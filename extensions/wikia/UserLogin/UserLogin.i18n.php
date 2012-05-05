<?php
/**
* Internationalisation file for the UserLogin extension.
*
* @addtogroup Languages
*/

$messages = array();

$messages['en'] = array(
	// login
	'userlogin-login-heading' => 'Log in',
	'userlogin-forgot-password' => 'Forgot your password?',
	'userlogin-remembermypassword' => 'Stay logged in',
	'userlogin-error-noname' => 'Oops, please fill in the username field.',
	'userlogin-error-sessionfailure' => 'Your log in session has timed out. Please log in again.',
	'userlogin-error-nosuchuser' => "We don't recognize this name. Don't forget usernames are case sensitive.",
	'userlogin-error-wrongpassword' => 'Oops, wrong password. Make sure caps lock is off and try again.',
	'userlogin-error-wrongpasswordempty' => 'Oops, please fill in the password field.',
	'userlogin-error-resetpass_announce' => 'Looks like you used a temporary password. Pick a new password here to continue logging in.',
	'userlogin-error-login-throttled' => 'You have tried to log in with the wrong password too many times. Wait a while before trying again.',
	'userlogin-error-login-userblocked' => "Your username has been blocked and cannot be used to log in.",
	'userlogin-error-edit-account-closed-flag' => 'Your account has been disabled by Wikia.',
	'userlogin-error-cantcreateaccount-text' => 'Your IP address is not allowed to create new accounts.',
	'userlogin-error-userexists' => 'Someone already has this username. Try a different one!',
	'userlogin-error-invalidemailaddress' => 'Please enter a valid e-mail address.',
	'userlogin-get-account' => 'Don\'t have an account? [[Special:UserSignup|Sign up]]',

	// signup
	'userlogin-error-invalid-username' => 'Invalid username',
	'userlogin-error-userlogin-unable-info' => 'Sorry, we are not able to register your account at this time.',
	'userlogin-error-user-not-allowed' => 'This username is not allowed.',
	'userlogin-error-captcha-createaccount-fail' => 'The word you entered did not match the word in the box, try again!',
	'userlogin-error-userlogin-bad-birthday' => 'Oops, please fill out month, day and year.',
	'userlogin-error-externaldberror' => 'Sorry! Our site is currently having an issue. Please try again later.',
	'userlogin-error-noemailtitle' => 'Please enter a valid e-mail address.',
	'userlogin-error-acct_creation_throttle_hit' => 'Sorry, this IP address has created too many accounts today. Please try again later.',

	// mail password
	'userlogin-error-resetpass_forbidden' => 'Passwords cannot be changed',
	'userlogin-error-blocked-mailpassword' => 'You cannot request a new password because this IP address is blocked by Wikia.',
	'userlogin-error-throttled-mailpassword' => 'We have already sent a password reminder to this account in the last {{PLURAL:$1|hour|$1 hours}}. Please check your email.',
	'userlogin-error-mail-error' => 'Oops, there was a problem sending you e-mail. Please [[Special:Contact/general|contact us]].',
	'userlogin-password-email-sent' => 'We have sent a new password to the e-mail address for $1.',
	'userlogin-error-unconfirmed-user' => 'Sorry, you have not confirmed your e-mail address. Please confirm your e-mail address first.',

	// change password page
	'userlogin-password-page-title' => 'Change your password',
	'userlogin-oldpassword' => 'Old password',
	'userlogin-newpassword' => 'New password',
	'userlogin-retypenew' => 'Retype new password',


	// password email
	'userlogin-password-email-subject' => 'Forgotten password request',
	'userlogin-password-email-greeting' => 'Hi $USERNAME,',
	'userlogin-password-email-content' => 'Please use this temporary password to log in to Wikia: "$NEWPASSWORD"
<br/><br/>
If you did not request a new password, don\'t worry! Your account is safe and secure. You can ignore this email and continue log in to Wikia with your old password.
<br /><br />
Questions or concerns? Feel free to contact us.',
	'userlogin-password-email-signature' => 'Wikia Community Support',
	'userlogin-password-email-body' => 'Hi $2,

Please use this temporary password to log in to Wikia: "$3"

If you did not request a new password, don\'t worry! Your account is safe and secure. You can ignore this email and continue log in to Wikia with your old password.

Questions or concerns? Feel free to contact us.

Wikia Community Support


___________________________________________

To check out the latest happenings on Wikia, visit http://community.wikia.com
Want to control which emails you receive? Go to: {{fullurl:{{ns:special}}:Preferences}}',
	'userlogin-password-email-body-HTML' => '',

	// general email
	'userlogin-email-footer-line1' => 'To check out the latest happenings on Wikia, visit <a style="color:#2a87d5;text-decoration:none;" href="http://community.wikia.com">community.wikia.com</a>',
	'userlogin-email-footer-line2' => 'Want to control which emails you receive? Go to your <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">Preferences</a>',
	'userlogin-email-footer-line3' => '<a href="http://www.twitter.com/wikia" style="text-decoration:none">
<img alt="twitter" src="http://images4.wikia.nocookie.net/wikianewsletter/images/f/f7/Twitter.png" style="border:none">
</a>
&nbsp;
<a href="http://www.facebook.com/wikia" style="text-decoration:none">
<img alt="facebook" src="http://images2.wikia.nocookie.net/wikianewsletter/images/5/55/Facebook.png" style="border:none">
</a>
&nbsp;
<a href="http://www.youtube.com/wikia" style="text-decoration:none">
<img alt="youtube" src="http://images3.wikia.nocookie.net/wikianewsletter/images/a/af/Youtube.png" style="border:none">
</a>
&nbsp;
<a href="http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog" style="text-decoration:none">
<img alt="wikia" src="http://images1.wikia.nocookie.net/wikianewsletter/images/b/be/Wikia_blog.png" style="border:none">
</a>',

	// 3rd party login providers
	'userlogin-provider-or' => 'Or',
	'userlogin-provider-tooltip-facebook' => 'Click the button to log in with Facebook',
	'userlogin-provider-tooltip-facebook-signup' => 'Click the button to sign up with Facebook',

	'userlogin-facebook-show-preferences' => 'Show Facebook feed preferences',
	'userlogin-facebook-hide-preferences' => 'Hide Facebook feed preferences',

	'userlogin-loginreqlink' => 'log in',
	'userlogin-changepassword-needlogin' => 'You need to $1 to change your password.',

	//WikiaMobile skin
	'wikiamobile-sendpassword-label' => 'Send new password',
	'wikiamobile-facebook-connect-fail' => 'Sorry, your Facebook account is not currently linked with a Wikia account.'
);

