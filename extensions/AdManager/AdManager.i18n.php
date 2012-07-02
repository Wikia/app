<?php
/**
 * Internationalization file for the AdManager extension.
 *
 * @file
 * @ingroup Extensions
 */
$messages = array();

/** English
 * @author Ike Hecht
 */
$messages['en'] = array(
	'admanager' => 'Ad Manager',
	'admanagerzones' => 'Ad Manager Zones',
	'admanager-desc' => 'Provides a [[Special:AdManager|special page]] which allows sysops to set the zone for pages or categories',
	'admanager_docu' => 'To add or remove the ad zone of a page or entire category, add or remove its title below.',
	'admanagerzones_docu' => 'Enter each ad zone number on its own line.',
	'admanager_invalidtargetpage' => 'No page found with title "$1".',
	'admanager_invalidtargetcategory' => 'No category found with title "$1".',
	'admanager_notable' => 'Error! A required database table was not found! Run update.php first.',
	'admanager_noAdManagerZones' => 'Error! You must add some ad zones. Enter them at [[Special:AdManagerZones|Ad Manager Zones]].',
	'admanager_labelPage' => 'Page titles',
	'admanager_labelCategory' => 'Category names',
	'admanager_submit' => 'Submit',
	'admanager_noads' => 'Display no ads',
	'admanager_Page' => 'Pages',
	'admanager_Category' => 'Categories',
	'admanager_added' => 'Your changes have been saved',
	'admanager_noadsset' => '$1 has been set to show no ads',
	'admanager_addedzone' => 'Added zone',
	'admanager_zonenum' => 'Zone #: $1',
	'admanager_zonenotnumber' => 'Error! $1 is not a number.',
	'admanager_return' => 'Return to [[Special:AdManager|Ad Manager]]',
	'admanager_gotoads' => '[[Special:AdManager|Edit ad placement]]',
	'admanager_gotozones' => '[[Special:AdManagerZones|Edit ad zones]]',
	'right-admanager' => '[[Special:AdManager|Manage advertising configuration]]',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'admanager_submit' => '{{Identical|Submit}}',
	'admanager_Page' => '{{Identical|Pages}}',
	'admanager_Category' => '{{Identical|Categories}}',
	'right-admanager' => '{{doc-right|admanager}}',
);

/** Arabic (العربية)
 * @author روخو
 */
$messages['ar'] = array(
	'admanager_labelPage' => 'عناوين الصفحة:',
	'admanager_labelCategory' => 'أسماء التصنيف',
	'admanager_submit' => 'أرسل',
	'admanager_noads' => 'لا تعرض إعلانات',
	'admanager_Page' => 'صفحات',
	'admanager_added' => 'تم حفظ التغييرات',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'admanager' => 'Кіраўнік рэклямы',
	'admanagerzones' => 'Кіраваньне зонамі рэклямы',
	'admanager-desc' => 'Дадае [[Special:AdManager|спэцыяльную старонку]], якая дазваляе адміністратарам прызначаць зону для старонак ці катэгорыяў',
	'admanager_docu' => 'Для даданьня ці выдаленьня зоны рэклямы на старонцы ці ўсёй катэгорыі, трэба дадаць ці выдаліць назву ўнізе.',
	'admanagerzones_docu' => 'Увядзіце нумар кожнай зоны рэклямы ў асобным радку.',
	'admanager_invalidtargetpage' => 'Старонка з назвай «$1» ня знойдзеная.',
	'admanager_invalidtargetcategory' => 'Катэгорыя з назвай «$1» ня знойдзеная.',
	'admanager_notable' => 'Памылка! Неабходная табліца базы зьвестак ня знойдзеная! Спачатку запусьціце update.php.',
	'admanager_noAdManagerZones' => 'Памылка! Вам неабходна дадаць зоны рэклямы. Увядзіце іх у [[Special:AdManagerZones|Кіраваньні зонамі рэклямы]].',
	'admanager_labelPage' => 'Назвы старонак',
	'admanager_labelCategory' => 'Назвы катэгорыяў',
	'admanager_submit' => 'Захаваць',
	'admanager_noads' => 'Не паказваць рэкляму',
	'admanager_Page' => 'Старонкі',
	'admanager_Category' => 'Катэгорыі',
	'admanager_added' => 'Вашыя зьмены былі захаваныя',
	'admanager_noadsset' => '$1 быў устаноўлены так, каб не паказваць рэкляму',
	'admanager_addedzone' => 'Дададзеная зона',
	'admanager_zonenum' => 'Зона № $1',
	'admanager_zonenotnumber' => 'Памылка: $1 не зьяўляецца лікам.',
	'admanager_return' => 'Вярнуцца ў [[Special:AdManager|кіраваньне рэклямай]]',
	'admanager_gotoads' => '[[Special:AdManager|Рэдагаваць разьмяшчэньне рэклямы]]',
	'admanager_gotozones' => '[[Special:AdManagerZones|Рэдагаваць зоны рэклямы]]',
	'right-admanager' => '[[Special:AdManager|кіраваньне наладамі рэклямы]]',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'admanager_invalidtargetpage' => 'Не е намерена страница с името „$1“.',
	'admanager_invalidtargetcategory' => 'Не е намерена категория с името „$1“.',
	'admanager_noads' => 'Без показване на реклами',
	'admanager_Page' => 'Страници',
	'admanager_Category' => 'Категории',
	'admanager_added' => 'Промените бяха съхранени',
	'admanager_zonenum' => 'Зона #: $1',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'admanager' => 'Merour ar brudañ',
	'admanagerzones' => 'Takadoù merañ ar brudañ',
	'admanager_invalidtargetpage' => 'N\'eus bet kavet pajenn ebet dezhi an titl "$1".',
	'admanager_invalidtargetcategory' => 'N\'eus bet kavet rummañ ebet dezhañ an titl "$1".',
	'admanager_labelPage' => 'Titloù ar bajenn',
	'admanager_labelCategory' => 'Anvioù ar rummad :',
	'admanager_submit' => 'Kas',
	'admanager_noads' => 'Na ziskouez bruderezh',
	'admanager_Page' => 'Pajennoù',
	'admanager_Category' => 'Rummadoù',
	'admanager_added' => 'Enrollet eo bet ho kemmoù',
	'admanager_addedzone' => 'Takad ouzhpennet',
	'admanager_zonenum' => 'Takad #: $1',
	'admanager_zonenotnumber' => "Fazi ! $1 n'eo ket un niver.",
	'admanager_return' => 'Distreiñ da [[Special:AdManager|Ad Manager]]',
);

