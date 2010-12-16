<?php
/**
 * Internationalisation file for the RefreshSpecial extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Bartek Łapiński
 */
$messages['en'] = array(
	'refreshspecial' => 'Refresh special pages',
	'refreshspecial-desc' => 'Allows [[Special:RefreshSpecial|manual special page refresh]] of special pages',
	'refreshspecial-title' => 'Refresh special pages',
	'refreshspecial-help' => 'This special page provides means to manually refresh special pages.
When you have chosen all pages that you want to refresh, click on the "Refresh selected" button below to refresh the selected special pages.
\'\'\'Warning:\'\'\' The refresh may take a while on larger wikis.',
	'refreshspecial-button' => 'Refresh selected',
	'refreshspecial-fail' => 'Please check at least one special page to refresh.',
	'refreshspecial-refreshing' => 'refreshing special pages',
	'refreshspecial-skipped' => 'cheap, skipped',
	'refreshspecial-choice' => 'refreshing special pages',
	'refreshspecial-js-disabled' => '(<i>You cannot select all pages when JavaScript is disabled</i>)',
	'refreshspecial-select-all-pages' => 'Select all pages',
	'refreshspecial-link-back' => 'Go back to special page',
	'refreshspecial-none-selected' => 'You have not selected any special pages. Reverting to default selection.',
	'refreshspecial-db-error' => 'Failed: Database error',
	'refreshspecial-no-page' => 'No such special page',
	'refreshspecial-slave-lagged' => 'Slave lagged, waiting...',
	'refreshspecial-reconnected' => 'Reconnected.',
	'refreshspecial-reconnecting' => 'Connection failed, reconnecting in 10 seconds...',
	'refreshspecial-page-result' => 'got $1 {{PLURAL:$1|row|rows}} in',
	'refreshspecial-total-display' => 'Refreshed $1 {{PLURAL:$1|page|pages}} totaling $2 {{PLURAL:$2|row|rows}} in time $3 (complete time of the script run is $4)',
	'right-refreshspecial' => 'Refresh special pages',
);

/** Message documentation (Message documentation)
 * @author Darth Kule
 * @author Fryed-peach
 * @author Purodha
 * @author Siebrand
 */
