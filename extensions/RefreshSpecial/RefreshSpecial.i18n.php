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
Warning: the refresh may take a while on larger wikis.',
	'refreshspecial-button' => 'Refresh selected',
	'refreshspecial-fail' => 'Please check at least one special page to refresh.',
	'refreshspecial-refreshing' => 'refreshing special pages',
	'refreshspecial-skipped' => 'cheap, skipped',
	'refreshspecial-success-subtitle' => 'refreshing special pages',
	'refreshspecial-choice' => 'refreshing special pages',
	'refreshspecial-js-disabled' => '(<i>You cannot select all pages when JavaScript is disabled</i>)',
	'refreshspecial-select-all-pages' => 'Select all pages',
	'refreshspecial-link-back' => 'Go back to special page',
	'refreshspecial-none-selected' => 'You have not selected any special pages. Reverting to default selection.',
	'refreshspecial-db-error' => 'Failed: database error',
	'refreshspecial-no-page' => 'No such special page',
	'refreshspecial-slave-lagged' => 'Slave lagged, waiting...',
	'refreshspecial-reconnected' => 'Reconnected.',
	'refreshspecial-reconnecting' => 'Connection failed, reconnecting in 10 seconds...',
	'refreshspecial-page-result' => 'got $1 {{PLURAL:$1|row|rows}} in',
	'refreshspecial-total-display' => 'Refreshed $1 {{PLURAL:$1|page|pages}} totaling $2 {{PLURAL:$2|row|rows}} in time $3 (complete time of the script run is $4)',
	'right-refreshspecial' => 'Refresh special pages',
);

