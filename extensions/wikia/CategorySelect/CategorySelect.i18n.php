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

$messages['en'] = array(
	'categoryselect-desc' => 'Provides an interface for managing categories in a page without editing whole page',
	'categoryselect-button-add' => 'Add category',
	'categoryselect-button-cancel' => 'Cancel',
	'categoryselect-button-save' => 'Save',
	'categoryselect-category-add' => 'Add category...',
	'categoryselect-category-edit' => 'Edit category',
	'categoryselect-category-remove' => 'Remove category',
	'categoryselect-edit-summary' => 'Adding categories',
	'categoryselect-error-article-doesnt-exist' => 'Page [id=$1] does not exist.',
	'categoryselect-error-category-name-length' => 'The maximum length for a category name has been reached.',
	'categoryselect-error-db-locked' => 'Database is locked.',
	'categoryselect-error-duplicate-category-name' => 'Category "$1" already exists.',
	'categoryselect-error-edit-abort' => 'The modifications you tried to make were aborted by an extension hook.',
	'categoryselect-error-empty-category-name' => 'Please provide a category name.',
	'categoryselect-error-user-rights' => 'User does not have permission to perform this action.',
	'categoryselect-modal-category-name' => 'Provide the name of the category:',
	'categoryselect-modal-category-sortkey' => 'Optionally, you may alphabetize this page on the "$1" category page under the name:',
	'categoryselect-tooltip-add' => 'Press the Enter or Return key when done.',
	'tog-disablecategoryselect' => 'Disable Category module (only applies if editing in visual mode has been disabled)',
	'tog-disablecategoryselect-v2' => 'Disable Category module (only applies if visual mode editing is disabled)',
);

/** Message documentation (Message documentation)
 * @author Kflorence
 * @author Shirayuki
 */
$messages['qqq'] = array(
	'categoryselect-desc' => '{{desc}}',
	'categoryselect-button-add' => 'The text displayed for the add category button on article pages.
{{Identical|Add category}}',
	'categoryselect-button-cancel' => 'The text displayed for the cancel button on article pages.
{{Identical|Cancel}}',
	'categoryselect-button-save' => 'The text displayed for the save button on article pages.
{{Identical|Save}}',
	'categoryselect-category-add' => 'The placeholder text displayed in the category input field when it is empty.
{{Identical|Add category}}',
	'categoryselect-category-edit' => 'Title text for the edit icon and the heading for category edit modals.',
	'categoryselect-category-remove' => 'Title text for the remove icon.',
	'categoryselect-edit-summary' => 'The summary used for revisions created when saving category updates on view pages.',
	'categoryselect-error-article-doesnt-exist' => "The error message shown when trying to add categories to an article that doesn't exist. Parameters:
* $1: The ID of the article.",
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
	'tog-disablecategoryselect-v2' => 'The text displayed in user preferences for disabling the CategorySelect extension when the UserPreferencesV2 extension is enabled.',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'categoryselect-button-add' => 'Voeg kategorie by',
	'categoryselect-button-cancel' => 'Kanselleer',
	'categoryselect-button-save' => 'Stoor',
	'categoryselect-error-article-doesnt-exist' => 'Artikel [id=$1] bestaan nie.', # Fuzzy
	'categoryselect-error-db-locked' => 'Databasis is gesluit.',
	'categoryselect-tooltip-add' => "Druk 'Enter' as u klaar is", # Fuzzy
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
	'categoryselect-button-add' => 'أضف تصنيفا',
	'categoryselect-button-cancel' => 'إلغاء',
	'categoryselect-button-save' => 'سجل',
	'categoryselect-category-add' => 'أضف تصنيفا',
	'categoryselect-category-edit' => 'عدل التصنيف',
	'categoryselect-category-remove' => 'إزالة التصنيف',
	'categoryselect-edit-summary' => 'إضافة التصانيف',
	'categoryselect-error-article-doesnt-exist' => 'المقالة ذات [الإسم=$1] لا وجود لها.',
	'categoryselect-error-category-name-length' => 'لا يمكن تجاوز الحد الأقصى لطول اسم تصنيف.',
	'categoryselect-error-db-locked' => 'قاعدة البيانات مغلقة',
	'categoryselect-error-duplicate-category-name' => 'الفئة " $1 " موجود بالفعل.',
	'categoryselect-error-edit-abort' => 'التعديل الذي تحاول أن تقوم به تم تعطيله من قبل مقياس امتدادي.',
	'categoryselect-error-empty-category-name' => 'الرجاء توفير اسم للتصنيف.',
	'categoryselect-error-user-rights' => 'المستخدم ليس لديه الإذن لتنفيذ هذا الإجراء.',
	'categoryselect-modal-category-name' => 'قدم إسما للتصنيف:',
	'categoryselect-modal-category-sortkey' => 'يمكنك ترتيب هذه الصفحة أبجديا تحت تصنيف "$1" حسب الإسم:',
	'categoryselect-tooltip-add' => 'اضغط على المفتاح Enter أو Return عند القيام به.',
	'tog-disablecategoryselect' => 'تعطيل وسم التصنيفات (لن يعمل إلا إذا تم تغيير محرر النص المتطور)',
	'tog-disablecategoryselect-v2' => 'تعطيل إختيار التصنيفات (لن يعمل إلا إذا تم تغيير محرر النص المتطور)',
);

/** Assamese (অসমীয়া)
 * @author Jaminianurag
 */
$messages['as'] = array(
	'categoryselect-button-add' => 'শ্ৰেণী সংযোগ কৰক',
	'categoryselect-button-cancel' => 'বাতিল কৰক',
	'categoryselect-button-save' => 'সঞ্চিত কৰক',
);

/** Azerbaijani (azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'categoryselect-button-cancel' => 'Ləğv et',
	'categoryselect-button-save' => 'Qeyd et',
);

/** Bavarian (Boarisch)
 * @author Mucalexx
 */
$messages['bar'] = array(
	'categoryselect-desc' => "Stöd a Ówerflächen zur da Vawoitung voh da Kategorie in am Artiké zur Vafygung, óne daas ma'n gaunzen Artiké beorweiten muass.",
	'categoryselect-button-add' => 'Kategorie dazuadoah',
	'categoryselect-button-cancel' => 'Obbrechen',
	'categoryselect-button-save' => 'Speichern',
	'categoryselect-category-add' => 'A Kategorie dazuadoah', # Fuzzy
	'categoryselect-category-edit' => 'Kategorie-Ópziónen', # Fuzzy
	'categoryselect-edit-summary' => 'Kategorie dazuadoah',
	'categoryselect-error-article-doesnt-exist' => 'Der Artiké [id=$1] existird néd.', # Fuzzy
	'categoryselect-error-db-locked' => 'Dé Daatenbaunk is im Móment grod gsperrd.',
	'categoryselect-error-edit-abort' => 'Deih vasuachte Änderrung is durch a Aufhänger voh aner Daweiterrung obbrochen worn.', # Fuzzy
	'categoryselect-error-empty-category-name' => 'Kategorie-Naum (der Tei vur |)', # Fuzzy
	'categoryselect-error-user-rights' => 'Koane ausreichenden Benutzerrechtt.', # Fuzzy
	'categoryselect-modal-category-name' => 'Gib an Naum voh da Kategorie auh:', # Fuzzy
	'categoryselect-modal-category-sortkey' => 'Dua dén Artiké in da Kategorie „$1“ unter fóigendm Naum einé:', # Fuzzy
	'categoryselect-tooltip-add' => 'Mid da Eihgobtasten beénden', # Fuzzy
	'tog-disablecategoryselect' => 'Vaoahfochts Kategorisiern ausschoiden',
);

/** Belarusian (Taraškievica orthography) (беларуская (тарашкевіца)‎)
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'categoryselect-button-cancel' => 'Адмяніць',
	'categoryselect-button-save' => 'Захаваць',
);

/** Bulgarian (български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'categoryselect-button-add' => 'Добавяне на категория',
	'categoryselect-button-cancel' => 'Отказване',
	'categoryselect-button-save' => 'Съхраняване',
	'categoryselect-category-add' => 'Добавяне на категория...',
	'categoryselect-edit-summary' => 'Добавяне на категории',
);

/** Bengali (বাংলা)
 * @author Aftab1995
 */
$messages['bn'] = array(
	'categoryselect-button-add' => 'বিষয়শ্রেণী যোগ',
	'categoryselect-button-cancel' => 'বাতিল',
	'categoryselect-button-save' => 'সংরক্ষণ',
	'categoryselect-category-add' => 'বিষয়শ্রেণী যোগ...',
	'categoryselect-category-edit' => 'বিষয়শ্রেণী সম্পাদনা',
	'categoryselect-category-remove' => 'বিষয়শ্রেণী অপসারণ',
);

/** Breton (brezhoneg)
 * @author Fulup
 * @author Gwenn-Ael
 * @author Y-M D
 */
