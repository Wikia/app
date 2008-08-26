<?PHP

// Max number of files to alsssslow for uploading
define(max_num, '10');

// Default the "Yes" "No" drop-down
# For No:
# define(protect, '');
# For Yes:
# define(protect, 'selected');
define(protect, 'selected');




class working{
	
	function working(){
	global $wgRequest, $wgOut, $wgTitle, $wgUser;
	global $wgEnableUploads, $wgScriptPath;
	
		/** Show an error message if file upload is disabled */ 
		if( ! $wgEnableUploads ) {
			$wgOut->addWikiText( wfMsg( 'uploaddisabled' ) );
			return;
		}

		/** Various rights checks */
		if( !$wgUser->isAllowed( 'upload' ) || $wgUser->isBlocked() ) {
			$wgOut->errorpage( 'uploadnologin', 'uploadnologintext' );
			return;
		}
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		
		$this->url = $wgTitle->getInternalURL();
		
		$todo = $wgRequest->getVal( 'action' );
		$spl = explode("/", $todo);
		$todo = $spl[0];
		$this->id =  str_replace("id_", "", $spl[1]) ;
		if (!$this->id) $this->id = $wgRequest->getVal( 'id' );
		
		#die($todo);
		switch( $todo ) {
		
			case 'make_form':
					$this->make_form();
				break;
				
			case 'upload_files':
					$this->upload_files();
				break;
				
			default:
				$this->load_forum();
				break;
				
				
		}
		
		$wgOut->addHTML("<br><table width='100%' border='1'><tr><td align='center'>Multi-File Uploader Created By: <a href='http://anotherwebcom.com' target='_blank'>Another Web Com</a></td></tr></table> ");
		
	}
	
	function load_forum(){
	global $wgOut;
		
		$html = '<form name="upload" method="post" action="'.$this->url.'" />';
		$html .= '<input name="action" type="hidden" value="make_form">';
		$html .= 'Enter the number of files you would like to upload:<br> ';
		$html .= '<input name="num_files" type="text" maxlength="2" size="2"> ';
		$html .= '<input type="submit" name="Submit" value="Add">';
		$html .= '</form>';
	
		$wgOut->addHTML($html);
	
	}
	
