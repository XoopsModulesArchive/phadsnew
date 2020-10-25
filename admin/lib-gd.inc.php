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

// Define defaults
$phpAds_GDImageFormat = '';

/*********************************************************/
/* Determine the image format supported by GD            */
/*********************************************************/

function phpAds_GDImageFormat()
{
    global $phpAds_config;

    global $phpAds_GDImageFormat;

    // Determine php version

    $phpversion = preg_replace('([^0-9])', '', phpversion());

    $phpversion /= pow(10, mb_strlen($phpversion) - 1);

    if ($phpversion >= 4.02 || ($phpversion >= 3.018 && $phpversion < 4.0)) {
        // Determine if GD is installed

        if (extension_loaded('gd')) {
            // Use ImageTypes() to dermine image format

            if (imagetypes() & IMG_PNG) {
                $phpAds_GDImageFormat = 'png';
            } elseif (imagetypes() & IMG_JPG) {
                $phpAds_GDImageFormat = 'jpeg';
            } elseif (imagetypes() & IMG_GIF) {
                $phpAds_GDImageFormat = 'gif';
            } else {
                $phpAds_GDImageFormat = 'none';
            }
        } else {
            $phpAds_GDImageFormat = 'none';
        }
    } elseif ($phpversion >= 4) {
        // No way to determine image format
        $phpAds_GDImageFormat = 'gif'; // assume gif?
    } else {
        // Use Function_Exists to determine image format

        if (function_exists('imagepng')) {
            $phpAds_GDImageFormat = 'png';
        } elseif (function_exists('imagejpeg')) {
            $phpAds_GDImageFormat = 'jpeg';
        } elseif (function_exists('imagegif')) {
            $phpAds_GDImageFormat = 'gif';
        } else {
            $phpAds_GDImageFormat = 'none';
        }
    }

    // Override detected GD foramt

    if (isset($phpAds_config['override_gd_imageformat']) && '' != $phpAds_config['override_gd_imageformat']) {
        $phpAds_GDImageFormat = $phpAds_config['override_gd_imageformat'];
    }

    return ($phpAds_GDImageFormat);
}

/*********************************************************/
/* Send the correct Content-type header                  */
/*********************************************************/

function phpAds_GDContentType()
{
    global $phpAds_GDImageFormat;

    if ('' == $phpAds_GDImageFormat) {
        $phpAds_GDImageFormat = phpAds_GDImageFormat();
    }

    header("Content-type: $phpAds_GDImageFormat");
}

/*********************************************************/
/* Send the image to the browser in the correct format   */
/*********************************************************/

function phpAds_GDShowImage($im)
{
    global $phpAds_GDImageFormat;

    if ('' == $phpAds_GDImageFormat) {
        $phpAds_GDImageFormat = phpAds_GDImageFormat();
    }

    switch ($phpAds_GDImageFormat) {
        case 'gif':
            imagegif($im);
            break;
        case 'jpeg':
            imagejpeg($im);
            break;
        case 'png':
            imagepng($im);
            break;
        default:
            break;    // No GD installed
    }
}
