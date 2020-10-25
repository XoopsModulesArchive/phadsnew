<?php

// $Revision: 2.0.2.3 $

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

/* PUBLIC FUNCTIONS */

$phpAds_geoPluginID = 'mod_geoip';

function phpAds_mod_geoip_getInfo()
{
    global $HTTP_SERVER_VARS;

    return ([
        'name' => 'MaxMind GeoIP (mod)',
'db' => false,
'country' => true,
'continent' => true,
'region' => isset($HTTP_SERVER_VARS['GEOIP_REGION']),
    ]);
}

function phpAds_mod_geoip_getGeo($addr, $db)
{
    // $addr and $db parameter is ignored and is here for API consistency only

    global $HTTP_SERVER_VARS;

    $country = $HTTP_SERVER_VARS['GEOIP_COUNTRY_CODE'] ?? '';

    $region = $HTTP_SERVER_VARS['GEOIP_REGION'] ?? false;

    if ('' != $country && '--' != $country) {
        // Get continent code

        @require_once phpAds_path . '/libraries/resources/res-continent.inc.php';

        $continent = $phpAds_continent[$country];

        return ([
            'country' => $country,
'continent' => $continent,
'region' => $region,
        ]);
    }

    return (false);
}
