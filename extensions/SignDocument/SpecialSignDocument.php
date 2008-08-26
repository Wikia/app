<?PHP 
if (!defined('MEDIAWIKI')) die();
require_once( 'SignDocumentHelpers.php' );

// TODO: Doc
class SignDocument extends SpecialPage {
	/**
	 * The Document the user wants to sign.
	 * @type int
	 */
	private $mDocumentId;
	
	private $mArticle;
	private $mTitle;
	
	private $mCurrentSig;
	private $mForm;
	
	/**
     * Constructor
     */
    function SignDocument() {
		SpecialPage::SpecialPage( 'SignDocument', 'sigadmin' );
		wfLoadExtensionMessages('SpecialSignDocument');
		$this->includable( true );
	}

	function execute($par = null) {
		global $wgOut, $wgRequest, $wgUser;

		$this->setHeaders();
		if ( $wgUser->isAllowed( 'sigadmin' ) ) {
			$this->mDocumentId = (int) $wgRequest->getVal( 'doc', null );
		
			if ( $this->mDocumentId && !is_null($wgRequest->getVal( 'viewsigs' )) ) {
				$tmp = new SignatureViewer();
				$tmp->execute();
				return;
			}

			if ( $this->mDocumentId == null )
				$this->showSelectDocument();
			else if (!$wgRequest->wasPosted()) {
				$this->mCurrentSig = SignDocumentSignature::newBasic();
				$this->showSignForm();
			}
			else {
				$this->dealWithPost();
			}
		}
		else {
			$wgOut->permissionRequired( 'sigadmin' );
		}
	}

	function showSelectDocument() {
		global $wgOut, $wgTitle;

		$wgOut->addWikiText( wfMsg( 'sign-nodocselected' ) );
		
		$out = '';
		$out .= wfOpenElement( 'form', array(
			'id' => 'mw-SignDocument-SelectDoc-form',
			'action' => $wgTitle->escapeLocalUrl(),
			'method' => 'get') );

		$out .= '<p><strong>' . wfMsg( 'sign-selectdoc' ) . '</strong>&nbsp;';

		$out .= $this->buildDocSelector();
	
		$out .= wfElement( 'input', array(
			'id' => 'mw-SelectDoc-submit',
			'type' => 'submit',
			'value' => wfMsg( 'go' ) ) );
												
		$out .= '</p></form>';
															
		$wgOut->addHTML( $out );
	}

	function buildDocSelector( ) {
		$id = 'mw-SignDocument-docselector';

		$attribs = array(
			'id' => $id,
			'name' => 'doc',
			'size' => '1', 
		);

		$out = wfOpenElement( 'select', $attribs );

		$itms = SignDocumentForm::getNamesFromDB();
		$firstItem = null;
		
		foreach(array_keys($itms) as $itm) {
			if (!$firstItem) $firstItem = $itm;
			$out .= $this->buildOption( $itm, $itms[$itm], $firstItem );
		}
		
		$out .= "</select>\n";
		return $out;
	}

	function buildOption( $text, $value, $selected ) {
		$selectedAttrib = ($selected == $text)
			? array( 'selected' => 'selected' )
			: array();
		
			return wfElement( 'option',
					array( 'value' => $value ) + $selectedAttrib,
							$text );
	}
	
	function showSignForm() {
		global $wgOut, $wgUser, $wgRequest, $wgTitle;
		
		$this->mForm = SignDocumentForm::newFromDB( $wgRequest->getVal('doc') );
		
		if ( !$this->mForm ) {
			$wgOut->addWikiText( wfMsg( 'sign-error-nosuchdoc', $wgRequest->getVal('doc') ) );
			return;
		}
		
		if ( !in_array( $this->mForm->mAllowedGroup, $wgUser->getEffectiveGroups() ) ) {
			$wgOut->permissionRequired( $this->mForm->mAllowedGroup );
			return;
		}

		$skin = $wgUser->getSkin();

		$wgOut->addHTML( '<div style="position:absolute; top:5px; right:10px;">' .
			'[<b>'. $skin->makeKnownLinkObj( SpecialPage::getTitleFor('SignDocument'),
				wfMsg( 'sign-viewsignatures' ), 'doc=' . $wgRequest->getVal('doc') 
				. '&viewsigs&timestamp&realname')
			   	. '</b>]</div>' );
		
		if ( !$this->mForm->mOpen ) {
			$wgOut->addWikiText( wfMsg( 'sign-error-closed' ) );
			$wgOut->addHTML( '<h1>' . $this->mForm->mPagename . '</h1>' );
			$wgOut->addWikiText( $this->mForm->mArticle->getContent() );
			return;
		}
		
		$wgOut->addWikiText( wfMsg( 'sign-docheader', $this->mForm->mPagename ) );

		$wgOut->addHTML( '<h1>' . $this->mForm->mPagename . '</h1>' );
		$wgOut->addWikiText( $this->mForm->mArticle->getContent() );

		$wgOut->addHTML( '<hr>' );

		$wgOut->addWikiText( wfMsg( 'sign-information', $this->mForm->mIntrotext ) );

		$wgOut->addHTML( '<br />' );
		
		$this->addSignForm();
	}

