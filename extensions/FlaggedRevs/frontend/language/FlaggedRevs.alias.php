<?php
/**
 * Aliases for special pages for extension FlaggedRevs
 *
 * @file
 * @ingroup Extensions
 */

$specialPageAliases = array();

/** English (English) */
$specialPageAliases['en'] = array(
	'PendingChanges' => array( 'PendingChanges', 'OldReviewedPages' ),
	'ProblemChanges' => array( 'ProblemChanges' ),
	'QualityOversight' => array( 'AdvancedReviewLog', 'QualityOversight' ),
	'ReviewedPages' => array( 'ReviewedPages' ),
	'RevisionReview' => array( 'RevisionReview' ),
	'Stabilization' => array( 'Stabilization', 'Stabilisation' ),
	'StablePages' => array( 'StablePages' ),
	'ConfiguredPages' => array( 'ConfiguredPages' ),
	'ReviewedVersions' => array( 'ReviewedVersions', 'StableVersions' ),
	'UnreviewedPages' => array( 'UnreviewedPages' ),
	'ValidationStatistics' => array( 'ValidationStatistics' ),
);

/** Aragonese (Aragonés) */
$specialPageAliases['an'] = array(
	'PendingChanges' => array( 'PachinasSupervisatasAntigas' ),
	'QualityOversight' => array( 'SupervisataDeCalidat' ),
	'ReviewedPages' => array( 'PachinasSubervisatas' ),
	'StablePages' => array( 'PachinasEstables' ),
	'UnreviewedPages' => array( 'PachinasNoRevisatas' ),
);

/** Arabic (العربية) */
$specialPageAliases['ar'] = array(
	'PendingChanges' => array( 'صفحات_مراجعة_قديمة' ),
	'ProblemChanges' => array( 'تغييرات_المشاكل' ),
	'QualityOversight' => array( 'سجل_المراجعة_المتقدم', 'نظر_الجودة' ),
	'ReviewedPages' => array( 'صفحات_مراجعة' ),
	'RevisionReview' => array( 'مراجعة_نسخة' ),
	'Stabilization' => array( 'استقرار' ),
	'StablePages' => array( 'صفحات_مستقرة' ),
	'ConfiguredPages' => array( 'صفحات_مضبوطة' ),
	'ReviewedVersions' => array( 'نسخ_مراجعة', 'نسخ_مستقرة' ),
	'UnreviewedPages' => array( 'صفحات_غير_مراجعة' ),
	'ValidationStatistics' => array( 'إحصاءات_التحقق' ),
);

/** Egyptian Spoken Arabic (مصرى) */
$specialPageAliases['arz'] = array(
	'PendingChanges' => array( 'صفح_مراجعه_قديمه' ),
	'ProblemChanges' => array( 'تغييرات_المشاكل' ),
	'QualityOversight' => array( 'مراقبة_الجوده' ),
	'ReviewedPages' => array( 'صفح_مراجعه' ),
	'RevisionReview' => array( 'مراجعة_نسخه' ),
	'Stabilization' => array( 'استقرار' ),
	'StablePages' => array( 'صفح_مستقر' ),
	'ConfiguredPages' => array( 'صفحات_مضبوطه' ),
	'ReviewedVersions' => array( 'نسخ_مراجعه', 'نسخ_مستقره' ),
	'UnreviewedPages' => array( 'صفح_مش_متراجعه' ),
	'ValidationStatistics' => array( 'احصائيات_الصلاحيه' ),
);

/** Southern Balochi (بلوچی مکرانی) */
$specialPageAliases['bcc'] = array(
	'PendingChanges' => array( 'صفحات-بازبینی-قدیمی' ),
	'QualityOversight' => array( 'رویت-کیفیت' ),
	'ReviewedPages' => array( 'صفحات-بازبینی' ),
	'StablePages' => array( 'صفحات-ثابت' ),
	'UnreviewedPages' => array( 'صفحات-بی-بازبینی' ),
);

/** Breton (Brezhoneg) */
$specialPageAliases['br'] = array(
	'ReviewedPages' => array( 'PajennoùAdwelet' ),
	'Stabilization' => array( 'Stabiladur' ),
	'StablePages' => array( 'PajennoùStabil' ),
	'ConfiguredPages' => array( 'PajennoùKefluniet' ),
	'UnreviewedPages' => array( 'PajennoùDaAprouiñ' ),
	'ValidationStatistics' => array( 'KadarnaatStadegoù' ),
);

/** Bosnian (Bosanski) */
$specialPageAliases['bs'] = array(
	'PendingChanges' => array( 'StarePregledaneStranice' ),
	'QualityOversight' => array( 'KvalitetNadzora' ),
	'ReviewedPages' => array( 'PregledaneStranice' ),
	'RevisionReview' => array( 'PregledRevizija' ),
	'Stabilization' => array( 'Stabilizacija' ),
	'StablePages' => array( 'StabilneStranice' ),
	'UnreviewedPages' => array( 'NeprovjereneStranice' ),
	'ValidationStatistics' => array( 'StatistikeValidacije' ),
);

