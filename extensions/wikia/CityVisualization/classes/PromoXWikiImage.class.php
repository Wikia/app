<?php

class PromoXWikiImage extends BaseXWikiImage {
	protected $reviewStatus;
	const __DIMENSION_CACHE_KEY = "promo.image.dimensions.001.%s"; // %s name
	const __DIMENSION_CACHE_TTL = 2592000; // 30*24*60*60

	protected function getContainerDirectory() {
		return "/images/p/promote/images";
	}

	protected function getSwiftContainer() {
		return "promote";
	}

	protected function getSwiftPathPrefix() {
		return "/images";
	}

	protected function provideImageDimensions( $img = null ) {
		$cacheKey = sprintf( self::__DIMENSION_CACHE_KEY, $this->getName() );
		$cachedSize = F::app()->wg->memc
			->get( $cacheKey );
		if ( !empty( $cachedSize ) ) {
			$this->width = $cachedSize['w'];
			$this->height = $cachedSize['h'];
		} else {
			parent::provideImageDimensions( $img );
			$cachedSize = [ "w" => $this->width, "h" => $this->height ];
			F::app()->wg->memc
				->set( $cacheKey, $cachedSize, self::__DIMENSION_CACHE_TTL );
		}
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
