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

/** Ukrainian (Українська)
 * @author Тест
 */
$messages['uk'] = array(
	'unsubscribe-confirm-button' => 'Так, я впевнений',
);

