<?php
/**
 * Internationalisation file for extension Plotters. Based on the Gadgets extension.
 *
 * @file
 * @ingroup Extensions
 * @author Ryan Lane, rlane32+mwext@gmail.com
 * @copyright © 2009 Ryan Lane
 * @license GNU General Public Licence 2.0 or later
 */

$messages = array();

/** English
 * @author Ryan Lane, rlane32+mwext@gmail.com
 * @author Purodha
 */
$messages['en'] = array(
	# for Special:Version
	'plotters-desc'      => 'Lets users use custom JavaScript in jsplot tags',

	# for Special:Plotters
	'plotters'           => 'Plotters',
	'plotters-title'     => 'Plotters',
	'plotters-pagetext'  => "Below is a list of special plotters users can use in their jsplot tags, as defined by [[MediaWiki:Plotters-definition]].
This overview provides easy access to the system message pages that define each plotter's description and code.",

	# for Special:Plotters-definition
	'plotters-uses'      => 'Uses',
	'plotters-missing-script'      => 'No script was defined.',
	'plotters-missing-arguments'      => 'No arguments specified.',
	'plotters-excessively-long-scriptname'      => 'The script name is too long.
Please define a script, the name of which is 255 characters long at most.',
	'plotters-excessively-long-preprocessorname'      => 'The preprocessor name is too long.
Please define a preprocessor, the name of which is 255 characters long at most.',
	'plotters-excessively-long-name'      => 'The plot name is too long.
Please define a plot name that has 255 characters at most.',
	'plotters-excessively-long-tableclass'      => 'The tableclass is too long.
Please define a tableclass that has 255 characters at most.',
	'plotters-no-data'      => 'No data was provided.',
	'plotters-invalid-renderer'      => 'An invalid renderer was selected.',
	'plotters-errors'      => 'Plotters {{PLURAL:$1|error|errors}}:',
);

/** Message documentation (Message documentation)
 * @author Fryed-peach
 * @author Purodha
 */
$messages['qqq'] = array(
	'plotters-desc' => '{{desc}}',
	'plotters-errors' => 'Parameters:
$1 = number of messages following. Can be used with PLURAL.',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'plotters-desc' => 'يدع المستخدمين يستخدمون جافاسكريبت معدلة في وسوم jsplot',
	'plotters' => 'رسامات',
	'plotters-title' => 'رسامات',
	'plotters-pagetext' => 'بالأسفل قائمة بالرسامين الخاصين يمكن للمستخدمين استخدامها في وسوم jsplot، كما هو معرف بواسطة [[MediaWiki:Plotters-definition]].
هذا العرض العام يوفر وصولا سهلا لصفحات رسائل النظام التي تعرف وصف وكود كل رسام.',
	'plotters-uses' => 'تستخدم',
	'plotters-missing-script' => 'لا سكربت مُعرّف.',
	'plotters-missing-arguments' => 'لا معطى محدّد.',
	'plotters-excessively-long-scriptname' => 'اسم السكربت طويل جدًا.
من فضلك عرّف سكربتًا اسمه لا يتجاوز 255 حرفًا.',
	'plotters-excessively-long-preprocessorname' => 'اسم المعالج الأولي طويل جدا.
من فضلك عرف معالجا أوليا، اسمه طوله 255 حرفا كحد أقصى.',
	'plotters-excessively-long-name' => 'اسم الرسام طويل جدا.
من فضلك عرف اسم رسام به 255 حرف كحد أقصى.',
	'plotters-excessively-long-tableclass' => 'رتبة الجدول طويلة جدا.
من فضلك عرف رتبة جدول لديها 255 حرف كحد أقصى.',
	'plotters-no-data' => 'لا بيانات متوفرة.',
	'plotters-invalid-renderer' => 'عارض غير صحيح تم اختياره.',
	'plotters-errors' => '{{PLURAL:$1|خطأ|أخطاء}} الرسام:',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'plotters-desc' => 'Дазваляе ўдзельнікам выкарыстоўваць уласны JavaScript у тэгах jsplot',
	'plotters' => 'Плотары',
	'plotters-title' => 'Плотары',
	'plotters-pagetext' => 'Ніжэй пададзены сьпіс спэцыяльных плотараў, якія ўдзельнікі могуць выкарыстоўваць у тэгах jsplot, як вызначана ў [[MediaWiki:Plotters-definition]].
Гэта дазваляе атрымаць доступ да старонак з сыстэмнымі паведамленьнямі, якія вызначаюць апісаньне і код кожнага плотара.',
	'plotters-uses' => 'Выкарыстаньні',
	'plotters-missing-script' => 'Скрыпт ня вызначаны.',
	'plotters-missing-arguments' => 'Аргумэнты не пазначаныя.',
	'plotters-excessively-long-scriptname' => 'Назва скрыпта занадта доўгая.
Калі ласка, вызначце скрыпт, назва якога ня больш за 255 сымбаляў.',
	'plotters-excessively-long-preprocessorname' => 'Назва прэпрацэсара занадта доўгая.
Калі ласка, вызначце прэпрацэсар, назва якога ня больш за 255 сымбаляў.',
	'plotters-excessively-long-name' => 'Назва плотара занадта доўгая.
Калі ласка, прызначце назву плотара даўжынёй ня болей 255 сымбаляў.',
	'plotters-excessively-long-tableclass' => 'Назва клясы табліцы занадта доўгая.
Калі ласка, вызначце клясу табліцы, назва якой ня больш за 255 сымбаляў.',
	'plotters-no-data' => 'Зьвесткі не пададзеныя.',
	'plotters-invalid-renderer' => 'Выбраны няслушны генэратар выяваў.',
	'plotters-errors' => '{{PLURAL:$1|Памылка плотара|Памылкі плотара}}:',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'plotters-uses' => 'ব্যবহারকারীগণ',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'plotters-desc' => 'Lezel a ra an implijerien da implijout JavaScript personelaet er balizennoù jsplot',
	'plotters' => 'Treselloù grafek',
	'plotters-title' => 'Treselloù grafek',
	'plotters-pagetext' => "Setu aze a-is roll an treselloù dibar a c'hall an implijerien ober ganto en o balizennoù jsplot, evel m'eo termenet e [[MediaWiki:Plotters-definition]].
Dre ar brassell-mañ e c'haller gwelet aes ar c'hemennadennoù reizhiad eo termenet ar chod ganto ha termenadur pep tresell.",
	'plotters-uses' => 'Implijoù',
	'plotters-missing-script' => "N'eus bet termenet skript ebet.",
	'plotters-missing-arguments' => "N'eus bet spisaet arguzenn ebet.",
	'plotters-excessively-long-scriptname' => "Re hir eo anv ar skript.
Termenit ur skript dezhañ un anv a 255 arouezenn d'ar muiañ.",
	'plotters-excessively-long-preprocessorname' => "Re hir eo anv ar rakprosesor.
Termenit ur rakprosesor dezhañ un anv a 255 arouezenn d'ar muiañ.",
	'plotters-excessively-long-name' => "Re hir eo anv ar graf. 
Termenit ur graf dezhañ un anv a 255 arouezenn d'ar muiañ.",
	'plotters-excessively-long-tableclass' => "Re hir eo rummad an daolenn. 
Termenit ur rummad taolenn na'z aio ket en tu all da 255 arouezenn.",
	'plotters-no-data' => "N'eus bet pourchaset roadenn ebet.",
	'plotters-invalid-renderer' => "Diuzet ez eus bet ur c'heflusker rentañ direizh.",
	'plotters-errors' => '{{PLURAL:$1|fazi|fazioù}} treselloù :',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'plotters-desc' => 'Omogućuje korisnicima prilagođene JavaScript u jsplot oznakama',
	'plotters' => 'Ploteri',
	'plotters-title' => 'Ploteri',
	'plotters-pagetext' => 'Ispod je spisak posebnih plotera koje korisici mogu upotrebljavati u svojim jsplot oznakama, kako je definirano u [[MediaWiki:Plotters-definition]].
Ovaj pregled omogućuje jednostavni pristup na stranice sistemskih poruka koje definiraju svaki opis i kod plotera.',
	'plotters-uses' => 'Korištenja',
	'plotters-missing-script' => 'Nije definirana nijedna skirpta.',
	'plotters-missing-arguments' => 'Nisu navedeni argumenti.',
	'plotters-excessively-long-scriptname' => 'Naziv skripte je predug. Molimo definirajte naziv skripte koji je manji od 255 znakova.',
	'plotters-excessively-long-preprocessorname' => 'Naziv preprocesora je predug.
Molimo definirajte preprocesor, tako da ime ne bude duže od 255 znakova.',
	'plotters-excessively-long-name' => 'Naziv plota je predug.
Molimo definirajte naziv plota da ne bude duži od 255 znakova.',
	'plotters-excessively-long-tableclass' => 'Klasa tabele je preduga.
Molimo definirajte klasu tabele tako da ima najviše 255 znakova.',
	'plotters-no-data' => 'Nisu navedeni podaci.',
	'plotters-invalid-renderer' => 'Odabran je nevaljan renderer.',
	'plotters-errors' => '{{PLURAL:$1|Greška|Greške}} plotera:',
);

