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
	'editaccount' => 'Edit account',
	'editaccount-desc' => 'Enables staff members to manage user account information',
	'editaccount-title' => 'Special:EditAccount',
	'editaccount-frame-manage' => 'Edit an acccount',
	'editaccount-frame-usage' => 'Note',
	'editaccount-usage' => "User data is cached separately for each wiki. When you reset a password or e-mail, cache will be busted for this wiki only. Please direct the user to this wiki to log in with a newly set password to avoid cache issues.",
	'editaccount-label-select' => 'Select a user account',
	'editaccount-submit-account' => 'Manage account',
	'editaccount-frame-account' => 'Editing user account: $1',
	'editaccount-frame-close' => 'Disable user account: $1',
	'editaccount-label-email' => 'Set new e-mail address',
	'editaccount-label-pass' => 'Set new password',
	'editaccount-label-realname' => 'Set new real name',
	'editaccount-submit-email' => 'Save e-mail address',
	'editaccount-submit-pass' => 'Save password',
	'editaccount-submit-realname' => 'Save real name',
	'editaccount-submit-close' => 'Close account',
	'editaccount-usage-close' => 'You can also disable a user account by scrambling its password and removing the e-mail address. Note that this data is lost and will not be recoverable.',
	'editaccount-warning-close' => '<b>Caution!</b> You are about to permanently disable the account of user <b>$1</b>. This cannot be reverted. Are you sure that is what you want to do?',
	'editaccount-status' => 'Status message',
	'editaccount-success-email' => 'Successfully changed e-mail address for account $1 to $2.',
	'editaccount-success-email-blank' => 'Successfully removed e-mail address for account $1.',
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

/** Message documentation (Message documentation)
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'editaccount-desc' => '{{desc}}',
	'right-editaccount' => '{{doc-right|editaccount}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'editaccount' => 'Wysig gebruiker',
	'editaccount-frame-manage' => "Wysig 'n rekening",
	'editaccount-frame-usage' => 'Let op',
	'editaccount-label-select' => "Kies 'n gebruiker",
	'editaccount-submit-account' => 'Bestuur gebruiker',
	'editaccount-frame-close' => 'Deaktiveer gebruiker: $1',
	'editaccount-label-email' => 'Stel nuwe e-posadres',
	'editaccount-label-pass' => 'Stel nuwe wagwoord',
	'editaccount-label-realname' => 'Stel nuwe regte naam',
	'editaccount-submit-email' => 'Stoor E-pos',
	'editaccount-submit-pass' => 'Stoor wagwoord',
	'editaccount-submit-realname' => 'Stoor regte naam',
	'editaccount-submit-close' => 'Sluit rekening',
	'editaccount-status' => 'Statusboodskap',
	'editaccount-invalid-email' => '"$1" is nie \'n geldige e-posadres nie!',
	'editaccount-nouser' => 'Die gebruiker "$1" bestaan nie.',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'editaccount-submit-email' => 'Захаваць адрас электроннай пошты',
	'editaccount-submit-pass' => 'Захаваць пароль',
	'editaccount-submit-realname' => 'Захаваць сапраўднае імя',
);

/** Bihari (भोजपुरी)
 * @author Ganesh
 */
