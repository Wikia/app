<?php

class PortableInfoboxParserTagController extends WikiaController {
	const PARSER_TAG_NAME = 'infobox';

	/**
	 * @desc Parser hook: used to register parser tag in MW
	 *
	 * @param Parser $parser
	 * @return bool
	 */
	public static function parserTagInit( Parser $parser ) {
		$parser->setHook( self::PARSER_TAG_NAME, [ new static(), 'renderInfobox' ] );
		return true;
	}

	/**
	 * @desc Renders Infobox
	 *
	 * @param String $text
	 * @param Array $params
	 * @param Parser $parser
	 * @param PPFrame $frame
	 * @returns String $html
	 */
	public function renderInfobox( $text, $params, $parser, $frame ) {

		$markup = '<' . self::PARSER_TAG_NAME . '>' . $text . '</' . self::PARSER_TAG_NAME . '>';

		$infoboxParser = new Wikia\PortableInfobox\Parser\Parser( $frame->getNamedArguments() );
		$infoboxParser->setExternalParser( (new Wikia\PortableInfobox\Parser\MediaWikiParserService( $parser, $frame ) ) );
		$data = $infoboxParser->getDataFromXmlString( $markup );

		$renderer = new PortableInfoboxRenderService();

		return [ $renderer->renderInfobox( $data ), 'markerType' => 'nowiki' ];
	}

	private function parseData( $json, Parser $parser, PPFrame $frame ) {
		$result = [ ];
		foreach ( $json->items as $item ) {
			$result[ $item->tag->value ] = $this->parseItem( $item, $parser, $frame );
		}
		return $result;
	}

	private function parseItem( $item, Parser $parser, PPFrame $frame ) {
		$result = [
			'type' => $item->type->value,
			'data' => [
				'label' => $this->parseValue( $item->label->value, $parser, $frame ),
				'value' => $this->parseValue( $item->value->value, $parser, $frame ),
			]
		];
		//add path for image type
		if ( $item->type->value == 'image' ) {
			//resolve url
			$result[ 'data' ][ 'value' ] = $this->resolveImageUrl( $result[ 'data' ][ 'value' ] );
			//get alt attribute
			if ( !empty( $item->properties->alt->value ) ) {
				$result[ 'data' ][ 'alt' ] = $this->parseValue( $item->properties->alt->value, $parser, $frame );
			}
		}
		return $result;
	}

	private function resolveImageUrl( $filename ) {
		$title = Title::newFromText( $filename, NS_FILE );
		if ( $title && $title->exists() ) {
			return WikiaFileHelper::getFileFromTitle($title)->getUrlGenerator()->url();
		}
		return "";
	}

	private function parseValue( $text, Parser $parser, PPFrame $frame ) {
		if ( !empty( $text ) ) {
			$options = $parser->getOptions();
			$options->enableLimitReport( false );
			$preprocessed = $parser->recursivePreprocess( $text, $frame );
			$newlinesstripped = preg_replace( "|[\n\r]|Us", '', $preprocessed );
			$marksstripped = preg_replace( '|{{{.*}}}|Us', '', $newlinesstripped );
			return ( new Parser() )->parse( $marksstripped, $parser->getTitle(), $options, false )->getText();
		}
		return "";
	}
}
