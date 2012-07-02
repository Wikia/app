<?php
/**
 * Internationalisation for Drafts extension
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Trevor Parscal
 */
$messages['en'] = array(
	'drafts' => 'Drafts',
	'drafts-desc' => 'Adds the ability to save [[Special:Drafts|draft]] versions of a page on the server',
	'drafts-view' => 'ViewDraft',
	'drafts-view-summary' => 'This special page shows a list of all existing drafts.
Unused drafts will be discarded after {{PLURAL:$1|$1 day|$1 days}} automatically.',
	'drafts-view-article' => 'Page',
	'drafts-view-existing' => 'Existing drafts',
	'drafts-view-saved' => 'Saved',
	'drafts-view-discard' => 'Discard',
	'drafts-view-nonesaved' => 'You do not have any drafts saved at this time.',
	'drafts-view-notice' => 'You have $1 for this page.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|draft|drafts}}',
	'drafts-view-warn' => 'By navigating away from this page you will lose all unsaved changes to this page.
Do you want to continue?',
	'drafts-save' => 'Save this as a draft',
	'drafts-save-save' => 'Save draft',
	'drafts-save-saved' => 'Saved',
	'drafts-save-saving' => 'Saving',
	'drafts-save-error' => 'Error saving draft',
	'tooltip-drafts-save' => 'Save as a draft',
	'accesskey-drafts-save' => 'g', # do not translate or duplicate this message to other languages
);

/** Message documentation (Message documentation)
 * @author Darth Kule
 * @author Dead3y3
 * @author EugeneZelenko
 * @author The Evil IP address
 */
$messages['qqq'] = array(
	'drafts' => 'Title of Special:Drafts',
	'drafts-desc' => '{{desc}}',
	'drafts-view-summary' => 'Used in [[Special:Drafts]] when there is at least one draft saved.',
	'drafts-view-article' => 'Name of column in Special:Drafts, when there are draft versions saved.

{{Identical|Page}}',
	'drafts-view-existing' => 'Shown at the top while editing a page with draft versions saved',
	'drafts-view-saved' => 'Name of column in Special:Drafts, when there are draft versions saved.
{{Identical|Saved}}',
	'drafts-view-discard' => 'Name of button to delete draft version of a page',
	'drafts-view-nonesaved' => 'Displayed in Special:Drafts when there are no draft versions saved',
	'drafts-view-notice' => "Shown at the top while previewing a page with draft versions saved. ''$1'' is {{msg-mw|Drafts-view-notice-link}} message",
	'drafts-view-notice-link' => "Used in {{msg-mw|Drafts-view-notice}}. ''$1'' is the number of draft versions saved for the page
{{Identical|Draft}}",
	'drafts-save' => 'Tooltip of {{msg-mw|Drafts-save-save}} button',
	'drafts-save-save' => 'Button shown near "Show changes" under editing form of a page
{{Identical|Save draft}}',
	'drafts-save-saved' => 'Message indicating that the draft has been saved.
{{Identical|Saved}}',
	'drafts-save-saving' => 'Message indicating that the draft is in the process of being saved.',
);

/** Magyar (magázó) (Magyar (magázó))
 * @author Dani
 */
