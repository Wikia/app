<?php
/**
 * ArticleComments.php - A MediaWiki extension for adding comment sections to articles.
 * @author Jim R. Wilson
 * @author Platonides
 * @version 0.6
 * @copyright Copyright © 2007 Jim R. Wilson
 * @license The MIT License - http://www.opensource.org/licenses/mit-license.php
 * -----------------------------------------------------------------------
 * Description:
 *     This is a MediaWiki (http://www.mediawiki.org/) extension which adds support
 *     for comment sections within article pages, or directly into all pages.
 * Requirements:
 *     MediaWiki 1.16.x or higher
 * Installation:
 *     1. Drop this script (ArticleComments.php) in $IP/extensions
 *         Note: $IP is your MediaWiki install dir.
 *     2. Enable the extension by adding this line to your LocalSettings.php:
 *            require_once( "$IP/extensions/ArticleComments/ArticleComments.php" );
 * Usage:
 *     Once installed, you may utilize ArticleComments by adding the following flag in the article text:
 *         <comments />
 *     Note: Typically this would be placed at the end of the article text.
 * Version Notes:
 *     version 0.6:
 *         Added comments inside <comment> tags instead of article-comments-new-comment message.
 *     version 0.5.1:
 *         Removed the base64 pass
 *     version 0.5:
 *         Updated to work with MediaWiki 1.16+
 *     version 0.4.3:
 *         Added new insertion feature, comments will now be inserted before <!--COMMENTS_ABOVE--> if present
 *         Or, after <!--COMMENTS_BELOW--> if present (the latter causes reverse chronological comment ordering).
 *     version 0.4.2:
 *         Updated default spam filtering code to check all fields against $wgSpamRegex, if specified.
 *     version 0.4.1:
 *         Updated default spam filtering code. (now matches <a> tags in commenterName)
 *     version 0.4:
 *         Updated default spam filtering code.
 *         Abstracted Spam filter via hook (ArticleCommentsSpamCheck) to aid future spam checkers
 *     version 0.3:
 *         Added rudimentary spam filtering based on common abuses.
 *     version 0.2:
 *         Fixed form post method to use localized version of "Special"
 *         Added option for making the form automatically visible (no "Leave a comment..." link)
 *         Added option of diabling the "Website" field
 *         Added system message for prepopulating the comment box.
 *         Added system message for structuring comment submission text.
 *         Added abstracted method for form creation (for insertion into skins)
 *         Added option to "Whitelist" Namespaces for comment submission (as by skin-level form).
 *         Added check for user blocked status prior to comment submission.
 *     version 0.1:
 *         Initial release.
 * -----------------------------------------------------------------------
 * Copyright © 2007 Jim R. Wilson
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do
 * so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 * -----------------------------------------------------------------------
 */

# Confirm MW environment
if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

# Credits
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'ArticleComments',
	'author' => array( 'Jim R. Wilson', 'Platonides' ),
	'version' => '0.6',
	'url' => 'https://www.mediawiki.org/wiki/Extension:ArticleComments',
	'descriptionmsg' => 'article-comments-desc',
);

# Add extension internationalization messages
$wgExtensionMessagesFiles['ArticleComments'] = dirname( __FILE__ ) . '/ArticleComments.i18n.php';

# Attach hooks
$wgHooks['ParserFirstCallInit'][] = 'wfArticleCommentsParserSetup';
$wgHooks['SkinAfterContent'][] = 'wfArticleCommentsAfterContent';
$wgHooks['ArticleCommentsSpamCheck'][] = 'defaultArticleCommentSpamCheck';

/**
 * Comment options
 * May be overriden as parameters to the <comment> tag
 */
$wgArticleCommentDefaults = array(
	'showurlfield' => true, # Provide an URL field ?
	'noscript' => false, # Set to true to not include any ArticleComments related JavaScript
	'hideform' => true, # Should the comment field be hidden by default?
	'defaultMode' => 'normal', # Which mode should be preselected for comments? Values are: plain, normal and wiki
);

