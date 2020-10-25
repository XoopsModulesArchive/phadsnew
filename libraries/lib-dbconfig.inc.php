<?php

// $Revision: 2.6.2.12 $

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

// Set define to prevent duplicate include
define('LIBDBCONFIG_INCLUDED', true);

// Current phpAds version
$phpAds_version = 200.175;
$phpAds_version_readable = '2.0 RC 4.2';
$phpAds_productname = 'phpAdsNew';
$phpAds_producturl = 'www.phpadsnew.com';
$phpAds_dbmsname = 'MySQL';

$GLOBALS['phpAds_settings_information'] = [
    'dbhost' => ['type' => 'string', 'sql' => false],
'dbport' => ['type' => 'integer', 'sql' => false],
'dbuser' => ['type' => 'string', 'sql' => false],
'dbpassword' => ['type' => 'string', 'sql' => false],
'dbname' => ['type' => 'string', 'sql' => false],
'tbl_adclicks' => ['type' => 'string', 'sql' => false],
'tbl_adviews' => ['type' => 'string', 'sql' => false],
'tbl_adstats' => ['type' => 'string', 'sql' => false],
'tbl_banners' => ['type' => 'string', 'sql' => false],
'tbl_clients' => ['type' => 'string', 'sql' => false],
'tbl_session' => ['type' => 'string', 'sql' => false],
'tbl_acls' => ['type' => 'string', 'sql' => false],
'tbl_zones' => ['type' => 'string', 'sql' => false],
'tbl_affiliates' => ['type' => 'string', 'sql' => false],
'tbl_images' => ['type' => 'string', 'sql' => false],
'tbl_userlog' => ['type' => 'string', 'sql' => false],
'tbl_cache' => ['type' => 'string', 'sql' => false],
'tbl_targetstats' => ['type' => 'string', 'sql' => false],
'tbl_config' => ['type' => 'string', 'sql' => false],
'table_prefix' => ['type' => 'string', 'sql' => false],
'table_type' => ['type' => 'string', 'sql' => false],
'persistent_connections' => ['type' => 'boolean', 'sql' => false],
'insert_delayed' => ['type' => 'boolean', 'sql' => false],
'compatibility_mode' => ['type' => 'boolean', 'sql' => false],
'url_prefix' => ['type' => 'string', 'sql' => false],
'p3p_policies' => ['type' => 'boolean', 'sql' => false],
'p3p_compact_policy' => ['type' => 'string', 'sql' => false],
'p3p_policy_location' => ['type' => 'string', 'sql' => false],
'default_banner_url' => ['type' => 'string', 'sql' => false],
'default_banner_target' => ['type' => 'string', 'sql' => false],
'delivery_caching' => ['type' => 'string', 'sql' => false],
'type_html_auto' => ['type' => 'boolean', 'sql' => false],
'type_html_php' => ['type' => 'boolean', 'sql' => false],
'con_key' => ['type' => 'boolean', 'sql' => false],
'mult_key' => ['type' => 'boolean', 'sql' => false],
'acl' => ['type' => 'boolean', 'sql' => false],
'geotracking_type' => ['type' => 'string', 'sql' => false],
'geotracking_location' => ['type' => 'string', 'sql' => false],
'geotracking_stats' => ['type' => 'boolean', 'sql' => false],
'geotracking_cookie' => ['type' => 'boolean', 'sql' => false],
'compact_stats' => ['type' => 'boolean', 'sql' => false],
'log_beacon' => ['type' => 'boolean', 'sql' => false],
'log_adviews' => ['type' => 'boolean', 'sql' => false],
'block_adviews' => ['type' => 'integer', 'sql' => false],
'log_adclicks' => ['type' => 'boolean', 'sql' => false],
'block_adclicks' => ['type' => 'integer', 'sql' => false],
'reverse_lookup' => ['type' => 'boolean', 'sql' => false],
'ignore_hosts' => ['type' => 'array', 'sql' => false],
'warn_admin' => ['type' => 'boolean', 'sql' => false],
'warn_client' => ['type' => 'boolean', 'sql' => false],
'warn_limit' => ['type' => 'integer', 'sql' => false],
'proxy_lookup' => ['type' => 'boolean', 'sql' => false],
'ui_enabled' => ['type' => 'boolean', 'sql' => false],
'ui_forcessl' => ['type' => 'boolean', 'sql' => false],
'log_source' => ['type' => 'boolean', 'sql' => false],
'log_hostname' => ['type' => 'boolean', 'sql' => false],
'log_iponly' => ['type' => 'boolean', 'sql' => false],

    'my_header' => ['type' => 'string', 'sql' => true],
'my_footer' => ['type' => 'string', 'sql' => true],
'language' => ['type' => 'string', 'sql' => true],
'name' => ['type' => 'string', 'sql' => true],
'company_name' => ['type' => 'string', 'sql' => true],
'override_gd_imageformat' => ['type' => 'string', 'sql' => true],
'begin_of_week' => ['type' => 'integer', 'sql' => true],
'percentage_decimals' => ['type' => 'integer', 'sql' => true],
'default_banner_weight' => ['type' => 'integer', 'sql' => true],
'default_campaign_weight' => ['type' => 'integer', 'sql' => true],
'type_sql_allow' => ['type' => 'boolean', 'sql' => true],
'type_web_allow' => ['type' => 'boolean', 'sql' => true],
'type_url_allow' => ['type' => 'boolean', 'sql' => true],
'type_html_allow' => ['type' => 'boolean', 'sql' => true],
'type_txt_allow' => ['type' => 'boolean', 'sql' => true],
'type_web_mode' => ['type' => 'integer', 'sql' => true],
'type_web_dir' => ['type' => 'string', 'sql' => true],
'type_web_ftp' => ['type' => 'string', 'sql' => true],
'type_web_url' => ['type' => 'string', 'sql' => true],
'admin' => ['type' => 'string', 'sql' => true],
'admin_pw' => ['type' => 'string', 'sql' => true],
'admin_fullname' => ['type' => 'string', 'sql' => true],
'admin_email' => ['type' => 'string', 'sql' => true],
'admin_email_headers' => ['type' => 'string', 'sql' => true],
'admin_novice' => ['type' => 'boolean', 'sql' => true],
'client_welcome' => ['type' => 'boolean', 'sql' => true],
'client_welcome_msg' => ['type' => 'string', 'sql' => true],
'content_gzip_compression' => ['type' => 'boolean', 'sql' => true],
'userlog_email' => ['type' => 'boolean', 'sql' => true],
'userlog_priority' => ['type' => 'boolean', 'sql' => true],
'userlog_autoclean' => ['type' => 'boolean', 'sql' => true],
'gui_show_campaign_info' => ['type' => 'boolean', 'sql' => true],
'gui_show_campaign_preview' => ['type' => 'boolean', 'sql' => true],
'gui_show_banner_info' => ['type' => 'boolean', 'sql' => true],
'gui_show_banner_preview' => ['type' => 'boolean', 'sql' => true],
'gui_show_banner_html' => ['type' => 'boolean', 'sql' => true],
'gui_show_matching' => ['type' => 'boolean', 'sql' => true],
'gui_show_parents' => ['type' => 'boolean', 'sql' => true],
'gui_hide_inactive' => ['type' => 'boolean', 'sql' => true],
'gui_link_compact_limit' => ['type' => 'integer', 'sql' => true],
'qmail_patch' => ['type' => 'boolean', 'sql' => true],
'updates_frequency' => ['type' => 'integer', 'sql' => true],
'updates_last_seen' => ['type' => 'string', 'sql' => true],
'updates_timestamp' => ['type' => 'integer', 'sql' => true],
'allow_invocation_plain' => ['type' => 'boolean', 'sql' => true],
'allow_invocation_js' => ['type' => 'boolean', 'sql' => true],
'allow_invocation_frame' => ['type' => 'boolean', 'sql' => true],
'allow_invocation_xmlrpc' => ['type' => 'boolean', 'sql' => true],
'allow_invocation_local' => ['type' => 'boolean', 'sql' => true],
'allow_invocation_interstitial' => ['type' => 'boolean', 'sql' => true],
'allow_invocation_popup' => ['type' => 'boolean', 'sql' => true],
'auto_clean_tables' => ['type' => 'boolean', 'sql' => true],
'auto_clean_tables_interval' => ['type' => 'integer', 'sql' => true],
'auto_clean_userlog' => ['type' => 'boolean', 'sql' => true],
'auto_clean_userlog_interval' => ['type' => 'integer', 'sql' => true],
    //	'auto_clean_tables_vacuum' =>	array ('type' => 'boolean', 'sql' => true),

'autotarget_factor' => ['type' => 'double', 'sql' => true],
'config_version' => ['type' => 'string', 'sql' => true],
'maintenance_timestamp' => ['type' => 'integer', 'sql' => true],
];

/*********************************************************/
/* Load configuration from database                      */
/*********************************************************/

function phpAds_LoadDbConfig()
{
    global $phpAds_config, $phpAds_settings_information;

    if ((!empty($GLOBALS['phpAds_db_link']) || phpAds_dbConnect()) && isset($phpAds_config['tbl_config'])) {
        if ($res = phpAds_dbQuery('SELECT * FROM ' . $phpAds_config['tbl_config'] . ' WHERE configid = 0')) {
            if ($row = phpAds_dbFetchArray($res, 0)) {
                while (list($k, $v) = each($phpAds_settings_information)) {
                    if (!$v['sql'] || !isset($row[$k])) {
                        continue;
                    }

                    switch ($v['type']) {
                        case 'boolean':
                            $row[$k] = 't' == $row[$k];
                            break;
                        case 'integer':
                            $row[$k] = (int)$row[$k];
                            break;
                        case 'array':
                            $row[$k] = unserialize($row[$k]);
                            break;
                        case 'float':
                            $row[$k] = (float)$row[$k];
                            break;
                    }

                    $phpAds_config[$k] = $row[$k];
                }

                reset($phpAds_settings_information);

                return true;
            }
        }
    }

    return false;
}
