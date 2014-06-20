<?php
/**
 * Class WikiaInteractiveMapsController
 * @desc Special:WikiaInteractiveMaps controller
 */
class WikiaInteractiveMapsController extends WikiaSpecialPageController {

	const MAP_HEIGHT = 600;
	const MAPS_PER_PAGE = 10;
	const PAGE_NAME = 'InteractiveMaps';

	/**
	 * @var WikiaMaps
	 */
	private $mapsModel;

	/**
	 * Keeps data needed while creating map/tile set process
	 * @var Array
	 */
	private $creationData;

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
	 * Main Special:InteractiveMaps page
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

		$mapsResponse = $this->mapsModel->cachedRequest( 'getMapsFromApi', $params );

		if ( !$mapsResponse ) {
			$this->forward( 'WikiaInteractiveMaps', 'error' );
			return;
		}

		$this->setVal( 'maps', $mapsResponse->items );
		$this->setVal( 'hasMaps', !empty( $mapsResponse->total ) );

		$url = $this->getContext()->getTitle()->getFullURL();
		$this->setVal( 'baseUrl', $url );

		$messages = [
			'wikia-interactive-maps-title' => wfMessage( 'wikia-interactive-maps-title' ),
			'wikia-interactive-maps-create-a-map' => wfMessage( 'wikia-interactive-maps-create-a-map' ),
			'wikia-interactive-maps-no-maps' => wfMessage( 'wikia-interactive-maps-no-maps' )
		];
		$this->setVal( 'messages', $messages );
		$this->setVal( 'sortingOptions', $this->mapsModel->getSortingOptions( $selectedSort ) );

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

		$map = $this->mapsModel->cachedRequest(
			'getMapByIdFromApi',
			[ 'id' => $mapId ]
		);

		if ( isset( $map->title ) ) {
			$this->wg->out->setHTMLTitle( $map->title );

			$url = $this->mapsModel->buildUrl( [
				WikiaMaps::ENTRY_POINT_RENDER,
				$mapId,
				$zoom,
				$lat,
				$lon
			] );

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
	 * get list of tile sets
	 *
	 * @return Array
	 */

	public function getTileSets() {
		$params = [];
		$searchTerm = $this->request->getVal( 'searchTerm', null );

		if ( !is_null( $searchTerm ) ) {
			$params[ 'searchTerm' ] = $searchTerm;
		}

		$this->response->setVal( 'results', $this->mapsModel->getTileSets( $params ) );
	}

	/**
	 * Entry point to create a map from either existing tiles or new image
	 *
	 * @requestParam Integer $tileSetId an unique id of existing tiles
	 * @requestParam String $image an URL to image which the tiles will be created from
	 * @requestParam String $title map title
	 *
	 * @throws PermissionsException
	 * @throws BadRequestApiException
	 * @throws InvalidParameterApiException
	 */
	public function createMap() {
		$type = trim( $this->request->getVal( 'type', WikiaMaps::MAP_TYPE_GEO ) );

		$this->setCreationData( 'tileSetId', $this->request->getInt( 'tileSetId', 0 ) );
		$this->setCreationData( 'title', trim( $this->request->getVal( 'title', '' ) ) );
		$this->setCreationData( 'image', trim( $this->request->getVal( 'fileUrl', '' ) ) );

		$this->validateMapCreation();

		$this->setCreationData( 'creatorName', $this->wg->User->getName() );
		$this->setCreationData( 'cityId', (int) $this->wg->CityId );

		if ( $type === WikiaMaps::MAP_TYPE_CUSTOM ) {
			$results = $this->createCustomMap();
		} else {
			$results = $this->createGeoMap();
		}

		$this->setVal( 'results', $results );
	}

	/**
	 * Creates a custom map for given tileset or creating a tileset and then map out of it
	 *
	 * @return Array
	 */
	private function createCustomMap() {
		$tileSetId = $this->getCreationData( 'tileSetId' );

		if ( $tileSetId > 0 ) {
			$results = $this->createMapFromTilesetId();
		} else {
			$results = $this->createTileset();

			if ( true === $results[ 'success' ] ) {
				$this->setCreationData( 'tileSetId', $results[ 'content' ]->id );
				$results = $this->createMapFromTilesetId();
			}
		}

		return $results;
	}

	/**
	 * Creates a map from Geo tileset
	 *
	 * @return Array
	 */
	private function createGeoMap() {
		$this->setCreationData( 'tileSetId', $this->mapsModel->getGeoMapTilesetId() );
		return $this->createMapFromTilesetId();
	}

	/**
	 * Helper method to validate creation data
	 *
	 * @throws PermissionsException
	 * @throws BadRequestApiException
	 * @throws InvalidParameterApiException
	 */
	private function validateMapCreation() {
		$tileSetId = $this->getCreationData( 'tileSetId' );
		$imageUrl = $this->getCreationData( 'image' );
		$mapTitle = $this->getCreationData( 'title' );

		if ( $tileSetId === 0 && empty( $imageUrl ) && empty( $mapTitle ) ) {
			throw new BadRequestApiException( wfMessage( 'wikia-interactive-maps-create-map-bad-request-error' )->plain() );
		}

		if ( empty( $mapTitle ) ) {
			throw new InvalidParameterApiException( 'title' );
		}

		if ( !$this->wg->User->isLoggedIn() ) {
			throw new PermissionsException( 'interactive maps' );
		}
	}

	/**
	 * Helper method which sends request to maps service to create tiles' set
	 * and then processes the response providing results array
	 */
	private function createTileset() {
		return $this->mapsModel->saveTileset( [
			'name' => $this->getCreationData( 'title' ),
			'url' => $this->getCreationData( 'image' ),
			'created_by' => $this->getCreationData( 'creatorName' ),
		] );
	}

	/**
	 * Helper method which sends request to maps service to create a map from existing tiles' set
	 * and processes the response providing results array
	 *
	 * @return Array
	 */
	private function createMapFromTilesetId() {
		$response = $this->mapsModel->saveMap( [
			'title' => $this->getCreationData( 'title' ),
			'tile_set_id' => $this->getCreationData( 'tileSetId' ),
			'city_id' => $this->getCreationData( 'cityId' ),
			'created_by' => $this->getCreationData( 'creatorName' ),
		] );

		if ( true === $response[ 'success' ] ) {
			$mapId = $response['content']->id;

			$response[ 'content' ]->mapUrl = Title::newFromText(
				self::PAGE_NAME . '/' . $mapId,
				NS_SPECIAL
			)->getFullUrl();

			// Log new map created
			WikiaMapsLogger::addLogEntry(
				WikiaMapsLogger::ACTION_CREATE_MAP,
				$mapId,
				$this->getCreationData( 'title' )
			);
		}

		return $response;
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
	 * Getter for creation data
	 *
	 * @param String $name name of the data key
	 * @param Bool $default
	 *
	 * @return Mixed
	 */
	private function getCreationData( $name, $default = false ) {
		if ( isset( $this->creationData[ $name ] ) ) {
			return $this->creationData[ $name ];
		}

		return $default;
	}

	/**
	 * Setter of creation data
	 *
	 * @param String $name
	 * @param Mixed $value
	 */
	public function setCreationData( $name, $value ) {
		$this->creationData[ $name ] = $value;
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
			NotificationsController::addConfirmation( wfMessage( 'wikia-interactive-maps-delete-map-success' ) );
			$this->response->setVal(
				'redirectUrl',
				$this->getSpecialUrl( 'InteractiveMaps' )
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

}
