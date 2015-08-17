<?php

abstract class WikiaHubsModuleEditableService extends WikiaHubsModuleService
{
	abstract public function getFormFields();

	public function renderEditor($data) {
		return $this->getView('editor', $data);
	}

	public function filterData($data) {
		$filteredData = array_intersect_key($data, $this->getFormFields());
		$filteredData = array_filter($filteredData, function ($value) { return !empty($value); });
		return $filteredData;
	}

}
