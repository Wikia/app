<?php
/**
 * Internationalisation file for the extension DataTransclusion
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Kinzler for Wikimedia Deutschland
 * @copyright © 2010 Wikimedia Deutschland (Author: Daniel Kinzler)
 * @licence GNU General Public Licence 2.0 or later
 */

$messages = array();

/** English
 */
$messages['en'] = array(
	'datatransclusion-desc'         => 'Import and rendering of data records from external data sources',

	'datatransclusion-test-wikitext' => 'some <span class="test">html</span> and \'\'markup\'\'.', // Do not translate.
	'datatransclusion-test-evil-html' => 'some <object>evil</object> html.', // Do not translate.
	'datatransclusion-test-nowiki' => 'some <nowiki>{{nowiki}}</nowiki> code.', // Do not translate.

	'datatransclusion-missing-source'            => 'No data source specified.
Second or "source" argument is required.', #FUZZ!
	'datatransclusion-unknown-source'            => 'Bad data source specified.
"$1" is not known.',
	'datatransclusion-missing-key'           => 'No key specified.
$2 are valid keys in data source $1.',
	'datatransclusion-bad-argument-by'           => 'Bad key field specified.
"$2" is not a key field in data source "$1".
{{PLURAL:$4|Valid key|Valid keys are}}: $3.',
	'datatransclusion-missing-argument-key'      => 'No key value specified.
Second or "key" argument is required.',
	'datatransclusion-missing-argument-template' => 'No template specified.
First or "template" argument is required.', #FUZZ!
	'datatransclusion-record-not-found'          => 'No record matching $2 = $3 was found in data source $1.',
	'datatransclusion-bad-template-name'         => 'Bad template name: $1.',
	'datatransclusion-unknown-template'          => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki> does not exist.',
);

/** Message documentation (Message documentation)
 * @author McDutchie
 * @author Siebrand
 */
$messages['qqq'] = array(
	'datatransclusion-desc' => '{{desc}}',
	'datatransclusion-missing-source' => 'Issued if no data "source" or second positional argument was specified.',
	'datatransclusion-unknown-source' => 'Issued if an unknown data source was specified. Parameters:
* $1 is the name of the data source.',
	'datatransclusion-missing-key' => 'Issued if no argument matches an entry in the list of key field. Parameters:
* $1 is the name of the data source
* $2 is a list of all valid keys for this data source',
	'datatransclusion-bad-argument-by' => 'Issued if a bad value was specified for the "by" argument, that is, an unknown key field was selected. Parameters:
* $1 is the name of the data source
* $2 is the value of the by argument
* $3 is a list of all valid keys for this data source
* $4 is the number of valid keys for this data source.',
	'datatransclusion-missing-argument-key' => 'Issued if no "key" or second positional argument was given provided. A key value is always required.',
	'datatransclusion-missing-argument-template' => 'Issued if no "template" or first positional argument was given provided. A target template is always required.',
	'datatransclusion-record-not-found' => 'issued if the record specified using the "by" and "key" arguments was nout found in the data source.  Parameters:
* $1 is the name of the data source
* $2 is the key filed used
* $3 is the key value to select by.',
	'datatransclusion-bad-template-name' => 'Issued if the template name specified is not valid. Parameters:
* $1 is the given template name.',
	'datatransclusion-unknown-template' => 'Issued if the template specified does not exist. Parameters:
* $1 is the given template name.',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'datatransclusion-desc' => 'Імпарт і паказ зьвестак з вонкавых крыніц',
	'datatransclusion-missing-source' => 'Крыніца зьвестак не пазначаная.
Другі ці «крынічны» парамэтар — абавязковы.',
	'datatransclusion-unknown-source' => 'Няслушная крыніца зьвестак.
$1 — невядомая.',
	'datatransclusion-missing-key' => 'Ключ не пазначаны.
Слушнымі ключамі ў крыніцы зьвестак $1 зьяўляюцца $2.',
	'datatransclusion-bad-argument-by' => 'Пазначана няслушнае ключавое поле.
«$2» не зьяўляецца ключавым полем ў крыніцы зьвестак «$1».
{{PLURAL:$4|Слушным ключом зьяўляецца|Слушнымі ключамі зьяўляюцца}}: $3.',
	'datatransclusion-missing-argument-key' => 'Ключавое значэньне не пазначана.
Неабходны другі ці «ключавы» аргумэнт.',
	'datatransclusion-missing-argument-template' => 'Шаблён не пазначаны. 
Неабходны першы ці «шаблённы» аргумэнт.',
	'datatransclusion-record-not-found' => 'Ня знойдзеныя супадаючыя запісы $2 = $3 ў крыніцы зьвестак $1.',
	'datatransclusion-bad-template-name' => 'Няслушная назва шаблёну: $1.',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki> не існуе.',
);

