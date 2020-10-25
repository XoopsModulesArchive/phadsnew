<?php

// $Revision: 2.2.2.2 $

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
require 'lib-gdcolors.inc.php';
require 'lib-gd.inc.php';

/*********************************************************/
/* Create the legends                                    */
/*********************************************************/

function legend($im, $x, $y, $text, $fillcolor, $outlinecolor, $textcolor)
{
    imagefilledrectangle($im, $x, $y, $x + 10, $y + 10, $fillcolor);

    imagerectangle($im, $x, $y, $x + 10, $y + 10, $outlinecolor);

    imagestring($im, 2, $x + 15, $y, $text, $textcolor);
}

/*********************************************************/
/* Main code                                             */
/*********************************************************/

$i = 0;
$totalViews = 0;
$totalClicks = 0;
$maxViews = 0;
$maxClicks = 0;

$count = [];
$maxlen = 0;
$items_count = count($items);

for ($x = 0; $x < $items_count; $x++) {
    // AdViews

    $count[$x] = $items[$x]['value1'];

    $totalViews += $items[$x]['value1'];

    if ($items[$x]['value1'] > $maxViews) {
        $maxViews = $items[$x]['value1'];
    }

    // AdClicks

    $count2[$x] = $items[$x]['value2'];

    $totalClicks += $items[$x]['value2'];

    if ($items[$x]['value2'] > $maxClicks) {
        $maxClicks = $items[$x]['value2'];
    }

    // Strings

    if (mb_strlen($items[$x]['text']) > $maxlen) {
        $maxlen = mb_strlen($items[$x]['text']);
    }
}

// Get next round number
if (mb_strlen($maxViews) > 2) {
    $maxViews = ceil($maxViews / pow(10, mb_strlen($maxViews) - 2)) * pow(10, mb_strlen($maxViews) - 2);
} else {
    $maxViews = 100;
}

if (mb_strlen($maxClicks) > 2) {
    $maxClicks = ceil($maxClicks / pow(10, mb_strlen($maxClicks) - 2)) * pow(10, mb_strlen($maxClicks) - 2);
} elseif (mb_strlen($maxClicks) > 1) {
    $maxClicks = ceil($maxClicks / pow(10, mb_strlen($maxClicks) - 1)) * pow(10, mb_strlen($maxClicks) - 1);
} else {
    $maxClicks = 10;
}

// Use the same scale
if (defined('LIB_GRAPH_SAME_SCALE')) {
    if ($maxViews > $maxClicks) {
        $maxClicks = $maxViews;
    } else {
        $maxViews = $maxClicks;
    }
}

// Margins
$leftMargin = mb_strlen($maxViews) * imagefontwidth(2);
$rightMargin = mb_strlen($maxClicks) * imagefontwidth(2);
$margin = $leftMargin + $rightMargin;

// Headers
$text['value1'] .= ': ' . $totalViews;
$text['value2'] .= ': ' . $totalClicks;

// Dimensions
if (!isset($height)) {
    $height = 180;
}

if (!isset($width)) {
    $width = max($margin + 20 + 12 * $items_count, $margin + 50 + imagefontwidth(2) * (mb_strlen($text['value1']) + mb_strlen($text['value2'])));
}

$im = imagecreate($width, $height);
$bgcolor = imagecolorallocate($im, $bgcolors[0], $bgcolors[1], $bgcolors[2]);
$linecolor = imagecolorallocate($im, $linecolors[0], $linecolors[1], $linecolors[2]);
$graycolor = imagecolorallocate($im, $RGB['lgray'][0], $RGB['lgray'][1], $RGB['lgray'][2]);
$textcolor = imagecolorallocate($im, $textcolors[0], $textcolors[1], $textcolors[2]);
$adviewscolor = imagecolorallocate($im, $adviewscolors[0], $adviewscolors[1], $adviewscolors[2]);
$adclickscolor = imagecolorallocate($im, $adclickscolors[0], $adclickscolors[1], $adclickscolors[2]);

for ($x = 0; $x < $items_count; $x++) {
    imagestringup($im, 1, $leftMargin + 12 + ($x * 12), 130 + imagefontwidth(1) * $maxlen, $items[$x]['text'], $textcolor);
}

if (0 == $maxViews) {
    $scaleViews = 100;
} else {
    $scaleViews = (float)100 / (float)$maxViews;
}

if (defined('LIB_GRAPH_SAME_SCALE')) {
    $scaleClicks = $scaleViews;
} elseif (0 == $maxClicks) {
    $scaleClicks = 50;
} else {
    $scaleClicks = (float)50 / (float)$maxClicks;
}

imageline($im, $leftMargin + 10, 20, $leftMargin + 10 + ($items_count * 12), 20, $graycolor);
imageline($im, $leftMargin + 10, 45, $leftMargin + 10 + ($items_count * 12), 45, $graycolor);
imageline($im, $leftMargin + 10, 70, $leftMargin + 10 + ($items_count * 12), 70, $graycolor);
imageline($im, $leftMargin + 10, 95, $leftMargin + 10 + ($items_count * 12), 95, $graycolor);
imageline($im, $leftMargin + 10, 120, $leftMargin + 10 + ($items_count * 12), 120, $linecolor);

legend($im, $leftMargin + 10, 2, $text['value1'], $adviewscolor, $linecolor, $textcolor);
legend($im, $leftMargin + 40 + (imagefontwidth(2) * mb_strlen($text['value1'])), 2, $text['value2'], $adclickscolor, $linecolor, $textcolor);

// Views
imagestring($im, 2, $leftMargin - (imagefontwidth(2) * mb_strlen($maxViews)), 12, $maxViews, $textcolor);
imagestring($im, 2, $leftMargin - (imagefontwidth(2) * mb_strlen('0')), 115, '0', $textcolor);

// Clicks
if (!defined('LIB_GRAPH_SAME_SCALE')) {
    imagestring($im, 2, $leftMargin + 20 + ($items_count * 12), 63, $maxClicks, $textcolor);

    imagestring($im, 2, $leftMargin + 20 + ($items_count * 12), 115, '0', $textcolor);
}

for ($x = 0; $x < $items_count; $x++) {
    // AdViews

    imagefilledrectangle($im, $leftMargin + 10 + ($x * 12), 120 - (int)($count[$x] * $scaleViews), $leftMargin + 19 + ($x * 12), 120, $adviewscolor);

    imagerectangle($im, $leftMargin + 10 + ($x * 12), 120 - (int)($count[$x] * $scaleViews), $leftMargin + 19 + ($x * 12), 120, $linecolor);

    // AdClicks

    imagefilledrectangle($im, $leftMargin + 12 + ($x * 12), 120 - (int)($count2[$x] * $scaleClicks), $leftMargin + 21 + ($x * 12), 120, $adclickscolor);

    imagerectangle($im, $leftMargin + 12 + ($x * 12), 120 - (int)($count2[$x] * $scaleClicks), $leftMargin + 21 + ($x * 12), 120, $linecolor);
}

// IE workaround: Turn off outputbuffering
// if zlib compression is turned on
if (mb_strpos($HTTP_SERVER_VARS['HTTP_USER_AGENT'], 'MSIE') > 0
    && function_exists('ini_get') && (ini_get('zlib.output_compression')
        || 'ob_gzhandler' == ini_get('outputHandler'))) {
    ini_set('zlib.output_compression', false);

    ini_set('outputHandler', '');
}

// Send the content-type header
phpAds_GDContentType();

// No caching
require '../libraries/lib-cache.inc.php';

// Display modified image
phpAds_GDShowImage($im);

// Release allocated ressources
imagedestroy($im);
