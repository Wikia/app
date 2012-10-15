<?php

/**
 * Class representing a question, which the voter will answer. There may be 
 * more than one question in an election.
 */
class SecurePoll_Question extends SecurePoll_Entity {
	var $options, $electionId;

	/**
	 * Constructor
	 * @param $context SecurePoll_Context
	 * @param $info Associative array of entity info
	 */
	function __construct( $context, $info ) {
		parent::__construct( $context, 'question', $info );
		$this->options = array();
		foreach ( $info['options'] as $optionInfo ) {
			$this->options[] = new SecurePoll_Option( $context, $optionInfo );
		}
	}

	/**
	 * Get a list of localisable message names.
	 */
	function getMessageNames() {
		$ballot = $this->getElection()->getBallot();
		return array_merge( $ballot->getMessageNames( $this ), array( 'text' ) );
		
	}

	/**
	 * Get the child entity objects.
	 */
	function getChildren() {
		return $this->options;
	}

	function getOptions() {
		return $this->options;
	}

	function getConfXml( $params = array() ) {
		$s = "<question>\n" . $this->getConfXmlEntityStuff( $params );
		foreach ( $this->getOptions() as $option ) {
			$s .= $option->getConfXml( $params );
		}
		$s .= "</question>\n";
		return $s;
	}
}
