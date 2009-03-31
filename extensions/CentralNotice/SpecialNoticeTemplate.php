<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "CentralNotice extension\n";
	exit( 1 );
}

class SpecialNoticeTemplate extends UnlistedSpecialPage {

	/* Functions */

	function __construct() {
		// Initialize special page
		parent::__construct( 'NoticeTemplate' );

		// Internationalization
		wfLoadExtensionMessages( 'CentralNotice' );
	}

	function execute( $sub ) {
		global $wgOut, $wgUser, $wgRequest;

		// Begin output
		$this->setHeaders();

		// Get current skin
		$sk = $wgUser->getSkin();

		// Check permissions
		$this->editable = $wgUser->isAllowed( 'centralnotice-admin' );

		// Show summary
		$wgOut->addWikiText( wfMsg( 'centralnotice-summary' ) );

		// Show header
		CentralNotice::printHeader();

		if( $this->editable ) {
			// Handle forms
			if ( $wgRequest->wasPosted() ) {
	
				// Handle removing
				$toRemove = $wgRequest->getArray( 'removeTemplates' );
				if ( isset( $toRemove ) ) {
					// Remove templates in list
					foreach ( $toRemove as $template ) {
						$this->removeTemplate( $template );
					}
				}
	
				// Handle translation message update
				$update = $wgRequest->getArray( 'updateText' );
				$token  = $wgRequest->getArray( 'token' );
				if ( isset ( $update ) ) {
					foreach ( $update as $lang => $messages ) {
						foreach ( $messages as $text => $translation ) {
							// If we actually have text
							if ( $translation ) {
								$this->updateMessage( $text, $translation, $lang, $token );
							}
						}
					}
				}
			}
	
			// Handle adding
			if ( $wgRequest->getVal( 'wpMethod' ) == 'addTemplate' ) {
				$this->addTemplate(
					$wgRequest->getVal( 'templateName' ),
					$wgRequest->getVal( 'templateBody' )
				);
				$sub = 'view';
			}
			if ( $wgRequest->getVal( 'wpMethod' ) == 'editTemplate' ) {
				$this->editTemplate(
					$wgRequest->getVal( 'template' ),
					$wgRequest->getVal( 'templateBody' )
				);
				$sub = 'view';
			}
		}

                // Handle viewiing of a template in all languages
                if ( $sub == 'view' && $wgRequest->getVal( 'wpUserLanguage' ) == 'all' ) {
                        $template =  $wgRequest->getVal( 'template' );
                        $this->showViewAvailable( $template );
                        return;
                }

		// Handle viewing a specific template
		if ( $sub == 'view' && $wgRequest->getText( 'template' ) != '' ) {
			$this->showView();
			return;
		}

		if( $this->editable ) {
			// Handle viewing a specific template
			if ( $sub == 'add' ) {
				$this->showAdd();
				return;
			}
                        if ( $sub == 'clone' ) {
                            $oldTemplate = $wgRequest->getVal( 'oldTemplate' );
                            $newTemplate =  $wgRequest->getVal( 'newTemplate' );
                            //We use the returned name in case any special characters had to be removed
                            $template = $this->cloneTemplate( $oldTemplate, $newTemplate );
                            $wgOut->redirect( SpecialPage::getTitleFor( 'NoticeTemplate', 'view' )->getLocalUrl( "template=$template" ) );
                            return;
                        }
		}

		// Show list by default
		$this->showList();
	}