$messages['hu-formal'] = array(
	'drafts-view-nonesaved' => 'Jelenleg nincs egyetlen elmentett piszkozata sem.',
	'drafts-view-notice-link' => '{{PLURAL:$1|egy|$1}} piszkozata',
	'drafts-view-warn' => 'Ha elmegy az oldalról, az összes mentetlen változtatás elvész.
Biztosan folytatja?',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'drafts' => 'Werkweergawes',
	'drafts-view' => 'WysWerkweergawe',
	'drafts-view-article' => 'Bladsy',
	'drafts-view-saved' => 'Gestoor',
	'drafts-view-discard' => 'Verwyder',
	'drafts-view-notice' => 'U het $1 vir hierdie bladsy.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|werkweergawe|werkweergawes}}',
	'drafts-save' => "Stoor dit as 'n werkweergawe",
	'drafts-save-save' => 'Stoor as kladwerk',
	'drafts-save-saved' => 'Gestoor',
	'drafts-save-saving' => 'Besig om te stoor',
	'drafts-save-error' => 'Fout tydens stoor van werkweergawe',
	'tooltip-drafts-save' => 'As werkweergawe stoor',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'drafts-view-article' => 'Pachina',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'drafts' => 'مسودات',
	'drafts-desc' => 'يضيف القدرة على حفظ نسخ [[Special:Drafts|مسودة]] لصفحة على الخادم',
	'drafts-view' => 'عرض المسودة',
	'drafts-view-summary' => 'هذه الصفحة الخاصة تعرض قائمة بكل المسودات الموجودة.
المسودات غير المستخدمة سيتم التغاضي عنها بعد {{PLURAL:$1|$1 يوم|$1 يوم}} تلقائيا.',
	'drafts-view-article' => 'الصفحة',
	'drafts-view-existing' => 'المسودات الموجودة',
	'drafts-view-saved' => 'محفوظة',
	'drafts-view-discard' => 'تجاهل',
	'drafts-view-nonesaved' => 'أنت ليس لديك أي مسودات محفوظة في هذا الوقت.',
	'drafts-view-notice' => 'أنت لديك $1 لهذه الصفحة.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|مسودة|مسودة}}',
	'drafts-view-warn' => 'بواسطة الإبحار عن هذه الصفحة ستفقد كل التغييرات غير المحفوظة لهذه الصفحة.
هل تريد الاستمرار؟',
	'drafts-save' => 'يحفظ هذه كمسودة',
	'drafts-save-save' => 'احفظ المسودة',
	'drafts-save-saved' => 'محفوظة',
	'drafts-save-saving' => 'حفظ',
	'drafts-save-error' => 'خطأ أثناء حفظ المسودة',
	'tooltip-drafts-save' => 'حفظ كمسودة',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'drafts-view-article' => 'ܕܦܐ',
	'drafts-view-saved' => 'ܠܒܟܬ',
	'drafts-save-saved' => 'ܠܒܟܬ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'drafts' => 'مسودات',
	'drafts-desc' => 'يضيف القدرة على حفظ نسخ [[Special:Drafts|مسودة]] لصفحة على الخادم',
	'drafts-view' => 'عرض المسودة',
	'drafts-view-summary' => 'هذه الصفحة الخاصة تعرض قائمة بكل المسودات الموجودة.
المسودات غير المستخدمة سيتم التغاضى عنها بعد {{PLURAL:$1|$1 يوم|$1 يوم}} تلقائيا.',
	'drafts-view-article' => 'الصفحة',
	'drafts-view-existing' => 'المسودات الموجودة',
	'drafts-view-saved' => 'محفوظة',
	'drafts-view-discard' => 'تجاهل',
	'drafts-view-nonesaved' => 'أنت ليس لديك أى مسودات محفوظة فى هذا الوقت.',
	'drafts-view-notice' => 'أنت لديك $1 لهذه الصفحة.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|مسودة|مسودة}}',
	'drafts-view-warn' => 'بواسطة الإبحار عن هذه الصفحة ستفقد كل التغييرات غير المحفوظة لهذه الصفحة.
هل تريد الاستمرار؟',
	'drafts-save' => 'حفظ هذه كمسودة',
	'drafts-save-save' => 'حفظ المسودة',
	'drafts-save-saved' => 'محفوظة',
	'drafts-save-saving' => 'تسييف',
	'drafts-save-error' => 'خطأ أثناء حفظ المسودة',
	'tooltip-drafts-save' => 'حفظ كمسودة',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 * @author Vago
 */
$messages['az'] = array(
	'drafts-view-article' => 'Səhifə',
	'drafts-view-saved' => 'Yaddaşa verildi',
	'drafts-save-saved' => 'Yaddaşa verildi',
);

/** Bashkir (Башҡортса)
 * @author Assele
 */
$messages['ba'] = array(
	'drafts' => 'Ҡараламалар',
	'drafts-desc' => 'Серверҙа биттәрҙең [[Special:Drafts|ҡараламаһын]] һаҡлау мөмкинлеген өҫтәй',
	'drafts-view' => 'ҠараламаҠарау',
	'drafts-view-summary' => 'Был махсус бит бөтә булған ҡараламаларҙы күрһәтә.
Ҡулланылмаған ҡараламалар {{PLURAL:$1|$1 көндән}} үҙенән-үҙе юйыла.',
	'drafts-view-article' => 'Бит',
	'drafts-view-existing' => 'Булған ҡараламалар',
	'drafts-view-saved' => 'Һаҡланған',
	'drafts-view-discard' => 'Кире алырға',
	'drafts-view-nonesaved' => 'Әлеге выҡытта һеҙҙең бер ҡараламағыҙ ҙа юҡ.',
	'drafts-view-notice' => 'Һеҙҙең был бит өсөн $1 бар.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|ҡаралама}}',
	'drafts-view-warn' => 'Был биттән китһәгеҙ, һеҙ биттәге бөтә һаҡланмаған үҙгәртеүҙәрҙе юғалтасаҡһығыҙ.
Дауам итергә теләйһегеҙме?',
	'drafts-save' => 'Ҡаралама рәүешендә һаҡларға',
	'drafts-save-save' => 'Ҡараламаны һаҡларға',
	'drafts-save-saved' => 'Һаҡланған',
	'drafts-save-saving' => 'Һаҡлау',
	'drafts-save-error' => 'Ҡараламаны һаҡлау хатаһы',
	'tooltip-drafts-save' => 'Ҡаралама рәүешендә һаҡларға',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'drafts' => 'Чарнавікі',
	'drafts-desc' => 'Дадае магчымасьць запісу [[Special:Drafts|чарнавіка]] старонкі на сэрвэры',
	'drafts-view' => 'Прагляд чарнавіка',
	'drafts-view-summary' => 'Гэтая спэцыяльная старонка паказвае сьпіс усіх існуючых чарнавікоў.
Чарнавікі, якія не выкарыстоўваюцца, будуць аўтаматычна выдаляцца праз {{PLURAL:$1|дзень|дні|дзён}}.',
	'drafts-view-article' => 'Старонка',
	'drafts-view-existing' => 'Існуючыя чарнавікі',
	'drafts-view-saved' => 'Захаваны',
	'drafts-view-discard' => 'Выдаліць',
	'drafts-view-nonesaved' => 'Цяпер у Вас няма захаваных чарнавікоў.',
	'drafts-view-notice' => 'Вы маеце $1 для гэтай старонкі.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|чарнавік|чарнавікі|чарнавікоў}}',
	'drafts-view-warn' => 'Закрыцьцё гэтай старонкі прывядзе да страты ўсіх незахаваных зьменаў.
Вы жадаеце працягваць?',
	'drafts-save' => 'Захаваць гэта як чарнавік',
	'drafts-save-save' => 'Захаваць чарнавік',
	'drafts-save-saved' => 'Захаваны',
	'drafts-save-saving' => 'Захаваньне',
	'drafts-save-error' => 'Памылка захаваньня чарнавіка',
	'tooltip-drafts-save' => 'Захаваць як чарнавік',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Turin
 */
$messages['bg'] = array(
	'drafts' => 'Чернови',
	'drafts-desc' => 'Добавя възможност за съхраняване на [[Special:Drafts|чернови]] на страниците',
	'drafts-view' => 'ПрегледНаЧернова',
	'drafts-view-article' => 'Страница',
	'drafts-view-existing' => 'Налични чернови',
	'drafts-view-saved' => 'Запазено',
	'drafts-view-discard' => 'Отхвърляне',
	'drafts-view-nonesaved' => 'Все още нямате съхранени чернови.',
	'drafts-view-notice' => 'Имате $1 за тази страница.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|чернова|чернови}}',
	'drafts-save' => 'Съхраняване на съдържанието като чернова',
	'drafts-save-save' => 'Съхраняване като чернова',
	'drafts-save-saved' => 'Запазено',
	'drafts-save-saving' => 'Запазване',
	'drafts-save-error' => 'Възникна грешка при съхраняване на черновата',
	'tooltip-drafts-save' => 'Съхраняване като чернова',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'drafts' => 'খসড়া',
	'drafts-view' => 'খসড়া দেখো',
	'drafts-view-article' => 'পাতা',
	'drafts-view-existing' => 'বর্তমানে রয়েছে এমন খসড়াসমূহ',
	'drafts-view-saved' => 'সংরক্ষিত',
	'drafts-view-discard' => 'বাতিল',
	'drafts-view-nonesaved' => 'আপনার বর্তমানে সংরক্ষিত কোনো খসড়া নেই।',
	'drafts-view-notice' => 'এই পাতার জন্য আপনার $1টি রয়েছে।',
	'drafts-view-notice-link' => '$1টি {{PLURAL:$1|খসড়া|খসড়া}}',
	'drafts-save' => 'খসড়া হিসেবে সংরক্ষণ করো',
	'drafts-save-save' => 'খসড়া সংরক্ষণ',
	'drafts-save-saved' => 'সংরক্ষিত',
	'drafts-save-saving' => 'সংরক্ষণ করা হচ্ছে',
	'drafts-save-error' => 'ড্রাফট সংরক্ষণে ত্রুটি',
	'tooltip-drafts-save' => 'খসড়া হিসেবে সংরক্ষণ করো',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'drafts' => 'Brouilhedoù',
	'drafts-desc' => 'Aotreañ a ra da enrollañ ur stumm [[Special:Drafts|brouilhed]] eus ur bajenn war ar servijer',
	'drafts-view' => 'Gwelet ar brouilhed',
	'drafts-view-summary' => 'Ar bajenn ispisial-mañ a zo ur roll eus an holl brouilhedoù a zo.
Ar brouilhedoù nann-implijet a vo distaolet emgefre goude $1 devez{{PLURAL:$1||}}.',
	'drafts-view-article' => 'Pajenn',
	'drafts-view-existing' => 'Brouilhedoù zo anezho dija',
	'drafts-view-saved' => 'Enrollet',
	'drafts-view-discard' => 'Disteurel',
	'drafts-view-nonesaved' => "N'hoc'h eus tamm brouilhoñs ebet enrollet er mare-mañ.",
	'drafts-view-notice' => '$1 ho peus evit ar bajenn-mañ.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|brouilhed|brouilhed}}',
	'drafts-view-warn' => "Ma'z it da verdeiñ er maez eus ar bajenn-mañ e kollot an holl gemmoù dienroll degaset d'ar bajenn-mañ.
Ha kenderc'hel a fell deoc'h ober ?",
	'drafts-save' => 'Enrollañ an dra-mañ evel brouilhed',
	'drafts-save-save' => 'Enrollañ ar brouilhed',
	'drafts-save-saved' => 'Enrollet',
	'drafts-save-saving' => "Oc'h enrollañ",
	'drafts-save-error' => 'Fazi enrollañ ar brouilhed',
	'tooltip-drafts-save' => 'Enrollañ evel brouilhed',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'drafts' => 'Skice',
	'drafts-desc' => 'Dodaje mogućnost spremanja [[Special:Drafts|draft]] verzija stranice na server',
	'drafts-view' => 'Pogledaj skicu',
	'drafts-view-summary' => 'Ova posebna stranica prikazuje spisak svih postojećih nacrta.
Nekorišteni nacrti će biti uklonjeni odavde automatski nakon {{PLURAL:$1|$1 dan|$1 dana|$1 dana}}.',
	'drafts-view-article' => 'Stranica',
	'drafts-view-existing' => 'Postojeće skice',
	'drafts-view-saved' => 'Spremljeno',
	'drafts-view-discard' => 'Odustani',
	'drafts-view-nonesaved' => 'Trenutno nemate spremljen nijedan draft.',
	'drafts-view-notice' => 'Imate $1 za ovu stranicu.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|skicu|skice|skica}}',
	'drafts-view-warn' => 'Ako napustite ovu stranicu izgubit ćete sve nespremljene izmjene na stranici.
Da li želite da nastavite?',
	'drafts-save' => 'Spremi ovo kao skicu',
	'drafts-save-save' => 'Sačuvaj skicu',
	'drafts-save-saved' => 'Spremljeno',
	'drafts-save-saving' => 'spremam',
	'drafts-save-error' => 'Greška pri spremanju skice',
	'tooltip-drafts-save' => 'Spremi kao skicu',
);

/** Catalan (Català)
 * @author Aleator
 * @author SMP
 * @author Solde
 */
$messages['ca'] = array(
	'drafts' => 'Esborranys',
	'drafts-desc' => "Afegeix la capacitat de desar versions d'[[Special:Drafts|esborrany]] d'una pàgina al servidor",
	'drafts-view' => 'Veure esborrany',
	'drafts-view-summary' => 'Aquesta pàgina especial mostra una llista de tots els esborranys existents.
Els esborranys sense utilitzar seran descartats automàticament als {{PLURAL:$1|$1 dia|$1 dies}}.',
	'drafts-view-article' => 'Pàgina',
	'drafts-view-existing' => 'Esborranys existents',
	'drafts-view-saved' => 'Desat a',
	'drafts-view-discard' => 'Descarta',
	'drafts-view-nonesaved' => 'En aquests moments no teniu cap esborrany desat.',
	'drafts-view-notice' => 'Teniu $1 per aquesta pàgina.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|esborrany|esborranys}}',
	'drafts-view-warn' => "Si sortiu d'aquesta pàgina perdreu tots els canvis no desats de la mateixa.
Voleu continuar?",
	'drafts-save' => 'Desar-ho com un esborrany',
	'drafts-save-save' => 'Desa un esborrany',
	'drafts-save-saved' => 'Desat',
	'drafts-save-saving' => 'Desant',
	'drafts-save-error' => 'Error en desar esborrany',
	'tooltip-drafts-save' => 'Desar com a esborrany',
);

/** Czech (Česky)
 * @author Danny B.
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'drafts' => 'Koncepty',
	'drafts-desc' => 'Přidává možnost uložit na server verzi stránky jako [[Special:Drafts|koncept]]',
	'drafts-view' => 'Zobrazit koncept',
	'drafts-view-summary' => 'Tato speciální stránka zobrazuje seznam všech existujících konceptů.
Nepoužité koncepty budou po {{plural:$1|$1 dni|$1 dnech}} automaticky smazány.',
	'drafts-view-article' => 'Stránka',
	'drafts-view-existing' => 'Existující koncepty',
	'drafts-view-saved' => 'Uložené',
	'drafts-view-discard' => 'Smazat',
	'drafts-view-nonesaved' => 'Momentálně nemáte uloženy žádné koncepty.',
	'drafts-view-notice' => 'Máte $1 této stránky',
	'drafts-view-notice-link' => '$1 {{plural:$1|koncept|koncepty|konceptů}}',
	'drafts-view-warn' => 'Pokud odejdete z této stránky, ztratíte všechny neuložené změny této stránky. Chcete pokračovat?',
	'drafts-save' => 'Uložit tuto verzi jako koncept',
	'drafts-save-save' => 'Uložit koncept',
	'drafts-save-saved' => 'Uložené',
	'drafts-save-saving' => 'Ukládá se',
	'drafts-save-error' => 'Chyba při ukládání konceptu',
	'tooltip-drafts-save' => 'Uložit jako koncept',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author Kghbln
 * @author Metalhead64
 * @author Pill
 * @author Umherirrender
 * @author W (aka Wuzur)
 */
$messages['de'] = array(
	'drafts' => 'Zwischengespeicherte Versionen',
	'drafts-desc' => 'Zwischenspeichern von [[Special:Drafts|Textentwürfen]] auf dem Server',
	'drafts-view' => 'Zwischengespeicherte Version anzeigen',
	'drafts-view-summary' => 'Diese Spezialseite listet alle bestehenden zwischengespeicherten Versionen auf.
Nicht verwendete zwischengespeicherte Versionen werden nach {{PLURAL:$1|$1 Tag|$1 Tagen}} automatisch verworfen.',
	'drafts-view-article' => 'Seite',
	'drafts-view-existing' => 'Bestehende zwischengespeicherte Versionen',
	'drafts-view-saved' => 'Gespeichert',
	'drafts-view-discard' => 'Verwerfen',
	'drafts-view-nonesaved' => 'Du hast bisher noch keine zwischengespeicherten Versionen erstellt.',
	'drafts-view-notice' => 'Du hast $1 für diese Seite.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|zwischengespeicherte Version|zwischengespeicherte Versionen}}',
	'drafts-view-warn' => 'Wenn du diese Seite verlässt, gehen alle nichtgespeicherten Änderungen verloren.
Möchtest du dennoch fortfahren?',
	'drafts-save' => 'Diese Version zwischenspeichern',
	'drafts-save-save' => 'Zwischenspeichern',
	'drafts-save-saved' => 'Gespeichert',
	'drafts-save-saving' => 'Am Speichern …',
	'drafts-save-error' => 'Fehler beim Erstellen der zwischengespeicherten Version',
	'tooltip-drafts-save' => 'Eine zwischengespeicherte Version erstellen',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author ChrisiPK
 * @author Imre
 * @author MichaelFrey
 */
$messages['de-formal'] = array(
	'drafts-view-nonesaved' => 'Sie haben bisher noch keine zwischengespeicherten Versionen erstellt.',
	'drafts-view-notice' => 'Sie haben $1 für diese Seite.',
	'drafts-view-warn' => 'Wenn Sie diese Seite verlasseb, gehen alle nichtgespeicherten Änderungen verloren.
Möchten Sie dennoch fortfahren?',
);

/** Zazaki (Zazaki)
 * @author Aspar
 * @author Xoser
 */
$messages['diq'] = array(
	'drafts' => 'nımuneyi',
	'drafts-desc' => 'Xacetê versiyonê [[Special:Drafts|draft]] yew peleyî qeyd kerdişî de keno',
	'drafts-view' => 'nımune bıvin',
	'drafts-view-summary' => 'no pelo xususi listeya numuneyi ya mewcudi ramocneno.
numuneyê ke nêşuxuliyeni badê $1 {{PLURAL:$1|roci|roci}} bı otomatik esteriyeni.',
	'drafts-view-article' => 'Pel',
	'drafts-view-existing' => 'Draftan ke esto',
	'drafts-view-saved' => 'Qeyd biker',
	'drafts-view-discard' => 'Îptal biker',
	'drafts-view-nonesaved' => 'Ti hama nika yew draft qeyd nikerd.',
	'drafts-view-notice' => 'Ser ena pel de $1 teneyê tu esto.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|draft|draftan}}',
	'drafts-view-warn' => 'Eka ti ena pele qefinene, vurnayîşê tu ke ti qeyd nikerd înan pêran beno vin.
Ti wazeno dewam bikero?',
	'drafts-save' => 'Eno ze yew draft qeyd bike',
	'drafts-save-save' => 'Draft qeyd ke',
	'drafts-save-saved' => 'Qeyd bike',
	'drafts-save-saving' => 'Ho qeyd keno',
	'drafts-save-error' => 'Qeyd kerdişî de yew ğelet biyo',
	'tooltip-drafts-save' => 'Ze yew draft qeyd bike',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'drafts' => 'Nacerjenja',
	'drafts-desc' => 'Zmóžna składowanje [[Special:Drafts|nacerjeńskich wersijow]] boka na serwerje',
	'drafts-view' => 'Nacerjenje se woglědaś',
	'drafts-view-summary' => 'Toś ten specialny bok pokazujo lisćinu wšych eksistujucych nacerjenjow.
Njewužywane naćerjenja zachyśiju se awtomatiski pó {{PLURAL:$1|$ dnju|$1 dnjoma|$1 dnjach|$1 dnjach}}.',
	'drafts-view-article' => 'Bok',
	'drafts-view-existing' => 'Eksistěrujuce nacerjenja',
	'drafts-view-saved' => 'Skłaźony',
	'drafts-view-discard' => 'Zachyśiś',
	'drafts-view-nonesaved' => 'Dotychměst njejsy składł nacerjenja.',
	'drafts-view-notice' => 'Maš $1 za toś ten bok.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|nacerjenje|nacerjeni|nacerjenja|nacerjenjow}}',
	'drafts-view-warn' => 'Gaž spušćaš toś ten bok, zgubijoš wše njeskłaźone změny na toś tom boku.
Coš weto pókšacowaś?',
	'drafts-save' => 'To ako nacerjenje składowaś',
	'drafts-save-save' => 'Nacerjenje składowaś',
	'drafts-save-saved' => 'Skłaźony',
	'drafts-save-saving' => 'Składowanje',
	'drafts-save-error' => 'Zmólka pśi składowanju nacerjenja',
	'tooltip-drafts-save' => 'Ako nacerjenje składowaś',
);

/** Ewe (Eʋegbe) */
$messages['ee'] = array(
	'drafts-view-article' => 'Axa',
);

/** Greek (Ελληνικά)
 * @author Dead3y3
 * @author Geraki
 * @author Omnipaedista
 */
$messages['el'] = array(
	'drafts' => 'Drafts',
	'drafts-desc' => 'Προσθέτει την ικανότητα για αποθήκευση [[Special:Drafts|πρόχειρων]] εκδόσεων μιας σελίδας στον εξυπηρετητή',
	'drafts-view' => 'ΕμφάνισηΠροχείρου',
	'drafts-view-summary' => 'Αυτή η ειδική σελίδα εμφανίζει έναν κατάλογο όλων των υπάρχοντων προχείρων.
Αχρησιμοποίητα πρόχειρα θα απορρίπτονται μετά από {{PLURAL:$1|$1 ημέρα|$1 ημέρες}} αυτόματα.',
	'drafts-view-article' => 'Σελίδα',
	'drafts-view-existing' => 'Υπάρχοντα πρόχειρα',
	'drafts-view-saved' => 'Αποθηκευμένα',
	'drafts-view-discard' => 'Απόρριψη',
	'drafts-view-nonesaved' => 'Δεν έχετε κανένα πρόχειρο αποθηκευμένο αυτή τη στιγμή.',
	'drafts-view-notice' => 'Έχετε $1 για αυτή τη σελίδα.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|πρόχειρο|πρόχειρα}}',
	'drafts-view-warn' => 'Με την περιήγησή σας μακριά από αυτή τη σελίδα θα χάσετε όλες τις αποθήκευτες αλλαγές σε αυτή τη σελίδα.
Θέλετε να συνεχίσετε;',
	'drafts-save' => 'Αποθήκευση αυτού ως προχείρου',
	'drafts-save-save' => 'Αποθήκευση προχείρου',
	'drafts-save-saved' => 'Αποθηκεύτηκε',
	'drafts-save-saving' => 'Αποθηκεύεται',
	'drafts-save-error' => 'Σφάλμα στην αποθήκευση του προχείρου',
	'tooltip-drafts-save' => 'Αποθήκευση ως ένα πρόχειρο',
);

/** Esperanto (Esperanto)
 * @author Melancholie
 * @author Yekrats
 */
$messages['eo'] = array(
	'drafts' => 'Malnetoj',
	'drafts-desc' => 'Permesas la kapablon konservi [[Special:Drafts|malnetajn]] versiojn de paĝo de la servilo',
	'drafts-view' => 'VidiMalneton',
	'drafts-view-summary' => 'Ĉi tiu speciala paĝo montras liston de ĉiuj ekzistantaj malnetoj.
Neuzataj malnetoj estos forĵetitaj post {{PLURAL:$1|$1 tago|$1 tagoj}} aŭtomate.',
	'drafts-view-article' => 'Paĝo',
	'drafts-view-existing' => 'Ekzistante malnetojn',
	'drafts-view-saved' => 'Konservita',
	'drafts-view-discard' => 'Forĵeti',
	'drafts-view-nonesaved' => 'Vi ne havas iujn malnetojn konservitajn ĉi-momente.',
	'drafts-view-notice' => 'Vi havas $1n por ĉi tiun paĝon.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|malneto|malnetoj}}',
	'drafts-view-warn' => 'Se vi navigus for de ĉi tiu paĝo, vi perdus ĉiun nekonservitajn ŝanĝojn al ĉi tiu paĝo.
Ĉu vi volas fari tiel?',
	'drafts-save' => 'Konservi ĉi tiun kiel malneton',
	'drafts-save-save' => 'Konservi malneton',
	'drafts-save-saved' => 'Konservita',
	'drafts-save-saving' => 'Konservante',
	'drafts-save-error' => 'Eraro konservante malneton',
	'tooltip-drafts-save' => 'Konservi kiel malneton',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Dferg
 * @author Imre
 * @author Remember the dot
 */
$messages['es'] = array(
	'drafts' => 'Borradores',
	'drafts-desc' => 'Agregar la habilidad de grabar versiones [[Special:Drafts|borrador]] de esta página en el servidor',
	'drafts-view' => 'Ver borrador',
	'drafts-view-summary' => 'Esta página especial muestra una lista de todos los borradores existentes.
Los borradores no usados serán descartados despues de {{PLURAL:$1|$1 día|$1 días}} automáticamente.',
	'drafts-view-article' => 'Página',
	'drafts-view-existing' => 'Borradores existentes',
	'drafts-view-saved' => 'Grabar',
	'drafts-view-discard' => 'Descartar',
	'drafts-view-nonesaved' => 'No tiene ningún borrador grabado en este momento.',
	'drafts-view-notice' => 'usted tiene $1 para esta página.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|borrador|borradores}}',
	'drafts-view-warn' => 'Por navigar fuera de esta página, usted perderá todos cambios no guardados a esta página.
¿Quiere continuar?',
	'drafts-save' => 'Guardar esto como un borrador',
	'drafts-save-save' => 'Grabar borrador',
	'drafts-save-saved' => 'Grabado',
	'drafts-save-saving' => 'Grabando',
	'drafts-save-error' => 'Error grabando borrador',
	'tooltip-drafts-save' => 'Guardar como un borrador',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 */
$messages['et'] = array(
	'drafts' => 'Mustandid',
	'drafts-desc' => 'Võimaldab serverisse lehekülje [[Special:Drafts|mustandiversioone]] salvestada.',
	'drafts-view' => 'Vaata mustandeid',
	'drafts-view-summary' => 'Sellel erileheküljel kuvatakse kõik olemasolevad mustandid.
Kasutamata mustandid vistakse {{PLURAL:$1|ühe päeava|$1 päeva}} möödudes automaatselt ära.',
	'drafts-view-article' => 'Lehekülg',
	'drafts-view-existing' => 'Olemasolevad mustandid',
	'drafts-view-saved' => 'Salvestatud',
	'drafts-view-discard' => 'Viska ära',
	'drafts-view-nonesaved' => 'Hetkel pole sul ühtegi salvestatud mustandit.',
	'drafts-view-notice' => 'Sul on selle lehekülje jaoks $1.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|mustand|mustandit}}',
	'drafts-view-warn' => 'Kui sellelt leheküljelt lahkud, jääd ilma kõigist sellel leheküljel tehtud salvestamata muudatustest.
Kas soovid jätkata?',
	'drafts-save' => 'Salvesta see mustandina',
	'drafts-save-save' => 'Salvesta mustand',
	'drafts-save-saved' => 'Salvestatud',
	'drafts-save-saving' => 'Salvestamine',
	'drafts-save-error' => 'Mustandi salvestamine ebaõnnestus',
	'tooltip-drafts-save' => 'Salvesta mustandina',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'drafts' => 'Zirriborroak',
	'drafts-view-article' => 'Orrialdea',
	'drafts-view-existing' => 'Dauden zirriborroak',
	'drafts-view-saved' => 'Gordeta',
	'drafts-view-discard' => 'Baztertu',
	'drafts-view-nonesaved' => 'Une honetan ez duzu gordetako zirriborrorik.',
	'drafts-view-notice' => 'Orrialde honetarako $1 duzu.',
	'drafts-view-notice-link' => '{{PLURAL:$1|Zirriborro $1|$1 zirriborro}}',
	'drafts-save' => 'Gorde hau zirriborro bezala',
	'drafts-save-save' => 'Zirriborroa gorde',
	'drafts-save-saved' => 'Gordeta',
	'drafts-save-saving' => 'Gordetzen',
	'drafts-save-error' => 'Akatsa zirriborroa gordetzean',
	'tooltip-drafts-save' => 'Zirriborroa bezala gorde',
);

/** Persian (فارسی)
 * @author Huji
 * @author Wayiran
 */
$messages['fa'] = array(
	'drafts' => 'پیش‌نویس‌ها',
	'drafts-desc' => 'امکان نمایش نسخه‌های [[Special:Drafts|پیش‌نویس]] یک صفحه را می‌افزاید',
	'drafts-view' => 'نمایش پیش‌نویس',
	'drafts-view-summary' => 'این صفحهٔ ویژه فهرستی از تمام پیش‌نویس‌های موجود را نمایش می‌دهد.
پیش‌نویس‌های استفاده نشده پس از {{PLURAL:$1|$1 روز|$1 روز}} به طور خودکار دور انداخته می‌شوند.',
	'drafts-view-article' => 'صفحه',
	'drafts-view-existing' => 'پیش‌نویس‌های موجود',
	'drafts-view-saved' => 'ذخیره شد',
	'drafts-view-discard' => 'دور انداختن',
	'drafts-view-nonesaved' => 'شما همینک هیچ پیش‌نویسی ذخیره ندارید.',
	'drafts-view-notice' => 'شما $1 برای این صفحه دارید.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|پیش‌نویس|پیش‌نویس}}',
	'drafts-view-warn' => 'با خارج شدن از این صفحه شما تمام تغییرات ذخیره نشده در این صفحه را ازدست می‌دهید.
آیا می‌خواهید ادامه دهید؟ْ',
	'drafts-save' => 'ذخیره کردن این متن به عنوان پیش‌نویس',
	'drafts-save-save' => 'ذخیره کردن پیش‌نویس',
	'drafts-save-saved' => 'ذخیره شد',
	'drafts-save-saving' => 'ذخیره‌سازی',
	'drafts-save-error' => 'خطا در ذخیره کردن پیش‌نویس',
	'tooltip-drafts-save' => 'ذخیره به عنوان پیش‌نویس',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Nike
 * @author Str4nd
 * @author Vililikku
 */
$messages['fi'] = array(
	'drafts' => 'Luonnokset',
	'drafts-desc' => 'Lisää mahdollisuuden tallentaa [[Special:Drafts|luonnosversioita]] sivusta palvelimelle.',
	'drafts-view' => 'Katso luonnosta',
	'drafts-view-summary' => 'Tämä toimintosivu näyttää luettelon kaikista olemassa olevista luonnoksista.
Luonnokset, joita ei käytetä hävitetään {{PLURAL:$1|$1 päivän|$1 päivän}} kuluttua automaattisesti.',
	'drafts-view-article' => 'Sivu',
	'drafts-view-existing' => 'Olemassa olevat luonnokset',
	'drafts-view-saved' => 'Tallennettu',
	'drafts-view-discard' => 'Hylkää',
	'drafts-view-nonesaved' => 'Sinulla ei ole yhtään tallennettua luonnosta tällä hetkellä.',
	'drafts-view-notice' => 'Sinulla on $1 tälle sivulle.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|luonnos|luonnosta}}',
	'drafts-view-warn' => 'Jos siirryt pois tältä sivulta, kadotat kaikki tallentamattomat muutokset.
Haluatko jatkaa?',
	'drafts-save' => 'Tallenna nykyinen teksti luonnoksena',
	'drafts-save-save' => 'Tallenna luonnos',
	'drafts-save-saved' => 'Tallennettu',
	'drafts-save-saving' => 'Tallennetaan',
	'drafts-save-error' => 'Luonnoksen tallentaminen epäonnistui',
	'tooltip-drafts-save' => 'Tallenna luonnoksena',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author IAlex
 * @author Verdy p
 */
$messages['fr'] = array(
	'drafts' => 'Brouillons',
	'drafts-desc' => 'Ajoute la possibilité d’enregistrer les versions « [[Special:Drafts|brouillons]] » d’une page sur le serveur',
	'drafts-view' => 'Voir le brouillon',
	'drafts-view-summary' => 'Cette page spéciale liste tous les brouillons existant.
Les brouillons inutilisés seront automatiquement supprimés après $1 jour{{PLURAL:$1||s}}.',
	'drafts-view-article' => 'Page',
	'drafts-view-existing' => 'Brouillons existants',
	'drafts-view-saved' => 'Enregistré',
	'drafts-view-discard' => 'Abandonner',
	'drafts-view-nonesaved' => 'Vous n’avez actuellement enregistré aucun brouillon.',
	'drafts-view-notice' => 'Vous avez $1 pour cette page.',
	'drafts-view-notice-link' => '$1 brouillon{{PLURAL:$1||s}}',
	'drafts-view-warn' => 'En navigant en dehors de cette page, vous perdrez toutes les modifications non enregistrées de cette page.
Voulez-vous continuer ?',
	'drafts-save' => 'Enregistrer ceci comme brouillon',
	'drafts-save-save' => 'Enregistrer le brouillon',
	'drafts-save-saved' => 'Enregistré',
	'drafts-save-saving' => 'Enregistrement en cours',
	'drafts-save-error' => 'Erreur d’enregistrement du brouillon',
	'tooltip-drafts-save' => 'Enregistrer comme brouillon',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'drafts' => 'Brolyons',
	'drafts-desc' => 'Apond la possibilitât d’encartar les vèrsions « [[Special:Drafts|brolyons]] » d’una pâge sur lo sèrvor.',
	'drafts-view' => 'Vêre lo brolyon',
	'drafts-view-summary' => 'Ceta pâge spèciâla liste tôs los brolyons ègzistents.
Los brolyons inutilisâs seront suprimâs ôtomaticament aprés $1 jorn{{PLURAL:$1||s}}.',
	'drafts-view-article' => 'Pâge',
	'drafts-view-existing' => 'Brolyons ègzistents',
	'drafts-view-saved' => 'Encartâ',
	'drafts-view-discard' => 'Abandonar',
	'drafts-view-nonesaved' => 'Ora, vos éd encartâ gins de brolyon.',
	'drafts-view-notice' => 'Vos avéd $1 por ceta pâge.',
	'drafts-view-notice-link' => '$1 brolyon{{PLURAL:$1||s}}',
	'drafts-view-warn' => 'En naveguent en defôr de ceta pâge, vos pèrdréd tôs los changements pas encartâs de ceta pâge.
Voléd-vos continuar ?',
	'drafts-save' => 'Encartar cen coment brolyon',
	'drafts-save-save' => 'Encartar lo brolyon',
	'drafts-save-saved' => 'Encartâ',
	'drafts-save-saving' => 'Encartâjo en cors',
	'drafts-save-error' => 'Èrror d’encartâjo du brolyon',
	'tooltip-drafts-save' => 'Encartar coment brolyon',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'drafts' => 'Borrador',
	'drafts-desc' => 'Engade a habilidade de gardar, no servidor, versións [[Special:Drafts|borrador]] dunha páxina',
	'drafts-view' => 'Ver o borrador',
	'drafts-view-summary' => 'Esta páxina especial amosa unha lista de todos os borradores existentes.
Os borradores non usuados serán descartados automaticamente tras {{PLURAL:$1|un día|$1 días}}.',
	'drafts-view-article' => 'Páxina',
	'drafts-view-existing' => 'Borradores existentes',
	'drafts-view-saved' => 'Gardado',
	'drafts-view-discard' => 'Desbotar',
	'drafts-view-nonesaved' => 'Nestes intres non ten gardado ningún borrador.',
	'drafts-view-notice' => 'Ten $1 para esta páxina.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|borrador|borradores}}',
	'drafts-view-warn' => 'Se deixa esta páxina perderá todos os cambios que non foron gardados.
Quere continuar?',
	'drafts-save' => 'Gardar isto como un borrador',
	'drafts-save-save' => 'Gardar o borrador',
	'drafts-save-saved' => 'Gardado',
	'drafts-save-saving' => 'Gardando',
	'drafts-save-error' => 'Produciuse un erro ao gardar o borrador',
	'tooltip-drafts-save' => 'Gardar como un borrador',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 */
$messages['grc'] = array(
	'drafts-view-article' => 'Δέλτος',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'drafts' => 'Versione im Zwischespycher',
	'drafts-desc' => 'Macht s megli, [[Special:Drafts|zwischegspychereti Versione]] uf em Server aazlege',
	'drafts-view' => 'Version im Zwischespycher aazeige',
	'drafts-view-summary' => 'Die Spezialsyte zeigt alli Entwirf, wu s git.
Entwirf, wu nit verwändet wäre, wäre automatisch no {{PLURAL:$1|$1 Tag|$1 Täg}} useghejt.',
	'drafts-view-article' => 'Syte',
	'drafts-view-existing' => 'Versione, wu s im Zwischespycher git',
	'drafts-view-saved' => 'Gspycheret',
	'drafts-view-discard' => 'Furt gheije',
	'drafts-view-nonesaved' => 'Du hesch no kei Versione im Zwischespychere aagleit.',
	'drafts-view-notice' => 'Du hesch $1 fir die Syte.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|Version im Zwischespycher|Versione im Zwischespycher}}',
	'drafts-view-warn' => 'Wänn Du die Syte verlosch, no gehn alli Änderige verlore, wu nit gspycheret sin.
Mechtsch einewäg wytergoh?',
	'drafts-save' => 'Die Version zwischespychere',
	'drafts-save-save' => 'Zwischespychere',
	'drafts-save-saved' => 'Gspycheret',
	'drafts-save-saving' => 'Am Spychere',
	'drafts-save-error' => 'Fähler bim Aalege vu dr zwischegspycherete Version',
	'tooltip-drafts-save' => 'E zwischegspychereti Version aalege',
);

/** Gujarati (ગુજરાતી)
 * @author Ashok modhvadia
 * @author Dineshjk
 */
$messages['gu'] = array(
	'drafts' => 'મુસદ્દા',
	'drafts-desc' => 'સર્વર પર [[Special:મુસદ્દા|મુસદ્દા]]ના પાનાંનાં સંસ્કરણો સાચવવાની ક્ષમતા ઉમેરે છે.',
	'drafts-view' => 'મુસદ્દો જુઓ',
	'drafts-view-summary' => 'આ ખાસ પાનું બધા વિદ્યમાન મુસદ્દાની યાદી દર્શાવે છે.

વણવપરાયેલ મુસદ્દા {{PLURAL:$1|$1 દિવસ|$1 દિવસો}} પછી આપોઆપ દુર કરાશે.',
	'drafts-view-article' => 'પૃષ્ઠ',
	'drafts-view-existing' => 'વિદ્યમાન મુસદ્દા',
	'drafts-view-saved' => 'સાચવેલ',
	'drafts-view-discard' => 'કાઢી નાખો',
	'drafts-view-nonesaved' => 'આ સમયે તમારી પાસે કોઇ સાચવેલ મુસદ્દા નથી.',
	'drafts-view-notice' => 'તમારી પાસે આ પાના માટે $1 છે.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|મુસદ્દો|મુસદ્દા}}',
	'drafts-view-warn' => 'આ પાના પરથી બીજે જતા તમે સાચવ્યા વિનાના બધાજ ફેરફારો ગુમાવશો.

તમે આગળ વધવા માંગો છો?',
	'drafts-save' => 'આને મુસદ્દા તરીકે સાચવો',
	'drafts-save-save' => 'મુસદ્દો સાચવો',
	'drafts-save-saved' => 'સાચવ્યું',
	'drafts-save-saving' => 'સચવાય છે',
	'drafts-save-error' => 'મુસદ્દો સાચવવામાં ત્રુટી',
	'tooltip-drafts-save' => 'મુસદ્દા તરીકે સાચવો',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'drafts-view-article' => 'Shafi',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'drafts' => 'טיוטות',
	'drafts-desc' => 'הוספת האפשרות לשמירת גרסאות [[Special:Drafts|טיוטה]] של הדף בשרת',
	'drafts-view' => 'הצגת טיוטה',
	'drafts-view-summary' => 'דף מיוחד זה מציג רשימה של כל הטיוטות הקיימות.
טיוטות שאינן בשימוש יימחקו אוטומטית כעבור {{PLURAL:$1|יום אחד|$1 ימים|יומיים}}.',
	'drafts-view-article' => 'דף',
	'drafts-view-existing' => 'טיוטות קיימות',
	'drafts-view-saved' => 'שמורה',
	'drafts-view-discard' => 'מחיקה',
	'drafts-view-nonesaved' => 'אין לכם טיוטות שמורות לעת עתה.',
	'drafts-view-notice' => 'יש לכם $1 לדף זה.',
	'drafts-view-notice-link' => '{{PLURAL:$1|טיוטה אחת|$1 טיוטות}}',
	'drafts-view-warn' => 'אם תנווטו אל מחוץ לדף, תאבדו את כל השינויים שלא נשמרו לדף זה.
האם ברצונכם להמשיך?',
	'drafts-save' => 'שמירת דף זה כטיוטה',
	'drafts-save-save' => 'שמירת טיוטה',
	'drafts-save-saved' => 'נשמרה',
	'drafts-save-saving' => 'בשמירה',
	'drafts-save-error' => 'שגיאה בשמירת הטיוטה',
	'tooltip-drafts-save' => 'שמירה כטיוטה',
);

/** Croatian (Hrvatski)
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'drafts' => 'Nacrti',
	'drafts-desc' => 'Dodaje mogućnost snimanja [[Special:Drafts|nacrta]] stranice na poslužitelj',
	'drafts-view' => 'VidiNacrt',
	'drafts-view-summary' => 'Ova posebna stranica prikazuje popis svih postojećih nacrta.
Neuporabljeni nacrti će biti automatski odbačeni nakon {{PLURAL:$1|jednog dana|$1 dana|$1 dana}}.',
	'drafts-view-article' => 'Stranica',
	'drafts-view-existing' => 'Postojeći nacrti',
	'drafts-view-saved' => 'Snimljeno',
	'drafts-view-discard' => 'Odbaci',
	'drafts-view-nonesaved' => 'Nemate nijedan spremljeni nacrt u ovom trenutku.',
	'drafts-view-notice' => 'Imate $1 za ovu stranicu.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|nacrt|nacrta|nacrta}}',
	'drafts-view-warn' => 'Odlaskom s ove stranice, izgubit ćete sve nespremljene promjene na ovoj stranici.
Želite li nastaviti?',
	'drafts-save' => 'Spremi kao skicu',
	'drafts-save-save' => 'Spremi skicu',
	'drafts-save-saved' => 'Snimljeno',
	'drafts-save-saving' => 'Snimam',
	'drafts-save-error' => 'Pogrješka pri spremanju skice',
	'tooltip-drafts-save' => 'Spremi kao skicu',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'drafts' => 'Naćiski',
	'drafts-desc' => 'Zmóžnja składowanje [[Special:Drafts|naćiskich wersijow]] strony na serwerje',
	'drafts-view' => 'ViewDraft',
	'drafts-view-summary' => 'Tuta specialna strona pokazuje lisćinu wšěch eksistowacych naćiskow.
Njewužiwane naćiski so po {{PLURAL:$1|$1 dnju|$1 dnjomaj|$1 dnjach|$1 dnjach}} awtomatisce zaćiskaja.',
	'drafts-view-article' => 'Strona',
	'drafts-view-existing' => 'Eksistowace naćiski',
	'drafts-view-saved' => 'Składowany',
	'drafts-view-discard' => 'Zaćisnyć',
	'drafts-view-nonesaved' => 'Njejsy dotal žane naćiski składował.',
	'drafts-view-notice' => 'Maš $1 za tutu stronu.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|naćisk|naćiskaj|naćiski|naćiskow}}',
	'drafts-view-warn' => 'Hdyž stronu wopušćiš, zhubiš wšě njeskładowane změny tuteje strony. Chceš najebać toho pokročować?',
	'drafts-save' => 'To jako naćisk składować',
	'drafts-save-save' => 'Naćisk składować',
	'drafts-save-saved' => 'Składowany',
	'drafts-save-saving' => 'Składowanje',
	'drafts-save-error' => 'Zmylk při składowanju naćiska',
	'tooltip-drafts-save' => 'Jako naćisk składować',
);

/** Hungarian (Magyar)
 * @author Bdamokos
 * @author Dani
 * @author Glanthor Reviol
 * @author Gondnok
 */
$messages['hu'] = array(
	'drafts' => 'Piszkozatok',
	'drafts-desc' => 'Lehetővé teszi lapok [[Special:Drafts|piszkozatainak]] elmentését a szerverre',
	'drafts-view' => 'Piszkozatok megtekintése',
	'drafts-view-summary' => 'Ez a speciális lap listázza az összes piszkozatot.
A fel nem használt piszkozatok {{PLURAL:$1|egy nap|$1 nap}} után automatikusan törlődnek.',
	'drafts-view-article' => 'Lap',
	'drafts-view-existing' => 'Elmentett piszkozatok',
	'drafts-view-saved' => 'Elmentve',
	'drafts-view-discard' => 'Elvetés',
	'drafts-view-nonesaved' => 'Jelenleg nincs egyetlen elmentett piszkozatod sem.',
	'drafts-view-notice' => 'Jelenleg $1 van ehhez a laphoz.',
	'drafts-view-notice-link' => '{{PLURAL:$1|egy|$1}} piszkozatod',
	'drafts-view-warn' => 'Ha elmész az oldalról, az összes nem mentett változtatás elvész.
Biztosan folytatod?',
	'drafts-save' => 'Mentés piszkozatként',
	'drafts-save-save' => 'Mentés piszkozatként',
	'drafts-save-saved' => 'Elmentve',
	'drafts-save-saving' => 'Mentés…',
	'drafts-save-error' => 'Hiba történt a piszkozat elmentése közben',
	'tooltip-drafts-save' => 'Mentés piszkozatként',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'drafts' => 'Versiones provisori',
	'drafts-desc' => 'Adde le possibilitate de salveguardar [[Special:Drafts|versiones provisori]] de un pagina in le servitor',
	'drafts-view' => 'Vider version provisori',
	'drafts-view-summary' => 'Iste pagina special monstra un lista de tote le versiones provisori existente.
Le versiones provisori non usate essera automaticamente abandonate post {{PLURAL:$1|$1 die|$1 dies}}.',
	'drafts-view-article' => 'Pagina',
	'drafts-view-existing' => 'Versiones provisori existente',
	'drafts-view-saved' => 'Salveguardate',
	'drafts-view-discard' => 'Abandonar',
	'drafts-view-nonesaved' => 'Tu non ha alcun version provisori salveguardate al momento.',
	'drafts-view-notice' => 'Tu ha $1 pro iste pagina.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|version|versiones}} provisori',
	'drafts-view-warn' => 'Si tu quita iste pagina, tu perdera tote le modificationes non salveguardate de iste pagina.
Continuar?',
	'drafts-save' => 'Salveguardar isto como version provisori',
	'drafts-save-save' => 'Salveguardar version provisori',
	'drafts-save-saved' => 'Salveguardate',
	'drafts-save-saving' => 'Salveguarda in curso',
	'drafts-save-error' => 'Error salveguardante le version provisori',
	'tooltip-drafts-save' => 'Salveguardar como version provisori',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Irwangatot
 * @author IvanLanin
 * @author Kandar
 */
$messages['id'] = array(
	'drafts' => 'Rancangan',
	'drafts-desc' => 'Menambahkan kemampuan untuk menyimpan versi [[Special:Drafts|tulisan rancangan]] suatu halaman di server',
	'drafts-view' => 'LihatRancangan',
	'drafts-view-summary' => 'Halaman istimewa ini menunjukkan daftar semua tulisan rancangan yang ada.
Tulisan rancangan yang tidak digunakan akan dibuang secara otomatis setelah {{PLURAL:$1||}}$1 hari.',
	'drafts-view-article' => 'Halaman',
	'drafts-view-existing' => 'Tulisan rancangan yang ada',
	'drafts-view-saved' => 'Simpan..',
	'drafts-view-discard' => 'Buang',
	'drafts-view-nonesaved' => 'Saat ini Anda tidak memiliki tulisan rancangan yang tersimpan.',
	'drafts-view-notice' => 'Anda memiliki $1 untuk halaman ini.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1||}}tulisan rancangan',
	'drafts-view-warn' => 'Jika Anda meninggalkan halaman ini Anda akan kehilangan semua perubahan yang belum tersimpan.
Apakah Anda ingin meninggalkan halaman ini?',
	'drafts-save' => 'Simpan halaman ini sebagai tulisan rancangan',
	'drafts-save-save' => 'Simpan tulisan rancangan',
	'drafts-save-saved' => 'Tersimpan',
	'drafts-save-saving' => 'Menyimpan',
	'drafts-save-error' => 'Terjadi kesalahan pada saat menyimpan tulisan rancangan',
	'tooltip-drafts-save' => 'Simpan sebagai tulisan rancangan',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'drafts' => 'Kladi',
	'drafts-view-article' => 'Pagino',
	'drafts-view-saved' => 'Registragita',
	'drafts-view-notice' => 'Vu havas $1 por ca pagino.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|klado|kladi}}',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Darth Kule
 */
$messages['it'] = array(
	'drafts' => 'Bozze',
	'drafts-desc' => 'Aggiunge la possibilità di salvare versioni di [[Special:Drafts|bozza]] di una pagina sul server',
	'drafts-view' => 'VisualizzaBozza',
	'drafts-view-summary' => 'Questa pagina speciale mostra un elenco delle bozze esistenti. Le bozze non usate verranno cancellate automaticamente dopo {{PLURAL:$1|$1 giorno|$1 giorni}}.',
	'drafts-view-article' => 'Pagina',
	'drafts-view-existing' => 'Bozze esistenti',
	'drafts-view-saved' => 'Salvata',
	'drafts-view-discard' => 'Cancella',
	'drafts-view-nonesaved' => 'Non hai alcuna bozza salvata al momento.',
	'drafts-view-notice' => 'Hai $1 per questa pagina.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|bozza|bozze}}',
	'drafts-view-warn' => 'Uscendo da questa pagina tutte le modifiche apportate non salvate saranno perse. Si desidera continuare?',
	'drafts-save' => 'Salva come bozza',
	'drafts-save-save' => 'Salva bozza',
	'drafts-save-saved' => 'Salvata',
	'drafts-save-saving' => 'Salvataggio',
	'drafts-save-error' => 'Errore nel salvataggio della bozza',
	'tooltip-drafts-save' => 'Salva come bozza',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'drafts' => '下書き',
	'drafts-desc' => 'ページの[[Special:Drafts|下書き]]をサーバーに保存できるようにする',
	'drafts-view' => '下書き表示',
	'drafts-view-summary' => 'この特別ページは現在保存されている下書きを一覧表示します。使用されていない下書きは $1{{PLURAL:$1|日}}後に自動的に破棄されます。',
	'drafts-view-article' => 'ページ',
	'drafts-view-existing' => '現在保存されている下書き',
	'drafts-view-saved' => '保存済',
	'drafts-view-discard' => '破棄',
	'drafts-view-nonesaved' => '現在保存されている下書きはありません。',
	'drafts-view-notice' => 'このページにはあなたが作成した$1があります。',
	'drafts-view-notice-link' => '$1個の{{PLURAL:$1|下書き}}',
	'drafts-view-warn' => 'このページから抜けると、あなたがこのページに加えた未保存の変更がすべて失われてしまいます。続けますか？',
	'drafts-save' => '現在の原稿を下書きとして保存する',
	'drafts-save-save' => '下書きを保存',
	'drafts-save-saved' => '保存完了',
	'drafts-save-saving' => '保存中',
	'drafts-save-error' => '下書きの保存に失敗',
	'tooltip-drafts-save' => '下書きとして保存する',
);

/** Georgian (ქართული)
 * @author Dawid Deutschland
 * @author Sopho
 * @author გიორგიმელა
 */
$messages['ka'] = array(
	'drafts' => 'შავი ფურცლები',
	'drafts-desc' => 'მატებს [[Special:Drafts|შავი ფურცლების]] შენახვის საშუალებას სერვერზე',
	'drafts-view' => 'შავი ფურცლის ხილვა',
	'drafts-view-summary' => 'ამ სპეცგვერდზე წარმოდგენილია ყველა შავი ფურცელი.
გამოუყენებელი შავი ფურცლები წაიშლება $1 {{PLURAL:$1|დღე|დღის|დღეები}}.',
	'drafts-view-article' => 'გვერდი',
	'drafts-view-existing' => 'არსებული შავი ფურცლები',
	'drafts-view-saved' => 'შენახვა',
	'drafts-view-discard' => 'გაუქმება',
	'drafts-view-nonesaved' => 'ამ დროისთვის თქვენ არ გაგაჩნიათ შენახული შავი ფურცლები',
	'drafts-view-notice' => 'თქვენ გაქვთ  $1 ამ გვერდისთვის.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|შეუმოწმებელი ვერსია|შეუმოწმებელი ვერსიები}}',
	'drafts-view-warn' => 'ამ გვერდის დატოვებისას თქვენ კარგავთ ყველა შეუნახავ ცვლილებას.
გაგრძელება?',
	'drafts-save' => 'შეინახეთ როგორც შავი ფურცელი',
	'drafts-save-save' => 'შეინახეთ შავი ფურცელი',
	'drafts-save-saved' => 'შენახულია',
	'drafts-save-saving' => 'შენახვა',
	'drafts-save-error' => 'შავი ფურცელის შენახვის შეცდომა',
	'tooltip-drafts-save' => 'შეინახეთ შავი ფურცელი',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Thearith
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'drafts' => 'ពង្រាង',
	'drafts-desc' => 'បន្ថែម​លទ្ធភាព ដើម្បី​រក្សាទុក​កំណែ [[Special:ពង្រាង|ពង្រាង]] នៃ​ទំព័រ​មួយ​លើ​ម៉ាស៊ីនបម្រើ',
	'drafts-view' => 'មើល​ពង្រាង',
	'drafts-view-article' => 'ទំព័រ',
	'drafts-view-existing' => 'ពង្រាង​ដែល​មាន​ស្រេច',
	'drafts-view-saved' => 'បាន​រក្សាទុក',
	'drafts-view-discard' => 'បោះចោល',
	'drafts-view-nonesaved' => 'អ្នក​មិន​មាន​ពង្រាង​ណាមួយ​ត្រូវ​បាន​រក្សាទុក​នាពេលនេះ​ទេ​។',
	'drafts-view-notice' => 'អ្នក​មាន $1 សម្រាប់​ទំព័រ​នេះ​។',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|ពង្រាង|ពង្រាង}}',
	'drafts-view-warn' => 'បើចាកចេញពីទំព័រនេះ អ្នកនឹងបាត់បង់រាល់អ្វីដែលមិនទាន់បានរក្សាទុកនៅលើទំព័រនេះ។

តើអ្នកចង់បន្តទេ?',
	'drafts-save' => 'រក្សាទុក​ជា​ពង្រាង',
	'drafts-save-save' => 'រក្សាទុក​ពង្រាង',
	'drafts-save-saved' => 'បាន​រក្សាទុក',
	'drafts-save-saving' => 'កំពុង​រក្សាទុក​',
	'drafts-save-error' => 'កំហុស​រក្សាទុក​ពង្រាង',
	'tooltip-drafts-save' => 'រក្សាទុក​ជា​ពង្រាង',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'drafts-view-article' => 'ಪುಟ',
);

/** Korean (한국어)
 * @author Klutzy
 * @author Kwj2772
 */
$messages['ko'] = array(
	'drafts' => '임시 저장된 문서 목록',
	'drafts-desc' => '작업중인 문서를 [[Special:Drafts|임시적으로 저장]]하는 기능입니다.',
	'drafts-view' => '초고 보기',
	'drafts-view-summary' => '이 특수 문서는 모든 존재하는 초고를 보여 주고 있습니다.
사용되지 않는 초고는 $1일 후에 자동적으로 폐기될 것입니다.',
	'drafts-view-article' => '문서',
	'drafts-view-existing' => '임시 저장된 문서 목록',
	'drafts-view-saved' => '저장된 시간',
	'drafts-view-discard' => '삭제',
	'drafts-view-nonesaved' => '임시 저장한 문서가 없습니다.',
	'drafts-view-notice' => '당신은 이 문서에 $1를 갖고 있습니다.',
	'drafts-view-notice-link' => '$1개의 초고',
	'drafts-view-warn' => '다른 문서를 둘러보면, 당신은 저장하지 않은 모든 편집이 사라질 것입니다.
계속하시곘습니까?',
	'drafts-save' => '이 편집을 초안으로 저장',
	'drafts-save-save' => '임시 저장',
	'drafts-save-saved' => '저장됨',
	'drafts-save-saving' => '저장 중',
	'drafts-save-error' => '임시 저장 중 오류 발생',
	'tooltip-drafts-save' => '초안으로 저장하기',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'drafts' => 'Äntwörf',
	'drafts-desc' => 'Deit de Müjjeleschkeit dobei, en [[Special:Drafts|Entworf]] fun en Sigg om Server affzelääje.',
	'drafts-view' => 'Äntworf zeije',
	'drafts-view-summary' => 'Hee die Söndersigg hät en Leß met alle Entwörf, die mer han.
Noh {{PLURAL:$1|einem Daach|$1 Dääsch|nullkommanix}} wäde de
unjenotz Enwörf automattesch fott jeschmesse.',
	'drafts-view-article' => 'Sigg',
	'drafts-view-existing' => 'Jespeicherte Äntwörf',
	'drafts-view-saved' => 'Jespeichert',
	'drafts-view-discard' => 'Schmiiß fott!',
	'drafts-view-nonesaved' => 'Do häß jrad kein Äntwörf jespeichert.',
	'drafts-view-notice' => 'Do häß $1 för heh di Sigg.',
	'drafts-view-notice-link' => '{{PLURAL:$1|eine Entworf|$1 Äntwörf|keine Entworf}}',
	'drafts-view-warn' => 'Wann De heh vun dä Sigg fott jeihß, dann sen all Ding Ennjabe fott, di De noch nit avjespeicht häß.
Wellß De wigger maaache?',
	'drafts-save' => 'Wat mer heh süht als_ennen Entworf avspeichere',
	'drafts-save-save' => 'Entworf avspeichere',
	'drafts-save-saved' => 'Avjespeichert',
	'drafts-save-saving' => 'Am Avspeichere',
	'drafts-save-error' => 'Bemm Entworf Speichere es jet donevve jejange, dat hät nit jeflupp.',
	'tooltip-drafts-save' => 'Als ene Entworf avspeichere',
);

/** Cornish (Kernowek)
 * @author Kw-Moon
 */
$messages['kw'] = array(
	'drafts-view-article' => 'Folen',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'drafts' => 'Brouillonen',
	'drafts-desc' => 'Erlaabt et Versioune vun enger Säit als [[Special:Drafts|Brouillon]] op dem Server ze späicheren',
	'drafts-view' => 'Brouillon weisen',
	'drafts-view-summary' => 'Dës Spezialsäit weist eng Lëscht mat alle Brouillonen, déi et gëtt.
Bruillonen déi net benotzt ginn, ginn no {{PLURAL:$1|engem Dag|$1 Deeg}} automatesch geläscht.',
	'drafts-view-article' => 'Säit',
	'drafts-view-existing' => 'Brouillonen déi et gëtt',
	'drafts-view-saved' => 'Gespäichert',
	'drafts-view-discard' => 'Verwerfen',
	'drafts-view-nonesaved' => 'Dir hutt elo keng Brouillone gespäichert.',
	'drafts-view-notice' => 'Dir hutt $1 fir dës Säit.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|Brouillon|Brouillone}}',
	'drafts-view-warn' => 'Wann Dir vun dëser Säit weidersurft da verléiert Dir all netgespäichert ännerungen vun dëser Säit.',
	'drafts-save' => 'Dës als Brouillon späicheren',
	'drafts-save-save' => 'Brouillon späicheren',
	'drafts-save-saved' => 'Gespäichert',
	'drafts-save-saving' => 'Späicheren',
	'drafts-save-error' => 'Feller beim späicher vum Brouillon',
	'tooltip-drafts-save' => 'Als Brouillon späicheren',
);

/** Limburgish (Limburgs)
 * @author Aelske
 * @author Ooswesthoesbes
 * @author Remember the dot
 */
$messages['li'] = array(
	'drafts' => 'Drafts',
	'drafts-desc' => "Veug functionaliteit tou om [[Special:Drafts|drafts]] van 'n pagina op de server op te slaon",
	'drafts-view' => 'DraftZeen',
	'drafts-view-summary' => "Deze speciale pagina toont 'n lies van alle bestaonde drafts.
Ongebroekte drafts zulle automatisch waere verwiederd nao {{PLURAL:$1|$1 daag|$1 daag}}.",
	'drafts-view-article' => 'Pazjena',
	'drafts-view-existing' => 'Bestaonde drafts',
	'drafts-view-saved' => 'Opgesjlage',
	'drafts-view-discard' => 'Wis',
	'drafts-view-nonesaved' => 'De höbs gein opgeslage drafts.',
	'drafts-view-notice' => 'De mós $1 veur dees pazjena.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|draft|drafts}}',
	'drafts-view-warn' => 'Door ven dees paasj weg te gaon, verluus se als verwieziginge die se nag neet neet höbs opgeslage.
Wilse doorgaon?',
	'drafts-save' => "Slaon es 'ne draft",
	'drafts-save-save' => 'Opslaon',
	'drafts-save-saved' => 'Opgeslaon',
	'drafts-save-saving' => 'Opslääondje',
	'drafts-save-error' => 'Fout ópsläöndje draft',
	'tooltip-drafts-save' => 'Opslaon es draft',
);

/** Maithili (मैथिली)
 * @author Vinitutpal
 */
$messages['mai'] = array(
	'drafts' => 'प्रारूप',
	'drafts-view' => 'प्रारूप देखू',
	'drafts-view-article' => 'पृष्ठ',
	'drafts-view-existing' => 'मौजूदा प्रारूप',
	'drafts-view-saved' => 'सुरक्षित',
	'drafts-view-discard' => 'छोडू',
	'drafts-view-nonesaved' => 'अहि काल अहां के कोनो प्रारूप सुरक्षित नहि अछि.',
	'drafts-view-notice' => 'अहि पृष्ठ लेल अहां लग $1 अछि',
	'drafts-save' => 'प्रारूप जेना सुरुक्षित करू',
	'drafts-save-save' => 'सुरक्षित प्रारूप',
	'drafts-save-saved' => 'सुरक्षित',
	'drafts-save-saving' => 'बचत करू',
	'drafts-save-error' => 'प्रारूप सुरक्षित करहि मे त्रुटि',
	'tooltip-drafts-save' => 'प्रारूप के सुरक्षित करू',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'drafts' => 'Работни верзии',
	'drafts-desc' => 'Додава можност за зачувување на [[Special:Drafts|работни верзии]] на страниците на опслужувачот',
	'drafts-view' => 'ПрегледНаРаботнаВерзија',
	'drafts-view-summary' => 'Оваа специјална страница ги наведува сите постоечки работни верзии.
Неискористените работни верзии ќе бидат автоматски исфрлени по {{PLURAL:$1|$1 ден|$1 дена}}.',
	'drafts-view-article' => 'Страница',
	'drafts-view-existing' => 'Постоечки работни верзии',
	'drafts-view-saved' => 'Зачувано',
	'drafts-view-discard' => 'Фрли',
	'drafts-view-nonesaved' => 'Моментално немате зачувани работни верзии.',
	'drafts-view-notice' => 'Имате $1 за оваа страница.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|работна верзија|работни верзии}}',
	'drafts-view-warn' => 'Ако се оттргнете од страницава ќе ги изгубите сите незачувани промени.
Дали сакате да продолжите?',
	'drafts-save' => 'Зачувај го ова како работна верзија',
	'drafts-save-save' => 'Зачувај раб. верз.',
	'drafts-save-saved' => 'Зачувано',
	'drafts-save-saving' => 'Зачувување',
	'drafts-save-error' => 'Грешка при зачувувањето на работната верзија',
	'tooltip-drafts-save' => 'Зачувај како работна верзија',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'drafts' => 'കരട് താളുകൾ',
	'drafts-desc' => 'സെർവറിൽ താളിന്റെ [[Special:Drafts|കരട്]] പതിപ്പുകൾ സേവ് ചെയ്യാൻ പ്രാപ്തമാക്കുന്നു',
	'drafts-view' => 'കരട് കാണുക',
	'drafts-view-summary' => 'ഇപ്പോൾ നിലവിലുള്ള എല്ലാ കരടും ഈ പ്രത്യേക താളിൽ പട്ടികയായി കാണാവുന്നതാണ്.
ഉപയോഗിക്കാത്ത കരടുകൾ {{PLURAL:$1|ഒരു ദിവസത്തിനു|$1 ദിവസങ്ങൾക്കു}} ശേഷം സ്വയം ഒഴിവാക്കപ്പെടുന്നതാണ്.',
	'drafts-view-article' => 'താൾ',
	'drafts-view-existing' => 'ഇപ്പോഴുള്ള കരടുകൾ',
	'drafts-view-saved' => 'സേവ് ചെയ്തിരിക്കുന്നു',
	'drafts-view-discard' => 'ഒഴിവാക്കിയിരിക്കുന്നു',
	'drafts-view-nonesaved' => 'ഇപ്പോൾ താങ്കൾ കരടുകളൊന്നും സേവ് ചെയ്തിട്ടില്ല.',
	'drafts-view-notice' => 'താങ്കൾക്ക് ഈ താളിൽ $1 ഉണ്ട്.',
	'drafts-view-notice-link' => '{{PLURAL:$1|ഒരു കരട്|$1 കരട്}}',
	'drafts-view-warn' => 'ഈ താളിൽ നിന്നും പോയാൽ താളിലെ സേവ് ചെയ്യാത്ത എല്ലാ മാറ്റങ്ങളും നഷ്ടമാകുന്നതാണ്.
താങ്കൾക്ക് തുടരേണ്ടതുണ്ടോ?',
	'drafts-save' => 'ഇതൊരു കരട് ആയി സേവ് ചെയ്യുക',
	'drafts-save-save' => 'കരട് സേവ് ചെയ്യുക',
	'drafts-save-saved' => 'സേവ് ചെയ്തിരിക്കുന്നു',
	'drafts-save-saving' => 'സേവ് ചെയ്യുന്നു',
	'drafts-save-error' => 'കരട് സേവ് ചെയ്തപ്പോൾ പിഴവുണ്ടായി',
	'tooltip-drafts-save' => 'കരട് ആയി സേവ് ചെയ്യുക',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'drafts-view-article' => 'Хуудас',
);

/** Malay (Bahasa Melayu)
 * @author Aviator
 * @author Izzudin
 */
$messages['ms'] = array(
	'drafts' => 'Draf',
	'drafts-desc' => 'Menambah kebolehan untuk menyimpan laman versi [[Special:Drafts|draf]] dalam komputer pelayan',
	'drafts-view' => 'ViewDraft',
	'drafts-view-summary' => 'Yang berikut ialah senarai semua draf. Draf-draf yang tidak digunakan akan diabaikan secara automatik selepas $1 hari.',
	'drafts-view-article' => 'Laman',
	'drafts-view-existing' => 'Draf yang ada',
	'drafts-view-saved' => 'Disimpan',
	'drafts-view-discard' => 'Abaikan',
	'drafts-view-nonesaved' => 'Anda tidak mempunyai draf.',
	'drafts-view-notice' => 'Anda mempunyai $1 untuk laman ini.',
	'drafts-view-notice-link' => '$1 draf',
	'drafts-view-warn' => 'Anda akan kehilangan semua perubahan pada laman ini yang belum disimpan. Betul anda mahu keluar dari laman ini?',
	'drafts-save' => 'Simpan suntingan ini sebagai draf',
	'drafts-save-save' => 'Simpan draf',
	'drafts-save-saved' => 'Disimpan',
	'drafts-save-saving' => 'Menyimpan',
	'drafts-save-error' => 'Ralat ketika menyimpan draf',
	'tooltip-drafts-save' => 'Simpan sebagai draf',
);

/** Mirandese (Mirandés)
 * @author Malafaya
 */
$messages['mwl'] = array(
	'drafts-view-article' => 'Páigina',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'drafts-view-article' => 'Лопа',
	'drafts-save-saved' => 'Ванстозь',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Laaknor
 */
$messages['nb'] = array(
	'drafts' => 'Kladder',
	'drafts-desc' => 'Legger til muligheten til å lagre [[Special:Drafts|utkast]]versjoner av en side på serveren',
	'drafts-view' => 'Vis utkast',
	'drafts-view-summary' => 'Denne spesialsiden viser en liste over nåværende utkast.
Ubrukte utkast vil slettes automatisk etter {{PLURAL:$1|én dag|$1 dager}}.',
	'drafts-view-article' => 'Side',
	'drafts-view-existing' => 'Eksisterende utkast',
	'drafts-view-saved' => 'Lagret',
	'drafts-view-discard' => 'Forkast',
	'drafts-view-nonesaved' => 'Du har ingen utkast lagret på nåværende tidspunkt',
	'drafts-view-notice' => 'Du har $1 for denne siden.',
	'drafts-view-notice-link' => '{{PLURAL:$1|ett utkast|$1 utkast}}',
	'drafts-view-warn' => 'Ved å navigere vekk fra denne siden vil du miste alle ulagrede endringer til denne siden.
Vil du fortsette?',
	'drafts-save' => 'Lagre dette som et utkast',
	'drafts-save-save' => 'Lagre utkast',
	'drafts-save-saved' => 'Lagret',
	'drafts-save-saving' => 'Lagrer',
	'drafts-save-error' => 'Feil ved lagring av utkast',
	'tooltip-drafts-save' => 'Lagre som et utkast',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'drafts' => 'Twischenspiekert Versionen',
	'drafts-desc' => 'Maakt dat mööglich, [[Special:Drafts|twischenspiekert Versionen]] op’n Server aftoleggen',
	'drafts-view' => 'Twischenspiekert Version ankieken',
	'drafts-view-summary' => 'Disse Spezialsied wiest all twischenspiekerte Versionen.
Nich bruukt twischenspiekerte Versionen warrt na {{PLURAL:$1|$1 Dag|$1 Daag}} automaatsch wegdaan.',
	'drafts-view-article' => 'Sied',
	'drafts-view-existing' => 'Vörhannen twischenspiekerte Versionen',
	'drafts-view-saved' => 'Spiekert',
	'drafts-view-discard' => 'Wegdoon',
	'drafts-view-nonesaved' => 'Du hest noch keen Versionen twischenspiekert.',
	'drafts-view-notice' => 'Du hest $1 för disse Sied.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|twischenspiekerte Version|twischenspiekerte Versionen}}',
	'drafts-view-warn' => 'Wenn du nu vun disse Sied weggeist, gaht all nich spiekerte Ännern verloren.
Wullt du dat liekers doon?',
	'drafts-save' => 'Twischenspiekern',
	'drafts-save-save' => 'Twischenspiekern',
	'drafts-save-saved' => 'Spiekert',
	'drafts-save-saving' => 'An’t Spiekern',
	'drafts-save-error' => 'Fehler bi’t Twischenspiekern',
	'tooltip-drafts-save' => 'Twischenspiekern',
);

/** Dutch (Nederlands)
 * @author Siebrand
 * @author Tvdm
 */
$messages['nl'] = array(
	'drafts' => 'Werkversies',
	'drafts-desc' => 'Voegt functionaliteit toe om [[Special:Drafts|werkversies]] van een pagina op de server op te slaan',
	'drafts-view' => 'WerkversieBekijken',
	'drafts-view-summary' => 'Deze speciale pagina toont een lijst van alle bestaande werkversies.
Ongebruikte werkversies zullen automatisch worden verwijderd na {{PLURAL:$1|$1 dag|$1 dagen}}.',
	'drafts-view-article' => 'Pagina',
	'drafts-view-existing' => 'Bestaande werkversies',
	'drafts-view-saved' => 'Opgeslagen',
	'drafts-view-discard' => 'Verwijderen',
	'drafts-view-nonesaved' => 'U hebt geen opgeslagen werkversies.',
	'drafts-view-notice' => 'U moet $1 voor deze pagina.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|werkversie|werkversies}}',
	'drafts-view-warn' => 'Door van deze pagina weg te navigeren verliest u alle wijzigingen die u nog niet hebt opgeslagen.
Wilt u doorgaan?',
	'drafts-save' => 'Opslaan als werkversie',
	'drafts-save-save' => 'Werkversie opslaan',
	'drafts-save-saved' => 'Opgeslagen',
	'drafts-save-saving' => 'Bezig met opslaan',
	'drafts-save-error' => 'Fout bij het opslaan van de werkversie',
	'tooltip-drafts-save' => 'Als werkversie opslaan',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 * @author Ranveig
 */
$messages['nn'] = array(
	'drafts' => 'Utkast',
	'drafts-desc' => 'Gjer det mogleg å lagra [[Special:Drafts|utkastsversjonar]] av ei sida på tenaren',
	'drafts-view' => 'Syna utkast',
	'drafts-view-summary' => 'Denne spesialsida syner ei lista over alle utkasta som finst frå før.
Unytta utkast vil verta vraka av seg sjølv etter {{PLURAL:$1|éin dag|$1 dagar}}.',
	'drafts-view-article' => 'Sida',
	'drafts-view-existing' => 'Eksisterande utkast',
	'drafts-view-saved' => 'Lagra',
	'drafts-view-discard' => 'Vrak',
	'drafts-view-nonesaved' => 'Du har ingen lagra utkast nett no.',
	'drafts-view-notice' => 'Du har $1 for denne sida.',
	'drafts-view-notice-link' => '{{PLURAL:$1|eitt utkast|$1 utkast}}',
	'drafts-view-warn' => 'Ved å navigera vekk frå denne sida vil du missa alle endringane på sida som ikkje er lagra.
Vil du halda fram?',
	'drafts-save' => 'Lagra dette som eit utkast',
	'drafts-save-save' => 'Lagra utkast',
	'drafts-save-saved' => 'Lagra',
	'drafts-save-saving' => 'Lagrar',
	'drafts-save-error' => 'Det oppstod ein feil under lagring av utkast',
	'tooltip-drafts-save' => 'Lagra som utkast',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'drafts' => 'Borrolhons',
	'drafts-desc' => 'Apond la possibilitat de salvar las versions « [[Special:Drafts|borrolhon]] » d’una pagina sul servidor',
	'drafts-view' => 'Veire lo borrolhon',
	'drafts-view-summary' => "Aquesta pagina especiala fa la lista de totes los borrolhons qu'existisson.
Los borrolhons inutilizats seràn suprimits automaticament aprèp $1 {{PLURAL:$1|jorn|jorns}}.",
	'drafts-view-article' => 'Pagina',
	'drafts-view-existing' => 'Borrolhons existents',
	'drafts-view-saved' => 'Salvar',
	'drafts-view-discard' => 'Abandonar',
	'drafts-view-nonesaved' => 'Avètz pas de borrolhon salvat actualament.',
	'drafts-view-notice' => 'Avètz $1 per aquesta pagina.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|borrolhon|borrolhons}}',
	'drafts-view-warn' => "En navigant en defòra d'aquesta pagina i perdretz totes los cambiaments pas salvats.",
	'drafts-save' => 'Salvatz aquò coma borrolhon',
	'drafts-save-save' => 'Salvar lo borrolhon',
	'drafts-save-saved' => 'Salvat',
	'drafts-save-saving' => 'Salvament en cors',
	'drafts-save-error' => 'Error de salvament del borrolhon',
	'tooltip-drafts-save' => 'Salvar coma borrolhon',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'drafts-view-article' => 'Blatt',
	'drafts-view-saved' => 'Bhalde',
	'drafts-view-notice' => 'Du hast $1 fer des Blatt.',
	'drafts-save-saved' => 'Bhalde',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Holek
 * @author Leinad
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'drafts' => 'Brudnopisy stron',
	'drafts-desc' => 'Dodaje możliwość zapisywania [[Special:Drafts|brudnopisów stron]] na serwerze',
	'drafts-view' => 'Zobacz brudnopis',
	'drafts-view-summary' => 'Ta strona specjalna prezentuje listę wszystkich brudnopisów stron.
Nieużywane brudnopisy zostaną automatycznie usunięte po $1 {{PLURAL:$1|dniu|dniach}}.',
	'drafts-view-article' => 'Strona',
	'drafts-view-existing' => 'Brudnopisy',
	'drafts-view-saved' => 'Zapisane',
	'drafts-view-discard' => 'Usuń',
	'drafts-view-nonesaved' => 'Nie masz obecnie zapisanych żadnych brudnopisów stron.',
	'drafts-view-notice' => 'Masz obecnie $1 tej strony.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|brudnopis|brudnopisy|brudnopisów}}',
	'drafts-view-warn' => 'Opuszczenie tej strony spowoduje utratę wszystkich niezapisanych zmian w jej treści.
Czy chcesz kontynuować?',
	'drafts-save' => 'Zapisuje jako brudnopis strony',
	'drafts-save-save' => 'Zapisz brudnopis',
	'drafts-save-saved' => 'Zapisany',
	'drafts-save-saving' => 'Zapisywanie',
	'drafts-save-error' => 'Błąd zapisywania brudnopisu strony',
	'tooltip-drafts-save' => 'Zapisz jako brudnopis strony',
);

/** Piedmontese (Piemontèis)
 * @author Dragonòt
 */
$messages['pms'] = array(
	'drafts' => 'Sbòss',
	'drafts-desc' => 'A gionta la possibilità ëd salvé vërsion [[Special:Drafts|sbòss]] ëd na pàgina an sël server',
	'drafts-view' => 'VardaSbòss',
	'drafts-view-summary' => "Sta pàgina special-sì a mosta na lista ëd tùit jë sbòss esistent.
Jë sbòss pa dovrà a saran scartà automaticament d'apress {{PLURAL:$1|$1 di|$1 di}}.",
	'drafts-view-article' => 'Pàgina',
	'drafts-view-existing' => 'Sbòss esistent',
	'drafts-view-saved' => 'Salvà',
	'drafts-view-discard' => 'Scartà',
	'drafts-view-nonesaved' => "It l'has pa gnun sbòss salvà an cost moment.",
	'drafts-view-notice' => "It l'ha $1 për sta pàgina-sì.",
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|sbòss|sbòss}}',
	'drafts-view-warn' => 'An navigand anans da sta pàgina-sì it përdras tùit ij cambi pa salvà a sta pàgina-sì.
It veus-to continué?',
	'drafts-save' => 'Salva sòn-sì com në sbòss',
	'drafts-save-save' => 'Salva sbòss',
	'drafts-save-saved' => 'Salvà',
	'drafts-save-saving' => 'An salvand',
	'drafts-save-error' => 'Eror an salvand sbòss',
	'tooltip-drafts-save' => 'Salva com në sbòss',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'drafts' => 'ګارلیکونه',
	'drafts-view-article' => 'مخ',
	'drafts-view-existing' => 'شته ګارليکونه',
	'drafts-view-notice' => 'د دې مخ لپاره تاسې $1 لرۍ.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|ګارليک|ګارليکونه}}',
	'drafts-save' => 'د يوه ګارليک په توګه خوندي کول',
	'drafts-save-save' => 'ګارليک خوندي کول',
	'drafts-save-saved' => 'خوندي شو',
	'drafts-save-saving' => 'د خوندي کېدلو په حال کې',
	'tooltip-drafts-save' => 'د يوه ګارليک په توګه خوندي کول',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Malafaya
 */
$messages['pt'] = array(
	'drafts' => 'Rascunhos',
	'drafts-desc' => 'Adiciona a possibilidade de gravar versões [[Special:Drafts|rascunho]] de uma página no servidor',
	'drafts-view' => 'Ver Rascunho',
	'drafts-view-summary' => 'Esta página especial mostra uma lista de todos os rascunhos existentes.
Rascunhos não usados serão descartados automaticamente após {{PLURAL:$1|$1 dia|$1 dias}}.',
	'drafts-view-article' => 'Página',
	'drafts-view-existing' => 'Rascunhos existentes',
	'drafts-view-saved' => 'Gravado',
	'drafts-view-discard' => 'Descartar',
	'drafts-view-nonesaved' => 'Não tem neste momento quaisquer rascunhos gravados.',
	'drafts-view-notice' => 'Tem $1 para esta página.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|rascunho|rascunhos}}',
	'drafts-view-warn' => 'Se navegar para fora desta página, perderá todas as alterações por gravar desta página.
Pretende continuar?',
	'drafts-save' => 'Gravar isto como rascunho',
	'drafts-save-save' => 'Gravar rascunho',
	'drafts-save-saved' => 'Gravado',
	'drafts-save-saving' => 'A gravar',
	'drafts-save-error' => 'Erro a gravar rascunho',
	'tooltip-drafts-save' => 'Gravar como rascunho',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'drafts' => 'Rascunhos',
	'drafts-desc' => 'Adiciona a possibilidade de gravar versões [[Special:Drafts|rascunho]] de uma página no servidor',
	'drafts-view' => 'Ver Rascunho',
	'drafts-view-summary' => 'Esta página especial mostra uma lista de todos os rascunhos existentes.
Rascunhos não usados serão descartados automaticamente após {{PLURAL:$1|1 dia|$1 dias}}.',
	'drafts-view-article' => 'Página',
	'drafts-view-existing' => 'Rascunhos existentes',
	'drafts-view-saved' => 'Gravado',
	'drafts-view-discard' => 'Descartar',
	'drafts-view-nonesaved' => 'Você não tem neste momento quaisquer rascunhos gravados.',
	'drafts-view-notice' => 'Você tem $1 para esta página.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|rascunho|rascunhos}}',
	'drafts-view-warn' => 'Se navegar para fora desta página, perderá todas as alterações por gravar desta página.
Deseja continuar?',
	'drafts-save' => 'Gravar isto como rascunho',
	'drafts-save-save' => 'Gravar rascunho',
	'drafts-save-saved' => 'Gravado',
	'drafts-save-saving' => 'Gravando',
	'drafts-save-error' => 'Erro ao gravar rascunho',
	'tooltip-drafts-save' => 'Gravar como rascunho',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Minisarm
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'drafts' => 'Schițe',
	'drafts-desc' => 'Adaugă posibilitatea de a salva pe server versiuni-[[Special:Drafts|schițe]] ale unei pagini',
	'drafts-view' => 'VizualizeazăSchiță',
	'drafts-view-summary' => 'Această pagină specială afișează o listă cu toate schițele existente.
Schițele nefolosite vor fi șterse automat după {{PLURAL:$1|$1 zi|$1 zile}}.',
	'drafts-view-article' => 'Pagină',
	'drafts-view-existing' => 'Schițe existente',
	'drafts-view-saved' => 'Salvat',
	'drafts-view-discard' => 'Respinge',
	'drafts-view-nonesaved' => 'Nu aveți vreo schiță salvată în acest moment.',
	'drafts-view-notice' => 'Aveți $1 pentru această pagină.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|ciornă|ciorne}}',
	'drafts-view-warn' => 'Dacă părăsiți această pagină veți pierde toate modificările nesalvate aduse paginii.
Doriți să continuați?',
	'drafts-save' => 'Salvează aceasta ca o schiță',
	'drafts-save-save' => 'Salvează schiță',
	'drafts-save-saved' => 'Salvat',
	'drafts-save-saving' => 'Salvare',
	'drafts-save-error' => 'Eroare la salvarea schiței',
	'tooltip-drafts-save' => 'Salvează ca schiță',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 * @author Reder
 */
$messages['roa-tara'] = array(
	'drafts' => 'Bozze',
	'drafts-view' => 'ViewDraft',
	'drafts-view-article' => 'Vosce',
	'drafts-view-existing' => 'Pruggette esistende',
	'drafts-view-saved' => 'Reggistrate',
	'drafts-view-discard' => 'Scitte',
	'drafts-view-nonesaved' => 'Non ge tène totte le pruggette salvate jndre stù momende.',
	'drafts-view-notice' => 'Tu tène $1 pè quèste pàgene.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|pruggette|pruggette}}',
	'drafts-save' => 'Salve quiste cumme bozze',
	'drafts-save-save' => "Salve 'a bozze",
	'drafts-save-saved' => 'Reggistrate',
	'drafts-save-saving' => 'Stoche a reggistre',
	'drafts-save-error' => "Errore de salvatagge d'u pruggette",
	'tooltip-drafts-save' => 'Salve cumme bozze',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'drafts' => 'Черновики',
	'drafts-desc' => 'Добавляет возможность сохранять [[Special:Drafts|черновики]] страниц на сервере',
	'drafts-view' => 'ПросмотрЧерновика',
	'drafts-view-summary' => 'На этой служебной странице приведён список всех черновиков.
Неиспользуемые черновики автоматически удаляются через $1 {{PLURAL:$1|день|дня|дней}}.',
	'drafts-view-article' => 'Страница',
	'drafts-view-existing' => 'Существующие черновики',
	'drafts-view-saved' => 'Сохранено',
	'drafts-view-discard' => 'Сбросить',
	'drafts-view-nonesaved' => 'В настоящее время у вас нет сохранённых черновиков.',
	'drafts-view-notice' => 'У вас $1 этой страницы.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|черновик|черновика|черновиков}}',
	'drafts-view-warn' => 'Уходя с этой страницы вы потеряете все несохранённые изменения.
Вы желаете продолжить?',
	'drafts-save' => 'Сохранить это как черновик',
	'drafts-save-save' => 'Сохранить черновик',
	'drafts-save-saved' => 'Сохранено',
	'drafts-save-saving' => 'Сохранение',
	'drafts-save-error' => 'Ошибка сохранения черновика',
	'tooltip-drafts-save' => 'Сохранить как черновик',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'drafts' => 'Концепты',
	'drafts-view' => 'Зобразити концепт',
	'drafts-view-article' => 'Сторінка',
	'drafts-view-existing' => 'Єстуючі концепты',
	'drafts-view-saved' => 'Уложене',
	'drafts-view-discard' => 'Змазати',
	'drafts-view-nonesaved' => 'Моментално не маєте уложены жадны концепты',
	'drafts-view-notice' => 'Маєте $1 той сторінкы.',
	'drafts-view-notice-link' => '$1 {{plural:$1|концепт|концепты|концептів}}',
	'drafts-view-warn' => 'Кідь одыйдете з той сторінкы, стратите вшыткы уложены зміны той сторінкы. Хочете продовжыти?',
	'drafts-save' => 'Уложыти тоту верзію як концепт',
	'drafts-save-save' => 'Уложыти концепт',
	'drafts-save-saved' => 'Уложене',
	'drafts-save-saving' => 'Укладать ся',
	'drafts-save-error' => 'Хыба почас укладаня концепту',
	'tooltip-drafts-save' => 'Уложыти як концепт',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'drafts' => 'Черновиктар',
	'drafts-desc' => 'Сирэй [[Special:Drafts|черновиктарын]] сиэрбэргэ уурары сатанар гынар',
	'drafts-view' => 'ЧерновиигыКөрүү',
	'drafts-view-summary' => 'Бу анал сирэйгэ черновиктар тиһиктэрэ көстөр.
Туттуллубат черновиктар {{PLURAL:$1|1 күн|$1 күн}} буола-буола сотуллан иһэллэр.',
	'drafts-view-article' => 'Сирэй',
	'drafts-view-existing' => 'Билигин баар черновиктар',
	'drafts-view-saved' => 'Сатанна',
	'drafts-view-discard' => 'Бырах/ыраастаа',
	'drafts-view-nonesaved' => 'Билигин кэлин туттарга хаалларыллыбыт черновигыҥ суох.',
	'drafts-view-notice' => 'Эйиэхэ сирэй $1 турар.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|черновик|черновиктар}}',
	'drafts-view-warn' => 'Бу сирэйтэн бардаххына бигэргэтиллибэтэх уларытыыларгын сүтэриэҥ.
Салгыыгын дуо?',
	'drafts-save' => 'Маны черновик быһыытынан хааллар',
	'drafts-save-save' => 'Черновигы кэлин туттарга хааллар',
	'drafts-save-saved' => 'Хаалларылынна',
	'drafts-save-saving' => 'Хаалларыы',
	'drafts-save-error' => 'Сатаан хаалларыллыбата',
	'tooltip-drafts-save' => 'Харатынан хааллар',
);

/** Sicilian (Sicilianu)
 * @author Aushulz
 */
$messages['scn'] = array(
	'drafts-view-article' => 'Pàggina',
	'drafts-view-saved' => 'Sarvata',
	'drafts-save-saved' => 'Sarvata',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'drafts' => 'Návrhy',
	'drafts-desc' => 'Pridáva možnosť uložiť na server verzie stránky ako [[Special:Drafts|návrhy]]',
	'drafts-view' => 'ZobraziťNávrh',
	'drafts-view-summary' => 'Táto špeciálna stránka zobrazuje zoznam všetkých existujúcich návrhov.
Nepoužité návrhy sa po {{PLURAL:$1|$1 dni|$1 dňoch}} automaticky zahodia.',
	'drafts-view-article' => 'Stránka',
	'drafts-view-existing' => 'Existujúce návrhy',
	'drafts-view-saved' => 'Uložené',
	'drafts-view-discard' => 'Zmazať',
	'drafts-view-nonesaved' => 'Momentálne nemáte uložené žiadne návrhy.',
	'drafts-view-notice' => 'Máte $1 tejto stránky.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|návrh|návrhy|návrhov}}',
	'drafts-view-warn' => 'Ak odídete z tejto stránky, stratíte všetky neuložené zmeny tejto stránky. Chcete pokračovať?',
	'drafts-save' => 'Uložiť túto verziu ako návrh',
	'drafts-save-save' => 'Uložiť návrh',
	'drafts-save-saved' => 'Uložené',
	'drafts-save-saving' => 'Ukladá sa',
	'drafts-save-error' => 'Chyba pri ukladaní návrhu',
	'tooltip-drafts-save' => 'Uložiť ako návrh',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'drafts' => 'Osnutki',
	'drafts-desc' => 'Doda zmožnost shranjevanja različic [[Special:Drafts|osnutkov]] strani na strežniku',
	'drafts-view' => 'Ogled osnutka',
	'drafts-view-summary' => 'Ta posebna stran prikazuje seznam vseh obstoječih osnutkov.
Neuporabljeni osnutki bodo samodejno zavrženi po $1 {{PLURAL:$1|dnevu|dneh}}.',
	'drafts-view-article' => 'Stran',
	'drafts-view-existing' => 'Obstoječi osnutki',
	'drafts-view-saved' => 'Shranjeno',
	'drafts-view-discard' => 'Zavrzi',
	'drafts-view-nonesaved' => 'Trenutno nimate shranjenih nobenih osnutkov.',
	'drafts-view-notice' => 'Imate $1 za to stran.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|osnutek|osnutka|osnutke|osnutkov}}',
	'drafts-view-warn' => 'Z odhodom iz te strani boste izgubili vse neshranjene spremembe na tej strani.
Ali želite nadaljevati?',
	'drafts-save' => 'Shrani kot osnutek',
	'drafts-save-save' => 'Shrani osnutek',
	'drafts-save-saved' => 'Shranjeno',
	'drafts-save-saving' => 'Shranjevanje',
	'drafts-save-error' => 'Napaka pri shranjevanju osnutka',
	'tooltip-drafts-save' => 'Shrani kot osnutek',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'drafts' => 'Нацрти',
	'drafts-view-article' => 'Страница',
	'drafts-view-existing' => 'Постојећи нацрти',
	'drafts-view-saved' => 'Сачувано',
	'drafts-view-discard' => 'Одбаци',
	'drafts-view-nonesaved' => 'Тренутно немате снимљених нацрта.',
	'drafts-view-notice' => 'Имате $1 за ову страну.',
	'drafts-save' => 'Сними ово као нацрт',
	'drafts-save-save' => 'Сними нацрт',
	'drafts-save-saved' => 'Сачувано',
	'drafts-save-saving' => 'Чување',
	'drafts-save-error' => 'Грешка приликом снимања нацрта',
	'tooltip-drafts-save' => 'Сними као нацрт',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬) */
$messages['sr-el'] = array(
	'drafts' => 'Nacrti',
	'drafts-view-article' => 'Strana',
	'drafts-view-existing' => 'Postojeći nacrti',
	'drafts-view-saved' => 'Snimljeno',
	'drafts-view-discard' => 'Odbaci',
	'drafts-view-nonesaved' => 'Trenutno nemate snimljenih nacrta.',
	'drafts-view-notice' => 'Imate $1 za ovu stranu.',
	'drafts-save' => 'Snimi ovo kao nacrt',
	'drafts-save-save' => 'Snimi nacrt',
	'drafts-save-saved' => 'Snimljeno',
	'drafts-save-saving' => 'Snimanje u toku',
	'drafts-save-error' => 'Greška prilikom snimanja nacrta',
	'tooltip-drafts-save' => 'Snimi kao nacrt',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Najami
 */
$messages['sv'] = array(
	'drafts' => 'Utkast',
	'drafts-desc' => 'Möjliggör att kunna spara [[Special:Drafts|utkastsversioner]] av en sida på servern',
	'drafts-view' => 'Visa utkast',
	'drafts-view-summary' => 'Denna specialsida visar en lista över alla utkast som finns.
Oanvända utkast kommer automatiskt att försvinna efter {{PLURAL:$1|$1 dag|$1 dagar}}.',
	'drafts-view-article' => 'Sida',
	'drafts-view-existing' => 'Existerande utkast',
	'drafts-view-saved' => 'Sparad',
	'drafts-view-discard' => 'Förkasta',
	'drafts-view-nonesaved' => 'Du har inga utkast sparade just nu.',
	'drafts-view-notice' => 'Du har $1 för denna sida.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|utkast|utkast}}',
	'drafts-view-warn' => 'Genom att navigera bort från denna sida kommer du förlora alla osparade ändringar för denna sida.
Vill du fortsätta?',
	'drafts-save' => 'Spara detta som ett utkast',
	'drafts-save-save' => 'Spara utkast',
	'drafts-save-saved' => 'Sparad',
	'drafts-save-saving' => 'Sparar',
	'drafts-save-error' => 'Fel vid sparande av utkast',
	'tooltip-drafts-save' => 'Spara som ett utkast',
);

/** Swahili (Kiswahili) */
$messages['sw'] = array(
	'drafts-view-article' => 'Ukurasa',
);

/** Tamil (தமிழ்)
 * @author TRYPPN
 */
$messages['ta'] = array(
	'drafts-view-article' => 'பக்கம்',
	'drafts-view-saved' => 'சேமிக்கப்பட்டது',
	'drafts-save-saved' => 'சேமிக்கப்பட்டது',
	'drafts-save-saving' => 'சேமிக்கப்படுகிறது',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'drafts' => 'చిత్తుప్రతులు',
	'drafts-view-article' => 'పేజీ',
	'drafts-view-existing' => 'ప్రస్తుత చిత్తుప్రతులు',
	'drafts-view-saved' => 'భద్రపరచినవి',
	'drafts-view-nonesaved' => 'ప్రస్తుతం మీరు భద్రపరచిన ప్రతులు ఏమీ లేవు.',
	'drafts-view-notice' => 'ఈ పుటకి మీకు $1.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|చిత్తుప్రతి ఉంది|చిత్తుప్రతులు ఉన్నాయి}}',
	'drafts-view-warn' => 'మీ పేజీని వదిలివెళ్ళడం ద్వారా ఈ పేజీలోని భద్రపరచని అన్ని మార్పులనీ కోల్పోతారు.
అయినా మీరు కొనసాగాలనుకుంటున్నరా?',
	'drafts-save' => 'దీన్ని చిత్తుప్రతిగా భద్రపరచు',
	'drafts-save-save' => 'చిత్తుప్రతిని భద్రపరచు',
	'drafts-save-saved' => 'భద్రమయ్యింది',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'drafts-view-article' => 'Pájina',
);

/** Thai (ไทย)
 * @author Woraponboonkerd
 */
$messages['th'] = array(
	'drafts-view-saved' => 'บันทึก',
	'drafts-view-discard' => 'ยกเลิก',
	'drafts-save-saved' => 'บันทึก',
	'drafts-save-saving' => 'กำลังบันทึก',
	'drafts-save-error' => 'เกิดความผิดพลาดในการบันทึกฉบับร่าง',
	'tooltip-drafts-save' => 'บันทึกเป็นฉบับร่าง',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'drafts' => 'Garalamalar',
	'drafts-desc' => 'Sahypanyň [[Special:Drafts|garalama]] wersiýasyny serwere ýazdyrmak mümkinçiligini goşýar',
	'drafts-view' => 'GaralamaGörkez',
	'drafts-view-summary' => 'Bu ýörite sahypa bar bolan ähli garalamalaryň sanawyny görkezýär.
Ulanylmaýan garalamalar $1 {{PLURAL:$1|gün|gün}} geçensoň awtomatik öçüriler.',
	'drafts-view-article' => 'Sahypa',
	'drafts-view-existing' => 'Bar bolan garalamalar',
	'drafts-view-saved' => 'Ýazdyryldy',
	'drafts-view-discard' => 'Öçür',
	'drafts-view-nonesaved' => 'Häzirki wagtda ýazdyrylan hiç hili garalamaňyz ýok.',
	'drafts-view-notice' => 'Bu sahypa üçin $1 bar.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|garalamaňyz|garalamaňyz}}',
	'drafts-view-warn' => 'Bu sahypadan gitseňiz, sahypadaky ähli ýazdyrylmadyk üýtgeşmeleri ýitirersiňiz.
Dowam etmek isleýärsiňizmi?',
	'drafts-save' => 'Muny garalama hökmünde ýazdyr',
	'drafts-save-save' => 'Garalamany ýazdyr',
	'drafts-save-saved' => 'Ýazdyryldy',
	'drafts-save-saving' => 'Ýazdyrylýar',
	'drafts-save-error' => 'Garalama ýazdyrma säwligi',
	'tooltip-drafts-save' => 'Garalama hökmünde ýazdyr',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'drafts' => 'Mga balangkas',
	'drafts-desc' => 'Nagdaragdag ng kakayahang makapagsagip ng mga bersyon [[Special:Drafts|ng balangkas]] ng isang pahina sa loob ng serbidor',
	'drafts-view' => 'TingnanBalangkas',
	'drafts-view-summary' => 'Nagpapakita ang natatanging pahinang ito ng isang talaan ng lahat ng umiiral na mga balangkas.
Kusang itatapon na ang hindi nagagamit na mga balangkas pagkaraan ng {{PLURAL:$1|$1 araw|$1 mga araw}}.',
	'drafts-view-article' => 'Pahina',
	'drafts-view-existing' => 'Umiiral na mga balangkas',
	'drafts-view-saved' => 'Nasagip na',
	'drafts-view-discard' => 'Itapon (ibasura)',
	'drafts-view-nonesaved' => 'Wala kang nakasagip na kahit na anong mga balangkas sa ngayon.',
	'drafts-view-notice' => 'Mayroon kang $1 para sa pahinang ito.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|balangkas|mga balangkas}}',
	'drafts-view-warn' => 'Sa pamamagitan ng paglalayag papalayo mula sa pahinang ito, mawawala ang lahat ng hindi nakasagip na mga pagbabago mo para sa pahinang ito.
Nais mo bang magpatuloy?',
	'drafts-save' => 'Sagipin ito bilang isang balangkas',
	'drafts-save-save' => 'Sagipin ang balangkas',
	'drafts-save-saved' => 'Nasagip na',
	'drafts-save-saving' => 'Sinasagip',
	'drafts-save-error' => 'May kamalian sa pagsasagip ng balangkas',
	'tooltip-drafts-save' => 'Sinagip bilang isang balangkas',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Stultiwikia
 */
$messages['tr'] = array(
	'drafts' => 'Taslaklar',
	'drafts-desc' => 'Bir sayfanın [[Special:Drafts|taslak]] sürümünü sunucuya kaydetme özelliğini ekler',
	'drafts-view' => 'TaslağıGör',
	'drafts-view-summary' => 'Bu özel sayfa tüm mevcut taslakların bir listesini gösterir.
Kullanılmayan taslaklar $1 {{PLURAL:$1|gün|gün}} sonra otomatik olarak silinir.',
	'drafts-view-article' => 'Madde',
	'drafts-view-existing' => 'Mevcut taslaklar',
	'drafts-view-saved' => 'Kaydedildi',
	'drafts-view-discard' => 'Sil',
	'drafts-view-nonesaved' => 'Şu anda kayıtlı hiçbir taslağınız yok.',
	'drafts-view-notice' => 'Bu sayfa için $1 var.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|taslağınız|taslağınız}}',
	'drafts-view-warn' => 'Bu sayfadan ayrılarak, sayfadaki tüm kaydedilmemiş değişiklikleri kaybedeceksiniz.
Devam etmek istiyor musunuz?',
	'drafts-save' => 'Bunu taslak olarak kaydet',
	'drafts-save-save' => 'Taslağı kaydet',
	'drafts-save-saved' => 'Kaydedildi',
	'drafts-save-saving' => 'Kaydediliyor',
	'drafts-save-error' => 'Taslağı kaydederken hata',
	'tooltip-drafts-save' => 'Taslak olarak kaydet',
);

/** Uyghur (Latin script) (Uyghurche‎)
 * @author Jose77
 */
$messages['ug-latn'] = array(
	'drafts-view-article' => 'Bet',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 */
$messages['uk'] = array(
	'drafts' => 'Чернетки',
	'drafts-desc' => 'Додає можливість зберігання [[Special:Drafts|чернеток]] сторінок на сервері',
	'drafts-view' => 'ПереглядЧернетки',
	'drafts-view-summary' => 'На цій спеціальній сторінці показаний список усіх чернеток.
Невикористані чернетки автоматично вилучаються через $1 {{PLURAL:$1|день|дні|днів}}.',
	'drafts-view-article' => 'Сторінка',
	'drafts-view-existing' => 'Наявні чернетки',
	'drafts-view-saved' => 'Збережено',
	'drafts-view-discard' => 'Відкинути',
	'drafts-view-nonesaved' => 'На даний момент ви не маєте збережених чернеток.',
	'drafts-view-notice' => 'Ви маєте $1 цієї сторінки.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|чернетку|чернетки|чернеток}}',
	'drafts-view-warn' => 'При виході з цієї сторінки ви втратите усі незбережені дані.
Бажаєте продовжити?',
	'drafts-save' => 'Зберегти це як чернетку',
	'drafts-save-save' => 'Зберегти чернетку',
	'drafts-save-saved' => 'Збережено',
	'drafts-save-saving' => 'Зберігаю',
	'drafts-save-error' => 'Помилка збереження чернетки',
	'tooltip-drafts-save' => 'Зберегти як чернетку',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'drafts' => 'Bozze',
	'drafts-desc' => 'Zonta la possibilità de salvar sul server na version de [[Special:Drafts|bozza]] de na pàxena',
	'drafts-view' => 'VardaBozza',
	'drafts-view-summary' => 'Sta pàxena speciale la mostra na lista de tute le bozze esistenti.
Le bozze mia doparà le vegnarà scancelà automaticamente dopo {{PLURAL:$1|$1 zòrno|$1 zòrni}}.',
	'drafts-view-article' => 'Pàxena',
	'drafts-view-existing' => 'Bozze esistenti',
	'drafts-view-saved' => 'Salvà',
	'drafts-view-discard' => 'Scancela',
	'drafts-view-nonesaved' => 'No ti gà nissuna bozza salvà in sto momento.',
	'drafts-view-notice' => 'Ti gà $1 de sta pàxena',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|bozza|bozze}}',
	'drafts-view-warn' => "'Ndando fora de sta pàxena te perdarè tute quante le modìfeghe che no ti gà salvà.
Vuto continuar?",
	'drafts-save' => 'Salva come bozza',
	'drafts-save-save' => 'Salva bozza',
	'drafts-save-saved' => 'Salvà',
	'drafts-save-saving' => 'Drio salvar',
	'drafts-save-error' => 'Eròr in tel salvatajo de la bozza',
	'tooltip-drafts-save' => 'Salva come bozza',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'drafts-view-article' => "Lehtpol'",
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'drafts' => 'Bản thảo',
	'drafts-desc' => 'Thêm khả năng lưu các phiên bản [[Special:Drafts|bản thảo]] của trang trên máy chủ',
	'drafts-view' => 'Xem bản thảo',
	'drafts-view-summary' => 'Trang đặc biệt này hiển thị một danh sách tất cả các bản thảo hiện có.
Các bản thảo không được sử dụng sẽ được tự động bỏ đi sau {{PLURAL:$1|$1 ngày|$1 ngày}}.',
	'drafts-view-article' => 'Trang',
	'drafts-view-existing' => 'Bản thảo hiện tại',
	'drafts-view-saved' => 'Đã lưu',
	'drafts-view-discard' => 'Loại bỏ',
	'drafts-view-nonesaved' => 'Bạn không có bất kỳ bản thảo lưu trữ nào vào lúc này.',
	'drafts-view-notice' => 'Bạn có $1 cho trang này.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|bản thảo|bản thảo}}',
	'drafts-view-warn' => 'Nếu tắt trang này bạn sẽ mất toàn bộ các thay đổi chưa lưu đối với trang.
Bạn có muốn tiếp tục?',
	'drafts-save' => 'Lưu bản này làm bản thảo',
	'drafts-save-save' => 'Lưu bản thảo',
	'drafts-save-saved' => 'Đã lưu',
	'drafts-save-saving' => 'Đang lưu',
	'drafts-save-error' => 'Lỗi khi lưu bản thảo',
	'tooltip-drafts-save' => 'Lưu làm bản thảo',
);

/** Volapük (Volapük)
 * @author Malafaya
 */
$messages['vo'] = array(
	'drafts' => 'Rigets',
	'drafts-view-article' => 'Pad',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'drafts-view-article' => 'בלאַט',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Chenxiaoqino
 * @author Gzdavidwong
 * @author Hydra
 * @author Wmr89502270
 */
$messages['zh-hans'] = array(
	'drafts' => '草稿',
	'drafts-desc' => '添加要在服务器上保存页面的 [[Special:Drafts|草案]] 版本的能力',
	'drafts-view' => '查看草稿',
	'drafts-view-summary' => '此特殊页显示一个列表中的所有现有的草稿。
未使用的草稿以后就会在{{PLURAL：$1|$1天|$1天}}自动被删除。',
	'drafts-view-article' => '页面',
	'drafts-view-existing' => '现有草稿',
	'drafts-view-saved' => '已保存',
	'drafts-view-discard' => '舍弃',
	'drafts-view-nonesaved' => '您还没有任何已保存的草稿。',
	'drafts-view-notice' => '您有$1供此页。',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|草稿|草稿}}',
	'drafts-view-warn' => '如果你离开这页，你将会失去你的更改。
你想继续吗？',
	'drafts-save' => '把此页面以草稿形式保存',
	'drafts-save-save' => '保存草稿',
	'drafts-save-saved' => '已保存',
	'drafts-save-saving' => '保存中',
	'drafts-save-error' => '保存草稿时发生错误',
	'tooltip-drafts-save' => '以草稿形式保存',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Gzdavidwong
 * @author Horacewai2
 * @author Liangent
 * @author Mark85296341
 * @author Waihorace
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'drafts' => '草稿',
	'drafts-desc' => '新增要在伺服器上儲存頁面的 [[Special:Drafts|草案]] 版本的能力',
	'drafts-view' => '檢視草稿',
	'drafts-view-summary' => '此特殊頁面顯示一個列表中的所有現有的草稿。
未使用的草稿以後就會在{{PLURAL:$1|$1天|$1天}}自動被刪除。',
	'drafts-view-article' => '頁面',
	'drafts-view-existing' => '現有草稿',
	'drafts-view-saved' => '已儲存',
	'drafts-view-discard' => '捨棄',
	'drafts-view-nonesaved' => '您還沒有任何已保存的草稿。',
	'drafts-view-notice' => '您有$1供此頁。',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|草稿|草稿}}',
	'drafts-view-warn' => '如果你離開這頁，你將會失去你的更改。
你想繼續嗎？',
	'drafts-save' => '把此頁面以草稿形式儲存',
	'drafts-save-save' => '儲存草稿',
	'drafts-save-saved' => '已儲存',
	'drafts-save-saving' => '儲存中',
	'drafts-save-error' => '儲存草稿時發生錯誤',
	'tooltip-drafts-save' => '以草稿形式儲存',
);

