<?php

if (!defined('MEDIAWIKI')) die();

class ReplaceText extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct('ReplaceText', 'replacetext');
		wfLoadExtensionMessages('ReplaceText');
	}

	function execute( $para ) {
		global $wgUser, $wgOut;

		if ( ! $wgUser->isAllowed('replacetext') ) {
			$wgOut->permissionRequired('replacetext');
			return;
		}

		$this->setHeaders();
		doSpecialReplaceText();
	}

	function displayConfirmForm($message) {
		global $wgRequest, $wgContLang;
		$target_str = $wgRequest->getVal('target_str');
		$replacement_str = $wgRequest->getVal('replacement_str');
		// escape quotes for inclusion in HTML
		$target_str = str_replace('"', '&quot;', $target_str);
		$replacement_str = str_replace('"', '&quot;', $replacement_str);
		$continue_label = wfMsg('replacetext_continue');
		$cancel_label = wfMsg('replacetext_cancel');
		// set 'title' as hidden field, in case there's no URL niceness
		$mw_namespace_labels = $wgContLang->getNamespaces();
		$special_namespace = $mw_namespace_labels[NS_SPECIAL];
		$text =<<<END
	<form method="post" action="">
	<input type="hidden" name="title" value="$special_namespace:ReplaceText">
	<input type="hidden" name="target_str" value="$target_str">
	<input type="hidden" name="replacement_str" value="$replacement_str">
	<p>$message</p>
	<p><input type="Submit" name="confirm" value="$continue_label"></p>
	<p>$cancel_label</p>
	</form>

END;
		return $text;
	}
}