/** German (Deutsch) */
$specialPageAliases['de'] = array(
	'PendingChanges' => array( 'Seiten_mit_ungesichteten_Versionen' ),
	'QualityOversight' => array( 'Markierungsübersicht' ),
	'ReviewedPages' => array( 'Gesichtete_Seiten' ),
	'RevisionReview' => array( 'Versionsprüfung' ),
	'Stabilization' => array( 'Seitenkonfiguration', 'Stabilisierung' ),
	'StablePages' => array( 'Markierte_Seiten' ),
	'ConfiguredPages' => array( 'Konfigurierte_Seiten' ),
	'ReviewedVersions' => array( 'Gesichtete_Versionen' ),
	'UnreviewedPages' => array( 'Ungesichtete_Seiten' ),
	'ValidationStatistics' => array( 'Markierungsstatistik' ),
);

/** Lower Sorbian (Dolnoserbski) */
$specialPageAliases['dsb'] = array(
	'PendingChanges' => array( 'Zasej njepśeglědane boki' ),
	'QualityOversight' => array( 'Kwalitna_kontrola' ),
	'ReviewedPages' => array( 'Pśeglědane_boki' ),
	'RevisionReview' => array( 'Wersijowe_pśeglědanje' ),
	'Stabilization' => array( 'Stabilizacija' ),
	'StablePages' => array( 'Stabilne_boki' ),
	'UnreviewedPages' => array( 'Njepśeglědane_boki' ),
	'ValidationStatistics' => array( 'Statistika_pśeglědanjow' ),
);

/** Esperanto (Esperanto) */
$specialPageAliases['eo'] = array(
	'PendingChanges' => array( 'Malfreŝe_kontrolitaj_paĝoj' ),
	'QualityOversight' => array( 'Kvalita_kontrolo' ),
	'ReviewedPages' => array( 'Kontrolitaj_paĝoj' ),
	'Stabilization' => array( 'Stabilado' ),
	'StablePages' => array( 'Stabilaj_paĝoj' ),
	'UnreviewedPages' => array( 'Nekontrolitaj_paĝoj' ),
);

/** Spanish (Español) */
$specialPageAliases['es'] = array(
	'PendingChanges' => array( 'Páginas_revisadas_antiguas' ),
	'ReviewedPages' => array( 'PáginasRevisadas', 'Páginas_revisadas' ),
	'Stabilization' => array( 'Estabilización' ),
	'StablePages' => array( 'Páginas_publicadas' ),
	'ConfiguredPages' => array( 'PáginasConfiguradas', 'Páginas_configuradas' ),
	'ReviewedVersions' => array( 'Versiones_revisadas' ),
	'UnreviewedPages' => array( 'Páginas_sin_revisar' ),
	'ValidationStatistics' => array( 'Estadísticas_de_validación' ),
);

/** Persian (فارسی) */
$specialPageAliases['fa'] = array(
	'PendingChanges' => array( 'صفحه‌های_بازبینی_شده_قدیمی' ),
	'ProblemChanges' => array( 'تغییر_مشکلات' ),
	'QualityOversight' => array( 'نظارت_کیفی' ),
	'ReviewedPages' => array( 'صفحه‌های_بازبینی_شده' ),
	'RevisionReview' => array( 'بازبینی_نسخه' ),
	'Stabilization' => array( 'پایدارسازی' ),
	'StablePages' => array( 'صفحه‌های_پایدار' ),
	'ConfiguredPages' => array( 'صفحه‌های_تنظیم_شده' ),
	'ReviewedVersions' => array( 'نسخه‌های_پایدار' ),
	'UnreviewedPages' => array( 'صفحه‌های‌بازبینی‌نشده' ),
	'ValidationStatistics' => array( 'آمار_تاییدها' ),
);

/** Finnish (Suomi) */
$specialPageAliases['fi'] = array(
	'ProblemChanges' => array( 'Ongelmalliset_muutokset' ),
	'Stabilization' => array( 'Vakaaksi_versioksi' ),
	'StablePages' => array( 'Vakaat_sivut' ),
	'UnreviewedPages' => array( 'Arvioimattomat_sivut' ),
);

/** French (Français) */
$specialPageAliases['fr'] = array(
	'PendingChanges' => array( 'AnciennesPagesRelues' ),
	'QualityOversight' => array( 'SuperviseurQualité' ),
	'ReviewedPages' => array( 'Pages_révisées' ),
	'RevisionReview' => array( 'Relecture_des_révisions' ),
	'StablePages' => array( 'Pages_stables' ),
	'UnreviewedPages' => array( 'Pages_non_relues' ),
	'ValidationStatistics' => array( 'Statistiques_de_validation' ),
);

