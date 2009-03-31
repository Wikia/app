<?php
# $wgGrammarForms for Wikimedia sites. No longer needed to set them in
# InitialiseSettings.php. Initial version compiled from current Wikimedia
# configuration and contents of LanguageXx.php.

$wgGrammarForms['be'] = array(
	# genitive
	'родны' => array(
		'ВікіВіды'    => 'ВікіВідаў',
		'ВікіКнігі'   => 'ВікіКніг',
		'ВікіКрыніца' => 'ВікіКрыніцы',
		'ВікіНавіны'  => 'ВікіНавін',
		'ВікіСлоўнік' => 'ВікіСлоўніка',
		'Вікіпэдыя'   => 'Вікіпэдыі',
	),
	# akusative
	'вінавальны' => array(
		'ВікіКнігі'   => 'ВікіКніг',
		'ВікіКрыніца' => 'ВікіКрыніцу',
		'ВікіНавіны'  => 'ВікіНавін',
		'ВікіСлоўнік' => 'ВікіСлоўніка',
		'Вікіпэдыя'   => 'Вікіпэдыю',
	),
	# prepositional
	'месны' => array(
		'ВікіВіды'    => 'ВікіВідах',
		'ВікіКнігі'   => 'ВікіКнігах',
		'ВікіКрыніца' => 'ВікіКрыніцы',
		'ВікіНавіны'  => 'ВікіНавінах',
		'ВікіСлоўнік' => 'ВікіСлоўніку',
		'Вікіпэдыя'   => 'Вікіпэдыі',
	),
); # be

$wgGrammarForms['be-tarask'] = array(
	# genitive
	'родны' => array(
		'ВікіВіды'    => 'ВікіВідаў',
		'ВікіКнігі'   => 'ВікіКніг',
		'ВікіКрыніца' => 'ВікіКрыніцы',
		'ВікіНавіны'  => 'ВікіНавін',
		'ВікіСлоўнік' => 'ВікіСлоўніка',
		'Вікіпэдыя'   => 'Вікіпэдыі',
	),
	# akusative
	'вінавальны' => array(
		'ВікіКрыніца' => 'ВікіКрыніцу',
		'ВікіНавіны'  => 'ВікіНавіны',
		'ВікіСлоўнік' => 'ВікіСлоўнік',
		'Вікіпэдыя'   => 'Вікіпэдыю',
	),
	# prepositional
	'месны' => array(
		'ВікіВіды'    => 'ВікіВідах',
		'ВікіКнігі'   => 'ВікіКнігах',
		'ВікіКрыніца' => 'ВікіКрыніцы',
		'ВікіНавіны'  => 'ВікіНавінах',
		'ВікіСлоўнік' => 'ВікіСлоўніку',
		'Вікіпэдыя'   => 'Вікіпэдыі',
	),
); # be-tarask

$wgGrammarForms['bs'] = array(
	# genitive
	'genitiv' => array(
		'Vikirječnik' => 'Vikirječnika',
		'Wikicitati'  => 'Wikicitata',
		'Wikiizvor'   => 'Wikiizvora',
		'Wikiknjige'  => 'Wikiknjiga',
		'Wikipedia'   => 'Wikipedije',
	),
	# dative
	'dativ' => array(
		'Vikirječnik' => 'Vikirječniku',
		'Wikicitati'  => 'Wikicitatima',
		'Wikiizvor'   => 'Wikiizvoru',
		'Wikiknjige'  => 'Wikiknjigama',
		'Wikipedia'   => 'Wikipediji',
		'Wikivijesti' => 'Wikivijestima',
	),
	# akusative
	'akuzativ' => array(
		'Vikirječnik' => 'Vikirječnika',
		'Wikicitati'  => 'Wikicitate',
		'Wikiizvor'   => 'Wikiizvora',
		'Wikipedia'   => 'Wikipediju',
	),
	# vocative
	'vokativ' => array(
		'Vikirječnik' => 'Vikirječniče',
		'Wikiizvor'   => 'Wikizivoru',
		'Wikipedia'   => 'Wikipedijo',
	),
	# instrumental
	'instrumental' => array(
		'Vikirječnik' => 's Vikirječnikom',
		'Wikicitati'  => 's Wikicitatima',
		'Wikiizvor'   => 's Wikiizvorom',
		'Wikiknjige'  => 's Wikiknjigama',
		'Wikipedia'   => 's Wikipediom',
		'Wikivijesti' => 's Wikivijestima',
	),
	# lokative
	'lokativ' => array(
		'Vikirječnik' => 'o Vikirječniku',
		'Wikicitati'  => 'o Wikicitatima',
		'Wikiizvor'   => 'o Wikiizvoru',
		'Wikiknjige'  => 'o Wikiknjigama',
		'Wikipedia'   => 'o Wikipediji',
		'Wikivijesti' => 'o Wikivijestima',
	),
); # bs

