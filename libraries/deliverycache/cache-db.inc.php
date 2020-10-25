<?php

// $Revision: 2.0 $

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
define('LIBVIEWCACHE_INCLUDED', true);

function phpAds_cacheFetch($name)
{
    global $phpAds_config;

    $cacheres = phpAds_dbQuery('SELECT * FROM ' . $phpAds_config['tbl_cache'] . " WHERE cacheid='" . $name . "'");

    if ($cacherow = phpAds_dbFetchArray($cacheres)) {
        return (unserialize($cacherow['content']));
    }

    return false;
}

function phpAds_cacheStore($name, $cache)
{
    global $phpAds_config;

    $result = phpAds_dbQuery('UPDATE ' . $phpAds_config['tbl_cache'] . " SET content='" . addslashes(serialize($cache)) . "' WHERE cacheid='" . $name . "'");

    if (0 == phpAds_dbAffectedRows()) {
        $result = phpAds_dbQuery('INSERT INTO ' . $phpAds_config['tbl_cache'] . " SET cacheid='" . $name . "', content='" . addslashes(serialize($cache)) . "'");
    }
}

function phpAds_cacheDelete($name = '')
{
    global $phpAds_config;

    if ('' == $name) {
        $result = phpAds_dbQuery('DELETE FROM ' . $phpAds_config['tbl_cache']);
    } else {
        $result = phpAds_dbQuery('DELETE FROM ' . $phpAds_config['tbl_cache'] . " WHERE cacheid='" . $name . "'");
    }
}

function phpAds_cacheInfo()
{
    global $phpAds_config;

    $result = [];

    $cacheres = phpAds_dbQuery('SELECT * FROM ' . $phpAds_config['tbl_cache']);

    while (false !== ($cacherow = phpAds_dbFetchArray($cacheres))) {
        $result[$cacherow['cacheid']] = mb_strlen($cacherow['content']);
    }

    return ($result);
}
