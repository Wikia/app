<?php

declare( strict_types=1 );

namespace FileFetcher;

/**
 * @since 4.2
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class StubFileFetcher implements FileFetcher {

	private $stubReturnValue;

	public function __construct( string $stubReturnValue ) {
		$this->stubReturnValue = $stubReturnValue;
	}

	// @codingStandardsIgnoreStart
	public function fetchFile( string $fileUrl ): string {
		// @codingStandardsIgnoreEnd
		return $this->stubReturnValue;
	}

}
