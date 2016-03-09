<?php
global $SpecialContactSecMap;
$SpecialContactSecMap = array();

$SpecialContactSecMap[] = array(
	'headerMsg' => 'onwiki',
	'links' => array(
		'content-issue',
		'user-conflict',
		'adoption',
		'dmca-request',
	)
);

$SpecialContactSecMap[] = array(
	'headerMsg' => 'account',
	'links' => array(
		array('link'=>'account-issue',  'form'=> 'account-issue' ),
		array('link'=>'close-account',  'form'=> 'close-account', 'reqlogin' => true ),
		array('link'=>'rename-account', 'form'=> 'rename-account', 'reqlogin' => true ),
		array('link'=>'blocked' ),
	)
);

$SpecialContactSecMap[] = [
	'headerMsg' => 'editing',
	'links' => [
		'using-wikia',
		[ 'link' => 'feedback', 'form' => true ],
		[ 'link' => 'bug',      'form' => 'bug-report' ],
		[ 'link' => 'security', 'form' => 'security' ],
		[ 'link' => 'bad-ad',   'form' => 'bad-ad' ],
	],
];

$SpecialContactSecMap[] = array(
	'headerMsg' => 'setting',
	'links' => array(
		array('link'=>'wiki-name-change', 'form'=>true),
		'design',
		'features',
		array('link'=>'close-wiki', 'form'=>true),
	)
);

#this is special section, it has no headerMsg.
# with no headerMsg, it will not generate a section on the picker,
# but it's jump links will be authorized
$SpecialContactSecMap[] = array(
	'links' => array(
		array('link'=>'general', 'form'=>true),
	)
);
