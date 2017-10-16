<?php

/**
 * Class for the 'layer' tag for describing a layer.
 * Most code of 'Maps_LayerPage.php' is reused for this since in 3.0 layer
 * pages can contain wikitext and a layer definition must be made through
 * this tag extension.
 *
 * @since 3.0
 *
 * @file Maps_Layer.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 * @author Daniel Werner
 */
class MapsLayerDefinition extends ParserHook {
	
	/**
	 * The final layer representation of this tag.
	 *
	 * @since 3.0
	 *
	 * @var MapsLayer instance
	 */
	protected $layer;
	
	public function __construct() {
		/*
		 * make this a tag extension only to avoid weird parser function
		 * syntax as we have it in 'display_point' from the beginning!
		 */
		parent::__construct( true, false );
	}
	
	public static function initialize() {
		
	}
	
	/**
	 * Gets the name of the parser hook.
	 * @see ParserHook::getName
	 *
	 * @since 3.0
	 *
	 * @return string
	 */
	protected function getName() {
		return 'layer';
	}
	
	/**
	 * Returns an array containing the parameter info.
	 * @see ParserHook::getParameterInfo
	 *
	 * @since 3.0
	 *
	 * @return array
	 */
	protected function getParameterInfo( $type ) {
		$params = array();

		$params['type'] = array(
			'default' => false,
			'manipulatedefault' => false,
			'message' => 'maps-displaymap-par-coordinates', // TODO-customMaps: create a message
		);

		$params['name'] = array(
			'default' => false,
			'manipulatedefault' => false,
			// TODO-customMaps: addCriteria( new CriterionIsNonNumeric );
			'message' => 'maps-displaymap-par-coordinates', // TODO-customMaps: create a message
		);

		$params['definition'] = array(
			'default' => false,
			'manipulatedefault' => false,
			'message' => 'maps-displaymap-par-coordinates', // TODO-customMaps: create a message
			'post-format' => function( $value ) {
				return MapsLayers::parseLayerParameters( $value, "\n", '=' );
			}
		);

		return $params;
	}
	
	/**
	 * Returns the list of default parameters.
	 * @see ParserHook::getDefaultParameters
	 *
	 * @since 3.0
	 *
	 * @return array
	 */
	protected function getDefaultParameters( $type ) {
		return array( 'definition' );
	}
	
	/**
	 * Returns the parser function options.
	 * @see ParserHook::getFunctionOptions
	 *
	 * @since 3.0
	 *
	 * @return array
	 */
	protected function getFunctionOptions() {
		return array(
			'noparse' => true,
			'isHTML' => true
		);
	}

	/**
	 * @see ParserHook::getMessage()
	 *
	 * @since 3.0
	 */
	public function getMessage() {
		return 'maps-layerdefinition-description';
	}
	
	/**
	 * Returns the MapsLayerGroup with all layers of the same page which have been
	 * processed already. If the store is not attached to the parser object yet,
	 * an empty MapsLayerGroup will be attached as store after calling the function.
	 *
	 * @since 3.0
	 *
	 * @return MapsLayerGroup
	 */
	protected function getLayerStore() {
		$parserOutput = $this->parser->getOutput();
		
		// make sure layers store in current parsers ParserOutput is initialized:
		if( ! isset( $parserOutput->mExtMapsLayers ) ) {
			$parserOutput->mExtMapsLayers = new MapsLayerGroup();
		}
		return $parserOutput->mExtMapsLayers;
	}
	
