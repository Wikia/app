<?php

/**
 * Class to render star ratings.
 * 
 * @since 0.1
 * 
 * @file RatingsStars.php
 * @ingroup Ratings
 * 
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class RatingsStars extends ParserHook {
	/**
	 * No LSB in pre-5.3 PHP *sigh*.
	 * This is to be refactored as soon as php >=5.3 becomes acceptable.
	 */
	public static function staticInit( Parser &$parser ) {
		$instance = new self;
		return $instance->init( $parser );
	}

	/**
	 * Gets the name of the parser hook.
	 * @see ParserHook::getName
	 * 
	 * @since 0.1
	 * 
	 * @return string
	 */
	protected function getName() {
		return array( 'starrating' );
	}
	
	/**
	 * Returns an array containing the parameter info.
	 * @see ParserHook::getParameterInfo
	 * 
	 * @since 0.1
	 * 
	 * @return array
	 */
	protected function getParameterInfo( $type ) {
		global $egRatingsShowWhenDisabled, $egRatingsIncSummary;
		
		$params = array();
		
		$params['page'] = new Parameter( 'page' );
		$params['page']->setDescription( wfMsg( 'ratings-par-page' ) );
		$params['page']->setDefault( false, false );
		
		$params['tag'] = new Parameter( 'tag' );
		$params['tag']->setDescription( wfMsg( 'ratings-par-tag' ) );		
		
		$params['showdisabled'] = new Parameter( 'showdisabled', Parameter::TYPE_BOOLEAN );
		$params['showdisabled']->setDescription( wfMsg( 'ratings-par-showdisabled' ) );			
		$params['showdisabled']->setDefault( $egRatingsShowWhenDisabled );
		
		$params['incsummary'] = new Parameter( 'incsummary', Parameter::TYPE_BOOLEAN );
		$params['incsummary']->setDescription( wfMsg( 'ratings-par-incsummary' ) );			
		$params['incsummary']->setDefault( $egRatingsIncSummary );		
		
		return $params;
	}
	
	/**
	 * Returns the list of default parameters.
	 * @see ParserHook::getDefaultParameters
	 * 
	 * @since 0.1
	 * 
	 * @return array
	 */
	protected function getDefaultParameters( $type ) {
		return array( 'tag', 'page' );
	}
	
	/**
	 * Renders and returns the output.
	 * @see ParserHook::render
	 * 
	 * @since 0.1
	 * 
	 * @param array $parameters
	 * 
	 * @return string
	 */
	public function render( array $parameters ) {
		$this->loadJs( $parameters );
		
		$parameters['page'] = $parameters['page'] === false ? $GLOBALS['wgTitle'] : Title::newFromText( $parameters['page'] ); 
		
		static $ratingStarNr = 0; $ratingStarNr++;
		
		$inputs = array();
		
		for ( $i = 0; $i < 5; $i++ ) {
			$inputs[] = Html::element(
				'input',
				array(
					'class' => 'starrating',
					'type' => 'radio',
					'name' => 'ratingstars_' . $ratingStarNr,
					'value' => $i,
					'page' => $parameters['page']->getFullText(),
					'tag' => $parameters['tag'],
				)
			);
		}
		
		if ( $parameters['incsummary'] ) {
			array_unshift( $inputs, htmlspecialchars( Ratings::getRatingSummaryMessage( $parameters['page'], $parameters['tag'] ) ) . '<br />' );
		}
		
		return Html::rawElement(
			'div',
			array( 'style' => 'display:none; position:static', 'class' => 'starrating-div' ),
			implode( '', $inputs )
		);
	}
	
	/**
	 * Loads the needed JavaScript.
	 * Takes care of non-RL compatibility.
	 * 
	 * @since 0.1
	 * 
	 * @param array $parameters
	 */
	protected function loadJs( array $parameters ) {
		static $loadedJs = false;
		
		if ( $loadedJs ) {
			return;
		}
		
		$loadedJs = true;
		
		$this->addJSWikiData( $parameters );
		
		// For backward compatibility with MW < 1.17.
		if ( is_callable( array( $this->parser->getOutput(), 'addModules' ) ) ) {
			$this->parser->getOutput()->addModules( 'ext.ratings.stars' );
		}
		else {
			global $egRatingsScriptPath, $wgStylePath, $wgStyleVersion;
			
			$this->addJSLocalisation();

			$this->parser->getOutput()->addHeadItem(
				Html::linkedScript( "$wgStylePath/common/jquery.min.js?$wgStyleVersion" ),
				'jQuery'
			);
			
			Ratings::loadJs( $this->parser );
			
			$this->parser->getOutput()->addHeadItem(
				Html::linkedScript( $egRatingsScriptPath . '/starrating/star-rating/jquery.rating.js' )
				. Html::linkedStyle( $egRatingsScriptPath . '/starrating/star-rating/jquery.rating.css' ),
				'ext.ratings.stars.jquery'
			);			
			
			$this->parser->getOutput()->addHeadItem(
				Html::linkedScript( $egRatingsScriptPath . '/starrating/ext.ratings.stars.js' ),
				'ext.ratings.stars'
			);
		}		
	}	
	
	/**
	 * Ouput the wiki data needed to display the licence links.
	 * 
	 * @since 0.1
	 * 
	 * @param array $parameters
	 */
	protected function addJSWikiData( array $parameters ) {
		$this->parser->getOutput()->addHeadItem(
			Html::inlineScript(
				'var wgRatingsShowDisabled =' . json_encode( $parameters['showdisabled'] ) . ';'
			)
		);
	}
	
	/**
	 * Adds the needed JS messages to the page output.
	 * This is for backward compatibility with pre-RL MediaWiki.
	 * 
	 * @since 0.1
	 */
	protected function addJSLocalisation() {
		global $egRatingsStarsJSMessages;
		
		$data = array();
	
		foreach ( $egRatingsStarsJSMessages as $msg ) {
			$data[$msg] = wfMsgNoTrans( $msg );
		}

		$this->parser->getOutput()->addHeadItem( Html::inlineScript( 'var wgRatingsStarsMessages = ' . json_encode( $data ) . ';' ) );
	}
	
	/**
	 * Returns the parser function otpions.
	 * @see ParserHook::getFunctionOptions
	 * 
	 * @since 0.1
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
	 * @see ParserHook::getDescription()
	 * 
	 * @since 0.1
	 */
	public function getDescription() {
		return wfMsg( 'ratings-starsratings-desc' );
	}		
	
}
