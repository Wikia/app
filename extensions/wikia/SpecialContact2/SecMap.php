<?php
global $SpecialContactSecMap;
$SpecialContactSecMap = array();

$SpecialContactSecMap[] = array(
	'headerMsg' => 'onwiki',
	'links' => array(
		'content-issue',
		'user-conflict',
		'adoption',
	)
);

$SpecialContactSecMap[] = array(
	'headerMsg' => 'account',
	'links' => array(
		array('link'=>'account-issue',  'form'=>true),
		array('link'=>'close-account',  'form'=>true),
		array('link'=>'rename-account', 'form'=>true),
		array('link'=>'blocked' ),
	)
);

$SpecialContactSecMap[] = array(
	'headerMsg' => 'editing',
	'links' => array(
		'using-wikia',
		array('link'=>'feedback', 'form'=>true),
		array('link'=>'bug',      'form'=>true),
		array('link'=>'bad-ad',   'form'=>true),
	)
);

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
