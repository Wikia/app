<?php
#coding: utf-8
/** \file
* \brief Internationalization file for the Password Reset Extension.
*/

$messages = array();

$messages['en'] = array(
	'passwordreset' => 'Password reset',
	'passwordreset-desc'               => "Resets wiki user's passwords - requires 'passwordreset' privileges",
	'passwordreset-invalidusername'    => 'Invalid username',
	'passwordreset-emptyusername'      => 'Empty username',
	'passwordreset-nopassmatch'        => 'Passwords do not match',
	'passwordreset-badtoken'           => 'Invalid edit token',
	'passwordreset-username'           => 'Username',
	'passwordreset-newpass'            => 'New password',
	'passwordreset-confirmpass'        => 'Confirm password',
	'passwordreset-submit'             => 'Reset password',
	'passwordreset-success'            => 'Password has been reset for user_id: $1',
	'passwordreset-disableuser'        => 'Disable user account?',
	'passwordreset-disableuserexplain' => '(sets an invalid password hash - user cannot login)',
	'passwordreset-disablesuccess'     => 'User account has been disabled (user ID: $1)',
	'passwordreset-accountdisabled'    => 'Account has been disabled',
	'disabledusers'                    => 'Disabled users',
	'disabledusers-summary'            => 'This is a list of users that have been disabled via PasswordReset.',
);

/** Faeag Rotuma (Faeag Rotuma)
 * @author Jose77
 */
$messages['rtm'] = array(
	'passwordreset-username' => 'Asa',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'passwordreset-username' => 'Пайдаланышын лӱмжӧ',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'passwordreset-username' => 'Matahigoa he tagata',
);

/** Afrikaans (Afrikaans)
 * @author SPQRobin
 * @author Naudefj
 */
$messages['af'] = array(
	'passwordreset-username' => 'Gebruikersnaam',
	'passwordreset-newpass'  => 'Nuwe wagwoord',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'passwordreset'                    => 'تمت إعادة ضبط كلمة السر',
	'passwordreset-invalidusername'    => 'اسم مستخدم غير صحيح',
	'passwordreset-emptyusername'      => 'اسم مستخدم فارغ',
	'passwordreset-nopassmatch'        => 'كلمات السر لا تتطابق',
	'passwordreset-badtoken'           => 'نص تعديل غير صحيح',
	'passwordreset-username'           => 'اسم مستخدم',
	'passwordreset-newpass'            => 'كلمة سر جديدة',
	'passwordreset-confirmpass'        => 'أكد كلمة السر',
	'passwordreset-submit'             => 'أعد ضبط كلمة السر',
	'passwordreset-success'            => 'كلمة السر تم ضبطها ل user_id: $1',
	'passwordreset-disableuser'        => 'عطل حساب المستخدم؟',
	'passwordreset-disableuserexplain' => '(يضبط هاش كلمة سر غير صحيح - المستخدم لا يمكنه الدخول)',
	'passwordreset-disablesuccess'     => 'حساب المستخدم تم تعطيله (رقم_المستخدم: $1)',
	'passwordreset-accountdisabled'    => 'الحساب تم تعطيله',
	'disabledusers'                    => 'مستخدمون معطلون',
	'disabledusers-summary'            => 'هذه قائمة بالمستخدمين الذين تم تعطيلهم من خلال إعادة ضبط كلمة السر.',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'passwordreset-invalidusername' => 'Невалидно потребителско име',
	'passwordreset-emptyusername'   => 'Празно потребителско име',
	'passwordreset-nopassmatch'     => 'Паролите не съвпадат',
	'passwordreset-username'        => 'Потребителско име',
	'passwordreset-newpass'         => 'Нова парола',
	'passwordreset-confirmpass'     => 'Парола (повторно)',
	'passwordreset-disableuser'     => 'Деактивиране на потребителската сметка?',
	'passwordreset-disablesuccess'  => 'Потребителската сметка беше деактивирана (потребителски номер: $1)',
	'passwordreset-accountdisabled' => 'Потребителската сметка беше деактивирана',
	'disabledusers'                 => 'Деактивирани потребителски сметки',
	'disabledusers-summary'         => 'Това е списък с потребителски сметки, които са били деактивирани чрез PasswordReset.',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'passwordreset-username' => 'по́льꙃєватєлꙗ и́мѧ',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'passwordreset-username' => 'Brugernavn',
	'passwordreset-newpass'  => 'Ny adgangskode',
	'passwordreset-submit'   => 'Nullstille passord',
);

/** German (Deutsch)
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'passwordreset'                    => 'Passwort zurücksetzen',
	'passwordreset-desc'               => "Zurücksetzen eines Benutzer-Passwortes - ''passwordreset''-Recht notwendig",
	'passwordreset-invalidusername'    => 'Ungültiger Benutzername',
	'passwordreset-emptyusername'      => 'Leerer Benutzername',
	'passwordreset-nopassmatch'        => 'Passwörter stimmen nicht überein',
	'passwordreset-badtoken'           => 'Ungültiger „Edit Token“',
	'passwordreset-username'           => 'Benutzername',
	'passwordreset-newpass'            => 'Neues Passwort',
	'passwordreset-confirmpass'        => 'Passwort bestätigen',
	'passwordreset-submit'             => 'Passwort zurücksetzen',
	'passwordreset-success'            => 'Passwort für Benutzer-ID $1 wurde zurückgesetzt.',
	'passwordreset-disableuser'        => 'Benutzerkonto deaktivieren?',
	'passwordreset-disableuserexplain' => '(setzen eines ungültigen Passwort-Hashs - Anmelden unmöglich)',
	'passwordreset-disablesuccess'     => 'Benutzerkonto für Benutzer-ID $1 wurde deaktiviert.',
	'passwordreset-accountdisabled'    => 'Benutzerkonto ist deaktiviert',
	'disabledusers'                    => 'Deaktivierte Benutzerkonten',
	'disabledusers-summary'            => 'Dies ist die Liste der deaktivierten Benutzerkonten (via PasswordReset).',
);

/** Greek (Ελληνικά)
 * @author Consta
 */
