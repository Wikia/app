<?php
/**
 * Overview UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterViewSearch extends DataCenterView {

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
							'heading', array( 'message' => 'search-results' )
						),
						DataCenterUI::renderWidget(
							'body',
							array(
								'message' => 'notice-no-results',
								'style' => 'notice'
							)
						)
					)
				)
			)
		);
	}

	public function results(
		$path
	) {
		return DataCenterUI::renderLayout(
			'columns',
			array(
				DataCenterUI::renderLayout(
					'rows',
					array(
						DataCenterUI::renderWidget(
							'heading', array( 'message' => 'search-results' )
						),
						DataCenterUI::renderWidget(
							'searchresults',
							array( 'query' => $path['parameter'] )
						)
					)
				)
			)
		);
	}
}