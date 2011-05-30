<?php
/**
 * Class which encapsulates message importing. It scans for changes (new, changed, deleted),
 * displays them in pretty way with diffs and finally executes the actions the user choices.
 *
 * @file
 * @author Niklas Laxström
 * @author Siebrand Mazeland
 * @copyright Copyright © 2009-2010, Niklas Laxström, Siebrand Mazeland
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Class which encapsulates message importing. It scans for changes (new, changed, deleted),
 * displays them in pretty way with diffs and finally executes the actions the user choices.
 */
class MessageWebImporter {
	protected $title;
	protected $user;
	protected $group;
	protected $code;

	/**
	 * @var OutputPage
	 */
	protected $out;

	/**
	 * Maximum processing time in seconds.
	 */
	protected $processingTime = 60;

	public function __construct( Title $title = null, $group = null, $code = 'en' ) {
		$this->setTitle( $title );
		$this->setGroup( $group );
		$this->setCode( $code );
	}

	/**
	 * Wrapper for consistency with SpecialPage
	 *
	 * @return Title
	 */
	public function getTitle() { return $this->title; }
	public function setTitle( Title $title ) { $this->title = $title; }

	public function getUser() {
		global $wgUser;

		return $this->user ? $this->user : $wgUser;
	}

	public function setUser( User $user ) {
		$this->user = $user;
	}

	/**
	 * @return MessageGroup
	 */
	public function getGroup() {
		return $this->group;
	}

	/**
	 * Group is either MessageGroup object or group id.
	 */
	public function setGroup( $group ) {
		if ( $group instanceof MessageGroup ) {
			$this->group = $group;
		} else {
			$this->group = MessageGroups::getGroup( $group );
		}
	}

	public function getCode() {
		return $this->code;
	}

	public function setCode( $code = 'en' ) {
		$this->code = $code;
	}

	protected function getAction() {
		return $this->getTitle()->getFullURL();
	}

	protected function doHeader() {
		TranslateUtils::injectCSS();

		$formParams = array(
			'method' => 'post',
			'action' => $this->getAction(),
			'class'  => 'mw-translate-manage'
		);

		return
			Xml::openElement( 'form', $formParams ) .
			Html::hidden( 'title', $this->getTitle()->getPrefixedText() ) .
			Html::hidden( 'token', $this->getUser()->editToken() ) .
			Html::hidden( 'process', 1 );
	}

	protected function doFooter() {
		return '</form>';
	}

	protected function allowProcess() {
		global $wgRequest;

		if ( $wgRequest->wasPosted() &&
			$wgRequest->getBool( 'process', false ) &&
			$this->getUser()->matchEditToken( $wgRequest->getVal( 'token' ) ) ) {

			return true;
		}
		return false;
	}

	protected function getActions() {
		if ( $this->code === 'en' ) {
			return array( 'import', 'fuzzy', 'ignore' );
		} else {
			return array( 'import', 'conflict', 'ignore' );
		}
	}

	protected function getDefaultAction( $fuzzy, $action ) {
		if ( $action ) {
			return $action;
		}

		return $fuzzy ? 'conflict' : 'import';
	}

