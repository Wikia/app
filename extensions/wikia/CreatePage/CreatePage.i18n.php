<?php
/**
 * CreatePage extension message file
 */

$messages = array();

$messages['en'] = array(
	'createpage-desc' => 'Allows to create a new page using Fandom\'s WYSIWYG editor',
	'createpage-sp-title' => 'Create a new page',
	'createpage_title' => 'Create a new page',
	'createpage_title_caption' => 'Title',
	'createpage_enter_text' => 'Text:',
	'createpage_empty_title_error' => 'Title required',
	'createpage_empty_article_body_error' => 'Page text required',
	'createpage_invalid_title_error' => 'Invalid title',
	'createpage_article_already_exists' => 'A page with that name already exists.
Please select different name.',
	'createpage_spam' => 'Sorry, your edit could not be saved',
	'createpage_cant_edit' => 'Could not perform edit',
	'createpage-dialog-title' => 'Create a new page',
	'createpage-dialog-message1' => 'Hooray, you are creating a new page!',
	'createpage-dialog-message2' => 'What do you want to call it?',
	'createpage-dialog-choose' => 'Choose a page layout:',
	'createpage-dialog-format' => 'Standard layout',
	'createpage-dialog-blank' => 'Blank page',
	'createpage-error-empty-title' => 'Please write a title for your page',
	'createpage-error-invalid-title' => 'Sorry, the page title was invalid.
Please use a different title.',
	'createpage-error-article-exists' => 'A page with that title already exists.
You can go to <a href="$1">$2</a>, or rename your page',
	'createpage-error-article-spam' => 'Sorry, the page title was rejected by our spam filter.
Please use a different title.',
	'createpage-error-article-blocked' => 'Sorry, you are unable to create that page at this time.',
	'tog-createpagedefaultblank' => 'Use a blank page as default for creating a new page',
	'tog-createpagepopupdisabled' => 'Disable "Create a new article" flow (Not Recommended)',

	'newpagelayout' => '[[File:Placeholder|right|300px]]
Write the first paragraph of your page here.

==Section heading==

Write the first section of your page here.

==Section heading==

Write the second section of your page here.', // Doesn't include video placeholder, and is overridden on messages wiki

	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Write the first paragraph of your page here.

==Section heading==

Write the first section of your page here.

==Section heading==

Write the second section of your page here.', // Does include video placeholder, and is overridden on messages wiki
	'createpage-ve-body' => 'The article <b>$1</b> does not yet exist on this Fandom. You can help out by adding a few sentences.',
	'createpage-button-cancel' => 'Cancel',
);

/** Message documentation (Message documentation)
 * @author The Evil IP address
 */
$messages['qqq'] = array(
	'createpage-desc' => '{{desc}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'createpage-sp-title' => "Skep 'n nuwe bladsy",
	'createpage_title' => "Skep 'n nuwe artikel",
	'createpage_title_caption' => 'Bladsynaam:', # Fuzzy
	'createpage_enter_text' => 'Teks:',
	'createpage_empty_title_error' => "'n Bladsynaam is verpligtend",
	'createpage_empty_article_body_error' => 'Bladsyteks is verpligtend',
	'createpage_invalid_title_error' => 'Ongeldige bladsynaam',
	'createpage_article_already_exists' => "Daar bestaan reeds 'n bladsy met hierdie naam.
Kies asseblief 'n ander naam.",
	'createpage_spam' => 'Jammer, u wysiging kon nie gestoor word nie',
	'createpage_cant_edit' => 'Dit was nie moontlik om die wysiging uit te voer nie',
	'createpage-dialog-title' => "Skep 'n nuwe bladsy",
	'createpage-dialog-message1' => "Veels geluk.
U is besig om 'n nuwe bladsy te skep!",
	'createpage-dialog-message2' => 'Wat wil u die bladsy noem?',
	'createpage-dialog-choose' => "Kies 'n bladuitleg:",
	'createpage-dialog-format' => 'Standaard uitleg',
	'createpage-dialog-blank' => 'Leë bladsy',
	'createpage-error-empty-title' => "Verskaf asseblief 'n naam vir u bladsy",
	'createpage-error-invalid-title' => "Jammer, die bladsynaam was ongeldig.
Gebruik asseblief 'n ander naam.",
	'createpage-error-article-exists' => 'Daar bestaan al reeds \'n bladsy met die naam.
U kan na "<a href="$1">$2</a>" gaan of u bladsy \'n ander naam gee',
	'createpage-error-article-spam' => "Jammer, die bladsynaam is deur ons SPAM-filter verwerp.
Gebruik asseblief 'n ander naam.",
	'createpage-error-article-blocked' => 'Jammer, maar u kan nie die bladsye op die oomblik skep nie.',
	'tog-createpagedefaultblank' => "Gebruik 'n leë bladsy as standaard vir die skep van nuwe bladsye",
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Skryf die eerste paragraaf van u artikel hier.

==Opskrif==
Skryf die eerste afdeling van u bladsy hier.

==Opskrif==
Skryf die tweede afdeling van u bladsy hier.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Skryf die eerste paragraaf van u artikel hier.

==Opskrif==
Skryf die eerste afdeling van u bladsy hier.

==Opskrif==
Skryf die tweede afdeling van u bladsy hier.',
);

/** Arabic (العربية)
 * @author Achraf94
 * @author Alexknight12
 * @author OsamaK
 */