/** Franco-Provençal (Arpetan) */
$specialPageAliases['frp'] = array(
	'PendingChanges' => array( 'Pâges_que_les_vèrsions_sont_dèpassâs', 'PâgesQueLesVèrsionsSontDèpassâs' ),
	'QualityOversight' => array( 'Supèrvision_de_qualitât', 'SupèrvisionDeQualitât' ),
	'ReviewedPages' => array( 'Pâges_revues', 'PâgesRevues' ),
	'RevisionReview' => array( 'Rèvision_de_les_vèrsions', 'RèvisionDeLesVèrsions' ),
	'Stabilization' => array( 'Stabilisacion' ),
	'StablePages' => array( 'Pâges_stâbles', 'PâgesStâbles' ),
	'UnreviewedPages' => array( 'Pâges_pas_revues', 'PâgesPasRevues' ),
	'ValidationStatistics' => array( 'Statistiques_de_validacion', 'StatistiquesDeValidacion' ),
);

/** Galician (Galego) */
$specialPageAliases['gl'] = array(
	'PendingChanges' => array( 'Páxinas_revisadas_hai_tempo' ),
	'ProblemChanges' => array( 'Cambios_nun_problema' ),
	'QualityOversight' => array( 'Revisión_de_calidade' ),
	'ReviewedPages' => array( 'Páxinas_revisadas' ),
	'RevisionReview' => array( 'Revisión_da_revisión' ),
	'Stabilization' => array( 'Estabilización' ),
	'StablePages' => array( 'Páxinas_estábeis' ),
	'ConfiguredPages' => array( 'Páxinas_configuradas' ),
	'ReviewedVersions' => array( 'Versións_revisadas', 'Versións_estables' ),
	'UnreviewedPages' => array( 'Páxinas_non_revisadas' ),
	'ValidationStatistics' => array( 'Estatísticas_de_validación' ),
);

/** Swiss German (Alemannisch) */
$specialPageAliases['gsw'] = array(
	'PendingChanges' => array( 'Syte mit Versione wu nit gsichtet sin' ),
	'QualityOversight' => array( 'Markierigsibersicht' ),
	'ReviewedPages' => array( 'Gsichteti Syte' ),
	'RevisionReview' => array( 'Versionspriefig' ),
	'Stabilization' => array( 'Sytekonfiguration' ),
	'StablePages' => array( 'Konfigurierti Syte' ),
	'UnreviewedPages' => array( 'Syte wu nit gsichtet sin' ),
	'ValidationStatistics' => array( 'Markierigsstatischtik' ),
);

/** Gujarati (ગુજરાતી) */
$specialPageAliases['gu'] = array(
	'PendingChanges' => array( 'જુનાં તપાસાયેલા પાનાં' ),
	'QualityOversight' => array( 'ગુણવતા_દુર્લક્ષ' ),
	'ReviewedPages' => array( 'રીવ્યુપાનાં' ),
	'RevisionReview' => array( 'આવૃત્તિરીવ્યુ' ),
	'Stabilization' => array( 'સ્થિરતા' ),
	'StablePages' => array( 'સ્થિરપાનાઓ' ),
);

/** Hindi (हिन्दी) */
$specialPageAliases['hi'] = array(
	'PendingChanges' => array( 'पुरानेदेखेंहुएपन्ने' ),
	'QualityOversight' => array( 'गुणवत्ताओव्हरसाईट' ),
	'ReviewedPages' => array( 'जाँचेहुएपन्ने' ),
	'StablePages' => array( 'स्थिरपन्ने' ),
	'UnreviewedPages' => array( 'नदेखेंहुएपन्ने' ),
);

/** Croatian (Hrvatski) */
$specialPageAliases['hr'] = array(
	'StablePages' => array( 'Stabilne_stranice' ),
);

/** Upper Sorbian (Hornjoserbsce) */
$specialPageAliases['hsb'] = array(
	'PendingChanges' => array( 'Zaso njepřehladane strony' ),
	'QualityOversight' => array( 'Kwalitna_kontrola' ),
	'ReviewedPages' => array( 'Přehladane_strony' ),
	'RevisionReview' => array( 'Wersijowe_přehladanje' ),
	'Stabilization' => array( 'Stabilizacija' ),
	'StablePages' => array( 'Stabilne_strony' ),
	'UnreviewedPages' => array( 'Njepřehladane_strony' ),
	'ValidationStatistics' => array( 'Statistika_přehladanjow' ),
);

/** Haitian (Kreyòl ayisyen) */
$specialPageAliases['ht'] = array(
	'PendingChanges' => array( 'ChanjmanKapTann', 'AnsyenPajRevize' ),
	'ProblemChanges' => array( 'ChanjmanPwoblèm' ),
	'QualityOversight' => array( 'JounalRevizyonAvanse', 'SipèvizyonKalite' ),
	'ReviewedPages' => array( 'PajRevize' ),
	'RevisionReview' => array( 'VerifyeRevizyon' ),
	'Stabilization' => array( 'Estabilizasyon' ),
	'StablePages' => array( 'PajEstab' ),
	'ConfiguredPages' => array( 'PajKonfigire' ),
	'ReviewedVersions' => array( 'VèsyonRevize', 'VèsyonEstab' ),
	'UnreviewedPages' => array( 'PajPaRevize' ),
	'ValidationStatistics' => array( 'EstatistikValidasyon' ),
);

