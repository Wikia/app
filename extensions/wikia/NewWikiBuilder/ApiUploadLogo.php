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
 *
 * When this becomes available, consider using it instead:
 * http://www.mediawiki.org/wiki/API:Edit_-_Uploading_files
 */

class ApiUploadLogo extends ApiBase {

	const LOGO_WIDTH = 216;
	const LOGO_HEIGHT = 155;
	const LOGO_TYPE = 'png';
	const LOGO_NAME = 'Image:Wiki.png';
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
		$outfile = tempnam(sys_get_temp_dir(), __METHOD__) . '.' . self::LOGO_TYPE;

		// Convert to correct size and format	
		$size = self::LOGO_WIDTH . 'x' . self::LOGO_HEIGHT;
		$cmd = "convert -quality " . self::LOGO_QUALITY . " -size $size -resize $size $infile $outfile";

		exec($cmd, $output, $returnVar);

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

        protected function getDB() {
                global $wgDBname;
                return wfGetDB(DB_MASTER, array(), $wgDBname);
        }

	private function usageCheck($params){
                $this->getMain()->requestWriteMode();
		if (empty($params['logo_file']) || empty($_FILES) || !empty($_FILES['error'])){
                        $this->dieUsageMsg(array('missingparam', 'logo_file'));
		}
		$titleObj = Title::newFromText($params['title']);
		if($params['createonly'] && $titleObj->exists()) {
                        $this->dieUsageMsg(array('createonly-exists'));
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
		$r['params'] = $params;
		$r['file_info'] = $_FILES;
		$convertedFile = $this->convert_logo($_FILES['logo_file']['tmp_name']);
		$r['converted_file'] = $convertedFile;

		// Save the resulting file Mediawiki. 

/*
		// Code pulled from SpecialMiniUpload
		$licenses = new Licenses(); // Just a weird fix
		global $wgRequest, $wgOut;

		// Disable redirects - this is what standard UploadForm do after succesful
		// upload of file
		$wgOut->enableRedirects(false);

		$UploadForm = new UploadForm();
		$UploadForm->execute();
*/


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

	public function getShowVersions() {
		echo "hi";
	}

}
