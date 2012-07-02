<?php

/**
 * A SecurePoll subpage for translating election messages.
 */
class SecurePoll_TranslatePage extends SecurePoll_Page {	
	/**
	 * Execute the subpage.
	 * @param $params array Array of subpage parameters.
	 */
	function execute( $params ) {
		global $wgOut, $wgUser, $wgLang, $wgRequest;

		if ( !count( $params ) ) {
			$wgOut->addWikiMsg( 'securepoll-too-few-params' );
			return;
		}
		
		$electionId = intval( $params[0] );
		$this->election = $this->context->getElection( $electionId );
		if ( !$this->election ) {
			$wgOut->addWikiMsg( 'securepoll-invalid-election', $electionId );
			return;
		}
		$this->initLanguage( $wgUser, $this->election );
		$wgOut->setPageTitle( wfMsg( 'securepoll-translate-title', 
			$this->election->getMessage( 'title' ) ) );

		$this->isAdmin = $this->election->isAdmin( $wgUser );

		$primary = $this->election->getLanguage();
		$secondary = $wgRequest->getVal( 'secondary_lang' );
		if ( $secondary !== null ) {
			# Language selector submitted: redirect to the subpage
			$wgOut->redirect( $this->getTitle( $secondary )->getFullUrl() );
			return;
		}

		if ( isset( $params[1] ) ) {
			$secondary = $params[1];
		} else {
			# No language selected, show the selector
			$this->showLanguageSelector( $primary );
			return;
		}

		$secondary = $params[1];
		$primaryName = $wgLang->getLanguageName( $primary );
		$secondaryName = $wgLang->getLanguageName( $secondary );
		if ( strval( $secondaryName ) === '' ) {
			$wgOut->addWikiMsg( 'securepoll-invalid-language', $secondary );
			$this->showLanguageSelector( $primary );
			return;
		}

		# Set a subtitle to return to the language selector
		$this->parent->setSubtitle( array( 
			$this->getTitle(),
			wfMsg( 'securepoll-translate-title', $this->election->getMessage( 'title' ) ) ) );

		# If the request was posted, do the submit
		if ( $wgRequest->wasPosted() && $wgRequest->getVal( 'action' ) == 'submit' ) {
			$this->doSubmit( $secondary );
			return;
		}

		# Show the form
		$action = $this->getTitle( $secondary )->getLocalUrl( 'action=submit' );
		$s = 
			Xml::openElement( 'form', array( 'method' => 'post', 'action' => $action ) ) .
			'<table class="mw-datatable TablePager securepoll-trans-table">' .
			'<col class="securepoll-col-trans-id" width="1*"/>' .
			'<col class="securepoll-col-primary" width="30%"/>' .
			'<col class="securepoll-col-secondary"/>' .
			'<tr><th>' . wfMsgHtml( 'securepoll-header-trans-id' ) . '</th>' . 
			'<th>' . htmlspecialchars( $primaryName ) . '</th>' .
			'<th>' . htmlspecialchars( $secondaryName ) . '</th></tr>';
		$entities = array_merge( array( $this->election ), $this->election->getDescendants() );
		foreach ( $entities as $entity ) {
			$entityName = $entity->getType() . '(' . $entity->getId() . ')';
			foreach ( $entity->getMessageNames() as $messageName ) {
				$controlName = 'trans_' . $entity->getId() . '_' . $messageName;
				$primaryText = $entity->getRawMessage( $messageName, $primary );
				$secondaryText = $entity->getRawMessage( $messageName, $secondary );
				$attribs = array( 'class' => 'securepoll-translate-box' );
				if ( !$this->isAdmin ) {
					$attribs['readonly'] = '1';
				}
				$s .= '<tr><td>' . htmlspecialchars( "$entityName/$messageName" ) . "</td>\n" .
					'<td>' . nl2br( htmlspecialchars( $primaryText ) ) . '</td>' .
					'<td>' . 
					Xml::textarea( $controlName, $secondaryText, 40, 3, $attribs ) .
					"</td></tr>\n";
			}
		}
		$s .= '</table>';
		if ( $this->isAdmin ) {
			$s .= 
			'<p style="text-align: center;">' . 
			Xml::submitButton( wfMsg( 'securepoll-submit-translate' ) ) .
			"</p>";
		}
		$s .= "</form>\n";
		$wgOut->addHTML( $s );
	}

	/**
	 * @return Title
	 */
	function getTitle( $lang = false ) {
		$subpage = 'translate/' . $this->election->getId();
		if ( $lang !== false ) {
			$subpage .= '/' . $lang;
		}
		return $this->parent->getTitle( $subpage );
	}

	/**
	 * Show a language selector to allow the user to choose the language to
	 * translate.
	 */
	function showLanguageSelector( $selectedCode ) {
		$s = 
			Xml::openElement( 'form', 
				array( 
					'action' => $this->getTitle( false )->getLocalUrl()
				) 
			) .
			Xml::openElement( 
				'select', 
				array( 'id' => 'secondary_lang', 'name' => 'secondary_lang' ) 
			) . "\n";
		
		$languages = Language::getLanguageNames();
		ksort( $languages );
		foreach ( $languages as $code => $name ) {
			$s .= "\n" . Xml::option( "$code - $name", $code, $code == $selectedCode );
		}
		$s .= "\n</select>\n" . 
			'<p>' . Xml::submitButton( wfMsg( 'securepoll-submit-select-lang' ) ) . '</p>' .
			"</form>\n";
		global $wgOut;
		$wgOut->addHTML( $s );
	}

	/**
	 * Submit message text changes.
	 */
	function doSubmit( $secondary ) {
		global $wgRequest, $wgOut;

		if ( !$this->isAdmin ) {
			$wgOut->addWikiMsg( 'securepoll-need-admin' );
			return;
		}

		$entities = array_merge( array( $this->election ), $this->election->getDescendants() );
		$replaceBatch = array();
		foreach ( $entities as $entity ) {
			foreach ( $entity->getMessageNames() as $messageName ) {
				$controlName = 'trans_' . $entity->getId() . '_' . $messageName;
				$value = $wgRequest->getText( $controlName );
				if ( $value !== '' ) {
					$replaceBatch[] = array(
						'msg_entity' => $entity->getId(),
						'msg_lang' => $secondary,
						'msg_key' => $messageName,
						'msg_text' => $value
					);
				}
			}
		}
		if ( $replaceBatch ) {
			$dbw = $this->context->getDB();	
			$dbw->replace( 
				'securepoll_msgs', 
				array( array( 'msg_entity', 'msg_lang', 'msg_key' ) ),
				$replaceBatch,
				__METHOD__
			);
		}
		$wgOut->redirect( $this->getTitle( $secondary )->getFullUrl() );
	}
}
