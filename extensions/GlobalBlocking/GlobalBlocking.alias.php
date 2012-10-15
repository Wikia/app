<?php
/**
 * Aliases for Special:GlobalBlock
 *
 * @file
 * @ingroup Extensions
 */

$specialPageAliases = array();

/** English (English) */
$specialPageAliases['en'] = array(
	'GlobalBlock' => array( 'GlobalBlock' ),
	'GlobalBlockList' => array( 'GlobalBlockList' ),
	'RemoveGlobalBlock' => array( 'GlobalUnblock', 'RemoveGlobalBlock' ),
	'GlobalBlockStatus' => array( 'GlobalBlockWhitelist', 'GlobalBlockStatus', 'DisableGlobalBlock' ),
);

/** Arabic (العربية) */
$specialPageAliases['ar'] = array(
	'GlobalBlock' => array( 'منع_عام' ),
	'GlobalBlockList' => array( 'قائمة_منع_عامة' ),
	'RemoveGlobalBlock' => array( 'رفع_منع_عام', 'إزالة_منع_عام' ),
	'GlobalBlockStatus' => array( 'قائمة_المنع_العام_البيضاء', 'حالة_المنع_العام', 'تعطيل_المنع_العام' ),
);

/** Egyptian Spoken Arabic (مصرى) */
$specialPageAliases['arz'] = array(
	'GlobalBlock' => array( 'بلوك_عام' ),
	'GlobalBlockList' => array( 'ليستة_بلوك_عامه' ),
	'RemoveGlobalBlock' => array( 'شيل_بلوك_عام' ),
	'GlobalBlockStatus' => array( 'ليستة_البلوك_العام_البيضا', 'حالة_البلوك_العام', 'تعطيل_البلوك_العام' ),
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬) */
$specialPageAliases['be-tarask'] = array(
	'GlobalBlock' => array( 'Глябальнае_блякаваньне' ),
	'GlobalBlockList' => array( 'Сьпіс_глябальных_блякаваньняў' ),
);

/** Breton (Brezhoneg) */
$specialPageAliases['br'] = array(
	'GlobalBlock' => array( 'StankadennHollek' ),
	'GlobalBlockList' => array( 'RollStankadennoùHollek' ),
	'RemoveGlobalBlock' => array( 'DistankadennHollek' ),
);

/** Bosnian (Bosanski) */
$specialPageAliases['bs'] = array(
	'GlobalBlock' => array( 'GlobalnoBlokiranje' ),
	'GlobalBlockList' => array( 'ListaGlobalnogBlokiranja' ),
	'RemoveGlobalBlock' => array( 'GlobalnoDeblokiranje', 'UklanjanjeGlobalnogBlokiranja' ),
	'GlobalBlockStatus' => array( 'GlobalniDopusteniSpisak' ),
);

/** German (Deutsch) */
$specialPageAliases['de'] = array(
	'GlobalBlock' => array( 'Globale_Sperre' ),
	'GlobalBlockList' => array( 'Liste_globaler_Sperren' ),
	'RemoveGlobalBlock' => array( 'Globale_Sperre_aufheben' ),
	'GlobalBlockStatus' => array( 'Ausnahme_von_globaler_Sperre' ),
);

/** Lower Sorbian (Dolnoserbski) */
$specialPageAliases['dsb'] = array(
	'GlobalBlock' => array( 'Globalne_blokěrowanje' ),
	'GlobalBlockList' => array( 'Lisćina_globalnych_blokěrowanjow' ),
	'RemoveGlobalBlock' => array( 'Globalne_blokěrowanje_wótpóraś' ),
	'GlobalBlockStatus' => array( 'Wuwześa_z_globalnego_blokěrowanja' ),
);

/** Esperanto (Esperanto) */
$specialPageAliases['eo'] = array(
	'GlobalBlock' => array( 'Ĉiea_forbaro' ),
	'GlobalBlockList' => array( 'Ĉiea_forbarlisto' ),
	'RemoveGlobalBlock' => array( 'Ĉiea_malforbaro' ),
);

