<?php

/**
 * This abstract class extends SpecialPage providing helper methods to render, validate and handle create form for Recipes Wikis
 */

abstract class RecipesTemplate extends SpecialPage {

	// stores list of fields of recipes template
	protected $mFields = array();

	// whether posted form is valid
	private $mValidated = null;

	// action to be performed when POSTed: submit/preview
	private $mAction = null;

	// page preview
	private $mPreview = null;

	// error message shown above create form
	private $mErrorMessage = null;

	// create forms toggles
	private $mToggles = array();

	public function __construct( $name = '', $restriction = '', $listed = true, $function = false, $file = 'default', $includable = false ) {
		wfLoadExtensionMessages('RecipesTemplate');

		$this->mToggles = self::getToggles();

		parent::__construct( $name, $restriction, $listed, $function, $file, $includable );
	}

	/**
	 * Get wikitext for create form
	 */
	abstract protected function getWikitext();

	/**
	 * Format given title to follow specs of create form
	 */
	abstract public function formatPageTitle($title);

	/**
	 * Get edit summary of given create form
	 */
	abstract protected function getEditSummary();

	/**
	 * Return whether form data is valid
	 */
	protected function isFormValidated() {
		return $this->mValidated !== false;
	}

	/**
	 * Get list of available form types
	 */
	static function getToggles() {
		$aToggles = array();

		$togglesRaw = explode( "\n", wfMsgForContent( 'recipes-template-toggles' ) );

		foreach ( $togglesRaw as $item ) {
			$item = trim( $item, '* ' );
			$a = explode( '|', $item );

			$toggle = array(
				'name' => $a[0],
				'specialPage' => $a[1],
			);

			if ( !empty( $a[2] ) ) {
				$toggle['type'] = $a[2];
			}

			$aToggles[] = $toggle;
		}

		return $aToggles;
	}

	/**
	 * Get list of create form fields
	 */
	protected function getFields() {
		$fields = array();

		foreach($this->mFields as $name => $field) {
			if (!is_numeric($name)) {
				$fields[] = $name;
			}
		}

		return $fields;
	}

	/**
	 * Get value of given field
	 */
	protected function getValue($field) {
		return isset($this->mFields[$field]['value']) ? $this->mFields[$field]['value'] : null;
	}

	/**
	 * Get formatted value of given field (to be used in wikitext)
	 */
	protected function getFormattedValue($field) {
		return isset($this->mFields[$field]['formattedValue']) ? $this->mFields[$field]['formattedValue'] : null;
	}

	/**
	 * Set an error message for given field
	 */
	protected function setErrorMsg($field, $msg) {
		$this->mFields[$field]['error_msg'] = $msg;
		$this->mFields[$field]['error'] = true;

		$this->mValidated = false;

		self::log(__METHOD__, "setting an error message for '{$field}'");
	}

