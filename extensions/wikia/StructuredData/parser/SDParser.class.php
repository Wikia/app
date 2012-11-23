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
		$parser->setHook( 'datalist', array( $this, 'datalistParserHook' ) );
		$parser->setHook( 'data', array( $this, 'dataParserHook' ) );
		return true;
	}

	public function onParserFirstCallInitParserFunctionHook( Parser &$parser ) {
		$parser->setFunctionHook('data', array( $this, 'dataParserFunction') );
		return true;
	}

	public function getListFromStringPath( $path ) {
		$result = array();

		$dataTag = F::build( 'SDParserTag', array( 'parser' => $this, 'tagRawContent' => $path, 'args' => array( 'renderMode' => SDParserTag::RENDER_MODE_OBJECT ) ));
		$values = $dataTag->render();

		if( !is_array( $values ) ) {
			return $result;
		}

		foreach( $values as $value ) {
			if( $value->isObject() ) {
				$result[] = '#' . $value->getValue()->id;
			}
		}

		return $result;
	}

	public function datalistParserHook( $input, $args, Parser $parser, PPFrame $frame = null ) {
		$output = "";
		$list = $this->getListFromStringPath( $args['src'] );

		foreach ( $list as $elementHash ) {
			$output .= str_replace('$'.$args['var'], $elementHash, $input);
		}
		$output = $parser->recursiveTagParse( ( !empty($output) ? $output : $input ), $frame);

		return $output;
	}

	public function dataParserHook( $input, $args, Parser $parser, PPFrame $frame = null ) {
		if ( !empty( $frame ) ) {
			$input = $parser->recursiveTagParse($input, $frame);
		}

		$tag = F::build( 'SDParserTag', array( 'parser' => $this, 'tagRawContent' => $input, 'args' => $args ) );

		return $tag->render();
	}

	public function dataParserFunction( $parser, $param1 = '', $param2 = '' ) {
		return $this->dataParserHook( $param1, null, $parser );
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
