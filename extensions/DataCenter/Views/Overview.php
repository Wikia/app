<?php
/**
 * Overview UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterViewOverview extends DataCenterView {

	/* Functions */

	public function main(
		$path
	) {
		return DataCenterUI::renderLayout(
			'columns',
			array(
				DataCenterUI::renderLayout(
					'rows',
					array(
						DataCenterUI::renderWidget(
							'heading', array( 'message' => 'overview' )
						),
						DataCenterUI::renderWidget(
							'body',
							array(
								'message' => 'important-welcome',
								'style' => 'important'
							)
						)
					)
				)
			)
		);
	}
}