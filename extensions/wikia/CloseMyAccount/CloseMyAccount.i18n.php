<?php
$messages = array();

$messages['en'] = array(
	'closemyaccount' => 'Close My Account',
	'closemyaccount-desc' => 'Allows users to close their own accounts.',
	'closemyaccount-intro-text' => "We are sorry {{GENDER:$2|you}} want to disable your account. FANDOM has many communities on all sorts of subjects and we'd love for you to stick around and find the one that's right for you. If you are having a local problem with your community, please don't hesitate to contact your [[Special:ListUsers/sysop|local admins]] for help and advice.

If you have decided you definitely want to disable your account please be aware:
* FANDOM does not have the ability to fully remove accounts, but we can disable them. This will ensure the account is locked and can't be used.
* This process is NOT reversible after $1 {{PLURAL:$1|day has|days have}} passed, and you will have to create a new account if you wish to rejoin FANDOM.
* This process will not remove your contributions from a given FANDOM community, as these contributions belong to the community as a whole.

If you need any more information on what an account disable actually does, you can visit our [[Help:Close_my_account|help page on disabling your account]]. If you are sure you want to close your account, please click the button below.

Please note you will have $1 {{PLURAL:$1|day|days}} after making this request to reactivate your account by logging in and following the instructions you will see. After this waiting period, your account will be closed permanently and cannot be restored.",
	'closemyaccount-unconfirmed-email' => 'Warning: You do not have a confirmed email address associated with this account. You will not be able to reactivate your account within the waiting period without one. Please consider setting an email address in [[Special:Preferences|your preferences]] before proceeding.',
	'closemyaccount-logged-in-as' => 'You are logged in as {{GENDER:$1|$1}}. [[Special:UserLogout|Not you?]]',
	'closemyaccount-current-email' => '{{GENDER:$2|Your}} email is set to $1. [[Special:Preferences|Do you wish to change it?]]',
	'closemyaccount-confirm' => '{{GENDER:$1|I}} have read the [[Help:Close_my_account|help page on closing your account]] and confirm that I want to disable my FANDOM account.',
	'closemyaccount-button-text' => 'Close my account',
	'closemyaccount-reactivate-button-text' => 'Reactivate my account',
	'closemyaccount-reactivate-page-title' => 'Reactivate my account',
	'closemyaccount-reactivate-intro' => '{{GENDER:$2|You}} have previously requested that we close your account. You still have $1 {{PLURAL:$1|day|days}} left until your account is closed. If you still wish to close your account, simply go back to browsing FANDOM. However, if you would like to reactivate your account, please click the button below and follow the instructions in the email.

Would you like to reactivate your account?',
	'closemyaccount-reactivate-requested' => 'An email has been sent to the address you had set for your account. Please click the link in the email to reactivate your account.',
	'closemyaccount-reactivate-error-id' => 'Please login to your account first to request reactivation.',
	'closemyaccount-reactivate-error-email' => 'No email was set for this account prior to requesting closure so it cannot be reactivated. Please [[Special:Contact|contact FANDOM]] if you have any questions.',
	'closemyaccount-reactivate-error-not-scheduled' => 'Account is not scheduled for closure.',
	'closemyaccount-reactivate-error-invalid-code' => '{{GENDER:$1|You}} appear to have used a confirmation code that has expired. Please check your email for a newer code you may have requested, or try requesting a new code by [[Special:UserLogin|logging in]] to the account you want to reactivate and following the instructions.',
	'closemyaccount-reactivate-error-empty-code' => 'A confirmation code needed to reactivate your account has not been provided. If you have requested your account be reactivated, please click the link in the email sent to you. Otherwise, [[Special:UserLogin|login]] to the account you want to reactivate in order to request a confirmation code.',
	'closemyaccount-reactivate-error-disabled' => 'This account has already been disabled. Please [[Special:Contact|contact FANDOM]] if you have any questions.',
	'closemyaccount-reactivate-error-failed' => 'An error occurred while attempting to reactivate this account. Please try again or [[Special:Contact|contact FANDOM]] if the issue persists.',
	'closemyaccount-reactivate-success' => 'Your account has been reactivated.',
	'closemyaccount-scheduled' => 'Your account has been successfully scheduled to be closed.

Please note you will have $1 {{PLURAL:$1|day|days}} from now to reactivate your account by [[Special:UserLogin|logging in]] and following the instructions you will see. After this waiting period, your account will be closed permanently and cannot be restored.',
	'closemyaccount-scheduled-failed' => 'An error occurred while attempting to schedule this account to be closed. Please [[Special:CloseMyAccount|try again]] or [[Special:Contact|contact FANDOM]] if the issue persists.',
);

$messages['qqq'] = array(
	'closemyaccount' => 'Special page name',
	'closemyaccount-desc' => '{{desc}}',
	'closemyaccount-intro-text' => 'Text displayed at the top of the Close My Account form.
* $1 is the number of days before the account is permanently closed
* $2 is the username',
	'closemyaccount-unconfirmed-email' => 'Warning message displayed when a user attempts to close their account when they do not have a confirmed email set on their account.',
	'closemyaccount-logged-in-as' => "Message on close account form informing the user which account they are logged in as to make sure they aren't closing the wrong account.
* $1 is the username",
	'closemyaccount-current-email' => 'Message on close account form informing the user which email is set for the account they are logged in as to make sure they have access to it.
* $1 is the email address
* $2 is the username',
	'closemyaccount-confirm' => 'Label for a checkbox above submit button on the account closure form.
* $1 is the username',
	'closemyaccount-button-text' => 'Text of the submit button to close your account',
	'closemyaccount-reactivate-button-text' => 'Text of the submit button to reactivate your account',
	'closemyaccount-reactivate-page-title' => 'Special page name of the reactivate account form.',
	'closemyaccount-reactivate-intro' => 'Text displayed at the top of the Reactivate My Account form.
* $1 is the number of days the user has left to reactivate their account
* $2 is the username',
	'closemyaccount-reactivate-requested' => 'Confirmation text displayed when a user has successfully requested their account be reactivated.',
	'closemyaccount-reactivate-error-id' => 'Error message displayed when trying to access the reactivate form without a valid ID.',
	'closemyaccount-reactivate-error-email' => 'Error message displayed when the user attempts to reactivate an account that does not have a confirmed email address.',
	'closemyaccount-reactivate-error-not-scheduled' => 'Error message displayed when the user attempts to reactivate an account that is not scheduled for closure.',
	'closemyaccount-reactivate-error-invalid-code' => 'Error message displayed when a user attempted to reactivate their account with an invalid or expired code.
* $1 is the username provided by the user',
	'closemyaccount-reactivate-error-empty-code' => 'Error message displayed when a user tries to reactivate their account without a confirmation code.',
	'closemyaccount-reactivate-error-disabled' => 'Error message displayed when the user attempts to reactivate an account that has already been closed.',
	'closemyaccount-reactivate-error-failed' => 'Error message displayed when reactivation of an account has failed.',
	'closemyaccount-reactivate-success' => "Success message after user re-activated his account. From now account isn't scheduled to be closed.",
	'closemyaccount-scheduled' => 'Success message displayed when the user has successfully requested their account is closed. $1 is the number of days the user has left to reactivate their account.',
	'closemyaccount-scheduled-failed' => 'Error message displayed when a request to close an account has failed.',
);