	function addSignForm() {
		global $wgOut, $wgTitle, $wgRequest;

		$this->mForm = SignDocumentForm::newFromDB( $wgRequest->getVal('doc') );

		/* We need the values the user submitted, even if they're not listed. */
		$this->mCurrentSig->setAllAccessible( true );
		
		$out = '';

		$out .= wfOpenElement( 'form', array(
			'id' => 'mw-SignDocument-sign-form',
			'action' => $wgTitle->escapeLocalUrl(),
			'method' => 'post') );

		$out .= '<table>';
		$out .= $this->makeInput( false, false, 'realname', wfMsg('sign-realname'), 
				$this->mCurrentSig->getRealname(), 'anonymous' );
				
		$out .= $this->makeInput( $this->mForm->mAddressHidden, 
				$this->mForm->mAddressOptional,
				'address', wfMsg('sign-address'), 
				$this->mCurrentSig->getAddress(), 'hideaddress' );
		$out .= $this->makeInput( $this->mForm->mExtAddressHidden, 
				$this->mForm->mExtAddressOptional,
				'city', wfMsg('sign-city'), 
				$this->mCurrentSig->getCity(), 'hideextaddress' );
		$out .= $this->makeInput( $this->mForm->mExtAddressHidden, 
				$this->mForm->mExtAddressOptional,
				'state', wfMsg('sign-state'), 
				$this->mCurrentSig->getState(), false );
		$out .= $this->makeInput( $this->mForm->mExtAddressHidden, 
				$this->mForm->mExtAddressOptional,
				'zip', wfMsg('sign-zip'), 
				$this->mCurrentSig->getZip(), false );
		$out .= $this->makeInput( $this->mForm->mExtAddressHidden, 
				$this->mForm->mExtAddressOptional,
				'country', wfMsg('sign-country'), 
				$this->mCurrentSig->getCountry(), false );
		$out .= $this->makeInput( $this->mForm->mPhoneHidden, 
				$this->mForm->mPhoneOptional,
				'phone', wfMsg('sign-phone'), 
				$this->mCurrentSig->getPhone(), 'hidephone' );
		$out .= $this->makeInput( $this->mForm->mBdayHidden, 
				$this->mForm->mBdayOptional,
				'bday', wfMsg('sign-bday'), 
				$this->mCurrentSig->getBday(), 'hidebday' );
		$out .= $this->makeInput( $this->mForm->mEmailHidden, 
				$this->mForm->mEmailOptional,
				'email', wfMsg('sign-email'), 
				$this->mCurrentSig->getEmail(), 'hideemail' );

		$out .= '<tr><td></td><td>' . wfMsg( 'sign-indicates-req' ) . '</td></tr>';
		$out .= '<tr><td></td><td>' . wfMsg( 'sign-hide-note' ) . '</td></tr>';

		$out .= wfElement( 'input', array(
			
				'type' => 'hidden',
				'name' => 'doc',
				'value' => $wgRequest->getVal('doc') ) );

		$out .= '<tr><td>' . wfElement( 'input', array(
				'id' => 'mwSignDocument-submit',
				'type' => 'submit',
				'value' => wfMsg( 'sign-submit') ) );

		$out .= '</td></tr>';
		
		$out .= '</table></form>';

		$wgOut->addHTML( $out );
	}

