<?php
/**
 * Aliases for Special:GlobalBlock
 *
 * @addtogroup Extensions
 */

$aliases = array();

/** English
 * @author Jon Harald Søby
 */
$aliases['en'] = array(
	'GlobalBlock'     => array( 'GlobalBlock' ),
	'GlobalBlockList' => array( 'GlobalBlockList' ),
	'RemoveGlobalBlock' => array( 'GlobalUnblock', 'RemoveGlobalBlock' ),
	'GlobalBlockStatus' => array( 'GlobalBlockWhitelist', 'GlobalBlockStatus', 'DisableGlobalBlock' ),
);

/** Arabic (العربية)
 * @author Meno25
 */
$aliases['ar'] = array(
	'GlobalBlock' => array( 'منع_عام' ),
	'GlobalBlockList' => array( 'قائمة_منع_عامة' ),
	'RemoveGlobalBlock' => array( 'رفع_منع_عام', 'إزالة_منع_عام' ),
	'GlobalBlockStatus' => array( 'قائمة_المنع_العام_البيضاء', 'حالة_المنع_العام', 'تعطيل_المنع_العام' ),
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$aliases['arz'] = array(
	'GlobalBlock' => array( 'منع_عام' ),
	'GlobalBlockList' => array( 'قائمة_منع_عامة' ),
	'RemoveGlobalBlock' => array( 'رفع_منع_عام', 'إزالة_منع_عام' ),
	'GlobalBlockStatus' => array( 'قايمة_المنع_العام_البيضاء', 'حالة_المنع_العام', 'تعطيل_المنع_العام' ),
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца)) */
$aliases['be-tarask'] = array(
	'GlobalBlock' => array( 'Глябальнае_блякаваньне' ),
	'GlobalBlockList' => array( 'Сьпіс_глябальных_блякаваньняў' ),
);

/** Bosnian (Bosanski) */
$aliases['bs'] = array(
	'GlobalBlock' => array( 'GlobalnoBlokiranje' ),
	'GlobalBlockList' => array( 'ListaGlobalnogBlokiranja' ),
	'RemoveGlobalBlock' => array( 'GlobalnoDeblokiranje', 'UklanjanjeGlobalnogBlokiranja' ),
	'GlobalBlockStatus' => array( 'GlobalniDopusteniSpisak' ),
);

/** German (Deutsch) */
$aliases['de'] = array(
	'GlobalBlock' => array( 'Globale Sperre' ),
	'GlobalBlockList' => array( 'Liste globaler Sperren' ),
	'RemoveGlobalBlock' => array( 'Globale Sperre aufheben' ),
	'GlobalBlockStatus' => array( 'Ausnahme von globaler Sperre' ),
);

/** Finnish (Suomi) */
$aliases['fi'] = array(
	'GlobalBlock' => array( 'Globaaliesto' ),
	'GlobalBlockList' => array( 'Globaaliestojen lista' ),
	'RemoveGlobalBlock' => array( 'Poista globaaliesto' ),
);

/** French (Français) */
$aliases['fr'] = array(
	'GlobalBlock' => array( 'BlocageGlobal' ),
);

/** Galician (Galego) */
$aliases['gl'] = array(
	'GlobalBlock' => array( 'Bloqueo global' ),
	'GlobalBlockList' => array( 'Lista de bloqueos globais', 'Listaxe de bloqueos globais' ),
	'RemoveGlobalBlock' => array( 'Desbloqueo global' ),
);

/** Swiss German (Alemannisch) */
$aliases['gsw'] = array(
	'GlobalBlock' => array( 'Wältwyti Sperri' ),
	'GlobalBlockList' => array( 'Lischt vu wältwyte Sperrine' ),
	'RemoveGlobalBlock' => array( 'Wältwyti Sperri uffhebe' ),
	'GlobalBlockStatus' => array( 'Uusnahme vun ere wältwyte Sperri' ),
);

/** Hebrew (עברית)
 * @author Rotem Liss
 */
$aliases['he'] = array(
	'GlobalBlock' => array( 'חסימה_גלובלית' ),
	'GlobalBlockList' => array( 'רשימת_חסומים_גלובליים' ),
	'RemoveGlobalBlock' => array( 'שחרור_חסימה_גלובלית', 'הסרת_חסימה_גלובלית' ),
	'GlobalBlockStatus' => array( 'רשימה_לבנה_לחסימה_גלובלית', 'מצב_חסימה_גלובלית', 'ביטול_חסימה_גלובלית' ),
);

/** Croatian (Hrvatski) */
$aliases['hr'] = array(
	'GlobalBlock' => array( 'Globalno_blokiraj' ),
	'GlobalBlockList' => array( 'Globalno_blokirane_adrese' ),
	'RemoveGlobalBlock' => array( 'Ukloni_globalno_blokiranje', 'Globalno_odblokiraj' ),
	'GlobalBlockStatus' => array( 'Status_globalnog_blokiranja' ),
);

/** Haitian (Kreyòl ayisyen) */
$aliases['ht'] = array(
	'GlobalBlock' => array( 'BlokajGlobal' ),
);

/** Hungarian (Magyar) */
$aliases['hu'] = array(
	'GlobalBlock' => array( 'Globális blokkolás' ),
	'GlobalBlockList' => array( 'Globális blokkok listája' ),
	'RemoveGlobalBlock' => array( 'Globális feloldás' ),
);

