<?php

class LocalisationException extends Exception {};
class NoSuchMessageFileException extends LocalisationException {};

/**loosely inspired on class of same name from mediawiki.
* (mediawiki version is overkill for our purposes though)
* also, unlike mediawiki, we always use ISO 639-3 for language codes.
*/
class Language {

	private $code; #language code, mostly for debugging purposes
	private $messages; # assoc array of translations
	private $fallback=false; #a different Language object to fall back to
				 # if we can't find a particular entry in $messages
	private $direction="ltr";

	public function __construct($code="Default") {
		if (!$code) 
			$code="Default";
		$this->code=$code;
		$this->loadMessages($code);


	}

	/** getter, returns writing direction of this language ("rtl" or "ltr"); */
	public function getDirection() {
		return $this->direction;
	}

	public function loadMessages($code="Default") {
		if ($code==="Default") {
			$code="en";
		}

		include("language.i18n.php");	
		if (array_key_exists($code, $messages)) {
			foreach ($messages[$code] as $key=>$message) {
				$this->messages[$key]=$message; #messages is from the included file
			}
		} else {
			throw new LocalisationException("messages problem, there's no messages for $code");
		}
			
		if (array_key_exists($code,$fallback)) {
			if ($fallback[$code]===false) {
				$this->fallback=false;
			} else {
				$this->fallback=new Language($fallback[$code]);
			}
		}

		if (array_key_exists($code,$direction)) {
			$this->direction=$direction[$code];
		}


		$this->code=$code;
	}


	/** safe takes a string and makes it safe for use as a key on betawiki.
	 * betawiki (http://translatewiki.net/) will translate my i18n for me
	 * if I do this. So it's a fair trade.
	 */
	public static function safe($string) {
		if (substr_count($string,"voctrain_")==0) {
			$string="voctrain_".$string;
		}
		$string=preg_replace("|[^A-Za-z0-9_]|","_",$string);
		$compare="";
		while($compare!=$string) {
			$compare=$string;
			$string=str_replace("__","_",$string);
		}

		return $string;
	}

	
	/** safeMatch two strings, after safe()-ing them.
	 * @return true if safe($one)==safe($two)
	*/
	public static function safeMatch($one, $two) {
		return Language::safe($one)==Language::safe($two);
	}

	
	/**
	 * Get language names available for i18n, indexed by code.
	 */
	public static function getI18NLanguageNames() {
		include("language.i18n.php");	
		include("Names.php");
		$keys= array_keys($messages);
		$names=array();
		foreach ($keys as $key) {
			if (array_key_exists($key,$languageNames)) {
				$names[$key]=$languageNames[$key];
			}
		}

		return $names;
	}

	public function translation_exists($phrase) {
		if ($this->messages) {
			return array_key_exists(Language::safe($phrase), $this->messages);
		} else {
			throw new Exception("not initialized, code ".$this->code);
		}
	}

	/** translate the phrase, but doesn't do any substitutions. 
	 * Use printf,sprintf, or vsprintf etc...  for subsitutions */
	public function translate($phrase) {
		if ($this->translation_exists($phrase)) {
			return $this->messages[Language::safe($phrase)];
		} elseif ($this->fallback && $this->fallback->translation_exists($phrase)) {
			return $this->fallback->translate($phrase);
		} else {
			return "{untranslated: '$phrase'}";
		}
	}
	

	# == Diverse sprintf-ish functions 
	# (see also: php documentation for non-i18nified versions)

	/** i18nsprint is a simpler way to go about things, will do i18n replacement
	on antyhing enclosed in <|  |>, any %signs in these substrings
	    will be substituted with items from the array*/
	public function i18nsprint($string, $replacements=array()) {
		$callback=new I18Ncallback();
		$callback->replacements=$replacements;
		$callback->language=$this;
		return preg_replace_callback("#(?U)(<\|.*\|>)#", array($callback,"replace"), $string);
	}

	/* like i18nsprint, but prints directly to output*/
	public function i18nprint($string, $replacements=array()) {
		print $this->i18nsprint($string, $replacements);
	}


	# internationalized printf
	public function printf($phrase) {
		$args=func_get_args();
		$str=$this->vsprintf($phrase, $args);
		print $str;
		return strlen($str);
	}

	# internationalized sprintf
	public function sprintf($phrase) {
		$args=func_get_args();
		return $this->vsprintf($phrase, $args);
	}

	# internationalized vprintf
	public function vsprintf($phrase, $array) {
		return vsprintf($this->translate($phrase),$array);
	}

	/** assoc variant of vsprintf,
	 * (modified from sprintf2 by "matt", 10-Mar-2008 06:13,
	 *  http://nl2.php.net/manual/en/function.sprintf.php )
	 * original apparently  Copyright © 2001-2008 The PHP Group, copied here
	 * on condition that copyright notice is retained. )
	 */
	function vsprintf2($phrase='', $vars=array(), $char='%') {
		$str=$this->translate($phrase);
		if (!$str) return '';
		if (count($vars) > 0) {
			foreach ($vars as $k => $v) {
				$str = str_replace($char . $k, $v, $str);
			}
		}

		return $str;
	}

	# == Getters/setters

	/**@return iso693_3 3-letter language code, or "Default".*/
	public function getCode() {
		return $this->code;
	}
	
	/** @return all possible languages indexed by code */
	public static function getAllLanguageNames() {
		include("Names.php");
		return $languageNames;
	}

}


/** for use by Language::i18nprint */
class I18Ncallback {
	public $language;
	public $replacements;
	public function replace($matches) {
		$match=substr($matches[0],2,-2);

		return $this->language->vsprintf2($match,$this->replacements);
	}
}

?>
