<?php
/**
 * Aliases for special pages of CentralAuth  extension.
 *
 * @addtogroup Extensions
 */

$aliases = array();

/** English
 * @author Jon Harald Søby
 */
$aliases['en'] = array(
	'CentralAuth'            => array( 'CentralAuth' ),
	'AutoLogin'              => array( 'AutoLogin' ),
	'MergeAccount'           => array( 'MergeAccount' ),
	'GlobalGroupMembership'  => array( 'GlobalUserRights', 'GlobalGroupMembership' ),
	'GlobalGroupPermissions' => array( 'GlobalGroupPermissions' ),
	'EditWikiSets'           => array( 'EditWikiSets' ),
	'GlobalUsers'            => array( 'GlobalUsers' ),
);

/** Afrikaans (Afrikaans) */
$aliases['af'] = array(
	'GlobalUsers' => array( 'GlobaleGebruikers' ),
);

/** Arabic (العربية) */
$aliases['ar'] = array(
	'CentralAuth' => array( 'تحقق_مركزي' ),
	'AutoLogin' => array( 'دخول_تلقائي' ),
	'MergeAccount' => array( 'دمج_حساب' ),
	'GlobalGroupMembership' => array( 'صلاحيات_المستخدم_العامة', 'عضوية_المجموعة_العامة' ),
	'GlobalGroupPermissions' => array( 'سماحات_المجموعة_العامة' ),
	'EditWikiSets' => array( 'تعديل_مجموعات_الويكي' ),
	'GlobalUsers' => array( 'مستخدمون_عامون' ),
);

/** Egyptian Spoken Arabic (مصرى) */
$aliases['arz'] = array(
	'CentralAuth' => array( 'تحقق_مركزى' ),
	'AutoLogin' => array( 'دخول_تلقائى' ),
	'MergeAccount' => array( 'دمج_حساب' ),
	'GlobalGroupMembership' => array( 'صلاحيات_المستخدم_العامة', 'عضوية_المجموعة_العامة' ),
	'GlobalGroupPermissions' => array( 'سماحات_المجموعة_العامة' ),
	'EditWikiSets' => array( 'تعديل_مجموعات_الويكى' ),
	'GlobalUsers' => array( 'مستخدمون_عامون' ),
);

/** Bulgarian (Български) */
$aliases['bg'] = array(
	'CentralAuth' => array( 'Управление на единните сметки' ),
	'AutoLogin' => array( 'Автоматично влизане' ),
	'MergeAccount' => array( 'Обединяване на сметки' ),
	'GlobalGroupMembership' => array( 'Глобални потребителски права' ),
	'GlobalUsers' => array( 'Списък на глобалните сметки' ),
);

/** Bosnian (Bosanski) */
$aliases['bs'] = array(
	'CentralAuth' => array( 'SredisnjaAutent' ),
	'AutoLogin' => array( 'AutoPrijava' ),
	'MergeAccount' => array( 'UjediniRacune' ),
	'GlobalGroupMembership' => array( 'GlobalnaKorisnicnaPrava' ),
	'GlobalGroupPermissions' => array( 'GlobalneDozvoleGrupa' ),
	'EditWikiSets' => array( 'UrediWikiSetove' ),
	'GlobalUsers' => array( 'GlobalniKorisnici' ),
);

/** Catalan (Català) */
$aliases['ca'] = array(
	'MergeAccount' => array( 'Fusió de comptes' ),
	'GlobalUsers' => array( 'Usuaris globals' ),
);

/** German (Deutsch) */
$aliases['de'] = array(
	'CentralAuth' => array( 'Verwaltung Benutzerkonten-Zusammenführung' ),
	'AutoLogin' => array( 'Automatische Anmeldung' ),
	'MergeAccount' => array( 'Benutzerkonten zusammenführen' ),
	'GlobalGroupMembership' => array( 'Globale Benutzerzugehörigkeit' ),
	'GlobalGroupPermissions' => array( 'Globale Gruppenrechte' ),
	'EditWikiSets' => array( 'Wikisets bearbeiten' ),
	'GlobalUsers' => array( 'Globale Benutzerliste' ),
);

