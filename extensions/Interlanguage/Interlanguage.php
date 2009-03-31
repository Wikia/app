<?php
# MediaWiki Interlanguage extension v1.1
#
# Copyright © 2008 Nikola Smolenski <smolensk@eunet.yu>
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
#
# For more information see
# http://www.mediawiki.org/wiki/Extension:Interlanguage

$wgExtensionFunctions[]="wfInterlanguageExtension";
$wgHooks['LanguageGetMagic'][] = 'wfInterlanguageExtensionMagic';
$wgExtensionCredits['parserhook'][] = array(
	'name'           => 'Interlanguage',
	'author'         => 'Nikola Smolenski',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Interlanguage',
	'version'        => '1.1',//preg_replace('/^.* (\d\d\d\d-\d\d-\d\d) .*$/', '\1', '$LastChangedDate$'), #just the date of the last change
	'description'    => 'Grabs interlanguage links from another wiki',
	'descriptionmsg' => 'interlanguage-desc',
);

function wfInterlanguageExtension() {
	global $wgParser;
	$wgParser->setFunctionHook( 'interlanguage', 'InterlanguageExtension', SFH_NO_HASH );
}

function wfInterlanguageExtensionMagic( &$magicWords, $langCode ) {
	$magicWords['interlanguage'] = array(0, 'interlanguage');
	return true;
}

function InterlanguageExtension( &$parser, $param) {
	global $wgInterlanguageExtensionApiUrl, $wgInterlanguageExtensionSort,
	$wgInterlanguageExtensionPrefix, $wgInterlanguageExtensionInterwiki,
	$wgLanguageCode, $wgTitle, $wgMemc;

	if(isset($wgInterlanguageExtensionPrefix)) {
		$param = "$wgInterlanguageExtensionPrefix$param";
	}

	$url = $wgInterlanguageExtensionApiUrl . "?action=query&prop=langlinks&" . 
			"lllimit=500&format=php&redirects&titles=" . strtr( $param, ' ', '_' );
	$key = wfMemc( 'Interlanguage', md5( $url ) );
	$res = $wgMemc->get( $key );

	if ( !$res ) {
		# be sure to set $res back to bool false, we do a strict compare below
		$res = false;
		$a = Http::get( $url );
		$a = @unserialize( $a );
		if(isset($a['query']['pages']) && is_array($a['query']['pages'])) {
			$a = array_shift($a['query']['pages']);

			if(isset($a['missing'])) {
				// There is no such article on the central wiki
				$linker = new Linker();
				$res=array( $linker->makeBrokenLink( $wgInterlanguageExtensionInterwiki . strtr($param,'_',' ') ), 'noparse' => true, 'isHTML' => true);

			} else {
				if(isset($a['langlinks'])) {
					$a = $a['langlinks'];
					if(is_array($a)) {
						$res = true;
					}
				} else {
					// There are no links in the central wiki article
					$res = '';
				}
			}
		}
	}

	if($res === false) {
		// An API error has occured; preserve the links that are in the article
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'langlinks', array( 'll_lang', 'll_title' ), array( 'll_from' => $wgTitle->mArticleID), __FUNCTION__);
		$a = array();
		while ( $row = $dbr->fetchObject( $res ) ) {
			$a[] = array( 'lang' => $row->ll_lang, '*' => $row->ll_title );
		}
		$dbr->freeResult( $res );
		$res = true;
	}

	if($res === true) {
		// Sort links
		switch($wgInterlanguageExtensionSort) {
			case 'code':
				usort($a, 'InterlanguageExtensionCompareCode');
				break;
			case 'alphabetic':
				usort($a, 'InterlanguageExtensionCompareAlphabetic');
				break;
			case 'alphabetic_revised':
				usort($a, 'InterlanguageExtensionCompareAlphabeticRevised');
				break;
		}

		// Convert links to wikitext
		$res = '';
		foreach($a as $v) {
			if($v['lang'] != $wgLanguageCode) {
				$res .= "[[".$v['lang'].':'.$v['*']."]]";
			}
		}
	}
	# cache the final result so we can skip all of this
	$wgMemc->set( $key, $res, time() + 3600 );
	return $res;
}

