<?php

class TranslatePreferences {
	/**
	 * Add preferences for Translate
	 */
	public static function onGetPreferences( $user, &$preferences ) {
		global $wgEnableEmail, $wgUser;

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
			$preferences = wfArrayInsertAfter( $preferences, $prefs, 'enotifrevealaddr' );
		}

		return true;
	}


	public static function translationAssistLanguages( $user, &$preferences ) {
		$select = self::languageSelector();
		$select->setTargetId( 'mw-input-translate-editlangs' );


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

	public static function translationJsedit( $user, &$preferences ) {
		$preferences['translate-jsedit'] = array(
			'class' => 'HTMLCheckField',
			'section' => 'editing/translate',
			'label-message' => 'translate-pref-jsedit',
		);

		return true;
	}

	protected static  function languageSelector() {
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