/** Lower Sorbian (Dolnoserbski) */
$aliases['dsb'] = array(
	'CentralAuth' => array( 'Zjadnośenje kontow' ),
	'AutoLogin' => array( 'Awtomatiske pśizjawjenje' ),
	'MergeAccount' => array( 'Konta zjadnośiś' ),
	'GlobalGroupMembership' => array( 'Cłonkojstwo w globalnej kupce' ),
	'GlobalGroupPermissions' => array( 'Globalne kupkowe pšawa' ),
	'EditWikiSets' => array( 'Wikisajźby wobźěłaś' ),
	'GlobalUsers' => array( 'Globalne wužywarje' ),
);

/** Greek (Ελληνικά) */
$aliases['el'] = array(
	'AutoLogin' => array( 'ΑυτόματηΣύνδεση' ),
	'MergeAccount' => array( 'ΣυγχώνευσηΛογαριασμού' ),
	'GlobalGroupMembership' => array( 'ΚαθολικάΔικαιώματαΧρηστών' ),
	'GlobalGroupPermissions' => array( 'ΚαθολικέςΆδειεςΧρηστών' ),
	'GlobalUsers' => array( 'ΚαθολικοίΧρήστες' ),
);

/** Spanish (Español) */
$aliases['es'] = array(
	'GlobalUsers' => array( 'Usuarios_globales' ),
);

/** Estonian (Eesti) */
$aliases['et'] = array(
	'CentralAuth' => array( 'Kontode_ühendamine' ),
	'AutoLogin' => array( 'Automaatne_sisselogimine' ),
	'MergeAccount' => array( 'Kontode_ühendamise_seis' ),
	'GlobalGroupMembership' => array( 'Globaalse_kasutaja_õigused' ),
	'GlobalGroupPermissions' => array( 'Globaalse_rühma_haldamine' ),
	'GlobalUsers' => array( 'Globaalsed_kasutajad' ),
);

/** Persian (فارسی) */
$aliases['fa'] = array(
	'CentralAuth' => array( 'ورود_متمرکز' ),
	'AutoLogin' => array( 'ورود_خودکار' ),
	'MergeAccount' => array( 'ادغام_حساب' ),
	'GlobalGroupMembership' => array( 'اختیارات_سراسری_کاربر' ),
	'GlobalGroupPermissions' => array( 'اختیارات_سراسری_گروه' ),
	'EditWikiSets' => array( 'ویرایش_مجموعه‌های_ویکی' ),
	'GlobalUsers' => array( 'کاربران_سراسری' ),
);

/** Finnish (Suomi) */
$aliases['fi'] = array(
	'CentralAuth' => array( 'Keskitetty varmennus' ),
	'AutoLogin' => array( 'Automaattikirjautuminen' ),
	'MergeAccount' => array( 'Yhdistä tunnus' ),
	'GlobalUsers' => array( 'Yhdistetyt tunnukset' ),
);

/** French (Français) */
$aliases['fr'] = array(
	'AutoLogin' => array( 'Connexion automatique', 'ConnexionAutomatique', 'ConnexionAuto', 'Login automatique', 'LoginAutomatique', 'LoginAuto' ),
	'MergeAccount' => array( 'Fusionner le compte', 'FusionnerLeCompte' ),
	'GlobalGroupMembership' => array( 'Permissions globales', 'PermissionGlobales' ),
	'GlobalGroupPermissions' => array( 'Droits des groupes globaux', 'DroitsDesGroupesGlobaux' ),
	'EditWikiSets' => array( 'Modifier les sets de wikis', 'ModifierLesSetsDeWiki' ),
	'GlobalUsers' => array( 'Utilisateurs globaux', 'UtilisateursGlobaux' ),
);

/** Franco-Provençal (Arpetan) */
$aliases['frp'] = array(
	'CentralAuth' => array( 'Administracion des comptos fusionâs', 'AdministracionDesComptosFusionâs' ),
	'AutoLogin' => array( 'Branchement ôtomatico', 'BranchementÔtomatico' ),
	'MergeAccount' => array( 'Fusionar los comptos', 'FusionarLosComptos' ),
	'GlobalGroupMembership' => array( 'Pèrmissions globâles', 'PèrmissionsGlobâles' ),
	'GlobalGroupPermissions' => array( 'Drêts a les tropes globâles', 'DrêtsALesTropesGlobâles' ),
	'EditWikiSets' => array( 'Changiér los sèts de vouiquis', 'ChangiérLosSètsDeVouiquis' ),
	'GlobalUsers' => array( 'Utilisators globâls', 'UtilisatorsGlobâls' ),
);

