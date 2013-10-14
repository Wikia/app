<?php
/**
 * Internationalisation file for Unsubscribe extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author 
 */
$messages['en'] = array(
	'unsubscribe' => 'Unsubscribe',

	'unsubscribe-badaccess' => 'Sorry, this page cannot be used directly. Please follow the link from your e-mail.',
	'unsubscribe-badtoken' => 'Sorry, there was a problem with the security token.',
	'unsubscribe-bademail' => 'Sorry, there was a problem with the e-mail.',
	'unsubscribe-badtime' => 'Sorry, the link has expired. Please use a link that is less then 7 days old.',

	#user info list
	'unsubscribe-nousers' => 'No users found with that e-mail address.',
	#'unsubscribe-already' => 'Already unsubscribed', 
	'unsubscribe-noconfusers' => 'No confirmed users found with that e-mail address.',

	#confirm form
	'unsubscribe-confirm-legend' => 'Confirm',
	'unsubscribe-confirm-text' => 'Unsubscribe all accounts with <code>$1</code>?',
	'unsubscribe-confirm-button' => "Yes, I'm sure",
	
	#working page
	'unsubscribe-working' => 'Unsubscribing $1 {{PLURAL:$1|account|accounts}} for $2',
	'unsubscribe-working-problem' => 'problem loading user info for: $1',
	'unsubscribe-working-done' => 'Complete.',

	#preferences changes
	'unsubscribe-preferences-toggle' => 'Unsubscribe from all emails from Wikia (deselect this to access the options below)',
	'unsubscribe-preferences-notice' => 'Emails have been disabled for your account. Visit the User Profile tab to re-enable them.',
);

/** Message documentation (Message documentation)
 * @author HvW
 * @author Shirayuki
 */
$messages['qqq'] = array(
	'unsubscribe-working-done' => '{{Identical|Complete}}',
	'unsubscribe-preferences-toggle' => 'zugehörige Adresse: http://de.wikia.com/Spezial:Einstellungen',
);

/** Arabic (العربية)
 * @author Achraf94
 */
$messages['ar'] = array(
	'unsubscribe' => 'ألغِ الاشتراك',
	'unsubscribe-badaccess' => 'عذراً، لا يمكن استخدام هذه الصفحة مباشرة. الرجاء اتباع الرابط من البريد الإلكتروني الخاص بك.',
	'unsubscribe-badtoken' => 'آسف، كانت هناك مشكلة مع رمز الأمان.',
	'unsubscribe-bademail' => 'آسف، كانت هناك مشكلة مع البريد الإلكتروني.',
	'unsubscribe-badtime' => 'عذراً، انتهت مدة صلاحية الرابط. يرجى استخدام رابط أقل من 7 أيام.',
	'unsubscribe-nousers' => 'لا يوجد مستخدمون بعنوان البريد الإلكتروني هذا.',
	'unsubscribe-noconfusers' => 'لا يوجد مستخدمون بعنوان البريد الإلكتروني هذا.',
	'unsubscribe-confirm-legend' => 'تأكيد',
	'unsubscribe-confirm-text' => 'إلغاء الاشتراك في جميع الحسابات مع <code>$1</code> ؟',
	'unsubscribe-confirm-button' => 'نعم، أنا متأكد',
	'unsubscribe-working' => 'إلغاء اشتراك  $1   {{PLURAL:$1|حساب|حسابات}} ل $2',
	'unsubscribe-working-problem' => 'مشكلة أثناء تحميل معلومات المستخدم ل: $1',
	'unsubscribe-working-done' => 'انتهيت.',
	'unsubscribe-preferences-toggle' => 'إلغاء الاشتراك من جميع رسائل البريد الإلكتروني من ويكيا (إلغاء تحديد لهذا الوصول في الخيارات أدناه)',
	'unsubscribe-preferences-notice' => 'لقد تم تعطيل رسائل البريد الإلكتروني للحساب الخاص بك. قم بزيارة قسم تفضيلات الصفحة الشخصية للمستخدم لإعادة تمكينها.',
);

/** Azerbaijani (azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'unsubscribe-confirm-legend' => 'Təsdiq et',
);

/** Bulgarian (български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'unsubscribe-confirm-legend' => 'Потвърждаване',
);

/** Breton (brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'unsubscribe' => 'Digoumanantiñ',
	'unsubscribe-confirm-legend' => 'Kadarnaat',
	'unsubscribe-confirm-button' => 'Ya, sur on',
	'unsubscribe-working-done' => 'Graet.',
);

/** Catalan (català)
 * @author Light of Cosmos
 */
$messages['ca'] = array(
	'unsubscribe-nousers' => "No s'han trobat usuaris amb aquesta adreça electrònica.",
	'unsubscribe-noconfusers' => "No s'han trobat usuaris confirmats amb aquesta adreça electrònica.",
	'unsubscribe-confirm-legend' => 'Confirmar',
	'unsubscribe-confirm-button' => "Sí, n'estic segur.",
	'unsubscribe-working-done' => 'Complet.',
);

/** Czech (česky)
 * @author Dontlietome7
 */
$messages['cs'] = array(
	'unsubscribe' => 'Odhlásit',
	'unsubscribe-badaccess' => 'Tuto stránku nelze použít přímo. Prosím klepněte na odkaz v e-mailu.',
	'unsubscribe-badtoken' => 'Je nám líto, ale došlo k potížím se zabezpečením.',
	'unsubscribe-bademail' => 'Je nám líto, ale došlo k potížím s e-mailem.',
	'unsubscribe-badtime' => 'Je nám líto, ale odkaz vypršel. Použijte prosím odkaz, který je čerstvější než 7 dní.',
	'unsubscribe-nousers' => 'Žádní uživatelé s danou e-mailovou adresu nebyli nalezeni.',
	'unsubscribe-noconfusers' => 'Žádní potvrzení uživatelé s danou e-mailovou adresou nebyli nalezeni.',
	'unsubscribe-confirm-legend' => 'Potvrdit',
	'unsubscribe-confirm-text' => 'Odhlásit všechny účty s <code>$1</code>?',
	'unsubscribe-confirm-button' => 'Ano, jsem si jistý',
	'unsubscribe-working' => 'Odhlašování $1 {{PLURAL:$1|účtu|účtů}} pro $2',
	'unsubscribe-working-problem' => 'problém načítání informací uživatele pro: $1',
	'unsubscribe-working-done' => 'Hotovo.',
);

