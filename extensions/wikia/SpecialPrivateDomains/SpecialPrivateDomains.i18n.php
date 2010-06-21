<?php
/**
 * Internationalisation file for WikiFactory extension.
 *
 * @addtogroup Languages
 */

$messages = array();

$messages['en'] = array(
	'privatedomains_nomanageaccess' => "Sorry, you do not have enough rights to manage the allowed private domains for this wiki. Only wiki bureaucrats and staff members have access.</p><p>If you are not logged in, you probably [[Special:Userlogin|should]].",
	'privatedomains' =>  'Manage Private Domains',
	'privatedomains_ifemailcontact' => "Otherwise, please contact [[Special:EmailUser/$1|$1]] if you have any questions.",
	'saveprivatedomains_success' => "Private Domains changes saved.",
	'privatedomains_invalidemail' => "Sorry, access to this wiki is restricted to members of $1. If you have an e-mail address affiliated with $1, you can enter or reconfirm your e-mail address on your account preference page [[Special:Preferences|here]]. You can still view pages on this wiki, but you will be unable to edit.",
	'privatedomains_affiliatenamelabel' => "Name of organization:",
	'privatedomains_emailadminlabel' => "Contact username for access problems or queries:",
	'privatedomainsinstructions' => "Below is the list of e-mail domains allowed for editors of this wiki. Each line designates an e-mail suffix that is given access for editing. This should be formatted with one suffix per line. For example:</p><p style=\"width: 20%; padding:5px; border: 1px solid grey;\">cs.stanford.edu<br /> stanfordalumni.org</p><p>This would allow edits from anyone with the e-mail address whatever@cs.stanford.edu or whatever@stanfordalumni.org</p><p><b>Enter the allowed domains in the text box below, and click \"{{int:saveprefs}}\".</b>"
);

/** Message documentation (Message documentation)
 * @author Siebrand
 */
$messages['qqq'] = array(
	'privatedomains_affiliatenamelabel' => 'Leading newline does not make sense. Consider hardcoding it.',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'privatedomains' => 'Bestuur private domeine',
	'saveprivatedomains_success' => 'Die wysigings aan privaatdomeine is gestoor.',
	'privatedomains_affiliatenamelabel' => 'Naam van organisasie:',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'privatedomains_nomanageaccess' => "Выбачайце, Вы ня маеце правоў для кіраваньня дазволенымі ўласнымі дамэнамі ў {{GRAMMAR:месны|{{SITENAME}}}}. Маюць доступ толькі бюракраты і супрацоўнікі.</p><p>Калі вы не ўвайшлі ў сыстэму, Вам, магчыма, [[Special:Userlogin|трэба ўвайсьці]].",
	'privatedomains' => 'Кіраваньне ўласнымі дамэнамі',
	'privatedomains_ifemailcontact' => 'У іншым выпадку, калі ласка, зьвярніцеся да [[Special:EmailUser/$1|$1]], калі Вы маеце якія-небудзь пытаньні.',
	'saveprivatedomains_success' => 'Зьмены ў прыватных дамэнах захаваныя.',
	'privatedomains_invalidemail' => 'Прабачце, доступ да {{GRAMMAR:родны|{{SITENAME}}}} забаронены для ўдзельнікаў $1. Калі Вы маеце адрас электроннай пошты зьвязаны з $1, Вы можаце ўвесьці альбо перапацьвердзіць Ваш адрас электроннай пошты на старонцы Вашых установак [[Special:Preferences|тут]]. Вы можаце праглядаць старонкі {{GRAMMAR:родны|{{SITENAME}}}}, але ня можаце іх рэдагаваць.',
	'privatedomains_affiliatenamelabel' => 'Назва арганізацыі:',
	'privatedomains_emailadminlabel' => 'Кантактнае імя ўдзельніка для праблемаў уваходу альбо запытаў:',
	'privatedomainsinstructions' => 'Ніжэй пададзены сьпіс паштовых дамэнаў дазволеных для рэдактараў {{GRAMMAR:родны|{{SITENAME}}}}. Кожны радок вызначае суфікс адрасу электроннай пошты, які дазваляе доступ да рэдагаваньня. Ён павінен мець выгляд: адзін суфікс на радок. Напрыклад: </p><p style="width: 20%; padding:5px; border: 1px solid grey;">cs.stanford.edu<br /> stanfordalumni.org</p><p>Гэта дазволіць рэдагаваньне толькі удзельнікам з адрасам электроннай пошты whatever@cs.stanford.edu альбо whatever@stanfordalumni.org</p><p><b>Увядзіце дазволеныя дамэны ў тэкставае поле ніжэй і націсьніце «Захаваць».</b>',
);

