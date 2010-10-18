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
	function __construct() { parent::__construct('WikiFactoryReporter', 'wikifactory'); }

	function execute($params)
	{
		global $wgOut, $wgUser, $wgRequest;

		$wgOut->setPageTitle('WikiFactory Reporter');
		$wgOut->setRobotpolicy('noindex,nofollow');
		$wgOut->setArticleRelated(false);

		if( !$wgUser->isAllowed('wikifactory') ) {
			$this->displayRestrictionError();
			return;
		}

		$this->varid = $wgRequest->getInt('varid');

		$this->disable_limit = $wgRequest->getBool('nolimit');

		/***********************************************/
		$vars = WikiFactory::getVariables( "cv_name", 0, 0);
		$select = new XmlSelect( 'varid', false, $this->varid);

		if( !empty($this->varid) )
		{
			//the cast is because the Xml select uses === to detect the default
			$select->setDefault( (string)$this->varid);

			//change the name, using the var name
			$variable = WikiFactory::getVarById($this->varid, 0);
			$wgOut->setPageTitle('WikiFactory Reporter: ' . $variable->cv_name);
		}

		foreach($vars as $variable)
		{
			$select->addOption( "{$variable->cv_name} ({$variable->cv_id})", $variable->cv_id );
		}

		$wgOut->addHTML( "<form action='' method='get'>\n" );
		$wgOut->addHTML( $select->getHTML() );
		$wgOut->addHTML( "<input type='submit'>\n" );
		$wgOut->addHTML( "</form>\n" );
		/***********************************************/

		if( !empty($this->varid) )
		{
			$wgOut->addHTML($this->getCustomSettings());
		}
	}

	function getCustomSettings()
	{
		global $wgExternalSharedDB;
		$city_list = 'city_list';
		$cv        = 'city_variables';
		$cv_pool   = 'city_variables_pool';

		$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
		$res = $dbr->select(
			array($city_list, $cv, $cv_pool),
			array('cv_value', 'city_url', 'city_id'),
			array
			(
				"{$city_list}.city_id = {$cv}.cv_city_id",
				"{$cv}.cv_variable_id = {$cv_pool}.cv_id",
				"{$cv_pool}.cv_id     = '{$this->varid}'",
			),
			__METHOD__
		);

		$variable = WikiFactory::getVarById($this->varid, 0);

		$data = array();
		$values = array();
		$row_count = $dbr->numRows($res);

		if( $row_count == 0 ) {
			$dbr->freeResult($res);
			$out = "no settings found in WikiFactory\n";
			return $out;
		}

			$this->over_limit = false;
		if( $row_count > 1000 )
		{
			$this->over_limit = true;
		}
		if( $this->disable_limit )
		{
			$this->over_limit = false;
		}

		while ($row = $dbr->fetchObject($res))
		{
			$city_id = $row->city_id;
			$cv_value = unserialize($row->cv_value);
			$nom_value = $cv_value;
			if (is_array($cv_value))
			{
				asort($cv_value);
				$cv_value = join(', ', $cv_value);
				$nom_value = 'array';
			} elseif( is_bool($cv_value) )
			{
				$cv_value = ($cv_value)?('true'):('false');
				$nom_value = $cv_value;
			} else
			{
				#$cv_value = 'Error. Not an array?!?';
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
				if( count($data) <= 1000 || $this->disable_limit)
				{
					$data[] = array('value'=>$cv_value, 'url'=>$city_url, 'city'=>$city_id);
				}
				
				$values[] = $nom_value;
			}
		}

			$dbr->freeResult($res);
		$acv = array_count_values($values);
		asort($acv);
		unset($values);

		$gt = GlobalTitle::newFromText('WikiFactory', NS_SPECIAL, 177);

		$limit_message = '';
		if( $this->over_limit ) {
			$limit_message = Wikia::errorbox("Warning, this variable has {$row_count} entries. Only first 1000 shown");
			$QS = http_build_query( array('varid'=>$variable->cv_variable_id, 'nolimit' => 1) );
			$limit_message .= "<a href='/index.php?title=Special:WikiFactoryReporter&{$QS}'>Click here to load all results</a>\n";
		}

		$groups = WikiFactory::getGroups();
		$variable->var_group = $groups[$variable->cv_variable_group];

		$tmpl = new EasyTemplate(dirname(__FILE__) . '/templates/');
		$tmpl->set_vars(array
		(
			'th'       => array($variable->cv_name, 'wiki', 'city_id'),
			'data'     => $data,
			'variable' => $variable,
			'acv'      => $acv,
			'wf_base'  => $gt->getFullUrl(),
			'limit_message'  => $limit_message,
		));

		$out = $tmpl->execute('reporter');
		return $out;
	}
}