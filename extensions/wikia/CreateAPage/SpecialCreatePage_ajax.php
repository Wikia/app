<?php

function axTitleExists() {
	global $wgRequest ;
	$res = array (
			'text' => false ,
	) ;

	$title = $wgRequest->getVal ('title') ;
	$mode = $wgRequest->getVal ('mode') ;
	$title_object = Title::newFromText ($title) ;

        if (is_object ($title_object)) {
		if ($title_object->exists()) {
			$res = array (
					'url'  => $title_object->getLocalUrl() ,
					'text' => $title_object->getPrefixedText() ,
					'mode' => $mode ,
				     ) ;
		}
	} else {
		$res = array (
			'empty' => true ,
		) ;
	}

	return Wikia::json_encode ($res) ;
}

function axMultiEditParse() {
	wfLoadExtensionMessages ('CreateAPage') ;
	$me = '';
	global $wgRequest;

	$template = $wgRequest->getVal('template');
	$title = Title::newFromText("Createplate-{$template}", NS_MEDIAWIKI);

	if ($title->exists()) {
		$rev = Revision::newFromTitle ($title) ;		
		$me = CreateMultiPage::multiEditParse (10, 10, '?', $rev->getText () ) ;                                       
	} else {
		$me = CreateMultiPage::multiEditParse (10, 10, '?', "<!---blanktemplate--->") ;
	}
	return Wikia::json_encode ($me) ;
}

function axMultiEditImageUpload () {
	$res = false ;
	wfLoadExtensionMessages ('CreateAPage') ;

	global $wgRequest ;
	$postfix = $wgRequest->getVal ('num') ;
	$wgRequest->getVal ('infix') != '' ? $infix = $wgRequest->getVal ('infix') : $infix = '' ;

	//do the real upload
	$uploadform = new CreatePageImageUploadForm ($wgRequest) ;
	$uploadform->mTempPath       = $wgRequest->getFileTempName( 'wp' . $infix . 'UploadFile' . $postfix );
	$uploadform->mFileSize       = $wgRequest->getFileSize( 'wp' . $infix . 'UploadFile' . $postfix );
	$uploadform->mSrcName        = $wgRequest->getFileName( 'wp' . $infix . 'UploadFile' . $postfix );
	$uploadform->CurlError       = $wgRequest->getUploadError( 'wp' . $infix . 'UploadFile' . $postfix );
	$uploadform->mLastTimestamp  = $wgRequest->getText( 'wp' . $infix . 'LastTimestamp' . $postfix );

	$par_name = $wgRequest->getText ('wp' . $infix . 'ParName' .$postfix) ;
	$file_ext = split ("\.", $uploadform->mSrcName) ;
	$file_ext = $file_ext [1] ;
	$uploadform->mParameterExt = $file_ext ;
	if ('' == $infix) {
		$uploadform->mDesiredDestName = $wgRequest->getText ('Createtitle') . ' ' . trim ($par_name) ;
	} else {
		$uploadform->mDesiredDestName = $wgRequest->getText ('Createtitle') ;
	}

	$uploadform->mSessionKey     = false;
	$uploadform->mStashed        = false;
	$uploadform->mRemoveTempFile = false;

	//some of the values are fixed, we have no need to add them to the form itself
	$uploadform->mIgnoreWarning = 1 ;
	$uploadform->mUploadDescription = wfMsg ('createpage_uploaded_from') ;
	$uploadform->mWatchthis = 1  ;
	$uploadedfile = $uploadform->execute () ;
	if ($uploadedfile ["error"] == 0) {
		$imageobj = wfLocalFile ($uploadedfile ["timestamp"]) ;
		$imageurl = $imageobj->createThumb (60) ;
		return Wikia::json_encode (
				array (
					"error" => 0 ,
					"msg" => $uploadedfile ["msg"] ,
					"url" => $imageurl ,
					"timestamp" => $uploadedfile ["timestamp"] ,
					"num" => $postfix ,
				)
		) ;
	} else {
		if ($uploadedfile ["once"]) {
			if (!$error_once) {
				return Wikia::json_encode (
					array (
						"error" => 1 ,  
						"msg" => $uploadedfile ["msg"] ,
						"num" => $postfix ,
					)
				) ;
			}	
			$error_once = true ;
		} else {
			return Wikia::json_encode (
				array (
					"error" => 1 ,
					"msg" => $uploadedfile ["msg"] ,
					"num" => $postfix ,
				)
			) ;
		}
	}
}

function axCreatepageAdvancedSwitch () {
	global $wgRequest ;
	
	$mCreateplate = $wgRequest->getVal ("createplates") ;
	$editor = new CreatePageMultiEditor ($mCreateplate) ;
	$content = CreateMultiPage::unescapeBlankMarker ($editor->GlueArticle ()) ;
	wfCreatePageUnescapeKnownMarkupTags ($content) ;
	$_SESSION ['article_content'] = $content ;
        
	return Wikia::json_encode (true)  ;
}

global $wgAjaxExportList;
$wgAjaxExportList[] = 'axTitleExists' ;
$wgAjaxExportList[] = 'axMultiEditParse' ;
$wgAjaxExportList[] = 'axMultiEditImageUpload' ;
$wgAjaxExportList[] = 'axCreatepageAdvancedSwitch' ;

?>