/** Message documentation (Message documentation)
 * @author Siebrand
 */
$messages['qqq'] = array(
	'userlogin-login-heading' => 'Login page heading',
	'userlogin-forgot-password' => 'Link that asks if you forgot your password.',
	'userlogin-remembermypassword' => 'Label for staying logged in checkbox',
	'userlogin-error-noname' => 'Error message upon login attempt stating the name field is blank.',
	'userlogin-error-sessionfailure' => 'Error message upon login attempt stating session has timed out.',
	'userlogin-error-nosuchuser' => 'Error message upon login attempt stating there is no such user. Reminds of caps lock.',
	'userlogin-error-wrongpassword' => 'Error message upon login attempt stating the password is incorrect. Reminds of caps lock.',
	'userlogin-error-wrongpasswordempty' => 'Error message upon login attempt stating password field is blank.',
	'userlogin-error-resetpass_announce' => 'Error message upon login attempt stating that this password is a temp password, and the user needs to set a new password.',
	'userlogin-error-login-throttled' => 'Error message upon login attempt stating user has failed too many logins for the time period.',
	'userlogin-error-login-userblocked' => 'Error message upon login attempt stating user has been blocked.',
	'userlogin-error-edit-account-closed-flag' => 'Error message upon login attempt stating the account has been closed.',
	'userlogin-error-cantcreateaccount-text' => "Error message upon login attempt stating that the user's IP address has been throttled because of login failures.",
	'userlogin-error-userexists' => 'Error message upon signup attempt stating user name already exists.',
	'userlogin-error-invalidemailaddress' => 'Error message upon signup attempt stating e-mail address is invalid.',
	'userlogin-get-account' => 'Marketing blurb asking to sign up with wikitext internal link to usersignup page. Please append userlang as appropriate.',
	'userlogin-error-invalid-username' => 'Error message upon signup attempt stating username is badly formatted, or invalid',
	'userlogin-error-userlogin-unable-info' => 'Error message upon signup attempt stating account cannot be create currently.',
	'userlogin-error-user-not-allowed' => 'Error message upon signup attempt stating username is unacceptable.',
	'userlogin-error-captcha-createaccount-fail' => 'Error message upon signup attempt stating CAPTCHA has failed or not entered correctly.',
	'userlogin-error-userlogin-bad-birthday' => 'Error message upon signup attempt stating all fields for birthday is required: Year, Month, Day.',
	'userlogin-error-externaldberror' => 'Error message upon signup attempt stating there was a technical issue at wikia.',
	'userlogin-error-noemailtitle' => 'Error message upon signup attempt stating user should enter a valid e-mail address.',
	'userlogin-error-acct_creation_throttle_hit' => 'Error message upon signup attempt stating that too many accounts have been created from the same IP.',
	'userlogin-error-resetpass_forbidden' => 'Error message stating password cannot be changed.',
	'userlogin-error-blocked-mailpassword' => 'Error message stating password cannot be changed because IP has been restricted.',
	'userlogin-error-throttled-mailpassword' => 'Error message stating email has already been sent $1 hours ago and asks user to check email. Parameters:
* $1 is numerical hour.',
	'userlogin-error-mail-error' => 'Error message stating there was an error sending the email. Link to Contact us page in wikitext.',
	'userlogin-password-email-sent' => 'Validation message stating that email has been to the user. Parameters:
* $1 contains the email address, such as john@wikia-inc.com',
	'userlogin-error-unconfirmed-user' => 'Error message stating that user needs to be confirmed first.',
	'userlogin-password-page-title' => 'Heading for change password page.',
	'userlogin-oldpassword' => 'Label for old password field',
	'userlogin-newpassword' => 'Label for new password field',
	'userlogin-retypenew' => 'Label for retype password field',
	'userlogin-password-email-subject' => 'Subject line for Forgot password email',
	'userlogin-password-email-greeting' => 'Email body heading. $USERNAME is a special wikia magic word, so re-use it without changing. This may contain html markup, and is placed onto a template.',
	'userlogin-password-email-content' => 'Email body. $NEWPASSWORD is wikia magic word. This may contain html markup, and is placed onto a template.',
	'userlogin-password-email-signature' => 'Wikia Email signature at the bottom of the email. This may contain html markup, and is placed onto a template.',
	'userlogin-password-email-body' => 'This is a text-only version email that combines the contents userlogin-password-email-greeting, userlogin-password-email-content, and userlogin-password-email-signature. This does NOT contain HTML. Parameters:
* $2 is username in greeting,
* $3 is the temporary password value. Content-wise, it is exactly the same as templated html version, but this is a complete stand-alone.',
	'userlogin-email-footer-line1' => 'Footer line 1 in the standard Wikia email template.',
	'userlogin-email-footer-line2' => 'Footer line 2 in the standard Wikia email template.',
	'userlogin-email-footer-line3' => 'Footer line 3 in the standard Wikia email template. The links are space (&nbsp) separated pointing to social networks. Leave this blank if social network is unknown.',
	'userlogin-provider-or' => 'Word shown between login form and FB connect button',
	'userlogin-provider-tooltip-facebook' => 'Tooltip when hovering over facebook connect button in login page or context.',
	'userlogin-provider-tooltip-facebook-signup' => 'Tooltip when hovering over facebook connect button in signup page or context.',
	'userlogin-facebook-show-preferences' => 'Action anchor text to show facebook feed preference section of the UI when near facebook signup completion.',
	'userlogin-facebook-hide-preferences' => 'Action anchor text to hide facebook feed preference section of the UI when near facebook signup completion.',
	'userlogin-loginreqlink' => 'login link',
	'userlogin-changepassword-needlogin' => 'Parameters:
* $1 is an action link using the message {{msg-wikia|userlogin-loginreqlink}}.',
	'wikiamobile-sendpassword-label' => 'Label for the button used to request a new password for recovery',
	'wikiamobile-facebook-connect-fail' => "Shown when a user tries to log in via FBConnect but there's no matching account in our DB, please keep the message as short as possible as the space at disposal is really limited",
);

