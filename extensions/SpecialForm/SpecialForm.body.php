<?php
/**
 * SpecialForm.php -- Use a form-based interface to start new articles
 * Copyright 2007 Vinismo, Inc. (http://vinismo.com/)
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @author Evan Prodromou <evan@vinismo.com>
 * @ingroup Extensions
 */

if (!defined('MEDIAWIKI')) {
	exit( 1 );
}

require_once('XmlFunctions.php');

class SpecialForm extends SpecialPage {
	function SpecialForm() {
		SpecialPage::SpecialPage("Form");
	}

	function execute( $par ) {
		global $wgRequest, $wgOut;

		wfLoadExtensionMessages( 'Form' );

		# Must have a name, like Special:Form/Nameofform
		# XXX: instead of an error, show a list of available forms

		if (!$par) {
			$wgOut->showErrorPage('formnoname', 'formnonametext');
			return;
		}

		$form = $this->loadForm($par);

		# Bad form

		if (!$form) {
			$wgOut->showErrorPage('formbadname', 'formbadnametext');
			return;
		}

		if ($wgRequest->wasPosted()) {
			# POST is to create an article
			$this->createArticle($form);
		} else {
			# GET (HEAD?) is to show the form
			$this->showForm($form);
		}
	}

	# Load and parse a form article from the DB

	function loadForm($name) {
		$nt = Title::makeTitleSafe(NS_MEDIAWIKI, wfMsgForContent('formpattern', $name));

		# article exists?

		if (!$nt || $nt->getArticleID() == 0) {
			return NULL;
		}

		$article = new Article($nt);

		assert($article);

		$text = $article->getContent(true);

		# Form constructor does the parsing

		return new Form($name, $text);
	}

	function showForm($form, $errmsg = NULL) {
		global $wgOut, $wgRequest, $wgParser, $wgTitle, $wgUser, $wgSpecialFormRecaptcha;

		$self = SpecialPage::getTitleFor(wfMsgForContent('form') . '/' . $form->name);

		$wgOut->setPageTitle($form->title);

		if (!is_null($form->instructions)) {

			$wgOut->addHTML(Xml::openElement('div', array('class' => 'instructions')) .
							$wgOut->parse($form->instructions) .
							Xml::closeElement('div') .
							Xml::element('br'));
		}

		if (!is_null($errmsg)) {
			$wgOut->addHTML(Xml::openElement('div', array('class' => 'error')) .
							$wgOut->parse($errmsg) .
							Xml::closeElement('div') .
							Xml::element('br'));
		}

		$wgOut->addHTML(Xml::openElement('form',
									  array('method' => 'POST',
											'action' => $self->getLocalURL())));

		foreach ($form->fields as $field) {
			$wgOut->addHTML($field->render($wgRequest->getText($field->name)) . Xml::element('br') . "\n");
		}

		if ($wgUser->getId() == 0 && $wgSpecialFormRecaptcha) { # Anonymous user, use recaptcha
			require_once('recaptchalib.php');
			global $recaptcha_public_key; # same as used by Recaptcha plugin
			$wgOut->addHTML(recaptcha_get_html($recaptcha_public_key));
		}

		$wgOut->addHTML(Xml::element('input', array('type' => 'submit',
												 'value' => wfMsg('formsave'))));

		$wgOut->addHTML(Xml::closeElement('form'));
	}

	function createArticle($form) {

		global $wgOut, $wgRequest, $wgLang, $wgUser, $wgSpecialFormRecaptcha;

		# Check recaptcha

		if ($wgUser->getId() == 0 && $wgSpecialFormRecaptcha) {

			require_once('recaptchalib.php');
			global $recaptcha_private_key; # same as used by Recaptcha plugin
			$resp = recaptcha_check_answer($recaptcha_private_key,
										   $_SERVER["REMOTE_ADDR"],
										   $wgRequest->getText("recaptcha_challenge_field"),
										   $wgRequest->getText("recaptcha_response_field"));

			if (!$resp->is_valid) {
				$this->showForm($form, wfMsg('formbadrecaptcha'));
				return;
			}
		}

		# Check for required fields

		$missedFields = array();

		foreach ($form->fields as $name => $field) {
			$value = $wgRequest->getText($name);
			if ($field->isOptionTrue('required') && (is_null($value) || strlen($value) == 0)) {
				$missedFields[] = $field->label;
			}
		}

		# On error, show the form again with some error text.

		if ($missedFields) {
			if (count($missedFields) > 1) {
				$msg = wfMsg('formrequiredfieldpluralerror', $wgLang->listToText($missedFields));
			} else {
				$msg = wfMsg('formrequiredfielderror', $missedFields[0]);
			}
			$this->showForm($form, $msg);
			return;
		}

		# First, we make sure we have all the titles

		$nt = array();

		for ($i = 0; $i < count($form->template); $i++) {

			$namePattern = $form->namePattern[$i];
			$template = $form->template[$i];

			if (!$namePattern || !$template) {
				$wgOut->showErrorPage('formindexmismatch-title', 'formindexmismatch', array($i));
				return;
			}

			wfDebug("SpecialForm: for index '$i', namePattern = '$namePattern' and template = '$template'.\n");

			$title = $this->makeTitle($form, $namePattern);

			$nt[$i] = Title::newFromText($title);

			if (!$nt[$i]) {
				$wgOut->showErrorPage('formbadpagename', 'formbadpagenametext', array($title));
				return;
			}

			if ($nt[$i]->getArticleID() != 0) {
				$wgOut->showErrorPage('formarticleexists', 'formarticleexists', array($title));
				return;
			}
		}

		# At this point, all $nt titles should be valid, although we're subject to race conditions.

		for ($i = 0; $i < count($form->template); $i++) {

			$template = $form->template[$i];

			$text = "{{subst:$template";

			foreach ($form->fields as $name => $field) {
				# FIXME: strip/escape template-related chars (|, =, }})
				$text .= "|$name=" . $wgRequest->getText($name);
			}

			$text .= "}}";

			if (!$this->checkSave($nt[$i], $text)) {
				# Just break here; output already sent
				return;
			}

			$title = $nt[$i]->GetPrefixedText();

			wfDebug("SpecialForm: saving article with index '$i' and title '$title'\n");

			$article = new Article($nt[$i]);

			$status = $article->doEdit($text, wfMsg('formsavesummary', $form->name), EDIT_NEW);
			if ( $status === false || ( is_object( $status ) && !$status->isOK() ) ) {
				$wgOut->showErrorPage('formsaveerror', 'formsaveerrortext', array($title));
				return; # Don't continue
			}
		}

		# Redirect to the first article

		if ($nt && $nt[0]) {
			$wgOut->redirect($nt[0]->getFullURL());
		}
	}

