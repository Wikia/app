<?php
/**
 * @author ADi
 */
class SDElementRendererFactory {
	private $config = null;

	public function __construct(Array $config) {
		$this->config = $config;
	}

	public function getRenderer(SDObject $object) {

		if(isset($this->config['renderers'][$object->getTypeName()])) {
			$className = $this->config['renderers'][$object->getTypeName()];
			$classPath = $this->config['rendere'] . $className . '.class.php';
			if(file_exists( $classPath )) {
				include_once( $classPath );

				return F::build( $className, array( 'object' => $object) );
			}
			else {
				throw new WikiaException('SDElementRenderer not found for type: ' . $object->getTypeName() );
			}
		}

		return null;
	}
}
