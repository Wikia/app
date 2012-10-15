<?php
/**
 * Internationalization file for Package Force extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Svip
 */
$messages['en'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'PackageForceAdmin',
	'pf-desc' => '[[Special:PackageForce|Download packages]] of useful templates/etc.',
	'pf-only-admins-allowed' => "This page is only for users with the 'packageforce-admin'-right.",

	/* admin links */
	'pf-admin-menu-default'	=> 'Default',
	'pf-admin-menu-unsortedtemplates' => 'Templates not yet sorted',
	'pf-admin-link-view-documentation' => 'View documentations tied to page.',
	'pf-admin-link-editlink-page' => 'Edit page',
	'pf-admin-link-approve' => 'Approve page',

	/* table headers */
	'pf-header-documentation' => 'Documentation',
	'pf-header-in_packages' => 'Packages',
	'pf-header-edit' => 'Edit link',
	'pf-header-type' => 'Type of page',
	'pf-header-page_title' => 'Title',
	'pf-header-approve' => 'Approve',

	#'right-packageforce-admin' => '', Todo: Add a descriptive message for these
	#'right-packageforce-edit' => '',  new rights. It is shown at Special:ListGroupRights
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author McDutchie
 * @author Purodha
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'pf-desc' => '{{desc}}

Hint: The linked special page allows to collect stuff and make it into downloadable packages.',
	'pf-only-admins-allowed' => 'Do not translate "<code lang="en">packageforce-admin</code>".',
	'pf-admin-menu-default' => '{{Identical|Default}}',
	'pf-admin-link-editlink-page' => 'This is a link anchor. The page it links to allows users to edit the Package page. The link itself is an entry in a table column, the column header of which is {{msg-mw|Pf-header-edit}}',
	'pf-header-documentation' => '{{Identical|Documentation}}',
	'pf-header-edit' => 'This is a column header in a table. In the rows, there are clickable links with description {{msg-mw|pf-admin-link-editlink-page}} that allow users to edit the Package page.',
	'pf-header-page_title' => '{{Identical|Title}}',
	'pf-header-approve' => '{{Identical|Approve}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'pf-admin-menu-default' => 'Standaard',
	'pf-header-approve' => 'Keur goed',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'pf-admin-link-approve' => 'ܩܒܘܠ ܕܦܐ',
	'pf-header-documentation' => 'ܐܫܛܪܘܬܐ',
	'pf-header-edit' => 'ܫܚܠܦ ܐܣܘܪܐ',
	'pf-header-type' => 'ܐܕܫܐ ܕܕܦܐ',
	'pf-header-page_title' => 'ܟܘܢܝܐ',
	'pf-header-approve' => 'ܩܘܒܠܐ',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'pf-header-page_title' => 'Başlıq',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'Адміністратар PackageForce',
	'pf-desc' => '[[Special:PackageForce|Загрузка набораў]] карысных шаблёнаў і г.д.',
	'pf-only-admins-allowed' => 'Гэтая старонка толькі для ўдзельнікаў з правамі адміністратараў PackageForce.',
	'pf-admin-menu-default' => 'Па змоўчваньні',
	'pf-admin-menu-unsortedtemplates' => 'Несартаваныя шаблёны',
	'pf-admin-link-view-documentation' => 'Паказаць дакумэнтацыю зьвязаную са старонкай.',
	'pf-admin-link-editlink-page' => 'Рэдагаваць старонку',
	'pf-admin-link-approve' => 'Зацьвердзіць старонку',
	'pf-header-documentation' => 'Дакумэнтацыя',
	'pf-header-in_packages' => 'Наборы',
	'pf-header-edit' => 'Спасылка рэдагаваньня',
	'pf-header-type' => 'Тып старонкі',
	'pf-header-page_title' => 'Назва',
	'pf-header-approve' => 'Зацьвердзіць',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'packageforce' => 'প্যাকেজফোর্স',
	'packageforceadmin' => 'প্যাকেজফোর্সঅ্যাডমিন',
	'pf-admin-menu-default' => 'পূর্বনির্ধারিত',
	'pf-admin-link-editlink-page' => 'পাতা সম্পাদনা',
	'pf-admin-link-approve' => 'অনুমোদিত পাতাসমূহ',
	'pf-header-documentation' => 'ডকুমেন্টেশন',
	'pf-header-in_packages' => 'প্যাকেজসমূহ',
	'pf-header-edit' => 'সংযোগ সম্পাদনা',
	'pf-header-type' => 'পাতার ধরন',
	'pf-header-page_title' => 'শিরোনাম',
	'pf-header-approve' => 'অনুমোদিত',
);

