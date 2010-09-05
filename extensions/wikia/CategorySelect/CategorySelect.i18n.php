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
	'categoryselect-visual-view' => 'Visual view',
	'categoryselect-infobox-caption' => 'Category options',
	'categoryselect-infobox-category' => 'Provide the name of the category:',
	'categoryselect-infobox-sortkey' => 'Alphabetize this article on the "$1" category page under the name:',
	'categoryselect-addcategory-button' => 'Add category',
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
	'tog-disablecategoryselect' => 'Disable Category Tagging'
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'categoryselect-button-save' => '{{Identical|Save}}',
	'categoryselect-button-cancel' => '{{Identical|Cancel}}',
	'categoryselect-desc' => '{{desc}}',
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

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'categoryselect-button-cancel' => 'Cancelar',
);

/** Arabic (العربية)
 * @author Achraf94
 */
$messages['ar'] = array(
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
	'categoryselect-desc' => 'يوفر واجهة لإدارة التصنيفات في مقالة دون تعديل كامل المقالة',
	'categoryselect-edit-abort' => 'التعديل الذي تحاول أن تقوم به أجهض من قبل تمديد هوك',
	'tog-disablecategoryselect' => 'تعطيل وسم التصنيفات',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'categoryselect-button-save' => 'Захаваць',
	'categoryselect-button-cancel' => 'Адмяніць',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'categoryselect-button-save' => 'Съхраняване',
);

/** Breton (Brezhoneg)
 * @author Gwenn-Ael
 * @author Y-M D
 */
$messages['br'] = array(
	'categoryselect-code-view' => "Gwelet ar c'hod",
	'categoryselect-visual-view' => 'Sell dre gwelet',
	'categoryselect-infobox-caption' => 'Dibarzhioù ar rummad',
	'categoryselect-infobox-category' => 'Roit anv ar rummad :',
	'categoryselect-infobox-sortkey' => 'Lakaat ar pennad-mañ er rummad "$1" dindan an anv da-heul :',
	'categoryselect-addcategory-button' => 'Ouzhpennañ rummadoù',
	'categoryselect-suggest-hint' => 'Pouezit war "Enter" evit echuiñ',
	'categoryselect-tooltip' => "'''Nevez!''' Barenn ostilhoù evit diuzañ rummadoù. Amprouit anezhi pe lennit [[Help:CategorySelect|ar sikour]] evit gouzout hiroc'h",
	'categoryselect-unhandled-syntax' => "Ur gudenn ereadurezh dianav zo. Ne c'haller ket kemmañ  e gwel grafek.",
	'categoryselect-edit-summary' => 'Ouzhpennañ ur rummad',
	'categoryselect-empty-name' => 'Reiñ a ra anv ar rummad (al lodenn skrivet a-raok |)',
	'categoryselect-button-save' => 'Enrollañ',
	'categoryselect-button-cancel' => 'Nullañ',
	'categoryselect-error-not-exist' => "N'eus ket eus ar pennad [id=$1].",
	'categoryselect-error-user-rights' => 'Fazi en aotreoù implijerien.',
	'categoryselect-error-db-locked' => 'Stanket eo ar bank roadennoù',
	'categoryselect-desc' => 'a bourchas un etrefas evit gallout merañ rummadoù ur pennad hep ma vefe ezhomm da voullañ ar pennad a-bezh.',
	'categoryselect-edit-abort' => "Ar c'hemm ho peus klask ober zo bet ehanet gant ur c'hrog astenn.",
	'tog-disablecategoryselect' => 'Diweredekaat balizadur ar rummadoù',
);

/** Sorani (کوردی) */
$messages['ckb'] = array(
	'categoryselect-button-save' => 'پاشەکەوت',
);

/** German (Deutsch)
 * @author LWChris
 */
