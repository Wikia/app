<?php

/**
* @package MediaWiki
* @subpackage LiquidThreads
* @author David McCabe <davemccabe@gmail.com>
* @licence GPL2
*/

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( -1 );
}

$wgExtensionCredits['other'][] = array(
	'name'           => 'Liquid Threads',
	'version'        => '1.0',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:LiquidThreads',
	'author'         => 'David McCabe',
	'description'    => 'Add threading discussions to talk pages',
	'descriptionmsg' => 'lqt-desc',
);

function efArrayDefault($name, $key, $default) {
	global $$name;
	if( isset($$name) && is_array($$name) && array_key_exists($key, $$name) ) {
		$foo = $$name;
		return $foo[$key];
	}
	else {
		return $default;
	}
}

define('NS_LQT_THREAD', efArrayDefault('egLqtNamespaceNumbers', 'Thread', 90));
define('NS_LQT_THREAD_TALK', efArrayDefault('egLqtNamespaceNumbers', 'Thread_talk', 91));
define('NS_LQT_SUMMARY', efArrayDefault('egLqtNamespaceNumbers', 'Summary', 92));
define('NS_LQT_SUMMARY_TALK', efArrayDefault('egLqtNamespaceNumbers', 'Summary_talk', 93));
define('LQT_NEWEST_CHANGES',1);
define('LQT_NEWEST_THREADS',2);
define('LQT_OLDEST_THREADS',3);

$wgCanonicalNamespaceNames[NS_LQT_THREAD]		= 'Thread';
$wgCanonicalNamespaceNames[NS_LQT_THREAD_TALK]	= 'Thread_talk';
$wgCanonicalNamespaceNames[NS_LQT_SUMMARY]		= 'Summary';
$wgCanonicalNamespaceNames[NS_LQT_SUMMARY_TALK]	= 'Summary_talk';

$wgExtraNamespaces[NS_LQT_THREAD]	= 'Thread';
$wgExtraNamespaces[NS_LQT_THREAD_TALK] = 'Thread_talk';
$wgExtraNamespaces[NS_LQT_SUMMARY] = 'Summary';
$wgExtraNamespaces[NS_LQT_SUMMARY_TALK] = 'Summary_talk';

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['LiquidThreads'] = $dir . 'Lqt.i18n.php';

require_once('LqtBaseView.php');

$wgExtensionFunctions[] = 'wfLqtInitMsg';
$wgExtensionFunctions[] = 'wfLqtSpecialDeleteThread';
$wgExtensionFunctions[] = 'wfLqtSpecialMoveThreadToAnotherPage';
$wgExtensionFunctions[] = 'wfLqtSpecialNewMessages';
$wgHooks['BeforeWatchlist'][] = 'wfLqtBeforeWatchlistHook';

$wgSpecialPages['DeleteThread'] = 'SpecialDeleteThread';
$wgSpecialPages['MoveThread'] = 'SpecialMoveThreadToAnotherPage';
$wgSpecialPages['NewMessages'] = 'SpecialNewMessages';

/**
 * Initialize LiquidThreads user interface messages
 */
function wfLqtInitMsg() {
	wfLoadExtensionMessages( 'LiquidThreads' );
}

/**
 * Recreate the original associative array so that a new pair with the given key
 * and value is inserted before the given existing key. $original_array gets
 * modified in-place.
*/
function efInsertIntoAssoc( $new_key, $new_value, $before, &$original_array ) {
	$ordered = array();
	$i = 0;
	foreach($original_array as $key=>$value) {
		$ordered[$i] = array($key, $value);
		$i += 1;
	}
	$new_assoc = array();
	foreach($ordered as $pair) {
		if( $pair[0] == $before ) {
			$new_assoc[$new_key] = $new_value;
		}
		$new_assoc[$pair[0]] = $pair[1];
	}
	$original_array = $new_assoc;
}

class TalkpageView extends LqtView {
	/* Added to SkinTemplateTabs hook in TalkpageView::show(). */
	function customizeTabs( $skintemplate, $content_actions ) {
		// The arguments are passed in by reference.
		unset($content_actions['edit']);
		unset($content_actions['viewsource']);
		unset($content_actions['addsection']);
		unset($content_actions['history']);
		unset($content_actions['watch']);
		unset($content_actions['move']);

		/*
		TODO:
		We could make these tabs actually follow the tab metaphor if we repointed
		the 'history' and 'edit' tabs to the original subject page. That way 'discussion'
		would just be one of four ways to view the article. But then those other tabs, for
		logged-in users, don't really fit the metaphor. What to do, what to do?
		*/
		return true;
	}

	function permalinksForThreads($ts, $method = null, $operand = null) {
		$ps = array();
		foreach ($ts as $t) {
			$u = $this->permalinkUrl($t, $method, $operand);
			$l = $t->subjectWithoutIncrement();
			$ps[] = "<a href=\"$u\">$l</a>";
		}
		return $ps;
	}

	function showHeader() {
		/* Show the contents of the actual talkpage article if it exists. */

		$article = new Article( $this->title );
		$revision = Revision::newFromId($article->getLatest());
		if( $revision ) $article_text = $revision->getRawText();

		$oldid = $this->request->getVal('oldid', null);
		$editlink = $this->title->getFullURL( 'action=edit' );

		// If $article_text == "", the talkpage was probably just created
		// when the first thread was posted to make the links blue.
		if ( $article->exists() && $article_text != "" ) {
			$historylink = $this->title->getFullURL( 'action=history' );
			$this->openDiv('lqt_header_content');
			$this->showPostBody($article, $oldid);
			$this->outputList('ul', 'lqt_header_commands', null, array(
				"[<a href=\"$editlink\">".wfMsg('edit')."&uarr;</a>]",
				"[<a href=\"$historylink\">".wfMsg('history_short')."&uarr;</a>]"
				));
			$this->closeDiv();
		} else {
			$this->output->addHTML("<p class=\"lqt_header_notice\">[<a href=\"$editlink\">".wfMsg('lqt_add_header')."</a>]</p>");
		}
	}

	function outputList( $kind, $class, $id, $contents ) {
		$this->output->addHTML(wfOpenElement($kind, array('class'=>$class,'id'=>$id)));
		foreach ($contents as $li) {
			$this->output->addHTML( wfOpenElement('li') );
			$this->output->addHTML( $li );
			$this->output->addHTML( wfCloseElement('li') );
		}
		$this->output->addHTML(wfCloseElement($kind));
	}

