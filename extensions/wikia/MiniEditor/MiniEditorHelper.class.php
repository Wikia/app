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
		if (class_exists('RTE') && !empty($content) && !empty($convertToFormat)) {

			// If converting to richtext, handle edge cases
			if ($convertToFormat == 'richtext') {
				$html = RTE::WikitextToHtml($content);

				if (empty(RTE::$edgeCases)) {
					$content = $html;

				// Edge cases were found, add them to the response object (if provided)
				} else if (!is_null($response)) {
					$response->setVal('edgeCases', RTE::$edgeCases);
				}

			} else {
				$content = RTE::HtmlToWikitext($content);
			}
		}

		return $content;
	}
}