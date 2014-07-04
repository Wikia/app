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
	const PAGE_NAME = 'Maps';
	const TRANSLATION_FILENAME = 'translations.json';
	const MAPS_WIKIA_URL = 'http://maps.wikia.com';

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
	public function __construct( $name = null, $restriction = 'editinterface', $listed = true, $function = false, $file = 'default', $includable = false ) {
		parent::__construct( self::PAGE_NAME, $restriction, $listed, $function, $file, $includable );
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

		// convert images to thumbs
		foreach ( $mapsResponse->items as $item ) {
			$item->image = $this->mapsModel->createCroppedThumb( $item->image, self::MAP_THUMB_WIDTH, self::MAP_THUMB_HEIGHT, 'origin' );
		}

		if ( $this->app->checkSkin( 'wikiamobile' ) ) {
			$this->setVal( 'mapThumbWidth', self::MAP_THUMB_WIDTH );
			$this->setVal( 'mapThumbHeight', self::MAP_THUMB_HEIGHT );
			$this->setVal( 'renderControls', false );
			$this->setVal( 'renderTitle', false );

			WikiaMobilePageHeaderService::setSkipRendering( true );
		} else {
			$this->setVal( 'mapThumbWidth', self::MAP_THUMB_WIDTH );
			$this->setVal( 'mapThumbHeight', self::MAP_THUMB_HEIGHT );
			$this->setVal( 'renderControls', true );
			$this->setVal( 'renderTitle', true );

			$messages = [
				'title' => wfMessage( 'wikia-interactive-maps-title' ),
				'create-a-map' => wfMessage( 'wikia-interactive-maps-create-a-map' ),
				'no-maps-header' => wfMessage( 'wikia-interactive-maps-no-maps-header' ),
				'no-maps-text' => wfMessage( 'wikia-interactive-maps-no-maps-text' ),
				'no-maps-learn-more' => wfMessage( 'wikia-interactive-maps-no-maps-learn-more' ),
			];
			$this->setVal( 'messages', $messages );
			$this->setVal( 'sortingOptions', $this->mapsModel->getSortingOptions( $selectedSort ) );
			$this->setVal( 'searchInput', $this->app->renderView( 'Search', 'Index' ) );
		}

		// template variables shared between skins
		$this->setVal( 'maps', $mapsResponse->items );
		$this->setVal( 'hasMaps', !empty( $mapsResponse->total ) );
		$this->setVal( 'learnMoreUrl', self::MAPS_WIKIA_URL );

		$baseUrl = $this->getContext()->getTitle()->getFullURL();
		$this->setVal( 'baseUrl', $baseUrl );

		$urlParams = [];
		if ( !is_null( $selectedSort ) ) {
			$urlParams[ 'sort' ] = $selectedSort;
		}
		$url = $this->getContext()->getTitle()->getFullURL( $urlParams );

		$pagination = false;
		$totalMaps = (int)$mapsResponse->total;

		if ( $totalMaps > self::MAPS_PER_PAGE ) {
			$pagination = $this->app->renderView(
				'PaginationController',
				'index',
				array(
					'totalItems' => $totalMaps,
					'itemsPerPage' => self::MAPS_PER_PAGE,
					'currentPage' => $currentPage,
					'url' => $url
				)
			);
		}
		$this->setVal( 'pagination', $pagination );

		$this->response->addAsset( 'extensions/wikia/WikiaInteractiveMaps/css/WikiaInteractiveMaps.scss' );
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

	/**
	 * Single map page
	 */
	public function map() {
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

			$this->setVal( 'title', $map->title );
			$this->setVal( 'mapFound', true );
			$this->setVal( 'url', $url );
			$this->setVal( 'height', self::MAP_HEIGHT );
			$this->setVal( 'menu', $this->getMenuMarkup() );
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
	function getSpecialUrl( $name ) {
		return Title::newFromText( $name, NS_SPECIAL )->getFullUrl();
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
				$this->getSpecialUrl( self::PAGE_NAME )
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
}
