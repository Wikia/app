<?php

/**
 * Base special page for special pages in the Survey extension,
 * taking care of some common stuff and providing compatibility helpers.
 * 
 * @since 0.1
 * 
 * @file SpecialSurveyPage.php
 * @ingroup Survey
 * 
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class SpecialSurveyPage extends SpecialPage {
	
	/**
	 * @see SpecialPage::getDescription
	 * 
	 * @since 0.1
	 */
	public function getDescription() {
		return wfMsg( 'special-' . strtolower( $this->getName() ) );
	}
	
	/**
	 * Sets headers - this should be called from the execute() method of all derived classes!
	 * 
	 * @since 0.1
	 */
	public function setHeaders() {
		$out = $this->getOutput();
		$out->setArticleRelated( false );
		$out->setRobotPolicy( 'noindex,nofollow' );
		$out->setPageTitle( $this->getDescription() );
	}	
	
	/**
	 * Main method.
	 * 
	 * @since 0.1
	 * 
	 * @param string $arg
	 */
	public function execute( $subPage ) {
		global $wgUser;
		
		$this->setHeaders();
		$this->outputHeader();
		
		// If the user is authorized, display the page, if not, show an error.
		if ( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return false;
		}
		
		return true;
	}
	
	/**
	 * Add resource loader modules or use fallback code for
	 * earlier versions of MediaWiki.
	 * 
	 * @since 0.1
	 * 
	 * @param string|array $modules
	 */
	public function addModules( $modules ) {
		$this->getOutput()->addModules( $modules );
	}
	
	/**
	 * Show a message in an error box.
	 * 
	 * @since 0.1
	 * 
	 * @param string $message
	 */
	protected function showError( $message ) {
		$this->getOutput()->addHTML(
			'<p class="visualClear errorbox">' . wfMsgExt( $message, 'parseinline' ) . '</p>'
		);
	}
	
	/**
	 * Show a message in a warning box.
	 * 
	 * @since 0.1
	 * 
	 * @param string $message
	 */
	protected function showWarning( $message ) {
		$this->getOutput()->addHTML(
			'<p class="visualClear warningbox">' . wfMsgExt( $message, 'parseinline' ) . '</p>'
		);
	}
	
	/**
	 * Display navigation links.
	 * 
	 * @since 0.1
	 * 
	 * @param array $links
	 */
	protected function displayNavigation( array $links ) {
		$this->getOutput()->addHTML( Html::rawElement( 'p', array(), $this->getLanguage()->pipeList( $links ) ) );
	}
	
}
