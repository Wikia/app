<?php
/* vim: noet ts=4 sw=4
 * http://www.mediawiki.org/wiki/Extension:Uniwiki_Layouts
 * http://www.gnu.org/licenses/gpl-3.0.txt */

if ( !defined( 'MEDIAWIKI' ) )
	die();

$wgExtensionCredits['other'][] = array(
	'name'           => 'Layouts',
	'author'         => 'Merrick Schaefer, Mark Johnston, Evan Wheeler and Adam Mckaig (at UNICEF)',
	'description'    => 'Populate newly-created pages with editable "layouts" to encourage a common structure for pages',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Uniwiki_Layouts',
	'svn-date'       => '$LastChangedDate: 2009-03-13 21:00:23 +0100 (ptk, 13 mar 2009) $',
	'svn-revision'   => '$LastChangedRevision: 48387 $',
	'descriptionmsg' => 'layouts-desc',
);

$wgExtensionMessagesFiles['Layouts'] = dirname( __FILE__ ) . '/Layouts.i18n.php';

/* ---- CONFIGURABLE OPTIONS ---- */

$wgAddLayoutLink = true;
$wgLayoutWhiteList = array( NS_MAIN );
$wgLayoutCategories = false;
$wgLayoutUseCategoryPage = true;
$wgLayoutCategoryNSWhiteList = array( NS_MAIN );
$wgNoLayoutOption = true;

/* ---- NAMESPACES ---- */

/* assign constants to number our namespaces if they
 * haven't already been defined (in localsettings) */
if ( !defined ( "NS_LAYOUT" ) )      define ( "NS_LAYOUT",      100 ); # even = content
if ( !defined ( "NS_LAYOUT_TALK" ) ) define ( "NS_LAYOUT_TALK", 101 ); # odd  = discussion

// create the namespaces
$wgExtraNamespaces[NS_LAYOUT]      = "Layout";
$wgExtraNamespaces[NS_LAYOUT_TALK] = "Layout_talk";

# only sysops can edit the layouts
$wgNamespaceProtection[NS_LAYOUT] = array ( "editlayouts" );
$wgGroupPermissions['sysop']['editlayouts'] = true;


/* ---- TAGS ---- */

$wgExtensionFunctions[] = "UW_Layouts_EF";
function UW_Layouts_EF() {
	global $wgParser;
	$wgParser->setHook ( "layout", "UW_Layouts_EF_Render" );
}

/* render a note to display the name of the
 * layout that this page was created from */
function UW_Layouts_EF_Render ( $input, $args, $parser ) {
	// wfLoadExtensionMessages( 'Layouts' );
	// $name = isset($args['name']) ? Title::newFromURL("Layout:".$args['name'])->getText() : wfMsg('layouts_unknown');
	// return "<div class='layout-name'><p>".wfMsg('layouts_tagline', $name)."</p></div>";
	return "";
}

/* ---- HOOKS ---- */
$wgHooks['CustomEditor'][] = "UW_Layouts_maybeRedirectToLayout";
$wgHooks['UnknownAction'][] = "UW_Layouts_checkActionIsLayout";
$wgHooks['SkinTemplateSetupPageCss'][] = "UW_Layouts_Css";
$wgHooks['EditFormPreloadText'][] = "UW_Layouts_preFillTextBox";

function UW_Layouts_maybeRedirectToLayout( $article, $user ) {
	global $wgOut, $wgRequest, $wgLayoutWhiteList;

	/* bug fixes from Tom Maaswinkel -- thanks Tom!
	 * http://www.mediawiki.org/w/index.php?title=Extension:Uniwiki_Layouts&oldid=213030#Bug_Fix
	 * http://www.mediawiki.org/w/index.php?title=Extension:Uniwiki_Layouts&oldid=213030#Bug_fix_2 */

	/* don't hijack the request if we are
	 * in the middle of switching modes,
	 * previewing,  or showing changes */
	if ( isset( $wgRequest->data['switch-mode'] )
	|| isset( $wgRequest->data['wpTextbox1'] )
	|| isset( $wgRequest->data['section-0'] ) )
		return true;

	/* if this page is new,
	 * no layout variable is in the query string,
	 * and the page is in a namespace that is using the extension
	 * and we are not submitting the form (either saving OR preview)
	 * and we're NOT editing an old revision */
	if ( $article->getID() === 0 
	&& ( !isset( $wgRequest->data['oldid'] ) || $article->fetchContent( $wgRequest->data['oldid'] ) === false )
	&& ( $wgRequest->getVal ( "layout" ) === NULL )
	&& in_array ( $article->mTitle->getNamespace(), $wgLayoutWhiteList )
	&& ( $wgRequest->getVal( "action" ) != "submit" ) )

		// redirect to the "pick a layout" page!
		$wgOut->redirect( $article->mTitle->getInternalUrl ( "action=layout" ) );

	return true;
}

