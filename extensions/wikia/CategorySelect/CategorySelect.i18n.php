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
	'categoryselect-code-view' => 'Code view',
	'categoryselect-code-view-placeholder' => 'Add categories here, e.g. [[Category:Name]]',
	'categoryselect-visual-view' => 'Visual view',
	'categoryselect-infobox-caption' => 'Category options',
	'categoryselect-infobox-category' => 'Provide the name of the category:',
	'categoryselect-infobox-sortkey' => 'Alphabetize this article on the "$1" category page under the name:',
	'categoryselect-addcategory-button' => 'Add category',
	'categoryselect-addcategory-edit' => 'Add a category',
	'categoryselect-suggest-hint' => 'Press Enter when done',
	'categoryselect-tooltip' => "'''New!''' Category tagging toolbar. Try it out or see [[Help:CategorySelect|help]] to learn more",
	'categoryselect-unhandled-syntax' => 'Unhandled syntax detected - switching back to visual mode impossible.',
	'categoryselect-edit-summary' => 'Adding categories',
	'categoryselect-empty-name' => 'Provide category name (part before |)',
	'categoryselect-button-save' => 'Save',
	'categoryselect-button-cancel' => 'Cancel',
	'categoryselect-error-not-exist' => 'Article [id=$1] does not exist.',
	'categoryselect-error-user-rights' => 'User rights error.',
	'categoryselect-error-db-locked' => 'Database is locked.',
	'categoryselect-edit-abort' => 'The modification you tried to make was aborted by an extension hook',
	'tog-disablecategoryselect' => 'Disable Category module (only applies if editing in visual mode has been disabled)',
	'tog-disablecategoryselect-v2' => 'Disable Category module (only applies if visual mode editing is disabled)'
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Nemo bis
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'categoryselect-desc' => '{{desc}}',
	'categoryselect-code-view-placeholder' => "This is the message shown in the category form in the source mode of the editor. The link doesn't exist, it's just an example text to show how to add the category.",
	'categoryselect-button-save' => '{{Identical|Save}}',
	'categoryselect-button-cancel' => '{{Identical|Cancel}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'categoryselect-addcategory-button' => 'Voeg kategorie by',
	'categoryselect-suggest-hint' => "Druk 'Enter' as u klaar is",
	'categoryselect-button-save' => 'Stoor',
	'categoryselect-button-cancel' => 'Kanselleer',
	'categoryselect-error-not-exist' => 'Artikel [id=$1] bestaan nie.',
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
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'categoryselect-desc' => 'يوفر واجهة لإدارة التصنيفات في مقالة دون تعديل كامل المقالة',
	'categoryselect-code-view' => 'عرض الرموز',
	'categoryselect-visual-view' => 'عرض مرئي',
	'categoryselect-infobox-caption' => 'خيارات التصنيف',
	'categoryselect-infobox-category' => 'يقدم إسما للتصنيف',
	'categoryselect-infobox-sortkey' => 'يرتب أبجديا هذا المقال في صفحة تصنيف "$1" تحت الاسم',
	'categoryselect-addcategory-button' => 'أضف تصنيفا',
	'categoryselect-suggest-hint' => 'إظغط على Enter اذا انتهيت',
	'categoryselect-tooltip' => "'''جديد!''' شريط أدوات علامات التصنيف. جربه أو أنظر [[مساعدة:إختيار التصنيف|المساعدة]] لتعرف المزيد",
	'categoryselect-unhandled-syntax' => 'تم الكشف عن بناء جملة غير معالج - يتم التحويل إلى العرض المرئي',
	'categoryselect-edit-summary' => 'إضافة التصانيف',
	'categoryselect-empty-name' => 'يوفر إسم التصنيف (الجزء قبل |)',
	'categoryselect-button-save' => 'سجل',
	'categoryselect-button-cancel' => 'إلغاء',
	'categoryselect-error-not-exist' => 'المقالة [id=$1] لا وجود لها',
	'categoryselect-error-user-rights' => 'خطأ في حقوق المستخدم',
	'categoryselect-error-db-locked' => 'قاعدة البيانات مغلقة',
	'categoryselect-edit-abort' => 'التعديل الذي تحاول أن تقوم به أجهض من قبل تمديد هوك',
	'tog-disablecategoryselect' => 'تعطيل وسم التصنيفات',
);

/** Assamese (অসমীয়া)
 * @author Jaminianurag
 */
$messages['as'] = array(
	'categoryselect-addcategory-button' => 'শ্ৰেণী সংযোগ কৰক',
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
	'categoryselect-infobox-caption' => 'Kategorie-Ópziónen',
	'categoryselect-infobox-category' => 'Gib an Naum voh da Kategorie auh:',
	'categoryselect-infobox-sortkey' => 'Dua dén Artiké in da Kategorie „$1“ unter fóigendm Naum einé:',
	'categoryselect-addcategory-button' => 'Kategorie dazuadoah',
	'categoryselect-addcategory-edit' => 'A Kategorie dazuadoah',
	'categoryselect-suggest-hint' => 'Mid da Eihgobtasten beénden',
	'categoryselect-tooltip' => "'''Neich!''' Unser Kategorieauswoi-Leisten. Prówiers aus óder lies dé [[Help:KategorieAuswahl|Hüfe]] fyr weiderne Informaziónen",
	'categoryselect-unhandled-syntax' => "Néd unterstytzde Syntax gfunden - A Wexel in d' graafische Auhsicht is néd méglé.",
	'categoryselect-edit-summary' => 'Kategorie dazuadoah',
	'categoryselect-empty-name' => 'Kategorie-Naum (der Tei vur |)',
	'categoryselect-button-save' => 'Speichern',
	'categoryselect-button-cancel' => 'Obbrechen',
	'categoryselect-error-not-exist' => 'Der Artiké [id=$1] existird néd.',
	'categoryselect-error-user-rights' => 'Koane ausreichenden Benutzerrechtt.',
	'categoryselect-error-db-locked' => 'Dé Daatenbaunk is im Móment grod gsperrd.',
	'categoryselect-edit-abort' => 'Deih vasuachte Änderrung is durch a Aufhänger voh aner Daweiterrung obbrochen worn.',
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
	'categoryselect-addcategory-button' => 'Добавяне на категория',
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
	'categoryselect-infobox-caption' => 'Dibarzhioù ar rummad',
	'categoryselect-infobox-category' => 'Roit anv ar rummad :',
	'categoryselect-infobox-sortkey' => 'Lakaat ar pennad-mañ er rummad "$1" dindan an anv da-heul :',
	'categoryselect-addcategory-button' => 'Ouzhpennañ rummadoù',
	'categoryselect-addcategory-edit' => 'Ouzhpennañ ur rummad',
	'categoryselect-suggest-hint' => 'Pouezañ war "Kas" evit echuiñ',
	'categoryselect-tooltip' => "'''Nevez !''' Barrenn ostilhoù evit diuzañ rummadoù. Amprouit anezhi pe lennit [[Help:CategorySelect|ar skoazell]] evit gouzout hiroc'h",
	'categoryselect-unhandled-syntax' => "Ur gudenn ereadurezh dianav zo. N'haller ket lakaat ar mod gwelet.",
	'categoryselect-edit-summary' => 'Ouzhpennañ ur rummad',
	'categoryselect-empty-name' => 'Reiñ a ra anv ar rummad (al lodenn skrivet a-raok |)',
	'categoryselect-button-save' => 'Enrollañ',
	'categoryselect-button-cancel' => 'Nullañ',
	'categoryselect-error-not-exist' => "N'eus ket eus ar pennad [id=$1].",
	'categoryselect-error-user-rights' => 'Fazi en aotreoù implijerien.',
	'categoryselect-error-db-locked' => 'Stanket eo ar bank roadennoù',
	'categoryselect-edit-abort' => "Ar c'hemm hoc'h eus klasket degas zo bet harzet gant ur c'hrog astenn.",
	'tog-disablecategoryselect' => 'Diweredekaat balizadur ar rummadoù',
);