$messages['ar'] = array(
	'createpage-sp-title' => 'إنشاء صفحة جديدة',
	'createpage_title' => 'أنشئ مقالة جديدة',
	'createpage_title_caption' => 'العنوان', # Fuzzy
	'createpage_enter_text' => 'النص:',
	'createpage_empty_title_error' => 'العنوان مطلوب',
	'createpage_empty_article_body_error' => 'نص المقالة مطلوب',
	'createpage_invalid_title_error' => 'عنوان غير صالح',
	'createpage_article_already_exists' => 'هناك مقالة بذلك الاسم.
الرجاء إختيار اسم آخر.',
	'createpage_spam' => 'عذرا، تحريرك لا يمكن تسجيله',
	'createpage_cant_edit' => 'لا يمكن إجراء التعديل',
	'createpage-dialog-title' => 'إنشاء صفحة جديدة',
	'createpage-dialog-message1' => 'مرحى! أنت تنشئ صفحة جديدة!',
	'createpage-dialog-message2' => 'ماذا تريد تمسيتها؟',
	'createpage-dialog-choose' => 'إختر تخطيط الصفحة:',
	'createpage-dialog-format' => 'تخطيط عادي',
	'createpage-dialog-blank' => 'صفحة فارغة',
	'createpage-error-empty-title' => 'الرجاء كتابة عنوان لمقالك',
	'createpage-error-invalid-title' => 'عذرا، المقالة غير صالحة.
الرجاء استخدام عنوان مختلف.',
	'createpage-error-article-exists' => 'مقالة بذلك العنوان موجودة.
يمكنك أن تزور <a href="$1">$2</a>، أو إعادة تسميتها',
	'createpage-error-article-spam' => 'عذرا، عنوان المقالة تم رفضه من قبل فلتر الإزعاج لدينا.
الرجاء اختيار عنوان آخر.',
	'createpage-error-article-blocked' => 'آسف، أنت غير قادر على إنشاء ذلك المقال حاليا.',
	'tog-createpagedefaultblank' => 'استخدم الصفحة الفارغة افتراضيا لإنشاء صفحة جديدة',
	'tog-createpagepopupdisabled' => 'تعطيل إنبثاق منشئ الصفحات', # Fuzzy
	'newpagelayout' => '[[ملف:Placeholder|يسار|300بك]]
قم بكتابة الفقرة الأولى من المقالة هنا.

==عنوان القسم==

كتابة عنوان المقطع الأول من مقالك هنا.

==عنوان القسم==

كتابة عنوان المقطع الثاني من مقالك هنا.',
	'createpage-with-video' => '[[ملف:Placeholder|video|right|300px]] [[ملف:Placeholder|يسار|300بك]]
قم بكتابة الفقرة الأولى من المقالة هنا.

==عنوان القسم==

كتابة عنوان المقطع الأول من مقالك هنا.

==عنوان القسم==

كتابة عنوان المقطع الثاني من مقالك هنا.',);

/** Assamese (অসমীয়া)
 * @author Bishnu Saikia
 */
$messages['as'] = array(
	'createpage-sp-title' => 'এখন নতুন পৃষ্ঠা সৃষ্টি কৰক',
	'createpage_title' => 'এখন নতুন পৃষ্ঠা সৃষ্টি কৰক',
	'createpage_title_caption' => 'শীৰ্ষক',
	'createpage_enter_text' => 'পাঠ্য:',
	'createpage_empty_title_error' => 'শিৰোনামাৰ প্ৰয়োজন',
	'createpage_invalid_title_error' => 'ভুল শীৰ্ষক',
	'createpage-dialog-title' => 'এখন নতুন পৃষ্ঠা সৃষ্টি কৰক',
	'createpage-dialog-blank' => 'উকা পৃষ্ঠা',
);

/** Azerbaijani (azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'createpage_title_caption' => 'Başlıq:', # Fuzzy
	'createpage_enter_text' => 'Mətn:',
);

/** South Azerbaijani (تورکجه)
 * @author Arjanizary
 * @author E THP
 */
$messages['azb'] = array(
	'createpage-sp-title' => 'یئنی یارپاق یارات',
	'createpage_title' => 'یئنی صحیفه یارات',
	'createpage_title_caption' => 'باشلیق',
	'createpage_enter_text' => 'متن:',
	'createpage_empty_title_error' => 'باشلیق گرکن‌دیر',
	'createpage_invalid_title_error' => 'گئچرسیز آد',
	'createpage-dialog-title' => 'یئنی یارپاق یارات',
	'createpage-dialog-blank' => 'بوش یارپاق',
	'createpage-error-empty-title' => 'لوطفا یارپاغیزا بیر آد یازین',
);

/** Bashkir (башҡортса)
 * @author Рустам Нурыев
 */
$messages['ba'] = array(
	'createpage_enter_text' => 'Текст:',
);

/** Bulgarian (български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'createpage-desc' => 'Позволява създаване на нова страница чрез визуалния редактор на Wikia',
	'createpage-sp-title' => 'Създаване на нова страница',
	'createpage_title' => 'Създаване на нова страница',
	'createpage_title_caption' => 'Заглавие',
	'createpage_enter_text' => 'Текст:',
	'createpage_invalid_title_error' => 'Невалидно заглавие',
	'createpage_spam' => 'За съжаление редакцията ви не можа да бъде съхранена',
	'createpage-dialog-title' => 'Създаване на нова страница',
	'createpage-dialog-choose' => 'Избиране на облик на страницата:',
	'createpage-dialog-format' => 'Стандартен облик',
	'createpage-dialog-blank' => 'Празна страница',
	'createpage-error-article-exists' => 'Вече съществува страница с това име.
Можете да отидете на <a href="$1">$2</a> или да преименувате вашата страница',
	'tog-createpagedefaultblank' => 'По подразбиране използване на празна страница при създаване на нова страница',
);

/** Breton (brezhoneg)
 * @author Gwenn-Ael
 * @author Y-M D
 */
$messages['br'] = array(
	'createpage-desc' => 'Talvezout a ra da grouiñ ur bajenn nevez en ur implijout aozer WYSIWYG Wikia',
	'createpage-sp-title' => 'Krouiñ ur pennad nevez',
	'createpage_title' => 'Krouiñ ur pennad nevez',
	'createpage_title_caption' => 'Titl',
	'createpage_enter_text' => 'Testenn :',
	'createpage_empty_title_error' => "Ezhomm 'zo eus un titl",
	'createpage_empty_article_body_error' => "Ezhomm 'zo eus testenn ar pennad",
	'createpage_invalid_title_error' => 'Titl direizh',
	'createpage_article_already_exists' => 'Ur pennad gant an anv-se a zo dija.
Mar plij dibabit un anv disheñvel',
	'createpage_spam' => "Digarezit, n'eo ket bet enrollet ho kemmoù",
	'createpage_cant_edit' => "Dibosupl eo seveniñ ar c'hemm",
	'createpage-dialog-title' => 'Krouiñ ur Pennad Nevez',
	'createpage-dialog-message1' => "Youc'hou, emaoc'h o krouiñ ur bajenn nevez !",
	'createpage-dialog-message2' => "Penaos hoc'h eus c'hoant envel anezhi ?",
	'createpage-dialog-choose' => 'Dibabit ur bajennaozañ :',
	'createpage-dialog-format' => 'Kinnig boaz',
	'createpage-dialog-blank' => "Pajenn c'houllo",
	'createpage-error-empty-title' => 'Mar plij lakait un titl evit ho pennad',
	'createpage-error-invalid-title' => 'Digarezit, ne oa ket mat titl ar pennad.
Mar plij dibabit un titl disheñvel.',
	'createpage-error-article-exists' => 'Bez ez eus dija eus ur pennad gant an anv-se.
Gellout a rit mont da <a href="$1">$2,</a> pe adenvel ho pajenn',
	'createpage-error-article-spam' => "Digarezit, nac'het eo bet titl ar pennad gant hon sil ar stroboù.
Mar plij implijit un titl disheñvel.",
	'createpage-error-article-blocked' => "Digarezit, ne c'helloc'h ket krouiñ ar pennad-se er mare-mañ.",
	'tog-createpagedefaultblank' => "Implijout ur bajenn c'houllo dre ziouer evit krouiñ ur bajenn nevez",
	'tog-createpagepopupdisabled' => 'Diweredekaat ar wazh "Krouiñ ur pennad nevez" (N\'eo ket erbedet)',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Skrivit amañ rannbennad kentañ ho pennad.

== Titl ar rannskrid ==

Skrivit amañ rannskrid kentañ ho pennad.

== Titl ar rannskrid ==

Skrivit amañ eil rannskrid ho pennad.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Skrivit amañ rannbennad kentañ ho pennad.

== Titl ar rannskrid ==

Skrivit amañ rannskrid kentañ ho pennad.

== Titl ar rannskrid ==

Skrivit amañ eil rannskrid ho pennad.',
);

/** Catalan (català)
 * @author BroOk
 * @author Ciencia Al Poder
 */
$messages['ca'] = array(
	'createpage-desc' => "Permet crear una pàgina nova utilitzant l'editor WYSIWYG de Wikia",
	'createpage-sp-title' => 'Crea una pàgina nova',
	'createpage_title' => 'Crea una pàgina nova',
	'createpage_title_caption' => 'Títol',
	'createpage_enter_text' => 'Text:',
	'createpage_empty_title_error' => 'Títol requerit',
	'createpage_empty_article_body_error' => 'Text de la pàgina requerit',
	'createpage_invalid_title_error' => 'Títol no vàlid',
	'createpage_article_already_exists' => 'Ja existeix una pàgina amb aquest nom.
Si us plau, tria un nom diferent.',
	'createpage_spam' => "Ho sentim, l'edició no s'ha pogut guardar",
	'createpage_cant_edit' => "No s'ha pogut realitzar l'edició",
	'createpage-dialog-title' => 'Crea una pàgina nova',
	'createpage-dialog-message1' => 'Visca, has creat una pàgina nova!',
	'createpage-dialog-message2' => 'Com li vols dir?',
	'createpage-dialog-choose' => 'Trieu un disseny de pàgina:',
	'createpage-dialog-format' => 'Disseny estàndard',
	'createpage-dialog-blank' => 'Pàgina en blanc',
	'createpage-error-empty-title' => 'Si us plau, escriu un títol per la pàgina',
	'createpage-error-invalid-title' => 'Ho sentim, el títol de la pàgina no és vàlid!
Si us plau, utilitzeu un títol diferent.',
	'createpage-error-article-exists' => 'Ja existeix una pàgina amb aquest títol.
Pots anar a <a href="$1">$2</a> o canviar el nom de la pàgina',
	'createpage-error-article-spam' => "Ho sentim, el títol de pàgina ha estat rebutjat pel nostre filtre d'spam.
Si us plau, utilitzeu un títol diferent.",
	'createpage-error-article-blocked' => 'Ho sentim, no pots crear aquesta pàgina en aquest moment.',
	'tog-createpagedefaultblank' => "Utilitzeu una pàgina en blanc per defecte per a la creació d'una nova pàgina",
	'tog-createpagepopupdisabled' => 'Desactivar el procés "Crear una pàgina nova" (no recomanat)',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Escriu el primer paràgraf de la pàgina aquí.

== Encapçalament ==

Escriu la primera secció de la pàgina aquí.

== Encapçalament ==

Escriu la segona secció de la pàgina aquí.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Escriu el primer paràgraf de la pàgina aquí.

== Encapçalament ==

Escriu la primera secció de la pàgina aquí.

== Encapçalament ==

Escriu la segona secció de la pàgina aquí.',
);

/** Czech (česky)
 * @author Darth Daron
 */
$messages['cs'] = array(
	'createpage-desc' => 'Umožňuje vytvořit novou stránku pomocí WYSIWYG editoru.',
	'createpage-sp-title' => 'Vytvořit novou stránku',
	'createpage_title' => 'Vytvořit novou stránku',
	'createpage_title_caption' => 'Název',
	'createpage_enter_text' => 'Text:',
	'createpage_empty_title_error' => 'Název povinný',
	'createpage_empty_article_body_error' => 'Text stránky povinný',
	'createpage_invalid_title_error' => 'Neplatný název',
	'createpage_article_already_exists' => 'Stránka s tímto názvem již existuje.
Vyberte prosím jiný název.',
	'createpage_spam' => 'Omlouváme se, ale vaše úpravy nelze uložit.',
	'createpage_cant_edit' => 'Nelze provést úpravy',
	'createpage-dialog-title' => 'Vytvořit novou stránku',
	'createpage-dialog-message1' => 'Hurá, vytváříte novou stránku!',
	'createpage-dialog-message2' => 'Jaký je název článku?',
	'createpage-dialog-choose' => 'Zvolte rozvržení stránky:',
	'createpage-dialog-format' => 'Standardní rozložení',
	'createpage-dialog-blank' => 'Prázdná stránka',
	'createpage-error-empty-title' => 'Prosím, zadejte název vaší stánky.',
	'createpage-error-invalid-title' => 'Omlovuáme se, ale název stránky je neplatný.
Použijte prosím jiný název.',
	'createpage-error-article-exists' => 'Stránka s tímto názvem již existuje.
Můžete jít na <a href="$1">$2</a> nebo přejmenovat vaši stránku.',
	'createpage-error-article-spam' => 'Omlouváme se, ale název stránky byl odmítnut naším spamovým filtrem.
Použijte prosím jiný název.',
	'createpage-error-article-blocked' => 'Omlouváme se, ale v současné době nemůžete vytvořit tuto stránku.',
	'tog-createpagedefaultblank' => 'Použijte prázdnou stránku jako výchozí pro vytvoření nové stránky',
	'tog-createpagepopupdisabled' => 'Zakázat "Vytvořit nový článek" dialog (nedoporučeno)',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Sem napište první odstavec.

==Nadpis části==

Sem napište první část stránky.

==Nadpis části==

Sem napište druhou část stránky.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Sem napište první odstavec.

==Nadpis části==

Sem napište první část stránky.

==Nadpis části==

Sem napište druhou část stránky.',
);

/** German (Deutsch)
 * @author Inkowik
 * @author LWChris
 * @author Quedel
 * @author The Evil IP address
 */
$messages['de'] = array(
	'createpage-desc' => "Erlaubt das Erstellen von neuen Seiten mit Wikia's WYSIWYG-Editor",
	'createpage-sp-title' => 'Neue Seite anlegen',
	'createpage_title' => 'Neue Seite anlegen',
	'createpage_title_caption' => 'Titel:',
	'createpage_enter_text' => 'Text:',
	'createpage_empty_title_error' => 'Titel erforderlich',
	'createpage_empty_article_body_error' => 'Artikeltext erforderlich',
	'createpage_invalid_title_error' => 'Ungültiger Titel',
	'createpage_article_already_exists' => 'Ein Artikel mit diesem Namen existiert bereits.
Bitte wähle einen anderen Namen.',
	'createpage_spam' => 'Tut uns leid, deine Bearbeitung konnte nicht gespeichert werden',
	'createpage_cant_edit' => 'Konnte die Bearbeitung nicht durchführen',
	'createpage-dialog-title' => 'Erstelle einen neuen Artikel',
	'createpage-dialog-message1' => 'Du erstellst einen neuen Artikel!',
	'createpage-dialog-message2' => 'Wie soll der Artikel heißen?',
	'createpage-dialog-choose' => 'Wähle ein Seitenlayout aus:',
	'createpage-dialog-format' => 'Vorformatiert',
	'createpage-dialog-blank' => 'Leere Seite',
	'createpage-error-empty-title' => 'Bitte gib einen Titel für den Artikel an',
	'createpage-error-invalid-title' => 'Ungültiger Titel. Bitte wähle einen gültigen Titel.',
	'createpage-error-article-exists' => 'Ein Artikel mit dem selben Titel existiert bereits. Gehe zu <a href="$1">$2</a> oder wähle einen anderen Titel',
	'createpage-error-article-spam' => 'Der Titel wurde vom Spamfilter blockiert, bitte wähle einen anderen.',
	'createpage-error-article-blocked' => 'Du kannst im Moment keinen Artikel erstellen.',
	'tog-createpagedefaultblank' => 'Wähle „Leere Seite“ als Standard bei Erstellung neuer Seiten',
	'tog-createpagepopupdisabled' => 'Seite erstellen-Hinweis deaktivieren (Nicht empfohlen)',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Schreibe den ersten Absatz deines Artikels hier.

==Überschrift des Abschnittes==

Schreibe den ersten Abschnitt deines Artikels hier.

==Überschrift des Abschnittes==

Schreibe den zweiten Abschnitt deines Artikels hier.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Schreibe den ersten Absatz deines Artikels hier.

==Überschrift des Abschnittes==

Schreibe den ersten Abschnitt deines Artikels hier.

==Überschrift des Abschnittes==

Schreibe den zweiten Abschnitt deines Artikels hier.',
	'createpage-ve-body' => 'Der <b>$1</b> Artikel existiert auf diesem Wiki nicht. Du kannst helfen, indem du ein paar Sätze hinzufügst.',
	'createpage-button-cancel' => 'Abbrechen',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author LWChris
 */
$messages['de-formal'] = array(
	'createpage_article_already_exists' => 'Ein Artikel mit diesem Namen existiert bereits.
Bitte wählen Sie einen anderen Namen.',
	'createpage_spam' => 'Entschuldigung, Ihre Bearbeitung konnte nicht gespeichert werden',
	'createpage-dialog-title' => 'Neue Seite anlegen',
	'createpage-dialog-message1' => 'Juhu, Sie erstellen eine neue Seite!',
	'createpage-dialog-message2' => 'Wie wollen Sie die Seite nennen?',
	'createpage-dialog-choose' => 'Wählen Sie ein Seitenlayout:',
	'createpage-dialog-format' => 'Standardlayout',
	'createpage-error-empty-title' => 'Bitte geben Sie einen Titel für Ihren Artikel ein',
	'createpage-error-invalid-title' => 'Entschuldigung, der Artikelname war ungültig.
Bitte verwenden Sie einen anderen Titel.',
	'createpage-error-article-exists' => 'Ein Artikel mit diesem Titel besteht bereits.
Sie können zu <a href="$1">$2</a> gehen, oder Ihre Seite umbenennen',
	'createpage-error-article-spam' => 'Entschuldigung, der Artikelname wurde von unserem Spamfilter zurückgewiesen.
Bitte verwenden Sie einen anderen Titel.',
	'createpage-error-article-blocked' => 'Entschuldigung, wir können diesen Artikel im Moment nicht erstellen.',
	'tog-createpagedefaultblank' => 'Eine leere Seite als Standard für neue Seiten verwenden',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Schreiben Sie den ersten Absatz Ihres Artikels hier.

==Überschrift des Abschnittes==

Schreiben Sie den ersten Abschnitt Ihres Artikels hier.

==Überschrift des Abschnittes==

Schreiben Sie den zweiten Abschnitt Ihres Artikels hier.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Schreiben Sie den ersten Absatz Ihres Artikels hier.

==Überschrift des Abschnittes==

Schreiben Sie den ersten Abschnitt Ihres Artikels hier.

==Überschrift des Abschnittes==

Schreiben Sie den zweiten Abschnitt Ihres Artikels hier.',
	'createpage-ve-body' => 'Der <b>$1</b> Artikel existiert auf diesem Wiki nicht. Du kannst helfen, indem du ein paar Sätze hinzufügst.',
	'createpage-button-cancel' => 'Abbrechen',
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 */
$messages['diq'] = array(
	'createpage-sp-title' => 'Pela newi vıraze',
	'createpage_title' => 'Pela newi vıraze',
	'createpage_title_caption' => 'Sername',
	'createpage_enter_text' => 'Metın:',
	'createpage-dialog-title' => 'Pela newi vıraze',
);

/** Greek (Ελληνικά)
 * @author Dead3y3
 * @author Evropi
 * @author Περίεργος
 */
$messages['el'] = array(
	'createpage-desc' => 'Σας επιτρέπει να δημιουργήσετε μια νέα σελίδα χρησιμοποιώντας τον επεξεργαστή WYSIWYG της Wikia',
	'createpage-sp-title' => 'Δημιουργήσετε μια νέα σελίδα',
	'createpage_title' => 'Δημιουργήστε ένα καινούργιο άρθρο',
	'createpage_title_caption' => 'Τίτλος:', # Fuzzy
	'createpage_invalid_title_error' => 'Άκυρος τίτλος',
	'createpage-dialog-blank' => 'Κενή σελίδα',
);

/** Spanish (español)
 * @author Armando-Martin
 * @author Ciencia Al Poder
 * @author Crazymadlover
 * @author Mor
 * @author Translationista
 */
$messages['es'] = array(
	'createpage-desc' => 'Permite crear una nueva página usando editor WYSIWYG de Wikia',
	'createpage-sp-title' => 'Crea un nuevo artículo',
	'createpage_title' => 'Crear un nuevo artículo',
	'createpage_title_caption' => 'Título',
	'createpage_enter_text' => 'Escribe el contenido aquí:',
	'createpage_empty_title_error' => 'Título requerido',
	'createpage_empty_article_body_error' => 'Texto de artículo requerido',
	'createpage_invalid_title_error' => 'Título inválido.',
	'createpage_article_already_exists' => 'Ya existe un artículo con ese nombre.Por favor, selecciona un nombre diferente.',
	'createpage_spam' => 'Lo sentimos. No se pudo guardar tu edición',
	'createpage_cant_edit' => 'No se pudo efectuar la edición',
	'createpage-dialog-title' => 'Crear un nuevo artículo',
	'createpage-dialog-message1' => '¡Bravo! ¡Estás creando una nueva página!',
	'createpage-dialog-message2' => '¿Cómo le quieres llamar?',
	'createpage-dialog-choose' => 'Elige un diseño de página:',
	'createpage-dialog-format' => 'Diseño estándar',
	'createpage-dialog-blank' => 'Página en blanco',
	'createpage-error-empty-title' => 'Por favor, escribe un título para tu artículo',
	'createpage-error-invalid-title' => 'Lo sentimos, el título del artículo no era válido. Por favor, usa un título diferente.',
	'createpage-error-article-exists' => 'Ya existe un artículo con ese título. Puedes ir a <a href="$1">$2</a> o cambiar el nombre de tu página',
	'createpage-error-article-spam' => 'Lo sentimos, el título del artículo fue rechazado por nuestro filtro de contenido no deseado. Por favor, usa un título diferente.',
	'createpage-error-article-blocked' => 'Lo sentimos, no puedes crear ese artículo en este momento.',
	'tog-createpagedefaultblank' => 'Usa una página en blanco de manera predeterminada para la traducción de nuevas páginas.',
	'tog-createpagepopupdisabled' => 'Desactivar el proceso "Crear un nuevo artículo" (no recomendado)',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Escribe aquí el primer párrafo de tu artículo.

==Encabezado de sección==

Escribe aquí la primera sección de tu artículo.

==Encabezado de sección==

Escribe aquí la segunda sección de tu artículo.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Escribe aquí el primer párrafo de tu artículo.

==Encabezado de sección==

Escribe aquí la primera sección de tu artículo.

==Encabezado de sección==

Escribe aquí la segunda sección de tu artículo.',
	'createpage-ve-body' => 'El artículo <b>$1</b> aún no existe en esta wikia. Puedes ayudar agregando unas pocas frases.',
	'createpage-button-cancel' => 'Cancelar',
);

/** Basque (euskara)
 * @author An13sa
 * @author Xabier Armendaritz
 */
$messages['eu'] = array(
	'createpage-desc' => 'Wikiako WYSIWYG editatzailea erabiliz orrialde berriak sortzea ahalbidetzen du',
	'createpage-sp-title' => 'Artikulu berri bat sortu',
	'createpage_title' => 'Artikulu berri bat sortu',
	'createpage_title_caption' => 'Izenburua',
	'createpage_enter_text' => 'Testua:',
	'createpage_empty_title_error' => 'Izenburua beharrezkoa',
	'createpage_empty_article_body_error' => 'Artikuluaren testua beharrezkoa',
	'createpage_invalid_title_error' => 'Balio gabeko izenburua',
	'createpage_article_already_exists' => 'Izen hori duen artikulua badago.
Mesedez beste izen bat aukeratu.',
	'createpage_spam' => 'Barkatu, zure aldaketa ezin izan da gorde',
	'createpage_cant_edit' => 'Aldaketa ezin izan da burutu',
	'createpage-dialog-title' => 'Artikulu Berria Sortu',
	'createpage-dialog-message1' => 'Aupa! Orrialde berria sortzen ari zara!',
	'createpage-dialog-message2' => 'Nola deitu nahi diozu?',
	'createpage-dialog-choose' => 'Aukeratu orrialderako diseinua:',
	'createpage-dialog-format' => 'Disenu estandarra',
	'createpage-dialog-blank' => 'Orri zuria',
	'createpage-error-empty-title' => 'Msedez idatzi zure artikuluarentzako izenburua',
	'createpage-error-invalid-title' => 'Barkatu, izenburu hori okerra da.
Mesedez erabiki izenburu desberdina.',
	'createpage-error-article-exists' => 'Izenburu berdina duen artikulua bat badago.
An article with that title already exists.
<a href="$1">$2</a>-(e)ra joan zaitezke, edo zure orrialde berrizendatu',
	'createpage-error-article-spam' => 'Barkatu, artikuluaren izenburua gure spam-iragazkiak baztertu du.
Mesedez erabili izenburu ezberdin bat.',
	'createpage-error-article-blocked' => 'Barkatu, ezin duzu une honetan artikulu hori sortu.',
	'tog-createpagedefaultblank' => 'Erabili orrialde txuria lehenetsiz orrialde berri bat sortzean',
	'tog-createpagepopupdisabled' => '"Artikulu berria sortu" prozesua ezgaitu (ez gomendatua)',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Hemen zure artikuluaren lehen parrafoa idatz ezazu.

==Atal goiburua==

Hemen zure artikuluaren lehen atala idatz ezazu.

==Atal goiburua==

Hemen zure artikuluaren bigarren atala idatz ezazu.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Hemen zure artikuluaren lehen parrafoa idatz ezazu.

==Atal goiburua==

Hemen zure artikuluaren lehen atala idatz ezazu.

==Atal goiburua==

Hemen zure artikuluaren bigarren atala idatz ezazu.',
);

/** Persian (فارسی)
 * @author BlueDevil
 * @author Mjbmr
 * @author ZxxZxxZ
 */
$messages['fa'] = array(
	'createpage-sp-title' => 'ایجاد صفحهٔ جدید',
	'createpage_title' => 'ایجاد مقالۀ جدید',
	'createpage_title_caption' => 'عنوان',
	'createpage_enter_text' => 'متن',
	'createpage-dialog-title' => 'ایجاد صفحهٔ جدید',
	'createpage-dialog-format' => 'چیدمان استاندارد',
	'createpage-dialog-blank' => 'صفحهٔ خالی',
	'createpage-error-empty-title' => 'لطفاً برای صفحهٔ خود عنوانی بنویسید',
);

/** Finnish (suomi)
 * @author Centerlink
 * @author Crt
 * @author Ilkea
 */
$messages['fi'] = array(
	'createpage-desc' => 'Mahdollistaa uusien sivujen luonnin käyttäen Wikian WYSIWYG muokkainta',
	'createpage-sp-title' => 'Luo uusi artikkeli',
	'createpage_title' => 'Luo uusi artikkeli',
	'createpage_title_caption' => 'Otsikko',
	'createpage_enter_text' => 'Kirjoita tekstiä tähän:',
	'createpage_empty_title_error' => 'Otsikko vaadittu',
	'createpage_empty_article_body_error' => 'Sivulla pitää olla tekstiä',
	'createpage_invalid_title_error' => 'Virheellinen otsikko',
	'createpage_article_already_exists' => 'Artikkeli tuolla nimellä on jo olemassa.
Valitse eri nimi.',
	'createpage_spam' => 'Muokkaustasi ei valitettavasti voitu tallentaa',
	'createpage_cant_edit' => 'Ei voitu suorittaa muokkausta',
	'createpage-dialog-title' => 'Luo uusi artikkeli',
	'createpage-dialog-message1' => 'Olet luomassa uutta sivua.',
	'createpage-dialog-message2' => 'Miksi haluat kutsua sitä?',
	'createpage-dialog-choose' => 'Valitse sivun ulkoasu:',
	'createpage-dialog-format' => 'Oletus ulkoasu',
	'createpage-dialog-blank' => 'Tyhjä sivu',
	'createpage-error-empty-title' => 'Kirjoita artikkelisi otsikko',
	'createpage-error-invalid-title' => 'Sivun otsikko ei valitettavasti kelpaa.
Käytä jotain muuta otsikkoa.',
	'createpage-error-article-exists' => 'Tämän niminen sivu on jo olemassa.
Voit siirtyä <a href="$1">$2</a>, tai nimetä sivusi uudelleen',
	'createpage-error-article-spam' => 'Valitettavasti spam-suodatin hylkäsi antamasi sivun otsikon.
Käytä eri otsikkoa.',
	'createpage-error-article-blocked' => 'Valitettavasti et pysty luomaan sivua tällä hetkellä.',
	'tog-createpagedefaultblank' => 'Käytä tyhjää sivua oletuksena uutta sivua luodessa',
	'tog-createpagepopupdisabled' => 'Poista käytöstä "Luo uusi artikkeli" virta (Ei suositeltu)',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Kirjoita sivusi ensimmäinen kappale tähän.

==Väliotsikko==

Kirjoita sivusi ensimmäinen osio tähän.

==Väliotsikko==

Kirjoita sivusi toinen osio tähän.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Kirjoita sivusi ensimmäinen kappale tähän.

==Väliotsikko==

Kirjoita sivusi ensimmäinen osio tähän.

==Väliotsikko==

Kirjoita sivusi toinen osio tähän.',
);

/** French (français)
 * @author Crochet.david
 * @author IAlex
 * @author Wyz
 */
$messages['fr'] = array(
	'createpage-desc' => 'Permet de créer une nouvelle page en utilisant l’éditeur WYSIWYG de Wikia',
	'createpage-sp-title' => 'Créer un nouvel article',
	'createpage_title' => 'Créer une nouvelle page',
	'createpage_title_caption' => 'Titre',
	'createpage_enter_text' => 'Texte :',
	'createpage_empty_title_error' => 'Titre requis',
	'createpage_empty_article_body_error' => "Texte de l'article requis",
	'createpage_invalid_title_error' => 'Titre invalide',
	'createpage_article_already_exists' => 'Un article avec ce nom existe déjà, veuillez choisir un nom différent',
	'createpage_spam' => "Désolé, votre modification n'a pas pu être sauvegardée",
	'createpage_cant_edit' => "Impossible d'effectuer la modification",
	'createpage-dialog-title' => 'Créer un nouvel article',
	'createpage-dialog-message1' => 'Hourra, vous êtes en train de créer une nouvelle page !',
	'createpage-dialog-message2' => "Comment voulez-vous l'appeler ?",
	'createpage-dialog-choose' => 'Choisissez une mise en page :',
	'createpage-dialog-format' => 'Présentation normale',
	'createpage-dialog-blank' => 'Page vide',
	'createpage-error-empty-title' => 'Veuillez écrire le titre de votre article',
	'createpage-error-invalid-title' => "Désolé, le titre de l'article était invalide. Veuillez choisir un titre différent.",
	'createpage-error-article-exists' => 'Un article avec ce titre existe déjà. Vous pouvez aller à <a href="$1">$2,</a> ou renommer votre page',
	'createpage-error-article-spam' => 'Désolé, le titre de la page a été rejeté par notre filtre anti-spam. Veuillez utiliser un nom différent.',
	'createpage-error-article-blocked' => 'Désolé, vous ne pouvez créer cet article en ce moment.',
	'tog-createpagedefaultblank' => 'Utiliser une page vierge par défaut pour créer une nouvelle page',
	'tog-createpagepopupdisabled' => 'Désactiver le flux « Créer un nouvel article » (non recommandé)',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Écrivez le premier paragraphe de votre article ici.

== Titre de section ==

Écrivez la première section de votre article ici.

== Titre de section ==

Écrivez la deuxième section de votre article ici.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Écrivez le premier paragraphe de votre article ici.

== Titre de section ==

Écrivez la première section de votre article ici.

== Titre de section ==

Écrivez la deuxième section de votre article ici.',
	'createpage-ve-body' => 'L\'article <b>$1</b> n\'existe pas dans ce wikia. Vous pouvez aider en ajoutant quelques phrases.',
	'createpage-button-cancel' => 'Annuler',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'createpage-desc' => 'Permite crear unha nova páxina usando o editor WYSIWYG de Wikia',
	'createpage-sp-title' => 'Crear un novo artigo',
	'createpage_title' => 'Crear un novo artigo',
	'createpage_title_caption' => 'Título',
	'createpage_enter_text' => 'Texto:',
	'createpage_empty_title_error' => 'O título é obrigatorio',
	'createpage_empty_article_body_error' => 'O texto do artigo é obrigatorio',
	'createpage_invalid_title_error' => 'Título non válido',
	'createpage_article_already_exists' => 'Xa existe un artigo con ese nome.
Por favor, seleccione un nome diferente.',
	'createpage_spam' => 'Sentímolo, non se pode gardar a súa edición',
	'createpage_cant_edit' => 'Non se puido efectuar a edición',
	'createpage-dialog-title' => 'Crear un novo artigo',
	'createpage-dialog-message1' => 'Parabéns, está creando unha nova páxina!',
	'createpage-dialog-message2' => 'Como quere chamala?',
	'createpage-dialog-choose' => 'Escolla un esquema para a páxina:',
	'createpage-dialog-format' => 'Esquema estándar',
	'createpage-dialog-blank' => 'Baleirar a páxina',
	'createpage-error-empty-title' => 'Por favor, escriba un título para o seu artigo',
	'createpage-error-invalid-title' => 'Sentímolo, o título do artigo era inválido.
Por favor, use un título diferente.',
	'createpage-error-article-exists' => 'Xa existe un artigo con este título.
Pode ir a <a href="$1">$2</a> ou cambiar o nome da súa páxina',
	'createpage-error-article-spam' => 'Sentímolo, o noso filtro de spam rexeitou o título do artigo.
Por favor, use un título diferente.',
	'createpage-error-article-blocked' => 'Sentímolo, non pode crear este artigo nestes intres.',
	'tog-createpagedefaultblank' => 'Use unha páxina en branco por defecto para crear unha nova páxina',
	'tog-createpagepopupdisabled' => 'Desactivar o fluxo "Crear un novo artigo" (non recomendado)',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Escriba aquí o primeiro parágrafo do seu artigo.

==Cabeceira de sección==

Escriba aquí a primeira sección do seu artigo.

==Cabeceira de sección==

Escriba aquí a segunda sección do seu artigo.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Escriba aquí o primeiro parágrafo do seu artigo.

==Cabeceira de sección==

Escriba aquí a primeira sección do seu artigo.

==Cabeceira de sección==

Escriba aquí a segunda sección do seu artigo.',
);

/** Hebrew (עברית)
 * @author 0ftal
 */
$messages['he'] = array(
	'createpage-desc' => 'ההרחבה מאפשרת ליצור דף חדש באמצעות העורך החזותי של Wikia',
	'createpage-sp-title' => 'כתוב מאמר חדש',
	'createpage_title' => 'כתוב מאמר חדש',
	'createpage_title_caption' => 'כותרת:', # Fuzzy
	'createpage_enter_text' => 'טקסט:',
	'createpage_empty_title_error' => 'דרושה כותרת',
	'createpage_empty_article_body_error' => 'דרוש טקסט במאמר',
	'createpage_invalid_title_error' => 'כותרת לא תקינה',
	'createpage_article_already_exists' => 'מאמר עם שם זה כבר קיים.
אנא בחר שם אחר.',
	'createpage_spam' => 'מצטערים, לא היה ניתן לשמור את העריכה שלך',
	'createpage_cant_edit' => 'אין אפשרות לבצע עריכה',
	'createpage-dialog-title' => 'כתוב מאמר חדש',
	'createpage-dialog-message1' => 'הידד, אתה יוצר דף חדש!',
	'createpage-dialog-message2' => 'איך ברצונך לקרוא לו?',
	'createpage-dialog-choose' => 'בחר את פריסת הדף:',
	'createpage-dialog-format' => 'פריסה רגילה',
	'createpage-dialog-blank' => 'דף ריק',
	'createpage-error-empty-title' => 'אנא כתוב כותרת למאמר שלך',
	'createpage-error-invalid-title' => 'מצטערים, כותרת המאמר לא תקינה.
אנא השתמש בכותרת שונה.',
	'createpage-error-article-exists' => 'מאמר בשם זה כבר קיים.
אתה יכול ללכת ל <a href="$1">$2</a>, או לשנות את שם המאמר',
	'createpage-error-article-spam' => 'מצטערים, כותרת המאמר נדחתה על ידי המסנן שלנו.
אנא השתמש בכותרת שונה.',
	'createpage-error-article-blocked' => 'מצטערים, אינך יכול ליצור את המאמר הזה כרגע.',
	'tog-createpagedefaultblank' => 'השתמש בדף ריק ליצירת מאמרים כברירת מחדל',
	'tog-createpagepopupdisabled' => 'נטרול החלונית ליצירת דפים', # Fuzzy
	'newpagelayout' => '[[File:Placeholder|right|300px]]
כתוב את הפסקה הראשונה במאמר שלך כאן.

==כותרת קטע==

כתוב את הקטע הראשון במאמר שלך כאן.

==כותרת קטע==

כתוב את הקטע השני במאמר שלך כאן.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
כתוב את הפסקה הראשונה במאמר שלך כאן.

==כותרת קטע==

כתוב את הקטע הראשון במאמר שלך כאן.

==כותרת קטע==

כתוב את הקטע השני במאמר שלך כאן.',);

/** Hungarian (magyar)
 * @author Dani
 * @author Dj
 * @author Enbéká
 * @author Glanthor Reviol
 * @author TK-999
 */
$messages['hu'] = array(
	'createpage-desc' => 'Lehetővé teszi egy új oldal létrehozását a Wikia WYSIWYG szerkesztőjével',
	'createpage-sp-title' => 'Új szócikk létrehozása',
	'createpage_title' => 'Új szócikk létrehozása',
	'createpage_title_caption' => 'Cím',
	'createpage_enter_text' => 'Szöveg:',
	'createpage_empty_title_error' => 'A cím megadása kötelező',
	'createpage_empty_article_body_error' => 'A szócikk nem lehet üres',
	'createpage_invalid_title_error' => 'Érvénytelen cím',
	'createpage_article_already_exists' => 'Már létezik ilyen nevű lap.
Válassz másikat!',
	'createpage_spam' => 'Sajnáljuk, a mentést nem sikerült elmenteni',
	'createpage_cant_edit' => 'Nem sikerült végrehajtani a szerkesztést',
	'createpage-dialog-title' => 'Új szócikk létrehozása',
	'createpage-dialog-message1' => 'Hurrá, egy új lapot hozol létre!',
	'createpage-dialog-message2' => 'Mi legyen a címe?',
	'createpage-dialog-choose' => 'Válaszd ki az oldal elrendezését:',
	'createpage-dialog-format' => 'Szabványos elrendezés',
	'createpage-dialog-blank' => 'Üres lap',
	'createpage-error-empty-title' => 'Adj címet a lapnak',
	'createpage-error-invalid-title' => 'Sajnos az oldal címe érvénytelen volt.
Kérünk, használj más címet.',
	'createpage-error-article-exists' => 'Már létezik egy oldal, ezzel a címmel.
Elmehetsz a(z) <a href="$1 ">$2</a>-höz, vagy átnevezheted az oldalt.',
	'createpage-error-article-spam' => 'Sajnos a spamszűrő letiltotta a lap címét
Kérünk, használj más címet.',
	'createpage-error-article-blocked' => 'Sajnáljuk, jelenleg nem hozhatod létre ezt az oldalt.',
	'tog-createpagedefaultblank' => 'Üres lap alapértelmezett használata új oldal létrehozásakor',
	'tog-createpagepopupdisabled' => '"Új szócikk létrehozása" letiltása (nem javasolt)',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Írd az oldalad első bekezdését ide.

==Címsor==

Írd az oldalad első szakaszát ide.

==Címsor==

Írd az oldalad második szakaszát ide.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Írd az oldalad első bekezdését ide.

==Címsor==

Írd az oldalad első szakaszát ide.

==Címsor==

Írd az oldalad második szakaszát ide.',
);

/** Armenian (Հայերեն)
 * @author Vadgt
 */
$messages['hy'] = array(
	'createpage-sp-title' => 'Ստեղծել նոր էջ',
	'createpage_title' => 'Ստեղծել նոր էջ',
	'createpage_title_caption' => 'Վերնագիր',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'createpage-desc' => 'Permitte crear un nove pagina con le editor WYSIWYG de Wikia',
	'createpage-sp-title' => 'Crear un nove articulo',
	'createpage_title' => 'Crear un nove articulo',
	'createpage_title_caption' => 'Titulo',
	'createpage_enter_text' => 'Texto:',
	'createpage_empty_title_error' => 'Un titulo es obligatori',
	'createpage_empty_article_body_error' => 'Texto de articulo es obligatori',
	'createpage_invalid_title_error' => 'Titulo invalide',
	'createpage_article_already_exists' => 'Un articulo con iste nomine ja existe.
Per favor entra un altere nomine.',
	'createpage_spam' => 'Pardono, tu modification non poteva esser salveguardate',
	'createpage_cant_edit' => 'Non poteva exequer le modification',
	'createpage-dialog-title' => 'Crear un nove articulo',
	'createpage-dialog-message1' => 'Hurra, tu crea ora un nove pagina!',
	'createpage-dialog-message2' => 'Como vole tu appellar lo?',
	'createpage-dialog-choose' => 'Selige un disposition:',
	'createpage-dialog-format' => 'Disposition standard',
	'createpage-dialog-blank' => 'Pagina vacue',
	'createpage-error-empty-title' => 'Per favor scribe un titulo pro tu articulo',
	'createpage-error-invalid-title' => 'Pardono, le titulo del articulo es invalide.
Per favor usa un altere articulo.',
	'createpage-error-article-exists' => 'Un articulo con iste titulo ja existe.
Tu pote visitar <a href="$1">$2</a>, o renominar tu pagina.',
	'createpage-error-article-spam' => 'Pardono, le titulo del articulo ha essite rejectate per nostre filtro anti-spam.
Per favor usa un altere titulo.',
	'createpage-error-article-blocked' => 'Pardono, tu non pote crear iste articulo in iste momento.',
	'tog-createpagedefaultblank' => 'Usa un pagina blanc como standard pro le creation de nove paginas',
	'tog-createpagepopupdisabled' => 'Disactivar "Crear un nove articulo" (non recommendate)',
	'newpagelayout' => '[[File:Placeholder|right|300px|Spatio reservate]]
Scribe hic le prime paragrapho de tu articulo.

==Titulo de section==

Scribe hic le prime section de tu articulo.

==Titulo de section==

Scribe hic le secunde section de tu articulo.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px|Spatio reservate]]
Scribe hic le prime paragrapho de tu articulo.

==Titulo de section==

Scribe hic le prime section de tu articulo.

==Titulo de section==

Scribe hic le secunde section de tu articulo.',
);

/** Indonesian (Bahasa Indonesia)
 * @author Aldnonymous
 * @author Irwangatot
 */
$messages['id'] = array(
	'createpage-desc' => 'Memungkinkan untuk membuat halaman baru menggunakan editor WYSIWYG Wikia',
	'createpage-sp-title' => 'Buat halaman baru',
	'createpage_title' => 'Buat halaman baru',
	'createpage_title_caption' => 'Judul',
	'createpage_enter_text' => 'Teks:',
	'createpage_empty_title_error' => 'Judul diperlukan',
	'createpage_empty_article_body_error' => 'Teks halaman dibutuhkan',
	'createpage_invalid_title_error' => 'Judul tidak sah',
	'createpage_article_already_exists' => 'Halaman dengan nama yang sudah ada.
Silakan Pilih nama yang berbeda.',
	'createpage_spam' => 'Maaf, suntingan anda tidak dapat disimpan',
	'createpage_cant_edit' => 'Tidak dapat menyunting',
	'createpage-dialog-title' => 'Buat halaman baru',
	'createpage-dialog-message1' => 'Selamat, Anda membuat sebuah halaman baru!',
	'createpage-dialog-message2' => 'Nama apa yang ingin Anda berikan?',
	'createpage-dialog-choose' => 'Pilih rancangan halaman',
	'createpage-dialog-format' => 'rancangan standar',
	'createpage-dialog-blank' => 'Halaman kosong',
	'createpage-error-empty-title' => 'Silakan menulis judul halaman Anda',
	'createpage-error-invalid-title' => 'Maaf, halaman judul ini tidak sah.
Gunakan judul yang berbeda.',
	'createpage-error-article-exists' => 'Halaman dengan judul yang sama sudah ada.
Anda dapat pergi ke <a href="$1">$2</a>, atau merubah nama halaman Anda',
	'createpage-error-article-spam' => 'Maaf, halaman judul ini ditolak oleh filter spam kami.
Gunakan judul yang berbeda.',
	'createpage-error-article-blocked' => 'Maaf, Anda tidak dapat membuat halaman saat ini.',
	'tog-createpagedefaultblank' => 'Gunakan halaman kosong sebagai default untuk membuat sebuah halaman baru',
	'tog-createpagepopupdisabled' => 'Nonaktifkan "Buat artikel baru" pop-up dialog', # Fuzzy
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Tulis paragraf pertama dari halaman Anda di sini.

 == Bagian judul ==

Tulis bagian pertama dari halaman Anda di sini.

 == Bagian judul ==

Tulis bagian kedua dari halaman Anda di sini.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Tulis paragraf pertama dari halaman Anda di sini.

 == Bagian judul ==

Tulis bagian pertama dari halaman Anda di sini.

 == Bagian judul ==

Tulis bagian kedua dari halaman Anda di sini.',
);

/** Italian (italiano)
 * @author HalphaZ
 * @author Leviathan 89
 * @author Ximo17
 */
$messages['it'] = array(
	'createpage-desc' => "Permette di creare una nuova pagina utilizzando l'editor WYSIWYG di Wikia",
	'createpage-sp-title' => 'Crea un nuovo articolo',
	'createpage_title' => 'Crea un nuovo articolo',
	'createpage_title_caption' => 'Titolo',
	'createpage_enter_text' => 'Testo:',
	'createpage_empty_title_error' => 'Titolo necessario',
	'createpage_empty_article_body_error' => "Testo dell'articolo richiesto",
	'createpage_invalid_title_error' => 'Titolo non valido',
	'createpage_article_already_exists' => 'Un articolo con questo nome esiste già.
Seleziona un nome diverso.',
	'createpage_spam' => 'Spiacente, la tua modifica non può essere salvata',
	'createpage_cant_edit' => 'Impossibile effettuare la modifica',
	'createpage-dialog-title' => 'Crea un nuovo articolo',
	'createpage-dialog-message1' => 'Evviva, stai creando una nuova pagina!',
	'createpage-dialog-message2' => 'Come la vuoi chiamare?',
	'createpage-dialog-choose' => 'Scegli una formattazione per la pagina:',
	'createpage-dialog-format' => 'Formattazione standard',
	'createpage-dialog-blank' => 'Pagina vuota',
	'createpage-error-empty-title' => 'Scrivi un titolo per il tuo articolo',
	'createpage-error-invalid-title' => "Spiacente, il titolo dell'articolo non era valido.
Utilizza un titolo diverso.",
	'createpage-error-article-exists' => 'Un articolo con questo titolo esiste già.
Puoi andare a <a href="$1">$2</a> , o rinominare la tua pagina',
	'createpage-error-article-spam' => "Spiacente, il titolo dell'articolo è stata respinto dal nostro filtro anti-spam.
Usa un titolo diverso.",
	'createpage-error-article-blocked' => 'Spiacente, non puoi creare questo articolo in questo momento.',
	'tog-createpagedefaultblank' => 'Utilizza una pagina vuota come default per la creazione di una nuova pagina',
	'tog-createpagepopupdisabled' => 'Disabilita il flusso "Crea nuovo articolo" (Non Raccomandato)',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Scrivi qui il primo paragrafo del tuo articolo.

==Titolo della sezione==

Scrivi qui la prima sezione del tuo articolo.

==Titolo della sezione==

Scrivi qui la seconda sezione del tuo articolo.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Scrivi qui il primo paragrafo del tuo articolo.

==Titolo della sezione==

Scrivi qui la prima sezione del tuo articolo.

==Titolo della sezione==

Scrivi qui la seconda sezione del tuo articolo.',
	'createpage-ve-body' => 'L\'articolo <b>$1</b> non è ancora disponibile su questo wikia. Puoi dare il tuo contributo aggiungendo qualche frase.',
	'createpage-button-cancel' => 'Annulla',
);

/** Japanese (日本語)
 * @author Tommy6
 */
$messages['ja'] = array(
	'createpage-desc' => 'ウィキアのWYSIWYGエディターを使って、新しいページを作成できるようにする',
	'createpage-sp-title' => '新規記事を作成',
	'createpage_title' => '新規記事を作成',
	'createpage_title_caption' => 'タイトル',
	'createpage_enter_text' => '本文:',
	'createpage_empty_title_error' => 'タイトルが必要です',
	'createpage_empty_article_body_error' => '本文にテキストが必要です',
	'createpage_invalid_title_error' => '不適切なタイトルです',
	'createpage_article_already_exists' => 'このタイトルの記事は既にあります。違うタイトルをつけてください。',
	'createpage_spam' => '編集を保存できませんでした',
	'createpage_cant_edit' => '編集を実行できません',
	'createpage-dialog-title' => '新しいページをつくる',
	'createpage-dialog-message1' => ' ',
	'createpage-dialog-message2' => 'ページのタイトルを入力してください。',
	'createpage-dialog-choose' => 'ページのレイアウトを選択:',
	'createpage-dialog-format' => '標準レイアウト',
	'createpage-dialog-blank' => '白紙ページ',
	'createpage-error-empty-title' => '記事のタイトルを指定してください',
	'createpage-error-invalid-title' => '記事のタイトルが不適切です。他のタイトルを指定してください。',
	'createpage-error-article-exists' => 'このタイトルの記事は既に存在します。<a href="$1">$2</a>を編集するか、作成するページのタイトルを変更してください。',
	'createpage-error-article-spam' => 'このタイトルはスパムフィルターによって拒否されました。他のタイトルに変更してください。',
	'createpage-error-article-blocked' => '現在、記事が作成できなくなっています。',
	'tog-createpagedefaultblank' => '白紙ページを新規記事の作成にデフォルトで使用する',
	'tog-createpagepopupdisabled' => '新規記事作成支援機能を無効にする（非推奨）',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
ここに導入部分（第一段落）を書く。

== 節見出し ==
ここに1番目の節を書く。

== 節見出し ==
ここに2番目の節を書く。',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
ここに導入部分（第一段落）を書く。

== 節見出し ==
ここに1番目の節を書く。

== 節見出し ==
ここに2番目の節を書く。',
	'createpage-ve-body' => '<b>$1</b>という記事はこのウィキアには存在しません。記事を作成するにはいくつかの文章を加えて下さい。',
	'createpage-button-cancel' => 'キャンセル',
);

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'createpage-sp-title' => 'បង្កើតទំព័រថ្មីមួយ',
	'createpage_title' => 'បង្កើតទំព័រថ្មីមួយ',
	'createpage_title_caption' => 'ចំណងជើង៖', # Fuzzy
	'createpage_enter_text' => 'អត្ថបទ៖',
	'createpage_empty_title_error' => 'តំរូវអោយមានចំណងជើង',
	'createpage_empty_article_body_error' => 'តំរូវអោយមានអត្ថបទ',
	'createpage_invalid_title_error' => 'ចំណងជើងមិនត្រឹមត្រូវ',
	'createpage_article_already_exists' => 'មានទំព័រដែលមានឈ្មោះបែបនេះហើយ។
សូមជ្រើសរើសឈ្មោះផ្សេងពីនេះ។',
	'createpage_spam' => 'សូមទោស។ ការកែប្រែរបស់អ្នកមិនអាចរក្សាទុកបានទេ',
	'createpage_cant_edit' => 'មិនអាចធ្វើការកែប្រែ',
	'createpage-dialog-title' => 'បង្កើតទំព័រថ្មីមួយ',
	'createpage-dialog-message1' => 'ជយោ! អ្នកកំពុងតែបង្កើតទំព័រថ្មីមួយហើយ!',
	'createpage-dialog-message2' => 'តើអ្នកចង់ហៅវាយ៉ាងម៉េច?',
	'createpage-dialog-choose' => 'ជ្រើសរើសប្លង់ទំព័រ៖',
	'createpage-dialog-format' => 'ប្លង់ស្តង់ដារ',
	'createpage-dialog-blank' => 'ទំព័រទទេ',
	'createpage-error-empty-title' => 'សូម​សរសេរចំណងជើង​ទំព័រ​ឱ្យ​ទំព័រ​របស់​អ្នក​។',
	'createpage-error-invalid-title' => 'សូមទោស។ ចំណងជើងទំព័រមិនត្រឹមត្រូវទេ។
សូមប្រើចំណងជើងផ្សេងពីនេះ។',
	'createpage-error-article-exists' => 'ទំព័រដែលមានចំណងជើងបែបនេះមានរួចហើយ។
អ្នកអាចទៅកាន់<a href="$1">$2</a> ឬប្ដូរឈ្មោះទំព័ររបស់អ្នក',
	'createpage-error-article-spam' => 'សូមទោស។ ចំណងជើងទំព័រត្រូវបានច្រានចោលដោយតំរងស្ប៉ាមរបស់យើង។
សូមប្រើប្រាស់ចំណងជើងមួយផ្សេងទៀត។',
	'createpage-error-article-blocked' => 'សូមទោស។ អ្នកមិនអាចបង្កើតទំព័រនោះបានទេនាពេលនេះ។',
	'tog-createpagedefaultblank' => 'ប្រើទំព័រទទេក្នុងលំនាំដើម ក្នុងការបង្កើតទំព័រថ្មីមួយ',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
សរសេរកឋាខណ្ឌទីមួយរបស់អ្នកនៅទីនេះ។

==ចំណងជើងផ្នែក==

សរសេរផ្នែកទីមួយរបស់ទំព័រអ្នកនៅទៅនេះ។

==ចំណងជើងផ្នែក==
សរសេរផ្នែកទីពីររបស់ទំព័រអ្នកនៅទៅនេះ។',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
សរសេរកឋាខណ្ឌទីមួយរបស់អ្នកនៅទីនេះ។

==ចំណងជើងផ្នែក==

សរសេរផ្នែកទីមួយរបស់ទំព័រអ្នកនៅទៅនេះ។

==ចំណងជើងផ្នែក==
សរសេរផ្នែកទីពីររបស់ទំព័រអ្នកនៅទៅនេះ។',
);

/** Kurdish (Latin script) (Kurdî (latînî)‎)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'createpage-sp-title' => 'Rûpeleka nû çêke',
	'createpage_title' => 'Rûpeleka nû çêke',
	'createpage_title_caption' => 'Sernav:', # Fuzzy
	'createpage_enter_text' => 'Nivîs:',
	'createpage-dialog-title' => 'Rûpeleka nû çêke',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'createpage-desc' => 'Erlaabt et eng nei Säit mam Wikia WYSIWYG-Editeur unzeleeën',
	'createpage-sp-title' => 'En neien Artikel uleeën',
	'createpage_title' => 'En neien Artikel uleeën',
	'createpage_title_caption' => 'Titel',
	'createpage_enter_text' => 'Text:',
	'createpage_empty_title_error' => 'Titel obligatoresch',
	'createpage_empty_article_body_error' => 'Text vum Artikel obligatoresch',
	'createpage_invalid_title_error' => 'Net valabelen Titel',
	'createpage_article_already_exists' => 'Et gëtt schonn en Artikel mat deem Numm.
Sicht Iech w.e.g. en aneren Numm.',
	'createpage_spam' => 'pardon, Är Ännerung konnt net gespäichert ginn',
	'createpage_cant_edit' => "D'Ännerung konnt net gemaach ginn",
	'createpage-dialog-title' => 'En neien Artikel uleeën',
	'createpage-dialog-message1' => 'Super, Dir sidd am gaang eng nei Säit unzeleeën!',
	'createpage-dialog-message2' => 'Wéi wëllt Dir en nennen?',
	'createpage-dialog-choose' => 'Sicht e Layout vun der Säit aus:',
	'createpage-dialog-format' => 'Standard-Layout',
	'createpage-dialog-blank' => 'Eidel Säit',
	'createpage-error-empty-title' => 'Schreiwt w.e.g. en Titel an Ären Artikel',
	'createpage-error-invalid-title' => 'Pardon den titel vum Artikel ass net valabel.
Benotzt w.e.g. en aneren Titel.',
	'createpage-error-article-exists' => 'Et gëtt schonn en Artikel mat deem Titel.
Dir kënnt op <a href="$1">$2</a> goen oder Är Säit ëmbenennen',
	'createpage-error-article-spam' => 'Pardon, den Titel vum Artikel gouf vun eisem Spam-Filter blockéiert.
Benotzt w.e.g. en aneren Titel.',
	'createpage-error-article-blocked' => 'Pardon, Dir kënnt deen Artikel elo net uleeën.',
	'tog-createpagedefaultblank' => 'Benotzt eng eidel Säit als Standard fir eng nei Säit unzeleeën',
	'tog-createpagepopupdisabled' => 'De Flux  Pop-Up Dialog "En neien Artikel uleeën" ausschalten (Net geroden)',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Schreiwt den éischten Abschnitt vun Ärem Artikel hei.

== Iwwerschrëft vun der Sektioun ==

Schreiwt déi éischt Sektioun vun Ärem Artikel hei.

== Iwwerschrëft vun der Sektioun ==

Schreiwt déi zweet Sektioun vun Ärem Artikel hei.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Schreiwt den éischten Abschnitt vun Ärem Artikel hei.

== Iwwerschrëft vun der Sektioun ==

Schreiwt déi éischt Sektioun vun Ärem Artikel hei.

== Iwwerschrëft vun der Sektioun ==

Schreiwt déi zweet Sektioun vun Ärem Artikel hei.',
);

/** Lithuanian (lietuvių)
 * @author Eitvys200
 */
$messages['lt'] = array(
	'createpage-sp-title' => 'Sukurti naują puslapį',
	'createpage_title' => 'Sukurti naują puslapį',
	'createpage_title_caption' => 'Pavadinimas',
	'createpage_enter_text' => 'Tekstas:',
	'createpage_empty_title_error' => 'Pavadinimas būtinas',
	'createpage_empty_article_body_error' => 'Puslapio tekstas privalomas',
	'createpage_invalid_title_error' => 'Neleistinas pavadinimas',
	'createpage-dialog-title' => 'Sukurti naują puslapį',
	'createpage-dialog-choose' => 'Pasirinkite puslapio maketą:',
	'createpage-dialog-format' => 'Standartinis maketas',
	'createpage-dialog-blank' => 'Tuščias puslapis',
	'createpage-error-empty-title' => 'Prašome parašyti puslapio pavadinimą',
	'createpage-error-invalid-title' => 'Atsiprašome, puslapio pavadinimas yra negalimas.
Prašome naudoti kitą pavadinimą.',
	'createpage-error-article-exists' => 'Puslapis su šiuo pavadinmu jau egzistuoja.
Jūs galite eiti į <a href="$1">$2</a>, arba pervadinti savo puslapį',
	'createpage-error-article-spam' => 'Atsiprašome, puslapio pavadinimas buvo atmestas mūsų šlamšto filtro.
Prašome naudoti kitą pavadinimą.',
	'createpage-error-article-blocked' => 'Atsiprašome, jūs negalite sukurti šio puslapį šiuo metu.',
	'tog-createpagedefaultblank' => 'Naudoti tuščia puslapį kaip numatytąjį kuriant naują puslapį',
	'tog-createpagepopupdisabled' => 'Išjungti "Sukurti naują straipsnį" srautą (Nerekomenduojama)',
);

/** Mizo (Mizo ţawng)
 * @author RMizo
 */
$messages['lus'] = array(
	'createpage-desc' => 'Wikia WYSIWYG ziahna hmanga phêk thar siam theihna',
	'createpage-sp-title' => 'Phêk thar siamna',
	'createpage_title' => 'Phêk thar siam rawh le',
	'createpage_title_caption' => 'Thupui',
	'createpage_enter_text' => 'Thu:',
	'createpage_empty_title_error' => 'Thupui neihtir a ngai',
	'createpage_empty_article_body_error' => 'Thuziak a awm a ngai',
	'createpage_invalid_title_error' => 'Hming pawm loh',
	'createpage_article_already_exists' => 'Hemi phêk hming pu hi a awm tawh.
Hming thar khawngaihin thlang rawh.',
	'createpage_spam' => 'A pawi hle mai, i thuziak a dahţhat theih loh tlat',
	'createpage_cant_edit' => 'Siamţhat a tlawlh',
	'createpage-dialog-title' => 'Phêk thar siamna',
	'createpage-dialog-message1' => 'Lè lé lè le, phêk thar i siam e!',
	'createpage-dialog-message2' => 'Engtinnge i koh dawn le?',
	'createpage-dialog-choose' => 'Phêk intàrphung thlang rawh le:',
	'createpage-dialog-format' => 'Intàrphung pangngai',
	'createpage-dialog-blank' => 'Phêk ruak',
	'createpage-error-empty-title' => 'Phêk hming khawngaihin ziak rawh',
	'createpage-error-invalid-title' => 'A pawi hle mai, phêk hming pawm loh i thlang palh.
Hming thar khawngaihin thlang rawh.',
	'createpage-error-article-exists' => 'Hemi hming pu phêk hi a awm tawh tlat.
<a href="$1">$2</a>-ah i kal thei ang, a nih loh paw\'n a phêk hming i thlâk thei bawk ang.',
	'newpagelayout' => '[[File:Placeholder|right|300px]]

I phêk hläwm hmasa ber hetah hian ziak la.

==Ţhen hming==

I phêk ţhen hmasa ber hetah.

==Ţhen hming==

Hetah hian a ţhen hnihna.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]

I phêk hläwm hmasa ber hetah hian ziak la.

==Ţhen hming==

I phêk ţhen hmasa ber hetah.

==Ţhen hming==

Hetah hian a ţhen hnihna.',
);