/** Spanish (Español) */
$specialPageAliases['es'] = array(
	'GlobalBlock' => array( 'BloquearGlobal', 'Bloquear_global', 'Bloqueo_global' ),
	'GlobalBlockList' => array( 'Lista_de_bloqueos_globales', 'Lista_bloqueos_globales' ),
	'RemoveGlobalBlock' => array( 'DesbloquearGlobal', 'Desbloquear_global' ),
	'GlobalBlockStatus' => array( 'Lista_blanca_de_bloqueos_globales', 'Lista_blanca_bloqueos_globales' ),
);

/** Estonian (Eesti) */
$specialPageAliases['et'] = array(
	'GlobalBlock' => array( 'Globaalselt_blokeerimine' ),
	'GlobalBlockList' => array( 'Globaalne_blokeerimisloend' ),
	'RemoveGlobalBlock' => array( 'Globaalse_blokeeringu_eemaldamine' ),
	'GlobalBlockStatus' => array( 'Globaalsete_blokeeringute_valge_nimekiri' ),
);

/** Persian (فارسی) */
$specialPageAliases['fa'] = array(
	'GlobalBlock' => array( 'بستن_سراسری' ),
	'GlobalBlockList' => array( 'فهرست_بستن_سراسری' ),
	'RemoveGlobalBlock' => array( 'بازکردن_سراسری' ),
	'GlobalBlockStatus' => array( 'فهرست_سفید_بستن_سراسری' ),
);

/** Finnish (Suomi) */
$specialPageAliases['fi'] = array(
	'GlobalBlock' => array( 'Globaaliesto' ),
	'GlobalBlockList' => array( 'Globaaliestojen_lista' ),
	'RemoveGlobalBlock' => array( 'Poista_globaaliesto' ),
);

/** French (Français) */
$specialPageAliases['fr'] = array(
	'GlobalBlock' => array( 'Blocage_global', 'BlocageGlobal' ),
	'RemoveGlobalBlock' => array( 'Déblocage_global', 'DéblocageGlobal' ),
);

/** Franco-Provençal (Arpetan) */
$specialPageAliases['frp'] = array(
	'GlobalBlock' => array( 'Blocâjo_globâl', 'BlocâjoGlobâl' ),
	'GlobalBlockList' => array( 'Lista_des_blocâjos_globâls', 'ListaDesBlocâjosGlobâls' ),
	'RemoveGlobalBlock' => array( 'Dèblocâjo_globâl', 'DèblocâjoGlobâl' ),
	'GlobalBlockStatus' => array( 'Lista_blanche_des_blocâjos_globâls', 'ListaBlancheDesBlocâjosGlobâls' ),
);

/** Galician (Galego) */
$specialPageAliases['gl'] = array(
	'GlobalBlock' => array( 'Bloqueo_global' ),
	'GlobalBlockList' => array( 'Lista_de_bloqueos_globais' ),
	'RemoveGlobalBlock' => array( 'Desbloqueo_global' ),
	'GlobalBlockStatus' => array( 'Lista_branca_de_bloqueos_globais' ),
);

/** Swiss German (Alemannisch) */
$specialPageAliases['gsw'] = array(
	'GlobalBlock' => array( 'Wältwyti Sperri' ),
	'GlobalBlockList' => array( 'Lischt vu wältwyte Sperrine' ),
	'RemoveGlobalBlock' => array( 'Wältwyti Sperri uffhebe' ),
	'GlobalBlockStatus' => array( 'Uusnahme vun ere wältwyte Sperri' ),
);

/** Hebrew (עברית) */
$specialPageAliases['he'] = array(
	'GlobalBlock' => array( 'חסימה_גלובלית' ),
	'GlobalBlockList' => array( 'רשימת_חסומים_גלובליים' ),
	'RemoveGlobalBlock' => array( 'שחרור_חסימה_גלובלית', 'הסרת_חסימה_גלובלית' ),
	'GlobalBlockStatus' => array( 'רשימה_לבנה_לחסימה_גלובלית', 'מצב_חסימה_גלובלית', 'ביטול_חסימה_גלובלית' ),
);

