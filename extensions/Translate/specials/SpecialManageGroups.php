<?php
/**
 * Implements special page for group management, where file based message
 * groups are be managed.
 *
 * @ingroup SpecialPage
 * @file
 * @author Niklas Laxström
 * @author Siebrand Mazeland
 * @copyright Copyright © 2009-2010, Niklas Laxström, Siebrand Mazeland
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Class for special page Special:ManageMessageGroups. On this special page
 * file based message groups can be managed (FileBasedMessageGroup). This page
 * allows updating of the file cache, import and fuzzy for source language
 * messages, as well as import/update of messages in other languages.
 */
class SpecialManageGroups extends SpecialPage {
	protected $skin, $user, $out;
	/// Maximum allowed processing time in seconds.
	protected $processingTime = 30;

	/// Constructor
	public function __construct() {
		global $wgOut, $wgUser;
		$this->out = $wgOut;
		$this->user = $wgUser;
		$this->skin = $wgUser->getSkin();
		parent::__construct( 'ManageMessageGroups', 'translate-manage' );
	}

	public function execute( $par ) {
		global $wgRequest;

		$this->out->setPageTitle( htmlspecialchars( wfMsg( 'translate-managegroups' ) ) );

		$group = $wgRequest->getText( 'group' );
		$group = MessageGroups::getGroup( $group );

		if ( !$group instanceof FileBasedMessageGroup ) {
			$group = null;
		}

		if ( $group ) {
			if (
				$wgRequest->getBool( 'rebuildall', false ) &&
				$wgRequest->wasPosted() &&
				$this->user->isAllowed( 'translate-manage' ) &&
				$this->user->matchEditToken( $wgRequest->getVal( 'token' ) )
			) {
				$languages = explode( ',', $wgRequest->getText( 'codes' ) );
				foreach ( $languages as $code ) {
					$cache = new MessageGroupCache( $group, $code );
					$cache->create();
				}
			}

			$code = $wgRequest->getText( 'language', 'en' );
			// Go to English for undefined codes.
			$codes = array_keys( Language::getLanguageNames( false ) );
			if ( !in_array( $code, $codes ) ) {
				$code = 'en';
			}

			$this->importForm( $group, $code );
		} else {
			global $wgLang, $wgOut;

			$groups = MessageGroups::singleton()->getGroups();

			$wgOut->wrapWikiMsg( '<h2>$1</h2>', 'translate-manage-listgroups' );
			$separator = wfMsg( 'word-separator' );

			$languages = array_keys( Language::getLanguageNames( false ) );

			foreach ( $groups as $group ) {
				if ( !$group instanceof FileBasedMessageGroup ) {
					continue;
				}

				wfDebug( __METHOD__ . ": {$group->getId()}\n" );

				$link = $this->skin->link( $this->getTitle(), $group->getLabel(), array(), array( 'group' => $group->getId() ) );
				$out = $link . $separator;

				$cache = new MessageGroupCache( $group );
				if ( $cache->exists() ) {
					$timestamp = wfTimestamp( TS_MW, $cache->getTimestamp() );
					$out .= wfMsg( 'translate-manage-cacheat',
						$wgLang->date( $timestamp ),
						$wgLang->time( $timestamp )
					);

					$modified = array();

					foreach ( $languages as $code ) {
						$cache = new MessageGroupCache( $group, $code );
						if ( !$cache->isValid() ) $modified[] = $code;
					}

					if ( count( $modified ) ) {
						$out = '[' . implode( ",", $modified ) . '] ' . $out;
					} else {
						$out = Html::rawElement( 'span', array( 'style' => 'color:grey' ), $out );
					}
				} else {
					$out .= wfMsg( 'translate-manage-newgroup' );
				}

				$wgOut->addHtml( $out );
				$wgOut->addHtml( '<hr>' );
			}

			$wgOut->wrapWikiMsg( '<h2>$1</h2>', 'translate-manage-listgroups-old' );
			$wgOut->addHTML( '<ul>' );

			foreach ( $groups as $group ) {
				if ( $group instanceof FileBasedMessageGroup ) {
					continue;
				}

				$wgOut->addHtml( Xml::element( 'li', null, $group->getLabel() ) );
			}

			$wgOut->addHTML( '</ul>' );
		}
	}

