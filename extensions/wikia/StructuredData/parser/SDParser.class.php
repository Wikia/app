<?php
/**
 * @author ADi
 */
class SDParser {
	/**
	 * @var StructuredData
	 */
	protected $structuredData = null;

	public function __construct( StructuredData $structuredData ) {
		$this->structuredData = $structuredData;
	}

	public function onParserFirstCallInit( Parser &$parser ) {
		$parser->setHook( 'data', array( $this, 'dataParserHook' ) );
		return true;
	}

	public function dataParserHook( $input, $args, Parser $parser, PPFrame $frame ) {
		$input = $parser->recursiveTagParse($input, $frame);

		$tag = F::build( 'SDParserTag', array( 'parser' => $this, 'tagRawContent' => $input, 'args' => $args ) );

		return $tag->render();
	}

	public function getSDElementByPath(SDParserTagPropertyPath $path) {
		if( $path->hasElementHash() ) {
			$SDElement = $this->structuredData->getSDElementById( $path->getElementHash() );
		}
		else {
			$SDElement = $this->structuredData->getSDElementByTypeAndName( $path->getElementType(), $path->getElementName() );
		}
		return $SDElement;
	}

}
