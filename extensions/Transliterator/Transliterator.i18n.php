<?php
/**
 * Internationalization file for Transliterator
 */

require_once( dirname(__FILE__) . '/Transliterator.i18n.magic.php' );

$messages = array();

/**
 * English
 * @author: Conrad.Irwin
 * @author: Purodha
 */
$messages['en'] = array(
	'transliterator-desc' => "Provides a configurable parser function for transliteration",
	'transliterator-prefix' => 'Transliterator:', // [[MediaWiki:Transliterator:blah]] NOTE: changing this requires moving all maps
	// $1 is the line from the map, 'a => z', $2 is the map-page including prefix.
	'transliterator-error-ambiguous' => "Ambiguous rule <code>$1</code> in [[MediaWiki:$2]]",
	'transliterator-error-syntax' => "Invalid syntax <code>$1</code> in [[MediaWiki:$2]]",
	// $1 is the limit on number of rules
	'transliterator-error-rulecount' => "More than $1 {{PLURAL:$1|rule|rules}} in [[MediaWiki:$2]]",
	// $3 is the limit on the length of the left hand side (e.g. 'alpha => beta' has 5)
	'transliterator-error-rulesize' => "Rule <code>$1</code> has more than $3 {{PLURAL:$3|character|characters}} on the left in [[MediaWiki:$2]]",
	// $1 is the minimum transliterator prefix length, $2 is the name of the message containing the prefix
	'transliterator-error-prefix' => "[[MediaWiki:$2]] must be at least $1 {{PLURAL:$1|character|characters}} long."
);

/** Message documentation (Message documentation)
 * @author Conrad.Irwin
 * @author Fryed-peach
 * @author Purodha
 */
