<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

/**
 * Updates schema of database
 * Also checks for required core methods
 */
class qp_SchemaUpdater {

	private static $required_classes_and_methods = array(
		# todo: do not forget to update the list of used core methods
		# except of these which are called immediately in LocalSettings.php
		array(
			# alternatives list
			array( 'Article' => 'doPurge' ),
			array( 'WikiPage' => 'doPurge' )
		),
		array( 'StubObject' => 'isRealObject' ),
		array( 'Linker' => 'link' ),
		array( 'OutputPage' => 'isPrintable' ),
		array( 'PPFrame' => 'expand' ),
		array( 'Parser' => 'getTitle' ),
		array( 'Parser' => 'setHook' ),
		array( 'Parser' => 'recursiveTagParse' ),
		array( 'ParserCache' => 'getKey' ),
		array( 'ParserCache' => 'singleton' ),
		array( 'Title' => 'getArticleID' ),
		array( 'Title' => 'getPrefixedText' ),
		array( 'Title' => 'makeTitle' ),
		array( 'Title' => 'makeTitleSafe' ),
		array( 'Title' => 'newFromID' ),
		array( 'WebResponse' => 'setCookie' ),
		array( 'Language' => 'lc' ),
		array( 'Language' => 'truncate' ),
		array( 'User' => 'isAnon' )
	);

	/**
	 * Checks whether the required core methods exists
	 */
	static function coreRequirements() {
		foreach ( self::$required_classes_and_methods as &$check ) {
			if ( array_key_exists( 0, $check ) ) {
				# process alternatives
				$methodFound = false;
				$methodNames = '';
				foreach ( $check as &$clm ) {
					if ( method_exists( key( $clm ), current( $clm ) ) ) {
						$methodFound = true;
						break;
					}
					if ( $methodNames !== '' ) {
						$methodNames .= ', ';
					}
					$methodNames .= key( $clm ) . '::' . current( $clm );
				}
				if ( !$methodFound ) {
					throw new Exception( "QPoll extension requires one of the following methods to be available: {$methodNames} .<br />\n" .
						"Your version of MediaWiki is incompatible with this extension.\n" );
				}
			} else {
				# process one method
				if ( !method_exists( key( $check ), current( $check ) ) ) {
					throw new Exception( "QPoll extension requires " . key( $check ) . "::" . current( $check ) . " method to be available.<br />\n" .
						"Your version of MediaWiki is incompatible with this extension.\n" );
				}
			}
		}
		if ( !defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
			throw new Exception( "QPoll extension requires ParserFirstCallInit hook.\nPlease upgrade your MediaWiki installation first.\n" );
		}
	}

	# keys are the paths of script files to run
	private static $scriptsToRun = array();
	# values are the list of initialized tables
	private static $tablesInit = array();
	# keys are the list of upgraded tables
	private static $tablesUpgrade = array();

	# new tables to add
	static $sql_tables = array(
		'qpoll_0.7.0.src' => array(
			'qp_poll_desc',
			'qp_question_desc',
			'qp_question_categories',
			'qp_question_proposals',
			'qp_question_answers',
			'qp_users_polls',
			'qp_users'
		),
		'qpoll_random_questions.src' => array(
			'qp_random_questions'
		)
	);

	# new fields for already existing tables
	static $addFields = array(
		'qpoll_interpretation.src' => array(
			'qp_poll_desc' => array( 'interpretation_namespace', 'interpretation_title' ),
			'qp_users_polls' => array( 'attempts', 'short_interpretation', 'long_interpretation' )
		),
		'qpoll_structured_interpretation.src' => array(
			'qp_users_polls' => array( 'structured_interpretation' )
		),
		'qpoll_question_name.src' => array(
			'qp_question_desc' => array( 'name' )
		)
	);

	# Table/field names are currently unused, they are only for informational purpose.
	static $modifyFields = array(
		'qpoll_proposal_text_length.src' => array( 'qp_question_proposals' => array( 'proposal_text' ) ),
		'qpoll_mediumtext_to_text.src' => array(
			'qp_poll_desc' => array( 'dependance' ),
			'qp_question_desc' => array( 'common_question' ),
			'qp_question_answers' => array( 'text_answer' ),
		)
	);

	/**
	 * check for existence of multiple tables in the selected database
	 * @param  $tableset  array list of DB tables in set
	 * @return  array with names of non-existing tables in specified list
	 */
	private static function tablesExists( array $tableset ) {
		$db = & wfGetDB( DB_MASTER );
		$tablesNotFound = array();
		foreach ( $tableset as &$table ) {
			if ( !$db->tableExists( $table ) ) {
				$tablesNotFound[] = $table;
			}
		}
		return $tablesNotFound;
	}

	/**
	 * check for the existence of multiple fields in the selected database table
	 * @param $table  string  table name
	 * @param $fields  mixed  array/string field(s) names
	 * @return  array with names of non-existing fields in specified table
	 */
	private static function fieldsExists( $table, $fields ) {
		$db = & wfGetDB( DB_MASTER );
		if ( !is_array( $fields ) ) {
			$fields = array( $fields );
		}
		$fieldsNotFound = array();
		foreach ( $fields as $field ) {
			if ( !$db->fieldExists( $table, $field ) ) {
				$fieldsNotFound[] = $field;
			}
		}
		return $fieldsNotFound;
	}

