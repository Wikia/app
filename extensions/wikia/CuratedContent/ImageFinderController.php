<?php


class ImageFinderController extends WikiaApiController {
	public function getList() {
		$query = $this->getRequiredParam( 'query' );
		$limit = $this->getVal( 'limit', 24 );

		$request = new WebRequest();
		$request->setVal( 'query', $query );
		$request->setVal( 'limit', $limit );
		$request->setVal( 'format', 'array' );
		$request->setVal( 'ns', NS_FILE );

		$suggestions = LinkSuggest::getLinkSuggest( $request );
		if ( !is_array( $suggestions ) ) {
			$suggestions = [];
		}

		$results = [];
		$filePageIds = array_map( 'intval', array_keys( $suggestions ) );
		$titles = Title::newFromIDs( $filePageIds );

		foreach ( $titles as $title ) {
			$file = RepoGroup::singleton()->getLocalRepo()->findFile( $title );

			if ( $file && (
					$file->getMediaType() == MEDIATYPE_BITMAP ||
					$file->getMediaType() === MEDIATYPE_DRAWING
				)
			) {
				$results[] = [
					'title' => $title->getText(),
					'type' => 'photo',
					'url' => $file->getUrl(),
					'width' => $file->getWidth(),
					'height' => $file->getHeight(),
					'id' => $title->getArticleID(),
				];
			}
		}

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setData( [ 'items' => $results ] );
	}
}