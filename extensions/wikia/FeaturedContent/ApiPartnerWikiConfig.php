<?php

/**
 * @package MediaWiki
 * @subpackage API
 * @author Przemek Piotrowski <ppiotr@wikia.com> for Wikia, Inc.
 * @copyright (C) 2007 Wikia, Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id$
 */

class ApiPartnerWikiConfig extends ApiBase
{
	const PARTNER_WIKI_CONFIG_VAR = 'wgPartnerWikiConfig';

	public function __construct($main, $action)
	{
		parent::__construct($main, $action, 'pwc');
	}

	public function execute()
	{
		wfProfileIn(__METHOD__);

		$params = $this->getParams();
		$data = $this->getData($params);
		$this->setOutput($data);

		wfProfileOut(__METHOD__);
	}

	protected function getParams()
	{
		wfProfileIn(__METHOD__);

		$params = $this->extractRequestParams();

		wfProfileOut(__METHOD__);
		return $params;
	}

	protected function getData($params)
	{
		wfProfileIn(__METHOD__);

		$data = array();

		if (!empty($params['name']))
		{
			$name = $params['name'];
			if (!empty($GLOBALS[self::PARTNER_WIKI_CONFIG_VAR]))
			{
				$pwcv = $GLOBALS[self::PARTNER_WIKI_CONFIG_VAR];
				if (!empty($pwcv[$name]))
				{
					$data = $pwcv[$name];
				}
			}
		}

		wfProfileOut(__METHOD__);
		return $data;
	}

	protected function setOutput($data)
	{
		wfProfileIn(__METHOD__);

		$result =& $this->getResult();

		$data2 = array();
		foreach ($data as $key => $val)
		{
			$data2[$key] = $val;
			if (preg_match('/links/', $key, $preg))
			{
				$result->setIndexedTagName($data2[$key], 'link');
			}
		}
		$data = $data2;

		$result->setIndexedTagName($data, 'pwc');
		$result->addValue('query', $this->getModuleName(), $data);

		wfProfileOut(__METHOD__);
	}

	public function getAllowedParams()
	{
		return array
		(
			'name' => array
			(
				ApiBase::PARAM_TYPE => 'string',
			),
		);
	}

	public function getParamDescription()
	{
		return array
		(
			'name' => 'Name of the partner wiki.',
		);
	}

	public function getDescription()
	{
		return array
		(
			'This module is used to show config variables for the partner (mirror) wiki.',
		);
	}
	
	public function getExamples()
	{
		return array
		(
			'api.php?action=partnerwikiconfig&pwcname=wikia.partner.com',
		);
	}

	public function getVersion()
	{
		return __CLASS__ . ': $Id$';
	}
}

?>
