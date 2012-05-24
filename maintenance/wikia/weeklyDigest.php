<?php

require_once( dirname(__FILE__) . '/../Maintenance.php' );

class WeeklyDigest extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->addOption( 'debug', 'Enable debug log' );
		$this->addOption( 'users', 'Send emails to comma separated list of users' );
		$this->addOption( 'usedb', 'Use comma separated list of database names' );
		$this->addOption( 'clear', 'Marking all pages as "visited"' );
		$this->addOption( 'regen', 'Regenerate global watchlist for all Wikis' );
		$this->addOption( 'mailto', 'Set debug mail' );
		$this->addOption( 'update', 'Update local watchlist - mark all pages as visited on Wikia. Use this option with --page and --namespace options' );
		$this->addOption( 'page', 'Mark this page as visited' );
		$this->addOption( 'namespace', 'Namespace of page' );	
		$this->addOption( 'send', 'Prepare email for user and send email. Use this option with --users option' );
		$this->mDescription = "Sending global watchlist to users";
	}

	public function execute() {
		if ( class_exists('GlobalWatchlistBot') ) {
			
			// defaults
			$bDebugMode = $bClearMode = $bUpdateMode = $bSendMode = $bRegenMode = false;
			$aUserNames = $aUseDB = array();
			$sDebugMailTo = $sPage = '';
			$sNamespace = null;
			
			// options
			if( $this->hasOption( 'debug' ) ) {
				$bDebugMode = true;
			} 
			
			if ( $this->hasOption( 'clear' ) ) {
				$bClearMode = true;
			} elseif ( $this->hasOption( 'update' ) ) {
				$bUpdateMode = true;
			} elseif ( $this->hasOption( 'send' ) ) {
				$bSendMode = true;
			} elseif ( $this->hasOption( 'regen' ) ) {
				$bRegenMode = true;
			}
			
			if ( $this->hasOption( 'users' ) ) {
				$aUserNames = explode( ',', $this->getOption( 'users' ) );
			} 
			if ( $this->hasOption( 'usedb' ) ) {
				$aUseDB = explode( ',', $this->getOption( 'usedb' ) );
			} 
			if ( $this->hasOption( 'mailto' ) ) {
				$sDebugMailTo = $this->getOption( 'mailto' );
			} 
			if ( $this->hasOption( 'page' ) ) {
				$sPage = $this->getOption( 'page' );
			} 
			if ( $this->hasOption( 'namespace' ) ) {
				$sNamespace = $this->getOption( 'namespace' );
			}
			
			$oWatchlistBot = new GlobalWatchlistBot( $bDebugMode, $aUserNames, $aUseDB );
			$oWatchlistBot->setDebugMailTo( $sDebugMailTo );

			if ( $bClearMode ) {
				$this->output( "Run weekly digest with --clear option ... \n" );
				$oWatchlistBot->clear();
			} elseif ( $bRegenMode ) {
				$this->output( "Run weekly digest with --regen option ... \n" );
				$oWatchlistBot->regenerate();			
			} elseif ( $bUpdateMode ) {
				$this->output( "Run weekly digest with --update option for page {$sPage} and namespace {$sNamespace} ... \n" );
				if ( !empty( $sPage ) && !is_null( $sNamespace ) ) {
					if ( ! $oWatchlistBot->updateLocalWatchlist( $sPage, $sNamespace ) ) {
						print "Update error \n"; 
						exit(1);						
					}
				} else {
					print "Invalid title \n"; 
					exit(1);
				}
			} elseif ( $bSendMode ) { 
				$this->output( "Run weekly digest with --send option for user {$this->getOption( 'users' )} ... \n" );
				if ( ! $oWatchlistBot->send() ) {
					print "Send failed \n";
					exit(1);
				}
			} else {
				$this->output( "Run weekly digest ...\n" );
				$oWatchlistBot->updateLog( );
				$emailsSent = $oWatchlistBot->run();
				//
				$oUser = User::newFromId(115748); //Moli.wikia
				$oUser->load();
				$oUser->sendMail( 'Global watchlist has finished', 'Global watchlist has finished', 'Wikia <community@wikia.com>', null, 'GlobalWatchlist' );

				$oWatchlistBot->updateLog( );
				$this->output( "Done!\n" );
			}
		}
		else {
			$this->output( "GlobalWatchlist extension is not installed.\n" );
			exit(1);
		}
	}
}

$maintClass = "WeeklyDigest";
require_once( DO_MAINTENANCE );