function doSpecialReplaceText() {
	global $wgUser, $wgOut, $wgRequest, $wgContLang;

	// set 'title' as hidden field, in case there's no URL niceness
	$mw_namespace_labels = $wgContLang->getNamespaces();
	$special_namespace = $mw_namespace_labels[NS_SPECIAL];

	if ($wgRequest->getCheck('replace')) {
		$target_str = $wgRequest->getVal('target_str');
		$replacement_str = $wgRequest->getVal('replacement_str');
		$replacement_params = array();
		$replacement_params['user_id'] = $wgUser->getId();
		$replacement_params['target_str'] = $target_str;
		$replacement_params['replacement_str'] = $replacement_str;
		$replacement_params['edit_summary'] = wfMsgForContent('replacetext_editsummary', $target_str, $replacement_str);
		foreach ($wgRequest->getValues() as $key => $value) {
			if ($value == 'on') {
				if (strpos($key, 'move-') !== false) {
					$title = Title::newFromId(substr($key, 5));
					$replacement_params['move_page'] = true;
				} else {
					$title = Title::newFromId($key);
				}
				if ($title !== null)
					$jobs[] = new ReplaceTextJob( $title, $replacement_params );
			}
		}
		Job::batchInsert( $jobs );
		$num_modified_pages = count($jobs);
		$wgOut->addHTML( wfMsgExt( 'replacetext_success', array( 'escape', 'parsemag' ), $target_str, $replacement_str, $num_modified_pages) );
	} elseif ( $wgRequest->getCheck('target_str') ) { // very long elseif, look for "end elseif"
		$dbr =& wfGetDB( DB_SLAVE );
		$fname = 'doSpecialReplaceText';
		$target_str = $wgRequest->getVal('target_str');
		$replacement_str = $wgRequest->getVal('replacement_str');

		if (! $wgRequest->getCheck('confirm')) {
			// display a page to make the user confirm the replacement, if the
			// replacement string is either blank or found elsewhere on the wiki
			// (since undoing the replacement would be difficult in either case)
			if ($replacement_str == '') {
				$text = wfMsg('replacetext_blankwarning');
				$wgOut->addHTML(ReplaceText::displayConfirmForm($text));
				return;
			} else {
				// get the number of pages in which the replacement string appears
				$page_table = $dbr->tableName('page');
				$revision_table = $dbr->tableName('revision');
				$text_table = $dbr->tableName('text');
				$talk_ns = NS_TALK;
				$usertalk_ns = NS_USER_TALK;
				$mediawiki_ns = NS_MEDIAWIKI;	
				$sql_replacement_str = str_replace("'", "\'", $replacement_str);
				$sql = "SELECT count(*)
					FROM $page_table p
					JOIN $revision_table r ON p.page_latest = r.rev_id
					JOIN $text_table t ON r.rev_text_id = t.old_id
					WHERE t.old_text LIKE '%$sql_replacement_str%'
					AND p.page_namespace != $talk_ns
					AND p.page_namespace != $usertalk_ns
					AND p.page_namespace != $mediawiki_ns";
				$res = $dbr->query($sql);
				$row = $dbr->fetchRow($res);
				$num_pages_with_replacement_str = $row[0];
				// if there are any, the user most confirm the replacement
				if ($num_pages_with_replacement_str > 0) {
  					$text = wfMsgExt( 'replacetext_warning', array( 'escape', 'parsemag' ), $num_pages_with_replacement_str, $replacement_str );
					$wgOut->addHTML(ReplaceText::displayConfirmForm($text));
					return;
				}
			}
		}
		$jobs = array();
		$num_modified_pages = 0;
		$found_titles = array();
		$titles_for_move = array();
		$unmoveable_titles = array();
		$angle_brackets = array('<', '>');
		$escaped_angle_brackets = array('&lt;', '&gt;');
		
		// get the set of pages that contain the target string, and display
		// the name and "context" (the text around the string) of each
		$page_table = $dbr->tableName('page');
		$revision_table = $dbr->tableName('revision');
		$text_table = $dbr->tableName('text');
		$talk_ns = NS_TALK;
		$usertalk_ns = NS_USER_TALK;
		$mediawiki_ns = NS_MEDIAWIKI;	
		// escape single quote and backslash for SQL - for some reason, the
		// backslash needs to be escaped twice (plus once for PHP)
		$sql_target_str = str_replace(array("\\", "'"), array("\\\\\\\\", "\'"), $target_str);
		# FIXME: suggestions for improvement at http://www.mediawiki.org/wiki/Special:Code/MediaWiki/43239#c608
		$sql = "SELECT p.page_title AS title, p.page_namespace AS namespace, t.old_text AS text
			FROM $page_table p
			JOIN $revision_table r ON p.page_latest = r.rev_id
			JOIN $text_table t ON r.rev_text_id = t.old_id
			WHERE t.old_text LIKE '%$sql_target_str%'
			AND p.page_namespace != $talk_ns
			AND p.page_namespace != $usertalk_ns
			AND p.page_namespace != $mediawiki_ns
			ORDER BY p.page_namespace, p.page_title";
		$res = $dbr->query($sql);
		$contextchars = $wgUser->getOption( 'contextchars', 40 );
		while( $row = $dbr->fetchObject( $res ) ) {
			$title = Title::newFromText($row->title, $row->namespace);
			$article_text = $row->text;
			$target_pos = strpos($article_text, $target_str);
			$context_str = str_replace($angle_brackets, $escaped_angle_brackets, $wgContLang->truncate(substr($article_text, 0, $target_pos), -$contextchars, '...' ));
			$context_str .= "<span class=\"searchmatch\">" . str_replace($angle_brackets, $escaped_angle_brackets, substr($article_text, $target_pos, strlen($target_str))) . "</span>";
			$context_str .= str_replace($angle_brackets, $escaped_angle_brackets, $wgContLang->truncate(substr($article_text, $target_pos + strlen($target_str)), $contextchars, '...' ));
			$found_titles[] = array($title, $context_str);
			$num_modified_pages++;
		}
		if ($wgRequest->getCheck('move_pages')) {
			$sql_target_str2 = str_replace(' ', '_', $sql_target_str);
			$sql2 = "SELECT p.page_title AS title, p.page_namespace AS namespace
	FROM $page_table p
	WHERE p.page_title LIKE '%$sql_target_str2%'
	ORDER BY p.page_namespace, p.page_title";
			$res = $dbr->query($sql2);
			while( $row = $dbr->fetchObject( $res ) ) {
				$title = Title::newFromText($row->title, $row->namespace);
				// see if this move can happen
				$cur_page_name = str_replace('_', ' ', $row->title);
				$new_page_name = str_replace($target_str, $replacement_str, $cur_page_name);
				$new_title = Title::newFromText($new_page_name, $row->namespace);
				$err = $title->isValidMoveOperation($new_title);
				if ($title->userCanMove(true) && (! is_array($err))) {
					$titles_for_move[] = $title;
					$num_modified_pages++;
				} else {
					$unmoveable_titles[] = $title;
				}
			}
		}
		if ($num_modified_pages == 0) {
			$wgOut->addHTML(wfMsg('replacetext_noreplacement', $target_str));
		} else {
		$javascript_text =<<<END
<script type="text/javascript">
function invertSelections() {
	form = document.getElementById('choose_pages');
	num_elements = form.elements.length;
	for (i = 0; i < num_elements; i++) {
		if (form.elements[i].type == "checkbox") {
			if (form.elements[i].checked == true)
				form.elements[i].checked = false;
			else
				form.elements[i].checked = true;
		}
	}
}
		</script>

END;
		$wgOut->addScript($javascript_text);
		$replace_label = wfMsg('replacetext_replace');
		$choose_pages_label = wfMsgExt('replacetext_choosepages', array( 'escape', 'parsemag' ), $target_str, $replacement_str, count( $found_titles ) );
		$choose_pages_for_move_label = wfMsgExt( 'replacetext_choosepagesformove', array( 'escape', 'parsemag' ), count( $titles_for_move ) );
		$cannot_move_pages_label = wfMsgExt( 'replacetext_cannotmove', array( 'escape', 'parsemag' ), count( $unmoveable_titles ) );
		$skin = $wgUser->getSkin();
		// escape quotes for inclusion in HTML
		$target_str = str_replace('"', '&quot;', $target_str);
		$replacement_str = str_replace('"', '&quot;', $replacement_str);
		$text =<<<END
	<p>$choose_pages_label</p>
	<form id="choose_pages" method="post">
	<input type="hidden" name="title" value="$special_namespace:ReplaceText">
	<input type="hidden" name="target_str" value="$target_str">
	<input type="hidden" name="replacement_str" value="$replacement_str">

END;
		foreach ($found_titles as $value_pair) {
			list($title, $context_str) = $value_pair;
			$text .= "<input type=\"checkbox\" name=\"{$title->getArticleID()}\" checked /> {$skin->makeLinkObj( $title, $title->prefix($title->getText()) )} - <small>$context_str</small><br />\n";
  		}
		if (count($titles_for_move) > 0) {
			$text .= "<p>$choose_pages_for_move_label</p>\n";
			foreach ($titles_for_move as $title) {
				$text .= "<input type=\"checkbox\" name=\"move-{$title->getArticleID()}\" checked /> {$skin->makeLinkObj( $title, $title->prefix($title->getText()) )}<br />\n";
 	 		}
		}
		$text .=<<<END
	<p><input type="Submit" name="replace" value="$replace_label"></p>

END;
		// only show "invert selections" link if there are more than five pages
		if (count($found_titles) + count($titles_for_move) > 5) {
			$invert_selections_label = wfMsg('replacetext_invertselections');
			$text .=<<<END
	<p><a href="javascript:;" onclick="invertSelections(); return false;">$invert_selections_label</a></p>

END;
  		}
		$text .= "	</form>\n";
		if (count($unmoveable_titles) > 0) {
			$text .= "<p>$cannot_move_pages_label</p>\n";
			$text .= "<ul>\n";
			foreach ($unmoveable_titles as $title) {
				$text .= "<li>{$skin->makeLinkObj( $title, $title->prefix($title->getText()) )}<br />\n";
  			}
			$text .= "</ul>\n";
		}
		$wgOut->addHTML($text);
	}
	} // end elseif
	else {
		$replacement_label = wfMsg('replacetext_docu');
		$replacement_note = wfMsg('replacetext_note');
		$original_text_label = wfMsg('replacetext_originaltext');
		$replacement_text_label = wfMsg('replacetext_replacementtext');
		$move_pages_label = wfMsg('replacetext_movepages');
		$continue_label = wfMsg('replacetext_continue');
		$text =<<<END
	<form method="get" action="">
	<input type="hidden" name="title" value="$special_namespace:ReplaceText">
	<p>$replacement_label</p>
	<p>$replacement_note</p>
	<table>
	<tr>
	<td>$original_text_label:</td>
	<td><input type="text" length="10" name="target_str"></td>
	</tr>
	<tr>
	<td>$replacement_text_label:</td>
	<td><input type="text" length="10" name="replacement_str"></td>
	</tr>
	</table>
	<p><input type="checkbox" name="move_pages"> $move_pages_label</p>
	<p><input type="Submit" value="$continue_label"></p>
	</form>

END;
		$wgOut->addHTML($text);
	}
}
