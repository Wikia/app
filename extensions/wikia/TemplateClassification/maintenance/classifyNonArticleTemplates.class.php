<?php

$mainDir = __DIR__ . "/../../../..";
require_once( $mainDir . '/maintenance/Maintenance.php' );

class ClassifyNonArticleTemplates extends Maintenance {

	const NONARTICLE_MAINTENANCE_PROVIDER = 'maintenance';
	const NONARTICLE_MAINTENANCE_ORIGIN = 1; // Since it's the first script of this type

	private $dryRun, $quiet, $logFile;

	public function __construct() {
		parent::__construct();

		$this->addOption( 'dry-run', 'Set if you just want to count first-level and nested templates.' );
		$this->addOption( 'quiet', 'Set if you do not want to output any logs.' );
		$this->addOption( 'log-file', 'If you need logs in a .csv format provide a path to an existing file.', false, true );
	}

	public function execute() {
		global $wgCityId, $wgDBname, $wgContentNamespaces;

		$this->dryRun = $this->getOption( 'dry-run' );
		$this->quiet = $this->getOption( 'quiet' );
		$this->logFile = $this->getOption( 'log-file' );

		if ( isset( $this->logFile ) && !$this->verifyLogFile() ) {
			$this->out( "The log file {$this->logFile} does not exist, please create it." );
			return false;
		}

		$this->setDB( wfGetDB( DB_SLAVE ) );
		$tcs = new TemplateClassificationService();
		$firstLevelTemplates = $nestedTemplates = [];

		$namespacesTemplates = ( new \WikiaSQL() )
			->SELECT( 'pt.page_title as template_title, pt.page_id as template_id, p.page_id as page_id' )
			->FROM( 'templatelinks' )->AS_( 'tl' )
			->INNER_JOIN( 'page' )->AS_( 'pt' )
			->ON( 'tl.tl_title', 'pt.page_title' )
			->INNER_JOIN( 'page' )->AS_( 'p' )
			->ON( 'tl.tl_from', 'p.page_id' )
			->WHERE( 'tl.tl_namespace' )->EQUAL_TO( NS_TEMPLATE )
			->AND_( 'pt.page_namespace' )->EQUAL_TO( NS_TEMPLATE )
			->AND_( 'p.page_namespace' )->IN( $wgContentNamespaces )
			->runLoop( $this->getDB(), function ( &$pages, $row ) {
				if ( !isset( $pages[$row->template_id]['title'] ) ) {
					// First run for this template ID
					$pages[$row->template_id]['title'] = $row->template_title;
					$pages[$row->template_id]['linkingPages'] = [];
				}

				$pages[$row->template_id]['linkingPages'][] = (int)$row->page_id;
			} );

		foreach ( $namespacesTemplates as $templateId => $data ) {
			$templateTitle = $data['title'];
			$linkingPages = $data['linkingPages'];
			$count = count( $linkingPages );

			$this->out( "\nProcessing {$count} inclusions of template {$templateTitle} ({$templateId})" );
			$isFirstLevel = false;

			foreach ( $linkingPages as $pageId ) {
				$pageRawTextLc = strtolower( WikiPage::newFromID( $pageId )->getRawText() );
				$templateTitleLc = strtolower( $templateTitle );
				if ( strpos( $pageRawTextLc, "{{{$templateTitleLc}" ) > -1 ) {
					$firstLevelTemplates[] = $templateId;
					$isFirstLevel = true;
					break;
				}
			}

			if ( $isFirstLevel ) {
				$this->out( "{$templateTitle} - First level inclusion found in {$pageId}!" );
			} else {
				$this->out( "{$templateTitle} is just a nested template! Classify it!" );
				if ( !$this->dryRun ) {
					try {
						$tcs->classifyTemplate(
							$wgCityId,
							$templateId,
							TemplateClassificationService::TEMPLATE_NOT_ART,
							self::NONARTICLE_MAINTENANCE_PROVIDER,
							self::NONARTICLE_MAINTENANCE_ORIGIN
						);
					} catch ( \Swagger\Client\ApiException $e ) {
						$this->out( 'Classification failed!' );
					}
				}
			}
		}

		$countContentNsTemplates = count( $namespacesTemplates );
		$countFirstLevelTemplates = count( $firstLevelTemplates );
		$results = [
			'wiki_id' => $wgCityId,
			'dbname' => $wgDBname,
			'Templates in content NS' => $countContentNsTemplates,
			'First-level templates' => $countFirstLevelTemplates,
			'Nested templates' => $countContentNsTemplates - $countFirstLevelTemplates,
		];

		$this->out( "\nResults: " . json_encode( $results ) );
		$this->logResults( $results );
	}

	private function out( $s ) {
		if ( !$this->quiet ) {
			$this->output( "$s\n" );
		}
	}

	private function logResults( array $results ) {
		if ( isset( $this->logFile ) ) {
			$data = implode( ',', array_values( $results ) );
			file_put_contents( $this->logFile, $data, FILE_APPEND );
		}
	}

	private function verifyLogFile() {
		return file_exists( $this->logFile );
	}
}

$maintClass = 'ClassifyNonArticleTemplates';
require_once( RUN_MAINTENANCE_IF_MAIN );