$messages['de'] = array(
	'closemyaccount' => 'Benutzerkonto schließen',
	'closemyaccount-desc' => 'Ermöglicht Benutzern, ihre Benutzerkonten zu schließen.',
	'closemyaccount-intro-text' => 'Schade, dass {{GENDER:$2|du}} dein Benutzerkonto schließen möchtest. FANDOM bietet jede Menge Wikis zu allen möglichen Themen und wir würden uns freuen, wenn du noch ein wenig bleibst und das Richtige für dich findest. Falls du ein Problem in deiner Community hast, zögere nicht, einen der [[Spezial:Benutzer/sysop|Admins dort]] um Hilfe zu bitten.

Wenn du dich dazu entschlossen hast, dein Benutzerkonto definitiv zu schließen, beachte die folgenden Hinweise:
* FANDOM kann Benutzerkonten nicht komplett zu entfernen, aber wir können sie deaktivieren. Das stellt sicher, dass das Konto geschlossen ist und nicht mehr benutzt werden kann.
* Diese Entscheidung kann nach dem Ablauf von $1 {{PLURAL:$1|Tag|Tagen}} NICHT wieder rückgängig gemacht werden und du wirst ein neues Konto anlegen müssen, wenn du FANDOM wieder beitreten möchtest.
* Dieser Prozess entfernt keinen deiner Beiträge von FANDOM, da diese Bearbeitungen der gesamten Community gehören.

Falls du genauer wissen möchtest, was bei der Deaktivierung eines Benutzerkontos passiert, schau dir unsere [[w:c:de:Hilfe:Benutzerkonto_stilllegen|Hilfeseite zum Thema]] an. Wenn du dir sicher bist, dass du dein Benutzerkonto deaktivieren möchtest, klicke bitte auf den untenstehenden Knopf.

Bitte beachte, dass du nach dem Abschicken $1 {{PLURAL:$1|Tag|Tage}} Zeit hast, um dein Benutzerkonto wieder zu aktivieren. Melde dich dazu an und folge den Hinweisen. Nach dieser Übergangszeit wird dein Benutzerkonto dauerhaft geschlossen und kann nicht wiederhergestellt werden.',
	'closemyaccount-unconfirmed-email' => 'Achtung: Du hast keine bestätigte E-Mail-Adresse mit diesem Benutzerkonto verbunden. Ohne eine bestätigte E-Mail-Adresse kannst du dein Konto in der Wartezeit nicht wieder aktivieren. Bitte überlege dir, eine E-Mail-Adresse in deinen [[Special:Preferences|Benutzereinstellungen]] anzugeben und zu bestätigen, bevor du fortfährst.',
	'closemyaccount-logged-in-as' => 'Du bist angemeldet als {{GENDER:$1|$1}}. [[Special:UserLogout|Das bist du nicht?]]',
	'closemyaccount-current-email' => '{{GENDER:$2|Deine}} E-Mail-Adresse lautet $1. [[Special:Preferences|Möchtest du sie ändern?]]',
	'closemyaccount-confirm' => '{{GENDER:$1|Ich}} habe die [[w:c:de:Hilfe:Benutzerkonto_stilllegen|Hilfeseite zur Stilllegung von Benutzerkonten]] gelesen und bestätige, dass ich mein FANDOM-Konto schließen möchte.',
	'closemyaccount-button-text' => 'Benutzerkonto schließen',
	'closemyaccount-reactivate-button-text' => 'Benutzerkonto reaktivieren',
	'closemyaccount-reactivate-page-title' => 'Benutzerkonto reaktivieren',
	'closemyaccount-reactivate-intro' => '{{GENDER:$2|Du}} hast die Schließung deines Benutzerkontos beantragt. Du hast noch $1 {{PLURAL:$1|Tag|Tage}}, bevor dein Benutzerkonto dauerhaft geschlossen wird. Wenn du weiterhin möchtest, dass dein Konto deaktiviert wird, musst du nichts weiter tun. Falls du dein Benutzerkonto doch wieder aktivieren möchtest, klicke bitten den folgenden Knopf und folge den Anweisungen in der E-Mail an dich.

Möchtest du dein Benutzerkonto wieder aktivieren?',
	'closemyaccount-reactivate-requested' => 'Eine E-Mail wurde an die in deinem Benutzerkonto angegebene Adresse geschickt. Bitte klicke auf den Link in der E-Mail, um dein Benutzerkonto zu reaktivieren.',
	'closemyaccount-reactivate-error-id' => 'Bitte melde dich mit deinem Benutzerkonto an, um die Reaktivierung zu beantragen.',
	'closemyaccount-reactivate-error-email' => 'Für das Benutzerkonto war vor der Beantragung der Schließung keine E-Mail-Adresse angegeben, so dass es nicht wieder aktiviert werden kann. Bitte [[Special:Contact|kontaktiere FANDOM]], falls du Fragen hast.',
	'closemyaccount-reactivate-error-not-scheduled' => 'Das Benutzerkonto ist nicht für eine Schließung vorgesehen.',
	'closemyaccount-reactivate-error-invalid-code' => 'Du scheinst einen Bestätigungscode zu verwenden, der nicht mehr gültig ist. Bitte prüfe deine E-Mail auf einen neueren Code, den du beantragt hast oder fordere einen neuen Code an, indem du dich mit dem Benutzerkonto [[Special:UserLogin|anmeldest]], das du reaktivieren möchtest - und dann den Anweisungen folgst.',
	'closemyaccount-reactivate-error-empty-code' => 'Zur Reaktivierung des Benutzerkontos ist ein Bestätigungscode notwendig, der aber nicht angegeben wurde. Wenn du dein Benutzerkonto reaktivieren möchtest, klicke bitte den Link in der E-Mail an, die dir gesendet wurde. Ansonsten [[Special:UserLogin|melde dich mit dem Benutzerkonto an]], das du reaktivieren möchtest, und fordere einen Bestätigungscode an.',
	'closemyaccount-reactivate-error-disabled' => 'Dieses Benutzerkonto wurde bereits deaktiviert. Bitte [[Spezial:Kontakt|kontaktiere FANDOM]], falls du Fragen hast.',
	'closemyaccount-reactivate-error-failed' => 'Beim Reaktivieren dieses Benutzerkontos ist ein Fehler aufgetreten. Bitte versuche es erneut oder [[Spezial:Kontakt|kontaktiere FANDOM]], falls das Problem bestehen bleibt.',
	'closemyaccount-scheduled' => 'Dein Benutzerkonto wurde erfolgreich für eine Schließung vorgemerkt.

Bitte beachte, dass du ab sofort $1 {{PLURAL:$1|Tag|Tage}} Zeit hast, dein Benutzerkonto zu reaktivieren. Dazu musst du dich [[Special:UserLogin|anmelden]] und den Anweisungen folgen. Nach dieser Wartezeit wird dein Benutzerkonto dauerhaft geschlossen und kann nicht wiederhergestellt werden.',
	'closemyaccount-scheduled-failed' => 'Beim Reaktivieren dieses Benutzerkontos ist ein Fehler aufgetreten. Bitte [[Spezial:CloseMyAccount|probiere es nochmal]] oder [[Spezial:Kontakt|kontaktiere FANDOM]], falls das Problem bestehen bleibt.',
	'closemyaccount-reactivate-success' => 'Dein Benutzerkonto wurde wieder aktiviert.',
	'closemyaccount-reactivate-error-fbconnect' => '{{GENDER:$1|Du}} hast die Schließung deines Benutzerkontos beantragt. Falls du Dein Konto wieder aktivieren möchtest, rufe bitte die [[Special:CloseMyAccount/reactivate|Reaktivierungsseite für dein Benutzerkonto]] auf und folge dort den Anweisungen.',
);

