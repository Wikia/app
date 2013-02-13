<?php

/**
 * CategorySelect
 *
 * A CategorySelect extension for MediaWiki
 * Provides an interface for managing categories in article without editing whole article
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2009-01-13
 * @copyright Copyright (C) 2009 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/CategorySelect/CategorySelect.php");
 */

$messages = array();

$messages[ 'en' ] = array(
	'categoryselect-desc' => 'Provides an interface for managing categories in article without editing whole article',
	'categoryselect-button-add' => 'Add category',
	'categoryselect-button-cancel' => 'Cancel',
	'categoryselect-button-save' => 'Save',
	'categoryselect-category-add' => 'Add category...',
	'categoryselect-category-edit' => 'Edit category',
	'categoryselect-category-remove' => 'Remove category',
	'categoryselect-edit-summary' => 'Adding categories',
	'categoryselect-error-article-doesnt-exist' => 'Article [id=$1] does not exist.',
	'categoryselect-error-category-name-length' => 'The maximum length for a category name has been reached.',
	'categoryselect-error-db-locked' => 'Database is locked.',
	'categoryselect-error-duplicate-category-name' => 'Category "$1" already exists.',
	'categoryselect-error-edit-abort' => 'The modifications you tried to make were aborted by an extension hook.',
	'categoryselect-error-empty-category-name' => 'Please provide a category name.',
	'categoryselect-error-user-rights' => 'User does not have permission to perform this action.',
	'categoryselect-modal-category-name' => 'Provide the name of the category:',
	'categoryselect-modal-category-sortkey' => 'Optionally, you may alphabetize this article on the "$1" category page under the name:',
	'categoryselect-tooltip-add' => 'Press the Enter or Return key when done.',
	'tog-disablecategoryselect' => 'Disable Category module (only applies if editing in visual mode has been disabled)',
	'tog-disablecategoryselect-v2' => 'Disable Category module (only applies if visual mode editing is disabled)'
);

/** Message documentation (Message documentation)
 * @author Kflorence
 */
$messages[ 'qqq' ] = array(
	'categoryselect-desc' => '{{desc}}',
	'categoryselect-button-add' => 'The text displayed for the add category button on article pages.',
	'categoryselect-button-save' => 'The text displayed for the save button on article pages.',
	'categoryselect-button-cancel' => 'The text displayed for the cancel button on article pages.',
	'categoryselect-category-add' => 'The placeholder text displayed in the category input field when it is empty.',
	'categoryselect-category-edit' => 'Title text for the edit icon and the heading for category edit modals.',
	'categoryselect-category-remove' => 'Title text for the remove icon.',
	'categoryselect-edit-summary' => 'The summary used for revisions created when saving category updates on view pages.',
	'categoryselect-error-article-doesnt-exist' => 'The error message shown when trying to add categories to an article that doesn\'t exist. Parameters:
* $1: The ID of the article.',
	'categoryselect-error-category-name-length' => 'The error message shown when typing in a category name when the maximum allowable length is exceeded.',
	'categoryselect-error-db-locked' => 'The error message shown when saving changes when the site is in read only mode.',
	'categoryselect-error-duplicate-category-name' => 'The error message shown when trying to add a category with the same name as an existing category. Parameters:
* $1: The name of the category the user is trying to add.',
	'categoryselect-error-edit-abort' => 'The error message shown when saving changes is cancelled by an extension hook.',
	'categoryselect-error-empty-category-name' => 'The error message shown when trying to add a category without a category name.',
	'categoryselect-error-user-rights' => 'The error message shown when trying to save changes without proper user permissions.',
	'categoryselect-modal-category-name' => 'The text shown above the category input field in the modal dialog.',
	'categoryselect-modal-category-sortkey' => 'The text shown above the sortkey input field in the modal dialog.',
	'categoryselect-tooltip-add' => 'A tooltip explaining to users how to submit the category they typed in the input field.',
	'tog-disablecategoryselect' => 'The text displayed in user preferences for disabling the CategorySelect extension',
	'tog-disablecategoryselect-v2' => 'The text displayed in user preferences for disabling the CategorySelect extension when the UserPreferencesV2 extension is enabled.'
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'categoryselect-button-add' => 'Voeg kategorie by',
	'categoryselect-tooltip-add' => "Druk 'Enter' as u klaar is",
	'categoryselect-button-save' => 'Stoor',
	'categoryselect-button-cancel' => 'Kanselleer',
	'categoryselect-error-article-doesnt-exist' => 'Artikel [id=$1] bestaan nie.',
	'categoryselect-error-db-locked' => 'Databasis is gesluit.',
);

/** Aragonese (aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'categoryselect-button-cancel' => 'Cancelar',
);

/** Arabic (العربية)
 * @author Achraf94
 * @author Alexknight12
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'categoryselect-desc' => 'يوفر واجهة لإدارة التصنيفات في مقالة دون تعديل كامل المقالة',
	'categoryselect-code-view' => 'عرض الرموز',
	'categoryselect-visual-view' => 'عرض مرئي',
	'categoryselect-category-edit' => 'خيارات التصنيف',
	'categoryselect-modal-category-name' => 'يقدم إسما للتصنيف',
	'categoryselect-modal-category-sortkey' => 'يرتب أبجديا هذا المقال في صفحة تصنيف "$1" تحت الاسم',
	'categoryselect-button-add' => 'أضف تصنيفا',
	'categoryselect-tooltip-add' => 'إظغط على Enter اذا انتهيت',
	'categoryselect-tooltip' => "'''جديد!''' شريط أدوات علامات التصنيف. جربه أو أنظر [[مساعدة:إختيار التصنيف|المساعدة]] لتعرف المزيد", # Fuzzy
	'categoryselect-unhandled-syntax' => 'تم الكشف عن بناء جملة غير معالج - يتم التحويل إلى العرض المرئي',
	'categoryselect-edit-summary' => 'إضافة التصانيف',
	'categoryselect-error-empty-category-name' => 'أضف اسم التصنيف (الجزء قبل |)',
	'categoryselect-button-save' => 'سجل',
	'categoryselect-button-cancel' => 'إلغاء',
	'categoryselect-error-article-doesnt-exist' => 'المقالة [id=$1] لا وجود لها',
	'categoryselect-error-user-rights' => 'خطأ في حقوق المستخدم',
	'categoryselect-error-db-locked' => 'قاعدة البيانات مغلقة',
	'categoryselect-error-edit-abort' => 'التعديل الذي تحاول أن تقوم به أجهض من قبل تمديد هوك',
	'tog-disablecategoryselect' => 'تعطيل وسم التصنيفات', # Fuzzy
);

/** Assamese (অসমীয়া)
 * @author Jaminianurag
 */
$messages['as'] = array(
	'categoryselect-button-add' => 'শ্ৰেণী সংযোগ কৰক',
	'categoryselect-button-save' => 'সঞ্চিত কৰক',
	'categoryselect-button-cancel' => 'বাতিল কৰক',
);

/** Azerbaijani (azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'categoryselect-button-save' => 'Qeyd et',
	'categoryselect-button-cancel' => 'Ləğv et',
);

/** Bavarian (Boarisch)
 * @author Mucalexx
 */
$messages['bar'] = array(
	'categoryselect-desc' => "Stöd a Ówerflächen zur da Vawoitung voh da Kategorie in am Artiké zur Vafygung, óne daas ma'n gaunzen Artiké beorweiten muass.",
	'categoryselect-code-view' => 'Quöjtext',
	'categoryselect-visual-view' => 'Graafische Auhsicht',
	'categoryselect-category-edit' => 'Kategorie-Ópziónen',
	'categoryselect-modal-category-name' => 'Gib an Naum voh da Kategorie auh:',
	'categoryselect-modal-category-sortkey' => 'Dua dén Artiké in da Kategorie „$1“ unter fóigendm Naum einé:',
	'categoryselect-button-add' => 'Kategorie dazuadoah',
	'categoryselect-category-add' => 'A Kategorie dazuadoah',
	'categoryselect-tooltip-add' => 'Mid da Eihgobtasten beénden',
	'categoryselect-tooltip' => "'''Neich!''' Unser Kategorieauswoi-Leisten. Prówiers aus óder lies dé [[Help:KategorieAuswahl|Hüfe]] fyr weiderne Informaziónen",
	'categoryselect-unhandled-syntax' => "Néd unterstytzde Syntax gfunden - A Wexel in d' graafische Auhsicht is néd méglé.",
	'categoryselect-edit-summary' => 'Kategorie dazuadoah',
	'categoryselect-error-empty-category-name' => 'Kategorie-Naum (der Tei vur |)',
	'categoryselect-button-save' => 'Speichern',
	'categoryselect-button-cancel' => 'Obbrechen',
	'categoryselect-error-article-doesnt-exist' => 'Der Artiké [id=$1] existird néd.',
	'categoryselect-error-user-rights' => 'Koane ausreichenden Benutzerrechtt.',
	'categoryselect-error-db-locked' => 'Dé Daatenbaunk is im Móment grod gsperrd.',
	'categoryselect-error-edit-abort' => 'Deih vasuachte Änderrung is durch a Aufhänger voh aner Daweiterrung obbrochen worn.',
	'tog-disablecategoryselect' => 'Vaoahfochts Kategorisiern ausschoiden',
);

/** Belarusian (Taraškievica orthography) (беларуская (тарашкевіца)‎)
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'categoryselect-button-save' => 'Захаваць',
	'categoryselect-button-cancel' => 'Адмяніць',
);

/** Bulgarian (български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'categoryselect-button-add' => 'Добавяне на категория',
	'categoryselect-edit-summary' => 'Добавяне на категории',
	'categoryselect-button-save' => 'Съхраняване',
	'categoryselect-button-cancel' => 'Отказване',
);

/** Breton (brezhoneg)
 * @author Fulup
 * @author Gwenn-Ael
 * @author Y-M D
 */