/** German (Deutsch)
 * @author Avatar
 * @author Imre
 * @author Kghbln
 * @author MF-Warburg
 * @author Sebastian Wallroth
 * @author Umherirrender
 */
$messages['de'] = array(
	'plotters-desc' => 'Erlaubt Benutzern die Verwendung von spezifischem JavaScript in jsplot-Tags',
	'plotters' => 'Plotter',
	'plotters-title' => 'Plotter',
	'plotters-pagetext' => 'Die folgende Liste gibt spezielle Plotter an, die ein Benutzer innerhalb der jsplot-Tags verwenden kann. Diese sind auf der Spezialseite [[MediaWiki:Plotters-definition|Plotterdefinitionen]] beschrieben.
Die Übersicht ermöglicht ein einfaches Auffinden der Seiten mit den Systemnachrichten, die die einzelnen Plotter, mitsamt dem zugehörigen Code, definieren.',
	'plotters-uses' => 'Nutzungen',
	'plotters-missing-script' => 'Es wurde kein Skript definiert.',
	'plotters-missing-arguments' => 'Keine Argumente festgelegt.',
	'plotters-excessively-long-scriptname' => 'Der Skriptname ist zu lang.
Bitte lege ein Skript fest, dessen Titel 255 Zeichen nicht übersteigt.',
	'plotters-excessively-long-preprocessorname' => 'Der Name des Präprozessors ist zu lang.
Bitte lege einen Präprozessor fest, dessen Name 255 Zeichen nicht übersteigt.',
	'plotters-excessively-long-name' => 'Der Entwurfsname ist zu lang. 
Bitte definiere einen Entwurfsnamen, der aus höchstens 255 Zeichen besteht.',
	'plotters-excessively-long-tableclass' => 'Die Tabellenklasse ist zu lang.
Bitte definiere eine Tabellenklasse, die maximal 255 Zeichen aufweist.',
	'plotters-no-data' => 'Es wurden keine Daten angegeben.',
	'plotters-invalid-renderer' => 'Es wurde ein ungültiger Renderer ausgewählt.',
	'plotters-errors' => 'Plotter{{PLURAL:$1|fehler|fehler}}:',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Imre
 * @author Kghbln
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'plotters-excessively-long-scriptname' => 'Der Name des Skripts ist zu lang.
Bitte legen Sie ein Skript fest, dessen Name maximal 255 Zeichen aufweist.',
	'plotters-excessively-long-preprocessorname' => 'Der Name des Präprozessors ist zu lang.
Bitte definieren Sie einen Präprozessor, dessen Name maximal 255 Zeichen aufweist.',
	'plotters-excessively-long-name' => 'Der Name des Entwurfs ist zu lang.
Bitte definieren Sie einen Entwurf, dessen Name maximal 255 Zeichen aufweist.',
	'plotters-excessively-long-tableclass' => 'Die Tabellenklasse ist zu lang.
Bitte definieren Sie eine Tabellenklasse, die maximal 255 Zeichen aufweist.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'plotters-desc' => 'Zmóžnja wužywarjam swójski JavaScript w toflickach jsplot wužywaś',
	'plotters' => 'Plotery',
	'plotters-title' => 'Plotery',
	'plotters-pagetext' => 'Dołojce jo lisćina specialnych ploterow, kótarež wužywarje mógu w swójich toflickach jsplot wužywaś, kaž pśez [[MediaWiki:Plotters-definition]] definěrowane.
Toś ten pśeglěd dawa lažki pśistup k bokam systenmowych powěźeńkow, kótarež definěruju wopisanje a kode kuždego plotera.',
	'plotters-uses' => 'Wužywa',
	'plotters-missing-script' => 'Žeden skript njejo se definěrował.',
	'plotters-missing-arguments' => 'Žedne argumenty pódane.',
	'plotters-excessively-long-scriptname' => 'Mě skripta jo pśedłujke. Pšosym definěruj skript, kótaryž ma mjenjej ako 255 znamuškow.',
	'plotters-excessively-long-preprocessorname' => 'Mě preprocesora jo pśedłujke. Pšosym definěruj preprocesor, kótaryž ma mjenjej ako 255 znamuškow.',
	'plotters-excessively-long-name' => 'Mě plota jo pśedłujke.
Pšosym definěruj plotowe mě, kótarež ma maksimalnje 255 znamuškow.',
	'plotters-excessively-long-tableclass' => 'Tabelowa klasa jo pśedłujka. Pšosym definěruj tabelowu klasu, kótaraž ma jano 255 znamuškow.',
	'plotters-no-data' => 'Žedne daty njejsu se pódali.',
	'plotters-invalid-renderer' => 'Njepłaśiwy kreslak jo se wubrał.',
	'plotters-errors' => '{{PLURAL:$1|Ploterowa zmólka|Ploterowej zmólce|Ploterowe zmólki|Ploterowe zmólki}}:',
);

/** Greek (Ελληνικά)
 * @author ZaDiak
 */
