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
	'unsubscribe-desc' => 'Provides a [[Special:Unsubscribe|single e-mail unsubscribe]] point',
	'unsubscribe' => 'Unsubscribe',

	'unsubscribe-badaccess' => 'Sorry, this page cannot be used in this manor.
Please follow the link from your e-mail.',
	'unsubscribe-badtoken' => 'Sorry, there was a problem with the security token.
Please try again.',
	'unsubscribe-bademail' => 'Sorry, there was a problem with the e-mail address.
Please try again.',

	# user info list
	'unsubscribe-already' => 'Already unsubscribed',

	# confirm form
	'unsubscribe-confirm-legend' => 'Confirm unsubscribe',
	'unsubscribe-confirm-text' => 'Unsubscribe all accounts using the e-mail address <code>$1</code>?',
	'unsubscribe-confirm-button' => 'Yes, I\'m sure',

	# working page
	'unsubscribe-working' => 'Unsubscribing {{PLURAL:$1|account|$1 accounts}} for $2',
	'unsubscribe-working-problem' => '* Problem loading user info for: $1',
	'unsubscribe-working-done' => 'The e-mail address has been unsubscribed.',
);

/** Message documentation (Message documentation) */
$messages['qqq'] = array(
	'unsubscribe-desc' => '{{desc}}',
	'unsubscribe' => 'Special page description on [[Special:SpecialPages]] and special page title.',
	'unsubscribe-confirm-text' => 'Parameters:
* $1 is an e-mail address.',
	'unsubscribe-working' => 'Parameters:
* $1 is the number of users for which the given e-mail address is used.
* $1 is an e-mail address.',
	'unsubscribe-working-problem' => 'This is an error message. The "*" character is wiki markup for a list. Parameters:
* $1 is a username.',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'unsubscribe-bademail' => "Jammer, daar was 'n probleem met die e-posadres. 
Probeer asseblief weer.",
	'unsubscribe-confirm-button' => 'Ja, ek is seker',
	'unsubscribe-working-problem' => '* Probleem met laai van gebruikersinligting vir: $1',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'unsubscribe-desc' => 'Овозможува [[Special:Unsubscribe|едно место за отпишување на е-пошта]]',
	'unsubscribe' => 'Отпишување',
	'unsubscribe-badaccess' => 'Нажалост, страницава не може да  се користи вака.
Проследете ја врската од вашата е-пошта.',
	'unsubscribe-badtoken' => 'Нажалост, се појави проблем со безбедносниот жетон.
Обидете се повторно.',
	'unsubscribe-bademail' => 'Нажалост, имаше проблем со е-поштенската адреса.
Обидете се повторно.',
	'unsubscribe-already' => 'Веќе се отпишавте',
	'unsubscribe-confirm-legend' => 'Потврди отпис',
	'unsubscribe-confirm-text' => 'Сакате да ги отпишете сите сметки преку е-поштенската адреса <code>$1</code>?',
	'unsubscribe-confirm-button' => 'Да, сигурно',
	'unsubscribe-working' => '{{PLURAL:$1|Отпишувам сметка|Отпишувам $1 сметки}} за $2',
	'unsubscribe-working-problem' => '* Проблем при вчитувањето на корисничките податоци за: $1',
	'unsubscribe-working-done' => 'Е-поштенската адреса е отпишана.',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'unsubscribe-desc' => 'Biedt een [[Special:Unsubscribe|enkel punt om e-mail af te melden]]',
	'unsubscribe' => 'Uitschrijven',
	'unsubscribe-badaccess' => 'Deze pagina kan niet op deze wijze gebruikt worden.
Volg de verwijzing in uw e-mail.',
	'unsubscribe-badtoken' => 'Er was een probleem met het beveiligingstoken.
Probeer het opnieuw.',
	'unsubscribe-bademail' => 'Er was een probleem met het e-mailadres.
Probeer het opnieuw.',
	'unsubscribe-already' => 'Al uitgeschreven',
	'unsubscribe-confirm-legend' => 'Uitschrijven bevestigen',
	'unsubscribe-confirm-text' => 'Alle gebruikers met het e-mailadres <code>$1</code> uitschrijven?',
	'unsubscribe-confirm-button' => 'Ja, ik weet het zeker',
	'unsubscribe-working' => '{{PLURAL:$1|Gebruiker|$1 gebruikers}} voor $2 aan het uitschrijven',
	'unsubscribe-working-problem' => '* Probleem laden van gebruikersgegevens: $1',
	'unsubscribe-working-done' => 'Het e-mailadres is uitgeschreven.',
);

