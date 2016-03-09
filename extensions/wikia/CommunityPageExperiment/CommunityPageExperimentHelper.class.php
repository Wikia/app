<?php

class CommunityPageExperimentHelper {
	const HEADER_IMAGE_NAME = 'Community-Page-Header.jpg';

	public function getPageList() {
		global $wgCommunityPageExperimentPages;

		$pages = [];

		if ( empty( $wgCommunityPageExperimentPages ) ) {
			return $pages;
		}

		foreach ( $wgCommunityPageExperimentPages as $page ) {
			$title = Title::newFromText( $page );
			if ( !( $title instanceof Title ) ) {
				continue;
			}

			$editActionParam = ( EditorPreference::isVisualEditorPrimary() ? 'veaction' : 'action' );

			$pages[] = [
				'titleText' => $title->getPrefixedText(),
				'titleUrl' => $title->getLocalURL(),
				'editUrl' => $title->getLocalURL( [ $editActionParam => 'edit' ] ),
			];
		}

		return $pages;
	}

	public function getHeaderImage() {
		$title = Title::newFromText( self::HEADER_IMAGE_NAME, NS_FILE );
		$file = wfFindFile( $title );
		if ( $file instanceof File ) {
			return $file->getUrl();
		}

		return false;
	}
}
