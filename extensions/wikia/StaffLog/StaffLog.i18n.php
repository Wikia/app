<?php

$messages = array();

$messages['en'] = array(
	'stafflog-desc' => 'Centralised logging for staff',
	'stafflog' => 'StaffLog',
	'stafflog-blockmsg' => '$1 $2 tried to block staff user $3 on wiki $4. Reason: $5',
	'stafflog-piggybackloginmsg' => '$1 Piggyback - user $2 login as $3', // @todo FIXME: event contains 4 parameters.
	'stafflog-piggybacklogoutmsg' => '$1 Piggyback - user $2 logout from $3 acount', // @todo FIXME: event contains 4 parameters.
);

$messages['qqq'] = array(
	'stafflog-desc' => '{{desc}}',
	'stafflog' => 'Log name.',
	'stafflog-blockmsg' => 'Log entry. Parameters:
* $1 is the user ID of the acting user
* $2 is the user name of the acting user
* $3 is the blocked user name
* $4 is the blocked address
* $5 is the block reason.',
	'stafflog-piggybackloginmsg' => 'Log entry. Parameters:
* $1 is the user ID of the acting user
* $2 is the user name of the acting user
* $3 is the user ID of the "victim"
* $4 is the user name of the "victim".',
	'stafflog-piggybacklogoutmsg' => 'Log entry. Parameters:
* $1 is the user ID of the acting user
* $2 is the user name of the acting user
* $3 is the user ID of the "victim"
* $4 is the user name of the "victim".',
);