/** Hungarian (Magyar) */
$specialPageAliases['hu'] = array(
	'PendingChanges' => array( 'Elavult_ellenőrzött_lapok', 'Régen_ellenőrzött_lapok' ),
	'QualityOversight' => array( 'Minőségellenőrzés' ),
	'ReviewedPages' => array( 'Ellenőrzött_lapok' ),
	'RevisionReview' => array( 'Változat_ellenőrzése' ),
	'Stabilization' => array( 'Lap_rögzítése' ),
	'StablePages' => array( 'Rögzített_lapok' ),
	'UnreviewedPages' => array( 'Ellenőrizetlen_lapok' ),
	'ValidationStatistics' => array( 'Ellenőrzési_statisztika' ),
);

/** Interlingua (Interlingua) */
$specialPageAliases['ia'] = array(
	'PendingChanges' => array( 'Modificationes_pendente', 'Paginas_revidite_ancian' ),
	'ProblemChanges' => array( 'Modificationes_problematic' ),
	'QualityOversight' => array( 'Registro_de_revision_avantiate', 'Supervision_de_qualitate' ),
	'ReviewedPages' => array( 'Paginas_revidite' ),
	'RevisionReview' => array( 'Revision_de_versiones' ),
	'StablePages' => array( 'Paginas_stabile', 'Paginas_publicate' ),
	'ConfiguredPages' => array( 'Paginas_configurate' ),
	'ReviewedVersions' => array( 'Versiones_revidite', 'Versiones_stabile' ),
	'UnreviewedPages' => array( 'Paginas_non_revidite' ),
	'ValidationStatistics' => array( 'Statisticas_de_validation' ),
);

/** Indonesian (Bahasa Indonesia) */
$specialPageAliases['id'] = array(
	'PendingChanges' => array( 'Halaman_tertinjau_usang', 'HalamanTertinjauUsang' ),
	'ProblemChanges' => array( 'Perubahan_masalah', 'PerubahanMasalah' ),
	'QualityOversight' => array( 'Pemeriksaan_kualitas', 'PemeriksaanKualitas' ),
	'ReviewedPages' => array( 'Halaman_tertinjau', 'HalamanTertinjau' ),
	'RevisionReview' => array( 'Tinjauan_revisi', 'TinjauanRevisi' ),
	'Stabilization' => array( 'Stabilisasi' ),
	'StablePages' => array( 'Halaman_stabil', 'HalamanStabil' ),
	'ConfiguredPages' => array( 'Halaman_terkonfigurasi', 'HalamanTerkonfigurasi' ),
	'ReviewedVersions' => array( 'Versi_tertinjau', 'VersiTertinjau', 'Versi_stabil', 'VersiStabil' ),
	'UnreviewedPages' => array( 'Halaman_yang_belum_ditinjau', 'HalamanBelumDitinjau' ),
	'ValidationStatistics' => array( 'Statistik_validasi', 'StatistikValidasi' ),
);

/** Japanese (日本語) */
$specialPageAliases['ja'] = array(
	'PendingChanges' => array( '古くなった査読済みページ' ),
	'ProblemChanges' => array( '問題の修正' ),
	'QualityOversight' => array( '品質監督' ),
	'ReviewedPages' => array( '査読済みページ' ),
	'RevisionReview' => array( '特定版の査読' ),
	'Stabilization' => array( '固定', '採択', 'ページの採択' ),
	'StablePages' => array( '固定ページ', '安定ページ', '採用ページ' ),
	'ConfiguredPages' => array( '査読設定のあるページ' ),
	'ReviewedVersions' => array( '固定版', '安定版', '採用版' ),
	'UnreviewedPages' => array( '未査読ページ', '査読待ちページ' ),
	'ValidationStatistics' => array( '判定統計' ),
);

/** Colognian (Ripoarisch) */
$specialPageAliases['ksh'] = array(
	'PendingChanges' => array( 'SiggeMetUnjesichVersione' ),
	'ProblemChanges' => array( 'SiggeMetProbleme' ),
	'ReviewedPages' => array( 'JesichSigge' ),
	'UnreviewedPages' => array( 'UNjesichSigge' ),
);

/** Ladino (Ladino) */
$specialPageAliases['lad'] = array(
	'ProblemChanges' => array( 'Trocamientos_de_problemes' ),
	'QualityOversight' => array( 'Sorvelyança_de_calidad' ),
	'ReviewedPages' => array( 'HojasEgzaminadas' ),
	'RevisionReview' => array( 'Egzamén_de_rēvizyones' ),
	'Stabilization' => array( 'Estabilizasyón' ),
	'StablePages' => array( 'HojasEstables' ),
	'ConfiguredPages' => array( 'HojasArregladas' ),
	'ReviewedVersions' => array( 'VersionesEgzaminadas' ),
	'UnreviewedPages' => array( 'HojasNoEgzaminadas' ),
	'ValidationStatistics' => array( 'Estatistikas_de_validdasyón' ),
);

