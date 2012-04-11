<?php

$messages = array();

$messages['en'] = array(
	'chat' => 'Chat',
	'chat-desc' => '[[Special:Chat|Live chat]]',
	'chat-no-login' => 'You must be logged in to chat.',
	'chat-no-login-text' => 'Please login to chat.',
	'chat-default-topic' => 'Welcome to the $1 chat',
	'chat-welcome-message' => 'Welcome to the $1 chat',
	'chat-user-joined' => '$1 has joined the chat.',
	'chat-read-only' => 'Chat is temporarily unavailable while wiki is in read-only mode.',
	'chat-private-messages' => 'Private Messages',
	// Many of these are sent from server.js to the client (which uses $.msg() to translate the message).
	'chat-user-parted' => '$1 has left the chat.',
	'chat-user-joined' => '$1 has joined the chat.',
	'chat-user-blocked' => '$1 has blocked $2.',
	'chat-user-allow' => '$1 has allowed $2.',

	'chat-kick-you-need-permission' => 'You do not have permissions to kick a user.',
	'chat-kick-cant-kick-moderator' => 'You cannot kick another Chat Moderator.',
	
	'chat-user-was-kicked' => "$1 has been kicked by $2.",
	'chat-you-were-kicked' => "You have been kicked by $1.",

	'chat-user-was-banned' => '$1 has been banned by $2 $3.',
	'chat-you-were-banned' => 'You have been banned by $1.',
	'chat-user-was-unbanned' => '$2 has ended the Chat ban for $1.',
	
	'chat-ban-cannt-undo' => 'Ban has already been undone',

	'chat-user-permanently-disconnected' => 'You have been disconnected, check your Internet connection and refresh browser window',

	'chat-inlinealert-a-made-b-chatmod' => "$1 has made <strong>$2</strong> a chat moderator.",
	'chat-err-connected-from-another-browser' => 'You have connected from another browser. This connection will be closed.',
	'chat-err-communicating-with-mediawiki' => 'Error communicating with MediaWiki server.',

	// Kick/Ban modal
	
	'chat-ban-contributions-heading' => 'Ban from chat',
	'chat-ban-modal-heading' => 'Ban this user from chat',
	'chat-ban-modal-label-expires' => 'Expires',
	'chat-ban-modal-label-reason' => 'Reason',
	'chat-log-reason-banadd' => 'Misbehaving in chat',
	'chat-log-reason-undo' => 'undo',

	'chat-ban-undolink' => 'undo',
	'chat-ban-modal-button-ok' => 'Ban this user',

	'chat-ban-modal-button-change-ban' => 'Change Ban',
	'chat-ban-modal-button-cancel' => 'Cancel',
	'chat-ban-modal-change-ban-heading' => 'Change this user\'s chat ban',
	'chat-ban-modal-change-ban-label' => 'Change to',	
	'chat-ban-modal-end-ban' => 'End Ban',
	'chat-log-reason-banchange' => 'No reason given',
	'chat-log-reason-banremove' => 'No reason given',
	
	// Possible errors when trying to kick/ban a user:
	'chat-ban-cant-ban-moderator' => "You cannot kick/ban another Chat Moderator.",
	'chat-ban-already-banned' => '$1 is already banned from chat on this wiki.',
	'chat-ban-you-need-permission' => 'You do not have the $1 permission which is required to kick/ban a user.',
	'chat-missing-required-parameter' => '\'$1\' is required but was not found in the request.',

	'chat-err-already-chatmod' => "Error: \"$1\" is already in the \"$2\" group.",
	'chat-err-no-permission-to-add-chatmod' => "Error: You do not have permission to add the \"$1\" group to this user.",
	'chat-userrightslog-a-made-b-chatmod' => "$1 promoted $2 to be a chat moderator on this wiki.",
	'chat-err-invalid-username-chatmod' => 'Error: Couldn\'t find user "$1"',
	
	'chat-you-are-banned' => 'Permissions error.',
	// TODO: link to list of admins
	'chat-you-are-banned-text' => 'Sorry, you do not have permission to chat on this wiki.  If you think this was a mistake or would like to be reconsidered, please contact an administrator.',
	'chat-room-is-not-on-this-wiki' => 'The chat room you are attempting to enter does not appear to exist on this wiki.',
	'chat-kick-log-reason' => 'Kick/banned from the chat for this wiki by $1. Please contact them for more info.',
	'chat-live2' => 'Live! Chat',
	'chat-start-a-chat' => 'Start a Chat',
	'chat-join-the-chat' => 'Join the Chat',
	'chat-edit-count' => '{{PLURAL:$1|$1 edit|$1 edits}}',

	'chat-member-since' => 'Member since $1',
	'chat-great-youre-logged-in' => "Great! You're logged in.",

	'chat-user-menu-message-wall' => 'Message Wall',
	'chat-user-menu-talk-page' => 'Talk Page',
	'chat-user-menu-contribs' => 'Contributions',
	'chat-user-menu-private' => 'Private Message',
	'chat-user-menu-give-chat-mod' => 'Give ChatMod Status',
	'chat-user-menu-kick' => 'Kick',
	'chat-user-menu-ban' => 'Ban',

	'chat-user-menu-private-block' => 'Block Private Messages',
	'chat-user-menu-private-allow' => 'Allow Private Messages',
	'chat-user-menu-private-close' => 'Close Private Room',
	'chat-private-headline' => 'Private chat with $1',

	//rights/groups
	'right-chatmoderator' => 'Can kick/ban users from [[Help:Chat|Chat]]',
	'group-chatmoderator' => 'Chat moderators',
	'group-chatmoderator-member' => 'Chat moderator',
	'grouppage-chatmoderator' => 'w:c:community:Help:Chat',

	'group-bannedfromchat' => 'Banned from chat',
	'group-bannedfromchat-member' => 'Banned from chat',
	'grouppage-bannedfromchat' => 'w:c:community:Help:Chat',


	'chatfailover' => 'Chatfailover control center',

	'chat-failover-warning-title' => 'Read this carefully !!!',

	'chat-failover-warning' => "This special page allows you to switch the chat to failover mode. 
	<br><br>If you're not an engineer, performing this operation requires consultation. <br><br>
	If chat is operating allready in failover mode and the chat app is not working: DO not switch it beck to regular mode without consultating an operations engineer",

	'chat-failover-server-list' => 'Chat servers in use:',
	
	'chat-failover-operating-failover' => 'Chat is operating now in: <span>failover mode</span>', 
	'chat-failover-operating-regular' => 'Chat is operating now in: <span>regular mode</span>',
	
	'chat-failover-reason' => 'To switch mode enter a reason and press button',
	
	'chat-failover-switchmode-failover' => 'To switch to regular mode',
	'chat-failover-switchmode-regular' => 'To switch to failover mode',
	
	'chat-failover-mode-areyousure' => 'Do you understands the consequences of this operation ???',
	'chat-failover-reason-empty' => 'Reason can not be empty',

	'chat-failover-log-entry' => "$1 Chat operating mode changed by user [[User:$2]] to $3. '''Reason''': $4",

	'chat-ban-option-list' => '2 hours:2 hours,1 day:1 day,3 days:3 days,1 week:1 week,2 weeks:2 weeks,1 month:1 month,3 months:3 months,6 months:6 months,1 year:1 year,infinite:infinite',
	
	'chat-ban-log-change-ban-link' => 'change ban',

	'chat-chatban-log' => 'Chat ban log',
	'chat-chatbanadd-log-entry' => 'banned $1 from chat with an expiry time of $2, ends $3',
	'chat-chatbanremove-log-entry' => 'unbanned $1 from chat', 
	'chat-chatbanchange-log-entry' =>  'changed ban settings for $1 with an expiry time of $2, ends $3',
	'chat-contributions-ban-notice' => 'This user is currently banned from chat. The latest chat ban log entry is provided below for reference:',

	'chat-browser-is-notsupported' => '	Your browser is not supported. For the best experience, use a <a href="http://community.wikia.com/wiki/Help:Supported_browsers">newer browser</a>.'
);

/** Message documentation (Message documentation)
 * @author Aldnonymous
 * @author Claudia Hattitten
 * @author Lloffiwr
 * @author Sean Colombo
 * @author VezonThunder
 */
$messages['qqq'] = array(
	'chat' => 'shown in Special:Specialpages as the link label.',
	'chat-inlinealert-a-made-b-chatmod' => '$1 is user name when "he" make other user ($2) to become moderator. (account upgrade)',
	'chat-whos-here' => 'Regards users that are in a chat room. The parameter gives the total count.',
	'chat-edit-count' => '$1 is the number of edits made by the user',
	'chat-member-since' => '$1 tells both the month and the year, month abbreviated. E.g. "Apr 2008".',
	'chat-user-menu-give-chat-mod' => 'ChatMod = chat moderator',
	'chat-kick-you-need-permission' => 'shown to the user when he tries to kick someone, but does not have a required rights',
	'chat-kick-cant-kick-moderator' => 'shown when user tries to kick another chat moderator (which is not allowed)',
	'chat-user-was-kicked' => 'broadcasted after a user was kicked; $1 is the name of kicked user, $2 is the kicking chat moderator',
	'chat-you-were-kicked' => 'sent to a user when he was kicked; $1 is the kicking chat moderator',
	'chat-ban-modal-heading' => 'This is the <h2> (heading) tag at the top of the modal for banning a user from chat.',
	'chat-ban-modal-label-expires' => 'form label inside modal for banning users.  "Expires" refers to the time at which the banned user can return to chat.',
	'chat-ban-modal-label-reason' => 'form label inside modal for banning users.  "Reason" is the reason for banning a user from chat.',
	'chat-log-reason-banadd' => 'Placeholder text for the "reason" input inside the ban user from chat modal.',
	'chat-ban-modal-button-ok' => 'Button text to submit the form inside a modal, banning a user from chat. ',
	'chat-ban-modal-button-change-ban' => 'Button text to submit the form inside a modal, changing a user\'s ban from chat. ',
	'chat-ban-modal-button-cancel' => 'Button text to cancel the modal that bans a user from chat.',
	'chat-ban-modal-change-ban-heading' => 'Heading text for the modal for changing or ending a user\'s ban.',
	'chat-ban-modal-change-ban-label' => 'This is the form label displayed when an admin user wants to change a chat ban of another user.',	
	'chat-ban-modal-end-ban' => 'Option inside a select menu.  Choose this option if you want the end a user\'s ban.',
	'chat-welcome-message' => 'sent to a user when he join chat',
	'chat-ban-option-list' => 'This is used for setting the options for expiration time when banning a user from chat. The value before the colon (:) is what the user will see.  The value after the color will translate to the amount of time the user is banned.  Do not change the value after the colon unless you actually want to change the options presented for expiring a ban. Another way of writing this would be: "The banned user will be banned for 2 hours:2 hours; The banned user will be banned for 3 days:3 days;" So, as you can see, it is very important that the time values on either side of the colon match up.',
	'chat-ban-log-change-ban-link' => 'shown in Special:Log',
	'chat-user-was-banned' => 'The user was banned from chat.',
	'chat-you-were-banned'  => 'sent to a user when he was banned; $1 is the baning chat moderator',
	'chat-user-was-unbanned' => 'sent to a user when he was unbanned; $1 is the baning chat moderator',
	'chat-ban-cannt-undo' => 'sent to a user who cannt undo ban',
	'chat-user-menu-ban' => 'Click here to ban a user (from the user dropdown menu).',
	'chat-ban-contributions-heading' => 'shown in contributions under the list of actions',
	'chat-private-messages' => 'Header in right user list for private messages section',
	'chat-browser-is-notsupported' => 'shown when user broser is not supported',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'chat-no-login-text' => 'Meld asseblief aan om te klets.',
);

/** Arabic (العربية)
 * @author Malhargan
 */
$messages['ar'] = array(
	'chat-desc' => '[[دردشة : خاصة  | دردشة مباشرة]]',
	'chat-no-login' => 'يجب تسجيل الدخول إلى الدردشة.',
	'chat-no-login-text' => 'يرجى تسجيل الدخول للمحادثة.',
	'chat-default-topic' => 'مرحبا بكم في دردشة SAR4',
	'chat-user-joined' => '$1 انضمت إلى الدردشة.',
	'chat-user-parted' => '$1 تركت الدردشة.',
	'chat-user-blocked' => 'SAR4 حظر SAR8 .',
	'chat-user-allow' => 'SAR4 سمحت SAR8 .',
);

