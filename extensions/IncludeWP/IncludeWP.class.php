<?php

/**
 * CLass to render the sub page list.
 * 
 * @since 0.1
 * 
 * @file SubPageList.class.php
 * @ingroup IncludeWP
 * 
 * @licence GNU GPL v3 or later
 *
 * @author Jeroen De Dauw
 * @author James McCormack (email: user "qedoc" at hotmail); preceding version Martin Schallnahs <myself@schaelle.de>, original Rob Church <robchur@gmail.com>
 * @copyright © 2008 James McCormack, preceding version Martin Schallnahs, original Rob Church
 */
final class IncludeWP extends ParserHook {
	/**
	 * No LSB in pre-5.3 PHP *sigh*.
	 * This is to be refactored as soon as php >=5.3 becomes acceptable.
	 */	
	public static function staticInit( Parser &$parser ) {
		$className = __CLASS__;
		$instance = new $className();
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
		return array( 'include' );
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
		global $egIncWPWikis, $egIncWPDefaultWiki, $egIncWPParagraphs, $egIncWPDivHeight;
		
		$params = array();
		
		$params['page'] = new Parameter( 'page' );
		$params['page']->setDescription( wfMsg( 'includewp-include-par-page' ) );
		
		$params['wiki'] = new Parameter( 'wiki' );
		
		if ( !array_key_exists( $egIncWPDefaultWiki, $egIncWPWikis  ) ) {
			$egIncWPDefaultWiki = array_shift( array_keys( $egIncWPWikis ) );
		}
		
		$params['wiki']->setDefault( $egIncWPDefaultWiki );
		$params['wiki']->addCriteria( new CriterionInArray( array_keys( $egIncWPWikis ) ) );
		$params['wiki']->addManipulations( new ParamManipulationFunctions( 'strtolower' ) );
		$params['wiki']->setDescription( wfMsg( 'includewp-include-par-wiki' ) );
		
		$params['paragraphs'] = new Parameter( 'paragraphs', Parameter::TYPE_INTEGER );
		$params['paragraphs']->setDefault( $egIncWPParagraphs );
		$params['paragraphs']->setDescription( wfMsg( 'includewp-include-par-paragraphs' ) );
		
		$params['height'] = new Parameter( 'height', Parameter::TYPE_INTEGER );
		$params['height']->setDefault( $egIncWPDivHeight );		
		$params['height']->setDescription( wfMsg( 'includewp-include-par-height' ) );
		
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
		return array( 'page', 'wiki' );
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
		static $nr = 0;
		$nr++;
		
		$this->loadJs();
		
		$html = Html::element(
			'div',
			array(
				'id' => 'includewp-loading-' . $nr,
				'pageid' => $nr,
				'class' => 'includewp-loading',
				'page' => $parameters['page'],
				'wiki' => $parameters['wiki'],
				'paragraphs' => $parameters['paragraphs']
			),
			wfMsgForContent( 'includewp-loading-page' )
		);
		
		$html .= Html::element(
			'div',
			array(
				'id' => 'includewp-article-' . $nr,
				'class' => 'includewp-article',
				'style' => $parameters['height'] > 0 ? 'width:auto; max-height: ' . $parameters['height'] . 'px; overflow: auto' : 'width:auto'
			),
			''
		);	

		$html .= Html::element(
			'div',
			array(
				'id' => 'includewp-copyright-' . $nr,
				'class' => 'includewp-copyright',
				'style' => 'color:darkgray'
			),
			''
		);			
		
		return $html;
	}
	
	/**
	 * Loads the needed JavaScript.
	 * Takes care of non-RL compatibility.
	 * 
	 * @since 0.1
	 */
	protected function loadJs() {
		static $loadedJs = false;
		
		if ( $loadedJs ) {
			return;
		}
		
		$loadedJs = true;
		
		$this->addJSWikiData();
		
		// For backward compatibility with MW < 1.17.
		if ( is_callable( array( $this->parser->getOutput(), 'addModules' ) ) ) {
			$this->parser->getOutput()->addModules( 'ext.incwp' );
		}
		else {
			global $egIncWPScriptPath, $wgStylePath, $wgStyleVersion;
			
			$this->addJSLocalisation();

			$this->parser->getOutput()->addHeadItem(
				Html::linkedScript( "$wgStylePath/common/jquery.min.js?$wgStyleVersion" ),
				'jQuery'
			);			
			
			$this->parser->getOutput()->addHeadItem(
				Html::linkedScript( $egIncWPScriptPath . '/ext.incwp.js' ),
				'ext.incwp'
			);
		}		
	}	
	
	/**
	 * Ouput the wiki data needed to display the licence links.
	 * 
	 * @since 0.1
	 */
	protected function addJSWikiData() {
		global $egIncWPWikis;
		
		$this->parser->getOutput()->addHeadItem(
			Html::inlineScript(
				'var wgIncWPWikis =' . FormatJson::encode( $egIncWPWikis ) . ';'
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
		global $egIncWPJSMessages;
		
		$data = array();
	
		foreach ( $egIncWPJSMessages as $msg ) {
			$data[$msg] = wfMsgNoTrans( $msg );
		}

		$this->parser->getOutput()->addHeadItem( Html::inlineScript( 'var wgIncWPMessages = ' . FormatJson::encode( $data ) . ';' ) );
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
		return wfMsg( 'includewp-parserhook-desc' );
	}		
	
}
