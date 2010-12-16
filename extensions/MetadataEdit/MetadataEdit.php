<?php

/**
 * Put categories, language links and allowed templates in a separate text box
 * while editing pages.
 *
 * @file
 * @ingroup Extensions
 * @author Magnus Manske and Alexandre Emsenhuber
 */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'MetadataEdit',
	'author' => array( 'Magnus Manske', 'Alexandre Emsenhuber' ),
	'url' => 'http://www.mediawiki.org/wiki/Extension:MetadataEdit',
	'description' => 'Put categories, language links and allowed templates in a separate text box while editing pages',
	'descriptionmsg' => 'metadataedit-desc',
	'version' => '0.1',
);

/**
 * Full name (including namespace) of the page containing templates names that
 * will be allowed as metadata
 */
$wgMetadataWhitelist = '';

$wgExtensionMessagesFiles['MetadataEdit'] = dirname( __FILE__ ) . '/MetadataEdit.i18n.php';

$wgHooks['EditFormInitialText'][] = 'wfMetadataEditExtractFromArticle';
$wgHooks['EditPage::importFormData'][] = 'wfMetadataEditOnImportData';
$wgHooks['EditPage::attemptSave'][] = 'wfMetadataEditOnAttemptSave';
$wgHooks['EditPage::showEditForm:fields'][] = 'wfMetadataEditOnShowFields';
$wgHooks['EditPageGetPreviewText'][] = 'wfMetadataEditOnGetPreviewText';
$wgHooks['EditPageGetDiffText'][] = 'wfMetadataEditOnGetDiffText';

function wfMetadataEditExtractFromArticle( $editPage ) {
	global $wgMetadataWhitelist, $wgContLang;

	$editPage->mMetaData = '';
	if ( $wgMetadataWhitelist == '' ) return true;
	$s = '';
	$t = $editPage->textbox1;

	# MISSING : <nowiki> filtering

	# Categories and language links
	$t = explode( "\n" , $t );
	$catlow = strtolower( $wgContLang->getNsText( NS_CATEGORY ) );
	$cat = $ll = array();
	foreach ( $t as $key => $x ) {
		$y = trim( strtolower ( $x ) );
		while ( substr( $y , 0 , 2 ) == '[[' ) {
			$y = explode( ']]' , trim ( $x ) );
			$first = array_shift( $y );
			$first = explode( ':' , $first );
			$ns = array_shift( $first );
			$ns = trim( str_replace( '[' , '' , $ns ) );
			if ( $wgContLang->getLanguageName( $ns ) || strtolower( $ns ) == $catlow ) {
				$add = '[[' . $ns . ':' . implode( ':' , $first ) . ']]';
				if ( strtolower( $ns ) == $catlow ) $cat[] = $add;
				else $ll[] = $add;
				$x = implode( ']]', $y );
				$t[$key] = $x;
				$y = trim( strtolower( $x ) );
			} else {
				$x = implode( ']]' , $y );
				$y = trim( strtolower( $x ) );
			}
		}
	}
	if ( count( $cat ) ) $s .= implode( ' ' , $cat ) . "\n";
	if ( count( $ll ) ) $s .= implode( ' ' , $ll ) . "\n";
	$t = implode( "\n" , $t );

	# Load whitelist
	$sat = array () ; # stand-alone-templates; must be lowercase
	$wl_title = Title::newFromText( $wgMetadataWhitelist );
	if ( !$wl_title ) {
		throw new MWException( '$wgMetadataWhitelist is not set to a valid page title.' );
	}
	$wl_article = new Article ( $wl_title );
	$wl = explode ( "\n" , $wl_article->getContent() );
	foreach ( $wl AS $x ) {
		$isentry = false;
		$x = trim ( $x );
		while ( substr ( $x , 0 , 1 ) == '*' ) {
			$isentry = true;
			$x = trim ( substr ( $x , 1 ) );
		}
		if ( $isentry ) {
			$sat[] = strtolower ( $x );
		}

	}

	# Templates, but only some
	$t = explode( '{{' , $t );
	$tl = array() ;
	foreach ( $t as $key => $x ) {
		$y = explode( '}}' , $x , 2 );
		if ( count( $y ) == 2 ) {
			$z = $y[0];
			$z = explode( '|' , $z );
			$tn = array_shift( $z );
			if ( in_array( strtolower( $tn ) , $sat ) ) {
				$tl[] = '{{' . $y[0] . '}}';
				$t[$key] = $y[1];
				$y = explode( '}}' , $y[1] , 2 );
			}
			else $t[$key] = '{{' . $x;
		}
		else if ( $key != 0 ) $t[$key] = '{{' . $x;
		else $t[$key] = $x;
	}
	if ( count( $tl ) ) $s .= implode( ' ' , $tl );
	$t = implode( '' , $t );

	$t = str_replace( "\n\n\n", "\n", $t );
	$editPage->textbox1 = $t;
	$editPage->mMetaData = $s;
	
	return true;
}

function wfMetadataEditOnImportData( $editPage, $request ) {
	if ( $request->wasPosted() ) {
		$editPage->mMetaData = rtrim( $request->getText( 'metadata' ) );
	} else {
		$editPage->mMetaData = '';
	}

	return true;
}

function wfMetadataEditOnAttemptSave( $editPage ) {
	# Reintegrate metadata
	if ( $editPage->mMetaData != '' ) $editPage->textbox1 .= "\n" . $editPage->mMetaData;
	$editPage->mMetaData = '';

	return true;
}

function wfMetadataEditOnShowFields( $editPage ) {
	global $wgContLang, $wgUser;
	$metadata = htmlspecialchars( $wgContLang->recodeForEdit( $editPage->mMetaData ) );
	$ew = $wgUser->getOption( 'editwidth' ) ? ' style="width:100%"' : '';
	$cols = $wgUser->getIntOption( 'cols' );
	$metadata = wfMsgWikiHtml( 'metadata_help' ) . "<textarea name='metadata' rows='3' cols='{$cols}'{$ew}>{$metadata}</textarea>" ;
	$editPage->editFormTextAfterContent .= $metadata;

	return true;
}

function wfMetadataEditOnGetPreviewText( $editPage, &$toparse ) {
	if ( $editPage->mMetaData != '' ) $toparse .= "\n" . $editPage->mMetaData;

	return true;
}

function wfMetadataEditOnGetDiffText( $editPage, &$newText ) {
	if ( $editPage->mMetaData != '' ) $newText .= "\n" . $editPage->mMetaData;

	return true;
}
