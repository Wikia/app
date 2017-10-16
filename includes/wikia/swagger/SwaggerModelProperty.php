<?php
class SwaggerModelProperty {
	const TYPE_ARRAY = 'array';

	private static $primitives = [self::TYPE_ARRAY, 'integer', 'number', 'string', 'boolean'];

	public $name;
	public $type;
	public $description;
	public $required;
	public $allowableValues;
	public $items;

	public function __construct($name, $property, $isRequired) {
		$this->name = $name;
		$this->required = $isRequired;
		$this->description = $property->description ?: null;
		$this->type = $this->parseType($property);
		$this->items = $this->parseItems($property);
	}

	private function parseType($property) {
		if (isset($property->type)) {
			return $property->type;
		} elseif (isset($property->{'$ref'})) {
			return $this->parseRefType($property->{'$ref'});
		}

		return null;
	}

	private function parseRefType($ref) {
		$offset = strrpos($ref, '/');
		if ($offset === false) {
			return $ref;
		}

		return substr($ref, $offset + 1);
	}

	private function parseItems($property) {
		if (!isset($property->items)) {
			return null;
		}

		return (object) [
			'type' => $this->parseType($property->items),
		];
	}

	public static function isPrimitiveType($type) {
		return in_array($type, self::$primitives);
	}
}