$messages['br'] = array(
	'categoryselect-desc' => 'a bourchas un etrefas evit gallout merañ rummadoù ur pennad hep ma vefe ezhomm da voullañ ar pennad a-bezh.',
	'categoryselect-button-add' => 'Ouzhpennañ rummadoù',
	'categoryselect-button-cancel' => 'Nullañ',
	'categoryselect-button-save' => 'Enrollañ',
	'categoryselect-category-add' => 'Ouzhpennañ ur rummad...',
	'categoryselect-category-edit' => 'Kemmañ ar rummad',
	'categoryselect-category-remove' => 'Tennañ ar rummad kuit',
	'categoryselect-edit-summary' => 'Ouzhpennañ ur rummad',
	'categoryselect-error-article-doesnt-exist' => "N'eus ket eus ar bajenn [id=$1].",
	'categoryselect-error-category-name-length' => 'Tizhet eo bet ar vent vrasañ evit un anv rummad.',
	'categoryselect-error-db-locked' => 'Stanket eo ar bank roadennoù',
	'categoryselect-error-duplicate-category-name' => 'Ar rummad "$1" zo anezhañ dija',
	'categoryselect-error-edit-abort' => "Ar c'hemm hoc'h eus klasket degas zo bet harzet gant ur c'hrog astenn.",
	'categoryselect-error-empty-category-name' => 'Roit anv ar rummad, mar plij',
	'categoryselect-error-user-rights' => "N'ho peus ket ar gwirioù da ouzhpennañ rummadoù d'ar bajenn-mañ.",
	'categoryselect-modal-category-name' => 'Roit anv ar rummad :',
	'categoryselect-modal-category-sortkey' => 'Gallout a reot rummañ ar pennad-mañ en urzh lizherennk war e pajenn ar rummad $1 » dindan an anv (diret) :',
	'categoryselect-tooltip-add' => 'Pouezañ war "Kas" pe "Distro" ur wech echuet',
	'tog-disablecategoryselect' => 'Diweredekaat balizadur ar rummadoù', # Fuzzy
);

/** Catalan (català)
 * @author BroOk
 * @author Marcmpujol
 */
$messages['ca'] = array(
	'categoryselect-desc' => "Proporciona una interfície per gestionar les categories dels articles sense editar tot l'article.",
	'categoryselect-button-add' => 'Afegir categoria',
	'categoryselect-button-cancel' => 'Cancel·la',
	'categoryselect-button-save' => 'Desa',
	'categoryselect-category-add' => 'Afegir una categoria...',
	'categoryselect-category-edit' => 'Editar categoria',
	'categoryselect-category-remove' => 'Suprimir categoria',
	'categoryselect-edit-summary' => 'Afegint categories',
	'categoryselect-error-article-doesnt-exist' => 'La pàgina "$1" no existeix.',
	'categoryselect-error-category-name-length' => "S'ha assolit el límit màxim per a el nom de la categoria.",
	'categoryselect-error-db-locked' => 'La base de dades està bloquejada.',
	'categoryselect-error-duplicate-category-name' => 'La categoria "$1" ja existeix.',
	'categoryselect-error-edit-abort' => 'La modificació que has intentat realitzar ha estat avortada per un problema de la extensió.',
	'categoryselect-error-empty-category-name' => 'Si us plau, indiqueu un nom de categoria.',
	'categoryselect-error-user-rights' => "L'usuari no té els permisos per realitzar aquesta acció.",
	'categoryselect-modal-category-name' => 'Proporciona el nom de la categoria:',
	'categoryselect-modal-category-sortkey' => 'Opcionalment, pots alfabetitzar aquesta pàgina en la categoria "$1" amb el nom:',
	'categoryselect-tooltip-add' => 'Pressiona Enter o Retrocés quan acabis.',
	'tog-disablecategoryselect' => "Desactivar el mòdul de categories (només s'aplica si l'edició en mode visual està desactivada).",
	'tog-disablecategoryselect-v2' => "Desactivar el mòdul de categories (només s'aplica si l'edició en mode visual està desactivada).",
);

/** Sorani Kurdish (کوردی)
 */
$messages['ckb'] = array(
	'categoryselect-button-save' => 'پاشەکەوت',
);

/** Czech (česky)
 * @author Chmee2
 * @author Darth Daron
 * @author Dontlietome7
 */
$messages['cs'] = array(
	'categoryselect-desc' => 'Poskytuje rozhraní pro správu kategorií v článku bez úprav celého článku',
	'categoryselect-button-add' => 'Přidat kategorii',
	'categoryselect-button-cancel' => 'Storno',
	'categoryselect-button-save' => 'Uložit',
	'categoryselect-category-add' => 'Přidat kategorii', # Fuzzy
	'categoryselect-category-edit' => 'Možnosti kategorie', # Fuzzy
	'categoryselect-category-remove' => 'Odstranit kategorii',
	'categoryselect-edit-summary' => 'Přidávání kategorií',
	'categoryselect-error-article-doesnt-exist' => 'Článek [id=$1] neexistuje.', # Fuzzy
	'categoryselect-error-db-locked' => 'Databáze je uzamčena.',
	'categoryselect-error-edit-abort' => 'Změna, o kterou jste se pokusili, byla zrušena rozšířením.', # Fuzzy
	'categoryselect-error-empty-category-name' => 'Zadejte název kategorie (část před |)', # Fuzzy
	'categoryselect-error-user-rights' => 'Chyba uživatelských práv.', # Fuzzy
	'categoryselect-modal-category-name' => 'Uveďte název kategorie:', # Fuzzy
	'categoryselect-modal-category-sortkey' => 'Abecedně seřadit tento článek na stránce kategorie „$1" pod názvem:', # Fuzzy
	'categoryselect-tooltip-add' => 'Po dokončení stiskněte Enter', # Fuzzy
	'tog-disablecategoryselect' => 'Zakázat značení kategorií (platné pouze, pokud bylo editování ve vizuálním režimu zakázáno)',
	'tog-disablecategoryselect-v2' => 'Zakázat modul kategorií (pouze pokud je zakázaný vizuální editor)',
);

/** German (Deutsch)
 * @author Arkondi
 * @author Avatar
 * @author Inkowik
 * @author Jan Luca
 * @author LWChris
 * @author Metalhead64
 * @author PtM
 */
$messages['de'] = array(
	'categoryselect-desc' => 'Stellt eine Oberfläche zur Verwaltung der Kategorien in einem Artikel ohne Bearbeitung des ganzen Artikels zur Verfügung.',
	'categoryselect-button-add' => 'Kategorie hinzufügen',
	'categoryselect-button-cancel' => 'Abbrechen',
	'categoryselect-button-save' => 'Speichern',
	'categoryselect-category-add' => 'Kategorie hinzufügen …',
	'categoryselect-category-edit' => 'Kategorie bearbeiten',
	'categoryselect-category-remove' => 'Kategorie entfernen',
	'categoryselect-edit-summary' => 'Kategorien hinzufügen',
	'categoryselect-error-article-doesnt-exist' => 'Der Artikel [id=$1] ist nicht vorhanden.',
	'categoryselect-error-category-name-length' => 'Die maximale Länge für einen Kategorienamen wurde erreicht.',
	'categoryselect-error-db-locked' => 'Die Datenbank ist vorübergehend gesperrt.',
	'categoryselect-error-duplicate-category-name' => 'Die Kategorie „$1“ ist bereits vorhanden.',
	'categoryselect-error-edit-abort' => 'Deine versuchte Änderung wurde durch eine Einschubmethode verhindert.',
	'categoryselect-error-empty-category-name' => 'Bitte gib einen Kategorienamen an.',
	'categoryselect-error-user-rights' => 'Der Benutzer hat zum Ausführen dieser Aktion keine Berechtigung.',
	'categoryselect-modal-category-name' => 'Gib den Namen der Kategorie an:',
	'categoryselect-modal-category-sortkey' => 'Optional kannst du diesen Artikel auf der Kategorieseite „$1“ unter folgendem Namen einordnen:',
	'categoryselect-tooltip-add' => 'Drück die Eingabetaste, wenn du fertig bist.',
	'tog-disablecategoryselect' => 'Kategorie-Modul ausschalten (greift nur, wenn das grafische Bearbeiten ausgeschaltet wurde)',
	'tog-disablecategoryselect-v2' => 'Kategorie-Modul deaktivieren (trifft nur zu, wenn der grafische Editor deaktiviert ist)',
);

/** German (formal address) (Deutsch (Sie-Form)‎)
 * @author LWChris
 */
