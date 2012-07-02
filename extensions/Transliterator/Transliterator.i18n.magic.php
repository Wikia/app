<?php
/**
 *
 */

$magicWords = array();

/** English (English) */
$magicWords['en'] = array(
	'transliterate' => array( 'transliterate' ),
	'tr_prefix' => array( '1', 'Transliterator:' ),
	'tr_decompose' => array( '__DECOMPOSE__' ),
);

/** Afrikaans (Afrikaans) */
$magicWords['af'] = array(
	'transliterate' => array( 'translitereer', 'transliterate' ),
	'tr_prefix' => array( '1', 'Translitereerder:', 'Transliterator:' ),
);

/** Arabic (العربية) */
$magicWords['ar'] = array(
	'transliterate' => array( 'ترجمة_حرفية' ),
	'tr_prefix' => array( 'مترجم_حرفي:' ),
	'tr_decompose' => array( '__تحلل__' ),
);

/** Egyptian Spoken Arabic (مصرى) */
$magicWords['arz'] = array(
	'transliterate' => array( 'ترجمة_حرفية', 'transliterate' ),
	'tr_prefix' => array( '1', 'مترجم_حرفي:', 'Transliterator:' ),
	'tr_decompose' => array( '__تحلل__', '__DECOMPOSE__' ),
);

/** Breton (Brezhoneg) */
$magicWords['br'] = array(
	'transliterate' => array( 'treuzlizherennañ' ),
);

/** Chechen (Нохчийн) */
$magicWords['ce'] = array(
	'transliterate' => array( 'хийцайозанца', 'транслитерация', 'transliterate' ),
);

/** Spanish (Español) */
$magicWords['es'] = array(
	'transliterate' => array( 'transliterar' ),
);

/** Japanese (日本語) */
$magicWords['ja'] = array(
	'transliterate' => array( '翻字' ),
	'tr_prefix' => array( '翻字機能:' ),
	'tr_decompose' => array( '__分解__' ),
);

/** Macedonian (Македонски) */
$magicWords['mk'] = array(
	'transliterate' => array( 'транслитерирај' ),
	'tr_prefix' => array( 'Траслитератор:' ),
	'tr_decompose' => array( '__РАЗЛОЖИ__' ),
);

/** Malayalam (മലയാളം) */
$magicWords['ml'] = array(
	'transliterate' => array( 'ലിപിമാറ്റംചെയ്യുക', 'ലിപ്യന്തരണം', 'ലിപിമാറ്റം' ),
	'tr_prefix' => array( 'ലിപിമാറ്റയുപകരണം:' ),
	'tr_decompose' => array( '__ശിഥിലീകരിക്കുക__' ),
);

/** Marathi (मराठी) */
$magicWords['mr'] = array(
	'transliterate' => array( 'लिप्यांतर', 'transliterate' ),
);

/** Dutch (Nederlands) */
$magicWords['nl'] = array(
	'transliterate' => array( 'translitereren' ),
);

/** Oriya (ଓଡ଼ିଆ) */
$magicWords['or'] = array(
	'transliterate' => array( 'ଟ୍ରାନ୍ସଲିଟରେସନ' ),
	'tr_prefix' => array( 'ଟ୍ରାନ୍ସଲିଟରେସନକାରି' ),
);

/** Portuguese (Português) */
$magicWords['pt'] = array(
	'transliterate' => array( 'transliterar', 'transliterate' ),
	'tr_prefix' => array( '1', 'Transliterador:', 'Transliterator:' ),
);

/** Russian (Русский) */
$magicWords['ru'] = array(
	'transliterate' => array( 'транслитерация' ),
	'tr_prefix' => array( 'Транслитератор:' ),
	'tr_decompose' => array( '__РАЗОБРАТЬ__' ),
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬) */
$magicWords['sr-ec'] = array(
	'transliterate' => array( 'пресловљавање' ),
	'tr_prefix' => array( 'Пресловљавач:' ),
);

/** Serbian (Latin script) (‪Srpski (latinica)‬) */
$magicWords['sr-el'] = array(
	'transliterate' => array( 'preslovljavanje' ),
	'tr_prefix' => array( 'Preslovljivač:' ),
);

/** Vietnamese (Tiếng Việt) */
$magicWords['vi'] = array(
	'transliterate' => array( 'chuyểntự' ),
);