	function showTOC($threads) {
		$sk = $this->user->getSkin();
		$toclines = array();
		$i = 1;
		$toclines[] = $sk->tocIndent();
		foreach($threads as $t) {
			$toclines[] = $sk->tocLine($this->anchorName($t), $t->subjectWithoutIncrement(), $i, 1);
			$i++;
		}
		$toclines[] = $sk->tocUnindent(1);
		
		$this->openDiv('lqt_toc_wrapper');
		$this->output->addHTML('<h2 class="lqt_toc_title">'.wfMsg('lqt_contents_title').'</h2> <ul>');
		
		foreach($threads as $t) {
			$this->output->addHTML('<li><a href="#'.$this->anchorName($t).'">'.$t->subjectWithoutIncrement().'</a></li>');
		}
		
		$this->output->addHTML('</ul></div>');
	}

	function showArchiveWidget($threads) {
		$threadlinks = $this->permalinksForThreads($threads);
		$url = $this->talkpageUrl($this->title, 'talkpage_archive');
		
		if ( count($threadlinks) > 0 ) {
			$this->openDiv('lqt_archive_teaser');
			$this->output->addHTML('<h2 class="lqt_recently_archived">'.wfMsg('lqt_recently_archived').'</h2>');
//			$this->output->addHTML("<span class=\"lqt_browse_archive\">[<a href=\"$url\">".wfMsg('lqt_browse_archive_with_recent')."</a>]</span></h2>");
			$this->outputList('ul', '', '', $threadlinks);
			$this->closeDiv();
		} else {	
		}
	}
	
	function show() {
		global $wgHooks, $wgUser;
		$wgHooks['SkinTemplateTabs'][] = array($this, 'customizeTabs');

		$this->output->setPageTitle( $this->title->getTalkpage()->getPrefixedText() );
		self::addJSandCSS();
		$article = new Article( $this->title );
		
		if( $this->methodApplies('talkpage_sort_order') ) {
			global $wgRequest;
			$remember_sort_checked = $wgRequest->getVal('lqt_remember_sort') ? 'checked ' : '';
			$wgUser->setOption('lqt_sort_order', $this->sort_order);
			$wgUser->saveSettings();
		} else {
			$remember_sort_checked = '';
		}

		if( $this->methodApplies('talkpage_new_thread') ) {
			$this->showNewThreadForm();
		} else {

			// Only show sort controls if there is stuff to be sorted
			if($article->exists()) {
				$nc_sort = $this->sort_order==LQT_NEWEST_CHANGES ? ' selected' : '';
				$nt_sort = $this->sort_order==LQT_NEWEST_THREADS ? ' selected' : '';
				$ot_sort = $this->sort_order==LQT_OLDEST_THREADS ? ' selected' : '';
				$newest_changes = wfMsg('lqt_sort_newest_changes');
				$newest_threads = wfMsg('lqt_sort_newest_threads');
				$oldest_threads = wfMsg('lqt_sort_oldest_threads');
				$lqt_remember_sort = wfMsg('lqt_remember_sort') ;
				$form_action_url = $this->talkpageUrl( $this->title, 'talkpage_sort_order');
				$lqt_sorting_order = wfMsg('lqt_sorting_order');
				$lqt_sort_newest_changes = wfMsg('lqt_sort_newest_changes');
				$lqt_sort_newest_threads = wfMsg('lqt_sort_newest_threads');
				$lqt_sort_oldest_threads = wfMsg('lqt_sort_oldest_threads');
				$go=wfMsg('go');
				if($wgUser->isLoggedIn()) { 
					$remember_sort = 
<<<HTML
<br />
<label for="lqt_remember_sort_checkbox">
<input id="lqt_remember_sort_checkbox" name="lqt_remember_sort" type="checkbox" value="1" $remember_sort_checked class="lqt_remember_sort" />
$lqt_remember_sort</label>
HTML;
				} else {
					$remember_sort = '';
				}
				$this->openDiv('lqt_view_options');
				$this->output->addHTML( 

<<<HTML
<form name="lqt_sort" action="$form_action_url" method="post">$lqt_sorting_order
<select name="lqt_order" class="lqt_sort_select">
<option value="nc"$nc_sort>$lqt_sort_newest_changes</option>
<option value="nt"$nt_sort>$lqt_sort_newest_threads</option>
<option value="ot"$ot_sort>$lqt_sort_oldest_threads</option>
</select>
$remember_sort
<input name="submitsort" type="submit" value="$go" class="lqt_go_sort"/>
</form>
HTML
				);
				$this->closeDiv();
			}
			$url = $this->talkpageUrl( $this->title, 'talkpage_new_thread' );
			$this->output->addHTML("<strong><a class=\"lqt_start_discussion\" href=\"$url\">".wfMsg('lqt_new_thread')."</a></strong>");
		}

		$threads = $this->queries->query('fresh');

		$this->openDiv('lqt_toc_archive_wrapper');
		
		$this->openDiv('lqt_archive_teaser_empty');
		$this->output->addHTML("<div class=\"lqt_browse_archive\"><a href=\"{$this->talkpageUrl($this->title, 'talkpage_archive')}\">".wfMsg('lqt_browse_archive_without_recent')."</a></div>");
		$this->closeDiv();
		$recently_archived_threads = $this->queries->query('recently-archived');
		if(count($threads) > 3 || count($recently_archived_threads) > 0) {
			$this->showTOC($threads);
		}
		$this->showArchiveWidget($recently_archived_threads);
		$this->closeDiv();
		// Clear any floats
		$this->output->addHTML('<br clear="all" />');
		
		foreach($threads as $t) {
			$this->showThread($t);
		}
		return false;
	}
}

class TalkpageArchiveView extends TalkpageView {
	function __construct(&$output, &$article, &$title, &$user, &$request) {
		parent::__construct($output, $article, $title, $user, $request);
		$this->loadQueryFromRequest();
	}

	function showThread($t) {
		$this->output->addHTML(<<<HTML
<tr>
	<td><a href="{$this->permalinkUrl($t)}">{$t->subjectWithoutIncrement()}</a></td>
	<td>
HTML
);		if( $t->hasSummary() ) {
			$this->showPostBody($t->summary());
		} else if ( $t->type() == Threads::TYPE_MOVED ) {
			$rthread = $t->redirectThread();
			if( $rthread  && $rthread->summary() ) {
				$this->showPostBody($rthread->summary());
			}
		}
			$this->output->addHTML(<<<HTML
	</td>
</tr>
HTML
);
	}

