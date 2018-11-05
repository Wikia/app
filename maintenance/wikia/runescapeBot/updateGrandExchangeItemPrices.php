<?php

require_once( __DIR__ . '/../../Maintenance.php' );
require_once( __DIR__ . '/runescapeBot.setup.php' );

class UpdateGrandExchangeItemPrices extends Maintenance {

	const PAUSE_TIME_IN_SECONDS = 2.5;
	const BOT_USERNAME = "FandomBot";
	const LOG_MESSAGE_TEMPLATE = "RUNESCAPE_BOT -- %s";
	const MODULE_PREFIX = "Module:Exchange/";
	const TEMPLATE_PREFIX = "Template:";
	const DATA_SUFFIX = "/Data";
	const INDEX_PAGES = [
		"GE Common Trade Index",  "GE Discontinued Rare Index",  "GE Food Index",  "GE Herb Index",  "GE Log Index",
		"GE Metal Index", "GE Rune Index"
	];
	const GRAND_EXCHANGE_PRICES_PAGE = "Module:GEPrices/data";

	private $runescapeApi;
	private $pageFetcher;
	private $textUpdater;
	private $allPrices = [];
	private $botUser;

	// Runescape provides the trade count for the top 100 most traded items.
	// When updating the price for those items, we'll also update their trade count
	private $topItemsTradeCount = [];

	public function __construct() {
		parent::__construct();
		$this->runescapeApi = new RunescapeApi();
		$this->pageFetcher = new GrandExchangePageFetcher();
		$this->textUpdater = new RawTextUpdater();
	}

	/**
	 * @throws Exception
	 */
	public function execute() {
		$this->botUser = User::newFromName( self::BOT_USERNAME );
		$this->topItemsTradeCount = $this->runescapeApi->getTopItems();

		$pages = $this->pageFetcher->fetchAllGrandExchangePages();
		foreach ( $pages as $page) {
			try {
				$this->updatePricePagesForArticle( $page );
			} catch	( Exception $e ) {
				$this->logError( $e->getMessage(), [ 'page' => $page ] );
			} finally {
				$this->pauseExecutionMomentarily();
			}
		}

		$this->updatePricesPage();
		$this->updateIndexPages();
	}

	/**
	 * @param $pageTitle
	 * @throws MWException
	 * @throws Exception
	 */
	private function updatePricePagesForArticle( $pageTitle ) {
		$modulePage = $this->getWikiPageForTitle( $this->getModulePageTitle( $pageTitle ) );
		$dataPage = $this->getWikiPageForTitle( $this->getDataPageTitle( $pageTitle ) );
		$itemId = $this->getItemId( $modulePage->getRawText() );
		$grandExchangeItem = $this->runescapeApi->getItemId( $itemId );

		$this->updateModulePage( $modulePage, $grandExchangeItem );
		$this->updateDataPage( $dataPage, $grandExchangeItem );

		$this->appendPriceToAllPricesArray( $pageTitle, $grandExchangeItem->getPrice() );
	}

	private function getModulePageTitle( $pageTitle ) {
		return self::MODULE_PREFIX . $pageTitle;
	}

	private function getDataPageTitle( $pageTitle ) {
		return self::MODULE_PREFIX . $pageTitle . self::DATA_SUFFIX;
	}

	/**
	 * @param WikiPage $modulePage
	 * @param GrandExchangeItem $grandExchangeItem
	 * @throws MWException
	 * @throws Exception
	 */
	private function updateModulePage( WikiPage $modulePage, GrandExchangeItem $grandExchangeItem ) {
		$newText = $this->textUpdater->updateModuleText(
			$modulePage->getRawText(),
			$grandExchangeItem,
			$this->topItemsTradeCount[$grandExchangeItem->getId()] ?? null
		);
		$this->updatePageLoggingResult( $modulePage, $newText, "Updating price" );
	}

	/**
	 * @param WikiPage $dataPage
	 * @param GrandExchangeItem $grandExchangeItem
	 * @throws MWException
	 */
	private function updateDataPage( WikiPage $dataPage, GrandExchangeItem $grandExchangeItem ) {
		$newText = $this->textUpdater->updateDataText(
			$dataPage->getRawText(),
			$grandExchangeItem,
			$this->topItemsTradeCount[$grandExchangeItem->getId()] ?? null
		);
		$this->updatePageLoggingResult( $dataPage, $newText, "Updating price data" );
	}

	/**
	 * @throws MWException
	 */
	private function updatePricesPage() {
		$this->appendPriceToAllPricesArray( self::BOT_USERNAME, $this->getTimeStampForRuneScape() );
		$joinedPrices = implode ( ",\n", $this->allPrices );
		$updateString = sprintf("return {\n%s\n}", $joinedPrices);
		$pricesDataPage = $this->getWikiPageForTitle( self::GRAND_EXCHANGE_PRICES_PAGE );

		$this->updatePageLoggingResult( $pricesDataPage, $updateString, "updating all prices" );
	}

