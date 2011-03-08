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
);

/** Breton (Brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'unsubscribe' => 'Digoumanantiñ',
	'unsubscribe-confirm-legend' => 'Kadarnaat',
	'unsubscribe-confirm-button' => 'Ya, sur on',
	'unsubscribe-working-done' => 'Graet.',
);

/** Czech (Česky)
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
);

/** Spanish (Español)
 * @author Bola
 */
$messages['es'] = array(
	'unsubscribe' => 'Darse de baja',
	'unsubscribe-badaccess' => 'Lo sentimos, esta página no puede ser usada directamente. Por favor sigue el enlace desde tu e-mail.',
	'unsubscribe-badtoken' => 'Lo sentimos, hubo un problema con la seguridad.',
	'unsubscribe-bademail' => 'Lo sentimos, hubo un problema con el e-mail.',
	'unsubscribe-badtime' => 'Lo sentimos, el enlace ha expirado. Por favor, usa un enlace con menos de siete días de antigüedad.',
	'unsubscribe-nousers' => 'No se encontraron usuarios con esa dirección de e-mail.',
	'unsubscribe-noconfusers' => 'No se encontraron usuarios confirmados con esa dirección de e-mail.',
	'unsubscribe-confirm-legend' => 'Confirmar',
	'unsubscribe-confirm-text' => '¿Dar de baja todas las cuentas con <code>$1</code>?',
	'unsubscribe-confirm-button' => 'Sí, estoy totalmente seguro/a',
	'unsubscribe-working' => 'Dar de baja $1 {{PLURAL:$1|cuenta|cuentas}} por $2',
	'unsubscribe-working-problem' => 'problema cargando información del usuario para: $1',
	'unsubscribe-working-done' => 'Completado.',
);

/** Finnish (Suomi)
 * @author Tofu II
 */
$messages['fi'] = array(
	'unsubscribe-working-done' => 'Valmis.',
);

/** Interlingua (Interlingua)
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
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'unsubscribe-confirm-legend' => 'Confirméieren',
	'unsubscribe-confirm-button' => 'Jo, ech si sécher',
	'unsubscribe-working-done' => 'Fäerdeg.',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'unsubscribe' => 'Отпиши',
	'unsubscribe-badaccess' => 'Нажалост, оваа страница не може да се користи директно. Стиснете на врската наведена во пораката што ви ја испративме по е-пошта.',
	'unsubscribe-badtoken' => 'Нажалост, се појави проблем со безбедносниот жетон.',
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
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'unsubscribe' => 'Uitschrijven',
	'unsubscribe-badaccess' => 'Deze pagina kan niet direct benaderd worden. Volg alstublieft de verwijzing in uw e-mail.',
	'unsubscribe-badtoken' => 'Er is een probleem met het beveiligingstoken.',
	'unsubscribe-bademail' => 'Er is een probleem met het e-mailbericht.',
	'unsubscribe-badtime' => 'De verwijzing is verlopen. Gebruik een verwijzing die maximaal zeven dagen oud is.',
	'unsubscribe-nousers' => 'Er zijn geen gebruikers met dat e-mailadres.',
	'unsubscribe-noconfusers' => 'Er zijn geen bevestigde gebruikers met dat e-mailadres.',
	'unsubscribe-confirm-legend' => 'Bevestigen',
	'unsubscribe-confirm-text' => 'Alle gebruikers met <code>$1</code> uitschrijven?',
	'unsubscribe-confirm-button' => 'Ja, ik weet het zeker',
	'unsubscribe-working' => 'Bezig met het uitschrijven van {{PLURAL:$1|een gebruiker|$1 gebruikers}} voor $2',
	'unsubscribe-working-problem' => 'probleem bij het laden van de gebruikersgegevens voor: $1',
	'unsubscribe-working-done' => 'Afgerond.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 */
$messages['no'] = array(
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
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'unsubscribe' => 'Anular subscrição',
	'unsubscribe-badaccess' => 'Esta página não pode ser usada directamente. Siga o link no seu correio electrónico, por favor.',
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

/** Brazilian Portuguese (Português do Brasil)
 * @author Aristóbulo
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
);

/** Serbian Cyrillic ekavian (‪Српски (ћирилица)‬)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'unsubscribe' => 'Одјави ме',
	'unsubscribe-nousers' => 'Корисник с том е-адресом није пронађен.',
	'unsubscribe-confirm-legend' => 'Потврди',
	'unsubscribe-confirm-button' => 'Да, сигуран/-на сам',
	'unsubscribe-working-done' => 'Завршено.',
);

/** Swedish (Svenska)
 * @author Tobulos1
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
	'unsubscribe-working' => 'Avslutar prenumerationen $1 {{PLURAL:$1|konto|konton}} för $2',
	'unsubscribe-working-problem' => 'problem med att läsa användarinformationen för: $1',
	'unsubscribe-working-done' => 'Slutfört.',
);

/** Ukrainian (Українська)
 * @author Тест
 */
$messages['uk'] = array(
	'unsubscribe-confirm-button' => 'Так, я впевнений',
);

