<?php

require_once( dirname(__FILE__) . '/../Maintenance.php' );

class CreateNewWiki extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->addArg( 'username', 'Founder username' );
		$this->addArg( 'name', 'Wiki name' );
		$this->addArg( 'domain', 'Wiki domain' );
		$this->addArg( 'language', 'Wiki language', false );
		$this->addArg( 'vertical', 'Vertical ID', false );

		$this->mDescription = "Create new wiki";
	}

	public function execute()
	{
		global $wgUser;
		$wgUser = User::newFromName( $this->getArg( 0 ) );

		if (!$wgUser) {
			echo( "Please provide valid username.\n" );
			return false;
		}

		$wikiName = $this->getArg( 1 );
		$wikiDomain = $this->getArg( 2 );
		$wikiLanguage = $this->getArg( 3, 'en' );
		$wikiVertical = $this->getArg( 4, 1 ); // entertainment by default
		$wikiCategories = [ 1, 2 ]; // a few random categories

		$newWiki = new CreateWiki($wikiName, $wikiDomain, $wikiLanguage, $wikiVertical, $wikiCategories);
		$newWiki->create();

		$wikiId = $newWiki->getWikiInfo( 'city_id' );
		echo( <<<EOT
Created new wiki:

	Name: {$wikiName}
	Domain: {$wikiDomain}
	ID: {$wikiId}

EOT
		);

		return true;
	}
}

$maintClass = "CreateNewWiki";
require_once( DO_MAINTENANCE );
