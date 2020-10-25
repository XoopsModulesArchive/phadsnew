<?php

// $Revision: 2.1.2.7 $

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

$phpAds_settings_write_cache = [];
$phpAds_settings_update_cache = [];

$phpAds_configFilepath = phpAds_path . '/config.inc.php';

/*********************************************************/
/* Public: Determine if the config file is writable      */
/*********************************************************/

function phpAds_isConfigWritable()
{
    global $phpAds_configFilepath;

    return (@fclose(@fopen($phpAds_configFilepath, 'ab')));
}

/*********************************************************/
/* Public: Edit a setting                                */
/*********************************************************/

function phpAds_SettingsWriteAdd($key, $value)
{
    global $phpAds_settings_write_cache;

    $phpAds_settings_write_cache[$key] = $value;

    return true;
}

/*********************************************************/
/* Public: Store all edited settings                     */
/*********************************************************/

function phpAds_SettingsWriteFlush()
{
    global $phpAds_config;

    global $phpAds_settings_information, $phpAds_settings_write_cache;

    $sql = [];

    $config_inc = [];

    while (list($k, $v) = each($phpAds_settings_write_cache)) {
        $k_sql = $phpAds_settings_information[$k]['sql'];

        $k_type = $phpAds_settings_information[$k]['type'];

        if ($k_sql) {
            if ('boolean' == $k_type) {
                $v = $v ? 't' : 'f';
            }

            $sql[] = $k . " = '" . $v . "'";
        } else {
            if ('boolean' == $k_type) {
                $v = $v ? true : false;
            } elseif ('array' != $k_type) {
                $v = stripslashes($v);
            }

            $config_inc[] = [
                $k,
                $v,
                $k_type,
            ];
        }
    }

    if (count($sql)) {
        $query = 'UPDATE ' . $phpAds_config['tbl_config'] . ' SET ' . implode(', ', $sql);

        $res = @phpAds_dbQuery($query);

        if (@phpAds_dbAffectedRows() < 1) {
            $query = 'INSERT INTO ' . $phpAds_config['tbl_config'] . ' SET ' . implode(', ', $sql);

            @phpAds_dbQuery($query);
        }
    }

    if (count($config_inc)) {
        if (!phpAds_ConfigFilePrepare()) {
            return false;
        }

        while (list(, $v) = each($config_inc)) {
            phpAds_ConfigFileSet($v[0], $v[1], $v[2]);
        }

        return phpAds_ConfigFileFlush();
    }

    return true;
}

/*********************************************************/
/* Public: Clear the config file                         */
/*********************************************************/

function phpAds_ConfigFileClear()
{
    global $phpAds_configFilepath;

    $config = @fopen($phpAds_configFilepath, 'wb');

    $template = @fopen(phpAds_path . '/libraries/defaults/config.template.php', 'rb');

    if ($config && $template) {
        // Write the contents of the template to the config file

        @fwrite($config, @fread($template, filesize(phpAds_path . '/libraries/defaults/config.template.php')));

        @fclose($template);

        @fclose($config);
    }
}

/*********************************************************/
/* Public: Import settings from the config file          */
/*********************************************************/