	/**
	 * @throws MWException
	 */
	private function updateIndexPages() {
		foreach( self::INDEX_PAGES as $indexPage ) {
			$this->purgePage( $indexPage );
			$indexValue = $this->getIndexValuFromTemplatePage( $indexPage );
			$timeStamp = $this->getTimeStampForRuneScape();
			$indexDataPage = $this->getWikiPageForTitle( $this->getDataTitleForIndexPage( $indexPage ) );
			$item = new GrandExchangeItem( $timeStamp, $indexValue, -1 );
			$this->updateDataPage( $indexDataPage, $item );
		}
	}

	/**
	 * @param $pageTitle
	 * @throws MWException
	 */
	private function purgePage( $pageTitle ) {
		$this->getWikiPageForTitle( $pageTitle )->doPurge();
	}

	/**
	 * @param $page
	 * @return mixed
	 * @throws MWException
	 */
	private function getIndexValuFromTemplatePage( $page ) {
		$templatePage = $this->getWikiPageForTitle( $this->getTemplateTitle( $page ) );
		return $this->extractIndexFromParsedContent( $templatePage );
	}

	private function getTemplateTitle( $pageTitle ) {
		return self::TEMPLATE_PREFIX . $pageTitle;
	}

	private function extractIndexFromParsedContent( WikiPage $wikiPage ) {
		$parsedContent = $wikiPage->getParserOutput( $wikiPage->makeParserOptions( $this->botUser ) )->mText;
		$matches = [];
		preg_match( "/^([\d\.]+)/", $parsedContent, $matches );
		return $matches[1];
	}

	private function getTimeStampForRuneScape() {
		try {
			return $this->runescapeApi->getItemId( $this->getFirstItemIdFromTop100Items() )->getTimeStamp();
		} catch (Exception $e) {
			$this->logError( "unable to fetch timestamp from runescape, using default", null );
			return time();
		}
	}

	private function getDataTitleForIndexPage( $indexPage ) {
		return self::MODULE_PREFIX . preg_replace( "/^GE /", "", $indexPage ) . self::DATA_SUFFIX;
	}

	private function getFirstItemIdFromTop100Items() {
		return array_keys( $this->topItemsTradeCount )[0];
	}

	/**
	 * @param $pageTitle
	 * @return WikiPage
	 * @throws MWException
	 */
	private function getWikiPageForTitle( $pageTitle ) {
		return new WikiPage( Title::newFromText( $pageTitle ) );
	}

	/**
	 * @param $rawText
	 * @return mixed
	 * @throws Exception
	 */
	private function getItemId( $rawText ) {
		$matches = [];
		preg_match( "/itemId\s*= (\d+)/", $rawText, $matches );
		if ( count( $matches ) !== 2 ) {
			throw new Exception( "Unable to parse id from wikipage" );
		}

		return $matches[1];
	}

	private function appendPriceToAllPricesArray(string $pageTitle, string $price ) {
		$this->allPrices[] = $this->formatAllPricesString( $pageTitle, $price );
	}

	private function formatAllPricesString(  string $pageTitle, string $price  ) {
		$normalizedTitle = str_replace( "_", " ", str_replace( "'", "\\'", $pageTitle ) );
		return sprintf( "  ['%s'] = %s", $normalizedTitle, $price );
	}

	private function updatePageLoggingResult( WikiPage $page, $pageText, $summary ) {
		$pageContext = [ "page" => $page->getTitle()->getPrefixedDBkey() ];
		try {
			$result = $page->doEdit( $pageText, $summary, EDIT_FORCE_BOT, false, $this->botUser );
			if ( $result->isGood() )  {
				$this->logInfo( "successfully updated page", $pageContext );
			} else {
				$this->logError( "unable to update page", $pageContext );
			}
		} catch ( MWException $e ) {
			$errorContext = [ "exception" => $e ];
			$this->logError( "error updating page", array_merge( $pageContext, $errorContext ) );
		}
	}

	private function logError( string $errorMessage,  $context = [] ) {
		$message = sprintf( self::LOG_MESSAGE_TEMPLATE, $errorMessage );
		$this->output( $message . ": " . $context['page'] . "\n" );
		Wikia\Logger\WikiaLogger::instance()->warning(
			$message,
			$context
		);
	}

	private function logInfo( $infoMessage, $context = [] ) {
		$message = sprintf( self::LOG_MESSAGE_TEMPLATE, $infoMessage );
		$this->output( $message . ": " . $context['page'] . "\n" );
		Wikia\Logger\WikiaLogger::instance()->info(
			$message,
			$context
		);
	}

	/**
	 * We're hitting runescape's API for every page we're updating. Rate limit ourselves to be nice about it.
	 */
	private function pauseExecutionMomentarily() {
		sleep( self::PAUSE_TIME_IN_SECONDS );
	}
}


$maintClass = 'UpdateGrandExchangeItemPrices';
require_once RUN_MAINTENANCE_IF_MAIN;
