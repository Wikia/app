<?php
/*
 * An interface for objects that return a Vignette UrlGenerator.
 *
 * This is intended to be used
 */

namespace Wikia\Vignette;

interface UrlGeneratorInterface {

	/*
	 * @return \UrlGenerator
	 */
	public function getUrlGenerator();
}
