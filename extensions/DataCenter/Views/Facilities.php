<?php
/**
 * Facilities UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterViewFacilities extends DataCenterView {

	/* Functions */

	public function history(
		$path
	) {
		if ( $path['type'] == 'location' ) {
			$facility = DataCenterDB::getLocation( $path['id'] );
		} else if ( $path['type'] == 'space' ) {
			$facility = DataCenterDB::getSpace( $path['id'] );
		} else {
			return null;
		}
		return DataCenterUI::renderLayout(
			'columns',
			array(
				DataCenterUI::renderLayout(
					'rows',
					array(
						DataCenterUI::renderWidget(
							'heading',
							array(
								'message' => 'history-type',
								'subject' => DataCenterUI::message(
									'type', $path['type']
								)
							)
						),
						DataCenterUI::renderWidget(
							'history',
							array( 'component' => $facility )
						),
					)
				),
			)
		);
	}
}