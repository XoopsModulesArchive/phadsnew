<?php

// $Revision: 2.1.2.1 $

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
include 'lib-languages.inc.php';

// Register input variables
phpAds_registerGlobal(
    'admin',
    'pwold',
    'pw',
    'pw2',
    'admin_fullname',
    'admin_email',
    'company_name',
    'language',
    'updates_frequency',
    'admin_novice',
    'userlog_email',
    'userlog_priority',
    'userlog_autoclean'
);

// Security check
phpAds_checkAccess(phpAds_Admin);

$errormessage = [];
$sql = [];

if (isset($_POST) && count($_POST)) {
    if (isset($admin)) {
        if (!mb_strlen($admin)) {
            $errormessage[0][] = $strInvalidUsername;
        } elseif (phpAds_dbNumRows(phpAds_dbQuery('SELECT * FROM ' . $phpAds_config['tbl_clients'] . " WHERE LOWER(clientusername) = '" . mb_strtolower($admin) . "'"))) {
            $errormessage[0][] = $strDuplicateClientName;
        } elseif (phpAds_dbNumRows(phpAds_dbQuery('SELECT * FROM ' . $phpAds_config['tbl_affiliates'] . " WHERE LOWER(username) = '" . mb_strtolower($admin) . "'"))) {
            $errormessage[0][] = $strDuplicateClientName;
        } else {
            phpAds_SettingsWriteAdd('admin', $admin);
        }
    }

    if (isset($pwold) && mb_strlen($pwold)
        || isset($pw) && mb_strlen($pw)
        || isset($pw2) && mb_strlen($pw2)) {
        if (md5($pwold) != $phpAds_config['admin_pw']) {
            $errormessage[0][] = $strPasswordWrong;
        } elseif (!mb_strlen($pw) || mb_strstr('\\', $pw)) {
            $errormessage[0][] = $strInvalidPassword;
        } elseif (strcmp($pw, $pw2)) {
            $errormessage[0][] = $strNotSamePasswords;
        } else {
            $admin_pw = $pw;

            phpAds_SettingsWriteAdd('admin_pw', md5($admin_pw));
        }
    }

    if (isset($admin_fullname)) {
        phpAds_SettingsWriteAdd('admin_fullname', $admin_fullname);
    }

    if (isset($admin_email)) {
        phpAds_SettingsWriteAdd('admin_email', $admin_email);
    }

    if (isset($company_name)) {
        phpAds_SettingsWriteAdd('company_name', $company_name);
    }

    if (isset($language)) {
        phpAds_SettingsWriteAdd('language', $language);
    }

    if (isset($updates_frequency)) {
        phpAds_SettingsWriteAdd('updates_frequency', $updates_frequency);
    }

    phpAds_SettingsWriteAdd('admin_novice', isset($admin_novice));

    phpAds_SettingsWriteAdd('userlog_email', isset($userlog_email));

    phpAds_SettingsWriteAdd('userlog_priority', isset($userlog_priority));

    phpAds_SettingsWriteAdd('userlog_autoclean', isset($userlog_autoclean));

    if (!count($errormessage)) {
        if (phpAds_SettingsWriteFlush()) {
            header('Location: settings-interface.php');

            exit;
        }
    }
}

/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PrepareHelp();
if (isset($message)) {
    phpAds_ShowMessage($message);
}
phpAds_PageHeader('5.1');
phpAds_ShowSections(['5.1', '5.3', '5.4', '5.2']);
phpAds_SettingsSelection('admin');

/*********************************************************/
/* Cache settings fields and get help HTML Code          */
/*********************************************************/

$unique_users = [];

$res = phpAds_dbQuery('SELECT LOWER(clientusername) as used FROM ' . $phpAds_config['tbl_clients'] . " WHERE clientusername != ''");
while (false !== ($row = phpAds_dbFetchArray($res))) {
    $unique_users[] = $row['used'];
}

$res = phpAds_dbQuery('SELECT LOWER(username) as used FROM ' . $phpAds_config['tbl_affiliates'] . " WHERE username != ''");
while (false !== ($row = phpAds_dbFetchArray($res))) {
    $unique_users[] = $row['used'];
}

$settings = [
    [
        'text' => $strLoginCredentials,
'items' => [
            [
                'type' => 'text',
'name' => 'admin',
'text' => $strAdminUsername,
'check' => 'unique',
'unique' => $unique_users,
            ],
            [
                'type' => 'break',
            ],
            [
                'type' => 'password',
'name' => 'pwold',
'text' => $strOldPassword,
            ],
            [
                'type' => 'break',
            ],
            [
                'type' => 'password',
'name' => 'pw',
'text' => $strNewPassword,
'depends' => 'pwold!=""',
            ],
            [
                'type' => 'break',
            ],
            [
                'type' => 'password',
'name' => 'pw2',
'text' => $strRepeatPassword,
'depends' => 'pwold!=""',
'check' => 'compare:pw',
            ],
        ],
    ],
    [
        'text' => $strBasicInformation,
'items' => [
            [
                'type' => 'text',
'name' => 'admin_fullname',
'text' => $strAdminFullName,
'size' => 35,
            ],
            [
                'type' => 'break',
            ],
            [
                'type' => 'text',
'name' => 'admin_email',
'text' => $strAdminEmail,
'size' => 35,
'check' => 'email',
            ],
            [
                'type' => 'break',
            ],
            [
                'type' => 'text',
'name' => 'company_name',
'text' => $strCompanyName,
'size' => 35,
            ],
        ],
    ],
    [
        'text' => $strPreferences,
'items' => [
            [
                'type' => 'select',
'name' => 'language',
'text' => $strLanguage,
'items' => phpAds_AvailableLanguages(),
            ],
            [
                'type' => 'break',
            ],
            [
                'type' => 'select',
'name' => 'updates_frequency',
'text' => $strAdminCheckUpdates,
'items' => [
                    '0' => $strAdminCheckEveryLogin,
'1' => $strAdminCheckDaily,
'7' => $strAdminCheckWeekly,
'30' => $strAdminCheckMonthly,
'-1' => $strAdminCheckNever,
                ],
            ],
            [
                'type' => 'break',
            ],
            [
                'type' => 'checkbox',
'name' => 'admin_novice',
'text' => $strAdminNovice,
            ],
            [
                'type' => 'break',
            ],
            [
                'type' => 'checkbox',
'name' => 'userlog_email',
'text' => $strUserlogEmail,
            ],
            [
                'type' => 'checkbox',
'name' => 'userlog_priority',
'text' => $strUserlogPriority,
            ],
            [
                'type' => 'checkbox',
'name' => 'userlog_autoclean',
'text' => $strUserlogAutoClean,
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