<?php

$mainDir = __DIR__ . "/../../../..";
require_once( $mainDir . '/maintenance/Maintenance.php' );

class ClassifyNonArticleTemplates extends Maintenance {

	const NONARTICLE_MAINTENANCE_PROVIDER = 'usage_classifier';

	private $dryRun, $quiet, $logFile, $wikiaLogger;

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

		$origin = date('Y-m-d');
		$this->setDB( wfGetDB( DB_SLAVE ) );
		$tcs = new TemplateClassificationService();

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

		$countFirstLevelTemplates = 0;
		foreach ( $namespacesTemplates as $templateId => $data ) {
			$templateTitle = $data['title'];
			$linkingPages = $data['linkingPages'];
			$count = count( $linkingPages );

			$this->out( "\nProcessing {$count} inclusions of template {$templateTitle} ({$templateId})" );
			$isFirstLevel = false;

			foreach ( $linkingPages as $pageId ) {
				$wikiPage = WikiPage::newFromID( $pageId );
				if ( !$wikiPage instanceof WikiPage ) {
					continue;
				}

				$pageRawTextLc = strtolower( $wikiPage->getRawText() );
				$templateTitleLc = strtolower( $templateTitle );
				$templateTitleLcSpaces = str_replace( '_', ' ', $templateTitleLc );
				if ( strpos( $pageRawTextLc, "{{{$templateTitleLcSpaces}" ) > -1
					|| strpos( $pageRawTextLc, "{{{$templateTitleLc}" ) > -1
				) {
					$countFirstLevelTemplates++;
					$isFirstLevel = true;
					break;
				}
			}

			if ( $isFirstLevel ) {
				$this->out( "{$templateTitle} - First level inclusion found in {$pageId}!" );
				$type = TemplateClassificationService::TEMPLATE_DIRECTLY_USED;
			} else {
				$this->out( "{$templateTitle} is just a nested template! Classify it as nonarticle!" );
				$type = TemplateClassificationService::TEMPLATE_NOT_ART;
			}

			if ( !$this->dryRun ) {
				try {
					$tcs->classifyTemplate(
						$wgCityId,
						$templateId,
						$type,
						$origin,
						self::NONARTICLE_MAINTENANCE_PROVIDER
					);
				} catch ( \Swagger\Client\ApiException $e ) {
					$this->out( 'Classification failed!' );
					$this->logException( $e, $wgCityId, $templateId );
				}
			}
		}

		$countContentNsTemplates = count( $namespacesTemplates );
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
			$data = implode( ',', $results );
			file_put_contents( $this->logFile, $data, FILE_APPEND );
		}
	}

	private function verifyLogFile() {
		return file_exists( $this->logFile );
	}

	private function logException( \Swagger\Client\ApiException $e, $wikiId, $templateId ) {
		if ( !isset( $this->wikiaLogger ) ) {
			$this->wikiaLogger = \Wikia\Logger\WikiaLogger::instance();
		}

		$this->wikiaLogger->error( 'TC_MAINTENANCE_SCRIPT_EXCEPTION', [
			'wikiId' => $wikiId,
			'templateId' => $templateId,
			'tcExcptBcktrc' => $e->getTrace(),
			'tcExcptRspnsHeaders' => $e->getResponseHeaders(),
			'tcExcptRspnsBody' => $e->getResponseBody(),
		] );
	}
}

$maintClass = 'ClassifyNonArticleTemplates';
require_once( RUN_MAINTENANCE_IF_MAIN );
