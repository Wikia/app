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
			return $namespace . ucfirst($title->getPartialURL());
		} else {
			return $namespace . $title->getPartialURL();
		}
	}

	/**
	 * A very similar function, to get the non-URL-encoded title string
	 */
	static function titleString($title) {
		$namespace = $title->getNsText();
		if ( '' != $namespace ) {
			$namespace .= ':';
		}
		return ($namespace . ucfirst($title->getText()));
	}

	/**
	 * Gets the default form specified, if any, for a specific page
	 * (which should be a category, property, or namespace page)
	 */
	static function getDefaultForm($page_title, $page_namespace) {
		if ($page_title == NULL)
			return null;

		global $sfgContLang;
		$store = smwfGetStore();
		$title = Title::newFromText($page_title, $page_namespace);
		// we can do this easily if we're using SMW 1.4 or higher
		if (class_exists('SMWPropertyValue')) {
			$default_form_property = SMWPropertyValue::makeProperty('_SF_DF');
			$res = $store->getPropertyValues($title, $default_form_property);
			if (isset($res[0]))
				return $res[0]->getTitle()->getText();
			else
				return null;
		}

		// otherwise, it's a bit more complex
		$sf_props = $sfgContLang->getPropertyLabels();
		$default_form_property = str_replace(' ', '_', $sf_props[SF_SP_HAS_DEFAULT_FORM]);
		$property = SFUtils::createProperty($default_form_property);
		$res = $store->getPropertyValues($title, $property);
		if (isset($res[0]) && ($res[0] instanceof SMWWikiPageValue || $res[0] instanceof Title)) {
			// make sure it's in the form namespace
			if ($res[0]->getNamespace() == SF_NS_FORM) {
				$form_name = $res[0]->getTitle()->getText();
				return $form_name;
			}
		}
		// if that didn't work, try any aliases that may exist
		// for SF_SP_HAS_DEFAULT_FORM
		$sf_props_aliases = $sfgContLang->getPropertyAliases();
		foreach ($sf_props_aliases as $alias => $prop_code) {
			if ($prop_code == SF_SP_HAS_DEFAULT_FORM) {
				$property = SFUtils::createProperty($alias);
				$res = $store->getPropertyValues($title, $property);
				if (isset($res[0]) && ($res[0] instanceof SMWWikiPageValue || $res[0] instanceof Title)) {
					// make sure it's in the form namespace
					if ($res[0]->getNamespace() == SF_NS_FORM) {
						$form_name = $res[0]->getTitle()->getText();
						return $form_name;
					}
				}
			}
		}
		return null;
	}

	/**
	 * Gets the alternate forms specified, if any, for a specific page
	 * (which should always be a property page)
	 */
	static function getAlternateForms($page_title, $page_namespace) {
		if ($page_title == NULL)
			return array();

		global $sfgContLang;
		$store = smwfGetStore();
		$title = Title::newFromText($page_title, $page_namespace);
		// we can do this easily if we're using SMW 1.4 or higher
		if (class_exists('SMWPropertyValue')) {
			$alternate_form_property = SMWPropertyValue::makeProperty('_SF_AF');
			$res = $store->getPropertyValues($title, $alternate_form_property);
			// there could be multiple alternate forms
			$form_names = array();
			foreach ($res as $wiki_page_value) {
				$form_names[] = $wiki_page_value->getTitle()->getText();
			}
			return $form_names;
		}

		// otherwise, it's a bit more complex
		$sf_props = $sfgContLang->getPropertyLabels();
		$alternate_form_property = str_replace(' ', '_', $sf_props[SF_SP_HAS_ALTERNATE_FORM]);
		$property = SFUtils::createProperty($alternate_form_property);
		$prop_vals = $store->getPropertyValues($title, $property);
		$form_names = array();
		foreach ($prop_vals as $prop_val) {
			// make sure it's in the form namespace
			if (($prop_val instanceof SMWWikiPageValue || $prop_val instanceof Title) &&
				$prop_val->getNamespace() == SF_NS_FORM) {
				$form_names[] = str_replace(' ', '_', $prop_val->getTitle()->getText());
			}
		}
		// try the English version too, if this isn't in English
		if ($alternate_form_property != "Has_alternate_form") {
			$property = SFUtils::createProperty("Has_alternate_form");
			$prop_vals = $store->getPropertyValues($title, $property);
			foreach ($prop_vals as $prop_val) {
				if (($prop_val instanceof SMWWikiPageValue || $prop_val instanceof Title)
					&& $prop_val->getNamespace() == SF_NS_FORM) {
					$form_names[] = str_replace(' ', '_', $prop_val->getTitle()->getText());
				}
			}
		}
		return $form_names;
	}

	/**
	 * Helper function for addDataLink() - gets the 'default form' and
	 * 'alternate form' properties for a page, and creates the
	 * corresponding 'add data' link, if any such properties are defined
	 */
	static function getAddDataLinkForPage($target_page_title, $page_title, $page_namespace) {
		$form_name = SFLinkUtils::getDefaultForm($page_title, $page_namespace);
		$alt_forms = SFLinkUtils::getAlternateForms($page_title, $page_namespace);
		if (! $form_name && count($alt_forms) == 0)
			return null;
		$ad = SpecialPage::getPage('AddData');
		if ($form_name)
			$add_data_url = $ad->getTitle()->getLocalURL() . "/" . $form_name . "/" . SFLinkUtils::titleURLString($target_page_title);
		else
			$add_data_url = $ad->getTitle()->getLocalURL() . "/" . SFLinkUtils::titleURLString($target_page_title);
		foreach ($alt_forms as $i => $alt_form) {
			$add_data_url .= (strpos($add_data_url, "?")) ? "&" : "?";
			$add_data_url .= "alt_form[$i]=$alt_form";
		}
		return $add_data_url;
	}

	/**
	 * Sets the URL for form-based adding of a nonexistent (broken-linked,
	 * AKA red-linked) page
	 */
	static function setBrokenLink_1_13(&$linker, $title, $query, &$u, &$style, &$prefix, &$text, &$inside, &$trail) {
		$link = SFLinkUtils::addDataLink($title);
		if ($link != '')
			$u = $link;
		return true;
	}

	/**
	 * Sets the URL for form-based adding of a nonexistent (broken-linked,
	 * AKA red-linked) page
	 */
	static function setBrokenLink($linker, $target, $options, $text, &$attribs, &$ret) {
		if (in_array('broken', $options)) {
			$link = SFLinkUtils::addDataLink($target);
			if ($link != '') {
				$attribs['href'] = $link;
			}
		}
		return true;
	}

	static function addDataLink($title) {
		// get all properties pointing to this page, and if
		// getAddDataLinkForPage() returns a value with any of
		// them, return that
		$store = smwfGetStore();
		$title_text = SFLinkUtils::titleString($title);
		$value = SMWDataValueFactory::newTypeIDValue('_wpg', $title_text);
		$incoming_properties = $store->getInProperties($value);
		foreach ($incoming_properties as $property) {
			$property_title = SFUtils::getPropertyName($property);
			if ($add_data_link = SFLinkUtils::getAddDataLinkForPage($title, $property_title, SMW_NS_PROPERTY)) {
				return $add_data_link;
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
		if ($add_data_link = SFLinkUtils::getAddDataLinkForPage($title, $namespace, NS_PROJECT)) {
			return $add_data_link;
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
		$fname = 'getCategoriesForArticle()';
		$categories = array();
		$db = wfGetDB( DB_SLAVE );
		$conditions = null;
		if ($article != NULL) {
			$titlekey = $article->mTitle->getArticleId();
			$conditions = "cl_from='$titlekey'";
		}
		$res = $db->select( $db->tableName('categorylinks'),
			'distinct cl_to', $conditions, $fname);
		if ($db->numRows( $res ) > 0) {
			while ($row = $db->fetchRow($res)) {
				$categories[] = $row[0];
			}
		}
		$db->freeResult($res);
		return $categories;
	}

	/**
	 * Get the form used to edit this article: either the default form for
	 * a category that this article belongs to (if there is one), or the
	 * default form for the article's namespace, if there is one
	 */
	static function getFormForArticle($obj) {
		$categories = SFLinkUtils::getCategoriesForArticle($obj);
		foreach ($categories as $category) {
			if ($form_name = SFLinkUtils::getDefaultForm($category, NS_CATEGORY)) {
				return $form_name;
			}
		}
		// if we're still here, just return the default form for the
		// namespace, which may well be null
		$namespace = $obj->mTitle->getNsText();
		if ('' === $namespace) {
			// if it's in the main (blank) namespace, check for the
			// file named with the word for "Main" in this language
			wfLoadExtensionMessages('SemanticForms');
			$namespace = wfMsgForContent('sf_blank_namespace');
		}
		return SFLinkUtils::getDefaultForm($namespace, NS_PROJECT);
	}

}
