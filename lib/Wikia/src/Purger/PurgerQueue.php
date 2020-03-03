<?php

declare( strict_types=1 );

namespace Wikia\Purger;

interface PurgerQueue {
	public function addUrls( array $urls );
	public function addSurrogateKey( string $key );
	public function addThumblrSurrogateKey( string $key );
}
