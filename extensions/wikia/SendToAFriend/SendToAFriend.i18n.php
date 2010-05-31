<?php

$messages = array();

$messages['en'] = array(
	'invitespecialpage'        => 'Invite friends to join Wikia',	//the name displayed on Special:SpecialPages
	'sendtoafriend-desc'       => '[[Special:InviteSpecialPage|Invite friends to join Wikia]]',
	'sendtoafriend-button-desc' => 'Displays a "Send to a friend" button in pages',
	'stf_button'               => 'Send this article to a friend',
	'stf_after_reg'            => '[[Special:InviteSpecialPage|Invite a friend to join Wikia!]]',
	'stf_subject'              => '$2 has sent you an article from $1!',
	'stf_confirm'              => 'Message sent! Invite others?',
	'stf_error'                => 'Error sending e-mail.',
	'stf_error_name'           => 'You didn\'t provide your name.',
	'stf_error_from'           => 'You didn\'t provide your e-mail address.',
	'stf_error_to'             => 'You didn\'t provide your friend\'s e-mail address.',
	'stf_frm1'                 => 'Your e-mail address:',
	'stf_frm2'                 => 'E-mail addresses (More than one? Separate with commas)',
	'stf_msg_label'            => 'Message to be sent',
	'stf_name_label'           => 'Your name',
	'stf_email_label'          => 'Your e-mail address',
	'stf_frm3_send'            => "Hi!\n\n\$1 thought you'd like this page from Wikia!\n\n$2\n\nCome check it out!",
	'stf_frm3_invite'          => "Hi!\n\nI just joined this wiki at Wikia...  \$1\n\nCome check it out!",
	'stf_frm4_send'            => 'Send',
	'stf_frm4_cancel'          => 'Cancel',
	'stf_frm4_invite'          => 'Send invite!',
	'stf_multiemail'           => 'Send to more than one recipient?',
	'stf_frm5'                 => '(the URL of this site will be appended to your message)',
	'stf_frm6'                 => 'Close this window',
	'stf_throttle'             => 'For security reasons, you can only send $1 {{PLURAL:$1|invite|invites}} a day.',
	'stf_abuse'                => "This e-mail was sent by $1 via Wikia.\nIf you think this was sent in error, please let us know at support@wikia.com.",
	'stf_ctx_invite'           => 'More than one? Separate with commas - up to $1!',
	'stf_ctx_check'            => 'Check contacts',
	'stf_ctx_empty'            => 'You have no contacts in this account.',
	'stf_ctx_invalid'          => 'Login or password you typed is invalid. Please try again.',
	'stf_sending'	           => 'Please wait...',
	'stf_email_sent'           => 'Send confirmation',
	'stf_back_to_article'      => 'Back to article',
	'stf_most_emailed'         => 'Most e-mailed articles on $1 today:',
	'stf_most_popular'         => 'Most popular articles on $1:',
	'stf_choose_from_existing' => 'Choose from your existing contacts:',
	'stf_add_emails'           => 'Add e-mail addresses:',
	'stf_your_email'           => 'Your e-mail service',
	'stf_your_login'           => 'Your login name',
	'stf_your_password'        => 'Your password',
	'stf_your_name'            => 'Your name',
	'stf_your_address'         => 'Your e-mail address',
	'stf_your_friends'         => 'Your friend\'s|e-mail addresses',
	'stf_we_dont_keep'         => 'We do not keep this e-mail address and password',
	'stf_need_approval'        => 'No e-mails are sent without your approval',
	'stf_message'              => 'Message',
	'stf_instructions'         => '1. Select friends.|2. Click "$1"',
	'stf_select_all'           => 'Select all',
	'stf_select_friends'       => 'Select friends:',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Lloffiwr
 * @author Siebrand
 */
$messages['qqq'] = array(
	'stf_name_label' => '{{Identical|Name}}',
	'stf_frm4_cancel' => '{{Identical|Cancel}}',
	'stf_frm4_invite' => 'Button text',
	'stf_throttle' => 'Needs plural support',
	'stf_ctx_invite' => 'Supports plural for $1.',
	'stf_your_name' => '{{Identical|Name}}',
	'stf_your_friends' => 'Apparently the pipe character is replaced with an HTML break. Very strange coding practice. The whole message is a column header, I think.',
	'stf_message' => '{{Identical|Message}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'invitespecialpage' => 'Nooi vriende om by Wikia aan te sluit',
	'stf_button' => "Stuur hierdie artikel aan 'n vriend",
	'stf_after_reg' => "[[Special:InviteSpecialPage|Nooi 'n vriend om by Wikia aan te sluit!]]",
	'stf_subject' => "$2 het aan u 'n bladsy van $1 gestuurd!",
	'stf_confirm' => 'Die boodskap is gestuur!
Wil u nog meer vriende uitnooi?',
	'stf_error' => 'Fout met stuur van e-pos.',
	'stf_error_name' => 'U het nie u naam verskaf nie.',
	'stf_error_from' => 'U het nie u E-posadres verskaf nie.',
	'stf_error_to' => 'U het nie u vriend se e-posadres verskaf nie.',
	'stf_frm1' => 'U e-posadres:',
	'stf_frm2' => 'E-posadresse (Meer as een? Skei met kommas)',
	'stf_msg_label' => 'Boodskap om te stuur',
	'stf_name_label' => 'U naam',
	'stf_email_label' => 'U e-pos',
	'stf_frm3_send' => 'Hallo.

$1 het gedink dat u hierdie bladsy van Wikia sal waardeer!

$2

Kom kyk gerus!',
	'stf_frm3_invite' => 'Hallo!

Ek het sopas by hierdie wiki op Wikia aangesluit... $1

Ek nooi u hartlik uit om te kom kyk!',
	'stf_frm4_send' => 'Stuur',
	'stf_frm4_cancel' => 'Kanselleer',
	'stf_frm4_invite' => 'Stuur uitnodiging!',
	'stf_multiemail' => 'Stuur na meer as een ontvanger?',
	'stf_frm5' => 'Die URL van hierdie webwerf word by u boodskap gevoeg.',
	'stf_frm6' => 'Sluit venster',
	'stf_throttle' => 'Vir sekuriteitsredes kan u slegs $1 {{PLURAL:$1|uitnodiging|uitnodigings}} per dag stuur.',
	'stf_abuse' => 'Hierdie e-pos is gestuur deur $1 via Wikia.
As u dink dat dit foutiewelik aan u gestuur is, laat ons asseblief weet by  support@wikia.com.',
	'stf_ctx_invite' => 'Meer as een?
Skei dan met kommas - maksimum $1!',
	'stf_ctx_check' => 'Kontroleer kontakpersone',
	'stf_ctx_empty' => 'U het geen kontakpersone vir hierdie gebruiker nie.',
	'stf_ctx_invalid' => 'Die gebruikersnaam of wagwoord wat u verskaf het is verkeerd.
Probeer asseblief weer.',
	'stf_sending' => 'Wag asseblief...',
	'stf_email_sent' => 'Stuur bevestiging',
	'stf_back_to_article' => 'Terug na artikel',
	'stf_most_emailed' => 'Mees ge-eposte artikels op $1 vandag:',
	'stf_most_popular' => 'Mees populêre artikels op $1:',
	'stf_choose_from_existing' => 'Kies uit u bestaande kontakpersone:',
	'stf_add_emails' => 'Voeg E-posadresse by:',
	'stf_your_email' => 'U e-posdiens',
	'stf_your_login' => 'U gebruikersnaam',
	'stf_your_password' => 'U wagwoord',
	'stf_your_name' => 'U naam',
	'stf_your_address' => 'U e-posadres',
	'stf_your_friends' => 'E-posadresse|van u vriende',
	'stf_we_dont_keep' => 'Ons hou nie hierdie e-pos of wagwoord nie',
	'stf_need_approval' => 'Sonder u toestemming word geen e-pos gestuur nie',
	'stf_message' => 'Boodskap',
	'stf_instructions' => '1. Kies vriende|2. Kliek "$1"',
	'stf_select_all' => 'Kies alles',
	'stf_select_friends' => 'Kies vriende:',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'stf_frm4_cancel' => 'Cancelar',
	'stf_message' => 'Mensache',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'invitespecialpage' => 'Запрасіць сяброў у Wikia',
	'stf_name_label' => 'Ваша імя',
	'stf_frm4_cancel' => 'Адмяніць',
	'stf_sending' => 'Калі ласка, пачакайце…',
	'stf_your_email' => 'Ваш паштовы сэрвіс',
	'stf_your_login' => 'Назва Вашага рахунку',
	'stf_your_password' => 'Ваш пароль',
	'stf_your_name' => 'Ваша імя',
	'stf_message' => 'Паведамленьне',
);

/** Breton (Brezhoneg)
 * @author Gwenn-Ael
 * @author Y-M D
 */
$messages['br'] = array(
	'invitespecialpage' => "Pediñ mignoned d'en em gavout gant Wikia",
	'sendtoafriend-desc' => '[[Special:InviteSpecialPage|Pediñ mignoned evit dont war Wikia]]',
	'sendtoafriend-button-desc' => 'Diskouez ar bouton "Kas d\'ur mignon" er pajennoù',
	'stf_button' => "Kas ar pennad-mañ d'ur mignon",
	'stf_after_reg' => "[[Special:InviteSpecialPage|Pedit ur mignon d'en em gavout gant Wikia !]]",
	'stf_subject' => "$2 en deus kaset ur pennad deoc'h eus $1!",
	'stf_confirm' => 'Kemmennadenn kaset ! Pediñ tud all ?',
	'stf_error' => "Fazi pa'z eo bet kaset ar postel",
	'stf_error_name' => "N'ho peus roet hoc'h anv.",
	'stf_error_from' => "N'ho peus ket roet ho chomlec'h postel.",
	'stf_error_to' => "N'ho peus ket roet chomlec'h postel ho mignon.",
	'stf_frm1' => "Ho chomlec'h postel :",
	'stf_frm2' => "Chomlec'hioù postel (Muioc'h eget unan? Dispartiet gant skejoù)",
	'stf_msg_label' => 'Kemenadenn da gas',
	'stf_name_label' => "Hoc'h anv",
	'stf_email_label' => "Ho chomlec'h postel",
	'stf_frm3_send' => 'Salud dit!

$1 a soñj dezhañ e plijo ar bajenn Wikia dit!

$2

Deus da wiriañ !',
	'stf_frm3_invite' => "Salud dit!

Emaon o paouez oc'h en em gavout gant ar Wikia-mañ...  $1

Deus da deuler ur sell!",
	'stf_frm4_send' => 'Kas',
	'stf_frm4_cancel' => 'Nullañ',
	'stf_frm4_invite' => 'Kas ar bedadenn !',
	'stf_multiemail' => 'Kas da veur a zen ?',
	'stf_frm5' => "(URL al lech'ienn a vo ouzhpennet d'ho kemmennadenn)",
	'stf_frm6' => 'Serriñ ar prenestr-mañ',
	'stf_throttle' => "Evit abegoù surentez, e c'hallit kas $1 pedadenn{{PLURAL:$1||}} an deiz hepken.",
	'stf_abuse' => "Kaset eo bet ar postel-mmañ gant $1 dre Wikia.
Ma soñj deoc'h ez eo dre fazi, roit dimp da c'houzout, mar plij, war support@wikia.com.",
	'stf_ctx_invite' => "Muioc'h evit unan ? Dispartiit anezho gant skejoù - betek $1 !",
	'stf_ctx_check' => 'Gwiriañ an darempredoù',
	'stf_ctx_empty' => "N'ho peus darempred ebet war ar gont-mañ.",
	'stf_ctx_invalid' => 'direizh eo an niverenn-anaout pe ar ger-tremen ho peus bizskrivet. Klaskit en-dro, mar plij',
	'stf_sending' => 'Gortozit mar plij...',
	'stf_email_sent' => "Kas ur c'hemennad kardarnaat",
	'stf_back_to_article' => "Distreiñ d'ar pennad",
	'stf_most_emailed' => 'Pennadoù kaset ar muiañ dre bostel hiziv war $1 :',
	'stf_most_popular' => 'Pennadoù poblekañ $1',
	'stf_choose_from_existing' => 'Dibabit e-touez ho darempredoù bremañ :',
	'stf_add_emails' => "Ouzhpennañ chomlec'hioù posteloù",
	'stf_your_email' => 'Ho servij posteler',
	'stf_your_login' => "Hoc'h anv implijer",
	'stf_your_password' => 'Ho ker-tremen',
	'stf_your_name' => "Hoc'h anv",
	'stf_your_address' => "Ho chomlec'h postel",
	'stf_your_friends' => "Chomlec'hioù postel|ho mignoned",
	'stf_we_dont_keep' => 'Ne viromp ket ar posteloù/gerioù-tremen-mañ',
	'stf_need_approval' => "Ne vo kaset postel ebet hep ma vefe aprouet ganeoc'h.",
	'stf_message' => 'Kemennadenn',
	'stf_instructions' => '1. Dibabit mignoned. |2. Klikit war « $1 »',
	'stf_select_all' => 'Diuzañ pep tra',
	'stf_select_friends' => 'Diuzañ Mignoned :',
);

/** Welsh (Cymraeg)
 * @author Babel AutoCreate
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'invitespecialpage' => 'Gwahodd ffrindiau i ymuno â Wikia',
	'sendtoafriend-desc' => '[[Special:InviteSpecialPage|Gwahodd ffrindiau i ymuno â Wikia]]',
	'sendtoafriend-button-desc' => 'Yn gosod botwm "Anfon at ffrind" ar dudalennau',
	'stf_button' => 'Anfoner yr erthygl hon at ffrind',
	'stf_after_reg' => '[[Special:InviteSpecialPage|Gwahoddwch ffrind i ymuno â Wikia!]]',
	'stf_subject' => 'Mae $2 wedi anfon erthygl o $1 atoch!',
	'stf_confirm' => 'Anfonwyd y neges! Am wahodd pobl eraill?',
	'stf_error' => 'Cafwyd gwall wrth ddanfon yr e-bost.',
	'stf_error_name' => 'Wnaethoch chi ddim rhoi eich enw.',
	'stf_error_from' => 'Wnaethoch chi ddim rhoi eich cyfeiriad e-bost.',
	'stf_error_to' => 'Nid ydych wedi ysgrifennu cyfeiriad e-bost eich ffrind.',
	'stf_frm1' => 'Eich cyfeiriad e-bost:',
	'stf_frm2' => 'Users in this category indicate they have skill level 5 for language íslenska.',
	'stf_msg_label' => "Y neges i'w hanfon",
	'stf_name_label' => 'Eich enw',
	'stf_email_label' => 'Eich cyfeiriad e-bost',
	'stf_frm3_send' => "Sut mae?

Mae $1 yn meddwl y byddech yn mwynhau darllen y dudalen Wikia isod!

$2

Dewch draw i'w weld!",
	'stf_frm3_invite' => "Sut mae?

Rwyf newydd ymuno â'r wici hwn yn Wikia... $1

Dewch draw i'w weld!",
	'stf_frm4_send' => 'Anfoner',
	'stf_frm4_cancel' => 'Diddymer',
	'stf_frm4_invite' => 'Anfoner y gwahoddiad!',
	'stf_multiemail' => 'Am anfon at fwy nag un?',
	'stf_frm5' => '(bydd URL y safle hwn yn cael ei gosod wrth gwt eich neges)',
	'stf_frm6' => "Cau'r ffenestr hon",
	'stf_throttle' => 'Am resymau diogelwch, dim ond $1 {{PLURAL:$1||gwahoddiad y gallwch ei anfon|wahoddiad y gallwch eu hanfon|gwahoddiad y gallwch eu hanfon|gwahoddiad y gallwch eu hanfon|gwahoddiad y gallwch eu hanfon}} bob dydd.',
	'stf_abuse' => 'Anfonwyd yr e-bost hwn drwy Wikia gan $1.
Os ydych yn credu mai drwy gamgymeriad y cafodd ei anfon, rhowch wybod i ni yn support@wikia.com, os gwelwch yn dda.',
	'stf_ctx_invite' => 'Mwy nag un? Gwahanwch nhw gydag atalnodau - hyd at $1 ohonynt!',
	'stf_ctx_check' => "Gwirio'ch cydnabod",
	'stf_ctx_empty' => 'Nid oes enwau unrhyw gydnabod yn y cyfrif hwn.',
	'stf_ctx_invalid' => "Mae'r enw defnyddiwr neu'r cyfrinair a deipiasoch yn annilys. Rhowch gynnig arall arni.",
	'stf_sending' => 'Arhoswch ...',
	'stf_back_to_article' => "Nôl i'r erthygl",
	'stf_most_emailed' => 'Users in this category indicate they have knowledge of language íslenska.',
	'stf_most_popular' => "Dyma'r erthyglau mwyaf poblogaidd ar $1:",
	'stf_choose_from_existing' => 'Dewis cyfeiriadau o blith eich cydnabod:',
	'stf_add_emails' => 'Ychwanegu cyfeiriadau e-bost:',
	'stf_your_email' => 'Eich gwasanaeth e-bost',
	'stf_your_login' => 'Eich enw defnyddiwr',
	'stf_your_password' => 'Eich cyfrinair',
	'stf_your_name' => 'Eich enw',
	'stf_your_address' => 'Eich cyfeiriad e-bost',
	'stf_your_friends' => 'Cyfeiriadau e-bost|eich ffrind',
	'stf_we_dont_keep' => "Ni fyddwn yn cadw'r cyfeiriad e-bost hwn na'r cyfrinair",
	'stf_need_approval' => 'Ni anfonir e-byst heb eich caniatâd',
	'stf_message' => 'Neges',
	'stf_instructions' => '1. Dewiswch eich ffrindiau. | 2. Cliciwch "$1"',
	'stf_select_all' => 'Dewis pawb',
	'stf_select_friends' => 'Dewis ffrindiau:',
);

/** German (Deutsch)
 * @author LWChris
 */
$messages['de'] = array(
	'invitespecialpage' => 'Lade Freunde zu Wikia ein',
	'sendtoafriend-desc' => '[[Special:InviteSpecialPage|Freunde einladen Wikia beizutreten]]',
	'sendtoafriend-button-desc' => 'Zeigt einen "Weiterempfehlen"-Button auf den Seiten',
	'stf_button' => 'Artikel an einen Freund versenden',
	'stf_after_reg' => '[[Special:InviteSpecialPage|Lade einen Freund zu Wikia ein!]].',
	'stf_subject' => '$2 hat dir einen Artikel von $1 geschickt!',
	'stf_confirm' => 'Nachricht versandt! Weitere Freunde einladen?',
	'stf_error' => 'Fehler beim Mailversand.',
	'stf_error_name' => 'Du hast deinen Namen nicht angegeben.',
	'stf_error_from' => 'Du hast deine E-Mail-Adresse nicht angegeben.',
	'stf_error_to' => 'Du hast die E-Mail-Adresse deines Freundes nicht angegeben.',
	'stf_frm1' => 'Deine E-Mail-Adresse:',
	'stf_frm2' => 'E-Mail-Adressen (Mehr als eine? Trenne sie durch Kommata)',
	'stf_msg_label' => 'Zu versendende Nachricht',
	'stf_name_label' => 'Dein Name',
	'stf_email_label' => 'Deine E-Mail-Adresse:',
	'stf_frm3_send' => 'Hi!

$1 denkt, dass dir diese Seite von Wikia gefallen könnte!

$2

Wirf mal einen Blick drauf!',
	'stf_frm3_invite' => "Hi!

Ich hab' mich gerade bei diesem Wiki bei Wikia angemeldet: $1

Schau doch mal vorbei!",
	'stf_frm4_send' => 'Abschicken',
	'stf_frm4_cancel' => 'Abbrechen',
	'stf_frm4_invite' => 'Einladung verschicken!',
	'stf_multiemail' => 'An mehr als einen Empfänger verschicken?',
	'stf_frm5' => '(die URL dieser Seite wird an deine Nachricht angehängt)',
	'stf_frm6' => 'Fenster schließen',
	'stf_throttle' => 'Aus Sicherheitsgründen kannst du nur {{PLURAL:$1|1 Einladung|$1 Einladungen}} pro Tag verschicken.',
	'stf_abuse' => 'Diese E-Mail wurde von $1 über Wikia verschickt.
Wenn du glaubst, dass sie irrtümlicherweise gesendet wurde, teile uns dies bitte unter support@wikia.com mit.',
	'stf_ctx_invite' => 'Mehr als eine? Mit Komma trennen - bis zu $1!',
	'stf_ctx_check' => 'Checke Kontakte',
	'stf_ctx_empty' => 'Unter diesem Benutzerkonto existieren keine Kontakte.',
	'stf_ctx_invalid' => 'Der Benutzername oder das Passwort ist ungültig. Bitte probier es noch einmal.',
	'stf_sending' => 'Etwas Geduld...',
	'stf_email_sent' => 'Bestätigung senden',
	'stf_back_to_article' => 'Zurück zum Artikel',
	'stf_most_emailed' => 'Heute am häufigsten verschickter Artikel in $1:',
	'stf_most_popular' => 'Beliebteste Artikel auf $1:',
	'stf_choose_from_existing' => 'Wähle aus deinen bestehenden Kontakten:',
	'stf_add_emails' => 'E-Mail-Adressen hinzufügen:',
	'stf_your_email' => 'Dein E-Mail-Dienst',
	'stf_your_login' => 'Dein Benutzername',
	'stf_your_password' => 'Dein Passwort',
	'stf_your_name' => 'Dein Name',
	'stf_your_address' => 'Deine E-Mail-Adresse',
	'stf_your_friends' => 'E-Mail-Adressen|deiner Freunde',
	'stf_we_dont_keep' => 'Diese E-Mail-Adresse und das Passwort werden nicht gespeichert',
	'stf_need_approval' => 'Es werden keine E-Mails ohne deine Zustimmung verschickt',
	'stf_message' => 'Nachricht',
	'stf_instructions' => '1. Freunde auswählen.|2. "$1" klicken',
	'stf_select_all' => 'Alle auswählen',
	'stf_select_friends' => 'Freunde auswählen:',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author LWChris
 */
$messages['de-formal'] = array(
	'invitespecialpage' => 'Laden Sie Freunde zu Wikia ein',
	'stf_subject' => '$2 hat Ihnen einen Artikel von $1 geschickt!',
	'stf_error_name' => 'Sie haben Ihren Namen nicht angegeben.',
	'stf_error_from' => 'Sie haben Ihre E-Mail-Adresse nicht angegeben.',
	'stf_error_to' => 'Sie haben die E-Mail-Adresse Ihres Freundes nicht angegeben.',
	'stf_frm1' => 'Ihre E-Mail-Adresse:',
	'stf_frm2' => 'E-Mail-Adressen (Mehr als eine? Trennen Sie sie durch Kommata)',
	'stf_name_label' => 'Ihr Name',
	'stf_email_label' => 'Ihre E-Mail-Adresse:',
	'stf_frm3_send' => 'Guten Tag!

$1 denkt, dass Ihnen diese Seite von Wikia gefallen könnte!

$2

Werfen Sie doch einmal einen Blick drauf!',
	'stf_frm3_invite' => 'Hallo!

Ich habe mich gerade bei diesem Wiki bei Wikia angemeldet... $1

Schauen Sie doch auch mal vorbei!',
	'stf_frm5' => '(die URL dieser Seite wird an Ihre Nachricht angehängt)',
	'stf_throttle' => 'Aus Sicherheitsgründen können Sie nur $1 {{PLURAL:$1|Einladung|Einladungen}} pro Tag verschicken.',
	'stf_abuse' => 'Diese E-Mail wurde von $1 über Wikia verschickt.
Wenn Sie glauben, dass sie irrtümlicherweise gesendet wurde, teilen Sie uns dies bitte unter support@wikia.com mit.',
	'stf_ctx_invalid' => 'Der Benutzername oder das Passwort ist ungültig. Bitte probieren Sie es noch einmal.',
	'stf_choose_from_existing' => 'Wählen Sie aus Ihren bestehenden Kontakten:',
	'stf_your_email' => 'Ihr E-Mail-Dienst',
	'stf_your_login' => 'Ihr Benutzername',
	'stf_your_password' => 'Ihr Passwort',
	'stf_your_name' => 'Ihr Name',
	'stf_your_address' => 'Ihre E-Mail-Adresse',
	'stf_your_friends' => 'E-Mail-Adressen|Ihrer Freunde',
	'stf_need_approval' => 'Es werden keine E-Mails ohne Ihre Zustimmung verschickt',
);

/** Greek (Ελληνικά)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['el'] = array(
	'stf_frm4_cancel' => 'Ακύρωση',
	'stf_message' => 'Μήνυμα',
);

/** Spanish (Español)
 * @author Translationista
 */
$messages['es'] = array(
	'invitespecialpage' => 'Invita a tus amigos a participar en Wikia',
	'sendtoafriend-desc' => '[[Special:InviteSpecialPage|Invita a tus amistades a unirse a Wikia]]',
	'sendtoafriend-button-desc' => 'Muestra un botón de "Enviar a una amistad" en las páginas',
	'stf_button' => 'Envía este artículo a un amigo',
	'stf_after_reg' => '[[Special:InviteSpecialPage|¡Invita a una amistad a unirse a Wikia!]]',
	'stf_subject' => '$2 te ha enviado un artículo desde $1!',
	'stf_confirm' => '¡Mensaje enviado! ¿Deseas invitar a alguien más?',
	'stf_error' => 'Error enviando el correo electrónico',
	'stf_error_name' => 'No especificaste tu nombre.',
	'stf_error_from' => 'No has especificado tu dirección de correo electrónico.',
	'stf_error_to' => 'No especificaste la dirección de correo electrónico de tu amigo.',
	'stf_frm1' => 'Tu dirección de correo electrónico:',
	'stf_frm2' => 'Direcciones de correo (¿Más de una? Sepáralas con una coma).',
	'stf_msg_label' => 'Mensaje a enviar',
	'stf_name_label' => 'Tu nombre',
	'stf_email_label' => 'Tu email',
	'stf_frm3_send' => '¡Hola!

¡$1 piensa que te gustará esta página de Wikia!

$2

¡Ven a revisarla!',
	'stf_frm3_invite' => '¡Hola!

Acabo de unirme a este wiki de Wikia...  $1

¡Te invito a revisarlo!',
	'stf_frm4_send' => 'Enviar',
	'stf_frm4_cancel' => 'Cancelar',
	'stf_frm4_invite' => '¡Envía la invitación!',
	'stf_multiemail' => '¿Enviar a más de un receptor?',
	'stf_frm5' => '(la dirección de este sitio será incluida al final de tu mensaje)',
	'stf_frm6' => 'Cerrar esta ventana',
	'stf_throttle' => 'Por razones de seguridad, sólo puedes enviar {{PLURAL:$1|invitación|invitaciones}} por día.',
	'stf_abuse' => 'Este email fue enviado por $1 via Wikia.
Si piensas que fue enviado por error, por favor háznoslo saber a support@wikia.com',
	'stf_ctx_invite' => '¿Más de una? Sepáralas con comas, ¡puedes ingresar hasta $1!',
	'stf_ctx_check' => 'Comprobar contactos',
	'stf_ctx_empty' => 'No tienes contactos en esta cuenta.',
	'stf_ctx_invalid' => 'El nombre de usuario o la contraseña que escribiste no son válidos. Por favor inténtalo nuevamente.',
	'stf_sending' => 'Espera un momento, por favor...',
	'stf_email_sent' => 'Enviar confirmación',
	'stf_back_to_article' => 'Volver al artículo',
	'stf_most_emailed' => 'Artículos que más se han enviado hoy por correo electrónico en $1:',
	'stf_most_popular' => 'Artículos más populares en $1:',
	'stf_choose_from_existing' => 'Elige desde tus contactos existentes:',
	'stf_add_emails' => 'Añade direcciones de correo electrónico:',
	'stf_your_email' => 'Tu servicio de correo electrónico',
	'stf_your_login' => 'Tu nombre de usuario',
	'stf_your_password' => 'Tu contraseña',
	'stf_your_name' => 'Tu nombre',
	'stf_your_address' => 'Tu dirección de correo electrónico',
	'stf_your_friends' => 'La dirección de correo|electrónico de tu|amigo',
	'stf_we_dont_keep' => 'No conservaremos tu dirección de correo electrónico y/o contraseña',
	'stf_need_approval' => 'No se enviarán correos electrónicos sin tu aprobación',
	'stf_message' => 'Mensaje',
	'stf_instructions' => '1. Selecciona amigos.|2. Haz clic en "$1"',
	'stf_select_all' => 'Seleccionar todos',
	'stf_select_friends' => 'Seleccionar amigos:',
);

/** Estonian (Eesti)
 * @author Hendrik
 */
$messages['et'] = array(
	'stf_error' => 'Viga e-kirja saatmisel.',
	'stf_frm4_send' => 'Saada',
	'stf_frm4_invite' => 'Saada kutse!',
	'stf_frm6' => 'Sulge see aken',
	'stf_email_sent' => 'Saada kinnitus',
	'stf_select_all' => 'Vali kõik',
);

/** Persian (فارسی) */
$messages['fa'] = array(
	'invitespecialpage' => 'دعوت دوستان برای پیوستن به ویکیا',
);

/** Finnish (Suomi)
 * @author Centerlink
 * @author Crt
 */
$messages['fi'] = array(
	'invitespecialpage' => 'Kutsu ystävä Wikiaan',
	'stf_msg_label' => 'Lähetettävä viesti',
	'stf_name_label' => 'Nimesi',
	'stf_email_label' => 'Sähköpostiosoitteesi',
	'stf_frm4_cancel' => 'Peruuta',
	'stf_frm6' => 'Sulje tämä ikkuna',
	'stf_email_sent' => 'Lähetä vahvistus',
	'stf_your_name' => 'Nimesi',
	'stf_your_address' => 'Sähköpostiosoitteeseesi',
	'stf_message' => 'Viesti',
	'stf_select_all' => 'Valitse kaikki',
);

/** French (Français)
 * @author IAlex
 * @author Peter17
 */
$messages['fr'] = array(
	'invitespecialpage' => 'Inviter des amis à rejoindre Wikia',
	'sendtoafriend-desc' => '[[Special:InviteSpecialPage|Inviter des amis à rejoindre Wikia]]',
	'sendtoafriend-button-desc' => 'Afficher le bouton « Envoyer à un ami » dans les pages',
	'stf_button' => 'Envoyer cet article à un ami',
	'stf_after_reg' => '[[Special:InviteSpecialPage|Invitez un ami à rejoindre Wikia !]]',
	'stf_subject' => '$2 vous a envoyé un article depuis $1 !',
	'stf_confirm' => "Message envoyé ! Inviter d'autres personnes ?",
	'stf_error' => "Erreur lors de l'envoi du courriel.",
	'stf_error_name' => "Vous n'avez pas fourni votre nom.",
	'stf_error_from' => "Vous n'avez pas fourni votre adresse de courriel.",
	'stf_error_to' => "Vous n'avez pas fourni l'adresse de courriel de votre ami.",
	'stf_frm1' => 'Votre adresse de courriel :',
	'stf_frm2' => "Adresses de courriel (Plus d'une ? les séparer avec des virgules)",
	'stf_msg_label' => 'Message a envoyer',
	'stf_name_label' => 'Votre nom',
	'stf_email_label' => 'Votre adresse de courriel',
	'stf_frm3_send' => 'Salut !

$1 a pensé que tu apprécierais cette page de Wikia !

$2

Viens vérifier !',
	'stf_frm3_invite' => 'Salut !

Je viens de rejoindre ce wiki sur Wikia... $1

Viens jeter un œil !',
	'stf_frm4_send' => 'Envoyer',
	'stf_frm4_cancel' => 'Annuler',
	'stf_frm4_invite' => 'Envoyer les invitations!',
	'stf_multiemail' => "Envoyer à plus d'une personne ?",
	'stf_frm5' => "(l'URL de ce site sera ajoutée à votre message)",
	'stf_frm6' => 'Fermer cette fenêtre',
	'stf_throttle' => 'Pour des raisons de sécurité, vous pouvez uniquement envoyer $1 {{PLURAL:$1|invitation|invitations}} par jour.',
	'stf_abuse' => "Ce courrier électronique a été envoyé par $1 depuis Wikia.
Si vous pensez qu'il s'agit d'une erreur, merci de nous le faire savoir à support@wikia.com.",
	'stf_ctx_invite' => "Plus d'une adresse? Séparez-les avec des virgules - jusqu'à $1 !",
	'stf_ctx_check' => 'Vérification des contacts',
	'stf_ctx_empty' => "Vous n'avez aucun contact sur ce compte.",
	'stf_ctx_invalid' => "L'identifiant ou le mot de passe que vous avez tapé est invalide. Veuillez ré-essayer.",
	'stf_sending' => 'Veuillez patienter...',
	'stf_email_sent' => 'Envoyer une confirmation',
	'stf_back_to_article' => "Revenir à l'article",
	'stf_most_emailed' => "Articles les plus envoyés par courrier électronique aujourd'hui sur $1 :",
	'stf_most_popular' => 'Articles les plus populaires de $1 :',
	'stf_choose_from_existing' => 'Choisir parmi vos contacts actuels :',
	'stf_add_emails' => 'Ajouter des adresses email',
	'stf_your_email' => "Votre service d'email",
	'stf_your_login' => "Votre nom d'utilisateur",
	'stf_your_password' => 'Votre mot de passe',
	'stf_your_name' => 'Votre nom',
	'stf_your_address' => 'Votre adresse email',
	'stf_your_friends' => 'Les adresses email|de vos amis',
	'stf_we_dont_keep' => 'Nous ne gardons pas ces email et mot de passe',
	'stf_need_approval' => "Aucun envoi d'email sans votre approbation",
	'stf_message' => 'Message',
	'stf_instructions' => '1. Sélectionnez des amis. |2. Cliquez sur « $1 »',
	'stf_select_all' => 'Tout sélectionner',
	'stf_select_friends' => 'Sélectionner des amis :',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'invitespecialpage' => 'Convidar aos amigos a unirse a Wikia',
	'sendtoafriend-desc' => '[[Special:InviteSpecialPage|Convide amigos a unirse a Wikia!]]',
	'sendtoafriend-button-desc' => 'Mostra un botón "Enviar a un amigo" nas páxinas',
	'stf_button' => 'Enviar este artigo a un amigo',
	'stf_after_reg' => '[[Special:InviteSpecialPage|Convide a un amigo a unirse a Wikia!]]',
	'stf_subject' => '$2 envioulle un artigo de $1!',
	'stf_confirm' => 'Mensaxe enviada! Quere convidar a outras persoas?',
	'stf_error' => 'Erro ao enviar o correo electrónico.',
	'stf_error_name' => 'Non deu o seu nome.',
	'stf_error_from' => 'Non deu o seu enderezo de correo electrónico.',
	'stf_error_to' => 'Non deu o enderezo de correo electrónico do seu amigo.',
	'stf_frm1' => 'O seu enderezo de correo electrónico:',
	'stf_frm2' => 'Enderezos de correo electrónico (hai máis dun? Escríbaos separados por comas)',
	'stf_msg_label' => 'Mensaxe a enviar',
	'stf_name_label' => 'O seu nome',
	'stf_email_label' => 'O seu correo electrónico',
	'stf_frm3_send' => 'Ola!

$1 pensou que lle gustaría esta páxina de Wikia!

$2

Veña vela!',
	'stf_frm3_invite' => 'Ola!

Veño de me unir a este wiki de Wikia... $1

Ven velo!',
	'stf_frm4_send' => 'Enviar',
	'stf_frm4_cancel' => 'Cancelar',
	'stf_frm4_invite' => 'Enviar o convite!',
	'stf_multiemail' => 'Quérea enviar a máis dun destinatario?',
	'stf_frm5' => '(o URL deste sitio engadirase á súa mensaxe)',
	'stf_frm6' => 'Pechar esta ventá',
	'stf_throttle' => 'Por razóns de seguridade, só pode enviar $1 {{PLURAL:$1|convite|convites}} ao día.',
	'stf_abuse' => 'Este correo electrónico foi enviado por $1 a través de Wikia.
Se pensa que lle chegou por erro, por favor, fáganolo saber en support@wikia.com.',
	'stf_ctx_invite' => 'Hai máis dun? Sepáreos con comas; ata $1!',
	'stf_ctx_check' => 'Comprobar os contactos',
	'stf_ctx_empty' => 'Non ten ningún contacto nesta conta.',
	'stf_ctx_invalid' => 'O nome de usuario ou o contrasinal que inseriu é inválido. Por favor, inténteo de novo.',
	'stf_sending' => 'Por favor, agarde...',
	'stf_email_sent' => 'Enviar unha confirmación',
	'stf_back_to_article' => 'Volver ao artigo',
	'stf_most_emailed' => 'Artigos máis enviados por correo electrónico hoxe en $1:',
	'stf_most_popular' => 'Artigos máis populares en $1:',
	'stf_choose_from_existing' => 'Elixir de entre os seus contactos xa existentes:',
	'stf_add_emails' => 'Engadir enderezos de correo electrónico:',
	'stf_your_email' => 'O seu servizo de correo electrónico',
	'stf_your_login' => 'O seu nome de usuario',
	'stf_your_password' => 'O seu contrasinal',
	'stf_your_name' => 'O seu nome',
	'stf_your_address' => 'O seu enderezo de correo electrónico',
	'stf_your_friends' => 'O enderezo de correo electrónico|do seu amigo',
	'stf_we_dont_keep' => 'Nós non mantemos este correo electrónico e contrasinal',
	'stf_need_approval' => 'Non se enviou ningún correo electrónico sen a súa aprobación',
	'stf_message' => 'Mensaxe',
	'stf_instructions' => '1. Seleccione os amigos.|2. Prema en "$1"',
	'stf_select_all' => 'Seleccionar todos',
	'stf_select_friends' => 'Seleccionar os amigos:',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'invitespecialpage' => 'Barátok meghívása a Wikiához való csatlakozásra',
	'stf_error' => 'Hiba az email küldése közben.',
	'stf_msg_label' => 'Elküldendő üzenet',
	'stf_name_label' => 'Neved',
	'stf_email_label' => 'Email címed',
	'stf_frm4_send' => 'Küldés',
	'stf_frm4_cancel' => 'Mégse',
	'stf_frm4_invite' => 'Meghívó küldése!',
	'stf_frm6' => 'Ablak bezárása',
	'stf_sending' => 'Kérlek várj …',
	'stf_email_sent' => 'Visszaigazolás küldése',
	'stf_back_to_article' => 'Vissza a szócikkhez',
	'stf_add_emails' => 'Email címek hozzáadása:',
	'stf_your_email' => 'Az email szolgáltatód',
	'stf_your_login' => 'Bejelentkezési neved',
	'stf_your_password' => 'Jelszavad',
	'stf_your_name' => 'Neved',
	'stf_your_address' => 'Email címed',
	'stf_message' => 'Üzenet',
	'stf_select_all' => 'Összes kijelölése',
	'stf_select_friends' => 'Barátok kijelölése:',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'invitespecialpage' => 'Invita amicos a participar in Wikia',
	'sendtoafriend-desc' => '[[Special:InviteSpecialPage|Invita amicos a participar in Wikia]]',
	'sendtoafriend-button-desc' => 'Monstra un button "Inviar a un amico" in paginas',
	'stf_button' => 'Inviar iste articulo a un amico',
	'stf_after_reg' => '[[Special:InviteSpecialPage|Invita un amico a participar in Wikia!]]',
	'stf_subject' => '$2 te ha inviate un articulo de $1!',
	'stf_confirm' => 'Message inviate! Invitar altere personas?',
	'stf_error' => 'Error de inviar e-mail.',
	'stf_error_name' => 'Tu non ha specificate tu nomine.',
	'stf_error_from' => 'Tu non ha specificate tu adresse de e-mail.',
	'stf_error_to' => 'Tu non ha specificate le adresse de e-mail de tu amico.',
	'stf_frm1' => 'Tu adresse de e-mail:',
	'stf_frm2' => 'Adresses de e-mail (Plus de un? Separa los con commas)',
	'stf_msg_label' => 'Message a inviar',
	'stf_name_label' => 'Tu nomine',
	'stf_email_label' => 'Tu e-mail',
	'stf_frm3_send' => 'Salute!

$1 pensava que te placerea iste pagina de Wikia!

$2

Veni leger lo!',
	'stf_frm3_invite' => 'Salute!

Io justo me univa a iste wiki a Wikia... $1

Veni vider lo!',
	'stf_frm4_send' => 'Inviar',
	'stf_frm4_cancel' => 'Cancellar',
	'stf_frm4_invite' => 'Inviar invitation!',
	'stf_multiemail' => 'Inviar a plus de un destinatario?',
	'stf_frm5' => '(le URL de iste sito essera adjungite a tu message)',
	'stf_frm6' => 'Clauder iste fenestra',
	'stf_throttle' => 'Pro motivos de securitate, tu pote solmente inviar $1 {{PLURAL:$1|invitation|invitationes}} per die.',
	'stf_abuse' => 'Iste e-mail ha essite inviate per $1 via Wikia.
Si tu pensa que isto ha essite inviate in error, per favor face nos lo saper a support@wikia.com.',
	'stf_ctx_invite' => 'Plus de un? Separa con commas - usque a $1!',
	'stf_ctx_check' => 'Verificar contactos',
	'stf_ctx_empty' => 'Tu non ha contactos in iste conto.',
	'stf_ctx_invalid' => 'Le nomine de usator o le contrasigno que tu entrava es invalide. Per favor reproba.',
	'stf_sending' => 'Un momento…',
	'stf_email_sent' => 'Inviar confirmation',
	'stf_back_to_article' => 'Retornar al articulo',
	'stf_most_emailed' => 'Le articulos le plus inviate hodie in $1:',
	'stf_most_popular' => 'Le articulos le plus popular in $1:',
	'stf_choose_from_existing' => 'Selige de tu contactos existente:',
	'stf_add_emails' => 'Adder adresses de e-mail:',
	'stf_your_email' => 'Tu servicio de e-mail',
	'stf_your_login' => 'Tu nomine de usator',
	'stf_your_password' => 'Tu contrasigno',
	'stf_your_name' => 'Tu nomine',
	'stf_your_address' => 'Tu adresse de e-mail',
	'stf_your_friends' => 'Le adresses de e-mail|de tu amicos',
	'stf_we_dont_keep' => 'Nos non retene iste adresse de e-mail e contrasigno',
	'stf_need_approval' => 'Nulle e-mail es inviate sin tu approbation',
	'stf_message' => 'Message',
	'stf_instructions' => '1. Selige amicos.|2. Clicca super "$1"',
	'stf_select_all' => 'Seliger totes',
	'stf_select_friends' => 'Selige amicos:',
);

/** Igbo (Igbo) */
$messages['ig'] = array(
	'stf_frm4_cancel' => 'Emekwàlà',
	'stf_message' => 'Ozi',
);

/** Italian (Italiano) */
$messages['it'] = array(
	'stf_name_label' => 'Tuo nome',
	'stf_email_label' => 'Tuo indirizzo e-mail',
	'stf_frm4_send' => 'Invia',
	'stf_frm4_cancel' => 'Annulla',
	'stf_your_password' => 'Password',
	'stf_your_name' => 'Password',
	'stf_message' => 'Messaggio',
	'stf_select_all' => 'Seleziona tutte',
);

/** Japanese (日本語)
 * @author Naohiro19
 * @author Tommy6
 */
$messages['ja'] = array(
	'invitespecialpage' => '友人を招待する',
	'sendtoafriend-button-desc' => '"Send to a friend"ボタンをページに表示する',
	'stf_button' => 'この記事を友達に送ります',
	'stf_after_reg' => '友達をウィキアに招待してみましょう! [[Special:InviteSpecialPage|こちら]]をクリックしてください。',
	'stf_subject' => '$2さんが$1からの記事を送りました。',
	'stf_confirm' => 'メッセージを送りました! 他の人も招待しますか?',
	'stf_error' => 'メールの送信に失敗しました。',
	'stf_error_name' => 'お名前が入力されていません',
	'stf_error_from' => 'メールアドレスが入力されていません。',
	'stf_error_to' => '送信先が入力されていません',
	'stf_frm1' => '自分のメールアドレス:',
	'stf_frm2' => 'メールアドレス(ひとつ以上の場合はカンマ(,)で区切ってください)',
	'stf_msg_label' => '送信されたメッセージ',
	'stf_name_label' => '名前',
	'stf_email_label' => 'メールアドレス',
	'stf_frm3_send' => 'こんにちは!

ウィキアのこのページのがお薦めです。

$2

是非ともチェックしてみてください。',
	'stf_frm3_invite' => 'こんにちは!

ウィキアの $1 のウィキサイトに参加しました。

是非ともチェックしてみてください。',
	'stf_frm4_send' => '送信',
	'stf_frm4_cancel' => 'キャンセル',
	'stf_frm4_invite' => '招待状を送りましょう!',
	'stf_multiemail' => '二人以上に送りますか?',
	'stf_frm5' => '(このページのURLはメールに自動で含まれます)',
	'stf_frm6' => 'ウィンドウを閉じる',
	'stf_throttle' => 'セキュリティ上の理由により、一日に$1回までしか送信できません。',
	'stf_abuse' => 'このメールは、$1がウィキアから送信したものです。もし、何らかの間違いであったら、 support@wikia.com までお知らせください。',
	'stf_ctx_invite' => '一人以上の場合は、カンマ(,)で区切ってください。制限は$1人までです。',
	'stf_ctx_check' => 'アドレス帳を確認',
	'stf_ctx_empty' => 'このアカウントにアドレス帳がありません',
	'stf_ctx_invalid' => 'アカウント名、またはパスワードが違います。もう一度確認してみてください。',
	'stf_sending' => '少しお待ちください',
	'stf_email_sent' => '送信の確認',
	'stf_back_to_article' => '記事に戻る',
	'stf_most_emailed' => '$1で今日一番メールで送られた記事:',
	'stf_most_popular' => '$1の人気の記事:',
	'stf_choose_from_existing' => '下から、使っているサービスを選んでください:',
	'stf_add_emails' => '追加のメールアドレス:',
	'stf_your_email' => '利用しているメールサービス',
	'stf_your_login' => 'アカウント名',
	'stf_your_password' => 'パスワード',
	'stf_your_name' => '名前',
	'stf_your_address' => 'メールアドレス',
	'stf_your_friends' => '友達のメールアドレス',
	'stf_we_dont_keep' => 'メールアドレス、パスワードは保存しません',
	'stf_need_approval' => '承認が無いため、メールが送られませんでした。',
	'stf_message' => 'メッセージ',
	'stf_instructions' => '1. 友達を選択|2. "$1"をクリックする',
	'stf_select_all' => '全て選択',
	'stf_select_friends' => '友達を選択:',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'stf_name_label' => 'ನಿಮ್ಮ ಹೆಸರು',
	'stf_your_name' => 'ನಿಮ್ಮ ಹೆಸರು',
	'stf_message' => 'ಸಂದೇಶ',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'invitespecialpage' => 'Поканете пријатели да се зачленат на Викија',
	'sendtoafriend-desc' => '[[Special:InviteSpecialPage|Поканете пријатели да се зачленат на Викија]]',
	'sendtoafriend-button-desc' => 'Прикажува копче „Испрати на пријател“ во страниците',
	'stf_button' => 'Испрати ја статијава на пријател',
	'stf_after_reg' => '[[Special:InviteSpecialPage|Поканете пријател да се зачлени на Викија!]]',
	'stf_subject' => '$2 ви испрати статија од $1!',
	'stf_confirm' => 'Пораката е испратена! Сакате да поканите уште?',
	'stf_error' => 'Грешка при испраќање на е-поштата',
	'stf_error_name' => 'Не наведовте ваше корисничко име.',
	'stf_error_from' => 'Не наведовте ваша е-поштенска адреса.',
	'stf_error_to' => 'Не наведовте е-поштенска адреса за вашиот пријател.',
	'stf_frm1' => 'Ваша е-поштенска адреса:',
	'stf_frm2' => 'Е-поштенски адреси (Повеќе од една? Одделувајте ги со запирки)',
	'stf_msg_label' => 'Порака за праќање',
	'stf_name_label' => 'Ваше име',
	'stf_email_label' => 'Ваша е-пошта',
	'stf_frm3_send' => 'Здраво!

$1 мисли дека ќе ви се допадне оваа страница од Викија!

$2

Ѕирнете ја!',
	'stf_frm3_invite' => 'Здраво!

Штотуку се зачленив на ова вики на Викија...  $1

Ѕирни го!',
	'stf_frm4_send' => 'Испрати',
	'stf_frm4_cancel' => 'Откажи',
	'stf_frm4_invite' => 'Испрати покана!',
	'stf_multiemail' => 'Да испратам на повеќе од еден примач?',
	'stf_frm5' => '(URL-адресата на оваа веб-страница ќе биде приложена кон вашата порака)',
	'stf_frm6' => 'Затвори го прозорецов',
	'stf_throttle' => 'Од безбедносни причини можете да испратите највеќе до $1 {{PLURAL:$1|покана|покани}} дневно.',
	'stf_abuse' => 'Ова писмо го испрати $1 преку Викија.
Ако сметате дека е испратено по грешка, известете нè на support@wikia.com.',
	'stf_ctx_invite' => 'Повеќе од една? Одделете ги со запирки - дозволено е највеќе до $1!',
	'stf_ctx_check' => 'Провери контакти',
	'stf_ctx_empty' => 'Немате контакти на оваа сметка.',
	'stf_ctx_invalid' => 'Внесено е погрешно корисничко име или лозинка. Обидете се повторно.',
	'stf_sending' => 'Почекајте...',
	'stf_email_sent' => 'Испрати потврда',
	'stf_back_to_article' => 'Назад кон статијата',
	'stf_most_emailed' => 'Најпраќани статии на $1 за денес:',
	'stf_most_popular' => 'Најпопуларни статии на $1:',
	'stf_choose_from_existing' => 'Одберете од вашите постоечки контакти:',
	'stf_add_emails' => 'Додајте е-поштенски адреси:',
	'stf_your_email' => 'Вашиот услужник на е-пошта',
	'stf_your_login' => 'Вашето корисничко име',
	'stf_your_password' => 'Вашата лозинка',
	'stf_your_name' => 'Вашето име:',
	'stf_your_address' => 'Ваша е-поштенска адреса',
	'stf_your_friends' => 'Е-поштенски адреси на пријателот',
	'stf_we_dont_keep' => 'Ние не ја чуваме оваа е-пошта / лозинка',
	'stf_need_approval' => 'Не се испраќа е-пошта без ваша дозвола',
	'stf_message' => 'Порака',
	'stf_instructions' => '1. Одберете пријатели.|2. Кликнете на „$1“',
	'stf_select_all' => 'Избери сè',
	'stf_select_friends' => 'Одберете пријатели:',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'invitespecialpage' => 'Vrienden uitnodigen naar Wikia te komen',
	'sendtoafriend-desc' => '[[Special:InviteSpecialPage|Vrienden uitnodigen om bij Wikia te komen]]',
	'sendtoafriend-button-desc' => 'Geeft een knop "Deze pagina naar een vriend versturen" weer in pagina\'s',
	'stf_button' => 'Deze pagina naar een vriend versturen',
	'stf_after_reg' => '[[Special:InviteSpecialPage|Nodig een vriend uit bij Wikia!]]',
	'stf_subject' => '$2 heeft u een pagina van $1 gestuurd!',
	'stf_confirm' => 'Het bericht is verzonden.
Wilt u nog meer vrienden uitnodigen?',
	'stf_error' => 'Fout bij het sturen van de e-mail.',
	'stf_error_name' => 'U hebt uw naam niet opgegeven.',
	'stf_error_from' => 'U hebt uw e-mailadres niet opgegeven.',
	'stf_error_to' => 'U hebt het e-mailadres van uw vriend niet opgegeven.',
	'stf_frm1' => 'Uw e-mailadres:',
	'stf_frm2' => "E-mailadressen (meer dan 1? Scheid door komma's)",
	'stf_msg_label' => 'Te versturen bericht',
	'stf_name_label' => 'Uw naam',
	'stf_email_label' => 'Uw e-mailadres',
	'stf_frm3_send' => 'Hallo.

$1 dacht dat u deze pagina van Wikia wel zou kunnen waarderen!

$2

Ga er maar eens naar kijken!',
	'stf_frm3_invite' => 'Hallo!

Ik ben net bij deze wiki bij Wikia gekomen... $1

Ik nodig u van harte uit ook te komen kijken!',
	'stf_frm4_send' => 'Verzenden',
	'stf_frm4_cancel' => 'Annuleren',
	'stf_frm4_invite' => 'Uitnodiging verzenden!',
	'stf_multiemail' => 'Naar meer dan 1 ontvanger verzenden?',
	'stf_frm5' => 'De URL van deze website wordt toegevoegd aan uw bericht.',
	'stf_frm6' => 'Venster sluiten',
	'stf_throttle' => 'Om beveiligingsreden kunt u maar $1 {{PLURAL:$1|uitnodiging|uitnodigingen}} per dag verzenden.',
	'stf_abuse' => 'Deze e-mail is verzonden door $1 via Wikia.
Als u vindt dat deze onterecht is verzonden, laat ons dat dan weten via support@wikia.com.',
	'stf_ctx_invite' => "Meer dan één?
Scheid dan met komma's - maximaal $1!",
	'stf_ctx_check' => 'Contactpersonen controleren',
	'stf_ctx_empty' => 'U hebt geen contactpersonen voor deze gebruiker.',
	'stf_ctx_invalid' => 'De gebruikersnaam of het wachtwoord is onjuist.
Probeer het nog eens.',
	'stf_sending' => 'Even geduld alstublieft...',
	'stf_email_sent' => 'Bevestiging verzenden',
	'stf_back_to_article' => 'Terug naar pagina',
	'stf_most_emailed' => "Meest ge-e-mailde pagina's op $1 vandaag:",
	'stf_most_popular' => "Meest populaire pagina's op $1:",
	'stf_choose_from_existing' => 'Kies uit uw bestaande contactpersonen:',
	'stf_add_emails' => 'E-mailadressen toevoegen:',
	'stf_your_email' => 'Uw e-maildienst',
	'stf_your_login' => 'Uw gebruikersnaam',
	'stf_your_password' => 'Uw wachtwoord',
	'stf_your_name' => 'Uw naam',
	'stf_your_address' => 'Uw e-mailadres',
	'stf_your_friends' => 'E-mailadressen|van uw vrienden',
	'stf_we_dont_keep' => 'We bewaren deze e-mailadressen en/of het wachtwoord niet',
	'stf_need_approval' => 'Zonder uw toestemming worden geen e-mails verstuurd',
	'stf_message' => 'Bericht',
	'stf_instructions' => '1. Selecteer vrienden|2. Klik "$1"',
	'stf_select_all' => 'Alle selecteren',
	'stf_select_friends' => 'Selecteer vrienden:',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'invitespecialpage' => 'Inviter venner til å bli med i Wikia',
	'sendtoafriend-desc' => '[[Special:InviteSpecialPage|Inviter venner til å bli med i Wikia]]',
	'sendtoafriend-button-desc' => 'Viser en «Send til en venn»-knapp på sidene',
	'stf_button' => 'Send denne artikkelen til en venn',
	'stf_after_reg' => '[[Special:InviteSpecialPage|Inviter en venn til å bli med i Wikia!]]',
	'stf_subject' => '$2 har sendt deg en artikkel fra $1!',
	'stf_confirm' => 'Melding sendt! Inviter andre?',
	'stf_error' => 'Feil ved sending av e-post.',
	'stf_error_name' => 'Du oppga ikke navnet ditt.',
	'stf_error_from' => 'Du oppga ikke e-postadressen din.',
	'stf_error_to' => 'Du oppga ikke din venns e-postadresse.',
	'stf_frm1' => 'Din e-postadresse:',
	'stf_frm2' => 'E-postadresser (Mer enn én? Skill med komma)',
	'stf_msg_label' => 'Melding som skal sendes',
	'stf_name_label' => 'Ditt navn',
	'stf_email_label' => 'Din e-postadresse',
	'stf_frm3_send' => 'Hei!

$1 tenkte du ville like denne siden fra Wikia!

$2

Kom og sjekk den ut!',
	'stf_frm3_invite' => 'Hei!

Jeg har nettopp blitt med på denne Wikiaen... $1

Kom og sjekk den ut!',
	'stf_frm4_send' => 'Send',
	'stf_frm4_cancel' => 'Avbryt',
	'stf_frm4_invite' => 'Send invitasjon!',
	'stf_multiemail' => 'Send til mer enn en mottager?',
	'stf_frm5' => '(adressen til denne siden vil bli lagt ved meldingen din)',
	'stf_frm6' => 'Lukk dette vinduet',
	'stf_throttle' => 'Av sikkerhetsmessige årsaker kan du bare sende {{PLURAL:$1|én invitasjon|$1 invitasjoner}} per dag.',
	'stf_abuse' => 'Denne e-posten ble sendt av $1 via Wikia.
Hvis du tror den ble sendt ved en feil, vennligst si ifra til support@wikia.com.',
	'stf_ctx_invite' => 'Mer enn en? Separer med kommaer - opp til $1!',
	'stf_ctx_check' => 'Sjekk kontakter',
	'stf_ctx_empty' => 'Du har ingen kontakter på denne kontoen.',
	'stf_ctx_invalid' => 'Logg inn eller passordet du skrev er ugyldig. Vennligst forsøk igjen.',
	'stf_sending' => 'Vennligst vent...',
	'stf_email_sent' => 'Send bekreftelse',
	'stf_back_to_article' => 'Tilbake til artikkel',
	'stf_most_emailed' => 'Mest sendte artikler på $1 idag:',
	'stf_most_popular' => 'Mest populære artikler på $1:',
	'stf_choose_from_existing' => 'Velg fra dine eksisterende kontakter:',
	'stf_add_emails' => 'Legg til e-postadresser:',
	'stf_your_email' => 'Din e-posttjeneste',
	'stf_your_login' => 'Ditt logginnavn',
	'stf_your_password' => 'Ditt passord',
	'stf_your_name' => 'Ditt navn',
	'stf_your_address' => 'Din e-postadresse',
	'stf_your_friends' => 'Dine venners|e-postadresser',
	'stf_we_dont_keep' => 'Vi beholder ikke denne e-postadressen/dette passordet',
	'stf_need_approval' => 'Ingen e-poster blir sendt uten din godkjennelse',
	'stf_message' => 'Melding',
	'stf_instructions' => '|. Velg venner.|2. Klikk på «$1»',
	'stf_select_all' => 'Velg alle',
	'stf_select_friends' => 'Velg Venner:',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'stf_message' => 'Messatge',
	'stf_instructions' => "1. Seleccionatz d'amics.|2. Clicatz sus « $1 »",
	'stf_select_all' => 'Seleccionar tot',
	'stf_select_friends' => "Seleccionar d'amics :",
);

/** Polish (Polski)
 * @author Marcin Łukasz Kiejzik
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'invitespecialpage' => 'Zaproś znajomych do Wikii!',
	'stf_button' => 'Wyślij ten artykuł do znajomego',
	'stf_after_reg' => '[[Special:InviteSpecialPage|Zaproś znajomego do przyłączenia się do Wikii!]].',
	'stf_subject' => '$2 wysłał(a) Ci artykuł z $1!',
	'stf_confirm' => 'Zaproszenie wysłane! Zaprosić następnych?',
	'stf_error' => 'Błąd podczas wysyłania emaila.',
	'stf_error_name' => 'Nie podałeś swojego imienia.',
	'stf_error_from' => 'Nie podałeś swojego adresu email.',
	'stf_error_to' => 'Nie podałeś adresu email swojego przyjaciela.',
	'stf_frm1' => 'Twój adres email:',
	'stf_frm2' => 'Adres email znajomego (Chcesz wysłać kilka emaili? Rozdziel je przecinkami)',
	'stf_msg_label' => 'Wiadomość do wysłania',
	'stf_name_label' => 'Twoje imię',
	'stf_email_label' => 'Twój email',
	'stf_frm3_send' => 'Cześć!

$1 uważa, że spodoba Ci się ta strona na Wikii!

$2

Kliknij i zobacz!',
	'stf_frm3_invite' => 'Cześć!

Właśnie dołączyłem do tego wiki na Wikii...  $1

Wejdź i zobacz!',
	'stf_frm4_send' => 'Wyślij',
	'stf_frm4_cancel' => 'Anuluj',
	'stf_frm4_invite' => 'Zaproś!',
	'stf_multiemail' => 'Wysłać emaile na podane adresy?',
	'stf_frm5' => '(URL tej strony zostanie dołączony do Twojego tekstu)',
	'stf_frm6' => 'Zamknij to okienko',
	'stf_throttle' => 'Ze względów bezpieczeństwa możesz wysłać jedynie $1 {{PLURAL:$1|zaproszenie|zaproszenia|zaproszeń}} dziennie.',
	'stf_abuse' => 'Ten email został wysłany przez $1 z Wikii.
Jeśli uważasz, że nie powinien on do Ciebie trafić, daj nam znać na support@wikia.com.',
	'stf_ctx_invite' => 'Więcej niż jeden? Rozdziel przecinkami – aż do $1!',
	'stf_ctx_check' => 'Sprawdź Kontakty',
	'stf_ctx_empty' => 'Lista kontaktów tego konta jest pusta.',
	'stf_ctx_invalid' => 'Podany login lub hasło są nieprawidłowe. Proszę spróbować ponownie.',
	'stf_sending' => 'Proszę czekać...',
	'stf_email_sent' => 'Potwierdzenie wysyłki',
	'stf_back_to_article' => 'Wróć do artykułu',
	'stf_most_emailed' => 'Najczęściej wysyłane dziś artykuły na $1:',
	'stf_most_popular' => 'Najpopularniejsze artykuły na $1:',
	'stf_choose_from_existing' => 'Wybierz z istniejących kontaktów:',
	'stf_add_emails' => 'Dodaj adresy:',
	'stf_your_email' => 'Twoja usługa email',
	'stf_your_login' => 'Twój login',
	'stf_your_password' => 'Twoje hasło',
	'stf_your_name' => 'Twoje imię',
	'stf_your_address' => 'Twój adres email',
	'stf_your_friends' => 'Adresy email|Twoich przyjaciół',
	'stf_we_dont_keep' => 'Email i hasło nie są nigdzie zapisywane',
	'stf_need_approval' => 'Nic nie wyślemy bez Twojej zgody',
	'stf_message' => 'Wiadomość',
	'stf_instructions' => '1. Wybierz przyjaciół.|2. Kliknij "$1"',
	'stf_select_all' => 'Zaznacz wszystkich',
	'stf_select_friends' => 'Wybierz przyjaciół:',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'invitespecialpage' => "Anvité d'amis a intré an Wikia",
	'sendtoafriend-desc' => "[[Special:InviteSpecialPage|Anvité dj'amis a iscrivse a Wikia]]",
	'sendtoafriend-button-desc' => 'Mostré un boton "Spediss a n\'amis" ant je pàgine',
	'stf_button' => "Mandé st'artìcol-sì a n'amis",
	'stf_after_reg' => "[[Special:InviteSpecialPage|Anvita n'amis a intré an Wikia!]]",
	'stf_subject' => "$2 a l'ha mandate n'artìcol da $1!",
	'stf_confirm' => "Mëssagi mandà! Anvité d'àutri?",
	'stf_error' => 'Eror an mandand ël mëssagi.',
	'stf_error_name' => "A l'ha pa butà sò nòm.",
	'stf_error_from' => "A l'ha pa butà soa adrëssa ëd pòsta eletrònica.",
	'stf_error_to' => "A l'ha pa butà l'adrëssa ëd pòsta eletrònica ëd sò amis.",
	'stf_frm1' => 'Soa adrëssa ëd pòsta eletrònica:',
	'stf_frm2' => "Adrësse ëd pòsta eletrònica (Pi d'un-a? Ch'a-j separa con ëd vìrgole)",
	'stf_msg_label' => 'Mëssagi da mandé',
	'stf_name_label' => 'Tò nòm',
	'stf_email_label' => 'Soa adrëssa ëd pòsta eletrònica',
	'stf_frm3_send' => "Cerea!

$1 a l'ha pensà ch'at podrìa piasèj sta pàgina da Wikia!

$2

Ven a vëdd-la!",
	'stf_frm3_invite' => 'Cerea!

I son pen-a gionzume a costa wiki su Wikia ... $1

Ven a vëdd-la!',
	'stf_frm4_send' => 'Manda',
	'stf_frm4_cancel' => 'Scancelé',
	'stf_frm4_invite' => 'Manda Anvit!',
	'stf_multiemail' => "Mandé a pi d'un destinatari?",
	'stf_frm5' => "(l'adrëssa dë sto sit-sì a sarà gionzùa a sò messagi)",
	'stf_frm6' => 'Saré sta fnestra-sì',
	'stf_throttle' => 'Për rason ëd sicurëssa, it peule mach mandé $1 {{PLURAL:$1|anvit|anvit}} për di.',
	'stf_abuse' => "Cost mëssagi a l'é stàit mandà da $1 via Wikia.
S'a pensa ch'a sia stàit mandà për eror, për piasì ch'an lo fasa savèj a support@wikia.com.",
	'stf_ctx_invite' => "Pi d'un? Ch'a-j separa con ëd vìrgole - fin-a a $1!",
	'stf_ctx_check' => 'Contròla Contat',
	'stf_ctx_empty' => "It l'has pa gnun contat an sto cont-sì.",
	'stf_ctx_invalid' => "Ël nòm o la ciav ch'a l'ha scrivù a son pa bon. Për piasì, ch'a preuva torna.",
	'stf_sending' => 'Për piasì speta...',
	'stf_email_sent' => 'Manda conferma',
	'stf_back_to_article' => "André a l'artìcol",
	'stf_most_emailed' => 'Artìcoj pì mandà su $1 ancheuj:',
	'stf_most_popular' => 'Artìcoj pi popolar su $1:',
	'stf_choose_from_existing' => 'Sern daj tò contat esistent:',
	'stf_add_emails' => "Gionté dj'adrësse ëd pòsta eletrònica:",
	'stf_your_email' => 'Sò servissi ëd pòsta eletrònica',
	'stf_your_login' => 'Tò Nòm per intré',
	'stf_your_password' => 'Toa Ciav',
	'stf_your_name' => 'Tò nòm',
	'stf_your_address' => 'Soa adrëssa ëd pòsta eletrònica',
	'stf_your_friends' => 'Adrësse ëd pòsta eletrònica|dij sò amis',
	'stf_we_dont_keep' => 'I goernoma pa costa adrëssa o ciav',
	'stf_need_approval' => 'Gnun mëssagi mandà sensa toa aprovassion',
	'stf_message' => 'Mëssagi',
	'stf_instructions' => '1. Selession-a amis.|2. Sgnaca "$1"',
	'stf_select_all' => 'Selession-a tut',
	'stf_select_friends' => 'Selession-a Amis:',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'stf_name_label' => 'ستاسې نوم',
	'stf_email_label' => 'ستاسې برېښليک',
	'stf_frm4_send' => 'لېږل',
	'stf_your_name' => 'ستاسې نوم',
	'stf_message' => 'پيغام',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'invitespecialpage' => 'Convidar amigos a juntar-se à Wikia',
	'sendtoafriend-desc' => '[[Special:InviteSpecialPage|Convidar amigos a juntar-se à Wikia]]',
	'sendtoafriend-button-desc' => 'Apresenta nas páginas um botão "Enviar a um amigo"',
	'stf_button' => 'Enviar esta página a um amigo',
	'stf_after_reg' => '[[Special:InviteSpecialPage|Convide um amigo a juntar-se à Wikia!]]',
	'stf_subject' => '$2 enviou-lhe uma página da $1!',
	'stf_confirm' => 'Mensagem enviada! Convidar outros?',
	'stf_error' => 'Erro ao enviar mensagem.',
	'stf_error_name' => 'Não introduziu o seu nome.',
	'stf_error_from' => 'Não introduziu o seu endereço de correio electrónico.',
	'stf_error_to' => 'Não introduziu o endereço de correio electrónico do seu amigo.',
	'stf_frm1' => 'O seu correio electrónico:',
	'stf_frm2' => 'Endereços de correio electrónico (Mais do que um? Separe-os usando vírgulas)',
	'stf_msg_label' => 'Mensagem para enviar',
	'stf_name_label' => 'O seu nome',
	'stf_email_label' => 'O seu correio electrónico',
	'stf_frm3_send' => 'Olá!

$1 achou que gostaria desta página da Wikia!

$2

Venha vê-la!',
	'stf_frm3_invite' => 'Olá!

Acabei de inscrever-me nesta wiki da Wikia...  $1

Vem cá vê-la!',
	'stf_frm4_send' => 'Enviar',
	'stf_frm4_cancel' => 'Cancelar',
	'stf_frm4_invite' => 'Enviar convite!',
	'stf_multiemail' => 'Enviar a mais do que um destinatário?',
	'stf_frm5' => '(a URL deste site será acrescentada à sua mensagem)',
	'stf_frm6' => 'Fechar esta janela',
	'stf_throttle' => 'Por razões de segurança, só pode enviar $1 {{PLURAL:$1|convite|convites}} por dia.',
	'stf_abuse' => 'Esta mensagem foi enviada por $1 através da Wikia.
Se acha que ela foi enviada por engano, informe-nos em support@wikia.com.',
	'stf_ctx_invite' => 'Mais do que um? Separe-os usando vírgulas - máx. $1!',
	'stf_ctx_check' => 'Verificar contactos',
	'stf_ctx_empty' => 'Não tem contactos nesta conta.',
	'stf_ctx_invalid' => 'O utilizador ou palavra-chave que introduziu são inválidos. Tente novamente, por favor.',
	'stf_sending' => 'Aguarde, por favor...',
	'stf_email_sent' => 'Enviar confirmação',
	'stf_back_to_article' => 'Voltar à página',
	'stf_most_emailed' => 'Páginas mais enviadas na $1 hoje:',
	'stf_most_popular' => 'Páginas mais populares da $1:',
	'stf_choose_from_existing' => 'Escolha dos seus contactos:',
	'stf_add_emails' => 'Adicionar endereços de correio electrónico:',
	'stf_your_email' => 'O seu serviço de correio electrónico',
	'stf_your_login' => 'O seu nome de utilizador',
	'stf_your_password' => 'A sua palavra-chave',
	'stf_your_name' => 'O seu nome',
	'stf_your_address' => 'O seu correio electrónico',
	'stf_your_friends' => 'O correio-e|do seu amigo',
	'stf_we_dont_keep' => 'Não guardamos este correio electrónico e palavra-chave',
	'stf_need_approval' => 'Não serão enviadas mensagens sem a sua aprovação',
	'stf_message' => 'Mensagem',
	'stf_instructions' => '1. Seleccione amigos.|2. Clique "$1"',
	'stf_select_all' => 'Seleccionar todos',
	'stf_select_friends' => 'Seleccionar amigos:',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Jesielt
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'invitespecialpage' => 'Convide amigos para se juntar ao Wikia',
	'sendtoafriend-desc' => '[[Special:InviteSpecialPage|Convide amigos para se juntar ao Wikia]]',
	'stf_button' => 'Envie este artigo para um amigo',
	'stf_after_reg' => '[[Special:InviteSpecialPage|Convide um amigo para se juntar ao Wikia!]]',
	'stf_subject' => '$2 lhe enviou um artigo de $1!',
	'stf_confirm' => 'Sua mensagem foi enviada! Deseja convidar mais alguém?',
	'stf_error' => 'Ocorreu um no envio do e-mail.',
	'stf_error_name' => 'Você não forneceu seu nome.',
	'stf_error_from' => 'Você não forneceu seu endereço de email.',
	'stf_error_to' => 'Você não forneceu os endereços de email dos seus amigos.',
	'stf_frm1' => 'Seu endereço de email:',
	'stf_frm2' => 'Endereços de email (Mais do que um? Separe-os com vírgulas.)',
	'stf_msg_label' => 'Mensagem a ser enviada',
	'stf_name_label' => 'Seu nome',
	'stf_email_label' => 'Seu email',
	'stf_frm3_send' => 'Olá!

O(A) $1 acha que você vai gostar dessa página do Wikia!

$2

Dê uma olhada!',
	'stf_frm3_invite' => 'Olá!

Eu acabei de me juntar a esse wiki no Wikia...  $1

Dê uma olhada!',
	'stf_frm4_send' => 'Enviar',
	'stf_frm4_cancel' => 'Cancelar',
	'stf_frm4_invite' => 'Enviar convite!',
	'stf_multiemail' => 'Enviar para mais de uma pessoa?',
	'stf_frm5' => '(o endereço desse site irá ser colocado na sua mensagem)',
	'stf_frm6' => 'Feche essa janela',
	'stf_throttle' => 'Por motivos de segurança, você só pode enviar $1 {{PLURAL:$1|convite|convites}} por dia.',
	'stf_abuse' => 'Este email foi enviado por $1 via Wikia.
Se você acha que essa mensagem foi enviada errada, por favor, nos avise pelo email support@wikia.com .',
	'stf_ctx_empty' => 'Você não tem contatos nessa conta.',
	'stf_ctx_invalid' => 'O Login ou a senha que você digitou está errada. Por favor, tente novamente.',
	'stf_sending' => 'Por favor, aguarde...',
	'stf_email_sent' => 'Enviar confirmação',
	'stf_back_to_article' => 'Volte ao artigo',
	'stf_your_password' => 'Sua senha',
	'stf_your_name' => 'Seu nome',
);

/** Russian (Русский)
 * @author Lockal
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'invitespecialpage' => 'Пригласите друзей присоединиться к Викии',
	'sendtoafriend-desc' => '[[Special:InviteSpecialPage|Пригласите друзей присоединиться к Wikia]]',
	'sendtoafriend-button-desc' => 'Отображение на страницах кнопки «Отправить другу»',
	'stf_button' => 'Отправить эту статью другу',
	'stf_after_reg' => '[[Special:InviteSpecialPage|Пригласить друга присоединиться к Wikia!]]',
	'stf_subject' => '$2 отправил вам статью из $1!',
	'stf_confirm' => 'Сообщение отправлено! Пригласить других друзей?',
	'stf_error' => 'Ошибка при отправке письма.',
	'stf_error_name' => 'Вы не указали своё имя.',
	'stf_error_from' => 'Вы не указали свой адрес электронной почты.',
	'stf_error_to' => 'Вы не указали адрес электронной почты вашего друга.',
	'stf_frm1' => 'Ваш адрес электронной почты:',
	'stf_frm2' => 'Адреса электронной почты (Более одного? Разделяйте запятыми)',
	'stf_msg_label' => 'Сообщение для отправки',
	'stf_name_label' => 'Ваше имя',
	'stf_email_label' => 'Ваш адрес эл. почты',
	'stf_frm3_send' => 'Привет!

$1 считает, что вам понравится эта страница из проекта Wikia!

$2

Заходите посмотреть!',
	'stf_frm3_invite' => 'Привет!

Я только что зарегистрировался в этой вики на Wikia… $1

Заходи посмотреть!',
	'stf_frm4_send' => 'Отправить',
	'stf_frm4_cancel' => 'Отменить',
	'stf_frm4_invite' => 'Отправить приглашение!',
	'stf_multiemail' => 'Отправить более чем одному адресату?',
	'stf_frm5' => '(адрес этого сайта будет добавлен к вашему сообщению)',
	'stf_frm6' => 'Закрыть это окно',
	'stf_throttle' => 'По соображениям безопасности, вы можете отправить не более $1 {{PLURAL:$1|приглашения|приглашений|приглашений}} в день.',
	'stf_abuse' => 'Это письмо было отправлено пользователем $1 из Wikia.
Если вы считаете, что оно было отправлено по ошибке, пожалуйста, дайте нам знать по адресу support@wikia.com.',
	'stf_ctx_invite' => 'Больше чем один? Разделяйте запятыми — всего до $1!',
	'stf_ctx_check' => 'Просмотреть контакты',
	'stf_ctx_empty' => 'В этой учётной записи у вас нет контактов.',
	'stf_ctx_invalid' => 'Указан неправильный логин или пароль. Пожалуйста, попробуйте ещё раз.',
	'stf_sending' => 'Пожалуйста, подождите…',
	'stf_email_sent' => 'Отправить подтверждение',
	'stf_back_to_article' => 'Вернуться к статье',
	'stf_most_emailed' => 'Наиболее часто отправляемые статьи на $1 сегодня:',
	'stf_most_popular' => 'Самые популярные статьи на $1:',
	'stf_choose_from_existing' => 'Выберите один из существующих контактов:',
	'stf_add_emails' => 'Добавление электронных адресов:',
	'stf_your_email' => 'Ваша почтовая служба',
	'stf_your_login' => 'Ваш логин',
	'stf_your_password' => 'Ваш пароль',
	'stf_your_name' => 'Ваше имя',
	'stf_your_address' => 'Ваш адрес электронной почты',
	'stf_your_friends' => 'Адреса|ваших друзей',
	'stf_we_dont_keep' => 'Мы не сохраняем эти адрес электронной почты и пароль',
	'stf_need_approval' => 'Без вашего согласия письма отправляться не будут',
	'stf_message' => 'Сообщение',
	'stf_instructions' => '1. Выберите друзей.|2. Нажмите «$1»',
	'stf_select_all' => 'Выбрать всех',
	'stf_select_friends' => 'Выбрать друзей:',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Verlor
 */
$messages['sr-ec'] = array(
	'invitespecialpage' => 'пОзови своје пријатеље да се придруже Викији',
	'sendtoafriend-desc' => '[Special:InviteSpecialPage|Позови пријатеље да се придруже викији]]',
	'sendtoafriend-button-desc' => 'Показује "Пошаљи пријатељу" дугме на страницама',
	'stf_button' => 'Пошаљи овај чланак пријатељу',
	'stf_after_reg' => '[Special:InviteSpecialPage|Позови пријатеља да се придружи викији!]]',
	'stf_subject' => '$2 вам је послао чланак од $1!',
	'stf_confirm' => 'Порука послана! Позивате друге!',
	'stf_error' => 'Грешка при слању е-поште',
	'stf_error_name' => 'Нисте назначили своје име',
	'stf_error_from' => 'Нисте дали своју адресу е-поште',
	'stf_error_to' => 'Нисте означили адресу е-поште вашег пријатеља',
	'stf_frm1' => 'Ваша адреса е-поште',
	'stf_frm2' => 'Адресе е-поште (више од једне? Раздвојите их зарезом)',
	'stf_msg_label' => 'Порука коју треба послати',
	'stf_name_label' => 'Ваше име',
	'stf_email_label' => 'Ваш мејл',
	'stf_frm3_send' => 'Здраво!

$1 мисли да би ти желео ову страну са Викије!

$2

Дођи и види!',
	'stf_frm4_send' => 'Пошаљи',
	'stf_frm4_cancel' => 'Одустани',
	'stf_frm4_invite' => 'ПОшаљи позив!',
	'stf_multiemail' => 'Пошаљи ово на више пошиљалаца?',
	'stf_frm6' => 'Затвори овај прозор',
	'stf_abuse' => 'Ову е-пошту послао је  $1 преко Викије-
Ако мислите да је погрешно послано, можете да нам дате то до знања на support@wikia.com.',
	'stf_ctx_check' => 'Провери контакте',
	'stf_ctx_invalid' => 'Корисничко име или лозинка коју сте унели није исправна. Молимо покушајте поново!',
	'stf_sending' => 'Молим сачекајте ...',
	'stf_email_sent' => 'Пошаљи потврду',
	'stf_back_to_article' => 'натраг на чланак',
	'stf_most_popular' => 'Најпопуларнији чланци на $1:',
	'stf_choose_from_existing' => 'Изаберите из ваших постојећих контаката:',
	'stf_add_emails' => 'Додај адресу е-поште',
	'stf_your_login' => 'Ваше корисничко име (логин)',
	'stf_your_password' => 'Ваша лозинка',
	'stf_your_name' => 'Ваше име',
	'stf_your_address' => 'Адреса е-поште',
	'stf_need_approval' => 'Не шаље се е.пошта без вашег одобрења',
	'stf_message' => 'Порука',
	'stf_instructions' => '1. Изаберите пријатеље.|2. Кликните "$1"',
	'stf_select_all' => 'Изабери све',
	'stf_select_friends' => 'Означи пријатеље',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'stf_name_label' => 'మీ పేరు',
);

/** Chinese (中文) */
$messages['zh'] = array(
	'invitespecialpage' => '邀請朋友加入Wikia',
);

/** Chinese (China) (‪中文(中国大陆)‬) */
$messages['zh-cn'] = array(
	'invitespecialpage' => '邀請朋友加入Wikia',
	'stf_frm4_cancel' => '取消',
	'stf_back_to_article' => '返回文章',
);

/** Simplified Chinese (‪中文(简体)‬) */
$messages['zh-hans'] = array(
	'stf_frm4_cancel' => '取消',
	'stf_back_to_article' => '返回文章',
);

/** Traditional Chinese (‪中文(繁體)‬) */
$messages['zh-hant'] = array(
	'stf_frm4_cancel' => '取消',
	'stf_back_to_article' => '返回文章',
);

/** Chinese (Hong Kong) (‪中文(香港)‬) */
$messages['zh-hk'] = array(
	'invitespecialpage' => '邀請朋友加入Wikia',
	'stf_frm4_cancel' => '取消',
	'stf_back_to_article' => '返回文章',
);

/** Chinese (Taiwan) (‪中文(台灣)‬) */
$messages['zh-tw'] = array(
	'invitespecialpage' => '邀請朋友加入Wikia',
	'stf_frm4_cancel' => '取消',
	'stf_back_to_article' => '返回文章',
);

