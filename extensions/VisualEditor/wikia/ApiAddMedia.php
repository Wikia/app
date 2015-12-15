<?php

abstract class ApiAddMedia extends ApiBase {

	protected function getFileDuplicate( $filepath ) {
		$duplicates = RepoGroup::singleton()->findBySha1(
			FSFile::getSha1Base36FromPath( $filepath )
		);
		if ( count ( $duplicates ) > 0 ) {
			return $duplicates[0];
		}
		return null;
	}

	protected function getVideoDuplicate( $provider, $videoId ) {
		$duplicates = WikiaFileHelper::getDuplicateVideos( $provider, $videoId );
		if ( count( $duplicates ) > 0 ) {
			return wfFindFile( $duplicates[0]['video_title'] );
		}
		return null;
	}

	public function isWriteMode() {
		return true;
	}

	public function mustBePosted() {
		return true;
	}

	public function needsToken() {
		return true;
	}

	public function getTokenSalt() {
		return '';
	}
}