	/**
	 * Create new article
	 *
	 * When successful returns title object of created article. If not, returns EditPage error code
	 */
	protected function createArticle($title, $content, $summary) {
		global $wgUser;
		wfProfileIn(__METHOD__);

		self::log(__METHOD__, "creating article '{$title}'");
		//self::log(__METHOD__, array($title, $content, $summary));

		$ret = false;

		// title object for new article
		$newTitle = Title::newFromText($title);

		if (!empty($newTitle) && !empty($wgUser) && $newTitle->userCan('edit') && !$wgUser->isBlocked()) {
			$article = new Article($newTitle);
			$editPage = new EditPage($article);

			$editPage->edittime = $article->getTimestamp();
			$editPage->textbox1 = $content;
			$editPage->summary = $summary;

			$result = null;
			$bot = $wgUser->isAllowed('bot');

			// do edit
			$ret = $editPage->internalAttemptSave($result, $bot);

			// creating new article
			if ($ret == EditPage::AS_SUCCESS_NEW_ARTICLE) {
				// edit successful
				$newTitle->invalidateCache();
				Article::onArticleEdit($newTitle);

				self::log(__METHOD__, 'success!');

				$ret = $newTitle;
			}
			elseif ($ret == EditPage::AS_SPAM_ERROR) {
				self::log(__METHOD__, 'spam found!');
			}
			else {
				self::log(__METHOD__, 'edit aborted');
			}
		}
		else {
			self::log(__METHOD__, 'user not allowed to edit');

			$ret = EditPage::AS_USER_CANNOT_EDIT;
		}

		if (is_numeric($ret)) {
			self::log(__METHOD__, "failed with error code #{$ret}");
		}

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Handle POST requests (set fields value, render preview, detect saves)
	 */
	protected function handlePost() {
		global $wgRequest;
		wfProfileIn(__METHOD__);

		// detect POST requests
		if (!$wgRequest->wasPosted()) {
			wfProfileOut(__METHOD__);
			return;
		}

		$this->mValidated = true;

		// are we doing submit or preview?
		$this->mAction = $wgRequest->getVal('wpPreview') ? 'preview' : 'submit';

		self::log(__METHOD__, "action = {$this->mAction}");

		// get values of form fields and validate them
		foreach($this->mFields as $id => $field) {
			// ignore headings
			if (is_numeric($id)) {
				continue;
			}

			// value to be stored in mFields array
			$value = false;

			// value to be used in wikitext
			$formattedValue = isset($field['default']) ? $field['default'] : false;

			// validate and parse each value
			switch($field['type']) {
				case 'input':
				case 'textarea':
					$val = trim($wgRequest->getText($id));

					if ($val != '') {
						$value = $val;
						$formattedValue = $val;

						// replace single line breaks with double line breaks
						$formattedValue = preg_replace("#([^\n])\n([^\n])#", "\$1\n\n\$2", $formattedValue);
					}
					break;

				case 'upload':
					$val = trim($wgRequest->getVal($id));

					if ($val != '') {
						$value = array(
							'name' => $val,
							'thumb' => self::makeThumb($val),
						);
						$formattedValue = $val;
					}
					break;

				case 'time':
					// get hours and minutes
					$hours = $wgRequest->getInt("$id-hours");
					$minutes = $wgRequest->getInt("$id-minutes");

					// validate minutes
					// 1h 75m -> 2h 15m
					if ($minutes > 59) {
						$hours += floor($minutes / 60);
						$minutes = $minutes % 60;
					}

					$value = array(
						'hours' => $hours,
						'minutes' => $minutes,
					);

					// format time as x hour(s), X minute(s)
					// 45 minutes / 1 hour, 15 minutes / 3 hours
					if ($minutes > 0 || $hours > 0) {
						$formattedValue = trim(wfMsgExt('recipes-template-time-format', array('parsemag'), $hours, $minutes), ', ');
					}

				case 'multifield':
					$vals = $wgRequest->getArray($id);

					if (!empty($vals)) {
						// check for array with empty elements
						$tmp = array_filter($vals);

						if (!empty($tmp)) {
							$value = $vals;

							// format as bulleted list
							$formattedValue = '* ' . rtrim(implode("\n* ", $vals), "\n* ");
						}
					}
					break;

				case 'multiselect':
					$postVals = $wgRequest->getArray($id);
					$otherVals = $wgRequest->getArray("{$id}Other");
					$values = self::parseCategoryChooserMessage($field['values']);

					// select values
					$n = 0;
					foreach ($values as $key => $val) {
						// category selected
						$selected = $postVals[$n];

						$valueIsEmpty = true;

						// -1: no value selected
						// 0...x: value from dropdown selected
						// other: custom value used
						if (is_numeric($selected) && $selected > -1) {
							$values[$key][$selected]['selected'] = true;
							$valueIsEmpty = false;

						}
						else if ($selected == 'other') {
							$values[$key]['other'] = array(
								'selected' => true,
								'value' => $otherVals[$n],
							);
							$valueIsEmpty = ($otherVals[$n] == '');
						}

						// generate categories wikitext
						if (!$valueIsEmpty) {
							$formattedValue .= "[[Category:{$values[$key][$selected]['value']}]] ";
						}

						// first category is required
						if (($n == 0) && isset($field['required']) && $valueIsEmpty) {
							// required field is empty
							$this->setErrorMsg($id, wfMsg('recipes-template-error-field-required'));
							self::log(__METHOD__, "required field '{$id}' is empty");
						}

						$n++;
					}

					// remove spaces from formatted list of categories
					$formattedValue = trim($formattedValue);

					// pass value to template
					$value = $values;
					break;
			}

			if ($value !== false) {
				// store parser value
				$this->mFields[$id]['value'] = $value;
			}
			else if (!empty($field['required'])) {
				// required field is empty
				$this->setErrorMsg($id, wfMsg('recipes-template-error-field-required'));

				self::log(__METHOD__, "required field '{$id}' is empty");
			}

			if ($formattedValue !== false) {
				$this->mFields[$id]['formattedValue'] = $formattedValue;
			}
		}

		// perform title check (maybe this page already exists?)
		$title = $this->formatPageTitle($this->getValue('wpTitle'));
		if ($title != '') {
			$newTitle = Title::newFromText($title);

			if (!empty($newTitle) && $newTitle->exists()) {
				$msg = wfMsgExt('recipes-template-error-title-exists', array('parseinline'), $title);
				$this->setErrorMsg('wpTitle', $msg);

				self::log(__METHOD__, "page '{$title}' already exists");
			}
		}

		// submit form if it's valid
		if ($this->isFormValidated()) {
			if ($this->mAction == 'submit') {
				self::log(__METHOD__, 'form validated - submitting...');

				$this->submitForm();
			}
		}
		else {
			self::log(__METHOD__, 'form not validated!');
		}

		// render preview
		if ($this->mAction == 'preview') {
			self::log(__METHOD__, 'rendering preview...');
			$this->renderPreview();
		}

		/**
		global $wgOut;
		$wgOut->addHtml('<pre>' . print_r($this->mFields, true) . '</pre>');
		/**/

		wfProfileOut(__METHOD__);
	}

	/**
	 * Handle validated form submit
	 */
	private function submitForm() {
		global $wgOut;
		wfProfileIn(__METHOD__);

		// get form data
		$title = $this->formatPageTitle($this->getValue('wpTitle'));
		$content = $this->formatWikitext($this->getWikitext());
		$summary = $this->getEditSummary();

		// try to create an article
		$ret = $this->createArticle($title, $content, $summary);

		if (is_object($ret)) {
			// redirect to created recipe / ingredient page
			self::log(__METHOD__, 'article created - redirecting...');

			$wgOut->redirect($ret->getFullURL());
		}
		else {
			// show error message
			$this->mErrorMessage = wfMsg('recipes-template-error-article-creation', $ret);
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * Return HTML of current recipes form
	 */
	protected function renderForm() {
		global $wgOut, $wgStylePath, $wgExtensionsPath, $wgStyleVersion, $wgJsMimeType, $wgTitle, $wgUser;
		wfProfileIn(__METHOD__);

		// load dependencies (CSS and JS)
		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/RecipesTemplate/RecipesTemplate.css?{$wgStyleVersion}");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/RecipesTemplate/RecipesTemplate.js?{$wgStyleVersion}\"></script>\n");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgStylePath}/common/jquery/jquery.autocomplete.js?{$wgStyleVersion}\"></script>\n");

		// create form type: recipe / ingredient
		$formType = strtolower(substr($wgTitle->getText(), 6));

		// is current user admin or staff?
		$userGroups = $wgUser->getGroups();
		$isAdmin = in_array('admin', $userGroups) || in_array('staff', $userGroups);

		// where admins can go to edit the categories
		$editTitle = Title::newFromDBkey('MediaWiki:Recipe-menus');
		$editCategoriesLink = $editTitle->getLinkUrl();

		// render recipes form
		$tpl = new EasyTemplate(dirname(__FILE__).'/templates');
                $tpl->set_vars(array(
			'errorMessage' => $this->mErrorMessage,
			'fields' => $this->mFields,
			'formAction' => $wgTitle->getLocalUrl(),
			'formType' => $formType,
			'isAdmin' => $isAdmin,
			'isValid' => $this->isFormValidated(),
			'messages' => array(
				'bold_tip' => wfMsg('bold_tip'),
				'italic_tip' => wfMsg('italic_tip'),
				'link_tip' => wfMsg('link_tip'),
			),
			'preview' => $this->mPreview,
			'toggles' => $this->mToggles,
			'type' => $this->mType,
			'editCategoriesLink' => $editCategoriesLink,
			'editCategoriesMsg' => wfMsg('recipes-template-edit-categories')
		));
		$html = $tpl->render('renderForm');

		$wgOut->addHtml($html);

		wfProfileOut(__METHOD__);
	}

