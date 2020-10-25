<?php

// $Revision: 2.1.2.10 $

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
require 'config.php';
require 'lib-statistics.inc.php';
require 'lib-zones.inc.php';
require 'lib-invocation.inc.php';
require 'lib-size.inc.php';
require 'lib-append.inc.php';

// Register input variables
phpAds_registerGlobal('chaintype', 'chainzone', 'chainwhat', 'append', 'prepend', 'submitbutton', 'textad');
phpAds_registerGlobal('appendtype', 'appendtype_previous', 'appendsave', 'appendselection', 'appendwhat');

// Security check
phpAds_checkAccess(phpAds_Admin + phpAds_Affiliate);

/*********************************************************/
/* Affiliate interface security                          */
/*********************************************************/

if (phpAds_isUser(phpAds_Affiliate)) {
    if (isset($zoneid) && $zoneid > 0) {
        $result = phpAds_dbQuery(
            '
			SELECT
				affiliateid
			FROM
				' . $phpAds_config['tbl_zones'] . "
			WHERE
				zoneid = '$zoneid'
			"
        ) or phpAds_sqlDie();

        $row = phpAds_dbFetchArray($result);

        if ('' == $row['affiliateid'] || phpAds_getUserID() != $row['affiliateid'] || !phpAds_isAllowed(phpAds_EditZone)) {
            phpAds_PageHeader('1');

            phpAds_Die($strAccessDenied, $strNotAdmin);
        } else {
            $affiliateid = phpAds_getUserID();
        }
    } else {
        if (phpAds_isAllowed(phpAds_AddZone)) {
            $affiliateid = phpAds_getUserID();
        } else {
            phpAds_PageHeader('1');

            phpAds_Die($strAccessDenied, $strNotAdmin);
        }
    }
}

/*********************************************************/
/* Process submitted form                                */
/*********************************************************/

if (isset($submitbutton)) {
    if (isset($zoneid) && '' != $zoneid) {
        $sqlupdate = [];

        // Determine chain

        if ('1' == $chaintype && '' != $chainzone) {
            $chain = 'zone:' . $chainzone;
        } elseif ('2' == $chaintype && '' != $chainwhat) {
            $chain = $chainwhat;
        } else {
            $chain = '';
        }

        $sqlupdate[] = "chain='" . $chain . "'";

        if (isset($textad) && $textad) {
            if (!isset($prepend)) {
                $prepend = '';
            }

            if (!isset($append)) {
                $append = '';
            }

            $sqlupdate[] = "prepend='" . $prepend . "'";

            $sqlupdate[] = "append='" . $append . "'";
        } else {
            $sqlupdate[] = "prepend=''";

            // Do not save append until finished with appending, if present

            if (isset($appendsave) && $appendsave) {
                if (phpAds_AppendNone == $appendtype) {
                    $append = '';
                }

                if (phpAds_AppendPopup == $appendtype
                    || phpAds_AppendInterstitial == $appendtype) {
                    if (phpAds_AppendBanner == $appendselection) {
                        $what = isset($appendwhat[phpAds_AppendBanner]) ? implode(',', $appendwhat[phpAds_AppendBanner]) : '';
                    } elseif (phpAds_AppendZone == $appendselection) {
                        $what = isset($appendwhat[phpAds_AppendZone]) ? 'zone:' . $appendwhat[phpAds_AppendZone] : 'zone:0';
                    } else {
                        $what = $appendwhat[phpAds_AppendKeyword];
                    }

                    if (phpAds_AppendPopup == $appendtype) {
                        $codetype = 'popup';
                    } else {
                        $codetype = 'adlayer';

                        if (!isset($layerstyle)) {
                            $layerstyle = 'geocities';
                        }

                        require dirname(__DIR__) . '/libraries/layerstyles/' . $layerstyle . '/invocation.inc.php';
                    }

                    $append = addslashes(phpAds_GenerateInvocationCode());
                }

                $sqlupdate[] = "append='" . $append . "'";

                $sqlupdate[] = "appendtype='" . $appendtype . "'";
            }
        }

        $res = phpAds_dbQuery(
            '
			UPDATE
				' . $phpAds_config['tbl_zones'] . '
			SET
				' . implode(', ', $sqlupdate) . "
			WHERE
				zoneid='" . $zoneid . "'
		"
        ) or phpAds_sqlDie();

        // Rebuild Cache

        if (!defined('LIBVIEWCACHE_INCLUDED')) {
            include phpAds_path . '/libraries/deliverycache/cache-' . $phpAds_config['delivery_caching'] . '.inc.php';
        }

        phpAds_cacheDelete('what=zone:' . $zoneid);

        // Do not redirect until not finished with zone appending, if present

        if (!isset($appendsave) || $appendsave) {
            if (phpAds_isUser(phpAds_Affiliate)) {
                if (phpAds_isAllowed(phpAds_LinkBanners)) {
                    header('Location: zone-include.php?affiliateid=' . $affiliateid . '&zoneid=' . $zoneid);
                } else {
                    header('Location: zone-probability.php?affiliateid=' . $affiliateid . '&zoneid=' . $zoneid);
                }
            } else {
                header('Location: zone-include.php?affiliateid=' . $affiliateid . '&zoneid=' . $zoneid);
            }

            exit;
        }
    }
}