$messages['el'] = array(
	'passwordreset'                 => 'Κωδικός επαναφοράς',
	'passwordreset-invalidusername' => 'Άκυρο όνομα χρήστη',
	'passwordreset-emptyusername'   => 'Κενό όνομα χρήστη',
	'passwordreset-nopassmatch'     => 'Οι Κωδικοί δεν αντιστοιχούν',
	'passwordreset-username'        => 'Όνομα χρήστη',
	'passwordreset-newpass'         => 'Νέος Κωδικός',
	'passwordreset-confirmpass'     => 'Επιβεβαιώστε τον κωδικό πρόσβασης',
	'passwordreset-submit'          => 'Επαναφορά κωδικού',
	'passwordreset-success'         => 'Ο κωδικός έχει επαναφερθεί για τον user_id: $1',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'passwordreset'                 => 'Restarigo de pasvorto',
	'passwordreset-invalidusername' => 'Nevalida Salutnomo',
	'passwordreset-emptyusername'   => 'Malplena Salutnomo',
	'passwordreset-nopassmatch'     => 'Pasvortoj ne estas samaj',
	'passwordreset-username'        => 'Salutnomo',
	'passwordreset-newpass'         => 'Nova pasvorto',
	'passwordreset-confirmpass'     => 'Konfirmu Pasvorton',
	'passwordreset-submit'          => 'Refari pasvorton',
	'passwordreset-success'         => 'Pasvorto estis restarigita por user_id: $1',
	'passwordreset-disablesuccess'  => 'Konto de uzanto estis malebligita (uzanto-identigo: $1)',
	'disabledusers'                 => 'Malebligitaj uzantoj',
);

/** French (Français)
 * @author Sherbrooke
 * @author Dereckson
 * @author Grondin
 * @author Urhixidur
 */
$messages['fr'] = array(
	'passwordreset'                    => 'Remise à zéro du mot de passe',
	'passwordreset-desc'               => 'Réinitialise le mot de passe wiki d’un utilisateur - nécessite les droits de « passwordreset »',
	'passwordreset-invalidusername'    => "Nom d'usager inconnu",
	'passwordreset-emptyusername'      => "Nom d'usager vide",
	'passwordreset-nopassmatch'        => 'Les mots de passe que vous avez saisis ne sont pas identiques.',
	'passwordreset-badtoken'           => 'Jeton de modification inconnu',
	'passwordreset-username'           => "Nom d'usager",
	'passwordreset-newpass'            => 'Nouveau mot de passe',
	'passwordreset-confirmpass'        => 'Confirmez le mot de passe',
	'passwordreset-submit'             => 'Remise à zéro du mot de passe',
	'passwordreset-success'            => 'Le mot de passe a été remis à zéro pour l’usager $1.',
	'passwordreset-disableuser'        => 'Désactiver le compte utilisateur ?',
	'passwordreset-disableuserexplain' => '(spécifie un hachage de mot de passe invalide - l’utilisateur ne pourra pas se connecter)',
	'passwordreset-disablesuccess'     => 'Compte utilisateur désactivé (user_id : $1)',
	'passwordreset-accountdisabled'    => 'Ce compte a été désactivé.',
	'disabledusers'                    => 'Utilisateurs désactivés',
	'disabledusers-summary'            => 'Ceci est la liste des utilisateurs qui ont été désactivés par PasswordReset.',
);

/** Galician (Galego)
 * @author Xosé
 * @author Toliño
 * @author Alma
 */
