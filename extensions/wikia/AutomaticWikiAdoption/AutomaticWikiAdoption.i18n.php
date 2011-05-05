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
	'wikiadoption' => 'Automatic wiki adoption',
	'wikiadoption-desc' => 'An AutomaticWikiAdoption extension for MediaWiki',
	'wikiadoption-header' => 'Adopt this wiki',
	'wikiadoption-button-adopt' => 'Yes, I want to adopt {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Find out more!',
	'wikiadoption-description' => "$1, ready to adopt {{SITENAME}}?
<br /><br />
There hasn't been an active administrator on {{SITENAME}} for a while, and we're looking for a new leader to help this wiki's content and community grow! As someone who's contributed to {{SITENAME}} we were wondering if you'd like the job.
<br /><br />
By adopting the wiki, you'll be promoted to administrator and bureaucrat to give you the tools you'll need to manage the wiki's community and content. You'll be able to create other administrators to help, delete, rollback, move and protect pages, as well as create user groups and assign users to them.
<br /><br />
Are you ready to take the next steps to help {{SITENAME}}?",
	'wikiadoption-know-more-header' => 'Want to know more?',
	'wikiadoption-know-more-description' => 'Check out these links for more information. And of course, feel free to contact us if you have any questions!',
	'wikiadoption-adoption-successed' => 'Congratulations! You are a now an administrator on this wiki!',
	'wikiadoption-adoption-failed' => "We are sorry. We tried to make you an administrator, but it did not work out. Please [http://community.wikia.com/Special:Contact contact us], and we will try to help you out.",
	'wikiadoption-not-allowed' => "We are sorry. You cannot adopt this wiki right now.",
	'wikiadoption-not-enough-edits' => "Oops! You need to have more than 10 edits to adopt this wiki.",
	'wikiadoption-adopted-recently' => "Oops! You have already adopted another wiki recently. You will need to wait a while before you can adopt a new wiki.",
	'wikiadoption-log-reason' => 'Automatic Wiki Adoption',
	'wikiadoption-notification' => "{{SITENAME}} is up for adoption. Interesting in becoming a leader here? Adopt this wiki to get started!  $2",
	'wikiadoption-mail-first-subject' => "We have not seen you around in a while",
	'wikiadoption-mail-first-content' => "Hi $1,

It's been a couple of weeks since we have seen an administrator on your wiki. Remember, your community will be looking to you to make sure the wiki is running smoothly.

If you need help taking care of the wiki, you can also allow other community members to become administrators by going to $2.

The Wikia Team

Click the following link to unsubscribe from changes to this list: $3.",
	'wikiadoption-mail-first-content-HTML' => "Hi $1,<br /><br />
It's been a couple of weeks since we have seen an administrator on your wiki. Remember, your community will be looking to you to make sure the wiki is running smoothly.<br /><br />
If you need help taking care of the wiki, you can also allow other community members to become administrators by going to <a href=\"$2\">User rights management</a>.<br /><br />
<b>The Wikia Team</b><br /><br />
<small>You can <a href=\"$3\">unsubscribe</a> from changes to this list.</small>",
	'wikiadoption-mail-second-subject' => "We will put your wiki up for adoption soon",
	'wikiadoption-mail-second-content' => "Hi $1,

It's been a while since we have seen an administrator around on your wiki. It is important to have active administrators for the community so the wiki can continue to run smoothly - so we will put your wiki up for adoption soon to give it a chance to have active administrators again.

The Wikia Team

Click the following link to unsubscribe from changes to this list: $3.",
	'wikiadoption-mail-second-content-HTML' => "Hi $1,

It's been a while since we have seen an administrator around on your wiki. It is important to have active administrators for the community so the wiki can continue to run smoothly - so we will put your wiki up for adoption soon to give it a chance to have active administrators again.

<b>The Wikia Team</b>

<small>You can <a href=\"$3\">unsubscribe</a> from changes to this list.</small>",
	'wikiadoption-mail-adoption-subject' => 'Your wiki has been adopted',
	'wikiadoption-mail-adoption-content' => "Hi $1,

Your wiki has been adopted! This means that someone else has volunteered to help maintain the community and content on the site. Do not worry - you are still an administrator, and you are welcome to come back at any time.

The Wikia Team

Click the following link to unsubscribe from changes to this list: $3.",
	'wikiadoption-mail-adoption-content-HTML' => "Hi $1,<br /><br />
Your wiki has been adopted! This means that someone else has volunteered to help maintain the community and content on the site. Do not worry - you are still an administrator, and you are welcome to come back at any time.<br /><br />
<b>The Wikia Team</b><br /><br />
<small>You can <a href=\"$3\">unsubscribe</a> from changes to this list.</small>",
	'tog-adoptionmails' => 'E-mail me if $1 will become available for other users to adopt',
	'wikiadoption-pref-label' => 'Changing these preferences will only affect e-mails from $1.',
	'wikiadoption-welcome-header' => 'Congratulations! You\'ve adopted {{SITENAME}}!',
	'wikiadoption-welcome-body' => "You're now a bureaucrat on this wiki. With your new status you now have access to all the tools that will help you manage {{SITENAME}}.
<br /><br />
The most important thing you can do to help {{SITENAME}} grow is keep editing.
<br /><br />
If there is no active administrator on a wiki it can be put up for adoption so be sure to check in on the wiki frequently.
<br /><br />
Helpful Tools:
<br /><br />
[[Special:ThemeDesigner|ThemeDesigner]]
<br />
[[Special:LayoutBuilder|Page Layout Builder]]
<br />
[[Special:ListUsers|User List]]
<br />
[[Special:UserRights|Manage Rights]]",
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'wikiadoption-know-more-header' => 'Wil u meer weet?',
);

