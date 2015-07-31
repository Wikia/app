<?php

/**
 * Script goes through all provided pages in pages param and adds layout="stacked"
 *
 * @param string --pages Json encoded array contains list of pages ids and namespaces
 * e.g. before encoding
 * [
 *  [
 *    'page_id' => 123,
 *    'namespace' => 0
 *  ],
 *  [
 *    'page_id' => 124,
 *    'namespace' => 10
 *  ]
 * ]
 *
 * @author Kamil Koterba
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Maintenance script class
 */
class addLayoutToPortableInfoboxes extends Maintenance {

	private $summaries = [
		'en' => 'Adding explicit layout parameter'
	];

	public function __construct() {
		parent::__construct();
	}

	public function execute() {
		$pages = json_decode( $this->getOption( 'pages' ) );
		foreach ( $pages as $page ) {
			if ( $page['namespace'] !== 10 ) {
				continue;
			}
			$article = Article::newFromID( $page['page_id'] );
			$content = $article->getContent();
			$replacedContent = preg_replace_callback( '/<infobox([^>]*)>/i', [ $this,'replace' ], $content );

			$article->getPage()->doEdit( $replacedContent, $this->getSummary() );
		}
		$this->output( "\nDone!\n" );
	}

	public function replace( $matches ) {
		if ( $this->hasLayout( $matches[0] ) !== false ) {
			return $matches[0];
		}
		return preg_replace( '/<infobox/i', '<infobox layout="stacked"', $matches[0] );
	}

	private function hasLayout( $subject ) {
		return strpos( $subject, 'layout' );
	}

	private function getSummary() {
		global $wgContLang;
		$summary = $this->summaries[$wgContLang];
		if ( $summary ) {
			return $summary;
		} else {
			return $this->summaries['en'];
		}
	}

}

$maintClass = "addLayoutToPortableInfoboxes";
require_once( RUN_MAINTENANCE_IF_MAIN );
