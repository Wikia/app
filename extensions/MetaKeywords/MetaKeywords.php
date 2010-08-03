<?php

/*
	Extension:MetaKeywords Copyright (C) 2008 Conrad.Irwin

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA
*/

//Ideas from http://mediawiki.org/wiki/Extension:Gadgets thanks to Duesentrieb
//		   [[User:Mike Dillon]]

$wgExtensionCredits['other'][] = array(
	'name'           => 'MetaKeywords',
	'author'         => '[http://en.wiktionary.org/wiki/User:Conrad.Irwin Conrad Irwin]',
	'svn-date'       => '$LastChangedDate: 2008-08-13 08:39:09 +0200 (śro, 13 sie 2008) $',
	'svn-revision'   => '$LastChangedRevision: 39275 $',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:MetaKeywords',
	'description'    => 'Lets wikis add meta keywords depending on namespace',
	'descriptionmsg' => 'metakeywords-desc',
);

$wgExtensionMessagesFiles['MetaKeywords'] = dirname( __FILE__ ) . '/MetaKeywords.i18n.php';

$wgHooks['BeforePageDisplay'][] = 'wfMetaKeywordOutput';
$wgHooks['ArticleSaveComplete'][] = 'wfMetaKeywordClearCache';
$wgHooks['ParserFirstCallInit'][] = 'wfMetaKeywordLoadMessages';

//Load messages, seeing as wfLoadExtensionMessages isn't defined when the file is included.
function wfMetaKeywordLoadMessages ( ){
	wfLoadExtensionMessages ('MetaKeywords');
	return true;
}

//Adds customised keywords after the pagename of the <meta keywords> tag
function wfMetaKeywordOutput( &$out ){
	global $wgTitle, $wgMemc;
	$ns = $wgTitle->getNamespace();
	
	//Keywords
	$opts = $wgMemc->get( "metakeywords-opts" );
	if($opts === null ){ //Reload if not in cache
		$opts = wfMetaKeywordInput( 'keywords' );
	}
	$pagename = array_shift( $out->mKeywords );

	if( array_key_exists( $ns, $opts ) && $opts[$ns] ){ //Namespace specific keywords
		array_unshift( $out->mKeywords, $opts[$ns]);
	}elseif( array_key_exists( '*', $opts ) && $opts['*'] ){ //Global keywords
		array_unshift( $out->mKeywords, $opts['*']);
	}
	if( $pagename ){ //No pagename for special pages
		array_unshift( $out->mKeywords, $pagename );
	}
	//Descriptions
	$opts = $wgMemc->get( "metadescription-opts" );

	if($opts === null ){ //Reload if not in cache
		$opts = wfMetaKeywordInput( 'description' );
	}
	if( array_key_exists( $ns, $opts ) && $opts[$ns] ){ //Namespace specific descrption
		$out->addMeta('description',str_replace("$1", $pagename, $opts[$ns]));
	}elseif( array_key_exists( '*', $opts ) && $opts['*'] ){ //Otherwise global description
		$out->addMeta('description', str_replace("$1", $pagename, $opts['*']));
	}
	return true;
}

//Reads [[MediaWiki:Meta$page]]
function wfMetaKeywordInput( $type ){
	global $wgContLang, $wgMemc, $wgDBname;
	
	$params = wfMsgForContentNoTrans("meta$type");
	
	$opts = array(0);

	if (! wfEmptyMsg( "meta$type", $params ) ) {
		$opts = wfMetaKeywordParse($params);
	}
	return $opts;
}

//Parses the syntax, ignores things it does not understand
function wfMetaKeywordParse( $params ){
	global $wgContLang;
	$lines = preg_split( '/(\r\n|\r|\n)/', $params );
	$opts = array ();
	foreach( $lines as $l ){
		if( preg_match( '/^\s*([^#\|]*)\s*\|\s*(.*)\s*$/',$l,$m ) ){
		    $name = trim($m[1]);
			$ns=false;
			if($name == '(main)'){
				$ns=0;
			}elseif($name == '(all)'){
				$ns='*';
			}elseif(is_numeric($name)){ //a namespace number
				$ns=$name;
			}else{ //normal namespace name
				$ns = $wgContLang->getNsIndex($name);
			}
			if($ns !== false ){
				$opts[$ns] = trim($m[2]);
			}
		}
	}
	return $opts;
}

//Updates the cache if [[MediaWiki:Metakeywords]] or [[MediaWiki:Metadescription]] has been edited
function wfMetaKeywordClearCache( &$article, &$wgUser, &$text ) {
	global $wgMemc;
		$title = $article->mTitle;

		if( $title->getNamespace() == NS_MEDIAWIKI){
			$tt = $title->getText();
			if( $tt == 'metakeywords' || $tt == 'metadescription' ) {
				$opts = wfMetaKeywordParse( $text );
				$wgMemc->set($tt.'-opts',$opts,900);
			}
		}
		return true;
}