/**
 * List of namespaces on which a comment field is automatically added.
 * Eg. $wgArticleCommentsNSDisplayList[] = NS_MAIN;
 */
$wgArticleCommentsNSDisplayList = array();

# Sets up special page to handle comment submission
$wgSpecialPages['ProcessComment'] = 'SpecialProcessComment';

# Sets up the ArticleComments Parser hook for <comments />
function wfArticleCommentsParserSetup( &$parser ) {
	$parser->setHook( 'comments', 'wfArticleCommentsParserHook' );
	$parser->setHook( 'comment', 'wfArticleCommentsParserHookComment' );
	return true;
}

function wfArticleCommentsParserHook( $text, $params = array(), $parser ) {
	# Generate a comment form for display
	return wfArticleCommentForm( $parser->mTitle, $params, $parser );
}

function wfArticleCommentsParserHookComment( $text, $args, $parser, $frame ) {
	global $wgArticleCommentDefaults, $wgParser, $wgParserConf;

	if ( $parser === $wgParser ) { # Workaround bug 25506
		$wgParser = new StubObject( 'wgParser', $wgParserConf['class'], array( $wgParserConf ) );
	}

	if ( !isset( $args['name'] ) ) {
		$args['name'] = wfMsgExt( 'article-comments-comment-missing-name-parameter', array( 'language' => $parser->getFunctionLang() ) );
	}

	if ( !isset( $args['url'] ) ) {
		$args['url'] = ''; # This one can be empty
	}

	if ( !isset( $args['date'] ) ) {
		$args['date'] = wfMsgExt( 'article-comments-comment-missing-date-parameter', array( 'language' => $parser->getFunctionLang() ) );
	} else {
		$args['date'] = $parser->getFunctionLang()->date( wfTimestamp( TS_MW, $args['date'] ) );
	}

	if ( !isset( $args['signature'] ) ) {
		$args['signature'] = $args['url'] == '' ? $args['name'] : $parser->getOptions()->getSkin( $parser->getTitle() )->makeExternalLink( $args['url'], $args['name'] );
	} else { // The signature is wikitext, so it may need parsing
		$args['signature'] = $parser->recursiveTagParse( $args['signature'], $frame );
	}

	if ( !isset( $args['mode'] ) ) {
		$args['mode'] = $wgArticleCommentDefaults['defaultMode'];
	}

	$args['mode'] = strtolower( $args['mode'] );
	if ( $args['mode'] == 'plain' ) {
		// Don't perform any formatting
		$text = htmlspecialchars( $text );

		// But make new line generate new paragraphs
		$text = str_replace( "\n", "</p><p>", $text );

		return "<p>$text</p>";
	} elseif ( $args['mode'] == 'normal' ) {
		// Convert some wikitext oddities to wiki markup

		# Need only a newline for new paragraph
		$text = str_replace( "\n", "\n\n", $text );

		# Disable <pre> on space // TODO: Enable space indenting.
		$text = str_replace( "\n ", "\n&#32;", $text );

	} elseif ( $args['mode'] == 'wiki' ) {
		/* Full wikitext */

	} else {
		return Html::rawElement( 'div', array( 'class' => 'error' ),
			wfMsgExt( 'article-comments-comment-bad-mode', array( 'parsemag', 'language' => $parser->getFunctionLang() ) )
		);
	}

	# Parse the content, this is later kept as-is since we do a replaceafter there.
	$text = $parser->recursiveTagParse( $text, $frame );

	return wfMsgExt(
		'article-comments-comment-contents',
		array( 'parse', 'replaceafter', 'content' ),
		$args['name'], $args['url'], $args['signature'], $args['date'], $text
	);
}

/**
 * Echos out a comment form depending on the page action and namespace.
 *
 * @param $data
 * @param $skin Object: Skin object
 */
