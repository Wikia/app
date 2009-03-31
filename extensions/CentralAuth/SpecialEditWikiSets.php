<?php
/**
 * Special page to allow managing global groups
 * Prototype for a similar system in core.
 *
 * @addtogroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "CentralAuth extension\n";
	exit( 1 );
}


class SpecialEditWikiSets extends SpecialPage
{
	function __construct() {
		parent::__construct('EditWikiSets', 'globalgrouppermissions');
		wfLoadExtensionMessages('SpecialCentralAuth');
	}

	function getDescription() {
		return wfMsg( 'centralauth-editset' );
	}

	function userCanExecute($user) {		
		global $wgUser;
		return $wgUser->isAllowed( 'globalgrouppermissions' );
		$globalUser = CentralAuthUser::getInstance( $user );
		
		## Should be a global user
		if (!$globalUser->exists() || !$globalUser->isAttached()) {
			return false;
		}
		
		## Permission MUST be gained from global rights.
		return $globalUser->hasGlobalPermission( 'globalgrouppermissions' );
	}

	function execute( $subpage ) {
		global $wgRequest, $wgOut, $wgUser;

		if( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}

		$this->setHeaders();

		if( $subpage && !is_numeric( $subpage ) ) {
			$set = WikiSet::newFromName( $subpage );
			if( $set ) {
				$subpage = $set->getID();
			} else {
				$wgOut->setPageTitle( wfMsg( 'error' ) );
				$error = wfMsgExt( 'centralauth-editset-notfound', array( 'escapenoentities' ), $subpage );
				$this->buildMainView( "<strong class='error'>{$error}</strong>" );
				return;
			}
		}

		if( ( $subpage || $subpage === '0' ) && $wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) ) ) {
			$this->doSubmit( $subpage );
		} else if( ( $subpage || $subpage === '0' ) && is_numeric( $subpage ) ) {
			$this->buildSetView( $subpage );
		} else {
			$this->buildMainView();
		}
	}

	function buildMainView( $msg = '' ) {
		global $wgOut, $wgScript, $wgUser;
		$sk = $wgUser->getSkin();

		$legend = wfMsg( 'centralauth-editset-legend' );
		$wgOut->addHTML( "<fieldset><legend>{$legend}</legend>" );
		if( $msg )
			$wgOut->addHTML( $msg );
		$wgOut->addWikiMsg( 'centralauth-editset-intro' );
		$wgOut->addHTML( '<ul>' );

		$sets = WikiSet::getAllWikiSets();
		foreach( $sets as $set ) {
			$text = wfMsgExt( 'centralauth-editset-item', array( 'parseinline' ), $set->getName(), $set->getID() );
			$wgOut->addHTML( "<li>{$text}</li>" );
		}

		$target = SpecialPage::getTitleFor( 'EditWikiSets', '0' );
		$newlink = $sk->makeLinkObj( $target, wfMsgHtml( 'centralauth-editset-new' ) );
		$wgOut->addHTML( "<li>{$newlink}</li>" );

		$wgOut->addHTML( '</ul></fieldset>' );
	}

	function buildSetView( $subpage, $error = false, $name = null, $type = null, $wikis = null, $reason = null ) {
		global $wgOut, $wgUser;

		$set = $subpage ? WikiSet::newFromID( $subpage ) : null;
		if( !$name ) $name = $set ? $set->getName() : '';
		if( !$type ) $type = $set ? $set->getType() : WikiSet::OPTIN;
		if( !$wikis ) $wikis = implode( "\n", $set ? $set->getWikisRaw() : array() );
		else $wikis = implode( "\n", $wikis );
		$url = SpecialPage::getTitleFor( 'EditWikiSets', $subpage )->getLocalUrl();
		$legend = wfMsgHtml( 'centralauth-editset-legend-' . ($set ? 'edit' : 'new'), $name );

		$wgOut->addHTML( "<fieldset><legend>{$legend}</legend>" );
		if( $error )
			$wgOut->addHTML( "<strong class='error'>{$error}</strong>" );
		$wgOut->addHTML( "<form action='{$url}' method='post'>" );

		if( $set ) {
			$groups = $set->getRestrictedGroups();
			if ( $groups ) {
				$usage = "<ul>\n";
				foreach( $groups as $group )
					$usage .= "<li>" . wfMsgExt( 'centralauth-editset-grouplink', array('parseinline'), $group ) . "</li>\n";
				$usage .= "</ul>";
			} else {
				$usage = wfMsgWikiHtml('centralauth-editset-nouse');
			}
		} else {
			$usage = '';
		}

		$form = array();
		$form['centralauth-editset-name'] = Xml::input( 'wpName', false, $name );
		if( $usage )
			$form['centralauth-editset-usage'] = $usage;
		$form['centralauth-editset-type'] = $this->buildTypeSelector( 'wpType', $type );
		$form['centralauth-editset-wikis'] = Xml::textarea( 'wpWikis', $wikis );
		$form['centralauth-editset-reason'] = Xml::input( 'wpReason', false, $reason );

		$wgOut->addHTML( Xml::buildForm( $form, 'centralauth-editset-submit' ) );

		$edittoken = Xml::hidden( 'wpEditToken', $wgUser->editToken() );
		$wgOut->addHTML( "<p>{$edittoken}</p></form></fieldset>" );
	}

	function buildTypeSelector( $name, $value ) {
		$select = new XmlSelect( $name, 'set-type', $value );
		foreach( array( WikiSet::OPTIN, WikiSet::OPTOUT ) as $type )
			$select->addOption( wfMsg( "centralauth-editset-{$type}" ), $type );
		return $select->getHTML();
	}

	function doSubmit( $id ) {
		global $wgRequest, $wgContLang;

		$name = $wgContLang->ucfirst( $wgRequest->getVal( 'wpName' ) );
		$type = $wgRequest->getVal( 'wpType' );
		$wikis = array_unique( preg_split( '/(\s+|\s*\W\s*)/', $wgRequest->getVal( 'wpWikis' ), -1, PREG_SPLIT_NO_EMPTY ) );
		$reason = $wgRequest->getVal( 'wpReason' );
		$set = WikiSet::newFromId( $id );

		if( !Title::newFromText( $name ) ) {
			$this->buildSetView( $id, wfMsgHtml( 'centralauth-editset-badname' ), $name, $type, $wikis, $reason );
			return;
		}
		if( (!$id || $set->getName() != $name ) && WikiSet::newFromName( $name ) ) {
			$this->buildSetView( $id, wfMsgHtml( 'centralauth-editset-setexists' ), $name, $type, $wikis, $reason );
			return;
		}
		if( !in_array( $type, array( WikiSet::OPTIN, WikiSet::OPTOUT ) ) ) {
			$this->buildSetView( $id, wfMsgHtml( 'centralauth-editset-badtype' ), $name, $type, $wikis, $reason );
			return;
		}
		if( !$wikis ) {
			$this->buildSetView( $id, wfMsgHtml( 'centralauth-editset-nowikis' ), $name, $type, $wikis, $reason );
			return;
		}
		$badwikis = array();
		$allwikis = CentralAuthUser::getWikiList();
		foreach( $wikis as $wiki )
			if( !in_array( $wiki, $allwikis ) )
				$badwikis[] = $wiki;
		if( $badwikis ) {
			$this->buildSetView( $id, wfMsgExt( 'centralauth-editset-badwikis', array( 'escapenoentities', 'parsemag' ), 
						implode( ', ', $badwikis ), count( $badwikis ) ), $name, $type, $wikis, $reason );
			return;
		}

		if( $set ) {
			$oldname = $set->getName();
			$oldtype = $set->getType();
			$oldwikis = $set->getWikisRaw();
		} else {
			$set = new WikiSet();
			$oldname = $oldtype = null; $oldwikis = array();
		}
		$set->setName( $name );
		$set->setType( $type );
		$set->setWikisRaw( $wikis );
		$set->commit();

		// Now logging
		$log = new LogPage( 'gblrights' );
		$title = SpecialPage::getTitleFor( 'EditWikiSets', $set->getID() );
		if( !$oldname ) {
			// New set
			$log->addEntry( 'newset', $title, $reason, array( $name, $type, implode( ', ', $wikis ) ) );
		} else {
			if( $oldname != $name )
				$log->addEntry( 'setrename', $title, $reason, array( $name, $oldname ) );
			if( $oldtype != $type )
				$log->addEntry( 'setnewtype', $title, $reason, array( $name, $oldtype, $type ) );
			$added = implode( ', ', array_diff( $wikis, $oldwikis ) );
			$removed = implode( ', ', array_diff( $oldwikis, $wikis ) );
			if( $added || $removed ) {
				$log->addEntry( 'setchange', $title, $reason, array( $name, $added, $removed ) );
			}
		}
		
		global $wgUser,$wgOut;
		$sk = $wgUser->getSkin();
		$returnLink = $sk->makeKnownLinkObj( $this->getTitle(), wfMsg( 'centralauth-editset-return' ) );

		$wgOut->addHTML( '<strong class="success">' . wfMsgHtml( 'centralauth-editset-success' ) . '</strong> <p>'.$returnLink.'</p>' );
	}
}