/** Luxembourgish (Lëtzebuergesch) */
$specialPageAliases['lb'] = array(
	'PendingChanges' => array( 'Säite_mat_Versiounen_déi_net_iwwerpréift_sinn' ),
	'ProblemChanges' => array( 'Problematesch_Ännerungen' ),
	'QualityOversight' => array( 'Qualitéitsiwwersiicht' ),
	'ReviewedPages' => array( 'Säiten_déi_iwwerkuckt_goufen' ),
	'RevisionReview' => array( 'Versioun_iwwerpréifen' ),
	'Stabilization' => array( 'Stabilisatioun' ),
	'StablePages' => array( 'Stabil_Säiten' ),
	'ConfiguredPages' => array( 'Agestallte_Säiten' ),
	'ReviewedVersions' => array( 'Stabil_Versiounen' ),
	'UnreviewedPages' => array( 'Net_iwwerpréifte_Säiten' ),
	'ValidationStatistics' => array( 'Statistik_vun_den_iwwerpréifte_Säiten' ),
);

/** Macedonian (Македонски) */
$specialPageAliases['mk'] = array(
	'PendingChanges' => array( 'СтариОценетиСтраници' ),
	'ProblemChanges' => array( 'ПромениНаПроблеми' ),
	'QualityOversight' => array( 'НадлегувањеНаКвалитетот' ),
	'ReviewedPages' => array( 'ПрегледаниСтраници' ),
	'RevisionReview' => array( 'ПрегледНаРевизии' ),
	'Stabilization' => array( 'Стабилизација' ),
	'StablePages' => array( 'СтабилниСтраници' ),
	'ConfiguredPages' => array( 'НагодениСтраници' ),
	'ReviewedVersions' => array( 'ПрегледаниВерзии', 'СтабилниВерзии' ),
	'UnreviewedPages' => array( 'НепрегледаниСтраници' ),
	'ValidationStatistics' => array( 'ПотврдниСтатистики' ),
);

/** Malayalam (മലയാളം) */
$specialPageAliases['ml'] = array(
	'PendingChanges' => array( 'മുമ്പ്_സംശോധനം_ചെയ്ത_താളുകൾ' ),
	'ProblemChanges' => array( 'പ്രശ്നകാരിമാറ്റങ്ങൾ' ),
	'QualityOversight' => array( 'ഗുണമേന്മാമേൽനോട്ടം' ),
	'ReviewedPages' => array( 'സംശോധനംചെയ്തതാളുകൾ' ),
	'RevisionReview' => array( 'നാൾപ്പതിപ്പ്സംശോധനം' ),
	'Stabilization' => array( 'സ്ഥിരപ്പെടുത്തൽ' ),
	'StablePages' => array( 'സ്ഥിരതാളുകൾ' ),
	'ConfiguredPages' => array( 'ക്രമീകരിച്ചതാളുകൾ' ),
	'ReviewedVersions' => array( 'സംശോധിതപതിപ്പുകൾ', 'സ്ഥിരതയുള്ള_പതിപ്പുകൾ' ),
	'UnreviewedPages' => array( 'സംശോധനംചെയ്യാത്തതാളുകൾ' ),
	'ValidationStatistics' => array( 'മൂല്യനിർണ്ണയസ്ഥിതിവിവരം' ),
);

/** Marathi (मराठी) */
$specialPageAliases['mr'] = array(
	'PendingChanges' => array( 'जुनीतपासलेलीपाने' ),
	'QualityOversight' => array( 'गुणवत्ताओव्हरसाईट' ),
	'ReviewedPages' => array( 'तपासलेलीपाने' ),
	'RevisionReview' => array( 'आवृत्तीसमीक्षा' ),
	'Stabilization' => array( 'स्थिरीकरण' ),
	'StablePages' => array( 'स्थिरपाने' ),
	'UnreviewedPages' => array( 'नतपासलेलीपाने' ),
);

/** Malay (Bahasa Melayu) */
$specialPageAliases['ms'] = array(
	'PendingChanges' => array( 'Laman_diperiksa_lapuk' ),
	'QualityOversight' => array( 'Kawalan_mutu' ),
	'ReviewedPages' => array( 'Laman_diperiksa' ),
	'StablePages' => array( 'Laman_stabil' ),
	'UnreviewedPages' => array( 'Laman_tidak_diperiksa' ),
);

