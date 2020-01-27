<?php

declare( strict_types=1 );

namespace Wikia\Purger;

interface Purger {
	public function addUrls( array $urls );

	public function addSurrogateKey( string $key );
}
