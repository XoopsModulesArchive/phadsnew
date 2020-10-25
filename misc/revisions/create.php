<?php

// Determine the location of phpAdsNew on the server
if (mb_strlen(__FILE__) > mb_strlen(basename(__FILE__))) {
    define('phpAds_path', preg_replace('[/\\\\]misc[/\\\\].+$', '', __FILE__));
} else {
    define('phpAds_path', '../..');
}

include phpAds_path . '/libraries/lib-dbconfig.inc.php';
include phpAds_path . '/libraries/lib-revisions.inc.php';

// Starting scan
echo 'Starting scan at ' . phpAds_path . '<br>';

if (phpAds_revisionCreate()) {
    echo 'Revision file succesfully created!<br>';
} else {
    echo '<strong>Error:</strong> Failed to create a new revision file<br>';
}