/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

$navorder = $Session['prefs']['affiliate-zones.php']['listorder'] ?? '';

$navdirection = $Session['prefs']['affiliate-zones.php']['orderdirection'] ?? '';

// Get other zones
$res = phpAds_dbQuery(
    '
	SELECT
		*
	FROM
		' . $phpAds_config['tbl_zones'] . "
	WHERE
		affiliateid = '" . $affiliateid . "'
		" . phpAds_getZoneListOrder($navorder, $navdirection) . '
'
);

while (false !== ($row = phpAds_dbFetchArray($res))) {
    phpAds_PageContext(
        phpAds_buildZoneName($row['zoneid'], $row['zonename']),
        'zone-advanced.php?affiliateid=' . $affiliateid . '&zoneid=' . $row['zoneid'],
        $zoneid == $row['zoneid']
    );
}

if (phpAds_isUser(phpAds_Admin)) {
    phpAds_PageShortcut($strAffiliateProperties, 'affiliate-edit.php?affiliateid=' . $affiliateid, 'images/icon-affiliate.gif');

    phpAds_PageShortcut($strZoneHistory, 'stats-zone-history.php?affiliateid=' . $affiliateid . '&zoneid=' . $zoneid, 'images/icon-statistics.gif');

    $extra = "<form action='zone-modify.php'>";

    $extra .= "<input type='hidden' name='zoneid' value='$zoneid'>";

    $extra .= "<input type='hidden' name='returnurl' value='zone-advanced.php'>";

    $extra .= '<br><br>';

    $extra .= "<b>$strModifyZone</b><br>";

    $extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";

    $extra .= "<img src='images/icon-duplicate-zone.gif' align='absmiddle'>&nbsp;<a href='zone-modify.php?affiliateid=" . $affiliateid . '&zoneid=' . $zoneid . "&duplicate=true&returnurl=zone-advanced.php'>$strDuplicate</a><br>";

    $extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";

    $extra .= "<img src='images/icon-move-zone.gif' align='absmiddle'>&nbsp;$strMoveTo<br>";

    $extra .= "<img src='images/spacer.gif' height='1' width='160' vspace='2'><br>";

    $extra .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

    $extra .= "<select name='moveto' style='width: 110;'>";

    $res = phpAds_dbQuery('SELECT * FROM ' . $phpAds_config['tbl_affiliates'] . " WHERE affiliateid <> '" . $affiliateid . "'") or phpAds_sqlDie();

    while (false !== ($row = phpAds_dbFetchArray($res))) {
        $extra .= "<option value='" . $row['affiliateid'] . "'>" . phpAds_buildAffiliateName($row['affiliateid'], $row['name']) . '</option>';
    }

    $extra .= "</select>&nbsp;<input type='image' src='images/" . $phpAds_TextDirection . "/go_blue.gif'><br>";

    $extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";

    $extra .= "<img src='images/icon-recycle.gif' align='absmiddle'>&nbsp;<a href='zone-delete.php?affiliateid=$affiliateid&zoneid=$zoneid&returnurl=affiliate-zones.php'" . phpAds_DelConfirm($strConfirmDeleteZone) . ">$strDelete</a><br>";

    $extra .= '</form>';

    phpAds_PageHeader('4.2.3.6', $extra);

    echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;" . phpAds_getAffiliateName($affiliateid);

    echo "&nbsp;<img src='images/" . $phpAds_TextDirection . "/caret-rs.gif'>&nbsp;";

    echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;<b>" . phpAds_getZoneName($zoneid) . '</b><br><br><br>';

    phpAds_ShowSections(['4.2.3.2', '4.2.3.6', '4.2.3.3', '4.2.3.4', '4.2.3.5']);
} else {
    $sections[] = '2.1.2';

    $sections[] = '2.1.6';

    if (phpAds_isAllowed(phpAds_LinkBanners)) {
        $sections[] = '2.1.3';
    }

    $sections[] = '2.1.4';

    $sections[] = '2.1.5';

    phpAds_PageHeader('2.1.6');

    echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;" . phpAds_getAffiliateName($affiliateid);

    echo "&nbsp;<img src='images/" . $phpAds_TextDirection . "/caret-rs.gif'>&nbsp;";

    echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;<b>" . phpAds_getZoneName($zoneid) . '</b><br><br><br>';

    phpAds_ShowSections($sections);
}