function wfArticleCommentsAfterContent( $data, $skin ) {
	global $wgRequest, $wgArticleCommentsNSDisplayList, $wgParser;

	# Short-circuit for anything other than action=view or action=purge
	if ( $wgRequest->getVal( 'action' ) &&
		$wgRequest->getVal( 'action' ) != 'view' &&
		$wgRequest->getVal( 'action' ) != 'purge'
	)
	{
		return true;
	}

	# Short-circuit if displaylist is undefined, empty or null
	if ( $wgArticleCommentsNSDisplayList == null ) {
		return true;
	}

	$title = $skin->getTitle();
	if ( !$title->exists() ) {
		return true;
	}

	# Ensure that the namespace list is an actual list
	$nsList = $wgArticleCommentsNSDisplayList;
	if ( !is_array( $nsList ) ) {
		$nsList = array( $nsList );
	}

	# Display the form
	if ( in_array( $title->getNamespace(), $nsList ) ) {
		$data .= wfArticleCommentForm( $title, array(), $wgParser );
	}

	return true;
}

/**
 * Generates and returns an ArticleComment form HTML.
 * @param $title Object: the title of the article on which the form will appear.
 * @param $params Array: a hash of parameters containing rendering options.
 */
function wfArticleCommentForm( $title, $params = array(), $parser ) {
	global $wgArticleCommentDefaults, $wgOut, $wgParser, $wgParserConf;

	if ( $parser === $wgParser ) { # Needed since r82645. Workaround the 'Invalid marker' problem by giving a new parser to wfMsgExt().
		$wgParser = new StubObject( 'wgParser', $wgParserConf['class'], array( $wgParserConf ) );
	}

	# Merge in global defaults if specified
	$tmp = $wgArticleCommentDefaults;
	foreach ( $params as $k => $v ) {
		$tmp[strtolower( $k )] = (bool)strcasecmp( $v, "false" );
	}
	$params = $tmp;

	# Build out the comment form.
	$content = '<div id="commentForm">';
	$content .= Xml::openElement( 'form', array( 'method' => 'post', 'action' => SpecialPage::getTitleFor( 'ProcessComment' )->getLocalURL() ) );

	$content .= '<p>';
	$content .= Html::hidden( 'commentArticle', $title->getPrefixedDBkey() );

	$content .= '<label for="commenterName">' .
		wfMsgExt(
			'article-comments-name-field',
			array( 'parseinline', 'content' )
		) . Html::element( 'br' ) . '</label>';
	$content .= Html::input( 'commenterName', '', 'text', array( 'id' => 'commenterName' ) );
	$content .= '</p>';

	if ( $params['showurlfield'] ) {
		$content .=  '<p><label for="commenterURL">' .
			wfMsgExt(
				'article-comments-url-field',
				array( 'parseinline', 'content' )
			) . Html::element( 'br' ) . '</label>';
		$content .= Html::input( 'commenterURL', 'http://', 'text', array( 'id' => 'commenterURL' ) );
		$content .= '</p>';
	}

	$content .= '<p><label for="comment">' .
		wfMsgExt( 'article-comments-comment-field', array( 'parseinline', 'content' ) ) .
		Html::element( 'br' ) . '</label>';

	$content .= '<textarea id="comment" name="comment" style="width:30em" rows="5">' . '</textarea></p>';

	$content .= '<p>' . Html::input( 'comment-submit', wfMsgForContent( 'article-comments-submit-button' ), 'submit' ) . '</p>';
	$content .= '</form></div>';

	# Short-circuit if noScript has been set to anything other than false
	if ( $params['noscript'] ) {
		return $content;
	}

	# Inline JavaScript to make form behavior more rich (must degrade well in JS-disabled browsers)
	$js = "<script type=\"text/javascript\">//<![CDATA[\n(function(){\n";

	# Prefill the name field if the user is logged in.
	$js .=
		'var prefillUserName = function(){' . "\n" .
		'var ptu=document.getElementById("pt-userpage");' . "\n" .
		'if (ptu) document.getElementById("commenterName").value=' .
		'ptu.getElementsByTagName("a")[0].innerHTML;};' . "\n" .
		'if (window.addEventListener) window.addEventListener' .
		'("load",prefillUserName,false);' . "\n" .
		'elseif (window.attachEvent) window.attachEvent' .
		'("onload",prefillUserName);' . "\n";

	# Prefill comment text if it has been specified by a system message
	# Note: This is done dynamically with JavaScript since it would be annoying
	# for JS-disabled browsers to have the prefilled text (since they'd have
	# to manually delete it) and would break parser output caching
	$pretext = wfMsgForContent( 'article-comments-prefilled-comment-text' );
	if ( $pretext ) {
		$js .=
			'var comment = document.getElementById("comment");' . "\n" .
			'comment._everFocused=false;' . "\n" .
			'comment.innerHTML="' . htmlspecialchars( $pretext ) . '";' . "\n" .
			'var clearCommentOnFirstFocus = function() {' . "\n" .
			'var c=document.getElementById("comment");' . "\n" .
			'if (!c._everFocused) {' . "\n" .
			'c._everFocused=true;' . "\n" .
			'c.value="";}}' . "\n" .
			'if (comment.addEventListener) comment.addEventListener' .
			'("focus",clearCommentOnFirstFocus,false);' . "\n" .
			'elseif (comment.attachEvent) comment.attachEvent' .
			'("onfocus",clearCommentOnFirstFocus);' . "\n";
	}

	# Hides the commentForm until the "Make a comment" link is clicked
	# Note: To disable, set $wgArticleCommentDefaults['hideForm']=false in LocalSettings.php
	if ( !isset( $params['hideform'] ) ||
		( $params['hideform'] !== 'false' &&
		!$params['hideform'] === false ) ) {
		$js .=
			'var cf=document.getElementById("commentForm");' . "\n" .
			'cf.style.display="none";' . "\n" .
			'var p=document.createElement("p");' . "\n" .
			'p.innerHTML="<a href=\'javascript:void(0)\' onclick=\'' .
			'document.getElementById(\\"commentForm\\").style.display=\\"block\\";' .
			'this.style.display=\\"none\\";false' .
			'\'>' . wfMsgForContent( 'article-comments-leave-comment-link' ) . '</a>";' . "\n" .
			'cf.parentNode.insertBefore(p,cf);' . "\n";
	}

	$js .= "})();\n//]]></script>";
	$wgOut->addScript( $js );

	return $content;
}

