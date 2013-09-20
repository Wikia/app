<?php
/**
 * @author ADi
 */
class SDParser {

	protected static $instance = null;

	/**
	 * @var StructuredData
	 */
	protected $structuredData = null;

	public function __construct( StructuredData $structuredData = null) {
		if( is_null( $structuredData ) ) {
			$structuredData = new StructuredData();
		}
		$this->structuredData = $structuredData;
	}

	static public function getInstance() {
		if( is_null(self::$instance) ) {
			self::$instance = new SDParser();
		}
		return self::$instance;
	}

	static public function onParserFirstCallInit( Parser &$parser ) {
		$instance = self::getInstance();
		$parser->setHook( 'datalist', array( $instance, 'datalistParserHook' ) );
		$parser->setHook( 'data', array( $instance, 'dataParserHook' ) );
		return true;
	}

	static public function onParserFirstCallInitParserFunctionHook( Parser &$parser ) {
		$instance = self::getInstance();
		$parser->setFunctionHook('data', array( $instance, 'dataParserFunction') );
		return true;
	}

	public function getListFromStringPath( $path ) {
		$result = array();

		$dataTag = new SDParserTag( $this, $path, array( 'renderMode' => SDParserTag::RENDER_MODE_OBJECT ) );
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
		if(count($list) > 0) {
			foreach ( $list as $elementHash ) {
				$tmpOutput = str_replace( '<$'.$args['var'], '<datalist', $input);
				$tmpOutput = str_replace( '</$'.$args['var'], '</datalist', $tmpOutput);
				$tmpOutput = preg_replace( '/(foreach="([a-z,0-9,:,_]{1,})")/i', 'src="'.$elementHash.'/$2"', $tmpOutput );
				$output .= str_replace( '$'.$args['var'], $elementHash, $tmpOutput );
			}
		}
		else {
			return '';
		}

		$output = $parser->recursiveTagParse( ( $output ), $frame);
		return $output;
	}

	public function dataParserHook( $input, $args, Parser $parser, PPFrame $frame = null ) {
		if ( !empty( $frame ) ) {
			$input = $parser->recursiveTagParse($input, $frame);
		}
		$args['parser'] = $parser;
		$args['frame'] = $frame;

		$tag = new SDParserTag( $this, $input, $args );

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
