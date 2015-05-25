<?php

$dir = dirname( __FILE__ ) . "/../../../../";
$extDir = __DIR__ . "/../";

require_once( $dir . 'includes/wikia/nirvana/WikiaObject.class.php' );
require_once( $dir . 'includes/wikia/nirvana/WikiaModel.class.php' );
require_once( $extDir . 'FlagsExtractor.class.php' );
require_once( $extDir . 'models/FlagsBaseModel.class.php' );
require_once( $extDir . 'models/Flag.class.php' );
require_once( $extDir . 'models/FlagType.class.php' );
require_once( $dir . 'maintenance/Maintenance.php' );

use Flags\FlagsExtractor;
use Flags\Models\Flag;
use Flags\Models\FlagType;

class MoveNotices extends Maintenance {

	private
		$log = '',
		$logFile,
		$templateName,
		$wikiId,
		$pageId,
		$flagId;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( 'csv', 'CSV file with data' );
		$this->addOption( 'list', 'Run script without adding data to database' );
		$this->addOption( 'section', 'Search template in given section. Otherwise all article is searched.' );
	}

	public function execute() {
		global $wgCityId, $wgParser;

		if ( empty ( $wgCityId ) ) {
			exit( "Wiki ID is not set\n" );
		}

		$this->wikiId = $wgCityId;

		$csv = $this->getOption( 'csv' );
		$section = $this->getOption( 'section' );
		$list = $this->getOption( 'list' );

		if ( empty( $csv ) ) {
			$this->output( "You must attach CSV file.\n" );
			return;
		}

		if ( !file_exists( $csv ) ) {
			$this->output( "File $csv does not exist.\n" );
			return;
		}

		$this->prepareLogFile( $csv );

		if ( !$this->logFile ) {
			$this->output( "Cannot create log file.\n" );
			return;
		}

		$csvFile = fopen( $csv, 'r' );
		$csvData = [];

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

		$flagModel = new Flag();
		$flagTypeModel = new FlagType();
		$flagsExtractor = new FlagsExtractor();

		foreach( $csvData as $data ) {
			$this->log = '';
			$flagId = null;

			$error = $this->validateCSVData( $data );

			if ( $error ) {
				fwrite($this->logFile, $this->log);
				$this->output( $this->log );
				continue;
			}

			$this->templateName = $data[0];

			if ( !$list ) {
				// Prepare data to add flag type
				$flagType = $this->prepareDataForFlagType( $flagTypeModel, $data );

				if ( !($this->flagId = $this->addFlagType( $flagTypeModel, $flagType ) ) ) {
					continue;
				}

				$this->log = "Adding flag type: " . json_encode( $flagType ) ."\n";
			}

			$this->log .= "Start processing template: $this->templateName \n";

			$title = Title::newFromText('Template:' . $this->templateName);

			$rows = $this->showIndirectLinks( 0, $title, 0 );

			if ( empty( $rows ) ) {
				$this->log .= "[WARNING] This template is not used \n";
				$this->log .= "================================================== \n\n\n";
				fwrite( $this->logFile, $this->log );
				$this->output( $this->log );
				continue;
			}

			if ( !is_null( $section )  ) {
				$this->log .= "Searching in section $section\n";
			} else {
				$this->log .= "Searching in all article content\n";
			}

			fwrite( $this->logFile, $this->log );
			$this->output( $this->log );

			foreach ( $rows as $row ) {
				$this->log = '';
				$this->pageId = $row->page_id;

				$page = Title::makeTitle( $row->page_namespace, $row->page_title );
				$pageName = $page->getPrefixedText();
				$article = Article::newFromID( $this->pageId );
				$content = $article->getContent();

				if ( !is_null( $section )  ) {
					$content = $wgParser->getSection($content, $section);
				}

				$this->log .= "Looking for template on $pageName [" . $this->pageId . "]\n";

				$flagsExtractor->init( $content, $this->templateName);
				$templates = $flagsExtractor->getAllTemplates();

				$size = sizeof( $templates );

				if ( !$size ) {
					$this->log .= "[WARNING] No templates found on page $pageName\n";
				} elseif ( $size > 1 ) {
					$this->log .= "[WARNING] Found more than one ($size) template $this->templateName on page $pageName\n";
				}

				if ( $size ) {
					$this->logTemplatesInfo( $templates );

					$flagsToPages = $this->prepareDataForFlagsToPage( $templates[0]['params'] );

					if ( !$list ) {
						$flagModel->verifyParamsForAdd( $flagsToPages );
						$flagModel->addFlagsToPage( $flagsToPages );

						$this->log .= "Adding flags to pages: " . json_encode( $flagsToPages ) ."\n";
					}
				}

				fwrite( $this->logFile, $this->log );
				$this->output( $this->log );
			}

			$this->log = "Processing template: $this->templateName completed \n";
			$this->log .= "================================================== \n\n\n";

			fwrite($this->logFile, $this->log);
			$this->output( $this->log );
		}

		fclose( $this->logFile );

		$this->output( "Processing completed\n" );
	}

	/**
	 * Add flag type
	 */
	private function addFlagType( FlagType $flagTypeModel, $flagType ) {
		$flagTypeModel->verifyParamsForAdd( $flagType );
		$flagId = $flagTypeModel->addFlagType( $flagType );

		if ( $flagId ) {
			$this->log .= "Flag ID: $flagId added.\n";
		} else {
			$this->log .= "[ERROR] Flag is not added!\n";
			$this->log .= "================================================== \n\n\n";
			fwrite( $this->logFile, $this->log );
			$this->output( $this->log );
		}

		return $flagId;
	}

	/**
	 * Log info about all found templates
	 */
	private function logTemplatesInfo( $templates ) {
		foreach ( $templates as $template ) {
			$this->log .= "Processing template: " . $template['template'] ."\n";

			if (empty($template['params'])) {
				$this->log .= "No parameters found\n";
			} else {
				$this->log .= "Found parameters: \n";

				foreach( $template['params'] as $name => $value ) {
					$this->log .= "Parameter $name = $value \n";
				}
			}
		}
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
			'flag_params_names' => $parameters
		];

		return $flagType;
	}

	/**
	 * Prepare data to add flags to page
	 */
	private function prepareDataForFlagsToPage( $params ) {
		$flagsToPages = [
			'wiki_id' => $this->wikiId,
			'page_id' => $this->pageId,
			'flags' => [
				[
					'flag_type_id' => $this->flagId,
					'params' => $params
				]
			]
		];

		return $flagsToPages;
	}

	/**
	 * Prepare log file
	 */
	private function prepareLogFile( $csv ) {
		$logName = substr( $csv, 0, strrpos( $csv, '.' ) );
		$logName .= '.log';

		$this->logFile = fopen( $logName, 'w+' );
	}

	/**
	 * Validate data from CSV file
	 */
	private function validateCSVData( $data ) {
		$error = false;

		if ( empty( $data[0] ) ) {
			$this->output( "[WARNING] Template name is not set.\n" );
			$this->log .= "[WARNING] Template name is not set.\n";
			$error = true;
		}

		$templateName = $data[0];

		if ( empty( $data[1] ) ) {
			$this->output( "[WARNING] Template display name for template $templateName is not set.\n" );
			$this->log .= "[WARNING] Template name is not set.\n";
			$error = true;
		}

		if ( empty( $data[2] ) ) {
			$this->output( "[WARNING] Flag type for template $templateName is not set.\n" );
			$this->log .= "[WARNING] Template name for template $templateName is not set.\n";
			$error = true;
		}

		if ( empty( $data[3] ) ) {
			$this->output( "[WARNING] Flag targeting for template $templateName is not set.\n" );
			$this->log .= "[WARNING] Template name for template $templateName is not set.\n";
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
			$csvParams = substr($csvParams, 1);
		}

		$csvParams = explode('|', $csvParams);

		foreach ($csvParams as $param) {
			list($paramName, $paramValue) = explode('=', $param, 2);
			$params[$paramName] = $paramValue;
		}

		return json_encode( $params );
	}

	/**
	 * Get list of pages with searched template
	 * Based on Special:Whatlinkshere showIndirectLinks method
	 */
	public function showIndirectLinks( $level, $target ) {
		global $wgContentNamespaces;

		$rows = [];

		$dbr = wfGetDB( DB_SLAVE );
		$options = [];

		$hidelinks = false;
		$hideredirs = false;
		$hidetrans = false;
		$hideimages = false; //$target->getNamespace() != NS_FILE;

		$fetchlinks = (!$hidelinks || !$hideredirs);

		// Make the query
		$plConds = array(
			'page_id=pl_from',
			'pl_namespace' => $target->getNamespace(),
			'pl_title' => $target->getDBkey(),
		);
		if( $hideredirs ) {
			$plConds['rd_from'] = null;
		} elseif( $hidelinks ) {
			$plConds[] = 'rd_from is NOT NULL';
		}

		$tlConds = array(
			'page_id=tl_from',
			'tl_namespace' => $target->getNamespace(),
			'tl_title' => $target->getDBkey(),
		);

		$ilConds = array(
			'page_id=il_from',
			'il_to' => $target->getDBkey(),
		);

		if ( is_array( $wgContentNamespaces ) && !empty( $wgContentNamespaces ) ) {
			$namespaces = implode( ',', $wgContentNamespaces );

			$plConds[] = 'page_namespace IN (' . $namespaces . ')';
			$tlConds[] = 'page_namespace IN (' . $namespaces . ')';
			$ilConds[] = 'page_namespace IN (' . $namespaces . ')';
		} elseif ( is_int( $wgContentNamespaces ) ) {
			$plConds['page_namespace'] = $wgContentNamespaces;
			$tlConds['page_namespace'] = $wgContentNamespaces;
			$ilConds['page_namespace'] = $wgContentNamespaces;
		}

		// Enforce join order, sometimes namespace selector may
		// trigger filesorts which are far less efficient than scanning many entries
		$options[] = 'STRAIGHT_JOIN';

		//$options['LIMIT'] = $queryLimit;
		$fields = array( 'page_id', 'page_namespace', 'page_title', 'rd_from' );

		$joinConds = array( 'redirect' => array( 'LEFT JOIN', array(
			'rd_from = page_id',
			'rd_namespace' => $target->getNamespace(),
			'rd_title' => $target->getDBkey(),
			'(rd_interwiki is NULL) or (rd_interwiki = \'\')'
		)));

		if( $fetchlinks ) {
			$options['ORDER BY'] = 'pl_from';
			$plRes = $dbr->select( array( 'pagelinks', 'page', 'redirect' ), $fields,
				$plConds, __METHOD__, $options,
				$joinConds);
		}

		if( !$hidetrans ) {
			$options['ORDER BY'] = 'tl_from';
			$tlRes = $dbr->select( array( 'templatelinks', 'page', 'redirect' ), $fields,
				$tlConds, __METHOD__, $options,
				$joinConds);
		}

		if( !$hideimages ) {
			$options['ORDER BY'] = 'il_from';
			$ilRes = $dbr->select( array( 'imagelinks', 'page', 'redirect' ), $fields,
				$ilConds, __METHOD__, $options,
				$joinConds);
		}

		// Read the rows into an array and remove duplicates
		// templatelinks comes second so that the templatelinks row overwrites the
		// pagelinks row, so we get (inclusion) rather than nothing
		if( $fetchlinks ) {
			foreach ( $plRes as $row ) {
				$row->is_template = 0;
				$row->is_image = 0;
				$rows[$row->page_id] = $row;
			}
		}
		if( !$hidetrans ) {
			foreach ( $tlRes as $row ) {
				$row->is_template = 1;
				$row->is_image = 0;
				$rows[$row->page_id] = $row;
			}
		}
		if( !$hideimages ) {
			foreach ( $ilRes as $row ) {
				$row->is_template = 0;
				$row->is_image = 1;
				$rows[$row->page_id] = $row;
			}
		}

		foreach ( $rows as $row ) {

			$nt = Title::makeTitle( $row->page_namespace, $row->page_title );

			if ( $row->rd_from && $level < 2 ) {
				$this->showIndirectLinks( $level + 1, $nt );

			}
		}

		return $rows;
	}

}

$maintClass = "MoveNotices";
require_once( RUN_MAINTENANCE_IF_MAIN );