$messages['qqq'] = array(
	'refreshspecial' => '{{Identical|Refresh special pages}}
Title of Special:RefreshSpecial as displayed on Special:SpecialPages.',
	'refreshspecial-desc' => 'Shown in [[Special:Version]] as a short description of this extension. Do not translate links.',
	'refreshspecial-title' => '{{Identical|Refresh special pages}}
Title of the special page Special:RefreshSpecial',
	'refreshspecial-help' => 'Help displayed to the user on Special:RefreshSpecial. "Refresh selected" comes from {{msg-mw|refreshspecial-button}}.',
	'refreshspecial-button' => 'Text displayed on the button on Special:RefreshSpecial. Clicking on the button refreshes the selected special pages.',
	'refreshspecial-fail' => 'Failure message displayed if no special pages were checked to refresh.',
	'refreshspecial-refreshing' => '{{Identical|Refreshing special pages}}
Text displayed in the subtitle below the actual page title once the user has pressed the "Refresh selected" button.',
	'refreshspecial-choice' => '{{Identical|Refreshing special pages}}',
	'refreshspecial-js-disabled' => 'Displayed to users with JavaScript disabled so that they won\'t wonder why the "select all pages" checkbox isn\'t working properly.',
	'refreshspecial-select-all-pages' => 'Text displayed next to a checkbox on Special:RefreshSpecial; checking the checkbox allows to select all listed pages.',
	'refreshspecial-link-back' => 'Displayed on Special:RefreshSpecial after the user has pressed the "Refresh selected" button, at the bottom of the page.',
	'refreshspecial-none-selected' => 'If the user pressed the "Refresh selected" button without checking any of the checkboxes, this message will be displayed to him/her.',
	'refreshspecial-db-error' => 'Error message shown to the user if a database error is encountered while trying to do the necessary queries.',
	'refreshspecial-no-page' => 'If an invalid special page is encountered, this message will be displayed.',
	'refreshspecial-slave-lagged' => 'Displayed if a slave database server is lagging',
	'refreshspecial-reconnected' => 'Displayed if the connection to the database was lost for some reason but the extension was able to reconnect to it.',
	'refreshspecial-reconnecting' => 'Displayed if the connection to the database was lost for some reason.',
	'refreshspecial-page-result' => 'Displayed on Special:RefreshSpecial after the user has pressed the "Refresh selected" button and results were gotten from the DB.',
	'refreshspecial-total-display' => 'Displayed on Special:RefreshSpecial after the user has pressed the "Refresh selected" button if the refreshing was done successfully. $1 is the amount of special pages refreshed, $2 is the amount of database rows touched, $3 is the time how long it took to refresh all the selected special pages and $4 is the complete time of the script run.',
	'right-refreshspecial' => '{{doc-right}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'refreshspecial' => 'Verfris spesiale bladsye',
	'refreshspecial-title' => 'Verfris spesiale bladsye',
	'refreshspecial-refreshing' => 'besig met die verfris van spesiale bladsye',
	'refreshspecial-choice' => 'besig met die verfris van spesiale bladsye',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'refreshspecial' => 'تحديث الصفحات الخاصة',
	'refreshspecial-desc' => 'يسمح [[Special:RefreshSpecial|بتحديث يدوي]] للصفحات الخاصة',
	'refreshspecial-title' => 'تحديث الصفحات الخاصة',
	'refreshspecial-help' => 'هذه الصفحة الخاصة توفر الوسيلة لتحديث الصفحات الخاصة يدويا.
عندما تختار كل الصفحات التي تريد تحديثها، اضغط على زر "تحديث المختارة" بالأسفل لتحديث الصفحات الخاصة المختارة.
تحذير: التحديث ربما يأخذ وقتا في الويكيات الكبيرة.',
	'refreshspecial-button' => 'تحديث المختارة',
	'refreshspecial-fail' => 'من فضلك علم على صفحة خاصة واحدة على الأقل للتحديث.',
	'refreshspecial-refreshing' => 'جاري تحديث الصفحات الخاصة',
	'refreshspecial-skipped' => 'رخيصة، تم تجاوزها',
	'refreshspecial-choice' => 'تحديث الصفحات الخاصة',
	'refreshspecial-js-disabled' => '(<i>أنت لا يمكنك اختيار كل الصفحات عندما تكون الجافاسكريبت معطلة</i>)',
	'refreshspecial-select-all-pages' => 'اختر كل الصفحات',
	'refreshspecial-link-back' => 'رجوع إلى الامتداد',
	'refreshspecial-none-selected' => 'أنت لم تختر أي صفحة خاصة. استرجاع إلى الاختيار الافتراضي.',
	'refreshspecial-db-error' => 'فشل: خطأ قاعدة بيانات',
	'refreshspecial-no-page' => 'لا توجد صفحة خاصة كهذه',
	'refreshspecial-slave-lagged' => 'الخادم التابع تأخر، جاري الانتظار...',
	'refreshspecial-reconnected' => 'تمت إعادة التوصيل.',
	'refreshspecial-reconnecting' => 'التوصيل فشل، إعادة التوصيل خلال 10 ثواني...',
	'refreshspecial-page-result' => 'حصل على {{PLURAL:$1||صف واحد|صفين|$1 صفوف|$1 صفًا|$1 صف}} في',
	'refreshspecial-total-display' => 'حدث {{PLURAL:$1||صفحة واحدة|صفحتين|$1 صفحات|$1 صفحة}} بإجمالي {{PLURAL:$2||صف واحد|صفين|$2 صفوف|$2 صفًا|$2 صف}} في زمن مقداره $3 (الوقت الإجمالي لتشغيل السكريبت هو $4)',
	'right-refreshspecial' => 'إنعاش الصفحات الخاصة',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'refreshspecial-select-all-pages' => 'ܓܒܝ ܟܠ ܦܐܬܬ̈ܐ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 */
$messages['arz'] = array(
	'refreshspecial' => 'تحديث الصفحات الخاصة',
	'refreshspecial-desc' => 'يسمح [[Special:RefreshSpecial|بتحديث يدوي]] للصفحات الخاصة',
	'refreshspecial-title' => 'تحديث الصفحات الخاصة',
	'refreshspecial-help' => 'الصفحة الخاصة دى بتوفر الوسيلة لتحديث الصفحات الخاصة يدويا. لما تختار كل الصفحات اللى عايز تحدثها، اضغط على زر التحديث تحت
. تحذير: التحديث ربما ياخد وقت فى الويكيات الكبيرة.',
	'refreshspecial-button' => 'تحديث المختارة',
	'refreshspecial-fail' => 'من فضلك علم على صفحة خاصة واحدة على الأقل للتحديث.',
	'refreshspecial-refreshing' => 'جارى تحديث الصفحات الخاصة',
	'refreshspecial-skipped' => 'رخيصة، تم تجاوزها',
	'refreshspecial-choice' => 'تحديث الصفحات الخاصة',
	'refreshspecial-js-disabled' => '(<i>أنت لا يمكنك اختيار كل الصفحات عندما تكون الجافاسكريبت معطلة</i>)',
	'refreshspecial-select-all-pages' => 'اختار كل الصفحات',
	'refreshspecial-link-back' => 'رجوع إلى الامتداد',
	'refreshspecial-none-selected' => 'أنت لم تختر أى صفحة خاصة. استرجاع إلى الاختيار الافتراضى.',
	'refreshspecial-db-error' => 'فشل: خطأ قاعدة بيانات',
	'refreshspecial-no-page' => 'لا توجد صفحة خاصة كهذه',
	'refreshspecial-slave-lagged' => 'الخادم التابع تأخر، جارى الانتظار...',
	'refreshspecial-reconnected' => 'تمت إعادة التوصيل.',
	'refreshspecial-reconnecting' => 'التوصيل فشل، إعادة التوصيل خلال 10 ثوانى...',
	'refreshspecial-page-result' => 'حصل على $1 {{PLURAL:$1|صف|صف}} فى',
	'refreshspecial-total-display' => 'تحديث $1 {{PLURAL:$1|صفحة|صفحة}} بإجمالى $2 {{PLURAL:$2|صف|صف}} فى وقت $3 (الزمن الإجمالى لعمل السكريبت هو $4)',
	'right-refreshspecial' => 'إنعاش الصفحات الخاصة',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'refreshspecial' => 'Абнавіць спэцыяльныя старонкі',
	'refreshspecial-desc' => 'Дазваляе [[Special:RefreshSpecial|ручное абнаўленьне]] спэцыяльных старонак',
	'refreshspecial-title' => 'Абнаўленьне спэцыяльныя старонкі',
	'refreshspecial-help' => 'Гэта спэцыяльная старонка дазваляе абнаўляць спэцыяльныя старонкі ў ручным рэжыме.
Калі Вы выберыце ўсе старонкі, якія Вы жадаеце абнавіць, націсьніце кнопку «Абнавіць выбраныя» унізе, каб абнавіць іх.
Увага: абнаўленьне можа патрабаваць пэўны час у вялікіх вікі.',
	'refreshspecial-button' => 'Абнавіць выбраныя',
	'refreshspecial-fail' => 'Калі ласка, пазначце хаця б адну спэцыяльную старонку для абнаўленьня.',
	'refreshspecial-refreshing' => 'абнаўленьне спэцыяльных старонак',
	'refreshspecial-skipped' => 'няважнае, прапушчанае',
	'refreshspecial-choice' => 'абнаўленьне спэцыяльных старонак',
	'refreshspecial-js-disabled' => '(<i>Вы ня можаце выбраць усе старонкі, калі JavaScript адключаны</i>)',
	'refreshspecial-select-all-pages' => 'Выбраць усе старонкі',
	'refreshspecial-link-back' => 'Вярнуцца на спэцыяльную старонку',
	'refreshspecial-none-selected' => 'Вы ня выбралі ніякай спэцыяльнай старонкі. Вярнуцца да выбару па змоўчваньні.',
	'refreshspecial-db-error' => 'Памылка базы зьвестак',
	'refreshspecial-no-page' => 'Няма такой спэцыяльнай старонкі',
	'refreshspecial-slave-lagged' => 'Праблемы сувязі з падпарадкаванай сыстэмай. Калі ласка, пачакайце...',
	'refreshspecial-reconnected' => 'Перадалучэньне.',
	'refreshspecial-reconnecting' => 'Памылка злучэньня, перадалучэньне праз 10 сэкундаў...',
	'refreshspecial-page-result' => '{{PLURAL:$1|атрыманы $1 радок у|атрыманыя $1 радкі ў|атрыманыя $1 радкоў у}}',
	'refreshspecial-total-display' => '{{PLURAL:$1|Адноўленая $1 старонка|Адноўленыя $1 старонкі|Адноўленыя $1 старонак}} уключаючы $2 {{PLURAL:$2|радок|радкі|радкоў}} за $3 (поўны час выкананьня скрыпта $4)',
	'right-refreshspecial' => 'Абнавіць спэцыяльныя старонкі',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'refreshspecial-select-all-pages' => 'Избиране на всички страници',
	'refreshspecial-no-page' => 'Няма такава специална страница',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'refreshspecial' => 'Freskaat ar bajennoù ispisial',
	'refreshspecial-desc' => 'Aotreañ a ra ar [[Special:RefreshSpecial|freskadur gant an dorn]] eus ar bajennoù ispisial',
	'refreshspecial-title' => 'Freskaat ar pajennoù arbennik',
	'refreshspecial-help' => "Ar bajenn ispisial-mañ a ro an tro da freskaat pajennoù ispisial gant an dorn.
P'ho peus dibabet an holl pajennoù ho peus c'hoant freskaat klikit war \"Freskaat\" amañ dindan evit diskouez ar bajennoù dibabet.
'''Diwallit :''' war ar wikioù bras e c'hell padout an traoù un tamm.",
	'refreshspecial-button' => 'Freskaat ar re ziuzet',
	'refreshspecial-fail' => "Mar plij gevaskit ur bajenn ispisial da freskaat d'an nebeutañ.",
	'refreshspecial-refreshing' => 'o freskaat ar pajennoù arbennik',
	'refreshspecial-skipped' => 'diwar gorre, lammet',
	'refreshspecial-choice' => 'o freskaat pajennoù ispisial',
	'refreshspecial-js-disabled' => "(<i>Ne c'helloc'h ket dibab an holl pajennoù pa 'z eo diweredekaet JavaScript</i>)",
	'refreshspecial-select-all-pages' => 'Diuzañ an holl bajennoù',
	'refreshspecial-link-back' => "Distreiñ d'ar bajennoù ispisial",
	'refreshspecial-none-selected' => "N'ho peus dibabet pajenn ispisial ebet. Distro davet an dibab dre ziouer.",
	'refreshspecial-db-error' => "C'hwitet : fazi gant an diaz roadennoù",
	'refreshspecial-no-page' => "N'eus ket a bajenn ispisial",
	'refreshspecial-slave-lagged' => 'Dale war ar servijer sklav, o gortoz...',
	'refreshspecial-reconnected' => 'Adkevreet.',
	'refreshspecial-reconnecting' => "N'oc'h ket bet kevreadet, adkevreadenn a-benn 10 eilenn...",
	'refreshspecial-page-result' => 'Kaout $1 {{PLURAL:$1|linenn |linenn}} e',
	'refreshspecial-total-display' => '$1 pajenn freskaet{{PLURAL:$1||}} evit un hollad a $2 linenn{{PLURAL:$2||}} e-pad $3 (sevenadur hollek ar skript en deus padet $4)',
	'right-refreshspecial' => 'Freskaat ar pajennoù arbennik',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'refreshspecial' => 'Osvježenje posebnih stranica',
	'refreshspecial-desc' => 'Omogućava [[Special:RefreshSpecial|posebnu stranicu za ručno osvježavanje]] posebnih stranica',
	'refreshspecial-title' => 'Osvježi posebne stranice',
	'refreshspecial-help' => "Ova posebna stranica omogućuje da se ručno osvježe posebne stranice.
Kada odaberete sve stranice koje želite osvježiti, kliknite dugme \"Odabrano osvježavanje\" ispod za osvježavanje odabranih posebnih stranica.
'''Upozorenje:''' Osvježavanje može duže trajati na većim wikijima.",
	'refreshspecial-button' => 'Odabrano osvježavanje',
	'refreshspecial-fail' => 'Molimo odaberite najmanje jednu posebnu stranicu za osvježavanje.',
	'refreshspecial-refreshing' => 'osvježavam specijalne stranice',
	'refreshspecial-skipped' => 'nevažno, preskočeno',
	'refreshspecial-choice' => 'osvježavam posebne stranice',
	'refreshspecial-js-disabled' => '(<i>Ne možete odabrati sve stranice ako je JavaScript onemogućen</i>)',
	'refreshspecial-select-all-pages' => 'Odaberi sve stranice',
	'refreshspecial-link-back' => 'Idi nazad na posebne stranice',
	'refreshspecial-none-selected' => 'Niste odabrali nijednu posebnu stranicu. Vraćam na pretpostavljeni odabir.',
	'refreshspecial-db-error' => 'Neuspjelo: greška baze podataka',
	'refreshspecial-no-page' => 'Nema takve specijalne stranice',
	'refreshspecial-slave-lagged' => 'Zastoj pomoćnog servera, čekam...',
	'refreshspecial-reconnected' => 'Ponovno spojeno.',
	'refreshspecial-reconnecting' => 'Spajanje nije uspjelo, ponovno spajanje za 10 sekundi...',
	'refreshspecial-page-result' => 'ima $1 {{PLURAL:$1|red|reda|redova}} u',
	'refreshspecial-total-display' => 'Osvježeno $1 {{PLURAL:$1|stranica|stranice|stranica}} ukupno $2 {{PLURAL:$2|red|reda|redova}} u vremenu $3 (ukupno vrijeme pokretanja skripte je $4)',
	'right-refreshspecial' => 'Osvježavanje posebnih stranica',
);

/** Catalan (Català)
 * @author Solde
 */
$messages['ca'] = array(
	'refreshspecial-select-all-pages' => 'Selecciona totes les pàgines',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'refreshspecial' => 'Obnovit speciální stránky',
	'refreshspecial-desc' => 'Umožňuje [[Special:RefreshSpecial|ruční obnovení speciálních stránek]]',
	'refreshspecial-title' => 'Obnovit speciální stránky',
	'refreshspecial-help' => 'Tato speciální stránka slouží k manuálnímu obnovení speciálních stránek.
Po vybrání všech stránek, které chcete obnovit, klikněte na tlačítko „Obnovit vybrané”.
Upozornění: na větších wiki může obnovení chvíli trvat.',
	'refreshspecial-button' => 'Obnovit vybrané',
	'refreshspecial-fail' => 'Prosím, vyberte alespoň jednu speciální stránku, která se má obnovit',
	'refreshspecial-refreshing' => 'obnovují se speciální stránky',
	'refreshspecial-skipped' => 'přeskočeno',
	'refreshspecial-choice' => 'obnovují se speciální stránky',
	'refreshspecial-js-disabled' => '(<i>Není možné použít funkci výběru všech stránek, pokud máte vypnutý JavaScript</i>)',
	'refreshspecial-select-all-pages' => 'Vybrat všechny stránky',
	'refreshspecial-link-back' => 'Zpět na rozšíření',
	'refreshspecial-none-selected' => 'Nevybrali jste žádné speciální stránky. Vrací se původní výběr.',
	'refreshspecial-db-error' => 'Chyba: chyba databáze',
	'refreshspecial-no-page' => 'Taková speciální stránka neexistuje',
	'refreshspecial-slave-lagged' => 'Replikovaný databázový server je zpožděn, čeká se…',
	'refreshspecial-reconnected' => 'Znovu připojený.',
	'refreshspecial-reconnecting' => 'Spojení selhalo, opětovné připojení za 10 sekund…',
	'refreshspecial-page-result' => '{{PLURAL:$1|zpracován $1 řádek|zpracovány $1 řádky|zpracováno $1 řádků}} za',
	'refreshspecial-total-display' => '{{PLURAL:$1|Obnovena $1 stránka|Obnoveny $1 stránky|Obnoveno $1 stránek}}, což činí $2 {{PLURAL:$2|řádek|řádky|řádků}} za čas $3 (celkový čas běhu skriptu je $4)',
	'right-refreshspecial' => 'Obnovování speciálních stránek',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author MF-Warburg
 * @author Melancholie
 * @author Purodha
 * @author Revolus
 * @author Umherirrender
 */
$messages['de'] = array(
	'refreshspecial' => 'Spezialseiten aktualisieren',
	'refreshspecial-desc' => 'Erlaubt das [[Special:RefreshSpecial|manuelle Auffrischen von Spezialseiten]]',
	'refreshspecial-title' => 'Spezialseiten aktualisieren',
	'refreshspecial-help' => 'Diese Spezialseite stellt ein Werkzeug zum manuellen Aktualisieren der Spezialseiten bereit.
Sobald du alle Spezialseiten zum Aktualisieren ausgewählt hast, drücke die Aktualisieren-Schaltfläche, um die Aktualisierung zu starten.
Achtung: Das Aktualisieren kann auf großen Wikis länger dauern.',
	'refreshspecial-button' => 'ausgewählte auffrischen',
	'refreshspecial-fail' => 'Bitte hake mindestens eine Spezialseite zum Auffrischen an.',
	'refreshspecial-refreshing' => 'Spezialseiten werden aktualisiert',
	'refreshspecial-skipped' => 'wertlos, übersprungen',
	'refreshspecial-choice' => 'aktualisiere Spezialseiten',
	'refreshspecial-js-disabled' => '(<i>Du kannst nicht alle Seiten auswählen, wenn du Javascript deaktiviert hast</i>)',
	'refreshspecial-select-all-pages' => 'Alle Seiten auswählen',
	'refreshspecial-link-back' => 'Zurück zur Erweiterung',
	'refreshspecial-none-selected' => 'Du hast keine Spezialseiten ausgewählt; somit Zurücksetzung auf die Standardauswahl.',
	'refreshspecial-db-error' => 'Störung: Datenbankfehler',
	'refreshspecial-no-page' => 'Keine solche Spezialseite',
	'refreshspecial-slave-lagged' => 'Slave-Server hängt hinterher, warten …',
	'refreshspecial-reconnected' => 'Wiederverbunden.',
	'refreshspecial-reconnecting' => 'Verbindung fehlgeschlagen, wiederverbinde in 10 Sekunden …',
	'refreshspecial-page-result' => 'enthält {{PLURAL:$1|eine Reihe|$1 Reihen}} in',
	'refreshspecial-total-display' => 'Aktualisierte $1 {{PLURAL:$1|Seite|Seiten}}, insgesamt $2 {{PLURAL:$2|Zeile|Zeilen}} in einer Zeit von $3 (Gesamtlaufzeit des Skripts: $4)',
	'right-refreshspecial' => 'Spezialseiten aktualisieren',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author Imre
 * @author Revolus
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'refreshspecial-help' => 'Diese Spezialseite stellt ein Werkzeug zum manuellen Aktualisieren der Spezialseiten bereit.
Sobald Sie alle Spezialseiten zum Aktualisieren ausgewählt haben, drücken Sie die Aktualisieren-Schaltfläche, um die Aktualisierung zu starten.
Achtung: Das Aktualisieren kann auf großen Wikis länger dauern.',
	'refreshspecial-fail' => 'Bitte haken Sie mindestens eine Spezialseite zum Auffrischen ab.',
	'refreshspecial-js-disabled' => '(<i>Sie können nicht alle Seiten auswählen, wenn Sie Javascript deaktiviert haben</i>)',
	'refreshspecial-none-selected' => 'Sie haben keine Spezialseiten ausgewählt; somit Zurücksetzung auf die Standardauswahl.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'refreshspecial' => 'Specialne boki wobnowiś',
	'refreshspecial-desc' => 'Zmóžnja [[Special:RefreshSpecial|manuelne wobnowjenje specialnych bokow]]',
	'refreshspecial-title' => 'Specialne boki wobnowiś',
	'refreshspecial-help' => 'Toś ten specialny bok staja rěd za manuelne wobnowjenje specialnych bokow k dispoziciji.
Gaž sy wubrał wše boki, kótarež coš wobnowiś, klikni na tłocašk "Wubrane wobnowiś" dołojce, aby wobnowił specialne wubrane boki.
Warnowanje: Wobnowjenje móžo na wjelikich wikijach wobdłujko traś.',
	'refreshspecial-button' => 'Wubrane wobnowiś',
	'refreshspecial-fail' => 'Pšosym wubjeŕ nanejmjenjej jaden specialny bok za wobnowjenje.',
	'refreshspecial-refreshing' => 'specialne boki se wobnowjaju',
	'refreshspecial-skipped' => 'bźeze gódnoty, pśeskocony',
	'refreshspecial-choice' => 'specialne boki se wobnowjaju',
	'refreshspecial-js-disabled' => '(<i>Njamóžoš wše boki wubraś, gaž JavaScript jo znjemóžnjony</i>)',
	'refreshspecial-select-all-pages' => 'Wše boki wubraś',
	'refreshspecial-link-back' => 'Slědk k specialnemu bokoju',
	'refreshspecial-none-selected' => 'Njejsy wubrał specialne boki. Wrośenje k standardnemu wuběrkoju.',
	'refreshspecial-db-error' => 'Njewuspěch: zmólka datoweje banki',
	'refreshspecial-no-page' => 'Žeden taki specialny bok',
	'refreshspecial-slave-lagged' => 'Serwer slave jo pómały, caka se...',
	'refreshspecial-reconnected' => 'Znowego zwězany.',
	'refreshspecial-reconnecting' => 'Zwisk jo se njeraźił, znowegozwězowanje za 10 sekundow...',
	'refreshspecial-page-result' => 'wopśimujo $1 {{PLURAL:$1|rěd|rěda|rědy|rědow}} w',
	'refreshspecial-total-display' => 'Som wobnowił $1 {{PLURAL:$1|bok|boka|boki|bokow}}, dogromady $2 {{PLURAL:$2|rěd|rěda|rědy|rědow}} w casu $3 (ceły cas běga jo $4)',
	'right-refreshspecial' => 'Specialne boki wobnowiś',
);

/** Greek (Ελληνικά)
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'refreshspecial' => 'Ανανέωση ειδικών σελίδων',
	'refreshspecial-title' => 'Ανανέωση ειδικών σελίδων',
	'refreshspecial-button' => 'Επιλέχθηκε ανανέωση',
	'refreshspecial-refreshing' => 'ανανέωση ειδικών σελίδων',
	'refreshspecial-skipped' => 'φθηνό, παρακάμφθηκε',
	'refreshspecial-choice' => 'ανανέωση ειδικών σελίδων',
	'refreshspecial-select-all-pages' => 'Επιλογή όλων των σελίδων',
	'refreshspecial-link-back' => 'Πήγαινε πίσω στην ειδική σελίδα',
	'refreshspecial-db-error' => 'Απέτυχε: Σφάλμα βάσης δεδομένων',
	'refreshspecial-no-page' => 'Καμιά τέτοια ειδική σελίδα',
	'refreshspecial-reconnected' => 'Επανασυνδέθηκε.',
	'refreshspecial-reconnecting' => 'Η σύνδεση απέτυχε, επανασύνδεση σε 10 δευτερόλεπτα...',
	'refreshspecial-page-result' => 'πήρε $1 {{PLURAL:$1|σειρά|σειρές}} σε',
	'right-refreshspecial' => 'Ανανέωση ειδικών σελίδων',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'refreshspecial' => 'Refreŝigi specialajn paĝojn',
	'refreshspecial-desc' => 'Permesas [[Special:RefreshSpecial|permanan refreŝigon de specialaj paĝoj]]',
	'refreshspecial-title' => 'Refreŝigi specialajn paĝojn',
	'refreshspecial-button' => 'Refreŝigi selektaĵojn',
	'refreshspecial-refreshing' => 'refreŝigante specialajn paĝojn',
	'refreshspecial-choice' => 'refreŝigante specialajn paĝojn',
	'refreshspecial-js-disabled' => '(<i>Vi ne povas selekti ĉiujn paĝojn kiam JavaScript estas malŝalta</i>)',
	'refreshspecial-select-all-pages' => 'Selekti ĉiujn paĝojn',
	'refreshspecial-link-back' => 'Reiri al speciala paĝo',
	'refreshspecial-none-selected' => 'Vi ne selektis iujn ajn specialajn paĝojn. Reŝanĝante al defaŭlta selekto.',
	'refreshspecial-db-error' => 'Malsukcesis: Datenbaza eraro',
	'refreshspecial-no-page' => 'Nenia speciala paĝo',
	'refreshspecial-reconnected' => 'Rekonektita.',
	'refreshspecial-reconnecting' => 'Konekto malsukcesis; rekonekante en 10 sekundoj...',
	'right-refreshspecial' => 'Refreŝigi specialajn paĝojn',
);

/** Spanish (Español)
 * @author Antur
 * @author Crazymadlover
 * @author Translationista
 */
$messages['es'] = array(
	'refreshspecial' => 'Refrescar páginas especiales',
	'refreshspecial-desc' => 'Permite [[Special:RefreshSpecial|refrescamiento de paginas especiales manualmente]] de paginas especiales',
	'refreshspecial-title' => 'Refrescar páginas especiales',
	'refreshspecial-help' => "Esta página especial provee las herramientas necesarias para volver a cargar páginas especiales manualmente.
Después de elegir todas las páginas que desee volver a cargar, haga click en el botón \"actualizar selección\" mostrado abajo para volver a cargar las páginas especiales seleccionadas.
'''Advertencia:''' La actualización puede tardar un poco en wikis más extensos.",
	'refreshspecial-button' => 'Actualizar selección',
	'refreshspecial-fail' => 'Por favor chequee al menos una página especial a refrescar.',
	'refreshspecial-refreshing' => 'refrescando páginas especiales',
	'refreshspecial-skipped' => 'ordinario, omitido',
	'refreshspecial-choice' => 'refrescando páginas especiales',
	'refreshspecial-js-disabled' => '(<i>Usted no puede seleccionar todas las páginas donde JavaScript está deshabiltada</i>)',
	'refreshspecial-select-all-pages' => 'Seleccione todas las páginas',
	'refreshspecial-link-back' => 'Regresar a página especial',
	'refreshspecial-none-selected' => 'No has seleccionado ninguna pagina especial. Revertiendo a la selección por defecto.',
	'refreshspecial-db-error' => 'Fracasado: error en base de datos',
	'refreshspecial-no-page' => 'No tal página especial',
	'refreshspecial-slave-lagged' => 'Retraso del servidor esclavo, esperando...',
	'refreshspecial-reconnected' => 'Reconectado.',
	'refreshspecial-reconnecting' => 'Conexión falló, reconectando en 10 segundos...',
	'refreshspecial-page-result' => 'obtener $1 {{PLURAL:$1|fila|filas}} en',
	'refreshspecial-total-display' => '$1 {{PLURAL:$1|página actualizada|páginas actualizadas}} de un total de $2 {{PLURAL:$2|línea|líneas}} durante $3 (la duración completa de la acción del script es de $4)',
	'right-refreshspecial' => 'Refrescar páginas especiales',
);

/** Basque (Euskara)
 * @author Kobazulo
 */
$messages['eu'] = array(
	'refreshspecial-reconnected' => 'Birkonektaturik.',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Jack Phoenix <jack@countervandalism.net>
 * @author Mobe
 * @author Nike
 * @author Vililikku
 */
$messages['fi'] = array(
	'refreshspecial' => 'Päivitä toimintosivuja',
	'refreshspecial-desc' => 'Mahdollistaa [[Special:RefreshSpecial|toimintosivujen päivittämisen manuaalisesti]].',
	'refreshspecial-title' => 'Päivitä toimintosivuja',
	'refreshspecial-help' => 'Tämä toimintosivu tarjoaa keinoja päivittää toimintosivuja manuaalisesti. Kun olet valinnut kaikki sivut, jotka haluat päivittää, napsauta ”Päivitä valitut” -nappia alapuolella päivittääksesi valitut. Varoitus: Päivittäminen saattaa kestää jonkin aikaa isommissa wikeissä.',
	'refreshspecial-button' => 'Päivitä valitut',
	'refreshspecial-fail' => 'Valitse ainakin yksi päivitettävä toimintosivu.',
	'refreshspecial-refreshing' => 'päivitetään toimintosivuja',
	'refreshspecial-skipped' => 'halpa, ohitettu',
	'refreshspecial-choice' => 'päivitetään toimintosivuja',
	'refreshspecial-js-disabled' => '(<i>Et voi valita kaikkia sivuja, kun JavaScript on pois käytöstä</i>)',
	'refreshspecial-select-all-pages' => 'Valitse kaikki sivut',
	'refreshspecial-link-back' => 'Palaa takaisin',
	'refreshspecial-none-selected' => 'Et ole valinnut yhtään toimintosivua. Palataan oletusasetuksiin.',
	'refreshspecial-db-error' => 'Epäonnistui: Tietokantavirhe',
	'refreshspecial-no-page' => 'Kyseistä toimintosivua ei ole',
	'refreshspecial-slave-lagged' => 'Toisiopalvelin on jäänyt jälkeen. Odotetaan...',
	'refreshspecial-reconnected' => 'Yhdistetty uudelleen.',
	'refreshspecial-reconnecting' => 'Yhteys epäonnistui, yritetään uudelleen 10 sekunnin kuluttua...',
	'refreshspecial-total-display' => 'Päivitettiin {{PLURAL:$1|yksi sivu|$1 sivua}}. Yhteensä {{PLURAL:$2|yksi rivi|$2 riviä}} ajassa $3. Yhteensä komentosarjan suorittamiseen meni aikaa $4.',
	'right-refreshspecial' => 'Päivittää toimintosivuja',
);

/** French (Français)
 * @author Grondin
 * @author IAlex
 * @author McDutchie
 * @author Verdy p
 * @author Zetud
 */
$messages['fr'] = array(
	'refreshspecial' => 'Actualiser les pages spéciales',
	'refreshspecial-desc' => 'Permet [[Special:RefreshSpecial|l’actualisation manuelle]] des pages spéciales',
	'refreshspecial-title' => 'Actualiser les pages spéciales',
	'refreshspecial-help' => 'Cette page spéciale fournit les moyens de rafraichir manuellement les pages spéciales.
Quand vous avez choisi toutes les pages que vous voulez actualiser, cliquer sur le bouton « Actualiser » ci-dessous pour actualiser les pages sélectionnées.
Attention : l’actualisation peut prendre un certain temps sur des wikis disposant d’une grande taille.',
	'refreshspecial-button' => 'Actualiser sélectionnées',
	'refreshspecial-fail' => 'Veuillez cocher au moins une page spéciale à rafraichir.',
	'refreshspecial-refreshing' => 'Actualisation des pages spéciales',
	'refreshspecial-skipped' => 'superficiel, sauté',
	'refreshspecial-choice' => 'actualisation des pages spéciales',
	'refreshspecial-js-disabled' => '(<i>Vous ne pouvez pas sélectionner toutes les pages si JavaScript est désactivé</i>)',
	'refreshspecial-select-all-pages' => 'Sélectionner toutes les pages',
	'refreshspecial-link-back' => 'Revenir à l’extension',
	'refreshspecial-none-selected' => 'Vous n’avez pas sélectionné de pages spéciales. Retour vers la sélection par défaut.',
	'refreshspecial-db-error' => 'Échec : erreur de la base de données',
	'refreshspecial-no-page' => 'Aucune page spéciale',
	'refreshspecial-slave-lagged' => 'Retard sur le serveur esclave, attente en cours...',
	'refreshspecial-reconnected' => 'Reconnecté.',
	'refreshspecial-reconnecting' => 'Échec de la connexion, reconnexion dans 10 secondes...',
	'refreshspecial-page-result' => '$1 {{PLURAL:$1|ligne obtenue|lignes obtenues}} en',
	'refreshspecial-total-display' => '$1 {{PLURAL:$1|page actualisée|pages actualisées}} pour un total de $2 ligne{{PLURAL:$2||s}} durant $3 (l’exécution complète du script a duré $4)',
	'right-refreshspecial' => 'Actualiser les pages spéciales',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'refreshspecial' => 'Refrescar a páxina especial',
	'refreshspecial-desc' => 'Permite [[Special:RefreshSpecial|refrescar páxinas especiais manualmente]]',
	'refreshspecial-title' => 'Refrescar as páxinas especiais',
	'refreshspecial-help' => 'Esta páxina especial proporciona medios para refrescar manualmente as páxinas especiais.
Cando escolla todas as páxinas que quere refrescar, prema no botón "Actualizar o seleccionado" para levar a cabo a acción.
Aviso: o refrescado pode levar uns intres nos wikis grandes.',
	'refreshspecial-button' => 'Actualizar o seleccionado',
	'refreshspecial-fail' => 'Por favor, comprobe polo menos unha páxina especial para refrescar.',
	'refreshspecial-refreshing' => 'actualizando as páxinas especiais',
	'refreshspecial-skipped' => 'superficial, saltado',
	'refreshspecial-choice' => 'actualizando as páxinas especiais',
	'refreshspecial-js-disabled' => '(<i>Non pode seleccionar todas as páxinas cando o JavaScript está deshabilitado</i>)',
	'refreshspecial-select-all-pages' => 'Seleccionar todas as páxinas',
	'refreshspecial-link-back' => 'Voltar á extensión',
	'refreshspecial-none-selected' => 'Non seleccionou ningunha páxina especial. Revertendo á selección por defecto.',
	'refreshspecial-db-error' => 'Fallou: erro da base de datos',
	'refreshspecial-no-page' => 'Non existe tal páxina especial',
	'refreshspecial-slave-lagged' => 'Intervalo de atraso, agardando...',
	'refreshspecial-reconnected' => 'Reconectado.',
	'refreshspecial-reconnecting' => 'Fallou a conexión, reconectando en 10 segundos...',
	'refreshspecial-page-result' => '{{PLURAL:$1|Obtívose unha liña|Obtivéronse $1 liñas}} en',
	'refreshspecial-total-display' => '$1 {{PLURAL:$1|páxina refrescada|páxinas refrescadas}} dun total {{PLURAL:$2|dunha liña|de $2 liñas}} dunha duración de $3 (a duración completa da escritura é de $4)',
	'right-refreshspecial' => 'Actualizar as páxinas especiais',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'refreshspecial' => 'Spezialsyten aktualisiere',
	'refreshspecial-desc' => 'Erlaubt s [[Special:RefreshSpecial|manuäll Aktualisiere vu Spezialsyte]]',
	'refreshspecial-title' => 'Spezialsyten aktualisiere',
	'refreshspecial-help' => 'Uf däre Spezialsyte git s e Wärchzyyg zum manuälle Aktualisiere vu Spezialsyte.
Wänn Du alli Spezialsyte zum Aktualisiere uusgwehlt hesch, druck d Aktualisiere-Schaltflächi go d Aktualisierig aafange.
Obacht: S Aktualisiere cha uf große Wiki lenger goh.',
	'refreshspecial-button' => 'Uusgwehlti aktualisiere',
	'refreshspecial-fail' => 'Bitte chryz zmindescht ei Spezialsyte zum Aktualisieren aa.',
	'refreshspecial-refreshing' => 'Spezialsyte wäre aktualisiert',
	'refreshspecial-skipped' => 'wärtlos, ibersprunge',
	'refreshspecial-choice' => 'am Spezialsyten aktualisiere',
	'refreshspecial-js-disabled' => '(<i>Du chasch nit alli Syten uuswehle, wänn Du Javascript deaktiviert hesch</i>)',
	'refreshspecial-select-all-pages' => 'Alli Syten uuswehle',
	'refreshspecial-link-back' => 'Zrugg zue dr Spezialsyte',
	'refreshspecial-none-selected' => 'Du hesch kei Spezialsyten ausgwehlt. Wird zrugggsetzt uf d Standarduuswahl.',
	'refreshspecial-db-error' => 'Sterig: Datebankfähler',
	'refreshspecial-no-page' => 'Kei sonigi Spezialsyte',
	'refreshspecial-slave-lagged' => 'Slave-Server hangt, warte ...',
	'refreshspecial-reconnected' => 'Wider verbunde.',
	'refreshspecial-reconnecting' => 'Verbindig fähl gschlaa, wider verbinde in 10 Sekunde ...',
	'refreshspecial-page-result' => 'het {{PLURAL:$1|ei Reihe|$1 Reihe}} in',
	'refreshspecial-total-display' => 'Het $1 {{PLURAL:$1|Syten|Syten}} aktualisiert, insgsamt $2 {{PLURAL:$2|Zyylen|Zyylen}} in ere Zyt vu $3 (Gsamtlaufzyt vum Skript: $4)',
	'right-refreshspecial' => 'Spezialsyten aktualisiere',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'refreshspecial' => 'רענון דפים מיוחדים',
	'refreshspecial-desc' => 'מתן האפשרות ל[[Special:RefreshSpecial|רענון ידני של דפים מיוחדים]]',
	'refreshspecial-title' => 'רענון דפים מיוחדים',
	'refreshspecial-help' => 'דף מיוחד זה מספק שיטות לרענון ידני של דפים מיוחדים.
לאחר שתבחרו את כל הדפים אותם תרצו לרענן, לחצו על הכפתור "רענון הנבחרים" שלהלן כדי לרענן את הדפים המיוחדים שבחרתם.
אזהרה: הרענון עלול לארוך זמן מה באתרי ויקי גדולים.',
	'refreshspecial-button' => 'רענון הנבחרים',
	'refreshspecial-fail' => 'אנא בחרו לפחות דף מיוחד אחד לרענון.',
	'refreshspecial-refreshing' => 'מבוצע רענון הדפים המיוחדים',
	'refreshspecial-skipped' => 'הדף זול, בוצע דילוג',
	'refreshspecial-choice' => 'דפים מיוחדים לרענון',
	'refreshspecial-js-disabled' => '(<i>לא תוכלו לבחור את כל הדפים כאשר JavaScript מבוטלת</i>)',
	'refreshspecial-select-all-pages' => 'בחירת כל הדפים',
	'refreshspecial-link-back' => 'חזרה להרחבה',
	'refreshspecial-none-selected' => 'לא בחרתם דפים מיוחדים. הבחירה תוחזר לברירת המחדל.',
	'refreshspecial-db-error' => 'ההחלפה נכשלה: שגיאת בסיס נתונים',
	'refreshspecial-no-page' => 'אין דף מיוחד כזה',
	'refreshspecial-slave-lagged' => 'שרת המשנה אינו מעודכן, בהמתנה...',
	'refreshspecial-reconnected' => 'בוצעה התחברות מחדש.',
	'refreshspecial-reconnecting' => 'ההתחברות נכשלה, מתחבר תוך 10 שניות...',
	'refreshspecial-page-result' => 'יש {{PLURAL:$1|שורה אחת|$1 שורות}} ב',
	'refreshspecial-total-display' => '{{PLURAL:$1|דף אחד עבר|$1 דפים עברו}} רענון, בסך הכל {{PLURAL:$2|שורה אחת|$2 שורות}} תוך $3 (זמן השלמת הרצת הסקריפט הוא $4)',
	'right-refreshspecial' => 'רענון דפים מיוחדים',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'refreshspecial' => 'Specialne strony aktualizować',
	'refreshspecial-desc' => 'Zmóznja [[Special:RefreshSpecial|manuelne wobnowjenje specialnych stronow]]',
	'refreshspecial-title' => 'Specialne strony wobnowić',
	'refreshspecial-help' => 'Tua specialna strona staja srědki za manuelne wobnowjenje specialnych bokow k dispoziciji.
Hdyž sy wšě strony wubrał, kotrež chceš wobnowić, klikń na tłóčatko "Wubrane wobnowić" deleka, zo by wubrane specialne strony wobnowił.
Warnowanje: wobnowjenje móže na wulkich wikijach chětro dołho trać.',
	'refreshspecial-button' => 'Wubrane wobnowić',
	'refreshspecial-fail' => 'Prošu wubjer znajmjeńša jednu stronu za wobnowjenje.',
	'refreshspecial-refreshing' => 'Specialne strony so wobnowjeja',
	'refreshspecial-skipped' => 'tuni, přeskočeny',
	'refreshspecial-choice' => 'specialne strony so wobnowjeja',
	'refreshspecial-js-disabled' => '(<i>Njemóžeš wšě strony wubrać, hdyž sy JavaScript znjemóžnił</i>)',
	'refreshspecial-select-all-pages' => 'Wšě strony wubrać',
	'refreshspecial-link-back' => 'Wróćo k specialnej stronje',
	'refreshspecial-none-selected' => 'Njejsy specialne strony wubrał. Nawrót k standardnemu wuběrej',
	'refreshspecial-db-error' => 'Njewuspěch: zmylk datoweje banki',
	'refreshspecial-no-page' => 'Žana tajka specialna strona',
	'refreshspecial-slave-lagged' => 'Zwisk ze serwerom slave je pomały, čaka so...',
	'refreshspecial-reconnected' => 'Znowa zwjazany.',
	'refreshspecial-reconnecting' => 'Zwisk je so njeporadźił, znowazwjazowanje za 10 sekundow...',
	'refreshspecial-page-result' => 'wobsahuje $1 {{PLURAL:$1|rjad|rjadaj|rjady|rjadow}} w',
	'refreshspecial-total-display' => 'Zaktualizowa $1 {{PLURAL:$1|stronu|stronje|strony|stronow}}, w cyłku $2 {{PLURAL:$2|rjad|rjadaj|rjady|rjadow}} w dobje $3 (cyłkowny čas běha skripta je $4)',
	'right-refreshspecial' => 'Specialne strony wobnowić',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'refreshspecial' => 'Speciális lapok frissítése',
	'refreshspecial-desc' => 'Lehetővé teszi a [[Special:RefreshSpecial|speciális lapok kézi frissítését]]',
	'refreshspecial-title' => 'Speciális lapok frissítése',
	'refreshspecial-help' => "Ez a speciális lap lehetőségeket biztosít más speciális lapok kézi frissítésére.
Ha kiválasztottad az összes frissítendő lapot, kattints a „Kijelöltek frissítése” gombra alul a kiválasztott lapok aktualizálásához.
'''Figyelem:''' a frissítés eltarthat egy ideig nagyobb wikiken.",
	'refreshspecial-button' => 'Kiválasztottak frissítése',
	'refreshspecial-fail' => 'Jelölj ki legalább egy speciális lapot frissítésre.',
	'refreshspecial-refreshing' => 'speciális lapok frissítése',
	'refreshspecial-skipped' => 'nem fontos, átugorva',
	'refreshspecial-choice' => 'speciális lapok frissítése',
	'refreshspecial-js-disabled' => '(<i>Nem tudod kijelölni az összes lapot, ha a JavaScript le van tiltva</i>)',
	'refreshspecial-select-all-pages' => 'Összes lap kijelölése',
	'refreshspecial-link-back' => 'Vissza a speciális lapra',
	'refreshspecial-none-selected' => 'Nem jelöltél ki egy speciális lapot sem. Visszatérés az alapértelmezett kijelöléshez.',
	'refreshspecial-db-error' => 'Sikertelen: adatbázishiba',
	'refreshspecial-no-page' => 'Nincs ilyen speciális lap',
	'refreshspecial-slave-lagged' => 'A slave lemaradt, várakozás…',
	'refreshspecial-reconnected' => 'Újracsatlakozva.',
	'refreshspecial-reconnecting' => 'A kapcsolat megszakadt, újracsatlakozás 10 másodperc múlva…',
	'refreshspecial-page-result' => '$1 sort tartalmaz',
	'refreshspecial-total-display' => '$1 lap frissítve, összesen $2 sor $3 idő alatt (a parancsfájl teljes futási ideje $4 volt)',
	'right-refreshspecial' => 'Speciális lapok frissítése',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'refreshspecial' => 'Refrescar paginas special',
	'refreshspecial-desc' => 'Permitte le [[Special:RefreshSpecial|refrescamento manual]] de paginas special',
	'refreshspecial-title' => 'Refrescar paginas special',
	'refreshspecial-help' => 'Iste pagina special forni un modo manual de refrescar paginas special.
Quando tu ha seligite tote le paginas que tu vole refrescar, clicca super le button "Refrescar selection" in basso pro refrescar le paginas special seligite.
Attention: le refrescamento pote durar un poco de tempore in wikis plus grande.',
	'refreshspecial-button' => 'Refrescar selection',
	'refreshspecial-fail' => 'Per favor marca al minus un pagina special a refrescar.',
	'refreshspecial-refreshing' => 'refrescamento de paginas special in curso',
	'refreshspecial-skipped' => 'superficial, omittite',
	'refreshspecial-choice' => 'refrescamento de paginas special',
	'refreshspecial-js-disabled' => '<i>(Tu non pote seliger tote le paginas si JavaScript non es active)</i>',
	'refreshspecial-select-all-pages' => 'Seliger tote le paginas',
	'refreshspecial-link-back' => 'Retornar al extension',
	'refreshspecial-none-selected' => 'Tu non ha seligite alcun pagina special. Le selection retorna al predefinite.',
	'refreshspecial-db-error' => 'Falta: error del base de datos',
	'refreshspecial-no-page' => 'Iste pagina special non existe',
	'refreshspecial-slave-lagged' => 'Sclavo in retardo; attende...',
	'refreshspecial-reconnected' => 'Reconnectite.',
	'refreshspecial-reconnecting' => 'Connexion fallite, reconnexion post 10 secundas...',
	'refreshspecial-page-result' => 'obteneva $1 {{PLURAL:$1|linea|lineas}} in',
	'refreshspecial-total-display' => 'Refrescava $1 {{PLURAL:$1|pagina|paginas}} con un total de $2 {{PLURAL:$2|linea|lineas}} durante $3 (le durata total del execution del script es $4)',
	'right-refreshspecial' => 'Refrescar paginas special',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Irwangatot
 * @author Kandar
 */
$messages['id'] = array(
	'refreshspecial' => 'Mutakhirkan halaman istimewa',
	'refreshspecial-desc' => 'Membolehkan [[Special:RefreshSpecial|halaman istimewa perbaharuan]]  dari halaman istimewa',
	'refreshspecial-title' => 'Mutakhirkan halaman istimewa',
	'refreshspecial-help' => "

Halaman istimewa ini menyediakan sarana untuk secara manual memperbaharui halaman istimewa. 
Ketika Anda memilih semua halaman yang ingin Anda perbaharui, klik pada tombol \"Refresh dipilih\" di bawah ini untuk memperbaharui  halaman istimewa yang dipilih. 
'''Peringatan:''' Pembaharuan mungkin memerlukan waktu di wiki yang besar.",
	'refreshspecial-button' => 'Pembaharuan terpilih',
	'refreshspecial-fail' => 'Silakan periksa setidaknya satu halaman istimewa untuk diperbarui.',
	'refreshspecial-refreshing' => 'memutakhirkan halaman istimewa',
	'refreshspecial-skipped' => 'murah, melewatkan',
	'refreshspecial-choice' => 'memutakhirkan halaman istimewa',
	'refreshspecial-js-disabled' => '(<i>Anda tidak dapat memilih semua halaman ketika JavaScript diaktifkan</i>)',
	'refreshspecial-select-all-pages' => 'Pilih semua halaman',
	'refreshspecial-link-back' => 'Kembali ke halaman istimewa',
	'refreshspecial-none-selected' => 'Anda belum memilih halaman istimewa apapun. Kembali ke pilihan default.',
	'refreshspecial-db-error' => 'Gagal: kesalahan basis data',
	'refreshspecial-no-page' => 'Tidak ada halaman istimewa tersebut',
	'refreshspecial-slave-lagged' => 'Slave tertinggal, tunggu...',
	'refreshspecial-reconnected' => 'Tersambung kembali.',
	'refreshspecial-reconnecting' => 'Gagal tersambung. Menghubungkan kembali dalam 10 detik...',
	'refreshspecial-page-result' => 'mendapat $1 {{PLURAL:$1|baris|baris}} pada',
	'refreshspecial-total-display' => 'Pembaharuan $1 {{PLURAL:$1|halaman|halaman}} dengan jumlah $2 {{PLURAL:$2|baris|baris}} selama $3 (waktu selesai script berjalan adalah $4)',
	'right-refreshspecial' => 'Perbaharui halaman istimewa',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Darth Kule
 */
$messages['it'] = array(
	'refreshspecial' => 'Aggiorna pagine speciali',
	'refreshspecial-desc' => "Permette l'[[Special:RefreshSpecial|aggiornamento manuale]] delle pagine speciali",
	'refreshspecial-title' => 'Aggiorna pagine speciali',
	'refreshspecial-help' => 'Questa pagina speciale permette di aggiornare manualmente le pagine speciali. Quando hai scelto tutte le pagine che vuoi aggiornare, fai clic sul pulsante "Aggiorna pagine selezionate" per aggiornare le pagine speciali selezionate. Attenzione: l\'aggiornamento potrebbe richiedere un po\' di tempo sulle wiki più grandi.',
	'refreshspecial-button' => 'Aggiorna pagine selezionate',
	'refreshspecial-fail' => 'Seleziona almeno una pagina speciale da aggiornare.',
	'refreshspecial-refreshing' => 'aggiornamento pagine speciali',
	'refreshspecial-skipped' => 'non importante, saltato',
	'refreshspecial-choice' => 'aggiornamento pagine speciali',
	'refreshspecial-js-disabled' => '(<i>Non è possibile selezionare tutte le pagine se JavaScript è disattivato</i>)',
	'refreshspecial-select-all-pages' => 'Seleziona tutte le pagine',
	'refreshspecial-link-back' => "Torna all'estensione",
	'refreshspecial-none-selected' => 'Non è stata selezionata alcuna pagina speciale. Ripristino alla selezione di default.',
	'refreshspecial-db-error' => 'Fallito: errore del database',
	'refreshspecial-no-page' => 'Pagina speciale inesistente',
	'refreshspecial-slave-lagged' => 'In attesa per ritardo del server slave...',
	'refreshspecial-reconnected' => 'Riconnesso.',
	'refreshspecial-reconnecting' => 'Connessione fallita, prossimo tentativo fra 10 secondi...',
	'refreshspecial-page-result' => '{{PLURAL:$1|ottenuta 1 riga|ottenute $1 righe}} in',
	'refreshspecial-total-display' => '$1 {{PLURAL:$1|pagina aggiornata|pagine aggiornate}} per un totale di $2 {{PLURAL:$1|linea|linee}} in un tempo di $3 (il tempo totale di esecuzione dello script è di $4)',
	'right-refreshspecial' => 'Aggiorna pagine speciali',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 */
$messages['ja'] = array(
	'refreshspecial' => '特別ページを更新する',
	'refreshspecial-desc' => '[[Special:RefreshSpecial|特別ページを手動で更新]]できるようにする',
	'refreshspecial-title' => '特別ページの更新',
	'refreshspecial-help' => 'この特別ページは、特別ページを手動で更新する手段を提供します。更新したい特別ページをすべて選択し、以下の「選択したものを更新」ボタンを押すと選択したページを更新します。
警告: 規模の大きなウィキでは更新にしばらくかかります。',
	'refreshspecial-button' => '選択したものを更新',
	'refreshspecial-fail' => '更新する特別ページを最低でも1つは選んでください。',
	'refreshspecial-refreshing' => '特別ページを更新中',
	'refreshspecial-skipped' => '負荷が低いので飛ばしました',
	'refreshspecial-choice' => '特別ページを更新中',
	'refreshspecial-js-disabled' => '(<i>JavaScript を無効にしていると「すべてのページを選択」機能が使えません</i>)',
	'refreshspecial-select-all-pages' => 'すべてのページを選択',
	'refreshspecial-link-back' => '元のページに戻る',
	'refreshspecial-none-selected' => '特別ページを一つも選択していません。デフォルトの選択状態に戻します。',
	'refreshspecial-db-error' => '失敗: データベースのエラー',
	'refreshspecial-no-page' => 'そのような特別ページはありません',
	'refreshspecial-slave-lagged' => 'スレーブサーバーの遅延、待機中…',
	'refreshspecial-reconnected' => '再接続しました。',
	'refreshspecial-reconnecting' => '接続失敗、10秒間の再接続中…',
	'refreshspecial-page-result' => '$1{{PLURAL:$1|行}}を取得',
	'refreshspecial-total-display' => '$1{{PLURAL:$1|ページ}} (データベース{{PLURAL:$2|行数}}合計: $2) を $3で更新しました (スクリプトの全実行時間: $4)',
	'right-refreshspecial' => '特別ページを更新する',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Thearith
 */
$messages['km'] = array(
	'refreshspecial' => 'ធ្វើឱ្យ​ទំព័រពិសេស​ស្រស់',
	'refreshspecial-desc' => 'អនុញ្ញាត [[Special:RefreshSpecial|ធ្វើឱ្យ​ទំព័រពិសេស​ស្រស់​ដោយដៃ]] នៃ​ទំព័រ​ពិសេស',
	'refreshspecial-title' => 'ធ្វើឱ្យ​ទំព័រពិសេស​ស្រស់',
	'refreshspecial-fail' => 'សូម​ពិនិត្យមើល​ទំព័រ​ពិសេស​យ៉ាងហោច​មួយ ដើម្បី​ធ្វើឱ្យស្រស់​។',
	'refreshspecial-refreshing' => 'ដែល​ធ្វើឱ្យ​ទំព័រពិសេសស្រស់',
	'refreshspecial-choice' => 'ដែល​ធ្វើឱ្យ​ទំព័រពិសេសស្រស់',
	'refreshspecial-js-disabled' => '(<i>អ្នក​មិន​អាច​ជ្រើសយក​គ្រប់​ទំព័រ​ទាំងអស់​បាន​ទេ ខណៈដែល JavaScript មិន​ត្រូវ​បាន​អនុញ្ញាត</i>)',
	'refreshspecial-select-all-pages' => 'ជ្រើស​ទំព័រ​ទាំងអស់',
	'refreshspecial-link-back' => 'ត្រឡប់ក្រោយ​ទៅ​ផ្នែកបន្ថែម​វិញ',
	'refreshspecial-none-selected' => 'អ្នក​មិន​បាន​ជ្រើស​ទំព័រពិសេសេ​ណាមួយ​ទេ​។ សូម​ត្រឡប់​ទៅរក​ការជ្រើស​តាម​លំនាំដើម​វិញ​។',
	'refreshspecial-db-error' => 'បរាជ័យ​៖ កំហុស​មូលដ្ឋានទិន្នន័យ',
	'refreshspecial-no-page' => 'មិនមាន​ទំព័រពិសេសេ',
	'refreshspecial-reconnected' => 'បាន​តភ្ជាប់ឡើងវិញ​។',
	'refreshspecial-reconnecting' => 'តភ្ជាប់ឡើងវិញ​បាន​បរាជ័យ, ដែល​ដំណើរការ​តភ្ជាប់ឡើងវិញ​នៅ​ក្នុង​រយៈពេល ១០ វិនាទី...',
	'right-refreshspecial' => 'ធ្វើឱ្យ​ទំព័រពិសេសស្រស់',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'refreshspecial' => 'Söndersigge ier Date neu opfreshe',
	'refreshspecial-desc' => 'Määt et müjjelesch, Söndersigge ier Date [[Special:RefreshSpecial|fun Hand neu opfreshe]] ze lohße.',
	'refreshspecial-title' => 'Söndersigge neu aanzeije',
	'refreshspecial-help' => 'Hee die Söndersigg jitt Der e Werkzüch för de Söndersigge ier Daten
vun Hand neu ußrechne ze johße.
Wann De all die Söndersigge doför ußjewählt häs, donn op dä Knopp
„{{int:refreshspecial-button}}“ klekke, öm dat neu Opnämme aanzefange.
Opjepaß: Dat op jruuße Wikis sing Zick doore.',
	'refreshspecial-button' => 'Uswahl neu opfreshe',
	'refreshspecial-fail' => 'Bes esu joot, un donn winnishsdens ein Sigg zom Opfresche ußwähle.',
	'refreshspecial-refreshing' => 'Ben de Söndersigge am opfresche',
	'refreshspecial-skipped' => 'bellesch, övverjange',
	'refreshspecial-choice' => 'Ben de Söndersigge am opfresche',
	'refreshspecial-js-disabled' => '(<i>De kanns nit all Sigge ußwähle, wann JavaSkipp nit jeiht</i>)',
	'refreshspecial-select-all-pages' => 'All Sigge ußwähle',
	'refreshspecial-link-back' => 'Jangk retuur op di Söndersigg',
	'refreshspecial-none-selected' => 'Do häs kein Söndersigge ußjgewählt.
Mer jonn fröm op de Shtandatt-Ußwahl.',
	'refreshspecial-db-error' => 'Dat es donevve jejange: Mer hatte ene Datebangk-Fähler.',
	'refreshspecial-no-page' => 'Esu en Söndersigg ham_mer nit.',
	'refreshspecial-slave-lagged' => 'Ene nohjeschaldte ßööver eß hengerher aam hingke, mer sen am waade&nbsp;...',
	'refreshspecial-reconnected' => 'De Verbendong es widder do.',
	'refreshspecial-reconnecting' => 'De Verbendong es fott. Weed widder opjebout in 10 Sekunde&nbsp;...',
	'refreshspecial-page-result' => 'hät {{PLURAL:$1|ein Reih|$1 Reije|kein einzije Reih}} en',
	'refreshspecial-total-display' => 'Han {{PLURAL:$1|ein Sigg|$1 Sigge|kein Sigg}} op der neuste Shtand jebraat,
met ensjesamp {{PLURAL:$2|ein Reih|$2 Reije|kein Reih}},
en dä Zick fun $3, wobei dä janze Vörjang $4 jedooht hät.',
	'right-refreshspecial' => 'Söndersigge ier Date neu opfreshe',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'refreshspecial' => 'Spezialsäiten aktualiséieren',
	'refreshspecial-desc' => "Erlaabt et Spezialsäite [[Special:RefreshSpecial|manuell z'aktualiséieren]]",
	'refreshspecial-title' => 'Spezialsäiten aktualiséieren',
	'refreshspecial-help' => "Dës Spezialsäit erlaabt et fir Spezialsäite manuell z'aktualiséieren. 
Wann Dir all Säiten ugewielt hutt déi dir wëllt aktualiséiert kréien, da klickt op den ''Aktulisatiouns-Knäppchen'' hei ënnendrënner fir déi gewielte Spezialsäiten z'aktualiséieren. 
Opgepasst: op méi grousse Wikie kann d'Aktualisatioun eng Zäit daueren.",
	'refreshspecial-button' => 'Déi gewielten aktualiséieren',
	'refreshspecial-fail' => "Wielt mindestens eng Spezialsäit aus fir z'aktualiséieren.",
	'refreshspecial-refreshing' => 'Spezialsäiten aktualiséieren',
	'refreshspecial-skipped' => 'bëlleg, iwwersprong',
	'refreshspecial-choice' => 'Aktualisatioun vu Spezialsäiten',
	'refreshspecial-js-disabled' => "(<i>dir kënnt net all d'Säiten auswielen, wa JavaScript ausgeschalt ass</i>)",
	'refreshspecial-select-all-pages' => ' All Säiten auswielen',
	'refreshspecial-link-back' => "Zréck op d'Erweiderung",
	'refreshspecial-none-selected' => "Dir hutt keng Spezialssäiten ausgewielt. Zrèck op d'Astellung 'par défaut'",
	'refreshspecial-db-error' => 'Et geet net: Feeler vun der Datebank',
	'refreshspecial-no-page' => 'Et gëtt keng esou Spezialsäit',
	'refreshspecial-slave-lagged' => 'Aarbecht déi nach usteet, an der Maach ...',
	'refreshspecial-reconnected' => 'Nees verbonn',
	'refreshspecial-reconnecting' => "D'Verbindung koum net zustan, nei Verbindung an 10 Sekonnen ...",
	'refreshspecial-page-result' => ' {{PLURAL:$1|eng Rei|$1 Reie}} kritt an',
	'refreshspecial-total-display' => "$1 {{PLURAL:$1|Säit|Säiten}} aktuliséiert mat am Ganzen $2 {{PLURAL:$2|Rei|Reien}} an $3 (Dauer) (d'Gesamtzäit déi de Script gebraucht huet ass $4)",
	'right-refreshspecial' => 'Spezialsäiten aktualiséieren',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'refreshspecial' => 'Ажурирај специјални страници',
	'refreshspecial-desc' => 'Овозможува [[Special:RefreshSpecial|рачно ажурирање]] на специјални страници',
	'refreshspecial-title' => 'Ажурирање на специјални страници',
	'refreshspecial-help' => "Оваа специјална страница дава начин на рачно ажурирање на специјални страници.
Откако ќе ги изберете сите страници кои сакате да ги ажурирате, кликнете на копчето „Освежи го одбраното“ подолу за да ги ажурирате тие страници.
'''Предупредување:''' Ажурирањето може да потрае кај поголеми викија.",
	'refreshspecial-button' => 'Ажурирај го избраното',
	'refreshspecial-fail' => 'ОДберете барем една специјална страница за ажурирање.',
	'refreshspecial-refreshing' => 'ажурирање на специјалните страници',
	'refreshspecial-skipped' => 'грешка, прескокнато',
	'refreshspecial-choice' => 'ажурирање на специјалните страници',
	'refreshspecial-js-disabled' => '(<i>Не можете да ги одберете сите страници кога е исклучен JavaScript</i>)',
	'refreshspecial-select-all-pages' => 'Одбери ги сите страници',
	'refreshspecial-link-back' => 'Назад кон специјалната страница',
	'refreshspecial-none-selected' => 'Немате одбрано ниедна специјална страница. Враќам на основно зададениот избор.',
	'refreshspecial-db-error' => 'Неуспешно: Грешка во базата на податоци',
	'refreshspecial-no-page' => 'Нема таква специјална страница',
	'refreshspecial-slave-lagged' => 'Зависниот сервер заостанува. Чекам...',
	'refreshspecial-reconnected' => 'Преповрзано.',
	'refreshspecial-reconnecting' => 'Поврзувањето не успеа. Се преповрзувам за 10 секунди...',
	'refreshspecial-page-result' => '{{PLURAL:$1|$Внесен е 1 ред|Внесени се $1 реда}} во',
	'refreshspecial-total-display' => '{{PLURAL:$1|Ажурирана е $1 страница|Ажурирани се $1 страници}}, со вкупно $2 {{PLURAL:$2|ред|реда}} за време $3 (вкупното време откако скриптата работи изнесува $4)',
	'right-refreshspecial' => 'Ажурирање на специјални страници',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'refreshspecial' => "Speciale pagina's verversen",
	'refreshspecial-desc' => "Maakt het mogelijk om [[Special:RefreshSpecial|handmatig speciale pagina's te verversen]]",
	'refreshspecial-title' => "Speciale pagina's verversen",
	'refreshspecial-help' => "Via deze pagina kunt u speciale pagina's handmatig verversen.
Nadat u alle gewenste pagina's hebt aangevinkt, kunt u 'Geselecteerde pagina's verversen' kiezen om de geselecteerde speciale pagina's bij te laten werken.
Waarschuwing: op grotere wiki's kan dit enige tijd duren.",
	'refreshspecial-button' => "Geselecteerde pagina's verversen",
	'refreshspecial-fail' => 'Vink tenminste één te verversen pagina aan.',
	'refreshspecial-refreshing' => "bezig met het verversen van speciale pagina's",
	'refreshspecial-skipped' => 'goedkoop, overgeslagen',
	'refreshspecial-choice' => "bezig met het verversen van speciale pagina's",
	'refreshspecial-js-disabled' => "(<i>U kunt alle pagina's niet selecteren als JavaScript is uitgeschakeld</i>)",
	'refreshspecial-select-all-pages' => "Alle pagina's selecteren",
	'refreshspecial-link-back' => 'Terug naar uitbreiding',
	'refreshspecial-none-selected' => "U hebt geen speciale pagina's geselecteerd.
De standaardinstellingen zijn hersteld.",
	'refreshspecial-db-error' => 'Fout: databasefout',
	'refreshspecial-no-page' => 'De speciale pagina bestaat niet',
	'refreshspecial-slave-lagged' => 'De slaveserver loopt achter. Bezig met wachten...',
	'refreshspecial-reconnected' => 'Weer verbonden.',
	'refreshspecial-reconnecting' => 'Verbinding kon niet gemaakt worden.
Over 10 seconden wordt weer geprobeerd verbinding te maken...',
	'refreshspecial-page-result' => '$1 {{PLURAL:$1|rij|rijen}} verwerkt in',
	'refreshspecial-total-display' => "Er {{PLURAL:$1|is $1 pagina|zijn $1 pagina's}} ververst met $2 {{PLURAL:$2|rij|rijen}} in $3 tijd (totale duur van de verwerking was $4)",
	'right-refreshspecial' => "Speciale pagina's verversen",
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'refreshspecial' => 'Oppdater spesialsider',
	'refreshspecial-desc' => 'Mogleggjer [[Special:RefreshSpecial|manuell oppdatering]] av spesialsider',
	'refreshspecial-title' => 'Oppdater spesialsider',
	'refreshspecial-help' => "Denne spesialsida gjer at ein manuelt kan oppdatera spesialsider. 
Når du har valt kva sider du ønskjer å oppdatera, klikk på 'Oppdater valte' for å gjennomføra oppdateringa. Åtvaring: Oppdatering kan ta ei stund på større wikiar.",
	'refreshspecial-button' => 'Oppdater valte',
	'refreshspecial-fail' => 'Merk av minst éi spesialsida som skal oppdaterast',
	'refreshspecial-refreshing' => 'oppdaterer spesialsider',
	'refreshspecial-skipped' => 'billig, hoppa over',
	'refreshspecial-choice' => 'oppdaterer spesialsider',
	'refreshspecial-js-disabled' => '(<i>Du kan ikkje merkja alle sider om JavaScript er slege av</i>)',
	'refreshspecial-select-all-pages' => 'Merk alle sider',
	'refreshspecial-link-back' => 'Gå attende til utvidinga',
	'refreshspecial-none-selected' => 'Du har ikkje merkt noka spesialsida. Stiller attende til standardval.',
	'refreshspecial-db-error' => 'Mislukkast: databasefeil',
	'refreshspecial-no-page' => 'Spesialsida finst ikkje',
	'refreshspecial-slave-lagged' => 'Forseinking i slavetenaren, ventar...',
	'refreshspecial-reconnected' => 'Kopla til på nytt.',
	'refreshspecial-reconnecting' => 'Tilkopling mislukkast, prøver om att om ti sekund...',
	'refreshspecial-page-result' => 'fekk {{PLURAL:$1|éi rekkja|$1 rekkjer}} i',
	'refreshspecial-total-display' => 'Oppdaterte {{PLURAL:$1|éi sida|$1 sider}} med totalt {{PLURAL:$2|éi rekkja|$2 rekkjer}} med tida $3 (total skriptkøyretid er $4)',
	'right-refreshspecial' => 'Oppdatera spesialsider',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'refreshspecial' => 'Oppdater spesialsider',
	'refreshspecial-desc' => 'Muliggjør [[Special:RefreshSpecial|manuell oppdatering]] av spesialsider',
	'refreshspecial-title' => 'Oppdater spesialsider',
	'refreshspecial-help' => "Denne spesialsiden tilbyr metoder for å manuelt oppdatere spesialsider.
Når du har valgt alle sidene du vil oppdatere, klikk på «Oppdater valgte»-knappen for å gjennomføre oppdateringen på de valgte spesialsidene.
'''Advarsel:''' Oppdateringen kan ta en stund på større wikier.",
	'refreshspecial-button' => 'Oppdater valgte',
	'refreshspecial-fail' => 'Merk minst én spesialside for oppdatering',
	'refreshspecial-refreshing' => 'oppdaterer spesialsider',
	'refreshspecial-skipped' => 'billig, hoppet over',
	'refreshspecial-choice' => 'oppdaterer spesialsider',
	'refreshspecial-js-disabled' => "(''Du kan ikke merke alle sider om JavaScript er slått av'')",
	'refreshspecial-select-all-pages' => 'Merk alle sider',
	'refreshspecial-link-back' => 'Tilbake til utvidelsen',
	'refreshspecial-none-selected' => 'Du har ikke merket noen spesialsider. Tilbakestiller til standardvalg.',
	'refreshspecial-db-error' => 'Mislyktes: databasefeil',
	'refreshspecial-no-page' => 'Ingen slik spesialside',
	'refreshspecial-slave-lagged' => 'Forsinkelse i slavetjeneren, venter ...',
	'refreshspecial-reconnected' => 'Tilkoblet på nytt.',
	'refreshspecial-reconnecting' => 'Tilkobling mislyktes, prøver igjen om ti sekunder ...',
	'refreshspecial-page-result' => 'fikk {{PLURAL:$1|én rad|$1 rader}} i',
	'refreshspecial-total-display' => 'Oppdaterte {{PLURAL:$1|én side|$1 sider}} med totalt {{PLURAL:$2|én rad|$2 rader}} på tiden $3 (total skriptkjøretid er $4)',
	'right-refreshspecial' => 'Oppdater spesialsider',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'refreshspecial' => 'Refrescar las paginas especialas',
	'refreshspecial-desc' => 'Permet [[Special:RefreshSpecial|l’actualizacion de las paginas especialas del manual]] de las paginas concernidas',
	'refreshspecial-title' => 'Refrescar las paginas especialas',
	'refreshspecial-help' => 'Aquesta pagina especiala provesís los mejans de refrescar manualament las paginas especialas.
Quand avètz causit totas las paginas que volètz actualizar, clicatz sul bouton « Actualizar » çaijós per actualizar las paginas seleccionadas.
Atencion : l’actualizacion pòt préne un cèrt temps sus de wikis que dispausan d’una talha bèla.',
	'refreshspecial-button' => 'Actualizacion seleccionada',
	'refreshspecial-fail' => 'Marcatz al mens una pagina especiala de refrescar.',
	'refreshspecial-refreshing' => 'Actualizacion de las paginas especialas',
	'refreshspecial-skipped' => 'superficial, sautat',
	'refreshspecial-choice' => 'actualizacion de las paginas especialas',
	'refreshspecial-js-disabled' => '(<i>Podètz pas seleccionar totas las paginas quand JavaScript es desactivat</i>)',
	'refreshspecial-select-all-pages' => 'Seleccionar totas las paginas',
	'refreshspecial-link-back' => 'Tornar a l’extension',
	'refreshspecial-none-selected' => 'Avètz pas seleccionat cap de paginas especialas. Retorn cap a la seleccion per defaut.',
	'refreshspecial-db-error' => 'Fracàs : error de la banca de donada',
	'refreshspecial-no-page' => 'Pas cap de pagina especiala',
	'refreshspecial-slave-lagged' => 'Trabalh retardat, en cors...',
	'refreshspecial-reconnected' => 'Reconnectat.',
	'refreshspecial-reconnecting' => 'Fracàs de la connexion, reconnexion dins 10 segondas...',
	'refreshspecial-page-result' => '$1 {{PLURAL:$1|linha obtenguda|linhas obtengudas}} en',
	'refreshspecial-total-display' => "$1 {{PLURAL:$1|pagina actualizada|paginas actualizadas}} totalizant $2 {{PLURAL:$2|linha|linhas}} sus una durada de $3 (la durada completa de l’accion de l'escript es de $4)",
	'right-refreshspecial' => 'Actualizar las paginas especialas',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Jwitos
 * @author Leinad
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'refreshspecial' => 'Odśwież strony specjalne',
	'refreshspecial-desc' => 'Umożliwia [[Special:RefreshSpecial|za pomocą strony specjalnej wymusić odświeżenie]] zawartości innych stron specjalnych',
	'refreshspecial-title' => 'Odśwież strony specjalne',
	'refreshspecial-help' => 'Strona pozwala ręcznie odświeżać strony specjalne.
Po wybraniu wszystkich stron do odświeżenia należy kliknąć znajdujący się poniżej przycisk „Odśwież wybrane” aby wymusić odświeżenie.
Uwaga – odświeżenie może trwać długo na dużej wiki.',
	'refreshspecial-button' => 'Odśwież wybrane',
	'refreshspecial-fail' => 'Proszę zaznaczyć co najmniej jedną stronę specjalną do odświeżenia.',
	'refreshspecial-refreshing' => 'odświeżanie stron specjalnych',
	'refreshspecial-skipped' => 'nieważne, pominięte',
	'refreshspecial-choice' => 'odświeżanie stron specjalnych',
	'refreshspecial-js-disabled' => '(<i>Nie możesz wybrać wszystkich stron, gdy JavaScript jest wyłączony</i>)',
	'refreshspecial-select-all-pages' => 'Zaznacz wszystkie strony',
	'refreshspecial-link-back' => 'Powrót do strony specjalnej',
	'refreshspecial-none-selected' => 'Nie wybrałeś żadnych stron specjalnych. Przywracanie domyślnego wyboru.',
	'refreshspecial-db-error' => 'Niepowodzenie – błąd bazy danych',
	'refreshspecial-no-page' => 'Nie ma takiej strony specjalnej',
	'refreshspecial-slave-lagged' => 'Opóźnienia w komunikacji z systemem podrzędnym, trwa oczekiwanie...',
	'refreshspecial-reconnected' => 'Ponownie połączono.',
	'refreshspecial-reconnecting' => 'Połączenie nie powiodło się, ponowne połączenie nastąpi za 10 sekund...',
	'refreshspecial-page-result' => 'otrzymała $1 {{PLURAL:$1|wiersz|wiersze|wierszy}} w',
	'refreshspecial-total-display' => 'Odświeżono $1 {{PLURAL:$1|stronę|strony|stron}} łącznie $2 {{PLURAL:$2|wiersz|wiersze|wierszy}} w czasie $3 (pełny czas wykonania skryptu $4)',
	'right-refreshspecial' => 'Odświeżanie stron specjalnych',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'refreshspecial' => 'Agiorna le pàgine speciaj',
	'refreshspecial-desc' => "A përmëtt l'[[Special:RefreshSpecial|agiornament manual]] ëd le pàgine speciaj",
	'refreshspecial-title' => 'Agiorna le pàgine speciaj',
	'refreshspecial-help' => "Sta pàgina special-sì a dà ij mojen për agiorné le pàgine speciaj.
Quand it l'has sërnù tute le pàgine ch'it veule agiorné, sgnaca ël boton \"Agiorna selessionà\" sì-sota për agiorné le pàgine speciaj selessionà.
'''Atension:''' L'agiornament a peul duré bastansa dzora a wiki gròsse.",
	'refreshspecial-button' => 'Agiorna selessionà',
	'refreshspecial-fail' => 'Për piasì contròla almanch na pàgina special da agiorné.',
	'refreshspecial-refreshing' => 'agiornament pàgine speciaj',
	'refreshspecial-skipped' => 'da gnente, sautà',
	'refreshspecial-choice' => 'agiornament pàgine speciaj',
	'refreshspecial-js-disabled' => "(<i>It peule pa selessioné tute le pàgine quand che JavaScript a l'é disabilità</i>)",
	'refreshspecial-select-all-pages' => 'Selession-a tute le pàgine',
	'refreshspecial-link-back' => 'Torna a la pàgina special',
	'refreshspecial-none-selected' => "It l'has pa selessionà gnun-e pàgine speciaj. Tornà a la selession ëstàndard.",
	'refreshspecial-db-error' => 'Eror: eror dla base ëd dàit',
	'refreshspecial-no-page' => 'A-i é pa la pàgina special',
	'refreshspecial-slave-lagged' => 'Artard ëd lë s-ciav, speta ...',
	'refreshspecial-reconnected' => 'Torna colegà.',
	'refreshspecial-reconnecting' => 'Conession falìa, riconession tra 10 second ...',
	'refreshspecial-page-result' => 'trovà $1 {{PLURAL:$1|riga|righe}} an',
	'refreshspecial-total-display' => "Agiornà $1 {{PLURAL:$1|pàgina|pàgine}} për un total ëd $2 {{PLURAL:$2|riga|righe}} ant un temp ëd $3 (ël temp total d'esecussion dlë script a l'é $4)",
	'right-refreshspecial' => 'Agiorna pàgine speciaj',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Malafaya
 */
$messages['pt'] = array(
	'refreshspecial' => 'Refrescar páginas especiais',
	'refreshspecial-desc' => 'Permite o [[Special:RefreshSpecial|refrescamento manual]] das páginas especiais',
	'refreshspecial-title' => 'Refrescar páginas especiais',
	'refreshspecial-help' => "Esta página especial permite refrescar manualmente páginas especiais.
Quando tiver escolhido todas as páginas que pretende refrescar, clique no botão \"Refrescar seleccionadas\" abaixo, para refrescar as páginas especiais que seleccionou.
'''Aviso:''' O refrescamento pode demorar algum tempo em wikis de tamanho considerável.",
	'refreshspecial-button' => 'Refrescar seleccionadas',
	'refreshspecial-fail' => 'Por favor, seleccione pelo menos uma página especial para refrescar.',
	'refreshspecial-refreshing' => 'a refrescar página especiais',
	'refreshspecial-skipped' => 'insignificante, saltado',
	'refreshspecial-choice' => 'a refrescar página especiais',
	'refreshspecial-js-disabled' => '(<i>Não pode seleccionar todas as páginas quando o JavaScript está desactivado</i>)',
	'refreshspecial-select-all-pages' => 'Seleccionar todas as páginas',
	'refreshspecial-link-back' => 'Voltar à extensão',
	'refreshspecial-none-selected' => 'Não seleccionou nenhuma página especial. Revertendo para a selecção padrão.',
	'refreshspecial-db-error' => 'Falha: erro de base de dados',
	'refreshspecial-no-page' => 'Página especial inexistente',
	'refreshspecial-slave-lagged' => 'Servidor escravo com atraso, aguardando...',
	'refreshspecial-reconnected' => 'Novamente ligado.',
	'refreshspecial-reconnecting' => 'Ligação falhou, nova tentativa em 10 segundos...',
	'refreshspecial-page-result' => '{{PLURAL:$1|obtida 1 linha|obtidas $1 linhas}} em',
	'refreshspecial-total-display' => '$1 {{PLURAL:$1|página refrescada|páginas refrescadas}}, totalizando $2 {{PLURAL:$2|linha|linhas}} em tempo $3 (tempo total de execução do script é $4)',
	'right-refreshspecial' => 'Refrescar páginas especiais',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'refreshspecial' => 'Atualizar páginas especiais',
	'refreshspecial-desc' => 'Permite a [[Special:RefreshSpecial|atualização manual]] das páginas especiais',
	'refreshspecial-title' => 'Atualizar páginas especiais',
	'refreshspecial-help' => 'Esta página especial providencia uma forma de atualizar páginas especiais manualmente.
Quando tiver escolhido todas as páginas que pretende atualizar, clique no botão "Atualizar selecionadas" abaixo para atualizar as páginas especiais selecionadas.
Aviso: a atualização pode demorar um tempo considerável em wikis grandes.',
	'refreshspecial-button' => 'Atualizar selecionadas',
	'refreshspecial-fail' => 'Por favor, selecione pelo menos uma página especial para atualizar.',
	'refreshspecial-refreshing' => 'atualizando páginas especiais',
	'refreshspecial-skipped' => 'insignificante, saltado',
	'refreshspecial-choice' => 'atualizando página especiais',
	'refreshspecial-js-disabled' => '(<i>Não pode selecionar todas as páginas quando o JavaScript está desabilitado</i>)',
	'refreshspecial-select-all-pages' => 'Selecionar todas as páginas',
	'refreshspecial-link-back' => 'Voltar à página especial',
	'refreshspecial-none-selected' => 'Não selecionou nenhuma página especial. Revertendo para a seleção padrão.',
	'refreshspecial-db-error' => 'Falha: erro de base de dados',
	'refreshspecial-no-page' => 'Página especial inexistente',
	'refreshspecial-slave-lagged' => 'Servidor escravo com atraso, aguardando...',
	'refreshspecial-reconnected' => 'Reconectado.',
	'refreshspecial-reconnecting' => 'Conexão falhou, reconectando em 10 segundos...',
	'refreshspecial-page-result' => '{{PLURAL:$1|obtida 1 linha|obtidas $1 linhas}} em',
	'refreshspecial-total-display' => '$1 {{PLURAL:$1|página atualizada|páginas atualizadas}}, totalizando $2 {{PLURAL:$2|linha|linhas}} em tempo $3 (tempo total de execução do script é $4)',
	'right-refreshspecial' => 'Atualizar páginas especiais',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 * @author Mihai
 */
$messages['ro'] = array(
	'refreshspecial' => 'Actualizează paginile speciale',
	'refreshspecial-desc' => 'Permite [[Special:RefreshSpecial|actualizarea manuală]] a paginilor speciale',
	'refreshspecial-title' => 'Actualizează paginile speciale',
	'refreshspecial-help' => "Această pagină specială furnizează mijloacele pentru a actualiza manual paginile speciale.
După ce aţi ales toate paginile pe care doriţi să le reîmprospătaţi, faceţi clic pe butonul de mai jos, \"Actualizează marcările\", pentru a actualiza paginile speciale marcate.
'''Atenţie:''' Actualizarea poate dura un timp mai îndelungat în wiki-urile mari.",
	'refreshspecial-button' => 'Actualizează marcările',
	'refreshspecial-fail' => 'Te rog marchează cel puţin o pagină specială care să fie actualizată',
	'refreshspecial-refreshing' => 'se actualizează paginile speciale',
	'refreshspecial-skipped' => 'superficial, omis',
	'refreshspecial-choice' => 'se actualizează paginile speciale',
	'refreshspecial-js-disabled' => '(<i>Nu poţi selecta toate paginile dacă JavaScript is dezactivat</i>)',
	'refreshspecial-select-all-pages' => 'Marchează toate paginile',
	'refreshspecial-link-back' => 'Înapoi la pagina specială',
	'refreshspecial-none-selected' => 'Nu ai selectat nicio pagină specială. Vor fi readuse marcările implicite.',
	'refreshspecial-db-error' => 'Eşuat: eroare la baza de date',
	'refreshspecial-no-page' => 'Nu există o astfel de pagină specială',
	'refreshspecial-slave-lagged' => 'Întârziere la serverul secundar, aştept ...',
	'refreshspecial-reconnected' => 'Reconectat.',
	'refreshspecial-reconnecting' => 'Eroare la conectare, reconectare în 10 secunde ...',
	'refreshspecial-page-result' => '$1 {{PLURAL:$1|rând obţinut|rânduri obţinute}} în',
	'refreshspecial-total-display' => 'Au fost actualizate $1 {{PLURAL:$1|pagină|pagini}} însumând $2 {{PLURAL:$2|rând|rânduri}} în timpul de $3 (timpul complet de rulare a script-ului a fost de $4)',
	'right-refreshspecial' => 'Actualizez paginile speciale',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Lockal
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'refreshspecial' => 'Обновить служебные страницы',
	'refreshspecial-desc' => 'Позволяет [[Special:RefreshSpecial|совершать ручное обновление]] служебных страниц',
	'refreshspecial-title' => 'Обновить служебные страницы',
	'refreshspecial-help' => "Эта служебная страница позволяет обновлять служебные страницы.
Вы можете выбрать все страницы, которые вам нужно обновить, нажать «Обновление выбрано» для обновления выбранных служебных страниц.
'''Внимание,''' обновление может вызвать задержку в больших вики.",
	'refreshspecial-button' => 'Обновление выбрано',
	'refreshspecial-fail' => 'Пожалуйста, выберите одну служебную страницу для обновления.',
	'refreshspecial-refreshing' => 'обновление служебных страниц',
	'refreshspecial-skipped' => 'ошибка, пропущена',
	'refreshspecial-choice' => 'обновление служебных страниц',
	'refreshspecial-js-disabled' => '(<i>Вы не можете выбрать все страницы, когда JavaScript отключён</i>)',
	'refreshspecial-select-all-pages' => 'Выбрать все страницы',
	'refreshspecial-link-back' => 'Вернуться к служебной странице',
	'refreshspecial-none-selected' => 'Вы не выбрали служебных страниц. Возвращение к выбору по умолчанию.',
	'refreshspecial-db-error' => 'Неудачно. Ошибка базы данных.',
	'refreshspecial-no-page' => 'Нет такой служебной страницы',
	'refreshspecial-slave-lagged' => 'Лаг зависимого сервера, ожидание...',
	'refreshspecial-reconnected' => 'Пересоединение.',
	'refreshspecial-reconnecting' => 'Соединение неудачно, пересоединение через 10 секунд...',
	'refreshspecial-page-result' => 'выведено $1 {{PLURAL:$1|строка|строки|строк}} в',
	'refreshspecial-total-display' => '{{PLURAL:$1|Обновлена $1 страница, содержащая|Обновлено $1 страницы, содержащих|Обновлено $1 страниц, содержащих}} $2 {{PLURAL:$2|строку|строки|строк}} за время $3 (полное время выполнения скрипта составило $4)',
	'right-refreshspecial' => 'обновление служебных страниц',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'refreshspecial' => 'Obnoviť špeciálne stránky',
	'refreshspecial-desc' => 'Umožňuje manuálne [[Special:RefreshSpecial|obnovenie špeciálnych stránok]]',
	'refreshspecial-title' => 'Obnoviť špeciálne stránky',
	'refreshspecial-help' => 'Táto špeciálna stránka slúži na manuálne obnovenie špeciálnych stránok.
Po vybraní všetkých stránok, ktoré chcete obnoviť, kliknite na tlačidlo „Obnoviť vybrané“.
Upozornenie: na väčších wiki môže obnovenie chvíľu trvať.',
	'refreshspecial-button' => 'Obnoviť vybrané',
	'refreshspecial-fail' => 'Prosím, vyberte aspoň jednu špeciálnu stránku, ktorá sa má obnoviť',
	'refreshspecial-refreshing' => 'obnovujú sa špeciálne stránky',
	'refreshspecial-skipped' => 'lacné, preskočené',
	'refreshspecial-choice' => 'obnovujú sa špeciálne stránky',
	'refreshspecial-js-disabled' => '(<i>Nie je možné použiť funkciu výberu všetkých stránok, keď máte vypnutý JavaScript.</i>)',
	'refreshspecial-select-all-pages' => 'Vybrať všetky stránky',
	'refreshspecial-link-back' => 'Späť na rozšírenie',
	'refreshspecial-none-selected' => 'Nevybrali ste žiadne špeciálne stránky. Vracia sa pôvodný výber.',
	'refreshspecial-db-error' => 'Chyba: chyba databázy',
	'refreshspecial-no-page' => 'Taká špeciálna stránka neexistuje',
	'refreshspecial-slave-lagged' => 'Spojenie s databázovým slave je pomalé, čaká sa...',
	'refreshspecial-reconnected' => 'Znovu pripojený.',
	'refreshspecial-reconnecting' => 'Spojenie zlyhalo, opätovné pripojenie o 10 sekúnd...',
	'refreshspecial-page-result' => '{{PLURAL:$1|zadaný $1 riadok|zadané $1 riadky|zadaných $1 riadkov}}',
	'refreshspecial-total-display' => '{{PLURAL:$1|Obnovená $1 stránka|Obnovené $1 stránky|Obnovených $1 stránok}}, čo činí $2 {{PLURAL:$2|riadok|riadky|riadkov}} za čas $3 (celkový čas behu skriptu je $4)',
	'right-refreshspecial' => 'Obnoviť špeciálne stránky',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'refreshspecial' => 'Spezioalsieden aktualisierje',
	'refreshspecial-desc' => 'Ferlööwet dät [[Special:RefreshSpecial|manuelle Apfriskjen fon Spezioalsieden]]',
	'refreshspecial-title' => 'Spezioalsieden aktualisierje',
	'refreshspecial-help' => 'Disse Spezioalsiede stoalt ne Reewe toun manuellen Aktualisierjen fon do Spezioalsieden kloor.
Sogau du aal Spezioalsieden toun Aktualisierjen uutwääld hääst, druk ju Aktualisierje-Schaltfläche, uum ju Aktualisierenge tou starjen.
Oachtenge: Dät Aktualisierjen kon ap groote Wikis laanger duurje.',
	'refreshspecial-button' => 'uutwäälde apfriskje',
	'refreshspecial-fail' => 'Hoak toumindest een Spezioalsiede toun Apfriskjen an.',
	'refreshspecial-refreshing' => 'Spezioalsieden wäide aktualisierd',
	'refreshspecial-skipped' => 'wäidloos, uursproangen',
	'refreshspecial-choice' => 'aktualisier Spezioalsieden',
	'refreshspecial-js-disabled' => '(<i>Du koast nit aal Sieden uutwääle, wan du Javascript deaktivierd hääst</i>)',
	'refreshspecial-select-all-pages' => 'aal Sieden uutwääle',
	'refreshspecial-link-back' => 'Tourääch tou juu Spezioalsiede',
);

/** Swedish (Svenska)
 * @author Najami
 * @author Rotsee
 */
$messages['sv'] = array(
	'refreshspecial' => 'Uppdatera specialsidor',
	'refreshspecial-desc' => 'Möjliggör [[Special:RefreshSpecial|manuell uppdatering]] av specialsidor',
	'refreshspecial-title' => 'Uppdatera specialsidor',
	'refreshspecial-help' => "Den här specialsidan låter dig uppdatera andra specialsidor manuellt.
Välj vilka sidor du vill uppdatera, och klicka på \"Uppdatera valda sidor\".
'''Obs:''' Uppdateringen kan ta en lång stund på en stor wiki.",
	'refreshspecial-button' => 'Uppdatera valda sidor',
	'refreshspecial-fail' => 'Välj minst en sida att uppdatera.',
	'refreshspecial-refreshing' => 'uppdaterar specialsidor',
	'refreshspecial-skipped' => 'överhoppad',
	'refreshspecial-choice' => 'uppdaterar specialsidor',
	'refreshspecial-js-disabled' => "(''Du behöver slå på JavaScript för att kunna markera alla sidor'')",
	'refreshspecial-select-all-pages' => 'Välj alla sidor',
	'refreshspecial-link-back' => 'Tillbaka till specialsidan',
	'refreshspecial-none-selected' => 'Du har inte valt någon specialsida. Återställer standardvalet.',
	'refreshspecial-db-error' => 'Misslyckades: Databasfel',
	'refreshspecial-no-page' => 'Ingen sådan specialsida',
	'refreshspecial-slave-lagged' => 'Slavservern släpar efter, väntar ...',
	'refreshspecial-reconnected' => 'Återansluten.',
	'refreshspecial-reconnecting' => 'Anslutning misslyckades, återansluter om 10 sekunder...',
	'refreshspecial-page-result' => 'databasen svarade med $1 {{PLURAL:$1|rad|rader}} i',
	'refreshspecial-total-display' => 'Uppdaterade $1 {{PLURAL:$1|sida|sidor}} om sammanlagt $2 {{PLURAL:$2|rad|rader}} på $3 (skriptet har körts i sammanlagt $4)',
	'right-refreshspecial' => 'Uppdatera specialsidor',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'refreshspecial' => 'ప్రత్యేక పేజీలను తాజాకరించు',
	'refreshspecial-title' => 'ప్రత్యేక పేజీల తాజాకరణ',
	'refreshspecial-refreshing' => 'ప్రత్యేక పేజీలను తాజాకరిస్తున్నాం',
	'refreshspecial-choice' => 'ప్రత్యేక పేజీలను తాజాకరిస్తున్నాం',
	'refreshspecial-js-disabled' => '(<i>జావాస్క్రిప్ట్ అచేతనంగా ఉన్నప్పుడు అన్నీ పేజీలను మీరు ఎంచుకోలేరు</i>)',
	'refreshspecial-select-all-pages' => 'అన్ని పేజీలను ఎంచుకోండి',
	'refreshspecial-link-back' => 'తిరిగి పొడగింతకు వెళ్ళండి',
	'refreshspecial-db-error' => 'విఫలం: డాటాబేసు పొరపాటు',
	'refreshspecial-no-page' => 'అటువంటి ప్రత్యేక పేజీ లేదు',
	'right-refreshspecial' => 'ప్రత్యేక పేజీలను తాజాకరించడం',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'refreshspecial' => 'Sariwain ang natatanging mga pahina',
	'refreshspecial-desc' => 'Nagpapahintulot ng [[Special:RefreshSpecial|kinakamay na pagsasariwa ng natatanging pahina]] ng mga natatanging pahina',
	'refreshspecial-title' => 'Sariwain ang natatanging mga pahina',
	'refreshspecial-help' => "Nagbibigay ang natatanging pahinang ito ng paraan kung paano makakamay ang pagsasariwa ng natatanging mga pahina.  Kapag napili mo na ang lahat ng mga pahinang nais mong sariwain, pindutin ang  pindutang ''Pinili ang sariwain'' na sa ibaba upang masariwa ang napiling natatanging mga pahina.  Babala: maaaring maging matagal ang pagsasariwa sa mas malalaking mga wiki.",
	'refreshspecial-button' => 'Pinili ang pagsasariwa',
	'refreshspecial-fail' => 'Pakilagyan ng tsek ang kahit isang natatanging pahinang sasariwain.',
	'refreshspecial-refreshing' => 'sinasariwa ang natatanging mga pahina',
	'refreshspecial-skipped' => 'mababa ang halaga, nilaktawan',
	'refreshspecial-choice' => 'sinasariwa ang natatanging mga pahina',
	'refreshspecial-js-disabled' => '(<i>Hindi mo mapipili ang lahat ng mga pahina kapag hindi gumagana ang JavaScript</i>)',
	'refreshspecial-select-all-pages' => 'Piliin lahat ng mga pahina',
	'refreshspecial-link-back' => 'Magbalik sa karugtong',
	'refreshspecial-none-selected' => 'Hindi ka pumili ng anumang natatanging mga pahina.  Nagbabalik sa likas na nakatakdang pagpipilian.',
	'refreshspecial-db-error' => 'Nabigo: kamalian sa kalipunan ng dato',
	'refreshspecial-no-page' => 'Walang ganyang natatanging pahina',
	'refreshspecial-slave-lagged' => 'Naiwan/bumagal ang alipin, naghihintay...',
	'refreshspecial-reconnected' => 'Muli nang naugnay.',
	'refreshspecial-reconnecting' => 'Nabigo ang pagkakaugnay (koneksyon), muling uugnay sa loob ng 10 segundo...',
	'refreshspecial-page-result' => 'nakakuha ng $1 {{PLURAL:$1|pahalang na hanay|pahalang na mga hanay}} mula sa',
	'refreshspecial-total-display' => 'Nasariwa na ang $1 mga pahina na may kabuoang $2 {{PLURAL:$2|pahalang na hanay|pahalang na mga hanay}} sa panahong $3 (buong panahon ng pagtakbo sa panitik ay $4)',
	'right-refreshspecial' => 'Sariwain ang natatanging mga pahina',
);

/** Turkish (Türkçe)
 * @author Karduelis
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'refreshspecial' => 'Yenilen özel sayfalar',
	'refreshspecial-title' => 'Yenilen özel sayfalar',
	'refreshspecial-button' => 'Seçileni yenile',
	'refreshspecial-choice' => 'özel sayfalar yenileniyor',
	'refreshspecial-link-back' => 'Özel sayfaya geri dön',
	'refreshspecial-reconnected' => 'Yeniden bağlanıldı.',
	'refreshspecial-reconnecting' => 'Bağlantı başarısız, 10 saniye içinde yeniden bağlanılıyor...',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'refreshspecial' => 'Оновити спеціальні сторінки',
	'refreshspecial-desc' => 'Дозволяє [[Special:RefreshSpecial|здійснювати ручне оновлення]] спеціальних сторінок',
	'refreshspecial-title' => 'Оновити спеціальні сторінки',
	'refreshspecial-help' => "Ця спеціальна сторінка дозволяє вручну оновлювати спеціальні сторінки.
Коли ви обрали всі сторінки, які ви хочете оновити, натисніть на кнопку \"Оновити вибрані\", розташовану нижче, щоб оновити вибрані спеціальні сторінки.
'''Увага:''' оновлення у великих вікі може зайняти якийсь час.",
	'refreshspecial-button' => 'Оновити вибрані',
	'refreshspecial-fail' => 'Будь ласка, оберіть принаймні одну спеціальну сторінку для оновлення.',
	'refreshspecial-refreshing' => 'оновлення спеціальних сторінок',
	'refreshspecial-skipped' => 'незначна помилка, пропущена',
	'refreshspecial-choice' => 'оновлення спеціальних сторінок',
	'refreshspecial-js-disabled' => '(<i>Ви не можете вибрати всі сторінки, коли відключений JavaScript</i>)',
	'refreshspecial-select-all-pages' => 'Виділити всі сторінки',
	'refreshspecial-link-back' => 'Повернутись до спеціальної сторінки',
	'refreshspecial-none-selected' => 'Ви не вибрали жодної спеціальної сторінки. Повернення до вибору за замовчуванням.',
	'refreshspecial-db-error' => 'Помилка: Помилка бази даних',
	'refreshspecial-no-page' => 'Немає такої спеціальної сторінки',
	'refreshspecial-slave-lagged' => 'Запізнення у обміні з залежним сервером, очікування...',
	'refreshspecial-reconnected' => "Повторне з'єднання.",
	'refreshspecial-reconnecting' => "Не вдалося встановити з'єднання, повтор через 10 секунд ...",
	'refreshspecial-page-result' => 'отримано $1 {{PLURAL:$1|рядок|рядки|рядків}} за',
	'refreshspecial-total-display' => 'Оновлено $1 {{PLURAL:$1|сторінку, що містить|сторінки, що містять|сторінок, що містять}} $2 {{PLURAL:$2|рядок|рядки|рядків}} за час $3 (загальний час роботи скрипту $4)',
	'right-refreshspecial' => 'Оновлення спеціальних сторінок',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'refreshspecial-title' => 'Udištada specialižed lehtpoled',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'refreshspecial' => 'Làm mới trang đặc biệt',
	'refreshspecial-desc' => 'Cho phép [[Special:RefreshSpecial|người dùng làm mới trang đặc biệt]]',
	'refreshspecial-title' => 'Làm mới trang đặc biệt',
	'refreshspecial-help' => 'Trang đặc biệt này là phương tiện để làm mới (refresh) các trang đặc biệt bằng tay.
Khi bạn chọn các trang bạn muốn làm mới, nhấn vào nút "Làm mới" phía dưới để thực hiện làm mới các trang đặc biệt đã chọn.
Cảnh báo: việc làm mới có thể sẽ mất một lúc nếu wiki khá lớn.',
	'refreshspecial-button' => 'Làm mới các trang đã chọn',
	'refreshspecial-fail' => 'Xin hãy chọn ít nhất một trang đặc biệt để làm mới.',
	'refreshspecial-refreshing' => 'đang làm mới trang đặc biệt',
	'refreshspecial-skipped' => 'không quan trọng, bỏ qua',
	'refreshspecial-choice' => 'đang làm mới trang đặc biệt',
	'refreshspecial-js-disabled' => '(<i>Bạn không thể chọn tất cả các trang trong khi JavaScript bị tắt</i>)',
	'refreshspecial-select-all-pages' => 'Chọn tất cả các trang',
	'refreshspecial-link-back' => 'Quay về bộ mở rộng',
	'refreshspecial-none-selected' => 'Bạn chưa chọn trang đặc biệt nào. Đang quay về lựa chọn mặc định.',
	'refreshspecial-db-error' => 'Thất bại: lỗi cơ sở dữ liệu',
	'refreshspecial-no-page' => 'Không có trang đặc biệt như vậy',
	'refreshspecial-slave-lagged' => 'Máy phụ bị trễ, đang chờ...',
	'refreshspecial-reconnected' => 'Đã kết nối lại.',
	'refreshspecial-reconnecting' => 'Kết nối thất bại, đang kết nối lại trong 10 giây nữa...',
	'refreshspecial-page-result' => 'có $1 {{PLURAL:$1|hàng|hàng}} trong',
	'refreshspecial-total-display' => 'Đã làm mới $1 {{PLURAL:$1|trang|trang}}, tổng cộng là $2 {{PLURAL:$2|hàng|hàng}} trong thời gian $3 (thời gian để hoàn thành chạy mã kịch bản là $4)',
	'right-refreshspecial' => 'Làm mới trang đặc biệt',
);

/** Volapük (Volapük)
 * @author Smeira
 */
$messages['vo'] = array(
	'refreshspecial-select-all-pages' => 'Välön padis valik',
	'refreshspecial-link-back' => 'Geikön lü pad patik',
	'refreshspecial-none-selected' => 'Evälol padis patik nonik. Geikobs lü stad kösömik.',
	'refreshspecial-db-error' => 'No eplöpon sekü nünodemapök',
	'refreshspecial-no-page' => 'Pad patik somik no dabinon',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 */
$messages['zh-hans'] = array(
	'refreshspecial' => '刷新特殊页面',
	'refreshspecial-title' => '刷新特殊页面',
	'refreshspecial-button' => '刷新已选页面',
	'refreshspecial-choice' => '正在刷新特殊页面',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'refreshspecial' => '重新載入特殊頁面',
	'refreshspecial-title' => '重新載入特殊頁面',
	'refreshspecial-button' => '重新載入已選頁面',
	'refreshspecial-choice' => '正在重新載入特殊頁面',
);