	/**
	 * Return HTML of create forms toggle
	 */
	protected static function renderToggle() {
		global $wgOut, $wgExtensionsPath, $wgStyleVersion;
		wfProfileIn(__METHOD__);

		// load dependencies (CSS)
                $wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/RecipesTemplate/RecipesTemplate.css?{$wgStyleVersion}");

		// render toggle
		$tpl = new EasyTemplate(dirname(__FILE__).'/templates');
		$tpl->set_vars(array(
			'toggles' => self::getToggles(),
		));
		$html = $tpl->render('toggleForms');

		$wgOut->addHtml($html);

		wfProfileOut(__METHOD__);
	}

	/**
	 * Render preview based on form data
	 */
	protected function renderPreview() {
		global $wgParser, $wgTitle, $wgUser;
		wfProfileIn(__METHOD__);

		// prepare wikitext
		$wikitext = $this->getWikitext();
		$wikitext = $this->formatWikitext($wikitext);

		// don't show TOC
		$wikitext = "__NOTOC__\n{$wikitext}";

		$parserOptions = ParserOptions::newFromUser($wgUser);

		$this->mPreview = $wgParser->parse($wikitext, $wgTitle, $parserOptions)->getText();

		wfProfileOut(__METHOD__);
	}

	/**
	 * Replace <<foo>> placeholders with values from create form fields
	 */
	protected function formatWikitext($wikitext) {
		wfProfileIn(__METHOD__);

		$fields = $this->getFields();

		foreach($fields as $fieldName) {
			$value = $this->getFormattedValue($fieldName);
			$wikitext = str_replace("<<{$fieldName}>>", $value, $wikitext);
		}

		wfProfileOut(__METHOD__);
		return $wikitext;
	}