/** Asturian (Asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'chat-desc' => '[[Special:Chat|Charra en vivu]]',
	'chat-no-login' => 'Has de tar coneutáu pa charrar',
	'chat-no-login-text' => 'Por favor, conéutate pa charrar.',
	'chat-default-topic' => 'Bienveníu a la charra $1',
	'chat-ban-cant-ban-moderator' => 'Nun pues espulsar/torgar a otru moderador del chat.',
	'chat-ban-already-banned' => '$1 yá tien torgáu el chat nesta wiki.',
	'chat-ban-you-need-permission' => 'Nun tienes el permisu de $1 que ye necesariu pa espulsar/torgar a un usuariu.',
	'chat-missing-required-parameter' => "'$1' ye necesariu, pero nun s'alcontró na petición.",
	'chat-you-are-banned' => 'Fallu de permisos.',
	'chat-you-are-banned-text' => "Nun tienes permisu pal chat d'esta wiki. Si pienses que foi por error o quies que se reconsidere, ponte en contautu con un alministrador.",
	'chat-room-is-not-on-this-wiki' => 'La sala de charra na que tas tentando entrar paez que nun esiste nesta wiki.',
	'chat-kick-log-reason' => "Espulsáu/torgáu na charra d'esta wiki por $1.
Ponte'n contautu con ellos pa más info.",
	'chat-headline' => 'Chat de $1',
	'chat-live' => '¡En vivo!',
	'chat-start-a-chat' => 'Aniciar una charra',
	'chat-whos-here' => 'Quién ta equí ($1)',
	'chat-join-the-chat' => 'Xunise al Chat',
	'chat-edit-count' => '$1 Ediciones',
	'chat-member-since' => 'Miembru dende $1',
	

	//Special Chatfailover
	'chat-failover-warning-title' => 'WARNING TITLE',
	'chat-failover-warning' => 'WARNING TITLE',
	'chat-failover-operating-failover', 'we are operating in failover mode',
	'chat-failover-operating-regular' => 'we are operating in regular mode',
	'chat-failover-reason' => "Enter reasone",
	'chat-failover-button' => "Switch to failover mode",
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'chat-desc' => '[[Special:Chat|Чат]]',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'chat' => 'Flap',
	'chat-desc' => '[[Special:Chat|Flapiñ war-eeun]]',
	'chat-no-login' => "Ret eo deoc'h bezañ kevreet evit flapiñ",
	'chat-no-login-text' => 'Kevreit evit gallout flapiñ.',
	'chat-default-topic' => 'Degemer mat er flap $1',
	'chat-user-blocked' => '$1 en deus stanket $2',
	'chat-user-allow' => '$1 en deus aotreet $2.',
	'chat-ban-cant-ban-moderator' => "N'hallit ket skarzhañ/stankañ ur merour all eus ar flap.",
	'chat-ban-already-banned' => '$1 a zo stanket dija war flap ar wiki-mañ.',
	'chat-ban-you-need-permission' => "N'ho peus ket an aotreoù $1 rekis evit skarzhañ/stankañ un implijer.",
	'chat-missing-required-parameter' => 'Rekis eo "$1" met n\'eo ket bet kavet er reked.',
	'chat-you-are-banned' => 'Fazi aotreoù.',
	'chat-you-are-banned-text' => "Berzet eo bet ar flap ouzhoc'h.
Ma soñj deoc'h ez eo dre fazi pe mar fell deoc'h e vefe distroet war an diviz e c'hallit mont e darempred gant ur merour.",
	'chat-room-is-not-on-this-wiki' => "Evit doare n'eus ket eus ar gaoz a glaskit kevreañ outi war ar wiki-mañ.",
	'chat-kick-log-reason' => "Skarzhet eus ar flap er wiki-mañ gant $1.
Kit e darempred ganto da c'houzout hiroc'h.",
	'chat-headline' => 'Chat $1',
	'chat-live' => 'War-eeun !',
	'chat-start-a-chat' => 'Kregiñ gant ar Flap',
	'chat-whos-here' => "Piv 'vez amañ ($1)",
	'chat-join-the-chat' => 'Mont er Flap',
	'chat-edit-count' => '$1 Kemm',
	'chat-member-since' => 'Ezel adalek an $1',
	'chat-user-menu-profile' => 'Profil implijer',
	'chat-user-menu-contribs' => 'Degasadennoù',
	'chat-user-menu-private' => 'Kemennadenn brevez',
	'chat-user-menu-private-block' => "Stankañ ar c'hemennadennoù prevez",
	'chat-user-menu-private-allow' => "Aotren ar c'hemennadennoù prevez",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'chat-desc' => '[[Special:Chat|Razgovor uživo]]',
	'chat-no-login' => 'Morate biti prijavljeni da biste chatali',
	'chat-no-login-text' => 'Molimo prijavite se za chat.',
	'chat-default-topic' => 'Dobrodošli na $1 chat',
	'chat-you-are-banned' => 'Greške pri odobrenju.',
	'chat-you-are-banned-text' => 'Zabranjen vam je chat.
Ako mislite da je to greška ili želite da se ponovo razmotri, molimo kontaktirajte administratora.',
	'chat-kick-log-reason' => 'Izbačeni/blokirani ste za chat na ovoj wiki od strane $1.
Molimo kontaktirajte ga za više podataka.',
);

/** Catalan (Català)
 * @author BroOk
 */
$messages['ca'] = array(
	'chat-desc' => '[[Special:Chat|Xat en línia]]',
	'chat-no-login' => "Has d'estar connectat al xat.",
	'chat-no-login-text' => "Si us plau connecta't per parlar.",
	'chat-default-topic' => 'Benvingut al xat de $1',
	'chat-user-joined' => "$1 s'ha unit al xat.",
	'chat-read-only' => 'El Xat està temporalment no disponible mentre la wiki estigui en mode llegir-només.',
	'chat-user-parted' => '$1 ha sortit del xat.',
	'chat-user-blocked' => '$1 ha bloquejat $2 .',
	'chat-user-allow' => '$1 ha permès $2 .',
	'chat-user-permanently-disconnected' => 'Has sigut desconnectat, comprova la teva connexió a Internet i refresca la finestra del navegador',
	'chat-inlinealert-a-made-b-chatmod' => '$1ha fet a <strong>$2</strong> un Moderador de Xat.',
	'chat-err-connected-from-another-browser' => "T'has connectat des d'un altre navegador. Aquesta connexió es tancarà.",
	'chat-err-communicating-with-mediawiki' => 'Error de comunicació amb el servidor de MediaWiki.',
	'chat-ban-cant-ban-moderator' => 'No pots expulsar/bennejar un altre Moderador del Xat.',
	'chat-ban-already-banned' => "$1 ja està bannejat del xat d'aquest wiki.",
	'chat-ban-you-need-permission' => 'No teniu el $1 permís que es necessita per expulsar/bannejar un usuari.',
	'chat-missing-required-parameter' => "'$1' és necessari però no s'ha trobat en la sol·licitud.",
	'chat-err-already-chatmod' => 'Error: "$1" ja està en el "$2" grup.',
	'chat-err-no-permission-to-add-chatmod' => 'Error: No té permís per afegir el " $1 " grup a aquest usuari.',
	'chat-userrightslog-a-made-b-chatmod' => '$1promogut $2 per ser moderador del xat en aquest wiki.',
	'chat-you-are-banned' => 'Error de permisos.',
	'chat-you-are-banned-text' => "Ho sentim, no teniu permís per xatejar en aquest wiki. Si penses que és un error o vols ser reconsiderat, si us plau posa't contacte amb un administrador.",
	'chat-room-is-not-on-this-wiki' => "La sala de xat que estàs intentant d'entrar no sembla existir en aquest wiki.",
	'chat-kick-log-reason' => "Expulsat/bannejat del xat d'aquest wiki per $1. Si us plau, poseu-vos en contacte per més informació.",
	'chat-headline' => '$1 Xat',
	'chat-live' => 'Live!',
	'chat-start-a-chat' => 'Entra al Xat',
	'chat-whos-here' => 'Qui és aquí ($1)',
	'chat-join-the-chat' => 'Uneix-te al xat',
	'chat-edit-count' => '$1 Edicions',
	'chat-member-since' => 'Membre des de $1',
	'chat-great-youre-logged-in' => "Genial! T'has connectat.",
	'chat-user-menu-profile' => "Perfil d'usuari",
	'chat-user-menu-contribs' => 'Contribucions',
	'chat-user-menu-private' => 'Missatge Privat',
	'chat-user-menu-give-chat-mod' => 'Fer Mod. del Xat',
	'chat-user-menu-private-block' => 'Bloquejar Missatges Privats',
	'chat-user-menu-private-allow' => 'Permetre Missatges Privats',
	'chat-user-menu-private-close' => 'Tancar la Sala Privada',
	'chat-private-headline' => 'Xat privat amb $1',
	'right-chatmoderator' => 'Pots expulsar/bannejar un usuari del [[Help:Chat|Xat]]',
	'group-chatmoderator' => 'Moderadors del Xat',
	'group-chatmoderator-member' => 'Moderador del Xat',
	'group-bannedfromchat' => 'BannedFromChat',
	'group-bannedfromchat-member' => 'BannedFromChat',
);

/** German (Deutsch)
 * @author Claudia Hattitten
 * @author DaSch
 * @author Jan Luca
 * @author LWChris
 * @author SVG
 * @author Tiin
 */
