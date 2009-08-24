<?php
/**
 * Configuration UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterViewSettings extends DataCenterView {

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
							'heading', array( 'message' => 'settings' )
						),
						DataCenterUI::renderWidget(
							'body',
							array(
								'message' => 'important-settings',
								'style' => 'important'
							)
						)
					)
				)
			)
		);
	}
}