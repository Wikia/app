<?php

/*
 * AddToList is a handy way to edit lists right from view mode.
 * It's a bit similar to CategorySelect in it's basic concept.
 *
 * Usage:
 * * list item foo
 * * list item bar
 * * <addmore />
 *
 * @author tor
 *
 * @todo make this use AJAX
 * @todo add error handling
 * @todo add permission checks
 * @todo allow for more than one input per page (currently this will not work)
 * @todo i18n
 */

$wgHooks['ParserFirstCallInit'][] = 'efAddToListInit';
$wgHooks['UnknownAction'][] = 'efAddToListEdit';

function efAddToListInit( &$parser ) {
        $parser->setHook( 'addmore', 'efAddToListRenderInput' );
        return true;
}

function efAddToListRenderInput( $input, $args, $parser, $frame ) {
	global $wgTitle, $wgScriptPath;

	$ret = '';

	$ret .= Xml::openElement( 'form', array( 'action' => $wgScriptPath, 'method' => 'POST' ) );

	$ret .= Xml::input( 'item' );
	$ret .= Html::hidden( 'action', 'addtolist' );
	$ret .= Html::hidden( 'timestamp', wfTimestampNow() ); // for edit conflicts
	$ret .= Html::hidden( 'title', $wgTitle->getDBKey() );

	if ( !empty( $args['signature'] ) ) {
		$ret .= Html::hidden( 'postfix', ' --~~~' );
	}

	$ret .= Xml::submitButton( 'Add to list' );

	$ret .= Xml::closeElement( 'form' );

	return $ret;
}

function efAddToListEdit( $action, $article ) {
	global $wgOut, $wgRequest, $wgTitle;

	if ( $action !== 'addtolist' ) {
		return true;
	}

	if ( $article->mTitle->getText() != $wgTitle->getText() ) {
		return true;
	}

	// @todo should return some error
	if ( wfReadOnly() ) {
		return true;
	}

	$content = $article->getContent();
	$item = trim( $wgRequest->getText( 'item' ) ) . $wgRequest->getText( 'postfix' );

	if ( empty( $item ) ) {
		return true;
	}

	$parts = explode( '* <addmore', $content );
	$first = array_shift( $parts );
	array_unshift( $parts, "* $item\n* <addmore" );
	array_unshift( $parts, $first );

	$newContent = implode( '', $parts );

	$article->doEdit( $newContent, 'added list item' );

	$wgOut->redirect( $article->mTitle->getFullUrl() );

	return false;
}
