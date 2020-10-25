<?php

// $Revision: 2.2.2.3 $

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

// Include config file and check need to upgrade
require '../config.inc.php';

// Figure out our location
if (!defined('phpAds_path')) {
    if (mb_strlen(__FILE__) > mb_strlen(basename(__FILE__))) {
        define('phpAds_path', preg_replace('[/\\\\]admin[/\\\\][^/\\\\]+$', '', __FILE__));
    } else {
        define('phpAds_path', '..');
    }
}

if (!defined('phpAds_installed')) {
    // Old style configuration present

    header('Location: upgrade.php');

    exit;
} elseif (!phpAds_installed) {
    // Post configmanager, but not installed -> install

    header('Location: install.php');

    exit;
}

// Include required files
include '../libraries/lib-io.inc.php';
include '../libraries/lib-db.inc.php';
include '../libraries/lib-dbconfig.inc.php';
include 'lib-gui.inc.php';
include 'lib-permissions.inc.php';
include '../libraries/lib-userlog.inc.php';

// Open the database connection
$link = phpAds_dbConnect();
if (!$link) {
    // This text isn't translated, because if it is shown the language files are not yet loaded

    phpAds_Die(
        'A fatal error occurred',
        $phpAds_productname . " can't connect to the database.
				Because of this it isn't possible to use the administrator interface. The delivery
				of banners might also be affected. Possible reasons for the problem are:
				<ul><li>The database server isn't functioning at the moment</li>
				<li>The location of the database server has changed</li>
				<li>The username or password used to contact the database server are not correct</li>
				</ul>"
    );
}

// Load settings from the database
phpAds_LoadDbConfig();

if (!isset($phpAds_config['config_version'])
    || $phpAds_version > $phpAds_config['config_version']) {
    // Post configmanager, but not up to date -> update

    header('Location: upgrade.php');

    exit;
}

// Check for SLL requirements
if ($phpAds_config['ui_forcessl']
    && 443 != $HTTP_SERVER_VARS['SERVER_PORT']) {
    header('Location: https://' . $HTTP_SERVER_VARS['SERVER_NAME'] . $HTTP_SERVER_VARS['PHP_SELF']);

    exit;
}

// Adjust url_prefix if SLL is used
if (443 == $HTTP_SERVER_VARS['SERVER_PORT']) {
    $phpAds_config['url_prefix'] = str_replace('http://', 'https://', $phpAds_config['url_prefix']);
}

// First thing to do is clear the $Session variable to
// prevent users from pretending to be logged in.
unset($Session);

// Authorize the user
phpAds_Start();

// Load language strings
@include phpAds_path . '/language/english/default.lang.php';
if ('english' != $phpAds_config['language'] && file_exists(phpAds_path . '/language/' . $phpAds_config['language'] . '/default.lang.php')) {
    @include phpAds_path . '/language/' . $phpAds_config['language'] . '/default.lang.php';
}

// Register variables
phpAds_registerGlobal(
    'bannerid',
    'campaignid',
    'clientid',
    'zoneid',
    'affiliateid',
    'userlogid',
    'day'
);

// Check for missing required parameters
phpAds_checkIds();