/** Breton (Brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'datatransclusion-desc' => 'Enporzhiañ ha furmaozañ ar roadennoù o tont eus ar vammenn diavaez',
	'datatransclusion-missing-source' => 'N\'eo spisaet mammenn roadennoù ebet.
An eil arguzenn pe "mammenn" a zo ret.',
	'datatransclusion-unknown-source' => 'Direizh eo ar vammenn roadennoù spisaet.
Dianav eo $1.',
	'datatransclusion-missing-key' => "N'eo spisaet alc'hwez ebet.
$2 a zo an alc'hwezioù reizh evit ar vammenn rodennoù $1.",
	'datatransclusion-bad-argument-by' => 'Direizh eo an alc\'hwez maezienn spisaet.
N\'eo ket "$2" un alc\'hwez maezienn er vammenn roadennoù "$1".
An {{PLURAL:$4|alc\'hwez|alc\'hwezioù|}} a zo : $3.',
	'datatransclusion-missing-argument-key' => "N'eo spisaet talvoudenn alc'hwez ebet.
An eil arguzenn pe \"alc'hwez\" a zo ret.",
	'datatransclusion-missing-argument-template' => 'N\'eo spisaet patrom ebet.
An arguzenn gentañ pe "patrom" a zo ret.',
	'datatransclusion-record-not-found' => 'Enrolladenn ebet o wiriañ $2 = $3 a zo bet kavet e danvez ar roadennoù $1.',
	'datatransclusion-bad-template-name' => 'Anv patrom direizh : $1.',
	'datatransclusion-unknown-template' => "N'eus ket eus <nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki>.",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'datatransclusion-desc' => 'Uvoz i oblikovanje zapisa podataka iz vanjskih izvora podataka',
	'datatransclusion-missing-source' => 'Nije naveden izvor podataka.
Drugi ili "izvorni" argument je neophodan.',
	'datatransclusion-unknown-source' => 'Naveden nevaljan izvor podataka.
"$1" nije poznat.',
	'datatransclusion-missing-key' => 'Nije određen ključ.
$2 su valjani ključevi u izvoru podataka $1.',
	'datatransclusion-bad-argument-by' => 'Naznačeno loše ključno polje.
"$2" nije ključno polje u izvoru podataka "$1".
{{PLURAL:$4|Valjani ključ je|Valjani ključevi su}}: $3.',
	'datatransclusion-missing-argument-key' => 'Nije navedena ključna vrijednost.
Drugi ili "ključni" argument je neophodan.',
	'datatransclusion-missing-argument-template' => "Nije naveden šablon.
Prvi ili ''šablonski'' argument je obavezan.",
	'datatransclusion-record-not-found' => 'Odgovarajuća slaganja $2 = $3 nisu nađena u izvoru podataka $1.',
	'datatransclusion-bad-template-name' => 'Loše ime šablona: $1.',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki> ne postoji.',
);

/** Czech (Česky)
 * @author Jkjk
 */
$messages['cs'] = array(
	'datatransclusion-desc' => 'Import a zobrazování dat z externích zdrojů',
	'datatransclusion-unknown-source' => 'Špatný zdroj dat.
"$1" není známý.',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki> neexistuje.',
);

/** German (Deutsch)
 * @author Kghbln
 */
$messages['de'] = array(
	'datatransclusion-desc' => 'Ermöglicht den Import und die Darstellung von Datensätzen aus externen Datenquellen',
	'datatransclusion-missing-source' => 'Es wurde keine Datenquelle angegeben.
Ein zweites oder ein „Quell“-Argument ist erforderlich.',
	'datatransclusion-unknown-source' => 'Es wurde eine mangelhafte Datenquelle angegeben.
„$1“ ist nicht bekannt.',
	'datatransclusion-missing-key' => 'Es wurde kein Schlüssel angegeben.
„$2“ sind gültige Schlüssel in Datenquelle „$1“.',
	'datatransclusion-bad-argument-by' => 'Es wurde ein mangelhaftes Schlüsselfeld angegeben.
„$2“ ist kein Schlüsselfeld in der Datenquelle „$1“.
{{PLURAL:$4|Ein gültiger Schlüssel ist|Gültige Schlüssel sind}}: $3.',
	'datatransclusion-missing-argument-key' => 'Es wurde kein Schlüsselwert angegeben.
Ein zweites oder ein „Schlüssel“-Argument ist erforderlich.',
	'datatransclusion-missing-argument-template' => 'Es wurde keine Vorlage angegeben.
Das erste oder ein „Vorlagen“-Argument ist erforderlich.',
	'datatransclusion-record-not-found' => 'Es wurde kein passender Datensatz $2 = $3 in der Datenquelle „$1“ gefunden.',
	'datatransclusion-bad-template-name' => 'Mangelhafter Vorlagenname: $1.',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki> existiert nicht.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'datatransclusion-desc' => 'Importowanje a pśedstajenje datowych sajźbow z eksternych datowych žrědłow',
	'datatransclusion-missing-source' => 'Žedne datowe žrědło pódane.
Drugi abo "žrědłowy" argument jo trěbny.',
	'datatransclusion-unknown-source' => 'Wopacne datowe žrědło pódane.
$1 jo njeznaty.',
	'datatransclusion-missing-key' => 'Žeden kluc pódany.
$2 su płaśiwe kluce w datowem žrědle $1.',
	'datatransclusion-bad-argument-by' => 'Wopacne pólo pódane.
"$2" njejo klucowe pólo w datowem žrědle "$1".
{{PLURAL:$4|Płaíswy kluc jo|Płaśiwej kluca stej|Płaśiwe kluce su|Płaśiwe kluce su}}: $3.',
	'datatransclusion-missing-argument-key' => 'Žedna datowa gódnota pódana.
Drugi abo "klucowy" argument je trěbny.',
	'datatransclusion-missing-argument-template' => 'Žedna pśedłoga pódana.
Prědny abo "pśedłogowy" argument jo trěbny.',
	'datatransclusion-record-not-found' => 'W datowem žrědle $1 njejo se žedna sajźba namakała, kótaraž $2=$3 wótpowědujo.',
	'datatransclusion-bad-template-name' => 'Wopacne mě pśedłogi: $1.',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki> njeeksistěrujo.',
);

