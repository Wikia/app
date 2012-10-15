<?php

/**
 * TODO: doc
 * 
 * @since 0.1
 * 
 * @ingroup Distribution
 * 
 * @author Chad Horohoe
 */
class SpecialReleaseManager extends SpecialPage {

	private $rels, $out, $skin = null;

	public function __construct() {
		parent::__construct( 'ReleaseManager', 'release-manager' );
	}

	public function execute( $par ) {
		global $wgUser, $wgRequest, $wgOut;

		if( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}

		$this->setHeaders();
		$this->rels = ReleaseRepo::singleton();
		$this->out = $wgOut;
		$this->skin = $wgUser->getSkin();

		$params = explode( '/', $par );
		switch( $params[0] ) {
			case 'edit':
				if( isset( $params[1] ) ) {
					if( $wgRequest->wasPosted() ) {
						$this->postEdit( $params[1], $wgRequest );
					}
					$this->showEdit( $params[1] );
				}
				break;
			case 'delete':
				if( isset( $params[1] ) ) {
					if( $wgRequest->wasPosted() ) {
						$this->postDelete( $params[1], $wgRequest );
					} else {
						$this->showDelete( $params[1] );
						break;
					}
				}
			case 'add':
				if( $wgRequest->wasPosted() ) {
					$this->postAdd( $wgRequest );
				}
				$this->showAdd();
				break;
			default:
				$this->showList();
		}

	}

	private function showList() {
		$this->out->addWikiMsg( 'releasemanager-header' );
		$h = Html::openElement( 'div', array( 'style' => 'text-align:center' ) ) .
			$this->skin->link(
				$this->getTitleFor( 'ReleaseManager', 'add' ),
				wfMsg( 'releasemanager-add' ),
				array( 'style' => 'font-size:175%' )
			) . Html::element( 'hr' ) . Html::closeElement( 'div' ) .
			Html::openElement( 'table', array( 'class' => 'wikitable plainlinks sortable' ) ) .
			Html::openElement( 'tr' );
		foreach( MediaWikiRelease::getFieldNames() as $field ) {
			if( $field == 'id' ) {
				continue;
			}
			$h .= Html::element( 'th', array(), wfMsg( "mwr-field-$field" ) );
		}
		$h .= Html::element( 'th', array(), 'edit/del' ) . Html::closeElement( 'tr' );
		foreach( $this->rels->getAllReleases() as $rel ) {
			$h .= $this->formatReleaseForTable( $rel );
		}
		$h .= Html::closeElement( 'table' );
		$this->out->addHTML( $h );
	}

	private function formatReleaseForTable( MediaWikiRelease $rel ) {
		global $wgLang;
		$branchUrl = $this->skin->makeExternalLink( $rel->getBranchUrl(), $rel->getBranch () );
		$tagUrl = $this->skin->makeExternalLink( $rel->getTagUrl(), $rel->getTag() );
		$announceUrl = $this->skin->makeExternalLink( $rel->getAnnouncement(), 'mediawiki-announce' );
		$supported = $rel->isSupported() ? wfMsg( 'yes' ) : wfMsg( 'no' );
		$flagStatus = $rel->getSupported() > Release::SUPPORT_TIL_EOL ?
			wfMsg( 'releasemanager-supported-overriden', $supported ) :
			wfMsg( 'releasemanager-supported-til-eol', $supported );
		$editDel = $this->skin->link(
			$this->getTitleFor( 'ReleaseManager', 'edit/' . $rel->getId() ),
			wfMsg( 'edit' )
		) . ' / ' . $this->skin->link(
			$this->getTitleFor( 'ReleaseManager', 'delete/' . $rel->getId() ),
			wfMsg( 'delete' )
		);
		return Html::openElement( 'tr' ) .
			Html::element( 'td', array(), $rel->getName() ) .
			Html::element( 'td', array(), $rel->getNumber() ) .
			Html::element( 'td', array(), 'broken'/* $wgLang->date( $rel->getReleaseDate() ) */ ) .
			Html::element( 'td', array(), 'broken'/* $wgLang->date( $rel->getEOLDate() ) */ ) .
			Html::rawElement( 'td', array(), $branchUrl ) .
			Html::rawElement( 'td', array(), $tagUrl ) .
			Html::rawElement( 'td', array(), $announceUrl ) .
			Html::rawElement( 'td', array(), $flagStatus ) .
			Html::rawElement( 'td', array(), $editDel ) .
			Html::closeElement( 'tr' );
	}

	private function showAdd() {
	}

	private function postAdd( $req ) {
	}

	private function showEdit( $versionId ) {

	}

	private function postEdit( $versionId, $wgRequest ) {
	}

	private function showDelete( $versionId ) {
		if( !$this->rels->releaseExists( $versionId ) ) {
			$this->out->addWikiMsg( 'releasemanager-doesnotexist' );
			return;
		} else {
			$submitUrl = $this->getTitleFor( 'ReleaseManager', "delete/$versionId" )->getFullURL();
			$this->out->addWikiMsg( 'releasemanager-delete-confirm' );
			$h = Html::openElement( 'form', array( 'action' => $submitUrl,
				'method' => 'post' ) ) .
				Html::input( 'submit', wfMsg( 'submit' ), 'submit' ) .
				Html::closeElement( 'form' );
			$this->out->addHTML( $h );
		}
	}

	private function postDelete( $versionId, $wgRequest ) {
		$rel = $this->rels->getReleaseForId( $versionId );
		if( !$rel ) {
			$this->out->addWikiMsg( 'releasemanager-doesnotexist' );
			return;
		} else {
			$rel->delete();
		}
	}
}