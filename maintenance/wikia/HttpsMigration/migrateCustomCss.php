<?php

/**
 * Maintenance script to migrate urls included in custom CSS files to https/protocol relative
 * @usage
 *  # this will migrate assets for wiki with ID 119:
 *  run_maintenance --script='wikia/HttpsMigration/migrateCustomCss.php  --saveChanges' --id=119
 *  # running on some wikis in dry mode and dumping url changes to a csv file:
 *  run_maintenance --script='wikia/HttpsMigration/migrateCustomCss.php --file migrate_css.csv' --where='city_id < 10000'
 *
 */

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_ALL ^ E_NOTICE );

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

use \Wikia\Logger\WikiaLogger;

/**
 * Class MigrateCustomCssToHttps
 */
class MigrateCustomCssToHttps extends Maintenance {

	protected $saveChanges  = false;
	protected $fh;	// handle to the output csv file

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Migrates urls in custom CSS assets to HTTPS';
		$this->addOption( 'saveChanges', 'Edit articles for real.', false, false, 'd' );
		$this->addOption( 'file', 'CSV file where to save values that are going to be altered', false, true, 'f' );
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
					[ $wgCityId, $this->currentTitle->getDBkey(), $description, $oldValue, $newValue ] );
			}
		}
	}

	/**
	 * Returns css file edit summary
	 */
	private function getEditSummary() {
		return "Applying changes that should make this CSS file HTTPS-ready. If you have any questions or noticed " .
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
	 * True if the url point to currently processed wiki.
	 */
	private function isCurrentWikiUrl( $url ) {
		global $wgServer;
		if ( !$this->currentHost ) {
			$this->currentHost = parse_url( $wgServer, PHP_URL_HOST );
		}
		return parse_url( $url, PHP_URL_HOST ) === $this->currentHost;
	}

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
	 * Fixes wiki urls according to our guidelines:
	 * - urls to current wiki should be local, without protocol or host
	 * - urls to other wiki should be protocol-relative.
	 */
	private function fixWikiUrl( $url ) {
		if ( $this->isCurrentWikiUrl( $url ) ) {
			$url = $this->stripProtocolAndHost( $url );
		} elseif ( $this->isWikiaComSubdomainUrl( $url ) && $this->isHttpUrl( $url ) ) {
			$url = wfProtocolUrlToRelative( $url );
		}
		return $url;
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
			if ( $this->isHttpUrl( $url ) ) {
				$url = $this->upgradeThirdPartyUrl( $url );
			}
		} elseif ( $this->isWikiaImageUrl( $url ) ) {
			$url = $this->forceWikiaImageOverHttps( $url );
			$this->logUrlChange( 'Replaced vignette url', $originalUrl, $url );
		} else {
			if ( $this->isWikiaComSubdomainUrl( $url ) ) {
				$url = $this->fixWikiUrl( $url );
				$this->logUrlChange( 'Converted wiki url to protocol/host relative', $originalUrl, $url );
			} else {
				$this->output( "Don't know to handle {$url}\n" );
			}
		}
		return $url;
	}

	/**
	 * Tries to fix the url found in CSS code.
	 * @param $matches regex match object, $matches[0] contain the whole matched text, $matches[1] is the url itself.
	 * @return matched text with the url upgraded when possible.
	 */
	public function makeUrlHttpsComatible( $matches ) {
		$url = $this->fixUrl( $matches[ 1 ] );
		if ( !empty( $url ) && $url !== $matches[ 1 ] ) {
			$matches[ 0 ] = str_replace( $matches[ 1 ], $url, $matches[ 0 ] );
		}
		return $matches[ 0 ];
	}

	/**
	 * Process CSS source code upgrading urls to https/protocol-relative.
	 * @param $text CSS source code
	 * @return mixed Updated CSS source code
	 */
	public function updateCSSContent( $text ) {
		// To be on the safe side, only replace urls in image and import statements. This should reduce the number of
		// changes and prevent us from changing something we didn't mean to change.
		// match url("http://...")
		$text =  preg_replace_callback( '/url\s*\(\s*"(.+?)"\s*\)/i', [ $this, 'makeUrlHttpsComatible' ], $text );
		// match url('http://...')
		$text =  preg_replace_callback( '/url\s*\(\s*\'(.+?)\'\s*\)/i', [ $this, 'makeUrlHttpsComatible' ], $text );
		// match url(http://...)
		$text =  preg_replace_callback( '/url\s*\(\s*([^\'"]+?)\s*\)/i', [ $this, 'makeUrlHttpsComatible' ], $text );
		// match @import 'http://...'
		$text = preg_replace_callback( '/@import\s+\'(.+?)\'/i', [ $this, 'makeUrlHttpsComatible' ], $text );
		// match @import "http://..."
		$text = preg_replace_callback( '/@import\s+"(.+?)"/i', [ $this, 'makeUrlHttpsComatible' ], $text );
		// match (src="http://..."
		$text = preg_replace_callback( '/\(src="(.+?)"/i', [ $this, 'makeUrlHttpsComatible' ], $text );
		// match (src='http://...'
		$text = preg_replace_callback( '/\(src=\'(.+?)\'/i', [ $this, 'makeUrlHttpsComatible' ], $text );
		// match (src=http://... - up to a comma or closing parenthesis
		$text = preg_replace_callback( '/\(src=\s*([^"\',\) ]+)/i', [ $this, 'makeUrlHttpsComatible' ], $text );

		// logging - output lines that still use http protocol
		$lines = explode( "\n", $text );
		foreach( $lines as $line ) {
			if ( strpos( $line, 'http://' ) !== FALSE ) {
				$this->output( "Notice: http protocol still used in \"{$line}\"\n" );
			}
		}

		return $text;
	}

	/**
	 * If possible, make the CSS https-ready and save the updated content (if not running in dry mode)
	 */
	public function migrateCSS( Title $title ) {
		$revId = $title->getLatestRevID();
		$this->currentTitle = $title;
		$revision = Revision::newFromId( $revId );
		if( !is_null( $revision ) ) {
			$text = $revision->getText();
			$updatedText = $this->updateCSSContent( $text );
			if ( $text !== $updatedText ) {
				if ( $this->saveChanges ) {
					$article = new Article( $title );
					$editPage = new EditPage( $article );
					$editPage->summary = $this->getEditSummary();
					$editPage->textbox1 = $updatedText;
					$editPage->minoredit = true;
					$editPage->starttime = wfTimestampNow();
					$result = [];
					$status = $editPage->internalAttemptSave( $result, /* bot */ true );
					if ( $status->isGood() ) {
						$this->output( "Saved updated CSS file\n" );
					} else {
						$this->error( "Failed to save CSS file: {$status->value}!\n" );
					}
				}
				return true;
			}
		}
		return false;
	}

	public function execute() {
		global $wgUser, $wgCityId;

		$wgUser = User::newFromName( Wikia::BOT_USER ); // Make changes as FANDOMbot

		$this->saveChanges = $this->hasOption( 'saveChanges' );
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

		$where = [ 'page_namespace' => NS_MEDIAWIKI, 'page_is_redirect' => 0,
			'page_title ' . $this->db->buildLike( $this->db->anyString(), '.css' ) ];
		$options = [ 'ORDER BY' => 'page_title ASC' ];
		$result = $this->db->select( 'page', [ 'page_id', 'page_title', 'page_is_redirect' ], $where, __METHOD__, $options );
		$migratedFiles = 0;
		foreach( $result as $row ) {
			$title = Title::makeTitle( NS_MEDIAWIKI, $row->page_title );
			if ( $title->isCssPage() ) {
				$this->output( "Processing CSS file {$row->page_title}...\n" );
				if ( $this->migrateCSS( $title ) ) {
					$migratedFiles += 1;
				}
			}
		}
		$result->free();
		$this->output( "Migrated {$migratedFiles} CSS files.\n" );
	}

}

$maintClass = "MigrateCustomCssToHttps";
require_once( RUN_MAINTENANCE_IF_MAIN );
