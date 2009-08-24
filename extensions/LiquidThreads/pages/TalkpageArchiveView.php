<?php

if ( !defined( 'MEDIAWIKI' ) ) die;

class TalkpageArchiveView extends TalkpageView {
	function __construct( &$output, &$article, &$title, &$user, &$request ) {
		parent::__construct( $output, $article, $title, $user, $request );
		$this->loadQueryFromRequest();
	}

	function showThread( $t ) {
		$this->output->addHTML( <<<HTML
<tr>
<td><a href="{$this->permalinkUrl($t)}">{$t->subjectWithoutIncrement()}</a></td>
<td>
HTML
		);		if ( $t->hasSummary() ) {
			$this->showPostBody( $t->summary() );
		} else if ( $t->type() == Threads::TYPE_MOVED ) {
			$rthread = $t->redirectThread();
			if ( $rthread  && $rthread->summary() ) {
				$this->showPostBody( $rthread->summary() );
			}
		}
		$this->output->addHTML( <<<HTML
</td>
</tr>
HTML
		);
	}

	function loadQueryFromRequest() {
		wfLoadExtensionMessages( 'LiquidThreads' );
		// Begin with with the requirements for being *in* the archive.
		global $wgLqtThreadArchiveStartDays;
		$startdate = Date::now()->nDaysAgo( $wgLqtThreadArchiveStartDays )->midnight();
		$where = array( Threads::articleClause( $this->article ),
		'thread.thread_parent is null',
		'(thread.thread_summary_page is not null' .
		' OR thread.thread_type = ' . Threads::TYPE_MOVED . ')',
		'thread.thread_modified < ' . $startdate->text() );
		$options = array( 'ORDER BY thread.thread_modified DESC' );

		$annotations = array( wfMsg ( 'lqt-searching' ) );

		$r = $this->request;

		/* START AND END DATES */
		// $this->start and $this->end are clipped into the range of available
		// months, for use in the actual query and the selects. $this->raw* are
		// as actually provided, for use by the 'older' and 'newer' buttons.
		$ignore_dates = ! $r->getVal( 'lqt_archive_filter_by_date', true );
		if ( !$ignore_dates ) {
			$months = Threads::monthsWhereArticleHasThreads( $this->article );
		}
		$s = $r->getVal( 'lqt_archive_start' );
		if ( $s && ctype_digit( $s ) && strlen( $s ) == 6 && !$ignore_dates ) {
			$this->selstart = new Date( "{$s}01000000" );
			$this->starti = array_search( $s, $months );
			$where[] = 'thread.thread_modified >= ' . $this->selstart->text();
		}
		$e = $r->getVal( 'lqt_archive_end' );
		if ( $e && ctype_digit( $e ) && strlen( $e ) == 6 && !$ignore_dates ) {
			$this->selend = new Date( "{$e}01000000" );
			$this->endi = array_search( $e, $months );
			$where[] = 'thread.thread_modified < ' . $this->selend->nextMonth()->text();
		}
		if ( isset( $this->selstart ) && isset( $this->selend ) ) {

			$this->datespan = $this->starti - $this->endi;

			$formattedFrom = $this->formattedMonth( $this->selstart->text() );
			$formattedTo = $this->formattedMonth( $this->selend->text() );

			if ( $this->datespan == 0 ) {
				$annotations[] = wfMsg( 'lqt_archive_month_annotation', $formattedFrom );
			} else {
				$annotations[] = wfMsg( 'lqt_archive_month_range_annotation', $formattedFrom, $formattedTo );
			}
		} else if ( isset( $this->selstart ) ) {
			$annotations[] = "after {$this->selstart->text()}";
		} else if ( isset( $this->selend ) ) {
			$annotations[] = "before {$this->selend->text()}";
		}

		$this->where = $where;
		$this->options = $options;
		$this->annotations = implode( "<br />\n", $annotations );
	}

	function threads() {
		return Threads::where( $this->where, $this->options );
	}

	function formattedMonth( $yyyymm ) {
		global $wgLang; // TODO global.
		return $wgLang->getMonthName( substr( $yyyymm, 4, 2 ) ) . ' ' . substr( $yyyymm, 0, 4 );
	}

	function monthSelect( $months, $name ) {
		$selection =  $this->request->getVal( $name );

		// Silently adjust to stay in range.
		$selection = max( min( $selection, $months[0] ), $months[count( $months ) - 1] );

		$options = array();
		foreach ( $months as $m ) {
			$options[$this->formattedMonth( $m )] = $m;
		}
		$result = "<select name=\"$name\" id=\"$name\">";
		foreach ( $options as $label => $value ) {
			$selected = $selection == $value ? 'selected="true"' : '';
			$result .= "<option value=\"$value\" $selected>$label";
		}
		$result .= "</select>";
		return $result;
	}

