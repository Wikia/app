<?php
/**
 * Internationalization file for PrivateDomains extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Inez Korczyński <korczynski@gmail.com>
 */
$messages['en'] = array(
	'privatedomains-nomanageaccess' => 'You do not have enough rights to manage the allowed private domains for this wiki.
Only wiki bureaucrats and staff members have access.

If you are not logged in, you probably [[Special:UserLogin|should]].',
	'privatedomains' => 'Manage private domains',
	'privatedomains-ifemailcontact' => 'Otherwise, please contact [[Special:EmailUser/$1|$1]] if you have any questions.',
	'saveprivatedomains-success' => 'Private domains changes saved.',
	'privatedomains-invalidemail' => 'Sorry, access to this wiki is restricted to members of $1.
If you have an e-mail address affiliated with $1, you can enter or reconfirm your e-mail address on your [[Special:Preferences|account preference page]].
You can still view pages on this wiki, but you will be unable to edit.',
	'privatedomains-affiliatenamelabel' => 'Name of organization:',
	'privatedomains-emailadminlabel' => 'Contact username for access problems or queries:',
	'privatedomains-instructions' => "Below is the list of e-mail domains allowed for editors of this wiki.
Each line designates an e-mail suffix that is given access for editing.
This should be formatted with one suffix per line.
For example:<div style=\"width: 20%; padding:5px; border: 1px solid grey;\">cs.stanford.edu<br />stanfordalumni.org</div>
This would allow edits from anyone with the e-mail address whatever@cs.stanford.edu or whatever@stanfordalumni.org
<b>Enter the allowed domains in the text box below, and click \"save\".</b>",
	// For Special:ListGroupRights
	'right-privatedomains' => 'Manage private domains',
);

/** Message documentation (Message documentation)
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'right-privatedomains' => '{{doc-right|privatedomains}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'privatedomains' => 'Bestuur private domeine',
	'saveprivatedomains-success' => 'Die wysigings aan privaatdomeine is gestoor.',
	'privatedomains-affiliatenamelabel' => 'Naam van organisasie:',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'privatedomains-nomanageaccess' => 'Выбачайце, Вы ня маеце правоў для кіраваньня дазволенымі ўласнымі дамэнамі ў {{GRAMMAR:месны|{{SITENAME}}}}. Маюць доступ толькі бюракраты і супрацоўнікі.Калі вы не ўвайшлі ў сыстэму, Вам, магчыма, [[Special:UserLogin|трэба ўвайсьці]].',
	'privatedomains' => 'Кіраваньне ўласнымі дамэнамі',
	'privatedomains-ifemailcontact' => 'У іншым выпадку, калі ласка, зьвярніцеся да [[Special:EmailUser/$1|$1]], калі Вы маеце якія-небудзь пытаньні.',
	'saveprivatedomains-success' => 'Зьмены ў прыватных дамэнах захаваныя.',
	'privatedomains-invalidemail' => 'Прабачце, доступ да {{GRAMMAR:родны|{{SITENAME}}}} забаронены для ўдзельнікаў $1. Калі Вы маеце адрас электроннай пошты зьвязаны з $1, Вы можаце ўвесьці альбо перапацьвердзіць Ваш адрас электроннай пошты на старонцы Вашых установак [[Special:Preferences|тут]]. Вы можаце праглядаць старонкі {{GRAMMAR:родны|{{SITENAME}}}}, але ня можаце іх рэдагаваць.',
	'privatedomains-affiliatenamelabel' => 'Назва арганізацыі:',
	'privatedomains-emailadminlabel' => 'Кантактнае імя ўдзельніка для праблемаў уваходу альбо запытаў:',
	'privatedomains-instructions' => 'Ніжэй пададзены сьпіс паштовых дамэнаў дазволеных для рэдактараў {{GRAMMAR:родны|{{SITENAME}}}}. Кожны радок вызначае суфікс адрасу электроннай пошты, які дазваляе доступ да рэдагаваньня. Ён павінен мець выгляд: адзін суфікс на радок. Напрыклад: <div style="width: 20%; padding:5px; border: 1px solid grey;">cs.stanford.edu<br /> stanfordalumni.org</div>Гэта дазволіць рэдагаваньне толькі удзельнікам з адрасам электроннай пошты whatever@cs.stanford.edu альбо whatever@stanfordalumni.org</div><b>Увядзіце дазволеныя дамэны ў тэкставае поле ніжэй і націсьніце «Захаваць».</b>',
	'right-privatedomains' => 'кіраваньне прыватнымі дамэнамі',
);

/** Breton (Brezhoneg)
 * @author Gwenn-Ael
 */
