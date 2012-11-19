<?php
$messages = array();

/** English
 * @author Trevor Parscal
 */
$messages['en'] = array(
	'visualeditor' => 'VisualEditor',
	'visualeditor-desc' => 'Visual editor for MediaWiki',
	'visualeditor-preference-enable' => 'Enable VisualEditor (main namespace only)',
	'visualeditor-notification-saved' => 'Your changes to $1 have been saved.',
	'visualeditor-notification-created' => '$1 has been created.',
	'visualeditor-ca-editsource' => 'Edit source',
	'visualeditor-linkinspector-title' => 'Hyperlink',
	'visualeditor-linkinspector-label-pagetitle' => 'Page title',
	'visualeditor-linkinspector-suggest-existing-page' => 'Existing page',
	'visualeditor-linkinspector-suggest-new-page' => 'New page',
	'visualeditor-linkinspector-suggest-external-link' => 'Web link',
	'visualeditor-formatdropdown-title' => 'Change format',
	'visualeditor-formatdropdown-format-paragraph' => 'Paragraph',
	'visualeditor-formatdropdown-format-heading1' => 'Heading 1',
	'visualeditor-formatdropdown-format-heading2' => 'Heading 2',
	'visualeditor-formatdropdown-format-heading3' => 'Heading 3',
	'visualeditor-formatdropdown-format-heading4' => 'Heading 4',
	'visualeditor-formatdropdown-format-heading5' => 'Heading 5',
	'visualeditor-formatdropdown-format-heading6' => 'Heading 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Preformatted',
	'visualeditor-annotationbutton-bold-tooltip' => 'Bold',
	'visualeditor-annotationbutton-italic-tooltip' => 'Italic',
	'visualeditor-annotationbutton-link-tooltip' => 'Link',
	'visualeditor-indentationbutton-indent-tooltip' => 'Increase indentation',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Decrease indentation',
	'visualeditor-listbutton-number-tooltip' => 'Numbered list',
	'visualeditor-listbutton-bullet-tooltip' => 'Bullet list',
	'visualeditor-clearbutton-tooltip' => 'Clear formatting',
	'visualeditor-historybutton-undo-tooltip' => 'Undo',
	'visualeditor-historybutton-redo-tooltip' => 'Redo',
	'visualeditor-viewpage-savewarning' => 'Are you sure you want to go back to view mode without saving first?',
	'visualeditor-loadwarning' => 'Error loading data from server: $1. Would you like to retry?',
	'visualeditor-saveerror' => 'Error saving data to server: $1.',
	'visualeditor-editsummary' => 'Describe what you changed',
	'visualeditor-aliennode-tooltip' => 'Sorry, this element cannot be edited using the VisualEditor',
);

/** Message documentation (Message documentation)
 * @author Amire80
 * @author Erik Moeller
 * @author Jdforrester
 * @author Nike
 * @author Purodha
 * @author Trevor Parscal
 */
$messages['qqq'] = array(
	'visualeditor' => 'The name of the VisualEditor extension',
	'visualeditor-desc' => '{{desc}}',
	'visualeditor-feedback-prompt' => 'A link that opens feedback form in http://www.mediawiki.org/wiki/Special:VisualEditorSandbox',
	'visualeditor-notification-saved' => '$1 is a page name.',
	'visualeditor-notification-created' => '$1 is a page name.',
	'visualeditor-ca-editsource' => 'Text for the edit source link in the tab dropdown',
	'visualeditor-linkinspector-title' => 'Title of the link inspector dialog', # Fuzzy
	'visualeditor-linkinspector-label-pagetitle' => 'Label for the text field that holds the link target in the link inspector',
	'visualeditor-formatdropdown-title' => 'This is a tooltip for the drop-down box for choosing the formatting style of the selected text, such as "Heading 1", "Heading 2" or "Plain text". (This is not related to "file format" or "data format", such as "Wikitext", "HTML", "PDF" etc.)',
	'visualeditor-formatdropdown-format-paragraph' => 'Item in the formatting dropdown for paragraphs (normal text)',
	'visualeditor-formatdropdown-format-heading1' => 'Item in the formatting dropdown for a level 1 heading',
	'visualeditor-formatdropdown-format-heading2' => 'Item in the formatting dropdown for a level 2 heading',
	'visualeditor-formatdropdown-format-heading3' => 'Item in the formatting dropdown for a level 3 heading',
	'visualeditor-formatdropdown-format-heading4' => 'Item in the formatting dropdown for a level 4 heading',
	'visualeditor-formatdropdown-format-heading5' => 'Item in the formatting dropdown for a level 5 heading',
	'visualeditor-formatdropdown-format-heading6' => 'Item in the formatting dropdown for a level 6 heading',
	'visualeditor-formatdropdown-format-preformatted' => 'Item in the formatting dropdown for preformatted text',
	'visualeditor-annotationbutton-bold-tooltip' => 'Tooltip for the bold button',
	'visualeditor-annotationbutton-italic-tooltip' => 'Tooltip for the italic button',
	'visualeditor-annotationbutton-link-tooltip' => 'Tooltip for the link button',
	'visualeditor-indentationbutton-indent-tooltip' => 'Tooltip for the list indent button',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Tooltip for the list outdent button',
	'visualeditor-listbutton-number-tooltip' => 'Tooltip for the numbered list button',
	'visualeditor-listbutton-bullet-tooltip' => 'Tooltip for the bullet list button',
	'visualeditor-clearbutton-tooltip' => 'Tooltip for the clear formatting button',
	'visualeditor-historybutton-undo-tooltip' => 'Tooltip for the undo button',
	'visualeditor-historybutton-redo-tooltip' => 'Tooltip for the redo button',
	'visualeditor-viewpage-savewarning' => 'Text shown when the user tries to leave the editor without saving their changes',
	'visualeditor-loadwarning' => 'Text shown when the editor fails to load properly. $1 is the error message from the server, in English.',
	'visualeditor-saveerror' => 'Text shown when the editor fails to save properly. $1 is an error message, in English.',
);

/** Assamese (অসমীয়া)
 * @author Bishnu Saikia
 */
$messages['as'] = array(
	'visualeditor-formatdropdown-format-paragraph' => 'দফা',
	'visualeditor-formatdropdown-format-heading1' => 'শিৰোনাম ১',
	'visualeditor-formatdropdown-format-heading2' => 'শিৰোনাম ২',
	'visualeditor-formatdropdown-format-heading3' => 'শিৰোনাম ৩',
	'visualeditor-formatdropdown-format-heading4' => 'শিৰোনাম ৪',
	'visualeditor-formatdropdown-format-heading5' => 'শিৰোনাম ৫',
	'visualeditor-formatdropdown-format-heading6' => 'শিৰোনাম ৬',
	'visualeditor-annotationbutton-bold-tooltip' => 'গাঢ়',
	'visualeditor-annotationbutton-italic-tooltip' => 'হেলনীয়া',
	'visualeditor-annotationbutton-link-tooltip' => 'সংযোগ',
	'visualeditor-historybutton-undo-tooltip' => 'পূৰ্ববত কৰক',
);

/** Asturian (asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'visualeditor' => 'VisualEditor',
	'visualeditor-desc' => 'Editor visual pa MediaWiki',
	'visualeditor-preference-enable' => "Activar l'editor visual (sólo nel espaciu de nomes principal)",
	'visualeditor-notification-saved' => 'Se guardaron los cambeos fechos en "$1".',
	'visualeditor-notification-created' => 'Creóse "$1".',
	'visualeditor-ca-editsource' => 'Editar la fonte',
	'visualeditor-linkinspector-title' => 'Hiperenllaz',
	'visualeditor-linkinspector-label-pagetitle' => 'Títulu de la páxina',
	'visualeditor-linkinspector-suggest-existing-page' => 'Páxina esistente',
	'visualeditor-linkinspector-suggest-new-page' => 'Páxina nueva',
	'visualeditor-linkinspector-suggest-external-link' => 'Enllaz web',
	'visualeditor-formatdropdown-title' => 'Cambiar de formatu',
	'visualeditor-formatdropdown-format-paragraph' => 'Párrafu',
	'visualeditor-formatdropdown-format-heading1' => 'Testera 1',
	'visualeditor-formatdropdown-format-heading2' => 'Testera 2',
	'visualeditor-formatdropdown-format-heading3' => 'Testera 3',
	'visualeditor-formatdropdown-format-heading4' => 'Testera 4',
	'visualeditor-formatdropdown-format-heading5' => 'Testera 5',
	'visualeditor-formatdropdown-format-heading6' => 'Testera 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Con formatu previu',
	'visualeditor-annotationbutton-bold-tooltip' => 'Negrina',
	'visualeditor-annotationbutton-italic-tooltip' => 'Cursiva',
	'visualeditor-annotationbutton-link-tooltip' => 'Enllaz',
	'visualeditor-indentationbutton-indent-tooltip' => 'Aumentar la sangría',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Disminuir la sangría',
	'visualeditor-listbutton-number-tooltip' => 'Llista numberada',
	'visualeditor-listbutton-bullet-tooltip' => 'Llista con viñetes',
	'visualeditor-clearbutton-tooltip' => 'Quitar el formatu',
	'visualeditor-historybutton-undo-tooltip' => 'Desfacer',
	'visualeditor-historybutton-redo-tooltip' => 'Volver a facer',
	'visualeditor-viewpage-savewarning' => '¿Seguro que quies volver al mou de visualización ensin guardar primero?',
	'visualeditor-loadwarning' => "Error al cargar los datos dende'l sirvidor: $1. ¿Quies volver a intentalo?",
	'visualeditor-saveerror' => 'Error al guardar los datos nel sirvidor: $1.',
	'visualeditor-editsummary' => 'Describi lo que camudasti',
);

/** Bashkir (башҡортса)
 * @author Haqmar
 */
$messages['ba'] = array(
	'visualeditor' => 'VisualEditor',
	'visualeditor-desc' => 'MediaWiki өсөн визуаль мөхәррирләгес',
	'visualeditor-feedback-prompt' => 'Фекерегеҙҙе беледерегеҙ',
	'visualeditor-feedback-dialog-title' => 'VisualEditor ҡомлоғо тураһында үҙ фекерегеҙҙе белдерегеҙ',
	'visualeditor-ca-editsource' => 'Сығанаҡты мөхәррирләргә',
	'visualeditor-linkinspector-title' => 'Һылтанманы мөхәррирләргә', # Fuzzy
	'visualeditor-linkinspector-label-pagetitle' => 'Бит исеме',
	'visualeditor-formatdropdown-title' => 'Форматты үҙгәртергә',
	'visualeditor-formatdropdown-format-paragraph' => 'Параграф',
	'visualeditor-formatdropdown-format-heading1' => 'Башлыҡ 1',
	'visualeditor-formatdropdown-format-heading2' => 'Башлыҡ 2',
	'visualeditor-formatdropdown-format-heading3' => 'Башлыҡ 3',
	'visualeditor-formatdropdown-format-heading4' => 'Башлыҡ 4',
	'visualeditor-formatdropdown-format-heading5' => 'Башлыҡ 5',
	'visualeditor-formatdropdown-format-heading6' => 'Башлыҡ 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Әҙер формат',
	'visualeditor-annotationbutton-bold-tooltip' => 'Ҡалын',
	'visualeditor-annotationbutton-italic-tooltip' => 'Ҡыя',
	'visualeditor-annotationbutton-link-tooltip' => 'Һылтанма',
);

/** Belarusian (Taraškievica orthography) (беларуская (тарашкевіца)‎)
 * @author EugeneZelenko
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'visualeditor' => 'Візуальны рэдактар',
	'visualeditor-desc' => 'Візуальны рэдактар для MediaWiki',
	'visualeditor-preference-enable' => 'Уключыць візуальны рэдактар (толькі ў асноўнай прасторы)',
	'visualeditor-feedback-prompt' => 'Пакінуць водгук',
	'visualeditor-feedback-dialog-title' => 'Пакіньце водгук пра візуальны рэдактар',
	'visualeditor-notification-saved' => 'Вашыя зьмены ў «$1» захаваныя.',
	'visualeditor-notification-created' => 'Старонка «$1» створаная.',
	'visualeditor-ca-editsource' => 'Рэдагаваць крыніцу',
	'visualeditor-linkinspector-title' => 'Гіпэрспасылка',
	'visualeditor-linkinspector-label-pagetitle' => 'Назва старонкі',
	'visualeditor-linkinspector-suggest-existing-page' => 'Існуючая старонка',
	'visualeditor-linkinspector-suggest-new-page' => 'Новая старонка',
	'visualeditor-linkinspector-suggest-external-link' => 'Вэб-спасылка',
	'visualeditor-formatdropdown-title' => 'Зьмяніць фарматаваньне',
	'visualeditor-formatdropdown-format-paragraph' => 'Параграф',
	'visualeditor-formatdropdown-format-heading1' => 'Загаловак 1',
	'visualeditor-formatdropdown-format-heading2' => 'Загаловак 2',
	'visualeditor-formatdropdown-format-heading3' => 'Загаловак 3',
	'visualeditor-formatdropdown-format-heading4' => 'Загаловак 4',
	'visualeditor-formatdropdown-format-heading5' => 'Загаловак 5',
	'visualeditor-formatdropdown-format-heading6' => 'Загаловак 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Аформлены',
	'visualeditor-annotationbutton-bold-tooltip' => 'Тоўсты',
	'visualeditor-annotationbutton-italic-tooltip' => 'Курсіў',
	'visualeditor-annotationbutton-link-tooltip' => 'Спасылка',
	'visualeditor-indentationbutton-indent-tooltip' => 'Павялічыць водступ',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Паменшыць водступ',
	'visualeditor-listbutton-number-tooltip' => 'Нумараваны сьпіс',
	'visualeditor-listbutton-bullet-tooltip' => 'Маркіраваны сьпіс',
	'visualeditor-clearbutton-tooltip' => 'Прыбраць афармленьне',
	'visualeditor-historybutton-undo-tooltip' => 'Скасаваць',
	'visualeditor-historybutton-redo-tooltip' => 'Узнавіць',
	'visualeditor-viewpage-savewarning' => 'Вы ўпэўненыя, што жадаеце перайсьці ў рэжым прагляду без папярэдняга захаваньня?',
	'visualeditor-loadwarning' => 'Памылка ў час загрузкі зьвестак з сэрвэру: $1. Жадаеце паўтарыць?',
	'visualeditor-saveerror' => 'Памылка ў час захаваньня зьвестак на сэрвэры: $1.',
	'visualeditor-editsummary' => 'Апішыце вашыя зьмены',
);

/** Bengali (বাংলা)
 * @author Bellayet
 */
