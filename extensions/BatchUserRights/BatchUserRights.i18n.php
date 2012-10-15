<?php
/**
 * Internationalisation file for the BatchUserRights extension
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English */
$messages['en'] = array(
	'batchuserrights' => 'Batch user rights',
	'batchuserrights-desc' => 'Allows adding one or more users to a group or more groups in one action',
	'batchuserrights-names' => 'Usernames to add this group to (one per line):',
	'batchuserrights-intro' => 'This page will let you add a group to multiple users at once.
For security reasons, the list of addable groups is set in the extension configuration and cannot be changed from within the wiki.
Please ask a system administrator if you need to allow batch-adding of other groups.',
	'batchuserrights-single-progress-update' => 'Added {{PLURAL:$1|group|groups}} to <strong>$2</strong>.',
	'batchuserrights-add-groups' => 'Adding {{PLURAL:$1|one user|$1 users}} to the following {{PLURAL:$2|group|groups}}: <strong>$3</strong>.',
	'batchuserrights-userload-error' => "Could not load the user \"'''$1'''\".",
	'batchuserrights-no-groups' => 'You did not choose any groups.
This will not accomplish anything.
The rest of the page will be allowed to run just so that you can easily see if any of the usernames could not be loaded.',

	'right-batchuserrights' => 'Adding one or more users to a group or more groups in one action',
);

/** Message documentation (Message documentation)
 * @author SVG
 * @author The Evil IP address
 */