$wgGrammarForms['cs'] = array(
	# only forms different than default/given
	'1sg' => array(
		'Wikibooks'   => 'Wikiknihy',
		'Wikinews'    => 'Wikizprávy',
		'Wikipedia'   => 'Wikipedie',
		'Wikiquote'   => 'Wikicitáty',
		'Wikispecies' => 'Wikidruhy',
		'Wikiversity' => 'Wikiverzita',
		'Wiktionary'  => 'Wikislovník',
		'Wikcionář'   => 'Wikislovník', # old Wiktionary translation
	),
	'2sg' => array(
		'uživatel'    => 'uživatele',
		'Wikibooks'   => 'Wikiknih',
		'Wikinews'    => 'Wikizpráv',
		'Wikipedia'   => 'Wikipedie',
		'Wikiquote'   => 'Wikicitátů',
		'Wikispecies' => 'Wikidruhů',
		'Wikiversity' => 'Wikiverzity',
		'Wiktionary'  => 'Wikislovníku',
		'Wikicitáty'  => 'Wikicitátů',
		'Wikidruhy'   => 'Wikidruhů',
		'Wikiknihy'   => 'Wikiknih',
		'Wikislovník' => 'Wikislovníku',
		'Wikiverzita' => 'Wikiverzity',
		'Wikizprávy'  => 'Wikizpráv',
		'Wikcionář'   => 'Wikislovníku',
	),
	'3sg' => array(
		'uživatel'    => 'uživateli',
		'Wikibooks'   => 'Wikiknihám',
		'Wikinews'    => 'Wikizprávám',
		'Wikipedia'   => 'Wikipedii',
		'Wikiquote'   => 'Wikicitátům',
		'Wikispecies' => 'Wikidruhům',
		'Wikiversity' => 'Wikiverzitě',
		'Wiktionary'  => 'Wikislovníku',
		'Wikicitáty'  => 'Wikicitátům',
		'Wikidruhy'   => 'Wikidruhům',
		'Wikiknihy'   => 'Wikiknihám',
		'Wikipedie'   => 'Wikipedii',
		'Wikislovník' => 'Wikislovníku',
		'Wikiverzita' => 'Wikiverzitě',
		'Wikizprávy'  => 'Wikizprávám',
		'Wikcionář'   => 'Wikislovníku',
	),
	'4sg' => array(
		'uživatel'    => 'uživatele',
		'Wikibooks'   => 'Wikiknihy',
		'Wikinews'    => 'Wikizprávy',
		'Wikipedia'   => 'Wikipedii',
		'Wikiquote'   => 'Wikicitáty',
		'Wikispecies' => 'Wikidruhy',
		'Wikiversity' => 'Wikiverzitu',
		'Wiktionary'  => 'Wikislovník',
		'Wikipedie'   => 'Wikipedii',
		'Wikiverzita' => 'Wikiverzitu',
		'Wikcionář'   => 'Wikislovník',
	),
	'5sg' => array(
		'uživatel'    => 'uživateli',
		'Wikibooks'   => 'Wikiknihy',
		'Wikinews'    => 'Wikizprávy',
		'Wikipedia'   => 'Wikipedie',
		'Wikiquote'   => 'Wikicitáty',
		'Wikispecies' => 'Wikidruhy',
		'Wikiversity' => 'Wikiverzito',
		'Wiktionary'  => 'Wikislovníku',
		'Wikislovník' => 'Wikislovníku',
		'Wikiverzita' => 'Wikiverzito',
		'Wikcionář'   => 'Wikislovníku',
	),
	'6sg' => array(
		'uživatel'    => 'uživateli',
		'Wikibooks'   => 'Wikiknihách',
		'Wikinews'    => 'Wikizprávách',
		'Wikipedia'   => 'Wikipedii',
		'Wikiquote'   => 'Wikicitátech',
		'Wikispecies' => 'Wikidruzích',
		'Wikiversity' => 'Wikiverzitě',
		'Wiktionary'  => 'Wikislovníku',
		'Wikicitáty'  => 'Wikicitátech',
		'Wikidruhy'   => 'Wikidruzích',
		'Wikiknihy'   => 'Wikiknihách',
		'Wikipedie'   => 'Wikipedii',
		'Wikislovník' => 'Wikislovníku',
		'Wikiverzita' => 'Wikiverzitě',
		'Wikizprávy'  => 'Wikizprávách',
		'Wikcionář'   => 'Wikislovníku',
	),
	'7sg' => array(
		'uživatel'    => 'uživatelem',
		'Wikibooks'   => 'Wikiknihami',
		'Wikinews'    => 'Wikizprávami',
		'Wikipedia'   => 'Wikipedií',
		'Wikiquote'   => 'Wikicitáty',
		'Wikispecies' => 'Wikidruhy',
		'Wikiversity' => 'Wikiverzitou',
		'Wiktionary'  => 'Wikislovníkem',
		'Wikiknihy'   => 'Wikiknihami',
		'Wikipedie'   => 'Wikipedií',
		'Wikislovník' => 'Wikislovníkem',
		'Wikiverzita' => 'Wikiverzitou',
		'Wikizprávy'  => 'Wikizprávami',
		'Wikcionář'   => 'Wikislovníkem',
	),
	'1pl' => array(
		'uživatel'    => 'uživatelé',
		'Wikibooks'   => 'Wikiknihy',
		'Wikinews'    => 'Wikizprávy',
		'Wikipedia'   => 'Wikipedie',
		'Wikiquote'   => 'Wikicitáty',
		'Wikispecies' => 'Wikidruhy',
		'Wikiversity' => 'Wikiverzity',
		'Wiktionary'  => 'Wikislovníky',
		'Wikislovník' => 'Wikislovníky',
		'Wikiverzita' => 'Wikiverzity',
		'Wikcionář'   => 'Wikislovníky',
	),
	'2pl' => array(
		'uživatel'    => 'uživatelů',
		'Wikibooks'   => 'Wikiknih',
		'Wikinews'    => 'Wikizpráv',
		'Wikipedia'   => 'Wikipedií',
		'Wikiquote'   => 'Wikicitátů',
		'Wikispecies' => 'Wikidruhů',
		'Wikiversity' => 'Wikiverzit',
		'Wiktionary'  => 'Wikislovníků',
		'Wikicitáty'  => 'Wikicitátů',
		'Wikidruhy'   => 'Wikidruhů',
		'Wikiknihy'   => 'Wikiknih',
		'Wikipedie'   => 'Wikipedií',
		'Wikislovník' => 'Wikislovníků',
		'Wikiverzita' => 'Wikiverzit',
		'Wikizprávy'  => 'Wikizpráv',
		'Wikcionář'   => 'Wikislovníků',
	),
	'3pl' => array(
		'uživatel'    => 'uživatelům',
		'Wikibooks'   => 'Wikiknihám',
		'Wikinews'    => 'Wikizprávám',
		'Wikipedia'   => 'Wikipediím',
		'Wikiquote'   => 'Wikicitátům',
		'Wikispecies' => 'Wikidruhům',
		'Wikiversity' => 'Wikiverzitám',
		'Wiktionary'  => 'Wikislovníkům',
		'Wikicitáty'  => 'Wikicitátům',
		'Wikidruhy'   => 'Wikidruhům',
		'Wikiknihy'   => 'Wikiknihám',
		'Wikipedie'   => 'Wikipediím',
		'Wikislovník' => 'Wikislovníkům',
		'Wikiverzita' => 'Wikiverzitám',
		'Wikizprávy'  => 'Wikizprávám',
		'Wikcionář'   => 'Wikislovníkům',
	),
	'4pl' => array(
		'uživatel'    => 'uživatele',
		'Wikibooks'   => 'Wikiknihy',
		'Wikinews'    => 'Wikizprávy',
		'Wikipedia'   => 'Wikipedie',
		'Wikiquote'   => 'Wikicitáty',
		'Wikispecies' => 'Wikidruhy',
		'Wikiversity' => 'Wikiverzity',
		'Wiktionary'  => 'Wikislovníky',
		'Wikislovník' => 'Wikislovníky',
		'Wikiverzita' => 'Wikiverzity',
		'Wikcionář'   => 'Wikislovníky',
	),
	'5pl' => array(
		'uživatel'    => 'uživatelé',
		'Wikibooks'   => 'Wikiknihy',
		'Wikinews'    => 'Wikizprávy',
		'Wikipedia'   => 'Wikipedie',
		'Wikiquote'   => 'Wikicitáty',
		'Wikispecies' => 'Wikidruhy',
		'Wikiversity' => 'Wikiverzity',
		'Wiktionary'  => 'Wikislovníky',
		'Wikislovník' => 'Wikislovníky',
		'Wikiverzita' => 'Wikiverzity',
		'Wikcionář'   => 'Wikislovníky',
	),
	'6pl' => array(
		'uživatel'    => 'uživatelích',
		'Wikibooks'   => 'Wikiknihách',
		'Wikinews'    => 'Wikizprávách',
		'Wikipedia'   => 'Wikipediích',
		'Wikiquote'   => 'Wikicitátech',
		'Wikispecies' => 'Wikidruzích',
		'Wikiversity' => 'Wikiverzitách',
		'Wiktionary'  => 'Wikislovnících',
		'Wikicitáty'  => 'Wikicitátech',
		'Wikidruhy'   => 'Wikidruzích',
		'Wikiknihy'   => 'Wikiknihách',
		'Wikipedie'   => 'Wikipediích',
		'Wikislovník' => 'Wikislovnících',
		'Wikiverzita' => 'Wikiverzitách',
		'Wikizprávy'  => 'Wikizprávách',
		'Wikcionář'   => 'Wikislovnících',
	),
	'7pl' => array(
		'uživatel'    => 'uživateli',
		'Wikibooks'   => 'Wikiknihami',
		'Wikinews'    => 'Wikizprávami',
		'Wikipedia'   => 'Wikipediemi',
		'Wikiquote'   => 'Wikicitáty',
		'Wikispecies' => 'Wikidruhy',
		'Wikiversity' => 'Wikiverzitami',
		'Wiktionary'  => 'Wikislovníky',
		'Wikiknihy'   => 'Wikiknihami',
		'Wikipedie'   => 'Wikipediemi',
		'Wikislovník' => 'Wikislovníky',
		'Wikiverzita' => 'Wikiverzitami',
		'Wikcionář'   => 'Wikislovníky',
	),
); # cs

