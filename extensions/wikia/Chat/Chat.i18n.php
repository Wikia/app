<?php

$messages = array();

$messages['en'] = array(
	'chat-desc' => '[[Special:Chat|Live chat]]',
	'chat-no-login' => 'You must be logged in to chat.',
	'chat-no-login-text' => 'Please login to chat.',
	'chat-default-topic' => 'Welcome to the $1 chat',

	// Possible errors when trying to kick/ban a user:
	'chat-ban-cant-ban-moderator' => "You cannot kick/ban another Chat Moderator.",
	'chat-ban-already-banned' => '$1 is already banned from chat on this wiki.',
	'chat-ban-you-need-permission' => 'You do not have the $1 permission which is required to kick/ban a user.',
	'chat-ban-requires-usertoban-parameter' => '\'$1\' is required but was not found in the request.',

	'chat-you-are-banned' => 'Permissions error.',
	// TODO: link to list of admins
	'chat-you-are-banned-text' => 'Sorry, you do not have permission to chat on this wiki.  If you think this was a mistake or would like to be reconsidered, please contact an administrator.',
	'chat-room-is-not-on-this-wiki' => 'The chat room you are attempting to enter does not appear to exist on this wiki.',
	'chat-kick-log-reason' => 'Kick/banned from the chat for this wiki by $1. Please contact them for more info.',
	'chat-headline' => '$1 Chat',
	'chat-live' => 'Live!',
	'chat-start-a-chat' => 'Start a Chat',
	'chat-whos-here' => "Who's here ($1)",
	'chat-join-the-chat' => 'Join the Chat',
	'chat-edit-count' => '$1 Edits',
	'chat-member-since' => 'Member since $1'
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'chat-no-login-text' => 'Meld asseblief aan om te klets.',
);

/** Asturian (Asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'chat-desc' => '[[Special:Chat|Charra en vivu]]',
	'chat-no-login' => 'Has de tar coneutáu pa charrar',
	'chat-no-login-text' => 'Por favor, conéutate pa charrar.',
	'chat-default-topic' => 'Bienveníu a la charra $1',
	'chat-you-are-banned' => 'Lo siento, tas espulsáu de la charra',
	'chat-you-are-banned-text' => "Tas espulsáu de la charra.
Si pienses que fue por error o quies que se reconsidere, ponte'n contautu con un alministrador.",
	'chat-kick-log-reason' => "Espulsáu/torgáu na charra d'esta wiki por $1.
Ponte'n contautu con ellos pa más info.",
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'chat-desc' => '[[Special:Chat|Flapiñ war-eeun]]',
	'chat-no-login' => "Ret eo deoc'h bezañ kevreet evit flapiñ",
	'chat-no-login-text' => 'Kevreit evit gallout flapiñ.',
	'chat-default-topic' => 'Degemer mat er flap $1',
	'chat-you-are-banned' => "Ho tigarez, berzet eo bet ar flap ouzhoc'h",
	'chat-you-are-banned-text' => "Berzet eo bet ar flap ouzhoc'h.
Ma soñj deoc'h ez eo dre fazi pe mar fell deoc'h e vefe distroet war an diviz e c'hallit mont e darempred gant ur merour.",
	'chat-kick-log-reason' => "Skarzhet eus ar flap er wiki-mañ gant $1.
Kit e darempred ganto da c'houzout hiroc'h.",
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

/** German (Deutsch)
 * @author LWChris
 */
$messages['de'] = array(
	'chat-desc' => '[[Special:Chat|Live-Chat]]',
	'chat-no-login' => 'Du musst angemeldet sein, um zu chatten',
	'chat-no-login-text' => 'Bitte anmelden, um zu chatten.',
	'chat-default-topic' => 'Willkommen im $1 Chat',
	'chat-you-are-banned' => 'Sorry, du wurdest aus dem Chat gebannt',
	'chat-you-are-banned-text' => 'Du wurdest aus dem Chat gebannt.
Wenn du dies für einen Fehler hältst oder möchtest, dass die Entscheidung überdacht wird, wende dich bitte an einen Administrator.',
	'chat-kick-log-reason' => 'Rauswurf/Bann aus dem Chat für dieses Wiki durch $1.
Bitte kontaktiere sie für weitere Informationen.',
);

/** Spanish (Español)
 * @author VegaDark
 */
