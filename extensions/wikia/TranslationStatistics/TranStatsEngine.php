<?php

class TransStatsEngine {

	private $inputFile;
	private $groupList = array( 'EditAccount' );
	private $allMessages = array();

	private function processProductList() {
		
	}

	public function buildMsgs() {
		global $IP;

		// @TODO add cache here?

		foreach ( $this->groupList as $group ) {
			$messages = array();

			$defaults = array(
					'group' => $group,
					'languages' => array( 'en' )
					);


			// @TODO make this not be wikia-specific
			include( "$IP/extensions/wikia/$group/Special$group.i18n.php" ); 

			// collect messages
			$this->allMessages = array_merge( $this->allMessages, array_fill_keys( array_keys( $messages['en'] ), $defaults ) );

			// collect meta-information
			$this->allGroups[$group] = array(
				'total' => count( $messages['en'] ),
				'translated' => array(),
			);
		}

		return true;
	}


	public function calculateState() {
		$dbr = wfGetDB( DB_SLAVE );

		$dbr->select( 'page', array( 'page_namespace' => NS_MEDIAWIKI, 'page_title LIKE "%/%"' ) );

		while ( $translation = $dbr->fetchObject( $res ) ) {
			$translationData = explode( $translation->page_title, '/' );

			if ( empty( $this->allMessages[$translationData[0]] ) ) {
				// not a registered message, move on to the next one
				continue;
			}

			$this->incrementCounters( $translationData[0], $translationData[1] );
		}

		die( var_dump( $this->allMessages ) );
	}

	/** GETTERS **/

	public function getLangStats( $lang ) {
		return $ret;
	}

	public function getGroupStats( $group ) {
		$done = $this->allGroups[$group];
		return $done;
	}

	/** INCREMENTERS **/

	private function incrementCounters( $msg, $lang ) {
			$group = $this->almessages[$msg]['group'];

                        $this->allMessages[$msg]['languages'][] = $lang;
                        $this->allGroups[$group]['translated'][$lang]++; // ProductStats
	}
}
