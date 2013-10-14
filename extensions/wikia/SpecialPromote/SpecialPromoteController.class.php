<?php

/**
 * Admin Upload Tool Controller
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

class SpecialPromoteController extends WikiaSpecialPageController {
	/**
	 * @var SpecialPromoteHelper
	 */
	protected $helper;

	protected $errors;

	public function __construct() {
		parent::__construct('Promote');

		if( $this->wg->User->isLoggedIn() ) {
		//fix for fb#49401 -- the page for anons looks better without this stylesheet
		//apparently it's also fix for fb#49394 -- the page for anons looks better without this stylesheet
		//FIXME: this is an asset of AdminDashboard extension; why is it added here? Maybe we should use some logic of AdminDashboard to load this asset and remove it from here
			$this->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/AdminDashboard/css/AdminDashboard.scss'));
		}

		$this->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/SpecialPromote/css/SpecialPromote.scss'));

		$this->helper = new SpecialPromoteHelper();
	}

	public function index() {
		if (!$this->checkAccess()) {
			return false;
		}
		$this->wg->out->setPageTitle(wfMsg('promote-title'));
		if ( !$this->app->checkSkin( 'oasis' ) ) {
			$this->wg->out->addWikiMsg( 'promote-error-oasis-only' );
			$this->skipRendering();
			return true;
		}

		$this->response->addAsset('extensions/wikia/SpecialPromote/js/SpecialPromote.js');

		JSMessages::enqueuePackage('SpecialPromote', JSMessages::EXTERNAL);

		$this->minHeaderLength = $this->helper->getMinHeaderLength();
		$this->maxHeaderLength = $this->helper->getMaxHeaderLength();
		$this->minDescriptionLength = $this->helper->getMinDescriptionLength();
		$this->maxDescriptionLength = $this->helper->getMaxDescriptionLength();

		$this->wikiHeadline = $this->helper->getWikiHeadline();
		$this->wikiDesc = $this->helper->getWikiDesc();
		$this->mainImage = $this->helper->getMainImage();
		$this->additionalImages = $this->helper->getAdditionalImages();
		$this->wikiStatus = $this->helper->getWikiStatusMessage($this->wg->CityId, $this->wg->contLang->getCode());

		$cityVisualization = new CityVisualization();
		$this->isCorpLang = $cityVisualization->isCorporateLang($this->wg->contLang->getCode());
	}

	protected function checkAccess() {
		if (!$this->wg->User->isLoggedIn() || !$this->wg->User->isAllowed('promote')) {
			if (!$this->request->isXmlHttp()) {
				$this->skipRendering();
				$this->specialPage->displayRestrictionError();
			}
			return false;
		}
		return true;
	}

	public function getUploadForm() {
		$this->checkAccess = $this->checkAccess();
		$this->uploadType = $this->request->getVal('uploadType');
		$this->imageIndex = $this->request->getVal('imageIndex',null);
	}

	public function removeTempImage() {
		if (!$this->checkAccess()) {
			return false;
		}

		$fileName = $this->request->getVal('fileName');
		$this->helper->removeTempImage($fileName);
	}

	public function uploadImage() {
		if (!$this->checkAccess()) {
			return false;
		}
		wfProfileIn(__METHOD__);
		$upload = new UploadVisualizationImageFromFile();

		$status = $this->helper->uploadImage($upload);

		$result = array();

		if ($status['status'] === 'uploadattempted' && $status['isGood']) {
			$file = $status['file'];
			$result['uploadType'] = $this->request->getVal('uploadType');
			$result['imageIndex'] = $this->request->getVal('imageIndex',null);

			if( $result['uploadType'] == 'additional' ) {
				$width = SpecialPromoteHelper::SMALL_IMAGE_WIDTH;
				$height = SpecialPromoteHelper::SMALL_IMAGE_HEIGHT;
			} else {
				$width = SpecialPromoteHelper::LARGE_IMAGE_WIDTH;
				$height = SpecialPromoteHelper::LARGE_IMAGE_HEIGHT;
			}

			$result['fileUrl'] = $this->helper->getImageUrl($file, $width, $height);
			$result['fileName'] = $file->getFileKey();

			if ($result['fileUrl'] == null || $result['fileName'] == null) {
				$result['errorMessages'] = array(wfMsg('promote-error-unknown-upload-error'));
			}
		} else if ($status['status'] === 'error') {
			$result['errorMessages'] = $status['errors'];
		}

		$this->result = $result;

		wfProfileOut(__METHOD__);
	}

	public function saveData() {
		if( !$this->checkAccess() ) {
			$this->success = false;
			$this->error = wfMsg('promote-wrong-rights');
			return;
		}

		wfProfileIn(__METHOD__);

		$data = $this->request->getParams();
		if(empty($data['additionalImagesNames'])) {
			$data['additionalImagesNames'] = array();
		}

		try {
			$this->helper->saveVisualizationData($data, $this->wg->contLang->getCode());
			$this->success = true;
		} catch(Exception $e) {
			$this->success = false;
			$this->error = $e->getMessage();
		}

		wfProfileOut(__METHOD__);
	}
}
