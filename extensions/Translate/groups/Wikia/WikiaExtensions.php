<?php
/**
 * Classes for Wikia extension translation.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2008-2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Support for %MediaWiki extensions in Wikias repository.
 */
class PremadeWikiaExtensionGroups extends PremadeMediawikiExtensionGroups {
	protected $useConfigure = false;
	protected $idPrefix = 'wikia-';
	protected $path = null;
	protected $namespaces = array( NS_WIKIA, NS_WIKIA_TALK );

	public function __construct() {
		global $wgTranslateGroupRoot;

		parent::__construct();
		$dir = dirname( __FILE__ );
		$this->definitionFile = $dir . '/extensions.txt';
		$this->path = "$wgTranslateGroupRoot/wikia/";
	}
}