	function makeTitle($form, $pattern) {
		global $wgRequest;

		$title = $pattern;

		foreach ($form->fields as $name => $field) {
			$title = preg_replace("/{{\{$name\}}}/", $wgRequest->getText($name), $title);
		}

		return $title;
	}

	# Had to crib some checks from EditPage.php, since they're not done in Article.php

	function checkSave($nt, $text) {
		global $wgSpamRegex, $wgFilterCallback, $wgUser, $wgMaxArticleSize, $wgOut;

		$matches = array();
		$errortext = "";

		$editPage = new FakeEditPage($nt);

		# FIXME: more specific errors, copied from EditPage.php

		if ($wgSpamRegex && preg_match($wgSpamRegex, $text, $matches)) {
			$wgOut->showErrorPage('formsaveerror', 'formsaveerrortext');
			return false;
		} else if ($wgFilterCallback && $wgFilterCallback($nt, $text, 0)) {
			$wgOut->showErrorPage('formsaveerror', 'formsaveerrortext');
			return false;
		} else if (!wfRunHooks('EditFilter', array($editPage, $text, 0, &$errortext))) {
			# Hooks usually print their own error
			return false;
		} else if ($errortext != '') {
			$wgOut->showErrorPage('formsaveerror', 'formsaveerrortext');
			return false;
		} else if ($wgUser->isBlockedFrom($nt, false)) {
			$wgOut->showErrorPage('formsaveerror', 'formsaveerrortext');
			return false;
		} else if ((int)(strlen($text) / 1024) > $wgMaxArticleSize) {
			$wgOut->showErrorPage('formsaveerror', 'formsaveerrortext');
			return false;
		} else if (!$wgUser->isAllowed('edit')) {
			$wgOut->showErrorPage('formsaveerror', 'formsaveerrortext');
			return false;
		} else if (wfReadOnly()) {
			$wgOut->showErrorPage('formsaveerror', 'formsaveerrortext');
			return false;
		} else if ($wgUser->pingLimiter()) {
			$wgOut->showErrorPage('formsaveerror', 'formsaveerrortext');
			return false;
		}

		return true;
	}
}

# Dummy class for extensions that support EditFilter hook

class FakeEditPage {

	var $mTitle;

	function FakeEditPage(&$nt) {
		$this->mTitle = $nt;
	}
}

class Form {
	var $name;
	var $title;
	var $template;
	var $instructions;
	var $fields;
	var $namePattern;

