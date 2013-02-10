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
	'tog-disablecategoryselect-v2' => 'Disable Category module (only applies if visual mode editing is disabled)',
);

/** Message documentation (Message documentation)
 * @author Kflorence
 */
$messages['qqq'] = array(
	'categoryselect-desc' => '{{desc}}',
	'categoryselect-button-add' => 'The text displayed for the add category button on article pages.',
	'categoryselect-button-cancel' => 'The text displayed for the cancel button on article pages.',
	'categoryselect-button-save' => 'The text displayed for the save button on article pages.',
	'categoryselect-category-add' => 'The placeholder text displayed in the category input field when it is empty.',
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
	'categoryselect-error-article-doesnt-exist' => 'Artikel [id=$1] bestaan nie.',
	'categoryselect-error-db-locked' => 'Databasis is gesluit.',
	'categoryselect-tooltip-add' => "Druk 'Enter' as u klaar is",
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
	'categoryselect-category-edit' => 'خيارات التصنيف',
	'categoryselect-edit-summary' => 'إضافة التصانيف',
	'categoryselect-error-article-doesnt-exist' => 'المقالة [id=$1] لا وجود لها',
	'categoryselect-error-db-locked' => 'قاعدة البيانات مغلقة',
	'categoryselect-error-edit-abort' => 'التعديل الذي تحاول أن تقوم به أجهض من قبل تمديد هوك',
	'categoryselect-error-empty-category-name' => 'أضف اسم التصنيف (الجزء قبل |)',
	'categoryselect-error-user-rights' => 'خطأ في حقوق المستخدم', # Fuzzy
	'categoryselect-modal-category-name' => 'يقدم إسما للتصنيف',
	'categoryselect-modal-category-sortkey' => 'يرتب أبجديا هذا المقال في صفحة تصنيف "$1" تحت الاسم',
	'categoryselect-tooltip-add' => 'إظغط على Enter اذا انتهيت',
	'tog-disablecategoryselect' => 'تعطيل وسم التصنيفات', # Fuzzy
);

/** Assamese (অসমীয়া)
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
	'categoryselect-category-add' => 'A Kategorie dazuadoah',
	'categoryselect-category-edit' => 'Kategorie-Ópziónen',
	'categoryselect-edit-summary' => 'Kategorie dazuadoah',
	'categoryselect-error-article-doesnt-exist' => 'Der Artiké [id=$1] existird néd.',
	'categoryselect-error-db-locked' => 'Dé Daatenbaunk is im Móment grod gsperrd.',
	'categoryselect-error-edit-abort' => 'Deih vasuachte Änderrung is durch a Aufhänger voh aner Daweiterrung obbrochen worn.',
	'categoryselect-error-empty-category-name' => 'Kategorie-Naum (der Tei vur |)',
	'categoryselect-error-user-rights' => 'Koane ausreichenden Benutzerrechtt.', # Fuzzy
	'categoryselect-modal-category-name' => 'Gib an Naum voh da Kategorie auh:',
	'categoryselect-modal-category-sortkey' => 'Dua dén Artiké in da Kategorie „$1“ unter fóigendm Naum einé:',
	'categoryselect-tooltip-add' => 'Mid da Eihgobtasten beénden',
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
	'categoryselect-edit-summary' => 'Добавяне на категории',
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
	'categoryselect-category-add' => 'Ouzhpennañ ur rummad',
	'categoryselect-category-edit' => 'Dibarzhioù ar rummad',
	'categoryselect-edit-summary' => 'Ouzhpennañ ur rummad',
	'categoryselect-error-article-doesnt-exist' => "N'eus ket eus ar pennad [id=$1].",
	'categoryselect-error-db-locked' => 'Stanket eo ar bank roadennoù',
	'categoryselect-error-edit-abort' => "Ar c'hemm hoc'h eus klasket degas zo bet harzet gant ur c'hrog astenn.",
	'categoryselect-error-empty-category-name' => 'Reiñ a ra anv ar rummad (al lodenn skrivet a-raok |)',
	'categoryselect-error-user-rights' => 'Fazi en aotreoù implijerien.', # Fuzzy
	'categoryselect-modal-category-name' => 'Roit anv ar rummad :',
	'categoryselect-modal-category-sortkey' => 'Lakaat ar pennad-mañ er rummad "$1" dindan an anv da-heul :',
	'categoryselect-tooltip-add' => 'Pouezañ war "Kas" evit echuiñ',
	'tog-disablecategoryselect' => 'Diweredekaat balizadur ar rummadoù', # Fuzzy
);

/** Catalan (català)
 * @author BroOk
 */
