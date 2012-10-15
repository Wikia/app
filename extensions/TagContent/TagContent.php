<?php
//
// TagContent MediaWiki extension.
// Translate from tags to parser functions.
// 
// Copyright (C) 2009 - John Erling Blad.
//
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//

# Not a valid entry point, skip unless MEDIAWIKI is defined
if( !defined( 'MEDIAWIKI' ) ) {
	echo "TagContent: This is an extension to the MediaWiki package and cannot be run standalone.\n";
	die( -1 );
}

#----------------------------------------------------------------------------
#    Extension initialization
#----------------------------------------------------------------------------
 
$TagContentVersion = '0.2';
$wgExtensionCredits['parserhook'][] = array(
	'name'=>'TagContent',
	'version'=>$TagContentVersion,
	'author'=>'John Erling Blad',
	'url'=>'http://www.mediawiki.org/wiki/Extension:TagContent',
	'description' => 'Translate from tags to parser functions'
);
 
$wgHooks['ParserFirstCallInit'][] = 'efTagContentSetHooks';
$wgExtensionMessagesFiles['TagContent'] = dirname(__FILE__) . '/TagContent.i18n.php';

$egTagContentDefine = array(
);

$egTagContentBlacklist = array(

	// mediawiki
	'noinclude' => true,    'includeonly' => true,  'onlyinclude' => true,  'gallery' => true,

	// html tags
	'address' => true,      'applet' => true,       'area' => true,         'a' => true,
	'base' => true,         'basefont' => true,     'big' => true,          'blockquote' => true,
	'body' => true,         'br' => true,           'b' => true,            'caption' => true,
	'center' => true,       'cite' => true,         'code' => true,         'dd' => true,
	'dfn' => true,          'dir' => true,          'div' => true,          'dl' => true,
	'dt' => true,           'em' => true,           'font' => true,         'form' => true,
	'h1' => true,           'h2' => true,           'h3' => true,           'h4' => true,
	'h5' => true,           'h6' => true,           'head' => true,         'hr' => true,
	'html' => true,         'img' => true,          'input' => true,        'isindex' => true,
	'i' => true,            'kbd' => true,          'link' => true,         'li' => true,
	'map' => true,          'menu' => true,         'meta' => true,         'ol' => true,
	'option' => true,       'param' => true,        'pre' => true,          'p' => true,
	'samp' => true,         'script' => true,       'select' => true,       'small' => true,
	'strike' => true,       'strong' => true,       'style' => true,        'sub' => true,
	'sup' => true,          'table' => true,        'td' => true,           'textarea' => true,
	'th' => true,           'title' => true,        'tr' => true,           'tt' => true,
	'ul' => true,           'u' => true,            'var' => true,

);

class TagContent {
	private $mParms = null;                 # hash
	private $mTemplate = null;              # string
	private static $mDefinitions = null;    # Title
	private $mTag = null;                   # string
	private $mChangeable = false;           # boolean
	private $mTitle = null;                 # Title

	/**
	* Contructor for the TagContent class
	* @param $tag Name of the new tag, that is the 
	* @param $template Optional name of the template to use during rendering
	* @param $params Optional default parameters
	* @param $changable
	*/
	public function TagContent( $tag, $template=null, &$params=null, $changeable=false ) {
		if ($params) {
			$h = array();
			$p = explode('|', htmlspecialchars($params));
			$n = 1;
			foreach ($p as $item) {
				if (false === strrpos($item, '=')) {
					$item = $n++ . '=' . $item;
				}
				list($k, $v) = explode('=', $item, 2);
				$h[trim($k)] = $v;
			}
			$this->mParms = $h;
		}
		$this->mTag = $tag;
		$this->mTemplate = htmlspecialchars($template);
		$this->mChangeable = $changeable;
	}

	/**
	* Accessor function for changeable
	* @param $val If set the new value for the changable attribute
	* @return The existing or new value if it is set
	*/
	public function changeable ( $val ) {
		if (isset($val)) {
			$this->mChangeable = $val;
		}
		return $this->mChangeable;
	}

	/**
	* Local reimplementation of addLink
	* @param $parser Reference to the parser instance
	* @param $title Title of the additional link
	*/
	private function addLink( &$parser, &$title ) {
		if (!$title) {
			throw new Exception( 'none' );
		}
		$lc = LinkCache::singleton();
		$pdbk = $title->getPrefixedDBkey();
		if ( 0 != ( $id = $lc->getGoodLinkID( $pdbk ) ) ) {
			$parser->mOutput->addLink( $title, $id );
		}
		elseif ( $lc->isBadLink( $pdbk ) ) {
			$parser->mOutput->addLink( $title, 0 );
			throw new Exception( $title->getPrefixedText() );
		}
		else {
			$id = $title->getArticleID();
			$parser->mOutput->addLink( $title, $id );
			if (!$id) {
				throw new Exception( $title->getPrefixedText() );
			}
		}
	}

	/**
	* Callback function for inserting our own rendering
	* @param $text Content for the tag call
	* @param $params Parameters for the tag call
	* @param $parser Reference to the parser instance
	* @return Replaced content wrapped in a recursive call
	*/
	public function onRender ( $text, $params, &$parser ) {
		if ($this->mChangeable) {
			if (!$this->mDefinitions) {
				$this->mDefinitions = Title::newFromText("Mediawiki:tags-definition");
			}
			try {
				$this->addLink($parser, $this->mDefinitions);
			}
			catch (Exception $e) {
				return $parser->recursiveTagParse( wfMsg( 'tags-definitions-unknown', $e->getMessage() ) );
			}
		}
		if (!$this->mTitle) {
			$this->mTitle = Title::newFromText($this->mTemplate);
		}
		try {
			$this->addLink($parser, $this->mTitle);
		}
		catch (Exception $e) {
			return $parser->recursiveTagParse( wfMsg( 'tags-template-unknown', $e->getMessage() ) );
		}
		$cont = array($this->mTemplate, $text);
		foreach ($this->mParms as $k => $v) {
			if (isset($params[$k])) {
				$cont[] = "$k=$params[$k]";
			}
			else {
				$cont[] = "$k=$v";
			}
		}
		foreach ($params as $k => $v) {
			if (!isset($this->mParms[$k])) {
				$cont[] = "$k=$v";
			}
		}
		$output = '{{' . implode('|', $cont) . '}}';
		return $parser->recursiveTagParse($output);
	}
}

/**
* Setup function for the extension
@return True is returned unconditionally
*/
function efTagContentSetHooks( $parser ) {
	global $egTagContentBlacklist, $egTagContentDefine;
	
	foreach ($egTagContentDefine as $k => $a) {
		$template = $a[0];
		$tag = strtolower($k);
		$c = new TagContent($tag, $template, $a[1], false);
		$parser->setHook( $tag, array( $c, 'onRender' ));
	}
	$defs = explode("\n", wfMsgNoTrans( 'tags-definition' ));
	foreach ($defs as $line) {
		if ('*' == substr($line, 0, 1)) {
			$line = ltrim($line, '*');
			$a = explode('|', $line, 3);
			$template = trim($a[1]);
			$tag = strtolower(trim($a[0]));
			if ( !$egTagContentBlacklist[$tag] && !isset($egTagContentDefine[$tag])) {
				$c = new TagContent($tag, $template, $a[2], true);
				$parser->setHook( $tag, array( $c, 'onRender' ));
			}
		}
	}
	return true;
}