/** Norwegian Bokmål (‪Norsk (bokmål)‬) */
$specialPageAliases['nb'] = array(
	'PendingChanges' => array( 'Gamle_anmeldte_sider' ),
	'ProblemChanges' => array( 'Problemendringer' ),
	'QualityOversight' => array( 'Kvalitetsoversikt' ),
	'ReviewedPages' => array( 'Anmeldte_sider' ),
	'RevisionReview' => array( 'Revisjonsgjennomgang' ),
	'Stabilization' => array( 'Stabilisering' ),
	'StablePages' => array( 'Stabile_sider' ),
	'ConfiguredPages' => array( 'Konfigurerte_sider' ),
	'ReviewedVersions' => array( 'Gjennomgåtte_sider' ),
	'UnreviewedPages' => array( 'Ikke-gjennomgåtte_sider' ),
	'ValidationStatistics' => array( 'Valideringsstatistikk' ),
);

/** Nedersaksisch (Nedersaksisch) */
$specialPageAliases['nds-nl'] = array(
	'PendingChanges' => array( 'Wiezigingen_in_wachtrie' ),
	'ProblemChanges' => array( 'Problematiese_wiezigingen' ),
	'QualityOversight' => array( 'Kwaliteitskontrole' ),
	'ReviewedPages' => array( 'Pagina\'s_mit_eindredaksie' ),
	'RevisionReview' => array( 'Eindredaksie_versies' ),
	'Stabilization' => array( 'Stabilisasie' ),
	'StablePages' => array( 'Stabiele_pagina\'s' ),
	'ConfiguredPages' => array( 'In-estelden_pagina\'s' ),
	'ReviewedVersions' => array( 'Nao-ekeken_versies' ),
	'UnreviewedPages' => array( 'Pagina\'s_zonder_eindredaksie' ),
	'ValidationStatistics' => array( 'Eindredaksiestaotistieken' ),
);

/** Dutch (Nederlands) */
$specialPageAliases['nl'] = array(
	'PendingChanges' => array( 'PaginasVerouderdeEindredactie', 'Pagina\'sVerouderdeEindredactie' ),
	'ProblemChanges' => array( 'ProblematischeWijzigingen' ),
	'QualityOversight' => array( 'KwaliteitsControle' ),
	'ReviewedPages' => array( 'PaginasMetEindredactie', 'Pagina\'sMetEindredactie' ),
	'RevisionReview' => array( 'EindredactieVersies' ),
	'Stabilization' => array( 'Stabilisatie' ),
	'StablePages' => array( 'StabielePaginas', 'StabielePagina\'s' ),
	'ConfiguredPages' => array( 'IngesteldePaginas', 'IngesteldePagina\'s' ),
	'ReviewedVersions' => array( 'GecontroleerdeVersies', 'StabieleVersies' ),
	'UnreviewedPages' => array( 'PaginasZonderEindredactie', 'Pagina\'sZonderEindredactie' ),
	'ValidationStatistics' => array( 'Eindredactiestatistieken', 'StatistiekenEindredactie' ),
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬) */
$specialPageAliases['nn'] = array(
	'PendingChanges' => array( 'Gamle_vurderte_sider' ),
	'QualityOversight' => array( 'Kvalitetsoversyn' ),
	'ReviewedPages' => array( 'Vurderte_sider' ),
	'RevisionReview' => array( 'Versjonsvurdering' ),
	'Stabilization' => array( 'Stabilisering' ),
	'StablePages' => array( 'Stabile_sider' ),
	'UnreviewedPages' => array( 'Ikkje-vurderte_sider' ),
	'ValidationStatistics' => array( 'Valideringsstatistikk' ),
);

/** Occitan (Occitan) */
$specialPageAliases['oc'] = array(
	'PendingChanges' => array( 'PaginasAncianasRelegidas' ),
	'QualityOversight' => array( 'SupervisorQualitat' ),
	'ReviewedPages' => array( 'Paginas_revisadas', 'PaginasRevisadas' ),
	'RevisionReview' => array( 'Relectura_de_las_revisions' ),
	'StablePages' => array( 'Paginas_establas', 'PaginasEstablas' ),
	'UnreviewedPages' => array( 'Paginas_pas_relegidas', 'PaginasPasRelegidas' ),
);

/** Polish (Polski) */
$specialPageAliases['pl'] = array(
	'PendingChanges' => array( 'Zdezaktualizowane_przejrzane_strony' ),
	'ProblemChanges' => array( 'Wątpliwe_zmiany' ),
	'QualityOversight' => array( 'Rejestr_oznaczania_wersji' ),
	'ReviewedPages' => array( 'Przejrzane_strony' ),
	'RevisionReview' => array( 'Oznaczenie_wersji' ),
	'Stabilization' => array( 'Konfiguracja_strony' ),
	'StablePages' => array( 'Strony_stabilizowane', 'Strony_z_domyślnie_pokazywaną_wersją_oznaczoną' ),
	'ConfiguredPages' => array( 'Skonfigurowane_strony' ),
	'ReviewedVersions' => array( 'Przejrzane_wersje' ),
	'UnreviewedPages' => array( 'Nieprzejrzane_strony' ),
	'ValidationStatistics' => array( 'Statystyki_oznaczania' ),
);

