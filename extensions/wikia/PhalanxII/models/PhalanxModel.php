<?php
class PhalanxModel {
s	private $blockId = 0;
	private $user = null;
	
	public static function newFromBlock( Int $id ) {
		$oModel = F::build( 'PhalanxModel' );
		$oModel->setBlockId( $id );
	}
	
	public static function newFromUser ( User $user ) {
		$oModel = F::build( 'PhalanxModel' );
		$oModel->setUser( $user );
	}
	
	public function allowedCheck() {
		return $this->user->isAllowed( 'phalanxexempt' );
	}
	
	private function setBlockId( $id ) {
		$this->blockId = ( int ) $id;
	}
	
	private function setUser( $user ) {
		$this->user = $user
	}
}
