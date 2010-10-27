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

		$raw_file = file_get_contents( 'extensions.txt' );
		$groups = explode( "\n\n", $raw_file );

		foreach ( $groups as $group ) {
			$messages = array();

			// @TODO make this not be wikia-specific
                        $group = explode( "\n", $group );

                        $name = str_replace( ' ', '', array_shift( $group ) );

			$defaults = array(
					'group' => $name,
					'languages' => array( 'en' )
					);


			$params = array();

			foreach ( $group as $line ) {
				$line_raw = explode( '=', $line );
				if ( count( $line_raw ) > 1 ) {
					$param_name = trim( $line_raw[0] );
					$param_value = trim( $line_raw[1] );
					$params[$param_name] = $param_value;
				}
			}

			if ( isset( $params['file'] ) ) {
				$res = include( "$IP/extensions/wikia/" . $params['file'] ); 
			} else {
				$res = include( "$IP/extensions/wikia/$name/$name.i18n.php" ); 
			}

			if ( !$res ) {
				echo "ERROR INCLUDING FILE $name\n";
				continue;
			}

			// collect messages
			$this->allMessages = array_merge( $this->allMessages, array_fill_keys( array_keys( $messages['en'] ), $defaults ) );

			// collect meta-information
			$this->allGroups[$name] = array(
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
