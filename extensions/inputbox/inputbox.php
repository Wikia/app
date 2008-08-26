<?php

/**
 * This file contains the main include file for the Inputbox extension of 
 * MediaWiki. 
 *
 * Usage: Add the following line in LocalSettings.php:
 * require_once( "$IP/extensions/Inputbox/Inputbox.php" );
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
if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
	$wgHooks['ParserFirstCallInit'][] = 'efInputBoxSetup';
} else {
	$wgExtensionFunctions[] = 'efInputBoxSetup';
}
$wgExtensionCredits['parserhook'][] = array(
	'name'           => 'Inputbox',
	'author'         => array( 'Erik Moeller', 'Leonardo Pimenta', 'Rob Church' ),
	'svn-date'       => '$LastChangedDate: 2008-07-09 05:37:55 +0000 (Wed, 09 Jul 2008) $',
	'svn-revision'   => '$LastChangedRevision: 37366 $',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Inputbox',
	'description'    => 'Allow inclusion of predefined HTML forms.',
	'descriptionmsg' => 'inputbox-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Inputbox'] = $dir . 'InputBox.i18n.php';

/**
 * Extension setup function
 */
function efInputBoxSetup() {
	global $wgParser;
	$wgParser->setHook( 'inputbox', 'efInputBoxRender' );
	return true;
}

function efInputBoxRender( $input, $params, $parser ) {
	$inputbox = new Inputbox( $parser );
	$inputbox->extractOptions( $parser->replaceVariables( $input ) );
	return $inputbox->render();
}

class Inputbox {
	var $type, $width, $preload, $editintro, $br;
	var $defaulttext,$bgcolor,$buttonlabel,$searchbuttonlabel,$labeltext;
	var $hidden, $namespaces;

	function InputBox( &$parser ) {
		$this->parser =& $parser;
	}

	function render() {
		wfLoadExtensionMessages('Inputbox');
		switch( $this->type ) {
			case 'create':
			case 'comment':
				return $this->getCreateForm();
			case 'search':
				return $this->getSearchForm();
			case 'search2':
				return $this->getSearchForm2();
			default:
				$message = strlen( $this->type ) > 0
					? htmlspecialchars( wfMsgForContent( 'inputbox-error-bad-type', $this->type ) )
					: htmlspecialchars( wfMsgForContent( 'inputbox-error-no-type' ) );
				return "<div><strong class=\"error\">{$message}</strong></div>";
		}
	}

	function getSearchForm() {
		global $wgContLang;
		$search = SpecialPage::getTitleFor( 'Search' )->escapeLocalUrl();
		
		if(!$this->buttonlabel) {
			$this->buttonlabel = wfMsgHtml( 'tryexact' );
		}
		if(!$this->searchbuttonlabel) {
			$this->searchbuttonlabel = wfMsgHtml( 'searchfulltext' );
		}

		$buttonlabel = htmlspecialchars( $this->buttonlabel );
		$searchbuttonlabel = htmlspecialchars( $this->searchbuttonlabel );
		$defaulttext = htmlspecialchars( $this->defaulttext );
		$bgcolor = htmlspecialchars( $this->bgcolor );

		$type = $this->hidden ? 'hidden' : 'text';
		$searchform=<<<ENDFORM
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
		<td align="center" bgcolor="{$bgcolor}">
		<form name="searchbox" action="{$search}" class="searchbox">
		<input class="searchboxInput" name="search" type="{$type}"
		value="{$defaulttext}" size="{$this->width}" />{$this->br}
ENDFORM;

		// disabled when namespace filter active
		$gobutton=<<<ENDGO
<input type='submit' name="go" class="searchboxGoButton" value="{$buttonlabel}" />&nbsp;
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
		<input type='submit' name="fulltext" class="searchboxSearchButton" value="{$searchbuttonlabel}" />
		</form>
		</td>
		</tr>
		</table>
ENDFORM2;
		//Return form values
		return $searchform . $searchform2 . $searchform3;
	}

