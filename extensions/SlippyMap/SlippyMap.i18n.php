<?php
/**
 * Internationalisation file for SlippyMap extension.
 *
 ##################################################################################
 #
 # Copyright 2008 Harry Wood, Jens Frank, Grant Slater, Raymond Spekking
 #                and the autors of betawiki
 #
 # This program is free software; you can redistribute it and/or modify
 # it under the terms of the GNU General Public License as published by
 # the Free Software Foundation; either version 2 of the License, or
 # (at your option) any later version.
 #
 # This program is distributed in the hope that it will be useful,
 # but WITHOUT ANY WARRANTY; without even the implied warranty of
 # MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 # GNU General Public License for more details.
 #
 # You should have received a copy of the GNU General Public License
 # along with this program; if not, write to the Free Software
 # Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 #
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'slippymap_desc' => "Allows the use of the <tt><nowiki>&lt;slippymap&gt;</nowiki></tt> tag to display an OpenLayers slippy map. Maps are from [http://openstreetmap.org openstreetmap.org]",
	'slippymap_latmissing' => "Missing lat value (for the latitude).",
	'slippymap_lonmissing' => "Missing lon value (for the longitude).",
	'slippymap_zoommissing' => "Missing z value (for the zoom level).",
	'slippymap_longdepreciated' => "Please use 'lon' instead of 'long' (parameter was renamed).",
	'slippymap_widthnan' => "width (w) value '%1' is not a valid integer",
	'slippymap_heightnan' => "height (h) value '%1' is not a valid integer",
	'slippymap_zoomnan' => "zoom (z) value '%1' is not a valid integer",
	'slippymap_latnan' => "latitude (lat) value '%1' is not a valid number",
	'slippymap_lonnan' => "longitude (lon) value '%1' is not a valid number",
	'slippymap_widthbig' => "width (w) value cannot be greater than 1000",
	'slippymap_widthsmall' => "width (w) value cannot be less than 100",
	'slippymap_heightbig' => "height (h) value cannot be greater than 1000",
	'slippymap_heightsmall' => "height (h) value cannot be less than 100",
	'slippymap_latbig' => "latitude (lat) value cannot be greater than 90",
	'slippymap_latsmall' => "latitude (lat) value cannot be less than -90",
	'slippymap_lonbig' => "longitude (lon) value cannot be greater than 180",
	'slippymap_lonsmall' => "longitude (lon) value cannot be less than -180",
	'slippymap_zoomsmall' => "zoom (z) value cannot be less than zero",
	'slippymap_zoom18' => "zoom (z) value cannot be greater than 17. Note that this MediaWiki extension hooks into the OpenStreetMap 'osmarender' layer which does not go beyond zoom level 17. The Mapnik layer available on openstreetmap.org, goes up to zoom level 18",
	'slippymap_zoombig' => "zoom (z) value cannot be greater than 17.",
	'slippymap_invalidlayer' => "Invalid 'layer' value '%1'",
	'slippymap_maperror' => "Map error:",
	'slippymap_osmlink' => 'http://www.openstreetmap.org/?lat=%1&lon=%2&zoom=%3', # do not translate or duplicate this message to other languages
	'slippymap_osmtext' => 'See this map on OpenStreetMap.org',
	'slippymap_code'    => 'Wikicode for this map view:',
	'slippymap_button_code' => 'Get wikicode',
	'slippymap_resetview' => 'Reset view',
	'slippymap_license' => 'OpenStreetMap - CC-BY-SA-2.0', # do not translate or duplicate this message to other languages
);

/** Message documentation (Message documentation)
 * @author Purodha
 */
$messages['qqq'] = array(
	'slippymap_desc' => 'Short description of the Slippymap extension, shown in [[Special:Version]]. Do not translate or change links.',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'slippymap_desc' => 'يسمح باستخدام وسم <tt><nowiki>&lt;slippymap&gt;</nowiki></tt> لعرض خريطة OpenLayers لزقة. الخرائط من [http://openstreetmap.org openstreetmap.org]',
	'slippymap_latmissing' => 'قيمة lat مفقودة (للارتفاع).',
	'slippymap_lonmissing' => 'قيمة lon مفقودة (لخط الطول).',
	'slippymap_zoommissing' => 'قيمة z مفقودة (لمستوى التقريب).',
	'slippymap_longdepreciated' => "من فضلك استخدم 'lon' بدلا من 'long' (المحدد تمت إعادة تسميته).",
	'slippymap_widthnan' => "قيمة العرض (w) '%1' ليست رقما صحيحا",
	'slippymap_heightnan' => "قيمة الارتفاع (h) '%1' ليست رقما صحيحا",
	'slippymap_zoomnan' => "قيمة التقريب (z) '%1' ليست رقما صحيحا",
	'slippymap_latnan' => "قيمة خط العرض (lat) '%1' ليست رقما صحيحا",
	'slippymap_lonnan' => "قيمة خط الطول (lon) '%1' ليست رقما صحيحا",
	'slippymap_widthbig' => 'قيمة العرض (w) لا يمكن أن تكون أكبر من 1000',
	'slippymap_widthsmall' => 'قيمة العرض (w) لا يمكن أن تكون أصغر من 100',
	'slippymap_heightbig' => 'قيمة الارتفاع (h) لا يمكن أن تكون أكبر من 1000',
	'slippymap_heightsmall' => 'قيمة الارتفاع (h) لا يمكن أن تكون أقل من 100',
	'slippymap_latbig' => 'قيمة دائرة العرض (lat) لا يمكن أن تكون أكبر من 90',
	'slippymap_latsmall' => 'قيمة دائرة العرض (lat) لا يمكن أن تكون أقل من -90',
	'slippymap_lonbig' => 'قيمة خط الطول (lon) لا يمكن أن تكون أكبر من 180',
	'slippymap_lonsmall' => 'قيمة خط الطول (lon) لا يمكن أن تكون أقل من -180',
	'slippymap_zoomsmall' => 'قيمة التقريب (z) لا يمكن أن تكون أقل من صفر',
	'slippymap_zoom18' => "قيمة التقريب (z) لا يمكن أن تكون أكبر من 17. لاحظ أن امتداد الميدياويكي هذا يخطف إلى طبقة OpenStreetMap 'osmarender' والتي لا تذهب أبعد من مستوى التقريب 17. طبقة Mapnik المتوفرة في openstreetmap.org، تذهب إلى مستوى تقريب 18",
	'slippymap_zoombig' => 'قيمة التقريب (z) لا يمكن أن تكون أكبر من 17.',
	'slippymap_invalidlayer' => "قيمة 'طبقة' غير صحيحة '%1'",
	'slippymap_maperror' => 'خطأ في الخريطة:',
	'slippymap_osmtext' => 'انظر هذه الخريطة في OpenStreetMap.org',
	'slippymap_code' => 'كود الويكي لعرض الخريطة هذا:',
	'slippymap_button_code' => 'الحصول على كود ويكي',
	'slippymap_resetview' => 'إعادة ضبط الرؤية',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'slippymap_desc' => 'يسمح باستخدام وسم <tt><nowiki>&lt;slippymap&gt;</nowiki></tt> لعرض خريطة OpenLayers لزقة. الخرائط من [http://openstreetmap.org openstreetmap.org]',
	'slippymap_latmissing' => 'قيمة lat مفقودة (للارتفاع).',
	'slippymap_lonmissing' => 'قيمة lon مفقودة (لخط الطول).',
	'slippymap_zoommissing' => 'قيمة z مفقودة (لمستوى التقريب).',
	'slippymap_longdepreciated' => "من فضلك استخدم 'lon' بدلا من 'long' (المحدد تمت إعادة تسميته).",
	'slippymap_widthnan' => "قيمة العرض (w) '%1' ليست رقما صحيحا",
	'slippymap_heightnan' => "قيمة الارتفاع (h) '%1' ليست رقما صحيحا",
	'slippymap_zoomnan' => "قيمة التقريب (z) '%1' ليست رقما صحيحا",
	'slippymap_latnan' => "قيمة خط العرض (lat) '%1' ليست رقما صحيحا",
	'slippymap_lonnan' => "قيمة خط الطول (lon) '%1' ليست رقما صحيحا",
	'slippymap_widthbig' => 'قيمة العرض (w) لا يمكن أن تكون أكبر من 1000',
	'slippymap_widthsmall' => 'قيمة العرض (w) لا يمكن أن تكون أصغر من 100',
	'slippymap_heightbig' => 'قيمة الارتفاع (h) لا يمكن أن تكون أكبر من 1000',
	'slippymap_heightsmall' => 'قيمة الارتفاع (h) لا يمكن أن تكون أقل من 100',
	'slippymap_latbig' => 'قيمة دائرة العرض (lat) لا يمكن أن تكون أكبر من 90',
	'slippymap_latsmall' => 'قيمة دائرة العرض (lat) لا يمكن أن تكون أقل من -90',
	'slippymap_lonbig' => 'قيمة خط الطول (lon) لا يمكن أن تكون أكبر من 180',
	'slippymap_lonsmall' => 'قيمة خط الطول (lon) لا يمكن أن تكون أقل من -180',
	'slippymap_zoomsmall' => 'قيمة التقريب (z) لا يمكن أن تكون أقل من صفر',
	'slippymap_zoom18' => "قيمة التقريب (z) لا يمكن أن تكون أكبر من 17. لاحظ أن امتداد الميدياويكى هذا يخطف إلى طبقة OpenStreetMap 'osmarender' والتى لا تذهب أبعد من مستوى التقريب 17. طبقة Mapnik المتوفرة فى openstreetmap.org، تذهب إلى مستوى تقريب 18",
	'slippymap_zoombig' => 'قيمة التقريب (z) لا يمكن أن تكون أكبر من 17.',
	'slippymap_invalidlayer' => "قيمة 'طبقة' غير صحيحة '%1'",
	'slippymap_maperror' => 'خطأ فى الخريطة:',
	'slippymap_osmtext' => 'انظر هذه الخريطة فى OpenStreetMap.org',
	'slippymap_code' => 'كود الويكى لعرض الخريطة هذا:',
	'slippymap_button_code' => 'الحصول على كود ويكي',
	'slippymap_resetview' => 'إعادة ضبط الرؤية',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'slippymap_desc' => 'Позволява използването на етикета <tt><nowiki>&lt;slippymap&gt;</nowiki></tt> за показване на OpenLayers slippy карти. Картите са от [http://openstreetmap.org openstreetmap.org]',
	'slippymap_zoommissing' => 'Липсваща стойност z (за степен на приближаване).',
	'slippymap_zoomsmall' => 'стойността за приближаване (z) не може да бъде отрицателно число',
	'slippymap_zoombig' => 'стойността за приближаване (z) не може да бъде по-голяма от 17.',
	'slippymap_invalidlayer' => "Невалидна стойност на 'слоя' '%1'",
	'slippymap_maperror' => 'Грешка в картата:',
	'slippymap_osmtext' => 'Преглеждане на картата в OpenStreetMap.org',
	'slippymap_code' => 'Уикикод за тази карта:',
);

