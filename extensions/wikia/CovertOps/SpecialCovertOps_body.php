<?php

/**
 * CovertOps
 *
 * Lets privlidged users edit wikis without leaving a visible trace
 * in RecentChanges and logs. Used for contests.
 *
 * @author Łukasz Garczewski (TOR) <tor@wikia.com>
 * @date 2008-08-18
 * @copyright Copyright (C) 2008 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage SpecialPage
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named SiteWideMessages.\n";
	exit(1) ;
}

class CovertOps extends SpecialPage {
	/**
	 * contructor
	 */
	function  __construct() {
		parent::__construct('CovertOps' /*class*/, 'covertops' /*restriction*/);
	}

	function execute($subpage) {
		global $wgUser, $wgOut, $wgRequest, $wgTitle, $wgParser;
		wfLoadExtensionMessages('CovertOps');

		$template = 'editor';	//default template

		//handle different submit buttons in one form
		if ($wgRequest->getVal('coEdit', false)) {
			$action = 'edit';
		} elseif ($wgRequest->getVal('coPreview', false)) {
			$action = 'preview';
		} elseif ($wgRequest->getVal('coSave', false)) {
			$action = 'save';
		} else {
			$action = 'select';
		}

		if(!$wgUser->isAllowed('covertops')) {
			$wgOut->permissionRequired('covertops');
			return;
		}

		$mTitle = $wgRequest->getText('mTitle');
		$formData['mTitle'] = $mTitle;

		switch ($action) {

			case 'select':
				$wgOut->SetPageTitle(wfMsg('cops-page-title-select'));
				$template = "selector";	
				break;
			case 'save':
				$mArticle = new Article ( Title::newFromText( $mTitle ) );
				$mRevision = Revision::newFromId ( $mArticle->getLatest() );

				/* do a backup and replace current rev text */
				$this->replaceText ( $mRevision );

				/* add page semi-protection */
				$this->covertProtect ( $mArticle );
	
				$title = Title::newFromText($mTitle);
				$redirect = $title->getLocalUrl('action=purge');
				$wgOut->redirect($redirect);
				return;
				break;

                       case 'preview':
                                $formData['messageContent'] = $wgRequest->getText('mContent');
                                if ($formData['messageContent'] != '') {
                                        global $wgUser, $wgParser;
                                        $title = Title::newFromText(uniqid('tmp'));
                                        $options = ParserOptions::newFromUser($wgUser);

                                        //Parse some wiki markup [eg. ~~~~]
                                        $formData['messageContent'] = $wgParser->preSaveTransform($formData['messageContent'], $title, $wgUser, $options);
                                }

                                $formData['messagePreview'] = $wgOut->parse($formData['messageContent']);
                                $wgOut->SetPageTitle(wfMsg('cops-page-title-preview'));
                                break;

			case 'edit':
				$mTitle = $wgRequest->getText('mTitle');
				$article = new Article ( Title::newFromText( $mTitle ) );
				$formData['mTitle'] = $mTitle;
				$formData['messageContent'] = !empty($article) ? $article->getContent() : null;
				//no break - go to 'default' => editor

			default:	//editor
				$wgOut->SetPageTitle(wfMsg('cops-page-title-editor'));
		}

		$oTmpl = new EasyTemplate(dirname( __FILE__ ) . '/templates/');
		$oTmpl->set_vars( array(
				'title' => $wgTitle,
				'formData' => $formData,
				'mTitle' => $mTitle
			));
		$wgOut->addHTML($oTmpl->execute($template));
	}

	function replaceText ( $revision ) {
		global $wgRequest, $wgDefaultExternalStore, $wgCityId;

		$dbw =& wfGetDb( DB_MASTER );
		$mText = $wgRequest->getText('mContent');

		# Backup text or External reference to shared table
		$dbw->insertSelect (
			wfSharedTable('covertops_text'),
			$dbw->tableName('text'),
			array (
				'city_id' => $wgCityId,
				'old_id' => 'old_id',
 				'old_text' => 'old_text'
			),
                        array (
				'old_id' => $revision->getTextId()
			),
			'CovertOps::replaceText',
			array( 'IGNORE' ) # Backup 1st one only, subsequent edits are corrections of the *new* text
		);

		$flags = Revision::compressRevisionText( $mText );

		if ( $wgDefaultExternalStore ) {
			if ( is_array( $wgDefaultExternalStore ) ) {
				// Distribute storage across multiple clusters
	                        $store = $wgDefaultExternalStore[mt_rand(0, count( $wgDefaultExternalStore ) - 1)];
                        } else {
				$store = $wgDefaultExternalStore;
			}

			$new_text = ExternalStore::insert( $store, $mText );

			if ( $flags ) {
				$flags .= ',';
			}
			$flags .= 'external';

		} else {
			$new_text = $mText;
		}
	
		$dbw->update(
			$dbw->tableName( 'text' ),
			array( 'old_text' => $new_text ),
			array( 'old_id' => $revision->getTextId ),
			'CovertOps::replaceText'
		);
		
		if ($wgDefaultExternalStore) {
			ExternalStorageUpdate::addDeferredUpdate( $revision, $new_text, $flags );
		}
	}

	function covertProtect ( $article ) {
		$dbw =& wfGetDb( DB_MASTER );

		# Protect bypassing form and logging
		$dbw->insert(
			$dbw->tableName ('page_restrictions'),
			array(
				'pr_page' => $article->getId(),
				'pr_type' => 'edit',
				'pr_level' => 'autoconfirmed',
				'pr_cascade' => 0,
				'pr_user' => NULL,
				'pr_expiry' => 'infinity',
				'pr_id' => NULL
			),
			'CovertOps::covertProtect',
			array( 'IGNORE' )
		);
	}
}
