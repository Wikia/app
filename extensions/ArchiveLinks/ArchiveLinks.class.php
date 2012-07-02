<?php
/**
 * Main Extension Class for Archive Links
 */

class ArchiveLinks {
	private $db_master;
	private $db_slave;
	private $db_result;

	/**
	 * This is the primary function for the Archive Links Extension
	 * It fires off of the ArticleSaveComplete hook and is primarily responsible for updating
	 * the appropiate tables to began the process of archival
	 *
	 * @param $article Article object article object from ArticleSaveComplete hook
	 * @return bool
	 */
	public static function queueExternalLinks ( &$article ) {
		global $wgParser, $wgArchiveLinksConfig;
		$external_links = $wgParser->getOutput();
		$external_links = $external_links->mExternalLinks;

		$db_master = wfGetDB( DB_MASTER );
		$db_slave = wfGetDB( DB_SLAVE );
		$db_result = array();

		$db_master->begin();

		if ( !isset( $wgArchiveLinksConfig['global_rearchive_time'] ) ) {
			//30 days or 2,592,000 seconds...
			$wgArchiveLinksConfig['global_rearchive_time'] = 2592000;
		}

		if ( !isset( $wgArchiveLinksConfig['page_rearchive_time'] ) ) {
			//200 days or 17,280,000 seconds
			$wgArchiveLinksConfig['page_rearchive_time'] = 1728000;
		}

		if( !isset( $wgArchiveLinksConfig['previous_archive_lockout_time'] ) ) {
			//2 days or 172,800 seconds
			$wgArchiveLinksConfig['previous_archive_lockout_time'] = 172800;
		}

		$page_id = $article->getID();
		$time = time();

		if ( $wgArchiveLinksConfig['generate_feed'] === true ) {
			$old_id = $article->getTitle();
			$old_id = $old_id->getPreviousRevisionID( $page_id );

			$db_result['links_on_page'] = $db_master->select( 'el_archive_link_history', '*', array( 'hist_page_id' => $page_id ), __METHOD__ );

			$old_external_links = array();
			$new_external_links = array();

			if ( $db_result['links_on_page']->numRows() > 0 ) {
				while( $row = $db_result['links_on_page']->fetchRow() ) {
					$old_external_links[] = $row['hist_url'];
				}

				$new_external_links = array_diff( $external_links, $old_external_links );
				unset( $old_external_links );

				//die( var_dump( $old_external_links ) );
			} elseif ( count( $external_links ) > 0 ) {
				$new_external_links = $external_links;
			}

			if ( !isset( $wgArchiveLinksConfig['link_insert_max'] ) ) {
				$wgArchiveLinksConfig['link_insert_max'] = 100;
			}
			die ( count( $new_external_links ));
			if ( count( $new_external_links ) <= $wgArchiveLinksConfig['link_insert_max'] ) {
				//insert the links into the queue now
				foreach( $new_external_links as $link ) {
					$db_result['queue'] = $db_slave->select( 'el_archive_queue', '*', array( 'url' => $link ), __METHOD__, array( 'LIMIT' => '1', ) );
					$db_result['blacklist'] = $db_slave->select( 'el_archive_blacklist', '*', array( 'bl_url' => $link ), __METHOD__, array( 'LIMIT' => '1', ) );

					$db_result['queue-numrows'] = $db_result['queue']->numRows();
					$db_result['blacklist-numrows'] = $db_result['blacklist']->numRows();

					if ( $db_result['blacklist-numrows'] === 0 && $db_result['queue-numrows'] === 0 ) {
						$db_master->insert( 'el_archive_queue', array(
							'page_id' => $page_id,
							'url' => $link,
							'delay_time' => '0',
							'insertion_time' => $time,
							'in_progress' => '0',
						));

						$db_master->insert( 'el_archive_link_history', array(
							'hist_page_id' => $page_id,
							'hist_url' => $link,
							'hist_insertion_time' => $time,
						));
					}
				}
			} else {
				//insert everything as a job and do the work later to avoid lagging page save
			}
		} else {
			foreach ( $external_links as $link => $unused_value ) {
				//$db_result['resource'] = $db_slave->select( 'el_archive_resource', '*', '`el_archive_resource`.`resource_url` = "' . $db_slave->strencode( $link ) . '"');
				$db_result['blacklist'] = $db_slave->select( 'el_archive_blacklist', '*', array( 'bl_url' => $link ), __METHOD__ );
				$db_result['queue'] = $db_slave->select( 'el_archive_queue', '*', array( 'url' => $link ), __METHOD__ );

				if ( $db_result['blacklist']->numRows() === 0 ) {
					if ( $db_result['queue']->numRows() === 0 ) {
						// this probably a first time job
						// but we should check the logs and resource table
						// to make sure
						$db_master->insert( 'el_archive_queue', array (
							'page_id' => $page_id,
							'url' => $link,
							'delay_time' => '0',
							'insertion_time' => $time,
							'in_progress' => '0',
						));
					} else {
						//this job is already in the queue, why?
						// * most likely reason is it has already been inserted by another page
						// * or we are checking it later because the site was down at last archival
						//  in either case we don't really need to do anything right now, so skip...
					}
				}
			}
		}

		$db_master->commit();

		return true;
	}

