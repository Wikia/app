<?php
namespace RecentChanges;

use WikiaController;

class Controller extends WikiaController {
	const TYPE_NAMESPACE = 'namespace';
	const TYPE_LOGTYPE = 'logtype';

	public function saveFilters() {
		$this->checkWriteRequest();
		$this->skipRendering();

		$type = $this->request->getVal( 'type' );
		$filters = $this->request->getArray( 'filters' );

		switch ( $type ) {
			case static::TYPE_LOGTYPE:
				$this->getContext()->getUser()->setGlobalPreference(
					SpecialPage::LOGTYPE_PREF,
					$filters
				);
				break;
			case static::TYPE_NAMESPACE:
				$this->getContext()->getUser()->setGlobalPreference(
					SpecialPage::NS_PREF,
					$filters
				);
				break;
		}
	}
}
