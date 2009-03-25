<?php
/**
 * Internationalization file for EditAccount extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 */
$messages['en'] = array(
	'editaccount' => 'Edit Account',
	'editaccount-title' => 'Special:EditAccount',
	'editaccount-frame-manage' => 'Edit an acccount',
	'editaccount-frame-usage' => 'Note',
	'editaccount-usage' => "User data is cached separately for each wiki. When you reset a password or e-mail, cache will be busted for this wiki only. Please direct the user to this wiki to log in with a newly set password to avoid cache issues.",
	'editaccount-label-select' => 'Select a user account',
	'editaccount-submit-account' => 'Manage Account',
	'editaccount-frame-account' => 'Editing user account: $1',
	'editaccount-frame-close' => 'Disable user account: $1',
	'editaccount-label-email' => 'Set new e-mail address',
	'editaccount-label-pass' => 'Set new password',
	'editaccount-label-realname' => 'Set new real name',
	'editaccount-submit-email' => 'Save E-Mail',
	'editaccount-submit-pass' => 'Save Password',
	'editaccount-submit-realname' => 'Save Real Name',
	'editaccount-submit-close' => 'Close Account',
	'editaccount-usage-close' => 'You can also disable a user account by scrambling its password and removing the e-mail address. Note that this data is lost and will not be recoverable.',
	'editaccount-warning-close' => '<b>Caution!</b> You are about to permanently disable the account of user <b>$1</b>. This cannot be reverted. Are you sure that is what you want to do?',
	'editaccount-status' => 'Status message',
	'editaccount-success-email' => 'Successfully changed e-mail for account $1 to $2.',
	'editaccount-success-pass' => 'Successfully changed password for account $1.',
	'editaccount-success-realname' => 'Successfully changed real name for account $1.',
	'editaccount-success-close' => 'Successfully disabled account $1.',
	'editaccount-error-email' => 'E-mail was not changed. Try again or contact the Tech Team.',
	'editaccount-error-pass' => 'Password was not changed. Try again or contact the Tech Team.',
	'editaccount-error-realname' => 'Real name was not changed. Try again or contact the Tech Team.',
	'editaccount-error-close' => 'A problem occured when closing account. Try again or contact the Tech Team.',
	'editaccount-invalid-email' => '"$1" is not a valid e-mail address!',
	'editaccount-nouser' => 'Account "$1" does not exist!',
	# logging
	'editaccount-log' => 'User accounts log',
	'editaccount-log-header' => 'This page lists changes made to user preferences by Wikia Staff.',
	'editaccount-log-entry-email' => 'changed e-mail for user $2',
	'editaccount-log-entry-pass' => 'changed password for user $2',
	'editaccount-log-entry-realname' => 'changed real name for user $2',
	'editaccount-log-entry-close' => 'disabled account $2',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">This account has been disabled.</div>',
	// For Special:ListGroupRights
	'right-editaccount' => "Edit other users' preferences",
);

/** Finnish (Suomi)
 * @author Jack Phoenix <jack@countervandalism.net>
 */
$messages['fi'] = array(
	'editaccount' => 'Muokkaa käyttäjätunnuksia',
	'editaccount-frame-manage' => 'Muokkaa käyttäjätunnusta',
	'editaccount-frame-usage' => 'Huomioi',
	'editaccount-usage' => 'Käyttäjäkohtaisen tiedot ovat talletettuna välimuistiin erikseen jokaista wikiä kohden. Kun asetat uuden salasanan tai sähköpostiosoitteen, välimuistiin tallennetut tiedot poistetaan vain tämän wikin kohdalla. Ole hyvä ja ohjaa käyttäjä kirjautumaan sisään tätä wikiä käyttäen vältääksesi ongelmia välimuistin kanssa.',
	'editaccount-label-select' => 'Valitse käyttäjätunnus',
	'editaccount-submit-account' => 'Hallinnoi tunnusta',
	'editaccount-frame-account' => 'Muokataan käyttäjätunnusta: $1',
	'editaccount-frame-close' => 'Sulje käyttäjätunnus: $1',
	'editaccount-label-email' => 'Aseta uusi sähköpostiosoite',
	'editaccount-label-pass' => 'Aseta uusi salasana',
	'editaccount-submit-email' => 'Tallenna sähköpostiosoite',
	'editaccount-submit-pass' => 'Tallenna salasana',
	'editaccount-submit-close' => 'Sulje tunnus',
	'editaccount-usage-close' => 'Voit myös sulkea käyttäjätunnuksen sekoittamalla sen salasanan ja poistamalla sen sähköpostiosoitteen. Huomioi, että nämä tiedot katoavat eikä niitä voi palauttaa.',
	'editaccount-status' => 'Tilaviesti',
	'editaccount-success-email' => 'Tunnuksen $1 sähköpostiosoite vaihdettiin onnistuneesti osoitteeseen $2.',
	'editaccount-success-pass' => 'Tunnuksen $1 salasana vaihdettiin onnistuneesti.',
	'editaccount-success-close' => 'Tunnus $1 suljettiin onnistuneesti.',
	'editaccount-error-email' => 'Sähköpostiosoitetta ei vaihdettu. Yritä uudelleen tai ota yhteyttä tekniseen tiimiin.',
	'editaccount-error-pass' => 'Salasanaa ei vaihdettu. Yritä uudelleen tai ota yhteyttä tekniseen tiimiin.',
	'editaccount-error-close' => 'Tunnusta suljettaessa tapahtui virhe. Yritä uudelleen tai ota yhteyttä tekniseen tiimiin.',
	'editaccount-invalid-email' => '"$1" ei ole kelvollinen sähköpostiosoite!',
	'editaccount-nouser' => 'Tunnusta nimeltä "$1" ei ole olemassa!',
	'editaccount-log' => 'Käyttäjätunnusloki',
	'editaccount-log-header' => 'Tämä sivu listaa Wikian henkilökunnan käyttäjäkohtaisiin asetuksiin tekemät muutokset.',
	'editaccount-log-entry-email' => 'muutti käyttäjän $2 sähköpostiosoitetta',
	'editaccount-log-entry-pass' => 'muutti käyttäjän $2 salasanaa',
	'editaccount-log-entry-close' => 'sulki tunnuksen $2',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Tämä tunnus on suljettu.</div>',
	'right-editaccount' => 'Muuttaa toisten käyttäjien käyttäjäkohtaisia asetuksia',
);