$messages['br'] = array(
	'categoryselect-desc' => 'a bourchas un etrefas evit gallout merañ rummadoù ur pennad hep ma vefe ezhomm da voullañ ar pennad a-bezh.',
	'categoryselect-code-view' => "Gwelet ar c'hod",
	'categoryselect-visual-view' => 'Sell dre gwelet',
	'categoryselect-category-edit' => 'Dibarzhioù ar rummad',
	'categoryselect-modal-category-name' => 'Roit anv ar rummad :',
	'categoryselect-modal-category-sortkey' => 'Lakaat ar pennad-mañ er rummad "$1" dindan an anv da-heul :',
	'categoryselect-button-add' => 'Ouzhpennañ rummadoù',
	'categoryselect-category-add' => 'Ouzhpennañ ur rummad',
	'categoryselect-tooltip-add' => 'Pouezañ war "Kas" evit echuiñ',
	'categoryselect-tooltip' => "'''Nevez !''' Barrenn ostilhoù evit diuzañ rummadoù. Amprouit anezhi pe lennit [[Help:CategorySelect|ar skoazell]] evit gouzout hiroc'h",
	'categoryselect-unhandled-syntax' => "Ur gudenn ereadurezh dianav zo. N'haller ket lakaat ar mod gwelet.",
	'categoryselect-edit-summary' => 'Ouzhpennañ ur rummad',
	'categoryselect-error-empty-category-name' => 'Reiñ a ra anv ar rummad (al lodenn skrivet a-raok |)',
	'categoryselect-button-save' => 'Enrollañ',
	'categoryselect-button-cancel' => 'Nullañ',
	'categoryselect-error-article-doesnt-exist' => "N'eus ket eus ar pennad [id=$1].",
	'categoryselect-error-user-rights' => 'Fazi en aotreoù implijerien.',
	'categoryselect-error-db-locked' => 'Stanket eo ar bank roadennoù',
	'categoryselect-error-edit-abort' => "Ar c'hemm hoc'h eus klasket degas zo bet harzet gant ur c'hrog astenn.",
	'tog-disablecategoryselect' => 'Diweredekaat balizadur ar rummadoù', # Fuzzy
);

/** Catalan (català)
 * @author BroOk
 */
$messages['ca'] = array(
	'categoryselect-desc' => "Proporciona una interfície per gestionar les categories dels articles sense editar tot l'article.",
	'categoryselect-code-view' => 'Vista de codi',
	'categoryselect-code-view-placeholder' => 'Afegeix categories aquí, per exemple: [[Categoria:Nom]]', # Fuzzy
	'categoryselect-visual-view' => 'Vista visual',
	'categoryselect-category-edit' => 'Opcions de categoria',
	'categoryselect-modal-category-name' => 'Posa el nom de la categoria:',
	'categoryselect-modal-category-sortkey' => 'Classifica aquest article a la categoria "$1" amb el nom:',
	'categoryselect-button-add' => 'Afegir categoria',
	'categoryselect-category-add' => 'Afegir una categoria',
	'categoryselect-tooltip-add' => 'Pressiona "Enter" quan acabis',
	'categoryselect-tooltip' => "'''Nou!''' Barra d'etiquetes de categoria. Prova-la o dóna-li un cop d'ull a l'[[Help:CategorySelect|ajuda]] per aprendre més",
	'categoryselect-unhandled-syntax' => 'Detectada sintaxis immanejable - impossible canviar al mode visual.',
	'categoryselect-edit-summary' => 'Afegint categories',
	'categoryselect-error-empty-category-name' => 'Posa el nom de la categoria (part abans de |)',
	'categoryselect-button-save' => 'Desa',
	'categoryselect-button-cancel' => 'Cancel·la',
	'categoryselect-error-article-doesnt-exist' => "L'article [id=$1] no existeix.",
	'categoryselect-error-user-rights' => "Error de drets d'usuari.",
	'categoryselect-error-db-locked' => 'La base de dades està bloquejada.',
	'categoryselect-error-edit-abort' => "La modificació que has intentat fer ha estat avortada per un ganxo d'extensió.",
	'tog-disablecategoryselect' => "Desactivar el mòdul de categories (només s'aplica si l'edició en mode visual està desactivada).",
	'tog-disablecategoryselect-v2' => "Desactivar el mòdul de categories (només s'aplica si l'edició en mode visual està desactivada).",
);

/** Sorani Kurdish (کوردی)
 */
$messages['ckb'] = array(
	'categoryselect-button-save' => 'پاشەکەوت',
);

/** Czech (česky)
 * @author Darth Daron
 * @author Dontlietome7
 */
$messages['cs'] = array(
	'categoryselect-desc' => 'Poskytuje rozhraní pro správu kategorií v článku bez úprav celého článku',
	'categoryselect-code-view' => 'Zobrazení kódu',
	'categoryselect-code-view-placeholder' => 'Zde přidat kategoire, např. [[Kategorie:Jméno]]', # Fuzzy
	'categoryselect-visual-view' => 'Vizuální zobrazení',
	'categoryselect-category-edit' => 'Možnosti kategorie',
	'categoryselect-modal-category-name' => 'Uveďte název kategorie:',
	'categoryselect-modal-category-sortkey' => 'Abecedně seřadit tento článek na stránce kategorie „$1" pod názvem:',
	'categoryselect-button-add' => 'Přidat kategorii',
	'categoryselect-category-add' => 'Přidat kategorii',
	'categoryselect-tooltip-add' => 'Po dokončení stiskněte Enter',
	'categoryselect-tooltip' => "'''Novinka!''' Lišta na tagování kategorií. Vyzkoušejte ji nebo si přečtěte [[Help:CategorySelect|nápovědu]]",
	'categoryselect-unhandled-syntax' => 'Zjištěna neošetřená syntaxe - přepnutí zpět do vizuálního zobrazení není možné.',
	'categoryselect-edit-summary' => 'Přidávání kategorií',
	'categoryselect-error-empty-category-name' => 'Zadejte název kategorie (část před |)',
	'categoryselect-button-save' => 'Uložit',
	'categoryselect-button-cancel' => 'Storno',
	'categoryselect-error-article-doesnt-exist' => 'Článek [id=$1] neexistuje.',
	'categoryselect-error-user-rights' => 'Chyba uživatelských práv.',
	'categoryselect-error-db-locked' => 'Databáze je uzamčena.',
	'categoryselect-error-edit-abort' => 'Změna, o kterou jste se pokusili, byla zrušena rozšířením.',
	'tog-disablecategoryselect' => 'Zakázat značení kategorií (platné pouze, pokud bylo editování ve vizuálním režimu zakázáno)',
	'tog-disablecategoryselect-v2' => 'Zakázat modul kategorií (pouze pokud je zakázaný vizuální editor)',
);

/** German (Deutsch)
 * @author Avatar
 * @author Inkowik
 * @author Jan Luca
 * @author LWChris
 * @author Metalhead64
 * @author PtM
 */
$messages['de'] = array(
	'categoryselect-desc' => 'Stellt eine Oberfläche zur Verwaltung der Kategorien in einem Artikel ohne Bearbeitung des ganzen Artikels zur Verfügung.',
	'categoryselect-code-view' => 'Quelltext',
	'categoryselect-code-view-placeholder' => 'Hier Kategorie hinzufügen, z. B. [[{{ns:category}}:Name]]',
	'categoryselect-visual-view' => 'Grafische Ansicht',
	'categoryselect-category-edit' => 'Kategorie-Optionen',
	'categoryselect-modal-category-name' => 'Gib den Namen der Kategorie an:',
	'categoryselect-modal-category-sortkey' => 'Ordne diesen Artikel in der Kategorie „$1“ unter folgendem Namen ein:',
	'categoryselect-button-add' => 'Kategorie hinzufügen',
	'categoryselect-category-add' => 'Eine Kategorie hinzufügen',
	'categoryselect-tooltip-add' => 'Mit Eingabetaste beenden',
	'categoryselect-tooltip' => "'''Neu!''' Unsere Kategorieauswahl-Leiste. Probier sie aus oder lies die [[Help:KategorieAuswahl|Hilfe]] für weitere Informationen",
	'categoryselect-unhandled-syntax' => 'Nicht unterstützte Syntax entdeckt - Wechsel in grafische Ansicht nicht möglich.',
	'categoryselect-edit-summary' => 'Kategorien hinzufügen',
	'categoryselect-error-empty-category-name' => 'Kategorie-Name (der Teil vor |)',
	'categoryselect-button-save' => 'Speichern',
	'categoryselect-button-cancel' => 'Abbrechen',
	'categoryselect-error-article-doesnt-exist' => 'Der Artikel [id=$1] existiert nicht.',
	'categoryselect-error-user-rights' => 'Keine ausreichenden Benutzerrechte.',
	'categoryselect-error-db-locked' => 'Die Datenbank ist vorübergehend gesperrt.',
	'categoryselect-error-edit-abort' => 'Deine versuchte Änderung wurde durch ein Aufhängen einer Erweiterung abgebrochen',
	'tog-disablecategoryselect' => 'Kategorie-Modul ausschalten (greift nur, wenn das grafische Bearbeiten ausgeschaltet wurde)',
	'tog-disablecategoryselect-v2' => 'Kategorie-Modul deaktivieren (trifft nur zu, wenn der grafische Editor deaktiviert ist)',
);

/** German (formal address) (Deutsch (Sie-Form)‎)
 * @author LWChris
 */
