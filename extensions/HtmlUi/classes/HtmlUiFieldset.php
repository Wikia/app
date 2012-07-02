<?php

class HtmlUiFieldset extends HtmlUiFormElementCollection implements HtmlUiFormElement {
	
	/* Protected Members */
	
	protected $id;
	
	/* Protected Methods */
	
	protected function getDefaultOptions() {
		return array();
	}
	
	/* Methods */
	
	public function getId() {
		return $this->id;
	}
	
	public function setId( $id ) {
		return $this->id = $id;
	}
	
	public function render() {
		$template = new HtmlUiTemplate( 'extensions/HtmlUi/templates/HtmlUiFieldset.php' );
		return $template->render( array(
			'id' => $this->id,
			'elements' => $this->elements
		) );
	}
}