	function clip( $vals, $min, $max ) {
		$res = array();
		foreach ( $vals as $val ) $res[] =  max( min( $val, $max ), $min );
		return $res;
	}

	/* @return True if there are no threads to show, false otherwise.
	TODO is is somewhat bizarre. */
	function showSearchForm() {
		$months = Threads::monthsWhereArticleHasThreads( $this->article );
		if ( count( $months ) == 0 ) {
			return true;
		}
		wfLoadExtensionMessages( 'LiquidThreads' );

		$use_dates = $this->request->getVal( 'lqt_archive_filter_by_date', null );
		if ( $use_dates === null ) {
			$use_dates = $this->request->getBool( 'lqt_archive_start', false ) ||
			$this->request->getBool( 'lqt_archive_end', false );
		}
		$any_date_check    = !$use_dates ? 'checked="1"' : '';
		$these_dates_check =  $use_dates ? 'checked="1"' : '';
		$any_date = wfMsg ( 'lqt-any-date' );
		$only_date = wfMsg ( 'lqt-only-date' );
		$date_from = wfMsg ( 'lqt-date-from' );
		$date_to  = wfMsg ( 'lqt-date-to' );
		$date_info = wfMsg ( 'lqt-date-info' );
		if ( isset( $this->datespan ) ) {
			$oatte = $this->starti + 1;
			$oatts = $this->starti + 1 + $this->datespan;

			$natts = $this->endi - 1;
			$natte = $this->endi - 1 - $this->datespan;

			list( $oe, $os, $ns, $ne ) =
			$this->clip( array( $oatte, $oatts, $natts, $natte ),
			0, count( $months ) - 1 );

			$older = '<a class="lqt_newer_older" href="' . $this->queryReplace( array(
			'lqt_archive_filter_by_date' => '1',
			'lqt_archive_start' => $months[$os],
			'lqt_archive_end' => $months[$oe] ) )
			. '">«' . wfMsg ( 'lqt-older' ) . '</a>';
			$newer = '<a class="lqt_newer_older" href="' . $this->queryReplace( array(
			'lqt_archive_filter_by_date' => '1',
			'lqt_archive_start' => $months[$ns],
			'lqt_archive_end' => $months[$ne] ) )
			. '">' . wfMsg ( 'lqt-newer' ) . '»</a>';
		}
		else {
			$older = '<span class="lqt_newer_older_disabled" title="' . wfMsg ( 'lqt-date-info' ) . '">«' . wfMsg ( 'lqt-older' ) . '</span>';
			$newer = '<span class="lqt_newer_older_disabled" title="' . wfMsg ( 'lqt-date-info' ) . '">' . wfMsg ( 'lqt-newer' ) . '»</span>';
		}

		$this->output->addHTML( <<<HTML
<form id="lqt_archive_search_form" action="{$this->title->getLocalURL()}">
<input type="hidden" name="lqt_method" value="talkpage_archive">
<input type="hidden" name="title" value="{$this->title->getPrefixedURL()}"

<input type="radio" id="lqt_archive_filter_by_date_no"
name="lqt_archive_filter_by_date" value="0" {$any_date_check}>
<label for="lqt_archive_filter_by_date_no">{$any_date}</label>  <br />
<input type="radio" id="lqt_archive_filter_by_date_yes"
name="lqt_archive_filter_by_date" value="1" {$these_dates_check}>
<label for="lqt_archive_filter_by_date_yes">{$only_date}</label> <br />

<table>
<tr><td><label for="lqt_archive_start">{$date_from}</label>
<td>{$this->monthSelect($months, 'lqt_archive_start')} <br />
<tr><td><label for="lqt_archive_end">{$date_to}</label>
<td>{$this->monthSelect($months, 'lqt_archive_end')}
</table>
<input type="submit">
$older $newer
</form>
HTML
		);
		return false;
	}

	function show() {
		global $wgHooks;
		$wgHooks['SkinTemplateTabs'][] = array( $this, 'customizeTabs' );

		$this->output->setPageTitle( $this->title->getTalkpage()->getPrefixedText() );
		self::addJSandCSS();
		wfLoadExtensionMessages( 'LiquidThreads' );

		$empty = $this->showSearchForm();
		if ( $empty ) {
			$this->output->addHTML( '<p><br /><b>' . wfMsg( 'lqt-nothread' ) . '</b></p>' );
			return false;
		}
		$lqt_title = wfMsg ( 'lqt-title' );
		$lqt_summary = wfMsg ( 'lqt-summary' );
		$this->output->addHTML( <<<HTML
<p class="lqt_search_annotations">{$this->annotations}</p>
<table class="lqt_archive_listing">
<col class="lqt_titles" />
<col class="lqt_summaries" />
<tr><th>{$lqt_title}<th>{$lqt_summary}</tr>
HTML
		);
		foreach ( $this->threads() as $t ) {
			$this->showThread( $t );
		}
		$this->output->addHTML( '</table>' );

		return false;
	}
}
