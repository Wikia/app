<?php
/* 
 * API module that facilitates uploading a logo. The API eqivalent of action=uploadlogo.
 * Requires API write mode to be enabled.
 *
 * Steps
 * 1. Sanity check on the file
 * 2. Convert it to the right type (LOGO_TYPE)
 * 3. Resize it to LOGO_WIDTH and LOGO_HEIGHT
 * 4. Save it in Mediawiki
 *
 * Someday:
 * Handle user defined cropping & zooming
 * Run "pngcrush" on the resulting image
 *
 * When this becomes available, consider using it instead:
 * http://www.mediawiki.org/wiki/API:Edit_-_Uploading_files
 */

class ApiUploadLogo extends ApiBase {

	const LOGO_WIDTH = 216;
	const LOGO_HEIGHT = 155;
	const LOGO_TYPE = 'png';
	const LOGO_NAME = 'Wiki2.png';
	const LOGO_QUALITY = 60; // The "quality" param passed to convert. Lower = smaller

	/* Takes an incoming filename and processes it as a Mediawiki logo,
	* 	
 	* Returns the file name of the resulting file or false on error */
	private function convert_logo($infile){
		if (!is_readable($infile)){
			$this->dieUsageMsg(array("infile $infile in not readable in for " . __METHOD__));
			return false;	
		}

		// Generate a temporary file name for the output file
		$dir = dirname($file);
		$outfile = tempnam(sys_get_temp_dir(), __FUNCTION__) . '.' . self::LOGO_TYPE;

		// Convert to correct size and format	
		// (Emil: wouldn't be better to use includes/media/Bitmap.php class?
		// We may use something else in future than ImageMagick so why to tighly-couple with it?)
		global $wgImageMagickConvertCommand, $wgImageMagickTempDir;
		if ( strval( $wgImageMagickTempDir ) !== '' ) {
			$tempEnv = 'MAGICK_TMPDIR=' . wfEscapeShellArg( $wgImageMagickTempDir ) . ' ';
		} else {
			$tempEnv = '';
		}
		$size = self::LOGO_WIDTH . 'x' . self::LOGO_HEIGHT;
		$cmd = $tempEnv . 
			wfEscapeShellArg( $wgImageMagickConvertCommand ) .
			" -quality " . self::LOGO_QUALITY . 
			" -size $size" .
			" -resize $size" .
			" " . wfEscapeShellArg( $infile ) .
			" " . wfEscapeShellArg( $outfile );

		wfShellExec($cmd, $returnVar);

		if ($returnVar === 0){
			return $outfile;
		} else {
                        $this->dieUsageMsg(array("Error converting image"));
			return false;
		}
	}


        public function __construct($main, $action) {
                parent :: __construct($main, $action);
        }

	private function usageCheck($params){
                $this->getMain()->requestWriteMode();
		if (empty($params['logo_file']) || empty($_FILES) || !empty($_FILES['error'])){
                        $this->dieUsageMsg(array('missingparam', 'logo_file'));
		}

                global $wgEnableUploads;

                # Check uploading enabled
                if( !$wgEnableUploads ) {
                        $this->dieUsageMsg(array('uploaddisabled', 'uploaddisabledtext'));
                        return false;
                }

                # Check permissions
		global $wgUser;
                if( !$wgUser->isAllowed( 'upload' ) ) {
                        if( !$wgUser->isLoggedIn() ) {
                                $this->dieUsageMsg( array('anonymous-users-cantupload'));
                        } else {
				$this->dieUsageMsg( array("permission-denied-upload"));
                        }
                        return false;
                }

		global $wgTitle;
		$wgTitle = Title::newFromText($params['title']);
		if($params['createonly'] && $wgTitle->exists()) {
                        $this->dieUsageMsg(array('createonly-exists'));
			return false;
		}

		return true;
	}

	/**
	 * If the uplaod succeeds, the
	 * details of the image added to the result object.
	 */

	public function execute() {
                $params = $this->extractRequestParams();
		if (empty($params['title'])){
			$params['title'] = self::LOGO_NAME;
		}
		$params = array_merge($params, $_FILES);

		$this->usageCheck($params);

        	$r = array();
		$r['file_info'] = $_FILES;
		$convertedFile = $this->convert_logo($_FILES['logo_file']['tmp_name']);
		$r['converted_file'] = $convertedFile;

		// Save the resulting file Mediawiki. 
                $licenses = new Licenses(); // Just a weird fix
                global $wgRequest, $wgOut;

                # Set OutputPage object to contain only article body,
                # without skin parts (header&footer)
                $wgOut->setArticleBodyOnly(true);

                # Disable redirects - this is what standard UploadForm do after succesfull
                # upload of file
                $wgOut->enableRedirects(false);

                # Create UploadForm object (standard Special:Upload) and pass to it
                # request object which was sent to this page

                $Upload = new UploadFromApi( $wgRequest , $params['title']);
		$Upload->initializeFromApi($params, $convertedFile);
		$Upload->execute();

		// Everything go ok?
		if (!empty($Upload->upload_error)){
			$this->getResult()->addValue(null, error, array('info' => $Upload->upload_error));
			return;
		}

                # Get whole output (HTML) from above initializated UploadForm object
                $html = $wgOut->getHTML();

                # Clear HTML output for OutputPage object
                $wgOut->clearHTML();

                if(is_object($Upload->mLocalFile)) {

                        $img = $Upload->mLocalFile;

                        $r['image_info'] = array(
                                'width' => $img->getWidth(),
                                'height' => $img->getHeight(),
                                'url' => $img->getFullUrl(),
                                'name' => $img->getName(),
                        );
		}

		$this->getResult()->addValue(null, $this->getModuleName(), $r);
	}

	public function mustBePosted() { return true; }

	public function getAllowedParams() {
		return array (
			'title' => null,
			'createonly' => null
		);
	}

	public function getParamDescription() {
		return array (
			'title' => 'Title to save the file to. Default to ' . self::LOGO_NAME . ". Handy to change if you want to preview it first",
			'createonly' => "If the logo exists already, don't overwrite it",
			'logo_file' =>  "The file to be uploaded, using <input type=file> and enctype=multipart/form-data"
		);
	}

	public function getDescription() {
		return array(
			'Upload a logo. Take the incoming file convert/resize it to the right image format, and save it to Wiki.png'
		);
	}

	protected function getExamples() {
		return array (
			'api.php?action=uploadlogo&file=fileupload',
			'api.php?action=uploadlogo&file=fileupload&preview=true',
		);
	}
        public function getVersion() { return __CLASS__ . ': $Id: '.__CLASS__.'.php '.filesize(dirname(__FILE__)."/".__CLASS__.".php").' '.strftime("%Y-%m-%d %H:%M:%S", time()).'Z wikia $'; }

}


class UploadFromApi extends UploadForm {

        function initializeFromApi ( $params, $convertedFile ) {
		$this->mTempPath = $convertedFile;
		$this->mFileSize = filesize($convertedFile);
		$this->mSrcName = $params['title'];
		$this->mStashed = false;
		$this->mSessionkey = false;
		$this->removeTempFile = true;
		$this->mAction = "submit";
		$this->mIgnoreWarning = true;
		if (empty($params['createonly'])){
			$this->mDestWarningAck = true;
		}
	}

	/* Overwrite the default here so we can capture the error messages */
	function processUpload() {
                $details = null;
                $value = $this->internalProcessUpload( $details );
		if ($value == self::SUCCESS){
			$this->upload_error = null;
		} else {
			$this->upload_error = "Error uploading image, code $value: " . print_r($details, true);
		}
	}
}