	/**
	 * This will attach a user defined layer to the parser output of the parser which has
	 * started the <layer> rendering. All added layers will be stored in the database
	 * after page parsing.
	 * $layer will only be stored in case it is a subclass of MapsLayer and its definition
	 * is at least considered 'ok'.
	 *
	 * @since 3.0
	 *
	 * @param type $layer 
	 *
	 * @return boolean whether $layer has been added to the store
	 */
	protected function addLayerToStore( $layer ) {
		
		$store = $this->getLayerStore();
		
		// check whether $layer is a layer worthy to end up in the database:
		if( $layer === null || $layer === false
			|| ! is_subclass_of( $layer, 'MapsLayer' )
			|| ! $layer->isOk()
			|| $store->getLayerByName( $layer->getName() ) !== null // layer of same name in store already
			
		) {
			return false;
		}
		// add layer to store:
		$overwritten = $store->addLayer( $layer );
		
		if( $overwritten ) {
			/** @ToDo: Message that a layer was defined twice on that site */
		}
		return true;
	}
	
	/**
	 * Renders and returns the output.
	 * @see ParserHook::renderTag
	 *
	 * @since 3.0
	 *
	 * @param array $parameters
	 *
	 * @return string
	 */
	public function render( array $parameters ) {
		global $wgLang;

		// Check whether parser tag is used in the right namespace context, abort if not
		if( $this->parser->getTitle()->getNamespace() !== Maps_NS_LAYER ) {
			global $wgContLang;
			return $this->rawErrorbox(
				wfMessage(
					'maps-layerdef-wrong-namespace',
					$wgContLang->getNsText( Maps_NS_LAYER )
				)->inContentLanguage()->text()
			);
		}
		
		$type = $parameters['type'];
		
		if( $type === false ) {
			// no layer type specified
			
			$availableLayerTypes = MapsLayerTypes::getAvailableTypes();
			
			$out = $this->rawErrorbox(
				wfMessage(
					'maps-error-no-layertype',
					$wgLang->listToText( $availableLayerTypes ),
					count( $availableLayerTypes )
				)->inContentLanguage()->text()
			);
		}
		elseif( MapsLayerTypes::hasType( $type ) ) {
			// get layer name if any:
			$name = $parameters['name'] !== false ? $parameters['name'] : null;
			
			// make sure the layer has a label, if no user data, make something up:
			if( empty( $parameters['definition']['label'] ) ) {
				if( $name !== null ) {
					$labelSuffix = "- $name";
				} else {
					// label for unnamed layer:
					$labelSuffix = '#' . ( count( $this->getLayerStore()->getLayers( MapsLayerGroup::LAYERS_NUMERIC ) ) + 1 );
				}
				$parameters['definition']['label'] = $this->parser->getTitle()->getText() . ' ' . $labelSuffix;
			}

			// new layer from user input (could still be invalid):
			$layer = MapsLayers::newLayerFromDefinition( $type, $parameters['definition'], $name );
			
			$out = $this->renderLayerInfo( $layer );
		}
		else {
			// specified layer type is non-existant!
			
			$availableLayerTypes = MapsLayerTypes::getAvailableTypes();
			
			$out = $this->rawErrorbox(
				wfMessage(
					'maps-error-invalid-layertype',
					$this->validator->getParameter('type')->getOriginalValue(),
					$wgLang->listToText( $availableLayerTypes ),
					count( $availableLayerTypes )
				)->inContentLanguage()->text()
			);
		}

		// add the layer to the store after all info has been rendered:
		$this->addLayerToStore( $layer );

		return $out;
	}

	/**
	 * Responsible for actual output on the layer page which gives an overview of the layer definition.
	 *
	 * @since 3.0
	 *
	 * @param MapsLayer
	 *
	 * @return string
	 */
	public function renderLayerInfo( MapsLayer $layer ) {
		global $wgLang;

		// appropriate layer header:
		if( $layer->getName() !== null ) {

			// if layer with same name is defined on same page already:
			if( $this->getLayerStore()->getLayerByName( $layer->getName() ) !== null ) {
				return
					$this->errorbox(
						wfMessage(
							'maps-layerdef-equal-layer-name',
							$layer->getName()
						)->inContentLanguage()->text()
					);
			}
			$outHeader = wfMessage(
				'maps-layer-of-type-and-name',
				$layer->getType(),
				$layer->getName()
			)->inContentLanguage()->text();
		}
		else {
			$outHeader = wfMessage(
				'maps-layer-of-type',
				$layer->getType()
			)->inContentLanguage()->text();
		}
		$outHeader = "<span class=\"mapslayerhead\">$outHeader</span>";

		// info message about which services are supporting the layer(-type):
		$supportedServices = MapsLayerTypes::getServicesForType( $layer->getType() );
		$outServices = '<span class="mapslayersupports">' .
			wfMessage(
				'maps-layer-type-supported-by',
				$wgLang->listToText( $supportedServices ),
				count( $supportedServices )
			)->inContentLanguage()->escaped() . '</span>';

		$outTable = $this->getLayerDefinitionTable( $layer );

		return
			Html::rawElement(
				'div',
				array( 'class' => 'mapslayer' . ( $layer->isOk() ? '' : ' mapslayererror' ) ),
				$outHeader . $outServices . $outTable
			);
	}