$messages['de-formal'] = array(
	'categoryselect-modal-category-name' => 'Geben Sie den Namen der Kategorie an:',
	'categoryselect-tooltip' => "'''Neu!''' Unsere Kategorieauswahl-Leiste. Probieren Sie sie aus oder lesen Sie die [[Help:KategorieAuswahl|Hilfe]] für weitere Informationen",
	'categoryselect-error-edit-abort' => 'Ihre versuchte Änderung wurde durch ein Aufhängen einer Erweiterung abgebrochen',
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 * @author Mirzali
 */
$messages['diq'] = array(
	'categoryselect-code-view' => 'Kodi bıvin',
	'categoryselect-button-save' => 'Star ke',
	'categoryselect-button-cancel' => 'Bıtexelne',
);

/** Greek (Ελληνικά)
 * @author Crazymadlover
 * @author Glavkos
 */
$messages['el'] = array(
	'categoryselect-code-view' => 'Προβολή κώδικα',
	'categoryselect-visual-view' => 'Οπτική προβολή',
	'categoryselect-category-edit' => 'Επιλογές κατηγορίας',
	'categoryselect-modal-category-name' => 'Δώστε το όνομα της κατηγορίας:',
	'categoryselect-button-add' => 'Προσθήκη κατηγορίας',
	'categoryselect-category-add' => 'Προσθήκη μιας κατηγορίας',
	'categoryselect-tooltip-add' => 'Πατήστε Enter όταν γίνει',
	'categoryselect-button-save' => 'Αποθήκευση',
	'categoryselect-button-cancel' => 'Ακύρωση',
	'categoryselect-error-db-locked' => 'Η βάση δεδομένων είναι κλειδωμένη',
);

/** Spanish (español)
 * @author Armando-Martin
 * @author Benfutbol10
 * @author Pertile
 * @author Translationista
 * @author VegaDark
 * @author Vivaelcelta
 */
$messages['es'] = array(
	'categoryselect-desc' => 'Proporciona una interfaz para gestionar las categorías de los artículos sin editar todo el artículo.',
	'categoryselect-code-view' => 'Vista de código',
	'categoryselect-code-view-placeholder' => 'Añadir categorías aquí, por ejemplo, [[:{{ns:category}}:Name]]',
	'categoryselect-visual-view' => 'Vista visual',
	'categoryselect-category-edit' => 'Opciones de categoría',
	'categoryselect-modal-category-name' => 'Pon el nombre de la categoría:',
	'categoryselect-modal-category-sortkey' => 'Clasifica este artículo en la categoría "$1" con el nombre:',
	'categoryselect-button-add' => 'Añadir categoría',
	'categoryselect-category-add' => 'Añadir una categoría',
	'categoryselect-tooltip-add' => 'Presiona Enter cuando termines',
	'categoryselect-tooltip' => "'''¡Nuevo!''' Barra de etiquetas de categoría. Pruebala o échale un vistazo a [[Help:CategorySelect|ayuda]] para aprender más",
	'categoryselect-unhandled-syntax' => 'Detectada sintaxis inmanipulable - imposible cambiar al modo visual.',
	'categoryselect-edit-summary' => 'Añadiendo categorías',
	'categoryselect-error-empty-category-name' => 'Pon el nombre de la categoría (parte antes de |)',
	'categoryselect-button-save' => 'Guardar',
	'categoryselect-button-cancel' => 'Cancelar',
	'categoryselect-error-article-doesnt-exist' => 'El artículo [id=$1] no existe.',
	'categoryselect-error-user-rights' => 'Error de derechos de usuario.',
	'categoryselect-error-db-locked' => 'La base de datos está bloqueada.',
	'categoryselect-error-edit-abort' => 'La modificación que ha intentado realizar fue abortada por un gancho de extensión',
	'tog-disablecategoryselect' => 'Desactivar el módulo de categorías (sólo se aplica si la edición en modo visual está desactivada)',
	'tog-disablecategoryselect-v2' => 'Desactivar módulo de Categorías en el modo fuente',
);

/** Basque (euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'categoryselect-button-save' => 'Gorde',
	'categoryselect-button-cancel' => 'Utzi',
);

/** Persian (فارسی)
 * @author ZxxZxxZ
 */
$messages['fa'] = array(
	'categoryselect-button-add' => 'افزودن رده',
	'categoryselect-tooltip-add' => 'پس از اتمام دکمه اینتر را فشار دهید',
	'categoryselect-edit-summary' => 'افزودن رده',
	'categoryselect-button-save' => 'ذخیره کردن',
	'categoryselect-button-cancel' => 'لغو',
);

/** Finnish (suomi)
 * @author Crt
 * @author Ilkea
 * @author Tm T
 * @author Tofu II
 * @author VezonThunder
 */
$messages['fi'] = array(
	'categoryselect-desc' => 'Tarjoaa käyttöliittymän artikkelin luokkien hallitsemiselle ilman koko artikkelin muokkaamista',
	'categoryselect-code-view' => 'Näytä koodi',
	'categoryselect-code-view-placeholder' => 'Lisää luokkia tähän, esim. [[Luokka:Nimi]]', # Fuzzy
	'categoryselect-visual-view' => 'Näytä visuaalisena',
	'categoryselect-category-edit' => 'Luokan asetukset',
	'categoryselect-modal-category-name' => 'Syötä luokan nimi:',
	'categoryselect-modal-category-sortkey' => 'Aakkosta tämä artikkeli "$1" luokkasivulle nimellä:',
	'categoryselect-button-add' => 'Lisää luokka',
	'categoryselect-category-add' => 'Lisää luokka',
	'categoryselect-tooltip-add' => 'Paina Enter, kun olet valmis',
	'categoryselect-tooltip' => "'''Uusi!''' Luokan lisäystyökalurivi. Testaa sitä tai katso [[Help:CategorySelect|ohjeesta]] lisätietoa.",
	'categoryselect-unhandled-syntax' => 'Käsittelemätön syntaksi havaittu - palaaminen visuaaliseen tilaan ei mahdollista.',
	'categoryselect-edit-summary' => 'Luokkien lisääminen',
	'categoryselect-error-empty-category-name' => 'Syötä luokan nimi (osa ennen |)',
	'categoryselect-button-save' => 'Tallenna',
	'categoryselect-button-cancel' => 'Peruuta',
	'categoryselect-error-article-doesnt-exist' => 'Artikkelia [id=$1] ei ole olemassa.',
	'categoryselect-error-user-rights' => 'Käyttöoikeusvirhe.',
	'categoryselect-error-db-locked' => 'Tietokanta on lukittu.',
	'categoryselect-error-edit-abort' => 'Laajennusriippuvuus keskeytti yrittämäsi muutoksen',
	'tog-disablecategoryselect' => 'Poista luokkamoduuli käytöstä (koskee vain, jos visuaalisessa tilassa muokkaaminen on poistettu käytöstä)',
	'tog-disablecategoryselect-v2' => 'Poista luokkamoduuli käytöstä (koskee vain jos visuaalinen muokkaus on poistettu käytöstä)',
);

/** French (français)
 * @author Gomoko
 * @author IAlex
 * @author Peter17
 * @author Wyz
 */
$messages['fr'] = array(
	'categoryselect-desc' => "Fournit une interface permettant de gérer les catégories d'un article sans avoir à éditer tout l'article.",
	'categoryselect-code-view' => 'Voir le code',
	'categoryselect-code-view-placeholder' => 'Ajoutez les catégories ici, par ex. [[{{ns:category}}:Name]]',
	'categoryselect-visual-view' => 'Vue visuelle',
	'categoryselect-category-edit' => 'Options de la catégorie',
	'categoryselect-modal-category-name' => 'Ecrivez le nom de la catégorie :',
	'categoryselect-modal-category-sortkey' => 'Mettre cet article dans la catégorie « $1 » sous le nom suivant :',
	'categoryselect-button-add' => 'Ajouter des catégories',
	'categoryselect-category-add' => 'Ajouter une catégorie',
	'categoryselect-tooltip-add' => 'Appuyez sur « Entrée » pour terminer',
	'categoryselect-tooltip' => "'''Nouveau ! :''' Barre d'outils de sélection de catégorie. Essayez-la ou lisez [[Help:CategorySelect|l'aide]] pour en apprendre plus.",
	'categoryselect-unhandled-syntax' => "Il y a un problème de syntaxe inconnue. Il n'est pas possible de changer en vue graphique.",
	'categoryselect-edit-summary' => 'Ajout de catégories',
	'categoryselect-error-empty-category-name' => "Nom de la catégorie (ce qu'on écrit devant |)",
	'categoryselect-button-save' => 'Enregistrer',
	'categoryselect-button-cancel' => 'Annuler',
	'categoryselect-error-article-doesnt-exist' => "L'article [id=$1] n'existe pas.",
	'categoryselect-error-user-rights' => 'Erreur de droits utilisateur.',
	'categoryselect-error-db-locked' => 'La base de données est verrouillée.',
	'categoryselect-error-edit-abort' => "La modification que vous avez essayé de faire a été arrêtée par un crochet d'une extension",
	'tog-disablecategoryselect' => "Désactiver le module des catégories (valable uniquement si l'édition en mode visuel a été désactivée)",
	'tog-disablecategoryselect-v2' => "Désactiver le module Catégorie (s'applique uniquement si le mode d'édition visuelle est désactivé)",
);

/** Galician (galego)
 * @author Toliño
 * @author Vivaelcelta
 */
$messages['gl'] = array(
	'categoryselect-desc' => 'Proporciona unha interface para xestionar as categorías dos artigos sen editar todo o artigo.',
	'categoryselect-code-view' => 'Vista do código',
	'categoryselect-code-view-placeholder' => 'Engadir categorías aquí, por exemplo, [[{{ns:category}}:Name]]',
	'categoryselect-visual-view' => 'Vista visual',
	'categoryselect-category-edit' => 'Opcións de categoría',
	'categoryselect-modal-category-name' => 'Escriba o nome da categoría:',
	'categoryselect-modal-category-sortkey' => 'Clasificar este artigo na categoría "$1" co nome:',
	'categoryselect-button-add' => 'Engadir a categoría',
	'categoryselect-category-add' => 'Engadir unha categoría',
	'categoryselect-tooltip-add' => 'Prema a tecla Intro cando remate',
	'categoryselect-tooltip' => "'''Novo!''' Barra de ferramentas de selección de categoría. Próbaa ou olle a [[Help:CategorySelect|axuda]] para saber máis",
	'categoryselect-unhandled-syntax' => 'Detectouse unha sintaxe descoñecida; non é posible volver ao modo visual.',
	'categoryselect-edit-summary' => 'Inserción de categorías',
	'categoryselect-error-empty-category-name' => 'Dea o nome da categoría (o que se escribe antes de |)',
	'categoryselect-button-save' => 'Gardar',
	'categoryselect-button-cancel' => 'Cancelar',
	'categoryselect-error-article-doesnt-exist' => 'O artigo [id=$1] non existe.',
	'categoryselect-error-user-rights' => 'Erro de dereitos de usuario.',
	'categoryselect-error-db-locked' => 'A base de datos está bloqueada.',
	'categoryselect-error-edit-abort' => 'O asociador da extensión abortou a modificación que intentou realizar',
	'tog-disablecategoryselect' => 'Desactivar o módulo de categorías (só se aplica se a edición no modo visual está desactivada)',
	'tog-disablecategoryselect-v2' => 'Desactivar o módulo de categorías (só se aplica se o modo de edición visual está desactivado)',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 */
$messages['grc'] = array(
	'categoryselect-button-cancel' => 'Ἀκυροῦν',
);

/** Hausa (Hausa)
 */
$messages['ha'] = array(
	'categoryselect-button-cancel' => 'Soke',
);

/** Hungarian (magyar)
 * @author Dani
 * @author Glanthor Reviol
 * @author TK-999
 */
$messages['hu'] = array(
	'categoryselect-desc' => 'Egy felületet biztosít a szócikk kategóriáinak az egész oldal szerkesztése nélküli kezeléséhez',
	'categoryselect-code-view' => 'Kódnézet',
	'categoryselect-code-view-placeholder' => 'Itt add hozzá a kategüriákat, pl. [[Kategória:Név]]', # Fuzzy
	'categoryselect-visual-view' => 'Grafikus nézet',
	'categoryselect-category-edit' => 'Kategóriabeállítások',
	'categoryselect-modal-category-name' => 'Add meg a kategória nevét:',
	'categoryselect-modal-category-sortkey' => 'A szócikk ábécérendbe sorolása az "$1" kategóriában az alábbi név szerint:',
	'categoryselect-button-add' => 'Kategória hozzáadása',
	'categoryselect-category-add' => 'Kategória hozzáadása',
	'categoryselect-tooltip-add' => 'Nyomj Entert, ha kész vagy',
	'categoryselect-tooltip' => "''' Új!'' ' Kategória címkézési eszköztár. Próbáld ki, vagy tekintsd meg a [[Help:CategorySelect|dokumentációt]]",
	'categoryselect-unhandled-syntax' => 'Kezeletlen szintaxis észlelve - nem lehetséges a visszaváltás vizuális módba.',
	'categoryselect-edit-summary' => 'Kategóriák hozzáadása',
	'categoryselect-error-empty-category-name' => 'Kategórianév megjelenítése ( az | előtti rész)',
	'categoryselect-button-save' => 'Mentés',
	'categoryselect-button-cancel' => 'Mégse',
	'categoryselect-error-article-doesnt-exist' => 'A(z) [id=$1] szócikk nem létezik.',
	'categoryselect-error-user-rights' => 'Felhasználói jog hiba.',
	'categoryselect-error-db-locked' => 'Az adatbázis zárolva.',
	'categoryselect-error-edit-abort' => 'Az általad kezdeményezett módosítást nem lehet végrehajtani. (Egy bővítmény megakadályozta.)',
	'tog-disablecategoryselect' => 'Kategóriamodul letiltása (csak a vizuális módban való szerkesztés kikapcsolása esetén érvényes)',
	'tog-disablecategoryselect-v2' => 'Kategóriamodul letiltása (csak a vizuális mód kikapcsolása esetén érvényes)',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'categoryselect-desc' => 'Provide un interfacie pro gerer le categorias in un articulo sin modificar tote le articulo.',
	'categoryselect-code-view' => 'Vista de codice',
	'categoryselect-code-view-placeholder' => 'Adde categorias hic, p.ex. [[Category:Nomine]]', # Fuzzy
	'categoryselect-visual-view' => 'Vista graphic',
	'categoryselect-category-edit' => 'Optiones de categoria',
	'categoryselect-modal-category-name' => 'Entra le nomine del categoria:',
	'categoryselect-modal-category-sortkey' => 'Alphabetisar iste articulo in le categoria "$1" sub le nomine:',
	'categoryselect-button-add' => 'Adder categoria',
	'categoryselect-category-add' => 'Adder un categoria',
	'categoryselect-tooltip-add' => 'Preme Enter pro finir',
	'categoryselect-tooltip' => "'''Nove!''' Instrumentario pro seliger categorias. Proba lo o vide [[Help:CategorySelect|le adjuta]] pro leger plus",
	'categoryselect-unhandled-syntax' => 'Syntaxe incognite detegite - impossibile retornar al vista graphic.',
	'categoryselect-edit-summary' => 'Addition de categorias…',
	'categoryselect-error-empty-category-name' => 'Entra le nomine del categoria (le parte ante "|")',
	'categoryselect-button-save' => 'Salveguardar',
	'categoryselect-button-cancel' => 'Cancellar',
	'categoryselect-error-article-doesnt-exist' => 'Le articulo [id=$1] non existe.',
	'categoryselect-error-user-rights' => 'Error de derectos de usator.',
	'categoryselect-error-db-locked' => 'Le base de datos es blocate.',
	'categoryselect-error-edit-abort' => 'Le modification que tu tentava facer ha essite abortate per un extension.',
	'tog-disablecategoryselect' => 'Disactivar le modulo Categoria (applicabile solmente si le modification in modo visual ha essite disactivate)',
	'tog-disablecategoryselect-v2' => 'Disactivar le modulo Categoria (applicabile solmente si le modification in modo visual es disactivate)',
);

/** Indonesian (Bahasa Indonesia)
 * @author Aldnonymous
 * @author Irwangatot
 */
$messages['id'] = array(
	'categoryselect-desc' => 'Menyediakan sebuah antarmuka untuk mengelola kategori dalam artikel tanpa mengedit seluruh artikel.',
	'categoryselect-code-view' => 'Tampilan kode',
	'categoryselect-code-view-placeholder' => 'Tambahkan Kategori di sini, misalnya [[Category:Name]]', # Fuzzy
	'categoryselect-visual-view' => 'Tampilan visual',
	'categoryselect-category-edit' => 'Pilihan kategori',
	'categoryselect-modal-category-name' => 'Memberikan nama kategori:',
	'categoryselect-modal-category-sortkey' => 'Penyusunan artikel ini menurut abjad pada kategori "$1" dengan nama:',
	'categoryselect-button-add' => 'Menambah kategori',
	'categoryselect-category-add' => 'Menambahkan kategori',
	'categoryselect-tooltip-add' => 'Tekan Enter jika sudah selesai',
	'categoryselect-tooltip' => "'''Baru!''' Peralatan tag Kategori. Cobalah atau lihat [[Help:CategorySelect|Bantuan]] untuk mempelajari lebih lanjut",
	'categoryselect-unhandled-syntax' => 'terdeteksi sintaks tidak tertangani - beralih kembali ke modus visual tidak memungkinkan.',
	'categoryselect-edit-summary' => 'Menambahkan kategori',
	'categoryselect-error-empty-category-name' => 'Membutuhkan nama kategori (bagian sebelum |)',
	'categoryselect-button-save' => 'Simpan',
	'categoryselect-button-cancel' => 'Batalkan',
	'categoryselect-error-article-doesnt-exist' => 'Artikel [id=$1] tidak ada.',
	'categoryselect-error-user-rights' => 'Kesalahan hak pengguna.',
	'categoryselect-error-db-locked' => 'Basis data dikunci.',
	'categoryselect-error-edit-abort' => 'Perubahan yang coba Anda lakukan dibatalkan oleh suatu ekstensi kaitan.',
	'tog-disablecategoryselect' => 'Nonaktifkan Kategori Tagging( hanya berlaku jika modus visual telah dinonaktifkan)',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'categoryselect-button-save' => 'Domá',
	'categoryselect-button-cancel' => 'Emekwàlà',
);

/** Italian (italiano)
 * @author Beta16
 * @author Leviathan 89
 * @author Minerva Titani
 * @author Ximo17
 */
$messages['it'] = array(
	'categoryselect-desc' => "Fornisce un'interfaccia per la gestione delle categorie negli articoli senza modificare l'intera pagina",
	'categoryselect-code-view' => 'Modalità codice',
	'categoryselect-code-view-placeholder' => 'Aggiungere le categorie qui, ad esempio [[Categoria:Nome]]', # Fuzzy
	'categoryselect-visual-view' => 'Modalità visuale',
	'categoryselect-category-edit' => 'Opzioni categoria',
	'categoryselect-modal-category-name' => 'Fornire il nome della categoria:',
	'categoryselect-modal-category-sortkey' => 'Alfabetizzare questo articolo nella categoria "$1" sotto il nome:',
	'categoryselect-button-add' => 'Aggiungi categoria',
	'categoryselect-category-add' => 'Aggiungi una categoria',
	'categoryselect-tooltip-add' => 'Premi INVIO quando hai fatto',
	'categoryselect-tooltip' => "'''Novità!''' Barra per il tagging categoria. Provala o cerca [[Help:CategorySelect|aiuto]] per saperne di più",
	'categoryselect-unhandled-syntax' => 'Sintassi non gestita rilevata - passaggio alla modalità visuale impossibile',
	'categoryselect-edit-summary' => 'Categorie aggiunte',
	'categoryselect-error-empty-category-name' => 'Fornire il nome della categoria (parte prima di |)',
	'categoryselect-button-save' => 'Salva',
	'categoryselect-button-cancel' => 'Annulla',
	'categoryselect-error-article-doesnt-exist' => "L'articolo [id=$1] non esiste.",
	'categoryselect-error-user-rights' => "Errore nei diritti dell'utente.",
	'categoryselect-error-db-locked' => 'Database bloccato.',
	'categoryselect-error-edit-abort' => "La modifica che si sta tentando di fare è stata interrotta da un problema dell'estensione",
	'tog-disablecategoryselect' => 'Disabilita il modulo Categoria (si applica solo se la modifica in modalità visuale è stata disabilitata)',
	'tog-disablecategoryselect-v2' => 'Disabilita il modulo Categoria (si applica solo se la modifica in modalità visuale è disabilitata)',
);

/** Japanese (日本語)
 * @author Shirayuki
 * @author Tommy6
 */
$messages['ja'] = array(
	'categoryselect-desc' => '記事を編集することなくカテゴリを操作するためのインターフェースを提供する',
	'categoryselect-code-view' => 'ウィキコードを表示',
	'categoryselect-code-view-placeholder' => 'ここにカテゴリを追加（例: [[Category:カテゴリ名]]）', # Fuzzy
	'categoryselect-visual-view' => 'ビジュアルモードで表示',
	'categoryselect-category-edit' => 'カテゴリのオプション',
	'categoryselect-modal-category-name' => 'カテゴリ名を入力',
	'categoryselect-modal-category-sortkey' => '"$1"カテゴリで記事のソートに使用する名前を入力',
	'categoryselect-button-add' => 'カテゴリを追加',
	'categoryselect-category-add' => 'カテゴリを追加',
	'categoryselect-tooltip-add' => 'エンターキーを押すと終了',
	'categoryselect-tooltip' => "''New!''' カテゴリタギングツールバー。詳しくは[[Help:カテゴリセレクト|ヘルプ]]を参照してください。",
	'categoryselect-unhandled-syntax' => '処理できない構文が検出されました - ビジュアルモードに移行できません。',
	'categoryselect-edit-summary' => 'カテゴリを追加',
	'categoryselect-error-empty-category-name' => 'カテゴリ名を入力（"|"より前の部分）',
	'categoryselect-button-save' => '保存',
	'categoryselect-button-cancel' => '取り消し',
	'categoryselect-error-article-doesnt-exist' => '記事 [id=$1] は存在しません。',
	'categoryselect-error-user-rights' => '利用者権限のエラーです。',
	'categoryselect-error-db-locked' => 'データベースがロックされています',
	'categoryselect-error-edit-abort' => '拡張機能のフックによって、修正が中断されました',
	'tog-disablecategoryselect' => 'カテゴリタグ付け機能を無効にする（ビジュアルモードでの編集を無効にしている場合にのみ適用）',
	'tog-disablecategoryselect-v2' => 'カテゴリモジュールを無効にする（ビジュアルモードでの編集を無効にしている場合にのみ適用）',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'categoryselect-button-save' => 'ಉಳಿಸಿ',
	'categoryselect-button-cancel' => 'ರದ್ದು ಮಾಡು',
);

/** Korean (한국어)
 * @author Cafeinlove
 * @author 아라
 */
$messages['ko'] = array(
	'categoryselect-code-view' => '코드 보기',
	'categoryselect-code-view-placeholder' => '여기에 분류를 추가하세요. 예를 들어 [[Category:이름]]', # Fuzzy
	'categoryselect-visual-view' => '시각적 보기',
	'categoryselect-category-edit' => '분류 옵션',
	'categoryselect-button-add' => '분류 추가',
	'categoryselect-category-add' => '분류 추가',
	'categoryselect-edit-summary' => '분류 추가',
	'categoryselect-error-empty-category-name' => '분류 이름 제공 (| 전에 부분)',
	'categoryselect-button-save' => '저장',
	'categoryselect-button-cancel' => '취소',
	'categoryselect-error-article-doesnt-exist' => '문서 [id=$1]가 존재하지 않습니다.',
	'categoryselect-error-user-rights' => '사용자 권한 오류입니다.',
	'categoryselect-error-db-locked' => '데이터베이스가 잠겨 있습니다.',
);

/** Kurdish (Latin script) (Kurdî (latînî)‎)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'categoryselect-button-cancel' => 'Betal bike',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'categoryselect-code-view-placeholder' => "Hei d'Kategorien derbäisetzen, z. Bsp. [[Category:Numm]]", # Fuzzy
	'categoryselect-category-edit' => 'Optioune vun der Kategorie',
	'categoryselect-button-add' => 'Kategorie derbäisetzen',
	'categoryselect-category-add' => 'Eng Kategorie derbäisetzen',
	'categoryselect-tooltip-add' => "Dréckt 'Enter' wann Dir fäerdeg sidd",
	'categoryselect-edit-summary' => 'Kategorien derbäisetzen',
	'categoryselect-button-save' => 'Späicheren',
	'categoryselect-button-cancel' => 'Ofbriechen',
	'categoryselect-error-article-doesnt-exist' => 'Den Artikel [id=$1] gëtt et net.',
	'categoryselect-error-user-rights' => 'Feeler bäi de Benotzerrechter.',
	'categoryselect-error-db-locked' => "D'Datebank ass gespaart.",
);

/** Lithuanian (lietuvių)
 * @author Eitvys200
 */
$messages['lt'] = array(
	'categoryselect-code-view' => 'Kodo peržiūra',
	'categoryselect-code-view-placeholder' => 'Pridėkite kategorijas čia pvz. [[Kategorija:Pavadinimas]]', # Fuzzy
	'categoryselect-category-edit' => 'Kategorijos nustatymai',
	'categoryselect-button-add' => 'Pridėti kategoriją',
	'categoryselect-category-add' => 'Pridėti kategoriją',
	'categoryselect-tooltip-add' => 'Baigę paspauskite Enter',
	'categoryselect-button-save' => 'Išsaugoti',
	'categoryselect-button-cancel' => 'Atšaukti',
	'categoryselect-error-article-doesnt-exist' => 'Straipsnis [id = $1 ] neegzistuoja.',
	'categoryselect-error-user-rights' => 'Vartotojo teisių klaida.',
	'categoryselect-error-db-locked' => 'Duomenų bazė užrakinta.',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'categoryselect-desc' => 'Дава посредник за раководење со категориите во една статија без да треба да се уредува целата статија.',
	'categoryselect-code-view' => 'Коден изглед',
	'categoryselect-code-view-placeholder' => 'Тука додавајте категории (на пр. [[{{ns:category}}:Name]])',
	'categoryselect-visual-view' => 'Визуелен изглед',
	'categoryselect-category-edit' => 'Нагодувања за категории',
	'categoryselect-modal-category-name' => 'Наведете го името на категоријата:',
	'categoryselect-modal-category-sortkey' => 'Азбучно заведи ја статијава во категоријата „$1“ под името:',
	'categoryselect-button-add' => 'Додај категорија',
	'categoryselect-category-add' => 'Додај категорија',
	'categoryselect-tooltip-add' => 'Пристиснете Enter кога сте готови',
	'categoryselect-tooltip' => "'''Ново!''' Алатник за означување на категории. Испробајте го или одете на [[Help:CategorySelect|помош]] за да дознаете повеќе",
	'categoryselect-unhandled-syntax' => 'Пронајдена е необработена синтакса - не можам да ве вратам во визуелен режим.',
	'categoryselect-edit-summary' => 'Додавање на категории',
	'categoryselect-error-empty-category-name' => 'Наведете има на категоријата (делот пред |)',
	'categoryselect-button-save' => 'Зачувај',
	'categoryselect-button-cancel' => 'Откажи',
	'categoryselect-error-article-doesnt-exist' => 'Статијата [id=$1] не постои.',
	'categoryselect-error-user-rights' => 'Грешка со корисничките права.',
	'categoryselect-error-db-locked' => 'Базата на податоци е заклучена.',
	'categoryselect-error-edit-abort' => 'Измените кои се обидовте да ги направите се откажани од кука за додатоци',
	'tog-disablecategoryselect' => 'Оневозможи го модулот за категории (важи само кога е оневозможено уредувањето во режимот „Визуелно“)',
	'tog-disablecategoryselect-v2' => 'Оневозможи го категорискиот модул (важи само ако е оневозможен визуелниот режим)',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'categoryselect-category-edit' => 'വർഗ്ഗത്തിലെ ഐച്ഛികങ്ങൾ',
	'categoryselect-button-add' => 'വർഗ്ഗം ചേർക്കുക',
	'categoryselect-tooltip-add' => 'പൂർത്തിയാകുമ്പോൾ എന്റർ അമർത്തുക',
	'categoryselect-button-save' => 'സേവ് ചെയ്യുക',
	'categoryselect-button-cancel' => 'റദ്ദാക്കുക',
	'categoryselect-error-article-doesnt-exist' => 'ലേഖനം [id=$1] നിലവിലില്ല.',
);

/** Mongolian (монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'categoryselect-button-cancel' => 'Цуцлах',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'categoryselect-desc' => 'Menyediakan antara muka untuk menguruskan kategori dalam laman tanpa menyunting seluruh rencana',
	'categoryselect-code-view' => 'Paparan kod',
	'categoryselect-code-view-placeholder' => 'Tambahkan kategori di sini, cth. [[Category:Name]]', # Fuzzy
	'categoryselect-visual-view' => 'Paparan visual',
	'categoryselect-category-edit' => 'Pilihan kategori',
	'categoryselect-modal-category-name' => 'Nyatakan nama kategori:',
	'categoryselect-modal-category-sortkey' => 'Abjadkan rencana ini di laman kategori "$1" di bawah nama',
	'categoryselect-button-add' => 'Tambahkan kategori',
	'categoryselect-category-add' => 'Tambahkan kategori',
	'categoryselect-tooltip-add' => 'Tekan Enter apabila siap',
	'categoryselect-tooltip' => "'''Baru!''' Bar alat pengetagan kategori. Cubalah atau dapatkan [[Help:CategorySelect|bantuan]] untuk mengetahui lebih lanjut",
	'categoryselect-unhandled-syntax' => 'Sintaks yang tidak diuruskan dikesan - tidak dapat beralih kembali ke mod visual.',
	'categoryselect-edit-summary' => 'Menambahkan kategori',
	'categoryselect-error-empty-category-name' => 'Nyatakan nama kategori (bahagian sebelum |)',
	'categoryselect-button-save' => 'Simpan',
	'categoryselect-button-cancel' => 'Batalkan',
	'categoryselect-error-article-doesnt-exist' => 'Rencana [id=$1] tidak wujud.',
	'categoryselect-error-user-rights' => 'Ralat hak pengguna.',
	'categoryselect-error-db-locked' => 'Pangkalan data dikunci.',
	'categoryselect-error-edit-abort' => 'Pengubahsuaian yang anda cuba buat telah dipaksa henti oleh cangkuk sambungan',
	'tog-disablecategoryselect' => 'Matikan modul Kategori (hanya jika tidak boleh menyunting dalam mod visual)',
	'tog-disablecategoryselect-v2' => 'Matikan modul Kategori (hanya jika mod penyuntingan visual dimatikan)',
);

/** Norwegian Bokmål (norsk (bokmål)‎)
 * @author Audun
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'categoryselect-desc' => 'Tilbyr et grensesnitt for håndtering av kategorier i artikler uten å redigere hele artikkelen.',
	'categoryselect-code-view' => 'Kodevisning',
	'categoryselect-code-view-placeholder' => 'Legg til en kategori her, f. eks. [[Category:Name]]', # Fuzzy
	'categoryselect-visual-view' => 'Visuell visning',
	'categoryselect-category-edit' => 'Kategorivalg',
	'categoryselect-modal-category-name' => 'Oppgi navnet på kategorien:',
	'categoryselect-modal-category-sortkey' => 'Alfabetiser denne artikkelen under kategorisiden «$1» under navnet:',
	'categoryselect-button-add' => 'Legg til kategori',
	'categoryselect-category-add' => 'Legg til en kategori',
	'categoryselect-tooltip-add' => 'Trykk Enter når du er ferdig',
	'categoryselect-tooltip' => "'''Nyhet!''' Verktøylinje for kategorimerking. Prøv den eller se [[Help:CategorySelect|her]] for å lære mer",
	'categoryselect-unhandled-syntax' => 'Uhåndtert syntaks oppdaget - umulig å bytte tilbake til visuell modus.',
	'categoryselect-edit-summary' => 'Legger til kategorier',
	'categoryselect-error-empty-category-name' => 'Oppgi kategorinavn (del før |)',
	'categoryselect-button-save' => 'Lagre',
	'categoryselect-button-cancel' => 'Avbryt',
	'categoryselect-error-article-doesnt-exist' => 'Artikkel [id=$1] finnes ikke.',
	'categoryselect-error-user-rights' => 'Feil med brukerrettigheter.',
	'categoryselect-error-db-locked' => 'Database er låst.',
	'categoryselect-error-edit-abort' => 'Endringene du prøvde å utføre ble avbrutt av en utvidelseskrok',
	'tog-disablecategoryselect' => 'Deaktiver kategorimodulen (gjelder kun dersom redigering i visuell modus er deaktivert)',
	'tog-disablecategoryselect-v2' => 'Deaktiver kategorimodulen (gjelder kun dersom redigering i visuell modus er deaktivert)',
);

/** Dutch (Nederlands)
 * @author McDutchie
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'categoryselect-desc' => 'Biedt een interface voor het beheren van categorieën in een pagina zonder de hele pagina te bewerken',
	'categoryselect-code-view' => 'Wikitekstweergave',
	'categoryselect-code-view-placeholder' => 'Categorieën hier toevoegen, bijvoorbeeld [[{{ns:category}}:Name]]',
	'categoryselect-visual-view' => 'Visuele weergave',
	'categoryselect-category-edit' => 'Categoriemogelijkheden',
	'categoryselect-modal-category-name' => 'Geef de naam van een categorie op:',
	'categoryselect-modal-category-sortkey' => 'Rangschik deze pagina in de categoriepagina "$1" onder:',
	'categoryselect-button-add' => 'Categorie toevoegen',
	'categoryselect-category-add' => 'Categorie toevoegen',
	'categoryselect-tooltip-add' => 'Druk "Enter" als u klaar bent',
	'categoryselect-tooltip' => "'''Nieuw!''' Werkbalk voor categorielabels.
Probeer het uit of zie [[Help:CategorySelect|help]] voor meer informatie.",
	'categoryselect-unhandled-syntax' => 'Er is ongeldige wikitekst gedetecteerd.
Terugschakelen naar visuele weergave is niet mogelijk.',
	'categoryselect-edit-summary' => 'Bezig met het toevoegen van categorieën',
	'categoryselect-error-empty-category-name' => 'Geef de categoriemaan op (het deel voor "|")',
	'categoryselect-button-save' => 'Opslaan',
	'categoryselect-button-cancel' => 'Annuleren',
	'categoryselect-error-article-doesnt-exist' => 'De pagina [id=$1] bestaat niet.',
	'categoryselect-error-user-rights' => 'Fout in de gebruikersrechten.',
	'categoryselect-error-db-locked' => 'De database is geblokkeerd.',
	'categoryselect-error-edit-abort' => 'De wijziging die u probeerde te maken is afgebroken door een uitbreidingshook',
	'tog-disablecategoryselect' => 'Categoriemodule uitschakelen (alleen van toepassing als bewerken in visuele modus is uitgeschakeld)',
	'tog-disablecategoryselect-v2' => 'Categoriemodule uitschakelen (alleen van toepassing als de visuele tekstverwerker is uitgeschakeld)',
);

/** Nederlands (informeel)‎ (Nederlands (informeel)‎)
 * @author Siebrand
 */
$messages['nl-informal'] = array(
	'categoryselect-error-edit-abort' => 'De wijziging die je probeerde te maken is afgebroken door een uitbreidingshook',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Psubhashish
 */
$messages['or'] = array(
	'categoryselect-button-cancel' => 'ନାକଚ',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'categoryselect-button-save' => 'Beilege',
);

/** Pälzisch (Pälzisch)
 * @author Manuae
 */
$messages['pfl'] = array(
	'categoryselect-button-save' => 'Schbaischare',
	'categoryselect-button-cancel' => 'Uffhere',
);

/** Polish (polski)
 * @author BeginaFelicysym
 * @author Sovq
 */
$messages['pl'] = array(
	'categoryselect-desc' => 'Umożliwia zarządzanie kategoriami bez potrzeby edytowania całego artykułu',
	'categoryselect-code-view' => 'Tryb źródłowy',
	'categoryselect-code-view-placeholder' => 'Dodaj kategorie tutaj, np. [[{{ns:category}}:Nazwa]]',
	'categoryselect-visual-view' => 'Tryb wizualny',
	'categoryselect-category-edit' => 'Opcje kategorii',
	'categoryselect-modal-category-name' => 'Podaj nazwę kategorii:',
	'categoryselect-modal-category-sortkey' => 'Umieść artykuł na alfabetycznej liście kategorii "$1" pod nazwą:',
	'categoryselect-button-add' => 'Dodaj kategorię',
	'categoryselect-category-add' => 'Dodaj kategorię',
	'categoryselect-tooltip-add' => 'Zatwierdź wciskając Enter',
	'categoryselect-tooltip' => "'''Nowość!''' Pasek dodawania kategorii. Wypróbuj lub zobacz [[Help:CategorySelect|stronę pomocy]] aby dowiedzieć się więcej",
	'categoryselect-unhandled-syntax' => 'Wykryto nieobsługiwaną składnię - powrót do trybu wizualnego niemożliwy.',
	'categoryselect-edit-summary' => 'Dodawanie kategorii',
	'categoryselect-error-empty-category-name' => 'Podaj nazwę kategorii (część przed |)',
	'categoryselect-button-save' => 'Zapisz',
	'categoryselect-button-cancel' => 'Anuluj',
	'categoryselect-error-article-doesnt-exist' => 'Artykuł [id=$1] nie istnieje.',
	'categoryselect-error-user-rights' => 'Błąd uprawnień użytkownika.',
	'categoryselect-error-db-locked' => 'Baza danych jest zablokowana',
	'categoryselect-error-edit-abort' => 'Zmiany, które próbowano wprowadzić zostały anulowane przez inne rozszerzenie',
	'tog-disablecategoryselect' => 'Wyłącz dodawanie kategorii',
	'tog-disablecategoryselect-v2' => 'Wyłącz dodawanie kategorii w trybie źródłowym',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'categoryselect-desc' => "A dà n'antërfacia për gestì categorìe ant j'artìcoj sensa modifiché tut l'artìcol.",
	'categoryselect-code-view' => 'Visualisé ël còdes',
	'categoryselect-code-view-placeholder' => 'Gionta dle categorìe ambelessì, p.e. [[Category:Name]]', # Fuzzy
	'categoryselect-visual-view' => 'Visualisassion visual',
	'categoryselect-category-edit' => 'Opsion ëd categorìa',
	'categoryselect-modal-category-name' => 'Dà ël nòm ëd la categorìa',
	'categoryselect-modal-category-sortkey' => 'Buté st\'artìcol-sì ant la pàgina ëd categorìa "$1" an órdin alfabétich sota ël nòm:',
	'categoryselect-button-add' => 'Gionta categorìa',
	'categoryselect-category-add' => 'Gionta na categorìa',
	'categoryselect-tooltip-add' => 'Sgnaché su Mandé quand fàit',
	'categoryselect-tooltip' => "'''Neuv!''' Bara dj'utiss ëd j'etichëtte ëd categorìa. Ch'a la preuva o ch'a varda [[Help:CategorySelect|agiut]] për savèjne ëd pi",
	'categoryselect-unhandled-syntax' => "Trovà sintassi pa gestìa - a l'é pa possìbil torné andré a modalità visual.",
	'categoryselect-edit-summary' => 'Gionté categorìe',
	'categoryselect-error-empty-category-name' => 'Dé nòm a la categorìa (part prima |)',
	'categoryselect-button-save' => 'Salva',
	'categoryselect-button-cancel' => 'Scancelé',
	'categoryselect-error-article-doesnt-exist' => "L'artìcol [id=$1] a esist pa.",
	'categoryselect-error-user-rights' => "Eror dij drit dj'utent.",
	'categoryselect-error-db-locked' => "La base ëd dàit a l'é blocà.",
	'categoryselect-error-edit-abort' => "La modìfica ch'it l'has provà a fé a l'é stàita abortìa da n'agancc ëd n'estension",
	'tog-disablecategoryselect' => "Disabilité ël mòdul dle categorìe (a s'àplica mach se ël modifiché an manera visual a l'é stàit disabilità)",
	'tog-disablecategoryselect-v2' => "Disabilité ël mòdul Categorìa (a s'àplica mach se l'edission an manera visual a l'é disabilità)",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'categoryselect-button-add' => 'وېشنيزه ورګډول',
	'categoryselect-category-add' => 'يوه وېشنيزه ورګډول',
	'categoryselect-edit-summary' => 'وېشنيزې ورګډول',
	'categoryselect-button-save' => 'خوندي کول',
	'categoryselect-button-cancel' => 'ناګارل',
);

/** Portuguese (português)
 * @author Hamilton Abreu
 * @author Malafaya
 * @author SandroHc
 */
$messages['pt'] = array(
	'categoryselect-desc' => 'Fornece uma interface de gestão das categorias de um artigo sem editar o artigo completo.',
	'categoryselect-code-view' => 'Modo de código',
	'categoryselect-code-view-placeholder' => 'Adiciona categorias aqui, exemplo: [[Categoria:Nome]]', # Fuzzy
	'categoryselect-visual-view' => 'Modo de visionamento',
	'categoryselect-category-edit' => 'Opções de categoria',
	'categoryselect-modal-category-name' => 'Introduza o nome da categoria:',
	'categoryselect-modal-category-sortkey' => 'Na página da categoria "$1", listar esta página na posição do nome:',
	'categoryselect-button-add' => 'Adicionar categoria',
	'categoryselect-category-add' => 'Adicionar uma categoria',
	'categoryselect-tooltip-add' => 'Pressione Enter quando tiver acabado',
	'categoryselect-tooltip' => "'''Novo!''' Barra de ferramentas de categorização. Experimente-a ou consulte a [[Help:CategorySelect|ajuda]] para saber mais",
	'categoryselect-unhandled-syntax' => 'Foi detectada sintaxe que não pode ser tratada - não é possível voltar ao modo de visionamento.',
	'categoryselect-edit-summary' => 'A adicionar categorias',
	'categoryselect-error-empty-category-name' => 'Introduza o nome da categoria (a parte antes de |)',
	'categoryselect-button-save' => 'Gravar',
	'categoryselect-button-cancel' => 'Cancelar',
	'categoryselect-error-article-doesnt-exist' => 'A página [id=$1] não existe.',
	'categoryselect-error-user-rights' => 'Erro de permissões.',
	'categoryselect-error-db-locked' => 'A base de dados está trancada.',
	'categoryselect-error-edit-abort' => 'A alteração que tentou fazer foi abortada pelo hook de uma extensão',
	'tog-disablecategoryselect' => 'Desligar o módulo de Categorias (aplica-se apenas se a edição em modo visual tiver sido desativada)',
	'tog-disablecategoryselect-v2' => 'Desligar o módulo de Categorias (aplica-se apenas se a edição em modo visual estiver desativada)',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Aristóbulo
 * @author Giro720
 * @author Jesielt
 * @author TheGabrielZaum
 * @author 555
 */
$messages['pt-br'] = array(
	'categoryselect-desc' => 'Disponibiliza uma interface para a administração de categorias de uma página sem que seja necessário editá-lo por inteiro',
	'categoryselect-code-view' => 'Ver em modo de código',
	'categoryselect-code-view-placeholder' => 'Adicione categorias aqui, ex. [[Category:Nome]]', # Fuzzy
	'categoryselect-visual-view' => 'Exibição visual',
	'categoryselect-category-edit' => 'Opções de categoria',
	'categoryselect-modal-category-name' => 'Dê o nome da categoria:',
	'categoryselect-modal-category-sortkey' => 'Classifique este artigo na categoria "$1" com o nome de:',
	'categoryselect-button-add' => 'Adicione uma categoria',
	'categoryselect-category-add' => 'Adicionar uma categoria',
	'categoryselect-tooltip-add' => 'Pressione "Enter" depois de digitar',
	'categoryselect-tooltip' => "'''Novidade!''' Barra de ferramentas para a aplicação de categorias. Experimente ou veja a [[Help:CategorySelect|página de ajuda]] para aprender mais",
	'categoryselect-unhandled-syntax' => 'Sintaxe não manipulada detectada - impossível voltar ao modo visual.',
	'categoryselect-edit-summary' => 'Adicionando categorias',
	'categoryselect-error-empty-category-name' => 'Coloque o nome da categoria (parte anterior a I)',
	'categoryselect-button-save' => 'Salvar',
	'categoryselect-button-cancel' => 'Cancelar',
	'categoryselect-error-article-doesnt-exist' => 'O artigo [id=$1] não existe.',
	'categoryselect-error-user-rights' => 'Erro nos direitos de usuário.',
	'categoryselect-error-db-locked' => 'O banco de dados está bloqueado.',
	'categoryselect-error-edit-abort' => "A alteração que você tentou fazer foi abortada pelo ''hook'' de uma extensão",
	'tog-disablecategoryselect' => 'Desabilitar o módulo de categorias (apenas aplicado caso a edição em modo visual foi desabilitada)',
	'tog-disablecategoryselect-v2' => 'Desativar o módulo de Categorias (aplicado apenas se o Modo Visual está desativado)',
);

/** Romanian (română)
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'categoryselect-code-view' => 'Vizualizare cod',
	'categoryselect-visual-view' => 'Vizualizare vizuală',
	'categoryselect-category-edit' => 'Opţiuni categorie',
	'categoryselect-modal-category-name' => 'Furnizaţi numele categoriei:',
	'categoryselect-button-add' => 'Adaugă categorie',
	'categoryselect-tooltip-add' => 'Apasă Enter când aţi terminat',
	'categoryselect-button-save' => 'Salvează',
	'categoryselect-button-cancel' => 'Renunţă',
	'categoryselect-error-db-locked' => 'Baza de date este blocată.',
);

/** Russian (русский)
 * @author DCamer
 * @author Kuzura
 * @author Lockal
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'categoryselect-desc' => 'Предоставляет интерфейс для управления категориями в статье без редактирования всей статьи.',
	'categoryselect-code-view' => 'Просмотр кода',
	'categoryselect-code-view-placeholder' => 'Укажите тут категорию, например, [[{{ns:category}}:Название]].',
	'categoryselect-visual-view' => 'Визуальный просмотр',
	'categoryselect-category-edit' => 'Настройки категории',
	'categoryselect-modal-category-name' => 'Укажите имя категории:',
	'categoryselect-modal-category-sortkey' => 'Приводить эту статью на странице категории «$1» под следующем именем:',
	'categoryselect-button-add' => 'Добавить категорию',
	'categoryselect-category-add' => 'Добавить категорию',
	'categoryselect-tooltip-add' => 'Нажмите Enter, когда закончите',
	'categoryselect-tooltip' => "'''Новое!''' Панель категоризации. Попробуйте. Подробнее см. в [[Help:CategorySelect|справке]]",
	'categoryselect-unhandled-syntax' => 'Обнаружен неподдерживаемый синтаксис — невозможно вернуть назад к наглядному режиму.',
	'categoryselect-edit-summary' => 'Добавление категорий',
	'categoryselect-error-empty-category-name' => 'Укажите название категории (часть до |)',
	'categoryselect-button-save' => 'Сохранить',
	'categoryselect-button-cancel' => 'Отмена',
	'categoryselect-error-article-doesnt-exist' => 'Статья [id=$1] не существует.',
	'categoryselect-error-user-rights' => 'Ошибка прав участника.',
	'categoryselect-error-db-locked' => 'База данных заблокирована.',
	'categoryselect-error-edit-abort' => 'Изменение, которые вы пытались сделать, прервано обработчиком расширения',
	'tog-disablecategoryselect' => 'Отключить модуль категорий (применяется только при отключенном редактировании в визуальном режиме)',
	'tog-disablecategoryselect-v2' => 'Отключить модуль Категорий (активно только при редактировании в режиме Исходного кода)',
);

/** Slovenian (slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'categoryselect-button-save' => 'Shrani',
);

/** Serbian (Cyrillic script) (српски (ћирилица)‎)
 * @author Rancher
 * @author Verlor
 */
$messages['sr-ec'] = array(
	'categoryselect-code-view' => 'Преглед кода',
	'categoryselect-visual-view' => 'Визуални преглед',
	'categoryselect-category-edit' => 'Поставке категорије',
	'categoryselect-modal-category-name' => 'Унесите име категорије:',
	'categoryselect-button-add' => 'Додај категорију',
	'categoryselect-tooltip-add' => 'Притисните Enter када завршите.',
	'categoryselect-edit-summary' => 'Додавање категорија',
	'categoryselect-button-save' => 'Сачувај',
	'categoryselect-button-cancel' => 'Откажи',
	'categoryselect-error-article-doesnt-exist' => 'Чланак [id=$1] не постоји.',
	'categoryselect-error-user-rights' => 'Грешка у корисничким правима.',
	'categoryselect-error-db-locked' => 'База података је закључана.',
);

/** Swedish (svenska)
 * @author Tobulos1
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'categoryselect-desc' => 'Provides an interface for managing categories in article without editing whole article',
	'categoryselect-code-view' => 'Kodvy',
	'categoryselect-code-view-placeholder' => 'Lägg till kategorier här, t.ex. [[{{ns:category}}:Namn]]',
	'categoryselect-visual-view' => 'Visuell vy',
	'categoryselect-category-edit' => 'Kategori-alternativ',
	'categoryselect-modal-category-name' => 'Ge namnet på kategorin:',
	'categoryselect-modal-category-sortkey' => 'Alfabetisera denna artikel på kategorin "$1" under namnet:',
	'categoryselect-button-add' => 'Lägg till kategori',
	'categoryselect-category-add' => 'Lägg till en kategori',
	'categoryselect-tooltip-add' => 'Tryck Enter när du är klar',
	'categoryselect-tooltip' => "'''Nytt!''' Verktygsfält för kategoritaggning. Prova den eller se [[Help:CategorySelect|hjälp]] för att läsa mer",
	'categoryselect-unhandled-syntax' => 'Ohanterad syntax upptäcktes - omöjligt att växla tillbaka till visuellt läge.',
	'categoryselect-edit-summary' => 'Lägg till kategorier',
	'categoryselect-error-empty-category-name' => 'Ange kategorinamn (del innan |)',
	'categoryselect-button-save' => 'Spara',
	'categoryselect-button-cancel' => 'Avbryt',
	'categoryselect-error-article-doesnt-exist' => 'Artikel [id=$1] finns inte.',
	'categoryselect-error-user-rights' => 'Fel om användarrättigheter.',
	'categoryselect-error-db-locked' => 'Databasen är låst.',
	'categoryselect-error-edit-abort' => 'Ändringen du försökte göra avbröts av en förlängningskrok',
	'tog-disablecategoryselect' => 'Inaktivera kategorimodul (gäller endast om redigering i visuellt läge har inaktiverats)',
	'tog-disablecategoryselect-v2' => 'Inaktivera kategorimodulen (gäller endast om det visuella redigeringsläget är inaktiverat)',
);

/** Swahili (Kiswahili)
 */
$messages['sw'] = array(
	'categoryselect-button-save' => 'Hifadhi',
	'categoryselect-button-cancel' => 'Batilisha',
);

/** Telugu (తెలుగు)
 * @author Praveen Illa
 * @author Veeven
 */
$messages['te'] = array(
	'categoryselect-category-edit' => 'వర్గాల ఎంపికలు',
	'categoryselect-button-add' => 'వర్గాన్ని చేర్చండి',
	'categoryselect-category-add' => 'ఒక వర్గాన్ని చేర్చండి',
	'categoryselect-button-save' => 'భద్రపరచు',
	'categoryselect-button-cancel' => 'రద్దుచేయి',
	'categoryselect-error-db-locked' => 'డేటాబేసు లాక్‌చెయ్యబడింది.',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'categoryselect-desc' => 'Nagbibigay ng isang hangganang-mukha para sa pamamahala ng mga kategorya sa loob ng artikulo na hindi binabago ang buong artikulo.',
	'categoryselect-code-view' => 'Tingin sa kodigo',
	'categoryselect-code-view-placeholder' => 'Dito magdagdag ng mga kategorya, halimbawa na ang [[Category:Name|Kategorya:Pangalan]]', # Fuzzy
	'categoryselect-visual-view' => 'Tanawing nakikita',
	'categoryselect-category-edit' => 'Mga mapagpipilian ng kategorya',
	'categoryselect-modal-category-name' => 'Ibigay ang pangalan ng kategorya',
	'categoryselect-modal-category-sortkey' => 'Gawing naka-abakada ang artikulong ito sa pahina ng kategoryang "$1" sa ilalim ng pangalang:',
	'categoryselect-button-add' => 'Idagdag ang kategorya',
	'categoryselect-category-add' => 'Magdagdag ng isang kategorya',
	'categoryselect-tooltip-add' => 'Pindutin ang Ipasok pagkatapos',
	'categoryselect-tooltip' => "'''Bago!''' Kahon ng kasangkapan na pantatak ng Kategorya. Subukan ito o tingnan ang [[Help:CategorySelect|tulong]] upang makaalam pa ng marami",
	'categoryselect-unhandled-syntax' => 'Nakapuna ng hindi nahahawakang sintaks - hindi maaari ang pagbabalik sa modalidad na natatanaw.',
	'categoryselect-edit-summary' => 'Idinaragdag ang mga kategorya',
	'categoryselect-error-empty-category-name' => 'Ibigay ang pangalan ng kategorya (bahagi bago ang |)',
	'categoryselect-button-save' => 'Sagipin',
	'categoryselect-button-cancel' => 'Huwag ituloy',
	'categoryselect-error-article-doesnt-exist' => 'Hindi umiiral ang artikulong [id=$1].',
	'categoryselect-error-user-rights' => 'Kamalian sa mga karapatan ng tagagamit.',
	'categoryselect-error-db-locked' => 'Nakakandado ang kalipunan ng dato',
	'categoryselect-error-edit-abort' => 'Ang pagbabagong sinubok mong gawin ay pinigil ng isang kawil ng dugtong',
	'tog-disablecategoryselect' => 'Huwag Paganahin ang modulo ng Kategorya (mailalapat lang kapag hindi pinagagana ang pamamatnugot na nasa gawi na nakikita)',
	'tog-disablecategoryselect-v2' => 'Huwag paganahin ang modyul ng Kategorya (nailalapat lamang kapag hindi pinagagana ang pamamatnugot na nasa gawi na nakikita)',
);

/** толышә зывон (толышә зывон)
 * @author Гусейн
 */
$messages['tly'] = array(
	'categoryselect-button-cancel' => 'Ләғв кардеј',
);

/** Turkish (Türkçe)
 * @author Gizemb
 * @author Suelnur
 */
$messages['tr'] = array(
	'categoryselect-button-add' => 'Kategori ekle',
	'categoryselect-button-save' => 'Kaydet',
	'categoryselect-button-cancel' => 'İptal',
);

/** Tatar (Cyrillic script) (татарча)
 * @author Zahidulla
 */
$messages['tt-cyrl'] = array(
	'categoryselect-code-view' => 'Кодны карау',
	'categoryselect-visual-view' => 'Визуаль карау',
	'categoryselect-category-edit' => 'Төркемнәр көйләнмәләре',
	'categoryselect-button-add' => 'Төркем өстәргә',
	'categoryselect-tooltip-add' => 'Тәмамлагач Enter-га басыгыз',
	'categoryselect-edit-summary' => 'Төркемнәр өстәү',
	'categoryselect-button-save' => 'Сакларга',
	'categoryselect-button-cancel' => 'Кире кагу',
	'categoryselect-error-article-doesnt-exist' => '[id=$1] мәкаләсе юк.',
	'categoryselect-error-db-locked' => 'Мәгълүматлар базасы тыелган',
);

/** Ukrainian (українська)
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'categoryselect-desc' => 'Забезпечує інтерфейс для управління категоріями у статті без редагування всієї статті.',
	'categoryselect-code-view' => 'Перегляд коду',
	'categoryselect-category-edit' => 'Параметри категорії',
	'categoryselect-modal-category-name' => 'Вкажіть назву категорії:',
	'categoryselect-modal-category-sortkey' => 'Включити ключ сортування цієї статті в категорії "$1" за наступною назвою/параметром:',
	'categoryselect-button-add' => 'Додати категорію',
	'categoryselect-tooltip-add' => 'Натисніть Enter, коли закінчите',
	'categoryselect-edit-summary' => 'Додавання категорій',
	'categoryselect-error-empty-category-name' => 'Введіть назву категорії (частину до |)',
	'categoryselect-button-save' => 'Зберегти',
	'categoryselect-button-cancel' => 'Скасувати',
	'categoryselect-error-article-doesnt-exist' => 'Статті [id=$1] не існує.',
	'categoryselect-error-user-rights' => 'Помилка прав користувача.',
);

/** Urdu (اردو)
 */
$messages['ur'] = array(
	'categoryselect-button-cancel' => 'منسوخ',
);

/** Veps (vepsän kel’)
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'categoryselect-button-save' => 'Panda muštho',
);

/** Vietnamese (Tiếng Việt)
 * @author Xiao Qiao
 */
$messages['vi'] = array(
	'categoryselect-desc' => 'Cung cấp một giao diện để quản lý thể loại trong bài viết mà không cần chỉnh sửa toàn bộ bài viết',
	'categoryselect-code-view' => 'Xem mã',
	'categoryselect-code-view-placeholder' => 'Chèn thể loại tại đây, ví dụ [[Category:Name]]', # Fuzzy
	'categoryselect-visual-view' => 'Xem trực quan',
	'categoryselect-category-edit' => 'Tùy chọn thể loại',
	'categoryselect-modal-category-name' => 'Cung cấp tên thể loại:',
	'categoryselect-modal-category-sortkey' => 'Sắp xếp theo bảng chữ cái bài biết này trên trang thể loại "$1" dưới tên:',
	'categoryselect-button-add' => 'Chèn thể loại',
	'categoryselect-category-add' => 'Chèn thể loại',
	'categoryselect-tooltip-add' => 'Nhấn Enter khi thực hiện xong',
	'categoryselect-tooltip' => "'''Mới!''' Thể loại gắn trên thanh công cụ. Hãy xem thử hoặc vào trang [[Help:CategorySelect|trợ giúp]] để tìm hiểu thêm",
	'categoryselect-unhandled-syntax' => 'Chưa xử lý cú pháp phức tạp - không thể trở về chế độ trực quan.',
	'categoryselect-edit-summary' => 'Thêm thể loại',
	'categoryselect-error-empty-category-name' => 'Cung cấp tên thể loại (phần trước dấu |)',
	'categoryselect-button-save' => 'Lưu',
	'categoryselect-button-cancel' => 'Hủy bỏ',
	'categoryselect-error-article-doesnt-exist' => 'Bài viết [id = $1] không tồn tại.',
	'categoryselect-error-user-rights' => 'Lỗi quyền người dùng.',
	'categoryselect-error-db-locked' => 'Cơ sở dữ liệu bị khóa.',
	'categoryselect-error-edit-abort' => 'Sửa đổi bạn cố gắng thực hiện đã bị hủy bỏ bởi một móc phần mở rộng',
	'tog-disablecategoryselect' => 'Vô hiệu hóa mô-đun Thể loại (chỉ áp dụng khi sửa đổi trong chế độ trực quan đã bị vô hiệu)',
	'tog-disablecategoryselect-v2' => 'Vô hiệu hóa bản Thể loại (chỉ áp dụng khi sửa đổi ở chế độ trực quan bị vô hiệu hoá)',
);

/** Wu (吴语)
 */
$messages['wuu'] = array(
	'categoryselect-button-cancel' => '取消',
);

/** Chinese (中文)
 */
$messages['zh'] = array(
	'categoryselect-category-edit' => '分類選項',
	'categoryselect-modal-category-name' => '分類的名稱',
	'categoryselect-modal-category-sortkey' => '此文章在"$1"分類中使用以下的名義排序:',
	'categoryselect-button-add' => '增加分類',
	'categoryselect-tooltip-add' => '完成時請鍵入＜ＥＮＴＥＲ＞',
	'categoryselect-button-save' => '儲存',
	'categoryselect-button-cancel' => '取消',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Dimension
 * @author Hydra
 * @author Hzy980512
 */
$messages['zh-hans'] = array(
	'categoryselect-code-view' => '代码视图',
	'categoryselect-code-view-placeholder' => '在此添加分类，例如[[{{ns:category}}:Name]]',
	'categoryselect-visual-view' => '预览视图',
	'categoryselect-modal-category-name' => '输入类别的名称：',
	'categoryselect-button-add' => '添加分类',
	'categoryselect-category-add' => '添加分类',
	'categoryselect-tooltip-add' => '完成时按Enter键',
	'categoryselect-edit-summary' => '添加分类',
	'categoryselect-button-save' => '保存',
	'categoryselect-button-cancel' => '取消',
	'categoryselect-error-article-doesnt-exist' => '条目：[id=$1]不存在。',
	'categoryselect-error-user-rights' => '用户权限错误。',
	'categoryselect-error-db-locked' => '数据库已锁定。',
);

/** Traditional Chinese (中文（繁體）‎)
 * @author Ffaarr
 */
$messages['zh-hant'] = array(
	'categoryselect-category-edit' => '分類選項',
	'categoryselect-modal-category-name' => '提供的分類的名稱：',
	'categoryselect-button-add' => '增加分類',
	'categoryselect-category-add' => '增加一個分類',
	'categoryselect-tooltip-add' => '完成時按 Enter',
	'categoryselect-edit-summary' => '增加分類',
	'categoryselect-button-save' => '儲存',
	'categoryselect-button-cancel' => '取消',
	'categoryselect-error-article-doesnt-exist' => '文章 [id = $1 ] 不存在。',
	'categoryselect-error-user-rights' => '用戶權限錯誤。',
	'categoryselect-error-db-locked' => '資料庫已鎖定。',
);