/** Message documentation (Message documentation)
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
	'refreshspecial-success-subtitle' => '{{Identical|Refreshing special pages}}
Text displayed in the subtitle below the actual page title once the user has pressed the "Refresh selected" button.',
	'refreshspecial-js-disabled' => 'Displayed to users with JavaScript disabled so that they won\'t wonder why the "select all pages" checkbox isn\'t working properly.',
	'refreshspecial-select-all-pages' => 'Text displayed next to a checkbox on Special:RefreshSpecial; checking the checkbox allows to select all listed pages.',
	'refreshspecial-link-back' => 'Displayed on Special:RefreshSpecial after the user has pressed the "Refresh selected" button, at the bottom of the page.',
	'refreshspecial-none-selected' => 'If the user pressed the "Refresh selected" button without checking any of the checkboxes, this message will be displayed to him/her.',
	'refreshspecial-db-error' => 'Error message shown to the user if a database error is encountered while trying to do the necessary queries.',
	'refreshspecial-no-page' => 'If an invalid special page is encountered, this message will be displayed.',
	'refreshspecial-slave-lagged' => 'Displayed if a slave database server is lagging',
	'refreshspecial-reconnected' => 'Displayed if the connection to the database was lost for some reason but the extension was able to reconnect to it.',
	'refreshspecial-reconnecting' => 'Displayed if the connection to the database was lost for some reason.',
	'refreshspecial-total-display' => 'Displayed on Special:RefreshSpecial after the user has pressed the "Refresh selected" button if the refreshing was done successfully. $1 is the amount of special pages refreshed, $2 is the amount of database rows touched, $3 is the time how long it took to refresh all the selected special pages and $4 is the complete time of the script run.',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'refreshspecial' => 'تحديث الصفحات الخاصة',
	'refreshspecial-desc' => 'يسمح [[Special:RefreshSpecial|بتحديث يدوي]] للصفحات الخاصة',
	'refreshspecial-title' => 'تحديث الصفحات الخاصة',
	'refreshspecial-help' => 'هذه الصفحة الخاصة توفر الوسيلة لتحديث الصفحات الخاصة يدويا. عندما تختار كل الصفحات التي تريد تحديثها، اضغط على زر التحديث بالأسفل للبدء. تحذير: التحديث ربما يأخذ وقتا في الويكيات الكبيرة.',
	'refreshspecial-button' => 'تحديث المختارة',
	'refreshspecial-fail' => 'من فضلك علم على صفحة خاصة واحدة على الأقل للتحديث.',
	'refreshspecial-refreshing' => 'جاري تحديث الصفحات الخاصة',
	'refreshspecial-skipped' => 'رخيصة، تم تجاوزها',
	'refreshspecial-success-subtitle' => 'جاري تحديث الصفحات الخاصة',
	'refreshspecial-choice' => 'تحديث الصفحات الخاصة',
	'refreshspecial-js-disabled' => '(<i>أنت لا يمكنك اختيار كل الصفحات عندما تكون الجافاسكريبت معطلة</i>)',
	'refreshspecial-select-all-pages' => 'انتقاء كل الصفحات',
	'refreshspecial-link-back' => 'رجوع إلى الامتداد',
	'refreshspecial-none-selected' => 'أنت لم تختر أي صفحة خاصة. استرجاع إلى الاختيار الافتراضي.',
	'refreshspecial-db-error' => 'فشل: خطأ قاعدة بيانات',
	'refreshspecial-no-page' => 'لا توجد صفحة خاصة كهذه',
	'refreshspecial-slave-lagged' => 'الخادم التابع تأخر، جاري الانتظار...',
	'refreshspecial-reconnected' => 'تمت إعادة التوصيل.',
	'refreshspecial-reconnecting' => 'التوصيل فشل، إعادة التوصيل خلال 10 ثواني...',
	'refreshspecial-total-display' => 'حدث $1 صفحة بإجمالي $2 صف في وقت $3 (الزمن الإجمالي لعمل السكريبت هو $4)',
	'right-refreshspecial' => 'إنعاش الصفحات الخاصة',
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
	'refreshspecial-success-subtitle' => 'جارى تحديث الصفحات الخاصة',
	'refreshspecial-choice' => 'تحديث الصفحات الخاصة',
	'refreshspecial-js-disabled' => '(<i>أنت لا يمكنك اختيار كل الصفحات عندما تكون الجافاسكريبت معطلة</i>)',
	'refreshspecial-select-all-pages' => 'اختار كل الصفحات',
	'refreshspecial-link-back' => 'رجوع إلى الامتداد',
	'refreshspecial-none-selected' => 'أنت لم تختر أى صفحة خاصة. استرجاع إلى الاختيار الافتراضي.',
	'refreshspecial-db-error' => 'فشل: خطأ قاعدة بيانات',
	'refreshspecial-no-page' => 'لا توجد صفحة خاصة كهذه',
	'refreshspecial-slave-lagged' => 'الخادم التابع تأخر، جارى الانتظار...',
	'refreshspecial-reconnected' => 'تمت إعادة التوصيل.',
	'refreshspecial-reconnecting' => 'التوصيل فشل، إعادة التوصيل خلال 10 ثواني...',
	'refreshspecial-total-display' => 'تحديث $1 صفحة بإجمالى $2 صف فى وقت $3 (الزمن الإجمالى لعمل السكريبت هو $4)',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'refreshspecial-select-all-pages' => ' избиране на всички страници',
	'refreshspecial-no-page' => 'Няма такава специална страница',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'refreshspecial' => 'Obnovit speciální stránky',
	'refreshspecial-desc' => 'Umožňje manuální [[Special:RefreshSpecial|obnovení speciálních stránek]]',
	'refreshspecial-title' => 'Obnovit speciální stránky',
	'refreshspecial-help' => 'Tato speciální stránka slouží k manuálnímu obnovení speciálních stránek.
Po vybrání všech stránek, které chcete obnovit, klikněte na tlačítko „Obnovit vybrané”.
Upozornění: na větších wiki může obnovení chvíli trvat.',
	'refreshspecial-button' => 'Obnovit vybrané',
	'refreshspecial-fail' => 'Prosím, vyberte alespoň jednu speciální stránku, která se má obnovit',
	'refreshspecial-refreshing' => 'obnovují se speciální stránky',
	'refreshspecial-skipped' => 'přeskočeno',
	'refreshspecial-success-subtitle' => 'obnovují se speciální stránky',
	'refreshspecial-choice' => 'obnovují se speciální stránky',
	'refreshspecial-js-disabled' => '(<i>Není možné použít funkci výběru všech stránek, pokud máte vypnutý JavaScript</i>)',
	'refreshspecial-select-all-pages' => ' vybrat všechny stránky',
	'refreshspecial-link-back' => 'Zpět na rozšíření',
	'refreshspecial-none-selected' => 'Nevybrali jste žádné speciální stránky. Vrací se původní výběr.',
	'refreshspecial-db-error' => 'Chyba: chyba databáze',
	'refreshspecial-no-page' => 'Taková speciální stránka neexistuje',
	'refreshspecial-slave-lagged' => 'Spojení s databázovým slave je pomalé, čeká se…',
	'refreshspecial-reconnected' => 'Znovu připojený.',
	'refreshspecial-reconnecting' => 'Spojení selhalo, opětovné připojení za 10 sekund…',
	'refreshspecial-total-display' => '{{PLURAL:$1|Obnovena $1 stránka|Obnoveny $1 stránky|Obnoveno $1 stránek}}, což činí $2 {{PLURAL:$2|řádek|řádky|řádků}} za čas $3 (celkový čas běhu skriptu je $4)',
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
	'refreshspecial-success-subtitle' => 'aktualisiere Spezialseiten',
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
 * @author Revolus
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'refreshspecial-help' => 'Diese Spezialseite stellt ein Werkzeug zum manuellen Aktualisieren der Spezialseiten bereit.
Sobald Sie alle Spezialseiten zum Aktualisieren ausgewählt haben, drücken Sie die Aktualisieren-Schaltfläche, um die Aktualisierung zu starten.
Achtung: Das Aktualisieren kann auf großen Wikis länger dauern.',
	'refreshspecial-js-disabled' => '(<i>Sie können nicht alle Seiten auswählen, wenn Sie Javascript deaktiviert haben</i>)',
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
	'refreshspecial-success-subtitle' => 'refreŝigante specialajn paĝojn',
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
 * @author Imre
 */