/** Galician (Galego) */
$aliases['gl'] = array(
	'MergeAccount' => array( 'Fusionar contas' ),
	'GlobalGroupMembership' => array( 'Dereitos de usuario globais' ),
	'GlobalUsers' => array( 'Usuarios globais' ),
);

/** Swiss German (Alemannisch) */
$aliases['gsw'] = array(
	'CentralAuth' => array( 'Verwaltig Benutzerchonte-Zämmefierig' ),
	'AutoLogin' => array( 'Automatischi Aamäldig' ),
	'MergeAccount' => array( 'Benutzerchonte zämmefiere' ),
	'GlobalGroupMembership' => array( 'Wältwyti Benutzerrächt' ),
	'GlobalGroupPermissions' => array( 'Wältwyti Grupperächt' ),
	'EditWikiSets' => array( 'Wikisets bearbeite' ),
	'GlobalUsers' => array( 'Wältwyti Benutzerlischt' ),
);

/** Gujarati (ગુજરાતી) */
$aliases['gu'] = array(
	'CentralAuth' => array( 'કેન્દ્રીયશપથ' ),
	'AutoLogin' => array( 'સ્વયંભૂલોગીન' ),
	'GlobalUsers' => array( 'વૈશ્વીકસભ્ય' ),
);

/** Hebrew (עברית) */
$aliases['he'] = array(
	'CentralAuth' => array( 'חשבון_משתמש_מאוחד' ),
	'AutoLogin' => array( 'כניסה_אוטומטית' ),
	'MergeAccount' => array( 'מיזוג_חשבונות' ),
	'GlobalGroupMembership' => array( 'הרשאות_משתמש_כלליות', 'חברות_בקבוצות_כלליות' ),
	'GlobalGroupPermissions' => array( 'הרשאות_קבוצות_כלליות' ),
	'EditWikiSets' => array( 'עריכת_קבוצות_אתרי_ויקי' ),
	'GlobalUsers' => array( 'משתמשים_כלליים' ),
);

/** Croatian (Hrvatski) */
$aliases['hr'] = array(
	'CentralAuth' => array( 'Središnja_prijava' ),
	'AutoLogin' => array( 'AutoPrijava' ),
	'MergeAccount' => array( 'Spoji_račun' ),
	'GlobalGroupMembership' => array( 'Globalna_suradnička_prava' ),
	'GlobalGroupPermissions' => array( 'Globalna_prava_skupina' ),
	'EditWikiSets' => array( 'Uredi_wikiset' ),
	'GlobalUsers' => array( 'Globalni_suradnici' ),
);

/** Upper Sorbian (Hornjoserbsce) */
$aliases['hsb'] = array(
	'CentralAuth' => array( 'Zjednoćenje kontow' ),
	'AutoLogin' => array( 'Awtomatiske přizjewjenje' ),
	'MergeAccount' => array( 'Konta zjednoćić' ),
	'GlobalGroupMembership' => array( 'Globalne wužiwarske prawa' ),
	'GlobalGroupPermissions' => array( 'Globalne skupinske prawa' ),
	'EditWikiSets' => array( 'Wikisadźby wobdźěłać' ),
	'GlobalUsers' => array( 'Globalni wužiwarjo' ),
);

/** Hungarian (Magyar) */
$aliases['hu'] = array(
	'CentralAuth' => array( 'Központi azonosítás' ),
	'AutoLogin' => array( 'Automatikus bejelentkezés' ),
	'MergeAccount' => array( 'Szerkesztői fiókok egyesítése', 'Felhasználói fiókok egyesítése' ),
	'GlobalGroupMembership' => array( 'Globális szerkesztői jogok', 'Globális felhasználói jogok' ),
	'GlobalGroupPermissions' => array( 'Globális szerkesztői engedélyek', 'Globális felhasználói engedélyek' ),
	'EditWikiSets' => array( 'Wikicsoportok szerkesztése' ),
	'GlobalUsers' => array( 'Globális szerkesztőlista', 'Globális felhasználólista', 'Felhasználók globális listája' ),
);