$wgGrammarForms['dsb'] = array(
	# genitive
	'genitiw' => array(
		'Wikipedija'  => 'Wikipedije',
		'Wikiknihi'   => 'Wikiknih',
		'Wikinowiny'  => 'Wikinowin',
		'Wikižórło'   => 'Wikižórła',
		'Wikicitaty'  => 'Wikicitatow',
		'Wikisłownik' => 'Wikisłownika',
	),
	# dative
	'datiw' => array(
		'Wikipedija'  => 'Wikipediji',
		'Wikiknihi'   => 'Wikikniham',
		'Wikinowiny'  => 'Wikinowinam',
		'Wikižórło'   => 'Wikižórłu',
		'Wikicitaty'  => 'Wikicitatam',
		'Wikisłownik' => 'Wikisłownikej',
	),
	# akuzative
	'akuzativ' => array(
		'Wikipedija'  => 'Wikipediju',
		'Wikiknihi'   => 'Wikiknknihi',
	),
	# instrumental
	'instrumental' => array(
		'Wikipedija'  => 'Wikipediju',
		'Wikiknihi'   => 'Wikiknihami',
		'Wikinowiny'  => 'Wikinowinami',
		'Wikižórło'   => 'Wikižórłom',
		'Wikicitaty'  => 'Wikicitatami',
		'Wikisłownik' => 'Wikisłownikom',
	),
	# lokative
	'lokatiw' => array(
		'Wikipedija'  => 'Wikipediji',
		'Wikiknihi'   => 'Wikiknihach',
		'Wikinowiny'  => 'Wikinowinach',
		'Wikižórło'   => 'Wikižórłu',
		'Wikicitaty'  => 'Wikicitatach',
		'Wikisłownik' => 'Wikisłowniku',
	),
); # dsb

