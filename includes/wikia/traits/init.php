<?php
/**
 * init.php
 *
 * includes all traits
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

global $wgAutoloadClasses;
$dir = dirname(__FILE__);

$wgAutoloadClasses['PreventBlockedUsers'] = "{$dir}/PreventBlockedUsers.trait.php";