/** Czech (Česky)
 * @author Danny B.
 */
$messages['cs'] = array(
	'slippymap_desc' => 'Umožňuje použití tagu <code><nowiki>&lt;slippymap&gt;</nowiki></code> pro zobrazení posuvné mapy OpenLayers. Mapy pocházejí z [http://openstreetmap.org openstreetmap.org].',
	'slippymap_latmissing' => 'Chybí hodnota lat (zeměpisná šířka)',
	'slippymap_lonmissing' => 'Chybí hodnota lon (zeměpisná délka)',
	'slippymap_zoommissing' => 'Chybí hodnota z (úroveň přiblížení)',
	'slippymap_longdepreciated' => 'Prosím, použijte „lon” namísto „long” (parametr byl přejmenován).',
	'slippymap_widthnan' => 'hodnota šířky (w) „%1” není platné celé číslo',
	'slippymap_heightnan' => 'hodnota výšky (h) „%1” není platné celé číslo',
	'slippymap_zoomnan' => 'hodnota úrovně přiblížení (z) „%1” není platné celé číslo',
	'slippymap_latnan' => 'hodnota zeměpisné šířky (lat) „%1” není platné číslo',
	'slippymap_lonnan' => 'hodnota zeměpisné délky (lon) „%1” není platné číslo',
	'slippymap_widthbig' => 'hodnota šířky (w) nemůže být větší než 1000',
	'slippymap_widthsmall' => 'hodnota šířky (w) nemůže být menší než 100',
	'slippymap_heightbig' => 'hodnota výšky (h) nemůže být větší než 1000',
	'slippymap_heightsmall' => 'hodnota výšky (h) nemůže být menší než 100',
	'slippymap_latbig' => 'hodnota zeměpisné šířky (lat) nemůže být větší než 90',
	'slippymap_latsmall' => 'hodnota zeměpisné šířky (lat) nemůže být menší než -90',
	'slippymap_lonbig' => 'hodnota zeměpisné délky (lon) nemůže být větší než 180',
	'slippymap_lonsmall' => 'hodnota zeměpisné délky (lon) nemůže být menší než -180',
	'slippymap_zoomsmall' => 'hodnota úrovně přiblížení (z) nemůže být menší než nula',
	'slippymap_zoom18' => 'Hodnota úrovně přiblížení (z) nemůže být větší než 17. Mějte na vědomí, že toto rozšíření MediaWiki používá vrstvu „osmarender” OpenStreetMap, která umožňuje úroveň priblížení až 17. Vrstva „Mapnik“ na openstreetmap.org umožňuje priblížení do úrovně 18.',
	'slippymap_zoombig' => 'Hodnota úrovně přiblížení (z) nemůže být větší než 17.',
	'slippymap_invalidlayer' => 'Neplatná hodnota „layer” „%1”',
	'slippymap_maperror' => 'Chyba mapy:',
	'slippymap_osmtext' => 'Zobrazit tuto mapu na OpenStreetMap.org',
	'slippymap_code' => 'Wikikód tohoto pohledu na mapu:',
	'slippymap_button_code' => 'Zobrazit wikikód',
	'slippymap_resetview' => 'Obnovit zobrazení',
);

/** German (Deutsch)
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'slippymap_desc' => 'Ermöglicht die Nutzung des <tt><nowiki>&lt;slippymap&gt;</nowiki></tt>-Tags zur Anzeige einer OpenLayer-SlippyMap. Die Karten stammen von [http://openstreetmap.org openstreetmap.org]',
	'slippymap_latmissing' => 'Es wurde kein Wert für die geografische Breite (lat) angegeben.',
	'slippymap_lonmissing' => 'Es wurde kein Wert für die geografische Länge (lon) angegeben.',
	'slippymap_zoommissing' => 'Es wurde kein Zoom-Wert (z) angegeben.',
	'slippymap_longdepreciated' => "Bitte benutze 'lon' an Stelle von 'long' (Parameter wurde umbenannt).",
	'slippymap_widthnan' => "Der Wert für die Breite (w) '%1' ist keine gültige Zahl",
	'slippymap_heightnan' => "Der Wert für die Höhe (h) '%1' ist keine gültige Zahl",
	'slippymap_zoomnan' => "Der Wert für den Zoom (z) '%1' ist keine gültige Zahl",
	'slippymap_latnan' => "Der Wert für die geografische Breite (lat) '%1' ist keine gültige Zahl",
	'slippymap_lonnan' => "Der Wert für die geografische Länge (lon) '%1' ist keine gültige Zahl",
	'slippymap_widthbig' => 'Die Breite (w) darf 1000 nicht überschreiten',
	'slippymap_widthsmall' => 'Die Breite (w) darf 100 nicht unterschreiten',
	'slippymap_heightbig' => 'Die Höhe (h) darf 1000 nicht überschreiten',
	'slippymap_heightsmall' => 'Die Höhe (h) darf 100 nicht unterschreiten',
	'slippymap_latbig' => 'Die geografische Breite darf nicht größer als 90 sein',
	'slippymap_latsmall' => 'Die geografische Breite darf nicht kleiner als -90 sein',
	'slippymap_lonbig' => 'Die geografische Länge darf nicht größer als 180 sein',
	'slippymap_lonsmall' => 'Die geografische Länge darf nicht kleiner als -180 sein',
	'slippymap_zoomsmall' => 'Der Zoomwert darf nicht negativ sein',
	'slippymap_zoom18' => "Der Zoomwert (z) darf nicht größer als 17 sein. Beachte, dass diese MediaWiki-Erweiterung die OpenStreetMap 'Osmarender'-Karte einbindet, die nicht höher als Zoom 17 geht. Die Mapnik-Karte ist auf openstreetmap.org verfügbar und geht bis Zoom 18.",
	'slippymap_zoombig' => 'Der Zoomwert (z) darf nicht größer als 17 sein.',
	'slippymap_invalidlayer' => "Ungültiger 'layer'-Wert „%1“",
	'slippymap_maperror' => 'Kartenfehler:',
	'slippymap_osmtext' => 'Diese Karte auf OpenStreetMap.org ansehen',
	'slippymap_code' => 'Wikitext für diese Kartenansicht:',
	'slippymap_button_code' => 'Zeige Wikicode',
	'slippymap_resetview' => 'Zurücksetzen',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'slippymap_maperror' => 'Mapa eraro:',
	'slippymap_osmtext' => 'Vidi ĉi tiun mapon en OpenStreetMap.org',
	'slippymap_code' => 'Vikikodo por ĉi tiu mapvido:',
	'slippymap_button_code' => 'Akiri vikikodon',
	'slippymap_resetview' => 'Restarigi vidon',
);

/** Basque (Euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'slippymap_button_code' => 'Wikikodea lortu',
);

/** Finnish (Suomi)
 * @author Nike
 * @author Str4nd
 * @author Vililikku
 */
