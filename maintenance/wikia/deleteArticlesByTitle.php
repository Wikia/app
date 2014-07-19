<?php

/**
 * Script that removes articles from a wiki given a list of article titles
 *
 * Use --quiet option when running on cron machines
 *
 * @author garth@wikia-inc.com
 * @file
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_NOTICE);

/**
 * Maintenance script class
 */
class DeleteArticlesByTitle extends Maintenance {

	const REASON = 'Removed by deleteArticlesByTitle maintenance script';

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( 'file', 'File containing titles', true, true, 'f' );
		$this->addOption( 'namespace', 'Namespace ID to iterate over (default: 0)', false, true, 'n' );
		$this->addOption( 'dry-run', 'Do not remove any article, just list them' );
		$this->mDescription = 'Remove articles from a file of titles';
	}

	public function execute() {
		$file = $this->getOption('file');
		$namespace = intval($this->getOption('namespace', 0));
		$isDryRun = $this->hasOption('dry-run');

		if ( $isDryRun ) {
			echo "== DRY RUN ==\n\n";
		}

		global $wgUser;
		$wgUser = User::newFromName( 'WikiaBot' );


		if ( ! file_exists( $file ) ) {
			die( "File $file does not exist\n" );
		}

		$content = trim( file_get_contents($file) );

		$lines = explode("\n", $content);

		if (count($lines) === 0) {
			die( "No articles found!\n" );
		}

		echo "Removing ".count($lines)." article(s) in namespace ".$namespace."\n";

		foreach ( $lines as $titleText ) {
			if ( preg_match( '/^ *$/', $titleText ) ) {
				continue;
			}

			echo "* Deleting $titleText ... ";

			$title = Title::newFromText( $titleText, $namespace );
			$pageId = $title->getArticleID();

			$article = Article::newFromID( $pageId );
			if ( $article instanceof Article ) {
				if ( $isDryRun ) {
					echo "not deleted (dry run)\n";
					continue;
				} else {
					$res = $article->doDeleteArticle( self::REASON );
				}

				if ( $res === true ) {
					echo "done\n";
				} else {
					echo "error!\n";
				}
			} else {
				echo "article not found by its ID!\n";
			}
		}

		echo "\nDone!\n";
	}
}

$maintClass = "DeleteArticlesByTitle";
require_once( RUN_MAINTENANCE_IF_MAIN );