/** Breton (Brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'Meradur PackageForce',
	'pf-desc' => '[[Special:PackageForce|Pellgargañ pakadoù]] patromoù talvoudus, etc.',
	'pf-only-admins-allowed' => "N'eo ar bajenn-mañ nemet evit an implijerien ganto ar gwirioù 'packageforce-admin'.",
	'pf-admin-menu-default' => 'Diouer',
	'pf-admin-menu-unsortedtemplates' => "N'eo ket bet rummet ar patromoù c'hoazh",
	'pf-admin-link-view-documentation' => "Gwelet an teuliadurioù liammet d'ar bajenn.",
	'pf-admin-link-editlink-page' => 'Kemmañ ar bajenn',
	'pf-admin-link-approve' => 'Aprouiñ ur bajenn',
	'pf-header-documentation' => 'Teuliadur',
	'pf-header-in_packages' => 'Pakadoù',
	'pf-header-edit' => 'Kemmañ al liamm',
	'pf-header-type' => 'Doare ar bajenn',
	'pf-header-page_title' => 'Titl',
	'pf-header-approve' => 'Aprouiñ',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'Administratorska stranica za PackageForce',
	'pf-desc' => '[[Special:PackageForce|Skidanje paketa]] korisnih šablona/itd.',
	'pf-only-admins-allowed' => "Ova stranica je samo za korisnike sa 'packageforce-admin'-pravom.",
	'pf-admin-menu-default' => 'Pretpostavljeno',
	'pf-admin-menu-unsortedtemplates' => 'Šabloni još nisu poredani',
	'pf-admin-link-view-documentation' => 'Pogledaj dokumentacije vezane sa stranicom.',
	'pf-admin-link-editlink-page' => 'Uredi stranicu',
	'pf-admin-link-approve' => 'Odobri stranicu',
	'pf-header-documentation' => 'Dokumentacija',
	'pf-header-in_packages' => 'Paketi',
	'pf-header-edit' => 'Uredi link',
	'pf-header-type' => 'Vrsta stranice',
	'pf-header-page_title' => 'Naslov',
	'pf-header-approve' => 'Odobri',
);

/** Czech (Česky) */
$messages['cs'] = array(
	'pf-header-documentation' => 'Dokumentace',
	'pf-header-page_title' => 'Název',
	'pf-header-approve' => 'Schválit',
);

/** Danish (Dansk)
 * @author Emilkris33
 */
$messages['da'] = array(
	'pf-admin-link-approve' => 'Godkend side',
	'pf-header-edit' => 'Rediger link',
);

/** German (Deutsch)
 * @author Kghbln
 */
$messages['de'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'Administrationsseite von PackageForce',
	'pf-desc' => 'Ermöglicht es, auf einer [[Special:PackageForce|Spezialseite]] nützliche Vorlagen, usw. zusammenzustellen und zu herunterladbaren sowie weiterverwendbaren Paketen zu bündeln',
	'pf-only-admins-allowed' => 'Diese Seite kann nur von Benutzern verwendet werden, die über das Recht zur Administration von PackageForce (‚packageforce-admin‘) verfügen.',
	'pf-admin-menu-default' => 'Standard',
	'pf-admin-menu-unsortedtemplates' => 'Die Vorlagen wurden noch nicht sortiert',
	'pf-admin-link-view-documentation' => 'Siehe hierzu die mit dieser Seite verknüpfte Dokumentation.',
	'pf-admin-link-editlink-page' => 'Bearbeitungsseite',
	'pf-admin-link-approve' => 'Bestätigungsseite',
	'pf-header-documentation' => 'Dokumentation',
	'pf-header-in_packages' => 'Pakete',
	'pf-header-edit' => 'Bearbeitungslink',
	'pf-header-type' => 'Seitentyp',
	'pf-header-page_title' => 'Titel',
	'pf-header-approve' => 'Bestätigen',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'PackageForceAdmin',
	'pf-desc' => 'Pakśiki wužytnych pśedłogow atd. [[Special:PackageForce|ześěgnuś]]',
	'pf-only-admins-allowed' => "Toś ten bok jo jano za wužywarjow z pšawom 'packageforce-admin'.",
	'pf-admin-menu-default' => 'Standard',
	'pf-admin-menu-unsortedtemplates' => 'Pśedłogi hyšći njesortěrowane',
	'pf-admin-link-view-documentation' => 'Dokumentacije pokazaś, kótarež su z bokom zwězane.',
	'pf-admin-link-editlink-page' => 'Bok wobźěłaś',
	'pf-admin-link-approve' => 'Bok pśizwóliś',
	'pf-header-documentation' => 'Dokumentacija',
	'pf-header-in_packages' => 'Pakśiki',
	'pf-header-edit' => 'Wótkaz wobźěłaś',
	'pf-header-type' => 'Bokowy typ',
	'pf-header-page_title' => 'Titel',
	'pf-header-approve' => 'Pśizwóliś',
);

/** Greek (Ελληνικά)
 * @author Dada
 */
$messages['el'] = array(
	'pf-admin-link-editlink-page' => 'Επεξεργασία σελίδας',
	'pf-admin-link-approve' => 'Έγκριση σελίδας',
	'pf-header-edit' => 'Επεξεργασία συνδέσμου',
	'pf-header-approve' => 'Έγκριση',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'pf-admin-menu-default' => 'Defaŭlta',
	'pf-header-edit' => 'Redakti ligilon',
	'pf-header-approve' => 'Aprobi',
);

/** Spanish (Español)
 * @author McDutchie
 * @author Pertile
 */
