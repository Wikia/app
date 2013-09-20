<?php

/**
 * Class handling the #display_map rendering.
 *
 * @file
 * @ingroup Maps
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Kim Eik
 */
class MapsDisplayMapRenderer {

	/**
	 * @since 2.0
	 *
	 * @var iMappingService
	 */
	protected $service;

	/**
	 * Constructor.
	 *
	 * @param iMappingService $service
	 */
	public function __construct( iMappingService $service ) {
		$this->service = $service;
	}

	/**
	 * Returns the HTML to display the map.
	 *
	 * @since 2.0
	 *
	 * @param array $params
	 * @param Parser $parser
	 * @param string $mapName
	 *
	 * @return string
	 */
	protected function getMapHTML( array $params, Parser $parser, $mapName ) {
		return Html::rawElement(
			'div',
			array(
				'id' => $mapName,
				'style' => "width: {$params['width']}; height: {$params['height']}; background-color: #cccccc; overflow: hidden;",
				'class' => 'maps-map maps-' . $this->service->getName()
			),
			wfMessage( 'maps-loading-map' )->inContentLanguage()->escaped() .
				Html::element(
					'div',
					array( 'style' => 'display:none', 'class' => 'mapdata' ),
					FormatJson::encode( $this->getJSONObject( $params, $parser ) )
				)
		);
	}

	/**
	 * Returns a PHP object to encode to JSON with the map data.
	 *
	 * @since 2.0
	 *
	 * @param array $params
	 * @param Parser $parser
	 *
	 * @return mixed
	 */
	protected function getJSONObject( array $params, Parser $parser ) {
		return $params;
	}

	/**
	 * Handles the request from the parser hook by doing the work that's common for all
	 * mapping services, calling the specific methods and finally returning the resulting output.
	 *
	 * @param array $params
	 * @param Parser $parser
	 *
	 * @return html
	 */
	public final function renderMap( array $params, Parser $parser ) {
		$this->handleMarkerData( $params, $parser );

		$mapName = $this->service->getMapId();

		$output = $this->getMapHTML( $params, $parser, $mapName );

		$configVars = Skin::makeVariablesScript( $this->service->getConfigVariables() );

		$this->service->addDependencies( $parser );
		$parser->getOutput()->addHeadItem( $configVars );

		return $output;
	}

	/**
	 * Converts the data in the coordinates parameter to JSON-ready objects.
	 * These get stored in the locations parameter, and the coordinates on gets deleted.
	 *
	 * @since 1.0
	 *
	 * @param array &$params
	 * @param Parser $parser
	 */
	protected function handleMarkerData( array &$params, Parser $parser ) {
		$parserClone = clone $parser;

		$iconUrl = MapsMapper::getFileUrl( $params['icon'] );
		$visitedIconUrl = MapsMapper::getFileUrl( $params['visitedicon'] );
		$params['locations'] = array();

		/**
		 * @var MapsLocation $location
		 */
		foreach ( $params['coordinates'] as $location ) {
			if ( $location->isValid() ) {
				$jsonObj = $location->getJSONObject( $params['title'], $params['label'], $iconUrl, '', '',$visitedIconUrl);

				$jsonObj['title'] = $parserClone->parse( $jsonObj['title'], $parserClone->getTitle(), new ParserOptions() )->getText();
				$jsonObj['text'] = $parserClone->parse( $jsonObj['text'], $parserClone->getTitle(), new ParserOptions() )->getText();
				$jsonObj['inlineLabel'] = strip_tags($parserClone->parse( $jsonObj['inlineLabel'], $parserClone->getTitle(), new ParserOptions() )->getText(),'<a><img>');

				$hasTitleAndtext = $jsonObj['title'] !== '' && $jsonObj['text'] !== '';
				$jsonObj['text'] = ( $hasTitleAndtext ? '<b>' . $jsonObj['title'] . '</b><hr />' : $jsonObj['title'] ) . $jsonObj['text'];
				$jsonObj['title'] = strip_tags( $jsonObj['title'] );

				$params['locations'][] = $jsonObj;
			}
		}

		unset( $params['coordinates'] );

		$textContainers = array(
			&$params['lines'] ,
			&$params['polygons'] ,
			&$params['circles'] ,
			&$params['rectangles'],
			&$params['imageoverlays'], // FIXME: this is Google Maps specific!!
		);

		foreach ( $textContainers as &$textContainer ) {
			if ( is_array( $textContainer ) ) {
				foreach ( $textContainer as &$obj ) {
					$obj['title'] = $parserClone->parse( $obj['title'] , $parserClone->getTitle() , new ParserOptions() )->getText();
					$obj['text'] = $parserClone->parse( $obj['text'] , $parserClone->getTitle() , new ParserOptions() )->getText();

					$hasTitleAndtext = $obj['title'] !== '' && $obj['text'] !== '';
					$obj['text'] = ( $hasTitleAndtext ? '<b>' . $obj['title'] . '</b><hr />' : $obj['title'] ) . $obj['text'];
					$obj['title'] = strip_tags( $obj['title'] );
				}
			}
		}
	}
	
}