$messages['es'] = array(
	'refreshspecial-here' => '<b>aquí</b>',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Jack Phoenix
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
	'refreshspecial-success-subtitle' => 'päivitetään toimintosivuja',
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
 * @author Zetud
 */
$messages['fr'] = array(
	'refreshspecial' => 'Rafraichir les pages spéciales',
	'refreshspecial-desc' => 'Permet [[Special:RefreshSpecial|l’actualisation manuelle]] des pages spéciales',
	'refreshspecial-title' => 'Rafraichir les pages spéciales',
	'refreshspecial-help' => 'Cette page spéciale fournit les moyens de rafraichir manuellement les pages spéciales.
Quand vous avez choisi toutes les pages que vous voulez actualiser, cliquer sur le bouton « Actualiser » ci-dessous pour actualiser les pages sélectionnées.
Attention : l’actualisation peut prendre un certain temps sur des wikis disposant d’une grande taille.',
	'refreshspecial-button' => 'Actualiser sélectionnées',
	'refreshspecial-fail' => 'Veuillez cocher au moins une page spéciale à rafraichir.',
	'refreshspecial-refreshing' => 'Actualisation des pages spéciales',
	'refreshspecial-skipped' => 'superficiel, sauté',
	'refreshspecial-success-subtitle' => 'actualisation des pages spéciales',
	'refreshspecial-choice' => 'actualisation des pages spéciales',
	'refreshspecial-js-disabled' => '(<i>Vous ne pouvez sélectionnez toutes les pages quand JavaScript est désactivé</i>)',
	'refreshspecial-select-all-pages' => 'Sélectionner toutes les pages',
	'refreshspecial-link-back' => 'Revenir à l’extension',
	'refreshspecial-none-selected' => 'Vous n’avez pas sélectionné de pages spéciales. Retour vers la sélection par défaut.',
	'refreshspecial-db-error' => 'Échec : erreur de la base de données',
	'refreshspecial-no-page' => 'Aucune page spéciale',
	'refreshspecial-slave-lagged' => 'Travail retardé, en cours…',
	'refreshspecial-reconnected' => 'Reconnecté.',
	'refreshspecial-reconnecting' => 'Échec de la connection, reconnection dans 10 secondes…',
	'refreshspecial-page-result' => '$1 {{PLURAL:$1|ligne obtenue|lignes obtenues}} en',
	'refreshspecial-total-display' => '$1 {{PLURAL:$1|page actualisée|pages actualisées}} totalisant $2 {{PLURAL:$2|ligne|lignes}} sur une durée de $3 (la durée complète de l’action du script est de $4)',
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
	'refreshspecial-success-subtitle' => 'actualizando as páxinas especiais',
	'refreshspecial-choice' => 'actualizando as páxinas especiais',
	'refreshspecial-js-disabled' => '(<i>Non pode seleccionar todas as páxinas cando o JavaScript está deshabilitado</i>)',
	'refreshspecial-select-all-pages' => 'Seleccionar todas as páxinas',
	'refreshspecial-link-back' => 'Voltar á extensión',
	'refreshspecial-none-selected' => 'Non seleccionou ningunha páxina especial. Revertendo á selección por defecto.',
	'refreshspecial-db-error' => 'Fallou: erro da base de datos',
	'refreshspecial-no-page' => 'Non existe tal páxina especial',
	'refreshspecial-slave-lagged' => 'Intervalo de retraso, agardando...',
	'refreshspecial-reconnected' => 'Reconectado.',
	'refreshspecial-reconnecting' => 'Fallou a conexión, reconectando en 10 segundos...',
	'refreshspecial-page-result' => '{{PLURAL:$1|Obtívose unha liña|Obtivéronse $1 liñas}} en',
	'refreshspecial-total-display' => '$1 {{PLURAL:$1|páxina refrescada|páxinas refrescadas}} dun total {{PLURAL:$2|dunha liña|de $2 liñas}} dunha duración de $3 (a duración completa da escritura é de $4)',
	'right-refreshspecial' => 'Actualizar as páxinas especiais',
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
	'refreshspecial-success-subtitle' => 'הדפים המיוחדים רועננו',
	'refreshspecial-choice' => 'דפים מיוחדים לרענון',
	'refreshspecial-js-disabled' => '(<i>לא תוכלו לבחור את כל הדפים כאשר JavaScript מבוטלת</i>)',
	'refreshspecial-select-all-pages' => 'בחירת כל הדפים',
	'refreshspecial-link-back' => 'חזרה להרחבה',
	'refreshspecial-none-selected' => 'לא בחרתם דפים מיוחדים. הבחירה תוחזר לברירת המחדל.',
	'refreshspecial-db-error' => 'ההחלפה נכשלה: שגיאת בסיס נתונים',
	'refreshspecial-no-page' => 'אין דף מיוחד כזה',
	'refreshspecial-reconnected' => 'בוצעה התחברות מחדש.',
	'refreshspecial-reconnecting' => 'ההתחברות נכשלה, מתחבר תוך 10 שניות...',
	'right-refreshspecial' => 'רענון דפים מיוחדים',
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
	'refreshspecial-success-subtitle' => 'refrescamento de paginas special',
	'refreshspecial-choice' => 'refrescamento de paginas special',
	'refreshspecial-js-disabled' => '<i>(Tu non pote seliger tote le paginas si JavaScript non es active)</i>',
	'refreshspecial-select-all-pages' => 'Seliger tote le paginas',
	'refreshspecial-link-back' => 'Retornar al extension',
	'refreshspecial-none-selected' => 'Tu non ha seligite alcun pagina special. Le selection retorna al predefinite.',
	'refreshspecial-db-error' => 'Falta: error del base de datos',
	'refreshspecial-no-page' => 'Iste pagina special non existe',
	'refreshspecial-slave-lagged' => 'Sclavo in retardo; attende…',
	'refreshspecial-reconnected' => 'Reconnectite.',
	'refreshspecial-reconnecting' => 'Connexion fallite, reconnexion post 10 secundas…',
	'refreshspecial-page-result' => 'obteneva $1 {{PLURAL:$1|linea|lineas}} in',
	'refreshspecial-total-display' => 'Refrescava $1 {{PLURAL:$1|pagina|paginas}} con un total de $2 {{PLURAL:$2|linea|lineas}} durante $3 (le durata total del execution del script es $4)',
	'right-refreshspecial' => 'Refrescar paginas special',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'refreshspecial' => 'Aggiorna pagine speciali',
	'refreshspecial-desc' => "Permette l'[[Special:RefreshSpecial|aggiornamento manuale]] di pagine speciali",
	'refreshspecial-title' => 'Aggiorna pagine speciali',
	'refreshspecial-help' => "Questa pagina speciale permette di aggiornare manualmente le pagine speciali. Quando hai scelto tutte le pagine che vuoi aggiornare, fai clic sul pulsante Aggiorna per effettuarlo. Attenzione: l'aggiornamento potrebbe richiedere un po' di tempo sulle wiki più grandi.",
	'refreshspecial-button' => 'Aggiorna pagine selezionate',
	'refreshspecial-fail' => 'Seleziona almeno una pagina speciale da aggiornare.',
	'refreshspecial-refreshing' => 'aggiornamento pagine speciali',
	'refreshspecial-success-subtitle' => 'aggiornamento pagine speciali',
	'refreshspecial-choice' => 'aggiornamento pagine speciali',
	'refreshspecial-js-disabled' => '(<i>Non è possibile selezionare tutte le pagine se JavaScript è disattivato</i>)',
	'refreshspecial-select-all-pages' => 'seleziona tutte le pagine',
	'refreshspecial-link-back' => "Torna all'estensione",
	'refreshspecial-none-selected' => 'Non è stata selezionata alcuna pagina speciale. Ripristino alla selezione di default.',
	'refreshspecial-db-error' => 'Fallito: errore del database',
	'refreshspecial-no-page' => 'Pagina speciale inesistente',
	'refreshspecial-reconnected' => 'Riconnesso.',
	'refreshspecial-reconnecting' => 'Connessione fallita, prossimo tentativo fra 10 secondi...',
	'refreshspecial-total-display' => '$1 pagine aggiornate per un totale di $2 linee in un tempo di $3 (il tempo totale di esecuzione dello script è di $4)',
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
	'refreshspecial-success-subtitle' => 'ដែល​ធ្វើឱ្យ​ទំព័រពិសេសស្រស់',
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
	'refreshspecial-help' => 'Hee die Söndersigg jitt Der e Werkzeuch för de Söndersigge ier Daten
vun Hand neu ußrechne ze johße.
Wann De all die Söndersigge doför ußjewählt häs, donn op dä Knopp
„{{int:refreshspecial-button}}“ klekke, öm dat neu Opnämme aanzefange.
Opjepaß: Dat op jruuße Wikis sing Zick doore.',
	'refreshspecial-button' => 'Uswahl neu opfreshe',
	'refreshspecial-fail' => 'Bes esu joot, un donn winnishsdens ein Sigg zom Opfresche ußwähle.',
	'refreshspecial-refreshing' => 'Ben de Söndersigge am opfresche',
	'refreshspecial-skipped' => 'bellesch, övverjange',
	'refreshspecial-success-subtitle' => 'Ben de Söndersigge am opfresche',
	'refreshspecial-choice' => 'Ben de Söndersigge am opfresche',
	'refreshspecial-js-disabled' => '(<i>De kanns nit all Sigge ußwähle, wann JavaSkipp nit jeiht</i>)',
	'refreshspecial-select-all-pages' => 'All Sigge ußwähle',
	'refreshspecial-link-back' => 'Jangk retuur op di Söndersigg',
	'refreshspecial-none-selected' => 'Do häs kein Söndersigge ußjgewählt.
Mer jonn fröm op de Shtandatt-Ußwahl.',
	'refreshspecial-db-error' => 'Dat es donevve jejange: Mer hatte ene Datebangk-Fähler.',
	'refreshspecial-no-page' => 'Esu en Söndersigg ham_mer nit.',
	'refreshspecial-slave-lagged' => 'Ene nohjeschaldte ßööver eß hengerher aam hingke, mer sen am waade&nbsp;…',
	'refreshspecial-reconnected' => 'De Verbendong es widder do.',
	'refreshspecial-reconnecting' => 'De Verbendong es fott. Weed widder opjebout in 10 Sekunde&nbsp;…',
	'refreshspecial-page-result' => 'hät {{PLURAL:$1|ein Reih|$1 Reije|kein einzije Reih}} en',
	'refreshspecial-total-display' => 'Han {{PLURAL:$1|ein Sigg|$1 Sigge|kein Sigg}} op der neuste Shtand jebraat,
met ensjesamp {{PLURAL:$2|ein Reih|$2 Reije|kein Reih}},
en dä Zick fun $3, wobei dä janze Vörjang $4 jedooht hät.',
	'right-refreshspecial' => 'Söndersigge ier Date neu opfreshe',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'refreshspecial' => 'Spezialsäiten aktualiséieren',
	'refreshspecial-desc' => 'Erlaabt et [[Special:RefreshSpecial|manuell Aktualiséierung]] vu Spezialsäiten',
	'refreshspecial-title' => 'Spezialsäiten aktualiséieren',
	'refreshspecial-help' => "Dës Spezialsäit erlaabt et fir Spezialsäite manuell z'aktualiséieren. 
Wann Dir all Säiten ugewielt hutt déi dir wëllt aktualiséiert kréien, da klickt op den ''Aktulisatiouns-Knäppchen'' hei ënnendrënner fir déi gewielte Spezialsäiten z'aktualiséieren. 
Opgepasst: op méi grousse Wikien kann d'Aktualisatioun eng Zäit daueren.",
	'refreshspecial-button' => 'Déi gewielten aktualiséieren',
	'refreshspecial-fail' => "Wielt mindestens eng Spezialsäit aus fir z'aktualiséieren.",
	'refreshspecial-refreshing' => 'Spezialsäiten aktualiséieren',
	'refreshspecial-skipped' => 'bëlleg, iwwersprong',
	'refreshspecial-success-subtitle' => 'Aktualisatioun vu Spezialsäiten',
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
	'refreshspecial-total-display' => "$1 {{PLURAL:$1|Säit|Säiten}} aktuliséiert mat am Ganzen $2 {{PLURAL:$2|Rei|Reien}} an $3 (Dauer) (d'Gesamtzäit déi de Script gebraucht huet ass $4)",
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'refreshspecial-here' => '<b>тесэ</b>',
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
	'refreshspecial-success-subtitle' => "bezig met het verversen van speciale pagina's",
	'refreshspecial-choice' => "bezig met het verversen van speciale pagina's",
	'refreshspecial-js-disabled' => "(<i>U kunt alle pagina's niet selecteren als JavaScript is uitgeschakeld</i>)",
	'refreshspecial-select-all-pages' => "Alle pagina's selecteren",
	'refreshspecial-link-back' => 'Terug naar uitbreiding',
	'refreshspecial-none-selected' => "U hebt geen speciale pagina's geselecteerd.
De standaardinstellingen zijn hersteld.",
	'refreshspecial-db-error' => 'Fout: databasefout',
	'refreshspecial-no-page' => 'De speciale pagina bestaat niet',
	'refreshspecial-slave-lagged' => 'Slaveserver loopt achter. Bezig met wachten...',
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
	'refreshspecial-success-subtitle' => 'oppdaterer spesialsider',
	'refreshspecial-choice' => 'oppdaterer spesialsider',
	'refreshspecial-js-disabled' => '(<i>Du kan ikkje merkja alle sider om JavaScript er slege av</i>)',
	'refreshspecial-select-all-pages' => 'Merk alle sider',
	'refreshspecial-link-back' => 'Gå attende til utvidinga',
	'refreshspecial-none-selected' => 'Du har ikkje merkt noka spesialsida. Stiller attende til standardval.',
	'refreshspecial-db-error' => 'Mislukkast: databasefeil',
	'refreshspecial-no-page' => 'Spesialsida finst ikkje',
	'refreshspecial-slave-lagged' => 'Forseinking i slavetenaren, ventar…',
	'refreshspecial-reconnected' => 'Kopla til på nytt.',
	'refreshspecial-reconnecting' => 'Tilkopling mislukkast, prøver om att om ti sekund…',
	'right-refreshspecial' => 'Oppdatera spesialsider',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'refreshspecial' => 'Oppdater spesialsider',
	'refreshspecial-desc' => 'Muliggjør [[Special:RefreshSpecial|manuell oppdatering]] av spesialsider',
	'refreshspecial-title' => 'Oppdater spesialsider',
	'refreshspecial-help' => 'Denne spesialsiden gjør at manuel kan oppdatere spesialsider. Når du har valgt hvilke sider du ønsker å oppdatere, klikk på Oppdater for å gjennomføre oppdateringen. Advarsel: Oppdatering kan ta en stund på større wikier.',
	'refreshspecial-button' => 'Oppdater valgte',
	'refreshspecial-fail' => 'Merk minst én spesialside for oppdatering',
	'refreshspecial-refreshing' => 'oppdaterer spesialsider',
	'refreshspecial-success-subtitle' => 'oppdaterer spesialsider',
	'refreshspecial-choice' => 'oppdaterer spesialsider',
	'refreshspecial-js-disabled' => "(''Du kan ikke merke alle sider om JavaScript er slått av'')",
	'refreshspecial-select-all-pages' => 'merk alle sider',
	'refreshspecial-link-back' => 'Tilbake til utvidelsen',
	'refreshspecial-none-selected' => 'Du har ikke merket noen spesialsider. Tilbakestiller til standardvalg.',
	'refreshspecial-db-error' => 'Mislyktes: databasefeil',
	'refreshspecial-no-page' => 'Ingen slik spesialside',
	'refreshspecial-slave-lagged' => 'Forsinkelse i slavetjeneren, venter …',
	'refreshspecial-reconnected' => 'Tilkoblet på nytt.',
	'refreshspecial-reconnecting' => 'Tilkobling mislyktes, prøver igjen om ti sekunder …',
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
	'refreshspecial-success-subtitle' => 'actualizacion de las paginas especialas',
	'refreshspecial-choice' => 'actualizacion de las paginas especialas',
	'refreshspecial-js-disabled' => '(<i>Podètz pas seleccionar totas las paginas quand JavaScript es desactivat</i>)',
	'refreshspecial-select-all-pages' => 'Seleccionar totas las paginas',
	'refreshspecial-link-back' => 'Tornar a l’extension',
	'refreshspecial-none-selected' => 'Avètz pas seleccionat cap de paginas especialas. Retorn cap a la seleccion per defaut.',
	'refreshspecial-db-error' => 'Fracàs : error de la banca de donada',
	'refreshspecial-no-page' => 'Pas cap de pagina especiala',
	'refreshspecial-slave-lagged' => 'Trabalh retardat, en cors…',
	'refreshspecial-reconnected' => 'Reconnectat.',
	'refreshspecial-reconnecting' => 'Fracàs de la connexion, reconnexion dins 10 segondas…',
	'refreshspecial-page-result' => '$1 {{PLURAL:$1|linha obtenguda|linhas obtengudas}} en',
	'refreshspecial-total-display' => "$1 {{PLURAL:$1|pagina actualizada|paginas actualizadas}} totalizant $2 {{PLURAL:$2|linha|linhas}} sus una durada de $3 (la durada completa de l’accion de l'escript es de $4)",
	'right-refreshspecial' => 'Actualizar las paginas especialas',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Jwitos
 * @author Leinad
 */
$messages['pl'] = array(
	'refreshspecial' => 'Odśwież strony specjalne',
	'refreshspecial-desc' => 'Umożliwia [[Special:RefreshSpecial|za pomocą strony specjalnej ręcznie odświeżać]] strony specjalne',
	'refreshspecial-title' => 'Odśwież strony specjalne',
	'refreshspecial-button' => 'Odśwież wybrane',
	'refreshspecial-fail' => 'Proszę zaznaczyć co najmniej jedną stronę specjalną do odświeżenia.',
	'refreshspecial-refreshing' => 'odświeżanie stron specjalnych',
	'refreshspecial-success-subtitle' => 'odświeżanie stron specjalnych',
	'refreshspecial-choice' => 'odświeżanie stron specjalnych',
	'refreshspecial-js-disabled' => '(<i>Nie możesz wybrać wszystkich stron, gdy JavaScript jest wyłączony</i>)',
	'refreshspecial-select-all-pages' => 'Zaznacz wszystkie strony',
	'refreshspecial-link-back' => 'Powrót do strony specjalnej',
	'refreshspecial-none-selected' => 'Nie wybrałeś żadnych stron specjalnych. Przywracanie domyślnego wyboru.',
	'refreshspecial-db-error' => 'Niepowodzenie: błąd bazy danych',
	'refreshspecial-no-page' => 'Nie ma takiej strony specjalnej',
	'refreshspecial-reconnected' => 'Ponownie połączono.',
	'refreshspecial-reconnecting' => 'Połączenie nie powiodło się, ponowne połączenie nastąpi za 10 sekund...',
);

/** Portuguese (Português)
 * @author Malafaya
 */
$messages['pt'] = array(
	'refreshspecial' => 'Refrescar páginas especiais',
	'refreshspecial-desc' => 'Permite o [[Special:RefreshSpecial|refrescamento manual]] das páginas especiais',
	'refreshspecial-title' => 'Refrescar páginas especiais',
	'refreshspecial-help' => 'Esta página especial providencia forma de refrescar páginas especiais.
Quando tiver escolhido todas as páginas que pretende refrescar, clique no botão "Refrescar seleccionadas" abaixo para refrescar as páginas especiais seleccionadas.
Aviso: o refrescamento pode demorar um tempo considerável em wikis grandes.',
	'refreshspecial-button' => 'Refrescar seleccionadas',
	'refreshspecial-fail' => 'Por favor, seleccione pelo menos uma página especial para refrescar.',
	'refreshspecial-refreshing' => 'a refrescar página especiais',
	'refreshspecial-skipped' => 'insignificante, saltado',
	'refreshspecial-success-subtitle' => 'a refrescar página especiais',
	'refreshspecial-choice' => 'a refrescar página especiais',
	'refreshspecial-js-disabled' => '(<i>Não pode seleccionar todas as páginas quando o JavaScript está desactivado</i>)',
	'refreshspecial-select-all-pages' => 'Seleccionar todas as páginas',
	'refreshspecial-link-back' => 'Voltar à extensão',
	'refreshspecial-none-selected' => 'Não seleccionou nenhuma página especial. Revertendo para a selecção padrão.',
	'refreshspecial-db-error' => 'Falha: erro de base de dados',
	'refreshspecial-no-page' => 'Página especial inexistente',
	'refreshspecial-slave-lagged' => 'Servidor escravo com atraso, aguardando...',
	'refreshspecial-reconnected' => 'Reconectado.',
	'refreshspecial-reconnecting' => 'Conexão falhada, reconectando em 10 segundos...',
	'refreshspecial-page-result' => '{{PLURAL:$1|obtida 1 linha|obtidas $1 linhas}} em',
	'refreshspecial-total-display' => '$1 {{PLURAL:$1|página refrescada|páginas refrescadas}}, totalizando $2 {{PLURAL:$2|linha|linhas}} em tempo $3 (tempo total de execução do script é $4)',
	'right-refreshspecial' => 'Refrescar páginas especiais',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'refreshspecial-db-error' => 'Eşuat: eroare la baza de date',
	'refreshspecial-reconnected' => 'Reconectat.',
);

/** Russian (Русский)
 * @author Ferrer
 */
$messages['ru'] = array(
	'refreshspecial-select-all-pages' => ' выбрать все страницы',
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
	'refreshspecial-success-subtitle' => 'obnovujú sa špeciálne stránky',
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

/** Swedish (Svenska)
 * @author Najami
 */
$messages['sv'] = array(
	'refreshspecial' => 'Uppdatera specialsidor',
	'refreshspecial-desc' => 'Möjliggör [[Special:RefreshSpecial|manuell uppdatering]] av specialsidor',
	'refreshspecial-title' => 'Uppdatera specialsidor',
	'refreshspecial-refreshing' => 'uppdaterar specialsidor',
	'refreshspecial-success-subtitle' => 'uppdaterar specialsidor',
	'refreshspecial-choice' => 'uppdaterar specialsidor',
	'refreshspecial-select-all-pages' => 'välj alla sidor',
	'refreshspecial-no-page' => 'Ingen sådan specialsida',
	'refreshspecial-reconnected' => 'Återansluten.',
	'refreshspecial-reconnecting' => 'Anslutning misslyckades, återansluter om 10 sekunder...',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'refreshspecial' => 'ప్రత్యేక పేజీలను తాజాకరించు',
	'refreshspecial-title' => 'ప్రత్యేక పేజీల తాజాకరణ',
	'refreshspecial-refreshing' => 'ప్రత్యేక పేజీలను తాజాకరిస్తున్నాం',
	'refreshspecial-success-subtitle' => 'ప్రత్యేక పేజీలను తాజాకరిస్తున్నాం',
	'refreshspecial-choice' => 'ప్రత్యేక పేజీలను తాజాకరిస్తున్నాం',
	'refreshspecial-js-disabled' => '(<i>జావాస్క్రిప్ట్ అచేతనంగా ఉన్నప్పుడు అన్నీ పేజీలను మీరు ఎంచుకోలేరు</i>)',
	'refreshspecial-select-all-pages' => 'అన్ని పేజీలను ఎంచుకోండి',
	'refreshspecial-link-back' => 'తిరిగి పొడగింతకు వెళ్ళండి',
	'refreshspecial-db-error' => 'విఫలం: డాటాబేసు పొరపాటు',
	'refreshspecial-no-page' => 'అటువంటి ప్రత్యేక పేజీ లేదు',
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
	'refreshspecial-success-subtitle' => 'sinasariwa ang natatanging mga pahina',
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

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'refreshspecial' => 'Làm mới trang đặc biệt',
	'refreshspecial-desc' => 'Cho phép [[Special:RefreshSpecial|người dùng làm mới trang đặc biệt]]',
	'refreshspecial-title' => 'Làm mới trang đặc biệt',
	'refreshspecial-help' => 'Trang đặc biệt này là phương tiện để làm mới (refresh) các trang đặc biệt. Khi bạn đã chọn các trang bạn muốn làm mới, nhấn vào nút Làm mới phía dưới để thực hiện. Cảnh báo: việc làm mới có thể sẽ mất một lúc nếu wiki khá lớn.',
	'refreshspecial-button' => 'Làm mới các trang đã chọn',
	'refreshspecial-fail' => 'Xin hãy chọn ít nhất một trang đặc biệt để làm mới.',
	'refreshspecial-refreshing' => 'đang làm mới trang đặc biệt',
	'refreshspecial-skipped' => 'không quan trọng, bỏ qua',
	'refreshspecial-success-subtitle' => 'đang làm mới trang đặc biệt',
	'refreshspecial-choice' => 'đang làm mới trang đặc biệt',
	'refreshspecial-js-disabled' => '(<i>Bạn không thể chọn tất cả các trang trong khi JavaScript bị tắt</i>)',
	'refreshspecial-select-all-pages' => ' chọn tất cả các trang',
	'refreshspecial-link-back' => 'Quay về bộ mở rộng',
	'refreshspecial-none-selected' => 'Bạn chưa chọn trang đặc biệt nào. Đang quay về lựa chọn mặc định.',
	'refreshspecial-db-error' => 'Thất bại: lỗi cơ sở dữ liệu',
	'refreshspecial-no-page' => 'Không có trang đặc biệt như vậy',
	'refreshspecial-slave-lagged' => 'Máy phụ bị trễ, đang chờ…',
	'refreshspecial-reconnected' => 'Đã kết nối lại.',
	'refreshspecial-reconnecting' => 'Kết nối thất bại, đang kết nối lại trong 10 giây nữa…',
	'refreshspecial-total-display' => 'Đã làm mới $1 trang, tổng cộng là $2 hàng trong thời gian $3 (thời gian để hoàn thành chạy mã kịch bản là $4)',
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
	'refreshspecial-success-subtitle' => '正在刷新特殊页面',
	'refreshspecial-choice' => '正在刷新特殊页面',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'refreshspecial' => '重新載入特殊頁面',
	'refreshspecial-title' => '重新載入特殊頁面',
	'refreshspecial-button' => '重新載入已選頁面',
	'refreshspecial-success-subtitle' => '正在重新載入特殊頁面',
	'refreshspecial-choice' => '正在重新載入特殊頁面',
);