$wgGrammarForms['fi'] = array(
	'genitive' => array(
		'Wikiuutiset' => 'Wikiuutisten',
		'Wikisitaatit' => 'Wikisitaattien',
	),
	'partitive' => array(
		'Wikiuutiset' => 'Wikiuutisia',
		'Wikisitaatit' => 'Wikisitaatteja',
	),
	'elative' => array(
		'Wikiuutiset' => 'Wikiuutisista',
		'Wikisitaatit' => 'Wikisitaateista',
	),
	'inessive' => array(
		'Wikiuutiset' => 'Wikiuutisissa',
		'Wikisitaatit' => 'Wikisitaateissa',
	),
	'illative' => array(
		'Wikiuutiset' => 'Wikiuutisiin',
		'Wikisitaatit' => 'Wikisitaatteihin',
	),
); # fi

$wgGrammarForms['ga'] = array(
	'genitive' => array(
		'Vicipéid'     => 'Vicipéide',
		'Vicífhoclóir' => 'Vicífhoclóra',
		'Vicíleabhair' => 'Vicíleabhar',
		'Vicíshliocht' => 'Vicíshleachta',
		'Vicífhoinse'  => 'Vicífhoinse',
		'Vicíghnéithe' => 'Vicíghnéithe',
		'Vicínuacht'   => 'Vicínuachta',
	),
); # ga

