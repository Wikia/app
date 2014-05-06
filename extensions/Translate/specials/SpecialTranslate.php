<?php
/**
 * Contains logic for special page Special:Translate.
 *
 * @file
 * @author Niklas Laxström
 * @author Siebrand Mazeland
 * @copyright Copyright © 2006-2011 Niklas Laxström, Siebrand Mazeland
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Implements the core of Translate extension - a special page which shows
 * a list of messages in a format defined by Tasks.
 *
 * @ingroup SpecialPage TranslateSpecialPage
 */
class SpecialTranslate extends SpecialPage {

	/**
	 * @var Task
	 */
	protected $task = null;

	/**
	 * @var MessageGroup
	 */
	protected $group = null;

	protected $defaults    = null;
	protected $nondefaults = null;
	protected $options     = null;

	function __construct() {
		parent::__construct( 'Translate' );
	}

	/**
	 * Access point for this special page.
	 */
	public function execute( $parameters ) {
		global $wgOut, $wgTranslateBlacklist, $wgRequest;

		$wgOut->addModules( 'ext.translate.special.translate' );

		$this->setHeaders();

		// @todo Move to api or so
		if ( $parameters === 'editpage' ) {
			$editpage = TranslationEditPage::newFromRequest( $wgRequest );

			if ( $editpage ) {
				$editpage->execute();
				return;
			}
		}

		$this->setup( $parameters );

		$errors = array();

		if ( $this->options['group'] === '' ) {
			TranslateUtils::addSpecialHelpLink( $wgOut, 'Help:Extension:Translate/Translation_example' );
			$this->groupInformation();
			return;
		}

		$codes = Language::getLanguageNames( false );

		if ( !$this->options['language'] || !isset( $codes[$this->options['language']] ) ) {
			$errors['language'] = wfMsgExt( 'translate-page-no-such-language', array( 'parse' ) );
			$this->options['language'] = $this->defaults['language'];
		}

		if ( !$this->task instanceof TranslateTask ) {
			$errors['task'] = wfMsgExt( 'translate-page-no-such-task', array( 'parse' ) );
			$this->options['task'] = $this->defaults['task'];
		}

		if ( !$this->group instanceof MessageGroup ) {
			$errors['group'] = wfMsgExt( 'translate-page-no-such-group', array( 'parse' ) );
			$this->options['group'] = $this->defaults['group'];
		}

		TranslateUtils::addSpecialHelpLink( $wgOut, 'Help:Extension:Translate/Translation_example' );
		// Show errors nicely.
		$wgOut->addHTML( $this->settingsForm( $errors ) );

		if ( count( $errors ) ) {
			return;
		} else {
			$checks = array(
				$this->options['group'],
				strtok( $this->options['group'], '-' ),
				'*'
			);

			foreach ( $checks as $check ) {
				$reason = @$wgTranslateBlacklist[$check][$this->options['language']];
				if ( $reason !== null ) {
					$wgOut->addWikiMsg( 'translate-page-disabled', $reason );
					return;
				}
			}
		}

		// Proceed.
		$taskOptions = new TaskOptions(
			$this->options['language'],
			$this->options['limit'],
			$this->options['offset'],
			array( $this, 'cbAddPagingNumbers' )
		);

		// Initialise and get output.
		$this->task->init( $this->group, $taskOptions );
		$output = $this->task->execute();

		if ( $this->task->plainOutput() ) {
			$wgOut->disable();
			header( 'Content-type: text/plain; charset=UTF-8' );
			echo $output;
		} else {
			$description = $this->getGroupDescription( $this->group );

			$taskid = $this->options['task'];
			if ( in_array( $taskid, array( 'untranslated', 'reviewall' ), true ) ) {
				$hasOptional = count( $this->group->getTags( 'optional' ) );
				if ( $hasOptional ) {
					$linker = class_exists( 'DummyLinker' ) ? new DummyLinker : new Linker;
					$linktext = wfMessage( 'translate-page-description-hasoptional-open' )->escaped();
					$params = array( 'task' => 'optional' ) + $this->nondefaults;
					$link = $linker->link( $this->getTitle(), $linktext, array(), $params );
					$note = wfMessage( 'translate-page-description-hasoptional' )->rawParams( $link )->parseAsBlock();

					if ( $description ) {
						$description .= '<br>' . $note;
					} else {
						$description = $note;
					}
				}
			}

			$status = $this->getWorkflowStatus();
			if ( $status !== false ) {
				$description = $status . $description;
			}

			if ( $description ) {
				$description = Xml::fieldset( wfMsg( 'translate-page-description-legend' ), $description );
			}

			$links = $this->doStupidLinks();

			if ( $this->paging['count'] === 0 ) {
				$wgOut->addHTML( $description . $links );
			} else {
				$wgOut->addHTML( $description . $links . $output . $links );
			}
		}
	}

