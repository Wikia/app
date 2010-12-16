<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Implements the core of Translate extension - a special page which shows
 * a list of messages in a format defined by Tasks.
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2006-2007 Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
class SpecialTranslate extends SpecialPage {
	const MSG = 'translate-page-';

	protected $task = null;
	protected $group = null;

	protected $defaults    = null;
	protected $nondefaults = null;
	protected $options     = null;

	function __construct() {
		SpecialPage::SpecialPage( 'Translate' );
	}

	/**
	 * Access point for this special page.
	 */
	public function execute( $parameters ) {
		global $wgOut, $wgTranslateBlacklist, $wgUser, $wgRequest;
		TranslateUtils::injectCSS();

		$this->setHeaders();
		if ( $parameters === 'manage' ) {
			$this->restriction( 'translate-manage' );
			if ( !$this->userCanExecute( $wgUser ) ) {
				$this->displayRestrictionError();
				return;
			}

			$manage = new SpecialManageGroups();
			$manage->execute();
			return;
		} elseif ( $parameters === 'editpage' ) {
			$editpage = TranslationEditPage::newFromRequest( $wgRequest );
			if ( $editpage ) {
				$editpage->execute();
				return;
			}
		}

		$this->setup( $parameters );

		$errors = array();

		if ( $this->options['group'] === '' ) {
			$wgOut->addHTML(
				$this->groupInformation()
			);
			return;
		}

		$codes = Language::getLanguageNames( false );
		if ( !$this->options['language'] || !isset( $codes[$this->options['language']] ) ) {
			$errors['language'] = wfMsgExt( self::MSG . 'no-such-language', array( 'parse' ) );
			$this->options['language'] = $this->defaults['language'];
		}
		if ( !$this->task instanceof TranslateTask ) {
			$errors['task'] = wfMsgExt( self::MSG . 'no-such-task', array( 'parse' ) );
			$this->options['task'] = $this->defaults['task'];
		}
		if ( !$this->group instanceof MessageGroup ) {
			$errors['group'] = wfMsgExt( self::MSG . 'no-such-group', array( 'parse' ) );
			$this->options['group'] = $this->defaults['group'];
		}

		// Show errors nicely
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
					$wgOut->addWikiMsg( self::MSG . 'disabled', $reason );
					return;
				}
			}
		}

		# Proceed
		$taskOptions = new TaskOptions(
			$this->options['language'],
			$this->options['limit'],
			$this->options['offset'],
			array( $this, 'cbAddPagingNumbers' )
		);

		// Initialise and get output
		$this->task->init( $this->group, $taskOptions );
		$output = $this->task->execute();

		if ( $this->task->plainOutput() ) {
			$wgOut->disable();
			header( 'Content-type: text/plain; charset=UTF-8' );
			echo $output;
		} else {
			$description = $this->getGroupDescription( $this->group );
			if ( $description ) {
				$description = Xml::fieldset( wfMsg( self::MSG . 'description-legend' ), $description );
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
			if ( $_ === '' ) continue;

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

	/**
	 * GLOBALS: $wgScript
	 */
	protected function settingsForm( $errors ) {
		global $wgScript;

		$task = $this->taskSelector();
		$group = $this->groupSelector();
		$language = $this->languageSelector();
		$limit = $this->limitSelector();
		$button = Xml::submitButton( wfMsg( TranslateUtils::MSG . 'submit' ) );


		$options = array();
		foreach ( array( 'task', 'group', 'language', 'limit' ) as $g ) {
			$options[] = self::optionRow(
				Xml::tags( 'label', array( 'for' => $g ), wfMsgExt( self::MSG . $g, 'escapenoentities' ) ),
				$$g,
				array_key_exists( $g, $errors ) ? $errors[$g] : null
			);
		}

		$form =
			Xml::openElement( 'fieldset', array( 'class' => 'mw-sp-translate-settings' ) ) .
				Xml::element( 'legend', null, wfMsg( self::MSG . 'settings-legend' ) ) .
				Xml::openElement( 'form', array( 'action' => $wgScript, 'method' => 'get' ) ) .
					Xml::hidden( 'title', $this->getTitle()->getPrefixedText() ) .
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
		$groups = MessageGroups::singleton()->getGroups();
		$selector = new HTMLSelector( 'group', 'group', $this->options['group'] );
		foreach ( $groups as $id => $class ) {
			if ( MessageGroups::getGroup( $id )->exists() ) {
				$selector->addOption( $class->getLabel(), $id );
			}
		}
		return $selector->getHTML();
	}

	protected function taskSelector() {
		$selector = new HTMLSelector( 'task', 'task', $this->options['task'] );
		foreach ( TranslateTasks::getTasks() as $id ) {
			$label = call_user_func( array( 'TranslateTask', 'labelForTask' ), $id );
			$selector->addOption( $label, $id );
		}
		return $selector->getHTML();
	}

	protected function languageSelector() {
		global $wgLang;
		return TranslateUtils::languageSelector( $wgLang->getCode(), $this->options['language'] );
	}

	protected function limitSelector() {
		global $wgLang;
		$items = array( 100, 250, 500, 1000, 2500 );
		$selector = new HTMLSelector( 'limit', 'limit', $this->options['limit'] );
		foreach ( $items as $count ) {
			$selector->addOption( wfMsgExt( self::MSG . 'limit-option', 'parsemag', $wgLang->formatNum( $count ) ), $count );
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
			$navigation = wfMsgExt( self::MSG . 'showing-none', array( 'parse' ) );
		} elseif ( $allInThisPage ) {
			$navigation = wfMsgExt( self::MSG . 'showing-all',
				array( 'parse' ), $total );
		} else {
			$previous = wfMsg( TranslateUtils::MSG . 'prev' );
			if ( $this->options['offset'] > 0 ) {
				$offset = max( 0, $this->options['offset'] - $this->options['limit'] );
				$previous = $this->makeOffsetLink( $previous, $offset );
			}

			$nextious = wfMsg( TranslateUtils::MSG . 'next' );
			if ( $this->paging['total'] != $this->paging['start'] + $this->paging['count'] ) {
				$offset = $this->options['offset'] + $this->options['limit'];
				$nextious = $this->makeOffsetLink( $nextious, $offset );
			}

			$start = $this->paging['start'] + 1 ;
			$stop  = $start + $this->paging['count'] - 1;
			$total = $this->paging['total'];

			$showing = wfMsgExt( self::MSG . 'showing',
				array( 'parseinline' ), $start, $stop, $total );
			$navigation = wfMsgExt( self::MSG . 'paging-links',
				array( 'escape', 'replaceafter' ), $previous, $nextious );

			$navigation = Xml::tags( 'p', null, $showing . ' ' . $navigation );
		}

		return
			Xml::openElement( 'fieldset' ) .
				Xml::element( 'legend', null, wfMsg( self::MSG . 'navigation-legend' ) ) .
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
		if ( $description === null ) return null;
		$description = $wgOut->parse( $description, false );
		return $description;
	}

	/**
	 * Returns group strucuted into sub groups. First group in each subgroup is
	 * considered as the main group.
	 */
	public function getGroupStructure() {
		global $wgTranslateGroupStructure;
		$groups = MessageGroups::singleton()->getGroups();
		$structure = array();

		foreach ( $groups as $id => $o ) {
			if ( !MessageGroups::getGroup( $id )->exists() ) continue;
			foreach ( $wgTranslateGroupStructure as $pattern => $hypergroup ) {
				if ( preg_match( $pattern, $id ) ) {
					// Emulate deepArraySet, because AFAIK php doesn't have one
					self::deepArraySet( $structure, $hypergroup, $id, $o );
					// We need to continue the outer loop, because we have finished this item
					continue 2;
				}
			}

			// Does not belong to any subgroup, just shove it into main level
			$structure[$id] = $o;

		}

		return $structure;
	}

	/**
	 * Function do do $array[level1][level2]...[levelN][$key] = $value, if we have
	 * the indexes in an array.
	 */
	public static function deepArraySet( &$array, array $indexes, $key, $value ) {
		foreach ( $indexes as $index ) {
			if ( !isset( $array[$index] ) ) $array[$index] = array();
			$array = &$array[$index];
		}

		$array[$key] = $value;
	}


	public function groupInformation() {
		$out = '';
		$structure = $this->getGroupStructure();

		foreach ( $structure as $blocks ) {
			$out .= $this->formatGroupInformation( $blocks );
		}

		return $out;
	}

	public function formatGroupInformation( $blocks, $level = 2 ) {
		global $wgUser;

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

		$edit = $wgUser->getSkin()->link(
			$title,
			wfMsgHtml( self::MSG . 'edit' ),
			array(),
			$queryParams
		);
		$label =  htmlspecialchars( $block->getLabel() ) . " ($edit)";
		$desc = $this->getGroupDescription( $block );
		$hasSubblocks = is_array( $blocks ) && count( $blocks );

		if ( $hasSubblocks || $level === 2 ) {
			$class = 'mw-sp-translate-group';
		} else {
			$class = 'mw-sp-translate-target';
		}

		$out = "\n<div class=\"$class mw-sp-translate-$id\">\n";
		$out .= Xml::tags( "h$level", null, $label );

		if ( $desc !== null ) {
			$out .= Xml::wrapClass( $desc, 'description', 'div' );
		}

		if ( $hasSubblocks ) {
			foreach ( $blocks as $subBlock ) {
				$out .= $this->formatGroupInformation( $subBlock, $level + 1 );
			}
		}

		$out .= "\n</div>\n";

		return $out;
	}
}
