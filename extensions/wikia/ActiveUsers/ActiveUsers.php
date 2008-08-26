<?php
/*
 * Copyright 2006 Wikia, Inc.  All rights reserved.
 * Use is subject to license terms.
 */

if (!defined('MEDIAWIKI'))
	exit;

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['Activeusers'] = $dir . 'ActiveUsers_body.php';
$wgExtensionMessagesFiles['Activeusers'] = $dir . 'ActiveUsers.i18n.php';
$wgSpecialPages['Activeusers'] = 'Activeusers';
