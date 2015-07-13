<?php
/**
 * @author Yaron Koren
 * @file
 * @ingroup SF
 */

/**
 * @ingroup SFLanguage
 */
class SF_LanguageEl extends SF_Language {

	/* private */ var $m_SpecialProperties = array(
		// always start upper-case
		SF_SP_HAS_DEFAULT_FORM    => 'Έχει προεπιλεγμένη φόρμα', // Has default form
		SF_SP_HAS_ALTERNATE_FORM  => 'Έχει εναλλακτική φόρμα', // Has alternate form
		SF_SP_CREATES_PAGES_WITH_FORM => 'Δημιουργεί σελίδες με φόρμα', // Creates pages with form
		SF_SP_PAGE_HAS_DEFAULT_FORM   => 'Η σελίδα έχει προεπιλεγμένη φόρμα', // Page has default form
		SF_SP_HAS_FIELD_LABEL_FORMAT  => 'Έχει μορφή ετικέτας πεδίου', //Has field label format
	);

}