$messages['es'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'Administrador de PackageForce',
	'pf-desc' => '[[Special:PackageForce|Descargar paquetes]] de plantillas útiles, etc.',
	'pf-only-admins-allowed' => "Esta página es únicamente para usuarios con los privilegios de 'packageforce-admin'.",
	'pf-admin-menu-default' => 'Por defecto',
	'pf-admin-menu-unsortedtemplates' => 'Plantillas aún no ordenadas',
	'pf-admin-link-view-documentation' => 'Ver documentación vinculada a una página.',
	'pf-admin-link-editlink-page' => 'Editar página',
	'pf-admin-link-approve' => 'Aprobar página',
	'pf-header-documentation' => 'Documentación',
	'pf-header-in_packages' => 'Paquetes',
	'pf-header-edit' => 'Vínculo de edición',
	'pf-header-type' => 'Tipo de página',
	'pf-header-page_title' => 'Título',
	'pf-header-approve' => 'Aprobar',
);

/** Basque (Euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'pf-header-documentation' => 'Dokumentazioa',
);

/** Persian (فارسی)
 * @author Mjbmr
 */
$messages['fa'] = array(
	'pf-admin-menu-default' => 'پیش‌فرض',
);

/** Finnish (Suomi)
 * @author Centerlink
 * @author Crt
 * @author Nike
 * @author Str4nd
 */
$messages['fi'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'Hallintointisivu PackageForce-laajennukselle',
	'pf-desc' => '[[Special:PackageForce|Lataa paketit]], jotka sisältävät hyödyllisiä mallineita ja muuta.',
	'pf-only-admins-allowed' => 'Tämä sivu on vain käyttäjille, joilla on ”packageforce-admin”-oikeudet.',
	'pf-admin-menu-default' => 'Oletus',
	'pf-admin-menu-unsortedtemplates' => 'Mallineita ei ole vielä lajiteltu',
	'pf-admin-link-view-documentation' => 'Katso sivuun liittyviä dokumentteja.',
	'pf-admin-link-editlink-page' => 'Muokkaa sivua',
	'pf-admin-link-approve' => 'Hyväksy sivu',
	'pf-header-documentation' => 'Dokumentaatio',
	'pf-header-in_packages' => 'Paketit',
	'pf-header-edit' => 'Muokkauslinkki',
	'pf-header-type' => 'Sivun tyyppi',
	'pf-header-page_title' => 'Otsikko',
	'pf-header-approve' => 'Hyväksy',
);

/** French (Français)
 * @author IAlex
 * @author Peter17
 * @author Verdy p
 */
$messages['fr'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'Administration de PackageForce',
	'pf-desc' => '[[Special:PackageForce|Télécharger des paquets]] de modèles utiles, ...',
	'pf-only-admins-allowed' => 'Cette page est uniquement accessible aux utilisateurs avec le droit « packageforce-admin ».',
	'pf-admin-menu-default' => 'Par défaut',
	'pf-admin-menu-unsortedtemplates' => 'Modèles pas encore triés',
	'pf-admin-link-view-documentation' => 'Voir la documentations liée à la page.',
	'pf-admin-link-editlink-page' => 'Modifier la page',
	'pf-admin-link-approve' => 'Approuver la page',
	'pf-header-documentation' => 'Documentation',
	'pf-header-in_packages' => 'Paquets',
	'pf-header-edit' => 'Lien pour modifier',
	'pf-header-type' => 'Type de page',
	'pf-header-page_title' => 'Titre',
	'pf-header-approve' => 'Approuver',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'Administracion de PackageForce',
	'pf-desc' => '[[Special:PackageForce|Tèlècharge des paquèts]] de modèlos utilos, ....',
	'pf-admin-menu-default' => 'Per dèfôt',
	'pf-admin-menu-unsortedtemplates' => 'Modèlos p’oncor triyês',
	'pf-admin-link-view-documentation' => 'Vêre la documentacion liyê a la pâge.',
	'pf-admin-link-editlink-page' => 'Changiér la pâge',
	'pf-admin-link-approve' => 'Aprovar la pâge',
	'pf-header-documentation' => 'Documentacion',
	'pf-header-in_packages' => 'Paquèts',
	'pf-header-edit' => 'Lim por changiér',
	'pf-header-type' => 'Tipo de pâge',
	'pf-header-page_title' => 'Titro',
	'pf-header-approve' => 'Aprovar',
);

/** Galician (Galego)
 * @author McDutchie
 * @author Toliño
 */
