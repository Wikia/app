<?php

$dir = dirname( __FILE__ ) . "/../../../../";
$extDir = __DIR__ . "/../";

require_once( $dir . 'includes/wikia/nirvana/WikiaObject.class.php' );
require_once( $dir . 'includes/wikia/nirvana/WikiaModel.class.php' );
require_once( $extDir . 'models/FlagsBaseModel.class.php' );
require_once( $extDir . 'models/Flag.class.php' );
require_once( $extDir . 'models/FlagType.class.php' );
require_once( $dir . 'maintenance/Maintenance.php' );

use Flags\Models\Flag;
use Flags\Models\FlagType;

class MoveNotices extends Maintenance {

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

		// Prepare log file
		$logName = substr( $csv, 0, strrpos( $csv, '.' ) );
		$logName .= '.log';

		$csvFile = fopen( $csv, 'r' );
		$logFile = fopen( $logName, 'w+' );

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

		$flag = new Flag();
		$flagTypes = new FlagType();

		foreach( $csvData as $data ) {
			$log = '';
			$error = false;
			$flagId = null;

			if ( empty( $data[0] ) ) {
				$this->output( "[WARNING] Template name is not set.\n" );
				$log .= "[WARNING] Template name is not set.\n";
				$error = true;
			}

			$templateName = $data[0];

			if ( empty( $data[1] ) ) {
				$this->output( "[WARNING] Template display name for template $templateName is not set.\n" );
				$log .= "[WARNING] Template name is not set.\n";
				$error = true;
			}

			if ( empty( $data[2] ) ) {
				$this->output( "[WARNING] Flag type for template $templateName is not set.\n" );
				$log .= "[WARNING] Template name for template $templateName is not set.\n";
				$error = true;
			}

			if ( empty( $data[3] ) ) {
				$this->output( "[WARNING] Flag targeting for template $templateName is not set.\n" );
				$log .= "[WARNING] Template name for template $templateName is not set.\n";
				$error = true;
			}

			if ( $error ) {
				fwrite($logFile, $log);
				$this->output( $log );
				continue;
			}

			$templateDisplayName = $data[1];
			$flagGroup = $flagTypes->getFlagGroupId( $data[2] );
			$flagTargeting = $flagTypes->getFlagTargetingId( $data[3] );

			if ( !empty( $data[4] ) ) {
				$parameters = $this->prepareParametersFromCSV( $data[4] );
			} else {
				$parameters = null;
			}

			// Prepare data to add flag type
			$flagType = [
				'wikiId' => $wgCityId,
				'flagGroup' => $flagGroup,
				'flagName' => $templateDisplayName,
				'flagView' => $templateName,
				'flagTargeting' => $flagTargeting,
				'flagParamsNames' => $parameters
			];

			$log = "Adding flag type: " . json_encode( $flagType ) ."\n";

			if ( !$list ) {
				$flagTypes->verifyParamsForAdd( $flagType );
				$flagId = $flagTypes->addFlagType( $flagType );

				if ( $flagId ) {
					$log .= "Flag ID: $flagId added.\n";
				} else {
					$log .= "[ERROR] Flag is not added!\n";
					$log .= "================================================== \n\n\n";
					fwrite( $logFile, $log );
					$this->output( $log );
					continue;
				}
			}

			$log .= "Start processing template: $templateName \n";

			$title = Title::newFromText('Template:' . $templateName);

			$rows = $this->showIndirectLinks( 0, $title, 0 );

			if ( empty( $rows ) ) {
				$log .= "[WARNING] This template is not used \n";
				$log .= "================================================== \n\n\n";
				fwrite( $logFile, $log );
				$this->output( $log );
				continue;
			}

			if ( !is_null( $section )  ) {
				$log .= "Searching in section $section\n";
			} else {
				$log .= "Searching in all article content\n";
			}

			fwrite( $logFile, $log );
			$this->output( $log );

			foreach ( $rows as $row ) {
				$log = '';

				$page = Title::makeTitle( $row->page_namespace, $row->page_title );
				$pageName = $page->getPrefixedText();
				$article = Article::newFromID( $row->page_id );
				$content = $article->getContent();

				if ( !is_null( $section )  ) {
					$content = $wgParser->getSection($content, $section);
				}

				$log .= "Looking for template on $pageName [" . $row->page_id . "]\n";

				$flagsToPages = [
					'wikiId' => $wgCityId,
					'pageId' => $row->page_id
				];

				$templates = $this->findTemplates( $content, $templateName );
				$size = sizeof( $templates );

				if ( !$size ) {
					$log .= "[WARNING] No templates found on page $pageName\n";
				} elseif ( $size > 1 ) {
					$log .= "[WARNING] Found more than one ($size) template $templateName on page $pageName\n";
				}

				foreach ( $templates as $template ) {
					$log .= "Processing template: " . $template['name'] ."\n";

					if (empty($template['params'])) {
						$log .= "No parameters found\n";
					} else {
						$log .= "Found parameters: \n";

						foreach( $template['params'] as $name => $value ) {
							$log .= "Parameter $name = $value \n";
						}
					}
				}

				if ( $size ) {
					$flagsToPages['flags'][] = [
						'flagTypeId' => $flagId,
						'params' => $templates[0]['params']
					];

					$log .= "Adding flags to pages: " . json_encode( $flagsToPages ) ."\n";

					if ( !$list ) {
						$flag->verifyParamsForAdd( $flagsToPages );
						$flag->addFlagsToPage( $flagsToPages );
					}
				}

				fwrite( $logFile, $log );
				$this->output( $log );
			}

			$log = "Processing template: $templateName completed \n";
			$log .= "================================================== \n\n\n";

			fwrite($logFile, $log);
			$this->output( $log );
		}

