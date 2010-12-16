<?php

/**
 * Internationalization file for the Validator extension
 *
 * @file Validator.i18n.php
 * @ingroup Validator
 *
 * @author Jeroen De Dauw
*/

$messages = array();

/** English
 * @author Jeroen De Dauw
 */
$messages['en'] = array(
	'validator-desc' => 'Provides generic parameter handling support for other extensions',

	// General
	'validator-warning' => 'Warning: $1',
	'validator-error' => 'Error: $1',
	'validator-fatal-error' => 'Fatal error: $1',
	'validator_error_parameters' => 'The following {{PLURAL:$1|error has|errors have}} been detected in your syntax:',
	'validator_warning_parameters' => 'There {{PLURAL:$1|is an error|are errors}} in your syntax.',
	'validator-warning-adittional-errors' => '... and {{PLURAL:$1|one more issue|multiple more issues}}.',
	'validator-error-omitted' => 'The {{PLURAL:$2|value "$1" has|values "$1" have}} been omitted.',
	'validator-error-problem' => 'There was a problem with parameter $1.',

	// General errors
	'validator_error_unknown_argument' => '$1 is not a valid parameter.',
	'validator_error_required_missing' => 'The required parameter "$1" is not provided.',
	'validator-error-override-argument' => 'Tried to override parameter $1 (value: $2) with value "$3"', 

	// Listerrors
	'validator-listerrors-errors' => 'Errors',
	'validator-listerrors-severity-message' => '($1) $2', // $1 = severity; $2 = message
	'validator-listerrors-minor' => 'Minor',
	'validator-listerrors-low' => 'Low',
	'validator-listerrors-normal' => 'Normal',
	'validator-listerrors-high' => 'High',
	'validator-listerrors-fatal' => 'Fatal',

	// Criteria errors for single values
	'validator_error_empty_argument' => 'Parameter $1 can not have an empty value.',
	'validator_error_must_be_number' => 'Parameter $1 can only be a number.',
	'validator_error_must_be_integer' => 'Parameter $1 can only be an integer.',
	'validator-error-must-be-float' => 'Parameter $1 can only be a floating point number.',
	'validator_error_invalid_range' => 'Parameter $1 must be between $2 and $3.',
	'validator-error-invalid-regex' => 'Parameter $1 must match this regular expression: $2.',
	'validator-error-invalid-length' => 'Parameter $1 must have a length of $2.',
	'validator-error-invalid-length-range' => 'Parameter $1 must have a length between $2 and $3.',
	'validator_error_invalid_argument' => 'The value $1 is not valid for parameter $2.',

	// Criteria errors for lists
	'validator_list_error_empty_argument' => 'Parameter $1 does not accept empty values.',
	'validator_list_error_must_be_number' => 'Parameter $1 can only contain numbers.',
	'validator_list_error_must_be_integer' => 'Parameter $1 can only contain integers.',
	'validator-list-error-must-be-float' => 'Parameter $1 can only contain floats.',
	'validator_list_error_invalid_range' => 'All values of parameter $1 must be between $2 and $3.',
	'validator-list-error-invalid-regex' => 'All values of parameter $1 must match this regular expression: $2.',
	'validator_list_error_invalid_argument' => 'One or more values for parameter $1 are invalid.',
	'validator-list-error-accepts-only' => 'One or more values for parameter $1 are invalid.
It only accepts {{PLURAL:$3|this value|these values}}: $2.',
	'validator-list-error-accepts-only-omitted' => 'One or more values for parameter $1 are invalid.
It only accepts {{PLURAL:$3|this value|these values}}: $2 (and $4 omitted {{PLURAL:$4|value|values}}).',

	// Criteria errors for single values & lists
	'validator_error_accepts_only' => 'The value "$4" is not valid for parameter $1.
It only accepts {{PLURAL:$3|this value|these values}}: $2.',
	'validator-error-accepts-only-omitted' => 'The value "$2" is not valid for parameter $1.
It only accepts {{PLURAL:$5|this value|these values}}: $3 (and $4 omitted {{PLURAL:$4|value|values}}).',

	'validator_list_omitted' => 'The {{PLURAL:$2|value|values}} $1 {{PLURAL:$2|has|have}} been omitted.',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Purodha
 * @author Raymond
 */
$messages['qqq'] = array(
	'validator-desc' => '{{desc}}',
	'validator-warning' => '{{Identical|Warning}}',
	'validator-error' => '{{Identical|Error}}',
	'validator_error_parameters' => 'Parameters:
* $1 is the number of syntax errors, for PLURAL support (optional)',
	'validator-listerrors-errors' => '{{Identical|Error}}',
	'validator-listerrors-severity-message' => '{{Optional}}
* $1 = severit
* $2 = message',
	'validator-listerrors-normal' => '{{Identical|Normal}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'validator-desc' => 'Die valideerder gee ander uitbreidings die vermoë om parameters van ontlederfunksies en etiket-uitbreidings te valideer, op hulle verstekwaardes in te stel en om foutboodskappe te genereer',
	'validator-warning' => 'Waarskuwing: $ 1',
	'validator-error' => 'Fout: $1',
	'validator-fatal-error' => 'Onherstelbare fout: $1',
	'validator_error_parameters' => 'Die volgende {{PLURAL:$1|fout|foute}} is in u sintaks waargeneem:',
	'validator_error_unknown_argument' => "$1 is nie 'n geldige parameter nie.",
	'validator_error_required_missing' => 'Die verpligte parameter $1 is nie verskaf nie.',
	'validator-listerrors-errors' => 'Foute',
	'validator-listerrors-minor' => 'Oorkomelik',
	'validator-listerrors-low' => 'Laag',
	'validator-listerrors-normal' => 'Gemiddeld',
	'validator-listerrors-high' => 'Groot',
	'validator-listerrors-fatal' => 'Fataal',
	'validator_error_empty_argument' => 'Die parameter $1 mag nie leeg wees nie.',
	'validator_error_must_be_number' => "Die parameter $1 mag net 'n getal wees.",
	'validator_error_must_be_integer' => "Die parameter $1 kan slegs 'n heelgetal wees.",
	'validator_error_invalid_range' => 'Die parameter $1 moet tussen $2 en $3 lê.',
	'validator_error_invalid_argument' => 'Die waarde $1 is nie geldig vir parameter $2 nie.',
	'validator_error_accepts_only' => 'Die parameter $1 kan slegs die volgende {{PLURAL:$3|waarde|waardes}} hê: $2.',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'validator-desc' => 'Validator është një zgjerim MediaWiki që ofron parametër përgjithshme trajtimin mbështetje të shtesave të tjera',
	'validator_error_parameters' => 'Më poshtë {{PLURAL:$1|gabim ka gabime|kanë}} është zbuluar në sintaksën e juaj:',
	'validator_warning_parameters' => 'Ka {{PLURAL:$1|është|janë gabime gabim}} në sintaksë tuaj.',
	'validator_error_unknown_argument' => '$1 nuk është një parametër i vlefshëm.',
	'validator_error_required_missing' => 'Parametrat e nevojshëm $1 nuk jepet.',
	'validator_error_empty_argument' => 'Parametër $1 nuk mund të ketë një vlerë bosh.',
	'validator_error_must_be_number' => 'Parametër $1 mund të jetë vetëm një numër.',
	'validator_error_must_be_integer' => 'Parametër $1 mund të jetë vetëm një numër i plotë.',
	'validator_error_invalid_range' => 'Parametër $1 duhet të jetë në mes të $2 dhe $3.',
	'validator_error_invalid_argument' => 'Vlera $1 nuk është i vlefshëm për parametër $2.',
	'validator_list_error_empty_argument' => 'Parametër $1 nuk e pranon vlerat bosh.',
	'validator_list_error_must_be_number' => 'Parametër $1 mund të përmbajë vetëm numrat.',
	'validator_list_error_must_be_integer' => 'Parametër $1 mund të përmbajë vetëm numra të plotë.',
	'validator_list_error_invalid_range' => 'Të gjitha vlerat e parametrit $1 duhet të jetë në mes të $2 dhe $3.',
	'validator_list_error_invalid_argument' => 'Një ose më shumë vlera për parametër $1 janë të pavlefshme.',
	'validator_list_omitted' => '{{PLURAL:$2 |vlerë|vlerat}} $1 {{PLURAL:$2|ka|kanë}} janë lënë jashtë.',
	'validator_error_accepts_only' => 'Parametër $1 vetëm pranon {{PLURAL:$3|kjo vlerë|këtyre vlerave}}: $2.',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'validator-desc' => 'المحقق يوفر طريقة سهلة للامتدادات الأخرى للتحقق من محددات دوال المحلل وامتدادات الوسوم، وضبط القيم الافتراضية وتوليد رسائل الخطأ',
	'validator_error_parameters' => '{{PLURAL:$1|الخطأ التالي|الاخطاء التالية}} تم كشفها في صياغتك:',
	'validator_warning_parameters' => 'هناك {{PLURAL:$1|خطأ|أخطاء}} في صياغتك.',
	'validator_error_unknown_argument' => '$1 ليس محددا صحيحا.',
	'validator_error_required_missing' => 'المحدد المطلوب $1 ليس متوفرا.',
	'validator_error_empty_argument' => 'المحدد $1 لا يمكن أن تكون قيمته فارغة.',
	'validator_error_must_be_number' => 'المحدد $1 يمكن أن يكون فقط عددا.',
	'validator_error_must_be_integer' => 'المحدد $1 يمكن أن يكون عددا صحيحا فقط.',
	'validator_error_invalid_range' => 'المحدد $1 يجب أن يكون بين $2 و $3.',
	'validator_error_invalid_argument' => 'القيمة $1 ليست صحيحة للمحدد $2.',
	'validator_list_error_empty_argument' => 'المحدد $1 لا يقبل القيم الفارغة.',
	'validator_list_error_must_be_number' => 'المحدد $1 يمكن أن يحتوي فقط على أرقام.',
	'validator_list_error_must_be_integer' => 'المحدد $1 يمكن أن يحتوي فقط على أرقام صحيحة.',
	'validator_list_error_invalid_range' => 'كل قيم المحدد $1 يجب أن تكون بين $2 و$3.',
	'validator_list_error_invalid_argument' => 'قيمة واحدة أو أكثر للمحدد $1 غير صحيحة.',
	'validator_list_omitted' => '{{PLURAL:$2|القيمة|القيم}} $1 {{PLURAL:$2|تم|تم}} مسحها.',
	'validator_error_accepts_only' => 'المحدد $1 يقبل فقط {{PLURAL:$3|هذه القيمة|هذه القيم}}: $2.',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'validator-desc' => 'Правяраючы палягчае іншым пашырэньням працу па праверцы парамэтраў функцыяў парсэру і тэгаў пашырэньняў, устанаўлівае значэньні па змоўчваньні і стварае паведамленьні пра памылкі',
	'validator-warning' => 'Папярэджаньне: $1',
	'validator-error' => 'Памылка: $1',
	'validator-fatal-error' => 'Крытычная памылка: $1',
	'validator_error_parameters' => 'У сынтаксісе {{PLURAL:$1|выяўленая наступная памылка|выяўленыя наступныя памылкі}}:',
	'validator_warning_parameters' => 'У Вашы сынтаксісе {{PLURAL:$1|маецца памылка|маюцца памылкі}}.',
	'validator-warning-adittional-errors' => '... і {{PLURAL:$1|яшчэ адна праблема|яшчэ некалькі праблемаў}}.',
	'validator-error-omitted' => '{{PLURAL:$2|Значэньне «$1» было прапушчанае|Значэньні «$1» былі прапушчаныя}}.',
	'validator-error-problem' => 'Узьнікла праблема з парамэтрам $1.',
	'validator_error_unknown_argument' => 'Няслушны парамэтар $1.',
	'validator_error_required_missing' => 'Не пададзены абавязковы парамэтар $1.',
	'validator-error-override-argument' => 'Спрабаваў памяняць значэньне парамэтру $1 з «$2» на «$3»',
	'validator-listerrors-errors' => 'Памылкі',
	'validator-listerrors-minor' => 'Дробная',
	'validator-listerrors-low' => 'Малая',
	'validator-listerrors-normal' => 'Звычайная',
	'validator-listerrors-high' => 'Значная',
	'validator-listerrors-fatal' => 'Фатальная',
	'validator_error_empty_argument' => 'Парамэтар $1 ня можа мець пустое значэньне.',
	'validator_error_must_be_number' => 'Парамэтар $1 можа быць толькі лікам.',
	'validator_error_must_be_integer' => 'Парамэтар $1 можа быць толькі цэлым лікам.',
	'validator-error-must-be-float' => 'Парамэтар $1 можа быць толькі лікам з плаваючай коскай.',
	'validator_error_invalid_range' => 'Парамэтар $1 павінен быць паміж $2 і $3.',
	'validator-error-invalid-regex' => 'парамэтар $1 мусіць адпавядаць гэтаму рэгулярнаму выразу: $2.',
	'validator-error-invalid-length' => 'Парамэтар $1 павінен мець даўжыню $2.',
	'validator-error-invalid-length-range' => 'Парамэтар $1 павінен мець даўжыню паміж $2 і $3.',
	'validator_error_invalid_argument' => 'Значэньне $1 не зьяўляецца слушным для парамэтру $2.',
	'validator_list_error_empty_argument' => 'Парамэтар $1 ня можа прымаць пустыя значэньні.',
	'validator_list_error_must_be_number' => 'Парамэтар $1 можа ўтрымліваць толькі лікі.',
	'validator_list_error_must_be_integer' => 'Парамэтар $1 можа ўтрымліваць толькі цэлыя лікі.',
	'validator-list-error-must-be-float' => 'Парамэтар $1 можа ўтрымліваць толькі лікі з плаваючай кропкай.',
	'validator_list_error_invalid_range' => 'Усе значэньні парамэтру $1 павінны знаходзіцца паміж $2 і $3.',
	'validator-list-error-invalid-regex' => 'Усе значэньні парамэтру $1 мусяць адпавядаць гэтаму рэгулярнаму выразу: $2.',
	'validator_list_error_invalid_argument' => 'Адно ці болей значэньняў парамэтру $1 зьяўляюцца няслушнымі.',
	'validator-list-error-accepts-only' => 'Адзін ці некалькі значэньняў парамэтру $1 зьяўляюцца няслушнымі.
{{PLURAL:$3|Ён мусіць мець наступнае значэньне|Яны мусяць мець наступныя значэньні}}: $2.',
	'validator-list-error-accepts-only-omitted' => 'Адзін ці некалькі значэньняў парамэтру $1 зьяўляюцца няслушнымі.
{{PLURAL:$3|Ён мусіць мець наступнае значэньне|Яны мусяць мець наступныя значэньні}}: $2. (і $4  {{PLURAL:$4|прапушчанае значэньне|прапушчаныя значэньні|прапушчаных значэньняў}}).',
	'validator_error_accepts_only' => 'Значэньне «$4» зьяўляецца няслушным для парамэтру $1. Ён можа прымаць толькі {{PLURAL:$3|гэтае значэньне|гэтыя значэньні}}: $2.',
	'validator-error-accepts-only-omitted' => 'Значэньне «$2» зьяўляецца няслушным для парамэтру $1.
{{PLURAL:$5|Ён мусіць мець наступнае значэньне|Яны мусяць мець наступныя значэньні}}: $3. (і $4  {{PLURAL:$4|прапушчанае значэньне|прапушчаныя значэньні|прапушчаных значэньняў}}).',
	'validator_list_omitted' => '{{PLURAL:$2|Значэньне|Значэньні}} $1 {{PLURAL:$2|было прапушчанае|былі прапушчаныя}}.',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Reedy
 */
$messages['bg'] = array(
	'validator_error_empty_argument' => 'Параметърът $1 не може да има празна стойност.',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Gwendal
 * @author Y-M D
 */
$messages['br'] = array(
	'validator-desc' => 'Un doare aes eo kadarnataer evit an astennoù all da gadarnaat arventennoù ar fonksionoù parser hag astennoù ar balizennoù, evit termeniñ talvoudennoù dre ziouer ha sevel kemennoù fazioù',
	'validator-warning' => 'Diwallit : $1',
	'validator-error' => 'Fazi : $1',
	'validator-fatal-error' => 'Fazi diremed: $1',
	'validator_error_parameters' => "Kavet eo bet ar {{PLURAL:$1|fazi|fazioù}} da-heul en hoc'h ereadur :",
	'validator_warning_parameters' => "{{PLURAL:$1|Ur fazi|Fazioù}} zo en hoc'h ereadur.",
	'validator-warning-adittional-errors' => '... {{PLURAL:$1|hag ur gudenn bennak all|ha meur a gudenn all}}.',
	'validator-error-omitted' => 'N\'eo ket bet merket ar {{PLURAL:$2|roadenn "$1"|roadennoù "$1"}}.',
	'validator-error-problem' => 'Ur gudenn zo bet gant an arventenn $1.',
	'validator_error_unknown_argument' => "$1 n'eo ket un arventenn reizh.",
	'validator_error_required_missing' => "N'eo ket bet pourchaset an arventenn rekis $1",
	'validator-error-override-argument' => 'Klasket en deus ar meziant erlec\'hiañ an arventenn $1 (talvoud : $2) gant an talvoud "$3"',
	'validator-listerrors-errors' => 'Fazioù',
	'validator-listerrors-minor' => 'Minor',
	'validator-listerrors-low' => 'Gwan',
	'validator-listerrors-normal' => 'Reizh',
	'validator-listerrors-high' => 'Uhel',
	'validator-listerrors-fatal' => 'Diremed',
	'validator_error_empty_argument' => "N'hall ket an arventenn $1 bezañ goullo he zalvoudenn",
	'validator_error_must_be_number' => 'Un niver e rank an arventenn $1 bezañ hepken.',
	'validator_error_must_be_integer' => 'Rankout a ra an arventenn $1 bezañ un niver anterin.',
	'validator_error_invalid_range' => 'Rankout a ra an arventenn $1 bezañ etre $2 hag $3.',
	'validator-error-invalid-length' => "Ret eo d'an arventenn $1 bezañ par he hed da $2.",
	'validator-error-invalid-length-range' => 'Rankout a ra an arventenn $1 bezañ he hed etre $2 hag $3.',
	'validator_error_invalid_argument' => "N'eo ket reizh an dalvoudenn $1 evit an arventenn $2.",
	'validator_list_error_empty_argument' => 'Ne zegemer ket an arventenn $1 an talvoudennoù goullo.',
	'validator_list_error_must_be_number' => "N'hall bezañ nemet niveroù en arventenn $1.",
	'validator_list_error_must_be_integer' => "N'hall bezañ nemet niveroù anterin en arventenn $1.",
	'validator-list-error-must-be-float' => "N'hall bezañ nemet niveroù gant skej en arventenn $1.",
	'validator_list_error_invalid_range' => 'An holl talvoudennoù eus an arventenn $1 a rank bezañ etre $2 ha $3.',
	'validator_list_error_invalid_argument' => 'Faziek eo unan pe meur a dalvoudenn eus an arventenn $1.',
	'validator-list-error-accepts-only' => 'Direizh eo unan pe meur a hini eus an talvoudoù evit an arventenn $1.
Ne zegemer nemet an {{PLURAL:$3|talvoud|talvoudoù}}-mañ : $2.',
	'validator-list-error-accepts-only-omitted' => 'Direizh eo unan pe meur a hini eus an talvoudoù evit an arventenn $1.
Ne zegemer nemet an {{PLURAL:$3|talvoud|talvoudoù}}-mañ : $2 (ha $4 {{PLURAL:$4|talvoud anroet|talvoud anroet}}).',
	'validator_error_accepts_only' => 'Ne zegemer ket an arventenn $1 an talvoud "$4". Ne zegemer nemet {{PLURAL:$3|an talvoud|an talvoudoù}}-mañ : $2.',
	'validator-error-accepts-only-omitted' => 'Direizh eo an talvoud "$2" evit an arventenn $1.
Ne zegemer nemet an {{PLURAL:$5|talvoud|talvoudoù}}-mañ : $3 (ha $4 {{PLURAL:$4|talvoud anroet|talvoud anroet}}).',
	'validator_list_omitted' => 'Disoñjet eo bet an {{PLURAL:$2|talvoudenn|talvoudennoù}} $1.',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'validator-desc' => 'Validator pruža jednostavni način za druga proširenja u svrhu validacije parametara parserskih funkcija i proširenja oznaka, postavlja pretpostavljene vrijednosti i generira poruke pogrešaka.',
	'validator-warning' => 'Upozorenje: $1',
	'validator-error' => 'Greška: $1',
	'validator-fatal-error' => 'Fatalna greška: $1',
	'validator_error_parameters' => 'U Vašoj sintaksi {{PLURAL:$1|je|su}} {{PLURAL:$1|otkivena slijedeća greška|otkrivene slijedeće greške}}:',
	'validator_warning_parameters' => '{{PLURAL:$1|Postoji greška|Postoje greške}} u Vašoj sintaksi.',
	'validator-warning-adittional-errors' => '... i {{PLURAL:$1|još jedan problem|još nekoliko problema}}.',
	'validator_error_unknown_argument' => '$1 nije valjan parametar.',
	'validator_error_required_missing' => 'Obavezni parametar $1 nije naveden.',
	'validator-error-override-argument' => 'Pokušano da se preskoči parametar $1 (vrijednost: $2) vrijednošću "$3"',
	'validator-listerrors-normal' => 'Normalno',
	'validator_error_empty_argument' => 'Parametar $1 ne može imati praznu vrijednost.',
	'validator_error_must_be_number' => 'Parametar $1 može biti samo broj.',
	'validator_error_must_be_integer' => 'Parametar $1 može biti samo cijeli broj.',
	'validator-error-must-be-float' => 'Parametar $1 može biti samo broj sa plutajućim zarezom.',
	'validator_error_invalid_range' => 'Parametar $1 mora biti između $2 i $3.',
	'validator-error-invalid-length' => 'Parametar $1 mora imati dužinu $2.',
	'validator-error-invalid-length-range' => 'Parametar $1 mora imati dužinu između $2 i $3.',
	'validator_error_invalid_argument' => 'Vrijednost $1 nije valjana za parametar $2.',
	'validator_list_error_empty_argument' => 'Parametar $1 ne prima prazne vrijednosti.',
	'validator_list_error_must_be_number' => 'Parametar $1 može sadržavati samo brojeve.',
	'validator_list_error_must_be_integer' => 'Parametar $1 može sadržavati samo cijele brojeve.',
	'validator_list_error_invalid_range' => 'Sve vrijednosti parametra $1 moraju biti između $2 i $3.',
	'validator_list_error_invalid_argument' => 'Jedna ili više vrijednosti za parametar $1 nisu valjane.',
	'validator_error_accepts_only' => 'Vrijednost "$4" nije valjana za parametar $1. On prihvata samo {{PLURAL:$3|ovu vrijednost|ove vrijednosti}}: $2.',
	'validator_list_omitted' => '{{PLURAL:$2|Vrijednost|Vrijednosti}} $1 {{PLURAL:$2|je ispuštena|su ispuštene}}.',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 * @author Mormegil
 * @author Reaperman
 */
$messages['cs'] = array(
	'validator-desc' => 'Validátor poskytuje ostatním rozšířením snadnější způsob ověřování parametrů funkcí parseru a značek, nastavování výchozích hodnot a vytváření chybových zpráv.',
	'validator_error_parameters' => 'Ve vaší syntaxi {{PLURAL:$1|byla nalezena následující chyba|byly nalezeny následující chyby}}:',
	'validator_warning_parameters' => 'Ve vaší syntaxi {{PLURAL:$1|je chyba|jsou chyby}}.',
	'validator_error_unknown_argument' => '$1 není platný parametr.',
	'validator_error_required_missing' => 'Povinný parameter $1 nebyl specifikován.',
	'validator_error_empty_argument' => 'Parametr $1 nemůže být prázdný.',
	'validator_error_must_be_number' => 'Parametr $1 může být pouze číslo.',
	'validator_error_must_be_integer' => 'Parametr $1 může být pouze celé číslo.',
	'validator_error_invalid_range' => 'Parametr $1 musí být v rozmezí $2 až $3.',
	'validator_error_invalid_argument' => '$1 není platná hodnota pro parametr $2.',
	'validator_list_error_empty_argument' => 'Parametr $1 npeřijímá prázdné hoodnoty.',
	'validator_list_error_must_be_number' => 'Parametr $1 může obsahovat pouze čísla.',
	'validator_list_error_must_be_integer' => 'Paramter $1 může obsahovat pouze celá čísla.',
	'validator_list_error_invalid_range' => 'Všechny hodnoty parametru $1 musí být v rozmezí $2 až $3.',
	'validator_list_error_invalid_argument' => 'Jedna nebo více hodnot parametru $1 jsou neplatné.',
	'validator_list_omitted' => '{{PLURAL:$2|Hodnota $1 byla vynechána|Hodnoty $1 byly vynechány}}.',
	'validator_error_accepts_only' => 'Parametr $1 nemůže mít hodnotu „$4“; přijímá pouze {{PLURAL:$3|tuto hodnotu|tyto hodnoty}}: $2.',
);

/** German (Deutsch)
 * @author DaSch
 * @author Imre
 * @author Kghbln
 * @author LWChris
 */
$messages['de'] = array(
	'validator-desc' => 'Ermöglicht es anderen Softwareerweiterungen Parameter verarbeiten zu können',
	'validator-warning' => 'Warnung: $1',
	'validator-error' => 'Fehler: $1',
	'validator-fatal-error' => "'''Schwerwiegender Fehler:''' $1",
	'validator_error_parameters' => '{{PLURAL:$1|Der folgende Fehler wurde|Die folgenden Fehler wurden}} in der Syntax gefunden:',
	'validator_warning_parameters' => '{{PLURAL:$1|Es ist ein Fehler|Es sind Fehler}} in der Syntax.',
	'validator-warning-adittional-errors' => '… und {{PLURAL:$1|ein weiteres Problem|weitere Probleme}}.',
	'validator-error-omitted' => '{{PLURAL:$2|Der Wert|Die Werte}} „$1“ {{PLURAL:$2|wurde|wurden}} ausgelassen.',
	'validator-error-problem' => 'Es gab ein Problem mit Parameter $1.',
	'validator_error_unknown_argument' => '$1 ist kein gültiger Parameter.',
	'validator_error_required_missing' => 'Der notwendige Parameter $1 wurde nicht angegeben.',
	'validator-error-override-argument' => 'Es wurde versucht Parameter $1 ($2) mit dem Wert „$3“ zu überschreiben.',
	'validator-listerrors-errors' => 'Fehler',
	'validator-listerrors-minor' => 'Marginal',
	'validator-listerrors-low' => 'Klein',
	'validator-listerrors-normal' => 'Normal',
	'validator-listerrors-high' => 'Groß',
	'validator-listerrors-fatal' => 'Schwerwiegend',
	'validator_error_empty_argument' => 'Parameter $1 kann keinen leeren Wert haben.',
	'validator_error_must_be_number' => 'Parameter $1 kann nur eine Nummer sein.',
	'validator_error_must_be_integer' => 'Parameter $1 kann nur eine ganze Zahl sein.',
	'validator-error-must-be-float' => 'Parameter $1 kann nur eine Gleitkommazahl sein.',
	'validator_error_invalid_range' => 'Parameter $1 muss zwischen $2 und $3 liegen.',
	'validator-error-invalid-regex' => 'Parameter $1 muss diesem regulären Ausdruck entsprechen: $2.',
	'validator-error-invalid-length' => 'Parameter $1 muss eine Länge von $2 haben.',
	'validator-error-invalid-length-range' => 'Parameter $1 muss eine Länge zwischen $2 und $3 haben.',
	'validator_error_invalid_argument' => 'Der Wert „$1“ ist nicht gültig für Parameter $2.',
	'validator_list_error_empty_argument' => 'Parameter $1 akzeptiert keine leeren Werte.',
	'validator_list_error_must_be_number' => 'Parameter $1 kann nur Ziffern enthalten.',
	'validator_list_error_must_be_integer' => 'Parameter $1 kann nur ganze Zahlen enthalten.',
	'validator-list-error-must-be-float' => 'Parameter $1 kann nur Gleitkommazahlen enthalten.',
	'validator_list_error_invalid_range' => 'Alle Werte des Parameters $1 müssen zwischen „$2“ und „$3“ liegen.',
	'validator-list-error-invalid-regex' => 'Alle Werte des Parameters $1 müssen diesem regulären Ausdruck entsprechen: $2.',
	'validator_list_error_invalid_argument' => 'Einer oder mehrere Werte für Parameter $1 sind ungültig.',
	'validator-list-error-accepts-only' => 'Einer oder mehrere Werte für Parameter $1 sind ungültig.
Nur {{PLURAL:$3|der folgende Wert wird|die folgenden Werte werden}} akzeptiert: $2.',
	'validator-list-error-accepts-only-omitted' => 'Einer oder mehrere Werte für Parameter $1 sind ungültig.
Nur {{PLURAL:$3|der folgende Wert wird|die folgenden Werte werden}} akzeptiert: $2 (sowie $4 ausgelassene {{PLURAL:$4|Wert|Werte}}).',
	'validator_error_accepts_only' => 'Der Wert „$4“ ist nicht gültig für Parameter $1.
Nur {{PLURAL:$3|der folgende Wert wird|die folgenden Werte werden}} akzeptiert: $2.',
	'validator-error-accepts-only-omitted' => 'Der Wert „$2“ ist nicht gültig für Parameter $1.
Nur {{PLURAL:$5|der folgende Wert wird|die folgenden Werte werden}} akzeptiert: $3 (sowie $4 ausgelassene {{PLURAL:$4|Wert|Werte}}).',
	'validator_list_omitted' => '{{PLURAL:$2|Der Wert|Die Werte}} $1 {{PLURAL:$2|wurde|wurden}} ausgelassen.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'validator-desc' => 'Validator stoj lažki nałog za druge rozšyrjenja k dispoziciji, aby se pśekontrolěrowali parametry parserowych funkcijow a toflickich rozšyrjenjow, nastajili standardne gódnoty a napórali zmólkowe powěsći',
	'validator_error_parameters' => '{{PLURAL:$1|Slědujuca zmólka jo se namakała|Slědujucej zmólce stej se namakałej|Slědujuce zmólki su se namakali|Slědujuce zmólki su se namakali}} w twójej syntaksy:',
	'validator_warning_parameters' => '{{PLURAL:$1|Jo zmólka|Stej zmólce|Su zmólki|Su zmólki}} w twójej syntaksy.',
	'validator_error_unknown_argument' => '$1 njejo płaśiwy parameter.',
	'validator_error_required_missing' => 'Trěbny parameter $1 njejo pódany.',
	'validator_error_empty_argument' => 'Parameter $1 njamóžo proznu gódnotu měś.',
	'validator_error_must_be_number' => 'Parameter $1 móžo jano licba byś.',
	'validator_error_must_be_integer' => 'Parameter $1 móžo jano ceła licba byś.',
	'validator_error_invalid_range' => 'Parameter $1 musy mjazy $2 a $3 byś.',
	'validator_error_invalid_argument' => 'Gódnota $1 njejo płaśiwa za parameter $2.',
	'validator_list_error_empty_argument' => 'Parameter $1 njeakceptěrujo prozne gódnoty.',
	'validator_list_error_must_be_number' => 'Parameter $1 móžo jano licby wopśimjeś.',
	'validator_list_error_must_be_integer' => 'Parameter $1 móžo jano cełe licby wopśimjeś.',
	'validator_list_error_invalid_range' => 'Wšykne gódnoty parametra $1 muse mjazy $2 a $3 byś.',
	'validator_list_error_invalid_argument' => 'Jadna gódnota abo wěcej gódnotow za parameter $1 su njepłaśiwe.',
	'validator_list_omitted' => '{{PLURAL:$2|Gódnota|Gódnośe|Gódnoty|Gódnoty}} $1 {{PLURAL:$2|jo se wuwóstajiła|stej se wuwóstajiłej|su se wuwóstajili|su se wuwostajili}}.',
	'validator_error_accepts_only' => 'Parameter $1 akceptěrujo jano {{PLURAL:$3|toś tu gódnotu|toś tej gódnośe|toś te gódnoty|toś te gódnoty}}: $2.',
);

/** Greek (Ελληνικά)
 * @author Dada
 * @author Lou
 * @author ZaDiak
 * @author Απεργός
 */
$messages['el'] = array(
	'validator_error_unknown_argument' => '$1 δεν είναι μια έγκυρη παράμετρος.',
	'validator_error_required_missing' => 'Λείπει η απαιτούμενη παράμετρος $1.',
	'validator_error_must_be_number' => 'Η παράμετρος $1 μπορεί να είναι μόνο αριθμός.',
	'validator_error_must_be_integer' => 'Η παράμετρος $1 μπορεί να είναι μόνο ακέραιος αριθμός.',
	'validator_list_error_must_be_number' => 'Η παράμετρος $1 μπορεί να περιέχει μόνο αριθμούς.',
	'validator_list_error_must_be_integer' => 'Η παράμετρος $1 μπορεί να περιέχει μόνο ακέραιους αριθμούς.',
	'validator_list_error_invalid_range' => 'Όλες οι τιμές της παραμέτρου $1 πρέπει να είναι μεταξύ $2 και $3.',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'validator_error_unknown_argument' => '$1 ne estas valida parametro.',
	'validator_error_required_missing' => 'La nepra parametro $1 mankas.',
	'validator_error_empty_argument' => 'Parametro $1 ne povas esti nula valoro.',
	'validator_error_must_be_number' => 'Parametro $1 nur povas esti numero.',
	'validator_error_must_be_integer' => 'Parametro $1 nur povas esti entjero.',
	'validator_error_invalid_range' => 'Parametro $1 estu inter $2 kaj $3.',
	'validator_list_error_invalid_argument' => 'Unu aŭ pliaj valoroj por parametro $1 estas malvalida.',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Imre
 * @author Translationista
 */
$messages['es'] = array(
	'validator-desc' => 'FUZZY!!! El validador es una herramienta para que otras funciones validen fácilmente parámetros de funciones de análisis y extensiones de etiquetas, establecer valores predeterminados y generar mensajes de error',
	'validator-warning' => 'Advertencia: $1',
	'validator-error' => 'Error: $1',
	'validator-fatal-error' => 'Error fatal: $1',
	'validator_error_parameters' => 'Se detectó {{PLURAL:$1|el siguiente error|los siguientes errores}} en la sintaxis empleada:',
	'validator_warning_parameters' => 'Hay {{PLURAL:$1|un error|errores}} en tu sintaxis.',
	'validator-warning-adittional-errors' => '...y {{PLURAL:$1|otro problema|muchos otros problemas}}.',
	'validator-error-omitted' => '{{PLURAL:$2|el valor "$1" ha sido  omitido|los valores "$1" han sido omitidos}}.',
	'validator-error-problem' => 'Ha habido un problema con el parámetro $1.',
	'validator_error_unknown_argument' => '$1 no es un parámetro válido.',
	'validator_error_required_missing' => 'No se ha provisto el parámetro requerido $1.',
	'validator-error-override-argument' => 'Se ha intentado sobreescribir el parámetro $1 (valor: $2) con el valor "$3"',
	'validator-listerrors-errors' => 'Errores',
	'validator-listerrors-minor' => 'Menor',
	'validator-listerrors-low' => 'Bajo',
	'validator-listerrors-normal' => 'Normal',
	'validator-listerrors-high' => 'Alto',
	'validator-listerrors-fatal' => 'Fatal',
	'validator_error_empty_argument' => 'El parámetro $1 no puede tener un valor vacío.',
	'validator_error_must_be_number' => 'El parámetro $1 sólo puede ser un número.',
	'validator_error_must_be_integer' => 'El parámetro $1 sólo puede ser un número entero.',
	'validator-error-must-be-float' => 'El parámetro $1 tiene que ser un número de punto flotante.',
	'validator_error_invalid_range' => 'El parámetro $1 debe ser entre $2 y $3.',
	'validator-error-invalid-regex' => 'El parámetro $1 tiene que coincidir con esta expresión racional : $2.',
	'validator-error-invalid-length' => 'El parámetro $1 tiene que tener una longitud de $2.',
	'validator-error-invalid-length-range' => 'El parámetro $1 tiene que tener una longitud comprendida entre $2 y $3.',
	'validator_error_invalid_argument' => 'El valor $1 no es válido para el parámetro $2.',
	'validator_list_error_empty_argument' => 'El parámetro $1 no acepta valores vacíos.',
	'validator_list_error_must_be_number' => 'El parámetro $1 sólo puede contener números.',
	'validator_list_error_must_be_integer' => 'El parámetro $1 sólo puede contener números enteros.',
	'validator-list-error-must-be-float' => 'El parámetro $1 sólo puede contener floats.',
	'validator_list_error_invalid_range' => 'Todos los valores del parámetro $1 deben ser entre $2 y $3.',
	'validator-list-error-invalid-regex' => 'El parámetro $1 tiene que coincidir con esta expresión regular: $2.',
	'validator_list_error_invalid_argument' => 'Uno o más valores del parámetros $1 son inválidos.',
	'validator-list-error-accepts-only' => 'Uno o más valores para el parámetro $1 son inválidos. 
Sólo acepta{{PLURAL:$3|este valor| estos valores}}: $2.',
	'validator-list-error-accepts-only-omitted' => 'Uno o más valores para el parámetro $1 son inválidos. 
Sólo acepta {{PLURAL:$3|este valor|estos valores}}: $2 (y $4 {{PLURAL:$4|valor omitido|valores omitidos}}).',
	'validator_error_accepts_only' => 'El valor "$4" no es válido para el parámetro $1. El parámetro sólo acepta {{PLURAL:$3|este valor|estos valores}}: $2.',
	'validator-error-accepts-only-omitted' => 'El valor $2 no es válido para el parámetro $1.
Sólo acepta {{PLURAL:$5|este valor|estos valores}}: $3 (y $4 {{PLURAL:$4|valor omitido|valores omitidos}}).',
	'validator_list_omitted' => '{{PLURAL:$2|El valor|Los valores}} $1 {{PLURAL:$2|ha sido omitido|han sido omitidos}}.',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Silvonen
 * @author Str4nd
 */
$messages['fi'] = array(
	'validator-desc' => 'Tarkastaja tarjoaa helpon tavan muille laajennuksille jäsenninfunktioiden ja tagilaajennusten parametrien tarkastukseen, oletusarvojen asettamiseen ja virheilmoitusten luomiseen.',
	'validator_error_must_be_number' => 'Parametrin $1 on oltava luku.',
	'validator_error_must_be_integer' => 'Parametrin $1 on oltava kokonaisluku.',
);

/** French (Français)
 * @author Cedric31
 * @author Crochet.david
 * @author IAlex
 * @author Jean-Frédéric
 * @author McDutchie
 * @author Peter17
 * @author PieRRoMaN
 * @author Sherbrooke
 * @author Urhixidur
 * @author Verdy p
 */
$messages['fr'] = array(
	'validator-desc' => 'Le validateur fournit aux autres extensions un moyen simple de valider les paramètres des fonctions parseur et des extensions de balises, de définir des valeurs par défaut et de générer des messages d’erreur',
	'validator-warning' => 'Attention : $1',
	'validator-error' => 'Erreur : $1',
	'validator-fatal-error' => 'Erreur fatale : $1',
	'validator_error_parameters' => '{{PLURAL:$1|L’erreur suivante a été détectée|Les erreurs suivantes ont été détectées}} dans votre syntaxe :',
	'validator_warning_parameters' => 'Il y a {{PLURAL:$1|une erreur|des erreurs}} dans votre syntaxe.',
	'validator-warning-adittional-errors' => '... et {{PLURAL:$1|un problème supplémentaire|plusieurs autres problèmes}}.',
	'validator-error-omitted' => '{{PLURAL:$2|La valeur « $1 » a été oubliée|Les valeurs « $1 » ont été oubliées}}.',
	'validator-error-problem' => 'Il y avait un problème avec le paramètre $1.',
	'validator_error_unknown_argument' => '$1 n’est pas un paramètre valide.',
	'validator_error_required_missing' => 'Le paramètre requis $1 n’est pas fourni.',
	'validator-error-override-argument' => 'Le logiciel a essayé de remplacer le paramètre $1 (valeur : $2) avec la valeur « $3 »',
	'validator-listerrors-errors' => 'Erreurs',
	'validator-listerrors-minor' => 'Mineur',
	'validator-listerrors-low' => 'Faible',
	'validator-listerrors-normal' => 'Normal',
	'validator-listerrors-high' => 'Élevé',
	'validator-listerrors-fatal' => 'Fatal',
	'validator_error_empty_argument' => 'Le paramètre $1 ne peut pas avoir une valeur vide.',
	'validator_error_must_be_number' => 'Le paramètre $1 peut être uniquement un nombre.',
	'validator_error_must_be_integer' => 'Le paramètre $1 peut seulement être un entier.',
	'validator-error-must-be-float' => 'Le paramètre $1 doit être un nombre à virgule flottante.',
	'validator_error_invalid_range' => 'Le paramètre $1 doit être entre $2 et $3.',
	'validator-error-invalid-regex' => 'Le paramètre $1 doit vérifier cette expression rationnelle : « $2 ».',
	'validator-error-invalid-length' => 'Le paramètre $1 doit avoir une longueur de $2.',
	'validator-error-invalid-length-range' => 'Le paramètre $1 doit avoir une longueur comprise entre $2 et $3.',
	'validator_error_invalid_argument' => 'La valeur $1 n’est pas valide pour le paramètre $2.',
	'validator_list_error_empty_argument' => 'Le paramètre $1 n’accepte pas les valeurs vides.',
	'validator_list_error_must_be_number' => 'Le paramètre $1 ne peut contenir que des nombres.',
	'validator_list_error_must_be_integer' => 'Le paramètre $1 ne peut contenir que des entiers.',
	'validator-list-error-must-be-float' => 'Le paramètre $1 ne peut contenir que des nombres à virgule.',
	'validator_list_error_invalid_range' => 'Toutes les valeurs du paramètre $1 doivent être comprises entre $2 et $3.',
	'validator-list-error-invalid-regex' => 'Toutes les valeurs du paramètre $1 doivent vérifier cette expression rationnelle : « $2 ».',
	'validator_list_error_invalid_argument' => 'Une ou plusieurs valeurs du paramètre $1 sont invalides.',
	'validator-list-error-accepts-only' => 'Une ou plusieurs valeur(s) du paramètre $1 est(sont) invalide(s).
Il n’accepte que {{PLURAL:$3|cette valeur|ces valeurs}} : $2.',
	'validator-list-error-accepts-only-omitted' => 'Une ou plusieurs valeur(s) du paramètre $1 est(sont) invalide(s).
Celui-ci n’accepte que {{PLURAL:$3|cette valeur|ces valeurs}} : $2 (et $4 {{PLURAL:$4|valeur omise|valeurs omises}}).',
	'validator_error_accepts_only' => "La valeur « $4 » n'est pas valable pour le paramètre $1. Il accepte uniquement {{PLURAL:$3|cette valeur|ces valeurs}} : $2.",
	'validator-error-accepts-only-omitted' => 'La valeur « $2 » n’est pas valable pour le paramètre $1.
Celui-ci n’accepte que {{PLURAL:$5|cette valeur|ces valeurs}} : $3 (et $4 {{PLURAL:$4|valeur omise|valeurs omises}}).',
	'validator_list_omitted' => '{{PLURAL:$2|La valeur|Les valeurs}} $1 {{PLURAL:$2|a été oubliée|ont été oubliées}}.',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'validator_error_parameters' => '{{PLURAL:$1|Ceta èrror at étâ dècelâ|Cetes èrrors ont étâ dècelâs}} dens voutra sintaxa :',
	'validator_warning_parameters' => 'Y at {{PLURAL:$1|una èrror|des èrrors}} dens voutra sintaxa.',
	'validator_error_unknown_argument' => '$1 est pas un paramètre valido.',
	'validator_error_required_missing' => 'Lo paramètre nècèssèro $1 est pas balyê.',
	'validator_error_empty_argument' => 'Lo paramètre $1 pôt pas avêr una valor voueda.',
	'validator_error_must_be_number' => 'Lo paramètre $1 pôt étre ren qu’un nombro.',
	'validator_error_must_be_integer' => 'Lo paramètre $1 pôt étre ren qu’un entiér.',
	'validator_error_invalid_range' => 'Lo paramètre $1 dêt étre entre-mié $2 et $3.',
	'validator_error_invalid_argument' => 'La valor $1 est pas valida por lo paramètre $2.',
	'validator_list_error_empty_argument' => 'Lo paramètre $1 accèpte pas les valors vouedes.',
	'validator_list_error_must_be_number' => 'Lo paramètre $1 pôt contegnir ren que des nombros.',
	'validator_list_error_must_be_integer' => 'Lo paramètre $1 pôt contegnir ren que des entiérs.',
	'validator_list_error_invalid_range' => 'Totes les valors du paramètre $1 dêvont étre entre-mié $2 et $3.',
	'validator_list_error_invalid_argument' => 'Yona ou ben un mouél de valors du paramètre $1 sont envalides.',
	'validator_list_omitted' => '{{PLURAL:$2|La valor|Les valors}} $1 {{PLURAL:$2|at étâ oubliâ|ont étâ oubliâs}}.',
	'validator_error_accepts_only' => 'La valor « $4 » est pas valida por lo paramètre $1. Accèpte ren que {{PLURAL:$3|ceta valor|cetes valors}} : $2.',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'validator-desc' => 'O servizo de validación ofrece un medio sinxelo a outras extensións para validar os parámetros de funcións analíticas e etiquetas de extensións, para establecer os valores por defecto e para xerar mensaxes de erro',
	'validator-warning' => 'Atención: $1',
	'validator-error' => 'Erro: $1',
	'validator-fatal-error' => 'Erro fatal: $1',
	'validator_error_parameters' => '{{PLURAL:$1|Detectouse o seguinte erro|Detectáronse os seguintes erros}} na sintaxe empregada:',
	'validator_warning_parameters' => 'Hai {{PLURAL:$1|un erro|erros}} na súa sintaxe.',
	'validator-warning-adittional-errors' => '... e {{PLURAL:$1|un problema máis|moitos máis problemas}}.',
	'validator-error-omitted' => '{{PLURAL:$2|Omitiuse o valor "$1"|Omitíronse os valores "$1"}}.',
	'validator-error-problem' => 'Houbo un problema co parámetro $1.',
	'validator_error_unknown_argument' => '"$1" non é un parámetro válido.',
	'validator_error_required_missing' => 'Non se proporcionou o parámetro $1 necesario.',
	'validator-error-override-argument' => 'Intentouse sobrescribir o parámetro $1 (valor: $2) co valor "$3"',
	'validator-listerrors-errors' => 'Erros',
	'validator-listerrors-minor' => 'Menor',
	'validator-listerrors-low' => 'Baixo',
	'validator-listerrors-normal' => 'Normal',
	'validator-listerrors-high' => 'Alto',
	'validator-listerrors-fatal' => 'Fatal',
	'validator_error_empty_argument' => 'O parámetro $1 non pode ter un valor baleiro.',
	'validator_error_must_be_number' => 'O parámetro $1 só pode ser un número.',
	'validator_error_must_be_integer' => 'O parámetro $1 só pode ser un número enteiro.',
	'validator-error-must-be-float' => 'O parámetro $1 só pode ser un número de coma flotante.',
	'validator_error_invalid_range' => 'O parámetro $1 debe estar entre $2 e $3.',
	'validator-error-invalid-regex' => 'O parámetro $1 debe coincidir con esta expresión regular: $2.',
	'validator-error-invalid-length' => 'O parámetro $1 debe ter unha lonxitude de $2.',
	'validator-error-invalid-length-range' => 'O parámetro $1 ter unha lonxitude de entre $2 e $3.',
	'validator_error_invalid_argument' => 'O valor $1 non é válido para o parámetro $2.',
	'validator_list_error_empty_argument' => 'O parámetro $1 non acepta valores en branco.',
	'validator_list_error_must_be_number' => 'O parámetro $1 só pode conter números.',
	'validator_list_error_must_be_integer' => 'O parámetro $1 só pode conter números enteiros.',
	'validator-list-error-must-be-float' => 'O parámetro $1 só pode conter comas flotantes.',
	'validator_list_error_invalid_range' => 'Todos os valores do parámetro $1 deben estar comprendidos entre $2 e $3.',
	'validator-list-error-invalid-regex' => 'Todos os valores do parámetro $1 deben coincidir con esta expresión regular: $2.',
	'validator_list_error_invalid_argument' => 'Un ou varios valores do parámetro $1 non son válidos.',
	'validator-list-error-accepts-only' => 'Un ou varios valores do parámetro $1 non son válidos.
Só acepta {{PLURAL:$3|este valor|estes valores}}: $2.',
	'validator-list-error-accepts-only-omitted' => 'Un ou varios valores do parámetro $1 non son válidos.
Só acepta {{PLURAL:$3|este valor|estes valores}}: $2 (e $4 {{PLURAL:$4|valor omitido|valores omitidos}}).',
	'validator_error_accepts_only' => 'O valor "$4" non é válido para o parámetro "$1". Só acepta {{PLURAL:$3|este valor|estes valores}}: $2.',
	'validator-error-accepts-only-omitted' => 'O valor "$2" non é válido para o parámetro $1.
Só acepta {{PLURAL:$5|este valor|estes valores}}: $3 (e $4 {{PLURAL:$4|valor omitido|valores omitidos}}).',
	'validator_list_omitted' => '{{PLURAL:$2|O valor|Os valores}} $1 {{PLURAL:$2|foi omitido|foron omitidos}}.',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'validator-desc' => 'Validator stellt e eifachi Form z Verfiegig fir anderi Erwyterige go Parameter validiere vu Parser- un Tag-Funktione, go Standardwärt definiere un Fählermäldige generiere',
	'validator-warning' => 'Warnig: $1',
	'validator-error' => 'Fähler: $1',
	'validator-fatal-error' => 'Fähler, wu nit cha behobe wäre: $1',
	'validator_error_parameters' => '{{PLURAL:$1|Dää Fähler isch|Die Fähler sin}} in Dyyre Syntax gfunde wore:',
	'validator_warning_parameters' => 'S het {{PLURAL:$1|e Fähler|Fähler}} in dyyre Syntax.',
	'validator-warning-adittional-errors' => '... un {{PLURAL:$1|e ander Probläm|$1 anderi Probläm}}.',
	'validator-error-omitted' => '{{PLURAL:$2|Dr Wärt|D Wärt}} „$1“ {{PLURAL:$2|isch|sin}} uusgloo wore.',
	'validator-error-problem' => 'S het e Probläm gee mit em Parameter $1.',
	'validator_error_unknown_argument' => '$1 isch kei giltige Parameter.',
	'validator_error_required_missing' => 'Dr Paramter $1, wu aagforderet woren isch, wird nit z Verfiegig gstellt.',
	'validator-error-override-argument' => 'S isch versuecht wore, dr Parameter $1 (Wärt: $2) mit em Wärt „$3“ z iberschryybe',
	'validator-listerrors-errors' => 'Fähler',
	'validator-listerrors-minor' => 'Gring',
	'validator-listerrors-low' => 'Chlei',
	'validator-listerrors-normal' => 'Normal',
	'validator-listerrors-high' => 'Groß',
	'validator-listerrors-fatal' => 'Schwär',
	'validator_error_empty_argument' => 'Dr Parameter $1 cha kei lääre Wärt haa.',
	'validator_error_must_be_number' => 'Dr Parameter $1 cha nume ne Zahl syy.',
	'validator_error_must_be_integer' => 'Parameter $1 cha nume ne giltigi Zahl syy.',
	'validator-error-must-be-float' => 'Parameter $1 cha nume ne Gleitkommazahl syy.',
	'validator_error_invalid_range' => 'Dr Parameter $1 muess zwische $2 un $3 syy.',
	'validator-error-invalid-regex' => 'Parameter $1 mueß däm reguläre Uusdruck entspräche: $2.',
	'validator-error-invalid-length' => 'Parameter $1 mueß e Lengi haa vu $2.',
	'validator-error-invalid-length-range' => 'Parameter $1 mueß e Lengi haa zwische $2 un $3.',
	'validator_error_invalid_argument' => 'Dr Wärt $1 isch nit giltig fir dr Parameter $2.',
	'validator_list_error_empty_argument' => 'Bim Parameter $1 sin keini lääre Wärt zuegloo.',
	'validator_list_error_must_be_number' => 'Fir dr Parameter $1 si nume Zahle zuegloo.',
	'validator_list_error_must_be_integer' => 'Fir dr Parameter $1 sin nume ganzi Zahle zuegloo.',
	'validator-list-error-must-be-float' => 'Im Parameter $1 cha s nume Gleitkommazahle haa.',
	'validator_list_error_invalid_range' => 'Alli Wärt fir dr Parameter $1 mien zwische $2 un $3 lige.',
	'validator-list-error-invalid-regex' => 'Alli Wärt vum Parameter $1 mien däm reguläre Uusdruck entspräche: $2.',
	'validator_list_error_invalid_argument' => 'Ein oder mehreri Wärt fir dr Parameter $1 sin nit giltig.',
	'validator-list-error-accepts-only' => 'Ein oder meh Wärt fir dr Parameter $1 sin nit giltig.
Nume {{PLURAL:$3|dää Wärt wird|die Wärt wäre}} akzeptiert: $2.',
	'validator-list-error-accepts-only-omitted' => 'Ein oder meh Wärt fir dr Parameter $1 sin nit giltig.
Nume {{PLURAL:$3|dää Wärt wird|die Wärt wäre}} akzeptiert: $2 (un $4 uusglosseni {{PLURAL:$4|Wärt|Wärt}}).',
	'validator_error_accepts_only' => 'Dr Wärt „$4“ isch nit giltig fir dr Parameter $1. Nume {{PLURAL:$3|dää Wärt wird|die Wärt wäre}} akzeptiert: „$2“.',
	'validator-error-accepts-only-omitted' => 'Dr Wärt „$2“ isch nit giltig fir dr Parameter $1.
Nume {{PLURAL:$5|dää Wärt wird|die Wärt wäre}} akzeptiert: $3 (un $4 uusglosseni {{PLURAL:$4|Wärt|Wärt}}).',
	'validator_list_omitted' => '{{PLURAL:$2|Dr Wärt|D Wärt}} $1 {{PLURAL:$2|isch|sin}} uusgloo wore.',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'validator-fatal-error' => 'שגיאה חמורה: $1',
	'validator_warning_parameters' => '{{PLURAL:$1|ישנה שגיאה|ישנן שגיאות}} בתחביר שלכם.',
	'validator_error_unknown_argument' => '$1 אינו פרמטר תקני.',
	'validator_error_required_missing' => 'הפרמטר הדרוש $1 לא צוין.',
	'validator-listerrors-errors' => 'שגיאות',
	'validator_error_empty_argument' => 'הפרמטר $1 לא יכול להיות ערך ריק.',
	'validator_error_must_be_number' => 'הפרמטר $1 יכול להיות מספר בלבד.',
	'validator_error_must_be_integer' => 'הפרמטר $1 יכול להיות מספר שלם בלבד.',
	'validator_error_invalid_range' => 'הפרמטר $1 חייב להיות בין $2 ל־$3.',
	'validator_error_invalid_argument' => 'הערך $1 אינו תקני עבור הפרמטר $2.',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'validator-desc' => 'Validator skići lochke wašnje za druhe rozšěrjenja, zo bychu so parametry parserowych funkcijow a tafličkowych rozšěrjenjow přepruwowali, standardne hódnoty nastajili a zmylkowe powěsće wutworili',
	'validator_error_parameters' => '{{PLURAL:$1|Slědowacy zmylk bu|Slědowacej zmylkaj buštej|Slědowace zmylki buchu|Slědowace zmylki buchu}} w twojej syntaksy {{PLURAL:$1|wotkryty|wotkrytej|wotkryte|wotkryte}}:',
	'validator_warning_parameters' => '{{PLURAL:$1|Je zmylk|Stej zmylkaj|Su zmylki|Su zmylki}} w twojej syntaksy.',
	'validator_error_unknown_argument' => '$1 płaćiwy parameter njeje.',
	'validator_error_required_missing' => 'Trěbny parameter $1 njeje podaty.',
	'validator_error_empty_argument' => 'Parameter $1 njemóže prózdnu hódnotu měć.',
	'validator_error_must_be_number' => 'Parameter $1 móže jenož ličba być.',
	'validator_error_must_be_integer' => 'Parameter $1 móže jenož cyła ličba być.',
	'validator_error_invalid_range' => 'Parameter $1 dyrbi mjez $2 a $3 być.',
	'validator_error_invalid_argument' => 'Hódnota $1 njeje płaćiwa za parameter $2.',
	'validator_list_error_empty_argument' => 'Parameter $1 njeakceptuje prózdne hódnoty.',
	'validator_list_error_must_be_number' => 'Parameter $1 móže jenož ličby wobsahować.',
	'validator_list_error_must_be_integer' => 'Parameter $1 móže jenož cyłe ličby wobsahować.',
	'validator_list_error_invalid_range' => 'Wšě hódnoty parametra $1 dyrbja mjez $2 a $3 być.',
	'validator_list_error_invalid_argument' => 'Jedna hódnota abo wjace hódnotow za parameter $1 su njepłaćiwe.',
	'validator_list_omitted' => '{{PLURAL:$2|Hódnota|Hódnoće|Hódnoty|Hódnoty}} $1 {{PLURAL:$2|je so wuwostajiła|stej so wuwostajiłoj|su so wuwostajili|su so wuwostajili}}.',
	'validator_error_accepts_only' => 'Parameter $1 akceptuje jenož {{PLURAL:$3|tutu hódnotu|tutej hódnoće|tute hódnoty|tute hódnoty}}: $2.',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'validator-desc' => 'Az érvényesség-ellenőrző egyszerű lehetőséget nyújt más kiterjesztéseknek az elemzőfüggvények és tagek paramétereinek ellenőrzésére, alapértelmezett értékek beállítására, valamint hibaüzenetek generálására.',
	'validator-warning' => 'Figyelmeztetés: $1',
	'validator-error' => 'Hiba: $1',
	'validator-fatal-error' => 'Végzetes hiba: $1',
	'validator_error_parameters' => 'A következő {{PLURAL:$1|hiba található|hibák találhatóak}} a szintaxisban:',
	'validator_warning_parameters' => '{{PLURAL:$1|Hiba van|Hibák vannak}} a szintaxisodban.',
	'validator_error_unknown_argument' => 'A(z) $1 nem érvényes paraméter.',
	'validator_error_required_missing' => 'A(z) $1 kötelező paraméter nem lett megadva.',
	'validator-listerrors-errors' => 'Hibák',
	'validator-listerrors-minor' => 'Apró',
	'validator-listerrors-low' => 'Alacsony',
	'validator-listerrors-normal' => 'Normális',
	'validator-listerrors-high' => 'Komoly',
	'validator-listerrors-fatal' => 'Végzetes',
	'validator_error_empty_argument' => 'A(z) $1 paraméter értéke nem lehet üres.',
	'validator_error_must_be_number' => 'A(z) $1 paraméter csak szám lehet.',
	'validator_error_must_be_integer' => 'A(z) $1 paraméter csak egész szám lehet.',
	'validator-error-must-be-float' => 'A(z) $1 paraméter csak lebegőpontos szám lehet.',
	'validator_error_invalid_range' => 'A(z) $1 paraméter értékének $2 és $3 között kell lennie.',
	'validator-error-invalid-regex' => 'A(z) $1 paraméternek illeszkednie kell a következő reguláris kifejezésre: $2.',
	'validator-error-invalid-length' => 'A(z) $1 paraméternek legalább $2 karakter hosszúnak kell lennie.',
	'validator-error-invalid-length-range' => 'A(z) $1 paraméternek $2 és $3 karakter közötti hosszúnak kell lennie.',
	'validator_error_invalid_argument' => 'A(z) $1 érték nem érvényes a(z) $2 paraméterhez.',
	'validator_list_error_empty_argument' => 'A(z) $1 paraméter nem fogad el üres értékeket.',
	'validator_list_error_must_be_number' => 'A(z) $1 paraméter csak számokat tartalmazhat.',
	'validator_list_error_must_be_integer' => 'A(z) $1 paraméter csak egész számokat tartalmazhat.',
	'validator-list-error-must-be-float' => 'A(z) $1 paraméter csak lebegőpontos számokat tartalmazhat.',
	'validator_list_error_invalid_range' => 'A(z) $1 paraméter összes értékének $2 és $3 közöttinek kell lennie.',
	'validator_list_error_invalid_argument' => 'A(z) $1 paraméter egy vagy több értéke érvénytelen.',
	'validator_error_accepts_only' => 'A(z) $1 paraméter csak a következő {{PLURAL:$3|értéket|értékeket}} fogadja el: $2',
	'validator_list_omitted' => 'A(z) $1 {{PLURAL:$2|érték mellőzve lett.|értékek mellőzve lettek.}}',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'validator-desc' => 'Validator provide un modo facile a altere extensiones de validar parametros de functiones del analysator syntactic e extensiones de etiquettas, predefinir valores e generar messages de error',
	'validator-warning' => 'Aviso: $1',
	'validator-error' => 'Error: $1',
	'validator-fatal-error' => 'Error fatal: $1',
	'validator_error_parameters' => 'Le sequente {{PLURAL:$1|error|errores}} ha essite detegite in tu syntaxe:',
	'validator_warning_parameters' => 'Il ha {{PLURAL:$1|un error|errores}} in tu syntaxe.',
	'validator-warning-adittional-errors' => '... e {{PLURAL:$1|un altere problema|plure altere problemas}}.',
	'validator-error-omitted' => 'Le {{PLURAL:$2|valor|valores}} "$1" ha essite omittite.',
	'validator-error-problem' => 'Il habeva un problema con le parametro $1.',
	'validator_error_unknown_argument' => '$1 non es un parametro valide.',
	'validator_error_required_missing' => 'Le parametro requisite $1 non ha essite fornite.',
	'validator-error-override-argument' => 'Tentava supplantar le parametro $1 (valor: $2) con le valor "$3"',
	'validator-listerrors-errors' => 'Errores',
	'validator-listerrors-minor' => 'Minor',
	'validator-listerrors-low' => 'Basse',
	'validator-listerrors-normal' => 'Normal',
	'validator-listerrors-high' => 'Alte',
	'validator-listerrors-fatal' => 'Fatal',
	'validator_error_empty_argument' => 'Le parametro $1 non pote haber un valor vacue.',
	'validator_error_must_be_number' => 'Le parametro $1 pote solmente esser un numero.',
	'validator_error_must_be_integer' => 'Le parametro $1 pote solmente esser un numero integre.',
	'validator-error-must-be-float' => 'Le parametro $1 pote solmente esser un numero con fraction decimal.',
	'validator_error_invalid_range' => 'Le parametro $1 debe esser inter $2 e $3.',
	'validator-error-invalid-regex' => 'Le parametro $1 debe corresponder a iste expression regular: $2.',
	'validator-error-invalid-length' => 'Le parametro $1 debe haber un longitude de $2.',
	'validator-error-invalid-length-range' => 'Le parametro $1 debe haber un longitude inter $2 e $3.',
	'validator_error_invalid_argument' => 'Le valor $1 non es valide pro le parametro $2.',
	'validator_list_error_empty_argument' => 'Le parametro $1 non accepta valores vacue.',
	'validator_list_error_must_be_number' => 'Le parametro $1 pote solmente continer numeros.',
	'validator_list_error_must_be_integer' => 'Le parametro $1 pote solmente continer numeros integre.',
	'validator-list-error-must-be-float' => 'Le parametro $1 pote solmente continer numeros a comma flottante.',
	'validator_list_error_invalid_range' => 'Tote le valores del parametro $1 debe esser inter $2 e $3.',
	'validator-list-error-invalid-regex' => 'Tote le valores del parametro $1 debe corresponder a iste expression regular: $2.',
	'validator_list_error_invalid_argument' => 'Un o plus valores pro le parametro $1 es invalide.',
	'validator-list-error-accepts-only' => 'Un o plus valores del parametro $1 es invalide.
Illo accepta solmente iste {{PLURAL:$3|valor|valores}}: $2.',
	'validator-list-error-accepts-only-omitted' => 'Un o plus valores del parametro $1 es invalide.
Illo accepta solmente iste {{PLURAL:$3|valor|valores}}: $2. (e $4 {{PLURAL:$4|valor|valores}} omittite).',
	'validator_error_accepts_only' => 'Le valor "$4" non es valide pro le parametro $1. Illo accepta solmente iste {{PLURAL:$3|valor|valores}}: $2.',
	'validator-error-accepts-only-omitted' => 'Le valor "$2" non es valide pro le parametro $1.
Illo accepta solmente iste {{PLURAL:$5|valor|valores}}: $3 (e $4 {{PLURAL:$4|valor|valores}} omittite).',
	'validator_list_omitted' => 'Le {{PLURAL:$2|valor|valores}} $1 ha essite omittite.',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Farras
 * @author Irwangatot
 * @author IvanLanin
 */
$messages['id'] = array(
	'validator-desc' => 'Validator memberikan cara mudah untuk ekstensi lain untuk memvalidasi parameter ParserFunction dan ekstensi tag, mengatur nilai biasa dan membuat pesan kesalahan',
	'validator_error_parameters' => '{{PLURAL:$1|Kesalahan|Kesalahan}} berikut telah terdeteksi pada sintaksis Anda:',
	'validator_warning_parameters' => '{{PLURAL:$1|kesalahan|kesalahan}} ini  pada sintaks anda.',
	'validator_error_unknown_argument' => '$1 bukan parameter yang benar.',
	'validator_error_required_missing' => 'Parameter $1 yang diperlukan tidak diberikan.',
	'validator_error_empty_argument' => 'Parameter $1 tidak dapat bernilai kosong.',
	'validator_error_must_be_number' => 'Parameter $1 hanya dapat berupa angka.',
	'validator_error_must_be_integer' => 'Parameter $1 hanya dapat berupa integer.',
	'validator_error_invalid_range' => 'Parameter $1 harus antara $2 dan $3.',
	'validator_error_invalid_argument' => 'Nilai $1 tidak valid untuk parameter $2.',
	'validator_list_error_empty_argument' => 'Parameter $1 tidak menerima nilai kosong.',
	'validator_list_error_must_be_number' => 'Parameter $1 hanya dapat berisi angka.',
	'validator_list_error_must_be_integer' => 'Parameter $1 hanya dapat berisi bilangan bulat.',
	'validator_list_error_invalid_range' => 'Semua nilai parameter $1 harus antara $2 dan $3.',
	'validator_list_error_invalid_argument' => 'Satu nilai atau lebih untuk parameter $1 tidak sah.',
	'validator_list_omitted' => '{{PLURAL:$2|Nilai|Nilai}} $1 {{PLURAL:$2|telah|telah}} dihapus.',
	'validator_error_accepts_only' => 'Parameter $1 hanya menerima {{PLURAL:$3|nilai ini|nilai ini}}: $2.',
);

/** Italian (Italiano)
 * @author Civvì
 * @author HalphaZ
 */
$messages['it'] = array(
	'validator-desc' => 'Validator fornisce ad altre estensiono un modo semplice per la convalida dei parametri delle funzioni parser e dei tag introdotti, per impostare i valori di default e per generare messaggi di errore.',
	'validator_error_parameters' => 'Nella tua sintassi {{PLURAL:$1|è stato individuato il seguente errore|sono stati individuati i seguenti errori}}:',
	'validator_warning_parameters' => "Nella tua sintassi {{PLURAL:$1|c'è un errore|ci sono errori}}.",
	'validator_error_unknown_argument' => '$1 non è un parametro valido.',
	'validator_error_required_missing' => 'Il parametro richiesto $1 non è stato fornito.',
	'validator_error_empty_argument' => 'Il parametro $1 non può avere un valore vuoto.',
	'validator_error_must_be_number' => 'Il parametro $1 può essere solo un numero.',
	'validator_error_must_be_integer' => 'Il parametro $1 può essere solo un intero.',
	'validator_error_invalid_range' => 'Il parametro $1 deve essere compreso tra $2 e $3.',
	'validator_error_invalid_argument' => 'Il valore $1 non è valido per il parametro $2.',
	'validator_list_error_empty_argument' => 'Il parametro $1 non accetta valori vuoti.',
	'validator_list_error_must_be_number' => 'Il parametro $1 può contenere solo numeri.',
	'validator_list_error_must_be_integer' => 'Il parametro $1 può contenere solo numeri interi.',
	'validator_list_error_invalid_range' => 'Tutti i valori del parametro $1 devono essere compresi tra $2 e $3.',
	'validator_list_error_invalid_argument' => 'Uno o più valori del parametro $1 non sono validi.',
	'validator_list_omitted' => '{{PLURAL:$2|Il valore|I valori}} $1 {{PLURAL:$2|è stato omesso|sono stati omessi}}.',
	'validator_error_accepts_only' => 'Il parametro $1 accetta solo {{PLURAL:$3|questo valore|questi valori}}: $2.',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Marine-Blue
 * @author Whym
 * @author Yanajin66
 */
$messages['ja'] = array(
	'validator-desc' => '妥当性評価器は他の拡張機能にパーサー関数やタグ拡張の引数の妥当性を確認したり、規定値を設定したり、エラーメッセージを生成する手段を提供する',
	'validator-warning' => '警告: $1',
	'validator-error' => 'エラー： $1',
	'validator-fatal-error' => '致命的なエラー： $1',
	'validator_error_parameters' => 'あなたの入力から以下の{{PLURAL:$1|エラー|エラー}}が検出されました:',
	'validator_warning_parameters' => 'あなたの入力した構文には{{PLURAL:$1|エラー}}があります。',
	'validator-warning-adittional-errors' => '...と{{PLURAL:$1|他の問題}}。',
	'validator-error-omitted' => '{{PLURAL:$2|$1 個の値}}が省略されました。',
	'validator-error-problem' => 'パラメータ $1 に問題が見つかりました。',
	'validator_error_unknown_argument' => '$1 は有効な引数ではありません。',
	'validator_error_required_missing' => '必須の引数「$1」が入力されていません。',
	'validator-error-override-argument' => '値"$3"とともにパラメータ$1 (値: $2)を無視してみてください',
	'validator-listerrors-errors' => 'エラー',
	'validator-listerrors-minor' => '非常に軽度',
	'validator-listerrors-low' => '軽度',
	'validator-listerrors-normal' => '普通',
	'validator-listerrors-high' => '重大',
	'validator-listerrors-fatal' => '非常に重大',
	'validator_error_empty_argument' => '引数「$1」は空の値をとることができません。',
	'validator_error_must_be_number' => '引数「$1」は数値でなければなりません。',
	'validator_error_must_be_integer' => '引数「$1」は整数でなければなりません。',
	'validator-error-must-be-float' => 'パラメータ$1は浮動小数点数になることだけができます。',
	'validator_error_invalid_range' => '引数「$1」は $2 と $3 の間の値でなければなりません。',
	'validator-error-invalid-regex' => 'パラメータ $1 は次の正規表現と一致する必要があります： $2',
	'validator-error-invalid-length' => 'パラメータ$1は$2の長さを保持していなければならない。',
	'validator-error-invalid-length-range' => 'パラメータ$1は$2と$3間の長さを保持していなければならない。',
	'validator_error_invalid_argument' => '値「$1」は引数「$2」として妥当ではありません。',
	'validator_list_error_empty_argument' => '引数「$1」は空の値をとりません。',
	'validator_list_error_must_be_number' => '引数「$1」は数値しかとることができません。',
	'validator_list_error_must_be_integer' => '引数「$1」は整数値しかとることができません。',
	'validator-list-error-must-be-float' => 'パラメータ $1 は整数値しか利用できません。',
	'validator_list_error_invalid_range' => '引数「$1」の値はすべて $2 と $3 の間のものでなくてはなりません。',
	'validator-list-error-invalid-regex' => 'パラメータ $1 の値は次の正規表現と一致する必要があります： $2',
	'validator_list_error_invalid_argument' => '引数「$1」の値に不正なものが1つ以上あります。',
	'validator-list-error-accepts-only' => 'パラメータ $1 に無効な値が含まれています。
このパラメータは{{PLURAL:$3|次の値}}しか利用できません： $2',
	'validator-list-error-accepts-only-omitted' => 'パラメータ $1 に無効な値が含まれています。
このパラメータは{{PLURAL:$3|次の値}}しか利用できません： $2 （と省略された $4 の値）',
	'validator_error_accepts_only' => '値"$4"はパラメーター$1にとって有効ではありません。{{PLURAL:$3|この値|これらの値}}のみ受け入れられます。: $2。',
	'validator-error-accepts-only-omitted' => 'パラメータ $1 の値 "$2" は有効ではありません。
このパラメータは{{PLURAL:$5|次の値}}しか利用できません： $3 （と省略された $4 の値）',
	'validator_list_omitted' => '{{PLURAL:$2|値}} $1 は省かれました。',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'validator-desc' => '{{int:validator_name}} brängk eine eijfache Wääsch, der Parrammeetere fun Paaser-Fungkßjohne un Zohsatzprojramme ze prööve, Schtandatt-Wääte enzefööje, un Fähler ze mällde.',
	'validator_error_parameters' => '{{PLURAL:$1|Heh dä|Heh di|Keine}} Fähler {{PLURAL:$1|es|sin|es}} en Dinge Syntax opjevalle:',
	'validator_error_unknown_argument' => '„$1“ es keine jöltijje Parameeter.',
	'validator_error_required_missing' => 'Dä Parameeter $1 moß aanjejovve sin, un fählt.',
	'validator_error_empty_argument' => 'Dä Parameeter $1 kann keine Wäät met nix dren hann.',
	'validator_error_must_be_number' => 'Dä Parameeter $1 kann blohß en Zahl sin.',
	'validator_error_must_be_integer' => 'Dä Parrameeter $1 kann bloß en jannze Zahl sin.',
	'validator_error_invalid_range' => 'Dä Parameeter $1 moß zwesche $2 un $3 sin.',
	'validator_error_invalid_argument' => 'Däm Parameeter $2 singe Wäät es $1, dat es ävver doför nit jöltesch.',
	'validator_error_accepts_only' => '„$4“ es nit ze Bruche, weil dä Parameeter $1 {{PLURAL:$3|bloß eine Wäät|bloß eine vun heh dä Wääte|keine Wäät}} han kann: $2',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'validator-desc' => 'Validator erlaabt et op eng einfach Manéier fir Parametere vu Parser-Fonctiounen an Tag-Erweiderungen ze validéieren, fir Standard-Wäerter festzeleeën a fir Feeler-Messagen ze generéieren',
	'validator-warning' => 'Opgepasst: $1',
	'validator-error' => 'Feeler: $1',
	'validator-fatal-error' => 'Fatale Feeler: $1',
	'validator_error_parameters' => '{{PLURAL:$1|Dëse Feeler gouf|Dës Feeler goufen}} an Ärer Syntax fonnt:',
	'validator_warning_parameters' => 'Et {{PLURAL:$1|ass ee|si}} Feeler an Ärer Syntax.',
	'validator-error-omitted' => '{{PLURAL:$2|De Wäert|D\'Wäerter}} "$1" {{PLURAL:$2|gouf|goufe}} vergiess.',
	'validator-error-problem' => 'Et gouf e Problem mam Parameter $1.',
	'validator_error_unknown_argument' => '$1 ass kee valbele Parameter.',
	'validator_error_required_missing' => 'Den obligatoresche Parameter $1 war net derbäi.',
	'validator-error-override-argument' => 'huet versicht de Parameter $1 (Wäert: $2) mam Wäert "$3" z\'iwwerschreiwen',
	'validator-listerrors-errors' => 'Feeler',
	'validator-listerrors-minor' => 'Marginal',
	'validator-listerrors-low' => 'Niddreg',
	'validator-listerrors-normal' => 'Normal',
	'validator-listerrors-high' => 'Héich',
	'validator-listerrors-fatal' => 'Fatal',
	'validator_error_empty_argument' => 'De Parameter $1 ka keen eidele Wäert hunn.',
	'validator_error_must_be_number' => 'De Parameter $1 ka just eng Zuel sinn',
	'validator_error_must_be_integer' => 'De Parameter $1 ka just eng ganz Zuel sinn.',
	'validator-error-must-be-float' => 'Parameter $1 kann nëmmen eng Féisskommazuel sinn.',
	'validator_error_invalid_range' => 'De Parameter $1 muss tëschent $2 an $3 leien.',
	'validator-error-invalid-length' => 'Parameter $1 muss eng Längt vu(n) $2 hunn.',
	'validator-error-invalid-length-range' => 'De Parameter $1 muss eng Längt tëschent $2 an $3 hunn.',
	'validator_error_invalid_argument' => 'De Wäert $1 ass net valabel fir de Parameter $2.',
	'validator_list_error_empty_argument' => 'De Parameter $1 hëlt keng eidel Wäerter un.',
	'validator_list_error_must_be_number' => 'Am Parameter $1 kënnen nëmmen Zuelen dra sinn.',
	'validator_list_error_must_be_integer' => 'Am Parameter $1 kënnen nëmme ganz Zuele sinn.',
	'validator-list-error-must-be-float' => 'Am Parameter $1 kënnen nëmme Kommazuelen dra sinn.',
	'validator_list_error_invalid_range' => 'All Wäerter vum Parameter $1 mussen tëschent $2 an $3 leien.',
	'validator_list_error_invalid_argument' => 'Een oder méi Wäerter fir de Parameter $1 sinn net valabel.',
	'validator-list-error-accepts-only' => 'Een oder méi Wäerter vum Parameter $1 sinn net valabel.
En akzeptéiert nëmmen {{PLURAL:$3|dëse Wäert|dës Wäerter}}: $2.',
	'validator_error_accepts_only' => 'De Wäert $4 ass net valabel fir de Parameter $1. En akzeptéiert just {{PLURAL:$3|dëse Wäert|dës Wäerter}}: $2',
	'validator-error-accepts-only-omitted' => 'De Wäert "$2" ass net valabel fir de Parameter $1.
En akzeptéiert nëmmen {{PLURAL:$5|dëse Wäert|dës Wäerter}}: $3 (an {{PLURAL:$4|een ausgeloossene Wäert|$4 ausgeloosse Wäerter}}).',
	'validator_list_omitted' => "{{PLURAL:$2|De Wäert|D'Wäerter}} $1 {{PLURAL:$2|gouf|goufe}} vergiess.",
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author McDutchie
 */
$messages['mk'] = array(
	'validator-desc' => 'Потврдувачот овозможува лесен начин другите додатоци да ги потврдат параметрите на парсерските функции и додатоците со ознаки, да поставаат основно зададени вредности и да создаваат пораки за грешки',
	'validator-warning' => 'Предупредување: $1',
	'validator-error' => 'Грешка: $1',
	'validator-fatal-error' => 'Фатална грешка: $1',
	'validator_error_parameters' => 'Во вашата синтакса {{PLURAL:$1|е откриена следнава грешка|се откриени следниве грешки}}:',
	'validator_warning_parameters' => 'Имате {{PLURAL:$1|грешка|грешки}} во синтаксата.',
	'validator-warning-adittional-errors' => '... и {{PLURAL:$1|уште еден проблем|повеќе други проблеми}}.',
	'validator-error-omitted' => '{{PLURAL:$2|Изоставена е вредноста „$1“|Изоставени се вредностите „$1“}}.',
	'validator-error-problem' => 'Се појави проблем со параметарот $1.',
	'validator_error_unknown_argument' => '$1 не е важечки параметар.',
	'validator_error_required_missing' => 'Бараниот параметар $1 не е наведен.',
	'validator-error-override-argument' => 'Се обидовте да презапишете врз параметарот $1 (вредност: $2) со вредност „$3“',
	'validator-listerrors-errors' => 'Грешки',
	'validator-listerrors-minor' => 'Ситни',
	'validator-listerrors-low' => 'Малку',
	'validator-listerrors-normal' => 'Нормално',
	'validator-listerrors-high' => 'Многу',
	'validator-listerrors-fatal' => 'Фатални',
	'validator_error_empty_argument' => 'Параметарот $1 не може да има празна вредност.',
	'validator_error_must_be_number' => 'Параметарот $1 може да биде само број.',
	'validator_error_must_be_integer' => 'Параметарот $1 може да биде само цел број.',
	'validator-error-must-be-float' => 'Параметарот $1 може да биде само број со подвижна точка.',
	'validator_error_invalid_range' => 'Параметарот $1 мора да изнесува помеѓу $2 и $3.',
	'validator-error-invalid-regex' => 'Параметарот $1 мора да се совпаѓа со следниов регуларен израз: $2.',
	'validator-error-invalid-length' => 'Параметарот $1 мора да има должина од $2.',
	'validator-error-invalid-length-range' => 'Должината на параметарот параметарот $1 мора да изнесува помеѓу $2 и $3.',
	'validator_error_invalid_argument' => 'Вредноста $1 е неважечка за параметарот $2.',
	'validator_list_error_empty_argument' => 'Параметарот $1 не прифаќа празни вредности.',
	'validator_list_error_must_be_number' => 'Параметарот $1 може да содржи само бројки.',
	'validator_list_error_must_be_integer' => 'Параметарот $1 може да содржи само цели броеви.',
	'validator-list-error-must-be-float' => 'Параметарот $1 може да содржи само подвижни бинарни точки.',
	'validator_list_error_invalid_range' => 'Сите вредности на параметарот $1 мора да бидат помеѓу $2 и $3.',
	'validator-list-error-invalid-regex' => 'Сите вредности на параметарот $1 мора да се совпаднат со следниов регуларен израз: $2.',
	'validator_list_error_invalid_argument' => 'Една или повеќе вредности на параметарот $1 се неважечки.',
	'validator-list-error-accepts-only' => 'Параметарот $1 има една или повеќе неважечки вредности.
Се {{PLURAL:$3|прифаќа само следнава вредност|прифаќаат само следниве вредности}}: $2.',
	'validator-list-error-accepts-only-omitted' => 'Параметарот $1 има една или повеќе неважечки вредности.
Се {{PLURAL:$3|прифаќа само следнава вредност|прифаќаат само следниве вредности}}: $2 (и $4 {{PLURAL:$4|изоставена вредност|изоставени вредности}}).',
	'validator_error_accepts_only' => 'Вредноста „$4“ е неважечка за параметарот $1. Се {{PLURAL:$3|прифаќа само следнава вредност|прифаќаат само следниве вредности}}: $2.',
	'validator-error-accepts-only-omitted' => 'Вредноста „$2“ не е важечка за параметарот $1. Се прифаќаат само следниве вредности: $3 (и $4 изоставени вредности).',
	'validator_list_omitted' => '{{PLURAL:$2|Вредноста|Вредностите}} $1 {{PLURAL:$2|беше испуштена|беа испуштени}}.',
);

/** Dutch (Nederlands)
 * @author Jeroen De Dauw
 * @author Siebrand
 */
$messages['nl'] = array(
	'validator-desc' => 'Validator geeft andere uitbreidingen de mogelijkheid om parameters van parserfuncties en taguitbreidingen te valideren, in te stellen op hun standaardwaarden en foutberichten te genereren',
	'validator-warning' => 'Waarschuwing: $1',
	'validator-error' => 'Fout: $1',
	'validator-fatal-error' => 'Onherstelbare fout: $1',
	'validator_error_parameters' => 'In uw syntaxis {{PLURAL:$1|is de volgende fout|zijn de volgende fouten}} gedetecteerd:',
	'validator_warning_parameters' => 'Er {{PLURAL:$1|zit een fout|zitten $1 fouten}} in uw syntaxis.',
	'validator-warning-adittional-errors' => '... en nog {{PLURAL:$1|een ander probleem|$1 andere problemen}}.',
	'validator-error-omitted' => 'De {{PLURAL:$2|waarde "$1" mist|waarden "$1" missen}}.',
	'validator-error-problem' => 'Er was een probleem met de parameter $1.',
	'validator_error_unknown_argument' => '$1 is geen geldige parameter.',
	'validator_error_required_missing' => 'De verplichte parameter $1 is niet opgegeven.',
	'validator-error-override-argument' => 'Geprobeerd de parameter $1 (waarde: $2) te overschrijven met waarde "$3".',
	'validator-listerrors-errors' => 'Fouten',
	'validator-listerrors-minor' => 'Overkomelijk',
	'validator-listerrors-low' => 'Laag',
	'validator-listerrors-normal' => 'Gemiddeld',
	'validator-listerrors-high' => 'Groot',
	'validator-listerrors-fatal' => 'Fataal',
	'validator_error_empty_argument' => 'De parameter $1 mag niet leeg zijn.',
	'validator_error_must_be_number' => 'De parameter $1 mag alleen een getal zijn.',
	'validator_error_must_be_integer' => 'De parameter $1 kan alleen een heel getal zijn.',
	'validator-error-must-be-float' => 'Parameter $1 kan alleen een getal met decimalen zijn.',
	'validator_error_invalid_range' => 'De parameter $1 moet tussen $2 en $3 liggen.',
	'validator-error-invalid-regex' => 'De parameter $1 moet voldoen aan deze reguliere expressie: $2.',
	'validator-error-invalid-length' => 'Parameter $1 moet een lengte hebben van $2.',
	'validator-error-invalid-length-range' => 'Parameter $1 moet een lengte hebben tussen $2 en $3.',
	'validator_error_invalid_argument' => 'De waarde $1 is niet geldig voor de parameter $2.',
	'validator_list_error_empty_argument' => 'Voor de parameter $1 zijn lege waarden niet toegestaan.',
	'validator_list_error_must_be_number' => 'Voor de parameter $1 zijn alleen getallen toegestaan.',
	'validator_list_error_must_be_integer' => 'Voor de parameter $1 zijn alleen hele getallen toegestaan.',
	'validator-list-error-must-be-float' => 'Voor de parameter $1 zijn alleen getallen met drijvende komma toegestaan.',
	'validator_list_error_invalid_range' => 'Alle waarden voor de parameter $1 moeten tussen $2 en $3 liggen.',
	'validator-list-error-invalid-regex' => 'Alle waarden voor de parameter $1 moeten voldoen aan deze reguliere expressie: $2.',
	'validator_list_error_invalid_argument' => 'Een of meerdere waarden voor de parameter $1 zijn ongeldig.',
	'validator-list-error-accepts-only' => 'Een of meer waarden voor de parameter $1 zijn ongeldig. 
Alleen deze {{PLURAL:$3|waarde is|waarden zijn}} toegestaan: $2.',
	'validator-list-error-accepts-only-omitted' => 'Een of meer waarden voor de parameter $1 zijn ongeldig.
Alleen deze {{PLURAL:$3|waarde is|waarden zijn}} toegestaan: $2.
Als ook $4 weggelaten {{PLURAL:$4|waarde|waarden}}.',
	'validator_error_accepts_only' => 'De waarde "$4" is ongeldig voor parameter $1. Deze kan alleen de volgende {{PLURAL:$3|waarde|waarden}} hebben: $2.',
	'validator-error-accepts-only-omitted' => 'De waarde "$2" is niet geldig voor de parameter $1.
Alleen deze {{PLURAL:$5|waarde is|waarden zijn}} toegestaan: $3.
Als ook $4 weggelaten {{PLURAL:$4|waarde|waarden}}.',
	'validator_list_omitted' => 'De {{PLURAL:$2|waarde|waarden}} $1 {{PLURAL:$2|mist|missen}}.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'validator-desc' => 'Gir generisk støtte for parameterhåndtering for andre utvidelser',
	'validator-warning' => 'Advarsel: $1',
	'validator-error' => 'Feil: $1',
	'validator-fatal-error' => 'Kritisk feil: $1',
	'validator_error_parameters' => 'Følgende {{PLURAL:$1|feil|feil}} har blitt oppdaget i syntaksen din:',
	'validator_warning_parameters' => 'Det er {{PLURAL:$1|én feil|flere feil}} i syntaksen din.',
	'validator-warning-adittional-errors' => '... og {{PLURAL:$1|ett problem til|flere problem}}.',
	'validator-error-omitted' => '{{PLURAL:$2|Verdien|Verdiene}} «$1» har blitt utelatt.',
	'validator-error-problem' => 'Det var et problem med parameteren $1.',
	'validator_error_unknown_argument' => '$1 er ikke en gyldig parameter.',
	'validator_error_required_missing' => 'Den nødvendige parameteren «$1» er ikke angitt.',
	'validator-error-override-argument' => 'Prøvde å overkjøre parameter $1 (verdi: $2) med verdien «$3»',
	'validator-listerrors-errors' => 'Feil',
	'validator-listerrors-minor' => 'Mindre',
	'validator-listerrors-low' => 'Lav',
	'validator-listerrors-normal' => 'Normal',
	'validator-listerrors-high' => 'Høy',
	'validator-listerrors-fatal' => 'Kritisk',
	'validator_error_empty_argument' => 'Parameteren $1 kan ikke ha en tom verdi.',
	'validator_error_must_be_number' => 'Parameteren $1 må være et tall.',
	'validator_error_must_be_integer' => 'Parameteren $1 må være et heltall.',
	'validator-error-must-be-float' => 'Parameter $1 må være et flyttall.',
	'validator_error_invalid_range' => 'Parameter $1 må være mellom $2 og $3.',
	'validator-error-invalid-regex' => 'Parameteren $1 må samsvare med dette regulære uttrykket: $2.',
	'validator-error-invalid-length' => 'Parameter $1 må ha en lengde på $2.',
	'validator-error-invalid-length-range' => 'Parameter $1 må ha en lengde mellom $2 og $3.',
	'validator_error_invalid_argument' => 'Verdien $1 er ikke gyldig for parameter $2.',
	'validator_list_error_empty_argument' => 'Parameteren $1 godtar ikke tomme verdier.',
	'validator_list_error_must_be_number' => 'Parameteren $1 kan bare inneholde tall.',
	'validator_list_error_must_be_integer' => 'Parameteren $1 kan bare inneholde heltall.',
	'validator-list-error-must-be-float' => 'Parameteren $1 kan bare innholde flyttall.',
	'validator_list_error_invalid_range' => 'Alle verdier av parameteren $1 må være mellom $2 og $3.',
	'validator-list-error-invalid-regex' => 'Alle verdier av parameteren $1 må samsvare med dette regulære uttrykket: $2.',
	'validator_list_error_invalid_argument' => 'Parameteren $1 har en eller flere ugyldige verdier.',
	'validator-list-error-accepts-only' => 'En eller flere verdier for parameteren $1 er ugyldige.
Den godtar bare {{PLURAL:$3|denne verdien|disse verdiene}}: $2.',
	'validator-list-error-accepts-only-omitted' => 'En eller flere verdier for parameteren $1 er ugyldige.
Den godtar bare {{PLURAL:$3|denne verdien|disse verdiene}}: $2 (og $4 {{PLURAL:$4|utelatt verdi|utelatte verdier}}).',
	'validator_error_accepts_only' => 'Verdien «$4» er ikke gyldig for parameteren $1. Den aksepterer kun {{PLURAL:$3|denne verdien|disse verdiene}}: $2.',
	'validator-error-accepts-only-omitted' => 'Verdien «$2» er ikke gyldig for parameteren $1.
Den godtar bare {{PLURAL:$5|denne verdien|disse verdiene}}: $3 (og $4 {{PLURAL:$4|utelatt verdi|utelatte verdier}}).',
	'validator_list_omitted' => '{{PLURAL:$2|Verdien|Verdiene}} $1 har blitt utelatt.',
);

/** Occitan (Occitan)
 * @author Cedric31
 * @author Jfblanc
 */
$messages['oc'] = array(
	'validator-desc' => "Validator porgís a d'autras extensions un biais per validar aisidament los paramètres de foncions d'analisi e las extensions de mercas, definir de valors per manca e crear de messatges d'error",
	'validator_error_parameters' => '{{PLURAL:$1|Aquela error es estada detectada|Aquelas errors son estadas detectadas}} dins la sintaxi',
	'validator_error_unknown_argument' => '$1 es pas un paramètre valedor.',
	'validator_error_required_missing' => "Manca lo paramètre $1 qu'es obligatòri.",
	'validator_error_empty_argument' => 'Lo paramètre $1 pòt pas estar voide.',
	'validator_error_must_be_number' => 'Lo paramètre $1 deu èsser un nombre.',
	'validator_error_must_be_integer' => 'Lo paramètre $1 deu èsser un nombre entièr.',
	'validator_error_invalid_range' => 'Lo paramètre $1 deu èsser entre $2 e $3.',
	'validator_error_invalid_argument' => '$1 es pas valedor pel paramètre $2.',
	'validator_error_accepts_only' => 'Sonque {{PLURAL:$3|aquela valor es valedora|aquelas valors son valedoras}}pel paramètre $1 : $2.',
);

/** Polish (Polski)
 * @author Fizykaa
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'validator-desc' => 'Dostarcza innym rozszerzeniom ogólną obsługę parametrów',
	'validator-warning' => 'Uwaga – $1',
	'validator-error' => 'Błąd – $1',
	'validator-fatal-error' => 'Błąd krytyczny – $1',
	'validator_error_parameters' => 'W Twoim kodzie {{PLURAL:$1|został wykryty następujący błąd|zostały wykryte następujące błędy}} składni:',
	'validator_warning_parameters' => 'W Twoim kodzie {{PLURAL:$1|wystąpił błąd|wystąpiły błędy}} składni.',
	'validator-warning-adittional-errors' => '... i {{PLURAL:$1|jeszcze jeden problem|wiele więcej problemów}}.',
	'validator-error-omitted' => '{{PLURAL:$2|Wartość „$1” została pominięta|Wartości „$1” zostały pominięte}}.',
	'validator-error-problem' => 'Wystąpił problem z parametrem $1.',
	'validator_error_unknown_argument' => '$1 jest niepoprawnym parametrem.',
	'validator_error_required_missing' => 'Obowiązkowy parametr $1 nie został przekazany.',
	'validator-error-override-argument' => 'Próba nadpisania parametru $1 o wartości „$2” nową wartością „$3”',
	'validator-listerrors-errors' => 'Błędy',
	'validator-listerrors-minor' => 'Nieistotny',
	'validator-listerrors-low' => 'Mało istotny',
	'validator-listerrors-normal' => 'Typowy',
	'validator-listerrors-high' => 'Istotny',
	'validator-listerrors-fatal' => 'Krytyczny',
	'validator_error_empty_argument' => 'Parametr $1 nie może być pusty.',
	'validator_error_must_be_number' => 'Parametr $1 musi być liczbą.',
	'validator_error_must_be_integer' => 'Parametr $1 musi być liczbą całkowitą.',
	'validator-error-must-be-float' => 'Parametr $1 musi być liczbą rzeczywistą.',
	'validator_error_invalid_range' => 'Parametr $1 musi zawierać się w przedziale od $2 do $3.',
	'validator-error-invalid-regex' => 'Parametr $1 musi pasować do wyrażenia regularnego $2.',
	'validator-error-invalid-length' => 'Parametr $1 musi mieć długość $2.',
	'validator-error-invalid-length-range' => 'Długość parametru $1 musi zawierać się w przedziale od $2 do $3.',
	'validator_error_invalid_argument' => 'Nieprawidłowa wartość $1 parametru $2.',
	'validator_list_error_empty_argument' => 'Parametr $1 nie może być pusty.',
	'validator_list_error_must_be_number' => 'Parametrem $1 mogą być wyłącznie liczby.',
	'validator_list_error_must_be_integer' => 'Parametrem $1 mogą być wyłącznie liczby całkowite.',
	'validator-list-error-must-be-float' => 'Parametrem $1 mogą być wyłącznie liczby rzeczywiste.',
	'validator_list_error_invalid_range' => 'Wartości parametru $1 muszą zawierać się w przedziale od $2 do $3.',
	'validator-list-error-invalid-regex' => 'Wszystkie wartości parametru $1 muszą pasować do wyrażenia regularnego $2.',
	'validator_list_error_invalid_argument' => 'Przynajmniej jedna wartość parametru $1 jest nieprawidłowa.',
	'validator-list-error-accepts-only' => 'Jedna lub więcej wartości parametru $1 są nieprawidłowe.
Może przyjmować wyłącznie {{PLURAL:$3|wartość|wartości:}} $2.',
	'validator-list-error-accepts-only-omitted' => 'Jedna lub więcej wartości parametru $1 są nieprawidłowe.
Może przyjmować wyłącznie {{PLURAL:$3|wartość|wartości:}} $2 (oraz $4 {{PLURAL:$4|pominiętą wartość|pominięte wartości|pominiętych wartości}}).',
	'validator_error_accepts_only' => 'Wartość „$4” jest nieprawidłowa dla parametru $1. {{PLURAL:$3|Dopuszczalna jest wyłącznie wartość|Dopuszczalne są wyłącznie wartości:}} $2.',
	'validator-error-accepts-only-omitted' => 'Wartość „$2” parametru $1 jest nieprawidłowa.
Parametr może przyjmować wyłącznie {{PLURAL:$5|wartość|wartości:}} $3 (oraz $4 {{PLURAL:$4|pominiętą wartość|pominięte wartości|pominiętych wartości}}).',
	'validator_list_omitted' => '{{PLURAL:$2|Parametr|Parametry}} $1 {{PLURAL:$2|został opuszczony|zostały opuszczone}}.',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 * @author McDutchie
 */
$messages['pms'] = array(
	'validator-desc' => "Validator a dà na manera bel fé për àutre estension ëd validé ij paràmetr ëd le funsion dël parser e j'estension dij tag, d'amposté ij valor ëd default e generé mëssagi d'eror",
	'validator-warning' => 'Avis: $1',
	'validator-error' => 'Eror: $1',
	'validator-fatal-error' => 'Eror Fatal: $1',
	'validator_error_parameters' => "{{PLURAL:$1|L'eror sì-sota a l'é stàit|J'eror sì-sota a son ëstàit}} trovà an soa sintassi:",
	'validator_warning_parameters' => "{{PLURAL:$1|A-i é n'|A-i son dj'}}eror ant soa sintassi.",
	'validator-warning-adittional-errors' => "... e {{PLURAL:$1|ëdcò n'àutr problema|vàire àutri problema}}.",
	'validator-error-omitted' => '{{PLURAL:$2|Ël valor "$1" a l\'é|Ij valor "$1" a son}} stàit sautà.',
	'validator-error-problem' => 'A-i é staje un problema con ël paràmetr $1.',
	'validator_error_unknown_argument' => "$1 a l'é un paràmetr pa bon.",
	'validator_error_required_missing' => "Ël paràmetr obligatòri $1 a l'é pa dàit.",
	'validator-error-override-argument' => 'Provà a coaté ël paràmetr $1 (valor: $2) con ël valor "$3"',
	'validator-listerrors-errors' => 'Eror',
	'validator-listerrors-minor' => 'Pi cit',
	'validator-listerrors-low' => 'Bass',
	'validator-listerrors-normal' => 'Normal',
	'validator-listerrors-high' => 'Àut',
	'validator-listerrors-fatal' => 'Fatal',
	'validator_error_empty_argument' => 'Ël paràmetr $1 a peul pa avèj un valor veuid.',
	'validator_error_must_be_number' => 'Ël paràmetr $1 a peul mach esse un nùmer.',
	'validator_error_must_be_integer' => "Ël paràmetr $1 a peul mach esse n'antregh.",
	'validator-error-must-be-float' => 'Ël paràmetr $1 a peul mach esse un nùmer an vìrgola mòbil.',
	'validator_error_invalid_range' => 'Ël paràmetr $1 a deuv esse an tra $2 e $3.',
	'validator-error-invalid-regex' => 'Ël paràmetr $1 a dev cobiesse con sta espression regolar: $2.',
	'validator-error-invalid-length' => 'Ël paràmetr $1 a dev avèj na longheur ëd $2.',
	'validator-error-invalid-length-range' => 'Ël paràmetr $1 a dev avèj na longheur antra $2 e $3.',
	'validator_error_invalid_argument' => "Ël valor $1 a l'é pa bon për ël paràmetr $2.",
	'validator_list_error_empty_argument' => 'Ël paràmetr $1 a aceta pa dij valor veuid.',
	'validator_list_error_must_be_number' => 'Ël paràmetr $1 a peul mach conten-e dij nùmer.',
	'validator_list_error_must_be_integer' => "Ël paràmetr $1 a peul mach conten-e dj'antegr.",
	'validator-list-error-must-be-float' => 'Ël paràmetr $1 a peul mach conten-e dij nùmer con vìrgola.',
	'validator_list_error_invalid_range' => 'Tùit ij valor dël paràmetr $1 a deuvo esse tra $2 e $3.',
	'validator-list-error-invalid-regex' => 'Tùit ij valor dël paràmetr $1 a devo cobiesse con sta espression regolar: $2.',
	'validator_list_error_invalid_argument' => 'Un o pi valor dël paràmetr $1 a son pa bon.',
	'validator-list-error-accepts-only' => 'Un o pi valor për ël paràmetr $1 a son pa bon.
A aceta mach {{PLURAL:$3|sto valor|sti valor}}: $2.',
	'validator-list-error-accepts-only-omitted' => 'Un o pi valor për ël paràmetr $1 a son pa bon.
A aceta mach {{PLURAL:$3|sto valor|sti valor}}: $2 (e $4 {{PLURAL:$4|valor|valor}} sautà).',
	'validator_error_accepts_only' => 'Ël valor "$4" a l\'é pa bon për ël paràmetr $1. A aceta mach {{PLURAL:$3|sto valor-sì|sti valor-sì}}: $2.',
	'validator-error-accepts-only-omitted' => 'Ël valor "$2" a l\'é pa bon për ël paràmetr $1. A aceta mach sti valor: $3 (e ij valor pa butà $4).',
	'validator_list_omitted' => "{{PLURAL:$2|Ël valor|Ij valor}} $1 {{PLURAL:$2|a l'é|a son}} pa stàit butà.",
);

/** Portuguese (Português)
 * @author Giro720
 * @author Hamilton Abreu
 * @author Waldir
 */
$messages['pt'] = array(
	'validator-desc' => 'O Serviço de Validação permite que, de forma simples, as outras extensões possam validar parâmetros das funções do analisador sintáctico e das extensões dos elementos HTML, definir valores por omissão e gerar mensagens de erro',
	'validator-warning' => 'Aviso: $1',
	'validator-error' => 'Erro: $1',
	'validator-fatal-error' => 'Erro fatal: $1',
	'validator_error_parameters' => '{{PLURAL:$1|Foi detectado o seguinte erro sintáctico|Foram detectados os seguintes erros sintácticos}}:',
	'validator_warning_parameters' => '{{PLURAL:$1|Existe um erro sintáctico|Existem erros sintácticos}}.',
	'validator-warning-adittional-errors' => '... e {{PLURAL:$1|mais um problema|vários outros problemas}}.',
	'validator-error-omitted' => '{{PLURAL:$2|O valor "$1" foi omitido|Os valores "$1" foram omitidos}}.',
	'validator-error-problem' => 'Houve um problema com o parâmetro $1.',
	'validator_error_unknown_argument' => '$1 não é um parâmetro válido.',
	'validator_error_required_missing' => 'O parâmetro obrigatório $1 não foi fornecido.',
	'validator-error-override-argument' => 'Tentativa de sobrepor o parâmetro $1 (valor: $2) com o valor "$3"',
	'validator-listerrors-errors' => 'Erros',
	'validator-listerrors-minor' => 'Menor',
	'validator-listerrors-low' => 'Baixo',
	'validator-listerrors-normal' => 'Normal',
	'validator-listerrors-high' => 'Alto',
	'validator-listerrors-fatal' => 'Fatal',
	'validator_error_empty_argument' => 'O parâmetro $1 não pode estar vazio.',
	'validator_error_must_be_number' => 'O parâmetro $1 só pode ser numérico.',
	'validator_error_must_be_integer' => 'O parâmetro $1 só pode ser um número inteiro.',
	'validator-error-must-be-float' => 'O parâmetro $1 só pode ser um número de vírgula flutuante.',
	'validator_error_invalid_range' => 'O parâmetro $1 tem de ser entre $2 e $3.',
	'validator-error-invalid-regex' => 'O parâmetro $1 deve corresponder à expressão regular: $2.',
	'validator-error-invalid-length' => 'O parâmetro $1 tem de ter um comprimento de $2.',
	'validator-error-invalid-length-range' => 'O parâmetro $1 tem de ter um comprimento entre $2 e $3.',
	'validator_error_invalid_argument' => 'O valor $1 não é válido para o parâmetro $2.',
	'validator_list_error_empty_argument' => 'O parâmetro $1 não pode estar vazio.',
	'validator_list_error_must_be_number' => 'O parâmetro $1 só pode ser numérico.',
	'validator_list_error_must_be_integer' => 'O parâmetro $1 só pode ser um número inteiro.',
	'validator-list-error-must-be-float' => 'O parâmetro $1 só pode conter valores de vírgula flutuante.',
	'validator_list_error_invalid_range' => 'Todos os valores do parâmetro $1 têm de ser entre $2 e $3.',
	'validator-list-error-invalid-regex' => 'Todos os valores do parâmetro $1 devem corresponder à expressão regular: $2.',
	'validator_list_error_invalid_argument' => 'Um ou mais valores do parâmetro $1 são inválidos.',
	'validator-list-error-accepts-only' => 'Um ou mais valores para o parâmetro $1 são inválidos. 
Só {{PLURAL:$3|é aceite este valor|são aceites estes valores}}: $2.',
	'validator-list-error-accepts-only-omitted' => 'Um ou mais valores para o parâmetro $1 são inválidos. 
Só {{PLURAL:$3|é aceite este valor|são aceites estes valores}}: $2 (e $4 {{PLURAL:$4|valor omitido|valores omitidos}}).',
	'validator_error_accepts_only' => 'O valor "$4" não é válido para o parâmetro $1. O parâmetro só aceita {{PLURAL:$3|este valor|estes valores}}: $2.',
	'validator-error-accepts-only-omitted' => 'O valor $2 não é válido para o parâmetro $1.
Só {{PLURAL:$5|é aceite este valor|são aceites estes valores}}: $3 (e $4 {{PLURAL:$4|valor omitido|valores omitidos}}).',
	'validator_list_omitted' => '{{PLURAL:$2|O valor $1 foi omitido|Os valores $1 foram omitidos}}.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'validator-desc' => 'Fornece suporte a manipulação de parâmetros genéricos para outras extensões',
	'validator-warning' => 'Atenção: $1',
	'validator-error' => 'Erro: $1',
	'validator-fatal-error' => 'Erro crítico: $1',
	'validator_error_parameters' => '{{PLURAL:$1|Foi detectado o seguinte erro sintáctico|Foram detectados os seguintes erros sintácticos}}:',
	'validator_warning_parameters' => '{{PLURAL:$1|Existe um erro|Existem erros}} em sua sintaxe.',
	'validator-warning-adittional-errors' => '... e {{PLURAL:$1|mais um problema|vários outros problemas}}.',
	'validator-error-omitted' => '{{PLURAL:$2|O valor "$1" foi omitido|Os valores "$1" foram omitidos}}.',
	'validator-error-problem' => 'Houve um problema com o parâmetro $1.',
	'validator_error_unknown_argument' => '$1 não é um parâmetro válido.',
	'validator_error_required_missing' => 'O parâmetro obrigatório $1 não foi fornecido.',
	'validator-error-override-argument' => 'Tentativa de sobrepor o parâmetro $1 (valor: $2) com o valor "$3"',
	'validator-listerrors-errors' => 'Erros',
	'validator-listerrors-minor' => 'Menor',
	'validator-listerrors-low' => 'Baixo',
	'validator-listerrors-normal' => 'Normal',
	'validator-listerrors-high' => 'Alto',
	'validator-listerrors-fatal' => 'Fatal',
	'validator_error_empty_argument' => 'O parâmetro $1 não pode estar vazio.',
	'validator_error_must_be_number' => 'O parâmetro $1 só pode ser numérico.',
	'validator_error_must_be_integer' => 'O parâmetro $1 só pode ser um número inteiro.',
	'validator-error-must-be-float' => 'O parâmetro $1 deve ser um número de ponto flutuante.',
	'validator_error_invalid_range' => 'O parâmetro $1 tem de ser entre $2 e $3.',
	'validator-error-invalid-regex' => 'O parâmetro $1 deve corresponder à expressão regular: $2.',
	'validator-error-invalid-length' => 'O parâmetro $1 deve ter um comprimento de $2.',
	'validator-error-invalid-length-range' => 'O parâmetro $1 deve ter um comprimento entre $2 e $3.',
	'validator_error_invalid_argument' => 'O valor $1 não é válido para o parâmetro $2.',
	'validator_list_error_empty_argument' => 'O parâmetro $1 não pode estar vazio.',
	'validator_list_error_must_be_number' => 'O parâmetro $1 só pode ser numérico.',
	'validator_list_error_must_be_integer' => 'O parâmetro $1 só pode ser um número inteiro.',
	'validator-list-error-must-be-float' => 'O parâmetro $1 só pode conter valores de ponto flutuante.',
	'validator_list_error_invalid_range' => 'Todos os valores do parâmetro $1 têm de ser entre $2 e $3.',
	'validator-list-error-invalid-regex' => 'Todos os valores do parâmetro $1 devem corresponder à expressão regular: $2.',
	'validator_list_error_invalid_argument' => 'Um ou mais valores do parâmetro $1 são inválidos.',
	'validator-list-error-accepts-only' => 'Um ou mais valores para o parâmetro $1 são inválidos. 
Só {{PLURAL:$3|é aceite este valor|são aceites estes valores}}: $2.',
	'validator-list-error-accepts-only-omitted' => 'Um ou mais valores para o parâmetro $1 são inválidos. 
Só {{PLURAL:$3|é aceite este valor|são aceites estes valores}}: $2 (e $4 {{PLURAL:$4|valor omitido|valores omitidos}}).',
	'validator_error_accepts_only' => 'O valor $4 não é válido para o parâmetro $1. Esse parâmetro só aceita {{PLURAL:$3|este valor|estes valores}}: $2.',
	'validator-error-accepts-only-omitted' => 'O valor $2 não é válido para o parâmetro $1.
Só {{PLURAL:$5|é aceite este valor|são aceites estes valores}}: $3 (e $4 {{PLURAL:$4|valor omitido|valores omitidos}}).',
	'validator_list_omitted' => '{{PLURAL:$2|O valor $1 foi omitido|Os valores $1 foram omitidos}}.',
);

/** Romanian (Română)
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'validator-warning' => 'Avertisment: $1',
	'validator-fatal-error' => 'Eroare fatală: $1',
	'validator_error_unknown_argument' => '$1 nu este un parametru valid.',
	'validator_error_required_missing' => 'Parametrul solicitat „$1” nu este furnizat.',
	'validator-listerrors-errors' => 'Erori',
	'validator_error_empty_argument' => 'Parametrul $1 nu poate avea o valoare goală.',
	'validator_error_must_be_number' => 'Parametrul $1 poate fi doar un număr.',
	'validator_error_must_be_integer' => 'Parametrul $1 poate fi doar un număr întreg.',
);

/** Russian (Русский)
 * @author Aleksandrit
 * @author Eleferen
 * @author Lockal
 * @author MaxSem
 * @author McDutchie
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'validator-desc' => 'Валидатор предоставляет другим расширениям возможности проверки параметров функций парсера и тегов, установки значения по умолчанию и создания сообщения об ошибках',
	'validator-warning' => 'Внимание: $1',
	'validator-error' => 'Ошибка: $1',
	'validator-fatal-error' => 'Критическая ошибка: $1',
	'validator_error_parameters' => 'В вашем синтаксисе {{PLURAL:$1|обнаружена следующая ошибка|обнаружены следующие ошибки}}:',
	'validator_warning_parameters' => 'В вашем синтаксисе {{PLURAL:$1|имеется ошибка|имеются ошибки}}.',
	'validator-warning-adittional-errors' => '… и {{PLURAL:$1|ещё одна проблема|ещё несколько проблем}}.',
	'validator-error-omitted' => '{{PLURAL:$2|Значение «$1» пропущено|Значения «$1» пропущены}}.',
	'validator-error-problem' => 'Обнаружена проблема с параметром «$1».',
	'validator_error_unknown_argument' => '$1 не является допустимым параметром.',
	'validator_error_required_missing' => 'Не указан обязательный параметр $1.',
	'validator-error-override-argument' => 'Попытка переопределения параметра $1 (значение: $2) значением «$3»',
	'validator-listerrors-errors' => 'Ошибки',
	'validator-listerrors-minor' => 'Незначительная',
	'validator-listerrors-low' => 'Низкая',
	'validator-listerrors-normal' => 'Обычная',
	'validator-listerrors-high' => 'Высокая',
	'validator-listerrors-fatal' => 'Фатальная',
	'validator_error_empty_argument' => 'Параметр $1 не может принимать пустое значение.',
	'validator_error_must_be_number' => 'Значением параметра $1 могут быть только числа.',
	'validator_error_must_be_integer' => 'Параметр $1 может быть только целым числом.',
	'validator-error-must-be-float' => 'Параметр $1 может быть числом с плавающей точкой.',
	'validator_error_invalid_range' => 'Параметр $1 должен быть от $2 до $3.',
	'validator-error-invalid-regex' => 'Параметр «$1» должен соответствовать регулярному выражению «$2».',
	'validator-error-invalid-length' => 'Параметр $1 должен иметь длину $2.',
	'validator-error-invalid-length-range' => 'Параметр $1 должен иметь длину от $2 до $3.',
	'validator_error_invalid_argument' => 'Значение $1 не является допустимым параметром $2',
	'validator_list_error_empty_argument' => 'Параметр $1 не может принимать пустые значения.',
	'validator_list_error_must_be_number' => 'Параметр $1 может содержать только цифры.',
	'validator_list_error_must_be_integer' => 'Параметр $1 может содержать только целые числа.',
	'validator-list-error-must-be-float' => 'Параметр «$1» может содержать только числа с плавающей точкой.',
	'validator_list_error_invalid_range' => 'Все значения параметра $1 должна находиться в диапазоне от $2 до $3.',
	'validator-list-error-invalid-regex' => 'Все значения параметра «$1» должны соответствовать регулярноve выражению «$2».',
	'validator_list_error_invalid_argument' => 'Одно или несколько значений параметра $1 ошибочны.',
	'validator-list-error-accepts-only' => 'Ошибочны один или несколько значений параметра $1. 
{{PLURAL:$3|Допустимо только следующее значение|Допустимы только следующие значения}}: $2.',
	'validator-list-error-accepts-only-omitted' => 'Ошибочны один или несколько значений параметра $1. 
{{PLURAL:$3|Допустимо только следующее значение|Допустимы только следующие значения}}: $2 (и $4 {{PLURAL:$4|опущенное значение|опущенных значения|опущенных значений}}).',
	'validator_error_accepts_only' => 'Значение «$4» не подходит для параметра $1. Оно может принимать только {{PLURAL:$3|следующее значение|следующие значения}}: $2.',
	'validator-error-accepts-only-omitted' => 'Значение «$2» не подходит для параметра $1. 
{{PLURAL:$5|Допускается только значение|Допускаются только значения}}: $3 (и $4 {{PLURAL:$4|пропущенное значение|пропущенных значения|пропущенных значений}}).',
	'validator_list_omitted' => '{{PLURAL:$2|Значение $1 было пропущено|Значения $1 были пропущены}}.',
);

/** Sinhala (සිංහල)
 * @author Calcey
 */
$messages['si'] = array(
	'validator-desc' => 'තහවුරු කරන්නා ටැග් දිඟුවන් හා parser ශ්‍රිතවල පරාමිතීන් තහවුරු කිරීමට අනෙක් දිඟුවන් සඳහා පහසු ක්‍රමයක් සපයයි,පෙරනිමි අගයන් පිහිටුවීම හා දෝෂ පණිවුඩ ජනනය කිරීම ද සිදු කරයි',
	'validator_error_parameters' => 'ඔබේ වාග් රීතිය මඟින් පහත {{PLURAL:$1|දෝෂය|දෝෂයන්}} අනාවරණය කරනු ලැබ ඇත',
	'validator_error_unknown_argument' => '$1 වලංගු පරාමිතියක් නොවේ.',
	'validator_error_required_missing' => 'අවශ්‍ය වන $1 පරාමිතිය සපයා නොමැත.',
	'validator_error_empty_argument' => '$1 පරාමිතියට හිස් අගයක් තිබිය නොහැක.',
	'validator_error_must_be_number' => '$1 පරාමිතිය විය හැක්කේ ඉලක්කමක් පමණි.',
	'validator_error_invalid_range' => '$1 පරාමිතිය $2 හා $3 අතර විය යුතුය.',
	'validator_error_invalid_argument' => '$2 පරාමිතිය සඳහා $1 අගය වලංගු නොවේ.',
	'validator_error_accepts_only' => '$1 පරාමිතිය විසින් පිළිගනු ලබන්නේ {{PLURAL:$3|මෙම අගය|මෙම අගයන්}}: $2 පමණි.',
);

/** Swedish (Svenska)
 * @author Fluff
 * @author Ozp
 * @author Per
 * @author Sertion
 */
$messages['sv'] = array(
	'validator-desc' => 'Valideraren skapar ett smidigt sätt för andra tillägg att validera olika parserfunktioners parametrar och taggar, sätta standardvärden för tilläggen samt att generera felmeddelanden',
	'validator_error_parameters' => 'Följande {{PLURAL:$1|fel|fel}} har upptäckts i din syntax:',
	'validator_warning_parameters' => 'Det finns {{PLURAL:$1|ett|flera}} fel i din syntax.',
	'validator_error_unknown_argument' => '$1 är inte en giltig paramter.',
	'validator_error_required_missing' => 'Den nödvändiga parametern $1 har inte angivits.',
	'validator_error_empty_argument' => 'Parametern $1 kan inte lämnas tom.',
	'validator_error_must_be_number' => 'Parameter $1 måste bestå av ett tal.',
	'validator_error_must_be_integer' => 'Parametern $1 måste vara ett heltal.',
	'validator_error_invalid_range' => 'Parameter $1 måste vara i mellan $2 och $3.',
	'validator_error_invalid_argument' => 'Värdet $1 är inte giltigt som parameter $2.',
	'validator_list_error_empty_argument' => 'Parameter $1 accepterar inte tomma värden.',
	'validator_list_error_must_be_number' => 'Parameter $1 får endast innehålla siffror.',
	'validator_list_error_must_be_integer' => 'Parameter $1 får endast innehålla heltal.',
	'validator_list_error_invalid_range' => 'Alla värden av parameter $1 måste vara mellan $2 och $3.',
	'validator_list_error_invalid_argument' => 'Ett eller flera värden av parameter $1 är ogiltiga.',
	'validator_list_omitted' => '{{PLURAL:$2|Värdet|Värdena}} $1 har blivit {{PLURAL:$2|utelämnat|utelämnade}}.',
	'validator_error_accepts_only' => 'Parametern $1 måste ha {{PLURAL:$3|detta värde|ett av dessa värden}}: $2.',
);

/** Telugu (తెలుగు)
 * @author Ravichandra
 * @author Veeven
 */
$messages['te'] = array(
	'validator-warning' => 'హెచ్చరిక: $1',
	'validator-error' => 'పొరపాటు: $1',
	'validator_error_unknown_argument' => '$1 అనేది సరైన పరామితి కాదు.',
	'validator_error_required_missing' => 'తప్పకుండా కావాల్సిన $1 పరామితిని ఇవ్వలేదు.',
	'validator-listerrors-errors' => 'పొరపాట్లు',
	'validator_error_empty_argument' => '$1 పరామితి ఖాళీగా ఉండకూడదు',
	'validator_error_must_be_number' => '$1 పరామితి ఖచ్చితంగా ఓ సంఖ్య అయిఉండాలి',
	'validator_error_must_be_integer' => '$1 పరామితి ఒక పూర్ణసంఖ్య అయిఉండాలి',
	'validator_error_invalid_range' => '$1 పరామితి $2,  $3 మద్యలో ఉండాలి.',
	'validator_error_invalid_argument' => '$2 పరామితి కోసం $1 విలువ సరైంది కాదు',
	'validator_list_error_must_be_number' => '$1 పరామితి ఖచ్చితంగా సంఖ్యలను మాత్రమే కలిగివుండాలి.',
	'validator_list_error_must_be_integer' => '$1 పరామితి పూర్ణసంఖ్యలను మాత్రమే కలిగివుండాలి.',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'validator-desc' => 'Nagbibigay ng panlahatang magtangkilik na paghawak sa ibang mga dugtong',
	'validator-warning' => 'Babala: $1',
	'validator-error' => 'Kamalian: $1',
	'validator-fatal-error' => 'Masidhing kamalian: $1',
	'validator_error_parameters' => 'Ang sumusunod na {{PLURAL:$1|kamalian|mga kamalian}} ay napansin sa iyong sintaks:',
	'validator_warning_parameters' => 'May {{PLURAL:$1|mali|mga mali}} sa sintaks mo.',
	'validator-warning-adittional-errors' => '... at {{PLURAL:$1|isa pang paksa|maramihan pang mga paksa}}.',
	'validator_error_unknown_argument' => 'Ang $1 ay isang hindi tanggap na parametro.',
	'validator_error_required_missing' => 'Hindi ibinigay ang kailangang parametro na $1.',
	'validator-error-override-argument' => 'Sinubukang pangingibabawan ang parametrong $1 (halaga: $2) ng halagang "$3"',
	'validator_error_empty_argument' => 'Hindi dapat na isang halagang walang laman ang parametrong $1.',
	'validator_error_must_be_number' => 'Dapat na bilang lang ang parametrong $1.',
	'validator_error_must_be_integer' => 'Dapat na tambilang lang ang parametrong $1.',
	'validator-error-must-be-float' => 'Ang parametrong $1 ay maaaring isang lumulutang na bilang ng punto lamang.',
	'validator_error_invalid_range' => 'Dapat na nasa pagitan ng $2 at $3 ang parametrong $1.',
	'validator-error-invalid-length' => 'Ang parametrong $1 ay dapat na may isang haba na $2.',
	'validator-error-invalid-length-range' => 'Ang parametrong $1 ay dapat na may isang haba na nasa pagitan ng $2 at $3.',
	'validator_error_invalid_argument' => 'Ang halagang $1 ay hindi tanggap para sa parametrong $2.',
	'validator_list_error_empty_argument' => 'Hindi tumatanggap ng halagang walang laman ang parametrong $1.',
	'validator_list_error_must_be_number' => 'Dapat na naglalaman lang ng mga bilang ang parametrong $1.',
	'validator_list_error_must_be_integer' => 'Dapat na naglalaman lang ng mga tambilang ang parametrong $1.',
	'validator_list_error_invalid_range' => 'Dapat na nasa pagitan ng $2 at $3 ang lahat ng mga halaga ng parametrong $1.',
	'validator_list_error_invalid_argument' => 'Hindi tanggap ang isa o higit pang mga halaga para sa parametrong $1.',
	'validator_error_accepts_only' => 'Ang halagang "$4" ay hindi tanggap para sa parametrong $1.  Tumatanggap lamang ito ng 
{{PLURAL:$3|ganitong halaga|ganitong mga halaga}}: $2.',
	'validator_list_omitted' => 'Tinanggal {{PLURAL:$2|na ang|na ang mga}} {{PLURAL:$2|halaga|halaga}} ng $1.',
);

/** Turkish (Türkçe)
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'validator_error_unknown_argument' => '$1, geçerli bir parametre değildir.',
	'validator_error_empty_argument' => '$1 parametresi boş bir değere sahip olamaz.',
	'validator_error_must_be_number' => '$1 parametresi sadece sayı olabilir.',
	'validator_error_must_be_integer' => '$1 parametresi sadece bir tamsayı olabilir',
	'validator_list_error_empty_argument' => '$1 parametresi boş değerleri kabul etmemektedir.',
	'validator_list_error_must_be_number' => '$1 parametresi sadece sayı içerebilir.',
);

/** Ukrainian (Українська)
 * @author NickK
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'validator-desc' => 'Валідатор забезпечує іншим розширенням можливості перевірки параметрів функцій парсера і тегів, встановлення значень за умовчанням та створення повідомлень про помилки',
	'validator_error_parameters' => 'У вашому синтаксисі {{PLURAL:$1|виявлена така помилка|виявлені такі помилки}}:',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'validator-desc' => 'Bộ phê chuẩn cho phép các phần mở rộng khác phê chuẩn tham số của hàm cú pháp và thẻ mở rộng, đặt giá trị mặc định, và báo cáo lỗi.',
	'validator_error_parameters' => '{{PLURAL:$1|Lỗi|Các lỗi}} cú pháp sau được nhận ra trong mã của bạn:',
	'validator_warning_parameters' => 'Có {{PLURAL:$1|lỗi|lỗi}} cú pháp trong mã của bạn.',
	'validator_error_unknown_argument' => '$1 không phải là tham số hợp lệ.',
	'validator_error_required_missing' => 'Không định rõ tham số bắt buộc “$1”.',
	'validator_error_empty_argument' => 'Tham số “$1” không được để trống.',
	'validator_error_must_be_number' => 'Tham số “$1” phải là con số.',
	'validator_error_must_be_integer' => 'Tham số “$1” phải là số nguyên.',
	'validator_error_invalid_range' => 'Tham số “$1” phải nằm giữa $2 và $3.',
	'validator_error_invalid_argument' => 'Giá trị “$1” không hợp tham số “$2”.',
	'validator_list_error_empty_argument' => 'Không được để trống tham số “$1”.',
	'validator_list_error_must_be_number' => 'Tham số “$1” chỉ được phép bao gồm con số.',
	'validator_list_error_must_be_integer' => 'Tham số “$1” chỉ được phép bao gồm số nguyên.',
	'validator_list_error_invalid_range' => 'Tất cả các giá trị của tham số “$1” phải nằm giữa $2 và $3.',
	'validator_list_error_invalid_argument' => 'Ít nhất một giá trị của tham số “$1” không hợp lệ.',
	'validator_list_omitted' => '{{PLURAL:$2|Giá trị|Các giá trị}} “$1” bị bỏ qua.',
	'validator_error_accepts_only' => 'Tham số $1 chỉ nhận được {{PLURAL:$3|giá trị|các giá trị}} này: $2.',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Wilsonmess
 */
$messages['zh-hans'] = array(
	'validator_error_unknown_argument' => '$1 不是合法参数。',
	'validator_error_required_missing' => '未能提供所需要的参数 $1 。',
	'validator_error_empty_argument' => '参数 $1 不能为空。',
	'validator_error_must_be_number' => '参数 $1 只能为数字。',
	'validator_error_must_be_integer' => '参数 $1 只能为整数。',
	'validator_error_invalid_range' => '参数 $1 的范围必须介于 $2 与 $3 之间。',
	'validator_error_invalid_argument' => '值 $1 对于参数 $2 不合法。',
	'validator_list_error_empty_argument' => '参数 $1 不接受空值。',
	'validator_list_error_must_be_number' => '参数 $1 只能包含数字。',
	'validator_list_error_must_be_integer' => '参数 $1 只能包含整数。',
	'validator_list_error_invalid_range' => '参数 $1 所有合法的值都必须介于 $2 与 $3 之间。',
	'validator_list_error_invalid_argument' => '参数 $1 的一个或多个值不合法。',
);