	/**
	 * Initializes missed tables grouped by their related sets
	 */
	private static function initializeTables() {
		$db = & wfGetDB( DB_MASTER );
		/* check whether the tables were initialized */
		$result = true;
		foreach ( self::$sql_tables as $sourceFile => &$tableset ) {
			$tablesNotFound = self::tablesExists( $tableset );
			if ( count( $tablesNotFound ) === count( $tableset ) ) {
				# all of the tables in set are missing
				self::$tablesInit = array_merge( self::$tablesInit, $tableset );
				# no tables were found, initialize the DB completely with minimal version
				if ( ( $r = $db->sourceFile( qp_Setup::$ExtDir . "/tables/{$sourceFile}" ) ) !== true ) {
					throw new Exception( $r );
				}
			} elseif ( count( $tablesNotFound ) > 0 ) {
				# some tables are missing, serious DB error
				throw new Exception( "The following extension's database tables are missing: " . implode( ', ', $tablesNotFound ) . "<br />Please restore from backup or drop the remaining extension tables, then reload this page." );
			}
		}
	}

	/**
	 * Check for added fields
	 */
	static private function fieldsToAdd() {
		foreach ( self::$addFields as $script => &$table_list ) {
			foreach ( $table_list as $table => &$fields_list ) {
				$fieldsNotFound = self::fieldsExists( $table, $fields_list );
				if ( count( $fieldsNotFound ) > 0 ) {
					self::$scriptsToRun[$script] = true;
					self::$tablesUpgrade[$table] = true;
					if ( count( $fieldsNotFound ) !== count( $fields_list ) ) {
						throw new Exception( 'Field(s) (' . implode( ', ', array_diff( $fields_list, $fieldsNotFound ) ) . ') already exist in the table ' . $table . '. Fields cannot be added partially, only the whole set :' . implode( ', ', $fields_list ) );
					}
				}
			}
		}
	}

	/**
	 * Check for modifying existing fields
	 *
	 * note: Unfortunately, I cannot reliably distinguish tinytext field from
	 * text field via MySQLField methods. So, I've made unconditional ALTERing.
	 *
	 */
	static private function fieldsToModify() {
		/* try to modify existing fields */
		foreach ( self::$modifyFields as $script => &$table_fields ) {
			self::$scriptsToRun[$script] = true;
			foreach ( $table_fields as $table => $fields_list ) {
				$fieldsNotFound = self::fieldsExists( $table, $fields_list );
				if ( count( $fieldsNotFound ) > 0 ) {
					throw new Exception( 'Field(s) (' . implode( ', ', $fieldsNotFound ). ') cannot be modified, because it does not exist' );
				}
				self::$tablesUpgrade[$table] = true;
			}
		}
	}

	/**
	 * Run update scripts on already existing tables
	 */
	static private function doUpdates() {
		$db = & wfGetDB( DB_MASTER );
		foreach ( self::$scriptsToRun as $script => $val ) {
			if ( ( $r = $db->sourceFile( qp_Setup::$ExtDir . "/archives/{$script}" ) ) !== true ) {
				throw new Exception( $r );
			}
		}
	}

	/**
	 * Check whether the extension's tables exist in DB;
	 * Add/update tables/fields when necessary.
	 * @return  boolean true if tables are found, string with error message otherwise
	 */
	static function checkAndUpdate() {
		try {
			self::coreRequirements();
			self::initializeTables();
			self::fieldsToAdd();
			self::fieldsToModify();
			self::doUpdates();
		} catch ( Exception $e ) {
				return nl2br( $e->getMessage() );
		}
		$result = ''; # great, no errors
		if ( count( self::$tablesInit ) > 0 ) {
			$result = 'The following table(s) were initialized: ' . implode( ', ', self::$tablesInit ) . '<br />';
		}
		if ( count( self::$tablesUpgrade ) > 0 ) {
			$result .= 'The following table(s) were upgraded: ' . implode( ', ', array_keys( self::$tablesUpgrade ) ) . '<br />';
		}
		return $result;
	}

	/**
	 * Updates tables from CLI via php update.php
	 */
	public static function onLoadExtensionSchemaUpdates( $updater = null ) {
		global $wgExtNewTables, $wgExtModifiedFields;
		# add tables
		foreach ( self::$sql_tables as $sourceFile => &$tableset ) {
			foreach ( $tableset as $table ) {
				$scriptFile = qp_Setup::$ExtDir . "/tables/{$sourceFile}";
				if ( is_null( $updater ) ) {
					$wgExtNewTables[] = array( $table, $scriptFile );
				} else {
					$updater->addExtensionUpdate( array( 'addTable', $table, $scriptFile, true ) );
				}
			}
		}
		# add fields
		foreach ( self::$addFields as $script => &$table_list ) {
			$scriptFile = qp_Setup::$ExtDir . "/archives/{$script}";
			foreach ( $table_list as $table => &$fields_list ) {
				foreach ( $fields_list as $field ) {
					if ( is_null( $updater ) ) {
						$wgExtNewFields[] = array( $table, $field, $scriptFile );
					} else {
						$updater->addExtensionUpdate( array( 'addField', $table, $field, $scriptFile, true ) );
					}
				}
			}
		}
		# modify fields
		foreach ( self::$modifyFields as $script => &$table_list ) {
			$scriptFile = qp_Setup::$ExtDir . "/archives/{$script}";
			foreach ( $table_list as $table => $fields_list ) {
				foreach ( $fields_list as $field ) {
					if ( is_null( $updater ) ) {
						$wgExtModifiedFields[] = array( $table, $field, $scriptFile );
					} else {
						$updater->addExtensionUpdate( array( 'modifyField', $table, $field, $scriptFile, true ) );
					}
				}
			}
		}
		return true;
	}

} /* end of qp_SchemaUpdater class */