/** Spanish (Español)
 * @author Crazymadlover
 */
$messages['es'] = array(
	'datatransclusion-desc' => 'Importación y representación de registro de datos desde fuentes externas de datos',
	'datatransclusion-missing-source' => 'Ninguna fuente de datos especificada.
Argumento segundo o "fuente" es obligatorio.',
	'datatransclusion-unknown-source' => 'Fuente de datos mal especificado.
$1 es desconocido.',
	'datatransclusion-missing-key' => 'Sin clave especificada.
$2 son claves válidas en fuente de datos $1.',
	'datatransclusion-bad-argument-by' => 'Campo clave mal especificado.
"$2" no es un campo clave en la fuente de datos "$1".
{{PLURAL:$4|Clave válida|Claves válidas son}}: $3.',
	'datatransclusion-missing-argument-key' => 'Ningún valor clave especificado.
Argumento segundo o "clave" es obligatorio.',
	'datatransclusion-missing-argument-template' => 'Ninguna plantilla especificada.
Argumento primero o "plantilla" es obligatorio.',
	'datatransclusion-record-not-found' => 'Ningún registro coincidente $2 = $3 fue encontrado en la fuente de datos $1.',
	'datatransclusion-bad-template-name' => 'Mal nombre de plantilla: $1.',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki> no existe.',
);

/** French (Français)
 * @author IAlex
 * @author Peter17
 */
