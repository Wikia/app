<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia.com
 * @version: 1.0
 */
class ChatBanListSpecial extends SpecialRedirectToSpecial
{

	function __construct() {
		parent::__construct( 'ChatBanList', 'chatbanlist' );
	}

	public function execute( $subpage ) {
		global $wgOut, $wgJsMimeType, $wgResourceBasePath;

		wfProfileIn( __METHOD__ );

		$scriptSource = "{$wgResourceBasePath}/resources/wikia/libraries/jquery/datatables/jquery.dataTables.min.js";

		$wgOut->setPageTitle( wfMessage( 'chatbanlist' )->text() );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );
		$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$scriptSource}\"></script>\n" );
		$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/Listusers/css/table.scss' ) );

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$wgOut->addHTML( $oTmpl->render( "ChatBanList" ) );

		wfProfileOut( __METHOD__ );
	}

}

