<?php

class PhalanxHooks extends WikiaObject {
	function __construct() {
		parent::__construct();
		F::setInstance( __CLASS__, $this );
	}

	/**
	 * Add a link to central:Special:Phalanx from Special:Contributions/USERNAME
	 * if the user has 'phalanx' permission
	 * @param $id Integer: user ID
	 * @param $nt Title: user page title
	 * @param $links Array: tool links
	 * @return boolean true
	 */
	public function loadLinks( $id, $nt, &$links ) {
		$this->wf->profileIn( __METHOD__ );

		if ( $this->wg->User->isAllowed( 'phalanx' ) ) {
			$links[] = Linker::makeKnownLinkObj(
				GlobalTitle::newFromText( 'Phalanx', NS_SPECIAL, WikiFactory::COMMUNITY_CENTRAL ),
				'PhalanxBlock',
				wfArrayToCGI(
					array(
						'wpPhalanxTypeFilter[]' => '8',
						'wpPhalanxCheckBlocker' => $nt->getText()
					)
				)
			);
		}

		$this->wf->profileOut( __METHOD__ );
		return true;
	}

	/**
	 * Performs spam check for 3rd party extension. Third parameter will be provided with matching block data
	 *
	 * @param $text string content to check for spam
	 * @param $typeId int block type (see Phalanx::TYPE_* constants)
	 * @param $blockData array array to be provided with matching block details (pass as a reference)
	 * @return boolean spam check result
	 *
	 * @author macbre
	 */
	public function onSpamFilterCheck($text, $typeId, &$blockData) {
		wfProfileIn(__METHOD__);

		if ($text === '') {
			wfProfileOut(__METHOD__);
			return true;
		}

		// get type ID -> type mapping
		$types = Phalanx::getAllTypeNames();
		$ret = true;

		if (isset($types[$typeId])) {
			$type = $types[$typeId];

			$service = new PhalanxService();

			// get info about the block that was applied
			$service->setLimit(1);
			$res = $service->match($type, $text);

			if (is_object($res)) {
				$blockData = (array) $res;
			}

			$ret = ($res === 1);
		}

		if ($ret === false) {
			wfDebug(__METHOD__ . ": spam check blocked '{$text}'\n");
		}

		wfProfileOut(__METHOD__);
		return $ret;
	}
}
