<?php

declare( strict_types=1 );

namespace Wikia\Search\UnifiedSearch;

interface UnifiedSearchResultItem extends \ArrayAccess {
	public function extended( array $data);

	public function toArray(): array;
}
