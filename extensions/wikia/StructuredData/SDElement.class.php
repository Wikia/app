<?php
/**
 * @author ADi
 */
class SDElement extends SDObject implements SplSubject {
	private $id = 0;
	private $depth = 0;
	private static $excludedNames = array(
		'@context',
		'type',
		'id'
	);
	protected $type = null;
	/**
	 * @var SplObjectStorage
	 */
	protected $properties = null;
	/**
	 * @var SDContext
	 */
	protected $context = null;

	/**
	 * @param string $type
	 * @param SDContext $context
	 * @param int $id
	 * @param int $depth
	 */
	public function __construct( $type, $context, $id = 0, $depth = 0) {
		$this->type = $type;
		$this->context = $context;
		$this->id = $id;
		$this->depth = $depth;

		$this->properties = F::build( 'SplObjectStorage' );
	}

	public function getId() {
		return $this->id;
	}

	public function setType($type) {
		$this->type = $type;
	}

	public function getType() {
		return $this->type;
	}

	public function setDepth($depth) {
		$this->depth = $depth;
	}

	public function getDepth() {
		return $this->depth;
	}

	public function getProperties() {
		return $this->properties;
	}

	/**
	 * Return a property based on its schema name
	 * @return SDElementProperty
	 */
	public function getProperty( $name ) {
		foreach($this->properties as $property) {
			if ( $property->getName() == $name )
				return $property;
		}
		return null;
	}

	/**
	 * get property value
	 * @param string $name
	 * @param mixed $default
	 * @return mixed
	 */
	public function getPropertyValue( $name, $default = null ) {
		$property = $this->getProperty( $name );
		return ($property instanceof SDElementProperty) ? $property->getValue() : $default;
	}

	/**
	 * Return element's name
	 * @return string
	 */
	public function getName() {
		return $this->getPropertyValue( 'schema:name' );
	}

	/**
	 * Return element's url
	 * @return string
	 */
	public function getUrl() {
		return $this->getPropertyValue( 'schema:url' );
	}

	/**
	 * @param \SDContext $context
	 */
	public function setContext($context) {
		$this->context = $context;
	}

	/**
	 * @return \SDContext
	 */
	public function getContext() {
		return $this->context;
	}

	public function addProperty(SDElementProperty $property) {
		$this->properties->attach( $property );
	}

	public static function newFromTemplate(stdClass $template, SDContext $context, stdClass $data = null, $depth = 0) {
		if(!empty($data) && isset($data->id)) {
			$elementId = $data->id;
		}
		/** @var $element SDElement */
		$element = F::build( 'SDElement', array( $template->type, $context, $elementId, $depth ) );
		$structuredData = F::build( 'StructuredData' );

		foreach($template as $propertyName => $propertyValue) {
			$propertyType = false;

			if(isset($data->{"$propertyName"})) {
				$propertyValue = $data->{"$propertyName"};
			}

			if(!in_array( $propertyName, self::$excludedNames )) {
				/** @var $property SDElementProperty */
				$property = F::build( 'SDElementProperty', array( $propertyName, $propertyValue, $propertyType) );
				if($depth == 0) {
					$property->expandValue( $structuredData, $element->getDepth() );
				}
				$element->addProperty( $property );
			}
			elseif($propertyName == '@context') {
				$context->addResource( $propertyValue, true, $element->getType() );
			}
		}

		$element->notify();

		return $element;
	}

	//public function

	public function toArray() {
		$properties = array();

		foreach($this->properties as $property) {
			$properties[] = $property->toArray();
		}

		return array(
			'id' => $this->getId(),
			'type' => $this->getType(),
			'name' => $this->getName(),
			'url' => $this->getUrl(),
			'properties' => $properties,
			'depth' => $this->getDepth()
		);
	}

	public function __toString() {
		return json_encode( $this->toArray() );
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Attach an SplObserver
	 * @link http://php.net/manual/en/splsubject.attach.php
	 * @param SplObserver $observer <p>
	 * The <b>SplObserver</b> to attach.
	 * </p>
	 * @return void
	 */
	public function attach(SplObserver $observer) {
		if($observer instanceof SDElementProperty) {
			// we want support only property objects
			$this->addProperty($observer);
		}
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Detach an observer
	 * @link http://php.net/manual/en/splsubject.detach.php
	 * @param SplObserver $observer <p>
	 * The <b>SplObserver</b> to detach.
	 * </p>
	 * @return void
	 */
	public function detach(SplObserver $observer) {
		$this->properties->detach($observer);
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Notify an observer
	 * @link http://php.net/manual/en/splsubject.notify.php
	 * @return void
	 */
	public function notify() {
		foreach($this->properties as $observer) {
			$observer->update($this);
		}
	}

	public function getTypeName() {
		return $this->type;
	}

	public function getRendererNames() {
		return array($this->getTypeName());
	}

	public function render( $context = SD_CONTEXT_DEFAULT ) {
		$result = parent::render( $context );
		return ( $result !== false ) ? $result : '<a href="'.$this->getSpecialPageUrl().'">'. htmlspecialchars( $this->getName() ) . '</a>';
	}

	public function getSpecialPageUrl() {
		return self::createSpecialPageUrl($this);
	}

	public static function createSpecialPageUrl($o) {
		if (is_array($o)) {
			$type = $o['type'];
			$name = $o['name'];
		} else {
			$type = $o->getType();
			$name = $o->getName();
		}
		$title = SpecialPage::getTitleFor( 'StructuredData', str_replace(' ', '+', $type) . '/' . str_replace(' ', '+', $name) );
		return $title->getFullUrl();
	}
}