/** Croatian (Hrvatski) */
$specialPageAliases['hr'] = array(
	'GlobalBlock' => array( 'Globalno_blokiraj' ),
	'GlobalBlockList' => array( 'Globalno_blokirane_adrese' ),
	'RemoveGlobalBlock' => array( 'Ukloni_globalno_blokiranje', 'Globalno_odblokiraj' ),
	'GlobalBlockStatus' => array( 'Status_globalnog_blokiranja' ),
);

/** Upper Sorbian (Hornjoserbsce) */
$specialPageAliases['hsb'] = array(
	'GlobalBlock' => array( 'Globalne_blokowanje' ),
	'GlobalBlockList' => array( 'Lisćina_globalnych_blokowanjow' ),
	'RemoveGlobalBlock' => array( 'Globalne_blokowanje_wotstronić' ),
	'GlobalBlockStatus' => array( 'Wuwzaća_z_globalneho_blokowanja' ),
);

/** Haitian (Kreyòl ayisyen) */
$specialPageAliases['ht'] = array(
	'GlobalBlock' => array( 'BlokajGlobal' ),
	'GlobalBlockList' => array( 'LisBlokajGlobal' ),
	'RemoveGlobalBlock' => array( 'DeblokajGlobal', 'RetireBlokajGlobal' ),
	'GlobalBlockStatus' => array( 'LisPèmètBlokajGlobal', 'EstatiBlokajGlobal', 'DeaktiveBlokajGlobal' ),
);

/** Hungarian (Magyar) */
$specialPageAliases['hu'] = array(
	'GlobalBlock' => array( 'Globális_blokkolás' ),
	'GlobalBlockList' => array( 'Globális_blokkok_listája' ),
	'RemoveGlobalBlock' => array( 'Globális_feloldás' ),
);

/** Interlingua (Interlingua) */
$specialPageAliases['ia'] = array(
	'GlobalBlock' => array( 'Blocada_global' ),
	'GlobalBlockList' => array( 'Lista_de_blocadas_global' ),
	'RemoveGlobalBlock' => array( 'Disblocada_global', 'Remover_blocada_global' ),
	'GlobalBlockStatus' => array( 'Lista_blanc_de_blocadas_global', 'Stato_de_blocadas_global', 'Disactivar_blocada_global' ),
);

/** Indonesian (Bahasa Indonesia) */
$specialPageAliases['id'] = array(
	'GlobalBlock' => array( 'Pemblokiran_global', 'PemblokiranGlobal' ),
	'GlobalBlockList' => array( 'Daftar_pemblokiran_global', 'DaftarPemblokiranGlobal' ),
	'RemoveGlobalBlock' => array( 'Batalkan_pemblokiran_global', 'BatalkanPemblokiranGlobal' ),
	'GlobalBlockStatus' => array( 'Daftar_putih_pemblokiran_global', 'DaftarPutihPemblokiranGlobal' ),
);

/** Italian (Italiano) */
$specialPageAliases['it'] = array(
	'GlobalBlock' => array( 'BloccoGlobale' ),
	'GlobalBlockList' => array( 'ElencoBlocchiGlobali', 'ListaBlocchiGlobali' ),
	'RemoveGlobalBlock' => array( 'SbloccoGlobale' ),
	'GlobalBlockStatus' => array( 'StatoLocaleBloccoGlobale', 'DisabilitaBloccoGlobale', 'ListaBiancaBloccoGlobale' ),
);

/** Japanese (日本語) */
$specialPageAliases['ja'] = array(
	'GlobalBlock' => array( 'グローバルブロック', 'グローバル・ブロック' ),
	'GlobalBlockList' => array( 'グローバルブロック一覧', 'グローバル・ブロック一覧' ),
	'RemoveGlobalBlock' => array( 'グローバルブロック解除', 'グローバル・ブロック解除' ),
	'GlobalBlockStatus' => array( 'グローバルブロックホワイトリスト', 'グローバルブロック状態', 'グローバルブロック無効' ),
);