$wgGrammarForms['gsw'] = array(
	# dative
	'dativ' => array(
		'Wikipedia'       => 'vo de Wikipedia',
		'Wikinorchrichte' => 'vo de Wikinochrichte',
		'Wiktionaire'     => 'vom Wiktionaire',
		'Wikibuecher'     => 'vo de Wikibuecher',
		'Wikisprüch'      => 'vo de Wikisprüch',
		'Wikiquälle'      => 'vo de Wikiquälle',
	),
	# accusative
	'akkusativ' => array(
		'Wikipedia'       => 'd Wikipedia',
		'Wikinorchrichte' => 'd Wikinorchrichte',
		'Wiktionaire'     => 's Wiktionaire',
		'Wikibuecher'     => 'd Wikibuecher',
		'Wikisprüch'      => 'd Wikisprüch',
		'Wikiquälle'      => 'd Wikiquälle',
	),
	# nominative
	'nominativ' => array(
		'Wikipedia'       => 'd Wikipedia',
		'Wikinorchrichte' => 'd Wikinorchrichte',
		'Wiktionaire'     => 's Wiktionaire',
		'Wikibuecher'     => 'd Wikibuecher',
		'Wikisprüch'      => 'd Wikisprüch',
		'Wikiquälle'      => 'd Wikiquälle',
	),
); # gsw

