<?php

$messages = array();

$messages['en'] = array(
	'places' => 'Places on this wiki',
	'places-nearby' => 'Places nearby',
	'places-desc' => 'Provides <nowiki><place> and <places></nowiki> parser hooks for geo tagging pages, [[Special:Places|map of all tagged pages]] and [[Special:Nearby|list of nearby places]]',
	'places-in-category' => 'Places in $1 category',
	'places-on-map' => '{{PLURAL:$1|$1 place|$1 places}} on this map',
	'places-modal-go-to-special' => 'Showing {{PLURAL:$1|$1 place|$1 places}} ([[Special:Places|see all]])',

	'places-toolbar-button-tooltip' => 'Click to add geo tag to this page',
	'places-toolbar-button-address' => 'Please provide address to use as a geo tag for this page',
	'places-editor-search' => 'Search',
	'places-editor-title-create-new' => 'Add a geotag',
	'places-editor-title-edit' => 'Edit a geotag',
	'places-editor-show-my-location' => 'Take me to my location',
	'places-editor-geoposition' => 'Current geolocation:',
	'places-geolocation-button-label' => 'Add location',

	'places-geolocation-modal-add-title' => 'Add location',
	'places-geolocation-modal-error-title' => 'Error',
	'places-geolocation-modal-error' => 'There was an error while trying to determine your position:<br />$1',
	'places-geolocation-modal-not-available' => 'Oops! This feature is currently available only on mobile devices.<br /><br />Want to give it a try? Just visit this page using your mobile device of choice.',

	'places-error-no-article' => 'You have to specify an page',
	'places-error-no-matches' => '<places> tag: no pages were found',
	'places-error-place-already-exists' => 'This page is already geo tagged',

	'places-updated-geolocation' => 'Geotagged this page',
	'places-category-switch' => 'Disable geotagging',
	'places-category-switch-off' => 'Enable geotagging'
);

/** Message documentation (Message documentation)
 * @author Shirayuki
 */
$messages['qqq'] = array(
	'places-in-category' => '$1 is a category name',
	'places-on-map' => 'Counter of places on a map ($1 is number of places)',
	'places-modal-go-to-special' => 'Shows below map in the modal and links to Special:Places. $1 is number of places shown on a map',
	'places-editor-search' => 'Label for submit button that handles a search string. {{Identical|Search}}',
	'places-editor-title-create-new' => 'Title of places editor modal when creating a new geotag',
	'places-editor-title-edit' => 'Title of places editor modal when editing an existing geotag',
	'places-geolocation-modal-error-title' => '{{Identical|Error}}',
	'places-error-no-matches' => 'Displayed when there are no matches for a given places query',
);

/** Old English (Ænglisc)
 * @author Espreon
 */
$messages['ang'] = array(
	'places-editor-search' => 'Sēcan',
);

/** Arabic (العربية)
 * @author Achraf94
 * @author Claw eg
 * @author ترجمان05
 */
$messages['ar'] = array(
	'places' => 'أماكن في هذا الويكي',
	'places-desc' => 'يوفر دعم مرشد  <nowiki><place> و <places></nowiki> ليحدد جغرافيا الصفحات، كما يضع [[Special:Places|خريطة بالأماكن المحددة]]',
	'places-in-category' => 'الأماكن في تصنيف $1',
	'places-on-map' => '{{PLURAL:$1|مكان واحد|$1 أماكن}} على هذه الخريطة',
	'places-modal-go-to-special' => 'عرض {{PLURAL:$1|مكان واحد|2=مكانين|$1 أماكن|$1 مكان}} ([[Special:Places|شاهد الكل]])',
	'places-toolbar-button-tooltip' => 'اضغط لإضافة علامات جغرافية لهذه الصفحة',
	'places-toolbar-button-address' => 'يرجى تقديم عنوان ليستخدم كإحدى العلامات جغرافية لهذه الصفحة',
	'places-editor-search' => 'بحث',
	'places-editor-title-create-new' => 'إضافة علامة جغرافية',
	'places-editor-title-edit' => 'تعديل علامة جغرافية',
	'places-editor-show-my-location' => 'خذني إلى مكاني',
	'places-editor-geoposition' => 'الموقع الجغرافي الحالي:',
	'places-geolocation-button-label' => 'إضافة مكان',
	'places-geolocation-modal-add-title' => 'إضافة مكان',
	'places-geolocation-modal-error-title' => 'خطأ',
	'places-geolocation-modal-error' => 'وقع خطأ أثناء محاولة تحديد موقعك:<br />$1',
	'places-geolocation-modal-not-available' => 'عفوًا! هذه الميزة متوفرة حاليًا للأجهزة المحمولة فقط.<br /><br />أتود تجربتها؟ قم بزيارة هذه الصفحة باستخدام جهازك المحمول المفضل.',
	'places-error-no-article' => 'يجب أن تحدد صفحة',
	'places-error-place-already-exists' => 'تم تحديد الموقع الجغرافي لهذه الصفحة بالفعل',
	'places-updated-geolocation' => 'إضافة علامة جغرافية لهذه الصفحة',
	'places-category-switch' => 'تعطيل تحديد الموقع الجغرافي',
	'places-category-switch-off' => 'تمكين تحديد الموقع الجغرافي',
);

/** Azerbaijani (azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'places-geolocation-modal-error-title' => 'Xəta',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Baloch Afghanistan
 */
$messages['bcc'] = array(
	'places-in-category' => 'جاگه بی $1 تهرِ تا',
);

/** Breton (brezhoneg)
 * @author Fohanno
 * @author Y-M D
 */
$messages['br'] = array(
	'places' => 'Lakaat war ar wiki-mañ',
	'places-in-category' => "Lec'hioù er rummad $1",
	'places-on-map' => '{{PLURAL:$1|$1 plas|$1 a blasoù}} war ar gartenn-mañ',
	'places-toolbar-button-tooltip' => "Klikit evit ouzhpennañ ur valizenn douaroniel d'ar bajenn-mañ",
	'places-toolbar-button-address' => "Pourchasit ar chomlec'h da implijout da valizenn douaroniel evit ar bajenn-mañ, mar plij",
	'places-editor-search' => 'Klask',
	'places-editor-title-create-new' => 'Ouzhpennañ ur valizenn douaroniel',
	'places-editor-title-edit' => 'Aozañ ur valizenn douaroniel',
	'places-editor-show-my-location' => "Ma c'has da'm lec'h",
	'places-editor-geoposition' => "Geolec'hiadur a-vremañ :",
	'places-geolocation-button-label' => "Ouzhpennañ ul lec'hiadur",
	'places-geolocation-modal-add-title' => "Ouzhpennañ ul lec'hiadur",
	'places-geolocation-modal-error-title' => 'Fazi',
	'places-geolocation-modal-error' => "Ur fazi zo bet pa oad o klask gouzout pelec'h emaoc'h : <br />$1",
	'places-error-no-article' => "Ret eo deoc'h diferiñ ur bajenn",
	'places-error-place-already-exists' => "Bez' ez eus ur valizenn douaroniel war ar bajenn-mañ dija",
	'places-category-switch' => 'Diweredekaat ar balizennañ douaroniel',
	'places-category-switch-off' => 'Gweredekaat ar balizennañ douaroniel',
);