function phpAds_ConfigFileUpdatePrepare()
{
    global $phpAds_configFilepath;

    global $phpAds_settings_information, $phpAds_settings_update_cache;

    global $phpAds_config, $HTTP_SERVER_VARS;

    if ($confighandle = @fopen($phpAds_configFilepath, 'rb')) {
        // Read old config file into buffer

        $buffer = @fread($confighandle, filesize($phpAds_configFilepath));

        @fclose($confighandle);

        // Determine config file format

        if (preg_match("phpAds_config\[", $buffer)) {
            // Post configmanager

            while (eregi("\n.phpAds_config\['([^']*)'\]([^;]*);", $buffer, $regs)) {
                if (isset($phpAds_settings_information[$regs[1]])) {
                    // Set variable name to lowercase

                    $regs[1] = mb_strtolower($regs[1]);

                    // Remove 'From' header from admin_email_headers

                    if ('admin_email_headers' == $regs[1]) {
                        $regs[2] = preg_replace('From: .*\n', '', $regs[2]);
                    }

                    // Don't trust url prefix, because the update might

                    // occur in a different directory as the original installation

                    if ('url_prefix' == $regs[1] && isset($HTTP_SERVER_VARS['HTTP_HOST'])) {
                        $regs[2] = ' = \'' . mb_strtolower(
                            eregi_replace(
                                    '^([a-z]+)/.*$',
                                    '\\1://',
                                    $HTTP_SERVER_VARS['SERVER_PROTOCOL']
                                )
                        ) . $HTTP_SERVER_VARS['HTTP_HOST'] . preg_replace("/admin/upgrade.php(\?.*)?$", '', $HTTP_SERVER_VARS['PHP_SELF']) . '\'';
                    }

                    @eval('$' . 'value ' . $regs[2] . ';');

                    // Update geotargeting type if needed

                    if ('geotracking_type' == $regs[1] && is_numeric($value)) {
                        switch ($value) {
                            case '1':
                                $value = 'ip2country';
                                break;
                            case '2':
                                $value = 'geoip';
                                break;
                            case '3':
                                $value = 'mod_geoip';
                                break;
                            default:
                                $value = '';
                                break;
                        }
                    }

                    // Force the type of the setting

                    if ('string' == $phpAds_settings_information[$regs[1]]['type']) {
                        // Add slashes because SettingsWriteFlush is designed to

                        // work with variables passed through magic_quotes_gpc

                        $value = addslashes($value);
                    } else {
                        settype($value, $phpAds_settings_information[$regs[1]]['type']);
                    }

                    $phpAds_settings_update_cache[$regs[1]] = $value;
                }

                $buffer = str_replace($regs[0], '', $buffer);
            }
        } else {
            // Pre configmanager

            while (eregi("\n.phpAds_([a-z0-9_]*)[^=]*([^;]*);", $buffer, $regs)) {
                // Check for renamed settings

                switch ($regs[1]) {
                    case 'hostname':
                        $regs[1] = 'dbhost';
                        break;
                    case 'mysqluser':
                        $regs[1] = 'dbuser';
                        break;
                    case 'pgsqluser':
                        $regs[1] = 'dbuser';
                        break;
                    case 'mysqlpassword':
                        $regs[1] = 'dbpassword';
                        break;
                    case 'pgsqlpassword':
                        $regs[1] = 'dbpassword';
                        break;
                    case 'db':
                        $regs[1] = 'dbname';
                        break;
                    case 'random_retrieve':
                        $regs[1] = 'retrieval_method';
                        break;
                }

                // Set variable name to lowercase

                $regs[1] = mb_strtolower($regs[1]);

                if (isset($phpAds_settings_information[$regs[1]])) {
                    // Remove 'From' header from admin_email_headers

                    if ('admin_email_headers' == $regs[1]) {
                        $regs[2] = preg_replace('From: .*\n', '', $regs[2]);
                    }

                    // Empty name if left to default value

                    if ('name' == $regs[1] && preg_match("[\"'](phpPgAds|phpAdsNew)[\"']", $regs[2])) {
                        $regs[2] = ' = ""';
                    }

                    // Remove default values

                    if ('type_web_dir' == $regs[1] && false !== mb_strpos($regs[2], '/home/myname/www/ads')) {
                        $regs[2] = ' = ""';
                    }

                    if ('type_web_ftp' == $regs[1] && false !== mb_strpos($regs[2], 'ftp://user:password@ftp.myname.com/ads')) {
                        $regs[2] = ' = ""';
                    }

                    if ('type_web_url' == $regs[1] && false !== mb_strpos($regs[2], 'http://www.myname.com/ads')) {
                        $regs[2] = ' = ""';
                    }

                    // Don't trust url prefix, because the update might

                    // occur in a different directory as the original installation

                    if ('url_prefix' == $regs[1] && isset($HTTP_SERVER_VARS['HTTP_HOST'])) {
                        $regs[2] = ' = \'' . mb_strtolower(
                            eregi_replace(
                                    '^([a-z]+)/.*$',
                                    '\\1://',
                                    $HTTP_SERVER_VARS['SERVER_PROTOCOL']
                                )
                        ) . $HTTP_SERVER_VARS['HTTP_HOST'] . preg_replace("/admin/upgrade.php(\?.*)?$", '', $HTTP_SERVER_VARS['REQUEST_URI']) . '\'';
                    }

                    // Parse variables inside assignments

                    while (preg_match('\$phpAds_([a-zA-Z0-9_]+)', $regs[2], $varregs)) {
                        $regs[2] = str_replace(
                            $varregs[0],
                            $phpAds_settings_update_cache[$varregs[1]] ?? '',
                            $regs[2]
                        );
                    }

                    @eval('$' . 'value ' . $regs[2] . ';');

                    if ('string' == $phpAds_settings_information[$regs[1]]['type']) {
                        // Update administrator password to its md5 value,

                        // because the updater function works only if the password

                        // is already saved on the db

                        if ('admin_pw' == $regs[1]) {
                            $value = md5($value);
                        }

                        // Add slashes because SettingsWriteFlush is designed to

                        // work with variables passed through magic_quotes_gpc

                        $value = addslashes($value);
                    } else {
                        settype($value, $phpAds_settings_information[$regs[1]]['type']);
                    }

                    $phpAds_settings_update_cache[$regs[1]] = $value;
                }

                $buffer = str_replace($regs[0], '', $buffer);
            }
        }

        // Check if we need to guess a table prefix for existing tables

        if (!isset($phpAds_settings_update_cache['table_prefix'])) {
            if (preg_match('^(.*)clients$', $phpAds_settings_update_cache['tbl_clients'], $match)) {
                // Overwrite default table prefix

                $phpAds_settings_update_cache['table_prefix'] = $match[1];
            } else {
                // Not found (translated table name?)

                // Create a random prefix

                mt_srand((float)microtime() * 1000000);

                $phpAds_settings_update_cache['table_prefix'] = sprintf('p%05d_', random_int(0, 99999));
            }
        }

        // Change names according to prefix for newly added tables

        reset($phpAds_config);

        while (list($k, ) = each($phpAds_config)) {
            if ('tbl_' == mb_substr($k, 0, 4)) {
                if (!isset($phpAds_settings_update_cache[$k])) {
                    $phpAds_settings_update_cache[$k] = $phpAds_settings_update_cache['table_prefix'] . mb_substr($k, 4);
                }
            }
        }

        reset($phpAds_config);

        return (true);
    }

    return (false);
}

