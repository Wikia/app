<?php
/**
 * @author ADi
 */
class SDParserTag {

	const RENDER_MODE_DEFAULT = 0;
	const RENDER_MODE_OBJECT = 1;
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
	protected $renderMode = 0;

	public function __construct( SDParser $parser, $tagRawContent, array $args = array() ) {
		$this->parser = $parser;
		$this->path = F::build( 'SDParserTagPropertyPath', array( 'pathString' => trim( $tagRawContent ) ) );
		$this->args = $args;
		if(isset($args['renderMode'])) {
			$this->renderMode = $args['renderMode'];
		}
		else {
			$this->renderMode = self::RENDER_MODE_DEFAULT;
		}
	}

	public function render() {
		$result = '';

		$SDElement = $this->getSDElement();

		if($SDElement instanceof SDElement) {
			$currentElement = $SDElement;
			do {
				if( $this->path->hasNext() ) {
					$tagProperty = $this->path->next( $currentElement );

					if( $tagProperty->isSDElement() ) {
						$currentElement = $tagProperty->get();
					}
					elseif( $tagProperty->isSDElementProperty() ) {
						$elementProperty = $tagProperty->get();

						if( !$this->path->hasNext() && !$tagProperty->hasValueIndex() ) {
							// last element in chain, try to render it
							$result = $elementProperty->render( SD_CONTEXT_DEFAULT, (array) $this->args );
							if( $result !== false ) {

								if( $this->renderMode == self::RENDER_MODE_OBJECT ) {
									return $elementProperty->getWrappedValue();
								}
								else {
									$currentElement = null;
									break;
								}
							}
						}

						$wrappedValue = $elementProperty->getWrappedValue();
						if( $elementProperty->isCollection() ) {
							$result = $wrappedValue[ $tagProperty->getValueIndex() ]->getValue();
						}
						else {
							$result = $wrappedValue->getValue();
						}

						if( is_object( $result ) && ( $result->object instanceof SDElement ) ) {
							$currentElement = $result->object;
						}
						elseif( !empty($result) ) {
							$currentElement = null;
							$renderedResult = $elementProperty->render( SD_CONTEXT_DEFAULT, (array) $this->args );
							if( $renderedResult !== false ) {
								$result = $renderedResult;
							}
						}
						else {
							$result = "Unknown value: " . $tagProperty->getName() . ( !$tagProperty->hasValueIndex() ? "[" . $tagProperty->getValueIndex() . "]" : "" );
							$currentElement = null;
						}
					}
					else {
						$result = "Unknown property: " . $tagProperty->getName();
						$currentElement = null;
					}

				}
				else {
					break;
				}
			}
			while( $currentElement instanceof SDElement );

			if($currentElement instanceof SDElement) {
				$result = $currentElement->render( SD_CONTEXT_DEFAULT, (array) $this->args );
			}
		}
		else {
			$result = 'Unknown element: ' . $this->path->getElementId();
		}

		return trim($result);
	}

	private function getSDElement() {
		return $this->parser->getSDElementByPath( $this->path );
	}
}
