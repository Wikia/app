<?php

/**
 * Body of the special page to show recent changes from one or more wiki
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Przemek Piotrowski <ppiotr@wikia.com> for Wikia, Inc.
 * @copyright (C) 2007, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id$
 */

require_once dirname(__FILE__) . '/SpecialRecentchanges_combined.i18n.php';

class SpecialRecentchanges_combined extends SpecialPage
{
	public function __construct()
	{
		parent::__construct('Recentchanges_combined');
	}

	public function execute($params)
	{
		wfProfileIn(__METHOD__);

		$params = $this->getParams();
		$data = $this->getData($params);
		$this->setOutput($data, $params);

		wfProfileOut(__METHOD__);
		return true;
	}
	
	protected function getParams()
	{
		wfProfileIn(__METHOD__);

		global $wgRequest;

		$params = array();

		$param = $wgRequest->getText('limit');
		if (!empty($param))
		{
			$params['limit'] = $param;
		} else
		{
			$params['limit'] = 10;
		}

		$param = $wgRequest->getText('wiki');
		if (!empty($param))
		{
			$wiki2 = array();
			foreach (preg_split('/[\s,|]+/', $param) as $wiki)
			{
				$wiki = preg_replace('/^http:\/\//', '', $wiki);
				$wiki = preg_replace('/[^a-z0-9.-]+/', '', $wiki);

				$wiki = preg_replace('/^([a-z]{2})$/',        '\1.wikipedia.org', $wiki); // two letters => wikipedia
				$wiki = preg_replace('/^([a-z0-9.-]+)\.wp$/', '\1.wikipedia.org', $wiki); // foo.wp => wikipedia
				$wiki = preg_replace('/^([a-z0-9-]{3,})$/',   '\1.wikia.com', $wiki);     // three+ alpha => wikia
				$wiki = preg_replace('/^([a-z0-9.-]+)\.w$/',  '\1.wikia.com', $wiki);     // foo.w => wikia

				if (!empty($wiki))
				{
					$wiki2[] = $wiki;
				}
			}

			if (count($wiki2))
			{
				$params['wiki'] = $wiki2;
			}
		}
		if (count($params['wiki']))
		{
			$params['wiki'] = join('|', $params['wiki']);
		} else
		{
			$params['wiki'] = str_replace('http://', '', $GLOBALS['wgServer']);
		}

		$param = $wgRequest->getIntArray('namespace');
		if (count($param))
		{
			$keys = array_keys($param, '-1');
			if (count($keys))
			{
				foreach ($keys as $key)
				{
					unset($param[$key]);
				}
			}
			if (count($param))
			{
				$params['namespace'] = join('|', $param);
			}
		}

		$show = array();
		foreach (array('minor', 'bot', 'anon', 'loggedin') as $name)
		{
			if ($wgRequest->getCheck($name))
			{
				$show["!{$name}"] = true;
			}
		}
		if (count($show))
		{
			if (array_key_exists('!anon', $show) && array_key_exists('!loggedin', $show))
			{
				unset($show['!anon']);
				unset($show['!loggedin']);
				$show['anon'] = true;
			} elseif (array_key_exists('!anon', $show))
			{
				// $show['!anon'] = true; is already set
			} elseif (array_key_exists('!loggedin', $show))
			{
				unset($show['!loggedin']);
				$show['anon'] = true;
			}

			$params['show'] = join('|', array_keys($show));
		}

		$param = $wgRequest->getInt('limit');
		if (!empty($param))
		{
			$params['limit'] = $param;
		}
		//echo '<pre>'; print_r($params); die();

		wfProfileOut(__METHOD__);
		return $params;
	}

	protected function getData($params)
	{
		wfProfileIn(__METHOD__);

		$request = new FauxRequest(array
		(
			'action'  => 'recentchangescombined',
			'rcwiki'  =>  $params['wiki'],
			'rcnamespace' =>  $params['namespace'],
			'rcprop'  => 'user|comment|flags',
			'rcshow'  =>  $params['show'],
			'rclimit' =>  $params['limit'],
		));

		$api = new ApiMain($request);
		$api->execute();

		$data = $api->getResultData();
		$data = $data['query']['recentchangescombined'];

		wfProfileOut(__METHOD__);
		return $data;
	}

	protected function setOutput($data, $params)
	{
		wfProfileIn(__METHOD__);

		$this->setHeaders();

		global $wgOut;
		$tmpl = new EasyTemplate(dirname( __FILE__ ));

		$tmpl->set_vars(array('params' => $params, 'this_url' => $this->getTitle()->getLocalUrl()));
		$output = $tmpl->execute('form');
		$wgOut->addHtml($output);

		$tmpl->set_vars(array('data' => $data));
		$output = $tmpl->execute('list');
		$wgOut->addHtml($output);

		wfProfileOut(__METHOD__);
	}
}

?>