function InterlanguageExtensionCompareCode($a, $b) {
	return strcmp($a['lang'], $b['lang']);
}

function InterlanguageExtensionCompareAlphabetic($a, $b) {
	global $wgInterlanguageExtensionSortPrepend;
//http://meta.wikimedia.org/w/index.php?title=Interwiki_sorting_order&oldid=1156923#By_order_of_alphabet.2C_based_on_local_language
	static $order = array(
			'aa', 'af', 'ak', 'als', 'am', 'ang', 'ab', 'ar', 'an', 'arc',
			'roa-rup', 'frp', 'as', 'ast', 'gn', 'av', 'ay', 'az', 'bm', 'bn',
			'zh-min-nan', 'map-bms', 'ba', 'be', 'be-x-old', 'bh', 'bcl', 'bi',
			'bar', 'bo', 'bs', 'br', 'bg', 'bxr', 'ca', 'cv', 'ceb', 'cs', 'ch',
			'ny', 'sn', 'tum', 'cho', 'co', 'za', 'cy', 'da', 'pdc', 'de', 'dv',
			'nv', 'dsb', 'dz', 'mh', 'et', 'el', 'eml', 'en', 'myv', 'es', 'eo',
			'ext', 'eu', 'ee', 'fa', 'fo', 'fr', 'fy', 'ff', 'fur', 'ga', 'gv',
			'gd', 'gl', 'gan', 'ki', 'glk', 'gu', 'got', 'zh-classical', 'hak',
			'xal', 'ko', 'ha', 'haw', 'hy', 'hi', 'ho', 'hsb', 'hr', 'io', 'ig',
			'ilo', 'bpy', 'id', 'ia', 'ie', 'iu', 'ik', 'os', 'xh', 'zu', 'is',
			'it', 'he', 'jv', 'kl', 'pam', 'kn', 'kr', 'ka', 'ks', 'csb', 'kk',
			'kw', 'rw', 'ky', 'rn', 'sw', 'kv', 'kg', 'ht', 'kj', 'ku', 'lad',
			'lbe', 'lo', 'la', 'lv', 'lb', 'lt', 'lij', 'li', 'ln', 'jbo', 'lg',
			'lmo', 'hu', 'mk', 'mg', 'ml', 'mt', 'mi', 'mr', 'mzn', 'ms', 'cdo',
			'mdf', 'mo', 'mn', 'mus', 'my', 'nah', 'na', 'fj', 'nl', 'nds-nl',
			'cr', 'ne', 'new', 'ja', 'nap', 'ce', 'pih', 'no', 'nn', 'nrm',
			'nov', 'oc', 'or', 'om', 'ng', 'hz', 'ug', 'uz', 'pa', 'pi', 'pag',
			'pap', 'ps', 'km', 'pms', 'nds', 'pl', 'pt', 'kaa', 'crh', 'ty',
			'ksh', 'ro', 'rmy', 'rm', 'qu', 'ru', 'sah', 'se', 'sm', 'sa', 'sg',
			'sc', 'sco', 'stq', 'st', 'tn', 'sq', 'scn', 'si', 'simple', 'sd',
			'ss', 'sk', 'cu', 'sl', 'szl', 'so', 'sr', 'sh', 'su', 'fi', 'sv',
			'tl', 'ta', 'kab', 'roa-tara', 'tt', 'te', 'tet', 'th', 'vi', 'ti',
			'tg', 'tpi', 'to', 'chr', 'chy', 've', 'tr', 'tk', 'tw', 'udm',
			'bug', 'uk', 'ur', 'vec', 'vo', 'fiu-vro', 'wa', 'vls', 'war', 'wo',
			'wuu', 'ts', 'ii', 'yi', 'yo', 'zh-yue', 'cbk-zam', 'diq', 'zea',
			'bat-smg', 'zh'
	);

	if(isset($wgInterlanguageExtensionSortPrepend) && is_array($wgInterlanguageExtensionSortPrepend)) {
		$order = array_merge($wgInterlanguageExtensionSortPrepend, $order);
		unset($wgInterlanguageExtensionSortPrepend);
	}

	$a=array_search($a['lang'], $order);
	$b=array_search($b['lang'], $order);

	return ($a>$b)?1:(($a<$b)?-1:0);
}

