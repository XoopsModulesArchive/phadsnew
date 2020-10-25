<?php

// $Revision: 2.3.2.3 $

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
define('LIBVIEWZONE_INCLUDED', true);

/*********************************************************/
/* Get a banner                                          */
/*********************************************************/

function phpAds_fetchBannerZone($remaining, $clientid, $context = 0, $source = '', $richmedia = true)
{
    global $phpAds_config, $HTTP_COOKIE_VARS;

    global $phpAds_followedChain;

    // Get first part, store second part

    $what = strtok($remaining, '|');

    $remaining = strtok('');

    $zoneid = mb_substr($what, 5);

    // Check if zone was already evaluated in the chain

    if (isset($phpAds_followedChain) && in_array($zoneid, $phpAds_followedChain, true)) {
        return ($remaining);
    }

    $phpAds_followedChain[] = $zoneid;

    // Get cache

    if (!defined('LIBVIEWCACHE_INCLUDED')) {
        @include phpAds_path . '/libraries/deliverycache/cache-' . $phpAds_config['delivery_caching'] . '.inc.php';
    }

    $cache = @phpAds_cacheFetch('what=zone:' . $zoneid);

    if (!$cache) {
        $zoneres = phpAds_dbQuery('SELECT * FROM ' . $phpAds_config['tbl_zones'] . " WHERE zoneid='" . $zoneid . "'");

        if ($zone = phpAds_dbFetchArray($zoneres)) {
            // No linked banners

            if ('' == $remaining) {
                $remaining = $zone['chain'];
            }

            if ('' == $zone['what']) {
                return ($remaining);
            }

            if (!defined('LIBVIEWQUERY_INCLUDED')) {
                include phpAds_path . '/libraries/lib-view-query.inc.php';
            }

            $precondition = '';

            // Size preconditions

            if ($zone['width'] > -1) {
                $precondition .= ' AND ' . $phpAds_config['tbl_banners'] . '.width = ' . $zone['width'] . ' ';
            }

            if ($zone['height'] > -1) {
                $precondition .= ' AND ' . $phpAds_config['tbl_banners'] . '.height = ' . $zone['height'] . ' ';
            }

            // Text Ads preconditions

            // Matching against the value instead of the constant phpAds_ZoneText (3).

            // Didn't want to include the whole lib-zones just for a constant

            if (3 == $zone['delivery']) {
                $precondition .= ' AND ' . $phpAds_config['tbl_banners'] . ".storagetype = 'txt' ";
            } else {
                $precondition .= ' AND ' . $phpAds_config['tbl_banners'] . ".storagetype <> 'txt' ";
            }

            $select = phpAds_buildQuery($zone['what'], false, $precondition);

            $res = phpAds_dbQuery($select);

            // Build array for further processing...

            $rows = [];

            $prioritysum = 0;

            while (false !== ($tmprow = phpAds_dbFetchArray($res))) {
                // weight of 0 disables the banner

                if ($tmprow['priority']) {
                    $prioritysum += $tmprow['priority'];

                    $rows[] = $tmprow;
                }
            }

            $cache = [
                $zone['zoneid'],
                $rows,
                $zone['what'],
                $prioritysum,
                $zone['chain'],
                $zone['prepend'],
                $zone['append'],
            ];

            phpAds_cacheStore('what=zone:' . $zone['zoneid'], $cache);

            // Unpack cache

            [$zoneid, $rows, $what, $prioritysum, $chain, $prepend, $append] = $cache;
        } else { // Zone not found
            return ($remaining);
        }
    } else {
        // Unpack cache

        [$zoneid, $rows, $what, $prioritysum, $chain, $prepend, $append] = $cache;

        if ('' == $remaining) {
            $remaining = $chain;
        }

        if (0 == count($rows)) {
            return ($remaining);
        }
    }

    // Build preconditions

    $excludeBannerID = [];

    $excludeCampaignID = [];

    $includeBannerID = [];

    $includeCampaignID = [];

    if (is_array($context)) {
        for ($i = 0, $iMax = count($context); $i < $iMax; $i++) {
            [$key, $value] = each($context[$i]);

            {
                $type = 'bannerid';
                $valueArray = explode(':', $value);

                if (1 == count($valueArray)) {
                    [$value] = $valueArray;
                } else {
                    [$type, $value] = $valueArray;
                }

                if ('bannerid' == $type) {
                    switch ($key) {
                        case '!=':
                            $excludeBannerID[$value] = true;
                            break;
                        case '==':
                            $includeBannerID[$value] = true;
                            break;
                    }
                }

                if ('campaignid' == $type) {
                    switch ($key) {
                        case '!=':
                            $excludeCampaignID[$value] = true;
                            break;
                        case '==':
                            $includeCampaignID[$value] = true;
                            break;
                    }
                }
            }
        }
    }

    $maxindex = count($rows);

    while ($prioritysum && count($rows)) {
        $low = 0;

        $high = 0;

        $ranweight = ($prioritysum > 1) ? random_int(0, $prioritysum - 1) : 0;

        for ($i = 0; $i < $maxindex; $i++) {
            if (is_array($rows[$i])) {
                $low = $high;

                $high += $rows[$i]['priority'];

                if ($high > $ranweight && $low <= $ranweight) {
                    $postconditionSucces = true;

                    // Excludelist banners

                    if (isset($excludeBannerID[$rows[$i]['bannerid']])) {
                        $postconditionSucces = false;
                    }

                    // Excludelist campaigns

                    if (true === $postconditionSucces
                        && isset($excludeCampaignID[$rows[$i]['clientid']])) {
                        $postconditionSucces = false;
                    }

                    // Includelist banners

                    if (true === $postconditionSucces
                        && count($includeBannerID)
                        && !isset($includeBannerID[$rows[$i]['bannerid']])) {
                        $postconditionSucces = false;
                    }

                    // Includelist campaigns

                    if (true === $postconditionSucces
                        && count($includeCampaignID)
                        && !isset($includeCampaignID[$rows[$i]['clientid']])) {
                        $postconditionSucces = false;
                    }

                    // HTML or Flash banners

                    if (true === $postconditionSucces
                        && false === $richmedia
                        && ('jpeg' != $rows[$i]['contenttype'] && 'gif' != $rows[$i]['contenttype'] && 'png' != $rows[$i]['contenttype'])) {
                        $postconditionSucces = false;
                    }

                    // Blocked

                    if (true === $postconditionSucces
                        && $rows[$i]['block'] > 0 && isset($HTTP_COOKIE_VARS['phpAds_blockAd'][$rows[$i]['bannerid']])
                        && $HTTP_COOKIE_VARS['phpAds_blockAd'][$rows[$i]['bannerid']] > time()) {
                        $postconditionSucces = false;
                    }

                    // Capped

                    if (true === $postconditionSucces
                        && $rows[$i]['capping'] > 0 && isset($HTTP_COOKIE_VARS['phpAds_capAd'][$rows[$i]['bannerid']])
                        && $HTTP_COOKIE_VARS['phpAds_capAd'][$rows[$i]['bannerid']] >= $rows[$i]['capping']) {
                        $postconditionSucces = false;
                    }

                    if (false === $postconditionSucces) {
                        // Failed one of the postconditions

                        // Delete this row and adjust $prioritysum

                        $prioritysum -= $rows[$i]['priority'];

                        $rows[$i] = '';

                        // Break out of the for loop to try again

                        break;
                    }

                    // Banner was not on exclude list

                    // and was on include list (if one existed)

                    // Now continue with ACL check

                    if ($phpAds_config['acl']) {
                        if (phpAds_aclCheck($rows[$i], $source)) {
                            $rows[$i]['zoneid'] = $zoneid;

                            $rows[$i]['append'] = $append;

                            $rows[$i]['prepend'] = $prepend;

                            return ($rows[$i]);
                        }

                        // Matched, but phpAds_aclCheck failed.

                        // Delete this row and adjust $prioritysum

                        $prioritysum -= $rows[$i]['priority'];

                        $rows[$i] = '';

                        // Break out of the for loop to try again

                        break;
                    }

                    // Don't check ACLs, found banner!

                    $rows[$i]['zoneid'] = $zoneid;

                    $rows[$i]['append'] = $append;

                    $rows[$i]['prepend'] = $prepend;

                    return ($rows[$i]);
                }
            }
        }
    }

    return ($remaining);
}
