<?php
/**
 * PhotoPop special page
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class PhotoPopSpecialPageController extends WikiaSpecialPageController {
	/* @var PhotoPopModel */
	private $model;

	public function __construct() {
		parent::__construct( 'PhotoPopSetup', 'photopop_setup', false );
	}

	public function init() {
		$this->model = (new PhotoPopModel);
	}

	public function index() {
		$this->wg->Out->setPageTitle( wfMsg( 'photopop-setup-title' ) );
		$this->response->addAsset( 'extensions/wikia/PhotoPop/css/PhotoPopSpecialPage.scss' );

		if( wfReadOnly() ) {
			$this->wg->Out->readOnlyPage();
			return;
		}

		if( !$this->wg->User->isAllowed( 'photopop_setup' ) ) {
			throw new PermissionsError( 'photopop_setup' );
		}

		$this->forward( __CLASS__, 'setup' );
	}

	private function getData($category){
		wfProfileIn( __METHOD__ );

		if ( empty( $category ) ) {
			wfProfileOut( __METHOD__ );
			throw new WikiaException( 'Missing parameter: category' );
		}

		$result = $this->model->getGameContents( $category, 480, 320 );
		wfProfileOut( __METHOD__ );

		return $result;
	}

	public function setup() {
		wfProfileIn( __METHOD__ );

		$category = trim( $this->request->getVal( 'category' ) );
		$icon = trim( $this->request->getVal( 'icon' ) );
		$watermark = trim( $this->request->getVal( 'watermark' ) );
		$iconUrl = null;
		$currentCategory = wfMsg( 'photpop-category-none' );
		$currentCategoryUrl = null;
		$currentIconUrl = wfBlankImgUrl();
		$currentWatermarkUrl = wfBlankImgUrl();
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
			$cat = Category::newFromName( $game->category );

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
				$cat = Category::newFromName( $category );

				if ( !( $cat instanceof Category && $cat->getID() !== false ) ) {
					$errors['category'][] = wfMsg( 'photopop-error-category-non-existing' );
				} else {
					$rounds = $this->getData($cat->getName());
				}

			} else {
				$errors['category'][] = wfMsg( 'photopop-error-field-compulsory' );
			}

			if ( !empty( $icon ) ) {
				$iconUrl = $this->model->getImageUrl( $icon );

				if ( empty( $iconUrl ) ) {
					$errors['icon'][] = wfMsg( 'photopop-error-file-non-existing' );
				}
			} else {
				$errors['icon'][] = wfMsg( 'photopop-error-field-compulsory' );
			}

			if ( !empty( $watermark ) ) {
				$watermarkUrl = $this->model->getImageUrl( $watermark );

				if ( empty( $watermark ) ) {
					$errors['icon'][] = wfMsg( 'photopop-error-file-non-existing' );
				}
			}

			if ( empty( $errors['category'] ) && empty( $errors['icon'] )  && empty( $errors['watermark'] ) ){
				if ( $this->model->saveSettings( $this->wg->CityId, $category, $iconUrl, $watermarkUrl ) !== false ) {
					$currentCategory = $cat->getName();
					$currentCategoryUrl = $cat->getTitle()->getLocalURL();
					$currentIconUrl = $iconUrl;
					$currentWatermarkUrl = $watermarkUrl;
					$message = wfMsg( 'photopop-settings-saved' );
				} else {
					$errors['db'][] = wfMsg( 'photopop-error-db-error' );
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
		wfProfileOut( __METHOD__ );
	}

}
