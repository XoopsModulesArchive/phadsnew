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

// Set HTML colors
$headercolor = '#66CCFF';
$bodycolor = '#000000';
$textcolor = '#006666';

// Populate RGB array with colors
$RGB = [
    'white' => [0xFF, 0xFF, 0xFF],
'black' => [0x00, 0x00, 0x00],
'gray' => [0x7F, 0x7F, 0x7F],
'lgray' => [0xBF, 0xBF, 0xBF],
'egray' => [0xDD, 0xDD, 0xDD],
'dgray' => [0x3F, 0x3F, 0x3F],
'blue' => [0x00, 0x00, 0xBF],
'lblue' => [0x00, 0x00, 0xFF],
'dblue' => [0x00, 0x00, 0x7F],
'yellow' => [0xBF, 0xBF, 0x00],
'lyellow' => [0xFF, 0xFF, 0x00],
'dyellow' => [0x7F, 0x7F, 0x00],
'green' => [0x00, 0xBF, 0x00],
'lgreen' => [0x00, 0xFF, 0x00],
'dgreen' => [0x00, 0x7F, 0x00],
'red' => [0xBF, 0x00, 0x00],
'lred' => [0xFF, 0x00, 0x00],
'dred' => [0x7F, 0x00, 0x00],
'purple' => [0xBF, 0x00, 0xBF],
'lpurple' => [0xFF, 0x00, 0xFF],
'dpurple' => [0x7F, 0x00, 0x7F],
'gold' => [0xFF, 0xD7, 0x00],
'pink' => [0xFF, 0xB7, 0xC1],
'dpink' => [0xFF, 0x69, 0xB4],
'marine' => [0x7F, 0x7F, 0xFF],
'cyan' => [0x00, 0xFF, 0xFF],
'lcyan' => [0xE0, 0xFF, 0xFF],
'maroon' => [0x80, 0x00, 0x00],
'olive' => [0x80, 0x80, 0x00],
'navy' => [0x00, 0x00, 0x80],
'teal' => [0x00, 0x80, 0x80],
'silver' => [0xC0, 0xC0, 0xC0],
'lime' => [0x00, 0xFF, 0x00],
'khaki' => [0xF0, 0xE6, 0x8C],
'lsteelblue' => [0xB0, 0xC4, 0xDE],
'seagreen' => [0x3C, 0xB3, 0x71],
'lseagreen' => [0x20, 0xB2, 0xAA],
'skyblue' => [0x87, 0xCE, 0xEB],
'lskyblue' => [0x87, 0xCE, 0xFA],
'slateblue' => [0x6A, 0x5A, 0xCD],
'slategray' => [0x70, 0x80, 0x90],
'steelblue' => [0x46, 0x82, 0xB4],
'tan' => [0xD2, 0xB4, 0x8C],
'violet' => [0xEE, 0x82, 0xEE],
'wheat' => [0xF5, 0xDE, 0xB3],
'phpAdsClicks' => [153, 204, 255],
'phpAdsViews' => [0, 102, 204],
'phpAdsLines' => [0, 0, 102],
];

// Set the colors used for creating the graphs
$bgcolors = $RGB['white'];
$adviewscolors = $RGB['phpAdsViews'];
$adclickscolors = $RGB['phpAdsClicks'];
$linecolors = $RGB['phpAdsLines'];
$textcolors = $RGB['black'];
