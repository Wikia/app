<?php
class WAMPageModel extends WikiaModel {
	const ITEMS_PER_PAGE = 20;

	public function getItemsPerPage() {
		return self::ITEMS_PER_PAGE;
	}
}
