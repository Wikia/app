<?php
/** --------------------------------------------
 === MediaWiki Extension: Add Article to Category 2 ===
 * @file
 * @ingroup Extensions
 * @version 1.0
 * @author Liang Chen <anything@liang-chen.com> (original code)
 * @author Julien Devincre (exclude categories)
 * @author Cynthia Mattingly - Marketing Factory Consulting (i18n, adding category)
 * @author Mikael Lindmark <mikael.lindmark@ladok.umu.se> (category adding optional, input check)
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 3.0 or later
 
	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.
 
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
 
	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
	 
--------------------------------------------*/

/**
 *  Protect against register globals vulnerabilities.
 *  This line must be present before any global variable is referenced.
 */
if ( !defined('MEDIAWIKI') ) {
	echo <<<HEREDOC
To install the ArticleToCategory2 extension, put the following line in LocalSettings.php:<P>
require_once( "\$IP/extensions/ArticleToCategory2/ArticleToCategory2.php" );<br>
\$wgarticletocategory2ConfigBlacklist=false;<br>
\$wgGroupPermissions['*']['ArticleToCategory2'] = true;<br>
\$wgGroupPermissions['*']['ArticleToCategory2AddCat'] = false;<br>

HEREDOC;
	exit( 1 );
}

/** Set default values on configutation variables **/
$wgarticletocategory2ConfigBlacklist=false;
/* Set default 'true' for add article to category */
$wgGroupPermissions['*']['ArticleToCategory2'] = true;
/* Set default 'false' for add category to category */
$wgGroupPermissions['*']['ArticleToCategory2AddCat'] = false;
 
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Add Article to Category 2',
	'descriptionmsg' => 'articletocategory2-desc',
	'version' => '1.0',
	'author' => array(
		'[http://www.mediawiki.org/wiki/User:BiGreat Liang Chen \'BiGreat\'] (original code)',
		'Julien Devincre (exclude categories)',
		'[http://www.mediawiki.org/wiki/User:Cm Cynthia Mattingly] (i18n, adding category)',
		'[http://www.mediawiki.org/wiki/User:MikaelLindmark Mikael Lindmark] (adding options, input check)'),
	'url' => 'https://www.mediawiki.org/wiki/Extension:ArticleToCategory2'
);

/*** Hook functions ***/
$wgHooks['EditFormPreloadText'][] = 'wfAddCategory';
$wgHooks['CategoryPageView'][] = 'wfCategoryChange';
 
$dir = dirname(__FILE__) . '/';
 
/*** Internationalisation ***/
$wgExtensionMessagesFiles['ArticleToCategory2'] = $dir . 'ArticleToCategory2.i18n.php';


 
/******************************
 * Add category to the new page
 * The category name is escaped to prevent JavaScript injection
 *
 * @param string $text The text to prefill edit form with
 * @return bool true
 ******************************/
function wfAddCategory( &$text ) {
	global $wgContLang;

	if ( array_key_exists( 'category', $_GET ) && array_key_exists( 'new', $_GET )) {
		$cname =  $_GET['category'];
		if ( $_GET['new'] == 1 ) {
			$text = "\n\n[[" . $wgContLang->getNsText( NS_CATEGORY ) . ":" .
			       	htmlspecialchars( $cname ) . "]]";
		}
	}
	return true;
}
 
/******************************
 * Function to get the excluded categories list (blacklist)
 * the list is retrieved from Add Article to Category 2 excluded categories page.
 *
 * @return string $excludedCategories
 ******************************/
function getExcludedCategories() {
	global $wgRequest;

	$excludedCategories = array();
	$specialcatpage='Add Article to Category 2 excluded categories';

	if ( $wgRequest->getVal( 'action' ) == 'edit' ) {
		return true;
	}
	$rev = Revision::newFromTitle( Title::makeTitle( 8, $specialcatpage ) );
	if ( $rev ) {
		$content = $rev->getText();
		if ( $content != "" ) {
			$changed = false;
			$c = explode( "\n", $content );
			foreach ( $c as $entry ) {
				if ( $entry[0]==';' ) {
					$cat = trim( substr( $entry, 1 ) );
					$excludedCategories[] = $cat;
				}
			}
 
		}
	} else {
		echo (" Page : \"" . $specialcatpage . "\" does not exist !");
	}
	return $excludedCategories;
}
 
