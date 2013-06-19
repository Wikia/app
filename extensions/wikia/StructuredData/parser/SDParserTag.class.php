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
		$this->path = new SDParserTagPropertyPath( trim( $tagRawContent ) );

		if(isset($args['renderMode'])) {
			$this->renderMode = $args['renderMode'];
			unset($args['renderMode']);
		}
		else {
			$this->renderMode = self::RENDER_MODE_DEFAULT;
		}

		$this->args = $args;
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
							$result = $elementProperty->render( SD_CONTEXT_DEFAULT, $this->getArgs( $currentElement->getId(), $tagProperty->getName() ) );
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
							$result = isset( $wrappedValue[ $tagProperty->getValueIndex() ] ) ? $wrappedValue[ $tagProperty->getValueIndex() ]->getValue() : '';
						}
						else {
							$result = $wrappedValue->getValue();
						}

						if( is_object( $result ) && ( $result->object instanceof SDElement ) ) {
							$currentElement = $result->object;
						}
						elseif( !empty($result) ) {
							$renderedResult = $elementProperty->render( SD_CONTEXT_DEFAULT, $this->getArgs() );
							if( $renderedResult !== false ) {
								$result = $renderedResult;
							}
							$currentElement = null;
						}
						else {
							$result = $this->isDebugMode() ? ( "Unknown value: " . $tagProperty->getName() . ( $tagProperty->hasValueIndex() ? "[" . $tagProperty->getValueIndex() . "]" : "" ) ) : '';
							$currentElement = null;
						}
					}
					else {
						$result = $this->isDebugMode() ? ( "Unknown property: " . $tagProperty->getName() ) : '';
						$currentElement = null;
					}

				}
				else {
					break;
				}
			}
			while( $currentElement instanceof SDElement );

			if($currentElement instanceof SDElement) {
				$result = $currentElement->render( SD_CONTEXT_DEFAULT, $this->getArgs() );
			}
		}
		else {
			$result = $this->isDebugMode() ? ( "Unknown element: " . $this->path->getElementId() ) : '';
		}

		return trim($result);
	}

	private function isDebugMode() {
		return isset( $this->args['debug'] ) ? (bool) $this->args['debug'] : false;
	}

	private function getArgs( $objectId = '', $propName = '' ) {
		$extraArgs = array();

		if( !empty( $objectId ) ) {
			$extraArgs['objectId'] = $objectId;
		}

		if( !empty( $propName ) ) {
			$extraArgs['propName'] = $propName;
		}

		return ( count( $extraArgs ) > 0 ) ? array_merge( $this->args, $extraArgs ) : $this->args;
	}

	private function getSDElement() {
		return $this->parser->getSDElementByPath( $this->path );
	}
}
