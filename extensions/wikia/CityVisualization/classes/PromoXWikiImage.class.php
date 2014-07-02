<?php

class PromoXWikiImage extends BaseXWikiImage {
	protected $reviewStatus;

	protected function getContainerDirectory() {
		return "/images/p/promote/images";
	}

	protected function getSwiftContainer() {
		return "promote";
	}

	protected function getSwiftPathPrefix() {
		return "/images";
	}

	public static function generateNewName( $wiki_id ) {
		return implode( '.', [ $wiki_id, time(), uniqid() ] );
	}

	public static function createNewImage( $wiki_id ) {
		return new PromoXWikiImage( self::generateNewName( $wiki_id ) );
	}

	public function setReviewStatus( $reviewStatus ) {
		$this->reviewStatus = $reviewStatus;
	}

	public function getReviewStatus() {
		return $this->reviewStatus;
	}
}