function UW_Layouts_checkActionIsLayout( $action, $article ) {
	global $wgOut, $wgDBprefix, $wgLayoutCategories, $wgLayoutUseCategoryPage,
		$wgNoLayoutOption, $wgContLang,
		$wgLayoutCategoryNSWhiteList;

	// not layout = do nothing
	if ( $action != "layout" )
		return true;

	/* if this page already exists, or
	 * is a discussion page, redirect
	 * to the regular edit page */
	if ( $article->fetchContent() !== false
	|| ( $article->mTitle->getNamespace() % 2 ) ) {
		$wgOut->redirect( $article->mTitle->getInternalUrl ( "action=edit" ) );
		return false;
	}

	// pluck out the bits that we need from mTitle
	$title = $article->mTitle->getPrefixedText();
	$url   = $article->mTitle->getInternalUrl();
	$name  = $article->mTitle->getPrefixedURL();
	$namespace = $article->mTitle->getNamespace();

	wfLoadExtensionMessages( 'Layouts' );

	$wgOut->setPageTitle ( wfMsg ( "layouts_title" ) );

	/* fetch all articles/pages in the NS_LAYOUT namespace
	 * by directly querying the database. mediawiki doesn't
	 * provide any OO way of doing this :( */
	$db = wfGetDB( DB_MASTER );
	$layouts = $db->resultObject ( $db->query ( "select * from {$wgDBprefix}page where page_namespace=" . NS_LAYOUT . " order by page_title" ) );

	$wgOut->addHTML ( wfMsg ( "layouts_chooselayout", $title ) . "
		<form action='$url' method='get'>
			<input type='hidden' name='title' value='$name' />
			<input type='hidden' name='action' value='edit' />
	" );

	/* iterate the pages we found in the Layouts
	 * namespace, and list each one as an option
	 * as long as it is not restricted to specific
	 * namespaces */
	$default = true;
	while ( $result = $layouts->next() ) {
		// page info
		$title = Title::newFromURL ( $result->page_title )->getText();
		$revision = Revision::loadFromPageId ( $db, $result->page_id );
		$text = $revision->getText();
		$lines = explode ( "\n", $text );
		$namespaces = array();

		// add this layout to the choices by default
		$add = true;

		/* go through the layout text and see if it has an @namespace
		 * restriction, if so only add the layout as a choice if we find
		 * the namespace of this page in the layout text */
		foreach ( $lines as $line ) {
			if ( preg_match ( "/^@namespace(.+?)$/m", $line, $matches ) ) {
				$namespaces = explode ( " ", trim( $matches[1] ) );
				$add = in_array ( $wgContLang->getNsText ( $namespace ), $namespaces ) ||
					$namespace == NS_MAIN && in_array ( "Main", $namespaces );
			}
		}
		if ( $add ) {
			$checked = $default ? "checked='checked'" : "";
			$default = false;
			$fm_id = "layout-" . $result->page_id;
			$wgOut->addHTML( "
				<div>
					<input type='radio' name='layout' id='$fm_id' value='$title' $checked/>
					<label for='$fm_id'>$title</label>
				</div>
			" );
		}
	}

	/* include an option to create a page
	 * without any layout (before any are created,
	 * this will be the only option available) */
	if ( $wgNoLayoutOption ) {
		$wgOut->addHTML( "
			<div>
				<input type='radio' name='layout' id='layout-0' value='none' />
				<label for='layout-0'>" . wfMsg( 'layouts_nolayout' ) . "</label>
			</div>
		" );
	}
	$wgOut->addHTML( "<br />" );

	/* check to see if we are allowing categories on the layout page
	 * and if so then, either grab all the categories, or get them from
	 * the designated page (do this for pages in the whitelisted namespaces) */
	if ( $wgLayoutCategories && in_array( $namespace, $wgLayoutCategoryNSWhiteList ) ) {
		$categories = array();

		/* get the categories from the page if desired,
		 * otherwise grab them from the db */
		if ( $wgLayoutUseCategoryPage ) {
			$revision = Revision::newFromTitle( Title::newFromDBKey( wfMsgForContent( 'layouts-layoutcategorypage' ) ) );
			$results = $revision ? split( "\n", $revision->getText() ) : array();
			foreach ( $results as $result ) {
				if ( trim ( $result ) != '' )
					$categories[] = Title::newFromText( trim( $result ) )->getDBkey();
			}
		} else {
			// todo: implement this later...
		}

		// add radio buttons for the categories
		$default = true;
		$title = $article->mTitle->getPrefixedText();
		$wgOut->addHTML( "<div id='category-box'>" . wfMsg ( "layouts_choosecategory", $title ) );
		foreach ( $categories as $category ) {
			$checked = $default ? "checked='checked'" : "";
			$default = false;
			$fm_id = "category-$category";
			$caption = Title::newFromDBkey ( $category )->getText();
			$wgOut->addHTML( "
				<div>
					<input type='radio' name='category' id='$fm_id' value='$fm_id' $checked/>
					<label for='$fm_id'>$caption</label>
				</div>
			" );
		}
		$wgOut->addHTML ( "</div><br />" );
	}

	$wgOut->addHTML ( "<input type='submit' value='" . wfMsg( 'layouts_continue' ) . "' />" );
	$wgOut->addHTML ( "</form>" );

	return false;
}

function UW_Layouts_Css ( &$out ) {
	global $wgScriptPath;
	$out .= "@import '$wgScriptPath/extensions/uniwiki/Layouts/style.css';\n";
	return true;
}

function UW_Layouts_preFillTextBox ( &$text, $title ) {
	global $wgRequest, $wgAddLayoutLink;

	/* fetch the layout from the query string,
	 * or abort this hook if it is missing */
	$layout_slug = $wgRequest->getVal ( "layout" );
	if ( $layout_slug === NULL )
		return true;

	// fetch the layout object
	$layout_title = Title::newFromURL ( "Layout:" . $layout_slug );
	$layout_article = new Article ( $layout_title );

	$layout_cats = '';

	/* if the layout article exists, pre-fill the textarea with its
	 * wiki text. if it doesn't exist, do nothing (no error) */
	if ( ( $layout_text = $layout_article->fetchContent() ) !== false ) {

		$layout_text = UW_Layouts_stripCats($layout_text, $layout_cats);
		$text .= $layout_cats;

		/* break the layout text into sections by splitting
		 * at header level =one= or ==two==, and iterate */
		$nodes = preg_split ( "/^(==?[^=].*)$/mi", $layout_text, - 1, PREG_SPLIT_DELIM_CAPTURE );
		for ( $i = 0; $i < count( $nodes ); $i++ ) {

			/* if the next node is OPTIONAL, then skip over it
			 * (it will be included if using GenericEditor) */
			if ( preg_match ( "/^@optional$/m", $nodes[$i + 1] ) ) {
				$i++;

			/* not an optional section, or
			 * text that hasn't been skipped */
			} else {

				// DO NOT copy over directives. remove them all!
				$text .= preg_replace ( "/^@.*/m", "", $nodes[$i] );
			}
		}
	}

	if ( $wgAddLayoutLink && $layout_slug != 'none' )
		$text .= "\n\n<layout name=\"$layout_slug\" />";

	return true;
}

function UW_Layouts_stripCats($texttostrip,&$catsintext){
	global $wgContLang, $wgOut;

	# Get localised namespace string:
	$m_catString = strtolower( $wgContLang->getNsText( NS_CATEGORY ) );
	# The regular expression to find the category links:
	$m_pattern = "\[\[({$m_catString}|category):(.*?)\]\]";

	$m_replace = "$2";
	# The container to store the processed text:
	$m_cleanText = '';

	# Check linewise for category links:
	foreach( explode( "\n", $texttostrip ) as $m_textLine ) {
		# Filter line through pattern and store the result:
		$m_cleanText .= trim( preg_replace( "/{$m_pattern}/i", "", $m_textLine ) . "\n" );

		# Check if we have found a category, else proceed with next line:
		if( preg_match_all( "/{$m_pattern}/i",$m_textLine,$catsintext2,PREG_SET_ORDER) ){        
			foreach( $catsintext2 as $local_cat => $m_prefix ) {
				//Set first letter to upper case to match MediaWiki standard
				$strFirstLetter = substr($m_prefix[2], 0,1);
				strtoupper($strFirstLetter);
				$newString = strtoupper($strFirstLetter) . substr($m_prefix[2], 1);
				$catsintext .= "[[" . $m_catString . ":" . $newString . "]]\n";                                  
			}
			# Get the category link from the original text and store it in our list:
			preg_replace( "/.*{$m_pattern}/i", $m_replace,$m_textLine,-1,$intNumber );
		}

	}

	return $m_cleanText;    
}