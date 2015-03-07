<?php
class ImageServingDriverUserNS extends ImageServingDriverMainNS {

	function formatResult( $allImages, $filteredImages ) {
		$out = parent::formatResult( $allImages, $filteredImages );
		foreach ( $this->getArticles() as $articleId => $articleData ) {
			$titleParts = explode( '/', $articleData['title'] );
			$userName = $titleParts[0];
			if ( !empty( $out[$articleId] ) ) {
				$out[$articleId] = array( $this->getAvatar( $userName ) ) + array_slice( $out[$articleId], 0, ImageServing::MAX_LIMIT - 1 );
			} else {
				$out[$articleId] = array( $this->getAvatar( $userName ) );
			}
		}

		return $out;
	}

	private function getAvatar( $user ) {
		$cut = $this->imageServing->getCut( 100, 100, "center", false );

		return array(
			"name" => 'avatar',
			"url" => AvatarService::getAvatarUrl( $user, $cut )
		);
	}
}