/*********************************************************/
/* Main code                                             */
/*********************************************************/

$res = phpAds_dbQuery(
    '
	SELECT
		*
	FROM
		' . $phpAds_config['tbl_zones'] . "
	WHERE
		zoneid = '" . $zoneid . "'
"
) or phpAds_sqlDie();

if (phpAds_dbNumRows($res)) {
    $zone = phpAds_dbFetchArray($res);
}

$tabindex = 1;

if (!isset($chaintype)) {
    $chainwhat = '';

    $chainzone = '';

    if ('' == $zone['chain']) {
        $chaintype = 0;
    } else {
        if (preg_match('^zone:([0-9]+)$', $zone['chain'], $regs)) {
            $chaintype = 1;

            $chainzone = $regs[1];
        } else {
            $chaintype = 2;

            $chainwhat = $zone['chain'];
        }
    }
}

echo "<form name='zoneform' method='post' action='zone-advanced.php' onSubmit='return phpAds_formSubmit();'>";
echo "<input type='hidden' name='zoneid' value='" . (isset($zoneid) && '' != $zoneid ? $zoneid : '') . "'>";
echo "<input type='hidden' name='affiliateid' value='" . (isset($affiliateid) && '' != $affiliateid ? $affiliateid : '') . "'>";

echo "<br><table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>" . $strChainSettings . '</b></td></tr>';
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>" . $strZoneNoDelivery . '</td><td>';
echo "<table cellpadding='0' cellspacing='0' border='0' width='100%'>";

echo "<tr><td><input type='radio' name='chaintype' value='0'" . (0 == $chaintype ? ' CHECKED' : '') . " tabindex='" . ($tabindex++) . "'>&nbsp;</td><td>";
echo $strZoneStopDelivery . '</td></tr>';
echo "<tr><td colspan='2'><img src='images/break-l.gif' height='1' width='100%' align='absmiddle' vspace='8'></td></tr>";

echo "<tr><td><input type='radio' name='chaintype' value='1'" . (1 == $chaintype ? ' CHECKED' : '') . " tabindex='" . ($tabindex++) . "'>&nbsp;</td><td>";
echo $strZoneOtherZone . ':</td></tr>';
echo "<tr><td>&nbsp;</td><td width='100%'><img src='images/spacer.gif' height='1' width='100%' align='absmiddle' vspace='1'>";

