<?php

/**
 * This file contains the main include file for the Inputbox extension of
 * MediaWiki.
 *
 * Usage: require_once("path/to/inputbox.php"); in LocalSettings.php
 *
 * This extension requires MediaWiki 1.5 or higher.
 *
 * @author Erik Moeller <moeller@scireview.de>
 *  namespaces search improvements partially by
 *  Leonardo Pimenta <leo.lns@gmail.com>
 * @copyright Public domain
 * @license Public domain
 * @version 0.1.1
 */

/**
 * Register the Inputbox extension with MediaWiki
 */
$wgExtensionFunctions[] = 'registerInputboxExtension';
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Inputbox',
	'author' => 'Erik Moeller',
	'url' => 'http://meta.wikimedia.org/wiki/Help:Inputbox',
	'description' => 'Allow inclusion of predefined HTML forms.',
);

$dir = dirname(__FILE__);
include("$dir/create.php");

$wgExtensionMessagesFiles['Inputbox'] = $dir . '/inputbox.i18n.php';

/**
 * Sets the tag that this extension looks for and the function by which it
 * operates
 */
function registerInputboxExtension()
{
    global $wgParser, $wgHooks;
    $wgParser->setHook('inputbox', 'renderInputbox');
    // #3483
    // @see http://www.mediawiki.org/wiki/Manual:Tag_extensions#How_can_I_avoid_modification_of_my_extension.27s_HTML_output.3F
    $wgHooks['ParserAfterTidy'][] = 'renderInputboxAfterTidy';
}

/**
 * Renders an inputbox based on information provided by $input.
 */
function renderInputbox($input, $params, &$parser)
{
	global $wgInputBoxMarkers;

	$inputbox=new Inputbox( $parser );
	getBoxOption($inputbox->type,$input,'type');
	getBoxOption($inputbox->width,$input,'width',true);
	getBoxOption($inputbox->prefix,$input,'prefix');
	getBoxOption($inputbox->preload,$input,'preload');
	getBoxOption($inputbox->editintro,$input,'editintro');
	getBoxOption($inputbox->defaulttext,$input,'default');
	getBoxOption($inputbox->bgcolor,$input,'bgcolor');
	getBoxOption($inputbox->buttonlabel,$input,'buttonlabel');
	getBoxOption($inputbox->searchbuttonlabel,$input,'searchbuttonlabel');
	getBoxOption($inputbox->namespaces,$input,'namespaces');
	getBoxOption($inputbox->id,$input,'id');
	getBoxOption($inputbox->labeltext,$input,'labeltext');
	getBoxOption($inputbox->br, $input, 'break');
	getBoxOption($inputbox->hidden, $input, 'hidden');
	$inputbox->lineBreak();
	$inputbox->checkWidth();

	$boxhtml=$inputbox->render();
	# Maybe support other useful magic words here
	$boxhtml=str_replace("{{PAGENAME}}",$parser->getTitle()->getText(),$boxhtml);

	if($boxhtml) {
		// #3483: return marker and save actual content
		$markerId=count($wgInputBoxMarkers);
		$wgInputBoxMarkers[$markerId]=$boxhtml;
		return "xx-inputboxmarker-$markerId-xx";
	} else {
		return '<div><strong class="error">Input box: type not defined.</strong></div>';
	}
}

/**
 * Find markers and replace them with actual output
 */
function renderInputboxAfterTidy(&$parser, &$text) {
	global $wgInputBoxMarkers;

	for ($m=0; $m<count($wgInputBoxMarkers); $m++) {
		$text=preg_replace('/xx-inputboxmarker-'.$m.'-xx/', $wgInputBoxMarkers[$m], $text);
	}
	return true;
}

function getBoxOption(&$value,&$input,$name,$isNumber=false) {

      if(preg_match("/^\s*$name\s*=\s*(.*)/mi",$input,$matches)) {
		if($isNumber) {
			$value=intval($matches[1]);
		} else {
			$value=htmlspecialchars($matches[1]);
		}
	}
}

class Inputbox {
	var $type,$width,$prefix,$preload,$editintro, $br;
	var $defaulttext,$bgcolor,$buttonlabel,$searchbuttonlabel;
	var $hidden;

	function InputBox( &$parser ) {
		$this->parser =& $parser;
	}