$messages['es'] = array(
	'closemyaccount' => 'Cerrar mi cuenta',
	'closemyaccount-desc' => 'Permite a los usuarios cerrar sus propias cuentas.',
	'closemyaccount-intro-text' => 'Lamentamos que quieras cerrar tu cuenta. FANDOM tiene comunidades de diferentes temas y deseamos que te quedes y encuentres el tema que sea para ti. Si estás teniendo problemas dentro de una comunidad, por favor no dudes en contactarte con tu [[{{#Special:ListUsers/sysop}}|administrador local]] para recibir ayuda y sugerencia.

Si has decidido definitivamente cerrar tu cuenta, por favor ten en cuenta lo siguiente:
* FANDOM no tiene la habilidad de cerrar cuentas completamente, pero podemos desactivarlas. Esto asegurará que la cuenta sea bloqueada y que no pueda ser usada.
* Este proceso NO es reversible después de que hayan pasado $1 {{PLURAL:$1|día|días}}, si deseas regresar a FANDOM vas a tener que crear una nueva cuenta.
* Este proceso no removerá tus contribuciones de una comunidad específica en FANDOM, ya que estas contribuciones pertenecen a la comunidad.

Si necesitas más información de lo que una cuenta cerrada realmente hace, puedes visitar nuestra página de [[w:c:comunidad:Ayuda:Cerrar_mi_cuenta|ayuda sobre como cerrar una cuenta]]. Si estás seguro de querer cerrar tu cuenta, por favor has clic en el botón de abajo.

Ten en cuenta que tendrás $1 {{PLURAL:$1|día|días}} después de hacer el pedido para reactivar tu cuenta ingresando en ella y siguiendo las instrucciones. Después del periodo de espera, tu cuenta será cerrada permanentemente y no podrá ser restaurada.',
	'closemyaccount-unconfirmed-email' => 'Advertencia: No tienes una dirección de correo electrónico asociada con esta cuenta. No serás capaz de reactivar tu cuenta dentro del período de espera sin una dirección de correo electrónico. Por favor considera asociar una en [[{{#Special:Preferences}}|tus preferencias]] antes de proceder.',
	'closemyaccount-logged-in-as' => 'Estás conectado como {{GENDER:$1|$1}}. [[{{#Special:UserLogout}}|¿No eres tú?]]',
	'closemyaccount-current-email' => '{{GENDER:$2|Tu}} correo electrónico es fijado como $1. [[{{#Special:Preferences}}|¿Deseas cambiarlo?]]',
	'closemyaccount-confirm' => '{{GENDER:$1|Yo}} he leído la página de [[w:c:comunidad:Ayuda:Cerrar_mi_cuenta|ayuda sobre como cerrar mi cuenta]] y confirmo que deseo desactivar mi cuenta de FANDOM.',
	'closemyaccount-button-text' => 'Cerrar mi cuenta',
	'closemyaccount-reactivate-button-text' => 'Reactivar mi cuenta',
	'closemyaccount-reactivate-page-title' => 'Reactivar mi cuenta',
	'closemyaccount-reactivate-intro' => 'Has solicitado previamente que cerremos tu cuenta. Todavía tienes $1 {{PLURAL:$1|día|días}} hasta que tu cuenta sea cerrada. Si todavía deseas cerrar tu cuenta, simplemente vuelve a navegar en FANDOM. Sin embargo, si deseas reactivar tu cuenta, por favor has clic en el botón de abajo y sigue las instrucciones presentadas en el correo electrónico.

¿Te gustaría reactivar tu cuenta?',
	'closemyaccount-reactivate-requested' => 'Se envió un correo electrónico a la dirección que asociaste a tu cuenta. Por favor, haz clic en el enlace enviado para reactivar tu cuenta.',
	'closemyaccount-reactivate-error-id' => 'Por favor ingresa a tu cuenta primero para solicitar la reactivación.',
	'closemyaccount-reactivate-error-email' => 'Ningún correo electrónico fue fijado para esta cuenta antes de solicitar el cierre así que no puede ser reactivada. Si tienes alguna pregunta, por favor [[{{#Special:Contact}}|contáctate con FANDOM]].',
	'closemyaccount-reactivate-error-not-scheduled' => 'La cuenta no está programada para ser cerrada.',
	'closemyaccount-reactivate-error-invalid-code' => 'Parece que has utilizado un código de confirmación que ha expirado. Por favor revisa tu correo electrónico por un código más reciente que hayas solicitado, o trata de solicitar un nuevo código al [[{{#Special:UserLogin}}|ingresar]] a la cuenta que deseas reactivar y sigue las instrucciones.',
	'closemyaccount-reactivate-error-empty-code' => 'No se ha proporcionado un código de confirmación necesario para reactivar su cuenta. Si has solicitado la reactivación de tu cuenta, por favor haz clic en el enlace enviado. De lo contrario, [[{{#Special:UserLogin}}|ingresa]] a la cuenta que deseas reactivar para solicitar un código de confirmación.',
	'closemyaccount-reactivate-error-disabled' => 'Esta cuenta ya ha sido desactivada. Si tienes alguna pregunta, por favor, [[{{#Special:Contact}}|contáctate con el equipo de soporte comunitario]].',
	'closemyaccount-reactivate-error-failed' => 'Se ha producido un error al intentar reactivar esta cuenta. Por favor, inténtalo de nuevo o [[{{#Special:Contact}}|contáctate con el equipo de soporte comunitario]] si el problema persiste.',
	'closemyaccount-scheduled' => 'Tu cuenta se ha programado exitosamente para ser cerrada.

Ten en cuenta que tendrás $1 {{PLURAL:$1|día|días}} después de hacer el pedido para reactivar tu cuenta [[{{#Special:UserLogin}}|ingresando]] y siguiendo las instrucciones. Después de este período de espera, tu cuenta será cerrada permanentemente y no podrá ser restaurada.',
	'closemyaccount-scheduled-failed' => 'Se ha producido un error al intentar programar esta cuenta para que sea cerrada. Por favor [[{{#Special:CloseMyAccount}}|intenta de nuevo]] o [[{{#Special:Contact}}|contáctate con el equipo de soporte comunitario]] si el problema persiste.',
	'closemyaccount-reactivate-success' => 'Tu cuenta ha sido reactivada.',
	'closemyaccount-reactivate-error-fbconnect' => '{{GENDER:$1|Tu}} han solicitado previamente que cerrar tu cuenta. Si deseas reactivar tu cuenta, ingresa a la [[{{#Special:CloseMyAccount/reactivate}}|página de reactivación de cuenta]] y sigue las instrucciones.',
);

$messages['fi'] = array(
	'closemyaccount-confirm' => 'Olen lukenut [[w:Help:Close my account|tilin poistamiseen liittyvän ohjesivun]] ja vahvistan, että haluan sulkea Wikia-tilini.',
	'closemyaccount-intro-text' => "Onpa ikävää, että haluat sulkea käyttäjätilisi. Wikiassa on runsaasti yhteisöjä kaikenlaisista aiheista ja meistä olisi mahtavaa, jos vielä löytäisit sen juuri sinulle sopivan. Mikäli sinulla on paikallinen ongelma jossakin wikiassa, ethän epäröi kysyä neuvoa kyseisen wikian [[Special:Listadmins|ylläpitäjiltä]].

Mikäli olet päättänyt, että ehdottomasti haluat sulkea tilisi, olethan tietoinen seuraavista seikoista:
* Wikialla ei ole mahdollisuutta poistaa tiliä täydellisesti, joskin se voidaan poistaa käytöstä. Tämä varmistaa sen, että tili on suljettu ja että sitä ei voi käyttää.
* Tätä prosessia '''ei''' voi peruuttaa enää $1 päivän jälkeen, vaan sinun on luotava kokonaan uusi tili jos haluat palata Wikiaan.
* Tämä prosessi ei myöskään poista muokkauksesi mihinkään wikiayhteisöön, sillä nämä muokkaukset kuuluvat yhteisölle kokonaisuutena.

Mikäli haluat lisätietoja siitä, mitä tilin sulkeminen tarkalleen tarkoittaa, voit lukea [[w:Help:Close my account|tilin poistamiseen liittyvän ohjesivun]]. Jos tämänkin jälkeen olet varma, että haluat sulkea tilisi, käytä nappia alla.

'''Huom:''' pyynnön jätettyäsi sinulla on $1 päivää aikaa uudelleenaktivoida tilisi kirjautumalla sisään ja seuraamalla näkemiäsi ohjeita. Tämän odotusajan jälkeen tilisi on pysyvästi suljettu eikä sitä voi palauttaa.",
	'closemyaccount-reactivate-error-disabled' => 'Tämä tili on jo suljettu. Mikäli sinulla on kysyttävää, ole hyvä ja [[Special:Contact|ota Wikiaan yhteyttä]].',
	'closemyaccount-reactivate-error-failed' => 'Tiliä aktivoitaessa tapahtui virhe. Ole hyvä ja yritä uudelleen tai [[Special:Contact|ota Wikiaan yhteyttä]] mikäli ongelma jatkuu.',
	'closemyaccount-reactivate-intro' => 'Olet aiemmin pyytänyt tilisi sulkemista. Sinulla on enää $1 {{PLURAL:$1|päivä|päivää}} aikaa siihen, että tilisi poistetaan käytöstä. Mikäli haluat yhä tilisi poistettavan, palaa vain selaamaan Wikiaa. Jos kuitenkin haluat uudelleenaktivoida tilisi, napsauta nappia alla ja seuraa sähköpostiisi saapuvia ohjeita.

Haluatko aktivoida tilisi uudelleen?',
	'closemyaccount-scheduled-failed' => 'Ajastettua poistoa määritettäessä tapahtui virhe. Ole hyvä ja [[Special:CloseMyAccount|yritä uudelleen]] tai [[w:c:yhteiso:ota yhteyttä|ota meihin yhteyttä]] mikäli ongelma jatkuu.',
	'closemyaccount-button-text' => 'Poista tilini käytöstä',
	'closemyaccount-current-email' => 'Sähköpostiosoitteeksesi on asetettu $1. [[Special:Preferences|Haluatko muuttaa sitä?]]',
	'closemyaccount-logged-in-as' => 'Olet kirjautuneena käyttäjänä $1. [[Special:UserLogout|Joku muu, kuin sinä?]]',
	'closemyaccount-reactivate-button-text' => 'Aktivoi tilini uudelleen',
	'closemyaccount-reactivate-error-email' => 'Tälle tilille ei asetettu sähköpostiosoitetta ennen sen sulkemista. Mikäli sinulla on kysyttävää, ole hyvä ja  [[Special:Contact|ota Wikiaan yhteyttä]].',
	'closemyaccount-reactivate-error-empty-code' => 'Tilisi uudelleenaktivointiin vaadittua vahvistuskoodia ei annettu. Mikäli olet pyytänyt tilisi sulkemista, ole hyvä ja napsauta  lähettämästämme sähköpostista löytyvää linkkiä. Muussa tapauksessa voit pyytää vahvistuskoodin [[Special:UserLogin|kirjautumalla]] tiliin, jonka haluat aktivoida uudelleen.',
	'closemyaccount-reactivate-error-id' => 'Pyytääksesi tilisi uudelleenaktivointia, ole hyvä ja kirjaudu sisään.',
	'closemyaccount-reactivate-error-invalid-code' => 'Olet ilmeisesti käyttänyt vanhentunutta vahvistuskoodia. Ole hyvä ja tarkista sähköpostisi uudemman koodin varalta, tai pyydä uusi koodi [[Special:UserLogin|kirjautumalla tilille]], jonka haluat aktivoida sekä seuraamalla ohjeita.',
	'closemyaccount-reactivate-error-not-scheduled' => 'Tiliä ei ole asetettu poistettavaksi.',
	'closemyaccount-reactivate-page-title' => 'Aktivoi tilini uudelleen',
	'closemyaccount-reactivate-requested' => 'Asettamaasi sähköpostiosoitteeseen on lähetetty viesti. Ole hyvä ja napsauta viestistä löytyvää linkkiä aktivoidaksesi tilisi uudelleen.',
	'closemyaccount-scheduled' => 'Tilillesi on onnistuneesti määritetty ajastettu poisto.

Huomaathan, että sinulla on $1 {{PLURAL:$1|päivä|päivää}} aikaa aktivoida tilisi uudelleen [[Special:UserLogin|kirjautumalla sisään]] ja seuraamalla näkemiäsi ohjeita. Tämän odotusajan jälkeen tilisi poistetaan käytöstä pysyvästi eikä sitä voida palauttaa.',
	'closemyaccount-unconfirmed-email' => 'Varoitus: tähän tiliin ei liity vahvistettua sähköpostiosoitetta. Ilman sellaista et voi uudelleenaktivoida tiliäsi odotusperiodin aikana. Harkitsethan sähköpostiosoitteen asettamista [[Special:Preferences|asetuksissasi]] ennen jatkamista.',
	'closemyaccount' => 'Käyttäjätilin sulkeminen',
);

$messages['fr'] = array(
	'closemyaccount' => 'Fermer mon compte',
	'closemyaccount-desc' => 'Permet aux utilisateurs de fermer leur compte.',
	'closemyaccount-intro-text' => "Nous sommes désolés que vous souhaitiez désactiver votre compte. FANDOM a de nombreux wikis sur toutes sortes de sujets et nous aimerions que vous restiez et trouviez celui qui vous convient. Si vous avez un problème sur votre wiki, n'hésitez pas à demander de l'aide ou des conseils aux [[Special:ListUsers/sysop|administrateurs locaux]].

Si vous avez finalement décidé que vous souhaitez désactiver votre compte, sachez que :
* FANDOM n'a pas la possibilité de retirer complètement les comptes, mais nous pouvons les désactiver. Cela assure que le compte est verrouillé et ne peut pas être utilisé.
* Cette opération n'est PAS réversible après $1 {{PLURAL:$1|jour|jours}} et vous devrez créer un nouveau compte si vous souhaitez revenir sur FANDOM.
* Cette opération ne retirera pas vos contributions sur une communauté FANDOM en particulier, comme ces contributions appartiennent à la communauté et forment un tout.

Si vous avez besoin de plus d'informations sur ce que la désactivation d'un compte fait réellement, vous pouvez visiter notre [[w:fr:Aide:Fermer mon compte|page d'aide sur la désactivation de votre compte]]. Si vous êtes {{GENDER:$2|sûr|sûre}} de vouloir fermer votre compte, veuillez cliquer sur le bouton ci-dessous.

Veuillez noter que vous aurez $1 {{PLURAL:$1|jour|jours}} après avoir effectué cette demande pour réactiver votre compte en vous connectant et en suivant les instructions affichées. Passé ce délai, votre compte sera fermé définitivement et ne pourra pas être restauré.",
	'closemyaccount-unconfirmed-email' => "Attention : Vous n'avez pas confirmé l'adresse e-mail associée avec ce compte. Vous ne pourrez pas réactiver votre compte durant la période de rétractation sans en avoir une. Veuillez réfléchir à indiquer une adresse e-mail dans [[Special:Preferences|vos préférences]] avant de continuer.",
	'closemyaccount-logged-in-as' => "Vous êtes {{GENDER:$1|connecté|connectée}} en tant que $1. [[Special:UserLogout|Ce n'est pas vous ?]]",
	'closemyaccount-current-email' => '{{GENDER:$2|Votre}} adresse e-mail est $1. [[Special:Preferences|Vous souhaitez la changer ?]]',
	'closemyaccount-confirm' => "{{GENDER:$1|J'}}ai lu la [[w:fr:Aide:Fermer_mon_compte|page d'aide sur la fermeture de mon compte]] et je confirme que je souhaite désactiver mon compte FANDOM.",
	'closemyaccount-button-text' => 'Fermer mon compte',
	'closemyaccount-reactivate-button-text' => 'Réactiver mon compte',
	'closemyaccount-reactivate-page-title' => 'Réactiver mon compte',
	'closemyaccount-reactivate-intro' => "Vous avez demandé auparavant à ce que nous fermions votre compte. Il reste encore $1 {{PLURAL:$1|jour|jours}} avant que votre compte ne soit fermé. Si vous souhaitez toujours fermer votre compte, retournez simplement à la navigation de FANDOM. Toutefois, si vous souhaitez réactiver votre compte, veuillez cliquer sur le bouton ci-dessous et suivre les instructions dans l'e-mail que vous allez recevoir.

Souhaitez-vous réactiver votre compte ?",
	'closemyaccount-reactivate-requested' => "Un e-mail a été envoyé a l'adresse que vous avez définie pour ce compte. Veuillez cliquer sur le lien dans cet e-mail pour réactiver votre compte.",
	'closemyaccount-reactivate-error-id' => "Veuillez d'abord vous connecter avant de demander la réactivation.",
	'closemyaccount-reactivate-error-email' => "Aucune adresse e-mail n'a été définie pour ce compte avant de demander la fermeture, il ne peut donc pas être réactivé. Veuillez [[Special:Contact|contacter Wikia]] si vous avez des questions.",
	'closemyaccount-reactivate-error-not-scheduled' => "La fermeture du compte n'est pas planifiée.",
	'closemyaccount-reactivate-error-invalid-code' => "Il semble que vous ayez utilisé un code de confirmation qui a expiré. Veuillez vérifier votre boîte aux lettres pour un code plus récent que vous auriez demandé ou essayez d'en demander un nouveau en vous [[Special:UserLogin|connectant]] au compte que vous souhaitez réactiver et suivez les instructions.",
	'closemyaccount-reactivate-error-empty-code' => "Un code de confirmation est nécessaire pour réactiver votre compte et n'a pas été indiqué. Si vous avez demandé à ce que votre compte soit réactivé, veuillez cliquer sur le lien dans l'e-mail que nous vous avons envoyé. Sinon, [[Special:UserLogin|connectez-vous]] avec le compte que vous souhaitez réactiver afin de demander un code de confirmation.",
	'closemyaccount-reactivate-error-disabled' => 'Ce compte a déjà été désactivé. Veuillez [[Special:Contact|contacter FANDOM]] si vous avez des questions.',
	'closemyaccount-reactivate-error-failed' => 'Une erreur est survenue en essayant de réactiver ce compte. Veuillez réessayer ou [[Special:Contact|contactez FANDOM]] si le problème persiste.',
	'closemyaccount-scheduled' => 'La fermeture de votre compte a été planifiée avec succès.

Veuillez noter que vous avez  $1 {{PLURAL:$1|jour|jours}} à partir de maintenant pour réactiver votre compte en [[Special:UserLogin|vous connectant]] et en suivant les instructions affichées. Après cette période de rétractation, votre compte sera définitivement fermé et ne pourra pas être restauré.',
	'closemyaccount-scheduled-failed' => 'Une erreur est survenue en tentant de planifier la fermeture de ce compte. Veuillez [[Special:CloseMyAccount|réessayer]] ou [[Special:Contact|contactez FANDOM]] si le problème persiste.',
	'closemyaccount-reactivate-success' => 'Votre compte a été réactivé.',
	'closemyaccount-reactivate-error-fbconnect' => '{{GENDER:$1|Vous}} avez demandé précédemment de fermer votre compte. Si vous souhaitez réactiver votre compte, veuillez vous rendre sur la [[Special:CloseMyAccount/reactivate|page de réactivation de compte]] et suivre les instructions affichées.',
);

$messages['it'] = array(
	'closemyaccount' => 'Chiudi il mio account',
	'closemyaccount-desc' => 'Consente agli utenti di chiudere il proprio account.',
	'closemyaccount-intro-text' => "Siamo spiacenti che tu voglia disattivare il tuo account. FANDOM dispone di numerose comunità di tanti argomenti diversi e saremmo lieti se rimanessi e trovassi quella giusta per te. Se hai un problema locale con la tua comunità, contatta pure [[Special:ListUsers/sysop|gli amministratori]] per assistenza e consigli.

Se hai deciso di disattivare il tuo account in modo permanente, tieni conto che:
* FANDOM non è in grado di rimuovere completamente gli account, ma possiamo disattivarli. Ciò assicurerà che l'account sia bloccato e non possa essere usato.
* Questo processo NON sarà più reversibile dopo $1 {{PLURAL:$1|giorno|giorni}} e dovrai quindi creare un nuovo account se desideri iscriverti nuovamente a FANDOM.
* Questo processo non rimuoverà i tuoi contributi da una particolare comunità di FANDOM, in quanto tali contributi appartengono all'intera comunità.

Se hai bisogno di ulteriori informazioni su ciò che fa effettivamente la disattivazione di un account, puoi visitare la [[w:it:Aiuto:Chiudere un account|pagina d'aiuto]]. Se sei certo di voler chiudere il tuo account, fai clic sul link seguente.

Ti preghiamo di notare che avrai $1 {{PLURAL:$1|giorno|giorni}} dopo l'inoltro di questa richiesta per riattivare il tuo account eseguendo l'accesso e seguendo le istruzioni visualizzate. Dopo questo periodo di attesa il tuo account sarà chiuso in maniera permanente e non potrà più essere ripristinato.",
	'closemyaccount-unconfirmed-email' => "Attenzione: Non hai un indirizzo email confermato associato a questo account. Non potrai riattivare il tuo account nel periodo di attesa senza di esso. Per favore, considera l'idea di impostare un account email nelle [[Special:Preferences|tue preferenze]] prima di procedere.",
	'closemyaccount-logged-in-as' => "Hai effettuato l'accesso come {{GENDER:$1|$1}}. [[Special:UserLogout|Non sei tu?]]",
	'closemyaccount-current-email' => 'La tua email è impostata come $1. [[Special:Preferences|Desideri cambiarla?]]',
	'closemyaccount-confirm' => "Ho letto la [[w:it:Aiuto:Chiudere un account|pagina d'aiuto sulla chiusura dell'account]] e confermo di voler disattivare il mio account FANDOM.",
	'closemyaccount-button-text' => 'Chiudi il mio account',
	'closemyaccount-reactivate-button-text' => 'Riattiva il mio account',
	'closemyaccount-reactivate-page-title' => 'Riattiva il mio account',
	'closemyaccount-reactivate-intro' => "Hai richiesto in precedenza che chiudessimo il tuo account. Hai ancora $1 {{PLURAL:$1|giorno|giorni rimasti}} prima che il tuo account venga chiuso. Se desideri ancora chiudere il tuo account, ritorna semplicemente a navigare su FANDOM. Tuttavia, se desideri riattivare il tuo account, fai clic sul pulsante seguente e segui le istruzioni contenute nell'email.

Desideri riattivare il tuo account?",
	'closemyaccount-reactivate-requested' => "Un'email è stata inviata all'indirizzo associato al tuo account. Per favore clicca sul link nell'email per riattivare il tuo account.",
	'closemyaccount-reactivate-error-id' => 'Per favore, accedi prima al tuo account per richiederne la riattivazione.',
	'closemyaccount-reactivate-error-email' => 'Nessuna email è stata impostata per questo account prima della richiesta di chiusura, per cui non può essere riattivato. Per favore, [[Special:Contact|contatta FANDOM]] per domande.',
	'closemyaccount-reactivate-error-not-scheduled' => "Non è prevista la chiusura dell'account.",
	'closemyaccount-reactivate-error-invalid-code' => "Sembra che tu abbia usato un codice di conferma scaduto. Per favore controlla la tua email per un codice più recente che potresti aver richiesto o prova a richiedere un nuovo codice [[Special:UserLogin|effettuando l'accesso]] all'account che vuoi riattivare e seguendo le istruzioni.",
	'closemyaccount-reactivate-error-empty-code' => "Non è stato fornito il codice di conferma necessario per riattivare il tuo account.  Se hai richiesto la riattivazione del tuo account, per favore clicca sull'indirizzo nella email che ti è stata inviata. Altrimenti, [[Special:UserLogin|accedi]] all'account che vuoi riattivare per poter richiedere un codice di conferma.",
	'closemyaccount-reactivate-error-disabled' => 'Questo account è già stato disattivato. Sei hai domande [[Special:Contact|contatta FANDOM]].',
	'closemyaccount-reactivate-error-failed' => 'Si è verificato un errore durante il tentativo di riattivazione di questo account. Per favore riprova o [[Special:Contact|contatta FANDOM]] se il problema persiste.',
	'closemyaccount-scheduled' => "La chiusura del tuo account è stata programmata con successo.

Per favore ricordati che hai $1 {{PLURAL:$1|giorno|giorni}} a disposizione da adesso per riattivare il tuo account [[Special:UserLogin|eseguendo l'accesso]] e seguendo le istruzioni che compariranno. Dopo questo periodo di attesa, il tuo account sarà chiuso definitivamente e non potrà essere riattivato.",
	'closemyaccount-scheduled-failed' => 'Si è verificato un errore durante il tentativo di pianificare la chiusura di questo account. Per favore [[Special:CloseMyAccount|riprova]] o [[Special:Contact|contatta FANDOM]] se il problema persiste.',
	'closemyaccount-reactivate-success' => 'Il tuo account è stato riattivato.',
	'closemyaccount-reactivate-error-fbconnect' => "Hai richiesto in precedenza la chiusura del tuo account. Se volessi riattivare il tuo account, vai sulla [[Special:CloseMyAccount/reactivate|pagina di riattivazione dell'account]] e segui le istruzioni visualizzate.",
);

$messages['ja'] = array(
	'closemyaccount' => 'アカウントを閉じる',
	'closemyaccount-desc' => '自分のアカウントを閉じる',
	'closemyaccount-intro-text' => '{{GENDER:$2|あなた}}のアカウントの無効化リクエストが送信されました。FANDOMには様々なトピックのバラエティ豊かなコミュニティがありますので、今後もし興味のあるコミュニティがあればご参加いただけましたら幸いです。ご自身が関わっているコミュニティで問題が発生している場合には、お気軽に[[Special:ListUsers/sysop|アドミン]]にお知らせください。

アカウントを無効化する場合は、以下の点にご留意ください。
* FANDOMでは、アカウントを完全に削除することはできませんが、無効にすることはできます。この作業を行うとアカウントがロックされ、使用できなくなります。
*無効化手続きは$1{{PLURAL:$1|日|日}}経過すると元に戻すことができなくなります。再度FANDOMに参加される場合、新たにアカウントを作成していただく必要があります。
*無効化手続きを行っても、これまでにFANDOMコミュニティに投稿された内容は削除されません。投稿はすべてコミュニティ全体の資産となります。

アカウント無効化のさらなる詳細は、[[w:c:ja.community:ヘルプ:アカウントの利用を停止する|アカウントの無効化に関するヘルプページ]]をご参照ください。アカウントを無効化するには、次のボタンをクリックしてください。

このリクエストを送信されてから$1{{PLURAL:$1|日間|日間}}は、アカウントにログインし画面の手順に沿って操作することで、再度アカウントを有効化することが可能です。この期間を過ぎると、アカウントが完全に無効となり、復元することができなくなりますのでご注意ください。',
	'closemyaccount-unconfirmed-email' => '警告: このアカウントで承認されているメールアドレスがありません。あなたのアカウントを再有効化するには、承認済みのメールアドレスが必要です。手続きに入る前に[[Special:Preferences|個人設定]]にてメールアドレスを設定して下さい。',
	'closemyaccount-logged-in-as' => 'あなたは {{GENDER:$1|$1}} としてログインしています。[[Special:UserLogout|別人ですか？]]',
	'closemyaccount-current-email' => 'あなたの登録メールアドレスは $1 です。[[Special:Preferences|変更をご希望ですか？]]',
	'closemyaccount-confirm' => '{{GENDER:$1|私}}は、[[w:c:ja.community:ヘルプ:アカウントの利用を停止する|アカウントを閉じる]]を読み、自身のFANDOMアカウントを無効化することに同意します。',
	'closemyaccount-button-text' => 'アカウントを閉じる',
	'closemyaccount-reactivate-button-text' => 'アカウントを再有効化する',
	'closemyaccount-reactivate-page-title' => 'アカウントを再有効化する',
	'closemyaccount-reactivate-intro' => 'FANDOMでは、{{GENDER:$2|あなた}} からアカウント無効化リクエストを受け取りました。アカウントが完全に無効となるまであと$1{{PLURAL:$1|日間|日間}} あります。アカウントを完全に無効としたい場合、特に追加のアクションは必要ありません。アカウントを再開する場合は、下のボタンをクリックし、受信されたメールに記載の手順に従ってください。

アカウントを再開しますか？',
	'closemyaccount-reactivate-requested' => 'あなたのアカウントで設定されたアドレスに、メールが送信されました。アカウントを再有効化するにはメールにあるリンクをクリックして下さい。',
	'closemyaccount-reactivate-error-id' => '再有効化をご希望の場合、はじめにあなたのアカウントにログインして下さい。',
	'closemyaccount-reactivate-error-email' => '再有効化に必要なメールアドレスがあなたのアカウントで設定されておりません。ご不明点など[[Special:Contact|ウィキアまで]]お問い合わせください。',
	'closemyaccount-reactivate-error-not-scheduled' => 'アカウントを閉じる予定はありません。',
	'closemyaccount-reactivate-error-invalid-code' => '有効期限が切れている承認コードを使用していると表示されています。メールにて送られた新しいコードを確認するか、[[Special:UserLogin|ログイン]] からアカウントを再有効化する新しいコードをリクエストし、手順を踏んで下さい。',
	'closemyaccount-reactivate-error-empty-code' => 'あなたのアカウントを再有効化するのに必要な承認コードが指定されていません。アカウントの再有効化をしたい場合は、送信されたメール内にあるリンクをクリックして手続きを行って下さい。また承認コードをリクエストするためには、再有効化したいアカウントで[[Special:UserLogin|ログイン]]して下さい。',
	'closemyaccount-reactivate-error-disabled' => 'このアカウントは無効化されています。ご不明な点は[[Special:Contact|FANDOMにお問い合わせ]]ください。',
	'closemyaccount-reactivate-error-failed' => 'このアカウントを有効化する際にエラーが発生しました。お手数ですが、もう一度お試しください。それでもこの問題が解決しない場合は、[[Special:Contact|FANDOMにお問い合わせ]]ください。',
	'closemyaccount-scheduled' => 'あなたのアカウントを無効化する手続きをしています。

今から$1 {{PLURAL:$1|day|days}} 日間は、[[Special:UserLogin|ログイン]]からあなたのアカウントの再有効化することができます。詳細は手順にてご確認ください。この期間を過ぎるとあなたのアカウントは永久に無効化され、再度有効化することはできません。',
	'closemyaccount-scheduled-failed' => 'アカウントを無効化する際にエラーが発生しました。お手数ですが、[[Special:CloseMyAccount|もう一度お試しください]]。それでもこの問題が解決しない場合は、[[Special:Contact|FANDOMにお問い合わせ]]ください。',
	'closemyaccount-reactivate-success' => 'アカウントが再開されました。',
	'closemyaccount-reactivate-error-fbconnect' => '{{GENDER:$1|あなた}}は、アカウントの無効化をリクエストされました。このアカウントの再開をご希望の場合は、[[特別:アカウント停止/reactivate|アカウントの再開ページ]]に移動して画面の手順に沿って行ってください。',
);

$messages['ko'] = array(
	'closemyaccount-confirm' => '저는 [[Help:Close_my_account|계정 비활성화에 대한 도움말 문서]]를 읽었고, 확실히 위키아 계정을 비활성화하고 싶습니다.',
	'closemyaccount-intro-text' => '계정을 비활성화하시게 되어 정말 유감입니다. 위키아에는 다양한 주제를 가진 수많은 커뮤니티가 존재하며 저희는 귀하가 위키아에 남아 수많은 커뮤니티 중에서 맘에 드는 커뮤니티를 찾아 함께 하시길 바랍니다. 만약 귀하가 속하신 커뮤니티와 문제가 발생하셨다면 [[Special:ListUsers/sysop|해당 커뮤니티의 관리자]]에게 도움을 받으실 수도 있습니다.

계정을 비활성화하시기 전에 다음 사항을 명심해주세요:
* 위키아에는 계정을 완전히 삭제하는 기능이 없습니다. 대신 계정을 비활성화할 수 있습니다. 비활성화된 계정은 사용할 수 없게 됩니다.
* $1일이 지나면 계정 비활성화를 다시 해제할 수 없습니다. 이 기간이 지난 후에 다시 위키아에 참여하시려면 새로 계정을 만드셔야 합니다.
* 계정을 비활성화한다고 해서 귀하의 기여까지 삭제되는 것은 아닙니다. 귀하의 기여는 각 커뮤니티에 귀속되어 있습니다.

더 자세한 정보는 [[Help:Close_my_account|도움말 문서 (영어)]]를 참고하세요. 정말 계정을 비활성화하시려면 아래 버튼을 눌러 주세요.

계정 비활성화 요청을 보낸 후 $1일 이내에 다시 로그인하시면 짧은 과정 이후에 다시 계정을 활성화하실 수 있습니다. 이 기간이 끝나면 귀하의 계정은 완전히 비활성화되며 다시 복구할 수 없습니다.',
	'closemyaccount-button-text' => '계정 비활성화',
	'closemyaccount-current-email' => "귀하의 이메일 주소는 지금, '$1'로 설정되어 있습니다. [[Special:Preferences|이메일을 변경하고 싶으신가요?]]",
	'closemyaccount-logged-in-as' => '귀하는 지금, $1 계정으로 로그인해 있으십니다. [[Special:UserLogout|귀하의 계정이 아니신가요?]]',
	'closemyaccount' => '계정 비활성화',
);

$messages['nl'] = array(
	'closemyaccount' => 'Close My Account',
	'closemyaccount-desc' => 'Allows users to close their own accounts.',
	'closemyaccount-intro-text' => "We are sorry {{GENDER:$2|you}} want to disable your account. Wikia has many communities on all sorts of subjects and we'd love for you to stick around and find the one that's right for you. If you are having a local problem with your wikia, please don't hesitate to contact your [[Special:ListUsers/sysop|local admins]] for help and advice.

If you have decided you definitely want to disable your account please be aware:
* Wikia does not have the ability to fully remove accounts, but we can disable them. This will ensure the account is locked and can't be used.
* This process is NOT reversible after $1 {{PLURAL:$1|day has|days have}} passed, and you will have to create a new account if you wish to rejoin Wikia.
* This process will not remove your contributions from a given Wikia community, as these contributions belong to the community as a whole.

If you need any more information on what an account disable actually does, you can visit our [[Help:Close_my_account|help page on disabling your account]]. If you are sure you want to close your account, please click the button below.

Please note you will have $1 {{PLURAL:$1|day|days}} after making this request to reactivate your account by logging in and following the instructions you will see. After this waiting period, your account will be closed permanently and cannot be restored.",
	'closemyaccount-unconfirmed-email' => 'Warning: You do not have a confirmed email address associated with this account. You will not be able to reactivate your account within the waiting period without one. Please consider setting an email address in [[Special:Preferences|your preferences]] before proceeding.',
	'closemyaccount-logged-in-as' => 'You are logged in as {{GENDER:$1|$1}}. [[Special:UserLogout|Not you?]]',
	'closemyaccount-current-email' => '{{GENDER:$2|Your}} email is set to $1. [[Special:Preferences|Do you wish to change it?]]',
	'closemyaccount-confirm' => '{{GENDER:$1|I}} have read the [[Help:Close_my_account|help page on closing your account]] and confirm that I want to disable my Wikia account.',
	'closemyaccount-button-text' => 'Close my account',
	'closemyaccount-reactivate-button-text' => 'Reactivate my account',
	'closemyaccount-reactivate-page-title' => 'Reactivate my account',
	'closemyaccount-reactivate-intro' => '{{GENDER:$2|You}} have previously requested that we close your account. You still have $1 {{PLURAL:$1|day|days}} left until your account is closed. If you still wish to close your account, simply go back to browsing Wikia. However, if you would like to reactivate your account, please click the button below and follow the instructions in the email.

Would you like to reactivate your account?',
	'closemyaccount-reactivate-requested' => 'An email has been sent to the address you had set for your account. Please click the link in the email to reactivate your account.',
	'closemyaccount-reactivate-error-id' => 'Please login to your account first to request reactivation.',
	'closemyaccount-reactivate-error-email' => 'No email was set for this account prior to requesting closure so it cannot be reactivated. Please [[Special:Contact|contact Wikia]] if you have any questions.',
	'closemyaccount-reactivate-error-not-scheduled' => 'Account is not scheduled for closure.',
	'closemyaccount-reactivate-error-invalid-code' => '{{GENDER:$1|You}} appear to have used a confirmation code that has expired. Please check your email for a newer code you may have requested, or try requesting a new code by [[Special:UserLogin|logging in]] to the account you want to reactivate and following the instructions.',
	'closemyaccount-reactivate-error-empty-code' => 'A confirmation code needed to reactivate your account has not been provided. If you have requested your account be reactivated, please click the link in the email sent to you. Otherwise, [[Special:UserLogin|login]] to the account you want to reactivate in order to request a confirmation code.',
	'closemyaccount-reactivate-error-disabled' => 'This account has already been disabled. Please [[Special:Contact|contact Wikia]] if you have any questions.',
	'closemyaccount-reactivate-error-failed' => 'An error occurred while attempting to reactivate this account. Please try again or [[Special:Contact|contact Wikia]] if the issue persists.',
	'closemyaccount-reactivate-success' => 'Your account has been reactivated.',
	'closemyaccount-scheduled' => 'Your account has been successfully scheduled to be closed.

Please note you will have $1 {{PLURAL:$1|day|days}} from now to reactivate your account by [[Special:UserLogin|logging in]] and following the instructions you will see. After this waiting period, your account will be closed permanently and cannot be restored.',
	'closemyaccount-scheduled-failed' => 'An error occurred while attempting to schedule this account to be closed. Please [[Special:CloseMyAccount|try again]] or [[Special:Contact|contact Wikia]] if the issue persists.',
);

$messages['pl'] = array(
	'closemyaccount' => 'Zamknij moje konto',
	'closemyaccount-desc' => 'Pozwala użytkownikom na zamykanie własnych kont.',
	'closemyaccount-intro-text' => 'Przykro nam, że chcesz wyłączyć swoje konto. FANDOM posiada wiele wiki na przeróżne tematy i chcielibyśmy abyś {{GENDER:$2|został i znalazł|zastała i znalazła}} coś dla siebie. Jeśli masz problem na swojej wiki, spróbuj skontaktować się z [[Special:ListUsers/sysop|lokalnymi administratorami]], aby uzyskać pomoc i wsparcie.

Jeśli {{GENDER:$2|zdecydowałeś|zdecydowałaś}} się wyłączyć swoje konto, weź pod uwagę, że:
* FANDOM nie jest w stanie w pełni usunąć konta, możemy je wyłączyć. To zapewni, że dostęp do konta zostanie zablokowany uniemożliwiając jego dalsze użycie.
* Tego procesu NIE DA się wycofać, gdy upłynie $1 {{PLURAL:$1|dzień|dni}} i będzie wtedy wymagane zarejestrowanie nowego konta, aby wrócić.
* Ten proces nie usunie twojego wkładu z danej społeczności, ponieważ te edycje należą do ogółu społeczności.

Jeżeli chcesz dowiedzieć się więcej o tym, jakie skutki ma wyłączenie konta, odwiedź [[w:c:pomoc:Pomoc:Zamykanie konta|stronę pomocy]] na ten temat. Jeżeli jesteś {{GENDER:$2|pewny|pewna}}, że chcesz wyłączyć konto, wystarczy, że klikniesz przycisk poniżej.

Pamiętaj, że po wysłaniu prośby o wyłączenie konta będziesz {{GENDER:$2|miał|miała}} $1 {{PLURAL:$1|dzień|dni}} na reaktywowanie swojego konta (żeby to zrobić, zaloguj się i postępuj zgodnie z instrukcjami, które zobaczysz). Po upłynięciu tego czasu twoje konto zostanie wyłączone na stałe i nie będzie można go już przywrócić.',
	'closemyaccount-unconfirmed-email' => 'Uwaga: twoje konto nie posiada potwierdzonego adresu email. Bez niego nie będziesz w stanie reaktywować konta w czasie oczekiwania. Rozważ możliwość ustawienia adresu email w [[Specjalna:Preferencje|preferencjach]] przed kontynuowaniem.',
	'closemyaccount-logged-in-as' => 'Jesteś {{GENDER:$1|zalogowany|zalogowana}} jako $1. [[Special:UserLogout|Nie ty?]]',
	'closemyaccount-current-email' => 'Twój email to $1. [[Special:Preferences|Chcesz go zmienić?]]',
	'closemyaccount-confirm' => '{{GENDER:$1|Przeczytałem|Przeczytałam}} [[w:c:pomoc:Pomoc:Zamykanie konta|stronę pomocy o zamykaniu konta]] i potwierdzam, że chcę wyłączyć swoje konto na Fandomie.',
	'closemyaccount-button-text' => 'Zamknij moje konto',
	'closemyaccount-reactivate-button-text' => 'Reaktywuj moje konto',
	'closemyaccount-reactivate-page-title' => 'Reaktywuj moje konto',
	'closemyaccount-reactivate-intro' => 'Już {{GENDER:$2|wysłałeś|wysłałaś}} wcześniej prośbę o wyłączenie konta. {{PLURAL:$1|Pozostał 1 dzień|Pozostało $2 dni}} do wyłączenia twojego konta. Jeśli ciągle chcesz, aby twoje konto zostało zamknięte możesz wrócić do przeglądania Fandomu. Jeśli chcesz reaktywować konto kliknij przycisk poniżej i postępuj zgodnie z instrukcjami w e-mailu.

Czy chcesz reaktywować swoje konto?',
	'closemyaccount-reactivate-requested' => 'E-mail został wysłany na adres ustawiony w preferencjach. Kliknij link w e-mailu, aby reaktywować swoje konto.',
	'closemyaccount-reactivate-error-id' => 'Zaloguj się, aby wysłać prośbę o reaktywację.',
	'closemyaccount-reactivate-error-email' => 'Żaden email nie został ustawiony przed prośbą o zamknięcie, więc konto nie może być reaktywowane. Proszę [[Special:Contact|skontaktuj się z Fandomem]], jeśli masz pytania.',
	'closemyaccount-reactivate-error-not-scheduled' => 'Konto nie oczekuje na zamknięcie.',
	'closemyaccount-reactivate-error-invalid-code' => 'Kod potwierdzający, który {{GENDER:$1|próbowałeś|próbowałaś}} użyć, już wygasł. Sprawdź ponownie swoją pocztę w poszukiwaniu nowego kodu lub spróbuj ponownie [[Special:UserLogin|logując]] się na konto, które chcesz reaktywować, i postępując zgodnie z instrukcjami.',
	'closemyaccount-reactivate-error-empty-code' => 'Kod potwierdzający reaktywowanie konta nie został podany. Jeśli chcesz reaktywować konto, kliknij na link zawarty w e-mailu. Ewentualnie [[Special:UserLogin|zaloguj się]] na konto, które chcesz reaktywować, aby wysłać prośbę o kod potwierdzający.',
	'closemyaccount-reactivate-error-disabled' => 'To konto zostało już wyłączone. Proszę [[Special:Contact|skontaktuj się z Fandomem]], jeśli masz pytania.',
	'closemyaccount-reactivate-error-failed' => 'Wystąpił błąd przy próbie reaktywowania konta. Spróbuj ponownie lub [[Special:Contact|skontaktuj się z Fandomem]], jeśli problem się powtarza.',
	'closemyaccount-scheduled' => 'Wyłączenie twojego konta zostało pomyślnie zaplanowane.

Masz $1 {{PLURAL:$1|dzień|dni}}, aby je reaktywować, logując się ponownie i postępując zgodnie z instrukcjami. Po tym czasie twoje konto zostanie wyłączone na stałe i nie będzie możliwości odzyskania go.',
	'closemyaccount-scheduled-failed' => 'Wystąpił błąd przy dodawaniu zadania zamknięcia konta. [[Special:CloseMyAccount|Spróbuj ponownie]] lub [[Special:Contact|skontaktuj się z Fandomem]], jeśli problem się powtarza.',
	'closemyaccount-reactivate-success' => 'Twoje konto zostało reaktywowane.',
	'closemyaccount-reactivate-error-fbconnect' => '{{GENDER:$1|Złożyłeś|Złożyłaś}} wniosek o zamknięcie konta. Jeśli chcesz ponownie aktywować konto, przejdź do [[Special:CloseMyAccount/reactivate|strony ponownej aktywacji konta]] i wykonuj polecenia zawarte na tej stronie.',
);

$messages['pt'] = array(
	'closemyaccount' => 'Fechar a minha conta',
	'closemyaccount-desc' => 'Permite que os usuários fechem suas próprias contas.',
	'closemyaccount-intro-text' => 'Lamentamos que {{GENDER:$2|você}} queira desativar sua conta. O FANDOM tem muitas comunidades sobre todos os tipos de assuntos e nós gostaríamos que você ficasse por aqui para encontrar o que é certo para você. Se você estiver tendo um problema local com sua comunidade, não hesite em contatar seu [[Especial:Lista_de_utilizadores/sysop|administrador local]] para ajuda e conselhos.

Se você decidiu definitivamente desativar sua conta, por favor, esteja ciente: 
* O FANDOM não tem a capacidade de remover completamente as contas, mas pode desativá-las. Isto garante que a conta continue bloqueada e ninguém poderá usá-la.
* Este processo NÃO é reversível após $1 {{PLURAL:$1|dia|dias}}, então você terá que criar uma nova conta se quiser se juntar ao FANDOM novamente.
* Este processo não removerá suas contribuições de uma determinada comunidade FANDOM, pois essas contribuições pertencem à comunidade como um todo.

Se você precisar de mais alguma informação sobre a desativação de contas, você pode visitar nossa [[Ajuda:Fechando_uma_conta|página sobre a desativação de sua conta]]. Se você tiver certeza que deseja fechar a sua conta, por favor clique no botão abaixo.

Por favor, note que você terá $1 {{PLURAL:$1|dia|dias}} depois de fazer este pedido para reativar sua conta registrando-se e seguindo as instruções. Após este período, sua conta será permanentemente fechada e não pode ser restaurada.',
	'closemyaccount-unconfirmed-email' => 'Aviso: Você não tem um endereço de e-mail confirmado associado a esta conta. Você não poderá reativar a sua conta sem um e-mail durante este período de espera. Por favor, considere configurar um endereço de e-mail em [[Especial:Preferências|suas preferências]] antes de prosseguir.',
	'closemyaccount-logged-in-as' => 'Você está logado como {{GENDER:$1|$1}}. [[Especial:Sair|Não é você?]]',
	'closemyaccount-current-email' => '{{GENDER:$2|Seu}} e-mail está definido como $1. [[Especial:Preferências|Você gostaria de mudá-lo?]]',
	'closemyaccount-confirm' => '{{GENDER:$1|Eu}} li a [[Ajuda:Fechando_uma_conta|página sobre o encerramento de conta]] e confirmo que desejo desativar minha conta no FANDOM.',
	'closemyaccount-button-text' => 'Fechar a minha conta',
	'closemyaccount-reactivate-button-text' => 'Reativar a minha conta',
	'closemyaccount-reactivate-page-title' => 'Reativação de conta',
	'closemyaccount-reactivate-intro' => '{{GENDER:$2|Você}} solicitou o fechamento de sua conta anteriormente. Você ainda tem $1 {{PLURAL:$1|dia|dias}} até que sua conta seja fechada. Se você ainda deseja fechá-la, simplesmente volte para navegação no FANDOM. No entanto, se você quiser reativar a sua conta, clique no botão abaixo e siga as instruções no e-mail.

Gostaria de reativar a sua conta?',
	'closemyaccount-reactivate-requested' => 'Um e-mail foi enviado para o endereço que você definiu na sua conta. Por favor clique no link no e-mail para reativar a sua conta.',
	'closemyaccount-reactivate-error-id' => 'Faça login na sua conta antes de solicitar a reativação.',
	'closemyaccount-reactivate-error-email' => 'Nenhum e-mail foi definido para esta conta antes de solicitar o encerramento, então ela não pode ser reativada. Por favor, [[Special:Contact|entre em contato com o FANDOM]] se você tiver alguma dúvida.',
	'closemyaccount-reactivate-error-not-scheduled' => 'A conta não está programada para ser fechada.',
	'closemyaccount-reactivate-error-invalid-code' => '{{GENDER:$1|Você}} pode ter usado um código de confirmação que expirou. Por favor, verifique seu e-mail para obter um código mais recente, que você pode ter solicitado, ou tente solicitar um novo código [[Special:UserLogin|entrando]] na conta que você deseja reativar e seguindo as instruções.',
	'closemyaccount-reactivate-error-empty-code' => 'O código de confirmação necessário para reativar a sua conta não foi fornecido. Se você solicitou a reativação da sua conta, por favor clique no link no e-mail enviado para você. Caso contrário, [[Special:UserLogin|entre]] na conta que você deseja reativar a fim de solicitar um código de confirmação.',
	'closemyaccount-reactivate-error-disabled' => 'Esta conta já foi desativada. Por favor, [[Especiall:Contact|entre em contato com o FANDOM]] se você tiver alguma dúvida.',
	'closemyaccount-reactivate-error-failed' => 'Um erro ocorreu ao tentar reativar essa conta. Por favor tente novamente ou [[Especial: Contact|entre em contato]] com o FANDOM se o problema persistir.',
	'closemyaccount-scheduled' => 'Sua conta foi agendada para ser fechada com êxito.

Por favor, note que você terá $1 {{PLURAL:$1|dia|dias}} a partir de agora para reativar sua conta. Basta [[Special:UserLogin|logar]] e seguir as instruções que você verá. Após este período, sua conta será permanentemente fechada e não pode ser restaurada.',
	'closemyaccount-scheduled-failed' => 'Um erro ocorreu ao tentar agendar o encerramento desta conta. Por favor [[Especial:CloseMyAccount|tente novamente]] ou [[Especial:Contact|contate o FANDOM]] se o problema persistir.',
	'closemyaccount-reactivate-success' => 'Sua conta foi reativada.',
	'closemyaccount-reactivate-error-fbconnect' => '{{GENDER:$1|Você}} solicitou o fechamento de sua conta anteriormente. Se você quiser reativar a sua conta, acesse a [[Special:CloseMyAccount|página de reativação de conta]] e siga as instruções.',
);

$messages['ru'] = array(
	'closemyaccount' => 'Отключить мою учётную запись',
	'closemyaccount-desc' => 'Это позволяет участникам удалять свои аккаунты.',
	'closemyaccount-intro-text' => 'Нам очень жаль, что вы хотите отключить вашу учётную запись. На Фэндоме есть множество википроектов на разные темы, и мы очень надеемся, что вы передумаете и найдёте ту вики, которая подходит именно вам. Если у вас возникли проблемы на вики, пожалуйста, не стесняйтесь обращаться за помощью к [[Special:ListUsers/sysop|местным администраторам]].

Если вы всё-таки точно решили, что хотите отключить вашу учётную запись, пожалуйста, учтите следующее:
* Фэндом не имеет технической возможности полностью удалить учётную запись, но может её отключить. В этом случае ваш аккаунт будет заблокирован и вы больше не сможете его использовать.
* Этот процесс является необратимым по прошествии $1 {{PLURAL:$1|дня|дней}}, и если вы захотите вернуться на Фэндом, вам придётся создать новую учётную запись.
* Закрытие учётной записи не приведёт к удалению ваших правок и вашего вклада в википроекты Фэндома, так как этот контент принадлежит вики-сообществу.

Если вам нужна дополнительная информация об отключении учётной записи, прочитайте соответствующую [[w:c:ru.community:Справка:Отключение_учётной_записи|справочную страницу]]. Если вы по-прежнему уверены, что хотите закрыть свою учётную запись, пожалуйста, нажмите на кнопку ниже.

Обратите внимание, что после отправки этого запроса у вас будет $1 {{PLURAL:$1|день|дня|дней}}, чтобы вернуться и восстановить учётную запись. Для этого войдите в свою учётную запись и следуйте инструкциям по остановке процесса отключения аккаунта. По истечении периода ожидания учётная запись будет закрыта окончательно и не сможет быть восстановлена.',
	'closemyaccount-unconfirmed-email' => 'Предупреждение! У вас нет подтверждённого адреса электронной почты, связанного с вашей учётной записью. Поэтому вы не сможете восстановить свою учётную запись в период ожидания после её отключения. Пожалуйста, укажите действительный адрес электронной почты в [[Special:Preferences|личных настройках]], чтобы продолжить.',
	'closemyaccount-logged-in-as' => 'Вы вошли как «{{GENDER:$1|$1}}». [[Special:UserLogout|Это не вы?]]',
	'closemyaccount-current-email' => '{{GENDER:$2|Ваш}} адрес электронной почты: $1. [[Special:Preferences|Хотите изменить его?]]',
	'closemyaccount-confirm' => 'Я прочитал(а) [[w:c:ru.community:Справка:Отключение учётной записи|справочную статью об отключении учётной записи]] и подтверждаю, что хочу отключить свой аккаунт на сайте Фэндом.',
	'closemyaccount-button-text' => 'Отключить мой аккаунт',
	'closemyaccount-reactivate-button-text' => 'Восстановить мой аккаунт',
	'closemyaccount-reactivate-page-title' => 'Восстановить мой аккаунт',
	'closemyaccount-reactivate-intro' => 'Ранее вы запросили отключение вашей учётной записи. Помните, что у вас есть ещё $1 {{PLURAL:$1|день|дня|дней}}, чтобы её восстановить. Если вы не собираетесь этого делать, просто перейдите на заглавную страницу Фэндома. Если вы хотите восстановить свой аккаунт сейчас, нажмите на кнопку ниже и следуйте инструкциям в письме, высланном на вашу электронную почту.

Вы хотите восстановить свою учётную запись?',
	'closemyaccount-reactivate-requested' => 'Письмо было отправлено на адрес электронной почты, который вы указали в личных настройках. Пожалуйста, нажмите на ссылку в письме, чтобы восстановить свою учётную запись.',
	'closemyaccount-reactivate-error-id' => 'Пожалуйста, войдите в систему, что запросить восстановление учётной записи.',
	'closemyaccount-reactivate-error-email' => 'Вы не указали действительный адрес электронной почты для отключённой учётной записи, поэтому она не может быть восстановлена. Пожалуйста, [[Special:Contact|свяжитесь с сотрудниками Фэндома]], если у вас есть вопросы.',
	'closemyaccount-reactivate-error-not-scheduled' => 'Не планируется отключать эту учётную запись.',
	'closemyaccount-reactivate-error-invalid-code' => 'Вы пытаетесь использовать ссылку подтверждения, срок активации которой уже истёк. Пожалуйста, проверьте вашу электронную почту на наличие новой ссылки или запросите её ещё раз — [[Special:UserLogin|войдите в учётную запись]], которую вы хотите восстановить, и проследуйте инструкциям.',
	'closemyaccount-reactivate-error-empty-code' => 'Ссылка подтверждения, которая необходима для восстановления учётной записи, не была активирована. Если вы уже запрашивали восстановление учётной записи, проверьте вашу электронную почту на наличие такой ссылки. В противном случае [[Special:UserLogin|войдите в аккаунт]], который вы хотите восстановить, и запросите ссылку подтверждения.',
	'closemyaccount-reactivate-error-disabled' => 'Эта учётная запись была отключена. Если у вас есть вопросы, [[Special:Contact|свяжитесь с сотрудниками Фэндома]].',
	'closemyaccount-reactivate-error-failed' => 'Произошла ошибка при попытке восстановить эту учётную запись. Пожалуйста, попробуйте ещё раз. Если проблема не исчезла, [[Special:Contact|свяжитесь с сотрудниками Фэндома]].',
	'closemyaccount-scheduled' => 'Ваша учётная запись была отключена.

Обратите внимание, что у вас будет $1 {{PLURAL:$1|день|дня|дней}}, чтобы восстановить аккаунт. Для этого [[Special:UserLogin|войдите в свою учётную запись]] и следуйте инструкциям. По прошествии указанного времени ваш аккаунт будет окончательно отключён, и его будет невозможно восстановить.',
	'closemyaccount-scheduled-failed' => 'Произошла ошибка при отключении учётной записи. Пожалуйста, попробуйте [[Special:CloseMyAccount|отключить аккаунт ещё раз]]. Если проблема повторяется, [[Special:Contact|свяжитесь с сотрудниками Фэндома]].',
	'closemyaccount-reactivate-success' => 'Ваша учётная запись была восстановлена.',
	'closemyaccount-reactivate-error-fbconnect' => '{{GENDER:$1|Вы}} запросили отключение вашей учётной записи. Если вы захотите восстановить свою учётную запись, перейдите на [[Special:CloseMyAccount/reactivate|страницу восстановления аккаунта]] и следуйте указанным инструкциям.',
);

$messages['zh-hans'] = array(
	'closemyaccount' => '关闭我的帐户',
	'closemyaccount-desc' => '允许用户关闭其自己的帐户。',
	'closemyaccount-intro-text' => '我们很抱歉您希望禁用您的帐户。FANDOM拥有众多的流行话题，您在此可以不断查看新的主题社区。如果您在任何喜欢的维基上遇到了问题，您可以选择联系这个维基的[[Special:ListUsers/sysop|管理员]]获取建议和帮助。

如果您已经确定需要禁用帐户，您需要注意的是：
* FANDOM没有能力完全删除您的帐户，但是我们可以禁用您的帐户。这将确保此帐户被永久锁定，不能被再次使用。
* 这个过程将在$1{{PLURAL:$1|天|天}}后不可逆。如果之后您希望重新加入FANDOM，您必须重新创建一个新的帐户。
* 禁用的过程不会删除您旧帐户的历史纪录，因为这些纪录属于您之前编辑过的维基社区的一部分。

如果您希望了解更多关于禁用帐户的有关信息，请访问社区中心的[[Help:Close_my_account|帮助:关闭帐户]]。如果您确定需要关闭您的帐户，请点击下面的按钮。

请注意，您将有$1{{PLURAL:$1|天|天}}时间重新激活您的帐户。超过这段时间之后，您的帐户将被永久禁用并且不能被重新恢复。',
	'closemyaccount-unconfirmed-email' => '警告: 您并没有任何和您帐户相连的注册邮件信息，因此我们将不能在有效时间内帮您重新激活帐户。请您在进行下一步之前，在[[Special:Preferences|个人设置]]中设置您的电子邮箱。',
	'closemyaccount-logged-in-as' => '您将作为{{GENDER:$1|$1}}登陆。[[Special:UserLogout|非本人?]]',
	'closemyaccount-current-email' => '{{GENDER:$2|您的}}电子邮箱将被设置为$1。[[Special:Preferences|还需要进行更改吗？]]',
	'closemyaccount-confirm' => '{{GENDER:$1|我}}已经阅读了[[Help:Close_my_account|关闭帐户帮助页]]的相关条款并且同意禁用我的FANDOM帐户。',
	'closemyaccount-button-text' => '关闭我的帐户',
	'closemyaccount-reactivate-button-text' => '重新激活我的帐户',
	'closemyaccount-reactivate-page-title' => '重新激活我的帐户',
	'closemyaccount-reactivate-intro' => '{{GENDER:$2|您}}之前申请过要求禁用此帐户，不过您目前还有$1{{PLURAL:$1|天|天}}的时间可以恢复您的帐户。 如果您仍然希望关闭此帐户，请继续您的网页浏览。如果您希望重新激活此帐户，请点击下面按钮，并且按照邮件中的说明逐步进行。

您希望重新激活您的帐户吗？',
	'closemyaccount-reactivate-requested' => '我们已经发送了一封邮件到您的邮箱中。请点击邮件中的链接重新激活您的帐户。',
	'closemyaccount-reactivate-error-id' => '请登入您的帐户进行重新激活。',
	'closemyaccount-reactivate-error-email' => '在您要求关闭此帐户之前未设置任何邮件地址，因此我们无法帮您重新激活此帐户。如果您有任何疑问，请发邮件[[Special:Contact|联系我们]]。',
	'closemyaccount-reactivate-error-not-scheduled' => '帐户不能被成功关闭。',
	'closemyaccount-reactivate-error-invalid-code' => '{{GENDER:$1|您}}似乎使用的是过期的验证码。请登陆您的邮箱查看最新的验证码，或者[[Special:UserLogin|登陆您之前要求封禁的帐户]]，按步骤重新进行激活。 ',
	'closemyaccount-reactivate-error-empty-code' => '激活帐户的验证码不可用。您需要点击邮件中的链接地址重新激活您的帐户；或者，您可以[[Special:UserLogin|登入]]帐户重新发送验证码。',
	'closemyaccount-reactivate-error-disabled' => '这个帐户已经被禁用。如果您有任何问题，请[[Special:Contact|联系FANDOM]]。',
	'closemyaccount-reactivate-error-failed' => '重新激活帐户出现错误，请再试一次。如果问题依然存在，请[[Special:Contact|联系FANDOM]]。',
	'closemyaccount-scheduled' => '您的帐户已经成功被禁用。

请注意，您还有$1{{PLURAL:$1|天|天}}时间重新激活您的帐户。请您[[Special:UserLogin|登入帐户]]进行激活。在这段时间之后，您的帐户将被永久禁用并且无法恢复。 ',
	'closemyaccount-scheduled-failed' => '关闭帐户出现错误，请[[Help:關閉帳號|重新进行关闭]]。如果问题依然存在，请[http://zh.community.wikia.com/wiki/Special:Contact/general 联系我们]。',
	'closemyaccount-reactivate-success' => '您的帐户已经被重新激活。',
	'closemyaccount-reactivate-error-fbconnect' => '{{GENDER:$1|您}} 曾经要求关闭您的帐户。如果您希望重新激活帐户，请转到[[Special:CloseMyAccount/reactivate|激活帐户页面]]并且按照提示进行操作。',
);

$messages['zh-hant'] = array(
	'closemyaccount' => '關閉我的帳號',
	'closemyaccount-desc' => '允許用戶關閉其帳號。',
	'closemyaccount-intro-text' => '我們很遺憾您希望關閉您的帳號。FANDOM擁有眾多流行主題的Wiki，我們很希望您能找到並持續參與您喜好的主題社區。如果您在任何喜歡的wiki上遇到了問題，您可以選擇聯絡這個wiki的[[Special:ListUsers/sysop|管理員]]獲取建議和幫助。

如果您已經確定需要關閉帳號，您需要注意的是：
* FANDOM無法完全刪除您的帳號，但是我們可以關閉您的帳號。這將確保此帳號被永久鎖定，不能被再次使用。
* 這個過程將在$1{{PLURAL:$1|天|天}}後無法恢復。之後如果您希望重新加入FANDOM，您必須重新創建一個新的帳號。
* 關閉的過程不會刪除您舊帳號的歷史紀錄，因為這些紀錄屬於您之前編輯過的wiki社區的一部分。

如果您希望了解更多關於關閉帳號的資訊，請訪問社區中心的[[Help:Close_my_account|幫助:關閉帳戶]]。如果您確定需要關閉您的帳號，請按下面的按鈕。

請注意，您將有$1{{PLURAL:$1|天|天}}時間重新啟用您的帳號。超過這段時間之後，您的帳號將會永久關閉而不能再恢復。',
	'closemyaccount-unconfirmed-email' => '警告: 您並沒有任何和您帳號相連的電子郵件信箱，這我們將不能在及時內幫您重新啟動帳戶。請您在進行下一步之前，在[[Special:Preferences|個人設定]]中設置您的電子郵箱。',
	'closemyaccount-logged-in-as' => '您將以{{GENDER:$1|$1}}登錄。[[Special:UserLogout|非本人?]]',
	'closemyaccount-current-email' => '{{GENDER:$2|您的}}電子郵箱將設置為$1。[[Special:Preferences|您希望進行更改嗎?]]',
	'closemyaccount-confirm' => '{{GENDER:$1|我}}已經閱讀了[[Help:Close_my_account|關閉帳號幫助頁面]]中的相關條款並且同意關閉我的FANDOM帳號。',
	'closemyaccount-button-text' => '關閉我的帳號',
	'closemyaccount-reactivate-button-text' => '重新啟動我的帳號',
	'closemyaccount-reactivate-page-title' => '重新啟動我的帳號',
	'closemyaccount-reactivate-intro' => '您之前曾申請關閉此帳號，不過您目前還有$1{{PLURAL:$1|天|天}} 的時間可以恢復您的帳號。如果您仍然希望關閉此帳號，請回去繼續您的Fandon頁面瀏覽。如果您希望重新開啟此帳戶，請按下下面的按鈕，並且按照郵件中的說明逐步進行。

您希望重新開啟您的帳號嗎？',
	'closemyaccount-reactivate-requested' => '我們已經發送了一封郵件到您的郵箱中。請點擊郵件中的連結重新啟動您的帳號。',
	'closemyaccount-reactivate-error-id' => '請登錄您的帳號以重新啟動。',
	'closemyaccount-reactivate-error-email' => '在您要求關閉此帳號之前未設置任何電子郵件地址，因此我們無法幫您重新啟動此帳號。如果您有任何疑問，請[[Special:Contact|聯繫我們]]。',
	'closemyaccount-reactivate-error-not-scheduled' => '帳號未能成功關閉。',
	'closemyaccount-reactivate-error-invalid-code' => '{{GENDER:$1|您}}似乎使用的是過期的驗證碼。請至您的郵箱查看最新的驗證碼，或者[[Special:UserLogin|登錄您之前要求關閉的帳號]]，按步驟進行重新啟用帳號。',
	'closemyaccount-reactivate-error-empty-code' => '未提供重啟帳號所需要的驗證碼。如果您已申請帳號重啟，您需要點擊郵件中的鏈接以重新啟用您的帳號；或者，您可以[[Special:UserLogin|登錄]]想要重啟的帳號申請發送驗證碼。',
	'closemyaccount-reactivate-error-disabled' => '這個帳號已經關閉。如果您有任何問題，請[[Special:Contact|聯絡FANDOM]]。',
	'closemyaccount-reactivate-error-failed' => '重新啟用帳號出現錯誤，請再試一次。如果問題依然存在，請[[Special:Contact|聯絡我們]]。',
	'closemyaccount-reactivate-success' => '您的帳號已經重新啟動了。',
	'closemyaccount-scheduled' => '您的帳號已經成功關閉。

請注意，您還有$1{{PLURAL:$1|天|天}}時間可重新啟用您的帳號。請您[[Special:UserLogin|登錄帳號]]進行重新啟用。在這段時間之後，您的帳號將被永久關閉而無法恢復。',
	'closemyaccount-scheduled-failed' => '關閉帳號出現錯誤，請[[Special:CloseMyAccount|重新進行關閉]]。如果問題依然存在，請[[Special:Contact|聯絡我們]]。',
	'closemyaccount-reactivate-error-fbconnect' => '{{GENDER:$1|您}}之前申請關閉了您的帳號。如果您想要重新啟動您的帳號，請進入 [[Special:CloseMyAccount/reactivate|帳號重啟頁面]]，按照步驟進行重新啟動。',
);