	function showList() {
		global $wgOut, $wgTitle, $wgUser, $wgRequest;

		$sk = $wgUser->getSkin();

		// Templates
		$templates = $this->queryTemplates();
		if ( count( $templates ) > 0 ) {
			$htmlOut = '';
			
			if( $this->editable ) {
				$htmlOut .= Xml::openElement( 'form',
					array(
						'method' => 'post',
						'action' => ''
					 )
				);
			}
			$htmlOut .= Xml::fieldset( wfMsg( 'centralnotice-available-templates' ) );
			$htmlOut .= Xml::openElement( 'table',
				array(
					'cellpadding' => 9,
					'width' => '100%'
				)
			);
			if( $this->editable ) {
				$htmlOut .= Xml::element( 'th', array( 'align' => 'left', 'width' => '5%' ),
					wfMsg ( 'centralnotice-remove' )
				);
			}
			$htmlOut .= Xml::element( 'th', array( 'align' => 'left' ),
				wfMsg ( 'centralnotice-template-name' )
			);

			$msgConfirmDelete = wfMsgHTML( 'centralnotice-confirm-delete' );
			foreach ( $templates as $templateName ) {
				$viewPage = SpecialPage::getTitleFor( 'NoticeTemplate', 'view' );
				$htmlOut .= Xml::openElement( 'tr' );

				if( $this->editable ) {
					// Remove box
					$htmlOut .= Xml::tags( 'td', array( 'valign' => 'top' ),
						Xml::check( 'removeTemplates[]', false,
							array(
								'value' => $templateName,
								'onchange' => "if(this.checked){this.checked=confirm('{$msgConfirmDelete}')}"
							)
						)
					);
				}

				// Link and Preview
				$render = new SpecialNoticeText();
				$render->project = 'wikipedia';
				$render->language = $wgRequest->getVal( 'wpUserLanguage' );
				$htmlOut .= Xml::tags( 'td', array( 'valign' => 'top' ),
					$sk->makeLinkObj( $viewPage,
						htmlspecialchars( $templateName ),
						'template=' . urlencode( $templateName ) ) .
					Xml::fieldset( wfMsg( 'centralnotice-preview' ),
						$render->getHtmlNotice( $templateName )
					)
				);

				$htmlOut .= Xml::closeElement( 'tr' );
			}
			if( $this->editable ) {
				$htmlOut .= Xml::tags( 'tr', null,
					Xml::tags( 'td', array( 'colspan' => 3 ),
						Xml::submitButton( wfMsg( 'centralnotice-modify' ) )
					)
				);
			}
		} else {
			$htmlOut = Xml::tags( 'tr', null,
				Xml::element( 'td', null, wfMsg( 'centralnotice-no-templates' ) )
			);
		}

		$htmlOut .= Xml::closeElement( 'table' );
		$htmlOut .= Xml::closeElement( 'fieldset' );
		if( $this->editable ) {
			$htmlOut .= Xml::closeElement( 'form' );

		$htmlOut .= Xml::element( 'p' );
		$newPage = SpecialPage::getTitleFor( 'NoticeTemplate', 'add' );
		$htmlOut .= $sk->makeLinkObj( $newPage, wfMsgHtml( 'centralnotice-add-template' ) );
		}

		// Output HTML
		$wgOut->addHTML( $htmlOut );
	}

	function showAdd() {
		global $wgOut, $wgTitle, $wgUser;

		// Build HTML
		$htmlOut = Xml::openElement( 'form', array( 'method' => 'post' ) );
		$htmlOut .= Xml::openElement( 'fieldset' );
		$htmlOut .= Xml::element( 'legend', null, wfMsg( 'centralnotice-add-template' ) );
		$htmlOut .= Xml::hidden( 'wpMethod', 'addTemplate' );
		$htmlOut .= Xml::tags( 'p', null,
			Xml::inputLabel(
				wfMsg( 'centralnotice-template-name' ),
				'templateName',
				'templateName',
				25
			)
		);
		$htmlOut .= Xml::tags( 'p', null,
			Xml::textarea( 'templateBody', '', 60, 20 )
		);
		$htmlOut .= Xml::tags( 'p', null,
			Xml::submitButton( wfMsg( 'centralnotice-modify' ) )
		);
		$htmlOut .= Xml::closeElement( 'fieldset' );
		$htmlOut .= Xml::closeElement( 'form' );

		// Output HTML
		$wgOut->addHTML( $htmlOut );
	}

