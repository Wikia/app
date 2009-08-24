<?php
/**
 * Displays a pre-defined form for editing a page's data.
 *
 * @author Yaron Koren
 */

/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if (!defined('MEDIAWIKI')) die();

class SFEditData extends SpecialPage {

	/**
	 * Constructor
	 */
	function SFEditData() {
		SpecialPage::SpecialPage('EditData');
		wfLoadExtensionMessages('SemanticForms');
	}

	function execute($query) {
		global $wgRequest;
		$this->setHeaders();
		$form_name = $wgRequest->getVal('form');
		$target_name = $wgRequest->getVal('target');

		// if query string did not contain these variables, try the URL
		if (! $form_name && ! $target_name) {
			$queryparts = explode('/', $query, 2);
			$form_name = $queryparts[0];
			$target_name = $queryparts[1];
		}

		self::printEditForm($form_name, $target_name);
	}

static function printEditForm($form_name, $target_name) {
	global $wgOut, $wgRequest, $wgScriptPath, $sfgScriptPath, $sfgFormPrinter, $sfgYUIBase;

	wfLoadExtensionMessages('SemanticForms');

	$javascript_text = "";
	// get contents of form definition file
	$form_title = Title::makeTitleSafe(SF_NS_FORM, $form_name);
	// get contents of target page
	$target_title = Title::newFromText($target_name);

	if (! $form_title || ! $form_title->exists() ) {
		if ($form_name == '')
			$text = '<p class="error">' . wfMsg('sf_editdata_badurl') . "</p>\n";
		else
			$text = '<p class="error">Error: No form page was found at ' . SFUtils::linkText(SF_NS_FORM, $form_name) . ".</p>\n";
	} elseif (! $target_title || ! $target_title->exists() ) {
		if ($target_name == '')
			$text = '<p class="error">' . wfMsg('sf_editdata_badurl') . "</p>\n";
		else
			$text = '<p class="error">Error: No page was found at ' . SFUtils::linkText(null, $target_name) . ".</p>\n";
	} else {
		$s = wfMsg('sf_editdata_title', $form_title->getText(), $target_title->getPrefixedText());
		$wgOut->setPageTitle($s);
		$form_article = new Article($form_title);
		$form_definition = $form_article->getContent();
		$submit_url = $form_title->getLocalURL('action=submit');
		$save_page = $wgRequest->getCheck('wpSave');
		$preview_page = $wgRequest->getVal('wpPreview');
		$diff_page = $wgRequest->getVal('wpDiff');
		$summary_text = $wgRequest->getVal('wpSummary');
		$form_submitted = ($save_page || $preview_page || $diff_page);
		$page_title = str_replace('_', ' ', $target_name);
		// if user already made some action, ignore the edited page
		// and just get data from the query string
		if ($wgRequest->getVal('query') == 'true') {
			$edit_content = null;
			$is_text_source = false;
		} else {
			$target_article = new Article($target_title);
			$edit_content = $target_article->getContent();
			$is_text_source = true;
		}
		list ($form_text, $javascript_text, $data_text, $form_page_title) =
			$sfgFormPrinter->formHTML($form_definition, $form_submitted, $is_text_source, $edit_content, $page_title);
		if ($form_submitted) {
			$wgOut->setArticleBodyOnly( true );
			$text = SFUtils::printRedirectForm($target_title, $data_text, $wgRequest->getVal('wpSummary'), $save_page, $preview_page, $diff_page, $wgRequest->getCheck('wpMinoredit'), $wgRequest->getCheck('wpWatchthis'), $wgRequest->getVal('wpStarttime'), $wgRequest->getVal('wpEdittime'));
		} else {
			// override the default title for this page if
			// a title was specified in the form
			if ($form_page_title != NULL) {
				$wgOut->setPageTitle("$form_page_title: {$target_title->getPrefixedText()}");
			}
			$text =<<<END
	<form name="createbox" onsubmit="return validate_all()" action="" method="post" class="createbox">
	<input type="hidden" name="query" value="true" />

END;
			$text .= $form_text;
		}
	}
	SFUtils::addJavascriptAndCSS();
	$wgOut->addScript('		<script type="text/javascript">' . "\n" . $javascript_text . '</script>' . "\n");
	$wgOut->addHTML($text);
}

}
