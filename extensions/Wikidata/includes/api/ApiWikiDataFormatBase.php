<?php


/*
 * Created on 9 nov 2007
 * 
 * Base formatter for WikiData defined meanings.
 *
 * Copyright (C) 2007 Edia <info@edia.nl>
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

abstract class ApiWikiDataFormatBase extends ApiFormatBase {

	protected $dmRecords;
	protected $excluded;
	protected $languages;
	protected $errorMessages;
	
	public function __construct( $main, $format ) {
		parent :: __construct( $main, $format );
		$this->dmRecords = array();
		$this->languages = array();
		$this->excluded = array();
		$this->errorMessages = array();
	}
	
	public function addDefinedMeaningRecord( & $dm ) {
		$this->dmRecords[] = $dm;
	}
	
	public function & getDefinedMeaningRecords() {
		return $this->dmRecords;
	}
	
	public function addOutputLanguageId( $id ) {
		$this->languages[] = $id;
	}
	
	public function & getOutputLanguageIds() {
		return $this->languages;
	}
	
	public function addErrorMessage( $message ) {
		$this->errorMessages[] = $message;
	}
	
	/**
	 * Exclude everything. 
	 * Standard behaviour is to include everything. If you want to start 
	 * from nothing and then include specific things, call this method first.
	 */
	public function excludeAll() {
		$this->setIncludeAltDefinitions( false );
		$this->setIncludeAnnotations( false );
		$this->setIncludeClassAttributes( false );
		$this->setIncludeClassMembership( false );
		$this->setIncludeCollectionMembership( false );
		$this->setIncludeDefinitions( false );
		$this->setIncludeRelations( false );
		$this->setIncludeSynTrans( false );
		$this->setIncludeSynTransAnnotations( false );
	}
	
	public function setIncludeDefinitions( $include ) {
		$this->setInclude( 'definition', $include );
	}
	
	public function isIncludeDefinitions() {
		return $this->isInclude( 'definition' );
	}

	/** Include alternative definitions. */
	public function setIncludeAltDefinitions( $include ) {
		$this->setInclude( 'alternative-definitions', $include );
	}
	
	public function isIncludeAltDefinitions() {
		return $this->isInclude( 'alternative-definitions' );
	}

	/** Include synonyms and translations. */
	public function setIncludeSynTrans( $include ) {
		$this->setInclude( 'synonyms-translations', $include );
	}
	
	public function isIncludeSynTrans() {
		return $this->isInclude( 'synonyms-translations' );
	}
	
	/** Include annotations of synonyms and translations such as part of speech. */
	public function setIncludeSynTransAnnotations( $include ) {
		$this->setInclude( 'option-attribute-values', $include );
	}
	
	public function isIncludeSynTransAnnotations() {
		return $this->isInclude( 'option-attribute-values' );
	}
	
	public function setIncludeClassAttributes( $include ) {
		$this->setInclude( 'class-attributes', $include );
	}
	
	public function isIncludeClassAttributes() {
		return $this->isInclude( 'class-attributes' );
	}
	
	/** Include annotations of the defined meaning itself, such as part of theme. */
	public function setIncludeAnnotations( $include ) {
		$this->setInclude( 'defined-meaning-attributes', $include );
	}
	
	public function isIncludeAnnotations() {
		return $this->isInclude( 'defined-meaning-attributes' );
	}
	
	public function setIncludeClassMembership( $include ) {
		$this->setInclude( 'class-membership', $include );
	}
	
	public function isIncludeClassMembership() {
		return $this->isInclude( 'class-membership' );
	}
	
	public function setIncludeCollectionMembership( $include ) {
		$this->setInclude( 'collection-membership', $include );
	}
	
	public function isIncludeCollectionMembership() {
		return $this->isInclude( 'collection-membership' );
	}
	
	public function setIncludeRelations( $include ) {
		$this->setInclude( 'reciprocal-relations', $include );
	}
	
	public function isIncludeRelations() {
		return $this->isInclude( 'reciprocal-relations' );
	}
	
	private function setInclude( $section, $include ) {
		if ( $include ) {
			unset( $this->excluded[$section] );
		}
		else {
			$this->excluded[$section] = $section;
		}
	}
	
	private function isInclude( $section ) {
		return !isset( $this->excluded[$section] );
	}

	public static function getBaseVersion() {
		return __CLASS__ . ': $Id: $';
	}
}
?>