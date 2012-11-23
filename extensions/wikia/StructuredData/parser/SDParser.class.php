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
		$parser->setHook( 'dl', array( $this, 'dlParserHook' ) );
		$parser->setHook( 'data', array( $this, 'dataParserHook' ) );
		return true;
	}

	public function onParserFirstCallInitParserFunctionHook( Parser &$parser ) {
		$parser->setFunctionHook('data', array( $this, 'dataParserFunction') );
		return true;
	}

	public function getListForStringPath( $path ) {

		if ( $path == 'mock-characters' ) {
			$arr = array(
				"callofduty:Character/Fidel Castro",
				"callofduty:Character/Terrance ",
				"callofduty:Character/Nikita Dragovich"
			);
		}
		if ( $path == 'mock-weapon' ) {
			$arr = array(
				"callofduty:Weapon/Weapon_KS-23",
				//"callofduty:Weapon/kałasz"
			);
		}

		return $arr;
	}

	public function dlParserHook( $input, $args, Parser $parser, PPFrame $frame = null ) {

		$list = $this->getListForStringPath( $args['src'] );
		$output = "";
		foreach ( $list as $i => $element ) {
			$output .= str_replace('$'.$args['var'], $element, $input);
		}
		$output = $parser->recursiveTagParse($output, $frame);
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