$messages['fi'] = array(
	'slippymap_desc' => 'Mahdollistaa <tt><nowiki>&lt;slippymap&gt;</nowiki></tt>-elementin käytön OpenLayers slippy map -kartan näyttämiseen. Kartat ovat osoitteesta [http://openstreetmap.org openstreetmap.org].',
	'slippymap_latmissing' => 'Puuttuva ”lat”-arvo leveysasteille.',
	'slippymap_lonmissing' => 'Puuttuva ”lon”-arvo pituusasteille.',
	'slippymap_zoommissing' => 'Puuttuva ”z”-arvo zoomaukselle.',
	'slippymap_longdepreciated' => 'Käytä ”lon”-arvoa ”long”-arvon sijasta nimenmuutoksen vuoksi.',
	'slippymap_widthnan' => 'leveysarvo (w) ”%1” ei ole kelvollinen kokonaisluku',
	'slippymap_heightnan' => 'Korkeusarvo (h) ”%1” ei ole kelvollinen kokonaisluku',
	'slippymap_zoomnan' => 'zoom-arvo (z) ”%1” ei ole kelvollinen kokonaisluku',
	'slippymap_latnan' => 'leveysastearvo (lat) ”%1” ei ole kelvollinen luku',
	'slippymap_lonnan' => 'Pituusastearvo ”%1” ei ole kelvollinen luku',
	'slippymap_widthbig' => 'leveysarvo (w) ei voi olla yli 1000',
	'slippymap_widthsmall' => 'leveysarvo (w) ei voi olla alle 100',
	'slippymap_heightbig' => 'korkeusarvo (h) ei voi olla yli 1000',
	'slippymap_heightsmall' => 'korkeusarvo (h) ei voi olla alle 100',
	'slippymap_latbig' => 'leveysastearvo (lat) ei voi olla yli 90',
	'slippymap_latsmall' => 'leveysastearvo (lat) ei voi olla alle -90',
	'slippymap_lonbig' => 'pituusastearvo (lon) ei voi olla yli 180',
	'slippymap_lonsmall' => 'pituusastearvo (lon) ei voi olla alle -180',
	'slippymap_zoomsmall' => 'zoom-arvo (z) ei voi olla alle nollan',
	'slippymap_zoom18' => 'Zoomaus (z) -arvo ei voi olla suurempi kuin 17. Tämä MediaWiki-laajennos hakee OpenStreetMapin Osmarender-tason, jota ei voi lähentää tasoa 17 enempää. Mapnik-taso, joka myös on käytettävissä openstreetmap.org:ssa, sisältää myös 18. lähennystason.',
	'slippymap_zoombig' => 'zoom-arvo (z) ei voi olla yli 17.',
	'slippymap_invalidlayer' => 'Virheellinen ”layer”-arvo ”%1”',
	'slippymap_maperror' => 'Karttavirhe:',
	'slippymap_osmtext' => 'Katso tämä kartta osoitteessa OpenStreetMap.org.',
	'slippymap_code' => 'Wikikoodi tälle karttanäkymälle:',
	'slippymap_button_code' => 'Hae wikikoodi',
	'slippymap_resetview' => 'Palauta näkymä',
);

/** French (Français)
 * @author Cedric31
 * @author Grondin
 */
