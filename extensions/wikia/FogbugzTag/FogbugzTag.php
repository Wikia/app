<?php
if (!defined('MEDIAWIKI'))
{
	exit(1);
}
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'FogbugzTag',
	'author' => 'Pepe & Rychu',
	'description' => "FogbugzTag allows to use tags <fogbugz_tck id=\"your_case_id\"></fogbugz_tck> ".
					 "in the articles on Internal Wiki",
	'version' => '1.0',
);

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['FogbugzTag'] = $dir . 'FogbugzTag.class.php';
$wgAutoloadClasses['FogbugzContainer'] = $dir . 'FogbugzContainer.class.php';

$wgHooks['ParserFirstCallInit'][] = 'FogbugzTag::onFogbugzTagInit';

$wgAjaxExportList[] = 'FogbugzTag::getFogbugzServiceResponse';