	function Form($name, $text) {

		$this->name = $name;
		$this->title = wfMsgForContent('formtitlepattern', $name);
		$this->template = array();
		$this->template[0] = wfMsgForContent('formtemplatepattern', $name);

		$this->fields = array();
		$this->namePattern = array();
		$this->instructions = NULL;

		# XXX: may be some faster ways to do this

		$lines = explode("\n", $text);

		foreach ($lines as $line) {

			if (preg_match('/^(\w+)=(.*)$/', $line, $matches)) {
				if (strcasecmp($matches[1], 'template') == 0) {
					$this->template[0] = $matches[2];
				} else if (preg_match('/template(\d+)/i', $matches[1], $tmatches)) {
					$this->template[intval($tmatches[1])] = $matches[2];
				} else if (strcasecmp($matches[1], 'namePattern') == 0) {
					$this->namePattern[0] = $matches[2];
				} else if (preg_match('/namePattern(\d+)/i', $matches[1], $tmatches)) {
					$this->namePattern[intval($tmatches[1])] = $matches[2];
				} else if (strcasecmp($matches[1], 'title') == 0) {
					$this->title = $matches[2];
				} else if (strcasecmp($matches[1], 'instructions') == 0) {
					$this->instructions = $matches[2];
					wfDebug("Got instructions: '" . $this->instructions . "'.\n");
				} else {
					wfDebug("SpecialForm: unknown form attribute '$matches[1]'; skipping.\n");
				}
			} else if (preg_match('/^(\w+)\|([^\|]+)\|(\w+)(\|([^\|]+)(\|(.*))?)?$/', $line, $matches)) {
				# XXX: build an inheritance tree for different kinds of fields
				$field = new FormField();
				$field->setName($matches[1]);
				$field->setLabel($matches[2]);
				$field->setFieldType($matches[3]);
				if (count($matches) > 4 && $matches[4]) {
					$field->setDescription($matches[5]);
					if (count($matches) > 6 && $matches[6]) {
						$rawOptions = explode(',', $matches[7]);
						foreach ($rawOptions as $rawOption) {
							if (preg_match('/^(\w+)=(.+)/', $rawOption, $optMatches)) {
								$field->setOption($optMatches[1], $optMatches[2]);
							} else {
								wfDebug("SpecialForm: unrecognized form field option: '$rawOption'; skipping.\n");
							}
						}
					}
				}
				$this->fields[$field->name] = $field;
			} else {
					wfDebug("SpecialForm: unrecognized form line: '$line'; skipping.\n");
			}
		}
	}
}

class FormField {

	var $name;
	var $type;
	var $label;
	var $description;
	var $options;

	function FormField() {
		$this->name = NULL;
		$this->type = NULL;
		$this->label = NULL;
		$this->description = NULL;
		$this->options = array();
	}

	function setName($name) {
		$this->name = $name;
	}

	function setFieldType($type) {
		$this->type = $type;
	}

	function setLabel($label) {
		$this->label = $label;
	}

	function setDescription($description) {
		$this->description = $description;
	}

	function setOption($key, $value) {
		$this->options[$key] = $value;
	}

	function getOption($key, $default = NULL) {
		if (array_key_exists($key, $this->options)) {
			return $this->options[$key];
		} else {
			return $default;
		}
	}

	function isOptionTrue($key, $default = false) {
		$value = $this->getOption($key, $default);
		return ((strcasecmp($value, 'on') == 0) ||
				(strcasecmp($value, 'yes') == 0) ||
				(strcasecmp($value, 'true') == 0) ||
				(strcasecmp($value, '1') == 0));
	}

	function render($def = NULL) {
		global $wgOut;

		switch ($this->type) {
		 case 'textarea':
			return Xml::openElement('h2') .
			  Xml::element('label', array('for' => $this->name), $this->label) .
		      Xml::closeElement('h2') .
			  (($this->description) ?
			   (Xml::openElement('div') . $wgOut->parse($this->description) . Xml::closeElement('div')) : '') .
			  Xml::openElement('textarea', array('name' => $this->name,
											  'id' => $this->name,
											  'rows' => $this->getOption('rows', 6),
											  'cols' => $this->getOption('cols', 80))) .
			  ((is_null($def)) ? '' : $def) .
			  Xml::closeElement('textarea');
			break;
		 case 'text':
			return Xml::element('label', array('for' => $this->name), $this->label) . ": " .
			  Xml::element('input', array('type' => 'text',
									   'name' => $this->name,
									   'id' => $this->name,
									   'value' => ((is_null($def)) ? '' : $def),
									   'size' => $this->getOption('size', 30)));
			break;
		 case 'checkbox':
			$attrs = array('type' => 'checkbox',
						   'name' => $this->name,
						   'id' => $this->name);
			if ($def == 'checked') {
				$attrs['checked'] = 'checked';
			}
			return Xml::element('label', array('for' => $this->name), $this->label) . ": " .
			  Xml::element('input', $attrs);
			break;
		 case 'radio':
			$items = array();
			$rawitems = explode(';', $this->getOption('items'));
			foreach ($rawitems as $item) {
				$attrs = array('type' => 'radio',
							   'name' => $this->name,
							   'value' => $item);
				if ($item == $def) {
					$attrs['checked'] = 'checked';
				}
				$items[] = Xml::openElement('input', $attrs) .
				  Xml::element('label', null, $item) .
				  Xml::closeElement('input');
			}
			return Xml::element('span', null, $this->label) . Xml::element('br') . implode("", $items);
			break;
		 case 'select':
			$items = array();
			$rawitems = explode(';', $this->getOption('items'));
			foreach ($rawitems as $item) {
				$items[] = Xml::element('option',
									 ($item == $def) ? array('selected' => 'selected') : null,
									 $item);
			}

			return Xml::element('label', array('for' => $this->name), $this->label) . ": " .
			  Xml::openElement('select', array('name' => $this->name, 'id' => $this->name)) .
			  implode("", $items) .
		      Xml::closeElement('select');

			break;
		 default:
			wfDebug("SpecialForm: unknown form field type '$this->type', skipping.\n");
			return '';
		}
	}
}
