<?php
/**
 * Contains logic for special page Special:Translate.
 *
 * @file
 * @author Niklas Laxström
 * @author Siebrand Mazeland
 * @copyright Copyright © 2006-2010 Niklas Laxström, Siebrand Mazeland
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Implements the core of Translate extension - a special page which shows
 * a list of messages in a format defined by Tasks.
 *
 * @ingroup SpecialPage TranslateSpecialPage
 */
class SpecialTranslate extends SpecialPage {
	protected $task = null;
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

		TranslateUtils::addModules( $wgOut, 'ext.translate.special.translate' );

		$this->setHeaders();

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
			$wgOut->addHTML( $this->groupInformation() );
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

		/**
		 * Show errors nicely.
		 */
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

		/**
		 * Proceed.
		 */
		$taskOptions = new TaskOptions(
			$this->options['language'],
			$this->options['limit'],
			$this->options['offset'],
			array( $this, 'cbAddPagingNumbers' )
		);

		/**
		 * Initialise and get output.
		 */
		$this->task->init( $this->group, $taskOptions );
		$output = $this->task->execute();

		if ( $this->task->plainOutput() ) {
			$wgOut->disable();
			header( 'Content-type: text/plain; charset=UTF-8' );
			echo $output;
		} else {
			$description = $this->getGroupDescription( $this->group );
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
			Xml::openElement( 'fieldset', array( 'class' => 'mw-sp-translate-settings' ) ) .
				Xml::element( 'legend', null, wfMsg( 'translate-page-settings-legend' ) ) .
				Xml::openElement( 'form', array( 'action' => $wgScript, 'method' => 'get' ) ) .
					Html::hidden( 'title', $this->getTitle()->getPrefixedText() ) .
					Xml::openElement( 'table' ) .
						implode( "", $options ) .
						self::optionRow( $button, ' ' ) .
					Xml::closeElement( 'table' ) .
				Xml::closeElement( 'form' ) .
			Xml::closeElement( 'fieldset' );
		return $form;
	}

	private static function optionRow( $label, $option, $error = null ) {
		return
			Xml::openElement( 'tr' ) .
				Xml::tags( 'td', null, $label ) .
				Xml::tags( 'td', null, $option ) .
				( $error ? Xml::tags( 'td', array( 'class' => 'mw-sp-translate-error' ), $error ) : '' ) .
			Xml::closeElement( 'tr' );

	}

	/* Selectors ahead */

	protected function groupSelector() {
		$groups = MessageGroups::getAllGroups();
		$selector = new HTMLSelector( 'group', 'group', $this->options['group'] );

		foreach ( $groups as $id => $class ) {
			if ( MessageGroups::getGroup( $id )->exists() ) {
				$selector->addOption( $class->getLabel(), $id );
			}
		}

		return $selector->getHTML();
	}

	protected function taskSelector( $pageTranslation = false ) {
		$selector = new HTMLSelector( 'task', 'task', $this->options['task'] );

		$isPageTranslation = $this->group instanceof WikiPageMessageGroup;
		foreach ( TranslateTasks::getTasks( $isPageTranslation ) as $id ) {
			$label = TranslateTask::labelForTask( $id );
			$selector->addOption( $label, $id );
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

		$items = array( 100, 250, 500, 1000, 2500 );
		$selector = new HTMLSelector( 'limit', 'limit', $this->options['limit'] );

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
		if ( $this->paging === null ) {
			return '';
		}

		$start = $this->paging['start'] + 1 ;
		$stop  = $start + $this->paging['count'] - 1;
		$total = $this->paging['total'];

		$allInThisPage = $start === 1 && $total <= $this->options['limit'];

		if ( $this->paging['count'] === 0 ) {
			$navigation = wfMsgExt( 'translate-page-showing-none', array( 'parseinline' ) );
		} elseif ( $allInThisPage ) {
			$navigation = wfMsgExt(
				'translate-page-showing-all',
				array( 'parseinline' ),
				$total
			);
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
				$start,
				$stop,
				$total );

			$navigation = wfMsgExt(
				'translate-page-paging-links',
				array( 'escape', 'replaceafter' ),
				$previous,
				$nextious
			);

			$navigation = $showing . ' ' . $navigation;
		}

		return
			Xml::openElement( 'fieldset' ) .
				Xml::element( 'legend', null, wfMsg( 'translate-page-navigation-legend' ) ) .
				$navigation .
			Xml::closeElement( 'fieldset' );
	}

	private function makeOffsetLink( $label, $offset ) {
		global $wgUser;

		$skin = $wgUser->getSkin();

		$query = array_merge(
			$this->nondefaults,
			array( 'offset' => $offset )
		);

		$link = $skin->link(
			$this->getTitle(),
			$label,
			array(),
			$query
		);

		return $link;
	}

	protected function getGroupDescription( MessageGroup $group ) {
		global $wgOut;

		$description = $group->getDescription();

		if ( $description === null ) {
			return null;
		}

		$description = $wgOut->parse( $description, false );

		return $description;
	}

	public function groupInformation() {
		$out = '';
		$structure = MessageGroups::getGroupStructure();

		foreach ( $structure as $blocks ) {
			$out .= $this->formatGroupInformation( $blocks );
		}

		$header = wfMsgExt( 'translate-grouplisting', 'parse' );
		return $header . "\n" . Html::rawElement( 'table', array( 'class' => 'mw-sp-translate-grouplist wikitable' ), $out );
	}

	public function formatGroupInformation( $blocks, $level = 2 ) {
		global $wgUser, $wgLang;

		if ( is_array( $blocks ) ) {
			$block = array_shift( $blocks );
		} else {
			$block = $blocks;
		}

		$id = $block->getId();

		$title = $this->getTitle();

		$code =  $this->options['language'];
		$queryParams = array(
			'group' => $id,
			'language' => $code
		);

		$label = $wgUser->getSkin()->link(
			$title,
			htmlspecialchars( $block->getLabel() ),
			array(),
			$queryParams
		);

		$desc = $this->getGroupDescription( $block );
		$hasSubblocks = is_array( $blocks ) && count( $blocks );

		$subid = Sanitizer::escapeId( "mw-subgroup-$id" );

		if ( $hasSubblocks ) {
			$msg = wfMsgExt( 'translate-showsub', 'parsemag', $wgLang->formatNum( count( $blocks ) ) );
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
}
