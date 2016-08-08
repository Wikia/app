<?php
class WikiaMapsParserTagController extends WikiaParserTagController {

	//TODO: figure out max and min height and width - PO design decision
	const DEFAULT_ZOOM = 7;
	const MIN_ZOOM = 0;
	const MAX_ZOOM = 16;
	const DEFAULT_WIDTH = 680;
	const DEFAULT_HEIGHT = 382;
	const DEFAULT_LATITUDE = 0;
	const MIN_LATITUDE = -90;
	const MAX_LATITUDE = 90;
	const DEFAULT_LONGITUDE = 0;
	const MIN_LONGITUDE = -180;
	const MAX_LONGITUDE = 180;
	const PARSER_TAG_NAME = 'imap';
	const RENDER_ENTRY_POINT = 'render';

	private $mapsModel;

	protected $tagAttributes = [
		'id' => 'map-id',
		'lat' => 'lat',
		'lon' => 'lon',
		'zoom' => 'zoom',
	];

	public function __construct() {
		parent::__construct();
		$this->mapsModel = new WikiaMaps( $this->wg->IntMapConfig );
	}

	public function getTagName() {
		return self::PARSER_TAG_NAME;
	}

	protected function registerResourceLoaderModules( Parser $parser ) {
		// register resource loader module dependencies for map parser tag
		// done separately for CSS and JS, so CSS will go to top of the page
		$parser->getOutput()->addModuleStyles( 'ext.wikia.WikiaMaps.ParserTag' );
		$parser->getOutput()->addModuleScripts( 'ext.wikia.WikiaMaps.ParserTag' );
	}

	protected function getErrorOutput( $errorMessages ) {
		$errorMessage = $errorMessages[0];

		return $this->sendRequest(
			'WikiaMapsParserTagController',
			'parserTagError',
			[ 'errorMessage' => $errorMessage ]
		);
	}

	protected function getSuccessOutput( $args ) {
		$params = $this->sanitizeParserTagArguments( $args );
		$params[ 'map' ] = $this->getMapObj( $params[ 'id' ] );

		if ( !empty( $params [ 'map' ]->id ) ) {
			return $this->sendRequest(
				'WikiaMapsParserTagController',
				'mapThumbnail',
				$params
			);
		} else {
			$errorMessage = wfMessage( 'wikia-interactive-maps-parser-tag-error-no-map-found' )->plain();
			return $this->getErrorOutput( [ $errorMessage ] );
		}
	}