	public function execute( $messages ) {
		global $wgOut, $wgLang;

		$this->out = $wgOut;

		// Set up diff engine
		$diff = new DifferenceEngine;
		$diff->showDiffStyle();
		$diff->setReducedLineNumbers();

		// Check whether we do processing
		$process = $this->allowProcess();

		// Initialise collection
		$group = $this->getGroup();
		$code = $this->getCode();
		$collection = $group->initCollection( $code );
		$collection->loadTranslations();

		$this->out->addHTML( $this->doHeader() );

		// Determine changes
		$alldone = $process;
		$changed = array();

		foreach ( $messages as $key => $value ) {
			$fuzzy = $old = false;

			if ( isset( $collection[$key] ) ) {
				$old = $collection[$key]->translation();
			}

			// No changes at all, ignore
			if ( strval( $old ) === strval( $value ) ) {
				continue;
			}

			if ( $old === false ) {
				$name = wfMsgHtml( 'translate-manage-import-new',
					'<code style="font-weight:normal;">' . htmlspecialchars( $key ) . '</code>'
				);
				$text = TranslateUtils::convertWhiteSpaceToHTML( $value );
				$changed[] = self::makeSectionElement( $name, 'new', $text );
			} else {
				$diff->setText( $old, $value );
				$text = $diff->getDiff( '', '' );
				$type = 'changed';

				global $wgRequest;
				$action = $wgRequest->getVal( self::escapeNameForPHP( "action-$type-$key" ) );

				if ( $process ) {
					if ( !count( $changed ) ) {
						$changed[] = '<ul>';
					}

					if ( $action === null ) {
						$message = wfMsgExt( 'translate-manage-inconsistent', 'parseinline', wfEscapeWikiText( "action-$type-$key" ) );
						$changed[] = "<li>$message</li></ul>";
						$process = false;
					} else {
						// Check processing time
						if ( !isset( $this->time ) ) {
							$this->time = wfTimestamp();
						}

						$message = self::doAction(
							$action,
							$group,
							$key,
							$code,
							$value
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

				$alldone = false;

				$actions = $this->getActions();
				$defaction = $this->getDefaultAction( $fuzzy, $action );

				$act = array();

				foreach ( $actions as $action ) {
					$label = wfMsg( "translate-manage-action-$action" );
					$name = self::escapeNameForPHP( "action-$type-$key" );
					$id = Sanitizer::escapeId( "action-$key-$action" );
					$act[] = Xml::radioLabel( $label, $name, $action, $id, $action === $defaction );
				}

				$name = wfMsg( 'translate-manage-import-diff',
					'<code style="font-weight:normal;">' . htmlspecialchars( $key ) . '</code>',
					implode( ' ', $act )
				);

				$changed[] = self::makeSectionElement( $name, $type, $text );
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
				$changed[] = self::makeSectionElement( $name, 'deleted', $text );
			}
		}

		if ( $process || ( !count( $changed ) && $code !== 'en' ) ) {
			if ( !count( $changed ) ) {
				$this->out->addWikiMsg( 'translate-manage-nochanges-other' );
			}

			if ( !count( $changed ) || strpos( $changed[count( $changed ) - 1], '<li>' ) !== 0 ) {
				$changed[] = '<ul>';
			}

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
				$this->out->addHTML( Xml::submitButton( wfMsg( 'translate-manage-submit' ) ) );
			} else {
				$this->out->addWikiMsg( 'translate-manage-nochanges' );
			}
		}

		$this->out->addHTML( $this->doFooter() );
		return $alldone;
	}

	/**
	 * Perform an action on a given group/key/code
	 *
	 * @param $action \string Options: 'import', 'conflict' or 'ignore'
	 * @param $group MessageGroup Group object
	 * @param $key \string Message key
	 * @param $code \string Language code
	 * @param $message \string contents for the $key/code combination
	 * @param $comment \string edit summary (default: empty) - see Article::doEdit
	 * @param $user User User that will make the edit (default: null - $wgUser) - see Article::doEdit
	 * @param $editFlags Integer bitfield: see Article::doEdit
	 * @return \string Action result
	 */
	public static function doAction( $action, $group, $key, $code, $message, $comment = '', $user = null, $editFlags = 0 ) {
		global $wgTranslateDocumentationLanguageCode;

		$title = self::makeTranslationTitle( $group, $key, $code );

		if ( $action === 'import' || $action === 'conflict' ) {
			if ( $action === 'import' ) {
				$comment = wfMsgForContentNoTrans( 'translate-manage-import-summary' );
			} else {
				$comment = wfMsgForContentNoTrans( 'translate-manage-conflict-summary' );
				$message = self::makeTextFuzzy( $message );
			}

			return self::doImport( $title, $message, $comment, $user, $editFlags );
		} elseif ( $action === 'ignore' ) {
			return array( 'translate-manage-import-ignore', $key );
		} elseif ( $action === 'fuzzy' && $code !== 'en' && $code !== $wgTranslateDocumentationLanguageCode ) {
			$message = self::makeTextFuzzy( $message );

			return self::doImport( $title, $message, $comment, $user, $editFlags );
		} elseif ( $action === 'fuzzy' && $code == 'en' ) {
			return self::doFuzzy( $title, $message, $comment, $user, $editFlags );
		} else {
			throw new MWException( "Unhandled action $action" );
		}
	}

	protected function checkProcessTime() {
		return wfTimestamp() - $this->time >= $this->processingTime;
	}

	/**
	 * @static
	 * @throws MWException
	 * @param Title $title
	 * @param  $message
	 * @param  $comment
	 * @param null $user
	 * @param int $editFlags
	 * @return array
	 */
	public static function doImport( $title, $message, $comment, $user = null, $editFlags = 0 ) {
		$article = new Article( $title, 0 );
		$status = $article->doEdit( $message, $comment, $editFlags, false, $user );
		$success = $status->isOK();

		if ( $success ) {
			return array( 'translate-manage-import-ok',
				wfEscapeWikiText( $title->getPrefixedText() )
			);
		} else {
			throw new MWException( "Failed to import new version of page {$title->getPrefixedText()}\n{$status->getWikiText()}" );
		}
	}

	/**
	 * @static
	 * @param Title $title
	 * @param  $message
	 * @param  $comment
	 * @param  $user
	 * @param int $editFlags
	 * @return array|String
	 */
	public static function doFuzzy( $title, $message, $comment, $user, $editFlags = 0 ) {
		global $wgUser;

		if ( !$wgUser->isAllowed( 'translate-manage' ) ) {
			return wfMsg( 'badaccess-group0' );
		}

		$dbw = wfGetDB( DB_MASTER );

		// Work on all subpages of base title.
		$messageInfo = TranslateEditAddons::figureMessage( $title );
		$titleText = $messageInfo[0];

		$conds = array(
			'page_namespace' => $title->getNamespace(),
			'page_latest=rev_id',
			'rev_text_id=old_id',
			'page_title' . $dbw->buildLike( "$titleText/", $dbw->anyString() ),
		);

		$rows = $dbw->select(
			array( 'page', 'revision', 'text' ),
			array( 'page_title', 'page_namespace', 'old_text', 'old_flags' ),
			$conds,
			__METHOD__
		);

		// Edit with fuzzybot if there is no user.
		if ( !$user ) {
			$user = self::getFuzzyBot();
		}

		// Process all rows.
		$changed = array();
		foreach ( $rows as $row ) {
			global $wgTranslateDocumentationLanguageCode;

			$ttitle = Title::makeTitle( $row->page_namespace, $row->page_title );

			// No fuzzy for English original or documentation language code.
			if ( $ttitle->getSubpageText() == 'en' || $ttitle->getSubpageText() == $wgTranslateDocumentationLanguageCode ) {
				// Use imported text, not database text.
				$text = $message;
			} else {
				$text = Revision::getRevisionText( $row );
				$text = self::makeTextFuzzy( $text );
			}

			// Do actual import
			$changed[] = self::doImport(
				$ttitle,
				$text,
				$comment,
				$user,
				$editFlags
			);
		}

		// Format return text
		$text = '';
		foreach ( $changed as $c ) {
			$key = array_shift( $c );
			$text .= "* " . wfMsgExt( $key, array(), $c ) . "\n";
		}

		return array( 'translate-manage-import-fuzzy', "\n" . $text );
	}

	public static function getFuzzyBot() {
		global $wgTranslateFuzzyBotName;

		$user = User::newFromName( $wgTranslateFuzzyBotName );

		if ( !$user->isLoggedIn() ) {
			$user->addToDatabase();
		}

		return $user;
	}

	/**
	 * Given a group, message key and language code, creates a title for the
	 * translation page.
	 *
	 * @param $group MessageGroup
	 * @param $key \string Message key
	 * @param $code \string Language code
	 * @return Title
	 */
	public static function makeTranslationTitle( $group, $key, $code ) {
		$ns = $group->getNamespace();

		return Title::makeTitleSafe( $ns, "$key/$code" );
	}

	/**
	 * Make section elements.
	 *
	 * @param $legend \string Legend as raw html.
	 * @param $type \string Contents of type class.
	 * @param $content \string Contents as raw html.
	 * @return \string Section element as html.
	 */
	public static function makeSectionElement( $legend, $type, $content ) {
		$containerParams = array( 'class' => "mw-tpt-sp-section mw-tpt-sp-section-type-{$type}" );
		$legendParams = array( 'class' => 'mw-tpt-sp-legend' );
		$contentParams = array( 'class' => 'mw-tpt-sp-content' );

		$items = new TagContainer();
		$items[] = new HtmlTag( 'div', new RawHtml( $legend ), $legendParams );
		$items[] = new HtmlTag( 'div', new RawHtml( $content ), $contentParams );

		return new HtmlTag( 'div', $items, $containerParams );
	}

	/**
	 * Prepends translation with fuzzy tag and ensures there is only one of them.
	 *
	 * @param $message String: message content
	 * @return $message \string Message prefixed with TRANSLATE_FUZZY tag
	 */
	public static function makeTextFuzzy( $message ) {
		$message = str_replace( TRANSLATE_FUZZY, '', $message );

		return TRANSLATE_FUZZY . $message;
	}

	/**
	 * Escape name such that it validates as name and id parameter in html, and
	 * so that we can get it back with WebRequest::getVal(). Especially dot and
	 * spaces are difficult for the latter.
	 * @param $name \string
	 * @return \string
	 */
	public static function escapeNameForPHP( $name ) {
		$replacements = array(
			"("  => '(OP)',
			" "  => '(SP)',
			"\t" => '(TAB)',
			"."  => '(DOT)',
			"'"  => '(SQ)',
			"\"" => '(DQ)',
			"%"  => '(PC)',
			"&"  => '(AMP)',
		);

		/* How nice of you PHP. No way to split array into keys and values in one
		 * function or have str_replace which takes one array? */
		return str_replace( array_keys( $replacements ), array_values( $replacements ), $name );
	}
}
