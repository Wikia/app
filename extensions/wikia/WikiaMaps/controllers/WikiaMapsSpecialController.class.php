<?php
/**
 * Class WikiaMapsSpecialController
 * @desc Special:Maps controller
 */
class WikiaMapsSpecialController extends WikiaSpecialPageController {

	const MAP_HEIGHT = 600;
	const MAPS_PER_PAGE = 10;
	const MAP_THUMB_WIDTH = 1110;
	const MAP_THUMB_HEIGHT = 300;
	const MAP_MOBILE_THUMB_WIDTH = 640;
	const MAP_MOBILE_THUMB_HEIGHT = 300;
	const PAGE_NAME = 'Maps';
	const PAGE_RESTRICTION = 'editinterface';
	const TRANSLATION_FILENAME = 'translations.json';
	const MAPS_WIKIA_URL = 'http://maps.wikia.com';

	const WIKIA_MOBILE_SKIN_NAME = 'wikiamobile';

	/**
	 * @var WikiaMaps
	 */
	private $mapsModel;

	/**
	 * Special page constructor
	 *
	 * @param null $name
	 * @param string $restriction
	 * @param bool $listed
	 * @param bool $function
	 * @param string $file
	 * @param bool $includable
	 */
	public function __construct( $name = null, $restriction = '', $listed = true, $function = false, $file = 'default', $includable = false ) {
		parent::__construct( self::PAGE_NAME, self::PAGE_RESTRICTION, $listed, $function, $file, $includable );
		$this->mapsModel = new WikiaMaps( $this->wg->IntMapConfig );
	}

	/**
	 * Wikia Maps special page
	 */
	public function index() {
		$this->wg->SuppressPageHeader = true;
		$this->wg->out->setHTMLTitle( wfMessage( 'wikia-interactive-maps-title' )->escaped() );

		if ( is_numeric( $this->getPar() ) ) {
			$this->forward( 'WikiaMapsSpecial', 'map' );
		} else {
			$this->forward( 'WikiaMapsSpecial', 'main' );
		}
	}