	/**
	 * This is the function resposible for rewriting the link html to insert the [cache] link
	 * after each external link on the page. This function will get called once for every external link.
	 *
	 * @global $wgArchiveLinksConfig array
	 * @param $url string The url of the page (what would appear in href)
	 * @param $text string The assoicated text of the URL (what would go between the anchor tags)
	 * @param $link string The rewritten text of the URL
	 * @param $attributes array Any attributes for the anchor tag
	 * @return bool
	 */
	public static function rewriteLinks (  &$url, &$text, &$link, &$attributes ) {
		if ( isset( $attributes['rel'] ) && $attributes['rel'] === 'nofollow' ) {
			global $wgArchiveLinksConfig;
			if ( $wgArchiveLinksConfig['use_multiple_archives'] ) {
				//need to add support for more than one archival service at once
				//  (a page where you can select one from a list of choices)
			} else {
				switch ( $wgArchiveLinksConfig['archive_service'] ) {
					case 'local':
						//We need to have something to figure out where the filestore is...
						$link_to_archive = urlencode( substr_replace( $url, '', 0, 7 ) );
						break;
					case 'wikiwix':
						$link_to_archive = 'http://archive.wikiwix.com/cache/?url=' . $url;
						break;
					case 'webcitation':
						$link_to_archive = 'http://webcitation.org/query?url=' . $url;
						break;
					case 'internet_archive':
					default:
						if ( /*$wgArchiveLinksConfig['generate_feed'] === true*/ false ) {
							$db_slave = wfGetDB( DB_SLAVE );
							$db_slave->select( 'el_archive_link_history','*');
						} else {
							$link_to_archive = 'http://wayback.archive.org/web/*/' . $url;
						}
						break;
				}
			}

			$link = HTML::element('a', array ( 'rel' => 'nofollow', 'class' => $attributes['class'], 'href' => $url ), $text )
				. HTML::openElement('sup')
				. HTML::openElement('small')
				. '&#160;'
				. HTML::element('a', array ( 'rel' => 'nofollow', 'href' => $link_to_archive ), '[' . wfMsg( 'archivelinks-cache-title') . ']')
				. HTML::closeElement('small')
				. HTML::closeElement('sup');

			return false;
		} else {
			return true;
		}
	}

	/**
	 * This function is responsible for any database updates within the extension and hooks into
	 * update.php
	 *
	 * @param $updater DatabaseUpdater object Passed by the LoadExtensionSchemaUpdates hook
	 * @return bool
	 */
	public static function schemaUpdates ( $updater = null ) {
		$path = dirname( __FILE__ );
		$updater->addExtensionUpdate( array(
			'addTable',
			'el_archive_link_history',
			$path . '/setuptables.sql',
			true
		));
		return true;
	}
}

class InsertURLsIntoQueue extends Job {
		public function __construct( $title, $params ) {
			// Replace synchroniseThreadArticleData with the an identifier for your job.
			parent::__construct( 'insertURLsIntoQueue', $title, $params );
		}

		public function run() {

		}
}
