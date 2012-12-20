<?php

abstract class FooterMenuItemBaseService extends WikiaService 	{
	protected $rawData;

	// currently used only as view; renders view using inheritance
	public function render() {
		echo $this->app->getView(get_class($this), 'index', array('data'=> $this->rawData));
	}

	public function setRawData($data) {
		$this->rawData = $data;
	}

}