$messages['br'] = array(
	'privatedomains' => 'Merañ an domanioù prevez',
	'privatedomains-ifemailcontact' => "Anez, kit e darempred gant [[Special:Emailuser/$1|$1]]  m'ho peus goulenn pe c'houlenn.",
	'saveprivatedomains-success' => 'Kemmoù en domanioù prevez saveteet.',
	'privatedomains-invalidemail' => "Ma digarezit, Miret eo ar moned d'ar wiki-mañ evit izili $1.  M'ho peus ur chomlec'h postel emezelet ouzh $1 e challit mont e-barzh pe adkarnaat ho chomlec'h postel war pajenn zibaboù ar gont [[Special:Preferences|amañ]]. Gallout a rit gwelet pajennoù ar wiki-mañ, met ne c'hallit ket kemmañ anezho.",
	'privatedomains-affiliatenamelabel' => 'Anv an aozadur :',
	'privatedomains-emailadminlabel' => "Anv implijer an darempred m'ho peus kudennoù mont pe rekedoù :",
	'privatedomains-instructions' => 'Diskwelet eo roll domanioù ar chomlec\'hioù postel zo aotreet evit embannerien ar wiki-mañ. Pep linenn a ziskouez ur rakverk postel a ro tro d\'an embannerien da vont warno. Furmadet e tle ar roll  bezañ gant ur rakverk dre linenn. Da skouer,  :<div style="width: 20%; padding:5px; border: 1px solid grey;">cs.stanford.edu<br /> stanfordalumni.org</div>p>This would allow edits from anyone with the email address whatever@cs.stanford.edu or whatever@stanfordalumni.org</div><b>Ebarzhit roll an domanioù aotreet er voest amañ amañ dindan ha klikit war « saveteiñ».</b>',
);

/** German (Deutsch)
 * @author Kghbln
 * @author LWChris
 */