	/**
	 * @todo Very long code block; split up.
	 */
	public function importForm( $group, $code ) {
		$this->setSubtitle( $group, $code );

		$formParams = array(
			'method' => 'post',
			'action' => $this->getTitle()->getFullURL( array( 'group' => $group->getId() ) ),
			'class'  => 'mw-translate-manage'
		);

		global $wgRequest, $wgLang;
		if (
			$wgRequest->wasPosted() &&
			$wgRequest->getBool( 'process', false ) &&
			$this->user->isAllowed( 'translate-manage' ) &&
			$this->user->matchEditToken( $wgRequest->getVal( 'token' ) )
		) {
			$process = true;
		} else {
			$process = false;
		}

		$this->out->addHTML(
			Xml::openElement( 'form', $formParams ) .
			Html::hidden( 'title', $this->getTitle()->getPrefixedText() ) .
			Html::hidden( 'token', $this->user->editToken() ) .
			Html::hidden( 'group', $group->getId() ) .
			Html::hidden( 'process', 1 )
		);

		// BEGIN
		$cache = new MessageGroupCache( $group, $code );
		if ( !$cache->exists() && $code === 'en' ) {
			$cache->create();
		}

		$collection = $group->initCollection( $code );
		$collection->loadTranslations();

		$diff = new DifferenceEngine;
		$diff->showDiffStyle();
		$diff->setReducedLineNumbers();

		$ignoredMessages = $collection->getTags( 'ignored' );
		if ( !is_array( $ignoredMessages ) ) {
			$ignoredMessages = array();
		}

		$messages = $group->load( $code );
		$changed = array();
		foreach ( $messages as $key => $value ) {
			// ignored? ignore!
			if ( in_array( $key, $ignoredMessages ) ) {
				continue;
			}

			$fuzzy = $old = false;

			if ( isset( $collection[$key] ) ) {
				$old = $collection[$key]->translation();
			}

			// No changes at all, ignore.
			if ( str_replace( TRANSLATE_FUZZY, '', $old ) === $value ) {
				continue;
			}

			if ( $old === false ) {
				$name = wfMsgHtml( 'translate-manage-import-new',
					'<code style="font-weight:normal;">' . htmlspecialchars( $key ) . '</code>'
				);

				$text = TranslateUtils::convertWhiteSpaceToHTML( $value );

				$changed[] = MessageWebImporter::makeSectionElement( $name, 'new', $text );
			} else {
				if ( TranslateEditAddons::hasFuzzyString( $old ) ) {
					// NO-OP
				} else {
					$transTitle = MessageWebImporter::makeTranslationTitle( $group, $key, $code );
					if ( TranslateEditAddons::isFuzzy( $transTitle ) ) {
						$old = TRANSLATE_FUZZY . $old;
					}
				}

				$diff->setText( $old, $value );
				$text = $diff->getDiff( '', '' );
				$type = 'changed';

				if ( $process ) {
					if ( !count( $changed ) ) {
						$changed[] = '<ul>';
					}

					$action = $wgRequest->getVal( MessageWebImporter::escapeNameForPHP( "action-$type-$key" ) );

					if ( $action === null ) {
						$message = wfMsgExt( 'translate-manage-inconsistent', 'parseinline', wfEscapeWikiText( "action-$type-$key" ) );
						$changed[] = "<li>$message</li></ul>";
						$process = false;
					} else {
						// Initialise processing time counter.
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

				if ( $this->user->isAllowed( 'translate-manage' ) ) {
					$defaction = $fuzzy ? 'conflict' : 'import';

					foreach ( $actions as $action ) {
						$label = wfMsg( "translate-manage-action-$action" );
						$name = MessageWebImporter::escapeNameForPHP( "action-$type-$key" );
						$id = Sanitizer::escapeId( "action-$key-$action" );
						$act[] = Xml::radioLabel( $label, $name, $action, $id, $action === $defaction );
					}
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

			$cache->create();
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
					$lang = TranslateUtils::getLanguageName( $code, false, $wgLang->getCode() );
					$this->out->addWikiMsg( 'translate-manage-intro-other', $lang );
				}
				$this->out->addHTML( Html::hidden( 'language', $code ) );
				$this->out->addHTML( implode( "\n", $changed ) );
				if ( $this->user->isAllowed( 'translate-manage' ) ) {
					$this->out->addHTML( Xml::submitButton( wfMsg( 'translate-manage-submit' ) ) );
				}
			} elseif ( $this->user->isAllowed( 'translate-manage' ) ) {
				$cache->create(); // Update timestamp
				$this->out->addWikiMsg( 'translate-manage-nochanges' );
			}
		}

		$this->out->addHTML( '</form>' );

		if ( $code === 'en' ) {
			$this->doModLangs( $group );
		} else {
			$this->out->addHTML( '<p>' . $this->skin->link(
				$this->getTitle(),
				wfMsgHtml( 'translate-manage-return-to-group' ),
				array(),
				array( 'group' => $group->getId() )
			) . '</p>' );
		}
	}

	public function doModLangs( $group ) {
		global $wgLang;

		$languages = array_keys( Language::getLanguageNames( false ) );
		$modified = $codes = array();

		foreach ( $languages as $code ) {
			if ( $code === 'en' ) {
				continue;
			}

			$cache = new MessageGroupCache( $group, $code );

			if ( $cache->isValid() ) {
				continue;
			}

			$link = $this->skin->link(
				$this->getTitle(),
				htmlspecialchars( TranslateUtils::getLanguageName( $code, false, $wgLang->getCode() ) . " ($code)" ),
				array(),
				array( 'group' => $group->getId(), 'language' => $code )
			);

			if ( !$cache->exists() ) {
				$modified[] = wfMsgHtml( 'translate-manage-modlang-new', $link  );
			} else {
				$modified[] = $link;
			}

			$codes[] = $code;
		}

		if ( count( $modified ) ) {
			$this->out->addWikiMsg( 'translate-manage-modlangs',
				$wgLang->formatNum( count( $modified ) )
			);

			$formParams = array(
				'method' => 'post',
				'action' => $this->getTitle()->getFullURL( array( 'group' => $group->getId() ) ),
			);

			if ( $this->user->isAllowed( 'translate-manage' ) ) {

				$this->out->addHTML(
					Xml::openElement( 'form', $formParams ) .
					Html::hidden( 'title', $this->getTitle()->getPrefixedText() ) .
					Html::hidden( 'token', $this->user->editToken() ) .
					Html::hidden( 'group', $group->getId() ) .
					Html::hidden( 'codes', implode( ',', $codes ) ) .
					Html::hidden( 'rebuildall', 1 ) .
					Xml::submitButton( wfMsg( 'translate-manage-import-rebuild-all' ) ) .
					Xml::closeElement( 'form' )
				);

			}

			$this->out->addHTML(
				'<ul><li>' . implode( "</li>\n<li>", $modified ) . '</li></ul>'
			);
		}
	}

	/**
	 * Reports if processing time for current page has exceeded the set
	 * maximum ($processingTime).
	 * @return \bool
	 */
	protected function checkProcessTime() {
		return wfTimestamp() - $this->time >= $this->processingTime;
	}

	/**
	 * Set a subtitle like "Manage > FreeCol (open source game) > German"
	 * based on group and language code. The language part is not shown if
	 * it is 'en', and all three possible parts of the subtitle are linked.
	 *
	 * @param $group MessageGroup
	 * @param $code \string Language code.
	 */
	protected function setSubtitle( $group, $code ) {
		global $wgLang;

		$links[] = $this->skin->link(
			$this->getTitle(),
			wfMsgHtml( 'translate-manage-subtitle' )
		);

		$links[] = $this->skin->link(
			$this->getTitle(),
			htmlspecialchars( $group->getLabel() ),
			array(),
			array( 'group' => $group->getId() )
		);

		// Do not show language part for English.
		if ( $code !== 'en' ) {
			$langname = TranslateUtils::getLanguageName( $code, false, $wgLang->getCode() );
			$links[] = $this->skin->link(
				$this->getTitle(),
				htmlspecialchars( $langname ),
				array(),
				array( 'group' => $group->getId(), 'language' => $code )
			);
		}

		$this->out->setSubtitle( implode( ' > ', $links ) );
	}
}