	function loadQueryFromRequest() {
		// Begin with with the requirements for being *in* the archive.
		$startdate = Date::now()->nDaysAgo($this->archive_start_days)->midnight();
		$where = array(Threads::articleClause($this->article),
							'thread.thread_parent is null',
		                   '(thread.thread_summary_page is not null' .
			                  ' OR thread.thread_type = '.Threads::TYPE_MOVED.')',
		                     'thread.thread_modified < ' . $startdate->text());
		$options = array('ORDER BY thread.thread_modified DESC');

		$annotations = array("Searching for threads");

		$r = $this->request;

		/* START AND END DATES */
		// $this->start and $this->end are clipped into the range of available
		// months, for use in the actual query and the selects. $this->raw* are
		// as actually provided, for use by the 'older' and 'newer' buttons.
		$ignore_dates = ! $r->getVal('lqt_archive_filter_by_date', true);
		if ( !$ignore_dates ) {
			$months = Threads::monthsWhereArticleHasThreads($this->article);
		}
		$s = $r->getVal('lqt_archive_start');
		if ($s && ctype_digit($s) && strlen($s) == 6 && !$ignore_dates) {
			$this->selstart = new Date( "{$s}01000000" );
			$this->starti = array_search($s, $months);
			$where[] = 'thread.thread_modified >= ' . $this->selstart->text();
		}
		$e = $r->getVal('lqt_archive_end');
		if ($e && ctype_digit($e) && strlen($e) == 6 && !$ignore_dates) {
			$this->selend = new Date("{$e}01000000");
			$this->endi = array_search($e, $months);
			$where[] = 'thread.thread_modified < ' . $this->selend->nextMonth()->text();
		}
		if ( isset($this->selstart) && isset($this->selend) ) {

			$this->datespan = $this->starti - $this->endi;

			$annotations[] = "from {$this->selstart->text()} to {$this->selend->text()}";
		} else if (isset($this->selstart)) {
			$annotations[] = "after {$this->selstart->text()}";
		} else if (isset($this->selend)) {
			$annotations[] = "before {$this->selend->text()}";
		}

		$this->where = $where;
		$this->options = $options;
		$this->annotations = implode("<br />\n", $annotations);
	}

	function threads() {
		return Threads::where($this->where, $this->options);
	}

	function formattedMonth($yyyymm) {
		global $wgLang; // TODO global.
		return $wgLang->getMonthName( substr($yyyymm, 4, 2) ).' '.substr($yyyymm, 0, 4);
	}

	function monthSelect($months, $name) {
		$selection =  $this->request->getVal($name);

		// Silently adjust to stay in range.
		$selection = max( min( $selection, $months[0] ), $months[count($months)-1] );

		$options = array();
		foreach($months as $m) {
			$options[$this->formattedMonth($m)] = $m;
		}
		$result = "<select name=\"$name\" id=\"$name\">";
		foreach( $options as $label => $value ) {
			$selected = $selection == $value ? 'selected="true"' : '';
			$result .= "<option value=\"$value\" $selected>$label";
		}
		$result .= "</select>";
		return $result;
	}

	function clip( $vals, $min, $max ) {
		$res = array();
		foreach($vals as $val) $res[] =  max( min( $val, $max ), $min );
		return $res;
	}

	/* @return True if there are no threads to show, false otherwise.
	 TODO is is somewhat bizarre. */
	function showSearchForm() {
		$months = Threads::monthsWhereArticleHasThreads($this->article);
		if (count($months) == 0) {
			return true;
		}

		$use_dates = $this->request->getVal('lqt_archive_filter_by_date', null);
		if ( $use_dates === null ) {
			$use_dates = $this->request->getBool('lqt_archive_start', false) ||
						 $this->request->getBool('lqt_archive_end', false);
		}
		$any_date_check    = !$use_dates ? 'checked="1"' : '';
		$these_dates_check =  $use_dates ? 'checked="1"' : '';

		if( isset($this->datespan) ) {
			$oatte = $this->starti + 1;
			$oatts = $this->starti + 1 + $this->datespan;

			$natts = $this->endi - 1;
			$natte = $this->endi - 1 - $this->datespan;

			list($oe, $os, $ns, $ne) =
				$this->clip( array($oatte, $oatts, $natts, $natte),
					     0, count($months)-1 );

			$older = '<a class="lqt_newer_older" href="' . $this->queryReplace(array(
				     'lqt_archive_filter_by_date'=>'1',
				     'lqt_archive_start' => $months[$os],
				     'lqt_archive_end' => $months[$oe]))
				. '">«older</a>';
			$newer = '<a class="lqt_newer_older" href="' . $this->queryReplace(array(
				     'lqt_archive_filter_by_date'=>'1',
				     'lqt_archive_start' => $months[$ns],
				     'lqt_archive_end' => $months[$ne]))
				. '">newer»</a>';
		}
		else {
			$older = '<span class="lqt_newer_older_disabled" title="This link is disabled because you are viewing threads from all dates.">«older</span>';
			$newer = '<span class="lqt_newer_older_disabled" title="This link is disabled because you are viewing threads from all dates.">newer»</span>';
		}

		$this->output->addHTML(<<<HTML
<form id="lqt_archive_search_form" action="{$this->title->getLocalURL()}">
	<input type="hidden" name="lqt_method" value="talkpage_archive">
        <input type="hidden" name="title" value="{$this->title->getPrefixedURL()}"

	<input type="radio" id="lqt_archive_filter_by_date_no"
               name="lqt_archive_filter_by_date" value="0" {$any_date_check}>
	<label for="lqt_archive_filter_by_date_no">Any date</label>  <br />
	<input type="radio" id="lqt_archive_filter_by_date_yes"
               name="lqt_archive_filter_by_date" value="1" {$these_dates_check}>
	<label for="lqt_archive_filter_by_date_yes">Only these dates:</label> <br />

<table>
<tr><td><label for="lqt_archive_start">From</label>
    <td>{$this->monthSelect($months, 'lqt_archive_start')} <br />
<tr><td><label for="lqt_archive_end">To</label>
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
		$wgHooks['SkinTemplateTabs'][] = array($this, 'customizeTabs');

		$this->output->setPageTitle( $this->title->getTalkpage()->getPrefixedText() );
		self::addJSandCSS();

		$empty = $this->showSearchForm();
		if ($empty) {
			$this->output->addHTML('<p><br /><b>'. wfMsg('lqt-nothread' ) . '</b></p>' );
			return false;
		}

		$this->output->addHTML(<<<HTML
<p class="lqt_search_annotations">{$this->annotations}</p>
<table class="lqt_archive_listing">
<col class="lqt_titles" />
<col class="lqt_summaries" />
<tr><th>Title<th>Summary</tr>
HTML
                );
		foreach ($this->threads() as $t) {
			$this->showThread($t);
		}
		$this->output->addHTML('</table>');

		return false;
	}
}

class ThreadPermalinkView extends LqtView {
	protected $thread;

