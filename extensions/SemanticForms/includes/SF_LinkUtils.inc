<?php
/**
 * Helper functions for linking to pages and forms
 *
 * @author Yaron Koren
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

class SFLinkUtils {

	static function linkText($namespace, $name, $text = NULL) {
		global $wgContLang;

		$inText = $wgContLang->getNsText($namespace) . ':' . $name;
		$title = Title::newFromText( $inText );
		if ($title === NULL) {
			return $inText; // TODO maybe report an error here?
		}
		if ( NULL === $text ) $text = $title->getText();
		$l = new Linker();
		return $l->makeLinkObj($title, $text);
	}

	/**
	 * Creates the name of the page that appears in the URL;
	 * this method is necessary because Title::getPartialURL(), for
	 * some reason, doesn't include the namespace
	 */
	static function titleURLString($title) {
		global $wgCapitalLinks;

		$namespace = wfUrlencode( $title->getNsText() );
		if ( '' != $namespace ) {
			$namespace .= ':';
		}
		if ($wgCapitalLinks) {
			global $wgContLang;
			return $namespace . $wgContLang->ucfirst($title->getPartialURL());
		} else {
			return $namespace . $title->getPartialURL();
		}
	}

	/**
	 * A very similar function to titleURLString(), to get the
	 * non-URL-encoded title string
	 */
	static function titleString($title) {
		global $wgCapitalLinks;

		$namespace = $title->getNsText();
		if ( '' != $namespace ) {
			$namespace .= ':';
		}
		if ($wgCapitalLinks) {
			global $wgContLang;
			return $namespace . $wgContLang->ucfirst($title->getText());
		} else {
			return $namespace . $title->getText();
		}
	}

	/**
	 * Gets the forms specified, if any, of either type "default form",
	 * "alternate form", or "default form for page", for a specific page
	 * (which should be a category, property, or namespace page)
	 */
	static function getFormsThatPagePointsTo($page_name, $page_namespace, $prop_smw_id, $backup_prop_smw_id, $prop_id) {
		if ($page_name == NULL)
			return array();

		global $sfgContLang;
		// produce a useful error message if SMW isn't installed
		if (! function_exists('smwfGetStore'))
			die("ERROR: <a href=\"http://semantic-mediawiki.org\">Semantic MediaWiki</a> must be installed for Semantic Forms to run!");
		$store = smwfGetStore();
		$title = Title::makeTitleSafe($page_namespace, $page_name);
		$property = SMWPropertyValue::makeProperty($prop_smw_id);
		$res = $store->getPropertyValues($title, $property);
		$form_names = array();
		foreach ($res as $wiki_page_value)
			$form_names[] = $wiki_page_value->getTitle()->getText();
		// if we're using a non-English language, check for the English string as well
		if (! class_exists('SF_LanguageEn') || ! $sfgContLang instanceof SF_LanguageEn) {
			$backup_property = SMWPropertyValue::makeProperty($backup_prop_smw_id);
			$res = $store->getPropertyValues($title, $backup_property);
			foreach ($res as $wiki_page_value)
				$form_names[] = $wiki_page_value->getTitle()->getText();
		}
		return $form_names;
	}

	/**
	 * Helper function for formEditLink() - gets the 'default form' and
	 * 'alternate form' properties for a page, and creates the
	 * corresponding Special:FormEdit link, if any such properties are
	 * defined
	 */
	static function getFormEditLinkForPage($target_page_title, $page_name, $page_namespace) {
		$default_forms = self::getFormsThatPagePointsTo($page_name, $page_namespace, '_SF_DF', '_SF_DF_BACKUP', SF_SP_HAS_DEFAULT_FORM);
		$alt_forms = self::getFormsThatPagePointsTo($page_name, $page_namespace, '_SF_AF', '_SF_AF_BACKUP', SF_SP_HAS_ALTERNATE_FORM);
		if ((count($default_forms) == 0) && (count($alt_forms) == 0))
			return null;
		$fe = SpecialPage::getPage('FormEdit');
		$fe_url = $fe->getTitle()->getLocalURL();
		if (count($default_forms) > 0)
			$form_edit_url = $fe_url . "/" . $default_forms[0] . "/" . self::titleURLString($target_page_title);
		else
			$form_edit_url = $fe_url . "/" . self::titleURLString($target_page_title);
		foreach ($alt_forms as $i => $alt_form) {
			$form_edit_url .= (strpos($form_edit_url, "?")) ? "&" : "?";
			$form_edit_url .= "alt_form[$i]=$alt_form";
		}
		return $form_edit_url;
	}

	/**
	 * Sets the URL for form-based creation of a nonexistent (broken-linked,
	 * AKA red-linked) page, for MediaWiki 1.13
	 */
	static function setBrokenLink_1_13(&$linker, $title, $query, &$u, &$style, &$prefix, &$text, &$inside, &$trail) {
		if (self::createLinkedPage($title)) {
			return true;
		}
		$link = self::formEditLink($title);
		if ($link != '')
			$u = $link;
		return true;
	}

	/**
	 * Sets the URL for form-based creation of a nonexistent (broken-linked,
	 * AKA red-linked) page
	 */
	static function setBrokenLink($linker, $target, $options, $text, &$attribs, &$ret) {
		if (in_array('broken', $options)) {
			if (self::createLinkedPage($target)) {
				return true;
			}
			$link = self::formEditLink($target);
			if ($link != '') {
				$attribs['href'] = $link;
			}
		}
		return true;
	}

	/**
	 * Automatically creates a page that's red-linked from the page being
	 * viewed, if there's a property pointing from anywhere to that page
	 * that's defined with the 'Creates pages with form' special property
	 */
	static function createLinkedPage($title) {
		// if we're in a 'special' page, just exit - this is to prevent
		// constant additions being made from the 'Special:RecentChanges'
		// page, which shows pages that were previously deleted as red
		// links, even if they've since been recreated. The same might
		// hold true for other special pages.
		global $wgTitle;
		if ($wgTitle->getNamespace() == NS_SPECIAL)
			return false;

		$store = smwfGetStore();
		$title_text = self::titleString($title);
		$value = SMWDataValueFactory::newTypeIDValue('_wpg', $title_text);
		$incoming_properties = $store->getInProperties($value);
		foreach ($incoming_properties as $property) {
			$property_name = $property->getWikiValue();
			if (empty($property_name)) continue;
			$property_title = Title::makeTitleSafe(SMW_NS_PROPERTY, $property_name);
			$auto_create_forms = self::getFormsThatPagePointsTo($property_name, SMW_NS_PROPERTY, '_SF_CP', '_SF_CP_BACKUP', SF_SP_CREATES_PAGES_WITH_FORM);
			if (count($auto_create_forms) > 0) {
				global $sfgFormPrinter;
				$form_name = $auto_create_forms[0];
				$form_title = Title::makeTitleSafe(SF_NS_FORM, $form_name);
				$form_article = new Article($form_title);
				$form_definition = $form_article->getContent();
				list ($form_text, $javascript_text, $data_text, $form_page_title, $generated_page_name) =
					$sfgFormPrinter->formHTML($form_definition, false, false, null, null, 'Some very long page name that will hopefully never get created ABCDEF123', null);
				$params = array();
				global $wgUser;
				$params['user_id'] = $wgUser->getId();
				$params['page_text'] = $data_text;
				$job = new SFCreatePageJob( $title, $params );
				Job::batchInsert( array($job) );

				return true;
			}
		}

		return false;
	}

	/**
	 * Returns the URL for the Special:FormEdit page for a specific page,
	 * given its default and alternate form(s) - we can't just point to
	 * '&action=formedit', because that one doesn't reflect alternate forms
	 */
	static function formEditLink($title) {
		// get all properties pointing to this page, and if
		// getFormEditLinkForPage() returns a value with any of
		// them, return that

		// produce a useful error message if SMW isn't installed
		if (! function_exists('smwfGetStore'))
			die("ERROR: <a href=\"http://semantic-mediawiki.org\">Semantic MediaWiki</a> must be installed for Semantic Forms to run!");
		$store = smwfGetStore();
		$title_text = self::titleString($title);
		$value = SMWDataValueFactory::newTypeIDValue('_wpg', $title_text);
		$incoming_properties = $store->getInProperties($value);
		foreach ($incoming_properties as $property) {
			$property_title = $property->getWikiValue();
			if ($form_edit_link = self::getFormEditLinkForPage($title, $property_title, SMW_NS_PROPERTY)) {
				return $form_edit_link;
			}
		}

		// if that didn't work, check if this page's namespace
		// has a default form specified
		$namespace = $title->getNsText();
		if ('' === $namespace) {
			// if it's in the main (blank) namespace, check for the
			// file named with the word for "Main" in this language
			wfLoadExtensionMessages('SemanticForms');
			$namespace = wfMsgForContent('sf_blank_namespace');
		}
		if ($form_edit_link = self::getFormEditLinkForPage($title, $namespace, NS_PROJECT)) {
			return $form_edit_link;
		}
		// if nothing found still, return null
		return null;
	}

	/**
	 * Helper function - gets names of categories for a page;
	 * based on Title::getParentCategories(), but simpler
	 * - this function doubles as a function to get all categories on
	 * the site, if no article is specified
	 */
	static function getCategoriesForArticle($article = NULL) {
		$categories = array();
		$db = wfGetDB( DB_SLAVE );
		$conditions = null;
		if ($article != NULL) {
			$titlekey = $article->mTitle->getArticleId();
			$conditions = "cl_from='$titlekey'";
		}
		$res = $db->select($db->tableName('categorylinks'),
			'distinct cl_to', $conditions, __METHOD__);
		if ($db->numRows( $res ) > 0) {
			while ($row = $db->fetchRow($res)) {
				$categories[] = $row[0];
			}
		}
		$db->freeResult($res);
		return $categories;
	}

	/**
	 * Get the form used to edit this article - either:
	 * - the default form the page itself, if there is one; or
	 * - the default form for a category that this article belongs to,
	 * if there is one; or
	 * - the default form for the article's namespace, if there is one
	 */
	static function getFormsForArticle($obj) {
		// see if the page itself has a default form (or forms), and
		// return it/them if so
		$default_forms = self::getFormsThatPagePointsTo($obj->mTitle->getText(), $obj->mTitle->getNamespace(), '_SF_PDF', '_SF_PDF_BACKUP', SF_SP_PAGE_HAS_DEFAULT_FORM);
		if (count($default_forms) > 0)
			return $default_forms;
		// if this is not a category page, look for a default form
		// for its parent categories
		$namespace = $obj->mTitle->getNamespace();
		if (NS_CATEGORY !== $namespace) {
			$default_forms = array();
			$categories = self::getCategoriesForArticle($obj);
			foreach ($categories as $category) {
				$default_forms = array_merge($default_forms, self::getFormsThatPagePointsTo($category, NS_CATEGORY, '_SF_DF', '_SF_DF_BACKUP', SF_SP_HAS_DEFAULT_FORM));
			}
			if (count($default_forms) > 0)
				return $default_forms;
		}
		// if we're still here, just return the default form for the
		// namespace, which may well be null
		if (NS_MAIN === $namespace) {
			// if it's in the main (blank) namespace, check for the
			// file named with the word for "Main" in this language
			wfLoadExtensionMessages('SemanticForms');
			$namespace_label = wfMsgForContent('sf_blank_namespace');
		} else {
			global $wgContLang;
			$namespace_labels = $wgContLang->getNamespaces();
			$namespace_label = $namespace_labels[$namespace];
		}
		$default_forms = self::getFormsThatPagePointsTo($namespace_label, NS_PROJECT, '_SF_DF', '_SF_DF_BACKUP', SF_SP_HAS_DEFAULT_FORM);
		return $default_forms;
	}

}