/** Indonesian (Bahasa Indonesia) */
$aliases['id'] = array(
	'GlobalBlock' => array( 'Pemblokiran global' ),
	'GlobalBlockList' => array( 'Daftar pemblokiran global' ),
	'RemoveGlobalBlock' => array( 'Batal pemblokiran global' ),
	'GlobalBlockStatus' => array( 'Daftar pemblokiran global nonaktif' ),
);

/** Japanese (日本語) */
$aliases['ja'] = array(
	'GlobalBlock' => array( 'グローバルブロック', 'グローバル・ブロック' ),
	'GlobalBlockList' => array( 'グローバルブロック一覧', 'グローバル・ブロック一覧' ),
	'RemoveGlobalBlock' => array( 'グローバルブロック解除', 'グローバル・ブロック解除' ),
	'GlobalBlockStatus' => array( 'グローバルブロック無効', 'グローバルブロックホワイトリスト' ),
);

/** Korean (한국어) */
$aliases['ko'] = array(
	'GlobalBlock' => array( '전체차단' ),
	'GlobalBlockList' => array( '전체차단목록' ),
	'RemoveGlobalBlock' => array( '전체차단취소', '전체차단해제' ),
);

/** Luxembourgish (Lëtzebuergesch) */
$aliases['lb'] = array(
	'GlobalBlock' => array( 'Global Spären' ),
	'GlobalBlockList' => array( 'Lëscht vun de globale Spären' ),
	'RemoveGlobalBlock' => array( 'Global Spär ophiewen' ),
	'GlobalBlockStatus' => array( 'Ausnahme vun der globaler Spär' ),
);

/** Macedonian (Македонски) */
$aliases['mk'] = array(
	'GlobalBlock' => array( 'ГлобалноБлокирање' ),
	'GlobalBlockList' => array( 'ЛистаНаГлобалниБлокирања' ),
	'RemoveGlobalBlock' => array( 'ГлобалниДеблокирања', 'БришиГлобаленБлок' ),
	'GlobalBlockStatus' => array( 'СтатусНаГлобаленБлок', 'ОневозможиГлобаленБлок' ),
);

/** Malay (Bahasa Melayu) */
$aliases['ms'] = array(
	'GlobalBlock' => array( 'Sekatan sejagat' ),
	'GlobalBlockList' => array( 'Senarai sekatan sejagat' ),
	'RemoveGlobalBlock' => array( 'Batal sekatan sejagat' ),
	'GlobalBlockStatus' => array( 'Senarai putih sekatan sejagat' ),
);

/** Maltese (Malti) */
$aliases['mt'] = array(
	'GlobalBlock' => array( 'BlokkGlobali' ),
	'GlobalBlockList' => array( 'ListaBlokkGlobali' ),
);

/** Nedersaksisch (Nedersaksisch) */
$aliases['nds-nl'] = array(
	'GlobalBlock' => array( 'Globaal_blokkeren' ),
	'GlobalBlockList' => array( 'Globale_blokkeerlieste' ),
	'RemoveGlobalBlock' => array( 'Globaal_deblokkeren' ),
	'GlobalBlockStatus' => array( 'Witte_lieste_blokkeringen' ),
);

/** Dutch (Nederlands) */
$aliases['nl'] = array(
	'GlobalBlock' => array( 'GlobaalBlokkeren' ),
	'GlobalBlockList' => array( 'GlobaleBlokkadelijst', 'GlobaleBlokkeerlijst' ),
	'RemoveGlobalBlock' => array( 'GlobaalDeblokkeren', 'GlobaleBlokkadeVerwijderen' ),
	'GlobalBlockStatus' => array( 'WitteLijstGlobaleBlokkades', 'GlobaleBlokkadestatus' ),
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$aliases['no'] = array(
	'GlobalBlock' => array( 'Blokker globalt', 'Global blokkering' ),
	'GlobalBlockList' => array( 'Global blokkeringsliste' ),
	'RemoveGlobalBlock' => array( 'Avblokker globalt', 'Global avblokkering' ),
	'GlobalBlockStatus' => array( 'Hviteliste for global blokkering' ),
);

/** Occitan (Occitan) */
$aliases['oc'] = array(
	'GlobalBlock' => array( 'Blocatge global', 'BlocatgeGlobal' ),
	'RemoveGlobalBlock' => array( 'Desblocatge global', 'DesblocatgeGlobal' ),
);

/** Polish (Polski) */
$aliases['pl'] = array(
	'GlobalBlock' => array( 'Zablokuj globalnie' ),
	'GlobalBlockList' => array( 'Spis globalnie zablokowanych adresów IP' ),
	'RemoveGlobalBlock' => array( 'Odblokuj globalnie' ),
	'GlobalBlockStatus' => array( 'Lokalny status globalnych blokad' ),
);

/** Pashto (پښتو) */
$aliases['ps'] = array(
	'GlobalBlock' => array( 'نړېوال بنديزونه' ),
);

/** Portuguese (Português) */
$aliases['pt'] = array(
	'GlobalBlock' => array( 'Bloquear globalmente' ),
);

/** Brazilian Portuguese (Português do Brasil) */
$aliases['pt-br'] = array(
	'GlobalBlock' => array( 'Bloquear globalmente' ),
);

/** Swedish (Svenska) */
$aliases['sv'] = array(
	'GlobalBlock' => array( 'Global blockering' ),
	'GlobalBlockList' => array( 'Global blockeringslista' ),
	'RemoveGlobalBlock' => array( 'Global avblockering' ),
);