/** Interlingua (Interlingua) */
$aliases['ia'] = array(
	'CentralAuth' => array( 'Auth central' ),
	'AutoLogin' => array( 'Autosession', 'AutoSession' ),
	'MergeAccount' => array( 'Fusionar conto' ),
	'GlobalGroupMembership' => array( 'Membrato global de gruppos' ),
	'GlobalGroupPermissions' => array( 'Permissiones global de gruppos' ),
	'EditWikiSets' => array( 'Modificar sets de wikis' ),
	'GlobalUsers' => array( 'Usatores global' ),
);

/** Indonesian (Bahasa Indonesia) */
$aliases['id'] = array(
	'CentralAuth' => array( 'Otoritas pusat', 'OtoritasPusat' ),
	'AutoLogin' => array( 'Masuk log otomatis', 'MasukLogOtomatis' ),
	'MergeAccount' => array( 'Gabungkan akun', 'GabungkanAkun' ),
	'GlobalGroupMembership' => array( 'Hak pengguna global', 'HakPenggunaGlobal' ),
	'GlobalGroupPermissions' => array( 'Hak kelompok global', 'HakKelompokGlobal' ),
	'EditWikiSets' => array( 'Sunting kelompok wiki', 'SuntingKelompokWiki' ),
	'GlobalUsers' => array( 'Pengguna global', 'PenggunaGlobal' ),
);

/** Italian (Italiano) */
$aliases['it'] = array(
	'MergeAccount' => array( 'UnificaUtenze' ),
	'GlobalGroupMembership' => array( 'PermessiUtenteGlobale' ),
	'GlobalGroupPermissions' => array( 'PermessiGruppoGlobale' ),
	'GlobalUsers' => array( 'UtentiGlobali' ),
);

/** Japanese (日本語) */
$aliases['ja'] = array(
	'CentralAuth' => array( 'アカウント統一管理', '統一ログインの管理' ),
	'AutoLogin' => array( '自動ログイン' ),
	'MergeAccount' => array( 'アカウント統合' ),
	'GlobalGroupMembership' => array( 'グローバルグループへの所属' ),
	'GlobalGroupPermissions' => array( 'グローバルグループ権限', 'グローバルグループパーミッション' ),
	'EditWikiSets' => array( 'ウィキ群の編集' ),
	'GlobalUsers' => array( 'グローバル利用者' ),
);

/** Khmer (ភាសាខ្មែរ) */
$aliases['km'] = array(
	'AutoLogin' => array( 'ឡុកអ៊ីនដោយស្វ័យប្រវត្តិ' ),
	'MergeAccount' => array( 'ច្របាច់បញ្ចូលគណនី' ),
);

/** Korean (한국어) */
$aliases['ko'] = array(
	'CentralAuth' => array( '통합계정관리' ),
	'AutoLogin' => array( '자동로그인' ),
	'MergeAccount' => array( '계정합치기', '사용자합치기' ),
	'GlobalGroupMembership' => array( '공통권한조정' ),
	'GlobalGroupPermissions' => array( '전체 그룹 권한' ),
	'GlobalUsers' => array( '통합계정목록', '공통계정목록' ),
);

/** Ripoarisch (Ripoarisch) */
$aliases['ksh'] = array(
	'AutoLogin' => array( 'AutomatteschEnlogge' ),
	'GlobalGroupMembership' => array( 'JemeinsamMetmaacherJroppeRääschte' ),
	'GlobalGroupPermissions' => array( 'JemeinsamJroppe' ),
	'EditWikiSets' => array( 'WikiJroppe' ),
	'GlobalUsers' => array( 'Jemeinsam_Metmaacher', 'JemeinsamMetmaacher', 'Jemeinsam_Medmaacher', 'JemeinsamMedmaacher' ),
);

/** Luxembourgish (Lëtzebuergesch) */
$aliases['lb'] = array(
	'CentralAuth' => array( 'Verwaltung vun der Benotzerkonten-Zesummeféierung' ),
	'AutoLogin' => array( 'Automatesch Umeldung' ),
	'MergeAccount' => array( 'Benotzerkonten zesummeféieren' ),
	'GlobalGroupMembership' => array( 'Member vu globale Benotzerrechter' ),
	'GlobalGroupPermissions' => array( 'Global Grupperechter' ),
	'EditWikiSets' => array( 'Wiki-Seten änneren' ),
	'GlobalUsers' => array( 'Global Benotzer' ),
);

/** Lithuanian (Lietuvių) */
$aliases['lt'] = array(
	'AutoLogin' => array( 'Automatinis prisijungimas' ),
	'MergeAccount' => array( 'Sujungti sąskaitas' ),
);