	function customizeTabs( $skintemplate, $content_actions ) {
		// Insert fake 'article' and 'discussion' tabs before the thread tab.
		// If you call the key 'talk', the url gets re-set later. TODO:
		// the access key for the talk tab doesn't work.
		$article_t = $this->thread->article()->getTitle();
		$talk_t = $this->thread->article()->getTitle()->getTalkPage();
		efInsertIntoAssoc('article', array(
				'text'=>wfMsg($article_t->getNamespaceKey()),
				'href'=>$article_t->getFullURL(),
				'class' => $article_t->exists() ? '' : 'new'),
			'nstab-thread', $content_actions);
		efInsertIntoAssoc('not_talk', array(
				// talkpage certainly exists since this thread is from it.
				'text'=>wfMsg('talk'),
				'href'=>$talk_t->getFullURL()),
		 	'nstab-thread', $content_actions);

		unset($content_actions['edit']);
		unset($content_actions['viewsource']);
		unset($content_actions['talk']);
		if( array_key_exists( 'move', $content_actions ) && $this->thread ) {
			$content_actions['move']['href'] =
				SpecialPage::getPage('Movethread')->getTitle()->getFullURL() . '/' .
				$this->thread->title()->getPrefixedURL();
		}
		if( array_key_exists( 'delete', $content_actions ) && $this->thread ) {
			$content_actions['delete']['href'] =
				SpecialPage::getPage('Deletethread')->getTitle()->getFullURL() . '/' .
				$this->thread->title()->getPrefixedURL();
		}

		if( array_key_exists('history', $content_actions) ) {
			$content_actions['history']['href'] = $this->permalinkUrl( $this->thread, 'thread_history' );
			if( $this->methodApplies('thread_history') ) {
				$content_actions['history']['class'] = 'selected';
			}
		}

		return true;
	}

	function showThreadHeading( $thread ) {
		if ( $this->headerLevel == 2 ) {
			$this->output->setPageTitle( $thread->wikilink() );
		} else {
			parent::showThreadHeading($thread);
		}
	}

	function noSuchRevision() {
		$this->output->addHTML(wfMsg('lqt_nosuchrevision'));
	}

	function showMissingThreadPage() {
		$this->output->addHTML(wfMsg('lqt_nosuchthread'));
	}

	function getSubtitle() {
 		// TODO the archive month part is obsolete.
		if (Date::now()->nDaysAgo(30)->midnight()->isBefore( new Date($this->thread->modified()) ))
			$query = '';
		else
			$query = 'lqt_archive_month=' . substr($this->thread->modified(),0,6);
		$talkpage = $this->thread->article()->getTitle()->getTalkpage();
		$talkpage_link = $this->user->getSkin()->makeKnownLinkObj($talkpage, '', $query);
		if ( $this->thread->hasSuperthread() ) {
			return wfMsg('lqt_fragment',"<a href=\"{$this->permalinkUrl($this->thread->topmostThread())}\">".wfMsg('lqt_discussion_link')."</a>",$talkpage_link);
		} else {
			return wfMsg('lqt_from_talk', $talkpage_link);
		}
	}

	function __construct(&$output, &$article, &$title, &$user, &$request) {

		parent::__construct($output, $article, $title, $user, $request);

		$t = Threads::withRoot( $this->article );
		$r = $this->request->getVal('lqt_oldid', null); if( $r ) {
			$t = $t->atRevision($r);
			if( !$t ) { $this->noSuchRevision(); return; }

		}
		$this->thread = $t;
		if( ! $t ) {
			return; // error reporting is handled in show(). this kinda sucks.
		}

		// $this->article gets saved to thread_article, so we want it to point to the
		// subject page associated with the talkpage, always, not the permalink url.
		$this->article = $t->article(); # for creating reply threads.

	}

	function show() {
		global $wgHooks;
		$wgHooks['SkinTemplateTabs'][] = array($this, 'customizeTabs');

		if( ! $this->thread ) {
			$this->showMissingThreadPage();
			return false;
		}

		self::addJSandCSS();
		$this->output->setSubtitle($this->getSubtitle());

		if( $this->methodApplies('summarize') )
			$this->showSummarizeForm($this->thread);

		$this->showThread($this->thread);
		return false;
	}
}

/*
 * Cheap views that just pass through to MW functions.
 */

class TalkpageHeaderView extends LqtView {
	function customizeTabs( $skintemplate, $content_actions ) {
		unset($content_actions['edit']);
		unset($content_actions['addsection']);
		unset($content_actions['history']);
		unset($content_actions['watch']);
		unset($content_actions['move']);

		$content_actions['talk']['class'] = false;
		$content_actions['header'] = array( 'class'=>'selected',
		                                    'text'=>'header',
		                                    'href'=>'');

		return true;
	}

	function show() {
		global $wgHooks, $wgOut, $wgTitle, $wgRequest;
		$wgHooks['SkinTemplateTabs'][] = array($this, 'customizeTabs');
		
		if( $wgRequest->getVal('action') === 'edit' ) {
			$warn_bold = '<strong>' . wfMsg('lqt_header_warning_bold') . '</strong>';
			$warn_link = '<a href="'.$this->talkpageUrl($wgTitle, 'talkpage_new_thread').'">'.
				wfMsg('lqt_header_warning_new_discussion').'</a>';
			$wgOut->addHTML('<p class="lqt_header_warning">' .
				wfMsg('lqt_header_warning_before_big', $warn_bold, $warn_link) .
				'<big>' . wfMsg('lqt_header_warning_big', $warn_bold, $warn_link) . '</big>' . 
				wfMsg('lqt_header_warning_after_big', $warn_bold, $warn_link) .
				'</p>');
		}
		
		return true;
	}
}

/*
	This is invoked in two cases:
	(1) the single-article history listing
	(2) an old revision of a single article.
*/
class IndividualThreadHistoryView extends ThreadPermalinkView {
	protected $oldid;

