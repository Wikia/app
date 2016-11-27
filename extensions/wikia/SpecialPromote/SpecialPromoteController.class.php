<?php

/**
 * Admin Upload Tool Controller
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

use \Wikia\Logger\WikiaLogger;


class SpecialPromoteController extends WikiaSpecialPageController {
	/**
	 * @var SpecialPromoteHelper
	 */
	protected $helper;

	protected $errors;

	public function __construct() {
		parent::__construct( 'Promote' );
		$this->helper = new SpecialPromoteHelper();
	}

	public function index() {
		if ( !$this->checkAccess() ) {
			return false;
		}
		$this->wg->out->setPageTitle( wfMsg( 'promote-title' ) );
		if ( !$this->app->checkSkin( 'oasis' ) ) {
			$this->wg->out->addWikiMsg( 'promote-error-oasis-only' );
			$this->skipRendering();

			return true;
		}

		$this->response->addAsset( 'extensions/wikia/SpecialPromote/css/SpecialPromote.scss' );
		$this->response->addAsset( 'extensions/wikia/SpecialPromote/js/SpecialPromote.js' );

		JSMessages::enqueuePackage( 'SpecialPromote', JSMessages::EXTERNAL );

		$this->minHeaderLength      = $this->helper->getMinHeaderLength();
		$this->maxHeaderLength      = $this->helper->getMaxHeaderLength();
		$this->minDescriptionLength = $this->helper->getMinDescriptionLength();
		$this->maxDescriptionLength = $this->helper->getMaxDescriptionLength();

		$this->wikiHeadline     = $this->helper->getWikiHeadline();
		$this->wikiDesc         = $this->helper->getWikiDesc();
		$this->mainImage        = $this->helper->getMainImage();
		$this->additionalImages = $this->helper->getAdditionalImages();
		$this->wikiStatus       = $this->helper->getWikiStatusMessage( $this->wg->CityId, $this->wg->contLang->getCode() );

		$cityVisualization = new CityVisualization();
		$this->isCorpLang  = $cityVisualization->isCorporateLang( $this->wg->contLang->getCode() );
	}

	protected function checkAccess() {
		/**
		 * We are checking if the user has perms to Disabled Promote (PLA-1823)
		 * to display message about Promote being disabled to the user
		 */
		if ( !$this->wg->User->isLoggedIn() || !$this->wg->User->isAllowed( 'restricted_promote' ) ) {
			if ( !$this->request->isXmlHttp() ) {

				$this->wg->Out->clearHTML();
				$this->wg->Out->setPageTitle( wfMessage('promote-extension-under-rework-header')->plain() );
				$this->wg->Out->addHTML( wfMessage('promote-extension-under-rework')->parse() );

				$this->skipRendering();
			}

			return false;
		}

		return true;
	}

	public function getUploadForm() {
		if ( !$this->checkAccess() ) {
			$this->setVal( 'errorMessage', wfMessage( 'promote-wrong-rights' )->plain() );

			return;
		}
		if ( empty( $this->wg->EnableUploads ) ) {
			$this->setVal( 'errorMessage', wfMessage( 'promote-upload-image-uploads-disabled' )->plain() );

			return;
		}

		$uploadType   = $this->request->getVal( 'uploadType' );
		$templateData = [
			'wgScriptPath' => $this->wg->ScriptPath,
			'uploadType'   => $uploadType,
			'imageIndex'   => $this->request->getVal( 'imageIndex', null )
		];

		if ( $uploadType == 'main' ) {
			$this->setVal( 'title', wfMessage( 'promote-upload-main-image-form-modal-title' )->plain() );
			$templateData['copy'] = wfMessage( 'promote-upload-main-image-form-modal-copy' )->plain();
		} else {
			$this->setVal( 'title', wfMessage( 'promote-upload-additional-image-form-modal-title' )->plain() );
			$templateData['copy'] = wfMessage( 'promote-upload-additional-image-form-modal-copy' )->plain();
		}

		$this->setVal( 'html', ( new Wikia\Template\MustacheEngine )
			->setPrefix( dirname( __FILE__ ) . '/templates' )
			->setData( $templateData )
			->render( 'SpecialPromote_getUploadForm.mustache' ) );
		$this->setVal( 'labelSubmit', wfMessage( 'promote-upload-submit-button' )->plain() );
		$this->setVal( 'labelCancel', wfMessage( 'promote-upload-form-modal-cancel' )->plain() );
	}

	public function removeTempImage() {
		if ( !$this->checkAccess() ) {
			return false;
		}

		$fileName = $this->request->getVal( 'fileName' );
		$this->helper->removeTempImage( $fileName );
	}

	public function uploadImage() {
		if ( !$this->checkAccess() ) {
			return false;
		}
		wfProfileIn( __METHOD__ );
		$upload = new UploadVisualizationImageFromFile();

		$status = $this->helper->uploadImage( $upload );

		$result = array();

		if ( $status['status'] === 'uploadattempted' && $status['isGood'] ) {
			$file                 = $status['file'];
			$result['uploadType'] = $this->request->getVal( 'uploadType' );
			$result['imageIndex'] = $this->request->getVal( 'imageIndex', null );

			if ( $result['uploadType'] == 'additional' ) {
				$width  = SpecialPromoteHelper::SMALL_IMAGE_WIDTH;
				$height = SpecialPromoteHelper::SMALL_IMAGE_HEIGHT;
			} else {
				$width  = SpecialPromoteHelper::LARGE_IMAGE_WIDTH;
				$height = SpecialPromoteHelper::LARGE_IMAGE_HEIGHT;
			}

			$result['fileUrl']  = $this->helper->getImageUrl( $file, $width, $height );
			$result['fileName'] = $file->getFileKey();

			if ( $result['fileUrl'] == null || $result['fileName'] == null ) {
				$result['errorMessages'] = array( wfMsg( 'promote-error-unknown-upload-error' ) );
			}
		} else if ( $status['status'] === 'error' ) {
			$result['errorMessages'] = $status['errors'];
		}

		$this->result = $result;

		wfProfileOut( __METHOD__ );
	}

	public function saveData() {
		
		if ( !$this->checkAccess() ) {
			$this->success = false;
			$this->error   = wfMsg( 'promote-wrong-rights' );

			return;
		}

		wfProfileIn( __METHOD__ );

		$data = $this->request->getParams();
		if ( empty( $data['additionalImagesNames'] ) ) {
			$data['additionalImagesNames'] = array();
		}
		WikiaLogger::instance()->debug( "SpecialPromote", ['method' => __METHOD__, 'data'=> $data] );

		try {
			$this->helper->saveVisualizationData( $data, $this->wg->contLang->getCode() );
			$this->success = true;
			$this->helper->triggerReindexing();
		} catch ( Exception $e ) {
			$this->success = false;
			$this->error   = $e->getMessage();
		}

		wfProfileOut( __METHOD__ );
	}
}