/** Macedonian (Македонски) */
$aliases['mk'] = array(
	'CentralAuth' => array( 'ЦентралнаАвтентикација' ),
	'AutoLogin' => array( 'АвтоматскоНајавување' ),
	'MergeAccount' => array( 'СпојувањеНаСметки' ),
	'GlobalGroupMembership' => array( 'ПраваНаГлобаленКорисник', 'ЧленствоВоГлобалнаГрупа' ),
	'GlobalGroupPermissions' => array( 'ДозволиНаГлобалнаГрупа' ),
	'GlobalUsers' => array( 'ГлобалниКорисници' ),
);

/** Malayalam (മലയാളം) */
$aliases['ml'] = array(
	'CentralAuth' => array( 'കേന്ദ്രീകൃത അംഗീകാരം' ),
	'AutoLogin' => array( 'സ്വയംപ്രവേശനം' ),
	'MergeAccount' => array( 'അംഗത്വസം‌യോജനം' ),
	'GlobalGroupMembership' => array( 'ആഗോള ഉപയോക്തൃ അവകാശങ്ങള്‍', 'ആഗോള ഉപയോക്തൃ അംഗത്വം' ),
	'GlobalGroupPermissions' => array( 'ആഗോള അംഗത്വാനുമതികള്‍' ),
	'EditWikiSets' => array( 'വിക്കിഗണങ്ങൾ തിരുത്തുക' ),
	'GlobalUsers' => array( 'ആഗോള ഉപയോക്താക്കള്‍' ),
);

/** Marathi (मराठी) */
$aliases['mr'] = array(
	'CentralAuth' => array( 'मध्यवर्तीअधिकारी' ),
	'AutoLogin' => array( 'स्वयंप्रवेश' ),
	'MergeAccount' => array( 'खातेविलीनीकरण' ),
	'GlobalGroupMembership' => array( 'वैश्विकसदस्याधिकार', 'वैश्विकगटसदस्यता' ),
	'GlobalGroupPermissions' => array( 'वैश्विकगटपरवानग्या' ),
	'EditWikiSets' => array( 'विकिसंचसंपादा' ),
	'GlobalUsers' => array( 'वैश्विकसदस्य' ),
);

/** Malay (Bahasa Melayu) */
$aliases['ms'] = array(
	'MergeAccount' => array( 'Gabungkan akaun' ),
	'GlobalGroupMembership' => array( 'Hak kumpulan sejagat' ),
	'GlobalGroupPermissions' => array( 'Keizinan kumpulan sejagat' ),
	'EditWikiSets' => array( 'Ubah set wiki' ),
	'GlobalUsers' => array( 'Pengguna sejagat' ),
);

/** Maltese (Malti) */
$aliases['mt'] = array(
	'AutoLogin' => array( 'LoginAwtomatiku', 'DħulAwtomatiku' ),
	'MergeAccount' => array( 'WaħħadKont' ),
	'GlobalUsers' => array( 'UtentiGlobali' ),
);

/** Erzya (Эрзянь) */
$aliases['myv'] = array(
	'MergeAccount' => array( 'ВейтьсэндямсСовамоТарка' ),
);

/** Nedersaksisch (Nedersaksisch) */
$aliases['nds-nl'] = array(
	'CentralAuth' => array( 'Centraal_anmelden' ),
	'AutoLogin' => array( 'Autematisch_anmelden' ),
	'MergeAccount' => array( 'Gebruker_samenvoegen' ),
	'GlobalGroupMembership' => array( 'Globale_gebrukersrechen' ),
	'GlobalGroupPermissions' => array( 'Globale_groepsrechen' ),
	'EditWikiSets' => array( 'Wikigroepen_bewarken' ),
	'GlobalUsers' => array( 'Globale_gebrukers' ),
);