if (phpAds_ZoneBanner == $zone['delivery']) {
    echo "<img src='images/icon-zone.gif' align='top'>";
}
if (phpAds_ZoneInterstitial == $zone['delivery']) {
    echo "<img src='images/icon-interstitial.gif' align='top'>";
}
if (phpAds_ZonePopup == $zone['delivery']) {
    echo "<img src='images/icon-popup.gif' align='top'>";
}
if (phpAds_ZoneText == $zone['delivery']) {
    echo "<img src='images/icon-textzone.gif' align='top'>";
}

echo "&nbsp;&nbsp;<select name='chainzone' style='width: 200;' onchange='phpAds_formSelectZone()' tabindex='" . ($tabindex++) . "'>";

$available = [];

// Get list of public publishers
$res = phpAds_dbQuery(
    'SELECT * FROM ' . $phpAds_config['tbl_affiliates'] . ' WHERE ' . "publiczones = 't' OR affiliateid = '" . $affiliateid . "'"
);

while (false !== ($row = phpAds_dbFetchArray($res))) {
    $available[] = "affiliateid = '" . $row['affiliateid'] . "'";
}

$available = implode(' OR ', $available);

$allowothersizes = phpAds_ZoneInterstitial == $zone['delivery'] || phpAds_ZonePopup == $zone['delivery'];

// Get list of zones to link to
$res = phpAds_dbQuery(
    'SELECT * FROM '
    . $phpAds_config['tbl_zones']
    . ' WHERE '
    . (-1 == $zone['width'] || $allowothersizes ? '' : 'width = ' . $zone['width'] . ' AND ')
    . (-1 == $zone['height'] || $allowothersizes ? '' : 'height = ' . $zone['height'] . ' AND ')
    . 'delivery = '
    . $zone['delivery']
    . ' AND ('
    . $available
    . ') AND zoneid != '
    . $zoneid
);

while (false !== ($row = phpAds_dbFetchArray($res))) {
    if ($chainzone == $row['zoneid']) {
        echo "<option value='" . $row['zoneid'] . "' selected>" . phpAds_buildZoneName($row['zoneid'], $row['zonename']) . '</option>';
    } else {
        echo "<option value='" . $row['zoneid'] . "'>" . phpAds_buildZoneName($row['zoneid'], $row['zonename']) . '</option>';
    }
}

echo '</select></td></tr>';
echo "<tr><td colspan='2'><img src='images/break-l.gif' height='1' width='100%' align='absmiddle' vspace='8'></td></tr>";

echo "<tr><td><input type='radio' name='chaintype' value='2'" . (2 == $chaintype ? ' CHECKED' : '') . " tabindex='" . ($tabindex++) . "'>&nbsp;</td><td>";
echo $strZoneUseKeywords . ':</td></tr>';
echo "<tr><td>&nbsp;</td><td width='100%'><img src='images/spacer.gif' height='1' width='100%' align='absmiddle' vspace='1'>";
echo "<img src='images/icon-edit.gif' align='top'>&nbsp;&nbsp;<textarea name='chainwhat' rows='3' cols='55' style='width: 200;' onkeydown='phpAds_formEditWhat()' tabindex='" . ($tabindex++) . "'>" . htmlspecialchars($chainwhat, ENT_QUOTES | ENT_HTML5) . '</textarea>';
echo '</td></tr></table></td></tr>';

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo '</table>';

