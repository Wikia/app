<?php

class TransStatsEngine {

	private $inputFile;
	private $allMessages = array();
	private $allGroups = array();
	private $project;

	function __construct( $project = NS_MEDIAWIKI ) {
		$this->project = $project;
	}

	private function processProductList() {
		
	}

	public function buildMsgs() {
		global $IP;

		// @TODO add cache here?

		$raw_file = file_get_contents( 'extensions.txt' );
		$groups = explode( "\n\n", $raw_file );

		foreach ( $groups as $group ) {
			$messages = array();
			$params = array();

                        $group = explode( "\n", $group );

                        $name = array_shift( $group );
			$defaultFile = str_replace( ' ', '', $name );

			$defaults = array(
					'group' => $name,
					'languages' => array( 'en' )
					);

			foreach ( $group as $line ) {
				$line_raw = explode( '=', $line );
				if ( count( $line_raw ) > 1 ) {
					$param_name = trim( $line_raw[0] );
					$param_value = trim( $line_raw[1] );
					$params[$param_name] = $param_value;
				}
			}

			// @TODO make this not be wikia-specific
			if ( isset( $params['file'] ) ) {
				$res = include( "$IP/extensions/wikia/" . $params['file'] ); 
			} else {
				$res = include( "$IP/extensions/wikia/$defaultFile/$defaultFile.i18n.php" ); 
			}

			if ( !$res ) {
				echo "ERROR INCLUDING FILE FOR GROUP $name\n";
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

		$res = $dbr->select( 'page', array( 'page_title' ), array( 'page_namespace' => $this->project, 'page_title LIKE "%/%"' ) );

		while ( $translation = $dbr->fetchObject( $res ) ) {
			$translationData = explode( '/', $translation->page_title );
			$translationData[0] = strtolower( $translationData[0] );
			if ( empty( $this->allMessages[$translationData[0]] ) ) {
				// not a registered message, move on to the next one
				continue;
			}

			if ( $translationData[1] == 'qqq' ) {
				// translator hints, not a real language
				continue;
			}

			$this->incrementCounters( $translationData[0], $translationData[1] );
		}

		die( var_dump( $this->allGroups ) );
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
			$group = $this->allMessages[$msg]['group'];

                        $this->allMessages[$msg]['languages'][] = $lang;
			if ( !isset( $this->allGroups[$group]['translated'][$lang] ) ) {
				$this->allGroups[$group]['translated'][$lang] = 0;
			}
                        $this->allGroups[$group]['translated'][$lang]++; // ProductStats
	}
}