$messages['de'] = array(
	'privatedomains-nomanageaccess' => 'Du hast nicht die Berechtigung zulässige Domains für dieses Wiki festzulegen sowie zu verwalten. Nur Benutzer mit der Berechtigung „privatedomains“ können dies.

Sofern du lediglich nicht angemeldet bist, kannst du dies [[Special:UserLogin|hier machen]].',
	'privatedomains' => 'Ermöglicht das Festlegen und Verwalten zulässiger Domains',
	'privatedomains-ifemailcontact' => 'Ansonsten wende dich bitte im Fall von Fragen an Benutzer [[Special:EmailUser/$1|$1]].',
	'saveprivatedomains-success' => 'Die Änderungen an den zulässigen Domains wurden gespeichert.',
	'privatedomains-invalidemail' => 'Der Zugang zu diesem Wiki ist auf Personen mit einer E-Mail-Adresse der Domain $1 beschränkt.
Sofern du über eine E-Mail-Adresse dieser Domain verfügst, kannst du sie auf der Spezialseite [[Special:Preferences|Einstellungen]] angeben und bestätigen oder ändern und erneut bestätigen.
Du kannst weiterhin Seiten in diesem Wiki ansehen, sie allerdings nicht bearbeiten.',
	'privatedomains-affiliatenamelabel' => 'Name der Organisation:',
	'privatedomains-emailadminlabel' => 'Der Name des Benutzers, der im Fall von Zugangsproblemen oder Fragen kontaktiert werden kann:',
	'privatedomains-instructions' => 'Unterhalb befindet sich die Liste der zulässigen Domains zu diesem Wiki. Benutzer die E-Mail-Adresse dieser Domains besitzen, dürfen dieses Wiki bearbeiten.
Jede Zeile gibt den Domainteil einer E-Mail-Adresse an, die zum Bearbeiten berechtigt.
Beispiel:<div style="width: 20%; padding:5px; border: 1px solid grey;">de.beispiel.org<br />beispiel.de</div>
Hierdurch wird es allen Benutzern gestattet dieses Wiki zu bearbeiten, die über eine E-Mail wie ‚xyz@de.beispiel.org‘ oder ‚xyz@beispiel.de‘ verfügen.
<b>Die zulässigen Domains bitte im folgenden Textfeld zeilenweise angeben und danach auf „Speichern“ klicken.</b>',
	'right-privatedomains' => 'Zulässige Domains festlegen und verwalten',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Kghbln
 * @author LWChris
 */
$messages['de-formal'] = array(
	'privatedomains-nomanageaccess' => 'Sie haben nicht die Berechtigung zulässige Domains für dieses Wiki festzulegen sowie zu verwalten. Nur Benutzer mit der Berechtigung „privatedomains“ können dies.

Sofern Sie lediglich nicht angemeldet sind, können Sie [[Special:UserLogin|hier machen]].',
	'privatedomains-ifemailcontact' => 'Ansonsten wenden Sie sich bitte im Fall von Fragen an Benutzer [[Special:EmailUser/$1|$1]].',
	'privatedomains-invalidemail' => 'Der Zugang zu diesem Wiki ist auf Personen mit einer E-Mail-Adresse der Domain $1 beschränkt.
Sofern Sie über eine E-Mail-Adresse dieser Domain verfügen, können Sie sie auf der Spezialseite [[Special:Preferences|Einstellungen]] angeben und bestätigen oder ändern und erneut bestätigen.
Sie können weiterhin Seiten in diesem Wiki ansehen, sie allerdings nicht bearbeiten.',
);

/** Spanish (Español)
 * @author Pertile
 */
$messages['es'] = array(
	'privatedomains-nomanageaccess' => 'Lo sentimos, no tiene los privilegios suficientes para administrar los dominios privados permitidos para esta wiki. Solamente los burócratas wiki y los miembros del personal tienen acceso.Si no accedió al sistema, probablemente [[Special:UserLogin|debería hacerlo]].',
	'privatedomains' => 'Administrar Dominios Privados',
	'privatedomains-ifemailcontact' => 'En caso contrario, póngase en contacto con [[Special:EmailUser/$1|$1]] por cualquier consulta.',
	'saveprivatedomains-success' => 'Se guardaron los cambios en los Dominios Privados.',
	'privatedomains-invalidemail' => 'Lo sentimos, el acceso a esta wiki está restringido a los miembros de $1. Si posee una cuenta de correo electrónico afiliada a $1, puede ingresarla o volver a confirmar su dirección de correo electrónico en la página de preferencias de su cuenta [[Special:Preferences|aquí]]. Todavía puede ver las páginas en esta wiki, pero no podrá editarlas.',
	'privatedomains-affiliatenamelabel' => 'Nombre de la organización:',
	'privatedomains-emailadminlabel' => 'Nombre de usuario del contacto para problemas o consultas:',
	'privatedomains-instructions' => 'A continuación se presenta la lista de dominios de correo electrónico permitidos para los editores de esta wiki. Cad línea designa un sufijo de correo electrónico que puede editar en esta wiki. Esta debería tener un formato de un sufijo por línea. Por ejemplo:<div style="width: 20%; padding:5px; border: 1px solid grey;">cs.stanford.edu<br /> stanfordalumni.org</div>El ejemplo anterior debería permitir las ediciones de alguien cuya dirección de correo sea loquesea@cs.stanford.edu o loquesea@stanfordalumni.org</div><b>Ingrese los dominios permitidos en el cuadro de texto que se muestra debajo y haga clic en "guardar".</b>',
);

/** Basque (Euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'privatedomains' => 'Domeinu pribatuak kudeatu',
	'saveprivatedomains-success' => 'Domeinu pribatuetako aldaketak gordeta.',
	'privatedomains-affiliatenamelabel' => 'Erakundearen izena:',
	'right-privatedomains' => 'Domeinu pribatuak kudeatu',
);

/** Finnish (Suomi)
 * @author Centerlink
 */
$messages['fi'] = array(
	'privatedomains' => 'Hallinnoi yksityisiä verkkoalueita',
	'privatedomains-ifemailcontact' => 'Muussa tapauksessa, ota yhteys [[Special:EmailUser/$1|$1]], jos sinulla on kysyttävää.',
	'saveprivatedomains-success' => 'Yksityisen verkkoalueen muutokset on tallennettu.',
	'privatedomains-affiliatenamelabel' => 'Organisaation nimi:',
	'privatedomains-emailadminlabel' => 'Yhteystietokäyttäjänimi pääsypulmissa tai kyselyissä:',
);

/** French (Français)
 * @author Alexandre Emsenhuber
 * @author IAlex
 */
$messages['fr'] = array(
	'privatedomains-nomanageaccess' => "Désolé, vous n'avez les droits suffisants pour gérer les domaines privés de ce wiki. Seuls les bureaucrates et les membres du personnel y ont accès.Si vous n'êtes pas connecté, vous devriez probablement [[Special:UserLogin|vous connecter]].",
	'privatedomains' => 'Gérer les domaines privés',
	'privatedomains-ifemailcontact' => 'Sinon, veuillez contacter [[Special:EmailUser/$1|$1]] si vous avec une question.',
	'saveprivatedomains-success' => 'Modifications dans les domaines privés sauvegardés.',
	'privatedomains-invalidemail' => "Désolé, l'accès à ce wiki est réservé aux membre de $1. Si vos avez une adresse de courriel affiliée avec $1, vous pouvez entrer ou reconfirmer votre adresse de courriel dans sur la page de préférences du compte [[Special:Preferences|ici]]. Vous pouvez toujours voir les pages de ce wiki, mais vous ne pouvez pas le modifier.",
	'privatedomains-affiliatenamelabel' => "Nom de l'organisation :",
	'privatedomains-emailadminlabel' => "Nom d'utilisateur du contact pour des problèmes d'accès ou requêtes :",
	'privatedomains-instructions' => '<br /> <br /> La liste des domaines des adresses de courriel autorisées pour les éditeurs de ce wiki est affichée ci-dessous. Chaque ligne désigne un suffixe d\'adresse de courriel qui donne accès aux éditeurs. La liste doit être formatée avec un suffixe par ligne. Par exemple : <div style="width: 20%; padding:5px; border: 1px solid grey;">cs.stanford.edu<br /> stanfordalumni.org</div> Ceci permettra à toutes les personnes ayant une adresse de courriel se terminant par « @cs.stanford.edu » et  « @stanfordalumni.org » de modifier le wiki. <b>Entrez la liste des domaines autorisés dans la boîte ci-dessous et cliquez sur « sauvegarder ».</b>',
	'right-privatedomains' => 'Gérer les domaines privés',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'privatedomains' => 'Administrar los domênos privâs',
	'privatedomains-affiliatenamelabel' => 'Nom de l’organisacion :',
	'right-privatedomains' => 'Administrar los domênos privâs',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'privatedomains-nomanageaccess' => 'Non ten os dereitos necesarios para xestionar os dominios privados deste wiki.
Só os burócratas do wiki e os membros do persoal teñen acceso.

Se non accedeu ao sistema, probabelmente [[Special:UserLogin|debería]] facelo.',
	'privatedomains' => 'Xestionar os dominios privados',
	'privatedomains-ifemailcontact' => 'Se non, póñase en contacto con [[Special:EmailUser/$1|$1]] se ten algunha dúbida.',
	'saveprivatedomains-success' => 'Gardáronse os cambios feitos nos dominios privados.',
	'privatedomains-invalidemail' => 'Sentímolo, o acceso a este wiki está restrinxido aos membros de $1.
Se ten un enderezo de correo electrónico afiliado con $1, pode entrar ou confirmar o seu enderezo de correo electrónico na [[Special:Preferences|páxina de preferencias da súa conta]].
Aínda pode ver páxinas neste wiki, pero non será capaz de editalas.',
	'privatedomains-affiliatenamelabel' => 'Nome da organización:',
	'privatedomains-emailadminlabel' => 'Nome de usuario de contacto para os problemas de acceso ou consultas:',
	'privatedomains-instructions' => 'A continuación está a lista de dominios de correo electrónico autorizados para os editores deste wiki.
Cada liña designa un sufixo que dá acceso á edición.
A lista debe estar ordenada de xeito que haxa un sufixo por liña.
Por exemplo: <div style="width: 20%; padding:5px; border: 1px solid grey;">cs.stanford.edu<br />stanfordalumni.org</div>
Isto permitirá as edicións de aqueles que teña un enderezo de correo electrónico o_que_sexa@cs.stanford.edu ou o_que_sexa@stanfordalumni.org
<b>Insira os dominios autorizados no cadro de texto de embaixo e prema en "Gardar".</b>',
	'right-privatedomains' => 'Xestionar dominios privados',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'privatedomains-nomanageaccess' => 'Nimaće prawa za rjadowanje dowolenych priwatnych domenow za tutón wiki.
Jenož wikijowi běrokraća a čłonojo team maju přistup.

Jeli njejsy přizjewjeny, móžeš to [[Special:UserLogin|nachwatać]].',
	'privatedomains' => 'Priwatne domeny zarjadować',
	'privatedomains-ifemailcontact' => 'Hewak staj so z [[Special:EmailUser/$1|$1]] do zwiska, jeli maš prašenja.',
	'saveprivatedomains-success' => 'Změny priwatnych domenow su so składowali.',
	'privatedomains-invalidemail' => 'Přistup na tutón wiki je bohužel na čłonow domeny $1 wobmjezowany.
Jeli maš e-mejlowu adresu tuteje domeny, móžeš e-mejlowu adesu na stronje swojich [[Special:Preferences|kontowych nastajenjow]] zapodać abo znowa wobkrućić.
Móžeš sej hišće strony na tutym wikiju wobhladać, ale njemóžeš je wobdźěłać.',
	'privatedomains-affiliatenamelabel' => 'Mjeno organizacije:',
	'privatedomains-emailadminlabel' => 'Wužiwarske mjeno kontaktoweje wosoby za přistupne problemy abo naprašowanja:',
	'privatedomains-instructions' => 'Deleka je lisćina e-mejlowych domenow, kotrež su za wobdźěłarjow tutoho wikija dopušćene.
Kóžda linka podawa e-mejlowy sufiks, kotryž wobdźěłowanje dowola.
Na kóždej lince ma jedyn sufiks stać.
Na přikład:<div style="width: 20%; padding:5px; border: 1px solid grey;">hsb.priklad.de<br />priklad.de</div>
To dowoli změny wot kóždeho, kotryž ma e-mejlowu adresu stozkuli@hsb.priklad.de abo stozkuli@priklad.de.
<b>Zapodaj dowolene domeny w slědowacym tekstowym polu a klikń na "składować".</b>',
	'right-privatedomains' => 'Priwatne domeny zarjadować',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'privatedomains' => 'Privát tartományok kezelése',
	'privatedomains-affiliatenamelabel' => 'Szervezet neve:',
	'privatedomains-emailadminlabel' => 'Kapcsolattartó neve hozzáférési problémák vagy kérdések esetére:',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'privatedomains-nomanageaccess' => 'Pardono, tu non ha le derectos necessari pro gerer le dominios private de iste wiki. Solmente le bureaucrates del wiki e le personal ha accesso.Si tu non ha aperite un session, tu deberea probabilemente [[Special:UserLogin|facer lo]].',
	'privatedomains' => 'Gerer dominios private',
	'privatedomains-ifemailcontact' => 'Si non, contacta [[Special:EmailUser/$1|$1]] si tu ha alcun questiones.',
	'saveprivatedomains-success' => 'Le alterationes in le dominios private ha essite salveguardate.',
	'privatedomains-invalidemail' => 'Pardono, le accesso a iste wiki es restringite al membros de $1. Si tu ha un adresse de e-mail affiliate con $1, tu pote entrar o reconfirmar tu adresse de e-mail in [[Special:Preferences|le pagina de preferentias de tu conto]]. Tu pote vider paginas in iste wiki, ma non modificar los.',
	'privatedomains-affiliatenamelabel' => 'Nomine del organisation:',
	'privatedomains-emailadminlabel' => 'Nomine de usator de contacto pro problemas de accesso o questiones:',
	'privatedomains-instructions' => 'Hic infra se trova le lista de dominios de e-mail permittite pro le contributores de iste wiki. Cata linea designa un suffixo de e-mail que da accesso al modification. Isto debe esser formatate con un suffixo per linea. Per exemplo:<div style="width: 20%; padding:5px; border: 1px solid grey;">cs.stanford.edu<br /> stanfordalumni.org</div>Isto permitterea le modificationes de omne persona con le adresse de e-mail quecunque@cs.stanford.edu o quecunque@stanfordalumni.org</div><b>Entra le dominios permittite in le quadro de texto sequente, e clicca "salveguardar".</b>',
	'right-privatedomains' => 'Gerer dominios private',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'privatedomains-affiliatenamelabel' => 'Numm vun der Organisatioun',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'privatedomains-nomanageaccess' => 'Жалиме, немате доволно права за да раководите со дозволените приватни домени за ова вики. Само вики-бирократи и членови на персоналот имаат таков пристап.Ако не сте најавени, веројатно ќе [[Special:UserLogin|треба да се најавите]].',
	'privatedomains' => 'Раководење со приватни домени',
	'privatedomains-ifemailcontact' => 'Во спротивно, обратете се на [[Special:EmailUser/$1|$1]] ако имате било какви прашања.',
	'saveprivatedomains-success' => 'Промените во приватните домени се зачувани.',
	'privatedomains-invalidemail' => 'Жалиме, но само членови на $1 имаат пристап на ова вики. Ако имате е-поштенска адреса здружена со $1, можете да ја внесете или препотврдите на страницата за нагодување на сметката [[Special:Preferences|тука]]. Ќе можете и понатаму да ги гледате страниците на ова вики, но нема да можете да уредувате.',
	'privatedomains-affiliatenamelabel' => 'Име на организација:',
	'privatedomains-emailadminlabel' => 'Корисничко име за контакт при проблеми или прашања за пристап:',
	'privatedomains-instructions' => 'Подолу е наведен список на е-поштенски домени дозволени за уредниците на ова вики. Во секој ред е назначена е-поштенска наставка што добива право на уредување. Ова треба да се форматира со по една наставка за секој ред. На пример:<div style="width: 20%; padding:5px; border: 1px solid grey;">cs.stanford.edu<br /> stanfordalumni.org</div>Ова дозволува уредувања од секој со адреса нешто@cs.stanford.edu или нешто@stanfordalumni.org</div><b>Во полето подолу внесете ги дозволените домени, и кликнете на „зачувај“.</b>',
	'right-privatedomains' => 'Раководење со приватни домени',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'privatedomains-nomanageaccess' => 'Beklager, du har ikke nok rettigheter til å håndtere tillatte private domener for denne wikien. Kun wikibyråkrater og stabsmedlemmer har tilgang.Du bør [[Special:UserLogin|logge inn]] om du ikke alt har gjort det.',
	'privatedomains' => 'Håndter private domener',
	'privatedomains-ifemailcontact' => 'Hvis ikke, kontakt [[Special:EmailUser/$1|$1]] om du har spørsmål.',
	'saveprivatedomains-success' => 'Endringer for private domener lagret.',
	'privatedomains-invalidemail' => 'Beklager, tilgang til denne wikien er begrenset til medlemmer av $1. Om du har en e-postadresse tilknyttet $1 kan du skrive den inn eller bekrefte den på din side for [[Special:Preferences|kontoinnstillinger]]. Du kan fortsatt se sidene på denne wikien, men du kan ikke redigere dem.',
	'privatedomains-affiliatenamelabel' => 'Navn på organisasjon:',
	'privatedomains-emailadminlabel' => 'Kontakt brukernavn for tilgangsproblemer eller spørsmål:',
	'privatedomains-instructions' => 'Under er en liste over e-postdomener som er tillatt for bidragsytere i denne wikien. Hver linje angir et e-postsuffiks som er gitt tilgang til redigering. Denne bør være formatert med ett suffiks per linje. For eksempel:<div style="width:20%; padding:5px; border:1px solid grey;">cs.stanford.edu<br /> stanfordalumni.org</div>Dette ville tillatt redigeringer fra enhver med e-postadresse hvasomhelst@cs.stanford.edu og hvasomhelst@stanfordalumni.org</div><b>Skriv inn tillatte domener i tekstboksen under og klikk «lagre».</b>',
);

/** Dutch (Nederlands)
 * @author Mark van Alphen
 * @author Mitchel Corstjens
 * @author Siebrand
 * @author Siebrand Mazeland
 */
$messages['nl'] = array(
	'privatedomains-nomanageaccess' => 'Sorry, maar je hebt niet genoeg rechten om privé domeinen voor deze wiki te beheren. Alleen wiki bureaucraten en staff leden hebben toegang.Als je niet ingelogd bent, zou je dat [[Special:UserLogin|moeten doen]].',
	'privatedomains' => 'Privédomeinen beheren',
	'privatedomains-ifemailcontact' => 'Anders, contacteer a.u.b. [[Special:EmailUser/$1|$1]] als je vragen hebt.',
	'saveprivatedomains-success' => 'De wijzigingen aan private domeinen zijn opgeslagen.',
	'privatedomains-invalidemail' => "Sorry, toegang tot deze wiki is alleen toegestaan voor leden van $1. Als je een email adres hebt die verwant is met $1, kan je je email adres invoeren of bevestigen op je account voorkeuren pagina [[Special:Preferences|hier]]. Je kan nog steeds pagina's op de wiki bekijken, maar kan niet bewerken.",
	'privatedomains-affiliatenamelabel' => 'Organisatienaam:',
	'privatedomains-emailadminlabel' => 'Neem contact op met gebruikersnaam voor toegangsproblemen of als je vragen hebt',
	'privatedomains-instructions' => '<br /> <br /> Onderstaande is een lijst van email domeinen toegestaan voor bewerkers op deze wiki. Elke regel wijst een email achtervoegsel toe die in staat is om deze wiki te bewerken. Formateer dit met een achtervoegsel per regel. Voorbeeld <div style="width: 20%; padding:5px; border: 1px solid grey;">cs.stanford.edu<br /> stanfordalumni.org</div> Dit zou iedereen toe moeten staan om te bewerken met het email adres whatever@cs.stanford.edu of whatever@stanfordalumni.org</div> <b>Type de toegestane domeinen in de onderstaande tekst box, en klik op "opslaan".</b>',
	'right-privatedomains' => 'Private domeinen beheren',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'privatedomains-nomanageaccess' => 'Nie masz wystarczających uprawnień do zarządzania prywatnymi domenami tej wiki. Robić to mogą wyłącznie członkowie grup biurokraci oraz personel.

Jeśli nie jesteś zalogowany możliwe, że powinieneś najpierw [[Special:UserLogin|zalogować się]].',
	'privatedomains' => 'Zarządzanie prywatnymi domenami',
	'privatedomains-ifemailcontact' => 'W przeciwnym wypadku należy kontaktować się z [[Special:EmailUser/$1|$1]], o ile masz jakieś pytania.',
	'saveprivatedomains-success' => 'Zmiany dla domen prywatnych zostały zapisane.',
	'privatedomains-invalidemail' => 'Dostęp do tej wiki został ograniczony do członków $1. Jeśli masz adres e-mail powiązany z $1, możesz wprowadzić lub potwierdzić swój adres e‐mail na [[Special:Preferences|stronie preferencji]]. Nadal możesz przeglądać strony, ale edycja nie będzie możliwa.',
	'privatedomains-affiliatenamelabel' => 'Nazwa organizacji',
	'privatedomains-emailadminlabel' => 'Użytkownik kontaktowy w sprawie pytań lub problemów z dostępem',
	'privatedomains-instructions' => 'Poniżej znajduje się lista domen poczty elektronicznej dostępnych dla redaktorów tej wiki. Każdy wiersz określa sufiks adresu e-mail, którego posiadanie umożliwia edycję. Należy umieścić jedną końcówkę w jednej linii. Na przykład:
<div style="width: 20%; padding:5px; border: 1px solid grey;">cs.stanford.edu<br /> stanfordalumni.org</div>
Pozwoli to edytować np posiadaczom adresów whatever@cs.stanford.edu lub whatever@stanfordalumni.org</div>
<b>Wprowadź dozwolone domeny w polu tekstowym i kliknij przycisk „{{int:saveprefs}}“.</b>',
	'right-privatedomains' => 'Zarządzanie własnymi domenami',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'privatedomains-nomanageaccess' => "Belavans a l'ha pa basta drit për gestì ël domini privà për sta wiki-sì. Mach mangiapapé dla wiki e mèmber ëd l'echip a l'han acess.S'a l'é pa rintrà ant ël sistema, a peul esse [[Special:UserLogin|ch'a deva felo]].",
	'privatedomains' => 'Gestiss Domini Privà',
	'privatedomains-ifemailcontact' => "Dësnò, për piasì ch'a contata [[Special:EmailUser/$1|$1]] s'a l'has chèich chestion.",
	'saveprivatedomains-success' => 'Salvà ij cangiament ai Domini Privà.',
	'privatedomains-invalidemail' => "Belavans l'acess a sta wiki-sì a l'é arstrenzù ai mèmber ëd $1. S'a l'ha n'adrëssa ëd pòsta eletrònica afilià con $1, a peul anserì o riconfirmé soa adrëssa an soa pàgina dle preferense ëd sò cont [[Special:Preferences|ambelessì]]. A peul ancó visualisé pàgine an sta wiki-sì, ma a podrà pa fé 'd modìfiche.",
	'privatedomains-affiliatenamelabel' => "Nòm ëd l'organisassion:",
	'privatedomains-emailadminlabel' => "Contata nòm utent për problem d'acess o custion:",
	'privatedomains-instructions' => "<br /> <br /> Sota a-i é la lista dij domini ëd pòsta eletrònica përmëttù a j'editor dë sta wiki-sì. Minca linia a spessìfica un sufiss ëd pòsta eletrònica che a l'ha acess për modifiché. Sòn a dovrìa pijé la forma con un sufiss për linia. Për esempi: <div style=\"width: 20%; padding:5px; border: 1px solid grey;\">cs.stanford.edu<br /> stanfordalumni.org</div> Sòn a përmët modìfiche da tuti coj ch'a l'han l'adrëssa ëd pòsta eletrònica whatever@cs.stanford.edu o whatever@stanfordalumni.org</div> <b>Ch'a anserissa ij domini përmëttù ant la casela ëd test sì-sota, e ch'a sgnaca \"salvé\".</b>",
	'right-privatedomains' => 'Gestì ij domini privà',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'privatedomains-nomanageaccess' => 'Desculpe, mas não tem privilégios para administrar os domínios privados permitidos nesta wiki. Só os burocratas e os membros da equipa têm acesso.Se não se autenticou, provavelmente [[Special:UserLogin|devia]].',
	'privatedomains' => 'Administrar Domínios Privados',
	'privatedomains-ifemailcontact' => 'Caso contrário, contacte [[Special:EmailUser/$1|$1]] se tiver dúvidas, por favor.',
	'saveprivatedomains-success' => 'As alterações aos Domínios Privados foram gravadas.',
	'privatedomains-invalidemail' => 'Desculpe, mas o acesso a esta wiki está restrito aos membros de $1. Se tem um correio electrónico afiliado com $1 pode introduzir ou reconfirmar o endereço de correio electrónico na sua [[Special:Preferences|página de preferências]]. Pode continuar a ver as páginas da wiki, mas não pode editá-las.',
	'privatedomains-affiliatenamelabel' => 'Nome da organização:',
	'privatedomains-emailadminlabel' => 'Nome do utilizador de contacto para problemas e questões:',
	'privatedomains-instructions' => 'É apresentada abaixo a lista de domínios de correio electrónico permitidos para os editores desta wiki.
Cada linha designa um sufixo de correio electrónico com permissões de edição.
Deve existir um sufixo por linha.
Por exemplo:<div style="width: 20%; padding:5px; border: 1px solid grey;">uma.pt<br />unl.pt</div>
Isto permite edições a todos aqueles com um endereço de correio electrónico nome@uma.pt ou nome@unl.pt.<br />
<b>Introduza os domínios permitidos na caixa de texto abaixo e clique "gravar".</b>',
	'right-privatedomains' => 'Gerir domínios privados',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'privatedomains-nomanageaccess' => 'Извините, у вас недостаточно полномочий для управления частными доменами этой вики. Только вики-бюрократы и сотрудники имеют подобный доступ.Если вы не вошли в систему, то вам, вероятно, [[Special:UserLogin|следует это сделать]].',
	'privatedomains' => 'Управление частными доменами',
	'privatedomains-ifemailcontact' => 'В противном случае, просим обращаться к [[Special:EmailUser/$1|$1]], если у вас есть какие-либо вопросы.',
	'saveprivatedomains-success' => 'Изменения в частных доменах сохранены.',
	'privatedomains-invalidemail' => 'Извините, доступ к этой вики доступен только для членов $1. Если у вас есть адрес электронной почты, связанный с $1, вы можете ввести или подтвердить ваш адрес электронной почты на вашей [[Special:Preferences|странице настроек]]. Вы можете просматривать страницы этой вики, но вы не сможете их править.',
	'privatedomains-affiliatenamelabel' => 'Название организации:',
	'privatedomains-emailadminlabel' => 'Контактное имя участника для запросов или проблем с доступом:',
	'privatedomains-instructions' => 'Ниже приведён список почтовых доменов, допустимых для редакторов этой вики. Каждая строка обозначает суффикс адреса электронной почты, позволяющего производить правки. На каждой строке должно быть не более одного суффикса. Например:  <div style="width: 20%; padding:5px; border: 1px solid grey;">cs.stanford.edu<br /> stanfordalumni.org</div> Подобная настройка позволит править статьи участникам, обладающим электронными адресами  whatever@cs.stanford.edu и whatever@stanfordalumni.org</div> <b>Введите разрешённые домены в представленное ниже текстовое поле и нажмите «Сохранить».</b>',
	'right-privatedomains' => 'управление частными доменами',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Verlor
 */
$messages['sr-ec'] = array(
	'privatedomains-affiliatenamelabel' => 'Назив организације:',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬) */
$messages['sr-el'] = array(
	'privatedomains-affiliatenamelabel' => 'Naziv organizacije:',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'privatedomains-affiliatenamelabel' => 'సంస్థ యొక్క పేరు:',
);

/** Tagalog (Tagalog) */
$messages['tl'] = array(
	'privatedomains-nomanageaccess' => 'Paumanhin, walang kang sapat na mga karapatang upang pamahalaan ang mga dominyong pribado para sa wiking ito.  Tanging mga burokrato at mga kasaping tauhan ng wiki lamang ang makakapunta..Kung hindi ka nakalagda, maaaring [[Special:UserLogin|dapat]] kang lumagda.',
	'privatedomains' => 'Pamahalaan ang mga Dominyong Pribado',
	'privatedomains-ifemailcontact' => 'O kaya, mangyaring makipag-ugnayan kay [[Special:EmailUser/$1|$1]] kung mayroon kang anumang mga katanungan.',
	'saveprivatedomains-success' => 'Sinagip ang mga pagbabago sa Mga Dominyong Pribado.',
	'privatedomains-invalidemail' => 'Paumahin, nakalaan lamang ang pagpasok sa wiking para sa mga kasapi ng $1.  Kung mayroon kang adres ng e-liham na may kaugnayan sa $1, maipapasok mo o muling patunayan ang adres mo ng e-liham sa pahina ng mga nais mo sa iyong akawnt [[Special:Preferences|dito]]. Maaari mo pa ring tingnan ang mga pahina sa wiking ito, subalit hindi ka makapamamatnugot.',
	'privatedomains-affiliatenamelabel' => 'Pangalan ng organisasyon:',
	'privatedomains-emailadminlabel' => 'Makipag-ugnayan sa pangalan ng tagagamit para sa mga suliranin sa pagpunta o mga tanong:',
	'privatedomains-instructions' => 'Nasa ibaba ang talaan ng mga dominyo ng e-liham na ipinapahintulot para sa mga patnugot ng wiking ito.  Bawat guhit ay nagtatalaga ng isang hulaping makakapunta para sa pamamatnugot.  Dapat itong anyuhang may isang hulapi bawat guhit.  Bilang halimbawa:<div style="width: 20%; padding:5px; border: 1px solid grey;">cs.stanford.edu<br /> stanfordalumni.org</div>Magpapahintulot ito ng mga pagbabago mula kaninuman na may adres ng e-liham na anuman@cs.stanford.edu o anuman@stanfordalumni.org</div><b>Ipasok ang pinapayagang mga dominyo sa loob ng kahon ng tekstong nasa ibaba, at pindutin ang "sagipin".</b>',
);