/** Malagasy (Malagasy)
 * @author Jagwar
 */
$messages['mg'] = array(
	'createpage-desc' => "Avela mamorona pejy amin'ny mpanova pejy WYSWIG an'i Wikia",
	'createpage-sp-title' => 'Hamorona takelaka vaovzo',
	'createpage_title' => 'Hamorona takelaka vaovao',
	'createpage_title_caption' => 'Lohateny :', # Fuzzy
	'createpage_enter_text' => 'Soratra :',
	'createpage_empty_title_error' => 'Ilaina ny lohateny',
	'createpage_empty_article_body_error' => "Ilaina ny soratra ao amin'ny takelaka",
	'createpage_invalid_title_error' => 'Lohateny tsy ekena',
	'createpage_article_already_exists' => 'Efa misy ny takelaka mitondra io anarana io, misafidia anarana hafa',
	'createpage_spam' => 'Miala tsiny, fa tsy afaka notahirizina ny fanovanao',
	'createpage_cant_edit' => 'Tsy afaka manao ilay fanovana',
	'createpage-dialog-title' => 'Hamorona takelaka vaovao',
	'createpage-dialog-message1' => 'Hooray, am-pamoronana pejy vaovao ianao !',
	'createpage-dialog-message2' => 'Inona ny anarana tianao antsoina azy ?',
	'createpage-dialog-choose' => 'Safidio ny fametrahana am-pejy :',
	'createpage-dialog-format' => 'Fanehoana tsotra',
	'createpage-dialog-blank' => 'Pejy fotsy',
	'createpage-error-empty-title' => "Soraty ny lohatenin'ny takelakao",
	'createpage-error-invalid-title' => "Mala tsiny, tsy azo nekena ny lohatenin'ny lahatsoratra. Misafidia lohateny hafa.",
	'createpage-error-article-exists' => 'Efa misy ny takelaka mitondra io lohateny io. Afaka mandeha any amin\'ny <a href="$1">$2</a> ianao, na manova ny pejinao',
	'createpage-error-article-spam' => "Miala tsiny, fa ny lohatenin'ny pejinao dia nolavin'ny fitantavanana spam. Mampiasà anarana hafa.",
	'createpage-error-article-blocked' => "Miala tsiny, tsy afaka mamorona takelana ianao amin'izao fotoana izao.",
	'tog-createpagedefaultblank' => 'Mampiasa pejy fotsy tsipalotra mba hamorona pejy vaovao',
	'newpagelayout' => "[[File:Placeholder|right|300px]]
Soraty eto ny paragrafy voalohan'ny pejinao.

== Lohafizarana ==

Soraty eto ny fizarana voalohan'ny pejinao.

==Section heading==

Soraty eto ny fizarana faharoan'ny pejinao.",
	'createpage-with-video' => "[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Soraty eto ny paragrafy voalohan'ny pejinao.

== Lohafizarana ==

Soraty eto ny fizarana voalohan'ny pejinao.

==Section heading==

Soraty eto ny fizarana faharoan'ny pejinao.",
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'createpage-desc' => 'Овозможува создавање на нови страници со уредникот WYSIWYG',
	'createpage-sp-title' => 'Создавање на нова статија',
	'createpage_title' => 'Создај нова статија',
	'createpage_title_caption' => 'Наслов',
	'createpage_enter_text' => 'Текст:',
	'createpage_empty_title_error' => 'Се бара наслов',
	'createpage_empty_article_body_error' => 'Треба текст за статијата',
	'createpage_invalid_title_error' => 'Погрешен наслов',
	'createpage_article_already_exists' => 'Веќе постои статија со такво име. Одберете друго.',
	'createpage_spam' => 'За жал вашето уредување не можеше да се зачува',
	'createpage_cant_edit' => 'Не можев да го извршам уредувањето',
	'createpage-dialog-title' => 'Создавање на нова статија',
	'createpage-dialog-message1' => 'Супер, создавате нова страница!',
	'createpage-dialog-message2' => 'Како сакате да ја наречете?',
	'createpage-dialog-choose' => 'Одберете распоред на страницата:',
	'createpage-dialog-format' => 'Стандарден распоред',
	'createpage-dialog-blank' => 'Празна страница',
	'createpage-error-empty-title' => 'Напишете наслов за статијата',
	'createpage-error-invalid-title' => 'За жал насловот за статијата е погрешен. Дајте друг наслов.',
	'createpage-error-article-exists' => 'Веќе постои статија со таков наслов.  Можете да појдете на <a href="$1">$2</a>, или да ја преименувате страницата',
	'createpage-error-article-spam' => 'За жал насловот на статијата беше одбиен од филтерот за спам. Дајте друг наслов.',
	'createpage-error-article-blocked' => 'Жалиме, но во моментов не можете да создадете нова страница.',
	'tog-createpagedefaultblank' => 'Користи празна страница за создавање нова по основно',
	'tog-createpagepopupdisabled' => 'Оневозможи скокачки прозорец „Создај нова статија“ (не се препорачува)',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Тука напишете го првиот параграф на статијата.

==Наслов на заглавие==

Тука напишете го првото заглавие од статијата.

==Наслов на заглавие==

Тука напишете го второто заглавие од статијата.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Тука напишете го првиот параграф на статијата.

==Наслов на заглавие==

Тука напишете го првото заглавие од статијата.

==Наслов на заглавие==

Тука напишете го второто заглавие од статијата.',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'createpage-sp-title' => 'പുതിയൊരു താൾ സൃഷ്ടിക്കുക',
	'createpage_title' => 'പുതിയൊരു താൾ സൃഷ്ടിക്കുക',
	'createpage_title_caption' => 'ശീർഷകം:', # Fuzzy
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'createpage-desc' => 'Membolehkan penciptaan laman baru dengan menggunakan alat penyunting WYSIWYG Wikia',
	'createpage-sp-title' => 'Cipta laman baru',
	'createpage_title' => 'Cipta laman baru',
	'createpage_title_caption' => 'Tajuk',
	'createpage_enter_text' => 'Teks:',
	'createpage_empty_title_error' => 'Tajuk diperlukan',
	'createpage_empty_article_body_error' => 'Teks laman diperlukan',
	'createpage_invalid_title_error' => 'Tajuk tidak sah',
	'createpage_article_already_exists' => 'Nama itu sudah dipakai oleh laman lain.
Sila pilih nama lain.',
	'createpage_spam' => 'Maaf, suntingan anda tidak boleh disimpan',
	'createpage_cant_edit' => 'Suntingan tidak boleh dilakukan',
	'createpage-dialog-title' => 'Cipta laman baru',
	'createpage-dialog-message1' => 'Syabas, anda telah mencipta satu laman baru!',
	'createpage-dialog-message2' => 'Apakah nama yang anda ingin berikan kepadanya?',
	'createpage-dialog-choose' => 'Pilih tataletak laman:',
	'createpage-dialog-format' => 'Tataletak standard',
	'createpage-dialog-blank' => 'Laman kosong',
	'createpage-error-empty-title' => 'Sila tuliskan tajuk laman anda',
	'createpage-error-invalid-title' => 'Maaf, tajuk laman ini tidak sah.
Sila gunakan tajuk lain.',
	'createpage-error-article-exists' => 'Tajuk itu sudah dipakai oleh laman lain.
Anda boleh pergi ke <a href="$1">$2</a>, atau menukar nama laman anda',
	'createpage-error-article-spam' => 'Maaf, tajuk laman ini ditolak oleh penapis spam kami.
Sila gunakan tajuk lain.',
	'createpage-error-article-blocked' => 'Maaf, anda tidak boleh mencipta laman itu sekarang.',
	'tog-createpagedefaultblank' => 'Gunakan laman kosong sebagai sediaan untuk mencipta laman baru',
	'tog-createpagepopupdisabled' => 'Matikan ciri "Buat rencana baru" (Tidak Disaran)',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Isikan perenggan pertama laman anda di sini.

==Pengatas bahagian==

Isikan bahagian pertama laman anda di sini.

==Pengatas bahagian==

Isikan bahagian kedua laman anda di sini.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Isikan perenggan pertama laman anda di sini.

==Pengatas bahagian==

Isikan bahagian pertama laman anda di sini.

==Pengatas bahagian==

Isikan bahagian kedua laman anda di sini.',
);