	/**
	 * @desc Displays parser tag error
	 *
	 * @return string
	 */
	public function parserTagError() {
		$this->setVal( 'errorMessage', $this->getVal( 'errorMessage' ) );
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

	/**
	 * @desc Renders Wikia Maps placeholder
	 *
	 * @return null|string
	 */
	public function mapThumbnail() {
		$params = $this->getMapPlaceholderParams();
		$userName = $params->map->created_by;
		$isMobile = $this->app->checkSkin( 'wikiamobile' );

		if ( $isMobile ) {
			//proper image is lazy loaded from the thumbnailer
			$params->map->imagePlaceholder = $this->wg->BlankImgUrl;
			$params->map->mobile = true;
			$params->map->href =
				WikiaMapsSpecialController::getSpecialUrl() . '/' . $params->map->id;
		} else {
			$params->map->image = $this->mapsModel->createCroppedThumb( $params->map->image, self::DEFAULT_WIDTH, self::DEFAULT_HEIGHT );
		}

		$renderParams = $this->mapsModel->getMapRenderParams( $params->map->city_id );

		$params->map->url = $this->mapsModel->getMapRenderUrl( [
			$params->map->id,
			$params->zoom,
			$params->lat,
			$params->lon,
		], $renderParams );

		$this->setVal( 'map', (object) $params->map );
		$this->setVal( 'params', $params );
		$this->setVal( 'created_by', wfMessage( 'wikia-interactive-maps-parser-tag-created-by', $userName )->text() );
		$this->setVal( 'avatarUrl', AvatarService::getAvatarUrl( $userName, AvatarService::AVATAR_SIZE_SMALL ) );
		$this->setVal( 'view', wfMessage( 'wikia-interactive-maps-parser-tag-view' )->plain() );
		$this->setVal( 'mercuryComponentAttrs', json_encode( [
			'url' => $params->map->url,
			'imageSrc' => $params->map->image,
			'id' => $params->map->id,
			'title' => $params->map->title,
		] ) );

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		if ( $isMobile ) {
			$this->overrideTemplate( 'mapThumbnail_mobile' );
		}
	}

	/**
	 * @desc Get map object from API
	 *
	 * @param integer $mapId - map object id
	 *
	 * @return object - map object
	 */
	private function getMapObj( $mapId ) {
		return $this->mapsModel->getMapByIdFromApi( $mapId );
	}

	/**
	 * @desc Gets map placeholder params from request
	 *
	 * @return stdClass
	 */
	private function getMapPlaceholderParams() {
		$params = [];

		$params[ 'lat' ] = $this->request->getVal( 'lat', self::DEFAULT_LATITUDE );
		$params[ 'lon' ] = $this->request->getVal( 'lon', self::DEFAULT_LONGITUDE );
		$params[ 'zoom' ] = $this->request->getInt( 'zoom', self::DEFAULT_ZOOM );
		$params[ 'width' ] = self::DEFAULT_WIDTH;
		$params[ 'height' ] = self::DEFAULT_HEIGHT;
		$params[ 'map' ] = $this->request->getVal( 'map' );
		$params[ 'created_by' ] = $this->request->getVal( 'created_by' );
		$params[ 'avatarUrl' ] = $this->request->getVal( 'avatarUrl' );

		$params[ 'width' ] .= 'px';
		$params[ 'height' ] .= 'px';

		return (object) $params;
	}

	/**
	 * @desc Sanitizes given data
	 *
	 * @param array $data
	 *
	 * @return array
	 */
	public function sanitizeParserTagArguments( $data ) {
		$result = [];

		foreach( $this->tagAttributes as $mapTo => $tagAttr) {
			if ( !empty( $data[ $tagAttr ] ) ) {
				$result[ $mapTo ] = $data[ $tagAttr ];
			}
		}

		return $result;
	}

	/**
	 * @desc Validates data provided in parser tag arguments, returns empty string if there is no error
	 *
	 * @param array $params an array with parser tag arguments
	 * @param String $errorMessage a variable where the error message will be assigned to
	 *
	 * @return String
	 */
	public function validateParseTagParams( Array $params, &$errorMessage ) {
		if( empty( $params ) ) {
			$errorMessage = wfMessage( 'wikia-interactive-maps-parser-tag-error-no-require-parameters' )->plain();
			return false;
		}

		$errorMessages = $this->validateAttributes( $params );
		if( !empty( $errorMessages ) ) {
			$errorMessage = $errorMessages[0];
			return false;
		}

		return true;
	}

	/**
	 * @desc Small factory method to create validators for params; returns false if validator can't be created
	 *
	 * @param String $paramName
	 * @return WikiaValidator
	 */
	protected function buildParamValidator( $paramName ) {
		$validator = new WikiaValidatorAlwaysTrue();

		switch( $paramName ) {
			case 'map-id':
				$validator = new WikiaValidatorInteger(
					[ 'required' => true ],
					[ 'not_int' => 'wikia-interactive-maps-parser-tag-error-invalid-map-id' ]
				);
				break;
			case 'lat':
				$validator = new WikiaValidatorNumeric(
					[
						'min' => self::MIN_LATITUDE,
						'max' => self::MAX_LATITUDE
					],
					[
						'not_numeric' => 'wikia-interactive-maps-parser-tag-error-invalid-latitude',
						'too_small' => 'wikia-interactive-maps-parser-tag-error-min-latitude',
						'too_big' => 'wikia-interactive-maps-parser-tag-error-max-latitude'
					]
				);
				break;
			case 'lon':
				$validator = new WikiaValidatorNumeric(
					[
						'min' => self::MIN_LONGITUDE,
						'max' => self::MAX_LONGITUDE
					],
					[
						'not_numeric' => 'wikia-interactive-maps-parser-tag-error-invalid-longitude',
						'too_small' => 'wikia-interactive-maps-parser-tag-error-min-longitude',
						'too_big' => 'wikia-interactive-maps-parser-tag-error-max-longitude'
					]
				);
				break;
			case 'zoom':
				$validator = new WikiaValidatorInteger(
					[
						'min' => self::MIN_ZOOM,
						'max' => self::MAX_ZOOM
					],
					[
						'not_int' => 'wikia-interactive-maps-parser-tag-error-invalid-zoom',
						'too_small' => 'wikia-interactive-maps-parser-tag-error-min-zoom',
						'too_big' => 'wikia-interactive-maps-parser-tag-error-max-zoom'
					]
				);
				break;
		}

		return $validator;
	}

	/**
	 * @desc Ajax method for lazy-loading map thumbnails
	 */
	public function getMobileThumbnail() {
		$width = $this->getVal( 'width' );
		//To keep the original aspect ratio
		$height = floor( $width * self::DEFAULT_HEIGHT / self::DEFAULT_WIDTH );
		$image = $this->getVal( 'image' );
		$this->setVal( 'src', $this->mapsModel->createCroppedThumb( $image, $width, $height ) );
	}

}
