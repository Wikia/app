<?php

class UserPreferencesStats {
	// MediaWiki Title object
	private $title = null;

	// WikiaApp
	private $app = null;
	private $dbWikicities = null;

	public function __construct(Title $currentTitle = null) {
		$this->app = F::app();
		$this->title = $currentTitle;
	}

	/**
	 * @brief
	 * @details
	 * @author Marooned
	 *
	 * @return array
	 */
	public function getProperties() {
		wfProfileIn( __METHOD__ );

		if ( !$this->dbWikicities ) {
			$this->dbWikicities = wfGetDB( DB_SLAVE, array(), $this->app->wg->ExternalSharedDB );
		}
		$oRes = $this->dbWikicities->select(
			'user_properties',
			'distinct up_property',
			array(),
			__METHOD__,
			array('ORDER BY' => 'up_property')
		);

		$aProperties = array();
		while ( $oRow = $this->dbWikicities->fetchObject( $oRes ) ) {
			$aProperties[] = $oRow->up_property;
		}
		$this->dbWikicities->freeResult( $oRes );

		wfProfileOut( __METHOD__ );
		return $aProperties;
	}

	/**
	 * @brief
	 * @details
	 * @author Marooned
	 *
	 * @return array
	 */
	public function getDataForProps( $props ) {
		wfProfileIn( __METHOD__ );

		$aData = array();
		$sEmptyProp = wfMsg('userpreferencesstats-empty-property');

		if (!$this->dbWikicities) {
			$this->dbWikicities = wfGetDB( DB_SLAVE, array(), $this->app->wg->ExternalSharedDB );
		}
		foreach ( $props as $prop ) {
			$oRes = $this->dbWikicities->select(
				'user_properties',
				array( 'up_value', 'count(up_user) as count' ),
				array( 'up_property' => $prop ),
				__METHOD__,
				array( 'GROUP BY' => 'up_value')
			);

			while ( $oRow = $this->dbWikicities->fetchObject( $oRes ) ) {
				$aData[$prop][$oRow->up_value != '' ? $oRow->up_value : $sEmptyProp] = $oRow->count;
			}
			$this->dbWikicities->freeResult( $oRes );
		}

		wfProfileOut( __METHOD__ );
		return $aData;
	}
}