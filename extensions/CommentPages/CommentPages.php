<?php
/*  Comment pages for main namespace pages
 *  Originally designed for Wikinews
 *  By [[User:Zachary]]
 *  Released under the GPL
 */

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'CommentPages',
	'author'         => '[http://en.wikinews.org/wiki/User:Zachary Zachary Hauri]',
	'descriptionmsg' => 'commentpages-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:CommentPages',
);

$wgExtensionMessagesFiles['CommentPages'] = dirname(__FILE__) . '/CommentPages.i18n.php';
$wgHooks['SkinTemplateTabs'][]  = 'wfCommentPagesSkinTemplateTabs';

/**
 * Namespace to use for comments
 */
$wgCommentPagesNS = 100;

$wgCommentPagesContentNamespace = NS_MAIN;

/**
 * @param $skin Skin
 * @param  $content_actions
 * @return bool
 */
function wfCommentPagesSkinTemplateTabs ( $skin, &$content_actions ) {
	global $wgContLang, $wgCommentPagesNS, $wgCommentPagesContentNamespace;

	$title = $skin->getTitle();
	$pagename = $title->getText();
	$namespace = $title->getNamespace();
	$class = '';
	$page = '';
	$query = '';

	if ($namespace == $wgCommentPagesContentNamespace ||
			$namespace == $wgCommentPagesContentNamespace + 1 ) {
		$comments = Title::makeTitleSafe( $wgCommentPagesNS, $pagename);
		$newcontent_actions = array();

		if (!$comments->exists()) {
			$class = 'new';
			$query = array( 'action' => 'edit', 'redlink' => 1 );

			if (wfMsg('commenttab-preload') != '') {
				$query['preload'] = wfMsg('commenttab-preload');
			}

			if (wfMsg('commenttab-editintro') != '') {
				$query['editintro'] = wfMsg('commenttab-editintro');
			}
		} else {
			$class = '';
		}
		
		$newcontent_actions['comments'] = array(
			'class' => $class,
			'text'  => wfMsg('nstab-comments'),
			'href'  => $comments->getFullURL($query),
		);
		
		$insertAfter = $title->getNamespaceKey();
		if ( isset($content_actions['talk']) ) {
			$insertAfter = 'talk';
		}
		
		$content_actions = efCommentPagesArrayInsertAfter( $content_actions,
							$newcontent_actions, $insertAfter );
	} elseif ($namespace == $wgCommentPagesNS) {
		$main = Title::makeTitleSafe( $wgCommentPagesContentNamespace, $pagename);
		$talk = $main->getTalkPage();
		$newcontent_actions = array();

		if (!$main->exists()) {
			$class = 'new';
			$query = 'action=edit&redlink=1';
		} else {
			$class = '';
			$query = '';
		}
		
		$articleMessage = $main->getNamespaceKey();
		$articleText = wfMsg( $articleMessage );
		if ( wfEmptyMsg( $articleMessage, $articleText ) ) {
			$articleText = $wgContLang->getFormattedNsText( $main->getNamespace() );
		}

		$newcontent_actions['article'] = array(
			'class' => $class,
			'text'  => $articleText,
			'href'  => $main->getFullURL($query),
		);

		if (!$talk->exists()) {
			$class = 'new';
			$query = 'action=edit';
		} else {
			$class = '';
			$query = '';
		}
		$newcontent_actions['talk'] = array(
			'class' => $class,
			'text'  => wfMsg( 'talk' ),
			'href'  => $talk->getFullURL($query),
		);

		foreach ($content_actions as $key => $value) {
			if ($key != 'talk')
				$newcontent_actions[$key] = $value;

			if ($key == 'nstab-comments')
				$newcontent_actions['nstab-comments']['text'] = wfMsg( 'nstab-comments' );
		}

		$content_actions = $newcontent_actions;
	}

	return true;
}

/**
 * Insert array into another array after the specified *KEY*
 * Stolen from GlobalFunctions.php in MW 1.16
 * @param $array Array: The array.
 * @param $insert Array: The array to insert.
 * @param $after Mixed: The key to insert after
 */
function efCommentPagesArrayInsertAfter( $array, $insert, $after ) {
	// Find the offset of the element to insert after.
	$keys = array_keys($array);
	$offsetByKey = array_flip( $keys );
	
	$offset = $offsetByKey[$after];
	
	// Insert at the specified offset
	$before = array_slice( $array, 0, $offset + 1, true );
	$after = array_slice( $array, $offset + 1, count($array)-$offset, true );
	
	$output = $before + $insert + $after;
	
	return $output;
}