$messages['de'] = array(
	'chat-desc' => '[[Special:Chat|Live-Chat]]',
	'chat-no-login' => 'Du musst angemeldet sein, um chatten zu können.',
	'chat-no-login-text' => 'Bitte anmelden, um zu chatten.',
	'chat-default-topic' => 'Willkommen im $1 Chat',
	'chat-user-joined' => '$1 hat den Chat betreten.',
	'chat-read-only' => 'Der Chat ist vorübergehend nicht erreichbar, während es sich im Nur-Lesen-Modus befindet.',
	'chat-user-parted' => '$1 hat den Chat verlassen.',
	'chat-user-blocked' => '$1 hat $2 blockiert.',
	'chat-user-allow' => '$1 hat $2 zugelassen.',
	'chat-user-permanently-disconnected' => 'Die Verbindung wurde getrennt. Überprüfe deine Internet-Verbindung und aktualisiere das Browser-Fenster.',
	'chat-inlinealert-a-made-b-chatmod' => '$1 hat <strong>$2</strong> zum Chat-Moderator gemacht.',
	'chat-err-connected-from-another-browser' => 'Du hast dich mit einem anderen Browser verbunden. Diese Verbindung wird geschlossen.',
	'chat-err-communicating-with-mediawiki' => 'Fehler bei Kommunikation mit MediaWiki Server.',
	'chat-ban-cant-ban-moderator' => 'Du kannst einen anderen Moderator nicht rauswerfen.',
	'chat-ban-already-banned' => '$1 ist bereits aus dem Chat verbannt.',
	'chat-ban-you-need-permission' => 'Du verfügst nicht über die Berechtigung $1, die erforderlich ist, um einen Benutzer zu entfernen/verbannen.',
	'chat-missing-required-parameter' => '"$1" ist notwendig, wurde aber in der Anfrage nicht gefunden.',
	'chat-err-already-chatmod' => 'Fehler: "$1" ist bereits in der "$2" Gruppe.',
	'chat-err-no-permission-to-add-chatmod' => 'Fehler: Du hast keine Berechtigung, die "$1" Gruppe bei diesem Benutzer hinzuzufügen.',
	'chat-userrightslog-a-made-b-chatmod' => '$1 hat $2 zum Chat-Moderator in diesem Wiki befördert.',
	'chat-you-are-banned' => 'Berechtigungsfehler.',
	'chat-you-are-banned-text' => 'Entschuldige bitte, aber du hast keine Berechtigung, in diesem Wiki zu chatten.
Wenn du dies für einen Fehler hältst oder möchtest, dass die Entscheidung überdacht wird, wende dich bitte an einen Administrator.',
	'chat-room-is-not-on-this-wiki' => 'Den Chat-Raum, dem du beitreten willst, scheint es in diesem Wiki nicht zu geben.',
	'chat-kick-log-reason' => 'Rauswurf aus dem Chat für dieses Wiki durch $1. Bitte kontaktiere $1 für weitere Informationen.',
	'chat-headline' => 'Chat: $1',
	'chat-live' => 'in Echtzeit!',
	'chat-start-a-chat' => 'Chat starten',
	'chat-whos-here' => 'Anwesende ($1)',
	'chat-join-the-chat' => 'Chat beitreten',
	'chat-edit-count' => '{{PLURAL:$1|Eine Bearbeitung|$1 Bearbeitungen}}',
	'chat-member-since' => 'Mitglied seit $1',
	'chat-great-youre-logged-in' => 'Glückwunsch! Du hast dich angemeldet.',
	'chat-user-menu-profile' => 'Benutzerprofil',
	'chat-user-menu-contribs' => 'Beiträge',
	'chat-user-menu-private' => 'Private Nachricht',
	'chat-user-menu-give-chat-mod' => 'ChatMod Status verleihen',
	'chat-user-menu-private-block' => 'Private Nachrichten blockieren',
	'chat-user-menu-private-allow' => 'Private Nachrichten erlauben',
	'chat-user-menu-private-close' => 'Privatchat schließen',
	'chat-private-headline' => 'Privater Chat mit $1',
	'right-chatmoderator' => 'Kann einen Benutzer aus dem [[Hilfe:Chat|Chat]] kicken/bannen',
	'group-chatmoderator' => 'Chat-Moderatoren',
	'group-chatmoderator-member' => 'Chat-Moderator',
	'group-bannedfromchat' => 'Aus dem Chat verbannt',
	'group-bannedfromchat-member' => 'Aus dem Chat verbannt',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author Tiin
 */
$messages['de-formal'] = array(
	'chat-user-permanently-disconnected' => 'Die Verbindung wurde getrennt. Überprüfen Sie ihre Internet-Verbindung und aktualisieren Sie das Browser-Fenster.',
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 */
$messages['diq'] = array(
	'chat-live' => 'Dare',
);

/** Spanish (Español)
 * @author VegaDark
 */
$messages['es'] = array(
	'chat-desc' => '[[Special:Chat|Chat en vivo]]',
	'chat-no-login' => 'Debes iniciar sesión para chatear.',
	'chat-no-login-text' => 'Inicia sesión para chatear.',
	'chat-default-topic' => 'Bienvenido al chat de $1',
	'chat-user-joined' => '$1 ha entrado al chat.',
	'chat-read-only' => 'El chat está temporalmente deshabilitado mientras el wiki está en modo de lectura.',
	'chat-user-parted' => '$1 ha salido del chat.',
	'chat-user-blocked' => '$1 ha bloqueado a $2.',
	'chat-user-allow' => '$1 ha permitido a $2.',
	'chat-user-permanently-disconnected' => 'Te has desconectado, comprueba tu conexión a internet y actualiza la ventana del navegador',
	'chat-inlinealert-a-made-b-chatmod' => '$1 ha hecho a <strong>$2</strong> un moderador del chat.',
	'chat-err-connected-from-another-browser' => 'Te has conectado de otro navegador. Esta conexión se cerrará.',
	'chat-err-communicating-with-mediawiki' => 'Error al comunicarse con el servidor MediaWiki.',
	'chat-ban-cant-ban-moderator' => 'No puedes expulsar/bloquear otro moderador del chat.',
	'chat-ban-already-banned' => '$1 ya está bloqueado del chat en este wiki.',
	'chat-ban-you-need-permission' => 'No tienes el permiso $1 que es requerido para expulsar/bloquear un usuario.',
	'chat-missing-required-parameter' => "'$1' es necesario pero no fue encontrado en la solicitud.",
	'chat-err-already-chatmod' => 'Error: "$1" ya está en el grupo "$2".',
	'chat-err-no-permission-to-add-chatmod' => 'Error: No tienes permiso para agregar el grupo $1 a este usuario.',
	'chat-userrightslog-a-made-b-chatmod' => '$1 promovió a $2 para ser moderador del chat en este wiki.',
	'chat-you-are-banned' => 'Error de permisos.',
	'chat-you-are-banned-text' => 'Lo sentimos, no tienes permiso para entrar al chat en esta wiki.
Si crees que ha sido un error o te gustaría reconsiderarlo, por favor contacta con un administrador.',
	'chat-room-is-not-on-this-wiki' => 'La sala de chat a la que estás tratando de entrar, parece no existir en este wiki.',
	'chat-kick-log-reason' => 'Expulsado y bloqueado del chat de esta wiki por $1.
Por favor, contáctalo para más información.',
	'chat-headline' => 'Chat de $1',
	'chat-live' => '¡En vivo!',
	'chat-start-a-chat' => 'Iniciar el Chat',
	'chat-whos-here' => 'Quién está aquí ($1)',
	'chat-join-the-chat' => 'Únete al Chat',
	'chat-edit-count' => '$1 ediciones',
	'chat-member-since' => 'Miembro desde $1',
	'chat-great-youre-logged-in' => '¡Genial! Has iniciado sesión.',
	'chat-user-menu-profile' => 'Perfil de Usuario',
	'chat-user-menu-contribs' => 'Contribuciones',
	'chat-user-menu-private' => 'Mensaje Privado',
	'chat-user-menu-give-chat-mod' => 'Dar estado de moderador',
	'chat-user-menu-private-block' => 'Bloquear mensajes privados',
	'chat-user-menu-private-allow' => 'Permitir mensajes privados',
	'chat-user-menu-private-close' => 'Cerrar sala privada',
	'chat-private-headline' => 'Chat privado con $1',
	'right-chatmoderator' => 'Puede banear y expulsar usuarios del [[Help:Chat|Chat]]',
	'group-chatmoderator' => 'Moderadores del chat',
	'group-chatmoderator-member' => 'Moderador del chat',
	'group-bannedfromchat' => 'Baneados del chat',
	'group-bannedfromchat-member' => 'Baneado del chat',
);

/** Finnish (Suomi)
 * @author Nike
 * @author VezonThunder
 */
$messages['fi'] = array(
	'chat' => 'Chat',
	'chat-desc' => '[[Special:Chat|Suora chat]]',
	'chat-no-login' => 'Chatin käyttö vaatii sisäänkirjautumisen.',
	'chat-no-login-text' => 'Ole hyvä ja kirjaudu sisään käyttääksesi chattia.',
	'chat-default-topic' => 'Tervetuloa {{GRAMMAR:genitive|$1}} chattiin',
	'chat-user-joined' => '$1 on liittynyt chattiin.',
	'chat-read-only' => 'Chat on tilapäisesti poissa käytöstä wikin ollessa vain luku -tilassa.',
	'chat-user-parted' => '$1 on poistunut chatista.',
	'chat-user-blocked' => '$1 on estänyt käyttäjän $2.',
	'chat-user-allow' => '$1 on sallinut käyttäjän $2.',
	'chat-user-permanently-disconnected' => 'Yhteys on katkaistu. Tarkista Internet-yhteytesi ja päivitä selainikkunasi.',
	'chat-inlinealert-a-made-b-chatmod' => '$1 on tehnyt käyttäjästä $2 chat-valvojan.',
	'chat-err-connected-from-another-browser' => 'Olet muodostanut yhteyden toisesta selaimesta. Tämä yhteys suljetaan.',
	'chat-err-communicating-with-mediawiki' => 'Virhe tiedonvälityksessä MediaWiki-palvelimen kanssa.',
	'chat-ban-cant-ban-moderator' => 'Et voi estää toista chat-valvojaa.',
	'chat-ban-already-banned' => '$1 on jo estetty tämän wikin chatissa.',
	'chat-ban-you-need-permission' => 'Sinulla ei ole käyttöoikeutta $1, joka vaaditaan käyttäjän estämiseen.',
	'chat-missing-required-parameter' => "'$1' vaaditaan, mutta se puuttui pyynnöstä.",
	'chat-err-already-chatmod' => 'Virhe: "$1" on jo ryhmässä "$2".',
	'chat-err-no-permission-to-add-chatmod' => 'Virhe: Sinulla ei ole oikeutta lisätä ryhmää "$1" tälle käyttäjälle.',
	'chat-userrightslog-a-made-b-chatmod' => '$1 ylensi käyttäjän $2 tämän wikin chat-valvojaksi.',
	'chat-you-are-banned' => 'Käyttöoikeusvirhe.',
	'chat-you-are-banned-text' => 'Valitettavasti sinulla ei ole oikeutta käyttää chattia tässä wikissä. Jos arvelet tämän johtuvan virheestä tai haluaisit, että oikeutta harkittaisiin uudelleen, ota yhteys ylläpitäjään.',
	'chat-room-is-not-on-this-wiki' => 'Chat-huone, johon yrität päästä, ei näytä olevan olemassa tässä wikissä.',
	'chat-kick-log-reason' => '$1 antoi sinulle chat-eston tässä wikissä. Ole hyvä ja ota yhteyttä häneen saadaksesi lisätietoa.',
	'chat-headline' => '{{GRAMMAR:genitive|$1}} chat',
	'chat-live' => 'Suorana!',
	'chat-start-a-chat' => 'Käynnistä chat',
	'chat-whos-here' => 'Läsnä ($1)',
	'chat-join-the-chat' => 'Liity chattiin',
	'chat-edit-count' => '{{PLURAL:$1|1 muokkaus|$1 muokkausta}}',
	'chat-member-since' => 'Liittynyt: $1',
	'chat-great-youre-logged-in' => 'Hienoa! Olet kirjautunut sisään.',
	'chat-user-menu-profile' => 'Käyttäjäprofiili',
	'chat-user-menu-contribs' => 'Muokkaukset',
	'chat-user-menu-private' => 'Yksityisviesti',
	'chat-user-menu-give-chat-mod' => 'Anna valvoja-asema',
	'chat-user-menu-private-block' => 'Estä yksityisviestit',
	'chat-user-menu-private-allow' => 'Salli yksityisviestit',
	'chat-user-menu-private-close' => 'Sulje yksityishuone',
	'chat-private-headline' => 'Yksityinen chat käyttäjän $1 kanssa',
	'right-chatmoderator' => 'Voi antaa käyttäjille [[Help:Chat|chat]]-estoja',
	'group-chatmoderator' => 'Chat-valvojat',
	'group-chatmoderator-member' => 'chat-valvoja',
	'group-bannedfromchat' => 'Estetty chatista',
	'group-bannedfromchat-member' => 'chatista estetty',
);

/** French (Français)
 * @author Gomoko
 * @author IAlex
 * @author McDutchie
 * @author Notafish
 * @author Od1n
 * @author Wyz
 */
$messages['fr'] = array(
	'chat' => 'Tchat',
	'chat-desc' => '[[Special:Chat|Tchater en direct]]',
	'chat-no-login' => 'Vous devez être connecté pour tchater.',
	'chat-no-login-text' => 'Veuillez vous connecter pour tchater.',
	'chat-default-topic' => 'Bienvenue sur le tchat de $1',
	'chat-user-joined' => '$1 a rejoint le tchat.',
	'chat-read-only' => 'La discussion est temporairement indisponible car le wiki est en mode lecture seule.',
	'chat-user-parted' => '$1 a quitté le tchat.',
	'chat-user-blocked' => '$1 a bloqué $2.',
	'chat-user-allow' => '$1 a autorisé $2.',
	'chat-user-permanently-disconnected' => 'Vous avez été déconnecté, vérifiez votre connexion Internet et rafraîchissez la fenêtre du navigateur',
	'chat-inlinealert-a-made-b-chatmod' => '$1 a promu <strong>$2</strong> au rang de modérateur du tchat.',
	'chat-err-connected-from-another-browser' => 'Vous vous êtes connecté depuis un autre navigateur. Cette connexion va être fermée.',
	'chat-err-communicating-with-mediawiki' => 'Une erreur est survenue lors de la communication avec le serveur MediaWiki.',
	'chat-ban-cant-ban-moderator' => 'Vous ne pouvez pas bannir un autre modérateur du tchat.',
	'chat-ban-already-banned' => '$1 est déjà banni du tchat sur ce wiki.',
	'chat-ban-you-need-permission' => 'Vous n’avez pas le droit $1, qui est nécessaire pour pouvoir bannir un utilisateur.',
	'chat-missing-required-parameter' => "'$1' est requis mais n’a pas été trouvé dans la requête.",
	'chat-err-already-chatmod' => 'Erreur : « $1 » est déjà dans le groupe « $2 ».',
	'chat-err-no-permission-to-add-chatmod' => "Erreur : Vous n'avez pas la permission d'ajouter cet utilisateur au groupe « $1 ».",
	'chat-userrightslog-a-made-b-chatmod' => '$1 a promu $2 au rang de modérateur du tchat sur ce wiki.',
	'chat-you-are-banned' => 'Erreur de permissions.',
	'chat-you-are-banned-text' => "Désolé, vous n'avez pas la permission de tchater sur ce wiki. Si vous pensez que c'est une erreur ou souhaitez en discuter, veuillez contacter un administrateur.",
	'chat-room-is-not-on-this-wiki' => 'Le salon de tchat auquel vous essayez de vous connecter ne semble pas exister sur ce wiki.',
	'chat-kick-log-reason' => 'Banni du tchat pour ce wiki par $1. Veuillez les contacter pour plus d’informations.',
	'chat-headline' => '$1 — Tchat',
	'chat-live' => 'En direct !',
	'chat-start-a-chat' => 'Démarrer une discussion',
	'chat-whos-here' => 'Qui est présent ($1)',
	'chat-join-the-chat' => 'Rejoindre la discussion',
	'chat-edit-count' => '$1 contributions',
	'chat-member-since' => 'Membre depuis $1',
	'chat-great-youre-logged-in' => 'Super ! Vous êtes connecté.',
	'chat-user-menu-profile' => 'Profil utilisateur',
	'chat-user-menu-contribs' => 'Contributions',
	'chat-user-menu-private' => 'Message privé',
	'chat-user-menu-give-chat-mod' => 'Donner le statut modérateur',
	'chat-user-menu-private-block' => 'Bloquer les messages privés',
	'chat-user-menu-private-allow' => 'Autoriser les messages privés',
	'chat-user-menu-private-close' => 'Fermer la discussion privée',
	'chat-private-headline' => 'Discussion privée avec $1',
	'right-chatmoderator' => 'Peut bannir des utilisateurs du [[Help:Chat|tchat]]',
	'group-chatmoderator' => 'Modérateurs du chat',
	'group-chatmoderator-member' => 'modérateur du tchat',
	'grouppage-chatmoderator' => 'w:c:aide:Aide:Tchat',
	'group-bannedfromchat' => 'Bannis du tchat',
	'group-bannedfromchat-member' => 'banni du tchat',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'chat' => 'Chat',
	'chat-desc' => '[[Special:Chat|Conversación en vivo]]',
	'chat-no-login' => 'Debe acceder ao sistema para chatear.',
	'chat-no-login-text' => 'Acceda ao sistema para chatear.',
	'chat-default-topic' => 'Benvido ao chat $1',
	'chat-user-joined' => '$1 uniuse ao chat.',
	'chat-read-only' => 'O chat non está dispoñible temporalmente debido a que o wiki está en modo de só lectura.',
	'chat-user-parted' => '$1 deixou a conversación.',
	'chat-user-blocked' => '$1 bloqueou a $2.',
	'chat-user-allow' => '$1 autorizou a $2.',
	'chat-user-permanently-disconnected' => 'Está desconectado; comprobe a súa conexión á internet e refresque a ventá do navegador',
	'chat-inlinealert-a-made-b-chatmod' => '$1 converteu a <strong>$2</strong> en moderador do chat.',
	'chat-err-connected-from-another-browser' => 'Conectouse desde outro navegador. Esta conexión vai pecharse.',
	'chat-err-communicating-with-mediawiki' => 'Erro na comunicación co servidor MediaWiki.',
	'chat-ban-cant-ban-moderator' => 'Non pode expulsar outro moderador do chat.',
	'chat-ban-already-banned' => '$1 xa foi expulsado do chat neste wiki.',
	'chat-ban-you-need-permission' => 'Non ten permisos de $1, necesarios para expulsar un usuario.',
	'chat-missing-required-parameter' => 'Cómpre "$1", pero non se atopou na solicitude.',
	'chat-err-already-chatmod' => 'Erro: "$1" xa está no grupo "$2".',
	'chat-err-no-permission-to-add-chatmod' => 'Erro: Non ten permisos para engadir este usuario ao grupo "$1".',
	'chat-userrightslog-a-made-b-chatmod' => '$1 fixo unha proposta para converter a $2 en moderador do chat neste wiki.',
	'chat-you-are-banned' => 'Erro de permisos.',
	'chat-you-are-banned-text' => 'Sentímolo, non ten os permisos necesarios para conversar neste wiki. Se cre que foi un erro ou quere que esta decisión sexa reconsiderada, póñase en contacto cun administrador.',
	'chat-room-is-not-on-this-wiki' => 'Semella que a sala de conversa á que intenta entrar non existe neste wiki.',
	'chat-kick-log-reason' => 'Expulsado do chat deste wiki por $1. Póñase en contacto con este usuario para obter máis información.',
	'chat-headline' => 'Chat $1',
	'chat-live' => 'En vivo!',
	'chat-start-a-chat' => 'Iniciar un chat',
	'chat-whos-here' => 'Quen está aquí ($1)',
	'chat-join-the-chat' => 'Únase ao chat',
	'chat-edit-count' => '$1 edicións',
	'chat-member-since' => 'Membro desde $1',
	'chat-great-youre-logged-in' => 'Ben! Está conectado.',
	'chat-user-menu-profile' => 'Perfil do usuario',
	'chat-user-menu-contribs' => 'Contribucións',
	'chat-user-menu-private' => 'Mensaxe privada',
	'chat-user-menu-give-chat-mod' => 'Dar os dereitos de moderador do chat',
	'chat-user-menu-private-block' => 'Bloquear as mensaxes privadas',
	'chat-user-menu-private-allow' => 'Permitir as mensaxes privadas',
	'chat-user-menu-private-close' => 'Pechar a sala privada',
	'chat-private-headline' => 'Conversa privada con $1',
	'right-chatmoderator' => 'Pode expulsar usuarios do [[Help:Chat|chat]]',
	'group-chatmoderator' => 'Moderadores do chat',
	'group-chatmoderator-member' => 'Moderador do chat',
	'group-bannedfromchat' => 'Expulsado do chat',
	'group-bannedfromchat-member' => 'Expulsado do chat',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Dj
 */
$messages['hu'] = array(
	'chat' => 'Csevegés',
	'chat-desc' => '[[Special:Chat|Élő csevegés]]',
	'chat-no-login' => 'A csevegéshez be kell jelentkezned!',
	'chat-no-login-text' => 'Jelentkezz be a csevegéshez!',
	'chat-default-topic' => 'Üdvözlünk a $1 csevegőben!',
	'chat-user-joined' => '$1belépett a csevegésbe.',
	'chat-read-only' => 'A csevegés ideiglenesen szünetel, amíg a wiki csak olvasható módban van.',
	'chat-user-parted' => '$1 kilépett a csevegésből.',
	'chat-user-blocked' => '$1letiltotta a  $2-t .',
	'chat-user-allow' => '$1 engedélyezte $2-t.',
	'chat-user-permanently-disconnected' => 'A kapcsolatod megszakadt. Ellenőrizd az internet kapcsolatodat és frissítsed a böngésző ablakot!',
	'chat-err-connected-from-another-browser' => 'Egy másik böngészőből csatlakoztál. Ez a kapcsolat meg fog szakadni.',
	'chat-err-communicating-with-mediawiki' => 'Hiba a MediaWiki-kiszolgálóval történő kommunikáció közben.',
	'chat-ban-cant-ban-moderator' => 'Nem tudsz kirúgni/kitiltani másik csevegő moderátort.',
	'chat-ban-already-banned' => '$1 már ki van tiltva a wiki csevegőjéből.',
	'chat-you-are-banned' => 'Engedélyezési hiba.',
	'chat-headline' => '$1-csevegő',
	'chat-live' => 'Élő!',
	'chat-start-a-chat' => 'Csevegő indítása',
	'chat-whos-here' => 'Ki van itt ($1)',
	'chat-join-the-chat' => 'Csatlakozás a csevegéshez',
	'chat-edit-count' => '$1 szerkesztés',
	'chat-member-since' => 'Tag $1 óta',
	'chat-great-youre-logged-in' => 'Nagyszerű! Bejelentkeztél.',
	'chat-user-menu-contribs' => 'Közreműködések',
	'chat-user-menu-private' => 'Privát üzenet',
	'chat-user-menu-private-block' => 'Privát üzenetek blokkolása',
	'chat-user-menu-private-allow' => 'Privát üzenetek engedélyezése',
	'chat-user-menu-private-close' => 'Privát szoba bezárása',
	'right-chatmoderator' => 'Kirúghat/kitilthat felhasználókat a [[Help:Chat|Csevegésből]]',
	'group-chatmoderator' => 'Csevegés moderátorok',
	'group-chatmoderator-member' => 'Csevegés moderátorok',
	'group-bannedfromchat' => 'Beszélgetésből kitiltva',
	'group-bannedfromchat-member' => 'Beszélgetésből kitiltva',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'chat' => 'Chat',
	'chat-desc' => '[[Special:Chat|Live chat]]',
	'chat-no-login' => 'Tu debe aperir un session pro poter chattar.',
	'chat-no-login-text' => 'Per favor aperi session pro chattar.',
	'chat-default-topic' => 'Benvenite al chat de $1',
	'chat-user-joined' => '$1 ha entrate in le chat.',
	'chat-read-only' => 'Le chat es temporarimente indisponibile durante que le wiki es in modo de lectura sol.',
	'chat-user-parted' => '$1 ha quitate le chat.',
	'chat-user-blocked' => '$1 ha blocate $2.',
	'chat-user-allow' => '$1 ha permittite $2.',
	'chat-user-permanently-disconnected' => 'Tu ha essite disconnectite. Verifica le connexion a internet e refresca le fenestra del navigator.',
	'chat-inlinealert-a-made-b-chatmod' => '$1 ha facite <strong>$2</strong> moderator del chat.',
	'chat-err-connected-from-another-browser' => 'Tu te ha connectite ab un altere navigator. Iste connexion essera claudite.',
	'chat-err-communicating-with-mediawiki' => 'Error durante le communication con le servitor MediaWiki.',
	'chat-ban-cant-ban-moderator' => 'Tu non pote ejectar/bannir un altere moderator del chat.',
	'chat-ban-already-banned' => '$1 es jam bannite del chat in iste wiki.',
	'chat-ban-you-need-permission' => 'Tu non ha le permission de $1 le qual es necessari pro poter ejectar/bannir un usator.',
	'chat-missing-required-parameter' => "'$1' es obligatori ma non esseva trovate in le requesta.",
	'chat-err-already-chatmod' => 'Error: "$1" es jam in le gruppo "$2".',
	'chat-err-no-permission-to-add-chatmod' => 'Error: Tu non ha le permission de adder iste usator al gruppo "$1".',
	'chat-userrightslog-a-made-b-chatmod' => '$1 ha promovite $2 a moderator del chat in iste wiki.',
	'chat-you-are-banned' => 'Error de permissiones.',
	'chat-you-are-banned-text' => 'Regrettabilemente, tu non ha le permission de entrar in le chat de iste wiki.
Si tu pensa que isto es un error o si tu vole esser reconsiderate, per favor contacta un administrator.',
	'chat-room-is-not-on-this-wiki' => 'Le canal de chat in le qual tu tenta entrar non pare exister in iste wiki.',
	'chat-kick-log-reason' => 'Expellite del chat de iste wiki per $1.
Per favor contacta le pro plus informationes.',
	'chat-headline' => 'Chat de $1',
	'chat-live' => 'In directo!',
	'chat-start-a-chat' => 'Comenciar un chat',
	'chat-whos-here' => 'Qui es presente ($1)',
	'chat-join-the-chat' => 'Entrar in le chat',
	'chat-edit-count' => 'Modificationes de $1',
	'chat-member-since' => 'Membro depost $1',
	'chat-great-youre-logged-in' => 'Genial! Tu ha aperite session.',
	'chat-user-menu-profile' => 'Profilo de usator',
	'chat-user-menu-contribs' => 'Contributiones',
	'chat-user-menu-private' => 'Message private',
	'chat-user-menu-give-chat-mod' => 'Dar stato de moderator',
	'chat-user-menu-private-block' => 'Blocar messages private',
	'chat-user-menu-private-allow' => 'Permitter messages private',
	'chat-user-menu-private-close' => 'Clauder sala private',
	'chat-private-headline' => 'Chat private con $1',
	'right-chatmoderator' => 'Pote ejectar/bannir usatores del [[Help:Chat|chat]]',
	'group-chatmoderator' => 'Moderatores del chat',
	'group-chatmoderator-member' => 'Moderator del chat',
	'group-bannedfromchat' => 'Bannite del chat',
	'group-bannedfromchat-member' => 'Bannite del chat',
);

/** Indonesian (Bahasa Indonesia)
 * @author Aldnonymous
 */
$messages['id'] = array(
	'chat-no-login' => 'Anda harus login untuk chatting.',
	'chat-no-login-text' => 'Silahkan login untuk chatting.',
	'chat-default-topic' => 'Selamat datang di $1 chatting',
	'chat-read-only' => 'Chat sementara tidak tersedia saat wiki berada pada mode baca-saja.',
	'chat-user-parted' => '$1 telah meninggalkan obrolan.',
	'chat-user-blocked' => '$1 telah memblokir  $2 .',
	'chat-user-allow' => '$1 telah memperbolehkan $2 .',
	'chat-user-permanently-disconnected' => 'Koneksi Anda terputus, periksa koneksi internet anda dan refresh jendela browser Anda',
	'chat-inlinealert-a-made-b-chatmod' => '$1telah <strong> $2 </strong> moderator chatting.',
	'chat-err-connected-from-another-browser' => 'Anda telah terhubung dari browser lain. Hubungan ini akan ditutup.',
	'chat-err-communicating-with-mediawiki' => 'Kesalahan terjadi saat terhubung dengan MediaWiki server.',
	'chat-ban-cant-ban-moderator' => 'Anda tidak bisa menendang/ban Moderator chatting yang lain.',
	'chat-ban-already-banned' => '$1sudah dilarang dari chatting di wiki ini.',
	'chat-ban-you-need-permission' => 'Anda tidak memiliki  $1  izin yang diperlukan untuk menendang/ban pengguna.',
);

/** Italian (Italiano)
 * @author Leviathan 89
 * @author Minerva Titani
 */
$messages['it'] = array(
	'chat-desc' => '[[Special:Chat|Chat dal vivo]]',
	'chat-no-login' => 'Devi effettuare il login per chattare.',
	'chat-no-login-text' => 'Per favore effettua il login per chattare.',
	'chat-default-topic' => 'Benvenuto nella chat di $1',
	'chat-user-joined' => '$1 è entrato nella chat.',
	'chat-read-only' => 'La chat è momentaneamente non disponibile mentre la wiki è in modalità solo lettura.',
	'chat-user-parted' => '$1 ha lasciato la chat.',
	'chat-user-blocked' => '$1 ha bloccato $2.',
	'chat-user-allow' => '$1 ha permesso $2.',
	'chat-user-permanently-disconnected' => 'Ti sei disconnesso, controlla la tua connessione Internet e ricarica la pagina',
	'chat-inlinealert-a-made-b-chatmod' => '$1 ha fatto <strong>$2</strong> un moderatore della chat.',
	'chat-err-connected-from-another-browser' => 'Ti sei connesso da un altro browser. Questa connessione verrà terminata.',
	'chat-err-communicating-with-mediawiki' => 'Errore di comunicazione con il server MediaWiki.',
	'chat-ban-cant-ban-moderator' => 'Non puoi bannare un altro moderatore della chat.',
	'chat-ban-already-banned' => '$1 è già stato bannato dalla chat di questa wiki.',
	'chat-ban-you-need-permission' => "Non hai l'autorizzazione $1 che è necessaria per bannare un utente.",
	'chat-missing-required-parameter' => '"$1" è necessario, ma non è stata trovato nella richiesta.',
	'chat-err-already-chatmod' => 'Errore: "$1" è già nel gruppo "$2".',
	'chat-err-no-permission-to-add-chatmod' => 'Errore: Non hai i permessi per aggiungere il gruppo "$1" a questo utente.',
	'chat-userrightslog-a-made-b-chatmod' => '$1 ha promosso $2 moderatore della chat di questa wiki.',
	'chat-you-are-banned' => 'Permessi non sufficienti.',
	'chat-you-are-banned-text' => "Siamo spiacenti, non hai l'autorizzazione ad accedere alla chat di questa wiki. Se ritieni che ci sia un errore o vuoi richiedere di essere riconsiderato, contatta un'amministratore.",
	'chat-room-is-not-on-this-wiki' => 'La chat a cui stai tentando di accedere sembra che non esista su questa wiki.',
	'chat-kick-log-reason' => 'Bannato dalla chat di questa wiki da $1. Per favore contattalo per maggiori informazioni.',
	'chat-headline' => 'Chat $1',
	'chat-live' => 'Live!',
	'chat-start-a-chat' => 'Inizia una Chat',
	'chat-whos-here' => "Chi c'è qui ($1)",
	'chat-join-the-chat' => 'Entra in Chat',
	'chat-edit-count' => '$1 modifiche',
	'chat-member-since' => 'Membro dal $1',
	'chat-great-youre-logged-in' => 'Fantastico! Ti sei connesso.',
	'chat-user-menu-profile' => 'Profilo utente',
	'chat-user-menu-contribs' => 'Contributi',
	'chat-user-menu-private' => 'Messaggio privato',
	'chat-user-menu-give-chat-mod' => 'Nomina Moderatore della Chat',
	'chat-user-menu-private-block' => 'Blocca messaggi privati',
	'chat-user-menu-private-allow' => 'Consenti messaggi privati',
	'chat-user-menu-private-close' => 'Chiudi Chat Privata',
	'chat-private-headline' => 'Chat privata con $1',
	'right-chatmoderator' => 'Può cacciare/bannare gli utenti della [[Help:Chat|Chat]]',
	'group-chatmoderator' => 'Moderatori della chat',
	'group-chatmoderator-member' => 'Moderatore chat',
	'group-bannedfromchat' => 'Bannati dalla chat',
	'group-bannedfromchat-member' => 'Bannato dalla chat',
);

/** Japanese (日本語)
 * @author Tommy6
 */
$messages['ja'] = array(
	'chat-desc' => '[[Special:Chat|ライブチャット]]',
	'chat-no-login' => 'ログインする必要があります。',
	'chat-no-login-text' => 'チャット機能を利用するにはログインする必要があります。',
	'chat-default-topic' => '「$1 チャット」にようこそ',
	'chat-user-joined' => '$1 がチャットに参加しました。',
	'chat-read-only' => 'ウィキが閲覧のみに制限されているためチャットは一時的に無効になっています。',
	'chat-user-parted' => '$1 がチャットから退席しました。',
	'chat-user-blocked' => '$1 が $2 をブロックしました。',
	'chat-user-allow' => '$1 が $2 に許可を与えました。',
	'chat-user-permanently-disconnected' => '切断されました。インターネット接続を確認し、ブラウザウィンドウを更新してください。',
	'chat-inlinealert-a-made-b-chatmod' => '$1 が <strong>$2</strong> をチャットモデレータにしました。',
	'chat-err-connected-from-another-browser' => '他のブラウザからの接続を確認しました。この接続は閉じられます。',
	'chat-err-communicating-with-mediawiki' => 'MediaWiki サーバとの通信でエラーが発生しました。',
	'chat-ban-cant-ban-moderator' => '他のチャットモデレータを強制退出させるあるいは追放することはできません。',
	'chat-ban-already-banned' => '$1 は既にこのウィキのチャットから追放されています。',
	'chat-ban-you-need-permission' => 'ユーザを強制退出させるあるいは追放するのに必要な$1権限がありません。',
	'chat-missing-required-parameter' => '「$1」が要求されましたがリクエストの中に見つかりませんでした。',
	'chat-err-already-chatmod' => 'エラー: 「$1」は既に「$2」グループの一員です。',
	'chat-err-no-permission-to-add-chatmod' => 'エラー: あなたにはこの利用者を「$1」グループに追加する権限がありません。',
	'chat-userrightslog-a-made-b-chatmod' => '$1 が $2 をこのウィキのチャットモデレータにしました。',
	'chat-you-are-banned' => '権限がありません',
	'chat-you-are-banned-text' => 'このウィキのチャット機能を利用する権限がありません。もし、これが誤りであるあるいは再考が必要であると考えるのであれば、管理者に連絡を取ってください。',
	'chat-room-is-not-on-this-wiki' => 'あなたが入ろうとしたチャットルームはこのウィキにはないようです。',
	'chat-kick-log-reason' => '$1 がこのウィキのチャットから強制退出あるいは追放しました。さらに詳しい情報については、実施者に問い合わせてください。',
	'chat-headline' => '$1 チャット',
	'chat-live' => 'Live!',
	'chat-start-a-chat' => 'チャットに参加',
	'chat-whos-here' => '現在いるユーザ ($1)',
	'chat-join-the-chat' => 'チャットに参加',
	'chat-edit-count' => '編集回数: $1',
	'chat-member-since' => '利用開始: $1',
	'chat-great-youre-logged-in' => 'ログインしました。',
	'chat-user-menu-profile' => '利用者情報',
	'chat-user-menu-contribs' => '投稿記録',
	'chat-user-menu-private' => 'プライベートメッセージ',
	'chat-user-menu-give-chat-mod' => 'モデレータにする',
	'chat-user-menu-private-block' => 'プライベートメッセージをブロックする',
	'chat-user-menu-private-allow' => 'プライベートメッセージを許可する',
	'chat-user-menu-private-close' => 'プライベートチャットを終了する',
	'chat-private-headline' => '$1 とのプライベートチャット',
	'right-chatmoderator' => '利用者を[[Help:Chat|チャット]]から追放する',
	'group-chatmoderator' => 'チャットモデレータ',
	'group-chatmoderator-member' => 'チャットモデレータ',
	'group-bannedfromchat' => 'チャットから追放された利用者',
	'group-bannedfromchat-member' => 'チャットから追放された利用者',
);

/** Khowar (کھوار)
 * @author Rachitrali
 */
$messages['khw'] = array(
	'chat-desc' => '[[Special:Chat|لایو چیٹنگ]]',
);

/** Korean (한국어)
 * @author Infinity
 */
$messages['ko'] = array(
	'chat-desc' => '[[Special:Chat|실시간 채팅]]',
	'chat-no-login' => '채팅을 하기 위해서는 로그인이 필요합니다.',
	'chat-no-login-text' => '채팅을 하기 위해서는 로그인이 필요합니다.',
	'chat-default-topic' => '$1 채팅에 오신 것을 환영합니다',
	'chat-ban-cant-ban-moderator' => '다른 채팅 운영자를 추방할 수 없습니다.',
	'chat-ban-already-banned' => '$1 사용자는 이미 추방되었습니다.',
	'chat-ban-you-need-permission' => '다른 사용자를 추방하기 위해서는 $1 권한이 필요합니다.',
	'chat-you-are-banned' => '권한 오류',
	'chat-you-are-banned-text' => '죄송합니다. 이 위키에서 채팅에 참여할 권한이 없습니다. 만약 이 사안이 관리자의 실수이거나 재검토가 필요하다고 생각하신다면 관리자에게 문의해주세요.',
	'chat-room-is-not-on-this-wiki' => '입장하려고 하는 채팅방이 이 위키에 없습니다.',
	'chat-kick-log-reason' => '$1에 의해 채팅에서 추방됨. 더 자세한 이유는 운영진에게 문의.',
	'chat-headline' => '$1 채팅',
	'chat-live' => '라이브!',
	'chat-start-a-chat' => '채팅 시작하기',
	'chat-whos-here' => '채팅중인 사용자 ($1)',
	'chat-join-the-chat' => '채팅 참가하기',
	'chat-edit-count' => '$1회 기여',
	'chat-member-since' => '$1부터 기여',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'chat-default-topic' => 'Wëllkomm am $1-Chat',
	'chat-user-blocked' => '$1 huet $2 gespaart.',
	'chat-you-are-banned' => 'Berechtigungs-Feeler',
	'chat-headline' => 'Chat: $1',
	'chat-edit-count' => '$1 Ännerungen',
	'chat-member-since' => 'Member zënter $1',
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 */
$messages['lt'] = array(
	'chat' => 'Pokalbiai',
	'chat-no-login' => 'Jus turite būti prisijungęs, kad galėtumėte kalbėti.',
	'chat-default-topic' => 'Sveiki atvykę į, $1 pokalbį',
	'chat-user-joined' => '$1 prisijungė prie pokalbio.',
	'chat-read-only' => 'Pokalbiai yra laikinai neprieinami, kol wiki yra tik skaitymo režimu.',
	'chat-user-parted' => '$1 paliko pokalbį.',
	'chat-user-blocked' => '$1 užblokavo  $2.',
	'chat-user-allow' => '$1 leido $2.',
	'chat-user-permanently-disconnected' => 'Buvote atjungtas, patikrinkite interneto ryšį ir atnaujinimo naršyklės langą',
	'chat-inlinealert-a-made-b-chatmod' => '$1 padarė <strong> $2 </strong> pokalbių moderatoriumi.',
	'chat-err-connected-from-another-browser' => 'Prisijungiate iš kitos naršyklės. Šis ryšys bus uždarytas.',
	'chat-err-communicating-with-mediawiki' => 'Klaida susisiekiant su MediaWiki serveriu.',
	'chat-ban-cant-ban-moderator' => 'Jūs negalite išmesti/užblokuoti kito Pokalbių Moderatoriaus.',
	'chat-ban-already-banned' => '$1 jau yra užblokuotas pokalbiuose šioje wiki.',
	'chat-ban-you-need-permission' => 'Jūs neturite $1 teisės kuri yra reikalinga vartotojo išmetimui/užblokavimui.',
	'chat-missing-required-parameter' => '"$1"  yra reikalingas bet nebuvo rastas prašyme.',
	'chat-err-already-chatmod' => 'Klaida: "$1" jau yra "$2" grupėje.',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'chat' => 'Разговори',
	'chat-desc' => '[[Special:Chat|Разговори во живо]]',
	'chat-no-login' => 'Мора да се најавени за да разговарате.',
	'chat-no-login-text' => 'Најавете се за да разговарате.',
	'chat-default-topic' => 'Добредојдовте на разговорот за $1',
	'chat-user-joined' => '$1 се приклучи на разговорот.',
	'chat-read-only' => 'Разговорите се привремено недостапни кога викито е во режимот „само читање“.',
	'chat-user-parted' => '$1 го напушти разговорот.',
	'chat-user-blocked' => '$1 го блокираше корисникот $2.',
	'chat-user-allow' => '$1 го прими корисникот $2.',
	'chat-user-permanently-disconnected' => 'Исклучени сте. Проверете си ја врската со интернет и превчитајте ја страницата во прелистувачот',
	'chat-inlinealert-a-made-b-chatmod' => '$1 го назначи корисникот <strong>$2</strong> за модератор на разговорите.',
	'chat-err-connected-from-another-browser' => 'Се поврзавте од друг прелистувач. Оваа врска ќе се затвори.',
	'chat-err-communicating-with-mediawiki' => 'Грешка при општењето со опслужувачот на МедијаВики.',
	'chat-ban-cant-ban-moderator' => 'Не можете да исфрлите/забраните пристап на друг модератор.',
	'chat-ban-already-banned' => 'На корисникот $1 веќе му е забранет пристапот до разговорот на ова вики.',
	'chat-ban-you-need-permission' => 'Ја немате дозволата за $1, што е потребна за исфрлање на корисници и забранување на пристап.',
	'chat-missing-required-parameter' => 'Се бара „$1“, но не пронајдов такво нешто.',
	'chat-err-already-chatmod' => 'Грешка: „$1“ веќе членува во групата „$2“.',
	'chat-err-no-permission-to-add-chatmod' => 'Грешка: Немате дозвола да ја додадете групата „$1“ кон овој корисник.',
	'chat-userrightslog-a-made-b-chatmod' => '$1 го унапреди корисникот $2 во модератор на разговорите на ова вики.',
	'chat-you-are-banned' => 'Грешка во дозволите.',
	'chat-you-are-banned-text' => 'Забрането ви е да разговарате на ова вики. Доколку сметате дека ова е направено по грешка или сакате да се преиспита одлуката, обратете се кај администратор.',
	'chat-room-is-not-on-this-wiki' => 'Собата за разговор што сакате да ја пристапите не постои на ова вики.',
	'chat-kick-log-reason' => 'Исфрлен од/има забранет пристап до разговорот на ова вики од страна на $1. За повеќе информации, обратете се кај тој корисник.',
	'chat-headline' => 'Разговор — $1',
	'chat-live' => 'Во живо!',
	'chat-start-a-chat' => 'Започнете разговор',
	'chat-whos-here' => 'Кој има тука ($1)',
	'chat-join-the-chat' => 'Приклучете се во разговорот',
	'chat-edit-count' => '$1 уредувања',
	'chat-member-since' => 'Членува од $1',
	'chat-great-youre-logged-in' => 'Одлично! Најавени сте.',
	'chat-user-menu-profile' => 'Кориснички профил',
	'chat-user-menu-contribs' => 'Придонеси',
	'chat-user-menu-private' => 'Приватна порака',
	'chat-user-menu-give-chat-mod' => 'Додели модераторски статус',
	'chat-user-menu-private-block' => 'Блокирај приватни пораки',
	'chat-user-menu-private-allow' => 'Дозволи приватни пораки',
	'chat-user-menu-private-close' => 'Затвори приватна соба',
	'chat-private-headline' => 'Приватен разговор со $1',
	'right-chatmoderator' => 'Може да исфрла/забранува корисници од [[Help:Chat|разговор]]',
	'group-chatmoderator' => 'Модератори на разговорот',
	'group-chatmoderator-member' => 'Модератор на разговорот',
	'grouppage-chatmoderator' => 'w:c:community:Help:Chat',
	'group-bannedfromchat' => 'Забранети во разговорот',
	'group-bannedfromchat-member' => 'Забранети во разговорот',
	'grouppage-bannedfromchat' => 'w:c:community:Help:Chat',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'chat-edit-count' => '$1 തിരുത്തലുകൾ',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'chat' => 'Sembang',
	'chat-desc' => '[[Special:Chat|Sembang secara langsung]]',
	'chat-no-login' => 'Anda mesti log masuk untuk bersembang',
	'chat-no-login-text' => 'Sila log masuk untuk bersembang',
	'chat-default-topic' => 'Selamat datang ke ruang sembang $1',
	'chat-user-joined' => '$1 telah memasuki ruang sembang.',
	'chat-read-only' => 'Laman Sembang tergendala buat sementara kerana wiki berada dalam mod baca sahaja.',
	'chat-user-parted' => '$1 telah meninggalkan ruang sembang.',
	'chat-user-blocked' => '$1 telah menyekat $2 .',
	'chat-user-allow' => '$1 telah membenarkan $2 .',
	'chat-user-permanently-disconnected' => 'Sambungan anda terputus; sila periksa sambungan Internet anda dan muat semula tetingkap pelayar',
	'chat-inlinealert-a-made-b-chatmod' => '$1 telah menjadikan <strong>$2</strong> seorang moderator sembang.',
	'chat-err-connected-from-another-browser' => 'Anda telah bersambung dari pelayar lain. Sambungan ini akan ditutup.',
	'chat-err-communicating-with-mediawiki' => 'Ralat ketika berhubung dengan pelayan MediaWiki.',
	'chat-ban-cant-ban-moderator' => 'Anda tidak boleh menghalau/melarang Penyelia Sembang yang lain.',
	'chat-ban-already-banned' => '$1 sudah dilarang daripada bersembang di wiki ini.',
	'chat-ban-you-need-permission' => 'Anda tidak mendapat kebenaran $1 yang diperlukan untuk menghalau/melarang pengguna.',
	'chat-missing-required-parameter' => "'$1' diperlukan tetapi tiada dalam permintaan.",
	'chat-err-already-chatmod' => 'Perhatian: "$1" sudah berada dalam kumpulan "$2".',
	'chat-err-no-permission-to-add-chatmod' => 'Perhatian: Anda tidak dibenarkan menambahkan kumpulan "$1" ke dalam pengguna ini.',
	'chat-userrightslog-a-made-b-chatmod' => '$1 menaik pangkat $2 untuk menjadi moderator sembang di wiki ini.',
	'chat-you-are-banned' => 'Ralat kebenaran.',
	'chat-you-are-banned-text' => 'Maaf, anda tidak dibenarkan untuk bersembang di wiki ini.
Jika anda rasa ini kesilapan atau ingin merayu untuk dibenarkan semula, sila hubungi pentadbir.',
	'chat-room-is-not-on-this-wiki' => 'Ruang sembang yang anda cuba masuk itu nampaknya tidak wujud di wiki ini.',
	'chat-kick-log-reason' => 'Dilarang daripada bersembang di wiki ini oleh $1.
Sila hubungi mereka untuk penjelasan lanjut.',
	'chat-headline' => 'Ruang Sembang $1',
	'chat-live' => 'Live!',
	'chat-start-a-chat' => 'Mula Bersembang',
	'chat-whos-here' => 'Siapa di sini ($1)',
	'chat-join-the-chat' => 'Jom Sembang',
	'chat-edit-count' => '$1 Suntingan',
	'chat-member-since' => 'Ahli sejak $1',
	'chat-great-youre-logged-in' => 'Bagus! Anda telah log masuk.',
	'chat-user-menu-profile' => 'Profil Pengguna',
	'chat-user-menu-contribs' => 'Sumbangan',
	'chat-user-menu-private' => 'Pesanan Peribadi',
	'chat-user-menu-give-chat-mod' => 'Berikan Status Penyelia Sembang',
	'chat-user-menu-private-block' => 'Sekat Pesanan Peribadi',
	'chat-user-menu-private-allow' => 'Benarkan Pesanan Peribadi',
	'chat-user-menu-private-close' => 'Tutup Bilik Peribadi',
	'chat-private-headline' => 'Sembang peribadi dengan $1',
	'right-chatmoderator' => 'Boleh mengusir/melarang pengguna daripada [[Help:Chat|bersembang]]',
	'group-chatmoderator' => 'Penyelia Sembang',
	'group-chatmoderator-member' => 'Penyelia Sembang',
	'grouppage-chatmoderator' => 'w:c:community:Help:Chat',
	'group-bannedfromchat' => 'DilarangBersembang',
	'group-bannedfromchat-member' => 'DilarangBersembang',
	'grouppage-bannedfromchat' => 'w:c:community:Help:Chat',
);

/** Norwegian Bokmål (Norsk (bokmål))
 * @author Audun
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'chat' => 'Chat',
	'chat-desc' => '[[Special:Chat|Chat]]',
	'chat-no-login' => 'Du må være logget inn for å chatte.',
	'chat-no-login-text' => 'Vennligst logg inn for å chatte.',
	'chat-default-topic' => 'Velkommen til $1-chatten',
	'chat-user-joined' => '$1 ble med i chatten.',
	'chat-read-only' => 'Nettprat er midlertidig utilgjengelig mens wikien er i skrivebeskyttet modus.',
	'chat-user-parted' => '$1 har forlatt chatten.',
	'chat-user-blocked' => '$1 har blokkert $2.',
	'chat-user-allow' => '$1 har tillatt $2.',
	'chat-user-permanently-disconnected' => 'Du har blitt koblet fra, sjekk Internett-tilkoblingen din og oppdater nettleservinduet',
	'chat-inlinealert-a-made-b-chatmod' => '$1 gjorde <strong>$2</strong> til en chat-moderator.',
	'chat-err-connected-from-another-browser' => 'Du har koblet til fra en annen nettleser. Denne tilkoblingen vil bli lukket.',
	'chat-err-communicating-with-mediawiki' => 'Feil under kommunikasjon med MediaWiki-tjeneren.',
	'chat-ban-cant-ban-moderator' => 'Du kan ikke sparke/utestenge en annen Chat-moderator.',
	'chat-ban-already-banned' => '$1 er allerede utestengt fra chatten på denne wikien.',
	'chat-ban-you-need-permission' => 'Du har ikke $1-tillatelsen som kreves for å sparke/utestenge en bruker.',
	'chat-missing-required-parameter' => '«$1» er påkrevd, men ble ikke funnet i forespørselen.',
	'chat-err-already-chatmod' => 'Feil: «$1» er allerede i gruppen «$2».',
	'chat-err-no-permission-to-add-chatmod' => 'Feil: Du har ikke tillatelse til å legge gruppen «$1» til denne brukeren.',
	'chat-userrightslog-a-made-b-chatmod' => '$1 forfremmet $2 til å være en chat-moderator på denne wikien.',
	'chat-you-are-banned' => 'Rettighetsfeil.',
	'chat-you-are-banned-text' => 'Beklager, du har ikke rett til å chatte på denne wikien. Hvis du tror dette er en feil, eller om du vil bli revurdert, vennligst kontakt en administrator.',
	'chat-room-is-not-on-this-wiki' => 'Chatrommet du forsøker å entre ser ikke ut til å eksistere på denne wikien.',
	'chat-kick-log-reason' => 'Sparket/utestengt fra chatten på denne wikien av $1.
Vennligst kontakt dem for mer informasjon.',
	'chat-headline' => '$1-chat',
	'chat-live' => 'Direkte!',
	'chat-start-a-chat' => 'Start en chat',
	'chat-whos-here' => 'Hvem er her ($1)',
	'chat-join-the-chat' => 'Bli med i chatten',
	'chat-edit-count' => '$1 redigeringer',
	'chat-member-since' => 'Medlem siden $1',
	'chat-great-youre-logged-in' => 'Flott! Du er logget inn.',
	'chat-user-menu-profile' => 'Brukerprofil',
	'chat-user-menu-contribs' => 'Bidrag',
	'chat-user-menu-private' => 'Privat melding',
	'chat-user-menu-give-chat-mod' => 'Gi ChatMod-status',
	'chat-user-menu-private-block' => 'Blokker private meldinger',
	'chat-user-menu-private-allow' => 'Tillat private meldinger',
	'chat-user-menu-private-close' => 'Lukk privatrommet',
	'chat-private-headline' => 'Privat chat med $1',
	'right-chatmoderator' => 'Kan sparke/utestengte brukere fra [[Help:Chat|chatten]]',
	'group-chatmoderator' => 'Chat-moderatorer',
	'group-chatmoderator-member' => 'Chat-moderator',
	'grouppage-chatmoderator' => 'w:c:community:Help:Chat',
	'group-bannedfromchat' => 'UtestengtFraChat',
	'group-bannedfromchat-member' => 'UtestengtFraChat',
	'grouppage-bannedfromchat' => 'w:c:community:Help:Chat',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 * @author Tjcool007
 */
$messages['nl'] = array(
	'chat' => 'Chatten',
	'chat-desc' => '[[Special:Chat|Livechat]]',
	'chat-no-login' => 'U moet aangemeld zijn om deel te nemen aan de chat.',
	'chat-no-login-text' => 'Meld u aan om deel te nemen aan de chat.',
	'chat-default-topic' => 'Welkom bij de chat van $1',
	'chat-user-joined' => '$1 neemt nu deel aan de chat.',
	'chat-read-only' => 'Chatten is tijdelijk niet mogelijk omdat de wiki alleen-lezen is.',
	'chat-user-parted' => '$1 heeft de chat verlaten.',
	'chat-user-blocked' => '$1 heeft $2 geblokkeerd.',
	'chat-user-allow' => '$1 heeft $2 gedeblokkeerd.',
	'chat-user-permanently-disconnected' => 'U hebt niet langer een verbinding. Controleer uw internetverbinding en ververs de inhoud van uw webbrowser.',
	'chat-inlinealert-a-made-b-chatmod' => '$1 heeft <strong>$2</strong> chatmoderator gemaakt.',
	'chat-err-connected-from-another-browser' => 'U bent verbonden via een andere browser. Deze verbinding wordt nu gesloten.',
	'chat-err-communicating-with-mediawiki' => 'Er is een fout opgetreden in de verbinding met de MediaWiki-server.',
	'chat-ban-cant-ban-moderator' => 'U kunt een andere chatmoderator niet kicken of verbannen.',
	'chat-ban-already-banned' => '$1 is al verbannen uit de chat voor deze wiki.',
	'chat-ban-you-need-permission' => 'U hebt het recht "$1" niet, wat nodig is om een gebruiker te kicken of te verbannen.',
	'chat-missing-required-parameter' => '"$1" is vereist, maar is niet aangetroffen in het verzoek.',
	'chat-err-already-chatmod' => 'Fout: "$1" is al in de groep "$2".',
	'chat-err-no-permission-to-add-chatmod' => 'Fout: U hebt geen toestemming om de groep "$1" aan deze gebruiker toe te voegen.',
	'chat-userrightslog-a-made-b-chatmod' => '$1 heeft $2 gepromoveerd tot chatmoderator op deze wiki.',
	'chat-you-are-banned' => 'Fouten in rechten.',
	'chat-you-are-banned-text' => 'U mag niet langer deelnemen aan de chat. Als u denkt dat dit niet klopt, of als u wilt vragen uw blokkade op te heffen, neem dan contact op met een beheerder.',
	'chat-room-is-not-on-this-wiki' => 'De chatroom waar u probeert binnen te komen bestaat niet op deze wiki.',
	'chat-kick-log-reason' => 'De toegang tot de chat voor deze wiki is u ontzegd door $1.
Neem alstublieft contact op met deze gebruiker voor meer informatie.',
	'chat-headline' => 'Chat voor $1',
	'chat-live' => 'Live!',
	'chat-start-a-chat' => 'Chat starten',
	'chat-whos-here' => 'Wie is er ($1)',
	'chat-join-the-chat' => 'Deelnemen aan de chat',
	'chat-edit-count' => '$1 bewerkingen',
	'chat-member-since' => 'Lid sinds $1',
	'chat-great-youre-logged-in' => 'Geweldig! U bent aangemeld.',
	'chat-user-menu-profile' => 'Gebruikersprofiel',
	'chat-user-menu-contribs' => 'Bijdragen',
	'chat-user-menu-private' => 'Privébericht',
	'chat-user-menu-give-chat-mod' => 'Status van chatmoderator weergeven',
	'chat-user-menu-private-block' => 'Privéberichten blokkeren.',
	'chat-user-menu-private-allow' => 'Privéberichten toestaan.',
	'chat-user-menu-private-close' => 'Privéruimte sluiten',
	'chat-private-headline' => 'Privechat met $1',
	'right-chatmoderator' => 'Kan gebruikers verwijderen en verbannen uit de [[Help:Chat|Chat]]',
	'group-chatmoderator' => 'Chatmoderatoren',
	'group-chatmoderator-member' => 'Chatmoderator',
	'group-bannedfromchat' => 'Verbannen uit chat',
	'group-bannedfromchat-member' => 'Verbannen uit chat',
);

/** Nederlands (informeel) (Nederlands (informeel))
 * @author Siebrand
 */
$messages['nl-informal'] = array(
	'chat-no-login' => 'Je moet aangemeld zijn om deel te nemen aan de chat',
	'chat-no-login-text' => 'Meld je aan om deel te nemen aan de chat.',
	'chat-ban-cant-ban-moderator' => 'Je kunt een andere chatmoderator niet kicken of verbannen.',
	'chat-ban-you-need-permission' => 'Je hebt het recht "$1" niet wat nodig is om een gebruiker te kicken of te verbannen.',
	'chat-you-are-banned-text' => 'Je mag niet langer deelnemen aan de chat. Als je denkt dat dit niet klopt, of als je wilt vragen uw blokkade op te heffen, neem dan contact op met een beheerder.',
	'chat-room-is-not-on-this-wiki' => 'De chatroom waar je probeert binnen te komen bestaat niet op deze wiki.',
);

/** Polish (Polski)
 * @author Anoon6
 * @author Cloudissimo
 * @author Nandy
 * @author Sovq
 * @author Sp5uhe
 * @author Woytecr
 */
$messages['pl'] = array(
	'chat' => 'Czat',
	'chat-desc' => '[[Special:Chat|Czat na żywo]]',
	'chat-no-login' => 'Musisz być zalogowany, żeby korzystać z czatu.',
	'chat-no-login-text' => 'Zaloguj się, żeby korzystać z czatu.',
	'chat-default-topic' => 'Witaj na czacie $1',
	'chat-user-joined' => '$1 dołączył na czat.',
	'chat-read-only' => 'Czat jest niedostępny ponieważ wiki jest w trybie tylko do odczytu.',
	'chat-private-messages' => 'Prywatne Wiadomości',
	'chat-user-parted' => '$1 opuścił czat.',
	'chat-user-blocked' => '$1 zablokował $2.',
	'chat-user-allow' => '$1 pozwolił $2',
	'chat-user-permanently-disconnected' => 'Rozłączono, sprawdź swoje połączenie z Internetem i odśwież okno przeglądarki',
	'chat-inlinealert-a-made-b-chatmod' => '$1 upowarznił <strong>$2</strong> moderatorem czatu.',
	'chat-err-connected-from-another-browser' => 'Połączyłeś się z innej przeglądarki. To połączenie zostanie zamknięte.',
	'chat-err-communicating-with-mediawiki' => 'Wystąpił błąd podczas komunikacji z serwerem MediaWiki.',
	'chat-ban-cant-ban-moderator' => 'Nie możesz wyrzucić/zablokować innego moderatora czatu.',
	'chat-ban-already-banned' => '$1 nie ma już dostępu do czatu na tej wiki.',
	'chat-ban-you-need-permission' => 'Nie masz $1 uprawnienia, które upoważnia do wyrzucania/blokowania użytkowników na czacie.',
	'chat-missing-required-parameter' => '$1 jest wymagane ale nie może zostać znalezione w żądaniu.',
	'chat-err-already-chatmod' => 'Błąd: "$1" jest już w "$2" grupie.',
	'chat-err-no-permission-to-add-chatmod' => 'Błąd: Nie masz uprawnień do dodawania "$1" grupy do tego użytkownika.',
	'chat-userrightslog-a-made-b-chatmod' => '$1 awansował $2 na moderatora czatu tej wiki.',
	'chat-you-are-banned' => 'Błąd uprawnień.',
	'chat-you-are-banned-text' => 'Niestety, nie masz uprawnień do korzystania z czatu na tej wiki. Jeśli uważasz, że wynikło to z powodu błędu lub powinno być ponownie rozpatrzone, skontaktuj się z administratorem.',
	'chat-room-is-not-on-this-wiki' => 'Chatroom, do którego próbujesz dołączyć wydaje się nie istnieć na tej wiki.',
	'chat-kick-log-reason' => 'Wyrzucony z czatu przez $1. Prosimy o kontakt z nimi w celu uzyskania dalszych informacji.',
	'chat-headline' => '$1 Czat',
	'chat-live' => 'Na żywo!',
	'chat-start-a-chat' => 'Rozpocznij czat',
	'chat-whos-here' => 'Obecnych ($1)',
	'chat-join-the-chat' => 'Dołącz do czatu',
	'chat-edit-count' => '$1 edycji',
	'chat-member-since' => 'Użytkownik od $1',
	'chat-great-youre-logged-in' => 'Świetnie! Jesteś zalogowany',
	'chat-user-menu-profile' => 'Profil użytkownika',
	'chat-user-menu-contribs' => 'Wkład użytkownika',
	'chat-user-menu-private' => 'Prywatna wiadomość',
	'chat-user-menu-give-chat-mod' => 'Nadaj status moderatora',
	'chat-user-menu-private-block' => 'Zablokuj prywatne wiadomości',
	'chat-user-menu-private-allow' => 'Zezwól na prywatne wiadomości',
	'chat-user-menu-private-close' => 'Zamknij prywatny pokój',
	'chat-private-headline' => 'Prywatna rozmowa z $1',
	'right-chatmoderator' => 'Może wyrzucać i banować użytkowników [[Help:Chat|czatu]]',
	'group-chatmoderator' => 'Moderatorzy czatu',
	'group-chatmoderator-member' => 'Moderator czatu',
	'group-bannedfromchat' => 'Zablokowany na czacie',
	'group-bannedfromchat-member' => 'Zablokowany na czacie',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'chat-headline' => '$1 بانډار',
	'chat-live' => 'ژوندی!',
	'chat-start-a-chat' => 'بانډار پيلول',
	'chat-edit-count' => '$1 سمونونه',
	'chat-user-menu-contribs' => 'ونډې',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'chat-desc' => '[[Special:Chat|Conversação ao vivo]]',
	'chat-no-login' => 'Para conversar tem de autenticar-se.',
	'chat-no-login-text' => 'Autentique-se para conversar, por favor.',
	'chat-default-topic' => 'Bem-vindo(a) à sala de conversação $1',
	'chat-user-joined' => '$1 entrou.',
	'chat-user-parted' => '$1 saiu.',
	'chat-user-blocked' => '$1 bloqueou $2.',
	'chat-user-allow' => '$1 permitiu $2.',
	'chat-inlinealert-a-made-b-chatmod' => '$1 tornou <strong>$2</strong> moderador.',
	'chat-err-connected-from-another-browser' => 'Ligou-se a partir de outro browser. Esta ligação será fechada.',
	'chat-err-communicating-with-mediawiki' => 'Erro de comunicação com o servidor do MediaWiki.',
	'chat-ban-cant-ban-moderator' => 'Não pode expulsar nem bloquear outro moderador.',
	'chat-ban-already-banned' => '$1 já está bloqueado da conversação nesta wiki.',
	'chat-ban-you-need-permission' => 'Não tem a permissão $1, que é necessária para expulsar ou bloquear utilizadores.',
	'chat-missing-required-parameter' => "'$1' é obrigatório mas não foi encontrado no pedido.",
	'chat-err-already-chatmod' => 'Erro: "$1" já está no grupo "$2".',
	'chat-err-no-permission-to-add-chatmod' => 'Erro: Não tem permissões para colocar este utilizador no grupo "$1".',
	'chat-userrightslog-a-made-b-chatmod' => '$1 promoveu $2 a moderador de conversação nesta wiki.',
	'chat-you-are-banned' => 'Erro de permissões.',
	'chat-you-are-banned-text' => 'Desculpe, mas não tem permissões para usar a sala de conversação nesta wiki. Se acredita que a falta de permissões resulta de um erro ou pretende que o assunto seja reconsiderado, contacte um administrador, por favor.',
	'chat-room-is-not-on-this-wiki' => 'A sala de conversação onde está tentando entrar não parece existir nesta wiki.',
	'chat-kick-log-reason' => 'Banido da sala de conversação desta wiki por $1. Contacte o utilizador para mais informações.',
	'chat-headline' => 'Sala de conversação da $1',
	'chat-live' => 'Ao vivo!',
	'chat-start-a-chat' => 'Iniciar uma conversa',
	'chat-whos-here' => 'Participantes ($1)',
	'chat-join-the-chat' => 'Entrar na sala',
	'chat-edit-count' => '$1 Edições',
	'chat-member-since' => 'Membro desde $1',
	'chat-great-youre-logged-in' => 'Óptimo! Está ligado.',
	'chat-user-menu-profile' => 'Perfil do Utilizador',
	'chat-user-menu-contribs' => 'Contribuições',
	'chat-user-menu-private' => 'Mensagem Privada',
	'chat-user-menu-give-chat-mod' => 'Dar Estatuto de Moderador',
	'chat-user-menu-private-block' => 'Bloquear Mensagens Privadas',
	'chat-user-menu-private-allow' => 'Permitir Mensagens Privadas',
	'chat-user-menu-private-close' => 'Fechar Sala Privada',
	'chat-private-headline' => 'Conversa privada com $1',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Aristóbulo
 * @author Pedroca cerebral
 */
$messages['pt-br'] = array(
	'chat-desc' => '[[Special:Chat|Bate-Papo]]',
	'chat-no-login' => 'Você precisa estar logado no bate-papo',
	'chat-no-login-text' => 'Por favor faça o login para o bate-papo.',
	'chat-default-topic' => 'Bem-vindo ao $1 bate-papo',
	'chat-user-joined' => '$1 entrou no chat.',
	'chat-read-only' => 'O chat está temporariamente indisponível porque a wiki está em modo de leitura.',
	'chat-user-parted' => '$1 saiu do chat.',
	'chat-user-blocked' => '$1 bloqueou $2.',
	'chat-user-allow' => '$1 permitiu $2.',
	'chat-user-permanently-disconnected' => 'Você está desconectado. Verifique sua conexão com a internet e atualize a janela de seu navegador',
	'chat-inlinealert-a-made-b-chatmod' => '$1 tornou <strong>$2</strong> moderador do chat.',
	'chat-err-connected-from-another-browser' => 'Ligou-se a partir de outro browser. Esta ligação será fechada.',
	'chat-err-communicating-with-mediawiki' => 'Erro de comunicação com o servidor do MediaWiki.',
	'chat-ban-cant-ban-moderator' => 'Você não pode expulsar nem bloquear outro moderador.',
	'chat-ban-already-banned' => '$1 já está bloqueado da conversação nesta wiki.',
	'chat-ban-you-need-permission' => 'Não tem a permissão $1, que é necessária para expulsar ou bloquear utilizadores.',
	'chat-missing-required-parameter' => "' $1 'é necessário, mas não foi encontrado no pedido.",
	'chat-err-already-chatmod' => 'Erro: "$1" já está no grupo "$2".',
	'chat-err-no-permission-to-add-chatmod' => 'Erro: Não tem permissões para colocar este utilizador no grupo "$1".',
	'chat-userrightslog-a-made-b-chatmod' => '$1 promoveu $2 a moderador de conversação nesta wiki.',
	'chat-you-are-banned' => 'Erro de permissões.',
	'chat-you-are-banned-text' => 'Desculpe, mas você não tem permissões para usar a sala de conversação nesta wiki. Se acredita que a falta de permissões resulta de um erro ou pretende que o assunto seja reconsiderado, contate um administrador, por favor.',
	'chat-room-is-not-on-this-wiki' => 'A sala de conversação onde você está tentando entrar não parece existir nesta wiki.',
	'chat-kick-log-reason' => 'Banido da sala de conversação desta wiki por $1. Contate o usuário para mais detalhes.',
	'chat-headline' => 'Chat da $1',
	'chat-live' => 'Ao vivo!',
	'chat-start-a-chat' => 'Iniciar uma conversa',
	'chat-whos-here' => 'Participantes ($1)',
	'chat-join-the-chat' => 'Entrar no Chat',
	'chat-edit-count' => '$1 edições',
	'chat-member-since' => 'Membro desde $1',
	'chat-great-youre-logged-in' => 'Ótimo! Está conectado.',
	'chat-user-menu-profile' => 'Perfil do usuário',
	'chat-user-menu-contribs' => 'Contribuições',
	'chat-user-menu-private' => 'Mensagem privada',
	'chat-user-menu-give-chat-mod' => 'Dar estatuto de Moderador',
	'chat-user-menu-private-block' => 'Bloquear mensagens privadas',
	'chat-user-menu-private-allow' => 'Permitir mensagens privadas',
	'chat-user-menu-private-close' => 'Fechar sala privada',
);

/** Romanian (Română)
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'chat-desc' => '[[Special:Chat|Chat live]]',
	'chat-no-login' => 'Trebuie să fii autentificat pentru a intra pe chat.',
	'chat-no-login-text' => 'Te rugăm autentifică-te pentru a intra pe chat.',
	'chat-start-a-chat' => 'Porneşte un chat',
	'chat-whos-here' => 'Cine-i aici ($1)',
	'chat-join-the-chat' => 'Alăturaţi-vă chat-ului',
	'chat-member-since' => 'Membru din $1',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'chat' => 'Ciat',
	'chat-desc' => "[[Special:Chat|Ciat da 'u vive]]",
	'chat-headline' => '$1 Ciat',
	'chat-edit-count' => '$1 Cangiaminde',
	'group-bannedfromchat' => "Mise fore da 'a ciat",
	'group-bannedfromchat-member' => "Mise fore da 'a ciat",
);

/** Russian (Русский)
 * @author Kuzura
 */
$messages['ru'] = array(
	'chat' => 'Чат',
	'chat-desc' => '[[Special:Chat|Чат]]',
	'chat-no-login' => 'Вы должны быть зарегистрированы, чтобы войти в чат',
	'chat-no-login-text' => 'Пожалуйста, войдите в чат.',
	'chat-default-topic' => 'Добро пожаловать в $1 чат',
	'chat-user-joined' => '$1 присоединился к чату',
	'chat-read-only' => 'Чат временно недоступен, так как вики находится в режиме только для чтения.',
	'chat-user-parted' => '$1 покинул чат.',
	'chat-user-blocked' => '$1 заблокировал $2.',
	'chat-user-allow' => '$1 допустил $2.',
	'chat-user-permanently-disconnected' => 'Вы были отключены; проверьте своё подключение к Интернету и перезагрузите окно браузера.',
	'chat-inlinealert-a-made-b-chatmod' => '$1 сделал <strong>$2</strong> модератором чата.',
	'chat-err-connected-from-another-browser' => 'Вы подключены из другого браузера. Это соединение будет закрыто.',
	'chat-err-communicating-with-mediawiki' => 'Ошибка связи с сервером MediaWiki.',
	'chat-ban-cant-ban-moderator' => 'Вы не можете забанить другого модератора чата.',
	'chat-ban-already-banned' => '$1 уже запрещён вход в чат на этой вики.',
	'chat-ban-you-need-permission' => 'У вас нет статуса $1, который необходим, чтобы забанить участника.',
	'chat-missing-required-parameter' => "'$1' требуется, но не был найден в запросе.",
	'chat-err-already-chatmod' => 'Ошибка: "$1" уже находится в группе "$2".',
	'chat-err-no-permission-to-add-chatmod' => 'Ошибка: у вас нет разрешения на добавление к группе "$1" этого участника.',
	'chat-userrightslog-a-made-b-chatmod' => '$1 присвоил $2 статус модератора чата на этой вики.',
	'chat-you-are-banned' => 'Ошибка доступа.',
	'chat-you-are-banned-text' => 'Извините, у вас нет доступа в чат на этой вики. Если вы думаете, что произошла ошибка или хотели бы, чтобы бан был пересмотрен, пожалуйста, свяжитесь с администратором вики.',
	'chat-room-is-not-on-this-wiki' => 'Чат, в который вы пытаетесь войти, вероятно, не существует на этой вики.',
	'chat-kick-log-reason' => '$1 запретил чат на этой вики. Пожалуйста, свяжитесь с ним для получения дополнительной информации.',
	'chat-headline' => '$1 Чат',
	'chat-live' => 'Live!',
	'chat-start-a-chat' => 'Начать чат',
	'chat-whos-here' => 'Кто находится здесь ($1)',
	'chat-join-the-chat' => 'Присоединиться к чату',
	'chat-edit-count' => '$1 правок',
	'chat-member-since' => 'Участник с $1',
	'chat-great-youre-logged-in' => 'Отлично! Вы вошли в систему.',
	'chat-user-menu-profile' => 'Профиль участника',
	'chat-user-menu-contribs' => 'Вклад',
	'chat-user-menu-private' => 'Личное сообщение',
	'chat-user-menu-give-chat-mod' => 'Дать статус модератора',
	'chat-user-menu-private-block' => 'Заблокировать личные сообщения',
	'chat-user-menu-private-allow' => 'Разрешить личные сообщения',
	'chat-user-menu-private-close' => 'Закрыть отдельную комнату',
	'chat-private-headline' => 'Отдельный чат с $1',
	'right-chatmoderator' => 'Как забанить участника в [[Help:Chat|чате]]',
	'group-chatmoderator' => 'Модераторы чата',
	'group-chatmoderator-member' => 'Модератор чата',
	'group-bannedfromchat' => 'Забанен в чате',
	'group-bannedfromchat-member' => 'Забанен в чате',
);

/** Serbian (Cyrillic script) (Српски (ћирилица))
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'chat-desc' => '[[Special:Chat|Ћаскање]]',
	'chat-no-login' => 'Морате бити пријављени да бисте ћаскали.',
	'chat-no-login-text' => 'Пријавите се да бисте ћаскали.',
	'chat-default-topic' => 'Добро дошли на ћасање $1',
	'chat-you-are-banned' => 'Грешка у дозволама.',
	'chat-you-are-banned-text' => 'Немате дозволу да ћаскате на овом викију. Ако мислите да је ово грешка или желите да се одлука преиспита, обратите се администратору.',
	'chat-kick-log-reason' => 'Избачени сте са ћаскања од стране {{GENDER:$1|корисника|кориснице|корисника}} $1.
Контактирајте га да бисте сазнали зашто сте избачени.',
	'grouppage-chatmoderator' => 'w:c:community:Help:Chat',
	'grouppage-bannedfromchat' => 'w:c:community:Help:Chat',
);

/** Swedish (Svenska)
 * @author Lokal Profil
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'chat' => 'Chatt',
	'chat-desc' => '[[Special:Chat|Live-chatt]]',
	'chat-no-login' => 'Du måste vara inloggad för att chatta.',
	'chat-no-login-text' => 'Var god logga in för att chatta.',
	'chat-default-topic' => 'Välkommen till $1-chatten',
	'chat-user-joined' => '$1 har gått med i chatten.',
	'chat-read-only' => 'Chatten är för tillfället inte tillgänglig medan wikin är i skrivskyddat läge.',
	'chat-user-parted' => '$1 har lämnat chatten.',
	'chat-user-blocked' => '$1 har blockerat $2 .',
	'chat-user-allow' => '$1 har tillåtit $2 .',
	'chat-user-permanently-disconnected' => 'Du har kopplats från, kontrollera internetanslutningen och uppdatera webbläsarfönstret',
	'chat-inlinealert-a-made-b-chatmod' => '$1 har gjort <strong>$2</strong> till en chattmoderator.',
	'chat-err-connected-from-another-browser' => 'Du har anslutit från en annan webbläsare. Denna anslutning kommer att stängas.',
	'chat-err-communicating-with-mediawiki' => 'Fel uppstod vid kommunikation med MediaWiki-servern.',
	'chat-ban-cant-ban-moderator' => 'Du kan inte sparka/stänga av en annan chattmoderator.',
	'chat-ban-already-banned' => '$1 är redan avstängd från chatten på denna wiki.',
	'chat-ban-you-need-permission' => 'Du har inte $1-behörighet som krävs för att sparka/stänga av en användare.',
	'chat-missing-required-parameter' => "'$1' krävs, men hittades inte i begäran.",
	'chat-err-already-chatmod' => 'Fel: "$1" är redan i gruppen "$2".',
	'chat-err-no-permission-to-add-chatmod' => 'Fel: Du har inte behörighet att lägga till gruppen "$1" till den här användaren.',
	'chat-userrightslog-a-made-b-chatmod' => '$1 befordrade $2 att vara en chattmoderator på denna wiki.',
	'chat-you-are-banned' => 'Behörighetsfel.',
	'chat-you-are-banned-text' => 'Tyvärr har du inte behörighet att chatta på denna wiki. Om du tror att detta var ett misstag eller vill bli omprövad, var god kontakta en administratör.',
	'chat-room-is-not-on-this-wiki' => 'Chattrummet du försöker gå in på verkar inte finnas på denna wiki.',
	'chat-kick-log-reason' => 'Utsparkad/avstängd från chatten för den här wikin av $1. Kontakta dem för mer information.',
	'chat-headline' => '$1-chatt',
	'chat-live' => 'Live!',
	'chat-start-a-chat' => 'Starta en chatt',
	'chat-whos-here' => 'Vem är här ($1)',
	'chat-join-the-chat' => 'Delta i chatten',
	'chat-edit-count' => '$1 redigeringar',
	'chat-member-since' => 'Medlem sedan $1',
	'chat-great-youre-logged-in' => 'Toppen! Du är inloggad.',
	'chat-user-menu-profile' => 'Användarprofil',
	'chat-user-menu-contribs' => 'Bidrag',
	'chat-user-menu-private' => 'Privat meddelande',
	'chat-user-menu-give-chat-mod' => 'Ge ChatMod-status',
	'chat-user-menu-private-block' => 'Blockera privata meddelanden',
	'chat-user-menu-private-allow' => 'Tillåt privata meddelanden',
	'chat-user-menu-private-close' => 'Stäng privatrummet',
	'chat-private-headline' => 'Privat chatt med $1',
	'right-chatmoderator' => 'Kan sparka ut/stänga av användare från [[Help:Chat|chatten]]',
	'group-chatmoderator' => 'Chattmoderatorer',
	'group-chatmoderator-member' => 'Chattmoderator',
	'group-bannedfromchat' => 'AvstängdFrånChatt',
	'group-bannedfromchat-member' => 'AvstängdFrånChatt',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'chat-member-since' => '$1 నుండి సభ్యులు',
);

/** Thai (ไทย)
 * @author Akkhaporn
 */
$messages['th'] = array(
	'chat-desc' => '[[Special:Chat|Live chat]]',
	'chat-no-login' => 'คุณต้องล็อกอินในการสนทนา',
	'chat-no-login-text' => 'กรุณาเข้าสู่ระบบเพื่อสนทนา',
	'chat-default-topic' => 'ยินดีต้อนรับ $1 สู่ห้องสนทนา',
	'chat-user-parted' => '$1 ได้ออกจากห้องสนทนา',
	'chat-inlinealert-a-made-b-chatmod' => '$1 ได้แต่งตั้ง <strong>$2</strong> เป็นผู้ดูแลห้องสนทนา',
	'chat-err-connected-from-another-browser' => 'คุณได้มีเชื่อมต่อจากเบราเซอร์อื่น การเชื่อมต่อนี้จะถูกปิด',
	'chat-err-communicating-with-mediawiki' => 'มีข้อผิดพลาดในการสื่อสารกับเซิร์ฟเวอร์ของมีเดียวิกิ',
	'chat-ban-cant-ban-moderator' => 'คุณไม่สามารถ เตะ/แบน ผผู้ดูแลห้องสนทนาคนอื่น',
	'chat-ban-already-banned' => '$1 ถูกแบนแล้วจากห้องสนทนาวิกิ',
	'chat-ban-you-need-permission' => 'คุณไม่มีสิทธิ์ $1 ซึ่งจะต้องการไป เตะ/แบน ผู้ใช้',
	'chat-missing-required-parameter' => "'$1' เป็นสิ่งจำเป็น แต่ไม่พบในการร้องขอ",
	'chat-err-already-chatmod' => 'ผิดพลาด: "$1" มีอยู่แล้วในกลุ่ม "$2"',
	'chat-err-no-permission-to-add-chatmod' => 'ผิดพลาด: คุณไม่ได้รับสิทธิ์ในการเพิ่มกลุ่ม "$1" ไปยังผู้ใช้รายนี้',
	'chat-userrightslog-a-made-b-chatmod' => '$1 เลื่อนขั้น $2 เป็นผู้ดูแลห้องสนทนาวิกิ',
	'chat-you-are-banned' => 'ข้อผิดพลาดในการใช้สิทธิ์',
	'chat-you-are-banned-text' => 'ขออภัย, คุณไม่ได้รับสิทธิ์ในการใช้ห้องสนทนาวิกินี้. ถ้าคุณคิดว่านี่เป็นความผิดพลาดหรือต้องการที่จะได้รับการพิจารณา, กรุณาติดต่อผู้ดูแลระบบ',
	'chat-room-is-not-on-this-wiki' => 'ในห้องสนทนาที่คุณกำลังพยายามที่จะป้อนจะไม่ปรากฏอยู่ในวิกินี้',
	'chat-kick-log-reason' => 'เตะ/แบน จากห้องสนทนาวิกิโดย $1. กรุณาติดต่อพวกเขาสำหรับข้อมูล',
	'chat-headline' => '$1 พูดว่า',
	'chat-live' => 'สด!',
	'chat-start-a-chat' => 'เริ่มต้นสนทนา',
	'chat-whos-here' => 'ออนไลน์ ($1)',
	'chat-join-the-chat' => 'เข้าร่วมสนทนา',
	'chat-edit-count' => '$1 การแก้ไข',
	'chat-member-since' => 'เป็นสมาชิกตั้งแต่ $1',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'chat-desc' => '[[Special:Chat|Buhay na satsatan]]',
	'chat-no-login' => 'Dapat kang nakalagda upang makapagsatsatan',
	'chat-no-login-text' => 'Mangyaring lumagda upang makapagsatsatan.',
	'chat-default-topic' => 'Maligayang pagdating sa satsatang $1',
	'chat-you-are-banned' => 'Kamalian sa mga kapahintulutan.',
	'chat-you-are-banned-text' => 'Paumanhin, wala kang pahintulot na makipagsatsatan sa wiking ito.
Kung iniisip mong isa itong pagkakamali o nais mong muling maisaalang-alang, mangyaring makipag-ugnayan sa isang tagapangasiwa.',
	'chat-kick-log-reason' => 'Sinipa/pinagbawala mula sa satsatan para sa wiking ito ni $1.
Mangyaring makipag-ugnayan sa kanila para sa mas maraming kabatiran.',
	'chat-headline' => '$1 Satsatan',
	'chat-live' => 'Buhay!',
	'chat-start-a-chat' => 'Magsimula ng isang Satsatan',
	'chat-whos-here' => 'Sino ang narito ($1)',
	'chat-join-the-chat' => 'Sumali sa Satsatan',
	'chat-edit-count' => '$1 Mga pamamatnugot',
	'chat-member-since' => 'Kasapi magmula pa noong $1',
);

/** Veps (Vepsän kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'chat' => 'Čat',
	'chat-start-a-chat' => 'Zavottä čat',
	'group-chatmoderator' => 'Čatan moderatorad',
	'group-chatmoderator-member' => 'Čatan moderator',
);

/** Vietnamese (Tiếng Việt)
 * @author Xiao Qiao
 * @author XiaoQiaoGrace
 */
$messages['vi'] = array(
	'chat' => 'Tán gẫu',
	'chat-desc' => '[[Special:Chat|Tán gẫu trực tuyến]]',
	'chat-no-login' => 'Bạn phải đăng nhập để tán gẫu.',
	'chat-no-login-text' => 'Vui lòng đăng nhập để tán gẫu.',
	'chat-default-topic' => 'Chào mừng đến với tán gẫu $1',
	'chat-user-joined' => '$1 đã tham gia tán gẫu.',
	'chat-read-only' => 'Tán gẫu tạm thời không được áp dụng trong khi wiki đang ở chế độ chỉ-đọc.',
	'chat-user-parted' => '$1 đã rời khỏi cuộc tán gẫu.',
	'chat-user-blocked' => '$1 đã cấm $2.',
	'chat-user-allow' => '$1 đã cho phép $2.',
	'chat-user-permanently-disconnected' => 'Bạn đã bị ngắt kết nối, hãy kiểm tra kết nối Internet của bạn và làm mới cửa sổ trình duyệt',
	'chat-inlinealert-a-made-b-chatmod' => '$1 đã phong cấp cho <strong>$2</strong> thành điều phối viên tán gẫu.',
	'chat-err-connected-from-another-browser' => 'Bạn đã kết nối từ một trình duyệt khác. Kết nối này sẽ bị đóng.',
	'chat-err-communicating-with-mediawiki' => 'Lỗi giao tiếp với hệ thống MediaWiki.',
	'chat-ban-cant-ban-moderator' => 'Bạn không thể tống/cấm Điều phối viên Tán gẫu.',
	'chat-ban-already-banned' => '$1 đã bị cấm tán gẫu trên wiki này.',
	'chat-ban-you-need-permission' => 'Bạn không có quyền $1 để yêu cầu tống/cấm một thành viên.',
	'chat-missing-required-parameter' => "'$1' là bắt buộc, nhưng không được tìm thấy trong yêu cầu.",
	'chat-err-already-chatmod' => 'Lỗi: "$1" đã nằm trong nhóm "$2".',
	'chat-err-no-permission-to-add-chatmod' => 'Lỗi: Bạn không có quyền cấp nhóm "$1" cho thành viên này.',
	'chat-userrightslog-a-made-b-chatmod' => '$1 đã phong cấp cho $2 thành điều phối viên tán gẫu tại wiki này.',
	'chat-you-are-banned' => 'Lỗi về quyền.',
	'chat-you-are-banned-text' => 'Xin lỗi, bạn không được phép tán gẫu trên wiki này. Nếu bạn nghĩ rằng đây là một sai lầm hoặc muốn được xem xét lại, xin vui lòng liên hệ với một bảo quản viên.',
	'chat-room-is-not-on-this-wiki' => 'Phòng tán gẫu bạn đang cố gắng nhập vào có vẻ không tồn tại trên wiki này.',
	'chat-kick-log-reason' => 'Bị tống/cấm từ tán gẫu trong wiki này bởi $1. Xin liên hệ họ để có thông tin.',
	'chat-headline' => 'Tán gẫu $1',
	'chat-live' => 'Trực tuyến!',
	'chat-start-a-chat' => 'Bắt đầu cuộc Tán gẫu',
	'chat-whos-here' => 'Ai đang ở đây ($1)',
	'chat-join-the-chat' => 'Tham gia Tán gẫu',
	'chat-edit-count' => '$1 Sửa đổi',
	'chat-member-since' => 'Thành viên từ $1',
	'chat-great-youre-logged-in' => 'Tuyệt! Bạn đã đăng nhập.',
	'chat-user-menu-profile' => 'Thông tin Thành viên',
	'chat-user-menu-contribs' => 'Đóng góp',
	'chat-user-menu-private' => 'Tin nhắn riêng',
	'chat-user-menu-give-chat-mod' => 'Phong cấp Điều phối Tán gẫu',
	'chat-user-menu-private-block' => 'Đóng tin nhắn riêng',
	'chat-user-menu-private-allow' => 'Mở tin nhắn riêng',
	'chat-user-menu-private-close' => 'Đóng phòng tán gẫu riêng',
	'chat-private-headline' => 'Tán gẫu riêng với $1',
	'right-chatmoderator' => 'Có thể tống/cấm thành viên từ [[Help:Chat|Tán gẫu]]',
	'group-chatmoderator' => 'Điều phối viên Tán gẫu',
	'group-chatmoderator-member' => 'Điều phối viên Tán gẫu',
	'group-bannedfromchat' => 'Bị cấm tán gẫu',
	'group-bannedfromchat-member' => 'Bị cấm tán gẫu',
);

/** Simplified Chinese (中文(简体))
 * @author Liangent
 * @author Yanmiao liu
 */
$messages['zh-hans'] = array(
	'chat' => '聊天',
	'chat-desc' => '[[Special:Chat|在线聊天]]',
	'chat-no-login' => '您必须登录以聊天。',
	'chat-no-login-text' => '请登录以聊天。',
	'chat-default-topic' => '欢迎来到$1聊天',
	'chat-user-joined' => '$1 已经加入聊天。',
	'chat-read-only' => '维基是只读模式，聊天暂时不可用。',
	'chat-user-parted' => '$1 已经离开聊天。',
	'chat-user-blocked' => '$1 已经屏蔽了 $2。',
	'chat-user-allow' => '$1 已经允许了 $2。',
	'chat-user-permanently-disconnected' => '您已经断开，检查网络连接并刷新浏览器窗口',
	'chat-inlinealert-a-made-b-chatmod' => '$1 升级 <strong>$2</strong> 为聊天主持人。',
	'chat-err-connected-from-another-browser' => '您已从另一个浏览器连接。此连接将被关闭。',
	'chat-err-communicating-with-mediawiki' => '与 MediaWiki 服务器通讯出错。',
	'chat-ban-cant-ban-moderator' => '您不能踢出另一个聊天主持人。',
	'chat-ban-already-banned' => '$1 已经在此维基的聊天中被禁止。',
	'chat-ban-you-need-permission' => '您没有 $1 权限，这是要踢出用户必需的。',
	'chat-missing-required-parameter' => "'$1' 是必需的，但在请求中未找到。",
	'chat-err-already-chatmod' => '错误："$1" 已经在 "$2" 组。',
	'chat-err-no-permission-to-add-chatmod' => '错误：您不具备给此用户添加 "$1" 组的权限。',
	'chat-userrightslog-a-made-b-chatmod' => '$1 推举 $2 为本维基上的聊天主持人。',
	'chat-you-are-banned' => '权限错误。',
	'chat-you-are-banned-text' => '对不起，您没有权限在本维基上聊天。如果您觉得这是一个错误，或想重新考虑，请联系管理员。',
	'chat-room-is-not-on-this-wiki' => '您正试图进入的聊天室似乎在本维基上并不存在。',
	'chat-kick-log-reason' => '已经从维基聊天中被 $1 踢出/禁止。更多信息，请联系他们。',
	'chat-headline' => '$1聊天',
	'chat-live' => '在线！',
	'chat-start-a-chat' => '开始聊天',
	'chat-whos-here' => '谁在这里（$1）',
	'chat-join-the-chat' => '加入聊天',
	'chat-edit-count' => '$1次编辑',
	'chat-member-since' => '$1以来的成员',
	'chat-great-youre-logged-in' => '太棒了！您已登录。',
	'chat-user-menu-profile' => '用户资料',
	'chat-user-menu-contribs' => '贡献',
	'chat-user-menu-private' => '悄悄话',
	'chat-user-menu-give-chat-mod' => '给聊天主持人状态',
	'chat-user-menu-private-block' => '屏蔽悄悄话',
	'chat-user-menu-private-allow' => '允许悄悄话',
	'chat-user-menu-private-close' => '关闭私有房间',
	'chat-private-headline' => '与 $1 私聊',
	'right-chatmoderator' => '能从[[Help:Chat|聊天]]中踢出用户',
	'group-chatmoderator' => '聊天主持人',
	'group-chatmoderator-member' => '聊天主持人',
	'group-bannedfromchat' => '从聊天中禁止',
	'group-bannedfromchat-member' => '从聊天中禁止',
);

