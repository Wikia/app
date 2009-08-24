<?php

/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterWidgetSearchResults extends DataCenterWidget {

	/* Private Static Members */

	private static $defaultParameters = array(
		/**
		 * XML ID attribute of widget
		 * @datatype	string
		 */
		'id' => 'searchresults',
		/**
		 * CSS class of widget
		 * @datatype	string
		 */
		'class' => 'widget-searchresults',
		/**
		 * Search terms
		 * @datatype	string
		 */
		'query' => null,
	);

	private static $targets = array(
		array(
			'class' => 'DataCenterDBAsset',
			'category' => 'asset',
			'type' => 'rack',
			'fields' => array( 'serial', 'asset' ),
			'table' => array(
				'fields' => array(
					'manufacturer',
					'model' => array( 'field' => 'name' ),
					'serial',
					'asset',
					'tense' => array( 'format' => 'option' ),
					'location' => array(
						'field' => 'location_name'
					)
				),
				'link' => array(
					'page' => 'assets',
					'type' => 'rack',
					'id' => '#id',
					'action' => 'view',
				)
			),
		),
		array(
			'class' => 'DataCenterDBAsset',
			'category' => 'asset',
			'type' => 'object',
			'fields' => array( 'serial', 'asset' ),
			'table' => array(
				'fields' => array(
					'manufacturer',
					'model' => array( 'field' => 'name' ),
					'serial',
					'asset',
					'tense' => array( 'format' => 'option' ),
					'location' => array(
						'field' => 'location_name'
					)
				),
				'link' => array(
					'page' => 'assets',
					'type' => 'object',
					'id' => '#id',
					'action' => 'view',
				)
			),
		)
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
		// Adds result type menu
		$currentTarget = null;
		$currentNum = null;
		$menuItems = array();
		foreach ( self::$targets as $target ) {
			$numMatches = DataCenterDB::numMatches(
				$target['category'],
				$target['type'],
				$target['fields'],
				$parameters['query']
			);
			if ( $numMatches == 0 ) {
				continue;
			}
			$fusedType = $target['category'] . '.' . $target['type'];
			if ( !$path['type'] ) {
				$path['type'] = $fusedType;
			}
			if ( $path['type'] == $fusedType ) {
				$currentTarget = $target;
				$currentNum = $numMatches;
				$state = 'current';
			} else {
				$state = 'normal';
			}
			$typePath = array_merge(
				$path,
				array( 'type' => $target['category'] . '.' . $target['type'] )
			);
			$menuItems[] = DataCenterXml::div(
				array( 'class' => 'type-' . $state ),
				DataCenterXml::link(
					DataCenterUI::message(
						'results',
						$target['category'] . '-' . $target['type'],
						$numMatches
					),
					$typePath
				)
			);
		}
		$resultItems = array();
		if ( !$currentTarget ) {
			$xmlOutput .= DataCenterUI::renderWidget(
				'body',
				array( 'message' => 'notice-no-results', 'style' => 'notice' )
			);
		}
		else {
			$joins = array();
			if ( $currentTarget['class'] == 'DataCenterDBAsset' ) {
				$joins = array_merge_recursive(
					DataCenterDB::buildJoin(
						'model', $currentTarget['type'], 'id',
						'asset', $currentTarget['type'], 'model',
						array( 'name', 'manufacturer' )
					),
					DataCenterDB::buildJoin(
						'facility', 'location', 'id',
						'asset', $currentTarget['type'], 'location',
						array( 'name' => 'location_name' )
					)
				);
			}
			// Gets search results
			$results = DataCenterDB::getMatches(
				$currentTarget['class'],
				$currentTarget['category'],
				$currentTarget['type'],
				$currentTarget['fields'],
				$parameters['query'],
				array_merge_recursive(
					$joins,
					DataCenterDB::buildRange( $path )
				)
			);
			// Adds types
			$xmlOutput .= DataCenterXml::div(
				array( 'class' => 'types' ), implode( $menuItems )
			);
			// Adds results
			$xmlOutput .= DataCenterXml::div(
				array( 'class' => 'results' ),
				DataCenterUI::renderWidget(
					'table',
					array_merge(
						$currentTarget['table'],
						array(
							'rows' => $results,
							'num' => $currentNum,
						)
					)
				)
			);
		}
		// Ends widget
		$xmlOutput .= parent::end();
		// Returns results
		return $xmlOutput;
	}
}