if (phpAds_ZoneBanner == $zone['delivery']) {
    echo "<br><br><table border='0' width='100%' cellpadding='0' cellspacing='0'>";

    echo "<tr><td height='25' colspan='3'><b>" . $strAppendSettings . '</b></td></tr>';

    echo "<tr height='1'><td width='30'><img src='images/break.gif' height='1' width='30'></td>";

    echo "<td width='200'><img src='images/break.gif' height='1' width='200'></td>";

    echo "<td width='100%'><img src='images/break.gif' height='1' width='100%'></td></tr>";

    echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

    // Get available zones

    $available = [];

    // Get list of public publishers

    $res = phpAds_dbQuery('SELECT * FROM ' . $phpAds_config['tbl_affiliates'] . " WHERE publiczones = 't' OR affiliateid = '" . $affiliateid . "'");

    while (false !== ($row = phpAds_dbFetchArray($res))) {
        $available[] = "affiliateid = '" . $row['affiliateid'] . "'";
    }

    $available = implode(' OR ', $available);

    // Get public zones

    $res = phpAds_dbQuery(
        'SELECT zoneid, zonename, delivery FROM ' . $phpAds_config['tbl_zones'] . ' WHERE ' . '(delivery = ' . phpAds_ZonePopup . ' OR delivery = ' . phpAds_ZoneInterstitial . ') AND (' . $available . ') ORDER BY zoneid'
    );

    $available = [phpAds_ZonePopup => [], phpAds_ZoneInterstitial => []];

    while (false !== ($row = phpAds_dbFetchArray($res))) {
        $available[$row['delivery']][$row['zoneid']] = phpAds_buildZoneName($row['zoneid'], $row['zonename']);
    }

    // Get available zones

    $available_banners = [];

    // Get campaigns from same advertiser

    $res = phpAds_dbQuery('SELECT * FROM ' . $phpAds_config['tbl_clients'] . " WHERE parent != 0 AND active = 't'");

    while (false !== ($row = phpAds_dbFetchArray($res))) {
        $available_banners[] = "clientid = '" . $row['clientid'] . "'";
    }

    $available_banners = implode(' OR ', $available_banners);

    // Get banners from same advertiser

    $res = phpAds_dbQuery(
        'SELECT bannerid, clientid, description, alt FROM ' . $phpAds_config['tbl_banners'] . ' WHERE ' . "active = 't' AND (" . $available_banners . ') ORDER BY clientid, bannerid'
    );

    $available_banners = [];

    while (false !== ($row = phpAds_dbFetchArray($res))) {
        $available_banners[$row['bannerid']] = phpAds_buildBannerName($row['bannerid'], $row['description'], $row['alt']);
    }

    // Determine the candidates for each type

    $candidates[phpAds_AppendPopup] = count($available[phpAds_ZonePopup]) + count($available_banners);

    $candidates[phpAds_AppendInterstitial] = count($available[phpAds_ZoneInterstitial]) + count($available_banners);

    // Determine appendtype

    if (!isset($appendtype)) {
        $appendtype = $zone['appendtype'];
    }

    if (!isset($appendtype_previous)) {
        $appendtype_previous = '';
    }

    echo "<input type='hidden' name='appendtype_previous' value='" . $appendtype . "'>";

    echo "<input type='hidden' name='appendsave' value='1'>";

    echo "<input type='hidden' name='textad' value='0'>";

    // Appendtype choices

    echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>" . $GLOBALS['strAppendType'] . '</td><td>';

    echo "<select name='appendtype' style='width: 200;' onchange='phpAds_formSelectAppendType()' tabindex='" . ($tabindex++) . "'>";

    echo "<option value='" . phpAds_AppendNone . "'" . (phpAds_AppendNone == $appendtype ? ' selected' : '') . '>' . $GLOBALS['strNone'] . '</option>';

    if ($candidates[phpAds_AppendPopup]) {
        echo "<option value='" . phpAds_AppendPopup . "'" . (phpAds_AppendPopup == $appendtype ? ' selected' : '') . '>' . $GLOBALS['strPopup'] . '</option>';
    }

    if ($candidates[phpAds_AppendInterstitial]) {
        echo "<option value='" . phpAds_AppendInterstitial . "'" . (phpAds_AppendInterstitial == $appendtype ? ' selected' : '') . '>' . $GLOBALS['strInterstitial'] . '</option>';
    }

    echo "<option value='" . phpAds_AppendRaw . "'" . (phpAds_AppendRaw == $appendtype ? ' selected' : '') . '>' . $GLOBALS['strAppendHTMLCode'] . '</option>';

    echo '</select></td></tr>';

    // Line

    if (phpAds_AppendNone != $appendtype) {
        echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

        echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";

        echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
    }

    if (phpAds_AppendPopup == $appendtype
        || phpAds_AppendInterstitial == $appendtype) {
        // Determine available zones

        $available_zones = (phpAds_AppendPopup == $appendtype) ? $available[phpAds_ZonePopup] : $available[phpAds_ZoneInterstitial];

        // Append zones

        if ($appendtype != $appendtype_previous) {
            // Admin chose a different append type or this is the first

            // time this page is shown to the admin

            if ($appendtype == $zone['appendtype']) {
                // Admin chose the original append type, or this is the

                // first time this page is shown to the admin.

                // Load all data from the invocation code

                $appendvars = phpAds_ParseAppendCode($zone['append']);

                $appendwhat = $appendvars[0]['what'];            // id's
                $appendselection = $appendvars[0]['selection'];        // keyword, banner or zone

                while (list($k, $v) = each($appendvars[1])) {
                    if ('n' != $k && 'what' != $k) {
                        $GLOBALS[$k] = addslashes($v);
                    }
                }
            } else {
                // Admin chose a different append type from the original

                // In this case it is not possible to reuse anything, set to defaults

                if (count($available_zones)) {
                    $appendselection = phpAds_AppendZone;

                    $appendwhat = '';
                } elseif (count($available_banners)) {
                    $appendselection = phpAds_AppendBanner;

                    $appendwhat = [];
                } else {
                    $appendselection = phpAds_AppendKeyword;

                    $appendwhat = '';
                }
            }
        } else {
            // Admin changed on of the lower options, reuse all of

            // info from the submitted form

            if (phpAds_AppendBanner == $appendselection) {
                $appendwhat = $appendwhat[$appendselection] ?? [];
            } else {
                $appendwhat = $appendwhat[$appendselection] ?? '';
            }
        }

        // Header

        echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>" . $strAppendWhat . '</td><td>';

        echo "<select name='appendselection' onChange=\"phpAds_formSelectBox(this.options[this.selectedIndex].value);\"";

        echo "tabindex='" . ($tabindex++) . "'>";

        if (count($available_zones)) {
            echo "<option value='" . phpAds_AppendZone . "'" . (phpAds_AppendZone == $appendselection ? ' SELECTED' : '') . '>';

            echo $strAppendZone . '</option>';
        }

        if (count($available_banners)) {
            echo "<option value='" . phpAds_AppendBanner . "'" . (phpAds_AppendBanner == $appendselection ? ' SELECTED' : '') . '>';

            echo $strAppendBanner . '</option>';
        }

        echo "<option value='" . phpAds_AppendKeyword . "'" . (phpAds_AppendKeyword == $appendselection ? ' SELECTED' : '') . '>';

        echo $strAppendKeyword . '</option>';

        echo '</select><br><br>';

        // Show all banners

        echo "<div class='box' id='box_" . phpAds_AppendBanner . "'" . (phpAds_AppendBanner == $appendselection ? '' : ' style="display: none;"') . '>';

        while (list($id, $name) = each($available_banners)) {
            echo "<div class='boxrow' onMouseOver='boxrow_over(this);' onMouseOut='boxrow_leave(this);' onClick='o=findObj(\"banner_" . $id . "\"); o.checked = !o.checked;'>";

            echo "<input onClick='boxrow_nonbubble();' tabindex='" . ($tabindex++) . "' ";

            echo "type='checkbox' id='banner_" . $id . "' name='appendwhat[" . phpAds_AppendBanner . "][]' value='$id'" . (phpAds_AppendBanner == $appendselection && in_array($id, $appendwhat, true) ? ' checked' : '') . '>';

            echo "&nbsp;<img src='images/icon-banner-stored.gif'>&nbsp;" . $name;

            echo '</div>';
        }

        echo '</div>';

        // Show all zones

        echo "<div class='box' id='box_" . phpAds_AppendZone . "'" . (phpAds_AppendZone == $appendselection ? '' : ' style="display: none;"') . '>';

        if (phpAds_AppendZone != $appendselection || '' == $appendwhat) {
            [$selected] = each($available_zones);

            reset($available_zones);
        } else {
            $selected = $appendwhat;
        }

        while (list($id, $name) = each($available_zones)) {
            echo "<div class='boxrow' onMouseOver='boxrow_over(this);' onMouseOut='boxrow_leave(this);' onClick='o=findObj(\"zone_" . $id . "\"); if (!o.checked) { o.checked = !o.checked; }'>";

            echo "<input onClick='boxrow_nonbubble();' tabindex='" . ($tabindex++) . "' ";

            echo "type='radio' id='zone_" . $id . "' name='appendwhat[" . phpAds_AppendZone . "]' value='$id'" . ($id == $selected ? ' checked' : '') . '>';

            if (phpAds_AppendPopup == $appendtype) {
                echo "&nbsp;<img src='images/icon-popup.gif'>";
            } else {
                echo "&nbsp;<img src='images/icon-interstitial.gif'>";
            }

            echo '&nbsp;' . $name;

            echo '</div>';
        }

        echo '</div>';

        // Show all keywords

        echo "<div id='box_" . phpAds_AppendKeyword . "'" . (phpAds_AppendKeyword == $appendselection ? '' : ' style="display: none;"') . '>';

        echo "<textarea class='box' name='appendwhat[" . phpAds_AppendKeyword . "]' tabindex='" . ($tabindex++) . "'>" . (phpAds_AppendKeyword == $appendselection ? $appendwhat : '') . '</textarea>';

        echo '</div>';

        // Line

        echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

        echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";

        echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

        // Invocation options

        $extra = [
            'what' => '',
'delivery' => phpAds_AppendPopup == $appendtype ? phpAds_ZonePopup : phpAds_ZoneInterstitial,
'zoneadvanced' => true,
        ];

        phpAds_placeInvocationForm($extra, true);

        echo '</td></tr>';
    } elseif (phpAds_AppendRaw == $appendtype) {
        // Regular HTML append

        echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>" . $strZoneAppend . '</td><td>';

        echo "<textarea name='append' class='code' rows='15' cols='55' tabindex='" . ($tabindex++) . "'>" . htmlspecialchars($zone['append'], ENT_QUOTES | ENT_HTML5) . '</textarea>';

        echo '</td></tr>';
    }

    echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

    echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";

    echo '</table>';
}

