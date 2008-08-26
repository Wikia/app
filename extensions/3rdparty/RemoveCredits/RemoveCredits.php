<?php

if (!defined('MEDIAWIKI')) die();

$wgExtensionFunctions[] = 'wfRemoveCredits';
$wgExtensionCredits['parserhook'][] = array
(
	'name'        => 'RemoveCredits',
	//'version'     => '0.1',
	'author'      => 'Przemek Piotrowski <ppiotr@wikia.com>',
	'url'         => 'http://staff.wikia.com/wiki/Attribution',
	'description' => 'adds users to global $wgCreditsToRemove to be removed from page credits in hacked Credits.php (eg. &lt;remove_credits users="ms_spammer,mr_vandal"/&gt;)',
);

$wgCreditsToRemove = array();

function wfRemoveCredits() 
{
	global $wgParser;

	$wgParser->setHook('remove_credits', 'doRemoveCredits');
}

function doRemoveCredits($input, $argv, &$parser)
{
	$parser->disableCache();

	global $wgCreditsToRemove;

	if (!empty($argv['users']))
	{
		$wgCreditsToRemove = preg_split('/\s*[,;\|]\s*/', $argv['users']);
	} elseif (!empty($input))
	{
		$wgCreditsToRemove = preg_split('/\s*[,;\|]\s*/', $input);
	}
}

?>