/** Breton (Brezhoneg)
 * @author Gwenn-Ael
 */
$messages['br'] = array(
	'privatedomains_nomanageaccess' => "Ma digarezit,  n'ho peus ket gwirioù a-walc'h evit merañ domanioù prevez ar wiki-mañ. N'eus nemet ar vurevourien hag izili ar c'hoskor a c'hall mont warnañ.</p><p> Ma n'oc'h ket kevreet, ret e vefe deoc'h [[Special:Userlogin|kevreañ]] marteze.",
	'privatedomains' => 'Merañ an domanioù prevez',
	'privatedomains_ifemailcontact' => "Anez, kit e darempred gant [[Special:EmailUser/$1|$1]]  m'ho peus goulenn pe c'houlenn.",
	'saveprivatedomains_success' => 'Kemmoù en domanioù prevez saveteet.',
	'privatedomains_invalidemail' => "Ma digarezit, Miret eo ar moned d'ar wiki-mañ evit izili $1.  M'ho peus ur chomlec'h postel emezelet ouzh $1 e challit mont e-barzh pe adkarnaat ho chomlec'h postel war pajenn zibaboù ar gont [[Special:Dibaboù|amañ]]. Gallout a rit gwelet pajennoù ar wiki-mañ, met ne c'hallit ket kemmañ anezho.",
	'privatedomains_affiliatenamelabel' => 'Anv an aozadur :',
	'privatedomains_emailadminlabel' => "Anv implijer an darempred m'ho peus kudennoù mont pe rekedoù :",
	'privatedomainsinstructions' => 'Diskwelet eo roll domanioù ar chomlec\'hioù postel zo aotreet evit embannerien ar wiki-mañ. Pep linenn a ziskouez ur rakverk postel a ro tro d\'an embannerien da vont warno. Furmadet e tle ar roll  bezañ gant ur rakverk dre linenn. Da skouer,  :</p><p style="width: 20%; padding:5px; border: 1px solid grey;">cs.stanford.edu<br /> stanfordalumni.org</p><p>p>This would allow edits from anyone with the email address whatever@cs.stanford.edu or whatever@stanfordalumni.org</p><p><b>Ebarzhit roll an domanioù aotreet er voest amañ amañ dindan ha klikit war « saveteiñ».</b>',
);

/** German (Deutsch)
 * @author LWChris
 * @author The Evil IP address
 */