/** Portuguese (Português) */
$specialPageAliases['pt'] = array(
	'PendingChanges' => array( 'Páginas_analisadas_antigas' ),
	'QualityOversight' => array( 'Controlo_de_qualidade' ),
	'ReviewedPages' => array( 'Páginas_analisadas' ),
	'RevisionReview' => array( 'Revisão_de_versões' ),
	'Stabilization' => array( 'Estabilização' ),
	'StablePages' => array( 'Páginas_estáveis' ),
	'ReviewedVersions' => array( 'Versões_revistas' ),
	'UnreviewedPages' => array( 'Páginas_a_analisar' ),
	'ValidationStatistics' => array( 'Estatísticas_de_validação' ),
);

/** Brazilian Portuguese (Português do Brasil) */
$specialPageAliases['pt-br'] = array(
	'PendingChanges' => array( 'Versões_antigas_de_páginas_analisadas' ),
	'QualityOversight' => array( 'Observatório_da_qualidade' ),
	'ReviewedPages' => array( 'Páginas_analisadas' ),
	'RevisionReview' => array( 'Revisão_de_edições' ),
	'Stabilization' => array( 'Estabilização' ),
	'StablePages' => array( 'Páginas_estáveis' ),
	'ConfiguredPages' => array( 'Páginas_configuradas' ),
	'UnreviewedPages' => array( 'Páginas_a_analisar' ),
	'ValidationStatistics' => array( 'Estatísticas_de_validação' ),
);

/** Sanskrit (संस्कृतम्) */
$specialPageAliases['sa'] = array(
	'PendingChanges' => array( 'पूर्वतनआवलोकीतपृष्ठ:' ),
	'QualityOversight' => array( 'गुणपूर्णवृजावलोकन' ),
	'ReviewedPages' => array( 'समसमीक्षीतपृष्ठ:' ),
	'RevisionReview' => array( 'आवृत्तीसमसमीक्षा' ),
	'Stabilization' => array( 'स्वास्थ्य' ),
	'StablePages' => array( 'स्वस्थपृष्ठ' ),
	'UnreviewedPages' => array( 'असमसमीक्षीतपृष्ठ:' ),
	'ValidationStatistics' => array( 'उपयोगितासिद्धीसांख्यिकी' ),
);

/** Slovak (Slovenčina) */
$specialPageAliases['sk'] = array(
	'PendingChanges' => array( 'StaréSkontrolovanéStránky' ),
	'ProblemChanges' => array( 'ProblematickéZmeny' ),
	'QualityOversight' => array( 'DohľadNadKvalitou' ),
	'ReviewedPages' => array( 'SkontrolovanéStránky' ),
	'RevisionReview' => array( 'KontrolaKontroly' ),
	'Stabilization' => array( 'Stabilizácia' ),
	'StablePages' => array( 'StabilnéStránky' ),
	'UnreviewedPages' => array( 'NeskontrolovanéStránky' ),
	'ValidationStatistics' => array( 'ŠtatistikaOverovania' ),
);

/** Albanian (Shqip) */
$specialPageAliases['sq'] = array(
	'Stabilization' => array( 'Stabilizim' ),
	'StablePages' => array( 'FaqetStabile' ),
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬) */
$specialPageAliases['sr-ec'] = array(
	'PendingChanges' => array( 'СтареПрегледанеСтране' ),
	'ProblemChanges' => array( 'Проблематичне_измене' ),
	'QualityOversight' => array( 'НадгледањеКвалитета' ),
	'ReviewedPages' => array( 'ПрегледанеСтране' ),
	'RevisionReview' => array( 'Преглед_измене' ),
	'Stabilization' => array( 'Стабилизација' ),
	'StablePages' => array( 'СтабилнеСтране', 'Стабилне_странице' ),
	'ConfiguredPages' => array( 'Подешене_странице' ),
	'ReviewedVersions' => array( 'Прегледана_издања', 'Прегледане_верзије' ),
	'UnreviewedPages' => array( 'НепрегледанеСтране', 'Непрегледане_странице' ),
);

/** Swedish (Svenska) */
$specialPageAliases['sv'] = array(
	'PendingChanges' => array( 'Gamla_granskade_sidor' ),
	'ProblemChanges' => array( 'Problemändringar' ),
	'QualityOversight' => array( 'Kvalitetsöversikt' ),
	'ReviewedPages' => array( 'Granskade_sidor' ),
	'RevisionReview' => array( 'Versionsgranskning' ),
	'Stabilization' => array( 'Stabilisering' ),
	'StablePages' => array( 'Stabila_sidor' ),
	'UnreviewedPages' => array( 'Ogranskade_sidor' ),
	'ValidationStatistics' => array( 'Valideringsstatistik' ),
);

/** Swahili (Kiswahili) */
$specialPageAliases['sw'] = array(
	'PendingChanges' => array( 'KurasaZilizoonyeshwaAwali' ),
	'ReviewedPages' => array( 'OnyeshaKurasa' ),
	'Stabilization' => array( 'Uimalishaji' ),
	'StablePages' => array( 'KurasaImara' ),
	'UnreviewedPages' => array( 'KurasaZisizoonyeshwa' ),
	'ValidationStatistics' => array( 'TakwimuIliyosahihi' ),
);

