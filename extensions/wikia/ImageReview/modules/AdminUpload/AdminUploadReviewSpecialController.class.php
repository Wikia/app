<?php

class AdminUploadReviewSpecialController extends ImageReviewSpecialController {
	const DEFAUL_IMAGE_SIZE = 320;

	public function __construct() {
		WikiaSpecialPageController::__construct('AdminUploadReview', 'adminuploaddirt', false /* $listed */);
	}

	protected function getPageTitle() {
		return 'Admin Upload Review tool';
	}

	public function index() {
		parent::index();
		$this->response->getView()->setTemplate('ImageReviewSpecialController', 'index');
	}

	public function stats() {
		parent::stats();
		$this->response->getView()->setTemplate('ImageReviewSpecialController', 'stats');
	}

	protected function getHelper() {
		return F::build( 'AdminUploadReviewHelper' );
	}

	protected function getBaseUrl() {
		return Title::newFromText('AdminUploadReview', NS_SPECIAL)->getFullURL();
	}

	protected function getToolName() {
		return 'Admin Upload Review';
	}

	protected function getStatsPageTitle() {
		return 'Admin Upload Review tool statistics';
	}

	public function copyVisualizationImage() {
		$this->wf->ProfileIn( __METHOD__ );

		$status = false;
		$helper = F::build('AdminUploadReviewHelper', array());

		//TODO: get those parameters from request
		$wikiId = 147; //starwars/wookiepedia http://starwars.nandy.wikia-dev.com/
		$imageId = 365501; //http://starwars.nandy.wikia-dev.com/wiki/File:Wikia-Visualization-Add-3.jpg
		$lang = $this->wg->contLang->getCode();

		if( !$this->isVisualizationOn($lang) ) {
			$this->wf->ProfileOut( __METHOD__ );
			$this->result = array(
				'status' => $status,
				'errorMsg' => wfMsg('admindirt-copy-image-wrong-corporate-wiki'),
			);

			$this->wf->ProfileOut( __METHOD__ );
			return;
		}

		$origFileTitle = GlobalTitle::newFromId($imageId, $wikiId);
		$origFileUrl = urldecode($helper->getImageUrl($wikiId, $imageId, self::DEFAUL_IMAGE_SIZE));

		$destWikiId = isset($this->wg->CorporatePagesWithVisualization[$lang]) ? $this->wg->CorporatePagesWithVisualization[$lang] : false;
		$destWikiUrl = WikiFactory::getVarValueByName('wgServer', $destWikiId);
		$destImgName = $helper->createDestFileName($wikiId, $origFileTitle);

		if( $this->wg->DevelEnvironment ) {
			switch($destWikiUrl) {
				case 'http://www.de.wikia.com':
					$destWikiUrl = 'http://de.nandy.wikia-dev.com';
					break;
				default:
					$destWikiUrl = 'http://wikiaglobal.nandy.wikia-dev.com';
					break;
			}
		}

		if( !empty($destImgName) && !empty($destWikiUrl) ) {
			$entryPoint = $destWikiUrl.'/wikia.php?controller=AdminUploadReviewSpecial&method=uploadFromUrl&format=json';
			$requestUrl = $entryPoint.'&imgUrl='.urlencode($origFileUrl);
			$requestUrl .= '&dstImgName='.urlencode($destImgName);

			$response = Http::get($requestUrl);
			$response = json_decode($response);

			$status = $response->result->success;

			if( (!empty($response->result->errors)) ) {
				$errorMsg = ( $response->result->errors[0] == 'admindirt-copy-image-no-rights' ) ? wfMsg('admindirt-copy-image-no-rights') : wfMsg('admindirt-copy-image-error-while-copying');
			} else {
				$errorMsg = '';
			}

			$this->result = array(
				'status' => $status,
				'errorMsg' => $errorMsg,
			);
		} else {
			$this->result = array(
				'status' => $status,
				'errorMsg' => wfMsg('admindirt-copy-image-invalid-dest-file-name-or-dest-wiki-url'),
			);
		}

		$this->wf->ProfileOut( __METHOD__ );
	}

	public function removeVisualizationImage($wikiId, $imageId, $lang) {
		$this->wf->ProfileIn( __METHOD__ );
		$status = false;
		$helper = F::build('AdminUploadReviewHelper', array());

		//TODO: get those parameters from request
		$wikiId = 147; //starwars/wookiepedia http://starwars.nandy.wikia-dev.com/
		$imageId = 365501; //http://starwars.nandy.wikia-dev.com/wiki/File:Wikia-Visualization-Add-3.jpg
		$lang = $this->wg->contLang->getCode();

		if( !$this->isVisualizationOn($lang) ) {
			$this->wf->ProfileOut( __METHOD__ );
			$this->result = array(
				'status' => $status,
				'errorMsg' => wfMsg('admindirt-copy-image-wrong-corporate-wiki'),
			);

			$this->wf->ProfileOut( __METHOD__ );
			return;
		}

		$this->wf->ProfileOut( __METHOD__ );
	}

	/**
	 * TODO: should we keep it here, create WikiaVisualizationService or put it to WikiHomePageHelper and create dependency?
	 */
	public function isVisualizationOn($lang) {
		$this->wf->ProfileIn( __METHOD__ );

		$lang = strtolower($lang);
		if( in_array($lang, array_keys($this->wg->CorporatePagesWithVisualization)) ) {
			$this->wf->ProfileOut( __METHOD__ );
			return true;
		}

		$this->wf->ProfileOut( __METHOD__ );
		return false;
	}

	public function uploadFromUrl() {
		$this->wf->ProfileIn( __METHOD__ );

		/* TODO: allow only logged-in users with proper rights
		if( !$this->wg->User->isLoggedIn() || !$this->wg->User->isAllowed( 'rejectedimagereview' ) ) {
			$this->result = array(
				'success' => false,
				'errors' => array('admindirt-copy-image-no-rights'),
			);
			return;
		}
		*/

		$imageUrl = urldecode($this->request->getVal('imgUrl', false));
		$dstImageName = urldecode($this->request->getVal('dstImgName', false));

		$data = array(
			'wpUpload' => 1,
			'wpSourceType' => 'web',
			'wpUploadFileURL' => $imageUrl
		);

		$upload = F::build('UploadFromUrl');
		$upload->initializeFromRequest(F::build('FauxRequest', array($data, true)));
		$upload->fetchFile();
		$upload->verifyUpload();

		// create destination file
		$title = Title::newFromText($dstImageName, NS_FILE);
		$file = F::build(
			'WikiaLocalFile',
			array(
				$title,
				RepoGroup::singleton()->getLocalRepo()
			)
		);

		/* real upload */
		$result = $file->upload(
			$upload->getTempPath(),
			$dstImageName,
			$dstImageName,
			File::DELETE_SOURCE
		);

		$this->result = array(
			'success' => $result->ok,
			'errors' => $result->errors,
		);

		$this->wf->ProfileIn( __METHOD__ );
	}
}