	protected function setup( $parameters ) {
		global $wgUser, $wgRequest;

		$defaults = array(
		/* str  */ 'task'     => 'untranslated',
		/* str  */ 'sort'     => 'normal',
		/* str  */ 'language' => $wgUser->getOption( 'language' ),
		/* str  */ 'group'    => '',
		/* int  */ 'offset'   => 0,
		/* int  */ 'limit'    => 100,
		);

		// Dump everything here
		$nondefaults = array();

		$parameters = array_map( 'trim', explode( ';', $parameters ) );
		$pars = array();

		foreach ( $parameters as $_ ) {
			if ( $_ === '' ) {
				continue;
			}

			if ( strpos( $_, '=' ) !== false ) {
				list( $key, $value ) = array_map( 'trim', explode( '=', $_, 2 ) );
			} else {
				$key = 'group';
				$value = $_;
			}

			$pars[$key] = $value;
		}

		foreach ( $defaults as $v => $t ) {
			if ( is_bool( $t ) ) {
				$r = isset( $pars[$v] ) ? (bool) $pars[$v] : $defaults[$v];
				$r = $wgRequest->getBool( $v, $r );
			} elseif ( is_int( $t ) ) {
				$r = isset( $pars[$v] ) ? (int) $pars[$v] : $defaults[$v];
				$r = $wgRequest->getInt( $v, $r );
			} elseif ( is_string( $t ) ) {
				$r = isset( $pars[$v] ) ? (string) $pars[$v] : $defaults[$v];
				$r = $wgRequest->getText( $v, $r );
			}

			wfAppendToArrayIfNotDefault( $v, $r, $defaults, $nondefaults );
		}

		$this->defaults    = $defaults;
		$this->nondefaults = $nondefaults;
		$this->options     = $nondefaults + $defaults;

		$this->group = MessageGroups::getGroup( $this->options['group'] );
		$this->task  = TranslateTasks::getTask( $this->options['task'] );

		if ( $this->group instanceof RecentMessageGroup ) {
			$this->group->setLanguage( $this->options['language'] );
		}
	}

	protected function settingsForm( $errors ) {
		global $wgScript;

		// These are used, in the $$g black magic below. Do not remove!
		$task = $this->taskSelector();
		$group = $this->groupSelector();
		$language = $this->languageSelector();
		$limit = $this->limitSelector();

		$button = Xml::submitButton( wfMsg( 'translate-submit' ) );

		$options = array();

		foreach ( array( 'task', 'group', 'language', 'limit' ) as $g ) {
			$options[] = self::optionRow(
				Xml::tags( 'label', array( 'for' => $g ), wfMsgExt( 'translate-page-' . $g, 'escapenoentities' ) ),
				$$g,
				array_key_exists( $g, $errors ) ? $errors[$g] : null
			);
		}

		$form =
			Html::openElement( 'fieldset', array( 'class' => 'mw-sp-translate-settings' ) ) .
				Html::element( 'legend', null, wfMsg( 'translate-page-settings-legend' ) ) .
				Html::openElement( 'form', array( 'action' => $wgScript, 'method' => 'get' ) ) .
					Html::hidden( 'title', $this->getTitle()->getPrefixedText() ) .
					Html::openElement( 'table' ) .
						implode( "", $options ) .
						self::optionRow( $button, ' ' ) .
					Html::closeElement( 'table' ) .
				Html::closeElement( 'form' ) .
			Html::closeElement( 'fieldset' );
		return $form;
	}

	/**
	 * @param $label string
	 * @param $option string
	 * @param $error string Html
	 * @return string
	 */
	private static function optionRow( $label, $option, $error = null ) {
		return
			Html::openElement( 'tr' ) .
				Html::rawElement( 'td', null, $label ) .
				Html::rawElement( 'td', null, $option ) .
				( $error ? Html::rawElement( 'td', array( 'class' => 'mw-sp-translate-error' ), $error ) : '' ) .
			Html::closeElement( 'tr' );
	}

	/* Selectors ahead */

	protected function taskSelector( $pageTranslation = false ) {
		global $wgUser;
		$selector = new XmlSelect( 'task', 'task' );
		$selector->setDefault( $this->options['task'] );

		$isPageTranslation = $this->group instanceof WikiPageMessageGroup;
		foreach ( TranslateTasks::getTasks( $isPageTranslation ) as $id ) {
			if ( TranslateTasks::getTask( $id )->isAllowedFor( $wgUser ) ) {
				$label = TranslateTask::labelForTask( $id );
				$selector->addOption( $label, $id );
			}
		}

		return $selector->getHTML();
	}

