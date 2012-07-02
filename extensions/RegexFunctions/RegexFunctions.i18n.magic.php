<?php
/**
 *
 */

$magicWords = array();

/** English (English) */
$magicWords['en'] = array(
	'rmatch' => array( 0, 'rmatch' ),
	'rsplit' => array( 0, 'rsplit' ),
	'rreplace' => array( 0, 'rreplace' ),
);

/** Arabic (العربية) */
$magicWords['ar'] = array(
	'rmatch' => array( 0, 'مطابقة_ريجيكس' ),
	'rsplit' => array( 0, 'فصل_ريجيكس' ),
	'rreplace' => array( 0, 'استبدال_ريجيكس' ),
);

/** Japanese (日本語) */
$magicWords['ja'] = array(
	'rmatch' => array( 0, '正規表現一致' ),
	'rsplit' => array( 0, '正規表現分割' ),
	'rreplace' => array( 0, '正規表現置き換え' ),
);

/** Macedonian (Македонски) */
$magicWords['mk'] = array(
	'rmatch' => array( 0, 'рсовпадни' ),
	'rsplit' => array( 0, 'родвој' ),
	'rreplace' => array( 0, 'рзамени' ),
);

/** Nedersaksisch (Nedersaksisch) */
$magicWords['nds-nl'] = array(
	'rmatch' => array( 0, 'rvergelieken' ),
);

/** Dutch (Nederlands) */
$magicWords['nl'] = array(
	'rmatch' => array( 0, 'rvergelijken' ),
	'rsplit' => array( 0, 'rsplitsen' ),
	'rreplace' => array( 0, 'rvervangen' ),
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬) */
$magicWords['sr-ec'] = array(
	'rmatch' => array( 0, 'рпоклопи' ),
	'rsplit' => array( 0, 'рраздвоји', 'рподели' ),
	'rreplace' => array( 0, 'рзамени' ),
);

/** Serbian (Latin script) (‪Srpski (latinica)‬) */
$magicWords['sr-el'] = array(
	'rmatch' => array( 0, 'rpoklopi' ),
	'rsplit' => array( 0, 'rrazdvoji', 'rpodeli' ),
	'rreplace' => array( 0, 'rzameni' ),
);