<?php
/**
 * Internationalization file for ServerAdminLog
 *
 * @file
 * @ignore
 */

$messages = array();

/** English
 * @author John Du Hart
 */
$messages['en'] = array(
	'serveradminlog-desc' => '[[Special:AdminLog|Log]] for admin actions',

	// Special:AdminLog
	'adminlog' => 'Server Admin Log',
	'serveradminlog-invalidchannel' => 'Invalid channel',
	'serveradminlog-invalidchannel-msg' => "Channel '''$1''' does not exist!",
);

/** Message documentation (Message documentation)
 * @author John Du Hart
 */
$messages['qqq'] = array(
	'serveradminlog-desc' => '{{desc}}',

	// Special:AdminLog
	'adminlog' => 'Title at the top of [[Special:AdminLog]]',
	'serveradminlog-invalidchannel' => 'Title of the page when an invalid channel is passed',
	'serveradminlog-invalidchannel-msg' => 'Message for when an invalid channel is passed',
);