$messages['ca'] = array(
	'categoryselect-desc' => "Proporciona una interfície per gestionar les categories dels articles sense editar tot l'article.",
	'categoryselect-button-add' => 'Afegir categoria',
	'categoryselect-button-cancel' => 'Cancel·la',
	'categoryselect-button-save' => 'Desa',
	'categoryselect-category-add' => 'Afegir una categoria',
	'categoryselect-category-edit' => 'Opcions de categoria',
	'categoryselect-edit-summary' => 'Afegint categories',
	'categoryselect-error-article-doesnt-exist' => "L'article [id=$1] no existeix.",
	'categoryselect-error-db-locked' => 'La base de dades està bloquejada.',
	'categoryselect-error-edit-abort' => "La modificació que has intentat fer ha estat avortada per un ganxo d'extensió.",
	'categoryselect-error-empty-category-name' => 'Posa el nom de la categoria (part abans de |)',
	'categoryselect-error-user-rights' => "Error de drets d'usuari.", # Fuzzy
	'categoryselect-modal-category-name' => 'Posa el nom de la categoria:',
	'categoryselect-modal-category-sortkey' => 'Classifica aquest article a la categoria "$1" amb el nom:',
	'categoryselect-tooltip-add' => 'Pressiona "Enter" quan acabis',
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
	'categoryselect-button-add' => 'Přidat kategorii',
	'categoryselect-button-cancel' => 'Storno',
	'categoryselect-button-save' => 'Uložit',
	'categoryselect-category-add' => 'Přidat kategorii',
	'categoryselect-category-edit' => 'Možnosti kategorie',
	'categoryselect-edit-summary' => 'Přidávání kategorií',
	'categoryselect-error-article-doesnt-exist' => 'Článek [id=$1] neexistuje.',
	'categoryselect-error-db-locked' => 'Databáze je uzamčena.',
	'categoryselect-error-edit-abort' => 'Změna, o kterou jste se pokusili, byla zrušena rozšířením.',
	'categoryselect-error-empty-category-name' => 'Zadejte název kategorie (část před |)',
	'categoryselect-error-user-rights' => 'Chyba uživatelských práv.', # Fuzzy
	'categoryselect-modal-category-name' => 'Uveďte název kategorie:',
	'categoryselect-modal-category-sortkey' => 'Abecedně seřadit tento článek na stránce kategorie „$1" pod názvem:',
	'categoryselect-tooltip-add' => 'Po dokončení stiskněte Enter',
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
	'categoryselect-button-add' => 'Kategorie hinzufügen',
	'categoryselect-button-cancel' => 'Abbrechen',
	'categoryselect-button-save' => 'Speichern',
	'categoryselect-category-add' => 'Eine Kategorie hinzufügen',
	'categoryselect-category-edit' => 'Kategorie-Optionen',
	'categoryselect-edit-summary' => 'Kategorien hinzufügen',
	'categoryselect-error-article-doesnt-exist' => 'Der Artikel [id=$1] existiert nicht.',
	'categoryselect-error-db-locked' => 'Die Datenbank ist vorübergehend gesperrt.',
	'categoryselect-error-edit-abort' => 'Deine versuchte Änderung wurde durch ein Aufhängen einer Erweiterung abgebrochen',
	'categoryselect-error-empty-category-name' => 'Kategorie-Name (der Teil vor |)',
	'categoryselect-error-user-rights' => 'Keine ausreichenden Benutzerrechte.', # Fuzzy
	'categoryselect-modal-category-name' => 'Gib den Namen der Kategorie an:',
	'categoryselect-modal-category-sortkey' => 'Ordne diesen Artikel in der Kategorie „$1“ unter folgendem Namen ein:',
	'categoryselect-tooltip-add' => 'Mit Eingabetaste beenden',
	'tog-disablecategoryselect' => 'Kategorie-Modul ausschalten (greift nur, wenn das grafische Bearbeiten ausgeschaltet wurde)',
	'tog-disablecategoryselect-v2' => 'Kategorie-Modul deaktivieren (trifft nur zu, wenn der grafische Editor deaktiviert ist)',
);

/** German (formal address) (Deutsch (Sie-Form)‎)
 * @author LWChris
 */
