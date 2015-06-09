<?php

namespace Wikia\AbPerfTesting;

interface Criterion {
	/**
	 * Does given criterion applies in the current context?
	 *
	 * @param int $bucket bucket ID to check
	 * @return boolean
	 */
	function applies($bucket);
}