/******************************
 * Generate the input box
 *
 * @param string $catpage The category article
 * @return bool true to do the default behavior of CategoryPage::view
 ******************************/
function wfCategoryChange( $catpage ) {
	global $wgarticletocategory2ConfigBlacklist, $wgarticletocategory2ConfigAddcat,
		$wgOut, $wgScript, $wgContLang, $wgUser;

	$action = htmlspecialchars( $wgScript );
	if ( !$catpage->mTitle->quickUserCan( 'edit' )
		|| !$catpage->mTitle->quickUserCan( 'create')
		|| !$wgUser->isAllowed( 'ArticleToCategory2') )
	{
		return true;
	}
	if ( $wgarticletocategory2ConfigBlacklist ) {
		$excludedCategories=getExcludedCategories();
		foreach ($excludedCategories as $value) {
			if ( $catpage->mTitle->getText() == $value ) {
				return true;
			}
		}
	}

	$boxtext  = wfMsg( 'articletocategory2-create-article-under-category-text' );
	$btext =    wfMsg( 'articletocategory2-create-article-under-category-button' );
	$boxtext2 = wfMsg( 'articletocategory2-create-category-under-category-text' );
	$btext2 =   wfMsg( 'articletocategory2-create-category-under-category-button' );
 
	$cattitle = $wgContLang->getNsText( NS_CATEGORY );
 
	/*** javascript blocks ***/
	$formstart=<<<FORMSTART
<!-- Add Article Extension Start -->
<script type="text/javascript">
function clearText(thefield) {
	if (thefield.defaultValue==thefield.value)
		thefield.value = ""
}
function addText(thefield) {
	if (thefield.value=="")
		thefield.value = thefield.defaultValue
}
 
function addTextTitle(thefield) {
	if (thefield.value=="") {
		thefield.value = thefield.defaultValue;
	} else {
		thefield.value = '{$cattitle}:'+thefield.value;
	}
}
 
function isemptyx(form) {
	if (form.title.value=="" || form.title.value==form.title.defaultValue) {
		<!-- alert(.title.value); -->
		return false;
	}
	return true;
}
</script>
 
<table border="0" align="right" width="423" cellspacing="0" cellpadding="0">
	<tr>
	<td width="100%" align="right" bgcolor="">
	<form name="createbox" action="{$action}" onsubmit="return isemptyx(this);" method="get" class="createbox">
		<input type='hidden' name="action" value="edit">
		<input type='hidden' name="new" value="1">
		<input type='hidden' name="category" value="{$catpage->mTitle->getText()}">
 
		<input class="createboxInput" name="title" type="text" value="{$boxtext}" size="38" style="color:#666;" onfocus="clearText(this);" onblur="addText(this);"/>
		<input type='submit' name="create" class="createboxButton" value="{$btext}"/>
	</form>
FORMSTART;
	$formcategory=<<<FORMCATEGORY
	<form name="createbox" action="{$action}" onsubmit="return isemptyx(this);" method="get" class="createbox">
		<input type='hidden' name="action" value="edit">
		<input type='hidden' name="new" value="1">
		<input type='hidden' name="category" value="{$catpage->mTitle->getText()}">
 
		<input class="createboxInput" name="title" type="text" value="{$boxtext2}" size="38" style="color:#666;" onfocus="clearText(this);" onblur="addTextTitle(this);"/>
		<input type='submit' name="create" class="createboxButton" value="{$btext2}"/>
	</form>
FORMCATEGORY;
	$formend=<<<FORMEND
	</td>
	</tr>
</table>
<!-- Add Article Extension End -->
FORMEND;
	/*** javascript blocks end ***/
	$wgOut->addHTML( $formstart );
	if ( $wgUser->isAllowed( 'ArticleToCategory2AddCat' ) ) {
		$wgOut->addHTML( $formcategory );
	}
	$wgOut->addHTML( $formend );
	return true;
}
