<?php

/**
 * Special page to display log entries
 */
class SpecialAdminLog extends IncludableSpecialPage {

	/**
	 * @var ServerAdminLogEntryPager
	 */
	protected $pager;

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'AdminLog' );
	}

	/**
	 * Execute. You know what this does!
	 *
	 * @param $par string Parameter
	 */
	public function execute( $par ) {
		$this->setHeaders();

		$this->pager = new ServerAdminLogEntryPager( $this->getContext() );

		if ( $par === null ) {
			// No channel, do a full overview
			$this->showOverview();
		} else {
			$this->showChannel( $par );
		}
	}

	/**
	 * Display the overview for all channels
	 */
	private function showOverview() {
		$out = $this->getOutput();
		$out->addHTML( $this->pager->getBody() );
	}

	/**
	 * Display information for one channel
	 *
	 * @param $par
	 * @throws ErrorPageError
	 */
	private function showChannel( $par ) {
		$channel = ServerAdminLogChannel::newFromCode( $par );
		if ( $channel === null ) {
			throw new ErrorPageError( 'serveradminlog-invalidchannel', 'serveradminlog-invalidchannel-msg', $par );
		}

		$out = $this->getOutput();
		$out->setPageTitle( $channel->getName() );

		$this->pager->setChannel( $channel->getId() );

		$out->addHTML( $this->pager->getBody() );


	}
}
