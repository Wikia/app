<?php
/**
 * PhotoPop special page
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class PhotoPopSpecialPageController extends WikiaSpecialPageController {
	private $model;

	public function __construct() {
		parent::__construct( 'PhotoPopSetup', 'photopop_setup', false );
	}

	public function init() {
		$this->model = F::build( 'PhotoPopModel' );
	}

	public function index() {
		$this->wg->Out->setPageTitle( $this->wf->Msg( 'photopop-setup-title' ) );
		$this->response->addAsset( 'extensions/wikia/PhotoPop/css/PhotoPopSpecialPage.scss' );

		if( $this->wf->ReadOnly() ) {
			$this->wg->Out->readOnlyPage();
			return;
		}

		if( !$this->wg->User->isAllowed( 'photopop_setup' ) ) {
			throw new PermissionsError( 'photopop_setup' );
		}

		$this->forward( __CLASS__, 'setup' );
	}

	private function getData($category){
		$this->wf->profileIn( __METHOD__ );

		if ( empty( $category ) ) {
			$this->wf->profileOut( __METHOD__ );
			throw new WikiaException( 'Missing parameter: category' );
		}

		$result = $this->model->getGameContents( $category, 480, 320 );
		$this->wf->profileOut( __METHOD__ );

		return $result;
	}

	public function setup() {
		$this->wf->profileIn( __METHOD__ );

		$category = trim( $this->request->getVal( 'category' ) );
		$icon = trim( $this->request->getVal( 'icon' ) );
		$watermark = trim( $this->request->getVal( 'watermark' ) );
		$iconUrl = null;
		$currentCategory = $this->wf->Msg( 'photpop-category-none' );
		$currentCategoryUrl = null;
		$currentIconUrl = $this->wf->BlankImgUrl();
		$currentWatermarkUrl = $this->wf->BlankImgUrl();
		$cat = null;
		$message = null;
		$errors = array(
			'category' => array(),
			'icon' => array(),
			'db' => array()
		);
		$rounds = null;
		$images = array();

		$game = $this->model->getSettings( $this->wg->CityId );

		if ( !empty( $game ) ){
			$cat = F::build( 'Category', array( $game->category ), 'newFromName' );

			if ( $cat instanceof Category ) {
				$currentCategory = $cat->getName();
				$currentCategoryUrl = $cat->getTitle()->getLocalURL();
				$rounds = $this->getData($currentCategory);
			}

			if ( !empty( $game->thumbnail ) ) {
				$currentIconUrl = $game->thumbnail;
			}

			if ( !empty( $game->watermark ) ) {
				$currentWatermarkUrl = $game->watermark;
			}
		}

		if ( $this->request->wasPosted() ) {
			if ( !empty( $category ) ) {
				$cat = F::build( 'Category', array( $category ), 'newFromName' );

				if ( !( $cat instanceof Category && $cat->getID() !== false ) ) {
					$errors['category'][] = $this->wf->Msg( 'photopop-error-category-non-existing' );
				} else {
					$rounds = $this->getData($cat->getName());
				}

			} else {
				$errors['category'][] = $this->wf->Msg( 'photopop-error-field-compulsory' );
			}

			if ( !empty( $icon ) ) {
				$iconUrl = $this->model->getImageUrl( $icon );

				if ( empty( $iconUrl ) ) {
					$errors['icon'][] = $this->wf->Msg( 'photopop-error-file-non-existing' );
				}
			} else {
				$errors['icon'][] = $this->wf->Msg( 'photopop-error-field-compulsory' );
			}

			if ( !empty( $watermark ) ) {
				$watermarkUrl = $this->model->getImageUrl( $watermark );

				if ( empty( $watermark ) ) {
					$errors['icon'][] = $this->wf->Msg( 'photopop-error-file-non-existing' );
				}
			}

			if ( empty( $errors['category'] ) && empty( $errors['icon'] )  && empty( $errors['watermark'] ) ){
				if ( $this->model->saveSettings( $this->wg->CityId, $category, $iconUrl, $watermarkUrl ) !== false ) {
					$currentCategory = $cat->getName();
					$currentCategoryUrl = $cat->getTitle()->getLocalURL();
					$currentIconUrl = $iconUrl;
					$currentWatermarkUrl = $watermarkUrl;
					$message = $this->wf->Msg( 'photopop-settings-saved' );
				} else {
					$errors['db'][] = $this->wf->Msg( 'photopop-error-db-error' );
				}
			}
		}

		$this->response->setVal( 'category', $category );
		$this->response->setVal( 'icon', $icon );
		$this->response->setVal( 'watermark', $watermark );
		$this->response->setVal( 'currentCategory', $currentCategory );
		$this->response->setVal( 'currentCategoryUrl', $currentCategoryUrl );
		$this->response->setVal( 'currentIconUrl', $currentIconUrl );
		$this->response->setVal( 'currentWatermarkUrl', $currentWatermarkUrl );
		$this->response->setVal( 'images', $rounds);
		$this->response->setVal( 'errors', $errors );
		$this->response->setVal( 'message', $message );
		$this->wf->profileOut( __METHOD__ );
	}

}
