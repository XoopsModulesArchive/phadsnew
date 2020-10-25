<?php

// $Revision: 2.3 $

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
    'allow_invocation_plain',
    'allow_invocation_js',
    'allow_invocation_frame',
    'allow_invocation_xmlrpc',
    'allow_invocation_local',
    'allow_invocation_interstitial',
    'allow_invocation_popup',
    'con_key',
    'mult_key',
    'acl',
    'delivery_caching',
    'p3p_policies',
    'p3p_compact_policy',
    'p3p_policy_location'
);

// Security check
phpAds_checkAccess(phpAds_Admin);

$errormessage = [];
$sql = [];

if (isset($_POST) && count($_POST)) {
    phpAds_SettingsWriteAdd('allow_invocation_plain', isset($allow_invocation_plain));

    phpAds_SettingsWriteAdd('allow_invocation_js', isset($allow_invocation_js));

    phpAds_SettingsWriteAdd('allow_invocation_frame', isset($allow_invocation_frame));

    phpAds_SettingsWriteAdd('allow_invocation_xmlrpc', isset($allow_invocation_xmlrpc));

    phpAds_SettingsWriteAdd('allow_invocation_local', isset($allow_invocation_local));

    phpAds_SettingsWriteAdd('allow_invocation_interstitial', isset($allow_invocation_interstitial));

    phpAds_SettingsWriteAdd('allow_invocation_popup', isset($allow_invocation_popup));

    if (isset($delivery_caching)) {
        phpAds_SettingsWriteAdd('delivery_caching', $delivery_caching);
    }

    phpAds_SettingsWriteAdd('acl', isset($acl));

    phpAds_SettingsWriteAdd('con_key', isset($con_key));

    phpAds_SettingsWriteAdd('mult_key', isset($mult_key));

    phpAds_SettingsWriteAdd('p3p_policies', isset($p3p_policies));

    if (isset($p3p_compact_policy)) {
        phpAds_SettingsWriteAdd('p3p_compact_policy', $p3p_compact_policy);
    }

    if (isset($p3p_policy_location)) {
        phpAds_SettingsWriteAdd('p3p_policy_location', $p3p_policy_location);
    }

    if (!count($errormessage)) {
        if (phpAds_SettingsWriteFlush()) {
            header('Location: settings-host.php');

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
phpAds_SettingsSelection('invocation');

/*********************************************************/
/* Cache settings fields and get help HTML Code          */
/*********************************************************/

// Determine delivery cache methods
$delivery_cache_methods['none'] = $strNone;
$delivery_cache_methods['db'] = $strCacheDatabase;

if ($fp = @fopen(phpAds_path . '/cache/available', 'wb')) {
    @fclose($fp);

    @unlink(phpAds_path . '/cache/available');

    $delivery_cache_methods['file'] = $strCacheFiles;
}

if (function_exists('shmop_open')) {
    $delivery_cache_methods['shm'] = $strCacheShmop . ' (' . $strExperimental . ')';
}

if (function_exists('shm_attach')) {
    $delivery_cache_methods['sysvshm'] = $strCacheSysvshm . ' (' . $strExperimental . ')';
}

$settings = [
    [
        'text' => $strDeliverySettings,
'items' => [
            [
                'type' => 'select',
'name' => 'delivery_caching',
'text' => $strCacheType,
'items' => $delivery_cache_methods,
            ],
            [
                'type' => 'break',
            ],
            [
                'type' => 'checkbox',
'name' => 'acl',
'text' => $strUseAcl,
            ],
            [
                'type' => 'break',
            ],
            [
                'type' => 'checkbox',
'name' => 'con_key',
'text' => $strUseConditionalKeys,
            ],
            [
                'type' => 'checkbox',
'name' => 'mult_key',
'text' => $strUseMultipleKeys,
            ],
        ],
    ],
    [
        'text' => $strAllowedInvocationTypes,
'items' => [
            [
                'type' => 'checkbox',
'name' => 'allow_invocation_plain',
'text' => $strAllowRemoteInvocation,
            ],
            [
                'type' => 'checkbox',
'name' => 'allow_invocation_js',
'text' => $strAllowRemoteJavascript,
            ],
            [
                'type' => 'checkbox',
'name' => 'allow_invocation_frame',
'text' => $strAllowRemoteFrames,
            ],
            [
                'type' => 'checkbox',
'name' => 'allow_invocation_xmlrpc',
'text' => $strAllowRemoteXMLRPC,
            ],
            [
                'type' => 'checkbox',
'name' => 'allow_invocation_local',
'text' => $strAllowLocalmode,
            ],
            [
                'type' => 'break',
            ],
            [
                'type' => 'checkbox',
'name' => 'allow_invocation_interstitial',
'text' => $strAllowInterstitial,
            ],
            [
                'type' => 'break',
            ],
            [
                'type' => 'checkbox',
'name' => 'allow_invocation_popup',
'text' => $strAllowPopups,
            ],
        ],
    ],
    [
        'text' => $strP3PSettings,
'items' => [
            [
                'type' => 'checkbox',
'name' => 'p3p_policies',
'text' => $strUseP3P,
            ],
            [
                'type' => 'break',
            ],
            [
                'type' => 'text',
'name' => 'p3p_compact_policy',
'text' => $strP3PCompactPolicy,
'size' => 35,
'depends' => 'p3p_policies==true',
            ],
            [
                'type' => 'break',
            ],
            [
                'type' => 'text',
'name' => 'p3p_policy_location',
'text' => $strP3PPolicyLocation,
'size' => 35,
'depends' => 'p3p_policies==true',
'check' => 'url',
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
