<?php

$dir = dirname( __FILE__ ) . "/../../../../";
require_once( $dir . 'maintenance/Maintenance.php' );

use Flags\FlagsExtractor;

class MoveNotice extends Maintenance {

	const
		SECTION_DEFAULT = 0,
		SECTION_ALL = 'all',
		EDIT_SUMMARY = 'Moving notices templates to our new Flags feature.',
		EDIT_USER = 'WikiaBot';

	private
		$log = '',
		$logFile = null,
		$templateName,
		$wikiId,
		$pageId,
		$pageName,
		$flagTypeId,
		$app;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( 'template', 'Template name' );
		$this->addOption( 'logFile', 'Log file name' );
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
		global $wgCityId, $wgParser, $wgUser;

		$this->app = F::app();

		if ( empty ( $wgCityId ) ) {
			exit( "Wiki ID is not set\n" );
		}

		$this->wikiId = $wgCityId;

		$section = $this->getOption( 'section' );
		$list = $this->getOption( 'list' );
		$replaceTop = $this->getOption( 'replaceTop' );
		$this->templateName = $this->getOption( 'template' );

		$tag = $this->getOption( 'tag', null );

		$actions = [];

		if ( !$list ) {
			$actions = $this->prepareActionOptions();
		}
		$actionsSum = array_sum( $actions );

		// get log file
		$this->openLogFile();

		if ( !$this->logFile ) {
			$this->output( "[WARNING] Log file is not set.\n" );
			exit();
		}

		if ( !$this->templateName ) {
			$this->addToLog( "[ERROR] Template name is not set.\n" );
			$this->writeToLog();
			$this->closeLogFile();
			exit();
		}

		$templateNames = $this->getTemplateNames();

		if ( empty( $templateNames ) ) {
			$this->addToLog( "[ERROR] Cannot find flags for this wiki [$this->wikiId].\n" );
			$this->writeToLog();
			$this->closeLogFile();
			exit();
		}

		$flagsExtractor = new FlagsExtractor();

		$this->log = '';
		$this->flagTypeId = $this->getFlagTypeId();

		if ( !$this->flagTypeId ) {
			$this->addToLog( "[ERROR] Cannot get flag type id.\n" );
			$this->writeToLog();
			$this->closeLogFile();
			exit();
		}

		$this->addToLog( "Start processing template: $this->templateName \n" );

		$title = Title::newFromText( 'Template:' . $this->templateName );

		$rows = $title->getIndirectLinks();

		if ( empty( $rows ) ) {
			$this->addToLog( "[WARNING] This template is not used \n" );
			$this->addToLog( "================================================== \n\n\n" );
			fwrite( $this->logFile, $this->log );
			$this->output( $this->log );
			exit();
		}

		if ( is_null( $section )  ) {
			$this->addToLog( "Searching in section " . self::SECTION_DEFAULT . " (by default)\n" );
			$section = self::SECTION_DEFAULT;
		} elseif ( $section == self::SECTION_ALL ) {
			$this->addToLog( "Searching in all article content\n" );
		} else {
			$this->addToLog( "Searching in section $section\n" );
		}

		$this->writeToLog();

		/**
		 * Perform all edits as WikiaBot
		 */
		$wgUser = User::newFromName( self::EDIT_USER );

