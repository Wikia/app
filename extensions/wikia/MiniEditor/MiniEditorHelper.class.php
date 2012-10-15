<?php

class MiniEditorHelper extends WikiaModel {

	/**
	 * Convert editor content from one format to another.
	 *
	 * @param $content The content to convert from the request object or passed in as a string
	 * @param $convertToFormat The format to convert to ('richtext' or 'wikitext')
	 * @param $response (optional) The response object to add edgeCases to
	 */
	public static function convertContent($content = '', $convertToFormat = '', WikiaResponse $response = null) {
		if (class_exists('RTE')) {

			// Clear out edge cases to avoid polluting future requests
			RTE::$edgeCases = array();

			if (!empty($content) && !empty($convertToFormat)) {
				if ($convertToFormat == 'richtext') {
					$html = RTE::WikitextToHtml($content);

					if (empty(RTE::$edgeCases)) {
						$content = $html;

					// Edge cases were found, add them to the response object (if provided)
					} else if (!is_null($response)) {
						$response->setVal('edgeCases', RTE::$edgeCases);
					}

				} else if ($convertToFormat == 'wikitext') {
					$content = RTE::HtmlToWikitext($content);
				}
			}
		}

		return $content;
	}

	/**
	 * Returns any edge cases found for the previous conversion from wikitext to richtext.
	 */
	public static function getEdgeCases() {
		$edgeCases = array();

		if (class_exists('RTE') && !empty(RTE::$edgeCases)) {
			$edgeCases = RTE::$edgeCases;
		}

		return $edgeCases;
	}
}