	/**
	 * Displays the layer definition as a table.
	 *
	 * @since 3.0
	 *
	 * @param MapsLayer $layer
	 *
	 * @return string
	 */
	protected function getLayerDefinitionTable( MapsLayer $layer ) {
		$out = '';
		$outWarning = '';

		// check whether any error occurred during parameter validaton:
		if ( ! $layer->isValid() ) {
			$messages = $layer->getErrorMessages();
			$warnings = '';
			
			if( count( $messages ) === 1 ) {
				$warnings = htmlspecialchars( $messages[0] );
			} else {
				$warnings = '<ul><li>' . implode( '</li><li>', array_map( 'htmlspecialchars', $messages ) ) . '</li></ul>';
			}
			
			$warnings =
				'<tr><td class="mapslayerpropname">' .
				wfMessage(
					'maps-layerdef-invalid' . ( $layer->isOk() ? '' : '-fatal' ),
					count( $messages )
				)->inContentLanguage()->escaped() .
				"</td><td class=\"mapslayerpropval\">{$warnings}</td></tr>";
			
			$outWarning .= Html::rawElement(
					'table',
					array( 'width' => '100%', 'class' => ( $layer->isOk() ? 'mapslayerwarntable' : 'mapslayererrortable' ) ),
					$warnings
			);

			if( ! $layer->isOk() ) {
				// fatal error occurred, don't print definition table since this would be quite empty since
				// parameter validation aborted after fatal error parameter!
				return $outWarning;
			}
		}
		
		global $wgOut;
		$wgOut->addModules( 'ext.maps.layers' );
		
		$rows = array();
		
		// rows with layer definition:
		$properties = $layer->getPropertiesHtmlRepresentation( $this->parser );
				
		foreach ( $properties as $property => $value ) {
			$rows[] = Html::rawElement(
				'tr',
				array(),
				Html::element(
					'td',
					array( 'class' => 'mapslayerpropname' ),
					$property
				) .
				Html::rawElement(
					'td',
					array( 'class' => 'mapslayerpropval' ),
					$value
				)
			);
		}
		
		$out .= Html::rawElement(
				'table',
				array( 'width' => '100%', 'class' => 'mapslayertable' ),
				implode( "\n", $rows )
		);
		
		return ( $out . $outWarning );
	}
	
	/**
	 * wraps text inside an error box.
	 *
	 * @since 3.0
	 *
	 * @param string  $text text of the error, html-escaped.
	 *
	 * @return string
	 */
	protected function errorbox( $text, $raw = true ) {
		/**
		 * FIXME: using 'errorbox' isn't the best idea since it has
		 * some weird css definition, better would be introducing a
		 * own class and puttin the whole definition into a nicer box.
		 */
		return '<div class="errorbox" style="margin:0;">' . $text .'</div><div style="clear:both"></div>';
	}
	
	/**
	 * wraps text inside an error box.
	 *
	 * @since 3.0
	 *
	 * @param string $text text of the error, NOT html-escaped
	 *
	 * @return string
	 */
	protected function rawErrorbox( $text ) {
		$text = htmlspecialchars( $text );
		return $this->errorbox( $text );
	}
}