	/**
	 * Parse given message with category chooser content
	 */
	static public function parseCategoryChooserMessage($messageName) {
		wfProfileIn(__METHOD__);
		$ret = array();

		$lines = explode("\n", wfMsg($messageName));

		foreach ($lines as $line) {
			if (strlen($line) == 0) // ignore empty lines
				continue;
			if (strpos($line, '*') !== 0)
				continue;
			if (strpos($line, '**') !== 0) {
				$line = trim($line, '* ');
				$heading = $line;
			}
			else {
				if (isset($heading)) {
					$ret[$heading][] = array('value' => trim($line, '* '));
				}
			}
		}

		wfProfileOut(__METHOD__);
		return $ret;
	}

	function execute($par) {
		wfProfileIn(__METHOD__);
		global $wgOut, $wgUser, $wgTitle;
		$this->setHeaders();

		// perform initial checks
		if ($wgUser->isBlocked()) {
			$wgOut->blockedPage();

			self::log(__METHOD__, 'user is blocked');
			wfProfileOut(__METHOD__);
			return;
		}

		if (wfReadOnly()) {
			$wgOut->readOnlyPage();

			self::log(__METHOD__, 'site is in read-only state');
			wfProfileOut(__METHOD__);
			return;
		}

		if (!$wgUser->isAllowed('edit')) {
			// create fake EditPage
			$editPage = new EditPage(new Article($wgTitle));
			$editPage->userNotLoggedInPage();

			self::log(__METHOD__, 'user is not allowed to edit');
			wfProfileOut(__METHOD__);
			return;
		}

		// handle form submit
		$this->handlePost();

		// render recipes form
		$this->renderForm();

		wfProfileOut(__METHOD__);
	}

	/**
	 * Show create forms toggle when on Special:CreatePage
	 */
	public static function showCreatePageToggle(&$editPage) {
		global $wgTitle, $wgOut;
		wfProfileIn(__METHOD__);

		if (!empty($wgTitle) && ($wgTitle->getText() == 'CreatePage') && ($wgTitle->getNamespace() == NS_SPECIAL)) {
			wfLoadExtensionMessages('RecipesTemplate');
			RecipesTemplate::renderToggle();
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Return URL to thumbnail (to fit 250x200 box) of given image
	 */
	public static function makeThumb($imageName) {
		wfProfileIn(__METHOD__);

		$maxWidth = 250;
		$maxHeight = 200;

		$title = Title::newFromText($imageName, NS_FILE);
		$image = wfFindFile($title);

		if (empty($image)) {
			wfProfileOut(__METHOD__);
			return false;
		}

		// get original dimensions of an image
		$width = $image->getWidth();
		$height = $image->getHeight();

		// don't try to make image larger
		if ($width > $maxWidth or $height > $maxHeight) {
			$width = $maxWidth;
			$height = $maxHeight;
		}

		// generate thumbnail
		$thumb = $image->getThumbnail($width, $height);
		$ret = $thumb->url;

		self::log(__METHOD__, "{$imageName} -> {$ret}");

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Add given message / dump given variable to MW log
	 *
	 * @author Macbre
	 */
	public static function log($method, $msg) {
		wfDebug("{$method}: {$msg}\n");
	}
}
