<?php
if (!defined('MEDIAWIKI')) die();
/**
 * Test skin
 *
 * @package MediaWiki
 * @subpackage Skins
 *
 * @author Inez Korczyñski <korczynski@gmail.com>
 * @copyright Copyright (C) Wikia Inc. 2007
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

require_once('includes/SkinTemplate.php');

class SkinTest extends SkinTemplate {
	function initPage( &$out ) {
		wfProfileIn( __METHOD__ );
		SkinTemplate::initPage( $out );
		$this->skinname  = 'test';
		$this->stylename = 'test';
		$this->template  = 'TestTemplate';
 		wfProfileOut( __METHOD__ );
	}

	function &setupTemplate( $classname, $repository = false, $cache_dir = false ) {
		$tpl = new $classname();
		return $tpl;
	}
}


class TestTemplate extends QuickTemplate {

	function execute() {
		global $wgUser, $wgTitle, $wgArticle, $wgOut, $wgSkin;

		print_pre("Theme: " . $this->data['skin']->themename);
		print_pre($this);
		print_pre($wgTitle);
		print_pre($wgArticle);
		print_pre($wgUser);
		print_pre($wgOut);

	}
}
?>