$messages['qqq'] = array(
	'transliterator-desc' => 'This is a short description of the extension. It is shown in [[Special:Version]].',
	'transliterator-prefix' => "{{optional}}
This is a prefix for the transliteration maps, used in the MediaWiki namespace like [<nowiki />[MediaWiki:Transliterator:''blah'']]. Changing this requires moving all maps.",
	'transliterator-error-ambiguous' => 'Parameters:
* $1 is the line from the map, such as: <code>a => z</code>
* $2 is the map-page including the prefix {{msg-mw|transliterator-invoke}}',
	'transliterator-error-syntax' => 'Parameters:
* $1 is the line from the map, such as: <code>a => z</code>
* $2 is the map-page including the prefix {{msg-mw|transliterator-invoke}}',
	'transliterator-error-rulecount' => 'Parameters:
* $1 is the limit on number of rules
* $2 is the map-page including the prefix {{msg-mw|transliterator-invoke}}',
	'transliterator-error-rulesize' => 'Parameters:
* $1 is the line from the map, such as: <code>a => z</code>
* $2 is the map-page including the prefix {{msg-mw|transliterator-invoke}}
* $3 is the limit on the length of the left hand side (e.g. <code>alpha => beta</code> has 5)',
	'transliterator-error-prefix' => 'Parameters:
* $1 is the length of the shortest transliteration prefix, needs to be enforced due to performance concerns.
* $2 is the name of the transliterator-prefix message',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'transliterator-desc' => "Bied 'n instelbare ontlederfunksie vir transliterasie",
	'transliterator-error-ambiguous' => 'Dubbelsinnige reël <code>$1</code> in [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Ongeldige sintaks <code>$1</code> in [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Meer as $1 {{PLURAL:$1|reël|reëls}} in [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'Reël <code>$1</code> het meer as $3 {{PLURAL:$3|karakter|karakters}} aan die linkerkant in [[MediaWiki:$2]]',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'transliterator-desc' => 'يوفر دالة محلل قابلة للضبط للترجمة الحرفية',
	'transliterator-prefix' => 'مترجم حرفي:',
	'transliterator-error-ambiguous' => 'قاعدة غير واضحة <code>$1</code> في [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'صياغة غير صحيحة <code>$1</code> في [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'أكثر من $1 {{PLURAL:$1|قاعدة|قواعد}} في [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'القاعدة <code>$1</code> بها أكثر من $3 {{PLURAL:$3|حرف|حروف}} على اليسار في [[MediaWiki:$2]]',
	'transliterator-error-prefix' => '[[MediaWiki:$2]] يجب أن تكون $1 {{PLURAL:$1|حرف|حروف}} كطول.',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'transliterator-desc' => 'Дадае функцыю парсэра для трансьлітарацыі, якую магчыма канфігураваць',
	'transliterator-error-ambiguous' => 'Неадназначнае правіла <code>$1</code> у [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Няслушны сынтаксіс <code>$1</code> у [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Больш за $1 {{PLURAL:$1|правіла|правілы|правілаў}} у [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'Правіла <code>$1</code> мае больш за $3 {{PLURAL:$3|сымбаль у|сымбалі ў|сымбаляў у}} у левай частцы ў [[MediaWiki:$2]]',
	'transliterator-error-prefix' => '[[MediaWiki:$2]] павінен зьмяшчаць ня менш за $1 {{PLURAL:$1|сымбаль|сымбалі|сымбаляў}}.',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 */
$messages['br'] = array(
	'transliterator-desc' => "Pourchas a ra un arc'hwel dielfennañ arventennadus evit an treuzlizherenniñ",
	'transliterator-error-ambiguous' => 'Reolenn amjestr <code>$1</code> e [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Ereadur faziek <code>$1</code> e [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Ouzhpenn $1 {{PLURAL:$1|reolenn|reolenn}} e [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'Ouzhpenn $3 {{PLURAL:$3|arouezenn|arouezenn}} zo gant ar reolenn <code>$1</code> war an tu kleiz e [[MediaWiki:$2]]',
	'transliterator-error-prefix' => '[[MediaWiki:$2]] a rank bezañ ennañ $1 {{PLURAL:$1|arouezenn|arouezenn}} da nebeutañ.',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'transliterator-desc' => 'Omogućava podešavajući parser funkcije za transliteraciju',
	'transliterator-error-ambiguous' => 'Višeznačno pravilo <code>$1</code> u [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Nevaljana sintaksa <code>$1</code> u [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Ima više od $1 {{PLURAL:$1|pravila|pravila}} u [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'Pravilo <code>$1</code> ima više od $3 {{PLURAL:$3|znaka|znaka|znakova}} na lijevoj strani u [[MediaWiki:$2]]',
	'transliterator-error-prefix' => '[[MediaWiki:$2]] mora imati najmanje $1 {{PLURAL:$1|znak|znaka|znakova}}.',
);

/** Catalan (Català)
 * @author SMP
 */
$messages['ca'] = array(
	'transliterator-desc' => 'Proporciona una funció configurable per a fer transliteració',
	'transliterator-error-ambiguous' => 'Regla ambigua <code>$1</code> a [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Sintaxi incorrecta <code>$1</code> a [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Més {{PLURAL:$1|d\'una regla|de $3 regles}} a [[MediaWiki: $ 2]]',
	'transliterator-error-rulesize' => "La regla <code>$1</code> té més {{PLURAL:$3|d'un caràcter|de $3 caràcters}} a l'esquerra a [[MediaWiki:$2]]",
);

/** Czech (Česky)
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'transliterator-desc' => 'Poskytuje konfigurovatelnou funkci parseru pro transliteraci',
	'transliterator-error-ambiguous' => 'Nejednoznačné pravidlo <code>$1</code> v [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Neplatná syntaxe <code>$1</code> v [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Více než $1 {{PLURAL:$1|pravidlo|pravidla|pravidel}} v [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'Pravidlo <code>$1</code> má více než $3 {{PLURAL:$3|znak|znaky|znaků}} nalevo od [[MediaWiki:$2]]',
	'transliterator-error-prefix' => '[[MediaWiki:$2]] musí být dlouhé alespoň $1 {{PLURAL:$1|znak|znaky|znaků}}.',
);

/** German (Deutsch)
 * @author Als-Holder
 * @author Imre
 */
$messages['de'] = array(
	'transliterator-desc' => 'Stellt eine konfigurierbare Parserfunktion zur Transliteration bereit.',
	'transliterator-error-ambiguous' => 'Mehrdeutige Regel <code>$1</code> in [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Fehlerhafte Syntax in Regel <code>$1</code> in [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Mehr als die {{PLURAL:$1|erlaubte eine Regel|die erlaubten $1 Regeln}} in [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'In der Regel <code>$1</code> {{PLURAL:$3|ist|sind}} mehr als $3 Zeichen auf der linken Seite in [[MediaWiki:$2]]',
	'transliterator-error-prefix' => '[[MediaWiki:$2]] muss mindestens $1 {{PLURAL:$1|Zeichen|Zeichen}} lang sein.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'transliterator-desc' => 'Staja konfigurěrujobnu parserowu funkciju za transliteraciju k dispoziciji',
	'transliterator-error-ambiguous' => 'Dwójozmysłowe pšawidło <code>$1</code> w [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Njepłaśiwa syntaksa <code>$1</code> w [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Wěcej ako $1 {{PLURAL:$1|pšawidło|pšawidle|pšawidła|pšawidłow}} w [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'Pšawidło <code>$1</code> ma wěcej ako $3 {{PLURAL:$3|znamuško|znamušce|znamuška|znamuškow}} nalěwo w [[MediaWiki:$2]]',
	'transliterator-error-prefix' => '[[MediaWiki:$2]] dej nanejmjenjej $1 {{PLURAL:$1|znamuško|znamušce|znamuška|znamuškow}} dłujko byś.',
);

/** Greek (Ελληνικά)
 * @author Omnipaedista
 */
$messages['el'] = array(
	'transliterator-error-rulecount' => 'Περισσότεροι από $1 {{PLURAL:$1|κανόνα|κανόνες}} στο [[MediaWiki:$2]]',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Translationista
 */
$messages['es'] = array(
	'transliterator-desc' => 'Provee una función analizadora configurable para transliteración',
	'transliterator-error-ambiguous' => 'Regla ambigua <code>$1</code> en [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Sintaxis inválido <code>$1</code> en [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Más de $1 {{PLURAL:$1|regla|reglas}} en [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'Regla <code>$1</code> tiene más de $3 {{PLURAL:$3|caracter|caracteres}} en la izquierda en [[MediaWiki:$2]]',
	'transliterator-error-prefix' => '[[MediaWiki:$2]] debe tener al menos $1 {{PLURAL:$1|caracter|caracteres}} de largo.',
);

/** Finnish (Suomi)
 * @author Centerlink
 * @author Crt
 */
$messages['fi'] = array(
	'transliterator-error-ambiguous' => 'Sääntö <code>$1</code> ei ole yksiselitteinen sivulla [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Virheellinen syntaksi <code>$1</code> sivulla [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Enemmän kuin $1 {{PLURAL:$1|sääntö|sääntöä}} sivulla [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'Säännöllä <code>$1</code> on enemmän kuin $3 {{PLURAL:$3|merkki|merkkiä}} jäljellä sivulla [[MediaWiki:$2]]',
	'transliterator-error-prefix' => '[[MediaWiki:$2]] on oltava pituudeltaan vähintään $1 {{PLURAL:$1|merkki|merkkiä}}.',
);

/** French (Français)
 * @author Crochet.david
 * @author IAlex
 * @author PieRRoMaN
 */
$messages['fr'] = array(
	'transliterator-desc' => 'Fournit une fonction parseur configurable pour la translittération',
	'transliterator-error-ambiguous' => 'Règle ambiguë <code>$1</code> dans [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Syntaxe incorrecte <code>$1</code> dans [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Plus de $1 {{PLURAL:$1|règle|règles}} dans [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'La règle <code>$1</code> a plus de $3 {{PLURAL:$3|caractère|caractères}} sur la gauche dans [[MediaWiki:$2]]',
	'transliterator-error-prefix' => '[[MediaWiki:$2]] doit avoir au moins $1 caractères.',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'transliterator-desc' => 'Proporciona unha función analítica configurable para a transliteración',
	'transliterator-error-ambiguous' => 'Regra ambigua <code>$1</code> en [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Sintaxe incorrecta <code>$1</code> en [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Máis {{PLURAL:$1|dunha regra|de $1 regras}} en [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'A regra <code>$1</code> ten máis {{PLURAL:$3|dun carácter|de $3 caracteres}} á esquerda en [[MediaWiki:$2]]',
	'transliterator-error-prefix' => '[[MediaWiki:$2]] debe conter, polo menos, $1 {{PLURAL:$1|carácter|caracteres}}.',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'transliterator-desc' => 'Stellt e konfigurierbari Parserfunktion z Verfiegig fir s Transliteration.',
	'transliterator-error-ambiguous' => 'Mehdytigi Regle <code>$1</code> in [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Fählerhafti Syntax in Regle <code>$1</code> in [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Meh wie di {{PLURAL:$1|ei erlaubt Regle|erlaubte $1 Regle}} in [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'In dr Regle <code>$1</code> {{PLURAL:$3|isch|sin}} meh wie $3 Zeiche uf dr linke Syte in [[MediaWiki:$2]]',
	'transliterator-error-prefix' => '[[MediaWiki:$2]] muess zmindescht $1 {{PLURAL:$1|Zeiche|Zeiche}} lang syy.',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'transliterator-desc' => 'הוספת פונקציות פענוח לתעתוק',
	'transliterator-error-ambiguous' => 'כלל רב־משמעי <code>$1</code> בדף [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'תחביר שגוי <code>$1</code> בדף [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'יש יותר מ{{PLURAL:$1|כלל אחד|־$1 כללים}} בדף [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'בכלל <code>$1</code> יש יותר מ{{PLURAL:$3|תו אחד|־$3 תווים}} בשמאל בדף [[MediaWiki:$2]]',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'transliterator-desc' => 'Staja konfigurujomnu parserowu funkciju za transliteraciju k dispoziciji',
	'transliterator-error-ambiguous' => 'Dwuzmyslne prawidło <code>$1</code> w [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Njepłaćiwa syntaksa <code>$1</code> w [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Wjace hač $1 {{PLURAL:$1|prawidło|prawidle|prawidła|prawidłow}} w [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'Prawidło <code>$1</code> ma wjace hač $3 {{PLURAL:$3|znamješko|znamješce|znamješka|znamješkow}} nalěwo w [[MediaWiki:$2]]',
	'transliterator-error-prefix' => '[[MediaWiki:$2]] dyrbi znajmjeńša $1 {{PLURAL:$1|znamješko|znamješce|znamješka|znamješkow}} dołho być.',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'transliterator-desc' => 'Konfigurálható elemzőfüggvény átíráshoz',
	'transliterator-error-ambiguous' => 'Kétértelmű szabály (<code>$1</code>) itt: [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Érvénytelen szintaxis a(z) [[MediaWiki:$2]] lapon: <code>$1</code>',
	'transliterator-error-rulecount' => 'Több mint {{PLURAL:$1|egy|$1}} szabály itt: [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'A(z) <code>$1</code> szabályban több, mint {{PLURAL:$3|egy|$3}} karakter van a bal oldalon, itt: [[MediaWiki:$2]]',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'transliterator-desc' => 'Forni un function configurabile de analysator syntactic pro transliteration',
	'transliterator-error-ambiguous' => 'Regula ambigue <code>$1</code> in [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Syntaxe invalide <code>$1</code> in [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Plus de $1 {{PLURAL:$1|regula|regulas}} in [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'Le regula <code>$1</code> ha plus de $3 {{PLURAL:$3|character|characteres}} a sinistra in [[MediaWiki:$2]]',
	'transliterator-error-prefix' => '[[MediaWiki:$2]] debe haber al minus $1 {{PLURAL:$1|character|characteres}} de longitude.',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 */
$messages['id'] = array(
	'transliterator-desc' => 'Menyediakan fungsi parser yang dapat dikonfigurasi untuk transliterasi',
	'transliterator-error-ambiguous' => 'Aturan ambigu <code>$1</code> pada [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Sintaks tidak sah <code>$1</code> pada [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Lebih dari $1 {{PLURAL:$1||}}aturan pada [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'Aturan <code>$1</code> memiliki lebih dari $3 {{PLURAL:$3||}}karakter di sebelah kiri di [[MediaWiki:$2]]',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'transliterator-desc' => 'Fornisce una funzione configurabile del parser per la traslitterazione',
	'transliterator-error-ambiguous' => 'Regola ambigua <code>$1</code> in [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Sintassi <code>$1</code> non valida in [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Più di $1 {{PLURAL:$1|regola|regole}} in [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'Regola <code>$1</code> ha più di $3 {{PLURAL:$3|carattere|caratteri}} a sinistra in [[MediaWiki:$2]]',
);

/** Japanese (日本語)
 * @author Fryed-peach
 */
$messages['ja'] = array(
	'transliterator-desc' => '翻字のための設定可能なパーサー関数を提供する',
	'transliterator-error-ambiguous' => '曖昧な規則 <code>$1</code> が [[MediaWiki:$2]] にあります',
	'transliterator-error-syntax' => '不正な構文 <code>$1</code> が [[MediaWiki:$2]] にあります',
	'transliterator-error-rulecount' => '[[MediaWiki:$2]] には$1個を超える規則があります',
	'transliterator-error-rulesize' => '[[MediaWiki:$2]] の規則 <code>$1</code> は左辺に$3個を超える文字があります',
	'transliterator-error-prefix' => '[[MediaWiki:$2]] は最低でも$1文字の長さが必要です。',
);

/** Ripoarisch (Ripoarisch) */
$messages['ksh'] = array(
	'transliterator-desc' => 'Deiht en ennstellbaa Paaserfunxjuhn en et Wiki, di Boochshtabe tuusche kann.',
	'transliterator-error-ambiguous' => 'En unkloh Rejel <code>$1</code> es en [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'En kappodde Syntax <code>$1</code> es en [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Et {{PLURAL:$1|es mieh wi ein Rejel|sinn_er mieh wi $1 Rejelle|es kei Rejel}} en [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'En de Rejel <code>$1</code> {{PLURAL:$3|es|sinn_er}} mieh wi $3 Zeische op de lengke Sigg, en [[MediaWiki:$2]]',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'transliterator-desc' => 'liwwert eng Parser Fonctioun déi agestallt ka gi fir Transliteratioun',
	'transliterator-error-ambiguous' => 'Zweeeiteg Regel <code>$1</code> a [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Falsch Syntax <code>$1</code> a [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Méi wéi $1 {{PLURAL:$1|Regel|Regelen}} a [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => "D'Regel <code>$1</code> huet méi wéi $3 {{PLURAL:$3|Zeeche|Zeeche}} lenks a [[MediaWiki:$2]]",
	'transliterator-error-prefix' => '[[MediaWiki:$2]] muss mindestens $1 {{PLURAL:$1|Zeeche|Zeeche}} laang sinn.',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'transliterator-desc' => 'Овозможува прилагодлива парсер функција за транслитерација',
	'transliterator-error-ambiguous' => 'Двосмислено правило <code>$1</code> iво [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Грешна синтакса <code>$1</code> во [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Над $1 {{PLURAL:$1|правило|правила}} во [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'Правилото <code>$1</code> содржи повеќе од $3 {{PLURAL:$3|знак|знаци}} лево од [[MediaWiki:$2]]',
	'transliterator-error-prefix' => '[[MediaWiki:$2]] мора да биде со должина од барем $1 {{PLURAL:$1|знак|знаци}}.',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'transliterator-desc' => 'Biedt een instelbare parserlaag voor transliteratie',
	'transliterator-error-ambiguous' => 'Dubbelzinnige regel <code>$1</code> in [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Ongeldige syntaxis <code>$1</code> in [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Meer dan $1 {{PLURAL:$1|regel|regels}} in [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'Regel <code>$1</code> heeft meer dan $3 {{PLURAL:$3|teken|tekens}} aan de linkerkant in [[MediaWiki:$2]]',
	'transliterator-error-prefix' => '[[MediaWiki:$2]] moet tenminste $1 {{PLURAL:$1|teken|tekens}} lang zijn.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'transliterator-desc' => 'Gir en konfigurerbar parserfunksjon for transliterasjon',
	'transliterator-error-ambiguous' => 'Tvetydig regel <code>$1</code> i [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Ugyldig syntaks <code>$1</code> i [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Mer enn {{PLURAL:$1|én regel|$1 regler}} i [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'Regelen <code>$1</code> har mer enn {{PLURAL:$3|ett tegn|$3 tegn}} til venstre i [[MediaWiki:$2]]',
	'transliterator-error-prefix' => '[[MediaWiki:$2]] må være minst {{PLURAL:$1|ett tegn|$1 tegn}} langt.',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'transliterator-desc' => 'Provesís una foncion parser configurabla per la transliteracion',
	'transliterator-error-ambiguous' => 'Règla ambigua <code>$1</code> dins [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Sintaxi incorrècta <code>$1</code> dins [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Mai de $1 {{PLURAL:$1|règla|règlas}} dins [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => "La règla <code>$1</code> a mai de $3 {{PLURAL:$3|caractèr|caractèrs}} sus l'esquèrra dins [[MediaWiki:$2]]",
	'transliterator-error-prefix' => '[[MediaWiki:$2]] deu aver al mens $1 {{PLURAL:$1|caractèr|caractèrs}}.',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'transliterator-desc' => 'Dodaje funkcję analizatora składni do transliteracji',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'transliterator-desc' => 'A dà na funsion configurabla dël parser për la trasliterassion',
	'transliterator-error-ambiguous' => 'Régola ambigua <code>$1</code> an [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Sintassi pa bon-a <code>$1</code> an [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Pì che $1 {{PLURAL:$1|régole|régole}} an [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => "La régola <code>$1</code> a l'ha pì che $3 {{PLURAL:$3|caràter|caràter}} an sla snista ëd [[MediaWiki:$2]]",
	'transliterator-error-prefix' => '[[MediaWiki:$2]] a dev esse longh almanch $1 {{PLURAL:$1|caràter|caràter}}.',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'transliterator-desc' => 'Fornece uma função de análise sintáctica configurável, para transliteração',
	'transliterator-error-ambiguous' => 'Regra ambígua <code>$1</code> em [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Sintaxe inválida <code>$1</code> em [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Mais de {{PLURAL:$1|uma regra|$1 regras}} em [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'A regra <code>$1</code> tem mais de {{PLURAL:$3|um carácter|$3 caracteres}} à esquerda em [[MediaWiki:$2]]',
	'transliterator-error-prefix' => '[[MediaWiki:$2]] tem de ter pelo menos {{PLURAL:$1|um caracter|$1 caracteres}}.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'transliterator-desc' => 'Provê uma função de análise configurável para transliteração',
	'transliterator-error-ambiguous' => 'Regra ambígua <code>$1</code> em [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Sintaxe inválida <code>$1</code> em [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Mais de $1 {{PLURAL:$1|regra|regras}} em [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'Regra <code>$1</code> tem mais que $3 {{PLURAL:$3|caracter|caracteres}} à esquerda em [[MediaWiki:$2]]',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'transliterator-desc' => 'Обеспечивает настраиваемую функцию парсера для транслитерации',
	'transliterator-error-ambiguous' => 'Неоднозначно правило <code>$1</code> в [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Ошибочный синтаксис <code>$1</code> в [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Более $1 {{PLURAL:$1|правила|правил|правил}} в [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'Правило <code>$1</code> содержит более $3 {{PLURAL:$3|символа|символов|символов}} слева в [[MediaWiki:$2]]',
	'transliterator-error-prefix' => '[[MediaWiki:$2]] должно быть длиной не менее $1 {{PLURAL:$1|символа|символов|символов}}.',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'transliterator-desc' => 'Poskytuje konfigurovateľnú funkciu syntaktického analyzátora na transliteráciu',
	'transliterator-error-ambiguous' => 'Nejednoznačné pravidlo <code>$1</code> v [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Chybná syntax <code>$1</code> v [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Viac než $1 {{PLURAL:$1|pravidlo|pravidlá|pravidiel}} v [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'Pravidlo <code>$1</code> má viac než $3 {{PLURAL:$3|znak|znaky|znakov}} naľavo v [[MediaWiki:$2]]',
);

/** Swedish (Svenska)
 * @author Ozp
 * @author Per
 */
$messages['sv'] = array(
	'transliterator-desc' => 'Tillhandahåller en konfigurerbar parserfunktion för transkribering',
	'transliterator-error-ambiguous' => 'Tvetydig regel <code>$1</code> i [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Ogiltig syntax <code>$1</code> i [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Mer än {{PLURAL:$1|en regel|$1 regler}} i  [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'Regeln <code>$1</code> har mer än {{PLURAL:$3|ett tecken|$3 tecken}} på vänster sida i [[MediaWiki:$2]]',
	'transliterator-error-prefix' => '[[MediaWiki:$2]] måste vara minst {{PLURAL:$1|ett tecken|$1 tecken}} långt.',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'transliterator-desc' => 'Cung cấp hàm cú pháp thiết kế được để chuyển tự',
	'transliterator-error-ambiguous' => 'Quy tắc không rõ <code>$1</code> trong [[MediaWiki:$2]]',
	'transliterator-error-syntax' => 'Cú pháp không hợp lệ <code>$1</code> trong [[MediaWiki:$2]]',
	'transliterator-error-rulecount' => 'Hơn $1 quy tắc trong [[MediaWiki:$2]]',
	'transliterator-error-rulesize' => 'Quy tắc <code>$1</code> có hơn $3 ký tự vào bên trái trong [[MediaWiki:$2]]',
);