	function customizeTabs( $skintemplate, $content_actions ) {
		$content_actions['history']['class'] = 'selected';
		parent::customizeTabs($skintemplate, $content_actions);
		return true;
	}

	/* This customizes the subtitle of a history *listing* from the hook,
	   and of an old revision from getSubtitle() below. */
	function customizeSubtitle() {
		$msg = wfMsg('lqt_hist_view_whole_thread');
		$threadhist = "<a href=\"{$this->permalinkUrl($this->thread->topmostThread(), 'thread_history')}\">$msg</a>";
		$this->output->setSubtitle(  parent::getSubtitle() . '<br />' . $this->output->getSubtitle() . "<br />$threadhist" );
		return true;
	}

	/* */
	function getSubtitle() {
		$this->article->setOldSubtitle($this->oldid);
		$this->customizeSubtitle();
		return $this->output->getSubtitle();
	}

	function show() {
		global $wgHooks;
/*
		$this->oldid = $this->request->getVal('oldid', null);
		if( $this->oldid !== null ) {

			parent::show();
			return false;
		}
*/
		$wgHooks['SkinTemplateTabs'][] = array($this, 'customizeTabs');

		$wgHooks['PageHistoryBeforeList'][] = array($this, 'customizeSubtitle');

		return true;
	}
}

class ThreadDiffView {
	function customizeTabs( $skintemplate, $content_actions ) {
		unset($content_actions['edit']);
		unset($content_actions['viewsource']);
		unset($content_actions['talk']);

		$content_actions['talk']['class'] = false;
		$content_actions['history']['class'] = 'selected';

		return true;
	}

	function show() {
		global $wgHooks;
		$wgHooks['SkinTemplateTabs'][] = array($this, 'customizeTabs');
		return true;
	}
}

class ThreadWatchView extends ThreadPermalinkView {
	function show() {
		global $wgHooks;
		$wgHooks['SkinTemplateTabs'][] = array($this, 'customizeTabs');
		return true;
	}
}

class ThreadProtectionFormView {
	function customizeTabs( $skintemplate, $content_actions ) {
		unset($content_actions['edit']);
		unset($content_actions['addsection']);
		unset($content_actions['viewsource']);
		unset($content_actions['talk']);

		$content_actions['talk']['class'] = false;
		if ( array_key_exists('protect', $content_actions) )
			$content_actions['protect']['class'] = 'selected';
		else if ( array_key_exists('unprotect', $content_actions) )
			$content_actions['unprotect']['class'] = 'selected';

		return true;
	}

	function show() {
		global $wgHooks;
		$wgHooks['SkinTemplateTabs'][] = array($this, 'customizeTabs');
		return true;
	}
}

class ThreadHistoryListingView extends ThreadPermalinkView {

	private function rowForThread($t) {
		global $wgLang, $wgOut; // TODO global.

		/* TODO: best not to refer to LqtView class directly. */
		/* We don't use oldid because that has side-effects. */
		$result = array();
		$change_names = array(	Threads::CHANGE_EDITED_ROOT => wfMsg('lqt_hist_comment_edited'),
		                      	Threads::CHANGE_EDITED_SUMMARY => wfMsg('lqt_hist_summary_changed'),
		                      	Threads::CHANGE_REPLY_CREATED => wfMsg('lqt_hist_reply_created'),
		                      	Threads::CHANGE_NEW_THREAD => wfMsg('lqt_hist_thread_created'),
								Threads::CHANGE_DELETED => wfMsg('lqt_hist_deleted'),
								Threads::CHANGE_UNDELETED => wfMsg('lqt_hist_undeleted'),
								Threads::CHANGE_MOVED_TALKPAGE => wfMsg('lqt_hist_moved_talkpage'));
		$change_label = array_key_exists($t->changeType(), $change_names) ? $change_names[$t->changeType()] : "";

		$url = LqtView::permalinkUrlWithQuery( $this->thread, 'lqt_oldid=' . $t->revisionNumber() );

		$user_id = $t->changeUser()->getID(); # ever heard of a User object?
		$user_text = $t->changeUser()->getName();
		$sig = $this->user->getSkin()->userLink( $user_id, $user_text ) .
			   $this->user->getSkin()->userToolLinks( $user_id, $user_text );

		$change_comment=$t->changeComment();
		if(!empty($change_comment))
			$change_comment="<em>($change_comment)</em>";

		$result[] = "<tr>";
		$result[] = "<td><a href=\"$url\">" . $wgLang->timeanddate($t->modified()) . "</a></td>";
		$result[] = "<td>" . $sig . "</td>";
		$result[] = "<td>$change_label</td>";
		$result[] = "<td>$change_comment</td>";
		$result[] = "</tr>";
		return implode('', $result);
	}

	function showHistoryListing($t) {
		$revisions = new ThreadHistoryIterator($t, $this->perPage, $this->perPage * ($this->page - 1));

		$this->output->addHTML('<table>');
		foreach($revisions as $ht) {
			$this->output->addHTML($this->rowForThread($ht));
		}
		$this->output->addHTML('</table>');

		if ( count($revisions) == 0 && $this->page == 1 ) {
			$this->output->addHTML('<p>'.wfMsg('lqt_hist_no_revisions_error'));
		}
		else if ( count($revisions) == 0 ) {
			// we could redirect to the previous page... yow.
			$this->output->addHTML('<p>'.wfMsg('lqt_hist_past_last_page_error'));
		}

		if( $this->page > 1 ) {
			$this->output->addHTML( '<a class="lqt_newer_older" href="' . $this->queryReplace(array('lqt_hist_page'=>$this->page - 1)) .'">'.wfMsg('lqt_newer').'</a>' );
		} else {
			$this->output->addHTML( '<span class="lqt_newer_older_disabled" title="'.wfMsg('lqt_hist_tooltip_newer_disabled').'">'.wfMsg('lqt_newer').'</span>' );
		}

		$is_last_page = false;
		foreach($revisions as $r)
			if( $r->changeType() == Threads::CHANGE_NEW_THREAD )
				$is_last_page = true;
		if( $is_last_page ) {
			$this->output->addHTML( '<span class="lqt_newer_older_disabled" title="'.wfMsg('lqt_hist_tooltip_older_disabled').'">'.wfMsg('lqt_older').'</span>' );
		} else {
			$this->output->addHTML( '<a class="lqt_newer_older" href="' . $this->queryReplace(array('lqt_hist_page'=>$this->page + 1)) . '">'.wfMsg('lqt_older').'</a>' );
		}
	}

