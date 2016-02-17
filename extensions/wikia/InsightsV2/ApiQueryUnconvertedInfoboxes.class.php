<?php

class ApiQueryUnconvertedInfoboxes extends ApiQueryBase {

	const XML_TAG_NAME = 'infobox';

	public function execute() {
		$data = PortableInfoboxQueryService::getNonPortableInfoboxes();

		foreach ( $data as $infobox ) {
			$this->getResult()->addValue( [ 'query', 'unconvertedinfoboxes' ], null, $infobox );
		}

		$this->getResult()->setIndexedTagName_internal( [ 'query', 'unconvertedinfoboxes' ], self::XML_TAG_NAME );
	}

	public function getVersion() {
		return __CLASS__ . '$Id$';
	}
}
