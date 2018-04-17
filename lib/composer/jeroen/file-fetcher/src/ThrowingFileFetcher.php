<?php

declare( strict_types=1 );

namespace FileFetcher;

/**
 * @since 4.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ThrowingFileFetcher extends InMemoryFileFetcher {

	public function __construct() {
		parent::__construct( [] );
	}

}
