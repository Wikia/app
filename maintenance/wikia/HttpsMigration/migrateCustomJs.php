<?php

/**
 * Maintenance script to migrate image urls included in custom JS files to https/protocol relative
 * @usage
 *  # this will migrate assets for wiki with ID 119:
 *  run_maintenance --script='wikia/HttpsMigration/migrateCustomJs.php  --saveChanges' --id=119
 *  # running on some wikis in dry mode and dumping url changes to a csv file:
 *  run_maintenance --script='wikia/HttpsMigration/migrateCustomJs.php --file migrate_js.csv' --where='city_id < 10000'
 *
 */

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_ALL ^ E_NOTICE );

require_once __DIR__ . '/../../Maintenance.php';

use \Wikia\Logger\WikiaLogger;

/**
 * Class MigrateCustomCJsToHttps
 */
class MigrateCustomJsToHttps extends Maintenance {

	protected $saveChanges = false;
	protected $processNonVignette = false;
	protected $fh; // handle to the output csv file
	private $contentReview;
	private $currentLine;

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Migrates image urls in custom JS assets to HTTPS';
		$this->addOption( 'saveChanges', 'Edit articles for real.', false, false, 'd' );
		$this->addOption( 'file', 'CSV file where to save values that are going to be altered', false, true, 'f' );
		$this->addOption( 'process-non-vignette', 'Process local URLs and other non-Fandom image URLs.', false, false, 'i' );
	}

	public function __destruct()  {
		if ( $this->fh ) {
			fclose( $this->fh );
		}
	}

	/**
	 * Logs urls value change if the new value is different than the old one.
	 */
	public function logUrlChange( $description, $oldValue, $newValue ) {
		global $wgCityId;
		if ( $oldValue !== $newValue ) {
			if ( $this->fh ) {
				fputcsv( $this->fh,
					[ $wgCityId, $this->currentTitle->getDBkey(), $description, $oldValue, $newValue, $this->currentLine ] );
			}
		}
	}

	/**
	 * Returns css file edit summary
	 */
	private function getEditSummary() {
		return "Applying changes that should make this JS file partially HTTPS-ready. If you have any questions or noticed " .
			"issues related to this edit, please reach out to us using the [[Special:Contact]] page.";
	}

	private function isHttpUrl( $url ) {
		return startsWith( $url, 'http://' );
	}

	private function isHttpsUrl( $url ) {
		return startsWith( $url, 'https://' );
	}

	private function isProtocolRelativeUrl( $url ) {
		return startsWith( $url, '//' );
	}

	/**
	 * True if the url doesn't contain the host part.
	 */
	private function isLocalUrl( $url ) {
		if ( $this->isHttpUrl( $url ) ||
			$this->isHttpsUrl( $url ) ||
			$this->isProtocolRelativeUrl( $url ) ) {
			return false;
		}
		return true;
	}

	private function isWikiaComSubdomainUrl( $url ) {
		$host = parse_url( $url, PHP_URL_HOST );
		if ( empty( $host ) ) {
			return false;
		}
		return endsWith( $host, '.wikia.com' );
	}

	/**
	 * True the the url points outside of our wikia.com and vignette domain.
	 */
	private function isThirdPartyUrl( $url ) {
		$host = parse_url( $url, PHP_URL_HOST );
		if ( empty( $host ) ) {
			return false;
		}
		return !endsWith( $host, '.wikia.com' ) && !endsWith( $host, '.wikia.nocookie.net' );
	}

	/**
	 * Returns true if the url points to one of many variations of our image domains.
	 * Handles a lot of historical formats that are not used anymore.
	 */
	private function isWikiaImageUrl( $url ) {
		$host = parse_url( $url, PHP_URL_HOST );
		if ( empty( $host ) ) {
			return false;
		}
		return ( preg_match( '/^(www\.)?(vignette|images|image|img|static|slot)\d*\.wikia\.nocookie\.net$/', $host ) ||
			preg_match( '/^(www\.)?slot\d*[\.-]images\.wikia\.nocookie\.net$/', $host ) ||
			$host === 'images.wikia.com' ||
			$host === 'static.wikia.com' );
	}

	/**
	 * Replaces http protocl with https. Protocol-relative urls are not affected.
	 */
	private function upgradeToHttps( $url ) {
		if ( $this->isHttpUrl( $url ) ) {
			$result = http_build_url( $url, [ 'scheme' => 'https' ] );
			if ( FALSE !== $result ) {
				return $result;
			}
		}
		return $url;
	}

	private function forceWikiaImageOverHttps( $url ) {
		$host = parse_url( $url, PHP_URL_HOST );

		if ( empty( $host ) ) {
			return $url;
		}

		$domain = ( strpos( $host, 'vignette' ) !== FALSE ) ?  'vignette.wikia.nocookie.net' : 'images.wikia.nocookie.net';

		$result = http_build_url( $url, [ 'scheme' => 'https', 'host' => $domain ] );
		if ( FALSE === $result ) {
			return $url;
		}
		return $result;
	}

	private $currentHost = null;

	/**
	 * Removes the host part of the url leaving only the path.
	 */
	private function stripProtocolAndHost( $url ) {
		$parsedUrl = parse_url( $url );
		if ( $parsedUrl === FALSE ) {
			return $url;
		}
		return $parsedUrl[ 'path' ] .
			( ( isset( $parsedUrl[ 'query' ] ) ) ? '?' . $parsedUrl[ 'query' ] : '' ) .
			( ( isset( $parsedUrl[ 'fragment' ] ) ) ? '#' . $parsedUrl[ 'fragment' ] : '' );
	}

	/**
	 * For host that we know for sure that support https, upgrade the url to use it.
	 */
	private function upgradeThirdPartyUrl( $url ) {
		$knownHttpsHosts = [ 'en.wikipedia.org', 'i.imgur.com', 'upload.wikimedia.org', 'fonts.googleapis.com',
			'commons.wikimedia.org' ];
		$host = parse_url( $url, PHP_URL_HOST );
		if ( in_array( $host, $knownHttpsHosts ) ) {
			$newUrl = $this->upgradeToHttps( $url );
			$this->logUrlChange( 'Upgraded third party url', $url, $newUrl );
			$url = $newUrl;
		} else {
			//$this->output( "Found unrecognized third party http url {$url}\n" );
		}
		return $url;
	}

	/**
	 * Try to make a single url https-ready
	 */
	public function fixUrl( $originalUrl ) {
		$url = $originalUrl;

		if ( $this->isLocalUrl( $url ) ) {
			//$this->output( "Skipping local link {$url}\n" );
		} elseif ( $this->isThirdPartyUrl( $url ) ) {
			if ( $this->isHttpUrl( $url ) && $this->processNonVignette ) {
				$url = $this->upgradeThirdPartyUrl( $url );
			}
		} elseif ( $this->isWikiaImageUrl( $url ) ) {
			if ( !$this->processNonVignette ) {
				$url = $this->forceWikiaImageOverHttps( $url );
				$this->logUrlChange( 'Replaced vignette url', $originalUrl, $url );
			}
		} elseif ( $this->isWikiaComSubdomainUrl( $url ) ) {
			if ( $this->isHttpUrl( $url ) && $this->processNonVignette ) {
				$url = wfProtocolUrlToRelative( $url );
				$this->logUrlChange( 'Converted wiki url to protocol/host relative', $originalUrl, $url );
			}
		} else {
			$this->output( "Don't know to handle {$url}\n" );
		}
		return $url;
	}

	/**
	 * @param $matches - regex match array, $matches[1] contain the protocol and domain
	 * @return updated url address match
	 */
	public function makeUrlHttpsComatible( $matches ) {
		$this->output( "Updating '{$matches[1]}' used in {$matches[0]}\n" );
		$domain = $this->fixUrl( $matches[1] );
		if ( $domain != $matches[1] ) {
			$this->output( "Updating '{$matches[1]}' to {$domain}\n" );
			$matches[ 0 ] = str_replace( $matches[ 1 ], $domain, $matches[ 0 ] );
		}
		return $matches[ 0 ];
	}

	/**
	 * Process JS source code upgrading urls to https/protocol-relative.
	 * @param $text JS source code
	 * @return mixed Updated JS source code
	 */
	public function updateJSContent( $text ) {
		$lines = explode( "\n", $text );
		foreach ( $lines as $index => $line ) {
			$this->currentLine = $line;
			// Try to skip the most common comment patterns
			if ( !preg_match( '/^(\s*\*|\s*\/\/\s+)/', $line ) ) {
				$lines[$index] = preg_replace_callback( '/(https?:\/\/[a-zA-Z0-9\\.]+)/i', [ $this, 'makeUrlHttpsComatible' ], $line );
				// log urls that were not altered, most likely there will be a lot of those
				if ( strpos( $lines[$index], 'http://' ) !== false ) {
					$this->output( "Notice: http protocol used in \"{$lines[$index]}\"\n" );
				}
			}
		}

		$text = implode( "\n", $lines );
		return $text;
	}

	/**
	 * If possible, make the JS https-ready and save the updated content (if not running in dry mode)
	 */
	public function migrateJS( Title $title ) {
		global $wgCityId, $wgRequest;
		$revId = $title->getLatestRevID( Title::GAID_FOR_UPDATE );
		$this->currentTitle = $title;
		$revision = Revision::newFromId( $revId );
		if( !is_null( $revision ) ) {
			$text = $revision->getText();
			$updatedText = $this->updateJSContent( $text );
			if ($text !== $updatedText) {
				if ( $this->saveChanges ) {
					// pay attention to JS-review process. if the latest revision is the same as
					// the one returned from ContentReviewHelper's getReviewedRevisionId, just autoapprove
					// (which requires FANDOMBot to be added to the content review group.
					// autoapprove can be set by using wpApprove parameter.
					// if the current JS revision is not approved yet, do not autoapprove JS changes!
					$latestReviewedID = $this->contentReview->getReviewedRevisionId( $title->getArticleID(), $wgCityId );
					if ( !$this->processNonVignette && $revId === $latestReviewedID ) {
						$this->output( "Auto-approving change\n" );
						$wgRequest->setVal( 'wpApprove', '1' );
					}
					$article = new Article( $title );
					$editPage = new EditPage( $article );
					$editPage->summary = $this->getEditSummary();
					$editPage->textbox1 = $updatedText;
					$editPage->minoredit = true;
					$editPage->starttime = wfTimestampNow();
					$result = [];
					$status = $editPage->internalAttemptSave( $result, /* bot */ true );
					if ( $status->isGood() ) {
						$this->output( "Saved updated JS file\n" );
					} else {
						$this->error( "Failed to save JS file: {$status->value}!\n" );
					}
					$wgRequest->setVal( 'wpApprove', false );
				}
				return true;
			}
		}
		return false;
	}

	public function execute() {
		global $wgUser, $wgCityId, $wgUseSiteJs;

		// Skip any wiki that doesn't use JS
		if ( empty( $wgUseSiteJs ) ) {
			return;
		}

		$wgUser = User::newFromName( Wikia::BOT_USER ); // Make changes as FANDOMbot
		$this->contentReview = new Wikia\ContentReview\Helper();

		$this->saveChanges = $this->hasOption( 'saveChanges' );
		$this->processNonVignette = $this->hasOption( 'process-non-vignette' );
		$fileName = $this->getOption( 'file', false );
		if ( $fileName ) {
			$this->fh = fopen( $fileName, "a" );
			if ( !$this->fh ) {
				$this->error( "Could not open file '$fileName' for write!'\n" );
				return false;
			}
		}

		$this->output( "Running on city " . $wgCityId . "\n" );

		$this->db = wfGetDB( DB_SLAVE );

		$where = [ 'page_namespace' => NS_MEDIAWIKI,
			'page_is_redirect' => 0,
			'page_title ' . $this->db->buildLike( $this->db->anyString(), '.js' ) ];
		$options = [ 'ORDER BY' => 'page_title ASC' ];
		$result = $this->db->select( 'page', [ 'page_id', 'page_title', 'page_is_redirect' ], $where, __METHOD__, $options );
		$migratedFiles = 0;
		foreach( $result as $row ) {
			$title = Title::makeTitle( NS_MEDIAWIKI, $row->page_title );
			if ( $title->isJsPage() ) {
				$this->output( "Processing JS file {$row->page_title}...\n" );
				if ( $this->migrateJS( $title ) ) {
					$migratedFiles += 1;
				}
			}
		}
		$result->free();
		$this->output( "Migrated {$migratedFiles} JS files.\n" );
	}

}

$maintClass = "MigrateCustomJsToHttps";
require_once( RUN_MAINTENANCE_IF_MAIN );