$wgGrammarForms['hsb'] = array(
	# genitive
	'genitiw' => array(
		'Wikipedija'  => 'Wikipedije',
		'Wikiknihi'   => 'Wikiknih',
		'Wikinowiny'  => 'Wikinowin',
		'Wikižórło'   => 'Wikižórła',
		'Wikicitaty'  => 'Wikicitatow',
		'Wikisłownik' => 'Wikisłownika',
	),
	# dative
	'datiw' => array(
		'Wikipedija'  => 'Wikipediji',
		'Wikiknihi'   => 'Wikikniham',
		'Wikinowiny'  => 'Wikinowinam',
		'Wikižórło'   => 'Wikižórłu',
		'Wikicitaty'  => 'Wikicitatam',
		'Wikisłownik' => 'Wikisłownikej',
	),
	# akuzative
	'akuzativ' => array(
		'Wikipedija'  => 'Wikipediju',
		'Wikiknihi'   => 'Wikiknknihi',
	),
	# instrumental
	'instrumental' => array(
		'Wikipedija'  => 'Wikipediju',
		'Wikiknihi'   => 'Wikiknihami',
		'Wikinowiny'  => 'Wikinowinami',
		'Wikižórło'   => 'Wikižórłom',
		'Wikicitaty'  => 'Wikicitatami',
		'Wikisłownik' => 'Wikisłownikom',
	),
	# lokative
	'lokatiw' => array(
		'Wikipedija'  => 'Wikipediji',
		'Wikiknihi'   => 'Wikiknihach',
		'Wikinowiny'  => 'Wikinowinach',
		'Wikižórło'   => 'Wikižórłu',
		'Wikicitaty'  => 'Wikicitatach',
		'Wikisłownik' => 'Wikisłowniku',
	),
); # hsb

$wgGrammarForms['hu'] = array(
	'rol' => array(
		'Wikipédia'   => 'Wikipédiáról',
		'Wikidézet'   => 'Wikidézetről',
		'Wikiszótár'  => 'Wikiszótárról',
		'Wikikönyvek' => 'Wikikönyvekről',
	),
	'ba' => array(
		'Wikipédia'   => 'Wikipédiába',
		'Wikidézet'   => 'Wikidézetbe',
		'Wikiszótár'  => 'Wikiszótárba',
		'Wikikönyvek' => 'Wikikönyvekbe',
	),
	'k' => array(
		'Wikipédia'   => 'Wikipédiák',
		'Wikidézet'   => 'Wikidézetek',
		'Wikiszótár'  => 'Wikiszótárak',
	),
); # hu

$wgGrammarForms['la'] = array(
	'genitive' => array(
		'Vicifons' => 'Vicifontis'
	),
); # la

$wgGrammarForms['lv'] = array(
	'ģenitīvs' => array(
		'Vikipēdija'   => 'Vikipēdijas',
		'Vikivārdnīca' => 'Vikivārdnīcas',
	),
	'datīvs' => array(
		'Vikipēdija'   => 'Vikipēdijai',
		'Vikivārdnīca' => 'Vikivārdnīcai',
	),
	'akuzatīvs' => array(
		'Vikipēdija'   => 'Vikipēdiju',
		'Vikivārdnīca' => 'Vikivārdnīcu',
	),
	'lokatīvs' => array(
		'Vikipēdija'   => 'Vikipēdijā',
		'Vikivārdnīca' => 'Vikivārdnīcā',
	),
); # lv