$messages['gl'] = array(
	'passwordreset'                    => 'Eliminar o contrasinal',
	'passwordreset-desc'               => 'Restablecer o contrasinal do usuario dun wiki (require privilexios "passwordreset")',
	'passwordreset-invalidusername'    => 'Nome de usuario non válido',
	'passwordreset-emptyusername'      => 'Nome de usuario baleiro',
	'passwordreset-nopassmatch'        => 'Os contrasinais non coinciden',
	'passwordreset-badtoken'           => 'Sinal de edición non válido',
	'passwordreset-username'           => 'Nome de usuario',
	'passwordreset-newpass'            => 'Contrasinal Novo',
	'passwordreset-confirmpass'        => 'Confirme o Contrasinal',
	'passwordreset-submit'             => 'Limpar o Contrasinal',
	'passwordreset-success'            => 'Limpouse o contrasinal para o id de usuario: $1',
	'passwordreset-disableuser'        => 'Desactivar a Conta de Usuario?',
	'passwordreset-disableuserexplain' => '(fixa un contrasinal hash inválido - o usuario non pode acceder ao sistema)',
	'passwordreset-disablesuccess'     => 'Desactivouse a conta do usuario (user_id: $1)',
	'passwordreset-accountdisabled'    => 'A conta foi desabilitada',
	'disabledusers'                    => 'Usuarios desabilitados',
	'disabledusers-summary'            => 'Esta é unha listaxe dos usuarios que foron deshabilitados por medio de PasswordReset.',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'passwordreset-username' => "Dt'ennym ymmydeyr",
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'passwordreset'                    => 'कूटशब्द रिसैट',
	'passwordreset-desc'               => "विकिसदस्य का कूटशब्द पूर्ववत करें - इसके लिये 'passwordreset' अधिकार होना आवश्यक हैं",
	'passwordreset-invalidusername'    => 'अवैध सदस्यनाम',
	'passwordreset-emptyusername'      => 'खाली सदस्यनाम',
	'passwordreset-nopassmatch'        => 'कूटशब्द मिलते नहीं',
	'passwordreset-badtoken'           => 'गलत एडिट टोकन',
	'passwordreset-username'           => 'सदस्यनाम',
	'passwordreset-newpass'            => 'नया कूटशब्द',
	'passwordreset-confirmpass'        => 'कूटशब्द निश्चित करें',
	'passwordreset-submit'             => 'कूटशब्द रिसैट करें',
	'passwordreset-success'            => 'निम्नलिखित सदस्य क्रमांक का कूटशब्द पूर्ववत कर दिया गया हैं: $1',
	'passwordreset-disableuser'        => 'सदस्य खाता बंद करें?',
	'passwordreset-disableuserexplain' => '(कूटशब्दमें एक गलत हॅश लिखता हैं - सदस्य लॉग इन नहीं कर सकता)',
	'passwordreset-disablesuccess'     => 'सदस्या खाता बंद कर दिया गया हैं (सदस्य क्रमांक: $1)',
	'passwordreset-accountdisabled'    => 'खाता बंद कर दिया गया हैं',
	'disabledusers'                    => 'बंद किये हुए खाता',
	'disabledusers-summary'            => 'यह ऐसे सदस्योंकी सूची हैं जिनके खाते PasswordReset का इस्तेमाल करके बंद कर दिये गये हैं।',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'passwordreset-username' => 'Ngalan sang Manog-gamit',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'passwordreset'                    => 'Hesło wróćo stajić',
	'passwordreset-desc'               => "Staja wužiwarske hesła wróćo - wužaduje prawa 'passwordreset'",
	'passwordreset-invalidusername'    => 'Njepłaćiwe wužiwarske mjeno',
	'passwordreset-emptyusername'      => 'Žane wužiwarske mjeno',
	'passwordreset-nopassmatch'        => 'Hesle njerunatej so',
	'passwordreset-badtoken'           => 'Njepłaćiwe wobdźěłanske znamjo',
	'passwordreset-username'           => 'Wužiwarske mjeno',
	'passwordreset-newpass'            => 'Nowe hesło',
	'passwordreset-confirmpass'        => 'Hesło wobkrućić',
	'passwordreset-submit'             => 'Hesło wróćo stajić',
	'passwordreset-success'            => 'Hesło bu za wužiwarski ID $1 wróćo stajene.',
	'passwordreset-disableuser'        => 'Wužiwarske konto znjemóžnić?',
	'passwordreset-disableuserexplain' => '(nastaja njepłaćiwy hesłowy šmjat - wužiwar njemóže so přizjewić)',
	'passwordreset-disablesuccess'     => 'Wužiwarske konto bu znjemóžnjene (wužiwarski_id: $1)',
	'passwordreset-accountdisabled'    => 'Konto bu znjemóžnjene',
	'disabledusers'                    => 'Znjemóžnene wužiwarske konta',
	'disabledusers-summary'            => 'To je lisćina wužiwarskich kontow, kotrež buchu přez PasswordReset znjemóžnjene.',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'passwordreset'                    => 'Jelszó beállítása',
	'passwordreset-invalidusername'    => 'Érvénytelen felhasználói név',
	'passwordreset-emptyusername'      => 'Nincs megadva felhasználói név',
	'passwordreset-nopassmatch'        => 'A jelszavak nem egyeznek meg',
	'passwordreset-badtoken'           => 'Hibás szerkesztési token',
	'passwordreset-username'           => 'Felhasználói név',
	'passwordreset-newpass'            => 'Új jelszó',
	'passwordreset-confirmpass'        => 'Jelszó megerősítése',
	'passwordreset-submit'             => 'Jelszó visszaállítása',
	'passwordreset-success'            => 'A(z) $1 azonosítószámú felhasználó jelszava be lett állítva',
	'passwordreset-disableuser'        => 'Felhasználói fiók letiltása?',
	'passwordreset-disableuserexplain' => '(egy érvénytelen hasht állít be jelszónak, így a felhasználó nem tud bejelentkezni)',
	'passwordreset-disablesuccess'     => 'A felhasználói fiók le lett tiltva (azonosító: $1)',
	'passwordreset-accountdisabled'    => 'A felhasználói fiók le lett tiltva',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'passwordreset-username' => 'Nomine de usator',
	'passwordreset-newpass'  => 'Nove contrasigno',
	'passwordreset-submit'   => 'Redefinir contrasigno',
);

/** Indonesian (Bahasa Indonesia)
 * @author Rex
 */
$messages['id'] = array(
	'passwordreset-badtoken' => 'Token penyuntingan tidak sah',
	'passwordreset-username' => 'Nama pengguna',
);

/** Interlingue (Interlingue)
 * @author SPQRobin
 */
$messages['ie'] = array(
	'passwordreset-username' => 'Vor nómine usatori',
	'passwordreset-newpass'  => 'Nov passa-parol',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'passwordreset-username' => 'Uzantonomo',
	'passwordreset-newpass'  => 'Nova Kontrolajo',
);

/** Icelandic (Íslenska)
 * @author SPQRobin
 */
$messages['is'] = array(
	'passwordreset-username' => 'Notandanafn',
);

/** Italian (Italiano)
 * @author Pietrodn
 * @author Darth Kule
 */
