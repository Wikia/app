<?php
/**
 * @addtogroup Extensions
 *
 * @author Niklas Laxström
 * @author Siebrand Mazeland
 * @copyright Copyright © 2009-2010, Niklas Laxström, Siebrand Mazeland
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class SpecialManageGroups {
	protected $skin, $user, $out;
	protected $processingTime = 10; // Seconds

	public function __construct() {
		global $wgOut, $wgUser;
		$this->out = $wgOut;
		$this->user = $wgUser;
		$this->skin = $wgUser->getSkin();
	}

	public function execute() {
		global $wgRequest;

		$this->out->setPageTitle( htmlspecialchars( wfMsg( 'translate-managegroups' ) ) );

		$group = $wgRequest->getText( 'group' );
		$group = MessageGroups::getGroup( $group );

		if ( $group ) {
			if ( $wgRequest->getBool( 'rebuildall', false ) &&
				$wgRequest->wasPosted() &&
				$this->user->isAllowed( 'translate-manage' ) &&
				$this->user->matchEditToken( $wgRequest->getVal( 'token' ) ) ) {

				$cache = new MessageGroupCache( $group );
				$languages = explode( ',', $wgRequest->getText( 'codes' ) );
				foreach ( $languages as $code ) {
					$messages = $group->load( $code );
					if ( count( $messages ) ) $cache->create( $messages, $code );
				}
			}

			$cache = new MessageGroupCache( $group );
			$code = $wgRequest->getText( 'language', 'en' );
			$this->importForm( $cache, $group, $code );
		} else {
			global $wgLang, $wgOut;

			$groups = MessageGroups::singleton()->getGroups();

			$wgOut->wrapWikiMsg( '==$1==', 'translate-manage-listgroups' );
			$separator = wfMsg( 'word-separator' );

			foreach ( $groups as $group ) {
				if ( !$group instanceof FileBasedMessageGroup ) continue;

				$link = $this->skin->link( $this->getTitle(), $group->getLabel(), array(), array( 'group' => $group->getId() ) );
				$out = $link . $separator;

				$cache = new MessageGroupCache( $group );

				if ( $cache->exists() ) {
					$timestamp = wfTimestamp( TS_MW, $cache->getTimestamp() );
					$out .= wfMsg( 'translate-manage-cacheat',
						$wgLang->date( $timestamp ),
						$wgLang->time( $timestamp )
					);
				} else {
					$out .= wfMsg( 'translate-manage-newgroup' );
				}

				$wgOut->addHtml( $out );
				$wgOut->addHtml( '<hr>' );
			}

			$wgOut->wrapWikiMsg( '==$1==', 'translate-manage-listgroups-old' );
			$wgOut->addHTML( '<ul>' );

			foreach ( $groups as $group ) {
				if ( $group instanceof FileBasedMessageGroup ) continue;

				$wgOut->addHtml( Xml::element( 'li', null, $group->getLabel() ) );
			}

			$wgOut->addHTML( '</ul>' );
		}
	}

	public function getTitle() {
		return SpecialPage::getTitleFor( 'Translate', 'manage' );
	}

	public function importForm( $cache, $group, $code ) {
		$this->setSubtitle( $group, $code );

		$formParams = array(
			'method' => 'post',
			'action' => $this->getTitle()->getFullURL( array( 'group' => $group->getId() ) ),
			'class'  => 'mw-translate-manage'
		);

		global $wgRequest;
		if ( $wgRequest->wasPosted() &&
			$wgRequest->getBool( 'process', false ) &&
			$this->user->isAllowed( 'translate-manage' ) &&
			$this->user->matchEditToken( $wgRequest->getVal( 'token' ) ) ) {
			$process = true;
		} else {
			$process = false;
		}

		$this->out->addHTML(
			Xml::openElement( 'form', $formParams ) .
			Xml::hidden( 'title', $this->getTitle()->getPrefixedText() ) .
			Xml::hidden( 'token', $this->user->editToken() ) .
			Xml::hidden( 'group', $group->getId() ) .
			Xml::hidden( 'process', 1 )
		);

		// BEGIN
		$messages = $group->load( $code );

		if ( !$cache->exists() && $code === 'en' ) {
			$cache->create( $messages );
		}

		$collection = $group->initCollection( $code );
		$collection->loadTranslations();

		$diff = new DifferenceEngine;
		$diff->showDiffStyle();
		$diff->setReducedLineNumbers();

		$changed = array();
		foreach ( $messages as $key => $value ) {
			$fuzzy = $old = false;

			if ( isset( $collection[$key] ) ) {
				$old = $collection[$key]->translation();
				$fuzzy = TranslateEditAddons::hasFuzzyString( $old ) ||
						TranslateEditAddons::isFuzzy( MessageWebImporter::makeTranslationTitle( $group, $key, $code ) );
				$old = str_replace( TRANSLATE_FUZZY, '', $old );
			}

			// No changes at all, ignore
			if ( $old === $value ) {
				continue;
			}

			if ( $old === false ) {
				$name = wfMsgHtml( 'translate-manage-import-new',
					'<code style="font-weight:normal;">' . htmlspecialchars( $key ) . '</code>'
				);

				$text = TranslateUtils::convertWhiteSpaceToHTML( $value );

				$changed[] = MessageWebImporter::makeSectionElement( $name, 'new', $text );
			} else {
				if ( $fuzzy ) {
					$old = TRANSLATE_FUZZY . $old;
				}

				$diff->setText( $old, $value );
				$text = $diff->getDiff( '', '' );
				$type = 'changed';

				if ( $process ) {
					if ( !count( $changed ) ) {
						$changed[] = '<ul>';
					}

					global $wgRequest, $wgLang;

					$action = $wgRequest->getVal( "action-$type-$key" );

					if ( $action === null ) {
						$message = wfMsgExt( 'translate-manage-inconsistent', 'parseinline', wfEscapeWikiText( "action-$type-$key" ) );
						$changed[] = "<li>$message</li></ul>";
						$process = false;
					} else {
						// Check processing time
						if ( !isset( $this->time ) ) {
							$this->time = wfTimestamp();
						}

						$fuzzybot = MessageWebImporter::getFuzzyBot();
						$message = MessageWebImporter::doAction(
							$action,
							$group,
							$key,
							$code,
							$value,
							'', /* default edit summary */
							$fuzzybot,
							EDIT_FORCE_BOT
						);

						$key = array_shift( $message );
						$params = $message;
						$message = wfMsgExt( $key, 'parseinline', $params );
						$changed[] = "<li>$message</li>";

						if ( $this->checkProcessTime() ) {
							$process = false;
							$duration = $wgLang->formatNum( $this->processingTime );
							$message = wfMsgExt( 'translate-manage-toolong', 'parseinline', $duration );
							$changed[] = "<li>$message</li></ul>";
						}
						continue;
					}
				}

				if ( $code !== 'en' ) {
					$actions = array( 'import', 'conflict', 'ignore' );
				} else {
					$actions = array( 'import', 'fuzzy', 'ignore' );
				}

				$act = array();
				$defaction = $fuzzy ? 'conflict' : 'import';

				foreach ( $actions as $action ) {
					$label = wfMsg( "translate-manage-action-$action" );
					$act[] = Xml::radioLabel( $label, "action-$type-$key", $action, "action-$key-$action", $action === $defaction );
				}

				$name = wfMsg( 'translate-manage-import-diff',
					'<code style="font-weight:normal;">' . htmlspecialchars( $key ) . '</code>',
					implode( ' ', $act )
				);

				$changed[] = MessageWebImporter::makeSectionElement( $name, $type, $text );
			}
		}

		if ( !$process ) {
			$collection->filter( 'hastranslation', false );
			$keys = array_keys( $collection->keys() );

			$diff = array_diff( $keys, array_keys( $messages ) );

			foreach ( $diff as $s ) {
				$name = wfMsgHtml( 'translate-manage-import-deleted',
					'<code style="font-weight:normal;">' . htmlspecialchars( $s ) . '</code>'
				);

				$text = TranslateUtils::convertWhiteSpaceToHTML(  $collection[$s]->translation() );

				$changed[] = MessageWebImporter::makeSectionElement( $name, 'deleted', $text );
			}
		}

		if ( $process || ( !count( $changed ) && $code !== 'en' ) ) {
			if ( !count( $changed ) ) {
				$this->out->addWikiMsg( 'translate-manage-nochanges-other' );
			}

			if ( !count( $changed ) || strpos( $changed[count( $changed ) - 1], '<li>' ) !== 0 ) {
				$changed[] = '<ul>';
			}

			$cache->create( $messages, $code );
			$message = wfMsgExt( 'translate-manage-import-rebuild', 'parseinline' );
			$changed[] = "<li>$message</li>";
			$message = wfMsgExt( 'translate-manage-import-done', 'parseinline' );
			$changed[] = "<li>$message</li></ul>";
			$this->out->addHTML( implode( "\n", $changed ) );
		} else {
			// END
			if ( count( $changed ) ) {
				if ( $code === 'en' ) {
					$this->out->addWikiMsg( 'translate-manage-intro-en' );
				} else {
					global $wgLang;
					$lang = TranslateUtils::getLanguageName( $code, false, $wgLang->getCode() );
					$this->out->addWikiMsg( 'translate-manage-intro-other', $lang );
				}
				$this->out->addHTML( Xml::hidden( 'language', $code ) );
				$this->out->addHTML( implode( "\n", $changed ) );
				$this->out->addHTML( Xml::submitButton( wfMsg( 'translate-manage-submit' ) ) );
			} else {
				$this->out->addWikiMsg( 'translate-manage-nochanges' );
			}
		}

		$this->out->addHTML( '</form>' );

		if ( $code === 'en' ) {
			$this->doModLangs( $cache, $group );
		} else {
			$this->out->addHTML( '<p>' . $this->skin->link(
				$this->getTitle(),
				wfMsgHtml( 'translate-manage-return-to-group' ),
				array(),
				array( 'group' => $group->getId() )
			) . '</p>' );
		}
	}

	public function doModLangs( $cache, $group ) {
		global $wgLang;

		$languages = array_keys( Language::getLanguageNames( false ) );
		$modified = $codes = array();

		foreach ( $languages as $code ) {
			if ( $code === 'en' ) {
				continue;
			}

			$filename = $group->getSourceFilePath( $code );
			$mtime = file_exists( $filename ) ? filemtime( $filename ) : false;
			$cachetime = $cache->exists( $code ) ? $cache->getTimestamp( $code ) : false;

			if ( $mtime === false && $cachetime === false ) {
				continue;
			}

			$link = $this->skin->link(
				$this->getTitle(),
				htmlspecialchars( TranslateUtils::getLanguageName( $code, false, $wgLang->getCode() ) . " ($code)" ),
				array(),
				array( 'group' => $group->getId(), 'language' => $code )
			);

			if ( $mtime === false ) {
				$modified[] = wfMsgHtml( 'translate-manage-modlang-new', $link  );
			} elseif ( $mtime > $cachetime  ) {
				$modified[] = $link;
			}

			$codes[] = $code;
		}

		if ( count( $modified ) ) {
			$this->out->addWikiMsg( 'translate-manage-modlangs',
				$wgLang->formatNum( count( $modified ) )
			);

			$this->out->addHTML(
				'<ul><li>' . implode( "</li>\n<li>", $modified ) . '</li></ul>'
			);

			$formParams = array(
				'method' => 'post',
				'action' => $this->getTitle()->getFullURL( array( 'group' => $group->getId() ) ),
			);

			global $wgRequest;

			if ( $wgRequest->wasPosted() &&
				$this->user->isAllowed( 'translate-manage' ) &&
				$this->user->matchEditToken( $wgRequest->getVal( 'token' ) ) ) {
				$process = true;
			} else {
				$process = false;
			}

			$this->out->addHTML(
				Xml::openElement( 'form', $formParams ) .
				Xml::hidden( 'title', $this->getTitle()->getPrefixedText() ) .
				Xml::hidden( 'token', $this->user->editToken() ) .
				Xml::hidden( 'group', $group->getId() ) .
				Xml::hidden( 'codes', implode( ',', $codes ) ) .
				Xml::hidden( 'rebuildall', 1 ) .
				Xml::submitButton( wfMsg( 'translate-manage-import-rebuild-all' ) ) .
				Xml::closeElement( 'form' )
			);
		}
	}

	protected function checkProcessTime() {
		return wfTimestamp() - $this->time >= $this->processingTime;
	}

	protected function setSubtitle( $group, $code ) {
		global $wgLang;
		$links[] = $this->skin->link(
			$this->getTitle(),
			wfMsgHtml( 'translate-manage-subtitle' )
		);

		$links[] = $this->skin->link(
			$this->getTitle(),
			$group->getLabel(),
			array(),
			array( 'group' => $group->getId() )
		);

		if ( $code !== 'en' ) {
			$links[] = $this->skin->link(
				$this->getTitle(),
				TranslateUtils::getLanguageName( $code, false, $wgLang->getCode() ),
				array(),
				array( 'group' => $group->getId(), 'language' => $code )
			);
		}

		$this->out->setSubtitle( implode( ' > ', $links ) );
	}
}