/** Catalan (Català)
 * @author Gemmaa
 */
$messages['ca'] = array(
	'admanager' => "Administrador d'anuncis",
	'admanagerzones' => "Zones de l'administrador d'anuncis",
	'admanager-desc' => "Proporciona un [[especial: AdManager|special pàgina]] que permet que els administradors d'establir la zona de pàgines o categories",
	'admanager_docu' => "Per afegir o suprimir la zona d'anunci d'una pàgina o categoria sencera, afegir o treure el seu títol sota.",
	'admanagerzones_docu' => "Cada número de zona d'anunci d'entrar en la seva pròpia línia.",
	'admanager_invalidtargetpage' => 'No hi ha pàgina s\'ha trobat amb títol " $1 ".',
	'admanager_invalidtargetcategory' => 'No hi ha pàgina s\'ha trobat amb títol " $1 ".',
	'admanager_notable' => "Error! No s'ha trobat una taula de base de dades requerit! Córrer update.php primer.",
	'admanager_noAdManagerZones' => "Error! Heu d'afegir algunes zones d'anuncis. Introduir-los a les [[especial: AdManagerZones|Administrador d'anuncis Zones]].",
	'admanager_labelPage' => 'Títol de la pàgina:',
	'admanager_labelCategory' => 'Nom de la categoria:',
	'admanager_submit' => 'Envia',
	'admanager_noads' => "No hi ha anuncis d'exhibició",
	'admanager_Page' => 'Pàgines',
	'admanager_Category' => 'Categories',
	'admanager_added' => "S'han desat els canvis",
	'admanager_noadsset' => "$1s'ha creat per mostrar cap anunci",
	'admanager_addedzone' => "Zona d'afegit",
	'admanager_zonenum' => '# La zona:$1',
	'admanager_zonenotnumber' => 'Error!  $1  no és un número.',
	'admanager_return' => "Torna a [[especial: AdManager|Administrador d'anuncis]]",
	'admanager_gotoads' => "[[Especial: AdManager|Edita la col. locació d'anuncis]]",
	'admanager_gotozones' => "[[Especial: AdManagerZones|Edita les zones d'anuncis]]",
	'right-admanager' => '[[Especial: AdManager|Gestió de configuració de publicitat]]',
);

/** Welsh (Cymraeg)
 * @author Pwyll
 */
$messages['cy'] = array(
	'admanager' => 'Rheolwr hysbysebion',
	'admanagerzones' => 'Ardaloedd Rheolwr Hysbysebion',
	'admanager_invalidtargetpage' => 'Ni ddaethpwyd o hyd i dudalen gyda\'r teitl "$1".',
	'admanager_invalidtargetcategory' => 'Ni ddaethpwyd o hyd i gategori gyda\'r teitl "$1".',
	'admanager_notable' => 'Gwall! Ni ddaethpwyd o hyd i dabl cronfa ddata angenrheidiol. Rhedwch update.php yn gyntaf.',
	'admanager_noAdManagerZones' => 'Gwall! Rhaid i chi ychwanegu rhai ardaloedd. Nodwch nhw yn [[Special:AdManagerZones|Ardaloedd Rheolwr Hysbysebion]].',
	'admanager_labelPage' => 'Teitlau tudalennau',
	'admanager_submit' => 'Cyflwyner',
	'admanager_noads' => 'Peidio arddangos hysbysebion',
	'admanager_Page' => 'Tudalennau',
	'admanager_added' => 'Cadwyd eich newidiadau',
	'admanager_noadsset' => 'Gosodwyd $1 i beidio ag arddangos hysbysebion',
	'admanager_addedzone' => 'Ardal a ychwanegwyd',
	'admanager_zonenum' => 'Ardal #: $1',
	'admanager_zonenotnumber' => 'Gwall! Nid rhif yw $1',
	'admanager_return' => 'Dychwelyd i [[Special:AdManager|Rheolwr Hysbesebion]]',
);

/** German (Deutsch)
 * @author Kghbln
 */
$messages['de'] = array(
	'admanager' => 'Anzeigenverwaltung',
	'admanagerzones' => 'Anzeigenverwaltung - Anzeigenbereiche',
	'admanager-desc' => 'Ergänzt eine [[Special:AdManager|Spezialseite]], die es Administratoren ermöglicht einen Anzeigenbereich für Seiten und Kategorien festzulegen',
	'admanager_docu' => 'Um einen Anzeigenbereich bei einer Seite oder Kategorie hinzuzufügen oder zu entfernen, muss deren Name hinzugefügt oder entfernt werden.',
	'admanagerzones_docu' => 'Bitte die Nummer jedes Anzeigenbereichs in einer eigenen Zeile angeben.',
	'admanager_invalidtargetpage' => 'Es wurde keine Seite mit dem Namen „$1“ gefunden.',
	'admanager_invalidtargetcategory' => 'Es wurde keine Kategorie mit dem Namen „$1“ gefunden.',
	'admanager_notable' => 'Fehler: Die erforderliche Datenbanktabelle wurde nicht gefunden. Bitte update.php ausführen.',
	'admanager_noAdManagerZones' => 'Fehler: Es müssen zunächst Anzeigebereiche hinzugefügt werden. Dies ist auf der Spezialseite [[Special:AdManagerZones|Anzeigenverwaltung - Anzeigenbereiche]] möglich.',
	'admanager_labelPage' => 'Seitennamen',
	'admanager_labelCategory' => 'Kategorienamen',
	'admanager_submit' => 'Speichern',
	'admanager_noads' => 'Keine Anzeigen anzeigen',
	'admanager_Page' => 'Seiten',
	'admanager_Category' => 'Kategorien',
	'admanager_added' => 'Die Änderungen wurden gespeichert',
	'admanager_noadsset' => 'Für $1 wurde festgelegt, keine Anzeigen anzuzeigen',
	'admanager_addedzone' => 'Anzeigenbereich wurde hinzugefügt',
	'admanager_zonenum' => 'Anzeigenbereichsnummer: $1',
	'admanager_zonenotnumber' => 'Fehler: Bei $1 handelt es sich nicht um eine Anzeigenbereichsnummer.',
	'admanager_return' => 'Zurück zur [[Special:AdManager|Anzeigenverwaltung]]',
	'admanager_gotoads' => '[[Special:AdManager|Anzeigen bearbeiten]]',
	'admanager_gotozones' => '[[Special:AdManagerZones|Anzeigenbereiche bearbeiten]]',
	'right-admanager' => '[[Special:AdManager|Anzeigen konfigurieren]]',
);

