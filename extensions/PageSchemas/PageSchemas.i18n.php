<?php

/**
 * Messages file for the PageSchemas extension
 *
 * @file
 * @ingroup Extensions
 */

/**
 * Get all extension messages
 *
 * @return array
 */
$messages = array();

$messages['en'] = array(
	'ps-desc' => 'Defines the data structure for all pages in a category using XML',
	'ps-schema-description' => 'Page schema',
	'generatepages' => 'Generate pages',
	'ps-generatepages-desc' => 'Generate the following pages, based on this category\'s schema:',
	'ps-generatepages-success' => 'The selected pages will be generated.',
	'ps-generatepages-noschema' => 'Error: There is no page schema defined for this category.',
	'ps-generatepages-editsummary' => 'Generated from a page schema',
	'ps-page-desc-cat-not-exist' => 'This category does not exist yet. Create this category and its page schema:',
	'ps-page-desc-ps-not-exist' => 'This category exists, but does not have a page schema. Create schema:',
	'ps-page-desc-edit-schema' => 'Edit the page schema for this category:',
	'ps-delimiter-label' => 'Delimiter for values (default is ","):',
	'ps-multiple-temp-label' => 'Allow multiple instances of this template',
	'ps-field-list-label' => 'This field can hold a list of values',
	'ps-template' => 'Template',
	'ps-add-template' => 'Add template',
	'ps-remove-template' => 'Remove template',
	'ps-field' => 'Field',
	'ps-namelabel' => 'Name:',
	'ps-displaylabel' => 'Display label:',
	'ps-add-field' => 'Add field',
	'ps-remove-field' => 'Remove field',
	'ps-add-xml-label' => 'Additional XML:',
	'ps-optional-name' => 'Name (leave blank to set to field name):',
	'editschema' => 'Edit schema',
	'createschema' => 'Create schema',
	'right-generatepages' => 'View "Generate pages" tab and page',
	'action-generatepages' => 'view the "Generate pages" tab and page',
);

/** Message documentation (Message documentation)
 * @author Ankit Garg
 * @author EugeneZelenko
 * @author Purodha
 * @author Raymond
 */
