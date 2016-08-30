<?php
/**
 * Internationalisation for CloseMyAccount extension
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Daniel Grunwell (grunny)
 */
$messages['en'] = array(
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
	'closemyaccount-confirm' => '{{GENDER:$1|I}} have read the [[Help:Close_my_account|help page on closing your account]] and confirm that I want to disable my Fandom account.',
	'closemyaccount-button-text' => 'Close my account',
	'closemyaccount-reactivate-button-text' => 'Reactivate my account',
	'closemyaccount-reactivate-page-title' => 'Reactivate my account',
	'closemyaccount-reactivate-intro' => '{{GENDER:$2|You}} have previously requested that we close your account. You still have $1 {{PLURAL:$1|day|days}} left until your account is closed. If you still wish to close your account, simply go back to browsing Wikia. However, if you would like to reactivate your account, please click the button below and follow the instructions in the email.

Would you like to reactivate your account?',
	'closemyaccount-reactivate-requested' => 'An email has been sent to the address you had set for your account. Please click the link in the email to reactivate your account.',
	'closemyaccount-reactivate-error-id' => 'Please login to your account first to request reactivation.',
	'closemyaccount-reactivate-error-fbconnect' => '{{GENDER:$1|You}} have previously requested that we close your account. If you would like to reactivate your account, please go to the [[Special:CloseMyAccount/reactivate|account reactivation page]] and follow the instructions you will see.',
	'closemyaccount-reactivate-error-email' => 'No email was set for this account prior to requesting closure so it cannot be reactivated. Please [[Special:Contact|contact Wikia]] if you have any questions.',
	'closemyaccount-reactivate-error-not-scheduled' => 'Account is not scheduled for closure.',
	'closemyaccount-reactivate-error-invalid-code' => '{{GENDER:$1|You}} appear to have used a confirmation code that has expired. Please check your email for a newer code you may have requested, or try requesting a new code by [[Special:UserLogin|logging in]] to the account you want to reactivate and following the instructions.',
	'closemyaccount-reactivate-error-empty-code' => 'A confirmation code needed to reactivate your account has not been provided. If you have requested your account be reactivated, please click the link in the email sent to you. Otherwise, [[Special:UserLogin|login]] to the account you want to reactivate in order to request a confirmation code.',
	'closemyaccount-reactivate-error-disabled' => 'This account has already been disabled. Please [[Special:Contact|contact Fandom]] if you have any questions.',
	'closemyaccount-reactivate-error-failed' => 'An error occurred while attempting to reactivate this account. Please try again or [[Special:Contact|contact Fandom]] if the issue persists.',
	'closemyaccount-reactivate-success' => 'Your account has been reactivated.',
	'closemyaccount-scheduled' => 'Your account has been successfully scheduled to be closed.

Please note you will have $1 {{PLURAL:$1|day|days}} from now to reactivate your account by [[Special:UserLogin|logging in]] and following the instructions you will see. After this waiting period, your account will be closed permanently and cannot be restored.',
	'closemyaccount-scheduled-failed' => 'An error occurred while attempting to schedule this account to be closed. Please [[Special:CloseMyAccount|try again]] or [[Special:Contact|contact Fandom]] if the issue persists.',
);

/**
 * @author Daniel Grunwell (grunny)
 */
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
	'closemyaccount-reactivate-error-fbconnect' => 'Error message displayed when users try to login to an account that has requested closure via Facebook Connect.
* $1 is the username',
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
	'closemyaccount-intro-text' => 'Schade, dass du dein Benutzerkonto schließen möchtest. Wikia bietet jede Menge Wikis zu allen möglichen Themen und wir würden uns freuen, wenn du noch ein wenig stöberst und das richtige für dich findest. Falls du ein Problem in deinem Wiki hast, zögere nicht einen der  [[Special:ListUsers/sysop|lokalen Admins]] um Hilfe zu bitten.

Wenn du dich dazu entschlossen hast, dein Benutzerkonto definitiv zu deaktivieren, beachte die folgenden Hinweise:
* Wikia hat nicht die Möglichkeit Benutzerkonten komplett zu entfernen, aber wir können sie deaktivieren. Das stellt sicher, dass das Konto geschlossen ist und nicht mehr benutzt werden kann.
* Diese Entscheidung kann nach dem Ablauf von $1 {{PLURAL:$1|Tag|Tagen}} NICHT wieder rückgängig gemacht werden und du wirst ein neues Konto anlegen müssen, wenn du Wikia wieder beitreten möchtest.
* Dieser Prozess führt nicht zu einer Entfernung deiner Beiträge von Wikia, da diese Bearbeitungen der gesamten Community gehören.

Falls du weitere Informationen darüber haben möchtest, was bei der Deaktivierung eines Benutzerkontos genau passiert, schau dir unsere [[w:c:de:Hilfe:Benutzerkonto_stilllegen|Hilfeseite zu dem Thema]] an. Wenn du dir sicher bist, dass du dein Benutzerkonto deaktivieren möchtest, drücke bitte den untenstehenden Knopf.

Bitte beachte, dass du nach dem Abschicken $1 {{PLURAL:$1|Tag|Tage}} Zeit hast, um dein Benutzerkonto wieder zu reaktivieren. Melde dich dazu an und folgen den Hinweisen. Nach dieser Zeit wird dein Benutzerkonto permanent geschlossen und kann nicht wiederhergestellt werden.',
	'closemyaccount-unconfirmed-email' => 'Warnung: Du hast keine bestätigte Mailadresse mit diesem Benutzerkonto verbunden. Ohne eine bestätigte Mailadresse kannst du dein Konto in der Wartezeit nicht wieder reaktivieren. Bitte überlege dir, eine E-Mail-Adresse in deinen [[Special:Preferences|Benutzereinstellungen]] anzugeben und zu bestätigen, bevor du fortfährst.',
	'closemyaccount-logged-in-as' => 'Du bist angemeldet als {{GENDER:$1|$1}}. [[Special:UserLogout|Nicht du?]]',
	'closemyaccount-current-email' => '{{GENDER:$2|Deine}} Mailadresse lautet $1. [[Special:Preferences|Möchtest du sie ändern?]]',
	'closemyaccount-confirm' => '{{GENDER:$1|Ich}} habe die  [[w:c:de:Hilfe:Benutzerkonto_stilllegen|Hilfeseite zur Stilllegung von Benutzerkonten]] gelesen und bestätige, dass ich mein Wikia-Konto schließen möchte.',
	'closemyaccount-button-text' => 'Benutzerkonto schließen',
	'closemyaccount-reactivate-button-text' => 'Benutzerkonto reaktivieren',
	'closemyaccount-reactivate-page-title' => 'Benutzerkonto reaktivieren',
	'closemyaccount-reactivate-intro' => 'Du hast die Schließung deines Benutzerkontos beantragt. Du hast noch $1 {{PLURAL:$1|Tag|Tage}} bevor dein Benutzerkonto dauerhaft geschlossen wird. Wenn du weiterhin möchtest, dass dein Konto deaktiviert wird, musst du nichts weiter tun. Falls du dein Benutzerkonto doch wieder reaktivieren möchtest, klicke bitten den folgenden Knopf und folge den Anweisungen in der E-Mail an dich.

Möchtest du dein Benutzerkonto wieder reaktivieren?',
	'closemyaccount-reactivate-requested' => 'Eine E-Mail wurde an die in deinem Benutzerkonto angegebene Adresse geschickt. Bitte klicke auf den Link in der E-Mail um dein Benutzerkonto wieder zu reaktivieren.',
	'closemyaccount-reactivate-error-id' => 'Bitte melde dich erst mit deinem Benutzerkonto an um die Reaktivierung zu beantragen.',
	'closemyaccount-reactivate-error-email' => 'Für das Benutzerkonto war vor der Beantragung der Schließung keine E-Mail-Adresse angegeben, so dass es nicht wieder reaktiviert werden kann. Bitte [[Special:Contact|kontaktiere Wikia]] falls du Fragen hast.',
	'closemyaccount-reactivate-error-not-scheduled' => 'Das Benutzerkonto ist nicht für eine Schließung vorgesehen.',
	'closemyaccount-reactivate-error-invalid-code' => 'Du hast augenscheinlich einen Bestätigungscode verwendet, der nicht mehr gültig ist. Bitte prüfe deine E-Mail auf einen neueren Code, den du beantragt hast oder fordere einen neuen Code an, indem du dich mit dem Benutzerkonto [[Special:UserLogin|anmeldest]], das du reaktivieren möchtest - und dann den Anweisungen folgst.',
	'closemyaccount-reactivate-error-empty-code' => 'Zur Reaktivierung des Benutzerkontos ist ein Bestätigungscode notwendig, der aber nicht angegeben wurde. Wenn du dein Benutzerkonto reaktivieren möchtest, klicke bitte den Link in der Mail an, die dir zugesendet wurde. Ansonsten [[Special:UserLogin|melde dich mit dem Benutzerkonto an]], das du reaktivieren möchtest, und fordere einen Bestätigungscode an.',
	'closemyaccount-reactivate-error-disabled' => 'Dieses Benutzerkonto wurde bereits deaktiviert. Bitte [[Special:Contact|kontaktiere Wikia]], falls du Fragen hast.',
	'closemyaccount-reactivate-error-failed' => 'Beim Versuch der Reaktivierung dieses Benutzerkontos ist ein Fehler aufgetreten. Bitte versuche es erneut oder  [[Special:Contact|kontaktiere Wikia]], falls das Problem weiter besteht.',
	'closemyaccount-scheduled' => 'Dein Benutzerkonto wurde erfolgreich für eine Schließung vorgemerkt.

