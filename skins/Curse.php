<?php
if (!defined('MEDIAWIKI')) die();
/**
 * Curse skin
 *
 * @package MediaWiki
 * @subpackage Skins
 *
 * @author Inez Korczynski <inez@wikia.com>
 * @author Gerard Adamczewski <gerard@wikia.com>
 * @author Maciej Brencz <macbre@wikia.com>
 * @author Tomasz Klim <tomek@wikia.com>
 * @copyright Copyright (C) 2007 Inez Korczynski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

global $IP;

require_once($IP.'/skins/Monaco.php');

class SkinCurse extends SkinMonaco {

	function initPage( &$out ) {
		wfProfileIn( __METHOD__ );

		parent::initPage( $out );
		$this->skinname  = 'curse';
		$this->stylename = 'curse';
		$this->template  = 'CurseTemplate';

		wfProfileOut( __METHOD__ );
	}
}

class CurseTemplate extends MonacoTemplate {

	// macbre: define custom header and footer for curse identity integration
	function printCustomHeader()
	{
		echo '<!-- curse header --><link rel="stylesheet" href="http://static.curse.com/v4/css/new-header.css?5" /><script type="text/javascript" src="http://www.curse.com/js/wikia/header.js"></script><!-- /curse header -->';
	}

	function printCustomFooter()
	{
		echo '<!-- curse footer --><script type="text/javascript" src="http://www.curse.com/js/wikia/footer.js"></script><!-- /curse header -->';
	}

}
