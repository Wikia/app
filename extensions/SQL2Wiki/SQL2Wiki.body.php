<?php

class SQL2Wiki {

	private $mDB;
	private $mDBType;
	
	private $mDBMSOutput;
	
	private $mArgs;
	private $mPLSQLMode;
	private $mInlineTag = null;
	
	private $mResult = null;
	private $mOutput = null;
	private $mError = null;

	private $ignoreAttributes = array( 'database', 'inline', 'fieldseparator', 'lineseparator', 'cache', 'expand', 'preexpand', 'quiet' );
	private $ignoreTabAttributes = array( 'tableclass', 'tablestyle', 'hrowstyle', 'hcellstyle', 'rowstyle', 'cellstyle', 'style', 'noheader' );

	public static function initTags( &$parser ) {
		$parser->setHook( "sql2wiki", "SQL2Wiki::renderSQL" );
		$parser->setHook( "plsql2wiki", "SQL2Wiki::renderPLSQL" );
		return true;
	}

	public static function renderSQL( $input, $args, $parser, $frame ) {
		try {
			$s2w = new SQL2Wiki( $args );

			$sql = ( $s2w->shouldPreexpand() ) ? $parser->recursiveTagParse( $input ) : $input;
			
			if ( !$s2w->execute( $sql ) ) {
				return $s2w->mError;
			}
			
			if ( ( $inline = $s2w->getInlineTag() ) !== false )
				$ret = $s2w->parseInline();
			else
				$ret = $s2w->parseTable();
			
			$ret = ( $s2w->shouldExpand() ) ? $parser->recursiveTagParse( $ret ) : $ret;
			$ret .= $s2w->handleCache( $parser );
			
			return $ret;	
		} catch ( Exception $ex ) {
			return $ex->getMessage();
		}
	}

	public static function renderPLSQL( $input, $args, $parser, $frame ) {
		try {
			$s2w = new SQL2Wiki( $args, true );

			if ( !$s2w->isPLSQLSupported() ) {
				return wfMsgForContent( 'sql2wiki-err-feature_not_supported', $s2w->getDBType() );
			}

			$sql = ( $s2w->shouldPreexpand() ) ? $parser->recursiveTagParse( $input ) : $input;
			
			if ( !$s2w->execute( $sql ) ) {
				return $s2w->mError;
			}

			$ret = $s2w->parseInline();

			$ret = ( $s2w->shouldExpand() ) ? $parser->recursiveTagParse( $ret ) : $ret;
			$ret .= $s2w->handleCache( $parser );
			
			return $ret;
		} catch ( Exception $ex ) {
			return $ex->getMessage();
		}
	}
	
	public function __construct( $args, $PLSQLMode = false ) {
		global $wgExSql2WikiDatabases;

		$this->mArgs = $args;
		$this->mPLSQLMode = $PLSQLMode;

		if ( !isset( $this->mArgs["database"] ) || !isset( $wgExSql2WikiDatabases[$this->mArgs["database"]] ) ) 
			throw new Exception( wfMsgForContent( 'sql2wiki-err-invalid_db_id' ) );
			
		$lastError = null;
		try {
			wfSuppressWarnings();
			$db = $wgExSql2WikiDatabases[$this->mArgs["database"]];
			$this->mDBType = $db['type'];
			$this->mDB = Database::newFromType( $this->mDBType, $db );
			wfRestoreWarnings();
		} catch ( Exception $ex) {
			$lastError = $ex->getMessage();
		}
		
		if ( $lastError == null && !$this->mDB->isOpen() ) {
			$lastError = $this->mDB->lastError();
		}
		
		if ( $lastError != null ) {
			throw new Exception( wfMsgForContent( 'sql2wiki-err-failed_to_connect',  $this->mArgs["database"] ) . "<br />\n$lastError" );
		}
	}
	
	public function isPLSQLSupported() {
		return ($this->mDBType == 'oracle');
	}
	
	public function isDBMSOutputSupported() {
		return ($this->mDBType == 'oracle');
	}
	
	public function shouldPreexpand() {
		return ( isset( $this->mArgs["preexpand"] ) && $this->mArgs["preexpand"] == 'true' );
	}
	
	public function shouldExpand() {
		return ( isset( $this->mArgs["expand"] ) && $this->mArgs["expand"] == 'true' );
	}
	
	public function getInlineTag() {
		if ( $this->mInlineTag == null ) {
			$this->mInlineTag = ( isset( $this->mArgs["inline"] ) )
				? $this->mArgs["inline"] 
				: ( $this->mPLSQLMode ? 'span' : false ) ;
		}
		return $this->mInlineTag;
	}
	
	public function getDBType() {
		return $this->mDBType;
	}
	
	public function execute( $sql ) {

		$this->initDBMSOutput();

		try {
			$this->mResult = $this->mDB->query( $sql, 'SQL2Wiki::execute', true );
			$this->getDBMSOutput();
		} catch (DBQueryError $ex) {
			if ( !( isset( $this->mArgs["quiet"] ) && $this->mArgs["quiet"] == 'true' ) ) {
				$this->mError = wfMsgForContent( 'sql2wiki-err-failed_to_execute',  $sql, $ex->error );
			}
			return false;
		}

		return true;	
	}
	