$wgGrammarForms['pl'] = array(
	'D.lp' => array(
		'wikipedysta'  => 'wikipedysty',
		'Wikicytaty'   => 'Wikicytatów',
		'Wikipedia'    => 'Wikipedii',
		'Wikisłownik'  => 'Wikisłownika',
		'Wikiźródła'   => 'Wikiźródeł',
		'użytkownik'   => 'użytkownika',
		'wikipedysta'  => 'wikipedysty',
		'wikireporter' => 'wikireportera',
		'wikiskryba'   => 'wikiskryby',
	),
	'C.lp' => array(
		'wikipedysta'  => 'wikipedyście',
		'Wikicytaty'   => 'Wikicytatom',
		'Wikipedia'    => 'Wikipedii',
		'Wikisłownik'  => 'Wikisłownikowi',
		'Wikiźródła'   => 'Wikiźródłom',
		'użytkownik'   => 'użytkownikowi',
		'wikipedysta'  => 'wikipedyście',
		'wikireporter' => 'wikireporterowi',
		'wikiskryba'   => 'wikiskrybie',
	),
	'B.lp' => array(
		'wikipedysta'  => 'wikipedystę',
		'Wikipedia'    => 'Wikipedię',
		'użytkownik'   => 'użytkownika',
		'wikipedysta'  => 'wikipedystę',
		'wikireporter' => 'wikireportera',
		'wikiskryba'   => 'wikiskrybę',
	),
	'N.lp' => array(
		'wikipedysta'  => 'wikipedystą',
		'Wikicytaty'   => 'Wikicytatami',
		'Wikipedia'    => 'Wikipedią',
		'Wikisłownik'  => 'Wikisłownikiem',
		'Wikiźródła'   => 'Wikiźródłami',
		'użytkownik'   => 'użytkownikiem',
		'wikipedysta'  => 'wikipedystą',
		'wikireporter' => 'wikireporterem',
		'wikiskryba'   => 'wikiskrybą',
	),
	'MS.lp' => array(
		'wikipedysta'  => 'wikipedyście',
		'Wikicytaty'   => 'Wikicytatach',
		'Wikipedia'    => 'Wikipedii',
		'Wikisłownik'  => 'Wikisłowniku',
		'Wikiźródła'   => 'Wikiźródłach',
		'użytkownik'   => 'użytkowniku',
		'wikipedysta'  => 'wikipedyście',
		'wikireporter' => 'wikireporterze',
		'wikiskryba'   => 'wikiskrybie',
	),
	'W.lp' => array(
		'wikipedysta'  => 'Wikipedysto',
		'Wikipedia'    => 'Wikipedio',
		'Wikisłownik'  => 'Wikisłowniku',
		'użytkownik'   => 'Użytkowniku',
		'wikipedysta'  => 'Wikipedysto',
		'wikireporter' => 'Wikireporterze',
		'wikiskryba'   => 'Wikiskrybo',
	),
	'M.lm' => array(
		'wikipedysta'  => 'wikipedyści',
		'użytkownik'   => 'użytkownicy',
		'wikipedysta'  => 'wikipedyści',
		'wikireporter' => 'wikireporterzy',
		'wikiskryba'   => 'wikiskrybowie',
	),
	'D.lm' => array(
		'wikipedysta'  => 'wikipedystów',
		'użytkownik'   => 'użytkowników',
		'wikipedysta'  => 'wikipedystów',
		'wikireporter' => 'wikireporterów',
		'wikiskryba'   => 'wikiskrybów',
	),
	'C.lm' => array(
		'wikipedysta'  => 'wikipedystom',
		'użytkownik'   => 'użytkownikom',
		'wikipedysta'  => 'wikipedystom',
		'wikireporter' => 'wikireporterom',
		'wikiskryba'   => 'wikiskrybom',
	),
	'B.lm' => array(
		'wikipedysta'  => 'wikipedystów',
		'użytkownik'   => 'użytkowników',
		'wikipedysta'  => 'wikipedystów',
		'wikireporter' => 'wikireporterów',
		'wikiskryba'   => 'wikiskrybów',
	),
	'N.lm' => array(
		'wikipedysta'  => 'wikipedystami',
		'użytkownik'   => 'użytkownikami',
		'wikipedysta'  => 'wikipedystami',
		'wikireporter' => 'wikireporterami',
		'wikiskryba'   => 'wikiskrybami',
	),
	'MS.lm' => array(
		'wikipedysta'  => 'wikipedystach',
		'użytkownik'   => 'użytkownikach',
		'wikipedysta'  => 'wikipedystach',
		'wikireporter' => 'wikireporterach',
		'wikiskryba'   => 'wikiskrybach',
	),
	'W.lm' => array(
		'wikipedysta'  => 'Wikipedyści',
		'użytkownik'   => 'Użytkownicy',
		'wikipedysta'  => 'Wikipedyści',
		'wikireporter' => 'Wikireporterzy',
		'wikiskryba'   => 'Wikiskrybowie',
	),
); # pl

