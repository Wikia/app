<?php
/**
 * Gets the form(s) used to edit a page, both for existing pages and for
 * not-yet-created, red-linked pages. This class uses its own in-memory
 * caching to try to minimize the number of calls to the Semantic
 * MediaWiki data store.
 *
 * @author Yaron Koren
 * @file
 * @ingroup SF
 */

class SFFormLinker {
	const DEFAULT_FORM = 1;
	const ALTERNATE_FORM = 2;
	const PAGE_DEFAULT_FORM = 3;
	const AUTO_CREATE_FORM = 4;

	// An in-memory cache of data already retrieved for the current page.
	static $mLinkedForms = array();
	static $mLinkedPages = array();
	static $mLinkedPagesRetrieved = false;

	static function getDefaultForm( $title ) {
		// The title passed in can be null in at least one
		// situation: if the "namespace page" is being checked, and
		// the project namespace alias contains any non-ASCII
		// characters. There may be other cases too.
		// If that happens, just exit.
		if ( is_null( $title ) ) {
			return null;
		}

		$pageID = $title->getArticleID();
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'page_props',
			array(
				'pp_value'
			),
			array(
				'pp_page' => $pageID,
				'pp_propname' => 'SFDefaultForm'
			)
		);

		if ( $row = $dbr->fetchRow( $res ) ) {
			return $row['pp_value'];
		}
	}

	/**
	 * Gets the set of all properties that point to this page, anywhere
	 * in the wiki.
	 */
	static function getIncomingProperties( $title ) {
		$store = SFUtils::getSMWStore();
		if ( is_null( $store ) ) {
			return array();
		}
		$value = SMWDIWikiPage::newFromTitle( $title );
		$properties = $store->getInProperties( $value );
		$propertyNames = array();
		foreach ( $properties as $property ) {
			$property_name = $property->getKey();
			if ( !empty( $property_name ) ) {
				$propertyNames[] = $property_name;
			}
		}
		return $propertyNames;
	}

	/**
	 * Gets the properties pointing from the current page to this one.
	 */
	static function getPagePropertiesOfPage( $title ) {
		if ( self::$mLinkedPagesRetrieved ) {
			return;
		}

		$store = SFUtils::getSMWStore();
		if ( $store == null ) {
			self::$mLinkedPagesRetrieved = true;
			return;
		}
		if ( class_exists( 'SMWDataItem' ) ) {
			$value = SMWDIWikiPage::newFromTitle( $title );
		} else {
			$value = $title;
		}
		$data = $store->getSemanticData( $value );
		foreach ( $data->getProperties() as $property ) {
			$propertyValues = $data->getPropertyValues( $property );
			foreach ( $propertyValues as $propertyValue ) {
				$propertyName = null;
				$linkedPageName = null;
				if ( $propertyValue instanceof SMWDIWikiPage ) {
					$propertyName = $property->getKey();
					$linkedPageName = $propertyValue->getDBkey();
				} elseif ( $propertyValue instanceof SMWWikiPageValue ) {
					$propertyName = $property->getWikiValue();
					$linkedPageName = $propertyValue->getWikiValue();
				}
				// Needed for SMW 1.7 (?)
				$linkedPageName = str_replace( '_', ' ', $linkedPageName );
				if ( !is_null( $linkedPageName ) ) {
					if ( array_key_exists( $linkedPageName, self::$mLinkedPages ) ) {
						self::$mLinkedPages[$linkedPageName][] = $propertyName;
					} else {
						self::$mLinkedPages[$linkedPageName] = array( $propertyName );
					}
				}
			}
		}
		self::$mLinkedPagesRetrieved = true;
	}

	/**
	 * Gets the forms specified, if any, of either type "default form",
	 * "alternate form", or "default form for page", for a specific page
	 * (which should be a category, property, or namespace page)
	 */
	static function getFormsThatPagePointsTo( $page_name, $page_namespace, $form_connection_type ) {
		if ( $page_name == NULL ) {
			return array();
		}

		// Check if we've already gotten the set of forms for this
		// combination of page and "form connection type" (default,
		// alternate or "creates pages with"). If so, use that -
		// otherwise, prepare the array so that we can add this
		// data to it.
		$page_key = "$page_namespace:$page_name";
		if ( array_key_exists( $page_key, self::$mLinkedForms ) ) {
			if ( array_key_exists( $form_connection_type, self::$mLinkedForms[$page_key] ) ) {
				return self::$mLinkedForms[$page_key][$form_connection_type];
			} else {
				// Do nothing - an entry with this key will
				// be added at the end of this method.
			}
		} else {
			self::$mLinkedForms[$page_key] = array();
		}

		if ( $form_connection_type == self::DEFAULT_FORM ) {
			$prop_smw_id = '_SF_DF';
			$backup_prop_smw_id = '_SF_DF_BACKUP';
		} elseif ( $form_connection_type == self::ALTERNATE_FORM ) {
			$prop_smw_id = '_SF_AF';
			$backup_prop_smw_id = '_SF_AF_BACKUP';
		} elseif ( $form_connection_type == self::PAGE_DEFAULT_FORM ) {
			$prop_smw_id = '_SF_PDF';
			$backup_prop_smw_id = '_SF_PDF_BACKUP';
		} elseif ( $form_connection_type == self::AUTO_CREATE_FORM ) {
			$prop_smw_id = '_SF_CP';
			$backup_prop_smw_id = '_SF_CP_BACKUP';
		} else {
			return array();
		}

		global $sfgContLang;

		$store = SFUtils::getSMWStore();
		$subject = Title::makeTitleSafe( $page_namespace, $page_name );
		$form_names = SFValuesUtils::getSMWPropertyValues( $store, $subject, $prop_smw_id );

		// If we're using a non-English language, check for the English
		// string as well.
		if ( ! class_exists( 'SF_LanguageEn' ) || ! $sfgContLang instanceof SF_LanguageEn ) {
			$backup_form_names = SFValuesUtils::getSMWPropertyValues( $store, $subject, $backup_prop_smw_id );
			$form_names = array_merge( $form_names, $backup_form_names );
		}

		// These form names will all start with "Form:" - remove the
		// namespace prefix.
		foreach ( $form_names as $i => $form_name ) {
			$form_names[$i] = preg_replace( '/^Form:/', '', $form_name );
		}
		// Add this data to the "cache".
		self::$mLinkedForms[$page_key][$form_connection_type] = $form_names;
		return $form_names;
	}

	/**
	 * Automatically creates a page that's red-linked from the page
	 * being viewed, if there's a property pointing from anywhere to
	 * that page that's defined with the 'Creates pages with form'
	 * special property.
	 *
	 * @deprecated since SF 3.4.
	 */
	static function createLinkedPage( $title, $incomingProperties ) {
		// If we're in a 'special' page, just exit - this is to
		// prevent constant additions being made from the
		// 'Special:RecentChanges' page, which shows pages that
		// were previously deleted as red links, even if they've
		// since been recreated. The same might hold true for
		// other special pages.
		global $wgTitle;
		if ( empty( $wgTitle ) ) {
			return false;
		}
		if ( $wgTitle->getNamespace() == NS_SPECIAL ) {
			return false;
		}

		foreach ( $incomingProperties as $propertyName ) {
			$autoCreateForms = self::getFormsThatPagePointsTo( $propertyName, SMW_NS_PROPERTY, self::AUTO_CREATE_FORM );
			if ( count( $autoCreateForms ) > 0 ) {
				self::createPageWithForm( $title, $autoCreateForms[0] );
				return true;
			}
		}

		return false;
	}

	public static function createPageWithForm( $title, $formName ) {
		global $sfgFormPrinter;

		$formTitle = Title::makeTitleSafe( SF_NS_FORM, $formName );
		$formDefinition = SFUtils::getPageText( $formTitle );
		$preloadContent = null;

		// Allow outside code to set/change the preloaded text.
		Hooks::run( 'sfEditFormPreloadText', array( &$preloadContent, $title, $formTitle ) );

		list ( $formText, $pageText, $formPageTitle, $generatedPageName ) =
			$sfgFormPrinter->formHTML( $formDefinition, false, false, null, $preloadContent, 'Some very long page name that will hopefully never get created ABCDEF123', null );
		$params = array();

		// Get user "responsible" for all auto-generated
		// pages from red links.
		$userID = 1;
		global $sfgAutoCreateUser;
		if ( !is_null( $sfgAutoCreateUser ) ) {
			$user = User::newFromName( $sfgAutoCreateUser );
			if ( !is_null( $user ) ) {
				$userID = $user->getId();
			}
		}
		$params['user_id'] = $userID;
		$params['page_text'] = $pageText;
		$job = new SFCreatePageJob( $title, $params );

		$jobs = array( $job );
		if ( class_exists( 'JobQueueGroup' ) ) {
			JobQueueGroup::singleton()->push( $jobs );
		} else {
			// MW <= 1.20
			Job::batchInsert( $jobs );
		}
	}

	/**
	 * Helper function for formEditLink() - gets the 'default form' and
	 * 'alternate form' properties for a page, and creates the
	 * corresponding Special:FormEdit link, if any such properties are
	 * defined
	 */
	static function getFormEditLinkForPage( $target_page_title, $page_name, $page_namespace ) {
		$default_forms = self::getFormsThatPagePointsTo( $page_name, $page_namespace, self::DEFAULT_FORM );
		$alt_forms = self::getFormsThatPagePointsTo( $page_name, $page_namespace, self::ALTERNATE_FORM );

		if ( ( count( $default_forms ) == 0 ) && ( count( $alt_forms ) == 0 ) ) {
			return null;
		}

		$fe = SpecialPageFactory::getPage( 'FormEdit' );

		$fe_url = $fe->getTitle()->getLocalURL();
		if ( count( $default_forms ) > 0 ) {
			$form_edit_url = $fe_url . "/" . $default_forms[0] . "/" . SFUtils::titleURLString( $target_page_title );
		} else {
			$form_edit_url = $fe_url;
			$form_edit_url .= ( strpos( $form_edit_url, "?" ) ) ? "&" : "?";
			$form_edit_url .= 'target=' . urlencode( SFUtils::titleString( $target_page_title ) );
		}
		foreach ( $alt_forms as $i => $alt_form ) {
			$form_edit_url .= ( strpos( $form_edit_url, "?" ) ) ? "&" : "?";
			$form_edit_url .= "alt_form[$i]=$alt_form";
		}
		// Add "redlink=1" to the query string, so that the user will
		// go to the actual page if it now exists.
		$form_edit_url .= ( strpos( $form_edit_url, "?" ) ) ? "&" : "?";
		$form_edit_url .= "redlink=1";
		return $form_edit_url;
	}

	/**
	 * Returns the URL for the Special:FormEdit page for a specific page,
	 * given its default and alternate form(s) - we can't just point to
	 * '&action=formedit', because that one doesn't reflect alternate forms
	 */
	static function formEditLink( $title, $incoming_properties ) {
		// Get all properties pointing to this page, and if
		// getFormEditLinkForPage() returns a value with any of
		// them, return that.

		foreach ( $incoming_properties as $property_name ) {
			if ( $form_edit_link = self::getFormEditLinkForPage( $title, $property_name, SMW_NS_PROPERTY ) ) {
				return $form_edit_link;
			}
		}

		// If that didn't work, check if this page's namespace
		// has a default form specified.
		$namespace_name = $title->getNsText();
		if ( '' === $namespace_name ) {
			// If it's in the main (blank) namespace, check for the
			// file named with the word for "Main" in this language.
			$namespace_name = wfMessage( 'sf_blank_namespace' )->inContentLanguage()->text();
		}
		if ( $form_edit_link = self::getFormEditLinkForPage( $title, $namespace_name, NS_PROJECT ) ) {
			return $form_edit_link;
		}
		// If nothing found still, return null.
		return null;
	}

	/**
	 * Sets the URL for form-based creation of a nonexistent (broken-linked,
	 * AKA red-linked) page
	 */
	static function setBrokenLink( $linker, $target, $options, $text, &$attribs, &$ret ) {
		// If it's not a broken (red) link, exit.
		if ( !in_array( 'broken', $options, true ) ) {
			return true;
		}
		// If the link is to a special page, exit.
		if ( $target->getNamespace() == NS_SPECIAL ) {
			return true;
		}

		global $sfgRedLinksCheckOnlyLocalProps;
		if ( $sfgRedLinksCheckOnlyLocalProps ) {
			$incoming_properties = array();
			global $wgTitle;
			// If this is called from the command line, $wgTitle
			// might not have been set.
			if ( !is_null( $wgTitle ) ) {
				self::getPagePropertiesOfPage( $wgTitle );
				$targetName = $target->getText();
				if ( array_key_exists( $targetName, self::$mLinkedPages ) ) {
					$incoming_properties = self::$mLinkedPages[$targetName];
				}
			}
		} else {
			$incoming_properties = self::getIncomingProperties( $target );
		}
		self::createLinkedPage( $target, $incoming_properties );
		$link = self::formEditLink( $target, $incoming_properties );
		if ( !is_null( $link ) ) {
			$attribs['href'] = $link;
			return true;
		}

		global $sfgLinkAllRedLinksToForms;
		// Don't do this is it it's a category page - it probably
		// won't have an associated form.
		if ( $sfgLinkAllRedLinksToForms && $target->getNamespace() != NS_CATEGORY ) {
			$attribs['href'] = $target->getLinkURL( array( 'action' => 'formedit', 'redlink' => '1' ) );
			return true;
		}

		return true;
	}

	/**
	 * Get the form(s) used to edit this page - either:
	 * - the default form(s) for the page itself, if there are any; or
	 * - the default form(s) for a category that this article belongs to,
	 * if there are any; or
	 * - the default form(s) for the article's namespace, if there are any.
	 */
	static function getDefaultFormsForPage( $title ) {
		// See if the page itself has a default form (or forms), and
		// return it/them if so.
		// (Disregard category pages for this check.)
		if ( $title->getNamespace() != NS_CATEGORY ) {
			$default_form = self::getDefaultForm( $title );
			if ( $default_form != '' ) {
				return array( $default_form );
			}
		}

		$default_forms = self::getFormsThatPagePointsTo( $title->getText(), $title->getNamespace(), self::PAGE_DEFAULT_FORM );
		if ( count( $default_forms ) > 0 ) {
			return $default_forms;
		}

		// If this is not a category page, look for a default form
		// for its parent category or categories.
		$namespace = $title->getNamespace();
		if ( NS_CATEGORY !== $namespace ) {
			$default_forms = array();
			$categories = SFValuesUtils::getCategoriesForPage( $title );
			foreach ( $categories as $category ) {
				if ( class_exists( 'PSSchema' ) ) {
					// Check the Page Schema, if one exists.
					$psSchema = new PSSchema( $category );
					if ( $psSchema->isPSDefined() ) {
						$formName = SFPageSchemas::getFormName( $psSchema );
						if ( !is_null( $formName ) ) {
							$default_forms[] = $formName;
						}
					}
				}
				$categoryPage = Title::makeTitleSafe( NS_CATEGORY, $category );
				$defaultFormForCategory = self::getDefaultForm( $categoryPage );
				if ( $defaultFormForCategory != '' ) {
					$default_forms[] = $defaultFormForCategory;
				}
				$default_forms = array_merge( $default_forms, self::getFormsThatPagePointsTo( $category, NS_CATEGORY, self::DEFAULT_FORM ) );
			}
			if ( count( $default_forms ) > 0 ) {
				// It is possible for two categories to have the same default form, so purge any
				// duplicates from the array to avoid a "more than one default form" warning.
				return array_unique( $default_forms );
			}
		}

		// All that's left is checking for the namespace. If this is
		// a subpage, exit out - default forms for namespaces don't
		// apply to subpages.
		if ( $title->isSubpage() ) {
			return array();
		}

		// If we're still here, just return the default form for the
		// namespace, which may well be null.
		if ( NS_MAIN === $namespace ) {
			// If it's in the main (blank) namespace, check for the
			// file named with the word for "Main" in this language.
			$namespace_label = wfMessage( 'sf_blank_namespace' )->inContentLanguage()->text();
		} else {
			global $wgContLang;
			$namespace_labels = $wgContLang->getNamespaces();
			$namespace_label = $namespace_labels[$namespace];
		}

		$namespacePage = Title::makeTitleSafe( NS_PROJECT, $namespace_label );
		$default_form = self::getDefaultForm( $namespacePage );
		if ( $default_form != '' ) {
			return array( $default_form );
		}

		$default_forms = self::getFormsThatPagePointsTo( $namespace_label, NS_PROJECT, self::DEFAULT_FORM );
		return $default_forms;
	}
}
