<?php
/**
 * @author: Jacek Jursza
 */
class SDTypeWikiText extends SDTypeHandlerAnyType {

	public function handleSaveData( array $data ) {

		$data = parent::handleSaveData( $data );

		if ( !empty( $data['schema:text'] ) ) {

			$parser = new Parser();
			$title = Title::newFromText( "Data:".$data['schema:name'] );

			/* @var $parserOutput ParserOutput */
			$parserOutput = $parser->parse( $data['schema:text'], $title, (new ParserOptions()) );

			// ----- remove HTML TAGs -----
			$string = $parserOutput->getText();
			$string = preg_replace ('/<[^>]*>/', ' ', $string);

			// ----- remove control characters -----
			$string = str_replace("\r", '', $string);    // --- replace with empty space
			$string = str_replace("\n", ' ', $string);   // --- replace with space
			$string = str_replace("\t", ' ', $string);   // --- replace with space

			// ----- remove multiple spaces -----
			$string = trim(preg_replace('/ {2,}/', ' ', $string));
			$string = trim(preg_replace('/([a-zA-Z0-9]) ([\.\,])/', '$1$2', $string));

			$data['schema:description'] = $string;
		}
		return $data;
	}
}
