<?php

global $IP ;
require_once ("$IP/includes/specials/SpecialUpload.php") ;

class CreatePageImageUploadForm extends UploadForm {
    var $mParameterExt, $mStoredDestName, $mLastTimestamp, $mReturnedTimestamp ;

    /**
     * contructor
     */
    public function __construct( &$request ) {

        #--- overwrite action parameter
        $_REQUEST["action"] = "submit";

        error_log( __METHOD__ );
        #--- and call parent
        parent::__construct( $request );
        error_log( __METHOD__ );
    }

    /**
     * Start doing stuff
     * @access public
     */
    function execute() {
                global $wgUser, $wgOut;
                global $wgEnableUploads;

                # Check uploading enabled
                if( !$wgEnableUploads ) {
            		return array( "error" => 1, "msg" => wfMsg ('uploaddisabledtext'), "once" => true );
                }

                # Check permissions
                if( !$wgUser->isAllowed( 'upload' ) ) {
                        if( !$wgUser->isLoggedIn() ) {
                		return array( "error" => 1, "msg" => "cp_no_login", "once" => true );
                        } else {
                		return array( "error" => 1, "msg" => wfMsg ('badaccess-group0'), "once" => true );
                        }
                        return;
                }

                # Check blocks
                if( $wgUser->isBlocked() ) {
			return array( "error" => 1, "msg" => wfMsg ('blockedtext'), "once" => true );
                }

                if( wfReadOnly() ) {
			return array( "error" => 1, "msg" => wfMsg ('createpage_upload_directory_read_only'), "once" => true );			
                }

		$Response = $this->processUpload();
		if (is_string($Response) ) {
			return array( "error" => 1, "msg" => $Response, "once" => false );
		}

		$this->cleanupTempFile();
		if ($this->mSrcName != '') {
			if ($this->mDestName != '') {
		        	return array( "error" => 0, "msg" => "Image:" . $this->mDestName, "timestamp" => $this->mDestName, "once" => false ) ;
			} else {
		        	return array( "error" => 0, "msg" => "Image:" . wfBaseName ($this->mSrcName), "timestamp" => wfBaseName ($this->mSrcName) , "once" => false ) ;
			}
		} else {
	        	return array( "error" => 1, "msg" => wfMsg ('uploaderror'), "once" => true ) ;
		}
    }

	function processUpload () {
                global $wgUser, $wgOut, $wgFileExtensions;
                $details = null;
                $value = null;
                $value = $this->internalProcessUpload( $details );

                switch($value) {
                        case self::SUCCESS:
			    // don't... do... REDIRECT
                            return ;

                        case self::BEFORE_PROCESSING:
                                return false;

                        case self::LARGE_FILE_SERVER:
                                return wfMsg ('largefileserver') ;

                        case self::EMPTY_FILE:
                                return wfMsg ('emptyfile') ;

                        case self::MIN_LENGHT_PARTNAME:
                                return wfMsg ('minlength1') ;
                            return;

                        case self::ILLEGAL_FILENAME:
                                $filtered = $details['filtered'];
                                return wfMsg ('illegalfilename', $filtered) ;

                        case self::PROTECTED_PAGE:
                                return wfMsg ('protectedpage') ;

                        case self::OVERWRITE_EXISTING_FILE:
                                $errorText = $details['overwrite'];
                                $overwrite = new WikiError( $wgOut->parse( $errorText ) );
                                return $overwrite->toString() ;

                        case self::FILETYPE_MISSING:
                                return wfMsg ('filetype-missing') ;

                        case self::FILETYPE_BADTYPE:
                                $finalExt = $details['finalExt'];
                                return wfMsg ('filetype-badtype') ;

                        case self::VERIFICATION_ERROR:
                                $veri = $details['veri'];
                                return $veri->toString() ;

                        case self::UPLOAD_VERIFICATION_ERROR:
                                $error = $details['error'];
                                return $error ;

                        case self::UPLOAD_WARNING:
                                $warning = $details['warning'];
                                return $warning ;
                }
                 new MWException( __METHOD__ . ": Unknown value `{$value}`" );
	}