Bitte beachte, dass du von nun an $1 {{PLURAL:$1|Tag|Tage}} Zeit hast, dein Benutzerkonto wieder zu reaktivieren. Dazu musst du dich [[Special:UserLogin|anmelden]] und den Anweisungen folgen. Nach dieser Wartezeit wird dein Benutzerkonto permanent geschlossen und kann nicht wiederhergestellt werden.',
	'closemyaccount-scheduled-failed' => 'Beim Versuch dieses Benutzerkonto für eine Schließung vorzumerken ist ein Fehler aufgetreten. Bitte [[Special:CloseMyAccount|probiere es nochmal]] oder [[Special:Contact|kontaktiere Wikia]], falls das Problem bestehen bleibt.',
	'closemyaccount-reactivate-error-fbconnect' => '{{GENDER:$1|Du}} hast zu einem früheren Zeitpunkt beantragt, dass dein Benutzerkonto geschlossen wird. Falls du Dein Konto wieder aktivieren möchtest, rufe bitte die [[Special:CloseMyAccount/reactivate|Reaktivierungsseite für dein Benutzerkonto]] auf und folge dort den Anweisungen.',
	'closemyaccount-reactivate-success' => 'Dein Benutzerkonto wurde wieder aktiviert.',
);

$messages['es'] = array(
	'closemyaccount' => 'Cerrar mi cuenta',
	'closemyaccount-desc' => 'Permite a los usuarios cerrar sus propias cuentas.',
	'closemyaccount-intro-text' => 'Lamentamos que desees cerrar tu cuenta. Wikia tiene wikias de diferentes temas y deseamos que te quedes y encuentres el tema que sea para ti. Si estás teniendo un problema en la wikia que participas frecuentemente, por favor no dudes en contactar tu [[Special:ListUsers/sysop|administrador local]] para ayuda y sugerencia.

Si has decidido definitivamente cerrar tu cuenta, por favor ten en cuenta:
* Wikia no tiene la habilidad de cerrar las cuentas completamente, pero podemos desactivarlas. Esto asegurará que la cuenta sea bloqueada y no pueda ser usada.
* Este proceso NO es reversible después de que hayan pasado $1 {{PLURAL:$1|día|días}}, vas a tener que crear una nueva cuenta si deseas regresar a Wikia.
* Este proceso no removerá tus contribuciones de una comunidad específica en Wikia, ya que estas contribuciones pertenecen a la comunidad.

Si necesitas más información de lo que una cuenta cerrada realmente hace, puedes visitar nuestra página de [[w:c:comunidad:Ayuda:Cerrar_mi_cuenta|ayuda sobre como cerrar una cuenta]]. Si estás seguro de querer cerrar tu cuenta, por favor haz clic en el botón de abajo.

Ten en cuenta que tendrás $1 {{PLURAL:$1|día|días}} después de hacer el pedido para reactivar tu cuenta ingresando y siguiendo las instrucciones. Después del periodo de espera, tu cuenta será cerrada permanentemente y no podrá ser restaurada.',
	'closemyaccount-unconfirmed-email' => 'Advertencia: No tienes una dirección de correo electrónico asociada con esta cuenta. No serás capaz de reactivar tu cuenta dentro del período de espera sin una dirección de correo electrónico. Por favor considera asociar una en [[Special:Preferences|tus preferencias]] antes de proceder.',
	'closemyaccount-logged-in-as' => 'Estás conectado como {{GENDER:$1|$1}}. [[Special:UserLogout|¿No eres tú?]]',
	'closemyaccount-current-email' => '{{GENDER:$2|Tu}} correo electrónico es fijado en $1. [[Special:Preferences|¿Deseas cambiarlo?]]',
	'closemyaccount-confirm' => '{{GENDER:$1|Yo}} he leído la página de [[w:c:comunidad:Ayuda:Cerrar_mi_cuenta|ayuda sobre como cerrar mi cuenta]] y confirmo que deseo desactivar mi cuenta de Wikia.',
	'closemyaccount-button-text' => 'Cerrar mi cuenta',
	'closemyaccount-reactivate-button-text' => 'Reactivar mi cuenta',
	'closemyaccount-reactivate-page-title' => 'Reactivar mi cuenta',
	'closemyaccount-reactivate-intro' => 'Has solicitado previamente que cerremos tu cuenta. Todavía tienes $1 {{PLURAL:$1|día|días}} hasta que tu cuenta sea cerrada. Si todavía deseas cerrar tu cuenta, simplemente vuelve a navegar en Wikia. Sin embargo, si deseas reactivar tu cuenta, por favor haz clic en el botón de abajo y sigue las instrucciones en el correo electrónico.

¿Te gustaría reactivar tu cuenta?',
	'closemyaccount-reactivate-requested' => 'Se envió un correo electrónico a la dirección que asociaste a tu cuenta. Por favor, haz clic en el enlace enviado para reactivar tu cuenta.',
	'closemyaccount-reactivate-error-id' => 'Por favor ingresa a tu cuenta primero para solicitar la reactivación.',
	'closemyaccount-reactivate-error-email' => 'Ningún correo electrónico fue fijado para esta cuenta antes de solicitar el cierre así que no puede ser reactivada. Si tienes alguna pregunta, por favor [[Special:Contact|contáctate con Wikia]].',
	'closemyaccount-reactivate-error-not-scheduled' => 'La cuenta no está programada para ser cerrada.',
	'closemyaccount-reactivate-error-invalid-code' => 'Parece que has utilizado un código de confirmación que ha expirado. Por favor revisa tu correo electrónico por un código más reciente que hayas solicitado, o trata de solicitar un nuevo código al [[Special:UserLogin|ingresar]] a la cuenta que deseas reactivar y sigue las instrucciones.',
	'closemyaccount-reactivate-error-empty-code' => 'No se ha proporcionado un código de confirmación necesario para reactivar su cuenta. Si has solicitado la reactivación de tu cuenta, por favor haz clic en el enlace enviado. De lo contrario, [[Special:UserLogin|ingresa]] a la cuenta que deseas reactivar para solicitar un código de confirmación.',
	'closemyaccount-reactivate-error-disabled' => 'Esta cuenta ya ha sido desactivada. Si tienes alguna pregunta, por favor, [[Special:Contact|contáctate con Wikia]].',
	'closemyaccount-reactivate-error-failed' => 'Se ha producido un error al intentar reactivar esta cuenta. Por favor, inténtalo de nuevo o [[Special:Contact|contáctate con Wikia]] si el problema persiste.',
	'closemyaccount-scheduled' => 'Tu cuenta se ha programado exitosamente para ser cerrada.

Ten en cuenta que tendrás $1 {{PLURAL:$1|día|días}} después de hacer el pedido para reactivar tu cuenta [[Special:UserLogin|ingresando]] y siguiendo las instrucciones. Después de este período de espera, tu cuenta será cerrada permanentemente y no podrá ser restaurada.',
	'closemyaccount-scheduled-failed' => 'Se ha producido un error al intentar programar esta cuenta para ser cerrada. Por favor [[Special:CloseMyAccount|intenta de nuevo]] o [[Special:Contact|contáctate con Wikia]] si el problema persiste.',
	'closemyaccount-reactivate-error-fbconnect' => '{{GENDER:$1|Tu}} han solicitado previamente que cerrar tu cuenta. Si deseas reactivar tu cuenta, ingresa a la [[Special:CloseMyAccount/reactivate|página de reactivación de cuenta]] y sigue las instrucciones.',
	'closemyaccount-reactivate-success' => 'Tu cuenta ha sido reactivada.',
);