	protected function groupSelector() {
		$activeId = false;
		if ( $this->group ) {
			$activeId = $this->group->getId();
		}

		$groups = MessageGroups::getAllGroups();
		$dynamic = MessageGroups::getDynamicGroups();
		$groups = array_keys( array_merge( $groups, $dynamic ) );

		$selected = $this->options['group'];

		$selector = new XmlSelect( 'group', 'group' );
		$selector->setDefault( $selected );

		foreach ( $groups as $id ) {
			if ( $id === $activeId ) {
				$activeId = false;
			}
			$group = MessageGroups::getGroup( $id );
			$hide = MessageGroups::getPriority( $group ) === 'discouraged';

			if ( !$group->exists() || $hide ) {
				continue;
			}

			$selector->addOption( $group->getLabel(), $id );
		}

		if ( $activeId ) {
			$selector->addOption( $this->group->getLabel(), $activeId );
		}

		return $selector->getHTML();
	}

	protected function languageSelector() {
		global $wgLang;

		return TranslateUtils::languageSelector(
			$wgLang->getCode(),
			$this->options['language']
		);
	}

	protected function limitSelector() {
		global $wgLang;

		$items = array( 100, 1000, 5000 );
		$selector = new XmlSelect( 'limit', 'limit' );
		$selector->setDefault( $this->options['limit'] );

		foreach ( $items as $count ) {
			$selector->addOption( wfMsgExt( 'translate-page-limit-option', 'parsemag', $wgLang->formatNum( $count ) ), $count );
		}

		return $selector->getHTML();
	}

	private $paging = null;

	public function cbAddPagingNumbers( $start, $count, $total ) {
		$this->paging = array(
			'start' => $start,
			'count' => $count,
			'total' => $total
		);
	}

	protected function doStupidLinks() {
		global $wgLang;

		if ( $this->paging === null ) {
			return '';
		}

		$start = $this->paging['start'] + 1 ;
		$stop  = $start + $this->paging['count'] - 1;
		$total = $this->paging['total'];

		$allInThisPage = $start === 1 && $total <= $this->options['limit'];

		if ( $this->paging['count'] === 0 ) {
			$navigation = wfMessage( 'translate-page-showing-none' )->parse();
		} elseif ( $allInThisPage ) {
			$navigation = wfMessage( 'translate-page-showing-all', $wgLang->formatNum( $total ) )->parse();
		} else {
			$previous = wfMsg( 'translate-prev' );
			if ( $this->options['offset'] > 0 ) {
				$offset = max( 0, $this->options['offset'] - $this->options['limit'] );
				$previous = $this->makeOffsetLink( $previous, $offset );
			}

			$nextious = wfMsg( 'translate-next' );

			if ( $this->paging['total'] != $this->paging['start'] + $this->paging['count'] ) {
				$offset = $this->options['offset'] + $this->options['limit'];
				$nextious = $this->makeOffsetLink( $nextious, $offset );
			}

			$start = $this->paging['start'] + 1 ;
			$stop  = $start + $this->paging['count'] - 1;
			$total = $this->paging['total'];

			$showing = wfMsgExt(
				'translate-page-showing',
				array( 'parseinline' ),
				$wgLang->formatNum( $start ),
				$wgLang->formatNum( $stop ),
				$wgLang->formatNum( $total )
			);

			$navigation = wfMsgExt(
				'translate-page-paging-links',
				array( 'escape', 'replaceafter' ),
				$previous,
				$nextious
			);

			$navigation = $showing . ' ' . $navigation;
		}

		return
			Html::openElement( 'fieldset' ) .
				Html::element( 'legend', null, wfMsg( 'translate-page-navigation-legend' ) ) .
				$navigation .
			Html::closeElement( 'fieldset' );
	}

	private function makeOffsetLink( $label, $offset ) {
		$linker = class_exists( 'DummyLinker' ) ? new DummyLinker : new Linker;

		$query = array_merge(
			$this->nondefaults,
			array( 'offset' => $offset )
		);

		$link = $linker->link(
			$this->getTitle(),
			$label,
			array(),
			$query
		);

		return $link;
	}

	protected function getGroupDescription( MessageGroup $group ) {
		$description = $group->getDescription();
		if ( $description !== null ) {
			global $wgOut;
			return $wgOut->parse( $description, false );
		}

		return '';
	}