	function __construct(&$output, &$article, &$title, &$user, &$request) {
		parent::__construct($output, $article, $title, $user, $request);
		$this->loadParametersFromRequest();
	}

	function loadParametersFromRequest() {
		$this->perPage = $this->request->getInt('lqt_hist_per_page', 10);
		$this->page = $this->request->getInt('lqt_hist_page', 1);
	}

	function show() {
		global $wgHooks;
		$wgHooks['SkinTemplateTabs'][] = array($this, 'customizeTabs');

		if( ! $this->thread ) {
			$this->showMissingThreadPage();
			return false;
		}
		self::addJSandCSS();

		$this->output->setSubtitle($this->getSubtitle() . '<br />' . wfMsg('lqt_hist_listing_subtitle'));

		$this->showThreadHeading($this->thread);
		$this->showHistoryListing($this->thread);

		$this->showThread($this->thread);

		return false;
	}
}

class ThreadHistoricalRevisionView extends ThreadPermalinkView {

	/* TOOD: customize tabs so that History is highlighted. */

	function postDivClass($thread) {
		$is_changed_thread = $thread->changeObject() &&
			$thread->changeObject()->id() == $thread->id();
		if ( $is_changed_thread )
			return 'lqt_post_changed_by_history';
		else
			return 'lqt_post';
	}

	function showHistoryInfo() {
		global $wgLang; // TODO global.
		$this->openDiv('lqt_history_info');
		$this->output->addHTML(wfMsg('lqt_revision_as_of', $wgLang->timeanddate($this->thread->modified())) .'<br />' );

		$ct = $this->thread->changeType();
		if( $ct == Threads::CHANGE_NEW_THREAD ) $msg = wfMsg('lqt_change_new_thread');
		else if( $ct == Threads::CHANGE_REPLY_CREATED ) $msg = wfMsg('lqt_change_reply_created');
		else if( $ct == Threads::CHANGE_EDITED_ROOT ) {
			$diff_url = $this->permalinkUrlWithDiff($this->thread);
			$msg = wfMsg('lqt_change_edited_root') . " [<a href=\"$diff_url\">" . wfMsg('diff') . '</a>]';
		}
		$this->output->addHTML($msg);
		$this->closeDiv();
	}