$messages['bh'] = array(
	'editaccount' => 'खाता सम्पादन',
	'editaccount-title' => 'विशेष: खाता सम्पादन',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Gwenn-Ael
 * @author Y-M D
 */
$messages['br'] = array(
	'editaccount' => 'Kemmañ ar gont',
	'editaccount-desc' => "Talvezout a ra d'ar skipailh merañ d'ober war-dro titouroù ar c'hontoù implijer",
	'editaccount-title' => 'Special:EditAccount',
	'editaccount-frame-manage' => 'Kemmañ ur gont',
	'editaccount-frame-usage' => 'Notenn',
	'editaccount-usage' => "Kuzhet e vez roadennoù an implijerien a-unanoù evit pep wiki. Ma teraouekait ar ger-tremen pe ar chomlec'h postel en-dro ne vo nullet ar grubuilh nemet evit ar wiki-mañ. Kasit, mar plij, an implijer war-du ar wiki-se evit ma c'hallo kevreañ ouzh e c'her-tremen nevez evit ma ne vefe ket a gudennoù krubuilh.",
	'editaccount-label-select' => 'Dibab ur gont implijer',
	'editaccount-submit-account' => 'Merañ ar gont',
	'editaccount-frame-account' => 'Kemmoù ar gont implijer : $1',
	'editaccount-frame-close' => 'Diweredekaat ar gont implijer : $1',
	'editaccount-label-email' => "Termeniñ ur chomlec'h postel nevez",
	'editaccount-label-pass' => 'Termeniñ ur ger-tremen nevez',
	'editaccount-label-realname' => 'Termeniñ un anv klok nevez',
	'editaccount-submit-email' => 'Enrollañ ar postel',
	'editaccount-submit-pass' => 'Enrollañ ar ger-tremen',
	'editaccount-submit-realname' => 'Enrollañ an anv klok',
	'editaccount-submit-close' => 'Serriñ ar gont',
	'editaccount-usage-close' => "Gallout a rit ivez diweredekaat ur gont implijer en ur rinegiñ he ger-tremen hag en ur implijout he chomlec'h postel. Diwallit ! Kollet e vo ar roadennoù ha ne c'hallor ket adtapout anezho.",
	'editaccount-warning-close' => "<b>Diwallit !</b> Emaoc'h war-nes diweredekaat ar gont implijer <b>$1</b> da vat. Ne c'hallor ket en dizober. Ha c'hoant ho peus d'en ober ?",
	'editaccount-status' => 'Kemenadenn statud',
	'editaccount-success-email' => 'Kemmet eo bet ar postel evit ar gont $1 da $2.',
	'editaccount-success-email-blank' => "Dilamet mat eo bet chomlec'h postel ar gont $1.",
	'editaccount-success-pass' => 'Kemmet eo bet ger tremen ar gont $1.',
	'editaccount-success-realname' => 'Kemmet eo bet anv gwir ar gont $1.',
	'editaccount-success-close' => 'Diweredekaet eo bet ar gont $1.',
	'editaccount-error-email' => "N'eo ket bet kemmet ar chomlec'h postel. Klaskit adarre pe kit a darempred gant ar skipailh teknikel.",
	'editaccount-error-pass' => "N'eo ket bet kemmet ar ger tremen. Klaskit adarre pe kit a darempred gant ar skipailh teknikel.",
	'editaccount-error-realname' => "N'eo ket bet kemmet an anv gwir. Klaskit adarre pe kit a darempred gant ar skipailh teknikel.",
	'editaccount-error-close' => 'Ur gudenn a zo bet pa vezer o serriñ ar gont. Klaskit adarre pe kit a darempred gant ar skipailh teknikel.',
	'editaccount-invalid-email' => 'N\'eo ket "$1" ur chomlec\'h postel reizh !',
	'editaccount-nouser' => 'N\'eus ket eus ar gont "$1" !',
	'editaccount-log' => 'Marilh ar gontoù implijer',
	'editaccount-log-header' => "Rollet e vez er pajenn-mañ ar c'hemmoù graet gant staff Wikia er penndibaboù implijer.",
	'editaccount-log-entry-email' => "en deus kemmet chmolec'h postel an implijer $2",
	'editaccount-log-entry-pass' => 'en deus kemmet ger tremen ar gont $2',
	'editaccount-log-entry-realname' => 'en deus kemmet anv gwir ar gont $2',
	'editaccount-log-entry-close' => 'en deus diweredekaet ar gont $2',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Diweredekaet eo bet ar gont.</div>',
	'right-editaccount' => 'Kemmañ penndibaboù implijerien all',
);

/** Catalan (Català)
 * @author Davidpar
 */
$messages['ca'] = array(
	'editaccount-log-entry-pass' => "contrasenya canviada de l'usuari $2",
	'editaccount-log-entry-realname' => "canviat el nom real de l'usuari $2",
	'editaccount-log-entry-close' => 'compte desactivat $2',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Aquest compte ha estat desactivat.</div>',
	'right-editaccount' => 'Edita les preferències dels altres usuaris',
);

/** German (Deutsch)
 * @author LWChris
 * @author The Evil IP address
 */
$messages['de'] = array(
	'editaccount' => 'Konto bearbeiten',
	'editaccount-desc' => 'Benutzerkonten-Verwaltung durch Mitarbeiter',
	'editaccount-title' => 'Special:EditAccount',
	'editaccount-frame-manage' => 'Ein Benutzerkonto bearbeiten',
	'editaccount-frame-usage' => 'Notiz',
	'editaccount-usage' => 'User-Daten werden separat für jedes Wiki gespeichert. Wenn du ein Passwort oder E-Mail-Adresse zurücksetzt, wird der Speicher nur für dieses Wiki gelöscht werden. Bitte schicke den Benutzer zu diesem Wiki zum Einzuloggen mit neuem Passwort, um Cache-Probleme zu vermeiden.',
	'editaccount-label-select' => 'Wähle ein Benutzerkonto',
	'editaccount-submit-account' => 'Konto verwalten',
	'editaccount-frame-account' => 'Bearbeiten von Benutzerkonto: $1',
	'editaccount-frame-close' => 'Deaktivieren von Benutzerkonto: $1',
	'editaccount-label-email' => 'Neue E-Mail-Adresse setzen',
	'editaccount-label-pass' => 'Neues Passwort setzen',
	'editaccount-label-realname' => 'Neuen tatsächlichen Namen setzen',
	'editaccount-submit-email' => 'E-Mail-Adresse speichern',
	'editaccount-submit-pass' => 'Passwort speichern',
	'editaccount-submit-realname' => 'Tatsächlichen Namen speichern',
	'editaccount-submit-close' => 'Konto schließen',
	'editaccount-usage-close' => 'Du kannst ein Konto auch deaktivieren indem du das Passwort zerwürfelst und die E-Mail-Adresse löschst. Beachte, dass diese Daten verloren und nicht wiederherstellbar sind.',
	'editaccount-warning-close' => '<b>Achtung!</b> Du bist dabei, das Konto von Benutzer <b>$1</b> dauerhaft zu deaktivieren. Dies kann nicht rückgängig gemacht werden. Bist du sicher, dass du das tun möchtest?',
	'editaccount-status' => 'Statusmeldung',
	'editaccount-success-email' => 'E-Mail-Adresse für das Konto $1 erfolgreich in $2 geändert.',
	'editaccount-success-email-blank' => 'E-Mail-Adresse für Konto $1 erfolgreich entfernt.',
	'editaccount-success-pass' => 'Passwort für Konto $1 erfolgreich geändert.',
	'editaccount-success-realname' => 'Tatsächlicher name für Konto $1 erfolgreich geändert.',
	'editaccount-success-close' => 'Konto $1 erfolgreich deaktiviert.',
	'editaccount-error-email' => 'Die E-Mail-Adresse wurde nicht geändert. Versuche es erneut oder kontaktiere das Tech Team.',
	'editaccount-error-pass' => 'Das Passwort wurde nicht geändert. Versuche es erneut oder kontaktiere das Tech Team.',
	'editaccount-error-realname' => 'Der tatsächliche Name wurde nicht geändert. Versuche es erneut oder kontaktiere das Tech Team.',
	'editaccount-error-close' => 'Beim Schließen des Kontos trat ein Fehler auf. Versuche es erneut oder kontaktiere das Tech Team.',
	'editaccount-invalid-email' => '„$1“ ist keine gültige E-Mail-Adresse!',
	'editaccount-nouser' => 'Konto „$1“ existiert nicht!',
	'editaccount-log' => 'Benutzerkonten-Logbuch',
	'editaccount-log-header' => 'Diese Seite listet Änderungen von Benutzereinstellungen durch das Wikia Personal.',
	'editaccount-log-entry-email' => 'änderte die E-Mail-Adresse von Benutzer $2',
	'editaccount-log-entry-pass' => 'änderte das Passwort von Benutzer $2',
	'editaccount-log-entry-realname' => 'änderte den tatsächlichen Namen von Benutzer $2',
	'editaccount-log-entry-close' => 'deaktivierte das Konto $2',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Dieses Benutzerkonto wurde deaktiviert.</div>',
	'right-editaccount' => 'Bearbeite andere Benutzereinstellungen',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author LWChris
 */
$messages['de-formal'] = array(
	'editaccount-usage' => 'User-Daten werden separat für jedes Wiki gespeichert. Wenn Sie ein Passwort oder E-Mail-Adresse zurücksetzen, wird der Speicher nur für dieses Wiki gelöscht werden. Bitte schicken Sie den Benutzer zu diesem Wiki zum Einzuloggen mit neuem Passwort, um Cache-Probleme zu vermeiden.',
	'editaccount-label-select' => 'Wählen Sie ein Benutzerkonto',
	'editaccount-usage-close' => 'Sie können ein Konto auch deaktivieren indem Sie das Passwort zerwürfeln und die E-Mail-Adresse löschen. Beachten Sie, dass diese Daten verloren und nicht wiederherstellbar sind.',
	'editaccount-warning-close' => '<b>Achtung!</b> Sie sind dabei, das Konto von Benutzer <b>$1</b> dauerhaft zu deaktivieren. Dies kann nicht rückgängig gemacht werden. Sind Sie sicher, dass Sie das tun möchten?',
	'editaccount-error-email' => 'Die E-Mail-Adresse wurde nicht geändert. Versuchen Sie es erneut oder kontaktieren Sie das Tech Team.',
	'editaccount-error-pass' => 'Das Passwort wurde nicht geändert. Versuchen Sie es erneut oder kontaktieren Sie das Tech Team.',
	'editaccount-error-realname' => 'Der tatsächliche Name wurde nicht geändert. Versuchen Sie es erneut oder kontaktieren Sie das Tech Team.',
	'editaccount-error-close' => 'Beim Schließen des Kontos trat ein Fehler auf. Versuchen Sie es erneut oder kontaktieren Sie das Tech Team.',
	'right-editaccount' => 'Bearbeiten Sie andere Benutzereinstellungen',
);

/** Greek (Ελληνικά)
 * @author Crazymadlover
 * @author Dada
 */
$messages['el'] = array(
	'editaccount-submit-pass' => 'Αποθήκευση κωδικού',
	'editaccount-log-entry-pass' => 'Έγινε αλλαγή στον κωδικό πρόσβασης του χρήστη $2',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Pertile
 * @author Translationista
 */
$messages['es'] = array(
	'editaccount' => 'Editar Cuenta',
	'editaccount-desc' => 'Permite a los miembros del staff gestionar información de cuenta de usuario',
	'editaccount-title' => 'Especial:EditAccount',
	'editaccount-frame-manage' => 'Editar una cuenta',
	'editaccount-frame-usage' => 'Nota',
	'editaccount-usage' => 'Los datos de usuario están en una memoria intermedia separada para cada wiki. Cuando se reinicie una contraseña o cuenta de correo electrónico, la memoria intermedia será únicamente anulada para esta wiki. Por favor dirija el usuario a esta wiki para acceder al sistema con una nueva contraseña y evitar problemas de memoria intermedia.',
	'editaccount-label-select' => 'Seleccionar una cuenta de usuario',
	'editaccount-submit-account' => 'Administrar Cuenta',
	'editaccount-frame-account' => 'Editando cuenta de usuario: $1',
	'editaccount-frame-close' => 'Desactivar la cuenta de usuario: $1',
	'editaccount-label-email' => 'Fijar una nueva dirección de correo electrónico',
	'editaccount-label-pass' => 'Fijar una nueva contraseña',
	'editaccount-label-realname' => 'Fijar un nuevo nombre real',
	'editaccount-submit-email' => 'Guardar correo electrónico',
	'editaccount-submit-pass' => 'Guardar contraseña',
	'editaccount-submit-realname' => 'Guardar nombre verdadero',
	'editaccount-submit-close' => 'Cerrar cuenta',
	'editaccount-usage-close' => 'También puedes desactivar una cuenta de usuario desordenando su contraseña y eliminando la dirección de correo electrónico. Ten en cuenta que estos datos se perderán y no se podrán recuperar.',
	'editaccount-warning-close' => '<b>Atención:</b> Estás a punto de desactivar permanentemente la cuenta del usuario <b>$1</b>. Esta acción es irreversible. ¿Seguro que eso es lo que deseas?',
	'editaccount-status' => 'Mensaje de estado',
	'editaccount-success-email' => 'Se ha cambiado correctamente el correo electrónico de la cuenta de $1 a $2.',
	'editaccount-success-email-blank' => 'Se ha eliminado con éxito el correo electrónico de la cuenta de $1.',
	'editaccount-success-pass' => 'Se ha cambiado correctamente la contraseña de cuenta de $1.',
	'editaccount-success-realname' => 'Se ha cambiado correctamente el nombre real de la cuenta de $1.',
	'editaccount-success-close' => 'Se ha inhabilitado correctamente la cuenta $1.',
	'editaccount-error-email' => 'El correo electrónico no se ha cambiado. Inténtalo de nuevo o contacta con el Equipo Técnico.',
	'editaccount-error-pass' => 'La clave ha sido cambiada. Inténtalo de nuevo o contacta con el Equipo Técnico.',
	'editaccount-error-realname' => 'El nombre real no se ha modificado. Inténtalo de nuevo o contacta con el Equipo Técnico.',
	'editaccount-error-close' => 'Ha ocurrido un problema mientras cerrabas la cuenta. Inténtalo de nuevo o contacta con el Equipo Técnico.',
	'editaccount-invalid-email' => '¡"$1" no es una dirección válida de correo electrónico!',
	'editaccount-nouser' => '¡La cuenta "$1" no existe!',
	'editaccount-log' => 'Registro de cuentas del usuario',
	'editaccount-log-header' => 'Esta página se enumera los cambios que el personal de Wikia ha realizado a las preferencias de usuario.',
	'editaccount-log-entry-email' => 'Se ha cambiado de correo electrónico del usuario $2',
	'editaccount-log-entry-pass' => 'Se ha cambiado la contraseña del usuario $2',
	'editaccount-log-entry-realname' => 'Se ha cambiado el nombre real del usuario $2',
	'editaccount-log-entry-close' => 'inhabilitado cuenta $2',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Esta cuenta ha sido inhabilitada.</div>',
	'right-editaccount' => 'Editar las preferencias de otros usuarios',
);

/** Persian (فارسی) */
$messages['fa'] = array(
	'editaccount-submit-close' => 'بستن حساب کاربری',
);

/** Finnish (Suomi)
 * @author Centerlink
 * @author Crt
 * @author Jack Phoenix <jack@countervandalism.net>
 */
$messages['fi'] = array(
	'editaccount' => 'Muokkaa käyttäjätunnuksia',
	'editaccount-title' => 'Special: EditAccount',
	'editaccount-frame-manage' => 'Muokkaa käyttäjätunnusta',
	'editaccount-frame-usage' => 'Huomioi',
	'editaccount-usage' => 'Käyttäjäkohtaisen tiedot ovat talletettuna välimuistiin erikseen jokaista wikiä kohden. Kun asetat uuden salasanan tai sähköpostiosoitteen, välimuistiin tallennetut tiedot poistetaan vain tämän wikin kohdalla. Ohjaa käyttäjä kirjautumaan sisään tätä wikiä käyttäen välttääksesi ongelmia välimuistin kanssa.',
	'editaccount-label-select' => 'Valitse käyttäjätunnus',
	'editaccount-submit-account' => 'Hallinnoi tunnusta',
	'editaccount-frame-account' => 'Muokataan käyttäjätunnusta: $1',
	'editaccount-frame-close' => 'Poista käytöstä käyttäjätunnus: $1',
	'editaccount-label-email' => 'Aseta uusi sähköpostiosoite',
	'editaccount-label-pass' => 'Aseta uusi salasana',
	'editaccount-label-realname' => 'Aseta uusi oikea nimi',
	'editaccount-submit-email' => 'Tallenna sähköpostiosoite',
	'editaccount-submit-pass' => 'Tallenna salasana',
	'editaccount-submit-realname' => 'Tallenna oikea nimi',
	'editaccount-submit-close' => 'Sulje tunnus',
	'editaccount-usage-close' => 'Käyttäjätunnuksen voi poistaa käytöstä myös sekoittamalla sen salasanan ja poistamalla sen sähköpostiosoitteen. Huomioi, että nämä tiedot katoavat eikä niitä voi palauttaa.',
	'editaccount-warning-close' => '<b>Varoitus!</b> Olet poistamassa pysyvästi käytöstä käyttäjän <b>$1</b> tilin. Tämä ei voi palauttaa. Oletko varma, että haluat tehdä tämän?',
	'editaccount-status' => 'Tilaviesti',
	'editaccount-success-email' => 'Tunnuksen $1 sähköpostiosoite vaihdettiin onnistuneesti osoitteeseen $2.',
	'editaccount-success-pass' => 'Tunnuksen $1 salasana vaihdettiin onnistuneesti.',
	'editaccount-success-realname' => 'Tilin $1 oikea nimi vaihdettiin onnistuneesti.',
	'editaccount-success-close' => 'Tunnus $1 poistettiin käytöstä onnistuneesti.',
	'editaccount-error-email' => 'Sähköpostiosoitetta ei vaihdettu. Yritä uudelleen tai ota yhteyttä tekniseen tiimiin.',
	'editaccount-error-pass' => 'Salasanaa ei vaihdettu. Yritä uudelleen tai ota yhteyttä tekniseen tiimiin.',
	'editaccount-error-realname' => 'Oikea nimi ei vaihtunut. Yritä uudelleen tai ota yhteys tekniseen ryhmään.',
	'editaccount-error-close' => 'Tunnusta suljettaessa tapahtui virhe. Yritä uudelleen tai ota yhteyttä tekniseen tiimiin.',
	'editaccount-invalid-email' => '"$1" ei ole kelvollinen sähköpostiosoite!',
	'editaccount-nouser' => 'Tunnusta nimeltä "$1" ei ole olemassa!',
	'editaccount-log' => 'Käyttäjätunnusloki',
	'editaccount-log-header' => 'Tämä sivu listaa Wikian henkilökunnan käyttäjäkohtaisiin asetuksiin tekemät muutokset.',
	'editaccount-log-entry-email' => 'muutti käyttäjän $2 sähköpostiosoitetta',
	'editaccount-log-entry-pass' => 'muutti käyttäjän $2 salasanaa',
	'editaccount-log-entry-realname' => 'käyttäjän $2 oikea nimi vaihtui',
	'editaccount-log-entry-close' => 'poisti käytöstä tunnuksen $2',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Tämä tunnus on poistettu käytöstä.</div>',
	'right-editaccount' => 'Muokata toisten käyttäjien asetuksia',
);

/** French (Français)
 * @author IAlex
 * @author Peter17
 */
$messages['fr'] = array(
	'editaccount' => 'Modifier le compte',
	'editaccount-desc' => "Permet aux membres du personnel de gérer les informations sur les comptes d'utilisateur",
	'editaccount-title' => 'Special:EditAccount',
	'editaccount-frame-manage' => 'Modifier un compte',
	'editaccount-frame-usage' => 'Avis',
	'editaccount-usage' => "Les données des utilisateurs sont cachées séparément pour chaque wiki. Si vous réinitialisez le mot de passe ou l'adresse électronique, le cache ne sera annulé que pour ce wiki. Veuillez rediriger l'utilisateur vers ce wiki pour qu'il se connecte avec son nouveau mot de passe pour éviter les problèmes de cache.",
	'editaccount-label-select' => 'Sélectionner un compte utilisateur',
	'editaccount-submit-account' => 'Gérer le compte',
	'editaccount-frame-account' => 'Modification du compte utilisateur : $1',
	'editaccount-frame-close' => 'Désactiver le compte utilisateur : $1',
	'editaccount-label-email' => 'Définir une nouvelle adresse électronique',
	'editaccount-label-pass' => 'Définir un nouveau mot de passe',
	'editaccount-label-realname' => 'Définir un nouveau nom complet',
	'editaccount-submit-email' => "Sauvegarder l'adresse électronique",
	'editaccount-submit-pass' => 'Sauvegarder le mot de passe',
	'editaccount-submit-realname' => 'Sauvegarder le nom complet',
	'editaccount-submit-close' => 'Clore le compte',
	'editaccount-usage-close' => 'Vous pouvez également désactiver un compte utilisateur en cryptant son mot de passe et en supprimant son adresse électronique. Veuillez notez que les données seront perdues et ne seront pas récupérables.',
	'editaccount-warning-close' => '<b>Attention !</b> Vous êtes sur le point de désactiver le compte utilisateur <b>$1</b> de manière permanente. Ceci ne peut pas être défait. Êtes-vous certain de vouloir effectuer cette opération ?',
	'editaccount-status' => 'Message de statut',
	'editaccount-success-email' => "L'adresse électronique du compte $1 a été modifiée avec succès à $2.",
	'editaccount-success-email-blank' => "L'adresse électronique du compte $1 a été supprimée avec succès.",
	'editaccount-success-pass' => 'Le mot de passe du compte $1 a été modifié avec succès.',
	'editaccount-success-realname' => 'Le nom complet du compte $1 a été modifié avec succès.',
	'editaccount-success-close' => 'Le compte $1 a été désactivé avec succès.',
	'editaccount-error-email' => "L'adresse électronique n'a pas été modifiée. Essayez de nouveau ou contactez l'équipe technique.",
	'editaccount-error-pass' => "Le mot de passe n'a pas été modifié. Essayez de nouveau ou contactez l'équipe technique.",
	'editaccount-error-realname' => "Le nom complet n'a pas été modifié. Essayez de nouveau ou contactez l'équipe technique.",
	'editaccount-error-close' => "Un problème est survenu lors de la fermeture du compte. Veuillez ré-essayer ou contacter l'équipe technique.",
	'editaccount-invalid-email' => "« $1 » n'est pas une adresse électronique valide !",
	'editaccount-nouser' => "Le compte « $1 » n'existe pas !",
	'editaccount-log' => 'Journal des comptes utilisateurs',
	'editaccount-log-header' => 'Cette page liste les modifications faîtes au préférences utilisateur par le staff de Wikia.',
	'editaccount-log-entry-email' => "a modifié l'adresse électronique de l'utilisateur $2",
	'editaccount-log-entry-pass' => 'a modifié le mot de passe du compte $2',
	'editaccount-log-entry-realname' => 'a modifié le nom complet du compte $2',
	'editaccount-log-entry-close' => 'a désactivé le compte $2§',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Ce compte a été désactivé.</div>',
	'right-editaccount' => "Modifier les préférences d'autres utilisateurs",
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'editaccount' => 'Editar a conta',
	'editaccount-desc' => 'Permite que os membros do persoal xestionen a información das contas de usuario',
	'editaccount-title' => 'Special:EditAccount',
	'editaccount-frame-manage' => 'Editar unha conta',
	'editaccount-frame-usage' => 'Nota',
	'editaccount-usage' => 'Os datos de usuario gárdanse na memoria caché por separado para cada wiki. Cando restablece un contrasinal ou correo electrónico, a caché só se anulará para este wiki. Por favor, dirixa ao usuario ata este wiki para que acceda ao sistema co seu novo contrasinal para así evitar problemas de caché.',
	'editaccount-label-select' => 'Seleccionar unha conta de usuario',
	'editaccount-submit-account' => 'Xestionar a conta',
	'editaccount-frame-account' => 'Edición da conta de usuario: $1',
	'editaccount-frame-close' => 'Desactivar a conta de usuario: $1',
	'editaccount-label-email' => 'Establecer un novo enderezo de correo electrónico',
	'editaccount-label-pass' => 'Establecer un novo contrasinal',
	'editaccount-label-realname' => 'Establecer un novo nome real',
	'editaccount-submit-email' => 'Gardar o correo electrónico',
	'editaccount-submit-pass' => 'Gardar o contrasinal',
	'editaccount-submit-realname' => 'Gardar o nome real',
	'editaccount-submit-close' => 'Pechar a conta',
	'editaccount-usage-close' => 'Tamén pode desactivar unha conta de usuario codificando o seu contrasinal e eliminando o enderezo de correo electrónico. Teña en conta que se perderá esa información e non se poderá recuperar.',
	'editaccount-warning-close' => '<b>Coidado!</b> Está a piques de desactivar permanentemente a conta do usuario <b>$1</b>. Isto non se pode reverter. Está seguro de que é o que quere facer?',
	'editaccount-status' => 'Mensaxe de estado',
	'editaccount-success-email' => 'O correo electrónico da conta $1 cambiouse con éxito a $2.',
	'editaccount-success-email-blank' => 'Eliminouse con éxito o correo electrónico da conta $1.',
	'editaccount-success-pass' => 'Cambiouse con éxito o contrasinal da conta $1.',
	'editaccount-success-realname' => 'Cambiouse con éxito o nome real da conta $1.',
	'editaccount-success-close' => 'Desactivouse con éxito a conta $1.',
	'editaccount-error-email' => 'Non se modificou o correo electrónico. Inténteo de novo ou póñase en contacto co equipo técnico.',
	'editaccount-error-pass' => 'Non se modificou o contrasinal. Inténteo de novo ou póñase en contacto co equipo técnico.',
	'editaccount-error-realname' => 'Non se modificou o nome real. Inténteo de novo ou póñase en contacto co equipo técnico.',
	'editaccount-error-close' => 'Houbo un problema ao pechar a conta. Inténteo de novo ou póñase en contacto co equipo técnico.',
	'editaccount-invalid-email' => '"$1" non é un enderezo de correo electrónico válido!',
	'editaccount-nouser' => 'A conta "$1" non existe!',
	'editaccount-log' => 'Rexistro de contas de usuario',
	'editaccount-log-header' => 'Esta páxina lista as modificacións feitas ás preferencias do usuario polo persoal de Wikia.',
	'editaccount-log-entry-email' => 'cambiou o correo electrónico do usuario $2',
	'editaccount-log-entry-pass' => 'cambiou o contrasinal do usuario $2',
	'editaccount-log-entry-realname' => 'cambiou o nome real do usuario $2',
	'editaccount-log-entry-close' => 'desactivou a conta $2',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Esta conta foi desactivada.</div>',
	'right-editaccount' => 'Editar as preferencias doutros usuarios',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'editaccount' => 'Felhasználói fiók szerkesztése',
	'editaccount-title' => 'Special:Felhasználói fiók szerkesztése',
	'editaccount-frame-manage' => 'Egy felhasználói fiók szerkesztése',
	'editaccount-frame-usage' => 'Megjegyzés',
	'editaccount-label-select' => 'Felhasználói fiók kiválasztása',
	'editaccount-submit-account' => 'Felhasználói fiók kezelése',
	'editaccount-label-email' => 'Új e-mail cím beállítása',
	'editaccount-label-pass' => 'Új jelszó beállítása',
	'editaccount-label-realname' => 'Új valódi név beállítása',
	'editaccount-submit-email' => 'E-mail mentése',
	'editaccount-submit-pass' => 'Jelszó mentése',
	'editaccount-submit-realname' => 'Valódi név mentése',
	'editaccount-submit-close' => 'Felhasználói fiók lezárása',
	'editaccount-status' => 'Állapotüzenet',
	'editaccount-success-email' => 'A(z) $1 felhasználói fiók email címe sikeresen megváltoztatva erre: $2.',
	'editaccount-success-email-blank' => 'A(z) $1 felhasználói fiók email címe sikeresen eltávolítva.',
	'editaccount-success-close' => '„$1” felhasználói fiók sikeresen letiltva.',
	'editaccount-nouser' => 'A(z) „$1” felhasználói fiók nem létezik!',
	'editaccount-log' => 'Felhasználói fiókok naplója',
	'editaccount-log-entry-email' => '„$2” e-mail címe megváltoztatva',
	'editaccount-log-entry-pass' => '„$2” jelszava megváltoztatva',
	'editaccount-log-entry-realname' => '„$2” valódi neve megváltoztatva',
	'editaccount-log-entry-close' => '„$2” felhasználói fiók letiltva',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'editaccount' => 'Modificar conto',
	'editaccount-desc' => 'Permitte que membros del personal modifica informationes de contos de usatores',
	'editaccount-title' => 'Special:Modificar conto',
	'editaccount-frame-manage' => 'Modificar un conto',
	'editaccount-frame-usage' => 'Nota',
	'editaccount-usage' => 'Le datos de usator es retenite in cache separatemente pro cata wiki. Si tu reinitialisa un contrasigno o adresse de e-mail, le cache essera radite solmente pro iste wiki. Per favor dirige le usator a iste wiki pro aperir un session con un contrasigno novemente definite pro evitar problemas de cache.',
	'editaccount-label-select' => 'Selige un conto de usator',
	'editaccount-submit-account' => 'Gerer conto',
	'editaccount-frame-account' => 'Modification del conto de usator: $1',
	'editaccount-frame-close' => 'Disactivar le conto de usator: $1',
	'editaccount-label-email' => 'Definir nove adresse de e-mail',
	'editaccount-label-pass' => 'Definir nove contrasigno',
	'editaccount-label-realname' => 'Definir nove nomine real',
	'editaccount-submit-email' => 'Salveguardar e-mail',
	'editaccount-submit-pass' => 'Salveguardar contrasigno',
	'editaccount-submit-realname' => 'Salveguardar nomine real',
	'editaccount-submit-close' => 'Clauder conto',
	'editaccount-usage-close' => 'Tu pote equalmente disactivar un conto de usator per cryptar le contrasigno e remover le adresse de e-mail. Nota que iste datos essera irrecuperabilemente perdite.',
	'editaccount-warning-close' => '<b>Attention!</b> Tu es super le puncto de disactivar permanentemente le conto del usator <b>$1</b>. Isto es irreversibile. Es tu secur de voler facer isto?',
	'editaccount-status' => 'Message de stato',
	'editaccount-success-email' => 'E-mail del conto $1 cambiate a $2 con successo.',
	'editaccount-success-email-blank' => 'Le e-mail del conto $1 ha essite removite.',
	'editaccount-success-pass' => 'Contrasigno del conto $1 cambiate con successo.',
	'editaccount-success-realname' => 'Nomine real del conto $1 cambiate con successo.',
	'editaccount-success-close' => 'Conto $1 disactivate con successo.',
	'editaccount-error-email' => 'Le adresse de e-mail non ha essite cambiate. Reproba o contacta le equipa technic.',
	'editaccount-error-pass' => 'Le contrasigno non ha essite cambiate. Reproba o contacta le equipa technic.',
	'editaccount-error-realname' => 'Le nomine real non ha essite cambiate. Reproba o contacta le equipa technic.',
	'editaccount-error-close' => 'Un problema occurreva durante le clausura del conto. Reproba o contacta le equipa technic.',
	'editaccount-invalid-email' => '"$1" non es un adresse de e-mail valide!',
	'editaccount-nouser' => 'Le conto "$1" non existe!',
	'editaccount-log' => 'Registro de contos de usator',
	'editaccount-log-header' => 'Iste pagina lista le cambios facite al preferentias de usator per le personal de Wikia.',
	'editaccount-log-entry-email' => 'cambiava le adresse de e-mail del usator $2',
	'editaccount-log-entry-pass' => 'cambiava le contrasigno del usator $2',
	'editaccount-log-entry-realname' => 'cambiava le nomine real del usator $2',
	'editaccount-log-entry-close' => 'disactivava le conto $2',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Iste conto ha essite disactivate.</div>',
	'right-editaccount' => 'Modificar le preferentias de altere usatores',
);

/** Indonesian (Bahasa Indonesia)
 * @author Irwangatot
 */
$messages['id'] = array(
	'editaccount-frame-usage' => 'Catatan',
);

/** Italian (Italiano)
 * @author HalphaZ
 */
$messages['it'] = array(
	'editaccount' => 'Modifica account',
	'editaccount-frame-manage' => 'Modifica account',
	'editaccount-frame-usage' => 'Nota',
	'editaccount-label-select' => 'Selezionare un account utente',
	'editaccount-submit-account' => 'Gestisci account',
	'editaccount-frame-account' => "Modifica dell'account utente $1",
	'editaccount-frame-close' => "Disattiva l'account utente $1",
	'editaccount-label-email' => 'Imposta un nuovo indirizzo e-mail',
	'editaccount-label-pass' => 'Riscrivi la nuova password',
	'editaccount-label-realname' => 'Imposta il nuovo nome reale',
	'editaccount-submit-email' => 'Salva e-mail',
	'editaccount-submit-pass' => 'Salva password',
	'editaccount-submit-realname' => 'Salva il nome reale',
	'editaccount-submit-close' => 'Chiudi account',
	'editaccount-warning-close' => "<b>Attenzione:</b> Si sta per disabilitare permanentemente l'account dell'utente <b>$1.</b> Ciò non può essere annullato. Sicuro che sia quello che vuoi fare?",
	'editaccount-status' => 'Messaggio di stato',
	'editaccount-success-email-blank' => "E-mail rimossa con successo dall'account $1.",
	'editaccount-success-pass' => "Password per l'account $1 cambiata con successo.",
	'editaccount-success-realname' => "Nome reale per l'account $1 cambiato con successo.",
	'editaccount-success-close' => 'Account $1 disabilitato con successo.',
	'editaccount-error-email' => "L'e-mail non è stata cambiata. Riprova o contatta il Team Tecnico.",
	'editaccount-error-pass' => 'La password non è stata cambiata. Riprova o contatta il Team Tecnico.',
	'editaccount-error-realname' => 'Nome reale non cambiato. Riprova o contatta il Team Tecnico.',
	'editaccount-error-close' => "Si è verificato un problema alla chiusura dell'account. Riprova o contatta il Team Tecnico.",
	'editaccount-invalid-email' => '"$1" non è un indirizzo e-mail valido!',
	'editaccount-nouser' => 'L\'account "$1" non esiste!',
	'editaccount-log' => 'Registro account utente',
	'editaccount-log-header' => 'Questa pagina elenca le modifiche alle preferenze utente effettuate dallo Staff Wikia.',
	'editaccount-log-entry-email' => "E-mail dell'utente $2 cambiata",
	'editaccount-log-entry-pass' => "Password dell'utente $2 cambiata",
	'editaccount-log-entry-realname' => "Nome reale dell'utente $2 cambiato",
	'editaccount-log-entry-close' => 'Account $2 disabilitato',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em"> Questo account è stato disattivato. </div>',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'editaccount' => 'Kont änneren',
	'editaccount-title' => 'Spezial:Kont änneren',
	'editaccount-frame-manage' => 'E Kont änneren',
	'editaccount-frame-usage' => 'Notiz',
	'editaccount-label-select' => 'E Benotzerkont eraussichen',
	'editaccount-label-email' => 'Nei E-Mailadress festleeën',
	'editaccount-label-pass' => 'Neit Passwuert festleeën',
	'editaccount-submit-email' => 'E-Mailadress späicheren',
	'editaccount-submit-pass' => 'Passwuert späicheren',
	'editaccount-submit-realname' => 'Richtegen Numm späicheren',
	'editaccount-submit-close' => 'Kont zoumaachen',
	'editaccount-invalid-email' => '"$1" ass keng valabel E-Mailadress!',
	'editaccount-nouser' => 'De Kont "$1" gëtt et net!',
	'editaccount-log' => 'Logbuch vun de Benotzerkonten',
	'editaccount-log-entry-realname' => 'huet de richtegen Numm vum Benotzer $2 geännert',
	'right-editaccount' => 'Aner Benotzerastellungen änneren',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'editaccount' => 'Уреди сметка',
	'editaccount-desc' => 'Им овозможува на членовите на персоналот да раководат со информациите за корисничките сметки',
	'editaccount-title' => 'Специјални:УредиСметка',
	'editaccount-frame-manage' => 'Уреди сметка',
	'editaccount-frame-usage' => 'Напомена',
	'editaccount-usage' => 'Корисничките податоци се кешираат посебно за секое вики. Кога ќе смените лозинка или е-пошта, кешот ќе се поднови само за ова вики. Упатете го корисникот кон ова вики да се најави со новосоздадена лозинка, за да избегне проблеми со кеширање.',
	'editaccount-label-select' => 'Одберете корисничка сметка',
	'editaccount-submit-account' => 'Раководење со сметка',
	'editaccount-frame-account' => 'Уредување на корисничка сметка: $1',
	'editaccount-frame-close' => 'Оневозможи корисничка сметка: $1',
	'editaccount-label-email' => 'Нова е-поштенска адреса',
	'editaccount-label-pass' => 'Нова лозинка',
	'editaccount-label-realname' => 'Ново вистинско име',
	'editaccount-submit-email' => 'Зачувај е-пошта',
	'editaccount-submit-pass' => 'Зачувај лозинка',
	'editaccount-submit-realname' => 'Зачувај вистинско име',
	'editaccount-submit-close' => 'Затвори сметка',
	'editaccount-usage-close' => 'Можете да оневозможите корисничка сметка со тоа што ќе ја претворите лозинката во нечитлива и ќе ја отстраните е-поштенската адреса. Имајте на ум дека овие податоци ќе се изгубат и нема да можат да се вратат.',
	'editaccount-warning-close' => '<b>Внимание!</b> На пат сте засекогаш да ја оневозможите сметката на корисникот <b>$1</b>. Оваа постапка не може да се врати. Дали сте сигурни дека сакате да го направите ова?',
	'editaccount-status' => 'Статусна порака',
	'editaccount-success-email' => 'Е-поштата за сметката $1 е успешно променета на $2.',
	'editaccount-success-email-blank' => 'Е-поштата за сметката $1 е успешно отстранета.',
	'editaccount-success-pass' => 'Лозинката за сметката $1 е успешно променета.',
	'editaccount-success-realname' => 'Вистинското име за сметката $1 е успешно променето.',
	'editaccount-success-close' => 'Сметката $1 е успешно оневозможена.',
	'editaccount-error-email' => 'Е-поштата не е променета. Обидете се повторно или контактирајте ја Екипата за техничка поддршка',
	'editaccount-error-pass' => 'Лозинката не е променета. Обидете се повторно или контактирајте ја Екипата за техничка поддршка.',
	'editaccount-error-realname' => 'Вистинското име не е променето. Обидете се повторно или контактирајте ја Екипата за техничка поддршка.',
	'editaccount-error-close' => 'Се појави проблем при затворањето на сметката. Обидете се повторно или контактирајте ја Екипата за техничка поддршка',
	'editaccount-invalid-email' => '„$1“ не е важечка е-поштенска адреса!',
	'editaccount-nouser' => 'Сметката „$1“ не поостои',
	'editaccount-log' => 'Дневник на кориснички сметки',
	'editaccount-log-header' => 'Оваа страница ги прикажува промените во нагодувањата на корисниците направени од персоналот на Викија',
	'editaccount-log-entry-email' => 'променета е-поштата на корисникот $2',
	'editaccount-log-entry-pass' => 'променета лозинката на корисникот $2',
	'editaccount-log-entry-realname' => 'променето вистинското име на корисникот $2',
	'editaccount-log-entry-close' => 'оневозможена сметка $2',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Оваа сметка е оневозможена.</div>',
	'right-editaccount' => 'Уредување на нагодувања на други корисници',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'editaccount' => 'Gebruiker bewerken',
	'editaccount-desc' => 'Stelt stafleden in staat gebruikersinformatie te beheren',
	'editaccount-title' => 'Gebruiker bewerken',
	'editaccount-frame-manage' => 'Gebruiker bewerken',
	'editaccount-frame-usage' => 'Let op',
	'editaccount-usage' => 'Gebruikersgevens worden voor iedere wiki apart in een cache bijgehouden.
Als u een wachtwoord of e-mailadres opnieuw instelt, wordt alleen de cache voor deze wiki ongeldig gemaakt.
Laat de gebruiker bij deze wiki aanmelden met een nieuw wachtwoord om problemen met de cache te voorkomen.',
	'editaccount-label-select' => 'Selecteer een gebruiker',
	'editaccount-submit-account' => 'Gebruiker beheren',
	'editaccount-frame-account' => 'Te bewerken gebruiker: $1',
	'editaccount-frame-close' => 'Te sluiten gebruiker: $1',
	'editaccount-label-email' => 'Nieuwe e-mailadres instellen',
	'editaccount-label-pass' => 'Nieuw wachtwoord instellen',
	'editaccount-label-realname' => 'Nieuwe echte naam instellen',
	'editaccount-submit-email' => 'E-mailadres opslaan',
	'editaccount-submit-pass' => 'Wachtwoord opslaan',
	'editaccount-submit-realname' => 'Echte naam opslaan',
	'editaccount-submit-close' => 'Gebruiker afsluiten',
	'editaccount-usage-close' => 'U kunt een gebruiker ook uitschakelen door een onbekend wachtwoord in te stellen en het e-mailadres te verwijderen.
De huidige gegevens gaan dan verloren en zijn niet te herstellen.',
	'editaccount-warning-close' => '<b>Let op!</b>
U staat op het punt de gebruiker <b>$1</b> permanent af te sluiten.
Dit kan niet ongedaan gemaakt worden.
Weet u zeker dat u dit wilt doen?',
	'editaccount-status' => 'Statusbericht',
	'editaccount-success-email' => 'Het e-mailadres voor gebruiker $1 is gewijzigd naar $2.',
	'editaccount-success-email-blank' => 'Het e-mailadres voor $1 is verwijderd.',
	'editaccount-success-pass' => 'Het wachtwoord voor gebruiker $1 is gewijzigd.',
	'editaccount-success-realname' => 'De echte naam voor gebruiker $1 is gewijzigd.',
	'editaccount-success-close' => 'De gebruiker $1 is uitgeschakeld.',
	'editaccount-error-email' => 'Het e-mailadres is niet gewijzigd.
Probeer het opnieuw of neem contact op het met Tech Team.',
	'editaccount-error-pass' => 'Het wachtwoord is niet gewijzigd.
Probeer het opnieuw of neem contact op met het Tech Team.',
	'editaccount-error-realname' => 'De echte naam is niet gewijzigd.
Probeer het opnieuw of neem contact op met het Tech Team.',
	'editaccount-error-close' => 'Er is een probleem ontstaan bij het afsluiten van de gebruiker.
Probeer het opnieuw of neem contact op met het Tech Team.',
	'editaccount-invalid-email' => '"$1" is geen geldig e-mailadres.',
	'editaccount-nouser' => 'De gebruiker "$1" bestaat niet.',
	'editaccount-log' => 'Logboek gebruikers',
	'editaccount-log-header' => 'Op deze pagina staan wijzigingen in gebruikersvoorkeuren die door stafleden van Wikia zijn gemaakt.',
	'editaccount-log-entry-email' => 'heeft het e-mailadres voor gebruiker $2 aangepast',
	'editaccount-log-entry-pass' => 'heeft het wachtwoord voor gebruiker $2 aangepast',
	'editaccount-log-entry-realname' => 'heeft de echte naam voor gebruiker $2 aangepast',
	'editaccount-log-entry-close' => 'heeft gebruiker $2 uitgeschakeld',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Deze gebruiker is afgelsoten.</div>',
	'right-editaccount' => 'Voorkeuren van gebruikers bewerken',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'editaccount' => 'Rediger konto',
	'editaccount-desc' => 'Lar ledelsesmedlemmer administrere brukerkontoinformasjon',
	'editaccount-title' => 'Special:EditAccount',
	'editaccount-frame-manage' => 'Rediger en konto',
	'editaccount-frame-usage' => 'Merk',
	'editaccount-usage' => 'Brukerdata blir mellomlagret separat for hver wiki. Når du tilbakestiller et passord eller en e-post, vil mellomlageret kun bli tømt for denne wikien. Vennligst led brukeren til denne wikien for å logge inn med det nyinnsatte passordet for å unngå problemer med mellomlageret.',
	'editaccount-label-select' => 'Velg en brukerkonto',
	'editaccount-submit-account' => 'Administrer konto',
	'editaccount-frame-account' => 'Redigerer brukerkonto: $1',
	'editaccount-frame-close' => 'Deaktiver brukerkonto: $1',
	'editaccount-label-email' => 'Angi ny e-postadresse',
	'editaccount-label-pass' => 'Angi nytt passord',
	'editaccount-label-realname' => 'Angi nytt virkelig navn',
	'editaccount-submit-email' => 'Lagre e-post',
	'editaccount-submit-pass' => 'Lagre passord',
	'editaccount-submit-realname' => 'Lagre virkelig navn',
	'editaccount-submit-close' => 'Lukk konto',
	'editaccount-usage-close' => 'Du kan også deaktivere en brukerkonto ved å tilfeldiggjøre passordet og fjerne e-postadressen. Legg merke til at denne dataen går tapt og ikke vil kunne gjenopprettes.',
	'editaccount-warning-close' => '<b>Forsiktig!</b> Du er i ferd med å permanent deaktivere kontoen til bruker <b>$1</b>. Dette kan ikke gjenopprettes. Er du sikker på at det er det du vil gjøre?',
	'editaccount-status' => 'Statusmelding',
	'editaccount-success-email' => 'Endret e-post for konto $1 til $2.',
	'editaccount-success-email-blank' => 'Fjernet e-post for kontoen $1.',
	'editaccount-success-pass' => 'Endret passord for konto $1.',
	'editaccount-success-realname' => 'Endret virkelig navn for konto $1.',
	'editaccount-success-close' => 'Deaktiverte konto $1.',
	'editaccount-error-email' => 'E-post ble ikke endret. Prøv igjen eller kontakt Tech Team.',
	'editaccount-error-pass' => 'Passord ble ikke endret. Prøv igjen eller kontakt Tech Team.',
	'editaccount-error-realname' => 'Virkelig navn ble ikke endret. Prøv igjen eller kontakt Tech Team.',
	'editaccount-error-close' => 'Et problem oppsto under lukking av kontoen. Prøv igjen eller kontakt Tech Team.',
	'editaccount-invalid-email' => '«$1» er ikke en gyldig e-postadresse!',
	'editaccount-nouser' => 'Kontoen «$1» finnes ikke!',
	'editaccount-log' => 'Brukerkontologg',
	'editaccount-log-header' => 'Denne siden lister opp endringer gjort på brukerinstillinger av Wikia Staff.',
	'editaccount-log-entry-email' => 'endret e-post for bruker $2',
	'editaccount-log-entry-pass' => 'endret passord for bruker $2',
	'editaccount-log-entry-realname' => 'endret virkelig navn for bruker $2',
	'editaccount-log-entry-close' => 'deaktiverte konto $2',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Denne kontoen har blitt deaktivert.</div>',
	'right-editaccount' => 'Rediger andre brukeres innstillinger',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'editaccount' => 'Modìfica Cont',
	'editaccount-desc' => "A përmet ai mèmber ëd l'echip ëd gestì j'anformassion dël cont ëd l'utent",
	'editaccount-title' => 'Special:EditAccount',
	'editaccount-frame-manage' => 'Modìfica un cont',
	'editaccount-frame-usage' => 'Nòta',
	'editaccount-usage' => "Ij dat utent a son butà an memòria local separatament për minca wiki. Quand ch'a ampòsta torna na ciav o n'adrëssa ëd pòsta eletrònica, la memòria local a sarà anulà mach për cola wiki. Për piasì ch'a adressa l'utent a cola wiki-là për intré con la neuva ciav për evité problema ëd memòria local.",
	'editaccount-label-select' => 'Selession-a un cont utent',
	'editaccount-submit-account' => 'Gestiss Cont',
	'editaccount-frame-account' => 'Modifiché cont utent: $1',
	'editaccount-frame-close' => 'Disabilité ël cont utent: $1',
	'editaccount-label-email' => 'Buté na neuva adrëssa ëd pòsta eletrònica',
	'editaccount-label-pass' => 'Ampòsta neuva ciav',
	'editaccount-label-realname' => 'Ampòsta neuv nòm ver',
	'editaccount-submit-email' => "Salvé l'adrëssa ëd pòsta eletrònica",
	'editaccount-submit-pass' => 'Salva Ciav',
	'editaccount-submit-realname' => 'Salva Nòm Ver',
	'editaccount-submit-close' => 'Sara Cont',
	'editaccount-usage-close' => "A peul ëdcò disabilité a un cont utent an cripté soa ciav e gavand soa adrëssa ëd pòsta eletrònica. Ch'a fasa atension che sto dat a l'é përdù e a l'é pa arcuperàbil.",
	'editaccount-warning-close' => "<b>Atension!</b> A l'é an camin ch'a disabìlita për sempe ël cont ëd l'utent <b>$1</b>. As peul pa torné andré. É-lo sigur ëd vorèj felo?",
	'editaccount-status' => 'Mëssagi dë stat',
	'editaccount-success-email' => "Cambià da bin l'adrëssa ëd pòsta eletrònica për ël cont $1 a $2.",
	'editaccount-success-email-blank' => "Gavà da bin l'adrëssa ëd pòsta eletrònica dal cont $1.",
	'editaccount-success-pass' => 'Cambià da bin ciav për ël cont $1.',
	'editaccount-success-realname' => 'Cambià da bin ël nòm ver për ël cont $1.',
	'editaccount-success-close' => 'Disabilità da bin ël cont $1.',
	'editaccount-error-email' => "L'adrëssa ëd pòsta eletrònica e l'é pa stàita cambià. Ch'a preuva torna o ch'a contata l'Echip técnica.",
	'editaccount-error-pass' => "La ciav a l'é pa stàita cangià. Ch'a preuva torna o ch'a contata l'Echip técnica.",
	'editaccount-error-realname' => "Ël nòm ver a l'é pa stàit cangià. Ch'a preuva torna o ch'a contata l'Echip Técnica.",
	'editaccount-error-close' => "Un problema a l'é capità an sarand ël cont. Ch'a preuva torna o ch'a contata l'Echip técnica.",
	'editaccount-invalid-email' => '"$1" a l\'é n\'adrëssa ëd pòsta eletrònica pa bon-a!',
	'editaccount-nouser' => 'Cont "$1" a esist pa!',
	'editaccount-log' => 'Registr dël cont utent',
	'editaccount-log-header' => "Sta pàgina-sì a lista ij cangiament fàit ai gust ëd l'utent da l'Echip ëd Wikia.",
	'editaccount-log-entry-email' => "a l'ha cangià l'adrëssa ëd pòsta eletrònica për l'utent $2",
	'editaccount-log-entry-pass' => 'cangià ciav për utent $2',
	'editaccount-log-entry-realname' => 'cangià nòm ver për utent $2',
	'editaccount-log-entry-close' => 'disabilità cont $2',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Sto cont-sì a l\'é stàit disabilità.</div>',
	'right-editaccount' => "Modifiché ij gust ëd j'àutri utent",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'editaccount-frame-usage' => 'يادښت',
	'editaccount-label-email' => 'نوې برېښليک پته ټاکل',
	'editaccount-label-pass' => 'نوی پټنوم ټاکل',
	'editaccount-label-realname' => 'نوی اصلي نوم ټاکل',
	'editaccount-submit-email' => 'برېښليک خوندي کول',
	'editaccount-submit-pass' => 'پټنوم خوندي کول',
	'editaccount-submit-close' => 'کارن حساب تړل',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'editaccount' => 'Editar Conta',
	'editaccount-desc' => 'Permite que os membros da equipa administrem a informação das contas de utilizador',
	'editaccount-title' => 'Special:EditAccount',
	'editaccount-frame-manage' => 'Editar uma conta',
	'editaccount-frame-usage' => 'Nota',
	'editaccount-usage' => 'Os dados do utilizador são mantidos em caches separadas para cada wiki. Ao reiniciar a palavra-chave ou o endereço de correio electrónico, será desfeita somente a cache desta wiki. Para evitar problemas de cache, direccione o utilizador para esta wiki para se autenticar com uma palavra-chave nova.',
	'editaccount-label-select' => 'Seleccione uma conta de utilizador',
	'editaccount-submit-account' => 'Administrar Conta',
	'editaccount-frame-account' => 'A editar a conta: $1',
	'editaccount-frame-close' => 'Deactivar a conta: $1',
	'editaccount-label-email' => 'Definir endereço de correio electrónico novo',
	'editaccount-label-pass' => 'Definir palavra-chave nova',
	'editaccount-label-realname' => 'Definir nome verdadeiro novo',
	'editaccount-submit-email' => 'Gravar Correio Electrónico',
	'editaccount-submit-pass' => 'Gravar Palavra-chave',
	'editaccount-submit-realname' => 'Gravar Nome Verdadeiro',
	'editaccount-submit-close' => 'Fechar Conta',
	'editaccount-usage-close' => 'Também pode desactivar uma conta de utilizador misturando a palavra-chave e removendo o endereço electrónico. Note que estes dados serão perdidos e não podem ser recuperados.',
	'editaccount-warning-close' => '<b>Cuidado!</b> Está prestes a desactivar definitivamente a conta do utilizador <b>$1</b>. Esta operação não pode ser desfeita. Tem a certeza de que pretende fazê-lo?',
	'editaccount-status' => 'Estado',
	'editaccount-success-email' => 'Alterou com sucesso o endereço electrónico da conta $1 para $2.',
	'editaccount-success-email-blank' => 'Removeu com sucesso o endereço electrónico da conta $1.',
	'editaccount-success-pass' => 'Alterou com sucesso a palavra-chave da conta $1.',
	'editaccount-success-realname' => 'Alterou com sucesso o nome verdadeiro da conta $1.',
	'editaccount-success-close' => 'Desactivou com sucesso a conta $1.',
	'editaccount-error-email' => 'O endereço electrónico não foi alterado. Tente novamente ou contacte o Suporte Técnico.',
	'editaccount-error-pass' => 'A palavra-chave não foi alterada. Tente novamente ou contacte o Suporte Técnico.',
	'editaccount-error-realname' => 'O nome verdadeiro não foi alterado. Tente novamente ou contacte o Suporte Técnico.',
	'editaccount-error-close' => 'Ocorreu um problema ao fechar a conta. Tente novamente ou contacte o Suporte Técnico.',
	'editaccount-invalid-email' => '"$1" não é um endereço electrónico válido!',
	'editaccount-nouser' => 'A conta "$1" não existe!',
	'editaccount-log' => 'Registo de contas de utilizador',
	'editaccount-log-header' => 'Esta página lista as alterações feitas às suas preferências pela Equipa da Wikia.',
	'editaccount-log-entry-email' => 'alterou o endereço electrónico do utilizador $2',
	'editaccount-log-entry-pass' => 'alterou a palavra-chave do utilizador $2',
	'editaccount-log-entry-realname' => 'alterou o nome verdadeiro do utilizador $2',
	'editaccount-log-entry-close' => 'desactivou a conta $2',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Esta conta foi desactivada.</div>',
	'right-editaccount' => 'Editar as preferências de outros utilizadores',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 * @author Jesielt
 */
$messages['pt-br'] = array(
	'editaccount' => 'Editar conta',
	'editaccount-desc' => 'Permite que os membros da equipe administrem a informação das contas de usuário',
	'editaccount-title' => 'Special:EditAccount',
	'editaccount-frame-manage' => 'Editar uma conta',
	'editaccount-frame-usage' => 'Nota',
	'editaccount-usage' => 'Os dados de usuário estão em caches separados para cada wiki. Quando você redefine uma senha ou email, o cache será modificado apenas para essa wiki. Por favor, direcione o usuário de modo a realizar login nessa wiki com a nova senha, para evitar problemas de cache.',
	'editaccount-label-select' => 'Selecione uma conta de usuário',
	'editaccount-submit-account' => 'Administrar Contas',
	'editaccount-frame-account' => 'Editando conta de usuário: $1',
	'editaccount-frame-close' => 'Desabilitar conta de usuário: $1',
	'editaccount-label-email' => 'Definir novo endereço de email',
	'editaccount-label-pass' => 'Definir nova senha',
	'editaccount-label-realname' => 'Definir novo nome real',
	'editaccount-submit-email' => 'Salvar Email',
	'editaccount-submit-pass' => 'Salvar Senha',
	'editaccount-submit-realname' => 'Salvar Nome Real',
	'editaccount-submit-close' => 'Fechar Conta',
	'editaccount-usage-close' => 'Você também pode desabilitar uma conta de usuário mudando sua senha e removendo o endereço de email. Note que esses dados serão perdidos e nunca mais poderão ser recuperados.',
	'editaccount-warning-close' => '<b>Atenção!</b> Você está prestes a desativar permanentemente a conta de usuário <b>$1</b>. Essa ação não poderá ser revertida. Estando ciente disto, você tem certeza de que é isso que deseja fazer?',
	'editaccount-status' => 'Mensagem de status',
	'editaccount-success-email' => 'Email alterado com sucesso para a conta de $1 para $2.',
	'editaccount-success-email-blank' => 'Removeu com sucesso o e-mail da conta $1.',
	'editaccount-success-pass' => 'Senha alterada com sucesso para a conta $1.',
	'editaccount-success-realname' => 'Nome real alterado com sucesso para a conta $1.',
	'editaccount-success-close' => 'Conta $1 desabilitada com sucesso.',
	'editaccount-error-email' => 'O email não foi alterado. Tente novamente ou contate a equipe de apoio (Tech Team).',
	'editaccount-error-pass' => 'A senha não foi alterada. Tente novamente ou contate a equipe de apoio (Tech Team).',
	'editaccount-error-realname' => 'O nome real não foi alterado. Tente novamente ou contate a equipe de apoio (Tech Team).',
	'editaccount-error-close' => 'Ocorreu um problema ao fechar a conta. Tente novamente ou contate a equipe de apoio (Tech Team).',
	'editaccount-invalid-email' => '"$1" não é um endereço de email válido!',
	'editaccount-nouser' => 'A conta "$1" não existe!',
	'editaccount-log' => 'Use o log de contas',
	'editaccount-log-header' => 'Essa página lista mudanças feitas nas preferências de usuário pela equipe do Wikia (Wikia Staff).',
	'editaccount-log-entry-email' => 'email alterado para o usuário $2',
	'editaccount-log-entry-pass' => 'senha alterada para o usuário $2',
	'editaccount-log-entry-realname' => 'nome real alterado para o usuário $2',
	'editaccount-log-entry-close' => 'desabilitada a conta $2',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Essa conta foi desabilitada.</div>',
	'right-editaccount' => 'Editar outras preferências de usuário',
);

/** Russian (Русский)
 * @author Eleferen
 * @author Lockal
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'editaccount' => 'Изменение учётной записи',
	'editaccount-desc' => 'Позволяет управлять учётными записями пользователей',
	'editaccount-title' => 'Special:ИзменениеУчётнойЗаписи',
	'editaccount-frame-manage' => 'Изменение учётной записи',
	'editaccount-frame-usage' => 'Замечание',
	'editaccount-usage' => 'Данные кэшируются отдельно для каждой вики. При сбросе пароля или адреса электронной почты, кэш будет обновлён только для этой вики. Пожалуйста, попросите участника войти в эту вики с новым паролем, чтобы избежать проблем с кэшированием.',
	'editaccount-label-select' => 'Выберите учётную запись участника',
	'editaccount-submit-account' => 'Управление учётной записью',
	'editaccount-frame-account' => 'Изменение учётной записи участника: $1',
	'editaccount-frame-close' => 'Отключение учётной записи участника: $1',
	'editaccount-label-email' => 'Установка нового адреса эл. почты',
	'editaccount-label-pass' => 'Установка нового пароля',
	'editaccount-label-realname' => 'Установка нового настоящего имени',
	'editaccount-submit-email' => 'Сохранить адрес эл. почты',
	'editaccount-submit-pass' => 'Сохранить пароль',
	'editaccount-submit-realname' => 'Сохранить настоящее имя',
	'editaccount-submit-close' => 'Закрыть учётную запись',
	'editaccount-usage-close' => 'Вы также можете приостановить действие учётной записи, заменив её пароль и удалив адрес электронной почты. Обратите внимание, что эти данные будет невозможно восстановить.',
	'editaccount-warning-close' => '<b>Внимание!</b> Вы собираетесь навсегда отключить учётную запись пользователя <b>$1</b>. Это действие не может быть отменено. Вы уверены, что хотите сделать именно это?',
	'editaccount-status' => 'Статусное сообщение',
	'editaccount-success-email' => 'Адрес эл. почты для учётной записи $1 успешно изменён на $2.',
	'editaccount-success-email-blank' => 'Адрес электронной почты учётной записи $1 успешно удалён.',
	'editaccount-success-pass' => 'Пароль для учётной записи $1 успешно изменён.',
	'editaccount-success-realname' => 'Настоящее имя для учётной записи $1 успешно изменено.',
	'editaccount-success-close' => 'Учётная запись $1 успешно отключена.',
	'editaccount-error-email' => 'Адрес эл. почты не был изменён. Попробуйте ещё раз или свяжитесь с технической командой.',
	'editaccount-error-pass' => 'Пароль не был изменён. Попробуйте ещё раз или свяжитесь с технической командой.',
	'editaccount-error-realname' => 'Настоящее имя не было изменено. Попробуйте ещё раз или свяжитесь с технической командой.',
	'editaccount-error-close' => 'Возникла проблема при закрытии учётной записи. Попробуйте ещё раз или свяжитесь с технической командой.',
	'editaccount-invalid-email' => '«$1» не является допустимым адресом электронной почты!',
	'editaccount-nouser' => 'Учётная запись «$1» не существует!',
	'editaccount-log' => 'Журнал учётных записей',
	'editaccount-log-header' => 'На этой странице показаны изменения настроек участника, выполненные сотрудниками Викии',
	'editaccount-log-entry-email' => 'изменил адрес эл. почты участника $2',
	'editaccount-log-entry-pass' => 'изменил пароль участника $2',
	'editaccount-log-entry-realname' => 'изменил настоящее имя участника $2',
	'editaccount-log-entry-close' => 'отключил учётную запись $2',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Эта учётная запись была отключена.</div>',
	'right-editaccount' => 'Редактировать настройки других участников',
);

/** Sinhala (සිංහල)
 * @author බිඟුවා
 */
$messages['si'] = array(
	'editaccount' => 'ගිණුම සංස්කරණය',
	'editaccount-frame-manage' => 'ගිණුමක් සංස්කරණය',
	'editaccount-frame-usage' => 'සටහන',
	'editaccount-submit-pass' => 'මුර පදය සුරකින්න',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Rancher
 * @author Verlor
 */
$messages['sr-ec'] = array(
	'editaccount' => 'Измена налога',
	'editaccount-frame-manage' => 'Уреди налог',
	'editaccount-frame-usage' => 'Белешка',
	'editaccount-label-select' => 'Изаберите кориснички налог',
	'editaccount-frame-close' => 'Онемогући кориснички налог: $1',
	'editaccount-label-email' => 'Постави нову адресу електронске поште (мејл)',
	'editaccount-label-pass' => 'Постави нову лозинку',
	'editaccount-label-realname' => 'Унеси ново право име',
	'editaccount-submit-email' => 'Сачувај е-пошту',
	'editaccount-submit-pass' => 'Сачувај лозинку',
	'editaccount-submit-realname' => 'Сачувај право име',
	'editaccount-submit-close' => 'Затвори налог',
	'editaccount-status' => 'Стање поруке',
	'editaccount-success-email' => 'Успешно променио е-пошту од налога $1 на $2.',
	'editaccount-success-pass' => 'Успешно променио лозинку за налог  $1.',
	'editaccount-success-realname' => 'успешно променио право име за налог  $1.',
	'editaccount-success-close' => 'Успешно затворио налог  $1.',
	'editaccount-invalid-email' => '"$1" је неважећа адреса електронске поште',
	'editaccount-nouser' => 'Не постоји налог "$1" !',
	'editaccount-log' => 'Извештај корисничких налога',
	'editaccount-log-entry-email' => ' промењена адреса е-поште за корисника $2',
	'editaccount-log-entry-pass' => ' промењена лозинка за корисника $2',
	'editaccount-log-entry-realname' => ' промењено право име за корисника $2',
	'editaccount-log-entry-close' => ' угашен налог $2',
);

/** Tamil (தமிழ்)
 * @author Mahir78
 * @author TRYPPN
 */
$messages['ta'] = array(
	'editaccount' => 'கணக்கில் மாற்றங்கள் செய்',
	'editaccount-desc' => 'பயனர் கணக்குகளை பற்றிய விவரங்களை எமது பணியாளர்கள் நிர்வகிக்க வசதி செய்யப்பட்டுள்ளது',
	'editaccount-title' => 'சிறப்பு:கணக்கில் மாற்றங்கள் செய்தல்',
	'editaccount-frame-manage' => 'ஒரு கணக்கை தொகு',
	'editaccount-frame-usage' => 'குறிப்பு',
	'editaccount-label-select' => 'ஒரு பயனர் கணக்கை தேர்ந்தெடு',
	'editaccount-submit-account' => 'கணக்கை நிர்வகி',
	'editaccount-frame-account' => 'பயனர் கணக்கு தொகுக்கப்படுகிறது: $1',
	'editaccount-frame-close' => 'பயனர் கணக்கை நிறுத்திவை: $1',
	'editaccount-label-email' => 'புதிய மின்னஞ்சல் முகவரியை செலுத்து',
	'editaccount-label-pass' => 'புதிய கடவுச்சொல்லை செலுத்து',
	'editaccount-label-realname' => 'புதிய சரியான பெயரை உள்ளிடு',
	'editaccount-submit-email' => 'மின்னஞ்சலை சேமி',
	'editaccount-submit-pass' => 'கடவுச்சொல்லை சேமி',
	'editaccount-submit-realname' => 'உண்மையான பெயரை சேமி',
	'editaccount-submit-close' => 'கணக்கை முடுக',
	'editaccount-status' => 'தற்போதைய நிலைமை பற்றிய செய்தி',
	'editaccount-success-email' => 'கணக்கு $1 லிருந்து $2 க்கு மின்னஞ்சல் வெற்றிகரமாக மாற்றப்பட்டது.',
	'editaccount-success-email-blank' => 'கணக்கு $1 க்கான மின்னஞ்சல் வெற்றிகரமாக நீக்கப்பட்டது',
	'editaccount-success-pass' => 'கணக்கு $1க்கான கடவுச்சொல் வெற்றிகரமாக மாற்றப்பட்டது',
	'editaccount-success-realname' => 'கணக்கு $1க்கான உண்மையான பெயர் வெற்றிகரமாக மாற்றப்பட்டது',
	'editaccount-success-close' => '$1 இந்த கணக்கை வெற்றிகரமாக செயலிழக்கச் செய்யப்பட்டுள்ளது.',
	'editaccount-error-email' => 'மின்னஞ்சல் மாற்றப்படவில்லை. மீண்டும் முயற்சிக்கவும் அல்லது தொழில்நுட்ப குழுவை அனுகவும்.',
	'editaccount-error-pass' => 'கடவுச்சொல் மாற்றப்படவில்லை. மீண்டும் முயற்சிக்கவும் அல்லது தொழில்நுட்ப குழுவை அனுகவும்.',
	'editaccount-error-realname' => 'உண்மையான பெயர் மாற்றப்படவில்லை. மீண்டும் முயற்சிக்கவும் அல்லது தொழில்நுட்ப குழுவை அனுகவும்.',
	'editaccount-error-close' => 'கணக்கு மூடும்போது ஒரு பிரச்சினை உள்ளது. மீண்டும் முயற்சிக்கவும் அல்லது தொழில்நுட்ப குழுவை அனுகவும்',
	'editaccount-invalid-email' => '"$1" சரியான மின்னஞ்சல் இல்லை!',
	'editaccount-nouser' => '"$1" - அப்படியொரு கணக்கு இல்லை!',
	'editaccount-log' => 'பயனர் கணக்கு log',
	'editaccount-log-header' => 'இந்தப் பக்கம் விக்கியா அலுவலரால் மாற்றப்பட்ட பயனர் விருப்பத்தேர்வுகள் பட்டியல்கள்.',
	'editaccount-log-entry-email' => 'பயனர் $2 க்கான மின்னஞ்சல் மாற்றப்பட்டது',
	'editaccount-log-entry-pass' => 'பயனர் $2 க்கான கடவுச்சொல் மாற்றப்பட்டது',
	'editaccount-log-entry-realname' => 'பயனர் $2க்கான உண்மையான பெயர் மாற்றப்பட்டது',
	'editaccount-log-entry-close' => 'செயலிழந்த கணக்கு $2',
	'right-editaccount' => 'ஏனைய பயனர் விருப்பத்தேர்வுகளை தொகு',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'editaccount-frame-usage' => 'గమనిక',
	'editaccount-status' => 'స్థితి సందేశం',
	'editaccount-invalid-email' => '"$1" అనేది సరైన ఈ-మెయిలు చిరునామా కాదు!',
	'editaccount-nouser' => '"$1" అనే ఖాతా లేనే లేదు!',
	'editaccount-log' => 'వాడుకరి ఖాతాల చిట్టా',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">ఈ ఖాతాని అచేతనం చేసారు.</div>',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'editaccount' => 'Baguhin ang Akawnt',
	'editaccount-title' => 'Natatangi:BaguhinangAkawnt',
	'editaccount-frame-manage' => 'Baguhin ang isang akawnt',
	'editaccount-frame-usage' => 'Tala',
	'editaccount-usage' => 'Nakahiwalay ang pagkakatago ng dato ng tagagamit para sa bawat wiki.  Kapag muli mong itinakda ang hudyat o e-liham, masisira ang taguan para sa wiking ito lamang.  Mangyari ituro ang tagagamit sa wiking ito upang lumagda na may isang bagong takdang hudyat upang maiwasan ang mga paksa na pangtaguan.',
	'editaccount-label-select' => 'Pumili ng isang akawnt ng tagagamit',
	'editaccount-submit-account' => 'Pamahalaan ang Akawnt',
	'editaccount-frame-account' => 'Binabago ang akawnt ng tagagamit na: $1',
	'editaccount-frame-close' => 'Huwag nang paganahin ang akawnt ng tagagamit na: $1',
	'editaccount-label-email' => 'Itakda ang bagong tirahan ng e-liham',
	'editaccount-label-pass' => 'Magtakda ng bagong hudyat',
	'editaccount-label-realname' => 'Itakda ang bagong tunay na pangalan',
	'editaccount-submit-email' => 'Sagipin ang E-Liham',
	'editaccount-submit-pass' => 'Sagipin ang Hudyat',
	'editaccount-submit-realname' => 'Sagipin ang Tunay na Pangalan',
	'editaccount-submit-close' => 'Isara ang Akawnt',
	'editaccount-usage-close' => 'Maaari mo ring huwag paandarin ang isang akawnt ng tagagamit sa pamamagitan ng paggulo sa hudyat at pagtanggal ng tirahan ng e-liham.  Unawaing mawawala na ang datong ito at hindi na maibabalik pa.',
	'editaccount-warning-close' => '<b>Mag-ingat!</b> Pananatilihin mo nang hindi pagaganahin ang akawnt ng tagagamit na si <b>$1</b>.  Hindi na ito maibabalik pa.  Talaga bang ito ang nais mong gawin?',
	'editaccount-status' => 'Mensahe ng katayuan',
	'editaccount-success-email' => 'Matagumpay na nabago ang e-liham para sa akawnt na $1 papuntang $2.',
	'editaccount-success-email-blank' => 'Matagumpay na natanggal ang e-liham mula sa akawnt na $1.',
	'editaccount-success-pass' => 'Matagumpay na nabago ang hudyat para sa akawnt na $1.',
	'editaccount-success-realname' => 'Matagumpay na nabago ang tunay na pangalan para sa akawnt na $1.',
	'editaccount-success-close' => 'Matagumpay na hindi pinagana ang akawnt na $1.',
	'editaccount-error-email' => 'Hindi binago ang e-liham.  Subukan uli o makipag-ugnayan sa Pangkat ng Tek.',
	'editaccount-error-pass' => 'Hindi nabago ang hudyat. Subukan uli o makipag-ugnayan sa Pangkat ng Tek.',
	'editaccount-error-realname' => 'Hindi nabago ang tunay na pangalan.  Subukan uli o makipag-ugnayan sa Pangkat ng Tek.',
	'editaccount-error-close' => 'Naganap ang isang suliranin habang sinasara ang akawnt.  Subukan uli o makipag-ugnayan sa Pangkat ng Tek.',
	'editaccount-invalid-email' => 'Ang "$1" ay hindi isang tanggap na tirahan ng e-liham!',
	'editaccount-nouser' => 'Hindi umiiral ang akawnt na "$1"!',
	'editaccount-log' => 'Talaan ng mga akawnt ng tagagamit',
	'editaccount-log-header' => 'Nagtatala ang pahinang ito ng mga pagbabagong ginawa ng Mga Tauhan ng Wikia sa mga nais ng tagagamit.',
	'editaccount-log-entry-email' => 'binago ang e-liham para sa tagagamit na $2',
	'editaccount-log-entry-pass' => 'binago ang hudyat para sa tagagamit na $2',
	'editaccount-log-entry-realname' => 'binago ang tunay na pangalan para sa tagagamit na $2',
	'editaccount-log-entry-close' => 'hindi pinagana ang akawnt na $2',
	'edit-account-closed-flag' => '<div style="border: 1px solid black; padding: 1em">Hindi na pinagagana ang akawnt na ito.</div>',
	'right-editaccount' => 'Baguhin ang mga nais ng iba pang mga tagagamit',
);

/** Ukrainian (Українська)
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'editaccount-log' => 'Журнал облікових записів',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'editaccount' => 'Sửa đổi tài khoản',
);

