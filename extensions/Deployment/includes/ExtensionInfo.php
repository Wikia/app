<?php

/**
 * File holding the ExtensionInfo class.
 *
 * @file ExtensionInfo.php
 * @ingroup Deployment
 *
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

/**
 * Class for handling extension information.
 * 
 * @since 0.1
 * 
 * @ingroup Deployment
 * 
 * @author Jeroen De Dauw
 */
class ExtensionInfo {
	
	/**
	 * The name of the extension.
	 * 
	 * @since 0.1
	 * 
	 * @var string
	 */
	protected $name;
	
	/**
	 * The extension version.
	 * 
	 * @since 0.1
	 * 
	 * @var string
	 */	
	protected $version;
	
	/**
	 * List of extension authors.
	 * 
	 * @since 0.1
	 * 
	 * @var array
	 */	
	protected $authors;
	
	/**
	 * The extension description.
	 * 
	 * @since 0.1
	 * 
	 * @var string
	 */
	protected $description;	
	
	/**
	 * The url of the extension documentation.
	 * 
	 * @since 0.1
	 * 
	 * @var string
	 */
	protected $documentationUrl;		
	
	/**
	 * Returns a new instance of ExtensionInfo by converting a $wgExtensionCredits entry.
	 * 
	 * @since 0.1
	 * 
	 * @param $extensionInfo Array 
	 */
	public static function newFromArray( array $extension ) {
		return new ExtensionInfo(
			array_key_exists( 'name', $extension ) ? $extension['name'] : wfMsg( 'extension-name-missing' ),
			array_key_exists( 'version', $extension ) ? $extension['version'] : wfMsg( 'version-unknown' ),
			array_key_exists( 'author', $extension ) ? (array)$extension['author'] : array(),
			self::getExtensionDescription( $extension ),
			array_key_exists( 'url', $extension ) ? $extension['url'] : false
		);
	}
	
	/**
	 * Returns the decription for an extension.
	 * 
	 * @since 0.1
	 * 
	 * @param $extension Array
	 * 
	 * @return string
	 */
	public static function getExtensionDescription( array $extension ) {
		$description = array_key_exists( 'description', $extension ) ? $extension['description'] : '';
		
		if ( array_key_exists( 'descriptionmsg', $extension ) ) {
			if( is_array( $extension['descriptionmsg'] ) ) {
				$descriptionMsgKey = $extension['descriptionmsg'][0];
				
				array_shift( $extension['descriptionmsg'] );
				array_map( 'htmlspecialchars', $extension['descriptionmsg'] );
				
				$msg = wfMsg( $descriptionMsgKey, $extension['descriptionmsg'] );
			} else {
				$msg = wfMsg( $extension['descriptionmsg'] );
			}
			
 			if ( !wfEmptyMsg( $extension['descriptionmsg'], $msg ) && $msg != '' ) {
 				$description = $msg;
 			}
		}

		return $description;
	}
	
	/**
	 * Constructor.
	 * 
	 * @since 0.1
	 * 
	 */	
	public function __construct( $name, $version, $authors = array(), $description = '', $documentationUrl = false ) {
		$this->name = $name;
		$this->version = $version;
		$this->authors = $authors;
		$this->description = $description;
		$this->documentationUrl = $documentationUrl;
	}
	
	/**
	 * Returns the extension name.
	 * 
	 * @since 0.1
	 * 
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * Returns the extension version.
	 * 
	 * @since 0.1
	 * 
	 * @return string
	 */	
	public function getVersion() {
		return $this->version;
	}	
	
	/**
	 * Returns the extension authors.
	 * 
	 * @since 0.1
	 * 
	 * @return array
	 */	
	public function getAuthors() {
		return $this->authors;
	}
	
	/**
	 * Returns the extension description.
	 * 
	 * @since 0.1
	 * 
	 * @return string
	 */	
	public function getDescription() {
		return $this->description;
	}	
	
	/**
	 * Returns the documentation url, or false when there is none.
	 * 
	 * @since 0.1
	 * 
	 * @return mixed: string or false
	 */	
	public function getDocumentationUrl() {
		return $this->documentationUrl;
	}
	
	/**
	 * Returns "created by [authors]" or an empty string when there are none.
	 * 
	 * @since 0.1
	 * 
	 * @param $extension Array
	 * 
	 * @return string
	 */	
	public function getCreatedByMessage() {
		global $wgLang; 
		
		if ( count( $this->getAuthors() ) == 0 ) {
			return '';
		}
		
		// TODO: resolve wikitext
		return wfMsgExt( 'extensionlist-createdby', 'parsemag', $wgLang->listToText( $this->getAuthors() ) );
	}	
	
}