$messages['fr'] = array(
	'closemyaccount' => 'Close My Account',
	'closemyaccount-desc' => 'Allows users to close their own accounts.',
	'closemyaccount-intro-text' => "Nous sommes désolés que vous souhaitiez désactiver votre compte. Wikia a de nombreux wikis sur toutes sortes de sujets et nous aimerions que vous restiez et trouviez celui qui vous convient. Si vous avez un problème sur votre wiki, n'hésitez pas à demander de l'aide ou des conseils aux [[Special:ListUsers/sysop|administrateurs locaux]].

Si vous avez finalement décidé que vous souhaitez désactiver votre compte, sachez que :
* Wikia n'a pas la possibilité de retirer complètement les comptes, mais nous pouvons les désactiver. Cela assure que le compte est verrouillé et ne peut pas être utilisé.
* Cette opération n'est PAS réversible après $1 {{PLURAL:$1|jour|jours}} et vous devrez créer un nouveau compte si vous souhaitez revenir sur Wikia.
* Cette opération ne retirera pas vos contributions sur une communauté Wikia en particulier, comme ces contributions appartiennent à la communauté et forment un tout.

Si vous avez besoin de plus d'informations sur ce que la désactivation d'un compte fait réellement, vous pouvez visiter notre [[w:fr:Aide:Fermer mon compte|page d'aide sur la désactivation de votre compte]]. Si vous êtes {{GENDER:$2|sûr|sure}} de vouloir fermer votre compte, veuillez cliquer sur le bouton ci-dessous.

Veuillez noter que vous aurez $1 {{PLURAL:$1|jour|jours}}  après avoir effectué cette demande pour réactiver votre compte en vous connectant et en suivant les instructions affichées. Passé ce délai, votre compte sera fermé définitivement et ne pourra pas être restauré.",
	'closemyaccount-unconfirmed-email' => "Attention : Vous n'avez pas confirmé l'adresse de courriel associée avec ce compte. Vous ne pourrez pas réactiver votre compte durant la période de rétractation sans en avoir une. Veuillez réfléchir à indiquer une adresse de courriel dans [[Special:Preferences|vos préférences]] avant de continuer.",
	'closemyaccount-logged-in-as' => "Vous êtes {{GENDER:$1|connecté|connectée}} en tant que $1. [[Special:UserLogout|Ce n'est pas vous ?]]",
	'closemyaccount-current-email' => '{{GENDER:$2|Votre}} adresse de courriel est $1. [[Special:Preferences|Vous souhaitez la changer ?]]',
	'closemyaccount-confirm' => "{{GENDER:$1|J'}} ai lu la [[w:fr:Aide:Fermer_mon_compte|page d'aide sur la fermeture de mon compte]] et je confirme que je souhaite désactiver mon compte Wikia.",
	'closemyaccount-button-text' => 'Fermer mon compte',
	'closemyaccount-reactivate-button-text' => 'Réactiver mon compte',
	'closemyaccount-reactivate-page-title' => 'Réactiver mon compte',
	'closemyaccount-reactivate-intro' => 'Vous avez demandé auparavant à ce que nous fermions votre compte. Il reste encore $1 {{PLURAL:$1|jour|jours}} avant que votre compte ne soit fermé. Si vous souhaitez toujours  fermer votre compte, retournez simplement à la navigation de Wikia. Toutefois, si vous souhaitez réactiver votre compte, veuillez cliquer sur le bouton ci-dessous et suivez les instructions du courriel que vous allez recevoir.

Souhaitez-vous réactiver votre compte ?',
	'closemyaccount-reactivate-requested' => "Un courriel a été envoyé a l'adresse que vous avez définie pour ce compte. Veuillez cliquer sur le lien dans le courriel pour réactiver votre compte.",
	'closemyaccount-reactivate-error-id' => "Veuillez d'abord vous connecter avant de demander la réactivation.",
	'closemyaccount-reactivate-error-email' => "Aucune adresse de courriel n'a été définie pour ce compte avant de demander la fermeture, il ne peut donc pas être réactivé. Veuillez  [[Special:Contact|contacter Wikia]] si vous avez des questions.",
	'closemyaccount-reactivate-error-not-scheduled' => "La fermeture du compte n'est pas planifiée.",
	'closemyaccount-reactivate-error-invalid-code' => "Il semble que vous ayez utilisé un code de confirmation qui a expiré. Veuillez vérifier votre boîte aux lettres pour un code plus récent que vous auriez demandé ou essayez d'en demander un nouveau en vous [[Special:UserLogin|connectant]] au compte que vous souhaitez réactiver et suivez les instructions.",
	'closemyaccount-reactivate-error-empty-code' => "Un code de confirmation est nécessaire pour réactiver votre compte et n'a pas été indiqué. Si vous avez demandé à ce que votre compte soit réactivé, veuillez cliquer sur le lien dans le courriel que nous vous avons envoyé. Sinon, [[Special:UserLogin|connectez-vous]] avec le compte que vous souhaitez réactiver afin de demander un code de confirmation.",
	'closemyaccount-reactivate-error-disabled' => 'Ce compte a déjà été désactivé. Veuillez  [[Special:Contact|contacter Wikia]] si vous avez des questions.',
	'closemyaccount-reactivate-error-failed' => 'Une erreur est survenue en essayant de réactiver ce compte. Veuillez réessayer ou  [[Special:Contact|contactez Wikia]] si le problème persiste.',
	'closemyaccount-scheduled' => 'La fermeture de votre compte a été planifiée avec succès.

Veuillez noter que vous avez  $1 {{PLURAL:$1|jour|jours}} à partir de maintenant pour réactiver votre compte en [[Special:UserLogin|vous connectant]] et en suivant les instructions affichées. Après cette période de rétractation, votre compte sera définitivement fermé et ne pourra pas être restauré.',
	'closemyaccount-scheduled-failed' => 'Une erreur est survenue en tentant de planifier la fermeture de ce compte. Veuillez [[Special:CloseMyAccount|réessayer]] ou [[Special:Contact|contactez Wikia]] si le problème persiste.',
	'closemyaccount-reactivate-error-fbconnect' => '{{GENDER:$1|Vous}} nous avez précédemment demandé de fermer votre compte. Pour le réactiver, accédez à la [[Special:CloseMyAccount/reactivate|page de réactivation du compte]] et suivez les instructions fournies.',
	'closemyaccount-reactivate-success' => 'Votre compte a été réactivé.',
);

$messages['it'] = array(
	'closemyaccount' => 'Chiudi il mio account',
	'closemyaccount-desc' => 'Allows users to close their own accounts.',
	'closemyaccount-intro-text' => "Ci dispiace che tu voglia disabilitare il tuo account. Wikia ha molte wiki su tanti argomenti e ci piacerebbe che tu possa restare con noi per trovare quello che più ti piace. Se stai avendo un problema locale nella tua wiki, per favore, non esitare a contattare gli [[Special:ListUsers/sysop|amministratori locali]] per aiuto e consiglio.

Se hai deciso definitivamente di voler disabilitare il tuo account, allora devi sapere che:
* Wikia non ha la possibilità di rimuovere completamente un account, ma può solo disabilitarlo. Questo assicurerà che l'account sia bloccato e non possa essere usato.
* Questo processo NON può essere annullato dopo che {{PLURAL:$1|è passato $1 giorno|sono passati $1 giorni}}, dovrai creare un nuovo account se vorrai entrare nuovamente in Wikia.
* Questo processo non rimuoverà i tuoi contributi da una wiki, dato che questi contributi appartengono all'intera comunità.

Se ti servono più informazioni su cosa la disabilitazione dell'account comporta, puoi leggere [[w:c:it:Aiuto:Chiudere_un_account|questa pagina d'aiuto]]. Se sei sicuro di voler chiudere il tuo account, clicca il pulsante qui sotto per favore.

Ricordati che hai $1 {{PLURAL:$1|giorno|giorni}} dopo l'inoltro di questa richiesta per poter riattivare il tuo account effettuando l'accesso e seguendo le istruzioni che compariranno. Dopo questo periodo di attesa, il tuo account sarà chiuso permanentemente e non potrà essere recuperato.",
	'closemyaccount-unconfirmed-email' => "Attenzione: Non hai un indirizzo email confermato associato a questo account. Non potrai riattivare il tuo account nel periodo di attesa senza di esso. Per favore, considera l'idea di impostare un account email nelle [[Special:Preferences|tue preferenze]] prima di procedere.",
	'closemyaccount-logged-in-as' => "Hai effettuato l'accesso come {{GENDER:$1|$1}}. [[Special:UserLogout|Non sei tu?]]",
	'closemyaccount-current-email' => '{{GENDER:$2|La tua}} email è impostata come $1. [[Special:Preferences|Desideri cambiarla?]]',
	'closemyaccount-confirm' => "{{GENDER:$1|Ho}} letto [[w:c:it:Aiuto:Chiudere_un_account|la pagina d'aiuto sulla chiusura dell'account]] e confermo di voler disabilitare il mio account Wikia.",
	'closemyaccount-button-text' => 'Chiudi il mio account',
	'closemyaccount-reactivate-button-text' => 'Riattiva il mio account',
	'closemyaccount-reactivate-page-title' => 'Riattiva il mio account',
	'closemyaccount-reactivate-intro' => "Hai precedentemente richiesto la chiusura del tuo account. Hai ancora $1 {{PLURAL:$1|giorno|giorni}} a disposizione prima che il tuo account venga chiuso. Se desideri la chiusura del tuo account, ritorna semplicemente a navigare su Wikia. Se invece desideri riattivare il tuo account, clicca per favore sul pulsante sottostante e segui le istruzioni dell'email.

Desideri riattivare il tuo account?",
	'closemyaccount-reactivate-requested' => "Un'email è stata inviata all'indirizzo associato al tuo account. Per favore clicca sul link nell'email per riattivare il tuo account.",
	'closemyaccount-reactivate-error-id' => 'Per favore, accedi prima al tuo account per richiederne la riattivazione.',
	'closemyaccount-reactivate-error-email' => 'Nessuna email è stata impostata per questo account prima della richiesta di chiusura, per cui non può essere riattivato. Per favore [[Special:Contact|contatta Wikia]] se hai domande.',
	'closemyaccount-reactivate-error-not-scheduled' => "Non è prevista la chiusura dell'account.",
	'closemyaccount-reactivate-error-invalid-code' => "Sembra che tu abbia usato un codice di conferma scaduto. Per favore controlla la tua email per un codice più recente che potresti aver richiesto o prova a richiedere un nuovo codice [[Special:UserLogin|effettuando l'accesso]] all'account che vuoi riattivare e seguendo le istruzioni.",
	'closemyaccount-reactivate-error-empty-code' => "Non è stato fornito il codice di conferma necessario per riattivare il tuo account.  Se hai richiesto la riattivazione del tuo account, per favore clicca sull'indirizzo nella email che ti è stata inviata. Altrimenti, [[Special:UserLogin|accedi]] all'account che vuoi riattivare per poter richiedere un codice di conferma.",
	'closemyaccount-reactivate-error-disabled' => 'Questo account è già stato disabilitato. Se hai domande, [[Special:Contact|contatta Wikia]] per favore.',
	'closemyaccount-reactivate-error-failed' => 'Si è verificato un errore durante il tentativo di riattivazione di questo account. Per favore prova di nuovo o [[Special:Contact|contatta Wikia]] se il problema persiste.',
	'closemyaccount-scheduled' => "La chiusura del tuo account è stata programmata con successo.

Per favore ricordati che hai $1 {{PLURAL:$1|giorno|giorni}} a disposizione da adesso per riattivare il tuo account [[Special:UserLogin|eseguendo l'accesso]] e seguendo le istruzioni che compariranno. Dopo questo periodo di attesa, il tuo account sarà chiuso definitivamente e non potrà essere riattivato.",
	'closemyaccount-scheduled-failed' => 'Si è verificato un errore durante la programmazione della chiusura di questo account. Per favore [[Special:CloseMyAccount|prova di nuovo]] o [[Special:Contact|contatta Wikia]] se il problema persiste.',
	'closemyaccount-reactivate-error-fbconnect' => '{{GENDER:$1|Tu}} hai richiesto in precedenza la chiusura del tuo account. Se dovessi desiderare di riattivare il tuo account, vai a [[Special:CloseMyAccount/reactivate|pagina di riattivazione account]] e segui le istruzioni visualizzate.',
	'closemyaccount-reactivate-success' => 'Il tuo account è stato riattivato.',
);

$messages['ja'] = array(
	'closemyaccount' => 'Close My Account',
	'closemyaccount-desc' => 'Allows users to close their own accounts.',
	'closemyaccount-intro-text' => '残念ですがあなたのアカウントを無効にします。ウィキアでは様々なトピックを扱っており、あなたが興味のあるトピックを見つけてほしいと思っています。もしご自身が関わっているコミュニティーで問題がある場合は、恥ずかしがらずに[[Special:ListUsers/sysop|管理者]]にヘルプやアドバイスを求めて下さい。

もしアカウントを無効にしたい場合は下記の事を確認して下さい。
*ウィキアは完全にあなたのアカウントを削除することはできませんが、無効にすることはできます。これはアカウントをロックし使用できないようにします。
* このプロセスは$1 {{PLURAL:$1|day has|days have}}日過ぎると元に戻すことはできません。もしウィキアのアカウントを再度持ちたい場合は新しいアカウントを作成してもらうことになります。
*このプロセスではあなたがウィキアコミュニティーに投稿した記事は削除されません。

アカウントの無効化について詳しい詳細を知りたい場合は[[w:c:ja.community:ヘルプ:アカウントの利用を停止する|ヘルプページ アカウントを無効化する]]にて確認して下さい。アカウントを無効化したい場合は、下にあるボタンをクリックして下さい。

あなたには$1 {{PLURAL:$1|day|days}} 日間、アカウントを再有効化するリクエストを行うことができます。この期間を過ぎると、あなたのアカウントを永久に無効となります。',
	'closemyaccount-unconfirmed-email' => '警告: このアカウントに関連付けられている承認済みのメールアドレスではございません。承認済みのメールアドレスがないとあなたのアカウントを再有効化することはできません。手続きに入る前に[[Special:Preferences|個人設定]]にてメールアドレスを設定して下さい。',
	'closemyaccount-logged-in-as' => '{{GENDER:$1|$1}}としてログインしています。[[Special:UserLogout|あなたではない?]]',
	'closemyaccount-current-email' => '{{GENDER:$2|Your}}メールアドレスは$1と設定されています。 [[Special:Preferences|変更をご希望ですか?]]',
	'closemyaccount-confirm' => '{{GENDER:$1|I}} は [[w:c:ja.community:ヘルプ:アカウントの利用を停止する|アカウントを閉じる]]を読み、自身のウィキアアカウントを閉鎖することを承認します。',
	'closemyaccount-button-text' => 'アカウントを閉じる',
	'closemyaccount-reactivate-button-text' => 'アカウントを再有効化する',
	'closemyaccount-reactivate-page-title' => 'アカウントを再有効化する',
	'closemyaccount-reactivate-intro' => '以前、あなたのアカウントを閉じることをリクエストし、完全に閉鎖するまで$1 {{PLURAL:$1|day|days}} 日間あります。アカウントを閉じたいのであればウィキアに戻って手続きをして下さい。もしアカウントを再有効化したい場合は、下のボタンをクリックし、メールにて送られる指示に従って下さい。

アカウントを再開しますか?',
	'closemyaccount-reactivate-requested' => 'メールをあなたのアカウントにて設定したアドレスに送信されました。アカウントを再有効化するにはメールにあるリンクをクリックして下さい。',
	'closemyaccount-reactivate-error-id' => '再有効化をご希望でしたらまずはあなたのアカウントにログインして下さい。',
	'closemyaccount-reactivate-error-email' => '再有効化に必要なメールアドレスがあなたのアカウントに設定されておりません。大変お手数ですが [[Special:Contact|ウィキアまで]]ご連絡をお願いします。',
	'closemyaccount-reactivate-error-not-scheduled' => 'アカウントを閉じる予定はありません。',
	'closemyaccount-reactivate-error-invalid-code' => '有効期限が切れている承認コードを使用していると表示されています。メールにて送られた新しいコードを確認するか、[[Special:UserLogin|ログイン]] からアカウントを再有効化する新しいコードをリクエストし、手順を踏んで下さい。',
	'closemyaccount-reactivate-error-empty-code' => 'あなたのアカウントを再有効化するのに必要な承認コードが指定されていません。もしアカウントの再有効化をしたい場合は送信されたメール内にあるリンクをクリックして手続きをして下さい。それ以外の場合は確認コードをリクエストする為に再有効化したいアカウントで[[Special:UserLogin|ログイン]]して下さい。',
	'closemyaccount-reactivate-error-disabled' => 'このアカウントは既に無効になっています。ご質問がある場合は、[特別：Contact|ウィキアに連絡] して下さい。',
	'closemyaccount-reactivate-error-failed' => 'このアカウントを再有効化しようとしたところエラーが発生しました。再度やり直して下さい。それでも問題が解決しない場合はお手数ですが[ [特別：Contact|ウィキアに連絡] してください。',
	'closemyaccount-scheduled' => 'あなたのアカウントを閉じる準備をしています。

今から$1 {{PLURAL:$1|day|days}} 日間、[[Special:UserLogin|ログイン]]によってあなたのアカウントは再有効化されます。説明をよく読んで下さい。この期間を過ぎるとあなたのアカウントは永久に閉鎖され、再度有効化することはできません。',
	'closemyaccount-scheduled-failed' => 'アカウントを閉鎖しようと手続きをしたところエラーが発生しました。お手数ですが[[Special:CloseMyAccount|再度試みる]]もしくは [[Special:Contact|ウィキア]]までご連絡下さい。',
	'closemyaccount-reactivate-error-fbconnect' => '{{GENDER:$1|あなた}}は以前、アカウントの停止をリクエストされました。このアカウントの再開をご希望の場合は、[[特別:アカウント停止/reactivate|アカウントの再開ページ]]に移動して画面の手順を行ってください。',
	'closemyaccount-reactivate-success' => 'アカウントを再開しました。',
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
	'closemyaccount-reactivate-error-fbconnect' => '{{GENDER:$1|You}} have previously requested that we close your account. If you would like to reactivate your account, please go to the [[Special:CloseMyAccount/reactivate|account reactivation page]] and follow the instructions you will see.',
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
	'closemyaccount-intro-text' => 'Przykro nam, że chcesz wyłączyć swoje konto. Wikia posiada wiele wiki na przeróżne tematy i chcielibyśmy abyś {{GENDER:$2|został i znalazł|zastała i znalazła}} jakiś dla siebie. Jeśli masz problem na swojej wiki, spróbuj skontaktować się z [[Special:ListUsers/sysop|lokalnymi administratorami]] aby uzyskać pomoc i wsparcie.

Jeśli {{GENDER:$2|zdecydowałeś|zdecydowałaś}} się wyłączyć swoje konto weź pod uwagę:
* Wikia nie jest w stanie w pełni usunąć konta, możemy je wyłączyć. To zapewni, że dostęp do konta zostanie zablokowany uniemożliwiając jego dalsze użycie.
* Tego procesu NIE DA się wycofać gdy upłynie $1 {{PLURAL:$1|dzień|dni}} i będzie wtedy wymagane zarejestrowanie nowego konta aby wrócić.
* Ten proces nie usunie Twojego wkładu z danej społeczności, jako, że te edycje należą do ogółu społeczności.',
	'closemyaccount-unconfirmed-email' => 'Uwaga: Twoje konto nie posiada potwierdzonego adresu email. Bez niego nie będziesz w stanie reaktywować konta w czasie oczekiwania. Weź pod uwagę możliwość ustawienia adresu email w [[Special:Preferences|preferencjach]] przed kontynuowaniem.',
	'closemyaccount-logged-in-as' => 'Jesteś {{GENDER:$1|zalogowany|zalogowana}} jako $1. [[Special:UserLogout|Nie ty?]]',
	'closemyaccount-current-email' => '{{GENDER:$2|Twój}} email to $1. [[Special:Preferences|Chcesz go zmienić?]]',
	'closemyaccount-confirm' => '{{GENDER:$1|Przeczytałem|Przeczytałam}} [[w:c:pl:Pomoc:Zamykanie_konta|stronę pomocy o zamykaniu konta]] i potwierdzam, że chcę wyłączyć swoje konto na Wikii.',
	'closemyaccount-button-text' => 'Wyłącz moje konto',
	'closemyaccount-reactivate-button-text' => 'Reaktywuj moje konto',
	'closemyaccount-reactivate-page-title' => 'Reaktywuj moje konto',
	'closemyaccount-reactivate-intro' => 'Już {{GENDER:$2|wysłałeś|wysłałaś}} wcześniej prośbę o wyłączenie konta. {{PLURAL:$1|Pozostał 1 dzień|Pozostało $2 dni}} do wyłączenia Twojego konta. Jeśli ciągle chcesz aby Twoje konto zostało zamknięte możesz wrócić do przeglądania Wikii. Jeśli chcesz reaktywować konto kliknij przycisk poniżej i postępuj zgodnie z instrukcjami w emailu.

Czy chcesz reaktywować swoje konto?',
	'closemyaccount-reactivate-requested' => 'Email został wysłany na adres ustawiony w preferencjach. Kliknij link w mailu aby reaktywować swoje konto.',
	'closemyaccount-reactivate-error-id' => 'Proszę zaloguj się aby wysłać prośbę o reaktywację.',
	'closemyaccount-reactivate-error-email' => 'Żaden email nie został ustawiony przed prośbą o zamknięcie, więc nie może być reaktywowane. Proszę [[Special:Contact|skontaktuj się z Wikią]] jeśli masz pytania.',
	'closemyaccount-reactivate-error-not-scheduled' => 'Konto nie oczekuje na zamknięcie.',
	'closemyaccount-reactivate-error-invalid-code' => 'Kod potwierdzający, który {{GENDER:$1|próbowałeś|próbowałaś}} użyć wygasł. Sprawdź ponownie swoją pocztę w poszukiwaniu nowego kodu lub spróbuj ponownie [[Special:UserLogin|logując]] się na konto, które chcesz reaktywować i postępuj zgodnie z instrukcjami.',
	'closemyaccount-reactivate-error-empty-code' => 'Kod potwierdzający reaktywowanie konta nie został podany. Jeśli chcesz reaktywować konto kliknij na link zawarty w emailu. Ewentualnie [[Special:UserLogin|zaloguj się]] na konto, które chcesz reaktywować aby wysłać prośbę o kod potwierdzający.',
	'closemyaccount-reactivate-error-disabled' => 'To konto zostało już wyłączone. Proszę [[Special:Contact|skontaktuj się z Wikią]] jeśli masz pytania.',
	'closemyaccount-reactivate-error-failed' => 'Wystąpił błąd przy próbie reaktywowania konta. Spróbuj ponownie lub [[Special:Contact|skontaktuj się z Wikią]] jeśli problem się powtarza.',
	'closemyaccount-scheduled' => 'Wyłączenie Twojego konta zostało pomyślnie zaplanowane.

Masz $1 {{PLURAL:$1|dzień|dni}} aby je reaktywować logując się na nie ponownie i postępując zgodnie z instrukcjami. Po tym czasie Twoje konto zostanie wyłączone na stałe i nie będzie możliwości odzyskania go.',
	'closemyaccount-scheduled-failed' => 'Wystąpił błąd przy dodawaniu zadania zamknięcia konta. Spróbuj [[Special:CloseMyAccount|ponownie]] lub [[Special:Contact|skontaktuj się z Wikią]] jeśli problem się powtarza.',
	'closemyaccount-reactivate-error-fbconnect' => '{{GENDER:$1|Został}} przez Ciebie złożony wniosek o zamknięcie konta. Jeśli chciałbyś ponownie aktywować konto, przejdź do [[Special:CloseMyAccount/reactivate|strony ponownej aktywacji konta]] i wykonuj polecenia zawarte na tej stronie.',
	'closemyaccount-reactivate-success' => 'Twoje konto zostało ponownie aktywowane.',
);

$messages['pt'] = array(
	'closemyaccount' => 'Encerramento de conta',
	'closemyaccount-desc' => 'Permite que os usuários fechem suas próprias contas.',
	'closemyaccount-intro-text' => 'Lamentamos que {{GENDER:$2|você}} queira desativar sua conta. A Wikia tem muitas comunidades sobre todos os tipos de assuntos e nós gostaríamos que você ficasse por aqui para encontrar o que é certo para você. Se você estiver tendo um problema local com sua wikia, não hesite em contatar seu [[Special: ListUsers| sysop|administrador local]] para ajuda e conselhos.

Se você decidiu definitivamente desativar sua conta, por favor, esteja ciente:
* A Wikia não tem a capacidade de remover completamente as contas, mas pode desativá-las. Isto garantirá que a conta está bloqueada e não pode ser usada.
 * Este processo NÃO é reversível após $1 {{PLURAL:$1|dia|dias}, e você terá que criar uma nova conta se quiser se juntar a Wikia.
 * Este processo não removerá suas contribuições de uma determinada comunidade Wikia, pois essas contribuições pertencem à comunidade como um todo.

Se você precisar de mais alguma informação sobre a desativação de contas, você pode visitar nossa [[Ajuda: Close_my_account|página sobre a desativação de sua conta]]. Se você tiver certeza que deseja fechar a sua conta, por favor clique no botão abaixo.

Por favor, note que você terá $1 {{PLURAL:$1|dia|dias}} depois de fazer este pedido para reativar sua conta registrando e seguindo as instruções. Após este período, sua conta será permanentemente fechada e não pode ser restaurada.',
	'closemyaccount-unconfirmed-email' => 'Aviso: Você não tem um endereço de e-mail confirmado associado a esta conta. Você não poderá reativar a sua conta sem um e-mail durante este período de espera. Por favor, considere configurar um endereço de e-mail em [[Special:Preferências|suas preferências]] antes de prosseguir.',
	'closemyaccount-logged-in-as' => 'Você está logado como {{GENDER:$1|$1}}. [[Special:UserLogout|Não é você?]]',
	'closemyaccount-current-email' => '{{GENDER:$2|Seu}} e-mail está definido como $1. [[Special:Preferences|Você gostaria de mudá-lo?]]',
	'closemyaccount-confirm' => '{{GENDER:$1|Eu}} li a [[Ajuda: Close_my_account|página sobre o encerramento de conta]] e confirmo que desejo desativar minha conta Wikia.',
	'closemyaccount-button-text' => 'Fechar a minha conta',
	'closemyaccount-reactivate-button-text' => 'Reativar a minha conta',
	'closemyaccount-reactivate-page-title' => 'Reativação de conta',
	'closemyaccount-reactivate-intro' => '{{GENDER:$2|Você}} solicitou o fechamento de sua conta anteriormente. Você ainda tem $1 {{PLURAL:$1|dia|dias}}, até que sua conta seja fechada. Se você ainda deseja fechá-la, simplesmente volte para navegação na Wikia. No entanto, se você quiser reativar a sua conta, clique no botão abaixo e siga as instruções no e-mail.

Gostaria de reativar a sua conta?',
	'closemyaccount-reactivate-requested' => 'Um e-mail foi enviado para o endereço que você definiu na sua conta. Por favor clique no link no e-mail para reativar a sua conta.',
	'closemyaccount-reactivate-error-id' => 'Faça login na sua conta antes de solicitar a reativação.',
	'closemyaccount-reactivate-error-email' => 'Nenhum e-mail foi definido para esta conta antes de solicitar o encerramento, portanto ela não pode ser reativada. Por favor, [[Special:Contact|contate a Wikia]] se você tiver alguma dúvida.',
	'closemyaccount-reactivate-error-not-scheduled' => 'A conta não está programada para ser fechada.',
	'closemyaccount-reactivate-error-invalid-code' => '{{GENDER:$1|Você}} pode ter usado um código de confirmação que expirou. Por favor, verifique seu e-mail para obter um código mais recente, que você pode ter solicitado, ou tente solicitar um novo código [[Special: UserLogin|entrando]] na conta que você deseja reativar e seguindo as instruções.',
	'closemyaccount-reactivate-error-empty-code' => 'O código de confirmação necessário para reativar a sua conta não foi fornecido. Se você solicitou a reativação da sua conta, por favor clique no link no e-mail enviado para você. Caso contrário, [[Special:UserLogin|entre]] na conta que você deseja reativar a fim de solicitar um código de confirmação.',
	'closemyaccount-reactivate-error-disabled' => 'Esta conta já foi desativada. Por favor, [[Special: Contact|entre em contato com a Wikia]] se você tiver alguma dúvida.',
	'closemyaccount-reactivate-error-failed' => 'Um erro ocorreu ao tentar reativar esta conta. Por favor tente novamente ou [[Special: Contact|contate a Wikia]] se o problema persistir.',
	'closemyaccount-scheduled' => 'Sua conta foi agendada para ser fechada com êxito.

Por favor, note que você terá $1 {{PLURAL:$1|dia|dias}} a partir de agora para reativar sua conta. Basta [[Special:UserLogin|logar]] e seguir as instruções que você verá. Após este período, sua conta será permanentemente fechada e não pode ser restaurada.',
	'closemyaccount-scheduled-failed' => 'Um erro ocorreu ao tentar agendar o encerramento desta conta. Por favor [[Special:CloseMyAccount|tente novamente]] ou [[Special:Contact|contate a Wikia]] se o problema persistir.',
	'closemyaccount-reactivate-error-fbconnect' => '{{GENDER:$1|Você}} solicitou o fechamento de sua conta anteriormente. Se você quiser reativar a sua conta, acesse a [[Special:CloseMyAccount|página de reativação de conta]] e siga as instruções.',
	'closemyaccount-reactivate-success' => 'Sua conta foi reativada.',
);

$messages['ru'] = array(
	'closemyaccount' => 'Отключить мою учётную запись',
	'closemyaccount-desc' => 'Это позволяет участнику удалить свой аккаунт',
	'closemyaccount-intro-text' => 'Нам очень жаль, что вы хотите отключить вашу учётную запись. На Викия есть множество википроектов на разные темы, и мы очень надеемся, что вы найдёте ту вики, которая подходит именно вам. Если у вас возникли проблемы на одной из вики, пожалуйста, не стесняйтесь обращаться за помощью к [[Special:ListUsers/sysop|местным администраторам]].

Если вы всё-таки точно решили, что хотите отключить вашу учётную запись,  имейте в виду:
* Викия не имеет технической возможности полностью удалить учётную запись, но может отключить её. В этом случае ваш аккаунт будет заблокирован и вы больше не сможете его использовать.
* Этот процесс является необратимым по прошествии $1 {{PLURAL:$1|дня|дней}}, и вам придётся создать новую учётную запись, если вы захотите вернуться на Викия.
* Закрытие учётной записи не приведёт к удалению ваших правок и вашего вклада во все википроекты Викия, так как этот контент принадлежит вики-сообществу.

Если вам нужна дополнительная информация об отключении учётной записи, прочитайте  [[w:c:ru.community:Справка:Удаление_учётной_записи|справочную страницу об этом]]. Если вы по-прежнему уверены что хотите закрыть свою учётную запись, пожалуйста, нажмите на кнопку ниже.

Обратите внимание, что у вас будет $1 {{PLURAL:$1|день|дня|дней}} после запроса, чтобы вернуться и восстановить учётную запись. Для этого войдите в свою учётную запись и следуйте инструкциям. По истечению периода ожидания учётная запись будет закрыта окончательно и не может быть восстановлена.',
	'closemyaccount-unconfirmed-email' => 'Предупреждение! У вас нет подтверждённого адреса электронной почты, связанного с вашей учётной записью. Поэтому вы не сможете восстановить свою учётную запись в период ожидания после её отключения. Пожалуйста, укажите действительный адрес электронной почты в [[Special:Preferences|личных настройках]], чтобы продолжить.',
	'closemyaccount-logged-in-as' => 'Вы вошли как {{GENDER:$1|$1}}. [[Special:UserLogout|Это не вы?]]',
	'closemyaccount-current-email' => '{{GENDER:$2|Ваш}} адрес электронной почты: $1. [[Special:Preferences|Хотите изменить его?]]',
	'closemyaccount-confirm' => '{{GENDER:$1|Я}} прочитал [[w:c:ru.community:Справка:Удаление_учётной_записи|справочную страницу об удалении учётной записи]] и подтверждаю, что хочу отключить свою учётную запись Викия.',
	'closemyaccount-button-text' => 'Отключить мой аккаунт',
	'closemyaccount-reactivate-button-text' => 'Восстановить мой аккаунт',
	'closemyaccount-reactivate-page-title' => 'Восстановить мой аккаунт',
	'closemyaccount-reactivate-intro' => 'Вы запрашивали отключение вашей учётной записи. Помните, что у вас есть ещё $1 {{PLURAL:$1|день|дня|дней}}, чтобы восстановить её. Если вы не желаете этого, просто вернитесь к просмотру википроектов. Если вы хотите восстановить свой аккаунт сейчас, пожалуйста, нажмите на кнопку ниже и следуйте инструкциям в письме, высланном на ваш email.  Вы хотите восстановить свою учётную запись?',
	'closemyaccount-reactivate-requested' => 'Письмо было отправлено на адрес электронной почты, который вы указали в личных настройках. Пожалуйста, нажмите на ссылку в письме, чтобы восстановить свою учётную запись.',
	'closemyaccount-reactivate-error-id' => 'Пожалуйста, войдите в систему, что запросить восстановление учётной записи.',
	'closemyaccount-reactivate-error-email' => 'Вы не указали действительный адрес электронной почты для закрытой учётной записи, поэтому она не может быть восстановлена. Пожалуйста, [[Special:Contact|свяжитесь с сотрудниками Викия]] по возникшим вопросам.',
	'closemyaccount-reactivate-error-not-scheduled' => 'Не планируется отключать эту учётную запись.',
	'closemyaccount-reactivate-error-invalid-code' => 'Вы пытаетесь использовать ссылку подтверждения, срок активации которой уже истёк. Пожалуйста, проверьте вашу электронную почту на наличие новой ссылки или запросите её ещё раз - [[Special:UserLogin|войдите в учётную запись]], которую вы хотите восстановить, и следуйте инструкциям.',
	'closemyaccount-reactivate-error-empty-code' => 'Ссылка подтверждения, которая необходима для восстановления учётной записи, не была активирована. Если вы уже запрашивали восстановление учётной записи, проверьте вашу электронную почту на наличие такой ссылки. В противном случае, [[Special:UserLogin|войдите в аккаунт]], который вы хотите восстановить, и запросите ссылку подтверждения.',
	'closemyaccount-reactivate-error-disabled' => 'Эта учётная запись была отключена. Если у вас есть какие-либо вопросы, пожалуйста, [[Special:Contact|свяжитесь с сотрудниками Викия]].',
	'closemyaccount-reactivate-error-failed' => 'Произошла ошибка при попытке восстановить эту учётную запись. Пожалуйста, попробуйте ещё раз. Если проблема не исчезла, [[Special:Contact|свяжитесь с сотрудниками Викия]].',
	'closemyaccount-scheduled' => 'Ваша учётная запись была отключена.

Обратите внимание, что у вас будет $1 {{PLURAL:$1|день|дня|дней}}, чтобы восстановить аккаунт. Для этого [[Special:UserLogin|войдите в свою учётную запись]] и следуйте инструкциям. По прошествии указанного времени ваш аккаунт будет окончательно отключён и его невозможно будет восстановить.',
	'closemyaccount-scheduled-failed' => 'Произошла ошибка при отключении учётной записи. Пожалуйста, попробуйте [[Special:CloseMyAccount|отключить аккаунт ещё раз]]. Если проблема не исчезла, [[Special:Contact|свяжитесь с сотрудниками Викия]].',
	'closemyaccount-reactivate-error-fbconnect' => '{{GENDER:$1|Вы}} запросили отключение вашей учётной записи. Если вы захотите восстановить свою учётную запись, перейдите на [[Special:CloseMyAccount/reactivate|страницу восстановления аккаунта]] и следуйте указанным инструкциям.',
	'closemyaccount-reactivate-success' => 'Ваша учётная запись была восстановлена.',
);

$messages['zh-hans'] = array(
	'closemyaccount' => 'Close My Account',
	'closemyaccount-desc' => 'Allows users to close their own accounts.',
	'closemyaccount-intro-text' => '我们很抱歉{{GENDER:$2|您}}希望禁用您的帐户。Wikia拥有众多的流行话题，您在此可以不断查看新的主题社区。如果您在任何喜欢的维基上遇到了问题，您可以选择联系这个维基的[[Special:ListUsers/sysop|管理员]]获取建议和帮助。

如果您已经确定需要禁用帐户，您需要注意的是：
* Wikia没有能力完全删除您的帐户，但是我们可以禁用您的帐户。这将确保此帐户被永久锁定，不能被再次使用。
* 这个过程将在$1{{PLURAL:$1|天|天}}后不可逆。如果您希望重新加入Wikia，您必须重新创建一个新的帐户。
* 禁用的过程不会删除您旧帐户的历史纪录，因为这些纪录属于您之前编辑过的维基社区的一部分。

如果您希望了解更多关于禁用帐户的有关信息，请访问社区中心的[[Help:Close_my_account|帮助:关闭帐户]]。如果您确定需要关闭您的帐户，请点击下面的按钮。

请注意，您将有$1{{PLURAL:$1|天|天}}时间重新激活您的帐户。超过这段时间之后，您的帐户将被永久禁用并且不能被重新恢复。',
	'closemyaccount-unconfirmed-email' => '警告: 您并没有任何和您帐户相连的注册邮件信息，因此我们将不能在有效时间内帮您重新激活帐户。请您在进行下一步之前，在[[Special:Preferences|个人设置]]中设置您的电子邮箱。',
	'closemyaccount-logged-in-as' => '您将作为{{GENDER:$1|$1}}登陆。[[Special:UserLogout|非本人?]]',
	'closemyaccount-current-email' => '{{GENDER:$2|您的}}电子邮箱将被设置为$1。 [[Special:Preferences|您希望进行更改?]]',
	'closemyaccount-confirm' => '{{GENDER:$1|我}}已经阅读了[[Help:Close_my_account|帮助页面关闭帐户]]的相关条款并且同意禁用我的Wikia帐户。',
	'closemyaccount-button-text' => '关闭我的帐户',
	'closemyaccount-reactivate-button-text' => '重新激活我的账户',
	'closemyaccount-reactivate-page-title' => '重新激活我的账户',
	'closemyaccount-reactivate-intro' => '{{GENDER:$2|您}}之前申请过要求禁用此帐户，不过您目前还有$1{{PLURAL:$1|天|天}}的时间可以恢复您的帐户。 如果您仍然希望关闭此帐户，请继续您的网页浏览。如果您希望重新激活此帐户，请点击下面按钮，并且按照邮件中的说明逐步进行。

您希望重新激活您的帐户吗？',
	'closemyaccount-reactivate-requested' => '我们已经发送了一封邮件到您的邮箱中。请点击邮件中的链接重新激活您的帐户。',
	'closemyaccount-reactivate-error-id' => '请登录您的帐户进行重新激活。',
	'closemyaccount-reactivate-error-email' => '在您要求关闭此帐户之前未设置任何邮件地址，因此我们无法帮您重新激活此帐户。如果您有任何疑问，请发邮件[[Special:Contact|联系我们]]。',
	'closemyaccount-reactivate-error-not-scheduled' => '帐户不能被成功关闭。',
	'closemyaccount-reactivate-error-invalid-code' => '{{GENDER:$1|您}}似乎使用的是过期的验证码。请登陆您的邮箱查看最新的验证码，或者[[Special:UserLogin|登陆您之前要求封禁的帐户]]，按步骤重新进行激活。 ',
	'closemyaccount-reactivate-error-empty-code' => '激活帐户的验证码不可用。您需要点击邮件中的链接地址重新激活您的帐户；或者，您可以[[Special:UserLogin|登陆]]帐户重新发送验证码。',
	'closemyaccount-reactivate-error-disabled' => '这个帐户已经被禁用。如果您有任何问题，请[[Special:Contact|联系Wikia]]。',
	'closemyaccount-reactivate-error-failed' => '重新激活帐户出现错误，请再试一次。如果问题依然存在，请[[Special:Contact|联系我们]]。',
	'closemyaccount-scheduled' => '您的帐户已经成功被禁用。

请注意，您还有$1{{PLURAL:$1|天|天}}时间重新激活您的帐户。请您[[Special:UserLogin|登陆帐户]]进行激活。在这段时间之后，您的帐户将被永久禁用并且无法恢复。 ',
	'closemyaccount-scheduled-failed' => '关闭帐户出现错误，请[[Special:CloseMyAccount|重新进行关闭]]。如果问题依然存在，请[[Special:Contact|联系我们]]。',
	'closemyaccount-reactivate-error-fbconnect' => '{{GENDER:$1|您}} 曾经要求关闭您的帐户。如果您希望重新激活帐户，请转到[[Special:CloseMyAccount/reactivate|激活帐户页面]]并且按照提示进行操作。',
	'closemyaccount-reactivate-success' => '您的帐户已经被重新激活。',
);

$messages['zh-hant'] = array(
	'closemyaccount' => '關閉我的帳戶',
	'closemyaccount-desc' => '允許用戶關閉其帳戶。',
	'closemyaccount-intro-text' => '我們很抱歉{{GENDER:$2|您}}希望禁用您的帳戶。Wikia擁有眾多的流行話題，您在此可以不斷查看新的主題社區。如果您在任何喜歡的社區上遇到了問題，您可以選擇聯繫這個社區的[[Special:ListUsers/sysop|管理員]]獲取建議和幫助。

如果您已經確定需要禁用帳戶，您需要注意的是：
* Wikia不能完全刪除您的帳戶，但是我們可以禁用您的帳戶。這將確保此帳戶被永久鎖定，不能被再次使用。
* 這個過程將在$1{{PLURAL:$1|天|天}}後不可逆。如果您希望重新加入Wikia，您必須重新創建一個新的帳戶。
* 禁用的過程不會刪除您舊帳戶的歷史紀錄，因為這些紀錄屬於您之前編輯過的Wikia社區的一部分。

如果您希望瞭解更多關於禁用帳戶的有關資訊，請訪問社區中心的[[Help:Close_my_account|幫助:關閉帳戶]]。如果您確定需要關閉您的帳戶，請點擊下面的按鈕。

請注意，您將有$1{{PLURAL:$1|天|天}}時間重新啟動您的帳戶。超過這段時間之後，您的帳戶將被永久禁用並且不能被重新恢復。',
	'closemyaccount-unconfirmed-email' => '警告: 您並沒有任何和您帳戶相連的註冊郵件訊息，因此我們將不能在有效時間內幫您重新啟動帳戶。請您在進行下一步之前，在[[Special:Preferences|個人設定]]中設置您的電子郵箱。',
	'closemyaccount-logged-in-as' => '您將作為{{GENDER:$1|$1}}登錄。[[Special:UserLogout|非本人?]]',
	'closemyaccount-current-email' => '{{GENDER:$2|您的}}電子郵箱將被設置為$1。[[Special:Preferences|您希望進行更改?]]',
	'closemyaccount-confirm' => '{{GENDER:$1|我}}已經閱讀了[[Help:Close_my_account|幫助頁面關閉帳戶]]的相關條款並且同意禁用我的Wikia帳戶。',
	'closemyaccount-button-text' => '關閉我的帳戶',
	'closemyaccount-reactivate-button-text' => '重新啟動我的帳戶',
	'closemyaccount-reactivate-page-title' => '重新啟動我的帳戶',
	'closemyaccount-reactivate-intro' => '{{GENDER:$2|您}}之前申請過要求禁用此帳戶，不過您目前還有$1{{PLURAL:$1|天|天}}的時間可以恢復您的帳戶。如果您仍然希望關閉此帳戶，請繼續您的網頁瀏覽。如果您希望重新激活此帳戶，請點擊下面按鈕，並且按照郵件中的說明逐步進行。

您希望重新激活您的帳戶嗎？',
	'closemyaccount-reactivate-requested' => '我們已經發送了一封郵件到您的郵箱中。請點擊郵件中的連結重新激活您的帳戶。',
	'closemyaccount-reactivate-error-id' => '請登錄您的帳戶進行重新激活。',
	'closemyaccount-reactivate-error-fbconnect' => '{{GENDER:$1|您}}似乎使用的是過期的驗證碼。請登錄您的郵箱查看最新的驗證碼，或者[[Special:UserLogin|登錄您之前要求封禁的帳戶]]，按步驟重新進行啟動。',
	'closemyaccount-reactivate-error-email' => '在您要求關閉此帳戶之前未設置任何郵件地址，因此我們無法幫您重新激活此帳戶。如果您有任何疑問，請發郵件[[Special:Contact|聯繫我們]]。',
	'closemyaccount-reactivate-error-not-scheduled' => '帳戶不能被成功關閉。',
	'closemyaccount-reactivate-error-invalid-code' => '{{GENDER:$1|您}}似乎使用的是過期的驗證碼。請登錄您的郵箱查看最新的驗證碼，或者[[Special:UserLogin|登錄您之前要求封禁的帳戶]]，按步驟重新進行激活。',
	'closemyaccount-reactivate-error-empty-code' => '激活帳戶的驗證碼不可用。您需要點擊郵件中的鏈接地址重新激活您的帳戶；或者，您可以[[Special:UserLogin|登錄]]帳戶重新發送驗證碼。',
	'closemyaccount-reactivate-error-disabled' => '這個帳戶已經被禁用。如果您有任何問題，請[[Special:Contact|聯繫Wikia]]。',
	'closemyaccount-reactivate-error-failed' => '重新激活帳戶出現錯誤，請再試一次。如果問題依然存在，請[[Special:Contact|聯繫我們]]。',
	'closemyaccount-reactivate-success' => '您的帳戶已經重新啟動了。',
	'closemyaccount-scheduled' => '您的帳戶已經成功被禁用。

請注意，您還有$1{{PLURAL:$1|天|天}}時間重新激活您的帳戶。請您[[Special:UserLogin|登錄帳戶]]進行激活。在這段時間之後，您的帳戶將被永久禁用並且無法恢復。',
	'closemyaccount-scheduled-failed' => '關閉帳戶出現錯誤，請[[Special:CloseMyAccount|重新進行關閉]]。如果問題依然存在，請[[Special:Contact|聯繫我們]]。',
);

$messages['zh-tw'] = array(
	'closemyaccount' => 'Close My Account',
	'closemyaccount-desc' => 'Allows users to close their own accounts.',
	'closemyaccount-intro-text' => '我們很抱歉您希望禁用您的帳戶。 Wikia擁有眾多的流行話題，您在此可以不斷查看新的主題社區。如果您在任何喜歡的維基上遇到了問題，您可以選擇聯繫這個維基的[[Special:ListUsers/sysop|管理員]]獲取建議和幫助。

如果您已經確定需要禁用帳戶，您需要注意的是：
* Wikia沒有能力完全刪除您的帳戶，但是我們可以禁用您的帳戶。這將確保此帳戶被永久鎖定，不能被再次使用。
* 這個過程將在$1{{PLURAL:$1|天|天}}後不可逆。如果您希望重新加入Wikia，您必須重新創建一個新的帳戶。
* 禁用的過程不會刪除您舊帳戶的歷史紀錄，因為這些紀錄屬於您之前編輯過的維基社區的一部分。

如果您希望了解更多關於禁用帳戶的有關信息，請訪問社區中心的[[Help:Close_my_account|幫助:關閉帳戶]]。如果您確定需要關閉您的帳戶，請點擊下面的按鈕。

請注意，您將有$1{{PLURAL:$1|天|天}}時間重新激活您的帳戶。超過這段時間之後，您的帳戶將被永久禁用並且不能被重新恢復。',
	'closemyaccount-unconfirmed-email' => '警告: 您並沒有任何和您帳戶相連的註冊郵件信息，因此我們將不能在有效時間內幫您重新激活帳戶。請您在進行下一步之前，在[[Special:Preferences|個人設置]]中設置您的電子郵箱。',
	'closemyaccount-logged-in-as' => '您將作為{{GENDER:$1|$1}}登陸。 [[Special:UserLogout|非本人?]]',
	'closemyaccount-current-email' => '{{GENDER:$2|您的}}電子郵箱將被設置為$1。 [[Special:Preferences|您希望進行更改?]]',
	'closemyaccount-confirm' => '{{GENDER:$1|我}}已經閱讀了[[Help:Close_my_account|幫助頁面關閉帳戶]]的相關條款並且同意禁用我的Wikia帳戶。',
	'closemyaccount-button-text' => '關閉我的帳戶',
	'closemyaccount-reactivate-button-text' => '重新啟動我的帳戶',
	'closemyaccount-reactivate-page-title' => '重新啟動我的帳戶',
	'closemyaccount-reactivate-intro' => '您之前申請過要求禁用此帳戶，不過您目前還有$1{{PLURAL:$1|天|天}}的時間可以恢復您的帳戶。如果您仍然希望關閉此帳戶，請繼續您的網頁瀏覽。如果您希望重新激活此帳戶，請點擊下面按鈕，並且按照郵件中的說明逐步進行。

您希望重新激活您的帳戶嗎？',
	'closemyaccount-reactivate-requested' => '我們已經發送了一封郵件到您的郵箱中。請點擊郵件中的鏈接重新激活您的帳戶。',
	'closemyaccount-reactivate-error-id' => '請登錄您的帳戶進行重新激活。',
	'closemyaccount-reactivate-error-email' => '在您要求關閉此帳戶之前未設置任何郵件地址，因此我們無法幫您重新激活此帳戶。如果您有任何疑問，請發郵件[http://zh.community.wikia.com/wiki/Special:Contact/general 聯繫我們]。',
	'closemyaccount-reactivate-error-not-scheduled' => '帳戶不能被成功關閉。',
	'closemyaccount-reactivate-error-invalid-code' => '您似乎使用的是過期的驗證碼。請登陸您的郵箱查看最新的驗證碼，或者[[Special:UserLogin|登陸您之前要求封禁的帳戶]]，按步驟重新進行激活。',
	'closemyaccount-reactivate-error-empty-code' => '激活帳戶的驗證碼不可用。您需要點擊郵件中的鏈接地址重新激活您的帳戶；或者，您可以[[Special:UserLogin|登陸]]帳戶重新發送驗證碼。',
	'closemyaccount-reactivate-error-disabled' => '這個帳戶已經被禁用。如果您有任何問題，請[http://zh.community.wikia.com/wiki/Special:Contact/general 聯繫Wikia]。',
	'closemyaccount-reactivate-error-failed' => '重新激活帳戶出現錯誤，請再試一次。如果問題依然存在，請[http://zh.community.wikia.com/wiki/Special:Contact/general 聯繫我們]。',
	'closemyaccount-scheduled' => '您的帳戶已經成功被禁用。

請注意，您還有$1{{PLURAL:$1|天|天}}時間重新激活您的帳戶。請您[[Special:UserLogin|登陸帳戶]]進行激活。在這段時間之後，您的帳戶將被永久禁用並且無法恢復。',
	'closemyaccount-scheduled-failed' => '關閉帳戶出現錯誤，請[[Special:CloseMyAccount|重新進行關閉]]。如果問題依然存在，請[http://zh.community.wikia.com/wiki/Special:Contact/general 聯繫我們]。',
);