$messages['de-formal'] = array(
	'categoryselect-error-edit-abort' => 'Ihre versuchte Änderung wurde durch ein Aufhängen einer Erweiterung abgebrochen', # Fuzzy
	'categoryselect-modal-category-name' => 'Geben Sie den Namen der Kategorie an:', # Fuzzy
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 * @author Mirzali
 */
$messages['diq'] = array(
	'categoryselect-button-cancel' => 'Bıtexelne',
	'categoryselect-button-save' => 'Star ke',
);

/** Greek (Ελληνικά)
 * @author Crazymadlover
 * @author Glavkos
 * @author Nikosguard
 */
$messages['el'] = array(
	'categoryselect-button-add' => 'Προσθήκη κατηγορίας',
	'categoryselect-button-cancel' => 'Ακύρωση',
	'categoryselect-button-save' => 'Αποθήκευση',
	'categoryselect-category-add' => 'Προσθήκη κατηγορίας...',
	'categoryselect-category-edit' => 'Επεξεργασία κατηγορίας',
	'categoryselect-error-db-locked' => 'Η βάση δεδομένων είναι κλειδωμένη',
	'categoryselect-modal-category-name' => 'Δώστε όνομα στην κατηγορία:',
	'categoryselect-tooltip-add' => 'Πιέστε το πλήκτρο Enter ή Return όταν γίνεται.',
);

/** British English (British English)
 * @author Shirayuki
 */
$messages['en-gb'] = array(
	'categoryselect-modal-category-sortkey' => 'Optionally, you may alphabetise this page on the "$1" category page under the name:',
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
	'categoryselect-button-add' => 'Añadir categoría',
	'categoryselect-button-cancel' => 'Cancelar',
	'categoryselect-button-save' => 'Guardar',
	'categoryselect-category-add' => 'Añadir una categoría...',
	'categoryselect-category-edit' => 'Editar categoría',
	'categoryselect-category-remove' => 'Eliminar categoría',
	'categoryselect-edit-summary' => 'Añadiendo categorías',
	'categoryselect-error-article-doesnt-exist' => 'El artículo [id=$1] no existe.',
	'categoryselect-error-category-name-length' => 'Se ha alcanzado el límite máximo para el nombre de la categoría.',
	'categoryselect-error-db-locked' => 'La base de datos está bloqueada.',
	'categoryselect-error-duplicate-category-name' => 'La categoría "$1" ya existe.',
	'categoryselect-error-edit-abort' => 'La modificación que has intentado realizar fue abortada por un problema de la extensión.',
	'categoryselect-error-empty-category-name' => 'Escribe un nombre de categoría.',
	'categoryselect-error-user-rights' => 'El usuario no tiene los permisos para realizar esta acción.',
	'categoryselect-modal-category-name' => 'Escribe el nombre de la categoría:',
	'categoryselect-modal-category-sortkey' => 'Opcionalmente, puedes afabetizar este artículo en la categoría "$1" con el nombre:',
	'categoryselect-tooltip-add' => 'Presiona Enter o Retroceso cuando termines.',
	'tog-disablecategoryselect' => 'Desactivar el módulo de categorías (sólo se aplica si la edición en modo visual está desactivada)',
	'tog-disablecategoryselect-v2' => 'Desactivar módulo de Categorías en el modo fuente',
);

/** Basque (euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'categoryselect-button-cancel' => 'Utzi',
	'categoryselect-button-save' => 'Gorde',
);

/** Persian (فارسی)
 * @author ZxxZxxZ
 * @author جواد
 */
$messages['fa'] = array(
	'categoryselect-button-add' => 'افزودن رده',
	'categoryselect-button-cancel' => 'لغو',
	'categoryselect-button-save' => 'ذخیره کردن',
	'categoryselect-category-edit' => 'ویرایش رده',
	'categoryselect-edit-summary' => 'افزودن رده',
	'categoryselect-tooltip-add' => 'پس از اتمام دکمه اینتر را فشار دهید', # Fuzzy
);

/** Finnish (suomi)
 * @author Crt
 * @author Ilkea
 * @author Nike
 * @author Tm T
 * @author Tofu II
 * @author VezonThunder
 */
$messages['fi'] = array(
	'categoryselect-desc' => 'Tarjoaa käyttöliittymän artikkelin luokkien hallitsemiselle ilman koko artikkelin muokkaamista',
	'categoryselect-button-add' => 'Lisää luokka',
	'categoryselect-button-cancel' => 'Peruuta',
	'categoryselect-button-save' => 'Tallenna',
	'categoryselect-category-add' => 'Lisää luokka...',
	'categoryselect-category-edit' => 'Muokkaa luokkaa',
	'categoryselect-edit-summary' => 'Luokkien lisääminen',
	'categoryselect-error-article-doesnt-exist' => 'Artikkelia [id=$1] ei ole olemassa.',
	'categoryselect-error-db-locked' => 'Tietokanta on lukittu.',
	'categoryselect-error-edit-abort' => 'Laajennus esti tekemäsi muutoksen tallentamisen',
	'categoryselect-error-empty-category-name' => 'Syötä luokan nimi.',
	'categoryselect-error-user-rights' => 'Käyttöoikeusvirhe.', # Fuzzy
	'categoryselect-modal-category-name' => 'Luokan nimi:',
	'categoryselect-modal-category-sortkey' => 'Voit myös aakkostaa tämä artikkelin luokassa $1 tällä nimellä:',
	'categoryselect-tooltip-add' => 'Paina Enter, kun olet valmis.',
	'tog-disablecategoryselect' => 'Poista luokkamoduuli käytöstä (koskee vain, jos visuaalisessa tilassa muokkaaminen on poistettu käytöstä)',
	'tog-disablecategoryselect-v2' => 'Poista luokkamoduuli käytöstä (koskee vain jos visuaalinen muokkaus on poistettu käytöstä)',
);

/** Faroese (føroyskt)
 * @author EileenSanda
 */
$messages['fo'] = array(
	'categoryselect-desc' => 'Veitir eitt markamót (interface) til stýring av bólkum á einari síðu, uttan at rætta eina heila síðu',
	'categoryselect-button-add' => 'Legg afturat ein bólk',
	'categoryselect-button-cancel' => 'Angra',
	'categoryselect-button-save' => 'Goym',
	'categoryselect-category-add' => 'Legg afturat bólk...',
	'categoryselect-category-edit' => 'Rætta bólk',
	'categoryselect-category-remove' => 'Tak burtur bólk',
	'categoryselect-edit-summary' => 'Legg bólkar afturat',
	'categoryselect-error-article-doesnt-exist' => 'Síðan [id=$1] er ikki til.',
	'categoryselect-error-category-name-length' => 'Maksimala longdin fyri eitt bólkanavn er nádd.',
	'categoryselect-error-db-locked' => 'Dátagrunnurin er stongdur.',
	'categoryselect-error-duplicate-category-name' => 'Bólkurin "$1" er longu til.',
);

/** French (français)
 * @author Gomoko
 * @author IAlex
 * @author Peter17
 * @author Wyz
 */
$messages['fr'] = array(
	'categoryselect-desc' => "Fournit une interface permettant de gérer les catégories d'un article sans avoir à modifier tout l'article.",
	'categoryselect-button-add' => 'Ajouter des catégories',
	'categoryselect-button-cancel' => 'Annuler',
	'categoryselect-button-save' => 'Enregistrer',
	'categoryselect-category-add' => 'Ajouter une catégorie…',
	'categoryselect-category-edit' => 'Modifier la catégorie',
	'categoryselect-category-remove' => 'Retirer catégorie',
	'categoryselect-edit-summary' => 'Ajout de catégories',
	'categoryselect-error-article-doesnt-exist' => 'L’article [id=$1] n’existe pas.',
	'categoryselect-error-category-name-length' => 'La taille maximale pour un nom de catégorie a été atteinte.',
	'categoryselect-error-db-locked' => 'La base de données est verrouillée.',
	'categoryselect-error-duplicate-category-name' => 'La catégorie « $1 » existe déjà.',
	'categoryselect-error-edit-abort' => 'Les modifications que vous avez essayé d’effectuer on été annulées par un point d’extension.',
	'categoryselect-error-empty-category-name' => 'Veuillez indiquer un nom de catégorie.',
	'categoryselect-error-user-rights' => 'Vous n’avez pas les droits pour ajouter des catégories à cette page.',
	'categoryselect-modal-category-name' => 'Indiquez le nom de la catégorie :',
	'categoryselect-modal-category-sortkey' => 'Vous pouvez trier cet article par ordre alphabétique sur la page de la catégorie « $1 » sous le nom (facultatif) :',
	'categoryselect-tooltip-add' => 'Appuyez sur la touche Entrée ou Retour une fois terminé.',
	'tog-disablecategoryselect' => "Désactiver le module des catégories (valable uniquement si l'édition en mode visuel a été désactivée)",
	'tog-disablecategoryselect-v2' => "Désactiver le module Catégorie (s'applique uniquement si le mode d'édition visuelle est désactivé)",
);

/** Galician (galego)
 * @author Toliño
 * @author Vivaelcelta
 */
$messages['gl'] = array(
	'categoryselect-desc' => 'Proporciona unha interface para xestionar as categorías dos artigos sen editar todo o artigo.',
	'categoryselect-button-add' => 'Engadir a categoría',
	'categoryselect-button-cancel' => 'Cancelar',
	'categoryselect-button-save' => 'Gardar',
	'categoryselect-category-add' => 'Engadir unha categoría...',
	'categoryselect-category-edit' => 'Editar a categoría',
	'categoryselect-category-remove' => 'Eliminar a categoría',
	'categoryselect-edit-summary' => 'Inserción de categorías',
	'categoryselect-error-article-doesnt-exist' => 'O artigo [id=$1] non existe.',
	'categoryselect-error-category-name-length' => 'Atinxiuse a lonxitude máxima para o nome das categorías.',
	'categoryselect-error-db-locked' => 'A base de datos está bloqueada.',
	'categoryselect-error-duplicate-category-name' => 'A categoría "$1" xa existe.',
	'categoryselect-error-edit-abort' => 'O asociador da extensión abortou a modificación que intentou realizar.',
	'categoryselect-error-empty-category-name' => 'Dea o nome da categoría.',
	'categoryselect-error-user-rights' => 'O usuario non ten os permisos necesarios para levar a cabo esta acción.',
	'categoryselect-modal-category-name' => 'Escriba o nome da categoría:',
	'categoryselect-modal-category-sortkey' => 'Opcionalmente, pode clasificar alfabeticamente este artigo na categoría "$1" co nome:',
	'categoryselect-tooltip-add' => 'Prema a tecla Intro ou Retroceso cando remate.',
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
	'categoryselect-button-add' => 'Kategória hozzáadása',
	'categoryselect-button-cancel' => 'Mégse',
	'categoryselect-button-save' => 'Mentés',
	'categoryselect-category-add' => 'Kategória hozzáadása',
	'categoryselect-category-edit' => 'Kategória szerkesztése',
	'categoryselect-category-remove' => 'Kategória eltávolítása',
	'categoryselect-edit-summary' => 'Kategóriák hozzáadása',
	'categoryselect-error-article-doesnt-exist' => 'A(z) [id=$1] lap nem létezik.',
	'categoryselect-error-category-name-length' => 'Túllépted a kategória nevének maximálisan megengedhető hosszát.',
	'categoryselect-error-db-locked' => 'Az adatbázis zárolva.',
	'categoryselect-error-duplicate-category-name' => 'A(z) "$1 kategória már létezik.',
	'categoryselect-error-edit-abort' => 'Az általad kezdeményezett módosítást megakadályozta egy bővítmény hook-ja.',
	'categoryselect-error-empty-category-name' => 'Kérlek, add meg egy kategória nevét.',
	'categoryselect-error-user-rights' => 'A felhasználó nem jogosult ezen művelet végrehajtására.',
	'categoryselect-modal-category-name' => 'Add meg a kategória nevét:',
	'categoryselect-modal-category-sortkey' => 'A szócikk ábécérendbe sorolása az "$1" kategóriában az alábbi név szerint:', # Fuzzy
	'categoryselect-tooltip-add' => 'Nyomd le az Entert vagy a Return-t, ha kész vagy',
	'tog-disablecategoryselect' => 'Kategóriamodul letiltása (csak a vizuális módban való szerkesztés kikapcsolása esetén érvényes)',
	'tog-disablecategoryselect-v2' => 'Kategóriamodul letiltása (csak a vizuális mód kikapcsolása esetén érvényes)',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'categoryselect-desc' => 'Provide un interfacie pro gerer le categorias in un articulo sin modificar tote le articulo.',
	'categoryselect-button-add' => 'Adder categoria',
	'categoryselect-button-cancel' => 'Cancellar',
	'categoryselect-button-save' => 'Salveguardar',
	'categoryselect-category-add' => 'Adder un categoria', # Fuzzy
	'categoryselect-category-edit' => 'Optiones de categoria', # Fuzzy
	'categoryselect-edit-summary' => 'Addition de categorias…',
	'categoryselect-error-article-doesnt-exist' => 'Le articulo [id=$1] non existe.', # Fuzzy
	'categoryselect-error-db-locked' => 'Le base de datos es blocate.',
	'categoryselect-error-edit-abort' => 'Le modification que tu tentava facer ha essite abortate per un extension.', # Fuzzy
	'categoryselect-error-empty-category-name' => 'Entra le nomine del categoria (le parte ante "|")', # Fuzzy
	'categoryselect-error-user-rights' => 'Error de derectos de usator.', # Fuzzy
	'categoryselect-modal-category-name' => 'Entra le nomine del categoria:', # Fuzzy
	'categoryselect-modal-category-sortkey' => 'Alphabetisar iste articulo in le categoria "$1" sub le nomine:', # Fuzzy
	'categoryselect-tooltip-add' => 'Preme Enter pro finir', # Fuzzy
	'tog-disablecategoryselect' => 'Disactivar le modulo Categoria (applicabile solmente si le modification in modo visual ha essite disactivate)',
	'tog-disablecategoryselect-v2' => 'Disactivar le modulo Categoria (applicabile solmente si le modification in modo visual es disactivate)',
);

/** Indonesian (Bahasa Indonesia)
 * @author Aldnonymous
 * @author C5st4wr6ch
 * @author Irwangatot
 */
$messages['id'] = array(
	'categoryselect-desc' => 'Menyediakan sebuah antarmuka untuk mengelola kategori dalam artikel tanpa mengedit seluruh artikel.',
	'categoryselect-button-add' => 'Menambah kategori',
	'categoryselect-button-cancel' => 'Batalkan',
	'categoryselect-button-save' => 'Simpan',
	'categoryselect-category-add' => 'Menambahkan kategori', # Fuzzy
	'categoryselect-category-edit' => 'Sunting kategori',
	'categoryselect-category-remove' => 'Menghapus kategori',
	'categoryselect-edit-summary' => 'Menambahkan kategori',
	'categoryselect-error-article-doesnt-exist' => 'Halaman [id=$1] tidak ada.',
	'categoryselect-error-db-locked' => 'Basis data dikunci.',
	'categoryselect-error-duplicate-category-name' => 'Kategori "$1" sudah ada.',
	'categoryselect-error-edit-abort' => 'Perubahan yang coba Anda lakukan dibatalkan oleh suatu ekstensi kaitan.', # Fuzzy
	'categoryselect-error-empty-category-name' => 'Silakan berikan nama kategori.',
	'categoryselect-error-user-rights' => 'Pengguna tidak memiliki izin untuk melakukan aksi ini.',
	'categoryselect-modal-category-name' => 'Menyediakan nama kategori:',
	'categoryselect-modal-category-sortkey' => 'Penyusunan artikel ini menurut abjad pada kategori "$1" dengan nama:', # Fuzzy
	'categoryselect-tooltip-add' => 'Tekan tombol Masuk atau Kembali ketika sudah selesai.',
	'tog-disablecategoryselect' => 'Nonaktifkan Kategori Tagging( hanya berlaku jika modus visual telah dinonaktifkan)',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'categoryselect-button-cancel' => 'Emekwàlà',
	'categoryselect-button-save' => 'Domá',
);

/** Italian (italiano)
 * @author Beta16
 * @author Leviathan 89
 * @author Minerva Titani
 * @author RickyB98
 * @author Ximo17
 */
$messages['it'] = array(
	'categoryselect-desc' => "Fornisce un'interfaccia per la gestione delle categorie negli articoli senza modificare l'intera pagina",
	'categoryselect-button-add' => 'Aggiungi categoria',
	'categoryselect-button-cancel' => 'Annulla',
	'categoryselect-button-save' => 'Salva',
	'categoryselect-category-add' => 'Aggiungi una categoria...',
	'categoryselect-category-edit' => 'Modifica categoria',
	'categoryselect-category-remove' => 'Elimina categoria',
	'categoryselect-edit-summary' => 'Categorie aggiunte',
	'categoryselect-error-article-doesnt-exist' => "L'articolo [id=$1] non esiste.",
	'categoryselect-error-category-name-length' => 'È stato raggiunto il limite di lunghezza per il nome di una categoria.',
	'categoryselect-error-db-locked' => 'Database bloccato.',
	'categoryselect-error-duplicate-category-name' => 'La categoria "$1" esiste già.',
	'categoryselect-error-edit-abort' => "La modifica che si sta tentando di fare è stata interrotta da un problema dell'estensione",
	'categoryselect-error-empty-category-name' => 'Fornire il nome della categoria (parte prima di |)',
	'categoryselect-error-user-rights' => "Errore nei diritti dell'utente.",
	'categoryselect-modal-category-name' => 'Fornire il nome della categoria:',
	'categoryselect-modal-category-sortkey' => 'Alfabetizzare questo articolo nella categoria "$1" sotto il nome:', # Fuzzy
	'categoryselect-tooltip-add' => 'Premi INVIO quando hai fatto',
	'tog-disablecategoryselect' => 'Disabilita il modulo Categoria (si applica solo se la modifica in modalità visuale è stata disabilitata)',
	'tog-disablecategoryselect-v2' => 'Disabilita il modulo Categoria (si applica solo se la modifica in modalità visuale è disabilitata)',
);

/** Japanese (日本語)
 * @author Shirayuki
 * @author Tommy6
 * @author 아라
 */
$messages['ja'] = array(
	'categoryselect-desc' => '記事を編集することなくカテゴリを操作するためのインターフェースを提供する',
	'categoryselect-button-add' => 'カテゴリを追加',
	'categoryselect-button-cancel' => '取り消し',
	'categoryselect-button-save' => '保存',
	'categoryselect-category-add' => 'カテゴリを追加', # Fuzzy
	'categoryselect-category-edit' => 'カテゴリのオプション', # Fuzzy
	'categoryselect-edit-summary' => 'カテゴリを追加',
	'categoryselect-error-article-doesnt-exist' => '記事 [id=$1] は存在しません。',
	'categoryselect-error-db-locked' => 'データベースがロックされています',
	'categoryselect-error-edit-abort' => '拡張機能のフックによって、修正が中断されました', # Fuzzy
	'categoryselect-error-empty-category-name' => 'カテゴリ名を入力（"|"より前の部分）', # Fuzzy
	'categoryselect-error-user-rights' => '利用者権限のエラーです。', # Fuzzy
	'categoryselect-modal-category-name' => 'カテゴリ名を入力', # Fuzzy
	'categoryselect-modal-category-sortkey' => '"$1"カテゴリで記事のソートに使用する名前を入力', # Fuzzy
	'categoryselect-tooltip-add' => 'エンターキーを押すと終了', # Fuzzy
	'tog-disablecategoryselect' => 'カテゴリタグ付け機能を無効にする（ビジュアルモードでの編集を無効にしている場合にのみ適用）',
	'tog-disablecategoryselect-v2' => 'カテゴリモジュールを無効にする（ビジュアルモードでの編集を無効にしている場合にのみ適用）',
);

/** Georgian (ქართული)
 * @author DevaMK
 */
$messages['ka'] = array(
	'categoryselect-button-add' => 'დაამატე კატეგორია',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'categoryselect-button-cancel' => 'ರದ್ದು ಮಾಡು',
	'categoryselect-button-save' => 'ಉಳಿಸಿ',
);

/** Korean (한국어)
 * @author Cafeinlove
 * @author 아라
 */
$messages['ko'] = array(
	'categoryselect-desc' => '전체 문서를 편집하지 않고 문서에 분류를 관리하기 위한 인터페이스를 제공합니다',
	'categoryselect-button-add' => '분류 추가',
	'categoryselect-button-cancel' => '취소',
	'categoryselect-button-save' => '저장',
	'categoryselect-category-add' => '분류 추가...',
	'categoryselect-category-edit' => '분류 편집',
	'categoryselect-category-remove' => '분류 제거',
	'categoryselect-edit-summary' => '분류 추가',
	'categoryselect-error-article-doesnt-exist' => '[id=$1] 문서가 존재하지 않습니다.',
	'categoryselect-error-category-name-length' => '분류 이름에 대한 최대 길이에 도달했습니다.',
	'categoryselect-error-db-locked' => '데이터베이스가 잠겨 있습니다.',
	'categoryselect-error-duplicate-category-name' => '"$1" 분류가 이미 존재합니다.',
	'categoryselect-error-edit-abort' => '수정하려고 한 것이 확장 기능 훅에 의해 중지되었습니다.',
	'categoryselect-error-empty-category-name' => '분류 이름을 제공하세요.',
	'categoryselect-error-user-rights' => '사용자는 이 작업을 수행할 권한이 없습니다.',
	'categoryselect-modal-category-name' => '분류의 이름 제공:',
	'categoryselect-modal-category-sortkey' => '선택적으로 이름에 따라 "$1" 분류 문서에 이 문서를 알파벳순으로 정렬할 수 있습니다:',
);

/** Kurdish (Latin script) (Kurdî (latînî)‎)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'categoryselect-button-cancel' => 'Betal bike',
	'categoryselect-button-save' => 'Tomar bike',
	'categoryselect-category-remove' => 'Kategoriyê jê bibe',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'categoryselect-button-add' => 'Kategorie derbäisetzen',
	'categoryselect-button-cancel' => 'Ofbriechen',
	'categoryselect-button-save' => 'Späicheren',
	'categoryselect-category-add' => 'Kategorie derbäisetzen...',
	'categoryselect-category-edit' => 'Kategorie änneren',
	'categoryselect-category-remove' => 'Kategorie ewechhuelen',
	'categoryselect-edit-summary' => 'Kategorien derbäisetzen',
	'categoryselect-error-article-doesnt-exist' => "D'Säit [id=$1] gëtt et net.",
	'categoryselect-error-db-locked' => "D'Datebank ass gespaart.",
	'categoryselect-error-duplicate-category-name' => 'D\'Kategorie "$1" gëtt et schonn.',
	'categoryselect-error-user-rights' => "De Benotzer huet net d'Rechter fir dës Aktioun ze maachen.",
	'categoryselect-tooltip-add' => "Dréckt 'Enter' oder 'Return' wann Dir fäerdeg sidd",
);

/** Lithuanian (lietuvių)
 * @author Eitvys200
 */
$messages['lt'] = array(
	'categoryselect-button-add' => 'Pridėti kategoriją',
	'categoryselect-button-cancel' => 'Atšaukti',
	'categoryselect-button-save' => 'Išsaugoti',
	'categoryselect-category-add' => 'Pridėti kategoriją', # Fuzzy
	'categoryselect-category-edit' => 'Kategorijos nustatymai', # Fuzzy
	'categoryselect-error-article-doesnt-exist' => 'Straipsnis [id = $1 ] neegzistuoja.', # Fuzzy
	'categoryselect-error-db-locked' => 'Duomenų bazė užrakinta.',
	'categoryselect-error-user-rights' => 'Vartotojo teisių klaida.', # Fuzzy
	'categoryselect-tooltip-add' => 'Baigę paspauskite Enter', # Fuzzy
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'categoryselect-desc' => 'Дава посредник за раководење со категориите во една статија без да треба да се уредува целата статија.',
	'categoryselect-button-add' => 'Додај категорија',
	'categoryselect-button-cancel' => 'Откажи',
	'categoryselect-button-save' => 'Зачувај',
	'categoryselect-category-add' => 'Додај категорија...',
	'categoryselect-category-edit' => 'Уреди категорија',
	'categoryselect-category-remove' => 'Отстрани категорија',
	'categoryselect-edit-summary' => 'Додавање на категории',
	'categoryselect-error-article-doesnt-exist' => 'Статијата [id=$1] не постои.',
	'categoryselect-error-category-name-length' => 'Ја достигнавте максималната должина за име на категорија.',
	'categoryselect-error-db-locked' => 'Базата на податоци е заклучена.',
	'categoryselect-error-duplicate-category-name' => 'Категоријата „$1“ веќе постои.',
	'categoryselect-error-edit-abort' => 'Измените кои се обидовте да ги направите се откажани од кука за додатоци.',
	'categoryselect-error-empty-category-name' => 'Наведете има на категоријата.',
	'categoryselect-error-user-rights' => 'Корисникот нема дозвола за ова дејство.',
	'categoryselect-modal-category-name' => 'Наведете го името на категоријата:',
	'categoryselect-modal-category-sortkey' => 'Можете и азбучно да ја заведете статијава во категоријата „$1“ под името:',
	'categoryselect-tooltip-add' => 'Пристиснете Enter или Return кога сте готови',
	'tog-disablecategoryselect' => 'Оневозможи го модулот за категории (важи само кога е оневозможено уредувањето во режимот „Визуелно“)',
	'tog-disablecategoryselect-v2' => 'Оневозможи го категорискиот модул (важи само ако е оневозможен визуелниот режим)',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'categoryselect-button-add' => 'വർഗ്ഗം ചേർക്കുക',
	'categoryselect-button-cancel' => 'റദ്ദാക്കുക',
	'categoryselect-button-save' => 'സേവ് ചെയ്യുക',
	'categoryselect-category-edit' => 'വർഗ്ഗത്തിലെ ഐച്ഛികങ്ങൾ', # Fuzzy
	'categoryselect-error-article-doesnt-exist' => 'ലേഖനം [id=$1] നിലവിലില്ല.', # Fuzzy
	'categoryselect-tooltip-add' => 'പൂർത്തിയാകുമ്പോൾ എന്റർ അമർത്തുക', # Fuzzy
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
	'categoryselect-button-add' => 'Tambahkan kategori',
	'categoryselect-button-cancel' => 'Batalkan',
	'categoryselect-button-save' => 'Simpan',
	'categoryselect-category-add' => 'Tambahkan kategori...',
	'categoryselect-category-edit' => 'Sunting kategori',
	'categoryselect-category-remove' => 'Buang kategori',
	'categoryselect-edit-summary' => 'Menambahkan kategori',
	'categoryselect-error-article-doesnt-exist' => 'Rencana [id=$1] tidak wujud.',
	'categoryselect-error-category-name-length' => 'Kepanjangan maksimum nama kategori telah dicapai.',
	'categoryselect-error-db-locked' => 'Pangkalan data dikunci.',
	'categoryselect-error-duplicate-category-name' => 'Kategori "$1" sudah wujud.',
	'categoryselect-error-edit-abort' => 'Pengubahsuaian yang telah anda cuba buat telah dipaksa henti oleh cangkuk sambungan.',
	'categoryselect-error-empty-category-name' => 'Sila berikan nama kategori.',
	'categoryselect-error-user-rights' => 'Pengguna tidak dibenarkan untuk melakukan tindakan ini.',
	'categoryselect-modal-category-name' => 'Berikan nama kategori:',
	'categoryselect-modal-category-sortkey' => 'Anda juga boleh menyusun rencana ini mengikut turutan abjat pada halaman kategori "$1" di bawah nama:',
	'categoryselect-tooltip-add' => 'Tekan kekunci Enter apabila selesai.',
	'tog-disablecategoryselect' => 'Matikan modul Kategori (hanya jika tidak boleh menyunting dalam mod visual)',
	'tog-disablecategoryselect-v2' => 'Matikan modul Kategori (hanya jika mod penyuntingan visual dimatikan)',
);

/** Norwegian Bokmål (norsk bokmål)
 * @author Audun
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'categoryselect-desc' => 'Tilbyr et grensesnitt for håndtering av kategorier i artikler uten å redigere hele artikkelen.',
	'categoryselect-button-add' => 'Legg til kategori',
	'categoryselect-button-cancel' => 'Avbryt',
	'categoryselect-button-save' => 'Lagre',
	'categoryselect-category-add' => 'Legg til en kategori...',
	'categoryselect-category-edit' => 'Rediger kategori',
	'categoryselect-category-remove' => 'Fjern kategori',
	'categoryselect-edit-summary' => 'Legger til kategorier',
	'categoryselect-error-article-doesnt-exist' => 'Siden [id=$1] finnes ikke.',
	'categoryselect-error-category-name-length' => 'Den maksimale lengden for et kategorinavn er nådd.',
	'categoryselect-error-db-locked' => 'Database er låst.',
	'categoryselect-error-duplicate-category-name' => 'Kategorien «$1» finnes allerede.',
	'categoryselect-error-edit-abort' => 'Endringene du prøvde å utføre ble avbrutt av en utvidelseskrok.',
	'categoryselect-error-empty-category-name' => 'Angi et kategorinavn.',
	'categoryselect-error-user-rights' => 'Brukeren har ikke tillatelse til å utføre denne handlingen.',
	'categoryselect-modal-category-name' => 'Oppgi navnet på kategorien:',
	'categoryselect-modal-category-sortkey' => 'Alternativt kan du alfabetisere denne siden under kategorisiden «$1» under navnet:',
	'categoryselect-tooltip-add' => 'Trykk på Enter- eller Linjeskift-tasten når du er ferdig.',
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
	'categoryselect-button-add' => 'Categorie toevoegen',
	'categoryselect-button-cancel' => 'Annuleren',
	'categoryselect-button-save' => 'Opslaan',
	'categoryselect-category-add' => 'Categorie toevoegen...',
	'categoryselect-category-edit' => 'Categorie bewerken',
	'categoryselect-category-remove' => 'Categorie verwijderen',
	'categoryselect-edit-summary' => 'Bezig met het toevoegen van categorieën',
	'categoryselect-error-article-doesnt-exist' => 'De pagina [id=$1] bestaat niet.',
	'categoryselect-error-category-name-length' => 'De maximale lengte voor een categorienaam is bereikt.',
	'categoryselect-error-db-locked' => 'De database is geblokkeerd.',
	'categoryselect-error-duplicate-category-name' => 'De categorie "$1" bestaat al.',
	'categoryselect-error-edit-abort' => 'De wijzigingen die u probeerde te maken zijn afgebroken door een uitbreidingshook.',
	'categoryselect-error-empty-category-name' => 'Geef de categorienaam op.',
	'categoryselect-error-user-rights' => 'De gebruiker geeft geen rechten om deze handeling uit te voeren.',
	'categoryselect-modal-category-name' => 'Geef de naam van de categorie op:',
	'categoryselect-modal-category-sortkey' => 'U kunt deze pagina ook in de categoriepagina "$1" ordenen onder de naam:',
	'categoryselect-tooltip-add' => 'Druk "Enter" of "Return" als u klaar bent.',
	'tog-disablecategoryselect' => 'Categoriemodule uitschakelen (alleen van toepassing als bewerken in visuele modus is uitgeschakeld)',
	'tog-disablecategoryselect-v2' => 'Categoriemodule uitschakelen (alleen van toepassing als de visuele tekstverwerker is uitgeschakeld)',
);

/** Nederlands (informeel)‎ (Nederlands (informeel)‎)
 * @author Siebrand
 */
$messages['nl-informal'] = array(
	'categoryselect-error-edit-abort' => 'De wijziging die je probeerde te maken is afgebroken door een uitbreidingshook', # Fuzzy
);

/** Oriya (ଓଡ଼ିଆ)
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
	'categoryselect-button-cancel' => 'Uffhere',
	'categoryselect-button-save' => 'Schbaischare',
);

/** Polish (polski)
 * @author BeginaFelicysym
 * @author Sovq
 */
$messages['pl'] = array(
	'categoryselect-desc' => 'Umożliwia zarządzanie kategoriami bez potrzeby edytowania całego artykułu',
	'categoryselect-button-add' => 'Dodaj kategorię',
	'categoryselect-button-cancel' => 'Anuluj',
	'categoryselect-button-save' => 'Zapisz',
	'categoryselect-category-add' => 'Dodaj kategorię...',
	'categoryselect-category-edit' => 'Edycja kategorii',
	'categoryselect-category-remove' => 'Usuwanie kategorii',
	'categoryselect-edit-summary' => 'Dodawanie kategorii',
	'categoryselect-error-article-doesnt-exist' => 'Artykuł [id=$1] nie istnieje.',
	'categoryselect-error-category-name-length' => 'Osiągnięto maksymalną długość nazwy kategorii.',
	'categoryselect-error-db-locked' => 'Baza danych jest zablokowana',
	'categoryselect-error-duplicate-category-name' => 'Kategoria "$1" już istnieje.',
	'categoryselect-error-edit-abort' => 'Zmiany, które próbowano wprowadzić zostały anulowane przez inne rozszerzenie.',
	'categoryselect-error-empty-category-name' => 'Podaj nazwę kategorii',
	'categoryselect-error-user-rights' => 'Błąd uprawnień użytkownika.',
	'categoryselect-modal-category-name' => 'Podaj nazwę kategorii:',
	'categoryselect-modal-category-sortkey' => 'Umieść artykuł na alfabetycznej liście kategorii "$1" pod nazwą:',
	'categoryselect-tooltip-add' => 'Zatwierdź wciskając Enter.',
	'tog-disablecategoryselect' => 'Wyłącz dodawanie kategorii',
	'tog-disablecategoryselect-v2' => 'Wyłącz dodawanie kategorii w trybie źródłowym',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'categoryselect-desc' => "A dà n'antërfacia për gestì categorìe ant j'artìcoj sensa modifiché tut l'artìcol.",
	'categoryselect-button-add' => 'Gionta categorìa',
	'categoryselect-button-cancel' => 'Scancelé',
	'categoryselect-button-save' => 'Salva',
	'categoryselect-category-add' => 'Gionta na categorìa', # Fuzzy
	'categoryselect-category-edit' => 'Opsion ëd categorìa', # Fuzzy
	'categoryselect-edit-summary' => 'Gionté categorìe',
	'categoryselect-error-article-doesnt-exist' => "L'artìcol [id=$1] a esist pa.", # Fuzzy
	'categoryselect-error-db-locked' => "La base ëd dàit a l'é blocà.",
	'categoryselect-error-edit-abort' => "La modìfica ch'it l'has provà a fé a l'é stàita abortìa da n'agancc ëd n'estension", # Fuzzy
	'categoryselect-error-empty-category-name' => 'Dé nòm a la categorìa (part prima |)', # Fuzzy
	'categoryselect-error-user-rights' => "Eror dij drit dj'utent.", # Fuzzy
	'categoryselect-modal-category-name' => 'Dà ël nòm ëd la categorìa', # Fuzzy
	'categoryselect-modal-category-sortkey' => 'Buté st\'artìcol-sì ant la pàgina ëd categorìa "$1" an órdin alfabétich sota ël nòm:', # Fuzzy
	'categoryselect-tooltip-add' => 'Sgnaché su Mandé quand fàit', # Fuzzy
	'tog-disablecategoryselect' => "Disabilité ël mòdul dle categorìe (a s'àplica mach se ël modifiché an manera visual a l'é stàit disabilità)",
	'tog-disablecategoryselect-v2' => "Disabilité ël mòdul Categorìa (a s'àplica mach se l'edission an manera visual a l'é disabilità)",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'categoryselect-button-add' => 'وېشنيزه ورګډول',
	'categoryselect-button-cancel' => 'ناگارل',
	'categoryselect-button-save' => 'خوندي کول',
	'categoryselect-category-add' => 'وېشنيزه ورگډول...',
	'categoryselect-category-edit' => 'وېشنيزه سمول',
	'categoryselect-category-remove' => 'وېشنيزه غورځول',
	'categoryselect-edit-summary' => 'وېشنيزې ورگډول',
	'categoryselect-error-article-doesnt-exist' => 'د [id=$1] ليکنه نشته.',
	'categoryselect-error-db-locked' => 'توکبنسټ تړل شوی.',
	'categoryselect-error-duplicate-category-name' => 'د "$1" وېشنيزه له پخوا څخه شته.',
	'categoryselect-error-empty-category-name' => 'لطفاً د يوې وېشنيزې نوم ورکړۍ.',
	'categoryselect-modal-category-name' => 'لطفاً د وېشنيزې نوم ورکړۍ.',
);

/** Portuguese (português)
 * @author Hamilton Abreu
 * @author Luckas
 * @author Malafaya
 * @author Pttraduc
 * @author SandroHc
 */
$messages['pt'] = array(
	'categoryselect-desc' => 'Fornece uma interface de gestão das categorias de um artigo sem editar o artigo completo.',
	'categoryselect-button-add' => 'Adicionar categoria',
	'categoryselect-button-cancel' => 'Cancelar',
	'categoryselect-button-save' => 'Salvar',
	'categoryselect-category-add' => 'Adicionar categoria...',
	'categoryselect-category-edit' => 'Editar categoria',
	'categoryselect-category-remove' => 'Remover categoria',
	'categoryselect-edit-summary' => 'A adicionar categorias',
	'categoryselect-error-article-doesnt-exist' => 'A página [id=$1] não existe.',
	'categoryselect-error-db-locked' => 'A base de dados está trancada.',
	'categoryselect-error-duplicate-category-name' => 'A categoria "$1" já existe.',
	'categoryselect-error-edit-abort' => 'A alteração que tentou fazer foi abortada pelo hook de uma extensão', # Fuzzy
	'categoryselect-error-empty-category-name' => 'Introduza o nome da categoria (a parte antes de |)', # Fuzzy
	'categoryselect-error-user-rights' => 'Erro de permissões.', # Fuzzy
	'categoryselect-modal-category-name' => 'Escreva o nome da categoria:',
	'categoryselect-modal-category-sortkey' => 'Na página da categoria "$1", listar esta página na posição do nome:', # Fuzzy
	'categoryselect-tooltip-add' => 'Pressione Enter quando tiver acabado', # Fuzzy
	'tog-disablecategoryselect' => 'Desligar o módulo de Categorias (aplica-se apenas se a edição em modo visual tiver sido desativada)',
	'tog-disablecategoryselect-v2' => 'Desligar o módulo de Categorias (aplica-se apenas se a edição em modo visual estiver desativada)',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Aristóbulo
 * @author Giro720
 * @author JM Pessanha
 * @author Jesielt
 * @author TheGabrielZaum
 * @author 555
 */
$messages['pt-br'] = array(
	'categoryselect-desc' => 'Disponibiliza uma interface para a administração de categorias de uma página sem que seja necessário editá-lo por inteiro',
	'categoryselect-button-add' => 'Adicionar categoria',
	'categoryselect-button-cancel' => 'Cancelar',
	'categoryselect-button-save' => 'Salvar',
	'categoryselect-category-add' => 'Adicionar categoria...',
	'categoryselect-category-edit' => 'Editar categoria',
	'categoryselect-category-remove' => 'Remover categoria',
	'categoryselect-edit-summary' => 'Adicionando categorias',
	'categoryselect-error-article-doesnt-exist' => 'O artigo [id=$1] não existe.',
	'categoryselect-error-category-name-length' => 'Atingiu-se o comprimento máximo para um nome de categoria.',
	'categoryselect-error-db-locked' => 'O banco de dados está bloqueado.',
	'categoryselect-error-duplicate-category-name' => 'A categoria "$1" já existe.',
	'categoryselect-error-edit-abort' => 'As mudanças que você tentou fazer foram abortadas por um anzol de extensão.',
	'categoryselect-error-empty-category-name' => 'Por favor forneça um nome para a categoria.',
	'categoryselect-error-user-rights' => 'O usuário não têm permissão para realizar esta ação.',
	'categoryselect-modal-category-name' => 'Escreva o nome da categoria:',
	'categoryselect-modal-category-sortkey' => 'Opcionalmente, você pode alfabetizar esta página na página da categoria "$1" sob o nome:',
	'categoryselect-tooltip-add' => 'Pressione a tecla Enter ou Return quando pronto.',
	'tog-disablecategoryselect' => 'Desabilitar o módulo de categorias (apenas aplicado caso a edição em modo visual foi desabilitada)',
	'tog-disablecategoryselect-v2' => 'Desativar o módulo de Categorias (aplicado apenas se o Modo Visual está desativado)',
);

/** Romanian (română)
 * @author Minisarm
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'categoryselect-button-cancel' => 'Renunţă',
	'categoryselect-button-save' => 'Salvează',
	'categoryselect-category-edit' => 'Modifică categoria',
	'categoryselect-error-db-locked' => 'Baza de date este blocată.',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'categoryselect-desc' => "Dèje 'n'inderfacce pa gestione de le categorije jndr'à 'na pàgene senze ca cange 'a pàgena stesse",
	'categoryselect-button-add' => "Aggiunge 'na categorije",
	'categoryselect-button-cancel' => 'Annulle',
	'categoryselect-button-save' => 'Reggìstre',
	'categoryselect-category-add' => "Aggiunge 'na categorije ...",
	'categoryselect-category-edit' => "Cange 'a categorije",
	'categoryselect-category-remove' => "Live 'a categorije",
	'categoryselect-edit-summary' => 'Categorije aggiunde',
	'categoryselect-error-article-doesnt-exist' => "'A pàgene [id=$1] non g'esiste.",
	'categoryselect-error-category-name-length' => "'A lunghezza massime pe 'na categorije ha state raggiunde.",
	'categoryselect-error-db-locked' => 'Archivije bloccate.',
	'categoryselect-error-duplicate-category-name' => 'Categorije "$1" già esiste.',
	'categoryselect-error-edit-abort' => "Le cangiaminde ca tu è pruvate a fà avènene annullate da 'u gance de estenzione.",
	'categoryselect-error-empty-category-name' => "Pe piacere dèje 'nu nome 'a categorije.",
	'categoryselect-error-user-rights' => "L'utende non ge tène 'u permesse pe fà st'azione.",
	'categoryselect-modal-category-name' => "Dèje 'nu nome d'a categorije:",
	'categoryselect-modal-category-sortkey' => 'Opzionalmende, tu puè alfabbetizzà sta pàgene sus \'a pàgene d\'a categorije "$1" sotte a \'u nome:',
	'categoryselect-tooltip-add' => "Cazze 'u taste Invie quanne è spicciate.",
	'tog-disablecategoryselect' => "Module pe disabbilità 'a categorije (appliche sulamend ce le cangiaminde jndr'à 'u mode visuale onne state disabbilitate)",
	'tog-disablecategoryselect-v2' => "Module pe disabbilità 'a categorije (appliche sulamend ce le cangiaminde jndr'à 'u mode visuale jè disabbilitate)",
);

/** Russian (русский)
 * @author DCamer
 * @author Kuzura
 * @author Lockal
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'categoryselect-desc' => 'Предоставляет интерфейс для управления категориями в статье без редактирования всей статьи.',
	'categoryselect-button-add' => 'Добавить категорию',
	'categoryselect-button-cancel' => 'Отмена',
	'categoryselect-button-save' => 'Сохранить',
	'categoryselect-category-add' => 'Добавьте категорию...',
	'categoryselect-category-edit' => 'Редактировании категории',
	'categoryselect-category-remove' => 'Удалить категорию',
	'categoryselect-edit-summary' => 'Добавление категорий',
	'categoryselect-error-article-doesnt-exist' => 'Статья [id=$1] не существует.',
	'categoryselect-error-category-name-length' => 'Была достигнута максимальная длина названия категории.',
	'categoryselect-error-db-locked' => 'База данных заблокирована.',
	'categoryselect-error-duplicate-category-name' => 'Категория "$1" уже добавлена.',
	'categoryselect-error-edit-abort' => 'Правка, которую вы пытались сделать, была отменена расширением.',
	'categoryselect-error-empty-category-name' => 'Пожалуйста, укажите название категории.',
	'categoryselect-error-user-rights' => 'Вы не имеете прав на выполнение этого действия.',
	'categoryselect-modal-category-name' => 'Укажите название категории:',
	'categoryselect-modal-category-sortkey' => 'Не обязательно. Вы можете поместить эту статью в категории "$1" под названием:',
	'categoryselect-tooltip-add' => 'Нажмите Enter или Отменить, когда закончите.',
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
 * @author Milicevic01
 * @author Rancher
 * @author Verlor
 */
$messages['sr-ec'] = array(
	'categoryselect-button-cancel' => 'Откажи',
	'categoryselect-button-save' => 'Сачувај',
	'categoryselect-category-edit' => 'Уреди категорију',
	'categoryselect-edit-summary' => 'Додавање категорија',
	'categoryselect-error-db-locked' => 'База података је закључана.',
	'categoryselect-error-user-rights' => 'Грешка у корисничким правима.', # Fuzzy
);

/** Swedish (svenska)
 * @author Tobulos1
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'categoryselect-desc' => 'Provides an interface for managing categories in article without editing whole article',
	'categoryselect-button-add' => 'Lägg till kategori',
	'categoryselect-button-cancel' => 'Avbryt',
	'categoryselect-button-save' => 'Spara',
	'categoryselect-category-add' => 'Lägg till kategori...',
	'categoryselect-category-edit' => 'Redigera kategori',
	'categoryselect-category-remove' => 'Ta bort kategori',
	'categoryselect-edit-summary' => 'Lägg till kategorier',
	'categoryselect-error-article-doesnt-exist' => 'Artikel [id=$1] finns inte.',
	'categoryselect-error-category-name-length' => 'Den maximala längden för ett kategorinamn är nådd.',
	'categoryselect-error-db-locked' => 'Databasen är låst.',
	'categoryselect-error-duplicate-category-name' => 'Kategorin "$1" finns redan.',
	'categoryselect-error-edit-abort' => 'Ändringen du försökte göra avbröts av en förlängningskrok.',
	'categoryselect-error-empty-category-name' => 'Var god ange ett kategorinamn.',
	'categoryselect-error-user-rights' => 'Användaren har inte behörighet att utföra denna åtgärd.',
	'categoryselect-modal-category-name' => 'Ange namnet på kategorin:',
	'categoryselect-modal-category-sortkey' => 'Alternativt kan du alfabetisera denna artikel på kategorisidan "$1" under namnet:',
	'categoryselect-tooltip-add' => 'Tryck på Enter eller RETUR när du är klar.',
	'tog-disablecategoryselect' => 'Inaktivera kategorimodul (gäller endast om redigering i visuellt läge har inaktiverats)',
	'tog-disablecategoryselect-v2' => 'Inaktivera kategorimodulen (gäller endast om det visuella redigeringsläget är inaktiverat)',
);

/** Swahili (Kiswahili)
 */
$messages['sw'] = array(
	'categoryselect-button-cancel' => 'Batilisha',
	'categoryselect-button-save' => 'Hifadhi',
);

/** Telugu (తెలుగు)
 * @author Praveen Illa
 * @author Veeven
 */
$messages['te'] = array(
	'categoryselect-button-cancel' => 'రద్దుచేయి',
	'categoryselect-button-save' => 'భద్రపరచు',
	'categoryselect-category-edit' => 'వర్గాల ఎంపికలు', # Fuzzy
	'categoryselect-error-db-locked' => 'డేటాబేసు లాక్‌చెయ్యబడింది.',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'categoryselect-desc' => 'Nagbibigay ng isang hangganang-mukha para sa pamamahala ng mga kategorya sa loob ng artikulo na hindi binabago ang buong artikulo.',
	'categoryselect-button-cancel' => 'Huwag ituloy',
	'categoryselect-button-save' => 'Sagipin',
	'categoryselect-category-edit' => 'Mga mapagpipilian ng kategorya', # Fuzzy
	'categoryselect-edit-summary' => 'Idinaragdag ang mga kategorya',
	'categoryselect-error-db-locked' => 'Nakakandado ang kalipunan ng dato',
	'categoryselect-error-user-rights' => 'Kamalian sa mga karapatan ng tagagamit.', # Fuzzy
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
	'categoryselect-button-cancel' => 'İptal',
	'categoryselect-button-save' => 'Kaydet',
);

/** Tatar (Cyrillic script) (татарча)
 * @author Zahidulla
 */
$messages['tt-cyrl'] = array(
	'categoryselect-button-cancel' => 'Кире кагу',
	'categoryselect-button-save' => 'Сакларга',
	'categoryselect-category-edit' => 'Төркемнәр көйләнмәләре', # Fuzzy
	'categoryselect-edit-summary' => 'Төркемнәр өстәү',
	'categoryselect-error-db-locked' => 'Мәгълүматлар базасы тыелган',
);

/** Ukrainian (українська)
 * @author Base
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'categoryselect-desc' => 'Забезпечує інтерфейс для управління категоріями у статті без редагування всієї статті.',
	'categoryselect-button-add' => 'Додати категорію',
	'categoryselect-button-cancel' => 'Скасувати',
	'categoryselect-button-save' => 'Зберегти',
	'categoryselect-category-add' => 'Додати категорію…',
	'categoryselect-category-edit' => 'Редагувати категорію',
	'categoryselect-category-remove' => 'Вилучити категорію',
	'categoryselect-edit-summary' => 'Додавання категорій',
	'categoryselect-error-article-doesnt-exist' => 'Стаття [id=$1] не існує.',
	'categoryselect-error-category-name-length' => 'Досягнуто максимальної довжини назви категорії.',
	'categoryselect-error-db-locked' => 'Базу даних заблоковано.',
	'categoryselect-error-duplicate-category-name' => 'Категорія «$1» вже існує.',
	'categoryselect-error-edit-abort' => 'Зміна, яку Ви намагались учинити була відхилена хуком розширення.',
	'categoryselect-error-empty-category-name' => 'Будь ласка, вкажіть назву категорії.',
	'categoryselect-error-user-rights' => 'У вас немає прав для того, щоб здійснити цю дію.',
	'categoryselect-modal-category-name' => 'Вкажіть назву категорії:',
	'categoryselect-modal-category-sortkey' => 'За бажання, Ви можете відсортувати цю статтю за алфавітом у категорії «$1» під назвою:',
	'categoryselect-tooltip-add' => 'Натисніть клавішу Enter або Return коли скінчите.',
	'tog-disablecategoryselect' => 'Вимкнути модуль категорій (застосовується лише при вимкненому редагуванні у візуальному режимі)',
	'tog-disablecategoryselect-v2' => 'Вимкнути модуль категорій (застосовується лише при вимкненому візуальному режимі)',
);

/** Urdu (اردو)
 */
$messages['ur'] = array(
	'categoryselect-button-cancel' => 'منسوخ',
);

/** Uzbek (oʻzbekcha)
 * @author Sociologist
 */
$messages['uz'] = array(
	'categoryselect-category-remove' => 'Turkumni oʻchirish',
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
	'categoryselect-button-cancel' => 'Hủy bỏ',
	'categoryselect-button-save' => 'Lưu',
	'categoryselect-category-edit' => 'Tùy chọn thể loại', # Fuzzy
	'categoryselect-edit-summary' => 'Thêm thể loại',
	'categoryselect-error-db-locked' => 'Cơ sở dữ liệu bị khóa.',
	'categoryselect-error-user-rights' => 'Lỗi quyền người dùng.', # Fuzzy
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
	'categoryselect-button-cancel' => '取消',
	'categoryselect-button-save' => '儲存',
	'categoryselect-category-edit' => '分類選項', # Fuzzy
);

/** Simplified Chinese (中文（简体）‎)
 * @author Dimension
 * @author Hydra
 * @author Hzy980512
 * @author Yfdyh000
 */
$messages['zh-hans'] = array(
	'categoryselect-desc' => '提供一个接口，用以在不编辑整个条目的情况下管理条目中的分类',
	'categoryselect-button-add' => '添加类别',
	'categoryselect-button-cancel' => '取消',
	'categoryselect-button-save' => '保存',
	'categoryselect-category-add' => '添加类别…',
	'categoryselect-category-edit' => '编辑类别',
	'categoryselect-category-remove' => '删除类别',
	'categoryselect-edit-summary' => '添加分类',
	'categoryselect-error-article-doesnt-exist' => '条目[id=$1]不存在。',
	'categoryselect-error-category-name-length' => '一个分类名称已超过最大长度。',
	'categoryselect-error-db-locked' => '数据库已锁定。',
	'categoryselect-error-duplicate-category-name' => '分类：“$1”已存在。',
	'categoryselect-error-edit-abort' => '您所尝试的修改被一个扩展钩子所取消。',
	'categoryselect-error-empty-category-name' => '请输入分类名称。',
	'categoryselect-error-user-rights' => '用户没有进行此操作的权限。',
	'categoryselect-modal-category-name' => '提供类别的名称：',
	'categoryselect-tooltip-add' => '完成后按Enter或Return键。',
	'tog-disablecategoryselect' => '禁用分类模块（仅适用于如果编辑在可视模式下已被禁用）',
	'tog-disablecategoryselect-v2' => '禁用分类模块（仅适用于如果可视模式已被禁用）',
);

/** Traditional Chinese (中文（繁體）‎)
 * @author Ffaarr
 * @author Simon Shek
 */
$messages['zh-hant'] = array(
	'categoryselect-button-add' => '增加分類',
	'categoryselect-button-cancel' => '取消',
	'categoryselect-button-save' => '儲存',
	'categoryselect-category-add' => '增加分類',
	'categoryselect-category-edit' => '編輯分類',
	'categoryselect-category-remove' => '移除分類',
	'categoryselect-edit-summary' => '增加分類',
	'categoryselect-error-category-name-length' => '已達到一個分類名稱的最大長度。',
	'categoryselect-error-db-locked' => '資料庫已鎖定。',
	'categoryselect-error-duplicate-category-name' => '分類「$1」已存在。',
	'categoryselect-error-empty-category-name' => '請提供一個分類名稱。',
	'categoryselect-error-user-rights' => '用戶沒有進行此操作的權限。',
	'categoryselect-modal-category-name' => '提供的分類的名稱：',
);