/** Zazaki (Zazaki)
 * @author Mirzali
 */
$messages['diq'] = array(
	'admanager_submit' => 'Qeyd ke',
	'admanager_Page' => 'Peli',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'admanager_invalidtargetpage' => 'Neniu paĝo trovita laŭ titolo "$1".',
	'admanager_labelPage' => 'Titoloj de paĝoj',
	'admanager_labelCategory' => 'Nomoj de kategorioj',
	'admanager_Page' => 'Paĝoj',
	'admanager_Category' => 'Kategorioj',
);

/** Spanish (Español)
 * @author Armando-Martin
 */
$messages['es'] = array(
	'admanager' => 'Administrador de publicidad',
	'admanagerzones' => 'Zonas de administrador de publicidad',
	'admanager-desc' => 'Proporciona una [[Special:AdManager|página especial]] que permite a los sysops (operadores de sistema) establecer la zona de páginas o categorías',
	'admanager_docu' => 'Para agregar o quitar la zona de publicidad de una página o de toda la categoría, agregue o elimine su título a continuación.',
	'admanagerzones_docu' => 'Introduzca cada número de zona de publicidad en su propia línea.',
	'admanager_invalidtargetpage' => 'Ninguna página encontrada con el título "$1".',
	'admanager_invalidtargetcategory' => 'Ninguna categoría encontrada con el título "$1".',
	'admanager_notable' => '¡Error! ¡No se encontró una tabla de base de datos requerida! Ejecute primero update.php.',
	'admanager_noAdManagerZones' => '¡Error! Debe agregar algunas zonas de publicidad. Introdúzcalas en [[Special:AdManagerZones|el administrador de zonas de publicidad]].',
	'admanager_labelPage' => 'Títulos de página',
	'admanager_labelCategory' => 'Nombres de categoría',
	'admanager_submit' => 'Enviar',
	'admanager_noads' => 'No mostrar anuncios',
	'admanager_Page' => 'Páginas',
	'admanager_Category' => 'Categorías',
	'admanager_added' => 'Sus cambios han sido guardados',
	'admanager_noadsset' => '$1 se ha establecido para no mostrar anuncios',
	'admanager_addedzone' => 'Zona adicional',
	'admanager_zonenum' => 'Zona #: $1',
	'admanager_zonenotnumber' => '¡Error!  $1 no es un número.',
	'admanager_return' => 'Volver a [[Special: AdManager|Administrador de publicidad]]',
	'admanager_gotoads' => '[[Special:AdManager|Editar ubicación de publicidad]]',
	'admanager_gotozones' => '[[Special:AdManagerZones|Editar zonas de publicidad]]',
	'right-admanager' => '[[Special:AdManager|Administrar configuración de publicidad]]',
);

/** Persian (فارسی)
 * @author ZxxZxxZ
 */
$messages['fa'] = array(
	'admanager_Page' => 'صفحه‌ها',
	'admanager_Category' => 'رده‌ها',
	'admanager_added' => 'تغییرات شما ذخیره شده‌است',
	'admanager_zonenum' => 'شمارهٔ منطقه: $1',
	'admanager_zonenotnumber' => 'خطا! $1 عدد نیست.',
);

/** French (Français)
 * @author Gomoko
 * @author Hashar
 */