/** Norwegian Bokmål (norsk (bokmål)‎)
 * @author Audun
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'createpage-desc' => 'Tillater å opprette en ny side med Wikias WYSIWYG-redaktør',
	'createpage-sp-title' => 'Skriv en ny artikkel',
	'createpage_title' => 'Skriv en ny artikkel',
	'createpage_title_caption' => 'Tittel',
	'createpage_enter_text' => 'Tekst:',
	'createpage_empty_title_error' => 'Tittel påkrevd',
	'createpage_empty_article_body_error' => 'Artikkeltekst påkrevd',
	'createpage_invalid_title_error' => 'Ugyldig tittel',
	'createpage_article_already_exists' => 'En artikkel med det navnet eksisterer allerede, vennligst velg et annet navn',
	'createpage_spam' => 'Beklager, endringen din kunne ikke lagres',
	'createpage_cant_edit' => 'Kunne ikke utføre endringen',
	'createpage-dialog-title' => 'Opprett en ny artikkel',
	'createpage-dialog-message1' => 'Hurra, du oppretter en ny side!',
	'createpage-dialog-message2' => 'Hva vil du kalle den?',
	'createpage-dialog-choose' => 'Velg et oppsett for siden:',
	'createpage-dialog-format' => 'Standardoppsett',
	'createpage-dialog-blank' => 'Blank side',
	'createpage-error-empty-title' => 'Vennligst skriv en tittel på artikkelen din',
	'createpage-error-invalid-title' => 'Beklager, artikkeltittelen var ugyldig.
Vennligst bruk en annen tittel.',
	'createpage-error-article-exists' => 'En artikkel med det navnet finnes allerede.
Du kan gå til <a href="$1">$2</a> eller gi siden din et nytt navn',
	'createpage-error-article-spam' => 'Beklager, artikkeltittelen ble avvist av spamfilteret vårt.
Vennligst bruk en annen tittel.',
	'createpage-error-article-blocked' => 'Beklager, du kan ikke opprettet artikler akkurat nå.',
	'tog-createpagedefaultblank' => 'Bruk en blank side som standard for å opprette en ny side',
	'tog-createpagepopupdisabled' => 'Deaktiver «Opprett en ny artikkel»-flyten (anbefales ikke)',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Skriv det første avsnittet i artikkelen din her.

==Seksjonsoverskrift==

Skriv den første seksjonen av artikkelen din her.

==Seksjonsoverskrift==

Skriv den andre seksjonen av artikkelen din her.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Skriv det første avsnittet i artikkelen din her.

==Seksjonsoverskrift==

Skriv den første seksjonen av artikkelen din her.

==Seksjonsoverskrift==

Skriv den andre seksjonen av artikkelen din her.',
);

/** Dutch (Nederlands)
 * @author McDutchie
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'createpage-desc' => "Maakt het mogelijk nieuwe pagina's aan te maken met Wikia's WYSIWYG-tekstverwerker",
	'createpage-sp-title' => 'Nieuwe pagina aanmaken',
	'createpage_title' => 'Nieuwe pagina aanmaken',
	'createpage_title_caption' => 'Paginanaam',
	'createpage_enter_text' => 'Tekst:',
	'createpage_empty_title_error' => 'Een paginanaam is verplicht',
	'createpage_empty_article_body_error' => 'Paginatekst is verplicht',
	'createpage_invalid_title_error' => 'Ongeldige paginanaam',
	'createpage_article_already_exists' => 'Er bestaat al een pagina met die naam.
Kies alstublieft een andere naam.',
	'createpage_spam' => 'Uw bewerking kon helaas niet worden opgeslagen',
	'createpage_cant_edit' => 'Het was niet mogelijk de bewerking uit te voeren',
	'createpage-dialog-title' => 'Nieuwe pagina aanmaken',
	'createpage-dialog-message1' => 'Gefeliciteerd.
U hebt een nieuwe pagina aangemaakt!',
	'createpage-dialog-message2' => 'Hoe wilt u de pagina noemen?',
	'createpage-dialog-choose' => 'Kies uw paginauiterlijk:',
	'createpage-dialog-format' => 'Standaardopmaak',
	'createpage-dialog-blank' => 'Lege pagina',
	'createpage-error-empty-title' => 'Geef een naam op voor uw pagina',
	'createpage-error-invalid-title' => 'Sorry, de paginanaam was ongeldig.
Gebruik alstublieft een andere naam.',
	'createpage-error-article-exists' => 'Er bestaat als een pagina met die naam.
U kunt naar "<a href="$1">$2</a>" gaan of uw pagina anders noemen',
	'createpage-error-article-spam' => 'Sorry, de paginanaam is verworpen door onze spamfilter.
Kies alstublieft een andere paginanaam.',
	'createpage-error-article-blocked' => "Sorry, maar u kunt op het moment geen nieuwe pagina's aanmaken.",
	'tog-createpagedefaultblank' => 'Lege pagina als standaard nieuwe pagina gebruiken',
	'tog-createpagepopupdisabled' => 'Workflow voor "Pagina aanmaken" uitschakelen (niet aanbevolen)',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Schrijf hier de eerste alinea van uw pagina.

==Paragraafkop==
Schrijf hier de eerste paragraaf van uw pagina.

==Paragraafkop==
Schrijf hier de tweede paragraaf van uw pagina.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Schrijf hier de eerste alinea van uw pagina.

==Paragraafkop==
Schrijf hier de eerste paragraaf van uw pagina.

==Paragraafkop==
Schrijf hier de tweede paragraaf van uw pagina.',
	'createpage-ve-body' => 'Het artikel <b>$1</b> bestaat nog niet op deze wikia. U kunt helpen door een paar zinnen toe te voegen.',
	'createpage-button-cancel' => 'Annuleren',
);

/** Nederlands (informeel)
 * @author Siebrand
 */