	function show() {
		if( ! $this->thread ) {
			$this->showMissingThreadPage();
			return false;
		}
		$this->showHistoryInfo();
		parent::show();
		return false;
	}
}


class SummaryPageView extends LqtView {
	function show() {
		$thread = Threads::withSummary($this->article);
		if( $thread ) {
			$url = $thread->root()->getTitle()->getFullURL();
			$name = $thread->root()->getTitle()->getPrefixedText();
			$this->output->setSubtitle(
				wfMsg('lqt_summary_subtitle',
					'<a href="'.$url.'">'.$name.'</a>'));
		}
		return true;
	}
}



function wfLqtSpecialMoveThreadToAnotherPage() {

    class SpecialMoveThreadToAnotherPage extends SpecialPage {
		private $user, $output, $request, $title, $thread;

        function __construct() {
            SpecialPage::SpecialPage( 'Movethread' );
            $this->includable( false );
        }

	/**
	 * @see SpecialPage::getDescription
	 */
	function getDescription() {
		return wfMsg( 'lqt_movethread' );
	}

		function handleGet() {
			$form_action = $this->title->getLocalURL() . '/' . $this->thread->title()->getPrefixedURL();
			$thread_name = $this->thread->title()->getPrefixedText();
			$article_name = $this->thread->article()->getTitle()->getTalkPage()->getPrefixedText();
			$edit_url = LqtView::permalinkUrl($this->thread, 'edit', $this->thread);
			$wfMsg = 'wfMsg'; // functions can only be called within string expansion by variable name.
			$this->output->addHTML(<<<HTML
			<p>{$wfMsg('lqt_move_movingthread', "<b>$thread_name</b>", "<b>$article_name</b>")}</p>
			<p>{$wfMsg('lqt_move_torename', "<a href=\"$edit_url\">{$wfMsg('lqt_move_torename_edit')}</a>")}</p>
			<form id="lqt_move_thread_form" action="$form_action" method="POST">
			<table>
			<tr>
			<td><label for="lqt_move_thread_target_title">{$wfMsg('lqt_move_destinationtitle')}</label></td>
			<td><input id="lqt_move_thread_target_title" name="lqt_move_thread_target_title" tabindex="100" size="40" /></td>
			</tr><tr>
			<td><label for="lqt_move_thread_reason">{$wfMsg('movereason')}</label></td>
			<td><input id="lqt_move_thread_reason" name="lqt_move_thread_reason" tabindex="200" size="40" /></td>
			</tr><tr>
			<td>&nbsp;</td>
			<td><input type="submit" value="{$wfMsg('lqt_move_move')}" style="float:right;" tabindex="300" /></td>
			</tr>
			</table>
			</form>
HTML
			);

		}

		function checkUserRights() {
			if ( !$this->user->isAllowed( 'move' ) ) {
				$this->output->showErrorPage( 'movenologin', 'movenologintext' );
				return false;
			}
			if ( $this->user->isBlocked() ) {
				$this->output->blockedPage();
				return false;
			}
			if ( wfReadOnly() ) {
				$this->output->readOnlyPage();
				return false;
			}
			if ( $this->user->pingLimiter( 'move' ) ) {
				$this->output->rateLimited();
				return false;
			}
			/* Am I forgetting anything? */
			return true;
		}

		function redisplayForm($problem_fields, $message) {
			$this->output->addHTML($message);
			$this->handleGet();
		}

		function handlePost() {
			if( !$this->checkUserRights() )
				return;

			$tmp = $this->request->getVal('lqt_move_thread_target_title');
			if( $tmp === "" ) {
				$this->redisplayForm(array('lqt_move_thread_target_title'), wfMsg('lqt_move_nodestination'));
				return;
			}
			$newtitle = Title::newFromText( $tmp )->getSubjectPage();

			$reason = $this->request->getVal('lqt_move_thread_reason', wfMsg('lqt_noreason'));

			// TODO no status code from this method.
			$this->thread->moveToSubjectPage( $newtitle, $reason, true );

			$this->showSuccessMessage( $newtitle->getTalkPage() );
		}

		function showSuccessMessage( $target_title ) {
			$this->output->addHTML(wfMsg('lqt_move_success',
				'<a href="'.$target_title->getFullURL().'">'.$target_title->getPrefixedText().'</a>'));
		}

		function execute( $par = null ) {
			global $wgOut, $wgRequest, $wgTitle, $wgUser;
			$this->user = $wgUser;
			$this->output = $wgOut;
			$this->request = $wgRequest;
			$this->title = $wgTitle;

			$this->setHeaders();

			if( $par === null || $par === "") {
				$this->output->addHTML(wfMsg('lqt_threadrequired'));
				return;
			}
			// TODO should implement Threads::withTitle(...).
			$thread = Threads::withRoot( new Article(Title::newFromURL($par)) );
			if (!$thread) {
				$this->output->addHTML(wfMsg('lqt_nosuchthread'));
				return;
			}

			$this->thread = $thread;

			if ( $this->request->wasPosted() ) {
				$this->handlePost();
			} else {
				$this->handleGet();
			}

        }
    }

     SpecialPage::addPage( new SpecialMoveThreadToAnotherPage() );
}

function wfLqtSpecialDeleteThread() {

    class SpecialDeleteThread extends SpecialPage {
		private $user, $output, $request, $title, $thread;

        function __construct() {
            SpecialPage::SpecialPage( 'Deletethread' );
            $this->includable( false );
        }

	/**
	 * @see SpecialPage::getDescription
	 */
	function getDescription() {
		return wfMsg( 'lqt_deletethread' );
	}

		function handleGet() {
			if( !$this->checkUserRights() )
				return;

			$form_action = $this->title->getLocalURL() . '/' . $this->thread->title()->getPrefixedURL();
			$thread_name = $this->thread->title()->getPrefixedText();
			$article_name = $this->thread->article()->getTitle()->getTalkPage()->getPrefixedText();

			$deleting = $this->thread->type() != Threads::TYPE_DELETED;

			$operation_message = $deleting ?
				wfMsg('lqt_delete_deleting', "<b>$thread_name</b>", '<b>'.wfMsg('lqt_delete_deleting_allreplies').'</b>')
//				"Deleting <b>$thread_name</b> and <b>all replies</b> to it."
				: wfMsg('lqt_delete_undeleting', "<b>$thread_name</b>");
			$button_label = $deleting ?
				wfMsg('lqt_delete_deletethread')
				: wfMsg('lqt_delete_undeletethread');
			$part_of = wfMsg('lqt_delete_partof', '<b>'.$article_name.'</b>');
			$reason = wfMsg('movereason'); // XXX arguably wrong to use movereason.

			$this->output->addHTML(<<<HTML
			<p>$operation_message
			$part_of</p>
			<form id="lqt_delete_thread_form" action="{$form_action}" method="POST">
			<table>
			<tr>
			<td><label for="lqt_delete_thread_reason">$reason</label></td>
			<td><input id="lqt_delete_thread_reason" name="lqt_delete_thread_reason" tabindex="200" size="40" /></td>
			</tr><tr>
			<td>&nbsp;</td>
			<td><input type="submit" value="$button_label" style="float:right;" tabindex="300" /></td>
			</tr>
			</table>
			</form>
HTML
			);

		}

		function checkUserRights() {
			if( in_array('delete', $this->user->getRights()) ) {
				return true;
			} else {
				$this->output->addHTML(wfMsg('lqt_delete_unallowed'));
				return false;
			}
		}

		function redisplayForm($problem_fields, $message) {
			$this->output->addHTML($message);
			$this->handleGet();
		}

		function handlePost() {
			// in theory the model should check rights...
			if( !$this->checkUserRights() )
				return;

			$reason = $this->request->getVal('lqt_delete_thread_reason', wfMsg('lqt_noreason'));

			// TODO: in theory, two fast-acting sysops could undo each others' work.
			$is_deleted_already = $this->thread->type() == Threads::TYPE_DELETED;
			if ( $is_deleted_already ) {
				$this->thread->undelete($reason);
			} else {
				$this->thread->delete($reason);
			}
			$this->showSuccessMessage( $is_deleted_already );
		}

		function showSuccessMessage( $is_deleted_already ) {
			// TODO talkpageUrl should accept threads, and look up their talk pages.
			$talkpage_url = LqtView::talkpageUrl($this->thread->article()->getTitle()->getTalkpage());
			$message = $is_deleted_already ? wfMsg('lqt_delete_undeleted') : wfMsg('lqt_delete_deleted');
			$message .= ' ';
			$message .= wfMsg('lqt_delete_return', '<a href="'.$talkpage_url.'">'.wfMsg('lqt_delete_return_link').'</a>');
			$this->output->addHTML($message);
		}

        function execute( $par = null ) {
            global $wgOut, $wgRequest, $wgTitle, $wgUser;
			$this->user = $wgUser;
			$this->output = $wgOut;
			$this->request = $wgRequest;
			$this->title = $wgTitle;

            $this->setHeaders();

			if( $par === null || $par === "") {
				$this->output->addHTML(wfMsg('lqt_threadrequired'));
				return;
			}
			// TODO should implement Threads::withTitle(...).
			$thread = Threads::withRoot( new Article(Title::newFromURL($par)) );
			if (!$thread) {
				$this->output->addHTML(wfMsg('lqt_nosuchthread'));
				return;
			}

			$this->thread = $thread;

			if ( $this->request->wasPosted() ) {
				$this->handlePost();
			} else {
				$this->handleGet();
			}

        }
    }

     SpecialPage::addPage( new SpecialDeleteThread() );
}

class NewUserMessagesView extends LqtView {

	protected $threads;
	protected $tops;
	protected $targets;