$messages['fr'] = array(
	'admanager' => 'Gestionnaire de publicité',
	'admanagerzones' => 'Zones de gestionnaire de publicité',
	'admanager-desc' => 'Fournit une [[Special:AdManager|page spéciale]] qui permet aux sysops de fixer la zone pour les pages ou les catégories',
	'admanager_docu' => "Pour ajouter ou supprimer la zone de publicité d'une page ou d'une catégorie complète, ajoutez ou supprimez son titre ci-dessous.",
	'admanagerzones_docu' => 'Entrez chaque numéro de zone de publicité sur sa propre ligne.',
	'admanager_invalidtargetpage' => 'Aucune page trouvé avec le titre « $1 ».',
	'admanager_invalidtargetcategory' => 'Pas de catégorie trouvée avec le titre "$1".',
	'admanager_notable' => "Erreur! Une table de base de données requise n'a pas été trouvée! Lancez d'abord update.php.",
	'admanager_noAdManagerZones' => 'Erreur! Vous devez ajouter des zones de publicité. Entrez-les dans les [[Special:AdManagerZones|zones de gestionnaire de publicité]].',
	'admanager_labelPage' => 'Titres de page',
	'admanager_labelCategory' => 'Noms de catégorie',
	'admanager_submit' => 'Soumettre',
	'admanager_noads' => 'Ne pas afficher de publicité',
	'admanager_Page' => 'Pages',
	'admanager_Category' => 'Catégories',
	'admanager_added' => 'Vos modifications ont été enregistrées',
	'admanager_noadsset' => "$1 a été paramétré pour n'afficher aucune publicité",
	'admanager_addedzone' => 'Zone ajoutée',
	'admanager_zonenum' => 'Zone #: $1',
	'admanager_zonenotnumber' => "Erreur ! « $1 » n'est pas un nombre.",
	'admanager_return' => 'Revenir à [[Special:AdManager|Gestionnaire de publicité]]',
	'admanager_gotoads' => "[[Special:AdManager|Modifier l'emplacement d'une publicité]]",
	'admanager_gotozones' => '[[Special:AdManagerZones|Modifier les zones de publicité]]',
	'right-admanager' => '[[Special:AdManager|Gérer la configuration des publicités]]',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'admanager' => 'Administrator de recllâmes',
	'admanagerzones' => 'Zones de l’administrator de recllâmes',
	'admanager_invalidtargetpage' => 'Niona pâge avouéc lo titro « $1 » at étâ trovâ.',
	'admanager_invalidtargetcategory' => 'Niona catègorie avouéc lo titro « $1 » at étâ trovâ.',
	'admanager_labelPage' => 'Titros de pâges',
	'admanager_labelCategory' => 'Noms de catègories',
	'admanager_submit' => 'Sometre',
	'admanager_noads' => 'Fâre vêre gins de recllâma',
	'admanager_Page' => 'Pâges',
	'admanager_Category' => 'Catègories',
	'admanager_added' => 'Voutros changements ont étâ encartâs',
	'admanager_noadsset' => '$1 at étâ dèfeni por fâre vêre gins de recllâma',
	'admanager_addedzone' => 'Zona apondua',
	'admanager_zonenum' => 'Numerô de zona : $1',
	'admanager_zonenotnumber' => 'Èrror ! $1 est pas un nombro.',
	'admanager_return' => 'Retôrn a l’[[Special:AdManager|administrator de recllâmes]]',
	'admanager_gotoads' => '[[Special:AdManager|Changiér lo placement de recllâma]]',
	'admanager_gotozones' => '[[Special:AdManagerZones|Changiér les zones de recllâmes]]',
	'right-admanager' => '[[Special:AdManager|Administrar la configuracion de la recllâma]]',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'admanager' => 'Xestor de anuncios',
	'admanagerzones' => 'Xestor das zonas de anuncios',
	'admanager-desc' => 'Proporciona unha [[Special:AdManager|páxina especial]] que permite aos administradores definir a zona das páxinas ou categorías',
	'admanager_docu' => 'Para engadir ou eliminar a zona de anuncios dunha páxina ou categoría enteira, engada ou elimine o seu título a continuación.',
	'admanagerzones_docu' => 'Escriba cada número de zona de anuncios na súa propia liña.',
	'admanager_invalidtargetpage' => 'Non se atopou ningunha páxina co título "$1".',
	'admanager_invalidtargetcategory' => 'Non se atopou ningunha categoría co título "$1".',
	'admanager_notable' => 'Erro! Non se atopou a táboa da base de datos necesaria para continuar! Execute update.php primeiro.',
	'admanager_noAdManagerZones' => 'Erro! Ten que engadir algunhas zonas de anuncios. Insíraas no [[Special:AdManagerZones|Xestor das zonas de anuncios]].',
	'admanager_labelPage' => 'Títulos da páxinas',
	'admanager_labelCategory' => 'Nomes da categorías',
	'admanager_submit' => 'Enviar',
	'admanager_noads' => 'Non mostrar os anuncios',
	'admanager_Page' => 'Páxinas',
	'admanager_Category' => 'Categorías',
	'admanager_added' => 'Gardáronse os seus cambios',
	'admanager_noadsset' => '$1 definiuse para non mostrar os anuncios',
	'admanager_addedzone' => 'Zona engadida',
	'admanager_zonenum' => 'Zona nº: $1',
	'admanager_zonenotnumber' => 'Erro! "$1" non é un número.',
	'admanager_return' => 'Volver ao [[Special:AdManager|Xestor de anuncios]]',
	'admanager_gotoads' => '[[Special:AdManager|Editar a posición do anuncio]]',
	'admanager_gotozones' => '[[Special:AdManagerZones|Editar as zonas dos anuncios]]',
	'right-admanager' => '[[Special:AdManager|Xestionar a configuración dos anuncios]]',
);

/** Hebrew (עברית)
 * @author Deror avi
 */
