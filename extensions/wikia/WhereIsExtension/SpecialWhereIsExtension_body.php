<?php
/**
 * WhereIsExtension
 *
 * A WhereIsExtension extension for MediaWiki
 * Provides a list of wikis with enabled selected extension
 *
 * @author Maciej Błaszkowski (Marooned) <marooned@wikia.com>
 * @date 2008-07-02
 * @copyright Copyright (C) 2008 Maciej Błaszkowski, Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage SpecialPage
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/WhereIsExtension/SpecialWhereIsExtension.php");
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named WhereIsExtension.\n";
	exit(1) ;
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'WhereIsExtension',
	'author' => '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]',
	'description' => 'This extension provides a list of wikis with enabled selected extension.'
);

class WhereIsExtension extends SpecialPage {
	private $values;

	function  __construct() {
		parent::__construct('WhereIsExtension' /*class*/, 'WhereIsExtension' /*restriction*/);
	}

	function execute() {
		global $wgOut, $wgUser, $wgRequest, $wgTitle;
		$gVar = $wgRequest->getText('var');
		$gVal = $wgRequest->getVal('val', 'true');
		$gLikeVal = $wgRequest->getVal('likeValue', 'true');
		$gTypeVal = $wgRequest->getVal('searchType', 'bool');
		
		wfLoadExtensionMessages('WhereIsExtension');
		$wgOut->SetPageTitle(wfMsg('whereisextension'));
		$wgOut->setRobotpolicy('noindex,nofollow');

		if( !$wgUser->isAllowed('WhereIsExtension') ) {
			$this->displayRestrictionError();
			return;
		}

		$this->values = array (
			//[0] displayed name
			//[1] serialized value
			//[2] condition
			0 => array('true', true, '='),
			1 => array('false', false, '='),
			2 => array('not empty', '', '!=')
		);

		$tagName = $wgRequest->getVal( 'wikiSelectTagName', null);
		$tagWikis = $wgRequest->getArray( 'wikiSelected' );
		$tagResultInfo = '';
		if ( $wgRequest->wasPosted() && !empty( $tagName ) && count( $tagWikis )) {
			$tagResultInfo = $this->tagSelectedWikis( $tagName, $tagWikis );
		}

		$formData['vars'] = $this->getListOfVars($gVar == '');
		$formData['vals'] = $this->values;
		$formData['selectedVal'] = $gVal;
		$formData['likeValue'] = $gLikeVal;
		$formData['searchType'] = $gTypeVal;
		$formData['selectedGroup'] = $gVar == '' ? 27 : '';	//default group: extensions (or all groups when looking for variable, rt#16953)
		$formData['groups'] = WikiFactory::getGroups();
		$formData['actionURL'] = $wgTitle->getFullURL();
		if (!empty($gVar)) {
			$formData['selectedVar'] = $gVar;
			$formData['wikis'] = $this->getListOfWikisWithVar($gVar, $gTypeVal, $gVal, $gLikeVal);
		}
		$oTmpl = new EasyTemplate(dirname( __FILE__ ) . '/templates/');
		$oTmpl->set_vars( array(
				'formData' => $formData,
				'tagResultInfo' => $tagResultInfo
			));
		$wgOut->addHTML($oTmpl->execute('list'));
	}

	//fetching variable list from 'extension' group
	private function getListOfVars($clear) {
		global $wgExternalSharedDB;
		$aTables = array( 'city_variables_pool', 'city_variables_groups' );

		$aWhere = array('cv_group_id = cv_variable_group');
		if ($clear) {	//rt#16953
			$aWhere['cv_variable_group'] = '27';	//id 'extensions' group
		}

		$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
		$oRes = $dbr->select(
			$aTables,
			array('cv_id, cv_name'),
			$aWhere,
			__METHOD__,
			array('ORDER BY' => 'cv_name')
		);

		$aVariables = array();
		while ($oRow = $dbr->fetchObject($oRes)) {
			$aVariables[$oRow->cv_id] = $oRow->cv_name;
		}
		$dbr->freeResult( $oRes );
		return $aVariables;
	}

	private function tagSelectedWikis( $tagName, Array $tagWikis) {
		global $wgCityId;

		if(!class_exists('WikiFactoryTags', true)) {
			return "WikiFactory extension must be enabled";
		}

		if (!empty($tagName) ) {
			foreach( $tagWikis as $wikiId ) {
				$wikiTags = new WikiFactoryTags( $wikiId );
				$wikiTags->addTagsByName( $tagName );
			}
			$wikiFactoryUrl = Title::makeTitle( NS_SPECIAL, 'WikiFactory' )->getFullUrl() . '/' . $wgCityId . '/tags/' . $tagName;

			$msg = count( $tagWikis ) . " wiki(s) tagged with tag: <a href=\"$wikiFactoryUrl\">$tagName</a>";
		}
		else {
			$msg = "Empty tag name";
		}

		return $msg;
	}

	//fetching wiki list with selected variable set to 'true'
	private function getListOfWikisWithVar($varId, $type, $val, $likeVal) {
		global $wgExternalSharedDB;
		$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
		
		$aWikis = array();
		if (!isset($this->values[$val][1])) {
			return $aWikis;
		}
		$selectedVal = serialize($this->values[$val][1]);
		$selectedCond = $this->values[$val][2];

		$aTables = array(
			'city_variables',
			'city_list',
		);
		$varId = mysql_real_escape_string($varId);
		$aWhere = array('city_id = cv_city_id');
		
		if( $type == "full" ) {
			$aWhere[] = "cv_value like '%".$dbr->escapeLike($likeVal)."%'";
		} else {
			$aWhere[] = "cv_value $selectedCond '$selectedVal'";	
		}
		
		$aWhere[] = "cv_variable_id = '$varId'";


		$oRes = $dbr->select(
			$aTables,
			array('city_id', 'city_title', 'city_url', 'city_public'),
			$aWhere,
			__METHOD__,
			array('ORDER BY' => 'city_sitename')
		);

		while ($oRow = $dbr->fetchObject($oRes)) {
			$aWikis[$oRow->city_id] = array('u' => $oRow->city_url, 't' => $oRow->city_title, 'p' => ( !empty($oRow->city_public) ? true : false ) );
		}
		$dbr->freeResult( $oRes );

		return $aWikis;
	}
}
?>
