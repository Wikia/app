<?php

$dir = dirname( __FILE__ ) . "/../../../../";
require_once( $dir . 'maintenance/Maintenance.php' );

use Flags\Models\FlagType;

class MoveNotices extends Maintenance {

	const
		SECTION_DEFAULT = 0,
		SECTION_ALL = 'all',
		EDIT_SUMMARY = 'Moving content notices to flags.';

	private
		$log = '',
		$logFile,
		$templateName,
		$wikiId,
		$app;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( 'csv', 'CSV file with data' );
		$this->addOption( 'list', 'Run script without adding data to database' );
		$this->addOption( 'section', 'Search template in given section (default is 0). Whole article can be parsed by setting value "all".' );
		$this->addOption( 'replaceTop', 'Replace template of the top of the page' );
		$this->addOption( 'add', "Add template as a flag.\n
							Accepted values:\n
							first (default) - first template with given name will be added\n
							all - all tempaltes with given name will be added");
		$this->addOption( 'remove', "Remove template from text.\n
							Accepted values:\n
							first (default) - first template with given name will be removed\n
							all - all tempaltes with given name will be removed");
		$this->addOption( 'replace', "Replace template by a tag.\n
							Accepted values:\n
							first (default) - first template with given name will be replaced\n
							all - all tempaltes with given name will be replaced");
		$this->addOption( 'tag', 'Tag to replace template. If not set, default __FLAGS__ tag will be used.');
	}

	public function execute() {
		global $wgCityId;

		$this->app = F::app();

		if ( empty ( $wgCityId ) ) {
			exit( "Wiki ID is not set\n" );
		}

		$this->wikiId = $wgCityId;

		$csv = $this->getOption( 'csv' );
		$list = $this->getOption( 'list' );

		if ( empty( $csv ) ) {
			$this->output( "You must attach CSV file.\n" );
			return;
		}

		if ( !file_exists( $csv ) ) {
			$this->output( "File $csv does not exist.\n" );
			return;
		}

		$logName = $this->prepareLogFile( $csv );
		$this->logFile = fopen( $logName, 'w+' );

		if ( !$this->logFile ) {
			$this->output( "Cannot create log file.\n" );
			return;
		}

		$options = $this->prepareScriptOption( $logName );

		$csvFile = fopen( $csv, 'r' );
		$csvData = [];
		$templateNames = [];

		if ( !$csvFile ) {
			$this->output( "Cannot read file: $csv" );
			return;
		}

		// Get data from scv file
		while( ( $data = fgetcsv( $csvFile ) ) !== false ) {
			$csvData[] = $data;
		}

		fclose( $csvFile );

		$this->output( "Start processing\n" );

		$flagTypeModel = new FlagType();

		fwrite($this->logFile, $this->log);

		foreach( $csvData as $data ) {
			$this->log = '';

			$error = $this->validateCSVData( $data );

			if ( $error ) {
				fwrite($this->logFile, $this->log);
				$this->output( $this->log );
				continue;
			}

			$templateNames[] = $this->templateName;

			if ( !$list ) {
				// Prepare data to add flag type
				$flagType = $this->prepareDataForFlagType( $flagTypeModel, $data );

				if ( !$this->getFlagTypeId( $flagType ) ) {
					if ( !$this->addFlagType( $flagType ) )  {
						$this->log = 'Cannot add a flag: ' . json_encode( $flagType ) . "\n";
						continue;
					} else {
						$this->log = 'Adding flag type: ' . json_encode( $flagType ) . "\n";
					}
				} else {
					$this->log = 'Flag already exists: ' . json_encode( $flagType ) . "\n";
				}
			}

			$this->log = "Processing template: $this->templateName completed \n";
			$this->addToLog( "================================================== \n\n\n" );

			fwrite( $this->logFile, $this->log );
			$this->output( $this->log );
		}

		fclose( $this->logFile );

		foreach( $templateNames as $template ) {
			$cmd = "SERVER_ID=$this->wikiId /usr/bin/php /usr/wikia/source/app/extensions/wikia/Flags/maintenance/MoveNotice.php --template='$template' $options";
			$this->output("Run cmd: $cmd\n");
			$output = wfShellExec( $cmd );

			$this->output( $output );
		}

		$this->output( "Processing completed\n" );
	}

	/**
	 * Add flag type
	 */
	private function addFlagType( $flagType ) {
		$response = $this->app->sendRequest( 'FlagsApiController',
			'addFlagType',
			$flagType
		)->getData();

		$flagTypeId = $response['data'];

		if ( $flagTypeId ) {
			$this->addToLog( "Flag ID: $flagTypeId added.\n" );
		} else {
			$this->addToLog( "[ERROR] Flag is not added!\n" );
			$this->addToLog( "================================================== \n\n\n" );
			fwrite( $this->logFile, $this->log );
			$this->output( $this->log );
		}

		return $flagTypeId;
	}

	private function getFlagTypeId( $flagType ) {
		$response = $this->app->sendRequest( 'FlagsApiController',
			'getFlagTypeIdByTemplate',
			$flagType
		)->getData();

		if ( $response['status'] && !empty( $response['data'] ) ) {
			return $response['data'];
		}

		return null;
	}

	private function prepareScriptOption( $logName ) {
		$options = '';

		$section = $this->getOption( 'section' );
		$list = $this->getOption( 'list' );
		$replaceTop = $this->getOption( 'replaceTop' );

		$add = $this->getOption( 'add' );
		$remove = $this->getOption( 'remove' );
		$replace = $this->getOption( 'replace' );

		$tag = $this->getOption( 'tag' );

		if ( $section ) {
			$options .= " --section=$section";
		}

		if ( $list ) {
			$options .= " --list";
		}

		if ( $replaceTop ) {
			$options .= " --replaceTop";
		}

		if ( $add ) {
			$options .= ( $add === self::SECTION_ALL ) ? " --add=all" : " --add";
		}

		if ( $remove ) {
			$options .= ( $remove === self::SECTION_ALL ) ? " --remove=all" : " --remove";
		}

		if ( $replace ) {
			$options .= ( $replace === self::SECTION_ALL ) ? " --replace=all" : " --replace";
		}

		if ( $tag ) {
			$options .= " --tag=$tag";
		}

		if ( $logName ) {
			$options .= " --logFile='$logName'";
		}

		return $options;
	}

	/**
	 * Add text to log
	 */
	private function addToLog( $text ) {
		$this->log .= $text;
	}

	/**
	 * Prepare data to add flag type
	 */
	private function prepareDataForFlagType( FlagType $flagTypeModel, $data ) {
		if ( !empty( $data[4] ) ) {
			$parameters = $this->prepareParametersFromCSV( $data[4] );
		} else {
			$parameters = null;
		}

		$flagType = [
			'wiki_id' => $this->wikiId,
			'flag_group' => $flagTypeModel->getFlagGroupId( $data[2] ),
			'flag_name' => $data[1],
			'flag_view' => $data[0],
			'flag_targeting' => $flagTypeModel->getFlagTargetingId( $data[3] ),
			'flag_params_names' => $parameters,
		];

		return $flagType;
	}

	/**
	 * Prepare log file
	 */
	private function prepareLogFile( $csv ) {
		$logName = substr( $csv, 0, strrpos( $csv, '.' ) );
		$logName .= '.log';

		return $logName;
	}

	/**
	 * Validate data from CSV file
	 */
	private function validateCSVData( $data ) {
		$error = false;

		if ( empty( $data[0] ) ) {
			$this->output( "[WARNING] Template name is not set.\n" );
			$this->addToLog( "[WARNING] Template name is not set.\n" );
			$error = true;
		}

		$this->templateName = $data[0];

		if ( empty( $data[1] ) ) {
			$this->output( "[WARNING] Template display name for template $$this->templateName is not set.\n" );
			$this->addToLog( "[WARNING] Template display name for template $$this->templateName is not set.\n" );
			$error = true;
		}

		if ( empty( $data[2] ) ) {
			$this->output( "[WARNING] Flag type for template $$this->templateName is not set.\n" );
			$this->addToLog( "[WARNING] Flag type for template $$this->templateName is not set.\n" );
			$error = true;
		}

		if ( empty( $data[3] ) ) {
			$this->output( "[WARNING] Flag targeting for template $$this->templateName is not set.\n" );
			$this->addToLog( "[WARNING] Flag targeting for template $$this->templateName is not set.\n" );
			$error = true;
		}

		return $error;
	}

	/**
	 * Get template parameters from csv file
	 */
	private function prepareParametersFromCSV( $csvParams ) {
		$params = [];

		if ($csvParams[0] == '|') {
			$csvParams = substr( $csvParams, 1 );
		}

		$csvParams = explode( '|', $csvParams );

		foreach ( $csvParams as $param ) {
			list( $paramName, $paramValue ) = explode( '=', $param, 2 );
			$params[$paramName] = $paramValue;
		}

		return json_encode( $params );
	}
}

$maintClass = 'MoveNotices';
require_once( RUN_MAINTENANCE_IF_MAIN );
