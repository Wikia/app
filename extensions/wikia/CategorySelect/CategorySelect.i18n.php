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

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named CategorySelect.\n";
	exit(1) ;
}

$messages = array(
	'en' => array(
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
		'tog-disablecategoryselect' => 'Disable Category Tagging'
	),
	'fi' => array(
		'categoryselect-code-view' => 'Näytä koodi',
		'categoryselect-visual-view' => 'Näytä visuaalisena',
		'categoryselect-infobox-caption' => 'Luokan asetukset',
		'categoryselect-infobox-category' => 'Syötä luokan nimi:',
		'categoryselect-infobox-sortkey' => 'Aakkosta tämä artikkeli "$1" luokkasivulle nimellä:',
		'categoryselect-addcategory-button' => 'Lisää luokka',
		'categoryselect-suggest-hint' => 'Paina Enter, kun olet valmis',
		'categoryselect-tooltip' => "'''Uutuus!''' Luokan lisäystyökalurivi. Testaa sitä tai katso [[Ohje:CategorySelect|ohje]] saadaksesi lisätietoa.",
		'categoryselect-unhandled-syntax' => 'Käsittelemätön syntaksi havaittu - visuaalisen moodin takaisin kytkentä on mahdotonta.',
		'categoryselect-edit-summary' => 'Luokkien lisääminen',
		'categoryselect-empty-name' => 'Syötä luokan nimi (osaa ennen |)',
		'categoryselect-button-save' => 'Tallenna',
		'categoryselect-button-cancel' => 'Peruuta',
		'tog-disablecategoryselect' => 'peru luokkien lisäys'
	)
);


$messages['de'] = array(
	'categoryselect-code-view' => 'Quelltext',
	'categoryselect-visual-view' => 'Grafische Ansicht',
	'categoryselect-infobox-caption' => 'Kategorie-Optionen',
	'categoryselect-infobox-category' => 'Gib den Namen der Kategorie an:',
	'categoryselect-infobox-sortkey' => 'Ordne diesen Artikel in der Kategorie „$1“ unter folgendem Namen ein:',
	'categoryselect-addcategory-button' => 'Kategorie hinzufügen',
	'categoryselect-suggest-hint' => 'Mit Eingabetaste beenden',
	'categoryselect-tooltip' => '\'\'\'Neu!:\'\'\' Unsere KategorieAuswahl-Leiste. Probier sie aus oder lies die [[Hilfe:KategorieAuswahl|Hilfe]] für weitere Informationen.',
	'categoryselect-unhandled-syntax' => 'Nicht unterstützte Syntax entdeckt - Wechsel in grafische Ansicht nicht möglich.',
	'categoryselect-edit-summary' => 'Kategorien hinzufügen',
	'categoryselect-empty-name' => 'Kategorie-Name (der Teil vor |)',
	'categoryselect-button-save' => 'Speichern',
	'categoryselect-button-cancel' => 'Abbrechen',
	'categoryselect-error-not-exist' => 'Der angegebene Artikel [id=$1] existiert nicht (mehr).',
	'categoryselect-error-user-rights' => 'Keine ausreichenden Benutzerrechte.',
	'categoryselect-error-db-locked' => 'Die Datenbank ist vorübergehend gesperrt.',
	'tog-disablecategoryselect' => 'Vereinfachtes Kategorisieren ausschalten',
);


$messages['es'] = array(
	'categoryselect-code-view' => 'Vista de código',
	'categoryselect-visual-view' => 'Vista visual',
	'categoryselect-infobox-caption' => 'Opciones de categoría',
	'categoryselect-infobox-category' => 'Pon el nombre de la categoría:',
	'categoryselect-infobox-sortkey' => 'Clasifica este artículo en la categoría "$1" con el nombre:',
	'categoryselect-addcategory-button' => 'Añadir categoría',
	'categoryselect-suggest-hint' => 'Presiona Enter cuando termines',
	'categoryselect-tooltip' => '\'\'\'¡Nuevo!\'\'\' Barra de etiquetas de categoría. Pruebala o échale un vistazo a [[Help:CategorySelect|ayuda]] para aprender más',
	'categoryselect-unhandled-syntax' => 'Detectada sintaxis inmanipulable - imposible cambiar al modo visual.',
	'categoryselect-edit-summary' => 'Añadiendo categorías',
	'categoryselect-empty-name' => 'Pon el nombre de la categoría (parte antes de |)',
	'categoryselect-button-save' => 'Guardar',
	'categoryselect-button-cancel' => 'Cancelar',
	'tog-disablecategoryselect' => 'Desactivar el Etiquetador de Categorías (Category Tagging)',
);


