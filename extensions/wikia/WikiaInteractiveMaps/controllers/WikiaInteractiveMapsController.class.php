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
	const MAP_NOT_DELETED = 0;
	const MAP_DELETED = 1;


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
		$showDeleted = $this->getVal( 'deleted', false );

		$offset = $this->getPaginationOffset( $currentPage, self::MAPS_PER_PAGE );

		$params = [
			'city_id' => $this->app->wg->CityId,
			'sort' => $selectedSort,
			'offset' => $offset,
			'limit' => self::MAPS_PER_PAGE,
		];

		if ( $showDeleted ) {
			$params['deleted'] = 1;
		}

		$mapsResponse = $this->mapsModel->getMapsFromApi( $params );

		if ( !$mapsResponse ) {
			$this->forward( 'WikiaInteractiveMaps', 'error' );
			return;
		}

		// convert images to thumbs
		foreach ( $mapsResponse->items as $item ) {
			$item->image = $this->mapsModel->createCroppedThumb( $item->image, self::MAP_THUMB_WIDTH, self::MAP_THUMB_HEIGHT, 'origin' );
		}

		$this->setVal( 'maps', $mapsResponse->items );
		$this->setVal( 'hasMaps', !empty( $mapsResponse->total ) );
		$this->setVal( 'mapThumbWidth', self::MAP_THUMB_WIDTH );
		$this->setVal( 'mapThumbHeight', self::MAP_THUMB_HEIGHT );

		$url = $this->getContext()->getTitle()->getFullURL();
		$this->setVal( 'baseUrl', $url );

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
		$this->setVal( 'learnMoreUrl', self::MAPS_WIKIA_URL );

		$urlParams = [];
		if ( !is_null( $selectedSort ) ) {
			$urlParams[ 'sort' ] = $selectedSort;
		}
		if ( $showDeleted ) {
			$urlParams[ 'deleted' ] = $showDeleted;
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

			$deleted = $map->deleted == self::MAP_DELETED;

			if ( $deleted ) {
				if ( F::app()->checkSkin( 'oasis' ) ) {
					NotificationsController::addConfirmation(
						wfMessage( 'wikia-interactive-maps-map-is-deleted' ),
						NotificationsController::CONFIRMATION_WARN
					);
				}
			}

			$this->setVal( 'deleted', $deleted );
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
			$this->setVal( 'menu', $this->getMenuMarkup( $deleted ) );
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
	function getMenuMarkup( $deleted ) {
		$actionButtonArray = [
			'action' => [
				'text' => wfMessage( 'wikia-interactive-maps-actions' )->escaped(),
			],
			'dropdown' => [],
		];
		if ( $deleted ) {
			$actionButtonArray[ 'dropdown' ][ 'unDeleteMap' ] = [
				'text' => wfMessage( 'wikia-interactive-maps-undelete-map' )->escaped(),
				'id' => 'unDeleteMap'
			];
		} else {
			$actionButtonArray[ 'dropdown' ][ 'deleteMap' ] = [
				'text' => wfMessage( 'wikia-interactive-maps-delete-map' )->escaped(),
				'id' => 'deleteMap'
			];
		}

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
	 * @desc Ajax method for un/deleting a map from IntMaps API
	 */
	public function updateMapDeletionStatus() {
		$mapId = $this->request->getVal( 'mapId', 0 );
		$deleted = $this->request->getInt( 'deleted' );

		if ( !in_array( $deleted, [ self::MAP_DELETED, self::MAP_NOT_DELETED ] ) ) {
			$deleted = self::MAP_DELETED;
		}

		$result = false;
		if ( $mapId && $this->wg->User->isLoggedIn() ) {
			$result = $this->mapsModel->updateMapDeletionStatus( $mapId, $deleted )[ 'success' ];
		}
		if ( $result ) {
			$action = $deleted === self::MAP_DELETED
				? WikiaMapsLogger::ACTION_DELETE_MAP
				: WikiaMapsLogger::ACTION_UNDELETE_MAP;
			WikiaMapsLogger::addLogEntry(
				$action,
				$mapId,
				$mapId
			);

			NotificationsController::addConfirmation(
				$deleted ?
					wfMessage( 'wikia-interactive-maps-delete-map-success' )->text() :
					wfMessage( 'wikia-interactive-maps-undelete-map-success' )->text()
			);
			$redirectUrl = $this->getSpecialUrl( self::PAGE_NAME );
			if ( $deleted === self::MAP_NOT_DELETED ) {
				$redirectUrl = $this->getSpecialUrl( self::PAGE_NAME ) . '/' . $mapId;
			}
			$this->response->setVal( 'redirectUrl', $redirectUrl );
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
	 * Return Real Map image URL
	 */
	public function getRealMapImageUrl() {
		$this->response->setVal( 'url', $this->mapsModel->getRealMapImageUrl() );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setCacheValidity( WikiaResponse::CACHE_SHORT, WikiaResponse::CACHE_SHORT );
	}
}