	function preShowThread($t) {
//		$t_ids = implode(',', array_map(create_function('$t', 'return $t->id();'), $this->targets[$t->id()]));
		$t_ids = implode(',', $this->targets[$t->id()]);
		$this->output->addHTML(<<<HTML
		<table ><tr>
		<td style="padding-right: 1em; vertical-align: top; padding-top: 1em;" >
		<form method="POST">
			<input type="hidden" name="lqt_method" value="mark_as_read" />
			<input type="hidden" name="lqt_operand" value="{$t_ids}" />
			<input type="submit" value="Read" name="lqt_read_button" title="Remove this thread from New Messages." />
		</form>
		</td>
		<td>
HTML
		);
	}

	function postShowThread($t) {
		$this->output->addHTML(<<<HTML
		</td>
		</tr></table>
HTML
		);
	}

	function showUndo($ids) {
		if( count($ids) == 1 ) {
			$t = Threads::withId($ids[0]);
			$msg = "Thread <b>{$t->subject()}</b> marked as read.";
		} else {
			$count = count($ids);
			$msg = "$count messages marked as read.";
		}
		$operand = implode(',', $ids);
		$this->output->addHTML(<<<HTML
		<form method="POST" class="lqt_undo_mark_as_read">
			$msg
			<input type="hidden" name="lqt_method" value="mark_as_unread" />
			<input type="hidden" name="lqt_operand" value="{$operand}" />
			<input type="submit" value="Undo" name="lqt_read_button" title="Bring back the thread you just dismissed." />
		</form>
HTML
		);
	}

	function postDivClass($thread) {
		$topid = $thread->topmostThread()->id();
		if( in_array($thread->id(), $this->targets[$topid]) )
			return 'lqt_post_new_message';
		else
			return 'lqt_post';
	}

	function showOnce() {
		self::addJSandCSS();

		if( $this->request->wasPosted() ) {
			// If they just viewed this page, maybe they still want that notice.
			// But if they took the time to dismiss even one message, they
			// probably don't anymore.
			$this->user->setNewtalk(false);
		}

		if( $this->request->wasPosted() && $this->methodApplies('mark_as_unread') ) {
			$ids = explode(',', $this->request->getVal('lqt_operand', ''));
			if( $ids !== false ) {
				foreach($ids as $id) {
					NewMessages::markThreadAsUnreadByUser(Threads::withId($id), $this->user);
				}
				$this->output->redirect( $this->title->getFullURL() );
			}
		}

		else if( $this->request->wasPosted() && $this->methodApplies('mark_as_read') ) {
			$ids = explode(',', $this->request->getVal('lqt_operand', ''));
			if( $ids !== false ) {
				foreach($ids as $id) {
					NewMessages::markThreadAsReadByUser(Threads::withId($id), $this->user);
				}
				$query = 'lqt_method=undo_mark_as_read&lqt_operand=' . implode(',', $ids);
				$this->output->redirect( $this->title->getFullURL($query) );
			}
		}

		else if( $this->methodApplies('undo_mark_as_read') ) {
			$ids = explode(',', $this->request->getVal('lqt_operand', ''));
			$this->showUndo($ids);
		}
	}

	function show() {
		if ( ! is_array( $this->threads ) ) {
			throw new MWException('You must use NewUserMessagesView::setThreads() before calling NewUserMessagesView::show().');
		}

		// Do everything by id, because we can't depend on reference identity; a simple Thread::withId
		// can change the cached value and screw up your references.

		$this->targets = array();
		$this->tops = array();
		foreach( $this->threads as $t ) {
			$top = $t->topmostThread();
			if( !in_array($top->id(), $this->tops) )
				$this->tops[] = $top->id();
			if( !array_key_exists($top->id(), $this->targets) )
				$this->targets[$top->id()] = array();
			$this->targets[$top->id()][] = $t->id();
		}

		foreach($this->tops as $t_id) {
			$t = Threads::withId($t_id);
			// It turns out that with lqtviews composed of threads from various talkpages,
			// each thread is going to have a different article... this is pretty ugly.
			$this->article = $t->article();

			$this->preShowThread($t);
			$this->showThread($t);
			$this->postShowThread($t);
		}
		return false;
	}

	function setThreads( $threads ) {
		$this->threads = $threads;
	}
}

function wfLqtSpecialNewMessages() {

    class SpecialNewMessages extends SpecialPage {
		private $user, $output, $request, $title;

        function __construct() {
            SpecialPage::SpecialPage( 'Newmessages' );
            $this->includable( true );
        }

	/**
	 * @see SpecialPage::getDescription
	 */
	function getDescription() {
		return wfMsg( 'lqt_newmessages' );
	}

        function execute( $par = null ) {
		    global $wgOut, $wgRequest, $wgTitle, $wgUser;
			$this->user = $wgUser;
			$this->output = $wgOut;
			$this->request = $wgRequest;
			$this->title = $wgTitle;

            $this->setHeaders();

			$view = new NewUserMessagesView( $this->output, new Article($this->title),
							$this->title, $this->user, $this->request );
			$view->setHeaderLevel(3);
			$view->showOnce();

			$this->output->addHTML('<h2 class="lqt_newmessages_section">Messages sent to you:</h2>');
			$view->setThreads( NewMessages::newUserMessages($this->user) );
			$view->show();

			$this->output->addHTML('<h2 class="lqt_newmessages_section">Messages on other talkpages:</h2>');
			$view->setThreads( NewMessages::watchedThreadsForUser($this->user) );
			$view->show();
        }
    }

     SpecialPage::addPage( new SpecialNewMessages() );
}

function wfLqtBeforeWatchlistHook( $options, $user, &$hook_sql ) {
	global $wgOut;

	$hook_sql = "AND page_namespace != " . NS_LQT_THREAD;

	$talkpage_messages = NewMessages::newUserMessages($user);
	$tn = count($talkpage_messages);

	$watch_messages = NewMessages::watchedThreadsForUser($user);
	$wn = count($watch_messages);

	if( $tn == 0 && $wn == 0 )
		return true;

	LqtView::addJSandCSS();
	$messages_url = SpecialPage::getPage('Newmessages')->getTitle()->getFullURL();
	$wgOut->addHTML(<<< HTML
		<a href="$messages_url" class="lqt_watchlist_messages_notice">
			&#x2712; There are new messages for you.
		</a>
HTML
	);

	return true;
}
