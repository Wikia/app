<?php
/**
 * AutomaticWikiAdoptionJobFactory
 *
 * An AutomaticWikiAdoption extension for MediaWiki
 * Maintenance script - helper class
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2010-10-08
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage Maintanance
 *
 */

class AutomaticWikiAdoptionJobFactory {
	private $instances = array();

	function produce($className) {
		if (!isset($this->instances[$className])) {
			$this->instances[$className] = new $className;
		}
		return $this->instances[$className];
	}
}