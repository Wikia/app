<?php
/**
 * Internationalisation file for the extension Book Information.
 *
 * @file
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */

$messages = array();

/* English (Rob Church) */
$messages['en'] = array(
	'bookinfo-header'            => 'Book information',
	'bookinformation-desc'              => 'Expands the [[Special:Booksources|book sources special page]] with information from a web service',
	'bookinfo-result-title'      => 'Title:',
	'bookinfo-result-author'     => 'Author:',
	'bookinfo-result-publisher'  => 'Publisher:',
	'bookinfo-result-year'       => 'Year:',
	'bookinfo-error-invalidisbn' => 'Invalid ISBN entered.',
	'bookinfo-error-nosuchitem'  => 'Item does not exist or could not be found.',
	'bookinfo-error-nodriver'    => 'Unable to initialise an appropriate Book Information Driver.',
	'bookinfo-error-noresponse'  => 'No response or request timed out.',
	'bookinfo-purchase'          => 'Purchase this book from $1',
	'bookinfo-provider'          => 'Data provider: $1',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Jon Harald Søby
 * @author Purodha
 * @author The Evil IP address
 */
$messages['qqq'] = array(
	'bookinformation-desc' => '{{desc}}',
	'bookinfo-result-title' => '{{Identical|Title}}',
	'bookinfo-result-author' => '{{Identical|Author}}',
	'bookinfo-result-publisher' => '{{Identical|Publisher}}',
	'bookinfo-result-year' => '{{Identical|Year}}',
);

/** ꢱꣃꢬꢵꢯ꣄ꢡ꣄ꢬꢵ (ꢱꣃꢬꢵꢯ꣄ꢡ꣄ꢬꢵ)
 * @author MooRePrabu
 */
$messages['saz'] = array(
	'bookinfo-result-author' => 'ꢭꢶꢒ꣄ꢒꢸꢥꢵꢬ꣄',
	'bookinfo-result-year' => 'ꢏꢬ꣄ꢱꢸ',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 * @author SPQRobin
 */
$messages['af'] = array(
	'bookinfo-header' => 'Boek inligting',
	'bookinformation-desc' => "Brei [[Special:Booksources]] uit met inligting van 'n webdiens",
	'bookinfo-result-title' => 'Titel:',
	'bookinfo-result-author' => 'Outeur:',
	'bookinfo-result-publisher' => 'Uitgewer:',
	'bookinfo-result-year' => 'Jaar:',
	'bookinfo-error-invalidisbn' => 'Ongeldige ISBN ingetik.',
	'bookinfo-error-nosuchitem' => 'Item bestaan nie of kon nie gevind word nie.',
	'bookinfo-error-nodriver' => 'Kon nie die regte "Book Information Driver" inisialiseer nie.',
	'bookinfo-error-noresponse' => 'Geen antwoord of versoek neem te lank.',
	'bookinfo-purchase' => 'Koop die boek vanaf $1',
	'bookinfo-provider' => 'Gegewens verskaf deur: $1',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'bookinfo-error-noresponse' => 'Nuk ka përgjigje ose të kërkojë kohë jashtë.',
	'bookinfo-purchase' => 'Blerje këtë libër nga $1',
	'bookinfo-provider' => 'Marresi i te dhenave: $1',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'bookinfo-result-title' => 'አርዕስት፡',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'bookinfo-header' => "Información d'o libro",
	'bookinformation-desc' => 'Estendilla [[Special:Booksources]] con información sobre un servicio web',
	'bookinfo-result-title' => 'Títol:',
	'bookinfo-result-author' => 'Autor:',
	'bookinfo-result-publisher' => 'Editorial:',
	'bookinfo-result-year' => 'Anyo:',
	'bookinfo-error-invalidisbn' => "S'ha escrito un ISBN incorreuto.",
	'bookinfo-error-nosuchitem' => "No existe l'elemento u no s'ha puesto trobar.",
	'bookinfo-error-nodriver' => "No s'ha puesto encetar un Driver de Información de Libros (Book Information Driver) conforme.",
	'bookinfo-error-noresponse' => "No bi ha garra respuesta u o tiempo de respuesta s'ha acotolato.",
	'bookinfo-purchase' => 'Mercar iste libro dende $1',
	'bookinfo-provider' => 'Furnidor de datos: $1',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'bookinfo-header' => 'معلومات كتاب',
	'bookinformation-desc' => 'يمد [[Special:Booksources|صفحة مصادر الكتب الخاصة]] بمعلومات من خدمة ويب',
	'bookinfo-result-title' => 'العنوان:',
	'bookinfo-result-author' => 'المؤلف:',
	'bookinfo-result-publisher' => 'الناشر:',
	'bookinfo-result-year' => 'السنة:',
	'bookinfo-error-invalidisbn' => 'ردمك غير صحيح تم إدخاله.',
	'bookinfo-error-nosuchitem' => 'المدخل غير موجود أو لم يمكن العثور عليه.',
	'bookinfo-error-nodriver' => 'غير قادر على بدأ درايفر معلومات كتاب مناسب.',
	'bookinfo-error-noresponse' => 'لا رد أو الطلب انتهت فترته.',
	'bookinfo-purchase' => 'اشتر هذا الكتاب من $1',
	'bookinfo-provider' => 'مزود البيانات: $1',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'bookinfo-result-title' => 'ܟܘܢܝܐ:',
	'bookinfo-result-author' => 'ܣܝܘܡܐ:',
	'bookinfo-result-publisher' => 'ܦܪܣܢܐ:',
	'bookinfo-result-year' => 'ܫܢܬܐ:',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'bookinfo-header' => 'معلومات كتاب',
	'bookinformation-desc' => 'يمد [[Special:Booksources|صفحة مصادر الكتب الخاصة]] بمعلومات من خدمة ويب',
	'bookinfo-result-title' => 'العنوان:',
	'bookinfo-result-author' => 'المؤلف:',
	'bookinfo-result-publisher' => 'الناشر:',
	'bookinfo-result-year' => 'السنة:',
	'bookinfo-error-invalidisbn' => 'ردمك غير صحيح تم إدخاله.',
	'bookinfo-error-nosuchitem' => 'المدخل غير موجود أو لم يمكن العثور عليه.',
	'bookinfo-error-nodriver' => 'غير قادر على بدأ درايفر معلومات كتاب مناسب.',
	'bookinfo-error-noresponse' => 'لا رد أو الطلب انتهت فترته.',
	'bookinfo-purchase' => 'اشتر هذا الكتاب من $1',
	'bookinfo-provider' => 'مزود البيانات: $1',
);

/** Asturian (Asturianu)
 * @author Esbardu
 */
$messages['ast'] = array(
	'bookinfo-header' => 'Información de llibros',
	'bookinformation-desc' => "Espande la [[Special:Booksources|páxina especial de fontes de llibros]] con información proviniente d'un serviciu web",
	'bookinfo-result-title' => 'Títulu:',
	'bookinfo-result-author' => 'Autor:',
	'bookinfo-result-publisher' => 'Editor:',
	'bookinfo-result-year' => 'Añu:',
	'bookinfo-error-invalidisbn' => 'Códigu ISBN introducíu non válidu.',
	'bookinfo-error-nosuchitem' => "L'elementu nun esiste o nun se pudo atopar.",
	'bookinfo-error-nodriver' => "Nun se pudo aniciar un controlador d'información de llibros afechiscu.",
	'bookinfo-error-noresponse' => "Nun hai rempuesta o acabóse'l tiempu de la consulta.",
	'bookinfo-purchase' => 'Mercar esti llibru dende $1',
	'bookinfo-provider' => 'Proveedor de datos: $1',
);

/** Kotava (Kotava)
 * @author Wikimistusik
 */
$messages['avk'] = array(
	'bookinfo-header' => 'Nevagiva',
	'bookinfo-result-title' => 'Vergumvelt :',
	'bookinfo-result-author' => 'Sutesik :',
	'bookinfo-result-publisher' => 'Sanegasik :',
	'bookinfo-result-year' => 'Ilana :',
	'bookinfo-error-invalidisbn' => 'Meenaf bazen ISBN otuk',
	'bookinfo-provider' => 'Origdafusik : $1',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 * @author Vago
 */
$messages['az'] = array(
	'bookinfo-result-title' => 'Başlıq:',
	'bookinfo-result-author' => 'Müəllif',
	'bookinfo-result-publisher' => 'Naşir:',
	'bookinfo-result-year' => 'İl:',
);

/** Bashkir (Башҡортса)
 * @author Assele
 */
$messages['ba'] = array(
	'bookinfo-header' => 'Китап тураһында мәғлүмәт',
	'bookinformation-desc' => '[[Special:Booksources|"Китап сығанаҡтары" махсус битен]] веб-хеҙмәттәрҙән алынған мәғлүмәт менән киңәйтә.',
	'bookinfo-result-title' => 'Исеме:',
	'bookinfo-result-author' => 'Авторы:',
	'bookinfo-result-publisher' => 'Нәшриәт:',
	'bookinfo-result-year' => 'Йыл:',
	'bookinfo-error-invalidisbn' => 'Керетелгән ISBN дөрөҫ түгел.',
	'bookinfo-error-nosuchitem' => 'Мәғлүмәт юҡ йәки табыла алмай.',
	'bookinfo-error-nodriver' => 'Кәрәкле Китаптар тураһында мәғлүмәт драйверының башланғыс көйләүҙәрен билдәләп булмай.',
	'bookinfo-error-noresponse' => 'Яуап юҡ йәки яуап көтөү выҡыты үтте.',
	'bookinfo-purchase' => 'Китапты ошонан һатып алырға: $1',
	'bookinfo-provider' => 'Мәғлүмәт менән тәьмин итеүсе: $1',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'bookinfo-result-title' => 'Titulo:',
	'bookinfo-result-year' => 'Taon:',
);

/** Belarusian (Беларуская)
 * @author Тест
 */
$messages['be'] = array(
	'bookinfo-result-author' => 'Аўтар:',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'bookinfo-header' => 'Інфармацыя пра кнігу',
	'bookinformation-desc' => 'Пашырае [[Special:Booksources|спэцыяльную старонку пошуку кніг]] інфармацыяй з ўэб-сэрвісу',
	'bookinfo-result-title' => 'Назва:',
	'bookinfo-result-author' => 'Аўтар:',
	'bookinfo-result-publisher' => 'Выдавецтва:',
	'bookinfo-result-year' => 'Год:',
	'bookinfo-error-invalidisbn' => 'Уведзены няслушны ISBN.',
	'bookinfo-error-nosuchitem' => 'Запіс не існуе альбо ня можа быць знойдзены.',
	'bookinfo-error-nodriver' => 'Немагчыма ініцыялізаваць адпаведны драйвэр інфармацыі пра кнігі.',
	'bookinfo-error-noresponse' => 'Няма адказу альбо перавышаны час чаканьня адказу.',
	'bookinfo-purchase' => 'Набыць гэту кнігу ў $1',
	'bookinfo-provider' => 'Крыніца інфармацыі: $1',
);

/** Bulgarian (Български)
 * @author Borislav
 * @author DCLXVI
 */
$messages['bg'] = array(
	'bookinfo-header' => 'Информация за книга',
	'bookinformation-desc' => 'Разширява [[Special:Booksources|специалната страница с източници за книги]] с информация от уеб услуга',
	'bookinfo-result-title' => 'Заглавие:',
	'bookinfo-result-author' => 'Автор:',
	'bookinfo-result-publisher' => 'Издател:',
	'bookinfo-result-year' => 'Година:',
	'bookinfo-error-invalidisbn' => 'Въведеният ISBN е грешен.',
	'bookinfo-error-nosuchitem' => 'Записът не съществува или не е бил намерен.',
	'bookinfo-error-noresponse' => 'Няма отговор или заявката отне твърде много време.',
	'bookinfo-purchase' => 'Купуване на тази книга от $1',
	'bookinfo-provider' => 'Източник на информация: $1',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Zaheen
 */
$messages['bn'] = array(
	'bookinfo-header' => 'বই বিষয়ক তথ্য',
	'bookinformation-desc' => 'ওয়েব সেবার থেকে তথ্য দিয়ে [[Special:Booksources|বইয়ের উৎস সম্পর্কিত বিশেষ পাতাকে]] সম্প্রসারিত করে',
	'bookinfo-result-title' => 'শিরোনাম:',
	'bookinfo-result-author' => 'লেখক:',
	'bookinfo-result-publisher' => 'প্রকাশক:',
	'bookinfo-result-year' => 'বছর:',
	'bookinfo-error-invalidisbn' => 'অবৈধ ISBN প্রবেশ করানো হয়েছে।',
	'bookinfo-error-nosuchitem' => 'আইটেমটির অস্তিত্ব নেই বা খুঁজে পাওয়া যায়নি।',
	'bookinfo-error-nodriver' => 'একটি উপযুক্ত বই তথ্য ড্রাইভার প্রারম্ভিকীকরণ করা যায়নি।',
	'bookinfo-error-noresponse' => 'কোন উত্তর নেই বা অনুরোধটির মেয়াদ উত্তীর্ণ হয়ে গেছে।',
	'bookinfo-purchase' => '$1 থেকে এই বইটি কিনুন',
	'bookinfo-provider' => 'তথ্য সরবরাহকারী: $1',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'bookinfo-header' => 'Titouroù war al levr',
	'bookinformation-desc' => 'Astenn a ra [[Special:Booksources|pajenn dibar mammennoù al levr]] gant titouroù adal ur servij Kenrouedad',
	'bookinfo-result-title' => 'Titl :',
	'bookinfo-result-author' => 'Aozer :',
	'bookinfo-result-publisher' => 'Embanner :',
	'bookinfo-result-year' => 'Bloaz :',
	'bookinfo-error-invalidisbn' => 'ISBN merket direizh.',
	'bookinfo-error-nosuchitem' => "Ar pezh zo bet goulennet n'eus ket anezhañ pe n'eo ket bet kavet.",
	'bookinfo-error-nodriver' => "N'hall ket deraouiñ ur sturier titouriñ a-feson war al levrioù.",
	'bookinfo-error-noresponse' => 'Respont ebet pe amzer glask re hir.',
	'bookinfo-purchase' => 'Prenañ al levr-mañ adal $1',
	'bookinfo-provider' => 'Pourvezer roadennoù : $1',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'bookinfo-header' => 'Informacije o knjizi',
	'bookinformation-desc' => 'Proširuje [[Special:Booksources|posebnu stranicu književnih izvora]] sa podacima sa web servisa',
	'bookinfo-result-title' => 'Naslov:',
	'bookinfo-result-author' => 'Autor:',
	'bookinfo-result-publisher' => 'Izdavač:',
	'bookinfo-result-year' => 'Godina:',
	'bookinfo-error-invalidisbn' => 'Uneseni ISBN broj nije validan.',
	'bookinfo-error-nosuchitem' => 'Stavka ne postoji ili nije mogla biti pronađena.',
	'bookinfo-error-nodriver' => 'Ne može se pokrenuti potrebni driver za Book Information',
	'bookinfo-error-noresponse' => 'Nema odgovora ili je istekao rok za odgovor.',
	'bookinfo-purchase' => 'Kupi ovu knjigu na $1',
	'bookinfo-provider' => 'Izvor podataka: $1',
);

/** Catalan (Català)
 * @author Aleator
 * @author SMP
 * @author Toniher
 */
$messages['ca'] = array(
	'bookinfo-header' => 'Informació del llibre',
	'bookinformation-desc' => "Expandeix la [[Special:Booksources|pàgina especial de fonts del llibre]] amb informació d'un servei web",
	'bookinfo-result-title' => 'Títol:',
	'bookinfo-result-author' => 'Autor:',
	'bookinfo-result-publisher' => 'Editorial:',
	'bookinfo-result-year' => 'Any:',
	'bookinfo-error-invalidisbn' => "L'ISBN introduït no és vàlid.",
	'bookinfo-error-nosuchitem' => "L'element no existeix o no s'ha pogut trobar.",
	'bookinfo-error-nodriver' => "No s'ha pogut inicialitzar un connector d'informació de llibres apropiat.",
	'bookinfo-error-noresponse' => "No hi ha cap resposta o el temps de soŀlicitud s'ha esgotat.",
	'bookinfo-purchase' => 'Compra aquest llibre de $1',
	'bookinfo-provider' => 'Proveïdor de dades: $1',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'bookinfo-result-year' => 'Шо:',
);

/** Corsican (Corsu) */
$messages['co'] = array(
	'bookinfo-result-author' => 'Autore:',
);

/** Czech (Česky)
 * @author Li-sung
 */
$messages['cs'] = array(
	'bookinfo-header' => 'Informace o knihách',
	'bookinformation-desc' => 'Rozšiřuje speciální stránku [[Special:Booksources|Zdroje knih]] o informace z internetových služeb',
	'bookinfo-result-title' => 'Název:',
	'bookinfo-result-author' => 'Autor:',
	'bookinfo-result-publisher' => 'Vydavatel:',
	'bookinfo-result-year' => 'Rok:',
	'bookinfo-error-invalidisbn' => 'Zadáno neplatné ISBN.',
	'bookinfo-error-nosuchitem' => 'Položka neexistuje nebo nebyla nalezena.',
	'bookinfo-error-nodriver' => 'Nepodařilo se inicializovat příslušný ovladač informací o knihách.',
	'bookinfo-error-noresponse' => 'Žádná odpověď nebo vypršel čas na odpověď.',
	'bookinfo-purchase' => 'Koupit tuto knihu na $1',
	'bookinfo-provider' => 'Poskytovatel dat: $1',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'bookinfo-result-author' => 'творь́ць :',
);

/** Welsh (Cymraeg)
 * @author Pwyll
 */
$messages['cy'] = array(
	'bookinfo-header' => 'Gwybodaeth am lyfr',
	'bookinformation-desc' => "Ehangu'r [[Special:Booksources|tudalen arbennig ffynhonellau llyfrau]] gyda gwybodaeth o wasanaeth ar y wê",
	'bookinfo-result-title' => 'Teitl:',
	'bookinfo-result-author' => 'Awdur:',
	'bookinfo-result-publisher' => 'Cyhoeddwr:',
	'bookinfo-result-year' => 'Blwyddyn:',
	'bookinfo-error-invalidisbn' => 'Nodwyd ISBN annilys.',
	'bookinfo-error-nosuchitem' => "Nid yw'r eitem yn bodoli neu ni allwyd dod o hyd iddo.",
	'bookinfo-error-nodriver' => 'Ni allwyd cychwyn ar Yrrwr Gwybodaeth am Lyfrau addas.',
	'bookinfo-error-noresponse' => 'Dim ymateb neu rhedodd y cais allan o amser.',
	'bookinfo-purchase' => 'Prynwch y llyfr hwn o $1',
	'bookinfo-provider' => 'Darparwr data: $1',
);

/** Danish (Dansk)
 * @author Froztbyte
 * @author Morten LJ
 */
$messages['da'] = array(
	'bookinfo-header' => 'Boginformation',
	'bookinformation-desc' => 'Udvider [[Special:Booksources|specialsiden med bogkilder]] med information fra en webservice',
	'bookinfo-result-title' => 'Titel:',
	'bookinfo-result-author' => 'Forfatter:',
	'bookinfo-result-publisher' => 'Udgiver:',
	'bookinfo-result-year' => 'År:',
	'bookinfo-error-invalidisbn' => 'Det indtastede ISBN-nummer er ugyldigt.',
	'bookinfo-error-nosuchitem' => 'Varen eksisterer ikke eller blev ikke fundet.',
	'bookinfo-error-nodriver' => 'Kunne ikke indlæse en passende boginformationsdriver.',
	'bookinfo-error-noresponse' => 'Intet svar eller forespørgslen fik timeout.',
	'bookinfo-purchase' => 'Køb denne bog hos $1',
	'bookinfo-provider' => 'Data leveret af: $1',
);

/** German (Deutsch)
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'bookinfo-header' => 'Informationen über Bücher',
	'bookinformation-desc' => 'Ergänzt die [[Special:Booksources|Buchquellen-Spezialseite]] um Informationen von einem Webangebot',
	'bookinfo-result-title' => 'Titel:',
	'bookinfo-result-author' => 'Autor:',
	'bookinfo-result-publisher' => 'Verlag:',
	'bookinfo-result-year' => 'Jahr:',
	'bookinfo-error-invalidisbn' => 'ISBN ungültig.',
	'bookinfo-error-nosuchitem' => 'Die Seite ist nicht vorhanden oder wurde nicht gefunden.',
	'bookinfo-error-nodriver' => 'Es war nicht möglich, die entsprechende Buchinformations-Schnittstelle zu initialisieren.',
	'bookinfo-error-noresponse' => 'Keine Antwort oder Zeitüberschreitung.',
	'bookinfo-purchase' => 'Dieses Buch kann von $1 bezogen werden.',
	'bookinfo-provider' => 'Daten-Lieferant: $1',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'bookinfo-header' => 'Informacije wó knigłach',
	'bookinformation-desc' => 'Wudopołnjujo [[Special:Booksources|specialny bok žrědłow knigłow ]] wó informacije z websłužby',
	'bookinfo-result-title' => 'Titel:',
	'bookinfo-result-author' => 'Awtor:',
	'bookinfo-result-publisher' => 'Wudawaŕ:',
	'bookinfo-result-year' => 'Lěto:',
	'bookinfo-error-invalidisbn' => 'Njepłaśiwy ISBN zapódany.',
	'bookinfo-error-nosuchitem' => 'Zapisk njeeksistěrujo abo njejo se namakaś dał.',
	'bookinfo-error-nodriver' => 'Njejo móžno pśiłušny gónjak za informacije wó knigłach inicializěrowaś',
	'bookinfo-error-noresponse' => 'Žedno wótegrono abo cas za wótegrono wótběgnuł',
	'bookinfo-purchase' => 'Toś te knigły z $1 kupiś',
	'bookinfo-provider' => 'Librowaŕ datow: $1',
);

/** Greek (Ελληνικά)
 * @author Badseed
 * @author Consta
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'bookinfo-header' => 'Βιβλίο πληροφοριών',
	'bookinformation-desc' => 'Επεκτείνει [[Special:Booksources|την ειδική σελίδα πηγών για βιβλία]] με πληροφορίες από μια διαδικτυακή υπηρεσία',
	'bookinfo-result-title' => 'Τίτλος:',
	'bookinfo-result-author' => 'Συντάκτης:',
	'bookinfo-result-publisher' => 'Εκδότης:',
	'bookinfo-result-year' => 'Χρόνος:',
	'bookinfo-error-invalidisbn' => 'Έχει πληκτρολογηθεί λάθος ISBN.',
	'bookinfo-error-nosuchitem' => 'Το αντικείμενο δεν υπάρχει ή δεν μπορούσε να βρεθεί.',
	'bookinfo-error-nodriver' => 'Δεν μπόρεσε να δημιουργηθεί ένας κατάλληλος Οδηγός Πληροφοριών Βιβλίου.',
	'bookinfo-error-noresponse' => 'Καμία απάντηση ή λήξη χρόνου απόκρισης της αίτησης.',
	'bookinfo-purchase' => 'Αγοράστε αυτό το βιβλίο από $1',
	'bookinfo-provider' => 'Παροχέας δεδομένων: $1',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'bookinfo-header' => 'Libra informo',
	'bookinformation-desc' => 'Pligrandigas [[Special:Booksources|paĝon pri libraj fontoj]] kun informo de Interreta-servo.',
	'bookinfo-result-title' => 'Titolo:',
	'bookinfo-result-author' => 'Aŭtoro:',
	'bookinfo-result-publisher' => 'Eldonejo:',
	'bookinfo-result-year' => 'Jaro:',
	'bookinfo-error-invalidisbn' => 'Nevalida ISBN entajpita.',
	'bookinfo-error-nosuchitem' => 'Tio ne ekzistas aŭ ne estas trovebla.',
	'bookinfo-error-nodriver' => 'Ne eblas starti taǔgan pelilon de Libro-Informo',
	'bookinfo-error-noresponse' => 'Neniu respondo aŭ peto estis finigita.',
	'bookinfo-purchase' => 'Aĉetu ĉi libron de $1',
	'bookinfo-provider' => 'Datuma provizanto: $1',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Dmcdevit
 * @author Drini
 */
$messages['es'] = array(
	'bookinfo-header' => 'Información de libro',
	'bookinformation-desc' => 'Ampliar la [[Special:Booksources|página especial de fuentes de libros]] con información de un servicio web',
	'bookinfo-result-title' => 'Título:',
	'bookinfo-result-author' => 'Autor:',
	'bookinfo-result-publisher' => 'Editorial:',
	'bookinfo-result-year' => 'Año:',
	'bookinfo-error-invalidisbn' => 'Se introduce el ISBN inválido.',
	'bookinfo-error-nosuchitem' => 'Item no existe o no pudo ser encontrado.',
	'bookinfo-error-nodriver' => 'No se pudo inicializar un Controlador de Información de Libro apropiado.',
	'bookinfo-error-noresponse' => 'No hay respuesta o expiró.',
	'bookinfo-purchase' => 'Comprar este libro de $1',
	'bookinfo-provider' => 'Proveedor de datos: $1',
);

/** Estonian (Eesti)
 * @author Avjoska
 */
$messages['et'] = array(
	'bookinfo-header' => 'Raamatu informatsioon',
	'bookinfo-result-title' => 'Pealkiri:',
	'bookinfo-result-author' => 'Autor:',
	'bookinfo-result-publisher' => 'Väljaandja:',
	'bookinfo-result-year' => 'Aasta:',
	'bookinfo-error-invalidisbn' => 'Sisestati kehtetu ISBN.',
	'bookinfo-error-nosuchitem' => 'Toodet ei ole olemas või ei leitud.',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Bengoa
 * @author Theklan
 */
$messages['eu'] = array(
	'bookinfo-header' => 'Liburuaren informazioa',
	'bookinformation-desc' => '[[Special:Booksources|Liburuen jatorriaren orrialde berezia]] hedatzen du web serbitzu bateko informazioarekin',
	'bookinfo-result-title' => 'Izenburua:',
	'bookinfo-result-author' => 'Egilea:',
	'bookinfo-result-publisher' => 'Argitaletxea:',
	'bookinfo-result-year' => 'Urtea:',
	'bookinfo-error-invalidisbn' => 'Baliagarria ez den ISBN bat sartu duzu.',
	'bookinfo-error-nosuchitem' => 'Elementua ez da esistitzen edo ezin da aurkitu.',
	'bookinfo-error-nodriver' => 'Ez da posible izan Book Information Driver egoki bat hastea.',
	'bookinfo-error-noresponse' => 'Ez dago erantzunik edo eskaera denboraz kanpo geratu da.',
	'bookinfo-purchase' => '$1(e)tik erosi liburu hau',
	'bookinfo-provider' => 'Datu emalea: $1',
);

/** Extremaduran (Estremeñu)
 * @author Better
 */
$messages['ext'] = array(
	'bookinfo-header' => 'Enhormación el libru',
	'bookinfo-result-title' => 'Entítulu:',
	'bookinfo-result-author' => 'Autol:',
	'bookinfo-result-publisher' => 'Eitorial:',
	'bookinfo-result-year' => 'Añu:',
	'bookinfo-error-nosuchitem' => 'El artículu nu desisti u nu puei sel alcuentrau.',
	'bookinfo-purchase' => 'Mercal esti libru e $1',
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'bookinfo-header' => 'اطلاعات کتاب',
	'bookinformation-desc' => '[[Special:Booksources]] را با استفاده از اطلاعات یک سرویس اینترنتی گسترش می‌دهد',
	'bookinfo-result-title' => 'عنوان:',
	'bookinfo-result-author' => 'نویسنده:',
	'bookinfo-result-publisher' => 'ناشر:',
	'bookinfo-result-year' => 'سال انتشار:',
	'bookinfo-error-invalidisbn' => 'شابک غیرمجاز وارد شده‌است.',
	'bookinfo-error-nosuchitem' => 'این مورد وجود ندارد یا پیدا نشد.',
	'bookinfo-error-nodriver' => 'راه‌انداز مناسب اطلاعات کتاب قابل به کارگیری نیست.',
	'bookinfo-error-noresponse' => 'پاسخی وجود نداشت یا مهلت درخواست سپری شد.',
	'bookinfo-purchase' => 'خرید این کتاب از $1',
	'bookinfo-provider' => 'مهیاکنندهٔ اطلاعات: $1',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Nike
 */
$messages['fi'] = array(
	'bookinfo-header' => 'Kirjan tiedot',
	'bookinformation-desc' => 'Laajentaa [[Special:Booksources|kirjalähdesivun]] tietoja verkkopalveluista.',
	'bookinfo-result-title' => 'Nimi:',
	'bookinfo-result-author' => 'Tekijä:',
	'bookinfo-result-publisher' => 'Kustantaja:',
	'bookinfo-result-year' => 'Vuosi:',
	'bookinfo-error-invalidisbn' => 'Kelpaamaton ISBN.',
	'bookinfo-error-nosuchitem' => 'Nimikettä ei ole olemassa tai sitä ei löytynyt.',
	'bookinfo-error-nodriver' => 'Kirjatietoajurin alustus ei onnistunut.',
	'bookinfo-error-noresponse' => 'Ei vastausta tai pyyntö aikakatkaistiin.',
	'bookinfo-purchase' => 'Osta tämä kirja: $1',
	'bookinfo-provider' => 'Tietolähde: $1',
);

/** French (Français)
 * @author Grondin
 * @author Urhixidur
 * @author Verdy p
 */
$messages['fr'] = array(
	'bookinfo-header' => 'Informations sur l’ouvrage',
	'bookinformation-desc' => 'Complète la [[Special:Booksources|page spéciale des sources d’ouvrages de références]] à l’aide d’informations provenant de services Internet',
	'bookinfo-result-title' => 'Titre :',
	'bookinfo-result-author' => 'Auteur :',
	'bookinfo-result-publisher' => 'Éditeur :',
	'bookinfo-result-year' => 'Année :',
	'bookinfo-error-invalidisbn' => 'ISBN invalide.',
	'bookinfo-error-nosuchitem' => 'Cet élément n’existe pas ou n’a pas pu être trouvé.',
	'bookinfo-error-nodriver' => 'Impossible d’initialiser un moteur d’information sur les ouvrages.',
	'bookinfo-error-noresponse' => 'Aucune réponse ou dépassement du délai.',
	'bookinfo-purchase' => 'Acheter ce livre sur $1',
	'bookinfo-provider' => 'Fournisseur des données : $1',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'bookinfo-header' => 'Enformacions sur les ôvres',
	'bookinformation-desc' => 'Complète la [[Special:Booksources|pâge spèciâla de les sôrses d’ôvres de refèrence]] avouéc des enformacions dês un sèrviço vouèbe.',
	'bookinfo-result-title' => 'Titro :',
	'bookinfo-result-author' => 'Ôtor :',
	'bookinfo-result-publisher' => 'Èditor :',
	'bookinfo-result-year' => 'An :',
	'bookinfo-error-invalidisbn' => 'ISBN envalido.',
	'bookinfo-error-nosuchitem' => 'Cél èlèment ègziste pas ou ben il at pas possu étre trovâ.',
	'bookinfo-error-nodriver' => 'Empossiblo d’inicialisar un motor d’enformacion sur les ôvres.',
	'bookinfo-error-noresponse' => 'Gins de rèponsa ou ben de dèpassement du dèlê.',
	'bookinfo-purchase' => 'Achetar cél lévro dessus $1',
	'bookinfo-provider' => 'Fornissor de les balyês : $1',
);

/** Friulian (Furlan)
 * @author Klenje
 */
$messages['fur'] = array(
	'bookinfo-header' => 'Informazions sui libris',
	'bookinfo-result-title' => 'Titul:',
	'bookinfo-result-author' => 'Autôr:',
	'bookinfo-result-year' => 'An:',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'bookinfo-result-author' => 'Auteur:',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'bookinfo-header' => 'Información do libro',
	'bookinformation-desc' => 'Amplía a [[Special:Booksources|páxina especial de fontes bibliográficas]] con información dun servizo web',
	'bookinfo-result-title' => 'Título:',
	'bookinfo-result-author' => 'Autor:',
	'bookinfo-result-publisher' => 'Publicación:',
	'bookinfo-result-year' => 'Ano:',
	'bookinfo-error-invalidisbn' => 'O ISBN introducido non é válido.',
	'bookinfo-error-nosuchitem' => 'O artigo non existe ou non foi atopado.',
	'bookinfo-error-nodriver' => 'Non é posible iniciar un motor de información sobre libros axeitado.',
	'bookinfo-error-noresponse' => 'Non se recibiu resposta ou a solicitude caducou.',
	'bookinfo-purchase' => 'Compre este libro de $1',
	'bookinfo-provider' => 'Fornecedor de datos: $1',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'bookinfo-result-title' => 'Ἐπιγραφή:',
	'bookinfo-result-author' => 'Δημιουργός:',
	'bookinfo-result-publisher' => 'Ἐκδότης:',
	'bookinfo-result-year' => 'Ἔτος:',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 * @author J. 'mach' wust
 */
$messages['gsw'] = array(
	'bookinfo-header' => 'Informatione iber Biecher',
	'bookinformation-desc' => 'Ergänzt d [[Special:Booksources|Buechquälle-Spezialsyte]] mit Informatione vun eme Netzaagebot',
	'bookinfo-result-title' => 'Titel:',
	'bookinfo-result-author' => 'Autor:',
	'bookinfo-result-publisher' => 'Verlag:',
	'bookinfo-result-year' => 'Johr:',
	'bookinfo-error-invalidisbn' => 'ISBN nit giltig.',
	'bookinfo-error-nosuchitem' => 'D Syte git s nit oder isch nit gfunde wore.',
	'bookinfo-error-nodriver' => 'S isch nit megli gsi, d Buechinformations-Schnittstell z initialisiere.',
	'bookinfo-error-noresponse' => 'Kei Antwort oder Zytiberschrytig.',
	'bookinfo-purchase' => 'Des Buech cha bi $1 gchauft wäre.',
	'bookinfo-provider' => 'Date-Lieferant: $1',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'bookinfo-header' => 'Oayllys lioar',
	'bookinformation-desc' => 'Mooadaghey [[Special:Booksources|yn duillag er lheh ry hoi farraneyn-fys lioar]] lesh oayllys veih shirveish voggyl.',
	'bookinfo-result-title' => 'Ennym:',
	'bookinfo-result-author' => 'Ughtar:',
	'bookinfo-result-publisher' => 'Soilsheyder:',
	'bookinfo-result-year' => 'Blein:',
	'bookinfo-error-invalidisbn' => 'ISBN neuchiart currit stiagh.',
	'bookinfo-error-nosuchitem' => 'Cha nel y nhee ayn ny cha row eh er geddyn magh.',
	'bookinfo-error-nodriver' => 'Cha nel eh jargal yn Immanagh Oayllys Lioar y ghoaill toshiaght.',
	'bookinfo-error-noresponse' => 'Cha row freggyrt ayn ny haghyr jerrey traa lesh yn aghin.',
	'bookinfo-purchase' => 'Kionnee yn lioar shoh veih $1',
	'bookinfo-provider' => 'Kiareyder fysseree: $1',
);

/** Hebrew (עברית)
 * @author Agbad
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'bookinfo-header' => 'נתוני הספר',
	'bookinformation-desc' => 'הרחבת [[Special:Booksources|הדף המיוחד משאבי ספרות חיצוניים]] באמצעות מידע משירות אינטרנטי',
	'bookinfo-result-title' => 'כותרת:',
	'bookinfo-result-author' => 'מחבר:',
	'bookinfo-result-publisher' => 'מוציא לאור:',
	'bookinfo-result-year' => 'שנה:',
	'bookinfo-error-invalidisbn' => 'המסת"ב שהוזן שגוי.',
	'bookinfo-error-nosuchitem' => 'הפריט לא קיים או שלא ניתן למצאו.',
	'bookinfo-error-nodriver' => 'לא ניתן להפעיל את מנהל נתוני הספרים המתאים.',
	'bookinfo-error-noresponse' => 'אין תגובה או שעבר הזמן לקבלת התגובה.',
	'bookinfo-purchase' => 'רכישת ספר זה מ־$1',
	'bookinfo-provider' => 'ספק הנתונים: $1',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'bookinfo-header' => 'किताब ज़ानकारी',
	'bookinformation-desc' => 'इंटरनेट से ज़ानकारी लेकर [[Special:Booksources]] बढायें',
	'bookinfo-result-title' => 'शीर्षक:',
	'bookinfo-result-author' => 'लेखक:',
	'bookinfo-result-publisher' => 'प्रकाशक:',
	'bookinfo-result-year' => 'सन:',
	'bookinfo-error-invalidisbn' => 'गलत ISBN दिया हैं',
	'bookinfo-error-nosuchitem' => 'आईटम मिला नहीं या अस्तित्वमें नहीं हैं।',
	'bookinfo-error-nodriver' => 'बुक इन्फर्मेशन ड्राइवर शुरू करने में असमर्थ।',
	'bookinfo-error-noresponse' => 'कोई भी जवाब नहीं या समय समाप्त हो गया हैं।',
	'bookinfo-purchase' => 'यह किताब $1 से खरीदें',
	'bookinfo-provider' => 'डाटा प्रोवाईडर: $1',
);

/** Croatian (Hrvatski)
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'bookinfo-header' => 'Informacije o knjizi',
	'bookinformation-desc' => 'Proširuje [[Special:Booksources|posebnu stranicu izvora knjiga]] s podacima dobivenim putem web usluge (servisa)',
	'bookinfo-result-title' => 'Naslov:',
	'bookinfo-result-author' => 'Autor:',
	'bookinfo-result-publisher' => 'Izdavač:',
	'bookinfo-result-year' => 'Godina:',
	'bookinfo-error-invalidisbn' => 'Nevaljan ISBN broj.',
	'bookinfo-error-nosuchitem' => 'Knjiga ne postoji/nije nađena.',
	'bookinfo-error-nodriver' => 'Ne mogu inicijalizirati odgovarajući program za informacije o knjigama.',
	'bookinfo-error-noresponse' => "Nema odgovora ili istek vremena za upit (''timeout'').",
	'bookinfo-purchase' => 'Kupi ovu knjigu od $1',
	'bookinfo-provider' => 'Dobavljač podataka: $1',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'bookinfo-header' => 'Informacije wo knihach',
	'bookinformation-desc' => 'Rozšěrja [[Special:Booksources|specialnu stronu z knižnych žórłow]] přez informacije z websłužby',
	'bookinfo-result-title' => 'Titul:',
	'bookinfo-result-author' => 'Awtor:',
	'bookinfo-result-publisher' => 'Nakładnistwo:',
	'bookinfo-result-year' => 'Lěto:',
	'bookinfo-error-invalidisbn' => 'ISBN njepłaćiwe.',
	'bookinfo-error-nosuchitem' => 'Artikl njeeksistuje abo njeda so namakać.',
	'bookinfo-error-nodriver' => 'Njeběše móžno wotpowědny ćěrjak za informacije wo knihach inicializować.',
	'bookinfo-error-noresponse' => 'Žana wotmołwa abo překročenje časa.',
	'bookinfo-purchase' => 'Tuta kniha hodźi so wot $1 kupić.',
	'bookinfo-provider' => 'Dodawar datow: $1',
);

/** Haitian (Kreyòl ayisyen)
 * @author Boukman
 * @author Masterches
 */
$messages['ht'] = array(
	'bookinfo-header' => 'Enfòmasyon sou liv',
	'bookinformation-desc' => 'Ap etann [[Special:Booksources|paj espesyal sou sous ki soti nan liv]] ak enfòmasyon nou jwenn nan yon sèvis wèb',
	'bookinfo-result-title' => 'Tit, non l:',
	'bookinfo-result-publisher' => 'Editè :',
	'bookinfo-result-year' => 'Lane :',
	'bookinfo-error-invalidisbn' => 'ISBN ou bay an pa bon ditou.',
	'bookinfo-error-nosuchitem' => 'Eleman sa a pa egziste oubyen nou pa kapab jwenn li.',
	'bookinfo-error-nodriver' => 'Nou pa kapab fè motè enfòmasyon sou liv yo mache ditou.',
	'bookinfo-error-noresponse' => 'Pa gen pyès repons oubyen delè nesesè a depase.',
	'bookinfo-purchase' => 'Achte liv sa nan men $1',
	'bookinfo-provider' => 'Moun ki ap bay enfòmasyon sa : $1',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author KossuthRad
 */
$messages['hu'] = array(
	'bookinfo-header' => 'Könyv információ',
	'bookinformation-desc' => 'Kiegészíti a [[Special:Booksources|könyvforrások speciális lapot]] információkkal egy webkiszolgálóról',
	'bookinfo-result-title' => 'Cím:',
	'bookinfo-result-author' => 'Szerző:',
	'bookinfo-result-publisher' => 'Kiadó:',
	'bookinfo-result-year' => 'Év:',
	'bookinfo-error-invalidisbn' => 'Érvénytelen ISBN.',
	'bookinfo-error-nosuchitem' => 'A cikk/hír nem létezik vagy nem található.',
	'bookinfo-error-nodriver' => 'Nem sikerült a megfelelő könyvinformációs meghajtó inicializálása.',
	'bookinfo-error-noresponse' => 'Nincs válasz vagy a kért idő letelt.',
	'bookinfo-purchase' => 'Ez a könyv megszerezve a $1-ből',
	'bookinfo-provider' => 'Adat ellátó: $1',
);

/** Interlingua (Interlingua)
 * @author Malafaya
 * @author McDutchie
 */
$messages['ia'] = array(
	'bookinfo-header' => 'Informationes de libros',
	'bookinformation-desc' => 'Extende le [[Special:Booksources|pagina special con fontes de libros]] con informationes proveniente de un servicio web',
	'bookinfo-result-title' => 'Titulo:',
	'bookinfo-result-author' => 'Autor:',
	'bookinfo-result-publisher' => 'Editor:',
	'bookinfo-result-year' => 'Anno:',
	'bookinfo-error-invalidisbn' => 'Tu entrava un ISBN invalide.',
	'bookinfo-error-nosuchitem' => 'Le entrata non existe o non poteva esser trovate.',
	'bookinfo-error-nodriver' => 'Non poteva initialisar un Motor de Informationes super Libros (Book Information Driver) appropriate.',
	'bookinfo-error-noresponse' => 'Nulle responsa, o le requesta expirava.',
	'bookinfo-purchase' => 'Acquirer iste libro a $1',
	'bookinfo-provider' => 'Providitor de datos: $1',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 * @author Meursault2004
 */
$messages['id'] = array(
	'bookinfo-header' => 'Informasi buku',
	'bookinformation-desc' => 'Mengembangkan [[Special:Booksources]] dengan informasi dari sumber-sumber buku',
	'bookinfo-result-title' => 'Judul:',
	'bookinfo-result-author' => 'Pengarang:',
	'bookinfo-result-publisher' => 'Penerbit:',
	'bookinfo-result-year' => 'Tahun:',
	'bookinfo-error-invalidisbn' => 'ISBN yang dimasukkan tidak sah.',
	'bookinfo-error-nosuchitem' => 'Item yang dimasukkan tidak ada atau tidak ditemukan.',
	'bookinfo-error-nodriver' => 'Tidak dapat menginisialisasi Book Information Driver.',
	'bookinfo-error-noresponse' => 'Tak ada respons atau respons terlalu lama.',
	'bookinfo-purchase' => 'Beli buku ini dari $1',
	'bookinfo-provider' => 'Penyedia data: $1',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'bookinfo-result-title' => 'Titulo:',
	'bookinfo-result-author' => 'Autoro:',
	'bookinfo-result-year' => 'Yaro:',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'bookinfo-header' => 'Bókaupplýsingar',
	'bookinfo-result-title' => 'Titill:',
	'bookinfo-result-author' => 'Höfundur:',
	'bookinfo-result-publisher' => 'Útgefandi:',
	'bookinfo-result-year' => 'Ár:',
	'bookinfo-error-invalidisbn' => 'Rangt ISBN skráð.',
	'bookinfo-error-nosuchitem' => 'Hluturinn er ekki til eða var ekki fundinn.',
	'bookinfo-error-noresponse' => 'Ekkert svar eða beiðnin fell úr gildi.',
	'bookinfo-purchase' => 'Festa kaup á þessari bók frá $1',
	'bookinfo-provider' => 'Upplýsingaveitandi: $1',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Darth Kule
 */
$messages['it'] = array(
	'bookinfo-header' => 'Informazioni sui libri',
	'bookinformation-desc' => 'Espande la [[Special:Booksources|pagina speciale per la ricerca di fonti librarie]] con informazioni provenienti da un servizio Web',
	'bookinfo-result-title' => 'Titolo:',
	'bookinfo-result-author' => 'Autore:',
	'bookinfo-result-publisher' => 'Editore:',
	'bookinfo-result-year' => 'Anno:',
	'bookinfo-error-invalidisbn' => 'Codice ISBN errato.',
	'bookinfo-error-nosuchitem' => 'Elemento inesistente o non trovato.',
	'bookinfo-error-nodriver' => 'Impossibile inizializzare un driver corretto per le Informazioni sui libri.',
	'bookinfo-error-noresponse' => 'Mancata risposta o risposta assente.',
	'bookinfo-purchase' => 'Acquista il libro presso: $1',
	'bookinfo-provider' => 'Dati estratti da: $1',
);

/** Japanese (日本語)
 * @author Aotake
 * @author JtFuruhata
 */
$messages['ja'] = array(
	'bookinfo-header' => '書籍情報',
	'bookinformation-desc' => '[[Special:Booksources|{{int:booksources}}]]の機能を拡張し、ウェブサービスから情報を取得する',
	'bookinfo-result-title' => 'タイトル:',
	'bookinfo-result-author' => '著者:',
	'bookinfo-result-publisher' => '出版:',
	'bookinfo-result-year' => '出版年:',
	'bookinfo-error-invalidisbn' => '不正な ISBN です。',
	'bookinfo-error-nosuchitem' => '指定したものが見つかりません。',
	'bookinfo-error-nodriver' => '適切な書籍情報エクステンション用ドライバが認識できません。',
	'bookinfo-error-noresponse' => 'リクエストを送信しましたが、応答がないかタイムアウトしました。',
	'bookinfo-purchase' => 'この本を $1 から購入する',
	'bookinfo-provider' => 'データ提供元: $1',
);

/** Jutish (Jysk)
 * @author Huslåke
 */
$messages['jut'] = array(
	'bookinfo-header' => 'Båĝinformåsje',
	'bookinformation-desc' => 'Expands [[Special:Booksources]] with information from a web service',
	'bookinfo-result-title' => 'Titel:',
	'bookinfo-result-author' => 'Førfatter:',
	'bookinfo-result-publisher' => 'Udgæver:',
	'bookinfo-result-year' => 'År:',
	'bookinfo-error-invalidisbn' => 'Det endtastede ISBN-nåmer er ugyldegt.',
	'bookinfo-error-nosuchitem' => 'Æ våre bistä ekke æller blev ekke fundet.',
	'bookinfo-error-nodriver' => 'Ken ekke endlæse en passende båĝinformåsjedrejver.',
	'bookinfo-error-noresponse' => 'Entet svar æller førespørgslen fek tiidud.',
	'bookinfo-purchase' => 'Køb denne båĝ hos $1',
	'bookinfo-provider' => 'Data leveret åf: $1',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'bookinfo-header' => 'Informasi buku',
	'bookinformation-desc' => 'Kembangna [[Special:Booksources|kaca mligi sumber buku]] mawa informasi saka sawijining peladèn wèb',
	'bookinfo-result-title' => 'Irah-irahan (judhul):',
	'bookinfo-result-author' => 'Pangripta:',
	'bookinfo-result-publisher' => 'Panerbit:',
	'bookinfo-result-year' => 'Taun:',
	'bookinfo-error-invalidisbn' => 'ISBN sing dilebokaké ora absah.',
	'bookinfo-error-nosuchitem' => 'Item sing dilebokaké ora ana utawa ora bisa ditemokaké.',
	'bookinfo-error-nodriver' => 'Ora bisa inisialisasi Book Information Driver.',
	'bookinfo-error-noresponse' => 'Ora ana wangsulan utawa rèsponsé kesuwèn.',
	'bookinfo-purchase' => 'Tuku buku ini saka $1',
	'bookinfo-provider' => 'Sing nyedyakaké data: $1',
);

/** Georgian (ქართული)
 * @author Alsandro
 * @author Temuri rajavi
 */
$messages['ka'] = array(
	'bookinfo-header' => 'ინფორმაცია წიგნზე',
	'bookinfo-result-title' => 'სათაური:',
	'bookinfo-result-author' => 'ავტორი:',
	'bookinfo-result-publisher' => 'გამომცემელი:',
	'bookinfo-result-year' => 'წელი:',
);

/** Kazakh (Arabic script) (‫قازاقشا (تٴوتە)‬) */
$messages['kk-arab'] = array(
	'bookinfo-header' => 'كىتاپ مالىمەتى',
	'bookinfo-result-title' => 'اتاۋى:',
	'bookinfo-result-author' => 'اۋتورى:',
	'bookinfo-result-publisher' => 'باسپاگەرى:',
	'bookinfo-result-year' => 'جىلى:',
	'bookinfo-error-invalidisbn' => 'جارامسىز ISBN ەنگىزىلگەن.',
	'bookinfo-error-nosuchitem' => 'ٴتىزىمنىڭ داناسى بولماعان نە تابىلماعان.',
	'bookinfo-error-nodriver' => 'كىتاپ مالىمەتتەرىنىڭ ٴوز درايۆەرى باستامالانبادى',
	'bookinfo-error-noresponse' => 'ەش جاۋاپ جوق نە سۇرانىمدىڭ مەزگىلى ٴوتىپ كەتتى.',
	'bookinfo-purchase' => 'بۇل كىتاپتى $1 دەگەننەن ساتىپ الۋ',
	'bookinfo-provider' => 'دەرەك جەتىستىرۋشىسى: $1',
);

/** Kazakh (Cyrillic script) (‪Қазақша (кирил)‬)
 * @author AlefZet
 */
$messages['kk-cyrl'] = array(
	'bookinfo-header' => 'Кітап мәліметі',
	'bookinfo-result-title' => 'Атауы:',
	'bookinfo-result-author' => 'Ауторы:',
	'bookinfo-result-publisher' => 'Баспагері:',
	'bookinfo-result-year' => 'Жылы:',
	'bookinfo-error-invalidisbn' => 'Жарамсыз ISBN енгізілген.',
	'bookinfo-error-nosuchitem' => 'Тізімнің данасы болмаған не табылмаған.',
	'bookinfo-error-nodriver' => 'Кітап мәліметтерінің өз драйвері бастамаланбады',
	'bookinfo-error-noresponse' => 'Еш жауап жоқ не сұранымдың мезгілі өтіп кетті.',
	'bookinfo-purchase' => 'Бұл кітапты $1 дегеннен сатып алу',
	'bookinfo-provider' => 'Дерек жетістірушісі: $1',
);

/** Kazakh (Latin script) (‪Qazaqşa (latın)‬) */
$messages['kk-latn'] = array(
	'bookinfo-header' => 'Kitap mälimeti',
	'bookinfo-result-title' => 'Atawı:',
	'bookinfo-result-author' => 'Awtorı:',
	'bookinfo-result-publisher' => 'Baspageri:',
	'bookinfo-result-year' => 'Jılı:',
	'bookinfo-error-invalidisbn' => 'Jaramsız ISBN engizilgen.',
	'bookinfo-error-nosuchitem' => 'Tizimniñ danası bolmağan ne tabılmağan.',
	'bookinfo-error-nodriver' => 'Kitap mälimetteriniñ öz draýveri bastamalanbadı',
	'bookinfo-error-noresponse' => 'Eş jawap joq ne suranımdıñ mezgili ötip ketti.',
	'bookinfo-purchase' => 'Bul kitaptı $1 degennen satıp alw',
	'bookinfo-provider' => 'Derek jetistirwşisi: $1',
);

/** Kalaallisut (Kalaallisut)
 * @author Qaqqalik
 */
$messages['kl'] = array(
	'bookinfo-result-year' => 'Ukioq:',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'bookinfo-header' => 'ព័ត៌មានអំពីសៀវភៅ',
	'bookinformation-desc' => 'ពង្រីក [[Special:Booksources|ទំព័រ​ពិសេស​អំពី​ប្រភព​សៀវភៅ]] ជាមួយព័ត៌មាន​ពីសេវាវិប',
	'bookinfo-result-title' => 'ចំណងជើង៖',
	'bookinfo-result-author' => 'អ្នកនិពន្ធ៖',
	'bookinfo-result-publisher' => 'ក្រុមហ៊ុនបោះពុម្ភផ្សាយ ៖',
	'bookinfo-result-year' => 'ឆ្នាំ៖',
	'bookinfo-error-invalidisbn' => 'លេខ ISBN មិនត្រឹមត្រូវ​ត្រូវបានបញ្ចូល។',
	'bookinfo-error-nosuchitem' => 'មុខរបស់ មិនមាន ឬ មិនអាចរកឃើញ ។',
	'bookinfo-error-noresponse' => 'គ្មានចម្លើយ ឬ សំណើបានអស់ពេល។',
	'bookinfo-purchase' => 'ជាវសៀវភៅនេះ​ពី $1',
	'bookinfo-provider' => 'អ្នកផ្គត់ផ្គង់ទិន្នន័យ៖ $1',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'bookinfo-result-title' => 'ಶೀರ್ಷಿಕೆ:',
	'bookinfo-result-author' => 'ಕರ್ತೃ:',
	'bookinfo-result-year' => 'ವರ್ಷ:',
);

/** Korean (한국어)
 * @author Klutzy
 * @author Kwj2772
 * @author Yknok29
 */
$messages['ko'] = array(
	'bookinfo-header' => '책 정보',
	'bookinformation-desc' => '웹 서비스의 정보를 바탕으로 [[Special:Booksources|책 찾기 특수 문서]]를 확장',
	'bookinfo-result-title' => '제목:',
	'bookinfo-result-author' => '저자:',
	'bookinfo-result-publisher' => '출판사:',
	'bookinfo-result-year' => '연도:',
	'bookinfo-error-invalidisbn' => '잘못된 ISBN이 입력되었습니다.',
	'bookinfo-error-nosuchitem' => '해당되는 결과가 없거나 찾을 수 없습니다.',
	'bookinfo-error-nodriver' => '책 정보 드라이버를 초기화할 수 없습니다.',
	'bookinfo-error-noresponse' => '서버의 반응이 없가나 요청 시간을 초과했습니다.',
	'bookinfo-purchase' => '$1에서 이 책을 구입하기',
	'bookinfo-provider' => '데이터 제공자: $1',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'bookinfo-header' => 'Enfomazjuhne övver Böhsher.',
	'bookinformation-desc' => 'Deit de [[Special:Booksources|Söndersigg drövver, woh mer Bööscher herkritt]] öm de Enfomazjuhne fun enem Deens em Web verjrüßere.',
	'bookinfo-result-title' => 'Tittel:',
	'bookinfo-result-author' => 'Schriver:',
	'bookinfo-result-publisher' => 'Verläjer:',
	'bookinfo-result-year' => 'Johr:',
	'bookinfo-error-invalidisbn' => 'kapodde ISBN.',
	'bookinfo-error-nosuchitem' => 'Dat Denge jidd_et nit, udder mer kunnte et nit fenge,',
	'bookinfo-error-nodriver' => 'Mer kunnte nit mem Zojreff övver de Boch-Ennfomazjuhns-Schnettstell aanfange, dä Driever hät nit metjemaat.',
	'bookinfo-error-noresponse' => 'Kei Antwoot udder et hät ze lang jedohrt.',
	'bookinfo-purchase' => 'Dat Boch kammer fum $1 krijje',
	'bookinfo-provider' => 'De Date hät jelivvert: $1',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 * @author Gomada
 */
$messages['ku-latn'] = array(
	'bookinfo-result-title' => 'Sernav:',
	'bookinfo-result-author' => 'Nivîskar:',
	'bookinfo-result-publisher' => 'Weşanger:',
	'bookinfo-result-year' => 'Sal:',
);

/** Latin (Latina)
 * @author SPQRobin
 */
$messages['la'] = array(
	'bookinfo-result-title' => 'Titulus:',
	'bookinfo-result-author' => 'Auctor:',
	'bookinfo-result-year' => 'Annus:',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'bookinfo-header' => 'Informatiounen iwwer Bicher',
	'bookinformation-desc' => "Erweidert [[Special:Booksources|d'Spezialsäit vun de Bicherreferenzen]] mat Informatiounen vun enger Offer um Internet",
	'bookinfo-result-title' => 'Titel:',
	'bookinfo-result-author' => 'Auteur:',
	'bookinfo-result-publisher' => 'Editeur:',
	'bookinfo-result-year' => 'Joer:',
	'bookinfo-error-invalidisbn' => 'Dir hutt eng ISBN aginn déi et net gëtt.',
	'bookinfo-error-nosuchitem' => "D'Säit gëtt et net oder si gouf net fonnt.",
	'bookinfo-error-nodriver' => "Et war net méiglech fir déi respektiv Buchinformatiounsquell z'initialiséieren.",
	'bookinfo-error-noresponse' => "Keng Äntwert oder d'Ufro huet ze laang gebraucht (timed out)",
	'bookinfo-purchase' => 'Dëst Buch op $1 kafen',
	'bookinfo-provider' => 'Informatioune vun: $1',
);

/** Lezghian (Лезги) */
$messages['lez'] = array(
	'bookinfo-result-year' => 'Йис:',
);

/** Lingua Franca Nova (Lingua Franca Nova)
 * @author Malafaya
 */
$messages['lfn'] = array(
	'bookinfo-result-title' => 'Titulo:',
	'bookinfo-result-author' => 'Autor:',
	'bookinfo-result-year' => 'Anio:',
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 * @author Pahles
 */
$messages['li'] = array(
	'bookinfo-header' => 'Boke informatie',
	'bookinformation-desc' => "Oetbreijing veur [[Special:Booksources|speciaal pazjena Bookinformatie]] mit informatie van 'n webservice",
	'bookinfo-result-title' => 'Titel:',
	'bookinfo-result-author' => 'Auteur:',
	'bookinfo-result-publisher' => 'Oetgaever:',
	'bookinfo-result-year' => 'Jaor:',
	'bookinfo-error-invalidisbn' => 'Ónkrèk ISBN-nómmer gegaeve.',
	'bookinfo-error-nosuchitem' => 'Besteit neet of kós neet gevónje waere.',
	'bookinfo-error-nodriver' => 'Kós de zjuuste Boke Informatie Driver neet initialisere.',
	'bookinfo-error-noresponse' => "Gein antjwaord of 'ne tied-oet.",
	'bookinfo-purchase' => 'Koup dit book bie $1.',
	'bookinfo-provider' => 'Gegaeves geleverdj door: $1',
);

/** Lithuanian (Lietuvių)
 * @author Ignas693
 * @author Matasg
 */
$messages['lt'] = array(
	'bookinfo-header' => 'Knygos informacija',
	'bookinformation-desc' => 'Išplečia [[specialus: Booksources|book šaltinių specialus puslapis]] informaciją iš tinklo tarnybos',
	'bookinfo-result-title' => 'Pavadinimas:',
	'bookinfo-result-author' => 'Autorius:',
	'bookinfo-result-publisher' => 'Leidėjas:',
	'bookinfo-result-year' => 'Metai:',
	'bookinfo-error-invalidisbn' => 'Įvestas blogas ISBN',
	'bookinfo-error-nosuchitem' => 'Prekės nėra arba rasti neįmanoma.',
	'bookinfo-error-nodriver' => 'Negalima inicijuoti atitinkamą knygos informacija tvarkyklę.',
	'bookinfo-error-noresponse' => 'Nr reagavimo arba prašymą, baigėsi.',
	'bookinfo-purchase' => 'Pirkti šią knygą iš $1',
	'bookinfo-provider' => 'Duomenų teikėjas:$1',
);

/** Latvian (Latviešu)
 * @author Papuass
 */
$messages['lv'] = array(
	'bookinfo-header' => 'Grāmatas informācija',
	'bookinfo-result-title' => 'Nosaukums:',
	'bookinfo-result-author' => 'Autors:',
	'bookinfo-result-publisher' => 'Izdevējs:',
	'bookinfo-result-year' => 'Gads:',
	'bookinfo-error-invalidisbn' => 'Ievadīts nederīgs ISBN.',
);

/** Malagasy (Malagasy)
 * @author Jagwar
 */
$messages['mg'] = array(
	'bookinfo-header' => 'Antsipirihany momba ny boky',
	'bookinformation-desc' => "Mameno ny [[Special:Booksources|pejy manokana momba ny foto-boky]] avy amin'ny servisy Internet",
	'bookinfo-result-title' => 'lohateny:',
	'bookinfo-result-author' => 'Mpanoratra azy:',
	'bookinfo-result-publisher' => 'Mpamoaka azy:',
	'bookinfo-result-year' => 'Taona:',
	'bookinfo-error-invalidisbn' => 'Tsy izy ny ISBN nampidirinao',
	'bookinfo-error-nosuchitem' => 'Tsy hita tao io zavatra io na tsy misy',
	'bookinfo-error-nodriver' => "Tsy afaka mandefa ny rindrankajy momba ny antsipirihan'ny boky",
	'bookinfo-error-noresponse' => 'Tsy nisy valiny na ela loatra niandry.',
	'bookinfo-purchase' => "Vidio any amin'ny $1 io boky",
	'bookinfo-provider' => 'mpanome data : $1',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'bookinfo-header' => 'Информации за книга',
	'bookinformation-desc' => 'Додаток на [[Special:Booksources|специјалната страница за книги]] со информации од мрежна служба',
	'bookinfo-result-title' => 'Наслов:',
	'bookinfo-result-author' => 'Автор:',
	'bookinfo-result-publisher' => 'Издавач:',
	'bookinfo-result-year' => 'Година:',
	'bookinfo-error-invalidisbn' => 'Погрешен ISBN.',
	'bookinfo-error-nosuchitem' => 'Податокот не постои или не може да се најде.',
	'bookinfo-error-nodriver' => 'Не можам да пуштам соодветен двигател за информации за книги.',
	'bookinfo-error-noresponse' => 'Нема одговор или барањето е истечено.',
	'bookinfo-purchase' => 'Нарачај ја книгава од $1',
	'bookinfo-provider' => 'Добавувач на податоците: $1',
);

/** Malayalam (മലയാളം)
 * @author Jacob.jose
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'bookinfo-header' => 'പുസ്തകത്തെക്കുറിച്ചുള്ള വിവരങ്ങൾ',
	'bookinformation-desc' => '[[Special:Booksources]] എന്ന പ്രത്യേകതാൾ വെബ്ബ് സർ‌വീസിലെ വിവരവും ചേർത്ത് വികസിപ്പിക്കുന്നു.',
	'bookinfo-result-title' => 'ശീർഷകം:',
	'bookinfo-result-author' => 'ഗ്രന്ഥകർത്താവ്:',
	'bookinfo-result-publisher' => 'പ്രസാധകൻ:',
	'bookinfo-result-year' => 'വർഷം:',
	'bookinfo-error-invalidisbn' => 'താങ്കൾ രേഖപ്പെടുത്തിയ ISBN സംഖ്യ അസാധുവാണ്‌.',
	'bookinfo-error-nosuchitem' => 'ഈ ഇനം കണ്ടെത്താൻ കഴിഞ്ഞില്ല അല്ലെങ്കിൽ നിലവിലില്ല.',
	'bookinfo-error-nodriver' => 'അനുയോജ്യമായ പുസ്തക വിവര ഡ്രൈവർ തുടങ്ങാൻ സാധിച്ചില്ല.',
	'bookinfo-error-noresponse' => 'പ്രതികരണമില്ല അല്ലെങ്കിൽ അപേക്ഷയുടെ സമയപരിധി കഴിഞ്ഞു',
	'bookinfo-purchase' => 'ഈ പുസ്തകം $1ൽ നിന്നു വാങ്ങുക',
	'bookinfo-provider' => 'ഡാറ്റ ദാതാവ്: $1',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'bookinfo-header' => 'ग्रंथ माहिती',
	'bookinformation-desc' => 'जालावरील माहिती घेवून [[Special:Booksources]] वाढवा',
	'bookinfo-result-title' => 'शीर्षक:',
	'bookinfo-result-author' => 'लेखक:',
	'bookinfo-result-publisher' => 'प्रकाशक:',
	'bookinfo-result-year' => 'वर्ष:',
	'bookinfo-error-invalidisbn' => 'चूकीचा ISBN भरला',
	'bookinfo-error-nosuchitem' => 'संचिका सापडली नाही किंवा अस्तित्वात नाही.',
	'bookinfo-error-nodriver' => 'योग्य असा बुक माहिती ड्रायव्हर सुरु करु शकत नाही.',
	'bookinfo-error-noresponse' => 'कुठलीही प्रतिक्रिया नाही किंवा वेळ संपलेली आहे.',
	'bookinfo-purchase' => 'हे पुस्तक $1कडून खरेदी करा',
	'bookinfo-provider' => 'विदा दाता: $1',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'bookinfo-header' => 'Maklumat buku',
	'bookinformation-desc' => 'Meluaskan [[Special:Booksources|laman khas sumber buku]] dengan maklumat dari perkhidmatan web',
	'bookinfo-result-title' => 'Tajuk:',
	'bookinfo-result-author' => 'Pengarang:',
	'bookinfo-result-publisher' => 'Penerbit:',
	'bookinfo-result-year' => 'Tahun:',
	'bookinfo-error-invalidisbn' => 'ISBN yang diberikan tidak sah.',
	'bookinfo-error-nosuchitem' => 'Butiran tidak wujud atau tidak dapat dicari.',
	'bookinfo-error-nodriver' => 'Book Information Driver yang bersesuaian tidak dapat dilancarkan.',
	'bookinfo-error-noresponse' => 'Tiada gerak balas, atau permohonan kehabisan masa.',
	'bookinfo-purchase' => 'Beli buku ini dari $1',
	'bookinfo-provider' => 'Pembekal data: $1',
);

/** Burmese (မြန်မာဘာသာ)
 * @author Erikoo
 */
$messages['my'] = array(
	'bookinfo-result-title' => 'ခေါင်းစဉ် :',
	'bookinfo-result-author' => 'ဖန်တီးသူ:',
);

/** Erzya (Эрзянь)
 * @author Amdf
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'bookinfo-result-title' => 'Коняксозо:',
	'bookinfo-result-author' => 'Сёрмадыцязо:',
	'bookinfo-result-year' => 'Ие:',
	'bookinfo-error-invalidisbn' => 'А истямо ISBN максыть',
);

/** Mazanderani (مازِرونی)
 * @author محک
 */
$messages['mzn'] = array(
	'bookinfo-header' => 'اطلاعات کتاب',
	'bookinformation-desc' => '[[Special:Booksources]] ره با استفاده از اطلاعات اتا سرویس اینترنتی گت کانده',
	'bookinfo-result-title' => 'ایسم:',
	'bookinfo-result-author' => 'نویسنده:',
	'bookinfo-result-publisher' => 'ناشر:',
	'bookinfo-result-year' => 'سال انتشار:',
	'bookinfo-error-invalidisbn' => 'شابک غیرموجاز وارد بیی‌ئه.',
	'bookinfo-error-nosuchitem' => 'این مورد دنی‌یه یا پیدا نیّه.',
	'bookinfo-error-nodriver' => 'راه‌انداز مناسب اطلاعات کتاب قابل به کاربییتن نی‌یه.',
	'bookinfo-error-noresponse' => 'جوابی دنی‌بی‌یه یا مهلت درخاست تموم بَیبی‌یه.',
	'bookinfo-purchase' => 'بخرین‌ین این کتاب $1 جه',
	'bookinfo-provider' => 'مهیاکنندهٔ اطلاعات: $1',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'bookinfo-result-title' => 'Tōcāitl:',
	'bookinfo-result-author' => 'Chīhualōni:',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['nb'] = array(
	'bookinfo-header' => 'Bokinformasjon',
	'bookinformation-desc' => 'Utvider [[Special:Booksources|siden med bokkilder]] med informasjon fra en nettjeneste',
	'bookinfo-result-title' => 'Tittel:',
	'bookinfo-result-author' => 'Forfatter:',
	'bookinfo-result-publisher' => 'Utgiver:',
	'bookinfo-result-year' => 'År:',
	'bookinfo-error-invalidisbn' => 'Ugyldig ISBN angitt.',
	'bookinfo-error-nosuchitem' => 'Boken eksisterer ikke, eller kunne ikke finnes.',
	'bookinfo-error-nodriver' => 'Kunne ikke sette i gang en passende bokinformasjonsdriver.',
	'bookinfo-error-noresponse' => 'Ingen respons eller tidsavbrudd.',
	'bookinfo-purchase' => 'Kjøp denne boken fra $1',
	'bookinfo-provider' => 'Dataleverandør: $1',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'bookinfo-header' => 'Informatschonen to Böker',
	'bookinfo-result-title' => 'Titel:',
	'bookinfo-result-author' => 'Schriever:',
	'bookinfo-result-publisher' => 'Verlag:',
	'bookinfo-result-year' => 'Johr:',
	'bookinfo-error-invalidisbn' => 'ISBN gellt nich.',
	'bookinfo-purchase' => 'Koop dit Book bi $1',
	'bookinfo-provider' => 'Daten vun: $1',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'bookinfo-header' => 'Boekinformatie',
	'bookinformation-desc' => 'Uitbreiding voor de [[Special:Booksources|speciale pagina Boekinformatie]] met informatie van een webservice',
	'bookinfo-result-title' => 'Titel:',
	'bookinfo-result-author' => 'Auteur:',
	'bookinfo-result-publisher' => 'Uitgever:',
	'bookinfo-result-year' => 'Jaar:',
	'bookinfo-error-invalidisbn' => 'Ongeldig ISBN ingegeven.',
	'bookinfo-error-nosuchitem' => 'Bestaat niet of kon niet gevonden worden.',
	'bookinfo-error-nodriver' => 'Kon de juiste Boekinformatie Driver niet initialiseren.',
	'bookinfo-error-noresponse' => 'Geen antwoord of een time-out.',
	'bookinfo-purchase' => 'Dit boek bij $1 kopen',
	'bookinfo-provider' => 'Gegevens geleverd door: $1',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'bookinfo-header' => 'Bokinformasjon',
	'bookinformation-desc' => 'Utvider [[Special:Booksources|sida med bokkjelder]] med informasjon frå ei nettenesta',
	'bookinfo-result-title' => 'Tittel:',
	'bookinfo-result-author' => 'Forfattar:',
	'bookinfo-result-publisher' => 'Utgjevar:',
	'bookinfo-result-year' => 'År:',
	'bookinfo-error-invalidisbn' => 'Ikkje ein gyldig ISBN.',
	'bookinfo-error-nosuchitem' => 'Boka eksisterer ikkje, eller kunne ikkje verta funne.',
	'bookinfo-error-nodriver' => 'Kunne ikkje setja i gang ein passande bokinformasjonsdrivar.',
	'bookinfo-error-noresponse' => 'Ingen respons eller tidsavbrot.',
	'bookinfo-purchase' => 'Kjøp boka frå $1',
	'bookinfo-provider' => 'Dataleverandør: $1',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'bookinfo-result-title' => 'Thaetlele',
	'bookinfo-result-author' => 'Mongwadi:',
	'bookinfo-result-publisher' => 'Mogatiši:',
	'bookinfo-result-year' => 'Ngwaga:',
	'bookinfo-error-nosuchitem' => 'Hlogwana ga e gona goba ga e humanege.',
	'bookinfo-purchase' => 'Reka puku ye go $1',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'bookinfo-header' => 'Entresenhas suls obratges',
	'bookinformation-desc' => "Espandís [[Special:Booksources|la pagina especiala de las fonts del libre]] amb d'entresenhas a partir d’un servici internet",
	'bookinfo-result-title' => 'Títol :',
	'bookinfo-result-author' => 'Autor :',
	'bookinfo-result-publisher' => 'Editor :',
	'bookinfo-result-year' => 'Annada :',
	'bookinfo-error-invalidisbn' => 'ISBN invalid.',
	'bookinfo-error-nosuchitem' => 'Aqueste element existís pas o es pas pogut èsser trobat.',
	'bookinfo-error-nodriver' => 'Impossible d’inicializar un motor d’informacion suls obratges.',
	'bookinfo-error-noresponse' => 'Cap de responsa o depassament de la sosta.',
	'bookinfo-purchase' => 'Crompar aqueste libre sus $1',
	'bookinfo-provider' => 'Fornidor de donadas : $1',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Psubhashish
 */
$messages['or'] = array(
	'bookinfo-result-title' => 'ଶିରୋନାମା:',
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'bookinfo-header' => 'Чиныджы тыххæй информаци',
	'bookinfo-result-title' => 'Сæргонд:',
	'bookinfo-result-author' => 'Автор:',
	'bookinfo-result-year' => 'Аз:',
	'bookinfo-purchase' => 'Ацы чиныг алхæнæн ис ам $1:',
);

/** Pampanga (Kapampangan)
 * @author Katimawan2005
 */
$messages['pam'] = array(
	'bookinformation-desc' => 'Miragdagan ya [[Special:Booksources]] kapamilatan ning impormasiun ibat king metung a web service',
	'bookinfo-result-title' => 'Bansag:',
	'bookinfo-result-author' => 'Talasulat',
	'bookinfo-result-publisher' => 'Talabulalag (Publisher):',
	'bookinfo-error-nosuchitem' => 'Ala yu o e meyakit ing bageng iti.',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'bookinfo-result-title' => 'Titel:',
	'bookinfo-result-author' => 'Schreiwer:',
	'bookinfo-result-year' => 'Yaahr:',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Holek
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'bookinfo-header' => 'Informacja o książce',
	'bookinformation-desc' => 'Rozszerza [[Special:Booksources|informacje o źródłach]] korzystając z serwisów internetowych o książkach',
	'bookinfo-result-title' => 'Tytuł:',
	'bookinfo-result-author' => 'Autor:',
	'bookinfo-result-publisher' => 'Wydawca:',
	'bookinfo-result-year' => 'Rok:',
	'bookinfo-error-invalidisbn' => 'Wprowadzono niepoprawny ISBN.',
	'bookinfo-error-nosuchitem' => 'Pozycja nie istnieje lub nie mogła zostać odnaleziona.',
	'bookinfo-error-nodriver' => 'Nie udało się zainicjować odpowiedniego sterownika Book Information.',
	'bookinfo-error-noresponse' => 'Brak odpowiedzi lub przekroczony dopuszczalny czas odpowiedzi.',
	'bookinfo-purchase' => 'Kup tę książkę w $1',
	'bookinfo-provider' => 'Źródło informacji: $1',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 * @author Dragonòt
 */
$messages['pms'] = array(
	'bookinfo-header' => 'Anformassion ant sëj lìber',
	'bookinformation-desc' => 'A espand la [[Special:Booksources|pàgina special dle sorziss sij lìber]] con anformassion pijà da un sërvissi Web',
	'bookinfo-result-title' => 'Tìtol:',
	'bookinfo-result-author' => 'Aotor:',
	'bookinfo-result-publisher' => 'Editor:',
	'bookinfo-result-year' => 'Ann:',
	'bookinfo-error-invalidisbn' => 'ISBN pa giusta',
	'bookinfo-error-nosuchitem' => "Vos che ò ch'a-i é nen ò ch'a l'é pa trovasse.",
	'bookinfo-error-nodriver' => "As riess nen a fé parte ël pilòta dj'Anformassion ant sëj Lìber",
	'bookinfo-error-noresponse' => "Pa d'arspòsta, ò miraco a la riva mach tròp tard",
	'bookinfo-purchase' => 'Caté ël lìber da: $1',
	'bookinfo-provider' => 'Sorgiss dij dat: $1',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'bookinfo-header' => 'د کتاب مالومات',
	'bookinfo-result-title' => 'سرليک:',
	'bookinfo-result-author' => 'ليکوال:',
	'bookinfo-result-publisher' => 'خپرونکی:',
	'bookinfo-result-year' => 'کال:',
	'bookinfo-error-invalidisbn' => 'تاسو يو ناسم ISBN ليکلی.',
	'bookinfo-error-nosuchitem' => 'يا خو همدا توکی نه شته او يا هم و نه موندلای شو.',
	'bookinfo-purchase' => 'همدا کتاب د $1 نه وپېرۍ',
);

/** Portuguese (Português)
 * @author 555
 * @author Hamilton Abreu
 * @author Malafaya
 */
$messages['pt'] = array(
	'bookinfo-header' => 'Informação de livro',
	'bookinformation-desc' => 'Expande a [[Special:Booksources|página especial de fontes de livros]] com informação proveniente de um web service',
	'bookinfo-result-title' => 'Título:',
	'bookinfo-result-author' => 'Autor:',
	'bookinfo-result-publisher' => 'Editora:',
	'bookinfo-result-year' => 'Ano:',
	'bookinfo-error-invalidisbn' => 'O código ISBN introduzido é inválido.',
	'bookinfo-error-nosuchitem' => 'O item não existe ou não foi encontrado.',
	'bookinfo-error-nodriver' => 'Não foi possível inicializar um Book Information Driver (Dispositivo de Informação de Livro) apropriado.',
	'bookinfo-error-noresponse' => 'Sem resposta ou tempo de pedido expirado.',
	'bookinfo-purchase' => 'Comprar este livro a $1',
	'bookinfo-provider' => 'Fornecedor de dados: $1',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'bookinfo-header' => 'Informações do livro',
	'bookinformation-desc' => 'Expande a [[Special:Booksources|página especial de fontes de livros]] com informação proveniente de um serviço web',
	'bookinfo-result-title' => 'Título:',
	'bookinfo-result-author' => 'Autor:',
	'bookinfo-result-publisher' => 'Editora:',
	'bookinfo-result-year' => 'Ano:',
	'bookinfo-error-invalidisbn' => 'O código ISBN introduzido é inválido.',
	'bookinfo-error-nosuchitem' => 'O item não existe ou não foi encontrado.',
	'bookinfo-error-nodriver' => 'Não foi possível inicializar um Book Information Driver (Dispositivo de Informação de Livro) apropriado.',
	'bookinfo-error-noresponse' => 'Sem resposta ou tempo de pedido expirado.',
	'bookinfo-purchase' => 'Comprar este livro em $1',
	'bookinfo-provider' => 'Provedor de dados: $1',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'bookinfo-header' => 'Liwrumanta willakuna',
	'bookinformation-desc' => "[[Special:Booksources|Liwru pukyu sapaq p'anqata]] llikapi sirwiymanta willaykunawan mast'arin",
	'bookinfo-result-title' => 'Liwrup sutin:',
	'bookinfo-result-author' => 'Qillqaq:',
	'bookinfo-result-publisher' => 'Uyaychaq:',
	'bookinfo-result-year' => 'Uyaychay wata:',
	'bookinfo-error-invalidisbn' => 'ISBN huchhaqa manam allinchu.',
	'bookinfo-error-nosuchitem' => 'Chay sutiyuq liwruqa manam kanchu icha manam tarisqachu.',
	'bookinfo-error-nodriver' => 'Manam atinichu allin Liwru Willaykuna Pusanata churariyta.',
	'bookinfo-error-noresponse' => "Manam kutichinchu icha mit'a yallisqaña.",
	'bookinfo-purchase' => 'Kay liwruta $1-manta rantiy',
	'bookinfo-provider' => 'Willakunata kamaq: $1',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 * @author Mihai
 * @author Minisarm
 */
$messages['ro'] = array(
	'bookinfo-header' => 'Informații despre carte',
	'bookinformation-desc' => 'Completează [[Special:Booksources|pagina specială a surselor de cărți]] cu informații de la un serviciu web',
	'bookinfo-result-title' => 'Titlu:',
	'bookinfo-result-author' => 'Autor:',
	'bookinfo-result-publisher' => 'Editură:',
	'bookinfo-result-year' => 'An:',
	'bookinfo-error-invalidisbn' => 'ISBN invalid.',
	'bookinfo-error-nosuchitem' => 'Elementul nu există sau nu a putut fi găsit.',
	'bookinfo-error-nodriver' => 'Nu poate fi accesată nicio sursă cu informații despe carte.',
	'bookinfo-error-noresponse' => 'Niciun răspuns sau cererea a expirat.',
	'bookinfo-purchase' => 'Cumpărați această carte de la $1',
	'bookinfo-provider' => 'Furnizor de date: $1',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'bookinfo-header' => "'Mbormazione sus a 'u libbre",
	'bookinformation-desc' => "Spanne 'a [[Special:Booksources|pàgena speciale de le sorgende de le libbre]] cu le 'mbormaziune da 'nu servizie web",
	'bookinfo-result-title' => 'Titele:',
	'bookinfo-result-author' => 'Autore:',
	'bookinfo-result-publisher' => 'Pubblicatore:',
	'bookinfo-result-year' => 'Anne:',
	'bookinfo-error-invalidisbn' => 'ISBN inzerite invalide.',
	'bookinfo-error-nosuchitem' => "L'artichele non g'esiste o non ge se pò acchià.",
	'bookinfo-error-nodriver' => "Non ge se pò inizializzà 'nu Driver appropriate de 'mbormaziune sus a le libbew.",
	'bookinfo-error-noresponse' => "Nisciuna risposte o 'a richieste ha scadute.",
	'bookinfo-purchase' => 'Accatte stu libbre da $1',
	'bookinfo-provider' => "Fornitore d'u date: $1",
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'bookinfo-header' => 'Информация о книге',
	'bookinformation-desc' => 'Расширяет [[Special:Booksources|служебную страницу «Источники книг»]] сведениями из веб-служб',
	'bookinfo-result-title' => 'Название:',
	'bookinfo-result-author' => 'Автор:',
	'bookinfo-result-publisher' => 'Издательство:',
	'bookinfo-result-year' => 'Год:',
	'bookinfo-error-invalidisbn' => 'Ошибочная ISBN-запись.',
	'bookinfo-error-nosuchitem' => 'Данные отсутствуют или не могут быть найдены.',
	'bookinfo-error-nodriver' => 'Ошибка инициализации соответствующего драйвера информации о книгах.',
	'bookinfo-error-noresponse' => 'Нет ответа или превышение времени ожидания ответа.',
	'bookinfo-purchase' => 'Купить эту книгу на $1',
	'bookinfo-provider' => 'Поставщик информации: $1',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'bookinfo-result-title' => 'Назва:',
	'bookinfo-result-author' => 'Автор:',
	'bookinfo-result-publisher' => 'Выдаватель:',
	'bookinfo-result-year' => 'Рік:',
	'bookinfo-error-invalidisbn' => 'Зазначене неправилне ISBN.',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'bookinfo-header' => 'Кинигэ туһунан',
	'bookinformation-desc' => 'Ситим (Веб) сулууспаларын сибидиэнньэлэринэн [[Special:Booksources|кинигэлэр источниктарын туһунан анал сирэйи]] кэҥэтэр',
	'bookinfo-result-title' => 'Аата:',
	'bookinfo-result-author' => 'Суруйааччы:',
	'bookinfo-result-publisher' => 'Кинигэ кыһата:',
	'bookinfo-result-year' => 'Сыла:',
	'bookinfo-error-invalidisbn' => 'Сыыһа ISBN турбут.',
	'bookinfo-error-nosuchitem' => 'Бу туһунан суох эбэтэр кыайан булуллубата.',
	'bookinfo-error-nodriver' => 'Кинигэ туһунан драйвер сатаан инициализацияламмат.',
	'bookinfo-error-noresponse' => 'Хоруй суох эбэтэр болдьоҕо ааста.',
	'bookinfo-purchase' => 'Бу кинигэни мантан атыылаһарга: $1',
	'bookinfo-provider' => 'Информацияны ким биэрбитэ: $1',
);

/** Sicilian (Sicilianu)
 * @author Aushulz
 */
$messages['scn'] = array(
	'bookinfo-result-title' => 'Tìtulu:',
	'bookinfo-result-year' => 'Annu:',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'bookinfo-header' => 'Informácie o knihách',
	'bookinformation-desc' => 'Rozširuje špeciálnu stránku [[Special:Booksources|Knižné zdroje]] o informácie z webovej služby',
	'bookinfo-result-title' => 'Názov:',
	'bookinfo-result-author' => 'Autor:',
	'bookinfo-result-publisher' => 'Vydavateľ:',
	'bookinfo-result-year' => 'Rok:',
	'bookinfo-error-invalidisbn' => 'Zadané neplatné ISBN.',
	'bookinfo-error-nosuchitem' => 'Položka neexistuje alebo nebola nenájdená.',
	'bookinfo-error-nodriver' => 'Nebolo možné inicializovať vhodný ovládač pre informácie o knihách.',
	'bookinfo-error-noresponse' => 'Bez odpovede alebo čas vyhradený na odpoveď vypršal.',
	'bookinfo-purchase' => 'Kúpiť túto knihu z $1',
	'bookinfo-provider' => 'Poskytovateľ údajov: $1',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'bookinfo-header' => 'Informacije o knjigah',
	'bookinformation-desc' => 'Razširi [[Special:Booksources|posebno stran z viri knjih]] z informacijami iz spletnih storitev',
	'bookinfo-result-title' => 'Naslov:',
	'bookinfo-result-author' => 'Avtor:',
	'bookinfo-result-publisher' => 'Založba:',
	'bookinfo-result-year' => 'Leto:',
	'bookinfo-error-invalidisbn' => 'Vnesen je bil neveljaven ISBN.',
	'bookinfo-error-nosuchitem' => 'Predmet ne obstaja ali ga ni mogoče najti.',
	'bookinfo-error-nodriver' => 'Ne morem zagnati ustreznega Gonilnika informacij o knjigah (Book Information Driver).',
	'bookinfo-error-noresponse' => 'Ni odgovora ali pa je zahteva potekla.',
	'bookinfo-purchase' => 'Kupite to knjigo pri $1',
	'bookinfo-provider' => 'Podatke nudi: $1',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Sasa Stefanovic
 */
$messages['sr-ec'] = array(
	'bookinfo-header' => 'Подаци о књизи',
	'bookinfo-result-title' => 'Наслов:',
	'bookinfo-result-author' => 'Аутор:',
	'bookinfo-result-publisher' => 'Издавач:',
	'bookinfo-result-year' => 'Година:',
	'bookinfo-error-invalidisbn' => 'Погрешно укуцан ISBN',
	'bookinfo-purchase' => 'Купите ову књигу од $1',
	'bookinfo-provider' => 'Подаци из: $1',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Rancher
 */
$messages['sr-el'] = array(
	'bookinfo-header' => 'Podaci o knjizi',
	'bookinfo-result-title' => 'Naslov:',
	'bookinfo-result-author' => 'Autor:',
	'bookinfo-result-publisher' => 'Izdavač:',
	'bookinfo-result-year' => 'Godina:',
	'bookinfo-error-invalidisbn' => 'Pogrešno ukucan ISBN',
	'bookinfo-purchase' => 'Kupite ovu knjigu od $1',
	'bookinfo-provider' => 'Podaci iz: $1',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'bookinfo-header' => 'Informatione uur Bouke',
	'bookinformation-desc' => 'Föiget [[Special:Booksources|Boukwällen-Spezioalsiede]] bietou mäd Informatione fon n Webanboad',
	'bookinfo-result-title' => 'Tittel:',
	'bookinfo-result-author' => 'Autor:',
	'bookinfo-result-publisher' => 'Ferlaach:',
	'bookinfo-result-year' => 'Jier:',
	'bookinfo-error-invalidisbn' => 'ISBN nit gultich.',
	'bookinfo-error-nosuchitem' => 'Ju Siede is nit deer of wuude nit fuunen.',
	'bookinfo-error-nodriver' => 'Dät waas nit muugelk, ju äntspreekende Boukinformations-Snitsteede tou initialisierjen.',
	'bookinfo-error-noresponse' => 'Neen Oantwoud of ju Tied is foarbie.',
	'bookinfo-purchase' => 'Dit Bouk kon fon $1 beleeken wäide.',
	'bookinfo-provider' => 'Doaten-Lääwerant: $1',
);

/** Sundanese (Basa Sunda)
 * @author Kandar
 */
$messages['su'] = array(
	'bookinfo-header' => 'Émbaran buku',
	'bookinformation-desc' => 'Legaan [[Special:Booksources]] ngawengku émbaran ti layanan loka',
	'bookinfo-result-title' => 'Judul:',
	'bookinfo-result-author' => 'Pangarang:',
	'bookinfo-result-publisher' => 'Pamedal:',
	'bookinfo-result-year' => 'Taun:',
	'bookinfo-error-invalidisbn' => 'ISBN nu diasupkeun salah.',
	'bookinfo-error-nosuchitem' => 'Euweuh atawa teu kapanggih.',
	'bookinfo-error-nodriver' => 'Gagal mitembeyan Book Information Driver.',
	'bookinfo-error-noresponse' => 'Teu némbal atawa rekésna gagal.',
	'bookinfo-purchase' => 'Beuli ti $1',
	'bookinfo-provider' => 'Panyadia data: $1',
);

/** Swedish (Svenska)
 * @author Lejonel
 * @author M.M.S.
 * @author Sannab
 */
$messages['sv'] = array(
	'bookinfo-header' => 'Bokinformation',
	'bookinformation-desc' => 'Utökar [[Special:Booksources|specialsidan med bokkällor]] med information från en webbservice',
	'bookinfo-result-title' => 'Titel:',
	'bookinfo-result-author' => 'Författare:',
	'bookinfo-result-publisher' => 'Utgivare:',
	'bookinfo-result-year' => 'År:',
	'bookinfo-error-invalidisbn' => 'Ogiltigt ISBN angivet.',
	'bookinfo-error-nosuchitem' => 'Posten existerar inte eller kunde inte hittas.',
	'bookinfo-error-nodriver' => 'Kunde ej starta upp en lämplig drivrutin för bokinformation.',
	'bookinfo-error-noresponse' => 'Fick inget svar eller det tog för lång tid att få svar.',
	'bookinfo-purchase' => 'Köp denna bok från $1',
	'bookinfo-provider' => 'Data hämtat från: $1',
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 */
$messages['szl'] = array(
	'bookinfo-result-title' => 'Titel:',
);

/** Tamil (தமிழ்)
 * @author TRYPPN
 * @author Trengarasu
 */
$messages['ta'] = array(
	'bookinfo-header' => 'நூல் விபரம்',
	'bookinformation-desc' => 'விரிவான செய்திகளை இந்த இணையதள சேவையில் பார்க்கவும் [[Special:Booksources|புத்தகங்கள் கிடைக்குமிடங்கள் பற்றிய சிறப்பு பக்கம்]]',
	'bookinfo-result-title' => 'தலைப்பு:',
	'bookinfo-result-author' => 'ஆசிரியர்:',
	'bookinfo-result-publisher' => 'வெளியீட்டாளர்:',
	'bookinfo-result-year' => 'ஆண்டு:',
	'bookinfo-error-invalidisbn' => 'தவறான ISBN எண்ணைக் கொடுத்துள்ளீர்கள்',
	'bookinfo-error-nosuchitem' => 'தாங்கள் தேடுவது இங்கில்லை (அல்லது) அதனைக் கண்டுபிடிக்க முடியவில்லை',
	'bookinfo-error-nodriver' => 'புத்தகவிவரங்களடங்கிய மெனபொருள் செயலியை தொடக்கநிலைக்குக் கொண்டுவரமுடியவில்லை.',
	'bookinfo-error-noresponse' => 'எந்தவித பதிலும் இல்லை (அல்லது) கொடுக்கப்பட்ட நேர அளவு முடிந்து விட்டது',
	'bookinfo-purchase' => 'இந்த புத்தகத்தை இங்கிருந்து ($1) வாங்கவும்',
	'bookinfo-provider' => 'புத்தங்கள் பற்றிய விவரங்களைக் கொடுப்பவர்: $1',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Veeven
 */
$messages['te'] = array(
	'bookinfo-header' => 'పుస్తకపు సమాచారం',
	'bookinformation-desc' => 'ఏదైనా వెబ్ సేవ నుండి వచ్చిన సమాచారంతో [[Special:Booksources|పుస్తక మూలాల ప్రత్యేక పేజీ]]ని విస్తరిస్తుంది',
	'bookinfo-result-title' => 'శీర్షిక:',
	'bookinfo-result-author' => 'రచయిత:',
	'bookinfo-result-publisher' => 'ప్రచురణకర్త:',
	'bookinfo-result-year' => 'సంవత్సరం:',
	'bookinfo-error-invalidisbn' => 'తప్పుడు ISBN ఇచ్చారు.',
	'bookinfo-error-nosuchitem' => 'అంశం అసలు లేదు లేదా కనబడలేదు.',
	'bookinfo-error-nodriver' => 'సముచితమైన పుస్తక సమాచార డ్రైవరును మేల్కొలపలేకున్నాం.',
	'bookinfo-error-noresponse' => 'ప్రతిస్పందన లేదు లేదా అభ్యర్థన కాలం చెల్లింది.',
	'bookinfo-purchase' => '$1 నుండి ఈ పుస్తకాన్ని కొనండి',
	'bookinfo-provider' => 'డాటా పంపిణీదారు: $1',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'bookinfo-header' => 'Informasaun kona-ba livru',
	'bookinfo-result-title' => 'Títulu:',
	'bookinfo-result-author' => 'Autór:',
	'bookinfo-result-year' => 'Tinan:',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'bookinfo-header' => 'Иттилооти китоб',
	'bookinformation-desc' => '[[Special:Booksources]]ро бо истифода аз иттилооти як вебхидмати Интернетӣ густариш медиҳад',
	'bookinfo-result-title' => 'Унвон:',
	'bookinfo-result-author' => 'Муаллиф:',
	'bookinfo-result-publisher' => 'Нашриёт:',
	'bookinfo-result-year' => 'Соли интишор:',
	'bookinfo-error-invalidisbn' => 'ISBN-ии ғайримиҷоз ворид шудааст.',
	'bookinfo-error-nosuchitem' => 'Ин маврид вуҷуд надорад ё пайдо нашуд.',
	'bookinfo-error-nodriver' => 'Роҳандози муносиби иттилооти китоб қобил ба коргирӣ нест.',
	'bookinfo-error-noresponse' => 'Посухе вуҷуд надошт ё мӯҳлати дархост сипарӣ шуд.',
	'bookinfo-purchase' => 'Харидани ин китоб аз $1',
	'bookinfo-provider' => 'Муҳаёкунандаи иттилоот: $1',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'bookinfo-header' => 'Ittilooti kitob',
	'bookinformation-desc' => '[[Special:Booksources]]ro bo istifoda az ittilooti jak vebxidmati Internetī gustariş medihad',
	'bookinfo-result-title' => 'Unvon:',
	'bookinfo-result-author' => 'Muallif:',
	'bookinfo-result-publisher' => 'Naşrijot:',
	'bookinfo-result-year' => 'Soli intişor:',
	'bookinfo-error-invalidisbn' => 'ISBN-iji ƣajrimiçoz vorid şudaast.',
	'bookinfo-error-nosuchitem' => 'In mavrid vuçud nadorad jo pajdo naşud.',
	'bookinfo-error-nodriver' => 'Rohandozi munosibi ittilooti kitob qobil ba korgirī nest.',
	'bookinfo-error-noresponse' => 'Posuxe vuçud nadoşt jo mūhlati darxost siparī şud.',
	'bookinfo-purchase' => 'Xaridani in kitob az $1',
	'bookinfo-provider' => 'Muhajokunandai ittiloot: $1',
);

/** Thai (ไทย)
 * @author Ans
 * @author Manop
 * @author Woraponboonkerd
 */
$messages['th'] = array(
	'bookinfo-header' => 'ข้อมูลหนังสือ',
	'bookinformation-desc' => 'ข้อมูลเพิ่มเติม[[Special:Booksources|หน้าพิเศษเกี่ยวกับข้อมูลหนังสือ]]จากบริการบนเว็บไซต์',
	'bookinfo-result-title' => 'ชื่อหนังสือ:',
	'bookinfo-result-author' => 'ผู้แต่ง:',
	'bookinfo-result-publisher' => 'ผู้ตีพิมพ์:',
	'bookinfo-result-year' => 'ปี:',
	'bookinfo-error-invalidisbn' => 'รหัส ISBN ที่ใส่ไม่ถูกต้อง',
	'bookinfo-error-nosuchitem' => 'ไม่พบข้อมูลหนังสือ',
	'bookinfo-error-nodriver' => 'ไม่สามารถเริ่มต้นไดร์ฟเวอร์ของข้ิอมูลหนังสือที่เหมาะสมได้',
	'bookinfo-error-noresponse' => 'ไม่มีการตอบรับหรือการร้องขอหมดเวลาก่อน',
	'bookinfo-purchase' => 'ซื้อหนังสือเล่มนี้ได้ที่ $1',
	'bookinfo-provider' => 'ผู้ให้ข้อมูล: $1',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'bookinfo-header' => 'Kabatiran sa aklat',
	'bookinformation-desc' => 'Nagpapalawak sa [[Special:Booksources|natatanging pahina ng mga pinagmulan ng mga aklat]] na may kabatiran mula sa isang palingkurang pang-web',
	'bookinfo-result-title' => 'Pamagat:',
	'bookinfo-result-author' => 'May-akda:',
	'bookinfo-result-publisher' => 'Tagapaglathala:',
	'bookinfo-result-year' => 'Taon:',
	'bookinfo-error-invalidisbn' => 'Hindi tanggap ang ipinasok na ISBN.',
	'bookinfo-error-nosuchitem' => 'Hindi umiiral ang bagay o hindi matagpuan.',
	'bookinfo-error-nodriver' => 'Hindi masimulan ang isang naangkop na Tagagawa ng Kabatirang Pang-Aklat.',
	'bookinfo-error-noresponse' => 'Walang tugon o namahinga ang hiling.',
	'bookinfo-purchase' => 'Bilhin ang aklat na ito mula sa $1',
	'bookinfo-provider' => 'Tagapagbigay ng dato: $1',
);

/** Turkish (Türkçe)
 * @author Erkan Yilmaz
 * @author Joseph
 * @author Karduelis
 */
$messages['tr'] = array(
	'bookinfo-header' => 'Kitap bilgisi',
	'bookinformation-desc' => '[[Special:Booksources|Kitap kaynakları özel sayfasını]], bir web servisinden bilgilerle genişletir',
	'bookinfo-result-title' => 'Başlık:',
	'bookinfo-result-author' => 'Yazar:',
	'bookinfo-result-publisher' => 'Yayımcı:',
	'bookinfo-result-year' => 'Yıl:',
	'bookinfo-error-invalidisbn' => 'Geçersiz ISBN girildi.',
	'bookinfo-error-nosuchitem' => 'Öğe yok veya bulunamadı.',
	'bookinfo-error-nodriver' => 'Uygun bir Kitap Bilgi Sürücüsü başlatılamıyor.',
	'bookinfo-error-noresponse' => 'Yanıt yok ya da istek zaman aşımına uğradı.',
	'bookinfo-purchase' => 'Bu kitapı buradan satın al: $1',
	'bookinfo-provider' => 'Veri sağlayıcısı: $1',
);

/** Tatar (Cyrillic script) (Татарча)
 * @author Ильнар
 */
$messages['tt-cyrl'] = array(
	'bookinfo-header' => 'Китап турында мәгълүмат',
);

/** Ukrainian (Українська)
 * @author Ahonc
 */
$messages['uk'] = array(
	'bookinfo-header' => 'Інформація про книгу',
	'bookinformation-desc' => 'Розширює [[Special:Booksources|спеціальну сторінку «Джерела книг»]] відомостями з веб-служб',
	'bookinfo-result-title' => 'Назва:',
	'bookinfo-result-author' => 'Автор:',
	'bookinfo-result-publisher' => 'Видавництво:',
	'bookinfo-result-year' => 'Рік:',
	'bookinfo-error-invalidisbn' => 'Уведено помилковий ISBN.',
	'bookinfo-error-nosuchitem' => 'Дані відсутні або їх неможливо знайти.',
	'bookinfo-error-nodriver' => 'Помилка ініціалізації відповідного драйвера інформації про книги.',
	'bookinfo-error-noresponse' => 'Нема відповіді або перевищений час очікування відповіді.',
	'bookinfo-purchase' => 'Купити цю книгу на $1',
	'bookinfo-provider' => 'Постачальник інформації: $1',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'bookinfo-header' => 'Informazion sui libri',
	'bookinformation-desc' => 'Espande la [[Special:Booksources|pàxena speciale par sercar le fonti librarie]] con informazion provenienti da un servizio web',
	'bookinfo-result-title' => 'Titolo:',
	'bookinfo-result-author' => 'Autor:',
	'bookinfo-result-publisher' => 'Editor:',
	'bookinfo-result-year' => 'Ano:',
	'bookinfo-error-invalidisbn' => 'Codice ISBN sbaglià.',
	'bookinfo-error-nosuchitem' => "L'elemento no l'esiste o no s'à podù catarlo.",
	'bookinfo-error-nodriver' => 'Impossibile inizializar un driver coreto par le Informazion sui libri.',
	'bookinfo-error-noresponse' => 'Mancata risposta o risposta assente.',
	'bookinfo-purchase' => 'Cronpa el libro presso: $1',
	'bookinfo-provider' => 'Dati tirà fora da: $1',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'bookinfo-header' => 'Informacii kirjas',
	'bookinfo-result-title' => 'Nimi:',
	'bookinfo-result-author' => 'Avtor:',
	'bookinfo-result-publisher' => 'Pästai:',
	'bookinfo-result-year' => "Pästandan voz':",
	'bookinfo-error-invalidisbn' => 'Nece ISBN om vär.',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'bookinfo-header' => 'Thông tin về sách',
	'bookinformation-desc' => 'Mở rộng [[Special:Booksources|trang đặc biệt về tìm kiếm sách]] để cung cấp thông tin từ một dịch vụ trên web',
	'bookinfo-result-title' => 'Tên:',
	'bookinfo-result-author' => 'Tác giả:',
	'bookinfo-result-publisher' => 'Nhà xuất bản:',
	'bookinfo-result-year' => 'Năm:',
	'bookinfo-error-invalidisbn' => 'Số ISBN không hợp lệ.',
	'bookinfo-error-nosuchitem' => 'Khoản này không tồn tại hay không kiếm được.',
	'bookinfo-error-nodriver' => 'Không có thể khởi chạy chương trình thông tin sách phù hợp.',
	'bookinfo-error-noresponse' => 'Không có trả lời, hay đã chờ trả lời lâu quá.',
	'bookinfo-purchase' => 'Mua sách này từ $1',
	'bookinfo-provider' => 'Dịch vụ cung cấp dữ liệu: $1',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'bookinfo-header' => 'Nüns dö buk',
	'bookinfo-result-title' => 'Tiäd:',
	'bookinfo-result-author' => 'Lautan:',
	'bookinfo-result-publisher' => 'Dabükan:',
	'bookinfo-result-year' => 'Yel:',
	'bookinfo-error-invalidisbn' => 'ISBN no lonöföl.',
	'bookinfo-error-nosuchitem' => 'No dabinon u no petuvon.',
	'bookinfo-error-noresponse' => 'No edabinon geükam, u tim tulunüpik ya epasetikon.',
	'bookinfo-purchase' => 'Remolös buki at se $1',
	'bookinfo-provider' => 'Nüns pesedons se: $1',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'bookinfo-result-title' => 'טיטל:',
);

/** Cantonese (粵語) */
$messages['yue'] = array(
	'bookinfo-header' => '書籍資料',
	'bookinformation-desc' => '擴充[[Special:Booksources]]嘅功能由一個網站服務囉到信息',
	'bookinfo-result-title' => '標題:',
	'bookinfo-result-author' => '作者:',
	'bookinfo-result-publisher' => '出版者:',
	'bookinfo-result-year' => '年份:',
	'bookinfo-error-invalidisbn' => '唔正確嘅 ISBN 輸入。',
	'bookinfo-error-nosuchitem' => '項目唔正確或者搵唔到。',
	'bookinfo-error-nodriver' => '唔能夠初始化一個合適嘅書籍資料驅動器。',
	'bookinfo-error-noresponse' => '無回應或要求過時。',
	'bookinfo-purchase' => '響$1買呢本書',
	'bookinfo-provider' => '資料提供者: $1',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Wmr89502270
 */
$messages['zh-hans'] = array(
	'bookinfo-header' => '书籍资料',
	'bookinformation-desc' => '扩展[[Special:Booksources|{{int:booksources}}]]的功能以们外部网站取得信息',
	'bookinfo-result-title' => '标题：',
	'bookinfo-result-author' => '作者:',
	'bookinfo-result-publisher' => '出版者:',
	'bookinfo-result-year' => '年份:',
	'bookinfo-error-invalidisbn' => '不正确的 ISBN 输入。',
	'bookinfo-error-nosuchitem' => '项目不正确或找不到。',
	'bookinfo-error-nodriver' => '无法初始化一个合适的书籍资料驱动器。',
	'bookinfo-error-noresponse' => '无反应或要求过时。',
	'bookinfo-purchase' => '在$1买这本书',
	'bookinfo-provider' => '资料提供者: $1',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'bookinfo-header' => '書籍資料',
	'bookinformation-desc' => '擴充[[Special:Booksources|{{int:booksources}}]]的功能得以從外部網站取得資訊',
	'bookinfo-result-title' => '標題：',
	'bookinfo-result-author' => '作者:',
	'bookinfo-result-publisher' => '出版者:',
	'bookinfo-result-year' => '年份：',
	'bookinfo-error-invalidisbn' => '不正確的 ISBN 輸入。',
	'bookinfo-error-nosuchitem' => '項目不正確或找不到。',
	'bookinfo-error-nodriver' => '無法初始化一個合適的書籍資料驅動器。',
	'bookinfo-error-noresponse' => '無回應或要求過時。',
	'bookinfo-purchase' => '在$1買這本書',
	'bookinfo-provider' => '資料提供者: $1',
);

/** Chinese (Hong Kong) (‪中文(香港)‬)
 * @author Oapbtommy
 */
$messages['zh-hk'] = array(
	'bookinfo-header' => '書籍資訊',
	'bookinfo-result-title' => '標題：',
	'bookinfo-result-author' => '作者：',
	'bookinfo-result-publisher' => '出版商：',
	'bookinfo-result-year' => '年份：',
	'bookinfo-error-invalidisbn' => '不正確的 ISBN 輸入。',
	'bookinfo-error-noresponse' => '沒有回應或請求逾時。',
	'bookinfo-purchase' => '從 $1 購買這本書',
	'bookinfo-provider' => '資料提供者：$1',
);