/** Spanish (Español)
 * @author Armando-Martin
 * @author Invadinado
 */
$messages['es'] = array(
	'userlogin-login-heading' => 'Iniciar sesión',
	'userlogin-forgot-password' => '¿Olvidaste tu contraseña?',
	'userlogin-remembermypassword' => 'Permanecer conectado',
	'userlogin-error-noname' => 'Perdón, rellene el campo de nombre de usuario.',
	'userlogin-error-sessionfailure' => 'El registro de la sesión ha caducado. Por favor, inicia sesión de nuevo.',
	'userlogin-error-nosuchuser' => 'No reconocemos este nombre. No olvides que los nombres de usuario distinguen mayúsculas de minúsculas.',
	'userlogin-error-wrongpassword' => 'Vaya, contraseña errónea. Asegúrate que la tecla Bloq Mayús (Caps Lock) está desactivada y vuelve a intentarlo.',
	'userlogin-error-wrongpasswordempty' => 'Perdón, rellena el campo de la contraseña.',
	'userlogin-error-resetpass_announce' => 'Parece que utilizaste una contraseña temporal. Elige aquí una nueva contraseña para continuar la sesión.',
	'userlogin-error-login-throttled' => 'Has intentado iniciar sesión con la contraseña incorrecta demasiadas veces. Espera un rato antes de volver a intentarlo.',
	'userlogin-error-login-userblocked' => 'Tu nombre de usuario ha sido bloqueado y no puede utilizarse para iniciar sesión.',
	'userlogin-error-edit-account-closed-flag' => 'Tu cuenta ha sido deshabilitada por Wikia.',
	'userlogin-error-cantcreateaccount-text' => 'Tu dirección IP no está autorizada para crear cuentas nuevas.',
	'userlogin-error-userexists' => 'Alguien ya tiene este nombre de usuario. ¡Prueba uno diferente!',
	'userlogin-error-invalidemailaddress' => 'Por favor, introduce una dirección de correo electrónico válida.',
	'userlogin-get-account' => '¿No tienes una cuenta? [[Special:UserSignup|Regístrate]]',
	'userlogin-error-invalid-username' => 'Nombre de usuario no válido',
	'userlogin-error-userlogin-unable-info' => 'Lo sentimos, no es posible registrar tu cuenta en este momento.',
	'userlogin-error-user-not-allowed' => 'Este nombre de usuario no esta permitido.',
	'userlogin-error-captcha-createaccount-fail' => 'La palabra que has introducido no coincide con la palabra del recuadro, ¡vuelve a intentarlo!',
	'userlogin-error-userlogin-bad-birthday' => 'Perdón, rellena mes, día y año.',
	'userlogin-error-externaldberror' => '¡Lo siento! Nuestro sitio actualmente está teniendo un problema. Inténtalo de nuevo más tarde.',
	'userlogin-error-noemailtitle' => 'Por favor, introduce una dirección de correo electrónico válida.',
	'userlogin-error-acct_creation_throttle_hit' => 'Lo sentimos, pero hoy ya se han creado demasiadas cuentas desde esta dirección IP. Por favor, inténtalo más tarde.',
	'userlogin-error-resetpass_forbidden' => 'No se pueden cambiar las contraseñas',
	'userlogin-error-blocked-mailpassword' => 'No puedes solicitar una nueva contraseña porque esta dirección IP está bloqueada por Wikia.',
	'userlogin-error-throttled-mailpassword' => 'Ya hemos enviado un recordatorio de contraseña de esta cuenta en {{PLURAL:$1|la última hora|las $1 últimas horas}}. Por favor, revisa tu correo electrónico.',
	'userlogin-error-mail-error' => 'Perdón, hubo un problema al enviar tu correo electrónico. Por favor, [[Special:Contact/general|contáctanos]].',
	'userlogin-password-email-sent' => 'Hemos enviado una nueva contraseña a la dirección de correo electrónico $1.',
	'userlogin-error-unconfirmed-user' => 'No has confirmado tu dirección de correo electrónico. Confirma tu dirección de correo electrónico primero.',
	'userlogin-password-page-title' => 'Cambia tu contraseña',
	'userlogin-oldpassword' => 'Contraseña antigua',
	'userlogin-newpassword' => 'Nueva contraseña',
	'userlogin-retypenew' => 'Confirma la contraseña nueva',
	'userlogin-password-email-subject' => 'Solicitud de contraseña olvidada',
	'userlogin-password-email-greeting' => 'Hola, $USERNAME.',
	'userlogin-password-email-content' => 'Utiliza esta contraseña temporal para iniciar sesión en Wikia: "$ NEWPASSWORD"
<br><br>
Si no solicitaste una nueva contraseña, ¡no te preocupes! Tu cuenta está segura. Puedes ignorar este mensaje y continuar iniciando sesión en Wikia con tu antigua contraseña.
<br><br>
¿Tienes preguntas o inquietudes? No dudes en ponerte en contacto con nosotros.',
	'userlogin-password-email-body' => 'Hola $2,

Utiliza esta contraseña temporal para iniciar sesión en Wikia: "$3"

Si no solicitaste una nueva contraseña, ¡no te preocupes! Tu cuenta está segura. Puedes ignorar este mensaje y continuar iniciando sesión en Wikia con tu antigua contraseña.

¿Tienes preguntas o inquietudes? No dudes en ponerte en contacto con nosotros.

Equipo de ayuda a la comunidad wikia


___________________________________________

Para comprobar los acontecimientos más recientes en Wikia, visita http://community.wikia.com
¿Deseas controlar qué mensajes de correo electrónico recibes? Ve a: {{fullurl:{{ns:special}}:Preferences}}',
	'userlogin-email-footer-line1' => 'Para comprobar las últimas novedades en Wikia, visita <a style="color:#2a87d5;text-decoration:none;" href="http://es.wikia.com">es.wikia.com</a>',
	'userlogin-email-footer-line2' => '¿Deseas controlar los correos electrónicos que recibes? Ve a tus <a href="{{fullurl:{{ns:special}}:Preferences}}" style="color:#2a87d5;text-decoration:none;">preferencias</a>',
	'userlogin-provider-or' => 'o',
	'userlogin-provider-tooltip-facebook-signup' => 'Pulsa el botón para iniciar sesión con Facebook',
	'userlogin-loginreqlink' => 'iniciar sesión',
	'userlogin-changepassword-needlogin' => 'Necesitas $1 para cambiar la contraseña.',
	'wikiamobile-sendpassword-label' => 'Enviar una nueva contraseña',
	'wikiamobile-facebook-connect-fail' => 'Lo sentimos, pero tu cuenta en Facebook no está actualmente vinculada con una cuenta Wikia.',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'userlogin-login-heading' => 'Најава',
	'userlogin-password-email-greeting' => 'Здраво $USERNAME,',
	'userlogin-password-email-signature' => 'Поддршка за заедницата на Викија',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'userlogin-login-heading' => 'Aanmelden',
	'userlogin-forgot-password' => 'Wachtwoord vergeten?',
	'userlogin-remembermypassword' => 'Aangemeld blijven',
	'userlogin-error-noname' => 'Geef een gebruikersnaam op.',
	'userlogin-error-sessionfailure' => 'Uw aanmeldsessie is verlopen. Meld u opnieuw aan.',
	'userlogin-error-nosuchuser' => 'Deze gebruikersnaam wordt niet herkend. Vergeet niet dat gebruikersnamen hoofdlettergevoelig zijn.',
	'userlogin-error-wrongpassword' => 'Het wachtwoord is onjuist. Vergeet niet dat wachtwoorden hoofdlettergevoelig zijn.',
	'userlogin-error-wrongpasswordempty' => 'Geef een wachtwoord op.',
	'userlogin-error-resetpass_announce' => 'U hebt een tijdelijk wachtwoord gebruikt. Kies een nieuw wachtwoord om door te gaan met aanmelden.',
	'userlogin-error-login-throttled' => 'U hebt te vaak een onjuist wachtwoord ingegeven. Wacht even voordat u het opnieuw probeert.',
	'userlogin-error-login-userblocked' => 'Uw gebruiker is geblokkeerd en er kan niet mee aangemeld worden.',
	'userlogin-error-edit-account-closed-flag' => 'Uw gebruiker is door Wikia buiten werking gesteld.',
	'userlogin-error-cantcreateaccount-text' => 'Via uw IP-adres mogen geen nieuwe gebruikers aangemaakt worden.',
	'userlogin-error-userexists' => 'Deze naam is al in gebruik. Kies een andere.',
	'userlogin-error-invalidemailaddress' => 'Voer alstublieft een geldig e-mailadres in.',
	'userlogin-get-account' => 'Hebt u nog geen gebruiker? [[Special:UserSignup|Registreren]]',
	'userlogin-error-invalid-username' => 'Ongeldige gebruikersnaam',
	'userlogin-error-userlogin-unable-info' => 'Het is helaas niet mogelijk uw gebruiker op dit moment te registreren.',
	'userlogin-error-user-not-allowed' => 'Deze gebruikersnaam is niet toegestaan.',
	'userlogin-password-page-title' => 'Uw wachtwoord wijzigen',
	'userlogin-oldpassword' => 'Huidige wachtwoord',
	'userlogin-newpassword' => 'Nieuw wachtwoord',
	'userlogin-retypenew' => 'Herhaling nieuwe wachtwoord',
	'userlogin-password-email-subject' => 'Verzoek voor nieuw wachtwoord',
	'userlogin-password-email-greeting' => 'Hallo $USERNAME,',
	'userlogin-password-email-content' => 'Gebruik het volgende tijdelijke wachtwoord om aan te melden bij Wikia: "$NEWPASSWORD".
<br /><br />
Maak u geen zorgen als u geen nieuw wachtwoord hebt opgevraagd. Uw gebruiker is veilig. U kunt deze e-mail negeren en blijven aanmelden bij Wikia met uw oude wachtwoord.
<br /><br />
Neem alstublieft contact met ons op als u vragen of zorgen hebt.',
	'userlogin-password-email-signature' => 'Wikia Community Support',
	'userlogin-password-email-body' => 'Hallo $2,

Gebruik het volgende tijdelijke wachtwoord om aan te melden bij Wikia: "$3".

Maak u geen zorgen als u geen nieuw wachtwoord hebt opgevraagd. Uw gebruiker is veilig. U kunt deze e-mail negeren en blijven aanmelden bij Wikia met uw oude wachtwoord.

Neem alstublieft contact met ons op als u vragen of zorgen hebt.


___________________________________________
Bezoek http://community.wikia.com voor het laatste nieuws over Wikia.
Om in te stellen welke e-mails u wilt ontvangen, gaat u naar {{fullurl:{{ns:special}}:Preferences}}.',
	'userlogin-provider-or' => 'Of',
	'userlogin-provider-tooltip-facebook' => 'Klik op de knop om aan te melden via Facebook',
	'userlogin-provider-tooltip-facebook-signup' => 'Klik op de knop om te registreren via Facebook',
	'userlogin-facebook-show-preferences' => 'Feedvoorkeuren van Facebook weergeven',
	'userlogin-facebook-hide-preferences' => 'Feedvoorkeuren van Facebook verbergen',
	'userlogin-loginreqlink' => 'aanmelden',
	'userlogin-changepassword-needlogin' => 'U moet $1 om uw wachtwoord te kunnen wijzigen.',
	'wikiamobile-sendpassword-label' => 'Nieuw wachtwoord sturen',
	'wikiamobile-facebook-connect-fail' => 'Uw Facebookgebruiker is op het moment niet gekoppeld met uw Wikiagebruiker.',
);

