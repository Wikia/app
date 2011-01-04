<?php

/**
 * Special handling for image description pages
 *
 * @since 0.7.1
 * 
 * @file Maps_LayerPage.php
 * @ingroup Maps
 * 
 * @author Jeroen De Dauw
 * 
 * TODO: check for the page being not created yet (then it's not invalid if there is nothing there...)
 */
class MapsLayerPage extends Article {
	
	/**
	 * Cached MapsLayer or false.
	 * 
	 * @since 0.7.1
	 * 
	 * @var false or MapsLayer
	 */
	protected $cachedLayer = false;
	
	/**
	 * Cached key-value pairs or false.
	 * 
	 * @since 0.7.2
	 * 
	 * @var false or array
	 */
	protected $keyValuePairs = false;
	
	/**
	 * Constructor.
	 * 
	 * @since 0.7.1
	 * 
	 * @param Title $title
	 */
	public function __construct( Title $title ) {
		parent::__construct( $title );
	}
	
	/**
	 * @see Article::view
	 * 
	 * @since 0.7.1
	 */
	public function view() {
		global $wgOut, $wgLang;
		
		$wgOut->setPageTitle( $this->mTitle->getPrefixedText() );
		
		if ( $this->exists() ) {
			$layerType = $this->getLayerType();
			
			if ( $layerType !== false && MapsLayers::hasLayer( $layerType ) ) {
				$wgOut->addHTML(
					Html::element(
						'h3',
						array(),
						wfMsgExt( 'maps-layer-of-type', 'parsemag', $layerType )
					)
				);
				
				$supportedServices = MapsLayers::getServicesForType( $layerType );
				
				$wgOut->addHTML(
					wfMsgExt( 'maps-layer-type-supported-by', 'parsemag', $wgLang->listToText( $supportedServices ), count( $supportedServices ) )
				);
				
				$this->displayLayerDefinition();
			}
			else {
				$availableLayerTypes = MapsLayers::getAvailableLayers();				
				
				if ( $layerType === false ) {
					$wgOut->addHTML(
						'<span class="errorbox">' .
						htmlspecialchars( wfMsgExt(
							'maps-error-no-layertype',
							'parsemag',
							$wgLang->listToText( $availableLayerTypes ),
							count( $availableLayerTypes )
						) ) .
						'</span><br />'
					);
				}
				else {					
					$wgOut->addHTML(
						'<span class="errorbox">' . 
						htmlspecialchars( wfMsgExt( 
							'maps-error-invalid-layertype',
							'parsemag',
							$this->getLayerType(),
							$wgLang->listToText( $availableLayerTypes ),
							count( $availableLayerTypes )
						) ) .
						'</span><br />'
					);						
				}
			}
		}
	}
	
	/**
	 * Displays the layer definition as a table.
	 * 
	 * @since 0.7.2
	 */
	protected function displayLayerDefinition() {
		global $wgOut;
		
		$layer = $this->getLayer();
		$errorHeader = '';
		
		if ( !$layer->isValid() ) {
			$messages = $layer->getErrorMessages( 'missing' );
			$errorString = '';
			
			if ( count( $messages ) > 0 ) {
				$errorString = '<br />' . implode( '<br />', array_map( 'htmlspecialchars', $messages ) );
			}
			
			$wgOut->addHTML(
				'<span class="errorbox">' .
				htmlspecialchars( wfMsg( 'maps-error-invalid-layerdef' ) ) . $errorString .
				'</span><br />'
			);
			
			$errorHeader = Html::element(
				'th',
				array( 'width' => '50%' ),
				wfMsg( 'maps-layer-errors' )
			);				
		}
		
		$rows = array();
		
		$rows[] = Html::rawElement(
			'tr',
			array(),
			Html::element(
				'th',
				array( 'width' => '200px' ),
				wfMsg( 'maps-layer-property' )
			) .
			Html::element(
				'th',
				array( 'colspan' ),
				wfMsg( 'maps-layer-value' )
			) . $errorHeader
		);		
		
		foreach ( $layer->getProperties() as $property => $value ) {
			$errorTD = '';
			
			if ( !$layer->isValid() ) {
				$messages = $layer->getErrorMessages( $property );
				
				if ( count( $messages ) > 0 ) {
					$errorString = implode( '<br />', array_map( 'htmlspecialchars', $messages ) );

					$errorTD = Html::rawElement(
						'td', 
						array(),
						$errorString
					);
				}
			}
			
			$valueTD = Html::element(
				'td',
				array( 'colspan' => $errorTD == '' && !$layer->isValid() ? 2 : 1 ),
				$value
			);			
			
			$rows[] = Html::rawElement(
				'tr',
				array(),
				Html::element(
					'td',
					array(),
					$property
				) .
				$valueTD . $errorTD
			);			
		}
		
		$wgOut->addHTML( Html::rawElement( 'table', array( 'width' => '100%', 'class' => 'wikitable sortable' ), implode( "\n", $rows ) ) );		
	}
	
	/**
	 * Returns if the layer definition in the page is valid.
	 * 
	 * @since 0.7.1
	 * 
	 * @return boolean
	 */
	public function hasValidDefinition( $service = null ) {
		if ( MapsLayers::hasLayer( $this->getLayerType(), $service ) ) {
			$layer = $this->getLayer();
			return $layer->isValid();
		}
		else {
			return false;
		}
	}
	
	/**
	 * Returns a new MapsLayer object created from the data in the page.
	 * 
	 * @since 0.7.1
	 * 
	 * @return MapsLayer
	 */
	public function getLayer() {
		if ( $this->cachedLayer === false ) {
			$this->cachedLayer = MapsLayers::getLayer( $this->getLayerType(), $this->getProperties() );
		}		
		
		return $this->cachedLayer;
	}
	
	/**
	 * Returns the properties defined on the page.
	 * 
	 * @since 0.7.1
	 * 
	 * @return array
	 */
	final protected function getProperties() {
		$properties = $this->getKeyValuePairs();

		if ( array_key_exists( 'type', $properties ) ) {
			unset( $properties['type'] );
		}
		
		return $properties;
	}
	
	/**
	 * Gets the layer type of false if none is set.
	 * 
	 * @since 0.7.2
	 * 
	 * @return string or false
	 */
	final protected function getLayerType() {
		$properties = $this->getKeyValuePairs();
		return array_key_exists( 'type' , $properties ) ? $properties['type'] : false;
	}	

	/**
	 * Returns all key-value pairs stored in the page.
	 * 
	 * @since 0.7.2
	 * 
	 * @return array
	 */
	final protected function getKeyValuePairs() {
		if ( $this->keyValuePairs === false ) {
			$this->keyValuePairs = array();
			
			if ( is_null( $this->mContent ) ) {
				$this->loadContent();
			}
			
			foreach ( explode( "\n", $this->mContent ) as $line ) {
				$parts = explode( '=', $line, 2 );
				
				if ( count( $parts ) == 2 ) {
					$this->keyValuePairs[strtolower( str_replace( ' ', '', $parts[0] ) )] = $parts[1];
				}
			}	
		}
		
		return $this->keyValuePairs;
	}
	
}