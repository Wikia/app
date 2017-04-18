<?php
namespace RecentChanges;

use WikiaObject;
use LogPage;

/**
 * Class Dropdown provides content for dropdowns on Special:RecentChanges
 */
class Dropdown extends WikiaObject {
	/**
	 * Return formatted list of namespace options that can be passed to dropdown controller
	 * @return array
	 */
	public function getNamespaceOptions(): array {
		$nsList = $this->wg->ContLang->getFormattedNamespaces();
		$options = [];

		foreach ( $nsList as $index => $name ) {
			if ( $index >= NS_MAIN ) {
				$options[] = [
					'value' => $index,
					'label' => $index === NS_MAIN ? wfMessage( 'blanknamespace' )->escaped() : $name
				];
			}
		}

		return $options;
	}

	/**
	 * Returns formatted list of log type options that can be passed to dropdown
	 * @return array
	 */
	public function getLogTypeOptions(): array {
		$options = [];

		foreach ( $this->wg->LogTypes as $logType ) {
			if ( !empty( $logType ) ) {
				$logPage = new LogPage( $logType );

				$options[] = [
					'value' => $logType,
					'label' => $logPage->getName()->escaped()
				];
			}
		}

		return $options;
	}
}