$messages['fr'] = array(
	'datatransclusion-desc' => 'Importer et mettre en forme des données depuis des sources externes',
	'datatransclusion-missing-source' => 'Aucune source de données n’est spécifiée.
Le deuxième argument ou « source » est obligatoire.',
	'datatransclusion-unknown-source' => 'Mauvaise source de données spécifiée.
$1 est inconnu.',
	'datatransclusion-missing-key' => 'Aucune clé n’est spécifiée.
$2 sont les clés valides pour la source de données $1.',
	'datatransclusion-bad-argument-by' => 'Mauvaise clé de champ spécifiée.
« $2 » n’est pas une clé de champ dans la source de données « $1 ».
{{PLURAL:$4|La clé valide est|Les clés valides sont}} : $3.',
	'datatransclusion-missing-argument-key' => 'Aucune valeur de clé spécifiée.
Le deuxième argument ou « clé » est obligatoire.',
	'datatransclusion-missing-argument-template' => 'Aucun modèle n’est spécifié.
Le premier argument ou « modèle » est obligatoire.',
	'datatransclusion-record-not-found' => 'Aucun enregistrement vérifiant $2 = $3 n’a été trouvé dans la source de données $1.',
	'datatransclusion-bad-template-name' => 'Mauvais nom de modèle : $1.',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki> n’existe pas.',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'datatransclusion-missing-source' => 'Niona sôrsa de balyês est spècefiâ.
Lo second argument ou ben « sôrsa » est oblegatouèro.',
	'datatransclusion-unknown-source' => 'Crouye sôrsa de balyês spècefiâ.
« $1 » est encognu.',
	'datatransclusion-missing-key' => 'Niona cllâf est spècefiâ.
$2 sont les cllâfs valides por la sôrsa de balyês $1.',
	'datatransclusion-bad-argument-by' => 'Crouye cllâf de champ spècefiâ.
« $2 » est pas una cllâf de champ dens la sôrsa de balyês « $1 ».
{{PLURAL:$4|La cllâf valida est|Les cllâfs valides sont}} : $3.',
	'datatransclusion-missing-argument-key' => 'Gins de valor de cllâf spècefiâ.
Lo second argument ou ben « cllâf » est oblegatouèro.',
	'datatransclusion-missing-argument-template' => 'Nion modèlo est spècefiâ.
Lo second argument ou ben « modèlo » est oblegatouèro.',
	'datatransclusion-record-not-found' => 'Nion encartâjo que contrôle $2 = $3 at étâ trovâ dens la sôrsa de balyês $1.',
	'datatransclusion-bad-template-name' => 'Crouyo nom de modèlo : $1.',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki> ègziste pas.',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'datatransclusion-desc' => 'Importación e procesamento de rexistros de datos de fontes externas',
	'datatransclusion-missing-source' => 'Non se especificou ningunha fonte de datos.
Necesítase o segundo argumento ou "fonte".',
	'datatransclusion-unknown-source' => 'A fonte de datos que se especificou é incorrecta.
Descoñécese o que é "$1".',
	'datatransclusion-missing-key' => 'Non se especificou ningunha clave.
"$2" son claves válidas na fonte de datos "$1".',
	'datatransclusion-bad-argument-by' => 'A clave de campo que se especificou é incorrecta.
"$2" non é unha clave de campo na fonte de datos "$1".
{{PLURAL:$4|Exemplo de clave válida|Exemplos de claves válidas}}: $3.',
	'datatransclusion-missing-argument-key' => 'Non se especificou ningún valor para a chave.
Necesítase o segundo argumento ou "clave".',
	'datatransclusion-missing-argument-template' => 'Non se especificou ningún modelo.
Necesítase o primeiro argumento ou "modelo".',
	'datatransclusion-record-not-found' => 'Non se atopou ningún rexistro que coincidise $2 = $3 na fonte de datos "$1".',
	'datatransclusion-bad-template-name' => 'O nome do modelo é incorrecto: $1.',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki> non existe.',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 * @author Purodha
 */
$messages['gsw'] = array(
	'datatransclusion-desc' => 'Importiere un Darstelle vu Datesätz us extärne Datequälle',
	'datatransclusion-missing-source' => 'S isch kei Datequälle aagee.
S brucht e zweit oder e „Quäll“-Argument.',
	'datatransclusion-unknown-source' => 'S isch e mangelhafti Datequälle aagee wore.
„$1“ isch nit bekannt.',
	'datatransclusion-missing-key' => 'S isch kei Schlissel aagee wore.
„$2“ sin giltigi Schlissel in dr Datequälle „$1“.',
	'datatransclusion-bad-argument-by' => 'S isch e mangelhaft Schlisselfäld aagee wore.
„$2“ isch kei Schlisselfäld in dr Datequälle „$1“.
{{PLURAL:$4|E giltige Schlissel isch|Giltigi Schlissel sin}}: $3.',
	'datatransclusion-missing-argument-key' => 'S isch kei Schlisselwärt aagee wore.
S brucht e zweit oder e „Schlissel“-Argumänt.',
	'datatransclusion-missing-argument-template' => 'S isch kei Vorlag aagee wore.
S brucht s erscht oder e „Vorlage“-Argumänt.',
	'datatransclusion-record-not-found' => 'S isch kei passende Datesatz $2 = $3 in dr Datequälle „$1“ gfunde wore.',
	'datatransclusion-bad-template-name' => 'Mangelhafte Vorlagename: $1.',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki> git s nit',
);

/** Hebrew (עברית)
 * @author YaronSh
 */
$messages['he'] = array(
	'datatransclusion-desc' => 'יבוא ועיבוד רשומות נתונים ממקורות נתונים חיצוניים',
	'datatransclusion-missing-source' => 'לא צוין מקור נתונים.
נדרש ארגומנט שני או "source".',
	'datatransclusion-unknown-source' => 'מקור הנתונים שצוין פגום.
"$1" אינו ידוע.',
	'datatransclusion-missing-key' => 'לא צוין מפתח.
$2 הנם מפתחות תקניים במקור הנתונים $1.',
	'datatransclusion-bad-argument-by' => 'שדה המפתח שצוין פגום.
"$2" אינו שדה מפתח במקור הנתונים "$1".
{{PLURAL:$4|המפתח התקני הוא|המפתחות התקניים הם}}: $3.',
	'datatransclusion-missing-argument-key' => 'לא צוין ערך למפתח.
דרוש ארגומנט שני או "key".',
	'datatransclusion-missing-argument-template' => 'לא נבחרה תבנית.
דרוש ארגומנט ראשון או "template".',
	'datatransclusion-record-not-found' => 'לא נמצאה רשומה התואמת $2 = $3 במקור הנתונים $1.',
	'datatransclusion-bad-template-name' => 'שם התבנית פגום: $1.',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki> אינו קיים.',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'datatransclusion-desc' => 'Importowanje a předstajenje datowych sadźbow z eksternych datowych žórłow',
	'datatransclusion-missing-source' => 'Žane datowe žórło podate.
Druhi abo "žórłowy" argument je trěbny.',
	'datatransclusion-unknown-source' => 'Wopačne datowe žórło podate.
$1 je njeznaty.',
	'datatransclusion-missing-key' => 'Žadyn kluč podaty.
$2 su płaćiwe kluče w datowym žórle $1.',
	'datatransclusion-bad-argument-by' => 'Wopačne klučowe polo podate.
$2 njeje klučowe polo w datowym žórle "$1".
{{PLURAL:$4|Płaćiwy kluč je|Płaćiwej klučej stej|Płaćiwe kluče su|Płaćiwe kluče su}}: $3',
	'datatransclusion-missing-argument-key' => 'Žana klučowa hódnota podata.
Druhi abo "klučowy" argument je trěbny.',
	'datatransclusion-missing-argument-template' => 'Žana předłoha podata.
Prěni abo "předłohowy" argument je trěbny.',
	'datatransclusion-record-not-found' => 'W datowym žórle $1 njeje so žana datowa sadźba namakała, kotraž $2=$3 wotpowěduje.',
	'datatransclusion-bad-template-name' => 'Wopačne mjeno předłohi: $1.',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki> njeeksistuje.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'datatransclusion-desc' => 'Importation e rendition de datos ex fontes externe',
	'datatransclusion-missing-source' => 'Nulle fonte de datos specificate.
Un secunde parametro "source" es obligatori.',
	'datatransclusion-unknown-source' => 'Un fonte de datos invalide ha essite specificate.
$1 non es cognoscite.',
	'datatransclusion-missing-key' => 'Nulle clave specificate.
$2 es le claves valide in le fonte de datos $1.',
	'datatransclusion-bad-argument-by' => 'Un campo de clave invalide ha essite specificate.
"$2" non es un campo de clave in le fonte de datos "$1".
Le {{PLURAL:$4|clave|claves}} valide es: $3.',
	'datatransclusion-missing-argument-key' => 'Nulle valor de clave specificate.
Un secunde parametro "key" es obligatori.',
	'datatransclusion-missing-argument-template' => 'Nulle patrono specificate.
Un prime parametro "template" es obligatori.',
	'datatransclusion-record-not-found' => 'Nulle dato correspondente a $2 = $3 ha essite trovate in le fonte de datos $1.',
	'datatransclusion-bad-template-name' => 'Nomine de patrono incorrecte: $1.',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki> non existe.',
);

/** Indonesian (Bahasa Indonesia)
 * @author Farras
 */
$messages['id'] = array(
	'datatransclusion-desc' => 'Mengimpor dan membuat catatan data dari sumber data luar',
	'datatransclusion-missing-source' => 'Tidak ada sumber data yang disebutkan.
Argumen kedua atau "sumber" dibutuhkan.',
	'datatransclusion-unknown-source' => 'Sumber data buruk disebutkan.
"$1" tidak dikenal.',
	'datatransclusion-missing-key' => 'Tidak ada kunci yang disebutkan.
$2 adalah kunci sah pada sumber data $1.',
	'datatransclusion-bad-argument-by' => 'Bidang kunci buruk disebutkan.
"$2" bukan sebuah bidang kunci pada sumber data "$1".
{{PLURAL:$4|Kunci sah|Kunci sah adalah}}: $3.',
	'datatransclusion-missing-argument-key' => 'Tidak ada nilai kunci yang disebutkan.
Argumen kedua atau "kunci" dibutuhkan.',
	'datatransclusion-missing-argument-template' => 'Tidak ada templat yang disebutkan.
Argumen pertama atau "templat" dibutuhkan.',
	'datatransclusion-record-not-found' => 'Tidak ada catatan yang cocok dengan $2 = $3 ditemukan di sumber data $1.',
	'datatransclusion-bad-template-name' => 'Nama templat buruk: $1.',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki> tidak ada.',
);

/** Italian (Italiano)
 * @author Beta16
 * @author EdoDodo
 */
$messages['it'] = array(
	'datatransclusion-unknown-source' => "Origine dati incorreta specificata.
''$1'' non è noto.",
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki> non esiste.',
);

/** Japanese (日本語)
 * @author Yanajin66
 * @author 青子守歌
 */
$messages['ja'] = array(
	'datatransclusion-desc' => '外部のデータソースからの記録データのインポートおよびレンダリング',
	'datatransclusion-missing-source' => 'データソースが指定されていません。
二番目または"source"引数が要求されています。',
	'datatransclusion-unknown-source' => '不正なデータソースが指定されました。 
 "$1"は認知されていない。',
	'datatransclusion-missing-key' => 'キーが指定されていません。
$2はデータソース$1において有効なキーです。',
	'datatransclusion-bad-argument-by' => '無効なキーフィールドを指定しました。
"$2"はデータソース"$1"におけるキーフィールドではありません。
{{PLURAL:$4|有効なキー|有効なキーの内容}}: $3。',
	'datatransclusion-missing-argument-key' => 'キーの値が指定されていません。
２番目あるいは"key"引数が要求されています。',
	'datatransclusion-missing-argument-template' => 'テンプレートが指定されていません。
一番目または"template"引数が要求されています。',
	'datatransclusion-record-not-found' => 'データソース$1において$2 = $3というようにマッチングする記録が見つかりませんでした。',
	'datatransclusion-bad-template-name' => '間違ったテンプレート名: $1。',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki>は存在しません。',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'datatransclusion-desc' => 'Määt et müjjelisch Daatesäz uß frembde Daatequälle ußerhallef vum Wiki ze empoteere un aanzezeije.',
	'datatransclusion-missing-source' => 'Et es kein Daatequäll aanjejovve.
Dat zweite Feld met dä Daatequäll es ävver nüüdesch.',
	'datatransclusion-unknown-source' => 'Et es kein joode Daatequäll aanjejovve.
„$1“ känne mer nit.',
	'datatransclusion-missing-key' => 'Et es keine Schlössel aanjejovve.
„$2“ sind de jöltije Schlössele en dä Daatequäll „$1“.',
	'datatransclusion-bad-argument-by' => 'Et es verkeehte Schlössel aanjejovve.
„$2“ es keine jöltije Schlössele en dä Daatequäll „$1“.
{{PLURAL:$4|Dä eijnzijje jöltije Schlössel es|De jöltije Schlössele sin}}: $3.',
	'datatransclusion-missing-argument-key' => 'Et es keine Wäät för dä Schlössel aanjejovve.
Dat zweite Feld met däm Wäät för dä Schlössel es ävver nüüdesch.',
	'datatransclusion-missing-argument-template' => 'Et es kein Schablon aanjejovve.
Dat eetste Feld met däm Name fun dä Schablon es ävver nüüdesch.',
	'datatransclusion-record-not-found' => 'Mer han kein zopaß Daatensäz en dä Daatequäll „$1“ jefonge, woh $2 = $3 dren wör.',
	'datatransclusion-bad-template-name' => '$1 is keine müjjeliche Name för en Schabloon.',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki> jidd et nit.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'datatransclusion-desc' => 'Import and Duerstellung vun Daten aus externe Quellen',
	'datatransclusion-missing-argument-template' => 'Keng Schabloun spezifizéiert.
Dat éischt oder "Schabloun"-Argument ass obligatoresch.',
	'datatransclusion-bad-template-name' => 'Schlechten Numm fir eng Schabloun: $1.',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki> gëtt et net.',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'datatransclusion-desc' => 'Увоз и обликување на податотечни записи од надворешни податотечни извори',
	'datatransclusion-missing-source' => 'Не е укажан податотечен извор. 
Се бара вториот аргумент или „извор“.',
	'datatransclusion-unknown-source' => 'укажан е лош податотечен извор ($1 е непознат)',
	'datatransclusion-missing-key' => 'Нема укажано клуч.
$2 се важечки клучеви во податотечниот извор $1.',
	'datatransclusion-bad-argument-by' => 'Укажано е лошо клучно поле.
„$2“ не е клучно поле во податочниот извор „$1“.
{{PLURAL:$4|Важечки клуч|Важечки клучеви се}}: $3.',
	'datatransclusion-missing-argument-key' => 'нема укажано вредност за клучот (се бара вториот аргумент или „клуч“)',
	'datatransclusion-missing-argument-template' => 'Нема укажано шаблон. 
Се бара првиот аргумент или „шаблон“.',
	'datatransclusion-record-not-found' => 'во податочниот извор $1 нема пронајдено запис што одговара на $2 = $3',
	'datatransclusion-bad-template-name' => 'лошо име на шаблон: $1',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[Template:$1|$1]]<nowiki>}}</nowiki> не постои.',
);

