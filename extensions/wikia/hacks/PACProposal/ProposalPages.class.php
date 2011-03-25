<?php

class ProposalPages {

	protected $fakeData = array(
		1 => array(
			array( 'pageName' => 'Page 1', 'pageUrl' => '#' ),
			array( 'pageName' => 'Page 2', 'pageUrl' => '#' ),
			array( 'pageName' => 'Page 3', 'pageUrl' => '#' ),
		),
		2 => array(
			array( 'pageName' => 'Page 4', 'pageUrl' => '#' ),
			array( 'pageName' => 'Page 5', 'pageUrl' => '#' ),
			array( 'pageName' => 'Page 6', 'pageUrl' => '#' ),
		),
		3 => array(
			array( 'pageName' => 'Page 7', 'pageUrl' => '#' ),
			array( 'pageName' => 'Page 8', 'pageUrl' => '#' ),
		),
		4 => array(
			array( 'pageName' => 'Page 9', 'pageUrl' => '#' ),
		),
		5 => array(
			array( 'pageName' => 'Foo Page', 'pageUrl' => '#' ),
		)
	);

	public function getList( $userId ) {
		if( empty( $this->fakeData[ $userId ]) ) {
			throw new WikiaException( 'Unknown User ID' );
		}

		return $this->fakeData[ $userId ];
	}

}