$messages['bn'] = array(
	'visualeditor-ca-editsource' => 'উৎস সম্পাদনা',
	'visualeditor-linkinspector-label-pagetitle' => 'পাতার শিরোনাম',
	'visualeditor-linkinspector-suggest-new-page' => 'নতুন পাতা',
	'visualeditor-annotationbutton-bold-tooltip' => 'গাঢ়',
	'visualeditor-annotationbutton-italic-tooltip' => 'ইটালিক',
	'visualeditor-annotationbutton-link-tooltip' => 'লিংক',
	'visualeditor-listbutton-number-tooltip' => 'সংখ্যায়িত তালিকা',
	'visualeditor-listbutton-bullet-tooltip' => 'বুলেটকৃত তালিকা',
	'visualeditor-historybutton-undo-tooltip' => 'পূর্বাবস্থায় ফেরাও',
);

/** Breton (brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'visualeditor' => 'VisualEditor',
	'visualeditor-feedback-prompt' => 'Lezel un evezhiadenn',
	'visualeditor-ca-editsource' => 'Kemmañ ar vammenn',
	'visualeditor-linkinspector-title' => 'Kemmañ al liamm', # Fuzzy
	'visualeditor-linkinspector-label-pagetitle' => 'Anv ar bajenn',
	'visualeditor-formatdropdown-title' => 'Kemmañ ar furmad',
	'visualeditor-formatdropdown-format-paragraph' => 'Rannbennad',
	'visualeditor-formatdropdown-format-heading1' => 'Titl 1',
	'visualeditor-formatdropdown-format-heading2' => 'Titl 2',
	'visualeditor-formatdropdown-format-heading3' => 'Titl 3',
	'visualeditor-formatdropdown-format-heading4' => 'Titl 4',
	'visualeditor-formatdropdown-format-heading5' => 'Titl 5',
	'visualeditor-formatdropdown-format-heading6' => 'Titl 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Rakfurmadet',
	'visualeditor-annotationbutton-bold-tooltip' => 'Tev',
	'visualeditor-annotationbutton-italic-tooltip' => 'Italek',
	'visualeditor-annotationbutton-link-tooltip' => 'Liamm',
	'visualeditor-indentationbutton-indent-tooltip' => 'Kreskiñ an endantadur',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Digreskiñ an endantadur',
	'visualeditor-listbutton-number-tooltip' => 'Roll niverennet',
	'visualeditor-listbutton-bullet-tooltip' => 'Roll padelliget',
	'visualeditor-clearbutton-tooltip' => 'Riñsañ ar furmata',
	'visualeditor-historybutton-undo-tooltip' => 'Dizober',
	'visualeditor-historybutton-redo-tooltip' => 'Adober',
);

/** Czech (česky)
 * @author Chmee2
 */
$messages['cs'] = array(
	'visualeditor' => 'WYSIWYG editor',
	'visualeditor-desc' => 'WYSIWYG editor pro MediaWiki',
	'visualeditor-feedback-prompt' => 'Podělte se se svým názorem',
	'visualeditor-feedback-dialog-title' => 'Podělte se se svým názorem na WYSIWYG editor',
	'visualeditor-ca-editsource' => 'Upravit zdroj',
	'visualeditor-linkinspector-title' => 'Upravit odkaz', # Fuzzy
	'visualeditor-linkinspector-label-pagetitle' => 'Název stránky',
	'visualeditor-formatdropdown-title' => 'Změnit formát',
	'visualeditor-formatdropdown-format-paragraph' => 'Odstavec',
	'visualeditor-formatdropdown-format-heading1' => 'Nadpis 1',
	'visualeditor-formatdropdown-format-heading2' => 'Nadpis 2',
	'visualeditor-formatdropdown-format-heading3' => 'Nadpis 3',
	'visualeditor-formatdropdown-format-heading4' => 'Nadpis 4',
	'visualeditor-formatdropdown-format-heading5' => 'Nadpis 5',
	'visualeditor-formatdropdown-format-heading6' => 'Nadpis 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Předformátovaný',
	'visualeditor-annotationbutton-bold-tooltip' => 'Tučné',
	'visualeditor-annotationbutton-italic-tooltip' => 'Kurzíva',
	'visualeditor-annotationbutton-link-tooltip' => 'Odkaz',
	'visualeditor-indentationbutton-indent-tooltip' => 'Zvětšit odsazení',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Zmenšit odsazení',
	'visualeditor-listbutton-number-tooltip' => 'Číslovaný seznam',
	'visualeditor-listbutton-bullet-tooltip' => 'Seznam s odrážkami',
	'visualeditor-clearbutton-tooltip' => 'Vymazat formátování',
	'visualeditor-historybutton-undo-tooltip' => 'Zpět',
	'visualeditor-historybutton-redo-tooltip' => 'Znovu',
	'visualeditor-viewpage-savewarning' => 'Opravdu se chcete vrátit k režimu zobrazení bez uložení?',
);

/** German (Deutsch)
 * @author G.Hagedorn
 * @author Kghbln
 * @author Metalhead64
 */
$messages['de'] = array(
	'visualeditor' => 'WYSIWYG-Editor',
	'visualeditor-desc' => 'Ermöglicht einen WYSIWYG-Editor',
	'visualeditor-preference-enable' => 'VisualEditor (WYSIWYG) aktivieren (nur für den Artikelnamensraum)',
	'visualeditor-notification-saved' => 'Deine Änderungen an $1 wurden gespeichert.',
	'visualeditor-notification-created' => '$1 wurde erstellt.',
	'visualeditor-ca-editsource' => 'Quelltext bearbeiten',
	'visualeditor-linkinspector-title' => 'Hyperlink',
	'visualeditor-linkinspector-label-pagetitle' => 'Seitenname',
	'visualeditor-linkinspector-suggest-existing-page' => 'Vorhandene Seite',
	'visualeditor-linkinspector-suggest-new-page' => 'Neue Seite',
	'visualeditor-linkinspector-suggest-external-link' => 'Weblink',
	'visualeditor-formatdropdown-title' => 'Format ändern',
	'visualeditor-formatdropdown-format-paragraph' => 'Absatz',
	'visualeditor-formatdropdown-format-heading1' => 'Überschrift 1',
	'visualeditor-formatdropdown-format-heading2' => 'Überschrift 2',
	'visualeditor-formatdropdown-format-heading3' => 'Überschrift 3',
	'visualeditor-formatdropdown-format-heading4' => 'Überschrift 4',
	'visualeditor-formatdropdown-format-heading5' => 'Überschrift 5',
	'visualeditor-formatdropdown-format-heading6' => 'Überschrift 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Vorformatiert',
	'visualeditor-annotationbutton-bold-tooltip' => 'Fett',
	'visualeditor-annotationbutton-italic-tooltip' => 'Kursiv',
	'visualeditor-annotationbutton-link-tooltip' => 'Link',
	'visualeditor-indentationbutton-indent-tooltip' => 'Einzug vergrößern',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Einzug verkleinern',
	'visualeditor-listbutton-number-tooltip' => 'Nummerierte Liste',
	'visualeditor-listbutton-bullet-tooltip' => 'Aufgezählte Liste',
	'visualeditor-clearbutton-tooltip' => 'Formatierungen entfernen',
	'visualeditor-historybutton-undo-tooltip' => 'Rückgängig machen',
	'visualeditor-historybutton-redo-tooltip' => 'Wiederholen',
	'visualeditor-viewpage-savewarning' => 'Bist du sicher, dass du zum Ansichtsmodus wechseln möchtest, ohne vorher zu speichern?',
	'visualeditor-loadwarning' => 'Fehler beim Laden der Daten vom Server: $1. Soll der Vorgang erneut durchgeführt werden?',
	'visualeditor-saveerror' => 'Fehler beim Speichern der Daten auf dem Server: $1.',
	'visualeditor-editsummary' => 'Beschreibe, was du geändert hast.',
	'visualeditor-aliennode-tooltip' => 'Dieses Element kann leider nicht mit dem WYSIWYG-Editor bearbeitet werden.',
);

/** German (formal address) (Deutsch (Sie-Form)‎)
 * @author Kghbln
 */
