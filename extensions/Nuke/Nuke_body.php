<?php

class SpecialNuke extends SpecialPage {

	public function __construct() {
		parent::__construct( 'Nuke', 'nuke' );
	}

	public function execute( $par ) {
		if ( !$this->userCanExecute( $this->getUser() ) ) {
			$this->displayRestrictionError();
		}
		$this->setHeaders();
		$this->outputHeader();

		if ( $this->getUser()->isBlocked() ) {
			$block = $this->getUser()->getBlock();
			throw new UserBlockedError( $block );
		}
		$this->checkReadOnly();

		$req = $this->getRequest();

		$target = trim( $req->getText( 'target', $par ) );

		// Normalise name
		if ( $target !== '' ) {
			$user = User::newFromName( $target );
			if ( $user ) $target = $user->getName();
		}

		$reason = $req->getText( 'wpReason',
			$target === '' ?
				wfMsgForContent( 'nuke-multiplepeople' ) :
				wfMsgForContent( 'nuke-defaultreason', "[[Special:Contributions/$target|$target]]" )
		);

		if( $req->wasPosted()
			&& $this->getUser()->matchEditToken( $req->getVal( 'wpEditToken' ) ) ) {

			if ( $req->getVal( 'action' ) == 'delete' ) {
				$pages = $req->getArray( 'pages' );

				if( $pages ) {
					$this->doDelete( $pages, $reason );
					return;
				}
			} elseif ( $req->getVal( 'action' ) == 'submit' ) {
				$this->listForm( $target, $reason, $req->getInt( 'limit', 500 ) );
			} else {
				$this->promptForm();
			}
		} elseif ( $target === '' ) {
			$this->promptForm();
		} else {
			$this->listForm( $target, $reason, $req->getInt( 'limit', 500 ) );
		}
	}

	/**
	 * Prompt for a username or IP address.
	 *
	 * @param $userName string
	 */
	protected function promptForm( $userName = '' ) {
		$out = $this->getOutput();

		$out->addWikiMsg( 'nuke-tools' );

		$out->addHTML(
			Xml::openElement(
				'form',
				array(
					'action' => $this->getTitle()->getLocalURL( 'action=submit' ),
					'method' => 'post'
				)
			)
			. '<table><tr>'
				. '<td>' . Xml::label( wfMsg( 'nuke-userorip' ), 'nuke-target' ) . '</td>'
				. '<td>' . Xml::input( 'target', 40, $userName, array( 'id' => 'nuke-target' ) ) . '</td>'
			. '</tr><tr>'
				. '<td>' . Xml::label( wfMsg( 'nuke-pattern' ), 'nuke-pattern' ) . '</td>'
				. '<td>' . Xml::input( 'pattern', 40, '', array( 'id' => 'nuke-pattern' ) ) . '</td>'
			. '</tr><tr>'
				. '<td>' . Xml::label( wfMsg( 'nuke-maxpages' ), 'nuke-limit' ) . '</td>'
				. '<td>' . Xml::input( 'limit', 7, '500', array( 'id' => 'nuke-limit' ) ) . '</td>'
			. '</tr><tr>'
				. '<td></td>'
				. '<td>' . Xml::submitButton( wfMsg( 'nuke-submit-user' ) ) . '</td>'
			.'</tr></table>'
			. Html::hidden( 'wpEditToken', $this->getUser()->editToken() )
			. Xml::closeElement( 'form' )
		);
	}