/** Catalan (català)
 * @author Marcmpujol
 */
$messages['ca'] = array(
	'places' => 'Llocs en aquest wiki',
	'places-desc' => "Proporciona funcions de l'analitzador <nowiki><place> i <places></nowiki> per geoetiquetar pàgines i un [[Special:Places|mapa de tots els llocs etiquetats]]",
	'places-in-category' => 'Llocs en la categoria $1',
	'places-on-map' => '{{PLURAL:$1|$1 lloc|$1 llocs}} en aquest mapa',
	'places-modal-go-to-special' => 'Mostrant {{PLURAL:$1|$1 lloc|$1 llocs}} ([[Special:Places|veure tots]])',
	'places-toolbar-button-tooltip' => 'Fes clic per afegir una geoetiqueta a aquesta pàgina',
	'places-toolbar-button-address' => 'Si us plau, proporciona una adreça per utilitzar-la com una geoetiqueta en aquesta pàgina',
	'places-editor-search' => 'Cercar',
	'places-editor-title-create-new' => 'Afegir una geoetiqueta',
	'places-editor-title-edit' => 'Editar una geoetiqueta',
	'places-editor-show-my-location' => "Portar'm fins la meva ubicació",
	'places-editor-geoposition' => 'Ubicació actual:',
	'places-geolocation-button-label' => 'Afegir ubicació',
	'places-geolocation-modal-add-title' => 'Afegir ubicació',
	'places-geolocation-modal-error-title' => 'Error',
	'places-geolocation-modal-error' => "S'ha produït un error mentre s'intentava determinar la teva ubicació:<br />$1",
	'places-geolocation-modal-not-available' => 'Oops! Aquesta característica està actualment disponible només en dispositius mòbils.<br /><br />Vols provar-lo? Simplement visita aquesta pàgina utilitzant un dispositiu mòbil de la teva elecció.',
	'places-error-no-article' => "Has d'especificar una pàgina",
	'places-error-place-already-exists' => 'Aquesta pàgina ja ha estat geoetiquetada',
	'places-updated-geolocation' => 'Geoetiqueta aquesta pàgina',
	'places-category-switch' => 'Desactivar les geoetiquetes',
	'places-category-switch-off' => 'Activar les geoetiquetes',
);

/** Chechen (нохчийн)
 * @author Умар
 */
$messages['ce'] = array(
	'places-editor-search' => 'Лахар',
	'places-editor-geoposition' => 'ХӀинца йолу меттиг',
);

/** Czech (čeština)
 * @author Chmee2
 */
$messages['cs'] = array(
	'places-editor-search' => 'Hledat',
	'places-editor-title-create-new' => 'Přidat geotag',
	'places-editor-title-edit' => 'Upravit geotag',
	'places-editor-show-my-location' => 'Vezmi mě na mé místo',
	'places-geolocation-button-label' => 'Přidat umístění',
	'places-geolocation-modal-add-title' => 'Přidat umístění',
	'places-geolocation-modal-error-title' => 'Chyba',
);

/** German (Deutsch)
 * @author Alphakilo
 * @author George Animal
 * @author PtM
 */