$messages['qqq'] = array(
	'batchuserrights' => 'Name of Special:BatchUserRights in Special:SpecialPages and title of Special:BatchUserRights page',
	'batchuserrights-desc' => '{{desc}}',
	'batchuserrights-names' => 'Names of users which should be added to the selected groups',
	'batchuserrights-intro' => 'How to use description on Special:BatchUserRights',
	'batchuserrights-single-progress-update' => 'Success message',
	'batchuserrights-add-groups' => 'Success message',
	'batchuserrights-userload-error' => 'Error message if an user could not loaded',
	'batchuserrights-no-groups' => 'Error message which will be shown if no groups to add has been selected',
	'right-batchuserrights' => '{{doc-right|batchuserrights}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'batchuserrights-userload-error' => "Die gebruiker \"'''\$1'''\" kon nie gelaai word nie.",
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'batchuserrights' => 'Пакетнае кіраваньне правамі ўдзельнікаў',
	'batchuserrights-desc' => 'Дазваляе дадаваць аднаго ці болей удзельнікаў у групу ці некалькі групаў за адно дзеяньне',
	'batchuserrights-names' => 'Імёны ўдзельнікаў, для даданьня ў групу (па аднаму на радок):',
	'batchuserrights-intro' => 'Гэтая старонка дазволіць Вам дадаваць у групу адразу некалькі ўдзельнікаў.
Па прычынах бясьпекі, сьпіс апрацоўваемых групаў ўстанаўліваецца ў наладах пашырэньня і ня можа быць зьменены ў {{GRAMMAR:месны|{{SITENAME}}}}.
Калі ласка, запытайце сыстэмнага адміністратара, калі Вам трэба ўключыць пакетнае даданьне для іншых групаў.',
	'batchuserrights-single-progress-update' => '{{PLURAL:$1|Група даданая|Групы даданыя}} для <strong>$2</strong>.',
	'batchuserrights-add-groups' => 'Даданьне $1 {{PLURAL:$1|ўдзельніка|удзельнікаў|удзельнікаў}} ў {{PLURAL:$2|наступную групу|наступныя групы}}: <strong>$3</strong>.',
	'batchuserrights-userload-error' => "Немагчыма загрузіць удзельніка «'''$1'''».",
	'batchuserrights-no-groups' => 'Вы не выбралі ніякай групы.
Нічога ня будзе выканана.
Астатняя частка старонкі будзе адкрытая для таго, каб Вы ўбачылі, якія імёны ўдзельнікаў ня могуць быць загружаныя.',
	'right-batchuserrights' => 'даданьне аднаго ці болей удзельнікаў у групу ці некалькі групаў за адно дзеяньне',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'batchuserrights-add-groups' => 'Добавяне на {{PLURAL:$1|един потребител|$1 потребителя}} в {{PLURAL:$2|следната група|следните групи}}: <strong>$3</strong>.',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'batchuserrights' => 'Gwirioù oberour dre strolladoù',
	'batchuserrights-desc' => "Aotren a ra ouzhpennañ unan pe meur a implijer d'ur strollad, pe meur a hini, en un taol hepken",
	'batchuserrights-names' => "Anvioù implijer da ouzhpennañ d'ar strollad-mañ (unan dre linenn) :",
	'batchuserrights-single-progress-update' => '{{PLURAL:$1|Strollad|Strolladoù}} ouzhpennet da <strong>$2</strong>.',
	'batchuserrights-add-groups' => "Ouzhpennañ {{PLURAL:$1|un implijer|$1 implijer}} d'ar {{PLURAL:$2|strollad|strolladoù}}-mañ : <strong>$3</strong>.",
	'batchuserrights-userload-error' => "Dibosupl eo kargañ an implijer \"'''\$1'''\".",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'batchuserrights-desc' => 'Omogućava dodavanje jednog ili više korisnika u grupu putem jedne akcije',
	'batchuserrights-userload-error' => "Nisam mogao učitati korisnika \"'''\$1'''\".",
);

/** Czech (Česky)
 * @author Dontlietome7
 */
$messages['cs'] = array(
	'batchuserrights' => 'Dávkové přidělení uživatelských práv',
	'batchuserrights-desc' => 'Umožňuje přidání jednoho nebo více uživatelů najednou do skupiny',
	'batchuserrights-names' => 'Uživatelská jména k přidání do této skupiny (1 na řádek):',
	'batchuserrights-intro' => 'Tato stránka vám umožní přidat skupinu pro více uživatelů najednou.
Z bezpečnostních důvodů seznam přidatelných skupin je nastaven v konfiguraci rozšíření a nelze jej měnit v rámci wiki.
Požádejte správce systému, pokud potřebujete povolit dávkové přidáním dalších skupin.',
	'batchuserrights-single-progress-update' => 'Přidána {{PLURAL:$1|skupina|skupiy|skupin}} do <strong>$2</strong>.',
	'batchuserrights-add-groups' => 'Přidávání {{PLURAL:$1|jednoho uževatele|$1 uživatelů}} do následující{{PLURAL:$2| skupiny|ch skupin}}: <strong>$3</strong>.',
	'batchuserrights-userload-error' => "Nelze načíst uživatele \"'''\$1'''\".",
	'batchuserrights-no-groups' => 'Neurčili jste žádné skupiny.
Neprovede se žádná akce.
Zbývající část stránky bude možné spustit tak, že lze snadno zobrazit, pokud některého z uživatelů nelze načíst.',
);

/** German (Deutsch)
 * @author Kghbln
 * @author LWChris
 * @author SVG
 * @author The Evil IP address
 */
$messages['de'] = array(
	'batchuserrights' => 'Sammelbenutzerrechtevergabe',
	'batchuserrights-desc' => 'Ermöglicht das gesammelte Hinzufügen eines oder mehrerer Benutzer zu einer oder mehreren Benutzergruppen',
	'batchuserrights-names' => 'Folgende Benutzer dieser Benutzergruppe hinzufügen (einer pro Zeile):',
	'batchuserrights-intro' => 'Auf dieser Seite kannst du mehrere Benutzer gleichzeitig einer Benutzergruppe hinzufügen.
Aus Sicherheitsgründen wurde die Liste der zuordenbaren Benutzergruppen in der Konfigurationsdatei der Softwareerweiterung selbst festgelegt und kann daher nicht im Wiki verändert werden.
Sofern weitere Benutzergruppen hinzugefügt werden sollen, wende dich bitte an einen Systemadministrator.',
	'batchuserrights-single-progress-update' => '{{PLURAL:$1|Benutzergruppe wurde|Benutzergruppen wurden}} <strong>$2</strong> hinzugefügt.',
	'batchuserrights-add-groups' => '{{PLURAL:$1|Ein Benutzer wird|$1 Benutzer werden}} {{PLURAL:$2|der folgenden Benutzergruppe|den folgenden Benutzergruppen}} hinzugefügt: <strong>$3</strong>',
	'batchuserrights-userload-error' => "Der Benutzer „'''$1'''“ konnte nicht geladen werden.",
	'batchuserrights-no-groups' => 'Du hast keine Benutzergruppe ausgewählt.
Es wird daher keine Änderung durchgeführt.
Der Rest der Seite wird nur deshalb geladen, damit du einfach feststellen kannst, ob einer der Benutzernamen nicht geladen werden konnte.',
	'right-batchuserrights' => 'Mehrere Benutzer gesammelt einer oder mehreren Benutzergruppen hinzufügen',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Kghbln
 */
$messages['de-formal'] = array(
	'batchuserrights-intro' => 'Auf dieser Seite können Sie mehrere Benutzer gleichzeitig einer Benutzergruppe hinzufügen.
Aus Sicherheitsgründen wurde die Liste der zuordenbaren Benutzergruppen in der Konfigurationsdatei der Softwareerweiterung selbst festgelegt und kann daher nicht im Wiki verändert werden.
Sofern weitere Benutzergruppen hinzugefügt werden sollen, wenden Sie sich bitte an einen Systemadministrator.',
	'batchuserrights-no-groups' => 'Sie haben keine Benutzergruppe ausgewählt.
Es wird daher keine Änderung durchgeführt.
Der Rest der Seite wird nur deshalb geladen, damit Sie einfach feststellen können, ob einer der Benutzernamen nicht geladen werden konnte.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'batchuserrights' => 'Pšawa zběrańskich wužywarjow',
	'batchuserrights-desc' => 'Zmóžnja pśidawanje jadnogo wužywarja abo někotarych wužywarjow kupce abo někotarym kupkam skupinam naraz',
	'batchuserrights-names' => 'Wužywarske mjenja, kótarež maju se toś tej kupce pśidaś (jadne na smužku):',
	'batchuserrights-intro' => 'Z toś tym bokom móžoš někotarym wužywarjam naraz kupku pśidaś.
Z pśicynow wěstoty lisćina pśidawajobnych kupkow nastaja se w konfiguraciji rozšyrjenja a njedajo se we wikiju změniś.
Pšosym staj se ze systemowym administratorom do zwiska, jolic musyš dalšne kupki pśidaś.',
	'batchuserrights-single-progress-update' => '{{PLURAL:$1|Kupka j|Kupce stej|Kupki su|Kupki su}} se do <strong>$2</strong> {{PLURAL:$1|pśidała|pśidałej|pśidali|pśidali}}.',
	'batchuserrights-add-groups' => '{{PLURAL:$1|Jaden wužywaŕ|$1 wužywarja|$1 wužywarje|$1 wužiwarjow}} {{PLURAL:$1|pśidawa|pśidawataj|pśidawaju|pśidawa}} se {{PLURAL:$2|slědujucej kupce|slědujucyma kupkoma|slědujucym kupkam|slědujucym kupkam}} : <strong>$3</strong>.',
	'batchuserrights-userload-error' => "Wužywaŕ \"'''\$1'''\" njedajo se zacytaś.",
	'batchuserrights-no-groups' => 'Njejsy žednu kupku wubrał.
Togodla se nic njewuwjeźo.
Zbytk boka se jano zacytujo, aby mógał lažko wiźeś, lěc jadne z wužywarskich mjenjow njedajo se zacytaś.',
	'right-batchuserrights' => 'Jadnogo wužywarja abo někotarych wužywarjow jadnej kupce abo někotarym kupkam naraz pśidaś',
);

/** Spanish (Español)
 * @author Bola
 * @author Sanbec
 */
$messages['es'] = array(
	'batchuserrights' => 'Derechos de usuarios por lotes',
	'batchuserrights-desc' => 'Permite añadir uno o más usuarios a un grupo en una sola acción',
	'batchuserrights-names' => 'Nombres de usuario para añadir a este grupo (uno por línea):',
	'batchuserrights-intro' => 'Esta página te permitirá añadir a un grupo múltiples usuarios a la vez.
Por razones de seguridad, la lista de grupos agregables se cambia en la configuración de la extensión y no puede ser cambiada desde dentro del wiki.
Por favor, pregunta a un administrador del sistema si necesitas añadir otros grupos.',
	'batchuserrights-single-progress-update' => 'Añadido {{PLURAL:$1|grupo|grupos}} a <strong>$2</strong>.',
	'batchuserrights-add-groups' => 'Añadiendo {{PLURAL:$1|un usuario|$1 usuarios}} {{PLURAL:$2|al siguiente grupo|a los siguientes grupos}}: <strong>$3</strong>.',
	'batchuserrights-userload-error' => "No se pudo cargar el usuario \"'''\$1'''\".",
	'batchuserrights-no-groups' => 'No elegiste ningún grupo.
De esta forma no ocurrirá nada.
El resto de la página será ejecutada solo para que puedas ver fácilmente si algún nombre de usuario no se puede cargar.',
);

/** French (Français)
 * @author Gomoko
 * @author Peter17
 * @author Seb35
 */
$messages['fr'] = array(
	'batchuserrights' => 'Droits d’utilisateurs par lots',
	'batchuserrights-desc' => 'Permet d’ajouter un ou plusieurs utilisateur(s) à un ou des groupe(s) en une seule action',
	'batchuserrights-names' => 'Noms d’utilisateurs à ajouter à ce groupe (un par ligne) :',
	'batchuserrights-intro' => 'Cette page permet d’ajouter un groupe à plusieurs utilisateurs en une fois.
Pour des raisons de sécurité, la liste des groupes utilisables est définie dans la configuration de l’extension et ne peut pas être changée depuis l’interface du wiki.
Si vous voulez autoriser l’ajout par lots pour d’autres groupes, veuillez demander leur ajout à un administrateur système.',
	'batchuserrights-single-progress-update' => '{{PLURAL:$1|groupe ajouté|groupes ajoutés}} à <strong>$2</strong>.',
	'batchuserrights-add-groups' => 'Ajout {{PLURAL:$1|d’un utilisateur|de $1 utilisateurs}} {{PLURAL:$2|au groupe suivant|aux groupes suivants}} : <strong>$3</strong>.',
	'batchuserrights-userload-error' => "Impossible de charger l’utilisateur « '''$1''' ».",
	'batchuserrights-no-groups' => 'Vous n’avez choisi aucun groupe.
Aucune action ne sera effectuée.
Le reste de la page se chargera normalement ce qui vous permettra de voir si certains noms d’utilisateurs ne peuvent pas être chargés.',
	'right-batchuserrights' => 'Ajouter un ou plusieurs utilisateurs à un groupe ou plusieurs groupes en une action',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'batchuserrights' => 'Dereitos de usuario en feixe',
	'batchuserrights-desc' => 'Permite engadir un ou máis usuarios a un ou máis grupos cunha soa acción',
	'batchuserrights-names' => 'Nomes de usuario a engadir a este grupo (un por liña):',
	'batchuserrights-intro' => 'Esta páxina permitirá engadir usuarios a un grupo ao mesmo tempo.
Por razóns de seguridade, a lista dos grupos que se poden engadir está definida na configuración da extensión e non se pode cambiar dentro do wiki.
Por favor, pregunte a un administrador do sistema se necesita engadir outros grupos.',
	'batchuserrights-single-progress-update' => 'Engadiu {{PLURAL:$1|un grupo|grupos}} a <strong>$2</strong>.',
	'batchuserrights-add-groups' => 'Engadiu {{PLURAL:$1|un usuario|$1 usuarios}} {{PLURAL:$2|ao seguinte grupo|aos seguintes grupos}}: <strong>$3</strong>.',
	'batchuserrights-userload-error' => "Non se puido cargar o usuario \"'''\$1'''\".",
	'batchuserrights-no-groups' => 'Non elixiu ningún grupo.
Deste modo, non ocorrerá nada.
Que apareza o resto da páxina só serve para que poida ollar facilmente se non se puido cargar algún dos nomes de usuario.',
	'right-batchuserrights' => 'Engadir un ou máis usuarios a un ou máis grupos cunha soa acción',
);

/** Hebrew (עברית)
 * @author Ofekalef
 */
$messages['he'] = array(
	'batchuserrights-names' => 'שמות משתמש להוספה לקבוצה זו (אחד בשורה):',
	'batchuserrights-single-progress-update' => 'נוספה {{PLURAL:$1|קבוצה|קבוצותה}} ל־<strong>$2</strong>.',
	'batchuserrights-userload-error' => "נכשלה טעינת המשתמש \"'''\$1'''\"",
	'right-batchuserrights' => 'הוספת משתמש אחד או יותר לקבוצה או יותר בפעולה אחת',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'batchuserrights' => 'Prawa zběranskich wužiwarjow',
	'batchuserrights-desc' => 'Zmóžnja přidawanje jednoho wužiwarja abo wjacorych wužiwarjow skupinje abo wjacorym skupinam naraz',
	'batchuserrights-names' => 'Wužiwarske mjena, kotrež maja so tutej skupinje přidać (jedne na linku):',
	'batchuserrights-intro' => 'Z tutej stronu móžeš wjacorym wužiwarjam naraz skupinu přidać.
Z přičinow wěstoty lisćina přidawajomnych skupinow nastaja so w konfiguraciji rozšěrjenja a njeda so we wikiju změnić.
Prošu staj so ze systemowym administratorom do zwiska, jeli dyrbiš dalše skupiny přidać.',
	'batchuserrights-single-progress-update' => '{{PLURAL:$1|Skupina je|Skupinje stej|Skupiny su|Skupiny su}} so do <strong>$2</strong> {{PLURAL:$1|přidała|přidałoj|přidali|přidali}}.',
	'batchuserrights-add-groups' => '{{PLURAL:$1|Jedyn wužiwar|$1 wužiwarjej|$1 wužiwarjo|$1 wužiwarjow}} so {{PLURAL:$2|slědowacej skupinje|slědowacymaj skupinomaj|slědowacym skupinam|slědowacym skupinam}} {{PLURAL:$1|přidawa|přidawataj|přidawaja|přidawa}}: <strong>$3</strong>.',
	'batchuserrights-userload-error' => "Wužiwar \"'''\$1'''\" njeda so začitać.",
	'batchuserrights-no-groups' => 'Njejsy žanu skupinu wubrał.
Tohodla so ničo njewukonja.
Zbytk strony so jenož začituje, zo by móhł lochko widźeć, hač jedne z wužiwarskich mjenow njeda so začitać.',
	'right-batchuserrights' => 'Jednoho wužiwarja abo wjacorych wužiwarjow jednej skupinje abo wjacorym skupinam naraz přidać',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'batchuserrights' => 'Derectos de usator in lot',
	'batchuserrights-desc' => 'Permitte adder un o plure usatores a un gruppo o a plure gruppos in un sol action',
	'batchuserrights-names' => 'Nomines de usator al quales adder iste gruppo (un per linea):',
	'batchuserrights-intro' => 'Iste pagina te permitte adder un gruppo a plure usatores insimul.
Pro motivos de securitate, le lista de gruppos addibile es definite in le configuration del extension e non pote esser cambiate ab intra le wiki.
Per favor demanda lo a un administrator de systema si tu ha besonio de permitter le addition in lot de altere gruppos.',
	'batchuserrights-single-progress-update' => 'Addeva {{PLURAL:$1|gruppo|gruppos}} a <strong>$2</strong>.',
	'batchuserrights-add-groups' => 'Adde {{PLURAL:$1|un usator|$1 usator}} al sequente {{PLURAL:$2|gruppo|gruppos}}: <strong>$3</strong>.',
	'batchuserrights-userload-error' => "Non poteva cargar le usator \"'''\$1'''\".",
	'batchuserrights-no-groups' => 'Tu non seligeva alcun gruppo.
Isto va complir nihil.
Le resto del pagina essera executate solmente a fin que tu pote vider facilemente si alcun del nomines de usator non poteva esser cargate.',
	'right-batchuserrights' => 'Adder un o plure usatores a un gruppo o a plure gruppos in un sol action',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'batchuserrights' => 'Benotzerrechter automatiséieren',
	'batchuserrights-desc' => 'Erlaabt et een oder méi Benotzer an enger Aktioun an eng Grupp oder méi Gruppen derbäizesetzen',
	'batchuserrights-names' => 'Benotzernimm fir an dëse Grupp derbäizesetzen (e pro Linn):',
	'batchuserrights-intro' => "Op dëser Säit kënnt Dir méi Benotzer mateneen bäi eng Benotzergrupp derbäisetzen.
Aus Sécherheitsgrën ass d'Lëscht vu Benotzergruppen déi derbäigesat kënne ginn am Konfigurationsfichier  vun der Erweiderung festgeluecht a kann net vun dëser Wiki aus geännert ginn.
Frot w.e.g. e System-Administrateur wann dës Fonctioun fir aner Benotzergruppe gebraucht gëtt.",
	'batchuserrights-single-progress-update' => '{{PLURAL:$1|Grupp|Gruppe}} bäi <strong>$2</strong> derbäigesat.',
	'batchuserrights-add-groups' => '{{PLURAL:$1|Ee Benotzer gëtt|$1 Benotzer gi}} bäi dës {{PLURAL:$2|Benotzergrupp|Benotzergruppen}} derbäigesat: <strong>$3</strong>',
	'batchuserrights-userload-error' => "De Benotzer \"'''\$1'''\" konnt net geluede ginn.",
	'batchuserrights-no-groups' => 'Dir hutt keng Gruppen erausgesicht.
Et gëtt näischt geännert.
De Rescht vun der Säit gëtt nei opgebaut esou datt Dir einfach gesi kënnt ob ee vun de Benotzernimm net konnt geluede ginn.',
	'right-batchuserrights' => 'Een oder méi Benotzer an enger Aktioun an eng oder méi Gruppen derbäisetzen',
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 */
$messages['lt'] = array(
	'batchuserrights-single-progress-update' => 'Pridėta {{PLURAL:$1| grupė | grupės}} į <strong>$2</strong> .',
	'batchuserrights-userload-error' => "Nepavyko įkelti naudotojo \"''' \$1 '''\".",
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'batchuserrights' => 'Групни кориснички права',
	'batchuserrights-desc' => 'Овозможува додавање на еден или повеќе корисници во група/и наеднаш',
	'batchuserrights-names' => 'Кориснички имиња кон кои треба да се додаде оваа група (по едно во секој ред):',
	'batchuserrights-intro' => 'Оваа страница ви овозможува да додадете група кон повеќе корисници наеднаш.
Од безбедносни причини, списокот на групи што може да се додаваат е сместена во поставките на додатокот и не може да се промени од викито.
Прашајте го системскиот администратор дали треба да дозволите групно додавање на други групи.',
	'batchuserrights-single-progress-update' => 'Додадени {{PLURAL:$1|група|групи}} кон <strong>$2</strong>.',
	'batchuserrights-add-groups' => '{{PLURAL:$1|Се додава еден корисник|Се додаваат $1 корисници}} кон {{PLURAL:$2|следнава група|следниве групи}}: <strong>$3</strong>.',
	'batchuserrights-userload-error' => "Не можев да го вчитам корисникот „'''$1'''“.",
	'batchuserrights-no-groups' => 'Не одбравте ниедна група.
Со ова нема да постигнете ништо.
Остатокот од страницата ќе работи и понатаму за да можете лесно да видите дали некое корисничко име не можело да се вчита.',
	'right-batchuserrights' => 'Додавање на еден или повеќе корисници во група/групи наеднаш',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'batchuserrights' => 'Hak pengguna kelompok',
	'batchuserrights-desc' => 'Membolehkan penambahan satu atau lebih pengguna ke dalam satu atau lebih kumpulan secara serentak',
	'batchuserrights-names' => 'Nama-nama pengguna untuk disertakan ke dalam kumpulan ini (seorang sebaris):',
	'batchuserrights-intro' => 'Laman ini akan membolehkan anda menyertakan lebih daripada satu pengguna ke dalam satu kumpulan sekaligus.
Demi keselamatan, senarai kumpulan yang boleh ditambah itu ditetapkan dalam tatarajah sambungan dan tidak boleh diubah dari dalam wiki.
Sila tanya pentadbir sistem jika anda perlu membenarkan penambahan kumpulan lain secara berkelompok.',
	'batchuserrights-single-progress-update' => '{{PLURAL:$1|Kumpulan|Kumpulan-kumpulan}} ditambahkan ke dalam <strong>$2</strong>.',
	'batchuserrights-add-groups' => '{{PLURAL:$1|Seorang pengguna|$1 orang pengguna}} sedang ditambahkan ke dalam {{PLURAL:$2|kumpulan|kumpulan-kumpulan}} berikut: <strong>$3</strong>.',
	'batchuserrights-userload-error' => "Pengguna \"'''\$1'''\" tidak dapat dimuatkan.",
	'batchuserrights-no-groups' => 'Anda belum memilih mana-mana kumpulan.
Ini tidak akan mendatangkan sebarang hasil.
Yang selebihnya dalam laman ini akan dibenarkan berjalan supaya anda mudah melihat sama ada terdapat nama pengguna yang tidak dapat dimuatkan.',
	'right-batchuserrights' => 'Menambahkan seorang atau berbilang pengguna ke dalam kumpulan atau berbilang kumpulan sekaligus',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'batchuserrights' => 'Puljeoppdater brukerrettigheter',
	'batchuserrights-desc' => 'Tillater å legge én eller flere brukere til en gruppe i én handling',
	'batchuserrights-names' => 'Brukernavn som skal legges til denne gruppen (ett per linje):',
	'batchuserrights-intro' => 'Denne siden lar deg legge flere brukere til en gruppe samtidig.
Av sikkerhetsmessige årsaker, er listen over mulige grupper satt i utvidelseskonfigurasjonen og kan ikke endres fra wikien.
Vennligst spør en systemadministrator hvis du har behov for å tillate puljetillegging av andre grupper.',
	'batchuserrights-single-progress-update' => 'Lagt {{PLURAL:$1|gruppe|grupper}} til <strong>$2</strong>.',
	'batchuserrights-add-groups' => 'Legger {{PLURAL:$1|én bruker|$1 brukere}} til {{PLURAL:$2|den|de}} følgende {{PLURAL:$2|gruppen|gruppene}}: <strong>$3</strong>.',
	'batchuserrights-userload-error' => "Kunne ikke laste brukeren «'''$1'''».",
	'batchuserrights-no-groups' => 'Du valgte ingen grupper.
Dette vil ikke oppnå noe.
Resten av siden vil få lov til å kjøre slik at du enkelt kan se om noen av brukernavnene ikke kunnes lastes.',
);

/** Dutch (Nederlands)
 * @author McDutchie
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'batchuserrights' => 'Gebruikersrechtenbeheer (en masse)',
	'batchuserrights-desc' => 'Maakt het toevoegen van één of meerdere gebruikers aan een groep of groepen in één handeling mogelijk',
	'batchuserrights-names' => 'Gebruikersnamen om deze groep aan toe te voegen (één per regel):',
	'batchuserrights-intro' => 'Via deze pagina kunt u meerdere gebruikers tegelijkertijd aan een groep toevoegen.
Om beveiligingsredenen wordt de lijst met beschikbare groepen ingesteld in de instellingen van de uitbreiding en deze groepen kunnen niet vanuit de wiki gewijzigd worden.
Vraag hulp van een systeembeheerder als u de beschikbare groepen wilt wijzigen.',
	'batchuserrights-single-progress-update' => 'De {{PLURAL:$1|groep is|groepen zijn}} toegevoegd aan <strong>$2</strong>.',
	'batchuserrights-add-groups' => 'Bezig met het toevoegen van {{PLURAL:$1|één gebruiker|$1 gebruikers}} aan de volgende {{PLURAL:$2|groep|groepen}}: <strong>$3</strong>.',
	'batchuserrights-userload-error' => "De gebruiker \"'''\$1'''\" kon niet geladen worden.",
	'batchuserrights-no-groups' => 'U hebt geen groepen gekozen.
Nu wordt er niets uitgevoerd.
De rest van de pagina kan uitgevoerd worden zodat u eenvoudig kunt zien of een van de gebruikersnamen niet geladen kon worden.',
	'right-batchuserrights' => 'Een of meerdere gebruikers aan een of meerdere groepen toevoegen in één actie',
);

/** ‪Nederlands (informeel)‬ (‪Nederlands (informeel)‬)
 * @author Siebrand
 */
$messages['nl-informal'] = array(
	'batchuserrights-intro' => 'Via deze pagina kan je meerdere gebruikers tegelijkertijd aan een groep toevoegen.
Om beveiligingsredenen wordt de lijst met beschikbare groepen ingesteld in de instellingen van de uitbreiding en deze groepen kunnen niet vanuit de wiki gewijzigd worden.
Vraag hulp van een systeembeheerder als je de beschikbare groepen wilt wijzigen.',
	'batchuserrights-no-groups' => 'Je hebt geen groepen gekozen.
Nu wordt er niets uitgevoerd.
De rest van de pagina kan uitgevoerd worden zodat je eenvoudig kunt zien of een van de gebruikersnamen niet geladen kon worden.',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'batchuserrights' => "Drit ëd j'utent për partìe",
	'batchuserrights-desc' => "A përmët ëd gionté un o pi utent a na partìa o a pi partìe con n'assion sola",
	'batchuserrights-names' => "Stranòm d'utent da gionté a costa partìa (un për linia):",
	'batchuserrights-intro' => "Sta pàgina a-j përmëttrà ëd gionté na partìa a vàire utent ant un colp.
Për rason ëd sicurëssa, la lista ëd partìe giontàbij a l'é ampostà ant la configurassion ëd l'estension e a peul pa esse cangià d'andrinta a la wiki.
Për piasì, ch'a ciama a n'aministrator ëd sistema s'a l'ha dabzògn ëd gionté a mucc d'àutre partìe.",
	'batchuserrights-single-progress-update' => 'Giontà {{PLURAL:$1|partìa|partìe}} a <strong>$2</strong>.',
	'batchuserrights-add-groups' => "Gionté {{PLURAL:$1|n'utent|$1 utent}} a {{PLURAL:$2|la partìa|le partìe}}  sì-dapress: <strong>$3</strong>.",
	'batchuserrights-userload-error' => "As peul pa carié l'utent \"'''\$1'''\".",
	'batchuserrights-no-groups' => "A l'ha sernù gnun-e partìe.
A sarà fàit gnente.
Ël rest ëd la pàgina a podrà giré mach an manera ch'a vëdda facilment se quaidun djë stranòm d'utent a peulo pa esse carià.",
	'right-batchuserrights' => "Gionté un o pi utent a na partia o a pi partìe con n'assion sola",
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Waldir
 */
$messages['pt'] = array(
	'batchuserrights' => 'Direitos de utilizador em lote',
	'batchuserrights-desc' => 'Permite adicionar um ou mais utilizadores a um grupo de uma só vez',
	'batchuserrights-names' => 'Nomes de utilizador a adicionar a este grupo (um por linha):',
	'batchuserrights-intro' => 'Esta página permite atribuir um grupo a vários utilizadores ao mesmo tempo.
Por razões de segurança, a lista dos grupos assim atribuíveis é definida na configuração da extensão e não pode ser alterada dentro da wiki.
Se precisa de acrescentar mais grupos atribuíveis, peça a um administrador.',
	'batchuserrights-single-progress-update' => '{{PLURAL:$1|O grupo foi atribuído|Os grupos foram atribuídos}} a <strong>$2</strong>.',
	'batchuserrights-add-groups' => 'A adicionar {{PLURAL:$1|um utilizador|$1 utilizadores}} {{PLURAL:$2|ao seguinte grupo|aos seguintes grupos}}: <strong>$3</strong>.',
	'batchuserrights-userload-error' => "Não foi possível carregar o utilizador \"'''\$1'''\".",
	'batchuserrights-no-groups' => 'Não escolheu nenhum grupo.
Isto não terá qualquer efeito.
Será permitida a execução do resto da página apenas para que possa verificar se não foi possível carregar algum dos utilizadores.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 */
$messages['pt-br'] = array(
	'batchuserrights' => 'Direitos de usuários em lote',
	'batchuserrights-desc' => 'Permite adicionar um ou mais usuários a um grupo de uma só vez',
	'batchuserrights-names' => 'Nomes de usuários a adicionar a este grupo (um por linha):',
	'batchuserrights-intro' => 'Esta página permite atribuir um grupo a vários usuários ao mesmo tempo.
Por razões de segurança, a lista dos grupos assim atribuíveis é definida na configuração da extensão e não pode ser alterada dentro da wiki.
Se você precisar acrescentar mais grupos atribuíveis, peça a um administrador.',
	'batchuserrights-single-progress-update' => '{{PLURAL:$1|O grupo foi atribuído|Os grupos foram atribuídos}} a <strong>$2</strong>.',
	'batchuserrights-add-groups' => 'A adicionar {{PLURAL:$1|um usuário|$1 usuários}} {{PLURAL:$2|ao seguinte grupo|aos seguintes grupos}}: <strong>$3</strong>.',
	'batchuserrights-userload-error' => "Não foi possível carregar o usuário \"'''\$1'''\".",
	'batchuserrights-no-groups' => 'Você não escolheu nenhum grupo.
Isto não terá qualquer efeito.
Será permitida a execução do resto da página apenas para que você possa verificar se não foi possível carregar algum dos usuários.',
);

/** Russian (Русский)
 * @author Eleferen
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'batchuserrights' => 'Пакетное управление правами участников',
	'batchuserrights-desc' => 'Позволяет добавлять нескольких участников в группу или несколько групп за одно действие',
	'batchuserrights-names' => 'Учётные записи, для включения в группу (по одному на строке):',
	'batchuserrights-intro' => 'Эта страница позволяет добавить группу в сразу несколько участников.
По соображениям безопасности, список обрабатываемых групп устанавливается в настройках расширения и не может быть изменён в вики.
Пожалуйста, обратитесь к системному администратору, если вы хотите включить пакетное добавление для других групп.',
	'batchuserrights-single-progress-update' => '{{PLURAL:$1|Добавлена группа|Добавлены группы}} для <strong>$2</strong>.',
	'batchuserrights-add-groups' => 'Добавление {{PLURAL:$1|$1 участника|$1 участников|$1 участников}} в {{PLURAL:$2|следующую группу|следующие группы}}: <strong>$3</strong>.',
	'batchuserrights-userload-error' => "Не удалось загрузить участника '''«$1»'''.",
	'batchuserrights-no-groups' => 'Вы не выбрали группы.
Ничего не будет выполнено.
Оставшаяся часть страницы будет обработана, чтобы показать какие учётные записи не могут быть загружены.',
	'right-batchuserrights' => 'Позволяет добавлять нескольких участников в группу или несколько групп за одно действие',
);

/** Swedish (Svenska)
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'batchuserrights-single-progress-update' => 'Lade till {{PLURAL:$1|grupp|grupperna}} till <strong>$2</strong>.',
	'batchuserrights-add-groups' => 'Lägger till {{PLURAL:$1|en användare|$1 användare}} till följande {{PLURAL:$2|grupp|grupper}}: <strong>$3</strong>.',
	'batchuserrights-userload-error' => "Kunde inte läsa in användaren \"'''\$1'''\".",
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'batchuserrights' => 'Mga karapatan ng tagagamit ng langkay',
	'batchuserrights-desc' => 'Nagpapahintulot  ng pagdaragdag ng isa o mas marami pang mga tagagamit sa isang pangkat sa pamamagitan ng isang galaw',
	'batchuserrights-names' => 'Mga pangalan ng tagagamit na pagdaragdagan ng pangkat na ito (isa bawat guhit):',
	'batchuserrights-intro' => 'Ang pahinang ito ay kaagad na magpapahintulot sa iyo na magdagdag ng isang pangkat sa maramihang mga tagagamit.
Para sa mga kadahilanang pangkaligtasan, ang talaan ng maidaragdag na mga pangkat ay nakatakda sa kaayusan ng dugtong at hindi mababago sa loob ng wiki.
Mangyaring makipag-ugnayan sa isang tagapangasiwa ng sistema kung kailangan mong pahintulutan ang pagdaragdag ng langkay ng ibang mga pangkat.',
	'batchuserrights-single-progress-update' => 'Nagdagdag ng {{PLURAL:$1|pangkat|mga pangkat}} sa <strong>$2</strong>.',
	'batchuserrights-add-groups' => 'Nagdaragdag ng {{PLURAL:$1|isang tagagamit|$1 mga tagagamit}} sa sumusunod na {{PLURAL:$2|pangkat|mga pangkat}}: <strong>$3</strong>.',
	'batchuserrights-userload-error' => "Hindi maikarga ang tagagamit na \"'''\$1'''\".",
	'batchuserrights-no-groups' => 'Hindi ka pumili ng alin mang mga pangkat.
Hindi ito makagagawa ng anumang bagay.
Ang natitirang bahagi ng pahina ay papahintulutang tumakbo upang maginhawa mong makita kung ang alin man sa mga pangalan ng tagagamit ay hindi maikakarga.',
);

/** Ukrainian (Українська)
 * @author Тест
 */
$messages['uk'] = array(
	'batchuserrights-desc' => 'Дозволяє додавати одного або декількох користувачів в групу за одну дію',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hydra
 * @author Hzy980512
 * @author Linforest
 */
$messages['zh-hans'] = array(
	'batchuserrights' => '批处理的用户权限',
	'batchuserrights-desc' => '允许将一个或多个用户添加到一个操作中的一个组',
	'batchuserrights-names' => '添加至该组的用户（每行一个）：',
	'batchuserrights-userload-error' => "无法加载用户\"'''\$1'''\"。",
);

/** Traditional Chinese (‪中文(繁體)‬) */
$messages['zh-hant'] = array(
	'batchuserrights' => '批處理的用戶權限',
);

