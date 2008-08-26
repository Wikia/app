<?php

$messages = array(
// English Version by Rob Church
	'en' => array(
	'editcount' => 'Edit count',
	'editcount_username' => 'User:',
	'editcount_submit' => 'Submit',
	'editcount_total' => 'Total',
	'editcount_allwikis' => 'All wikis',
	),

/* Arabic (Meno25) */
	'ar' => array(
	'editcount' => 'عداد المساهمات',
	'editcount_username' => 'مستخدم:',
	'editcount_submit' => 'تنفيذ',
	'editcount_total' => 'الإجمالي',
	),

'bcl' => array(
'editcount' => 'Hirahón an bilang',
'editcount_submit' => 'Isumitir',
),

'bn' => array(
'editcount' => 'সম্পাদনা সংখ্যা',
'editcount_username' => 'ব্যবহারকারী:',
'editcount_submit' => 'পেশ করো',
'editcount_total' => 'সর্বমোট',
),

'br' => array(
'editcount' => 'Sammad degasadennoù',
'editcount_username' => 'Implijer :',
'editcount_submit' => 'Kas',
'editcount_total' => 'Hollad',
),

'ca' => array(
'editcount' => 'Comptador d\'edicions',
'editcount_username' => 'Usuari:',
),

// German by Leon Weber
	'de' => array(
	'editcount' => 'Anzahl der Seitenbearbeitungen',
	'editcount_username' => 'Benutzer:',
	'editcount_submit' => 'Absenden',
	'editcount_total' => 'Gesamt',
	),

'ext' => array(
'editcount_username' => 'Usuáriu:',
),

// French Version by Bertrand Grondin
	'fr' => array(
	'editcount' => 'Compteur d’éditions individuel',
	'editcount_username' => 'Utilisateur :',
	'editcount_submit' => 'Soumettre',
	'editcount_total' => 'Total',
	),

'hsb' => array(
'editcount' => 'Ličba změnow',
'editcount_username' => 'Wužiwar:',
'editcount_submit' => 'OK',
'editcount_total' => 'dohromady',
),

// Indonesian Version by Ivan Lanin
	'id' => array(
	'editcount' => 'Jumlah suntingan',
	'editcount_username' => 'Pengguna:',
	'editcount_submit' => 'Kirim',
	'editcount_total' => 'Total',
	),

// Italian Version by BrokenArrow
	'it' => array(
	'editcount' => 'Conteggio delle modifiche',
	'editcount_username' => 'Utente:',
	'editcount_submit' => 'Invia',
	'editcount_total' => 'Totale',
	),

'la' => array(
'editcount_username' => 'Usor:',
),

// nld / Dutch version by Siebrand Mazeland
	'nl' => array(
	'editcount' => 'Bewerkingsteller',
	'editcount_username' => 'Gebruiker:',
	'editcount_submit' => 'OK',
	'editcount_total' => 'Totaal',
	),

// Norwegian (Jon Harald Søby)
	'no' => array(
	'editcount' => 'Redigeringsteller',
	'editcount_username' => 'Bruker:',
	'editcount_submit' => 'OK',
	'editcount_total' => 'Totalt',
	),

// Occitan by Cedric31
	'oc' => array(
	'editcount' => 'Comptaire d\'edicions individual',
	'editcount_username' => 'Utilizaire:',
	'editcount_submit' => 'Sometre',
	),

/* Piedmontese (Bèrto 'd Sèra) */
	'pms' => array(
	'editcount' => 'Total dle modìfiche',
	'editcount_username' => 'Stranòm:',
	'editcount_submit' => 'Manda',
	'editcount_total' => 'Total',
	),

// Portuguese (Lugusto)
	'pt' => array(
	'editcount' => 'Contador de edições',
	'editcount_username' => 'Usuário:',
	'editcount_submit' => 'Enviar',
	'editcount_total' => 'Total',
	),

// Slovak version by helix84
	'sk' => array(
	'editcount' => 'Počet príspevkov',
	'editcount_username' => 'Používateľ:',
	'editcount_submit' => 'Odoslať',
	'editcount_total' => 'Celkom',
	),

// Serbian default version by Sasa Stefanovic
	'sr' => array(
	'editcount' => 'Бројач измена',
	'editcount_username' => 'Корисник:',
	'editcount_submit' => 'Унеси',
	'editcount_total' => 'Укупно',
	),

// Serbian cyrillic version by Sasa Stefanovic
	'sr-ec' => array(
	'editcount' => 'Бројач измена',
	'editcount_username' => 'Корисник:',
	'editcount_submit' => 'Унеси',
	'editcount_total' => 'Укупно',
	),

// Serbian latin version by Sasa Stefanovic
	'sr-el' => array(
	'editcount' => 'Brojač izmena',
	'editcount_username' => 'Korisnik:',
	'editcount_submit' => 'Unesi',
	'editcount_total' => 'Ukupno',
	),

// Cantonese Version by Shinjiman
	'yue' => array(
	'editcount' => '編輯次數',
	'editcount_username' => '用戶:',
	'editcount_submit' => '遞交',
	'editcount_total' => '總數',
	),

// Chinese (Simplified) Version by Shinjiman
	'zh-hans' => array(
	'editcount' => '编辑次数',
	'editcount_username' => '用户:',
	'editcount_submit' => '提交',
	'editcount_total' => '总数',
	),

// Chinese (Traditional) Version by Shinjiman
	'zh-hant' => array(
	'editcount' => '編輯次數',
	'editcount_username' => '用戶:',
	'editcount_submit' => '遞交',
	'editcount_total' => '總數',
	),
);

	/* Chinese defaults, fallback to zh-hans or zh-hant */
	$messages['zh'] = $messages['zh-hans'];
	$messages['zh-cn'] = $messages['zh-hans'];
	$messages['zh-hk'] = $messages['zh-hant'];
	$messages['zh-cn'] = $messages['zh-hans'];
	$messages['zh-tw'] = $messages['zh-hant'];
	/* Cantonese default, fallback to zh-hans or zh-hant */
	$messages['zh-yue'] = $messages['yue'];