/** Bulgarian (Български) */
$messages['bg'] = array(
	'wikiadoption-adoption-successed' => 'Поздравления! Вече сте администратор на това уики!',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Y-M D
 */
$messages['br'] = array(
	'wikiadoption' => 'Degemer ur wiki ez-emgefre',
	'wikiadoption-header' => 'Degemer ar wiki-mañ',
	'wikiadoption-button-adopt' => 'Degemer bremañ',
	'wikiadoption-know-more-header' => "C'hoant gouzout hiroc'h ?",
	'wikiadoption-know-more-description' => "Sellit ouzh al liammoù-se evit gouzout hiroc'h. Ha deuit hardizh e darempred ganimp m'ho peus goulenn pe c'houlenn !",
	'wikiadoption-adoption-successed' => "Gourc'hemennoù ! Merour oc'h bremañ war ar wiki-mañ !",
	'wikiadoption-adoption-failed' => "Digarezit ac'hanomp. Klasket on eus lakaat ac'hanoc'h da verour, met ne ya ket en-dro. Mar plij [http://community.wikia.com/Special:Contact deuit e darempred ganeomp], hag e klaskimp skoazellañ ac'hanoc'h.",
	'wikiadoption-not-allowed' => "Digarezit ac'hanomp. Ne c'hellit ket degemer ar wiki-mañ bremañ.",
	'wikiadoption-not-enough-edits' => "C'hem ! Rankout a rit kaout muioc'h eget 10 degasadenn evit degemer ar wiki-mañ.",
	'wikiadoption-adopted-recently' => "C'hem ! Degemeret ho peus ur wiki n'eus ket pell. Ret 'vo deoc'h gortoz un tammig a-raok gellout degemer ur wiki nevez.",
	'wikiadoption-log-reason' => 'Degemer ur wiki ez-emgefre',
	'wikiadoption-notification' => "$1 a zo prest da vezañ degemeret ! Gellout a rit bezañ ar perc'henn nevez. '''Degemer bremañ !'''",
	'wikiadoption-mail-first-subject' => "N'hon eus ket gwelet ac'hanoc'h abaoe pell",
	'wikiadoption-mail-second-subject' => 'Lakaat a raimp ho wiki da zegemer a-benn nebeut',
	'wikiadoption-mail-adoption-subject' => 'Degemeret eo bet ho wiki !',
	'tog-adoptionmails' => 'Kasit din ur gemennadenn ma vez dieub $1 da zegemer',
	'wikiadoption-pref-label' => 'Kemmañ an dibarzhioù-mañ en do un efed war posteloù $1 hepken.',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'wikiadoption-header' => 'Usvoji ovu wiki',
	'wikiadoption-button-adopt' => 'Usvoji odmah',
	'wikiadoption-know-more-header' => 'Želite saznati više?',
	'wikiadoption-adoption-successed' => 'Čestitke! Sada ste administator na ovoj wiki!',
);

/** German (Deutsch)
 * @author Claudia Hattitten
 * @author LWChris
 */
$messages['de'] = array(
	'wikiadoption' => 'Automatische Wiki-Adoption',
	'wikiadoption-desc' => 'Eine MediaWiki-Erweiterung für automatische Wiki-Adoption',
	'wikiadoption-header' => 'Dieses Wiki adoptieren',
	'wikiadoption-button-adopt' => 'Jetzt adoptieren',
	'wikiadoption-description' => 'Du hast dich in diesem Wiki eingebracht, doch es gibt hier keinen aktiven Administrator. Möchtest du diesen Job übernehmen?

Als Adminstrator solltest du weiterhin zum Inhalt des Wikis beitragen, aber gleichzeitig auch alle Anderen im Wiki anspornen und ihnen bei Problemen zur Seite stehen.

Im Gegenzug erhältst du das Recht, Benutzer zu sperren und zu entsperren, Seiten vor dem Bearbeiten zu schützen, und noch viele andere Sonderfunktionen. Wir werden dir auch eine Mail schicken, wenn jemand im Wiki Bearbeitungen vornimmt.

Kurz gesagt, du wirst Verwalter des Wikis, und du kannst es nach deinen Vorstellungen anpassen.

Wär das nicht was?',
	'wikiadoption-know-more-header' => 'Möchtest du mehr wissen?',
	'wikiadoption-know-more-description' => 'Sieh dir diese Links für weitere Informationen an. Und natürlich, zögere nicht uns zu kontaktieren, wenn du Fragen hast!',
	'wikiadoption-adoption-successed' => 'Herzlichen Glückwunsch! Du bist jetzt ein Administrator in diesem Wiki!',
	'wikiadoption-adoption-failed' => 'Tut uns leid. Wir haben versucht, dich zu einem Administrator zu machen, aber es hat nicht funktioniert. Bitte [http://community.wikia.com/Special:Contact kontaktiere uns], und wir werden versuchen, dir weiterzuhelfen.',
	'wikiadoption-not-allowed' => 'Tut uns leid. Du kannst dieses Wiki gerade nicht übernehmen.',
	'wikiadoption-not-enough-edits' => 'Auweia! Du musst mehr als 10 Bearbeitungen getätigt haben, um dieses Wiki adoptieren zu können.',
	'wikiadoption-adopted-recently' => 'Auweia! Du hast in letzter Zeit bereits ein anderes Wiki adoptiert. Du musst eine Weile warten, bevor du ein weiteres Wiki adoptieren kannst.',
	'wikiadoption-log-reason' => 'Automatische Wiki-Adoption',
	'wikiadoption-notification' => '$1 kann adoptiert werden! Du kannst der neue Verwalter werden. $2',
	'wikiadoption-mail-first-subject' => 'Wir haben dich eine Weile nicht gesehen',
	'wikiadoption-mail-first-content' => 'Hallo $1,

Es ist ein paar Wochen her, dass wir einen Administrator in deinem Wiki gesehen haben. Bedenke, dass deine Gemeinschaft dort sich darauf verlässt, dass du das Wiki am Laufen hältst.

Falls du Hilfe bei der Pflege des Wikis brauchst, kannst du auch anderen Mitgliedern des Wikis ermöglichen, Administrator zu werden, indem du hierhin gehst: $2.

Das Wikia-Team


Klicke auf den folgenden Link, um Änderungen an dieser Liste abzubestellen: $3.',
	'wikiadoption-mail-first-content-HTML' => 'Hallo $1, <br /><br />
Es ist ein paar Wochen her, dass wir einen Administrator in deinem Wiki gesehen haben. Denk daran, deine Community wird von dir erwarten, dass das Wiki reibungslos läuft.<br /><br />
Wenn du Hilfe bei der Betreuung des Wikis benötigst, kannst du in der <a href="$2">Benutzerrechteverwaltung</a> auch anderen Community-Mitgliedern erlauben, Administrator zu werden.<br /><br />
<b>Das Wikia-Team</b> <br /><br />
<small>Du kannst Änderungen an dieser Liste <a href="$3">abbestellen</a>.</small>',
	'wikiadoption-mail-second-subject' => 'Dein Wiki wird bald zur Adoption freigegeben',
	'wikiadoption-mail-second-content' => 'Hallo $1,

es ist schon eine Weile her, dass wir einen Administrator in deinem Wiki gesehen haben. Es ist wichtig, aktive Administratoren für die Gemeinschaft zu haben, damit das Wiki weiterhin reibungslos funktionieren kann - also wird dein Wiki bald zur Adoption freigegeben, um ihm eine Chance zu geben, wieder aktive Administratoren zu haben.

Das Wikia-Team

Klicke auf den folgenden Link, um Änderungen an dieser Liste abzubestellen: $3.',
	'wikiadoption-mail-second-content-HTML' => 'Hallo $1,

es ist schon eine Weile her, dass wir einen Administrator in deinem Wiki gesehen haben. Es ist wichtig, aktive Administratoren für die Gemeinschaft zu haben, damit das Wiki weiterhin reibungslos funktionieren kann - also wird dein Wiki bald zur Adoption freigegeben, um ihm eine Chance zu geben, wieder aktive Administratoren zu haben.

<b>Das Wikia-Team</b>

<small>Du kannst Änderungen an dieser Liste <a href="$3">abbestellen</a>.</small>',
	'wikiadoption-mail-adoption-subject' => 'Dein Wiki wurde adoptiert',
	'wikiadoption-mail-adoption-content' => 'Hallo $1,

Dein Wiki wurde adoptiert! Das bedeutet, dass ein Anderer freiwillig bei der Pflege der Community und Inhalte auf der Website helfen wird. Mach dir keine Sorgen - du bist immer noch ein Administrator, und du kannst jederzeit wieder dazustoßen.

Das Wikia-Team

Klicke auf den folgenden Link, um Änderungen an dieser Liste abzubestellen: $3.',
	'wikiadoption-mail-adoption-content-HTML' => 'Hallo $1,<br /><br />
Dein Wiki wurde adoptiert! Das bedeutet, dass ein Anderer freiwillig bei der Pflege der Community und Inhalte auf der Website helfen wird. Mach dir keine Sorgen - du bist immer noch ein Administrator, und du kannst jederzeit wieder dazustoßen.<br /><br />
<b>Das Wikia-Team</b><br /><br />
<small>Du kannst Änderungen an dieser Liste <a href="$3">abbestellen</a>.</small>',
	'tog-adoptionmails' => 'Mich per E-Mail benachrichtigen, wenn $1 zur Adoption durch andere Benutzer freigegeben wird',
	'wikiadoption-pref-label' => 'Eine Änderung dieser Einstellungen wirkt sich nur auf E-Mails von $1 aus.',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬) */
$messages['de-formal'] = array(
	'wikiadoption-notification' => "$1 kann adoptiert werden. Sie können der neue Verwalter werden. ''Jetzt adoptieren!''",
);

/** Spanish (Español)
 * @author VegaDark
 */
$messages['es'] = array(
	'wikiadoption' => 'Adopción automática de wikis',
	'wikiadoption-desc' => 'Una extensión sobre Adopción Automática de Wikis para MediaWiki',
	'wikiadoption-header' => 'Adopta esta wiki',
	'wikiadoption-button-adopt' => 'Sí, ¡quiero adoptar {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => '¡Descubre más!',
	'wikiadoption-description' => '$1, ¿preparado para adoptar {{SITENAME}}?
<br /><br />
No han habido administradores activos en {{SITENAME}} por un tiempo, ¡y estamos buscando por un nuevo líder para ayudar al contenido de esta wiki y crecer la comunidad! Como alguien quien contribuyó a {{SITENAME}} pensamos si te gustaría el trabajo.
<br /><br />
Al adoptar esta wiki, serás promovido a administrador y burócrata para darte las herramientas que necesitarás para administrar el contenido y a la comunidad de la wiki. Estarás habilitado para promover a otros administradores para ayudar, borrar, revertir, mover y proteger páginas, como también crear grupos de usuario y asignar usuarios a ellos.
<br /><br />
¿Estás preparado para tomar los siguientes pasos y ayudar a {{SITENAME}}?',
	'wikiadoption-know-more-header' => '¿Quieres saber más?',
	'wikiadoption-know-more-description' => 'Revisa estos enlaces para obtener más información. Y, por supuesto, ¡no dudes en contactarnos si tienes alguna pregunta!',
	'wikiadoption-adoption-successed' => '¡Felicitaciones! ¡Ahora eres un administrador en esta wiki!',
	'wikiadoption-adoption-failed' => 'Lo sentimos. Intentamos hacerte administrador, pero no ha funcionado. Por favor [http://community.wikia.com/Special:Contact contáctanos], y trataremos de ayudarte.',
	'wikiadoption-not-allowed' => 'Lo sentimos. No puedes adoptar esta wiki por ahora.',
	'wikiadoption-not-enough-edits' => '¡Oops! Necesitas tener más de 10 ediciones para adoptar este wiki.',
	'wikiadoption-adopted-recently' => '¡Oops! Ya has adoptado otro wiki recientemente. Necesitas esperar un tiempo antes de que puedas adoptar un nuevo wiki.',
	'wikiadoption-log-reason' => 'Adopción automática de wikis',
	'wikiadoption-notification' => '{{SITENAME}} está en adopción. ¿Estás interesado en ser un líder aquí? ¡Adopta esta wiki para comenzar! $2',
	'wikiadoption-mail-first-subject' => 'No te hemos visto desde hace algún tiempo',
	'wikiadoption-mail-first-content' => 'Hola $1,

Han pasado un par de semanas desde que hemos visto un administrador en tu wiki. Recuerda, tu comunidad estará buscándote para asegurarse que la wiki esté funcionando correctamente.

Si necesitas ayuda para cuidar la wiki, puedes permitir que otros usuarios sean administradores haciendo clic en $2.

El Equipo de Wikia

Haz clic en el siguiente enlace para darte de baja de los cambios a esta lista: $3.',
	'wikiadoption-mail-first-content-HTML' => 'Hola $1,<br /><br />
Han pasado un par de semanas desde que hemos visto a un administrador en tu wiki. Recuerda, tu comunidad te estará buscando para asegurarse que la wiki trabaja sin problemas.<br /><br />
Si necesitas ayuda para cuidar de la wiki, puedes permitir que otros miembros de la comunidad sean administradores, yendo a <a href="$2">Configuración de permisos de usuarios</a>.<br /><br />
<b>El Equipo de Wikia</b><br /><br />
<small>Puedes <a href="$3">cancelar tu suscripción</a> para futuros cambios de esta lista.</small>',
	'wikiadoption-mail-second-subject' => 'Pondremos tu wiki pronta para la adopción',
	'wikiadoption-mail-second-content' => 'Hola $1,

Han pasado un par de semanas desde que hemos visto a un administrador en tu wiki. Es importante tener administradores activos para la comunidad así la wiki puede continuar trabajando sin problemas, así que pondremos tu wiki en adopción y darle un chance para que tenga administradores activos nuevamente.

El Equipo de Wikia

Haz clic en el siguiente enlace para cancelar tu suscripción de esta lista: $3.',
	'wikiadoption-mail-second-content-HTML' => 'Hola $1,

Han pasado un par de semanas desde que hemos visto a un administrador en tu wiki. Es importante tener administradores activos para la comunidad así la wiki puede continuar trabajando sin problemas, así que pondremos tu wiki en adopción y darle un chance para que tenga administradores activos nuevamente.

El Equipo de Wikia

<small>Puedes <a href="$3">cancelar</a> tu suscripción de esta lista.</small>',
	'wikiadoption-mail-adoption-subject' => 'Tu wiki ha sido adoptada',
	'wikiadoption-mail-adoption-content' => 'Hola $1,

¡Tu wiki ha sido adoptada! Esto significa que otro usuario a colaborado para ayudar a mantener a la comunidad y el contenido en el sitio. No te preocupes, aún sigues siendo un administrador, y eres bienvenido a regresar en cualquier momento.

El Equipo de Wikia

Haz clic en el siguiente enlace para cancelar tu suscripción de la lista: $3.',
	'wikiadoption-mail-adoption-content-HTML' => 'Hola $1,<br /><br />
¡Tu wiki ha sido adoptada! Esto significa que otro usuario a colaborado para ayudar a mantener a la comunidad y el contenido en el sitio. No te preocupes, aún sigues siendo un administrador, y eres bienvenido a regresar en cualquier momento.<br /><br />
<b>El Equipo de Wikia</b><br /><br />
<small>Puedes <a href="$3">cancelar</a> tu suscripción de esta lista.</small>',
	'tog-adoptionmails' => 'Notificarme por correo electrónico si $1 está disponible para otros usuarios para adoptar.',
	'wikiadoption-pref-label' => 'Cambiar estas preferencias solo afectarán los correos electrónicos de $1.',
	'wikiadoption-welcome-header' => '¡Felicitaciones! ¡Has adoptado {{SITENAME}}!',
	'wikiadoption-welcome-body' => 'Ahora eres burócrata en esta wikii. Con tu nuevo cargo ahora tienes acceso a todas las herramientas que te ayudarán a administrar {{SITENAME}}.
<br /><br />
Lo más importante que puedes hacer para ayudar a {{SITENAME}} es mantenerte editando.
<br /><br />
Si no hay administradores activos en una wiki, puede ponerse en adopción, así que asegúrate de estar revisando la wiki constantemente.
<br /><br />
Herramientas útiles:
<br /><br />
[[Special:ThemeDesigner|Diseñador de temas]]
<br />
[[Special:LayoutBuilder|Creador de plantillas]]
<br />
[[Special:ListUsers|Lista de Usuarios]]
<br />
[[Special:UserRights|Administrar permisos de usuarios]]',
);

/** Persian (فارسی)
 * @author Wayiran
 */
$messages['fa'] = array(
	'wikiadoption' => 'اتخاذ خودکار ویکی',
	'wikiadoption-header' => 'اتخاذ این ویکی',
	'wikiadoption-button-adopt' => 'هم‌اکنون اتخاذ کن',
	'wikiadoption-know-more-header' => 'چگونه بیش‌تر بدانیم؟',
);

/** Finnish (Suomi)
 * @author Nike
 * @author Tofu II
 */
$messages['fi'] = array(
	'wikiadoption-header' => 'Adoptoi tämä wiki',
	'wikiadoption-button-adopt' => 'Adoptoi nyt',
	'wikiadoption-know-more-header' => 'Haluatko tietää enemmän?',
	'wikiadoption-adoption-successed' => 'Onnittelut! Olet nyt ylläpitäjä tässä wikissä!',
	'wikiadoption-notification' => "$1 on adoptoitavana! Sinusta voi tulla uusi omistaja. '''Adoptoi nyt!'''",
);

/** French (Français)
 * @author Notafish
 * @author Zcqsc06
 */
$messages['fr'] = array(
	'wikiadoption' => 'Adoption de wiki automatique',
	'wikiadoption-desc' => 'Une extension AutomaticWikiAdoption pour MediaWiki',
	'wikiadoption-header' => 'Adopter ce wiki',
	'wikiadoption-button-adopt' => 'Adopter maintenant',
	'wikiadoption-description' => "Vous avez contribué à ce wiki, mais il n'y a pas d'administrateur actif. Voulez l'être?

Être un administrateur signifie que vous aurez besoin de contribuer continuellement, mais aussi d'encourager toute autre personne sur le wiki, et être disponibles pour les aider quand ils en ont besoin.

En échange, nous vous donnerons le pouvoir de bloquer / débloquer des utilisateurs, de verrouiller des pages pour l'édition, et plein d'autres fonctionnalités. Nous vous enverrons un e-mail lorsque quelqu'un d'autre modifie de ce wiki.

En bref, vous aurez la propriété du wiki, et vous pourrez façonner ce site de la façon que vous voulez.

Ça vous intéresse?",
	'wikiadoption-know-more-header' => 'Vous voulez en savoir plus ?',
	'wikiadoption-know-more-description' => "Veuillez consultez ces liens pour plus d'informations. Et, bien entendu, n’hésitez pas à nous contacter si vous avez des questions !",
	'wikiadoption-adoption-successed' => 'Félicitations ! Vous êtes maintenant administrateur sur ce wiki !',
	'wikiadoption-adoption-failed' => 'Nous sommes désolés. Nous avons essayé de vous nommer administrateur, mais cela n’a pas fonctionné. Veuillez [http://community.wikia.com/Special:Contact nous contacter], et nous allons essayer de vous aider.',
	'wikiadoption-not-allowed' => 'Nous sommes désolés. Vous ne pouvez pas adopter ce wiki maintenant.',
	'wikiadoption-not-enough-edits' => 'Oups ! Vous devez avoir plus de 10 contributions pour adopter ce wiki.',
	'wikiadoption-adopted-recently' => 'Oups ! Vous avez adopté un wiki récemment. Vous allez devoir attendre un peu avant de pouvoir adopter un nouveau wiki.',
	'wikiadoption-log-reason' => 'Adoption de wiki automatique',
	'wikiadoption-notification' => '$1 est disponible pour adoption ! Vous pouvez en devenir le nouveau propriétaire. $2!',
	'wikiadoption-mail-first-subject' => 'Nous ne vous avons pas vu depuis un bon moment',
	'wikiadoption-mail-first-content' => "Bounjour $1,

Ca fait quelques semaines que nous n'avons pas vu d'administrateur sur votre wiki. Rappelez-vous que votre communauté se tournera vers vous pour s'assurer du bon fonctionnement du wiki. 

Si vous avez besoin d'aide pour vous occuper du wiki, vous pouvez également autoriser d'autres membres de la communauté à devenir administrateurs en allant sur $2.

L'équipe de Wikia

Cliquez sur le lien suivant pour vous désabonner aux modifications de cette liste: $3.",
	'wikiadoption-mail-first-content-HTML' => 'Bonjour $1,<br /><br />
Cela fait quelques semaines que nous n’avons pas vu d’administrateur sur votre wiki. Rappelez-vous que votre communauté se tournera vers vous pour s’assurer que le wiki fonctionne sans problème.<br /><br />
Si vous avez besoin d’aide pour prendre soin du wiki, vous pouvez aussi permettre aux membres de la communauté de devenir des administrateurs en allant dans le <a href="$2">gestionnaire des droits des utilisateurs</a>.<br /><br />
<b>L’équipe Wikia</b><br /><br />
<small>Vous pouvez <a href="$3">vous désabonner</a> des mises à jour de cette liste.</small>',
	'wikiadoption-mail-second-subject' => 'Nous mettrons votre wiki disponible pour l’adoption dans peu de temps',
	'wikiadoption-mail-second-content' => 'Bonjour $1,

Cela fait un certain temps que nous n’avons pas vu d’administrateur sur votre wiki. Il est important d’avoir des administrateurs actifs dans la communauté pour que le wiki continue de fonctionner sans problème. Nous allons donc rendre votre wiki disponible pour l’adoption dans peu de temps, afin qu’il ait une chance d’avoir à nouveau des administrateurs actifs.

L’équipe Wikia

Cliquez sur le lien suivant pour vous désinscrire des mises à jour de cette liste : $3.',
	'wikiadoption-mail-second-content-HTML' => 'Bonjour $1,

Cela fait un certain temps que nous n’avons pas vu d’administrateur sur votre wiki. Il est important d’avoir des administrateurs actifs dans la communauté pour que le wiki continue de fonctionner sans problème. Nous allons donc rendre votre wiki disponible pour l’adoption dans peu de temps, afin qu’il ait une chance d’avoir à nouveau des administrateurs actifs.

<b>L’équipe Wikia</b>

<small>Cliquez sur le lien suivant pour <a href="$3">vous désabonner</a> des mises à jour de cette liste.</small>',
	'wikiadoption-mail-adoption-subject' => 'Votre wiki a été adopté',
	'wikiadoption-mail-adoption-content' => 'Bonjour $1,

Votre wiki a été adopté ! Cela signifie que quelqu’un d’autre s’est porté volontaire pour maintenir la communauté et le contenu du site. Ne vous inquiétez pas - vous êtes toujours administrateur et vous êtes invité à revenir à tout moment.

L’équipe Wikia

Cliquez sur le lien suivant pour vous désabonner des mises à jour de cette liste : $3.',
	'wikiadoption-mail-adoption-content-HTML' => 'Bonjour $1,<br /><br />
Votre wiki a été adopté ! Cela signifie que quelqu’un d’autre s’est porté volontaire pour maintenir la communauté et le contenu du site. Ne vous inquiétez pas - vous êtes toujours administrateur et vous êtes invité à revenir à tout moment.<br /><br />
<b>L’équipe Wikia</b><br /><br />
<small>Cliquez sur le lien suivant pour <a href="$3">vous désabonner</a> des mises à jour de cette liste.</small>',
	'tog-adoptionmails' => "Envoyez-moi un message si $1 devient disponible pour l'adoption",
	'wikiadoption-pref-label' => 'La modification de ces préférences affectera seulement les courriels de $1.',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'wikiadoption-mail-adoption-subject' => 'Adoptaron o seu wiki',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'wikiadoption' => 'Automatikus wiki örökbefogadás',
	'wikiadoption-header' => 'Wiki örökbefogadása',
	'wikiadoption-button-adopt' => 'Örökbefogadás',
	'wikiadoption-know-more-header' => 'Szeretnél többet tudni?',
	'wikiadoption-not-allowed' => 'Sajnáljuk, jelenleg nem adoptálhatod ezt a wikit.',
	'wikiadoption-mail-first-subject' => 'Már nem láttunk téged erre egy ideje',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'wikiadoption' => 'Adoption automatic de wikis',
	'wikiadoption-desc' => 'Un extension de MediaWiki pro adoption automatic de wikis',
	'wikiadoption-header' => 'Adoptar iste wiki',
	'wikiadoption-button-adopt' => 'Si, io vole adoptar {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Lege plus!',
	'wikiadoption-description' => '$1, es tu preste a adoptar {{SITENAME}}?
<br /><br />
Il non ha habite un administrator active in {{SITENAME}} durante un tempore, e nos cerca un nove dirigente pro adjutar a facer le communitate e contento de iste wiki crescer! Tu ha contribuite multo a {{SITENAME}}. Vole tu prender le posto?
<br /><br />
Adoptar iste wiki significa que tu essera promovite a administrator e bureaucrate. Isto te da accesso al instrumentos necessari pro gerer le communitate e contento del wiki. Tu potera assignar altere administratores pro adjutar, deler, reverter, renominar e proteger paginas, e crear gruppos de usatores e assignar usatores a illos.
<br /><br />
Es tu preste a prender le proxime passos pro adjutar {{SITENAME}}?',
	'wikiadoption-know-more-header' => 'Vole saper plus?',
	'wikiadoption-know-more-description' => 'Explora iste ligamines pro plus informationes. E, naturalmente, sia libere de contactar nos si tu ha questiones!',
	'wikiadoption-adoption-successed' => 'Felicitationes! Tu es ora administrator de iste wiki!',
	'wikiadoption-adoption-failed' => 'Nos lo regretta: nos ha tentate facer te administrator, ma le procedura non ha succedite. Per favor [http://community.wikia.com/Special:Contact contacta nos], e nos tentara adjutar te.',
	'wikiadoption-not-allowed' => 'Nos regretta que tu non pote adoptar iste wiki justo ora.',
	'wikiadoption-not-enough-edits' => 'Ups! Tu debe haber facite plus de 10 modificationes pro poter adoptar iste wiki.',
	'wikiadoption-adopted-recently' => 'Ups! Tu ha jam adoptate un wiki recentemente. Tu debe attender un certe tempore ante que tu pote adoptar un altere wiki.',
	'wikiadoption-log-reason' => 'Adoption automatic de wikis',
	'wikiadoption-notification' => '{{SITENAME}} es disponibile pro adoption. Ha tu interesse in devenir un dirigente hic? Adopta iste wiki pro comenciar! $2',
	'wikiadoption-mail-first-subject' => 'Nos non te ha vidite durante un tempore',
	'wikiadoption-mail-first-content' => 'Salute $1,

Ha passate plure septimanas desde que nos videva un administrator active in tu wiki. Non oblida que le communitate depende de te pro assecurar le bon functionamento del wiki.

Si tu require adjuta a facer attention al wiki, tu pote permitter altere membros del communitate a devenir administrator per visitar $2.

Le equipa de Wikia

Clicca super le ligamine sequente pro non plus reciper cambios a iste lista: $3.',
	'wikiadoption-mail-first-content-HTML' => 'Salute $1,<br /><br />
Plure septimanas ha passate depost que nos ha vidite un administrator in tu wiki. Rememora que tu communitate depende de te pro assecurar le bon functionamento del wiki.<br /><br />
Si tu ha besonio de adjuta pro le gerentia del wiki, tu pote permitter a altere membros de devenir administrator via le pagina pro <a href="$2">gestion de derectos de usator</a>.<br /><br />
<b>Le equipa de Wikia</b><br /><br />
<small>Tu pote <a href="$3">cancellar le subscription</a> al cambios a iste lista.</small>',
	'wikiadoption-mail-second-subject' => 'Nos rendera tu wiki disponibile pro adoption tosto',
	'wikiadoption-mail-second-content' => 'Salute $1,

Un certe tempore ha passate depost que nos ha vidite un administrator connectite in tu wiki. Es importante haber administratores active pro le communitate pro assecurar le bon functionamento del wiki; dunque, nos offerera tosto le wiki pro adoption, de sorta que illo pote haber de novo administratores active.

Le equipa de Wikia

Clicca le sequente ligamine pro cancellar le subscription al cambios in iste lista: $3.',
	'wikiadoption-mail-second-content-HTML' => 'Salute $1,

Un certe tempore ha passate depost que nos ha vidite un administrator active in tu wiki. Es importante haber administratores active in le communitate pro assecurar le bon functionamento del wiki, dunque nos offerera tosto tu wiki pro adoption a fin que illo pote haber de novo administratores active.

<b>Le equipa de Wikia</b>

<small>Tu pote <a href="$3">cancellar le subscription</a> a cambiamentos in iste lista.</small>',
	'wikiadoption-mail-adoption-subject' => 'Tu wiki ha essite adoptate',
	'wikiadoption-mail-adoption-content' => 'Salute $1,

Tu wiki ha essite adoptate! Isto vole dicer que alcuno altere se ha offerite como voluntario pro adjutar a mantener le communitate e contento in le sito. Non te inquieta; tu es ancora administrator, e tu es benvenite a retornar quandocunque tu vole.

Le equipa de Wikia

Clicca le sequente ligamine pro cancellar le subscription a cambiamentos in iste wiki: $3.',
	'wikiadoption-mail-adoption-content-HTML' => 'Salute $1,

Tu wiki ha essite adoptate! Isto significa que un altere persona se ha offerite pro adjutar a mantener le communitate e contento del sito. Non te inquieta: tu continua a esser administrator, e tu es benvenite a retornar a omne momento.

<b>Le equipa de Wikia</b>

<small>Tu pote <nowiki><a href="{{fullurl:{{ns:special}}:Preferences}}">cancellar le subscription</a></nowiki> al modificationes de iste lista.</small>',
	'tog-adoptionmails' => 'Inviar me e-mail si $1 devenira disponibile pro adoption per altere usatores',
	'wikiadoption-pref-label' => 'Modificar iste preferentias influentiara solmente le messages de e-mail ab $1.',
	'wikiadoption-welcome-header' => 'Felicitationes! Tu ha adoptate {{SITENAME}}!',
	'wikiadoption-welcome-body' => 'Tu es ora bureaucrate in iste wiki. Con tu nove stato, tu ha recipite accesso a tote le instrumentos que te adjutara a gerer {{SITENAME}}.
<br /><br />
Le cosa le plus importante que tu pote facer pro adjutar a facer {{SITENAME}} crescer es continuar a contribuer contento.
<br /><br />
Si il non ha un administrator active in un wiki illo pote esser rendite disponibile pro adoption, dunque assecura te de revider le wiki frequentemente.
<br /><br />
Instrumentos utile:
<br /><br />
[[Special:ThemeDesigner|Designator de apparentias]]
<br />
[[Special:LayoutBuilder|Constructor de dispositiones de pagina]]
<br />
[[Special:ListUsers|Lista de usatores]]
<br />
[[Special:UserRights|Gestion de derectos]]',
);

/** Italian (Italiano)
 * @author Minerva Titani
 */
$messages['it'] = array(
	'wikiadoption-header' => 'Adotta questa wiki',
	'wikiadoption-mail-adoption-subject' => 'La tua wiki è stata adottata',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'wikiadoption-know-more-header' => 'Wann Dir méi wësse wëllt.',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'wikiadoption' => 'АвтоматскоПосвојувањеНаВики',
	'wikiadoption-desc' => 'Додаток за автоматско посвојување на вики за МедијаВики',
	'wikiadoption-header' => 'Посвој го викиво',
	'wikiadoption-button-adopt' => 'Посвој веднаш',
	'wikiadoption-description' => 'Вие сте учесник на викито со вашите придонеси, но нема активен администратор. Дали би сакале да ја преземете оваа функција?

Кога сте администратор ќе треба да продолжите да учествувате со содржини, но и директно да ги поттикнувате другите на викито, и да бидете на располагање да помогнете кога ќе бидете потребни.

За возврат ќе имате овластување да блокирате / одблокирате корисници, да заклучувате страници (да не можат да се уредуваат), и еден куп други можности. Ќе добивате и известувања по е-пошта кога некој ќе го уреди викито.

Кратко речено, ќе бидете сопственик, и можете да го направите викито какво што вие сакате.

Звучи забавно?',
	'wikiadoption-know-more-header' => 'Сакате да дознаете повеќе?',
	'wikiadoption-know-more-description' => 'За повеќе информации, погледајте ги овие врски. И секако, најслободно обратете ни се ако имате прашања!',
	'wikiadoption-adoption-successed' => 'Честитаме! Сега сте администратор на ова вики!',
	'wikiadoption-adoption-failed' => 'Нажалост, се обидовме да ве назначиме за администратор, но не успеавме. [http://community.wikia.com/Special:Contact Контактирајте нè], и ќе се обидеме да ви помогнеме.',
	'wikiadoption-not-allowed' => 'Нажалост, во моментов не можете да го посвоите ова вики.',
	'wikiadoption-not-enough-edits' => 'Упс! Мора да имате барем 10 уредувања за да можете да го присвоите викито.',
	'wikiadoption-adopted-recently' => 'Упс! Неодамна имате посвоено друго вики. Ќе треба да почекате пред да можете да посвоите уште едно.',
	'wikiadoption-log-reason' => 'Автоматско посвојување на вики',
	'wikiadoption-notification' => '$1 може да се посвои! Имате можност да бидете новиот сопственик. $2!',
	'wikiadoption-mail-first-subject' => 'Не ве имаме видено во последно време',
	'wikiadoption-mail-first-content' => 'Здраво $1,

Има две недели како вашето вики нема администратор. Имајте на ум, вашата заедница очекува од вас да се грижите за викито и да ја обезбедите неговата непречена функционалност.

Ако ви треба помош со раководењето со викито, ви предлагаме да назначите администратор(и) од другите учесници. Ова можете да го направите преку страницата $2.

Екипата на Викија

Ако сакате повеќе да не добивате известувања за измените на овој поштенски список, стиснете на следнава врска: $3.',
	'wikiadoption-mail-first-content-HTML' => 'Здраво $1,<br /><br />
Има пар недели како немаме видено администратор на вашето вики. Запомнете дека вашата заедница очекува од вас да се грижите викито да работи правилно.<br /><br />
Ако ви треба помош со одржувањето на викито, можете да назначите и други членови на заедницата за администратори на страницата<a href="$2">Раководење со кориснички права</a>.<br /><br />
<b>Екипата на Викија</b><br /><br />
<small>Можете да се <a href="$3">отпишете</a> за повеќе да не добивате известувања за измените на овој список.</small>',
	'wikiadoption-mail-second-subject' => 'Наскоро ќе го понудиме вашето вики за посвојување',
	'wikiadoption-mail-second-content' => 'Hi $1,
Помина извесно време како не сме виделе администратор на вашето вики. Од голема важност е да имате активни администратори на викито за да може да работи правилно - затоа ќе ви го дадеме викито на посвојување, давајќи му шанса повторно да има активни администратори.

Екипата на Викија

Ако сакате да не добивање известувања за измените на списоков, проследете ја врската: $3.',
	'wikiadoption-mail-second-content-HTML' => 'Здраво $1,

Помина извесно време како не сме виделе администратор на вашето вики. Од голема важност е да имате активни администратори на викито за да може да работи правилно - затоа ќе ви го дадеме викито на посвојување, давајќи му шанса повторно да има активни администратори.

<b>Екипата на Викија</b>

<small>Можете да се <a href="$3">отпишете</a> за повеќе да не добивате известувања за измените на овој список.</small>',
	'wikiadoption-mail-adoption-subject' => 'Вашето вики е посвоено',
	'wikiadoption-mail-adoption-content' => 'Здраво $1,

Вашето вики е посвоено! Ова значи дека некој се пријавил да ја одржува заедницата и содржините на мрежното место. Не грижете се - вие останувате администратор, и добредојдени сте да се вратите во секое време.

Екипата на Викија

Ако сакате да не добивање известувања за измените на списоков, проследете ја врската: $3.',
	'wikiadoption-mail-adoption-content-HTML' => 'Здраво $1,<br /><br />
Вашето вики е посвоено! Ова значи дека некој се пријавил да ја одржува заедницата и содржините на мрежното место. Не грижете се - вие останувате администратор, и добредојдени сте да се вратите во секое време..<br /><br />
<b>Екипата на Викија</b><br /><br />
<small>Можете да се <a href="$3">отпишете</a> за повеќе да не добивате известувања за измените на овој список.</small>',
	'tog-adoptionmails' => 'Извести ме по е-пошта ако $1 стане достапно за посвојување',
	'wikiadoption-pref-label' => 'Измените во овие нагодувања ќе важат само за -пошта од $1.',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'wikiadoption-header' => 'ഈ വിക്കിയെ ദത്തെടുക്കുക',
	'wikiadoption-button-adopt' => 'ഇപ്പോൾ തന്നെ ദത്തെടുക്കുക',
	'wikiadoption-know-more-header' => 'കൂടുതൽ അറിയണമെന്നുണ്ടോ?',
	'wikiadoption-adoption-successed' => 'അഭിനന്ദനങ്ങൾ! താങ്കൾ ഇപ്പോൾ ഈ വിക്കിയിലെ ഒരു കാര്യനിർവാഹകനാണ്!',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'wikiadoption' => 'Pengambilalihan wiki automatik',
	'wikiadoption-desc' => 'Sambungan Pengambilalihan Wiki automatik untuk MediaWiki',
	'wikiadoption-header' => 'Ambil alih wiki ini',
	'wikiadoption-button-adopt' => 'Ambil alih sekarang',
	'wikiadoption-description' => 'Anda telah menyumbang kepada wiki ini, tetapi sekarang tiada pentadbir yang aktif. Adakah anda ingin menerima kerja ini?

Menjadi seorang pentadbir bermaksud anda perlu terus menyumbangkan kandungan, bahkan juga menggalakkan sesiapa sahaja di wiki ini secara langsung, serta sentiasa ada untuk membantu anda sesekali mereka memerlukan bantuan anda.

Sebagai balasan, kami akan memberi anda kuasa untuk menyekat / menarik balik sekatan daripada pengguna, mengunci laman daripada disunting, dan bermacam-macam lagi ciri-ciri. Kami juga akan menghantar e-mel kepada anda apabila ada orang lain yang menyunting wiki ini.

Pendek kata, anda akan menjadi pemilik dan boleh membentuk tapak ini sesuka hati anda.

Seronok, kan?',
	'wikiadoption-know-more-header' => 'Nak tahu lebih lanjut?',
	'wikiadoption-know-more-description' => 'Apa kata ikut pautan-pautan ini untuk maklumat lanjut. Seperkara lagi, jangan segan menghubungi kami jika ada apa-apa soalan untuk ditanya!',
	'wikiadoption-adoption-successed' => 'Syabas! Anda menjadi pentadbir di wiki ini!',
	'wikiadoption-adoption-failed' => 'Maaf. Kami cuba jadikan anda pentadbir, tetapi tidak menjadi pula. Sila [http://community.wikia.com/Special:Contact hubungi kami], supaya kami boleh membantu anda.',
	'wikiadoption-not-allowed' => 'Maafkan kami, anda tidak boleh mengambil alih wiki ini sekarang.',
	'wikiadoption-not-enough-edits' => 'Maaf, anda perlu membuat lebih 10 suntingan untuk mengambil alih wiki ini.',
	'wikiadoption-adopted-recently' => 'Maaf, anda baru mengambil alih wiki yang lain baru-baru ini. Anda perlu menunggu seketika sebelum anda boleh mengambil alih wiki baru.',
	'wikiadoption-log-reason' => 'Penerimaan Hakmilik Wiki Automatik',
	'wikiadoption-notification' => '$1 perlu diambil alih! Mungkin anda pemilik baru yang dicari-cari. $2!',
	'wikiadoption-mail-first-subject' => 'Sudah sekian lama kami tak berjumpa dengan anda',
	'wikiadoption-mail-first-content' => '$1,

Sudah dua minggu lebih sejak kali terakhir kami melihat ada pentadbir di wiki anda. Ingat, komuniti anda sedang mengharapkan anda untuk memastikan wiki ini berjalan dengan lancar.

Jika anda memerlukan bantuan untuk menjaga wiki ini, anda juga boleh membenarkan ahli-ahli komuniti yang lain menjadi pentadbir dengan pergi ke $2.

Pasukan Wikia

Klik pautan berikut untuk berhenti melanggan perubahan pada senarai ini: $3.',
	'wikiadoption-mail-first-content-HTML' => 'Apa khabar $1,<br /><br />
Sudah dua minggu sejak kami melihat seorang pentadbir yang bertugas di wiki anda. Ingat, komuniti anda akan bergantung pada anda untuk memastikan wiki ini berjalan dengan lancar.<br /><br />
Jika anda memerlukan bantuan untuk menjaga wiki, anda juga boleh membenarkan ahli komuniti lain untuk menjadi pentadbir dengan menggunakan <a href="$2">Pengurusan hak pengguna</a>.<br /><br />
<b>Pasukan Wikia</b><br /><br />
<small>Anda boleh <a href="$3">berhenti melanggan</a> perubahan pada senarai ini.</small>',
	'wikiadoption-mail-second-subject' => 'Kami akan mencari seseorang untuk mengambil alih wiki anda nanti.',
	'wikiadoption-mail-second-content' => 'Apa khabar $1,

Sudah sekian lama sejak kali terakhir wujudnya seorang pentadbir yang aktif di wiki anda. Kehadiran pentadbir yang aktif adalah penting kepada komuniti supaya wiki boleh terus berjalan dengan lancar, jadi kami akan mencari pihak lain untuk mengambil alih wiki anda tidak lama lagi supaya ia boleh diselenggara oleh pentadbir yang aktif semula.

Pasukan Wikia

Klik pautan berikut untuk berhenti melanggan perubahan pada senarai ini: $3.',
	'wikiadoption-mail-second-content-HTML' => 'Apa khabar $1,

Sudah sekian lama sejak kali terakhir wujudnya seorang pentadbir yang aktif di wiki anda. Kehadiran pentadbir yang aktif adalah penting kepada komuniti supaya wiki boleh terus berjalan dengan lancar, jadi kami akan mencari pihak lain untuk mengambil alih wiki anda tidak lama lagi supaya ia boleh diselenggara oleh pentadbir yang aktif semula.

<b>Pasukan Wikia</b>

<small>Anda boleh <a href="$3">berhenti melanggan</a> perubahan pada senarai ini.</small>',
	'wikiadoption-mail-adoption-subject' => 'Wiki anda telah diambil alih',
	'wikiadoption-mail-adoption-content' => 'Apa khabar $1,

Dengan sukacitanya kami maklumkan bahawa wiki anda telah diambil alih, iaitu ada pihak yang menawarkan diri untuk membantu menyelenggara komuniti dan kandungan di tapak itu. Jangan bimbang kerana anda masih seorang pentadbir, dan anda boleh kembali ke situ pada bila-bila masa sahaja.

Pasukan Wikia

Sila klik pautan berikut untuk berhenti melanggan perubahan pada senarai ini: $3.',
	'wikiadoption-mail-adoption-content-HTML' => 'Apa khabar $1,<br /><br />
Dengan sukacitanya kami maklumkan bahawa wiki anda telah diambil alih, iaitu ada pihak yang menawarkan diri untuk membantu menyelenggara komuniti dan kandungan di tapak itu. Jangan bimbang kerana anda masih seorang pentadbir, dan anda boleh kembali ke situ pada bila-bila masa sahaja.<br /><br />
<b>Pasukan Wikia</b><br /><br />
<small>Anda boleh <a href="$3">berhenti melanggan</a> perubahan pada senarai ini.</small>',
	'tog-adoptionmails' => 'E-mel kepada saya jika $1 akan dibuka kepada pengguna lain untuk mengambil alih',
	'wikiadoption-pref-label' => 'Penukaran keutamaan ini akan hanya mempengaruhi e-mel dari $1.',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'wikiadoption' => 'Automatische wikiadoptie',
	'wikiadoption-desc' => 'Een uitbreiding voor automatisch toewijzen van nieuwe beheerders voor een wiki (adoptie)',
	'wikiadoption-header' => 'Deze wiki adopteren',
	'wikiadoption-button-adopt' => 'Ja, ik wil {{SITENAME}} adopteren!',
	'wikiadoption-adopt-inquiry' => 'Meer te weten komen',
	'wikiadoption-description' => "Bent u klaar om {{SITENAME}} te adopteren, $1?<br /><br />
Er is al een tijdje geen actieve beheerder geweest voor {{SITENAME}} en we zoeken een nieuwe leider die ervoor zorgt dat de inhoud en de gemeenschap voor deze wiki blijft groeien! U hebt bijgedragen aan {{SITENAME}}, en we vragen ons af of u dat wilt doen.<br /><br />
Door de wiki te adapteren wordt u beheerder en bureaucraat zodat u de hulpmiddelen hebt om de inhoud en de gemeenschap van de wiki te beheren. U kunt andere gebruikers beheerder maken en helpen met het verwijderen, hernoemen en beveiligen van pagina's en bewerkingen terugdraaien. Daarnaast kunt u gebruikersgroepen aanmaken en daar gebruikers aan toevoegen.<br /><br />
Bent u klaar om de volgende stap te zetten in uw carrière bij {{SITENAME}}?",
	'wikiadoption-know-more-header' => 'Meer te weten komen?',
	'wikiadoption-know-more-description' => 'Volg deze verwijzingen voor meer infomatie. Het staat u natuurlijk ook vrij om contact met ons op te nemen als u vragen hebt.',
	'wikiadoption-adoption-successed' => 'Gefeliciteerd! U bent nu beheerder van deze wiki.',
	'wikiadoption-adoption-failed' => 'We hebben geprobeerd u beheerder te maken, maar dit lukte helaas niet. [http://community.wikia.com/Special:Contact Neem contact met ons op] zodat we u verder kunnen helpen.',
	'wikiadoption-not-allowed' => 'U kunt deze wiki nu helaas niet adopteren.',
	'wikiadoption-not-enough-edits' => 'U moet meer dan 10 bewerkingen gemaakt hebben om deze wiki te kunnen adopteren.',
	'wikiadoption-adopted-recently' => 'U hebt recentelijk al een wiki geadapteerd. U moet even wachten voordat u nog een wiki kunt adopteren.',
	'wikiadoption-log-reason' => 'Automatische wikiadoptie',
	'wikiadoption-notification' => '{{SITENAME}} kan geadopteerd worden. Wilt u de nieuwe leider worden? Adopteer deze wiki om er nu aan te beginnen! $2',
	'wikiadoption-mail-first-subject' => 'We hebben u al een tijdje niet gezien',
	'wikiadoption-mail-first-content' => 'Hallo $1,

Het is al weer een aantal weken geleden dat we een beheerder in uw wiki hebben gezien. Bedenk u dat uw gemeenschap naar u kijkt als het gaat om een soepel draaiende wiki.

Als u hulp nodig hebt bij het zorgen voor uw wiki, dan kunt u ook andere gemeenschapsleden beheerder maken door te gaan naar $2.

Het Wikia-team

Klik op de volgende verwijzing om u uit te schrijven van wijzigingen op deze lijst: $3.',
	'wikiadoption-mail-first-content-HTML' => 'Hallo $1,<br /><br />
Het is al weer een aantal weken geleden dat er een beheerder actief is geweest op uw wiki. Denk er alstublieft aan dat uw gemeenschap naar u kijkt als het gaat om het soepel laten draaien van de wiki.<br /><br />
Als u hulp nodig hebt bij het zorgen voor de wiki, dan kunt u ook andere gemeenschapsleden beheerder maken via <a href="$2">Gebruikersrechtenbeheer</a>.<br /><br />
<b>Het Wikia-team</b><br /><br />
<small>U kunt zich van wijzigingen op deze lijst <a href="$3">uitschrijven</a>.</small>',
	'wikiadoption-mail-second-subject' => 'Uw wiki wordt binnenkort voor adoptie opgegeven',
	'wikiadoption-mail-second-content' => 'Hallo $1,

Het is al weer even geleden dat we een beheerder hebben zien langskomen bij uw wiki. Het is voor de gemeenschap belangrijk dat er actieve beheerders zijn om ervoor te zorgen dat de wiki lekker blijft draaien. Daarom wordt uw wiki binnenkort beschikbaar gemaakt voor adoptie zodat er weer een kans op actieve beheerders gaat bestaan.

Het Wikia-team

U kunt zich van wijzigingen op deze lijst uitschrijven: $3.',
	'wikiadoption-mail-second-content-HTML' => 'Hallo $1,<br /><br />
Het is al weer even geleden dat we een beheerder hebben zien langskomen bij uw wiki. Het is voor de gemeenschap belangrijk dat er actieve beheerders zijn om ervoor te zorgen dat de wiki lekker blijft draaien. Daarom wordt uw wiki binnenkort beschikbaar gemaakt voor adoptie zodat er weer een kans op actieve beheerders gaat bestaan.<br /><br />
<b>Het Wikia-team</b><br /><br />
<small>U kunt zich van wijzigingen op deze lijst <a href="$3">uitschrijven</a>.</small>',
	'wikiadoption-mail-adoption-subject' => 'Uw wiki is geadopteerd',
	'wikiadoption-mail-adoption-content' => 'Hallo $1,

Uw wiki is geadopteerd! Dit betekent dat iemand anders zich heeft opgeworpen om te helpen bij het onderhouden van de gemeenschap en de inhoud van de site. Vrees niet. U bent nog steeds beheerder en u bent nog steeds op ieder moment van harte welkom.

Het Wikia-team

U kunt zich van wijzigingen op deze lijst uitschrijven: $3.',
	'wikiadoption-mail-adoption-content-HTML' => 'Hallo $1,<br /><br />
Uw wiki is geadopteerd! Dit betekent dat iemand anders zich heeft opgeworpen om te helpen bij het onderhouden van de gemeenschap en de inhoud van de site. Vrees niet. U bent nog steeds beheerder en u bent nog steeds op ieder moment van harte welkom.<br /><br />
<b>Het Wikia-team</b><br /><br />
<small>U kunt zich van wijzigingen op deze lijst <a href="$3">uitschrijven</a>.</small>',
	'tog-adoptionmails' => 'Mij e-mailen als $1 door andere gebruikers geadopteerd kan worden',
	'wikiadoption-pref-label' => 'Het wijzigen van deze voorkeuren heeft alleen invloed op e-mails van $1.',
	'wikiadoption-welcome-header' => 'Gefeliciteerd! U hebt {{SITENAME}} geadopteerd!',
	'wikiadoption-welcome-body' => 'U bent nu bureaucraat op deze wiki. Met uw nieuwe status hebt u nu de beschikking over alle hulpmiddelen die u nodig hebt om {{SITENAME}} te beheren.<br /><br />
Het belangrijkste wat u kunt doen om {{SITENAME}} te helpen is blijven bewerken.<br /><br />
Als er geen actieve beheerder is in een wiki, dan kan deze beschikbaar gesteld worden voor adoptie. Zorg er dus voor dat u de wiki regelmatig bezoekt.<br /><br />
Handige hulpmiddelen:<br /><br />
[[Special:ThemeDesigner|Vormgeving ontwerpen]]<br />
[[Special:LayoutBuilder|Paginavormgevingen maken]]<br />
[[Special:ListUsers|Gebruikerslijst]]<br />
[[Special:UserRights|Rechten beheren]]',
);

/** ‪Nederlands (informeel)‬ (‪Nederlands (informeel)‬)
 * @author Siebrand
 */
$messages['nl-informal'] = array(
	'wikiadoption-description' => "Je hebt bijgedragen aan deze wiki, maar er zijn op het moment geen actieve beheerders. Wil jij die taak op je nemen?

Beheerder zijn betekent dat je inhoud blijft bijdragen, maar ook anderen aanmoedigt en beschikbaar bent om anderen te helpen als ze hulp nodig hebben.

Daarnaast krijg je mogelijkheden om gebruikers te blokkeren en te deblokkeren, pagina's te beveiligen en nog veel meer. We sturen je ook een e-mail als iemand anders de wiki bewerkt.

In het kort, wordt je eigenaar en kun je de wiki kneden zoals je wilt.

Klinkt goed?",
	'wikiadoption-know-more-description' => 'Volg deze verwijzingen voor meer infomatie. Het staat je natuurlijk ook vrij om contact met ons op te nemen als je vragen hebt.',
	'wikiadoption-adoption-successed' => 'Gefeliciteerd! Je bent nu beheerder van deze wiki.',
	'wikiadoption-adoption-failed' => 'We hebben geprobeerd je beheerder te maken, maar dit lukte helaas niet. [http://community.wikia.com/Special:Contact Neem contact met ons op] zodat we je verder kunnen helpen.',
	'wikiadoption-not-allowed' => 'Je kunt deze wiki nu helaas niet adopteren.',
	'wikiadoption-not-enough-edits' => 'Je moet meer dan 10 bewerkingen gemaakt hebben om deze wiki te kunnen adopteren.',
	'wikiadoption-adopted-recently' => 'Je hebt recentelijk al een wiki geadapteerd. Je moet even wachten voordat je nog een wiki kunt adopteren.',
	'wikiadoption-notification' => '$1 kan geadopteerd worden. Je kunt de nieuwe eigenaar worden. $2',
	'wikiadoption-mail-first-subject' => 'We hebben je al een tijdje niet gezien',
	'wikiadoption-mail-first-content' => 'Hallo $1,

Het is al weer een aantal weken geleden dat we een beheerder in je wiki hebben gezien. Bedenk je dat jouw gemeenschap naar jou kijkt als het gaat om een soepel draaiende wiki.

Als je hulp nodig hebt bij het zorgen voor uw wiki, dan kan je ook andere gemeenschapsleden beheerder maken door te gaan naar $2.

Het Wikia-team

Klik op de volgende verwijzing om je uit te schrijven van wijzigingen op deze lijst: $3.',
	'wikiadoption-mail-first-content-HTML' => 'Hoi $1,<br /><br />
Het is al weer een aantal weken geleden dat er een beheerder actief is geweest op je wiki. Denk er alsjeblieft aan dat je gemeenschap naar jou kijkt als het gaat om het soepel laten draaien van de wiki.<br /><br />
Als je hulp nodig hebt bij het zorgen voor de wiki, dan kan je ook andere gemeenschapsleden beheerder maken via <a href="$2">Gebruikersrechtenbeheer</a>.<br /><br />
<b>Het Wikia-team</b><br /><br />
<small>Je kunt je van wijzigingen op deze lijst <a href="$3">uitschrijven</a>.</small>',
	'wikiadoption-mail-second-subject' => 'Je wiki wordt binnenkort voor adoptie opgegeven',
	'wikiadoption-mail-second-content' => 'Hoi $1,

Het is al weer even geleden dat we een beheerder hebben zien langskomen bij je wiki. Het is voor de gemeenschap belangrijk dat er actieve beheerders zijn om ervoor te zorgen dat de wiki lekker blijft draaien. Daarom wordt je wiki binnenkort beschikbaar gemaakt voor adoptie zodat er weer een kans op actieve beheerders gaat bestaan.

Het Wikia-team

Je kunt je van wijzigingen op deze lijst uitschrijven: $3.',
	'wikiadoption-mail-second-content-HTML' => 'Hoi $1,<br /><br />
Het is al weer even geleden dat we een beheerder hebben zien langskomen bij je wiki. Het is voor de gemeenschap belangrijk dat er actieve beheerders zijn om ervoor te zorgen dat de wiki lekker blijft draaien. Daarom wordt je wiki binnenkort beschikbaar gemaakt voor adoptie zodat er weer een kans op actieve beheerders gaat bestaan.<br /><br />
<b>Het Wikia-team</b><br /><br />
<small>Je kunt je van wijzigingen op deze lijst <a href="$3">uitschrijven</a>.</small>',
	'wikiadoption-mail-adoption-subject' => 'Je wiki is geadopteerd',
	'wikiadoption-mail-adoption-content' => 'Hoi $1,

Je wiki is geadopteerd! Dit betekent dat iemand anders zich heeft opgeworpen om te helpen bij het onderhouden van de gemeenschap en de inhoud van de site. Vrees niet. Je bent nog steeds beheerder en je bent nog steeds op ieder moment van harte welkom.

Het Wikia-team

Je kunt je van wijzigingen op deze lijst uitschrijven: $3.',
	'wikiadoption-mail-adoption-content-HTML' => 'Hoi $1,<br /><br />
Je wiki is geadopteerd! Dit betekent dat iemand anders zich heeft opgeworpen om te helpen bij het onderhouden van de gemeenschap en de inhoud van de site. Vrees niet. Je bent nog steeds beheerder en je bent nog steeds op ieder moment van harte welkom.<br /><br />
<b>Het Wikia-team</b><br /><br />
<small>Je kunt je van wijzigingen op deze lijst <a href="$3">uitschrijven</a>.</small>',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'wikiadoption' => 'Automatisk wikiadopsjon',
	'wikiadoption-desc' => 'En AutomatiskWikiAdopsjons-utvidelse for MediaWiki',
	'wikiadoption-header' => 'Adopter denne wikien',
	'wikiadoption-button-adopt' => 'Ja, jeg vil adoptere {{SITENAME}}!',
	'wikiadoption-adopt-inquiry' => 'Finn ut mer!',
	'wikiadoption-description' => '$1, klar til å adoptere {{SITENAME}}?
<br /><br />
Det har ikke vært noen aktive administratorer på {{SITENAME}} på en stund nå, og vi ser nå etter en ny leder for å hjelpe denne wikiens innhold og fellesskap å vokse! Som ev av bidragsyterne til {{SITENAME}} lurte vi på om du ville ha jobben.
<br /><br />
Ved å adoptere wikien vil du bli forfremmet til administrator og byråkrat for å gi deg verktøyene du trenger for å håndtere wikiens fellesskap og innhold. Du vil bli i stand til å opprette andre administratorer for å hjelpe, slette, tilbakeføre, flytte og beskytte sider, i tillegg til å opprette brukergrupper og tilordne brukere til dem.
<br /><br />
Er du klar til å ta det neste steget for å hjelpe {{SITENAME}}?',
	'wikiadoption-know-more-header' => 'Vil du vite mer?',
	'wikiadoption-know-more-description' => 'Sjekk disse lenkene for mer informasjon. Du er selvsagt velkommen til å kontakte oss om du har spørsmål!',
	'wikiadoption-adoption-successed' => 'Gratulerer! Du er nå administrator på denne wikien.',
	'wikiadoption-adoption-failed' => 'Beklager. Vi prøvde å gjøre deg til administrator, men det fungerte ikke. [http://community.wikia.com/Special:Contact Kontakt oss], så skal vi prøve å hjelpe deg.',
	'wikiadoption-not-allowed' => 'Beklager. Du kan ikke adoptere denne wikien akkurat nå.',
	'wikiadoption-not-enough-edits' => 'Ops! Du må ha flere enn ti redigeringer for å adoptere denne wikien.',
	'wikiadoption-adopted-recently' => 'Ops! Du har allerede adoptert en annen wiki nylig. Du må vente en stund før du kan adoptere en ny wiki.',
	'wikiadoption-log-reason' => 'Automatisk wikiadopsjon',
	'wikiadoption-notification' => '{{SITENAME}} er tilgjengelig for adopsjon. Interessert i å bli en leder her? Adopter denne wikien for å komme i gang!  $2',
	'wikiadoption-mail-first-subject' => 'Vi har ikke sett deg på en stund',
	'wikiadoption-mail-first-content' => 'Hei $1,

Det har gått noen uker siden vi så en administrator på wikien din. Husk at fellesskapet regner med at du sørger for at wikien går knirkefritt.

Hvis du trenger hjelp med å ta deg av wikien kan du gjøre andre fellesskapsmedlemmer til administratorer ved å gå til $2.

Wikia-ledelsen

Trykk på den følgende lenken for å avslutte abonnementet på endringer i denne listen: $3.',
	'wikiadoption-mail-first-content-HTML' => 'Hei $1,<br /><br />
Det har gått noen uker siden vi har sett en administrator på wikien din. Husk at fellesskapet regner med at du sørger for at wikien går problemfritt.<br /><br />
Hvis du trenger hjelp til å ta vare på wikien, kan du la andre medlemmer av fellesskapet bli administratorer ved å gå til href="$2">Brukerrettighetskontroll</a>.<br /><br />',
	'wikiadoption-mail-second-subject' => 'Vi vil sette opp wikien din til adopsjon snart',
	'wikiadoption-mail-second-content' => 'Hei $1,

Det er en stund siden vi har sett en administrator på wikien din. Det er viktig å ha aktive administratorer i fellesskapet slik at wikien går problemfritt - så vi vil snart sette opp wikien din for adopsjon slik at den får sjansen til å ha aktive administratorer igjen.

Wikia-teamet

Trykk på følgende lenke for å stoppe abonnementet på endringer fra denne listen: $3.',
	'wikiadoption-mail-second-content-HTML' => 'Hei $1,

Det er en stund siden vi har sett en administrator på wikien din. Det er viktig å ha aktive administratorer i fellesskapet slik at wikien går problemfritt - så vi vil snart sette opp wikien din for adopsjon slik at den får sjansen til å ha aktive administratorer igjen.

<b>Wikia-teamet</b>

<small>Du kan <a href="$3">stoppe abonnementet</a> på endringer fra denne listen.</small>',
	'wikiadoption-mail-adoption-subject' => 'Wikien din har blitt adoptert',
	'wikiadoption-mail-adoption-content' => 'Hei $1,

Wikien din har blitt adoptert! Dette betyr at noen andre har meldt seg frivillig til å hjelpe til med å opprettholde fellesskapet og innholdet på siden. Ikke bekymre deg - du er fremdeles en administrator, og du er velkommen til å komme tilbake når som helst.

Wikia-teamet

Trykk på følgende lenke for å stoppe abonnementet på endringer fra denne listen: $3.',
	'wikiadoption-mail-adoption-content-HTML' => 'Hei $1,<br /><br />
Wikien din har blitt adoptert! Dette betyr at noen andre har meldt seg frivillig til å hjelpe til med å opprettholde fellesskapet og innholdet på siden. Ikke bekymre deg - du er fremdeles en administrator, og du er velkommen til å komme tilbake når som helst.<br /><br />
<b>Wikia-teamet</b><br /><br />
<small>Du kan <a href="$3">stoppe abonnementet</a> på endringer fra denne listen.</small>',
	'tog-adoptionmails' => 'Send meg en e-post hvis $1 blir tilgjengelig for adopsjon av andre brukere',
	'wikiadoption-pref-label' => 'Å endre disse innstillingene vil bare påvirke e-poster fra $1.',
	'wikiadoption-welcome-header' => 'Gratulerer! Du har adoptert {{SITENAME}}!',
	'wikiadoption-welcome-body' => 'Du er nå en byråkrat på denne wikien. Med din nye status har du nå tilgang til alle verktøyene som vil hjelpe deg å håndtere {{SITENAME}}.
<br /><br />
Det viktigste du kan gjøre for å hjelpe {{SITENAME}} vokse er å fortsette å redigere.
<br /><br />
Hvis det ikke er noen aktive administratorer på en wiki kan den settes opp for adopsjon så sørg for å besøke wikien ofte.
<br /><br />
Nyttige verktøy:
<br /><br />
[[Special:ThemeDesigner|ThemeDesigner]]
<br />
[[Special:LayoutBuilder|Verktøy for sideoppsett]]
<br />
[[Special:ListUsers|Brukerliste]]
<br />
[[Special:UserRights|Håndter rettigheter]]',
);

/** Polish (Polski) */
$messages['pl'] = array(
	'wikiadoption' => 'Automatyczna adopcja wiki',
	'wikiadoption-header' => 'Adoptuj tę wiki',
	'wikiadoption-button-adopt' => 'Adoptuj teraz',
	'wikiadoption-know-more-header' => 'Chcesz wiedzieć więcej?',
	'wikiadoption-adoption-successed' => 'Gratulacje! Jesteś teraz administratorem na tej wiki!',
	'wikiadoption-mail-second-content' => 'Witaj $1,

Minęło sporo czasu od momentu, gdy ostatni raz widzieliśmy administratora na Twojej wiki. Obecność aktywnych administratorów jest ważna dla utrzymania porządku. Wkrótce oddamy Twoją wiki do adopcji, aby dać jej kolejną szansę na posiadanie aktywnych administratorów.

Zespół Wikii

Kliknij następujący link, jeśli chcesz zrezygnować z otrzymywania zmian na tej liście: $3.',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'wikiadoption' => 'Adopção automática de wikis',
	'wikiadoption-desc' => 'Uma extensão do MediaWiki para Adopção Automática de Wikis',
	'wikiadoption-header' => 'Adoptar esta wiki',
	'wikiadoption-button-adopt' => 'Adoptar agora',
	'wikiadoption-description' => 'Você tem colaborado nesta wiki, mas ela não tem um administrador activo. Quer desempenhar essa função?

Administrar a wiki significa que continua a criar conteúdo, mas também deve encorajar outros colaboradores da wiki directamente e estar disponível para ajudá-los quando precisarem de ajuda.

Em troca, recebe o poder de bloquear e desbloquear utilizadores, proteger páginas contra edição e terá acesso a muitas outras funcionalidades. Também receberá uma mensagem por correio electrónico quando outras pessoas editarem a wiki.

Em resumo, ela será sua e poderá dar-lhe a forma que desejar.

Quer administrar a wiki?',
	'wikiadoption-know-more-header' => 'Quer saber mais?',
	'wikiadoption-know-more-description' => 'Para mais informações visite estes links. E claro, contacte-nos se tiver alguma pergunta!',
	'wikiadoption-adoption-successed' => 'Parabéns! Agora é administrador desta wiki!',
	'wikiadoption-adoption-failed' => 'Infelizmente, tentámos torná-lo administrador desta wiki mas não funcionou. [http://community.wikia.com/Special:Contact Contacte-nos] e tentaremos ajudá-lo.',
	'wikiadoption-not-allowed' => 'Desculpe. Não pode adoptar esta wiki agora.',
	'wikiadoption-not-enough-edits' => 'Precisa de ter feito mais de 10 edições para adoptar esta wiki.',
	'wikiadoption-adopted-recently' => 'Já adoptou outra wiki recentemente. Tem de esperar algum tempo até poder adoptar mais uma wiki.',
	'wikiadoption-log-reason' => 'Adopção Automática de Wikis',
	'wikiadoption-notification' => 'É possível adoptar a wiki $1! Pode tornar-se o novo proprietário. $2!',
	'wikiadoption-mail-first-subject' => 'Já não o vemos há algum tempo',
	'wikiadoption-mail-first-content' => 'Olá $1,

Há já duas semanas que nenhum administrador visita a sua wiki. Lembre-se que a comunidade depende de si para garantir que a wiki está a funcionar normalmente.

Se precisa de ajuda para tomar conta da wiki, pode permitir que outros membros da comunidade também sejam administradores, visitando a página $2.

A Equipa da Wikia

Para cancelar a subscrição de alterações a esta lista, clique o seguinte link: $3',
	'wikiadoption-mail-first-content-HTML' => 'Olá $1,<br /><br />
Há já duas semanas que nenhum administrador visita a sua wiki. Lembre-se que a comunidade depende de si para garantir que a wiki está a funcionar normalmente.<br /><br />
Se precisa de ajuda para tomar conta da wiki, pode permitir que outros membros da comunidade também sejam administradores, na página <a href="$2">Privilégios dos utilizadores</a>.<br /><br />
<b>A Equipa da Wikia</b><br /><br />
<small>Pode <a href="$3">cancelar a subscrição</a> de alterações a esta lista.</small>',
	'wikiadoption-mail-second-subject' => 'A sua wiki será proposta para adopção em breve',
	'wikiadoption-mail-second-content' => 'Olá $1,

Há já algum tempo que nenhum administrador visita a sua wiki. É importante, para a comunidade, que existam administradores activos para que a wiki continue a funcionar normalmente - por isso, iremos propor a sua wiki para adopção em breve, de forma a que esta possa voltar a ter administradores activos.

A Equipa da Wikia

Para cancelar a subscrição de alterações a esta lista, clique o seguinte link: $3',
	'wikiadoption-mail-second-content-HTML' => 'Olá $1,

Há já algum tempo que nenhum administrador visita a sua wiki. É importante, para a comunidade, que existam administradores activos para que a wiki continue a funcionar normalmente - por isso, iremos propor a sua wiki para adopção em breve, de forma a que esta possa voltar a ter administradores activos.

<b>A Equipa da Wikia</b>

<small>Pode <a href="$3">cancelar a subscrição</a> de alterações a esta lista.</small>',
	'wikiadoption-mail-adoption-subject' => 'A sua wiki foi adoptada',
	'wikiadoption-mail-adoption-content' => 'Olá $1,

A sua wiki foi adoptada! Isto significa que alguém se voluntariou para manter a comunidade e o conteúdo do site. Não se preocupe - continua a ser administrador e pode voltar à wiki em qualquer altura.

A Equipa da Wikia

Para cancelar a subscrição de alterações a esta lista, clique o seguinte link: $3',
	'wikiadoption-mail-adoption-content-HTML' => 'Olá $1,<br /><br />
A sua wiki foi adoptada! Isto significa que alguém se voluntariou para manter a comunidade e o conteúdo do site. Não se preocupe - continua a ser administrador e pode voltar à wiki em qualquer altura.<br /><br />
<b>A Equipa da Wikia</b><br /><br />
<small>Pode <a href="$3">cancelar a subscrição</a> de alterações a esta lista.</small>',
	'tog-adoptionmails' => 'Notificar-me por correio electrónico se a $1 ficar disponível para adopção por outros utilizadores',
	'wikiadoption-pref-label' => 'Alterar estas preferências só afectará as mensagens por correio electrónico vindas da $1.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Aristóbulo
 */
$messages['pt-br'] = array(
	'wikiadoption' => 'Adoção automática de wikis',
	'wikiadoption-header' => 'Adotar esta wiki',
	'wikiadoption-button-adopt' => 'Adotar agora',
	'wikiadoption-know-more-header' => 'Quer saber mais?',
	'wikiadoption-know-more-description' => 'Para mais informações visite estes links. E claro, contate-nos se tiver alguma pergunta!',
	'wikiadoption-adoption-successed' => 'Parabéns! Agora você é administrador desta wiki!',
	'wikiadoption-adoption-failed' => 'Infelizmente, tentámos torná-lo administrador desta wiki mas não funcionou. [http://community.wikia.com/Special:Contact Contacte-nos] e tentaremos ajudá-lo.',
	'wikiadoption-not-allowed' => 'Desculpe. Não pode adotar esta wiki agora.',
	'wikiadoption-log-reason' => 'Adoção Automática de Wikis',
	'wikiadoption-notification' => "É possível adoptar a wiki $1! Pode tornar-se o novo proprietário. '''Adote-a agora!'''",
	'wikiadoption-mail-first-subject' => 'Já não o vemos há algum tempo',
	'wikiadoption-mail-first-content-HTML' => 'Olá $1,<br /><br />
Há já duas semanas que um administrador não visita a sua wiki. Lembre-se que a comunidade depende de si para garantir que a wiki está a funcionar normalmente.<br /><br />
Se precisa de ajuda para tomar conta da wiki, pode permitir que outros membros da comunidade também sejam administradores, na página <a href="$2">Privilégios dos utilizadores</a>.<br /><br />
<b>A Equipa da Wikia</b><br /><br />
<small>Pode <a href="$3">cancelar a subscrição</a> de alterações a esta lista.</small>',
	'wikiadoption-mail-second-subject' => 'A sua wiki será proposta para adoção em breve',
	'wikiadoption-mail-second-content' => 'Olá $1,

Há já algum tempo que nenhum administrador visita a sua wiki. É importante, para a comunidade, que existam administradores activos para que a wiki continue a funcionar normalmente - por isso, iremos propor a sua wiki para adopção em breve, de forma a que esta possa voltar a ter administradores activos.

A Equipa da Wikia

Para cancelar a subscrição de alterações a esta lista, clique o seguinte link: $3',
	'wikiadoption-mail-second-content-HTML' => 'Olá $1,

Há já algum tempo que nenhum administrador visita a sua wiki. É importante, para a comunidade, que existam administradores activos para que a wiki continue a funcionar normalmente - por isso, iremos propor a sua wiki para adopção em breve, de forma a que esta possa voltar a ter administradores activos.

<b>A Equipa da Wikia</b>

<small>Pode <a href="$3">cancelar a subscrição</a> de alterações a esta lista.</small>',
	'wikiadoption-mail-adoption-subject' => 'A sua wiki foi adotada',
	'wikiadoption-mail-adoption-content' => 'Olá $1,

A sua wiki foi adoptada! Isto significa que alguém se voluntariou para manter a comunidade e o conteúdo do site. Não se preocupe - continua a ser administrador e pode voltar à wiki em qualquer altura.

A Equipa da Wikia

Para cancelar a subscrição de alterações a esta lista, clique o seguinte link: $3',
	'wikiadoption-mail-adoption-content-HTML' => 'Olá $1,<br /><br />
A sua wiki foi adotada! Isto significa que alguém se voluntariou para manter a comunidade e o conteúdo do site. Não se preocupe - continua a ser administrador e pode voltar à wiki em qualquer altura.<br /><br />
<b>A Equipa da Wikia</b><br /><br />
<small>Pode <a href="$3">cancelar a subscrição</a> de alterações a esta lista.</small>',
	'tog-adoptionmails' => 'Notificar-me por correio electrónico quando houver alterações na administração (só para administradores)',
);

/** Romanian (Română)
 * @author Minisarm
 */
$messages['ro'] = array(
	'wikiadoption-header' => 'Adoptă acest wiki',
	'wikiadoption-button-adopt' => 'Adoptă acum',
	'wikiadoption-know-more-header' => 'Doriți să aflați mai multe?',
	'wikiadoption-mail-adoption-subject' => 'Wikiul dumneavoastră a fost adoptat',
);

/** Russian (Русский) */
$messages['ru'] = array(
	'wikiadoption-mail-adoption-content' => 'Привет, $1.

Вашу вки приютили! Это означает, что кто-то ещё добровольно вызвался поддерживать сообщество и содержание на сайте. Не беспокойтесь — Вы всё ещё администратор, и можете вернуться в любое время.

Команда Викии

Кликните по ссылке, чтобы отписаться от изменений в этом списке: $3.',
);

/** Serbian Cyrillic ekavian (‪Српски (ћирилица)‬)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'wikiadoption' => 'Самоприсвајање викије',
	'wikiadoption-header' => 'Присвоји ову викију',
	'wikiadoption-button-adopt' => 'Присвоји одмах',
	'wikiadoption-know-more-header' => 'Желите да знате више?',
	'wikiadoption-adoption-successed' => 'Честитамо! Постали сте администратор ове викије!',
);

/** Swedish (Svenska)
 * @author Tobulos1
 */
$messages['sv'] = array(
	'wikiadoption' => 'Automatisk wiki-adoption',
	'wikiadoption-header' => 'Adoptera den här wikin',
	'wikiadoption-button-adopt' => 'Adoptera nu',
	'wikiadoption-know-more-header' => 'Vill du veta mer?',
	'wikiadoption-know-more-description' => 'Kolla dessa länkar för mer information. Och naturligtvis är du välkommen att kontakta oss om du har några frågor!',
	'wikiadoption-adoption-successed' => 'Grattis! Du är nu en administratör på denna wiki!',
	'wikiadoption-adoption-failed' => 'Vi ber om ursäkt. Vi försökte att göra dig till en administratör, men det fungerade inte. Vänligen [http://community.wikia.com/Special:Contact kontakta oss], så ska vi försöka hjälpa dig.',
	'wikiadoption-not-allowed' => 'Vi ber om ursäkt. Du kan inte adoptera denna wiki just nu.',
	'wikiadoption-log-reason' => 'Automatisk Wiki-Adoption',
	'wikiadoption-notification' => "$1 är tillgänglig för adoption! Du kan bli den nya ägaren. '''Adoptera nu!'''",
	'wikiadoption-mail-first-subject' => 'Vi har inte sett dig på ett tag',
	'wikiadoption-mail-first-content-HTML' => 'Hej $1,<br /><br />
Det har varit ett par veckor sen vi såg en administratör på din wiki. Kom ihåg att din commynity kommer att titta till er för att se om wikin fungerar som den ska.<br /><br />
Om du behöver hjälp med att sköta din wiki, kan du tillåta andra medlemmar i din community att bli administratörer genom att gå till <a href="$2">Användarrättigheterna</a>.<br /><br />
<b>The Wikia Team</b><br /><br />
<small>Du kan <a href="$3">avbryta prenumerationen</a> från ändringar av denna lista.</small>',
	'wikiadoption-mail-second-subject' => 'Vi kommer att sätta upp din wiki för adoption snart',
	'wikiadoption-mail-second-content' => 'Hej $1,

Det var ett tag sen vi såg en administratör på din wiki. Det är viktigt att ha aktiva administratörer för din community så att wikin kan fortsätta att fungera smidigt - så vi kommer att sätta upp din wiki för adoption snart för att ge den en chans att få aktiva administratörer igen.

The Wikia Team

Klicka på följande länk för att avbryta din prenumeration på ändringar i denna lista: $3.',
	'wikiadoption-mail-second-content-HTML' => 'Hej $1,

Det var ett tag sen vi såg en administratör på din wiki. Det är viktigt att ha aktiva administratörer för din community så att din wiki kan fortsätta att fungera smidigt - så vi kommer att sätta upp din wiki för adoption snart för att ge den en chans att få aktiva administratörer igen.

<b>The Wikia Team</b>

<small>Du kan <a href="$3">avbryta prenumerationen</a> från ändringar på denna lista.</small>',
	'wikiadoption-mail-adoption-subject' => 'Din wiki har adopterats',
	'wikiadoption-mail-adoption-content' => 'Hej $1,

Din wiki har adopterats! Detta innebär att någon annan har erbjudit sig att bidra till att upprätthålla din community och innehållet på webbplatsen. Oroa dig inte - du är fortfarande en administratör, och du är välkommen att komma tillbaka när som helst.

The Wikia Team

Klicka på följande länk för att avsluta prenumerationen på ändringar i denna lista: $3.',
	'wikiadoption-mail-adoption-content-HTML' => 'Hej $1,<br /><br />
Din wiki har adopterats! Detta innebär att någon annan har erbjudit sig att bidra till att upprätthålla din community och innehållet på webbplatsen. Oroa dig inte - du är fortfarande en administratör, och du är välkommen att komma tillbaka när som helst.<br /><br />
<b>The Wikia Team</b><br /><br />
<small>Du kan <a href="$3">avbryta prenumerationen</a> på ändringar i denna lista.</small>',
	'tog-adoptionmails' => 'Skicka ett e-mail till mig när något ändras om wikins administration (endast administratörer)',
);

/** Telugu (తెలుగు) */
$messages['te'] = array(
	'wikiadoption-know-more-header' => 'మరింత తెలుసుకోవాలనుకుంటున్నారా?',
);

/** Ukrainian (Українська)
 * @author Тест
 */
$messages['uk'] = array(
	'wikiadoption-know-more-header' => 'Хочете знати більше?',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hydra
 */
$messages['zh-hans'] = array(
	'wikiadoption' => '制动维基领养',
	'wikiadoption-header' => '领养这个维基',
	'wikiadoption-button-adopt' => '现在领养',
	'wikiadoption-know-more-header' => '想知道更多吗？',
	'wikiadoption-adoption-successed' => '恭喜！您现在是这个维基的管理员！',
	'wikiadoption-log-reason' => '制动维基领养',
	'wikiadoption-mail-first-subject' => '我们没有看到你在一段时间',
);