$messages['de'] = array(
	'places' => 'Orte in diesem Wiki',
	'places-desc' => 'Bietet <nowiki><place>und <places></nowiki> Parser-Hooks zum Geo-Taggen von Seiten sowie eine [[Special:Places|Karte aller getaggten Seiten]]',
	'places-in-category' => 'Orte der Kategorie $1',
	'places-on-map' => '$1 {{PLURAL:$1|Ort|Orte}} auf dieser Karte',
	'places-modal-go-to-special' => '$1 {{PLURAL:$1|Ort|Orte}} angezeigt ([[Special:Places|Zeige alle]])',
	'places-toolbar-button-tooltip' => 'Klicken, um dieser Seite Geo-Tag hinzuzufügen',
	'places-toolbar-button-address' => 'Bitte gib für diese Seite die als Geo-Tag zu verwendende Adresse an',
	'places-editor-search' => 'Suche',
	'places-editor-title-create-new' => 'Geo-Tag hinzufügen',
	'places-editor-title-edit' => 'Geo-Tag bearbeiten',
	'places-editor-show-my-location' => 'Zu meinem Standort',
	'places-editor-geoposition' => 'Momentaner Geo-Standort:',
	'places-geolocation-button-label' => 'Standort hinzufügen',
	'places-geolocation-modal-add-title' => 'Standort hinzufügen',
	'places-geolocation-modal-error-title' => 'Fehler',
	'places-geolocation-modal-error' => 'Beim Versuch, deinen Standort zu bestimmen, ist ein Fehler aufgetreten:<br />$1',
	'places-geolocation-modal-not-available' => 'Hoppla! Dieses Feature ist derzeit nur auf mobilen Geräten verfügbar.<br /><br />Lust es auszuprobieren? Einfach diese Seite mit dem Mobilgerät deiner Wahl aufsuchen.',
	'places-error-no-article' => 'Eine Seite muss angegeben werden',
	'places-error-place-already-exists' => 'Diese Seite hat bereits einen Geo-Tag',
	'places-updated-geolocation' => 'Diese Seite Geotaggen',
	'places-category-switch' => 'Geotagging deaktivieren',
	'places-category-switch-off' => 'Geotagging aktivieren',
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 * @author Mirzali
 */
$messages['diq'] = array(
	'places-editor-search' => 'Cı geyre',
	'places-geolocation-modal-error-title' => 'Xeta',
);

/** Spanish (español)
 * @author Bea.miau
 * @author Benfutbol10
 * @author VegaDark
 */
$messages['es'] = array(
	'places' => 'Lugares en este wiki',
	'places-desc' => 'Proporciona funciones del analizador <nowiki><place> y <places></nowiki> para geoetiquetar páginas y un [[Special:Places|mapa de todos los lugares etiquetados]]',
	'places-in-category' => 'Lugares en la categoría $1',
	'places-on-map' => '{{PLURAL:$1|$1 lugar|$1 lugares}} en este mapa',
	'places-modal-go-to-special' => 'Mostrando  {{PLURAL:$1|$1 lugar|$1 lugares}} ([[Special:Places|ver todos]])',
	'places-toolbar-button-tooltip' => 'Haz clic para agregar una geoetiqueta a esta página',
	'places-toolbar-button-address' => 'Porfavor proporciona una dirección para utilizarla como una geoetiqueta en esta página',
	'places-editor-search' => 'Buscar',
	'places-editor-title-create-new' => 'Agregar una geoetiqueta',
	'places-editor-title-edit' => 'Editar un geoetiqueta',
	'places-editor-show-my-location' => 'Llévame a mi ubicación',
	'places-editor-geoposition' => 'Ubicación actual:',
	'places-geolocation-button-label' => 'Añadir localización',
	'places-geolocation-modal-add-title' => 'Añadir localización',
	'places-geolocation-modal-error-title' => 'Error',
	'places-geolocation-modal-error' => 'Se produjo un error mientras se intentaba determinar tu posición:<br />$1',
	'places-geolocation-modal-not-available' => 'Oops! Esta característica está actualmente disponible sólo en dispositivos móviles.<br /><br />¿Quieres probarlo? Simplemente visita esta página utilizando un dispositivo móvil de tu elección.',
	'places-error-no-article' => 'Tienes que especificar una página',
	'places-error-place-already-exists' => 'Esta página ya ha sido geoetiquetada',
	'places-updated-geolocation' => 'Geoetiqueta esta página',
	'places-category-switch' => 'Desactivar las geoetiquetas',
	'places-category-switch-off' => 'Activar las geoetiquetas',
);

/** Persian (فارسی)
 * @author Reza1615
 */
$messages['fa'] = array(
	'places-editor-search' => 'جستجو',
	'places-geolocation-modal-error-title' => 'خطا',
);

/** Finnish (suomi)
 * @author Centerlink
 * @author Elseweyr
 * @author Nike
 */
$messages['fi'] = array(
	'places' => 'Paikkoja tässä wikissä',
	'places-in-category' => 'Paikat luokassa $1',
	'places-on-map' => '{{PLURAL:$1|$1 paikka|$1 paikkaa}} tällä kartalla',
	'places-editor-search' => 'Etsi',
	'places-editor-title-create-new' => 'Lisää paikkatunniste',
	'places-editor-title-edit' => 'Muokkaa paikkatunnistetta',
	'places-editor-show-my-location' => 'Tämänhetkinen sijainti',
	'places-editor-geoposition' => 'Nykyinen paikkasijainti:',
	'places-geolocation-button-label' => 'Lisää sijainti',
	'places-geolocation-modal-add-title' => 'Lisää sijainti',
	'places-geolocation-modal-error-title' => 'Virhe',
	'places-error-no-article' => 'Sinun on määritettävä sivu',
	'places-error-place-already-exists' => 'Tämä sivu on jo paikkamerkitty',
	'places-updated-geolocation' => 'Geo-merkitse tämä sivu',
);

/** French (français)
 * @author Gomoko
 * @author Wyz
 */
$messages['fr'] = array(
	'places' => 'Lieux sur ce wiki',
	'places-desc' => "Fournit le support des balises <nowiki><place> et <places></nowiki> pour marquer géographiquement les pages, ainsi qu'une [[Special:Places|carte de toutes les pages marquées]]",
	'places-in-category' => 'Endroits dans la catégorie $1',
	'places-on-map' => '{{PLURAL:$1|$1 lieu|$1 lieux}} sur cette carte',
	'places-modal-go-to-special' => 'Afficher {{PLURAL:$1|$1 emplacement|$1 emplacements}} ([[Special:Places|voir tout]])',
	'places-toolbar-button-tooltip' => 'Cliquez pour ajouter une balise géographique à cette page',
	'places-toolbar-button-address' => "Veuillez indiquer l'adresse à utiliser comme balise géographique pour cette page.",
	'places-editor-search' => 'Rechercher',
	'places-editor-title-create-new' => 'Ajouter une balise géographique',
	'places-editor-title-edit' => 'Modifier une balise géographique',
	'places-editor-show-my-location' => "M'emmener à mon emplacement",
	'places-editor-geoposition' => 'Géolocalisation actuelle:',
	'places-geolocation-button-label' => 'Ajouter un emplacement',
	'places-geolocation-modal-add-title' => 'Ajoutez un emplacement',
	'places-geolocation-modal-error-title' => 'Erreur',
	'places-geolocation-modal-error' => 'Il y a eu une erreur en essayant de déterminer votre position:<br />$1',
	'places-geolocation-modal-not-available' => "Oups! Cette fonctionnalité est actuellement disponible uniquement sur des périphériques mobiles.<br /><br />Voulez-vous faire un essai ? Visitez cette page à l'aide de l'appareil mobile de votre choix.",
	'places-error-no-article' => 'Vous devez spécifier un article',
	'places-error-place-already-exists' => "L'article est déjà marqué géographiquement",
	'places-updated-geolocation' => 'Marquer géographiquement cet article',
	'places-category-switch' => 'Désactiver le balisage géographique',
	'places-category-switch-off' => 'Activer le balisage géographique',
);

/** Western Frisian (Frysk)
 * @author Robin0van0der0vliet
 */
$messages['fy'] = array(
	'places-editor-search' => 'Sykje',
	'places-geolocation-modal-error-title' => 'Flater',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'places' => 'Lugares neste wiki',
	'places-desc' => 'Proporciona os asociadores analíticos <nowiki><place> e <places></nowiki> para etiquetar xeograficamente as páxinas e un [[Special:Places|mapa de todas as páxinas etiquetadas]]',
	'places-in-category' => 'Lugares na categoría $1',
	'places-on-map' => '{{PLURAL:$1|$1 lugar|$1 lugares}} neste mapa',
	'places-modal-go-to-special' => 'Mostrando {{PLURAL:$1|$1 lugar|$1 lugares}} ([[Special:Places|ollar todos]])',
	'places-toolbar-button-tooltip' => 'Prema para engadir unha etiqueta xeográfica a esta páxina',
	'places-toolbar-button-address' => 'Dea o enderezo que se vai empregar para etiquetar xeograficamente esta páxina',
	'places-editor-search' => 'Procurar',
	'places-editor-title-create-new' => 'Engadir unha etiqueta xeográfica',
	'places-editor-title-edit' => 'Editar unha etiqueta xeográfica',
	'places-editor-show-my-location' => 'Ir á miña localización',
	'places-editor-geoposition' => 'Localización xeográfica actual:',
	'places-geolocation-button-label' => 'Engadir unha localización',
	'places-geolocation-modal-add-title' => 'Engadir unha localización',
	'places-geolocation-modal-error-title' => 'Erro',
	'places-geolocation-modal-error' => 'Houbo un erro ao intentar determinar a súa posición:<br />$1',
	'places-geolocation-modal-not-available' => 'Vaites! Esta característica unicamente está dispoñible nos dispositivos móbiles.<br /><br />Quere probala? Visite esta páxina desde calquera dispositivo móbil.',
	'places-error-no-article' => 'Debe especificar unha páxina',
	'places-error-place-already-exists' => 'Esta páxina xa esta etiquetada xeograficamente',
	'places-updated-geolocation' => 'Etiquetou xeograficamente esta páxina',
	'places-category-switch' => 'Desactivar as etiquetas xeográficas',
	'places-category-switch-off' => 'Activar as etiquetas xeográficas',
);

/** Hungarian (magyar)
 * @author TK-999
 */
$messages['hu'] = array(
	'places' => 'Helyek ezen a wikin',
	'places-desc' => '<nowiki><place> and <places></nowiki> címkéket biztosít az oldalak geotaggeléséhez, valamint [[Special:Places|az összes így megjelölt oldal listáját]]',
	'places-in-category' => 'Helyek a(z) $1 kategóriában',
	'places-on-map' => '{{PLURAL:$1|Egy|$1}} hely van ezen a térképen',
	'places-modal-go-to-special' => 'Megjelenítve {{PLURAL:$1|egy|$1}} hely ([[Special:Places|összes megtekintése]])',
	'places-editor-search' => 'Keresés',
	'places-editor-show-my-location' => 'Vigyen a saját helyzetemre',
	'places-geolocation-modal-error-title' => 'Hiba',
	'places-geolocation-modal-error' => 'Hiba történt a pozíciód megállapítása közben:<br />$1',
	'places-geolocation-modal-not-available' => 'Hoppá! Ez a szolgáltatás jelenleg csak mobil eszközökön érhető el.<br /><br />Szeretnéd kipróbálni? Egszerűen látogass el erre a lapra egy általad választott mobil eszközzel.',
	'places-error-no-article' => 'Meg kell adnod egy lapot',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'places' => 'Locos in iste wiki',
	'places-desc' => 'Forni al analysator syntactic le uncinos <nowiki><place> e <places></nowiki> pro geo-etiquettage de paginas e un [[Special:Places|mappa de tote le paginas etiquettate]]',
	'places-in-category' => 'Locos in categoria $1',
	'places-on-map' => '{{PLURAL:$1|$1 loco|$1 locos}} sur iste carta',
	'places-modal-go-to-special' => 'Monstra {{PLURAL:$1|$1 loco|$1 locos}} ([[Special:Places|vide totes]])',
	'places-toolbar-button-tooltip' => 'Clicca pro adder un geo-etiquetta a iste pagina',
	'places-toolbar-button-address' => 'Per favor specifica le adresse a usar como geo-etiquetta pro iste pagina',
	'places-editor-search' => 'Cercar',
	'places-editor-title-create-new' => 'Adder un geo-etiquetta',
	'places-editor-title-edit' => 'Modificar un geo-etiquetta',
	'places-editor-show-my-location' => 'Porta me a mi position',
	'places-editor-geoposition' => 'Geolocalisation actual:',
	'places-geolocation-button-label' => 'Adder loco',
	'places-geolocation-modal-add-title' => 'Adder loco',
	'places-geolocation-modal-error-title' => 'Error',
	'places-geolocation-modal-error' => 'Un error occurreva durante le determination de tu position:<br />$1',
	'places-geolocation-modal-not-available' => 'Iste function es actualmente disponibile solmente in apparatos mobile.<br /><br />Vole tentar lo? Simplemente visita iste pagina usante la apparato mobile de tu preferentia.',
	'places-error-no-article' => 'Es necessari specificar un pagina',
	'places-error-place-already-exists' => 'Iste pagina es jam geo-etiquettate',
	'places-updated-geolocation' => 'Geo-etiquettava iste pagina',
	'places-category-switch' => 'Disactivar geo-etiquettage',
	'places-category-switch-off' => 'Activar geo-etiquettage',
);

/** Italian (italiano)
 * @author Lexaeus 94
 */
$messages['it'] = array(
	'places-editor-search' => 'Cerca',
	'places-editor-geoposition' => 'Ubicazione attuale:',
	'places-geolocation-button-label' => 'Aggiungi posizione',
	'places-geolocation-modal-add-title' => 'Aggiungi posizione',
	'places-geolocation-modal-error-title' => 'Errore',
);

/** Japanese (日本語)
 * @author Barrel0116
 * @author Plover-Y
 */
$messages['ja'] = array(
	'places-editor-search' => '検索',
	'places-geolocation-modal-error-title' => 'エラー',
);

/** Kannada (ಕನ್ನಡ)
 * @author VASANTH S.N.
 */
$messages['kn'] = array(
	'places-editor-search' => 'ಹುಡುಕು',
	'places-geolocation-modal-error-title' => 'ದೋಷ',
);

/** Korean (한국어)
 * @author Miri-Nae
 */
$messages['ko'] = array(
	'places-editor-search' => '검색',
	'places-geolocation-button-label' => '장소 추가',
	'places-geolocation-modal-add-title' => '장소 추가',
	'places-geolocation-modal-error-title' => '오류',
	'places-geolocation-modal-not-available' => '이런! 이 기능은 아직 모바일 환경에서만 이용할 수 있습니다.<br /><br />이 기능을 이용하고 싶으시면 모바일을 통해 접속해 주세요.',
);

/** Kurdish (Latin script) (Kurdî (latînî)‎)
 * @author Bikarhêner
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'places-editor-search' => 'Lê bigere',
	'places-geolocation-modal-error-title' => 'Çewtî',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'places' => 'Plazen an dëser Wiki',
	'places-in-category' => 'Plazen an der Kategorie $1',
	'places-editor-search' => 'Sichen',
	'places-geolocation-button-label' => 'Plaz derbäisetzen',
	'places-geolocation-modal-add-title' => 'Plaz derbäisetzen',
	'places-geolocation-modal-error-title' => 'Feeler',
	'places-error-no-article' => 'Dir musst eng Säit uginn',
);

/** Northern Luri (لوری مینجایی)
 * @author Mogoeilor
 */
$messages['lrc'] = array(
	'places-editor-search' => 'پی جوری',
	'places-geolocation-modal-error-title' => 'خطا',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'places' => 'Места на ова вики',
	'places-desc' => 'Дава расчленувачки куки <nowiki><place> и <places></nowiki> за страници за геоозначување и [[Special:Places|карта на сите означени страници]]',
	'places-in-category' => 'Места во $1 категорија',
	'places-on-map' => '{{PLURAL:$1|$1 место|$1 места}} на картава',
	'places-modal-go-to-special' => 'Приказ на {{PLURAL:$1|$1 место|$1 места}} ([[Special:Places|погл. сите]])',
	'places-toolbar-button-tooltip' => 'Стиснете за да ѝ ставите геоознака на страницава',
	'places-toolbar-button-address' => 'Наведете адреса како геоознака на страницава',
	'places-editor-search' => 'Пребарај',
	'places-editor-title-create-new' => 'Додај геоознака',
	'places-editor-title-edit' => 'Уреди геоознака',
	'places-editor-show-my-location' => 'Одведи ме на мојата местоположба',
	'places-editor-geoposition' => 'Тековна геоположба:',
	'places-geolocation-button-label' => 'Додај местоположба',
	'places-geolocation-modal-add-title' => 'Додај местоположба',
	'places-geolocation-modal-error-title' => 'Грешка',
	'places-geolocation-modal-error' => '!Се појави грешка при обидот да утврдам вашата положба:<br />$1',
	'places-geolocation-modal-not-available' => 'Упс! Оваа функција е моментално достапна само на мобилни уреди.<br /><br />Сакате да ја испробате? Посетете ја страницата преку вашиот мобилен уред.',
	'places-error-no-article' => 'Мора да наведете статија',
	'places-error-place-already-exists' => 'Статијата е веќе геоозначена',
	'places-updated-geolocation' => 'Статијата е геоозначена',
	'places-category-switch' => 'Оневозможи геоозначување',
	'places-category-switch-off' => 'Овозможи геоозначување',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'places' => 'Tempat di wiki ini',
	'places-desc' => 'Menyediakan penyangkuk penghurai <nowiki><place> dan <places></nowiki> untuk membubuh geotag pada laman serta [[Special:Places|peta laman-laman yang dibubuhi tag]]',
	'places-in-category' => 'Tempat di kategori $1',
	'places-on-map' => '$1 tempat pada peta ini',
	'places-modal-go-to-special' => 'Memaparkan $1 tempat ([[Special:Places|lihat semua]])',
	'places-toolbar-button-tooltip' => 'Klik untuk bubuh geotag pada laman ini',
	'places-toolbar-button-address' => 'Sila sediakan alamat untuk digunakan sebagai geotag bagi laman ini',
	'places-editor-search' => 'Cari',
	'places-editor-title-create-new' => 'Bubuh geotag',
	'places-editor-title-edit' => 'Sunting geotag',
	'places-editor-show-my-location' => 'Bawa saya ke lokasi saya',
	'places-editor-geoposition' => 'Geolokasi semasa:',
	'places-geolocation-button-label' => 'Tambahkan lokasi',
	'places-geolocation-modal-add-title' => 'Tambahkan lokasi',
	'places-geolocation-modal-error-title' => 'Ralat',
	'places-geolocation-modal-error' => 'Terdapat ralat ketika cuba menentukan kedudukan anda:<br />$1',
	'places-geolocation-modal-not-available' => 'Eh eh! Ciri ini kini terdapat pada peranti mudah alih sahaja.<br /><br />Nak cuba? Sila lawati laman ini dengan menggunakan peranti mudah alih anda.',
	'places-error-no-article' => 'Anda perlu menyatakan satu rencana',
	'places-error-place-already-exists' => 'Rencana sudah dibubuhi geotag',
	'places-updated-geolocation' => 'Rencana ini dibubuhi geotag',
	'places-category-switch' => 'Matikan ciri geotag',
	'places-category-switch-off' => 'Hidupkan ciri geotag',
);

/** Norwegian Bokmål (norsk bokmål)
 * @author Audun
 */
$messages['nb'] = array(
	'places' => 'Steder på denne wikien',
	'places-desc' => 'Legger til <nowiki><place>- og <places></nowiki>-tagger for geo-tagging av sider og et [[Special:Places|kart over alle taggede sider]]',
	'places-in-category' => 'Steder i $1 kategori',
	'places-on-map' => '{{PLURAL:$1|$1 sted|$1 steder}} på dette kartet',
	'places-modal-go-to-special' => 'Viser {{PLURAL:$1|$1 sted|$1 steder}} ([[Special:Places|vis alle]])',
	'places-toolbar-button-tooltip' => 'Klikk for å legge geo-tag til denne siden',
	'places-toolbar-button-address' => 'Vennligst oppgi adressen som skal brukes som ge-tag for denne siden',
	'places-editor-search' => 'Søk',
	'places-editor-title-create-new' => 'Legg til en geotag',
	'places-editor-title-edit' => 'Rediger en geotag',
	'places-editor-show-my-location' => 'Ta meg til min plassering',
	'places-editor-geoposition' => 'Nåværende geoplassering:',
	'places-geolocation-button-label' => 'Legg til sted',
	'places-geolocation-modal-add-title' => 'Legg til sted',
	'places-geolocation-modal-error-title' => 'Feil',
	'places-geolocation-modal-error' => 'Det oppstod en feil under forsøket på å fastslå posisjonen din:<br />$1',
	'places-geolocation-modal-not-available' => 'Ops! Denne funksjonen er for øyeblikket kun tilgjengelig på mobile enheter.<br /><br />Vil du prøve den ut? Bare gå til denne siden med din foretrukne mobilenhet.',
	'places-error-no-article' => 'Du må spesifisere en side',
	'places-error-place-already-exists' => 'Denne siden er allerede geotagget',
	'places-updated-geolocation' => 'Geotagget denne siden',
	'places-category-switch' => 'Deaktiver geotagging',
	'places-category-switch-off' => 'Aktiver geotagging',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'places' => 'Plaatsen op deze wiki',
	'places-desc' => "Voegt de parserhooks <nowiki><place> en <places></nowiki> toe voor het geotaggen van pagina's en een [[Special:Places|kaart met alle opgegeven plaatsen]]",
	'places-in-category' => 'Plaatsen in de categorie $1',
	'places-on-map' => '{{PLURAL:$1|Eén plaats|$1 plaatsen}} op deze kaart',
	'places-modal-go-to-special' => '{{PLURAL:$1|Eén plaats|$1 plaatsen}} weergegeven ([[Special:Places|allemaal weergeven]])',
	'places-toolbar-button-tooltip' => 'Klik om een geotag aan deze pagina toe te voegen',
	'places-toolbar-button-address' => 'Geef een adres op om als geotag aan deze pagina toe te voegen',
	'places-editor-search' => 'Zoeken',
	'places-editor-title-create-new' => 'Geocodering toevoegen',
	'places-editor-title-edit' => 'Geocodering bewerken',
	'places-editor-show-my-location' => 'Naar mijn locatie gaan',
	'places-editor-geoposition' => 'Huidige geolocatie:',
	'places-geolocation-button-label' => 'Locatie toevoegen',
	'places-geolocation-modal-add-title' => 'Locatie toevoegen',
	'places-geolocation-modal-error-title' => 'Fout',
	'places-geolocation-modal-error' => 'Er is een fout opgetreden tijdens het bepalen van uw positie:<br />$1',
	'places-geolocation-modal-not-available' => 'Deze functie is op het moment alleen beschikbaar op mobiele apparaten.<br /><br />Wilt u het eens proberen? Ga dan naar deze pagina op uw mobiele apparaat.',
	'places-error-no-article' => 'U moet een pagina opgeven',
	'places-error-place-already-exists' => 'Deze pagina heeft al een geocodering',
	'places-updated-geolocation' => 'Deze pagina heeft een geocodering gekregen',
	'places-category-switch' => 'Geocodering uitschakelen',
	'places-category-switch-off' => 'Geocodering inschakelen',
);

/** Occitan (occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'places-editor-search' => 'Recercar',
	'places-editor-title-create-new' => 'Apondre una balisa geografica',
	'places-editor-title-edit' => 'Modificar una balisa geografica',
	'places-geolocation-button-label' => 'Apondre un emplaçament',
	'places-geolocation-modal-add-title' => 'Apondètz un emplaçament',
	'places-geolocation-modal-error-title' => 'Error',
);

/** Palatine German (Pälzisch)
 * @author Manuae
 */
$messages['pfl'] = array(
	'places-geolocation-modal-error-title' => 'Fehla',
);

/** Polish (polski)
 * @author BeginaFelicysym
 * @author Sovq
 */
$messages['pl'] = array(
	'places' => 'Miejsca na tej wiki',
	'places-nearby' => 'Miejsca w pobliżu Twojego aktualnego położenia',
	'places-desc' => 'Dodaje tagi <nowiki><place> i <places></nowiki> pozwalające na geotagowanie artykułów, [[Special:Places|mapę wszystkich oznaczonych artykułów]] oraz [[Special:Nearby|listę pobliskich miejsc]]',
	'places-in-category' => 'Miejsca w kategorii "$1"',
	'places-on-map' => '{{PLURAL:$1|$1 miejsce|$1 miejsc}} na mapie',
	'places-modal-go-to-special' => '{{PLURAL:$1|$1 miejsce|$1 miejsc}} na mapie ([[Special:Places|zobacz wszystkie]])',
	'places-toolbar-button-tooltip' => 'Dodaj lokalizację do tego artykułu',
	'places-toolbar-button-address' => 'Podaj adres określający lokalizację tego artykułu',
	'places-editor-search' => 'Szukaj',
	'places-editor-title-create-new' => 'Dodaj tag geograficzny',
	'places-editor-title-edit' => 'Edytuj tag geograficzny',
	'places-editor-show-my-location' => 'Wskaż moje umiejscowienie',
	'places-editor-geoposition' => 'Aktualna geolokalizacja:',
	'places-geolocation-button-label' => 'Dodaj umiejscowienie',
	'places-geolocation-modal-add-title' => 'Dodaj umiejscowienie',
	'places-geolocation-modal-error-title' => 'Błąd',
	'places-geolocation-modal-error' => 'Wystąpił błąd podczas próby określenia twojej pozycji:<br />$1',
	'places-geolocation-modal-not-available' => 'Ta funkcja jest obecnie dostępna tylko na urządzeniach przenośnych.<br /><br />Chcesz ją wypróbować? Odwiedź tę stronę za pomocą wybranego urządzenia przenośnego.',
	'places-error-no-article' => 'Musisz określić stronę',
	'places-error-no-matches' => 'Tag <places>: nie znaleziono stron pasujących do zapytania',
	'places-error-place-already-exists' => 'Ta strona jest już geo oznaczona',
	'places-updated-geolocation' => 'Geooznaczono tę stronę',
	'places-category-switch' => 'Wyłącz geotagowanie',
	'places-category-switch-off' => 'Włącz geotagowanie',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'places' => 'Pòst dzor sta wiki',
	'places-desc' => 'A forniss dle tichëtte <nowiki><place> e <places></nowiki> për marché da na mira geogràfica le pàgine e na [[Special:Places|carta ëd tute le pàgine marcà]]',
	'places-in-category' => 'A piassa an $1 categorìe',
	'places-on-map' => '{{PLURAL:$1|$1 pòst}} dzor sta carta',
	'places-modal-go-to-special' => 'Smon-e {{PLURAL:$1|$1 pòst}} ([[Special:Places|vëdde tut]])',
	'places-toolbar-button-tooltip' => "Ch'a sgnaca për gionté na tichëtta geogràfica a sta pàgina",
	'places-toolbar-button-address' => "Për piasì, ch'a buta l'adrëssa da dovré com tichëtta geogràfica për costa pàgina",
	'places-editor-search' => 'Sërca',
	'places-editor-title-create-new' => 'Gionta na tichëtta geogràfica',
	'places-editor-title-edit' => 'Modifiché na tichëtta geogràfica',
	'places-editor-show-my-location' => 'Pòrtme a mia locassion',
	'places-editor-geoposition' => 'Geolocassion corenta:',
	'places-geolocation-button-label' => 'Gionté na locassion',
	'places-geolocation-modal-add-title' => 'Gionté na locassion',
	'places-geolocation-modal-error-title' => 'Eror',
	'places-geolocation-modal-error' => "A-i é staje n'eror an provand a determiné soa posission:<br />$1",
	'places-geolocation-modal-not-available' => "Contacc! Sta funsion a l'é al moment disponìbil mach su dij dispositiv sacociàbij.<br /><br />Veul-lo fé na preuva? Ch'a vìsita mach sta pàgina dovrand ël dispositiv sacociàbil ch'a veul.",
	'places-error-no-article' => 'A dev specifiché na pàgina',
	'places-error-place-already-exists' => "Costa pàgina a l'é già marcà da na mira geogràfica",
	'places-updated-geolocation' => 'Marché sta pàgina da na mira geogràfica',
	'places-category-switch' => 'Disabilité la marcadura geogràfica',
	'places-category-switch-off' => 'Abilité la marcadura geogràfica',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'places' => 'ځايونه په دې ويکي',
	'places-editor-search' => 'پلټل',
	'places-geolocation-button-label' => 'ځای ورگډول',
	'places-geolocation-modal-add-title' => 'ځای ورگډول',
	'places-geolocation-modal-error-title' => 'تېروتنه',
);

/** Portuguese (português)
 * @author Luckas
 * @author Malafaya
 */
$messages['pt'] = array(
	'places-editor-search' => 'Pesquisar',
	'places-geolocation-button-label' => 'Adicionar localização',
	'places-geolocation-modal-add-title' => 'Adicionar localização',
	'places-geolocation-modal-error-title' => 'Erro',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Luckas
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'places-editor-search' => 'Pesquisar',
	'places-geolocation-button-label' => 'Adicionar localização',
	'places-geolocation-modal-add-title' => 'Adicionar localização',
	'places-geolocation-modal-error-title' => 'Erro',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'places' => 'Luèche sus a sta uicchi',
	'places-in-category' => "Luèche jndr'à categorije $1",
	'places-editor-search' => 'Cirche',
	'places-editor-title-create-new' => "Aggiunge 'nu geotag",
	'places-editor-title-edit' => "Cange 'nu geotag",
	'places-geolocation-button-label' => "Aggiunge 'na località",
	'places-geolocation-modal-add-title' => "Aggiunge 'na località",
	'places-geolocation-modal-error-title' => 'Errore',
);

/** Russian (русский)
 * @author Kuzura
 */
$messages['ru'] = array(
	'places' => 'Места на этой вики',
	'places-desc' => 'Обеспечивает <nowiki><place> и <places></nowiki> анализирует закладки для гео-тегах на страницах и на [[Special:Places|карте всех страниц с тегами]]',
	'places-in-category' => 'Места в  категории $1',
	'places-on-map' => '{{PLURAL:$1|$1 место|$1 места|$1 мест}} на этой карте',
	'places-modal-go-to-special' => '([[Special:Places|Увидеть все]]) показанные {{PLURAL:$1|$1 место|$1 места|$1 мест}}',
	'places-toolbar-button-tooltip' => 'Нажмите, чтобы добавить гео-тег на эту страницу',
	'places-toolbar-button-address' => 'Укажите адрес для использования в качестве гео-тега для этой страницы',
	'places-editor-search' => 'Найти',
	'places-editor-title-create-new' => 'Добавить геотег',
	'places-editor-title-edit' => 'Править геотег',
	'places-editor-show-my-location' => 'Привязать меня к моему местоположению',
	'places-editor-geoposition' => 'Текущее местонахождение:',
	'places-geolocation-button-label' => 'Добавить место',
	'places-geolocation-modal-add-title' => 'Добавить место',
	'places-geolocation-modal-error-title' => 'Ошибка',
	'places-geolocation-modal-error' => 'Произошла ошибка при попытке определить вашу позицию:<br />$1',
	'places-geolocation-modal-not-available' => 'В настоящее время эта функция доступна только на мобильных устройствах.<br /><br />Хотите попробовать? Просто посетите данную страницу, используя мобильное устройство.',
	'places-error-no-article' => 'Вы должны указать страницу',
	'places-error-place-already-exists' => 'Эта страница уже является геотегом',
	'places-updated-geolocation' => 'Добавить геотег на эту страницу',
	'places-category-switch' => 'Отключить геотеги',
	'places-category-switch-off' => 'Включить геотеги',
);

/** Serbian (Cyrillic script) (српски (ћирилица)‎)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'places-geolocation-modal-error-title' => 'Грешка',
);

/** Swedish (svenska)
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'places' => 'Platser på denna wiki',
	'places-desc' => 'Lägger till taggarna <nowiki><place> och <places></nowiki> för geotaggning av sidor och en [[Special:Places|karta över alla taggade sidor]]',
	'places-in-category' => 'Platser i $1 kategori',
	'places-on-map' => '{{PLURAL:$1|$1 ställe|$1 ställen}} på denna karta',
	'places-modal-go-to-special' => 'Visar {{PLURAL:$1|$1 plats|$1 platser}} ([[Special:Places|se alla]])',
	'places-toolbar-button-tooltip' => 'Klicka för att lägga till geotagg på denna sida',
	'places-toolbar-button-address' => 'Var god ange adressen som ska använda som en geotaggning för denna sida',
	'places-editor-search' => 'Sök',
	'places-editor-title-create-new' => 'Lägg till en geotagg',
	'places-editor-title-edit' => 'Redigera en geotagg',
	'places-editor-show-my-location' => 'Ta mig till min plats',
	'places-editor-geoposition' => 'Aktuell geoplacering:',
	'places-geolocation-button-label' => 'Lägg till plats',
	'places-geolocation-modal-add-title' => 'Lägg till plats',
	'places-geolocation-modal-error-title' => 'Fel',
	'places-geolocation-modal-error' => 'Ett fel uppstod när din position skulle bestämmas:<br />$1',
	'places-geolocation-modal-not-available' => 'Hoppsan! Denna funktion är endast tillgänglig på mobila enheter.<br /><br />Vill du prova? Det är bara att besöka sidan med din föredragna mobilenhet.',
	'places-error-no-article' => 'Du måste ange en sida',
	'places-error-place-already-exists' => 'Denna sida är redan geotaggad',
	'places-updated-geolocation' => 'Geotagga denna sida',
	'places-category-switch' => 'Inaktivera geotaggning',
	'places-category-switch-off' => 'Aktivera geotaggning',
);

/** Tamil (தமிழ்)
 * @author Karthi.dr
 */
$messages['ta'] = array(
	'places-editor-search' => 'தேடுக',
	'places-geolocation-modal-error-title' => 'பிழை',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Ravichandra
 */
$messages['te'] = array(
	'places-editor-search' => 'వెతుకు',
	'places-editor-show-my-location' => 'నన్ను నా స్థలానికి తీసుకువెళ్ళు',
	'places-geolocation-button-label' => 'ప్రాంతాన్ని చేర్చు',
	'places-geolocation-modal-add-title' => 'ప్రాంతాన్ని చేర్చు',
	'places-geolocation-modal-error-title' => 'లోపం',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'places' => 'Mga lugar sa wiking ito',
	'places-desc' => 'Nagbibigay ng <nowiki><place> at <places></nowiki> mga kalawit ng banghay para sa pagtatatak na pangheograpiya ng mga pahina at isang [[Special:Places|mapa ng lahat ng mga pahinang natatakan]]',
	'places-in-category' => 'Mga lugar na nasa loob ng kategoryang $1',
	'places-on-map' => '{{PLURAL:$1|$1 lugar|$1 mga lugar}} sa ibabaw ng mapang ito',
	'places-modal-go-to-special' => 'Nagpapakita ng  {{PLURAL:$1|$1 lugar|$1 mga lugar}} ([[Special:Places|tingnan lahat]])',
	'places-toolbar-button-tooltip' => 'Lagitikin upang makapagdagdag ng tatak na pangheograpiya sa pahinang ito',
	'places-toolbar-button-address' => 'Paki magbigay ng tirahan na gagamitin bilang isang tatak na pangheograpiya para sa pahinang ito',
	'places-editor-search' => 'Humanap',
	'places-editor-title-create-new' => 'Magdagdag ng isang tatak na pangheograpiya',
	'places-editor-title-edit' => 'Baguhin ang isang tatak na pangheograpiya',
	'places-editor-show-my-location' => 'Dalhin ako sa kinalalagyan ko',
	'places-editor-geoposition' => 'Kasalukuyang kinalalagyang pangheograpiya:',
	'places-geolocation-button-label' => 'Idagdag ang kinalalagyan',
	'places-geolocation-modal-add-title' => 'Idagdag ang kinalalagyan',
	'places-geolocation-modal-error-title' => 'Kamalian',
	'places-geolocation-modal-error' => 'Nagkaroon ng isang kamalian habang sinusubukang alamin ang kinaroroonan mo:<br />$1',
	'places-geolocation-modal-not-available' => 'Naku! Ang tampok na ito ay kasalukuyang makukuha lamang sa mga aparatong naililipat-lipat.<br /><br />Nais mo itong subukan? Dalawin lang ang pahinang ito na ginagamit ang iyong napiling aparatong naililipat-lipat.',
	'places-error-no-article' => 'Dapat kang tumukoy ng isang pahina',
	'places-error-place-already-exists' => 'Nalagyan na ang pahinang ito ng tatak na pangheograpiya',
	'places-updated-geolocation' => 'Nalagyan na ang pahinang ito ng tatak na pangheograpiya',
	'places-category-switch' => 'Huwag paganahin ang paglalagay ng tatak na pangheograpiya',
	'places-category-switch-off' => 'Paganahin ang paglalagay ng tatak na pangheograpiya',
);

/** Turkish (Türkçe)
 * @author Incelemeelemani
 */
$messages['tr'] = array(
	'places-editor-search' => 'Ara',
	'places-editor-title-create-new' => 'Bir coğrafi etiket ekle',
	'places-editor-title-edit' => 'Coğrafi etiketi düzenle',
	'places-editor-show-my-location' => 'Beni konumumu bul',
	'places-editor-geoposition' => 'Mevcut coğrafi konum:',
	'places-geolocation-button-label' => 'Konum ekle',
	'places-geolocation-modal-add-title' => 'Konum ekle',
	'places-geolocation-modal-error-title' => 'Hata',
	'places-geolocation-modal-error' => 'Konumunuz belirlenmeye çalışılırken bir hata oluştu:<br />$1',
	'places-geolocation-modal-not-available' => 'Bu özellik şu anda yalnızca mobil sürümdü kullanılabilir. <br /><br /> Tekrar denemek ister misiniz? Bu sayfayı yalnızca mobil cihazınız ile ziyaret edin.',
	'places-error-no-article' => 'Bir sayfa belirtmelisiniz',
);

/** Ukrainian (українська)
 * @author A1
 * @author Andriykopanytsia
 * @author Steve.rusyn
 * @author SteveR
 */
$messages['uk'] = array(
	'places' => 'Місця на цій wiki',
	'places-desc' => 'Забезпечує <nowiki><place> і <places></nowiki> аналізує закладки для геоміток на сторінках та на [[Special:Places|карті всіх сторінок з мітками]]',
	'places-in-category' => 'Місця в категорії $1',
	'places-on-map' => '{{PLURAL:$1|$1 місце|$1 місця|$1 місць}} на цій карті',
	'places-modal-go-to-special' => 'Показано {{PLURAL:$1|$1 місце|$1 місця|$1 місць}} ([[Special:Places|побачити усе]])',
	'places-toolbar-button-tooltip' => 'Натисніть, щоб додати геомітку на цій сторінці',
	'places-toolbar-button-address' => 'Будь ласка, вкажіть адресу для використання геоміток для цієї сторінки',
	'places-editor-search' => 'Пошук',
	'places-editor-title-create-new' => 'Додати геомітку',
	'places-editor-title-edit' => 'Редагувати геомітку',
	'places-editor-show-my-location' => "Прив'язати мене до мого розташування",
	'places-editor-geoposition' => 'Поточне розташування:',
	'places-geolocation-button-label' => 'Додати розташування',
	'places-geolocation-modal-add-title' => 'Додати розташування',
	'places-geolocation-modal-error-title' => 'Помилка',
	'places-geolocation-modal-error' => 'Виникла помилка під час спроби визначити вашу позицію:<br />$1',
	'places-geolocation-modal-not-available' => 'На жаль! Наразі ця функція доступна тільки на мобільних пристроях.<br /><br />Хочете спробувати? Просто зайдіть на цю сторінку за допомогою вашого мобільного пристрою.',
	'places-error-no-article' => 'Ви повинні вказати сторінку',
	'places-error-place-already-exists' => 'Ця сторінка вже є геоміткою',
	'places-updated-geolocation' => 'Додати геомітку на цю сторінку',
	'places-category-switch' => 'Вимкнути додавання геоміток',
	'places-category-switch-off' => 'Увімкнути додавання геоміток',
);

/** Vietnamese (Tiếng Việt)
 * @author Baonguyen21022003
 */
$messages['vi'] = array(
	'places' => 'Địa điễm trên wiki này',
	'places-geolocation-button-label' => 'Thêm địa điểm',
	'places-geolocation-modal-add-title' => 'Thêm địa điểm',
	'places-geolocation-modal-error-title' => 'Lỗi',
	'places-geolocation-modal-error' => 'Đã có lỗi trong khi cố gắng để xác định vị trí của bạn:<br />$1',
	'places-geolocation-modal-not-available' => 'Rất tiếc! Tính năng này là hiện chỉ trên thiết bị di động.<br /><br />Bạn muốn cho nó thử? Chỉ cần truy cập trang này bằng cách sử dụng điện thoại di động của sự lựa chọn.',
	'places-error-no-article' => 'Bạn phải chỉ định một trang',
);

/** Walloon (walon)
 * @author Srtxg
 */
$messages['wa'] = array(
	'places' => 'Plaeces sol wiki',
	'places-desc' => 'Fornixh li sopoirt po des etiketes <nowiki><place> et <places></nowiki> po marker des eplaeçmints djeyografikes, eyet ene [[Special:Places|mape di totes les markêyès plaeces]].',
	'places-in-category' => 'Plaeces del categoreye $1',
	'places-on-map' => '{{PLURAL:$1|$1 eplaeçmint|$1 eplaeçmints}} sol mape',
	'places-modal-go-to-special' => 'Håyner {{PLURAL:$1|$1 eplaeçmint|$1 eplaeçmints}} ([[Special:Places|vey totafwait]])',
	'places-toolbar-button-tooltip' => "Clitchîz po radjouter ene etikete d' eplaeçmint djeyografike",
	'places-toolbar-button-address' => "Dinez s' i vs plait l' adresse a-z eployî come etikete djeyografike po cisse pådje ci",
	'places-editor-search' => 'Cweri',
	'places-editor-title-create-new' => 'Radjouter etikete djeyografike',
	'places-editor-title-edit' => 'Candjî etikete djeyografike',
	'places-editor-show-my-location' => 'Potchî al plaece da minne',
	'places-editor-geoposition' => 'Eplaeçmint pol moumint:',
	'places-geolocation-button-label' => 'Radjouter eplaeçmint',
	'places-geolocation-modal-add-title' => 'Radjouter eplaeçmint',
	'places-geolocation-modal-error-title' => 'Aroke',
	'places-geolocation-modal-error' => "Åk n' a nén stî tot sayant d' trover vost eplaeçmint:<br />$1",
	'places-geolocation-modal-not-available' => "Waye! Cisse fonccionalité la n' egzistêye pol moumint ki so des axhlåves.<br /><br />Voloz vs sayî? I vs sufixh d' aler so cisse pådje ci avou èn éndjin mobile.",
	'places-error-no-article' => 'Vos dvoz dner ene pådje',
	'places-error-place-already-exists' => 'Cisse pådje ci a ddja ene etikete djeyografike',
	'places-updated-geolocation' => 'Eplaeçmint djeyografike metou sol pådje',
	'places-category-switch' => 'Dismete les etiketes djeyografikes',
	'places-category-switch-off' => 'Permete les etiketes djeyografikes',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Dimension
 * @author Hydra
 * @author Yfdyh000
 */
$messages['zh-hans'] = array(
	'places' => '本维基上的地点',
	'places-desc' => '提供<nowiki><place>和<places></nowiki>解析器钩，以供有地理标记的页面和[[Special:Places|所有有标记的页面的地图]]',
	'places-in-category' => '$1 分类的放置',
	'places-on-map' => '在此地图有{{PLURAL:$1|$1个地方|$1个地方}}',
	'places-modal-go-to-special' => '显示了{{PLURAL:$1|$1个地方|$1个地方}}（[[Special:Places|观看所有]]）',
	'places-toolbar-button-tooltip' => '点击以在此页上添加地理标签',
	'places-toolbar-button-address' => '请为此页提供一个作为地理标志的地址',
	'places-editor-search' => '搜索',
	'places-editor-title-create-new' => '添加地理标签',
	'places-editor-title-edit' => '编辑地理标签',
	'places-editor-show-my-location' => '带我到我的位置',
	'places-editor-geoposition' => '当前地理位置：',
	'places-geolocation-button-label' => '添加位置',
	'places-geolocation-modal-add-title' => '添加位置',
	'places-geolocation-modal-error-title' => '错误',
	'places-geolocation-modal-error' => '尝试测定您的位置时出错：<br />$1',
	'places-geolocation-modal-not-available' => '此功能目前仅可用于移动设备。<br /><br />想试试它？只需换用您的移动设备访问此页面。',
	'places-error-no-article' => '您必须指定一个页面',
	'places-error-place-already-exists' => '此页已有地理标签',
	'places-updated-geolocation' => '已在此页添加地理标签',
	'places-category-switch' => '禁用地理标签',
	'places-category-switch-off' => '启用地理标签',
);

/** Traditional Chinese (中文（繁體）‎)
 * @author Liuxinyu970226
 */
$messages['zh-hant'] = array(
	'places-editor-search' => '搜尋',
);
