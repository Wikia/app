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
	'automaticwikiadoption-desc' => 'TODO',
	'automaticwikiadoption-header' => 'Adopt this wiki',
	'automaticwikiadoption-button-adopt' => 'Adopt now',
	'automaticwikiadoption-description' => "You've contributed ... TODO",
	'automaticwikiadoption-know-more-header' => 'Want to know more?',
	'automaticwikiadoption-know-more-description' => 'Check out these links for more information. And of course, feel free to contact us if you have any questions!',
	'automaticwikiadoption-adoption-successed' => 'Congratulations! You are a now an administrator on this wiki!',
	'automaticwikiadoption-adoption-failed' => "We're sorry. We tried to make you an administrator, but it did not work out. Please [http://community.wikia.com/Special:Contact contact us], and we will try to help you out.",
	'automaticwikiadoption-not-allowed' => "We're sorry. You cannot adopt this wiki right now.",
	'automaticwikiadoption-log-reason' => 'Automatic Wiki Adoption',
	'automaticwikiadoption-notification' => "$1 is up for adoption! You can become the new owner. '''Adopt now!'''",
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

Your wiki has been adopted! This means that someone else has volunteered to help maintain the community and content on the site. Don't worry - you are still an administrator, and you are welcome to come back at any time.

The Wikia Team

Click the following link to unsubscribe from changes to this list: $3.",
	'automaticwikiadoption-mail-adoption-content-HTML' => "Hi $1,<br /><br />
Your wiki has been adopted! This means that someone else has volunteered to help maintain the community and content on the site. Don't worry - you're still an administrator, and you are welcome to come back at any time.<br /><br />
<b>The Wikia Team</b><br /><br />
<small>You can <a href=\"$3\">unsubscribe</a> from changes to this list.</small>",
	'tog-adoptionmails' => 'E-mail me when something changes about wiki administration (administrators only)',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'automaticwikiadoption-know-more-header' => 'Wil u meer weet?',
);

/** Breton (Brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'automaticwikiadoption-header' => 'Degemer ar wiki-mañ',
	'automaticwikiadoption-button-adopt' => 'Degemer bremañ',
	'automaticwikiadoption-know-more-header' => "C'hoant gouzout hiroc'h ?",
	'automaticwikiadoption-adoption-successed' => "Gourc'hemennoù ! Merour oc'h bremañ war ar wiki-mañ !",
	'automaticwikiadoption-adoption-failed' => "Digarezit ac'hanomp. Klasket on eus lakaat ac'hanoc'h da verour, met ne ya ket en-dro. Mar plij [http://community.wikia.com/Special:Contact deuit e darempred ganeomp], hag e klaskimp skoazellañ ac'hanoc'h.",
	'automaticwikiadoption-not-allowed' => "Digarezit ac'hanomp. Ne c'hellit ket degemer ar wiki-mañ bremañ.",
	'automaticwikiadoption-notification' => "$1 a zo prest da vezañ degemeret ! Gellout a rit bezañ ar perc'henn nevez. '''Degemer bremañ !'''",
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
	'automaticwikiadoption-log-reason' => 'Adoption automatic de wikis',
	'automaticwikiadoption-notification' => "$1 es disponibile pro adoption! Tu pote devenir le nove proprietario. '''Adopta lo ora!'''",
	'automaticwikiadoption-mail-first-subject' => 'Nos non te ha vidite durante un tempore',
	'automaticwikiadoption-mail-second-subject' => 'Nos rendera tu wiki disponibile pro adoption tosto',
	'automaticwikiadoption-mail-adoption-subject' => 'Tu wiki ha essite adoptate',
	'tog-adoptionmails' => 'Inviar me e-mail si alique cambia in le administration del wiki (administratores solmente)',
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
	'automaticwikiadoption-log-reason' => 'Автоматско посвојување на вики',
	'automaticwikiadoption-notification' => "$1 може да се посвои! Имате можност да бидете новиот сопственик. '''Посвојте го веднаш!'''",
	'automaticwikiadoption-mail-first-subject' => 'Не ве имаме видено во последно време',
	'automaticwikiadoption-mail-second-subject' => 'Наскоро ќе го понудиме вашето вики за посвојување',
	'automaticwikiadoption-mail-adoption-subject' => 'Вашето вики е посвоено',
	'tog-adoptionmails' => 'Извести ме по е-пошта ако нешто се измени во администрацијата на викито (само за администратори)',
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
	'automaticwikiadoption-log-reason' => 'Automatische wikiadoptie',
	'automaticwikiadoption-notification' => "$1 kan geadopteerd worden. U kunt de nieuwe eigenaar worden. '''Adopteer de wiki nu!'''",
	'automaticwikiadoption-mail-first-subject' => 'We hebben u al een tijdje niet gezien',
	'automaticwikiadoption-mail-second-subject' => 'Uw wiki wordt binnenkort voor adoptie opgegeven',
	'automaticwikiadoption-mail-adoption-subject' => 'Uw wiki is geadopteerd',
	'tog-adoptionmails' => 'Mij e-mailen als er wijzigingen zijn in het wikibeheer (alleen voor beheerders)',
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
	'automaticwikiadoption-notification' => "$1 kan adopteres! Du kan bli den nye eieren. '''Adopter nå!'''",
	'automaticwikiadoption-mail-first-subject' => 'Vi har ikke sett deg på en stund',
	'automaticwikiadoption-mail-second-subject' => 'Vi vil sette opp wikien din til adopsjon snart',
	'automaticwikiadoption-mail-adoption-subject' => 'Wikien din har blitt adoptert',
	'tog-adoptionmails' => 'Send meg en e-post når wikiadministrasjonen endres (kun administratorer)',
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
	'automaticwikiadoption-log-reason' => 'Adopção Automática de Wikis',
	'automaticwikiadoption-notification' => "É possível adoptar a wiki $1! Pode tornar-se o novo proprietário. '''Adopte-a agora!'''",
	'automaticwikiadoption-mail-first-subject' => 'Já não o vemos há algum tempo',
	'automaticwikiadoption-mail-second-subject' => 'A sua wiki será proposta para adopção em breve',
	'automaticwikiadoption-mail-adoption-subject' => 'A sua wiki foi adoptada',
	'tog-adoptionmails' => 'Notificar-me por correio electrónico quando houver alterações na administração (só para administradores)',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'automaticwikiadoption-know-more-header' => 'మరింత తెలుసుకోవాలనుకుంటున్నారా?',
);