$messages['fr'] = array(
	'slippymap_desc' => 'Autorise l’utilisation de la balise <tt><nowiki>&lt;slippymap&gt;</nowiki></tt> pour afficher une carte glissante d’OpenLayers. Les cartes proviennent de [http://openstreetmap.org openstreetmap.org]',
	'slippymap_latmissing' => 'Valeur lat manquante (pour la latitude).',
	'slippymap_lonmissing' => 'Valeur lon manquante (pour la longitude).',
	'slippymap_zoommissing' => 'Valeur z manquante (pour le niveau du zoom).',
	'slippymap_longdepreciated' => 'Veuillez utiliser « lon » au lieu de « long » (le paramètre a été renommé).',
	'slippymap_widthnan' => 'La largeur (w) ayant pour valeur « %1 » n’est pas un nombre entier correct.',
	'slippymap_heightnan' => 'La hauteur (h) ayant pour valeur « %1 » n’est pas un nombre entier correct.',
	'slippymap_zoomnan' => 'Le zoom (z) ayant pour valeur « %1 » n’est pas un nombre entier correct.',
	'slippymap_latnan' => 'La latitude (lat) ayant pour valeur « %1 » n’est pas un nombre correct.',
	'slippymap_lonnan' => 'La longitude (lon) ayant pour valeur « %1 » n’est pas un nombre correct.',
	'slippymap_widthbig' => 'La valeur de la largeur (w) ne peut excéder 1000',
	'slippymap_widthsmall' => 'La valeur de la largeur (w) ne peut être inférieure à 100',
	'slippymap_heightbig' => 'La valeur de la hauteur (h) ne peut excéder 1000',
	'slippymap_heightsmall' => 'La valeur de la hauteur (h) ne peut être inférieure à 100',
	'slippymap_latbig' => 'La valeur de la latitude (lat) ne peut excéder 90',
	'slippymap_latsmall' => 'La valeur de la latitude (lat) ne peut être inférieure à -90',
	'slippymap_lonbig' => 'La valeur de la longitude (lon) ne peut excéder 180',
	'slippymap_lonsmall' => 'La valeur de la longitude (lon) ne peut être inférieure à -180',
	'slippymap_zoomsmall' => 'La valeur du zoom (z) ne peut être négative',
	'slippymap_zoom18' => 'La valeur du zoom (z) ne peut excéder 17. Notez que ce crochet d’extension MediaWiki dans la couche « osmarender » de OpenStreetMap ne peut aller au-delà du niveau 17 du zoop. La couche Mapnik disponible sur openstreetmap.org, ne peut aller au-delà du niveau 18.',
	'slippymap_zoombig' => 'La valeur du zoom (z) ne peut excéder 17.',
	'slippymap_invalidlayer' => 'Valeur de « %1 » de la « couche » incorrecte',
	'slippymap_maperror' => 'Erreur de carte :',
	'slippymap_osmtext' => 'Voyez cette carte sur OpenStreetMap.org',
	'slippymap_code' => 'Code Wiki pour le visionnement de cette cate :',
	'slippymap_button_code' => 'Obtenir le code wiki',
	'slippymap_resetview' => 'Réinitialiser le visionnement',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'slippymap_desc' => 'Permite o uso da etiqueta <tt><nowiki>&lt;slippymap&gt;</nowiki></tt> para amosar un mapa slippy. Os mapas son de [http://openstreetmap.org openstreetmap.org]',
	'slippymap_latmissing' => 'Falta o valor lat (para a latitude).',
	'slippymap_lonmissing' => 'Falta o valor lan (para a lonxitude).',
	'slippymap_zoommissing' => 'Falta o valor z (para o nivel do zoom).',
	'slippymap_longdepreciated' => 'Por favor, use "lon" no canto de "long" (o parámetro foi renomeado).',
	'slippymap_widthnan' => "o valor '%1' do ancho (w) non é un número enteiro válido",
	'slippymap_heightnan' => "o valor '%1' da altura (h) non é un número enteiro válido",
	'slippymap_zoomnan' => "o valor '%1' do zoom (z) non é un número enteiro válido",
	'slippymap_latnan' => "o valor '%1' da latitude (lat) non é un número enteiro válido",
	'slippymap_lonnan' => "o valor '%1' da lonxitude (lon) non é un número enteiro válido",
	'slippymap_widthbig' => 'o valor do ancho (w) non pode ser máis de 1000',
	'slippymap_widthsmall' => 'o valor do ancho (w) non pode ser menos de 100',
	'slippymap_heightbig' => 'o valor da altura (h) non pode ser máis de 1000',
	'slippymap_heightsmall' => 'o valor da altura (h) non pode ser menos de 100',
	'slippymap_latbig' => 'o valor da latitude (lat) non pode ser máis de 90',
	'slippymap_latsmall' => 'o valor da latitude (lat) non pode ser menos de -90',
	'slippymap_lonbig' => 'o valor da lonxitude (lon) non pode ser máis de 180',
	'slippymap_lonsmall' => 'o valor da lonxitude (lon) non pode ser menos de -180',
	'slippymap_zoomsmall' => 'o valor do zoom (z) non pode ser menos de cero',
	'slippymap_zoom18' => 'o valor do zoom (z) non pode ser máis de 17. Déase conta de que esta extensión MediaWiki asocia no OpenStreetMap a capa "osmarender", que non vai máis alá do nivel 17 do zoom. A capa Mapnik dispoñible en openstreetmap.org, vai máis aló do nivel 18',
	'slippymap_zoombig' => 'o valor do zoom (z) non pode ser máis de 17.',
	'slippymap_invalidlayer' => 'Valor \'%1\' da "capa" inválido',
	'slippymap_maperror' => 'Erro no mapa:',
	'slippymap_osmtext' => 'Vexa este mapa en OpenStreetMap.org',
	'slippymap_code' => 'Código wiki para o visionado deste mapa:',
	'slippymap_button_code' => 'Obter o código wiki',
	'slippymap_resetview' => 'Axustar a vista',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'slippymap_desc' => 'מתן האפשרות לשימוש בתגית <tt><nowiki>&lt;slippymap&gt;</nowiki></tt> להצגת מפת OpenLayers רדומה. המפות הן מהאתר [http://openstreetmap.org openstreetmap.org]',
	'slippymap_latmissing' => 'ערך ה־lat חסר (עבור קו־הרוחב).',
	'slippymap_lonmissing' => 'ערך ה־lon חסר(עבור קו־האורך).',
	'slippymap_zoommissing' => 'ערך ה־z חסר (לרמת ההגדלה).',
	'slippymap_longdepreciated' => "אנא השתמשו ב־'lon' במקום ב־'long' (שם הפרמטר שונה).",
	'slippymap_widthnan' => "ערך הרוחב (w) '%1' אינו מספר שלם תקין",
	'slippymap_heightnan' => "ערך הגובה (h) '%1' אינו מספר שלם תקין",
	'slippymap_zoomnan' => "ערך ההגדלה (z) '%1' אינו מספר שלם תקין",
	'slippymap_latnan' => "ערך קו־הרוחב (lat) '%1' אינו מספר תקין",
	'slippymap_lonnan' => "ערך קו־האורך (lon) '%1' אינו מספר תקין",
	'slippymap_widthbig' => 'ערך הרוחב (w) לא יכול לחרוג מעבר ל־1000.',
	'slippymap_widthsmall' => 'ערך הרוחב (w) לא יכול לחרוג אל מתחת ל־100',
	'slippymap_heightbig' => 'ערך הגובה (h) לא יכול לחרוג אל מעבר ל־1000',
	'slippymap_heightsmall' => 'ערך הגובה (h) לא יכול לחרוג אל מתחת ל־100',
	'slippymap_latbig' => 'ערך קו־הרוחב (lat) לא יכול לחרוג מעבר ל־90',
	'slippymap_latsmall' => 'ערך קו־הרוחב (lat) לא יכול לחרוג אל מתחת ל־ -90',
	'slippymap_lonbig' => 'ערך קו־האורך (lon) לא יכול לחרוג אל מעבר ל־180',
	'slippymap_lonsmall' => 'ערך קו־האורך (lon) לא יכול לחרוג אל מתחת ל־ -180',
	'slippymap_zoomsmall' => 'ערך ההגדלה (z) לא יכול לחרוג אל מתחת לאפס',
	'slippymap_zoom18' => "ערך ההגדלה (z) לא יכול לחרוג אל מעבר ל־17. שימו לב שהרחבת מדיה־ויקי זו מתממשקת אל שכבת ה־'osmarender' של OpenStreetMap שאינה תומכת ברמת הגדלה הגדולה מ־17. שכבת ה־Mapnik הזמינה באתר openstreetmap.org, מגיעה לרמת הגדלה 18.",
	'slippymap_zoombig' => 'ערך ההגדלה (z) לא יכול לחרוג אל מעבר ל־17.',
	'slippymap_invalidlayer' => "ערך ה־'layer' אינו תקין '%1'",
	'slippymap_maperror' => 'שגיאת מפה:',
	'slippymap_osmtext' => 'עיינו במפה זו באתר OpenStreetMap.org',
	'slippymap_code' => 'קוד הוויקי להצגת מפה זו:',
	'slippymap_button_code' => 'איחזור קוד הוויקי',
	'slippymap_resetview' => 'איפוס התצוגה',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'slippymap_desc' => 'Permitte le uso del etiquetta <tt><nowiki>&lt;slippymap&gt;</nowiki></tt> pro monstrar un carta glissante de OpenLayers. Le cartas proveni de [http://openstreetmap.org openstreetmap.org]',
	'slippymap_latmissing' => 'Valor lat mancante (pro le latitude).',
	'slippymap_lonmissing' => 'Valor lon mancante (pro le longitude).',
	'slippymap_zoommissing' => 'Valor z mancante (pro le nivello de zoom).',
	'slippymap_longdepreciated' => "Per favor usa 'lon' in loco de 'long' (le parametro ha essite renominate).",
	'slippymap_widthnan' => "Le valor '%1' del latitude (w) non es un numero integre valide",
	'slippymap_heightnan' => "Le valor '%1' del altitude (h) non es un numero integre valide",
	'slippymap_zoomnan' => "Le valor '%1' del zoom (z) non es un numero integre valide",
	'slippymap_latnan' => "Le valor '%1' del latitude (lat) non es un numero valide",
	'slippymap_lonnan' => "Le valor '%1' del longitude (lon) non es un numero valide",
	'slippymap_widthbig' => 'Le valor del latitude (w) non pote exceder 1000',
	'slippymap_widthsmall' => 'Le valor del latitude (w) non pote esser minus de 100',
	'slippymap_heightbig' => 'Le valor del altitude (h) non pote esser plus de 1000',
	'slippymap_heightsmall' => 'Le valor del altitude (h) non pote esser minus de 100',
	'slippymap_latbig' => 'Le valor del latitude (lat) non pote exceder 90',
	'slippymap_latsmall' => 'Le valor del latitude (lat) non pote esser minus de -90',
	'slippymap_lonbig' => 'Le valor del longitude (lon) non pote exceder 100',
	'slippymap_lonsmall' => 'Le valor del longitude (lon) non pote esser minus de -100',
	'slippymap_zoomsmall' => 'Le valor del zoom (z) non pote esser minus de zero',
	'slippymap_zoom18' => "Le valor del zoom (z) non pote exceder 17. Nota que iste extension de MediaWiki se installa in le strato 'osmarender' de OpenStreetMap, le qual non excede le nivello de zoom 17. Le strato Mapnik disponibile in openstreetmap.org ha un nivello de zoom maxime de 18.",
	'slippymap_zoombig' => 'Le valor del zoom (z) non pote exceder 17.',
	'slippymap_invalidlayer' => "Valor de 'strato' invalide '%1'",
	'slippymap_maperror' => 'Error de carta:',
	'slippymap_osmtext' => 'Vider iste carta in OpenStreetMap.org',
	'slippymap_code' => 'Codice Wiki pro iste vista del carta:',
	'slippymap_button_code' => 'Obtener codice wiki',
	'slippymap_resetview' => 'Reinitialisar vista',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'slippymap_desc' => "Permette l'utilizzo del tag <tt><nowiki>&lt;slippymap&gt;</nowiki></tt> per visualizzare una mappa OpenLayers. Le mappe sono prese da [http://openstreetmap.org openstreetmap.org]",
	'slippymap_latmissing' => 'Manca il valore lat (per la latitudine).',
	'slippymap_lonmissing' => 'Manca il valore lon (per la longitudine).',
	'slippymap_zoommissing' => 'Manca il valore z (per il livello dello zoom).',
	'slippymap_longdepreciated' => "Usare 'lon' invece di 'long' (il parametro è stato rinominato).",
	'slippymap_widthnan' => "il valore '%1' della larghezza (w) non è un intero valido",
	'slippymap_heightnan' => "il valore '%1' dell'altezza (h) non è un intero valido",
	'slippymap_zoomnan' => "il valore '%1' dello zoom (z) non è un intero valido",
	'slippymap_latnan' => "il valore '%1' della latitudine (lat) non è un numero valido",
	'slippymap_lonnan' => "il valore '%1' della longitudine (long) non è un numero valido",
	'slippymap_widthbig' => 'il valore della larghezza (w) non può essere maggiore di 1000',
	'slippymap_widthsmall' => 'il valore della larghezza (w) non può essere minore di 100',
	'slippymap_heightbig' => "il valore dell'altezza (h) non può essere maggiore di 1000",
	'slippymap_heightsmall' => "il valore dell'altezza (h) non può essere minore di 100",
	'slippymap_latbig' => 'il valore della latitudine (lat) non può essere maggiore di 90',
	'slippymap_latsmall' => 'il valore della latitudine (lat) non può essere minore di -90',
	'slippymap_lonbig' => 'il valore della longitudine (lon) non può essere maggiore di 180',
	'slippymap_lonsmall' => 'il valore della longitudine (lon) non può essere minore di -180',
	'slippymap_zoomsmall' => 'il valore dello zoom (z) non può essere minore di zero',
	'slippymap_zoom18' => "il valore dello zoom (z) non può essere maggiore di 17. Nota che questa estensione MediaWiki utilizza il layer 'osmarender' di OpenStreetMap che non va oltre il livello 17 di zoom. Il layer Mapnik disponibile su openstreetmap.org arriva fino a un livello 18 di zoom",
	'slippymap_zoombig' => 'il valore dello zoom (z) non può essere maggiore di 17.',
	'slippymap_invalidlayer' => "Valore '%1' di 'layer' non valido",
	'slippymap_maperror' => 'Errore mappa:',
	'slippymap_osmtext' => 'Guarda questa mappa su OpenStreetMap.org',
	'slippymap_code' => 'Codice wiki per visualizzare questa mappa:',
	'slippymap_button_code' => 'Ottieni codice wiki',
	'slippymap_resetview' => 'Reimposta visuale',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Thearith
 */
$messages['km'] = array(
	'slippymap_latmissing' => 'ខ្វះ​តម្លៃ​រយៈទទឹង (សម្រាប់​រយៈទទឹង)​។',
	'slippymap_lonmissing' => 'ខ្វះ​តម្លៃ​រយៈបណ្ដោយ (សម្រាប់​រយៈបណ្ដោយ)​។',
	'slippymap_zoommissing' => 'ខ្វះ​តម្លៃ Z (សម្រាប់​កម្រិត​ពង្រីក)​។',
	'slippymap_longdepreciated' => "សូម​ប្រើ 'lon' ជំនួស​ឱ្យ 'long' (ប៉ារ៉ាម៉ែត្រ​ត្រូវ​បាន​ប្ដូរឈ្មោះ)​។",
	'slippymap_widthnan' => "តម្លៃ​ទទឹង (w) '%1' មិនមែន​ជា​ចំនួនគត់​ត្រឹមត្រូវ​ទេ",
	'slippymap_heightnan' => "តម្លៃ​កម្ពស់ (h) '%1' មិនមែន​ជា​ចំនួនគត់​ត្រឹមត្រូវ​ទេ",
	'slippymap_zoomnan' => "តម្លៃ​ពង្រីក (z) '%1' មិនមែន​ជា​ចំនួនគត់​ត្រឹមត្រូវ​ទេ",
	'slippymap_latnan' => "តម្លៃ​ទទឹង (lat) '%1' មិនមែន​ជា​ចំនួន​ត្រឹមត្រូវ​ទេ",
	'slippymap_lonnan' => "តម្លៃ​បណ្ដោយ (lon) '%1' មិនមែន​ជា​ចំនួន​ត្រឹមត្រូវ​ទេ",
	'slippymap_widthbig' => 'តម្លៃ​ទទឹង (w) មិន​អាច​ធំជាង ១០០០ ទេ',
	'slippymap_widthsmall' => 'តម្លៃ​ទទឹង (w) មិន​អាច​តូចជាង ១០០ ទេ',
	'slippymap_heightbig' => 'តម្លៃ​កម្ពស់ (h) មិន​អាច​ធំជាង ១០០០ ទេ',
	'slippymap_heightsmall' => 'តម្លៃ​កម្ពស់ (h) មិន​អាច​តូចជាង ១០០ ទេ',
	'slippymap_latbig' => 'តម្លៃ​រយៈទទឹង (lat) មិន​អាច​ធំជាង ៩០ ទេ',
	'slippymap_latsmall' => 'តម្លៃ​រយៈទទឹង (lat) មិន​អាច​តូចជាង -៩០ ទេ',
	'slippymap_lonbig' => 'តម្លៃ​រយៈបណ្ដោយ (lon) មិន​អាច​ធំជាង ១៨០ ទេ',
	'slippymap_lonsmall' => 'តម្លៃ​រយៈបណ្ដោយ (lon) មិន​អាច​តូចជាង -១៨០ ទេ',
	'slippymap_zoomsmall' => 'តម្លៃ​ពង្រីក (z) មិន​អាច​តូចជាង​សូន្យ​ទេ',
	'slippymap_zoombig' => 'តម្លៃ​ពង្រីក (z) មិន​អាច​ធំជាង ១៧ ទេ​។',
	'slippymap_maperror' => 'កំហុស​ផែនទី​៖',
	'slippymap_osmtext' => 'មើល​ផែនទី​នេះ នៅលើ OpenStreetMap.org',
	'slippymap_code' => 'កូដឹវិគី​សម្រាប់​មើល​ផែនទី​នេះ​៖',
	'slippymap_button_code' => 'យក​កូដវិគី',
	'slippymap_resetview' => 'កំណត់​ការមើល​ឡើងវិញ',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'slippymap_desc' => 'Deit dä Befääl <tt> <nowiki>&lt;slippymap&gt;</nowiki> </tt> em Wiki dobei, öm en <i lang="en">OpenLayers slippy map</i> Kaat aanzezeije. De Landkaate-Date kumme dobei fun <i lang="en">[http://openstreetmap.org openstreetmap.org]</i> her.',
	'slippymap_latmissing' => "Dä Wäät 'lat' för de Breed om Jlobus es nit aanjejovve.",
	'slippymap_lonmissing' => "Dä Wäät 'lon' för de Läng om Jlobus es nit aanjejovve.",
	'slippymap_zoommissing' => "Dä Wäät 'z' för dä Zoom es nit aanjejovve.",
	'slippymap_longdepreciated' => "Bes esu joot un donn dä Parrameeter 'lon' för de Läng om Jlobus nämme,
un nit mieh 'long' — dä Parrameeter wood enzwesche ömjanannt.",
	'slippymap_widthnan' => "„%1“ en kein jöltijje positive janze Zahl för dä Wäät 'w' för de Breed fum Beld.",
	'slippymap_heightnan' => "„%1“ en kein jöltijje positive janze Zahl för dä Wäät 'h' för de Hühde fum Beld.",
	'slippymap_zoomnan' => "„%1“ en kein jöltijje janze Zahl för dä Wäät 'z' för der Zoom.",
	'slippymap_latnan' => "„%1“ en kein jöltijje Zahl för dä Wäät 'lat' för de Brred om Jlobus.",
	'slippymap_lonnan' => "„%1“ es kein jöltijje Zahl för dä Wäät 'lon' för de Läng om Jlobus.",
	'slippymap_widthbig' => "Dä Wäät 'w' för de Breed fum Beld darf nit övver 1000 jonn.",
	'slippymap_widthsmall' => "Dä Wäät 'w' för de Breed fum Beld darf nit unger 100 jonn.",
	'slippymap_heightbig' => "Dä Wäät 'h' för de Hühde fum Beld darf nit övver 1000 jonn.",
	'slippymap_heightsmall' => "Dä Wäät 'h' för de Hühde fum Beld darf nit unger 100 jonn.",
	'slippymap_latbig' => "Dä Wäät 'lat' för de Breed om Jlobus darf nit övver 90 sin.",
	'slippymap_latsmall' => "Dä Wäät 'lat' för de Breed om Jlobus darf nit unger -90 sin.",
	'slippymap_lonbig' => "Dä Wäät 'lon' för de Läng om Jlobus darf nit övver 180 sin.",
	'slippymap_lonsmall' => "Dä Wäät 'lon' för de Läng om Jlobus darf nit unger -180 sin.",
	'slippymap_zoomsmall' => "Dä Wäät 'z' för der Zoom darf nit unger Noll sin.",
	'slippymap_zoom18' => 'Dä Wäät \'z\' för dä Zoom darf nit övver 17 sin.
Opjepaß: Hee dä Zosatz zor MediaWiki-ßoffwäer deiht de
<i lang="en">OpenStreetMap</i>-Kaate vum Tüp
\'<i lang="en">Osmarender</i>\' enbenge, wo dä Zoom bes 17 jeiht.
De \'<i lang="en">Mapnik</i>\' Kaate sen och op
http://openstreetmap.org/ ze fenge, un dänne iere Zoom jeiht bes 18.',
	'slippymap_zoombig' => "Dä Wäät 'z' för dä Zoom darf nit övver 17 sin.",
	'slippymap_invalidlayer' => "„%1“ es ene onjöltije Wäät för 'Schesch'.",
	'slippymap_maperror' => 'Fähler met dä Kaat:',
	'slippymap_osmtext' => 'Donn die Kaat op <i lang="en">OpenStreetMap.org</i> anloore',
	'slippymap_code' => 'Dä Wiki-Kood för di Kaate-Aansesh es:',
	'slippymap_button_code' => 'Donn dä Wiki-Kood zeije',
	'slippymap_resetview' => 'Aansesh zeröcksetze',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'slippymap_desc' => "Erméiglecht d'Benotzung vum Tag <tt><nowiki>&lt;slippymap&gt;</nowiki></tt> fir eng ''OpenLayers slippy map'' ze weisen. D'kaarte si vun [http://openstreetmap.org openstreetmap.org]",
	'slippymap_longdepreciated' => "Benitzt w.e.g. 'lon' aplaz vun  'long' (de parameter gouf ëmbennnt)",
	'slippymap_widthnan' => "Breet (w) de Wert '%1' ass keng gëlteg ganz Zuel",
	'slippymap_zoomnan' => "Zoom (z) de Wert '%1' ass keng gëlteg ganz Zuel",
	'slippymap_widthbig' => 'Breet (w) de Wert kann net méi grouss si wéi 1000',
	'slippymap_widthsmall' => 'Breet (w) de Wert kann net méi kleng si wéi 100',
	'slippymap_heightbig' => 'Héicht (h) de Wert kann net méi grouss wéi 1000 sinn',
	'slippymap_heightsmall' => 'Héicht (h) de Wert kann net méi kleng wéi 100 sinn',
	'slippymap_zoomsmall' => 'Zoom (z) de Wert kann net méi kleng si wéi null',
	'slippymap_zoombig' => 'Zoom (z) de Wert kann net méi grouss si wéi 17.',
	'slippymap_maperror' => 'Kaartefeeler:',
	'slippymap_code' => 'Wikicode fir dës Kaart ze kucken:',
	'slippymap_button_code' => 'Wikicode weisen',
	'slippymap_resetview' => 'Zrécksetzen',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'slippymap_maperror' => 'Ahcuallōtl āmatohcopa',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'slippymap_desc' => 'Laat het gebruik van de tag <tt><nowiki>&lt;slippymap&gt;</nowiki></tt> toe om een OpenLayers-kaart weer te geven. Kaarten zijn van [http://openstreetmap.org openstreetmap.org]',
	'slippymap_latmissing' => 'De "lat"-waarde ontbreekt (voor de breedte).',
	'slippymap_lonmissing' => 'De "lon"-waarde ontbreekt (voor de lengte).',
	'slippymap_zoommissing' => 'De "z"-waarde ontbreekt (voor het zoomniveau).',
	'slippymap_longdepreciated' => 'Gebruik "lon" in plaats van "long" (parameter is hernoemd).',
	'slippymap_widthnan' => "De waarde '%1' voor de breedte (w) is geen geldige integer",
	'slippymap_heightnan' => "De waarde '%1' voor de hoogte (h) is geen geldige integer",
	'slippymap_zoomnan' => "De waarde '%1' voor de zoom (z) is geen geldige integer",
	'slippymap_latnan' => "De waarde '%1' voor de breedte (lat) is geen geldig nummer",
	'slippymap_lonnan' => "De waarde '%1' voor de lengte (lon) is geen geldig nummer",
	'slippymap_widthbig' => 'De breedte (w) kan niet groter dan 1000 zijn',
	'slippymap_widthsmall' => 'De breedte (w) kan niet kleiner dan 100 zijn',
	'slippymap_heightbig' => 'De hoogte (h) kan niet groter dan 1000 zijn',
	'slippymap_heightsmall' => 'De hoogte (h) kan niet kleiner dan 100 zijn',
	'slippymap_latbig' => 'De breedte (lat) kan niet groter dan -90 zijn',
	'slippymap_latsmall' => 'De breedte (lat) kan niet kleiner dan -90 zijn',
	'slippymap_lonbig' => 'De lengte (lon) kan niet groter dan 180 zijn',
	'slippymap_lonsmall' => 'De lengte (lon) kan niet kleiner dan -180 zijn',
	'slippymap_zoomsmall' => 'De zoom (z) kan niet minder dan nul zijn',
	'slippymap_zoom18' => 'De zoom (z) kan niet groter zijn dan 17. Merk op dat deze MediaWiki-uitbreiding de "Osmarender"-layer van OpenSteetMap gebruikt die niet dieper dan het niveau 17 gaat. de "Mapnik"-layer, beschikbaar op openstreetmap.org, gaat tot niveau 18.',
	'slippymap_zoombig' => 'De zoom (z) kan niet groter dan 17 zijn',
	'slippymap_invalidlayer' => 'Ongeldige waarde voor \'layer\' "%1"',
	'slippymap_maperror' => 'Kaartfout:',
	'slippymap_osmtext' => 'Deze kaart op OpenStreetMap.org bekijken',
	'slippymap_code' => 'Wikicode voor deze kaart:',
	'slippymap_button_code' => 'Wikicode',
	'slippymap_resetview' => 'Terug',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'slippymap_desc' => 'Tillét bruk av merket <tt>&lt;slippymap&gt;</tt> for å syna eit «slippy map» frå OpenLayers. Karti kjem frå [http://openstreetmap.org openstreetmap.org]',
	'slippymap_latmissing' => 'Manglar «lat»-verdi (for breiddegrad).',
	'slippymap_lonmissing' => 'Manglar «lon»-verdi (for lengdegrad).',
	'slippymap_zoommissing' => 'Manglar «z»-verdi (for zoom-nivået).',
	'slippymap_longdepreciated' => 'Nytt «lon» i staden for «long» (parameteren fekk nytt namn).',
	'slippymap_widthnan' => 'breiddeverdien («w») «%1» er ikkje eit gyldig heiltal',
	'slippymap_heightnan' => 'høgdeverdien («h») «%1» er ikkje eit gyldig heiltal',
	'slippymap_zoomnan' => 'zoomverdien («z») «%1» er ikkje eit gyldig heiltal',
	'slippymap_latnan' => 'breiddegradsverdien («lat») «%1» er ikkje eit gyldig tal',
	'slippymap_lonnan' => 'lengdegradsverdien («lon») «%1» er ikkje eit gyldig tal',
	'slippymap_widthbig' => 'breiddeverdien («w») kan ikkje vera større enn 1000',
	'slippymap_widthsmall' => 'breiddeverdien («w») kan ikkje vera mindre enn 100',
	'slippymap_heightbig' => 'høgdeverdien («h») kan ikkje vera større enn 1000',
	'slippymap_heightsmall' => 'høgdeverdien («h») kan ikkje vera mindre enn 100',
	'slippymap_latbig' => 'breiddegraden («lat») kan ikkje vera større enn 90',
	'slippymap_latsmall' => 'breiddegraden («lat») kan ikkje vera mindre enn -90',
	'slippymap_lonbig' => 'lengdegraden («lon») kan ikkje vera større enn 180',
	'slippymap_lonsmall' => 'lengdegraden («lon») kan ikkje vera mindre enn -180',
	'slippymap_zoomsmall' => 'zoomverdien («z») kan ikkje vera mindre enn null',
	'slippymap_zoom18' => 'zoomverdien («z») kan ikkje vera større enn 17. Merk at denne MediaWiki-utvidingi nyttar OpenStreetMap-laget «osmarender», som ikkje kan zooma meir enn til nivå 17. «Mapnik»-laget på openstreetmap.org går til zoomnivå 18',
	'slippymap_zoombig' => 'zoomverdien («z») kan ikkje vera større enn 17.',
	'slippymap_invalidlayer' => 'Ugyldig «layer»-verdi «%1»',
	'slippymap_maperror' => 'Kartfeil:',
	'slippymap_osmtext' => 'Sjå dette kartet på OpenStreetMap.org',
	'slippymap_code' => 'Wikikode for denne kartvisingi:',
	'slippymap_button_code' => 'Hent wikikode',
	'slippymap_resetview' => 'Attendestill vising',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'slippymap_desc' => 'Tillater bruk av taggen <tt>&lt;slippymap&gt;</tt> for å vise et «slippy map» fra OpenLayers. Kartene kommer fra [http://openstreetmap.org openstreetmap.org]',
	'slippymap_latmissing' => 'Mangler «lat»-verdi (for breddegraden).',
	'slippymap_lonmissing' => 'Mangler «lon»-verdi (for lengdegraden).',
	'slippymap_zoommissing' => 'Mangler «z»-verdi (for zoom-nivået).',
	'slippymap_longdepreciated' => 'Bruk «lon» i stedet for «long» (parameteret fikk nytt navn).',
	'slippymap_widthnan' => 'breddeverdien («w») «%1» er ikke et gyldig heltall',
	'slippymap_heightnan' => 'høydeverdien («h») «%1» er ikke et gyldig heltall',
	'slippymap_zoomnan' => 'zoomverdien («z») «%1» er ikke et gyldig heltall',
	'slippymap_latnan' => 'breddegradsverdien («lat») «%1» er ikke et gyldig tall',
	'slippymap_lonnan' => 'lengdegradsverdien («lon») «%1» er ikke et gyldig tall',
	'slippymap_widthbig' => 'breddeverdien («w») kan ikke være større enn 1000',
	'slippymap_widthsmall' => 'breddeverdien («w») kan ikke være mindre enn 100',
	'slippymap_heightbig' => 'høydeverdien («h») kan ikke være større enn 1000',
	'slippymap_heightsmall' => 'høydeverdien («h») kan ikke være mindre enn 100',
	'slippymap_latbig' => 'breddegradsverdien («lat») kan ikke være større enn 90',
	'slippymap_latsmall' => 'breddegradsverdien («lat») kan ikke være mindre enn –90',
	'slippymap_lonbig' => 'lengdegradsverdien («lon») kan ikke være større enn 180',
	'slippymap_lonsmall' => 'lengdegradsverdien («lon») kan ikke være mindre enn –180',
	'slippymap_zoomsmall' => 'zoomverdien («z») kan ikke være mindre enn null',
	'slippymap_zoom18' => 'zoomverdien («z») kan ikke være større enn 17. Merk at denne MediaWiki-utvidelsen bruker OpenStreetMap-laget «osmarender», som ikke kan zoome mer enn til nivå 17. «Mapnik»-laget på openstreetmap.org går til zoomnivå 18.',
	'slippymap_zoombig' => 'zoomverdien («z») kan ikke være større enn 17.',
	'slippymap_invalidlayer' => 'Ugyldig «layer»-verdi «%1»',
	'slippymap_maperror' => 'Kartfeil:',
	'slippymap_osmtext' => 'Se dette kartet på OpenStreetMap.org',
	'slippymap_code' => 'Wikikode for denne kartvisningen:',
	'slippymap_button_code' => 'Hent wikikode',
	'slippymap_resetview' => 'Tilbakestill visning',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'slippymap_desc' => 'Autoriza l’utilizacion de la balisa <tt><nowiki>&lt;slippymap&gt;</nowiki></tt> per afichar una mapa lisanta d’OpenLayers. Las mapas provenon de [http://openstreetmap.org openstreetmap.org]',
	'slippymap_latmissing' => 'Valor lat mancanta (per la latitud).',
	'slippymap_lonmissing' => 'Valor lon mancanta (per la longitud).',
	'slippymap_zoommissing' => 'Valor z mancanta (pel nivèl del zoom).',
	'slippymap_longdepreciated' => 'Utilizatz « lon » al luòc de « long » (lo paramètre es estat renomenat).',
	'slippymap_widthnan' => "La largor (w) qu'a per valor « %1 » es pas un nombre entièr corrèct.",
	'slippymap_heightnan' => "La nautor (h) qu'a per valor « %1 » es pas un nombre entièr corrèct.",
	'slippymap_zoomnan' => "Lo zoom (z) qu'a per valor « %1 » es pas un nombre entièr corrèct.",
	'slippymap_latnan' => "La latitud (lat) qu'a per valor « %1 » es pas un nombre corrèct.",
	'slippymap_lonnan' => "La longitud (lon) qu'a per valor « %1 » es pas un nombre corrèct.",
	'slippymap_widthbig' => 'La valor de la largor (w) pòt pas excedir 1000',
	'slippymap_widthsmall' => 'La valor de la largor (w) pòt pas èsser inferiora a 100',
	'slippymap_heightbig' => 'La valor de la nautor (h) pòt pas excedir 1000',
	'slippymap_heightsmall' => 'La valor de la nautor (h) pòt pas èsser inferiora a 100',
	'slippymap_latbig' => 'La valor de la latitud (lat) pòt pas excedir 90',
	'slippymap_latsmall' => 'La valor de la latitud (lat) pòt pas èsser inferiora a -90',
	'slippymap_lonbig' => 'La valor de la longitud (lon) pòt pas excedir 180',
	'slippymap_lonsmall' => 'La valor de la longitud (lon) pòt pas èsser inferiora a -180',
	'slippymap_zoomsmall' => 'La valor del zoom (z) pòt pas èsser negativa',
	'slippymap_zoom18' => "La valor del zoom (z) pòt excedir 17. Notatz qu'aqueste croquet d’extension MediaWiki dins lo jaç « osmarender » de OpenStreetMap pòt pas anar de delà del nivèl 17 del zoom. Lo jaç Mapnik disponible sus openstreetmap.org, pòt pas anar de delà del nivèl 18.",
	'slippymap_zoombig' => 'La valor del zoom (z) pòt pas excedir 17.',
	'slippymap_invalidlayer' => 'Valor de « %1 » del « jaç » incorrècta',
	'slippymap_maperror' => 'Error de mapa :',
	'slippymap_osmtext' => 'Vejatz aquesta mapa sus OpenStreetMap.org',
	'slippymap_code' => "Còde Wiki pel visionament d'aquesta mapa :",
	'slippymap_button_code' => 'Obténer lo còde wiki',
	'slippymap_resetview' => 'Tornar inicializar lo visionament',
);

/** Polish (Polski)
 * @author Maikking
 */
$messages['pl'] = array(
	'slippymap_maperror' => 'Błąd mapy:',
);

/** Portuguese (Português)
 * @author Lijealso
 * @author Malafaya
 */
$messages['pt'] = array(
	'slippymap_latmissing' => 'Faltando o valor lat (para a latitude).',
	'slippymap_lonmissing' => 'Faltando o valor lon (para a longitude).',
	'slippymap_zoommissing' => 'Falta valor z (para o nível de zoom).',
	'slippymap_zoombig' => 'O valor de zoom (z) não pode ser maior que 17.',
	'slippymap_maperror' => 'Erro no mapa:',
	'slippymap_resetview' => 'Repor vista',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'slippymap_latmissing' => 'Valoarea lat lipsă (pentru latitudine).',
	'slippymap_lonmissing' => 'Valoarea lon lipsă (pentru longitudine).',
);

/** Russian (Русский)
 * @author Ferrer
 */
$messages['ru'] = array(
	'slippymap_maperror' => 'Ошибка карты:',
	'slippymap_button_code' => 'Получить викикод',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'slippymap_desc' => 'Umožňuje použitie značky <tt><nowiki>&lt;slippymap&gt;</nowiki></tt> na zobrazenie posuvnej mapy OpenLayers. Mapy sú z [http://openstreetmap.org openstreetmap.org]',
	'slippymap_latmissing' => 'Chýba hodnota lat (rovnobežka).',
	'slippymap_lonmissing' => 'Chýba hodnota lon (poludník).',
	'slippymap_zoommissing' => 'Chýba hodnota z (úroveň priblíženia)',
	'slippymap_longdepreciated' => 'Prosím, použite „lon” namiesto „long” (názov parametra sa zmenil).',
	'slippymap_widthnan' => 'hodnota šírky (w) „%1” nie je platné celé číslo',
	'slippymap_heightnan' => 'hodnota výšky (h) „%1” nie je platné celé číslo',
	'slippymap_zoomnan' => 'hodnota úrovne priblíženia (z) „%1” nie je platné celé číslo',
	'slippymap_latnan' => 'hodnota zemepisnej šírky (lat) „%1” nie je platné celé číslo',
	'slippymap_lonnan' => 'hodnota zemepisnej dĺžky (lon) „%1” nie je platné celé číslo',
	'slippymap_widthbig' => 'hodnota šírky (w) nemôže byť väčšia ako 1000',
	'slippymap_widthsmall' => 'hodnota šírky (w) nemôže byť menšia ako 100',
	'slippymap_heightbig' => 'hodnota výšky (h) nemôže byť väčšia ako 1000',
	'slippymap_heightsmall' => 'hodnota výšky (h) nemôže byť menšia ako 100',
	'slippymap_latbig' => 'hodnota zemepisnej dĺžky (h) nemôže byť väčšia ako 90',
	'slippymap_latsmall' => 'hodnota zemepisnej dĺžky (h) nemôže byť menšia ako -90',
	'slippymap_lonbig' => 'hodnota zemepisnej šírky (lon) nemôže byť väčšia ako 180',
	'slippymap_lonsmall' => 'hodnota zemepisnej dĺžky (lon) nemôže byť menšia ako -180',
	'slippymap_zoomsmall' => 'hodnota úrovne priblíženia (lon) nemôže byť menšia ako nula',
	'slippymap_zoom18' => 'hodnota úrovne priblíženia (lon) nemôže byť väčšia ako 17. Toto rozšírenie MediaWiki využíva vrstvu „osmarender” OpenStreetMap, ktorá umožňuje úroveň priblíženia po 17. Vrstva Mapnik na openstreetmap.org umožňuje priblíženie do úrovne 18.',
	'slippymap_zoombig' => 'hodnota úrovne priblíženia (lon) nemôže byť väčšia ako 17.',
	'slippymap_invalidlayer' => 'Neplatná hodnota „layer” „%1”',
	'slippymap_maperror' => 'Chyba mapy:',
	'slippymap_osmtext' => 'Pozrite si túto mapu na OpenStreetMap.org',
	'slippymap_code' => 'Wikikód tohto pohľadu na mapu:',
	'slippymap_button_code' => 'Zobraziť zdrojový kód',
	'slippymap_resetview' => 'Obnoviť zobrazenie',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author M.M.S.
 */
$messages['sv'] = array(
	'slippymap_desc' => 'Tillåter användning av taggen <tt>&lt;slippymap&gt;</tt> för att visa "slippy map" från OpenLayers. Kartorna kommer från [http://openstreetmap.org openstreetmap.org]',
	'slippymap_latmissing' => 'Saknat "lat"-värde (för breddgraden).',
	'slippymap_lonmissing' => 'Saknat "lon"-värde (för längdgraden).',
	'slippymap_zoommissing' => 'Saknat z-värde (för zoom-nivån).',
	'slippymap_longdepreciated' => 'Var god använd "lon"  istället för "long" (parametern fick ett nytt namn).',
	'slippymap_widthnan' => 'breddvärdet (w) "%1" är inte ett giltigt heltal',
	'slippymap_heightnan' => 'höjdvärdet (h) "%1" är inte ett giltigt heltal',
	'slippymap_zoomnan' => 'zoomvärdet (z) "%1" är inte ett giltigt heltal',
	'slippymap_latnan' => 'breddgradsvärdet (lat) "%1" är inte ett giltigt nummer',
	'slippymap_lonnan' => 'längdgradsvärdet (lon) "%1" är inte ett giltigt nummer',
	'slippymap_widthbig' => 'breddvärdet (w) kan inte vara större än 1000',
	'slippymap_widthsmall' => 'breddvärdet (w) kan inte vara mindre än 100',
	'slippymap_heightbig' => 'höjdvärdet (h) kan inte vara större än 1000',
	'slippymap_heightsmall' => 'höjdvärdet (h) kan inte vara mindre än 100',
	'slippymap_latbig' => 'breddgradsvärdet (lat) kan inte vara större än 90',
	'slippymap_latsmall' => 'breddgradsvärdet (lat) kan inte vara mindre än -90',
	'slippymap_lonbig' => 'längdgradsvärdet (lon) kan inte vara större än 180',
	'slippymap_lonsmall' => 'längdgradsvärdet (lon) kan inte vara mindre än -180',
	'slippymap_zoomsmall' => 'zoomvärdet (z) kan inte vara mindre än noll',
	'slippymap_zoom18' => "zoomvärdet (z) kan inte vara högre än 17. Observera att detta programtillägg använder OpenStreetMap-lagret 'osmarender', som inte kan zoomas mer än till nivå 17. Mapnik-lagret på openstreetmap.org zoomar till nivå 18",
	'slippymap_zoombig' => 'zoomvärdet (z) kan inte vara högre än 17.',
	'slippymap_invalidlayer' => "Ogiltigt 'layer'-värde '%1'",
	'slippymap_maperror' => 'Kartfel:',
	'slippymap_osmtext' => 'Se den här kartan på OpenStreetMap.org',
	'slippymap_code' => 'Wikikod för denna kartvisning:',
	'slippymap_button_code' => 'Hämta wikikod',
	'slippymap_resetview' => 'Återställ visning',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'slippymap_maperror' => 'పటపు పొరపాటు:',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'slippymap_desc' => "Nagpapahintulot sa paggamit ng tatak na <tt><nowiki>&lt;slippymap&gt;</nowiki></tt> upang maipakita/mapalitaw ang isang pampuwesto/pangkinaroroonang (''slippy'') mapa ng OpenLayers.  Nanggaling ang mga mapa mula sa [http://openstreetmap.org openstreetmap.org]",
	'slippymap_latmissing' => 'Nawawalang halaga para sa latitud (lat).',
	'slippymap_lonmissing' => 'Nawawalang halaga para sa longhitud (lon).',
	'slippymap_zoommissing' => "Nawawalang halagang 't' (mula sa 'tutok') para sa antas ng paglapit/pagtutok (''zoom'').",
	'slippymap_longdepreciated' => "Pakigamit lamang ang 'lon' sa halip na 'long' (muling pinangalanan ang parametro).",
	'slippymap_widthnan' => "ang halaga ng lapad (l) na '%1' ay hindi isang tanggap na buumbilang (''integer'')",
	'slippymap_heightnan' => "ang halaga ng taas (t) na '%1' ay hindi isang tanggap na buumbilang (''integer'')",
	'slippymap_zoomnan' => "ang halaga ng pagtutok/paglapit ('t' mula sa 'tutok' o ''zoom'') na '%1' ay hindi isang tanggap na buumbilang (''integer'')",
	'slippymap_latnan' => "ang halaga ng latitud (lat) na '%1' ay hindi isang tanggap na buumbilang (''integer'')",
	'slippymap_lonnan' => "ang halaga ng longhitud (lon) na '%1' ay hindi isang tanggap na buumbilang (''integer'')",
	'slippymap_widthbig' => 'hindi maaaring humigit/lumabis kaysa 1000 ang halaga ng lapad (l)',
	'slippymap_widthsmall' => 'hindi maaaring bumaba kaysa 1000 ang halaga ng lapad (l)',
	'slippymap_heightbig' => 'hindi maaaring humigit/lumabis kaysa 1000 ang halaga ng taas (t)',
	'slippymap_heightsmall' => 'hindi maaaring bumaba kaysa 1000 ang halaga ng taas (t)',
	'slippymap_latbig' => 'hindi maaaring humigit/lumabis kaysa 90 ang halaga ng latitud (lat)',
	'slippymap_latsmall' => 'hindi maaaring bumaba kaysa -90 ang halaga ng latitud (lat)',
	'slippymap_lonbig' => 'hindi maaaring humigit/lumabis kaysa 180 ang halaga ng longhitud (lon)',
	'slippymap_lonsmall' => 'hindi maaaring bumaba kaysa -180 ang halaga ng longhitud (lon)',
	'slippymap_zoomsmall' => "hindi maaaring bumaba kaysa wala/sero ang halaga ng pagtutok/paglapit ('t' mula sa 'tutok') o ''zoom''.",
	'slippymap_zoom18' => "hindi maaaring humigit/lumabis kaysa 17 ang halaga ng pagtutok/paglapit ('t' mula sa 'tutok') o ''zoom''.  Tandaan lamang na ang mga karugtong na ito na pang-Mediawiki ay kumakawing/kumakabit patungo sa sapin/patong na 'osmarender' ng OpenStreetMap na hindi lumalagpas mula sa kaantasan ng pagkakatutok na 17.  Ang sapin/patong na Mapnik na makukuha mula sa openstreetmap.org ay umaabot pataas sa kaantasan ng pagkakatutok na 18",
	'slippymap_zoombig' => "hindi maaaring humigit/lumabis kaysa 17 ang halaga ng pagtutok/paglapit ('t' mula sa 'tutok') o ''zoom''.",
	'slippymap_invalidlayer' => "Hindi tanggap ang halaga ng 'patong' o 'sapin' na '%1'",
	'slippymap_maperror' => 'Kamalian sa mapa:',
	'slippymap_osmtext' => 'Tingnan ang mapang ito sa OpenStreetMap.org',
	'slippymap_code' => 'Kodigo ng wiki ("wiki-kodigo") para sa tanawin ng mapang ito:',
	'slippymap_button_code' => 'Kuhanin ang kodigo ng wiki',
	'slippymap_resetview' => 'Muling itakda ang tanawin',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'slippymap_desc' => 'Thêm thẻ <tt><nowiki>&lt;slippymap&gt;</nowiki></tt> để nhúng bản đồ trơn OpenLayers. Các bản đồ do [http://openstreetmap.org openstreetmap.org] cung cấp.',
	'slippymap_latmissing' => 'Thiếu giá trị lat (vĩ độ).',
	'slippymap_lonmissing' => 'Thiếu giá trị lon (kinh độ).',
	'slippymap_zoommissing' => 'Thiếu giá trị z (cấp thu phóng).',
	'slippymap_longdepreciated' => 'Xin hãy dùng “lon” thay vì “long” (tham số đã được đổi tên).',
	'slippymap_widthnan' => 'giá trị chiều rộng (w), “%1”, không phải là nguyên số hợp lệ',
	'slippymap_heightnan' => 'giá trị chiều cao (h), “%1”, không phải là nguyên số hợp lệ',
	'slippymap_zoomnan' => 'giá trị cấp thu phóng (z), “%1”, không phải là nguyên số hợp lệ',
	'slippymap_latnan' => 'giá trị vĩ độ (lat), “%1”, không phải là số hợp lệ',
	'slippymap_lonnan' => 'giá trị kinh độ (lon), “%1”, không phải là số hợp lệ',
	'slippymap_widthbig' => 'giá trị chiều rộng (w) tối đa là “1000”',
	'slippymap_widthsmall' => 'giá trị chiều rộng (w) tối thiểu là “100”',
	'slippymap_heightbig' => 'giá trị chiều cao (h) tối đa là “1000”',
	'slippymap_heightsmall' => 'giá trị chiều cao (h) tối thiểu là “100”',
	'slippymap_latbig' => 'giá trị vĩ độ (lat) tối đa là “90”',
	'slippymap_latsmall' => 'giá trị vĩ độ (lat) tối thiểu là “-90”',
	'slippymap_lonbig' => 'giá trị kinh độ (lon) tối đa là “180”',
	'slippymap_lonsmall' => 'giá trị kinh độ (lon) tối thiểu là “-180”',
	'slippymap_zoomsmall' => 'giá trị cấp thu phóng tối thiểu là “0”',
	'slippymap_zoom18' => 'giá trị cấp thu phóng (z) tối đa là 17. Lưu ý rằng phần mở rộng MediaWiki này dựa trên lớp “osmarender” của OpenStreetMap, nó không vẽ rõ hơn cấp 17. Lớp Mapnik tại openstreetmap.org tới được cấp 18.',
	'slippymap_zoombig' => 'giá trị cấp thu phóng (z) tối đa là 17.',
	'slippymap_invalidlayer' => 'Giá trị “layer” không hợp lệ: “%1”.',
	'slippymap_maperror' => 'Lỗi trong bản đồ:',
	'slippymap_osmtext' => 'Xem bản đồ này tại OpenStreetMap.org',
	'slippymap_code' => 'Mã wiki để nhúng phần bản đồ này:',
	'slippymap_button_code' => 'Xem mã wiki',
	'slippymap_resetview' => 'Mặc định lại bản đồ',
);

/** Volapük (Volapük)
 * @author Smeira
 */
$messages['vo'] = array(
	'slippymap_maperror' => 'Mapapöl:',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 */
$messages['zh-hans'] = array(
	'slippymap_widthbig' => '宽度值（w）不能大于1000',
	'slippymap_widthsmall' => '宽度值（w）不能小于100',
	'slippymap_heightbig' => '高度值（h）不能大于1000',
	'slippymap_heightsmall' => '高度值（h）不能小于100',
	'slippymap_latbig' => '纬度值（lat）不能大于90',
	'slippymap_latsmall' => '纬度值（lat）不能小于-90',
	'slippymap_lonbig' => '经度值（lon）不能大于180',
	'slippymap_lonsmall' => '经度值（lon）不能小于-180',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Gzdavidwong
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'slippymap_widthbig' => '寬度值(w)不能大於1000',
	'slippymap_widthsmall' => '寬度值(w)不能小於100',
	'slippymap_heightbig' => '高度值(h)不能大於1000',
	'slippymap_heightsmall' => '高度值(h)不能少於100',
	'slippymap_latbig' => '緯度值(lat)不能大於90',
	'slippymap_latsmall' => '緯度值(lat)不能小於-90',
	'slippymap_lonbig' => '經度值(lon)不能大於180',
	'slippymap_lonsmall' => '經度值(lon)不能小於-180',
);

