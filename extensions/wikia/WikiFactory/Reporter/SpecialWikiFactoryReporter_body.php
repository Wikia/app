<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Przemek Piotrowski <ppiotr@wikia.com>
 */

if (!defined('MEDIAWIKI')) { echo "This is MediaWiki extension.\n"; exit(1); }

wfLoadExtensionMessages('WikiFactoryReporter');

class WikiFactoryReporter extends SpecialPage
{
	function __construct() { parent::__construct('WikiFactoryReporter'); }

	function execute($params)
	{
		global $wgOut;

		$wgOut->setPageTitle('WikiFactory Reporter: wgFileExtensions');
		$wgOut->setRobotpolicy('noindex,nofollow');
		$wgOut->setArticleRelated(false);

		$wgOut->addHTML('<h2>Global Settings</h2>');
		$wgOut->addHTML($this->getGlobalSettings());

		$wgOut->addHTML('<h2>Custom Settings</h2>');
		$wgOut->addHTML($this->getCustomSettings());
	}

	function getGlobalSettings()
	{
		global $wgFileExtensions;
		$output = $wgFileExtensions;

		global $wgFileExtensionsLocal;
		if (is_array($wgFileExtensionsLocal))
		{
			$output = array_diff($output, $wgFileExtensionsLocal);
		}

		sort($output);
		$output = join(', ', $output);
		$output = "<p>{$output}</p>";

		return $output;
	}

	function getCustomSettings()
	{
		$city_list = wfSharedTable('city_list');
		$cv        = wfSharedTable('city_variables');
		$cv_pool   = wfSharedTable('city_variables_pool');

		$dbr = wfGetDB(DB_SLAVE);
		$res = $dbr->select(
			array($city_list, $cv, $cv_pool),
			array('cv_value', 'city_url'),
			array
			(
				"{$city_list}.city_id = {$cv}.cv_city_id",
				"{$cv}.cv_variable_id = {$cv_pool}.cv_id",
				"{$cv_pool}.cv_name   = 'wgFileExtensionsLocal'",
			),
			__METHOD__
		);

		$data = array();
		while ($row = $dbr->fetchObject($res))
		{
			$cv_value = unserialize($row->cv_value);
			if (is_array($cv_value))
			{
				sort($cv_value);
				$cv_value = join(', ', $cv_value);
			} else
			{
				$cv_value = 'Error. Not an array?!?';
			}
		
			if (preg_match('/http:\/\/([\w\.\-]+)\//', $row->city_url, $matches))
			{
				$city_url = str_ireplace('.wikia.com', '', $matches[1]);
			} else
			{
				$city_url = 'Error. Unknown wiki?!?';
			}
			
			if (!empty($cv_value))
			{
				$data[] = array($cv_value, $city_url);
			}
		}

		$dbr->freeResult($res);

		$tmpl = new EasyTemplate(dirname(__FILE__) . '/templates/');
		$tmpl->set_vars(array
		(
			'th'   =>  array('wgFileExtensions', 'wiki'),
			'data' => $data,
		));
		$out = $tmpl->execute('reporter');

		return $out;
	}
}
