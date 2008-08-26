<?php
/**
 * Replace Text - a MediaWiki extension that provides a special page to
 * allow administrators to do a global string find-and-replace on all the
 * content pages of a wiki.
 *
 * http://www.mediawiki.org/wiki/Extension:Text_Replace
 *
 * The special page created is 'Special:ReplaceText', and it provides
 * a form to do a global search-and-replace, with the changes to every
 * page showing up as a wiki edit, with the administrator who performed
 * the replacement as the user, and an edit summary that looks like
 * "Text replace: 'search string' * to 'replacement string'".
 *
 * If the replacement string is blank, or is already found in the wiki,
 * the page provides a warning prompt to the user before doing the
 * replacement, since it is not easily reversible.
 *
 * @version 0.2.3
 * @author Yaron Koren
 */

if (!defined('MEDIAWIKI')) die();

global $IP;
require_once( "$IP/includes/SpecialPage.php" );

$wgExtensionFunctions[] = 'grSetupExtension';

if (version_compare($wgVersion, '1.11', '>=')) {
	$wgExtensionMessagesFiles['ReplaceText'] = dirname( __FILE__ ) . '/ReplaceText.i18n.php';
} else {
	$wgExtensionFunctions[] = 'grfLoadMessagesManually';
}

$wgJobClasses['replaceText'] = 'ReplaceTextJob';

require_once( "$IP/includes/JobQueue.php" );
require_once( dirname( __FILE__ ) . '/ReplaceTextJob.php');

function grSetupExtension() {
	global $wgVersion, $wgExtensionCredits;

	if (version_compare($wgVersion, '1.11', '>='))
		wfLoadExtensionMessages( 'ReplaceText' );

	// credits
	$wgExtensionCredits['specialpage'][] = array(
		'name' => 'Replace Text',
		'version' => '0.2.3',
		'author' => 'Yaron Koren',
		'url' => 'http://www.mediawiki.org/wiki/Extension:Text_Replace',
		'description' => 'A special page that lets administrators run a global search-and-replace',
		'descriptionmsg'  => 'replacetext-desc',
	);

	// you need to set the right 'replacetext' for a group,
	// e.g.  $wgGroupPermissions['sysop']['replacetext'] = true;  for sysops
	SpecialPage::addPage(new SpecialPage('ReplaceText', 'replacetext', true, 'doReplaceText', false));
}

/**
 * Initialize messages - these settings must be applied later on, since
 * the MessageCache does not exist yet when the settings are loaded in
 * LocalSettings.php.
 * Function based on version in ContributionScores extension
 */
function grfInitMessages() {
	global $wgVersion, $wgExtensionFunctions;
}

/**
 * Setting of message cache for versions of MediaWiki that do not support
 * wgExtensionFunctions - based on ceContributionScores() in
 * ContributionScores extension
 */
function grfLoadMessagesManually() {
	global $grIP, $wgMessageCache;

	# add messages
	require($grIP . '/ReplaceText.i18n.php');
	foreach($messages as $key => $value) {
		$wgMessageCache->addMessages($messages[$key], $key);
	}
}

function displayConfirmForm($message) {
	global $wgRequest;
	$target_str = $wgRequest->getVal('target_str');
	$replacement_str = $wgRequest->getVal('replacement_str');
	// escape quotes for inclusion in HTML
	$target_str = str_replace('"', '&quot;', $target_str);
	$replacement_str = str_replace('"', '&quot;', $replacement_str);
	$continue_label = wfMsg('replacetext_continue');
	$cancel_label = wfMsg('replacetext_cancel');
	$text =<<<END
	<form method="post" action="">
	<input type="hidden" name="target_str" value="$target_str">
	<input type="hidden" name="replacement_str" value="$replacement_str">
	<p>$message</p>
	<p><input type="Submit" name="confirm" value="$continue_label"></p>
	<p>$cancel_label</p>
	</form>

END;
	return $text;
}

function doReplaceText() {
  global $wgUser, $wgOut, $wgRequest, $wgContLang;

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
        $title = Title::newFromId($key);
        $jobs[] = new ReplaceTextJob( $title, $replacement_params );
      }
    }
    Job::batchInsert( $jobs );
    $num_modified_pages = count($jobs);
    $wgOut->addHTML(wfMsg('replacetext_success', $target_str, $replacement_str, $num_modified_pages));
  } elseif ($wgRequest->getCheck('target_str')) {
    $dbr =& wfGetDB( DB_SLAVE );
    $fname = 'doReplaceText';
    $target_str = $wgRequest->getVal('target_str');
    $replacement_str = $wgRequest->getVal('replacement_str');

    if (! $wgRequest->getCheck('confirm')) {
      // display a page to make the user confirm the replacement, if the
      // replacement string is either blank or found elsewhere on the wiki
      // (since undoing the replacement would be difficult in either case)
      if ($replacement_str == '') {
        $text = wfMsg('replacetext_blankwarning');
        $wgOut->addHTML(displayConfirmForm($text));
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
          $text = wfMsg('replacetext_warning', $num_pages_with_replacement_str, $replacement_str);
          $wgOut->addHTML(displayConfirmForm($text));
          return;
        }
      }
    }

    $jobs = array();
    $num_modified_pages = 0;
    $found_titles = array();
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
    $sql_target_str = str_replace("'", "\'", $target_str);
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

    if ($num_modified_pages == 0)
      $wgOut->addHTML(wfMsg('replacetext_noreplacement', $target_str));
    else {
      $replace_label = wfMsg('replacetext_replace');
      $choose_pages_label = wfMsg('replacetext_choosepages', $target_str, $replacement_str);
      $skin = $wgUser->getSkin();
      // escape quotes for inclusion in HTML
      $target_str = str_replace('"', '&quot;', $target_str);
      $replacement_str = str_replace('"', '&quot;', $replacement_str);
      $text =<<<END
	<p>$choose_pages_label</p>
	<form method="post">
	<input type="hidden" name="target_str" value="$target_str">
	<input type="hidden" name="replacement_str" value="$replacement_str">

END;
      foreach ($found_titles as $value_pair) {
        list($title, $context_str) = $value_pair;
        $text .= "<input type=\"checkbox\" name=\"{$title->getArticleID()}\" checked /> {$skin->makeLinkObj( $title, $title->prefix($title->getText()) )} - <small>$context_str</small><br />\n";
      }
      $text .=<<<END
	<p><input type="Submit" name="replace" value="$replace_label"></p>
	</form>

END;
      $wgOut->addHTML($text);
    }
  } else {
    $replacement_label = wfMsg('replacetext_docu');
    $replacement_note = wfMsg('replacetext_note');
    $original_text_label = wfMsg('replacetext_originaltext');
    $replacement_text_label = wfMsg('replacetext_replacementtext');
    $continue_label = wfMsg('replacetext_continue');
    $legendmsg = wfMsg( 'replacetext');
    $text =<<<END
    <p>$replacement_label</p>
    <fieldset>
    <legend>$legendmsg</legend>
	<form method="get" action="">
	<p>$replacement_note</p>
	<table><tr>
	<td>$original_text_label &nbsp;</td><td><input type="text" length="20" style="width:300px;" name="target_str"></td>
	</tr><tr>
	<td>$replacement_text_label &nbsp;</td><td><input type="text" length="20" style="width:300px;" name="replacement_str"></td>
	</tr></table>
	<p><input type="Submit" value="$continue_label"></p>
	</form>
	</fieldset>

END;
    $wgOut->addHTML($text);
  }

}
