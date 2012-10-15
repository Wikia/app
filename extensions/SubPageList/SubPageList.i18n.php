<?php

/**
 * Internationalization file for the SubPageList extension.
 *
 * @file SubPageList.i18n.php
 * @ingroup SPL
 *
 * @licence GNU GPL v3 or later
 *
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

$messages = array();

/** English
 * @author Jeroen De Dauw
 */
$messages['en'] = array(
	'spl-desc' => 'Adds a <code><nowiki><splist /></nowiki></code> tag that enables you to list subpages',

	'spl-nosubpages' => 'Page "$1" has no subpages to list.',
	'spl-noparentpage' => 'Page "$1" does not exist.',
	'spl-nopages' => 'Namespace "$1" does not have pages.',

	'spl-subpages-par-sort' => 'The direction to sort in. Allowed values: "asc" and "desc".',
	'spl-subpages-par-sortby' => 'What to sort the subpages by. Allowed values: "title" or "lastedit".',
	'spl-subpages-par-format' => 'The subpage list can be displayed in several formats. Allowed values: "ol" — ordered (numbered) list, "ul" — unordered (bulleted) lists, "list" — plain lists (for example comma-separated list).',
	'spl-subpages-par-page' => 'The page to show the subpages for, or namespace name (including trailing colon) to show pages in. Defaults to the current page.',
	'spl-subpages-par-showpage' => 'Indicates if the page itself should be shown in the list or not.',
	'spl-subpages-par-pathstyle' => 'The style of the path for subpages in the list. Allowed values: "fullpagename" — full page name (including namespace), "pagename" — page name (without namespace), "subpagename" — relative page name starting from the page we list subpages for, "none" — just the trailing part of the name after last slash.',
	'spl-subpages-par-kidsonly' => 'Allows showing only direct subpages.',
	'spl-subpages-par-limit' => 'The maximum number of pages to list.',
	'spl-subpages-par-element' => 'The HTML element enclosing the list (including "intro" and "outro" or "default" texts). Allowed values: "div", "p", "span".',
	'spl-subpages-par-class' => 'The value for "class" attribute of HTML element enclosing the list.',
	'spl-subpages-par-intro' => 'The text to output before the list, if the list is not empty.',
	'spl-subpages-par-outro' => 'The text to output after the list, if the list is not empty.',
	'spl-subpages-par-default' => 'The text to output instead of the list, if the list is empty. If empty, error message will rendered (such as "Page has no subpages to list"). If dash ("-"), result will be completely empty.',
	'spl-subpages-par-separator' => 'The text to output between two list items in case of "list" (and its alias "bar") format. Has no effect in other formats.',
	'spl-subpages-par-template' => 'The name of template. The template is applied to every item of the list. An item is passed as the first (unnamed) argument. Note that template does not cancel list formatting. Formatting ("ul", "ol", "list") is applied to the template\'s result.',
	'spl-subpages-par-links' => 'If true, list items are rendered as links. If false, list items are rendered as plain text. The latter is especially helpful for passing items into templates for further processing.',
);

/** Message documentation (Message documentation)
 * @author Hamilton Abreu
 * @author Purodha
 */
$messages['qqq'] = array(
	'spl-subpages-par-format' => 'I believe, that the brackettet words should not be translated. --[[User:Purodha|Purodha Blissenbach]] 00:04, 21 January 2011 (UTC)',
	'spl-subpages-par-pathstyle' => 'The parameters "fullpagename", "pagename", "subpagename" and "none" should not be translated!',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Renessaince
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'spl-desc' => 'Дадае тэг <code><nowiki><splist /></nowiki></code>, які выводзіць сьпіс падстаронак',
	'spl-nosubpages' => 'Старонка «$1» ня мае падстаронак для сьпісу.',
	'spl-noparentpage' => 'Старонка «$1» не існуе.',
	'spl-nopages' => 'Прастора назваў «$1» ня ўтрымлівае старонак.',
	'spl-subpages-par-sort' => 'Напрамак сартаваньня. Дапушчальныя значэньні: "asc" і "desc".',
	'spl-subpages-par-sortby' => 'Ключ сартаваньня падстаронак. Дапушчальныя значэньні: "title" ці "lastedit".',
	'spl-subpages-par-format' => 'Сьпіс падстаронак можа быць паказаны ў некалькіх фарматах. Дапушчальныя значэньні: "ol" — нумараваныя сьпісы, "ul" — маркіраваныя сьпісы і "list" — простыя сьпісы (напрыклад, падзеленыя коскамі).',
	'spl-subpages-par-page' => "Старонка, для якой паказваць сьпіс падстаронак, альбо прастора назваў (улучна з заключным двухкроп'ем), у якой паказваць старонкі. Па змоўчваньні цяперашняя старонка.",
	'spl-subpages-par-showpage' => 'Паказвае, ці павінна паказвацца старонка ў сьпісе.',
	'spl-subpages-par-pathstyle' => 'Стыль шляху для падстаронак у сьпісе. Дапушчальныя значэньні: "fullpagename" — поўная назва старонкі (разам з прасторай назваў); "pagename" — назва старонкі (без прасторы назваў); "subpagename" — адносная назва старонкі, пачынаючы са старонкі, для якой пералічваюцца падстаронкі; "none" — толькі заключная частка назвы пасьля апошняй нахільнай рыскі.',
	'spl-subpages-par-kidsonly' => 'Паказваць толькі прамыя падстаронкі.',
	'spl-subpages-par-limit' => 'Максымальная колькасьць старонак для паказу.',
	'spl-subpages-par-element' => 'Элемэнт HTML, які агортвае сьпіс (разам з тэкстамі "intro" і "outro" або "default"). Дапушчальныя значэньні: "div", "p", "span".',
	'spl-subpages-par-class' => 'Значэньне атрыбуту «class» агортваючага сьпіс элемэнту HTML.',
	'spl-subpages-par-intro' => 'Тэкст для вываду перад сьпісам, калі той не пусты.',
	'spl-subpages-par-outro' => 'Тэкст для вываду пасьля сьпісу, калі той не пусты.',
	'spl-subpages-par-default' => 'Тэкст для вываду замест сьпісу, калі той пусты. Калі не зададзены, будзе згенэраванае паведамленьне пра памылку (кшталту «Старонка ня мае падстаронак для сьпісу»). Калі ж зададзены злучок («-»), выводзіцца пустое значэньне.',
	'spl-subpages-par-separator' => 'Тэкст для вываду паміж двума элемэнтамі сьпісу ў фарматах «list» і «bar». Для іншых фарматаў ня мае эфэкту.',
	'spl-subpages-par-template' => 'Назва шаблёну. Шаблён ужываецца для кожнага элемэнту сьпісу. Элемэнт перадаецца як першы (безназоўны) аргумэнт. Заўважце, што шаблён не скасоўвае фарматаваньне сьпісу. Фарматаваньне («ul», «ol», «list») ўжываецца да вынікаў шаблёну.',
	'spl-subpages-par-links' => 'Калі сапраўдна, элемэнты сьпісу выводзяцца як спасылкі. Калі несапраўдна, выводзяцца як звычайны тэкст. Апошняе асабліва зручна для перадачы элемэнтаў у шаблёны для далейшай апрацоўкі.',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'spl-desc' => 'Ouzhpennañ a ra ur valizenn  <code><nowiki><splist /></nowiki></code> a dalvez da rollañ an ispajennoù',
	'spl-nosubpages' => 'N\'eus ispajenn ebet da rollañ evit ar bajenn "$1".',
	'spl-subpages-par-sort' => 'Tu an urzhiañ. Tu zo da lakaat an talvoudennoù : "krsk" ha "digrsk".',
	'spl-subpages-par-sortby' => 'Penaos urzhiañ an ispajennoù dre. Talvoudennoù aotreet : "title\' pe "lastedit".',
	'spl-subpages-par-format' => 'Gallout a ra ar roll ispajennoù bezañ diskwelet dre furmadoù disheñvel : rolloù niverennet (ol), rolloù padennek (ul) pe rolloù dispartiet dre skejoù (roll).',
	'spl-subpages-par-page' => 'Ar bajenn da welet an ispajennoù. Ar bajenn red eo an hini dre ziouer.',
	'spl-subpages-par-showpage' => 'Merkañ a ra ha rankout a ra ar bajenn bezañ war ar roll pe get.',
	'spl-subpages-par-pathstyle' => 'Stil hent ispajennoù ar roll.',
	'spl-subpages-par-kidsonly' => 'Aotren a ra diskouez hepken an ispajennoù eeun',
	'spl-subpages-par-limit' => 'Niver brasañ a bajennoù da rollañ.',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'spl-desc' => 'Dodaje <code><nowiki><splist /></nowiki></code> oznaku koja vam omogućuje da pregledate podstranice',
	'spl-nosubpages' => '$1 nema podstranica za prikaz.',
	'spl-subpages-par-sort' => 'Smijer za redanje.',
);

