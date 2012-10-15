<?php


/*
 * Created on Sep 19, 2006
 *
 * API for MediaWiki 1.8+
 *
 * Copyright (C) 2006 Yuri Astrakhan <FirstnameLastname@gmail.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	// Eclipse helper - will be ignored in production
	require_once ( 'ApiFormatBase.php' );
}

class ApiWikiDataFormatXml extends ApiWikiDataFormatBase {

	private $mRootElemName = 'wikidata';
	private $isError = false;
	private $format = 'plain';
	private $suppress_output = false;

	public function __construct( $main ) {
		parent :: __construct( $main, 'xml' );
	}
	
	public function initPrinter( $isError ) {
		$this->isError = $isError;
		parent :: initPrinter( $isError );
	}

	public function suppress_output( $suppress_output = true ) {
		$this->suppress_output = $suppress_output;
	}

	public function getMimeType() {
		if ( !$this->isError && count( $this->errorMessages ) == 0 ) {
			return 'text/xml';
		}
		else {
			 return 'text/plain';
		}
	}

	public function getNeedsRawData() {
		return false;
	}
	
	public function setRootElement( $rootElemName ) {
		$this->mRootElemName = $rootElemName;
	}
	
	public function setFormat( $format ) {
		$this->format = $format;
	}

	public function execute() {
		if ( !$this->isError && count( $this->errorMessages ) == 0 && !$this->suppress_output ) {
			$doc =& $this->createDocument();
			
			/* transform and output the xml document */
			$proc = $this->getXsltProcessor();
			echo $proc->transformToXML( $doc );
		} elseif ( $this->suppress_output ) {
			/* do nothing */
		} else {
			echo "An error occured.\r\n";
			foreach ( $this->errorMessages as $message ) {
				echo $message . "\r\n";
			}
		}
	}
	
	private function & getXsltProcessor() {
		// this is an attempt to work with precompiled stylesheets
		static $plainProc, $tbxProc;
		
		if ( $this->format == 'tbx' ) {
			if ( $tbxProc == null ) {
				$xsl = new DOMDocument();
				$xsl->load( "extensions/Wikidata/util/tbx.xsl" );
				$tbxProc = new XSLTProcessor();
				$tbxProc->importStylesheet( $xsl );
				$tbxProc->setParameter( '', 'siteUrl', 'http://kantoor.edia.nl/wikidata/index.php?title=DefinedMeaning:' );
			}
			return $tbxProc;
		}
		else {
			if ( $plainProc == null ) {
				$xsl = new DOMDocument();
				$xsl->load( "extensions/Wikidata/util/plaincopy.xsl" );
				$plainProc = new XSLTProcessor();
				$xsl = $plainProc->importStylesheet( $xsl );
			}
			return $plainProc;
		}
	}
	
	private function & createDocument() {
		$doc = new DOMDocument( '1.0', 'utf-8' );
		
		$root = $doc->createElement( $this->mRootElemName );
		$doc->appendChild( $root );
		
		$body = $doc->createElement( 'body' );
		$root->appendChild( $body );
		
		foreach ( $this->dmRecords as $dmRecord ) {
			$this->appendRecord( $dmRecord, 'defined-meaning', $body );
		}
		
		$xPath = new DOMXPath( $doc );
		$languageElements = $xPath->query( '//*[@language-id]' );
		foreach ( $languageElements as $languageElement ) {
			$languageElement->removeAttribute( 'language-id' );
		}
		
		return $doc;
	}
	
	private function appendRecord( & $record, $elmName, & $parentElm ) {
		
		$aExcluded = & $this->excluded;
		if ( isset( $aExcluded[$elmName] ) ) return;
		
		$element = new DOMElement( $elmName );
		$parentElm->appendChild( $element );
		
		$attributes = $record->getStructure()->getAttributes();
		foreach ( $attributes as $attribute ) {
			if ( is_string( $attribute->type ) ) {
				if ( $attribute->type == 'text' || $attribute->type == 'spelling' ) {
					$textNode = new DOMText( $record->getAttributeValue( $attribute ) );
					$element->appendChild( $textNode );
				}
				else if ( $attribute->type == 'language' ) {
					// We'll add the language code, but keep the language id because we need it later.
					// eventually, we'll remove it jusyt before we're done with the document.
					$languageId =  $record->getAttributeValue( $attribute );
					$languageCode = getLanguageIso639_3ForId( $languageId );
					$element->setAttribute( 'language-id', $languageId );
					$element->setAttribute( $attribute->id, $languageCode );
				}
				else {
					$element->setAttribute( $attribute->id, $record->getAttributeValue( $attribute ) );
				}
			}
			else {
				$value = $record->getAttributeValue( $attribute );
				if ( $value instanceof Record ) {
					// echo 'record: ' . $attribute->id . "\r\n";
					$this->appendRecord( $value, $attribute->id, $element );
				}
				else if ( $value instanceof RecordSet && $value->getRecordCount() > 0 ) {
					$listElement = new DOMElement( $attribute->id . '-list' );
					$element->appendChild( $listElement );
					for ( $i = 0; $i < $value->getRecordCount(); $i++ ) {
						$this->appendRecord( $value->getRecord( $i ), $attribute->id, $listElement );
					}
					// all children may have been excluded, so lets check and remove it if that's the case
					if ( !$listElement->hasChildNodes() ) {
						$element->removeChild( $listElement );
					}
				}
			}
		}
		
		// remove object-attributes elements that do not have children.
		if ( $elmName == 'object-attributes' && !$element->hasChildNodes() ) {
			$parentElm->removeChild( $element );
		}
		if ( !empty( $this->languages ) ) {// if languages is empty we'll return them all
			// remove definitions that aren't in a requested
			if ( $elmName == 'translated-text' ) {
				$language = $element->getAttribute( 'language-id' );
				if ( !in_array( $language, $this->languages ) ) {
					$parentElm->removeChild( $element );
				}
			}
			// remove synonyms-translations that aren't in a requested
			else if ( $elmName == 'synonyms-translations' ) {
				$language = $element->getElementsByTagName( 'expression' )->item( 0 )->getAttribute( 'language-id' );
				if ( !in_array( $language, $this->languages ) ) {
					$parentElm->removeChild( $element );
				}
			}
		}
		
	}
	
	public function getDescription() {
		return 'Output WikiData defined meaning in XML format' . parent :: getDescription();
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: $';
	}
	
}
?>