$messages['he'] = array(
	'admanager' => 'ניהול המודעות',
	'admanagerzones' => 'איזור ניהול המודעות',
	'admanager_docu' => 'על מנת להוסיף או להסיר את איזור המועדות של עמוד או של קטגוריה שלמה, נא להוסיף או להסיר את כותרתו מטה.',
	'admanagerzones_docu' => 'נא להזין כל מספר איזור מודעה בשורה נפרדת.',
	'admanager_invalidtargetpage' => 'לא נמצא דף שכותרתו "$1".',
	'admanager_invalidtargetcategory' => 'לא נמצאה קטגוריה שכותרתה "$1".',
	'admanager_notable' => 'שגיאה! לא נמצאה טבלת מסד הנתונים! נא הרץ תחילה את update.php',
	'admanager_noAdManagerZones' => 'שגיאה! עליך להזין אזורי מודעות. נא הזנתם ב- [[Special:AdManagerZones|איזור ניהול המודעות]].',
	'admanager_labelPage' => 'כותרות דפים',
	'admanager_labelCategory' => 'שמות קטגוריות',
	'admanager_submit' => 'שליחה',
	'admanager_noads' => 'הצגה ללא פרסומות',
	'admanager_Page' => 'דפים',
	'admanager_Category' => 'קטגוריות',
	'admanager_added' => 'השינויים נשמרו',
	'admanager_noadsset' => '$1 הוגדרה להצגה ללא פרסומות',
	'admanager_addedzone' => 'אזור נוסף',
	'admanager_zonenum' => 'אזור #: $1',
	'admanager_zonenotnumber' => 'שגיאה! $1 אינו מספר.',
	'admanager_return' => 'חזרה ל[[Special:AdManager|מנהל הפרסומות]]',
	'admanager_gotoads' => '[[Special:AdManager|עריכת מיקום מודעה]]',
	'admanager_gotozones' => '[[Special:AdManagerZones|עריכת איזורי מודעה]]',
	'right-admanager' => '[[Special:AdManager|ניהול תצורת פרסום]]',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'admanager' => 'Ad Manager',
	'admanagerzones' => 'Ad Manager - nawěškowe wobłuki',
	'admanager-desc' => 'Dodawa [[Special:AdManager|specialnu stronu]], kotraž administratoram dowoluje, zo bychu nawěškowy wobłuk za strony abo kategorije nastajili',
	'admanager_docu' => 'Zo by nawěškowy wobłuk strony abo cyłeje kategorije přidał abo wotstronił, přidaj abo wotstroń jeje titul.',
	'admanagerzones_docu' => 'Zapodaj čisło kóždeho nawěškoweho wobłuka we swójskej lince.',
	'admanager_invalidtargetpage' => 'Žana strona z titulom "$1" namakana.',
	'admanager_invalidtargetcategory' => 'Žana kategorija z titulom "$1" namakana.',
	'admanager_notable' => 'Zmylk! Trěbna tabela datoweje banki njeje so namakała! Wuwjedź najprjedy update.php.',
	'admanager_noAdManagerZones' => 'Zmylk! Dyrbiš nawěškowe wobłuki přidać. Zapodaj je na [[Special:AdManagerZones|Ad Manager - nawěškowe wobłuki]]',
	'admanager_labelPage' => 'Titule stronow',
	'admanager_labelCategory' => 'Kategorijowe mjena',
	'admanager_submit' => 'Wotpósłać',
	'admanager_noads' => 'Žane nawěški pokazać',
	'admanager_Page' => 'Strony',
	'admanager_Category' => 'Kategorije',
	'admanager_added' => 'Twoje změny su so składowali',
	'admanager_noadsset' => '$1 je so tak nastajił, zo so nawěški njepokazuja',
	'admanager_addedzone' => 'Nawěškowy wobłuk přidaty',
	'admanager_zonenum' => 'Čisło nawěškoweho wobłuka: $1',
	'admanager_zonenotnumber' => 'Zmylk! $1 ličba njeje.',
	'admanager_return' => 'Wróćo k [[Special:AdManager|Ad Manager]]',
	'admanager_gotoads' => '[[Special:AdManager|Nawěški wobdźěłać]]',
	'admanager_gotozones' => '[[Special:AdManagerZones|Nawěškowe wobłuki wobdźěłać]]',
	'right-admanager' => '[[Special:AdManager|Nawěški konfigurować]]',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'admanager' => 'Gestor de annuncios',
	'admanagerzones' => 'Zonas del gestor de annuncios',
	'admanager-desc' => 'Forni un [[Special:AdManager|pagina special]] que permitte al administratores de definir le zona pro paginas o categorias',
	'admanager_docu' => 'Pro adder o remover le zona de annuncios de un pagina o de un tote categoria, adde o remove su titulo hic infra.',
	'admanagerzones_docu' => 'Entra le numero de cata zona de annuncios in su proprie linea.',
	'admanager_invalidtargetpage' => 'Nulle pagina trovate con titulo "$1".',
	'admanager_invalidtargetcategory' => 'Nulle categoria trovate con titulo "$1".',
	'admanager_notable' => 'Error! Un tabella requisite non esseva trovate in le base de datos! Executa update.php primo.',
	'admanager_noAdManagerZones' => 'Error! Es necessari adder alcun zonas de annuncios. Entra los in le pagina [[Special:AdManagerZones|Zonas del gestor de annuncios]].',
	'admanager_labelPage' => 'Titulos de pagina',
	'admanager_labelCategory' => 'Nomines de categoria',
	'admanager_submit' => 'Submitter',
	'admanager_noads' => 'Non monstrar annuncios',
	'admanager_Page' => 'Paginas',
	'admanager_Category' => 'Categorias',
	'admanager_added' => 'Le cambiamentos ha essite salveguardate.',
	'admanager_noadsset' => '$1 ha essite configurate pro non monstrar annuncios',
	'admanager_addedzone' => 'Zona addite',
	'admanager_zonenum' => '№ de zona: $1',
	'admanager_zonenotnumber' => 'Error! $1 non es un numero.',
	'admanager_return' => 'Retornar al [[Special:AdManager|gestor de annuncios]]',
	'admanager_gotoads' => '[[Special:AdManager|Modificar placiamento de annuncio]]',
	'admanager_gotozones' => '[[Special:AdManagerZones|Modificar zonas de annuncios]]',
	'right-admanager' => '[[Special:AdManager|Gerer configuration de publicitate]]',
);

/** Japanese (日本語)
 * @author Fryed-peach
 */
$messages['ja'] = array(
	'admanager_Category' => 'カテゴリー',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'admanager' => 'Gestioun vun de Reklammen',
	'admanagerzones' => 'Gestioun vun den Zone vun de Reklammen',
	'admanager-desc' => 'Setzt eng [[Special:AdManager|Spezialsäit]] derbäi déi et Administrateuren erlaabt fir Zone vu Säiten oder Kategorien ze definéieren',
	'admanager_invalidtargetpage' => 'Keng Säit mam Titel "$1" fonnt.',
	'admanager_invalidtargetcategory' => 'Keng Kategorie mam Titel "$1" fonnt.',
	'admanager_notable' => "Feeler: Déi erfuerdert Datebanktabell gouf net fonnt! Start d'éischt update.php.",
	'admanager_labelPage' => 'Säitennimm',
	'admanager_labelCategory' => 'Nimm vun de Kategorien:',
	'admanager_submit' => 'Späicheren',
	'admanager_noads' => 'Keng Reklamme weisen',
	'admanager_Page' => 'Säiten',
	'admanager_Category' => 'Kategorien',
	'admanager_added' => 'Är Ännerunge goufe gespäichert',
	'admanager_noadsset' => '$1 gouf esou agestallt datt keng Reklamme gewise ginn',
	'admanager_zonenum' => 'Zone #: $1',
	'admanager_zonenotnumber' => 'Feeler! $1 ass keng Zuel.',
	'admanager_return' => "Zréck op d'[[Special:AdManager|Gestioun vun de Reklammen]]",
);

/** Limburgish (Limburgs)
 * @author Pahles
 */
