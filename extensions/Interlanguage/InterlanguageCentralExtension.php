<?php
/**
 * MediaWiki InterlanguageCentral extension
 * InterlanguageCentralExtension class
 *
 * Copyright © 2010-2011 Nikola Smolenski <smolensk@eunet.rs>
 * @version 1.3
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 *
 * For more information,
 * @see http://www.mediawiki.org/wiki/Extension:Interlanguage
 */

class InterlanguageCentralExtension {
	//ILL = InterLanguageLinks
	var $oldILL = array();

	function languagelink( &$parser, $lang, $title = "" ) {
		if( strlen( $lang ) && strlen( $title ) ) {
			return "[[$lang:$title]][[:$lang:$title]]";
		} else {
			return "";
		}
	}

	function onLinksUpdate( &$linksUpdate ) {
		$oldILL = $this->getILL( DB_SLAVE, $linksUpdate->mTitle);
		$newILL = $linksUpdate->mInterlangs;

		//Convert $newILL to the same format as $oldILL
		foreach($newILL as $k => $v) {
			if(!is_array($v)) {
				$newILL[$k] = array($v => true);
			}
		}

		//Compare ILLs before and after the save; if nothing changed, there is no need to purge
		if(
			count(array_udiff_assoc(
				$oldILL,
				$newILL,
				"InterlanguageCentralExtension::arrayCompareKeys"
			)) || count(array_udiff_assoc(
				$newILL,
				$oldILL,
				"InterlanguageCentralExtension::arrayCompareKeys"
			))
		) {
			$ill = array_merge_recursive($oldILL, $newILL);
			$job = new InterlanguageCentralExtensionPurgeJob( $linksUpdate->mTitle, array('ill' => $ill) );
			$job->insert();
		}

		return true;
	}

	function getILL( $db, $title ) {
		$dbr = wfGetDB( $db );
		$res = $dbr->select( 'langlinks', array( 'll_lang', 'll_title' ), array( 'll_from' => $title->mArticleID), __FUNCTION__);
		$a = array();
		foreach( $res as $row ) {
			if(!isset($a[$row->ll_lang])) {
				$a[$row->ll_lang] = array();
			}
			$a[$row->ll_lang][$row->ll_title] = true;
		}
		return $a;
	}

	static function arrayCompareKeys($a, $b) {
		return count(array_diff_key($a, $b))? 1: (count(array_diff_key($b, $a))? -1: 0);
	}
}
