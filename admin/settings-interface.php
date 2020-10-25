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

// Register input variables
phpAds_registerGlobal('name', 'my_header', 'my_footer', 'client_welcome', 'client_welcome_msg', 'content_gzip_compression');

// Security check
phpAds_checkAccess(phpAds_Admin);

$errormessage = [];
$sql = [];

if (isset($_POST) && count($_POST)) {
    if (isset($name)) {
        phpAds_SettingsWriteAdd('name', $name);
    }

    if (isset($my_header)) {
        if (file_exists($my_header) || '' == $my_header) {
            phpAds_SettingsWriteAdd('my_header', $my_header);
        } else {
            $errormessage[0][] = $strMyHeaderError;
        }
    }

    if (isset($my_footer)) {
        if (file_exists($my_footer) || '' == $my_footer) {
            phpAds_SettingsWriteAdd('my_footer', $my_footer);
        } else {
            $errormessage[0][] = $strMyFooterError;
        }
    }

    phpAds_SettingsWriteAdd('content_gzip_compression', isset($content_gzip_compression));

    phpAds_SettingsWriteAdd('client_welcome', isset($client_welcome));

    if (isset($client_welcome_msg)) {
        phpAds_SettingsWriteAdd('client_welcome_msg', $client_welcome_msg);
    }

    if (!count($errormessage)) {
        if (phpAds_SettingsWriteFlush()) {
            header('Location: settings-defaults.php');

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
phpAds_SettingsSelection('interface');

/*********************************************************/
/* Cache settings fields and get help HTML Code          */
/*********************************************************/

$settings = [
    [
        'text' => $strGeneralSettings,
'items' => [
            [
                'type' => 'text',
'name' => 'name',
'text' => $strAppName,
'size' => 35,
            ],
            [
                'type' => 'break',
            ],
            [
                'type' => 'text',
'name' => 'my_header',
'text' => $strMyHeader,
'size' => 35,
            ],
            [
                'type' => 'break',
            ],
            [
                'type' => 'text',
'name' => 'my_footer',
'text' => $strMyFooter,
'size' => 35,
            ],
            [
                'type' => 'break',
            ],
            [
                'type' => 'checkbox',
'name' => 'content_gzip_compression',
'text' => $strGzipContentCompression,
            ],
        ],
    ],
    [
        'text' => $strClientInterface,
'items' => [
            [
                'type' => 'checkbox',
'name' => 'client_welcome',
'text' => $strClientWelcomeEnabled,
            ],
            [
                'type' => 'break',
            ],
            [
                'type' => 'textarea',
'name' => 'client_welcome_msg',
'text' => $strClientWelcomeText,
'depends' => 'client_welcome==true',
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