	private function showView() {
		global $wgOut, $wgUser, $wgRequest, $wgContLanguageCode;

		$sk = $wgUser->getSkin();
		if( $this->editable ) {
			$readonly = array();
		} else {
			$readonly = array( 'readonly' => 'readonly' );
		}

		// Get token
		$token = $wgUser->editToken();

		// Get user's language
		$wpUserLang = $wgRequest->getVal( 'wpUserLanguage' ) ? $wgRequest->getVal( 'wpUserLanguage' ) : $wgContLanguageCode;

		// Get current template
		$currentTemplate = $wgRequest->getText( 'template' );

		// Show preview
		$render = new SpecialNoticeText();
		$render->project = 'wikipedia';
		$render->language = $wgRequest->getVal( 'wpUserLanguage' );
		$htmlOut = Xml::fieldset( wfMsg( 'centralnotice-preview' ),
			$render->getHtmlNotice( $wgRequest->getText( 'template' ) )
		);

		// Build HTML
		if( $this->editable ) {
			$htmlOut .= Xml::openElement( 'form', array( 'method' => 'post' ) );
		}
		$htmlOut .= Xml::fieldset( wfMsgHtml( 'centralnotice-translate-heading', $currentTemplate ) );
		$htmlOut .= Xml::openElement( 'table',
			array (
				'cellpadding' => 9,
				'width' => '100%'
			)
		);

		// Headers
		$htmlOut .= Xml::element( 'th', array( 'width' => '15%' ), wfMsg( 'centralnotice-message' ) );
		$htmlOut .= Xml::element( 'th', array( 'width' => '5%' ), wfMsg ( 'centralnotice-number-uses' )  );
		$htmlOut .= Xml::element( 'th', array( 'width' => '40%' ), wfMsg ( 'centralnotice-english' ) );
		$languages = Language::getLanguageNames();
		$htmlOut .= Xml::element( 'th', array( 'width' => '40%' ), $languages[$wpUserLang] );

                // Pull text and respect any inc: markup
                $bodyPage = Title::newFromText( "Centralnotice-template-{$currentTemplate}", NS_MEDIAWIKI );
		$body = Revision::newFromTitle( $bodyPage )->getText();
    
		$fields = array();
		preg_match_all( '/\{\{\{([A-Za-z0-9\_\-}]+)\}\}\}/', $body, $fields );

		// Remove duplicates
		$filteredFields = array();
		foreach ( $fields[1] as $field ) {
			$filteredFields[$field] = array_key_exists( $field, $filteredFields ) ? $filteredFields[$field] + 1 : 1;
		}

		// Rows
		foreach ( $filteredFields as $field => $count ) {
			// Message
			$message = ( $wpUserLang == 'en' ) ? "Centralnotice-{$currentTemplate}-{$field}" : "Centralnotice-{$currentTemplate}-{$field}/{$wpUserLang}";

			// English value
			$htmlOut .= Xml::openElement( 'tr' );

			$title = Title::newFromText( "MediaWiki:{$message}" );
			$htmlOut .= Xml::tags( 'td', null,
				$sk->makeLinkObj( $title, htmlspecialchars( $field ) )
			);

			$htmlOut .= Xml::element( 'td', null, $count );

			// English text
			$englishText = wfMsg( 'centralnotice-message-not-set' );
			$englishTextExists = false;
			if ( Title::newFromText( "Centralnotice-{$currentTemplate}-{$field}", NS_MEDIAWIKI )->exists() ) {
				$englishText = wfMsgExt( "Centralnotice-{$currentTemplate}-{$field}",
					array( 'language' => 'en' )
				);
				$englishTextExists = true;
			}
			$htmlOut .= Xml::tags( 'td', null,
				Xml::element( 'span',
					array( 'style' => 'font-style:italic;' . ( !$englishTextExists ? 'color:silver' : '' ) ),
					$englishText
				)
			);

			// Foreign text input
			$foreignText = '';
			$foreignTextExists = false;
			if ( Title::newFromText( $message, NS_MEDIAWIKI )->exists() ) {
				$foreignText = wfMsgExt( "Centralnotice-{$currentTemplate}-{$field}",
					array( 'language' => $wpUserLang )
				);
				$foreignTextExists = true;
			}
			$htmlOut .= Xml::tags( 'td', null,
				Xml::input( "updateText[{$wpUserLang}][{$currentTemplate}-{$field}]", '', $foreignText,
					wfArrayMerge( $readonly,
						array( 'style' => 'width:100%;' . ( !$foreignTextExists ? 'color:red' : '' ) ) )
				)
			);
			$htmlOut .= Xml::closeElement( 'tr' );
		}
		if( $this->editable ) {
			$htmlOut .= Xml::hidden( 'token', $token );
			$htmlOut .= Xml::hidden( 'wpUserLanguage', $wpUserLang );
			$htmlOut .= Xml::openElement( 'tr' );
			$htmlOut .= Xml::tags( 'td', array( 'colspan' => 4 ),
				Xml::submitButton( wfMsg( 'centralnotice-modify', array( 'name' => 'update' ) ) )
			);
			$htmlOut .= Xml::closeElement( 'tr' );
		}
		$htmlOut .= Xml::closeElement( 'table' );
		$htmlOut .= Xml::closeElement( 'fieldset' );
		if( $this->editable ) {
			$htmlOut .= Xml::closeElement( 'form' );
		}

		/*
		 * Show language selection form
		 */
		$htmlOut .= Xml::openElement( 'form', array( 'method' => 'post' ) );
		$htmlOut .= Xml::fieldset( wfMsgHtml( 'centralnotice-change-lang' ) );
		$htmlOut .= Xml::openElement( 'table', array ( 'cellpadding' => 9 ) );
		list( $lsLabel, $lsSelect ) = Xml::languageSelector( $wpUserLang );

                $newPage = SpecialPage::getTitleFor( 'NoticeTemplate', 'view' );
                 
		$htmlOut .= Xml::tags( 'tr', null,
			Xml::tags( 'td', null, $lsLabel ) .
			Xml::tags( 'td', null, $lsSelect ) .
			Xml::tags( 'td', array( 'colspan' => 2 ),
				Xml::submitButton( wfMsgHtml( 'centralnotice-modify' ) )
			)
                ); 
                $htmlOut .= Xml::tags( 'tr', null,
                    Xml::tags( 'td', null, '' ) .
                    Xml::tags( 'td', null, $sk->makeLinkObj( $newPage, wfMsg( 'centralnotice-preview-all-template-translations' ), "template=$currentTemplate&wpUserLanguage=all" ) )
		);
		$htmlOut .= Xml::closeElement( 'table' );
		$htmlOut .= Xml::closeElement( 'fieldset' );
		$htmlOut .= Xml::closeElement( 'form' );

		/*
		 * Show edit form
		 */
		if( $this->editable ) {
			$htmlOut .= Xml::openElement( 'form', array( 'method' => 'post' ) );
			$htmlOut .= Xml::hidden( 'wpMethod', 'editTemplate' );
		}
		$htmlOut .= Xml::fieldset( wfMsgHtml( 'centralnotice-edit-template' ) );
		$htmlOut .= Xml::openElement( 'table',
			array(
				'cellpadding' => 9,
				'width' => '100%'
			)
		);
		$htmlOut .= Xml::tags( 'tr', null,
			Xml::tags( 'td', null, Xml::textarea( 'templateBody', $body, 60, 20, $readonly ) )
		);
		if( $this->editable ) {
			$htmlOut .= Xml::tags( 'tr', null,
				Xml::tags( 'td', null, Xml::submitButton( wfMsgHtml( 'centralnotice-modify' ) ) )
			);
		}
		$htmlOut .= Xml::closeElement( 'table' );
		$htmlOut .= Xml::closeElement( 'fieldset' );
		if( $this->editable ) {
			$htmlOut .= Xml::closeElement( 'form' );
		}

                /*
                 * Show Clone form
                 */
                if ( $this->editable ) { 
                        $htmlOut .= Xml::openElement ( 'form', 
                                array(
                                        'method' => 'post',
                                        'action' => SpecialPage::getTitleFor( 'NoticeTemplate', 'clone' )->getLocalUrl()
                                )
                        );

                        $htmlOut .= Xml::fieldset( wfMsg( 'centralnotice-clone-notice' ) );
                        $htmlOut .= Xml::openElement( 'table', array( 'cellpadding' => 9 ) );
                        $htmlOut .= Xml::openElement( 'tr' );
                        $htmlOut .= Xml::inputLabel( 'Name:', 'newTemplate', 'newTemplate, 25');
                        $htmlOut .= Xml::submitButton( wfMsg( 'centralnotice-clone' ), array ( 'id' => 'clone' ) );
                        $htmlOut .= Xml::hidden( 'oldTemplate', $currentTemplate );

                        $htmlOut .= Xml::closeElement( 'tr' );
                        $htmlOut .= Xml::closeElement( 'table' );
                        $htmlOut .= Xml::closeElement( 'form' );
                }

                // Output HTML
                $wgOut->addHTML( $htmlOut );
        }