/** Georgian (ქართული) */
$specialPageAliases['ka'] = array(
	'GlobalBlock' => array( 'გლობალური_დაბლოკვა' ),
	'GlobalBlockList' => array( 'გლობალური_ბლოკირებების_სია' ),
	'RemoveGlobalBlock' => array( 'გლობალური_ბლოკის_მოხსნა' ),
);

/** Korean (한국어) */
$specialPageAliases['ko'] = array(
	'GlobalBlock' => array( '전체차단' ),
	'GlobalBlockList' => array( '전체차단목록' ),
	'RemoveGlobalBlock' => array( '전체차단취소', '전체차단해제' ),
);

/** Colognian (Ripoarisch) */
$specialPageAliases['ksh'] = array(
	'GlobalBlock' => array( 'Jemeinsam_Sperre' ),
	'GlobalBlockList' => array( 'Leß_met_jemeinsam_Sperre' ),
	'RemoveGlobalBlock' => array( 'Jemeinsam_Sperre_ophävve', 'Jemeinsam_Sperre_ophevve' ),
	'GlobalBlockStatus' => array( 'Ußnahme_vun_de_jemeinsam_Sperre' ),
);

/** Ladino (Ladino) */
$specialPageAliases['lad'] = array(
	'GlobalBlock' => array( 'BloqueoGlobbal' ),
	'GlobalBlockList' => array( 'Lista_de_bloqueos_globbales' ),
	'RemoveGlobalBlock' => array( 'DesbloquearGlobal' ),
	'GlobalBlockStatus' => array( 'Lista_blanca_de_bloqueos_globbales' ),
);

/** Luxembourgish (Lëtzebuergesch) */
$specialPageAliases['lb'] = array(
	'GlobalBlock' => array( 'Global_Spären' ),
	'GlobalBlockList' => array( 'Lëscht_vun_de_globale_Spären' ),
	'RemoveGlobalBlock' => array( 'Global_Spär_ophiewen' ),
	'GlobalBlockStatus' => array( 'Ausnahm_vun_der_globaler_Spär' ),
);

/** Macedonian (Македонски) */
$specialPageAliases['mk'] = array(
	'GlobalBlock' => array( 'ГлобалноБлокирање' ),
	'GlobalBlockList' => array( 'СписокНаГлобалниБлокирања' ),
	'RemoveGlobalBlock' => array( 'ГлобалниДеблокирања', 'БришиГлобаленБлок' ),
	'GlobalBlockStatus' => array( 'СтатусНаГлобаленБлок', 'ОневозможиГлобаленБлок' ),
);

/** Malayalam (മലയാളം) */
$specialPageAliases['ml'] = array(
	'GlobalBlock' => array( 'ആഗോളതടയൽ' ),
	'GlobalBlockList' => array( 'ആഗോളതടയൽപട്ടിക' ),
	'RemoveGlobalBlock' => array( 'ആഗോളതടയൽനീക്കുക' ),
	'GlobalBlockStatus' => array( 'ആഗോളതടയൽശുദ്ധപട്ടിക', 'ആഗോളതടയൽസ്ഥിതി', 'ആഗോളതടയൽപട്ടികനിർജീവമാക്കുക' ),
);

/** Marathi (मराठी) */
$specialPageAliases['mr'] = array(
	'GlobalBlock' => array( 'वैश्विकब्लॉक' ),
	'GlobalBlockList' => array( 'वैश्विकब्लॉकयादी' ),
	'RemoveGlobalBlock' => array( 'वैश्विकअनब्लॉक' ),
	'GlobalBlockStatus' => array( 'वैश्विकब्लॉकश्वेतपत्र' ),
);

/** Malay (Bahasa Melayu) */
$specialPageAliases['ms'] = array(
	'GlobalBlock' => array( 'Sekatan_sejagat' ),
	'GlobalBlockList' => array( 'Senarai_sekatan_sejagat' ),
	'RemoveGlobalBlock' => array( 'Batal_sekatan_sejagat' ),
	'GlobalBlockStatus' => array( 'Senarai_putih_sekatan_sejagat' ),
);

