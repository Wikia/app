<?php
/**
 * WhereIsExtension
 *
 * A WhereIsExtension extension for MediaWiki
 * Provides a list of wikis with enabled selected extension
 *
 * @author Maciej B³aszkowski (Marooned) <marooned@wikia.com>
 * @date 2008-07-02
 * @copyright Copyright (C) 2008 Maciej B³aszkowski, Wikia, Inc.
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
	'author' => '[http://www.wikia.com/wiki/User:Marooned Maciej B³aszkowski (Marooned)]',
	'description' => 'This extension provides a list of wikis with enabled selected extension.'
);

class WhereIsExtension extends SpecialPage {
	function  __construct() {
		parent::__construct('WhereIsExtension' /*class*/, 'WhereIsExtension' /*restriction*/);
	}

	function execute() {
		global $wgOut, $wgUser, $wgRequest;
		$gVar = $wgRequest->getText('var');
		wfLoadExtensionMessages('WhereIsExtension');
		$wgOut->SetPageTitle(wfMsg('whereisextension'));
		$wgOut->setRobotpolicy('noindex,nofollow');

		if( !$wgUser->isAllowed('WhereIsExtension') ) {
			$this->displayRestrictionError();
			return;
		}

		$formData['vars'] = $this->getListOfVars();
		if (!empty($gVar)) {
			$formData['selectedVar'] = $gVar;
			$formData['wikis'] = $this->getListOfWikisWithVar($gVar);
		}
		$oTmpl = new EasyTemplate(dirname( __FILE__ ) . '/templates/');
		$oTmpl->set_vars( array(
				'formData' => $formData,
			));
		$wgOut->addHTML($oTmpl->execute('list'));
	}

	//fetching variable list from 'extension' group
	private function getListOfVars() {
		$aTables = array(
			wfSharedTable('city_variables_pool'),
			wfSharedTable('city_variables_groups')
		);

		$aWhere = array('cv_group_id = cv_variable_group');
		$aWhere['cv_variable_group'] = '27';	//id 'extensions' group

		$dbr = wfGetDB(DB_SLAVE);
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

	//fetching wiki list with selected variable set to 'true'
	private function getListOfWikisWithVar($varId) {
		$aTables = array(
			wfSharedTable('city_variables'),
			wfSharedTable('city_list')
		);

		$varId = mysql_real_escape_string($varId);
		$aWhere = array('city_id = cv_city_id');
		$aWhere[] = "cv_value = '" . serialize(true) . "'";
		$aWhere[] = "cv_variable_id = '$varId'";

		$dbr = wfGetDB(DB_SLAVE);
		$oRes = $dbr->select(
			$aTables,
			array('city_title', 'city_url'),
			$aWhere,
			__METHOD__,
			array('ORDER BY' => 'city_sitename')
		);

		$aWikis = array();
		while ($oRow = $dbr->fetchObject($oRes)) {
			$aWikis[$oRow->city_title] = $oRow->city_url;
		}
		$dbr->freeResult( $oRes );

		return $aWikis;
	}
}
?>