		foreach ( $rows as $row ) {
			$this->log = '';
			$this->pageId = $row->page_id;

			$page = Title::makeTitle( $row->page_namespace, $row->page_title );
			$this->pageName = $page->getPrefixedText();
			$wiki = WikiPage::newFromID( $this->pageId );

			$content = $wiki->getText();
			$textToParse = $content;

			if ( $section !== self::SECTION_ALL ) {
				$textToParse = $wgParser->getSection( $content, $section );
			}

			if ( $replaceTop && !$list ) {
				$this->addToLog( "Looking for top template on $this->pageName [" . $this->pageId . "]\n" );

				if ( !$flagsExtractor->isTagAdded( FlagsExtractor::FLAGS_DEFAULT_TAG, $textToParse ) ) {
					$firstTemplate = $flagsExtractor->findFirstTemplateFromList( $templateNames, $textToParse );
					$this->addToLog( "First template on $this->pageName [" . $this->pageId . "] is $firstTemplate\n" );
					if ( !is_null( $firstTemplate ) && $this->templateName == $firstTemplate ) {
						$actions[] = FlagsExtractor::ACTION_REPLACE_FIRST_FLAG;
						$actionsSum = array_sum( $actions );
					}
				} else {
					$this->addToLog( "Tag is already added on $this->pageName [" . $this->pageId . "]\n" );
				}
			}

			$this->addToLog( "Looking for template on $this->pageName [" . $this->pageId . "]\n" );

			$actionParams = $this->prepareActionParams( $actionsSum, $tag );

			$flagsExtractor->init( $textToParse, $this->templateName, $actions, $actionParams );
			$templates = $flagsExtractor->getAllTemplates();

			if ( $actionsSum & (
					FlagsExtractor::ACTION_REPLACE_FIRST_FLAG
					| FlagsExtractor::ACTION_REPLACE_ALL_FLAGS
					| FlagsExtractor::ACTION_REMOVE_FIRST_FLAG
					| FlagsExtractor::ACTION_REMOVE_ALL_FLAGS
				) || $replaceTop

			) {
				$text = $flagsExtractor->getText();

				if ( $section !== self::SECTION_ALL  ) {
					$text = str_replace( $textToParse, $text, $content );
				}

				if ( strcmp( $content, $text ) !== 0 ) {
					$wiki->doEdit( $text, self::EDIT_SUMMARY );
				}
			}

			if ( $replaceTop && !$list ) {
				$actions = $this->prepareActionOptions();
				$actionsSum = array_sum( $actions );
			}

			$this->logTemplatesInfo( $templates, $actionsSum, $actionParams, $list );

			$this->writeToLog();
		}

		$this->log = "Processing template: $this->templateName completed \n";
		$this->addToLog( "================================================== \n\n\n" );

		$this->writeToLog();

		$this->closeLogFile();