	function make_form(){
	global $wgOut, $wgRequest, $wgScriptPath;
		
		$wgOut->addHTML('<script type="text/javascript" src="'. $wgScriptPath .'/extensions/awc/multi_file_uploader/awc.js"><!-- http://anotherwebcom.comg --></script>');
		$num = $wgRequest->getVal( 'num_files' );
		if ($num > max_num){
			$wgOut->addHTML("You have selected <b>" . $num . "</b> files to upload and the limit is </b><b>" . max_num . "</b><br>
							 Only <b>" . max_num . "</b> fields will be displayed.<hr />");
			$num = max_num ;
		} elseif ($num == '' || $num == '0') {
			$wgOut->addHTML("You need to select the number of files you want to upload.");
			return ;
		}
		$wgOut->addWikiText( wfMsg( 'uploadtext' ) . "<hr /><br />" );
		$html = '<form name="upload" enctype="multipart/form-data" method="post" action="'.$this->url.'" />';
		$html .= '<input name="action" type="hidden" value="upload_files">';
		$html .= '<input name="num_files" type="hidden" value="'.$num.'">';
		$html .= '<table width="100%">';
		
			for( $i = 0; $i < $num; $i++ ) {
				$html .= $this->multi_forum($i);
			}
		
		$html .= '</table>';
		$html .= '<input type="submit" name="Submit" value="'.wfMsg( 'uploadbtn' ).'"></form>';
		$wgOut->addHTML($html);
		
	
	}
	
	function multi_forum($id){
		
		$html = '<tr><td>';
		$html .= wfMsg( 'protect' ) .': <select name="protect_'.$id.'">';
		$html .= '<option value="no">No</option>';
		$html .= '<option value="yes" '. protect .'>Yes</option>';
		$html .= '</select>';
		$html .= ' &nbsp; '. wfMsg( 'protectcomment' ) .': <input name="protect_reason_'.$id.'" type="text"><br>';
		$html .= wfMsg( 'sourcefilename' ) . ': <input name="file_'.$id.'" id="file_'.$id.'" type="file" onchange="javascript:fillDestFilename('.$id.')" size="75"><br>';
		$html .= wfMsg( 'destfilename' ) .': <input name="filename_'.$id.'" id="filename_'.$id.'" type="text" size="50"><br>';
		$html .= wfMsg( 'filedesc' ) .": <textarea name='desc_".$id."' rows='3' cols='10'></textarea><br>"; 
		$html .= wfMsg( 'watchthis' ) .": <input type='checkbox' name='wpWatchthis_".$id."' value='true' /><br /><hr /><br />";
		// <input type='checkbox' name='wpWatchthis' id='wpWatchthis' $watchChecked value='true' />
		$html .= '</td></tr>';
	
		return $html ;	
	}
	
	function upload_files(){
	global $wgRequest, $wgOut, $up ;
		
		require_once('includes/SpecialUpload.php');
		$up = new UploadForm($wgRequest);
			
			
			$num = $wgRequest->getVal( 'num_files' );
			#die($num);
			for( $i = 0; $i < $num; $i++ ) {
					
					$this->mDestFile          = $wgRequest->getVal( 'filename_' . $i );
					$this->mUploadDescription =  $wgRequest->getVal( 'desc_' . $i );
					$this->mUploadSource      =  $wgRequest->getVal( 'file_' . $i );
					$this->mWatchthis         =  $wgRequest->getVal( 'wpWatchthis_' . $i );
					
					$this->mUploadTempName 	 = $_FILES['file_'. $i]['tmp_name'];
					$this->mUploadSize       = $_FILES['file_'. $i]['size'];
					$this->mOname            = $wgRequest->getFileName( 'file_' . $i );
					$this->mSessionKey       = false;
					$this->mStashed          = false;
					
					$this->mprotect 		 = $wgRequest->getVal( 'protect_' . $i );
					$this->mprotect_reason   = $wgRequest->getVal( 'protect_reason_' . $i );
					
					$html .= $this->processUpload();
					# addWikiText
			
			}
			
			$wgOut->addHTML($html);
	
	}
	
	
	
	
	
	
	
	
	
	
	# The Below FUNCTIONS are from the MediaWiki SpecialUpload.php, Image.php and Artile.php files...
	# REASON: If we just call the functions, at the end it will redirect to the Uploads Article Page
	# Which is not what we want to do... and also to do multipule functions at once, Protect.
	# Functions where edied to fit our needs...
	function processUpload() {
		global $wgUser, $wgOut, $wgLang, $wgContLang;
		global $wgUploadDirectory;
		global $wgUseCopyrightUpload, $wgCheckCopyrightUpload;
		global $up;
		
		/**
		 * If there was no filename or a zero size given, give up quick.
		 */
		if( trim( $this->mOname ) == '' || empty( $this->mUploadSize ) ) {
			return $this->mainUploadForm('<li>'.wfMsg( 'emptyfile' ).'</li>');
		}

		# Chop off any directories in the given filename
		if ( $this->mDestFile ) {
			$basename = basename( $this->mDestFile );
		} else {
			$basename = basename( $this->mOname );
		}

		/**
		 * We'll want to blacklist against *any* 'extension', and use
		 * only the final one for the whitelist.
		 */
		list( $partname, $ext ) = UploadForm::splitExtensions( $basename );
		if( count( $ext ) ) {
			$finalExt = $ext[count( $ext ) - 1];
		} else {
			$finalExt = '';
		}
		$fullExt = implode( '.', $ext );
		
		if ( strlen( $partname ) < 3 ) {
			#$this->mainUploadForm( wfMsg( 'minlength' ) );
			return wfMsg( 'minlength' ) . " <b>" . $basename . "</b><br><br>" ;
		}

		/**
		 * Filter out illegal characters, and try to make a legible name
		 * out of it. We'll strip some silently that Title would die on.
		 */
		$filtered = preg_replace ( "/[^".Title::legalChars()."]|:/", '-', $basename );
		$nt = Title::newFromText( $filtered );
		if( is_null( $nt ) ) {
			#return $this->uploadError( wfMsg( 'illegalfilename', htmlspecialchars( $filtered ) ) );
			return  wfMsg( 'illegalfilename', htmlspecialchars( $filtered )  );
		}
		$nt =& Title::makeTitle( NS_IMAGE, $nt->getDBkey() );
		$this->mUploadSaveName = $nt->getDBkey();
		
		
		/**
		 * If the image is protected, non-sysop users won't be able
		 * to modify it by uploading a new revision.
		 */
		if( !$nt->userCanEdit() ) {
			return wfMsg( 'protectedpage' ) . " <b>" . $basename . "</b><br><br>" ;
		}
		
		/* Don't allow users to override the blacklist (check file extension) */
		global $wgStrictFileExtensions;
		global $wgFileExtensions, $wgFileBlacklist;
		if( UploadForm::checkFileExtensionList( $ext, $wgFileBlacklist ) ||
			($wgStrictFileExtensions &&
				!UploadForm::checkFileExtension( $finalExt, $wgFileExtensions ) ) ) {
			#return $this->uploadError( wfMsg( 'badfiletype', htmlspecialchars( $fullExt ) ) );
			return  wfMsg( 'badfiletype' , htmlspecialchars( $fullExt ) . " - <b>" . $basename . "</b><br><br>" );
		}
		
		/**
		 * Look at the contents of the file; if we can recognize the
		 * type but it's corrupt or data of the wrong type, we should
		 * probably not accept it.
		 */
		if( !$this->mStashed ) {
			$veri= $up->verify($this->mUploadTempName, $finalExt);
			
			if( $veri !== true ) { //it's a wiki error...
				return $this->uploadError( $veri->toString() );
			}
		}
		
		/**
		 * Check for non-fatal conditions
		 */
		if ( ! $this->mIgnoreWarning ) {
			$warning = '';
			
			global $wgCapitalLinks;
			if( $wgCapitalLinks ) {
				$filtered = ucfirst( $filtered );
			}
			if( $this->mUploadSaveName != $filtered ) {
				$warning .=  '<li>'.wfMsg( 'badfilename', htmlspecialchars( $this->mUploadSaveName ) ).'</li>';
			}
	
			global $wgCheckFileExtensions;
			if ( $wgCheckFileExtensions ) {
				if ( ! $up->checkFileExtension( $finalExt, $wgFileExtensions ) ) {
					$warning .= '<li>'.wfMsg( 'badfiletype', htmlspecialchars( $fullExt ) ).'</li>';
				}
			}
	
			global $wgUploadSizeWarning;
			if ( $wgUploadSizeWarning && ( $this->mUploadSize > $wgUploadSizeWarning ) ) {
				# TODO: Format $wgUploadSizeWarning to something that looks better than the raw byte
				# value, perhaps add GB,MB and KB suffixes?
				$warning .= '<li>'.wfMsg( 'largefile', $wgUploadSizeWarning, $this->mUploadSize ).'</li>';
			}
			if ( $this->mUploadSize == 0 ) {
				$warning .= '<li>'.wfMsg( 'emptyfile' ).'</li>';
			}
			
			if( $nt->getArticleID() ) {
				global $wgUser;
				$sk = $wgUser->getSkin();
				$dlink = $sk->makeKnownLinkObj( $nt );
				$warning .= '<li>'.wfMsg( 'fileexists', $dlink ).'</li>';
			}
			
			if( $warning != '' ) {
				/**
				 * Stash the file in a temporary location; the user can choose
				 * to let it through and we'll complete the upload then.
				 */
				return ($warning . "<br />");
			}
		}
		
		
		
		/**
		 * Try actually saving the thing...
		 * It will show an error form on failure.
		 */
		if( $up->saveUploadedFile( $this->mUploadSaveName,
		                             $this->mUploadTempName,
		                             !empty( $this->mSessionKey ) ) ) {
			/**
			 * Update the upload log and create the description page
			 * if it's a new file.
			 */
			
			#$img = Image::newFromName( $this->mUploadSaveName );
			$success = $this->recordUpload( $this->mUploadOldVersion,
			                                $this->mUploadDescription,
			                                $this->mUploadCopyStatus,
			                                $this->mUploadSource,
			                                $this->mWatchthis );

			if ( $success ) {
				# $this->showSuccess();
				# AWC - Edit...
				global $wgUser;
				$sk = $wgUser->getSkin();
				$dlink = $sk->makeKnownLinkObj( $nt );
				return wfMsg( 'fileuploaded', $this->mUploadSaveName, $dlink ) . "<br><br>";
			} else {
				// Image::recordUpload() fails if the image went missing, which is 
				// unlikely, hence the lack of a specialised message
				$wgOut->fileNotFoundError( $this->mUploadSaveName );
			}
			
		}
	}
	
	
	function recordUpload( $oldver, $desc, $copyStatus = '', $source = '', $watch = false ) {
		global $wgUser, $wgLang, $wgTitle, $wgDeferredUpdateList;
		global $wgUseCopyrightUpload, $wgUseSquid, $wgPostCommitUpdateList;

		$img = Image::newFromName( $this->mUploadSaveName );
		
		$fname = 'Image::recordUpload';
		$dbw =& wfGetDB( DB_MASTER );

		Image::checkDBSchema($dbw);

		// Delete thumbnails and refresh the metadata cache
		$img->purgeCache();
		
		

		// Fail now if the image isn't there
		if ( !$img->fileExists || $img->fromSharedDirectory ) {
			wfDebug( "Image::recordUpload: File ".$img->imagePath." went missing!\n" );
			return false;
		}

		if ( $wgUseCopyrightUpload ) {
			$textdesc = '== ' . wfMsg ( 'filedesc' ) . " ==\n" . $desc . "\n" .
			  '== ' . wfMsg ( 'filestatus' ) . " ==\n" . $copyStatus . "\n" .
			  '== ' . wfMsg ( 'filesource' ) . " ==\n" . $source ;
		} else {
			$textdesc = $desc;
		}

		$now = $dbw->timestamp();

		#split mime type
		if (strpos($img->mime,'/')!==false) {
			list($major,$minor)= explode('/',$img->mime,2);
		}
		else {
			$major= $img->mime;
			$minor= "unknown";
		}
		
		# Test to see if the row exists using INSERT IGNORE
		# This avoids race conditions by locking the row until the commit, and also
		# doesn't deadlock. SELECT FOR UPDATE causes a deadlock for every race condition.
		$dbw->insert( 'image',
			array(
				'img_name' => $img->name,
				'img_size'=> $img->size,
				'img_width' => IntVal( $img->width ),
				'img_height' => IntVal( $img->height ),
				'img_bits' => $img->bits,
				'img_media_type' => $img->type,
				'img_major_mime' => $major,
				'img_minor_mime' => $minor,
				'img_timestamp' => $now,
				'img_description' => $desc,
				'img_user' => $wgUser->getID(),
				'img_user_text' => $wgUser->getName(),
				'img_metadata' => $img->metadata,
			), $fname, 'IGNORE' 
		);
		
		$descTitle = $img->getTitle();
		$purgeURLs = array();
		
		$article = new Article( $descTitle );
		$minor = false;
		$watch = $watch || $wgUser->isWatched( $descTitle );
		$suppressRC = true; // There's already a log entry, so don't double the RC load
		
		if( $descTitle->exists() ) {
			// TODO: insert a null revision into the page history for this update.
			if( $watch ) {
				$wgUser->addWatch( $descTitle );
			}
			
			# Invalidate the cache for the description page
			$descTitle->invalidateCache();
			$purgeURLs[] = $descTitle->getInternalURL();
		} else {
			$this->insertNewArticle($article, $textdesc, $desc, $minor, $watch, $suppressRC );
		}
		
		
		# Invalidate cache for all pages using this image
		$linksTo = $img->getLinksTo();
		
		if ( $wgUseSquid ) {
			$u = SquidUpdate::newFromTitles( $linksTo, $purgeURLs );
			array_push( $wgPostCommitUpdateList, $u );
		}
		Title::touchArray( $linksTo );
		
		$log = new LogPage( 'upload' );
		$log->addEntry( 'upload', $descTitle, $desc );

		return true;
	}
	
	
	
	function insertNewArticle($article, $text, $summary, $isminor, $watchthis, $suppressRC=false, $comment=false ) {
		global $wgOut, $wgUser;
		global $wgUseSquid, $wgDeferredUpdateList, $wgInternalServer;
		
		$fname = 'Article::insertNewArticle';
		wfProfileIn( $fname );

		$article->mGoodAdjustment = $article->isCountable( $text );
		$article->mTotalAdjustment = 1;

		$ns = $article->mTitle->getNamespace();
		$ttl = $article->mTitle->getDBkey();
		
		

		# If this is a comment, add the summary as headline
		if($comment && $summary!="") {
			$text="== {$summary} ==\n\n".$text;
		}
		$text = $article->preSaveTransform( $text );
		$isminor = ( $isminor && $wgUser->isLoggedIn() ) ? 1 : 0;
		$now = wfTimestampNow();

		$dbw =& wfGetDB( DB_MASTER );

		# Add the page record; stake our claim on this title!
		$newid = $article->insertOn( $dbw );

		# Save the revision text...
		$revision = new Revision( array(
			'page'       => $newid,
			'comment'    => $summary,
			'minor_edit' => $isminor,
			'text'       => $text
			) );
		$revisionId = $revision->insertOn( $dbw );

		$article->mTitle->resetArticleID( $newid );

		# Update the page record with revision data
		$article->updateRevisionOn( $dbw, $revision, 0 );

		Article::onArticleCreate( $article->mTitle );
		if(!$suppressRC) {
			RecentChange::notifyNew( $now, $article->mTitle, $isminor, $wgUser, $summary, 'default',
			  '', strlen( $text ), $revisionId );
		}

		if ($watchthis) {
			#if(!$article->mTitle->userIsWatching()) $this->watch($article);
			if (wfRunHooks('WatchArticle', array(&$wgUser, &$article))) {
	
				$wgUser->addWatch( $article->mTitle );
				$wgUser->saveSettings();
	
				wfRunHooks('WatchArticleComplete', array(&$wgUser, &$article));
			}
		
		}

		# The talk page isn't in the regular link tables, so we need to update manually:
		$talkns = $ns ^ 1; # talk -> normal; normal -> talk
		$dbw->update( 'page',
			array( 'page_touched' => $dbw->timestamp($now) ),
			array( 'page_namespace' => $talkns,
			       'page_title' => $ttl ),
			$fname );

		# standard deferred updates
		$article->editUpdates( $text, $summary, $isminor, $now , $revisionId );
		
		 
		if($this->mprotect == "yes"){
			# $this->mprotect 
			# $this->mprotect_reason
			$id = $article->mTitle->getArticleID();
			$limit = 'sysop';
			
			$dbw->update( 'page',
				array( /* SET */
					'page_touched' => $dbw->timestamp(),
					'page_restrictions' => (string)$limit
				), array( /* WHERE */
					'page_id' => $id
				), 'Article::protect'
			);
			
			$restrictions = "move=" . $limit;
			$restrictions .= ":edit=" . $limit;
			if( !$moveonly ) {
				#$restrictions .= ":edit=" . $limit;
			}
			if (wfRunHooks('ArticleProtect', array(&$article, &$wgUser, $limit == 'sysop', $this->mprotect_reason, $moveonly))) {

				$dbw =& wfGetDB( DB_MASTER );
				$dbw->update( 'page',
							  array( /* SET */
									 'page_touched' => $dbw->timestamp(),
									 'page_restrictions' => $restrictions
									 ), array( /* WHERE */
											   'page_id' => $id
											   ), 'Article::protect'
							  );

				wfRunHooks('ArticleProtectComplete', array(&$article, &$wgUser, $limit == 'sysop', $this->mprotect_reason, $moveonly));

				$log = new LogPage( 'protect' );
				$log->addEntry( 'protect', $article->mTitle, $this->mprotect_reason );
				
			}

			
		
		}
		
		# AWC - Edit
		# Dont want ot redirect...
		#$oldid = 0; # new article
		#$article->showArticle( $text, wfMsg( 'newarticle' ), false, $isminor, $now, $summary, $oldid );
		#wfProfileOut( $fname );
	}
	
	function wadtch($article) {
	global $wgUser;


		if (wfRunHooks('WatchArticle', array(&$wgUser, &$article))) {

			$wgUser->addWatch( $article->mTitle );
			$wgUser->saveSettings();

			wfRunHooks('WatchArticleComplete', array(&$wgUser, &$article));
		}
		
	}
	
	
	
}

?>