/** Maltese (Malti) */
$specialPageAliases['mt'] = array(
	'GlobalBlock' => array( 'BlokkGlobali' ),
	'GlobalBlockList' => array( 'ListaBlokkGlobali' ),
);

/** Norwegian Bokmål (‪Norsk (bokmål)‬) */
$specialPageAliases['nb'] = array(
	'GlobalBlock' => array( 'Blokker_globalt', 'Global_blokkering' ),
	'GlobalBlockList' => array( 'Global_blokkeringsliste' ),
	'RemoveGlobalBlock' => array( 'Avblokker_globalt', 'Global_avblokkering' ),
	'GlobalBlockStatus' => array( 'Hviteliste_for_global_blokkering' ),
);

/** Nedersaksisch (Nedersaksisch) */
$specialPageAliases['nds-nl'] = array(
	'GlobalBlock' => array( 'Globaal_blokkeren' ),
	'GlobalBlockList' => array( 'Globale_blokkeerlieste' ),
	'RemoveGlobalBlock' => array( 'Globaal_deblokkeren' ),
	'GlobalBlockStatus' => array( 'Witte_lieste_blokkeringen' ),
);

/** Dutch (Nederlands) */
$specialPageAliases['nl'] = array(
	'GlobalBlock' => array( 'GlobaalBlokkeren' ),
	'GlobalBlockList' => array( 'GlobaleBlokkadelijst', 'GlobaleBlokkeerlijst' ),
	'RemoveGlobalBlock' => array( 'GlobaalDeblokkeren', 'GlobaleBlokkadeVerwijderen' ),
	'GlobalBlockStatus' => array( 'WitteLijstGlobaleBlokkades', 'GlobaleBlokkadestatus' ),
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬) */
$specialPageAliases['nn'] = array(
	'GlobalBlockList' => array( 'Global_blokkeringsliste' ),
);

/** Occitan (Occitan) */
$specialPageAliases['oc'] = array(
	'GlobalBlock' => array( 'Blocatge_global', 'BlocatgeGlobal' ),
	'RemoveGlobalBlock' => array( 'Desblocatge_global', 'DesblocatgeGlobal' ),
);

/** Polish (Polski) */
$specialPageAliases['pl'] = array(
	'GlobalBlock' => array( 'Zablokuj_globalnie' ),
	'GlobalBlockList' => array( 'Spis_globalnie_zablokowanych_adresów_IP' ),
	'RemoveGlobalBlock' => array( 'Odblokuj_globalnie' ),
	'GlobalBlockStatus' => array( 'Lokalny_status_globalnych_blokad' ),
);

/** Pashto (پښتو) */
$specialPageAliases['ps'] = array(
	'GlobalBlock' => array( 'نړېوال_بنديزونه' ),
);

/** Portuguese (Português) */
$specialPageAliases['pt'] = array(
	'GlobalBlock' => array( 'Bloqueio_global' ),
	'GlobalBlockList' => array( 'Lista_de_bloqueios_globais' ),
	'RemoveGlobalBlock' => array( 'Desbloqueio_global', 'Remover_bloqueio_global' ),
	'GlobalBlockStatus' => array( 'Lista_branca_de_bloqueios_globais' ),
);

/** Brazilian Portuguese (Português do Brasil) */
$specialPageAliases['pt-br'] = array(
	'GlobalBlock' => array( 'Bloquear_globalmente' ),
);

/** Romanian (Română) */
$specialPageAliases['ro'] = array(
	'GlobalBlock' => array( 'Blocare_globală' ),
	'GlobalBlockList' => array( 'Lista_de_blocări_globale' ),
	'RemoveGlobalBlock' => array( 'Deblocare_globală', 'Elimină_blocarea_globală' ),
	'GlobalBlockStatus' => array( 'Lista_albă_de_blocări_globale', 'Stare_blocare_globală', 'Dezactivare_blocare_globală' ),
);