		$this->output( "Processing completed\n" );
	}

	/**
	 * Add text to log
	 */
	private function addToLog( $text ) {
		if ( $this->logFile ) {
			$this->log .= $text;
		}
	}

	/**
	 * Save current log to log file
	 */
	private function writeToLog() {
		if ( $this->logFile ) {
			fwrite( $this->logFile, $this->log );
			$this->output( $this->log );
		}
	}

	/**
	 * Close log file
	 */
	private function closeLogFile() {
		if ( $this->logFile ) {
			fclose( $this->logFile );
		}
	}

	/**
	 * Log info about all found templates and actions
	 */
	private function logTemplatesInfo( $templates, $actionsSum, $actionParams, $list ) {
		$size = sizeof( $templates );

		if ( !$size ) {
			$this->addToLog( "[WARNING] No templates found on page $this->pageName\n" );
		} elseif ( $size > 1 ) {
			$this->addToLog( "[WARNING] Found more than one ($size) template $this->templateName on page $this->pageName\n" );
		}

		if ( $size ) {
			$listWarning = $list ? '[LIST] ' : '';

			foreach ( $templates as $key => $template ) {
				$this->addToLog( "Processing template: " . $template['template'] ."\n" );

				if ( empty( $template['params'] ) ) {
					$this->addToLog( "No parameters found\n" );
				} else {
					$this->addToLog( "Found parameters: \n" );

					foreach( $template['params'] as $name => $value ) {
						$this->addToLog( "Parameter $name = $value \n" );
					}
				}

				if ( ( $actionsSum & FlagsExtractor::ACTION_ADD_FIRST_FLAG && $key == 0 )
					|| $actionsSum & FlagsExtractor::ACTION_ADD_ALL_FLAGS
				) {
					$this->addToLog( "$listWarning Adding template as flag to page: " . json_encode( $actionParams ) ."\n" );
				}

				if ( $actionsSum & FlagsExtractor::ACTION_REMOVE_FIRST_FLAG && $key == 0
					|| $actionsSum & FlagsExtractor::ACTION_REMOVE_ALL_FLAGS
				) {
					$this->addToLog( "$listWarning Remove template from text on page: $this->pageName\n" );
				}

				if ( $actionsSum & FlagsExtractor::ACTION_REPLACE_FIRST_FLAG && $key == 0
					|| $actionsSum & FlagsExtractor::ACTION_REPLACE_ALL_FLAGS
				) {
					$tag = isset( $actionParams['replacementTag'] )
						? $actionParams['replacementTag']
						: FlagsExtractor::FLAGS_DEFAULT_TAG;
					$this->addToLog( "$listWarning Replace template by tag $tag on page: $this->pageName\n" );
				}
			}
		}
	}

	/**
	 * Get flag type id for given template (view) name
	 *
	 * @return null
	 */
	private function getFlagTypeId() {
		$response = $this->app->sendRequest( 'FlagsApiController',
			'getFlagTypeIdByTemplate',
			[
				'wiki_id' => $this->wikiId,
				'flag_view' => $this->templateName
			]
		)->getData();

		if ( $response['status'] && !empty( $response['data'] ) ) {
			return $response['data'];
		}

		return null;
	}

	/**
	 * Get all flag types for given wiki
	 *
	 * @return array
	 */
	private function getTemplateNames() {
		$templateNames = [];

		$response = $this->app->sendRequest( 'FlagsApiController',
			'getFlagTypes',
			[
				'wiki_id' => $this->wikiId
			]
		)->getData();

		if ( $response['status'] && !empty( $response['data'] ) ) {
			foreach ( $response['data'] as $flagType ) {
				$templateNames[] = $flagType['flag_view'];
			}
		}

		return $templateNames;
	}

	/**
	 * Prepare action parameters (add / replace / remove)
	 *
	 * @return array
	 */
	private function prepareActionOptions() {
		$actions = [];

		$add = $this->getOption( 'add' );
		$remove = $this->getOption( 'remove' );
		$replace = $this->getOption( 'replace' );

		if ( !empty( $add ) ) {
			if ( $add === 'all' ) {
				$actions[] = FlagsExtractor::ACTION_ADD_ALL_FLAGS;
			} else {
				$actions[] = FlagsExtractor::ACTION_ADD_FIRST_FLAG;
			}
		}

		if ( !empty( $remove ) ) {
			if ( $remove === 'all' ) {
				$actions[] = FlagsExtractor::ACTION_REMOVE_ALL_FLAGS;
			} else {
				$actions[] = FlagsExtractor::ACTION_REMOVE_FIRST_FLAG;
			}
		}

		if ( !empty( $replace ) ) {
			if ( $replace === 'all' ) {
				$actions[] = FlagsExtractor::ACTION_REPLACE_ALL_FLAGS;
			} else {
				$actions[] = FlagsExtractor::ACTION_REPLACE_FIRST_FLAG;
			}
		}

		return $actions;
	}

	/**
	 * Prepare parameters for given actions
	 *
	 * @param int $actionsSum sum of actions
	 * @param string $tag replacement tag
	 * @return array
	 */
	private function prepareActionParams( $actionsSum, $tag ) {
		$actionParams = [];

		if ( $actionsSum & ( FlagsExtractor::ACTION_ADD_FIRST_FLAG | FlagsExtractor::ACTION_ADD_ALL_FLAGS ) ) {
			$actionParams = [
				'wiki_id' => $this->wikiId,
				'page_id' => $this->pageId,
				'flag_type_id' => $this->flagTypeId
			];
		}

		if ( $actionsSum & ( FlagsExtractor::ACTION_REPLACE_FIRST_FLAG | FlagsExtractor::ACTION_REPLACE_ALL_FLAGS )
			&& !is_null( $tag )
		) {
			$actionParams['replacementTag'] = $tag;
		}

		return $actionParams;
	}

	/**
	 * Try to open log file
	 */
	private function openLogFile() {
		$logName = $this->getOption( 'logFile' );

		if ( !empty( $logName ) ) {
			$this->logFile = fopen( $logName, 'a' );
		}
	}
}

$maintClass = 'MoveNotice';
require_once( RUN_MAINTENANCE_IF_MAIN );
