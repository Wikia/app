<?php

/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterWidgetSearch extends DataCenterWidget {

	/* Private Static Members */

	private static $defaultParameters = array(
		/**
		 * XML ID attribute of widget
		 * @datatype	string
		 */
		'id' => 'search',
		/**
		 * CSS class of widget
		 * @datatype	string
		 */
		'class' => 'widget-search',
		/**
		 * Data Source
		 * @datatype	DataCenterComponent
		 */
		'component' => null,
		/**
		 * Range of records to show
		 * @datatype	integer
		 */
		'paging' => array( 'limit' => 10, 'offset' => 0 ),
	);

	private static $defaultAttributes = array(
		/**
		 * Default XML attributes for table
		 */
		'table' => array(
			'width' => '100%',
			'cellpadding' => 5,
			'cellspacing' => 0,
			'border' => 0,
		),
		/**
		 * Default XML attributes for heading cell
		 */
		'heading' => array(
			'align' => 'left',
		),
		/**
		 * Default XML attributes for checkbox cell
		 */
		'radio' => array(
			'class' => 'radio',
			'width' => '1%',
		),
		/**
		 * Default XML attributes for label cell
		 */
		'field' => array(
			'class' => 'field',
		),
		/**
		 * Default XML attributes for buttons cell
		 */
		'buttons' => array(
			'class' => 'buttons',
			'align' => 'right',
			'colspan' => 6
		),
		/**
		 * Default XML attributes for paging cell
		 */
		'paging' => array(
			'class' => 'paging',
			'align' => 'right',
			'colspan' => 6
		),
	);

	/* Static Functions */

	public static function render(
		array $parameters
	) {
		global $wgUser;
		// Gets current path
		$path = DataCenterPage::getPath();
		// Sets Defaults
		$parameters = array_merge( self::$defaultParameters, $parameters );
		// Begins widget
		$xmlOutput = parent::begin( $parameters['class'] );
		// Builds form attributes
		$formAttributes = array(
			'id' => 'form_search',
			'name' => 'form_search',
			'method' => 'post',
			'action' => DataCenterXml::url( array( 'page' => 'search' ) ),
		);
		// Begins form
		$xmlOutput .= DataCenterXml::open( 'form', $formAttributes );
		// Adds query field
		$xmlOutput .= DataCenterXml::tag(
			'input',
			array(
				'type' => 'text',
				'class' => 'query',
				'name' => 'meta[query]',
				'value' => (
					( $path['page'] == 'search' ) ?
					urldecode( $path['parameter'] ) : ''
				)
			)
		);
		// Adds search button
		$xmlOutput .= DataCenterXml::tag(
			'input',
			array(
				'type' => 'submit',
				'class' => 'search',
				'name' => 'meta[search]',
				'value' => DataCenterUI::message( 'label', 'search' )
			)
		);
		// Adds do field
		$xmlOutput .= DataCenterXml::tag(
			'input',
			array(
				'type' => 'hidden',
				'name' => 'do',
				'value' => 'search'
			)
		);
		// Adds token field
		$xmlOutput .= DataCenterXml::tag(
			'input',
			array(
				'type' => 'hidden',
				'name' => 'token',
				'value' => $wgUser->editToken()
			)
		);
		// Ends form
		$xmlOutput .= DataCenterXml::close( 'form' );
		// Ends widget
		$xmlOutput .= parent::end();
		// Returns results
		return $xmlOutput;
	}

	public static function redirect(
		$data
	) {
		global $wgOut;
		$path = DataCenterPage::getPath();
		if ( isset( $data['meta']['query'] ) ) {
			// Sanitize: allow alpha-numeric
			$queryContent = urlencode(
				preg_replace(
					'`\ +`',
					' ',
					preg_replace(
						'`[^a-z0-9]`i', '', $data['meta']['query']
					)
				)
			);
			// Sanitize: allow alpha-numeric as well as spaces, underscores,
			// dashes and periods
			$query = urlencode(
				preg_replace(
					'`\ +`',
					' ',
					preg_replace(
						'`[^a-z0-9\ \_\-\.]`i', '', $data['meta']['query']
					)
				)
			);
		}
		if ( isset( $queryContent ) && $queryContent != '' ) {
			// Shows search results
			$path['action'] = 'results';
			$path['parameter'] = $query;
		}
		$wgOut->redirect( DataCenterXml::url( $path ) );
	}
}