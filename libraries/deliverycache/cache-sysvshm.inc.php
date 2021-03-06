<?php

// $Revision: 1.2 $

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

define('phpAds_shmopID', 0x2328);
define('phpAds_shmopIndexSize', 4096);
define('phpAds_shmopSegmentSize', 65536);

function phpAds_cacheFetch($name)
{
    // First read cache structure from shared memory

    $shm_id = shm_attach(phpAds_shmopID);

    if ($shm_id) {
        // Get the size of the structure

        $size = shm_get_var($shm_id, 1);

        $size = hexdec($size);

        if ($size > 0) {
            // Read the structure

            $structure = shm_get_var($shm_id, 1);

            shm_detach($shm_id);

            if (isset($structure[$name])) {
                $seg_id = shm_attach(phpAds_shmopID + $structure[$name]);

                if ($seg_id) {
                    // Get the size of the structure

                    $cache_size = shm_get_var($seg_id, 1);

                    $cache_size = hexdec($cache_size);

                    $cache_data = shm_get_var($seg_id, 0);

                    shm_detach($seg_id);

                    return ($cache_data);
                }

                return false;
            }

            return false;
        }

        shm_detach($shm_id);

        return false;
    }

    return false;
}

function phpAds_cacheStore($name, $cache)
{
    // First read cache structure from shared memory

    $struc_id = shm_attach(phpAds_shmopID, phpAds_shmopIndexSize, 0644);

    if ($struc_id) {
        // Get the size of the structure

        $size = shm_get_var($struc_id, 1);

        $size = hexdec($size);

        // Fetch the structure

        if ($size > 0) {
            $structure = shm_get_var($struc_id, 0);
        } else {
            $structure = [];
        }

        // Get highest segment id

        $highest = 0;

        reset($structure);

        while (list($k, $v) = each($structure)) {
            if ($v > $highest) {
                $highest = $v;
            }
        }

        // Get lowest unused segment id

        for ($i = 1; $i <= $highest + 1; $i++) {
            if (!in_array($i, $structure, true)) {
                $segment = $i;

                break;
            }
        }

        $delete = $structure[$name] ?? false;

        $seg_id = shm_attach(phpAds_shmopID + $segment, phpAds_shmopSegmentSize, 0644);

        if ($seg_id) {
            // Store data

            $seg_data = $cache;

            $seg_size = mb_strlen($seg_data);

            $seg_size = sprintf('%04X', $seg_size);

            shm_put_var($seg_id, 1, $seg_size);

            shm_put_var($seg_id, 0, $seg_data);

            shm_detach($seg_id);

            // Update structure

            $structure[$name] = $segment;

            // Store the structure

            $struc_data = $structure;

            $struc_size = mb_strlen($struc_data);

            $struc_size = sprintf('%04X', $struc_size);

            shm_put_var($struc_id, 1, $struc_size);

            shm_put_var($struc_id, 0, $struc_data);

            shm_detach($struc_id);

            // Delete old segment

            if ($delete) {
                $del_id = shm_attach(phpAds_shmopID + $delete);

                shm_remove($del_id);

                shm_detach($del_id);
            }

            return true;
        }

        shm_detach($struc_id);

        return false;
    }

    return false;
}

function phpAds_cacheDelete($name = '')
{
    // First read cache structure from shared memory

    $struc_id = shm_attach(phpAds_shmopID, phpAds_shmopIndexSize, 0644);

    if ($struc_id) {
        // Get the size of the structure

        $size = @shm_get_var($struc_id, 1);

        $size = hexdec($size);

        // Fetch the structure

        if ($size > 0) {
            $structure = shm_get_var($struc_id, 0);

        // $structure = unserialize($structure);
        } else {
            return false;
        }

        if ('' != $name && isset($structure[$name])) {
            $delete = $structure[$name];

            // Update structure

            unset($structure[$name]);

            // Store the structure

            $struc_data = $structure;

            $struc_size = mb_strlen($struc_data);

            $struc_size = sprintf('%04X', $struc_size);

            shm_put_var($struc_id, 1, $struc_size);

            shm_put_var($struc_id, 0, $struc_data);

            shm_detach($struc_id);

            // Delete old segment

            $del_id = shm_attach(phpAds_shmopID + $delete);

            shm_remove($del_id);

            shm_detach($del_id);

            return true;
        }

        if ('' == $name) {
            while (list($k, $v) = each($structure)) {
                // Delete old segment

                $del_id = shm_attach(phpAds_shmopID + $v);

                shm_remove($del_id);

                shm_detach($del_id);
            }

            $structure = [];

            // Store the structure

            $struc_data = $structure;

            $struc_size = mb_strlen($struc_data);

            $struc_size = sprintf('%04X', $struc_size);

            shm_put_var($struc_id, 1, $struc_size);

            shm_put_var($struc_id, 0, $struc_data);

            shm_detach($struc_id);

            return true;
        }
    }

    return false;
}

function phpAds_cacheInfo()
{
    // First read cache structure from shared memory

    $struc_id = shm_attach(phpAds_shmopID);

    if ($struc_id) {
        // Get the size of the structure

        $structure = @shm_get_var($struc_id, 0);

        shm_detach($struc_id);

        $result = [];

        while (list($k, $v) = each($structure)) {
            // attach to the current segment

            $info_id = shm_attach(phpAds_shmopID + $v);

            // Get the size of the structure

            $result[$k] = count(shm_get_var($info_id, 0));

            // detach from this element

            shm_detach($info_id);
        }

        return $result;
    }

    return false;
}
