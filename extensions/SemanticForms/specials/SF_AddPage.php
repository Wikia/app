<?php
/**
 * Displays a form for entering the title of a page, which then redirects
 * to either the form for adding the page, or a form for editing it,
 * depending on whether the page already exists.
 *
 * @author Yaron Koren
 * @author Jeffrey Stuckman
 */
if (!defined('MEDIAWIKI')) die();

class SFAddPage extends SpecialPage {

	/**
	 * Constructor
	 */
	function SFAddPage() {
		SpecialPage::SpecialPage('AddPage');
		wfLoadExtensionMessages('SemanticForms');
	}

	function execute($query = '') {
		$this->setHeaders();
		doSpecialAddPage($query);
	}
}

function doSpecialAddPage($query = '') {
	global $wgOut, $wgRequest, $sfgScriptPath;

	$form_name = $wgRequest->getVal('form');
	$target_namespace = $wgRequest->getVal('namespace');
	$super_page = $wgRequest->getVal('super_page');
	$params = $wgRequest->getVal('params');

	// if query string did not contain form name, try the URL
	if (! $form_name) {
		$form_name = $query;
		// get namespace from  the URL, if it's there
		if ($namespace_label_loc = strpos($form_name, "/Namespace:")) {
			$target_namespace = substr($form_name, $namespace_label_loc + 11);
			$form_name = substr($form_name, 0, $namespace_label_loc);
		}
	}

	// remove forbidden characters from form name
	$forbidden_chars = array('"', "'", '<', '>', '{', '}', '(', ')', '[', ']', '=');
	$form_name = str_replace($forbidden_chars, "", $form_name);

	// get title of form
	$form_title = Title::newFromText($form_name, SF_NS_FORM);

	// handle submission
	$form_submitted = $wgRequest->getCheck('page_name');
	if ($form_submitted) {
		$page_name = $wgRequest->getVal('page_name');
		// This form can be used to create a sub-page for an
		// existing page
		if ('' != $super_page)
		{
			$page_name = "$super_page/$page_name";
		}
		if ('' != $page_name) {
			// Append the namespace prefix to the page name,
			// if a namespace was not already entered.
			if (strpos($page_name,":") === false)
				$page_name = $target_namespace . ":" . $page_name;
			// find out whether this page already exists,
			// and send user to the appropriate form
			$page_title = Title::newFromText($page_name);
			if ($page_title && $page_title->exists()) {
				// it exists - see if page is a redirect; if
				// it is, edit the target page instead
				$article = new Article($page_title);
				$article->loadContent();
				$redirect_title = Title::newFromRedirect($article->fetchContent());
				if ($redirect_title != NULL) {
					$page_title = $redirect_title;
				}
				// HACK - if this is the default form for
				// this page, send to the regular 'formedit'
				// tab page; otherwise, send to the 'Special:EditData'
				// page, with the form name hardcoded.
				// Is this logic necessary? Or should we just
				// out-guess the user and always send to the
				// standard form-edit page, with the 'correct' form?
				$default_form_name = sffGetFormForArticle($article);
				if ($form_name == $default_form_name) {
					$redirect_url = $page_title->getLocalURL('action=formedit');
				} else {
					$ed = SpecialPage::getPage('EditData');
					$redirect_url = $ed->getTitle()->getFullURL() . "/" . $form_name . "/" . sffTitleURLString($page_title);
				}
			} else {
				$ad = SpecialPage::getPage('AddData');
				$redirect_url = $ad->getTitle()->getFullURL() . "/" . $form_name . "/" . sffTitleURLString($page_title);
				// of all the request values, send on to
				// 'AddData' only 'preload' and specific form
				// fields - we can tell the latter because
				// they show up as 'arrays'
				$first_val_added = false;
				foreach ($_REQUEST as $key => $val) {
					if (is_array($val)) {
						$template_name = $key;
						foreach ($val as $field_name => $value) {
							$redirect_url .= ($first_val_added) ? '&' : '?';
							$redirect_url .= $template_name . '[' . $field_name . ']=' . $value;
							$first_val_added = true;
						}
					} elseif ($key == 'preload') {
						$redirect_url .= ($first_val_added) ? '&' : '?';
						$redirect_url .= "$key=$val";
						$first_val_added = true;
					}
				}
			}

			if ('' != $params) {
				$redirect_url .= ($first_val_added) ? '&' : '?';
				$redirect_url .= $params;
			}

			$text =<<<END
        <script type="text/javascript">
        window.location="$redirect_url";
        </script>

END;
			$wgOut->addHTML($text);
			return;
		}
	}

	if ((! $form_title || ! $form_title->exists()) && ($form_name != '')) {
		$text = '<p>' . wfMsg('sf_addpage_badform', sffLinkText(SF_NS_FORM, $form_name)) . ".</p>\n";
	} else {
		if ($form_name == '')
			$description = wfMsg('sf_addpage_noform_docu', $form_name);
		else
			$description = wfMsg('sf_addpage_docu', $form_name);
		$button_text = wfMsg('addoreditdata');
		$text =<<<END
	<form action="" method="post">
	<p>$description</p>
	<p><input type="text" size="40" name="page_name">

END;
		// if no form was specified, display a dropdown letting
		// the user choose the form
		if ($form_name == '')
			$text .= sffFormDropdownHTML();

		$hidden_target_namespace = htmlspecialchars($target_namespace);
		$hidden_super_page = htmlspecialchars($super_page);
		$hidden_params = htmlspecialchars($params);

		$text .=<<<END
	</p>
	<input type="hidden" name="namespace" value="$hidden_target_namespace">
	<input type="hidden" name="super_page" value="$hidden_super_page">
	<input type="hidden" name="params" value="$hidden_params">
	<input type="Submit" value="$button_text">
	</form>

END;
	}
	$wgOut->addHTML($text);
}