$messages['de'] = array(
	'privatedomains_nomanageaccess' => "Sorry, du hast nicht genügend Rechte, um die erlaubten privaten Domains für dieses Wiki zu verwalten. Nur Wiki Bürokraten und Mitarbeiter haben Zugang.</p><p>Wenn du nicht eingeloggt bist, solltest du das wahrscheinlich [[Special:Userlogin|machen]].",
	'privatedomains' => 'Private Domains verwalten',
	'privatedomains_ifemailcontact' => 'Andernfalls wende dich bitte an [[Special:EmailUser/$1|$1]] falls du Fragen hast.',
	'saveprivatedomains_success' => 'Änderungen an privaten Domains gespeichert.',
	'privatedomains_invalidemail' => 'Tut uns leid, aber der Zugang zu diesem Wiki ist auf Mitglieder von $1 beschränkt. Wenn du eine E-Mail-Adresse von $1 besitzt, kannst du es betreten, oder bestätige deine E-Mail Adresse in deinen Konteneinstellungen [[Special:Preferences|hier]]. Du kannst weiterhin Seiten in diesem Wiki ansehen, wirst sie aber nicht bearbeiten können.',
	'privatedomains_affiliatenamelabel' => 'Name der Organisation:',
	'privatedomains_emailadminlabel' => 'Kontakt-Benutzername bei Zugangsproblemen oder Fragen:',
	'privatedomainsinstructions' => 'Unten ist die Liste der erlaubten E-Mail-Domains für Editoren dieses Wikis. Jede Zeile bezeichnet einen E-Mail-Suffix, dem Bearbeitungen erlaubt werden. Dies sollte mit einem Suffix pro Zeile formatiert werden. Zum Beispiel:</p><p style="width: 20%; padding:5px; border: 1px solid grey;"> cs.stanford.edu<br /> stanfordalumni.org</p><p>Dies würde Bearbeitungen von jedem mit der E-Mail-Adresse whatever@cs.stanford.edu oder whatever@stanfordalumni.org erlauben.</p><p><b>Gib die erlaubten Domains in das Textfeld unterhalb ein und klicke auf „{{int:saveprefs}}“.</b>',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author LWChris
 * @author The Evil IP address
 */
$messages['de-formal'] = array(
	'privatedomains_nomanageaccess' => "Entschuldigung, Sie haben nicht genügend Rechte, um die erlaubten privaten Domains für dieses Wiki zu verwalten. Nur Wiki Bürokraten und Mitarbeiter haben Zugang.</p><p>Wenn Sie nicht eingeloggt sind, sollten Sie dies wahrscheinlich [[Special:Userlogin|machen]].",
	'privatedomains_ifemailcontact' => 'Andernfalls wenden Sie sich bitte an [[Special:EmailUser/$1|$1]] falls Sie Fragen haben.',
	'privatedomains_invalidemail' => 'Tut uns leid, aber der Zugang zu diesem Wiki ist auf Mitglieder von $1 beschränkt. Wenn Sie eine E-Mail-Adresse von $1 besitzen, können Sie es betreten, oder bestätigen Sie Ihre E-Mail Adresse in Ihren Konteneinstellungen [[Special:Preferences|hier]]. Sie können weiterhin Seiten in diesem Wiki ansehen, werden sie aber nicht bearbeiten können.',
	'privatedomainsinstructions' => 'Unten ist die Liste der erlaubten E-Mail-Domains für Editoren dieses Wikis. Jede Zeile bezeichnet einen E-Mail-Suffix, dem Bearbeitungen erlaubt werden. Dies sollte mit einem Suffix pro Zeile formatiert werden. Zum Beispiel:</p><p style="width: 20%; padding:5px; border: 1px solid grey;"> cs.stanford.edu<br /> stanfordalumni.org</p><p>Dies würde Bearbeitungen von jedem mit der E-Mail-Adresse whatever@cs.stanford.edu oder whatever@stanfordalumni.org erlauben.</p><p><b>Geben Sie die erlaubten Domains in das Textfeld unterhalb ein und klicken Sie auf „{{int:saveprefs}}“.</b>',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Pertile
 */
$messages['es'] = array(
	'privatedomains_nomanageaccess' => "Lo sentimos, no tiene los privilegios suficientes para administrar los dominios privados permitidos para esta wiki. Solamente los burócratas wiki y los miembros del personal tienen acceso.</p><p>Si no accedió al sistema, probablemente [[Special:Userlogin|debería hacerlo]].",
	'privatedomains' => 'Administrar Dominios Privados',
	'privatedomains_ifemailcontact' => 'En caso contrario, póngase en contacto con [[Special:EmailUser/$1|$1]] por cualquier consulta.',
	'saveprivatedomains_success' => 'Se guardaron los cambios en los Dominios Privados.',
	'privatedomains_invalidemail' => 'Lo sentimos, el acceso a esta wiki está restringido a los miembros de $1. Si posee una cuenta de correo electrónico afiliada a $1, puede ingresarla o volver a confirmar su dirección de correo electrónico en la página de preferencias de su cuenta [[Special:Preferences|aquí]]. Todavía puede ver las páginas en esta wiki, pero no podrá editarlas.',
	'privatedomains_affiliatenamelabel' => 'Nombre de la organización:',
	'privatedomains_emailadminlabel' => 'Nombre de usuario del contacto para problemas o consultas:',
	'privatedomainsinstructions' => 'A continuación se presenta la lista de dominios de correo electrónico permitidos para los editores de esta wiki. Cada línea designa un sufijo de correo electrónico que puede editar en esta wiki. Esta debería tener un formato de un sufijo por línea. Por ejemplo:</p><p style="width: 20%; padding:5px; border: 1px solid grey;">cs.stanford.edu<br /> stanfordalumni.org</p><p>El ejemplo anterior debería permitir las ediciones de alguien cuya dirección de correo sea loquesea@cs.stanford.edu o loquesea@stanfordalumni.org</p><p><b>Ingrese los dominios permitidos en el cuadro de texto que se muestra debajo y haga clic en "{{int:saveprefs}}".</b>',
);

/** Finnish (Suomi)
 * @author Centerlink
 */
$messages['fi'] = array(
	'privatedomains' => 'Hallinnoi yksityisiä verkkoalueita',
	'privatedomains_ifemailcontact' => 'Muussa tapauksessa, ota yhteys [[Special:EmailUser/$1|$1]], jos sinulla on kysyttävää.',
	'saveprivatedomains_success' => 'Yksityisen verkkoalueen muutokset on tallennettu.',
	'privatedomains_affiliatenamelabel' => 'Organisaation nimi:',
	'privatedomains_emailadminlabel' => 'Yhteystietokäyttäjänimi pääsypulmissa tai kyselyissä:',
);

/** French (Français)
 * @author IAlex
 */
$messages['fr'] = array(
	'privatedomains_nomanageaccess' => "Désolé, vous n'avez les droits suffisants pour gérer les domaines privés de ce wiki. Seuls les bureaucrates et les membres du personnel y ont accès.</p><p>Si vous n'êtes pas connecté, vous devriez probablement [[Special:Userlogin|vous connecter]].",
	'privatedomains' => 'Gérer les domaines privés',
	'privatedomains_ifemailcontact' => 'Sinon, veuillez contacter [[Special:EmailUser/$1|$1]] si vous avec une question.',
	'saveprivatedomains_success' => 'Modifications dans les domaines privés sauvegardés.',
	'privatedomains_invalidemail' => "Désolé, l'accès à ce wiki est réservé aux membre de $1. Si vos avez une adresse de courriel affiliée avec $1, vous pouvez entrer ou reconfirmer votre adresse de courriel dans sur la page de préférences du compte [[Special:Preferences|ici]]. Vous pouvez toujours voir les pages de ce wiki, mais vous ne pouvez pas le modifier.",
	'privatedomains_affiliatenamelabel' => "Nom de l'organisation :",
	'privatedomains_emailadminlabel' => "Nom d'utilisateur du contact pour des problèmes d'accès ou requêtes :",
	'privatedomainsinstructions' => 'La liste des domaines des adresses de courriel autorisées pour les éditeurs de ce wiki est affichée ci-dessous. Chaque ligne désigne un suffixe d\'adresse de courriel qui donne accès aux éditeurs. La liste doit être formatée avec un suffixe par ligne. Par exemple :</p><p style="width: 20%; padding:5px; border: 1px solid grey;">cs.stanford.edu<br /> stanfordalumni.org</p><p>Ceci permettra à toutes les personnes ayant une adresse de courriel se terminant par « @cs.stanford.edu » et  « @stanfordalumni.org » de modifier le wiki.</p><p><b>Entrez la liste des domaines autorisés dans la boîte ci-dessous et cliquez sur « {{int:saveprefs}} ».</b>',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'privatedomains_nomanageaccess' => "Sentímolo, non ten os dereitos necesarios para xestionar os dominios privados deste wiki. Só os burócratas do wiki e os membros do persoal teñen acceso.</p><p>Se non accedeu ao sistema, probabelmente [[Special:Userlogin|debería facelo.",
	'privatedomains' => 'Xestionar os dominios privados',
	'privatedomains_ifemailcontact' => 'Se non, póñase en contacto con [[Special:EmailUser/$1|$1]] se ten algunha dúbida.',
	'saveprivatedomains_success' => 'Gardáronse os cambios feitos nos dominios privados.',
	'privatedomains_invalidemail' => 'Sentímolo, o acceso a este wiki está restrinxido aos membros de $1. Se ten un enderezo de correo electrónico afiliado con $1, pode entrar ou volver confirmar o seu enderezo de correo electrónico na páxina de preferencias da súa conta [[Special:Preferences|aquí]]. Aínda pode ver páxinas neste wiki, pero non será capaz de editalas.',
	'privatedomains_affiliatenamelabel' => 'Nome da organización:',
	'privatedomains_emailadminlabel' => 'Nome de usuario de contacto para os problemas de acceso ou dúbidas:',
	'privatedomainsinstructions' => 'A continuación está a lista cos dominios de correo electrónico autorizados para os editores deste wiki. Cada liña designa un sufixo que dá acceso á edición. A lista debe estar ordenada de xeito que haxa un sufixo por liña. Por exemplo:</p><p style="width: 20%; padding:5px; border: 1px solid grey;">cs.stanford.edu<br /> stanfordalumni.org</p><p>Isto permitirá as edicións daqueles usuarios que teñan un enderezo de correo electrónico o_que_sexa@cs.stanford.edu ou o_que_sexa@stanfordalumni.org</p><p><b>Insira os dominios autorizados no cadro de texto de embaixo e prema en "{{int:saveprefs}}".</b>',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'privatedomains' => 'Privát tartományok kezelése',
	'privatedomains_affiliatenamelabel' => 'Szervezet neve:',
	'privatedomains_emailadminlabel' => 'Kapcsolattartó neve hozzáférési problémák vagy kérdések esetére:',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'privatedomains_nomanageaccess' => "Pardono, tu non ha le derectos necessari pro gerer le dominios private de iste wiki. Solmente le bureaucrates del wiki e le personal ha accesso.</p><p>Si tu non ha aperite un session, tu deberea probabilemente [[Special:Userlogin|facer lo]].",
	'privatedomains' => 'Gerer dominios private',
	'privatedomains_ifemailcontact' => 'Si non, contacta [[Special:EmailUser/$1|$1]] si tu ha alcun questiones.',
	'saveprivatedomains_success' => 'Le alterationes in le dominios private ha essite salveguardate.',
	'privatedomains_invalidemail' => 'Pardono, le accesso a iste wiki es restringite al membros de $1. Si tu ha un adresse de e-mail affiliate con $1, tu pote entrar o reconfirmar tu adresse de e-mail in [[Special:Preferences|le pagina de preferentias de tu conto]]. Tu pote vider paginas in iste wiki, ma non modificar los.',
	'privatedomains_affiliatenamelabel' => 'Nomine del organisation:',
	'privatedomains_emailadminlabel' => 'Nomine de usator de contacto pro problemas de accesso o questiones:',
	'privatedomainsinstructions' => 'Hic infra se trova le lista de dominios de e-mail permittite pro le contributores de iste wiki. Cata linea designa un suffixo de e-mail que da accesso al modification. Isto debe esser formatate con un suffixo per linea. Per exemplo:</p><p style="width: 20%; padding:5px; border: 1px solid grey;">cs.stanford.edu<br /> stanfordalumni.org</p><p>Isto permitterea le modificationes de omne persona con le adresse de e-mail quecunque@cs.stanford.edu o quecunque@stanfordalumni.org</p><p><b>Entra le dominios permittite in le quadro de texto sequente, e clicca "{{int:saveprefs}}".</b>',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'privatedomains_affiliatenamelabel' => 'Numm vun der Organisatioun',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'privatedomains_nomanageaccess' => "Жалиме, немате доволно права за да раководите со дозволените приватни домени за ова вики. Само вики-бирократи и членови на персоналот имаат таков пристап.</p><p>Ако не сте најавени, веројатно ќе [[Special:Userlogin|треба да се најавите]].",
	'privatedomains' => 'Раководење со приватни домени',
	'privatedomains_ifemailcontact' => 'Во спротивно, обратете се на [[Special:EmailUser/$1|$1]] ако имате било какви прашања.',
	'saveprivatedomains_success' => 'Промените во приватните домени се зачувани.',
	'privatedomains_invalidemail' => 'Жалиме, но само членови на $1 имаат пристап на ова вики. Ако имате е-поштенска адреса здружена со $1, можете да ја внесете или препотврдите на страницата за нагодување на сметката [[Special:Preferences|тука]]. Ќе можете и понатаму да ги гледате страниците на ова вики, но нема да можете да уредувате.',
	'privatedomains_affiliatenamelabel' => 'Име на организација:',
	'privatedomains_emailadminlabel' => 'Корисничко име за контакт при проблеми или прашања за пристап:',
	'privatedomainsinstructions' => 'Подолу е наведен список на е-поштенски домени дозволени за уредниците на ова вики. Во секој ред е назначена е-поштенска наставка што добива право на уредување. Ова треба да се форматира со по една наставка за секој ред. На пример:</p><p style="width: 20%; padding:5px; border: 1px solid grey;">cs.stanford.edu<br /> stanfordalumni.org</p>
<p>Ова дозволува уредувања од секој со адреса whatever@cs.stanford.edu или whatever@stanfordalumni.org</p><p><b>Во полето подолу внесете ги дозволените домени, и кликнете на „{{int:saveprefs}}“.</b>',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'privatedomains_nomanageaccess' => "U hebt niet de juiste rechten om de toegewezen privédomeinen voor deze wiki te beheren.
Alle bureaucraten van deze wiki en stafleden hebben deze rechten.</p>
<p>Als u niet bent aangemeld, [[Special:Userlogin|doe dat dan]].",
	'privatedomains' => 'Privédomeinen beheren',
	'privatedomains_ifemailcontact' => 'Neem anders contact op met [[Special:EmailUser/$1|$1]] voor antwoord op uw vragen.',
	'saveprivatedomains_success' => 'De wijzigingen in de privédomeinen zijn opgeslagen.',
	'privatedomains_invalidemail' => 'Alleen leden van de groep $1 hebben schrijftoegang voor deze wiki.
Als u een e-mailadres hebt dat is verbonden met "$1", voer dat dan in bij [[Special:Preferences|uw voorkeuren]] of bevestig uw e-mailadres.
U kunt pagina\'s bekijken, maar deze niet bewerken.',
	'privatedomains_affiliatenamelabel' => 'Organisatienaam:',
	'privatedomains_emailadminlabel' => 'Contactgebruiker bij toegangsproblemen of vragen:',
	'privatedomainsinstructions' => 'Hieronder staat een lijst met e-maildomeinen waarvan gebruiker op deze wiki kunnen bewerken. Op iedere regel staat een domeinnaam waarmee bewerkingstoegang tot de wiki verkregen kan worden. Er mag maar 1 domeinnaam per regel staan. Bijvoorbeeld:</p>
<p style="width: 20%; padding:5px; border: 1px solid grey;">cs.stanford.edu<br />stanfordalumni.org</p>
<p>Met deze instellingen zouden gebruikers met het e-mailadres pietje.precies@cs.stanford.edu en jantje.beton@stanfordalumni.org bijvoorbeeld pagina\'s mogen bewerken.</p>
<p><b>Voer de toegelaten domeinen in het onderstaande invoervenster in en klik op "{{int:saveprefs}}".</b>',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'privatedomains_nomanageaccess' => 'Beklager, du har ikke nok rettigheter til å håndtere tillatte private domener for denne wikien. Kun wikibyråkrater og stabsmedlemmer har tilgang.</p><p>Du bør <a href="/wiki/Special:Userlogin">logge inn]] om du ikke alt har gjort det.',
	'privatedomains' => 'Håndter private domener',
	'privatedomains_ifemailcontact' => 'Hvis ikke, kontakt [[Special:EmailUser/$1|$1]] om du har spørsmål.',
	'saveprivatedomains_success' => 'Endringer for private domener lagret.',
	'privatedomains_invalidemail' => 'Beklager, tilgang til denne wikien er begrenset til medlemmer av $1. Om du har en e-postadresse tilknyttet $1 kan du skrive den inn eller bekrefte den på din side for [[Special:Preferences|kontoinnstillinger]]. Du kan fortsatt se sidene på denne wikien, men du kan ikke redigere dem.',
	'privatedomains_affiliatenamelabel' => 'Navn på organisasjon:',
	'privatedomains_emailadminlabel' => 'Kontakt brukernavn for tilgangsproblemer eller spørsmål:',
	'privatedomainsinstructions' => 'Under er en liste over e-postdomener som er tillatt for bidragsytere i denne wikien. Hver linje angir et e-postsuffiks som er gitt tilgang til redigering. Denne bør være formatert med ett suffiks per linje. For eksempel:</p><p style="width:20%; padding:5px; border:1px solid grey;">cs.stanford.edu<br /> stanfordalumni.org</p><p>Dette ville tillatt redigeringer fra enhver med e-postadresse hvasomhelst@cs.stanford.edu og hvasomhelst@stanfordalumni.org</p><p><b>Skriv inn tillatte domener i tekstboksen under og trykk «{{int:saveprefs}}».</b>',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'privatedomains_nomanageaccess' => "Belavans a l'ha pa basta drit për gestì ël domini privà për sta wiki-sì. Mach mangiapapé dla wiki e mèmber ëd l'echip a l'han acess.</p><p>S'a l'é pa rintrà ant ël sistema, a peul esse [[Special:Userlogin|ch'a deva felo]].",
	'privatedomains' => 'Gestiss Domini Privà',
	'privatedomains_ifemailcontact' => "Dësnò, për piasì ch'a contata [[Special:EmailUser/$1|$1]] s'a l'has chèich chestion.",
	'saveprivatedomains_success' => 'Salvà ij cangiament ai Domini Privà.',
	'privatedomains_invalidemail' => "Belavans l'acess a sta wiki-sì a l'é arstrenzù ai mèmber ëd $1. S'a l'ha n'adrëssa ëd pòsta eletrònica afilià con $1, a peul anserì o riconfirmé soa adrëssa an soa pàgina dle preferense ëd sò cont [[Special:Preferences|ambelessì]]. A peul ancó visualisé pàgine an sta wiki-sì, ma a podrà pa fé 'd modìfiche.",
	'privatedomains_affiliatenamelabel' => "Nòm ëd l'organisassion:",
	'privatedomains_emailadminlabel' => "Nòm utent ëd contat për problema d'acess o arceste:",
	'privatedomainsinstructions' => "Sota a-i é la lista dij domini ëd pòsta eletrònica përmëttù a j'editor dë sta wiki-sì. Minca linia a spessìfica un sufiss ëd pòsta eletrònica che a l'ha acess për modifiché. Sòn a dovrìa pijé la forma con un sufiss për linia. Për esempi:</p> <p style=\"width: 20%; padding:5px; border: 1px solid grey;\">cs.stanford.edu<br /> stanfordalumni.org</p> <p>Sòn a përmët modìfiche da tuti coj ch'a l'han l'adrëssa ëd pòsta eletrònica whatever@cs.stanford.edu o whatever@stanfordalumni.org</p> <p><b>Ch'a anserissa ij domini përmëttù ant la casela ëd test sì-sota, e ch'a sgnaca \"salvé\".</b>",
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'privatedomains_nomanageaccess' => "Desculpe, mas não tem privilégios para administrar os domínios privados permitidos nesta wiki. Só os burocratas e os membros da equipa têm acesso.</p><p>Se não se autenticou, provavelmente [[Special:Userlogin|devia]].",
	'privatedomains' => 'Administrar Domínios Privados',
	'privatedomains_ifemailcontact' => 'Caso contrário, contacte [[Special:EmailUser/$1|$1]] se tiver dúvidas, por favor.',
	'saveprivatedomains_success' => 'As alterações aos Domínios Privados foram gravadas.',
	'privatedomains_invalidemail' => 'Desculpe, mas o acesso a esta wiki está restrito aos membros de $1. Se tem um correio electrónico afiliado com $1 pode introduzir ou reconfirmar o endereço de correio electrónico na página de preferências da sua conta [[Special:Preferences|aqui]]. Pode continuar a ver as páginas da wiki, mas não pode editá-las.',
	'privatedomains_affiliatenamelabel' => 'Nome da organização:',
	'privatedomains_emailadminlabel' => 'Nome do utilizador de contacto para problemas e questões:',
	'privatedomainsinstructions' => 'É apresentada abaixo a lista de domínios de correio electrónico permitidos para os editores desta wiki. Cada linha designa um sufixo de correio electrónico com permissões de edição. Deve existir um sufixo por linha. Por exemplo:</p><p style="width: 20%; padding:5px; border: 1px solid grey;">uma.pt<br /> unl.pt</p><p>Isto permite edições a todos aqueles com um endereço de correio electrónico nome@uma.pt ou nome@unl.pt</p><p><b>Introduza os domínios permitidos na caixa de texto abaixo e clique "{{int:saveprefs}}".</b>',
);