// It isn't possible to append other banners to text zones, but
// it is possible to prepend and append regular HTML code for
// determining the layout of the text ad zone

elseif (phpAds_ZoneText == $zone['delivery']) {
    echo "<input type='hidden' name='textad' value='1'>";

    echo '<br><br><br>';

    echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";

    echo "<tr><td height='25' colspan='3'><b>" . $strAppendSettings . '</b></td></tr>';

    echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";

    echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

    echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>" . $strZonePrependHTML . '</td><td>';

    echo "<textarea name='prepend' rows='6' cols='55' style='width: 100%;' tabindex='" . ($tabindex++) . "'>" . htmlspecialchars($zone['prepend'], ENT_QUOTES | ENT_HTML5) . '</textarea>';

    echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";

    echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

    echo "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>" . $strZoneAppendHTML . '</td><td>';

    echo "<input type='hidden' name='appendsave' value='1'>";

    echo "<input type='hidden' name='appendtype' value='" . phpAds_ZoneAppendRaw . "'>";

    echo "<textarea name='append' rows='6' cols='55' style='width: 100%;' tabindex='" . ($tabindex++) . "'>" . htmlspecialchars($zone['append'], ENT_QUOTES | ENT_HTML5) . '</textarea>';

    echo '</td></tr>';

    echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

    echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";

    echo '</table>';
}

