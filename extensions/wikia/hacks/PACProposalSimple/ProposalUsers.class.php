<?php

class ProposalUsers {

	protected $fakeData = array(
		1 => array(
			array( 'userId' => 1, 'userName' => 'User1' ),
			array( 'userId' => 2, 'userName' => 'User2' ),
			array( 'userId' => 3, 'userName' => 'User3' )
		),
		2 => array(
			array( 'userId' => 1, 'userName' => 'User1' ),
			array( 'userId' => 4, 'userName' => 'AnonUser4' ),
			array( 'userId' => 5, 'userName' => 'User5' ),

		)
	);


	public function getList( $wikiId ) {
		if( empty( $this->fakeData[ $wikiId ]) ) {
			throw new WikiaException( 'Unknown Wiki ID' );
		}

		return $this->fakeData[ $wikiId ];
	}
}