/** Russian (Русский)
 * @author G0rn
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'privatedomains_nomanageaccess' => "Извините, у вас недостаточно полномочий для управления частными доменами этой вики. Только вики-бюрократы и сотрудники имеют подобный доступ.</p><p>Если вы не вошли в систему, то вам, вероятно, [[Special:Userlogin|следует это сделать]].",
	'privatedomains' => 'Управление частными доменами',
	'privatedomains_ifemailcontact' => 'В противном случае, просим обращаться к [[Special:EmailUser/$1|$1]], если у вас есть какие-либо вопросы.',
	'saveprivatedomains_success' => 'Изменения в частных доменах сохранены.',
	'privatedomains_invalidemail' => 'Извините, доступ к этой вики доступен только для членов $1. Если у вас есть адрес электронной почты, связанный с $1, вы можете ввести или подтвердить ваш адрес электронной почты на вашей [[Special:Preferences|странице настроек]]. Вы можете просматривать страницы этой вики, но вы не сможете их править.',
	'privatedomains_affiliatenamelabel' => 'Название организации:',
	'privatedomains_emailadminlabel' => 'Контактное имя участника для запросов или проблем с доступом:',
	'privatedomainsinstructions' => 'Ниже приведён список почтовых доменов, допустимых для редакторов этой вики. Каждая строка обозначает суффикс адреса электронной почты, позволяющего производить правки. На каждой строке должно быть не более одного суффикса. Например: </p> <p style="width: 20%; padding:5px; border: 1px solid grey;">cs.stanford.edu<br /> stanfordalumni.org</p> <p>Подобная настройка позволит править статьи участникам, обладающим электронными адресами  whatever@cs.stanford.edu и whatever@stanfordalumni.org</p> <p><b>Введите разрешённые домены в представленное ниже текстовое поле и нажмите «{{int:saveprefs}}».</b>',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Verlor
 */