        public function showViewAvailable( $template ) {
            global $wgOut, $wgUser;

            // Testing to see if bumping up the memory limit lets meta preview
            ini_set( 'memory_limit', '120M' );

            $sk = $wgUser->getSkin();

            // Pull all available text for a template
            $langs = array_keys( $this->getTranslations( $template ) );
            $htmlOut = '';
    
            foreach( $langs as $lang ) {
                // Link and Preview all available translations
                $viewPage = SpecialPage::getTitleFor( 'NoticeTemplate', 'view' );
                $render = new SpecialNoticeText();
                $render->project = 'wikipedia';
                $render->language = $lang;
                $htmlOut .= Xml::tags( 'td', array( 'valign' => 'top' ),
                        $sk->makeLinkObj( $viewPage,
                                $lang,
                                'template=' . urlencode( $template ) . "&wpUserLanguage=$lang") . 
                        Xml::fieldset( wfMsg( 'centralnotice-preview' ),
                                $render->getHtmlNotice( $template )
                        )
                );
            }
            return $wgOut->addHtml( $htmlOut );
        }
            
	private function updateMessage( $text, $translation, $lang, $token = false ) {
		global $wgUser;

		$title = Title::newFromText(
			( $lang == 'en' ) ? "Centralnotice-{$text}" : "Centralnotice-{$text}/{$lang}",
			NS_MEDIAWIKI
		);
		$article = new Article( $title );
		$article->doEdit( $translation, '', EDIT_FORCE_BOT );
	}

