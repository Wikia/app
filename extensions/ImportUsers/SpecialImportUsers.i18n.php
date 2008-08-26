<?php
/**Internationalization messages file for
  *Import User extension
  *
  * @addtogroup Extensions
*/

$messages = array();

$messages['en'] = array(
	'importusers'                         => 'Import users' ,
	'importusers-desc'                    => 'Imports users in bulk from CSV-file; encoding: UTF-8',
	'importusers-uploadfile'              => 'Upload file',
	'importusers-form-caption'            => 'Input CSV-file (UTF-8)' ,
	'importusers-form-file'               => 'User file format (csv): ',
	'importusers-form-replace-present'    => 'Replace existing users' ,
	'importusers-form-button'             => 'Import' ,
	'importusers-user-added'              => 'User <b>%s</b> has been added.' ,
	'importusers-user-present-update'     => 'User <b>%s</b> already exists. Updated.' ,
	'importusers-user-present-not-update' => 'User <b>%s</b> already exists. Did not update.' ,
	'importusers-user-invalid-format'     => 'User data in the line #%s has invalid format or is blank. Skipped.' ,
	'importusers-log'                     => 'Import log' ,
	'importusers-log-summary'             => 'Summary' ,
	'importusers-log-summary-all'         => 'All' ,
	'importusers-log-summary-added'       => 'Added' ,
	'importusers-log-summary-updated'     => 'Updated',
	'importusers-login-name'              => 'Login name',
	'importusers-password'                => 'password',
	'importusers-email'                   => 'e-mail',
	'importusers-realname'                => 'real name',
);

/** Faeag Rotuma (Faeag Rotuma)
 * @author Jose77
 */
