<?php
/**
 * it almost the same like UploadForm but it's ajax optimized
 * (no $wgOut->addHTML in execute, just returning Ajax response)
 *
 * @addtogroup SpecialPage
 */

class AjaxUploadForm extends UploadForm {

    public $mErrorMessage = null;
	public $mConvert = true;

    /**
     * contructor
     */
    public function __construct( &$request ) {

        #--- overwrite action parameter
        $_REQUEST["action"] = "submit";
        #--- and call parent
        parent::__construct( $request );
		
    }

    /**
     * Start doing stuff
     * @access public
     */
    function execute()
    {
        global $wgUser, $wgOut;
        global $wgEnableUploads, $wgUploadDirectory;

        # Check uploading enabled
        if( !$wgEnableUploads ) {
            return array( "error" => 1, "msg" => wfMsgForContent("uploaddisabledtext") );
        }

        # Check permissions
        if( !$wgUser->isAllowed( 'upload' ) ) {
            if( !$wgUser->isLoggedIn() ) {
                return array( "error" => 1, "msg" => wfMsg("uploadnologintext") );
            }
            else {
                return array( "error" => 1, "msg" => "You don't have permission to upload" );
            }
        }

        # Check blocks
        if( $wgUser->isBlocked() ) {
            #--- this should never happen
            return array( "error" => 1, "msg" => wfMsg("blockedtext") );
        }

        if( wfReadOnly() ) {
            return array( "error" => 1, "msg" => wfMsg("readonlytext") );
        }

        /** Check if the image directory is writeable, this is a common mistake */
        if( !is_writeable( $wgUploadDirectory ) ) {
            return array( "error" => 1, "msg" => wfMsg( 'upload_directory_read_only', $wgUploadDirectory ) );
        }

        #-- TODO - replace form with sensible info
        if( $this->mReUpload ) {
            if( !$this->unsaveUploadedFile() ) {
                return array( "error" => 0, "msg" => "unsaved file" );
            }
        }
        else if ( 'submit' == $this->mAction || $this->mUpload ) {
            $this->processUpload();
            if ( !empty( $this->mErrorMessage )) {
                return array( "error" => 1, "msg" => $this->mErrorMessage );
            }
        }

        $this->cleanupTempFile();
        return array( "error" => 0, "msg" =>  wfMsgHtml( 'successfulupload' ) );
    }

	/**
	 * @param string $error as HTML
	 * @access private, set $this->mErrorMessage
	 */
    function uploadError( $error )
    {
        $this->mErrorMessage = $error;
    }

	/**
	 * Checks if the mime type of the uploaded file matches the file extension.
	 *
	 * @param string $mime the mime type of the uploaded file
	 * @param string $extension The filename extension that the file is to be served with
	 * @return bool
	 */
	function verifyExtension( $mime, $extension ) {
		$fname = 'SpecialUpload::verifyExtension';

		$magic =& MimeMagic::singleton();

		if ( ! $mime || $mime == 'unknown' || $mime == 'unknown/unknown' )
			if ( ! $magic->isRecognizableExtension( $extension ) ) {
				wfDebug( "$fname: passing file with unknown detected mime type; unrecognized extension '$extension', can't verify\n" );
				return true;
			} else {
				wfDebug( "$fname: rejecting file with unknown detected mime type; recognized extension '$extension', so probably invalid file\n" );
				return false;
			}

		$match= $magic->isMatchingExtension($extension,$mime);

		if ($match===NULL) {
			wfDebug( "$fname: no file extension known for mime type $mime, passing file\n" );
			return true;
		} elseif ($match===true) {
			wfDebug( "$fname: mime type $mime matches extension $extension, passing file\n" );

			#TODO: if it's a bitmap, make sure PHP or ImageMagic resp. can handle it!
			return true;

		} else {
			return $this->convertImage( $mime, $extension );
		}
	}
	
	/**
	 * convertImage
	 *
	 * take tmp file, and if is not mime compatible convert via imagemagick
	 * to destination format. So far we assume that imagemagick is installed
	 * and working
	 * 
	 * @access public
	 * @author eloy@wikia
	 *
	 * @param string $mime: mime type
	 * @param string $extension: target image extension
	 *
	 * @return boolean: status of conversion
	 */ 
	public function convertImage( $mime, $extension )
	{
		global $wgImageMagickConvertCommand;
		$wgImageMagickComposeCommand = "/usr/bin/composite";
        $sBlankLogo = $GLOBALS["IP"]."/extensions/wikia/CustomizeWiki/templates/blank266x75.png";
		
		#--- failover to /opt/wikia/bin/composite
		if (!file_exists( $wgImageMagickComposeCommand ) ) {
			$wgImageMagickComposeCommand = "/opt/wikia/bin/composite";			
		}
	    $sTmpFile = $this->mUploadTempName.".".$extension;
        
        #--$cmd =  $wgImageMagickConvertCommand." -coalesce {$this->mUploadTempName} {$sTmpFile}";
		$cmd = wfEscapeShellArg( $wgImageMagickConvertCommand )
			. " -coalesce -size 500x150 "
			. wfEscapeShellArg( $this->mUploadTempName )
			. " -thumbnail '266x75>' -background transparent -gravity center -extent 266x75 "
			. wfEscapeShellArg( $sTmpFile );
		$err = wfShellExec( $cmd, $retval );
        
		$cmd = wfEscapeShellArg( $wgImageMagickComposeCommand )
			. " -compose over "
			. wfEscapeShellArg( $sTmpFile ) ." "
			. wfEscapeShellArg( $sBlankLogo ) ." "
			. wfEscapeShellArg( $this->mUploadTempName );
		$err = wfShellExec( $cmd, $retval );
                
		$this->uploadError( $err );
		return true;
	}
}