	function makeInput( $hidden, $optional, $name, $caption, $value, $markPrivate = false ) {
		if ($hidden) return '';
		$out = '<tr><td>';
		if (!$optional) $caption .= '<font color="red">*</font>';
		$out .= "<strong>$caption&nbsp;";
		$out .= '</td><td>';
		$out .= wfElement( 'input', array(
			'id' => "wmSignDocument-$name",
			'name' => $name,
			'value' => $value,
			'style' => 'width: 400px;'));
		if ( $markPrivate ) {
			$out .= '</td><td>';
			$out .= Xml::checkLabel(
	                    wfMsg( "sign-list-$markPrivate" ) .  '**',
						$markPrivate,
						$markPrivate,
						false);
		}
			
		$out .= '</td></tr>';
		
		return $out;
	}

	function loadDocument() {
		$this->mTitle = Title::newFromId( 1 );
		$this->mArticle = new Article( $this->mTitle );
	}

	function dealWithPost() {
		$this->doSigning();
	}

	function doSigning() {
		global $wgRequest, $wgOut, $wgUser;
		
		$this->mCurrentSig = SignDocumentSignature::newFromPost();
		
		if ( !$this->mCurrentSig->mForm->mOpen ) {
			$wgOut->addWikiText( wfMsg( 'sign-error-closed' ) );
			return;
		}

		$wgOut->addHTML( '<div style="position:absolute; top:5px; right:10px;">' .
			'[<b>'. $wgUser->getSkin()->makeKnownLinkObj( SpecialPage::getTitleFor('SignDocument'),
				wfMsg( 'sign-viewsignatures' ), 'doc=' . $wgRequest->getVal('doc') 
				. '&viewsigs&timestamp&realname')
			   	. '</b>]</div>' );

		try {
			$this->mCurrentSig->checkRequired();
			$this->mCurrentSig->checkSanity();
			$this->mCurrentSig->checkInDB();
		} catch ( MWException $e ) {
			$wgOut->addHTML( '<div style="border: 1px solid red;">' . $e->getMessage() . '</div>' );
			$this->addSignForm();
			return;
		}

		$this->mCurrentSig->addToDB();
		
		wfLogSignDocumentSignature($this->mCurrentSig);
		
		$wgOut->addWikiText( wfMsg( 'sig-success' ) );
	}
}

/**
 * A class for displaying the signatures submitted for a particular extension.
 */
class SignatureViewer {
	private $mForm, $mSigs;
						
	private $mFields;
	
	function execute() {
		global $wgRequest, $wgTitle, $wgUser;

		if ($wgRequest->getVal('detail')) {
			$this->doDetail();
			return;
		} else 
		
		$this->setUp();
		
		if ($wgRequest->wasPosted() && $wgUser->isAllowed('sigadmin')) {
		   	if (!is_null($wgRequest->getVal('opensigning') ) )
				$this->openSigning();
			else if (!is_null($wgRequest->getVal('closesigning') ) )
				$this->closeSigning();
		}

		global $wgOut;
		
		//TODO: Add counts, etc.
		$wgOut->addWikiText( wfMsg( 'sign-viewsigs-intro', $this->mForm->mPagename, $this->mForm->getId() ) );

		$wgOut->addHTML( $this->getCloseOpenOptions() );
		
		$wgOut->addHTML( '<br />' . $this->getFieldSelector() );
		
		$wgOut->addHTML( '<fieldset><legend>' . wfMsg('sign-signatures') . '</legend>' );
		$wgOut->addHTML( $this->getTableHead() );

		foreach ($this->mSigs as $sig)
			$wgOut->addHTML( $this->getSigRow($sig, $sig->mStricken ) );
		
		$wgOut->addHTML( '</table>' );
		$wgOut->addHTML( '</fieldset>' );

		$wgOut->addHTML( $this->getFieldSelector() );
	}

	private function setUp() {
		global $wgRequest;

		$doc = $wgRequest->getVal('doc');
		if (!$doc) throw new MWException();

		$this->mForm = SignDocumentForm::newFromDB( $doc );
		$this->mSigs = SignDocumentSignature::getAllFromDB( $this->mForm->getId() );

		$this->mFields = array(
			#'entryid'    => !is_null($wgRequest->getVal('entryid')),
			'timestamp'  => !is_null($wgRequest->getVal('timestamp')),
			'realname'   => !is_null($wgRequest->getVal('realname')),
			'address'    => !is_null($wgRequest->getVal('address')),
			'city'       => !is_null($wgRequest->getVal('city')),
			'state'      => !is_null($wgRequest->getVal('state')),
			'country'    => !is_null($wgRequest->getVal('country')),
			'zip'        => !is_null($wgRequest->getVal('zip')),
			'phone'      => !is_null($wgRequest->getVal('phone')),
			'email'      => !is_null($wgRequest->getVal('email')),
			'age'        => !is_null($wgRequest->getVal('age')),
			'ip'         => !is_null($wgRequest->getVal('ip')),
			'agent'      => !is_null($wgRequest->getVal('agent'))
		);
	}
	
