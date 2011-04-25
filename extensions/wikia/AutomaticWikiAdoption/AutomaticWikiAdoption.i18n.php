<?php
/**
 * AutomaticWikiAdoption
 *
 * An AutomaticWikiAdoption extension for MediaWiki
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2010-10-05
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/AutomaticWikiAdoption/AutomaticWikiAdoption_setup.php");
 */

$messages = array();

$messages['en'] = array(
	'automaticwikiadoption' => 'Automatic wiki adoption',
	'automaticwikiadoption-desc' => 'An AutomaticWikiAdoption extension for MediaWiki',
	'automaticwikiadoption-header' => 'Adopt this wiki',
	'automaticwikiadoption-button-adopt' => 'Adopt now',
	'automaticwikiadoption-description' => "You have contributed to this wiki, but there is no active administrator. Would you like the job?

Being an administrator means that you will need to keep contributing content, but also encourage anyone else on the wiki directly, and be available to help them out when they need you.

In return, we will give you the power to block / unblock users, lock pages from editing, and a whole bunch of other features. We will also send you an e-mail when anyone else edits this wiki.

In short, you will have ownership, and you can shape this site to whatever you want it to be.

Sound like fun?",
	'automaticwikiadoption-know-more-header' => 'Want to know more?',
	'automaticwikiadoption-know-more-description' => 'Check out these links for more information. And of course, feel free to contact us if you have any questions!',
	'automaticwikiadoption-adoption-successed' => 'Congratulations! You are a now an administrator on this wiki!',
	'automaticwikiadoption-adoption-failed' => "We are sorry. We tried to make you an administrator, but it did not work out. Please [http://community.wikia.com/Special:Contact contact us], and we will try to help you out.",
	'automaticwikiadoption-not-allowed' => "We are sorry. You cannot adopt this wiki right now.",
	'automaticwikiadoption-not-enough-edits' => "Oops! You need to have more than 10 edits to adopt this wiki.",
	'automaticwikiadoption-adopted-recently' => "Oops! You have already adopted another wiki recently. You will need to wait a while before you can adopt a new wiki.",
	'automaticwikiadoption-log-reason' => 'Automatic Wiki Adoption',
	'automaticwikiadoption-notification' => "$1 is up for adoption! You can become the new owner. $2!",
	'automaticwikiadoption-mail-first-subject' => "We have not seen you around in a while",
	'automaticwikiadoption-mail-first-content' => "Hi $1,

It's been a couple of weeks since we have seen an administrator on your wiki. Remember, your community will be looking to you to make sure the wiki is running smoothly.

If you need help taking care of the wiki, you can also allow other community members to become administrators by going to $2.

The Wikia Team

Click the following link to unsubscribe from changes to this list: $3.",
	'automaticwikiadoption-mail-first-content-HTML' => "Hi $1,<br /><br />
It's been a couple of weeks since we have seen an administrator on your wiki. Remember, your community will be looking to you to make sure the wiki is running smoothly.<br /><br />
If you need help taking care of the wiki, you can also allow other community members to become administrators by going to <a href=\"$2\">User rights management</a>.<br /><br />
<b>The Wikia Team</b><br /><br />
<small>You can <a href=\"$3\">unsubscribe</a> from changes to this list.</small>",
	'automaticwikiadoption-mail-second-subject' => "We will put your wiki up for adoption soon",
	'automaticwikiadoption-mail-second-content' => "Hi $1,

It's been a while since we have seen an administrator around on your wiki. It is important to have active administrators for the community so the wiki can continue to run smoothly - so we will put your wiki up for adoption soon to give it a chance to have active administrators again.

The Wikia Team

Click the following link to unsubscribe from changes to this list: $3.",
	'automaticwikiadoption-mail-second-content-HTML' => "Hi $1,

It's been a while since we have seen an administrator around on your wiki. It is important to have active administrators for the community so the wiki can continue to run smoothly - so we will put your wiki up for adoption soon to give it a chance to have active administrators again.

<b>The Wikia Team</b>

<small>You can <a href=\"$3\">unsubscribe</a> from changes to this list.</small>",
	'automaticwikiadoption-mail-adoption-subject' => 'Your wiki has been adopted',
	'automaticwikiadoption-mail-adoption-content' => "Hi $1,

Your wiki has been adopted! This means that someone else has volunteered to help maintain the community and content on the site. Do not worry - you are still an administrator, and you are welcome to come back at any time.

The Wikia Team

Click the following link to unsubscribe from changes to this list: $3.",
	'automaticwikiadoption-mail-adoption-content-HTML' => "Hi $1,<br /><br />
Your wiki has been adopted! This means that someone else has volunteered to help maintain the community and content on the site. Do not worry - you are still an administrator, and you are welcome to come back at any time.<br /><br />
<b>The Wikia Team</b><br /><br />
<small>You can <a href=\"$3\">unsubscribe</a> from changes to this list.</small>",
	'tog-adoptionmails' => 'E-mail me if $1 will become available for other users to adopt',
	'automaticwikiadoption-pref-label' => 'Changing these preferences will only affect e-mails from $1.',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'automaticwikiadoption-know-more-header' => 'Wil u meer weet?',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Y-M D
 */
$messages['br'] = array(
	'automaticwikiadoption-header' => 'Degemer ar wiki-mañ',
	'automaticwikiadoption-button-adopt' => 'Degemer bremañ',
	'automaticwikiadoption-know-more-header' => "C'hoant gouzout hiroc'h ?",
	'automaticwikiadoption-know-more-description' => "Sellit ouzh al liammoù-se evit gouzout hiroc'h. Ha deuit hardizh e darempred ganimp m'ho peus goulenn pe c'houlenn !",
	'automaticwikiadoption-adoption-successed' => "Gourc'hemennoù ! Merour oc'h bremañ war ar wiki-mañ !",
	'automaticwikiadoption-adoption-failed' => "Digarezit ac'hanomp. Klasket on eus lakaat ac'hanoc'h da verour, met ne ya ket en-dro. Mar plij [http://community.wikia.com/Special:Contact deuit e darempred ganeomp], hag e klaskimp skoazellañ ac'hanoc'h.",
	'automaticwikiadoption-not-allowed' => "Digarezit ac'hanomp. Ne c'hellit ket degemer ar wiki-mañ bremañ.",
	'automaticwikiadoption-notification' => "$1 a zo prest da vezañ degemeret ! Gellout a rit bezañ ar perc'henn nevez. $2 !",
	'automaticwikiadoption-mail-first-subject' => "N'hon eus ket gwelet ac'hanoc'h abaoe pell",
	'automaticwikiadoption-mail-adoption-subject' => 'Degemeret eo bet ho wiki !',
	'tog-adoptionmails' => 'Kas din ur postel pa cheñch un dra bennak da geñver merañ ar wiki (merourien hepken)',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'automaticwikiadoption-header' => 'Usvoji ovu wiki',
	'automaticwikiadoption-button-adopt' => 'Usvoji odmah',
	'automaticwikiadoption-know-more-header' => 'Želite saznati više?',
	'automaticwikiadoption-adoption-successed' => 'Čestitke! Sada ste administator na ovoj wiki!',
);

/** German (Deutsch)
 * @author Claudia Hattitten
 * @author LWChris
 */
$messages['de'] = array(
	'automaticwikiadoption' => 'Automatische Wikiübernahme',
	'automaticwikiadoption-header' => 'Dieses Wiki übernehmen',
	'automaticwikiadoption-button-adopt' => 'Jetzt übernehmen',
	'automaticwikiadoption-know-more-header' => 'Möchtest du mehr wissen?',
	'automaticwikiadoption-know-more-description' => 'Sieh dir diese Links für weitere Informationen an. Und natürlich, zögere nicht uns zu kontaktieren, wenn du Fragen hast!',
	'automaticwikiadoption-adoption-successed' => 'Herzlichen Glückwunsch! Du bist jetzt ein Administrator in diesem Wiki!',
	'automaticwikiadoption-adoption-failed' => 'Tut uns leid. Wir haben versucht, dich zu einem Administrator zu machen, aber es hat nicht funktioniert. Bitte [http://community.wikia.com/Special:Contact kontaktiere uns], und wir werden versuchen, dir weiterzuhelfen.',
	'automaticwikiadoption-not-allowed' => 'Tut uns leid. Du kannst dieses Wiki gerade nicht übernehmen.',
	'automaticwikiadoption-not-enough-edits' => 'Auweia! Du musst mehr als 10 Bearbeitungen getätigt haben, um dieses Wiki adoptieren zu können.',
	'automaticwikiadoption-adopted-recently' => 'Auweia! Du hast in letzter Zeit bereits ein anderes Wiki adoptiert. Du musst eine Weile warten, bevor du ein weiteres Wiki adoptieren kannst.',
	'automaticwikiadoption-log-reason' => 'Automatische Wikiübernahme',
	'automaticwikiadoption-notification' => "$1 kann übernommen werden! Du kannst der neue Besitzer werden. $2!",
	'automaticwikiadoption-mail-first-subject' => 'Wir haben dich eine Weile nicht gesehen',
	'automaticwikiadoption-mail-first-content-HTML' => 'Hallo $1, <br /><br />
Es ist ein paar Wochen her, dass wir ein Administrator in deinem Wiki gesehen haben. Denk daran, deine Community wird von dir erwarten, dass das Wiki reibungslos läuft.<br /><br />
Wenn du Hilfe bei der Betreuung des Wikis benötigst, kannst du in der <a href="$2">Benutzerrechteverwaltung</a> auch anderen Community-Mitgliedern erlauben, Administrator zu werden.<br /><br />
<b>Das Wikia-Team</b> <br /><br />
<small>Du kannst Änderungen an dieser Liste <a href="$3">abbestellen</a>.</small>',
	'automaticwikiadoption-mail-second-subject' => 'Dein Wiki wird bald zur Adoption freigegeben',
	'automaticwikiadoption-mail-second-content' => 'Hallo $1,

es ist schon eine Weile her, dass wir einen Administrator in deinem Wiki gesehen haben. Es ist wichtig, aktive Administratoren für die Gemeinschaft zu haben, damit das Wiki weiterhin reibungslos funktionieren kann - also wird dein Wiki bald zur Adoption freigegeben, um ihm eine Chance zu geben, wieder aktive Administratoren zu haben.

Das Wikia-Team

Klicke auf den folgenden Link, um Änderungen an dieser Liste abzubestellen: $3.',
	'automaticwikiadoption-mail-second-content-HTML' => 'Hallo $1,

es ist schon eine Weile her, dass wir einen Administrator in deinem Wiki gesehen haben. Es ist wichtig, aktive Administratoren für die Gemeinschaft zu haben, damit das Wiki weiterhin reibungslos funktionieren kann - also wird dein Wiki bald zur Adoption freigegeben, um ihm eine Chance zu geben, wieder aktive Administratoren zu haben.

<b>Das Wikia-Team</b>

<small>Du kannst Änderungen an dieser Liste <a href="$3">abbestellen</a>.</small>',
	'automaticwikiadoption-mail-adoption-subject' => 'Dein Wiki wurde adoptiert',
	'automaticwikiadoption-mail-adoption-content' => 'Hallo $1,

Dein Wiki wurde übernommen! Das bedeutet, dass jemand anderes freiwillig bei der Aufrechterhaltung der Community und Inhalte auf der Website helfen wird. Mach dir keine Sorgen - du bist immer noch ein Administrator, und du bist jederzeit willkommen zurückzukehren.

Das Wikia-Team

Klicke auf den folgenden Link, um Änderungen an dieser Liste abzubestellen: $3.',
	'automaticwikiadoption-mail-adoption-content-HTML' => 'Hallo $1,<br /><br />
Dein Wiki wurde übernommen! Das bedeutet, dass jemand anderes freiwillig bei der Aufrechterhaltung der Community und Inhalte auf der Website helfen wird. Mach dir keine Sorgen - du bist immer noch ein Administrator, und du bist jederzeit willkommen zurückzukehren.<br /><br />
<b>Das Wikia-Team</b><br /><br />
<small>Du kannst Änderungen an dieser Liste <a href="$3">abbestellen</a>.</small>',
	'tog-adoptionmails' => 'Mich per E-Mail benachrichtigen, wenn $1 zur Adoption durch andere Benutzer freigegeben wird',
	'automaticwikiadoption-pref-label' => 'Eine Änderung dieser Einstellungen wirkt sich nur auf E-Mails von $1 aus.',
);

/** Spanish (Español)
 * @author VegaDark
 */
$messages['es'] = array(
	'automaticwikiadoption' => 'Adopción automática de wikis',
	'automaticwikiadoption-header' => 'Adopta esta wiki',
	'automaticwikiadoption-button-adopt' => 'Adoptar ahora',
	'automaticwikiadoption-know-more-header' => '¿Quieres saber más?',
	'automaticwikiadoption-know-more-description' => 'Revisa estos enlaces para obtener más información. Y, por supuesto, ¡no dudes en contactarnos si tienes alguna pregunta!',
	'automaticwikiadoption-adoption-successed' => '¡Felicitaciones! ¡Ahora eres un administrador en esta wiki!',
	'automaticwikiadoption-adoption-failed' => 'Lo sentimos. Intentamos hacerte administrador, pero no ha funcionado. Por favor [http://community.wikia.com/Special:Contact contáctanos], y trataremos de ayudarte.',
	'automaticwikiadoption-not-allowed' => 'Lo sentimos. No puedes adoptar esta wiki por ahora.',
	'automaticwikiadoption-not-enough-edits' => '¡Oops! Necesitas tener más de 10 ediciones para adoptar este wiki.',
	'automaticwikiadoption-adopted-recently' => '¡Oops! Ya has adoptado otro wiki recientemente. Necesitas esperar un tiempo antes de que puedas adoptar un nuevo wiki.',
	'automaticwikiadoption-log-reason' => 'Adopción automática de wikis',
	'automaticwikiadoption-notification' => "¡$1 está disponible para la adopción! Puedes ser el nuevo fundador. $2.",
	'automaticwikiadoption-mail-first-subject' => 'No te hemos visto desde hace algún tiempo',
	'automaticwikiadoption-mail-first-content-HTML' => 'Hola $1,<br /><br />
Han pasado un par de semanas desde que hemos visto a un administrador en tu wiki. Recuerda, tu comunidad te estará buscando para asegurarse que la wiki trabaja sin problemas.<br /><br />
Si necesitas ayuda para cuidar de la wiki, puedes permitir que otros miembros de la comunidad sean administradores, yendo a <a href="$2">Configuración de permisos de usuarios</a>.<br /><br />
<b>El Equipo de Wikia</b><br /><br />
<small>Puedes <a href="$3">cancelar tu suscripción</a> para futuros cambios de esta lista.</small>',
	'automaticwikiadoption-mail-second-subject' => 'Pondremos tu wiki pronta para la adopción',
	'automaticwikiadoption-mail-second-content' => 'Hola $1,

Han pasado un par de semanas desde que hemos visto a un administrador en tu wiki. Es importante tener administradores activos para la comunidad así la wiki puede continuar trabajando sin problemas, así que pondremos tu wiki en adopción y darle un chance para que tenga administradores activos nuevamente.

El Equipo de Wikia

Haz clic en el siguiente enlace para cancelar tu suscripción de esta lista: $3.',
	'automaticwikiadoption-mail-second-content-HTML' => 'Hola $1,

Han pasado un par de semanas desde que hemos visto a un administrador en tu wiki. Es importante tener administradores activos para la comunidad así la wiki puede continuar trabajando sin problemas, así que pondremos tu wiki en adopción y darle un chance para que tenga administradores activos nuevamente.

El Equipo de Wikia

<small>Puedes <a href="$3">cancelar</a> tu suscripción de esta lista.</small>',
	'automaticwikiadoption-mail-adoption-subject' => 'Tu wiki ha sido adoptada',
	'automaticwikiadoption-mail-adoption-content' => 'Hola $1,

¡Tu wiki ha sido adoptada! Esto significa que otro usuario a colaborado para ayudar a mantener a la comunidad y el contenido en el sitio. No te preocupes, aún sigues siendo un administrador, y eres bienvenido a regresar en cualquier momento.

El Equipo de Wikia

Haz clic en el siguiente enlace para cancelar tu suscripción de la lista: $3.',
	'automaticwikiadoption-mail-adoption-content-HTML' => 'Hola $1,<br /><br />
¡Tu wiki ha sido adoptada! Esto significa que otro usuario a colaborado para ayudar a mantener a la comunidad y el contenido en el sitio. No te preocupes, aún sigues siendo un administrador, y eres bienvenido a regresar en cualquier momento.<br /><br />
<b>El Equipo de Wikia</b><br /><br />
<small>Puedes <a href="$3">cancelar</a> tu suscripción de esta lista.</small>',
	'tog-adoptionmails' => 'Notificarme por correo electrónico si $1 está disponible para otros usuarios para adoptar.',
	'automaticwikiadoption-pref-label' => 'Cambiar estas preferencias solo afectarán los correos electrónicos de $1.',
);

/** Persian (فارسی)
 * @author Wayiran
 */
$messages['fa'] = array(
	'automaticwikiadoption' => 'اتخاذ خودکار ویکی',
	'automaticwikiadoption-header' => 'اتخاذ این ویکی',
	'automaticwikiadoption-button-adopt' => 'هم‌اکنون اتخاذ کن',
	'automaticwikiadoption-know-more-header' => 'چگونه بیش‌تر بدانیم؟',
);

/** Finnish (Suomi)
 * @author Nike
 * @author Tofu II
 */
$messages['fi'] = array(
	'automaticwikiadoption-header' => 'Adoptoi tämä wiki',
	'automaticwikiadoption-button-adopt' => 'Adoptoi nyt',
	'automaticwikiadoption-know-more-header' => 'Haluatko tietää enemmän?',
	'automaticwikiadoption-adoption-successed' => 'Onnittelut! Olet nyt ylläpitäjä tässä wikissä!',
	'automaticwikiadoption-notification' => "$1 on adoptoitavana! Sinusta voi tulla uusi omistaja. $2!",
);

/** French (Français) */
$messages['fr'] = array(
	'automaticwikiadoption' => 'Adoption de wiki automatique',
	'automaticwikiadoption-header' => 'Adopter ce wiki',
	'automaticwikiadoption-button-adopt' => 'Adopter maintenant',
	'automaticwikiadoption-know-more-header' => 'Vous voulez en savoir plus ?',
	'automaticwikiadoption-know-more-description' => "Veuillez consultez ces liens pour plus d'informations. Et, bien entendu, n’hésitez pas à nous contacter si vous avez des questions !",
	'automaticwikiadoption-adoption-successed' => 'Félicitations ! Vous êtes maintenant administrateur sur ce wiki !',
	'automaticwikiadoption-adoption-failed' => 'Nous sommes désolés. Nous avons essayé de vous nommer administrateur, mais cela n’a pas fonctionné. Veuillez [http://community.wikia.com/Special:Contact nous contacter], et nous allons essayer de vous aider.',
	'automaticwikiadoption-not-allowed' => 'Nous sommes désolés. Vous ne pouvez pas adopter ce wiki maintenant.',
	'automaticwikiadoption-log-reason' => 'Adoption de wiki automatique',
	'automaticwikiadoption-notification' => "$1 est disponible pour l’adoption ! Vous pouvez en devenir le nouveau propriétaire. $2 !",
	'automaticwikiadoption-mail-first-subject' => 'Nous ne vous avons pas vu depuis un bon moment',
	'automaticwikiadoption-mail-first-content-HTML' => 'Bonjour $1,<br /><br />
Cela fait quelques semaines que nous n’avons pas vu d’administrateur sur votre wiki. Rappelez-vous que votre communauté se tournera vers vous pour s’assurer que le wiki fonctionne sans problème.<br /><br />
Si vous avez besoin d’aide pour prendre soin du wiki, vous pouvez aussi permettre aux membres de la communauté de devenir des administrateurs en allant dans le <a href="$2">gestionnaire des droits des utilisateurs</a>.<br /><br />
<b>L’équipe Wikia</b><br /><br />
<small>Vous pouvez <a href="$3">vous désabonner</a> des mises à jour de cette liste.</small>',
	'automaticwikiadoption-mail-second-subject' => 'Nous mettrons votre wiki disponible pour l’adoption dans peu de temps',
	'automaticwikiadoption-mail-second-content' => 'Bonjour $1,

Cela fait un certain temps que nous n’avons pas vu d’administrateur sur votre wiki. Il est important d’avoir des administrateurs actifs dans la communauté pour que le wiki continue de fonctionner sans problème. Nous allons donc rendre votre wiki disponible pour l’adoption dans peu de temps, afin qu’il ait une chance d’avoir à nouveau des administrateurs actifs.

L’équipe Wikia

Cliquez sur le lien suivant pour vous désinscrire des mises à jour de cette liste : $3.',
	'automaticwikiadoption-mail-second-content-HTML' => 'Bonjour $1,

Cela fait un certain temps que nous n’avons pas vu d’administrateur sur votre wiki. Il est important d’avoir des administrateurs actifs dans la communauté pour que le wiki continue de fonctionner sans problème. Nous allons donc rendre votre wiki disponible pour l’adoption dans peu de temps, afin qu’il ait une chance d’avoir à nouveau des administrateurs actifs.

<b>L’équipe Wikia</b>

<small>Cliquez sur le lien suivant pour <a href="$3">vous désabonner</a> des mises à jour de cette liste.</small>',
	'automaticwikiadoption-mail-adoption-subject' => 'Votre wiki a été adopté',
	'automaticwikiadoption-mail-adoption-content' => 'Bonjour $1,

Votre wiki a été adopté ! Cela signifie que quelqu’un d’autre s’est porté volontaire pour maintenir la communauté et le contenu du site. Ne vous inquiétez pas - vous êtes toujours administrateur et vous êtes invité à revenir à tout moment.

L’équipe Wikia

Cliquez sur le lien suivant pour vous désabonner des mises à jour de cette liste : $3.',
	'automaticwikiadoption-mail-adoption-content-HTML' => 'Bonjour $1,<br /><br />
Votre wiki a été adopté ! Cela signifie que quelqu’un d’autre s’est porté volontaire pour maintenir la communauté et le contenu du site. Ne vous inquiétez pas - vous êtes toujours administrateur et vous êtes invité à revenir à tout moment.<br /><br />
<b>L’équipe Wikia</b><br /><br />
<small>Cliquez sur le lien suivant pour <a href="$3">vous désabonner</a> des mises à jour de cette liste.</small>',
	'tog-adoptionmails' => 'Écrivez-moi lorsque quelque chose change à propos de l’administration du wiki (administrateurs seulement)',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'automaticwikiadoption-mail-adoption-subject' => 'Adoptaron o seu wiki',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'automaticwikiadoption' => 'Adoption automatic de wikis',
	'automaticwikiadoption-header' => 'Adoptar iste wiki',
	'automaticwikiadoption-button-adopt' => 'Adoptar ora',
	'automaticwikiadoption-know-more-header' => 'Vole saper plus?',
	'automaticwikiadoption-know-more-description' => 'Explora iste ligamines pro plus informationes. E, naturalmente, sia libere de contactar nos si tu ha questiones!',
	'automaticwikiadoption-adoption-successed' => 'Felicitationes! Tu es ora administrator de iste wiki!',
	'automaticwikiadoption-adoption-failed' => 'Nos lo regretta: nos ha tentate facer te administrator, ma le procedura non ha succedite. Per favor [http://community.wikia.com/Special:Contact contacta nos], e nos tentara adjutar te.',
	'automaticwikiadoption-not-allowed' => 'Nos regretta que tu non pote adoptar iste wiki justo ora.',
	'automaticwikiadoption-not-enough-edits' => 'Ups! Tu debe haber facite plus de 10 modificationes pro poter adoptar iste wiki.',
	'automaticwikiadoption-adopted-recently' => 'Ups! Tu ha jam adoptate un wiki recentemente. Tu debe attender un certe tempore ante que tu pote adoptar un altere wiki.',
	'automaticwikiadoption-log-reason' => 'Adoption automatic de wikis',
	'automaticwikiadoption-notification' => "$1 es disponibile pro adoption! Tu pote devenir le nove proprietario. $2.",
	'automaticwikiadoption-mail-first-subject' => 'Nos non te ha vidite durante un tempore',
	'automaticwikiadoption-mail-first-content-HTML' => 'Salute $1,<br /><br />
Plure septimanas ha passate depost que nos ha vidite un administrator in tu wiki. Rememora que tu communitate depende de te pro assecurar le bon functionamento del wiki.<br /><br />
Si tu ha besonio de adjuta pro le gerentia del wiki, tu pote permitter a altere membros de devenir administrator via le pagina pro <a href="$2">gestion de derectos de usator</a>.<br /><br />
<b>Le equipa de Wikia</b><br /><br />
<small>Tu pote <a href="$3">cancellar le subscription</a> al cambios a iste lista.</small>',
	'automaticwikiadoption-mail-second-subject' => 'Nos rendera tu wiki disponibile pro adoption tosto',
	'automaticwikiadoption-mail-second-content' => 'Salute $1,

Un certe tempore ha passate depost que nos ha vidite un administrator connectite in tu wiki. Es importante haber administratores active pro le communitate pro assecurar le bon functionamento del wiki; dunque, nos offerera tosto le wiki pro adoption, de sorta que illo pote haber de novo administratores active.

Le equipa de Wikia

Clicca le sequente ligamine pro cancellar le subscription al cambios in iste lista: $3.',
	'automaticwikiadoption-mail-second-content-HTML' => 'Salute $1,

Un certe tempore ha passate depost que nos ha vidite un administrator active in tu wiki. Es importante haber administratores active in le communitate pro assecurar le bon functionamento del wiki, dunque nos offerera tosto tu wiki pro adoption a fin que illo pote haber de novo administratores active.

<b>Le equipa de Wikia</b>

<small>Tu pote <a href="$3">cancellar le subscription</a> a cambiamentos in iste lista.</small>',
	'automaticwikiadoption-mail-adoption-subject' => 'Tu wiki ha essite adoptate',
	'automaticwikiadoption-mail-adoption-content' => 'Salute $1,

Tu wiki ha essite adoptate! Isto vole dicer que alcuno altere se ha offerite como voluntario pro adjutar a mantener le communitate e contento in le sito. Non te inquieta; tu es ancora administrator, e tu es benvenite a retornar quandocunque tu vole.

Le equipa de Wikia

Clicca le sequente ligamine pro cancellar le subscription a cambiamentos in iste wiki: $3.',
	'automaticwikiadoption-mail-adoption-content-HTML' => 'Salute $1,

Tu wiki ha essite adoptate! Isto significa que un altere persona se ha offerite pro adjutar a mantener le communitate e contento del sito. Non te inquieta: tu continua a esser administrator, e tu es benvenite a retornar a omne momento.

<b>Le equipa de Wikia</b>

<small>Tu pote <nowiki><a href="{{fullurl:{{ns:special}}:Preferences}}">cancellar le subscription</a></nowiki> al modificationes de iste lista.</small>',
	'tog-adoptionmails' => 'Inviar me e-mail si $1 devenira disponibile pro adoption per altere usatores',
	'automaticwikiadoption-pref-label' => 'Modificar iste preferentias influentiara solmente le messages de e-mail ab $1.',
);

/** Italian (Italiano)
 * @author Minerva Titani
 */
$messages['it'] = array(
	'automaticwikiadoption-header' => 'Adotta questa wiki',
	'automaticwikiadoption-mail-adoption-subject' => 'La tua wiki è stata adottata',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'automaticwikiadoption-know-more-header' => 'Wann Dir méi wësse wëllt.',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'automaticwikiadoption' => 'АвтоматскоПосвојувањеНаВики',
	'automaticwikiadoption-header' => 'Посвој го викиво',
	'automaticwikiadoption-button-adopt' => 'Посвој веднаш',
	'automaticwikiadoption-know-more-header' => 'Сакате да дознаете повеќе?',
	'automaticwikiadoption-know-more-description' => 'За повеќе информации, погледајте ги овие врски. И секако, најслободно обратете ни се ако имате прашања!',
	'automaticwikiadoption-adoption-successed' => 'Честитаме! Сега сте администратор на ова вики!',
	'automaticwikiadoption-adoption-failed' => 'Нажалост, се обидовме да ве назначиме за администратор, но не успеавме. [http://community.wikia.com/Special:Contact Контактирајте нè], и ќе се обидеме да ви помогнеме.',
	'automaticwikiadoption-not-allowed' => 'Нажалост, во моментов не можете да го посвоите ова вики.',
	'automaticwikiadoption-not-enough-edits' => 'Упс! Мора да имате барем 10 уредувања за да можете да го присвоите викито.',
	'automaticwikiadoption-adopted-recently' => 'Упс! Неодамна имате посвоено друго вики. Ќе треба да почекате пред да можете да посвоите уште едно.',
	'automaticwikiadoption-log-reason' => 'Автоматско посвојување на вики',
	'automaticwikiadoption-notification' => "$1 може да се посвои! Имате можност да бидете новиот сопственик. $2.",
	'automaticwikiadoption-mail-first-subject' => 'Не ве имаме видено во последно време',
	'automaticwikiadoption-mail-first-content-HTML' => 'Здраво $1,<br /><br />
Има пар недели како немаме видено администратор на вашето вики. Запомнете дека вашата заедница очекува од вас да се грижите викито да работи правилно.<br /><br />
Ако ви треба помош со одржувањето на викито, можете да назначите и други членови на заедницата за администратори на страницата<a href="$2">Раководење со кориснички права</a>.<br /><br />
<b>Екипата на Викија</b><br /><br />
<small>Можете да се <a href="$3">отпишете</a> за повеќе да не добивате известувања за измените на овој список.</small>',
	'automaticwikiadoption-mail-second-subject' => 'Наскоро ќе го понудиме вашето вики за посвојување',
	'automaticwikiadoption-mail-second-content' => 'Hi $1,
Помина извесно време како не сме виделе администратор на вашето вики. Од голема важност е да имате активни администратори на викито за да може да работи правилно - затоа ќе ви го дадеме викито на посвојување, давајќи му шанса повторно да има активни администратори.

Екипата на Викија

Ако сакате да не добивање известувања за измените на списоков, проследете ја врската: $3.',
	'automaticwikiadoption-mail-second-content-HTML' => 'Здраво $1,

Помина извесно време како не сме виделе администратор на вашето вики. Од голема важност е да имате активни администратори на викито за да може да работи правилно - затоа ќе ви го дадеме викито на посвојување, давајќи му шанса повторно да има активни администратори.

<b>Екипата на Викија</b>

<small>Можете да се <a href="$3">отпишете</a> за повеќе да не добивате известувања за измените на овој список.</small>',
	'automaticwikiadoption-mail-adoption-subject' => 'Вашето вики е посвоено',
	'automaticwikiadoption-mail-adoption-content' => 'Здраво $1,

Вашето вики е посвоено! Ова значи дека некој се пријавил да ја одржува заедницата и содржините на мрежното место. Не грижете се - вие останувате администратор, и добредојдени сте да се вратите во секое време.

Екипата на Викија

Ако сакате да не добивање известувања за измените на списоков, проследете ја врската: $3.',
	'automaticwikiadoption-mail-adoption-content-HTML' => 'Здраво $1,<br /><br />
Вашето вики е посвоено! Ова значи дека некој се пријавил да ја одржува заедницата и содржините на мрежното место. Не грижете се - вие останувате администратор, и добредојдени сте да се вратите во секое време..<br /><br />
<b>Екипата на Викија</b><br /><br />
<small>Можете да се <a href="$3">отпишете</a> за повеќе да не добивате известувања за измените на овој список.</small>',
	'tog-adoptionmails' => 'Извести ме по е-пошта ако $1 стане достапно за посвојување',
	'automaticwikiadoption-pref-label' => 'Измените во овие нагодувања ќе важат само за -пошта од $1.',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'automaticwikiadoption' => 'Pengambilalihan wiki automatik',
	'automaticwikiadoption-header' => 'Ambil alih wiki ini',
	'automaticwikiadoption-button-adopt' => 'Ambil alih sekarang',
	'automaticwikiadoption-know-more-header' => 'Nak tahu lebih lanjut?',
	'automaticwikiadoption-know-more-description' => 'Apa kata ikut pautan-pautan ini untuk maklumat lanjut. Seperkara lagi, jangan segan menghubungi kami jika ada apa-apa soalan untuk ditanya!',
	'automaticwikiadoption-adoption-successed' => 'Syabas! Anda menjadi pentadbir di wiki ini!',
	'automaticwikiadoption-adoption-failed' => 'Maaf. Kami cuba jadikan anda pentadbir, tetapi tidak menjadi pula. Sila [http://community.wikia.com/Special:Contact hubungi kami], supaya kami boleh membantu anda.',
	'automaticwikiadoption-not-allowed' => 'Maafkan kami, anda tidak boleh mengambil alih wiki ini sekarang.',
	'automaticwikiadoption-log-reason' => 'Penerimaan Hakmilik Wiki Automatik',
	'automaticwikiadoption-notification' => "$1 perlu diambil alih! Mungkin anda pemilik baru yang dicari-cari. $2!",
	'automaticwikiadoption-mail-first-subject' => 'Sudah sekian lama kami tak berjumpa dengan anda',
	'automaticwikiadoption-mail-first-content-HTML' => 'Apa khabar $1,<br /><br />
Sudah dua minggu sejak kami melihat seorang pentadbir yang bertugas di wiki anda. Ingat, komuniti anda akan bergantung pada anda untuk memastikan wiki ini berjalan dengan lancar.<br /><br />
Jika anda memerlukan bantuan untuk menjaga wiki, anda juga boleh membenarkan ahli komuniti lain untuk menjadi pentadbir dengan menggunakan <a href="$2">Pengurusan hak pengguna</a>.<br /><br />
<b>Pasukan Wikia</b><br /><br />
<small>Anda boleh <a href="$3">berhenti melanggan</a> perubahan pada senarai ini.</small>',
	'automaticwikiadoption-mail-second-subject' => 'Kami akan mencari seseorang untuk mengambil alih wiki anda nanti.',
	'automaticwikiadoption-mail-second-content' => 'Apa khabar $1,

Sudah sekian lama sejak kali terakhir wujudnya seorang pentadbir yang aktif di wiki anda. Kehadiran pentadbir yang aktif adalah penting kepada komuniti supaya wiki boleh terus berjalan dengan lancar, jadi kami akan mencari pihak lain untuk mengambil alih wiki anda tidak lama lagi supaya ia boleh diselenggara oleh pentadbir yang aktif semula.

Pasukan Wikia

Klik pautan berikut untuk berhenti melanggan perubahan pada senarai ini: $3.',
	'automaticwikiadoption-mail-second-content-HTML' => 'Apa khabar $1,

Sudah sekian lama sejak kali terakhir wujudnya seorang pentadbir yang aktif di wiki anda. Kehadiran pentadbir yang aktif adalah penting kepada komuniti supaya wiki boleh terus berjalan dengan lancar, jadi kami akan mencari pihak lain untuk mengambil alih wiki anda tidak lama lagi supaya ia boleh diselenggara oleh pentadbir yang aktif semula.

<b>Pasukan Wikia</b>

<small>Anda boleh <a href="$3">berhenti melanggan</a> perubahan pada senarai ini.</small>',
	'automaticwikiadoption-mail-adoption-subject' => 'Wiki anda telah diterima',
	'automaticwikiadoption-mail-adoption-content' => 'Apa khabar $1,

Dengan sukacitanya kami maklumkan bahawa wiki anda telah diambil alih, iaitu ada pihak yang menawarkan diri untuk membantu menyelenggara komuniti dan kandungan di tapak itu. Jangan bimbang kerana anda masih seorang pentadbir, dan anda boleh kembali ke situ pada bila-bila masa sahaja.

Pasukan Wikia

Sila klik pautan berikut untuk berhenti melanggan perubahan pada senarai ini: $3.',
	'automaticwikiadoption-mail-adoption-content-HTML' => 'Apa khabar $1,<br /><br />
Dengan sukacitanya kami maklumkan bahawa wiki anda telah diambil alih, iaitu ada pihak yang menawarkan diri untuk membantu menyelenggara komuniti dan kandungan di tapak itu. Jangan bimbang kerana anda masih seorang pentadbir, dan anda boleh kembali ke situ pada bila-bila masa sahaja.<br /><br />
<b>Pasukan Wikia</b><br /><br />
<small>Anda boleh <a href="$3">berhenti melanggan</a> perubahan pada senarai ini.</small>',
	'tog-adoptionmails' => 'E-mel kepada saya apabila terdapat perubahan mengenai pentadbiran wiki (pentadbir sahaja)',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'automaticwikiadoption' => 'Automatische wikiadoptie',
	'automaticwikiadoption-header' => 'Deze wiki adopteren',
	'automaticwikiadoption-button-adopt' => 'Nu adopteren',
	'automaticwikiadoption-know-more-header' => 'Meer te weten komen?',
	'automaticwikiadoption-know-more-description' => 'Volg deze verwijzingen voor meer infomatie. Het staat u natuurlijk ook vrij om contact met ons op te nemen als u vragen hebt.',
	'automaticwikiadoption-adoption-successed' => 'Gefeliciteerd! U bent nu beheerder van deze wiki.',
	'automaticwikiadoption-adoption-failed' => 'We hebben geproberd u bheerder te maken, maar dit lukte helaas niet. [http://community.wikia.com/Special:Contact Neem contact met ons op] zodat we u verder kunnen helpen.',
	'automaticwikiadoption-not-allowed' => 'U kunt deze wiki nu helaas niet adopteren.',
	'automaticwikiadoption-not-enough-edits' => 'U moet meer dan 10 bewerkingen gemaakt hebben om deze wiki te kunnen adopteren.',
	'automaticwikiadoption-adopted-recently' => 'U hebt recentelijk al een wiki geadapteerd. U moet even wachten voordat u nog een wiki kunt adopteren.',
	'automaticwikiadoption-log-reason' => 'Automatische wikiadoptie',
	'automaticwikiadoption-notification' => "$1 kan geadopteerd worden. U kunt de nieuwe eigenaar worden. $2.",
	'automaticwikiadoption-mail-first-subject' => 'We hebben u al een tijdje niet gezien',
	'automaticwikiadoption-mail-first-content-HTML' => 'Hallo $1,<br /><br />
Het is al weer een aantal weken geleden dat er een beheerder actief is geweest op uw wiki. Denk er alstublieft aan dat uw gemeenschap naar u kijkt als het gaat om het soepel laten draaien van de wiki.<br /><br />
Als u hulp nodig hebt bij het zorgen voor de wiki, dan kunt u ook andere gemeenschapsleden beheerder maken via <a href="$2">Gebruikersrechtenbeheer</a>.<br /><br />
<b>Het Wikia-team</b><br /><br />
<small>U kunt zich van wijzigingen op deze lijst <a href="$3">uitschrijven</a>.</small>',
	'automaticwikiadoption-mail-second-subject' => 'Uw wiki wordt binnenkort voor adoptie opgegeven',
	'automaticwikiadoption-mail-second-content' => 'Hallo $1,

Het is al weer even geleden dat we een beheerder hebben zien langskomen bij uw wiki. Het is voor de gemeenschap belangrijk dat er actieve beheerders zijn om ervoor te zorgen dat de wiki lekker blijft draaien. Daarom wordt uw wiki binnenkort beschikbaar gemaakt voor adoptie zodat er weer een kans op actieve beheerders gaat bestaan.

Het Wikia-team

U kunt zich van wijzigingen op deze lijst uitschrijven: $3.',
	'automaticwikiadoption-mail-second-content-HTML' => 'Hallo $1,<br /><br />
Het is al weer even geleden dat we een beheerder hebben zien langskomen bij uw wiki. Het is voor de gemeenschap belangrijk dat er actieve beheerders zijn om ervoor te zorgen dat de wiki lekker blijft draaien. Daarom wordt uw wiki binnenkort beschikbaar gemaakt voor adoptie zodat er weer een kans op actieve beheerders gaat bestaan.<br /><br />
<b>Het Wikia-team</b><br /><br />
<small>U kunt zich van wijzigingen op deze lijst <a href="$3">uitschrijven</a>.</small>',
	'automaticwikiadoption-mail-adoption-subject' => 'Uw wiki is geadopteerd',
	'automaticwikiadoption-mail-adoption-content' => 'Hallo $1,

Uw wiki is geadopteerd! Dit betekent dat iemand anders zich heeft opgeworpen om te helpen bij het onderhouden van de gemeenschap en de inhoud van de site. Vrees niet. U bent nog steeds beheerder en u bent nog steeds op ieder moment van harte welkom.

Het Wikia-team

U kunt zich van wijzigingen op deze lijst uitschrijven: $3.',
	'automaticwikiadoption-mail-adoption-content-HTML' => 'Hallo $1,<br /><br />
Uw wiki is geadopteerd! Dit betekent dat iemand anders zich heeft opgeworpen om te helpen bij het onderhouden van de gemeenschap en de inhoud van de site. Vrees niet. U bent nog steeds beheerder en u bent nog steeds op ieder moment van harte welkom.<br /><br />
<b>Het Wikia-team</b><br /><br />
<small>U kunt zich van wijzigingen op deze lijst <a href="$3">uitschrijven</a>.</small>',
	'tog-adoptionmails' => 'Mij e-mailen als $1 door andere gebruikers geadopteerd kan worden',
	'automaticwikiadoption-pref-label' => 'Het wijzigen van deze voorkeuren heeft alleen invloed op e-mails van $1.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'automaticwikiadoption' => 'Automatisk wikiadopsjon',
	'automaticwikiadoption-header' => 'Adopter denne wikien',
	'automaticwikiadoption-button-adopt' => 'Adopter nå',
	'automaticwikiadoption-know-more-header' => 'Vil du vite mer?',
	'automaticwikiadoption-know-more-description' => 'Sjekk disse lenkene for mer informasjon. Du er selvsagt velkommen til å kontakte oss om du har spørsmål!',
	'automaticwikiadoption-adoption-successed' => 'Gratulerer! Du er nå administrator på denne wikien.',
	'automaticwikiadoption-adoption-failed' => 'Beklager. Vi prøvde å gjøre deg til administrator, men det fungerte ikke. [http://community.wikia.com/Special:Contact Kontakt oss], så skal vi prøve å hjelpe deg.',
	'automaticwikiadoption-not-allowed' => 'Beklager. Du kan ikke adoptere denne wikien akkurat nå.',
	'automaticwikiadoption-log-reason' => 'Automatisk wikiadopsjon',
	'automaticwikiadoption-notification' => "$1 kan adopteres! Du kan bli den nye eieren. $2!",
	'automaticwikiadoption-mail-first-subject' => 'Vi har ikke sett deg på en stund',
	'automaticwikiadoption-mail-first-content-HTML' => 'Hei $1,<br /><br />
Det har gått noen uker siden vi har sett en administrator på wikien din. Husk at fellesskapet regner med at du sørger for at wikien går problemfritt.<br /><br />
Hvis du trenger hjelp til å ta vare på wikien, kan du la andre medlemmer av fellesskapet bli administratorer ved å gå til href="$2">Brukerrettighetskontroll</a>.<br /><br />',
	'automaticwikiadoption-mail-second-subject' => 'Vi vil sette opp wikien din til adopsjon snart',
	'automaticwikiadoption-mail-second-content' => 'Hei $1,

Det er en stund siden vi har sett en administrator på wikien din. Det er viktig å ha aktive administratorer i fellesskapet slik at wikien går problemfritt - så vi vil snart sette opp wikien din for adopsjon slik at den får sjansen til å ha aktive administratorer igjen.

Wikia-teamet

Trykk på følgende lenke for å stoppe abonnementet på endringer fra denne listen: $3.',
	'automaticwikiadoption-mail-second-content-HTML' => 'Hei $1,

Det er en stund siden vi har sett en administrator på wikien din. Det er viktig å ha aktive administratorer i fellesskapet slik at wikien går problemfritt - så vi vil snart sette opp wikien din for adopsjon slik at den får sjansen til å ha aktive administratorer igjen.

<b>Wikia-teamet</b>

<small>Du kan <a href="$3">stoppe abonnementet</a> på endringer fra denne listen.</small>',
	'automaticwikiadoption-mail-adoption-subject' => 'Wikien din har blitt adoptert',
	'automaticwikiadoption-mail-adoption-content' => 'Hei $1,

Wikien din har blitt adoptert! Dette betyr at noen andre har meldt seg frivillig til å hjelpe til med å opprettholde fellesskapet og innholdet på siden. Ikke bekymre deg - du er fremdeles en administrator, og du er velkommen til å komme tilbake når som helst.

Wikia-teamet

Trykk på følgende lenke for å stoppe abonnementet på endringer fra denne listen: $3.',
	'automaticwikiadoption-mail-adoption-content-HTML' => 'Hei $1,<br /><br />
Wikien din har blitt adoptert! Dette betyr at noen andre har meldt seg frivillig til å hjelpe til med å opprettholde fellesskapet og innholdet på siden. Ikke bekymre deg - du er fremdeles en administrator, og du er velkommen til å komme tilbake når som helst.<br /><br />
<b>Wikia-teamet</b><br /><br />
<small>Du kan <a href="$3">stoppe abonnementet</a> på endringer fra denne listen.</small>',
	'tog-adoptionmails' => 'Send meg en e-post når wikiadministrasjonen endres (kun administratorer)',
);

/** Polish (Polski) */
$messages['pl'] = array(
	'automaticwikiadoption' => 'Automatyczna adopcja wiki',
	'automaticwikiadoption-header' => 'Adoptuj tę wiki',
	'automaticwikiadoption-button-adopt' => 'Adoptuj teraz',
	'automaticwikiadoption-know-more-header' => 'Chcesz wiedzieć więcej?',
	'automaticwikiadoption-adoption-successed' => 'Gratulacje! Jesteś teraz administratorem na tej wiki!',
	'automaticwikiadoption-mail-second-content' => 'Witaj $1,

Minęło sporo czasu od momentu, gdy ostatni raz widzieliśmy administratora na Twojej wiki. Obecność aktywnych administratorów jest ważna dla utrzymania porządku. Wkrótce oddamy Twoją wiki do adopcji, aby dać jej kolejną szansę na posiadanie aktywnych administratorów.

Zespół Wikii

Kliknij następujący link, jeśli chcesz zrezygnować z otrzymywania zmian na tej liście: $3.',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'automaticwikiadoption' => 'Adopção automática de wikis',
	'automaticwikiadoption-header' => 'Adoptar esta wiki',
	'automaticwikiadoption-button-adopt' => 'Adoptar agora',
	'automaticwikiadoption-know-more-header' => 'Quer saber mais?',
	'automaticwikiadoption-know-more-description' => 'Para mais informações visite estes links. E claro, contacte-nos se tiver alguma pergunta!',
	'automaticwikiadoption-adoption-successed' => 'Parabéns! Agora é administrador desta wiki!',
	'automaticwikiadoption-adoption-failed' => 'Infelizmente, tentámos torná-lo administrador desta wiki mas não funcionou. [http://community.wikia.com/Special:Contact Contacte-nos] e tentaremos ajudá-lo.',
	'automaticwikiadoption-not-allowed' => 'Desculpe. Não pode adoptar esta wiki agora.',
	'automaticwikiadoption-not-enough-edits' => 'Precisa de ter feito mais de 10 edições para adoptar esta wiki.',
	'automaticwikiadoption-adopted-recently' => 'Já adoptou outra wiki recentemente. Tem de esperar algum tempo até poder adoptar mais uma wiki.',
	'automaticwikiadoption-log-reason' => 'Adopção Automática de Wikis',
	'automaticwikiadoption-notification' => "É possível adoptar a wiki $1! Pode tornar-se o novo proprietário. $2.",
	'automaticwikiadoption-mail-first-subject' => 'Já não o vemos há algum tempo',
	'automaticwikiadoption-mail-first-content-HTML' => 'Olá $1,<br /><br />
Há já duas semanas que um administrador não visita a sua wiki. Lembre-se que a comunidade depende de si para garantir que a wiki está a funcionar normalmente.<br /><br />
Se precisa de ajuda para tomar conta da wiki, pode permitir que outros membros da comunidade também sejam administradores, na página <a href="$2">Privilégios dos utilizadores</a>.<br /><br />
<b>A Equipa da Wikia</b><br /><br />
<small>Pode <a href="$3">cancelar a subscrição</a> de alterações a esta lista.</small>',
	'automaticwikiadoption-mail-second-subject' => 'A sua wiki será proposta para adopção em breve',
	'automaticwikiadoption-mail-second-content' => 'Olá $1,

Há já algum tempo que nenhum administrador visita a sua wiki. É importante, para a comunidade, que existam administradores activos para que a wiki continue a funcionar normalmente - por isso, iremos propor a sua wiki para adopção em breve, de forma a que esta possa voltar a ter administradores activos.

A Equipa da Wikia

Para cancelar a subscrição de alterações a esta lista, clique o seguinte link: $3',
	'automaticwikiadoption-mail-second-content-HTML' => 'Olá $1,

Há já algum tempo que nenhum administrador visita a sua wiki. É importante, para a comunidade, que existam administradores activos para que a wiki continue a funcionar normalmente - por isso, iremos propor a sua wiki para adopção em breve, de forma a que esta possa voltar a ter administradores activos.

<b>A Equipa da Wikia</b>

<small>Pode <a href="$3">cancelar a subscrição</a> de alterações a esta lista.</small>',
	'automaticwikiadoption-mail-adoption-subject' => 'A sua wiki foi adoptada',
	'automaticwikiadoption-mail-adoption-content' => 'Olá $1,

A sua wiki foi adoptada! Isto significa que alguém se voluntariou para manter a comunidade e o conteúdo do site. Não se preocupe - continua a ser administrador e pode voltar à wiki em qualquer altura.

A Equipa da Wikia

Para cancelar a subscrição de alterações a esta lista, clique o seguinte link: $3',
	'automaticwikiadoption-mail-adoption-content-HTML' => 'Olá $1,<br /><br />
A sua wiki foi adoptada! Isto significa que alguém se voluntariou para manter a comunidade e o conteúdo do site. Não se preocupe - continua a ser administrador e pode voltar à wiki em qualquer altura.<br /><br />
<b>A Equipa da Wikia</b><br /><br />
<small>Pode <a href="$3">cancelar a subscrição</a> de alterações a esta lista.</small>',
	'tog-adoptionmails' => 'Notificar-me por correio electrónico se a $1 ficar disponível para adopção por outros utilizadores',
	'automaticwikiadoption-pref-label' => 'Alterar estas preferências só afectará correios electrónicos da $1.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Aristóbulo
 */
$messages['pt-br'] = array(
	'automaticwikiadoption' => 'Adoção automática de wikis',
	'automaticwikiadoption-header' => 'Adotar esta wiki',
	'automaticwikiadoption-button-adopt' => 'Adotar agora',
	'automaticwikiadoption-know-more-header' => 'Quer saber mais?',
	'automaticwikiadoption-know-more-description' => 'Para mais informações visite estes links. E claro, contate-nos se tiver alguma pergunta!',
	'automaticwikiadoption-adoption-successed' => 'Parabéns! Agora você é administrador desta wiki!',
	'automaticwikiadoption-adoption-failed' => 'Infelizmente, tentámos torná-lo administrador desta wiki mas não funcionou. [http://community.wikia.com/Special:Contact Contacte-nos] e tentaremos ajudá-lo.',
	'automaticwikiadoption-not-allowed' => 'Desculpe. Não pode adotar esta wiki agora.',
	'automaticwikiadoption-log-reason' => 'Adoção Automática de Wikis',
	'automaticwikiadoption-notification' => "É possível adoptar a wiki $1! Pode tornar-se o novo proprietário. $2.",
	'automaticwikiadoption-mail-first-subject' => 'Já não o vemos há algum tempo',
	'automaticwikiadoption-mail-first-content-HTML' => 'Olá $1,<br /><br />
Há já duas semanas que um administrador não visita a sua wiki. Lembre-se que a comunidade depende de si para garantir que a wiki está a funcionar normalmente.<br /><br />
Se precisa de ajuda para tomar conta da wiki, pode permitir que outros membros da comunidade também sejam administradores, na página <a href="$2">Privilégios dos utilizadores</a>.<br /><br />
<b>A Equipa da Wikia</b><br /><br />
<small>Pode <a href="$3">cancelar a subscrição</a> de alterações a esta lista.</small>',
	'automaticwikiadoption-mail-second-subject' => 'A sua wiki será proposta para adoção em breve',
	'automaticwikiadoption-mail-second-content' => 'Olá $1,

Há já algum tempo que nenhum administrador visita a sua wiki. É importante, para a comunidade, que existam administradores activos para que a wiki continue a funcionar normalmente - por isso, iremos propor a sua wiki para adopção em breve, de forma a que esta possa voltar a ter administradores activos.

A Equipa da Wikia

Para cancelar a subscrição de alterações a esta lista, clique o seguinte link: $3',
	'automaticwikiadoption-mail-second-content-HTML' => 'Olá $1,

Há já algum tempo que nenhum administrador visita a sua wiki. É importante, para a comunidade, que existam administradores activos para que a wiki continue a funcionar normalmente - por isso, iremos propor a sua wiki para adopção em breve, de forma a que esta possa voltar a ter administradores activos.

<b>A Equipa da Wikia</b>

<small>Pode <a href="$3">cancelar a subscrição</a> de alterações a esta lista.</small>',
	'automaticwikiadoption-mail-adoption-subject' => 'A sua wiki foi adotada',
	'automaticwikiadoption-mail-adoption-content' => 'Olá $1,

A sua wiki foi adoptada! Isto significa que alguém se voluntariou para manter a comunidade e o conteúdo do site. Não se preocupe - continua a ser administrador e pode voltar à wiki em qualquer altura.

A Equipa da Wikia

Para cancelar a subscrição de alterações a esta lista, clique o seguinte link: $3',
	'automaticwikiadoption-mail-adoption-content-HTML' => 'Olá $1,<br /><br />
A sua wiki foi adotada! Isto significa que alguém se voluntariou para manter a comunidade e o conteúdo do site. Não se preocupe - continua a ser administrador e pode voltar à wiki em qualquer altura.<br /><br />
<b>A Equipa da Wikia</b><br /><br />
<small>Pode <a href="$3">cancelar a subscrição</a> de alterações a esta lista.</small>',
	'tog-adoptionmails' => 'Notificar-me por correio electrónico quando houver alterações na administração (só para administradores)',
);

/** Russian (Русский) */
$messages['ru'] = array(
	'automaticwikiadoption-mail-adoption-content' => 'Привет, $1.

Вашу вки приютили! Это означает, что кто-то ещё добровольно вызвался поддерживать сообщество и содержание на сайте. Не беспокойтесь — Вы всё ещё администратор, и можете вернуться в любое время.

Команда Викии

Кликните по ссылке, чтобы отписаться от изменений в этом списке: $3.',
);

/** Serbian Cyrillic ekavian (‪Српски (ћирилица)‬)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'automaticwikiadoption' => 'Самоприсвајање викије',
	'automaticwikiadoption-header' => 'Присвоји ову викију',
	'automaticwikiadoption-button-adopt' => 'Присвоји одмах',
	'automaticwikiadoption-know-more-header' => 'Желите да знате више?',
	'automaticwikiadoption-adoption-successed' => 'Честитамо! Постали сте администратор ове викије!',
);

/** Swedish (Svenska)
 * @author Tobulos1
 */
$messages['sv'] = array(
	'automaticwikiadoption' => 'Automatisk wiki-adoption',
	'automaticwikiadoption-header' => 'Adoptera den här wikin',
	'automaticwikiadoption-button-adopt' => 'Adoptera nu',
	'automaticwikiadoption-know-more-header' => 'Vill du veta mer?',
	'automaticwikiadoption-know-more-description' => 'Kolla dessa länkar för mer information. Och naturligtvis är du välkommen att kontakta oss om du har några frågor!',
	'automaticwikiadoption-adoption-successed' => 'Grattis! Du är nu en administratör på denna wiki!',
	'automaticwikiadoption-adoption-failed' => 'Vi ber om ursäkt. Vi försökte att göra dig till en administratör, men det fungerade inte. Vänligen [http://community.wikia.com/Special:Contact kontakta oss], så ska vi försöka hjälpa dig.',
	'automaticwikiadoption-not-allowed' => 'Vi ber om ursäkt. Du kan inte adoptera denna wiki just nu.',
	'automaticwikiadoption-log-reason' => 'Automatisk Wiki-Adoption',
	'automaticwikiadoption-notification' => "$1 är tillgänglig för adoption! Du kan bli den nya ägaren. $2!",
	'automaticwikiadoption-mail-first-subject' => 'Vi har inte sett dig på ett tag',
	'automaticwikiadoption-mail-first-content-HTML' => 'Hej $1,<br /><br />
Det har varit ett par veckor sen vi såg en administratör på din wiki. Kom ihåg att din commynity kommer att titta till er för att se om wikin fungerar som den ska.<br /><br />
Om du behöver hjälp med att sköta din wiki, kan du tillåta andra medlemmar i din community att bli administratörer genom att gå till <a href="$2">Användarrättigheterna</a>.<br /><br />
<b>The Wikia Team</b><br /><br />
<small>Du kan <a href="$3">avbryta prenumerationen</a> från ändringar av denna lista.</small>',
	'automaticwikiadoption-mail-second-subject' => 'Vi kommer att sätta upp din wiki för adoption snart',
	'automaticwikiadoption-mail-second-content' => 'Hej $1,

Det var ett tag sen vi såg en administratör på din wiki. Det är viktigt att ha aktiva administratörer för din community så att wikin kan fortsätta att fungera smidigt - så vi kommer att sätta upp din wiki för adoption snart för att ge den en chans att få aktiva administratörer igen.

The Wikia Team

Klicka på följande länk för att avbryta din prenumeration på ändringar i denna lista: $3.',
	'automaticwikiadoption-mail-second-content-HTML' => 'Hej $1,

Det var ett tag sen vi såg en administratör på din wiki. Det är viktigt att ha aktiva administratörer för din community så att din wiki kan fortsätta att fungera smidigt - så vi kommer att sätta upp din wiki för adoption snart för att ge den en chans att få aktiva administratörer igen.

<b>The Wikia Team</b>

<small>Du kan <a href="$3">avbryta prenumerationen</a> från ändringar på denna lista.</small>',
	'automaticwikiadoption-mail-adoption-subject' => 'Din wiki har adopterats',
	'automaticwikiadoption-mail-adoption-content' => 'Hej $1,

Din wiki har adopterats! Detta innebär att någon annan har erbjudit sig att bidra till att upprätthålla din community och innehållet på webbplatsen. Oroa dig inte - du är fortfarande en administratör, och du är välkommen att komma tillbaka när som helst.

The Wikia Team

Klicka på följande länk för att avsluta prenumerationen på ändringar i denna lista: $3.',
	'automaticwikiadoption-mail-adoption-content-HTML' => 'Hej $1,<br /><br />
Din wiki har adopterats! Detta innebär att någon annan har erbjudit sig att bidra till att upprätthålla din community och innehållet på webbplatsen. Oroa dig inte - du är fortfarande en administratör, och du är välkommen att komma tillbaka när som helst.<br /><br />
<b>The Wikia Team</b><br /><br />
<small>Du kan <a href="$3">avbryta prenumerationen</a> på ändringar i denna lista.</small>',
	'tog-adoptionmails' => 'Skicka ett e-mail till mig när något ändras om wikins administration (endast administratörer)',
);

/** Telugu (తెలుగు) */
$messages['te'] = array(
	'automaticwikiadoption-know-more-header' => 'మరింత తెలుసుకోవాలనుకుంటున్నారా?',
);

/** Ukrainian (Українська)
 * @author Тест
 */
$messages['uk'] = array(
	'automaticwikiadoption-know-more-header' => 'Хочете знати більше?',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hydra
 */
$messages['zh-hans'] = array(
	'automaticwikiadoption' => '制动维基领养',
	'automaticwikiadoption-header' => '领养这个维基',
	'automaticwikiadoption-button-adopt' => '现在领养',
	'automaticwikiadoption-know-more-header' => '想知道更多吗？',
	'automaticwikiadoption-adoption-successed' => '恭喜！您现在是这个维基的管理员！',
	'automaticwikiadoption-log-reason' => '制动维基领养',
	'automaticwikiadoption-mail-first-subject' => '我们没有看到你在一段时间',
);