$messages['gl'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'Administrador de PackageForce',
	'pf-desc' => '[[Special:PackageForce|Descargar paquetes]] de modelos e outras cousas útiles.',
	'pf-only-admins-allowed' => 'Esta páxina é só para usuarios co dereito "packageforce-admin".',
	'pf-admin-menu-default' => 'Por defecto',
	'pf-admin-menu-unsortedtemplates' => 'Modelos ser organizar',
	'pf-admin-link-view-documentation' => 'Ollar a documentación asociada á páxina.',
	'pf-admin-link-editlink-page' => 'Editar a páxina',
	'pf-admin-link-approve' => 'Aprobar a páxina',
	'pf-header-documentation' => 'Documentación',
	'pf-header-in_packages' => 'Paquetes',
	'pf-header-edit' => 'Ligazón de edición',
	'pf-header-type' => 'Tipo de páxina',
	'pf-header-page_title' => 'Título',
	'pf-header-approve' => 'Aprobar',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'PackageForce-Ammann',
	'pf-desc' => '[[Special:PackageForce|Paket abelade]] mit nitzlige Vorlage usw.',
	'pf-only-admins-allowed' => 'Die Syte isch nume fir Benutzer mit em „packageforce-admin“-Rächt.',
	'pf-admin-menu-default' => 'Standard',
	'pf-admin-menu-unsortedtemplates' => 'Vorlage sin nonig sortiert',
	'pf-admin-link-view-documentation' => 'Dokumäntazion zue dr Syte aaluege.',
	'pf-admin-link-editlink-page' => 'Syte bearbeite',
	'pf-admin-link-approve' => 'Syte gnähmige',
	'pf-header-documentation' => 'Dokumäntazion',
	'pf-header-in_packages' => 'Paket',
	'pf-header-edit' => 'Gleich bearbeite',
	'pf-header-type' => 'Sytetyp',
	'pf-header-page_title' => 'Titel',
	'pf-header-approve' => 'Gnähmige',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author YaronSh
 */
$messages['he'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'PackageForceAdmin',
	'pf-desc' => "[[Special:PackageForce|הורדת חבילות]] של תבניות שימושיות וכו'.",
	'pf-only-admins-allowed' => "הדף הזה מיועד רק למשתמשים בקבוצת 'packageforce-admin'.",
	'pf-admin-menu-default' => 'בררת המחדל',
	'pf-admin-menu-unsortedtemplates' => 'תבניות שטרם מוינו',
	'pf-admin-link-view-documentation' => 'צפייה בתיעוד הקשור לדפים.',
	'pf-admin-link-editlink-page' => 'עריכת דף',
	'pf-admin-link-approve' => 'לאשר דף',
	'pf-header-documentation' => 'תיעוד',
	'pf-header-in_packages' => 'חבילות',
	'pf-header-edit' => 'עריכת קישור',
	'pf-header-type' => 'סוג הדף',
	'pf-header-page_title' => 'כותרת',
	'pf-header-approve' => 'לאשר',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'PackageForceAdmin',
	'pf-desc' => '[[Special:PackageForce|Pakćiki wužitnych předłohow atd. sćahnyć]]',
	'pf-only-admins-allowed' => "Tuta strona je jenož za wužiwarjow z prawom 'packageforce-admin'.",
	'pf-admin-menu-default' => 'Standard',
	'pf-admin-menu-unsortedtemplates' => 'Předłohi hišće njesortěrowane',
	'pf-admin-link-view-documentation' => 'Dokumentacije pokazać, kotrež su ze stronu zwjazane.',
	'pf-admin-link-editlink-page' => 'Stronu wobdźěłać',
	'pf-admin-link-approve' => 'Stronu schwalić',
	'pf-header-documentation' => 'Dokumentacija',
	'pf-header-in_packages' => 'Pakćiki',
	'pf-header-edit' => 'Wotkaz wobdźěłać',
	'pf-header-type' => 'Typ strony',
	'pf-header-page_title' => 'Titul',
	'pf-header-approve' => 'Schwalić',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'PackageForceAdmin',
	'pf-desc' => 'Hasznos sablonok és egyéb dolgok [[Special:PackageForce|letöltése csomagban]]',
	'pf-admin-menu-default' => 'Alapértelmezett',
	'pf-admin-link-view-documentation' => 'A laphoz tartozó dokumentációk megtekintése.',
	'pf-admin-link-editlink-page' => 'Lap szerkesztése',
	'pf-admin-link-approve' => 'Lap jóváhagyása',
	'pf-header-documentation' => 'Dokumentáció',
	'pf-header-in_packages' => 'Csomagok',
	'pf-header-edit' => 'Hivatkozás szerkesztése',
	'pf-header-type' => 'A lap típusa',
	'pf-header-page_title' => 'Cím',
	'pf-header-approve' => 'Elfogadás',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'Administrator de PackageForce',
	'pf-desc' => '[[Special:PackageForce|Discargar pacchettos]] de patronos utile, etc.',
	'pf-only-admins-allowed' => "Iste pagina es solmente pro usatores con le derecto 'packageforce-admin'.",
	'pf-admin-menu-default' => 'Predefinition',
	'pf-admin-menu-unsortedtemplates' => 'Patronos non ancora ordinate',
	'pf-admin-link-view-documentation' => 'Vider documentation ligate al pagina.',
	'pf-admin-link-editlink-page' => 'Modificar pagina',
	'pf-admin-link-approve' => 'Approbar pagina',
	'pf-header-documentation' => 'Documentation',
	'pf-header-in_packages' => 'Pacchettos',
	'pf-header-edit' => 'Ligamine de modification',
	'pf-header-type' => 'Typo de pagina',
	'pf-header-page_title' => 'Titulo',
	'pf-header-approve' => 'Approbar',
);

/** Indonesian (Bahasa Indonesia)
 * @author Farras
 * @author Kenrick95
 */
$messages['id'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'PackageForceAdmin',
	'pf-desc' => '[[Special:PackageForce|Paket unduhan]] templat berguna, dll.',
	'pf-only-admins-allowed' => "Halaman ini hanya untuk pengguna dengan hak 'packageforce-admin'.",
	'pf-admin-menu-default' => 'Setelan baku',
	'pf-admin-menu-unsortedtemplates' => 'Templat belum diurutkan',
	'pf-admin-link-view-documentation' => 'Lihat dokumentasi yang berhubungan dengan halaman ini.',
	'pf-admin-link-editlink-page' => 'Sunting halaman',
	'pf-admin-link-approve' => 'Setujui halaman',
	'pf-header-documentation' => 'Dokumentasi',
	'pf-header-in_packages' => 'Paket',
	'pf-header-edit' => 'Sunting pranala',
	'pf-header-type' => 'Jenis halaman',
	'pf-header-page_title' => 'Judul',
	'pf-header-approve' => 'Setujui',
);

/** Italian (Italiano) */
$messages['it'] = array(
	'pf-admin-menu-default' => 'Default',
	'pf-admin-link-editlink-page' => 'Modifica pagina',
	'pf-header-documentation' => 'Documentazione',
	'pf-header-page_title' => 'Titolo',
	'pf-header-approve' => 'Approva',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author 青子守歌
 */
$messages['ja'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'PackageForceAdmin',
	'pf-desc' => '便利なテンプレートなどの[[Special:PackageForce|パッケージをダウンロード]]',
	'pf-only-admins-allowed' => "このページを利用するには 'packageforce-admin' 権限が必要です。",
	'pf-admin-menu-default' => '規定',
	'pf-admin-menu-unsortedtemplates' => 'テンプレートが整列されていません',
	'pf-admin-link-view-documentation' => 'ページに連結している説明書を読む。',
	'pf-admin-link-editlink-page' => 'ページを編集',
	'pf-admin-link-approve' => 'ページを承認',
	'pf-header-documentation' => '説明書',
	'pf-header-in_packages' => 'パッケージ',
	'pf-header-edit' => 'リンクを編集',
	'pf-header-type' => 'ページの種類',
	'pf-header-page_title' => 'ページ名',
	'pf-header-approve' => '承認',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'pf-header-page_title' => 'ಶೀರ್ಷಿಕೆ',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'packageforce' => '<i lang="en">PackageForce</i>',
	'packageforceadmin' => '<i lang="en">PackageForce</i> Verwallde',
	'pf-desc' => 'Nözlejje Schabloone un ähnlesch zo Pöngelle benge un [[Special:PackageForce|eronger laade]].',
	'pf-only-admins-allowed' => 'Di Sigg es bloß för Metmaacher met däm Rääsch <code lang="en">packageforce-admin</code>',
	'pf-admin-menu-default' => 'Shtandatt',
	'pf-admin-menu-unsortedtemplates' => 'De Schabloone sin noch nit zoteet',
	'pf-admin-link-view-documentation' => 'Beloor Der de Dokkemäntazjuhn för di Sigg',
	'pf-admin-link-editlink-page' => 'De Sigg ändere',
	'pf-admin-link-approve' => 'De Sigg beshtääteje',
	'pf-header-documentation' => 'Dokkemäntazjuhn',
	'pf-header-in_packages' => 'Pakkätte
of
Pöngelle',
	'pf-header-edit' => 'Lengk för et Ändere',
	'pf-header-type' => 'Zoot vun Sigg',
	'pf-header-page_title' => 'Tittel vun dä Sigg',
	'pf-header-approve' => 'Lengk för et Beshtääteje',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'Administratioun vu PackageForce',
	'pf-desc' => '[[Special:PackageForce|Erofluede vu Fichieren]] mat nëtzleche Schablounen asw.',
	'pf-only-admins-allowed' => "Dës Säit ass nëmme fir Benotzer mat 'packageforce-admin'-Rechter.",
	'pf-admin-menu-default' => 'Standard',
	'pf-admin-menu-unsortedtemplates' => 'Schablounen nach net zortéiert',
	'pf-admin-link-view-documentation' => "D'Dokumentatioun déi mat dëser Säit verbonn ass weisen.",
	'pf-admin-link-editlink-page' => 'Säit änneren',
	'pf-admin-link-approve' => 'Säit fräiginn',
	'pf-header-documentation' => 'Dokumentatioun',
	'pf-header-in_packages' => 'Päck',
	'pf-header-edit' => 'Link änneren',
	'pf-header-type' => 'Säitentyp',
	'pf-header-page_title' => 'Titel',
	'pf-header-approve' => 'Zoustëmmen',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'PackageForceAdmin',
	'pf-desc' => '[[Special:PackageForce|Преземање на пакети]] со корисни шаблони/и сл.',
	'pf-only-admins-allowed' => 'Оваа страница е само за корисници со право „packageforce-admin“.',
	'pf-admin-menu-default' => 'По основно',
	'pf-admin-menu-unsortedtemplates' => 'Шаблониете сè уште не се сортирани',
	'pf-admin-link-view-documentation' => 'Види приложена документација',
	'pf-admin-link-editlink-page' => 'Уреди страница',
	'pf-admin-link-approve' => 'Одобри страница',
	'pf-header-documentation' => 'Документација',
	'pf-header-in_packages' => 'Пакети',
	'pf-header-edit' => 'Уреди врска',
	'pf-header-type' => 'Тип на страница',
	'pf-header-page_title' => 'Наслов',
	'pf-header-approve' => 'Одобри',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'pf-admin-menu-default' => 'സ്വതേ',
	'pf-admin-link-editlink-page' => 'താൾ തിരുത്തുക',
	'pf-admin-link-approve' => 'താൾ അംഗീകരിക്കുക',
	'pf-header-edit' => 'തിരുത്തുവാനുള്ള കണ്ണി',
	'pf-header-type' => 'താളിന്റെ തരം',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'pf-admin-menu-default' => 'Asali',
	'pf-header-documentation' => 'Dokumentasi',
	'pf-header-page_title' => 'Tajuk',
	'pf-header-approve' => 'Luluskan',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'PackageForceAdmin',
	'pf-desc' => '[[Special:PackageForce|Last ned pakker]] med nyttige maler/osv.',
	'pf-only-admins-allowed' => "Denne siden er bare for brukere med rettigheten 'packageforce-admin'",
	'pf-admin-menu-default' => 'Standard',
	'pf-admin-menu-unsortedtemplates' => 'Maler ikke sortert ennå',
	'pf-admin-link-view-documentation' => 'Vis dokumentasjon knyttet til denne siden.',
	'pf-admin-link-editlink-page' => 'Rediger siden',
	'pf-admin-link-approve' => 'Godkjenn siden',
	'pf-header-documentation' => 'Dokumentasjon',
	'pf-header-in_packages' => 'Pakker',
	'pf-header-edit' => 'Rediger lenke',
	'pf-header-type' => 'Sidetype',
	'pf-header-page_title' => 'Tittel',
	'pf-header-approve' => 'Godkjenn',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'PackageForce-beheer',
	'pf-desc' => '[[Special:PackageForce|Pakketten downloaden]] met handige sjablonen, enzovoort.',
	'pf-only-admins-allowed' => 'Deze pagina is alleen bedoeld voor gebruikers met het recht "packageforce-admin".',
	'pf-admin-menu-default' => 'Standaard',
	'pf-admin-menu-unsortedtemplates' => 'De sjablonen zijn nog niet gesorteerd',
	'pf-admin-link-view-documentation' => 'Documentatie bij pagina bekijken.',
	'pf-admin-link-editlink-page' => 'Pagina bewerken',
	'pf-admin-link-approve' => 'Pagina goedkeuren',
	'pf-header-documentation' => 'Documentatie',
	'pf-header-in_packages' => 'Pakketten',
	'pf-header-edit' => 'Bewerken',
	'pf-header-type' => 'Type pagina',
	'pf-header-page_title' => 'Naam',
	'pf-header-approve' => 'Goedkeuren',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Nghtwlkr
 */
$messages['nn'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'PackageForceAdmin',
	'pf-admin-menu-default' => 'Standard',
	'pf-header-documentation' => 'Dokumentasjon',
	'pf-header-in_packages' => 'Pakkar',
	'pf-header-page_title' => 'Tittel',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Psubhashish
 */
$messages['or'] = array(
	'pf-header-page_title' => 'ଶିରୋନାମା',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'pf-header-page_title' => 'Titel',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'Administrator PackageForce',
	'pf-desc' => '[[Special:PackageForce|Pobieranie pakietów]] przydatnych szablonów itp.',
	'pf-only-admins-allowed' => 'Ta strona jest wyłącznie dla użytkowników posiadających uprawnienie „packageforce-admin”.',
	'pf-admin-menu-default' => 'Domyślne',
	'pf-admin-menu-unsortedtemplates' => 'Szablony jeszcze nieposortowane',
	'pf-admin-link-view-documentation' => 'Zobacz dokumentację związaną z tą stroną.',
	'pf-admin-link-editlink-page' => 'Edytuj stronę',
	'pf-admin-link-approve' => 'Zatwierdź stronę',
	'pf-header-documentation' => 'Dokumentacja',
	'pf-header-in_packages' => 'Pakiety',
	'pf-header-edit' => 'Link do edycji',
	'pf-header-type' => 'Typ strony',
	'pf-header-page_title' => 'Tytuł',
	'pf-header-approve' => 'Akceptuj',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'PackageForceAdmin',
	'pf-desc' => '[[Special:PackageForce|Dëscarié dij pachet]] dë stamp ùtij e via fòrt.',
	'pf-only-admins-allowed' => "Sta pàgina-sì a l'é mach për j'utent con ël drit 'packageforce-admin'",
	'pf-admin-menu-default' => 'Për sòlit',
	'pf-admin-menu-unsortedtemplates' => "Stamp pa anco' ordinà",
	'pf-admin-link-view-documentation' => 'Vardé la documentassion gropà a la pàgina.',
	'pf-admin-link-editlink-page' => 'Modifiché la pàgina',
	'pf-admin-link-approve' => 'Aprové la pàgina',
	'pf-header-documentation' => 'Documentassion',
	'pf-header-in_packages' => 'Pachet',
	'pf-header-edit' => "Modifiché l'anliura",
	'pf-header-type' => 'Sòrt ëd pàgina',
	'pf-header-page_title' => 'Tìtol',
	'pf-header-approve' => 'Apreuva',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'pf-admin-menu-default' => 'تلواليز',
	'pf-admin-link-editlink-page' => 'مخ سمول',
	'pf-header-type' => 'د مخ ډول',
	'pf-header-page_title' => 'سرليک',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'Administrador do PackageForce',
	'pf-desc' => 'Fazer [[Special:PackageForce|download de pacotes]] de predefinições úteis, etc.',
	'pf-only-admins-allowed' => "Esta página é apenas para utilizadores com o privilégio 'packageforce-admin'.",
	'pf-admin-menu-default' => 'Por omissão',
	'pf-admin-menu-unsortedtemplates' => 'Predefinições ainda não organizadas',
	'pf-admin-link-view-documentation' => 'Ver documentação associada à página.',
	'pf-admin-link-editlink-page' => 'Editar página',
	'pf-admin-link-approve' => 'Aprovar página',
	'pf-header-documentation' => 'Documentação',
	'pf-header-in_packages' => 'Pacotes',
	'pf-header-edit' => 'Link de edição',
	'pf-header-type' => 'Tipo de página',
	'pf-header-page_title' => 'Título',
	'pf-header-approve' => 'Aprovar',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 * @author Luckas Blade
 * @author McDutchie
 */
$messages['pt-br'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'Administrador do PackageForce',
	'pf-desc' => 'Fazer [[Special:PackageForce|download de pacotes]] de predefinições úteis, etc.',
	'pf-only-admins-allowed' => "Esta página é apenas para utilizadores com o privilégio 'packageforce-admin'.",
	'pf-admin-menu-default' => 'Padrão',
	'pf-admin-menu-unsortedtemplates' => 'Predefinições ainda não organizadas',
	'pf-admin-link-view-documentation' => 'Ver documentação associada à página.',
	'pf-admin-link-editlink-page' => 'Editar página',
	'pf-admin-link-approve' => 'Aprovar página',
	'pf-header-documentation' => 'Documentação',
	'pf-header-in_packages' => 'Pacotes',
	'pf-header-edit' => 'Link de edição',
	'pf-header-type' => 'Tipo de página',
	'pf-header-page_title' => 'Título',
	'pf-header-approve' => 'Aprovar',
);

/** Romanian (Română)
 * @author McDutchie
 * @author Minisarm
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'pf-admin-menu-default' => 'Implicit',
	'pf-admin-link-editlink-page' => 'Modifică pagina',
	'pf-admin-link-approve' => 'Aprobă pagina',
	'pf-header-documentation' => 'Documentație',
	'pf-header-in_packages' => 'Pachete',
	'pf-header-edit' => 'Legătură de editare',
	'pf-header-type' => 'Tipul de pagină',
	'pf-header-page_title' => 'Titlu',
	'pf-header-approve' => 'Aprobă',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'PackageForceAdmin',
	'pf-desc' => '[[Special:PackageForce|Загрузка пакетов]] полезных шаблонов и пр.',
	'pf-only-admins-allowed' => 'Эта страница предназначена только для пользователей с правами «packageforce-admin».',
	'pf-admin-menu-default' => 'По умолчанию',
	'pf-admin-menu-unsortedtemplates' => 'Ещё неупорядоченные шаблоны',
	'pf-admin-link-view-documentation' => 'Просмотр документов, связанных со страницей.',
	'pf-admin-link-editlink-page' => 'Править страницу',
	'pf-admin-link-approve' => 'Утвердить страницу',
	'pf-header-documentation' => 'Документация',
	'pf-header-in_packages' => 'Пакеты',
	'pf-header-edit' => 'Ссылка для изменения',
	'pf-header-type' => 'Тип страницы',
	'pf-header-page_title' => 'Название',
	'pf-header-approve' => 'Утверждение',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'pf-admin-menu-default' => 'Подразумевано',
	'pf-admin-menu-unsortedtemplates' => 'Шаблони још нису поређани',
	'pf-admin-link-view-documentation' => 'Погледај приложену документацију.',
	'pf-admin-link-editlink-page' => 'Уреди страницу',
	'pf-admin-link-approve' => 'Одобри страницу',
	'pf-header-documentation' => 'Документација',
	'pf-header-in_packages' => 'Пакети',
	'pf-header-edit' => 'Уреди везу',
	'pf-header-type' => 'Врста странице',
	'pf-header-page_title' => 'Наслов',
	'pf-header-approve' => 'Одобри',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬) */
$messages['sr-el'] = array(
	'pf-admin-menu-default' => 'Podrazumevano',
	'pf-admin-menu-unsortedtemplates' => 'Šabloni još uvek nisu sortirani',
	'pf-admin-link-view-documentation' => 'Vidi dokumentaciju povezanu sa stranom.',
	'pf-admin-link-editlink-page' => 'Izmeni stranu',
	'pf-admin-link-approve' => 'Odobri stranu',
	'pf-header-documentation' => 'Dokumentacija',
	'pf-header-in_packages' => 'Paketi',
	'pf-header-edit' => 'Izmeni vezu',
	'pf-header-type' => 'Vrsta strane',
	'pf-header-page_title' => 'Naslov',
	'pf-header-approve' => 'Odobri',
);

/** Swedish (Svenska)
 * @author Dafer45
 * @author McDutchie
 */
$messages['sv'] = array(
	'pf-admin-link-view-documentation' => 'Se dokumentation knuten till sidan.',
	'pf-admin-link-editlink-page' => 'Redigera sida',
	'pf-admin-link-approve' => 'Godkänn sida',
	'pf-header-documentation' => 'Dokumentation',
	'pf-header-in_packages' => 'Paket',
	'pf-header-edit' => 'Redigeringslänk',
	'pf-header-type' => 'Typ av sida',
	'pf-header-page_title' => 'Titel',
	'pf-header-approve' => 'Godkänn',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'pf-admin-menu-default' => 'అప్రమేయం',
	'pf-header-documentation' => 'పత్రావళి',
	'pf-header-type' => 'పుట యొక్క రకం',
	'pf-header-page_title' => 'శీర్షిక',
	'pf-header-approve' => 'అనుమతించు',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'packageforce' => 'PaketengPuwersa',
	'packageforceadmin' => 'Tagapangasiwa ng PaketengPuwersa',
	'pf-desc' => '[[Special:PackageForce|Ikargang pababa ang mga pakete]] ng magagamit na mga suleras/atbp.',
	'pf-only-admins-allowed' => "Ang pahinang ito ay para lamang sa mga tagagamit na may karapatang 'tagapangasiwa ng paketengpuwersa'.",
	'pf-admin-menu-default' => 'Likas na nakatakda',
	'pf-admin-menu-unsortedtemplates' => 'Hinpi na napipili ang mga suleras',
	'pf-admin-link-view-documentation' => 'Tingnan ang mga kasulatang nakatali sa pahina.',
	'pf-admin-link-editlink-page' => 'Baguhin ang pahina',
	'pf-admin-link-approve' => 'Payagan ang pahina',
	'pf-header-documentation' => 'Dokumentasyon',
	'pf-header-in_packages' => 'Mga pakete',
	'pf-header-edit' => 'Baguhin ang kawing',
	'pf-header-type' => 'Uri ng pahina',
	'pf-header-page_title' => 'Pamagat',
	'pf-header-approve' => 'Payagan',
);

/** Ukrainian (Українська)
 * @author Тест
 */
$messages['uk'] = array(
	'packageforce' => 'PackageForce',
	'packageforceadmin' => 'PackageForceAdmin',
	'pf-desc' => '[[Special:PackageForce|Завантаження наборів]] корисних шаблонів та інш.',
	'pf-only-admins-allowed' => "Ця сторінка призначена тільки для користувачів з правами 'packageforce-admin'.",
	'pf-admin-menu-default' => 'За умовчанням',
	'pf-admin-menu-unsortedtemplates' => 'Ще не відсортовані шаблони',
	'pf-admin-link-view-documentation' => "Перегляд документів, пов'язаних зі сторінкою.",
	'pf-admin-link-editlink-page' => 'Редагувати сторінку',
	'pf-admin-link-approve' => 'Затвердити сторінку',
	'pf-header-documentation' => 'Документація',
	'pf-header-in_packages' => 'Набори',
	'pf-header-edit' => 'Посилання для зміни',
	'pf-header-type' => 'Тип сторінки',
	'pf-header-page_title' => 'Заголовок',
	'pf-header-approve' => 'Затвердження',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'pf-admin-link-editlink-page' => 'רעדאַקטירן בלאַט',
	'pf-admin-link-approve' => 'באַשטעטיקן בלאַט',
	'pf-header-documentation' => 'דאָקומענטאַציע',
);

/** Simplified Chinese (‪中文(简体)‬) */
$messages['zh-hans'] = array(
	'pf-admin-menu-default' => '预设',
	'pf-admin-link-editlink-page' => '编辑页面',
	'pf-header-documentation' => '说明',
	'pf-header-edit' => '编辑连结',
	'pf-header-page_title' => '标题',
	'pf-header-approve' => '批复',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'pf-admin-menu-default' => '預設',
	'pf-admin-link-editlink-page' => '編輯頁面',
	'pf-header-documentation' => '說明',
	'pf-header-edit' => '編輯連結',
	'pf-header-page_title' => '標題',
	'pf-header-approve' => '獲准',
);