$messages['rtm'] = array(
	'importusers-uploadfile' => 'Upload ou file',
	'importusers-password'   => 'Ou password',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'importusers-log-summary' => 'Чылаже',
	'importusers-password'    => 'шолыпмут',
	'importusers-email'       => 'электрон почто',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'importusers-uploadfile'  => 'Fakafano e faila',
	'importusers-log-summary' => 'Fakakatoakatoa',
	'importusers-password'    => 'kupu fufu',
	'importusers-email'       => 'meli hila',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 */
$messages['af'] = array(
	'importusers-form-button'     => 'importeer',
	'importusers-log-summary-all' => 'Alle',
	'importusers-password'        => 'wagwoord',
	'importusers-email'           => 'e-pos',
	'importusers-realname'        => 'regte naam',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'importusers'                         => 'استيراد مستخدمين',
	'importusers-desc'                    => 'يستورد المستخدمين في صيغة bulk من ملف CSV؛ الإنكودينج: UTF-8',
	'importusers-uploadfile'              => 'رفع ملف',
	'importusers-form-caption'            => 'الناتج ملف CSV (UTF-8)',
	'importusers-form-file'               => 'صيغة ملف المستخدم (csv):',
	'importusers-form-replace-present'    => 'استبدل المستخدمين الموجودين',
	'importusers-form-button'             => 'استيراد',
	'importusers-user-added'              => 'المستخدم <b>%s</b> تمت إضافته.',
	'importusers-user-present-update'     => 'المستخدم <b>%s</b> موجود بالفعل. تم التحديث.',
	'importusers-user-present-not-update' => 'المستخدم <b>%s</b> موجود بالفعل. لم يتم التحديث.',
	'importusers-user-invalid-format'     => 'بيانات المستخدم في السطر #%s لها صيغة غير صحيحة أو فارغة. تم تجاهلها.',
	'importusers-log'                     => 'استيراد السجل',
	'importusers-log-summary'             => 'ملخص',
	'importusers-log-summary-all'         => 'الكل',
	'importusers-log-summary-added'       => 'تمت الإضافة',
	'importusers-log-summary-updated'     => 'تم التحديث',
	'importusers-login-name'              => 'اسم الدخول',
	'importusers-password'                => 'كلمة السر',
	'importusers-email'                   => 'البريد الإلكتروني',
	'importusers-realname'                => 'الاسم الحقيقي',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'importusers'                      => 'Внасяне на потребители',
	'importusers-desc'                 => 'Внасяне на потребители от CSV-файл; кодиране: UTF-8',
	'importusers-uploadfile'           => 'Качване на файл',
	'importusers-form-replace-present' => 'Заменяне на съществуващите потребители',
	'importusers-form-button'          => 'Внасяне',
	'importusers-user-added'           => 'Потребителят <b>%s</b> беше добавен.',
	'importusers-log'                  => 'Дневник на внасянията',
	'importusers-log-summary'          => 'Резюме',
	'importusers-log-summary-all'      => 'Всички',
	'importusers-log-summary-added'    => 'Добавен',
	'importusers-log-summary-updated'  => 'Обновен',
	'importusers-password'             => 'парола',
	'importusers-email'                => 'е-поща',
	'importusers-realname'             => 'истинско име',
);

/** Chamorro (Chamoru)
 * @author Jatrobat
 */
$messages['ch'] = array(
	'importusers-uploadfile' => "Na'kåtga hulu' i atkibu",
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'importusers-log-summary-all' => 'Oll',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'importusers-uploadfile'          => 'Læg en fil op',
	'importusers-form-button'         => 'Importer',
	'importusers-log'                 => 'Brugerimportlog',
	'importusers-log-summary-updated' => 'Opdateret',
	'importusers-password'            => 'adgangskode',
	'importusers-email'               => 'e-mail',
	'importusers-realname'            => 'virkeligt navn',
);

/** German (Deutsch)
 * @author MF-Warburg
 */
$messages['de'] = array(
	'importusers'                         => 'Benutzer importieren',
	'importusers-desc'                    => 'Importiert Benutzer aus einer CSV-Datei; Codierung: UTF-8',
	'importusers-uploadfile'              => 'Datei hochladen',
	'importusers-form-caption'            => 'CSV-Datei (UTF-8)',
	'importusers-form-file'               => 'Benutzerdateiformat (csv):',
	'importusers-form-replace-present'    => 'Bestehende Benutzer ersetzen',
	'importusers-form-button'             => 'Importieren',
	'importusers-user-added'              => 'Der Benutzer <b>%s</b> wurde importiert.',
	'importusers-user-present-update'     => 'Ein Benutzer <b>%s</b> existiert bereits. Aktualisiert.',
	'importusers-user-present-not-update' => 'Ein Benutzer <b>%s</b> existiert bereits. Nicht aktualisiert.',
	'importusers-user-invalid-format'     => 'Die Benutzerdaten in Zeile #%s haben ein ungültiges Format oder sind leer. Übersprungen.',
	'importusers-log'                     => 'Benutzerimport-Logbuch',
	'importusers-log-summary'             => 'Zusammenfassung',
	'importusers-log-summary-all'         => 'Alle',
	'importusers-log-summary-added'       => 'Hinzugefügt',
	'importusers-log-summary-updated'     => 'Aktualisiert',
	'importusers-login-name'              => 'Benutzername',
	'importusers-password'                => 'Passwort',
	'importusers-email'                   => 'E-Mail',
	'importusers-realname'                => 'Echter Name',
);

/** Greek (Ελληνικά)
 * @author Consta
 */
$messages['el'] = array(
	'importusers-password' => 'κωδικός',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'importusers'                         => 'Importu Uzantojn',
	'importusers-uploadfile'              => 'Alŝuti dosieron',
	'importusers-form-button'             => 'Importu',
	'importusers-user-added'              => 'Uzanto <b>%s</b> estis aldonita.',
	'importusers-user-present-update'     => 'Uzanto <b>%s</b> jam ekzistas. Ĝisdatigita.',
	'importusers-user-present-not-update' => 'Uzanto <b>%s</b> jam ekzistas. Ne estis ĝisdatigita.',
	'importusers-log'                     => 'Protokolo de importoj',
	'importusers-log-summary'             => 'Resumo',
	'importusers-log-summary-all'         => 'Ĉiuj',
	'importusers-log-summary-added'       => 'Aldonita',
	'importusers-log-summary-updated'     => 'Ĝisdatigita',
	'importusers-login-name'              => 'Salutnomo',
	'importusers-password'                => 'pasvorto',
	'importusers-email'                   => 'retadreso',
	'importusers-realname'                => 'reala nomo',
);

/** Spanish (Español)
 * @author Piolinfax
 */
$messages['es'] = array(
	'importusers-log-summary-all' => 'Todos',
);

/** Finnish (Suomi)
 * @author Jack Phoenix
 */
$messages['fi'] = array(
	'importusers'                         => 'Tuo käyttäjiä',
	'importusers-uploadfile'              => 'Tallenna tiedosto',
	'importusers-form-file'               => 'Käyttäjätiedoston muoto (csv):',
	'importusers-form-replace-present'    => 'Korvaa olemassaolevat käyttäjät',
	'importusers-form-button'             => 'Tuo',
	'importusers-user-added'              => 'Käyttäjä <b>%s</b> on lisätty.',
	'importusers-user-present-update'     => 'Käyttäjä <b>%s</b> on jo olemassa. Päivitetty.',
	'importusers-user-present-not-update' => 'Käyttäjä <b>%s</b> on jo olemassa. Ei päivitetty.',
	'importusers-user-invalid-format'     => 'Käyttäjätiedolla rivillä #%s on kelvoton muoto tai on tyhjä. Ohitettu.',
	'importusers-log'                     => 'Tuontiloki',
	'importusers-log-summary'             => 'Yhteenveto',
	'importusers-log-summary-all'         => 'Kaikki',
	'importusers-log-summary-added'       => 'Lisätty',
	'importusers-log-summary-updated'     => 'Päivitetty',
	'importusers-login-name'              => 'Kirjautumisnimi',
	'importusers-password'                => 'salasana',
	'importusers-email'                   => 'sähköposti',
	'importusers-realname'                => 'oikea nimi',
);

/** French (Français)
 * @author Urhixidur
 */
$messages['fr'] = array(
	'importusers'                         => 'Importer des utilisateurs',
	'importusers-desc'                    => 'Importe des utilisateurs en bloc depuis un fichier CVS ; encodage : UTF-8.',
	'importusers-uploadfile'              => 'Importer le fichier',
	'importusers-form-caption'            => 'Entrez un fichier CVS (UTF-8)',
	'importusers-form-file'               => 'Format du fichier utilisateur (csv) : ',
	'importusers-form-replace-present'    => 'Remplace les utilisateurs existants',
	'importusers-form-button'             => 'Importer',
	'importusers-user-added'              => 'L’utilisateur <b>%s</b> a été ajouté.',
	'importusers-user-present-update'     => 'l’utilisateur <b>%s</b> existe déjà. Mise à jour effectuée.',
	'importusers-user-present-not-update' => 'L’utilisateur <b>%s</b> existe déjà. Non mis à jour.',
	'importusers-user-invalid-format'     => 'Les données utilisateur dans la ligne #%s sont dans un mauvais format ou bien sont inexistantes. Aucune action.',
	'importusers-log'                     => 'Journal des importations',
	'importusers-log-summary'             => 'Sommaire',
	'importusers-log-summary-all'         => 'Total',
	'importusers-log-summary-added'       => 'Ajouté',
	'importusers-log-summary-updated'     => 'Mise à jour',
	'importusers-login-name'              => 'Nom d’utilisateur',
	'importusers-password'                => 'mot de passe',
	'importusers-email'                   => 'adresse courriel',
	'importusers-realname'                => 'nom réel',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 */
$messages['gl'] = array(
	'importusers'                         => 'Importar Usuarios',
	'importusers-desc'                    => 'Importa usuarios en bloque dende ficheiros CSV; codificación: UTF-8',
	'importusers-uploadfile'              => 'Cargar ficheiro',
	'importusers-form-caption'            => 'Ficheiro de entrada CSV (UTF-8)',
	'importusers-form-file'               => 'Formato do ficheiro do usuario (csv):',
	'importusers-form-replace-present'    => 'Reemprazar os usuarios existentes',
	'importusers-form-button'             => 'Importar',
	'importusers-user-added'              => 'Usuario <b>%s</b> foi engadido.',
	'importusers-user-present-update'     => 'O usuario <b>%s</b> xa existe. Actualizado.',
	'importusers-user-present-not-update' => 'O usuario %s xa existe. Non actualizado.',
	'importusers-user-invalid-format'     => 'Os datos de usuario na liña #%s teñen un formato inválido ou a liña está en branco. Esta foi saltada.',
	'importusers-log'                     => 'Importar rexistro',
	'importusers-log-summary'             => 'Resumo',
	'importusers-log-summary-all'         => 'Todo',
	'importusers-log-summary-added'       => 'Engadido',
	'importusers-log-summary-updated'     => 'Actualizado',
	'importusers-login-name'              => 'Rexistrar nome',
	'importusers-password'                => 'contrasinal',
	'importusers-email'                   => 'correo electrónico',
	'importusers-realname'                => 'nome real',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'importusers-login-name' => "Dt'ennym ymmydeyr",
	'importusers-password'   => "dt'ockle arrey",
	'importusers-email'      => 'post-L',
	'importusers-realname'   => 'feer-ennym',
);

/** Hakka (Hak-kâ-fa)
 * @author Hakka
 */
$messages['hak'] = array(
	'importusers-uploadfile' => 'Sông-chhòn tóng-on',
);

/** Hawaiian (Hawai`i)
 * @author Kalani
 */
$messages['haw'] = array(
	'importusers-log-summary-all' => 'Apau',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'importusers'                         => 'सदस्य आयात करें',
	'importusers-desc'                    => 'CSV-फ़ाईल से अनेक सदस्य आयात करें; एन्कोडिंग: UTF-8',
	'importusers-uploadfile'              => 'फ़ाइल अपलोड करें',
	'importusers-form-caption'            => 'इनपुट CSV-फ़ाईल (UTF-8)',
	'importusers-form-file'               => 'सदस्य फ़ाईल का स्वरूप (csv):',
	'importusers-form-replace-present'    => 'अभीके सदस्य रिप्लेस करें',
	'importusers-form-button'             => 'आयात',
	'importusers-user-added'              => '<b>%s</b> सदस्य बढा दिया।',
	'importusers-user-present-update'     => '<b>%s</b> सदस्य अस्तित्वमें हैं। अपडेट किया।',
	'importusers-user-present-not-update' => '<b>%s</b> सदस्य अस्तित्वमें हैं। अपडेट नहीं किया।',
	'importusers-user-invalid-format'     => '#%s इस लाईन पर दी हुई सदस्य ज़ानकारी गलत अथवा खाली हैं। हटाई।',
	'importusers-log'                     => 'आयात सूची',
	'importusers-log-summary'             => 'संक्षिप्त ज़ानकारी',
	'importusers-log-summary-all'         => 'सभी',
	'importusers-log-summary-added'       => 'बढाया',
	'importusers-log-summary-updated'     => 'अपडेट किया',
	'importusers-login-name'              => 'लॉग इन नाम',
	'importusers-password'                => 'कूटशब्द',
	'importusers-email'                   => 'इ-मेल',
	'importusers-realname'                => 'असली नाम',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'importusers-uploadfile'  => 'Karga file',
	'importusers-log-summary' => 'Kabilogan',
	'importusers-password'    => 'kontra-senyas',
	'importusers-email'       => 'e-mail',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'importusers'                         => 'Wužiwarjow importować',
	'importusers-desc'                    => 'Wužiwarjow we wulkich mnóstwach z CSV-dataje importować; kodowanje: UTF-8',
	'importusers-uploadfile'              => 'Dataju nahrać',
	'importusers-form-caption'            => 'CSV-dataju (UTF-8) zapodać',
	'importusers-form-file'               => 'Format wužiwarskeje dataje (csv):',
	'importusers-form-replace-present'    => 'Eksistowacych wužiwarjow narunać',
	'importusers-form-button'             => 'Importować',
	'importusers-user-added'              => 'Wužiwar <b>%s</b> je so přidał.',
	'importusers-user-present-update'     => 'Wužiwar <b>%s</b> hižo eksistuje. Zaktualizowany.',
	'importusers-user-present-not-update' => 'Wužiwar <b>%s</b> hižo eksistuje. Žana aktualizacija.',
	'importusers-user-invalid-format'     => 'Wužiwarske daty w lince #%s ma njepłaćiwy format abo su prózdne. Přeskočene.',
	'importusers-log'                     => 'Importowy protokol',
	'importusers-log-summary'             => 'Zjeće',
	'importusers-log-summary-all'         => 'Wšě',
	'importusers-log-summary-added'       => 'Přidaty',
	'importusers-log-summary-updated'     => 'Zaktualizowany.',
	'importusers-login-name'              => 'Přizjewjenske mjeno',
	'importusers-password'                => 'hesło',
	'importusers-email'                   => 'e-mejl',
	'importusers-realname'                => 'woprawdźite mjeno',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'importusers-form-button'     => 'Importar',
	'importusers-log-summary'     => 'Summario',
	'importusers-log-summary-all' => 'Totes',
	'importusers-password'        => 'contrasigno',
	'importusers-email'           => 'e-mail',
);

/** Indonesian (Bahasa Indonesia)
 * @author Rex
 */
$messages['id'] = array(
	'importusers-log-summary-all' => 'Semua',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'importusers-password' => 'lykilorð',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'importusers-uploadfile'              => 'Unggahna berkas',
	'importusers-form-button'             => 'Impor',
	'importusers-user-added'              => 'Panganggo <b>%s</b> wis ditambah.',
	'importusers-user-present-not-update' => 'Panganggo <b>%s</b> wis ana. Ora di-update.',
	'importusers-log'                     => 'Log impor',
	'importusers-log-summary'             => 'Ringkesan',
	'importusers-log-summary-all'         => 'Kabèh',
	'importusers-log-summary-added'       => 'Ditambah',
	'importusers-log-summary-updated'     => 'Dimutakiraké',
	'importusers-login-name'              => 'Jeneng log mlebu',
	'importusers-password'                => 'tembung sandhi',
	'importusers-email'                   => 'e-mail',
	'importusers-realname'                => 'jeneng asli',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 */
$messages['km'] = array(
	'importusers'                         => 'នាំចូលអ្នកប្រើប្រាស់',
	'importusers-uploadfile'              => 'ផ្ទុកឯកសារឡើង',
	'importusers-form-replace-present'    => 'ជំនួសអ្នកប្រើប្រាស់ដែលមាន',
	'importusers-form-button'             => 'នាំចូល',
	'importusers-user-added'              => 'បានបន្ថែមហើយ អ្នកប្រើប្រាស់ <b>%s</b> ។',
	'importusers-user-present-update'     => 'អ្នកប្រើប្រាស់ <b>%s</b> មានហើយ។ បានបន្ទាន់សម័យ។',
	'importusers-user-present-not-update' => 'អ្នកប្រើប្រាស់ <b>%s</b> មានហើយ។ មិនទាន់បានបន្ទាន់សម័យ។',
	'importusers-log'                     => 'កំណត់ហេតុនៃការនាំចូល',
	'importusers-log-summary'             => 'សេចក្តីសង្ខេប',
	'importusers-log-summary-all'         => 'ទាំងអស់',
	'importusers-log-summary-added'       => 'បានបន្ថែម',
	'importusers-log-summary-updated'     => 'បានធ្វើឱ្យទាន់សម័យ',
	'importusers-login-name'              => 'ឈ្មោះឡុកអ៊ីន',
	'importusers-password'                => 'ពាក្យសំងាត់',
	'importusers-email'                   => 'អ៊ីមែល',
	'importusers-realname'                => 'ឈ្មោះពិត',
);

/** Korean (한국어)
 * @author Ficell
 */
$messages['ko'] = array(
	'importusers-password' => '비밀번호',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'importusers-email' => 'e-mail',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'importusers-log-summary-all' => 'All',
	'importusers-realname'        => 'Dinge richtije Name',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'importusers'                         => 'Benotzer importéieren',
	'importusers-desc'                    => 'Importéiert Benotzer aus engem CSV(Comma Separated Values)-Fichier; Codéierung: UTF-8',
	'importusers-uploadfile'              => 'Fichier eroplueden',
	'importusers-form-caption'            => 'CSV-Fichier (UTF-8) eraginn',
	'importusers-form-file'               => 'Format vum fichier vun de Benotzer (csv):',
	'importusers-form-replace-present'    => 'Benotzer déi et scho gëtt ersetzen',
	'importusers-form-button'             => 'Importéieren',
	'importusers-user-added'              => 'De Benotzer <b>%s</b> gouf derbäigesat.',
	'importusers-user-present-update'     => 'De Benotzer <b>%s</b> gëtt et schonn. Aktualiséiert.',
	'importusers-user-present-not-update' => 'De Benotzer <b>%s</b> gëtt et schonn. Net aktualiséiert.',
	'importusers-user-invalid-format'     => "D'Benotzerdaten an der Linn #%s huet een ongëltege Format oder ass eidel. Iwwersprong.",
	'importusers-log'                     => 'Lëscht vun den Importen',
	'importusers-log-summary'             => 'Resumé',
	'importusers-log-summary-all'         => 'Alleguer',
	'importusers-log-summary-added'       => 'derbäigesat',
	'importusers-log-summary-updated'     => 'Aktualiséiert',
	'importusers-login-name'              => 'Benotzernumm',
	'importusers-password'                => 'Passwuert',
	'importusers-email'                   => 'E-Mailadress',
	'importusers-realname'                => 'richtege Numm',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'importusers'                      => 'ഉപയോക്താക്കളെ ഇറക്കുമതി ചെയ്യുക',
	'importusers-uploadfile'           => 'പ്രമാണം അപ്‌ലോഡ് ചെയ്യുക',
	'importusers-form-replace-present' => 'നിലവിലുള്ള ഉപയോക്താക്കളെ റീപ്ലേസ് ചെയ്യുക',
	'importusers-form-button'          => 'ഇറക്കുമതി',
	'importusers-log'                  => 'ഇറക്കുമതി പ്രവര്‍ത്തനരേഖ',
	'importusers-log-summary'          => 'ചുരുക്കം',
	'importusers-log-summary-all'      => 'എല്ലാം',
	'importusers-log-summary-added'    => 'ചേര്‍ത്തു',
	'importusers-log-summary-updated'  => 'പുതുക്കിയിരിക്കുന്നു',
	'importusers-login-name'           => 'ലോഗിന്‍ നാമം',
	'importusers-password'             => 'രഹസ്യവാക്ക്',
	'importusers-email'                => 'ഇമെയില്‍',
	'importusers-realname'             => 'യഥാര്‍ത്ഥ പേര്‌',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'importusers'                         => 'सदस्य मागवा',
	'importusers-desc'                    => 'CSV-संचिकेमधून अनेक सदस्य इंपोर्ट करा; एन्कोडिंग: UTF-8',
	'importusers-uploadfile'              => 'संचिका चढवा',
	'importusers-form-caption'            => 'CSV-संचिका (UTF-8)',
	'importusers-form-file'               => 'सदस्य संचिका स्वरूप (csv):',
	'importusers-form-replace-present'    => 'सध्याच्या सदस्यांवर पुनर्लेखन करा',
	'importusers-form-button'             => 'इंपोर्ट',
	'importusers-user-added'              => '<b>%s</b> सदस्य वाढविला.',
	'importusers-user-present-update'     => '<b>%s</b> सदस्य अस्तित्वात आहे. अपडेट केला.',
	'importusers-user-present-not-update' => '<b>%s</b> सदस्य अस्तित्वात आहे. अपडेट केला नाही.',
	'importusers-user-invalid-format'     => '#%s या ओळीवरील सदस्य माहिती चुकीची अथवा रिकामी आहे. वगळली.',
	'importusers-log'                     => 'इंपोर्ट नोंदी',
	'importusers-log-summary'             => 'संक्षिप्त माहिती',
	'importusers-log-summary-all'         => 'सर्व',
	'importusers-log-summary-added'       => 'वाढविले',
	'importusers-log-summary-updated'     => 'अपडेट केले',
	'importusers-login-name'              => 'सदस्य नाव',
	'importusers-password'                => 'परवलीचा शब्द',
	'importusers-email'                   => 'इमेल',
	'importusers-realname'                => 'खरे नाव',
);

/** Nahuatl (Nahuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'importusers-uploadfile'      => 'Tlahcuilōlquetza',
	'importusers-log-summary-all' => 'Mochīntīn',
	'importusers-email'           => 'e-mail',
	'importusers-realname'        => 'melāhuac motōcā',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'importusers'                         => 'Gebruikers importeren',
	'importusers-desc'                    => 'Gebruikers in bulk importeren vanuit een CSV-bestand. Codering: UTF-8',
	'importusers-uploadfile'              => 'Bestand uploaden',
	'importusers-form-caption'            => 'Invoerbestand (CSV, UTF-8)',
	'importusers-form-file'               => 'Gebruikersbestandsopmaak (csv):',
	'importusers-form-replace-present'    => 'Bestaande gebruikers vervangen',
	'importusers-form-button'             => 'Importeren',
	'importusers-user-added'              => 'Gebruiker <b>%s</b> is toegevoegd.',
	'importusers-user-present-update'     => 'Gebruiker <b>%s</b> bestaat al. Bijgewerkt.',
	'importusers-user-present-not-update' => 'Gebruiker <b>%s</b> bestaat al. Niet bijgewerkt.',
	'importusers-user-invalid-format'     => 'De gebruikersgegevens in de regel #%s hebben een ongeldige opmaak of zijn leeg. Overgeslagen.',
	'importusers-log'                     => 'Importlogboek',
	'importusers-log-summary'             => 'Samenvatting',
	'importusers-log-summary-all'         => 'Alle',
	'importusers-log-summary-added'       => 'Toegevoegd',
	'importusers-log-summary-updated'     => 'Bijgewerkt',
	'importusers-login-name'              => 'Gebruikersnaam',
	'importusers-password'                => 'wachtwoord',
	'importusers-email'                   => 'e-mail',
	'importusers-realname'                => 'echte naam',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'importusers-uploadfile'          => 'Last opp fil',
	'importusers-form-button'         => 'Importer',
	'importusers-log'                 => 'Brukarimporteringslogg',
	'importusers-log-summary-updated' => 'Oppdatert',
	'importusers-password'            => 'passord',
	'importusers-email'               => 'e-post',
	'importusers-realname'            => 'verkeleg namn',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'importusers'                         => 'Importer brukere',
	'importusers-desc'                    => 'Importing av brukere fra CSV-fil; tegnkoding: UTF-8',
	'importusers-uploadfile'              => 'Last opp fil',
	'importusers-form-caption'            => 'Sett inn CSV-fil (UTF-8)',
	'importusers-form-file'               => 'Brukerfilformat (csv):',
	'importusers-form-replace-present'    => 'Erstatt eksisterende brukere',
	'importusers-form-button'             => 'Importer',
	'importusers-user-added'              => 'Brukeren <b>%s</b> har blitt lagt til.',
	'importusers-user-present-update'     => 'Brukeren <b>%s</b> finnes allerede. Oppdatert.',
	'importusers-user-present-not-update' => 'Brukeren <b>%s</b> finnes allerede. Ikke oppdatert.',
	'importusers-user-invalid-format'     => 'Brukerdataene på linje #%s har ugyldig format eller er blank. Hoppet over.',
	'importusers-log'                     => 'Brukerimporteringslogg',
	'importusers-log-summary'             => 'Sammendrag',
	'importusers-log-summary-all'         => 'Alle',
	'importusers-log-summary-added'       => 'Lagt til',
	'importusers-log-summary-updated'     => 'Oppdatert',
	'importusers-login-name'              => 'Innloggingsnavn',
	'importusers-password'                => 'passord',
	'importusers-email'                   => 'e-post',
	'importusers-realname'                => 'virkelig navn',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'importusers'                         => "Importar d'utilizaires",
	'importusers-desc'                    => "Impòrta d'utilizaires en blòt dempuèi un fichièr CVS ; encodatge : UTF-8.",
	'importusers-uploadfile'              => 'Importar lo fichièr',
	'importusers-form-caption'            => 'Entratz un fichièr CVS (UTF-8)',
	'importusers-form-file'               => 'Format del fichièr utilizaire (csv) :',
	'importusers-form-replace-present'    => 'Remplaça los utilizaires existents',
	'importusers-form-button'             => 'Importar',
	'importusers-user-added'              => 'L’utilizaire <b>%s</b> es estat ajustat.',
	'importusers-user-present-update'     => 'l’utilizaire <b>%s</b> existís ja. Mesa a jorn efectuada.',
	'importusers-user-present-not-update' => 'L’utilizaire <b>%s</b> existís ja. Pas mes a jorn.',
	'importusers-user-invalid-format'     => "Las donadas d'utilizaire dins la linha #%s son dins un format marrit o alara son inexistentas. Cap d'accion.",
	'importusers-log'                     => 'Jornal dels impòrts',
	'importusers-log-summary'             => 'Somari',
	'importusers-log-summary-all'         => 'Total',
	'importusers-log-summary-added'       => 'Ajustat',
	'importusers-log-summary-updated'     => 'Mesa a jorn',
	'importusers-login-name'              => "Nom de l'escais",
	'importusers-password'                => 'Senhal',
	'importusers-email'                   => 'adreça de corrièr electronic',
	'importusers-realname'                => 'nom vertadièr',
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'importusers-uploadfile' => 'Ног файл сæвæр',
	'importusers-password'   => 'пароль',
	'importusers-email'      => 'эл. посты адрис',
);

/** Polish (Polski)
 * @author McMonster
 * @author Dodek
 * @author Sp5uhe
 * @author Airwolf
 * @author Maikking
 */
$messages['pl'] = array(
	'importusers'                         => 'Importuj kont użytkowników',
	'importusers-uploadfile'              => 'Prześlij plik',
	'importusers-form-button'             => 'Importuj',
	'importusers-user-added'              => 'Użytkownik <b>%s</b> został dodany.',
	'importusers-user-present-update'     => 'Użytkownik <b>%s</b> już istnieje. Zaktualizowano.',
	'importusers-user-present-not-update' => 'Użytkownik <b>%s</b> już istnieje. Nie zaktualizowano.',
	'importusers-log'                     => 'Rejestr importu',
	'importusers-log-summary'             => 'Podsumowanie',
	'importusers-log-summary-all'         => 'Wszyscy',
	'importusers-log-summary-added'       => 'Dodani',
	'importusers-log-summary-updated'     => 'Zmodyfikowano',
	'importusers-login-name'              => 'Nazwa użytkownika',
	'importusers-password'                => 'hasło',
	'importusers-email'                   => 'e-mail',
	'importusers-realname'                => 'imię i nazwisko',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'importusers-uploadfile'          => 'دوتنه پورته کول',
	'importusers-log-summary'         => 'لنډيز',
	'importusers-log-summary-all'     => 'ټول',
	'importusers-log-summary-updated' => 'تازه',
	'importusers-login-name'          => 'د ننوتلو کارن-نوم',
	'importusers-password'            => 'پټنوم',
	'importusers-email'               => 'برېښليک',
	'importusers-realname'            => 'اصلي نوم',
);

/** Portuguese (Português)
 * @author Malafaya
 */
$messages['pt'] = array(
	'importusers'                         => 'Importar Utilizadores',
	'importusers-desc'                    => 'Importa utilizadores em bloco de um ficheiro CSV; codificação: UTF-8',
	'importusers-uploadfile'              => 'Carregar ficheiro',
	'importusers-form-caption'            => 'Ficheiro CSV de entrada (UTF-8)',
	'importusers-form-file'               => 'Formato do ficheiro de utilizadores (csv):',
	'importusers-form-replace-present'    => 'Substituir utilizadores existentes',
	'importusers-form-button'             => 'Importar',
	'importusers-user-added'              => 'Utilizador <b>%s</b> foi adicionado.',
	'importusers-user-present-update'     => 'Utilizador <b>%s</b> já existe. Actualizado.',
	'importusers-user-present-not-update' => 'Utilizador <b>%s</b> já existe. Não foi actualizado.',
	'importusers-user-invalid-format'     => 'Dados de utilizador na linha #%s têm um formato inválido ou estão vazios. Passado à frente.',
	'importusers-log'                     => 'Registo de importação',
	'importusers-log-summary'             => 'Sumário',
	'importusers-log-summary-all'         => 'Todos',
	'importusers-log-summary-added'       => 'Adicionado',
	'importusers-log-summary-updated'     => 'Actualizado',
	'importusers-login-name'              => 'Nome de conta',
	'importusers-password'                => 'palavra-chave',
	'importusers-email'                   => 'email',
	'importusers-realname'                => 'nome real',
);

/** Tarifit (Tarifit)
 * @author Jose77
 */
$messages['rif'] = array(
	'importusers-uploadfile'      => 'Sili afaylu',
	'importusers-log-summary'     => 'Asgbr',
	'importusers-log-summary-all' => 'Maṛṛa',
	'importusers-realname'        => 'ism n dṣṣaḥ',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'importusers-email'    => 'e-mail',
	'importusers-realname' => 'nume real',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'importusers'                         => 'Импортирование участников',
	'importusers-desc'                    => 'Импорт большого количества участников из CSV-файла; кодировка: UTF-8',
	'importusers-uploadfile'              => 'Загрузить файл',
	'importusers-form-caption'            => 'Введите CVS-файл (UTF-8)',
	'importusers-form-file'               => 'Формат файла участников (csv):',
	'importusers-form-replace-present'    => 'Заменять существующих участников',
	'importusers-form-button'             => 'Импортировать',
	'importusers-user-added'              => 'Был добавлен участник <b>%s</b>.',
	'importusers-user-present-update'     => 'Участник <b>%s</b> уже существует. Обновлён.',
	'importusers-user-present-not-update' => 'Участник <b>%s</b> уже существует. Не обновлён.',
	'importusers-user-invalid-format'     => 'Данные участника в строке #%s имеют неправильный формат или пусты. Пропущен.',
	'importusers-log'                     => 'Журнал импорта',
	'importusers-log-summary'             => 'Итого',
	'importusers-log-summary-all'         => 'Всего',
	'importusers-log-summary-added'       => 'Добавлено',
	'importusers-log-summary-updated'     => 'Обновлено',
	'importusers-login-name'              => 'Имя учётной записи',
	'importusers-password'                => 'пароль',
	'importusers-email'                   => 'эл. почта',
	'importusers-realname'                => 'настоящее имя',
);

/** Tachelhit (Tašlḥiyt)
 * @author Zanatos
 */
$messages['shi'] = array(
	'importusers-log-summary-all' => 'kolchi',
	'importusers-login-name'      => 'ism omskhdam',
	'importusers-password'        => 'awal n tbadnit',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'importusers'                         => 'Import používateľov',
	'importusers-desc'                    => 'Hromadné importovanie používateľov z CSV súboru; kódovanie: UTF-8',
	'importusers-uploadfile'              => 'Nahrať súbor',
	'importusers-form-caption'            => 'Vstupný CSV súbor (UTF-8)',
	'importusers-form-file'               => 'Formát súboru (csv):',
	'importusers-form-replace-present'    => 'Nahradiť existujúcich používateľov',
	'importusers-form-button'             => 'Importovať',
	'importusers-user-added'              => 'Používateľ <b>%s</b> bol pridaný.',
	'importusers-user-present-update'     => 'Používateľ <b>%s</b> už existuje. Aktualizovaný.',
	'importusers-user-present-not-update' => 'Používateľ <b>%s</b> už existuje. Ponecháva sa bez aktualizácie.',
	'importusers-user-invalid-format'     => 'Údaje na riadku #%s majú neplatný formát alebo je riadok prázdny. Riadok preskočený.',
	'importusers-log'                     => 'Záznam importov',
	'importusers-log-summary'             => 'Zhrnutie',
	'importusers-log-summary-all'         => 'Všetky',
	'importusers-log-summary-added'       => 'Pridané',
	'importusers-log-summary-updated'     => 'Aktualizované',
	'importusers-login-name'              => 'Prihlasovacie meno',
	'importusers-password'                => 'heslo',
	'importusers-email'                   => 'email',
	'importusers-realname'                => 'skutočné meno',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'importusers'                         => 'Benutsere importierje',
	'importusers-desc'                    => 'Importiert Benutsere uut ne CSV-Doatäi; Codierenge: UTF-8',
	'importusers-uploadfile'              => 'Doatäi hoochleede',
	'importusers-form-caption'            => 'CSV-Doatäi (UTF-8)',
	'importusers-form-file'               => 'Benutserdoatäiformoat (csv):',
	'importusers-form-replace-present'    => 'Bestoundene Benutsere ärsätte',
	'importusers-form-button'             => 'Importierje',
	'importusers-user-added'              => 'Die Benutser <b>%s</b> wuude importierd.',
	'importusers-user-present-update'     => 'N Benutser <b>%s</b> existiert al. Aktualisierd.',
	'importusers-user-present-not-update' => 'N Benutser <b>%s</b> existiert al. Nit aktualisierd.',
	'importusers-user-invalid-format'     => 'Do Benutserdoaten in Riege #%s hääbe n uungultich Formoat of sunt loos. Uursproangen.',
	'importusers-log'                     => 'Benutserimport-Logbouk',
	'importusers-log-summary'             => 'Touhoopefoatenge',
	'importusers-log-summary-all'         => 'Aal',
	'importusers-log-summary-added'       => 'Bietouföiged',
	'importusers-log-summary-updated'     => 'Aktualisierd',
	'importusers-login-name'              => 'Benutsernoome',
	'importusers-password'                => 'Paaswoud',
	'importusers-email'                   => 'E-Mail',
	'importusers-realname'                => 'Ächten Noome',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'importusers-password' => 'sandi',
);

/** Swedish (Svenska)
 * @author M.M.S.
 * @author Lejonel
 * @author Jon Harald Søby
 */
$messages['sv'] = array(
	'importusers'                         => 'Importera användare',
	'importusers-desc'                    => 'Importera användare från en CSV-fil; teckenkodning: UTF-8',
	'importusers-uploadfile'              => 'Ladda upp fil',
	'importusers-form-caption'            => 'Sätt in CSV-fil (UTF-8)',
	'importusers-form-file'               => 'Användarfilsformat (csv):',
	'importusers-form-replace-present'    => 'Ersätt existerande användare',
	'importusers-form-button'             => 'Importera',
	'importusers-user-added'              => 'Användare <b>%s</b> hat blivigt tillagd.',
	'importusers-user-present-update'     => 'Användare <b>%s</b> existerar redan. Uppdaterad.',
	'importusers-user-present-not-update' => 'Användaren <b>%s</b> finns redan. Inte uppdaterat.',
	'importusers-user-invalid-format'     => 'Användardatan på linje #%s har ogiltigt format eller är blank. Överhoppad.',
	'importusers-log'                     => 'Importlogg',
	'importusers-log-summary'             => 'Sammanfattning',
	'importusers-log-summary-all'         => 'Alla',
	'importusers-log-summary-added'       => 'Tillagd',
	'importusers-log-summary-updated'     => 'Uppdaterad',
	'importusers-login-name'              => 'Inloggningsnamn',
	'importusers-password'                => 'lösenord',
	'importusers-email'                   => 'e-post',
	'importusers-realname'                => 'riktigt namn',
);

/** Tamil (தமிழ்)
 * @author Trengarasu
 */
$messages['ta'] = array(
	'importusers-log-summary-all' => 'அனைத்து',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'importusers'                         => 'వాడుకరులను దిగుమతి చేయి',
	'importusers-uploadfile'              => 'ఫైలుని ఎగుమతి చేయండి',
	'importusers-form-button'             => 'దిగుమతించు',
	'importusers-user-added'              => '<b>%s</b> అనే వాడుకరిని చేర్చాం.',
	'importusers-user-present-update'     => '<b>%s</b> అనే వాడుకరి ఈసరికే ఉన్నారు. తాజాకరించాం.',
	'importusers-user-present-not-update' => '<b>%s</b> అనే వాడుకరి ఈసరికే ఉన్నారు. తాజాకరించలేదు.',
	'importusers-log'                     => 'దిగుమతి దినచర్య',
	'importusers-log-summary'             => 'సంగ్రహం',
	'importusers-log-summary-all'         => 'అన్నీ',
	'importusers-log-summary-added'       => 'చేర్చినవి',
	'importusers-log-summary-updated'     => 'తాజాకరించినవి',
	'importusers-login-name'              => 'ప్రవేశపు పేరు',
	'importusers-password'                => 'సంకేతపదం',
	'importusers-email'                   => 'ఈ-మెయిల్',
	'importusers-realname'                => 'నిజమైన పేరు',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'importusers-log-summary-all' => 'Hotu',
	'importusers-email'           => 'korreiu eletróniku',
);

/** Tajik (Cyrillic) (Тоҷикӣ/tojikī (Cyrillic))
 * @author Ibrahim
 * @author Siebrand
 */
$messages['tg-cyrl'] = array(
	'importusers'                         => 'Ворид кардани Корбарон',
	'importusers-uploadfile'              => 'Фиристодани парванда',
	'importusers-user-added'              => 'Корбар <b>%s</b> илова шуд.',
	'importusers-user-present-update'     => 'Корбар <b>%s</b> аллакай вуҷуд дорад. Барӯз шудааст.',
	'importusers-user-present-not-update' => 'Корбар <b>%s</b> аллакай вуҷуд дорад. Барӯз нашудааст.',
	'importusers-log-summary'             => 'Хулоса',
	'importusers-log-summary-all'         => 'Ҳама',
	'importusers-password'                => 'гузарвожа',
	'importusers-email'                   => 'почтаи электронӣ',
	'importusers-realname'                => 'номи аслӣ',
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'importusers'                         => 'Nhập khẩu Thành viên',
	'importusers-desc'                    => 'Nhập nhiều thành viên từ tậptin CSV; mã hóa: UTF-8',
	'importusers-uploadfile'              => 'Tải tập tin lên',
	'importusers-form-caption'            => 'Tập CSV đầu vào (UTF-8)',
	'importusers-form-file'               => 'Định dạng tập tin người dùng (csv):',
	'importusers-form-replace-present'    => 'Thay thế những thành viên hiện có',
	'importusers-form-button'             => 'Nhập khẩu',
	'importusers-user-added'              => 'Thành viên <b>%s</b> đã được thêm vào.',
	'importusers-user-present-update'     => 'Thành viên <b>%s</b> đã tồn tại. Đã cập nhật.',
	'importusers-user-present-not-update' => 'Thành viên <b>%s</b> đã tồn tại. Không cập nhật.',
	'importusers-user-invalid-format'     => 'Dữ liệu thành viên tại dòng #%s có định dạng sai hoặc bỏ trống. Bỏ qua.',
	'importusers-log'                     => 'Nhật trình nhập',
	'importusers-log-summary'             => 'Tóm tắt',
	'importusers-log-summary-all'         => 'Tất cả',
	'importusers-log-summary-added'       => 'Được thêm vào',
	'importusers-log-summary-updated'     => 'Đã cập nhật',
	'importusers-login-name'              => 'Tên đăng nhập',
	'importusers-password'                => 'mật khẩu',
	'importusers-email'                   => 'thư điện tử',
	'importusers-realname'                => 'tên thật',
);

/** Volapük (Volapük)
 * @author Malafaya
 */
$messages['vo'] = array(
	'importusers-log-summary-all' => 'Valik',
);