	static function queryTemplates() {
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'cn_templates',
			array( 'tmp_name', 'tmp_id' ),
			'',
			__METHOD__,
			array( 'ORDER BY' => 'tmp_id' )
		);

		$templates = array();
		while ( $row = $dbr->fetchObject( $res ) ) {
			array_push( $templates, $row->tmp_name );
		}

		return $templates;
	}

	private function getTemplateId ( $templateName ) {
		global $wgOut, $egCentralNoticeTables;

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'cn_templates', 'tmp_id',
			array( 'tmp_name' => $templateName ),
			__METHOD__
		);

		$row = $dbr->fetchObject( $res );
		if ( $row ) {
			return $row->tmp_id;
		}
		return null;
	}

	private function removeTemplate ( $name ) {
		global $wgOut, $egCentralNoticeTables;

		if ( $name == '' ) {
			$wgOut->addHTML( wfMsg( 'centralnotice-template-doesnt-exist' ) );
			return;
		}

		$id = $this->getTemplateId( $name );
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'cn_assignments', 'asn_id', array( 'tmp_id' => $id ), __METHOD__ );

		if ( $dbr->numRows( $res ) > 0 ) {
			$wgOut->addHTML( wfMsg( 'centralnotice-template-still-bound' ) );
			return;
		} else {
			$dbw = wfGetDB( DB_MASTER );
			$dbw->begin();
			$res = $dbw->delete( 'cn_templates',
				array( 'tmp_id' => $id ),
				__METHOD__
			);
			$dbw->commit();

			$article = new Article(
				Title::newFromText( "centralnotice-template-{$name}", NS_MEDIAWIKI )
			);
			$article->doDeleteArticle( 'CentralNotice Automated Removal' );
		}
	}

	private function addTemplate ( $name, $body ) {
		global $wgOut, $egCentralNoticeTables;

		if ( $body == '' || $name == '' ) {
			$wgOut->addHTML( wfMsg( 'centralnotice-null-string' ) );
			return;
		}

		// Format name so there are only letters, numbers, and underscores
		$name = ereg_replace( '[^A-Za-z0-9\_]', '', $name );

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'cn_templates', 'tmp_name',
			array( 'tmp_name' => $name ),
			__METHOD__
		);

		if ( $dbr->numRows( $res ) > 0 ) {
			$wgOut->addHTML( wfMsg( 'centralnotice-template-exists' ) );
			return false;
		} else {
			$dbw = wfGetDB( DB_MASTER );
			$dbw->begin();
			$res = $dbw->insert( 'cn_templates',
				array( 'tmp_name' => $name ),
				__METHOD__
			);
			$dbw->commit();

			/*
			 * Perhaps these should move into the db as blob
			 */
			$article = new Article(
				Title::newFromText( "centralnotice-template-{$name}", NS_MEDIAWIKI )
			);
			$article->doEdit( $body, '', EDIT_FORCE_BOT );
			return true;
		}
	}

	private function editTemplate ( $name, $body ) {
		global $wgOut, $egCentralNoticeTables;

		if ( $body == '' || $name == '' ) {
			$wgOut->addHTML( wfMsg( 'centralnotice-null-string' ) );
			return;
		}

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'cn_templates', 'tmp_name',
			array( 'tmp_name' => $name ),
			__METHOD__
		);

		if ( $dbr->numRows( $res ) > 0 ) {
			/*
			 * Perhaps these should move into the db as blob
			 */
			$article = new Article(
				Title::newFromText( "centralnotice-template-{$name}", NS_MEDIAWIKI )
			);
			$article->doEdit( $body, '', EDIT_FORCE_BOT );
			return;
		}
	}

        /*
         * Copy all the data from one template to another
         */
        public function cloneTemplate( $source, $dest ) {
            // Reset the timer as updates on meta take a long time
            set_time_limit( 60 );
            // Pull all possible langs
            $langs = $this->getTranslations( $source );
            
            // Normalize name
	    $dest = ereg_replace( '[^A-Za-z0-9\_]', '', $dest );
     
            // Pull text and respect any inc: markup
            $bodyPage = Title::newFromText( "Centralnotice-template-{$source}", NS_MEDIAWIKI );
            $template_body = Revision::newFromTitle( $bodyPage )->getText();

            if ( $this->addTemplate( $dest, $template_body ) ) {

                // Populate the fields
                foreach($langs as $lang => $fields ) {
                    foreach( $fields as $field => $text ) {
                         $this->updateMessage( "$dest-$field", $text, $lang );
                    }
                }
             return $dest;
            }
        }

        /*
         * Find all fields set for a template
         */
        private function findFields( $template ) {
                $messages = array();
                $body = wfMsg( "Centralnotice-template-{$template}" );
    
                // Generate fields from parsing the body
                $fields = array();
                preg_match_all( '/\{\{\{([A-Za-z0-9\_\-}]+)\}\}\}/', $body, $fields );
    
                // Remove duplicates
                $filteredFields = array();
                foreach ( $fields[1] as $field ) { 
                        $filteredFields[$field] = array_key_exists( $field, $filteredFields ) ? $filteredFields[$field] + 1 :
1;
                }
                return $filteredFields;
        }

        /*
         * Given a template return a list of every set field in every language
         */
        public function getTranslations( $template ) {
            $translations = array();

            // Pull all language codes to enumerate
            $allLangs = array_keys( Language::getLanguageNames() );
            
            // Lookup all the possible fields for a template
            $fields = $this->findFields( $template );

            // Iterate through all possible languages to find matches
            foreach ( $allLangs as $lang ) {
                // Iterate through all possible fields
                foreach ( $fields as $field => $count ) {
                    // Put all fields together for a lookup
                    $message = ( $lang == 'en' ) ? "Centralnotice-{$template}-{$field}" : "Centralnotice-{$template}-{$field}/{$lang}";
                    if ( Title::newFromText( $message,  NS_MEDIAWIKI )->exists() ) {
                        $translations[$lang][$field] = wfMsgExt( "Centralnotice-{$template}-{$field}", 
                                                array( 'language' => $lang )
                        );
                    }
                }
            }
            return $translations;
        }
}
