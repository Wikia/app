<?php
/**
 * Try to find matches in our video library for a title or youtube URLs
 *
 * @author garth@wikia-inc.com
 * @ingroup Maintenance
 */

ini_set('display_errors', 'stderr');

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

class SingleTitleSearch extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Try to match youtube tags in the wiki with premium video";
		$this->addOption( 'title', 'Title', false, true, 't' );
		$this->addOption( 'url', 'URL', false, true, 't' );
		$this->addOption( 'verbose', 'Verbose', false, false, 'v' );
	}

	public function execute() {

		// See if we have a one off title search
		$youtube_title = $this->getOption( 'title' );
		$url = $this->getOption( 'url' );

                if (empty($url) && empty($youtube_title)) {
                        die("Either --url or --title required\n");
                }

		// If we have a one off title, don't search this wiki for them
		if ($url) {
			$youtube_title = $this->pullTitle($url);
		}

		$premium_title = $this->closestMatch($youtube_title);
		$premium_title = preg_replace('/^file:/i', '', $premium_title);

		echo("# YouTube: $youtube_title\n" .
		     "# Premium: $premium_title\n");
	}

	function pullTitle ( $url ) {
		$url = trim($url);

		try {
			$youtube = YoutubeApiWrapper::newFromUrl($url);
		}
		catch( VideoIsPrivateException $e ) {
			echo ("# [ERROR] video is private: $url\n");
			continue;
		}
		catch( VideoNotFoundException $e ) {
			echo ("# [ERROR] video not found: $url\n");
			continue;
		}
		catch (Exception $e) {
			echo '# [ERROR] Caught exception: ',  $e->getMessage(), ": $url\n";
		}

		$t = $youtube->getTitle();

		return $t;
	}

	function closestMatch ( $titleText ) {
		$app = F::App();
		$data = $app->sendRequest('WikiaSearchController', 'searchVideosByTitle',
								  array('title' => $titleText))->getData();

		if ( empty( $data[0]['title'] ) ) {
			return '';
		} else {
			return $data[0]['title'];
		}
	}
}

$maintClass = "SingleTitleSearch";
require_once( RUN_MAINTENANCE_IF_MAIN );