/** Tagalog (Tagalog) */
$specialPageAliases['tl'] = array(
	'PendingChanges' => array( 'Nasuring lumang mga pahina' ),
	'QualityOversight' => array( 'Maingat na pamamahala ng kalidad' ),
	'ReviewedPages' => array( 'Sinuring mga pahina' ),
	'RevisionReview' => array( 'Pagsusuri ng pagbabago' ),
	'Stabilization' => array( 'Pagpapatatag', 'Pagpapatibay' ),
	'StablePages' => array( 'Matatag na mga pahina' ),
	'UnreviewedPages' => array( 'Mga pahina hindi pa nasusuri' ),
	'ValidationStatistics' => array( 'Mga estadistika ng pagtitiyak' ),
);

/** Turkish (Türkçe) */
$specialPageAliases['tr'] = array(
	'PendingChanges' => array( 'BekleyenDeğişiklikler', 'EskiİncelenmişSayfalar' ),
	'ProblemChanges' => array( 'ProblemliDeğişiklikler', 'ProblemDeğişiklikleri' ),
	'QualityOversight' => array( 'GelişmişİncelemeGünlüğü', 'KaliteGözetimi' ),
	'ReviewedPages' => array( 'İncelenmişSayfalar' ),
	'RevisionReview' => array( 'Revizyonİnceleme', 'Revizyonİncele' ),
	'Stabilization' => array( 'Kararlılık', 'Stabilizasyon' ),
	'StablePages' => array( 'KararlıSayfalar', 'StabilSayfalar' ),
	'ConfiguredPages' => array( 'YapılandırılmışSayfalar', 'KonfigüreSayfalar' ),
	'ReviewedVersions' => array( 'İncelenmişSürümler', 'KararlıSürümler', 'StabilSürümler' ),
	'UnreviewedPages' => array( 'İncelenmemişSayfalar' ),
	'ValidationStatistics' => array( 'Doğrulamaİstatistikleri' ),
);

/** Tatar (Cyrillic script) (Татарча) */
$specialPageAliases['tt-cyrl'] = array(
	'StablePages' => array( 'Тотрыклы_битләр' ),
);

/** Vèneto (Vèneto) */
$specialPageAliases['vec'] = array(
	'PendingChanges' => array( 'PagineRiesaminàVèce' ),
	'QualityOversight' => array( 'ControloQualità' ),
	'ReviewedPages' => array( 'PagineRiesaminà' ),
	'StablePages' => array( 'PagineStabili' ),
	'UnreviewedPages' => array( 'PagineNonRiesaminà' ),
	'ValidationStatistics' => array( 'StatìstegheDeValidassion' ),
);

/** Vietnamese (Tiếng Việt) */
$specialPageAliases['vi'] = array(
	'PendingChanges' => array( 'Trang_chưa_duyệt_cũ' ),
	'QualityOversight' => array( 'Giám_sát_chất_lượng' ),
	'ReviewedPages' => array( 'Trang_đã_duyệt' ),
	'StablePages' => array( 'Trang_ổn_định' ),
	'UnreviewedPages' => array( 'Trang_chưa_duyệt' ),
	'ValidationStatistics' => array( 'Thống_kê_duyệt' ),
);

/** Simplified Chinese (‪中文(简体)‬) */
$specialPageAliases['zh-hans'] = array(
	'PendingChanges' => array( '待复审的更改' ),
	'ProblemChanges' => array( '有问题的更改' ),
	'QualityOversight' => array( '高级复审日志' ),
	'ReviewedPages' => array( '已复审页面' ),
	'RevisionReview' => array( '修订复审' ),
	'Stabilization' => array( '稳定化' ),
	'StablePages' => array( '稳定页面' ),
	'ConfiguredPages' => array( '配置页面' ),
	'ReviewedVersions' => array( '已复审版本' ),
	'UnreviewedPages' => array( '未复审页面' ),
	'ValidationStatistics' => array( '复审统计信息' ),
);

/** Traditional Chinese (‪中文(繁體)‬) */
$specialPageAliases['zh-hant'] = array(
	'PendingChanges' => array( '等待審核的更改' ),
	'ProblemChanges' => array( '問題改變' ),
	'QualityOversight' => array( '進階審閱日誌' ),
	'ReviewedPages' => array( '已審閱頁面' ),
	'RevisionReview' => array( '版本審核' ),
	'Stabilization' => array( '穩定性' ),
	'StablePages' => array( '穩定頁面' ),
	'ConfiguredPages' => array( '頁面審核設定' ),
	'ReviewedVersions' => array( '穩定版本' ),
	'UnreviewedPages' => array( '未審閱頁面' ),
	'ValidationStatistics' => array( '驗證數據' ),
);