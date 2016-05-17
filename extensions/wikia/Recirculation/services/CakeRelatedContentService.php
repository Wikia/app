<?php

class CakeRelatedContentService {

	/**
	 * @param $title
	 * @param $ignore
	 * @return RecirculationContent[]
	 */
	public function getContentRelatedTo($title, $ignore=null) {
		return [new RecirculationContent("", "", "", $title, "", "")];
	}
}
