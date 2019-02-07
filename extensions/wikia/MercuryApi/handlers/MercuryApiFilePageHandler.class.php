<?php

class MercuryApiFilePageHandler {

	public static function getFileContent( Title $title ) {
		$fileUsageData = F::app()->sendRequest(
			'FilePage',
			'fileUsage',
			[ 'type' => 'local', 'format' => 'json' ]
		)->getData();

		$details = WikiaFileHelper::getMediaDetail( $title );
		$mediaObject = ArticleAsJson::createMediaObject( $details, $title->getText() );

		$file = wfFindFile( $title );

		// width is set only for images and videos so if file page is about .pdf, .odt, .ogg or other type of file
		// we don't need to generate srcset or thumbnail url
		if ( isset( $mediaObject['width'] ) && is_int( $mediaObject['width'] ) ) {
			$mediaObject['srcset'] = ArticleAsJson::getSrcset( $mediaObject['url'], $mediaObject['width'], $file );
			$mediaObject['thumbnailUrl'] = ArticleAsJson::getThumbnailUrlForWidth( $mediaObject['url'], 340, $file );
		}

		// if article contains user provided HTML which is invalid (e.g. too many </div>), snippetter treat it as a text
		// too and it is not removed as other tags. In mobile-wiki we do not escape snippets, therefore invalid html may
		// cause errors on front-end side
		$fileUsageList = array_map( function( $item ) {
			$tidy = new tidy();
			$tidy->parseString( $item['snippet'] );
			$tidy->cleanRepair();
			if ( !empty( $tidy->body()->child ) ) {
				$item['snippet'] = array_reduce(
					$tidy->body()->child,
					function ( $acc, $child ) {
						return $acc . $child->value;
					}
				);
			}
			$item['canRead'] = true;
			$title = Title::newFromDBkey( $item['titleDBkey'] );
			if ( $title->isRedirect() ) {
				$item['canRead'] = false;
			}
			if ( !$title->userCan( 'read' ) ) {
				$item['canRead'] = false;
			}

			return $item;
		}, $fileUsageData['fileList']);

		$anonRedir = F::app()->sendRequest(
			'FilePage',
			'fileRedir',
			[ 'type' => 'local', 'format' => 'json' ]
		)->getData();

		$url = Title::newMainPage()->getFullURL();
		if ( isset( $anonRedir['url'] ) && $anonRedir['url'] ) {
			$url = $anonRedir['url'];
		}


		return [
			'anonRedir' => $url,
			'fileUsageList' => $fileUsageList,
			'fileUsageListSeeMoreUrl' => $fileUsageData['seeMoreLink'],
			'media' => $mediaObject
		];
	}
}