/**
 * Special page for comment processing.
 */
class SpecialProcessComment extends SpecialPage {
	function __construct(){
		parent::__construct( 'ProcessComment' );
	}

	function execute( $par ) {
		global $wgOut, $wgParser, $wgUser, $wgContLang, $wgRequest;

		# Retrieve submitted values
		$titleText = $wgRequest->getVal( 'commentArticle' );
		$commenterName = $wgRequest->getVal( 'commenterName' );
		$commenterURL = trim( $wgRequest->getVal( 'commenterURL' ) );
		$comment = $wgRequest->getVal( 'comment' );

		// The default value is the same as not providing a URL
		if ( $commenterURL == 'http://' ) {
			$commenterURL = '';
		}

		$title = Title::newFromText( $titleText );

		# Perform validation checks on supplied fields
		$messages = array();

		if ( !$wgRequest->wasPosted() ) {
			$messages[] = wfMsg( 'article-comments-not-posted' );
		}

		if ( $titleText === '' || !$title ) {
			$messages[] = wfMsg( 'article-comments-invalid-field', wfMsgForContent( 'article-comments-title-string' ), $titleText );
		}

		if ( !$commenterName || strpos( $commenterName, "\n" ) !== false ) {
			$messages[] = wfMsg( 'article-comments-required-field', wfMsgForContent( 'article-comments-name-string' ) );
		}

		if ( ( $commenterURL != '' ) && !preg_match( "/^(" . wfUrlProtocols() . ')' . Parser::EXT_LINK_URL_CLASS . '+$/', $commenterURL ) ) {
			$messages[] = wfMsg( 'article-comments-invalid-field', wfMsgForContent( 'article-comments-url-string' ), $commenterURL );
		}

		if ( !$comment ) {
			$messages[] = wfMsg( 'article-comments-required-field', wfMsg( 'article-comments-comment-string' ) );
		}

		if ( !empty( $messages ) ) {
			$wgOut->setPageTitle( wfMsg( 'article-comments-submission-failed' ) );
			$wikiText = "<div class='errorbox'>\n";
			$wikiText .= wfMsgExt( 'article-comments-failure-reasons', 'parsemag', count( $messages ) ) . "\n\n";
			foreach ( $messages as $message ) {
				$wikiText .= "* $message\n";
			}
			$wgOut->addWikiText( $wikiText . '</div>' );
			return;
		}

		# Setup title and talkTitle object
		$article = new Article( $title );

		$talkTitle = $title->getTalkPage();
		$talkArticle = new Article( $talkTitle );

		# Check whether user is blocked from editing the talk page
		if ( $wgUser->isBlockedFrom( $talkTitle ) ) {
			$wgOut->setPageTitle( wfMsg( 'article-comments-submission-failed' ) );
			$wikiText = "<div class='errorbox'>\n";
			# 1 error only but message is used above for n errors too
			$wikiText .= wfMsgExt( 'article-comments-failure-reasons', 'parsemag', 1 ) . "\n\n";
			$wikiText .= '* ' . wfMsg( 'article-comments-user-is-blocked', $talkTitle->getPrefixedText() ) . "\n";
			$wgOut->addWikiText( $wikiText . '</div>' );
			return;
		}

		# Retrieve article content
		$articleContent = '';
		if ( $title->exists() ) {
			$articleContent = $article->getContent();
		}

		# Retrieve existing talk content
		$talkContent = '';
		if ( $talkTitle->exists() ) {
			$talkContent = $talkArticle->getContent();
		}

		# Check if talk NS is in the namespace display list
		# Note: if so, then there's no need to confirm that <comments /> appears in the article or talk page.
		global $wgArticleCommentsNSDisplayList;
		$skipCheck = (
			is_array( $wgArticleCommentsNSDisplayList ) ?
			in_array( $talkTitle->getNamespace(), $wgArticleCommentsNSDisplayList ):
			false
		);

		# Check whether the article or its talk page contains a <comments /> flag
		if ( !$skipCheck &&
			preg_match( '/<comments( +[^>]*)?\\/>/', $articleContent ) === 0 &&
			preg_match( '/<comments( +[^>]*)?\\/>/', $talkContent ) === 0
		) {
			$wgOut->setPageTitle( wfMsgForContent( 'article-comments-submission-failed' ) );
			$wgOut->addWikiText(
				'<div class="errorbox">' .
				wfMsg( 'article-comments-no-comments', $title->getPrefixedText() ) .
				'</div>'
			);
			return;
		}

		# Run spam checks
		$isSpam = false;
		wfRunHooks( 'ArticleCommentsSpamCheck', array( $comment, $commenterName, $commenterURL, &$isSpam ) );

		# If it's spam - it's gone!
		if ( $isSpam ) {
			$wgOut->setPageTitle( wfMsg( 'article-comments-submission-failed' ) );
			$wgOut->addWikiText(
				'<div class="errorbox">' .
				wfMsg( 'article-comments-no-spam' ) .
				'</div>'
			);
			return;
		}

		# Initialize the talk page's content.
		if ( $talkContent == '' ) {
			$talkContent = wfMsgForContent( 'article-comments-talk-page-starter', $title->getPrefixedText() );
		}

		# Search for insertion point, or append most recent comment.
		$commentText = wfMsgForContent( 'article-comments-new-comment-heading', $commenterName, $commenterURL, '~~~~', $comment );
		$commentText .= '<comment date="' . htmlspecialchars( wfTimestamp( TS_ISO_8601 ) ) . '" name="' . htmlspecialchars( $commenterName ) . '"';
		if ( $commenterURL != '' ) {
			$commentText .= ' url="' . htmlspecialchars( $commenterURL ) . '"';
		}
		if ( $wgUser->isLoggedIn() ) {
			$commentText .= ' signature="' . htmlspecialchars( $wgParser->getUserSig( $wgUser ) ) . '"';
		}
		$commentText .= ">\n" . str_replace( '</comment', '&lt;/comment', $comment ) . "\n</comment>";

		$posAbove = stripos( $talkContent, '<!--COMMENTS_ABOVE-->' );
		if ( $posAbove === false ) {
			$posBelow = stripos( $talkContent, '<!--COMMENTS_BELOW-->' );
		}
		if ( $posAbove !== false ) {
			# Insert comments above HTML marker
			$talkContent = substr( $talkContent, 0, $posAbove ) . $commentText . substr( $talkContent, $posAbove );
		} elseif ( $posBelow !== false ) {
			# Insert comments below HTML marker
			$talkContent = substr( $talkContent, 0, $posBelow + 21 ) . $commentText . substr( $talkContent, $posBelow + 21 );
		} else {
			# No marker found, append to bottom (default)
			$talkContent .= $commentText;
		}

		# Update the talkArticle with the new comment
		$summary = wfMsgForContent( 'article-comments-summary', $commenterName );
		$talkArticle->doEdit( $talkContent, $summary );

		$wgOut->setPageTitle( wfMsg( 'article-comments-submission-succeeded' ) );
		$wgOut->addWikiMsg( 'article-comments-submission-success', $title->getPrefixedText() );
		$wgOut->addWikiMsg( 'article-comments-submission-view-all', $talkTitle->getPrefixedText() );
	}
}

