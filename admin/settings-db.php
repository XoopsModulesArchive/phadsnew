<?php

// $Revision: 2.5 $

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

// Include required files
include 'lib-settings.inc.php';

// Register input variables
phpAds_registerGlobal(
    'dbhost',
    'dbport',
    'dbuser',
    'dbpassword',
    'dbname',
    'persistent_connections',
    'insert_delayed',
    'compatibility_mode',
    'auto_clean_tables_vacuum'
);

// Security check
phpAds_checkAccess(phpAds_Admin);

$errormessage = [];
$sql = [];

if (isset($_POST) && count($_POST)) {
    if (isset($dbpassword) && preg_match('^\*+$', $dbpassword)) {
        $dbpassword = $phpAds_config['dbpassword'];
    }

    if (isset($dbhost) && isset($dbuser) && isset($dbpassword) && isset($dbname)) {
        phpAds_dbClose();

        unset($phpAds_db_link);

        $phpAds_config['dbhost'] = $dbhost;

        $phpAds_config['dbport'] = $dbport;

        $phpAds_config['dbuser'] = $dbuser;

        $phpAds_config['dbpassword'] = $dbpassword;

        $phpAds_config['dbname'] = $dbname;

        $phpAds_config['persistent_connections'] = isset($persistent_connections) ? true : false;

        if (!phpAds_dbConnect(true)) {
            $errormessage[0][] = $strCantConnectToDb;
        } else {
            phpAds_SettingsWriteAdd('dbname', $dbhost);

            phpAds_SettingsWriteAdd('dbport', $dbport);

            phpAds_SettingsWriteAdd('dbuser', $dbuser);

            phpAds_SettingsWriteAdd('dbpassword', $dbpassword);

            phpAds_SettingsWriteAdd('dbname', $dbname);

            phpAds_SettingsWriteAdd('persistent_connections', isset($persistent_connections));
        }
    }

    phpAds_SettingsWriteAdd('insert_delayed', isset($insert_delayed));

    phpAds_SettingsWriteAdd('compatibility_mode', isset($compatibility_mode));

    if (!count($errormessage)) {
        if (phpAds_SettingsWriteFlush()) {
            header('Location: settings-invocation.php');

            exit;
        }
    }
}

/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PrepareHelp();
phpAds_PageHeader('5.1');
phpAds_ShowSections(['5.1', '5.3', '5.4', '5.2']);
phpAds_SettingsSelection('db');

/*********************************************************/
/* Cache settings fields and get help HTML Code          */
/*********************************************************/

$settings = [
    [
        'text' => $strDatabaseServer,
'items' => [
            [
                'type' => 'text',
'name' => 'dbhost',
'text' => $strDbHost,
'req' => true,
            ],
            [
                'type' => 'break',
            ],
            [
                'type' => 'text',
'name' => 'dbport',
'text' => $strDbPort,
'req' => true,
            ],
            [
                'type' => 'break',
            ],
            [
                'type' => 'text',
'name' => 'dbuser',
'text' => $strDbUser,
'req' => true,
            ],
            [
                'type' => 'break',
            ],
            [
                'type' => 'password',
'name' => 'dbpassword',
'text' => $strDbPassword,
'req' => true,
            ],
            [
                'type' => 'break',
            ],
            [
                'type' => 'text',
'name' => 'dbname',
'text' => $strDbName,
'req' => true,
            ],
        ],
    ],
    [
        'text' => $strDatabaseOptimalisations,
'items' => [
            [
                'type' => 'checkbox',
'name' => 'persistent_connections',
'text' => $strPersistentConnections,
            ],
            [
                'type' => 'checkbox',
'name' => 'insert_delayed',
'text' => $strInsertDelayed,
'visible' => 'phpAdsNew' == $phpAds_productname && 'MYISAM' == $phpAds_config['table_type'],
            ],
            [
                'type' => 'checkbox',
'name' => 'compatibility_mode',
'text' => $strCompatibilityMode,
'visible' => 'phpAdsNew' == $phpAds_productname,
            ],
            [
                'type' => 'checkbox',
'name' => 'auto_clean_tables_vacuum',
'text' => $strAutoCleanVacuum,
'visible' => 'phpPgAds' == $phpAds_productname,
            ],
        ],
    ],
];

/*********************************************************/
/* Main code                                             */
/*********************************************************/

phpAds_ShowSettings($settings, $errormessage);

/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();