/** German (Deutsch)
 * @author Kghbln
 * @author Purodha
 */
$messages['de'] = array(
	'spl-desc' => 'Ergänzt das Tag <code><nowiki><splist /></nowiki></code> zur Anzeige einer Liste von Unterseiten',
	'spl-nosubpages' => 'Seite „$1“ verfügt über keine auflistbaren Unterseiten.',
	'spl-noparentpage' => 'Seite „$1“ ist nicht vorhanden.',
	'spl-nopages' => 'Im Namensraum „$1“ befinden sich keine Seiten.',
	'spl-subpages-par-sort' => 'Sortierreihenfolge für die Unterseiten. Mögliche Werte: „asc“ (aufsteigend) und „desc“ (absteigend)',
	'spl-subpages-par-sortby' => 'Sortierkriterium für die Unterseiten. Mögliche Werte: „titel“ (Titel) und „lastedit“ (letzte Bearbeitung)',
	'spl-subpages-par-format' => 'Die Liste der Unterseiten kann in verschiedenen Formaten angezeigt werden. Mögliche Werte: „ol“ (sortierte nummerierte Liste), „ul“ (unsortierte Aufzählung) oder „list“ (einfache Liste, bspw. eine kommagetrennte Liste).',
	'spl-subpages-par-page' => 'Die Seite für welche die Unterseiten oder der Namensraum (einschließlich eines anschließenden Doppelpunkts) für den die enthaltenen Seiten angezeigt werden sollen. Standardmäßig ist dies die aktuelle Seite.',
	'spl-subpages-par-showpage' => 'Gibt an, ob die Seite selbst in der Liste ihrer Unterseiten angezeigt werden soll oder nicht.',
	'spl-subpages-par-pathstyle' => 'Anzeigestil für die Pfade in der Liste angezeigten Unterseiten. Mögliche Werte: „fullpagename“ (Seitenname einschließlich des Namensraums),  „pagename“ (Seitenname ausschließlich des Namensraums),  „subpagename“ (Seitenname der Unterseiten der aktuellen Seite) und „none“ (lediglich der auf den letzten Schrägstrich folgende Teil des Seitennamens).',
	'spl-subpages-par-kidsonly' => 'Ermöglicht ausschließlich die Anzeige der direkten Unterseiten.',
	'spl-subpages-par-limit' => 'Die Höchstzahl der aufzulistenden Unterseiten.',
	'spl-subpages-par-element' => 'Das HTML-Element, das die Liste umschließen soll (einschließlich der Texte „intro“, „outro“ oder „standard“). Mögliche Werte: „div“, „p“, „span“.',
	'spl-subpages-par-class' => 'Der Wert für das Attribut „class“ des HTML-Elements, das die Liste umschließt.',
	'spl-subpages-par-intro' => 'Der vor der Liste auszugebende Text („intro“), sofern sie nicht leer ist.',
	'spl-subpages-par-outro' => 'Der nach der Liste auszugebende Text („outro“), sofern sie nicht leer ist.',
	'spl-subpages-par-default' => 'Der anstatt einer Liste auszugebende Text („standard“), sofern sie leer ist. Sofern sie leer ist, wird also eine Fehlermeldung, wie bspw. „Zu dieser Seite gibt es keine Unterseiten.“ ausgegeben. Wenn ein Bindestrich („-“) angegeben wird, wird die Ergebnisausgabe vollkommen leer sein.',
	'spl-subpages-par-separator' => 'Der zwischen den Listenelementen auszugebende Text, sofern die Anzeigeformate „list“ oder „bar“ genutzt wird. Er wird nicht bei anderen Formaten ausgegeben.',
	'spl-subpages-par-template' => 'Der Name der Vorlage. Die Vorlage wird auf jedes Listenelement angewendet. Ein Listenelement wird als erstes (unbezeichnetes) Argument an die Vorlage übergeben. Es ist zu beachten, dass die Vorlage nicht die Listenformatierung verändert. Die Formatierungsmöglichkeiten „ul“, „ol“ und „list“ werden also auf das in der Vorlage ausgegebene Ergebnis angewendet.',
	'spl-subpages-par-links' => 'Sofern aktiviert werden die Listenelemente als Links dargestellt. Sofern deaktiviert, werden die Listenelement im Textformat ausgegeben. Letztere Einstellung ist besonders dann hilfreich, wenn man die Ausgabeergebnisse an die Vorlage zur weiteren Verarbeitung weitergibt.',
);

/** French (Français)
 * @author Gomoko
 * @author Hashar
 * @author Seb35
 * @author Sherbrooke
 * @author Toliño
 */