/** German (Deutsch)
 * @author HvW
 * @author LWChris
 */
$messages['de'] = array(
	'unsubscribe' => 'Abonnement beenden',
	'unsubscribe-badaccess' => 'Sorry, diese Seite kann leider nicht direkt verwendet werden. Bitte verwende den Link aus deiner E-Mail.',
	'unsubscribe-badtoken' => 'Sorry, es gab ein Problem mit dem Security Token.',
	'unsubscribe-bademail' => 'Sorry, es gab ein Problem mit der E-Mail.',
	'unsubscribe-badtime' => 'Sorry, der Link ist leider nicht mehr gültig. Bitte benutze einen Link, der weniger als 7 Tage alt ist.',
	'unsubscribe-nousers' => 'Keine Benutzer mit dieser E-Mail-Adresse gefunden.',
	'unsubscribe-noconfusers' => 'Keine bestätigten Benutzer mit dieser E-Mail-Adresse gefunden.',
	'unsubscribe-confirm-legend' => 'Bestätigen',
	'unsubscribe-confirm-text' => 'Alle Konten mit <code>$1</code> abbestellen?',
	'unsubscribe-confirm-button' => 'Ja, ich bin sicher',
	'unsubscribe-working' => 'Trage $1 {{PLURAL:$1|Konto|Konten}} für $2 aus',
	'unsubscribe-working-problem' => 'Problem beim Laden der Benutzer-Informationen für: $1',
	'unsubscribe-working-done' => 'Fertig.',
	'unsubscribe-preferences-toggle' => 'Alle E-Mails von Wikia abbestellen (Haken entfernen, um aus den weiteren Optionen auszuwählen)',
	'unsubscribe-preferences-notice' => 'E-Mails wurden für Ihr Benutzerkonto deaktiviert. Gehen Sie zur Benutzerdaten-Seite, um sie wieder zu aktivieren.',
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 */
$messages['diq'] = array(
	'unsubscribe' => 'Abonin ra bıvıci',
	'unsubscribe-confirm-legend' => 'Testiq ke',
	'unsubscribe-confirm-button' => 'E, Me emel ke',
	'unsubscribe-working-done' => 'Temamyayo',
);

/** Spanish (español)
 * @author Bola
 * @author VegaDark
 * @author Vivaelcelta
 */
$messages['es'] = array(
	'unsubscribe' => 'Darse de baja',
	'unsubscribe-badaccess' => 'Lo sentimos, esta página no puede ser usada directamente. Por favor sigue el enlace desde tu correo electrónico.',
	'unsubscribe-badtoken' => 'Lo sentimos, hubo un problema con la seguridad.',
	'unsubscribe-bademail' => 'Lo sentimos, hubo un problema con el correo electrónico.',
	'unsubscribe-badtime' => 'Lo sentimos, el enlace ha expirado. Por favor, usa un enlace con menos de siete días de antigüedad.',
	'unsubscribe-nousers' => 'No se encontraron usuarios con esa dirección de correo electrónico.',
	'unsubscribe-noconfusers' => 'No se encontraron usuarios confirmados con esa dirección de correo electrónico.',
	'unsubscribe-confirm-legend' => 'Confirmar',
	'unsubscribe-confirm-text' => '¿Dar de baja todas las cuentas con <code>$1</code>?',
	'unsubscribe-confirm-button' => 'Sí, estoy totalmente seguro/a',
	'unsubscribe-working' => 'Dar de baja $1 {{PLURAL:$1|cuenta|cuentas}} por $2',
	'unsubscribe-working-problem' => 'problema cargando información del usuario para: $1',
	'unsubscribe-working-done' => 'Completado.',
	'unsubscribe-preferences-toggle' => 'Darme de baja de todos los correos de Wikia (deselecciona esta opción para acceder a las opciones de abajo)',
	'unsubscribe-preferences-notice' => 'Los correos electrónicos han sido deshabilitados para tu cuenta. Visita la pestaña de tu perfil para reactivarlos.',
);

/** Persian (فارسی)
 * @author Mjbmr
 */
$messages['fa'] = array(
	'unsubscribe-confirm-button' => 'بله، من مطمئن هستم',
	'unsubscribe-working-done' => 'کامل.',
);

/** Finnish (suomi)
 * @author Silvonen
 * @author Tofu II
 */
$messages['fi'] = array(
	'unsubscribe-confirm-legend' => 'Vahvista',
	'unsubscribe-working-done' => 'Valmis.',
);

/** Faroese (føroyskt)
 * @author EileenSanda
 */
$messages['fo'] = array(
	'unsubscribe' => 'Frámelda hald',
	'unsubscribe-badaccess' => 'Tíverri kann henda síðan ikki brúkast beinleiðis. Vinarliga fylg leinkjuni í tínum teldubrævi.',
	'unsubscribe-badtoken' => 'Tíverri var tað ein trupulleiki við trygdarlyklinum.',
	'unsubscribe-bademail' => 'Tíverri var tað ein trupulleiki við t-postinum.',
	'unsubscribe-badtime' => 'Tíverri er leinkjan útgingin. Vinarliga nýt eina leinkju sum er minni enn 7 dagar gomul.',
	'unsubscribe-nousers' => 'Ongir brúkarar vóru funnir við hasi t-post adressuni.',
	'unsubscribe-noconfusers' => 'Ongir váttaðir brúkarar vóru funnir við hasi t-post adressuni.',
	'unsubscribe-confirm-legend' => 'Vátta',
	'unsubscribe-confirm-text' => 'Frámelda hald til allar kontur við <code>$1</code>?',
	'unsubscribe-confirm-button' => 'Ja, eg eri sikkur',
);

/** French (français)
 * @author Wyz
 */
$messages['fr'] = array(
	'unsubscribe' => 'Se désabonner',
	'unsubscribe-badaccess' => 'Désolé, cette page ne peut pas être utilisée directement. Veuillez suivre le lien qui se trouve dans votre courriel.',
	'unsubscribe-badtoken' => 'Désolé, il y a eu un problème avec le jeton de sécurité.',
	'unsubscribe-bademail' => 'Désolé, il y a eu un problème avec le courriel.',
	'unsubscribe-badtime' => 'Désolé, le lien a expiré. Veuillez utiliser un lien qui date de moins de 7 jours.',
	'unsubscribe-nousers' => 'Aucun utilisateur trouvé à cette adresse de messagerie.',
	'unsubscribe-noconfusers' => 'Aucun utilisateur confirmé trouvé à cette adresse de messagerie.',
	'unsubscribe-confirm-legend' => 'Confirmer',
	'unsubscribe-confirm-text' => 'Désabonner tous les comptes avec <code>$1</code> ?',
	'unsubscribe-confirm-button' => 'Oui, j’en suis sûr.',
	'unsubscribe-working' => 'Désabonnement de $1 {{PLURAL:$1|compte|comptes}} pour $2',
	'unsubscribe-working-problem' => 'problème au chargement des informations de l’utilisateur : $1',
	'unsubscribe-working-done' => 'Terminé.',
	'unsubscribe-preferences-toggle' => 'Se désabonner de tous les courriels de Wikia (décochez ceci pour accéder aux options ci-dessous)',
	'unsubscribe-preferences-notice' => 'Les courriels ont été désactivés pour votre compte. Aller sur l’onglet de profil utilisateur pour les réactiver.',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'unsubscribe' => 'Cancelar a subscrición',
	'unsubscribe-badaccess' => 'Sentímolo, esta páxina non se pode empregar directamente. Siga a ligazón que se atopa no seu correo electrónico.',
	'unsubscribe-badtoken' => 'Sentímolo, houbo un problema co pase de seguridade.',
	'unsubscribe-bademail' => 'Sentímolo, houbo un problema co correo electrónico.',
	'unsubscribe-badtime' => 'Sentímolo, a ligazón caducou. Use unha ligazón que teña menos de 7 días de antigüidade.',
	'unsubscribe-nousers' => 'Non atopamos ningún usuario con ese enderezo de correo electrónico.',
	'unsubscribe-noconfusers' => 'Non atopamos ningún usuario confirmado con ese enderezo de correo electrónico.',
	'unsubscribe-confirm-legend' => 'Confirmar',
	'unsubscribe-confirm-text' => 'Quere cancelar a subscrición de todas as contas con <code>$1</code>?',
	'unsubscribe-confirm-button' => 'Si, estou seguro',
	'unsubscribe-working' => 'Cancelando a subscrición {{PLURAL:$1|dunha conta|de $1 contas}} para $2',
	'unsubscribe-working-problem' => 'problema ao cargar a información do usuario: $1',
	'unsubscribe-working-done' => 'Completo.',
	'unsubscribe-preferences-toggle' => 'Cancelar a subscrición de todos os correos electrónicos de Wikia (desmarque isto para acceder ás opcións embaixo)',
	'unsubscribe-preferences-notice' => 'Os correos electrónicos desactiváronse para a súa conta. Visite a lapela de perfil de usuario para reactivalos.',
);

/** Hungarian (magyar)
 * @author Dani
 * @author Dj
 * @author TK-999
 */
$messages['hu'] = array(
	'unsubscribe' => 'Leiratkozás',
	'unsubscribe-badaccess' => 'Sajnáljuk, ez a lap nem érhető el közvetlenül. Kérlek, használd az e-mailben küldött hivatkozást.',
	'unsubscribe-badtoken' => 'Sajnáljuk, de probléma történt a biztonsági tokennel.',
	'unsubscribe-bademail' => 'Sajnáljuk, de probléma volt az e-maillel.',
	'unsubscribe-badtime' => 'Sajnáljuk, de a hivatkozás lejárt. Kérlek, hogy hét napnál frissebb hivatkozást használj.',
	'unsubscribe-nousers' => 'Nem található a megadott e-mail címmel rendelkező felhasználó',
	'unsubscribe-noconfusers' => 'Nem található a megadott e-mail címmel rendelkező megerősített felhasználó.',
	'unsubscribe-confirm-legend' => 'Megerősítés',
	'unsubscribe-confirm-button' => 'Igen, biztos vagyok benne',
	'unsubscribe-working' => '$1 felhasználó leiratkoztatása $2-nek',
	'unsubscribe-working-problem' => 'hiba történt $1 felhasználói adatainak betöltése közben',
	'unsubscribe-working-done' => 'Kész.',
	'unsubscribe-preferences-toggle' => 'Leiratkozás az összes Wikia e-mailról (töröld a lenti beállítások eléréséhez)',
	'unsubscribe-preferences-notice' => 'A felhasználói fiókodnak szánt e-mailek le lettek tiltva. Bekapcsolásukhoz látogass el a "Felhasználói profil" fülre.',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'unsubscribe' => 'Cancellar subscription',
	'unsubscribe-badaccess' => 'Nos regretta que iste pagina non pote esser usate directemente.
Per favor seque le ligamine ab tu e-mail.',
	'unsubscribe-badtoken' => 'Occurreva un problema con le indicio de securitate.',
	'unsubscribe-bademail' => 'Occurreva un problema con le e-mail.',
	'unsubscribe-badtime' => 'Le ligamine ha expirate. Per favor usa un ligamine que ha minus de 7 dies de etate.',
	'unsubscribe-nousers' => 'Nulle usator trovate con iste adresse de e-mail.',
	'unsubscribe-noconfusers' => 'Nulle usator confirmate trovate con iste adresse de e-mail.',
	'unsubscribe-confirm-legend' => 'Confirmar',
	'unsubscribe-confirm-text' => 'Cancellar subscription de tote le contos con <code>$1</code>?',
	'unsubscribe-confirm-button' => 'Si, io es secur',
	'unsubscribe-working' => 'Cancella subscription de $1 {{PLURAL:$1|conto|contos}} pro $2',
	'unsubscribe-working-problem' => 'problema de cargamento del information de usator pro: $1',
	'unsubscribe-working-done' => 'Complete.',
	'unsubscribe-preferences-toggle' => 'Cancellar subscription a tote le e-mail de Wikia (dismarca isto pro acceder al optiones hic infra)',
	'unsubscribe-preferences-notice' => 'Le invio de e-mail ha essite disactivate pro tu conto. Visita le scheda "Profilo de usator" pro reactivar lo.',
);

/** Italian (italiano)
 * @author Minerva Titani
 */
$messages['it'] = array(
	'unsubscribe-preferences-toggle' => 'Disattiva la ricezione di tutte le mail da Wikia (deseleziona per accedere alle opzioni sottostanti)',
	'unsubscribe-preferences-notice' => 'Le email sono state disattivate per il tuo account. Accedi alla scheda "Profilo" per riattivarle.',
);

/** Japanese (日本語)
 * @author Shirayuki
 */
$messages['ja'] = array(
	'unsubscribe-confirm-legend' => '確認',
	'unsubscribe-working-done' => '完了しました。',
);

/** Korean (한국어)
 * @author Cafeinlove
 * @author 아라
 */
$messages['ko'] = array(
	'unsubscribe-confirm-legend' => '확인',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'unsubscribe' => 'Nimmieh Aboneere',
	'unsubscribe-badaccess' => 'Leider kam_mer heh di eSigg nit tiräk bruche. Nemm dä Lengk uß dä <i lang="en">e-mail</i> aan Desch.',
	'unsubscribe-badtoken' => 'Leider johv_et e Probleem met Dingem Schlößel.',
	'unsubscribe-bademail' => 'Leider johv_et e Probleem met dä <i lang="en">e-mail</i>.',
	'unsubscribe-badtime' => 'Leider deiht et dä Lengk nit mih. Nemm ene Lengk uß dä <i lang="en">e-mail</i> aan Desch, dä winnijer wi en Woch ald_es.',
	'unsubscribe-nousers' => 'Mer han keine Metmaacher met dä <i lang="en">e-mail</i> Adräß jefonge.',
	'unsubscribe-noconfusers' => 'Mer han keine beschtääteschte Metmaacher met dä <i lang="en">e-mail</i> Adräß jefonge.',
	'unsubscribe-confirm-legend' => 'Beshtähtejje',
	'unsubscribe-confirm-text' => 'Donn alle Abonnomangs met <code>$1</code> ußdraare?',
	'unsubscribe-confirm-button' => 'Joh, esch ben mer sescher, esch well dat han.',
	'unsubscribe-working' => 'Mer sen de $1 {{PLURAL:$1|Abonnomang|Abonnomangs}} för $2 am ußdraare&nbsp;…',
	'unsubscribe-working-problem' => 'Mer han e Probleem beim Laade vun däm Metmaacher $1 singe Daate,',
	'unsubscribe-working-done' => 'Fäädesch.',
	'unsubscribe-preferences-toggle' => 'Donn Desch vun alle <i lang="en">e-mails</i> vun Wikia afmälde (Donn dat heh nit ußwähle, öm aan di ander Müjjeleschkeite onge draan ze kumme)',
	'unsubscribe-preferences-notice' => 'För Desch sin <i lang="en">e-mails</i> afjeschalldt. Jangk op Ding Enschtällonge, döh kanns De se widder aanschallde.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'unsubscribe-confirm-legend' => 'Confirméieren',
	'unsubscribe-confirm-button' => 'Jo, ech si sécher',
	'unsubscribe-working-done' => 'Fäerdeg.',
);

/** Latvian (latviešu)
 * @author Admresdeserv.
 */
$messages['lv'] = array(
	'unsubscribe' => 'Atcelt abonēšanu',
	'unsubscribe-bademail' => 'Atvainojiet, radās problēma ar e-pastu.',
	'unsubscribe-confirm-legend' => 'Apstiprināt',
	'unsubscribe-confirm-text' => 'Atrakstīt visus kontus ar <code>$1</code> ?',
	'unsubscribe-confirm-button' => 'Jā, es esmu pārliecināts.',
	'unsubscribe-working-done' => 'Pabeigts!',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'unsubscribe' => 'Отпиши',
	'unsubscribe-badaccess' => 'Нажалост, оваа страница не може да се користи директно. Стиснете на врската наведена во пораката што ви ја испративме по е-пошта.',
	'unsubscribe-badtoken' => 'Нажалост, се појави проблем со безбедносната шифра.',
	'unsubscribe-bademail' => 'Нажалост, се појави проблем со е-поштата.',
	'unsubscribe-badtime' => 'Нажалост, врската истече. Врската не треба да е постара од 7 дена.',
	'unsubscribe-nousers' => 'Не пронајдов корисници со таа е-поштенска адреса.',
	'unsubscribe-noconfusers' => 'Не пронајдов потврдени корисници со таа е-поштенска адреса.',
	'unsubscribe-confirm-legend' => 'Потврди',
	'unsubscribe-confirm-text' => 'Да ве отпишам од сите сметки на <code>$1</code>?',
	'unsubscribe-confirm-button' => 'Да,  сигурен сум',
	'unsubscribe-working' => 'Отпис од $1 {{PLURAL:$1|сметка|сметки}} за $2',
	'unsubscribe-working-problem' => 'проблем при вчитувањето на корисничките податоци за: $1',
	'unsubscribe-working-done' => 'Готово.',
	'unsubscribe-preferences-toggle' => 'Откажи претплата на е-пошта од Викија (отшиклирајте го ова за да дојдете до можностите подолу)',
	'unsubscribe-preferences-notice' => 'Пораките по е-пошта се оневозможени за вашата сметка. Појдете на јазичето „Кориснички профил“ за да ги овозможите повторно.',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'unsubscribe' => 'Berhenti melanggan',
	'unsubscribe-badaccess' => 'Maaf, laman ini tidak boleh digunakan secara terus. Sila ikuti pautan dari e-mel anda.',
	'unsubscribe-badtoken' => 'Maaf, token keselamatan ini ada masalah.',
	'unsubscribe-bademail' => 'Maaf, e-mel ini ada masalah.',
	'unsubscribe-badtime' => 'Maaf, pautan telah luput. Sila gunakan pautan yang kurang daripada 7 hari lamanya.',
	'unsubscribe-nousers' => 'Pengguna yang punya alamat e-mel itu tidak dijumpai.',
	'unsubscribe-noconfusers' => 'Pengguna yang punya alamat e-mel itu tidak dapat dipastikan.',
	'unsubscribe-confirm-legend' => 'Sahkan',
	'unsubscribe-confirm-text' => 'Berhenti melanggan semua akaun dengan <code>$1</code>?',
	'unsubscribe-confirm-button' => 'Ya, saya pasti',
	'unsubscribe-working' => 'Berhenti melanggan $1 akaun untuk $2',
	'unsubscribe-working-problem' => 'masalah memuatkan info pengguna: $1',
	'unsubscribe-working-done' => 'Selesai.',
	'unsubscribe-preferences-toggle' => 'Berhenti melanggan semua e-mel dari Wikia (nyahpilih ini untuk mengakses pilihan di bawah)',
	'unsubscribe-preferences-notice' => 'E-mel telah dimatikan untuk akaun anda. Pergi ke tab Profil Pengguna untuk menghidupkannya semula.',
);

/** Burmese (မြန်မာဘာသာ)
 * @author Erikoo
 */
$messages['my'] = array(
	'unsubscribe-confirm-legend' => 'အတည်ပြု',
);

/** Norwegian Bokmål (norsk bokmål)
 * @author Audun
 */
$messages['nb'] = array(
	'unsubscribe' => 'Avbryt abonnement',
	'unsubscribe-badaccess' => 'Beklager, denne siden kan ikke brukes direkte. Vennligst følg lenken fra e-posten din.',
	'unsubscribe-badtoken' => 'Beklager, det oppstod et problem med sikkerhetskoden.',
	'unsubscribe-bademail' => 'Beklager, det oppstod et problem med e-posten.',
	'unsubscribe-badtime' => 'Beklager, lenken har utgått. Vennligst bruk en lenke som er mindre enn syv dager gammel.',
	'unsubscribe-nousers' => 'Ingen brukere funnet med denne e-postadressen.',
	'unsubscribe-noconfusers' => 'Ingen bekreftede brukere funnet med den e-postadressen.',
	'unsubscribe-confirm-legend' => 'Bekreft',
	'unsubscribe-confirm-text' => 'Avslutt abonnement for alle kontoer med <code>$1</code>?',
	'unsubscribe-confirm-button' => 'Ja, jeg er sikker',
	'unsubscribe-working' => 'Avbryter abonnement for $1 {{PLURAL:$1|konto|kontoer}} for $2',
	'unsubscribe-working-problem' => 'problem med å laste brukerinformasjon for: $1',
	'unsubscribe-working-done' => 'Fullført.',
	'unsubscribe-preferences-toggle' => 'Avslutt abonnementet på all e-post fra Wikia (sjekk av denne for å få tilgang til alternativene under)',
	'unsubscribe-preferences-notice' => 'E-post har blitt deaktivert for kontoen din. Besøk Brukerprofil-fanen for å aktivere dem igjen.',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'unsubscribe' => 'Uitschrijven',
	'unsubscribe-badaccess' => 'Deze pagina kan niet direct benaderd worden. Volg de koppeling in uw e-mail.',
	'unsubscribe-badtoken' => 'Er is een probleem met het beveiligingstoken.',
	'unsubscribe-bademail' => 'Er is een probleem met het e-mailbericht.',
	'unsubscribe-badtime' => 'De koppeling is verlopen. Gebruik een koppeling die maximaal zeven dagen oud is.',
	'unsubscribe-nousers' => 'Er zijn geen gebruikers met dat e-mailadres.',
	'unsubscribe-noconfusers' => 'Er zijn geen bevestigde gebruikers met dat e-mailadres.',
	'unsubscribe-confirm-legend' => 'Bevestigen',
	'unsubscribe-confirm-text' => 'Alle gebruikers met <code>$1</code> uitschrijven?',
	'unsubscribe-confirm-button' => 'Ja, ik weet het zeker',
	'unsubscribe-working' => 'Bezig met het uitschrijven van {{PLURAL:$1|een gebruiker|$1 gebruikers}} voor $2',
	'unsubscribe-working-problem' => 'probleem bij het laden van de gebruikersgegevens voor: $1',
	'unsubscribe-working-done' => 'Voltooid.',
	'unsubscribe-preferences-toggle' => 'Afmelden voor alle e-mails van Wikia (vink dit uit dit voor toegang tot de instellingen hieronder)',
	'unsubscribe-preferences-notice' => 'E-mails zijn uitgeschakeld voor uw gebruiker. Ga naar het gebruikersprofiel om e-mailberichten opnieuw in te schakelen.',
);

/** Nederlands (informeel)‎ (Nederlands (informeel)‎)
 * @author Siebrand
 */
$messages['nl-informal'] = array(
	'unsubscribe-badaccess' => 'Deze pagina kan niet direct benaderd worden. Volg de koppeling in je e-mail.',
);

/** Occitan (occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'unsubscribe' => 'Se desabonar',
	'unsubscribe-badaccess' => 'O planhèm, aquesta pagina pòt pas èsser utilizada dirèctament. Seguissètz lo ligam que se tròba dins vòstre corrièr electronic.',
	'unsubscribe-badtoken' => 'O planhèm, i a agut un problèma amb lo geton de seguretat.',
	'unsubscribe-bademail' => 'O planhèm, i a agut un problèma amb lo corrièr electronic.',
	'unsubscribe-badtime' => 'O planhèm, lo ligam a expirat. Utilizatz un ligam que data de mens de 7 jorns.',
	'unsubscribe-nousers' => "Cap d'utilizaire pas trobat a aquela adreça de messatjariá.",
	'unsubscribe-noconfusers' => "Cap d'utilizaire confirmat pas trobat a aquela adreça de messatjariá.",
	'unsubscribe-confirm-legend' => 'Confirmar',
	'unsubscribe-confirm-text' => 'Desabonar totes los comptes amb <code>$1</code> ?',
	'unsubscribe-confirm-button' => 'Òc, ne soi segur(a).',
	'unsubscribe-working' => 'Desabonament de $1 {{PLURAL:$1|compte|comptes}} per $2',
	'unsubscribe-working-problem' => 'problèma al cargament de las informacions de l’utilizaire : $1',
	'unsubscribe-working-done' => 'Acabat.',
	'unsubscribe-preferences-toggle' => 'Se desabonar de totes los corrièrs electronics de Wikia (desmarcatz aquò per accedir a las opcions çaijós)',
	'unsubscribe-preferences-notice' => "Los corrièrs electronics son estats desactivats per vòstre compte. Anar sus l’onglet de perfil d'utilizaire per los reactivar.",
);

/** Polish (polski)
 * @author BeginaFelicysym
 * @author Sovq
 */
$messages['pl'] = array(
	'unsubscribe' => 'Zrezygnuj z subskrypcji',
	'unsubscribe-badaccess' => 'Niestety, nie można wejść bezpośrednio na stronę. Prosimy skorzystać z linku z wiadomości e-mail.',
	'unsubscribe-badtoken' => 'Przepraszamy, wystąpił problem z tokenem zabezpieczeń.',
	'unsubscribe-bademail' => 'Przepraszamy, wystąpił problem z e-mailem.',
	'unsubscribe-badtime' => 'Niestety, link stracił ważność. Użyj łącza utworzonego w ciągu ostatnich 7 dni.',
	'unsubscribe-nousers' => 'Nie znaleziono użytkownika z takim adresem e-mail.',
	'unsubscribe-noconfusers' => 'Nie znaleziono zweryfikowanego użytkownika z takim adresem e-mail.',
	'unsubscribe-confirm-legend' => 'Potwierdź',
	'unsubscribe-confirm-text' => 'Wycofanie subskrypcji wszystkich kont z <code>$1</code> ?',
	'unsubscribe-confirm-button' => 'Tak, potwierdzam',
	'unsubscribe-working' => 'Anulowanie subskrypcji $1 {{PLURAL:$1|konta|kont|kont}} dla $2',
	'unsubscribe-working-problem' => 'problem podczas wczytywania informacji o użytkowniku:$1',
	'unsubscribe-working-done' => 'Ukończono.',
	'unsubscribe-preferences-toggle' => 'Zakończyć subskrypcję wszystkich kont e-mail z Wikii (odznacz tę opcję, aby uzyskać dostęp do opcji poniżej)',
	'unsubscribe-preferences-notice' => 'Wiadomości e-mail na to konto zostały wyłączone. Odwiedź kartę profilu użytkownika, aby włączyć je ponownie.',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'unsubscribe' => "Scancelé l'anscrission",
	'unsubscribe-badaccess' => "An dëspias, costa pàgina a peul pa esse dovrà diretament. Për piasì, ch'a-j vada dapress a la liura da soa pòsta eletrònica.",
	'unsubscribe-badtoken' => 'An dëspias, a-i é staje un problema con ël geton ëd sicurëssa.',
	'unsubscribe-bademail' => 'An dëspias, a-i é staje un problema con la pòsta eletrònica.',
	'unsubscribe-badtime' => "An dëspias, la liura a l'é scadùa. Për piasì, ch'a deuvra na liura che a l'abia men che 7 di.",
	'unsubscribe-nousers' => 'Gnun utent trovà con costa adrëssa ëd pòsta eletrònica.',
	'unsubscribe-noconfusers' => 'Gnun utent confirmà trovà con costa adrëssa ëd pòsta eletrònica.',
	'unsubscribe-confirm-legend' => 'Conferma',
	'unsubscribe-confirm-text' => "Scancelé l'anscrission ëd tùit ij cont con <code>$1</code>?",
	'unsubscribe-confirm-button' => 'É, i son sigur',
	'unsubscribe-working' => "Scancelassion ëd l'anscrission ëd $1 {{PLURAL:$1|cont}} për $2",
	'unsubscribe-working-problem' => "problema cariand j'anformassion ëd l'utent për: $1",
	'unsubscribe-working-done' => 'Completa.',
	'unsubscribe-preferences-toggle' => "Scancelé l'anscrission da tùit ij mëssagi da Wikia (gavé la selession ambelessì për andé a j'opsion sì-sota)",
	'unsubscribe-preferences-notice' => "Ij mëssagi ëd pòsta eletrònica a son ëstàit disabilità për sò cont. Ch'a vìsita la scheda dël Profil Utent për abiliteje torna.",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'unsubscribe-confirm-legend' => 'تاييد',
	'unsubscribe-confirm-button' => 'هو، زه ډاډه يم',
	'unsubscribe-working-done' => 'بشپړ.',
);

/** Portuguese (português)
 * @author Hamilton Abreu
 * @author Luckas
 */
$messages['pt'] = array(
	'unsubscribe' => 'Anular subscrição',
	'unsubscribe-badaccess' => 'Esta página não pode ser usada diretamente. Siga o link no seu correio eletrónico, por favor.',
	'unsubscribe-badtoken' => 'Desculpe, ocorreu um problema com a chave de segurança.',
	'unsubscribe-bademail' => 'Desculpe, ocorreu um problema com o correio electrónico.',
	'unsubscribe-badtime' => 'Desculpe, o link expirou. Use um link criado há menos de 7 dias, por favor.',
	'unsubscribe-nousers' => 'Não foram encontrados utilizadores com esse correio electrónico.',
	'unsubscribe-noconfusers' => 'Não foram encontrados utilizadores confirmados com esse correio electrónico.',
	'unsubscribe-confirm-legend' => 'Confirmar',
	'unsubscribe-confirm-text' => 'Anular a subscrição de todas as contas com <code>$1</code>?',
	'unsubscribe-confirm-button' => 'Sim, tenho a certeza',
	'unsubscribe-working' => 'A anular a subscrição de $1 {{PLURAL:$1|conta|contas}} para $2',
	'unsubscribe-working-problem' => 'problema ao carregar a informação do utilizador: $1',
	'unsubscribe-working-done' => 'Terminado.',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Aristóbulo
 * @author JM Pessanha
 */
$messages['pt-br'] = array(
	'unsubscribe' => 'Cancelar inscrição',
	'unsubscribe-badaccess' => 'Desculpe, esta página não pode ser usada diretamente. Por favor, siga o link de seu e-mail.',
	'unsubscribe-badtoken' => 'Desculpe, ocorreu um problema com o token de segurança.',
	'unsubscribe-bademail' => 'Desculpe, ocorreu um problema com o e-mail.',
	'unsubscribe-badtime' => 'Desculpe, o link expirou. Por favor, use um link com menos de 7 dias.',
	'unsubscribe-nousers' => 'Nenhum usuário encontrado com esse endereço de e-mail.',
	'unsubscribe-noconfusers' => 'Nenhum usuário confirmado foi encontrado com esse endereço de e-mail.',
	'unsubscribe-confirm-legend' => 'Confirmar',
	'unsubscribe-confirm-text' => 'Cancelar todas as contas com <code>$1</code>?',
	'unsubscribe-confirm-button' => 'Sim, eu tenho certeza',
	'unsubscribe-working' => 'Cancelamento de $1 {{PLURAL:$ 1|account|accounts}} para $2',
	'unsubscribe-working-problem' => 'problema de carregamento de informação de usuário: $1',
	'unsubscribe-working-done' => 'Completo.',
	'unsubscribe-preferences-toggle' => 'Cancelar a inscrição de todos os e-mails da Wikia (desmarque esta para acessar as opções abaixo)',
	'unsubscribe-preferences-notice' => 'E-mails foram desativados para sua conta. Visite a aba Perfil de Usuário para reativá-los.',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'unsubscribe' => 'Scangillate',
	'unsubscribe-badaccess' => "Ne despiace, sta pàgene non ge pò essere ausate direttamende. Pe piacere segue 'u collegamende da l'email toje.",
	'unsubscribe-badtoken' => "Ne despiace, ste 'nu probbleme cu 'u gettone de securezze.",
	'unsubscribe-bademail' => "Ne despiace, ste 'nu probbleme cu l'email.",
	'unsubscribe-badtime' => "Ne despiace, 'u collegamende ha scadute. Pe piacere ause 'u collegamende ca tène mene de 7 sciurne.",
	'unsubscribe-nousers' => 'Nisciune utende acchiate cu quidde indirizze email.',
	'unsubscribe-noconfusers' => 'Nisciune utende confermatarije acchiate cu quidde indirizze email.',
	'unsubscribe-confirm-legend' => 'Conferme',
	'unsubscribe-confirm-text' => 'Scangelle tutte le cunde cu <code>$1</code>?',
	'unsubscribe-confirm-button' => 'Sìne, so secure',
	'unsubscribe-working' => 'Stoche a scangelle $1 {{PLURAL:$1|cunde}} pe $2',
	'unsubscribe-working-problem' => "probbleme carecanne le 'mbormaziune utende pe: $1",
	'unsubscribe-working-done' => 'Comblete.',
	'unsubscribe-preferences-toggle' => 'Scangille da tutte le email da Uicchia (puè no scacchià quiste scenne a le opziune aqquà sotte)',
	'unsubscribe-preferences-notice' => "Le email onne state disabbilitate pu cunde tune. Visite 'a schede Profile de l'Utende pe abbilitarle arrete.",
);

/** Russian (русский)
 * @author DCamer
 * @author Kuzura
 */
$messages['ru'] = array(
	'unsubscribe' => 'Отписаться',
	'unsubscribe-badaccess' => 'К сожалению, эта страница не может быть использована напрямую. Пожалуйста, перейдите по ссылке из вашей электронной почты.',
	'unsubscribe-badtoken' => 'К сожалению, у нас проблема с маркером безопасности.',
	'unsubscribe-bademail' => 'К сожалению, у нас проблема с электронной почты.',
	'unsubscribe-badtime' => 'К сожалению, ссылка истекла. Пожалуйста, используйте ссылку, менее 7 дневной давности.',
	'unsubscribe-nousers' => 'Не найдено пользователей с этим адресом электронной почты.',
	'unsubscribe-noconfusers' => 'Нет найдено подтвержденных пользователей с этим адресом электронной почты.',
	'unsubscribe-confirm-legend' => 'Подтвердить',
	'unsubscribe-confirm-text' => 'Отписать все учетные записи с <code>$1</code>?',
	'unsubscribe-confirm-button' => 'Да, я уверен',
	'unsubscribe-working' => 'Отписка $1 {{PLURAL:$1|учётной записи|учётных записей}} для $2',
	'unsubscribe-working-problem' => 'проблема с загрузкой информации о пользователе: $1',
	'unsubscribe-working-done' => 'Готово.',
	'unsubscribe-preferences-toggle' => 'Отписаться от всех писем от Викия (снимите это для доступа к параметрам ниже)',
	'unsubscribe-preferences-notice' => 'Получение писем было отключено для вашей учётной записи. Посетите вкладку Личные данные, чтобы снова включить это.',
);

/** Sinhala (සිංහල)
 * @author පසිඳු කාවින්ද
 */
$messages['si'] = array(
	'unsubscribe' => 'සාමාජිකත්වයෙන් ඉවත්වන්න',
);

/** Serbian (Cyrillic script) (српски (ћирилица)‎)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'unsubscribe' => 'Одјави ме',
	'unsubscribe-nousers' => 'Корисник с том е-адресом није пронађен.',
	'unsubscribe-confirm-legend' => 'Потврди',
	'unsubscribe-confirm-button' => 'Да, сигуран/-на сам',
	'unsubscribe-working-done' => 'Завршено.',
);

/** Swedish (svenska)
 * @author Tobulos1
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'unsubscribe' => 'Avsluta prenumeration',
	'unsubscribe-badaccess' => 'Tyvärr kan inte denna sida användas direkt. Vänligen följ länken i din e-post.',
	'unsubscribe-badtoken' => 'Tyvärr, det var ett problem med säkerhetsnyckel.',
	'unsubscribe-bademail' => 'Tyvärr, det var ett problem med e-posten.',
	'unsubscribe-badtime' => 'Tyvärr har länken löpt ut. Använd en länk som är mindre än 7 dagar gammal.',
	'unsubscribe-nousers' => 'Inga användare hittades med den e-postadress.',
	'unsubscribe-noconfusers' => 'Inga bekräftade användare hittade med den e-postadress.',
	'unsubscribe-confirm-legend' => 'Bekräfta',
	'unsubscribe-confirm-text' => 'Avsluta prenumerationer för alla konton med <code>$1</code>?',
	'unsubscribe-confirm-button' => 'Ja, jag är säker',
	'unsubscribe-working' => 'Avslutar prenumerationen för $1 {{PLURAL:$1|konto|konton}} för $2',
	'unsubscribe-working-problem' => 'problem med att läsa användarinformationen för: $1',
	'unsubscribe-working-done' => 'Slutfört.',
	'unsubscribe-preferences-toggle' => 'Avsluta prenumerationen från alla e-postmeddelanden från Wikia (avmarkera detta för att komma åt alternativen nedan)',
	'unsubscribe-preferences-notice' => 'E-post har inaktiverats för ditt konto. Besök fliken Användarprofil för att återaktivera dem.',
);

/** Telugu (తెలుగు)
 * @author Ravichandra
 * @author Veeven
 */
$messages['te'] = array(
	'unsubscribe' => 'చందావిరమించు',
	'unsubscribe-confirm-legend' => 'ధృవీకరించు',
	'unsubscribe-confirm-button' => 'అవును, నిజమే',
	'unsubscribe-working-done' => 'పూర్తి',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'unsubscribe' => 'Pahintuin na ang pagtanggap ng sipi',
	'unsubscribe-badaccess' => 'Paumanhin, ang pahinang ito ay hindi maaaring gamitin nang tuwiran. Mangyaring sundin ang kawing magmula sa e-liham mo.',
	'unsubscribe-badtoken' => 'Paumanhin, nagkaroon ng isang suliranin sa kahalip na pangkaligtasan.',
	'unsubscribe-bademail' => 'Paumanhin, nagkaroon ng isang suliranin sa e-liham.',
	'unsubscribe-badtime' => 'Paumanhin, wala nang bisa ang kawing. Mangyaring gamitin ang isang kawing na mas mababa kaysa 7 mga araw na ang gulang.',
	'unsubscribe-nousers' => 'Walang natagpuang mga tagagamit na may ganyang tirahan ng e-liham.',
	'unsubscribe-noconfusers' => 'Walang natagpuang natiyak nang mga tagagamit na may ganyang tirahan ng e-liham.',
	'unsubscribe-confirm-legend' => 'Tiyakin',
	'unsubscribe-confirm-text' => 'Huwag nang patanggapin ng sipi ang lahat ng mga akawnt na may <code>$1</code>?',
	'unsubscribe-confirm-button' => 'Oo, nakatitiyak ako',
	'unsubscribe-working' => 'Hindi na patatanggapin ng sipi ang $1 {{PLURAL:$1|akawnt|mga akawnt}} para sa $2',
	'unsubscribe-working-problem' => 'may suliranin sa pagkakarga ng kabatiran ng tagagamit para sa: $1',
	'unsubscribe-working-done' => 'Buo na.',
	'unsubscribe-preferences-toggle' => 'Huwag nang magpasipi mula sa lahat ng mga e-liham mula sa Wikia (huwag na itong piliin upang mapuntahan ang mga mapagpipiliang nasa ibaba)',
	'unsubscribe-preferences-notice' => 'Hindi na pinagagana ang mga e-liham para sa akawnt mo. Dalawin ang laylayan ng Balangkas-Katangian ng Tagagamit upang muling paganahin ang mga ito.',
);

/** Ukrainian (українська)
 * @author Andriykopanytsia
 * @author Steve.rusyn
 * @author SteveR
 * @author Тест
 */
$messages['uk'] = array(
	'unsubscribe' => 'Відписатись',
	'unsubscribe-badaccess' => 'На жаль, ця сторінка не може бути використана безпосередньо. Будь ласка, перейдіть за посиланням з вашої електронної пошти.',
	'unsubscribe-badtoken' => 'На жаль, у нас проблема з маркером безпеки.',
	'unsubscribe-bademail' => 'Вибачте, виникла проблема з електронною поштою.',
	'unsubscribe-badtime' => 'На жаль, термін дії посилання минув. Будь ласка, використовуйте посилання, створене менше, ніж 7 днів тому.',
	'unsubscribe-nousers' => 'Не знайдено користувачів з цією адресою електронної пошти.',
	'unsubscribe-noconfusers' => 'Не знайдено підтверджених користувачів з цією адресою електронної пошти.',
	'unsubscribe-confirm-legend' => 'Підтвердити',
	'unsubscribe-confirm-text' => 'Скасувати підписку усіх облікових записів з <code>$1</code> ?',
	'unsubscribe-confirm-button' => 'Так, я впевнений',
	'unsubscribe-working' => 'Скасовується підписка $1 {{PLURAL:$1|облікового запису|облікових записів}} для $2',
	'unsubscribe-working-problem' => 'проблема при завантаженні інформації про користувача: $1',
	'unsubscribe-working-done' => 'Готово.',
	'unsubscribe-preferences-toggle' => 'Зняти підписку на всі листи з Вікія (відмініть це для доступу нижче до параметрів)',
	'unsubscribe-preferences-notice' => 'Електронні листи вимкнені для вашого облікового запису. Перейдіть на вкладку профіль користувача, щоб знову увімкнути їх.',
);

/** Vietnamese (Tiếng Việt)
 * @author Xiao Qiao
 */
$messages['vi'] = array(
	'unsubscribe' => 'Hủy đăng ký',
	'unsubscribe-badaccess' => 'Xin lỗi, trang này không thể sử dụng trực tiếp. Xin vui lòng theo các liên kết từ thư điện tử của bạn.',
	'unsubscribe-badtoken' => 'Xin lỗi, đã có một vấn đề với mã thông báo bảo mật.',
	'unsubscribe-bademail' => 'Xin lỗi, đã có một vấn đề với thư điện tử.',
	'unsubscribe-badtime' => 'Xin lỗi, liên kết đã hết hạn. Xin vui lòng sử dụng một liên kết ít hơn 7 ngày.',
	'unsubscribe-nousers' => 'Không có người dùng nào được tìm thấy với địa chỉ e-mail đó.',
	'unsubscribe-noconfusers' => 'Không có người dùng được tìm thấy là đã xác nhận thấy với địa chỉ e-mail đó.',
	'unsubscribe-confirm-legend' => 'Xác nhận',
	'unsubscribe-confirm-text' => 'Hủy đăng ký tất cả tài khoản với <code>$1</code>?',
	'unsubscribe-confirm-button' => 'Vâng, tôi chắc',
	'unsubscribe-working' => 'Hủy đăng ký $1 {{PLURAL:$1|tài khoản|tài khoản}} cho $2',
	'unsubscribe-working-problem' => 'vấn đề kết nối thông tin người sử dụng cho: $1',
	'unsubscribe-working-done' => 'Hoàn thành.',
	'unsubscribe-preferences-toggle' => 'Không nhật tất cả các email từ Wikia (bỏ chọn này để truy cập vào các tùy chọn dưới đây)',
	'unsubscribe-preferences-notice' => 'Thư điện tử đã bị vô hiệu hóa cho tài khoản của bạn. Truy cập vào thẻ Hồ sơ người dùng để kích hoạt lại chúng.',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Hydra
 * @author Hzy980512
 */
$messages['zh-hans'] = array(
	'unsubscribe' => '取消订阅',
	'unsubscribe-badaccess' => '抱歉，此页不能直接应用。请跟随您的电邮的链接。',
	'unsubscribe-badtoken' => '抱歉，安全令牌出现问题。',
	'unsubscribe-bademail' => '抱歉，电邮出现问题。',
	'unsubscribe-badtime' => '抱歉，链接已过期。请利用一个未满7天的链接。',
	'unsubscribe-nousers' => '找不到利用那电邮地址的用户。',
	'unsubscribe-noconfusers' => '找不到利用那电邮地址的已确认用户。',
	'unsubscribe-confirm-legend' => '确定',
	'unsubscribe-confirm-text' => '要利用<code>$1</code>取消订阅所有用户吗？',
	'unsubscribe-confirm-button' => '是，我很确定',
	'unsubscribe-working-done' => '完成。',
	'unsubscribe-preferences-toggle' => '不订阅Wikia的所有邮件（取消选定这个方块才能进入下列选项）',
	'unsubscribe-preferences-notice' => '您的账户已禁用电邮。请访问用户配置文件选项卡以从新启用。',
);