/** Marathi (मराठी)
 * @author V.narsikar
 */
$messages['mr'] = array(
	'datatransclusion-bad-template-name' => 'चुकीचे साचानाव:$1',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'datatransclusion-desc' => 'Import og gjengivelse av dataoppføringer fra eksterne datakilder',
	'datatransclusion-missing-source' => 'Ingen datakilde oppgitt.
Andre eller «kilde»-argument kreves.',
	'datatransclusion-unknown-source' => 'Dårlig datakilde oppgitt.
«$1» er ikke kjent.',
	'datatransclusion-missing-key' => 'Ingen nøkkel oppgitt.
$2 er gyldige nøkler i datakilden $1.',
	'datatransclusion-bad-argument-by' => 'Dårlig nøkkelfelt oppgitt.
«$2» er ikke et nøkkelfelt i datakilden «$1».
{{PLURAL:$4|Gyldig nøkkel|Gyldige nøkler}}: $3.',
	'datatransclusion-missing-argument-key' => 'Ingen nøkkelverdi oppgitt.
Andre eller «nøkkel»-argument kreves.',
	'datatransclusion-missing-argument-template' => 'Ingen mal oppgitt.
Første eller «mal»-argument kreves.',
	'datatransclusion-record-not-found' => 'Ingen oppføringer samsvarende $2 = $3 ble funnet i datakilden $1.',
	'datatransclusion-bad-template-name' => 'Dårlig malnavn: $1.',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki> finnes ikke.',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'datatransclusion-desc' => 'Importeren en renderen van gegevens uit externe bronnen',
	'datatransclusion-missing-source' => 'Er is geen gegevensbron aangegeven.
Een tweede of "bron"-argument is vereist.',
	'datatransclusion-unknown-source' => 'Er is een ongeldige gegevensbron aangegeven.
$1 is niet bekend.',
	'datatransclusion-missing-key' => 'Geen sleutel aangegeven.
$2 zijn geldige sleutels in gegevensbron $1.',
	'datatransclusion-bad-argument-by' => 'Ongeldig sleutelveld aangegeven.
"$2" is geen sleutelveld in gegevensbron "$1".
Geldige {{PLURAL:$4|sleutel is|sleutels zijn}}: $3.',
	'datatransclusion-missing-argument-key' => 'Er is geen sleutelwaarde aangegeven.
Een tweede argument of "sleutel" is verplicht.',
	'datatransclusion-missing-argument-template' => 'Geen sjabloon aangegeven.
Een eerste argument of "template"-argument is verplicht.',
	'datatransclusion-record-not-found' => 'Er is geen overeenkomstig gegeven $2 = $3 gevonden in de gegevensbron $1.',
	'datatransclusion-bad-template-name' => 'Ongeldige sjabloonnaam: $1.',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki>  bestaat niet.',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'datatransclusion-desc' => 'Import i renderowanie rekordów danych z zewnętrznych źródeł',
	'datatransclusion-missing-source' => 'Nie określono źródła danych.
Argumenty drugi lub „źródło“są wymagane.',
	'datatransclusion-unknown-source' => 'Określono złe źródło danych.
Nie znam „$1“.',
	'datatransclusion-missing-key' => 'Nie określono klucza.
$2 są prawidłowymi kluczami dla źródła danych $1.',
	'datatransclusion-bad-argument-by' => 'Określono złe pole klucza.
„$2“ nie jest kluczem w źródłe danych „$1“.
{{PLURAL:$4|Prawidłowy klucz to|Prawidłowe klucze:}} $3.',
	'datatransclusion-missing-argument-key' => 'Nie określono wartości klucza.
Argumenty drugi lub „klucz“ są wymagane.',
	'datatransclusion-missing-argument-template' => 'Nie określono szablonu.
Argumenty pierwszy lub „szablon“ są wymagane.',
	'datatransclusion-record-not-found' => 'Brak rekordów pasujących $2 = $3 w danych ze źródła $1.',
	'datatransclusion-bad-template-name' => 'Zła nazwa szablonu – $1.',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki> nie istnieje.',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'datatransclusion-desc' => 'Amporté e smon-e an forma ëd dat da dle sorgiss esterne ëd dat',
	'datatransclusion-missing-source' => 'Gnun-e sogziss ëd dat spessificà.
Ël second argoment o "sorgiss" a l\'é obligatòri',
	'datatransclusion-unknown-source' => 'Sorgiss ëd dat spessificà pa bon-a.
"$1" a l\'é dësconossù.',
	'datatransclusion-missing-key' => 'Gnun-e ciav spessificà.
$2 a son ciav bon-e ant la sorgiss ëd dat $1.',
	'datatransclusion-bad-argument-by' => 'Camp ciav spessificà pa bon.
"$2" a l\'é pa un camp ciav ant la sorgiss ëd dat "$1".
{{PLURAL:$4|La ciav bon-a a l\'é|Le ciav bon-e a son}}: $3.',
	'datatransclusion-missing-argument-key' => 'Gnun valor ëd ciav spessificà.
Ël second argoment o "ciav" a l\'é obligatòri.',
	'datatransclusion-missing-argument-template' => 'Gnun ëstamp spessificà.
Ël prim argoment o "stamp" a l\'é obligatòri.',
	'datatransclusion-record-not-found' => "Gnun-a registrassion ch'a vala $2 = $3 a l'é stàita trovà ant la sorgiss ëd dat $1.",
	'datatransclusion-bad-template-name' => 'Nòm dë stamp pa bon: $1.',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki>  a esist pa.',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'datatransclusion-desc' => 'Importação e apresentação de registos de dados vindos de fontes externas',
	'datatransclusion-missing-source' => 'Não foi especificada a fonte dos dados.
O segundo argumento, ou argumento "fonte", é obrigatório.',
	'datatransclusion-unknown-source' => 'A fonte de dados especificada é incorrecta.
$1 não é conhecido.',
	'datatransclusion-missing-key' => 'Não foi especificada uma chave.
$2 são chaves válidas na fonte de dados $1.',
	'datatransclusion-bad-argument-by' => 'Foi especificado um campo chave incorrecto.
"$2" não é um campo chave na fonte de dados "$1".
{{PLURAL:$4|O único campo chave válido é|Os campos chave válidos são}}: $3.',
	'datatransclusion-missing-argument-key' => 'Não foi especificado um campo chave.
O segundo argumento, ou argumento "chave", é obrigatório.',
	'datatransclusion-missing-argument-template' => 'Não foi especificada uma predefinição.
O primeiro argumento, ou argumento "predefinição", é obrigatório.',
	'datatransclusion-record-not-found' => 'Não foi encontrado nenhum registo $2 = $3 na fonte de dados $1.',
	'datatransclusion-bad-template-name' => 'Nome da predefinição incorrecto: $1.',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki> não existe.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 */
$messages['pt-br'] = array(
	'datatransclusion-desc' => 'Importação e apresentação de registros de dados vindos de fontes externas',
	'datatransclusion-missing-source' => 'Não foi especificada a fonte dos dados.
O segundo argumento, ou argumento "fonte", é obrigatório.',
	'datatransclusion-unknown-source' => 'A fonte de dados especificada é incorreta.
$1 não é conhecido.',
	'datatransclusion-missing-key' => 'Não foi especificada uma chave.
$2 são chaves válidas na fonte de dados $1.',
	'datatransclusion-bad-argument-by' => 'Foi especificado um campo chave incorreto.
"$2" não é um campo chave na fonte de dados "$1".
{{PLURAL:$4|O único campo chave válido é|Os campos chave válidos são}}: $3.',
	'datatransclusion-missing-argument-key' => 'Não foi especificado um campo chave.
O segundo argumento, ou argumento "chave", é obrigatório.',
	'datatransclusion-missing-argument-template' => 'Não foi especificada uma predefinição.
O primeiro argumento, ou argumento "predefinição", é obrigatório.',
	'datatransclusion-record-not-found' => 'Não foi encontrado nenhum registro $2 = $3 na fonte de dados $1.',
	'datatransclusion-bad-template-name' => 'Nome da predefinição incorreto: $1.',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki>  não existe.',
);

/** Russian (Русский)
 * @author G0rn
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'datatransclusion-desc' => 'Импорт и обработка данных из внешних источников данных',
	'datatransclusion-missing-source' => 'Не указан источник данных.
Первый аргумент (аргумент источника) является обязательным.',
	'datatransclusion-unknown-source' => 'Указан неправильный источник данных.
$1 — неизвестен.',
	'datatransclusion-missing-key' => 'Не задан ключ.
Допустимыми ключами источника данных $1 являются $2.',
	'datatransclusion-bad-argument-by' => 'Указано неправильное ключевое поле.
$2 не является ключевым полем в источнике данных $1.  
{{PLURAL:$4|Действительный ключ|Действительными ключами являются}}: $3.',
	'datatransclusion-missing-argument-key' => 'Не указано значение ключа.
Второй или «ключевой» аргумент является обязательным.',
	'datatransclusion-missing-argument-template' => 'Не указан шаблон.
Третий («шаблонный») аргумент является обязательным.',
	'datatransclusion-record-not-found' => 'В источнике данных $1 не найдено записи, соответствующей $2 = $3',
	'datatransclusion-bad-template-name' => 'Неправильное название шаблона: $1.',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki>  не существуе.',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'datatransclusion-bad-template-name' => 'Неисправан назив шаблона: $1.',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬) */
$messages['sr-el'] = array(
	'datatransclusion-bad-template-name' => 'Neispravan naziv šablona: $1.',
);

/** Swedish (Svenska)
 * @author Boivie
 */
$messages['sv'] = array(
	'datatransclusion-desc' => 'Import och rendering av registrerade data från externa datakällor',
	'datatransclusion-missing-source' => 'Ingen datakälla anges.
Andra eller "source"-argument krävs.',
	'datatransclusion-unknown-source' => '"$1" är inte känd.',
	'datatransclusion-missing-key' => '$2 är giltiga nycklar i datakällan $1.',
	'datatransclusion-bad-argument-by' => 'Dåligt nyckelfält anges.
"$2" är inte ett nyckelfält i datakällan "$1".
{{PLURAL:$4|Giltig nyckel|Giltiga nycklar är}}: $3.',
	'datatransclusion-missing-argument-key' => 'Inget nyckelvärde anges.
Andra eller "nyckel"-argument krävs.',
	'datatransclusion-missing-argument-template' => 'Ingen mall anges.
Första eller "template"-argument krävs.',
	'datatransclusion-record-not-found' => 'Inga uppgifter matchande $2 = $3 hittades i datakällan $1.',
	'datatransclusion-bad-template-name' => 'Dåligt mallnamn: $1.',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki> existerar inte.',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 */
$messages['te'] = array(
	'datatransclusion-unknown-source' => 'చెడ్డ డేటా సోర్సు ఇచ్చారు.
"$1" తెలీదు.',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'datatransclusion-desc' => 'Pag-aangkat at pagdudulog ng mga talaan ng dato mula sa mga pinagmulan ng datong panlabas',
	'datatransclusion-missing-source' => 'Walang tinukoy na pinagmulan ng dato.
Kailangan ang pangalawa o "pinagmulang" argumento.',
	'datatransclusion-unknown-source' => 'Natukoy ang masamang pinagmulan ng dato.
Hindi alam ang $1.',
	'datatransclusion-missing-key' => 'Walang tinukooy na susi.
Ang $2 ay tanggap na mga susi sa loob ng pinagmulan ng dato na $1.',
	'datatransclusion-bad-argument-by' => 'Tumukoy ng isang masamang susing larangan.
Ang "$2" ay hindi isang susing larangan sa loob ng pinagmulan ng dato na "$1".
{{PLURAL:$4|Tanggap na susi|Tanggap na mga susi ang}}: $3.',
	'datatransclusion-missing-argument-key' => 'Walang tinukoy na halaga ng susi.
Kailangan ang pangalawa o "susi" na argumento.',
	'datatransclusion-missing-argument-template' => 'Walang tinukoy na suleras.
Kailangan ang argumentong una o "suleras".',
	'datatransclusion-record-not-found' => 'Walang natagpuang rekord na tumutugma sa $2 = $3 na nasa loob ng pinagmulan ng dato na $1.',
	'datatransclusion-bad-template-name' => 'Masamang pangalan ng suleras: $1.',
	'datatransclusion-unknown-template' => 'Hindi umiiral ang <nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki>.',
);

/** Turkish (Türkçe)
 * @author Manco Capac
 */
$messages['tr'] = array(
	'datatransclusion-desc' => 'Dış veri kaynaklarından veri kayıtlarının aktarılması ve işlenmesi',
	'datatransclusion-missing-source' => 'Hiç veri kaynağı belirtilmedi.
İkinci bir kaynak ya da "kaynak" ispatı gerekmektedir.',
	'datatransclusion-unknown-source' => 'Belirtilen veri kaynağı kötüdür.
"$1" bilinmemektedir.',
	'datatransclusion-missing-key' => 'Hiç anahtar belirtilmedi.
$2, $1 veri kaynağındaki geçerli anahtarlardır.',
	'datatransclusion-bad-argument-by' => 'Kötü anahtar alanı belirtildi.
"$2", "$1" veri kaynağı içinde bir anahtar alanı değildir.
{{PLURAL:$4|Geçerli anahtar|Geçerli anahtarlar}}: $3.',
	'datatransclusion-missing-argument-key' => 'Hiç anahtar değeri belirtilmedi.
İkinci bir anahtar ya da "anahtar" ispatı gerekmektedir.',
	'datatransclusion-missing-argument-template' => 'Hiç şablon belirtilmedi.
Birincisi ya da "şablon" ispatı gerekmektedir.',
	'datatransclusion-record-not-found' => '$1 veri kaynağında, $2 = $3 şekline uyan hiç bir kayıt bulunamadı.',
	'datatransclusion-bad-template-name' => 'Kötü şablon adı: $1.',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki> varolmamaktadır.',
);

/** Ukrainian (Українська)
 * @author NickK
 * @author Тест
 */
$messages['uk'] = array(
	'datatransclusion-bad-template-name' => 'Неправильна назва шаблону: $1.',
	'datatransclusion-unknown-template' => '<nowiki>{{</nowiki>[[{{ns:template}}:$1|$1]]<nowiki>}}</nowiki> не існує.',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hydra
 * @author PhiLiP
 */
$messages['zh-hans'] = array(
	'datatransclusion-desc' => '导入和呈现从外部数据源的数据记录',
	'datatransclusion-missing-source' => '没有指定数据源。第二次或“源”参数是必需的。',
	'datatransclusion-unknown-source' => '指定错误的数据源。
"$1"未知的。',
);

/** Traditional Chinese (‪中文(繁體)‬) */
$messages['zh-hant'] = array(
	'datatransclusion-desc' => '導入和呈現從外部數據源的數據記錄',
	'datatransclusion-missing-source' => '沒有指定數據源。第二次或“源”參數是必需的。',
	'datatransclusion-unknown-source' => '指定錯誤的數據源。
"$1"未知的。',
);