$messages['fr'] = array(
	'spl-desc' => 'Ajoute une balise <nowiki><splist /></nowiki> qui permet de lister les sous-pages',
	'spl-nosubpages' => 'La page « $1 » n’a pas de sous-pages à lister.',
	'spl-noparentpage' => 'La page « $1 » n’existe pas.',
	'spl-nopages' => 'L’espace de nom « $1 » n’a pas de pages.',
	'spl-subpages-par-sort' => 'Le sens de tri. Valeurs permises: "asc" et "desc".',
	'spl-subpages-par-sortby' => 'Selon quoi trier les sous-pages. Valeurs permises: "title" ou "lastedit".',
	'spl-subpages-par-format' => 'La liste des sous-pages peut être affichée selon différents formats. Valeurs permises: "ol" - listes ordonnées (numérotées), "ul" - listes non ordonnées (à puces), "list" -  listes simples (par exemple liste séparée par des virgules).',
	'spl-subpages-par-page' => "La page pour afficher les sous-pages, ou l'espace de nommage (y compris le deux-points final) dont les pages sont à afficher. Par défaut, la page courante.",
	'spl-subpages-par-showpage' => 'Indique si la page elle-même doit figurer dans la liste ou non.',
	'spl-subpages-par-pathstyle' => 'Le style de chemin pour les sous-pages dans la liste. Valeurs permises: "fullpagename" - nom complet de la page (y compris l\'espace de noms), "pagename" - nom de la page (sans l\'espace de noms), "subpagename" - nom relatif de la page en démarrant de la page depuis laquelle nous listons les sous-pages, "none" - uniquement la dernière partie du nom, après le dernier slash.',
	'spl-subpages-par-kidsonly' => "Permet de n'afficher que les sous-pages immédiates.",
	'spl-subpages-par-limit' => 'La quantité maximale de pages à lister.',
	'spl-subpages-par-element' => 'L\'élément HTML englobant la liste (y compris les textes "intro" et "outro" ou "default"). Valeurs permises: "div", "p", "span".',
	'spl-subpages-par-class' => "La valeur pour l'attribut HTML « class » encadrant la liste.",
	'spl-subpages-par-intro' => "Le texte à renvoyer avant la liste, si celle-ci n'est pas vide.",
	'spl-subpages-par-outro' => "Le texte à renvoyer après la liste, si celle-ci n'est pas vide.",
	'spl-subpages-par-default' => 'La texte à renvoyer à la place de la liste, si celle-ci est vide. S\'il est vide, un message d\'erreur sera renvoyé (comme "La page n\'a aucune sous-page à lister"). S\'il est mis à un tiret ("-"), le résultat sera complètement vide.',
	'spl-subpages-par-separator' => 'Le texte à renvoyer entre deux éléments de la liste, dans le cas d\'un format "list" (et son alias "bar"). N\'a pas d\'effet dans les autres formats.',
	'spl-subpages-par-template' => 'Le nom du modèle. Le modèle est appliqué à chaque élément de la liste. Un élément est passé comme premier argument (non nommé). Remarquez que le modèle n\'annule pas le formatage de la liste. Le formatage ("ul", "ol", "list") est appliqué au résultat du modèle.',
	'spl-subpages-par-links' => "S'il est vrai, les éléments de liste sont rendus comme des liens. S'il est faux, les éléments de liste sont rendus comme du texte simple. Ce dernier est particulièrement utile pour passer des éléments dans les modèles pour un traitement ultérieur.",
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'spl-nosubpages' => 'Pâge « $1 » at gins de sot-pâge a ènumèrar.',
	'spl-noparentpage' => 'Pâge « $1 » ègziste pas.',
	'spl-nopages' => 'L’èspâço de noms « $1 » contint gins de pâge.',
	'spl-subpages-par-sort' => "La dirèccion de tri. Valors pèrmêses : « asc » (''crèssent'') et « desc » (''dècrèssent'').",
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'spl-desc' => 'Engade unha etiqueta <code><nowiki><splist /></nowiki></code> que permite poñer as subpáxinas nunha lista',
	'spl-nosubpages' => 'A páxina "$1" non ten subpáxinas que poñer nunha lista.',
	'spl-noparentpage' => 'A páxina "$1" non existe.',
	'spl-nopages' => 'O espazo de nomes "$1" non ten páxinas.',
	'spl-subpages-par-sort' => 'A dirección de ordenación. Valores permitidos: "asc" e "desc".',
	'spl-subpages-par-sortby' => 'O criterio de ordenación das subpáxinas. Valores permitidos: "title" ou "lastedit"',
	'spl-subpages-par-format' => 'A lista de subpáxinas pódese mostrar en varios formatos. Valores permitidos: "ol", listas ordenadas (numeradas); "ul", listas desordenadas (con asteriscos); e "list", listas simples (por exemplo, separadas por comas).',
	'spl-subpages-par-page' => 'A páxina na que mostrar as subpáxinas ou o espazo de nomes (incluídos os dous puntos) no que mostrar as páxinas. A páxina actual é a predeterminada.',
	'spl-subpages-par-showpage' => 'Indica se a páxina en si debería figurar ou non na lista.',
	'spl-subpages-par-pathstyle' => 'O estilo da ruta de acceso ás subpáxinas da lista. Valores permitidos: "fullpagename", nome completo da páxina (incluído o espazo de nomes); "pagename", nome da páxina (sen o espazo de nomes); "subpagename", nome relativo da páxina comezando a partir daquela da que se van poñer as subpáxinas nunha lista; e "none", unicamente a parte do nome despois da última barra inclinada.',
	'spl-subpages-par-kidsonly' => 'Permite mostrar só as subpáxinas directas.',
	'spl-subpages-par-limit' => 'O número máximo de páxinas a poñer nunha lista.',
	'spl-subpages-par-element' => 'O elemento HTML que engloba a lista (incluíndo os textos "intro" e "outro" ou "default"). Valores permitidos: "div", "p" e "span".',
	'spl-subpages-par-class' => 'O valor para o atributo "class" do elemento HTML que engloba a lista.',
	'spl-subpages-par-intro' => 'O texto que mostrar antes da lista, se esta non está baleira.',
	'spl-subpages-par-outro' => 'O texto que mostrar despois da lista, se esta non está baleira.',
	'spl-subpages-par-default' => 'O texto que mostrar no canto da lista, se esta está baleira. Nesta caso, aparecerá unha mensaxe de erro (como "A páxina non ten subpáxinas que poñer nunha lista"). Se o valor fose un guión ("-"), o resultado sería completamente baleiro.',
	'spl-subpages-par-separator' => 'O texto que mostrar entre dous elementos da lista en caso dun formato "list" (e o seu idéntico "bar"). Non ten efecto sobre outros formatos.',
	'spl-subpages-par-template' => 'O nome do modelo. O modelo aplícase a cada elemento da lista. Un elemento é tratado como o primeiro argumento (sen nome). Nótese que o modelo non cancelar o formato da lista. O formato ("ul", "ol", "list") aplícase ao resultado do modelo.',
	'spl-subpages-par-links' => 'Se fose verdadeiro, os elementos da lista preséntanse como ligazóns. En caso de ser falso, os elementos da lista móstranse como texto simple. Isto último é especialmente útil para presentar elementos nos modelos para procesalos posteriormente.',
);