echo '<br><br>';
echo "<input type='submit' name='submitbutton' value='" . $strSaveChanges . "' tabindex='" . ($tabindex++) . "'>";
echo '</form>';

/*********************************************************/
/* Form requirements                                     */
/*********************************************************/

?>

    <script language='JavaScript'>
        <!--

        // Set the name of the form
        formname = 'zoneform';


        function phpAds_formSelectZone() {
            form = findObj(formname);

            form.chaintype[0].checked = false;
            form.chaintype[1].checked = true;
            form.chaintype[2].checked = false;
        }

        function phpAds_formEditWhat() {
            if (event.keyCode != 9) {
                form = findObj(formname);

                form.chaintype[0].checked = false;
                form.chaintype[1].checked = false;
                form.chaintype[2].checked = true;
            }
        }

        function phpAds_formSelectAppendType() {
            form = findObj(formname);

            form.appendsave.value = '0';
            form.submit();
        }

        function phpAds_formSelectAppendDelivery(type) {
            form = findObj(formname);

            form.appendsave.value = '0';
            form.submit();
        }

        function phpAds_formSubmit() {
            // Defaults
            errors = '';

            // Get the type of append
            obj = findObj('appendtype');

            if (obj.options) {
                appendtype = obj.options[obj.selectedIndex].value;

                if (appendtype == <?php echo phpAds_AppendPopup ?> ||
                    appendtype == <?php echo phpAds_AppendInterstitial ?>) {
                    // Get the way banners are appended
                    obj = findObj('appendselection');
                    appendselection = obj.options[obj.selectedIndex].value;

                    form = findObj(formname);

                    // Check if a zone is selected
                    if (appendselection == <?php echo phpAds_AppendZone ?>) {
                        checked = false;

                        for (i = 0; i < form.elements.length; i++) {
                            if (form.elements.item(i).name == 'appendwhat[<?php echo phpAds_AppendZone ?>]' &&
                                form.elements.item(i).checked === true) {
                                checked = true;
                            }
                        }

                        if (!checked)
                            errors = '<?php echo $strAppendErrorZone ?>';
                    }

                    // Check if one or more banners are selected
                    if (appendselection == <?php echo phpAds_AppendBanner ?>) {
                        checked = false;

                        for (i = 0; i < form.elements.length; i++) {
                            if (form.elements.item(i).name == 'appendwhat[<?php echo phpAds_AppendBanner ?>][]' &&
                                form.elements.item(i).checked === true) {
                                checked = true;
                            }
                        }

                        if (!checked)
                            errors = '<?php echo $strAppendErrorBanner ?>';
                    }

                    // Check if there are any keywords specified
                    if (appendselection == <?php echo phpAds_AppendKeyword ?>) {
                        obj = findObj('appendwhat[<?php echo phpAds_AppendKeyword ?>]')

                        if (obj.value == '') {
                            errors = '<?php echo $strAppendErrorKeyword ?>';
                        }
                    }
                }
            }

            if (errors != '') {
                alert(errors + "\n");
                return false;
            }

            return true;
        }

        function phpAds_formSelectBox(s) {
            // Hide all the boxes
            hideLayer(findObj('box_<?php echo phpAds_AppendZone ?>'));
            hideLayer(findObj('box_<?php echo phpAds_AppendBanner ?>'));
            hideLayer(findObj('box_<?php echo phpAds_AppendKeyword ?>'));

            // Show the selected box
            showLayer(findObj('box_' + s));

            if (s == <?php echo phpAds_AppendKeyword ?>) {
                obj = findObj('appendwhat[<?php echo phpAds_AppendKeyword ?>]')
                obj.focus();
            }
        }

        //-->
    </script>

<?php

/*********************************************************/

/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
