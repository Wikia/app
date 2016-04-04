<?php

$dir = __DIR__ . '/../../../../';
require_once $dir . 'maintenance/Maintenance.php';

use Flags\Models\Flag;
use Flags\Models\FlaggedPages;
use Wikia\Util\GlobalStateWrapper;

class RevertNotice extends Maintenance {

	const EDIT_SUMMARY = 'Restoring templates used in the [[Special:Flags]] feature.';

	public function execute() {
		global $wgCityId, $wgEnableFlagsExt;

		if ( empty( $wgEnableFlagsExt ) ) {
			exit( "Flags extension is disabled on wiki {$wgCityId}\n" );
		}

		$pages = ( new FlaggedPages() )->getFlaggedPagesFromDatabase( $wgCityId );
		if ( empty( $pages ) ) {
			exit( "There are no pages with flags on this wiki {$wgCityId}\n");
		}

		$flagModel = new Flag();
		$mwf = \MagicWord::get( 'flags' );

		$user = User::newFromName( 'Wikia' );
		$wrapper = new GlobalStateWrapper( [
			'wgUser' => $user
		] );

		$wrapper->wrap( function() use ( $wgCityId ) {
			$this->disableFlagsExt( $wgCityId );
		} );

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

				if ( $wiki && $wiki->getTitle()->inNamespace( NS_MAIN ) ) {
					$content = $wiki->getText();

					if ( $mwf->match( $content ) ) {
						$text = $mwf->replace( $templates, $content );
					} else {
						$text = $templates . $content;
					}

					if ( strcmp( $content, $text ) !== 0 ) {
						$wiki->doEdit( $text, self::EDIT_SUMMARY, EDIT_FORCE_BOT, /* $baseRevId = */ false, $user );

						$log = sprintf(
							"Templates: %s were added to %s (%d) \n",
							implode( ',', $logTemplates ),
							$wiki->getTitle()->getText(),
							$wiki->getTitle()->getArticleId()
						);
						$this->output($log);
					}
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

	private function disableFlagsExt( $wikiId ) {
		WikiFactory::setVarByName( 'wgEnableFlagsExt', $wikiId, false );
	}
}

$maintClass = 'RevertNotice';
require_once RUN_MAINTENANCE_IF_MAIN;