$messages['li'] = array(
	'admanager' => 'Advertentiebehier',
	'admanagerzones' => 'Zones veur advertentiebehier',
	'admanager-desc' => "Veug 'n [[Special:AdManager|speciaal pagina]] bie die systeemwèrkers in sjtaot sjtelt om de zone veur pagina's of categorieë in te sjtèlle",
	'admanager_docu' => "De kins 'n advertentiezone van 'n pagina of volledige categorie biedoon of ewegsjaffe door de naam devaan bie te doon of eweg te sjaffe.",
	'admanagerzones_docu' => "Veur jeder advertentiezone op 'n eige regel in.",
	'admanager_invalidtargetpage' => 'Gein pagina gevónje mit de naam "$1".',
	'admanager_invalidtargetcategory' => 'Gein categorie gevónje mit de naam "$1".',
	'admanager_notable' => "Fout! 'n Vereiste databasetabel is neet gevónje! Veur iers update.php oet.",
	'admanager_noAdManagerZones' => 'Fout! De mós advertentiezones toeveuge. Veur ze in op de [[Special:AdManagerZones|speciaal pagina]].',
	'admanager_labelPage' => 'Paginaname',
	'admanager_labelCategory' => 'Categoriename',
	'admanager_submit' => 'Opsjlaon',
	'admanager_noads' => 'Gein advertenties weergaeve',
	'admanager_Page' => "Pagina's",
	'admanager_Category' => 'Categorieë',
	'admanager_added' => 'Dien verangeringe zeen opgesjlage',
	'admanager_noadsset' => '$1 is ingesjtèld om gein advertenties weer te gaeve',
	'admanager_addedzone' => 'Zone toegeveug',
	'admanager_zonenum' => 'Zonenómmer: $1',
	'admanager_zonenotnumber' => 'Fout: $1 is gein getal.',
	'admanager_return' => 'Trök nao [[Special:AdManager|advertentiebehier]]',
	'admanager_gotoads' => '[[Special:AdManager|Advertentieplaatsing bewirke]]',
	'admanager_gotozones' => '[[Special:AdManagerZones|Advertentiezones bewirke]]',
	'right-admanager' => '[[Special:AdManager|Advertentie-insjtèllinge behiere]]',
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 */
$messages['lt'] = array(
	'admanager' => 'Skelbimų tvarkyklė',
	'admanagerzones' => 'Skelbimų tvarkyklės zonos',
	'admanager_invalidtargetpage' => 'Puslapis nerastas su pavadinimu "$1".',
	'admanager_invalidtargetcategory' => 'Kategorija nerasta su pavadinimu "$1".',
	'admanager_labelPage' => 'Puslapio pavadinimai',
	'admanager_labelCategory' => 'Kategorijų pavadinimai',
	'admanager_submit' => 'Siųsti',
	'admanager_noads' => 'Nerodyti reklamų',
	'admanager_Page' => 'Puslapiai',
	'admanager_Category' => 'Kategorijos',
	'admanager_added' => 'Jūsų pakeitimai buvo įrašyti',
	'admanager_noadsset' => '$1 buvo nustatytas nerodyti jokių reklamų',
	'admanager_addedzone' => 'Pridėta zona',
	'admanager_zonenum' => 'Zona #: $1',
	'admanager_zonenotnumber' => 'Klaida! $1 nėra skaičius.',
	'admanager_gotozones' => '[[Special:AdManagerZones|Redaguoti reklamos zonas]]',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'admanager' => 'Раководител со реклами',
	'admanagerzones' => 'Зони - Раководител со реклами',
	'admanager-desc' => 'Дава [[Special:AdManager|специјална страница]] каде системските оператори можат да ја зададат зоната за страниците или категориите',
	'admanager_docu' => 'За да додадете или отстраните рекламна зона на една страница или цела категорија, подолу додајте/отстранете го нејзиниот наслов.',
	'admanagerzones_docu' => 'Внесете го ги броевите на рекламните зони, секој во посебен ред.',
	'admanager_invalidtargetpage' => 'Не пронајдов страница со наслов „$1“.',
	'admanager_invalidtargetcategory' => 'Не пронајдов категорија со наслов „$1“.',
	'admanager_notable' => 'Грешка! Не ја пронајдов потребната табела во базата! Најпрвин направете поднова со update.php.',
	'admanager_noAdManagerZones' => 'Грешка! Мора да додадете некои рекламни зони. Внесете ги во „[[Special:AdManagerZones|Зони - Раководител со реклами]]“.',
	'admanager_labelPage' => 'Наслови на страниците',
	'admanager_labelCategory' => 'Имиња на категориите',
	'admanager_submit' => 'Поднеси',
	'admanager_noads' => 'Не прикажувај реклами',
	'admanager_Page' => 'Страници',
	'admanager_Category' => 'Категории',
	'admanager_added' => 'Вашите измени се зачувани',
	'admanager_noadsset' => '$1 е наместено да не прикажува реклами',
	'admanager_addedzone' => 'Додадена зона',
	'admanager_zonenum' => 'Зона бр: $1',
	'admanager_zonenotnumber' => 'Грешка! $1 не претставува број.',
	'admanager_return' => 'Назад на [[Special:AdManager|Раководителот со реклами]]',
	'admanager_gotoads' => '[[Special:AdManager|Смени положба на рекламата]]',
	'admanager_gotozones' => '[[Special:AdManagerZones|Уреди рекламни зони]]',
	'right-admanager' => '[[Special:AdManager|Поставки за рекламирање]]',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'admanager' => 'Pengurus Iklan',
	'admanagerzones' => 'Zon Pengurus Iklan',
	'admanager_labelPage' => 'Tajuk laman',
	'admanager_noads' => 'Jangan paparkan iklan',
	'admanager_zonenum' => 'Bil. Zon: $1',
	'admanager_zonenotnumber' => 'Ralat! $1 bukan bilangan.',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'admanager' => 'Advertentiebeheer',
	'admanagerzones' => 'Zones voor advertentiebeheer',
	'admanager-desc' => "Voegt een [[Special:AdManager|speciale pagina]] toe die beheerders in staat stelt om de zone voor pagina's of categorieën in te stellen",
	'admanager_docu' => 'U kunt een advertentiezone van een pagina of volledige categorie toevoegen of verwijderen door de naam ervan toe te voegen of te verwijderen.',
	'admanagerzones_docu' => 'Voer elke advertentiezone op een eigen regel in.',
	'admanager_invalidtargetpage' => 'Geen pagina gevonden met de naam "$1".',
	'admanager_invalidtargetcategory' => 'Geen categorie gevonden met de naam "$1".',
	'admanager_notable' => 'Fout: een vereiste databasetabel is niet gevonden. Voer eerst update.php uit.',
	'admanager_noAdManagerZones' => 'Fout: u moet advertentiezones toevoegen. Voer ze in op de [[Special:AdManagerZones|speciale pagina]].',
	'admanager_labelPage' => 'Paginanamen',
	'admanager_labelCategory' => 'Categorienamen',
	'admanager_submit' => 'Opslaan',
	'admanager_noads' => 'Geen advertenties weergeven',
	'admanager_Page' => "Pagina's",
	'admanager_Category' => 'Categorieën',
	'admanager_added' => 'Uw wijzigingen zijn opgeslagen',
	'admanager_noadsset' => '$1 is ingesteld om geen advertenties weer te geven',
	'admanager_addedzone' => 'Zone toegevoegd',
	'admanager_zonenum' => 'Zonenummer: $1',
	'admanager_zonenotnumber' => 'Fout: $1 is geen getal.',
	'admanager_return' => 'Terug naar [[Special:AdManager|advertentiebeheer]]',
	'admanager_gotoads' => '[[Special:AdManager|Advertentieplaatsing bewerken]]',
	'admanager_gotozones' => '[[Special:AdManagerZones|Advertentiezones bewerken]]',
	'right-admanager' => '[[Special:AdManager|Advertentie-instellingen beheren]]',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Jnanaranjan Sahu
 */
$messages['or'] = array(
	'admanager_labelPage' => 'ପୃଷ୍ଠା ଶିରୋନାମାଗୁଡିକ',
	'admanager_labelCategory' => 'ବିଭାଗ ନାମ',
	'admanager_submit' => 'ପଇଠ କରିବେ',
	'admanager_noads' => 'କୌଣସି ବିଜ୍ଞାପନ ଦେଖାଇବେ ନାହିଁ',
	'admanager_Page' => 'ପୃଷ୍ଠାଗୁଡିକ',
	'admanager_Category' => 'ବିଭାଗଗୁଡିକ',
	'admanager_added' => 'ଆପଣଙ୍କର ବଦଳଗୁଡିକୁ ସାଇତାଗଲା',
	'admanager_addedzone' => 'ଯୋଡ଼ାଯାଇଥିବା ଭାଗ',
	'admanager_zonenotnumber' => 'ଅସୁବିଧା ! $1 ଗୋଟିଏ ସଂଖ୍ୟା ନୁହେଁ ।',
	'admanager_return' => '[[Special:AdManager|Ad Manager]]କୁ ଫେରିବେ',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'admanager_labelPage' => 'Naame vun Bledder',
);

/** Portuguese (Português)
 * @author SandroHc
 */
$messages['pt'] = array(
	'admanager_labelCategory' => 'Nomes da categoria',
	'admanager_submit' => 'Enviar',
	'admanager_noads' => 'Não apresentar anúncios',
	'admanager_Page' => 'Páginas',
	'admanager_Category' => 'Categorias',
	'admanager_added' => 'As suas alterações foram salvas',
	'admanager_noadsset' => '$1 definiu para não mostrar anúncios',
	'admanager_addedzone' => 'Zona adicionada',
	'admanager_zonenum' => 'Zona #: $1',
	'admanager_zonenotnumber' => 'Erro! $1 não é um número.',
	'admanager_return' => 'Voltar para [[Special:AdManager|Ad Manager]]',
);

/** Russian (Русский)
 * @author DCamer
 * @author Engineering
 */
$messages['ru'] = array(
	'admanager' => 'Менеджер рекламы',
	'admanagerzones' => 'Менеджер рекламных зон',
	'admanager-desc' => 'Добавляет [[Special:AdManager|служебную страницу]] которая позволяет администраторам устанавливать зоны для страниц или категорий',
	'admanager_docu' => 'Чтобы добавить или удалить рекламную зону страницы или всей категории, добавьте или удалите ее название.',
	'admanagerzones_docu' => 'Введите номер каждой рекламной зоны на отдельной строке.',
	'admanager_invalidtargetpage' => 'Не найдена страница " $1 ".',
	'admanager_invalidtargetcategory' => 'Не найдена категория " $1 ".',
	'admanager_notable' => 'Ошибка! Не найдена необходимая таблица базы данных! Сначала запустите update.php.',
	'admanager_noAdManagerZones' => 'Ошибка! Необходимо добавить несколько рекламных зон. Введите их в [[Special:AdManagerZones|Менеджере рекламных зон]].',
	'admanager_labelPage' => 'Названия страниц',
	'admanager_labelCategory' => 'Названия категорий',
	'admanager_submit' => 'Отправить',
	'admanager_noads' => 'Не отображать рекламу',
	'admanager_Page' => 'Страницы',
	'admanager_Category' => 'Категории',
	'admanager_added' => 'Ваши изменения были сохранены',
	'admanager_noadsset' => '$1 отключил показ рекламы',
	'admanager_addedzone' => 'Добавлена зона',
	'admanager_zonenum' => 'Зона #:$1',
	'admanager_zonenotnumber' => 'Ошибка!  $1  не является числом.',
	'admanager_return' => 'Обратно в [[Special:AdManager|Менеджер рекламы]]',
	'admanager_gotoads' => '[[Special:AdManager|Изменить размещение рекламы]]',
	'admanager_gotozones' => '[[Special:AdManagerZones|Изменить рекламные зоны]]',
	'right-admanager' => '[[Special:AdManager|Управление конфигурацией рекламы]]',
);

/** Swedish (Svenska)
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'admanager' => 'Annonshanterare',
	'admanagerzones' => 'Annonshanterar-zoner',
	'admanager-desc' => 'Ger en [[Special:AdManager|specialsida]] som låter systemoperatör ställa in zonen för sidor eller kategorier',
	'admanager_docu' => 'För att lägga till eller ta bort annonszonen av en sida eller en hel kategori, lägg till eller ta bort rubriken nedan.',
	'admanagerzones_docu' => 'Ange varje annonszon-nummer på en egen rad.',
	'admanager_invalidtargetpage' => 'Ingen sida hittades med titeln "$1".',
	'admanager_invalidtargetcategory' => 'Ingen kategori hittades med titeln "$1".',
	'admanager_notable' => 'Fel! En nödvändig databastabell hittades inte! Kör update.php först.',
	'admanager_noAdManagerZones' => 'Fel! Du måste lägga till några annonszoner. Skriv in dem i [[Special:AdManagerZones|Annonshanterarzoner]].',
	'admanager_labelPage' => 'Sidtitel',
	'admanager_labelCategory' => 'Kategorinamn',
	'admanager_submit' => 'Skicka',
	'admanager_noads' => 'Visa inga annonser',
	'admanager_Page' => 'Sidor',
	'admanager_Category' => 'Kategorier',
	'admanager_added' => 'Dina ändringar har sparats',
	'admanager_noadsset' => '$1 har ställts in för att inte visa några annonser',
	'admanager_addedzone' => 'Lade till zon',
	'admanager_zonenum' => 'Zon #: $1',
	'admanager_zonenotnumber' => 'Fel! $1 är inte ett tal.',
	'admanager_return' => 'Återgå till [[Special:AdManager|Annonshanteraren]]',
	'admanager_gotoads' => '[[Special:AdManager|Redigera annonsplacering]]',
	'admanager_gotozones' => '[[Special:AdManagerZones|Redigera annonszoner]]',
	'right-admanager' => '[[Special:AdManager|Hantera annonskonfigurering]]',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'admanager_labelCategory' => 'వర్గాల పేర్లు',
	'admanager_submit' => 'దాఖలుచెయ్యి',
	'admanager_Page' => 'పుటలు',
	'admanager_Category' => 'వర్గాలు',
	'admanager_added' => 'మీ మార్పుల భద్రమయ్యాయి',
);

/** Turkish (Türkçe)
 * @author Incelemeelemani
 */
$messages['tr'] = array(
	'admanager' => 'Reklam Yöneticisi',
	'admanagerzones' => 'Reklam Yöneticisi bölgeleri',
	'admanager_labelPage' => 'Sayfa başlıkları',
	'admanager_labelCategory' => 'Kategori adları',
	'admanager_submit' => 'Gönder',
	'admanager_noads' => 'Reklamları gösterme',
	'admanager_Page' => 'Sayfalar',
	'admanager_Category' => 'Kategoriler',
	'admanager_added' => 'Değişiklikleriniz kaydedildi',
	'admanager_noadsset' => '$1 reklamı göstermek için ayarla',
	'admanager_addedzone' => 'Eklenen bölge',
	'admanager_zonenum' => 'Bölge #: $1',
	'admanager_zonenotnumber' => 'Hata!  $1  bir sayı değil.',
	'admanager_return' => '[[Special:AdManager|Reklam Yöneticisine]] dön',
	'admanager_gotoads' => '[[Special:AdManager|Reklamı düzenle]]',
	'admanager_gotozones' => '[[Special:AdManagerZones|Bölgeyi düzenle]]',
	'right-admanager' => '[[Special:AdManager|Reklam Yöneticisi ayarları]]',
);

/** Ukrainian (Українська)
 * @author Sodmy
 */
$messages['uk'] = array(
	'admanager' => 'Менеджер оголошень',
	'admanagerzones' => 'Менеджер оголошень по зонам',
	'admanager-desc' => 'Забезпечує [[Special:AdManager|службову сторінку]], яка дозволяє адміністраторам встановлювати зони для сторінок або категорій',
	'admanager_docu' => 'Щоб додати або видалити зону оголошення у сторінці або усієї категорії, додайте або видаліть її назву нижче.',
	'admanagerzones_docu' => 'Введіть номер кожної зони оголошень в окремому рядку.',
	'admanager_invalidtargetpage' => 'Не знайдено сторінки з назвою "$1".',
	'admanager_invalidtargetcategory' => 'Не знайдено категорії з назвою "$1".',
	'admanager_notable' => 'Помилка! Не знайдено необхідної таблиці бази даних! Спочатку запустіть update.php.',
	'admanager_noAdManagerZones' => 'Помилка! Ви повинні додати деякі зони оголошень. Введіть їх у [[Special:AdManagerZones|Менеджер зон оголошень]].',
	'admanager_labelPage' => 'Назви сторінок',
	'admanager_labelCategory' => 'Імена категорій',
	'admanager_submit' => 'Відправити',
	'admanager_noads' => 'Не показувати рекламу',
	'admanager_Page' => 'Сторінки',
	'admanager_Category' => 'Категорії',
	'admanager_added' => 'Ваші зміни збережено',
	'admanager_noadsset' => '$1 відключив показ реклами',
	'admanager_addedzone' => 'Додана зона',
	'admanager_zonenum' => 'Зона #: $1',
	'admanager_zonenotnumber' => 'Помилка! $1 не є числом.',
	'admanager_return' => 'Повернутися до [[Special:AdManager|Менеджер оголошень]]',
	'admanager_gotoads' => '[[Special:AdManager|Редагувати розміщення оголошень]]',
	'admanager_gotozones' => '[[Special:AdManagerZones|Редагувати зони оголошень]]',
	'right-admanager' => '[[Special:AdManager|Керування конфігурацією реклами]]',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'admanager_submit' => 'אײַנגעבן',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hzy980512
 */
$messages['zh-hans'] = array(
	'admanager' => '广告管理器',
	'admanagerzones' => '广告管理器区域',
	'admanager_invalidtargetpage' => '找不到标题名为“$1”的页面',
	'admanager_invalidtargetcategory' => '找不到标题名为“$1”的分类',
	'admanager_notable' => '错误！找不到某数据库资料表！请先运行update.php。',
	'admanager_labelPage' => '页面标题',
	'admanager_labelCategory' => '分类名称',
	'admanager_submit' => '提交',
	'admanager_noads' => '不显示广告',
	'admanager_Page' => '页面',
	'admanager_Category' => '分类',
	'admanager_added' => '更改已保存',
	'admanager_addedzone' => '已添加区域',
	'admanager_zonenotnumber' => '错误！$1不是数字。',
	'admanager_return' => '回到[[Special:AdManager|广告管理器]]',
	'admanager_gotoads' => '[[Special:AdManager|编辑广告位置]]',
	'admanager_gotozones' => '[[Special:AdManagerZones|编辑广告区域]]',
	'right-admanager' => '[[Special:AdManager|管理广告配置]]',
);