$messages['qqq'] = array(
	'ps-desc' => '{{desc}}',
	'ps-template' => 'A MediaWiki template',
	'ps-field' => 'A "field" here is both a template parameter and a form field',
	'ps-displaylabel' => 'The term for the text that shows up next to a field when it is displayed',
	'editschema' => 'This is a special page name.',
	'createschema' => 'This is a special page name.',
	'right-generatepages' => '{{doc-right|generatepages}}',
	'action-generatepages' => '{{doc-action|generatepages}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'ps-desc' => 'Ondersteun sjablone waarvoor die datastruktuur via XML gedefinieer is',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'ps-desc' => 'يدعم القوالب التي تعرف هيكل بياناتها من خلال علامات XML',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Dudi
 * @author Ghaly
 */
$messages['arz'] = array(
	'ps-desc' => 'بيدعم القوالب اللى بتعرّف هيكل الداتا بتاعتها عن طريق علامات XML',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Renessaince
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'ps-desc' => 'Падтрымлівае шаблёны, якія вызначаюць уласную структуру зьвестак праз XML-разьметку',
	'ps-schema-description' => 'Апісаньне схемы:',
	'generatepages' => 'Стварыць старонкі',
	'ps-generatepages-desc' => 'Стварае наступныя старонкі, зыходзячы са схемы катэгорыі:',
	'ps-generatepages-success' => 'Старонкі будуць створаныя.',
	'ps-generatepages-noschema' => 'Памылка: для гэтай катэгорыі ня вызначаная схема старонкі.',
	'ps-page-desc-cat-not-exist' => 'Гэтая катэгорыя яшчэ не існуе. Стварыць яе са схемай старонкі:',
	'ps-page-desc-ps-not-exist' => 'Гэтая катэгорыя існуе, аднак ня мае схемы старонкі. Стварыць схему:',
	'ps-page-desc-edit-schema' => 'Рэдагаваць схему старонак для гэтай катэгорыі:',
	'ps-delimiter-label' => 'Разьдзяляльнік для значэньняў (па змоўчваньні «,»):',
	'ps-multiple-temp-label' => 'Дазволіць некалькі варыянтаў гэтага шаблёну',
	'ps-field-list-label' => 'Гэтае поле можа зьмяшчаць набор значэньняў',
	'ps-template' => 'Шаблён',
	'ps-add-template' => 'Дадаць шаблён',
	'ps-remove-template' => 'Выдаліць шаблён',
	'ps-field' => 'Поле',
	'ps-displaylabel' => 'Паказваць пазнаку:',
	'ps-add-field' => 'Дадаць поле',
	'ps-remove-field' => 'Выдаліць поле',
	'ps-add-xml-label' => 'Дадатковы XML:',
	'editschema' => 'Рэдагаваць схему',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'ps-desc' => 'Skorañ a ra ar patromoù dre dermeniñ o framm roadennoù gant balizennoù XML',
	'ps-schema-description' => 'Chema ar bajenn',
	'generatepages' => 'Genel ar pajennoù',
	'ps-template' => 'Patrom',
	'ps-add-template' => 'Ouzhpennañ ur patrom',
	'ps-remove-template' => 'Lemel ur patrom',
	'ps-field' => 'Maezienn',
	'ps-namelabel' => 'Anv :',
	'ps-displaylabel' => 'Tikedenn diskwel :',
	'ps-add-field' => 'Ouzhpennañ ur vaezienn',
	'ps-remove-field' => 'Lemel ar vaezienn',
	'editschema' => 'Kemmañ ar chema',
	'createschema' => 'Krouiñ ur chema',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'ps-desc' => 'Podržava šablone koji definiraju svoju strukturu podataka preko XML opisnog jezika',
);

/** German (Deutsch)
 * @author Imre
 * @author Kghbln
 */
$messages['de'] = array(
	'ps-desc' => 'Ermöglicht, unter Verwendung von XML, das Definieren einer Datenstruktur für alle Seiten in einer Kategorie',
	'ps-schema-description' => 'Seitenschema:',
	'generatepages' => 'Seiten generieren',
	'ps-generatepages-desc' => 'Die folgenden Seiten auf Basis des Schemas dieser Kategorie generieren:',
	'ps-generatepages-success' => 'Die ausgewählten Seiten werden generiert.',
	'ps-generatepages-noschema' => 'Fehler: Es wurde kein Schema für diese Kategorie definiert.',
	'ps-generatepages-editsummary' => 'Auf Basis eines Seitenschemas generiert',
	'ps-page-desc-cat-not-exist' => 'Diese Kategorie ist noch nicht vorhanden. Erstelle diese Kategorie und ihr Schema:',
	'ps-page-desc-ps-not-exist' => 'Diese Kategorie ist vorhanden, verfügt aber noch nicht über ein Schema. Erstelle das Schema:',
	'ps-page-desc-edit-schema' => 'Bearbeite das Schema dieser Kategorie:',
	'ps-delimiter-label' => 'Trennzeichen für Werte (Standardwert ist „,“):',
	'ps-multiple-temp-label' => 'Diese Vorlage für mehrere Instanzen freigeben',
	'ps-field-list-label' => 'Dieses Feld kann eine Liste von Werten enthalten',
	'ps-template' => 'Vorlage',
	'ps-add-template' => 'Vorlage hinzufügen',
	'ps-remove-template' => 'Vorlage entfernen',
	'ps-field' => 'Feld',
	'ps-namelabel' => 'Name:',
	'ps-displaylabel' => 'Anzuzeigender Feldname:',
	'ps-add-field' => 'Feld hinzufügen',
	'ps-remove-field' => 'Feld entfernen',
	'ps-add-xml-label' => 'Zusätzliches XML:',
	'ps-optional-name' => 'Name (leer lassen, um den Feldnamen zu verwenden):',
	'editschema' => 'Schema bearbeiten',
	'createschema' => 'Schema erstellen',
	'right-generatepages' => 'Den Reiter „Seiten generieren“ sowie die entsprechende Seite sehen',
	'action-generatepages' => 'den Reiter „Seiten generieren“ sowie die entsprechende Seite zu sehen',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Kghbln
 */
$messages['de-formal'] = array(
	'ps-page-desc-cat-not-exist' => 'Diese Kategorie ist noch nicht vorhanden. Erstellen Sie diese Kategorie und ihr Schema:',
	'ps-page-desc-ps-not-exist' => 'Diese Kategorie ist vorhanden, verfügt aber noch nicht über ein Schema. Erstellen Sie das Schema:',
	'ps-page-desc-edit-schema' => 'Bearbeiten Sie das Schema dieser Kategorie:',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'ps-desc' => 'Definěrujo strukturu datow za wšykne boki w kategoriji z pomocu XML',
);

/** Greek (Ελληνικά)
 * @author Περίεργος
 */
$messages['el'] = array(
	'ps-desc' => 'Υποστηρίζει πρότυπα που καθορίζουν τη δομή των δεδομένων τους μέσω της σήμανσης XML',
);

/** Spanish (Español)
 * @author Translationista
 */
$messages['es'] = array(
	'ps-desc' => 'Admite plantillas que definen su estructura de datos a través de XML',
);

/** Finnish (Suomi)
 * @author Crt
 */
$messages['fi'] = array(
	'ps-desc' => 'Tukee mallineiden tietorakenteiden määrittelyä XML-merkkauskielen kautta.',
);

/** French (Français)
 * @author Gomoko
 * @author IAlex
 * @author PieRRoMaN
 * @author Zebulon84
 */
$messages['fr'] = array(
	'ps-desc' => 'Définit la structure des données pour toutes les pages dans une catégorie en utilisant XML',
	'ps-schema-description' => 'Schéma de la page',
	'generatepages' => 'Générer les pages',
	'ps-generatepages-desc' => "Générer les pages suivantes, d'après le schéma de cette catégorie:",
	'ps-generatepages-success' => 'Les pages sélectionnées seront générés.',
	'ps-generatepages-noschema' => "Erreur: il n'y a pas de schéma de page défini pour cette catégorie",
	'ps-generatepages-editsummary' => 'Généré depuis le schéma de page',
	'ps-page-desc-cat-not-exist' => "Cette catégorie n'existe pas encore. Créez-la avec son schéma de page:",
	'ps-page-desc-ps-not-exist' => "Cette catégorie existe, mais n'a pas de schéma de page. Créez le schéma:",
	'ps-page-desc-edit-schema' => 'Éditez le schéma de page pour cette catégorie:',
	'ps-delimiter-label' => 'Délimiteur pour les valeurs ("," par défaut):',
	'ps-multiple-temp-label' => 'Permet plusieurs instances de ce modèle',
	'ps-field-list-label' => 'Ce champ peut contenir une liste de valeurs',
	'ps-template' => 'Modèle',
	'ps-add-template' => 'Ajouter un modèle',
	'ps-remove-template' => 'Supprimer un modèle',
	'ps-field' => 'Champ',
	'ps-namelabel' => 'Nom :',
	'ps-displaylabel' => 'Afficher le libellé:',
	'ps-add-field' => 'Ajouter un champ',
	'ps-remove-field' => 'Supprimer un champ',
	'ps-add-xml-label' => 'XML supplémentaire:',
	'ps-optional-name' => 'Nom (laisser blanc pour mettre le nom du champ):',
	'editschema' => 'Modifier le schéma',
	'createschema' => 'Créer le schéma',
	'right-generatepages' => 'Afficher l\'onglet "Générer les pages" et la page',
	'action-generatepages' => "afficher la page ou l'onglet « Générer les pages »",
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'ps-desc' => 'Dèfenét la structura de les balyês por totes les pâges dens una catègorie en utilisent XML.',
	'ps-schema-description' => 'Plan de la pâge',
	'generatepages' => 'Fâre les pâges',
	'ps-generatepages-editsummary' => 'Fêt dês lo plan de pâge',
	'ps-template' => 'Modèlo',
	'ps-add-template' => 'Apondre un modèlo',
	'ps-remove-template' => 'Enlevar un modèlo',
	'ps-field' => 'Champ',
	'ps-namelabel' => 'Nom :',
	'ps-displaylabel' => 'Ètiquèta por la visualisacion :',
	'ps-add-field' => 'Apondre un champ',
	'ps-remove-field' => 'Enlevar un champ',
	'ps-add-xml-label' => 'XML de ples :',
	'editschema' => 'Changiér lo plan',
	'createschema' => 'Fâre lo plan',
);

/** Galician (Galego)
 * @author MetalBrasil
 * @author Toliño
 */
$messages['gl'] = array(
	'ps-desc' => 'Define a estrutura de datos de todas as páxinas dunha categoría mediante formato XML',
	'ps-schema-description' => 'Esquema da páxina',
	'generatepages' => 'Xerar as páxinas',
	'ps-generatepages-desc' => 'Xerar as seguintes páxinas, segundo o esquema desta categoría:',
	'ps-generatepages-success' => 'As páxinas seleccionadas van ser xeradas.',
	'ps-generatepages-noschema' => 'Erro: Non hai ningún esquema de páxina definido para esta categoría.',
	'ps-generatepages-editsummary' => 'Xerado a partir do esquema de páxina',
	'ps-page-desc-cat-not-exist' => 'Esta categoría aínda non existe. Cree esta categoría e o seu esquema de páxina:',
	'ps-page-desc-ps-not-exist' => 'A categoría existe, pero non ten un esquema de páxina. Cree o esquema:',
	'ps-page-desc-edit-schema' => 'Edite o esquema de páxina desta categoría:',
	'ps-delimiter-label' => 'Delimitador de valores (por defecto é ","):',
	'ps-multiple-temp-label' => 'Permitir varias instancias deste modelo',
	'ps-field-list-label' => 'Este campo pode conter unha lista de valores',
	'ps-template' => 'Modelo',
	'ps-add-template' => 'Engadir un modelo',
	'ps-remove-template' => 'Eliminar un modelo',
	'ps-field' => 'Campo',
	'ps-namelabel' => 'Nome:',
	'ps-displaylabel' => 'Mostrar a etiqueta:',
	'ps-add-field' => 'Engadir un campo',
	'ps-remove-field' => 'Eliminar un campo',
	'ps-add-xml-label' => 'XML adicional:',
	'ps-optional-name' => 'Nome (déixeo en branco para definir o nome do campo):',
	'editschema' => 'Editar o esquema',
	'createschema' => 'Crear o esquema',
	'right-generatepages' => 'Ollar a lapela e a páxina "Xerar as páxinas"',
	'action-generatepages' => 'ollar a lapela e a páxina "Xerar as páxinas"',
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'ps-desc' => 'Definiert d Datestruktur für alli Syte inere Kategori, wo XML bruuche',
	'ps-schema-description' => 'Syteschema:',
	'generatepages' => 'Syte generiere',
	'ps-generatepages-desc' => 'Die Syte, wo folge, uff Basis vum Schema vo dere Kategori generiere',
	'ps-generatepages-success' => 'Die Syte, wo ussgwäält sin, werde generiert.',
	'ps-generatepages-noschema' => 'Fääler: Für die Kategori isch kei Schema definiert.',
	'ps-generatepages-editsummary' => 'Uff Basis vum Schema, wo folgt, generiert',
	'ps-page-desc-cat-not-exist' => "Die Kategorie git's no nit. Die Kategori un ihr Schema erstelle:",
	'ps-template' => 'Vorlag',
	'ps-add-template' => 'Vorlag zuefiege',
	'ps-remove-template' => 'Vorlag usenee',
	'ps-field' => 'Fäld',
	'ps-namelabel' => 'Name:',
	'ps-add-field' => 'Fieg Fäld yy',
	'ps-remove-field' => 'Fäld uusenee',
	'ps-add-xml-label' => 'Zuesätzlichs XML:',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author YaronSh
 */
$messages['he'] = array(
	'ps-desc' => 'הגדרת מבני נתונים לכל הדפים בקטגוריה באמצעות XML',
	'generatepages' => 'יצירת דפים',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'ps-desc' => 'Definuje datowu strukturu za wšě strony w kategoriji z pomocu XML',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'ps-desc' => 'Lehetővé teszi, hogy a sablonok XML-jelölőnyelv segítségével definiálják az adatstruktúrájukat',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'ps-desc' => 'Defini le structura de datos pro tote le paginas in un categoria usante XML',
	'ps-schema-description' => 'Schema de pagina',
	'generatepages' => 'Generar paginas',
	'ps-generatepages-desc' => 'Generar le sequente paginas a base del schema de iste categoria:',
	'ps-generatepages-success' => 'Le paginas seligite essera generate.',
	'ps-generatepages-noschema' => 'Error: Il non ha un schema de pagina definite pro iste categoria.',
	'ps-generatepages-editsummary' => 'Generate ab un schema de pagina',
	'ps-page-desc-cat-not-exist' => 'Iste categoria non existe ancora. Crea iste categoria e su schema de pagina:',
	'ps-page-desc-ps-not-exist' => 'Iste categoria existe, ma non ha un schema de pagina. Crea le schema:',
	'ps-page-desc-edit-schema' => 'Modifica le schema de pagina pro iste categoria:',
	'ps-delimiter-label' => 'Delimitator pro valores (predefinition es ","):',
	'ps-multiple-temp-label' => 'Permitter plure instantias de iste patrono',
	'ps-field-list-label' => 'Iste campo pote tener un lista de valores',
	'ps-template' => 'Patrono',
	'ps-add-template' => 'Adder patrono',
	'ps-remove-template' => 'Remover patrono',
	'ps-field' => 'Campo',
	'ps-namelabel' => 'Nomine:',
	'ps-displaylabel' => 'Etiquetta pro monstrar:',
	'ps-add-field' => 'Adder campo',
	'ps-remove-field' => 'Remover campo',
	'ps-add-xml-label' => 'Additional XML:',
	'ps-optional-name' => 'Nomine (lassar vacue pro definir como le nomine del campo):',
	'editschema' => 'Modificar schema',
	'createschema' => 'Crear schema',
	'right-generatepages' => 'Vider le scheda e pagina "Generar paginas"',
	'action-generatepages' => 'vider le scheda e pagina "Generar paginas"',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 */
$messages['id'] = array(
	'ps-desc' => 'Mendukung templat untuk dapat mendefinisikan struktur data mereka melalui markah XML',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'ps-desc' => 'Në nyé ike maka mkpurụ ihü, në nyé úchè maka ázú omárí ha nke shi édé XML',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author Schu
 */
$messages['ja'] = array(
	'ps-desc' => 'XML マークアップによってデータ構造を定義するテンプレートをサポートします。',
	'ps-schema-description' => 'スキーマの説明：',
	'generatepages' => 'ページを生成',
	'ps-generatepages-desc' => 'このカテゴリのスキーマに基づいて、次のページを生成',
	'ps-generatepages-success' => 'ページが生成されます。',
	'ps-generatepages-noschema' => 'エラー：このカテゴリに定義されているページのスキーマはありません。',
	'ps-page-desc-cat-not-exist' => 'このカテゴリはまだ存在しません。このカテゴリとそのページのスキーマを作成します。',
	'ps-page-desc-ps-not-exist' => 'このカテゴリは存在しますが、ページのスキーマを持っていません。スキーマを作成：',
	'ps-page-desc-edit-schema' => 'このカテゴリのページのスキーマを編集：',
	'ps-delimiter-label' => '値の区切り文字 (デフォルトは "," )：',
	'ps-multiple-temp-label' => 'このテンプレートの複数のインスタンスを許可',
	'ps-field-list-label' => 'このフィールドは、値のリストを保持することができます',
	'ps-template' => 'テンプレート',
	'ps-add-template' => 'テンプレートを追加',
	'ps-remove-template' => 'テンプレートを削除',
	'ps-field' => 'フィールド',
	'ps-displaylabel' => '表示ラベル：',
	'ps-add-field' => 'フィールドを追加',
	'ps-remove-field' => 'フィールドを削除',
	'ps-add-xml-label' => '追加のXML：',
	'editschema' => 'スキーマを編集',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'ps-desc' => 'Ongerschtöz, dat mer de Dateschtruktur vun Schablone övver en <i lang="en">XML</i> Fommaat beschrieve kann.',
	'ps-schema-description' => 'Dat XML-Schema beschrevve:',
	'generatepages' => 'Sigge automattesch aanlääje',
	'ps-generatepages-desc' => 'Donn de Sigge en dä Leß heh automattesch aanlääje, noh dämm XML-Schema för di Saachjropp:',
	'ps-generatepages-success' => 'Di Sigge wääde automattesch aanjelaat.',
	'ps-generatepages-noschema' => 'Fähler: Mer han kei XML-Schema för di Saachjropp.',
	'ps-page-desc-cat-not-exist' => 'Di Saachjropp jidd_et noch nit. Donn di Jropp aanlääje un e Schema för dä ier Siggg:',
	'ps-page-desc-ps-not-exist' => 'Heh di Saachjropp jidd_et, ävver se hät kei XML-Schema. Donn ein aanlääje:',
	'ps-page-desc-edit-schema' => 'Donn dat XML-Schema för di Saachjropp ändere:',
	'ps-field-list-label' => 'En däm Feld kann en Leß met Wääte shtonn',
	'ps-template' => 'Schabloon',
	'ps-add-template' => 'Donn en Schabloon dobei',
	'ps-remove-template' => 'Maach di Schabloon fott',
	'ps-field' => 'Väld',
	'ps-add-field' => 'Donn e Feld dobei',
	'ps-remove-field' => 'Nemm dat  Feld fott',
	'ps-add-xml-label' => 'Zohsäzlesh XML:',
	'ps-optional-name' => 'Dä Name — kam_mer läddesch lohße, dann ess_et automattesch dä Name vun däm Feld:',
	'editschema' => 'Et Schema ändere',
	'createschema' => 'E XML-Schema aanlääje',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'ps-desc' => "Definéiert d'Date-Struktur per XML fir all Säiten an enger Kategorie",
	'ps-schema-description' => 'Schema vun der Säit',
	'generatepages' => 'Säite generéieren',
	'ps-generatepages-desc' => 'Dës Säiten op der Basis vum Schema vun dëser Kategorie generéieren:',
	'ps-generatepages-success' => 'Déi erausgesichte Säite gi generéiert.',
	'ps-generatepages-noschema' => 'Feeler: et ass kee Säite-Schema fir dës Kategorie definéiert',
	'ps-generatepages-editsummary' => 'Generéiert op Basis vum Säite-Schema',
	'ps-page-desc-cat-not-exist' => 'Dës Kategorie gëtt et nach net. Leet dës Kategorie an hire Säite-Schema un:',
	'ps-page-desc-ps-not-exist' => 'Dës Kategorie gëtt et, awer si huet nach kee Säite-Schema. Leet de Schema un:',
	'ps-page-desc-edit-schema' => 'De Säite-Schema fir dës Kategorie änneren:',
	'ps-multiple-temp-label' => 'Méi Instanze vun dësem Schema zouloossen',
	'ps-field-list-label' => 'An dësem Feld kann eng Lëscht vu Wäerter stoen',
	'ps-template' => 'Schabloun',
	'ps-add-template' => 'Schabloun derbäisetzen',
	'ps-remove-template' => 'Schablon ewechhuelen',
	'ps-field' => 'Feld',
	'ps-namelabel' => 'Numm:',
	'ps-displaylabel' => 'Etiquette weisen:',
	'ps-add-field' => 'Feld derbäisetzen',
	'ps-remove-field' => 'Feld ewechhuelen',
	'ps-add-xml-label' => 'Zousätzlechen XML:',
	'ps-optional-name' => 'Numm (eidel loosse fir den Numm vum Feld ze benotzen):',
	'editschema' => 'Schema änneren',
	'createschema' => 'Schema uleeën',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'ps-desc' => 'Ја определува податочната структура на сите страници во една категорија користејќи XML',
	'ps-schema-description' => 'Шемата на страници',
	'generatepages' => 'Создај страници',
	'ps-generatepages-desc' => 'Создај ги следниве страници врз основа на шемата на категоријата:',
	'ps-generatepages-success' => 'Избраните страници ќе бидат создадени.',
	'ps-generatepages-noschema' => 'Грешка: оваа категорија нема определена шема на страници',
	'ps-generatepages-editsummary' => 'Создадено од шемата на страницата',
	'ps-page-desc-cat-not-exist' => 'Оваа категорија сè уште не постои. Создај ја категоријата и нејзината шема на страници:',
	'ps-page-desc-ps-not-exist' => 'Оваа категорија постои, но нема шема на страници. Создај шема:',
	'ps-page-desc-edit-schema' => 'Уреди ја шемата на страници за оваа категорија:',
	'ps-delimiter-label' => 'Одделвач за вредности (стандардниот е „,“):',
	'ps-multiple-temp-label' => 'Дозволи повеќе примероци на овој шаблон',
	'ps-field-list-label' => 'Ова поле може да содржи список на вредности',
	'ps-template' => 'Шаблон',
	'ps-add-template' => 'Додај шаблон',
	'ps-remove-template' => 'Отстрани шаблон',
	'ps-field' => 'Поле',
	'ps-namelabel' => 'Име:',
	'ps-displaylabel' => 'Натпис за приказ:',
	'ps-add-field' => 'Додај поле',
	'ps-remove-field' => 'Отстрани поле',
	'ps-add-xml-label' => 'Дополнителен XML:',
	'ps-optional-name' => 'Име (оставете празно за да биде како името на полето):',
	'editschema' => 'Уреди шема',
	'createschema' => 'Создај шема',
	'right-generatepages' => 'Јазичето „Создај страници“ и неговата страница',
	'action-generatepages' => 'приказ на јазичето „Создај страници“ и неговата страница',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'ps-desc' => 'Støtter maler som definerer datastrukturen sin gjennom XML-markering',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'ps-desc' => "Bepaalt de gegevensstructuur van alle pagina's in een categorie via XML",
	'ps-schema-description' => 'Paginaschema',
	'generatepages' => "Pagina's aanmaken",
	'ps-generatepages-desc' => "Maak de volgende pagina's aan, gebaseerd op dit categorieschema:",
	'ps-generatepages-success' => "De geselecteerde pagina's worden aangemaakt.",
	'ps-generatepages-noschema' => 'Fout: Er is geen paginaschema voor deze categorie.',
	'ps-generatepages-editsummary' => 'Aangemaakt vanuit een paginaschema',
	'ps-page-desc-cat-not-exist' => 'Deze categorie bestaat nog niet. Maak deze categorie en het bijbehorende paginaschema aan:',
	'ps-page-desc-ps-not-exist' => 'Deze categorie bestaat, maar heeft geen paginaschema. Maak het paginaschema aan:',
	'ps-page-desc-edit-schema' => 'Bewerkt het paginaschema voor deze categorie:',
	'ps-delimiter-label' => 'Scheidingsteken voor waarden (standaard ","):',
	'ps-multiple-temp-label' => 'Meerdere exemplaren van dit sjabloon toestaan',
	'ps-field-list-label' => 'Dit veld kan een lijst met waarden bevatten',
	'ps-template' => 'Sjabloon',
	'ps-add-template' => 'Sjabloon toevoegen',
	'ps-remove-template' => 'Sjabloon verwijderen',
	'ps-field' => 'Veld',
	'ps-namelabel' => 'Naam:',
	'ps-displaylabel' => 'Label weergeven:',
	'ps-add-field' => 'Veld toevoegen',
	'ps-remove-field' => 'Veld verwijderen',
	'ps-add-xml-label' => 'Extra XML:',
	'ps-optional-name' => 'Naam (laat leeg om in te stellen op de veldnaam):',
	'editschema' => 'Schema bewerken',
	'createschema' => 'Schema aanmaken',
	'right-generatepages' => 'Mag het tabblad en de pagina "Pagina\'s aanmaken" zijn',
	'action-generatepages' => 'het tabblad en de pagina "Pagina\'s aanmaken" te zien',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'ps-desc' => 'Støttar malar som definerer datastrukturen sin gjennom XML-markering.',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'ps-desc' => 'Supòrta los modèls en definissent lor estructura de donadas via de balisas XML',
);

/** Polish (Polski)
 * @author Sp5uhe
 * @author Woytecr
 */
$messages['pl'] = array(
	'ps-desc' => 'Obsługa definiowania struktury szablonów z wykorzystaniem znaczników XML',
	'ps-delimiter-label' => 'Separator wartości (domyślnie „,”)',
	'ps-template' => 'Szablon',
	'ps-add-template' => 'Dodaj szablon',
	'ps-remove-template' => 'Usuń szablon',
	'ps-field' => 'Pole',
	'ps-namelabel' => 'Nazwa',
	'ps-displaylabel' => 'Wyświetlana etykieta',
	'ps-add-field' => 'Dodaj pole',
	'ps-remove-field' => 'Usuń pole',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'ps-desc' => "A manten jë stamp ch'a definisso soa strutura dij dat via markup XML",
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'ps-desc' => 'Permite criar modelos, cuja estrutura de dados é definida através de uma notação XML',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Daemorris
 */
$messages['pt-br'] = array(
	'ps-desc' => 'Suporta predefinições definindo suas estruturas de dados via marcação XML',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'ps-desc' => "Definisce le strutture de le date pe tutte le pàggene jndr'à 'na categorije ausanne l'XML",
	'ps-schema-description' => "Schema d'a pàgene",
	'ps-template' => 'Template',
	'ps-add-template' => "Aggiunge 'u template",
	'ps-remove-template' => "Live 'u template",
	'ps-field' => 'Cambe',
);

/** Russian (Русский)
 * @author Eleferen
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'ps-desc' => 'Определяет структуру данных для всех страниц в категории с помощью XML',
	'ps-schema-description' => 'Схема страницы',
	'generatepages' => 'Создание страниц',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'ps-desc' => 'Opredeljuje zgradbo podatkov vseh strani v kategoriji z uporabo XML',
	'ps-schema-description' => 'Shema strani',
	'generatepages' => 'Ustvari strani',
	'ps-generatepages-desc' => 'Ustvari naslednje strani, temelječe na shemi te kategorije:',
	'ps-generatepages-success' => 'Ustvarjene bodo naslednje strani.',
	'ps-generatepages-noschema' => 'Napaka: Kategorija nima določene sheme strani.',
	'ps-generatepages-editsummary' => 'Ustvarjeno iz sheme strani',
	'ps-page-desc-cat-not-exist' => 'Ta kategorija še ne obstaja. Ustvarite kategorijo in njeno shemo strani:',
	'ps-page-desc-ps-not-exist' => 'Ta kategorija obstaja, vendar nima sheme strani. Ustvarite shemo:',
	'ps-page-desc-edit-schema' => 'Uredi shemo strani te kategorije:',
	'ps-delimiter-label' => 'Ločilo vrednosti (privzeto je »,«):',
	'ps-multiple-temp-label' => 'Dovoli več primerkov predloge',
	'ps-field-list-label' => 'Polje lahko vsebuje seznam vrednosti',
	'ps-template' => 'Predloga',
	'ps-add-template' => 'Dodaj predlogo',
	'ps-remove-template' => 'Odstrani predlogo',
	'ps-field' => 'Polje',
	'ps-namelabel' => 'Ime:',
	'ps-displaylabel' => 'Prikaži oznako:',
	'ps-add-field' => 'Dodaj polje',
	'ps-remove-field' => 'Odstrani polje',
	'ps-add-xml-label' => 'Dodatni XML:',
	'ps-optional-name' => 'Ime (pustite prazno, da nastavite na ime polje):',
	'editschema' => 'Uredi shemo',
	'createschema' => 'Ustvarite shemo',
	'right-generatepages' => 'Ogled zavihka in strani »Ustvari strani«',
	'action-generatepages' => 'ogled zavihka in strani »Ustvari strani«',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'ps-desc' => 'Одређује структуру података за све странице у категорији користећи XML',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬) */
$messages['sr-el'] = array(
	'ps-desc' => 'Određuje strukturu podataka za sve stranice u kategoriji koristeći XML',
);

/** Swedish (Svenska)
 * @author Per
 */
$messages['sv'] = array(
	'ps-desc' => 'Stödjer mallar som definierar datastrukturen med XML-markering',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'ps-desc' => 'Tumatangkilik sa mga suleras na nagbibigay kahulugan sa kanilang kayarian ng dato sa pamamagitan ng pagmarkang XML',
);

/** Turkish (Türkçe)
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'ps-desc' => 'XML işaretlemesi ile veri yapılarını tanımlayan şablonları destekler',
);

/** Ukrainian (Українська)
 * @author NickK
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'ps-desc' => 'Підтримує визначення структури даних шаблонів за допомогою розмітки XML',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'ps-desc' => 'Cho phép định nghĩa cấu trúc dữ liệu của bản mẫu dùng mã XML',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Chenxiaoqino
 */
$messages['zh-hans'] = array(
	'ps-desc' => '支持的模版已将其数据结构用XML代码声明。',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'ps-desc' => '支援的模版已將其資料結構用 XML 代碼聲明。',
);