$messages['nl-informal'] = array(
	'createpage_spam' => 'Sorry, je bewerking kon niet worden opgeslagen',
	'createpage-dialog-message1' => 'Gefeliciteerd.
Je hebt een nieuwe pagina aangemaakt!',
	'createpage-dialog-message2' => 'Hoe wil je de pagina noemen?',
	'createpage-error-empty-title' => 'Geef een naam op voor je pagina',
	'createpage-error-article-exists' => 'Er bestaat als een pagina met die naam.
Je kunt naar "<a href="$1">$2</a>" gaan of je pagina anders noemen',
	'createpage-error-article-blocked' => "Sorry, maar je kunt op het moment geen nieuwe pagina's aanmaken.",
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Schrijf hier de eerste alinea van je pagina.

==Paragraafkop==
Schrijf hier de eerste paragraaf van je pagina.

==Paragraafkop==
Schrijf hier de tweede paragraaf van je pagina.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Schrijf hier de eerste alinea van je pagina.

==Paragraafkop==
Schrijf hier de eerste paragraaf van je pagina.

==Paragraafkop==
Schrijf hier de tweede paragraaf van je pagina.',
);

/** Punjabi (ਪੰਜਾਬੀ)
 * @author Aalam
 */
$messages['pa'] = array(
	'createpage-desc' => 'ਵਿਕਿ ਦੇ WYSIWYG ਐਡੀਟਰ ਦੀ ਵਰਤੋਂ ਕਰਕੇ ਨਵਾਂ ਸਫ਼ਾ ਬਣਾਉਣਾ ਮਨਜ਼ੂਰ',
	'createpage-sp-title' => 'ਨਵਾਂ ਸਫ਼ਾ ਬਣਾਉ',
	'createpage_title' => 'ਨਵਾਂ ਸਫ਼ਾ ਬਣਾਓ',
	'createpage_title_caption' => 'ਟਾਈਟਲ:', # Fuzzy
	'createpage_enter_text' => 'ਟੈਕਸਟ:',
	'createpage_empty_title_error' => 'ਟਾਈਟਲ ਚਾਹੀਦਾ ਹੈ',
	'createpage_empty_article_body_error' => 'ਸਫ਼ਾ ਟੈਕਸਟ ਚਾਹੀਦਾ ਹੈ',
	'createpage_invalid_title_error' => 'ਗਲਤ ਟਾਈਟਲ',
	'createpage_article_already_exists' => 'ਉਸ ਨਾਂ ਨਾਲ ਸਫ਼ਾ ਪਹਿਲਾਂ ਹੀ ਮਨਜ਼ੂਰ ਹੈ।
ਵੱਖਰਾ ਨਾਂ ਚੁਣੋ ਜੀ।',
	'createpage_spam' => 'ਅਫਸੋਸ, ਤੁਹਾਡੀ ਸੋਧ ਸੰਭਾਲੀ ਨਹੀਂ ਜਾ ਸਕੀ',
	'createpage-dialog-title' => 'ਨਵਾਂ ਸਫ਼ਾ ਬਣਾਓ',
	'createpage-dialog-message1' => 'ਬੱਲੇ ਬੱਲੇ, ਤੁਸੀਂ ਨਵਾਂ ਸਫ਼ਾ ਬਣਾਇਆ ਹੈ!',
	'createpage-dialog-message2' => 'ਤੁਸੀਂ ਇਸ ਦਾ ਕੀ ਨਾਂ ਰੱਖਣਾ ਚਾਹੁੰਦੇ ਹੋ?',
	'createpage-dialog-choose' => 'ਸਫ਼ਾ ਲੇਆਉਟ ਚੁਣੋ ਜੀ:',
	'createpage-dialog-format' => 'ਸਟੈਂਡਰਡ ਲੇਆਉਟ',
	'createpage-dialog-blank' => 'ਖਾਲੀ ਸਫ਼ਾ',
	'createpage-error-empty-title' => 'ਆਪਣੇ ਸਫ਼ੇ ਲਈ ਟਾਈਟਲ ਲਿਖੋ ਜੀ',
	'createpage-error-article-exists' => 'ਉਸ ਟਾਈਟਲ ਨਾਲ ਸਫ਼ਾ ਪਹਿਲਾਂ ਹੀ ਮੌਜੂਦ ਹੈ।
ਤੁਸੀਂ <a href="$1">$2</a> ਵਰਤ ਸਕਦੇ ਹੋ ਜਾਂ ਆਪਣੇ ਸਫ਼ੇ ਦਾ ਨਾਂ ਬਦਲ ਸਕਦੇ ਹੋ',
);