$messages['de-formal'] = array(
	'visualeditor-notification-saved' => 'Ihre Änderungen an $1 wurden gespeichert.',
	'visualeditor-viewpage-savewarning' => 'Sind Sie sicher, dass Sie zum Ansichtsmodus wechseln möchten, ohne vorher zu speichern?',
	'visualeditor-editsummary' => 'Beschreiben Sie, was Sie geändert haben.',
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 */
$messages['diq'] = array(
	'visualeditor-linkinspector-label-pagetitle' => 'Sernamey pela',
);

/** Lower Sorbian (dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'visualeditor' => 'VisualEditor',
	'visualeditor-desc' => 'WYSIWYG-editor za MediaWiki',
	'visualeditor-feedback-prompt' => 'Komentar zawóstajiś',
	'visualeditor-feedback-dialog-title' => 'Komentar wó VisualEditorje zawóstajiś',
);

/** British English (British English)
 * @author Jdforrester
 */
$messages['en-gb'] = array(
	'visualeditor' => 'VisualEditor',
	'visualeditor-desc' => 'VisualEditor for MediaWiki',
	'visualeditor-feedback-prompt' => 'Leave feedback',
	'visualeditor-feedback-dialog-title' => 'Leave feedback about VisualEditor Sandbox',
	'visualeditor-ca-editsource' => 'Edit source',
	'visualeditor-linkinspector-title' => 'Edit link', # Fuzzy
	'visualeditor-linkinspector-label-pagetitle' => 'Page title',
	'visualeditor-formatdropdown-title' => 'Change format',
	'visualeditor-formatdropdown-format-paragraph' => 'Paragraph',
	'visualeditor-formatdropdown-format-heading1' => 'Heading 1',
	'visualeditor-formatdropdown-format-heading2' => 'Heading 2',
	'visualeditor-formatdropdown-format-heading3' => 'Heading 3',
	'visualeditor-formatdropdown-format-heading4' => 'Heading 4',
	'visualeditor-formatdropdown-format-heading5' => 'Heading 5',
	'visualeditor-formatdropdown-format-heading6' => 'Heading 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Pre-formatted',
	'visualeditor-annotationbutton-bold-tooltip' => 'Bold',
	'visualeditor-annotationbutton-italic-tooltip' => 'Italic',
	'visualeditor-annotationbutton-link-tooltip' => 'Link',
	'visualeditor-indentationbutton-indent-tooltip' => 'Increase indent',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Decrease indent',
	'visualeditor-listbutton-number-tooltip' => 'Numbered list',
	'visualeditor-listbutton-bullet-tooltip' => 'Bullet list',
	'visualeditor-clearbutton-tooltip' => 'Clear formatting',
	'visualeditor-historybutton-undo-tooltip' => 'Undo',
	'visualeditor-historybutton-redo-tooltip' => 'Redo',
	'visualeditor-viewpage-savewarning' => 'Are you sure you want to go back to view mode without first saving?',
	'visualeditor-loadwarning' => 'Error loading data from server: $1. Would you like to try again?',
	'visualeditor-saveerror' => 'Error saving data to server: $1.',
);

/** Spanish (español)
 * @author Armando-Martin
 * @author Imre
 * @author Ralgis
 */
$messages['es'] = array(
	'visualeditor' => 'VisualEditor',
	'visualeditor-desc' => 'Editor visual para MediaWiki',
	'visualeditor-preference-enable' => 'Activar el editor visual (sólo en el espacio de nombres principales)',
	'visualeditor-notification-saved' => 'Tus cambios en $1 han sido guardados',
	'visualeditor-notification-created' => '$1 ha sido creado',
	'visualeditor-ca-editsource' => 'Editar fuente',
	'visualeditor-linkinspector-title' => 'Hiperenlace',
	'visualeditor-linkinspector-label-pagetitle' => 'Título de la página',
	'visualeditor-linkinspector-suggest-existing-page' => 'Página existente',
	'visualeditor-linkinspector-suggest-new-page' => 'Nueva página',
	'visualeditor-linkinspector-suggest-external-link' => 'Enlace web',
	'visualeditor-formatdropdown-title' => 'Cambiar formato',
	'visualeditor-formatdropdown-format-paragraph' => 'Párrafo',
	'visualeditor-formatdropdown-format-heading1' => 'Encabezado 1',
	'visualeditor-formatdropdown-format-heading2' => 'Encabezado 2',
	'visualeditor-formatdropdown-format-heading3' => 'Encabezado 3',
	'visualeditor-formatdropdown-format-heading4' => 'Encabezado 4',
	'visualeditor-formatdropdown-format-heading5' => 'Encabezado 5',
	'visualeditor-formatdropdown-format-heading6' => 'Encabezado 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Preformateado',
	'visualeditor-annotationbutton-bold-tooltip' => 'Negrita',
	'visualeditor-annotationbutton-italic-tooltip' => 'Cursiva',
	'visualeditor-annotationbutton-link-tooltip' => 'Enlace',
	'visualeditor-indentationbutton-indent-tooltip' => 'Aumentar sangría',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Disminuir sangría',
	'visualeditor-listbutton-number-tooltip' => 'Lista numerada',
	'visualeditor-listbutton-bullet-tooltip' => 'Lista con viñetas',
	'visualeditor-clearbutton-tooltip' => 'Borrar formato',
	'visualeditor-historybutton-undo-tooltip' => 'Deshacer',
	'visualeditor-historybutton-redo-tooltip' => 'Rehacer',
	'visualeditor-viewpage-savewarning' => '¿Estás seguro que quieres volver al modo de visualización sin guardar primero?',
	'visualeditor-loadwarning' => 'Error al cargar los datos del servidor: $1. ¿Le gustaría volver a intentarlo?',
	'visualeditor-saveerror' => 'Error al guardar datos en el servidor: $1.',
	'visualeditor-editsummary' => 'Describe lo que has cambiado',
);

/** Estonian (eesti)
 * @author Avjoska
 * @author Pikne
 */
$messages['et'] = array(
	'visualeditor' => 'Visuaaltoimetaja',
	'visualeditor-desc' => 'MediaWiki visuaaltoimetaja',
	'visualeditor-notification-saved' => 'Sinu muudatused leheküljel $1 on salvestatud.',
	'visualeditor-notification-created' => 'Loodud on lehekülg $1.',
	'visualeditor-ca-editsource' => 'Muuda allikat',
	'visualeditor-linkinspector-title' => 'Lingi muutmine', # Fuzzy
	'visualeditor-linkinspector-label-pagetitle' => 'Lehekülg',
	'visualeditor-linkinspector-suggest-existing-page' => 'Olemasolev lehekülg',
	'visualeditor-linkinspector-suggest-new-page' => 'Uus lehekülg',
	'visualeditor-linkinspector-suggest-external-link' => 'Võrgulink',
	'visualeditor-formatdropdown-title' => 'Muuda vormingut',
	'visualeditor-formatdropdown-format-paragraph' => 'Lõik',
	'visualeditor-formatdropdown-format-heading1' => 'Pealkiri 1',
	'visualeditor-formatdropdown-format-heading2' => 'Pealkiri 2',
	'visualeditor-formatdropdown-format-heading3' => 'Pealkiri 3',
	'visualeditor-formatdropdown-format-heading4' => 'Pealkiri 4',
	'visualeditor-formatdropdown-format-heading5' => 'Pealkiri 5',
	'visualeditor-formatdropdown-format-heading6' => 'Pealkiri 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Eelvormindatud',
	'visualeditor-annotationbutton-bold-tooltip' => 'Rasvane kiri',
	'visualeditor-annotationbutton-italic-tooltip' => 'Kaldkiri',
	'visualeditor-annotationbutton-link-tooltip' => 'Link',
	'visualeditor-indentationbutton-indent-tooltip' => 'Suurenda taanet',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Vähenda taanet',
	'visualeditor-listbutton-number-tooltip' => 'Numberloend',
	'visualeditor-listbutton-bullet-tooltip' => 'Täpploend',
	'visualeditor-clearbutton-tooltip' => 'Eemalda vorming',
	'visualeditor-historybutton-undo-tooltip' => 'Võta tagasi',
	'visualeditor-historybutton-redo-tooltip' => 'Tee uuesti',
	'visualeditor-viewpage-savewarning' => 'Kas oled kindel, et tahad mina tagasi vaatamisrežiimi ilma kõigepealt salvestamata?',
	'visualeditor-loadwarning' => 'Tõrge andmete laadimisel serverist: $1. Ehk proovid uuesti?',
	'visualeditor-saveerror' => 'Tõrge andmete salvestamisel serverisse: $1.',
	'visualeditor-editsummary' => 'Kirjelda, mida muutsid',
);

/** Persian (فارسی)
 * @author Mjbmr
 */
$messages['fa'] = array(
	'visualeditor-annotationbutton-bold-tooltip' => 'ضخیم',
	'visualeditor-annotationbutton-italic-tooltip' => 'مورب',
	'visualeditor-annotationbutton-link-tooltip' => 'پیوند',
	'visualeditor-historybutton-undo-tooltip' => 'خنثی‌سازی',
	'visualeditor-historybutton-redo-tooltip' => 'انجام دوباره',
);

/** Finnish (suomi)
 * @author Beluga
 * @author Nike
 * @author Olli
 */
$messages['fi'] = array(
	'visualeditor' => 'Visuaalinen muokkain',
	'visualeditor-desc' => 'Visuaalinen muokkain MediaWikille',
	'visualeditor-feedback-prompt' => 'Jätä palautetta',
	'visualeditor-feedback-dialog-title' => 'Jätä palautetta visuaalisen muokkaimen hiekkalaatikosta.',
	'visualeditor-ca-editsource' => 'Muokkaa lähdetekstiä',
	'visualeditor-linkinspector-title' => 'Muokkauslinkki', # Fuzzy
	'visualeditor-linkinspector-label-pagetitle' => 'Sivun otsikko',
	'visualeditor-formatdropdown-format-paragraph' => 'Kappale',
	'visualeditor-formatdropdown-format-heading1' => 'Otsikko 1',
	'visualeditor-formatdropdown-format-heading2' => 'Otsikko 2',
	'visualeditor-formatdropdown-format-heading3' => 'Otsikko 3',
	'visualeditor-formatdropdown-format-heading4' => 'Otsikko 4',
	'visualeditor-formatdropdown-format-heading5' => 'Otsikko 5',
	'visualeditor-formatdropdown-format-heading6' => 'Otsikko 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Esimuotoiltu',
	'visualeditor-annotationbutton-bold-tooltip' => 'Lihavointi',
	'visualeditor-annotationbutton-italic-tooltip' => 'Kursiivi',
	'visualeditor-annotationbutton-link-tooltip' => 'Linkki',
	'visualeditor-listbutton-number-tooltip' => 'Numeroitu luettelo',
	'visualeditor-clearbutton-tooltip' => 'Poista muotoilu',
	'visualeditor-historybutton-undo-tooltip' => 'Kumoa',
	'visualeditor-historybutton-redo-tooltip' => 'Tee uudelleen',
);

/** French (français)
 * @author Crochet.david
 * @author Gomoko
 * @author Hello71
 * @author Urhixidur
 */
$messages['fr'] = array(
	'visualeditor' => 'VisualEditor',
	'visualeditor-desc' => 'Éditeur visuel pour MediaWiki',
	'visualeditor-preference-enable' => 'Activer VisualEditor (espace de noms principal uniquement)',
	'visualeditor-notification-saved' => 'Vos modifications à $1 ont été enregistrés.',
	'visualeditor-notification-created' => '$1 a été créé!',
	'visualeditor-ca-editsource' => 'Modifier la source',
	'visualeditor-linkinspector-title' => 'Hyperlien',
	'visualeditor-linkinspector-label-pagetitle' => 'Titre de la page',
	'visualeditor-linkinspector-suggest-existing-page' => 'Page existante',
	'visualeditor-linkinspector-suggest-new-page' => 'Nouvelle page',
	'visualeditor-linkinspector-suggest-external-link' => 'Lien Web',
	'visualeditor-formatdropdown-title' => 'Modifier le format',
	'visualeditor-formatdropdown-format-paragraph' => 'Paragraphe',
	'visualeditor-formatdropdown-format-heading1' => 'Titre 1',
	'visualeditor-formatdropdown-format-heading2' => 'Titre 2',
	'visualeditor-formatdropdown-format-heading3' => 'Titre 3',
	'visualeditor-formatdropdown-format-heading4' => 'Titre 4',
	'visualeditor-formatdropdown-format-heading5' => 'Titre 5',
	'visualeditor-formatdropdown-format-heading6' => 'Titre 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Préformaté',
	'visualeditor-annotationbutton-bold-tooltip' => 'Gras',
	'visualeditor-annotationbutton-italic-tooltip' => 'Italique',
	'visualeditor-annotationbutton-link-tooltip' => 'Lien',
	'visualeditor-indentationbutton-indent-tooltip' => 'Augmenter l’indentation',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Diminuer l’indentation',
	'visualeditor-listbutton-number-tooltip' => 'Liste numérotée',
	'visualeditor-listbutton-bullet-tooltip' => 'Liste à puces',
	'visualeditor-clearbutton-tooltip' => 'Effacer la mise en forme',
	'visualeditor-historybutton-undo-tooltip' => 'Annuler',
	'visualeditor-historybutton-redo-tooltip' => 'Refaire',
	'visualeditor-viewpage-savewarning' => 'Êtes-vous sûr de vouloir retourner au mode lecture sans d’abord enregistrer ?',
	'visualeditor-loadwarning' => 'Erreur lors du chargement des données du serveur: $1. Voulez-vous réessayer?',
	'visualeditor-saveerror' => 'Erreur d’enregistrement des données sur le serveur : $1.',
	'visualeditor-editsummary' => 'Décrire ce que vous avez modifié',
	'visualeditor-aliennode-tooltip' => 'Désolé, cet élément ne peut pas être modifié en utilisant VisualEditor',
);

/** Franco-Provençal (arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'visualeditor' => 'Èditor visuâl',
	'visualeditor-desc' => 'Èditor visuâl por MediaWiki',
	'visualeditor-feedback-prompt' => 'Balyér voutron avis',
	'visualeditor-feedback-dialog-title' => 'Balyér voutron avis sur la bouèta de sabla de l’èditor visuâl',
	'visualeditor-ca-editsource' => 'Changiér la sôrsa',
	'visualeditor-linkinspector-title' => 'Changiér lo lim', # Fuzzy
	'visualeditor-linkinspector-label-pagetitle' => 'Titro de la pâge',
	'visualeditor-formatdropdown-title' => 'Changiér lo format',
	'visualeditor-formatdropdown-format-paragraph' => 'Paragrafo',
	'visualeditor-formatdropdown-format-heading1' => 'Titro 1',
	'visualeditor-formatdropdown-format-heading2' => 'Titro 2',
	'visualeditor-formatdropdown-format-heading3' => 'Titro 3',
	'visualeditor-formatdropdown-format-heading4' => 'Titro 4',
	'visualeditor-formatdropdown-format-heading5' => 'Titro 5',
	'visualeditor-formatdropdown-format-heading6' => 'Titro 6',
	'visualeditor-annotationbutton-bold-tooltip' => 'Grâs',
	'visualeditor-annotationbutton-italic-tooltip' => 'Étalico',
	'visualeditor-annotationbutton-link-tooltip' => 'Lim',
	'visualeditor-listbutton-number-tooltip' => 'Lista numerotâye',
	'visualeditor-listbutton-bullet-tooltip' => 'Lista de puges',
	'visualeditor-historybutton-undo-tooltip' => 'Dèfâre',
	'visualeditor-historybutton-redo-tooltip' => 'Refâre',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'visualeditor' => 'Editor visual',
	'visualeditor-desc' => 'Editor visual para MediaWiki',
	'visualeditor-preference-enable' => 'Activar o editor visual (só no espazo de nomes principal)',
	'visualeditor-notification-saved' => 'Gardáronse os cambios feitos en "$1".',
	'visualeditor-notification-created' => 'Creouse "$1".',
	'visualeditor-ca-editsource' => 'Editar a fonte',
	'visualeditor-linkinspector-title' => 'Hiperligazón',
	'visualeditor-linkinspector-label-pagetitle' => 'Título da páxina',
	'visualeditor-linkinspector-suggest-existing-page' => 'Páxina existente',
	'visualeditor-linkinspector-suggest-new-page' => 'Páxina nova',
	'visualeditor-linkinspector-suggest-external-link' => 'Ligazón web',
	'visualeditor-formatdropdown-title' => 'Cambiar o formato',
	'visualeditor-formatdropdown-format-paragraph' => 'Parágrafo',
	'visualeditor-formatdropdown-format-heading1' => 'Cabeceira 1',
	'visualeditor-formatdropdown-format-heading2' => 'Cabeceira 2',
	'visualeditor-formatdropdown-format-heading3' => 'Cabeceira 3',
	'visualeditor-formatdropdown-format-heading4' => 'Cabeceira 4',
	'visualeditor-formatdropdown-format-heading5' => 'Cabeceira 5',
	'visualeditor-formatdropdown-format-heading6' => 'Cabeceira 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Con formato previo',
	'visualeditor-annotationbutton-bold-tooltip' => 'Negra',
	'visualeditor-annotationbutton-italic-tooltip' => 'Cursiva',
	'visualeditor-annotationbutton-link-tooltip' => 'Ligazón',
	'visualeditor-indentationbutton-indent-tooltip' => 'Aumentar a sangría',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Diminuír a sangría',
	'visualeditor-listbutton-number-tooltip' => 'Lista numerada',
	'visualeditor-listbutton-bullet-tooltip' => 'Lista con asteriscos',
	'visualeditor-clearbutton-tooltip' => 'Borrar o formato',
	'visualeditor-historybutton-undo-tooltip' => 'Desfacer',
	'visualeditor-historybutton-redo-tooltip' => 'Refacer',
	'visualeditor-viewpage-savewarning' => 'Está seguro de querer volver ao modo de lectura sen gardar primeiro?',
	'visualeditor-loadwarning' => 'Erro ao cargar os datos desde o servidor: $1. Quéreo intentar de novo?',
	'visualeditor-saveerror' => 'Erro ao gardar os datos no servidor: $1.',
	'visualeditor-editsummary' => 'Describa os seus cambios',
	'visualeditor-aliennode-tooltip' => 'Sentímolo, o editor visual non pode editar este elemento.',
);

/** Hebrew (עברית)
 * @author Amire80
 */
$messages['he'] = array(
	'visualeditor' => 'עורך חזותי',
	'visualeditor-desc' => 'עורך חזותי למדיה־ויקי',
	'visualeditor-preference-enable' => 'להפעיל את העורך החזותי (במרחב השמות הראשי בלבד)',
	'visualeditor-notification-saved' => 'השינויים שלך לדף $1 לא נשמרו.',
	'visualeditor-notification-created' => 'הדף $1 נוצר.',
	'visualeditor-ca-editsource' => 'עריכת קוד מקור',
	'visualeditor-linkinspector-title' => 'היפר־קישור',
	'visualeditor-linkinspector-label-pagetitle' => 'כותרת דף',
	'visualeditor-linkinspector-suggest-existing-page' => 'דף קיים',
	'visualeditor-linkinspector-suggest-new-page' => 'דף חדש',
	'visualeditor-linkinspector-suggest-external-link' => 'קישור לרשת',
	'visualeditor-formatdropdown-title' => 'שינוי סגנון',
	'visualeditor-formatdropdown-format-paragraph' => 'פסקה',
	'visualeditor-formatdropdown-format-heading1' => 'כותרת רמה 1',
	'visualeditor-formatdropdown-format-heading2' => 'כותרת רמה 2',
	'visualeditor-formatdropdown-format-heading3' => 'כותרת רמה 3',
	'visualeditor-formatdropdown-format-heading4' => 'כותרת רמה 4',
	'visualeditor-formatdropdown-format-heading5' => 'כותרת רמה 5',
	'visualeditor-formatdropdown-format-heading6' => 'כותרת רמה 6',
	'visualeditor-formatdropdown-format-preformatted' => 'טקסט חלק',
	'visualeditor-annotationbutton-bold-tooltip' => 'בולט',
	'visualeditor-annotationbutton-italic-tooltip' => 'נטוי',
	'visualeditor-annotationbutton-link-tooltip' => 'קישור',
	'visualeditor-indentationbutton-indent-tooltip' => 'הגדלת הזחה',
	'visualeditor-indentationbutton-outdent-tooltip' => 'הקטנת הזחה',
	'visualeditor-listbutton-number-tooltip' => 'רשימה ממוספרת',
	'visualeditor-listbutton-bullet-tooltip' => 'רשימת תבליטים',
	'visualeditor-clearbutton-tooltip' => 'ניקוי עיצוב',
	'visualeditor-historybutton-undo-tooltip' => 'ביטול',
	'visualeditor-historybutton-redo-tooltip' => 'חזרה על פעולה',
	'visualeditor-viewpage-savewarning' => 'האם ברצונך לשוב למצב תצוגה ללא שמירה?',
	'visualeditor-loadwarning' => 'שגיאה בטעינת מידע מהשרת: $1. האם לנסות שוב?',
	'visualeditor-saveerror' => 'שגיאה בשמירת נתונים לשרת: $1.',
	'visualeditor-editsummary' => 'נא לתאר מה שינית',
	'visualeditor-aliennode-tooltip' => 'סליחה, אי־אפשר לערוך את המרכיב הזה באמצעות העורך החזותי',
);

/** Hindi (हिन्दी)
 * @author Ansumang
 */
$messages['hi'] = array(
	'visualeditor-feedback-prompt' => 'प्रतिक्रिया छोड़ें',
);

/** Upper Sorbian (hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'visualeditor' => 'VisualEditor',
	'visualeditor-desc' => 'WYSIWYG-editor za MediaWiki',
	'visualeditor-preference-enable' => 'VisualEditor zmóžnić (jenož hłowny mjenowy rum)',
	'visualeditor-notification-saved' => 'Twoje změny na $1 su so składowali.',
	'visualeditor-notification-created' => '$1 je so wutworił.',
	'visualeditor-ca-editsource' => 'Žórłowy tekst wobdźěłać',
	'visualeditor-linkinspector-title' => 'Wotkaz',
	'visualeditor-linkinspector-label-pagetitle' => 'Titul strony',
	'visualeditor-linkinspector-suggest-existing-page' => 'Eksistowaca strona',
	'visualeditor-linkinspector-suggest-new-page' => 'Nowa strona',
	'visualeditor-linkinspector-suggest-external-link' => 'Webwotkaz',
	'visualeditor-formatdropdown-title' => 'Format změnić',
	'visualeditor-formatdropdown-format-paragraph' => 'Wotstawk',
	'visualeditor-formatdropdown-format-heading1' => 'Nadpis 1',
	'visualeditor-formatdropdown-format-heading2' => 'Nadpis 2',
	'visualeditor-formatdropdown-format-heading3' => 'Nadpis 3',
	'visualeditor-formatdropdown-format-heading4' => 'Nadpis 4',
	'visualeditor-formatdropdown-format-heading5' => 'Nadpis 5',
	'visualeditor-formatdropdown-format-heading6' => 'Nadpis 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Předformatowany',
	'visualeditor-annotationbutton-bold-tooltip' => 'Tučny',
	'visualeditor-annotationbutton-italic-tooltip' => 'Kursiwny',
	'visualeditor-annotationbutton-link-tooltip' => 'Wotkaz',
	'visualeditor-indentationbutton-indent-tooltip' => 'Zasunjenje powjetšić',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Zasunjenje pomjeńšić',
	'visualeditor-listbutton-number-tooltip' => 'Čisłowana lisćina',
	'visualeditor-listbutton-bullet-tooltip' => 'Nalicenje',
	'visualeditor-clearbutton-tooltip' => 'Formatowanje wotstronić',
	'visualeditor-historybutton-undo-tooltip' => 'Cofnyć',
	'visualeditor-historybutton-redo-tooltip' => 'Wospjetować',
	'visualeditor-viewpage-savewarning' => 'Chceš so woprawdźe k napohladowemu modusej wróćić, bjeztoho zo by prjedy składował?',
	'visualeditor-loadwarning' => 'Zmylk při začitowanju datow ze serwera: $1. Chceš znowa spytać?',
	'visualeditor-saveerror' => 'Zmylk při składowanju datow na serwerje: $1.',
	'visualeditor-editsummary' => 'Wopisaj, štož sy změnił',
);

/** Hungarian (magyar)
 * @author Dj
 */
$messages['hu'] = array(
	'visualeditor' => 'VisualEditor',
	'visualeditor-desc' => 'Vizuális szerkesztő a MediaWikihez',
	'visualeditor-feedback-prompt' => 'Visszajelzés',
	'visualeditor-feedback-dialog-title' => 'Visszajelzés készítése a VisualEditor homokozójáról',
	'visualeditor-formatdropdown-format-heading1' => 'Címsor 1',
	'visualeditor-formatdropdown-format-heading2' => 'Címsor 2',
	'visualeditor-formatdropdown-format-heading3' => 'Címsor 3',
	'visualeditor-formatdropdown-format-heading4' => 'Címsor 4',
	'visualeditor-formatdropdown-format-heading5' => 'Címsor 5',
	'visualeditor-formatdropdown-format-heading6' => 'Címsor 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Előre formázott',
	'visualeditor-annotationbutton-bold-tooltip' => 'Félkövér',
	'visualeditor-annotationbutton-italic-tooltip' => 'Dőlt',
	'visualeditor-annotationbutton-link-tooltip' => 'Hivatkozás',
	'visualeditor-indentationbutton-indent-tooltip' => 'Behúzás növelése',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Behúzás csökkentése',
	'visualeditor-listbutton-number-tooltip' => 'Számozott lista',
	'visualeditor-clearbutton-tooltip' => 'Formázás törlése',
	'visualeditor-historybutton-undo-tooltip' => 'Visszavonás',
	'visualeditor-historybutton-redo-tooltip' => 'Újra',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'visualeditor' => 'Editor visual',
	'visualeditor-desc' => 'Editor visual pro MediaWiki',
	'visualeditor-feedback-prompt' => 'Lassar commentario',
	'visualeditor-feedback-dialog-title' => 'Lassar commentario super le cassa a sablo del editor visual',
	'visualeditor-ca-editsource' => 'Modificar fonte',
	'visualeditor-linkinspector-title' => 'Modificar ligamine', # Fuzzy
	'visualeditor-linkinspector-label-pagetitle' => 'Titulo del pagina',
	'visualeditor-formatdropdown-title' => 'Cambiar formato',
	'visualeditor-formatdropdown-format-paragraph' => 'Paragrapho',
	'visualeditor-formatdropdown-format-heading1' => 'Titulo 1',
	'visualeditor-formatdropdown-format-heading2' => 'Titulo 2',
	'visualeditor-formatdropdown-format-heading3' => 'Titulo 3',
	'visualeditor-formatdropdown-format-heading4' => 'Titulo 4',
	'visualeditor-formatdropdown-format-heading5' => 'Titulo 5',
	'visualeditor-formatdropdown-format-heading6' => 'Titulo 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Preformatate',
	'visualeditor-annotationbutton-bold-tooltip' => 'Grasse',
	'visualeditor-annotationbutton-italic-tooltip' => 'Italic',
	'visualeditor-annotationbutton-link-tooltip' => 'Ligamine',
	'visualeditor-indentationbutton-indent-tooltip' => 'Augmentar indentation',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Reducer indentation',
	'visualeditor-listbutton-number-tooltip' => 'Lista numerate',
	'visualeditor-listbutton-bullet-tooltip' => 'Lista a punctos',
	'visualeditor-clearbutton-tooltip' => 'Rader formatation',
	'visualeditor-historybutton-undo-tooltip' => 'Disfacer',
	'visualeditor-historybutton-redo-tooltip' => 'Refacer',
	'visualeditor-viewpage-savewarning' => 'Es tu secur de voler retornar al modo de lectura sin salveguardar primo?',
	'visualeditor-loadwarning' => 'Error durante le cargamento del datos ab le servitor: $1. Vole tu reprobar?',
	'visualeditor-saveerror' => 'Error durante le salveguarda del datos in le servitor: $1.',
);

/** Icelandic (íslenska)
 * @author Snævar
 */
$messages['is'] = array(
	'visualeditor-feedback-prompt' => 'Skilja eftir svörun',
	'visualeditor-notification-saved' => 'Breytingarnar þínar á $1 hafa verið vistaðar.',
	'visualeditor-notification-created' => '$1 hefur verið búin til.',
	'visualeditor-ca-editsource' => 'Breyta uppruna',
	'visualeditor-linkinspector-title' => 'Breyta tengli', # Fuzzy
	'visualeditor-linkinspector-label-pagetitle' => 'Titill síðu',
	'visualeditor-linkinspector-suggest-new-page' => 'Ný síða',
	'visualeditor-linkinspector-suggest-external-link' => 'Veftengill',
	'visualeditor-formatdropdown-title' => 'Breyta fyrirsögn',
	'visualeditor-formatdropdown-format-paragraph' => 'Fyrirsögn',
	'visualeditor-formatdropdown-format-heading1' => 'Fyrirsögn 1',
	'visualeditor-formatdropdown-format-heading2' => 'Fyrirsögn 2',
	'visualeditor-formatdropdown-format-heading3' => 'Fyrirsögn 3',
	'visualeditor-formatdropdown-format-heading4' => 'Fyrirsögn 4',
	'visualeditor-formatdropdown-format-heading5' => 'Fyrirsögn 5',
	'visualeditor-formatdropdown-format-heading6' => 'Fyrirsögn 6',
	'visualeditor-annotationbutton-bold-tooltip' => 'Feitletra',
	'visualeditor-annotationbutton-italic-tooltip' => 'Skáletra',
	'visualeditor-annotationbutton-link-tooltip' => 'Tengill',
	'visualeditor-indentationbutton-indent-tooltip' => 'Auka inndrátt',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Minnka inndrátt',
	'visualeditor-listbutton-number-tooltip' => 'Tölusettur listi',
	'visualeditor-listbutton-bullet-tooltip' => 'Punktalisti',
	'visualeditor-clearbutton-tooltip' => 'Fjarlægja stílsnið',
	'visualeditor-historybutton-undo-tooltip' => 'Taka aftur',
	'visualeditor-historybutton-redo-tooltip' => 'Endurgera',
	'visualeditor-viewpage-savewarning' => 'Ertu viss um að þú viljir fara í skoðunarham án þess að vista fyrst ?',
	'visualeditor-editsummary' => 'Lýstu því hvað þú hefur breytt',
);

/** Italian (italiano)
 * @author Beta16
 * @author Darth Kule
 * @author F. Cosoleto
 */
$messages['it'] = array(
	'visualeditor' => 'VisualEditor',
	'visualeditor-desc' => 'Editor visivo per MediaWiki',
	'visualeditor-preference-enable' => 'Abilita VisualEditor (solo nel namespace principale)',
	'visualeditor-feedback-prompt' => 'Lascia un commento',
	'visualeditor-feedback-dialog-title' => 'Lascia un commento su VisualEditor',
	'visualeditor-notification-saved' => 'Le modifiche apportate a $1 sono state salvate.',
	'visualeditor-notification-created' => 'La pagina $1 è stata creata.',
	'visualeditor-ca-editsource' => 'Modifica sorgente',
	'visualeditor-linkinspector-title' => 'Collegamento ipertestuale',
	'visualeditor-linkinspector-label-pagetitle' => 'Titolo della pagina',
	'visualeditor-linkinspector-suggest-existing-page' => 'Pagina esistente',
	'visualeditor-linkinspector-suggest-new-page' => 'Nuova pagina',
	'visualeditor-linkinspector-suggest-external-link' => 'Collegamento web',
	'visualeditor-formatdropdown-title' => 'Cambia formato',
	'visualeditor-formatdropdown-format-paragraph' => 'Paragrafo',
	'visualeditor-formatdropdown-format-heading1' => 'Titolo 1',
	'visualeditor-formatdropdown-format-heading2' => 'Titolo 2',
	'visualeditor-formatdropdown-format-heading3' => 'Titolo 3',
	'visualeditor-formatdropdown-format-heading4' => 'Titolo 4',
	'visualeditor-formatdropdown-format-heading5' => 'Titolo 5',
	'visualeditor-formatdropdown-format-heading6' => 'Titolo 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Preformattato',
	'visualeditor-annotationbutton-bold-tooltip' => 'Grassetto',
	'visualeditor-annotationbutton-italic-tooltip' => 'Corsivo',
	'visualeditor-annotationbutton-link-tooltip' => 'Collegamento',
	'visualeditor-indentationbutton-indent-tooltip' => 'Aumenta indentazione',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Riduci indentazione',
	'visualeditor-listbutton-number-tooltip' => 'Elenco numerato',
	'visualeditor-listbutton-bullet-tooltip' => 'Elenco puntato',
	'visualeditor-clearbutton-tooltip' => 'Pulisci formattazione',
	'visualeditor-historybutton-undo-tooltip' => 'Annulla',
	'visualeditor-historybutton-redo-tooltip' => 'Rifai',
	'visualeditor-viewpage-savewarning' => 'Tornare alla modalità in visualizzazione senza salvare prima?',
	'visualeditor-loadwarning' => 'Errore durante il caricamento dei dati dal server: $1. Riprovare?',
	'visualeditor-saveerror' => 'Errore durante il salvataggio dei dati sul server: $1.',
	'visualeditor-editsummary' => 'Descrivere che cosa è cambiato',
);

/** Japanese (日本語)
 * @author Penn Station
 * @author Shirayuki
 */
$messages['ja'] = array(
	'visualeditor' => 'ビジュアルエディター',
	'visualeditor-desc' => 'MediaWiki 用のビジュアルエディター',
	'visualeditor-preference-enable' => 'ビジュアルエディターを有効にする (標準名前空間のみ)',
	'visualeditor-notification-saved' => '$1への変更を保存しました。',
	'visualeditor-notification-created' => '$1を作成しました。',
	'visualeditor-ca-editsource' => 'ソースを編集',
	'visualeditor-linkinspector-title' => 'ハイパーリンク',
	'visualeditor-linkinspector-label-pagetitle' => 'ページ名',
	'visualeditor-linkinspector-suggest-existing-page' => '既存のページ',
	'visualeditor-linkinspector-suggest-new-page' => '新規ページ',
	'visualeditor-linkinspector-suggest-external-link' => 'ウェブ リンク',
	'visualeditor-formatdropdown-title' => '書式の変更',
	'visualeditor-formatdropdown-format-paragraph' => '段落',
	'visualeditor-formatdropdown-format-heading1' => '見出し 1',
	'visualeditor-formatdropdown-format-heading2' => '見出し 2',
	'visualeditor-formatdropdown-format-heading3' => '見出し 3',
	'visualeditor-formatdropdown-format-heading4' => '見出し 4',
	'visualeditor-formatdropdown-format-heading5' => '見出し 5',
	'visualeditor-formatdropdown-format-heading6' => '見出し 6',
	'visualeditor-formatdropdown-format-preformatted' => '整形済みテキスト',
	'visualeditor-annotationbutton-bold-tooltip' => '太字',
	'visualeditor-annotationbutton-italic-tooltip' => '斜体',
	'visualeditor-annotationbutton-link-tooltip' => 'リンク',
	'visualeditor-indentationbutton-indent-tooltip' => 'インデント',
	'visualeditor-indentationbutton-outdent-tooltip' => 'インデント解除',
	'visualeditor-listbutton-number-tooltip' => '番号付き箇条書き',
	'visualeditor-listbutton-bullet-tooltip' => '番号なし箇条書き',
	'visualeditor-clearbutton-tooltip' => '書式を消去',
	'visualeditor-historybutton-undo-tooltip' => '取り消し',
	'visualeditor-historybutton-redo-tooltip' => 'やり直し',
	'visualeditor-viewpage-savewarning' => 'まだ保存していませんが、表示モードに本当に戻りますか?',
	'visualeditor-loadwarning' => 'サーバからのデータの読み込みでエラーが発生しました: $1。再試行してください。',
	'visualeditor-saveerror' => 'サーバにデータを保存する際にエラーが発生しました: $1',
	'visualeditor-editsummary' => '編集内容を説明してください',
	'visualeditor-aliennode-tooltip' => '申し訳ありませんが、この要素はビジュアルエディターでは編集できません',
);

/** Javanese (Basa Jawa)
 * @author NoiX180
 */
$messages['jv'] = array(
	'visualeditor' => 'PanyuntingVisual',
	'visualeditor-desc' => 'Panyunting visual kanggo MediaWiki',
	'visualeditor-feedback-prompt' => 'Tinggalaké lebon saran',
	'visualeditor-feedback-dialog-title' => 'Tinggalaké lebon saran bab KothakWedhi PanyuntingVisual',
	'visualeditor-ca-editsource' => 'Sunting sumber',
	'visualeditor-linkinspector-title' => 'Sunting pranala', # Fuzzy
	'visualeditor-linkinspector-label-pagetitle' => 'Judhul kaca',
	'visualeditor-formatdropdown-title' => 'Ganti format',
	'visualeditor-formatdropdown-format-paragraph' => 'Paragraf',
	'visualeditor-formatdropdown-format-heading1' => 'Irah-irahan 1',
	'visualeditor-formatdropdown-format-heading2' => 'Irah-irahan 2',
	'visualeditor-formatdropdown-format-heading3' => 'Irah-irahan 3',
	'visualeditor-formatdropdown-format-heading4' => 'Irah-irahan 4',
	'visualeditor-formatdropdown-format-heading5' => 'Irah-irahan 5',
	'visualeditor-formatdropdown-format-heading6' => 'Irah-irahan 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Kapraformat',
	'visualeditor-annotationbutton-bold-tooltip' => 'Kandel',
	'visualeditor-annotationbutton-italic-tooltip' => 'Miring',
	'visualeditor-annotationbutton-link-tooltip' => 'Pranala',
	'visualeditor-indentationbutton-indent-tooltip' => 'Tambah legokan',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Suda legokan',
	'visualeditor-listbutton-number-tooltip' => 'Daptar angka',
	'visualeditor-listbutton-bullet-tooltip' => 'Daptar poin',
	'visualeditor-clearbutton-tooltip' => 'Resiki pamormatan',
	'visualeditor-historybutton-undo-tooltip' => 'Batalaké',
	'visualeditor-historybutton-redo-tooltip' => 'Pilih manèh',
	'visualeditor-viewpage-savewarning' => 'Sampéyan yakin arep mbalik nèng mode pandelokan tanpa nyimpen dhisik?',
	'visualeditor-loadwarning' => 'Kasalahan nalika ngemot data saka sasana: $1. Sampéyan pingin njajal manèh?',
	'visualeditor-saveerror' => 'Kasalahan nalika nyimpen data nèng sasana: $1.',
);

/** Georgian (ქართული)
 * @author BRUTE
 * @author David1010
 */
$messages['ka'] = array(
	'visualeditor' => 'ვიზუალური რედაქტორი',
	'visualeditor-desc' => 'მედიავიკის ვიზუალური რედაქტორი',
	'visualeditor-feedback-prompt' => 'გამოხმაურების დატოვება',
	'visualeditor-notification-created' => '$1 შეიქმნა.',
	'visualeditor-ca-editsource' => 'წყაროს რედაქტირება',
	'visualeditor-linkinspector-title' => 'ბმულის რედაქტირება', # Fuzzy
	'visualeditor-linkinspector-label-pagetitle' => 'გვერდის სათაური',
	'visualeditor-formatdropdown-title' => 'ფორმატის ცვლილება',
	'visualeditor-formatdropdown-format-paragraph' => 'პარაგრაფი',
	'visualeditor-formatdropdown-format-heading1' => 'სათაური 1',
	'visualeditor-formatdropdown-format-heading2' => 'სათაური 2',
	'visualeditor-formatdropdown-format-heading3' => 'სათაური 3',
	'visualeditor-formatdropdown-format-heading4' => 'სათაური 4',
	'visualeditor-formatdropdown-format-heading5' => 'სათაური 5',
	'visualeditor-formatdropdown-format-heading6' => 'სათაური 6',
	'visualeditor-annotationbutton-bold-tooltip' => 'მუქი',
	'visualeditor-annotationbutton-italic-tooltip' => 'კურსივი',
	'visualeditor-annotationbutton-link-tooltip' => 'ბმული',
	'visualeditor-listbutton-number-tooltip' => 'დანომრილი სია',
	'visualeditor-listbutton-bullet-tooltip' => 'მარკირებული სია',
	'visualeditor-historybutton-undo-tooltip' => 'დაბრუნება',
	'visualeditor-historybutton-redo-tooltip' => 'განმეორება',
);

/** Korean (한국어)
 * @author 아라
 */
$messages['ko'] = array(
	'visualeditor' => '시각적편집기',
	'visualeditor-desc' => '미디어위키를 위한 시각적 편집기',
	'visualeditor-preference-enable' => '시각적편집기 활성화 (표준 이름공간만)',
	'visualeditor-notification-saved' => '$1 문서에 바뀜을 저장했습니다.',
	'visualeditor-notification-created' => '$1 문서를 만들었습니다.',
	'visualeditor-ca-editsource' => '자료 편집',
	'visualeditor-linkinspector-title' => '하이퍼링크',
	'visualeditor-linkinspector-label-pagetitle' => '문서 제목',
	'visualeditor-linkinspector-suggest-existing-page' => '기존 문서',
	'visualeditor-linkinspector-suggest-new-page' => '새 문서',
	'visualeditor-linkinspector-suggest-external-link' => '웹 링크',
	'visualeditor-formatdropdown-title' => '서식 바꾸기',
	'visualeditor-formatdropdown-format-paragraph' => '문단',
	'visualeditor-formatdropdown-format-heading1' => '1단계 문단 제목',
	'visualeditor-formatdropdown-format-heading2' => '2단계 문단 제목',
	'visualeditor-formatdropdown-format-heading3' => '3단계 문단 제목',
	'visualeditor-formatdropdown-format-heading4' => '4단계 문단 제목',
	'visualeditor-formatdropdown-format-heading5' => '5단계 문단 제목',
	'visualeditor-formatdropdown-format-heading6' => '6단계 문단 제목',
	'visualeditor-formatdropdown-format-preformatted' => '서식 지정',
	'visualeditor-annotationbutton-bold-tooltip' => '굵은 글씨',
	'visualeditor-annotationbutton-italic-tooltip' => '기울인 글씨',
	'visualeditor-annotationbutton-link-tooltip' => '링크',
	'visualeditor-indentationbutton-indent-tooltip' => '들여쓰기 높이기',
	'visualeditor-indentationbutton-outdent-tooltip' => '들여쓰기 낮추기',
	'visualeditor-listbutton-number-tooltip' => '번호가 매겨진 목록',
	'visualeditor-listbutton-bullet-tooltip' => '글머리 기호 목록',
	'visualeditor-clearbutton-tooltip' => '서식 지우기',
	'visualeditor-historybutton-undo-tooltip' => '되돌리기',
	'visualeditor-historybutton-redo-tooltip' => '다시 실행',
	'visualeditor-viewpage-savewarning' => '먼저 저장하지 않고 보기 모드로 돌아가겠습니까?',
	'visualeditor-loadwarning' => '서버에서 데이터를 불러오는 중 오류: $1. 다시 시도하겠습니까?',
	'visualeditor-saveerror' => '서버에 데이터를 저장하는 중 오류: $1.',
	'visualeditor-editsummary' => '바꾼 내용 설명',
	'visualeditor-aliennode-tooltip' => '죄송합니다, 이 요소는 시각적편집기를 사용하여 편집할 수 없습니다',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'visualeditor' => 'Sigge beldlesch beärbeide',
	'visualeditor-desc' => 'Määd_et müjjelesch, em MedijaWikki Sigge beldlesch ze beärbeide.',
	'visualeditor-feedback-prompt' => 'Jivv_en Röckmäldong',
	'visualeditor-feedback-dialog-title' => 'Donn en Röckmäldong övver et Ußprobeere vum  Sigge beldlesch Beärbeide jävve',
	'visualeditor-notification-saved' => 'Ding Änderonge aan dä Sigg „$1“ sin faßjehalde.',
	'visualeditor-notification-created' => 'Di Sigg „$1“ es aanjelaat woode.',
	'visualeditor-ca-editsource' => 'der Quälltäx ändere',
	'visualeditor-linkinspector-title' => 'Lengk ändere', # Fuzzy
	'visualeditor-linkinspector-label-pagetitle' => 'Siggetittel',
	'visualeditor-linkinspector-suggest-existing-page' => 'En Sigg, di ald doh es',
	'visualeditor-linkinspector-suggest-new-page' => 'En neue Sigg',
	'visualeditor-linkinspector-suggest-external-link' => 'Ene Wäblengk',
	'visualeditor-formatdropdown-title' => 'De Fommateerong ändere',
	'visualeditor-formatdropdown-format-paragraph' => 'Afschnett',
	'visualeditor-formatdropdown-format-heading1' => 'Övverschreff 1',
	'visualeditor-formatdropdown-format-heading2' => 'Övverschreff 2',
	'visualeditor-formatdropdown-format-heading3' => 'Övverschreff 3',
	'visualeditor-formatdropdown-format-heading4' => 'Övverschreff 4',
	'visualeditor-formatdropdown-format-heading5' => 'Övverschreff 5',
	'visualeditor-formatdropdown-format-heading6' => 'Övverschreff 6',
	'visualeditor-formatdropdown-format-preformatted' => 'De Fommateerong es ald doh',
	'visualeditor-annotationbutton-bold-tooltip' => 'Fätte Schreff',
	'visualeditor-annotationbutton-italic-tooltip' => 'Scheive Schreff',
	'visualeditor-annotationbutton-link-tooltip' => 'ene Lengk',
	'visualeditor-indentationbutton-indent-tooltip' => 'Mieh enjeröck',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Winnijer enjeröck',
	'visualeditor-listbutton-number-tooltip' => 'En Leß met Nommere',
	'visualeditor-listbutton-bullet-tooltip' => 'Leß met Pungkte',
	'visualeditor-clearbutton-tooltip' => 'Fomaateeronge fottnämme',
	'visualeditor-historybutton-undo-tooltip' => 'Donn de läzde Änderong zeröck nämme',
	'visualeditor-historybutton-redo-tooltip' => 'Donn dat norr_ens',
	'visualeditor-viewpage-savewarning' => 'Wells De verhaftesch retuur jonn op et beldlesch Beärbeide, der ohne eeds_ens di Sigg met Dinge Änderonge em Wiki faßzehallde?',
	'visualeditor-loadwarning' => 'Ene Fähler es opjetrodde beim Daate Laade vum däm ẞööver: <i lang="en">$1</i>.',
	'visualeditor-saveerror' => 'Ene Fähler es opjetrodde beim Daate Faßhallde op däm ẞööver: <i lang="en">$1</i>.',
	'visualeditor-editsummary' => 'Donn beschriive, wat De jeändert häs.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'visualeditor' => 'WYSIWYG-Editeur',
	'visualeditor-desc' => 'WYSIWYG-Editeur fir MediaWiki',
	'visualeditor-feedback-prompt' => 'Gitt Äre Feedback',
	'visualeditor-ca-editsource' => 'Quelltext änneren',
	'visualeditor-linkinspector-title' => 'Link änneren', # Fuzzy
	'visualeditor-linkinspector-label-pagetitle' => 'Titel vun der Säit',
	'visualeditor-linkinspector-suggest-new-page' => 'Nei Säit',
	'visualeditor-formatdropdown-title' => 'Format änneren',
	'visualeditor-formatdropdown-format-paragraph' => 'Abschnitt',
	'visualeditor-formatdropdown-format-heading1' => 'Iwwerschrëft 1',
	'visualeditor-formatdropdown-format-heading2' => 'Iwwerschrëft 2',
	'visualeditor-formatdropdown-format-heading3' => 'Iwwerschrëft 3',
	'visualeditor-formatdropdown-format-heading4' => 'Iwwerschrëft 4',
	'visualeditor-formatdropdown-format-heading5' => 'Iwwerschrëft 5',
	'visualeditor-formatdropdown-format-heading6' => 'Iwwerschrëft 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Virformatéiert',
	'visualeditor-annotationbutton-bold-tooltip' => 'Fett',
	'visualeditor-annotationbutton-italic-tooltip' => 'Kursiv',
	'visualeditor-annotationbutton-link-tooltip' => 'Link',
	'visualeditor-listbutton-number-tooltip' => 'Numeréiert Lëscht',
	'visualeditor-listbutton-bullet-tooltip' => 'Lëscht mat Punkten',
	'visualeditor-clearbutton-tooltip' => 'Format ewechhuelen',
	'visualeditor-historybutton-undo-tooltip' => 'Zréck setzen',
	'visualeditor-historybutton-redo-tooltip' => 'Widderhuelen',
	'visualeditor-saveerror' => 'Feeler beim Späichere vun den Donnéeën op de Server: $1.',
);

/** Lithuanian (lietuvių)
 * @author Eitvys200
 */
$messages['lt'] = array(
	'visualeditor-feedback-prompt' => 'Palikti atsiliepimą',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'visualeditor' => 'Визуелен уредник',
	'visualeditor-desc' => 'Визуелен уредник за МедијаВики',
	'visualeditor-preference-enable' => 'Овозможи ЛиковенУредник (само главен имен. простор)',
	'visualeditor-notification-saved' => 'Измените во $1 се зачувани',
	'visualeditor-notification-created' => 'Создавањето на $1 заврши успешно!',
	'visualeditor-ca-editsource' => 'Уреди извор',
	'visualeditor-linkinspector-title' => 'Хиперврска',
	'visualeditor-linkinspector-label-pagetitle' => 'Наслов на страницата',
	'visualeditor-linkinspector-suggest-existing-page' => 'Постоечка страница',
	'visualeditor-linkinspector-suggest-new-page' => 'Нова страница',
	'visualeditor-linkinspector-suggest-external-link' => 'Надворешна врска',
	'visualeditor-formatdropdown-title' => 'Смени формат',
	'visualeditor-formatdropdown-format-paragraph' => 'Пасус',
	'visualeditor-formatdropdown-format-heading1' => 'Наслов 1',
	'visualeditor-formatdropdown-format-heading2' => 'Наслов 2',
	'visualeditor-formatdropdown-format-heading3' => 'Наслов 3',
	'visualeditor-formatdropdown-format-heading4' => 'Наслов 4',
	'visualeditor-formatdropdown-format-heading5' => 'Наслов 5',
	'visualeditor-formatdropdown-format-heading6' => 'Наслов 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Претформатирано',
	'visualeditor-annotationbutton-bold-tooltip' => 'Задебелено',
	'visualeditor-annotationbutton-italic-tooltip' => 'Закосено',
	'visualeditor-annotationbutton-link-tooltip' => 'Врска',
	'visualeditor-indentationbutton-indent-tooltip' => 'Вовлекување',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Извлекување',
	'visualeditor-listbutton-number-tooltip' => 'Список со редни броеви',
	'visualeditor-listbutton-bullet-tooltip' => 'Список со потточки',
	'visualeditor-clearbutton-tooltip' => 'Исчисти форматирање',
	'visualeditor-historybutton-undo-tooltip' => 'Врати',
	'visualeditor-historybutton-redo-tooltip' => 'Повтори',
	'visualeditor-viewpage-savewarning' => 'Дали сте сигурни дека сакате да се вратите на прегледниот режим без прво да ги ачувате измените?',
	'visualeditor-loadwarning' => 'Грешка при вчитување на податоците од опслужувачот: $1. Дали сакате да пробате одново?',
	'visualeditor-saveerror' => 'Грешка при зачувување на податоците во опслужувачот: $1.',
	'visualeditor-editsummary' => 'Опишете ги направените измени',
	'visualeditor-aliennode-tooltip' => 'Нажалост, овој елемент не може да се уредува со ВизуеленУредник',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Santhosh.thottingal
 */
$messages['ml'] = array(
	'visualeditor' => 'കണ്ടുതിരുത്തൽ സൗകര്യം',
	'visualeditor-desc' => 'മീഡിയവിക്കിയ്ക്കായുള്ള കണ്ടുതിരുത്തൽ സൗകര്യം',
	'visualeditor-preference-enable' => 'കണ്ടുതിരുത്തൽ സൗകര്യം സജ്ജമാക്കുക (മുഖ്യനാമമേഖലയിൽ മാത്രം)',
	'visualeditor-notification-saved' => 'താങ്കൾ $1 എന്ന താളിൽ വരുത്തിയ മാറ്റങ്ങൾ സേവ് ചെയ്തിരിക്കുന്നു.',
	'visualeditor-notification-created' => '$1 എന്ന താൾ സൃഷ്ടിച്ചിരിക്കുന്നു.',
	'visualeditor-ca-editsource' => 'മൂലരൂപം തിരുത്തുക',
	'visualeditor-linkinspector-title' => 'ഹൈപ്പർലിങ്ക്',
	'visualeditor-linkinspector-label-pagetitle' => 'താളിന്റെ തലക്കെട്ട്',
	'visualeditor-linkinspector-suggest-existing-page' => 'നിലവിലുള്ള താൾ',
	'visualeditor-linkinspector-suggest-new-page' => 'പുതിയ താൾ',
	'visualeditor-linkinspector-suggest-external-link' => 'വെബ് കണ്ണി',
	'visualeditor-formatdropdown-title' => 'തരം മാറ്റുക',
	'visualeditor-formatdropdown-format-paragraph' => 'ഖണ്ഡിക',
	'visualeditor-formatdropdown-format-heading1' => 'തലക്കെട്ട് 1',
	'visualeditor-formatdropdown-format-heading2' => 'തലക്കെട്ട് 2',
	'visualeditor-formatdropdown-format-heading3' => 'തലക്കെട്ട് 3',
	'visualeditor-formatdropdown-format-heading4' => 'തലക്കെട്ട് 4',
	'visualeditor-formatdropdown-format-heading5' => 'തലക്കെട്ട് 5',
	'visualeditor-formatdropdown-format-heading6' => 'തലക്കെട്ട് 6',
	'visualeditor-formatdropdown-format-preformatted' => 'മുൻപേ ഘടന നിർണ്ണയിച്ചവ',
	'visualeditor-annotationbutton-bold-tooltip' => 'കടുപ്പിക്കുക',
	'visualeditor-annotationbutton-italic-tooltip' => 'ചെരിച്ച്',
	'visualeditor-annotationbutton-link-tooltip' => 'കണ്ണി',
	'visualeditor-indentationbutton-indent-tooltip' => 'അരികിലെ ഇട കൂട്ടുക',
	'visualeditor-indentationbutton-outdent-tooltip' => 'അരികിലെ ഇട കുറയ്ക്കുക',
	'visualeditor-listbutton-number-tooltip' => 'എണ്ണമിട്ട ലിസ്റ്റ്',
	'visualeditor-listbutton-bullet-tooltip' => 'എണ്ണമിടാത്ത ലിസ്റ്റ്',
	'visualeditor-clearbutton-tooltip' => 'രൂപഘടന നീക്കംചെയ്യുക',
	'visualeditor-historybutton-undo-tooltip' => 'തിരസ്കരിക്കുക',
	'visualeditor-historybutton-redo-tooltip' => 'വീണ്ടും ചെയ്യുക',
	'visualeditor-viewpage-savewarning' => 'സേവ് ചെയ്യാതെ തന്നെ കണ്ടുനോക്കൽ തലത്തിലേയ്ക്ക് തിരിച്ചു പോകണം എന്ന് താങ്കൾക്കുറപ്പാണോ?',
	'visualeditor-loadwarning' => 'സെർവറിൽ നിന്നും വിവരങ്ങൾ ശേഖരിക്കുന്നതിൽ പിഴവുണ്ടായി: $1. വീണ്ടും ശ്രമിക്കണോ?',
	'visualeditor-saveerror' => 'സെർവറിൽ വിവരങ്ങൾ ശേഖരിക്കുന്നതിൽ പിഴവുണ്ടായി: $1',
	'visualeditor-editsummary' => 'താങ്കൾ എന്താണ് മാറ്റം വരുത്തിയതെന്ന് വിവരിക്കുക',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'visualeditor' => 'VisualEditor',
	'visualeditor-desc' => 'Alat penyuntingan visual untuk MediaWiki',
	'visualeditor-preference-enable' => 'Hidupkan VisualEditor (ruang nama utama sahaja)',
	'visualeditor-feedback-prompt' => 'Tinggalkan maklum balas',
	'visualeditor-feedback-dialog-title' => 'Tinggalkan maklum balas tentang VisualEditor',
	'visualeditor-notification-saved' => 'Perubahan yang anda lakukan pada $1 telah disimpan.',
	'visualeditor-notification-created' => '$1 telah diwujudkan.',
	'visualeditor-ca-editsource' => 'Sunting sumber',
	'visualeditor-linkinspector-title' => 'Hiperpautan',
	'visualeditor-linkinspector-label-pagetitle' => 'Tajuk halaman',
	'visualeditor-linkinspector-suggest-existing-page' => 'Halaman sedia ada',
	'visualeditor-linkinspector-suggest-new-page' => 'Halaman baru',
	'visualeditor-linkinspector-suggest-external-link' => 'Pautan sesawang',
	'visualeditor-formatdropdown-title' => 'Tukar format',
	'visualeditor-formatdropdown-format-paragraph' => 'Perenggan',
	'visualeditor-formatdropdown-format-heading1' => 'Pengatas 1',
	'visualeditor-formatdropdown-format-heading2' => 'Pengatas 2',
	'visualeditor-formatdropdown-format-heading3' => 'Pengatas 3',
	'visualeditor-formatdropdown-format-heading4' => 'Pengatas 4',
	'visualeditor-formatdropdown-format-heading5' => 'Pengatas 5',
	'visualeditor-formatdropdown-format-heading6' => 'Pengatas 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Praformat',
	'visualeditor-annotationbutton-bold-tooltip' => 'Tebal',
	'visualeditor-annotationbutton-italic-tooltip' => 'Condong',
	'visualeditor-annotationbutton-link-tooltip' => 'Pautan',
	'visualeditor-indentationbutton-indent-tooltip' => 'Jarakkan engsotan',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Rapatkan engsotan',
	'visualeditor-listbutton-number-tooltip' => 'Senarai bernombor',
	'visualeditor-listbutton-bullet-tooltip' => 'Senarai berbulet',
	'visualeditor-clearbutton-tooltip' => 'Buang pemformatan',
	'visualeditor-historybutton-undo-tooltip' => 'Batalkan',
	'visualeditor-historybutton-redo-tooltip' => 'Pulihkan',
	'visualeditor-viewpage-savewarning' => 'Adakah anda benar-benar ingin kembali ke ragam paparan tanpa menyimpan terlebih dahulu?',
	'visualeditor-loadwarning' => 'Ralat ketika memuatkan data dari pelayan: $1. Adakah anda hendak mencuba lagi?',
	'visualeditor-saveerror' => 'Ralat ketika memuatkan data dari pelayan: $1',
	'visualeditor-editsummary' => 'Terangkan suntingan anda',
);

/** Norwegian Bokmål (norsk (bokmål)‎)
 * @author Danmichaelo
 * @author Event
 */
$messages['nb'] = array(
	'visualeditor' => 'VisualEditor',
	'visualeditor-desc' => 'Visuell redigering for MediaWiki',
	'visualeditor-preference-enable' => 'Aktiviser VisualEditor (bare for hovednavnerommet)',
	'visualeditor-notification-saved' => 'Dine endringer i $1 er blitt lagret.',
	'visualeditor-notification-created' => '$1 er blitt opprettet.',
	'visualeditor-ca-editsource' => 'Rediger kilde',
	'visualeditor-linkinspector-title' => 'Hyperlenke',
	'visualeditor-linkinspector-label-pagetitle' => 'Sidetittel',
	'visualeditor-linkinspector-suggest-existing-page' => 'Eksisterende side',
	'visualeditor-linkinspector-suggest-new-page' => 'Ny side',
	'visualeditor-linkinspector-suggest-external-link' => 'Weblenke',
	'visualeditor-formatdropdown-title' => 'Endre format',
	'visualeditor-formatdropdown-format-paragraph' => 'Avsnitt',
	'visualeditor-formatdropdown-format-heading1' => 'Overskrift 1',
	'visualeditor-formatdropdown-format-heading2' => 'Overskrift 2',
	'visualeditor-formatdropdown-format-heading3' => 'Overskrift 3',
	'visualeditor-formatdropdown-format-heading4' => 'Overskrift 4',
	'visualeditor-formatdropdown-format-heading5' => 'Overskrift 5',
	'visualeditor-formatdropdown-format-heading6' => 'Overskrift 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Preformatert',
	'visualeditor-annotationbutton-bold-tooltip' => 'Fet',
	'visualeditor-annotationbutton-italic-tooltip' => 'Kursiv',
	'visualeditor-annotationbutton-link-tooltip' => 'Lenke',
	'visualeditor-indentationbutton-indent-tooltip' => 'Øk innrykk',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Reduser innrykk',
	'visualeditor-listbutton-number-tooltip' => 'Nummerert liste',
	'visualeditor-listbutton-bullet-tooltip' => 'Punktliste',
	'visualeditor-clearbutton-tooltip' => 'Fjern formatering',
	'visualeditor-historybutton-undo-tooltip' => 'Angre',
	'visualeditor-historybutton-redo-tooltip' => 'Gjør om',
	'visualeditor-viewpage-savewarning' => 'Er du sikker på at du vil gå tilbake til visningsmodus uten å lagre først?',
	'visualeditor-loadwarning' => 'Det oppsto en feil ved henting av data fra serveren: $1. Vil du prøve på nytt?',
	'visualeditor-saveerror' => 'Det oppsto et problem ved lagring av data til serveren: $1.',
	'visualeditor-editsummary' => 'Beskriv hva du endret',
);

/** Nepali (नेपाली)
 * @author RajeshPandey
 */
$messages['ne'] = array(
	'visualeditor' => 'दृष्टि सम्पादक',
	'visualeditor-desc' => 'मेडियाविकिको लागि दृष्टि सम्पादक',
	'visualeditor-feedback-prompt' => 'प्रतिकृया दिने',
	'visualeditor-feedback-dialog-title' => 'दृष्टि सम्पादक प्रयोगस्थल को बारेमा प्रतिकृया दिने',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Saruman
 * @author Siebrand
 */
$messages['nl'] = array(
	'visualeditor' => 'Vereenvoudigde tekstverwerker',
	'visualeditor-desc' => 'Vereenvoudigde tekstverwerker voor MediaWiki',
	'visualeditor-preference-enable' => 'Visuele tekstverwerker inschakelen (alleen voor de hoofdnaamruimte)',
	'visualeditor-feedback-prompt' => 'Terugkoppeling achterlaten',
	'visualeditor-feedback-dialog-title' => 'Terugkoppeling geven over de visuele tekstverwerker',
	'visualeditor-notification-saved' => 'Uw wijzigingen aan "$1" zijn opgeslagen',
	'visualeditor-notification-created' => '"$1" is aangemaakt.',
	'visualeditor-ca-editsource' => 'Bron bewerken',
	'visualeditor-linkinspector-title' => 'Hyperlink',
	'visualeditor-linkinspector-label-pagetitle' => 'Paginanaam',
	'visualeditor-linkinspector-suggest-existing-page' => 'Bestaande pagina',
	'visualeditor-linkinspector-suggest-new-page' => 'Nieuwe pagina',
	'visualeditor-linkinspector-suggest-external-link' => 'Webverwijzing',
	'visualeditor-formatdropdown-title' => 'Opmaak wijzigen',
	'visualeditor-formatdropdown-format-paragraph' => 'Paragraaf',
	'visualeditor-formatdropdown-format-heading1' => 'Kop 1',
	'visualeditor-formatdropdown-format-heading2' => 'Kop 2',
	'visualeditor-formatdropdown-format-heading3' => 'Kop 3',
	'visualeditor-formatdropdown-format-heading4' => 'Kop 4',
	'visualeditor-formatdropdown-format-heading5' => 'Kop 5',
	'visualeditor-formatdropdown-format-heading6' => 'Kop 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Vooraf opgemaakt',
	'visualeditor-annotationbutton-bold-tooltip' => 'Vet',
	'visualeditor-annotationbutton-italic-tooltip' => 'Cursief',
	'visualeditor-annotationbutton-link-tooltip' => 'Verwijzing',
	'visualeditor-indentationbutton-indent-tooltip' => 'Inspringing vergroten',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Inspringing verkleinen',
	'visualeditor-listbutton-number-tooltip' => 'Genummerde lijst',
	'visualeditor-listbutton-bullet-tooltip' => 'Ongenummerde lijst',
	'visualeditor-clearbutton-tooltip' => 'Opmaak wissen',
	'visualeditor-historybutton-undo-tooltip' => 'Ongedaan maken',
	'visualeditor-historybutton-redo-tooltip' => 'Opnieuw uitvoeren',
	'visualeditor-viewpage-savewarning' => 'Weet u zeker dat u wilt teruggaan naar de modus bekijken zonder eerst op te slaan?',
	'visualeditor-loadwarning' => 'Fout tijdens het laden van gegevens van de server: $1. Wilt u het opnieuw proberen?',
	'visualeditor-saveerror' => 'Fout tijdens het opslaan van gegevens naar de server: $1.',
	'visualeditor-editsummary' => 'Beschrijf wat u hebt gewijzigd',
);

/** Polish (polski)
 * @author Mikołka
 */
$messages['pl'] = array(
	'visualeditor' => 'VisualEditor',
	'visualeditor-desc' => 'Edytor graficzny MediaWiki',
	'visualeditor-feedback-prompt' => 'Prześlij opinię',
	'visualeditor-feedback-dialog-title' => 'Prześlij swoją opinię na temat brudnopisu VisualEditor',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'visualeditor' => 'Editor Visual',
	'visualeditor-desc' => 'Editor visual për MediaWiki',
	'visualeditor-feedback-prompt' => "Lassé n'opinion",
	'visualeditor-feedback-dialog-title' => "Lassé n'opinion a propòsit dl'Ambient ëd preuva ëd VisualEditor",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'visualeditor-linkinspector-title' => 'تړنه سمول', # Fuzzy
	'visualeditor-linkinspector-label-pagetitle' => 'مخ سرليک',
	'visualeditor-linkinspector-suggest-external-link' => 'جال تړنه',
	'visualeditor-formatdropdown-format-heading1' => 'سرليک 1',
	'visualeditor-formatdropdown-format-heading2' => 'سرليک 2',
	'visualeditor-formatdropdown-format-heading3' => 'سرليک 3',
	'visualeditor-formatdropdown-format-heading4' => 'سرليک 4',
	'visualeditor-formatdropdown-format-heading5' => 'سرليک 5',
	'visualeditor-formatdropdown-format-heading6' => 'سرليک 6',
	'visualeditor-annotationbutton-bold-tooltip' => 'زغرد',
	'visualeditor-annotationbutton-italic-tooltip' => 'رېوند',
	'visualeditor-annotationbutton-link-tooltip' => 'تړنه',
	'visualeditor-listbutton-number-tooltip' => 'شمېرن لړليک',
	'visualeditor-listbutton-bullet-tooltip' => 'ګولۍ داره لړليک',
	'visualeditor-historybutton-undo-tooltip' => 'ناکړل',
	'visualeditor-historybutton-redo-tooltip' => 'بياکړل',
);

/** Portuguese (português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'visualeditor-saveerror' => 'Erro ao gravar os dados no servidor: $1.',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Jaideraf
 */
$messages['pt-br'] = array(
	'visualeditor' => 'VisualEditor',
	'visualeditor-desc' => 'Editor visual para o MediaWiki',
	'visualeditor-feedback-prompt' => 'Forneça o feedback',
	'visualeditor-feedback-dialog-title' => 'Forneça o feedback sobre a página de testes do editor visual',
	'visualeditor-notification-saved' => 'Suas alterações para $1 foram salvas.',
	'visualeditor-notification-created' => 'A página $1 foi criada.',
	'visualeditor-ca-editsource' => 'Editar código-fonte',
	'visualeditor-linkinspector-title' => 'Editar link', # Fuzzy
	'visualeditor-linkinspector-label-pagetitle' => 'Título da página',
	'visualeditor-linkinspector-suggest-existing-page' => 'Página existente',
	'visualeditor-linkinspector-suggest-new-page' => 'Página nova',
	'visualeditor-linkinspector-suggest-external-link' => 'Link da Web',
	'visualeditor-formatdropdown-title' => 'Alterar o formato',
	'visualeditor-formatdropdown-format-paragraph' => 'Parágrafo',
	'visualeditor-formatdropdown-format-heading1' => 'Nível 1',
	'visualeditor-formatdropdown-format-heading2' => 'Nível 2',
	'visualeditor-formatdropdown-format-heading3' => 'Nível 3',
	'visualeditor-formatdropdown-format-heading4' => 'Nível 4',
	'visualeditor-formatdropdown-format-heading5' => 'Nível 5',
	'visualeditor-formatdropdown-format-heading6' => 'Nível 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Pré-formatado',
	'visualeditor-annotationbutton-bold-tooltip' => 'Negrito',
	'visualeditor-annotationbutton-italic-tooltip' => 'Itálico',
	'visualeditor-annotationbutton-link-tooltip' => 'Link',
	'visualeditor-indentationbutton-indent-tooltip' => 'Aumentar recuo',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Diminuir recuo',
	'visualeditor-listbutton-number-tooltip' => 'Lista numerada',
	'visualeditor-listbutton-bullet-tooltip' => 'Lista com marcadores',
	'visualeditor-clearbutton-tooltip' => 'Limpar formatação',
	'visualeditor-historybutton-undo-tooltip' => 'Desfazer',
	'visualeditor-historybutton-redo-tooltip' => 'Refazer',
	'visualeditor-viewpage-savewarning' => 'Tem certeza que deseja voltar para a página sem querer salvar a edição?',
	'visualeditor-loadwarning' => 'Erro ao carregar dados do servidor:  $1. Gostaria de tentar novamente?',
	'visualeditor-saveerror' => 'Erro ao salvar dados para o servidor:  $1.',
	'visualeditor-editsummary' => 'Por favor, descreva o que você mudou',
);

/** Romanian (română)
 * @author Firilacroco
 */
$messages['ro'] = array(
	'visualeditor-feedback-prompt' => 'Lăsați un comentariu',
	'visualeditor-feedback-dialog-title' => 'Lăsați un comentariu despre cutia cu nisip a editorului vizual',
	'visualeditor-ca-editsource' => 'Modificați sursa',
	'visualeditor-linkinspector-title' => 'Modificați legătura', # Fuzzy
	'visualeditor-linkinspector-label-pagetitle' => 'Titlul paginii',
	'visualeditor-formatdropdown-title' => 'Modificați formatul',
	'visualeditor-formatdropdown-format-paragraph' => 'Paragraf',
	'visualeditor-formatdropdown-format-heading1' => 'Titlu 1',
	'visualeditor-formatdropdown-format-heading2' => 'Titlu 2',
	'visualeditor-formatdropdown-format-heading3' => 'Titlu 3',
	'visualeditor-formatdropdown-format-heading4' => 'Titlu 4',
	'visualeditor-formatdropdown-format-heading5' => 'Titlu 5',
	'visualeditor-formatdropdown-format-heading6' => 'Titlu 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Preformatat',
	'visualeditor-annotationbutton-bold-tooltip' => 'Aldin',
	'visualeditor-annotationbutton-italic-tooltip' => 'Cursiv',
	'visualeditor-annotationbutton-link-tooltip' => 'Legătură',
	'visualeditor-indentationbutton-indent-tooltip' => 'Măriți indentarea',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Diminuați indentarea',
	'visualeditor-listbutton-number-tooltip' => 'Listă numerotată',
	'visualeditor-listbutton-bullet-tooltip' => 'Listă cu puncte',
	'visualeditor-clearbutton-tooltip' => 'Curățați formatarea',
	'visualeditor-historybutton-undo-tooltip' => 'Anulare',
	'visualeditor-historybutton-redo-tooltip' => 'Refacere',
);

/** Russian (русский)
 * @author Amire80
 * @author Eugrus
 * @author Kalan
 */
$messages['ru'] = array(
	'visualeditor' => 'VisualEditor',
	'visualeditor-desc' => 'Визуальный редактор для MediaWiki',
	'visualeditor-feedback-prompt' => 'Оставить отзыв',
	'visualeditor-feedback-dialog-title' => 'Оставить отзыв о песочнице с VisualEditor',
	'visualeditor-ca-editsource' => 'Править исходный текст',
	'visualeditor-linkinspector-title' => 'Править ссылку', # Fuzzy
	'visualeditor-linkinspector-label-pagetitle' => 'Название страницы',
	'visualeditor-formatdropdown-title' => 'Форматирование',
	'visualeditor-formatdropdown-format-paragraph' => 'Абзац',
	'visualeditor-formatdropdown-format-heading1' => 'Заголовок 1',
	'visualeditor-formatdropdown-format-heading2' => 'Заголовок 2',
	'visualeditor-formatdropdown-format-heading3' => 'Заголовок 3',
	'visualeditor-formatdropdown-format-heading4' => 'Заголовок 4',
	'visualeditor-formatdropdown-format-heading5' => 'Заголовок 5',
	'visualeditor-formatdropdown-format-heading6' => 'Заголовок 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Преформатированный',
	'visualeditor-annotationbutton-bold-tooltip' => 'Жирный',
	'visualeditor-annotationbutton-italic-tooltip' => 'Курсив',
	'visualeditor-annotationbutton-link-tooltip' => 'Ссылка',
	'visualeditor-indentationbutton-indent-tooltip' => 'Увеличить отступ',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Уменьшить отступ',
	'visualeditor-listbutton-number-tooltip' => 'Нумерованный список',
	'visualeditor-listbutton-bullet-tooltip' => 'Маркированный список',
	'visualeditor-clearbutton-tooltip' => 'Очистить форматирование',
	'visualeditor-historybutton-undo-tooltip' => 'Отменить',
	'visualeditor-historybutton-redo-tooltip' => 'Вернуть',
	'visualeditor-viewpage-savewarning' => 'Вы точно хотите вернуться в режим просмотра, не сохранив изменения?',
	'visualeditor-loadwarning' => 'Ошибка при загрузке данных: $1. Попробовать снова?',
	'visualeditor-saveerror' => 'Ошибка при сохранении данных: $1.',
);

/** Rusyn (русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'visualeditor-formatdropdown-format-heading1' => 'Надпис 1',
	'visualeditor-formatdropdown-format-heading2' => 'Надпис 2',
	'visualeditor-formatdropdown-format-heading3' => 'Надпис 3',
	'visualeditor-formatdropdown-format-heading4' => 'Надпис 4',
	'visualeditor-formatdropdown-format-heading5' => 'Надпис 5',
	'visualeditor-formatdropdown-format-heading6' => 'Надпис 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Передформатованый',
	'visualeditor-annotationbutton-bold-tooltip' => 'Товсте',
	'visualeditor-annotationbutton-italic-tooltip' => 'Курзіва',
	'visualeditor-annotationbutton-link-tooltip' => 'Одказ',
);

/** Sinhala (සිංහල)
 * @author Singhalawap
 * @author පසිඳු කාවින්ද
 */
$messages['si'] = array(
	'visualeditor' => 'දෘශ්‍යසංස්කාරක',
	'visualeditor-desc' => 'මීඩියාවිකි සඳහා දෘශ්‍යසංස්කාරක',
	'visualeditor-feedback-prompt' => 'ප්‍රතිචාරය ලබා දෙන්න',
	'visualeditor-feedback-dialog-title' => 'දෘශ්‍යසංස්කරණ වැලිපිල්ල ගැන ප්‍රතිචාරය ලබාදෙන්න',
	'visualeditor-ca-editsource' => 'මූලාශ්‍රය සංස්කරණය කරන්න',
	'visualeditor-linkinspector-title' => 'සබැඳිය සංස්කරණය කරන්න', # Fuzzy
	'visualeditor-linkinspector-label-pagetitle' => 'පිටුවේ මාතෘකාව',
	'visualeditor-formatdropdown-title' => 'ආකෘතිය වෙනස් කරන්න',
	'visualeditor-formatdropdown-format-paragraph' => 'ඡේදය',
	'visualeditor-formatdropdown-format-heading1' => 'මාතෘකාව 1',
	'visualeditor-formatdropdown-format-heading2' => 'මාතෘකාව 2',
	'visualeditor-formatdropdown-format-heading3' => 'මාතෘකාව 3',
	'visualeditor-formatdropdown-format-heading4' => 'මාතෘකාව 4',
	'visualeditor-formatdropdown-format-heading5' => 'මාතෘකාව 5',
	'visualeditor-formatdropdown-format-heading6' => 'මාතෘකාව 6',
	'visualeditor-formatdropdown-format-preformatted' => 'පෙර ආකෘතිකරණය කරන ලද',
	'visualeditor-annotationbutton-bold-tooltip' => 'තද පැහැ අකුරු',
	'visualeditor-annotationbutton-italic-tooltip' => 'ඇළ අකුරු',
	'visualeditor-annotationbutton-link-tooltip' => 'සබැඳුම',
	'visualeditor-indentationbutton-indent-tooltip' => 'කඩතොල්ල වැඩි කරන්න',
	'visualeditor-indentationbutton-outdent-tooltip' => 'කඩතොල්ල අඩු කරන්න',
	'visualeditor-listbutton-number-tooltip' => 'අංකිත ලැයිස්තුව',
	'visualeditor-listbutton-bullet-tooltip' => 'බුලට් ලැයිස්තුව',
	'visualeditor-clearbutton-tooltip' => 'ආකෘතිකරණය හිස් කරන්න',
	'visualeditor-historybutton-undo-tooltip' => 'අහෝසිය',
	'visualeditor-historybutton-redo-tooltip' => 'යළි කරන්න',
	'visualeditor-saveerror' => 'සර්වරය වෙත දත්ත සුරැකීමේ දෝෂය: $1.',
);

/** Swedish (svenska)
 * @author Ainali
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'visualeditor' => 'VisualEditor',
	'visualeditor-desc' => 'Visuell redigerare för MediaWiki',
	'visualeditor-feedback-prompt' => 'Lämna feedback',
	'visualeditor-feedback-dialog-title' => 'Ge feedback om VisualEditor sandlåda',
	'visualeditor-notification-saved' => 'Dina ändringar i $1 har sparats.',
	'visualeditor-notification-created' => '$1 har skapats.',
	'visualeditor-ca-editsource' => 'Redigera källa',
	'visualeditor-linkinspector-title' => 'Redigera länk', # Fuzzy
	'visualeditor-linkinspector-label-pagetitle' => 'Sidtitel',
	'visualeditor-linkinspector-suggest-existing-page' => 'Befintlig sida',
	'visualeditor-linkinspector-suggest-new-page' => 'Ny sida',
	'visualeditor-linkinspector-suggest-external-link' => 'Webblänk',
	'visualeditor-formatdropdown-title' => 'Ändra format',
	'visualeditor-formatdropdown-format-paragraph' => 'Paragraf',
	'visualeditor-formatdropdown-format-heading1' => 'Rubrik 1',
	'visualeditor-formatdropdown-format-heading2' => 'Rubrik 2',
	'visualeditor-formatdropdown-format-heading3' => 'Rubrik 3',
	'visualeditor-formatdropdown-format-heading4' => 'Rubrik 4',
	'visualeditor-formatdropdown-format-heading5' => 'Rubrik 5',
	'visualeditor-formatdropdown-format-heading6' => 'Rubrik 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Förformaterad',
	'visualeditor-annotationbutton-bold-tooltip' => 'Fet',
	'visualeditor-annotationbutton-italic-tooltip' => 'Kursiv',
	'visualeditor-annotationbutton-link-tooltip' => 'Länk',
	'visualeditor-indentationbutton-indent-tooltip' => 'Öka indrag',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Minska indrag',
	'visualeditor-listbutton-number-tooltip' => 'Numrerad lista',
	'visualeditor-listbutton-bullet-tooltip' => 'Punktlista',
	'visualeditor-clearbutton-tooltip' => 'Radera formatering',
	'visualeditor-historybutton-undo-tooltip' => 'Ångra',
	'visualeditor-historybutton-redo-tooltip' => 'Gör om',
	'visualeditor-viewpage-savewarning' => 'Är du säker på att du vill gå tillbaka till visningsläget utan att spara först?',
	'visualeditor-loadwarning' => 'Fel uppstod vid inläsning av data från server: $1. Vill du försöka igen?',
	'visualeditor-saveerror' => 'Fel uppstod vid sparande av data till server: $1.',
	'visualeditor-editsummary' => 'Beskriv vad du har ändrat',
);

/** Tamil (தமிழ்)
 * @author Shanmugamp7
 * @author மதனாஹரன்
 */
$messages['ta'] = array(
	'visualeditor-ca-editsource' => 'மூலத்தை தொகு',
	'visualeditor-linkinspector-title' => 'இணைப்பைத் தொகு', # Fuzzy
	'visualeditor-linkinspector-label-pagetitle' => 'பக்கத்தின் தலைப்பு',
	'visualeditor-linkinspector-suggest-existing-page' => 'உள்ள பக்கம்',
	'visualeditor-linkinspector-suggest-new-page' => 'புதுப் பக்கம்',
	'visualeditor-linkinspector-suggest-external-link' => 'வலையிணைப்பு',
	'visualeditor-formatdropdown-title' => 'வடிவமைப்பை மாற்றுக',
	'visualeditor-formatdropdown-format-paragraph' => 'பத்தி',
	'visualeditor-formatdropdown-format-heading1' => 'தலைப்பு 1',
	'visualeditor-formatdropdown-format-heading2' => 'தலைப்பு 2',
	'visualeditor-formatdropdown-format-heading3' => 'தலைப்பு 3',
	'visualeditor-formatdropdown-format-heading4' => 'தலைப்பு 4',
	'visualeditor-formatdropdown-format-heading5' => 'தலைப்பு 5',
	'visualeditor-formatdropdown-format-heading6' => 'தலைப்பு 6',
	'visualeditor-formatdropdown-format-preformatted' => 'முன்வடிவமைக்கப்பட்டது',
	'visualeditor-annotationbutton-bold-tooltip' => 'தடித்த',
	'visualeditor-annotationbutton-italic-tooltip' => 'சாய்ந்த',
	'visualeditor-annotationbutton-link-tooltip' => 'இணைப்பு',
	'visualeditor-indentationbutton-indent-tooltip' => 'உள்தள்ளலை அதிகரிக்கவும்',
	'visualeditor-indentationbutton-outdent-tooltip' => 'உள்தள்ளலை குறைக்கவும்',
	'visualeditor-listbutton-number-tooltip' => 'எண்களுடன் வரிசை',
	'visualeditor-listbutton-bullet-tooltip' => 'குண்டுக்குறியிட்ட பட்டியல்',
	'visualeditor-clearbutton-tooltip' => 'வடிவமைத்தலை வெறுமையாக்கு',
	'visualeditor-historybutton-undo-tooltip' => 'மீளமை',
	'visualeditor-historybutton-redo-tooltip' => 'மீண்டும் செய்',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'visualeditor-linkinspector-label-pagetitle' => 'పేజీ శీర్షిక',
	'visualeditor-annotationbutton-bold-tooltip' => 'బొద్దు',
	'visualeditor-annotationbutton-italic-tooltip' => 'వాలు',
	'visualeditor-annotationbutton-link-tooltip' => 'లంకె',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'visualeditor' => 'Pampatnugot na Pampaningin',
	'visualeditor-desc' => 'Pampatnugot na pampaningin para sa MediaWiki',
	'visualeditor-feedback-prompt' => 'Mag-iwan ng tugon',
	'visualeditor-feedback-dialog-title' => 'Mag-iwan ng tugon hinggil sa Subukan ng Pampatnugot na Pampaningin',
	'visualeditor-notification-saved' => 'Nasagip na ang mga binago mo sa $1.',
	'visualeditor-notification-created' => 'Nalikha na ang $1.',
	'visualeditor-ca-editsource' => 'Baguhin ang pinagmulan',
	'visualeditor-linkinspector-title' => 'Baguhin ang kawing', # Fuzzy
	'visualeditor-linkinspector-label-pagetitle' => 'Pamagat ng pahina',
	'visualeditor-linkinspector-suggest-existing-page' => 'Umiiral na pahina',
	'visualeditor-linkinspector-suggest-new-page' => 'Bagong pahina',
	'visualeditor-linkinspector-suggest-external-link' => 'Kawing sa Web',
	'visualeditor-formatdropdown-title' => 'Baguhin ang anyo',
	'visualeditor-formatdropdown-format-paragraph' => 'Talata',
	'visualeditor-formatdropdown-format-heading1' => 'Pamuhatan 1',
	'visualeditor-formatdropdown-format-heading2' => 'Pamuhatan 2',
	'visualeditor-formatdropdown-format-heading3' => 'Pamuhatan 3',
	'visualeditor-formatdropdown-format-heading4' => 'Pamuhatan 4',
	'visualeditor-formatdropdown-format-heading5' => 'Pamuhatan 5',
	'visualeditor-formatdropdown-format-heading6' => 'Pamuhatan 6',
	'visualeditor-formatdropdown-format-preformatted' => 'May paunang kaanyuan',
	'visualeditor-annotationbutton-bold-tooltip' => 'Makapal',
	'visualeditor-annotationbutton-italic-tooltip' => 'Nakapahilis',
	'visualeditor-annotationbutton-link-tooltip' => 'Kawing',
	'visualeditor-indentationbutton-indent-tooltip' => 'Dagdagan ang pagkakayupi',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Bawasan ang pagkakayupi',
	'visualeditor-listbutton-number-tooltip' => 'Listahang may bilang',
	'visualeditor-listbutton-bullet-tooltip' => 'Listahang napungluan',
	'visualeditor-clearbutton-tooltip' => 'Hawiin ang kaanyuan',
	'visualeditor-historybutton-undo-tooltip' => 'Ibalik sa dati',
	'visualeditor-historybutton-redo-tooltip' => 'Gawing muli',
	'visualeditor-viewpage-savewarning' => 'Nakakatiyak ka bang nais mong magbalik sa gawi na nakikita na hindi muna nagsasagip?',
	'visualeditor-loadwarning' => 'Kamalian sa pagkakarga ng dato mula sa tagapaghain: $1. Nais mo bang subukan ulit?',
	'visualeditor-saveerror' => 'Kamalian sa pagsagip ng dato sa tagapaghain: $1.',
	'visualeditor-editsummary' => 'Ilarawan kung ano ang binago mo',
);

/** Urdu (اردو)
 * @author පසිඳු කාවින්ද
 */
$messages['ur'] = array(
	'visualeditor-feedback-prompt' => 'آپ کی رائے کو چھوڑ دو',
	'visualeditor-ca-editsource' => 'ذریعہ میں ترمیم کریں',
	'visualeditor-linkinspector-title' => 'لنک میں ترمیم کریں', # Fuzzy
	'visualeditor-linkinspector-label-pagetitle' => 'صفحہ کا عنوان',
	'visualeditor-formatdropdown-title' => 'تبدیلی کی شکل',
	'visualeditor-formatdropdown-format-paragraph' => 'پیرا',
	'visualeditor-listbutton-number-tooltip' => 'نمبر والی فہرست',
	'visualeditor-listbutton-bullet-tooltip' => 'شق کی فہرست',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'visualeditor' => 'Trình soạn thị giác',
	'visualeditor-desc' => 'Trình soạn thị giác MediaWiki',
	'visualeditor-preference-enable' => 'Sử dụng Trình soạn thị giác (chỉ có trong không gian tên chính)',
	'visualeditor-notification-saved' => 'Đã lưu các thay đổi của bạn tại $1.',
	'visualeditor-notification-created' => 'Đã tạo ra $1.',
	'visualeditor-ca-editsource' => 'Sửa đổi mã nguồn',
	'visualeditor-linkinspector-title' => 'Liên kết',
	'visualeditor-linkinspector-label-pagetitle' => 'Tên trang',
	'visualeditor-linkinspector-suggest-existing-page' => 'Trang đã tồn tại',
	'visualeditor-linkinspector-suggest-new-page' => 'Trang mới',
	'visualeditor-linkinspector-suggest-external-link' => 'Liên kết Web',
	'visualeditor-formatdropdown-title' => 'Thay đổi định dạng',
	'visualeditor-formatdropdown-format-paragraph' => 'Đoạn văn',
	'visualeditor-formatdropdown-format-heading1' => 'Đề mục cấp 1',
	'visualeditor-formatdropdown-format-heading2' => 'Đề mục cấp 2',
	'visualeditor-formatdropdown-format-heading3' => 'Đề mục cấp 3',
	'visualeditor-formatdropdown-format-heading4' => 'Đề mục cấp 4',
	'visualeditor-formatdropdown-format-heading5' => 'Đề mục cấp 5',
	'visualeditor-formatdropdown-format-heading6' => 'Đề mục cấp 6',
	'visualeditor-formatdropdown-format-preformatted' => 'Định dạng sẵn',
	'visualeditor-annotationbutton-bold-tooltip' => 'Đậm',
	'visualeditor-annotationbutton-italic-tooltip' => 'Xiên',
	'visualeditor-annotationbutton-link-tooltip' => 'Liên kết',
	'visualeditor-indentationbutton-indent-tooltip' => 'Tăng lề',
	'visualeditor-indentationbutton-outdent-tooltip' => 'Thụt lề',
	'visualeditor-listbutton-number-tooltip' => 'Danh sách đánh số',
	'visualeditor-listbutton-bullet-tooltip' => 'Danh sách không đánh số',
	'visualeditor-clearbutton-tooltip' => 'Xóa định dạng',
	'visualeditor-historybutton-undo-tooltip' => 'Hoàn tác',
	'visualeditor-historybutton-redo-tooltip' => 'Làm lại',
	'visualeditor-viewpage-savewarning' => 'Bạn có chắc chắn muốn quay trở về chế độ xem mà không lưu giữ trước tiên?',
	'visualeditor-loadwarning' => 'Lỗi tải dữ liệu từ máy chủ: $1. Bạn có muốn thử lại không?',
	'visualeditor-saveerror' => 'Lỗi lưu dữ liệu trên máy chủ: $1.',
	'visualeditor-editsummary' => 'Miêu tả các thay đổi của bạn',
	'visualeditor-aliennode-tooltip' => 'Rất tiếc, không thể sửa đổi phần tử này dùng Trình soạn thị giác',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Anakmalaysia
 * @author Liangent
 * @author Shirayuki
 * @author Shizhao
 */
$messages['zh-hans'] = array(
	'visualeditor' => '可视化编辑器',
	'visualeditor-desc' => 'MediaWiki的可视化编辑器',
	'visualeditor-feedback-prompt' => '留下反馈',
	'visualeditor-feedback-dialog-title' => '留下关于可视化编辑器的反馈',
	'visualeditor-ca-editsource' => '编辑源代码',
	'visualeditor-linkinspector-title' => '编辑链接', # Fuzzy
	'visualeditor-linkinspector-label-pagetitle' => '页面标题',
	'visualeditor-formatdropdown-title' => '更改格式',
	'visualeditor-formatdropdown-format-paragraph' => '段落',
	'visualeditor-formatdropdown-format-heading1' => '标题1',
	'visualeditor-formatdropdown-format-heading2' => '标题2',
	'visualeditor-formatdropdown-format-heading3' => '标题3',
	'visualeditor-formatdropdown-format-heading4' => '标题4',
	'visualeditor-formatdropdown-format-heading5' => '标题5',
	'visualeditor-formatdropdown-format-heading6' => '标题6',
	'visualeditor-formatdropdown-format-preformatted' => '预格式化文本',
	'visualeditor-annotationbutton-bold-tooltip' => '粗体',
	'visualeditor-annotationbutton-italic-tooltip' => '斜体',
	'visualeditor-annotationbutton-link-tooltip' => '链接',
	'visualeditor-indentationbutton-indent-tooltip' => '增加缩进',
	'visualeditor-indentationbutton-outdent-tooltip' => '减少缩进',
	'visualeditor-listbutton-number-tooltip' => '有序列表',
	'visualeditor-listbutton-bullet-tooltip' => '无序列表',
	'visualeditor-clearbutton-tooltip' => '清除格式',
	'visualeditor-historybutton-undo-tooltip' => '撤销',
	'visualeditor-historybutton-redo-tooltip' => '重做',
	'visualeditor-viewpage-savewarning' => '您确实要不保存而回到查看模式吗？',
	'visualeditor-loadwarning' => '从服务器载入数据错误：$1。您想重试吗？',
	'visualeditor-saveerror' => '向服务器保存数据错误：$1。',
);

/** Traditional Chinese (中文（繁體）‎)
 * @author Anakmalaysia
 * @author Simon Shek
 */
$messages['zh-hant'] = array(
	'visualeditor' => '可視化編輯器',
	'visualeditor-desc' => 'MediaWiki的可視化編輯器',
	'visualeditor-feedback-prompt' => '留下反饋',
	'visualeditor-feedback-dialog-title' => '留下關於可視化編輯器的反饋',
	'visualeditor-ca-editsource' => '編輯源代碼',
	'visualeditor-linkinspector-title' => '編輯鏈接', # Fuzzy
	'visualeditor-linkinspector-label-pagetitle' => '頁面標題',
	'visualeditor-formatdropdown-title' => '更改格式',
	'visualeditor-formatdropdown-format-paragraph' => '段落',
	'visualeditor-formatdropdown-format-heading1' => '標題 1',
	'visualeditor-formatdropdown-format-heading2' => '標題 2',
	'visualeditor-formatdropdown-format-heading3' => '標題 3',
	'visualeditor-formatdropdown-format-heading4' => '標題 4',
	'visualeditor-formatdropdown-format-heading5' => '標題 5',
	'visualeditor-formatdropdown-format-heading6' => '標題 6',
	'visualeditor-formatdropdown-format-preformatted' => '預格式化文本',
	'visualeditor-annotationbutton-bold-tooltip' => '粗體',
	'visualeditor-annotationbutton-italic-tooltip' => '斜體',
	'visualeditor-annotationbutton-link-tooltip' => '連結',
	'visualeditor-indentationbutton-indent-tooltip' => '增加縮進',
	'visualeditor-indentationbutton-outdent-tooltip' => '減少縮進',
	'visualeditor-listbutton-number-tooltip' => '有序列表',
	'visualeditor-listbutton-bullet-tooltip' => '無序列表',
	'visualeditor-clearbutton-tooltip' => '清除格式',
	'visualeditor-historybutton-undo-tooltip' => '撤銷',
	'visualeditor-historybutton-redo-tooltip' => '重做',
	'visualeditor-viewpage-savewarning' => '您確實要不保存而回到查看模式嗎？',
	'visualeditor-loadwarning' => '從服務器載入數據錯誤：$1。您想重試嗎？',
	'visualeditor-saveerror' => '向服務器保存數據錯誤：$1。',
);
