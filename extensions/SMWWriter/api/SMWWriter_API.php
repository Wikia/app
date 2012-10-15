<?php
/**
 * Web-based APIs for changing metadata in SMW
 *
 * @file
 * @ingroup SMWWriter
 * @author Denny Vrandecic
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

require_once ( "$IP/includes/api/ApiBase.php" );

global $wgAPIModules;
$wgAPIModules['smwwrite'] = 'SMWWriterAPI';
$wgAPIModules['smwwritable'] = 'SMWWritableAPI';

/**
 * Web-based API for writing and changing metadata in SMW
 *
 * @ingroup SMWWriter API
 * @author denny
 */
class SMWWriterAPI extends ApiBase {

	public function __construct( $query, $moduleName ) {
		parent :: __construct( $query, $moduleName );
	}

	public function execute() {
		global $wgUser;

		$params = $this->extractRequestParams();
		if ( is_null( $params['title'] ) )
			$this->dieUsage( 'Must specify page title', 0 );
		if ( is_null( $params['summary'] ) )
			$this->dieUsage( 'Must specify edit summary', 2 );
		if ( is_null( $params['token'] ) )
			$this->dieUsageMsg( array( 'missingparam', 'token' ) );
		if ( !$wgUser->matchEditToken( $params['token'] ) )
			$this->dieUsageMsg( array( 'sessionfailure' ) );

		$add = $params['add'];
		$remove = $params['remove'];
		$flags = $params['flags'];
		$summary = $params['summary'];

		$titleObj = Title::newFromText( $params['title'] );
		if ( !$titleObj || $titleObj->isExternal() )
			$this->dieUsageMsg( array( 'invalidtitle', $params['title'] ) );

		$errors = $titleObj->getUserPermissionsErrors( 'edit', $wgUser );
		if ( !$titleObj->exists() )
			$errors = array_merge( $errors, $titleObj->getUserPermissionsErrors( 'create', $wgUser ) );
		if ( count( $errors ) )
			$this->dieUsageMsg( $errors[0] );

		// Now let's check whether we're even allowed to do this
		$errors = $titleObj->getUserPermissionsErrors( 'edit', $wgUser );
		if ( !$titleObj->exists() )
			$errors = array_merge( $errors, $titleObj->getUserPermissionsErrors( 'create', $wgUser ) );
		if ( count( $errors ) )
			$this->dieUsageMsg( $errors[0] );

		// TODO check APIEditPage to see if there is more security stuff to do?

		$writer = new SMWWriter( $titleObj );
		$removeData = $this->readData( $titleObj, $remove );
		$addData = $this->readData( $titleObj, $add );
		$flagsData = $this->readFlags( $flags );

		$writer->update( $removeData, $addData, $summary, $flagsData );

		$error = $writer->getError();
		$result = array();
		if ( empty( $error ) ) {
			$result['result'] = 'Success';
		} else {
			$result['result'] = $error;
		}

		$this->getResult()->addValue( null, 'smwwrite', $result );
	}

	/**
	 * Reads the paramstring for remove and add and turns it into
	 * SMWSemanticData object that can be used with the SMWWriter API
	 *
	 * @param Title $title Title of the page to be modified
	 * @param string $text The param value
	 * @return SMWSemanticData Object with the interpreted data from the param value
	 */
	private function readData( Title $title, /* string */ $text ) {
		if ( empty( $text ) )
			return new SMWSemanticData( SMWWikiPageValue::makePage( false, 0 ) );
		if ( $text == '*' )
			return new SMWSemanticData( SMWWikiPageValue::makePage( $title, 0 ) );

		$result = new SMWSemanticData( SMWWikiPageValue::makePageFromTitle( $title ) );

		$matches = array();
		preg_match_all( "/\[\[([^\[\]]*)\]\]/", $text, $matches, PREG_PATTERN_ORDER );
		foreach ( $matches[1] as $match ) {
			$parts = explode( "::", $match );
			if ( count( $parts ) != 2 ) continue;
			$property = SMWPropertyValue::makeUserProperty( trim( $parts[0] ) );
			if ( trim( $parts[1] ) == '*' )
				$value = SMWDataValueFactory::newPropertyObjectValue( $property, false );
			else
				$value = SMWDataValueFactory::newPropertyObjectValue( $property, trim( $parts[1] ) );
			$result->addPropertyObjectValue( $property, $value );
		}
		return $result;
	}

