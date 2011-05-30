<?php
/**
 * Contains classes for addition of extension specific preference settings.
 *
 * @file
 * @author Siebrand Mazeland
 * @author Niklas Laxström
 * @copyright Copyright © 2008-2010 Siebrand Mazeland, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Class to add Translate specific preference settings.
 */
class TranslatePreferences {
	/**
	 * Add 'translate-pref-nonewsletter' preference.
	 * This is actually specific to translatewiki.net
	 *
	 * @return \bool true
	 */
	public static function onGetPreferences( $user, &$preferences ) {
		global $wgEnableEmail, $wgUser, $wgEnotifRevealEditorAddress;

		// Only show is e-mail is enabled and user has a confirmed e-mail address.
		if ( $wgEnableEmail && $wgUser->isEmailConfirmed() ) {
			// 'translate-pref-nonewsletter' is used as opt-out for
			// users with a confirmed e-mail address
			$prefs = array(
				'translate-nonewsletter' => array(
					'type' => 'toggle',
					'section' => 'personal/email',
					'label-message' => 'translate-pref-nonewsletter'
				)
			);

			// Add setting after 'enotifrevealaddr'
			$preferences = wfArrayInsertAfter( $preferences, $prefs,
				$wgEnotifRevealEditorAddress ? 'enotifrevealaddr' : 'enotifminoredits' );
		}

		return true;
	}

	/**
	 * Add 'translate-editlangs' preference.
	 * These are the languages also shown when translating.
	 *
	 * @return \bool true
	 */
	public static function translationAssistLanguages( $user, &$preferences ) {
		// Get selector.
		$select = self::languageSelector();
		// Set target ID.
		$select->setTargetId( 'mw-input-translate-editlangs' );
		// Get available languages.
		$languages = Language::getLanguageNames( false );

		$preferences['translate-editlangs'] = array(
			'class' => 'HTMLJsSelectToInputField',
			'section' => 'editing/translate',
			'label-message' => 'translate-pref-editassistlang',
			'help-message' => 'translate-pref-editassistlang-help',
			'select' => $select,
			'valid-values' => array_keys( $languages ),
		);

		return true;
	}

	/**
	 * Add 'translate-jsedit' preference.
	 * An option to disable the javascript edit interface.
	 *
	 * @return \bool true
	 */
	public static function translationJsedit( $user, &$preferences ) {
		$preferences['translate-jsedit'] = array(
			'class' => 'HTMLCheckField',
			'section' => 'editing/translate',
			'label-message' => 'translate-pref-jsedit',
		);

		return true;
	}

	/**
	 * JavsScript selector for language codes.
	 */
	protected static function languageSelector() {
		global $wgLang;

		if ( is_callable( array( 'LanguageNames', 'getNames' ) ) ) {
			$languages = LanguageNames::getNames( $wgLang->getCode(),
				LanguageNames::FALLBACK_NORMAL
			);
		} else {
			$languages = Language::getLanguageNames( false );
		}

		ksort( $languages );

		$selector = new XmlSelect( 'mw-language-selector', 'mw-language-selector'  );
		foreach ( $languages as $code => $name ) {
			$selector->addOption( "$code - $name", $code );
		}

		$jsSelect = new JsSelectToInput( $selector );
		$jsSelect->setSourceId( 'mw-language-selector' );

		return $jsSelect;
	}
}