$wgGrammarForms['rmy'] = array(
	# genitive (m.sg.)
	'genitive-m-sg' => array(
		'Vikipidiya' => 'Vikipidiyako',
		'Vikcyonaro' => 'Vikcyonaresko',
	),
	# genitive (f.sg.)
	'genitive-f-sg' => array(
		'Vikipidiya' => 'Vikipidiyaki',
		'Vikcyonaro' => 'Vikcyonareski',
	),
	# genitive (pl.)
	'genitive-pl' => array(
		'Vikipidiya' => 'Vikipidiyake',
		'Vikcyonaro' => 'Vikcyonareske',
	),
	# dative
	'dativ' => array(
		'Vikipidiya' => 'Wikipediji',
		'Vikcyonaro' => 'Vikcyonareske',
	),
	# locative
	'locative' => array(
		'Vikipidiya' => 'Wikipedijo',
		'Vikcyonaro' => 'Vikcyonareste',
	),
	# ablative
	'ablative' => array(
		'Vikipidiya' => 'o Wikipediji',
		'Vikcyonaro' => 'Vikcyonarestar',
	),
	# instrumental
	'instrumental' => array(
		'Vikipidiya' => 'z Wikipedijo',
		'Vikcyonaro' => 'Vikcyonaresa',
	),
); # rmy

$wgGrammarForms['sk'] = array(
	'genitív' => array(
		'Wikipédia'   => 'Wikipédie',
		'Wikislovník' => 'Wikislovníku',
		'Wikicitáty'  => 'Wikicitátov',
		'Wikiknihy'   => 'Wikikníh',
	),
	'datív' => array(
		'Wikipédia'   => 'Wikipédii',
		'Wikislovník' => 'Wikislovníku',
		'Wikicitáty'  => 'Wikicitátom',
		'Wikiknihy'   => 'Wikiknihám',
	),
	'akuzatív' => array(
		'Wikipédia'   => 'Wikipédiu',
		'Wikislovník' => 'Wikislovník',
		'Wikicitáty'  => 'Wikicitáty',
		'Wikiknihy'   => 'Wikiknihy',
	),
	'lokál' => array(
		'Wikipédia'   => 'Wikipédii',
		'Wikislovník' => 'Wikislovníku',
		'Wikicitáty'  => 'Wikicitátoch',
		'Wikiknihy'   => 'Wikiknihách',
	),
	'inštrumentál' => array(
		'Wikipédia'   => 'Wikipédiou',
		'Wikislovník' => 'Wikislovníkom',
		'Wikicitáty'  => 'Wikicitátmi',
		'Wikiknihy'   => 'Wikiknihami',
	),
); # sk

$wgGrammarForms['sl'] = array(
	# genitive
	'rodilnik' => array(
		'Wikipedija'  => 'Wikipedije',
		'Wikiknjige'  => 'Wikiknjig',
		'Wikinovice'  => 'Wikinovic',
		'Wikinavedek' => 'Wikinavedka',
		'Wikivir'     => 'Wikivira',
		'Wikislovar'  => 'Wikislovarja',
	),
	# dative
	'dajalnik' => array(
		'Wikipedija'  => 'Wikipediji',
		'Wikiknjige'  => 'Wikiknjigam',
		'Wikinovice'  => 'Wikinovicam',
		'Wikinavedek' => 'Wikinavedku',
		'Wikivir'     => 'Wikiviru',
		'Wikislovar'  => 'Wikislovarju',
	),
	# accusative
	'tožilnik' => array(
		'Wikipedija'  => 'Wikipedijo',
		# no need to transform the others
	),
	# locative
	'mestnik' => array(
		'Wikipedija'  => 'o Wikipediji',
		'Wikiknjige'  => 'o Wikiknjigah',
		'Wikinovice'  => 'o Wikinovicah',
		'Wikinavedek' => 'o Wikinavedku',
		'Wikivir'     => 'o Wikiviru',
		'Wikislovar'  => 'o Wikislovarju',
	),
	# instrumental
	'orodnik' => array(
		'Wikipedija'  => 'z Wikipedijo',
		'Wikiknjige'  => 'z Wikiknjigami',
		'Wikinovice'  => 'z Wikinovicami',
		'Wikinavedek' => 'z Wikinavedkom',
		'Wikivir'     => 'z Wikivirom',
		'Wikislovar'  => 'z Wikislovarjem',
	),
); # sl
