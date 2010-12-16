<?php
/**
 * This class represents one section of a translatable page.
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2009 Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
class TPSection {
	public $id, $name, $text, $type;

	public function getText() {
		return $this->text;
	}

	public function getTextForTrans() {
		$re = '~<tvar\|([^>]+)>(.*?)</>~u';
		return preg_replace( $re, '\2', $this->text );
	}

	public function getMarkedText() {
		$id = isset( $this->name ) ? $this->name : $this->id;
		$header = "<!--T:{$id}-->";
		$re     = '~^(=+.*?=+\s*?)\n~';
		$rep    = "\\1 $header\n";
		$count  = 0;

		$text = preg_replace( $re, $rep, $this->text, 1, $count );
		if ( $count === 0 ) {
			$text = $header . "\n" . $this->text;
		}
		return $text;
	}

	public function getOldText() {
		return isset( $this->oldtext ) ? $this->oldtext : $this->text;
	}

	public function getVariables() {
		$re = '~<tvar\|([^>]+)>(.*?)</>~u';
		$matches = array();
		preg_match_all( $re, $this->text, $matches, PREG_SET_ORDER );
		$vars = array();
		foreach ( $matches as $m ) {
			$vars['$' . $m[1]] = $m[2];
		}
		return $vars;
	}
}