/** Catalan (català)
 * @author BroOk
 */
$messages['ca'] = array(
	'categoryselect-code-view-placeholder' => 'Afegeix categories aquí, p.e. [[Categoria:Nom]]',
);

/** Sorani Kurdish (کوردی) */
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
	'categoryselect-code-view-placeholder' => 'Zde přidat kategoire, např. [[Kategorie:Jméno]]',
	'categoryselect-visual-view' => 'Vizuální zobrazení',
	'categoryselect-infobox-caption' => 'Možnosti kategorie',
	'categoryselect-infobox-category' => 'Uveďte název kategorie:',
	'categoryselect-infobox-sortkey' => 'Abecedně seřadit tento článek na stránce kategorie „$1" pod názvem:',
	'categoryselect-addcategory-button' => 'Přidat kategorii',
	'categoryselect-addcategory-edit' => 'Přidat kategorii',
	'categoryselect-suggest-hint' => 'Po dokončení stiskněte Enter',
	'categoryselect-tooltip' => "'''Novinka!''' Lišta na tagování kategorií. Vyzkoušejte ji nebo si přečtěte [[Help:CategorySelect|nápovědu]]",
	'categoryselect-unhandled-syntax' => 'Zjištěna neošetřená syntaxe - přepnutí zpět do vizuálního zobrazení není možné.',
	'categoryselect-edit-summary' => 'Přidávání kategorií',
	'categoryselect-empty-name' => 'Zadejte název kategorie (část před |)',
	'categoryselect-button-save' => 'Uložit',
	'categoryselect-button-cancel' => 'Storno',
	'categoryselect-error-not-exist' => 'Článek [id=$1] neexistuje.',
	'categoryselect-error-user-rights' => 'Chyba uživatelských práv.',
	'categoryselect-error-db-locked' => 'Databáze je uzamčena.',
	'categoryselect-edit-abort' => 'Změna, o kterou jste se pokusili, byla zrušena rozšířením.',
	'tog-disablecategoryselect' => 'Zakázat značení kategorií (platné pouze, pokud bylo editování ve vizuálním režimu zakázáno)',
	'tog-disablecategoryselect-v2' => 'Zakázat modul kategorií (pouze pokud je zakázaný vizuální editor)',
);

/** German (Deutsch)
 * @author Avatar
 * @author Inkowik
 * @author Jan Luca
 * @author LWChris
 * @author PtM
 */
$messages['de'] = array(
	'categoryselect-desc' => 'Stellt eine Oberfläche zur Verwaltung der Kategorien in einem Artikel ohne Bearbeitung des ganzen Artikels zur Verfügung.',
	'categoryselect-code-view' => 'Quelltext',
	'categoryselect-code-view-placeholder' => 'Hier Kategorie hinzufügen, z. B. [[Kategorie:Name]]',
	'categoryselect-visual-view' => 'Grafische Ansicht',
	'categoryselect-infobox-caption' => 'Kategorie-Optionen',
	'categoryselect-infobox-category' => 'Gib den Namen der Kategorie an:',
	'categoryselect-infobox-sortkey' => 'Ordne diesen Artikel in der Kategorie „$1“ unter folgendem Namen ein:',
	'categoryselect-addcategory-button' => 'Kategorie hinzufügen',
	'categoryselect-addcategory-edit' => 'Eine Kategorie hinzufügen',
	'categoryselect-suggest-hint' => 'Mit Eingabetaste beenden',
	'categoryselect-tooltip' => "'''Neu!''' Unsere Kategorieauswahl-Leiste. Probier sie aus oder lies die [[Help:KategorieAuswahl|Hilfe]] für weitere Informationen",
	'categoryselect-unhandled-syntax' => 'Nicht unterstützte Syntax entdeckt - Wechsel in grafische Ansicht nicht möglich.',
	'categoryselect-edit-summary' => 'Kategorien hinzufügen',
	'categoryselect-empty-name' => 'Kategorie-Name (der Teil vor |)',
	'categoryselect-button-save' => 'Speichern',
	'categoryselect-button-cancel' => 'Abbrechen',
	'categoryselect-error-not-exist' => 'Der Artikel [id=$1] existiert nicht.',
	'categoryselect-error-user-rights' => 'Keine ausreichenden Benutzerrechte.',
	'categoryselect-error-db-locked' => 'Die Datenbank ist vorübergehend gesperrt.',
	'categoryselect-edit-abort' => 'Deine versuchte Änderung wurde durch ein Aufhängen einer Erweiterung abgebrochen',
	'tog-disablecategoryselect' => 'Kategorie-Modul ausschalten (greift nur, wenn das grafische Bearbeiten ausgeschaltet wurde)',
	'tog-disablecategoryselect-v2' => 'Kategorie-Modul deaktivieren (trifft nur zu, wenn der grafische Editor deaktiviert ist)',
);

/** German (formal address) (Deutsch (Sie-Form)‎)
 * @author LWChris
 */
