<?php
/**
 * ImageTagging extension by Wikia, Inc.
 * Lets a user select regions of an embedded image and associate an article with that region
 *
 * @file
 * @ingroup Extensions
 * @version 1.2
 * @author Tristan Harris
 * @author Tomasz Klim
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @link http://www.mediawiki.org/wiki/Extension:ImageTagging Documentation
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This is not a valid entry point to MediaWiki.' );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'Image Tagging',
	'author'         => array( 'Tristan Harris', 'Tomasz Klim' ),
	'version'        => '1.2',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:ImageTagging',
	'descriptionmsg' => 'imagetagging-desc',
);

// Set up logging
$wgLogTypes[] = 'tag';
$wgLogNames['tag'] = 'tag-logpagename';
$wgLogHeaders['tag'] = 'tag-logpagetext';
$wgLogActions['tag'] = 'imagetagging-log-tagged';

$wgHooks['UnknownAction'][] = 'addTag';
$wgHooks['UnknownAction'][] = 'removeTag';
$wgHooks['UnknownAction'][] = 'tagSearch';

// other hooks to try: 'ParserAfterTidy', ...
#$wgHooks['OutputPageBeforeHTML'][] = 'wfCheckArticleImageTags';
$wgHooks['ArticleFromTitle'][] = 'wfArticleFromTitle';

// Set up the Special:TaggedImages special page
$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['ImageTagPage'] = $dir . 'ImageTagPage.php';
$wgAutoloadClasses['TaggedImages'] = $dir . 'ImageTagging_body.php';
$wgExtensionMessagesFiles['ImageTagging'] = $dir . 'ImageTagging.i18n.php';
$wgExtensionMessagesFiles['ImageTaggingAlias'] = $dir . 'ImageTagging.alias.php';
$wgSpecialPages['TaggedImages'] = 'TaggedImages';

/********************
 * End Trie Handlers
 ********************/

function wfCheckArticleImageTags( $outputPage, $text ) {
	if ( $outputPage->isArticle() ) {
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'imagetags',
			array(
				'article_tag', 'tag_rect', 'unique_id',
				'COUNT(article_tag) AS count'
			),
			array( 'article_tag' => $outputPage->getTitle()->getText() ),
			__METHOD__,
			array( 'GROUP BY' => 'article_tag' )
		);

		$o = $db->fetchObject( $res );
		if ( $o ) {
			$taggedImagesObj = SpecialPage::getTitleFor( 'TaggedImages' );
			$titleText = $outputPage->getTitle()->getText();

			$outputPage->addHTML('
				<a href="' . $taggedImagesObj->getLocalURL( 'q=' . $titleText ) . '">
				<span style="position:absolute;
				z-index: 1;
				border: none;
				background: none;
				right: 30px;
				top: 3.7em;
				float: right;
				margin: 0.0em;
				padding: 0.0em;
				line-height: 1.7em; /*1.5em*/
				text-align: right;
				text-indent: 0;
				font-size: 100%;
				text-transform: none;
				white-space: nowrap;" id="coordinates" class="plainlinksneverexpand">
				' . wfMsg( 'imagetagging-imagetag-seemoreimages', $titleText, $o->count ) .
				'</span></a>'
			);
		}
	}
	return true;
}

// TKL 2006-03-07: it doesn't work in new MediaWiki, modification required in includes/Wiki.php (class name change only)
// $wgNamespaceTemplates[NS_IMAGE] = 'ImageTagPage';

