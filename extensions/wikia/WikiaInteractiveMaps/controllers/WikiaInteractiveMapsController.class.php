<?php
/**
 * Class WikiaInteractiveMapsController
 * @desc Special:WikiaInteractiveMaps controller
 */
class WikiaInteractiveMapsController extends WikiaSpecialPageController {

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
	 * @desc Special page constructor
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
	 * Interactive maps special page
	 */
	public function index() {
		$this->wg->SuppressPageHeader = true;
		$this->wg->out->setHTMLTitle( wfMessage( 'wikia-interactive-maps-title' )->escaped() );

		if ( is_numeric( $this->getPar() ) ) {
			$this->forward( 'WikiaInteractiveMaps', 'map' );
		} else {
			$this->forward( 'WikiaInteractiveMaps', 'main' );
		}
	}

	/**
	 * Main Special:Maps page
	 */
	public function main() {
		$selectedSort = $this->getVal( 'sort', null );
		$this->setVal( 'selectedSort', $selectedSort );
		$currentPage = $this->request->getInt( 'page', 1 );

		$offset = $this->getPaginationOffset( $currentPage, self::MAPS_PER_PAGE );

		$params = [
			'city_id' => $this->app->wg->CityId,
			'sort' => $selectedSort,
			'offset' => $offset,
			'limit' => self::MAPS_PER_PAGE,
		];

		$mapsResponse = $this->mapsModel->getMapsFromApi( $params );

		if ( !$mapsResponse ) {
			$this->forward( 'WikiaInteractiveMaps', 'error' );
			return;
		}

		$this->prepareTemplateData( $mapsResponse, $selectedSort );

		$urlParams = [];
		if ( !is_null( $selectedSort ) ) {
			$urlParams[ 'sort' ] = $selectedSort;
		}
		$this->addPagination( (int)$mapsResponse->total, $currentPage, $urlParams );

		$this->response->addAsset( 'extensions/wikia/WikiaInteractiveMaps/css/WikiaInteractiveMaps.scss' );
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

	/**
	 * Single map page
	 */
	public function map() {
		$mobileSkin = F::app()->checkSkin( 'wikiamobile' );
		$mapId = (int)$this->getPar();
		$zoom = $this->request->getInt( 'zoom', WikiaInteractiveMapsParserTagController::DEFAULT_ZOOM );
		$lat = $this->request->getInt( 'lat', WikiaInteractiveMapsParserTagController::DEFAULT_LATITUDE );
		$lon = $this->request->getInt( 'lon', WikiaInteractiveMapsParserTagController::DEFAULT_LONGITUDE );

		$map = $this->mapsModel->getMapByIdFromApi( $mapId );

		if ( isset( $map->title ) ) {
			$this->wg->out->setHTMLTitle( $map->title );

			$url = $this->mapsModel->getMapRenderUrl([
				$mapId,
				$zoom,
				$lat,
				$lon
			]);

			if ( $mobileSkin ) {
				$this->setMapOnMobile();
			} else {
				$this->setVal( 'title', $map->title );
				$this->setVal( 'menu', $this->getMenuMarkup() );
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

		$this->response->addAsset( 'extensions/wikia/WikiaInteractiveMaps/css/WikiaInteractiveMaps.scss' );
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
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
	 * @desc Renders the menu markup for the map page from mustache
	 * @return string
	 */
	function getMenuMarkup() {
		$actionButtonArray = [
			'action' => [
				'text' => wfMessage( 'wikia-interactive-maps-actions' )->escaped(),
			],
			'dropdown' => [
				'deleteMap' => [
					'text' => wfMessage( 'wikia-interactive-maps-delete-map' )->escaped(),
					'id' => 'deleteMap'
				]
			],
		];
		return F::app()->renderView( 'MenuButton', 'index', $actionButtonArray );
	}

	/**
	 * @desc Obtains a url to a special page with a given path
	 * @param string $name - name of the special page
	 * @return string
	 */
	static function getSpecialMapsUrl( ) {
		return Title::newFromText( self::PAGE_NAME, NS_SPECIAL )->getFullUrl();
	}

	/**
	 * @desc Ajax method for deleting a map from IntMaps API
	 */
	public function deleteMap() {
		$mapId = $this->request->getVal( 'mapId', 0 );
		$result = false;
		if ( $mapId && $this->wg->User->isLoggedIn() ) {
			$result = $this->mapsModel->deleteMapById( $mapId )[ 'success' ];
		}
		if ( $result ) {
			WikiaMapsLogger::addLogEntry(
				WikiaMapsLogger::ACTION_DELETE_MAP,
				$mapId,
				$mapId
			);

			NotificationsController::addConfirmation( wfMessage( 'wikia-interactive-maps-delete-map-success' ) );
			$this->response->setVal(
				'redirectUrl',
				self::getSpecialMapsUrl()
			);
		}
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
	 *
	 * @param int $currentPage
	 * @param int $itemsPerPage
	 *
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
		require_once( dirname( __FILE__ ) . '/../WikiaInteractiveMapsService.i18n.php' );
		$this->response->setVal( 'messages', $messages );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

	/**
	 * Iterates through $items and changes image URL to thumbnail
	 *
	 * @param Array $items
	 * @param Integer $width
	 * @param Integer $height
	 */
	private function convertImagesToThumbs( &$items, $width, $height ) {
		foreach ( $items as $item ) {
			$item->image = $this->mapsModel->createCroppedThumb( $item->image, $width, $height, 'origin' );
		}
	}

	/**
	 * Sets template variables depending on skin
	 *
	 * @param Array $mapsResponse an array taken from API response
	 * @param String $selectedSort a sorting option passed in $_GET
	 */
	private function prepareTemplateData( $mapsResponse, $selectedSort ) {
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
			$this->setVal( 'sortingOptions', $this->mapsModel->getSortingOptions( $selectedSort ) );
			$this->setVal( 'searchInput', $this->app->renderView( 'Search', 'Index' ) );
		}

		// template variables shared between skins
		$this->setVal( 'messages', $messages );
		$this->setVal( 'maps', $mapsResponse->items );
		$this->setVal( 'hasMaps', !empty( $mapsResponse->total ) );
		$this->setVal( 'learnMoreUrl', self::MAPS_WIKIA_URL );

		$baseUrl = $this->getContext()->getTitle()->getFullURL();
		$this->setVal( 'baseUrl', $baseUrl );
	}

	/**
	 * Renders pagination and adds it to template variables for Oasis skin
	 *
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
		$this->response->setVal( 'url', $this->mapsModel->getRealMapImageUrl() );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setCacheValidity( WikiaResponse::CACHE_SHORT, WikiaResponse::CACHE_SHORT );
	}
}