/**
 * Checks ArticleComment fields for spam.
 * Usage: $wgHooks['ArticleCommentsSpamCheck'][] = 'defaultArticleCommentSpamCheck';
 * @param String $comment The comment body submitted (passed by value)
 * @param String $commenterName Name of commenter (passed by value)
 * @param String $commenterURL Website URL provided for comment (passed by value)
 * @param Boolean $isSpam Whether the comment is spam (passed by reference)
 * @return Boolean Always true to indicate other hooking methods may continue to check for spam.
 */
function defaultArticleCommentSpamCheck( $comment, $commenterName, $commenterURL, &$isSpam ) {
	if ( $isSpam ) {
		# This module only marks comments as spam (other modules may unspam)
		return true;
	}

	$fields = array( $comment, $commenterName, $commenterURL );

	# Run everything through $wgSpamRegex if it has been specified
	global $wgSpamRegex;
	if ( $wgSpamRegex ) {
		foreach ( $fields as $field ) {
			if ( preg_match( $wgSpamRegex, $field ) ) {
				$isSpam = true;
				return true;
			}
		}
	}

	# Rudimentary spam protection
	$spampatterns = array(
		'%\\[url=(https?|ftp)://%smi',
		'%<a\\s+[^>]*href\\s*=\\s*[\'"]?\\s*(https?|ftp)://%smi'
	);
	foreach ( $spampatterns as $sp ) {
		foreach ( $fields as $field ) {
			if ( preg_match( $sp, $field ) ) {
				$isSpam = true;
				return true;
			}
		}
	}

	# Check for bad input for commenterName (seems to be a popular spam location)
	# These patterns are more general than those above
	$spampatterns = array(
		'%<a\\s+%smi',
		'%(https?|ftp)://%smi',
		'%(\\n|\\r)%smi'
	);
	foreach ( $spampatterns as $sp ) {
		if ( preg_match( $sp, $commenterName ) ) {
			$isSpam = true;
			return true;
		}
	}

	# Fail for length violations
	if ( strlen( $commenterName ) > 255 || strlen( $commenterURL ) > 300 ) {
		$isSpam = true;
		return true;
	}

	# We made it this far, leave $isSpam alone and give other implementors a chance.
	return true;
}