function addTag( $action, $article ) {
	if( $action != 'addTag' ) {
		return true;
	}

	global $wgRequest, $wgOut, $wgUser;

	wfProfileIn( __METHOD__ );

	$wgOut->setArticleBodyOnly( true );

	$tagRect = $wgRequest->getText( 'rect' );
	$tagName = $wgRequest->getText( 'tagName' );
	$imgName = $wgRequest->getText( 'imgName' );
	$userText = $wgUser->getName();

	$tagRect = preg_replace( "/[\"'<>]/", '', $tagRect );
	$tagName = preg_replace( "/[\"'<>]/", '', $tagName );
	$imgName = preg_replace( "/[\"'<>]/", '', $imgName );

	$img = wfFindFile( $imgName );
	if ( $img ) {
		$imgTitle = $img->getTitle();

		wfPurgeTitle( $imgTitle );

		$dbw = wfGetDB( DB_MASTER );
		$dbw->insert(
			'imagetags',
			array(
				'img_page_id' => 0,
				'img_name' => $imgName,
				'article_tag' => $tagName,
				'tag_rect' => $tagRect,
				'user_text' => $userText
			),
			__METHOD__
		);

		$wgOut->clearHTML();
		$wgOut->addHTML( "<!-- added tag for image $imgName to database! -->" );
		$wgOut->addHTML( wfGetImageTags( $img, $imgName ) );

		$logPage = new LogPage( 'tag' );
		$link = basename( $img->title->getLocalURL() );
		$logComment = wfMsg(
			'imagetagging-log-tagged',
			$link, $imgName, $tagName, $userText
		);
		$logPage->addEntry( 'tag', $imgTitle, $logComment );

		$enotif = new EmailNotification( $wgUser, $imgTitle, wfTimestampNow(), $logComment, false );
		$enotif->notifyOnPageChange();
	} else {
		$wgOut->clearHTML();
		$wgOut->addHTML(
			"<!-- ERROR: img named $imgName -->
			<script type='text/javascript'>
			alert(\"Error adding tag!\");
			</script>"
		);
	}
	wfProfileOut( __METHOD__ );
	return false;
}

function removeTag( $action, $article ) {
	if ( $action != 'removeTag' ) {
		return true;
	}

	global $wgRequest, $wgOut, $wgUser;

	wfProfileIn( __METHOD__ );

	$wgOut->setArticleBodyOnly( true );

	$tagID = $wgRequest->getVal( 'tagID' );
	$tagName = $wgRequest->getText( 'tagName' );
	$imgName = $wgRequest->getText( 'imgName' );
	$userText = $wgUser->getName();

	$tagID = preg_replace( "/[\"'<>]/", '', $tagID );
	$tagName = preg_replace( "/[\"'<>]/", '', $tagName );
	$imgName = preg_replace( "/[\"'<>]/", '', $imgName );

	$img = wfFindFile( $imgName );
	if ( $img ) {
		$imgTitle = $img->getTitle();

		wfPurgeTitle( $imgTitle );

		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'imagetags', array( 'unique_id' => $tagID ), __METHOD__ );

		$wgOut->clearHTML();
		$wgOut->addHTML( '<!-- removed tag from the database! -->' );
		$wgOut->addHTML( wfGetImageTags( $img, $imgName ) );

		$logPage = new LogPage( 'tag' );
		$logComment = wfMsg( 'imagetagging-logentry', $tagName, $userText );
		$logPage->addEntry( 'tag', $imgTitle, $logComment );

		$enotif = new EmailNotification( $wgUser, $imgTitle, wfTimestampNow(), $logComment, false );
		$enotif->notifyOnPageChange();
	} else {
		$wgOut->clearHTML();
		$wgOut->addHTML(
			"<!-- ERROR: img named $imgName -->
			<script type='text/javascript'>
			alert(\"Error removing tag!\");
			</script>"
		);
	}

	wfProfileOut( __METHOD__ );
	return false;
}

function tagSearch( $action, $article ) {
	if( $action != 'tagSearch' ) {
		return true;
	}

	global $wgRequest, $wgOut;

	wfProfileIn( __METHOD__ );

	$wgOut->setArticleBodyOnly( true );

	$query = $wgRequest->getText( 'q' );
	$query = preg_replace( "/[\"'<>]/", '', $query );

	$search = SearchEngine::create();
	$search->setLimitOffset( 10, 0 );
	$search->setNamespaces( array( NS_MAIN ) );
	$search->showRedirects = true;
	$titleMatches = $search->searchTitle( $query );

	$numResults = ( $titleMatches ? $titleMatches->numRows() : 0 );
	if ( $numResults > 0 ) {
		$wgOut->addHTML( wfTagSearchShowMatches( $titleMatches ) );
	}

	wfProfileOut( __METHOD__ );
	return false;
}

/**
 * @param $matches SearchResultSet
 * @param $terms String: partial regexp for highlighting terms
 */
function wfTagSearchShowMatches( &$matches ) {
	global $wgContLang;

	wfProfileIn( __METHOD__ );

	$tm = $wgContLang->convertForSearchResult( $matches->termMatches() );
	$terms = implode( '|', $tm );

	$out = "<searchresults>\n";

	$result = $matches->next();
	while( $result ) {
		$out .= wfTagSearchHitXML( $result, $terms );
	}
	$out .= "</searchresults>\n";

	// convert the whole thing to desired language variant
	$out = $wgContLang->convert( $out );

	wfProfileOut( __METHOD__ );
	return $out;
}

/**
 * Format a single hit result
 * @param $result SearchResult
 * @param $terms String: partial regexp for highlighting terms
 */
function wfTagSearchHitXML( $result, $terms ) {
	global $wgUser, $wgContLang;

	wfProfileIn( __METHOD__ );

	$t = $result->getTitle();
	if( !$t instanceof Title ) {
		wfProfileOut( __METHOD__ );
		return "<!-- Broken link in search result -->\n";
	}
	$sk = $wgUser->getSkin();

	$contextlines = 5;
	$contextchars = 50;

	$link = $sk->makeKnownLinkObj( $t );
	$revision = Revision::newFromTitle( $t );
	$text = $revision->getText();

	$lines = explode( "\n", $text );

	$max = intval( $contextchars ) + 1;
	$pat1 = "/(.*)($terms)(.{0,$max})/i";

	$lineno = 0;

	$extract = '';
	foreach ( $lines as $line ) {
		if ( $contextlines == 0 ) {
			break;
		}
		++$lineno;
		if ( !preg_match( $pat1, $line, $m ) ) {
			continue;
		}
		$contextlines--;
		$pre = $wgContLang->truncate( $m[1], -$contextchars, '...', false );

		if ( count( $m ) < 3 ) {
			$post = '';
		} else {
			$post = $wgContLang->truncate( $m[3], $contextchars, '...', false );
		}

		$found = $m[2];

		$line = htmlspecialchars( $pre . $found . $post );
		$pat2 = '/(' . $terms . ')/i';
		$line = preg_replace( $pat2, "<span class='searchmatch'>\\1</span>", $line );

		$extract .= "<br /><small>{$lineno}: {$line}</small>\n";
	}

	wfProfileOut( __METHOD__ );
	return "<result>\n<link>{$link}</link>\n<context>{$extract}</context>\n</result>\n";
}

function wfPurgeTitle( $title ) {
	global $wgUseSquid;

	wfProfileIn( __METHOD__ );

	$title->invalidateCache();

	if ( $wgUseSquid ) {
		// Commit the transaction before the purge is sent
		$dbw = wfGetDB( DB_MASTER );
		$dbw->commit();

		// Send purge
		$update = SquidUpdate::newSimplePurge( $title );
		$update->doUpdate();
	}

	wfProfileOut( __METHOD__ );
}

function wfGetImageTags( $img, $imgName ) {
	global $wgUser, $wgOut, $wgLang;

	wfProfileIn( __METHOD__ );

	$sk = $wgUser->getSkin();
	$db = wfGetDB( DB_SLAVE );
	$res = $db->select(
		array( 'imagetags' ),
		array( 'article_tag', 'tag_rect', 'unique_id' ),
		array( 'img_name' => $imgName ),
		__METHOD__
	);

	$html = '';
	$wgOut->addHTML( '<!-- this many image tags: ' . count( $res ) . ' from img ' . $img->name . ' -->' );
	foreach( $res as $o ) {
		if ( strlen( $html ) > 0 ) {
			$html .= ', ';
		}

		$wgOut->addHTML(
			'<!-- tag rect: ' . $o->tag_rect . ', tag title: ' .
			$o->article_tag . ', unique_id: ' . $o->unique_id . '-->'
		);

		$span = '<span id="' . $o->article_tag . '-tag" onmouseout="hideTagBox()" onmouseover="tagBoxPercent(' . $o->tag_rect . ', false)">';

		$articleTitle = Title::newFromText( $o->article_tag );

		#$articleLink = '<a href="' . $articleTitle->escapeFullURL() . '" onmouseout="hideTagBox()">' . $o->article_tag . '</a>';
		$articleLink = $sk->makeLinkObj( $articleTitle );

		$specialImagesTitle = SpecialPage::getTitleFor( 'TaggedImages' );

		$imagesLink = '<a onmouseover="tagBoxPercent(' . $o->tag_rect . ', false)" onmouseout="hideTagBox()" href="' .
			$specialImagesTitle->escapeFullURL( 'q=' . $o->article_tag ) . '">' .
			wfMsgHtml( 'imagetagging-images' ) . '</a>';

		$removeLink = '<a href="#" onclick="removeTag(' . $o->unique_id .
			', this, \'' . addslashes( $o->article_tag ) . '\'); return false;">' .
			wfMsgHtml( 'imagetagging-removetag' ) . '</a>';

		$html .= $span . $articleLink . ' (' .
			$wgLang->pipeList( array( $imagesLink, $removeLink ) ) . ')</span>';
	}

	if ( $html ) {
		$html = wfMsg( 'imagetagging-inthisimage', $html );
	}

	wfProfileOut( __METHOD__ );
	return $html;
}

/**
 * Initializes ImageTagPage instead of MediaWiki's standard ImagePage for pages
 * in the image namespace and for users who are not blocked.
 *
 * @param $title Object: Title object
 * @param $article Object: Article object (or ImageTagPage)
 * @return Boolean: true
 */
function wfArticleFromTitle( &$title, &$article ) {
	global $wgUser;

	wfProfileIn( __METHOD__ );

	if ( NS_IMAGE == $title->getNamespace() && !$wgUser->isBlocked() ) {
		$article = new ImageTagPage( $title );
	}

	wfProfileOut( __METHOD__ );
	return true;
}
