<?php
/**
 * Plans UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterViewPlans extends DataCenterView {

	/* Functions */

	public function main(
		$path
	) {
		$plans = DataCenterDB::getPlans(
			DataCenterDB::buildSort(
				'meta', 'plan', array( 'space', 'tense DESC' )
			)
		);
		$numPlans = DataCenterDB::numPlans();
		return DataCenterUI::renderLayout(
			'columns',
			array(
				DataCenterUI::renderLayout(
					'rows',
					array(
						DataCenterUI::renderWidget(
							'heading',
							array( 'message' => 'plans' )
						),
						DataCenterUI::renderWidget(
							'table',
							array(
								'rows' => $plans,
								'num' => $numPlans,
								'fields' => array(
									'name',
									'space' => array( 'field' => 'space_name' ),
									'tense' => array( 'format' => 'option' ),
								),
								'link' => array(
									'page' => 'plans',
									'action' => 'view',
									'type' => 'plan',
									'id' => '#id',
								),
							)
						),
					)
				),
			)
		);
	}
}