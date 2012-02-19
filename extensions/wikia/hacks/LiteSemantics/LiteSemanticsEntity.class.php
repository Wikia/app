<?php
/**
 * Lite Semantics entities
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */

class LiteSemanticsEntity {
	protected $name = null;
	protected $value = null;

	function __construct( $name, $value = null ){
		$this->name = $name;
		$this->value = $value;
	}

	public function getName(){
		return $this->name;
	}

	public function setName( $name ){
		$this->name = $name;
	}

	public function getValue(){
		return $this->value;
	}

	public function setValue( $value ){
		$this->value = $value;
	}
}

class LiteSemanticsAttribute extends LiteSemanticsEntity{
	function __construct( $name, $value = null){
		parent::__construct( $name, $value );
	}

	function __toString(){
		return $this->name . ( $value !== null ) ? '="' . str_replace( '"', '\"', $value ) . '"' : '';
	}
}

class LiteSemanticsProperty extends LiteSemanticsEntity{
	protected $attributes = null;
	
	function __construct( $value = null ){
		parent::__construct( __CLASS__, $value );
		$this->attributes = new LiteSemanticsHashCollection();
	}

	public function getType(){
		return $this->name;
	}

	public function setType( $type ){
		$this->name = $type;
	}

	public function hasAttributes(){
		return $this->attributes->count() > 0;
	}

	public function getAttribute( $name ){
		return $this->attributes->getItem( $name );
	}

	public function setAttribute( $name, LiteSemanticsAttribute $value = null ){
		$this->attributes->storeItem( $name, new LiteSemanticsAttribute( $name, $value ) );	
	}

	public function removeAttribute( $name ){
		$this->attributes->removeItem( $name );
	}

	function __toString(){
		return $this->getValue();
	}
}

class LiteSemanticsData extends LiteSemanticsEntity{
	protected $attributes = null;
	protected $properties = null;
	protected $startIndex = null;
	protected $endIndex = null;
	
	function __construct( $content = null, $startIndex = null, $endIndex = null ){
		parent::__construct( /*uniqid(*/__CLASS__/*)*/, $content );
		$this->attributes = new LiteSemanticsHashCollection();
		$this->properties = new LiteSemanticsHashCollection();
		$this->startIndex = $startIndex;
		$this->endIndex = $endIndex;
	}
	
	public function hasAttributes(){
		return $this->attributes->count() > 0;
	}

	public function getAttribute( $name ){
		return $this->attributes->getItem( $name );
	}

	public function setAttribute( $name, LiteSemanticsAttribute $value = null ){
		$this->attributes->storeItem( $name,  $value );	
	}

	public function removeAttribute( $name ){
		$this->attributes->removeItem( $name );
	}

	public function hasProperties(){
		return $this->properties->count() > 0;
	}

	public function getProperty( $name ){
		return $this->properties->getItem( $name );
	}

	public function setProperty( $name, LiteSemanticsProperty $value = null ){
		$this->properties->storeItem( $name, $value );	
	}

	public function removeProperty( $name ){
		$this->properties->removeItem( $name );
	}

	public function getStartIndex(){
		return $this->startIndex;
	}

	public function getEndIndex(){
		return $this->endIndex;
	}
}

//TODO: implement ondemand loading from cache/DB
class LiteSemanticsDocument extends LiteSemanticsEntity{
	protected $title = null;
	protected $data = null;
	protected $parsing = false;

	function __construct( $text, Title $title = null, $parsing = false /* avoid loading from cache/DB */ ){
		parent::__construct( __CLASS__, $text );
		$this->title = $title;
		$this->data = new LiteSemanticsListCollection();
		$this->parsing = $parsing;
	}

	public function hasData(){
		return $this->data->count() > 0;
	}

	public function getData(){
		return $this->data;
	}

	public function addItem( LiteSemanticsData $data ){
		$this->data->addItem( $data );
	}

	public function setItem( $index, LiteSemanticsData $data ){
		$this->data->setItem( $index, $data );
	}

	public function getItem( $index ){
		return $this->data->getItem( $index );
	}

	public function removeItem( $index ){
		$this->attributes->removeItem( $index );
	}

	public function process(){
		$text = $this->getValue();

		//iterate in inverse order to not invalidate offset indexes of data in $text
		for ( $x = $this->data->count() - 1; $x >= 0; $x-- ) {
			$item = $this->data[$x];
			$startIndex = $item->getStartIndex();
			$length = $item->getEndIndex() - $startIndex;
			$dataOutput = $item->getValue();
			
			//give a chance to extensions to alter the rendered output of a data block
			F::app()->runHook( 'LiteSemanticsRenderData', array( $this->title, $item, &$dataOutput ) );

			$text = substr_replace( $text, $dataOutput, $startIndex, $length );
		}

		return $text;
	}
}