	private function getCloseOpenOptions() {
		global $wgUser, $wgTitle;
		if (!$wgUser->isAllowed('sigadmin')) return '';

		$url = $wgTitle->escapeLocalUrl() . '?doc=' . $this->mForm->getId()
				. '&viewsigs';
		
		$out = wfOpenElement( 'form', array(
			'id'     => 'wm-sign-viewsigs-closeopen-form',
			'action' => $url,
			'method' => 'post' ) );

		if ( $this->mForm->mOpen ) {
			$out .= wfMsg('sign-sigadmin-currentlyopen') . '&nbsp;';
			$out .= wfElement( 'input', array(
					'type'  => 'submit',
					'name'  => 'closesigning-submit',
					'value' => wfMsg( 'sign-sigadmin-close' ) ) );
			$out .= wfElement( 'input', array( 
					'type'  => 'hidden',
					'name'  => 'closesigning') );
		} else {
			$out .= wfMsg('sign-sigadmin-currentlyclosed') . '&nbsp;';
			$out .= wfElement( 'input', array(
					'type'  => 'submit',
					'name'  => 'opensigning-submit',
					'value' => wfMsg( 'sign-sigadmin-open' ) ) );
			$out .= wfElement( 'input', array( 
					'type'  => 'hidden',
					'name'  => 'opensigning') );
		}

		$out .= '</form>';
		return $out;
	}

	private function getFieldSelector() {
		global $wgTitle;
		$out = '';
		$out .= wfOpenElement( 'form', array(
			'id' => 'mw-sdoc-viewsigs-fieldselector-form',
			'action' => $wgTitle->escapeLocalUrl(),
			'method' => 'get') );

		$out .= wfMsg( 'sign-view-selectfields' );

		$out .= wfElement( 'input', array(
			'type' => 'hidden', 'name' => 'doc', 
			'value' => $this->mForm->getId()));

		$out .= wfElement( 'input', array(
			'type' => 'hidden', 'name' => 'viewsigs'));

		foreach (array_keys($this->mFields) as $field)
			$out .= $this->fieldCheck($field);
		
		$out .= '&nbsp;' . wfElement( 'input', array( 
			'type' => 'submit', 'value' => wfMsg('go') ) );
			
		$out .= '</form>';
		return $out;
	}

	private function fieldCheck($id) {
		global $wgRequest, $wgUser;
		if ($id == 'ip' || $id == 'agent') {
			if (!$wgUser->isAllowed('sigadmin')) return '';
		}
		return '&nbsp;' . Xml::checkLabel(
			wfMsg( "sign-viewfield-$id" ),
			$id, $id,
			$this->mFields[$id]);
	}

	private function getTableHead() {
		global $wgUser;
		$out = '<table cellpadding="2" class="sortable" ';
		$out .= 'style="cell-border: 0.25px solid gray; text-align: left;';
	    $out .= 'border-spacing: 1px; margin-left: 1em;"><tr>';
		
		if ( $wgUser->isAllowed('sigadmin') )
			$out .= '<th>' . wfMsg( 'sign-viewfield-options' ) . '</th>';
		
		foreach ($this->mFields as $field => $val) {
			if ($val) $out .= '<th>' . wfMsg( "sign-viewfield-$field" ) . '</th>';
		}
		
		return '</tr>' . $out;
	}