/** Sanskrit (संस्कृतम्) */
$specialPageAliases['sa'] = array(
	'GlobalBlock' => array( 'वैश्विकप्रतिबन्ध' ),
	'GlobalBlockList' => array( 'वैश्विकप्रतिबन्धसूची' ),
	'RemoveGlobalBlock' => array( 'वैश्विकअप्रतिबन्ध' ),
	'GlobalBlockStatus' => array( 'वैश्विकअप्रतिबन्धसूची' ),
);

/** Slovak (Slovenčina) */
$specialPageAliases['sk'] = array(
	'GlobalBlock' => array( 'GlobálneBlokovanie' ),
	'GlobalBlockList' => array( 'ZoznamGlobálnehoBlokovania' ),
	'RemoveGlobalBlock' => array( 'GlobálneOdblokovanie' ),
	'GlobalBlockStatus' => array( 'BielaListinaGlobálnehoBlokovania' ),
);

/** Swedish (Svenska) */
$specialPageAliases['sv'] = array(
	'GlobalBlock' => array( 'Global_blockering' ),
	'GlobalBlockList' => array( 'Global_blockeringslista' ),
	'RemoveGlobalBlock' => array( 'Global_avblockering' ),
);

/** Tagalog (Tagalog) */
$specialPageAliases['tl'] = array(
	'GlobalBlock' => array( 'Pandaigdigang paghadlang' ),
	'GlobalBlockList' => array( 'Talaan ng pandaigdigang paghadlang' ),
	'RemoveGlobalBlock' => array( 'Pandaigdigang hindi paghadlang', 'Tanggalin ang pandaigdigang paghadlang' ),
	'GlobalBlockStatus' => array( 'Puting talaan ng pandaigdigang paghadlang', 'Kalagayan ng pandaigdigang paghadlang', 'Huwag paganahin ang pandaigdigang paghadlang' ),
);

/** Turkish (Türkçe) */
$specialPageAliases['tr'] = array(
	'GlobalBlock' => array( 'KüreselEngel' ),
	'GlobalBlockList' => array( 'KüreselEngelListesi' ),
	'RemoveGlobalBlock' => array( 'KüreselEngelKaldırma' ),
	'GlobalBlockStatus' => array( 'KüreselEngelBeyazListesi', 'KüreselEngelDurumu' ),
);

/** Tatar (Cyrillic script) (Татарча) */
$specialPageAliases['tt-cyrl'] = array(
	'GlobalBlock' => array( 'Глобаль_тыю' ),
);

/** Vèneto (Vèneto) */
$specialPageAliases['vec'] = array(
	'GlobalBlock' => array( 'BlocoGlobal' ),
);

/** Vietnamese (Tiếng Việt) */
$specialPageAliases['vi'] = array(
	'GlobalBlock' => array( 'Cấm_toàn_cục' ),
	'GlobalBlockList' => array( 'Danh_sách_cấm_toàn_cục' ),
	'RemoveGlobalBlock' => array( 'Bỏ_cấm_toàn_cục' ),
);

/** Cantonese (粵語) */
$specialPageAliases['yue'] = array(
	'GlobalBlock' => array( '全域查封' ),
	'GlobalBlockList' => array( '全域封禁一覽' ),
	'RemoveGlobalBlock' => array( '全域解封' ),
	'GlobalBlockStatus' => array( '全域封禁白名單' ),
);

/** Simplified Chinese (‪中文(简体)‬) */
$specialPageAliases['zh-hans'] = array(
	'GlobalBlock' => array( '全域封禁' ),
	'GlobalBlockList' => array( '全域封禁列表' ),
	'RemoveGlobalBlock' => array( '解除全域封禁' ),
	'GlobalBlockStatus' => array( '全域封禁白名单' ),
);

/** Traditional Chinese (‪中文(繁體)‬) */
$specialPageAliases['zh-hant'] = array(
	'GlobalBlock' => array( '全域封禁' ),
	'GlobalBlockList' => array( '全域封禁列表' ),
	'RemoveGlobalBlock' => array( '解除全域封禁' ),
	'GlobalBlockStatus' => array( '全域封禁白名單' ),
);