$messages['de-formal'] = array(
	'categoryselect-infobox-category' => 'Geben Sie den Namen der Kategorie an:',
	'categoryselect-tooltip' => "'''Neu!''' Unsere Kategorieauswahl-Leiste. Probieren Sie sie aus oder lesen Sie die [[Help:KategorieAuswahl|Hilfe]] für weitere Informationen",
	'categoryselect-edit-abort' => 'Ihre versuchte Änderung wurde durch ein Aufhängen einer Erweiterung abgebrochen',
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
 */
$messages['el'] = array(
	'categoryselect-button-cancel' => 'Ακύρωση',
);

/** Spanish (español)
 * @author Armando-Martin
 * @author Benfutbol10
 * @author Pertile
 * @author Translationista
 * @author VegaDark
 */
$messages['es'] = array(
	'categoryselect-desc' => 'Proporciona una interfaz para gestionar las categorías de los artículos sin editar todo el artículo.',
	'categoryselect-code-view' => 'Vista de código',
	'categoryselect-code-view-placeholder' => 'Añadir categorías aquí, por ejemplo, [[Category:Nombre]]',
	'categoryselect-visual-view' => 'Vista visual',
	'categoryselect-infobox-caption' => 'Opciones de categoría',
	'categoryselect-infobox-category' => 'Pon el nombre de la categoría:',
	'categoryselect-infobox-sortkey' => 'Clasifica este artículo en la categoría "$1" con el nombre:',
	'categoryselect-addcategory-button' => 'Añadir categoría',
	'categoryselect-addcategory-edit' => 'Añadir una categoría',
	'categoryselect-suggest-hint' => 'Presiona Enter cuando termines',
	'categoryselect-tooltip' => "'''¡Nuevo!''' Barra de etiquetas de categoría. Pruebala o échale un vistazo a [[Help:CategorySelect|ayuda]] para aprender más",
	'categoryselect-unhandled-syntax' => 'Detectada sintaxis inmanipulable - imposible cambiar al modo visual.',
	'categoryselect-edit-summary' => 'Añadiendo categorías',
	'categoryselect-empty-name' => 'Pon el nombre de la categoría (parte antes de |)',
	'categoryselect-button-save' => 'Guardar',
	'categoryselect-button-cancel' => 'Cancelar',
	'categoryselect-error-not-exist' => 'El artículo [id=$1] no existe.',
	'categoryselect-error-user-rights' => 'Error de derechos de usuario.',
	'categoryselect-error-db-locked' => 'La base de datos está bloqueada.',
	'categoryselect-edit-abort' => 'La modificación que ha intentado realizar fue abortada por un gancho de extensión',
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

/** Persian (فارسی) */
$messages['fa'] = array(
	'categoryselect-addcategory-button' => 'افزودن رده',
	'categoryselect-suggest-hint' => 'پس از اتمام دکمه اینتر را فشار دهید',
	'categoryselect-edit-summary' => 'افزودن رده',
	'categoryselect-button-save' => 'ذخیره رده',
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
	'categoryselect-code-view-placeholder' => 'Lisää luokkia tähän, esim. [[Luokka:Nimi]]',
	'categoryselect-visual-view' => 'Näytä visuaalisena',
	'categoryselect-infobox-caption' => 'Luokan asetukset',
	'categoryselect-infobox-category' => 'Syötä luokan nimi:',
	'categoryselect-infobox-sortkey' => 'Aakkosta tämä artikkeli "$1" luokkasivulle nimellä:',
	'categoryselect-addcategory-button' => 'Lisää luokka',
	'categoryselect-addcategory-edit' => 'Lisää luokka',
	'categoryselect-suggest-hint' => 'Paina Enter, kun olet valmis',
	'categoryselect-tooltip' => "'''Uusi!''' Luokan lisäystyökalurivi. Testaa sitä tai katso [[Help:CategorySelect|ohjeesta]] lisätietoa.",
	'categoryselect-unhandled-syntax' => 'Käsittelemätön syntaksi havaittu - palaaminen visuaaliseen tilaan ei mahdollista.',
	'categoryselect-edit-summary' => 'Luokkien lisääminen',
	'categoryselect-empty-name' => 'Syötä luokan nimi (osa ennen |)',
	'categoryselect-button-save' => 'Tallenna',
	'categoryselect-button-cancel' => 'Peruuta',
	'categoryselect-error-not-exist' => 'Artikkelia [id=$1] ei ole olemassa.',
	'categoryselect-error-user-rights' => 'Käyttöoikeusvirhe.',
	'categoryselect-error-db-locked' => 'Tietokanta on lukittu.',
	'categoryselect-edit-abort' => 'Laajennusriippuvuus keskeytti yrittämäsi muutoksen',
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
	'categoryselect-code-view-placeholder' => 'Ajoutez les catégories ici, par exemple [[Category:Name]]',
	'categoryselect-visual-view' => 'Vue visuelle',
	'categoryselect-infobox-caption' => 'Options de la catégorie',
	'categoryselect-infobox-category' => 'Ecrivez le nom de la catégorie :',
	'categoryselect-infobox-sortkey' => 'Mettre cet article dans la catégorie « $1 » sous le nom suivant :',
	'categoryselect-addcategory-button' => 'Ajouter des catégories',
	'categoryselect-addcategory-edit' => 'Ajouter une catégorie',
	'categoryselect-suggest-hint' => 'Appuyez sur « Entrée » pour terminer',
	'categoryselect-tooltip' => "'''Nouveau ! :''' Barre d'outils de sélection de catégorie. Essayez-la ou lisez [[Help:CategorySelect|l'aide]] pour en apprendre plus.",
	'categoryselect-unhandled-syntax' => "Il y a un problème de syntaxe inconnue. Il n'est pas possible de changer en vue graphique.",
	'categoryselect-edit-summary' => 'Ajout de catégories',
	'categoryselect-empty-name' => "Nom de la catégorie (ce qu'on écrit devant |)",
	'categoryselect-button-save' => 'Enregistrer',
	'categoryselect-button-cancel' => 'Annuler',
	'categoryselect-error-not-exist' => "L'article [id=$1] n'existe pas.",
	'categoryselect-error-user-rights' => 'Erreur de droits utilisateur.',
	'categoryselect-error-db-locked' => 'La base de données est verrouillée.',
	'categoryselect-edit-abort' => "La modification que vous avez essayé de faire a été arrêtée par un crochet d'une extension",
	'tog-disablecategoryselect' => "Désactiver le module des catégories (valable uniquement si l'édition en mode visuel a été désactivée)",
	'tog-disablecategoryselect-v2' => "Désactiver le module Catégorie (s'applique uniquement si le mode d'édition visuelle est désactivé)",
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'categoryselect-desc' => 'Proporciona unha interface para xestionar as categorías dos artigos sen editar todo o artigo.',
	'categoryselect-code-view' => 'Vista do código',
	'categoryselect-code-view-placeholder' => 'Engadir categorías aquí, por exemplo, [[Category:Name]]',
	'categoryselect-visual-view' => 'Vista visual',
	'categoryselect-infobox-caption' => 'Opcións de categoría',
	'categoryselect-infobox-category' => 'Escriba o nome da categoría:',
	'categoryselect-infobox-sortkey' => 'Clasificar este artigo na categoría "$1" co nome:',
	'categoryselect-addcategory-button' => 'Engadir a categoría',
	'categoryselect-addcategory-edit' => 'Engadir unha categoría',
	'categoryselect-suggest-hint' => 'Prema a tecla Intro cando remate',
	'categoryselect-tooltip' => "'''Novo!''' Barra de ferramentas de selección de categoría. Próbaa ou olle a [[Help:CategorySelect|axuda]] para saber máis",
	'categoryselect-unhandled-syntax' => 'Detectouse unha sintaxe descoñecida; non é posible volver ao modo visual.',
	'categoryselect-edit-summary' => 'Inserción de categorías',
	'categoryselect-empty-name' => 'Dea o nome da categoría (o que se escribe antes de |)',
	'categoryselect-button-save' => 'Gardar',
	'categoryselect-button-cancel' => 'Cancelar',
	'categoryselect-error-not-exist' => 'O artigo [id=$1] non existe.',
	'categoryselect-error-user-rights' => 'Erro de dereitos de usuario.',
	'categoryselect-error-db-locked' => 'A base de datos está bloqueada.',
	'categoryselect-edit-abort' => 'O asociador da extensión abortou a modificación que intentou realizar',
	'tog-disablecategoryselect' => 'Desactivar o módulo de categorías (só se aplica se a edición no modo visual está desactivada)',
	'tog-disablecategoryselect-v2' => 'Desactivar o módulo de categorías (só se aplica se o modo de edición visual está desactivado)',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 */
$messages['grc'] = array(
	'categoryselect-button-cancel' => 'Ἀκυροῦν',
);

/** Hausa (Hausa) */
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
	'categoryselect-code-view-placeholder' => 'Itt add hozzá a kategüriákat, pl. [[Kategória:Név]]',
	'categoryselect-visual-view' => 'Grafikus nézet',
	'categoryselect-infobox-caption' => 'Kategóriabeállítások',
	'categoryselect-infobox-category' => 'Add meg a kategória nevét:',
	'categoryselect-infobox-sortkey' => 'A szócikk ábécérendbe sorolása az "$1" kategóriában az alábbi név szerint:',
	'categoryselect-addcategory-button' => 'Kategória hozzáadása',
	'categoryselect-addcategory-edit' => 'Kategória hozzáadása',
	'categoryselect-suggest-hint' => 'Nyomj Entert, ha kész vagy',
	'categoryselect-tooltip' => "''' Új!'' ' Kategória címkézési eszköztár. Próbáld ki, vagy tekintsd meg a [[Help:CategorySelect|dokumentációt]]",
	'categoryselect-unhandled-syntax' => 'Kezeletlen szintaxis észlelve - nem lehetséges a visszaváltás vizuális módba.',
	'categoryselect-edit-summary' => 'Kategóriák hozzáadása',
	'categoryselect-empty-name' => 'Kategórianév megjelenítése ( az | előtti rész)',
	'categoryselect-button-save' => 'Mentés',
	'categoryselect-button-cancel' => 'Mégse',
	'categoryselect-error-not-exist' => 'A(z) [id=$1] szócikk nem létezik.',
	'categoryselect-error-user-rights' => 'Felhasználói jog hiba.',
	'categoryselect-error-db-locked' => 'Az adatbázis zárolva.',
	'categoryselect-edit-abort' => 'Az általad kezdeményezett módosítást nem lehet végrehajtani. (Egy bővítmény megakadályozta.)',
	'tog-disablecategoryselect' => 'Kategóriamodul letiltása (csak a vizuális módban való szerkesztés kikapcsolása esetén érvényes)',
	'tog-disablecategoryselect-v2' => 'Kategóriamodul letiltása (csak a vizuális mód kikapcsolása esetén érvényes)',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'categoryselect-desc' => 'Provide un interfacie pro gerer le categorias in un articulo sin modificar tote le articulo.',
	'categoryselect-code-view' => 'Vista de codice',
	'categoryselect-code-view-placeholder' => 'Adder categorias hic, p.ex. [[Category:Nomine]]',
	'categoryselect-visual-view' => 'Vista graphic',
	'categoryselect-infobox-caption' => 'Optiones de categoria',
	'categoryselect-infobox-category' => 'Entra le nomine del categoria:',
	'categoryselect-infobox-sortkey' => 'Alphabetisar iste articulo in le categoria "$1" sub le nomine:',
	'categoryselect-addcategory-button' => 'Adder categoria',
	'categoryselect-addcategory-edit' => 'Adder un categoria',
	'categoryselect-suggest-hint' => 'Preme Enter pro finir',
	'categoryselect-tooltip' => "'''Nove!''' Instrumentario pro seliger categorias. Proba lo o vide [[Help:CategorySelect|le adjuta]] pro leger plus",
	'categoryselect-unhandled-syntax' => 'Syntaxe incognite detegite - impossibile retornar al vista graphic.',
	'categoryselect-edit-summary' => 'Addition de categorias…',
	'categoryselect-empty-name' => 'Entra le nomine del categoria (le parte ante "|")',
	'categoryselect-button-save' => 'Salveguardar',
	'categoryselect-button-cancel' => 'Cancellar',
	'categoryselect-error-not-exist' => 'Le articulo [id=$1] non existe.',
	'categoryselect-error-user-rights' => 'Error de derectos de usator.',
	'categoryselect-error-db-locked' => 'Le base de datos es blocate.',
	'categoryselect-edit-abort' => 'Le modification que tu tentava facer ha essite abortate per un extension.',
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
	'categoryselect-code-view-placeholder' => 'Tambahkan Kategori di sini, misalnya [[Category:Name]]',
	'categoryselect-visual-view' => 'Tampilan visual',
	'categoryselect-infobox-caption' => 'Pilihan kategori',
	'categoryselect-infobox-category' => 'Memberikan nama kategori:',
	'categoryselect-infobox-sortkey' => 'Penyusunan artikel ini menurut abjad pada kategori "$1" dengan nama:',
	'categoryselect-addcategory-button' => 'Menambah kategori',
	'categoryselect-addcategory-edit' => 'Menambahkan kategori',
	'categoryselect-suggest-hint' => 'Tekan Enter jika sudah selesai',
	'categoryselect-tooltip' => "'''Baru!''' Peralatan tag Kategori. Cobalah atau lihat [[Help:CategorySelect|Bantuan]] untuk mempelajari lebih lanjut",
	'categoryselect-unhandled-syntax' => 'terdeteksi sintaks tidak tertangani - beralih kembali ke modus visual tidak memungkinkan.',
	'categoryselect-edit-summary' => 'Menambahkan kategori',
	'categoryselect-empty-name' => 'Membutuhkan nama kategori (bagian sebelum |)',
	'categoryselect-button-save' => 'Simpan',
	'categoryselect-button-cancel' => 'Batalkan',
	'categoryselect-error-not-exist' => 'Artikel [id=$1] tidak ada.',
	'categoryselect-error-user-rights' => 'Kesalahan hak pengguna.',
	'categoryselect-error-db-locked' => 'Basis data dikunci.',
	'categoryselect-edit-abort' => 'Perubahan yang coba Anda lakukan dibatalkan oleh suatu ekstensi kaitan.',
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
	'categoryselect-code-view-placeholder' => 'Aggiungere le categorie qui, ad esempio [[Categoria:Nome]]',
	'categoryselect-visual-view' => 'Modalità visuale',
	'categoryselect-infobox-caption' => 'Opzioni categoria',
	'categoryselect-infobox-category' => 'Fornire il nome della categoria:',
	'categoryselect-infobox-sortkey' => 'Alfabetizzare questo articolo nella categoria "$1" sotto il nome:',
	'categoryselect-addcategory-button' => 'Aggiungi categoria',
	'categoryselect-addcategory-edit' => 'Aggiungi una categoria',
	'categoryselect-suggest-hint' => 'Premi INVIO quando hai fatto',
	'categoryselect-tooltip' => "'''Novità!''' Barra per il tagging categoria. Provala o cerca [[Help:CategorySelect|aiuto]] per saperne di più",
	'categoryselect-unhandled-syntax' => 'Sintassi non gestita rilevata - passaggio alla modalità visuale impossibile',
	'categoryselect-edit-summary' => 'Categorie aggiunte',
	'categoryselect-empty-name' => 'Fornire il nome della categoria (parte prima di |)',
	'categoryselect-button-save' => 'Salva',
	'categoryselect-button-cancel' => 'Annulla',
	'categoryselect-error-not-exist' => "L'articolo [id=$1] non esiste.",
	'categoryselect-error-user-rights' => "Errore nei diritti dell'utente.",
	'categoryselect-error-db-locked' => 'Database bloccato.',
	'categoryselect-edit-abort' => "La modifica che si sta tentando di fare è stata interrotta da un problema dell'estensione",
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
	'categoryselect-code-view-placeholder' => 'ここにカテゴリを追加（例: [[Category:カテゴリ名]]）',
	'categoryselect-visual-view' => 'ビジュアルモードで表示',
	'categoryselect-infobox-caption' => 'カテゴリのオプション',
	'categoryselect-infobox-category' => 'カテゴリ名を入力',
	'categoryselect-infobox-sortkey' => '"$1"カテゴリで記事のソートに使用する名前を入力',
	'categoryselect-addcategory-button' => 'カテゴリを追加',
	'categoryselect-addcategory-edit' => 'カテゴリを追加',
	'categoryselect-suggest-hint' => 'エンターキーを押すと終了',
	'categoryselect-tooltip' => "''New!''' カテゴリタギングツールバー。詳しくは[[Help:カテゴリセレクト|ヘルプ]]を参照してください。",
	'categoryselect-unhandled-syntax' => '処理できない構文が検出されました - ビジュアルモードに移行できません。',
	'categoryselect-edit-summary' => 'カテゴリを追加',
	'categoryselect-empty-name' => 'カテゴリ名を入力（"|"より前の部分）',
	'categoryselect-button-save' => '保存',
	'categoryselect-button-cancel' => '取り消し',
	'categoryselect-error-not-exist' => '記事 [id=$1] は存在しません。',
	'categoryselect-error-user-rights' => '利用者権限のエラーです。',
	'categoryselect-error-db-locked' => 'データベースがロックされています',
	'categoryselect-edit-abort' => '拡張機能のフックによって、修正が中断されました',
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
	'categoryselect-code-view-placeholder' => '여기에 분류를 추가하세요. 예를 들어 [[Category:이름]]',
	'categoryselect-visual-view' => '시각적 보기',
	'categoryselect-infobox-caption' => '분류 옵션',
	'categoryselect-addcategory-button' => '분류 추가',
	'categoryselect-addcategory-edit' => '분류 추가',
	'categoryselect-edit-summary' => '분류 추가',
	'categoryselect-empty-name' => '분류 이름 제공 (| 전에 부분)',
	'categoryselect-button-save' => '저장',
	'categoryselect-button-cancel' => '취소',
	'categoryselect-error-not-exist' => '문서 [id=$1]가 존재하지 않습니다.',
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
	'categoryselect-code-view-placeholder' => "Hei d'Kategorien derbäisetzen, z. Bsp. [[Category:Numm]]",
	'categoryselect-infobox-caption' => 'Optioune vun der Kategorie',
	'categoryselect-addcategory-button' => 'Kategorie derbäisetzen',
	'categoryselect-addcategory-edit' => 'Eng Kategorie derbäisetzen',
	'categoryselect-suggest-hint' => "Dréckt 'Enter' wann Dir fäerdeg sidd",
	'categoryselect-edit-summary' => 'Kategorien derbäisetzen',
	'categoryselect-button-save' => 'Späicheren',
	'categoryselect-button-cancel' => 'Ofbriechen',
	'categoryselect-error-not-exist' => 'Den Artikel [id=$1] gëtt et net.',
	'categoryselect-error-user-rights' => 'Feeler bäi de Benotzerrechter.',
	'categoryselect-error-db-locked' => "D'Datebank ass gespaart.",
);

/** Lithuanian (lietuvių)
 * @author Eitvys200
 */
$messages['lt'] = array(
	'categoryselect-code-view' => 'Kodo peržiūra',
	'categoryselect-code-view-placeholder' => 'Pridėkite kategorijas čia pvz. [[Kategorija:Pavadinimas]]',
	'categoryselect-infobox-caption' => 'Kategorijos nustatymai',
	'categoryselect-addcategory-button' => 'Pridėti kategoriją',
	'categoryselect-addcategory-edit' => 'Pridėti kategoriją',
	'categoryselect-suggest-hint' => 'Baigę paspauskite Enter',
	'categoryselect-button-save' => 'Išsaugoti',
	'categoryselect-button-cancel' => 'Atšaukti',
	'categoryselect-error-not-exist' => 'Straipsnis [id = $1 ] neegzistuoja.',
	'categoryselect-error-user-rights' => 'Vartotojo teisių klaida.',
	'categoryselect-error-db-locked' => 'Duomenų bazė užrakinta.',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'categoryselect-desc' => 'Дава посредник за раководење со категориите во една статија без да треба да се уредува целата статија.',
	'categoryselect-code-view' => 'Коден изглед',
	'categoryselect-code-view-placeholder' => 'Тука додавајте категории (на пр. [[Category:Name]])',
	'categoryselect-visual-view' => 'Визуелен изглед',
	'categoryselect-infobox-caption' => 'Нагодувања за категории',
	'categoryselect-infobox-category' => 'Наведете го името на категоријата:',
	'categoryselect-infobox-sortkey' => 'Азбучно заведи ја статијава во категоријата „$1“ под името:',
	'categoryselect-addcategory-button' => 'Додај категорија',
	'categoryselect-addcategory-edit' => 'Додај категорија',
	'categoryselect-suggest-hint' => 'Пристиснете Enter кога сте готови',
	'categoryselect-tooltip' => "'''Ново!''' Алатник за означување на категории. Испробајте го или одете на [[Help:CategorySelect|помош]] за да дознаете повеќе",
	'categoryselect-unhandled-syntax' => 'Пронајдена е необработена синтакса - не можам да ве вратам во визуелен режим.',
	'categoryselect-edit-summary' => 'Додавање на категории',
	'categoryselect-empty-name' => 'Наведете има на категоријата (делот пред |)',
	'categoryselect-button-save' => 'Зачувај',
	'categoryselect-button-cancel' => 'Откажи',
	'categoryselect-error-not-exist' => 'Статијата [id=$1] не постои.',
	'categoryselect-error-user-rights' => 'Грешка со корисничките права.',
	'categoryselect-error-db-locked' => 'Базата на податоци е заклучена.',
	'categoryselect-edit-abort' => 'Измените кои се обидовте да ги направите се откажани од кука за додатоци',
	'tog-disablecategoryselect' => 'Оневозможи го модулот за категории (важи само кога е оневозможено уредувањето во режимот „Визуелно“)',
	'tog-disablecategoryselect-v2' => 'Оневозможи го категорискиот модул (важи само ако е оневозможен визуелниот режим)',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'categoryselect-infobox-caption' => 'വർഗ്ഗത്തിലെ ഐച്ഛികങ്ങൾ',
	'categoryselect-addcategory-button' => 'വർഗ്ഗം ചേർക്കുക',
	'categoryselect-suggest-hint' => 'പൂർത്തിയാകുമ്പോൾ എന്റർ അമർത്തുക',
	'categoryselect-button-save' => 'സേവ് ചെയ്യുക',
	'categoryselect-button-cancel' => 'റദ്ദാക്കുക',
	'categoryselect-error-not-exist' => 'ലേഖനം [id=$1] നിലവിലില്ല.',
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
	'categoryselect-code-view-placeholder' => 'Tambahkan kategori di sini, cth. [[Category:Name]]',
	'categoryselect-visual-view' => 'Paparan visual',
	'categoryselect-infobox-caption' => 'Pilihan kategori',
	'categoryselect-infobox-category' => 'Nyatakan nama kategori:',
	'categoryselect-infobox-sortkey' => 'Abjadkan rencana ini di laman kategori "$1" di bawah nama',
	'categoryselect-addcategory-button' => 'Tambahkan kategori',
	'categoryselect-addcategory-edit' => 'Tambahkan kategori',
	'categoryselect-suggest-hint' => 'Tekan Enter apabila siap',
	'categoryselect-tooltip' => "'''Baru!''' Bar alat pengetagan kategori. Cubalah atau dapatkan [[Help:CategorySelect|bantuan]] untuk mengetahui lebih lanjut",
	'categoryselect-unhandled-syntax' => 'Sintaks yang tidak diuruskan dikesan - tidak dapat beralih kembali ke mod visual.',
	'categoryselect-edit-summary' => 'Menambahkan kategori',
	'categoryselect-empty-name' => 'Nyatakan nama kategori (bahagian sebelum |)',
	'categoryselect-button-save' => 'Simpan',
	'categoryselect-button-cancel' => 'Batalkan',
	'categoryselect-error-not-exist' => 'Rencana [id=$1] tidak wujud.',
	'categoryselect-error-user-rights' => 'Ralat hak pengguna.',
	'categoryselect-error-db-locked' => 'Pangkalan data dikunci.',
	'categoryselect-edit-abort' => 'Pengubahsuaian yang anda cuba buat telah dipaksa henti oleh cangkuk sambungan',
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
	'categoryselect-code-view-placeholder' => 'Legg til en kategori her, f. eks. [[Category:Name]]',
	'categoryselect-visual-view' => 'Visuell visning',
	'categoryselect-infobox-caption' => 'Kategorivalg',
	'categoryselect-infobox-category' => 'Oppgi navnet på kategorien:',
	'categoryselect-infobox-sortkey' => 'Alfabetiser denne artikkelen under kategorisiden «$1» under navnet:',
	'categoryselect-addcategory-button' => 'Legg til kategori',
	'categoryselect-addcategory-edit' => 'Legg til en kategori',
	'categoryselect-suggest-hint' => 'Trykk Enter når du er ferdig',
	'categoryselect-tooltip' => "'''Nyhet!''' Verktøylinje for kategorimerking. Prøv den eller se [[Help:CategorySelect|her]] for å lære mer",
	'categoryselect-unhandled-syntax' => 'Uhåndtert syntaks oppdaget - umulig å bytte tilbake til visuell modus.',
	'categoryselect-edit-summary' => 'Legger til kategorier',
	'categoryselect-empty-name' => 'Oppgi kategorinavn (del før |)',
	'categoryselect-button-save' => 'Lagre',
	'categoryselect-button-cancel' => 'Avbryt',
	'categoryselect-error-not-exist' => 'Artikkel [id=$1] finnes ikke.',
	'categoryselect-error-user-rights' => 'Feil med brukerrettigheter.',
	'categoryselect-error-db-locked' => 'Database er låst.',
	'categoryselect-edit-abort' => 'Endringene du prøvde å utføre ble avbrutt av en utvidelseskrok',
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
	'categoryselect-code-view-placeholder' => 'Categorieën hier toevoegen, bijv. [[Category:Name]]',
	'categoryselect-visual-view' => 'Visuele weergave',
	'categoryselect-infobox-caption' => 'Categoriemogelijkheden',
	'categoryselect-infobox-category' => 'Geef de naam van een categorie op:',
	'categoryselect-infobox-sortkey' => 'Rangschik deze pagina in de categoriepagina "$1" onder:',
	'categoryselect-addcategory-button' => 'Categorie toevoegen',
	'categoryselect-addcategory-edit' => 'Categorie toevoegen',
	'categoryselect-suggest-hint' => 'Druk "Enter" als u klaar bent',
	'categoryselect-tooltip' => "'''Nieuw!''' Werkbalk voor categorielabels.
Probeer het uit of zie [[Help:CategorySelect|help]] voor meer informatie.",
	'categoryselect-unhandled-syntax' => 'Er is ongeldige wikitekst gedetecteerd.
Terugschakelen naar visuele weergave is niet mogelijk.',
	'categoryselect-edit-summary' => 'Bezig met het toevoegen van categorieën',
	'categoryselect-empty-name' => 'Geef de categoriemaan op (het deel voor "|")',
	'categoryselect-button-save' => 'Opslaan',
	'categoryselect-button-cancel' => 'Annuleren',
	'categoryselect-error-not-exist' => 'De pagina [id=$1] bestaat niet.',
	'categoryselect-error-user-rights' => 'Fout in de gebruikersrechten.',
	'categoryselect-error-db-locked' => 'De database is geblokkeerd.',
	'categoryselect-edit-abort' => 'De wijziging die u probeerde te maken is afgebroken door een uitbreidingshook',
	'tog-disablecategoryselect' => 'Categoriemodule uitschakelen (alleen van toepassing als bewerken in visuele modus is uitgeschakeld)',
	'tog-disablecategoryselect-v2' => 'Categoriemodule uitschakelen (alleen van toepassing als de visuele tekstverwerker is uitgeschakeld)',
);

/** Nederlands (informeel)‎ (Nederlands (informeel)‎)
 * @author Siebrand
 */
$messages['nl-informal'] = array(
	'categoryselect-edit-abort' => 'De wijziging die je probeerde te maken is afgebroken door een uitbreidingshook',
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
	'categoryselect-code-view-placeholder' => 'Dodaj kategorie tutaj, np. [[Kategoria:Nazwa]]',
	'categoryselect-visual-view' => 'Tryb wizualny',
	'categoryselect-infobox-caption' => 'Opcje kategorii',
	'categoryselect-infobox-category' => 'Podaj nazwę kategorii:',
	'categoryselect-infobox-sortkey' => 'Umieść artykuł na alfabetycznej liście kategorii "$1" pod nazwą:',
	'categoryselect-addcategory-button' => 'Dodaj kategorię',
	'categoryselect-addcategory-edit' => 'Dodaj kategorię',
	'categoryselect-suggest-hint' => 'Zatwierdź wciskając Enter',
	'categoryselect-tooltip' => "'''Nowość!''' Pasek dodawania kategorii. Wypróbuj lub zobacz [[Help:CategorySelect|stronę pomocy]] aby dowiedzieć się więcej",
	'categoryselect-unhandled-syntax' => 'Wykryto nieobsługiwaną składnię - powrót do trybu wizualnego niemożliwy.',
	'categoryselect-edit-summary' => 'Dodawanie kategorii',
	'categoryselect-empty-name' => 'Podaj nazwę kategorii (część przed |)',
	'categoryselect-button-save' => 'Zapisz',
	'categoryselect-button-cancel' => 'Anuluj',
	'categoryselect-error-not-exist' => 'Artykuł [id=$1] nie istnieje.',
	'categoryselect-error-user-rights' => 'Błąd uprawnień użytkownika.',
	'categoryselect-error-db-locked' => 'Baza danych jest zablokowana',
	'categoryselect-edit-abort' => 'Zmiany, które próbowano wprowadzić zostały anulowane przez inne rozszerzenie',
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
	'categoryselect-code-view-placeholder' => 'Gionta dle categorìe ambelessì, p.e. [[Category:Name]]',
	'categoryselect-visual-view' => 'Visualisassion visual',
	'categoryselect-infobox-caption' => 'Opsion ëd categorìa',
	'categoryselect-infobox-category' => 'Dà ël nòm ëd la categorìa',
	'categoryselect-infobox-sortkey' => 'Buté st\'artìcol-sì ant la pàgina ëd categorìa "$1" an órdin alfabétich sota ël nòm:',
	'categoryselect-addcategory-button' => 'Gionta categorìa',
	'categoryselect-addcategory-edit' => 'Gionta na categorìa',
	'categoryselect-suggest-hint' => 'Sgnaché su Mandé quand fàit',
	'categoryselect-tooltip' => "'''Neuv!''' Bara dj'utiss ëd j'etichëtte ëd categorìa. Ch'a la preuva o ch'a varda [[Help:CategorySelect|agiut]] për savèjne ëd pi",
	'categoryselect-unhandled-syntax' => "Trovà sintassi pa gestìa - a l'é pa possìbil torné andré a modalità visual.",
	'categoryselect-edit-summary' => 'Gionté categorìe',
	'categoryselect-empty-name' => 'Dé nòm a la categorìa (part prima |)',
	'categoryselect-button-save' => 'Salva',
	'categoryselect-button-cancel' => 'Scancelé',
	'categoryselect-error-not-exist' => "L'artìcol [id=$1] a esist pa.",
	'categoryselect-error-user-rights' => "Eror dij drit dj'utent.",
	'categoryselect-error-db-locked' => "La base ëd dàit a l'é blocà.",
	'categoryselect-edit-abort' => "La modìfica ch'it l'has provà a fé a l'é stàita abortìa da n'agancc ëd n'estension",
	'tog-disablecategoryselect' => "Disabilité ël mòdul dle categorìe (a s'àplica mach se ël modifiché an manera visual a l'é stàit disabilità)",
	'tog-disablecategoryselect-v2' => "Disabilité ël mòdul Categorìa (a s'àplica mach se l'edission an manera visual a l'é disabilità)",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'categoryselect-addcategory-button' => 'وېشنيزه ورګډول',
	'categoryselect-addcategory-edit' => 'يوه وېشنيزه ورګډول',
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
	'categoryselect-code-view-placeholder' => 'Adiciona categorias aqui, exemplo: [[Categoria:Nome]]',
	'categoryselect-visual-view' => 'Modo de visionamento',
	'categoryselect-infobox-caption' => 'Opções de categoria',
	'categoryselect-infobox-category' => 'Introduza o nome da categoria:',
	'categoryselect-infobox-sortkey' => 'Na página da categoria "$1", listar esta página na posição do nome:',
	'categoryselect-addcategory-button' => 'Adicionar categoria',
	'categoryselect-addcategory-edit' => 'Adicionar uma categoria',
	'categoryselect-suggest-hint' => 'Pressione Enter quando tiver acabado',
	'categoryselect-tooltip' => "'''Novo!''' Barra de ferramentas de categorização. Experimente-a ou consulte a [[Help:CategorySelect|ajuda]] para saber mais",
	'categoryselect-unhandled-syntax' => 'Foi detectada sintaxe que não pode ser tratada - não é possível voltar ao modo de visionamento.',
	'categoryselect-edit-summary' => 'A adicionar categorias',
	'categoryselect-empty-name' => 'Introduza o nome da categoria (a parte antes de |)',
	'categoryselect-button-save' => 'Gravar',
	'categoryselect-button-cancel' => 'Cancelar',
	'categoryselect-error-not-exist' => 'A página [id=$1] não existe.',
	'categoryselect-error-user-rights' => 'Erro de permissões.',
	'categoryselect-error-db-locked' => 'A base de dados está trancada.',
	'categoryselect-edit-abort' => 'A alteração que tentou fazer foi abortada pelo hook de uma extensão',
	'tog-disablecategoryselect' => 'Desligar o módulo de Categorias (aplica-se apenas se a edição em modo visual tiver sido desativada)',
	'tog-disablecategoryselect-v2' => 'Desligar o módulo de Categorias (aplica-se apenas se a edição em modo visual estiver desativada)',
);

/** Brazilian Portuguese (português do Brasil)
 * @author 555
 * @author Aristóbulo
 * @author Giro720
 * @author Jesielt
 */
$messages['pt-br'] = array(
	'categoryselect-desc' => 'Disponibiliza uma interface para a administração de categorias de uma página sem que seja necessário editá-lo por inteiro',
	'categoryselect-code-view' => 'Ver em modo de código',
	'categoryselect-visual-view' => 'Exibição visual',
	'categoryselect-infobox-caption' => 'Opções de categoria',
	'categoryselect-infobox-category' => 'Dê o nome da categoria:',
	'categoryselect-infobox-sortkey' => 'Classifique este artigo na categoria "$1" com o nome de:',
	'categoryselect-addcategory-button' => 'Adicione uma categoria',
	'categoryselect-addcategory-edit' => 'Adicionar uma categoria',
	'categoryselect-suggest-hint' => 'Pressione "Enter" depois de digitar',
	'categoryselect-tooltip' => "'''Novidade!''' Barra de ferramentas para a aplicação de categorias. Experimente ou veja a [[Help:CategorySelect|página de ajuda]] para aprender mais",
	'categoryselect-unhandled-syntax' => 'Sintaxe não manipulada detectada - impossível voltar ao modo visual.',
	'categoryselect-edit-summary' => 'Adicionando categorias',
	'categoryselect-empty-name' => 'Coloque o nome da categoria (parte anterior a I)',
	'categoryselect-button-save' => 'Salvar',
	'categoryselect-button-cancel' => 'Cancelar',
	'categoryselect-error-not-exist' => 'O artigo [id=$1] não existe.',
	'categoryselect-error-user-rights' => 'Erro nos direitos de usuário.',
	'categoryselect-error-db-locked' => 'O banco de dados está bloqueado.',
	'categoryselect-edit-abort' => "A alteração que você tentou fazer foi abortada pelo ''hook'' de uma extensão",
	'tog-disablecategoryselect' => 'Desabilitar os botões de aplicação de categoria',
);

/** Romanian (română)
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'categoryselect-code-view' => 'Vizualizare cod',
	'categoryselect-visual-view' => 'Vizualizare vizuală',
	'categoryselect-infobox-caption' => 'Opţiuni categorie',
	'categoryselect-infobox-category' => 'Furnizaţi numele categoriei:',
	'categoryselect-addcategory-button' => 'Adaugă categorie',
	'categoryselect-suggest-hint' => 'Apasă Enter când aţi terminat',
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
	'categoryselect-code-view-placeholder' => 'Укажите тут категорию, например, [[Категория:Название]].',
	'categoryselect-visual-view' => 'Визуальный просмотр',
	'categoryselect-infobox-caption' => 'Настройки категории',
	'categoryselect-infobox-category' => 'Укажите имя категории:',
	'categoryselect-infobox-sortkey' => 'Приводить эту статью на странице категории «$1» под следующем именем:',
	'categoryselect-addcategory-button' => 'Добавить категорию',
	'categoryselect-addcategory-edit' => 'Добавить категорию',
	'categoryselect-suggest-hint' => 'Нажмите Enter, когда закончите',
	'categoryselect-tooltip' => "'''Новое!''' Панель категоризации. Попробуйте. Подробнее см. в [[Help:CategorySelect|справке]]",
	'categoryselect-unhandled-syntax' => 'Обнаружен неподдерживаемый синтаксис — невозможно вернуть назад к наглядному режиму.',
	'categoryselect-edit-summary' => 'Добавление категорий',
	'categoryselect-empty-name' => 'Укажите название категории (часть до |)',
	'categoryselect-button-save' => 'Сохранить',
	'categoryselect-button-cancel' => 'Отмена',
	'categoryselect-error-not-exist' => 'Статья [id=$1] не существует.',
	'categoryselect-error-user-rights' => 'Ошибка прав участника.',
	'categoryselect-error-db-locked' => 'База данных заблокирована.',
	'categoryselect-edit-abort' => 'Изменение, которые вы пытались сделать, прервано обработчиком расширения',
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
	'categoryselect-infobox-caption' => 'Поставке категорије',
	'categoryselect-infobox-category' => 'Унесите име категорије:',
	'categoryselect-addcategory-button' => 'Додај категорију',
	'categoryselect-suggest-hint' => 'Притисните Enter када завршите.',
	'categoryselect-edit-summary' => 'Додавање категорија',
	'categoryselect-button-save' => 'Сачувај',
	'categoryselect-button-cancel' => 'Откажи',
	'categoryselect-error-not-exist' => 'Чланак [id=$1] не постоји.',
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
	'categoryselect-code-view-placeholder' => 'Lägg till kategorier här, t.ex. [[Category:Name]]',
	'categoryselect-visual-view' => 'Visuell vy',
	'categoryselect-infobox-caption' => 'Kategori-alternativ',
	'categoryselect-infobox-category' => 'Ge namnet på kategorin:',
	'categoryselect-infobox-sortkey' => 'Alfabetisera denna artikel på kategorin "$1" under namnet:',
	'categoryselect-addcategory-button' => 'Lägg till kategori',
	'categoryselect-addcategory-edit' => 'Lägg till en kategori',
	'categoryselect-suggest-hint' => 'Tryck Enter när du är klar',
	'categoryselect-tooltip' => "'''Nytt!''' Verktygsfält för kategoritaggning. Prova den eller se [[Help:CategorySelect|hjälp]] för att läsa mer",
	'categoryselect-unhandled-syntax' => 'Ohanterad syntax upptäcktes - omöjligt att växla tillbaka till visuellt läge.',
	'categoryselect-edit-summary' => 'Lägg till kategorier',
	'categoryselect-empty-name' => 'Ange kategorinamn (del innan |)',
	'categoryselect-button-save' => 'Spara',
	'categoryselect-button-cancel' => 'Avbryt',
	'categoryselect-error-not-exist' => 'Artikel [id=$1] finns inte.',
	'categoryselect-error-user-rights' => 'Fel om användarrättigheter.',
	'categoryselect-error-db-locked' => 'Databasen är låst.',
	'categoryselect-edit-abort' => 'Ändringen du försökte göra avbröts av en förlängningskrok',
	'tog-disablecategoryselect' => 'Inaktivera kategorimodul (gäller endast om redigering i visuellt läge har inaktiverats)',
	'tog-disablecategoryselect-v2' => 'Inaktivera kategorimodulen (gäller endast om det visuella redigeringsläget är inaktiverat)',
);

/** Swahili (Kiswahili) */
$messages['sw'] = array(
	'categoryselect-button-save' => 'Hifadhi',
	'categoryselect-button-cancel' => 'Batilisha',
);

/** Telugu (తెలుగు)
 * @author Praveen Illa
 * @author Veeven
 */
$messages['te'] = array(
	'categoryselect-infobox-caption' => 'వర్గాల ఎంపికలు',
	'categoryselect-addcategory-button' => 'వర్గాన్ని చేర్చండి',
	'categoryselect-addcategory-edit' => 'ఒక వర్గాన్ని చేర్చండి',
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
	'categoryselect-code-view-placeholder' => 'Dito magdagdag ng mga kategorya, halimbawa na ang [[Category:Name|Kategorya:Pangalan]]',
	'categoryselect-visual-view' => 'Tanawing nakikita',
	'categoryselect-infobox-caption' => 'Mga mapagpipilian ng kategorya',
	'categoryselect-infobox-category' => 'Ibigay ang pangalan ng kategorya',
	'categoryselect-infobox-sortkey' => 'Gawing naka-abakada ang artikulong ito sa pahina ng kategoryang "$1" sa ilalim ng pangalang:',
	'categoryselect-addcategory-button' => 'Idagdag ang kategorya',
	'categoryselect-addcategory-edit' => 'Magdagdag ng isang kategorya',
	'categoryselect-suggest-hint' => 'Pindutin ang Ipasok pagkatapos',
	'categoryselect-tooltip' => "'''Bago!''' Kahon ng kasangkapan na pantatak ng Kategorya. Subukan ito o tingnan ang [[Help:CategorySelect|tulong]] upang makaalam pa ng marami",
	'categoryselect-unhandled-syntax' => 'Nakapuna ng hindi nahahawakang sintaks - hindi maaari ang pagbabalik sa modalidad na natatanaw.',
	'categoryselect-edit-summary' => 'Idinaragdag ang mga kategorya',
	'categoryselect-empty-name' => 'Ibigay ang pangalan ng kategorya (bahagi bago ang |)',
	'categoryselect-button-save' => 'Sagipin',
	'categoryselect-button-cancel' => 'Huwag ituloy',
	'categoryselect-error-not-exist' => 'Hindi umiiral ang artikulong [id=$1].',
	'categoryselect-error-user-rights' => 'Kamalian sa mga karapatan ng tagagamit.',
	'categoryselect-error-db-locked' => 'Nakakandado ang kalipunan ng dato',
	'categoryselect-edit-abort' => 'Ang pagbabagong sinubok mong gawin ay pinigil ng isang kawil ng dugtong',
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
	'categoryselect-addcategory-button' => 'Kategori ekle',
	'categoryselect-button-save' => 'Kaydet',
	'categoryselect-button-cancel' => 'İptal',
);

/** Tatar (Cyrillic script) (татарча)
 * @author Zahidulla
 */
$messages['tt-cyrl'] = array(
	'categoryselect-code-view' => 'Кодны карау',
	'categoryselect-visual-view' => 'Визуаль карау',
	'categoryselect-infobox-caption' => 'Төркемнәр көйләнмәләре',
	'categoryselect-addcategory-button' => 'Төркем өстәргә',
	'categoryselect-suggest-hint' => 'Тәмамлагач Enter-га басыгыз',
	'categoryselect-edit-summary' => 'Төркемнәр өстәү',
	'categoryselect-button-save' => 'Сакларга',
	'categoryselect-button-cancel' => 'Кире кагу',
	'categoryselect-error-not-exist' => '[id=$1] мәкаләсе юк.',
	'categoryselect-error-db-locked' => 'Мәгълүматлар базасы тыелган',
);

/** Ukrainian (українська)
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'categoryselect-desc' => 'Забезпечує інтерфейс для управління категоріями у статті без редагування всієї статті.',
	'categoryselect-code-view' => 'Перегляд коду',
	'categoryselect-infobox-caption' => 'Параметри категорії',
	'categoryselect-infobox-category' => 'Вкажіть назву категорії:',
	'categoryselect-infobox-sortkey' => 'Включити ключ сортування цієї статті в категорії "$1" за наступною назвою/параметром:',
	'categoryselect-addcategory-button' => 'Додати категорію',
	'categoryselect-suggest-hint' => 'Натисніть Enter, коли закінчите',
	'categoryselect-edit-summary' => 'Додавання категорій',
	'categoryselect-empty-name' => 'Введіть назву категорії (частину до |)',
	'categoryselect-button-save' => 'Зберегти',
	'categoryselect-button-cancel' => 'Скасувати',
	'categoryselect-error-not-exist' => 'Статті [id=$1] не існує.',
	'categoryselect-error-user-rights' => 'Помилка прав користувача.',
);

/** Urdu (اردو) */
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
	'categoryselect-code-view-placeholder' => 'Chèn thể loại tại đây, ví dụ [[Category:Name]]',
	'categoryselect-visual-view' => 'Xem trực quan',
	'categoryselect-infobox-caption' => 'Tùy chọn thể loại',
	'categoryselect-infobox-category' => 'Cung cấp tên thể loại:',
	'categoryselect-infobox-sortkey' => 'Sắp xếp theo bảng chữ cái bài biết này trên trang thể loại "$1" dưới tên:',
	'categoryselect-addcategory-button' => 'Chèn thể loại',
	'categoryselect-addcategory-edit' => 'Chèn thể loại',
	'categoryselect-suggest-hint' => 'Nhấn Enter khi thực hiện xong',
	'categoryselect-tooltip' => "'''Mới!''' Thể loại gắn trên thanh công cụ. Hãy xem thử hoặc vào trang [[Help:CategorySelect|trợ giúp]] để tìm hiểu thêm",
	'categoryselect-unhandled-syntax' => 'Chưa xử lý cú pháp phức tạp - không thể trở về chế độ trực quan.',
	'categoryselect-edit-summary' => 'Thêm thể loại',
	'categoryselect-empty-name' => 'Cung cấp tên thể loại (phần trước dấu |)',
	'categoryselect-button-save' => 'Lưu',
	'categoryselect-button-cancel' => 'Hủy bỏ',
	'categoryselect-error-not-exist' => 'Bài viết [id = $1] không tồn tại.',
	'categoryselect-error-user-rights' => 'Lỗi quyền người dùng.',
	'categoryselect-error-db-locked' => 'Cơ sở dữ liệu bị khóa.',
	'categoryselect-edit-abort' => 'Sửa đổi bạn cố gắng thực hiện đã bị hủy bỏ bởi một móc phần mở rộng',
	'tog-disablecategoryselect' => 'Vô hiệu hóa mô-đun Thể loại (chỉ áp dụng khi sửa đổi trong chế độ trực quan đã bị vô hiệu)',
	'tog-disablecategoryselect-v2' => 'Vô hiệu hóa bản Thể loại (chỉ áp dụng khi sửa đổi ở chế độ trực quan bị vô hiệu hoá)',
);

/** Wu (吴语) */
$messages['wuu'] = array(
	'categoryselect-button-cancel' => '取消',
);

/** Chinese (中文) */
$messages['zh'] = array(
	'categoryselect-infobox-caption' => '分類選項',
	'categoryselect-infobox-category' => '分類的名稱',
	'categoryselect-infobox-sortkey' => '此文章在"$1"分類中使用以下的名義排序:',
	'categoryselect-addcategory-button' => '增加分類',
	'categoryselect-suggest-hint' => '完成時請鍵入＜ＥＮＴＥＲ＞',
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
	'categoryselect-code-view-placeholder' => '在此添加分类，例如[[Category:名称]]',
	'categoryselect-visual-view' => '预览视图',
	'categoryselect-infobox-category' => '输入类别的名称：',
	'categoryselect-addcategory-button' => '添加分类',
	'categoryselect-addcategory-edit' => '添加分类',
	'categoryselect-suggest-hint' => '完成时按Enter键',
	'categoryselect-edit-summary' => '添加分类',
	'categoryselect-button-save' => '保存',
	'categoryselect-button-cancel' => '取消',
	'categoryselect-error-not-exist' => '条目：[id=$1]不存在。',
	'categoryselect-error-user-rights' => '用户权限错误。',
	'categoryselect-error-db-locked' => '数据库已锁定。',
);

/** Traditional Chinese (中文（繁體）‎)
 * @author Ffaarr
 */
$messages['zh-hant'] = array(
	'categoryselect-infobox-caption' => '分類選項',
	'categoryselect-infobox-category' => '提供的分類的名稱：',
	'categoryselect-addcategory-button' => '增加分類',
	'categoryselect-addcategory-edit' => '增加一個分類',
	'categoryselect-suggest-hint' => '完成時按 Enter',
	'categoryselect-edit-summary' => '增加分類',
	'categoryselect-button-save' => '儲存',
	'categoryselect-button-cancel' => '取消',
	'categoryselect-error-not-exist' => '文章 [id = $1 ] 不存在。',
	'categoryselect-error-user-rights' => '用戶權限錯誤。',
	'categoryselect-error-db-locked' => '資料庫已鎖定。',
);

