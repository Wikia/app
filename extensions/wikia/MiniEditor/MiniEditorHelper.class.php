<?php

class MiniEditorHelper extends WikiaModel {

	/**
	 * Helper function for extensions integrating with the Mini Editor
	 * This will look at the request 'format' parameter and will return 
	 * the opposite format. html -> wikitext and wikitext -> html
	 * The second parameter is the name of the request parameter to convert ('body' or 'newbody' etc)
	 * If the second parameter is null, you can pass in raw text for conversion
	 */
	public static function convertRequestText(WikiaRequest $request, $requestParam, $rawText = null) {
		// $convertFormat is the desired format, i.e. convert to this format.  
		$convertFormat = $request->getVal('convertFormat', 'wikitext');

		if ($rawText != null) {
			$text = $rawText;

		} else {
			$text = $request->getVal($requestParam, null);
		}

		if ($convertFormat == 'RTEHtml') {
			$text = RTE::WikitextToHtml($text);

		} else {
			$text = RTE::HtmlToWikitext($text);
		}

		return $text;
	}
}