$messages['it'] = array(
	'passwordreset'                    => 'Reimposta password',
	'passwordreset-desc'               => "Reimposta le password di utenti della wiki - richiede dei privilegi 'passwordreset'",
	'passwordreset-invalidusername'    => 'Nome utente non valido',
	'passwordreset-emptyusername'      => 'Nome utente vuoto',
	'passwordreset-nopassmatch'        => 'Le password non corrispondono',
	'passwordreset-badtoken'           => 'Edit token non valido',
	'passwordreset-username'           => 'Nome utente',
	'passwordreset-newpass'            => 'Nuova password',
	'passwordreset-confirmpass'        => 'Conferma password',
	'passwordreset-submit'             => 'Reimposta password',
	'passwordreset-success'            => 'La password è stata reimpostata per user_id: $1',
	'passwordreset-disableuser'        => 'Disabilitare account?',
	'passwordreset-disableuserexplain' => "(imposta una hash password non valida - l'utente non può effettuare il login)",
	'passwordreset-disablesuccess'     => "L'account è stato disabilitato (ID utente: $1)",
	'passwordreset-accountdisabled'    => "L'account è stato dsiabilitato",
	'disabledusers'                    => 'Utenti disabilitati',
	'disabledusers-summary'            => 'Questa è la lista degli utenti che sono stati disabilitati con PasswordReset.',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'passwordreset-invalidusername' => 'Jeneng panganggo ora absah',
	'passwordreset-emptyusername'   => 'Jeneng panganggo kosong',
	'passwordreset-nopassmatch'     => 'Tembung sandhiné ora cocog',
	'passwordreset-badtoken'        => 'Token panyuntingan ora absah',
	'passwordreset-username'        => 'Jeneng panganggo',
	'passwordreset-newpass'         => 'Tembung sandhi anyar',
	'passwordreset-confirmpass'     => 'Konfirmasi tembung sandhi',
	'passwordreset-submit'          => 'Reset tembung sandhi',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 */
$messages['km'] = array(
	'passwordreset-invalidusername' => 'ឈ្មោះអ្នកប្រើប្រាស់ គ្មានសុពលភាព',
	'passwordreset-emptyusername'   => 'ឈ្មោះអ្នកប្រើប្រាស់ ទទេ',
	'passwordreset-username'        => 'ឈ្មោះអ្នកប្រើប្រាស់',
	'passwordreset-newpass'         => 'ពាក្យសំងាត់ថ្មី',
	'passwordreset-confirmpass'     => 'បញ្ជាក់ទទួលស្គាល់ ពាក្យសំងាត់',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'passwordreset-username' => 'Metmaacher Name',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'passwordreset'                 => 'Passwuert zrécksetzen',
	'passwordreset-desc'            => "Zrécksetzen vu Benotzerpasswierder - Dir braucht dofir 'Passwordreset'-Rechter",
	'passwordreset-invalidusername' => 'Onbekannte Benotzernumm',
	'passwordreset-emptyusername'   => 'Eidele Benotzernumm',
	'passwordreset-nopassmatch'     => 'Déi Passwierder déi Dir aginn hutt sinn net identesch',
	'passwordreset-username'        => 'Benotzernumm',
	'passwordreset-newpass'         => 'Neit Passwuert',
	'passwordreset-confirmpass'     => 'Passwuert confirméieren',
	'passwordreset-submit'          => 'Passwuert zrécksetzen',
	'passwordreset-success'         => "Passwuert fir d'Benotzernummer (User_id) $1 gouf zréckgesat",
	'passwordreset-disableuser'     => 'Benotzerkont deaktivéieren?',
	'passwordreset-disablesuccess'  => 'De benotzerkont gouf desaktivéiert (Benotzernummer/user ID:$1)',
	'passwordreset-accountdisabled' => 'De Benotzerkont gouf desaktivéiert',
	'disabledusers'                 => 'Desaktivéiert Benotzer',
	'disabledusers-summary'         => 'Dëst ass eng Lëscht vun den, iwwer PasswordReset, deaktivéierte Benotzer.',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'passwordreset'                 => 'രഹസ്യവാക്ക് പുനഃക്രമീകരിക്കുക',
	'passwordreset-invalidusername' => 'അസാധുവായ ഉപയോക്തൃനാമം',
	'passwordreset-emptyusername'   => 'ശൂന്യമായ ഉപയോക്തൃനാമം',
	'passwordreset-nopassmatch'     => 'രഹസ്യ വാക്കുകള്‍ തമ്മില്‍ യോജിക്കുന്നില്ല',
	'passwordreset-username'        => 'ഉപയോക്തൃനാമം',
	'passwordreset-newpass'         => 'പുതിയ രഹസ്യവാക്ക്',
	'passwordreset-confirmpass'     => 'രഹസ്യവാക്ക് ഉറപ്പിക്കുക',
	'passwordreset-submit'          => 'രഹസ്യവാക്ക് പുനഃക്രമീകരിക്കുക',
	'passwordreset-success'         => 'ഈ ഉപയോക്തൃഐഡിയുടെ രഹസ്യവാക്ക് പുനഃക്രമീകരിച്ചു: $1',
	'passwordreset-disableuser'     => 'ഉപയോക്തൃഅക്കൗണ്ട് ഡിസേബിള്‍ ചെയ്യണമോ?',
	'passwordreset-disablesuccess'  => 'ഉപയോക്തൃ അക്കൗണ്ട് ഡിസേബിള്‍ ചെയ്തിരിക്കുന്നു. (ഉപയോക്തൃ ഐഡി: $1)',
	'passwordreset-accountdisabled' => 'അക്കൗണ്ട് പ്രവര്‍ത്തനരഹിതമാക്കിയിരിക്കുന്നു',
	'disabledusers'                 => 'ഡിസേബിള്‍ ചെയ്യപ്പെട്ട ഉപയോക്താക്കള്‍',
	'disabledusers-summary'         => 'രഹസ്യവാക്ക് പുനഃക്രമീകരണത്തിലൂടെ പ്രവര്‍ത്തനരഹിതമാക്കിയ ഉപയോക്താക്കളുടെ പട്ടിക.',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'passwordreset'                    => 'परवलीचा शब्द पूर्ववत करा',
	'passwordreset-desc'               => "विकि सदस्याचा परवलीचा शब्द पूर्ववत करा - यासाठी 'passwordreset' अधिकार असणे आवश्यक आहे",
	'passwordreset-invalidusername'    => 'चुकीचे सदस्यनाव',
	'passwordreset-emptyusername'      => 'रिकामे सदस्यनाव',
	'passwordreset-nopassmatch'        => 'परवलीचे शब्द जुळले नाहीत',
	'passwordreset-badtoken'           => 'चुकीचे संपादन टोकन',
	'passwordreset-username'           => 'सदस्यनाव',
	'passwordreset-newpass'            => 'नवीन परवलीचा शब्द',
	'passwordreset-confirmpass'        => 'परवलीचा शब्द पुन्हा लिहा',
	'passwordreset-submit'             => 'परवलीचा शब्द पूर्ववत करा',
	'passwordreset-success'            => 'पुढील सदस्यक्रमांकाकरीता परवलीचा शब्द पूर्ववत केलेला आहे: $1',
	'passwordreset-disableuser'        => 'सदस्य खाते प्रलंबित करायचे का?',
	'passwordreset-disableuserexplain' => '(परवलीच्या शब्दात एक चुकीचा हॅश वाढवितो - सदस्य प्रवेश करू शकत नाही)',
	'passwordreset-disablesuccess'     => 'सदस्य खाते बंद करण्यात आलेले आहे (सदस्य क्रमांक: $1)',
	'passwordreset-accountdisabled'    => 'खाते बंद केलेले आहे',
	'disabledusers'                    => 'बंद केलेले सदस्य',
	'disabledusers-summary'            => 'ही अशा सदस्यांची यादी आहे ज्यांची खाती PasswordReset वापरून बंद करण्यात आलेली आहेत.',
);

/** Nahuatl (Nahuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'passwordreset-username' => 'Tlatēquitiltilīltōcāitl',
);

/** Dutch (Nederlands)
 * @author Siebrand
 * @author SPQRobin
 */
$messages['nl'] = array(
	'passwordreset'                    => 'Wachtwoord opnieuw instellen',
	'passwordreset-desc'               => "Voegt een [[Special:Passwordreset|speciale pagina]] toe om wachtwoorden van gebruikers opnieuw in te stellen - het recht 'passwordreset' is hiervoor nodig",
	'passwordreset-invalidusername'    => 'Onjuiste gebruiker',
	'passwordreset-emptyusername'      => 'Gebruiker niet ingegeven',
	'passwordreset-nopassmatch'        => 'De wachtwoorden komen niet overeen',
	'passwordreset-badtoken'           => 'Ongeldig bewerkingstoken',
	'passwordreset-username'           => 'Gebruiker',
	'passwordreset-newpass'            => 'Nieuw wachtwoord',
	'passwordreset-confirmpass'        => 'Bevestig wachtwoord',
	'passwordreset-submit'             => 'Wachtwoord opnieuw instellen',
	'passwordreset-success'            => 'Wachtwoord voor gebruikersummer $1 is opnieuw ingesteld',
	'passwordreset-disableuser'        => 'Gebruiker deactiveren?',
	'passwordreset-disableuserexplain' => '(stelt een onjuiste wachtwoordhash in - gebruiker kan niet aanmelden)',
	'passwordreset-disablesuccess'     => 'Gebruiker is gedeactiveerd (gebruikersnummer $1)',
	'passwordreset-accountdisabled'    => 'Gebruiker is gedeactiveerd',
	'disabledusers'                    => 'Gedeactiveerde gebruikers',
	'disabledusers-summary'            => 'Dit is een lijst van gebruikers die zijn gedeactiveerd via PasswordReset',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'passwordreset-username' => 'Brukarnamn',
	'passwordreset-newpass'  => 'Nytt passord',
	'passwordreset-submit'   => 'Nullstill passord',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'passwordreset'                    => 'Passordresetting',
	'passwordreset-desc'               => "Resett brukeres passord &ndash; krever 'passwordreset'-rettigheter",
	'passwordreset-invalidusername'    => 'Ugyldig brukernavn',
	'passwordreset-emptyusername'      => 'Tomt brukernavn',
	'passwordreset-nopassmatch'        => 'Passordene er ikke de samme',
	'passwordreset-badtoken'           => 'Ugyldig redigeringstegn',
	'passwordreset-username'           => 'Brukernavn',
	'passwordreset-newpass'            => 'Nytt passord',
	'passwordreset-confirmpass'        => 'Bekreft passord',
	'passwordreset-submit'             => 'Nullstill passord',
	'passwordreset-success'            => 'Passordet for brukeren «$1» har blitt resatt.',
	'passwordreset-disableuser'        => 'Deaktiver kontoen?',
	'passwordreset-disableuserexplain' => '(setter et ugyldig passord – brukeren kan ikke logge inn)',
	'passwordreset-disablesuccess'     => 'Kontoen er blitt deaktivert (bruker-ID: $1)',
	'passwordreset-accountdisabled'    => 'Kontoen er blitt deaktivert',
	'disabledusers'                    => 'Deaktiverte kontoer',
	'disabledusers-summary'            => 'Dette er en liste over kontoer som har blitt deaktiverte via passordresetting.',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'passwordreset'                    => 'Remesa a zèro del senhal',
	'passwordreset-desc'               => 'Reïnicializa lo senhal wiki d’un utilizaire - necessita los dreches de « passwordreset »',
	'passwordreset-invalidusername'    => "Nom d'utilizaire desconegut",
	'passwordreset-emptyusername'      => "Nom d'utilizaire void",
	'passwordreset-nopassmatch'        => "Los senhals qu'avètz picats son pas identics.",
	'passwordreset-badtoken'           => 'Geton de modificacion desconegut',
	'passwordreset-username'           => "Nom d'utilizaire",
	'passwordreset-newpass'            => 'Senhal novèl',
	'passwordreset-confirmpass'        => 'Confirmatz lo senhal',
	'passwordreset-submit'             => 'Remesa a zèro del senhal',
	'passwordreset-success'            => "Lo senhal es estat remés a zèro per lo ''user_id'' $1.",
	'passwordreset-disableuser'        => "Desactivar lo compte d'utilizaire ?",
	'passwordreset-disableuserexplain' => "(règla un hash de senhal pas valid - l'utilizaire pòt pas se connectar)",
	'passwordreset-disablesuccess'     => "Compte d'utilizaire desactivat (user_id : $1)",
	'passwordreset-accountdisabled'    => 'Aqueste compte es estat desactivat.',
	'disabledusers'                    => 'Utilizaires desactivats',
	'disabledusers-summary'            => 'Aquò es la tièra dels utilizaires que son estats desactivats per PasswordReset.',
);

/** Polish (Polski)
 * @author Sp5uhe
 * @author Derbeth
 */
$messages['pl'] = array(
	'passwordreset'                    => 'Wyczyszczenie hasła',
	'passwordreset-desc'               => "Ponowne ustawienie hasła użytkownika – wymaga uprawnienia 'passwordreset'",
	'passwordreset-invalidusername'    => 'Nieprawidłowa nazwa użytkownika',
	'passwordreset-emptyusername'      => 'Pusta nazwa użytkownika',
	'passwordreset-nopassmatch'        => 'Hasła nie są identyczne',
	'passwordreset-badtoken'           => 'Nieprawidłowy żeton edycji',
	'passwordreset-username'           => 'Nazwa użytkownika',
	'passwordreset-newpass'            => 'Nowe hasło',
	'passwordreset-confirmpass'        => 'Potwierdź hasło',
	'passwordreset-submit'             => 'Wyczyść hasło',
	'passwordreset-success'            => 'Hasło zostało wyczyszczone dla użytkownika z ID: $1',
	'passwordreset-disableuser'        => 'Czy wyłączyć konto tego użytkownika?',
	'passwordreset-disableuserexplain' => '(ustawienie błędnego skrótu hasła uniemożliwi użytkownikowi zalogowanie)',
	'passwordreset-disablesuccess'     => 'Konto użytkownika zostało zablokowane (ID użytkownika: $1)',
	'passwordreset-accountdisabled'    => 'Konto zostało zablokowane',
	'disabledusers'                    => 'Zablokowani użytkownicy',
	'disabledusers-summary'            => 'Lista użytkowników, którzy zostali zablokowaniu poprzez użycie PasswordReset.',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 */
$messages['pms'] = array(
	'passwordreset'                 => 'Cambi ëd ciav',
	'passwordreset-invalidusername' => 'Stranòm nen giust',
	'passwordreset-emptyusername'   => 'Stranòm veujd',
	'passwordreset-nopassmatch'     => 'Le doe ciav a son pa mideme',
	'passwordreset-badtoken'        => 'Còdes ëd modìfica nen bon',
	'passwordreset-username'        => 'Stranòm',
	'passwordreset-newpass'         => 'Ciav neuva',
	'passwordreset-confirmpass'     => 'Confermè la ciav',
	'passwordreset-submit'          => 'Cambié la ciav',
	'passwordreset-success'         => "La ciav ëd l'utent $1 a l'é staita cambià",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'passwordreset-invalidusername' => 'ناسم کارن-نوم',
	'passwordreset-emptyusername'   => 'تش کارن-نوم',
	'passwordreset-nopassmatch'     => 'پټنوم مو کټ مټ د يو بل سره سمون نه خوري',
	'passwordreset-username'        => 'کارن-نوم',
	'passwordreset-newpass'         => 'نوی پټنوم',
	'passwordreset-disableuser'     => 'آيا په رښتيا دا کارن-حساب ناچارنول غواړۍ؟',
	'passwordreset-disablesuccess'  => 'کارن-حساب مو ناچارند شوی (د کارونکي پېژند: $1)',
	'passwordreset-accountdisabled' => 'کارن-حساب مو ناچارن شوی',
	'disabledusers'                 => 'ناچارن شوي کارونکي',
);

/** Portuguese (Português)
 * @author Malafaya
 */
$messages['pt'] = array(
	'passwordreset'                 => 'Repor Palavra-Chave',
	'passwordreset-desc'            => "Repõe palavras-chaves de utilizadores do wiki - requer privilégios 'passwordreset'",
	'passwordreset-invalidusername' => 'Nome de Utilizador Inválido',
	'passwordreset-emptyusername'   => 'Nome de Utilizador Vazio',
	'passwordreset-nopassmatch'     => 'Palavras-Chave não coincidem',
	'passwordreset-username'        => 'Nome de utilizador',
	'passwordreset-newpass'         => 'Nova Palavra-Chave',
	'passwordreset-confirmpass'     => 'Confirme Palavra-Chave',
	'passwordreset-submit'          => 'Repor Palavra-Chave',
	'passwordreset-disableuser'     => 'Desactivar Conta de Utilizador?',
	'passwordreset-disablesuccess'  => 'A conta de utilizador foi desactivada (ID do utilizador: $1)',
	'passwordreset-accountdisabled' => 'A conta foi desactivada',
	'disabledusers'                 => 'Utilizadores desactivados',
);

/** Rhaeto-Romance (Rumantsch)
 * @author SPQRobin
 */
$messages['rm'] = array(
	'passwordreset-username' => "Num d'utilisader",
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'passwordreset-username' => 'Nume de utilizator',
);

/** Russian (Русский)
 * @author Illusion
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'passwordreset'                    => 'Сброс пароля',
	'passwordreset-desc'               => "Сбрасывает пароли участников вики, если есть права 'passwordreset'",
	'passwordreset-invalidusername'    => 'Недопустимое имя участника',
	'passwordreset-emptyusername'      => 'Пустое имя участника',
	'passwordreset-nopassmatch'        => 'Пароли не совпадают',
	'passwordreset-badtoken'           => 'Ошибочный признак правки',
	'passwordreset-username'           => 'Имя участника',
	'passwordreset-newpass'            => 'Новый пароль',
	'passwordreset-confirmpass'        => 'Подтверждение пароля',
	'passwordreset-submit'             => 'Сбросить пароль',
	'passwordreset-success'            => 'Пароль сброшен для user_id: $1',
	'passwordreset-disableuser'        => 'Отключить учётную запись?',
	'passwordreset-disableuserexplain' => '(установлен неверный хеш пароля — участник не может зайти)',
	'passwordreset-disablesuccess'     => 'Учётная запись отключена (user_id: $1)',
	'passwordreset-accountdisabled'    => 'Учётная запись отключена',
	'disabledusers'                    => 'Выключенные участники',
	'disabledusers-summary'            => 'Это список участников, которые были «выключены» с помощью PasswordReset.',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'passwordreset'                    => 'Reset hesla',
	'passwordreset-desc'               => 'Umožňuje vygenerovanie nového hesla používateľovi. Vyžaduje oprávnenie „passwordreset“.',
	'passwordreset-invalidusername'    => 'Neplatné používateľské meno',
	'passwordreset-emptyusername'      => 'Nevyplnené používateľské meno',
	'passwordreset-nopassmatch'        => 'Heslá sa nezhodujú',
	'passwordreset-badtoken'           => 'Neplatný upravovací token',
	'passwordreset-username'           => 'Používateľské meno',
	'passwordreset-newpass'            => 'Nové heslo',
	'passwordreset-confirmpass'        => 'Potvrdiť heslo',
	'passwordreset-submit'             => 'Resetovať heslo',
	'passwordreset-success'            => 'Heslo používateľa s user_id $1 bolo resetované',
	'passwordreset-disableuser'        => 'Zablokovať používateľský účet?',
	'passwordreset-disableuserexplain' => '(nastaví neplatnú haš hodnotu hesla - používateľ sa nebude môcť prihlásiť)',
	'passwordreset-disablesuccess'     => 'Používateľský účet bol zablokovaný (user_id: $1)',
	'passwordreset-accountdisabled'    => 'Účet bol zablokovaný',
	'disabledusers'                    => 'Vypnutí používatelia',
	'disabledusers-summary'            => 'Toto je zoznam používateľov, ktorí boli vypnutí prostredníctvom PasswordReset.',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'passwordreset'                    => 'Paaswoud touräächsätte',
	'passwordreset-invalidusername'    => 'Uungultigen Benutsernoome',
	'passwordreset-emptyusername'      => 'Loosen Benutsernoome',
	'passwordreset-nopassmatch'        => 'Paaswoude stimme nit uureen',
	'passwordreset-badtoken'           => 'Ungultigen „Edit Token“',
	'passwordreset-username'           => 'Benutsernoome',
	'passwordreset-newpass'            => 'Näi Paaswoud',
	'passwordreset-confirmpass'        => 'Paaswoud bestäätigje',
	'passwordreset-submit'             => 'Paaswoud touräächsätte',
	'passwordreset-success'            => 'Paaswoud foar Benutser-ID $1 wuude touräächsät',
	'passwordreset-disableuser'        => 'Benutserkonto deaktivierje?',
	'passwordreset-disableuserexplain' => '(sät n uungultich Paaswoud-Hash - Anmäldjen uunmuugelk)',
	'passwordreset-disablesuccess'     => 'Benutserkonto wuude deaktivierd (Benutser-ID: $1)',
	'passwordreset-accountdisabled'    => 'Benutserkonto is deaktivierd',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'passwordreset-username' => 'Landihan',
	'passwordreset-newpass'  => 'Sandi anyar',
);

/** Swedish (Svenska)
 * @author M.M.S.
 */
$messages['sv'] = array(
	'passwordreset'                    => 'Lösenordsåterställning',
	'passwordreset-desc'               => "Återställ användarens lösenord - kräver 'passwordreset'-rättigheter",
	'passwordreset-invalidusername'    => 'Ogiltigt användarnamn',
	'passwordreset-emptyusername'      => 'Tomt användarnamn',
	'passwordreset-nopassmatch'        => 'Lösenordet matchar inte',
	'passwordreset-badtoken'           => 'Ogiltigt redigeringstecken',
	'passwordreset-username'           => 'Användarnamn',
	'passwordreset-newpass'            => 'Nytt lösenord',
	'passwordreset-confirmpass'        => 'Konfirmera lösenord',
	'passwordreset-submit'             => 'Återställ lösenord',
	'passwordreset-success'            => 'Lösenordet för användaren "$1" har återställts.',
	'passwordreset-disableuser'        => 'Avaktivera kontot?',
	'passwordreset-disableuserexplain' => '(sätter ett ogiltigt lösenord - användaren kan inte logga in)',
	'passwordreset-disablesuccess'     => 'Kontot har avaktiverats (användar-ID: $1)',
	'passwordreset-accountdisabled'    => 'Kontot har avaktiverats',
	'disabledusers'                    => 'Invalidisera konton',
	'disabledusers-summary'            => 'Detta är en lista över konton som har blivit invalidiserade via PasswordReset.',
);

/** Tamil (தமிழ்)
 * @author Trengarasu
 */
$messages['ta'] = array(
	'passwordreset-username' => 'பயனர் பெயர்',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'passwordreset-invalidusername' => 'తప్పుడు వాడుకరిపేరు',
	'passwordreset-emptyusername'   => 'ఖాళీ వాడుకరి పేరు',
	'passwordreset-nopassmatch'     => 'సంకేతపదాలు సరిపోలలేదు',
	'passwordreset-username'        => 'వాడుకరిపేరు',
	'passwordreset-newpass'         => 'కొత్త సంకేతపదం',
	'passwordreset-confirmpass'     => 'సంకేతపదాన్ని నిర్ధారించండి',
	'passwordreset-disableuser'     => 'వాడుకరి ఖాతాని అచేతనం చేయాలా?',
	'passwordreset-disablesuccess'  => 'వాడుకరి ఖాతాని అచేతనం చేసారు (user_id: $1)',
	'passwordreset-accountdisabled' => 'ఖాతాని అచేతనం చేసారు',
	'disabledusers'                 => 'అచేతన వాడుకరులు',
);

/** Tajik (Cyrillic) (Тоҷикӣ/tojikī (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'passwordreset-invalidusername' => 'Номи корбарии номӯътабар',
	'passwordreset-username'        => 'Номи корбарӣ',
	'passwordreset-newpass'         => 'Гузарвожаи ҷадид',
	'passwordreset-confirmpass'     => 'Тасдиқи гузарвожа',
);

/** Thai (ไทย)
 * @author Octahedron80
 * @author Passawuth
 */
$messages['th'] = array(
	'passwordreset'                 => 'ล้างรหัสผ่าน',
	'passwordreset-desc'            => 'ล้างรหัสผ่านของผู้ใช้วิกิ - ต้องการสิทธิ "ล้างรหัสผ่าน"',
	'passwordreset-invalidusername' => 'ชื่อผู้ใช้ไม่ถูกต้อง',
	'passwordreset-emptyusername'   => 'ชื่อผู้ใช้ว่างเปล่า',
	'passwordreset-nopassmatch'     => 'รหัสผ่านไม่ตรงกัน',
	'passwordreset-username'        => 'ชื่อผู้ใช้',
	'passwordreset-newpass'         => 'รหัสผ่านใหม่',
	'passwordreset-confirmpass'     => 'ยืนยันรหัสผ่าน',
	'passwordreset-submit'          => 'เปลี่ยนรหัสผ่าน',
	'passwordreset-success'         => 'รหัสผ่านถูกเปลี่ยนใหม่เรียบร้อยแล้วสำหรับชื่อผู้ใช้: $1',
	'passwordreset-disableuser'     => 'ระงับการใช้งานบัญชีผู้ใช้?',
	'passwordreset-disablesuccess'  => 'บัญชีผู้ใช้ได้ถูกระงับแล้ว (ไอดีผู้ใช้: $1)',
	'passwordreset-accountdisabled' => 'บัญชีถูกระงับแล้ว',
	'disabledusers'                 => 'ผู้ใช้ที่ถูกระงับ',
	'disabledusers-summary'         => 'นี่คือรายชื่อของผู้ใช้ที่ถูกระงับโดยการล้างรหัสผ่าน',
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'passwordreset'                    => 'Tái tạo mật khẩu',
	'passwordreset-desc'               => "Tái tạo mật khẩu của người dùng wiki - cần quyền 'passwordreset'",
	'passwordreset-invalidusername'    => 'Tên người dùng không hợp lệ',
	'passwordreset-emptyusername'      => 'Tên thành viên trống',
	'passwordreset-nopassmatch'        => 'Mật khẩu không khớp',
	'passwordreset-badtoken'           => 'Khóa sửa đổi không hợp lệ',
	'passwordreset-username'           => 'Tên người dùng',
	'passwordreset-newpass'            => 'Mật khẩu mới',
	'passwordreset-confirmpass'        => 'Xác nhận mật khẩu',
	'passwordreset-submit'             => 'Tái tạo mật khẩu',
	'passwordreset-success'            => 'Mật khẩu đã được tái tạo cho thành viên có id: $1',
	'passwordreset-disableuser'        => 'Tắt tài khoản thành viên?',
	'passwordreset-disableuserexplain' => '(thiết lập một bảng băm mật khẩu sai - thành viên sẽ không thể đăng nhập)',
	'passwordreset-disablesuccess'     => 'Tài khoản thành viên đã được tắt (mã số thành viên: $1)',
	'passwordreset-accountdisabled'    => 'Tài khoản đã bị tắt',
	'disabledusers'                    => 'Thành viên bị tắt',
	'disabledusers-summary'            => 'Đây là danh sách các thành viên đã bị tắt sử dụng bằng PasswordReset.',
);

/** Volapük (Volapük)
 * @author Malafaya
 */
$messages['vo'] = array(
	'passwordreset-username' => 'Gebananem',
);

/** Yue (粵語) */
$messages['yue'] = array(
	'passwordreset'                 => '密碼重設',
	'passwordreset-invalidusername' => '無效嘅用戶名',
	'passwordreset-emptyusername'   => '空白嘅用戶名',
	'passwordreset-nopassmatch'     => '密碼唔對',
	'passwordreset-badtoken'        => '無效嘅編輯幣',
	'passwordreset-username'        => '用戶名',
	'passwordreset-newpass'         => '新密碼',
	'passwordreset-confirmpass'     => '確認新密碼',
	'passwordreset-submit'          => '重設密碼',
	'passwordreset-success'         => 'User_id: $1 嘅密碼已經重設咗',
);

/** Simplified Chinese (‪中文(简体)‬) */
$messages['zh-hans'] = array(
	'passwordreset'                 => '密码重设',
	'passwordreset-invalidusername' => '无效的用户名',
	'passwordreset-emptyusername'   => '空白的用户名',
	'passwordreset-nopassmatch'     => '密码不匹配',
	'passwordreset-badtoken'        => '无效的编辑币',
	'passwordreset-username'        => '用户名',
	'passwordreset-newpass'         => '新密码',
	'passwordreset-confirmpass'     => '确认新密码',
	'passwordreset-submit'          => '重设密码',
	'passwordreset-success'         => 'User_id: $1 的密码已经重设',
);

/** Traditional Chinese (‪中文(繁體)‬) */
$messages['zh-hant'] = array(
	'passwordreset'                 => '密碼重設',
	'passwordreset-invalidusername' => '無效的用戶名',
	'passwordreset-emptyusername'   => '空白的用戶名',
	'passwordreset-nopassmatch'     => '密碼不匹配',
	'passwordreset-badtoken'        => '無效的編輯幣',
	'passwordreset-username'        => '用戶名',
	'passwordreset-newpass'         => '新密碼',
	'passwordreset-confirmpass'     => '確認新密碼',
	'passwordreset-submit'          => '重設密碼',
	'passwordreset-success'         => 'User_id: $1 的密碼已經重設',
);