	/**
	 * Main Special:Maps page
	 */
	public function main() {
		$selectedSort = $this->getVal( 'sort', null );
		$this->setVal( 'selectedSort', $selectedSort );
		$currentPage = $this->request->getInt( 'page', 1 );
		$showDeleted = $this->getVal( 'deleted', false );

		$offset = $this->getPaginationOffset( $currentPage, self::MAPS_PER_PAGE );

		$params = [
			'city_id' => $this->app->wg->CityId,
			'sort' => $selectedSort,
			'offset' => $offset,
			'limit' => self::MAPS_PER_PAGE,
		];

		if ( $showDeleted ) {
			$params[ 'deleted' ] = 1;
		}

		$mapsResponse = $this->getModel()->getMapsFromApi( $params );

		if ( !$mapsResponse ) {
			$this->forward( 'WikiaMapsSpecial', 'error' );
			return;
		}

		$this->prepareTemplateData( $mapsResponse, $selectedSort );

		$urlParams = [];
		if ( !is_null( $selectedSort ) ) {
			$urlParams[ 'sort' ] = $selectedSort;
		}
		if ( $showDeleted ) {
			$urlParams[ 'deleted' ] = $showDeleted;
		}

		$this->addPagination( (int)$mapsResponse->total, $currentPage, $urlParams );

		$this->response->addAsset( 'extensions/wikia/WikiaMaps/css/WikiaMaps.scss' );
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

	/**
	 * Single map page
	 */
	public function map() {
		$mobileSkin = $this->app->checkSkin( 'wikiamobile' );
		$mapId = (int)$this->getPar();
		$zoom = $this->request->getInt( 'zoom', WikiaMapsParserTagController::DEFAULT_ZOOM );
		$lat = $this->request->getInt( 'lat', WikiaMapsParserTagController::DEFAULT_LATITUDE );
		$lon = $this->request->getInt( 'lon', WikiaMapsParserTagController::DEFAULT_LONGITUDE );
		$model = $this->getModel();

		$map = $model->getMapByIdFromApi( $mapId );

		if( isset( $map->title ) ) {
			$mapCityId = $map->city_id;
			$this->redirectIfForeignWiki( $mapCityId, $mapId );
			$this->wg->out->setHTMLTitle( $map->title );

			$deleted = $map->deleted == WikiaMaps::MAP_DELETED;
			if ( $deleted ) {
				if ( $this->app->checkSkin( 'oasis' ) ) {
					NotificationsController::addConfirmation(
						wfMessage( 'wikia-interactive-maps-map-is-deleted' ),
						NotificationsController::CONFIRMATION_WARN
					);
				}
			}

			$this->setVal( 'deleted', $deleted );
			$params = $model->getMapRenderParams( $mapCityId );

			$url = $model->getMapRenderUrl( [
				$mapId,
				$zoom,
				$lat,
				$lon
			], $params );

			if ( $mobileSkin ) {
				$this->setMapOnMobile();
			} else {
				$this->setVal( 'title', $map->title );
				$this->setVal( 'menu', $this->getMenuMarkup( $deleted ) );
			}

			$this->setVal( 'mapFound', true );
			$this->setVal( 'url', $url );
			$this->setVal( 'height', self::MAP_HEIGHT );
			$this->setVal( 'mapId', $mapId );
		} else {
			$this->setVal( 'mapFound', false );
			$this->setVal( 'title', wfMessage( 'error' ) );
			$this->setVal( 'messages', [
				'wikia-interactive-maps-map-not-found-error' => wfMessage( 'wikia-interactive-maps-map-not-found-error' )
			] );
		}

		$this->response->addAsset( 'extensions/wikia/WikiaMaps/css/WikiaMaps.scss' );
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

	/**
	 * Redirects to a single map page on right wikia if the current wikia id isn't the same as the map's city_id
	 * @param Integer $cityId
	 * @param Integer $mapId
	 */
	public function redirectIfForeignWiki( $cityId, $mapId ) {
		if ( (int) $this->wg->CityId !== $cityId ) {
			$targetUrl = $this->getWikiPageUrl( self::PAGE_NAME, NS_SPECIAL, $cityId );
			$this->wg->out->redirect( $targetUrl . '/' . $mapId );
		}
	}

	/**
	 * Returns full URL for a wiki with given $cityId
	 * @param String $text
	 * @param Integer $namespace
	 * @param Integer|null $cityId
	 * @return string
	 */
	protected function getWikiPageUrl( $text, $namespace = NS_MAIN, $cityId = null ) {
		return GlobalTitle::newFromText( $text, $namespace, $cityId )->getFullURL();
	}

	/**
	 * Makes all required adjustments for rendering single map page on mobile
	 */
	private function setMapOnMobile() {
		global $wgHooks;

		// adds class to body
		$wgHooks[ 'SkinGetPageClasses' ][] = function( &$classes ) {
			$classes .= ' int-map-mobile-map-page';
			return true;
		};

		// skip rendering parts of Wikia page
		WikiaMobileFooterService::setSkipRendering( true );
		WikiaMobilePageHeaderService::setSkipRendering( true );
	}

	/**
	 * Renders the menu markup for the map page from mustache
	 * @param Integer $deleted flag which tells if a map was deleted
	 * @return string
	 */
	function getMenuMarkup( $deleted ) {
		$actionButtonArray = [
			'action' => [
				'text' => wfMessage( 'wikia-interactive-maps-actions' )->escaped(),
			],
			'dropdown' => [],
		];
		if ( $deleted ) {
			$actionButtonArray[ 'dropdown' ][ 'undeleteMap' ] = [
				'text' => wfMessage( 'wikia-interactive-maps-undelete-map' )->escaped(),
				'id' => 'undeleteMap'
			];
		} else {
			$actionButtonArray[ 'dropdown' ][ 'deleteMap' ] = [
				'text' => wfMessage( 'wikia-interactive-maps-delete-map' )->escaped(),
				'id' => 'deleteMap'
			];
		}

		return $this->app->renderView( 'MenuButton', 'index', $actionButtonArray );
	}

	/**
	 * Obtains a url to a special page with a given path
	 * @param string $name - name of the special page
	 * @return string
	 */
	static function getSpecialUrl( $name = self::PAGE_NAME ) {
		return SpecialPage::getTitleFor( $name )->getFullUrl();
	}
	
	/**
	 * API Error page
	 */
	public function error() {
		$this->setVal( 'messages', [
			'wikia-interactive-maps-service-error' => wfMessage( 'wikia-interactive-maps-service-error' )->parse()
		] );
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

	/**
	 * Generates offset value based on current page and items per page
	 * @param int $currentPage
	 * @param int $itemsPerPage
	 * @return int mixed
	 */
	private function getPaginationOffset( $currentPage, $itemsPerPage ) {
		return ($currentPage - 1) * $itemsPerPage;
	}

	/**
	 * Generate extension translations file
	 */
	public function translation() {
		$messages = [];
		require_once( dirname( __FILE__ ) . '/../WikiaMapsService.i18n.php' );
		$this->response->setVal( 'messages', $messages );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

	/**
	 * Iterates through $items and changes image URL to thumbnail
	 * @param Array $items
	 * @param Integer $width
	 * @param Integer $height
	 */
	private function convertImagesToThumbs( &$items, $width, $height ) {
		foreach ( $items as $item ) {
			$item->image = $this->getModel()->createCroppedThumb( $item->image, $width, $height );
		}
	}

	/**
	 * Sets template variables depending on skin
	 * @param Array $mapsResponse an array taken from API response
	 * @param String $selectedSort a sorting option passed in $_GET
	 */
	private function prepareTemplateData( $mapsResponse, $selectedSort ) {
		global $wgEnableGlobalNavExt;

		$isWikiaMobileSkin = $this->app->checkSkin( self::WIKIA_MOBILE_SKIN_NAME );

		$thumbWidth = ( $isWikiaMobileSkin ? self::MAP_MOBILE_THUMB_WIDTH : self::MAP_THUMB_WIDTH );
		$thumbHeight = ( $isWikiaMobileSkin ? self::MAP_MOBILE_THUMB_HEIGHT : self::MAP_THUMB_HEIGHT );
		$this->convertImagesToThumbs( $mapsResponse->items, $thumbWidth, $thumbHeight );
		$this->setVal( 'mapThumbWidth', $thumbWidth );
		$this->setVal( 'mapThumbHeight', $thumbHeight );

		$this->setVal( 'renderControls', ( $isWikiaMobileSkin ? false : true ) );
		$this->setVal( 'renderTitle', ( $isWikiaMobileSkin ? false : true ) );

		$messages = [
			'no-maps-header' => wfMessage( 'wikia-interactive-maps-no-maps-header' ),
			'no-maps-text' => wfMessage( 'wikia-interactive-maps-no-maps-text' ),
			'no-maps-learn-more' => wfMessage( 'wikia-interactive-maps-no-maps-learn-more' ),
		];

		if ( $isWikiaMobileSkin ) {
			WikiaMobilePageHeaderService::setSkipRendering( true );
		} else {
			$messages = array_merge( $messages, [
				'title' => wfMessage( 'wikia-interactive-maps-title' ),
				'create-a-map' => wfMessage( 'wikia-interactive-maps-create-a-map' ),
			] );
			$this->setVal( 'sortingOptions', $this->getModel()->getSortingOptions( $selectedSort ) );
			if ( empty( $wgEnableGlobalNavExt ) ) {
				$this->setVal( 'searchInput', $this->app->renderView( 'Search', 'Index' ) );
			}
		}

		// template variables shared between skins
		$this->setVal( 'messages', $messages );
		$this->setVal( 'maps', $mapsResponse->items );
		$this->setVal( 'hasMaps', !empty( $mapsResponse->total ) );
		$this->setVal( 'learnMoreUrl', self::MAPS_WIKIA_URL );

		$this->setVal( 'baseUrl', self::getSpecialUrl() );
	}

	/**
	 * Renders pagination and adds it to template variables for Oasis skin
	 * @param Integer $totalMaps
	 * @param Integer $currentPage
	 * @param Array $urlParams
	 */
	private function addPagination( $totalMaps, $currentPage, $urlParams ) {
		$url = $this->getContext()->getTitle()->getFullURL( $urlParams );
		$pagination = false;
		$paginationOptions = [
			'totalItems' => $totalMaps,
			'itemsPerPage' => self::MAPS_PER_PAGE,
			'currentPage' => $currentPage,
			'url' => $url,
		];

		if ( $this->app->checkSkin( self::WIKIA_MOBILE_SKIN_NAME ) ) {
			$paginationOptions = array_merge( $paginationOptions, [
				'prevMsg' => '&lt;',
				'nextMsg' => '&gt;',
			] );
		}

		if ( $totalMaps > self::MAPS_PER_PAGE ) {
			$pagination = $this->app->renderView(
				'PaginationController',
				'index',
				$paginationOptions
			);
		}

		$this->setVal( 'pagination', $pagination );
	}

	/**
	 * Return Real Map image URL
	 */
	public function getRealMapImageUrl() {
		$this->response->setVal( 'url', $this->getModel()->getRealMapImageUrl() );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setCacheValidity( WikiaResponse::CACHE_SHORT, WikiaResponse::CACHE_SHORT );
	}

	/**
	 * Returns WikiaMaps model
	 * @return WikiaMaps
	 */
	public function getModel() {
		return $this->mapsModel;
	}

}