	function getSearchForm2() {
		$search = SpecialPage::getTitleFor( 'Search' )->escapeLocalUrl();

		if(!$this->buttonlabel) {
			$this->buttonlabel = wfMsgHtml( 'tryexact' );
		}

		$buttonlabel = htmlspecialchars( $this->buttonlabel );
		$searchbuttonlabel = htmlspecialchars( $this->searchbuttonlabel );
		$id = Sanitizer::escapeId( $this->id );

		$label = '';
		$styles = '';

		$buttonlabel = htmlspecialchars( $this->buttonlabel );
		$searchbuttonlabel = htmlspecialchars( $this->searchbuttonlabel );
		$id = Sanitizer::escapeId( $this->id );

		if ( isset($this->labeltext) && strlen(trim($this->labeltext)) ) {
			$output = $this->parser->parse( $this->labeltext,
				$this->parser->getTitle(), $this->parser->getOptions(), false, false );
			$this->labeltext = $output->getText();
			$this->labeltext = str_replace('<p>', '', $this->labeltext);
			$this->labeltext = str_replace('</p>', '', $this->labeltext);
			$label = "<label for=\"bodySearchIput{$id}\">{$this->labeltext}</label>";
		}

		if ($this->inline) {
			$styles .= 'display: inline;';
		}

		if ($styles) {
			$styles = 'style="'.htmlspecialchars($styles).'"';
		}

		$type = $this->hidden ? 'hidden' : 'text';
		$searchform=<<<ENDFORM
<form action="$search" class="bodySearch" {$styles} id="bodySearch{$id}"><div class="bodySearchWrap" {$styles}>{$label}<input type="{$type}" name="search" size="{$this->width}" class="bodySearchIput" id="bodySearchIput{$id}" /><input type="submit" name="go" value="{$buttonlabel}" class="bodySearchBtnGo" />
ENDFORM;

		if ( !empty( $this->fulltextbtn ) ) // this is wrong...
			$searchform .= '<input type="submit" name="fulltext" class="bodySearchBtnSearch" value="{$searchbuttonlabel}" />';

		$searchform .= '</div></form>';

		return $searchform;
	}


	function getCreateForm() {
		global $wgScript;	

		$action = htmlspecialchars( $wgScript );
		if($this->type=="comment") {
			$comment="<input type=\"hidden\" name=\"section\" value=\"new\" />\n\t";
			if(!$this->buttonlabel) {
				$this->buttonlabel = wfMsgHtml( "postcomment" );
			}
		} else {
			$comment='';
			if(!$this->buttonlabel) {			
				$this->buttonlabel = wfMsgHtml( 'createarticle' );
			}
		}

		$bgcolor = htmlspecialchars( $this->bgcolor );
		$preload = htmlspecialchars( $this->preload );
		$editintro = htmlspecialchars( $this->editintro );
		$defaulttext = htmlspecialchars( $this->defaulttext );
		$buttonlabel = htmlspecialchars( $this->buttonlabel );

		$type = $this->hidden ? 'hidden' : 'text';
		$createform=<<<ENDFORM
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr>
<td align="center" bgcolor="{$bgcolor}">
<form name="createbox" action="$action" method="get" class="createbox">
	<input type='hidden' name="action" value="edit" />
	<input type="hidden" name="preload" value="{$preload}" />
	<input type="hidden" name="editintro" value="{$editintro}" />
	{$comment}<input class="createboxInput" name="title" type="{$type}"
	value="{$defaulttext}" size="{$this->width}" />{$this->br}
	<input type='submit' name="create" class="createboxButton"
	value="{$buttonlabel}" />
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
	 * Validate the width; make sure it's a valid, positive integer
	 */
	function checkWidth() {
		$this->width = intval( $this->width );
		if( $this->width <= 0 )
			$this->width = 50;
	}

	/**
	 * Extract options from a blob of text
	 *
	 * @param string $text Tag contents
	 */
	public function extractOptions( $text ) {
		wfProfileIn( __METHOD__ );

		// Parse all possible options
		$values = array();
		foreach( explode( "\n", $text ) as $line ) {
			if( strpos( $line, '=' ) === false )
				continue;
			list( $name, $value ) = explode( '=', $line, 2 );
			$values[ strtolower( trim( $name ) ) ] = trim( $value );
		}

		// Go through and set all the options we found
		$options = array(
			'type' => 'type',
			'width' => 'width',
			'preload' => 'preload',
			'editintro' => 'editintro',
			'default' => 'defaulttext',
			'bgcolor' => 'bgcolor',
			'buttonlabel' => 'buttonlabel',
			'searchbuttonlabel' => 'searchbuttonlabel',
			'namespaces' => 'namespaces',
			'id' => 'id',
			'labeltext' => 'labeltext',
			'break' => 'br',
			'hidden' => 'hidden',
			'inline' => 'inline',
		);
		foreach( $options as $name => $var ) {
			if( isset( $values[$name] ) )
				$this->$var = $values[$name];
		}

		// Some special-case fix-ups
		$this->lineBreak();
		$this->checkWidth();

		wfProfileOut( __METHOD__ );
	}

}
