<?php
/**
 * Support MantisBT: http://www.mantisbt.org.
 *
 * @addtogroup Extensions
 *
 * @copyright Copyright © 2008-2009, Translatewiki.net developers
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class MantisMessageGroup extends MessageGroupOld {
	protected $label = 'MantisBT (web-based bugtracking system)';
	protected $id    = 'out-mantis';
	protected $type  = 'mantis';

	protected   $fileDir  = '__BUG__';

	public function getPath() { return $this->fileDir; }
	public function setPath( $value ) { $this->fileDir = $value; }

	protected $codeMap = array(
		'af' => 'afrikaans',
		'am' => 'amharic',
		'ar' => 'arabic',
		'arz' => 'arabicegyptianspoken',
		'bg' => 'bulgarian',
		'br' => 'breton',
		'ca' => 'catalan',
		'cs' => 'czech',
		'da' => 'danish',
		'de' => 'german',
		'el' => 'greek',
		'en' => 'english',
		'es' => 'spanish',
		'et' => 'estonian',
		'fi' => 'finnish',
		'fr' => 'french',
		'gl' => 'galician',
		'gsw' => 'swissgerman',
		'he' => 'hebrew',
		'hr' => 'croatian',
		'hu' => 'hungarian',
		'is' => 'icelandic',
		'it' => 'italian',
		'ja' => 'japanese',
		'ksh' => 'ripoarisch',
		'ko' => 'korean',
		'lt' => 'lithuanian',
		'lv' => 'latvian',
		'mk' => 'macedonian',
		'nl' => 'dutch',
		'nn' => 'norwegian_nynorsk',
		'no' => 'norwegian_bokmal',
		'oc' => 'occitan',
		'pl' => 'polish',
		'pt' => 'portuguese_standard',
		'pt-br' => 'portuguese_brazil',
		'ro' => 'romanian',
		'ru' => 'russian',
		'sk' => 'slovak',
		'sl' => 'slovene',
		'sr-ec' => 'serbian',
		'sv' => 'swedish',
		'tl' => 'tagalog',
		'tr' => 'turkish',
		'uk' => 'ukrainian',
		'ur' => 'urdu',
		'vo' => 'volapuk',
		'zh-hans' => 'chinese_simplified',
		'zh-hant' => 'chinese_traditional',
	);

	protected $optional = array(
		's_sponsorship_process_url', 's_charset', 's_p',
		's_priority_abbreviation', 's_attachment_alt', 's_phpmailer_language',
		's_word_separator', 's_directionality', 's_label'
	);

	public $header = '<?php
/** MantisBT - a php based bugtracking system
 *
 * Copyright (C) 2000 - 2002  Kenzaburo Ito - kenito@300baud.org
 * Copyright (C) 2002 - 2010  MantisBT Team - mantisbt-dev@lists.sourceforge.net
 *
 * MantisBT is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * MantisBT is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with MantisBT.  If not, see <http://www.gnu.org/licenses/>.
 */';

	public function getMessageFile( $code ) {
		if ( isset( $this->codeMap[$code] ) ) {
			$code = $this->codeMap[$code];
		}
		return "strings_$code.txt";
	}

	protected function getFileLocation( $code ) {
		return $this->fileDir . '/' . $this->getMessageFile( $code );
	}

	public function getReader( $code ) {
		return new PhpVariablesFormatReader( $this->getFileLocation( $code ) );
	}

	public function getWriter() {
		return new PhpVariablesFormatWriter( $this );
	}

	public function getChecker() {
		$checker = new MessageChecker( $this );
		$checker->setChecks( array(
			array( $checker, 'printfCheck' ),
			array( $checker, 'braceBalanceCheck' ),
		) );
		return $checker;
	}

}
