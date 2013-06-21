<?php
/**
 * @author ADi
 */
class SDElement extends SDRenderableObject implements SplSubject {
	private $id = 0;
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
	 */
	public function __construct( $type, $context, $id = 0) {
		$this->type = $type;
		$this->context = $context;
		$this->id = $id;

		$this->properties = (new SplObjectStorage);
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

	public function getProperties() {
		return $this->properties;
	}

	public function isPropertyVisible( $property ) {

		//TODO: it should be SDS API dependent (object template?)
		// fields to hide
		$mockData = array(
		    'callofduty:Character' => array( 	'wikia:namespace',
			    				'schema:audio',
			    				'wikia:element',
			    				'schema:video',
			                    'wikia:elementIn'
		    ) ,
		    'callofduty:Weapon' => array(
			    				'wikia:namespace',
			    				'schema:audio',
			    				'schema:video',
			                    'wikia:elementIn'
		    ),
		    'wikia:WikiText' => array(
							'wikia:elementIn',
							'wikia:namespace',
							'schema:audio',
			    				'schema:url',
			    				'schema:photos',
			    				'schema:video',
			    				'wikia:restriction',
			    				'schema:description'
		    ),
		    'schema:ImageObject' => array(
			    				'schema:thumbnailUrl',
			    				'schema:description',
			    				'wikia:restriction',
			    				//'schema:contentURL',
			    				//'schema:width',
			    				//'schema:height'
		    ),
			'wikia:VideoGame' => array(
				'wikia:platform',
				'wikia:elementIn',
				'schema:publisher'
			),
			'*' => array(
				'wikia:namespace'
			)

		);

		if ( $property instanceof SDElementProperty ) {
			$property = $property->getName();
		}
		if ( isset($mockData[ $this->type ])) {
			if ( in_array( $property, $mockData[ $this->type ]) ) {
				return false;
			}
		}

		if ( in_array( $property, $mockData[ '*' ]) ) {
			return false;
		}

		return true;
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
	 * @return SDElementPropertyValue
	 */
	public function getPropertyValue( $name, $default = null ) {
		$property = $this->getProperty( $name );
		return ($property instanceof SDElementProperty) ? $property->getWrappedValue() : $default;
	}

	/**
	 * Return element's name
	 * @return string
	 */
	public function getName() {
		return $this->getPropertyValue( 'schema:name' )->getValue();
	}

	/**
	 * Return element's url
	 * @return string
	 */
	public function getUrl() {
		return $this->getPropertyValue( 'schema:url' )->getValue();
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

	public static function newFromTemplate(stdClass $template, SDContext $context, stdClass $data = null) {
		if(!empty($data) && isset($data->id)) {
			$elementId = $data->id;
		}
		else {
			$elementId = 0;
		}

		/** @var $element SDElement */
		$element = new SDElement( $template->type, $context, $elementId );

		foreach($template as $propertyName => $propertyValue) {
			if(isset($data->{"$propertyName"})) {
				$propertyValue = $data->{"$propertyName"};
			}

			if(!in_array( $propertyName, self::$excludedNames )) {
				if(is_object($propertyValue) && isset($propertyValue->{"@value"})) {
					$propertyValue = $propertyValue->{"@value"};
				}
				/** @var $property SDElementProperty */
				$property = new SDElementProperty( $propertyName, $propertyValue );
				$element->addProperty( $property );
			}
			elseif($propertyName == '@context') {
				$context->addResource( $propertyValue, true, $element->getType() );
			}
		}

		$element->notify();

		return $element;
	}

	public function __toString() {
		return $this->toSDSJson();
	}

	/**
	 * get SDS compatible json representation of this object
	 * @return string
	 */
	public function toSDSJson() {
		$data = new stdClass();

		if( !empty( $this->id ) ) {
			$data->id = $this->id;
		}
		$data->type = $this->getType();

		/** @var $property SDElementProperty */
		foreach($this->properties as $property) {

			if ( $this->isPropertyVisible( $property ) )
				$data->{$property->getName()} = $property->toSDSJson();
		}

		return json_encode( $data );
	}

	public function update(array $params) {
		/** @var $property SDElementProperty */
		foreach($this->properties as $property) {
			$value = (isset($params[$property->getName()])) ? $params[$property->getName()] : null;
			$property->setValueFromRequest($value);
		}
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

	public function getRendererNames() {
		return array( 'sdelement_'.$this->type, 'sdelement_default' );
	}

	/**
	 * Return current object's page url. For the default rendering context this method returns the address defined in schema:url
	 * property when it is not empty. In any other case address of the SDS special page with object details is returned.
	 * @param $context - SDS rendering context
	 * @return String
	 */
	public function getObjectPageUrl( $context ) {
		if ( $context == SD_CONTEXT_DEFAULT ) {
			$url = $this->getUrl();
			if ( !empty( $url ) ) {
				if ( preg_match( '/^http(s)?:/', $url, $matches ) > 0 ) {
					$title = Title::newFromText( $url );
					if( $title instanceof Title ) {
						return $title->getFullUrl();
					}
				}
				return $url;
			}
		}
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