	function render() {
		wfLoadExtensionMessages('Inputbox');
		if($this->type=='create' || $this->type=='comment') {
			return $this->getCreateForm();
		} elseif($this->type=='search') {
			return $this->getSearchForm();
		} elseif($this->type=='search2') {
			return $this->getSearchForm2();
		} else {
			return false;
		}
	}
	function getSearchForm() {
		global $wgUser, $wgContLang;

		$sk=$wgUser->getSkin();
		$searchpath = $sk->escapeSearchLink();
		if(!$this->buttonlabel) {
			$this->buttonlabel = wfMsgHtml( 'tryexact' );
		}
		if(!$this->searchbuttonlabel) {
			$this->searchbuttonlabel = wfMsgHtml( 'searchfulltext' );
		}


		$type = $this->hidden ? 'hidden' : 'text';
		$searchform=<<<ENDFORM
		<table border="0" width="100%" cellspacing="0" cellpadding="0" class="inputBox inputBoxSearchForm">
		<tr>
		<td align="center" bgcolor="{$this->bgcolor}">
		<form name="searchbox" action="$searchpath" class="searchbox">
		<input type="hidden" name="searchx" value="Search" />
		<input class="searchboxInput" name="search" type="{$type}"
		value="{$this->defaulttext}" size="{$this->width}" />{$this->br}
ENDFORM;

		// disabled when namespace filter active
		$gobutton=<<<ENDGO
<input type='submit' name="go" class="searchboxGoButton" value="{$this->buttonlabel}" />&nbsp;
ENDGO;
		// Determine namespace checkboxes
		$namespaces = $wgContLang->getNamespaces();
		$namespacesarray = explode(",",$this->namespaces);

		// Test if namespaces requested by user really exist
		$searchform2 = '';
		if ($this->namespaces) {
			foreach ($namespacesarray as $usernamespace) {
				$checked = '';
				// Namespace needs to be checked if flagged with "**" or if it's the only one
				if (strstr($usernamespace,'**') || count($namespacesarray)==1) {
                                        $usernamespace = str_replace("**","",$usernamespace);
                                        $checked =" checked";
                                }
				foreach ( $namespaces as $i => $name ) {
					if ($i < 0){
						continue;
					}elseif($i==0) {
						$name='Main';
					}
					if ($usernamespace == $name) {
						$searchform2 .= "<input type=\"checkbox\" name=\"ns{$i}\" value=\"1\"{$checked}>{$usernamespace}";
					}
				}
			}
			//Line feed
			$searchform2 .= $this->br;
			//If namespaces are defined remove the go button
			//because go button doesn't accept namespaces parameters
			$gobutton='';
		}
		$searchform3=<<<ENDFORM2
		{$gobutton}
		<input type='submit' name="fulltext" class="searchboxSearchButton" value="{$this->searchbuttonlabel}" />
		</form>
		</td>
		</tr>
		</table>
ENDFORM2;
		//Return form values
		return $searchform . $searchform2 . $searchform3;
	}

	function getSearchForm2() {
		global $wgUser;

		$sk=$wgUser->getSkin();
		$searchpath = $sk->escapeSearchLink();
		if(!$this->buttonlabel) {
			$this->buttonlabel = wfMsgHtml( 'tryexact' );
		}

		$output = $this->parser->parse( $this->labeltext,
			$this->parser->getTitle(), $this->parser->getOptions(), false, false );
		$this->labeltext = $output->getText();
		$this->labeltext = str_replace('<p>', '', $this->labeltext);
		$this->labeltext = str_replace('</p>', '', $this->labeltext);

		$type = $this->hidden ? 'hidden' : 'text';
		$searchform=<<<ENDFORM
<form action="$searchpath" class="bodySearch" id="bodySearch{$this->id}"><div class="bodySearchWrap"><label for="bodySearchIput{$this->id}">{$this->labeltext}</label><input type="{$type}" name="search" size="{$this->width}" class="bodySearchIput" id="bodySearchIput{$this->id}" /><input type="submit" name="go" value="{$this->buttonlabel}" class="bodySearchBtnGo" />
ENDFORM;

		if ( !empty( $this->fulltextbtn ) ) // this is wrong...
			$searchform .= '<input type="submit" name="fulltext" class="bodySearchBtnSearch" value="{$this->searchbuttonlabel}" />';

		$searchform .= '</div></form>';

		return $searchform;
	}


	function getCreateForm() {
		global $wgScript;

		$action = htmlspecialchars( $wgScript );
		if($this->type=="comment") {
			$comment='<input type="hidden" name="section" value="new" />';
			if(!$this->buttonlabel) {
				$this->buttonlabel = wfMsgHtml( "postcomment" );
			}
		} else {
			$comment='';
			if(!$this->buttonlabel) {
				$this->buttonlabel = wfMsgHtml( "createarticle" );
			}
		}
		$type = $this->hidden ? 'hidden' : 'text';
		$createform=<<<ENDFORM
<table border="0" width="100%" cellspacing="0" cellpadding="0" class="inputBox inputBoxCreateForm">
<tr>
<td align="center" bgcolor="{$this->bgcolor}">
<form name="createbox" action="$action" method="get" class="createbox">
	<input type='hidden' name="action" value="create" />
	<input type="hidden" name="prefix" value="{$this->prefix}" />
	<input type="hidden" name="preload" value="{$this->preload}" />
	<input type="hidden" name="editintro" value="{$this->editintro}" />
	{$comment}
	<input class="createboxInput" name="title" type="{$type}"
	value="{$this->defaulttext}" size="{$this->width}" />{$this->br}
	<input type='submit' name="create" class="createboxButton"
	value="{$this->buttonlabel}" />
</form>
</td>
</tr>
</table>
ENDFORM;
		return $createform;
	}

	function lineBreak() {
		# Should we be inserting a <br /> tag?
		$cond = ( strtolower( $this->br ) == "no" );
		$this->br = $cond ? '' : '<br />';
	}

	/**
	 * If the width is not supplied, set it to 50
	 */
	function checkWidth() {
		if( !$this->width || trim( $this->width ) == '' )
			$this->width = 50;
	}
}
?>
