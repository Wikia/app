<?php
/**
 * Implements Special:Interwiki
 * @ingroup SpecialPage
 */
class SpecialInterwiki extends SpecialPage {

	/**
	 * Constructor - sets up the new special page
	 */
	public function __construct() {
		parent::__construct( 'Interwiki' );
	}

	function getDescription() {
		global $wgUser;

		return wfMsg( $wgUser->isAllowed( 'interwiki' ) ?
			'interwiki' : 'interwiki-title-norights' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser;

		wfLoadExtensionMessages( 'Interwiki' );

		$admin = $wgUser->isAllowed( 'interwiki' );

		$this->setHeaders();
		$this->outputHeader();

		$admin = $wgUser->isAllowed( 'interwiki' );
		$action = $wgRequest->getVal( 'action', $par );

		switch( $action ){
		case 'delete':
		case 'edit':
		case 'add':
			// Check permissions
			if( !$admin ){
				$wgOut->permissionRequired( 'interwiki' );
				return;
			}
			// Is the database in read-only mode?
			if( wfReadOnly() ) {
				$wgOut->readOnlyPage();
				return;
			}
			$this->showForm( $action );
			break;
		case 'submit':
			// Check permissions
			if( !$admin ){
				$wgOut->permissionRequired( 'interwiki' );
				return;
			}
			// Is the database in read-only mode?
			if( wfReadOnly() ) {
				$wgOut->readOnlyPage();
				return;
			}
			// Prevent cross-site request forgeries
			if( !$wgRequest->wasPosted() || !$wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) ) ) {
				$wgOut->addWikiMsg( 'sessionfailure' );
				return;
			}
			$this->doSubmit();
			break;
		default:
			$this->showList( $admin );
			break;
		}
	}

	function showForm( $action ) {
		global $wgRequest, $wgUser, $wgOut;

		$actionUrl = $this->getTitle()->getLocalURL( 'action=submit' );
		$token = $wgUser->editToken();

		switch( $action ){
		case 'delete':

			$prefix = $wgRequest->getVal( 'prefix' );
			$button = wfMsg( 'delete' );
			$topmessage = wfMsg( 'interwiki_delquestion', $prefix );
			$deletingmessage = wfMsgExt( 'interwiki_deleting', array( 'parseinline' ), $prefix );
			$reasonmessage = wfMsg( 'deletecomment' );

			$wgOut->addHTML(
				Xml::openElement( 'fieldset' ) .
				Xml::element( 'legend', null, $topmessage ) .
				Xml::openElement( 'form', array( 'id' => 'mw-interwiki-deleteform', 'method' => 'post', 'action' => $actionUrl ) ) .
				Xml::openElement( 'table' ) .
				"<tr><td>$deletingmessage</td></tr>".
				'<tr><td class="mw-label">' . Xml::label( $reasonmessage, 'mw-interwiki-deletereason' ) . '</td>' .
				'<td class="mw-input">' .
				Xml::input( 'wpInterwikiReason', 60, '', array( 'tabindex' => '1', 'id' => 'mw-interwiki-deletereason', 'maxlength' => '200' ) ) .
				'</td></tr>' .
				'<tr><td></td><td class="mw-submit">' . Xml::submitButton( $button, array( 'id' => 'mw-interwiki-submit' ) ) .
				Xml::hidden( 'wpInterwikiPrefix', $prefix ) .
				Xml::hidden( 'wpInterwikiAction', $action ) .
				Xml::hidden( 'wpEditToken', $token ) .
				'</td></tr>' .
				Xml::closeElement( 'table' ) .
				Xml::closeElement( 'form' ) .
				Xml::closeElement( 'fieldset' )
			);
			break;
		case 'edit':
		case 'add':
			if( $action == 'edit' ){
				$prefix = $wgRequest->getVal( 'prefix' );
				$dbr = wfGetDB( DB_SLAVE );
				$row = $dbr->selectRow( 'interwiki', '*', array( 'iw_prefix' => $prefix ), __METHOD__ );
				if( !$row ){
					$this->error( 'interwiki_editerror', $prefix );
					return;
				}
				$prefix = '<tt>' . htmlspecialchars( $row->iw_prefix ) . '</tt>';
				$defaulturl = $row->iw_url;
				$trans = $row->iw_trans;
				$local = $row->iw_local;
				$old = Xml::hidden( 'wpInterwikiPrefix', $row->iw_prefix );
				$topmessage = wfMsgExt( 'interwiki_edittext', array( 'parseinline' ) );
				$intromessage = wfMsgExt( 'interwiki_editintro', array( 'parseinline' ) );
				$button = wfMsg( 'edit' );
			} else {
				$prefix = $wgRequest->getVal( 'wpInterwikiPrefix' ) ? $wgRequest->getVal( 'wpInterwikiPrefix' ) : $wgRequest->getVal( 'prefix' );
				$prefix = Xml::input( 'wpInterwikiPrefix', 20, $prefix, array( 'tabindex' => '1', 'id' => 'mw-interwiki-prefix', 'maxlength' => '20' ) );
				$local = $wgRequest->getCheck( 'wpInterwikiLocal' );
				$trans = $wgRequest->getCheck( 'wpInterwikiTrans' );
				$old = '';
				$defaulturl = $wgRequest->getVal( 'wpInterwikiURL' ) ? $wgRequest->getVal( 'wpInterwikiURL' ) : wfMsg( 'interwiki_defaulturl' );
				$topmessage = wfMsgExt( 'interwiki_addtext', array( 'parseinline' ) );
				$intromessage = wfMsgExt( 'interwiki_addintro', array( 'parseinline' ) );
				$button = wfMsg( 'interwiki_addbutton' );
			}

			$prefixmessage = wfMsgHtml( 'interwiki-prefix-label' );
			$localmessage = wfMsg( 'interwiki-local-label' );
			$transmessage = wfMsg( 'interwiki-trans-label' );
			$reasonmessage = wfMsg( 'interwiki_reasonfield' );
			$urlmessage = wfMsg( 'interwiki-url-label' );

			$wgOut->addHTML(
				Xml::fieldset( $topmessage ) .
				$intromessage .
				Xml::openElement( 'form', array( 'id' => 'mw-interwiki-editform', 'method' => 'post', 'action' => $actionUrl ) ) .
				Xml::openElement( 'table', array( 'id' => "mw-interwiki-$action" ) ) .
				"<tr><td class='mw-label'>$prefixmessage</td><td><tt>$prefix</tt></td></tr>" .
				'<tr><td class="mw-label">' . Xml::label( $localmessage, 'mw-interwiki-local' ) . '</td>' .
				'<td class="mw-input">' . Xml::check( 'wpInterwikiLocal', $local, array( 'id' => 'mw-interwiki-local' ) ) . '</td></tr>' .
				'<tr><td class="mw-label">' . Xml::label( $transmessage, 'mw-interwiki-trans' ) . '</td>' .
				'<td class="mw-input">' .  Xml::check( 'wpInterwikiTrans', $trans, array( 'id' => 'mw-interwiki-trans' ) ) . '</td></tr>' .
				'<tr><td class="mw-label">' . Xml::label( $urlmessage, 'mw-interwiki-url' ) . '</td>' .
				'<td class="mw-input">' . Xml::input( 'wpInterwikiURL', 60, $defaulturl, array( 'tabindex' => '1', 'maxlength' => '200', 'id' => 'mw-interwiki-url' ) ) . '</td></tr>' .
				'<tr><td class="mw-label">' . Xml::label( $reasonmessage, 'mw-interwiki-editreason' ) . '</td>' .
				'<td class="mw-input">' . Xml::input( 'wpInterwikiReason', 60, '', array( 'tabindex' => '1', 'id' => 'mw-interwiki-editreason', 'maxlength' => '200' ) ) .
				Xml::hidden( 'wpInterwikiAction', $action ) .
				$old .
				Xml::hidden( 'wpEditToken', $token ) .
				'</td></tr>' .
				'<tr><td></td><td class="mw-submit">' . Xml::submitButton( $button, array( 'id' => 'mw-interwiki-submit' ) ) . '</td></tr>' .
				Xml::closeElement( 'table' ) .
				Xml::closeElement( 'form' ) .
				Xml::closeElement( 'fieldset' )
			);
			break;
		}
	}

	function doSubmit() {
		global $wgRequest, $wgOut;
		$prefix = $wgRequest->getVal( 'wpInterwikiPrefix' );
		$do = $wgRequest->getVal( 'wpInterwikiAction' );
		if( preg_match( '/[\s:&=]/', $prefix ) ) {
			$this->error( 'interwiki-badprefix', htmlspecialchars( $prefix ) );
			$this->showForm( $do );
			return;
		}
		$reason = $wgRequest->getText( 'wpInterwikiReason' );
		$selfTitle = $this->getTitle();
		$dbw = wfGetDB( DB_MASTER );
		switch( $do ){
		case 'delete':
			$dbw->delete( 'interwiki', array( 'iw_prefix' => $prefix ), __METHOD__ );

			if ( $dbw->affectedRows() == 0 ) {
				$this->error( 'interwiki_delfailed', $prefix );
				$this->showForm( $do );
			} else {
				$wgOut->addWikiMsg( 'interwiki_deleted', $prefix );
				$wgOut->returnToMain( false, $selfTitle );
				$log = new LogPage( 'interwiki' );
				$log->addEntry( 'iw_delete', $selfTitle, $reason, array( $prefix ) );
			}
			break;
		case 'edit':
		case 'add':
			$theurl = $wgRequest->getVal( 'wpInterwikiURL' );
			$local = $wgRequest->getCheck( 'wpInterwikiLocal' ) ? 1 : 0;
			$trans = $wgRequest->getCheck( 'wpInterwikiTrans' ) ? 1 : 0;
			$data = array( 'iw_prefix' => $prefix, 'iw_url' => $theurl,
				'iw_local'  => $local, 'iw_trans'  => $trans );

			if( $do == 'add' ){
				$dbw->insert( 'interwiki', $data, __METHOD__, 'IGNORE' );
			} else {
				$dbw->update( 'interwiki', $data, array( 'iw_prefix' => $prefix ), __METHOD__, 'IGNORE' );
			}

			if( $dbw->affectedRows() == 0 ) {
				$this->error( "interwiki_{$do}failed", $prefix );
				$this->showForm( $do );
			} else {
				$wgOut->addWikiMsg( "interwiki_{$do}ed", $prefix );
				$wgOut->returnToMain( false, $selfTitle );
				$log = new LogPage( 'interwiki' );
				$log->addEntry( 'iw_' . $do, $selfTitle, $reason, array( $prefix, $theurl, $trans, $local ) );
			}
			break;
		}	
	}

	function trans_local( $tl, $msg0, $msg1 ) {
		if( $tl === '0' )
			return $msg0;
		if( $tl === '1' )
			return $msg1;
		return htmlspecialchars( $tl );
	}

	function showList( $admin ) {
		global $wgUser, $wgOut, $wgScriptPath;

		$wgOut->addExtensionStyle( "{$wgScriptPath}/extensions/Interwiki/SpecialInterwiki.css" );

		$prefixmessage = wfMsgHtml( 'interwiki_prefix' );
		$urlmessage = wfMsgHtml( 'interwiki_url' );
		$localmessage = wfMsgHtml( 'interwiki_local' );
		$transmessage = wfMsgHtml( 'interwiki_trans' );
		$message_0 = wfMsgHtml( 'interwiki_0' );
		$message_1 = wfMsgHtml( 'interwiki_1' );

		$out = '
<table width="100%" cellspacing="0" cellpadding="0" border="0" style="border:0" class="mw-interwikitable wikitable intro">
<tr><th class="mw-align-left">' . $prefixmessage . '</th><td>' . wfMsgExt( 'interwiki_prefix_intro', 'parseinline' ) . '</td></tr>
<tr><th class="mw-align-left">' . $urlmessage . '</th><td>' . wfMsgExt( 'interwiki_url_intro', 'parseinline' ) . '</td></tr>
<tr><th class="mw-align-left">' . $localmessage . '</th><td>' . wfMsgExt( 'interwiki_local_intro', 'parseinline' ) . '</td></tr>
<tr><th class="mw-align-right">' . $message_0 . '</th><td>' . wfMsgExt( 'interwiki_local_0_intro', 'parseinline' ) . '</td></tr>
<tr><th class="mw-align-right">' . $message_1 . '</th><td>' . wfMsgExt( 'interwiki_local_1_intro', 'parseinline' ) . '</td></tr>
<tr><th class="mw-align-left">' . $transmessage . '</th><td>' . wfMsgExt( 'interwiki_trans_intro', 'parseinline' ) . '</td></tr>
<tr><th class="mw-align-right">' . $message_1 . '</th><td>' . wfMsgExt( 'interwiki_trans_1_intro', 'parseinline' ) . '</td></tr>
<tr><th class="mw-align-right">' . $message_0 . '</th><td>' . wfMsgExt( 'interwiki_trans_0_intro', 'parseinline' ) . '</td></tr>
</table>
';
		$wgOut->addWikiMsg( 'interwiki_intro' );
		$wgOut->addHTML( $out );
		$wgOut->addWikiMsg( 'interwiki_intro_footer' );
		$selfTitle = $this->getTitle();

		// Privileged users can add new prefixes
		if ( $admin ) {
			$skin = $wgUser->getSkin();
			$addtext = wfMsgHtml( 'interwiki_addtext' );
			$addlink = $skin->link( $selfTitle, $addtext, array(), array( 'action' => 'add' ) );
			$wgOut->addHTML( '<p>' . $addlink . '</p>' );
		}

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'interwiki', '*', false, __METHOD__ );
		$numrows = $res->numRows();
		if ( $numrows == 0 ) {
			// If the interwiki table is empty, display an error message
			$this->error( 'interwiki_error' );
			return;
		}

		$out = "
		<table width='100%' class='mw-interwikitable wikitable sortable body'>
		<tr id='interwikitable-header'><th>$prefixmessage</th> <th>$urlmessage</th> <th>$localmessage</th> <th>$transmessage</th>";
		// Privileged users can modify and delete existing prefixes
		if( $admin ) {
			$deletemessage = wfMsgHtml( 'delete' );
			$editmessage = wfMsgHtml( 'edit' );
			$out .= '<th class="unsortable">' . wfMsgHtml( 'interwiki_edit' ) . '</th>';
		}
		$out .= "</tr>\n";

		while( $s = $res->fetchObject() ) {
			$prefix = htmlspecialchars( $s->iw_prefix );
			$url = htmlspecialchars( $s->iw_url );
			$trans = $this->trans_local( $s->iw_trans, $message_0, $message_1 );
			$local = $this->trans_local( $s->iw_local, $message_0, $message_1 );
			$out .= "<tr class='mw-interwikitable-row'>
				<td class='mw-interwikitable-prefix'>$prefix</td>
				<td class='mw-interwikitable-url'>$url</td>
				<td class='mw-interwikitable-local'>$local</td>
				<td class='mw-interwikitable-trans'>$trans</td>";
			if( $admin ) {
				$out .= '<td class="mw-interwikitable-modify">';
				$out .= $skin->link( $selfTitle, $editmessage, array(),
					array( 'action' => 'edit', 'prefix' => $s->iw_prefix ) );
				$out .= wfMsg( 'comma-separator' );
				$out .= $skin->link( $selfTitle, $deletemessage, array(),
					array( 'action' => 'delete', 'prefix' => $s->iw_prefix ) );
				$out .= '</td>';
			}

			$out .= "\n</tr>\n";
		}
		$res->free();
		$out .= '</table><br />';
		$wgOut->addHTML( $out );
	}

	function error() {
		global $wgOut;
		$args = func_get_args();
		$wgOut->wrapWikiMsg( "<p class='error'>$1</p>", $args );
	}

}