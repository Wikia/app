<?php
/**
 * This file is used by IE for cross-domain messaging by Facebook SDK (RT #140425)
 *
 * @see ttp://developers.facebook.com/docs/reference/javascript/FB.init
 */

// set caching headers (a year)
$duration = 365 * 3600;
header("Cache-Control: s-maxage={$duration}, must-revalidate, max-age=0");
header("X-Pass-Cache-Control: max-age={$duration}");

// select FB localisation
$lang = !empty($_GET['lang']) ? $_GET['lang'] : 'en_US';

?>
<script src="http://connect.facebook.net/<?= urlencode($lang) ?>/all.js"></script>
