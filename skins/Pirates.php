<?php
if (!defined('MEDIAWIKI')) die();
/**
 * Test skin
 *
 * @package MediaWiki
 * @subpackage Skins
 *
 * @author Consumer Team
 * @copyright Copyright (C) Wikia Inc. 2007
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

require_once('includes/SkinTemplate.php');

class SkinPirates extends WikiaSkin {
	function __construct() {
		global $wgOut;
		parent::__construct( 'PiratesTemplate', 'pirates' );

		$wgOut->addModuleStyles( 'skins.pirates' );

		//non-strict checks of css/js/scss assets/packages
		$this->strictAssetUrlCheck = false;
	}
}


class PiratesTemplate extends WikiaSkinTemplate {
	function execute() {
		F::app()->setSkinTemplateObj($this);
		$response = $this->app->sendRequest( 'Pirates', 'index' );
		$response->sendHeaders();
		$response->render();
	}
}
?>