	private function getSigRow( $sig, $del = false ) {
		global $wgUser;
		$out = '<s><tr>';
		if ( $sig->isPrivileged() )
			$out .= '<td>[' . $wgUser->getSkin()->makeKnownLinkObj(
				SpecialPage::getTitleFor('SignDocument'),
				wfMsg('sign-viewfield-options'), 'doc=' . 
				$this->mForm->getId() . '&viewsigs&detail=' . $sig->mId ) . ']</td>';

		#$out .= $this->getSigCell( 'entryid', $sig->mId, $del );
		$out .= $this->getSigCell( 'timestamp', $sig->mTimestamp, $del ) ;
		$out .= $this->getSigCell( 'realname', $sig->getRealName(), $del );
		$out .= $this->getSigCell( 'address', $sig->getAddress(), $del );
		$out .= $this->getSigCell( 'city', $sig->getCity(), $del );
		$out .= $this->getSigCell( 'state', $sig->getState(), $del );
		$out .= $this->getSigCell( 'country', $sig->getCountry(), $del );
		$out .= $this->getSigCell( 'zip', $sig->getZip(), $del );
		$out .= $this->getSigCell( 'phone', $sig->getPhone(), $del );
		$out .= $this->getSigCell( 'email', $sig->getEmail(), $del );
		$out .= $this->getSigCell( 'age', $sig->getBday(), $del );
		$out .= $this->getSigCell( 'ip', $sig->getIp(), $del );
		$out .= $this->getSigCell( 'agent', $sig->getAgent(), $del );

		return $out . '</tr>' ;
	}

	private function getSigCell( $id, $text, $del = false ) {
		if (!$this->mFields[$id]) return '';
		if ($del) return "<td><del>$text</del>&nbsp;&nbsp;</td>";
		return "<td>$text&nbsp;&nbsp;</td>";
	}

	private function closeSigning() {
		global $wgOut;
		$this->mForm->setOpen(false);
		$wgOut->addWikiText( wfMsg( 'sign-sigadmin-closesuccess', $this->mForm->mPagename ) );
	}

	private function openSigning() {
		global $wgOut;
		$this->mForm->setOpen(true);
		$wgOut->addWikiText( wfMsg( 'sign-sigadmin-opensuccess', $this->mForm->mPagename ) );
	}
	
	private function doDetail() {
		global $wgUser, $wgOut, $wgRequest;
		
		if ( !$wgUser->isAllowed('sigadmin') ) {
			$wgOut->permissionRequired( 'sigadmin' );
			return;
		}

		$sig = SignDocumentSignature::newFromDB( $wgRequest->getVal('detail') );

		if ( is_null( $sig ) ) {
			$wgOut->addWikiText( wfMsg( 'sig-nosuchsig' ) );
			return;
		}

		$wgOut->addHTML( $this->getDetailReviewForm( $sig ) );
		
		$wgOut->addHTML( $this->getDetailTable( $sig ) );

		$wgOut->addHTML( $this->runDetailUniqueQuery( $sig ) );
	}

	private function getDetailReviewForm( $sig ) {
		global $wgRequest, $wgTitle;
		if ( $wgRequest->wasPosted() && !is_null( $wgRequest->getVal( 'doreview' ) ) ) {
			$this->updateReviewFromPost( $sig );
		}

		$out = '';
		
		$url = $wgTitle->escapeLocalUrl() . '?doc=' . $wgRequest->getVal('doc')
				. '&viewsigs&detail=' . $wgRequest->getVal('detail');

		$out .= wfOpenElement( 'form', array( 
			'id'     => 'doreview-form',
			'action' => $url,
			'method' => 'post' ) );
		
		$out .= '<fieldset><legend>' . wfMsg( 'sign-reviewsig' ) . '</legend>';

		$out .= Xml::checkLabel(
	         wfMsg( "sign-detail-strike" ),
			'strikesig',
			'strikesig',
			$sig->mStricken);

		$out .= '&nbsp;&nbsp;' . wfMsg( 'sign-review-comment' ) . ':&nbsp;';
		$out .= wfElement( 'input', array(
			'type'  => 'text',
			'name'  => 'reviewcomment',
			'value' => $sig->mStrickenComment,
	   		'style' => 'width: 450px;'	) );

		$out .= '&nbsp;&nbsp;' . wfElement( 'input', array(
			'type'  => 'submit',
			'name'  => 'doreview',
			'value' => wfMsg( 'sign-submitreview' ) ) );

		$out .= '</fieldset></form>';
		return $out;
			

	}

	private function updateReviewFromPost( $sig ) {
		global $wgRequest;
		if (!$wgRequest->wasPosted() || is_null($wgRequest->getVal('doreview')) 
				|| is_null($wgRequest->getVal('reviewcomment' ) ) ) 
			return; //What are you doing here then?

		$sig->postReview( $wgRequest->getVal( 'reviewcomment' ), 
				$wgRequest->getVal('strikesig'));
	}

