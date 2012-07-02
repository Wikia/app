<?php
/**
 * AJAX functions for CreateAPage extension.
 */
function axTitleExists() {
	global $wgRequest;

	$res = array( 'text' => false );

	$title = $wgRequest->getVal( 'title' );
	$mode = $wgRequest->getVal( 'mode' );
	$title_object = Title::newFromText( $title );

	if ( is_object( $title_object ) ) {
		if ( $title_object->exists() ) {
			$res = array(
				'url'  => $title_object->getLocalURL(),
				'text' => $title_object->getPrefixedText(),
				'mode' => $mode,
			);
		}
	} else {
		$res = array( 'empty' => true );
	}

	return json_encode( $res );
}

function axMultiEditParse() {
	global $wgRequest;
	$me = '';

	$template = $wgRequest->getVal( 'template' );
	$title = Title::newFromText( "Createplate-{$template}", NS_MEDIAWIKI );

	// transfer optional sections data
	$optionalSections = array();
	foreach( $_POST as $key => $value ) {
		if( strpos( $key, 'wpOptionalInput' ) !== false ) {
			$optionalSections = str_replace( 'wpOptionalInput', '', $key );
		}
	}

	if ( $title->exists() ) {
		$rev = Revision::newFromTitle( $title );
		$me = CreateMultiPage::multiEditParse( 10, 10, '?', $rev->getText(), $optionalSections );
	} else {
		$me = CreateMultiPage::multiEditParse( 10, 10, '?', '<!---blanktemplate--->' );
	}

	return json_encode( $me );
}

function axMultiEditImageUpload() {
	global $wgRequest;

	$res = array();

	$postfix = $wgRequest->getVal( 'num' );
	$infix = '';
	if ( $wgRequest->getVal( 'infix' ) != '' ) {
		$infix = $wgRequest->getVal( 'infix' );
	}

	// do the real upload
	$uploadform = new CreatePageImageUploadForm( $wgRequest );
	$uploadform->mTempPath       = $wgRequest->getFileTempName( 'wp' . $infix . 'UploadFile' . $postfix );
	$uploadform->mFileSize       = $wgRequest->getFileSize( 'wp' . $infix . 'UploadFile' . $postfix );
	$uploadform->mSrcName        = $wgRequest->getFileName( 'wp' . $infix . 'UploadFile' . $postfix );
	$uploadform->CurlError       = $wgRequest->getUploadError( 'wp' . $infix . 'UploadFile' . $postfix );
	$uploadform->mLastTimestamp  = $wgRequest->getText( 'wp' . $infix . 'LastTimestamp' . $postfix );

	$par_name = $wgRequest->getText( 'wp' . $infix . 'ParName' . $postfix );
	$file_ext = explode( '.', $uploadform->mSrcName );
	$file_ext = @$file_ext[1];
	$uploadform->mParameterExt = $file_ext;
	if ( $infix == '' ) {
		$uploadform->mDesiredDestName = $wgRequest->getText( 'Createtitle' ) . ' ' . trim( $par_name );
	} else {
		$uploadform->mDesiredDestName = $wgRequest->getText( 'Createtitle' );
	}

	$uploadform->mSessionKey     = false;
	$uploadform->mStashed        = false;
	$uploadform->mRemoveTempFile = false;

	// some of the values are fixed, we have no need to add them to the form itself
	$uploadform->mIgnoreWarning = 1;
	$uploadform->mUploadDescription = wfMsg( 'createpage-uploaded-from' );
	$uploadform->mWatchthis = 1;

	$uploadedfile = $uploadform->execute();
	if ( $uploadedfile['error'] == 0 ) {
		$imageobj = wfLocalFile( $uploadedfile['timestamp'] );
		$imageurl = $imageobj->createThumb( 60 );

		$res = array(
			'error' => 0,
			'msg' => $uploadedfile['msg'],
			'url' => $imageurl,
			'timestamp' => $uploadedfile['timestamp'],
			'num' => $postfix
		);
	} else {
		if ( $uploadedfile['once'] ) {
			#if ( !$error_once ) {
				$res = array(
					'error' => 1,
					'msg' => $uploadedfile['msg'],
					'num' => $postfix,
				);
			#}
			$error_once = true;
		} else {
			$res = array(
				'error' => 1,
				'msg' => $uploadedfile['msg'],
				'num' => $postfix,
			);
		}
	}

	$text = json_encode( $res );
	$ar = new AjaxResponse( $text );
	$ar->setContentType( 'text/html; charset=utf-8' );
	return $ar;
}

function axCreatepageAdvancedSwitch() {
	global $wgRequest;

	$mCreateplate = $wgRequest->getVal( 'createplates' );
	$editor = new CreatePageMultiEditor( $mCreateplate );
	$content = CreateMultiPage::unescapeBlankMarker( $editor->glueArticle() );
	wfCreatePageUnescapeKnownMarkupTags( $content );
	$_SESSION['article_content'] = $content;

	return json_encode( true );
}

global $wgAjaxExportList;
$wgAjaxExportList[] = 'axTitleExists';
$wgAjaxExportList[] = 'axMultiEditParse';
$wgAjaxExportList[] = 'axMultiEditImageUpload';
$wgAjaxExportList[] = 'axCreatepageAdvancedSwitch';