$messages['de'] = array(
	'categoryselect-code-view' => 'Quelltext',
	'categoryselect-visual-view' => 'Grafische Ansicht',
	'categoryselect-infobox-caption' => 'Kategorie-Optionen',
	'categoryselect-infobox-category' => 'Gib den Namen der Kategorie an:',
	'categoryselect-infobox-sortkey' => 'Ordne diesen Artikel in der Kategorie „$1“ unter folgendem Namen ein:',
	'categoryselect-addcategory-button' => 'Kategorie hinzufügen',
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
	'categoryselect-desc' => 'Stellt eine Oberfläche zur Verwaltung der Kategorien in einem Artikel ohne Bearbeitung des ganzen Artikels zur Verfügung.',
	'categoryselect-edit-abort' => 'Deine versuchte Änderung wurde durch ein Aufhängen einer Erweiterung abgebrochen',
	'tog-disablecategoryselect' => 'Vereinfachtes Kategorisieren ausschalten',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author LWChris
 */
$messages['de-formal'] = array(
	'categoryselect-infobox-category' => 'Geben Sie den Namen der Kategorie an:',
	'categoryselect-tooltip' => "'''Neu!''' Unsere Kategorieauswahl-Leiste. Probieren Sie sie aus oder lesen Sie die [[Help:KategorieAuswahl|Hilfe]] für weitere Informationen",
	'categoryselect-edit-abort' => 'Ihre versuchte Änderung wurde durch ein Aufhängen einer Erweiterung abgebrochen',
);

/** Greek (Ελληνικά)
 * @author Crazymadlover
 */
$messages['el'] = array(
	'categoryselect-button-cancel' => 'Ακύρωση',
);

/** Spanish (Español)
 * @author Pertile
 * @author Translationista
 */
$messages['es'] = array(
	'categoryselect-code-view' => 'Vista de código',
	'categoryselect-visual-view' => 'Vista visual',
	'categoryselect-infobox-caption' => 'Opciones de categoría',
	'categoryselect-infobox-category' => 'Pon el nombre de la categoría:',
	'categoryselect-infobox-sortkey' => 'Clasifica este artículo en la categoría "$1" con el nombre:',
	'categoryselect-addcategory-button' => 'Añadir categoría',
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
	'categoryselect-desc' => 'Proporciona una interfaz para gestionar las categorías de los artículos sin editar todo el artículo.',
	'categoryselect-edit-abort' => 'La modificación que ha intentado realizar fue abortada por un gancho de extensión',
	'tog-disablecategoryselect' => 'Desactivar el Etiquetador de Categorías (Category Tagging)',
);

/** Persian (فارسی) */
$messages['fa'] = array(
	'categoryselect-addcategory-button' => 'افزودن رده',
	'categoryselect-suggest-hint' => 'پس از اتمام دکمه اینتر را فشار دهید',
	'categoryselect-edit-summary' => 'افزودن رده',
	'categoryselect-button-save' => 'ذخیره رده',
	'categoryselect-button-cancel' => 'لغو',
);

/** Finnish (Suomi)
 * @author Crt
 */
$messages['fi'] = array(
	'categoryselect-code-view' => 'Näytä koodi',
	'categoryselect-visual-view' => 'Näytä visuaalisena',
	'categoryselect-infobox-caption' => 'Luokan asetukset',
	'categoryselect-infobox-category' => 'Syötä luokan nimi:',
	'categoryselect-infobox-sortkey' => 'Aakkosta tämä artikkeli "$1" luokkasivulle nimellä:',
	'categoryselect-addcategory-button' => 'Lisää luokka',
	'categoryselect-suggest-hint' => 'Paina Enter, kun olet valmis',
	'categoryselect-tooltip' => "'''Uusi!''' Luokan lisäystyökalurivi. Testaa sitä tai katso [[Help:CategorySelect|ohjesta]] lisätietoa.",
	'categoryselect-unhandled-syntax' => 'Käsittelemätön syntaksi havaittu - visuaalisen moodin takaisin kytkentä on mahdotonta.',
	'categoryselect-edit-summary' => 'Luokkien lisääminen',
	'categoryselect-empty-name' => 'Syötä luokan nimi (osa ennen |)',
	'categoryselect-button-save' => 'Tallenna',
	'categoryselect-button-cancel' => 'Peruuta',
	'tog-disablecategoryselect' => 'peru luokkien lisäys',
);

/** French (Français)
 * @author IAlex
 * @author Peter17
 */
$messages['fr'] = array(
	'categoryselect-code-view' => 'Voir le code',
	'categoryselect-visual-view' => 'Vue visuelle',
	'categoryselect-infobox-caption' => 'Options de la catégorie',
	'categoryselect-infobox-category' => 'Ecrivez le nom de la catégorie :',
	'categoryselect-infobox-sortkey' => 'Mettre cet article dans la catégorie « $1 » sous le nom suivant :',
	'categoryselect-addcategory-button' => 'Ajouter des catégories',
	'categoryselect-suggest-hint' => 'Taper sur "Entrée" pour finir',
	'categoryselect-tooltip' => "'''Nouveau ! :''' Barre d'outils de sélection de catégorie. Essayez-la ou lisez [[Help:CategorySelect|l'aide]] pour en apprendre plus.",
	'categoryselect-unhandled-syntax' => "Il y a un problème de syntaxe inconnue. Il n'est pas possible de changer en vue graphique.",
	'categoryselect-edit-summary' => 'Ajouter une catégorie',
	'categoryselect-empty-name' => "Nom de la catégorie (ce qu'on écrit devant |)",
	'categoryselect-button-save' => 'Enregistrer',
	'categoryselect-button-cancel' => 'Annuler',
	'categoryselect-error-not-exist' => "L'article [id=$1] n'existe pas.",
	'categoryselect-error-user-rights' => "Erreur de droits d'utilisateurs.",
	'categoryselect-error-db-locked' => 'La base de données est verrouillée.',
	'categoryselect-desc' => "Fournit une interface permettant de gérer les catégories d'un article sans avoir à éditer tout l'article.",
	'categoryselect-edit-abort' => "La modification que vous avez essayé de faire a été arrêtée par un crochet d'une extension",
	'tog-disablecategoryselect' => 'Désactiver le balisage des catégories',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'categoryselect-code-view' => 'Vista do código',
	'categoryselect-visual-view' => 'Vista visual',
	'categoryselect-infobox-caption' => 'Opcións de categoría',
	'categoryselect-infobox-category' => 'Escriba o nome da categoría:',
	'categoryselect-infobox-sortkey' => 'Clasificar este artigo na categoría "$1" co nome:',
	'categoryselect-addcategory-button' => 'Engadir a categoría',
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
	'categoryselect-desc' => 'Proporciona unha interface para xestionar as categorías dos artigos sen editar todo o artigo.',
	'categoryselect-edit-abort' => 'O hook da extensión abortou a modificación que intentou realizar',
	'tog-disablecategoryselect' => 'Desactivar a etiquetaxe de categorías',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'categoryselect-button-cancel' => 'Soke',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'categoryselect-code-view' => 'Kódnézet',
	'categoryselect-visual-view' => 'Grafikus nézet',
	'categoryselect-infobox-caption' => 'Kategóriabeállítások',
	'categoryselect-addcategory-button' => 'Kategória hozzáadása',
	'categoryselect-edit-summary' => 'Kategóriák hozzáadása',
	'categoryselect-button-save' => 'Mentés',
	'categoryselect-button-cancel' => 'Mégse',
	'categoryselect-error-user-rights' => 'Felhasználói jog hiba.',
	'categoryselect-error-db-locked' => 'Az adatbázis zárolva.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'categoryselect-code-view' => 'Vista de codice',
	'categoryselect-visual-view' => 'Vista graphic',
	'categoryselect-infobox-caption' => 'Optiones de categoria',
	'categoryselect-infobox-category' => 'Entra le nomine del categoria:',
	'categoryselect-infobox-sortkey' => 'Alphabetisar iste articulo in le categoria "$1" sub le nomine:',
	'categoryselect-addcategory-button' => 'Adder categoria',
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
	'categoryselect-desc' => 'Provide un interfacie pro gerer le categorias in un articulo sin modificar tote le articulo.',
	'categoryselect-edit-abort' => 'Le modification que tu tentava facer ha essite abortate per un extension.',
	'tog-disablecategoryselect' => 'Disactivar selection de categorias',
);

/** Indonesian (Bahasa Indonesia)
 * @author Irwangatot
 */
$messages['id'] = array(
	'categoryselect-code-view' => 'Tampilan kode',
	'categoryselect-visual-view' => 'Tampilan visual',
	'categoryselect-infobox-caption' => 'Pilihan kategori',
	'categoryselect-infobox-category' => 'Memberikan nama kategori:',
	'categoryselect-infobox-sortkey' => 'Penyusunan artikel ini menurut abjad pada kategori "$1" dengan nama:',
	'categoryselect-addcategory-button' => 'Menambah kategori',
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
	'categoryselect-desc' => 'Menyediakan sebuah antarmuka untuk mengelola kategori dalam artikel tanpa mengedit seluruh artikel.',
	'categoryselect-edit-abort' => 'Perubahan yang coba Anda lakukan dibatalkan oleh suatu ekstensi kaitan.',
	'tog-disablecategoryselect' => 'Nonaktifkan Kategori Tagging',
);

/** Igbo (Igbo) */
$messages['ig'] = array(
	'categoryselect-button-save' => 'Donyéré',
	'categoryselect-button-cancel' => 'Emekwàlà',
);

/** Italian (Italiano) */
$messages['it'] = array(
	'categoryselect-addcategory-button' => 'Aggiungi categoria',
	'categoryselect-button-save' => 'Salva',
	'categoryselect-button-cancel' => 'Annulla',
	'categoryselect-error-db-locked' => 'Database bloccato.',
);

/** Japanese (日本語)
 * @author Tommy6
 */
$messages['ja'] = array(
	'categoryselect-code-view' => 'ウィキコードを表示',
	'categoryselect-visual-view' => 'ビジュアルモードで表示',
	'categoryselect-infobox-caption' => 'カテゴリのオプション',
	'categoryselect-infobox-category' => 'カテゴリ名を入力',
	'categoryselect-infobox-sortkey' => '"$1"カテゴリで記事のソートに使用する名前を入力',
	'categoryselect-addcategory-button' => 'カテゴリを追加',
	'categoryselect-suggest-hint' => 'エンターキーを押すと終了',
	'categoryselect-tooltip' => "''New!''' カテゴリタギングツールバー。詳しくは[[Help:カテゴリセレクト|ヘルプ]]を参照してください。",
	'categoryselect-unhandled-syntax' => '処理できない構文が検出されました - ビジュアルモードに移行できません。',
	'categoryselect-edit-summary' => 'カテゴリを追加',
	'categoryselect-empty-name' => 'カテゴリ名を入力（"|"より前の部分）',
	'categoryselect-button-save' => '保存',
	'categoryselect-button-cancel' => '取り消し',
	'categoryselect-error-not-exist' => '記事 [id=$1] が存在しません。',
	'categoryselect-error-user-rights' => '利用者権限のエラーです。',
	'categoryselect-error-db-locked' => 'データベースがロックされています',
	'categoryselect-desc' => '記事を編集することなくカテゴリを操作するためのインターフェースを提供する',
	'categoryselect-edit-abort' => 'システムにより変更が中断されました',
	'tog-disablecategoryselect' => 'カテゴリタグ付け機能を無効にする',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'categoryselect-addcategory-button' => 'Kategorie derbäisetzen',
	'categoryselect-edit-summary' => 'Kategorien derbäisetzen',
	'categoryselect-button-save' => 'Späicheren',
	'categoryselect-button-cancel' => 'Ofbriechen',
	'categoryselect-error-not-exist' => 'Den Artikel [id=$1] gëtt et net.',
	'categoryselect-error-db-locked' => "D'Datebank ass gespaart.",
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'categoryselect-code-view' => 'Коден изглед',
	'categoryselect-visual-view' => 'Визуелен изглед',
	'categoryselect-infobox-caption' => 'Нагодувања за категории',
	'categoryselect-infobox-category' => 'Наведете го името на категоријата:',
	'categoryselect-infobox-sortkey' => 'Азбучно заведи ја статијава во категоријата „$1“ под името:',
	'categoryselect-addcategory-button' => 'Додај категорија',
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
	'categoryselect-desc' => 'Дава посредник за раководење со категориите во една статија без да треба да се уредува целата статија.',
	'categoryselect-edit-abort' => 'Измените кои се обидовте да ги направите се откажани од кука за додатоци',
	'tog-disablecategoryselect' => 'Оневозможи означување на категории',
);

/** Dutch (Nederlands)
 * @author McDutchie
 * @author Siebrand
 */
$messages['nl'] = array(
	'categoryselect-code-view' => 'Wikitekstweergave',
	'categoryselect-visual-view' => 'Visuele weergave',
	'categoryselect-infobox-caption' => 'Categoriemogelijkheden',
	'categoryselect-infobox-category' => 'Geef de naam van een categorie op:',
	'categoryselect-infobox-sortkey' => 'Rangschik deze pagina in de categoriepagina "$1" onder:',
	'categoryselect-addcategory-button' => 'Categorie toevoegen',
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
	'categoryselect-desc' => 'Biedt een interface voor het beheren van categorieën in een pagina zonder de hele pagina te bewerken.',
	'categoryselect-edit-abort' => 'De wijziging die u probeerde te maken is afgebroken door een uitbreidingshook',
	'tog-disablecategoryselect' => 'Categorielabels uitschakelen',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'categoryselect-code-view' => 'Kodevisning',
	'categoryselect-visual-view' => 'Visuell visning',
	'categoryselect-infobox-caption' => 'Kategorivalg',
	'categoryselect-infobox-category' => 'Oppgi navnet på kategorien:',
	'categoryselect-infobox-sortkey' => 'Alfabetiser denne artikkelen under kategorisiden «$1» under navnet:',
	'categoryselect-addcategory-button' => 'Legg til kategori',
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
	'categoryselect-desc' => 'Tilbyr et grensesnitt for håndtering av kategorier i artikler uten å redigere hele artikkelen.',
	'categoryselect-edit-abort' => 'Endringene du prøvde å utføre ble avbrutt av en utvidelseskrok',
	'tog-disablecategoryselect' => 'Deaktiver kategorimerking',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'categoryselect-code-view' => 'Visualisé ël còdes',
	'categoryselect-visual-view' => 'Visualisassion visual',
	'categoryselect-infobox-caption' => 'Opsion ëd categorìa',
	'categoryselect-infobox-category' => 'Dà ël nòm ëd la categorìa',
	'categoryselect-infobox-sortkey' => 'Buté st\'artìcol-sì ant la pàgina ëd categorìa "$1" an órdin alfabétich sota ël nòm:',
	'categoryselect-addcategory-button' => 'Gionta categorìa',
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
	'categoryselect-desc' => "A dà n'antërfacia për gestì categorìe ant j'artìcoj sensa modifiché tut l'artìcol.",
	'categoryselect-edit-abort' => "La modìfica ch'it l'has provà a fé a l'é stàita abortìa da n'agancc ëd n'estension",
	'tog-disablecategoryselect' => 'Disabìlita etichëtté categorìe',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'categoryselect-addcategory-button' => 'وېشنيزه ورګډول',
	'categoryselect-button-save' => 'خوندي کول',
	'categoryselect-button-cancel' => 'ناګارل',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'categoryselect-code-view' => 'Modo de código',
	'categoryselect-visual-view' => 'Modo de visionamento',
	'categoryselect-infobox-caption' => 'Opções de categoria',
	'categoryselect-infobox-category' => 'Introduza o nome da categoria:',
	'categoryselect-infobox-sortkey' => 'Na página da categoria "$1", listar esta página na posição do nome:',
	'categoryselect-addcategory-button' => 'Adicionar categoria',
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
	'categoryselect-desc' => 'Fornece uma interface para gerir as categorias de um artigo sem editar o artigo completo.',
	'categoryselect-edit-abort' => 'A alteração que tentou fazer foi abortada pelo hook de uma extensão',
	'tog-disablecategoryselect' => 'Desligar a Categorização',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 * @author Jesielt
 */
$messages['pt-br'] = array(
	'categoryselect-code-view' => 'Ver em modo de código',
	'categoryselect-visual-view' => 'Ver botões',
	'categoryselect-infobox-caption' => 'Opções de categoria',
	'categoryselect-infobox-category' => 'Dê o nome da categoria:',
	'categoryselect-infobox-sortkey' => 'Classifique este artigo na categoria "$1" com o nome de:',
	'categoryselect-addcategory-button' => 'Adicione uma categoria',
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
	'categoryselect-desc' => 'Disponibiliza uma interface para a administração de categorias em um artigo sem necessitar editar o artigo todo.',
	'categoryselect-edit-abort' => "A alteração que você tentou fazer foi abortada pelo ''hook'' de uma extensão",
	'tog-disablecategoryselect' => 'Desabilitar os botões de aplicação de categoria',
);

/** Russian (Русский)
 * @author Lockal
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'categoryselect-code-view' => 'Просмотр кода',
	'categoryselect-visual-view' => 'Визуальный просмотр',
	'categoryselect-infobox-caption' => 'Настройки категории',
	'categoryselect-infobox-category' => 'Укажите имя категории:',
	'categoryselect-infobox-sortkey' => 'Приводить эту статью на странице категории «$1» под следующем именем:',
	'categoryselect-addcategory-button' => 'Добавить категорию',
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
	'categoryselect-desc' => 'Предоставляет интерфейс для управления категориями в статье без редактирования всей статьи.',
	'categoryselect-edit-abort' => 'Изменение, которые вы пытались сделать, прервано обработчиком расширения',
	'tog-disablecategoryselect' => 'Отключить Category Taging',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Verlor
 */
$messages['sr-ec'] = array(
	'categoryselect-code-view' => 'Кодни преглед',
	'categoryselect-visual-view' => 'Визуални преглед',
	'categoryselect-infobox-category' => 'Дајте име категорији:',
	'categoryselect-addcategory-button' => 'Додај категорију',
	'categoryselect-suggest-hint' => 'Стисните ЕНТЕР када завршите.',
	'categoryselect-edit-summary' => 'Додавање категорија',
	'categoryselect-button-save' => 'Сачувај',
	'categoryselect-button-cancel' => 'Одустани',
	'categoryselect-error-not-exist' => 'Чланак [id=$1] не постоји.',
	'categoryselect-error-user-rights' => 'Грешка у корисничким правима',
	'categoryselect-error-db-locked' => 'База података је закључана',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'categoryselect-button-save' => 'భద్రపరచు',
	'categoryselect-button-cancel' => 'రద్దుచేయి',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'categoryselect-code-view' => 'Tingin sa kodigo',
	'categoryselect-visual-view' => 'Tanawing nakikita',
	'categoryselect-infobox-caption' => 'Mga mapagpipilian ng kategorya',
	'categoryselect-infobox-category' => 'Ibigay ang pangalan ng kategorya',
	'categoryselect-infobox-sortkey' => 'Gawing naka-abakada ang artikulong ito sa pahina ng kategoryang "$1" sa ilalim ng pangalang:',
	'categoryselect-addcategory-button' => 'Idagdag ang kategorya',
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
	'categoryselect-desc' => 'Nagbibigay ng isang hangganang-mukha para sa pamamahala ng mga kategorya sa loob ng artikulo na hindi binabago ang buong artikulo.',
	'categoryselect-edit-abort' => 'Ang pagbabagong sinubok mong gawin ay pinigil ng isang kawil ng dugtong',
	'tog-disablecategoryselect' => 'Huwag Paganahin ang Pagtatatak ng Kategorya',
);

/** Ukrainian (Українська)
 * @author Prima klasy4na
 */
$messages['uk'] = array(
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
	'categoryselect-desc' => 'Забезпечує інтерфейс для управління категоріями у статті без редагування всієї статті.',
);

/** Urdu (اردو) */
$messages['ur'] = array(
	'categoryselect-button-cancel' => 'منسوخ',
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

