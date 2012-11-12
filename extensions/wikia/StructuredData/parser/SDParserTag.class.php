<?php
/**
 * @author ADi
 */
class SDParserTag {

	/**
	 * @var SDParser
	 */
	protected $parser;
	/**
	 * @var array
	 */
	protected $args;
	/**
	 * @var SDParserTagPropertyPath
	 */
	protected $path;

	public function __construct( SDParser $parser, $tagRawContent, array $args = array() ) {
		$this->path = F::build( 'SDParserTagPropertyPath', array( 'pathString' => $tagRawContent ) );
		$this->args = $args;
	}

	public function render() {
		$result = '';

		$SDElement = $this->getSDElement();

		if($SDElement instanceof SDElement) {
			$currentElement = $SDElement;
			do {
				// @todo implement
			}
			while( $currentElement instanceof SDElement );
		}
		else {
			$result = 'Unknown element: ' . $this->path->getElementId();
		}

		return $result;
	}

	private function getSDElement() {
		return $this->parser->getSDElementByPath( $this->path );
	}
}