function InterlanguageExtensionCompareAlphabeticRevised($a, $b) {
	global $wgInterlanguageExtensionSortPrepend;
//From http://meta.wikimedia.org/w/index.php?title=Interwiki_sorting_order&oldid=1156923#By_order_of_alphabet.2C_based_on_local_language_.28by_first_word.29
	static $order = array(
			'aa', 'af', 'ak', 'als', 'am', 'ang', 'ab',
			'ar', 'an', 'arc', 'roa-rup', 'frp', 'as', 'ast', 'gn', 'av', 'ay',
			'az', 'id', 'ms', 'bm', 'bn', 'zh-min-nan', 'map-bms', 'jv', 'su',
			'ba', 'be', 'be-x-old', 'bh', 'bcl', 'bi', 'bar', 'bo', 'bs', 'br',
			'bug', 'bg', 'bxr', 'ca', 'ceb', 'cv', 'cs', 'ch', 'cbk-zam', 'ny',
			'sn', 'tum', 'cho', 'co', 'za', 'cy', 'da', 'pdc', 'de', 'dv', 'nv',
			'dsb', 'dz', 'mh', 'et', 'na', 'el', 'eml', 'en', 'myv', 'es', 'eo',
			'ext', 'eu', 'ee', 'to', 'fa', 'fo', 'fr', 'fy', 'ff', 'fur', 'ga',
			'gv', 'sm', 'gd', 'gl', 'gan', 'ki', 'glk', 'gu', 'got', 'hak',
			'ko', 'ha', 'haw', 'hy', 'hi', 'ho', 'hsb', 'hr', 'io', 'ig', 'ilo',
			'bpy', 'ia', 'ie', 'iu', 'ik', 'os', 'xh', 'zu', 'is', 'it', 'he',
			'kl', 'xal', 'kn', 'kr', 'pam', 'ka', 'ks', 'csb', 'kk', 'kw', 'rw',
			'ky', 'rn', 'sw', 'kv', 'kg', 'ht', 'ku', 'kj', 'lad', 'lbe', 'lo',
			'la', 'lv', 'lb', 'lt', 'lij', 'li', 'ln', 'jbo', 'lg', 'lmo', 'hu',
			'mk', 'mg', 'ml', 'mt', 'zh-classical', 'mi', 'mr', 'mzn', 'cdo',
			'mdf', 'mo', 'mn', 'mus', 'my', 'nah', 'fj', 'nl', 'nds-nl', 'cr',
			'ne', 'new', 'ja', 'nap', 'ce', 'pih', 'no', 'nn', 'nrm', 'nov',
			'oc', 'or', 'om', 'ng', 'hz', 'uz', 'pa', 'pi', 'pag', 'pap', 'ps',
			'km', 'pms', 'nds', 'pl', 'pt', 'kaa', 'crh', 'ty', 'ksh', 'ro',
			'rmy', 'rm', 'qu', 'ru', 'se', 'sa', 'sg', 'sc', 'sah', 'sco',
			'stq', 'st', 'tn', 'sq', 'scn', 'si', 'simple', 'sd', 'ss', 'sk',
			'sl', 'cu', 'szl', 'so', 'sr', 'sh', 'fi', 'sv', 'tl', 'ta', 'kab',
			'roa-tara', 'tt', 'te', 'tet', 'th', 'vi', 'ti', 'tg', 'tpi', 'chr',
			'chy', 've', 'tr', 'tk', 'tw', 'udm', 'uk', 'ur', 'ug', 'vec', 'vo',
			'fiu-vro', 'wa', 'vls', 'war', 'wo', 'wuu', 'ts', 'ii', 'yi', 'yo',
			'zh-yue', 'diq', 'zea', 'bat-smg', 'zh', 'zh-tw', 'zh-cn',
	);

	if(isset($wgInterlanguageExtensionSortPrepend) && is_array($wgInterlanguageExtensionSortPrepend)) {
		$order = array_merge($wgInterlanguageExtensionSortPrepend, $order);
		unset($wgInterlanguageExtensionSortPrepend);
	}

	$a=array_search($a['lang'], $order);
	$b=array_search($b['lang'], $order);

	return ($a>$b)?1:(($a<$b)?-1:0);
}