$messages['de-formal'] = array(
	'categoryselect-error-edit-abort' => 'Ihre versuchte Änderung wurde durch ein Aufhängen einer Erweiterung abgebrochen',
	'categoryselect-modal-category-name' => 'Geben Sie den Namen der Kategorie an:',
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
 */
$messages['el'] = array(
	'categoryselect-button-add' => 'Προσθήκη κατηγορίας',
	'categoryselect-button-cancel' => 'Ακύρωση',
	'categoryselect-button-save' => 'Αποθήκευση',
	'categoryselect-category-add' => 'Προσθήκη μιας κατηγορίας',
	'categoryselect-category-edit' => 'Επιλογές κατηγορίας',
	'categoryselect-error-db-locked' => 'Η βάση δεδομένων είναι κλειδωμένη',
	'categoryselect-modal-category-name' => 'Δώστε το όνομα της κατηγορίας:',
	'categoryselect-tooltip-add' => 'Πατήστε Enter όταν γίνει',
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
	'categoryselect-category-add' => 'Añadir una categoría',
	'categoryselect-category-edit' => 'Opciones de categoría',
	'categoryselect-edit-summary' => 'Añadiendo categorías',
	'categoryselect-error-article-doesnt-exist' => 'El artículo [id=$1] no existe.',
	'categoryselect-error-db-locked' => 'La base de datos está bloqueada.',
	'categoryselect-error-edit-abort' => 'La modificación que ha intentado realizar fue abortada por un gancho de extensión',
	'categoryselect-error-empty-category-name' => 'Pon el nombre de la categoría (parte antes de |)',
	'categoryselect-error-user-rights' => 'Error de derechos de usuario.', # Fuzzy
	'categoryselect-modal-category-name' => 'Pon el nombre de la categoría:',
	'categoryselect-modal-category-sortkey' => 'Clasifica este artículo en la categoría "$1" con el nombre:',
	'categoryselect-tooltip-add' => 'Presiona Enter cuando termines',
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
 */
$messages['fa'] = array(
	'categoryselect-button-add' => 'افزودن رده',
	'categoryselect-button-cancel' => 'لغو',
	'categoryselect-button-save' => 'ذخیره کردن',
	'categoryselect-edit-summary' => 'افزودن رده',
	'categoryselect-tooltip-add' => 'پس از اتمام دکمه اینتر را فشار دهید',
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
	'categoryselect-button-add' => 'Lisää luokka',
	'categoryselect-button-cancel' => 'Peruuta',
	'categoryselect-button-save' => 'Tallenna',
	'categoryselect-category-add' => 'Lisää luokka',
	'categoryselect-category-edit' => 'Luokan asetukset',
	'categoryselect-edit-summary' => 'Luokkien lisääminen',
	'categoryselect-error-article-doesnt-exist' => 'Artikkelia [id=$1] ei ole olemassa.',
	'categoryselect-error-db-locked' => 'Tietokanta on lukittu.',
	'categoryselect-error-edit-abort' => 'Laajennusriippuvuus keskeytti yrittämäsi muutoksen',
	'categoryselect-error-empty-category-name' => 'Syötä luokan nimi (osa ennen |)',
	'categoryselect-error-user-rights' => 'Käyttöoikeusvirhe.', # Fuzzy
	'categoryselect-modal-category-name' => 'Syötä luokan nimi:',
	'categoryselect-modal-category-sortkey' => 'Aakkosta tämä artikkeli "$1" luokkasivulle nimellä:',
	'categoryselect-tooltip-add' => 'Paina Enter, kun olet valmis',
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
	'categoryselect-button-add' => 'Ajouter des catégories',
	'categoryselect-button-cancel' => 'Annuler',
	'categoryselect-button-save' => 'Enregistrer',
	'categoryselect-category-add' => 'Ajouter une catégorie',
	'categoryselect-category-edit' => 'Options de la catégorie',
	'categoryselect-edit-summary' => 'Ajout de catégories',
	'categoryselect-error-article-doesnt-exist' => "L'article [id=$1] n'existe pas.",
	'categoryselect-error-db-locked' => 'La base de données est verrouillée.',
	'categoryselect-error-edit-abort' => "La modification que vous avez essayé de faire a été arrêtée par un crochet d'une extension",
	'categoryselect-error-empty-category-name' => "Nom de la catégorie (ce qu'on écrit devant |)",
	'categoryselect-error-user-rights' => 'Erreur de droits utilisateur.', # Fuzzy
	'categoryselect-modal-category-name' => 'Ecrivez le nom de la catégorie :',
	'categoryselect-modal-category-sortkey' => 'Mettre cet article dans la catégorie « $1 » sous le nom suivant :',
	'categoryselect-tooltip-add' => 'Appuyez sur « Entrée » pour terminer',
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
	'categoryselect-category-add' => 'Engadir unha categoría',
	'categoryselect-category-edit' => 'Opcións de categoría',
	'categoryselect-edit-summary' => 'Inserción de categorías',
	'categoryselect-error-article-doesnt-exist' => 'O artigo [id=$1] non existe.',
	'categoryselect-error-db-locked' => 'A base de datos está bloqueada.',
	'categoryselect-error-edit-abort' => 'O asociador da extensión abortou a modificación que intentou realizar',
	'categoryselect-error-empty-category-name' => 'Dea o nome da categoría (o que se escribe antes de |)',
	'categoryselect-error-user-rights' => 'Erro de dereitos de usuario.', # Fuzzy
	'categoryselect-modal-category-name' => 'Escriba o nome da categoría:',
	'categoryselect-modal-category-sortkey' => 'Clasificar este artigo na categoría "$1" co nome:',
	'categoryselect-tooltip-add' => 'Prema a tecla Intro cando remate',
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
	'categoryselect-category-edit' => 'Kategóriabeállítások',
	'categoryselect-edit-summary' => 'Kategóriák hozzáadása',
	'categoryselect-error-article-doesnt-exist' => 'A(z) [id=$1] szócikk nem létezik.',
	'categoryselect-error-db-locked' => 'Az adatbázis zárolva.',
	'categoryselect-error-edit-abort' => 'Az általad kezdeményezett módosítást nem lehet végrehajtani. (Egy bővítmény megakadályozta.)',
	'categoryselect-error-empty-category-name' => 'Kategórianév megjelenítése ( az | előtti rész)',
	'categoryselect-error-user-rights' => 'Felhasználói jog hiba.', # Fuzzy
	'categoryselect-modal-category-name' => 'Add meg a kategória nevét:',
	'categoryselect-modal-category-sortkey' => 'A szócikk ábécérendbe sorolása az "$1" kategóriában az alábbi név szerint:',
	'categoryselect-tooltip-add' => 'Nyomj Entert, ha kész vagy',
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
	'categoryselect-category-add' => 'Adder un categoria',
	'categoryselect-category-edit' => 'Optiones de categoria',
	'categoryselect-edit-summary' => 'Addition de categorias…',
	'categoryselect-error-article-doesnt-exist' => 'Le articulo [id=$1] non existe.',
	'categoryselect-error-db-locked' => 'Le base de datos es blocate.',
	'categoryselect-error-edit-abort' => 'Le modification que tu tentava facer ha essite abortate per un extension.',
	'categoryselect-error-empty-category-name' => 'Entra le nomine del categoria (le parte ante "|")',
	'categoryselect-error-user-rights' => 'Error de derectos de usator.', # Fuzzy
	'categoryselect-modal-category-name' => 'Entra le nomine del categoria:',
	'categoryselect-modal-category-sortkey' => 'Alphabetisar iste articulo in le categoria "$1" sub le nomine:',
	'categoryselect-tooltip-add' => 'Preme Enter pro finir',
	'tog-disablecategoryselect' => 'Disactivar le modulo Categoria (applicabile solmente si le modification in modo visual ha essite disactivate)',
	'tog-disablecategoryselect-v2' => 'Disactivar le modulo Categoria (applicabile solmente si le modification in modo visual es disactivate)',
);

/** Indonesian (Bahasa Indonesia)
 * @author Aldnonymous
 * @author Irwangatot
 */
$messages['id'] = array(
	'categoryselect-desc' => 'Menyediakan sebuah antarmuka untuk mengelola kategori dalam artikel tanpa mengedit seluruh artikel.',
	'categoryselect-button-add' => 'Menambah kategori',
	'categoryselect-button-cancel' => 'Batalkan',
	'categoryselect-button-save' => 'Simpan',
	'categoryselect-category-add' => 'Menambahkan kategori',
	'categoryselect-category-edit' => 'Pilihan kategori',
	'categoryselect-edit-summary' => 'Menambahkan kategori',
	'categoryselect-error-article-doesnt-exist' => 'Artikel [id=$1] tidak ada.',
	'categoryselect-error-db-locked' => 'Basis data dikunci.',
	'categoryselect-error-edit-abort' => 'Perubahan yang coba Anda lakukan dibatalkan oleh suatu ekstensi kaitan.',
	'categoryselect-error-empty-category-name' => 'Membutuhkan nama kategori (bagian sebelum |)',
	'categoryselect-error-user-rights' => 'Kesalahan hak pengguna.', # Fuzzy
	'categoryselect-modal-category-name' => 'Memberikan nama kategori:',
	'categoryselect-modal-category-sortkey' => 'Penyusunan artikel ini menurut abjad pada kategori "$1" dengan nama:',
	'categoryselect-tooltip-add' => 'Tekan Enter jika sudah selesai',
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
 * @author Ximo17
 */
$messages['it'] = array(
	'categoryselect-desc' => "Fornisce un'interfaccia per la gestione delle categorie negli articoli senza modificare l'intera pagina",
	'categoryselect-button-add' => 'Aggiungi categoria',
	'categoryselect-button-cancel' => 'Annulla',
	'categoryselect-button-save' => 'Salva',
	'categoryselect-category-add' => 'Aggiungi una categoria',
	'categoryselect-category-edit' => 'Opzioni categoria',
	'categoryselect-edit-summary' => 'Categorie aggiunte',
	'categoryselect-error-article-doesnt-exist' => "L'articolo [id=$1] non esiste.",
	'categoryselect-error-db-locked' => 'Database bloccato.',
	'categoryselect-error-edit-abort' => "La modifica che si sta tentando di fare è stata interrotta da un problema dell'estensione",
	'categoryselect-error-empty-category-name' => 'Fornire il nome della categoria (parte prima di |)',
	'categoryselect-error-user-rights' => "Errore nei diritti dell'utente.", # Fuzzy
	'categoryselect-modal-category-name' => 'Fornire il nome della categoria:',
	'categoryselect-modal-category-sortkey' => 'Alfabetizzare questo articolo nella categoria "$1" sotto il nome:',
	'categoryselect-tooltip-add' => 'Premi INVIO quando hai fatto',
	'tog-disablecategoryselect' => 'Disabilita il modulo Categoria (si applica solo se la modifica in modalità visuale è stata disabilitata)',
	'tog-disablecategoryselect-v2' => 'Disabilita il modulo Categoria (si applica solo se la modifica in modalità visuale è disabilitata)',
);

/** Japanese (日本語)
 * @author Shirayuki
 * @author Tommy6
 */
$messages['ja'] = array(
	'categoryselect-desc' => '記事を編集することなくカテゴリを操作するためのインターフェースを提供する',
	'categoryselect-button-add' => 'カテゴリを追加',
	'categoryselect-button-cancel' => '取り消し',
	'categoryselect-button-save' => '保存',
	'categoryselect-category-add' => 'カテゴリを追加',
	'categoryselect-category-edit' => 'カテゴリのオプション',
	'categoryselect-edit-summary' => 'カテゴリを追加',
	'categoryselect-error-article-doesnt-exist' => '記事 [id=$1] は存在しません。',
	'categoryselect-error-db-locked' => 'データベースがロックされています',
	'categoryselect-error-edit-abort' => '拡張機能のフックによって、修正が中断されました',
	'categoryselect-error-empty-category-name' => 'カテゴリ名を入力（"|"より前の部分）',
	'categoryselect-error-user-rights' => '利用者権限のエラーです。', # Fuzzy
	'categoryselect-modal-category-name' => 'カテゴリ名を入力',
	'categoryselect-modal-category-sortkey' => '"$1"カテゴリで記事のソートに使用する名前を入力',
	'categoryselect-tooltip-add' => 'エンターキーを押すと終了',
	'tog-disablecategoryselect' => 'カテゴリタグ付け機能を無効にする（ビジュアルモードでの編集を無効にしている場合にのみ適用）',
	'tog-disablecategoryselect-v2' => 'カテゴリモジュールを無効にする（ビジュアルモードでの編集を無効にしている場合にのみ適用）',
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
	'categoryselect-button-add' => '분류 추가',
	'categoryselect-button-cancel' => '취소',
	'categoryselect-button-save' => '저장',
	'categoryselect-category-add' => '분류 추가',
	'categoryselect-category-edit' => '분류 옵션',
	'categoryselect-edit-summary' => '분류 추가',
	'categoryselect-error-article-doesnt-exist' => '문서 [id=$1]가 존재하지 않습니다.',
	'categoryselect-error-db-locked' => '데이터베이스가 잠겨 있습니다.',
	'categoryselect-error-empty-category-name' => '분류 이름 제공 (| 전에 부분)',
	'categoryselect-error-user-rights' => '사용자 권한 오류입니다.', # Fuzzy
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
	'categoryselect-button-add' => 'Kategorie derbäisetzen',
	'categoryselect-button-cancel' => 'Ofbriechen',
	'categoryselect-button-save' => 'Späicheren',
	'categoryselect-category-add' => 'Eng Kategorie derbäisetzen',
	'categoryselect-category-edit' => 'Optioune vun der Kategorie',
	'categoryselect-edit-summary' => 'Kategorien derbäisetzen',
	'categoryselect-error-article-doesnt-exist' => 'Den Artikel [id=$1] gëtt et net.',
	'categoryselect-error-db-locked' => "D'Datebank ass gespaart.",
	'categoryselect-error-user-rights' => 'Feeler bäi de Benotzerrechter.', # Fuzzy
	'categoryselect-tooltip-add' => "Dréckt 'Enter' wann Dir fäerdeg sidd",
);

/** Lithuanian (lietuvių)
 * @author Eitvys200
 */
$messages['lt'] = array(
	'categoryselect-button-add' => 'Pridėti kategoriją',
	'categoryselect-button-cancel' => 'Atšaukti',
	'categoryselect-button-save' => 'Išsaugoti',
	'categoryselect-category-add' => 'Pridėti kategoriją',
	'categoryselect-category-edit' => 'Kategorijos nustatymai',
	'categoryselect-error-article-doesnt-exist' => 'Straipsnis [id = $1 ] neegzistuoja.',
	'categoryselect-error-db-locked' => 'Duomenų bazė užrakinta.',
	'categoryselect-error-user-rights' => 'Vartotojo teisių klaida.', # Fuzzy
	'categoryselect-tooltip-add' => 'Baigę paspauskite Enter',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'categoryselect-desc' => 'Дава посредник за раководење со категориите во една статија без да треба да се уредува целата статија.',
	'categoryselect-button-add' => 'Додај категорија',
	'categoryselect-button-cancel' => 'Откажи',
	'categoryselect-button-save' => 'Зачувај',
	'categoryselect-category-add' => 'Додај категорија',
	'categoryselect-category-edit' => 'Нагодувања за категории',
	'categoryselect-edit-summary' => 'Додавање на категории',
	'categoryselect-error-article-doesnt-exist' => 'Статијата [id=$1] не постои.',
	'categoryselect-error-db-locked' => 'Базата на податоци е заклучена.',
	'categoryselect-error-edit-abort' => 'Измените кои се обидовте да ги направите се откажани од кука за додатоци',
	'categoryselect-error-empty-category-name' => 'Наведете има на категоријата (делот пред |)',
	'categoryselect-error-user-rights' => 'Грешка со корисничките права.', # Fuzzy
	'categoryselect-modal-category-name' => 'Наведете го името на категоријата:',
	'categoryselect-modal-category-sortkey' => 'Азбучно заведи ја статијава во категоријата „$1“ под името:',
	'categoryselect-tooltip-add' => 'Пристиснете Enter кога сте готови',
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
	'categoryselect-category-edit' => 'വർഗ്ഗത്തിലെ ഐച്ഛികങ്ങൾ',
	'categoryselect-error-article-doesnt-exist' => 'ലേഖനം [id=$1] നിലവിലില്ല.',
	'categoryselect-tooltip-add' => 'പൂർത്തിയാകുമ്പോൾ എന്റർ അമർത്തുക',
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
	'categoryselect-category-add' => 'Tambahkan kategori',
	'categoryselect-category-edit' => 'Pilihan kategori',
	'categoryselect-edit-summary' => 'Menambahkan kategori',
	'categoryselect-error-article-doesnt-exist' => 'Rencana [id=$1] tidak wujud.',
	'categoryselect-error-db-locked' => 'Pangkalan data dikunci.',
	'categoryselect-error-edit-abort' => 'Pengubahsuaian yang anda cuba buat telah dipaksa henti oleh cangkuk sambungan',
	'categoryselect-error-empty-category-name' => 'Nyatakan nama kategori (bahagian sebelum |)',
	'categoryselect-error-user-rights' => 'Ralat hak pengguna.', # Fuzzy
	'categoryselect-modal-category-name' => 'Nyatakan nama kategori:',
	'categoryselect-modal-category-sortkey' => 'Abjadkan rencana ini di laman kategori "$1" di bawah nama',
	'categoryselect-tooltip-add' => 'Tekan Enter apabila siap',
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
	'categoryselect-category-add' => 'Legg til en kategori',
	'categoryselect-category-edit' => 'Kategorivalg',
	'categoryselect-edit-summary' => 'Legger til kategorier',
	'categoryselect-error-article-doesnt-exist' => 'Artikkel [id=$1] finnes ikke.',
	'categoryselect-error-db-locked' => 'Database er låst.',
	'categoryselect-error-edit-abort' => 'Endringene du prøvde å utføre ble avbrutt av en utvidelseskrok',
	'categoryselect-error-empty-category-name' => 'Oppgi kategorinavn (del før |)',
	'categoryselect-error-user-rights' => 'Feil med brukerrettigheter.', # Fuzzy
	'categoryselect-modal-category-name' => 'Oppgi navnet på kategorien:',
	'categoryselect-modal-category-sortkey' => 'Alfabetiser denne artikkelen under kategorisiden «$1» under navnet:',
	'categoryselect-tooltip-add' => 'Trykk Enter når du er ferdig',
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
	'categoryselect-category-add' => 'Categorie toevoegen',
	'categoryselect-category-edit' => 'Categoriemogelijkheden',
	'categoryselect-category-remove' => 'Categorie verwijderen',
	'categoryselect-edit-summary' => 'Bezig met het toevoegen van categorieën',
	'categoryselect-error-article-doesnt-exist' => 'De pagina [id=$1] bestaat niet.',
	'categoryselect-error-category-name-length' => 'De maximale lengte voor een categorienaam is bereikt.',
	'categoryselect-error-db-locked' => 'De database is geblokkeerd.',
	'categoryselect-error-duplicate-category-name' => 'De categorie "$1" bestaat al.',
	'categoryselect-error-edit-abort' => 'De wijziging die u probeerde te maken is afgebroken door een uitbreidingshook',
	'categoryselect-error-empty-category-name' => 'Geef de categoriemaan op (het deel voor "|")',
	'categoryselect-error-user-rights' => 'De gebruiker geeft geen rechten om deze handeling uit te voeren.',
	'categoryselect-modal-category-name' => 'Geef de naam van een categorie op:',
	'categoryselect-modal-category-sortkey' => 'Rangschik deze pagina in de categoriepagina "$1" onder:',
	'categoryselect-tooltip-add' => 'Druk "Enter" als u klaar bent',
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
	'categoryselect-category-add' => 'Dodaj kategorię',
	'categoryselect-category-edit' => 'Opcje kategorii',
	'categoryselect-edit-summary' => 'Dodawanie kategorii',
	'categoryselect-error-article-doesnt-exist' => 'Artykuł [id=$1] nie istnieje.',
	'categoryselect-error-db-locked' => 'Baza danych jest zablokowana',
	'categoryselect-error-edit-abort' => 'Zmiany, które próbowano wprowadzić zostały anulowane przez inne rozszerzenie',
	'categoryselect-error-empty-category-name' => 'Podaj nazwę kategorii (część przed |)',
	'categoryselect-error-user-rights' => 'Błąd uprawnień użytkownika.', # Fuzzy
	'categoryselect-modal-category-name' => 'Podaj nazwę kategorii:',
	'categoryselect-modal-category-sortkey' => 'Umieść artykuł na alfabetycznej liście kategorii "$1" pod nazwą:',
	'categoryselect-tooltip-add' => 'Zatwierdź wciskając Enter',
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
	'categoryselect-category-add' => 'Gionta na categorìa',
	'categoryselect-category-edit' => 'Opsion ëd categorìa',
	'categoryselect-edit-summary' => 'Gionté categorìe',
	'categoryselect-error-article-doesnt-exist' => "L'artìcol [id=$1] a esist pa.",
	'categoryselect-error-db-locked' => "La base ëd dàit a l'é blocà.",
	'categoryselect-error-edit-abort' => "La modìfica ch'it l'has provà a fé a l'é stàita abortìa da n'agancc ëd n'estension",
	'categoryselect-error-empty-category-name' => 'Dé nòm a la categorìa (part prima |)',
	'categoryselect-error-user-rights' => "Eror dij drit dj'utent.", # Fuzzy
	'categoryselect-modal-category-name' => 'Dà ël nòm ëd la categorìa',
	'categoryselect-modal-category-sortkey' => 'Buté st\'artìcol-sì ant la pàgina ëd categorìa "$1" an órdin alfabétich sota ël nòm:',
	'categoryselect-tooltip-add' => 'Sgnaché su Mandé quand fàit',
	'tog-disablecategoryselect' => "Disabilité ël mòdul dle categorìe (a s'àplica mach se ël modifiché an manera visual a l'é stàit disabilità)",
	'tog-disablecategoryselect-v2' => "Disabilité ël mòdul Categorìa (a s'àplica mach se l'edission an manera visual a l'é disabilità)",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'categoryselect-button-add' => 'وېشنيزه ورګډول',
	'categoryselect-button-cancel' => 'ناګارل',
	'categoryselect-button-save' => 'خوندي کول',
	'categoryselect-category-add' => 'يوه وېشنيزه ورګډول',
	'categoryselect-edit-summary' => 'وېشنيزې ورګډول',
);

/** Portuguese (português)
 * @author Hamilton Abreu
 * @author Malafaya
 * @author SandroHc
 */
$messages['pt'] = array(
	'categoryselect-desc' => 'Fornece uma interface de gestão das categorias de um artigo sem editar o artigo completo.',
	'categoryselect-button-add' => 'Adicionar categoria',
	'categoryselect-button-cancel' => 'Cancelar',
	'categoryselect-button-save' => 'Gravar',
	'categoryselect-category-add' => 'Adicionar uma categoria',
	'categoryselect-category-edit' => 'Opções de categoria',
	'categoryselect-edit-summary' => 'A adicionar categorias',
	'categoryselect-error-article-doesnt-exist' => 'A página [id=$1] não existe.',
	'categoryselect-error-db-locked' => 'A base de dados está trancada.',
	'categoryselect-error-edit-abort' => 'A alteração que tentou fazer foi abortada pelo hook de uma extensão',
	'categoryselect-error-empty-category-name' => 'Introduza o nome da categoria (a parte antes de |)',
	'categoryselect-error-user-rights' => 'Erro de permissões.', # Fuzzy
	'categoryselect-modal-category-name' => 'Introduza o nome da categoria:',
	'categoryselect-modal-category-sortkey' => 'Na página da categoria "$1", listar esta página na posição do nome:',
	'categoryselect-tooltip-add' => 'Pressione Enter quando tiver acabado',
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
	'categoryselect-button-cancel' => 'Cancelar',
	'categoryselect-button-save' => 'Salvar',
	'categoryselect-category-edit' => 'Opções de categoria',
	'categoryselect-edit-summary' => 'Adicionando categorias',
	'categoryselect-error-db-locked' => 'O banco de dados está bloqueado.',
	'categoryselect-error-user-rights' => 'Erro nos direitos de usuário.', # Fuzzy
	'tog-disablecategoryselect' => 'Desabilitar o módulo de categorias (apenas aplicado caso a edição em modo visual foi desabilitada)',
	'tog-disablecategoryselect-v2' => 'Desativar o módulo de Categorias (aplicado apenas se o Modo Visual está desativado)',
);

/** Romanian (română)
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'categoryselect-button-cancel' => 'Renunţă',
	'categoryselect-button-save' => 'Salvează',
	'categoryselect-category-edit' => 'Opţiuni categorie',
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
	'categoryselect-button-cancel' => 'Отмена',
	'categoryselect-button-save' => 'Сохранить',
	'categoryselect-category-edit' => 'Настройки категории',
	'categoryselect-edit-summary' => 'Добавление категорий',
	'categoryselect-error-db-locked' => 'База данных заблокирована.',
	'categoryselect-error-user-rights' => 'Ошибка прав участника.', # Fuzzy
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
	'categoryselect-button-cancel' => 'Откажи',
	'categoryselect-button-save' => 'Сачувај',
	'categoryselect-category-edit' => 'Поставке категорије',
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
	'categoryselect-button-cancel' => 'Avbryt',
	'categoryselect-button-save' => 'Spara',
	'categoryselect-category-edit' => 'Kategori-alternativ',
	'categoryselect-edit-summary' => 'Lägg till kategorier',
	'categoryselect-error-db-locked' => 'Databasen är låst.',
	'categoryselect-error-user-rights' => 'Fel om användarrättigheter.', # Fuzzy
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
	'categoryselect-category-edit' => 'వర్గాల ఎంపికలు',
	'categoryselect-error-db-locked' => 'డేటాబేసు లాక్‌చెయ్యబడింది.',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'categoryselect-desc' => 'Nagbibigay ng isang hangganang-mukha para sa pamamahala ng mga kategorya sa loob ng artikulo na hindi binabago ang buong artikulo.',
	'categoryselect-button-cancel' => 'Huwag ituloy',
	'categoryselect-button-save' => 'Sagipin',
	'categoryselect-category-edit' => 'Mga mapagpipilian ng kategorya',
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
	'categoryselect-category-edit' => 'Төркемнәр көйләнмәләре',
	'categoryselect-edit-summary' => 'Төркемнәр өстәү',
	'categoryselect-error-db-locked' => 'Мәгълүматлар базасы тыелган',
);

/** Ukrainian (українська)
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'categoryselect-desc' => 'Забезпечує інтерфейс для управління категоріями у статті без редагування всієї статті.',
	'categoryselect-button-cancel' => 'Скасувати',
	'categoryselect-button-save' => 'Зберегти',
	'categoryselect-category-edit' => 'Параметри категорії',
	'categoryselect-edit-summary' => 'Додавання категорій',
	'categoryselect-error-user-rights' => 'Помилка прав користувача.', # Fuzzy
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
	'categoryselect-button-cancel' => 'Hủy bỏ',
	'categoryselect-button-save' => 'Lưu',
	'categoryselect-category-edit' => 'Tùy chọn thể loại',
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
	'categoryselect-category-edit' => '分類選項',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Dimension
 * @author Hydra
 * @author Hzy980512
 */
$messages['zh-hans'] = array(
	'categoryselect-button-cancel' => '取消',
	'categoryselect-button-save' => '保存',
	'categoryselect-edit-summary' => '添加分类',
	'categoryselect-error-db-locked' => '数据库已锁定。',
	'categoryselect-error-user-rights' => '用户权限错误。', # Fuzzy
	'categoryselect-modal-category-name' => '输入类别的名称：',
);

/** Traditional Chinese (中文（繁體）‎)
 * @author Ffaarr
 */
$messages['zh-hant'] = array(
	'categoryselect-button-cancel' => '取消',
	'categoryselect-button-save' => '儲存',
	'categoryselect-category-edit' => '分類選項',
	'categoryselect-edit-summary' => '增加分類',
	'categoryselect-error-db-locked' => '資料庫已鎖定。',
	'categoryselect-error-user-rights' => '用戶權限錯誤。', # Fuzzy
);
