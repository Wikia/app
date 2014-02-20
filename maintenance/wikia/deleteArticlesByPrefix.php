<?php

/**
 * Script that removes articles from a wiki matching given prefix
 *
 * Use --quiet option when running on cron machines
 *
 * @author macbre
 * @file
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Maintenance script class
 */
class DeleteArticlesByPrefix extends Maintenance {

	const REASON = 'Removed by DeleteArticlesByPrefix maintenance script';

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( "prefix", "Prefix used to match articles", true /* $required */ );
		$this->addOption( "namespace", "Namespace ID to iterate over (default: 0)", false, false, 'ns' );
		$this->addOption( "dry-run", "Do not remove any article, just list them" );
		$this->mDescription = "Remove articles matching given prefix (up to 5000)";
	}

	public function execute() {
		$prefix = $this->getOption('prefix');
		$namespace = intval($this->getOption('namespace', 0));
		$isDryRun = $this->hasOption('dry-run');

		$this->output( "Looking for pages matching '{$prefix}' prefix in namespace #{$namespace}... " );

		$res = ApiService::call(array(
			'action' => 'query',
			'list' => 'allpages',
			'apnamespace' => $namespace,
			'apprefix' => $prefix,
			'aplimit' => 5000,
		));

		$pages = !empty($res['query']['allpages']) ? $res['query']['allpages'] : array();
		$this->output(count($pages) . " article(s) found\n\n");

		if (count($pages) === 0) {
			$this->output("No articles found!\n");
			die();
		}

		foreach($pages as $page) {
			if ($isDryRun) {
				$this->output("* {$page['title']} not deleted (dry run)\n");
				continue;
			}

			$this->output("* Deleting {$page['title']}...");

			$article = Article::newFromID($page['pageid']);
			if ($article instanceof Article) {
				$res = $article->doDeleteArticle(self::REASON);

				if ($res === true) {
					$this->output(" done\n");
				}
				else {
					$this->output(" error!\n");
				}
			}
			else {
				$this->output(" article not found by its ID!\n");
			}
		}

		$this->output("\nDone!\n");
	}
}

$maintClass = "DeleteArticlesByPrefix";
require_once( RUN_MAINTENANCE_IF_MAIN );