	function getQuickTimestamp ($img_name) {
		$dbr = wfGetDB( DB_SLAVE );
		$resource = $dbr->select( 'image',
					array(
						'img_timestamp',
					     ),
					array( 'img_name' => $img_name ),
					__METHOD__
				) ;
		if ( 0 == $dbr->numRows( $resource ) ) {
			$dbr->freeResult($resource);
			return FALSE;
		}

		$res_obj = $dbr->fetchObject ($resource) ;
		return ($res_obj->img_timestamp) ;		       
	}

	/*	since we wanted to mess up heavily here...
		I'm copying this stuff too
	*/
       function internalProcessUpload( &$resultDetails ) {
                global $wgUser;

                /* Check for PHP error if any, requires php 4.2 or newer */
                if( $this->mCurlError == 1/*UPLOAD_ERR_INI_SIZE*/ ) {
                        return self::LARGE_FILE_SERVER;
                }

                /**
                 * If there was no filename or a zero size given, give up quick.
                 */
                if( trim( $this->mSrcName ) == '' || empty( $this->mFileSize ) ) {
                        return self::EMPTY_FILE;
                }

                # Chop off any directories in the given filename
                if( $this->mDesiredDestName ) {
                        $basename = $this->mDesiredDestName . '.' . $this->mParameterExt ;
			$this->mStoredDestName = $this->mDesiredDestName ;
                } else {
                        $basename = $this->mSrcName;
                }
                $filtered = wfBaseName( $basename );

                /**
                 * We'll want to blacklist against *any* 'extension', and use
                 * only the final one for the whitelist.
                 */
                list( $partname, $ext ) = $this->splitExtensions( $filtered );

               if( count( $ext ) ) {
                        $finalExt = $ext[count( $ext ) - 1];
                } else {
                        $finalExt = '';
                }

                # If there was more than one "extension", reassemble the base
                # filename to prevent bogus complaints about length
                if( count( $ext ) > 1 ) {
                        for( $i = 0; $i < count( $ext ) - 1; $i++ )
                                $partname .= '.' . $ext[$i];
                }

                if( strlen( $partname ) < 1 ) {
                        return self::MIN_LENGHT_PARTNAME;
                }

                /**
                 * Filter out illegal characters, and try to make a legible name
                 * out of it. We'll strip some silently that Title would die on.
                 */
                $filtered = preg_replace ( "/[^".Title::legalChars()."]|:/", '-', $filtered );
                $nt = Title::makeTitleSafe( NS_IMAGE, $filtered );

                if( is_null( $nt ) ) {
                        $resultDetails = array( 'filtered' => $filtered );
                        return self::ILLEGAL_FILENAME;
                }
                $this->mLocalFile = wfLocalFile( $nt );
                $this->mDestName = $this->mLocalFile->getName();

                /**
                 * If the image is protected, non-sysop users won't be able
                 * to modify it by uploading a new revision.
                 */
                if( !$nt->userCan( 'edit' ) ) {
                        return self::PROTECTED_PAGE;
                }

                /**
                 * In some cases we may forbid overwriting of existing files.
                 */

		// here starts the interesting part... 
		// we overwrite mDestName and give it a new twist
		$timestamp = "" ;						
                $img_found = wfFindFile ($this->mDestName) ;
		if ($img_found) {
			// ehhh... 
			// we'll do it hard way then...
			$timestamp = $this->mDestName ;	
		} else { //this timestamp should not repeat...
			$timestamp = "invalid" ;
		}
		$tempname = "" ;
		$tmpcount = 0 ;

		while ($img_found && ($timestamp != $this->mLastTimestamp)) {
			$tmpcount++ ;
			$file_ext = split ("\.", $this->mDestName) ;
			$file_ext = $file_ext [0] ;
			$tmpdestname = $file_ext ;
			$tempname = $tmpdestname . $tmpcount . '.' . $this->mParameterExt ;
			$timestamp = $tempname ;
			$img_found = wfFindFile ($tempname) ;								
		}

		if ($tmpcount > 0)  {
			wfLocalFile( $title ) ;			
			$tempname = preg_replace ( "/[^".Title::legalChars()."]|:/", '-', $tempname );
	                $nt = Title::makeTitleSafe( NS_IMAGE, $tempname );
	                $this->mLocalFile = wfLocalFile( $nt );
	                $this->mDestName = $this->mLocalFile->getName();
			$this->mDesiredDestName = $this->mStoredDestName . $tmpcount . '.' . $this->mParameterExt ;
		} else { // append the extension anyway
			$this->mDesiredDestName = $this->mStoredDestName . '.' . $this->mParameterExt ;
		}
		
                $overwrite = $this->checkOverwrite( $this->mDestName );
                if( $overwrite !== true ) {
                        $resultDetails = array( 'overwrite' => $overwrite );
                        return self::OVERWRITE_EXISTING_FILE;
                }

                /* Don't allow users to override the blacklist (check file extension) */
                global $wgStrictFileExtensions;
                global $wgFileExtensions, $wgFileBlacklist;

               if ($finalExt == '') {
                        return self::FILETYPE_MISSING;
                } elseif ( $this->checkFileExtensionList( $ext, $wgFileBlacklist ) ||
                                ($wgStrictFileExtensions && !$this->checkFileExtension( $finalExt, $wgFileExtensions ) ) ) {
                        $resultDetails = array( 'finalExt' => $finalExt );
                        return self::FILETYPE_BADTYPE;
                }

                /**
                 * Look at the contents of the file; if we can recognize the
                 * type but it's corrupt or data of the wrong type, we should
                 * probably not accept it.
                 */
                if( !$this->mStashed ) {
                        $this->mFileProps = File::getPropsFromPath( $this->mTempPath, $finalExt );
                        $this->checkMacBinary();
                        $veri = $this->verify( $this->mTempPath, $finalExt );

                        if( $veri !== true ) { //it's a wiki error...
                                $resultDetails = array( 'veri' => $veri );
                                return self::VERIFICATION_ERROR;
                        }

                        /**
                         * Provide an opportunity for extensions to add further checks
                         */
                        $error = '';
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
                        if( $basename != $filtered ) {
                                $warning .=  '<li>'.wfMsgHtml( 'badfilename', htmlspecialchars( $this->mDestName ) ).'</li>';
                        }

                        global $wgCheckFileExtensions;

                        if ( $wgCheckFileExtensions ) {
                                if ( ! $this->checkFileExtension( $finalExt, $wgFileExtensions ) ) {
                                        $warning .= '<li>'.wfMsgExt( 'filetype-badtype', array ( 'parseinline' ),
                                                htmlspecialchars( $finalExt ), implode ( ', ', $wgFileExtensions ) ).'</li>';
                                }
                        }

                        global $wgUploadSizeWarning;
                        if ( $wgUploadSizeWarning && ( $this->mFileSize > $wgUploadSizeWarning ) ) {
                                $skin = $wgUser->getSkin();
                                $wsize = $skin->formatSize( $wgUploadSizeWarning );
                                $asize = $skin->formatSize( $this->mFileSize );
                                $warning .= '<li>' . wfMsgHtml( 'large-file', $wsize, $asize ) . '</li>';
                        }
                        if ( $this->mFileSize == 0 ) {
                                $warning .= '<li>'.wfMsgHtml( 'emptyfile' ).'</li>';
                        }

                        if ( !$this->mDestWarningAck ) {
                                $warning .= self::getExistsWarning( $this->mLocalFile );
                        }
                        if( $warning != '' ) {
                                /**
                                 * Stash the file in a temporary location; the user can choose
                                 * to let it through and we'll complete the upload then.
                                 */
                                $resultDetails = array( 'warning' => $warning );
                                return self::UPLOAD_WARNING;
                        }
                }

                /**
                 * Try actually saving the thing...
                 * It will show an error form on failure.
                 */
                $pageText = self::getInitialPageText( $this->mComment, $this->mLicense,
                        $this->mCopyrightStatus, $this->mCopyrightSource );

                $status = $this->mLocalFile->upload( $this->mTempPath, $this->mComment, $pageText,
                        File::DELETE_SOURCE, $this->mFileProps );
                if ( !$status->isGood() ) {
                        $this->showError( $status->getWikiText() );
                } else {
                        if ( $this->mWatchthis ) {
                                global $wgUser;
                                $wgUser->addWatch( $this->mLocalFile->getTitle() );
                        }
                        // Success, redirect to description page
       			$this->mReturnedTimestamp = $this->getQuickTimestamp ($this->mDestName) ; 					
                        $img = null; // @todo: added to avoid passing a ref to null - should this be defined somewhere?			
                        return self::SUCCESS;
                }
        }

    function showSuccess () {
	global $wgOut ;

    }

}

?>
