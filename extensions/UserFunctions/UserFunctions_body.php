<?php

class ExtUserFunctions {

	/**
	 * @param $parser Parser
	 * @return bool
	 */
	function clearState(&$parser) {
		$parser->pf_ifexist_breakdown = array();
		return true;
	}

        /**
         * @param $parser Parser
         * @return $obj User
         */
	private function getUserObj($parser) {
		$obj = $parser->getOptions()->mUser;
		return $obj;
	}

	/**
	 * @param $parser Parser
	 * @param $frame PPFrame
	 * @param $args array
	 * @return string
	 */
	function ifanonObj( &$parser, $frame, $args ) {
		$myuser = $this->getUserObj($parser);
		$parser->disableCache();

		if($myuser->isAnon()){
			return isset( $args[0] ) ? trim( $frame->expand( $args[0] ) ) : '';
		} else {
			return isset( $args[1] ) ? trim( $frame->expand( $args[1] ) ) : '';
		}
	}

	/**
	 * @param $parser Parser
	 * @param $frame PPFrame
	 * @param $args array
	 * @return string
	 */
	function ifblockedObj( &$parser, $frame, $args ) {
		$myuser = $this->getUserObj($parser);
		$parser->disableCache();

		if($myuser->isBlocked()){
			return isset( $args[0] ) ? trim( $frame->expand( $args[0] ) ) : '';
		} else {
			return isset( $args[1] ) ? trim( $frame->expand( $args[1] ) ) : '';
		}
	}

	/**
	 * @param $parser Parser
	 * @param $frame PPFrame
	 * @param $args array
	 * @return string
	 */
	function ifsysopObj( &$parser, $frame, $args ) {
		$myuser = $this->getUserObj($parser);
		$parser->disableCache();

		if($myuser->isAllowed('protect')){
			return isset( $args[0] ) ? trim( $frame->expand( $args[0] ) ) : '';
		} else {
			return isset( $args[1] ) ? trim( $frame->expand( $args[1] ) ) : '';
		}
	}

	/**
	 * @param $parser Parser
	 * @param $frame PPFrame
	 * @param $args array
	 * @return string
	 */
	function ifingroupObj( &$parser, $frame, $args ) {
		$myuser = $this->getUserObj($parser);
		$parser->disableCache();

		$grp = isset( $args[0] ) ? trim( $frame->expand( $args[0] ) ) : '';

		if($grp!=='' && in_array($grp,$myuser->getEffectiveGroups())){
			return isset( $args[1] ) ? trim( $frame->expand( $args[1] ) ) : '';
		}
		return isset( $args[2] ) ? trim( $frame->expand( $args[2] ) ) : '';
	}

	/**
	 * @param $parser Parser
	 * @param $alt string
	 * @return String
	 */
	function realname( &$parser, $alt = '' ) {
		$myuser = $this->getUserObj($parser);
		$parser->disableCache();

		if($myuser->isAnon() && $alt!=='') {
			return $alt;
		}
		return $myuser->getRealName();
	}

	/**
	 * @param $parser Parser
	 * @param $alt string
	 * @return String
	 */
	function username( &$parser, $alt = '' ) {
		$myuser = $this->getUserObj($parser);
		$parser->disableCache();

		if($myuser->isAnon() && $alt!=='') {
			return $alt;
		}
		return $myuser->getName();
	}

	/**
	 * @param $parser Parser
	 * @param $alt string
	 * @return String
	 */
	function useremail( &$parser, $alt = '' ) {
		$myuser = $this->getUserObj($parser);
		$parser->disableCache();

		if($myuser->isAnon() && $alt!=='') {
			return $alt;
		}
		return $myuser->getEmail();
	}

	/**
	 * @param $parser Parser
	 * @param $alt string
	 * @return String
	 */
	function nickname( &$parser, $alt = '' ) {
		$myuser = $this->getUserObj($parser);
		$parser->disableCache();

		if($myuser->isAnon()) {
			if ( $alt!=='') {
				return $alt;
			}
			return $myuser->getName();
		}
		$nickname = $myuser->getOption( 'nickname' );
		$nickname = $nickname === '' ? $myuser->getName() : $nickname;
		return $nickname;
	}

	/**
	 * @param $parser Parser
	 * @return string
	 */
	function ip( &$parser ) {
		$parser->disableCache();
		return wfGetIP();
	}

}