/** Hebrew (עברית)
 * @author Amire80
 */
$messages['he'] = array(
	'spl-desc' => 'הוספת התג <code><nowiki><splist /></nowiki></code> ליצירת רשימת דפי־משנה',
	'spl-nosubpages' => 'לדף "$1" אין דפי משנה שאפשר להציג ברשימה.',
	'spl-subpages-par-sort' => 'באיזה כיוון למיין.',
	'spl-subpages-par-sortby' => 'לפי מה למיין את דפי־המשנה.',
	'spl-subpages-par-format' => 'רשימת דפי־המשנה יכולה להיות מוצגת במספר עיצובים. רשימה ממוספרת (ol), רשימת תבליטים (ul), ורשימה מופרדת בפסיקים (list).',
	'spl-subpages-par-page' => 'על איזה דף להציג את דפי־המשנה. בררת המחדל: הדף הנוכחי.',
	'spl-subpages-par-showpage' => 'מציין אם הדף עצמו צריך להיות מוצג ברשימה או לאו.',
	'spl-subpages-par-pathstyle' => 'סגנון הנתיב אל דפי־המשנה ברשימה.',
	'spl-subpages-par-kidsonly' => 'מאפשר להראות רק דפי־משנה ישירים.',
	'spl-subpages-par-limit' => 'המספר המרבי של דפים להציג.',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'spl-desc' => 'Přidawa element <code><nowiki><splist /></nowiki></code>, kotryž ći zmóžnja podstrony nalistować',
	'spl-nosubpages' => 'Strona "$1" nima podstrony za lisćinu.',
	'spl-noparentpage' => 'Strona "$1" njeeksistuje',
	'spl-nopages' => 'W mjenowym rumje "$1" strony njejsu.',
	'spl-subpages-par-sort' => 'Sortěrowanski porjad. Dowolene hódnoty: "asc" (postupowacy) a "desc" (spadowacy).',
	'spl-subpages-par-sortby' => 'Sortěrowanski kriterij podstronow. Dowolene hódnoty: "title" (titul) abo "lastedit" (poslednja změna)',
	'spl-subpages-par-format' => 'Lisćina podstronow hodźi so we wšelakich formatach zwobraznić. Dowolene hódnoty: "ol" - (čisłowana lisćina), "ul" - naličenje (nječisłowana lisćina), "list" - jednora lisćina (za na př. lisćinu z přez komu dźělenymi zapiskami).',
	'spl-subpages-par-page' => 'Strona, za kotruž maja so podstrony pokazać, abo mjenowy rum (inkluziwnje dwudypka), w kotrymž strony maja so  pokazać. Standard je aktualna strona.',
	'spl-subpages-par-showpage' => 'Podawa, hač strona sama měła so w lisćinje pokazać abo nic.',
	'spl-subpages-par-pathstyle' => 'Stil šćežki za podstrony w lisćinje. Dowolene hódnoty: "fullpagename" — mjeno strony inkluziwnje mjenoweho ruma, "pagename" — mjeno strony bjez mjenoweho ruma, "subpagename" — relatiwne mjeno strony započinajo ze stronu, za kotruž so podstrony nalistuja, "none" — jenož tón dźěl mjena, kotryž poslednjej nakósnej smužce slěduje.',
	'spl-subpages-par-kidsonly' => 'Móže  jenož direktne podstrony pokazać.',
	'spl-subpages-par-limit' => 'Maksimalna ličba stronow, kotrež maja so nalsitować.',
	'spl-subpages-par-element' => 'HTML-element, kotryž ma lisćinu wopřijeć (inkluziwnje teksty "intro" a "outro" abo "standard"). Dowolene hódnoty: "div", "p", "span".',
	'spl-subpages-par-class' => 'Hódnota atributa "class" HTML-elementa, kotryž lisćinu wopřijima.',
	'spl-subpages-par-intro' => 'Tekst, kotryž ma so před lisćinu wudać, jeli lisćina prózdna njeje.',
	'spl-subpages-par-outro' => 'Tekst, kotryž ma so po lisćinje wudać, jeli lisćina prózdna njeje.',
	'spl-subpages-par-default' => 'Tekst, kotryž ma so město lisćiny wudać, jeli lisćina je prózdna. Jeli je prózdna, wuda so zmylkowa zdźělenka (na př. "Strona podstrony nima"). Jeli wjazawku ("-") wobsahuje, budźe wuslědk cyle pródzny.',
	'spl-subpages-par-separator' => 'Tekst, kotryž ma so mjez dwěmaj lisćinowymaj zapiskomaj, jeli so format "list" (abo jeho alis "bar") wužiwa. To nima wuskutk na druhe formaty.',
	'spl-subpages-par-template' => 'Mjeno předłohi. Předłoha nałožuje so na kóždy zapisk lisćiny. Zapisk přepodawa so jako prěni argument (bjez mjena). Wobkedźbuj, zo předłoha njepřetorhnje formatowanje lisćiny. Formatowanje ("ul", "ol", "list") nałožuje so na wuslědk předłohi.',
	'spl-subpages-par-links' => 'Jeli zmóžnjene, lisćinowe zapiski zwobraznjeja so jako wotkazy. Jeli znjemóžnjene, lisćinowe zapiski zwobraznjeja so jako luty tekst. Druhi pad je wosebje wužitny za přepodawanje zapiskow do předłohow za dalše předźěłowanje.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'spl-desc' => 'Adde un etiquetta <code><nowiki><splist /></nowiki></code> que permitte listar subpaginas',
	'spl-nosubpages' => 'Le pagina "$1" non ha subpaginas a listar.',
	'spl-noparentpage' => 'Le pagina "$1" non existe.',
	'spl-nopages' => 'Le spatio de nomines "$1" non ha paginas.',
	'spl-subpages-par-sort' => 'Le direction in le qual ordinar. Valores permittite: "asc" e "desc".',
	'spl-subpages-par-sortby' => 'Criterio secundo le qual ordinar le subpaginas. Valores permittite: "title" (titulo) o "lastedit" (ultime modification).',
	'spl-subpages-par-format' => 'Le lista de subpaginas pote esser presentate in plure formatos. Valores permittite: "ol" — lista ordinate (con numeros), "ul" — lista non ordinate (con punctos), "list" — lista simple (p.ex. un lista separate per commas).',
	'spl-subpages-par-page' => 'Le pagina del qual presentar le subpaginas, o le nomine del spatio de nomines (incluse le duo punctos final) del qual presentar le paginas. Le predefinition es le pagina actual.',
	'spl-subpages-par-showpage' => 'Indica si le pagina mesme debe figurar in le lista o non.',
	'spl-subpages-par-pathstyle' => 'Le stilo del cammino pro subpaginas in le lista. Valores permittite: "fullpagename" — nomine complete del pagina (incluse le spatio de nomines), "pagename" — nomine del pagina (sin spatio de nomines), "subpagename" — nomine relative del pagina, comenciante al pagina del qual nos lista le subpaginas, "none" — solmente le parte final del nomine post le ultime barra oblique.',
	'spl-subpages-par-kidsonly' => 'Permitte monstrar solmente subpaginas directe.',
	'spl-subpages-par-limit' => 'Le numero maxime de paginas a listar.',
	'spl-subpages-par-element' => 'Le elemento HTML que circumfere le lista (incluse le textos "intro" e "outro" o "default"). Valores permittite: "div", "p", "span".',
	'spl-subpages-par-class' => 'Le valor del attributo "class" del elemento HTML que circumfere le lista.',
	'spl-subpages-par-intro' => 'Le texto a presentar ante le lista, si le lista non es vacue.',
	'spl-subpages-par-outro' => 'Le texto a presentar post le lista, si le lista non es vacue.',
	'spl-subpages-par-default' => 'Le texto a presentar in loco del lista, si le lista es vacue. Si vacue, un message de error essera rendite (como "Le pagina non ha subpaginas a listar"). Si es un lineetta ("-"), le resultato essera completemente vacue.',
	'spl-subpages-par-separator' => 'Le texto a presentar inter duo elementos del lista in caso del formatos "list" o "bar". Non ha effecto in altere formatos.',
	'spl-subpages-par-template' => 'Le nomine del patrono. Le patrono es applicate a cata elemento del lista. Un elemento es passate como le prime argumento (sin nomine). Nota que le patrono non cancella le formatation del lista. Le formatation ("ul", "ol", "list") es applicate al resultato del patrono.',
	'spl-subpages-par-links' => 'Si ver, le elementos del lista es rendite como ligamines. Si false, le elementos del lista es rendite como texto simple. Iste ultime option es particularmente utile pro passar elementos a in patronos pro ulterior processamento.',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 */
$messages['id'] = array(
	'spl-desc' => 'Memberikan tag <code><nowiki><splist /></nowiki></code> yang memungkinkan Anda untuk melihat daftar subhalaman',
	'spl-nosubpages' => '$1 tidak memiliki subhalaman untuk ditampilkan.',
	'spl-subpages-par-sort' => 'Arah urutan.',
	'spl-subpages-par-sortby' => 'Cara pengurutan subhalaman.',
	'spl-subpages-par-format' => 'Daftar subhalaman dapat ditampilkan dalam berbagai format, yaitu daftar bernomor (ol), daftar butir (ul), dan daftar dipisahkan koma (list).',
	'spl-subpages-par-page' => 'Halaman yang akan ditampilkan subhalamannya. Setelan bawaan: halaman saat ini.',
	'spl-subpages-par-showpage' => 'Menunjukkan apakah halaman itu sendiri harus ditampilkan atau tidak dalam daftar.',
	'spl-subpages-par-pathstyle' => 'Gaya jalur subhalaman dalam daftar.',
	'spl-subpages-par-kidsonly' => 'Hanya tampilkan subhalaman langsung.',
	'spl-subpages-par-limit' => 'Jumlah halaman maks. yang ditampilkan.',
);

/** Japanese (日本語)
 * @author Schu
 */
$messages['ja'] = array(
	'spl-desc' => 'サブページの一覧を表示可能にする <code><nowiki><splist /></nowiki></code> タグを追加します。',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'spl-desc' => 'Deiht dä Befähl <code><nowiki><splist /></nowiki></code> en et Wiki, för Ongersigge aanzezeije.',
	'spl-nosubpages' => 'Di Sigg „$1“ hät kein Ongersigge zom Opleßte.',
	'spl-noparentpage' => 'En Sigg „$1“ jidd_et nit.',
	'spl-subpages-par-sort' => 'Wieröm zoteet wääde sull.',
	'spl-subpages-par-sortby' => 'Noh wat de Ongersigge zoteet wääde sulle.',
	'spl-subpages-par-format' => 'De Leß met de Ongersigge kann ongerscheidlijje Jeschtalte han: met Nummere (ol) met Punkte (ul) un alles ein eine Reih met Kommas dozwesche (list)',
	'spl-subpages-par-page' => 'De Sigg, woh de Ongersigge vun jezeich wääde sulle. Wam_mer nix säät, es dat de Sigg, di jraad jezeich weed.',
	'spl-subpages-par-showpage' => 'Jitt aan, ov de Sigg selver och en dä Leß met dä iehre Ongersigge aanjezeisch wääde sull, udder nit.',
	'spl-subpages-par-pathstyle' => 'Dä Stil vun de Aanzeije vun däm Pad vun de Ongersigge en dä Leß.
Zohjelohße es:
<code lang="en">fullpagename</code> — Dä janze Name vun dä Sigg mem Appachtemang.
<code lang="en">pagename</code> — Dä janze Name vun dä Sigg der ohne et Appachtemang.
<code lang="en">subpagename</code> — Bloß der Deil vum Name henger dä Sigg, woh mer Ongersigge vun opleste donn.
<code lang="en">none</code> — Blos et Engk vum Name henger_em läzde schrääje Schtresch.',
	'spl-subpages-par-kidsonly' => 'Määt et müjjelesch, bloß de diräkte Ongersigge opzeleßte.',
	'spl-subpages-par-limit' => 'De jrüüßte Zahl Sigge för opzeleste.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'spl-desc' => 'Setzt den <code><nowiki><splist /></nowiki></code>-Tag fir Ënnersäiten ze weisen derbäi',
	'spl-nosubpages' => 'D\'Säit "$1" huet keng Ënnersäite fir ze weisen.',
	'spl-noparentpage' => 'D\'Säit "$1" gëtt et net.',
	'spl-nopages' => 'Am Nummraum "$1" gëtt et keng Säiten.',
	'spl-subpages-par-sort' => 'Reiefolleg wéi zortéiert soll ginn. Erlaabte Wäerter: "asc" an "desc".',
	'spl-subpages-par-sortby' => 'Wourop d\'Ënnersäiten zortéiert ginn. Erlaabte Wäerter: "titel" oder "lescht Ännerung".',
	'spl-subpages-par-format' => 'D\'Lëscht vun den Ënnersäite kann a verschiddene Formater gewise ginn. Erlaabte Wäerter: "ol" Numeréiert Lëschten, "ul" Lëschte mat Punkten, "list" ganz Lëschten (z. Bsp. "comma seperated" Lëscht).',
	'spl-subpages-par-page' => "D'Säit fir déi Ënnersäite gewise solle ginn, oder Numm vum Nummraum (inklusiv den Doppelpunkt) an deem Säite solle gewise ginn. Als Standard ass dat déi aktuell Säit.",
	'spl-subpages-par-showpage' => "Gëtt un ob d'Säit selwer an der Lëscht gewise soll ginn oder net.",
	'spl-subpages-par-pathstyle' => 'Styl vum Wee (path) fir Ënnersäiten an der Lëscht. Erlaabte Wäerter: "fullpagename" - Kompletten Numm vun der Säit (inklusiv den Nummraum), "pagename" - Numm vun der säit (ouni Nummraum), "subpagename" - Relative Numm vun der Säit ugefaang vun de Säit fir déi mir Ënnersäiten opzielen, "none" -  just deen Deel vum Numm deen no dem lescht Slash kënnt.',
	'spl-subpages-par-kidsonly' => 'Erlaabt fir nëmmen direkt Ënnersäiten ze weisen.',
	'spl-subpages-par-limit' => "D'Maximalzuel vu Säiten déi gewise ginn.",
	'spl-subpages-par-intro' => 'Den Text virun der Lëscht, wann se net eidel ass.',
	'spl-subpages-par-outro' => 'Den Text hannert der Lëscht, wann se net eidel ass.',
	'spl-subpages-par-default' => 'Den Text deen gewise amplaz vun der Lëscht gëtt, wann d\'Lëscht eidel ass. Wann se eidel ass, gëtt e Feeler-Message generéiert (esou wéi "D\'Säit huet keng Ënnersäiten"). Wann et e bindestrich ass ("-"), ass d\'Resultat komplett eidel.',
	'spl-subpages-par-template' => 'Den Numm vun der Schabloun. D\'Schabloun gëtt fir all Element vun der Lëscht benotzt. Een Element gëtt als éischt (ongenannt) Argument un D\'Schabloun viruginn. Denkt drun datt d\'Schabloun de Format vun der Lëscht net ännert. D\'Formatéierung ("ul", "ol", "list") gëtt op d\'Resultat vun der Schabloun applizéiert.',
	'spl-subpages-par-links' => "Wann et aktivéiert ass ginn d'Elementer vun der Lëscht als Linken duergestallt. Wann et net aktivéiert ass ginn d'Elementer vun der Lëscht als normalen Text duergestallt. Déi lescht Optioun ass besonnesch nëtzlech fir Elementer a Schablounen anzebannen an duerno weider ze verschaffen.",
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'spl-desc' => 'Додава ознака <code><nowiki><splist /></nowiki></code> што овозможува наведување на потстраници во список',
	'spl-nosubpages' => 'Страницата „$1“ нема потстраници за наведување.',
	'spl-noparentpage' => 'Страницата „$1“ не постои.',
	'spl-nopages' => 'Именскиот простор „$1“ нема страници.',
	'spl-subpages-par-sort' => '!Насока на подредување. Допуштени вредности: „asc“ и „desc“.',
	'spl-subpages-par-sortby' => 'По што да се подредат потстраниците. Допуштени вредности: „title“ or „lastedit“.',
	'spl-subpages-par-format' => 'Списокот на потстраници може да се прикаже во неколку формати. Допуштени вредности: „ol“ — подреден список (со бројки), „ul“ — неподредени списоци (потточки), „list“ прости списоци (на пр. список одделем со запирки).',
	'spl-subpages-par-page' => 'За која страница да се прикажат потстраниците, или називот на именскиот простор (вклучувајќи ги двете точки на крајот). По основно - тековната страница.',
	'spl-subpages-par-showpage' => 'Назначува дали во списокот да се прикаже и самата страница.',
	'spl-subpages-par-pathstyle' => 'Стилот на патеката за потстраниците во списокот. Допуштени вредности: „fullpagename“ — полно име на страницата (вклучувајќи го именскиот простор), „pagename“ — име на страницата (без именски простор), „subpagename“ — релативно име на страницата почнувајќи од страницата за која наведуваме потстраници, „none“ — само последниот дел од името што се наоѓа по последната коса црта.',
	'spl-subpages-par-kidsonly' => 'Овозможува приказ само на директни потстраници.',
	'spl-subpages-par-limit' => 'Максималниот број на страници за наведување во списокот.',
	'spl-subpages-par-element' => 'HTML-елементот што го опколува списокот (вклучувајќи ги текстовите во „intro“ и „outro“ или пак „default“). Допуштени вредности: „div“, „p“, „span“.',
	'spl-subpages-par-class' => 'Вредноста за атрибутот „class“ на HTML-елементот што го обиколува списокот.',
	'spl-subpages-par-intro' => 'Текстот пред сисокот, ако списокот не е празен.',
	'spl-subpages-par-outro' => 'Текстот по сисокот, ако списокот не е празен.',
	'spl-subpages-par-default' => 'Текстот за приказ наместо списокот, ако списокот е празен. Ако е празна, ќе се појави порака за грешка (како „Страницата нема потстраници“). Ако има цртичка („-“), резултатот ќе биде сосем празен.',
	'spl-subpages-par-separator' => 'Текстот помеѓу две ставки во списокот за форматите „list“ или „bar“. Не дејствува на другите формати.',
	'spl-subpages-par-template' => 'Името на шаблонот. Шаблонот се применува врз секоја ставка во списокот. Како прв (неименуван) аргумент се зема ставка. Имајте предвид дека шаблонот не го поништува форматирањето на списокот. Врз резултатот на шаблонот се применува форматирање („ul“, „ol“, „list“).',
	'spl-subpages-par-links' => 'Ако е точно, ставките во списокот се прикажуваат како врски. Ако е неточно, тогаш ставките се прикажуваат како прост текст. Второспоменатото е особено корисно за доставка на ставки во шаблони за понатамошна обработка.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'spl-desc' => 'Legger til et <code><nowiki><splist /></nowiki></code>-element som lar deg liste opp undersider',
	'spl-nosubpages' => '$1 har ingen undersider å liste opp.',
	'spl-subpages-par-sort' => 'Retningen du vil sortere i.',
	'spl-subpages-par-sortby' => 'Hva du vil sortere undersidene etter.',
	'spl-subpages-par-format' => 'Undersidelisten kan vises i flere format. Nummererte lister (ol), punktlister (ul) og kommaseparerte lister (list).',
	'spl-subpages-par-page' => 'Siden undersidene skal vises for. Standard er den gjeldende siden.',
	'spl-subpages-par-showpage' => 'Indikerer om selve siden skal vises i listen eller ikke.',
	'spl-subpages-par-pathstyle' => 'Stilen på banen for undersidene i listen.',
	'spl-subpages-par-kidsonly' => 'Tillater kun å vise direkte undersider.',
	'spl-subpages-par-limit' => 'Maksimum antall sider å liste opp.',
);

/** Dutch (Nederlands)
 * @author McDutchie
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'spl-desc' => "Voegt het label <code><nowiki><splist /></nowiki></code> toe dat het mogelijk maakt een lijst met subpagina's weer te geven",
	'spl-nosubpages' => 'Pagina "$1" heeft geen subpagina\'s.',
	'spl-noparentpage' => 'Pagina "$1" bestaat niet.',
	'spl-nopages' => 'Naamruimte "$1" heeft geen pagina\'s.',
	'spl-subpages-par-sort' => 'De richting voor de sorteervolgorde. Toegestande waarden: "asc" (oplopend") en "desc" (aflopend).',
	'spl-subpages-par-sortby' => 'Hoe de subpagina\'s te sorteren. Toegestane waarden: "title" (paginanaam) en "lastedit" (laatste bewerking).',
	'spl-subpages-par-format' => 'De lijst met subpagina\'s kan op verschillende manieren weergegeven worden. Als genummerde lijst ("ol"), ongenummerde lijst ("ul") en als door komma\'s gescheiden lijst ("list"), bijvoorbeeld een door komma\'s gescheiden lijst.',
	'spl-subpages-par-page' => "De pagina waarvoor subpagina's weergegeven moeten worden of een naamruimtenaam (inclusief de dubbele punt als achtervoegsel). Dit is standaard de huidige pagina.",
	'spl-subpages-par-showpage' => 'Geeft aan of de pagina zelf weergegeven moet worden in de lijst of niet.',
	'spl-subpages-par-pathstyle' => 'De stijl van het pad voor subpagina\'s in de lijst. Toegestane waarden: "fullpagename": volledige paginanaam, inclusief naamruimte, "pagename": paginanaam zonder naamruimte, "subpagename": relatieve paginanaam vanaf de pagina waarvoor subpagina\'s worden weergegeven, "none": alleen het achtervoegsel van de naam na de laatste slash.',
	'spl-subpages-par-kidsonly' => "Maakt het mogelijk om alleen subpagina's van het eerste niveau weer te geven.",
	'spl-subpages-par-limit' => "Het maximale aantal weer te geven pagina's.",
	'spl-subpages-par-element' => 'Het HTML-element dat de lijst omsluit (inclusief "intro" en "outro" of "default" teksten). Toegestane waarden: "div", "p", "span".',
	'spl-subpages-par-class' => 'De waarde voor het "class"-attribuut van het HTML-element waarin de lijst is omsloten.',
	'spl-subpages-par-intro' => 'De uit te voeren tekst vóór de lijst als de lijst niet leeg is.',
	'spl-subpages-par-outro' => 'De uit te voeren tekst na de lijst, als de lijst niet leeg is.',
	'spl-subpages-par-default' => 'De weer te geven tekst in plaats van de lijst als de lijst leeg is. Als dit leeg is, wordt een foutmelding gegeven, zoals "Er zijn geen weer te geven subpagina\'s". Bij gebruik van het teken "-" is het resultaat volledig leeg.',
	'spl-subpages-par-separator' => 'De uit te voeren tekst tussen twee lijstelementen voor een "list" (lijstweergave) of "bar" (balkweergave). Dit heeft geen effect op andere weergaven.',
	'spl-subpages-par-template' => 'De naam van het sjabloon. Het sjabloon wordt toegepast op ieder element in de lijst. Een element wordt doorgegeven als het eerste (onbenoemde) argument. Let op dat het sjabloon de lijstopmaak niet verwijdert; de opmaak ("ul", "ol" of "list") wordt toegepast op het resultaat van het sjabloon.',
	'spl-subpages-par-links' => 'Lijstelementen worden opgemaakt als verwijzingen als waar. Lijstelementen zijn platte tekst als onwaar. De laatste optie is handig bij het doorgeven van elementen aan sjablonen voor verdere verwerking.',
);

/** Polish (Polski)
 * @author Woytecr
 */
$messages['pl'] = array(
	'spl-desc' => 'Dodaje tag <code><nowiki><splist /></nowiki></code> pozwalający na wstawienie listy podstron',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'spl-desc' => 'A gionta un sìmbol <code><nowiki><splist /></nowiki></code> che at abìlita a listé le sot-pagine',
	'spl-nosubpages' => "La pàgina $1 a l'ha gnun-e sot-pàgine da listé.",
	'spl-subpages-par-sort' => 'La diression për ordiné. Valor përmëttù: «asc» e «desc».',
	'spl-subpages-par-sortby' => 'Criteri për ordiné le pagine. Valor përmëttù :«tìtol» o «ùltima modìfica».',
	'spl-subpages-par-format' => "La lista dle sot-pàgine a peul esse mostrà an vàire formà. Valor përmëttù: «ol» - lista ordinà (numerà), «ul» lista nen ordinà (a pont), «lista» - lista sempia (për esempi, lista separà da 'd vìrgole).",
	'spl-subpages-par-page' => 'La pàgina dont smon-e le sot-pàgine. o lë spassi nominal. Për stàndard la pagina corenta.',
	'spl-subpages-par-showpage' => 'A ìndica se la pagina midema a dev esse mostrà ant la lista o nò.',
	'spl-subpages-par-pathstyle' => "Lë stit dël përcors për le sot-pàgine ant la lista. Valor përmëttù: «nòmcompletpàgina» - nòm complet ëd la pàgina (spassi nominal comprèis), «nòmpàgina» - nàm ëd la pàgina (sensa spassi nominal), «nòmsotpàgina» nòm relativ ëd la pàgina an ancaminand da la pàgina dont i smonoma le sot-pàgine, «gnun» - mach la part dël nòm apress l'ùltima bara.",
	'spl-subpages-par-kidsonly' => 'A përmëtt ëd mostré mach le sot-pàgine direte.',
	'spl-subpages-par-limit' => 'Ël nùmer màssim ëd pàgine da listé.',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'spl-desc' => 'Acrescenta um elemento <code><nowiki><splist /></nowiki></code> que permite listar subpáginas',
	'spl-nosubpages' => 'A página $1 não tem subpáginas para listar.',
	'spl-noparentpage' => 'A página "$1" não existe.',
	'spl-nopages' => 'O espaço nominal "$1" não tem páginas.',
	'spl-subpages-par-sort' => 'A direcção da ordenação. Valores permitidos: "asc" e "desc".',
	'spl-subpages-par-sortby' => 'O critério de ordenação. Valores permitidos: "title" (titulo) ou "lastedit" (última edição).',
	'spl-subpages-par-format' => 'A lista de subpáginas pode ser apresentada em vários formatos. Valores permitidos: "ol"— listas ordenadas (numeradas), "ul" — listas não ordenadas (com marcadores) e "list" — listas simples (por exemplo, lista separada por vírgulas).',
	'spl-subpages-par-page' => 'A página cujas subpáginas serão mostradas, ou o nome do espaço nominal (incluindo o sinal de dois pontos) do qual mostrar as páginas. Por omissão, será a página corrente.',
	'spl-subpages-par-showpage' => 'Indica se a própria página deve ser mostrada na lista ou não.',
	'spl-subpages-par-pathstyle' => 'O estilo do caminho para as subpáginas na lista. Valores permitidos: "fullpagename" — nome completo da página (incluindo o espaço nominal), "pagename" — nome da página (sem o espaço nominal), "subpagename" — nome relativo da página, começando a partir da página cujas subpáginas vão ser mostradas e "none" — somente a parte do nome após a última barra "/".',
	'spl-subpages-par-kidsonly' => 'Permite mostrar só subpáginas directas.',
	'spl-subpages-par-limit' => 'O número máximo de páginas listadas.',
	'spl-subpages-par-element' => 'O elemento HTML que encapsula a lista (incluindo os textos "intro" e "outro" ou "default"). Valores permitidos: "div", "p" e "span".',
	'spl-subpages-par-class' => 'O valor do atributo "class" do elemento HTML que encapsula a lista.',
	'spl-subpages-par-intro' => 'O texto a apresentar antes da lista, se a lista não estiver vazia.',
	'spl-subpages-par-outro' => 'O texto a apresentar após a lista, se a lista não estiver vazia.',
	'spl-subpages-par-default' => 'O texto a apresentar em vez da lista, se a lista não estiver vazia. Se vazio, será apresentada uma mensagem de erro (como "A página não tem nenhuma subpágina para listar"). Se o valor for ("-"), o resultado estará completamente vazio.',
	'spl-subpages-par-separator' => 'O texto a apresentar entre duas entradas da lista no caso dos formatos "list" ou "bar". Não tem efeito nos outros formatos.',
	'spl-subpages-par-template' => 'O nome da predefinição. A predefinição é aplicada a cada entrada da lista. Uma entrada é passada como o primeiro argumento (anónimo). Note que a predefinição não cancela a formatação da lista. A formatação ("ul", "ol", ou "list") é aplicada ao resultado da predefinição.',
	'spl-subpages-par-links' => 'Se verdadeiro, as entradas da lista são apresentadas na forma de links. Se falso, as entradas da lista são apresentadas como texto simples. Esta última opção é especialmente útil para passar entradas a uma predefinição, para processamento posterior.',
);

/** Russian (Русский)
 * @author Renessaince
 * @author Van de Bugger
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'spl-desc' => 'Добавляет тег <code><nowiki><splist /></nowiki></code>, выводящий список подстраниц',
	'spl-nosubpages' => 'Страница «$1» не имеет подстраниц.',
	'spl-noparentpage' => 'Страница «$1» не существует.',
	'spl-nopages' => 'Пространство имён  «$1» не содержит страниц.',
	'spl-subpages-par-sort' => 'Направление сортировки. Допустимые значения: «asc» — сортировка по возрастанию, «desc» — по убыванию.',
	'spl-subpages-par-sortby' => 'Ключ сортировки: «title» — сортировать по названию страниц, «lastedit» — по дате последней правки.',
	'spl-subpages-par-format' => 'Список подстраниц может быть показан в нескольких форматах. Допустимые значения: «ol» — нумерованный список, «ul» — маркированный список, «list» — линейный список (например, через запятые).',
	'spl-subpages-par-page' => 'Страница для которой показывать список подстраниц, или имя пространства имён (включая конечное двоеточие). По умолчанию текущая страница.',
	'spl-subpages-par-showpage' => 'Указывает, должна ли отображаться сама страница.',
	'spl-subpages-par-pathstyle' => 'Стиль пути для подстраниц в списке. Допустимые значения: «fullpagename» — полное название страницы (включая пространство имён), "pagename" — имя страницы (полное но без пространства имён), "subpagename" — "относительное" имя страницы, начиная со страницы, для которой показывается список, "none" — только часть имени следующая за последней косой чертой.',
	'spl-subpages-par-kidsonly' => 'Показывать только прямые подстраницы.',
	'spl-subpages-par-limit' => 'Максимальное количество страниц в список.',
	'spl-subpages-par-element' => 'Элемент HTML, включающий весь список (вместе с текстами «intro» и «outro» или «default»). Допустимые значения: «div», «p», «span».',
	'spl-subpages-par-class' => 'Значение атрибута «class» элемента HTML.',
	'spl-subpages-par-intro' => 'Текст для вывод перед списком, если список не пуст.',
	'spl-subpages-par-outro' => 'Текст для вывода после списка, если список не пуст.',
	'spl-subpages-par-default' => 'Текст для вывода вместо списка, если список пуст.',
	'spl-subpages-par-separator' => 'Текст для вывода между двумя элементами списка для форматов "list" или "bar". Не имеет значения для других форматов.',
	'spl-subpages-par-template' => 'Имя шаблона. Шаблон применяется к каждому элементу списка. Элемент передаётся в шаблон как первый (неименованный) аргумент. Заметьте, что шаблон не отменяет форматирование списка. Форматирование ("ul", "ol", "list") применяется к результатам шаблона.',
	'spl-subpages-par-links' => 'Если истина, элементы списка выводятся как ссылки. Если ложь, элементы списка выводятся как простой текст, это особенно удобно, если применяется совместно с шаблоном.',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'spl-subpages-par-limit' => 'Највећи број страница за приказивање.',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬) */
$messages['sr-el'] = array(
	'spl-subpages-par-limit' => 'Najveći broj stranica za prikazivanje.',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'spl-desc' => 'Nagdaragdag ng isang tatak na <code><nowiki><splist /></nowiki></code> na nagbibigay ng kakayahan sa iyo na magtala ng kabahaging mga pahina',
	'spl-nosubpages' => 'Walang maitatalang kabahaging mga pahina ang $1.',
	'spl-subpages-par-sort' => 'Ang patutunguhan kung saan gagawa ng paghihiwa-hiwalay.',
	'spl-subpages-par-sortby' => 'Kung ano ang pagbabatayan ng paghihiwa-hiwalay ng kabahaging mga pahina.',
	'spl-subpages-par-format' => 'Ang talaan ng kabahaging pahina ay maaaring ipakita sa pamamagitan ng ilang mga anyo. Mga talaang may bilang (ol), mga talaang may punglo at mga talaang pinaghihiwa-hiwalay ng kuwit (talaan).',
	'spl-subpages-par-page' => 'Ang pahinang pagpapakitaan ng kabahaging mga pahina. Likas na nakatakdang pumunta sa pangkasalukuyang pahina.',
	'spl-subpages-par-showpage' => 'Nagpapahiwatig kung ang pahina mismo ay dapat na ipakita sa loob ng talaan o hindi.',
	'spl-subpages-par-pathstyle' => 'Ang estilo ng landas para sa kabahaging mga pahina sa loob ng talaan.',
	'spl-subpages-par-kidsonly' => 'Nagpapahintulot na magpakita lamang ng tuwirang kabahaging mga pahina.',
	'spl-subpages-par-limit' => 'Ang pinakamataas na bilang ng mga pahinang itatala.',
);

/** Ukrainian (Українська)
 * @author Renessaince
 * @author Тест
 */
$messages['uk'] = array(
	'spl-desc' => 'Додає тег <code><nowiki><splist /></nowiki></code>, який виводить список підсторінок',
	'spl-nosubpages' => 'Сторінка "$1" не має підсторінок для складання списку.',
	'spl-subpages-par-sort' => 'Напрямок сортування. Допущальни значення: "asc" і "desc".',
	'spl-subpages-par-page' => 'Сторінка, для якої показати підсторінки. За умовчанням — поточна сторінка.',
	'spl-subpages-par-limit' => 'Максимальна кількість сторінок у списку.',
);