$messages['es'] = array(
	'chat-desc' => '[[Special:Chat|Chat en vivo]]',
	'chat-no-login' => 'Debes iniciar sesión para chatear.',
	'chat-no-login-text' => 'Inicia sesión para chatear.',
	'chat-default-topic' => 'Bienvenido al chat de $1',
	'chat-you-are-banned' => 'Lo siento, estás bloqueado del chat',
	'chat-you-are-banned-text' => 'Has sido bloqueado del chat.
Si crees que ha sido un error o te gustaría reconsiderarlo, por favor contacta con un administrador.',
	'chat-kick-log-reason' => 'Expulsado y bloqueado del chat de esta wiki por $1.
Por favor, contáctalo para más información.',
);

/** French (Français)
 * @author Wyz
 */
$messages['fr'] = array(
	'chat-desc' => '[[Special:Chat|Tchater en direct]]',
	'chat-no-login' => 'Vous devez être connecté pour tchater',
	'chat-no-login-text' => 'Veuillez vous connecter pour tchater.',
	'chat-default-topic' => 'Bienvenue sur le tchat de $1',
	'chat-you-are-banned' => 'Désolé, vous êtes banni du tchat',
	'chat-you-are-banned-text' => "Vous avez été interdit de tchat.
Si vous pensez que c'est une erreur ou souhaitez en discuter, veuillez contacter un administrateur.",
	'chat-kick-log-reason' => 'Éjecté/Banni du tchat pour ce wiki par $1.
Veuillez les contacter pour plus d’informations.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'chat-desc' => '[[Special:Chat|Conversation in directo]]',
	'chat-no-login' => 'Tu debe aperir un session pro poter chattar.',
	'chat-no-login-text' => 'Per favor aperi session pro chattar.',
	'chat-default-topic' => 'Benvenite al chat de $1',
	'chat-ban-cant-ban-moderator' => 'Tu non pote ejectar/bannir un altere moderator del chat.',
	'chat-ban-already-banned' => '$1 es jam bannite del chat in iste wiki.',
	'chat-ban-you-need-permission' => 'Tu non ha le permission de $1 le qual es necessari pro poter ejectar/bannir un usator.',
	'chat-ban-requires-usertoban-parameter' => "'$1' es obligatori ma non esseva trovate in le requesta.",
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
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'chat-default-topic' => 'Wëllkomm am $1-Chat',
	'chat-you-are-banned' => 'Pardon, Dir sidd am Chat gespaart.',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'chat-desc' => '[[Special:Chat|Разговори во живо]]',
	'chat-no-login' => 'Мора да се најавени за да разговарате',
	'chat-no-login-text' => 'Најавете се за да разговарате.',
	'chat-default-topic' => 'Добредојдовте на разговорот за $1',
	'chat-you-are-banned' => 'Нажалост, забрането ви е да разговарате',
	'chat-you-are-banned-text' => 'Забрането ви е да разговарате.
Ако сметате дека ова е направено по грешка или сакате да се преиспита одлуката, обратете се кај администратор.',
	'chat-kick-log-reason' => 'Исфрлен/забранет од разговорот на ова вики од страна на $1.
За повеќе информации, обратете се кај тој корисник.',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'chat-desc' => '[[Special:Chat|Sembang secara langsung]]',
	'chat-no-login' => 'Anda mesti log masuk untuk bersembang',
	'chat-no-login-text' => 'Sila log masuk untuk bersembang',
	'chat-default-topic' => 'Selamat datang ke ruang sembang $1',
	'chat-you-are-banned' => 'Maaf, anda dilarang bersembang',
	'chat-you-are-banned-text' => 'Anda dilarang bersembang.
Jika anda rasa ini kesilapan atau ingin merayu untuk dibenarkan semula, sila hubungi pentadbir.',
	'chat-kick-log-reason' => 'Dilarang daripada bersembang di wiki ini oleh $1.
Sila hubungi mereka untuk penjelasan lanjut.',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'chat-desc' => '[[Special:Chat|Livechat]]',
	'chat-no-login' => 'U moet aangemeld zijn om deel te nemen aan de chat',
	'chat-no-login-text' => 'Meld u aan om deel te nemen aan de chat.',
	'chat-default-topic' => 'Welkom bij de chat van $1',
	'chat-ban-cant-ban-moderator' => 'U kunt een andere chatmoderator niet kicken of verbannen.',
	'chat-ban-already-banned' => '$1 is al verbannen uit de chat voor deze wiki.',
	'chat-ban-you-need-permission' => 'U hebt het recht "$1" niet wat nodig is om een gebruiker te kicken of te verbannen.',
	'chat-ban-requires-usertoban-parameter' => '"$1" is vereist, maar is niet aangetroffen in het verzoek.',
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
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 */
$messages['no'] = array(
	'chat-desc' => '[[Special:Chat|Chat]]',
	'chat-no-login' => 'Du må være logget inn for å chatte',
	'chat-no-login-text' => 'Vennligst logg inn for å chatte.',
	'chat-default-topic' => 'Velkommen til $1-chatten',
	'chat-you-are-banned' => 'Beklager, du er utestengt fra chatten',
	'chat-you-are-banned-text' => 'Du har blitt utestengt fra chatten.
Hvis du tror dette er en feil, eller om du vil bli revurdert, vennligst kontakt en administrator.',
	'chat-kick-log-reason' => 'Sparket/utestengt fra chatten på denne wikien av $1.
Vennligst kontakt dem for mer informasjon.',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'chat-desc' => '[[Special:Chat|Conversação ao vivo]]',
	'chat-no-login' => 'Para conversar tem de autenticar-se',
	'chat-no-login-text' => 'Autentique-se para conversar, por favor.',
	'chat-default-topic' => 'Bem-vindo(a) à conversa $1',
	'chat-you-are-banned' => 'Desculpe, foi banido da conversação',
	'chat-you-are-banned-text' => 'Foi banido da conversação. Se acho que isto foi um erro ou pretende que o seu banimento seja reconsiderado contacte um administrador.',
	'chat-kick-log-reason' => 'Banido da conversação desta wiki por $1.
Contacte este utilizador para mais informações.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Aristóbulo
 */
$messages['pt-br'] = array(
	'chat-desc' => '[[Special:Chat|Bate-Papo]]',
	'chat-no-login' => 'Você precisa estar logado no bate-papo',
	'chat-no-login-text' => 'Por favor faça o login para o bate-papo.',
	'chat-default-topic' => 'Bem-vindo ao $1 bate-papo',
	'chat-you-are-banned' => 'Desculpe, você está banido do chat',
	'chat-you-are-banned-text' => 'Você foi banido do chat.
Se você acha que isso foi um erro ou gostaria de ser reconsiderado(a), por favor entre em contato com um administrador.',
);

/** Serbian Cyrillic ekavian (‪Српски (ћирилица)‬)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'chat-desc' => '[[Special:Chat|Ћаскање]]',
	'chat-no-login' => 'Морате бити пријављени да бисте ћаскали.',
	'chat-no-login-text' => 'Пријавите се да бисте ћаскали.',
	'chat-default-topic' => 'Добро дошли на ћасање $1',
	'chat-you-are-banned' => 'Забрањен вам је приступ ћаскању.',
	'chat-you-are-banned-text' => 'Забрањен вам је приступ ћаскању.
Ако мислите да је ово грешка, контактирајте администратора.',
	'chat-kick-log-reason' => 'Избачени сте са ћаскања од стране {{GENDER:$1|корисника|кориснице|корисника}} $1.
Контактирајте га да бисте сазнали зашто сте избачени.',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'chat-desc' => '[[Special:Chat|Buhay na satsatan]]',
	'chat-no-login' => 'Dapat kang nakalagda upang makapagsatsatan',
	'chat-no-login-text' => 'Mangyaring lumagda upang makapagsatsatan.',
	'chat-default-topic' => 'Maligayang pagdating sa satsatang $1',
	'chat-you-are-banned' => 'Paumanhin, pinagbabawalan kang makipagsatsatan',
	'chat-you-are-banned-text' => 'Pinagbawalan kang makipagsatsatan.
Kung iniisip mong isa itong pagkakamali o nais mong muling maisaalang-alang, mangyaring makipag-ugnayan sa tagapangasiwa.',
	'chat-kick-log-reason' => 'Sinipa/pinagbawala mula sa satsatan para sa wiking ito ni $1.
Mangyaring makipag-ugnayan sa kanila para sa mas maraming kabatiran.',
);

