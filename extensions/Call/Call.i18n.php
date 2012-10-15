<?php
/**
 * Internationalization file for Call Extension
 *
 * @addGroup Extension
 */

$messages = array();

$messages['en'] = array(
	'call' => 'Call',
	'call-desc' => 'Create a hyperlink to a template (or to a normal wiki page) with parameter passing.
Can be used at the browser’s command line or within wiki text',
	'call-text' => 'The Call extension expects a wiki page and optional parameters for that page as an argument.<br /><br />

Example 1: &nbsp; <tt>[[{{#special:call}}/My Template,parm1=value1]]</tt><br />
Example 2: &nbsp; <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br />
Example 3: &nbsp; <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br />
Example 4 (Browser URL): &nbsp; <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:My Page,parm1=value1</tt><br /><br />

The <i>Call extension</i> will call the given page and pass the parameters.<br />
You will see the contents of the called page and its title but its \'type\' will be that of a special page, i.e. such a page cannot be edited.<br />The contents you see may vary depending on the value of the parameters you passed.<br /><br />

The <i>Call extension</i> is useful to build interactive applications with MediaWiki.<br />
For an example see <a href=\'http://semeb.com/dpldemo/Template:Catlist\'>the DPL GUI</a> ..<br />
In case of problems you can try <b>{{#special:call}}/DebuG</b>',
	'call-save' => 'The output of this call would be saved to a page called \'\'$1\'\'.',
	'call-save-success' => 'The following text has been saved to page <big>[[$1]]</big> .',
	'call-save-failed' => 'The following text has NOT been saved to page <big>[[$1]]</big> because that page already exists.',
);

/** Message documentation (Message documentation)
 * @author Lloffiwr
 * @author Purodha
 * @author The Evil IP address
 */
$messages['qqq'] = array(
	'call' => 'Title of a special page',
	'call-desc' => '{{desc}}

Parameter passing methods are the ways in which parameters are transferred between functions when one function calls another.',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'call' => 'Roep',
	'call-save' => "Die afvoer van hierdie oproep sou in bladsy ''$1'' gestoor word.",
	'call-save-success' => 'Die volgende teks is in bladsy <big>[[$1]]</big> gestoor.',
	'call-save-failed' => 'Die volgende teks is NIE na bladsy <big>[[$1]]</big> gestoor nie omdat die bladsy reeds bestaan.',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'call' => 'استدعاء',
	'call-desc' => 'ينشئ وصلة فائقة لقالب (أو لصفحة ويكي عادية) مع تمرير المحددات. يمكن استخدامها في سطر أوامر المتصفح أو خلال نص الويكي.',
	'call-text' => "امتداد الاستدعاء يتوقع صفحة ويكي ومحددات اختيارية لهذه الصفحة كمدخلات.<br /><br />

مثال 1: &nbsp; <tt>[[{{#special:call}}/My Template,parm1=value1]]</tt><br />
مثال 2: &nbsp; <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br />
مثال 3: &nbsp; <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br /><br />
مثال 4 (مسار متصفح): &nbsp; <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:My Page,parm1=value1</tt><br /><br />

<i>امتداد الاستدعاء</i> سيستدعي الصفحة المعطاة ويمرر المحددات.<br />سترى محتويات الصفحة المستدعاة وعنوانها ولكن 'نوعها' سيكون ذلك الخاص بصفحة خاصة،<br />أي أن صفحة مثل هذه لا يمكن تعديلها.<br />المحتويات التي تراها ربما تتغير على حسب قيمة المحددات التي مررتها.<br /><br />

<i>امتداد الاستدعاء</i> مفيد في بناء تطبيقات تفاعلية مع الميدياويكي.<br />لمثال انظر <a href='http://semeb.com/dpldemo/Template:Catlist'>DPL GUI</a> ..<br />
في حالة وجود مشكلات يمكنك محاولة <b>{{#special:call}}/DebuG</b>",
	'call-save' => "ناتج هذا الاستدعاء سيتم حفظه في صفحة اسمها ''$1''.",
	'call-save-success' => 'النص التالي تم حفظه لصفحة <big>[[$1]]</big> .',
	'call-save-failed' => 'النص التالي لم يتم حفظه لصفحة <big>[[$1]]</big> لأن هذه الصفحة موجودة بالفعل.',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'call' => 'نادى',
	'call-desc' => 'ينشئ وصلة فائقة لقالب (أو لصفحة ويكى عادية) مع تمرير المحددات. يمكن استخدامها فى سطر أوامر المتصفح أو خلال نص الويكى.',
	'call-text' => "امتداد الاستدعاء يتوقع صفحة ويكى ومحددات اختيارية لهذه الصفحة كمدخلات.<br /><br />
مثال 1: &nbsp; <tt>[[{{#special:call}}/My Template,parm1=value1]]</tt><br />
مثال 2: &nbsp; <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br />
مثال 3: &nbsp; <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br /><br />
مثال 4 (مسار متصفح): &nbsp; <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:My Page,parm1=value1</tt><br /><br />

<i>امتداد الاستدعاء</i> سيستدعى الصفحة المعطاة ويمرر المحددات.<br />سترى محتويات الصفحة المستدعاة وعنوانها ولكن 'نوعها' سيكون ذلك الخاص بصفحة خاصة،<br />أى أن صفحة مثل هذه لا يمكن تعديلها.<br />المحتويات التى تراها ربما تتغير على حسب قيمة المحددات التى مررتها.<br /><br />
<i>امتداد الاستدعاء</i> مفيد فى بناء تطبيقات تفاعلية مع الميدياويكى.<br />لمثال انظر <a href='http://semeb.com/dpldemo/Template:Catlist'>DPL GUI</a> ..<br />
فى حالة وجود مشكلات يمكنك محاولة <b>{{#special:call}}/DebuG</b>",
	'call-save' => "ناتج هذا الاستدعاء سيتم حفظه فى صفحة اسمها ''$1''.",
	'call-save-success' => 'النص التالى تم حفظه لصفحة <big>[[$1]]</big> .',
	'call-save-failed' => 'النص التالى لم يتم حفظه لصفحة <big>[[$1]]</big> لأن هذه الصفحة موجودة بالفعل.',
);

/** Asturian (Asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'call' => 'Llamada',
	'call-desc' => 'Crea un hiperenllaz a una plantía (o páxina wiki normal) pasando parámetros.
Se pue usar na llinia de comandu del restolador o dientro del testu wiki.',
	'call-text' => "La estensión Call espera una páxina wiki y parámetros opcionales pa esa páxina como argumentos.

Exemplu 1: &nbsp; <tt>[[{{#special:call}}/Mio plantía,parám1=valor1]]</tt><br />
Exemplu 2: &nbsp; <tt>[[{{#special:call}}/Talk:Mio alderique,parám1=valor1]]</tt><br />
Exemplu 3: &nbsp; <tt>[[{{#special:call}}/:Mio páxina,parám1=valor1,parám2=valor2]]</tt><br />
Exemplu 4 (URL del restolador): &nbsp; <tt>http://miodominiu/miowiki/index.php?{{#special:call}}/:Mio Páxina,parám1=valor1</tt>

La <i>estensión Call</i> llamará a la páxina dada y pasará-y los parámetros.<br />
Verás el conteníu de la páxina llamada y el so títulu, pero la so \"triba\" será la de páxina especial, esto ye, esa páxina nun se pue editar.<br />El conteníu visible pue variar dependiendo del valor de los parámetros que pases.<br /><br />

La <i>estensión Call</i> ye afayadiza pa construir aplicaciones interactives con MediaWiki.<br />
Pa ver un exemplu, visita <a href='http://semeb.com/dpldemo/Template:Catlist'>la GUI DPL</a>...<br />
En casu d'haber dalgún problema pues probar con <b>{{#special:call}}/DebuG</b>",
	'call-save' => "A salida d'esta llamada se guardaría n'una páxina llamada ''$1''.",
	'call-save-success' => 'El testu darréu se guardó na páxina <big>[[$1]]</big>.',
	'call-save-failed' => 'El testu darréu NUN se guardó na páxina <big>[[$1]]</big> porque la páxina yá esiste.',
);

/** Azerbaijani (Azərbaycanca)
 * @author Vago
 */
$messages['az'] = array(
	'call' => 'Çağırış',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'call' => 'Выклік',
	'call-desc' => 'Стварае гіпэрспасылку на шаблён (альбо звычайную вікі-старонку) з перадачай парамэтраў. Можа выкарыстоўвацца ў камандным радку браўзэра альбо ў вікі-тэксьце',
	'call-text' => "Пашырэньне Call чакае у якасьці аргумэнту, вікі-старонку і неабавязковыя парамэтры.<br /><br />

Прыклад 1: &nbsp; <tt>[[{{#special:call}}/Мой шаблён,parm1=value1]]</tt><br />
Прыклад 2: &nbsp; <tt>[[{{#special:call}}/Абмеркаваньне:Маё абмеркаваньне,parm1=value1]]</tt><br />
Прыклад 3: &nbsp; <tt>[[{{#special:call}}/:Мая старонка,parm1=value1,parm2=value2]]</tt><br />
Прыклад 4 (URL-адрас): &nbsp; <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:My Page,parm1=value1</tt><br /><br />

<i>Пашырэньне Call</i> выклікае пададзеную старонку і перадасьць ёй парамэтры.<br />
Вы ўбачыце зьмест выкліканай старонкі і яе назву, але яе 'тып' будзе тыпам спэцыяльнай старонкі, гэта значыць, што яе нельга будзе рэдагаваць.<br />Зьмест, які Вы бачыце можа зьмяняцца пасьля зьмены парамэтраў.<br /><br />

<i>Пашырэньне Call</i> карыснае для інтэрактыўных праграмаў на базе MediaWiki.<br />
Для прыкладу глядзіце <a href='http://semeb.com/dpldemo/Template:Catlist'>DPL GUI</a> ..<br />
У выпадку ўзьнікненьня праблемаў, Вы можаце паспрабаваць <b>{{#special:call}}/DebuG</b>",
	'call-save' => "Вывад гэтага выкліку будзе захаваны на старонцы ''$1''.",
	'call-save-success' => 'Наступны тэкст быў захаваны на старонцы <big>[[$1]]</big> .',
	'call-save-failed' => 'Наступны тэкст НЯ быў захаваны на старонцы <big>[[$1]]</big>, з-за таго, што гэта старонка ўжо існуе.',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'call' => 'Извикване',
	'call-save-success' => 'Следният текст беше съхранен на страницата <big>[[$1]]</big> .',
	'call-save-failed' => 'Следният текст НЕ БЕШЕ съхранен на страницата <big>[[$1]]</big>, тъй като тя вече съществува.',
);

/** Banjar (Bahasa Banjar)
 * @author Alamnirvana
 * @author Ezagren
 * @author J Subhi
 */
$messages['bjn'] = array(
	'call' => 'Kiauan',
	'call-save' => "Kaluaran gasan kiauan ini pacang disimpan di sabuah tungkaran bangaran ''$1''.",
	'call-save-success' => 'Naskah nang baumpat ini sudah disimpan ka tungkaran <big>[[$1]]</big>.',
	'call-save-failed' => 'Naskah nang baumpat ini BALUM disimpan ka tungkaran <big>[[$1]]</big>  karana tungkaran itu sudah ada.',
);

/** Bengali (বাংলা)
 * @author Zaheen
 */
$messages['bn'] = array(
	'call' => 'কল',
	'call-desc' => 'প্যারামিটার পাস করে কোন টেম্পলেটের (বা সাধারণ উইকি পাতার) দিকে একটি সংযোগ সৃষ্টি করুন। ব্রাউজারের কমান্ড লাইনে কিংবা উইকি টেক্সটের ভেতরে ব্যবহার করা যাবে।',
	'call-text' => "কল এক্সটেনশনটি আর্গুমেন্ট হিসেবে কোন উইকি পাতা এবং সেই পাতার জন্য ঐচ্ছিক প্যারামিটারসমূহ প্রত্যাশা করে।<br /><br />
উদাহরণ ১: &nbsp; <tt>[[{{#special:call}}/My Template,parm1=value1]]</tt><br />
উদাহরণ ২: &nbsp; <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br />
উদাহরণ ৩: &nbsp; <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br /><br />
উদাহরণ ৪ (ব্রাউজার URL): &nbsp; <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:My Page,parm1=value1</tt><br /><br />

<i>কল এক্সটেনশন</i> প্রদত্ত পাতাটিকে কল করবে এবং প্যারামিটার সরবরাহ করবে।<br />আপনি কল করা পাতা ও তার শিরোনাম দেখতে পাবেন কিন্তু পাতাটির 'টাইপ' হবে বিশেষ পাতার টাইপ,<br />অর্থাৎ এই পাতাটি সম্পাদনা করা যাবে না।<br />আপনি কী বিষয়বস্তু দেখতে পাবেন তা নির্ভর করবে আপনার সরবরাহকৃত প্যারামিটারের মানগুলির উপর।<br /><br />
<i>কল এক্সটেনশন</i> মিডিয়াউইকির সাথে মিথস্ক্রিয়াশীল অ্যাপ্লিকেশন তৈরিতে কাজে লাগতে পারে। <br />উদাহরণের জন্য দেখুন <a href='http://semeb.com/dpldemo/Template:Catlist'>ডিপিএল গুই</a> ..<br />
কোন সমস্যা হলে আপনি <b>{{#special:call}}/DebuG</b> ব্যবহার করতে পারেন",
	'call-save' => "এই কলটির আউটপুট ''$1'' নামের পাতায় সংরক্ষণ করা হবে।",
	'call-save-success' => '<big>[[$1]]</big> পাতায় নিচের টেক্সট সংরক্ষণ করা হয়েছে।',
	'call-save-failed' => '<big>[[$1]]</big> পাতায় নিচের টেক্সট সংরক্ষণ করা হয়নি, কারণ পাতাটি ইতিমধ্যেই বিদ্যমান।',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'call' => 'Galv',
	'call-desc' => 'Krouiñ a ra ur gourliamm davet ur patrom (pe ur pennad wiki boutin) en ur dremen arventennoù drezañ. Gallout a ra bezañ implijet evel linenn urzhiad adal ur merdeer pe e testenn ur wiki.',
	'call-text' => "Ezhomm en deus an astenn galv eus ur bajenn wiki hag eus an arventennoù diret eviti.<br /><br />
Skouer 1: &nbsp; <tt>[[{{#special:call}}/Ma fatrom,parm1=value1]]</tt><br />
Skouer 2: &nbsp; <tt>[[{{#special:call}}/Kaozeal:Ma c'haozeadennoù,parm1=value1]]</tt><br />
Skouer 3: &nbsp; <tt>[[{{#special:call}}/:Ma fajenn,parm1=value1,parm2=value2]]</tt><br /><br />
Skouer 4 (chomlec'h evit merdeer): &nbsp; <tt>http://madomani/mywiki/index.php?{{#special:call}}/:Ma fajenn,parm1=value1</tt><br /><br />

Gervel a raio an astenn <i>Galv</i> ar bajenn merket en ur dremen an arventennoù drezi.<br />Gwelout a reot danvez ar bajenn hag an titl anezhi met 'tres' ur bajenn dibar a vo warni<br />ha n'hallo ket kemmoù bezañ degaset enni.<br />An titouroù a vo warni a vo diouzh talvoud an arventennoù bet merket ganeoc'h.<br /><br />
Emsav-kenañ eo an <i>Astenn Galv</i> evit sevel arloadoù etregwezhiat gant MediaWiki.<br />Da skouer, gwelet <a href='http://semeb.com/dpldemo/Template:Catlist'>the DPL GUI</a> ..<br />
M'ho pez kudennoù e c'hallit klask ober gant <b>{{#special:call}}/DebuG</b>",
	'call-save' => "Gallout a rafe ar pezh zo merket gant ar galv-mañ bezañ enrollet en ur bajenn anvet ''$1''.",
	'call-save-success' => 'Enrollet eo bet an destenn da-heul war ar bajenn <big>[[$1]]</big> .',
	'call-save-failed' => "N'EO KET BET enrollet an destenn da-heul war ar bajenn <big>[[$1]]</big> rak bez'ez eus anezhi c'hoazh.",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'call' => 'Poziv',
	'call-desc' => 'Pravi hiperlink prema šablonu (ili običnoj wiki stranici) sa datim parametrima.
Može se koristiti i putem komandne linije preglednika ili unutar wiki teksta.',
	'call-text' => "Proširenje poziva očekuje wiki stranicu i moguće parametre za tu stranicu kao arugumente.<br /><br />

Primjer 1: &nbsp; <tt>[[{{#special:call}}/My Template,parm1=value1]]</tt><br />
Primjer 2: &nbsp; <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br />
Primjer 3: &nbsp; <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br />
Primjer 4 (URL preglednika): &nbsp; <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:My Page,parm1=value1</tt><br /><br />

<i>Proširenje poziva</i> će pozvati navedenu stranicu i unijeti parametre.<br />
Vi ćete vidjeti sadržaj pozvane stranice i njen naslov ali njen 'tip' će biti kao da je specijalna stranica tj. takva stranica se ne može uređivati.<br />Sadržaji koji su prikazani mogu biti različiti u zavisnosti od vrijednosti parametara koje ste naveli.<br /><br />

<i>Proširenje poziva</i> je korisno za pravljenje interaktivnih aplikacija sa MediaWiki.<br />Za primjer pogledajte na <a href='http://semeb.com/dpldemo/Template:Catlist'>DPL GUI</a> ..<br />
U slučaju problema možete pokušati <b>{{#special:call}}/DebuG</b>",
	'call-save' => "Izlaz ovog poziva će biti spremljen na stranicu ''$1''.",
	'call-save-success' => 'Slijedeći tekst je spremljen na stranicu <big>[[$1]]</big> .',
	'call-save-failed' => 'Slijedeći tekst NEĆE biti spremljen na stranicu <big>[[$1]]</big> jer ova stranica već postoji.',
);

/** Catalan (Català)
 * @author BroOk
 * @author El libre
 * @author Paucabot
 */
$messages['ca'] = array(
	'call' => 'Crida',
	'call-desc' => "Crear un hipervincle a una plantilla (o en una pàgina wiki normal), amb el pas de paràmetres.
Pot ser utilitzat en la línia d'ordres del navegador o en el text wiki",
	'call-text' => "L'extensió Call espera una pàgina wiki i els paràmetres opcionals per a aquella pàgina com a argument.<br /><br />

Exemple 1: &nbsp; <tt>[[{{#special:call}}/My Template,parm1=value1]]</tt><br />
Exemple 2: &nbsp; <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br />
Exemple 3: &nbsp; <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br />
Exemple 4 (URL del navegador): &nbsp; <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:My Page,parm1=value1</tt><br /><br />

L'<i>extensió Call</i> truca a la pàgina i passar els paràmetres.br />
Podràs veure el contingut de la pàgina anomenat i el seu títol, però el seu \"tipus\" serà d'una pàgina especial, és a dir, com una pàgina no es pot editar.<br />El contingut que veus poden variar segons el valor dels paràmetres que ha passat.<br /><br />

L'<i>extensió Call</i> és útil per a construir aplicacions interactives amb MediaWiki.<br />
Per exemple, veure <a href='http://semeb.com/dpldemo/Template:Catlist'>the DPL GUI</a> ..<br />
En cas de problemes pot provar <b>{{#special:call}}/DebuG</b>",
	'call-save' => "La sortida d'aquesta Call es pot guardar en una pàgina anomenada'' $1 ''.",
	'call-save-success' => 'El següent text ha estat desat a la pàgina <big>[[$1]]</big> .',
	'call-save-failed' => "El següent text no s'ha desat a la pàgina <big>[[ $1 ]]</big> ja que aquesta pàgina ja existeix.",
);

/** Czech (Česky)
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'call' => 'Call',
	'call-desc' => 'Vytvoří hyperodkaz na šablonu (nebo na běžnou wiki stránku) s odevzdáním parametrů. Je možné použít z řádku s adresou v prohlížečí nebo ve wiki textu.',
	'call-text' => "Doplněk Call očekává jako argumenty wiki stránku a volitelné parametry dané stránky.<br /><br />
Příklad 1: &nbsp; <tt>[[{{#special:call}}/Moje šablona,parm1=value1]]</tt><br />
Příklad 2: &nbsp; <tt>[[{{#special:call}}/Diskuse:Moje diskuse,parm1=value1]]</tt><br />
Příklad 3: &nbsp; <tt>[[{{#special:call}}/:Moje stránka,parm1=value1,parm2=value2]]</tt><br /><br />
Příklad 4 (URL prohlížeče): &nbsp; <tt>http://mojedomena/mojewiki/index.php?{{#special:call}}/:Moje stránka,parm1=value1</tt><br /><br />

<i>Doplněk Call</i> zavolá danbou stránku a odevzdá jí parametry.<br />
Uvidíte obsah zavolané stránky a její název, ale její 'typ' bude speciální stránka,<br />tj. takovou stránku není možné uprovat.<br />
Obsah, který uvidíte se může lišit v závislosti na parametrech, které jste odevzdali.<br /><br />
<i>Doplněk Call</i> je užitečný při budovaní interaktivních aplikací pomocí MediaWiki.<br />
Jako příklad se můžete podívat na <a href='http://semeb.com/dpldemo/Template:Catlist'>GUI DPL</a> ..<br />
V případě problémů můžete zkusit <b>{{#special:call}}/DebuG</b>",
	'call-save' => "Výstup této stránky byl uložen do stránky s názvem ''$1''.",
	'call-save-success' => 'Následující text byl uložený do stránky <big>[[$1]]</big>',
	'call-save-failed' => "Následující text NEBYL uložený do stránky ''$1'', protože tato stránka už existuje.",
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 * @author Xxglennxx
 */
$messages['cy'] = array(
	'call' => 'Galw',
	'call-desc' => "Creu hypergyswllt i nodyn (neu dudalen wici normal) sy'n pasio paramedrau.
Gellir ei ddefnyddio ar linell gorchymyn y porydd neu o fewn testun wici.",
	'call-text' => "Mae'r estyniad Galw yn disgwyl tudalen wici a pharamedrau dewisol ar gyfer y dudalen honno fel arg.<br /><br />

Enghraifft 1: &nbsp; <tt>[[{{#special:call}}/My Template,parm1=value1]]</tt><br />
Enghraifft 2: &nbsp; <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br />
Enghraifft 3: &nbsp; <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br />
Enghraifft 4 (URL y Porydd): &nbsp; <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:My Page,parm1=value1</tt><br /><br />

Bydd yr <i>estyniad Galw</i> yn galw'r dudalen dan sylw ac yn pasio'r paramedrau .<br />
Byddwch yn gweld cynnwys y dudalen a alwyd a'i theitl ond ar ffurf tudalen arbennig, h.y., ni ellid golygu'r fath dudalen.<br />Bydd y cynnwys yn amrywio yn ôl gwerthoedd y paramedrau a chawsant eu pasio gennych.<br /><br />

Mae'r <i>estyniad Galw</i> yn ddefnyddiol wrth adeiladu rhaglenni rhyngweithiol gyda MediaWiki.<br />
Am enghraifft, gweler <a href='http://semeb.com/dpldemo/Template:Catlist'>y rhyngwyneb defnyddio graffigol DPL</a> ..<br />
Os oes problemau, rhowch gynnig ar <b>{{#special:call}}/DebuG</b>",
	'call-save' => "Cedwir allbwn o'r galwad hon mewn tudalen o'r enw ''$1''.",
	'call-save-success' => 'Rhoddwyd y testun yma ar gadw yn y dudalen <big>[[$1]]</big>.',
	'call-save-failed' => "NI roddwyd y testun yma i gadw ar y dudalen <big>[[$1]]</big> am fod y dudalen yn bodoli'n barod.",
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author Umherirrender
 */
$messages['de'] = array(
	'call' => 'Parameteraufruf',
	'call-desc' => 'Erstellt einen Hyperlink zu einer Vorlage (oder zu einer normalen Seite) mit Parameterübergabe.
Kann in der Eingabeaufforderung des Browser oder im Wiki-Text verwendet werden.',
	'call-text' => "Die Parameteraufruf-Erweiterung erwartet eine Wiki-Seite und optionale Parameter für diese Seite als Argument.

Beispiel 1: &nbsp; <tt>[[{{#special:call}}/Meine Vorlage,parm1=wert1]]</tt><br />
Beispiel 2: &nbsp; <tt>[[{{#special:call}}/Diskussion:Meine Diskussion,parm1=wert1]]</tt><br />
Beispiel 3: &nbsp; <tt>[[{{#special:call}}/:Meine Seite,parm1=wert1,parm2=wert2]]</tt><br />
Beispiel 4 (URL im Browser): &nbsp; <tt>http://meinedomain/meinwiki/index.php?{{#special:call}}/:Meine Seite,parm1=wert1</tt>

Die <i>Parameteraufruf-Erweiterung</i> wird die angegebene Seite aufrufen und die Parameter übergeben.<br />
Es werden der Inhalt und der Titel der aufgerufenen Seite angezeigt, aber der Seitentyp wird der einer Spezialseite sein, daher kann so eine Seite z.B. nicht bearbeitet werden.<br />Der angezeigte Inhalt kann unterschiedlich sein, abhängig von den übergebenen Parameterwerten.

Die <i>Parameteraufruf-Erweiterung</i> ist praktisch, um interaktive Anwendungen mit MediaWiki zu erstellen.<br />
Ein Beispiel hierfür ist die <a href='http://semeb.com/dpldemo/Template:Catlist'>DPL GUI</a> ..<br />
Für Probleme gibt es <b>{{#special:call}}/DebuG</b>",
	'call-save' => "Die Ausgabe dieses Aufrufs würde als Seite ''$1'' gespeichert werden.",
	'call-save-success' => 'Der folgende Text wurde auf Seite <big>[[$1]]</big> gespeichert.',
	'call-save-failed' => 'Der folgende Text wurde NICHT auf Seite <big>[[$1]]</big> gespeichert, weil diese Seite bereits existiert.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'call' => 'Zawołanje',
	'call-desc' => 'Wótkaz k pśedloze (abo k normalnemu wikjowemu bokoju) z pśepódaśim parametra napóraś.
Dajo se na pśikazowej smužce wobglědowaka abo we wikijowem teksće wužywaś.',
	'call-text' => "Rozšyrjenje Call wótcakujo wikijowy bok a opcionalne parametry za toś ten bok ako argument.

Pśikład 1: &nbsp; <tt>[[Special:Call/My Template,parm1=value1]]</tt><br />
Pśikład 2: &nbsp; <tt>[[Special:Call/Talk:My Discussion,parm1=value1]]</tt><br />
Pśikład 3: &nbsp; <tt>[[Special:Call/:My Page,parm1=value1,parm2=value2]]</tt><br />
Pśikład 4: (URL we wobglědowaku): &nbsp; <tt>http://mydomain/mywiki/index.php?Special:Call/:My_Page,parm1=value1</tt>

<i>Rozšyrjenje Call</i> wuwołajo dany bok a pśepódajo parametry.<br />
Buźoš wiźeś wopśimjeśe wuwołanego boka a jogo titel, ale jogo 'typ' buźo ten wot specialnego boka, to groni, až taki bok njedajo se wobźěłaś.<br />Wopśimjeśe, kótarež wiźiš, móžo wariěrowaś, we wótwisnosći wót gódnoty parametrow, kótarež sy pśepódał.

<i>Rozšyrjenje Call</i> jo wužytne, aby twóriło interaktiwne aplikacije z MediaWiki.<br />
Glědaj na pśikład <a href='http://semeb.com/dpldemo/Template:Catlist'>DPL GUI</a> ..<br />
W paźe problemow, móžoš wopytaś <b>Special:Call/DebuG</b>",
	'call-save' => "Wudaśe toś togo zawołanja by se do boka z mjenim ''$1'' składowało.",
	'call-save-success' => 'Slědujucy tekst jo se do boka <big>[[$1]]</big> składował.',
	'call-save-failed' => 'Slědujucy tekst NJEjo se do boka <big>[[$1]]</big> składł, dokulaž ten bok južo eksistěrujo.',
);

/** Greek (Ελληνικά)
 * @author Omnipaedista
 */
$messages['el'] = array(
	'call' => 'Κλήση',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'call' => 'Voki',
	'call-save' => "La eligo de ĉi tiu voko estus konservita al paĝo nomata ''$1''.",
	'call-save-success' => 'La jena teksto estis konservita al paĝo <big>[[$1]]</big> .',
	'call-save-failed' => 'La jena teksto NE estis konservita al paĝo <big>[[$1]]</big> ĉar tiu paĝo jam ekzistas.',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Drini
 */
$messages['es'] = array(
	'call' => 'Llamar',
	'call-desc' => 'Crea un enlace a una plantilla (o página wiki normal) pasando parámetros.
Puede usarse en la línea de comandos del navegador o dentro de wikitexto.',
	'call-text' => 'La extensión Call recibe una página wiki y parámetros opcionales para esa página como argumentos.

Ejemplo 1: &nbsp; <tt>[[{{#special:call}}/My Template,parm1=value1]]</tt><br />
Ejemplo 2: &nbsp; <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br />
Ejemplo 3: &nbsp; <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br />
Ejemplo 4 (Browser URL): &nbsp; <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:My Page,parm1=value1</tt>

La <i>extensión Call</i> llamará a la paǵina indicada y pasará los parámetros.<br />
Verás los contenidos de la página llamada y su título, pero su "tipo" será el de una página especial (esto es, no podrá ser editada)<br />Los contenidos que veas dependerán del valor de los parámetros indicados.

La <i>extensión Call</i> es útil para construir aplicaciones interactivas con MediaWiki.<br />
Por ejemplo: <a href=\'http://semeb.com/dpldemo/Template:Catlist\'>la interfaz DPL</a> ..<br />
En caso de problemas, puedes invocar <b>{{#special:call}}/DebuG</b>',
	'call-save' => "El resultado de esta llamada se guardará en una página llamada ''$1''.",
	'call-save-success' => 'El siguiente texto ha sido grabado a la página <big>[[$1]]</big> .',
	'call-save-failed' => 'El siguiente texto NO ha sido grabado a la página <big>[[$1]]</big> porque esa página ya existe.',
);

/** Basque (Euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'call' => 'Deia',
	'call-save-success' => 'Ondorengo testua gorde egin da <big>[[$1]]</big> orrialdera.',
);

/** Persian (فارسی)
 * @author Ebraminio
 */
$messages['fa'] = array(
	'call' => 'تماس',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Ilaiho
 */
$messages['fi'] = array(
	'call' => 'Mallinekutsu',
	'call-desc' => 'Luo hyperlinkki mallineeseen (tai tavalliseen sivuun) siten, että parametrit välittyvät.
Voidaan käyttää selaimen osoiterivillä tai wikitekstin joukossa.',
	'call-text' => "Mallinekutsulaajennus hyväksyy syötteeksi wikisivun ja mahdolliset parametrit.

Esimerkki 1: &nbsp; <tt>[[{{#special:call}}/Esimerkkimalline,parm1=arvo1]]</tt><br />
Esimerkki 2: &nbsp; <tt>[[{{#special:call}}/Keskustelu:Esimerkkikeskustelusivu,parm1=arvo1]]</tt><br />
Esimerkki 3: &nbsp; <tt>[[{{#special:call}}/:My Page,parm1=arvo1,parm2=arvo2]]</tt><br />
Esimerkki 4 (selaimen URL): &nbsp; <tt>http://omadomain/wiki/index.php?{{#special:call}}/:Esimerkkisivu,parm1=arvo1</tt>

''Mallinekutsulaajennus'' kutsuu annettua sivua ja välittää parametrit.<br />
Ruudulle tulostuu kutsutun sivun otsikko ja sisältö, mutta sen tyyppi on toimintosivu, eli sitä ei voi muokata.<br />Tulostuva sisältö saattaa muuttua parametrien mukaan.

''Mallinekutsulaajennus'' soveltuu interaktiivisten toimintojen rakentamiseen MediaWiki-ohjelmiston avulla.<br />
Sillä on toteutettu esimerkiksi <a href='http://semeb.com/dpldemo/Template:Catlist'>DPL:n graafinen käyttöliittymä</a> ..<br /> <br />
Ongelmien ratkaisuun voit kokeilla sivua <b>{{#special:call}}/DebuG</b>",
	'call-save' => "Tämän mallinekutsun tuloste tallennettaisiin sivulle ''$1''.",
	'call-save-success' => 'Tämä teksti on tallennettu sivulle <big>[[$1]]</big> .',
	'call-save-failed' => 'Seuraavaa tekstiä EI tallennettu sivulle <big>[[$1]]</big>, sillä sivu on jo olemassa.',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author IAlex
 * @author Urhixidur
 * @author Verdy p
 */
$messages['fr'] = array(
	'call' => 'Appel',
	'call-desc' => 'Crée un lien hypertexte permettant d’afficher l’expansion d’un modèle (ou d’une page wiki normale) tout en lui passant des paramètres.
Ce lien peut être utilisé en ligne de commande depuis un navigateur ou dans un texte wiki.',
	'call-text' => 'L’extension Appel a besoin d’une page wiki et des paramètres facultatifs pour cette dernière comme argument.<br /><br />

Exemple 1 : &nbsp; <tt>[[{{#special:call}}/Mon modèle,param1=valeur1]]</tt><br />
Exemple 2 : &nbsp; <tt>[[{{#special:call}}/Discussion:Ma discussion,param1=valeur1]]</tt><br />
Exemple 3 : &nbsp; <tt>[[{{#special:call}}/:Ma page,param1=valeur1,param2=valeur2]]</tt><br />
Exemple 4 (adresse pour navigateur) : &nbsp; <tt>http://mondomaine/monwiki/index.php?{{#special:call}}/:Ma_Page,param1=value1</tt>

L’extension <i>Appel</i> appellera la page indiquée tout en lui passant les paramètres.<br />
Vous verrez les informations de cette page, son titre, mais son « type » sera celui d’une page spéciale qui ne pourra pas être éditée.<br />Les informations que vous verrez varieront en fonction des paramètres que vous avez passés.

Cette <i>extension</i> est très pratique pour créer des applications interactives avec MediaWiki.<br />
À titre d’exemple, voyez [http://semeb.com/dpldemo/Template:Catlist l’interface DPL]...<br />
En cas de problèmes, vous pouvez essayer <b>{{#special:call}}/DebuG</b>',
	'call-save' => "Le résultat de cet appel pourrait être publié dans une page appelée ''$1''.",
	'call-save-success' => 'Le texte suivant a été publié vers la page <big>[[$1]]</big>.',
	'call-save-failed' => 'Le texte suivant n’a pu être publié vers la page <big>[[$1]]</big> car cette page existe déjà.',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'call' => 'Apèl',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'call' => 'Chamada',
	'call-desc' => 'Crear unha ligazón cara a un modelo (ou cara a unha páxina normal dun wiki) con pasaxe de parámetros.
Pode ser usado na liña de comandos do navegador ou dentro do texto dun wiki.',
	'call-text' => "A extensión Call agarda unha páxina dun wiki e parámetros opcionais para esa páxina como argumentos.

Exemplo 1: &nbsp; <tt>[[{{#special:call}}/My Template,parm1=value1]]</tt><br />
Exemplo 2: &nbsp; <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br />
Exemplo 3: &nbsp; <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br />
Exemplo 4 (URL do navegador): &nbsp; <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:My Page,parm1=value1</tt>

A <i>extensión Call</i> chamará á páxina dada e pasaralle os parámetros.<br />
Poderá ver os contidos da páxina chamada e o seu título, pero o seu 'tipo' será o dunha páxina especial, isto é, a devandita páxina non poderá ser editada.<br />Os contidos que ve poden variar dependendo do valor dos parámetros que pasou.

A <i>extensión Call</i> é útil para construír aplicacións interactivas con MediaWiki.<br />
Para ver un exemplo, visite <a href='http://semeb.com/dpldemo/Template:Catlist'>o DPL GUI</a>...<br />
En caso de que haxa algún problema pode probar con <b>{{#special:call}}/DebuG</b>",
	'call-save' => "A saída desta chamada gardaríase nunha páxina chamada ''$1''.",
	'call-save-success' => 'O texto seguinte gardouse na páxina <big>[[$1]]</big>.',
	'call-save-failed' => 'O texto seguinte NON se gardou na páxina <big>[[$1]]</big> porque xa existe esa páxina.',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'call' => 'Καλεῖν',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'call' => 'Parameterufruef',
	'call-desc' => 'Leit e Hypergleich aa zuen ere Vorlag (oder zuen ere normale Syte) mit Parameteribergab.
Cha in dr Yygabufforderig vum Browser oder im Wiki-Täxt bruucht wäre.',
	'call-text' => "D Parameterufruef-Erwyterig bruucht e Wiki-Syte un optionali Parameter fir die Syte as Argumänt.

Byyspil 1: &nbsp; <tt>[[{{#special:call}}/My Template,parm1=value1]]</tt><br />
Byyspil 2: &nbsp; <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br />
Byyspil 3: &nbsp; <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br />
Byyspil 4:(Browser URL): &nbsp; <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:My Page,parm1=value1</tt>

D <i>Parameterufruef-Erwyterig</i> rieft die Syte uf, wu aagee isch, un ibergit d Parameter.<br />
Dr Inhalt un dr Titel vu dr ufgruefene Syte wäre aazeigt, aber dr Sytetyp isch dää vun ere Spezialsyte, wäge däm cha eso ne Syte z. B. bearbeitet wäre.<br />Dr aazeigt Inhalt cha unterschidlig syy, abhängig vu dr Parameterwärt, wu ibergee wäre.

D <i>Parameterufruef-Erwyterig</i> isch praktisch go interaktivi Aawändige mit MediaWiki aazlege.<br />
E Byyspil dodefir isch d <a href='http://semeb.com/dpldemo/Template:Catlist'>DPL GUI</a> ..<br />
Fir Probläm git s <b>{{#special:call}}:Call/DebuG</b>",
	'call-save' => "D Uusgab vu däm Ufruef tet as Syte ''$1'' gspycheret wäre.",
	'call-save-success' => 'Dää Täxt isch uf dr Syte <big>[[$1]]</big> gspycheret wore.',
	'call-save-failed' => 'Dää Täxt ischt NIT uf dr Syte <big>[[$1]]</big> gspycheret wore, wel s die Syte scho git.',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'call' => 'קריאה',
	'call-desc' => 'יצירת קישור לתבנית (או לדף ויקי רגיל) עם העברת משתנים.
ניתן לשימוש בשורת הפקודה של הדפדפן או כטקסט בוויקי.',
	'call-text' => 'הרחבת הקריאה מקבלת דף ויקי ופרמטרים אופציונליים לדף זה כארגומנט.<br /><br />

דוגמה 1: &nbsp; <tt>[[{{#special:call}}/My Template,parm1=value1]]</tt><br />
דוגמה 2: &nbsp; <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br />
דוגמה 3: &nbsp; <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br />
דוגמה 4 (כתובת URL בדפדפן): &nbsp; <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:My Page,parm1=value1</tt><br /><br />

<b>הרחבת הקריאה</b> תקרא לדף שניתן לה ותעביר לו את הפרמטרים.<br />
תוכלו לראות את התכנים של הדף הנקרא ואת הכותרת שלו, אבל ה"סוג" שלו יהיה כזה של דף מיוחד, כלומר, דף שאין אפשרות לערוך אותו.<br />
תוכן הדף עשוי להשתנות כתלות בערכי הפרמטרים שהעברתם.<br /><br />

<b>הרחבת הקריאה</b> היא שימושית לבניית יישומים אינטראקטיביים באמצעות מדיה־ויקי.<br />
לדוגמה, ראו את <a href=\'http://semeb.com/dpldemo/Template:Catlist\'>הממשק הגרפי ל־DPL</a> ..<br />
אם מתעוררות בעיות, באפשרותכם לנסות את <b>{{#special:call}}/DebuG</b>',
	'call-save' => "פלט הקריאה יישמר לדף בשם '''$1'''.",
	'call-save-success' => 'הטקסט הבא נשמר לדף <big>[[$1]]</big> .',
	'call-save-failed' => 'הטקסט הבא <b>לא</b> נשמר לדף <big>[[$1]]</big> כיוון שהוא כבר קיים.',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'call' => 'कॉल',
	'call-desc' => 'एक टेम्प्लेटसे (या साधारण विकिपन्ने से) जुडने वाली और कुछ पॅरॅमीटरके मिलने के बाद ही इस्तेमाल में आने वाली कड़ी बनायें।
यह कड़ी ब्राउज़रके कमांड लाईनमें अथवा विकिसंज्ञाओं द्वारा इस्तेमाल की जा सकती हैं।',
	'call-text' => "कॉल एक्स्टेंशन के लिये एक विकि पृष्ठ और उसके अन्य पॅरॅमीटर अर्ग्युमेंटमें दिये हुए होने आवश्यक हैं।<br /><br />
उदाहरण १: &nbsp; <tt>[[{{#special:call}}/My Template,parm1=value1]]</tt><br />
उदाहरण २: &nbsp; <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br />
उदाहरण ३: &nbsp; <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br /><br />
उदाहरण ४ (ब्राउझर URL): &nbsp; <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:My Page,parm1=value1</tt><br /><br />

<i>कॉल क्रिया</i> उस विशिष्ट पृष्ठ को मंगाकर दिये हुए पॅरॅमीटर्स जाँच लेगी।<br />आप उस पन्नेका शीर्षक तथा पाठ देख सकतें हैं पर उसका 'प्रकार' विशेष पॄष्ठ ही रहेगा,<br />मतलब उसे आप बदल नहीं सकतें हैं।<br />आपको दिखने वाला पाठ जितने पॅरॅमीटर्स मिलेंगे उसके हिसाब से बदल सकता हैं।<br /><br />
<i>कॉल क्रिया</i> यह मीडियाविकीको संलग्न ऍप्लीकेशन लिखनेके लिये उपयुक्त हैं।<br />उदाहरणके लिये देखें <a href='http://semeb.com/dpldemo/Template:Catlist'>डीपीएल जीयूआय</a> ..<br />
कोई भी समस्या आने पर आप <b>{{#special:call}}/DebuG</b> का इस्तेमाल करके देख सकतें हैं।",
	'call-save' => "इस कॉलका आउटपुट ''$1'' नाम के पन्नेपर दर्ज किया जायेगा।",
	'call-save-success' => 'नीचे दिया हुआ पाठ <big>[[$1]]</big> नामके पन्नेपर दर्ज किया गया हैं।',
	'call-save-failed' => 'नीचे का पाठ <big>[[$1]]</big> इस पन्ने पर संजोया नहीं गया हैं, क्योंकि यह पन्ना पहले से अस्तित्वमें हैं।',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'call' => 'Namołwa',
	'call-desc' => 'Wotkaz k předłoze (abo k normalnej wikijowej stronje) z přepodaću parametrow wutworić. Da so w přikazowej lince wobhladowaka abo znutřka wikijoweho teksta wužiwać.',
	'call-text' => "Rozšěrjenja Call wočakuje wiki-stronu a opcionalne parametry za tutu stronu jako argument.<br /><br />

Přikład 1: &nbsp; <tt>[[Special:Call/My Template,parm1=value1]]</tt><br />
Přikład 2: &nbsp; <tt>[[Special:Call/Talk:My Discussion,parm1=value1]]</tt><br />
Přikład 3: &nbsp; <tt>[[Special:Call/:My Page,parm1=value1,parm2=value2]]</tt><br />
Přikład 4 (URL wobhladowaka): &nbsp; <tt>http://mydomain/mywiki/index.php?Special:Call/:My Page,parm1=value1</tt><br /><br />

<i>Rozšěrjenje Call</i> budźe datu stronu wołać a parametry přepodawać.<br />Budźeš wobsah zwołaneje strony a jeje titul widźeć, ale jeje 'typ' budźe tón specialneje strony, t.r. tajka strona njeda so wobdźěłować.<br />Wobsah, kotryž widźiš, móže, wotwisujo wot hódnoty parametrow, kotruž sy přepodał, wariěrować.<br /><br />

<i>Rozšěrjenje Call</i> je wužitne, zo bychu so interaktiwne aplikacije z MediaWiki tworili.<br /> Za přikład hlej <a href='http://semeb.com/dpldemo/Template:Catlist'>DPL GUI</a> ..<br /> W padźe problemow móžeš <b>Special:Call/DebuG</b> spytać.",
	'call-save' => "Wudaće tutoho zwołanja by so na stronu z mjenom ''$1'' składowało.",
	'call-save-success' => 'Slědowacy tekst bu na stronu <big>[[$1]]</big> składował.',
	'call-save-failed' => 'Slědowacy tekst NJEje so na stronu <big>[[$1]]</big> składował, dokelž ta strona hižo eksistuje.',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'call' => 'Hívás',
	'call-desc' => 'Lehetővé teszi sablon (vagy egy normális wiki lap) meghívását paraméterátadással.
Használható a böngésző címsorából, vagy a wikiszövegben is.',
	'call-text' => "A kiegészítőnek meg kell adni egy wiki oldalt és kiegészítő paramétereket ahhoz az oldalhoz.<br /><br />
1. példa: &nbsp; <tt>[[{{#special:call}}/Sablon neve,parm1=érték1]]</tt><br />
2. példa: &nbsp; <tt>[[{{#special:call}}/Vita:Vitalapom,parm1=érték1]]</tt><br />
3. példa: &nbsp; <tt>[[{{#special:call}}/:Az én lapom,parm1=érték1,parm2=érték2]]</tt><br /><br />
4. példa (URL a böngészőben): &nbsp; <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:Az én lapom,parm1=érték1</tt><br /><br />

A kiegészítő meghívja az adott oldalt, és átadja neki a megadott paramétereket.<br />Láthatod a lap tartalmát, és a címét is, de a 'típusa' speciális lap lesz,<br />amit nem lehet szerkeszteni.<br />A lap tartalma változhat az általad megadott paraméterektől függően.<br /><br />
Hasznos lehet interaktív alkalmazások építésére a MediaWikivel.<br />Példának lásd <a href='http://semeb.com/dpldemo/Template:Catlist'>a DPL GUI</a>-t.<br />
Probléma esetén megpróbálhatod a <b>{{#special:call}}/DebuG</b> használatát",
	'call-save' => "A hívás kimenetét el lehet menteni egy ''$1'' nevű lapra.",
	'call-save-success' => 'A következő szöveg el lett mentve <big>[[$1]]</big> néven.',
	'call-save-failed' => 'A következő szöveg NEM lett elmentve, mert már létezik <big>[[$1]]</big> nevű lap.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'call' => 'Appello',
	'call-desc' => 'Crea un ligamine verso un patrono (o verso un pagina wiki normal) con parametros a passar.
Pote esser usate in le linea de commandos del navigator o in texto wiki.',
	'call-text' => "Le extension Appello expecta un pagina wiki al qual pote eser passate parametros.

Exemplo 1: &nbsp; <tt>[[{{#special:call}}/My Template,parm1=value1]]</tt><br />
Exemplo 2: &nbsp; <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br />
Exemplo 3: &nbsp; <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br />
Exemplo 4 (adresse URL): &nbsp; <tt>http://midominio/miwiki/index.php?{{#special:call}}/:Mi_pagina,parm1=valor1</tt>

Le <i>extension Appello</i> appellara le pagina date e passara le parametros.<br />
Tu videra le contento del pagina appellate e su titulo, ma su 'typo' essera de un pagina special, i.e. un tal pagina non pote esser modificate.<br />Le contento que tu vide pote variar dependente del valores del parametros que tu passa.

Le <i>extension Appello</i> es utile pro construer applicationes interactive con MediaWiki.<br />
Pro un exemplo, vide <a href='http://semeb.com/dpldemo/Template:Catlist'>le interfacie de usator graphic de DPL</a> ..<br />
In caso de problemas, tu pote probar <b>{{#special:call}}/DebuG</b>",
	'call-save' => "Le output de iste appello se immagazinarea in un pagina con titulo ''$1''.",
	'call-save-success' => 'Le sequente texto ha essite immagazinate in le pagina <big>[[$1]]</big> .',
	'call-save-failed' => 'Le sequente texto NON ha essite immagazinate in le pagina <big>[[$1]]</big> proque iste pagina existe ja.',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author IvanLanin
 */
$messages['id'] = array(
	'call' => 'Panggilan',
	'call-desc' => 'Buat sebuah pranala ke templat (atau halaman wiki biasa) dengan parameter.
Dapat digunakan pada baris perintah penjelajah web atau di antara teks wiki',
	'call-text' => "Pengaya \"Panggilan\" membutuhkan sebuah halaman wiki dan parameter opsional untuk halaman tersebut untuk digunakan sebagai argumen.

Contoh 1: &nbsp; <tt>[[{{#special:call}}/Templat Saya,parm1=value1]]</tt><br />
Contoh 2: &nbsp; <tt>[[{{#special:call}}/Pembicaraan:Diskusi Saya,parm1=value1]]</tt><br />
Contoh 3: &nbsp; <tt>[[{{#special:call}}/:Halaman Saya,parm1=value1,parm2=value2]]</tt><br />
Contoh 4 (URL Penjelajah): &nbsp; <tt>http://domain/wiki/index.php?{{#special:call}}/:Halaman Saya,parm1=value1</tt><br /><br />

Pengaya <i>Panggilan</i> akan memanggil halaman yang dimaksud dan mengirimkan parameternya.<br />
Anda akan melihat isi dari halaman tersebut dan judulnya, tapi 'tipe'-nya akan seperti halaman istimewa, yakni halaman tersebut tidak bisa disunting.<br />Isi yang Anda lihat akan bervariasi tergantung dari parameter yang dikirimkan.<br /><br />

Pengaya <i>Panggilan</i> berguna untuk membuat aplikasi interaktif dengan MediaWiki.<br />
Contohnya: <a href='http://semeb.com/dpldemo/Template:Catlist'>GUI DPL</a> ..<br />
Jika ada masalah, lihat <b>{{#special:call}}/DebuG</b>",
	'call-save' => "Keluaran untuk panggilan ini akan disimpan di sebuah halaman bernama ''$1''.",
	'call-save-success' => 'Teks berikut ini telah disimpan ke halaman <big>[[$1]]</big>.',
	'call-save-failed' => 'Teks berikut ini BELUM disimpan ke halaman <big>[[$1]]</big> karena halaman tersebut sudah ada.',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'call' => 'Kpo',
	'call-save-success' => 'Mkpurụ édé á a donyérélé ime ihü <big>[[$1]]</big>',
);

/** Italian (Italiano)
 * @author Gianfranco
 */
$messages['it'] = array(
	'call' => 'Richiamo',
	'call-desc' => 'Crea un hyperlink verso un template (o una normale pagina wiki) passandogli dei parametri.
Può essere usato da linea di comando nel browser oppure dentro al wikitext',
	'call-text' => "L'estensione Call (Richiamo) riceve come argomenti una pagina wiki e parametri opzionali per quella pagina.<br /><br />

Esempio 1: &nbsp; <tt>[[{{#special:call}}/My Template,parm1=value1]]</tt><br />
Esempio 2: &nbsp; <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br />
Esempio 3: &nbsp; <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br />
Esempio 4 (Browser URL): &nbsp; <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:My Page,parm1=value1</tt><br /><br />

La <i>estensione Call</i> richiamerà la pagina indicata e le passerà i parametri.<br />
Leggerai i contenuti della pagina richiamata ed il suo titolo, ma il suo 'tipo' sarà ora quello di una pagina speciale, e fra l'altro una pagina del genere non può essere editata.<br />I contenuti che leggerai potranno variare a seconda dei valori dei parametri che avrai specificato.<br /><br />

La <i>estensione Call</i> è utile per costruire applicazioni interattive con MediaWiki.<br />
Per esempio vedi <a href='http://semeb.com/dpldemo/Template:Catlist'>la GUI DPL</a> ..<br />
In caso di problemi, puoi provare <b>{{#special:call}}/DebuG</b>",
	'call-save' => "L'output di questa chiamata verrebbe salvato in una pagina chiamata ''$1''.",
	'call-save-success' => 'Il testo che segue è stato salvato alla pagina <big>[[$1]].</big>',
	'call-save-failed' => 'Il testo che segue NON è stato salvato alla pagina <big>[[$1]]</big> perché quella pagina esiste già.',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author JtFuruhata
 */
$messages['ja'] = array(
	'call' => 'ページ呼び出し',
	'call-desc' => 'テンプレート(または普通のウィキページ)にパラメータを渡すハイパーリンクを作成する。ブラウザのアドレス欄やウィキテキスト内部で利用可能',
	'call-text' => "ページ呼び出し拡張機能は、あるウィキページに、そのページが取る引数であるオプションパラメータが設定されていることを想定しています。

例1: &nbsp; <tt>[[{{#special:call}}/My Template,parm1=value1]]</tt><br />
例2: &nbsp; <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br />
例3: &nbsp; <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br />
例4 (ブラウザURL): &nbsp; <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:MyPage,parm1=value1</tt>

ページ呼び出し拡張機能は、与えられたページをパラメータ付きで呼び出します。<br />あなたは呼び出されたページ内容とページ名を見ることはできますが、ページの「タイプ」は特別ページとなり、<br />つまりそのページを編集することはできません。<br />ページ内容は指定したパラメータによって変化します。

ページ呼び出し拡張機能は、MediaWiki 上で対話的なアプリケーションを構築するのに便利です。<br /><a href='http://semeb.com/dpldemo/Template:Catlist'>DPL GUI</a>を参考にしてください。<br />
問題が発生した場合は、<b>{{#special:call}}/DebuG</b> をお試しください。",
	'call-save' => "このページ呼び出し結果は、ページ ''$1'' として保存されます。",
	'call-save-success' => '以下のテキストが、ページ <big>[[$1]]</big> として保存されました。',
	'call-save-failed' => "以下のテキストは、既に同名のページが存在するため、ページ <big>[[$1]]</big> として'''保存されませんでした'''。",
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'call' => 'Celuk',
	'call-desc' => 'Nggawé pranala menyang sawijining cithakan (utawa kaca wiki biasa) nganggo paramèter.
Bisa dienggo ing baris paréntah panjlajah utawa sajroning tèks wiki.',
	'call-save' => "Kasil panyelukan iki bakal disimpen ing sawijining kaca sing diarani ''$1''.",
	'call-save-success' => 'Tèks sing kapacak ing ngisor iki wis disimpen ing kaca <big>[[$1]]</big> .',
	'call-save-failed' => 'Tèks ing ngisor iki ORA disimpen ing kaca <big>[[$1]]</big> amerga kaca iku wis ana.',
);

/** Khmer (ភាសាខ្មែរ)
 * @author T-Rithy
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'call' => 'ហៅ',
	'call-save-success' => 'អត្ថបទដូចតទៅនេះត្រូវបានរក្សាទុកទៅក្នុងទំព័រ <big>[[$1]]</big>។',
	'call-save-failed' => 'អត្ថបទដូចតទៅនេះមិនត្រូវបានរក្សាទុកទៅក្នុងទំព័រ <big>[[$1]]</big> ពីព្រោះទំព័រនោះមានរួចហើយ។',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'call' => 'Call',
	'call-desc' => 'Kann ene Link op en Schabloon udder och jeede Sigg em Wiki maache, un derbei Parrametere övverjävve. Kam_mer em Brauser un em Wiki-Täx bruche.',
	'call-text' => 'Dä „<i lang="en">Call</i>“ Zosatz zor Wiki-Sofwäer bruch en Sigg em Wiki un, wann et paß, och en Leß met Parameetere.

Beispell 1: &nbsp; <tt>[<span />[{{#special:Call}}/Ming Schablon,parm1=wäät1]]</tt><br />
Beispell 2: &nbsp; <tt>[<span />[{{#special:Call}}/Talk:Minge Klaaf,parm1=wäät1]]</tt><br />
Beispell 3: &nbsp; <tt>[<span />[{{#special:Call}}/:Ming Sigg,parm1=wäät1,parm2=wäät2]]</tt><br />
Beispell 4 (Brauser URL): &nbsp; <tt>http://mingdomain/mingwiki/index.php?{{#{{#special:call}}}}/:Ming_Sigg,parm1=wäät1</tt>

„<i lang="en">Call</i>“ weed dė aanjejovve Sigg oprohfe, un de Parammeetere dobei wigger jevve, wann welsche doh sin.<br />
Dann süühs De dä Ennhald fun dä Sigg, un dä ier Övverschreff, ävver dä Tüp fun dä Sigg es wi bei en Söndersigg, dat es, De kanns do nit draan ändere.<br />
Wat mer süüht maach ongerscheedlesch sinn, je noh dämm, wat för en Parrammeetere mer do wigger jejovve hät.

„<i lang="en">Call</i>“ hellef, öm Aanwendunge met MediaWiki opzeboue, woh de Minsche dren enjriife künne, ohne projrammeere ze möße.<br />
För e Beispell för esu jät, loor Der <a href=\'http://semeb.com/dpldemo/Template:Catlist\'>et DPL GUI</a> aan.<br />
Wann de Probleme häß, versooch et enß met <b>[[{{#special:call}}/DebuG|{{#special:Call}}/DebuG]]</b>.',
	'call-save' => 'Wat bei dämm Oprohf eruß köhm, wööd als de Sigg „$1“ afjeshpeischert.',
	'call-save-success' => 'Dä Täx hee noh wood als de Sigg </big>[[$1]]</big> afjeshpeischert.',
	'call-save-failed' => "Dä Täx hee noh eß '''nit''' als de Sigg </big>[[$1]]</big> afjeshpeischert woode. Di Sigg jidd et nämlejj ald.",
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'call' => 'Opruff',
	'call-desc' => 'Mecht een Hyperlink op eng Schabloun (oder eng normal Wiki-Säit) mat Benotze vu Parameteren. Kann an der Kommandozeil vum Browser oder am Wiki-Text benotzt ginn.',
	'call-save' => "D'Resultat vun dësem Opruff géif op der Säit '''$1''' gespäichert ginn.",
	'call-save-success' => 'Dësen Text gouf op der Säit <big>[[$1]]</big> gespäichert.',
	'call-save-failed' => 'Dësen Text konnt NET op der Säit <big>[[$1]]</big> ofgespäichert ginn, well et déi Säit scho gëtt.',
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'call' => 'Kalle',
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 * @author Ignas693
 */
$messages['lt'] = array(
	'call' => 'Skambinti',
	'call-desc' => 'Kurti hipersaitą į šabloną (arba į įprastą wiki puslapį) parametras, einančios.
Gali būti naudojamas ne naršyklės komandų eilutę arba per wiki teksto',
	'call-text' => 'Call pratęsimo tikisi wiki puslapį ir neprivalomų parametrų puslapio kaip argumentas.<br><br>
N!1 Pavyzdys: <tt>[[{{# specialius: skambučių}} /My šabloną, parm1 = reikšmė1]]</tt><br>
2 Pavyzdys: <tt>[[{{# specialius: skambučių}} / kalbėti: mano diskusijų, parm1 = reikšmė1]]</tt><br>
3 Pavyzdys: <tt>[[{{# specialius: skambučių}} /: mano puslapį, parm1 = Reikšmė1, parm2 = reikšmė2]]</tt><br>
4 (Naršyklės URL) pavyzdys: <tt>http://mydomain/mywiki/index.php? {{# specialius: skambučių}}/: Mano puslapyje, parm1 = reikšmė1</tt><br><br>
N!<i>Skambinti pratęsimo</i> skambinti pateiktą puslapį ir perduoti parametrus.<br>
Jūs pamatysite vadinamas puslapio ir jos pavadinimas turinį, bet savo "tipas" bus, kad specialios puslapio, t. y. tokių puslapio redaguoti negalima.<br>Jūs matote turinys gali skirtis atsižvelgiant į perduodama parametrų vertės.<br><br>
N!<i>Skambinti plėtinys</i> yra naudinga sukurti interaktyviąsias programas su MediaWiki.<br>
Žr <a href="http://semeb.com/dpldemo/Template:Catlist">TGA GUI</a> .<br>
Dėl problemų galite pabandyti <b>{{# specialius: skambučių}} / DebuG</b>',
	'call-save' => 'Šis kvietimas produkcijos būtų įrašyti į puslapį, vadinamas " $1 ".',
	'call-save-success' => 'Šis tekstas buvo įrašytas į puslapį <big> [[$1]] </big> .',
	'call-save-failed' => 'Šis tekstas nebuvo įrašytas į puslapį <big>[[$1]]</big> nes puslapis jau egzistuoja.',
);

/** Malagasy (Malagasy)
 * @author Jagwar
 */
$messages['mg'] = array(
	'call' => 'Antso',
	'call-save' => "Mety voatahiry amin'ny pejy '''$1''' ny valin'ity antso ity .",
	'call-save-success' => "Voatahiry any amin'ny pejy <big>[[$1]]</big> io lahatsoratra io.",
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'call' => 'Повик',
	'call-desc' => 'Создајте хиперврска до шаблон (или нормална вики-страница) со предавање на параметри.
Може да се користи во командниот ред на прелистувачот, или пак во вики-текст',
	'call-text' => "Додатокот „Повик“ (Call) очекува вики-страница и незадолжителни параметри за таа страница како аргумент.<br /><br />

Пример 1: &nbsp; <tt>[[{{#special:call}}/My Template,parm1=value1]]</tt><br />
Пример 2: &nbsp; <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br />
Пример 3: &nbsp; <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br />
Пример 4 (URL за прелистувачот): &nbsp; <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:My Page,parm1=value1</tt><br /><br />

<i>Додатокот „Повик“</i> повикува дадена страница и ги предава параметрите.<br />
Ќе ја видите содржината на повиканата страница и нејзиниот наслов, но нејзиниот 'тип' ќе биде `специјална страница`, т.е. таквата страница не може да се уредува.<br />Содржината која ќе ја видите може да варира, зависно од вредноста на параметрите кои сте ги предале.<br /><br />

<i>Додатокот „Повик“</i> е полезно за изработка на интерактивни апликации со МедијаВики.<br />
На пример, погледајте <a href='http://semeb.com/dpldemo/Template:Catlist'>DPL GUI</a> ..<br />
Во случај да имете проблеми, послужете се со <b>{{#special:call}}/DebuG</b>",
	'call-save' => "Излезните податоци од овој повик ќе бидат зачувани на страница по име ''$1''.",
	'call-save-success' => 'Следниов текст е зачуван на страницата <big>[[$1]]</big> .',
	'call-save-failed' => 'Следниов текст НЕ е зачуван на страницата <big>[[$1]]</big> бидејќи таа страница веќе постои.',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'call' => 'വിളിക്കുക',
	'call-save-success' => 'താഴെ പ്രദർശിപ്പിച്ചിരിക്കുന്ന ടെക്സ്റ്റ് <big>[[$1]]</big> എന്ന താളിലേക്ക് സേവ് ചെയ്തിരിക്കുന്നു.',
	'call-save-failed' => 'താഴെ പ്രദർശിപ്പിച്ചിരിക്കുന്ന ടെക്സ്റ്റ് <big>[[$1]]</big> എന്ന താൾ മുൻപേ നിലവിലുള്ളതിനാൽ സേവ് ചെയ്യുന്നതിനു സാധിച്ചില്ല.',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'call' => 'बोलवा (मागवा)',
	'call-desc' => 'एखाद्या साचा (अथवा पानाशी) जोडणारा व काही पॅरॅमीटर जुळल्यानंतरच वापरता येणारा दुवा तयार करते. हा दुवा ब्राउझरच्या कमांड लाईन अथवा विकि संज्ञांच्या माध्यमातून वापरता येतो.',
	'call-text' => "कॉल ही क्रिया करण्यासाठी एक विकि पान व त्याचे इतर पॅरॅमीटर अर्ग्युमेंटमध्ये दिलेले असणे
आवश्यक आहे.<br /><br />
उदाहरण १: &nbsp; <tt>[[{{#special:call}}/My Template,parm1=value1]]</tt><br />
उदाहरण २: &nbsp; <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br />
उदाहरण ३: &nbsp; <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br /><br />
उदाहरण ४ (ब्राउझर URL): &nbsp; <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:My Page,parm1=value1</tt><br /><br />

<i>कॉल क्रिया</i> ते विशिष्ट पान मागवून दिलेले पॅरॅमीटर्स तपासून पाहील.<br />तुम्ही त्या पानाचे शीर्षक तसेच मजकूर पाहू शकता पण त्याचा 'प्रकार' विशेष पान असा राहील,,<br />म्हणजेच ते पान संपादित करता येणार नाही.<br />तुम्हाला दिसत असलेला मजकूर किती पॅरॅमीटर्स जुळले त्याप्रमाणे बदलू शकतो.<br /><br />
<i>कॉल क्रिया</i> ही मीडियाविकीशी संलग्न असणारी ऍप्लीकेशन लिहिण्यासाठी उपयुक्त आहे..<br />उदाहरणासाठी पहा <a href='http://semeb.com/dpldemo/Template:Catlist'>डीपीएल जीयूआय</a> ..<br />
काही अडचणी आल्यास आल्यास तुम्ही <b>{{#special:call}}/DebuG</b> वापरून पाहू शकता",
	'call-save' => "या कॉल क्रियेचा निकाल ''$1'' या नावाच्या पानावर नोंदला जाईल.",
	'call-save-success' => 'खालील मजकूर <big>[[$1]]</big> या पानावर जतन केलेला आहे.',
	'call-save-failed' => 'खालील मजकूर <big>[[$1]]</big> या पानावर जतन केलेला नाही, कारण ते पान अगोदरच अस्तित्वात आहे.',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Kurniasan
 */
$messages['ms'] = array(
	'call' => 'Panggil',
	'call-desc' => 'Membuat hiperpautan ke templat (atau ke laman wiki biasa) melalui penguluran parameter.
Boleh digunakan di baris perintah penyemak imbas atau di dalam teks wiki.',
	'call-text' => "Sambungan Call menjangkakan laman wiki dan parameter pilihan untuk laman itu sebagai hujah.<br /><br />

Contoh 1: &nbsp; <tt>[[{{#special:call}}/My Template,parm1=value1]]</tt><br />
Contoh 2: &nbsp; <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br />
Contoh 3: &nbsp; <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br />
Contoh 4 (URL Pelayar): &nbsp; <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:My Page,parm1=value1</tt><br /><br />

<i>Sambungan Call</i> akan memanggil laman yang dinyatakan dan menghantarkan parameter-parameternya.<br />
Anda akan melihat kandungan laman yang dipanggil dan tajuknya tetapi dalam 'jenis' laman khas, yang mana ia tidak boleh disunting.<br />Kandungan yang anda lihat mungkin ada perbezaan, bergantung pada nilai parameter yang dihantarkan.<br /><br />

<i>Sambungan Call</i> sesuai untuk membina aplikasi interaktif dengan MediaWiki.<br />
Contohnya, perhatikan <a href='http://semeb.com/dpldemo/Template:Catlist'>antara muka pengguna bergrafik DPL</a> ..<br />
Sekiranya ada masalah, anda boleh cuba <b>{{#special:call}}/DebuG</b>",
	'call-save' => "Keluaran bagi panggilan ini akan disimpan di laman ''$1''.",
	'call-save-success' => 'Teks berikut telah disimpan di laman <big>[[$1]]</big> .',
	'call-save-failed' => 'Teks berikut TIDAK disimpan di laman <big>[[$1]]</big> kerana laman tersebut telah pun wujud.',
);

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = array(
	'call-save-success' => 'Dan it-test segwenti kien salvat fuq il-paġna <big>[[$1]]</big>.',
	'call-save-failed' => 'Dan it-test segwenti ma ġiex salvat fuq il-paġna <big>[[$1]]</big> minħabba li din il-paġna diġà teżisti.',
);

/** Nahuatl (Nāhuatl)
 * @author Ricardo gs
 */
$messages['nah'] = array(
	'call' => 'Ticnōtzāz',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'call' => 'Kall opp',
	'call-desc' => 'Gir mulighet til å skape linker til maler (eller vanlige wikisider) med angitte parametre. Lenkene kan brukes i nettleserens adressefelt eller i wikitekst.',
	'call-text' => 'Utvidelsen Kall opp (Call) forventer seg at en wikiside og valgfrie parametere for den siden angis som et argument.<br /><br />

Eksempel 1: &nbsp; <tt>[[{{#special:call}}/My Template,parm1=value1]]</tt><br />
Eksempel 2: &nbsp; <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br /><br />
Eksempel 3: &nbsp; <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br /><br />
Eksempel 4 (URL for adressefeltet): &nbsp; <tt>http://mittdomene/minwiki/index.php?{{#special:call}}/:My Page,parm1=value1</tt><br /><br />

<i>Kall opp</i>-tillegget anroper den angitte siden og sender med parameterne.<br />
Du kommer til å se den anropte sidens innhold og tittel, men siden som vises er en spesialside og kan derfor ikke redigeres.<br />
Innholdet som vises kan variere avhengig av verdiene til de parameterne som sendes med.<br /><br />

<i>Kall opp</i>-utvidelsen kan brukes for å skape interaktive applikasjoner med MediaWiki.<br />
Se for eksempel <a href="http://semeb.com/dpldemo/Template:Catlist">grensesnittet for DPL</a> ..<br />
Om du har noen problemer kan du prøve <b>{{#special:call}}/DebuG</b>.',
	'call-save' => "Resultatet av denne oppkallingen ville blitt lagret på en side ved navn ''$1''.",
	'call-save-success' => 'Følgende tekst har blitt lagret på siden <big>[[$1]]</big>.',
	'call-save-failed' => 'Følgende tekst har IKKE blitt lagret på siden <big>[[$1]]</big> fordi siden allerede finnes.',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'call' => 'Aanroepen',
	'call-desc' => 'Maak een hyperlink naar een sjabloon (of naar een normale wikipagina) met gebruik van parameters.
Kan gebruikt worden in de adresregel van de browser of in wikitekst.',
	'call-text' => "De uitbreiding Aanroepen (Call) verwacht een wikipagina en optioneel parameters voor die pagina.

Voorbeeld 1: &nbsp; <tt>[[{{#special:call}}/My Template,parm1=value1]]</tt><br />
Voorbeeld 2: &nbsp; <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br />
Voorbeeld 3: &nbsp; <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br /><br />
Voorbeeld 4 (Browser URL): &nbsp; <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:My Page,parm1=value1</tt>

De <i>uitbreiding Aanroepen</i> roept de opgegeven pagina aan en geeft de parameters door.<br />
U krijgt de inhoud van de aangeroepen pagina te zien en de naam, maar deze is van het 'type' speciale pagina, dat wil zeggen dat de pagina niet bewerkt kan worden.<br />
De inhoud die u te zien krijgt kan verschillen, afhankelijk van de parameters die u hebt meegegeven.

De <i>uitbreiding Aanroepen</i> kan behulpzaam zijn bij het bouwen van interactieve applicaties met MediaWiki.
De <a href='http://semeb.com/dpldemo/Template:Catlist'>DPL GUI</a> is daar een voorbeeld van.<br />
Bij problemen kunt u gebruik maken van <b>{{#special:call}}/DebuG</b>",
	'call-save' => "De uitvoer van deze aanroep zou opgeslagen zijn in de pagina ''$1''.",
	'call-save-success' => 'De volgende tekst is opgeslagen in pagina <big>[[$1]]</big>.',
	'call-save-failed' => 'De volgende tekst is NIET opgeslagen in pagina <big>[[$1]]</big> omdat die pagina al bestaat.',
);

/** ‪Nederlands (informeel)‬ (‪Nederlands (informeel)‬)
 * @author Siebrand
 */
$messages['nl-informal'] = array(
	'call-text' => "De uitbreiding Aanroepen (Call) verwacht een wikipagina en optioneel parameters voor die pagina.

Voorbeeld 1: &nbsp; <tt>[[{{#special:call}}/My Template,parm1=value1]]</tt><br />
Voorbeeld 2: &nbsp; <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br />
Voorbeeld 3: &nbsp; <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br /><br />
Voorbeeld 4 (Browser URL): &nbsp; <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:My Page,parm1=value1</tt>

De <i>uitbreiding Aanroepen</i> roept de opgegeven pagina aan en geeft de parameters door.<br />
Je krijgt de inhoud van de aangeroepen pagina te zien en de naam, maar deze is van het 'type' speciale pagina, dat wil zeggen dat de pagina niet bewerkt kan worden.<br />
De inhoud die je te zien krijgt kan verschillen, afhankelijk van de parameters die u hebt meegegeven.

De <i>uitbreiding Aanroepen</i> kan behulpzaam zijn bij het bouwen van interactieve applicaties met MediaWiki.
De <a href='http://semeb.com/dpldemo/Template:Catlist'>DPL GUI</a> is daar een voorbeeld van.<br />
Bij problemen kan gebruik maken van <b>{{#special:call}}/DebuG</b>",
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'call' => 'Kall opp',
	'call-desc' => 'Gjer det mogleg å oppretta lenkjer til malar (eller vanlige wikisider) med oppgjevne parametrar. Lenkjene kan bli brukte i adressefeltet til nettlesaren eller i wikitekst.',
	'call-text' => 'Utvidinga Kall opp (Call) forventar at ei wikisida og valfrie parametrar for sida blir oppgjevne som eit argument.<br /><br />
Døme 1: &nbsp; <tt>[[{{#special:call}}/Malen min,parm1=verdi1]]</tt><br />
Døme 2: &nbsp; <tt>[[{{#special:call}}/Talk:Diskusjonssida mi,parm1=verdi1]]</tt><br /><br />
Døme 3: &nbsp; <tt>[[{{#special:call}}/:Sida mi,parm1=verdi1,parm2=verdi2]]</tt><br /><br />
Døme 4 (URL for adressefeltet): &nbsp; <tt>http://mittdomene/minwiki/index.php?{{#special:call}}/:Mi_sida,parm1=verdi1</tt><br /><br />

<i>Kall opp</i>-tillegget kallar opp den oppgjevne sida og sender med parametrane.<br />Du kjem til å sjå sida som er kalla opp sitt innhald og tittel, men sida som blir vist er ei spesialsida og kan difor ikkje bli redigert.<br />
Innhaldet som blir vist kan variera avhengig av verdiane til dei parametrane som som blir sendte med.<br /><br />
Tillegget <i>Kall opp</i> kan bli brukt for å skapa interaktive applikasjonar med MediaWiki.<br />
Sjå til dømes <a href="http://semeb.com/dpldemo/Template:Catlist">grensesnittet for DPL</a><br />
Om du har problem, kan du prøva <b>{{#special:call}}/DebuG</b>.',
	'call-save' => "Resultatet av denne oppkallinga ville blitt lagra på ei sida med namnet ''$1''.",
	'call-save-success' => 'Følgjande tekst har blitt lagra på sida <big>[[$1]]</big>.',
	'call-save-failed' => 'Følgjande tekst har IKKJE blitt lagra på sida <big>[[$1]]</big> av di sida allereie finst.',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'call' => 'Ampèl',
	'call-desc' => 'Crèa un ligam ipertèxte cap a un modèl o un article wiki normals tot i passant de paramètres. Pòt èsser utilizada en linha de comanda dempuèi un navigador o a travèrs un tèxte wiki.',
	'call-text' => "L’extension Ampèl a besonh d’una pagina wiki e dels paramètres facultatius per aquesta darrièra coma argumen.<br /><br />

Exemple 1: &nbsp; <tt>[[{{#special:call}}/Mon modèl,parm1=value1]]</tt><br />
Exemple 2: &nbsp; <tt>[[{{#special:call}}/Discussion:Ma discussion,parm1=valor1]]</tt><br />
Exemple 3: &nbsp; <tt>[[{{#special:call}}/:Ma pagina,parm1=valor1,parm2=valor2]]</tt><br /><br />
Exemple 4 (Adreça per navigador) : &nbsp; <tt>http://mondomeni/monwiki/index.php?{{#special:call}}/:Ma_Pagina,param1=valor1</tt>.<br /><br />

L’extension <i>Ampèl</i> apelarà la pagina indicada en i passant los paramètres.<br />
Veiretz las entresenhas d'aquesta pagina, son títol, mas son « tipe » serà lo d’una pagina especiala que poirà pas èsser editada.<br />Las entresenhas que veiretz variaràn en foncion dels paramètres qu'auretz indicats.<br /><br />

Aquesta extension es fòrt practica per crear d'aplicacions interactivas amb MediaWiki.<br />
A títol d’exemple, vejatz <a href='http://semeb.com/dpldemo/Template:Catlist'>l'interfàcia DPL</a>...<br />
En cas de problèmas, podètz ensajar <b>{{#special:call}}/DebuG</b>",
	'call-save' => "Çò qu'es indicat per aqueste ampèl poiriá èsser salvat cap a una pagina intitolada ''$1''.",
	'call-save-success' => 'Lo tèxte seguent es estat salvat cap a la pagina <big>[[$1]]</big> .',
	'call-save-failed' => 'Lo tèxte seguent a pas pogut èsser salvat cap a la pagina <big>[[$1]]</big> perque aquesta pagina existís ja.',
);

/** Polish (Polski)
 * @author Holek
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'call' => 'Wywołaj z parametrem',
	'call-desc' => 'Tworzy hiperłącze do szablonu (oraz strony w każdej przestrzeni nazw) z przesłaniem parametrów.
Funkcjonalność może być wykorzystana bezpośrednio w wikitekście lub jako adres dla pokazania możliwości szablonu/strony.',
	'call-text' => "Rozszerzenie <i>Wywołaj z parametrem</i> wywołuje się podając jako argument nazwę strony oraz opcjonalnie parametry wywołania dla tej strony.

Przykład 1: &nbsp; <tt>[[Specjalna:Wywołaj z parametrem/Mój szablon,parametr1=wartość1]]</tt><br />
Przykład 2: &nbsp; <tt>[[Specjalna:Wywołaj z parametrem/Dyskusja:Moja dyskusja,parametr1=wartość1]]</tt><br />
Przykład 3: &nbsp; <tt>[[Specjalna:Wywołaj z parametrem/:Moja strona,parametr1=wartość1,parametr2=wartość2]]</tt><br />
Przykład 4 (link): &nbsp; <tt>http://mojadomena/mojawiki/index.php?{{#special:call}}/:Moja strona,parametr1=wartość1</tt>

Rozszerzenie <i>Wywołaj z parametrem</i> wywoła podaną stronę i wysyłając jej podane parametry.<br />
Zobaczysz zawartość wywołanej strony i jej tytuł, ale dalej będzie to strona specjalna, przez co nie będzie mogła być edytowana.<br />Zawartość, którą zobaczysz, będzie różna w zależności od podanych parametrów.

Rozszerzenie <i>Wywołaj z parametrem</i> jest przydatne przy budowaniu interaktywnych aplikacji na bazie MediaWiki.<br />Przykładem takiej aplikacji może być <a href='http://semeb.com/dpldemo/Template:Catlist'>DPL GUI</a>.<br />
W razie problemów, spróbuj <b>Specjalna:Wywołaj z parametrem/DebuG</b>",
	'call-save' => "Rezultat tego wywołania zostanie zapisany na stronie ''$1''.",
	'call-save-success' => 'Poniższy tekst został zapisany na stronie <big>[[$1]]</big>.',
	'call-save-failed' => "Poniższy tekst '''NIE''' został zapisany na stronie <big>[[$1]]</big>, ponieważ ta strona już istnieje.",
);

/** Piedmontese (Piemontèis)
 * @author Dragonòt
 */
$messages['pms'] = array(
	'call' => 'Ciamà',
	'call-desc' => "Crea n'anliura a në stamp (o a na pàgina wiki normal) con passagi ëd paràmetr.
A peul esse dovrà ant la linia ëd comand dël browser o an drinta ëd test wiki",
	'call-text' => "L'estension ëd Call a speta na pàgina wiki e paramétr opsionaj për cola pàgina com n'argoment.<br /><br />

Esempi 1: &nbsp; <tt>[[{{#special:call}}/My Template,parm1=value1]]</tt><br />
Esempi 2: &nbsp; <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br />
Esempi 3: &nbsp; <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br />
Esempi 4 (Browser URL): &nbsp; <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:My Page,parm1=value1</tt><br /><br />

L'<i>estension Call</i> a ciamrà la pàgina dàita e a passrà ij paràmetr.<br />
It vëddras ij contnù ëd la pàgina ciamà e ij sò tìtoj ma ël sò 'type' a sarà col ëd na pàgina special, visadì com na pàgina ch'a peul pa esse modificà.<br />Ij contnù ch'it vëddras a peulo cambié a second dël valor dij paràmetr ch'it passe.<br /><br />

L'<i>estension Call</i> a l'é ùtila për fé dj'aplicassion antëràtive con MediaWiki.<br />
Për n'esempi varda <a href='http://semeb.com/dpldemo/Template:Catlist'>la GUI DPL</a> ..<br />
An cas ëd problema it peule prové <b>{{#special:call}}/DebuG</b>",
	'call-save' => "L'arzultà dë sta ciamà-sì a podrìa esse salvà dzora a na pàgina ciamà ''$1''.",
	'call-save-success' => "Ël test sota a l'é stàit salvà a la pàgina <big>[[$1]]</big> .",
	'call-save-failed' => "Ël test sota a l'é PA stàit salvà a la pàgina <big>[[$1]]</big> përchè la pàgina a esist già.",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'call-save-success' => 'لاندينی متن د <big>[[$1]]</big> مخ کې خوندي شوی.',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Malafaya
 */
$messages['pt'] = array(
	'call' => 'Call',
	'call-desc' => 'Cria um link para uma predefinição (ou para uma página wiki normal) com passagem de parâmetros. Pode ser usada na linha de comando do browser ou no texto wiki.',
	'call-text' => "A extensão Call espera receber como argumentos uma página wiki e parâmetros opcionais para essa página.<br /><br />

Exemplo 1: &nbsp; <tt>[[{{#special:call}}/Minha Predefinição,parm1=value1]]</tt><br />
Exemplo 2: &nbsp; <tt>[[{{#special:call}}/Talk:Minha Discussão,parm1=value1]]</tt><br />
Exemplo 3: &nbsp; <tt>[[{{#special:call}}/:Minha Página,parm1=value1,parm2=value2]]</tt><br /><br />
Exemplo 4 (URL para o browser): &nbsp; <tt>http://meudominio/minhawiki/index.php?{{#special:call}}/:Minha Página,parm1=value1</tt><br /><br />

A <i>extensão Call</i> irá realizar uma chamada à página fornecida e passar os parâmetros.<br />
Verá o conteúdo da página chamada e o seu título, mas o seu 'tipo' será o de uma página especial, isto é, a página não pode ser editada.<br />O conteúdo que verá pode variar dependendo do valor dos parâmetros que passou.<br /><br />

A <i>extensão Call</i> é útil para construir aplicações interactivas com o MediaWiki.<br />Para um exemplo, veja <a href='http://semeb.com/dpldemo/Template:Catlist'>o GUI DPL</a> ..<br />
Em caso de problemas, pode experimentar <b>{{#special:call}}/DebuG</b>",
	'call-save' => "O resultado desta chamada seria gravado numa página chamada ''$1''.",
	'call-save-success' => 'O seguinte texto foi gravado na página <big>[[$1]]</big>.',
	'call-save-failed' => 'O seguinte texto NÃO foi gravado na página <big>[[$1]]</big> porque essa página já existe.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'call' => 'Call',
	'call-desc' => 'Cria uma hiperligação para uma predefinição (ou para uma página wiki normal) com passagem de parâmetros. Pode ser usada na linha de comandos do navegador ou dentro de texto wiki.',
	'call-text' => "A extensão Call espera uma página wiki e parâmetros opcionais para essa página como argumentos.<br /><br />
Exemplo 1: &nbsp; <tt>[[{{#special:call}}/Minha Predefinição,parm1=value1]]</tt><br />
Exemplo 2: &nbsp; <tt>[[{{#special:call}}/Talk:Minha Discussão,parm1=value1]]</tt><br />
Exemplo 3: &nbsp; <tt>[[{{#special:call}}/:Minha Página,parm1=value1,parm2=value2]]</tt><br /><br />
Exemplo 4 (URL de \"browser\"): &nbsp; <tt>http://meudominio/meuwiki/index.php?{{#special:call}}/:Minha Página,parm1=value1</tt><br /><br />

A <i>extensão Call</i> irá realizar uma chamada à página fornecida e passar os parâmetros.<br />Você irá ver o conteúdo da página chamada e o seu título, mas o seu 'tipo' será o de uma página especial,<br />i.e. tal página não poderá ser editada.<br />O conteúdo que verá poderá variar dependendo do valor dos parâmetros que forem passados.<br /><br />
A <i>extensão Call</i> é útil na construção de aplicações interativas com MediaWiki.<br />Para um exemplo, veja <a href='http://semeb.com/dpldemo/Template:Catlist'>o GUI DPL</a> ..<br />
Em caso de problemas, você poderá experimentar <b>{{#special:call}}/DebuG</b>",
	'call-save' => "O resultado desta chamada seria gravado numa página chamada ''$1''.",
	'call-save-success' => 'O seguinte texto foi gravado na página <big>[[$1]]</big>.',
	'call-save-failed' => ' seguinte texto NÃO foi gravado na página <big>[[$1]]</big> porque essa página já existe.',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 * @author Minisarm
 */
$messages['ro'] = array(
	'call' => 'Apel',
	'call-save-success' => 'Următorul text a fost salvat la pagina <big>[[$1]]</big> .',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'call' => 'Chiame',
	'call-save' => "'U resultate de sta chiamate avène reggistrate jndr'à 'na pàgene chiamate ''$1''.",
);

/** Russian (Русский)
 * @author Ahonc
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'call' => 'Вызов',
	'call-desc' => 'Создаёт гиперссылку на шаблон (или обычную вики-страницу) с передачей параметров. Может использоваться в адресной строке браузера или в вики-тексте.',
	'call-text' => "Расширение «Вызов» (Call) принимает в качестве входных данных название страницы и значения параметров.<br /><br />

Пример 1: &nbsp; <tt>[[{{#special:call}}/My Template,parm1=value1]]</tt><br />
Пример 2: &nbsp; <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br />
Пример 3: &nbsp; <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br />
Пример 4 (URL для браузера): &nbsp; <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:My Page,parm1=value1</tt>

Данное расширение вызовет указанную страницу и передаст ей параметры.<br />
Вы увидите сожержимое страницы, её заголовок, но её тип будет типом служебной страницы, т. е. содержимое нельзя будет редактировать.<br />
Отображаемое содержимое страницы может изменяться, в зависимости от переданных параметров.<br /><br />

Расширение «Вызов» полезно для построения интерактивных приложений с помощью MediaWiki.<br />
См. например <a href='http://semeb.com/dpldemo/Template:Catlist'>DPL GUI</a>.<br />
В случае возникновения проблем, вы можете использовать <b>{{#special:call}}/DebuG</b>",
	'call-save' => "Вывод этого вызова будет сохранён на страницу ''$1''.",
	'call-save-success' => 'Следующий текст был сохранён на страницу <big>[[$1]]</big>.',
	'call-save-failed' => 'Следующий текст НЕ был сохранён на страницу <big>[[$1]]</big>, так как данная страница уже существует.',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'call' => 'Call',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'call' => 'Ыҥырыы',
	'call-desc' => 'Халыыпка (эбэтэр көннөрү сирэйгэ) сигэни оҥорор (туруорууарын биэрэн туран).
Браузер аадырыһын устуруокатыгар эбэтэр биики тиэкискэ туттуллуон сөп.',
);

/** Sinhala (සිංහල)
 * @author බිඟුවා
 */
$messages['si'] = array(
	'call' => 'ඇමතුම',
);

/** Slovak (Slovenčina)
 * @author Helix84
 * @author Rudko
 */
$messages['sk'] = array(
	'call' => 'Call',
	'call-desc' => 'Vytvorí hyperodkaz na šablónu (alebo na bežnú wiki stránku) s odovzdávaním parametrov. Je možné použiť z riadka s adresou v prehliadači alebo v rámci wiki textu.',
	'call-text' => "Rozšírenie Call očakáva ako argumenty stránku wiki a voliteľné parametre danej stránky.<br /><br />
Príklad 1: &nbsp; <tt>[[{{#special:call}}/Moja šablóna,parm1=value1]]</tt><br />
Príklad 2: &nbsp; <tt>[[{{#special:call}}/Diskusia:Moja diskusia,parm1=value1]]</tt><br />
Príklad 3: &nbsp; <tt>[[{{#special:call}}/:Moja stránka,parm1=value1,parm2=value2]]</tt><br /><br />
Príklad 4 (URL prehliadača): &nbsp; <tt>http://mojadoména/mojawiki/index.php?{{#special:call}}/:Moja stránka,parm1=value1</tt><br /><br />

<i>Rozšírenie Call</i> zavolá danú stránku a odovzdá jej parametre.<br />
Uvidíte obsah zavolanej stránky a jej názov, ale jej ''typ'' bude špeciálna stránka,<br />
t.j. takú stránku nie je možné upravovať.<br />
Obsah, ktorý uvidíte sa môže líšiť v závislosti od parametrov, ktoré ste odovzdali.<br /><br />
<i>Rozšírenie Call</i> je užitočné pri budovaní interaktívnych aplikácií pomocou MediaWiki.<br />
Ako príklad si môžete pozrieť <a href='http://semeb.com/dpldemo/Template:Catlist'>GUI DPL</a> ..<br />
V prípade problémov môžete skúsiť <b>{{#special:call}}/DebuG</b>",
	'call-save' => "Výstup tejto stránky by bol uložený na stránku s názvom ''$1''.",
	'call-save-success' => 'Nasledovný text bol uložený na stránku <big>[[$1]]</big>.',
	'call-save-failed' => "Nasledovný text NEBOL uložený na stránku ''$1'', pretože taká stránka už existuje.",
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Charmed94
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'call' => 'Позив',
	'call-desc' => 'Прављење везе ка шаблону (или до обичне странице викија) с параметром у пролазу.
Може се користити на командној линији прегледача или унутар вики текста',
	'call-save' => "Одредишна датотека овог позива била би сачувана на страницу под називом ''$1''.",
	'call-save-success' => 'Следећи текст је сачуван у страници <big>[[$1]]</big>.',
	'call-save-failed' => 'Следећи текст није сачуван на страници <big>[[$1]]</big> јер та страница већ постоји.',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Rancher
 */
$messages['sr-el'] = array(
	'call' => 'Poziv',
	'call-desc' => 'Pravljenje veze ka šablonu (ili do obične stranice vikija) s parametrom u prolazu.
Može se koristiti na komandnoj liniji pregledača ili unutar viki teksta',
	'call-save' => "Odredišna datoteka ovog poziva bila bi sačuvana na stranicu pod nazivom ''$1''.",
	'call-save-success' => 'Sledeći tekst je sačuvan u stranici <big>[[$1]]</big>.',
	'call-save-failed' => 'Sledeći tekst nije sačuvan na stranici <big>[[$1]]</big> jer ta stranica već postoji.',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'call' => 'Parameter-Aproup',
	'call-desc' => 'Moaket n Hyperlink tou ne Foarloage (of tou ne normoale Siede) mäd Parameter-Uurgoawe.
Kon in ju Iengoawe-Apfoarderenge fon dän Browser of in dän Wiki-Text ferwoand wäide.',
	'call-save' => "Ju Uutgoawe fon dissen Aproup wüül as Siede ''$1'' spiekerd wäide.",
	'call-save-success' => 'Die foulgjende Text wuud ap Siede <big>[[$1]]</big> spiekerd.',
	'call-save-failed' => 'Die foulgjende Text wuud NIT ap Siede <big>[[$1]]</big> spiekerd, wült disse Siede al existiert.',
);

/** Sundanese (Basa Sunda)
 * @author Kandar
 */
$messages['su'] = array(
	'call' => 'Calukan',
	'call-desc' => "Jieun hipertumbu ka citakan (atawa ka kaca wiki biasa) nu mibanda ''parameter passing''. Ieu bisa dipaké dina the browser’s command line or within wiki text.",
	'call-save' => "Kaluaran ieu panyaluk bakal disimpen di kaca nu disebut ''$1''.",
	'call-save-success' => 'Tulisan di handap ieu geus disimpen dina kaca <big>[[$1]]</big> .',
	'call-save-failed' => 'Tulisan di handap ieu CAN disimpen dina kaca <big>[[$1]]</big> kusabab éta kaca geus aya.',
);

/** Swedish (Svenska)
 * @author Lejonel
 * @author M.M.S.
 */
$messages['sv'] = array(
	'call' => 'Anropa',
	'call-desc' => 'Ger möjlighet att skapa länkar till mallar (eller vanliga wikisidor) med angivna parametrar. Länkarna kan användas i webbläsarens adressfält eller i wikitext.',
	'call-text' => "Programtillägget Call (Anropa) förväntar sig att en wikisida, och eventuellt parametrar till sidan, anges som argument.<br /><br />
Exempel 1: &nbsp; <tt>[[{{#special:call}}/Min mall,parm1=värde1]]</tt><br />
Exempel 2: &nbsp; <tt>[[{{#special:call}}/Talk:Min diskussion,parm1=värde1]]</tt><br />
Exempel 3: &nbsp; <tt>[[{{#special:call}}/:Min sida,parm1=värde1,parm2=värde2]]</tt><br /><br />
Example 4 (URL för adressfältet): &nbsp; <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:Min_sida,parm1=värde1</tt><br /><br />

<i>Call</i>-tillägget anropar den angivna sidan och skickar med parametrarna.<br />Du kommer att se den anropade sidans innehåll och titel, men sidan som visas är en specialsida och kan därför inte redigeras.<br />
Innehållet som visas kan variera beroende på värdena på de parametrar som skickas med.<br /><br />
Tillägget <i>Call</i> kan användas för att skapa interaktiva applikationer med MediaWiki.<br />
Se som ett exempel <a href='http://semeb.com/dpldemo/Template:Catlist'>gränssnittet för DPL</a> <br />
Om du har några problem så kan du prova <b>{{#special:call}}/DebuG</b>.",
	'call-save' => "Resultatet av det här anropet skulle ha sparats på en sida med titeln ''$1''.",
	'call-save-success' => 'Följande text har sparats på sidan <big>[[$1]]</big>.',
	'call-save-failed' => 'Följande text har <b>inte</b> sparats på sidan <big>[[$1]]</big> eftersom sidan redan existerar.',
);

/** Telugu (తెలుగు)
 * @author Ravichandra
 * @author Veeven
 * @author వైజాసత్య
 */
$messages['te'] = array(
	'call' => 'పిలువు',
	'call-desc' => 'ఒక మూసకు (లేదా ఒక సాధారణ వికీ పేజీ) కి పారామీటర్లను పంపించడం ద్వారా అనుపథం (హైపర్ లింక్) సృష్టించు.
దీన్ని విహరిణి యొక్క కమాండ్ లైన్ లోనూ, వికీ పాఠ్యం లోపల కూడా వాడవచ్చు.',
	'call-save' => "ఈ కాల్ యొక్క అవుట్‌పుట్ ''$1'' అనే పేజీలోకి భద్రపరుచుబడుతుంది.",
	'call-save-success' => 'ఈ క్రింది పాఠ్యాన్ని <big>[[$1]]</big> అనే పేజీలో భద్రపరిచాం.',
	'call-save-failed' => '<big>[[$1]]</big> అనే పేజీ ఈసరికే ఉన్నందువల్ల ఈ క్రింది పాఠ్యాన్ని అందులో భద్రపరచలేకపోయాం.',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'call-save-success' => 'Матни зерин ба саҳифа <big>[[$1]]</big> захира шуд.',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'call-save-success' => 'Matni zerin ba sahifa <big>[[$1]]</big> zaxira şud.',
);

/** Thai (ไทย)
 * @author Akkhaporn
 */
$messages['th'] = array(
	'call' => 'ทั้งหมด',
	'call-desc' => 'สร้างการเชื่อมโยงไปยังแม่แบบ (หรือหน้าวิกิปกติ) ด้วยำารามิเตอร์ที่ผ่านมา.
สามารถใช้บรรทัดคำสั่งที่เบราว์เซอร์หรือในข้อความวิกิ',
	'call-text' => '',
	'call-save' => "การส่งออกของคำร้องถูกบันทึกไปยังหน้า ''$1''",
	'call-save-success' => 'ข้อความต่อไปนี้ถูกบันทึกไปยังหน้า <big>[[$1]]</big>',
	'call-save-failed' => 'ข้อความต่อไปนี้ไม่ได้บันทึกไปยังหน้า <big>[[$1]]</big> เพราะหน้านั้นมีอยู่แล้ว',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'call' => 'Tawagin',
	'call-desc' => "Lumikha ng isang sangguniang kawing (''hyperlink'') sa isang suleras (o sa isang karaniwang pahina ng wiki) na may pagpasa ng parametro.
Magagamit sa guhit ng utos ng pangtingin (''browser'') o sa loob ng isang teksto ng wiki.",
	'call-text' => "Ang karugtong ng Pagtawag ay may inaasahang isang pahina ng wiki at mga parametro (na hindi naman talaga kinakailangang mayroon) para sa pahinang iyon bilang isang pangangatwiran.

Halimbawa 1: &nbsp; <tt>[[{{#special:call}}/My Template,parm1=value1]]</tt><br />
Halimbawa 2: &nbsp; <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br />
Halimbawa 3: &nbsp; <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br />
Halimbawa 4 (Browser URL): &nbsp; <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:My Page,parm1=value1</tt>

Tatawagin ng <i>karugtong ng Pagtawag</i> ang isang ibinigay na pahina at magpapasa ng mga parametro.<br />
Makikita mo ang mga nilalaman ng tinawag na pahina at ang pamagat nito subalit ang 'uri' nito ay magiging para sa isang natatanging pahina, iyan ay ang katulad ng isang pahinang hindi maaaring baguhin.<br />Maaaring maging magkakaiba ang mga nilalaman na makikita mo ayon sa halaga ng mga parametrong ipinasa mo.

Magagamit ang <i>karugtong ng Pagtawag</i> sa pagbubuo ng nakapagpapasigla sa pakikipag-ugnayan o inter-aktibong mga sopwer o aplikasyong kasama sa MediaWiki.<br />
Bilang halimbawa, tingnan ang <a href='http://semeb.com/dpldemo/Template:Catlist'>ang GUI ng DPL </a> ..<br />
Kung sakaling may mga suliranin, maaari mong subukan ang <b>{{#special:call}}/DebuG</b>",
	'call-save' => "Ang kinalabasan ng pagtawag na ito ay sasagipin sa isang pahinang tinatawag na ''$1''.",
	'call-save-success' => 'Ang sumusunod na teksto ay sinagip na sa pahinang <big>[[$1]]</big>.',
	'call-save-failed' => 'Ang sumusunod na teksto ay HINDI nasagip sa pahinang <big>[[$1]]</big> dahil umiiral na ang pahinang iyan.',
);

/** Turkish (Türkçe)
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'call' => 'Çağrı',
	'call-desc' => 'Parametre geçişi ile bir şablona (ya da normal bir viki sayfasına) giden bir bağlantı oluşturur.
Tarayıcının komut satırında ya da viki metni dahilinde kullanılabilir',
	'call-text' => "Çağrı eklentisi bir viki sayfası ve bir argüman olarak bu sayfa için opsiyonel parametre beklemektedir.<br /><br />

Örnek 1: &nbsp; <tt>[[{{#special:call}}/My Template,parm1=value1]]</tt><br />
Örnek 2: &nbsp; <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br />
Örnek 3: &nbsp; <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br />
Örnek 4 (Browser URL): &nbsp; <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:My Page,parm1=value1</tt><br /><br />

<i>Çağrı eklentisi</i>, verilen sayfayı arayacak ve parametreleri geçirecektir.<br />
Çağrılan sayfanın içeriğini göreceksiniz, ancak 'türü' özel bir sayfa gibi olacak, yani bu tür bir sayfada değişiklik yapılamayacak.<br />Gördüğünüz içerik, geçirdiğiniz parametre değerine bağlı olarak değişkenlik gösterebilir.<br /><br />

<i>Çağrı eklentisi</i>, MediaWiki ile interaktif uygulama oluşturma açısından yararlıdır.<br />
Örneğin <a href='http://semeb.com/dpldemo/Template:Catlist'>DPL GUI'ya</a> bakınız.<br />
Problem halinde <b>{{#special:call}}/DebuG</b> seçeneğini deneyebilirsiniz",
	'call-save' => "Bu çağrının çıktısı ''$1'' adlı bir sayfaya kaydedilecek.",
	'call-save-success' => 'Aşağıdaki metin, <big>[[$1]]</big> sayfasına kaydedildi.',
	'call-save-failed' => 'Aşağıdaki metin <big>[[$1]]</big> sayfasına KAYDEDİLMEDİ, zira bu sayfa mevcut değil.',
);

/** Ukrainian (Українська)
 * @author Ahonc
 */
$messages['uk'] = array(
	'call' => 'Виклик',
	'call-desc' => 'Створює посилання на шаблон (або звичайну вікі-сторінку) з передачею параметрів. Може використовуватися в адресному рядку браузера або у вікі-тексті.',
	'call-text' => "Розширення Call приймає в якості вхідних даних назву сторінки і значення параметрів.<br />

Приклад 1: &nbsp; <tt>[[{{#special:call}}/My Template,parm1=value1]]</tt><br />
Приклад 2: &nbsp; <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br />
Приклад 3: &nbsp; <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br />
Приклад 4 (URL для браузера): &nbsp; <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:My Page,parm1=value1</tt>

Це розширення викличе зазначену сторінку і передасть їй параметри. Ви побачите вміст сторінки, її заголовок, але її тип буде типом спеціальної сторінки, тобто вміст не можна буде редагувати.<br />Вімст сторінки, який відображається, може змінюватися, в залежності від переданих параметрів.<br />

Розширення Call корисне для побудови інтерактивних застосувань за допомогою MediaWiki.<br />Див. наприклад <a href='http://semeb.com/dpldemo/Template:Catlist'>DPL GUI</a>.<br />
У випадку виникнення проблем ви можете використовувати <b>{{#special:call}}/DebuG</b>",
	'call-save' => "Вивід цього виклику буде збережений на сторінку ''$1''.",
	'call-save-success' => 'Наступний текст був збережений на сторінку <big>[[$1]]</big>.',
	'call-save-failed' => 'Наступний текст НЕ був збережений на сторінку <big>[[$1]]</big>, оскільки ця сторінка вже існує.',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'call' => 'Kucund',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'call' => 'Gọi',
	'call-desc' => 'Tạo một siêu liên kết đến một bản mẫu (hoặc đến một trang wiki thông thường) bằng cách truyền tham số.
Có thể được dùng tại dòng lệnh của trình duyệt hoặc trong văn bản wiki.',
	'call-text' => "Phần mở rộng Call mong đợi một trang wiki và những thông số tùy chọn của trang đó là tham số.

Ví dụ 1: &nbsp; <tt>[[{{#special:call}}/Bản mẫu của tôi,tham1=trị1]]</tt><br />
Ví dụ 2: &nbsp; <tt>[[{{#special:call}}/Thảo luận:Thảo luận của tôi,tham1=trị1]]</tt><br />
Ví dụ 3: &nbsp; <tt>[[{{#special:call}}/:Trang của tôi,tham1=trị1,tham2=trị2]]</tt><br />
Ví dụ 4 (URL trình duyệt): &nbsp; <tt>http://tênmiền/wikitôi/index.php?{{#special:call}}/:Trang của tôi,tham1=trị1</tt>

<i>Phần mở rộng Call</i> sẽ gọi trang chỉ định và truyền tham số.<br />
Bạn sẽ nhìn thấy nội dung của trang được gọi cùng với tựa đề của nó nhưng “kiểu” của nó sẽ là một trang đặc biệt, có nghĩa là bạn không thể sửa đổi trang đó.<br />Nội dung bạn nhìn thấy có thể thay đổi tùy theo giá trị tham số bạn truyền vào.

<i>Phần mở rộng Call</i> hữu hiệu trong việc xây dựng những ứng dụng tương tác với MediaWiki.<br />
Xem ví dụ <a href='http://semeb.com/dpldemo/Template:Catlist'>DPL GUI</a>.<br />
Trong trường hợp có vấn đề bạn có thể thử <b>{{#special:call}}/DebuG</b>",
	'call-save' => "Ngõ ra của lần gọi này sẽ được lưu vào trang có tên ''$1''.",
	'call-save-success' => 'Văn bản sau đã được lưu vào trang <big>[[$1]]</big> .',
	'call-save-failed' => 'Văn bản sau KHÔNG được lưu vào trang <big>[[$1]]</big> vì trang đó đã tồn tại.',
);

/** Volapük (Volapük)
 * @author Smeira
 */
$messages['vo'] = array(
	'call' => 'Vokön',
	'call-save' => "Seks voka at padakiponsöv as pad tiädü ''$1''.",
	'call-save-success' => 'Vödem fovik pedakipon su pad: <big>[[$1]]</big>.',
	'call-save-failed' => 'Vödem fovik NO pedakipon su pad: <big>[[$1]]</big> bi pad at ya dabinon.',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 * @author Hydra
 * @author PhiLiP
 */
$messages['zh-hans'] = array(
	'call' => '呼叫',
	'call-desc' => '创建一个超链接到模板（或一般页面）的参数传递。可用于在浏览器的命令行或在wiki文本中使用。',
	'call-text' => '作为参数，调用扩展预计 wiki 页面，该页面的可选参数。<br /><br />

示例一： <tt>[[{{#special:call}}/My template,parm1=value1]]</tt><br />
示例二： <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br />
示例三： <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br />
示例四（浏览器 URL）： <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:My Page,parm1=value1</tt><br /><br />

<i>调用扩展</i> 的将调用给定的页面，并传递参数。<br />
您将看到所调用的页和它的标题的内容，但其 type 将的一个特殊的页面即此类的页面无法编辑。<br />您看到的内容取决于您所传递的参数的值。<br /><br />

<i>调用扩展</i> 的可用于构建具有 MediaWiki 的交互式应用程序。<br />
有关示例，请参见 <a href="http://semeb.com/dpldemo/Template:Catlist">DPL GUI</a>...<br />
问题的情况下，您可以尝试 <b>{{#special:call}}/DebuG</b>',
	'call-save' => '本呼叫的输出将保存至名为“$1”的页面内。',
	'call-save-success' => '以下文字经已保存至页面<big>[[$1]]</big>。',
	'call-save-failed' => '由于页面已存在，以下文字并未保存至页面<big>[[$1]]</big>。',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Horacewai2
 * @author Mark85296341
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'call' => '呼叫',
	'call-desc' => '建立一個超連結到模板（或一般頁面）的參數傳遞。可用於在瀏覽器的命令行或在維基文字中使用。',
	'call-text' => '作為參數，調用擴展預計 wiki 頁面，該頁面的可選參數。<br /><br />

示例一： <tt>[[{{#special:call}}/My template,parm1=value1]]</tt><br />
示例二： <tt>[[{{#special:call}}/Talk:My Discussion,parm1=value1]]</tt><br />
示例三： <tt>[[{{#special:call}}/:My Page,parm1=value1,parm2=value2]]</tt><br />
示例四（瀏覽器 URL）： <tt>http://mydomain/mywiki/index.php?{{#special:call}}/:My Page,parm1=value1</tt><br /><br />

<i>調用擴展</i> 的將調用給定的頁面，並傳遞參數。<br />
您將看到所調用的頁和它的標題的內容，但其 type 將的一個特殊的頁面即此類的頁面無法編輯。<br />您看到的內容取決於您所傳遞的參數的值。<br /><br />

<i>調用擴展</i> 的可用於構建具有 MediaWiki 的交互式應用程序。<br />
有關示例，請參見 <a href="http://semeb.com/dpldemo/Template:Catlist">DPL GUI</a>...<br />
問題的情況下，您可以嘗試 <b>{{#special:call}}/DebuG</b>',
	'call-save' => '本呼叫的輸出將儲存至名為「$1」的頁面內。',
	'call-save-success' => '以下文字經已儲存至頁面<big>[[$1]]</big>。',
	'call-save-failed' => '由於頁面已存在，以下文字並未儲存至頁面<big>[[$1]]</big>。',
);

/** Chinese (Hong Kong) (‪中文(香港)‬)
 * @author Oapbtommy
 */
$messages['zh-hk'] = array(
	'call' => '呼叫',
);