$messages['sr-ec'] = array(
	'privatedomains_affiliatenamelabel' => 'Име организације:',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'privatedomains_affiliatenamelabel' => 'సంస్థ యొక్క పేరు:',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'privatedomains_nomanageaccess' => "Paumanhin, walang kang sapat na mga karapatang upang pamahalaan ang mga dominyong pribado para sa wiking ito.  Tanging mga burokrato at mga kasaping tauhan ng wiki lamang ang makakapunta..</p><p>Kung hindi ka nakalagda, maaaring [[Special:Userlogin|dapat]] kang lumagda.",
	'privatedomains' => 'Pamahalaan ang mga Dominyong Pribado',
	'privatedomains_ifemailcontact' => 'O kaya, mangyaring makipag-ugnayan kay [[Special:EmailUser/$1|$1]] kung mayroon kang anumang mga katanungan.',
	'saveprivatedomains_success' => 'Sinagip ang mga pagbabago sa Mga Dominyong Pribado.',
	'privatedomains_invalidemail' => 'Paumahin, nakalaan lamang ang pagpasok sa wiking para sa mga kasapi ng $1.  Kung mayroon kang adres ng e-liham na may kaugnayan sa $1, maipapasok mo o muling patunayan ang adres mo ng e-liham sa pahina ng mga nais mo sa iyong akawnt [[Special:Preferences|dito]]. Maaari mo pa ring tingnan ang mga pahina sa wiking ito, subalit hindi ka makapamamatnugot.',
	'privatedomains_affiliatenamelabel' => 'Pangalan ng organisasyon:',
	'privatedomains_emailadminlabel' => 'Makipag-ugnayan sa pangalan ng tagagamit para sa mga suliranin sa pagpunta o mga tanong:',
	'privatedomainsinstructions' => 'Nasa ibaba ang talaan ng mga dominyo ng e-liham na ipinapahintulot para sa mga patnugot ng wiking ito.  Bawat guhit ay nagtatalaga ng isang hulaping makakapunta para sa pamamatnugot.  Dapat itong anyuhang may isang hulapi bawat guhit.  Bilang halimbawa:</p><p style="width: 20%; padding:5px; border: 1px solid grey;">cs.stanford.edu<br /> stanfordalumni.org</p><p>Magpapahintulot ito ng mga pagbabago mula kaninuman na may adres ng e-liham na anuman@cs.stanford.edu o anuman@stanfordalumni.org</p><p><b>Ipasok ang pinapayagang mga dominyo sa loob ng kahon ng tekstong nasa ibaba, at pindutin ang "sagipin".</b>',
);

