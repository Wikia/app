<?php

/**
 * Common code for API modules that enumerate stuff and we add filter by coordinates to them
 */
class GeoDataQueryExtender {
	/**
	 * Prepares modifications to the query
	 *
	 * @param Array $params: Request parameters
	 * @param String $joinField: Field to use for joins
	 * @param String $useIndex: Index to force for query
	 * @return Array
	 */
	public static function alterQuery( $params, $joinField, $useIndex ) {
		$tables = array();
		$fields = array();
		$joins = array();
		$options = array( 'USE INDEX' => array() );
		$where = array();

		if ( isset( $params['withcoordinates'] ) || $params['withoutcoordinates'] ) {
			$tables[] = 'geo_tags';
			$joins['geo_tags'] = array( 'LEFT JOIN', "$joinField = gt_page_id" );
			$options['USE INDEX']['geo_tags'] = 'gt_page_id'; // Yes, MySQL is THAT stupid
			if ( isset( $params['withcoordinates'] ) ) {
				switch ( $params['withcoordinates'] ) {
					case 'primary':
						$where[] = 'gt_primary = 1';
						break;
					case 'secondary':
						$where[] = 'gt_primary = 0';
						$options['GROUP BY'] = 'page_id';
						break;
					case 'any':
						$where[] = 'gt_primary IS NOT NULL';
						$options['GROUP BY'] = 'page_id';
						break;
				}
			} else {
				$where[] = 'gt_primary IS NULL';
			}
		} elseif ( $useIndex ) {
			$options['USE INDEX']['page'] = $useIndex;
		}
		return array( $tables, $fields, $joins, $options, $where );
	}

	public static function getAllowedParams() {
		return array(
			'withcoordinates' => array(
				ApiBase::PARAM_TYPE => array( 'primary', 'secondary', 'any' ),
			),
			'withoutcoordinates' => false,
		);
	}

	public function getParamDescription() {
		return array(
			'withcoordinates' => 'Whether to return pages with primary, secondary or either coordinates',
			'withoutcoordinates' => 'Return only pages without coordinates',
		);
	}
}