// Setup navigation
$phpAds_nav = [
    'admin' => [
        '2' => ['stats-global-client.php' => $strStats],
'2.1' => ['stats-global-client.php' => $strClientsAndCampaigns],
'2.1.1' => ["stats-client-history.php?clientid=$clientid" => $strClientHistory],
'2.1.1.1' => ["stats-client-daily.php?clientid=$clientid&day=$day" => $strDailyStats],
'2.1.1.2' => ["stats-client-daily-hosts.php?clientid=$clientid&day=$day" => $strHosts],
'2.1.2' => ["stats-client-campaigns.php?clientid=$clientid" => $strCampaignOverview],
'2.1.2.1' => ["stats-campaign-history.php?clientid=$clientid&campaignid=$campaignid" => $strCampaignHistory],
'2.1.2.1.1' => ["stats-campaign-daily.php?clientid=$clientid&campaignid=$campaignid&day=$day" => $strDailyStats],
'2.1.2.1.2' => ["stats-campaign-daily-hosts.php?clientid=$clientid&campaignid=$campaignid&day=$day" => $strHosts],
'2.1.2.2' => ["stats-campaign-banners.php?clientid=$clientid&campaignid=$campaignid" => $strBannerOverview],
'2.1.2.2.1' => ["stats-banner-history.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $strBannerHistory],
'2.1.2.2.1.1' => ["stats-banner-daily.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid&day=$day" => $strDailyStats],
'2.1.2.2.1.2' => ["stats-banner-daily-hosts.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid&day=$day" => $strHosts],
'2.1.2.2.2' => ["stats-banner-affiliates.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $strDistribution],
'2.1.2.3' => ["stats-campaign-target.php?clientid=$clientid&campaignid=$campaignid" => $strTargetStats],
'2.2' => ['stats-global-history.php' => $strGlobalHistory],
'2.2.1' => ["stats-global-daily.php?day=$day" => $strDailyStats],
'2.2.2' => ["stats-global-daily-hosts.php?day=$day" => $strHosts],
'2.4' => ['stats-global-affiliates.php' => $strAffiliatesAndZones],
'2.4.1' => ["stats-affiliate-history.php?affiliateid=$affiliateid" => $strAffiliateHistory],
'2.4.1.1' => ["stats-affiliate-daily.php?affiliateid=$affiliateid&day=$day" => $strDailyStats],
'2.4.1.2' => ["stats-affiliate-daily-hosts.php?affiliateid=$affiliateid&day=$day" => $strHosts],
'2.4.2' => ["stats-affiliate-zones.php?affiliateid=$affiliateid" => $strZoneOverview],
'2.4.2.1' => ["stats-zone-history.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strZoneHistory],
'2.4.2.1.1' => ["stats-zone-daily.php?affiliateid=$affiliateid&zoneid=$zoneid&day=$day" => $strDailyStats],
'2.4.2.1.2' => ["stats-zone-daily-hosts.php?affiliateid=$affiliateid&zoneid=$zoneid&day=$day" => $strHosts],
'2.4.2.2' => ["stats-zone-linkedbanners.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strLinkedBannersOverview],
'2.4.2.2.1' => ["stats-linkedbanner-history.php?affiliateid=$affiliateid&zoneid=$zoneid&bannerid=$bannerid" => $strLinkedBannerHistory],
'2.5' => ['stats-global-misc.php' => $strMiscellaneous],
'3' => ['report-index.php' => $strReports],
'4' => ['client-index.php' => $strAdminstration],
'4.1' => ['client-index.php' => $strClientsAndCampaigns],
'4.1.1' => ['client-edit.php' => $strAddClient],
'4.1.2' => ["client-edit.php?clientid=$clientid" => $strClientProperties],
'4.1.3' => ["client-campaigns.php?clientid=$clientid" => $strCampaignOverview],
'4.1.3.1' => ["campaign-edit.php?clientid=$clientid" => $strAddCampaign],
'4.1.3.2' => ["campaign-edit.php?clientid=$clientid&campaignid=$campaignid" => $strCampaignProperties],
'4.1.3.3' => ["campaign-zone.php?clientid=$clientid&campaignid=$campaignid" => $strLinkedZones],
'4.1.3.4' => ["campaign-banners.php?clientid=$clientid&campaignid=$campaignid" => $strBannerOverview],
'4.1.3.4.1' => ["banner-edit.php?clientid=$clientid&campaignid=$campaignid" => $strAddBanner],
'4.1.3.4.2' => ["banner-edit.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $strBannerProperties],
'4.1.3.4.3' => ["banner-acl.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $strModifyBannerAcl],
'4.1.3.4.4' => ["banner-zone.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $strLinkedZones],
'4.1.3.4.5' => ["banner-swf.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $strConvertSWFLinks],
'4.1.3.4.6' => ["banner-append.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $strAppendOthers],
'4.2' => ['affiliate-index.php' => $strAffiliatesAndZones],
'4.2.1' => ['affiliate-edit.php' => $strAddNewAffiliate],
'4.2.2' => ["affiliate-edit.php?affiliateid=$affiliateid" => $strAffiliateProperties],
'4.2.3' => ["affiliate-zones.php?affiliateid=$affiliateid" => $strZoneOverview],
'4.2.3.1' => ["zone-edit.php?affiliateid=$affiliateid" => $strAddNewZone],
'4.2.3.2' => ["zone-edit.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strZoneProperties],
'4.2.3.3' => ["zone-include.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strIncludedBanners],
'4.2.3.4' => ["zone-probability.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strProbability],
'4.2.3.5' => ["zone-invocation.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strInvocationcode],
'4.2.3.6' => ["zone-advanced.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strAdvanced],
'4.3' => ['admin-generate.php' => $strGenerateBannercode],
'5' => ['settings-index.php' => $strSettings],
'5.1' => ['settings-db.php' => $strMainSettings],
'5.3' => ['maintenance-index.php' => $strMaintenance],
'5.2' => ['userlog-index.php' => $strUserLog],
'5.2.1' => ["userlog-details.php?userlogid=$userlogid" => $strUserLogDetails],
'5.4' => ['maintenance-updates.php' => $strProductUpdates],
    ],

    'client' => [
        '1' => ["stats-client-history.php?clientid=$clientid" => $strHome],
'1.1' => ["stats-client-history.php?clientid=$clientid" => $strClientHistory],
'1.1.1' => ["stats-client-daily.php?clientid=$clientid&day=$day" => $strDailyStats],
'1.1.2' => ["stats-client-daily-hosts.php?clientid=$clientid&day=$day" => $strHosts],
'1.2' => ["stats-client-campaigns.php?clientid=$clientid" => $strCampaignOverview],
'1.2.1' => ["stats-campaign-history.php?clientid=$clientid&campaignid=$campaignid" => $strCampaignHistory],
'1.2.1.1' => ["stats-campaign-daily.php?clientid=$clientid&campaignid=$campaignid&day=$day" => $strDailyStats],
'1.2.1.2' => ["stats-campaign-daily-hosts.php?clientid=$clientid&campaignid=$campaignid&day=$day" => $strHosts],
'1.2.2' => ["stats-campaign-banners.php?clientid=$clientid&campaignid=$campaignid" => $strBannerOverview],
'1.2.2.1' => ["stats-banner-history.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $strBannerHistory],
'1.2.2.1.1' => ["stats-banner-daily.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid&day=$day" => $strDailyStats],
'1.2.2.1.2' => ["stats-banner-daily-hosts.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid&day=$day" => $strHosts],
'1.2.2.2' => ["banner-edit.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $strBannerProperties],
'1.2.2.3' => ["banner-swf.php?clientid=$clientid&campaignid=$campaignid&bannerid=$bannerid" => $strConvertSWFLinks],
'1.2.3' => ["stats-campaign-target.php?clientid=$clientid&campaignid=$campaignid" => $strTargetStats],
'3' => ['report-index.php' => $strReports],
    ],

    'affiliate' => [
        '1' => ["stats-affiliate-zones.php?affiliateid=$affiliateid" => $strHome],
'1.1' => ["stats-affiliate-zones.php?affiliateid=$affiliateid" => $strZones],
'1.1.1' => ["stats-zone-history.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strZoneHistory],
'1.1.1.1' => ["stats-zone-daily.php?affiliateid=$affiliateid&zoneid=$zoneid&day=$day" => $strDailyStats],
'1.1.1.2' => ["stats-zone-daily-hosts.php?affiliateid=$affiliateid&zoneid=$zoneid&day=$day" => $strHosts],
'1.1.2' => ["stats-zone-linkedbanners.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strLinkedBannersOverview],
'1.1.2.1' => ["stats-linkedbanner-history.php?affiliateid=$affiliateid&zoneid=$zoneid&bannerid=$bannerid" => $strLinkedBannerHistory],
'1.2' => ["stats-affiliate-history.php?affiliateid=$affiliateid" => $strAffiliateHistory],
'1.2.1' => ["stats-affiliate-daily.php?affiliateid=$affiliateid&day=$day" => $strDailyStats],
'1.2.2' => ["stats-affiliate-daily-hosts.php?affiliateid=$affiliateid&day=$day" => $strHosts],
'3' => ['report-index.php' => $strReports],
'2' => ["affiliate-zones.php?affiliateid=$affiliateid" => $strAdminstration],
'2.1' => ["affiliate-zones.php?affiliateid=$affiliateid" => $strZones],
'2.1.1' => ["zone-edit.php?affiliateid=$affiliateid&zoneid=0" => $strAddZone],
'2.1.2' => ["zone-edit.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strModifyZone],
'2.1.3' => ["zone-include.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strIncludedBanners],
'2.1.4' => ["zone-probability.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strProbability],
'2.1.5' => ["zone-invocation.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strInvocationcode],
'2.1.6' => ["zone-advanced.php?affiliateid=$affiliateid&zoneid=$zoneid" => $strChains],
'2.2' => ["affiliate-edit.php?affiliateid=$affiliateid" => $strPreferences],
    ],
];

if (phpAds_isUser(phpAds_Client) && phpAds_isAllowed(phpAds_ModifyInfo)) {
    $phpAds_nav['client']['2'] = ['client-edit.php' => $strPreferences];
}