/** Dutch (Nederlands) */
$aliases['nl'] = array(
	'CentralAuth' => array( 'CentraalAanmelden' ),
	'AutoLogin' => array( 'AutomatischAanmelden', 'AutoAanmelden' ),
	'MergeAccount' => array( 'GebruikerSamenvoegen' ),
	'GlobalGroupMembership' => array( 'GlobaalGroepslidmaatschap' ),
	'GlobalGroupPermissions' => array( 'GlobaleGroepsrechten' ),
	'EditWikiSets' => array( 'WikigroepenBewerken' ),
	'GlobalUsers' => array( 'GlobaleGebruikers' ),
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬) */
$aliases['nn'] = array(
	'MergeAccount' => array( 'Kontosamanslåing' ),
	'GlobalGroupMembership' => array( 'Globale brukarrettar' ),
	'GlobalUsers' => array( 'Globale brukarar' ),
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬) */
$aliases['no'] = array(
	'CentralAuth' => array( 'Enhetlig innlogging' ),
	'AutoLogin' => array( 'Automatisk innlogging' ),
	'MergeAccount' => array( 'Kontosammenslåing' ),
	'GlobalGroupMembership' => array( 'Globale brukerrettigheter' ),
	'GlobalGroupPermissions' => array( 'Globale gruppetillatelser' ),
	'EditWikiSets' => array( 'Rediger wikisett' ),
	'GlobalUsers' => array( 'Globale brukere' ),
);

/** Occitan (Occitan) */
$aliases['oc'] = array(
	'AutoLogin' => array( 'Login Automatic', 'LoginAutomatic', 'LoginAuto' ),
	'MergeAccount' => array( 'Fusionar lo compte', 'FusionarLoCompte' ),
	'GlobalGroupMembership' => array( 'Permissions globalas', 'PermissionGlobalas' ),
	'GlobalGroupPermissions' => array( 'Dreches dels gropes globals', 'DrechesDelsGropesGlobals' ),
	'EditWikiSets' => array( 'Modificar los sets de wikis', 'ModificarLosSetsDeWiki' ),
	'GlobalUsers' => array( 'Utilizaires globals', 'UtilizairesGlobals' ),
);

/** Polish (Polski) */
$aliases['pl'] = array(
	'CentralAuth' => array( 'Zarządzanie kontem uniwersalnym' ),
	'AutoLogin' => array( 'Automatyczne logowanie' ),
	'MergeAccount' => array( 'Łączenie kont', 'Konto uniwersalne' ),
	'GlobalGroupMembership' => array( 'Globalne uprawnienia' ),
	'GlobalGroupPermissions' => array( 'Globalne uprawnienia grup' ),
	'GlobalUsers' => array( 'Spis kont uniwersalnych' ),
);

/** Portuguese (Português) */
$aliases['pt'] = array(
	'AutoLogin' => array( 'Autenticação automática' ),
	'MergeAccount' => array( 'Fundir conta' ),
	'GlobalGroupMembership' => array( 'Grupos globais' ),
	'GlobalGroupPermissions' => array( 'Privilégios globais de grupo' ),
	'GlobalUsers' => array( 'Utilizadores globais' ),
);

/** Brazilian Portuguese (Português do Brasil) */
$aliases['pt-br'] = array(
	'AutoLogin' => array( 'Login automático' ),
	'MergeAccount' => array( 'Mesclar conta' ),
	'GlobalUsers' => array( 'Usuários globais' ),
);

/** Romanian (Română) */
$aliases['ro'] = array(
	'CentralAuth' => array( 'Autentificare centrală' ),
	'AutoLogin' => array( 'Autentificare automată' ),
	'MergeAccount' => array( 'Uneşte conturi' ),
	'GlobalGroupMembership' => array( 'Drepturi globale utilizator', 'Membru global grup' ),
	'GlobalGroupPermissions' => array( 'Permisiuni grup globale' ),
	'EditWikiSets' => array( 'Setări modificare Wiki' ),
	'GlobalUsers' => array( 'Utilizatori globali' ),
);

/** Sanskrit (संस्कृत) */
$aliases['sa'] = array(
	'CentralAuth' => array( 'मध्यवर्तीप्रामान्य' ),
	'AutoLogin' => array( 'स्वयमेवप्रवेश' ),
	'MergeAccount' => array( 'उपयोजकसंज्ञासंयोग' ),
	'GlobalGroupMembership' => array( 'वैश्विकसदस्याधिकार' ),
	'GlobalGroupPermissions' => array( 'वैश्विकगटसंमती' ),
	'EditWikiSets' => array( 'सम्पादनविकिगट' ),
	'GlobalUsers' => array( 'वैश्विकयोजक' ),
);

