<?php

/**
 * Groups the two file formats together for Okawix
 * @copyright Copyright © 2009, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
class OkawixExtensionsGroup extends AllMediawikiExtensionsGroup {
	protected $label = 'Okawix';
	protected $id    = 'out-okawix';

	protected $classes = null;
	protected $description = '{{int:bw-desc-okawix}}';

	protected $subgroups = array(
		'out-okawix-dtd',
		'out-okawix-prop',
	);

	protected function init() {
		if ( $this->classes === null ) {
			$this->classes = array();
			$classes = MessageGroups::singleton()->getGroups();
			foreach ( $this->subgroups as $key ) {
				$this->classes[$key] = $classes[$key];
			}
		}
	}
}

$wgTranslateAC['out-okawix'] = 'OkawixExtensionsGroup';
$wgTranslateEC[] = 'out-okawix';