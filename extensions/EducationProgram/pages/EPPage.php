<?php

/**
 * Abstract Page for interacting with a EPDBObject.
 *
 * @since 0.1
 *
 * @file EPPage.php
 * @ingroup EducationProgram
 * @ingroup Page
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class EPPage extends Page implements IContextSource {

	/**
	 * Returns a list of actions this page can handle.
	 * Array keys are action names, their values are the names of the handling Action classes.
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	protected abstract function getActions();

	/**
	 * @since 0.1
	 * @var IContextSource
	 */
	protected $context;

	/**
	 * @since 0.1
	 * @var WikiPage
	 */
	protected $page;
	
	public function __construct( Title $title ) {
		$this->page = new WikiPage( $title );
	}
	
	public function view() {
	//	MediaWiki::articleFromTitle($title, $context)
	}
	
	public function setContext( IContextSource $context ) {
		$this->context = $context;
	}
	
	public function getContext() {
		return $this->context;
	}
	
	public function getPage() {
		return $this->page;
	}
	
	public function isRedirect() {
		return false;
	}
	
	public function getTitle() {
		return $this->page->getTitle();
	}
	
	public function getRequest() {
		return $this->getContext()->getRequest();
	}
	
	public function canUseWikiPage() {
		return $this->getContext()->canUseWikiPage();
	}

	public function getWikiPage() {
		return $this->getContext()->getWikiPage();
	}
	
	public function getOutput() {
		return $this->getContext()->getOutput();
	}

	public function getUser() {
		return $this->getContext()->getUser();
	}

	public function getLanguage() {
		return $this->getContext()->getLanguage();
	}
	
	public function getSkin() {
		return $this->getContext()->getSkin();
	}

	public function msg( /* $args */ ) {
		$args = func_get_args();
		return call_user_func_array( array( $this->getContext(), 'msg' ), $args );
	}
	
	public function getActionOverrides() {
		$actions = $this->getActions();
		
		foreach ( $GLOBALS['wgActions'] as $actionName => $actionValue ) {
			if ( !array_key_exists( $actionName, $actions ) ) {
				$actions[$actionName] = false;
			}
		}
		
		return $actions;
	}
	
	public function getTouched() {
		return '19700101000000';
	}

	/**
	 * @deprecated
	 * @return Language
	 */
	public function getLang() {
		wfDeprecated( __METHOD__, '1.19' );
		return $this->getLanguage();
	}
	
}