/** Pälzisch (Pälzisch)
 * @author Manuae
 */
$messages['pfl'] = array(
	'createpage_title_caption' => 'Tidl',
);

/** Polish (polski)
 * @author Cloudissimo
 * @author Sovq
 * @author Sp5uhe
 * @author Woytecr
 */
$messages['pl'] = array(
	'createpage-desc' => 'Pozwala na utworzenie nowej strony za pomocą edytora WYSIWYG',
	'createpage-sp-title' => 'Utwórz nową stronę',
	'createpage_title' => 'Utwórz nową stronę',
	'createpage_title_caption' => 'Tytuł',
	'createpage_enter_text' => 'Tekst:',
	'createpage_empty_title_error' => 'Tytuł jest wymagany',
	'createpage_empty_article_body_error' => 'Wymagane podanie treści strony',
	'createpage_invalid_title_error' => 'Nieprawidłowy tytuł',
	'createpage_article_already_exists' => 'Strona o żądanej nazwie już istnieje.
Wybierz inną nazwę.',
	'createpage_spam' => 'Niestety zmiany nie mogą zostać zapisane',
	'createpage_cant_edit' => 'Nie można wykonać edycji',
	'createpage-dialog-title' => 'Utwórz nową stronę',
	'createpage-dialog-message1' => 'Hura! Tworzysz nową stronę!',
	'createpage-dialog-message2' => 'Jak chcesz ją nazwać?',
	'createpage-dialog-choose' => 'Wybierz układ strony:',
	'createpage-dialog-format' => 'Standardowy układ',
	'createpage-dialog-blank' => 'Pusta strona',
	'createpage-error-empty-title' => 'Podaj tytuł strony',
	'createpage-error-invalid-title' => 'Tytuł strony jest nieprawidłowy.
Podaj inny tytuł.',
	'createpage-error-article-exists' => 'Strona o tym tytule już istnieje.
Możesz przejść do <a href="$1">$2</a>, lub zmienić nazwę strony',
	'createpage-error-article-spam' => 'Tytuł strony został odrzucony przez nasz filtr antyspamowy.
Podaj inny tytuł.',
	'createpage-error-article-blocked' => 'Nie można utworzyć strony w tej chwili.',
	'tog-createpagedefaultblank' => 'Domyślnie twórz nowe strony puste',
	'tog-createpagepopupdisabled' => 'Wyłącz wyskakujące okno tworzenia nowego artykułu (nie zalecane)',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Tutaj umieść treść pierwszego paragrafu.

==Nagłówek sekcji==

Tutaj napisz treść pierwszej sekcji strony.

==Nagłówek sekcji==

Tutaj napisz treść drugiej sekcji strony.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Tutaj umieść treść pierwszego paragrafu.

==Nagłówek sekcji==

Tutaj napisz treść pierwszej sekcji strony.

==Nagłówek sekcji==

Tutaj napisz treść drugiej sekcji strony.',
	'createpage-ve-body' => 'Artykuł <b>$1</b> nie istnieje jeszcze w tej wikia. Możesz pomóc, dodając kilka zdań.',
	'createpage-button-cancel' => 'Anuluj',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'createpage-desc' => "A përmët ëd creé na pàgina neuva an dovrand l'editor WYSIWYG ëd Wikia",
	'createpage-sp-title' => 'Creé un neuv artìcol',
	'createpage_title' => 'Creé un neuv artìcol',
	'createpage_title_caption' => 'Tìtol',
	'createpage_enter_text' => 'Test:',
	'createpage_empty_title_error' => "Ël tìtol a l'é obligatòri",
	'createpage_empty_article_body_error' => "Ël test ëd l'artìcol a l'é obligatòri",
	'createpage_invalid_title_error' => 'Tìtol nen vàlid',
	'createpage_article_already_exists' => "N'artìcol con col nòm a esist già.
Për piasì selession-a un nòm diferent.",
	'createpage_spam' => 'Darmage, soa modìfica a peul pa esse salvà',
	'createpage_cant_edit' => "As peul pa fesse 'd modìfiche",
	'createpage-dialog-title' => 'Creé un Neuv Artìcol',
	'createpage-dialog-message1' => "Che bel, a l'é an camin ch'a crea na pàgina neuva!",
	'createpage-dialog-message2' => "Com ch'it veule ciamelo?",
	'createpage-dialog-choose' => 'Sern na presentassion ëd pàgina:',
	'createpage-dialog-format' => 'Presentassion stàndard',
	'createpage-dialog-blank' => 'Pàgina veuida',
	'createpage-error-empty-title' => 'Për piasì scriv un tìtol për tò artìcol',
	'createpage-error-invalid-title' => "Darmagi, ël tìtol ëd l'artìcol a l'é pa bon.
Për piasì, ch'a deuvra un tìtol diferent.",
	'createpage-error-article-exists' => 'N\'artìcol con col tìtol a esist già.
A peul andé a <a href="$1">$2</a>, o deje n\'àutr nòm a soa pàgina.',
	'createpage-error-article-spam' => "Darmagi, ël tìtol ëd l'artìcol a l'é stàit arfudà dal filtror ëd la rumenta.
Për piasì, ch'a deuvra un tìtol diferent.",
	'createpage-error-article-blocked' => 'Darmagi, a peul pa creé col artìcol adess.',
	'tog-createpagedefaultblank' => "Ch'a deuvra na pàgina polida për creé na neuva pàgina.",
	'tog-createpagepopupdisabled' => 'Disabilité ël fluss "Crea n\'artìcol neuv" (Pa Racomandà)',
	'newpagelayout' => "[[File:Placeholder|right|300px]]
Ch'a scriva ambelessì ël prim paràgraf ëd sò artìcol.

==Antestassion ëd la session==

Ch'a scriva ambelessì la prima session ëd sò artìcol.

==Antestassion ëd la session==

Ch'a scriva ambelessì la sconda session ëd sò artìcol.",
	'createpage-with-video' => "[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Ch'a scriva ambelessì ël prim paràgraf ëd sò artìcol.

==Antestassion ëd la session==

Ch'a scriva ambelessì la prima session ëd sò artìcol.

==Antestassion ëd la session==

Ch'a scriva ambelessì la sconda session ëd sò artìcol.",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'createpage-sp-title' => 'يوه نوې ليکنه ليکل',
	'createpage_title' => 'يوه نوې ليکنه ليکل',
	'createpage_title_caption' => 'سرليک',
	'createpage_enter_text' => 'متن:',
	'createpage_invalid_title_error' => 'ناسم سرليک',
	'createpage-dialog-title' => 'يوه نوې ليکنه ليکل',
	'createpage-dialog-message2' => 'څه يې نومول غواړې؟',
	'createpage-dialog-blank' => 'تش مخ',
	'createpage-error-empty-title' => 'لطفاً خپل مخ ته يو سرليک وليکۍ.',
	'newpagelayout' => '[[دوتنه:Placeholder|ښي|300px]]
د خپل د مخ لومړی پاراګراف دلته وليکۍ.

==د برخې سرليک==

د خپل د مخ لومړۍ برخه دلته وليکۍ.

==د برخې سرليک==

د خپل د مخ دويمه برخه دلته وليکۍ.',
	'createpage-with-video' => '[[دوتنه:Placeholder|video|right|300px]] [[دوتنه:Placeholder|ښي|300px]]
د خپل د مخ لومړی پاراګراف دلته وليکۍ.

==د برخې سرليک==

د خپل د مخ لومړۍ برخه دلته وليکۍ.

==د برخې سرليک==

د خپل د مخ دويمه برخه دلته وليکۍ.',);

/** Portuguese (português)
 * @author Hamilton Abreu
 * @author Malafaya
 * @author Rhaijin
 * @author SandroHc
 */
$messages['pt'] = array(
	'createpage-desc' => 'Permite criar uma página nova usando o editor WYSIWYG da Wikia',
	'createpage-sp-title' => 'Criar uma página nova',
	'createpage_title' => 'Criar uma página nova',
	'createpage_title_caption' => 'Título',
	'createpage_enter_text' => 'Texto:',
	'createpage_empty_title_error' => 'Título é obrigatório',
	'createpage_empty_article_body_error' => 'Texto é obrigatório',
	'createpage_invalid_title_error' => 'Título inválido',
	'createpage_article_already_exists' => 'Já existe uma página com esse nome.
Escolha outro nome, por favor.',
	'createpage_spam' => 'Não foi possível gravar a sua edição',
	'createpage_cant_edit' => 'Não foi possível fazer a edição',
	'createpage-dialog-title' => 'Criar uma página nova',
	'createpage-dialog-message1' => 'Está a criar uma página nova!',
	'createpage-dialog-message2' => 'Que nome lhe quer dar?',
	'createpage-dialog-choose' => 'Escolha um modelo de página:',
	'createpage-dialog-format' => 'Modelo padrão',
	'createpage-dialog-blank' => 'Página em branco',
	'createpage-error-empty-title' => 'Introduza um título para a sua página, por favor',
	'createpage-error-invalid-title' => 'O título da página era inválido.
Use outro título, por favor.',
	'createpage-error-article-exists' => 'Já existe uma página com esse título.
Pode visitá-la em <a href="$1">$2</a>, ou alterar o nome da sua',
	'createpage-error-article-spam' => 'O título da página foi rejeitado pelo filtro de spam.
Use outro título, por favor.',
	'createpage-error-article-blocked' => 'Não pode criar essa página neste momento.',
	'tog-createpagedefaultblank' => 'Por omissão, usar uma página em branco para criar uma página nova',
	'tog-createpagepopupdisabled' => 'Desactivar a janela flutuante Criar Página',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Escreva aqui o primeiro parágrafo da sua página.

==Cabeçalho de secção==

Escreva aqui a primeira secção da sua página.

==Cabeçalho de secção==

Escreva aqui a segunda secção da sua página.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Escreva aqui o primeiro parágrafo da sua página.

==Cabeçalho de secção==

Escreva aqui a primeira secção da sua página.

==Cabeçalho de secção==

Escreva aqui a segunda secção da sua página.',
	'createpage-ve-body' => 'O artigo <b>$1</b> ainda não existe nesta wikia. Você pode ajudar adicionando algumas frases.',
	'createpage-button-cancel' => 'Cancelar',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Giro720
 * @author Jesielt
 * @author Rhaijin
 * @author TheGabrielZaum
 */
$messages['pt-br'] = array(
	'createpage-desc' => 'Permite criar uma página nova usando o editor WYSIWYG da Wikia',
	'createpage-sp-title' => 'Crie um novo artigo',
	'createpage_title' => 'Crie um novo artigo',
	'createpage_title_caption' => 'Título',
	'createpage_enter_text' => 'Texto:',
	'createpage_empty_title_error' => 'Título requerido',
	'createpage_empty_article_body_error' => 'Texto de artigo requerido',
	'createpage_invalid_title_error' => 'Título inválido',
	'createpage_article_already_exists' => 'Já existe um artigo com esse nome.
Por favor, selecione um nome difetente.',
	'createpage_spam' => 'Desculpe-nos, sua edição não pôde ser salva',
	'createpage_cant_edit' => 'Não se pôde efetuar a edição',
	'createpage-dialog-title' => 'Crie um novo artigo',
	'createpage-dialog-message1' => 'Parabéns! Você está criando uma nova página.',
	'createpage-dialog-message2' => 'Como gostaria de chamá-la?',
	'createpage-dialog-choose' => 'Escolha um layout para a página:',
	'createpage-dialog-format' => 'Layout padrão',
	'createpage-dialog-blank' => 'Página em branco',
	'createpage-error-empty-title' => 'Por favor, escreva um título pra seu artigo',
	'createpage-error-invalid-title' => 'Desculpe-nos, o título do artigo era inválido.
Por favor, use um título diferente.',
	'createpage-error-article-exists' => 'Já existe um artigo com aquele título.
Você pode ir a <a href="$1">$2</a>, ou renomear a sua página.',
	'createpage-error-article-spam' => 'Desculpe-nos, o título do artigo foi rejeitado pelo nosso filtro de spam.
Por favor, use um título diferente.',
	'createpage-error-article-blocked' => 'Desculpe-nos, você está impossibilitado de criar aquele artigo agora.',
	'tog-createpagedefaultblank' => 'Usar uma página em branco como padrão para criar uma nova página',
	'tog-createpagepopupdisabled' => 'Desactivar a janela flutuante Criar Página',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Escreva o primeiro parágrafo do seu artigo aqui.

==Cabeçalho de seção==

Escreva a primeira seção do seu artigo aqui.

==Cabeçalho de seção==

Escreva a segunda seção do seu artigo aqui.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Escreva o primeiro parágrafo do seu artigo aqui.

==Cabeçalho de seção==

Escreva a primeira seção do seu artigo aqui.

==Cabeçalho de seção==

Escreva a segunda seção do seu artigo aqui.',
	'createpage-ve-body' => 'O artigo <b>$1</b> ainda não existe nesta wikia. Você pode ajudar adicionando algumas frases.',
	'createpage-button-cancel' => 'Cancelar',
);

/** Romanian (română)
 * @author Minisarm
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'createpage-sp-title' => 'Creează o pagină nouă',
	'createpage_title' => 'Creează o pagină nouă',
	'createpage_title_caption' => 'Titlu',
	'createpage_enter_text' => 'Text:',
	'createpage_empty_title_error' => 'Titlul necesar',
	'createpage_empty_article_body_error' => 'Textul paginii este necesar',
	'createpage_invalid_title_error' => 'Titlu invalid',
	'createpage_cant_edit' => 'Nu se poate efectua modificarea',
	'createpage-dialog-title' => 'Creează o pagină nouă',
	'createpage-dialog-message1' => 'Ura! În acest moment creați o nouă pagină!',
	'createpage-dialog-blank' => 'Pagină necompletată',
);

/** Russian (русский)
 * @author Kuzura
 * @author Lockal
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'createpage-desc' => 'Позволяет создавать новые страницы с помощью визуального редактора Викии',
	'createpage-sp-title' => 'Создание новой статьи',
	'createpage_title' => 'Создание новой статьи',
	'createpage_title_caption' => 'Название',
	'createpage_enter_text' => 'Текст:',
	'createpage_empty_title_error' => 'Заголовок обязателен',
	'createpage_empty_article_body_error' => 'Текст статьи обязателен',
	'createpage_invalid_title_error' => 'Недопустимое название',
	'createpage_article_already_exists' => 'Статья с таким именем уже существует.
Пожалуйста, выберите другое имя.',
	'createpage_spam' => 'К сожалению, ваша правка не может быть сохранена',
	'createpage_cant_edit' => 'Не удалось выполнить правку',
	'createpage-dialog-title' => 'Создание новой статьи',
	'createpage-dialog-message1' => 'Ура, вы создаёте новую страницу!',
	'createpage-dialog-message2' => 'Как вы хотите её назвать?',
	'createpage-dialog-choose' => 'Выберите макет страницы:',
	'createpage-dialog-format' => 'Стандартный макет',
	'createpage-dialog-blank' => 'Пустая страница',
	'createpage-error-empty-title' => 'Пожалуйста, напишите название для вашей статьи',
	'createpage-error-invalid-title' => 'К сожалению, название статьи недопустимо.
Пожалуйста, используйте другое название.',
	'createpage-error-article-exists' => 'Статья с таким названием уже существует.
Вы можете перейти на страницу <a href="$1">$2</a> или переименовать свою страницу',
	'createpage-error-article-spam' => 'К сожалению, название статьи было отклонено нашим спам-фильтром.
Пожалуйста, используйте другое название.',
	'createpage-error-article-blocked' => 'К сожалению, вы не можете создать эту статью в настоящее время.',
	'tog-createpagedefaultblank' => 'Использовать пустую страницу по умолчанию при создании новой страницы',
	'tog-createpagepopupdisabled' => 'Отключить всплывающее окно "Создать новую статью" (не рекомендуется)',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Напишите здесь первый параграф вашей статьи.

==Заголовок секции==

Напишите здесь первую секцию вашей статьи.

==Заголовок секции==

Напишите здесь вторую секцию вашей статьи.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Напишите здесь первый параграф вашей статьи.

==Заголовок секции==

Напишите здесь первую секцию вашей статьи.

==Заголовок секции==

Напишите здесь вторую секцию вашей статьи.',
	'createpage-ve-body' => 'Статья <b>$1</b> еще не существует на этом сервисе wikia. Вы можете помочь, добавив несколько предложений.',
	'createpage-button-cancel' => 'Отмена',
);

/** Sakha (саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'createpage-desc' => 'Викиа визуал эрэдээктэрин көмөтүнэн саҥа сирэйдэри оҥорору хааччыйар',
	'createpage-sp-title' => 'Саҥа сирэйи оҥоруу',
	'createpage_title' => 'Саҥа ыстатыйаны айыы',
	'createpage_title_caption' => 'Аата:', # Fuzzy
	'createpage_enter_text' => 'Тиэкиһэ:',
	'createpage_empty_title_error' => 'Хайаан да ааттаныахтаах',
	'createpage_empty_article_body_error' => 'Хайаан да тиэкистээх буолуохтаах',
	'createpage_invalid_title_error' => 'Сатаммат аат',
	'createpage_article_already_exists' => 'маннык ааттаах ыстатыйа баар эбит.
Бука диэн, атын аатта суруй.',
	'createpage_spam' => 'Баалаама, эн көннөрүүҥ бигэргэтиллэр кыаҕа суох эбит',
	'createpage_cant_edit' => 'Көннөрүү кыайан киирбэтэ',
	'createpage-dialog-title' => 'Саҥа ыстатыйаны айыы',
	'createpage-dialog-message1' => 'Уруй, эн саҥа ыстатыйаны айан эрэҕин!',
	'createpage-dialog-message2' => 'Хайдах ааттаары гынаҕын?',
	'createpage-dialog-choose' => 'Сирэй макетын тал:',
	'createpage-dialog-format' => 'Стандарт макет',
	'createpage-dialog-blank' => 'Кураанах сирэй',
	'createpage-error-empty-title' => 'Бука диэн, ыстатыйаҕын ааттаа',
	'createpage-error-invalid-title' => 'Баалаама, ыстатыйаҥ аата барсыбат.
Бука диэн, атыннык ааттаа.',
	'createpage-error-article-exists' => 'Маннык ааттаах ыстатыйа баар эбит.
<a href="$1">$2</a> сирэйгэ киириэххин сөп эбэтэр бэйэҥ айбыт сирэйгин атыннык ааттыаххын сөп',
	'createpage-error-article-spam' => 'Баалаама, эн суруйбут ааккын спаам-сиидэ аһарбата.
Бука диэн, атын ааты тал.',
	'createpage-error-article-blocked' => 'Хомойуох иһин, билигин маннык ыстатыйаны айарыҥ табыллыбат.',
	'tog-createpagedefaultblank' => 'Саҥа сирэйи айар буоллахха кураанах сирэйи аһарга',
	'tog-createpagepopupdisabled' => 'Саҥа сирэйи айарга тахсан кэлэр түннүгү таһаарыма', # Fuzzy
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Манна ыстатыйаҥ бастакы аҥаарын суруй.

==Салаа баһа==

Манна ыстатыйаҥ бастакы салаатын суруй.

==Салаа баһа==

Манна ыстатыйаҥ иккис салаатын суруй.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Манна ыстатыйаҥ бастакы аҥаарын суруй.

==Салаа баһа==

Манна ыстатыйаҥ бастакы салаатын суруй.

==Салаа баһа==

Манна ыстатыйаҥ иккис салаатын суруй.',
);

/** Serbian (Cyrillic script) (српски (ћирилица)‎)
 * @author Rancher
 * @author Verlor
 * @author Жељко Тодоровић
 */
$messages['sr-ec'] = array(
	'createpage-sp-title' => 'Направи нову страницу',
	'createpage_title' => 'Направи нову страницу',
	'createpage_title_caption' => 'Наслов',
	'createpage_enter_text' => 'Текст:',
	'createpage_empty_title_error' => 'Потребан је наслов',
	'createpage_empty_article_body_error' => 'Потребан је текст чланка',
	'createpage_invalid_title_error' => 'Неисправан наслов',
	'createpage_article_already_exists' => 'Страница с тим именом већ постоји.
Изаберите друго име.',
	'createpage_spam' => 'Ваша измена није сачувана.',
	'createpage_cant_edit' => 'Измена није извршена',
	'createpage-dialog-title' => 'Направи нову страницу',
	'createpage-dialog-message1' => 'Пишете нову страницу!',
	'createpage-dialog-message2' => 'Како желите да је назовете?',
	'createpage-dialog-choose' => 'Изаберите изглед странице:',
	'createpage-dialog-format' => 'Стандардан распоред',
	'createpage-dialog-blank' => 'Празна страница',
	'createpage-error-empty-title' => 'Унесите наслов странице',
	'createpage-error-invalid-title' => 'Наслов странице је неисправан.
Унесите други назив.',
	'createpage-error-article-exists' => 'Страница с тим називом већ постоји.
Посетите <a href="$1">$2</a> или преименујте је.',
	'createpage-error-article-blocked' => 'Не можете да направите страницу.',
);

/** Swedish (svenska)
 * @author Per
 * @author Tobulos1
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'createpage-desc' => 'Låter att skapa en ny sida med hjälp av Wikias WYSIWYG-redigerare',
	'createpage-sp-title' => 'Skapa en ny sida',
	'createpage_title' => 'Skapa en ny sida',
	'createpage_title_caption' => 'Titel',
	'createpage_enter_text' => 'Text:',
	'createpage_empty_title_error' => 'Rubrik krävs',
	'createpage_empty_article_body_error' => 'Text på sidan krävs',
	'createpage_invalid_title_error' => 'Ogiltig rubrik',
	'createpage_article_already_exists' => 'En sida med det namnet finns redan.
Välj ett annat namn.',
	'createpage_spam' => 'Tyvärr, din redigering kunde inte sparas',
	'createpage_cant_edit' => 'Kunde inte utföra redigering',
	'createpage-dialog-title' => 'Skapa en ny sida',
	'createpage-dialog-message1' => 'Hurra, du skapar en ny sida!',
	'createpage-dialog-message2' => 'Vad vill du kalla den?',
	'createpage-dialog-choose' => 'Välj en sidlayout:',
	'createpage-dialog-format' => 'Standard layout',
	'createpage-dialog-blank' => 'Tom sida',
	'createpage-error-empty-title' => 'Vänligen skriv in en rubrik för din sida.',
	'createpage-error-invalid-title' => 'Tyvärr, den rubriken är ogiltig.
Använd en annan rubrik.',
	'createpage-error-article-exists' => 'En sida med den rubriken finns redan.
Du kan gå till <a href="$1">$2</a>, eller byta namn på din sida',
	'createpage-error-article-spam' => 'Tyvärr stoppades den rubriken av vårt spamfilter.
Använd en annan titel.',
	'createpage-error-article-blocked' => 'Tyvärr kan du inte skapa den sidan just nu.',
	'tog-createpagedefaultblank' => 'Använd en tom sida som standard för att skapa en ny sida',
	'tog-createpagepopupdisabled' => 'Inaktivera flödet "Skapa en ny artikel" (rekommenderas inte)',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Skriv det första stycket på din sida här.

==Rubrik på avsnitt==

Skriv det första avsnittet på din sida här.

==Rubrik på avsnitt==

Skriv det andra avsnittet på din sida här',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Skriv det första stycket på din sida här.

==Rubrik på avsnitt==

Skriv det första avsnittet på din sida här.

==Rubrik på avsnitt==

Skriv det andra avsnittet på din sida här',
);

/** Swahili (Kiswahili)
 */
$messages['sw'] = array(
	'createpage_title_caption' => 'Cheo:', # Fuzzy
	'createpage_invalid_title_error' => 'Jina batili',
	'createpage-dialog-blank' => 'Ukurasa tupu',
);

/** Tamil (தமிழ்)
 * @author TRYPPN
 */
$messages['ta'] = array(
	'createpage-sp-title' => 'ஒரு புதிய பக்கத்தை உருவாக்கவும்',
	'createpage_title' => 'ஒரு புதிய பக்கத்தை உருவாக்கவும்',
	'createpage_title_caption' => 'தலைப்பு:', # Fuzzy
	'createpage_enter_text' => 'சொற்றொடர்:',
	'createpage_invalid_title_error' => 'தவறான தலைப்பு',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'createpage_title_caption' => 'శీర్షిక:', # Fuzzy
	'createpage_enter_text' => 'పాఠ్యం:',
	'createpage_empty_title_error' => 'శీర్షిక తప్పనిసరి',
	'createpage_empty_article_body_error' => 'వ్యాసపు పాఠ్యం తప్పనిసరి',
	'createpage_invalid_title_error' => 'తప్పుడు శీర్షిక',
	'createpage-dialog-blank' => 'ఖాళీ పేజీ',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'createpage-desc' => 'Nagpapahintulot upang makalikha ng isang bagong pahina na gumagamit ng patnugot na WYSIWYG ng Wikia',
	'createpage-sp-title' => 'Lumikha ng isang bagong artikulo',
	'createpage_title' => 'Lumikha ng isang bagong artikulo',
	'createpage_title_caption' => 'Pamagat',
	'createpage_enter_text' => 'Teksto:',
	'createpage_empty_title_error' => 'Kailangan ang pamagat',
	'createpage_empty_article_body_error' => 'Kailangan ang teksto ng artikulo',
	'createpage_invalid_title_error' => 'Hindi tanggap na pamagat',
	'createpage_article_already_exists' => 'Umiiral na ang artikulong may ganyang pangalan.
Mangyaring pumili ng ibang pangalan.',
	'createpage_spam' => 'Paumanhin, hindi masasagip ang pagbabago mo',
	'createpage_cant_edit' => 'Hindi magampanan ang pamamatnugot',
	'createpage-dialog-title' => 'Lumikha ng Isang Bagong Artikulo',
	'createpage-dialog-message1' => 'Yehey, lumilikha ka ng isang bagong pahina!',
	'createpage-dialog-message2' => 'Ano katawagan ang nais mo para rito?',
	'createpage-dialog-choose' => 'Pumili ng isang ayos ng pahina:',
	'createpage-dialog-format' => 'Karaniwang ayos',
	'createpage-dialog-blank' => 'Pahinang walang laman',
	'createpage-error-empty-title' => 'Mangyaring magsulat ng isang pamagat para sa iyong artikulo',
	'createpage-error-invalid-title' => 'Paumanhin, hindi tanggap ang pamagat ng artikulo.
Mangyaring gumamit ng ibang pamagat.',
	'createpage-error-article-exists' => 'Umiiral na ang isang artikulong may ganyang pamagat.
Maaari kang pumunta sa <a href="$1">$2</a>, o palitan ang pangalan ng pahina mo.',
	'createpage-error-article-spam' => 'Paumahin, tinanggihan ng aming pansala ng manlulusob ang pamagat ng artikulo mo.
Mangyaring gumamit ng ibang pamagat.',
	'createpage-error-article-blocked' => 'Paumanhin, hindi mo nagawang likhaing artikulong iyan sa ngayon.',
	'tog-createpagedefaultblank' => 'Gamitin ang pahinang walang laman para sa paglikha ng isang bagong pahina',
	'tog-createpagepopupdisabled' => 'Huwag paganahin ang daloy na "Lumikha ng isang bagong pahina" (Hindi Iminumungkahi)',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Isulat ang unang talata ng iyong artikulo dito.

==Ulo ng seksyon==

Isulat ang unang sekyon ng artikulo mo rito.

==Ulo ng seksyon==

Isulat ang pangalawang ulo ng sekyon mo rito.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Isulat ang unang talata ng iyong artikulo dito.

==Ulo ng seksyon==

Isulat ang unang sekyon ng artikulo mo rito.

==Ulo ng seksyon==

Isulat ang pangalawang ulo ng sekyon mo rito.',
);

/** Turkish (Türkçe)
 * @author Suelnur
 */
$messages['tr'] = array(
	'createpage-dialog-blank' => 'Boş sayfa',
);

/** Tatar (Cyrillic script) (татарча)
 * @author Ajdar
 */
$messages['tt-cyrl'] = array(
	'createpage-desc' => 'Викиянең визуаль редакторы ярдәмендә яңа мәкаләләр төзергә мөмкинлек бирә',
	'createpage-sp-title' => 'Яңа мәкалә язу',
	'createpage_title' => 'Яңа мәкалә язу',
	'createpage_title_caption' => 'Исем',
	'createpage_enter_text' => 'Текст',
	'createpage_empty_title_error' => 'Исем мәҗбүри',
	'createpage_empty_article_body_error' => 'Мәкалә тексты мәҗбүри',
	'createpage_invalid_title_error' => 'Мөмкин булмаган исем',
	'createpage_article_already_exists' => 'Мондый исемле мәкалә бар инде.
Зинһар өчен, башка исем сайлагыз.',
	'createpage_spam' => 'Кызганычка, сезнең үзгәртүне саклап булмый',
	'createpage_cant_edit' => 'Үзгәртүне башкарып булмады',
	'createpage-dialog-title' => 'Яңа мәкалә язу',
	'createpage-dialog-message1' => 'Афәрин, сез яңа мәкалә язасыз!',
	'createpage-dialog-message2' => 'Аны ничек атарга телисез?',
	'createpage-dialog-choose' => 'Битнең макетын сайлагыз:',
	'createpage-dialog-format' => 'Стандарт кыса',
	'createpage-dialog-blank' => 'Буш бит',
	'createpage-error-empty-title' => 'Зинһар өчен, мәкаләгезнең исемен языгыз',
	'createpage-error-invalid-title' => 'Кызганычка, мәкалә өчен мондый исем тыелган.
Зинһар өчен, башка исем кулланыгыз.',
	'createpage-error-article-exists' => 'Мондый исемле мәкалә бар инде.
Сез <a href="$1">$2</a> сәхифәсенә күчә аласыз, яки мәкаләнең исемен үзгәртергә мөмкин.',
	'createpage-error-article-spam' => 'Кызганычка, мәкалә исеме безнең спам-фильтр тарафыннан тыелды.
Зинһар өчен, башка исем кулланыгыз.',
	'createpage-error-article-blocked' => 'Кызганычка, сез бу мәкаләне хәзер ясый алмыйсыз.',
	'tog-createpagedefaultblank' => 'Яңа мәкалә ясаганда буш бит кулланырга.',
	'tog-createpagepopupdisabled' => '"Яңа мәкалә язу" йөззүче тәрәзәсен сүндерергә (тәкъдим ителми)',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Монда мәкаләгезнең беренче параграфын языгыз.

==Бүлек исеме==

Монда мәкаләнең беренче бүлеген языгыз.

==Бүлек исеме==

Монда мәкаләнең киләсе бүлеген языгыз.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Монда мәкаләгезнең беренче параграфын языгыз.

==Бүлек исеме==

Монда мәкаләнең беренче бүлеген языгыз.

==Бүлек исеме==

Монда мәкаләнең киләсе бүлеген языгыз.',
);

/** Ukrainian (українська)
 * @author A1
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'createpage-desc' => 'Дозволяє створити нові сторінки за допомогою WYSIWYG редактора',
	'createpage-sp-title' => 'Створити нову статтю',
	'createpage_title' => 'Створити нову статтю',
	'createpage_title_caption' => 'Назва',
	'createpage_enter_text' => 'Текст:',
	'createpage_empty_title_error' => 'Необхідно вказати назву',
	'createpage_empty_article_body_error' => 'Необхідно ввести текст статті',
	'createpage_invalid_title_error' => 'Неприпустима назва',
	'createpage_article_already_exists' => 'Стаття з такою назвою вже існує.
Будь ласка, оберіть іншу назву.',
	'createpage_spam' => 'На жаль, не вдалося зберегти ваші редагування',
	'createpage_cant_edit' => 'Не вдалося виконати редагування',
	'createpage-dialog-title' => 'Створити нову статтю',
	'createpage-dialog-message1' => 'Ура, ви створюєте нову сторінку!',
	'createpage-dialog-message2' => 'Як назвати сторінку?',
	'createpage-dialog-choose' => 'Виберіть макет сторінки:',
	'createpage-dialog-format' => 'Стандартний макет',
	'createpage-dialog-blank' => 'Порожня сторінка',
	'createpage-error-empty-title' => 'Будь ласка, введіть назву вашої сторінки.',
	'createpage-error-invalid-title' => 'Назва не припустима. Придумайте іншу.',
	'createpage-error-article-exists' => 'Сторінка з такою назвою вже існує. Огляньте <a href="$1">$2</a>, або перейменуйте свою сторінку',
	'createpage-error-article-spam' => 'На жаль, заголовок сторінки відхилив спам-фільтра.
Будь ласка, спробуйте іншу назву.',
	'createpage-error-article-blocked' => 'На жаль, не вдається створити сторінку.',
	'tog-createpagedefaultblank' => 'Використовувати порожню сторінку за замовчуванням для створення нової сторінки',
	'tog-createpagepopupdisabled' => 'Вимкнути виринаюче вікно "Створити нову статтю" (не рекомендовано)',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Напишіть тут перший параграф вашої статті.

==Заголовок розділу==

Напишіть тут перший розділ вашої статті.

==Заголовок розділу==

Напишіть тут другий розділ вашої статті.',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Напишіть тут перший параграф вашої статті.

==Заголовок розділу==

Напишіть тут перший розділ вашої статті.

==Заголовок розділу==

Напишіть тут другий розділ вашої статті.',
);

/** Veps (vepsän kel’)
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'createpage_title_caption' => 'Pälkirjutez',
	'createpage_enter_text' => 'Tekst:',
	'createpage-dialog-title' => "Säta uz' lehtpol'",
	'createpage-dialog-blank' => "Puhtaz lehtpol'",
);

/** Vietnamese (Tiếng Việt)
 * @author Xiao Qiao
 */
$messages['vi'] = array(
	'createpage-desc' => 'Cho phép tạo ra một trang mới bằng cách sử dụng trình soạn thảo WYSIWYG của Wikia',
	'createpage-sp-title' => 'Tạo một trang mới',
	'createpage_title' => 'Tạo một trang mới',
	'createpage_title_caption' => 'Tiêu đề',
	'createpage_enter_text' => 'Văn bản:',
	'createpage_empty_title_error' => 'Tiêu đề bắt buộc',
	'createpage_empty_article_body_error' => 'Trang văn bản yêu cầu',
	'createpage_invalid_title_error' => 'Tiêu đề không hợp lệ',
	'createpage_article_already_exists' => 'Một trang với tên đó đã tồn tại.
Xin vui lòng chọn tên khác.',
	'createpage_spam' => 'Xin lỗi, không thể lưu các chỉnh sửa của bạn',
	'createpage_cant_edit' => 'Không thể thực hiện chỉnh sửa',
	'createpage-dialog-title' => 'Tạo một trang mới',
	'createpage-dialog-message1' => 'Bạn đang tạo ra một trang mới!',
	'createpage-dialog-message2' => 'Bạn muốn gọi nó là gì?',
	'createpage-dialog-choose' => 'Hãy chọn một bố cục trang:',
	'createpage-dialog-format' => 'Bố cục chuẩn',
	'createpage-dialog-blank' => 'Trang trống',
	'createpage-error-empty-title' => 'Xin nhập tiêu đề cho trang',
	'createpage-error-invalid-title' => 'Xin lỗi, tiêu đề trang không hợp lệ.
Xin thử một tên khác',
	'createpage-error-article-exists' => 'Một trang với tựa đề đó đã tồn tại.
Bạn có thể đến <a href="$1">$2</a>, hoặc đổi tên lại trang của bạn',
	'createpage-error-article-spam' => 'Xin lỗi, tiêu đề trang không được chấp nhận bởi bộ lọc thư rác của chúng tôi.
Hãy sử dụng một tên khác khác.',
	'createpage-error-article-blocked' => 'Xin lỗi, bạn không thể tạo trang vào thời điểm này',
	'tog-createpagedefaultblank' => 'Sử dụng trang trống như là mặc định cho việc tạo ra một trang mới',
	'tog-createpagepopupdisabled' => 'Vô hiệu hoá cửa sổ "Tạo bài viết mới" (Không khuyến nghị)',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
Viết đoạn văn thứ nhất ở đây

==Đề mục 1==

Viết cho đề mục 1 tại đây

==Đề mục 2==

Viết cho đề mục 2 tại đây',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
Viết đoạn văn thứ nhất ở đây

==Đề mục 1==

Viết cho đề mục 1 tại đây

==Đề mục 2==

Viết cho đề mục 2 tại đây',
);

/** Chinese (中文)
 */
$messages['zh'] = array(
	'createpage-sp-title' => '新增文章',
	'createpage_title' => '發表新文章',
	'createpage_title_caption' => '文章標題', # Fuzzy
	'createpage_enter_text' => '輸入文字',
);

/** Chinese (China) (中文（中国大陆）‎)
 */
$messages['zh-cn'] = array(
	'createpage-sp-title' => '新增文章',
	'createpage_title' => '发表新文章',
	'createpage_title_caption' => '文章标题', # Fuzzy
	'createpage_enter_text' => '输入文字',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Anakmalaysia
 * @author Dimension
 * @author Hydra
 */
$messages['zh-hans'] = array(
	'createpage-sp-title' => '新增文章',
	'createpage_title' => '发表新文章',
	'createpage_title_caption' => '标题',
	'createpage_enter_text' => '输入文字',
	'createpage_invalid_title_error' => '标题无效',
	'createpage_spam' => '抱歉，无法保存您的编辑',
	'createpage_cant_edit' => '无法执行编辑',
	'createpage-dialog-title' => '创造一个新页面',
	'createpage-dialog-message1' => '喔~ 您将创建一个新页面！',
	'createpage-dialog-message2' => '您希望将其命名为何？',
	'createpage-dialog-format' => '标准布局',
	'createpage-dialog-blank' => '空白页面',
	'createpage-error-empty-title' => '请为您的页面添加标题',
	'createpage-error-invalid-title' => '抱歉，条目名无效。
请另行取名。',
	'createpage-error-article-exists' => '已存在同名页面。
您可以访问<a href="$1">$2</a>，或重命名您的页面。',
	'newpagelayout' => '[[File:Placeholder|right|300px]]
在这里撰写第一段落。

==标题项==

在这里撰写第一项。

==标题项==

在这里撰写第二项。',
	'createpage-with-video' => '[[File:Placeholder|video|right|300px]] [[File:Placeholder|right|300px]]
在这里撰写第一段落。

==标题项==

在这里撰写第一项。

==标题项==

在这里撰写第二项。',
	'createpage-ve-body' => '文章<b>$1</b>在此维基上不存在。您可以进行创建。',
	'createpage-button-cancel' => '取消',
);

/** Traditional Chinese (中文（繁體)
 * @author Anakmalaysia
 * @author Ffaarr
 * @author Oapbtommy
 */
$messages['zh-hant'] = array(
	'createpage-sp-title' => '建立一個新的頁面',
	'createpage_title' => '建立一個新的頁面',
	'createpage_title_caption' => '標題',
	'createpage_enter_text' => '輸入文字',
	'createpage_empty_title_error' => '需要標題',
	'createpage_empty_article_body_error' => '需要頁面文本',
	'createpage_invalid_title_error' => '無效的標題',
	'createpage_article_already_exists' => '已存在具有該名稱的頁面。
請選擇不同的名稱。',
	'createpage_spam' => '抱歉，你的編輯無法儲存',
	'createpage_cant_edit' => '不能執行編輯',
	'createpage-dialog-title' => '建立一個新的頁面',
	'createpage-dialog-message2' => '你想叫它什麼？',
	'createpage-error-article-blocked' => '對不起，您不能在這個時候創建該頁面。',
	'tog-createpagedefaultblank' => '使用空白頁作為預設創建新頁面',
	'createpage-ve-body' => '文章<b>$1</b>在此維基上不存在。您可以進行創建。',
	'createpage-button-cancel' => '取消',
);

/** Chinese (Hong Kong) (中文（香港）)
 * @author Anakmalaysia
 */
$messages['zh-hk'] = array(
	'createpage-sp-title' => '新增文章',
	'createpage_title' => '發表新文章',
	'createpage_title_caption' => '標題',
	'createpage_enter_text' => '輸入文字',
);

/** Chinese (Singapore) (中文（新加坡）‎)
 */
$messages['zh-sg'] = array(
	'createpage_title' => '发表新文章',
	'createpage_title_caption' => '文章标题', # Fuzzy
	'createpage_enter_text' => '输入文字',
);

/** Chinese (Taiwan) (中文（台灣）‎)
 */
$messages['zh-tw'] = array(
	'createpage-sp-title' => '新增文章',
	'createpage_title' => '發表新文章',
	'createpage_title_caption' => '文章標題', # Fuzzy
	'createpage_enter_text' => '輸入文字',
);
