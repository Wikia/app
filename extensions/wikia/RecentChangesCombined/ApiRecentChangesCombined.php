<?php

/**
 * @package MediaWiki
 * @subpackage API
 * @author Przemek Piotrowski <ppiotr@wikia.com> for Wikia, Inc.
 * @copyright (C) 2007, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id$
 */

class ApiRecentChangesCombined extends ApiBase
{
	protected $api_single = null;

	public function __construct($main, $action)
	{
		parent::__construct($main, $action, 'rc');

		$this->api_single = new ApiQueryRecentChanges($main, $action, 'rc');
	}

	public function execute()
	{
		$params = $this->getParams();
		list($data, $start) = $this->getData($params);
		$this->setOutput($data, $start);
	}

	protected function getParams()
	{
		$params = $this->extractRequestParams();

		return $params;
	}

	protected function getData($params)
	{
		$params_wiki = $params['wiki'];
		unset($params['wiki']);

		$params_url = array();
		foreach ($params as $name => $value)
		{
			if (is_array($value))
			{
				$value = join('|', $value);
			}
			if (!empty($value))
			{
				$params_url[] = "rc{$name}={$value}";
			}
		}
		$params_url = join('&', $params_url);

		$data2 = array();
		foreach ($params_wiki as $wiki)
		{
			if (preg_match('/\.wikipedia\.org/', $wiki, $preg))
			{
				$api_url = $wiki . '/w/';
			} else
			{
				$api_url = $wiki;
			}

			$url  = "http://{$api_url}/api.php?format=php&action=query&list=recentchanges&{$params_url}";
			$ch = curl_init();
			curl_setopt_array($ch, array(
				CURLOPT_HEADER         => false,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_URL            => $url,
			));
			$data = curl_exec($ch);
			$data = unserialize($data);

			foreach ((array) $data['query']['recentchanges'] as $row)
			{
				$data2[$row['timestamp'] . mt_rand(1000, 9999)] = $row + array('wiki' => $wiki);
			}

			$start = $data['query-continue']['recentchanges']['rcstart'];
		}

		if (1 < count($params_wiki))
		{
			krsort($data2);
			$data2 = array_slice($data2, 0, $params['limit'] + 1);

			$one_over_limit = array_pop($data2);
			$start = $one_over_limit['timestamp'];
		}

		$data = array_values($data2);

		return array($data, $start);
	}

	protected function setOutput($data, $start)
	{
		$result = $this->getResult();
		$result->addValue('query-continue', $this->getModuleName(), array('rcstart' => $start));
		$result->setIndexedTagName($data, 'rc');
		$result->addValue('query', $this->getModuleName(), $data);
	}

	public function getAllowedParams()
	{
		$this_wiki = str_replace('http://', '', $GLOBALS['wgServer']);

		return array_merge
		(
			array
			(
				'wiki' => array
				(
					ApiBase :: PARAM_ISMULTI =>  true,
					ApiBase :: PARAM_DFLT    => $this_wiki,
				),
			),
			$this->api_single->getAllowedParams()
		);
	}

	public function getParamDescription()
	{
		return array_merge
		(
			array
			(
				'wiki' => 'Wiki to check',
			),
			$this->api_single->getParamDescription()
		);
	}

	public function getDescription()
	{
		return array
		(
			'This module is used to show recent changes from one or more wiki.',
		);
	}
	
	public function getExamples()
	{
		return array
		(
			'api.php?action=recentchangescombined',
			'api.php?action=recentchangescombined&rcwiki=uncyclopedia.org|en.wikipedia.org&rclimit=25',
		);
	}

	public function getVersion()
	{
		return __CLASS__ . ': $Id$';
	}
}

?>