$messages['fr'] = array(
	'categoryselect-code-view' => 'Voir le code',
	'categoryselect-visual-view' => 'Vue visuelle',
	'categoryselect-infobox-caption' => 'Options de la catégorie',
	'categoryselect-infobox-category' => 'Ecrivez le nom de la catégorie :',
	'categoryselect-infobox-sortkey' => 'Mettre cet article dans la catégorie « $1 » sous le nom suivant :',
	'categoryselect-addcategory-button' => 'Ajouter des catégories',
	'categoryselect-suggest-hint' => 'Taper sur "Entrée" pour finir',
	'categoryselect-tooltip' => '\'\'\'Nouveau ! :\'\'\' Notre outil de sélection de catégorie (CatégorieSélection). Essayez le ou lisez [[w:c:aide:Aide:CatégorieSélection|l\'aide]] pour d\'autres informations.',
	'categoryselect-unhandled-syntax' => 'Il y a un problème de syntaxe inconnue. Il n\'est pas possible de changer en vue graphique.',
	'categoryselect-edit-summary' => 'Ajouter une catégorie',
	'categoryselect-empty-name' => 'Nom de la catégorie (ce qu\'on écrit devant |)',
	'categoryselect-button-save' => 'Enregistrer',
	'categoryselect-button-cancel' => 'Annuler',
	'tog-disablecategoryselect' => 'Désactiver le balisage des catégories',
);


$messages['ja'] = array(
	'categoryselect-code-view' => 'ウィキコードを表示',
	'categoryselect-visual-view' => 'ビジュアルモードで表示',
	'categoryselect-infobox-caption' => 'カテゴリのオプション',
	'categoryselect-infobox-category' => 'カテゴリ名を入力',
	'categoryselect-infobox-sortkey' => '"$1"カテゴリで記事のソートに使用する名前を入力',
	'categoryselect-addcategory-button' => 'カテゴリを追加',
	'categoryselect-suggest-hint' => 'エンターキーを押すと終了',
	'categoryselect-unhandled-syntax' => '処理できない構文が検出されました - ビジュアルモードに移行できません。',
	'categoryselect-edit-summary' => 'カテゴリを追加',
	'categoryselect-empty-name' => 'カテゴリ名を入力（"|"より前の部分）',
	'categoryselect-button-save' => '保存',
	'categoryselect-button-cancel' => '取り消し',
	'categoryselect-error-not-exist' => '記事 [id=$1] が存在しません。',
	'categoryselect-error-user-rights' => '利用者権限のエラーです。',
	'categoryselect-error-db-locked' => 'データベースがロックされています',
	'tog-disablecategoryselect' => 'カテゴリタグ付け機能を無効にする。',
);


$messages['zh'] = array(
	'categoryselect-infobox-caption' => '分類選項',
	'categoryselect-infobox-category' => '分類的名稱',
	'categoryselect-infobox-sortkey' => '此文章在"$1"分類中使用以下的名義排序:',
	'categoryselect-addcategory-button' => '增加分類',
	'categoryselect-suggest-hint' => '完成時請鍵入＜ＥＮＴＥＲ＞',
	'categoryselect-button-save' => '儲存',
	'categoryselect-button-cancel' => '取消',
);


$messages['fa'] = array(
	'categoryselect-addcategory-button' => 'افزودن رده',
	'categoryselect-suggest-hint' => 'پس از اتمام دکمه اینتر را فشار دهید',
	'categoryselect-edit-summary' => 'افزودن رده',
	'categoryselect-button-save' => 'ذخیره رده',
	'categoryselect-button-cancel' => 'لغو',
);


$messages['ru'] = array(
	'tog-disablecategoryselect' => 'Отключить Category Taging',
);