	/**
	 * Display list of pages to delete.
	 *
	 * @param string $username
	 * @param string $reason
	 * @param integer $limit
	 */
	protected function listForm( $username, $reason, $limit ) {
		$out = $this->getOutput();

		$pages = $this->getNewPages( $username, $limit );

		if( count( $pages ) == 0 ) {
			if ( $username === '' ) {
				$out->addWikiMsg( 'nuke-nopages-global' );
			} else {
				$out->addWikiMsg( 'nuke-nopages', $username );
			}

			$this->promptForm( $username );
			return;
		}

		if ( $username === '' ) {
			$out->addWikiMsg( 'nuke-list-multiple' );
		} else {
			$out->addWikiMsg( 'nuke-list', $username );
		}

		$nuke = $this->getTitle();

		$out->addModules( 'ext.nuke' );

		$out->addHTML(
			Xml::openElement( 'form', array(
				'action' => $nuke->getLocalURL( 'action=delete' ),
				'method' => 'post',
				'name' => 'nukelist')
			) .
			Html::hidden( 'wpEditToken', $this->getUser()->editToken() ) .
			Xml::tags( 'p',
				null,
				Xml::inputLabel(
					wfMsg( 'deletecomment' ), 'wpReason', 'wpReason', 70, $reason
				)
			)
		);

		// Select: All, None
		$links = array();
		$links[] = '<a href="#" id="toggleall">' .
			wfMsg( 'powersearch-toggleall' ) . '</a>';
		$links[] = '<a href="#" id="togglenone">' .
			wfMsg( 'powersearch-togglenone' ) . '</a>';
		$out->addHTML(
			Xml::tags( 'p',
				null,
				wfMsg( 'nuke-select', $this->getLanguage()->commaList( $links ) )
			)
		);

		// Delete button
		$out->addHTML(
			Xml::submitButton( wfMsg( 'nuke-submit-delete' ) )
		);

		$out->addHTML( '<ul>' );

		foreach( $pages as $info ) {
			/**
			 * @var $title Title
			 */
			list( $title, $userName ) = $info;

			$image = $title->getNamespace() == NS_IMAGE ? wfLocalFile( $title ) : false;
			$thumb = $image && $image->exists() ? $image->transform( array( 'width' => 120, 'height' => 120 ), 0 ) : false;

			$out->addHTML( '<li>' .
				Xml::check(
					'pages[]',
					true,
					array( 'value' =>  $title->getPrefixedDbKey() )
				) .
				'&#160;' .
				( $thumb ? $thumb->toHtml( array( 'desc-link' => true ) ) : '' ) .
				Linker::linkKnown( $title ) .
				'&#160;(' .
				( $userName ? wfMsgExt( 'nuke-editby', 'parseinline', $userName ) . ',&#160;' : '' ) .
				Linker::linkKnown(
					$title,
					wfMsg( 'nuke-viewchanges' ),
					array(),
					array( 'action' => 'history' )
				) .
				")</li>\n" );
		}

		$out->addHTML(
			"</ul>\n" .
			Xml::submitButton( wfMsg( 'nuke-submit-delete' ) ) .
			'</form>'
		);
	}

	/**
	 * Gets a list of new pages by the specified user or everyone when none is specified.
	 *
	 * @param string $username
	 * @param integer $limit
	 *
	 * @return array
	 */
	protected function getNewPages( $username, $limit ) {
		$dbr = wfGetDB( DB_SLAVE );

		$what = array(
			'rc_namespace',
			'rc_title',
			'rc_timestamp',
		);

		$where = array( "(rc_new = 1) OR (rc_log_type = 'upload' AND rc_log_action = 'upload')" );

		if ( $username === '' ) {
			$what[] = 'rc_user_text';
		} else {
			$where['rc_user_text'] = $username;
		}

		$pattern = $this->getRequest()->getText( 'pattern' );
		if ( !is_null( $pattern ) && trim( $pattern ) !== '' ) {
			$where[] = 'rc_title LIKE ' . $dbr->addQuotes( $pattern );
		}
		$group = implode( ', ', $what );

		$result = $dbr->select( 'recentchanges',
			$what,
			$where,
			__METHOD__,
			array(
				'ORDER BY' => 'rc_timestamp DESC',
				'GROUP BY' => $group,
				'LIMIT' => $limit
			)
		);

		$pages = array();

		foreach ( $result as $row ) {
			$pages[] = array(
				Title::makeTitle( $row->rc_namespace, $row->rc_title ),
				$username === '' ? $row->rc_user_text : false
			);
		}

		return $pages;
	}

	/**
	 * Does the actual deletion of the pages.
	 *
	 * @param array $pages The pages to delete
	 * @param string $reason
	 */
	protected function doDelete( array $pages, $reason ) {
		$res = array();

		foreach( $pages as $page ) {
			$title = Title::newFromURL( $page );
			$file = $title->getNamespace() == NS_FILE ? wfLocalFile( $title ) : false;

			$permission_errors = $title->getUserPermissionsErrors( 'delete', $this->getUser());

			if ( count( $permission_errors )) {
				throw new PermissionsError( 'delete', $permission_errors );
			}

			if ( $file ) {
				$oldimage = null; // Must be passed by reference
				$ok = FileDeleteForm::doDelete( $title, $file, $oldimage, $reason, false )->isOK();
			} else {
				$article = new Article( $title, 0 );
				$ok = $article->doDeleteArticle( $reason );
			}

			if ( $ok ) {
				$res[] = wfMsgExt( 'nuke-deleted', array( 'parseinline' ), $title->getPrefixedText() );
			} else {
				$res[] = wfMsgExt( 'nuke-not-deleted', array( 'parseinline' ), $title->getPrefixedText() );
			}
		}

		$this->getOutput()->addHTML( "<ul>\n<li>" . implode( "</li>\n<li>", $res ) . "</li>\n</ul>\n" );

		$this->getOutput()->addWikiMsg( 'nuke-delete-more' );
	}

}
