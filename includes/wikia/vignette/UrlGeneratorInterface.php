<?php
/*
 * An interface for objects that return a Wikia\Vignette\UrlGenerator.
 *
 * This is intended to be used with File or File-like objects and ImageServing
 * to provide a consistent and typed interface for generating image URLs.
 */

interface UrlGeneratorInterface {

	/*
	 * @return Wikia\Vignette\UrlGenerator
	 */
	public function getUrlGenerator();
}
