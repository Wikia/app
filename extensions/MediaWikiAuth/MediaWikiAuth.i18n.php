<?php
/**
 * Internationalization file for MediaWikiAuth extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Laurence "GreenReaper" Parry
 */
$messages['en'] = array(
	'mwa-autocreate-blocked' => 'Automatic account creation is blocked for this IP on the remote wiki.',
	'mwa-error-unknown' => 'Unknown error when logging in to the remote wiki.',
	'mwa-error-wrong-token' => 'A login token submission error occurred. Please retry, and contact an administrator if this fails.',
	'mwa-must-be-imported' => 'Your account must be imported.
Please <a target="_new" href="http://www.wikia.com/wiki/Special:UserLogin">reset your password at Wikia</a>, then use the new password here.<br /><br />
<b>Note:</b> You must use the password Wikia emails you to login there. You will then be asked to set a new password, which can be used here.',
	'mwa-resetpass' => 'You cannot login with a temporary password. Please use it on the remote wiki to create a new permanent password.',
	'mwa-wait' => 'Please wait $1 seconds before trying again.',
);

/** Finnish (Suomi)
 * @author Jack Phoenix
 */
$messages['fi'] = array(
	'mwa-autocreate-blocked' => 'Tunnuksen automaattinen luominen tälle IP:lle on estetty etäwikissä.',
	'mwa-error-unknown' => 'Tuntematon virhe kirjautuessa sisään etäwikiin.',
	'mwa-must-be-imported' => 'Tunnuksesi täytyy tuoda. <a target="_new" href="http://www.wikia.com/wiki/Special:UserLogin">Aseta itsellesi uusi salasana Wikiassa</a>, ja sen jälkeen käytä uutta salasanaa täällä.<br /><br />
<b>Huomioi:</b> Sinun tulee käyttää salasanaa, jonka Wikia lähettää sinulle sähköpostitse kirjautuessasi sisään sinne. Sen jälkeen sinua pyydetään asettamaan uusi salasana, jota voi käyttää täällä.',
	'mwa-resetpass' => 'Et voi kirjautua sisään tilapäisellä salasanalla. Ole hyvä ja käytä sitä etäwikissä luodaksesi pysyvän salasanan.',
	'mwa-wait' => 'Ole hyvä ja odota $1 sekuntia ennen kuin yrität uudelleen.',
);

/** Dutch (Nederlands)
 * @author Jedimca0
 */
$messages['nl'] = array(
	'mwa-autocreate-blocked' => 'Automatische account creatie is voor dit IP adres geblokkeerd',
	'mwa-error-unknown' => 'Er heeft zich een onbekende fout voorgedaan tijdens het inloggen.',
	'mwa-error-wrong-token' => 'Er heeft zich een login token error voorgedaan. Probeer het alstublieft opnieuw, en neem contact op met een administrator als het dan nog niet lukt.',
	'mwa-must-be-imported' => 'Uw account moet geïmporteerd worden.
<a target="_new" href="http://www.wikia.com/wiki/Special:UserLogin">Reset uw wachtwoord op Wikia</a> en gebruik het dan hier.<br /><br />
<b>Note:</b> U moet het wachtwoord gebruiken dat Wikia u per email gestuurd heeft, daarna moet u uw wachtwoord wijzigen.',
	'mwa-resetpass' => 'U kunt niet inloggen met een tijdelijk wachtwoord. Gebruik het om de "remote wiki" om een nieuw, permanent, wachtwoord in te stellen.',
	'mwa-wait' => 'Wacht alstublieft $1 seconden en probeer het dan opnieuw.',
);