	/**
	 * This funtion renders the default list of groups when no parameters
	 * are passed.
	 */
	public function groupInformation() {
		global $wgOut;
		$structure = MessageGroups::getGroupStructure();
		if ( !$structure ) {
			$wgOut->addWikiMsg( 'translate-grouplisting-empty' );
			return;
		}

		$wgOut->addWikiMsg( 'translate-grouplisting' );

		$out = '';
		foreach ( $structure as $blocks ) {
			$out .= $this->formatGroupInformation( $blocks );
		}

		$wgOut->addHtml( Html::rawElement( 'table', array( 'class' => 'mw-sp-translate-grouplist wikitable' ), $out ) );
	}

	public function formatGroupInformation( $blocks, $level = 2 ) {
		global $wgLang;

		if ( is_array( $blocks ) ) {
			foreach ( $blocks as $i => $block ) {
				if ( !is_array( $block ) && MessageGroups::getPriority( $block ) === 'discouraged' ) {
					unset( $blocks[$i] );
				}
			}
			$block = array_shift( $blocks );
		} else {
			$block = $blocks;
			if ( MessageGroups::getPriority( $block ) === 'discouraged' ) {
				return '';
			}
		}

		$id = $block->getId();

		$title = $this->getTitle();

		$code =  $this->options['language'];
		$queryParams = array(
			'group' => $id,
			'language' => $code
		);

		$linker = class_exists( 'DummyLinker' ) ? new DummyLinker : new Linker;

		$label = $linker->link(
			$title,
			htmlspecialchars( $block->getLabel() ),
			array(),
			$queryParams
		);

		$desc = $this->getGroupDescription( $block );
		$hasSubblocks = is_array( $blocks ) && count( $blocks );

		$subid = Sanitizer::escapeId( "mw-subgroup-$id" );

		if ( $hasSubblocks ) {
			$msg = wfMessage( 'translate-showsub', $wgLang->formatNum( count( $blocks ) ) )->text();
			$target = TranslationHelpers::jQueryPathId( $subid );
			$desc .= Html::element( 'a', array( 'onclick' => "jQuery($target).toggle()", 'class' => 'mw-sp-showmore' ), $msg );
		}

		$out = "\n<tr><td>$label</td>\n<td>$desc</td></tr>\n";
		if ( $hasSubblocks ) {
			$out .= "<tr><td></td><td>\n";
			$tableParams = array(
				'id' => $subid,
				'style' => 'display:none;',
				'class' => "mw-sp-translate-subgroup depth-$level",
			);
			$out .= Html::openElement( 'table', $tableParams );
			foreach ( $blocks as $subBlock ) {
				$out .= $this->formatGroupInformation( $subBlock, $level + 1 );
			}
			$out .= '</table></td></tr>';
		}

		return $out;
	}

	protected function getWorkflowStatus() {
		global $wgTranslateWorkflowStates, $wgUser;
		if ( !$wgTranslateWorkflowStates ) {
			return false;
		}

		if ( MessageGroups::isDynamic( $this->group ) ) {
			return false;
		}

		$dbr = wfGetDB( DB_SLAVE );
		$current = $dbr->selectField(
			'translate_groupreviews',
			'tgr_state',
			array( 'tgr_group' => $this->options['group'], 'tgr_lang' => $this->options['language'] ),
			__METHOD__
		);

		if ( $wgUser->isAllowed( 'translate-groupreview' ) ) {
			$selector = new XmlSelect( 'workflow' );

			$selector->setAttribute( 'class', 'mw-translate-workflowselector' );
			$selector->setDefault( $current );
			$selector->addOption( wfMessage( 'translate-workflow-state-' )->text(), '' );
			foreach ( array_keys( $wgTranslateWorkflowStates ) as $state ) {
				$stateMessage = wfMessage( "translate-workflow-state-$state" );
				$stateText = $stateMessage->isBlank() ? $state : $stateMessage->text();
				$selector->addOption( $stateText, $state );
			}
			$state = $selector->getHTML();

			$attributes = array(
				'type' => 'button',
				'id' => 'mw-translate-workflowset',
				'data-token' => ApiGroupReview::getToken( 0, '' ),
				'data-group' => $this->options['group'],
				'data-language' => $this->options['language'],
				'style' => 'visibility: hidden;',
				'value' => 'Set',
			);
			$state .= Html::element( 'input', $attributes );
		} elseif ( strval( $current ) !== '' ) {
			$state = $current;
		} else {
			$state = wfMessage( 'translate-workflow-state-' )->escaped();
		}

		$message = wfMessage( 'translate-workflowstatus' )->rawParams( $state );
		$box = Html::rawElement( 'div', array( 'id' => 'mw-sp-translate-workflow' ), $message->escaped() );
		return $box;
	}
}