$messages['el'] = array(
	'plotters' => 'Σχεδιοποιητές',
	'plotters-title' => 'Σχεδιοποιητές',
	'plotters-uses' => 'Χρήσεις',
	'plotters-missing-script' => 'Δεν προσδιορίστηκε κανένα σκριπτ',
	'plotters-missing-arguments' => 'Δεν καθορίστηκαν επιχειρήματα',
	'plotters-no-data' => 'Δεν παρασχέθηκαν δεδομένα.',
	'plotters-errors' => 'Σχεδιοποιητές {{PLURAL:$1|σφάλματος|σφαλμάτων}}:',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Locos epraix
 * @author Pertile
 */
$messages['es'] = array(
	'plotters-desc' => 'Deja a los usuarios usar JavaScript personalizada en etiquetas jsplot',
	'plotters' => 'Plotters',
	'plotters-title' => 'Plotters',
	'plotters-pagetext' => 'A continuación hay una lista de graficadores especiales que los usuarios pueden usar en sus etiquetas jsplot, tal como fueron definidas en [[MediaWiki:Plotters-definition]].
Este resumen provee un fácil acceso a las páginas de los mensajes de sistema que definen la descripción y el código de cada graficador.',
	'plotters-uses' => 'Usos',
	'plotters-missing-script' => 'No se definió el script.',
	'plotters-missing-arguments' => 'No se especificaron argumentos.',
	'plotters-excessively-long-scriptname' => 'El nombre del script es demasiado largo.
Por favor define un script, cuyo nombre tenga 255 caracteres de longitud como máximo.',
	'plotters-excessively-long-preprocessorname' => 'El nombre del preprocesador es demasiado largo.
Por favor define un preprocesador, cuyo nombre tenga 255 caracteres de longitud como máximo.',
	'plotters-excessively-long-name' => 'El nombre del gráfico es muy largo.
Por favor defina un nombre de gráfico que no supere los 255 caracteres.',
	'plotters-excessively-long-tableclass' => 'La clase de tabla es muy larga.
Por favor defina una clase de tabla que no supere los 255 caracteres.',
	'plotters-no-data' => 'sin datos proveídos',
	'plotters-invalid-renderer' => 'Se seleccionó un renderizador inválido.',
	'plotters-errors' => '{{PLURAL:$1|Error|Errores}} de graficadores:',
);

/** Persian (فارسی)
 * @author Mjbmr
 */
$messages['fa'] = array(
	'plotters-uses' => 'کاربردها',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 */
$messages['fi'] = array(
	'plotters-desc' => 'Mahdollistaa käyttäjille mukautetun JavaScriptin käytön jsplot-elementeissä.',
	'plotters-uses' => 'Käyttää',
	'plotters-missing-script' => 'Mitään skriptiä ei määritetty.',
	'plotters-excessively-long-scriptname' => 'Skriptin nimi on liian pitkä.
Nimeä skripti jonka nimi on enimmiltään 255 merkkiä pitkä.',
	'plotters-no-data' => 'Tietoa ei saatu.',
);

/** French (Français)
 * @author Crochet.david
 * @author IAlex
 * @author Urhixidur
 */
$messages['fr'] = array(
	'plotters-desc' => 'Permet aux utilisateurs d’utiliser du javascript personnalisé dans les balises jsplot',
	'plotters' => 'traceurs',
	'plotters-title' => 'traceurs',
	'plotters-pagetext' => 'Ci-dessous se trouve la liste des traceurs spéciaux que les utilisateurs peuvent utiliser dans leurs balises jsplot, comme définies sur [[MediaWiki:Plotters-definition]].
Cette vue d’ensemble permet d’accéder facilement aux messages système qui définissent le code et la description de chaque traceur.',
	'plotters-uses' => 'Utilise',
	'plotters-missing-script' => 'Aucun script n’a été défini.',
	'plotters-missing-arguments' => 'Aucun argument n’a été spécifié.',
	'plotters-excessively-long-scriptname' => 'Le nom du script est trop long. Veuillez spécifier un nom qui soit long de 255 caractères ou moins.',
	'plotters-excessively-long-preprocessorname' => 'Le nom du préprocesseur est trop long. Définissez un nom qui soit long de 255 caractères ou moins.',
	'plotters-excessively-long-name' => 'Le nom du graphe est trop long. Définissez un nom qui soit long de 255 caractères ou moins.',
	'plotters-excessively-long-tableclass' => 'La classe du tableau est trop longue. Définissez un nom de classe qui soit long de 255 caractères ou moins.',
	'plotters-no-data' => 'Aucune donnée n’a été fournie.',
	'plotters-invalid-renderer' => 'Un moteur de rendu invalide a été sélectionné.',
	'plotters-errors' => '{{PLURAL:$1|Erreur|Erreurs}} de traceurs :',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'plotters' => 'Traciors',
	'plotters-title' => 'Traciors',
	'plotters-uses' => 'Usâjos',
	'plotters-missing-script' => 'Nion scripte at étâ dèfeni.',
	'plotters-missing-arguments' => 'Nion argument at étâ spècefiâ.',
	'plotters-no-data' => 'Niona balyê at étâ balyê.',
	'plotters-invalid-renderer' => 'Un motor de rendu envalido at étâ chouèsi.',
	'plotters-errors' => 'Èrror{{PLURAL:$1||s}} de traciors :',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'plotters-desc' => 'Permite que os usuarios empreguen JavaScript personalizado nas súas etiquetas jsplot',
	'plotters' => 'Plotters',
	'plotters-title' => 'Plotters',
	'plotters-pagetext' => 'A continuación está a lista dos plotters especiais que os usuarios poden empregar nas súas etiquetas jsplot, tal e como está definido pola páxina [[MediaWiki:Plotters-definition]].
Esta vista xeral proporciona un acceso doado ás páxinas de mensaxes do sistema que definen a descrición e o código de cada plotter.',
	'plotters-uses' => 'Usos',
	'plotters-missing-script' => 'Non foi definida ningunha escritura.',
	'plotters-missing-arguments' => 'Non foi especificado ningún argumento.',
	'plotters-excessively-long-scriptname' => 'O nome da escritura é moi longo. Por favor, defina unha escritura que sexa inferior a 255 caracteres.',
	'plotters-excessively-long-preprocessorname' => 'O nome do preprocesador é moi longo. Por favor, defina un preprocesador que sexa inferior a 255 caracteres.',
	'plotters-excessively-long-name' => 'O nome do plot é moi longo. Por favor, defina un nome que sexa inferior a 255 caracteres.',
	'plotters-excessively-long-tableclass' => 'A clase de táboa é moi longa. Por favor, defina unha clase de táboa que sexa inferior a 255 caracteres.',
	'plotters-no-data' => 'Non se proporcionou ningún dato.',
	'plotters-invalid-renderer' => 'Seleccionouse un renderizador inválido.',
	'plotters-errors' => '{{PLURAL:$1|Erro|Erros}} de plotters:',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'plotters-desc' => 'Macht s Benutzer megli, e aapasst Javaskripkt in ihre jsplot-Markierige z bruche',
	'plotters' => 'Plotter',
	'plotters-title' => 'Plotter',
	'plotters-pagetext' => 'Unte sin spezielli Plotter usglischtet, wu Benutzer chenne verwände in ihre jsplot-Markierige, wie s dur [[MediaWiki:Plotters-definition]] definiert isch.
Die Ibersicht isch e eifach Zuegang zue dr Syschtemnochrichte, wu d Bschrybig un dr Code vu jedem Plotter definiere.',
	'plotters-uses' => 'Brucht',
	'plotters-missing-script' => 'Kei Skript isch definiert wore.',
	'plotters-missing-arguments' => 'Kei Argumänt definiert.',
	'plotters-excessively-long-scriptname' => 'Dr Skriptname isch z lang. Bitte definier e Skript, wu weniger wie 255 Zeiche het.',
	'plotters-excessively-long-preprocessorname' => 'Dr Name vum Vorprozessor isch z lang. Bitte definier e Vorprozessorname mit weniger wie 255 Zeiche.',
	'plotters-excessively-long-name' => 'Dr Plotname isch z lang. Bitte definer e Plotname mit weniger wie 255 Zeiche.',
	'plotters-excessively-long-tableclass' => 'D Tabälleklasse isch z lang. Bitte definier e Tabälleklasse mit weniger wie 255 Zeiche.',
	'plotters-no-data' => 'Kei Date botte.',
	'plotters-invalid-renderer' => 'E nit giltige Renderer isch uusgwehlt wore.',
	'plotters-errors' => '{{PLURAL:$1|Plotterfähler|Plotterfähler}}:',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'plotters-desc' => 'מתן אפשרות לשימוש ב־JavaScript מותאם אישית בתגי jsplot',
	'plotters' => 'תוויינים',
	'plotters-title' => 'תוויינים',
	'plotters-pagetext' => 'להלן רשימת תוויינים מיוחדים שהמשתמשים יכולים להשתמש בהם בתגי jsplot שלהם, כפי שמוגר ב־[[MediaWiki:Plotters-definition]].
הסקירה הכללית הזאת נותנת גישה קלה לדפי הודעות מערכת שמגדירים את התיאור ואת הקוד של כל תוויין.',
	'plotters-uses' => 'שימושים',
	'plotters-missing-script' => 'לא הוגדר סקריפט.',
	'plotters-missing-arguments' => 'לא צוינו ארגומנטים.',
	'plotters-excessively-long-scriptname' => 'שם הסקריפט ארוך מדי.
אנא הגדירו שם לסקריפט באורך 255 תווים לכל היותר.',
	'plotters-excessively-long-preprocessorname' => 'שם מעבד הקדם ארוך מדי.
נא להגדיר מעבד קדם שאורך שמו – 255 תווים לכל היותר.',
	'plotters-excessively-long-name' => 'שם התרשים ארוך מדי.
נא להגדיר שם תרשים באורך של 255 לכל היותר.',
	'plotters-excessively-long-tableclass' => 'שם מחלקת טבלאות ארוך מדי.
נא להגדיר שם מחלקת טבלאות באורך של 255 תווים לכל היותר.',
	'plotters-no-data' => 'לא סופקו נתונים.',
	'plotters-invalid-renderer' => 'נבחר מעבד תמונה לא תקין.',
	'plotters-errors' => '{{PLURAL:$1|שגיאת|שגיאות}} תוויינים:',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'plotters-desc' => 'Zmóžnja wužiwarjam swójske javaskripty w jich tafličkach jsplot wužiwać',
	'plotters' => 'Plotery',
	'plotters-title' => 'Plotery',
	'plotters-pagetext' => 'Deleka je lisćina specielnych ploterow, kotrež wužiwarjo móžeja w swojich tafličkach jsplot wužiwać, kaž su přez [[MediaWiki:Plotters-definition]] definowane.
Tutón přehlad dodawa lochki přistup na strony systemowych zdźělenkow, kotrež wopisanje a kod kóždeho plotera definuja.',
	'plotters-uses' => 'Wužiwa',
	'plotters-missing-script' => 'Žadyn skript njeje so definował.',
	'plotters-missing-arguments' => 'Žane argumenty podate.',
	'plotters-excessively-long-scriptname' => 'Mjeno skripta je předołhe. Prošu definuj skript, kotryž ma mjenje hač 255 znamješkow.',
	'plotters-excessively-long-preprocessorname' => 'Mjeno preprocesora je předołhe. Prošu definuj preprocesor, kotryž ma mjenje hač 255 znamješkow.',
	'plotters-excessively-long-name' => 'Mjeno plota je předołhe. Prošu definuj plotowe mjeno, kotrež ma mjenje hač 255 znamješkow.',
	'plotters-excessively-long-tableclass' => 'Tabelowa klasa je předołha. Prošu definuj tabelowu klasu, kotraž ma mjenje hač 255 znamješkow.',
	'plotters-no-data' => 'Žane daty njejsu so podali.',
	'plotters-invalid-renderer' => 'Njepłaćiwy rysowak je so wubrał.',
	'plotters-errors' => '{{PLURAL:$1|Ploterowy zmylk|Ploterowej zmylkaj|Ploterowe zmylki|Ploterowe zmylki}}:',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'plotters-desc' => 'Megengedi egyéni JavaScript használatát a jsplot tagekben',
	'plotters' => 'Diagramrajzolók',
	'plotters-title' => 'Diagramrajzolók',
	'plotters-pagetext' => 'Alább azok a speciális diagramrajzolók láthatóak, amelyeket a felhasználók használhatnak a jsplot tag-jeikben, ahogy a [[MediaWiki:Plotters-definition]] definiálja.
Ez az áttekintés könnyű hozzáférhetőséget biztosít a rendszerüzenet lapokhoz, amelyek megadják az egyes rajzolók leírását és kódját.',
	'plotters-uses' => 'Használatai',
	'plotters-missing-script' => 'Nem volt szkript megadva.',
	'plotters-missing-arguments' => 'Nincsenek argumentumok megadva.',
	'plotters-excessively-long-scriptname' => 'A szkript neve túl hosszú.
Adj meg egy szkriptet, amelynek a neve maximum 255 karakter hosszú lehet.',
	'plotters-excessively-long-preprocessorname' => 'Az előfeldolgozó neve túl hosszú.
Adj meg egy előfeldolgozót, amelynek a neve maximum 255 karakter hosszú lehet.',
	'plotters-excessively-long-name' => 'A diagram neve túl hosszú.
Kérlek legfeljebb 255 karakter hosszú diagramnevet adj meg.',
	'plotters-excessively-long-tableclass' => 'A táblázatosztály neve túl hosszú.
Kérlek legfeljebb 255 karakter hosszú táblázatosztályt adj meg.',
	'plotters-no-data' => 'Nem volt adat megadva.',
	'plotters-invalid-renderer' => 'Érvénytelen megjelenítőmotor lett kiválasztva.',
	'plotters-errors' => 'Diagramrajzoló {{PLURAL:$1|hiba|hibák}}:',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'plotters-desc' => 'Permitte a usatores inserer JavaScript personalisate per medio de etiquettas "jsplot"',
	'plotters' => 'Plotters',
	'plotters-title' => 'Plotters',
	'plotters-pagetext' => 'In basso es un lista de plotters special que le usatores pote usar in lor etiquettas jsplot, como definite per [[MediaWiki:Plotters-definition]].
Iste summario permitte acceder facilemente al messages de systema que defini le description e codice de cata plotter.',
	'plotters-uses' => 'Usa',
	'plotters-missing-script' => 'Nulle script esseva definite.',
	'plotters-missing-arguments' => 'Nulle parametro specificate.',
	'plotters-excessively-long-scriptname' => 'Le nomine del script es troppo longe. Per favor defini un script que ha minus de 255 characteres.',
	'plotters-excessively-long-preprocessorname' => 'Le nomine del preprocessator es troppo longe. Per favor defini un preprocessator que ha minus de 255 characteres.',
	'plotters-excessively-long-name' => 'Le nomine del plot es troppo longe.
Per favor defini un nomine de plot que ha 255 characteres al maximo.',
	'plotters-excessively-long-tableclass' => 'Le classe de tabula es troppo longe.
Per favor defini un classe de tabula que ha 255 characteres al maximo.',
	'plotters-no-data' => ' Nulle dato esseva providite.',
	'plotters-invalid-renderer' => 'Un renditor invalide esseva seligite.',
	'plotters-errors' => '{{PLURAL:$1|Error|Errores}} de plotter:',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Irwangatot
 */
$messages['id'] = array(
	'plotters-desc' => 'Memungkinkan pengguna menggunakan JavaScript di tag jsplot',
	'plotters' => 'Plotter',
	'plotters-title' => 'Plotter',
	'plotters-pagetext' => 'Di bawah ini adalah daftar anggota kelompok khusus pengguna dapat menggunakan tag jsplot mereka, sebagaimana didefinisikan oleh [[MediaWiki:Plotters-definition]]. 
Ikhtisar ini memberikan akses yang mudah ke halaman pesan sistem yang mendefinisikan deskripsi masing-masing anggota kelompok dan kode.',
	'plotters-uses' => 'Menggunakan',
	'plotters-missing-script' => 'Skrip tidak dicantumkan.',
	'plotters-missing-arguments' => 'Argumen tidak dicantumkan.',
	'plotters-excessively-long-scriptname' => 'Nama skrip terlalu panjang.
Cantumkan nama skrip yang panjangnya maksimal 255 karakter.',
	'plotters-excessively-long-preprocessorname' => 'Nama pre-pemroses terlalu panjang.
Cantumkan nama pre-pemroses yang panjangnya maksimal 255 karakter.',
	'plotters-excessively-long-name' => 'Nama plot terlalu panjang.
Cantumkan nama plot yang panjangnya maksimal 255 karakter.',
	'plotters-excessively-long-tableclass' => 'Nama kelas tabel terlalu panjang.
Cantumkan sebuah kelas tabel yang panjangnya maksimal 255 karakter.',
	'plotters-no-data' => 'Data tidak disediakan.',
	'plotters-invalid-renderer' => 'Penampil yang tidak sah dipilih.',
	'plotters-errors' => '{{PLURAL:$1||}}Kesalahan Plotter:',
);

/** Italian (Italiano) */
$messages['it'] = array(
	'plotters-uses' => 'Usi',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 */
$messages['ja'] = array(
	'plotters-desc' => '利用者が jsplot タグ内で独自の JavaScript を使えるようにする',
	'plotters' => 'プロッター',
	'plotters-title' => 'プロッター',
	'plotters-pagetext' => '以下は利用者が jsplot タグ内で使用できる、[[MediaWiki:Plotters-definition]]で定義された特別なプロッターの一覧です。この一覧から各プロッターの説明およびコードを定義している各システムメッセージのページにアクセスできます。',
	'plotters-uses' => '使用',
	'plotters-missing-script' => '定義済みのスクリプトはありません。',
	'plotters-missing-arguments' => '引数が指定されていません。',
	'plotters-excessively-long-scriptname' => 'スクリプトの名前が長すぎます。スクリプト名は255文字以内に収めてください。',
	'plotters-excessively-long-preprocessorname' => 'プリプロセッサの名前が長すぎます。プリプロセッサ名は255文字以内に収めてください。',
	'plotters-excessively-long-name' => 'プロットの名前が長すぎます。プロット名は255文字以内に収めてください。',
	'plotters-excessively-long-tableclass' => 'テーブルのクラスが長すぎます。クラスは255文字以内に収めてください。',
	'plotters-no-data' => 'データが与えられていません。',
	'plotters-invalid-renderer' => '無効なレンダラーが選択されました。',
	'plotters-errors' => 'プロッターの{{PLURAL:$1|エラー}}:',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'plotters-desc' => 'Jitt de Metmaacher selfs zerääsch jemaate JavaSkrepte för se en <code lang="en">jsplot</code>-Befähle ze bruche.',
	'plotters' => 'Plottere',
	'plotters-title' => 'Plotter',
	'plotters-pagetext' => 'Hee dronger es en Leß met beshtemmpte Plotter, di mer em Wiki en <code lang="en">jsplot</code>-Befähle bruche kann. Se sin en dä Sigg <code lang="en">[[MediaWiki:Plotters-definition]]</code> faßjelaat woode. Hee di Övverseesch jitt Der eine eijfache Zohjang op di Sigge, woh dä Plottere ier Eijeschaffte un dänne ier Koodes faßjehallde sin.',
	'plotters-uses' => 'Bruch',
	'plotters-missing-script' => 'Kei Skrep faßjelaat.',
	'plotters-missing-arguments' => 'Kei Parrameetere aanjejovve.',
	'plotters-excessively-long-scriptname' => 'Dä Name för dat Skrep es ze lang, jivv en Skrep aan, woh dä Name kööter wi 255 Zeijsche eß.',
	'plotters-excessively-long-preprocessorname' => 'Dä Name för dat Förloufprojramm es ze lang, jivv e Förloufprojramm aan, woh dä Name kööter wi 255 Zeijsche eß.',
	'plotters-excessively-long-name' => 'Dä Name för di Datteijh met dä Daate för ze plotte es ze lang, jivv ene Name aan, dä kööter wi 255 Zeijsche eß.',
	'plotters-excessively-long-tableclass' => 'Dä Name för di <i lang="en">CSS</i>-KLaß fö de Tabälle es ze lang, jivv ene Name aan, dä kööter wi 255 Zeijsche eß.',
	'plotters-no-data' => 'Kei Date aanjejovve.',
	'plotters-invalid-renderer' => 'En onjöltsch Aanzeijeprojramm wood ußjesohk.',
	'plotters-errors' => '{{PLURAL:$1|Eine|$1|Keine}} Fähler en de <i lang="en">Plotters</i>:',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'plotters' => 'Plotteren',
	'plotters-title' => 'Plotteren',
	'plotters-uses' => 'Benotzt',
	'plotters-missing-script' => 'Et gouf kee Script definéiert.',
	'plotters-excessively-long-scriptname' => 'Den Numm vum Script ass ze laang.
Leet w.e.g. e Script fest, den Numm vun deem däerf net méi laang si wéi 255 Zeechen.',
	'plotters-no-data' => 'Et goufe keng Donnéeën uginn.',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'plotters-desc' => 'Им овозможува на корисниците да користат свој прилагоден JavaScript во jsplot ознаки',
	'plotters' => 'Плотери',
	'plotters-title' => 'Плотери',
	'plotters-pagetext' => 'Подолу е наведен список на специјални плотери кои корисниците можат да ги користат во нивните jsplot ознаки, според определеното во [[MediaWiki:Plotters-definition]].
Овој преглед овозможува лесен пристап кон страниците со системски пораки кои го определуваат описот и кодот на секоја порака.',
	'plotters-uses' => 'Употреби',
	'plotters-missing-script' => 'Нема определено скрипта.',
	'plotters-missing-arguments' => 'Нема определено аргументи.',
	'plotters-excessively-long-scriptname' => 'Името на скриптата е предолго.
Определете скрипта, чие име не е подолго од 255 знаци.',
	'plotters-excessively-long-preprocessorname' => 'Името на претпроцесорот е предолго.
Определете име на претпороцесорот не подолго од 255 знаци.',
	'plotters-excessively-long-name' => 'Името на плотерот е предолго.
Определете име на плотерот не подолго од 255 знаци.',
	'plotters-excessively-long-tableclass' => 'Класата на таблицата е предолга.
Определете ја класата на таблицата со не повеќе од 255 знаци.',
	'plotters-no-data' => 'Нема наведено податоци.',
	'plotters-invalid-renderer' => 'Избран е неважечки прецртувач.',
	'plotters-errors' => '{{PLURAL:$1|Грешка кај плотерите|Грешки кај плотерите}}:',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 * @author Simny
 */
$messages['nb'] = array(
	'plotters-desc' => 'Lar brukere bruke egendefinerte JavaScript i jsplot-merkelapper',
	'plotters' => 'Plottere',
	'plotters-title' => 'Plottere',
	'plotters-pagetext' => 'Under er en liste over spesielle plottere brukere kan bruke i sine jsplot-merkelapper, som definert av [[MediaWiki:Plotters-definition]].
Denne oversikten gir enkel tilgang til systemmeldingssider som definerer hver plotters beskrivelse og kode.',
	'plotters-uses' => 'Bruker',
	'plotters-missing-script' => 'Ingen skript ble definert.',
	'plotters-missing-arguments' => 'Ingen argument spesifisert.',
	'plotters-excessively-long-scriptname' => 'Skriptnavnet er for langt.
Vennligst definer et skript med et navn som er maksimalt 255 tegn langt.',
	'plotters-excessively-long-preprocessorname' => 'Forprossesornavnet er for langt.
Definer en forpressesor med et navn som er maks 255 tegn langt.',
	'plotters-excessively-long-name' => 'Plottnavnet er for langt.
Vennligst definer et plottnavn som er maksimalt 255 tegn langt.',
	'plotters-excessively-long-tableclass' => 'Tabellklassen er for lang.
Vennligst definer en tabellklasse som er maksimalt 255 tegn langt.',
	'plotters-no-data' => 'Ingen data var tilgjengelig.',
	'plotters-invalid-renderer' => 'En ugyldig gjengiver ble valgt.',
	'plotters-errors' => '{{PLURAL:$1|Plotterfeil|Plotterfeil}}:',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'plotters-desc' => 'Laat gebruikers aangepaste JavaScript gebruiken in jsplot-tags',
	'plotters' => 'Plotters',
	'plotters-title' => 'Plotters',
	'plotters-pagetext' => "Hieronder worden de speciale plotters weergegeven die gebruikt kunnen worden in jsplot-tags, zoals is ingesteld in [[MediaWiki:Plotters-definition]].
Dit overzicht geeft eenvoudig toegang tot de pagina's met systeemteksten waarin iedere plotter wordt beschreven en de code van de plotter.",
	'plotters-uses' => 'Gebruikt',
	'plotters-missing-script' => 'Er is geen script gedefinieerd.',
	'plotters-missing-arguments' => 'Er zijn geen argumenten opgegeven.',
	'plotters-excessively-long-scriptname' => 'De scriptnaam is te lang.
Geef een scriptnaam op die korter is dan 255 karakters.',
	'plotters-excessively-long-preprocessorname' => 'De preprocessornaam is te lang.
Geef een preprocessornaam op die korter is dan 255 karakters.',
	'plotters-excessively-long-name' => 'De plotternaam is te lang.
Geeft aan plotternaam op die korter is dan 255 karakters.',
	'plotters-excessively-long-tableclass' => 'De tabelklassenaam is te lang.
Geef een tabelklassenaam op die korter is dan 255 karakters.',
	'plotters-no-data' => 'Er zijn geen gegevens ingevoerd.',
	'plotters-invalid-renderer' => 'Er is een ongeldige renderer geselecteerd.',
	'plotters-errors' => 'Er {{PLURAL:$1|is een plotterfout|zijn plotterfouten}} aangetroffen:',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Gunnernett
 * @author Harald Khan
 */
$messages['nn'] = array(
	'plotters-desc' => 'Lèt brukarar nytta eigendefinerte JavaScript i jsplot-merke.',
	'plotters-missing-script' => 'Inkje skript var definert.',
	'plotters-missing-arguments' => 'Ingen argument spesifiserte.',
	'plotters-no-data' => 'Ingen data var tilrettelagt.',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'plotters-desc' => "Permet als utilizaires d'utilizar de javascript personalizat dins las balisas jsplot",
	'plotters' => 'Traçaires',
	'plotters-title' => 'Traçaires',
	'plotters-pagetext' => "Çaijós la lista dels traçaires especials que los utilizaires pòdon utilizar dins lors balisas jsplot, coma definidas sua [[MediaWiki:Plotters-definition]].
Aquesta vista d'ensemble permet d'accedir aididament als messatges del sistèma que definisson lo còde e la descripcion de cada traçaire.",
	'plotters-uses' => 'Utiliza',
	'plotters-missing-script' => "Cap d'escripte es pas estat definit.",
	'plotters-missing-arguments' => "Cap d'argument es pas estat especificat.",
	'plotters-excessively-long-scriptname' => "Lo nom de l'escript es tròp long.
Definissètz un escript qu'a mens de 255 caractèrs.",
	'plotters-excessively-long-preprocessorname' => 'Lo nom del preprocessor es tròp long.
Definissètz un preprocessor que fa mens de 255 caractèrs.',
	'plotters-excessively-long-name' => 'Lo nom del graf es tròp long.
Definissètz un nom de graf que fa mens de 255 caractèrs.',
	'plotters-excessively-long-tableclass' => 'La classa del tablèu es tròp longa.
Definissètz una classa de tablèu que fa mens de 255 caractèrs.',
	'plotters-no-data' => 'Cap de donada es pas estada provesida.',
	'plotters-invalid-renderer' => 'Un motor de rendut invalid es estat seleccionat.',
	'plotters-errors' => '{{PLURAL:$1|Error|Errors}} de traçadors :',
);

/** Polish (Polski)
 * @author Sp5uhe
 * @author ToSter
 */
$messages['pl'] = array(
	'plotters-desc' => 'Pozwala użytkownikom korzystać z własnego kodu JavaScript w znacznikach jsplot',
	'plotters' => 'Plotery',
	'plotters-title' => 'Plotery',
	'plotters-pagetext' => 'Poniżej znajduje się lista specjalnych ploterów z których mogą korzystać użytkownicy w swoich znacznikach jsplot, zgodnie z definicją [[MediaWiki:Plotters-definition]].
Przegląd ten umożliwia łatwy dostęp do stron komunikatów systemowych, które definiują każdy ploter i kod.',
	'plotters-uses' => 'Liczba użyć',
	'plotters-missing-script' => 'Nie zdefiniowano skryptu.',
	'plotters-missing-arguments' => 'Nie określono argumentów.',
	'plotters-excessively-long-scriptname' => 'Nazwa skryptu jest zbyt długa.
Należy zdefiniować skrypt, którego nazwa ma nie więcej niż 255 znaków.',
	'plotters-excessively-long-preprocessorname' => 'Nazwa preprocesora jest zbyt długa.
Należy zdefiniować preprocesor, którego nazwa ma nie więcej niż 255 znaków.',
	'plotters-excessively-long-name' => 'Nazwa plotowania jest zbyt długa.
Należy zdefiniować nazwę plotowania, która ma co najwyżej 255 znaków.',
	'plotters-excessively-long-tableclass' => 'Nazwa tabeli klas jest zbyt długa.
Należy zdefiniować nazwę tabeli klas, która ma co najwyżej 255 znaków.',
	'plotters-no-data' => 'Nie dostarczono danych.',
	'plotters-invalid-renderer' => 'Wybrano nieprawidłowe renderowanie.',
	'plotters-errors' => '{{PLURAL:$1|Błąd|Błędy}} ploterów:',
);

/** Piedmontese (Piemontèis)
 * @author Dragonòt
 */
$messages['pms'] = array(
	'plotters-desc' => "Fà che j'utent a dòvro JavaScript përsonaj ant ij tag jsplot",
	'plotters' => 'Plotter',
	'plotters-title' => 'Plotter',
	'plotters-pagetext' => "Sota a-i é na lista ëd plotter speciaj che j'utent a peulo dovré ant ij sò tag jsplot, com definì da [[MediaWiki:Plotters-definition]].
Sta antrodussion-sì a dà un assess bel fé a le pàgine dij messagi ëd sistema che a definisso la descrission e ël còdes ëd minca plotter.",
	'plotters-uses' => 'Dovragi',
	'plotters-missing-script' => 'Pa gnun script definì.',
	'plotters-missing-arguments' => 'Pa gnun argoment spessifià.',
	'plotters-excessively-long-scriptname' => "Ël nòm ëd lë script a l'é tròp longh.
Për piasì definiss në script, ël sò nòm a deuv esse 255 caràter al pì.",
	'plotters-excessively-long-preprocessorname' => "Ël nòm dël preprossessor a l'é tròp longh.
Për piasì definiss un preprossessor, ël sò nòm a deuv esse al pì 255 caràter.",
	'plotters-excessively-long-name' => "Ël nòm dël plot a l'é tròp longh.
Për piasì definiss un nòm dël plot che a sia al pì 255 caràter.",
	'plotters-excessively-long-tableclass' => "la tableclass a l'é tròp longa.
Për piasì definiss na tableclass che a sia 255 caràter al pì.",
	'plotters-no-data' => 'Pa gnun dat dàit.',
	'plotters-invalid-renderer' => "A l'é stàit selessionà un renderer pa bon.",
	'plotters-errors' => '{{PLURAL:$1|Eror|Eror}} dij plotter:',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'plotters-uses' => 'کاروي',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Lijealso
 */
$messages['pt'] = array(
	'plotters-desc' => "Permite o uso de código JavaScript personalizado nas ''tags'' jsplot",
	'plotters' => 'Plotters',
	'plotters-title' => 'Plotters',
	'plotters-pagetext' => "Abaixo encontra uma lista de ''plotters'' especiais que podem ser usadas pelos utilizadores nas ''tags'' jsplot, como definido em [[MediaWiki:Plotters-definition]].
Este resumo permite acesso fácil às páginas das mensagens de sistema que definem o código e a descrição de cada ''plotter''.",
	'plotters-uses' => 'Usos',
	'plotters-missing-script' => "Não foi definido nenhum''script''.",
	'plotters-missing-arguments' => 'Não foram fornecidos argumentos.',
	'plotters-excessively-long-scriptname' => "O nome do ''script'' é demasiado longo.
Por favor, defina um ''script'' cujo nome tenha no máximo 255 caracteres.",
	'plotters-excessively-long-preprocessorname' => 'O nome do preprocessador é demasiado longo.
Por favor, defina um preprocessador cujo nome tenha no máximo 255 caracteres.',
	'plotters-excessively-long-name' => "O nome do ''plot'' é demasiado longo.
Por favor, defina um ''plot'' cujo nome tenha no máximo 255 caracteres.",
	'plotters-excessively-long-tableclass' => "A ''tableclass'' é demasiado longa.
Por favor, defina uma ''tableclass'' cujo nome tenha no máximo 255 caracteres.",
	'plotters-no-data' => 'Não foram fornecidos dados.',
	'plotters-invalid-renderer' => 'Foi seleccionado um renderizador inválido.',
	'plotters-errors' => "{{PLURAL:$1|Erro|Erros}} das ''plotters'':",
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'plotters-desc' => 'Permite aos utilizadores que usem código JavaScript personalizado em marcas jsplot',
	'plotters' => 'Plotters',
	'plotters-title' => 'Plotters',
	'plotters-pagetext' => 'Abaixo está uma lista de "plotters" especiais que os utilizadores podem usar em suas marcas jsplot, como definido por [[MediaWiki:Plotters-definition]].
Este resumo provê acesso fácil as páginas de mensagens de sistema que definem código e descrição de cada "plotter".',
	'plotters-uses' => 'Usos',
	'plotters-missing-script' => 'Nenhum script foi definido.',
	'plotters-missing-arguments' => 'Nenhum argumento especificado.',
	'plotters-excessively-long-scriptname' => 'O nome do script é muito longo.
Por favor defina um script cujo nome tenha no máximo 255 caracteres.',
	'plotters-excessively-long-preprocessorname' => 'O nome do preprocessador é muito longo.
Por favor defina um preprocessador cujo nome tenha no máximo 255 caracteres.',
	'plotters-excessively-long-name' => 'O nome do plot é muito longo.
Por favor defina um plot cujo nome tenha no máximo 255 caracteres.',
	'plotters-excessively-long-tableclass' => 'A tableclass é muito longa.
Por favor defina uma tableclass cujo nome tenha no máximo 255 caracteres.',
	'plotters-no-data' => 'Não foram fornecidos dados.',
	'plotters-invalid-renderer' => 'Um renderizador inválido foi selecionado.',
	'plotters-errors' => '{{PLURAL:$1|Erro|Erros}} nos plotters:',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'plotters-uses' => 'Utilizări',
	'plotters-missing-script' => 'Nici un script nu a fost definit.',
	'plotters-missing-arguments' => 'Nici un argument specificat.',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Lockal
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'plotters-desc' => 'Позволяет участникам использовать свой JavaScript в тегах jsplot',
	'plotters' => 'Плоттеры',
	'plotters-title' => 'Плоттеры',
	'plotters-pagetext' => 'Ниже приведён список служебных плоттеров, которые могут использовать участники в тегах jsplot, как определено в [[MediaWiki:Plotters-definition]].
Это позволяет получить простой доступ к страницам системных сообщений, которые определяют описание и код каждого плоттера.',
	'plotters-uses' => 'Использования',
	'plotters-missing-script' => 'Не определено ни одного скрипта.',
	'plotters-missing-arguments' => 'Аргументы не указаны.',
	'plotters-excessively-long-scriptname' => 'Имя скрипта слишком длинное.
Пожалуйста, укажите скрипт, чьё имя не превышает 255 символов.',
	'plotters-excessively-long-preprocessorname' => 'Имя препроцессора слишком длинное.
Пожалуйста, укажите препроцессор, чьё имя не превышает 255 символов.',
	'plotters-excessively-long-name' => 'Название плоттера слишком длинное.
Пожалуйста, определите название плоттера не больше 255 символов.',
	'plotters-excessively-long-tableclass' => 'Класс таблицы слишком длинный.
Пожалуйста, определите класс таблицы, содержащий не больше 255 символов.',
	'plotters-no-data' => 'Данные не указаны.',
	'plotters-invalid-renderer' => 'Выбран неверный рендерер.',
	'plotters-errors' => '{{PLURAL:$1|Ошибка плоттеров|Ошибки плоттеров}}:',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'plotters-desc' => 'Umožňuje používateľom používať vlastný JavaScript v jsplot',
	'plotters' => 'Plotre',
	'plotters-title' => 'Plotre',
	'plotters-pagetext' => 'Toto je zoznam špeciálnych plotrov, ktoré používatelia môžu použiť vo svojich značkách jsplot podľa definície na stránke [[MediaWiki:Plotters-definition]].
Tento prehľad poskytuje jednoduchý prístup k stránkam systémových správ, ktoré definujú popis a kód každého plotra.',
	'plotters-uses' => 'Použitia',
	'plotters-missing-script' => 'Nebol definovaný žiadny skript.',
	'plotters-missing-arguments' => 'Neboli zadané argumenty.',
	'plotters-excessively-long-scriptname' => 'Názov skriptu bol príliš dlhý. Prosím definujte skript, ktorého názov má menej ako 255 znakov.',
	'plotters-excessively-long-preprocessorname' => 'Názov preprocesora je príliš dlhý. Definujte prosím preprocesor, ktorého názov je kratší ako 255 znakov.',
	'plotters-excessively-long-name' => 'Názov diagramu je príliš dlhý. Definujte prosím preprocesor, ktorého názov je kratší ako 255 znakov.',
	'plotters-excessively-long-tableclass' => 'Názov triedy tabuľky je príliš dlhý. Definujte prosím preprocesor, ktorého názov je kratší ako 255 znakov.',
	'plotters-no-data' => 'Neboli poskytnuté žiadne údaje.',
	'plotters-invalid-renderer' => 'Bol vybraný neplatný vykresľovač.',
	'plotters-errors' => '<b>{{PLURAL:$1|Chyba|Chyby}} plotrov:</b>',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'plotters' => 'Плотери',
	'plotters-title' => 'Плотери',
	'plotters-uses' => 'Употребе',
	'plotters-no-data' => 'Нема наведених података.',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Rancher
 */
$messages['sr-el'] = array(
	'plotters' => 'Ploteri',
	'plotters-title' => 'Ploteri',
	'plotters-uses' => 'Upotrebe',
	'plotters-no-data' => 'Nema navedenih podataka.',
);

/** Swedish (Svenska)
 * @author Per
 */
$messages['sv'] = array(
	'plotters-uses' => 'Använder',
	'plotters-missing-script' => 'Inget skript blev definierat',
	'plotters-no-data' => 'Ingen data var tillgänglig.',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'plotters-uses' => 'వాడుకలు',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'plotters-desc' => 'Nagpapahintulot sa mga tagagamit na gumamit ng mga pasadyang JavaScript sa loob ng mga tatak na jsplot',
	'plotters' => 'Mga pampitak',
	'plotters-title' => 'Mga pampitak',
	'plotters-pagetext' => 'Nasa ibaba ang isang talaan ng natatanging mga pamitak na magagamit ng mga tagagamit sa kanilang mga tatak na jsplot, bilang binigyang kahulugan ng [[MediaWiki:Plotters-definition]].
Nagbibigay ang pang-ibabaw na tanawing ito ng maginhawang pagpunta sa mga pahina ng mensahe ng sistema na nagbibigay ng kahulugan sa bawat paglalarawan at kodigo ng pamitak.',
	'plotters-uses' => 'Mga mapaggagamitan',
	'plotters-missing-script' => 'Walang panitik na binigyan ng kahulugan.',
	'plotters-missing-arguments' => 'Walang tinukoy na pangangatwiran.',
	'plotters-excessively-long-scriptname' => 'Napakahaba ng pangalan ng panitikan na ito.
Paki bigyang kahulugan ang isang panitik, ang pangalan nito ay may habang 255 mga pantitik ang pinakamarami.',
	'plotters-excessively-long-preprocessorname' => 'Napakahaba ng pangalan ng paunang-tagagawa.
Pakibigyang kahulugan ang isang paunang-tagagawa, ang pangalan ay may habang 255 mga panitik ang pinakamarami.',
	'plotters-excessively-long-name' => 'Napakahaba ng pangalan ng pitak.
Pakibigyang kahulugan ang isang pangalan ng pitak na may habang 255 mga panitik ang pinakamarami.',
	'plotters-excessively-long-tableclass' => 'Napakahaba ng klase ng tabla.
Pakibigyang kahulugan ang isang klase ng tablang may habang 255 mga panitik ang pinakamarami.',
	'plotters-no-data' => 'Walang ibinigay na dato.',
	'plotters-invalid-renderer' => 'Napili ang isang hindi tanggap na tagagawa.',
	'plotters-errors' => '{{PLURAL:$1|Kamalian|Mga kamalian}} ng mga pampitak:',
);

/** Turkish (Türkçe)
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'plotters-uses' => 'Kullanımları',
	'plotters-no-data' => 'Veri girilmedi.',
);

/** Ukrainian (Українська)
 * @author Alex Khimich
 * @author Тест
 */
$messages['uk'] = array(
	'plotters-desc' => 'Дозволяє користувачам використовувати користувальницький JavaScript за допомогою тегів jsplot',
	'plotters' => 'Плоттери',
	'plotters-title' => 'Плоттери',
	'plotters-pagetext' => 'Нижче наводиться перелік спеціальних плоттерів які користувачі можуть використовувати свої jsplot теги, як описано в [[MediaWiki:Plotters-definition]] 
Цей розділ забезпечує легкий доступ до сторінок системних повідомлень, які визначають опис кожного плоттера і код.',
	'plotters-uses' => 'Використання',
	'plotters-missing-script' => 'Не вказано жодного скрипта.',
	'plotters-missing-arguments' => 'Не вказано жодного аргумента.',
	'plotters-excessively-long-scriptname' => 'Назва скрипта занадто довга.
Будь-ласка, вкажіть скрипт,з максимальною довжиною імені в 255 символів.',
	'plotters-excessively-long-preprocessorname' => "Занадто довге ім'я препроцесора. 
Будь ласка, вкажіть ім'я довжиною не більше ніж 255 символів.",
	'plotters-excessively-long-name' => "Ім'я плотера занадто довге ім'я. 
Будь ласка, вкажіть ім'я, яке має не більше 255 символів.",
	'plotters-excessively-long-tableclass' => "Клас таблиці містить занадто довге ім'я. 
Будь ласка, вкажіть ім'я, яке має не більше 255 символів.",
	'plotters-no-data' => 'Данні не вказані.',
	'plotters-invalid-renderer' => 'Обрано невірний рендерер.',
	'plotters-errors' => '{{PLURAL:$1|Помилка|Помилки}} плоттерів:',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'plotters-uses' => 'Kävutamižed',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'plotters-desc' => 'Cho phép người dùng sử dụng JavaScript tùy biến trong thẻ jsplot',
	'plotters' => 'Bộ vẽ',
	'plotters-title' => 'Bộ vẽ',
	'plotters-pagetext' => 'Đây là danh sách các bộ vẽ biểu đồ để cho những người dùng sử dụng trong các thẻ jsplot, theo định nghĩa tại [[MediaWiki:Plotters-definition]].
Từ trang này, bạn có thể truy cập những trang thông báo hệ thống miêu tả và định rõ mã nguồn của các bộ vẽ.',
	'plotters-uses' => 'Lần sử dụng',
);

