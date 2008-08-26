<?php
/*
 * Internationalization file for Call Extension
 *
 * @addGroup Extension
 */

$messages = array();

$messages['en'] = array(
	'call' => 'Call',
	'call-desc' => 'Create a hyperlink to a template (or to a normal wiki page) with parameter passing.
Can be used at the browser’s command line or within wiki text.',
	'call-text' => 'The Call extension expects a wiki page and optional parameters for that page as an argument.

Example 1: &nbsp; <tt>[[Special:Call/My Template,parm1=value1]]</tt><br />
Example 2: &nbsp; <tt>[[Special:Call/Talk:My Discussion,parm1=value1]]</tt><br />
Example 3: &nbsp; <tt>[[Special:Call/:My Page,parm1=value1,parm2=value2]]</tt><br />
Example 4 (Browser URL): &nbsp; <tt>http://mydomain/mywiki/index.php?Special:Call/:My Page,parm1=value1</tt>

The <i>Call extension</i> will call the given page and pass the parameters.<br />
You will see the contents of the called page and its title but its \'type\' will be that of a special page, i.e. such a page cannot be edited.<br />The contents you see may vary depending on the value of the parameters you passed.

The <i>Call extension</i> is useful to build interactive applications with MediaWiki.<br />
For an example see <a href=\'http://semeb.com/dpldemo/Template:Catlist\'>the DPL GUI</a> ..<br />
In case of problems you can try <b>Special:Call/DebuG</b>',
	'call-save' => 'The output of this call would be saved to a page called \'\'$1\'\'.',
	'call-save-success' => 'The following text has been saved to page <big>[[$1]]</big> .',
	'call-save-failed' => 'The following text has NOT been saved to page <big>[[$1]]</big> because that page already exists.',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'call' => 'Roep',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'call'              => 'استدعاء',
	'call-desc'         => 'ينشيء وصلة فائقة لقالب (أو لصفحة ويكي عادية) مع تمرير المحددات. يمكن استخدامها في سطر أوامر المتصفح أو خلال نص الويكي.',
	'call-text'         => "امتداد الاستدعاء يتوقع صفحة ويكي ومحددات اختيارية لهذه الصفحة كمدخلات.<br /><br />
مثال 1: &nbsp; <tt>[[Special:Call/My Template,parm1=value1]]</tt><br />
مثال 2: &nbsp; <tt>[[Special:Call/Talk:My Discussion,parm1=value1]]</tt><br />
مثال 3: &nbsp; <tt>[[Special:Call/:My Page,parm1=value1,parm2=value2]]</tt><br /><br />
مثال 4 (مسار متصفح): &nbsp; <tt>http://mydomain/mywiki/index.php?Special:Call/:My Page,parm1=value1</tt><br /><br />

<i>امتداد الاستدعاء</i> سيستدعي الصفحة المعطاة ويمرر المحددات.<br />سترى محتويات الصفحة المستدعاة وعنوانها ولكن 'نوعها' سيكون ذلك الخاص بصفحة خاصة,<br />أي أن صفحة مثل هذه لا يمكن تعديلها.<br />المحتويات التي تراها ربما تتغير على حسب قيمة المحددات التي مررتها.<br /><br />
<i>امتداد الاستدعاء</i> مفيد في بناء تطبيقات تفاعلية مع الميدياويكي.<br />لمثال انظر <a href='http://semeb.com/dpldemo/Template:Catlist'>DPL GUI</a> ..<br />
في حالة وجود مشكلات يمكنك محاولة <b>Special:Call/DebuG</b>",
	'call-save'         => "ناتج هذا الاستدعاء سيتم حفظه في صفحة اسمها ''$1''.",
	'call-save-success' => 'النص التالي تم حفظه لصفحة <big>[[$1]]</big> .',
	'call-save-failed'  => 'النص التالي لم يتم حفظه لصفحة <big>[[$1]]</big> لأن هذه الصفحة موجودة بالفعل.',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ramsis1978
 */
$messages['arz'] = array(
	'call' => 'نادي',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'call'              => 'Извикване',
	'call-save-success' => 'Следният текст беше съхранен на страницата <big>[[$1]]</big> .',
	'call-save-failed'  => 'Следният текст НЕ БЕШЕ съхранен на страницата <big>[[$1]]</big>, тъй като тя вече съществува.',
);

/** Bengali (বাংলা)
 * @author Zaheen
 */
$messages['bn'] = array(
	'call'              => 'কল',
	'call-desc'         => 'প্যারামিটার পাস করে কোন টেম্পলেটের (বা সাধারণ উইকি পাতার) দিকে একটি সংযোগ সৃষ্টি করুন। ব্রাউজারের কমান্ড লাইনে কিংবা উইকি টেক্সটের ভেতরে ব্যবহার করা যাবে।',
	'call-text'         => "কল এক্সটেনশনটি আর্গুমেন্ট হিসেবে কোন উইকি পাতা এবং সেই পাতার জন্য ঐচ্ছিক প্যারামিটারসমূহ প্রত্যাশা করে।<br /><br />
উদাহরণ ১: &nbsp; <tt>[[Special:Call/My Template,parm1=value1]]</tt><br />
উদাহরণ ২: &nbsp; <tt>[[Special:Call/Talk:My Discussion,parm1=value1]]</tt><br />
উদাহরণ ৩: &nbsp; <tt>[[Special:Call/:My Page,parm1=value1,parm2=value2]]</tt><br /><br />
উদাহরণ ৪ (ব্রাউজার URL): &nbsp; <tt>http://mydomain/mywiki/index.php?Special:Call/:My Page,parm1=value1</tt><br /><br />

<i>কল এক্সটেনশন</i> প্রদত্ত পাতাটিকে কল করবে এবং প্যারামিটার সরবরাহ করবে।<br />আপনি কল করা পাতা ও তার শিরোনাম দেখতে পাবেন কিন্তু পাতাটির 'টাইপ' হবে বিশেষ পাতার টাইপ,<br />অর্থাৎ এই পাতাটি সম্পাদনা করা যাবে না।<br />আপনি কী বিষয়বস্তু দেখতে পাবেন তা নির্ভর করবে আপনার সরবরাহকৃত প্যারামিটারের মানগুলির উপর।<br /><br />
<i>কল এক্সটেনশন</i> মিডিয়াউইকির সাথে মিথস্ক্রিয়াশীল অ্যাপ্লিকেশন তৈরিতে কাজে লাগতে পারে। <br />উদাহরণের জন্য দেখুন <a href='http://semeb.com/dpldemo/Template:Catlist'>ডিপিএল গুই</a> ..<br />
কোন সমস্যা হলে আপনি <b>Special:Call/DebuG</b> ব্যবহার করতে পারেন",
	'call-save'         => "এই কলটির আউটপুট ''$1'' নামের পাতায় সংরক্ষণ করা হবে।",
	'call-save-success' => '<big>[[$1]]</big> পাতায় নিচের টেক্সট সংরক্ষণ করা হয়েছে।',
	'call-save-failed'  => '<big>[[$1]]</big> পাতায় নিচের টেক্সট সংরক্ষণ করা হয়নি, কারণ পাতাটি ইতিমধ্যেই বিদ্যমান।',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'call'              => 'Galv',
	'call-desc'         => 'Krouiñ a ra ur gourliamm davet ur patrom (pe ur pennad wiki boutin) en ur dremen arventennoù drezañ. Gallout a ra bezañ implijet evel linenn urzhiad adal ur merdeer pe e testenn ur wiki.',
	'call-text'         => "Ezhomm en deus an astenn galv eus ur bajenn wiki hag eus an arventennoù diret eviti.<br /><br />
Skouer 1: &nbsp; <tt>[[Special:Call/Ma fatrom,parm1=value1]]</tt><br />
Skouer 2: &nbsp; <tt>[[Special:Call/Kaozeal:Ma c'haozeadenn,parm1=value1]]</tt><br />
Skouer 3: &nbsp; <tt>[[Special:Call/:Ma fajenn,parm1=value1,parm2=value2]]</tt><br /><br />
Skouer 4 (chomlec'h evit merdeer): &nbsp; <tt>http://madomani/mywiki/index.php?Special:Call/:Ma fajenn,parm1=value1</tt><br /><br />

Gervel a raio an astenn <i>Galv</i> ar bajenn merket en ur dremen an arventennoù drezi.<br />Gwelout a reot danvez ar bajenn hag an titl anezhi met 'tres' ur bajenn zibar a vo warni<br />ha n'hallo ket kemmoù bezañ degaset warni.<br />An titouroù a vo warni a vo diouzh talvoud an arventennoù bet merket ganeoc'h.<br /><br />
Emsav-kenañ eo an <i>Astenn Galv</i> evit sevel arloadoù etregwezhiat gant MediaWiki.<br />Da skouer, gwelet <a href='http://semeb.com/dpldemo/Template:Catlist'>the DPL GUI</a> ..<br />
M'ho pez kudennoù e c'hallit klask ober gant <b>Special:Call/DebuG</b>",
	'call-save'         => "Gallout a rafe ar pezh zo merket gant ar galv-mañ bezañ enrollet en ur bajenn anvet ''$1''.",
	'call-save-success' => 'Enrollet eo bet an destenn da-heul war ar bajenn <big>[[$1]]</big> .',
	'call-save-failed'  => "N'EO KET BET enrollet an destenn da-heul war ar bajenn <big>[[$1]]</big> rak bez'ez eus anezhi c'hoazh.",
);

/** Czech (Česky)
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'call'              => 'Call',
	'call-desc'         => 'Vytvoří hyperodkaz na šablonu (nebo na běžnou wiki stránku) s odevzdáním parametrů. Je možné použít z řádku s adresou v prohlížečí nebo ve wiki textu.',
	'call-text'         => "Doplněk Call očekává jako argumenty wiki stránku a volitelné parametry dané stránky.<br /><br />
Příklad 1: &nbsp; <tt>[[Special:Call/Moje šablona,parm1=value1]]</tt><br />
Příklad 2: &nbsp; <tt>[[Special:Call/Diskuse:Moje diskuse,parm1=value1]]</tt><br />
Příklad 3: &nbsp; <tt>[[Special:Call/:Moje stránka,parm1=value1,parm2=value2]]</tt><br /><br />
Příklad 4 (URL prohlížeče): &nbsp; <tt>http://mojedomena/mojewiki/index.php?Special:Call/:Moje stránka,parm1=value1</tt><br /><br />

<i>Doplněk Call</i> zavolá danbou stránku a odevzdá jí parametry.<br />
Uvidíte obsah zavolané stránky a její název, ale její 'typ' bude speciální stránka,<br />tj. takovou stránku není možné uprovat.<br />
Obsah, který uvidíte se může lišit v závislosti na parametrech, které jste odevzdali.<br /><br />
<i>Doplněk Call</i> je užitečný při budovaní interaktivních aplikací pomocí MediaWiki.<br />
Jako příklad se můžete podívat na <a href='http://semeb.com/dpldemo/Template:Catlist'>GUI DPL</a> ..<br />
V případě problémů můžete zkusit <b>Special:Call/DebuG</b>",
	'call-save'         => "Výstup této stránky byl uložen do stránky s názvem ''$1''.",
	'call-save-success' => 'Následující text byl uložený do stránky <big>[[$1]]</big>',
	'call-save-failed'  => "Následující text NEBYL uložený do stránky ''$1'', protože tato stránka už existuje.",
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'call'              => 'Voki',
	'call-save'         => "La eligo de ĉi tiu voko estus konservita al paĝo nomata ''$1''.",
	'call-save-success' => 'La jena teksto estis konservita al paĝo <big>[[$1]]</big> .',
	'call-save-failed'  => 'La jena teksto NE estis konservita al paĝo <big>[[$1]]</big> ĉar tiu paĝo jam ekzistas.',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 */
$messages['fi'] = array(
	'call-save-success' => 'Tämä teksti on tallennettu sivulle <big>[[$1]]</big> .',
);

/** French (Français)
 * @author Urhixidur
 * @author Grondin
 */
$messages['fr'] = array(
	'call'              => 'Appel',
	'call-desc'         => 'Crée un lien hypertexte vers un modèle ou un article wiki normal tout en passant des paramètres. Elle peut être utilisée en ligne de commande depuis un navigateur ou à travers un texte wiki.',
	'call-text'         => "L’extension Appel a besoin d’une page wiki et des paramètres facultatifs pour cette dernière comme argument.<br /><br />
Exemple 1: &nbsp; <tt>[[Special:Call/Mon modèle,parm1=value1]]</tt><br />
Exemple 2: &nbsp; <tt>[[Special:Call/Discussion:Ma discussion,parm1=value1]]</tt><br />
Exemple 3: &nbsp; <tt>[[Special:Call/:Ma page,parm1=value1,parm2=value2]]</tt><br /><br />
Exemple 4 (Adresse pour navigateur) : &nbsp; <tt>http://mondomaine/monwiki/index.php?Special:Call/:Ma_Page,parm1=value1</tt><br /><br />

L’extension <i>Appel</i> appellera la page indiquée en lui passant les paramètres.<br />Vous verrez les informations de cette page, son titre, mais son « type » sera celui d’une page spéciale qui ne pourra pas être éditée.<br />Les informations que vous verrez varieront en fonction des paramètres que vous aurez indiqués.<br />Cette extension est très pratique pour créer des applications interactives avec MediaWiki.<br />À titre d’exemple, voyez <a href='http://semeb.com/dpldemo/Template:Catlist'>the DPL GUI</a> ..<br />En cas de problèmes, vous pouvez essayer <b>Special:Call/DebuG</b>",
	'call-save'         => "Ce qui est indiqué par cet appel pourrait être sauvé vers une page intitulée ''$1''.",
	'call-save-success' => 'Le texte suivant a été sauvegardé vers la page <big>[[$1]]</big> .',
	'call-save-failed'  => 'Le texte suivant n’a pu être sauvergardé vers la page <big>[[$1]]</big> du fait qu’elle existe déjà.',
);

/** Galician (Galego)
 * @author Xosé
 * @author Toliño
 * @author Alma
 */
$messages['gl'] = array(
	'call'              => 'Chamada',
	'call-desc'         => 'Crear unha ligazón cara a un modelo (ou cara a unha páxina normal dun wiki) con pasaxe de parámetros.
Pode ser usado na liña de comandos do navegador ou dentro do texto dun wiki.',
	'call-text'         => "A extensión Call agarda unha páxina dun wiki e parámetros opcionais para esa páxina como argumentos.

Exemplo 1: &nbsp; <tt>[[Special:Call/My Template,parm1=value1]]</tt><br />
Exemplo 2: &nbsp; <tt>[[Special:Call/Talk:My Discussion,parm1=value1]]</tt><br />
Exemplo 3: &nbsp; <tt>[[Special:Call/:My Page,parm1=value1,parm2=value2]]</tt><br />
Exemplo 4 (URL do navegador): &nbsp; <tt>http://mydomain/mywiki/index.php?Special:Call/:My Page,parm1=value1</tt>

A <i>extensión Call</i> chamará á páxina dada e pasaralle os parámetros.<br />
Poderá ver os contidos da páxina chamada e o seu título, pero o seu 'tipo' será o dunha páxina especial, isto é, a devandita páxina non poderá ser editada.<br />Os contidos que ve poden variar dependendo do valor dos parámetros que pasou.

A <i>extensión Call</i> é útil para construír aplicacións interactivas con MediaWiki.<br />
Para ver un exemplo, visite <a href='http://semeb.com/dpldemo/Template:Catlist'>o DPL GUI</a>...<br />
En caso de que haxa algún problema pode probar con <b>Special:Call/DebuG</b>",
	'call-save'         => "A saída desta chamada gardaríase nunha páxina chamada ''$1''.",
	'call-save-success' => 'O texto seguinte gardouse na páxina <big>[[$1]]</big>.',
	'call-save-failed'  => 'O texto seguinte NON se gardou na páxina <big>[[$1]]</big> porque xa existe esa páxina.',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'call'              => 'कॉल',
	'call-desc'         => 'एक टेम्प्लेटसे (या साधारण विकिपन्ने से) जुडने वाली और कुछ पॅरॅमीटरके मिलने के बाद ही इस्तेमाल में आने वाली कड़ी बनायें।
यह कड़ी ब्राउज़रके कमांड लाईनमें अथवा विकिसंज्ञाओं द्वारा इस्तेमाल की जा सकती हैं।',
	'call-text'         => "कॉल एक्स्टेंशन के लिये एक विकि पृष्ठ और उसके अन्य पॅरॅमीटर अर्ग्युमेंटमें दिये हुए होने आवश्यक हैं।<br /><br />
उदाहरण १: &nbsp; <tt>[[Special:Call/My Template,parm1=value1]]</tt><br />
उदाहरण २: &nbsp; <tt>[[Special:Call/Talk:My Discussion,parm1=value1]]</tt><br />
उदाहरण ३: &nbsp; <tt>[[Special:Call/:My Page,parm1=value1,parm2=value2]]</tt><br /><br />
उदाहरण ४ (ब्राउझर URL): &nbsp; <tt>http://mydomain/mywiki/index.php?Special:Call/:My Page,parm1=value1</tt><br /><br />

<i>कॉल क्रिया</i> उस विशिष्ट पृष्ठ को मंगाकर दिये हुए पॅरॅमीटर्स जाँच लेगी।<br />आप उस पन्नेका शीर्षक तथा पाठ देख सकतें हैं पर उसका 'प्रकार' विशेष पॄष्ठ ही रहेगा,<br />मतलब उसे आप बदल नहीं सकतें हैं।<br />आपको दिखने वाला पाठ जितने पॅरॅमीटर्स मिलेंगे उसके हिसाब से बदल सकता हैं।<br /><br />
<i>कॉल क्रिया</i> यह मीडियाविकीको संलग्न ऍप्लीकेशन लिखनेके लिये उपयुक्त हैं।<br />उदाहरणके लिये देखें <a href='http://semeb.com/dpldemo/Template:Catlist'>डीपीएल जीयूआय</a> ..<br />
कोई भी समस्या आने पर आप <b>Special:Call/DebuG</b> का इस्तेमाल करके देख सकतें हैं।",
	'call-save'         => "इस कॉलका आउटपुट ''$1'' नाम के पन्नेपर दर्ज किया जायेगा।",
	'call-save-success' => 'नीचे दिया हुआ पाठ <big>[[$1]]</big> नामके पन्नेपर दर्ज किया गया हैं।',
	'call-save-failed'  => 'नीचे का पाठ <big>[[$1]]</big> इस पन्ने पर संजोया नहीं गया हैं, क्योंकि यह पन्ना पहले से अस्तित्वमें हैं।',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'call'              => 'Wołać',
	'call-desc'         => 'Wotkaz k předłoze (abo k normalnej wikijowej stronje) z přepodaću parametrow wutworić. Da so w přikazowej lince wobhladowaka abo znutřka wikijoweho teksta wužiwać.',
	'call-text'         => "Rozšěrjenja Call wočakuje wiki-stronu a opcionalne parametry za tutu stronu jako argument.<br /><br />
Přikład 1: &nbsp; <tt>[[Special:Call/My Template,parm1=value1]]</tt><br />
Přikład 2: &nbsp; <tt>[[Special:Call/Talk:My Discussion,parm1=value1]]</tt><br />
Přikład 3: &nbsp; <tt>[[Special:Call/:My Page,parm1=value1,parm2=value2]]</tt><br /><br />
Přikład 4 (URL wobhladowaka): &nbsp; <tt>http://mydomain/mywiki/index.php?Special:Call/:My Page,parm1=value1</tt><br /><br />

<i>Rozšěrjenje Call</i> budźe datu stronu podać a parametry přepodać.<br />Budźeš wobsah zwołaneje strony a jeje titul widźeć, ale jeje 'typ' budźe tón specialneje strony, <br />t.r. tajka strona njeda so wobdźěłować.<br />Wobsah, kotryž widźiš, móže, wotwisujo wot hódnoty parametrow, kotruž sy přepodał, wariěrować.<br /><br />
<i>Rozšěrjenje Call</i> je wužitne, zo bychu so interaktiwne aplikacije z MediaWiki tworili.<br /> Za přikład hlej <a href='http://semeb.com/dpldemo/Template:Catlist'>DPL GUI</a> ..<br /> W padźe problemow móžeš <b>Special:Call/DebuG</b> spytać.",
	'call-save'         => "Wudaće tutoho zwołanja by so na stronu z mjenom ''$1'' składowało.",
	'call-save-success' => 'Slědowacy tekst bu na stronu <big>[[$1]]</big> składował.',
	'call-save-failed'  => 'Slědowacy tekst NJEje so na stronu <big>[[$1]]</big> składował, dokelž ta strona hižo eksistuje.',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'call'              => 'Hívás',
	'call-desc'         => 'Lehetővé teszi sablon (vagy egy normális wiki lap) meghívását paraméterátadással.
Használható a böngésző címsorából, vagy a wikiszövegben is.',
	'call-text'         => "A kiegészítőnek meg kell adni egy wiki oldalt és kiegészítő paramétereket ahhoz az oldalhoz.<br /><br />
1. példa: &nbsp; <tt>[[Special:Call/Sablon neve,parm1=érték1]]</tt><br />
2. példa: &nbsp; <tt>[[Special:Call/Vita:Vitalapom,parm1=érték1]]</tt><br />
3. példa: &nbsp; <tt>[[Special:Call/:Az én lapom,parm1=érték1,parm2=érték2]]</tt><br /><br />
4. példa (URL a böngészőben): &nbsp; <tt>http://mydomain/mywiki/index.php?Special:Call/:Az én lapom,parm1=érték1</tt><br /><br />

A kiegészítő meghívja az adott oldalt, és átadja neki a megadott paramétereket.<br />Láthatod a lap tartalmát, és a címét is, de a 'típusa' speciális lap lesz,<br />amit nem lehet szerkeszteni.<br />A lap tartalma változhat az általad megadott paraméterektől függően.<br /><br />
Hasznos lehet interaktív alkalmazások építésére a MediaWikivel.<br />Példának lásd <a href='http://semeb.com/dpldemo/Template:Catlist'>a DPL GUI</a>-t.<br />
Probléma esetén megpróbálhatod a <b>Special:Call/DebuG</b> használatát",
	'call-save'         => "A hívás kimenetét el lehet menteni egy ''$1'' nevű lapra.",
	'call-save-success' => 'A következő szöveg el lett mentve <big>[[$1]]</big> néven.',
	'call-save-failed'  => 'A következő szöveg NEM lett elmentve, mert már létezik <big>[[$1]]</big> nevű lap.',
);

/** Japanese (日本語)
 * @author JtFuruhata
 */
$messages['ja'] = array(
	'call'              => 'ページ呼び出し',
	'call-desc'         => 'テンプレート（または普通のウィキページ）にパラメータを渡すハイパーリンクを作成できます。ブラウザのアドレス欄やウィキテキスト内部でも利用可能です。',
	'call-text'         => "ページ呼び出しエクステンションは、あるウィキページに、そのページが取る引数であるオプションパラメータが設定されていることを想定しています。<br /><br />
例1: &nbsp; <tt>[[Special:Call/My Template,parm1=value1]]</tt><br />
例2: &nbsp; <tt>[[Special:Call/Talk:My Discussion,parm1=value1]]</tt><br />
例3: &nbsp; <tt>[[Special:Call/:My Page,parm1=value1,parm2=value2]]</tt><br /><br />
例4 (ブラウザURL): &nbsp; <tt>http://mydomain/mywiki/index.php?Special:Call/:MyPage,parm1=value1</tt><br /><br />

<i>ページ呼び出しエクステンション</i> は、与えられたページをパラメータ付きで呼び出します。<br />あなたは呼び出されたページ内容とタイトルを見ることはできますが、'ページのタイプ'は特別ページ、<br />つまりそのページを編集することはできません。<br />ページ内容は指定したパラメータによって変化します。<br /><br />

<i>ページ呼び出しエクステンション</i> は、MediaWiki上でインタラクティブなアプリケーションを構築するのに便利です。<br />[http://semeb.com/dpldemo/Template:Catlist the DPL GUI]を参考にしてください。<br />
問題が発生した場合は、<b>[[Special:Call/DebuG]]</b> をお試しください。",
	'call-save'         => "このページ呼び出し結果は、ページ ''$1'' として保存されます。",
	'call-save-success' => '以下のテキストが、ページ <big>[[$1]]</big> として保存されました。',
	'call-save-failed'  => "以下のテキストは、既に同名のページが存在するため、ページ <big>[[$1]]</big> として'''保存されませんでした'''。",
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'call'              => 'Celuk',
	'call-desc'         => 'Nggawé pranala menyang sawijining cithakan (utawa kaca wiki biasa) nganggo paramèter.
Bisa dienggo ing baris paréntah panjlajah utawa sajroning tèks wiki.',
	'call-save'         => "Kasil panyelukan iki bakal disimpen ing sawijining kaca sing diarani ''$1''.",
	'call-save-success' => 'Tèks sing kapacak ing ngisor iki wis disimpen ing kaca <big>[[$1]]</big> .',
	'call-save-failed'  => 'Tèks ing ngisor iki ORA disimpen ing kaca <big>[[$1]]</big> amerga kaca iku wis ana.',
);

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'call-save-success' => 'អត្ថបទដូចតទៅនេះត្រូវបានរក្សាទុកទៅក្នុងទំព័រ <big>[[$1]]</big>។',
	'call-save-failed'  => 'អត្ថបទដូចតទៅនេះមិនត្រូវបានរក្សាទុកទៅក្នុងទំព័រ <big>[[$1]]</big> ពីព្រោះទំព័រនោះមានរួចហើយ។',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'call'              => 'Opruff',
	'call-desc'         => 'Mecht een Hyperlink op eng Schabloun (oder eng normal wiki-Säit) mat der Benotzung vu Parameteren. Kann an der Kommandozeil vum Browser oder am Wiki-Text benotzt ginn.',
	'call-save'         => "D'Resultat vun dësem Opruff géif op der Säit '''$1''' gespäichert ginn.",
	'call-save-success' => 'Dësen Text gouf op der Säit <big>[[$1]]</big> gespäichert.',
	'call-save-failed'  => 'Dësen Text konnt NET op der Säit <big>[[$1]]</big> ofgespäichert ginn, well et dës Säit scho gëtt.',
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'call' => 'Kalle',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'call'              => 'വിളിക്കുക',
	'call-save-success' => 'താഴെ പ്രദര്‍ശിപ്പിച്ചിരിക്കുന്ന ടെക്സ്റ്റ് <big>[[$1]]</big> എന്ന താളിലേക്ക് സേവ് ചെയ്തിരിക്കുന്നു.',
	'call-save-failed'  => 'താഴെ പ്രദര്‍ശിപ്പിച്ചിരിക്കുന്ന ടെക്സ്റ്റ് <big>[[$1]]</big> എന്ന താള്‍ മുന്‍പേ നിലവിലുള്ളതിനാല്‍ സേവ് ചെയ്യുന്നതിനു സാധിച്ചില്ല.',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'call'              => 'बोलवा (मागवा)',
	'call-desc'         => 'एखाद्या साचा (अथवा पानाशी) जोडणारा व काही पॅरॅमीटर जुळल्यानंतरच वापरता येणारा दुवा तयार करते. हा दुवा ब्राउझरच्या कमांड लाईन अथवा विकि संज्ञांच्या माध्यमातून वापरता येतो.',
	'call-text'         => "कॉल ही क्रिया करण्यासाठी एक विकि पान व त्याचे इतर पॅरॅमीटर अर्ग्युमेंटमध्ये दिलेले असणे
आवश्यक आहे.<br /><br />
उदाहरण १: &nbsp; <tt>[[Special:Call/My Template,parm1=value1]]</tt><br />
उदाहरण २: &nbsp; <tt>[[Special:Call/Talk:My Discussion,parm1=value1]]</tt><br />
उदाहरण ३: &nbsp; <tt>[[Special:Call/:My Page,parm1=value1,parm2=value2]]</tt><br /><br />
उदाहरण ४ (ब्राउझर URL): &nbsp; <tt>http://mydomain/mywiki/index.php?Special:Call/:My Page,parm1=value1</tt><br /><br />

<i>कॉल क्रिया</i> ते विशिष्ट पान मागवून दिलेले पॅरॅमीटर्स तपासून पाहील.<br />तुम्ही त्या पानाचे शीर्षक तसेच मजकूर पाहू शकता पण त्याचा 'प्रकार' विशेष पान असा राहील,,<br />म्हणजेच ते पान संपादित करता येणार नाही.<br />तुम्हाला दिसत असलेला मजकूर किती पॅरॅमीटर्स जुळले त्याप्रमाणे बदलू शकतो.<br /><br />
<i>कॉल क्रिया</i> ही मीडियाविकीशी संलग्न असणारी ऍप्लीकेशन लिहिण्यासाठी उपयुक्त आहे..<br />उदाहरणासाठी पहा <a href='http://semeb.com/dpldemo/Template:Catlist'>डीपीएल जीयूआय</a> ..<br />
काही अडचणी आल्यास आल्यास तुम्ही <b>Special:Call/DebuG</b> वापरून पाहू शकता",
	'call-save'         => "या कॉल क्रियेचा निकाल ''$1'' या नावाच्या पानावर नोंदला जाईल.",
	'call-save-success' => 'खालील मजकूर <big>[[$1]]</big> या पानावर जतन केलेला आहे.',
	'call-save-failed'  => 'खालील मजकूर <big>[[$1]]</big> या पानावर जतन केलेला नाही, कारण ते पान अगोदरच अस्तित्वात आहे.',
);

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = array(
	'call-save-success' => 'Dan it-test segwenti kien salvat fuq il-paġna <big>[[$1]]</big>.',
	'call-save-failed'  => 'Dan it-test segwenti ma ġiex salvat fuq il-paġna <big>[[$1]]</big> minħabba li din il-paġna diġà teżisti.',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'call'              => 'Aanroepen',
	'call-desc'         => 'Maak een hyperlink naar een sjabloon (of naar een normale wikipagina) met gebruik van parameters.
Kan gebruikt worden in de adresregel van de browser of in wikitekst.',
	'call-text'         => "De uitbreiding Aanroepen (Call) verwacht een wikipagina en optioneel parameters voor die pagina.

Voorbeeld 1: &nbsp; <tt>[[Special:Call/My Template,parm1=value1]]</tt><br />
Voorbeeld 2: &nbsp; <tt>[[Special:Call/Talk:My Discussion,parm1=value1]]</tt><br />
Voorbeeld 3: &nbsp; <tt>[[Special:Call/:My Page,parm1=value1,parm2=value2]]</tt><br /><br />
Voorbeeld 4 (Browser URL): &nbsp; <tt>http://mydomain/mywiki/index.php?Special:Call/:My Page,parm1=value1</tt>

De <i>uitbreiding Aanroepen</i> roept de opgegeven pagina aan en geeft de parameters door.<br />
U krijgt de inhoud van de aangeroepen pagina te zien en de naam, maar deze is van het 'type' speciale pagina, dat wil zeggen dat de pagina niet bewerkt kan worden.<br />
De inhoud die u te zien krijgt kan verschillen, afhankelijk van de parameters die u hebt meegegeven.

De <i>uitbreiding Aanroepen</i> kan behulpzaam zijn bij het bouwen van interactieve applicaties met MediaWiki.
De <a href='http://semeb.com/dpldemo/Template:Catlist'>DPL GUI</a> is daar een voorbeeld van.<br />
Bij problemen kunt u gebruik maken van <b>Special:Call/DebuG</b>",
	'call-save'         => "De uitvoer van deze aanroep zou opgeslagen zijn in de pagina ''$1''.",
	'call-save-success' => 'De volgende tekst is opgeslagen in pagina <big>[[$1]]</big>.',
	'call-save-failed'  => 'De volgende tekst is NIET opgeslagen in pagina <big>[[$1]]</big> omdat die pagina al bestaat.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'call'              => 'Kall opp',
	'call-desc'         => 'Gir mulighet til å skape linker til maler (eller vanlige wikisider) med angitte parametre. Lenkene kan brukes i nettleserens adressefelt eller i wikitekst.',
	'call-text'         => 'Utvidelsen Kall opp (Call) forventer seg at en wikiside og valgfrie parametere for den siden angis som et argument.<br /><br />
Eksempel 1: &nbsp; <tt>[[Special:Call/Min mal,parm1=verdi1]]</tt><br />
Eksempel 2: &nbsp; <tt>[[Special:Call/Talk:Min diskusjonsside,parm1=verdi1]]</tt><br /><br />
Eksempel 3: &nbsp; <tt>[[Special:Call/:Min side,parm1=verdi1,parm2=verdi2]]</tt><br /><br />
Eksempel 4 (URL for adressefeltet): &nbsp; <tt>http://mittdomene/minwiki/index.php?Special:Call/:Min_side,parm1=verdi1</tt><br /><br />

<i>Kall opp</i>-tillegget anroper den angitte siden og sender med parameterne.<br />Du kommer til å se den anropte sidens innhold og tittel, men siden som vises er en spesialside og kan derfor ikke redigeres.<br />
Innholdet som vises kan variere avhengig av verdiene til de parameterne som sendes med.<br /><br />
Tillegget <i>Kall opp</i> kan brukes for å skape interaktive applikasjoner med MediaWiki.<br />
Se for eksempel <a href="http://semeb.com/dpldemo/Template:Catlist">grensesnittet for DPL</a><br />
Om du har noen problemer kan du prøve <b>Special:Call/DebuG</b>.',
	'call-save'         => "Resultatet av denne oppkallingen ville blitt lagret på en side ved navn ''$1''.",
	'call-save-success' => 'Følgende tekst har blitt lagret på siden <big>[[$1]]</big>.',
	'call-save-failed'  => 'Følgende tekst har IKKE blitt lagret på siden <big>[[$1]]</big> fordi siden allerede finnes.',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'call'              => 'Ampèl',
	'call-desc'         => 'Crèa un ligam ipertèxt vèrs un modèl o un article wiki normals tot i passant de paramètres. Pòt èsser utilizada en linha de comanda dempuèi un navigador o a travèrs un tèxt wiki.',
	'call-text'         => "L’extension Ampèl a besonh d’una pagina wiki e de paramètres facultatius per aquesta darrièra.<br /><br />
Exemple 1: &nbsp; <tt>[[Special:Call/Mon modèl,parm1=value1]]</tt><br />
Exemple 2: &nbsp; <tt>[[Special:Call/Discussion:Ma discussion,parm1=value1]]</tt><br />
Exemple 3: &nbsp; <tt>[[Special:Call/:Ma pagina,parm1=value1,parm2=value2]]</tt><br /><br />
Exemple 4 (Adreça per navigador) : &nbsp; <tt>http://mondomeni/monwiki/index.php?Special:Call/:Ma_Pagina,parm1=value1</tt><br /><br />

L’extension <i>Ampèl</i> apelarà la pagina indicada en i passant los paramètres.<br />Veiretz las entresenhas d'aquesta pagina, son títol, mas son « tipe » serà lo d’una pagina especiala mas poirà pas èsser editada.<br />Las entresenhas que veiretz variaràn en foncion dels paramètres qu'auretz indicats.<br />Aquesta extension es fòrt practica per crear d'aplicacions interactivas amb MediaWiki.<br />A títol d’exemple, vejatz <a href='http://semeb.com/dpldemo/Template:Catlist'>the DPL GUI</a> ..<br />En cas de problèmas, podètz ensajar <b>Special:Call/DebuG</b>",
	'call-save'         => "Çò qu'es indicat per aqueste ampèl poiriá èsser salvat vèrs una pagina intitolada ''$1''.",
	'call-save-success' => 'Lo tèxt seguent es estat salvat vèrs la pagina <big>[[$1]]</big> .',
	'call-save-failed'  => 'Lo tèxt seguent a pogut èsser salvargardat vèrs la pagina <big>[[$1]]</big> del fach qu’existís ja.',
);

/** Polish (Polski)
 * @author Sp5uhe
 * @author Holek
 */
$messages['pl'] = array(
	'call'              => 'Wywołaj z parametrem',
	'call-desc'         => 'Tworzy hiperłącze do szablonu (oraz strony w każdej przestrzeni nazw) z przesłaniem parametrów.
Funkcjonalność może być wykorzystana bezpośrednio w wikitekście lub jako adres dla pokazania możliwości szablonu/strony.',
	'call-text'         => "Rozszerzenie <i>Wywołaj z parametrem</i> wywołuje się podając jako argument nazwę strony oraz opcjonalnie parametry wywołania dla tej strony.

Przykład 1: &nbsp; <tt>[[Specjalna:Wywołaj z parametrem/Mój szablon,parametr1=wartość1]]</tt><br />
Przykład 2: &nbsp; <tt>[[Specjalna:Wywołaj z parametrem/Dyskusja:Moja dyskusja,parametr1=wartość1]]</tt><br />
Przykład 3: &nbsp; <tt>[[Specjalna:Wywołaj z parametrem/:Moja strona,parametr1=wartość1,parametr2=wartość2]]</tt><br />
Przykład 4 (link): &nbsp; <tt>http://mojadomena/mojawiki/index.php?Special:Call/:Moja strona,parametr1=wartość1</tt>

Rozszerzenie <i>Wywołaj z parametrem</i> wywoła podaną stronę i wysyłając jej podane parametry.<br />
Zobaczysz zawartość wywołanej strony i jej tytuł, ale dalej będzie to strona specjalna, przez co nie będzie mogła być edytowana.<br />Zawartość, którą zobaczysz, będzie różna w zależności od podanych parametrów.

Rozszerzenie <i>Wywołaj z parametrem</i> jest przydatne przy budowaniu interaktywnych aplikacji na bazie MediaWiki.<br />Przykładem takiej aplikacji może być <a href='http://semeb.com/dpldemo/Template:Catlist'>DPL GUI</a>.<br />
W razie problemów, spróbuj <b>Specjalna:Wywołaj z parametrem/DebuG</b>",
	'call-save'         => "Rezultat tego wywołania zostanie zapisany na stronie ''$1''.",
	'call-save-success' => 'Poniższy tekst został zapisany na stronie <big>[[$1]]</big>.',
	'call-save-failed'  => "Poniższy tekst '''NIE''' został zapisany na stronie <big>[[$1]]</big>, ponieważ ta strona już istnieje.",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'call-save-success' => 'لاندينی متن د <big>[[$1]]</big> مخ کې خوندي شوی.',
);

/** Portuguese (Português)
 * @author Malafaya
 */
$messages['pt'] = array(
	'call'              => 'Call',
	'call-desc'         => 'Cria uma hiperligação para uma predefinição (ou para uma página wiki normal) com passagem de parâmetros. Pode ser usada na linha de comandos do "browser" ou dentro de texto wiki.',
	'call-text'         => "A extensão Call espera uma página wiki e parâmetros opcionais para essa página como argumentos.<br /><br />
Exemplo 1: &nbsp; <tt>[[{{ns:special}}:Call/Minha Predefinição,parm1=value1]]</tt><br />
Exemplo 2: &nbsp; <tt>[[{{ns:special}}:Call/{{ns:talk}}:Minha Discussão,parm1=value1]]</tt><br />
Exemplo 3: &nbsp; <tt>[[{{ns:special}}:Call/:Minha Página,parm1=value1,parm2=value2]]</tt><br /><br />
Exemplo 4 (URL de \"browser\"): &nbsp; <tt>http://meudominio/meuwiki/index.php?{{ns:special}}:Call/:Minha Página,parm1=value1</tt><br /><br />

A <i>extensão Call</i> irá realizar uma chamada à página fornecida e passar os parâmetros.<br />Você irá ver o conteúdo da página chamada e o seu título, mas o seu 'tipo' será o de uma página especial,<br />i.e. tal página não poderá ser editada.<br />O conteúdo que verá poderá variar dependendo do valor dos parâmetros que forem passados.<br /><br />
A <i>extensão Call</i> é útil na construção de aplicações interactivas com MediaWiki.<br />Para um exemplo, veja <a href='http://semeb.com/dpldemo/Template:Catlist'>o GUI DPL</a> ..<br />
Em caso de problemas, poderá experimentar <b>Special:Call/DebuG</b>",
	'call-save'         => "O resultado desta chamada seria gravado numa página chamada ''$1''.",
	'call-save-success' => 'O seguinte texto foi gravado na página <big>[[$1]]</big>.',
	'call-save-failed'  => 'O seguinte texto NÃO foi gravado na página <big>[[$1]]</big> porque essa página já existe.',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'call-save-success' => 'Următorul text a fost salvat la pagina <big>[[$1]]</big> .',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 * @author Ahonc
 */
$messages['ru'] = array(
	'call'              => 'Вызов',
	'call-desc'         => 'Создаёт гиперссылку на шаблон (или обычную вики-страницу) с передачей параметров. Может использоваться в адресной строке браузера или в вики-тексте.',
	'call-text'         => "Расширение «Вызов» (Call) принимает в качестве входных данных название страницы и значения параметров.<br /><br />
Пример 1: &nbsp; <tt>[[Special:Call/My Template,parm1=value1]]</tt><br />
Пример 2: &nbsp; <tt>[[Special:Call/Talk:My Discussion,parm1=value1]]</tt><br />
Пример 3: &nbsp; <tt>[[Special:Call/:My Page,parm1=value1,parm2=value2]]</tt><br />
Пример 4 (URL для браузера): &nbsp; <tt>http://mydomain/mywiki/index.php?Special:Call/:My Page,parm1=value1</tt>

Данное расширение вызовет указанную страницу и передаст ей параметры.<br />Вы увидите сожержимое страницы, её заголовок, но её тип будет типом служебной страницы,<br />т. е. содержимое нельзя будет редактировать.<br />Отображаемое содержимое страницы может изменяться, в зависимости от переданных параметров.<br /><br />Расширение «Вызов» полезно для построения интерактивных приложений с помощью MediaWiki.<br />См. например <a href='http://semeb.com/dpldemo/Template:Catlist'>DPL GUI</a>.<br />
В случае возникновения проблем, вы можете использовать <b>Special:Call/DebuG</b>",
	'call-save'         => "Вывод этого вызова будет сохранён на страницу ''$1''.",
	'call-save-success' => 'Следующий текст был сохранён на страницу <big>[[$1]]</big>.',
	'call-save-failed'  => 'Следующий текст НЕ был сохранён на страницу <big>[[$1]]</big>, так как данная страница уже существует.',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'call'              => 'Call',
	'call-desc'         => 'Vytvorí hyperodkaz na šablónu (alebo na bežnú wiki stránku) s odovzdávaním parametrov. Je možné použiť z riadka s adresou v prehliadači alebo v rámci wiki textu.',
	'call-text'         => "Rozšírenie Call očakáva ako argumenty stránku wiki a voliteľné parametre danej stránky.<br /><br />
Príklad 1: &nbsp; <tt>[[Special:Call/Moja šablóna,parm1=value1]]</tt><br />
Príklad 2: &nbsp; <tt>[[Special:Call/Diskusia:Moja diskusia,parm1=value1]]</tt><br />
Príklad 3: &nbsp; <tt>[[Special:Call/:Moja stránka,parm1=value1,parm2=value2]]</tt><br /><br />
Príklad 4 (URL prehliadača): &nbsp; <tt>http://mojadoména/mojawiki/index.php?Special:Call/:Moja stránka,parm1=value1</tt><br /><br />

<i>Rozšírenie Call</i> zavolá danú stránku a odovzdá jej parametre.<br />
Uvidiíte obsah zavolanej stránky a jej názov, ale jej ''typ'' bude špeciálna stránka,<br />
t.j. takú stránku nie je možné upravovať.<br />
Obsah, ktorý uvidíte sa môže líšiť v závislosti od parametrov, ktoré ste odovzdali.<br /><br />
<i>Rozšírenie Call</i> je užitočné pri budovaní interaktívnych aplikácií pomocou MediaWiki.<br />
Ako príklad si môžete pozrieť <a href='http://semeb.com/dpldemo/Template:Catlist'>GUI DPL</a> ..<br />
V prípade problémov môžete skúsuť <b>Special:Call/DebuG</b>",
	'call-save'         => "Výstup tejto stránky by bol uložený na stránku s názvom ''$1''.",
	'call-save-success' => 'Nasledovný text bol uložený na stránku <big>[[$1]]</big>.',
	'call-save-failed'  => "Nasledovný text NEBOL uložený na stránku ''$1'', pretože taká stránka už existuje.",
);

/** Sundanese (Basa Sunda)
 * @author Kandar
 */
$messages['su'] = array(
	'call'              => 'Calukan',
	'call-desc'         => "Jieun hipertumbu ka citakan (atawa ka kaca wiki biasa) nu mibanda ''parameter passing''. Ieu bisa dipaké dina the browser’s command line or within wiki text.",
	'call-save'         => "Kaluaran ieu panyaluk bakal disimpen di kaca nu disebut ''$1''.",
	'call-save-success' => 'Tulisan di handap ieu geus disimpen dina kaca <big>[[$1]]</big> .',
	'call-save-failed'  => 'Tulisan di handap ieu CAN disimpen dina kaca <big>[[$1]]</big> kusabab éta kaca geus aya.',
);

/** Swedish (Svenska)
 * @author Lejonel
 * @author M.M.S.
 */
$messages['sv'] = array(
	'call'              => 'Anropa',
	'call-desc'         => 'Ger möjlighet att skapa länkar till mallar (eller vanliga wikisidor) med angivna parametrar. Länkarna kan användas i webbläsarens adressfält eller i wikitext.',
	'call-text'         => "Programtillägget Call (Anropa) förväntar sig att en wikisida, och eventuellt parametrar till sidan, anges som argument.<br /><br />
Exempel 1: &nbsp; <tt>[[Special:Call/Min mall,parm1=värde1]]</tt><br />
Exempel 2: &nbsp; <tt>[[Special:Call/Talk:Min diskussion,parm1=värde1]]</tt><br />
Exempel 3: &nbsp; <tt>[[Special:Call/:Min sida,parm1=värde1,parm2=värde2]]</tt><br /><br />
Example 4 (URL för adressfältet): &nbsp; <tt>http://mydomain/mywiki/index.php?Special:Call/:Min_sida,parm1=värde1</tt><br /><br />

<i>Call</i>-tillägget anropar den angivna sidan och skickar med parametrarna.<br />Du kommer att se den anropade sidans innehåll och titel, men sidan som visas är en specialsida och kan därför inte redigeras.<br />
Innehållet som visas kan variera beroende på värdena på de parametrar som skickas med.<br /><br />
Tillägget <i>Call</i> kan användas för att skapa interaktiva applikationer med MediaWiki.<br />
Se som ett exempel <a href='http://semeb.com/dpldemo/Template:Catlist'>gränssnittet för DPL</a> <br />
Om du har några problem så kan du prova <b>Special:Call/DebuG</b>.",
	'call-save'         => "Resultatet av det här anropet skulle ha sparats på en sida med titeln ''$1''.",
	'call-save-success' => 'Följande text har sparats på sidan <big>[[$1]]</big>.',
	'call-save-failed'  => 'Följande text har <b>inte</b> sparats på sidan <big>[[$1]]</big> eftersom sidan redan existerar.',
);

/** Telugu (తెలుగు)
 * @author Veeven
 * @author వైజాసత్య
 */
$messages['te'] = array(
	'call'              => 'పిలువు',
	'call-save-success' => 'ఈ క్రింది పాఠ్యాన్ని <big>[[$1]]</big> అనే పేజీలో భద్రపరిచాం.',
	'call-save-failed'  => '<big>[[$1]]</big> అనే పేజీ ఈసరికే ఉన్నందువల్ల ఈ క్రింది పాఠ్యాన్ని అందులో భద్రపరచలేకపోయాం.',
);

/** Tajik (Cyrillic) (Тоҷикӣ/tojikī (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'call-save-success' => 'Матни зерин ба саҳифа <big>[[$1]]</big> захира шуд.',
);

/** Ukrainian (Українська)
 * @author Ahonc
 */
$messages['uk'] = array(
	'call'              => 'Виклик',
	'call-desc'         => 'Створює посилання на шаблон (або звичайну вікі-сторінку) з передачею параметрів. Може використовуватися в адресному рядку браузера або у вікі-тексті.',
	'call-text'         => "Розширення Call приймає в якості вхідних даних назву сторінки і значення параметрів.<br />

Приклад 1: &nbsp; <tt>[[Special:Call/My Template,parm1=value1]]</tt><br />
Приклад 2: &nbsp; <tt>[[Special:Call/Talk:My Discussion,parm1=value1]]</tt><br />
Приклад 3: &nbsp; <tt>[[Special:Call/:My Page,parm1=value1,parm2=value2]]</tt><br />
Приклад 4 (URL для браузера): &nbsp; <tt>http://mydomain/mywiki/index.php?Special:Call/:My Page,parm1=value1</tt>

Це розширення викличе зазначену сторінку і передасть їй параметри. Ви побачите вміст сторінки, її заголовок, але її тип буде типом спеціальної сторінки, тобто вміст не можна буде редагувати.<br />Вімст сторінки, який відображається, може змінюватися, в залежності від переданих параметрів.<br />

Розширення Call корисне для побудови інтерактивних застосувань за допомогою MediaWiki.<br />Див. наприклад <a href='http://semeb.com/dpldemo/Template:Catlist'>DPL GUI</a>.<br />
У випадку виникнення проблем ви можете використовувати <b>Special:Call/DebuG</b>",
	'call-save'         => "Вивід цього виклику буде збережений на сторінку ''$1''.",
	'call-save-success' => 'Наступний текст був збережений на сторінку <big>[[$1]]</big>.',
	'call-save-failed'  => 'Наступний текст НЕ був збережений на сторінку <big>[[$1]]</big>, оскільки ця сторінка вже існує.',
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'call'              => 'Gọi',
	'call-desc'         => 'Tạo một siêu liên kết đến một tiêu bản (hoặc đến một trang wiki thông thường) bằng cách truyền tham số.
Có thể được dùng tại dòng lệnh của trình duyệt hoặc trong văn bản wiki.',
	'call-text'         => "Gói mở rộng Call mong đợi một trang wiki và những thông số tùy chọn của trang đó là tham số.

Ví dụ 1: &nbsp; <tt>[[Special:Call/Tiêu bản của tôi,tham1=trị1]]</tt><br />
Ví dụ 2: &nbsp; <tt>[[Special:Call/Thảo luận:Thảo luận của tôi,tham1=trị1]]</tt><br />
Ví dụ 3: &nbsp; <tt>[[Special:Call/:Trang của tôi,tham1=trị1,tham2=trị2]]</tt><br />
Ví dụ 4 (URL trình duyệt): &nbsp; <tt>http://tênmiền/wikitôi/index.php?Special:Call/:Trang của tôi,tham1=trị1</tt>

<i>Gói mở rộng Call</i> sẽ gọi trang chỉ định và truyền tham số.<br />
Bạn sẽ nhìn thấy nội dung của trang được gọi cùng với tựa đề của nó nhưng 'kiểu' của nó sẽ là một trang đặc biệt, có nghĩa là bạn không thể sửa đổi trang đó.<br />Nội dung bạn nhìn thấy có thể thay đổi tùy theo giá trị tham số bạn truyền vào.

<i>Gói mở rộng Call</i> hữu hiệu trong việc xây dựng những ứng dụng tương tác với MediaWiki.<br />
Xem ví dụ <a href='http://semeb.com/dpldemo/Template:Catlist'>DPL GUI</a> ..<br />
Trong trường hợp có vấn đề bạn có thể thử <b>Special:Call/DebuG</b>",
	'call-save'         => "Ngõ ra của lần gọi này sẽ được lưu vào trang có tên ''$1''.",
	'call-save-success' => 'Văn bản sau đã được lưu vào trang <big>[[$1]]</big> .',
	'call-save-failed'  => 'Văn bản sau KHÔNG được lưu vào trang <big>[[$1]]</big> vì trang đó đã tồn tại.',
);

/** Volapük (Volapük)
 * @author Smeira
 */
$messages['vo'] = array(
	'call-save-success' => 'Vödem fovik pedakipon su pad: <big>[[$1]]</big>.',
	'call-save-failed'  => 'Vödem fovik NO pedakipon su pad: <big>[[$1]]</big> bi pad at ya dabinon.',
);