function phpAds_ConfigFileUpdateFlush()
{
    global $phpAds_settings_update_cache;

    global $phpAds_settings_information;

    for (
        reset($phpAds_settings_update_cache); $key = key($phpAds_settings_update_cache); next($phpAds_settings_update_cache)
    ) {
        phpAds_SettingsWriteAdd($key, $phpAds_settings_update_cache[$key]);
    }

    // Before we start writing all the settings

    // start with a clean config file to make

    // sure we always have the latest version

    phpAds_ConfigFileClear();

    // Now write all the settings back to the

    // clean config file

    return phpAds_SettingsWriteFlush();
}

function phpAds_ConfigFileUpdateExport()
{
    global $phpAds_config;

    global $phpAds_settings_update_cache;

    for (
        reset($phpAds_settings_update_cache); $key = key($phpAds_settings_update_cache); next($phpAds_settings_update_cache)
    ) {
        // Overwrite existing values

        $phpAds_config[$key] = $phpAds_settings_update_cache[$key];
    }
}

/*********************************************************/
/* Private: Read the config file and start editing       */
/*********************************************************/

function phpAds_ConfigFilePrepare()
{
    global $phpAds_configBuffer, $phpAds_configFilepath;

    if (phpAds_isConfigWritable()) {
        if ($confighandle = @fopen($phpAds_configFilepath, 'rb')) {
            $phpAds_configBuffer = @fread($confighandle, filesize($phpAds_configFilepath));

            @fclose($confighandle);

            return (true);
        }

        return (false);
    }

    return (false);
}

/*********************************************************/
/* Private: Edit a setting                               */
/*********************************************************/

function phpAds_ConfigFileSet($key, $value, $type)
{
    global $phpAds_configBuffer;

    // Prepare value

    if ('array' == $type && is_array($value)) {
        reset($value);

        while (list($akey, $aval) = each($value)) {
            if (is_string($aval) && '' != $aval) {
                $value[$akey] = "'" . str_replace("'", "\\'", $aval) . "'";
            }
        }

        $value = 'array (' . implode(',', $value) . ')';
    } elseif ('string' == $type) {
        $value = "'" . str_replace("'", "\\'", $value) . "'";
    } elseif ('boolean' == $type) {
        $value = ($value ? 'true' : 'false');
    }

    if (preg_match(".phpAds_config\['" . $key . "'\][^=]*=[^\n]*;([\n|\r|\s|\t])", $phpAds_configBuffer, $regs)) {
        $phpAds_configBuffer = str_replace($regs[0], "\$phpAds_config['" . $key . "'] = " . $value . ';' . $regs[1], $phpAds_configBuffer);
    }
}

/*********************************************************/
/* Private: Write edited config file                     */
/*********************************************************/

function phpAds_ConfigFileFlush()
{
    global $phpAds_configBuffer, $phpAds_configFilepath;

    if ('' != $phpAds_configBuffer) {
        if ($confighandle = @fopen($phpAds_configFilepath, 'wb')) {
            $result = @fwrite($confighandle, $phpAds_configBuffer);

            @fclose($confighandle);

            return $result;
        }

        return (false);
    }

    return (false);
}
?>
