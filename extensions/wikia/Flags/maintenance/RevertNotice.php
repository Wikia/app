<?php

$dir = dirname( __FILE__ ) . "/../../../../";
require_once( $dir . 'maintenance/Maintenance.php' );

use Flags\Models\Flag;
use Flags\Models\FlaggedPages;

class RevertNotice extends Maintenance {

	const EDIT_SUMMARY = 'Restoring templates used in the [[Special:Flags]] feature.';

	public function __construct() {
		parent::__construct();
	}

	public function execute() {
		global $wgCityId;

		$pages = ( new FlaggedPages() )->getFlaggedPagesFromDatabase( $wgCityId );
		if ( empty( $pages ) ) {
			exit( "There are no pages with flags on this wiki ($wgCityId)\n");
		}

		$flagModel = new Flag();
		$mwf = \MagicWord::get( 'flags' );

		foreach ( $pages as $page ) {
			$templates = '';
			$logTemplates = [];
			$flags = $flagModel->getFlagsForPage( $wgCityId, $page );

			foreach ( $flags as $flag ) {
				$templates .= $this->createTemplateString( $flag );
				$logTemplates[] = $flag['flag_view'];
			}

			if ( !empty( $templates ) ) {
				$wiki = WikiPage::newFromID( $page );
				$content = $wiki->getText();

				if ( $mwf->match( $content ) ) {
					$text = $mwf->replace( $templates, $content );
				} else {
					$text = $templates . $content;
				}

				if ( strcmp( $content, $text ) !== 0 ) {
					$wiki->doEdit( $text, self::EDIT_SUMMARY, EDIT_FORCE_BOT );

					$log = sprintf(
						"Templates: %s where added to %s \n",
						implode( ',', $logTemplates ),
						$wiki->getTitle()->getText()
					);
					$this->output($log);
				}
			}
		}
	}

	private function createTemplateString( $flag ) {
		$template = "{{{$flag['flag_view']}";
		if ( !empty( $flag['params'] ) ) {
			foreach( $flag['params'] as $id => $param ) {
				if ( !empty( $param ) ) {
					$template .= "|{$id}={$param}";
				}
			}
		}
		$template .= "}}\n";

		return $template;
	}
}

$maintClass = 'RevertNotice';
require_once( RUN_MAINTENANCE_IF_MAIN );
