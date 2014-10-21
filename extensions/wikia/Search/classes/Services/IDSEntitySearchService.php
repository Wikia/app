<?php

namespace Wikia\Search\Services;

class IDSEntitySearchService extends EntitySearchService {

	protected $fields = [ "id", "url" ];

	protected function prepareQuery( $query ) {
		$select = $this->getSelect();
		$select->setFields( $this->fields );

		$dismax = $select->getDisMax();
		$dismax->setQueryParser( 'edismax' );

		$select->setQuery( $query );
		$select->setRows( 999999 );

		$select->createFilterQuery( 'ids' )->setQuery( '+id:(' . implode( ' ', $this->ids ) . ')' );
		if ( !empty( $this->categories ) ) {
			$cat = array_map( [ $this, "sanitizeQuery" ], $this->categories );
			$select->createFilterQuery( 'cat' ) ->setQuery(' +categories_mv_en:(' . implode( ' AND ', $cat ) . ')' );
		}

		return $select;
	}

	public function setFields( $fields ) {
		if ( !empty( $fields ) ) {
			if ( !in_array( "id", $fields ) ) {
				$fields [ ] = "id";
			}
			$this->fields = $fields;
		}
		return $this;
	}

	protected function consumeResponse( $response ) {
		$data = [ ];
		foreach ( $response as $item ) {
			$data[ $item[ "id" ] ] = $item->getFields();
		}

		return $data;
	}

}