		fclose( $logFile );

		$this->output( "Processing completed\n" );
	}

	public function findTemplates( $text, $templateName ) {
		$paramOffsetStart = null;
		$bracketsCounter = 2;
		$bracketsLinkCounter = 0;
		$inProgress = true;
		$hasParamName = false;
		$template = [];
		$templates = [];
		$params = [];
		$i = 1;

		$templateName = '{{' . $templateName;

		// Position of template begin
		$offsetStart = $this->findTemplatePosition( $text, $templateName, 0 );

		if ( $offsetStart !== false ) {
			$offset = $offsetStart + strlen( $templateName );
			$textLength = strlen( $text ) - 1;

			while( $inProgress && $offset <= $textLength ) {

				switch ( $text[$offset] ) {
					case '}' : $bracketsCounter--; break;
					case '{' : $bracketsCounter++; break;
					case ']' : $bracketsLinkCounter--; break;
					case '[' : $bracketsLinkCounter++; break;
					// Looking for template parameters - check if it's not link or nested template parameter
					case '|' : if ( $bracketsCounter == 2 && !$bracketsLinkCounter ) {
									// First parameter
									if ( is_null( $paramOffsetStart ) ) {
										$paramOffsetStart = $offset;
									// Next parameter
									} else {
										$param = substr( $text, $paramOffsetStart + 1, $offset - $paramOffsetStart - 1 );
										$params = $this->getTemplateParams( $param, $params, $hasParamName, $i );
										$i++;
										$paramOffsetStart = $offset;
										$hasParamName = false;
									}
								}
								break;
					// Check if param has name and it's not in link or nested template
					case '=' : if ( !is_null( $paramOffsetStart ) && $bracketsCounter == 2 && !$bracketsLinkCounter ) {
									$hasParamName = true;
								}
								break;
				}

				$offset++;

				// End of template
				if ( $bracketsCounter === 0 ) {
					$tmp = substr( $text, $offsetStart, $offset - $offsetStart );
					$template['name'] = $tmp;
					$offsetStart = $this->findTemplatePosition( $text, $templateName, $offset );

					// Check if there is last template parameter
					if ( !is_null( $paramOffsetStart ) ) {
						$param = substr( $text, $paramOffsetStart + 1, $offset - $paramOffsetStart - 3 );
						$params = $this->getTemplateParams( $param, $params, $hasParamName, $i );
						$i = 1;
						$paramOffsetStart = null;
						$hasParamName = false;
					}

					$template['params'] = $params;

					$templates[] = $template;

					// If there is more same templates in content
					if ( $offsetStart !== false ) {
						$bracketsCounter = 2;
						$offset = $offsetStart + strlen( $templateName ) - 1;
						$template = [];
						$params = [];
					} else {
						$inProgress = false;
					}
				}
			}
		}

		return $templates;
	}

	/**
	 * Check if template is wrapped by <nowiki> tag
	 */
	public function isWrappedByNoWikiTag( $text, $offset ) {
		while( $offset > 0 && $text[--$offset] == ' ' ) {};
		if ( $offset >= 7 ) {
			$offset -= 7;

			$tag = substr( $text, $offset, 8 );

			if ( strcasecmp( $tag, '<nowiki>' ) == 0 ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Find template position in text
	 */
	public function findTemplatePosition( $text, $templateName, $offset ) {
		while ( ( $offsetStart = stripos($text, $templateName, $offset) ) !== false ) {
			$offset = $offsetStart + strlen($templateName);
			if ( !$this->isWrappedByNoWikiTag( $text, $offsetStart ) ) {
				if ( $text[$offset] == '}' || $text[$offset] == '|' ) {
					return $offsetStart;
				}
			}
		}
		return false;
	}

	/**
	 * Get template from params
	 */
	public function getTemplateParams( $param, $params, $hasParamName, $i) {
		if ($hasParamName) {
			list($paramName, $paramValue) = explode('=', $param, 2);
			$paramName = trim($paramName);
			$paramValue = trim($paramValue);
			$params[$paramName] = $paramValue;
		} else {
			$params[$i] = $param;
		}

		return $params;
	}

	/**
	 * Get template parameters from csv file
	 */
	public function prepareParametersFromCSV( $csvParams ) {
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