	private function getDetailTable( $sig ) {
		$out = '';
		$out .= '<fieldset><legend>' . wfMsg( 'sign-sigdetails' ) . '</legend>';

		$out .= '<table style="width: 100%"><tr><td><table>';

		$out .= $this->getDetailTableRow( 'realname', $sig->getRealName(), 
				$sig->isHidden('realname') );
		$out .= $this->getDetailTableRow( 'address', $sig->getAddress(), 
				$sig->isHidden('address') );
		$out .= $this->getDetailTableRow( 'city', $sig->getCity(),
   				$sig->isHidden('extaddress') );
		$out .= $this->getDetailTableRow( 'state', $sig->getState(),
   				$sig->isHidden('extaddress') );
		$out .= $this->getDetailTableRow( 'country', $sig->getCountry(),
				$sig->isHidden('extaddress') );
		$out .= $this->getDetailTableRow( 'zip', $sig->getZip(),
				$sig->isHidden('extaddress') );
		$out .= $this->getDetailTableRow( 'phone', $sig->getPhone(),
				$sig->isHidden('phone') );
		$out .= $this->getDetailTableRow( 'email', 
				wfMsg( 'sign-emailto', $sig->getEmail() ), 
		   		$sig->isHidden('email')	);

		$out .= '</table></td><td valign="top"><table valign="top">';

		$out .= $this->getDetailTableRow( 'timestamp', $sig->mTimestamp );
		$out .= $this->getDetailTableRow( 'ip', wfMsgExt( 'sign-iptools', array( 
			'parse' ), $sig->getIp() ) );
		$out .= $this->getDetailTableRow( 'agent', $sig->getAgent() );
		
		$out .= $this->getDetailTableRow( 'stricken', ($sig->mStricken)?wfMsg( 'yes' ):wfMsg('no') );
		$out .= $this->getDetailTableRow( 'reviewedby', $sig->getReviewedBy() );
		$out .= $this->getDetailTableRow( 'reviewcomment', $sig->mStrickenComment );
		
		$out .= '</table></td></tr>';
		
		$out .= '</table></fieldset>';
		return $out;
	}

	private function getDetailTableRow( $fieldid, $val, $priv = false ) {
		return '<tr><td><strong>' . wfMsg( "sign-viewfield-$fieldid" ) . ':</strong></td><td>' 
				. $val . (($priv)?(' (' . wfMsg( 'sig-private' ) . ')'):'') . '</td></tr>';
	}

	private function runDetailUniqueQuery( $sig ) {
		global $wgRequest, $wgTitle;
		$out = '';

		$out .= '<fieldset><legend>' . wfMsg( 'sign-detail-uniquequery' ) . '</legend>';
		
		if ( !$wgRequest->wasPosted() || !$wgRequest->getVal( 'rununiquequery' ) ) {
			$url = $wgTitle->escapeLocalUrl() . '?doc=' . $wgRequest->getVal('doc')
				. '&viewsigs&detail=' . $wgRequest->getVal('detail');
			$out .= wfOpenElement( 'form', array(
				'id' => 'rununiquequery-form',
				'action' => $url,
				'method' => 'post' ) );

			$out .= wfElement( 'input', array(
				'type' => 'submit',
				'name' => 'rununiquequery',
				'value'=> wfMsg( 'sign-detail-uniquequery-run' ) ) );

			return '</form></fieldset>' . $out;	
		}

		$out .= $this->similarTable( wfMsg( 'sign-uniquequery-similarname' ), $sig->similarByName() );
		$out .= $this->similarTable( wfMsg( 'sign-uniquequery-similaraddress' ), $sig->similarByAddress() );
		$out .= $this->similarTable( wfMsg( 'sign-uniquequery-similarphone' ), $sig->similarByPhone() );
		$out .= $this->similarTable( wfMsg( 'sign-uniquequery-similaremail' ), $sig->similarByEmail() );

		$out .= '</fieldset>';
		return $out;
	}

	private function similarTable( $header, $sigs ) {
		$out = "<h5>$header</h5>";
		
		$out .= '<ul>';
		foreach ($sigs as $sig)
			$out .= '<li>' . wfMsgExt( 'sign-uniquequery-1signed2', array( 'parse'),
					$sig->getRealName(), $sig->mForm->mPagename, 
					$sig->mId,  $sig->mForm->getId() ) . '</li>';
	
		$out .= '</ul>';
					
		return $out;
	}
}