	public function handleCache ( $parser ) {
		$cache = isset( $this->mArgs["cache"] ) ? $this->mArgs["cache"] : 'on';
		
		if ( $cache == 'off') {
			$parser->disableCache();
		} elseif ( $cache == 'manual' && ($this->mPLSQLMode || $this->getInlineTag() === false) ) {
			return '<br />'.
						Xml::openElement(	'a', 
											array( 'href' => $parser->getTitle()->getLocalURL( array( 'action' => 'purge' ) ) ) ).
						Xml::element( 'small', null, wfMsgForContent( 'sql2wiki-cache_refresh' ) ).
						Xml::closeElement( 'a' );
		}
		
		return '';
	}
	
	private function initDBMSOutput() {
		if ( !$this->isDBMSOutputSupported() ) {
			$this->mDBMSOutput = false;
			return;
		}
		
		$this->mDbmsOutput = ( isset( $this->mArgs["dbmsoutput"] ) && $this->mArgs["dbmsoutput"] == 'true' );
		if ($this->mDBMSOutput) {
			$this->enableDBMSOutput();
		}
	}
	
	private function enableDBMSOutput() {
		if ( !$this->isDBMSOutputSupported() ) {
			return;
		}
		
		$this->mDB->query ('BEGIN dbms_output.enable(null); END;');
	}
	
	private function disableDBMSOutput() {
		if ( !$this->isDBMSOutputSupported() ) {
			return;
		}
		
		$this->mDB->query ('BEGIN dbms_output.disable; END;');
	}

	private function getDBMSOutput() {
		if ( !$this->mDBMSOutput ) {
			return false;
		}

		$this->mOutput = array();

		$ret = $dbObj->query('SELECT column_value FROM TABLE(get_output_lines())');
		while(($line = $ret->fetchObject()) !== FALSE) {
			$this->mOutput[] = $line->column_value;
		}
	}
	
	private function parseInline() {
		$fieldSeparator = isset( $this->mArgs["fieldseparator"] ) ? $this->mArgs["fieldseparator"] : '';
		$lineSeparator = isset( $this->mArgs["lineseparator"] ) ? $this->mArgs["lineseparator"] : '';

		$output = '';
		while ( ($line = $this->mResult->fetchObject() ) !== FALSE) {
			if ( $output != '' ) {
				$output .= $lineSeparator."\n";
			}

			foreach ( $line as $value ){
				$output .= $value.$fieldSeparator;
			}
			$output = substr( $output, 0, strlen( $output )-strlen( $fieldSeparator ) );
		}
		
		$attributes = array_diff_key( $this->mArgs, array_flip( $this->ignoreAttributes ) );
		return Xml::openElement( $this->getInlineTag(), $attributes).
				$output.
				Xml::closeElement( $this->getInlineTag() );
	}

	private function parseTable() {
		$line = $this->mResult->fetchObject();
		if ( $line === false ) {
			return '';
		}

		$tableClass = isset( $this->mArgs["tableclass"] ) ? $this->mArgs["tableclass"] : 'wikitable';
		$tableStyle = isset( $this->mArgs["tablestyle"] ) ? $this->mArgs["tablestyle"] : 'border: black solid 1px;';

		$attributes = array_diff_key( $this->mArgs, array_flip( $this->ignoreAttributes ), array_flip( $this->ignoreTabAttributes ) );

		$output = Xml::openElement( 'table', array_merge( $attributes, array( 'style' => $tableStyle, 'class' => $tableClass ) ) );

		if ( !isset( $this->mArgs["noheader"] ) || $this->mArgs["noheader"] != 'true' ) {
			$headerRowStyle = isset( $this->mArgs["hrowstyle"] ) ? $this->mArgs["hrow_style"] : '';
			$headerCellStyle = isset( $this->mArgs["hcellstyle"] ) ? $this->mArgs["hcellstyle"] : 'font-weight: bold;';
			$headerCellStyle = array_merge( $attributes, array( 'style' => $headerCellStyle ) );

			$output .= Xml::openElement( 'tr', array_merge( $attributes, array( 'style' => $headerRowStyle ) ) );

			foreach ( $line as $key=>$value ) {
				$output .= Xml::openElement( 'th',  $headerCellStyle ).
							$key.
							Xml::closeElement( 'th' );
			}

			$output .= Xml::closeElement( 'tr' );
		} 

		$rowStyle = isset( $this->mArgs["rowstyle"] ) ? $this->mArgs["rowstyle"] : '';
		$cellStyle = isset( $this->mArgs["cellstyle"] ) ? $this->mArgs["cellstyle"] : '';
		$cellStyle = array_merge( $attributes, array( 'style' => $cellStyle ) );
		
		do {
			$output .= Xml::openElement( 'tr', array_merge( $attributes, array( 'style' => $rowStyle ) ) );

			foreach ( $line as $key=>$value ) {
				$output .= Xml::openElement( 'td',  $cellStyle ).
							$value.
							Xml::closeElement( 'td' );
			}

			$output .= Xml::closeElement( 'tr' );
		} while ( ( $line = $this->mResult->fetchObject() ) !== false );


		$output .= Xml::closeElement( 'table' );
		
		return $output;
	}

} 
