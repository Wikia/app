<?php

/**
 * Page to manage LiveTranslate translation memories.
 * 
 * @since 0.4
 * 
 * @file SpecialLiveTranslate.php
 * @ingroup LiveTranslate
 * 
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SpecialLiveTranslate extends SpecialPage {
	
	/**
	 * Constructor.
	 * 
	 * @since 0.4
	 */
	public function __construct() {
		parent::__construct( 'LiveTranslate', 'managetms' );
	}
	
	/**
	 * @see SpecialPage::getDescription
	 * 
	 * @since 0.4
	 */
	public function getDescription() {
		return wfMsg( 'special-' . strtolower( $this->getName() ) );
	}
	
	/**
	 * Sets headers - this should be called from the execute() method of all derived classes!
	 * 
	 * @since 0.4
	 */
	public function setHeaders() {
		global $wgOut;
		$wgOut->setArticleRelated( false );
		$wgOut->setRobotPolicy( "noindex,nofollow" );
		$wgOut->setPageTitle( $this->getDescription() );
	}	
	
	/**
	 * Main method.
	 * 
	 * @since 0.4
	 * 
	 * @param string $arg
	 */
	public function execute( $arg ) {
		global $wgOut, $wgUser, $wgRequest;
		
		$this->setHeaders();
		$this->outputHeader();
		
		// If the user is authorized, display the page, if not, show an error.
		if ( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}
		
		if ( $wgRequest->wasPosted() && $wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) ) ) {
			$this->handleSubmission();
		}
		
		$tms = $this->getTMConfigItems();
		
		$this->displayTMConfig( $tms );
		
		$this->updateTranslationMemory( $tms );
	}
	
	/**
	 * Handles the submission of the config form.
	 * 
	 * @since 0.4
	 */	
	protected function handleSubmission() {
		global $wgRequest;
		
		$tms = $this->getTMConfigItems();
		
		$dbw = wfGetDB( DB_MASTER );

		// Loop over the existing translation memories and update/delete them if requested.
		foreach ( $tms as $tm ) {
			// If a delete has been requested, remove the item.
			if ( $wgRequest->getCheck( 'tmdel-' . $tm->memory_id ) ) {
				$dbw->delete(
					'live_translate_memories',
					array( 'memory_id' => $tm->memory_id )
				);
			}
			// If changes where made, apply them in the db.
			elseif (
				$wgRequest->getText( 'tmlocation-' . $tm->memory_id ) != $tm->memory_location
				|| $wgRequest->getInt( 'wptmtype-' . $tm->memory_id ) != $tm->memory_type
				|| ( $wgRequest->getCheck( 'tmlocal-' . $tm->memory_id ) ? 1 : 0 ) != $tm->memory_local
				) {
				$dbw->update(
					'live_translate_memories',
					array(
						'memory_location' => $wgRequest->getText( 'tmlocation-' . $tm->memory_id ),
						'memory_type' => $wgRequest->getInt( 'wptmtype-' . $tm->memory_id ),
						'memory_local' => $wgRequest->getCheck( 'tmlocal-' . $tm->memory_id ) ? 1 : 0
					),
					array( 'memory_id' => $tm->memory_id )
				);
			}
		}
		
		// If there is a new item, insert it.
		if ( $wgRequest->getText( 'newtm-location' ) != '' ) {
			$dbw->insert(
				'live_translate_memories',
				array(
					'memory_type' => $wgRequest->getInt( 'wpnewtm-type' ),
					'memory_location' => $wgRequest->getText( 'newtm-location' ),
					'memory_local' => $wgRequest->getCheck( 'newtm-local' ) ? 1 : 0
				)
			);
		}
	}
	
	/**
	 * Updates the translation memory stored in the db.
	 * 
	 * @since 0.4
	 * 
	 * @param array $tms The current translation memories
	 */
	protected function updateTranslationMemory( array $tms ) {
		$dbr = wfGetDB( DB_SLAVE );
		
		// Just drop everything and rebuild the entire translation memory.
		$dbr->query( 'TRUNCATE TABLE ' . $dbr->tableName( 'live_translate' ) );
		
		foreach ( $tms as $tm ) {
			$requestData = array(
				'action' => 'importtms',
				'format' => 'json',
				'source' => $tm->memory_location,
				'type' => $tm->memory_type,
				'local' => $tm->memory_local,
			);
			
			$api = new ApiMain( new FauxRequest( $requestData, true ), true );
			$api->execute();
			$response = $api->getResultData();					
		}
	}
	
	/**
	 * Displays the translation memories config table.
	 * 
	 * @since 0.4
	 * 
	 * @param array $tms The current translation memories
	 */		
	protected function displayTMConfig( array $tms ) {
		global $wgOut, $wgUser;
		
		$wgOut->addHtml( Xml::openElement(
			'form',
			array(
				'id' => 'tmform',
				'name' => 'tmform',
				'method' => 'post',
				'action' => $this->getTitle()->getLocalURL(),
			)
		) );
		
		if ( count( $tms ) > 0 ) {
			/*
			$wgOut->addHTML( '<h3>' . htmlspecialchars( wfMsg( 'livetranslate-special-tms-update' ) ) . '</h3>' );
			
			$wgOut->addHTML(
				Html::input(
					'',
					wfMsg( 'livetranslate-special-update' ),
					'submit',
					array( 'id' => 'tmform-updatesubmit' )
				)
			);
			*/
			
			$wgOut->addHTML( '<h3>' . htmlspecialchars( wfMsg( 'livetranslate-special-current-tms' ) ) . '</h3>' );
			
			$wgOut->addHTML( Xml::openElement(
				'table',
				array( 'class' => 'wikitable', 'style' => 'width:50%' )
			) );

			$wgOut->addHTML( Html::rawElement(
				'tr',
				array(),
				Html::element( 'th', array( 'width' => '400px' ), wfMsg( 'livetranslate-special-location' ) ) .
				Html::element( 'th', array( 'width' => '160px' ), wfMsg( 'livetranslate-special-type' ) ) .
				Html::element( 'th', array( 'width' => '160px' ), wfMsg( 'livetranslate-special-local' ) ) .
				Html::element( 'th', array( 'width' => '100px' ), wfMsg( 'livetranslate-special-remove' ) )
			) );			
			
			foreach ( $tms as $tm ) {
				$this->displayTMItem( $tm );
			}

			$wgOut->addHTML( Xml::closeElement( 'table' ) );
		}
		else {
			$wgOut->addWikiMsg( 'livetranslate-special-no-tms-yet' );
		}
		
		$this->displayAddNewTM();
		
		$wgOut->addHtml(
			'<br />' .
			Html::input(
				'',
				wfMsg( 'livetranslate-special-button' ),
				'submit',
				array( 'id' => 'tmform-submit' )
			) .
			Html::hidden( 'wpEditToken', $wgUser->editToken() ) .
			Xml::closeElement( 'form' )
		);
	}
	
	/**
	 * Displays a single row in the translation memories config table.
	 * 
	 * @since 0.4
	 * 
	 * @return array
	 */		
	protected function getTMConfigItems() {
		$dbr = wfGetDB( DB_SLAVE );
		
		$res = $dbr->select(
			'live_translate_memories',
			array( 'memory_id', 'memory_type', 'memory_location', 'memory_local' ),
			array(),
			__METHOD__,
			array( 'LIMIT' => '5000' )
		);
		
		$tms = array();
		
		// Iterate over the result items in the result wrapper to end up with a regular array.
		foreach ( $res as $tm ) {
			$tms[] = $tm;
		}
		
		return $tms;
	}
	
	/**
	 * Displays a single row in the translation memories config table.
	 * 
	 * @since 0.4
	 * 
	 * @param object $tm
	 */	
	protected function displayTMItem( $tm ) {
		global $wgOut;

		$wgOut->addHTML( Html::rawElement(
			'tr',
			array(),
			Html::rawElement(
				'td',
				array(),
				Html::input( 'tmlocation-' . $tm->memory_id, $tm->memory_location, 'text', array( 'size' => 60 ) )
			) .					
			Html::rawElement(
				'td',
				array(),
				$this->getTypeSelector( 'tmtype-' . $tm->memory_id, $tm->memory_type )
			) .	
			Html::rawElement(
				'td',
				array( 'style' => 'text-align:center' ),
				Xml::check( 'tmlocal-' . $tm->memory_id, $tm->memory_local != "0" )
			) .						
			Html::rawElement(
				'td',
				array( 'style' => 'text-align:center' ),
				Xml::check( 'tmdel-' . $tm->memory_id, false )
			)	
		) );
	}
	
	/**
	 * Displays an input to add a new translation memory.
	 * 
	 * @since 0.4
	 */		
	protected function displayAddNewTM() {
		global $wgOut, $egLiveTranslateTMT;
		
		$wgOut->addHTML( '<h3>' . htmlspecialchars( wfMsg( 'livetranslate-special-add-tm' ) ) . '</h3>' );
		
		$wgOut->addHTML(
			'<table><tr>' .
				'<td><b>' . htmlspecialchars( wfMsg( 'livetranslate-special-type' ) ) . ': </b></td>' .
				'<td>' . $this->getTypeSelector( 'newtm-type', $egLiveTranslateTMT ) . '</td>' .		
			'</tr><tr>' .
				'<td><b>' . htmlspecialchars( wfMsg( 'livetranslate-special-location' ) ) . ': </b></td>' .
				'<td>' . Html::input( 'newtm-location', '', 'text', array( 'size' => 75 ) ) . '</td>' .
			'</tr><tr>' .
				'<td><b>' . htmlspecialchars( wfMsg( 'livetranslate-special-local' ) ) . ': </b></td>' .
				'<td>' . Xml::check( 'newtm-local', false ) . '</td>' .		
			'</tr></table>'
		);
	}
	
	/**
	 * Builds up an HTML select for translation memory types with the provided name.
	 * The value parameter allows setting which item should be selected.
	 * 
	 * @since 0.4
	 * 
	 * @param string $name
	 * @param string $value
	 * 
	 * @return string
	 */
	protected function getTypeSelector( $name, $value ) {
		$typeSelector = new HTMLSelectField( array(
			'fieldname' => $name,
			'options' => $this->getTypeOptions()
		) );
		
		return $typeSelector->getInputHTML( $value );
	}
	
	/**
	 * Returns an array with the translation memory type names (keys)
	 * and their database values (values).
	 * 
	 * @since 0.4
	 * 
	 * @return array
	 */
	protected function getTypeOptions() {
		static $options = false;
		
		if ( $options === false ) {
			$options = array();
			
			$tmTypes = array(
				TMT_LTF => 'ltf',
				TMT_TMX => 'tmx',
				TMT_GCSV => 'gcsv',
			);			
			
			foreach ( $tmTypes as $dbValue => $msgKey ) {
				$options[wfMsg( 'livetranslate-tmtype-' . $msgKey )] = $dbValue;
			}
		}
		
		return $options;
	}
	
}