	private function readFlags( $text ) {
		$flags = 0;
		$flagtext = explode( "|", $text );
		foreach ( $flagtext as $f ) {
			if ( $f == 'ATOMIC_CHANGE' ) $flags |= SMWWriter::ATOMIC_CHANGE;
			if ( $f == 'IGNORE_CONSTANT' ) $flags |= SMWWriter::IGNORE_CONSTANT;
			if ( $f == 'EDIT_MINOR' ) $flags |= SMWWriter::EDIT_MINOR;
			if ( $f == 'CHANGE_TEXT' ) $flags |= SMWWriter::CHANGE_TEXT;
		}
		return $flags;
	}

	protected function getAllowedParams() {
		return array (
			'title' => null,
			'token' => null,
			'add' => null,
			'remove' => null,
			'flags' => null,
			'summary' => null
		);
	}

	protected function getParamDescription() {
		return array (
			'title' => 'Title of the page to modify',
			'token' => 'Edit token. You can get one of these through prop=info',
			'add' => 'Annotations to add. The format is like simple wiki annotations, i.e. [[property::value]]',
			'remove' => 'Annotations to remove. The format is like simple wiki annotations, i.e. [[property::value]]. If value is * then all values of that property will be replaced. If remove is *, then all annotations will be removed. If remove is empty, then content simply gets added',
			'flags' => 'Flags for the edit process. The following flags exist: ATOMIC_CHANGE, CHANGE_TEXT, EDIT_MINOR, IGNORE_CONSTANT. The flags are connected with the | symbol',
			'summary' => 'Edit summary'
		);
	}

	public function mustBePosted() {
		return true;
	}

	public function isWriteMode() {
		return true;
	}

	protected function getDescription() {
		return 'Call to set annotations in SMW';
	}

	public function getExamples() {
		return array (
			'api.php?action=smwwrite&title=WWW2011&add=[[deadline::7/11/2010]]&remove=[[deadline::*]]&summary=Deadline+extension&token=%2B'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: SMWWriter_API.php 72600 2010-09-08 18:21:13Z jeroendedauw $';
	}
}

/**
 * Web-based API for accessing the updateable part of metadata of a page.
 *
 * @ingroup SMWWriter API
 * @author denny
 */
class SMWWritableAPI extends ApiBase {

	public function __construct( $query, $moduleName ) {
		parent :: __construct( $query, $moduleName );
	}

	public function execute() {
		global $wgUser;

		$params = $this->extractRequestParams();
		if ( is_null( $params['title'] ) )
			$this->dieUsage( 'Must specify page title', 0 );

		$page = $params['title'];

		$articleTitle = Title::newFromText( $page );
		if ( !$articleTitle )
			$this->dieUsage( "Can't create title object ($page)", 3 );

		$article = new Article( $articleTitle );
		if ( !$article->exists() )
			$this->dieUsage( "Article doesn't exist ($page)", 5 );

		$writer = new SMWWriter( $articleTitle );
		$answer = $writer->getUpdateable();

		$result = array();

		$error = $writer->getError();

		if ( empty( $success ) ) {
			$result['result'] = 'Success';
		} else {
			$result['result'] = $error;
		}

		$this->process( $answer );

		$this->getResult()->addValue( null, 'smwwriteable', $result );
	}

	private function process( SMWSemanticData $answer ) {
		$this->getResult()->addValue( array( 'smwwriteable' ), 'title', $answer->getSubject()->getWikiValue() );
		$properties = $answer->getProperties();
		foreach ( $properties as $property ) {
			$values = $answer->getPropertyValues( $property );
			$valuestrings = array();
			foreach ( $values as $value ) $valuestrings[] = $value->getWikiValue();
			$this->getResult()->setIndexedTagName( $valuestrings, 'value' );
			$this->getResult()->addValue( array( 'smwwriteable', 'properties' ), $property->getWikiValue(), $valuestrings );
		}
	}

	protected function getAllowedParams() {
		return array (
			'title' => null
		);
	}

	protected function getParamDescription() {
		return array (
			'title' => 'Title of the page'
		);
	}

	protected function getDescription() {
		return 'Returns the list of all annotations that can be changed by the Writer API';
	}

	public function getExamples() {
		return array (
			'api.php?action=smwwritable&title=Paris'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: SMWWriter_API.php 72600 2010-09-08 18:21:13Z jeroendedauw $';
	}
}