/** Sinhala (සිංහල) */
$aliases['si'] = array(
	'CentralAuth' => array( 'මධ්‍යඅවසර' ),
	'AutoLogin' => array( 'ස්වයංක්‍රීයපිවිසුම' ),
	'MergeAccount' => array( 'ගිණුමඑක්කරන්න' ),
);

/** Slovak (Slovenčina) */
$aliases['sk'] = array(
	'CentralAuth' => array( 'CentrálneOverenie' ),
	'AutoLogin' => array( 'AutomatickéPrihlasovanie' ),
	'MergeAccount' => array( 'ZlúčenieÚčtov' ),
	'GlobalGroupMembership' => array( 'GlobálnePrávaPoužívateľa' ),
	'GlobalGroupPermissions' => array( 'GlobálneSkupinovéOprávnenia' ),
	'EditWikiSets' => array( 'UpraviťWikiMnožiny' ),
	'GlobalUsers' => array( 'GlobálniPoužívatelia' ),
);

/** Sundanese (Basa Sunda) */
$aliases['su'] = array(
	'MergeAccount' => array( 'GabungRekening' ),
);

/** Swedish (Svenska) */
$aliases['sv'] = array(
	'CentralAuth' => array( 'Gemensam inloggning' ),
	'AutoLogin' => array( 'Automatisk inloggning' ),
	'MergeAccount' => array( 'Slå ihop konton' ),
	'GlobalUsers' => array( 'Globala användare' ),
);

/** Swahili (Kiswahili) */
$aliases['sw'] = array(
	'AutoLogin' => array( 'IngiaEFnyewe' ),
	'MergeAccount' => array( 'KusanyaAkaunti' ),
);

/** Tagalog (Tagalog) */
$aliases['tl'] = array(
	'CentralAuth' => array( 'Lundayan ng pahintulot' ),
	'AutoLogin' => array( 'Kusang paglagda' ),
	'MergeAccount' => array( 'Pagsanibin ang akawnt' ),
	'GlobalGroupMembership' => array( 'Mga karapatan ng pandaigdigang tagagamit', 'Kasapian sa pandaigdigang pangkat' ),
	'GlobalGroupPermissions' => array( 'Mga kapahintulutan ng pandaigdigang pangkat' ),
	'EditWikiSets' => array( 'Mga pangkat ng pamamatnugot ng wiki' ),
	'GlobalUsers' => array( 'Pandaigdigang mga tagagamit' ),
);

/** Turkish (Türkçe) */
$aliases['tr'] = array(
	'AutoLogin' => array( 'OtomatikOturumAçma' ),
	'MergeAccount' => array( 'HesapBirleştirmeDurumu' ),
	'GlobalGroupMembership' => array( 'KüreselGrupÜyeliği' ),
	'GlobalGroupPermissions' => array( 'KüreselGrupİzinleri' ),
	'EditWikiSets' => array( 'VikiDizileriniDüzenle' ),
	'GlobalUsers' => array( 'KüreselKullanıcılar' ),
);

/** Vèneto (Vèneto) */
$aliases['vec'] = array(
	'MergeAccount' => array( 'UnissiUtense' ),
	'GlobalGroupMembership' => array( 'DiritiUtenteGlobali' ),
	'GlobalGroupPermissions' => array( 'ParmessiUtentiGlobali' ),
	'GlobalUsers' => array( 'UtentiGlobali' ),
);

/** Simplified Chinese (‪中文(简体)‬) */
$aliases['zh-hans'] = array(
	'CentralAuth' => array( '中央认证' ),
	'AutoLogin' => array( '自动登录' ),
	'MergeAccount' => array( '整合账户' ),
	'GlobalGroupMembership' => array( '全域用户权利', '全域组成员资格' ),
	'GlobalGroupPermissions' => array( '全域组权限' ),
	'EditWikiSets' => array( '编辑Wiki组' ),
	'GlobalUsers' => array( '全域用户' ),
);

/** Traditional Chinese (‪中文(繁體)‬) */
$aliases['zh-hant'] = array(
	'CentralAuth' => array( '中央認證' ),
	'AutoLogin' => array( '自動登錄' ),
	'MergeAccount' => array( '整合賬戶' ),
	'GlobalGroupMembership' => array( '全域用戶權利', '全域組成員資格' ),
	'GlobalGroupPermissions' => array( '全域組權限' ),
	'EditWikiSets' => array( '編輯Wiki組' ),
	'GlobalUsers' => array( '全域用戶' ),
);

