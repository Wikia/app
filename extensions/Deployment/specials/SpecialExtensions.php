<?php

/**
 * A special page that allows browing and searching through installed extensions.
 * Based on Special:Version.
 * 
 * @since 0.1
 * 
 * @file SpecialExtensions.php
 * @ingroup Deployment
 * @ingroup SpecialPage
 * 
 * @author Jeroen De Dauw
 */
class SpecialExtensions extends SpecialPage {

	/**
	 * @var boolean
	 */
	protected $openedFirstExtension = false;
	
	protected static $viewvcUrls = array(
		'svn+ssh://svn.wikimedia.org/svnroot/mediawiki' => 'http://svn.wikimedia.org/viewvc/mediawiki',
		'http://svn.wikimedia.org/svnroot/mediawiki' => 'http://svn.wikimedia.org/viewvc/mediawiki',
		# Doesn't work at the time of writing but maybe some day: 
		'https://svn.wikimedia.org/viewvc/mediawiki' => 'http://svn.wikimedia.org/viewvc/mediawiki',
	);
	
	protected $typeFilter;
	
	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct( 'Extensions' );	
	}
	
	/**
	 * @see SpecialPage::getDescription
	 */
	public function getDescription() {
		return wfMsg( 'special-' . strtolower( $this->getName() ) );
	}	

	/**
	 * Main method.
	 * 
	 * @since 0.1
	 * 
	 * @param $arg String
	 */
	public function execute( $arg ) {
		global $wgOut;

		$this->typeFilter = is_null( $arg ) ? 'all' : $arg;
		
		$wgOut->setPageTitle( wfMsg( 'extensions-title' ) );		
		
		$this->displayPage();	
	}
	
	/**
	 * Creates and outputs the page contents.
	 * 
	 * @since 0.1
	 */
	protected function displayPage() {
		global $wgOut, $wgUser;
		
		if ( $wgUser->isAllowed( 'siteadmin' ) ) {
			$this->displayAddNewButton();
		}
		else {
			// TODO: fix url
			$wgOut->addWikiMsg( 'extension-page-explanation' );
		}
		
		$wgOut->addHTML(
			Xml::element( 'h2', array( 'id' => 'mw-version-ext' ), wfMsg( 'version-extensions' ) )
		);
		
		$this->displayFilterControl();
		
		$this->displayBulkActions();
		
		$this->displayExtensionList();		
	}
	
	/**
	 * Created and outputs an "add new" button linking to the Special:Install page. 
	 * 
	 * @since 0.1
	 */		
	protected function displayAddNewButton() {
		global $wgOut;
		
		$wgOut->addHTML( 
			Html::element(
				'button',
				array(
					'type' => 'button',
					'onclick' => 'window.location="' . Xml::escapeJsString( SpecialPage::getTitleFor( 'install' )->getFullURL() ) . '"'
				),
				wfMsg( 'add-new-extensions' )
			)
		);		
	}

	/**
	 * Creates and outputs the filter control.
	 * 
	 * @since 0.1
	 */	
	protected function displayFilterControl() {
		global $wgOut, $wgExtensionCredits;
		
		$extensionAmount = 0;
		$filterSegments = array();
		
		$extensionTypes = SpecialVersion::getExtensionTypes();
		
		foreach ( $extensionTypes as $type => $message ) {
			if ( !array_key_exists( $type, $wgExtensionCredits ) ) {
				continue;
			}
			
			$amount = count( $wgExtensionCredits[$type] );
			
			if ( $amount > 0 ) {
				$filterSegments[] = $this->getTypeLink( $type, $message, $amount ); 
				$extensionAmount += $amount;					
			}
		}
		
		$all = array( $this->getTypeLink( 'all', wfMsg( 'extension-type-all' ), $extensionAmount ) );
		
		$wgOut->addHTML( implode( ' | ', array_merge( $all, $filterSegments ) ) );
	}
	
	/**
	 * Builds and returns the HTML for a single item in the filter control.
	 * 
	 * @since 0.1
	 * 
	 * @param $type String
	 * @param $message String
	 * @param $amount Integer
	 * 
	 * @return string
	 */
	protected function getTypeLink( $type, $message, $amount ) {
		if ( $this->typeFilter == $type ) {
			$name = Html::element( 'b', array(), $message );
		}
		else {
			$name = Html::element(
				'a',
				array(
					'href' => self::getTitle( $type == 'all' ? null : $type )->getFullURL()
				),
				$message
			);			
		}
			
		return "$name ($amount)";
	}
	
	/**
	 * Creates and outputs the bilk actions control.
	 * 
	 * @since 0.1
	 */		
	protected function displayBulkActions() {
		// TODO
	}
	
	/**
	 * Displays the installed extensions (of the selected type).
	 * 
	 * @since 0.1
	 * 
	 * @return string
	 */
	protected function displayExtensionList() {
		global $wgOut, $wgExtensionCredits;
		
		if ( !array_key_exists( $this->typeFilter, $wgExtensionCredits ) && $this->typeFilter != 'all' ) {
			$wgOut->addWikiMsg( 'extension-invalid-category', $this->typeFilter );
			$this->typeFilter = 'all';
		}
		
		$extensions = array();
		
		if ( $this->typeFilter == 'all' ) {
			foreach ( $wgExtensionCredits as $type => $exts ) {
				$extensions = array_merge( $extensions, $exts );
			}
		}
		else {
			$extensions = $wgExtensionCredits[$this->typeFilter];
		}
		
		if ( count( $extensions ) == 0 ) {
			if ( $this->typeFilter == 'all' ) {
				$wgOut->addWikiMsg( 'extension-none-installed', 'Special:Install' );
			}
			else {
				$wgOut->addWikiMsg( 'extension-empty-category', $this->typeFilter );
			}
		}
		else {
			$extensionObjects = array();
			
			foreach( $extensions as $extension ) {
				$infoObject = ExtensionInfo::newFromArray( $extension );
				$extensionObjects[$infoObject->getName()] = $infoObject;
			}
			
			$extensionNames = array_keys( $extensionObjects );
			
			natcasesort( $extensionNames );
			
			$wgOut->addHTML( Html::openElement(
				'table',
				array( 'class' => 'wikitable', 'style' => 'width:100%' )
			) );
			
			$wgOut->addHTML(
				'<tr>' . 
				Html::element( 'th', array(), wfMsg( 'extension' ) ) .
				Html::element( 'th', array(), wfMsg( 'extensionlist-description' ) )
				. '</tr>'
			);
			
			foreach ( $extensionNames as $extensionName ) {
				$this->displayExtensionRow( $extensionObjects[$extensionName] );
			}			
			
			$wgOut->addHTML( Html::closeElement( 'table' ) );
		}
	}
	
	/**
	 * Displays a single extension in the list.
	 * 
	 * @since 0.1
	 * 
	 * @param $extensions ExtensionInfo
	 */	
	protected function displayExtensionRow( ExtensionInfo $extension ) {
		global $wgOut;
		
		// TODO: use seperate rows for title + desc and controls + links
		
		// TODO: add row that shows with update info when an update is detected
		
		$wgOut->addHTML( '<tr><td>' );
		
		$wgOut->addHTML( $this->getItemNameTdContents( $extension ) );
		
		$wgOut->addHTML( '</td><td>' );
		
		$version = wfMsgExt( 'extensionlist-version-number', 'parsemag', $extension->getVersion() );
		
		$wgOut->addWikiText(
			$extension->getDescription() . '<br />'  .
				$version . ' | ' . $extension->getCreatedByMessage()
		);
		
		$wgOut->addHTML( '</td></tr>' );
	}
	
	/**
	 * Returns the contents for the first field in an extension row.
	 * If the user has the required permissions, controls will be shown.
	 * 
	 * @since 0.1
	 * 
	 * @param $extension ExtensionInfo
	 * 
	 * @return string
	 */	
	protected function getItemNameTdContents( ExtensionInfo $extension ) {
		global $wgUser;
		
		$html = Html::element( 'b', array(), $extension->getName() );
		
		$controls = array();
		
		if ( $extension->getDocumentationUrl() ) {
			$controls[] = Html::element(
				'a',
				array(
					'href' => $extension->getDocumentationUrl(),
					'class' => 'external text'
				),
				wfMsg( 'extensionlist-details' )		
			);			
		}
		
		if ( $wgUser->isAllowed( 'siteadmin' ) ) {
			$controls[] = Html::element(
				'a',
				array(
					'href' => '',
				),
				wfMsg( 'extensionlist-deactivate' )		
			);
		}
	
		if ( count( $controls ) > 0 ) {
			$html .= '<br />' . implode( ' | ', $controls );
		}
		
		return $html;
	}
	
}
