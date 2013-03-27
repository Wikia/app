<?php
class WAMPageModel extends WikiaModel {
	const ITEMS_PER_PAGE = 20;
	const VISUALIZATION_ITEMS_COUNT = 4;

	public function getItemsPerPage() {
		return self::ITEMS_PER_PAGE;
	}

	public function getVisualizationItemsCount() {
		return self::VISUALIZATION_ITEMS_COUNT;
	}
}
