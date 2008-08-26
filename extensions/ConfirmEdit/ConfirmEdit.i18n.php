<?php
/**
 * Internationalisation file for ConfirmEdit extension.
 *
 * @addtogroup Extensions
*/

$messages = array();

$messages['en'] = array(
	'captcha-edit'               => 'To edit this page, please solve the simple sum below and enter the answer in the box ([[Special:Captcha/help|more info]]):',
	'captcha-desc'               => 'Simple captcha implementation',
	'captcha-addurl'             => 'Your edit includes new external links.
To help protect against automated spam, please solve the simple sum below and enter the answer in the box ([[Special:Captcha/help|more info]]):',
	'captcha-badlogin'           => 'To help protect against automated password cracking, please solve the simple sum below and enter the answer in the box ([[Special:Captcha/help|more info]]):',
	'captcha-createaccount'      => 'To help protect against automated account creation, please solve the simple sum below and enter the answer in the box ([[Special:Captcha/help|more info]]):',
	'captcha-createaccount-fail' => "Incorrect or missing confirmation code.",
	'captcha-create'             => 'To create the page, please solve the simple sum below and enter the answer in the box ([[Special:Captcha/help|more info]]):',
	'captchahelp-title'          => 'Captcha help',
	'captchahelp-cookies-needed' => "You will need to have cookies enabled in your browser for this to work.",
	'captchahelp-text'           => "Web sites that accept postings from the public, like this wiki, are often abused by spammers who use automated tools to post their links to many sites.
While these spam links can be removed, they are a significant nuisance.

Sometimes, especially when adding new web links to a page, the wiki may show you an image of colored or distorted text and ask you to type the words shown.
Since this is a task that's hard to automate, it will allow most real humans to make their posts while stopping most spammers and other robotic attackers.

Unfortunately this may inconvenience users with limited vision or using text-based or speech-based browsers.
At the moment we do not have an audio alternative available.
Please contact the site administrators for assistance if this is unexpectedly preventing you from making legitimate posts.

Hit the 'back' button in your browser to return to the page editor.",
	'captcha-addurl-whitelist'   => ' #<!-- leave this line exactly as it is --> <pre>
# Syntax is as follows:
#   * Everything from a "#" character to the end of the line is a comment
#   * Every non-blank line is a regex fragment which will only match hosts inside URLs
 #</pre> <!-- leave this line exactly as it is -->',

	'right-skipcaptcha'          => 'Perform captcha triggering actions without having to go through the captcha',
);

/** Afrikaans (Afrikaans)
 * @author BrokenArrow
 * @author Naudefj
 * @author Siebrand
 */
$messages['af'] = array(
	'captcha-edit'               => 'U wysiging bevat nuwe webskakels. Neem kennis dat blote reklame van u werf, produk of besigheid as vandalisme beskou kan word. As beskerming teen outomatiese gemorsbydraes, sal u die woorde wat onder verskyn in die prentjie moet intik: <br />([[Special:Captcha/help|Wat is hierdie?]])',
	'captcha-desc'               => 'Eenvoudige implementasie van captcha',
	'captcha-addurl'             => 'U wysiging bevat nuwe webskakels.
As beskerming teen outomatiese gemorsbydraes, sal u die woorde wat onder verskyn in die prentjie moet intik ([[Special:Captcha/help|Wat is hierdie?]]):',
	'captcha-createaccount'      => "As 'n beskerming teen geoutomatiseerde gemors, tik asseblief die woorde wat in die beeld verskyn in om 'n rekening te skep: <br />([[Special:Captcha/help|Wat is hierdie?]])",
	'captcha-createaccount-fail' => 'Verkeerde of geen bevestigingkode.',
	'captcha-create'             => 'U wysiging bevat nuwe webskakels. Neem kennis dat blote reklame van u werf, produk of besigheid as vandalisme beskou kan word. As beskerming teen outomatiese gemorsbydraes, sal u die woorde wat onder verskyn in die prentjie moet intik: <br />([[Special:Captcha/help|Wat is hierdie?]])',
	'captchahelp-title'          => 'Captcha-hulp',
	'captchahelp-cookies-needed' => 'U moet koekies in u webblaaier aanskakel hê om dit te laat werk.',
	'captchahelp-text'           => "Webwerwe wat bydraes van die publiek aanvaar (soos hierdie wiki) word soms lastig geval deur kwaaddoeners met programme wat outomaties klomp skakels plak in die werf. Alhoewel hierdie gemors verwyder kan word, is dit lastig. In party gevalle, veral as u webskakels by 'n blad voeg, sal die wiki dalk 'n beeld met verwronge teks vertoon en vra dat u die woorde daarin intik. Omdat hierdie taak moeilik geoutomatiseer word, laat dit meeste regte mense toe om bydraes te maak terwyl dit meeste kwaaddoeners stop. Hierdie kan ongelukkig lastig wees vir mense met beperkte sig, of diegene wat teks- of spraakgebaseerde blaaiers gebruik. Tans is daar nog nie 'n klankalternatief beskikbaar nie. Kontak asseblief die werfadministrateurs vir hulp as hierdie u onverwags belemmer om legitieme bydraes te maak. Gebruik die \"terug\"-knoppie van u blaaier om na die vorige blad terug te keer.",
);

/** Amharic (አማርኛ)
 * @author Siebrand
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'captcha-edit'          => 'ይህንን ድርሰት ለማረም፣ እባክዎን የሚቀጥለውን ቀላል የመደመር ጥያቄ መልስ ሳጥን ውስጥ ይጻፉ። ([[Special:Captcha/help|ተጨማሪ መረጃ]])',
	'captcha-createaccount' => 'ያልተፈለገ የመኪናነት አባልነት ለመከላከል፥ አባል ለመሆን በዚህ ምስል የታዩት እንግሊዝኛ ቃላት ወይም ቁጥር መልስ በትክክል መጻፍ ግዴታ ነው። ([[Special:Captcha/help|ይህ ምንድነው?]]):',
	'captchahelp-title'     => "የ'ካፕቻ' መግለጫ",
	'captchahelp-text'      => "አንዳንዴ 'ስፓም' የተባሉት ያልተፈለጉ መልእክቶች የሚላኩ ሰዎች በመኪናነት አማካይነት በብዙ ድረገጽ ላይ የማይገባ ማስታወቂያ በመልጠፍ ላይ እየተገኘ ነው። ይህን የማይገባ መያያዣ ማስወገድ ቢቻለም አስቸጋሪ ናቸው።

ስለዚህ በመጀመርያ አባልነት ሲገቡ ወይም አንዳንዴ የውጭ ድረገጽ አድራሻ ሲጨመር የፕሮግራሙ ሶፍትዌር 'ካፕቻ' የእንግሊዝኛን ቃላት ወይም የቁጥር መልስ እንዲዳግሙ ለፈተና ይጠይቃል። ይህ አደራረግ ለመኪናነት ቀላል ተግባር ሰላማይሆን፥ እውነተኛ ሰው ከሆነ ለመልጠፍ ያስችለዋል ነገር ግን መኪናነት ከሆነ ዕንቅፋት ይሆንበታል።

ይህ ዘዴ ከመልጠፍ ያለግባብ ቢከለክልዎ እባክዎ መጋቢን ይጠይቁ።

አሁን ( <= 'back' ) በbrowserዎ ላይ ይጫኑ።",
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 * @author Siebrand
 */
$messages['an'] = array(
	'captcha-edit'               => 'Ta editar ista pachina, faiga por fabor a suma simpla que apareixe contino y escriba a soluzión en a caixa ([[Special:Captcha/help|más informazión]]):',
	'captcha-desc'               => 'Implementazión simpla de captcha',
	'captcha-addurl'             => "A suya edizión encluye binclos esternos. Ta aduyar-nos en a protezión contra o spam automatizato, por fabor, faiga a suma simpla que s'amuestra contino y escriba a respuesta en a caixa ([[Special:Captcha/help|más informazión]]):",
	'captcha-badlogin'           => 'Ta aduyar en a protezión contra a obtenzión automatizata de palabras de paso, por fabor faiga a suma simpla que amanixe contino y escriba a respuesta en a caixa ([[Special:Captcha/help|más informazión]]):',
	'captcha-createaccount'      => "Ta aduyar-nos en a protezión contra a creyazión automatica de cuentas, por fabor faiga a suma simpla que s'amuestra contino y escriba a respuesta en a caixa ([[Special:Captcha/help|más informazión]]):",
	'captcha-createaccount-fail' => 'No ha escrito o codigo de confirmazión, u iste ye incorreuto.',
	'captcha-create'             => "Ta creyar a pachina, por fabor faiga a suma simpla que s'amuestra contino y escriba a respuesta en a caixa ([[Special:Captcha/help|más informazión]]):",
	'captchahelp-title'          => 'Aduya sobre o "captcha"',
	'captchahelp-cookies-needed' => 'Ta que o sistema funzione le cal tener as cookies autibatas en o nabegador.',
	'captchahelp-text'           => "Os sitios web que azeptan mensaches d'o publico, como iste wiki, son á ormino obcheto d'abusos por spammers que fan serbir ferramientas automatizatas ta encluyir-ie binclos ta asabelos sitios. Anque istos binclos se pueden sacar, son un gran estorbo.

Bellas begadas, espezialment cuan se mire de adibir nuebos binclos á una pachina, o wiki talment le amuestre una imachen con testo en color y distorsionato, y le pregunte cuals son as palabras amostratas. Como ista ye una faina de mal automatizar, premitirá á os usuarios umanos fer as suyas edizions de bez que aturará á muitos spammers y atacants automaticos.

Manimenos, isto puede estar un barrache ta usuarios con bisión limitata u que faigan ser nabegadors basatos en testo u en a boz. Por l'inte no tenemos garra alternatiba de audio. Por fabor, contaute con os almenistradors d'o sistema ta demandar aduya si isto le ye pribando de fer as suyas edizions lechitimas.

Punche o botón 'entazaga' d'o suyo nabegador ta tornar t'o editor de pachinas.",
	'captcha-addurl-whitelist'   => " #<!-- leave this line exactly as it is --> <pre>
# A sintaxis ye asinas:
#  * Tot o que bi ha dende un caráuter \"#\" dica a fin d'a linia ye un comentario
#  * Cualsiquier linia con testo un troz d'expresión regular (regex) que sólo concordará con os hosts aintro d'URLs
   #</pre> <!-- leave this line exactly as it is -->",
	'right-skipcaptcha'          => 'Fer aizions que requieren o captcha sin fer serbir o captcha',
);

/** Arabic (العربية)
 * @author Mido
 * @author Meno25
 * @author Alnokta
 * @author OsamaK
 * @author Siebrand
 */
$messages['ar'] = array(
	'captcha-edit'               => 'لتعديل هذه الصفحة، من فضلك قم بحل المسألة الرياضية البسيطة أدناه وأدخل الحل في الصندوق ([[Special:Captcha/help|مزيد من المعلومات]]):',
	'captcha-desc'               => 'تطبيق كابتشا بسيط',
	'captcha-addurl'             => 'تعديلك يحتوي على وصلات خارجية جديدة. للمساعدة في الحماية من السخام الأوتوماتيكي، من فضلك حل عملية الجمع بالأسفل و أضف الحل في الصندوق  ([[Special:Captcha/help|معلومات إضافية]]):',
	'captcha-badlogin'           => 'للمساعدة في الحماية ضد سرقة كلمات السر، من فضلك حل عملية الجمع البسيطة بالأسفل وأدخل الحل في الصندوق ([[Special:Captcha/help|معلومات إضافية]]):',
	'captcha-createaccount'      => 'كحماية ضد العمليات التخريبية، يجب أن تدخل ناتج العملية الحسابية التالية لكي تنشأ حسابا: <br />([[Special:Captcha/help|ما هذا؟]])',
	'captcha-createaccount-fail' => 'كود غير مطابق أو لم تقم بإدخاله.',
	'captcha-create'             => 'من فضلك قم بحل المسألة الرياضية التالية لإنشاء هذه الصفحة وأدخل
الجواب في الصندوق ([[Special:Captcha/help|معلومات إضافية]]):',
	'captchahelp-title'          => 'مساعدة الكابتشا',
	'captchahelp-cookies-needed' => 'ستحتاج إلى أن تكون الكوكيز مفعلة في متصفحك لكي يعمل هذا',
	'captchahelp-text'           => "عادة ما يتم في المواقع التي تقبل الردود والرسائل من العامة، كهذا الويكي، تخريب الموقع عن طريق الأشخاص الذين يستعملون آليات معينة لإرسال وصلاتهم لمواقع متعددة بصورة آلية. وعلى الرغم من أن هذا يمكن إزالته ولكنه مزعج للغاية.

في بعض الأحيان، خصوصا عند إضافة وصلات لصفحة، ربما يعرض الويكي صورة ملونة أو مشوشة ويطلب منك إدخال كلمات موجودة بالصورة أو يعرض عليك مسألة رياضية عشوائية ويطلب منك حلها. ولأن هذه المهمة صعبة للغاية لأن يقوم بها برنامج، سيسمح هذا للأشخاص الآدميين بإضافة تحريراتهم بينما ستوقف البرامج التخريبية والهجمات الآلية الأخرى.

للأسف سيكون هذا صعبا بالنسبة لمستخدمي المتصفحات المحدودة أو التي تعتمد على النصوص فقط أو قراءة النصوص. في الوقت الحالي لا يوجد لدينا بديل سمعي. من فضلك راسل مديري الموقع للمساعدة إذا كان هذا الأمر يمنعك من التعديل ووضع وصلات قانونية.

إذا كنت تحرر صفحة معينة: اضغط زر 'العودة' في متصفحك للعودة إلى التحرير.",
	'captcha-addurl-whitelist'   => ' #<!-- اترك هذا السطر تمامًا كما هو --> <pre>
# الصيغة كما تلي:
#  * كل شيء من علامة "#" لنهاية السطر تعليق
#  * كل سطر غير فارغ هو جزء تعبير نمطي والذي سوف يطابق فقط المضيفين داخل العناوين
  #</pre> <!-- اترك هذا السطر تمامًا كما هو -->',
	'right-skipcaptcha'          => 'أداء أفعال تستوجب تنفيذ كابتشا دون المرور بها',
);

/** Assamese (অসমীয়া)
 * @author Rajuonline
 */
$messages['as'] = array(
	'captcha-edit'               => 'এই পৃষ্ঠাটো সম্পাদনা কৰিবলৈ তলৰ সহজ অংকটো কৰি উত্তৰতো বাকছৰ ভিতৰত লিখক
([[Special:Captcha/help|অধিক তথ্য]]):',
	'captcha-addurl'             => 'আপোনাৰ সম্পাদনাত বাহিৰলৈ সংযোগ আছে।
স্বয়ংক্রীয় স্পামৰ পৰা বাচিবলৈ, তলৰ সহজ অংকটো কৰি উত্তৰতো বাকছৰ ভিতৰত লিখক ([[Special:Captcha/help|অধিক তথ্য]]):',
	'captcha-badlogin'           => 'স্বয়ংক্রীয়ভাবে গুপ্তশব্দ ভঙাৰ পৰা বাচিবলৈ, তলৰ সহজ অংকটো কৰি উত্তৰতো বাকছৰ ভিতৰত লিখক
([[Special:Captcha/help|অধিক তথ্য]]):',
	'captcha-createaccount'      => 'স্বয়ংক্রীয় হোৱা ভাবে সদস্যভুক্তি ৰোধ কৰিবলৈ, তলৰ সহজ অংকটো কৰি উত্তৰতো বাকছৰ ভিতৰত লিখক
([[Special:Captcha/help|অধিক তথ্য]]):',
	'captcha-createaccount-fail' => 'ভুল বা খালী নিশ্বিতকৰণ শব্দ',
	'captcha-create'             => 'এই পৃষ্ঠাটো তৈয়াৰ কৰিবলৈ, তলৰ সহজ অংকটো কৰি উত্তৰতো বাকছৰ ভিতৰত লিখক
([[Special:Captcha/help|অধিক তথ্য]]):',
	'captchahelp-cookies-needed' => 'এই কামতো সম্পন্ন কৰিবলৈ, আপোনাৰ ব্রাউজাৰত কুকী সক্রীয় থাকিব লাগিব',
	'captchahelp-text'           => "যিবোৰ ৱেবচাইটত জনতাই পাঠ্য ভৰাব পাৰে, যেনে এই ৱিকি, সেইবোৰক প্রায়ে দুস্ক্রিতিকাৰি স্পেমাৰবোৰে স্বয়ংক্রীয় আহিলাৰ দ্বাৰা তেওলোকৰ চাইটলৈ সংযোগ ভৰাই আক্রমন কৰে। 
যদিও তেনে স্পাম সংযোগ গুচাব পাৰি, পিছে এয়া এক ডাঙৰ উপদ্রৱ।

কেতিয়াবা, সাধাৰণতে যেতিয়া কোনো পৃষ্ঠালৈ নতুন সংযোগ সৃষ্টি কৰা হয়, তেতিয়া ৱিকিয়ে এটা ৰঙীন বা বিকৃত চবি দেখুৱাই তাত থকা শব্দখিনি আপোনাক টাইপ কৰিব কব পাৰে।
যিহেতু এই কামতো স্বয়ংক্রীয় ভাবে কৰা প্রায়ে অসম্ভব, ই বেছিভাগ প্রকৃত ব্যক্তিক পাঠ্য ভৰাব দিয়াৰ লগতে স্বয়ংক্রীয় আহিলাৰ দ্বাৰা পাঠ্য ভৰোৱা দুস্ক্রিতিকাৰি সকলক ৰোধ কৰিব পাৰে।

দুর্ভাগ্যক্রমে, সিমিত দৃষ্টিশক্তি থকা ব্যক্তিসকলে, বা পাঠ্য-আধাৰিত অথবা ধ্বনি-আধাৰিত ব্রাউজাৰ ব্যৱহাৰ কৰা ব্যক্তিসকলে ইয়াৰ বাবে আসুবিধা পাব পাৰে.
এই সময়ত ইয়াৰ কোনো ধ্বনি-আধাৰিত বিকল্প আমাৰ হাতত নাই।

ইয়াৰ বাবে যদি আপুনি যুক্তিসম্মত পঠ্য ভৰাব অসুবিধা পাইছে, তেনেহলে চাইট প্রৱন্ধকৰ লগত যোগযোগ কৰক।

পৃষ্ঠা সম্পাদনালৈ ঘুৰি যাবলৈ আপোনাৰ ব্রাউজাৰৰ 'back' বুটামত টিপা মাৰক।",
);

/** Asturian (Asturianu)
 * @author SPQRobin
 * @author Esbardu
 */
$messages['ast'] = array(
	'captcha-edit'               => "Pa editar esta páxina, por favor resuelvi la suma simple d'embaxo y pon la rempuesta nel caxellu ([[Special:Captcha/help|más información]]):",
	'captcha-addurl'             => "La to edición inclúi nuevos enllaces esternos. P'aidar a protexer escontra'l spam automatizáu, por favor resuelvi la suma simple d'embaxo y pon la rempuesta nel caxellu ([[Special:Captcha/help|más información]]):",
	'captcha-badlogin'           => "P'aidar a protexer escontra'l descifráu automáticu de claves, por favor resuelvi la suma simple d'embaxo y pon la rempuesta nel caxellu ([[Special:Captcha/help|más información]]):",
	'captcha-createaccount'      => "P'aidar a protexer escontra la creación automática de cuentes, por favor resuelvi la suma simple d'embaxo y pon la rempuesta nel caxellu ([[Special:Captcha/help|más información]]):",
	'captcha-createaccount-fail' => 'Códigu de confirmación incorreutu o ausente.',
	'captcha-create'             => "Pa crear la páxina, por favor resuelvi la suma simple d'embaxo y pon la rempuesta nel caxellu ([[Special:Captcha/help|más información]]):",
	'captchahelp-title'          => 'Aida tocante al captcha',
	'captchahelp-cookies-needed' => "Has tener les cookies habilitaes nel to navegador pa que'l sistema funcione.",
	'captchahelp-text'           => "Los sitios web qu'aceuten mensaxes del publicu, como esta wiki, davezu son oxetu d'abusu por spammers qu'usen programes pa incluyir los sos enllaces automáticamente. Si bien estos enllaces spam puen quitase, son una bona molestia.

Dacuando, especialmente cuando amiesta nuevos enllaces web nuna páxina, la wiki pue amosate una imaxe de testu coloreáu o distorsionáu y va pidite qu'escribas les pallabres amosaes. Yá qu'esti ye un llabor difícil d'automatizar, permitirá a les más de les persones reales unviar los sos testos, al empar que detién los más de los spammers y otros atacantes automáticos.

Desafortunadamente esto pue suponer un inconveniente pa los usuarios con visión llimitada o qu'usen navegadores de testu o voz. De momentu nun tenemos disponible una alternativa per audiu. Por favor, contauta colos alministradores del sitiu pa pidir aida si esto t'impide facer ediciones llexítimes.

Calca nel botón 'atrás' del to navegador pa volver a la páxina d'edicion.",
	'captcha-addurl-whitelist'   => ' #<!-- dexa esta llinia exautamente como ta --> <pre>
# La sintaxis ye como sigue:
#  * Too dende\'l carauter "#" hasta la fin de la llinia ye un comentariu
#  * Toa llinia non vacia ye un fragmentu regex que namái buscará hosts n\'URLs
  #</pre> <!-- dexa esta llinia exautamente como ta -->',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'captcha-edit'               => 'به اصلاح کتن ای صفحه،لطفا ای جمع ساده حل کنیت و جوابء جهلا وارد کنیت ([[Special:Captcha/help|گیشتر اطلاعات]]):',
	'captcha-desc'               => ' کاربرد ساده captcha',
	'captcha-addurl'             => 'شمی اصلاح شامل نوکین درای لینک انت.
په کمک په حمایت چه اتوماتیکی اسپم، لطفا جمع ساده حل کینت و جواب جهلء وارد کنیت  ([[Special:Captcha/help|گیشتر اطلاعات]]):',
	'captcha-badlogin'           => 'په کمک په حمایت چه اتوماتیکی کلمه رمز پروشوک، لطفا ای جمع ساده حل کنیت. جوابء جهلء وارد کنید  ([[Special:Captcha/help|گیشتر اطلاعات]]):',
	'captcha-createaccount'      => 'په کمک په حمایت چه اتوماتیکی حساب شرکتن، لطفا ای جهلی ساده جمع حل کنیت و جواب بنویسیت  ([[Special:Captcha/help|گیشتر اطلاعات]]):',
	'captcha-createaccount-fail' => 'اشتباه یا گارین کد تایید',
	'captcha-create'             => 'په شرکتن صفحه، لطفا ای جمع ساده حل کنیت و جواب ادان بنویسیت  ([[Special:Captcha/help|گیشتر اطلاعات]]):',
	'captchahelp-title'          => 'کمک Captcha',
	'captchahelp-cookies-needed' => 'شمی نیاز بیت که ته وتی بروزر کوکی فعال کنیت په ای کارء',
	'captchahelp-text'           => "وب سایتانی که چه عام نوشته قبول کننت، په داب ای ویکی، اغلب چه طرف اسپمرآن که چه وسایل اتوماتیکی په دیم دهگ لینکانش په بازگین سایت سوء استفاده کنگ بیت.
اگر که ای لینک اسپمی دور کنگ بینت،بله باز اذیت کننت.

لهتی وهد به خصوصی وهدی که نوکین لینک وبی په یک صفحه اضافه بیت،ویکی شاید یک عکس رنگی یا هورت هورین متنی شما ار پیش داریت و چه شما لوٹیت پیش داشتگین کلمات وارد کنیت.
چه آ جاهی که ای کاری سختنت په اتوماتیک کتن،آی واقعی ترین انسان اجازت دنت تا وتی نوشتانک دیم دهنت چه آ دیم گیشترین اسپمر و هکرآنء متوقف کنت.

متاسفانه شی شاید کاربرانء ناراحت کنت ته یک دید محدود یا استفاده کتن چه بروزرآن متنی و گپی.
هنو ما را تواری جایگزین نیست.
لطفا مدیران سایت تماس گریت په کمک اگر شی یک ناخواسته این جلوگیری چه دیم دهگ قانونی انت.
دکمه 'back' ته وتی بروزر بجنیت دان په صفحه اصلاح تریت.",
	'captcha-addurl-whitelist'   => ' #<!-- leave this line exactly as it is --> <pre>
# Syntax is as follows:
#   * Everything from a "#" character to the end of the line is a comment
#   * Every non-blank line is a regex fragment which will only match hosts inside URLs
 #</pre> <!-- leave this line exactly as it is -->',
	'right-skipcaptcha'          => 'اجرای کاران کپچا بی شی که چه طریق کپچا بروت',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'captcha-create'    => 'Tangarig maggibo an pahina, paki simbagan an simpleng suma sa ibaba asin ikaag an simbag sa laog kan kahon ([[Special:Captcha/help|more info]]):',
	'captchahelp-title' => 'Tabang sa Captcha',
);

/** Belarusian (Беларуская)
 * @author Yury Tarasievich
 */
$messages['be'] = array(
	'captcha-create'             => 'Каб стварыць старонку, развяжыце простае ўраўненне, што ніжэй, і ўпішыце адказ у адпаведнае поле ([[Special:Captcha/help|больш падрабязна]]):',
	'captchahelp-title'          => 'Даведка Капчы',
	'captchahelp-cookies-needed' => 'Каб гэтая магчымасць працавала, належыць дазволіць у браўзеры апрацоўку квіткоў ("кукі").',
	'captcha-addurl-whitelist'   => ' #<!-- радок абавязкова пакінуць як ёсць (у т.л., з прагалам у пачатку) --> <pre>
# Сінтаксіс наступны:
#  * Усё ад знаку "#" да канца радка гэта каментар
#  * Кожны непусты радок гэта частковы рэгулярны выраз, які параўноўваецца з адрасамі сервераў унутры URL-яў
  #</pre> <!-- радок абавязкова пакінуць як ёсць (у т.л., з прагалам у пачатку) -->',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Spiritia
 */
$messages['bg'] = array(
	'captcha-edit'               => 'Редактирането на тази статия изисква потребителите да въведат отговора на задачата по-долу в текстовата кутия ([[Special:Captcha/help|повече информация]]):',
	'captcha-desc'               => 'Имплементира опростена captcha',
	'captcha-addurl'             => 'Тази редакция съдържа нови външни препратки. Като защита срещу автоматизиран спам системата изисква потребителите да въведат отговора на задачата по-долу в текстовата кутия ([[Special:Captcha/help|повече информация]]):',
	'captcha-badlogin'           => 'Като защита срещу автоматизирано компрометиране на пароли, системата изисква потребителите да въведат отговора на задачата по-долу в текстовата кутия ([[Special:Captcha/help|повече информация]]):',
	'captcha-createaccount'      => 'Като защита от автоматизирани регистрации, системата изисква при регистриране на потребителска сметка потребителите да въведат отговора на задачата по-долу в текстовата кутия ([[Special:Captcha/help|повече информация]]):',
	'captcha-createaccount-fail' => 'Грешен или липсващ код за потвърждение.',
	'captcha-create'             => 'За създаване на страницата е необходимо да се реши задачата и да се въведе отговорът в кутията ([[Special:Captcha/help|повече информация]]):',
	'captchahelp-title'          => 'Помощ за сaptcha',
	'captchahelp-text'           => "Уеб сайтовете, които позволяват свободно да се редактира и добавя ново съдържание (като това уики), често са обект на атаки от страна на спамъри, които използват средства за автоматизирано редактиране за публикуване на препратки към много сайтове. Въпреки че тези препратки могат да бъдат премахнати, те са особено неприятни за потребителите.

Понякога, особено когато се добавят нови препратки към страниците, е възможно уикито да покаже картинка с текст, който трябва да бъде въведен в посоченото поле. Тъй като това е стъпка, която е трудно да бъде прескочена при автоматизирано редактиране, тя затруднява и спира повечето спамъри и роботи, но допуска истинските потребителите да правят редакции.

За съжаление тази стъпка може да затрудни незрящи потребители или потребители, които използват текстови или речеви браузъри. За момента системата не разполага с възможност за гласова алтернатива. Обърнете се за помощ към администратор на сайта, ако това изискване на системата ви затруднява да допринасяте легитимно.

Натиснете бутона 'back' на вашия браузър, за да се върнете към редактора на страници.",
);

/** Bengali (বাংলা)
 * @author Zaheen
 * @author Bellayet
 */
$messages['bn'] = array(
	'captcha-edit'               => 'এই নিবন্ধটি সম্পাদনা করতে দয়া করে নিচের সহজ যোগটি সমাধান করুন এবং ফলাফলটি বাক্সটিতে প্রবেশ করান ([[Special:Captcha/help|আরও তথ্য]]):',
	'captcha-desc'               => 'সরল captcha বাস্তবায়ন',
	'captcha-addurl'             => 'আপনার সম্পাদনায় নতুন বহিঃসংযোগ বিদ্যমান। স্বয়ংক্রিয় স্প্যামের বিরুদ্ধে সুরক্ষার খাতিরে অনুগ্রহ নিচের যোগটি সমাহদান করুন এবং উত্তরটি বাক্সে প্রবেশ করান ([[Special:Captcha/help|আরও তথ্য]]):',
	'captcha-badlogin'           => 'স্বয়ংক্রিয় শব্দচাবি ক্র‌্যাকিং-এর বিরুদ্ধে সুরক্ষার খাতিরে অনুগ্রহ করে নিচের যোগটি সমাধান করুন এবং উত্তরটি বাক্সে প্রবেশ করান ([[Special:Captcha/help|আরও তথ্য]]):',
	'captcha-createaccount'      => 'স্বয়ংক্রিয় অ্যাকাউন্ট সৃষ্টি রোধ করার খাতিরে অনুগ্রহ করে নিচের যোগটি সমাধান করুন এবং উত্তরটি বাক্সে প্রবেশ করান ([[Special:Captcha/help|আরও তথ্য]]):',
	'captcha-createaccount-fail' => 'ভুল অথবা হারিয়ে যাওয়া নিশ্চিতকরণ সংকেত',
	'captcha-create'             => 'পাতাটি সৃষ্টি করতে চাইলে অনুগ্রহ করে নিচের যোগটি সমাধান করুন এবং উত্তরটি বাক্সে প্রবেশ করান ([[Special:Captcha/help|আরও তথ্য]]):',
	'captchahelp-title'          => 'ক্যাপচা সাহায্য',
	'captchahelp-cookies-needed' => 'এই কাজটি করার জন্য আপনাকে আপনার ব্রাউজারের কুকি সক্রিয় করতে হবে।',
	'captchahelp-text'           => 'যেসব ওয়েবসাইট পোস্টিং-এর জন্য উন্মুক্ত, যেমন এই উইকিটি, সেগুলি প্রায়ই স্প্যামারদের আক্রমণের শিকার হয়। স্প্যামাররা স্বয়ংক্রিয় সরঞ্জাম ব্যবহার করে তাদের সংযোগগুলি বহু সাইটে পোস্ট করে। এই স্প্যাম সংযোগগুলি মুছে ফেলা সম্ভব, কিন্তু এগুলি যথেষ্ট বিরক্তির উদ্রেক করে।

কখনো কখনো, বিশেষ করে কোন পাতায় নতুন ওয়েব সংযোগ যোগ করার সময়, উইকিটি আপনাকে রঙিন বা বিকৃত টেক্সটবিশিষ্ট ছবি দেখিয়ে আপনাকে শব্দটি টাইপ করতে বলতে পারে। যেহেতু এই কাজটি স্বয়ংক্রিয়ভাবে সম্পাদন করা দুরূহ, তাই এই ব্যবস্থার ফলে প্রকৃত মানুষেরা পোস্ট করতে পারবেন কিন্তু বেশির ভাগ স্প্যামার বা রোবটভিত্তিক আক্রমণ বাধাপ্রাপ্ত হবে।

যারা চোখে কম দেখতে পান কিংবা টেক্সটভিত্তিক বা উক্তিভিত্তিক ব্রাউজার ব্যবহার করছেন, দুর্ভাগ্যবশত এই ব্যবস্থাটি তাদের জন্য সমস্যার সৃষ্টি করবে। এই মুহূর্তে আমাদের কাছে এই ব্যবস্থাটির কোন অডিও বিকল্প নেই। যদি ব্যবস্থাটি আপনাকে বৈধ পোস্ট করতে অযাচিত বাধা দেয়, অনুগ্রহ করে সাইটের প্রশাসকদের কাছে সাহায্য চান।

আপনি এখন ব্রাউজারের ব্যাক বোতাম চেপে পাতা সম্পাদকে ফেরত যেতে পারেন।',
	'captcha-addurl-whitelist'   => ' #<!-- leave this line exactly as it is --> <pre>
# সিনট্যাক্স নিম্নরূপ:
#  * "#" ক্যারেক্টার থেকে শুরু হয়ে লাইনের শেষ পর্যন্ত সবকিছু একটি মন্তব্য
#  * খালি নয় এমন প্রতিটি লাইন একটি রেজেক্স খণ্ডাংশ যেটি URLগুলির ভেতরে হোস্টগুলির সাথে মিলে যাবে।
  #</pre> <!-- leave this line exactly as it is -->',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author BrokenArrow
 */
$messages['br'] = array(
	'captcha-edit'               => "A-raok gellout degas kemmoù war ar bajenn-mañ e c'houlenner ouzhoc'h respont d'ar jedadenn eeun a-is ha lakaat an disoc'h er vaezienn ([[Special:Captcha/help|Petra eo se?]])",
	'captcha-desc'               => 'Enplementadur eeun Captcha',
	'captcha-addurl'             => "Liammoù diavaez nevez zo bet ouzhpennet ganeoc'h. A-benn en em wareziñ diouzh ar spam emgefre skrivit disoc'h ar jedadennig eeun-mañ er stern : <br />([[Special:Captcha/help|Petra eo se?]])",
	'captcha-badlogin'           => "A-benn talañ ouzh preizhadur emgefre ar gerioù-tremen gant ar botoù e c'houlenner ouzhoc'h jediñ an tamm oberiadenn ha skrivañ an disoc'h anezhi er vaezienn a-is ([[Special:Captcha/help|Petra eo se ?]]):",
	'captcha-createaccount'      => "A-benn hor skoazellañ d'en em wareziñ diouzh ar c'hrouiñ kontoù emgefre, skrivit ar gerioù a zeu war wel er stern-mañ evit enrollañ ho kont : <br />([[Special:Captcha/help|Petra eo se?]])",
	'captcha-createaccount-fail' => "Mankout a ra ar c'hod kadarnaat pe fall eo.",
	'captcha-create'             => "A-benn krouiñ ar bajenn, skrivit disoc'h ar jedadennig eeun-mañ er vaezienn : <br />([[Special:Captcha/help|Petra eo se?]])",
	'captchahelp-title'          => 'Skoazell Capcha',
	'captchahelp-cookies-needed' => "Ret eo deoc'h gweredekaet an toupinoù war ho merdeer Web evit ma'z afe en-dro.",
	'captchahelp-text'           => "Alies e vez taget al lec'hiennoù a zegemer kemennadennoù a-berzh an holl, evel ar wiki-mañ, gant ar spamerien a implij ostilhoù emgefre evit postañ o liammoù war lec'hiennoù a bep seurt. Diverket e c'hallont bezañ, gwir eo, kazus-mat ez int memes tra. A-wechoù, dreist-holl pa vez ouzhpennet liammoù Web nevez war ur bajenn, e c'hallo ar wiki-mañ diskouez deoc'h ur skeudenn warni un tamm testenn liv pe a-dreuz. Goulennet e vo diganeoc'h skrivañ ar gerioù deuet war wel. Un trevell start da emgefrekaat eo hemañ. Gant se e c'hallo an implijerien wirion postañ ar pezh a fel ldezho tra ma vo lakaet un harz d'an darn vrasañ eus ar spamerien pe d'an dagerien robotek all. Koulskoude e c'hallo an implijerien berr o gweled pe ar re a implij merdeerioù diazezet war ar skrid pe war ar vouezh bezañ strafuilhet gant se. N'omp ket evit kinnig un diskoulm dre glevet evit c'hoazh. Kit e darempred gant merourien al lec'hienn m'hoc'h eus diaesterioù evit kemer perzh abalamour d'an teknik-se. Pouezit war bouton 'kent' ho merdeer evit distreiñ d'ar bajenn gemmañ.",
	'captcha-addurl-whitelist'   => " #<!-- laoskit al linenn-mañ tre evel m'emañ --> <pre>
# Setu penaos emañ an ereadur :
#  * Kement tra war-lerc'h an arouezenn \"#\" zo un urzhiad, betek penn all al linenn
#  * Kement linenn n'eo ket goullo zo ur c'hod regex a vo implijet e diabarzh al liammoù gourdskrid hepken 
  #</pre> <!-- laoskit al linenn-mañ tre evel m'emañ -->",
	'right-skipcaptcha'          => 'Lañsañ a ra an oberoù captcha hep bezañ rediet da dremen drezañ',
);

/** Bosnian (Bosanski)
 * @author BrokenArrow
 */
$messages['bs'] = array(
	'captcha-edit'               => 'Vaša izmjena uključuje nove URL poveznice; kao zaštita od automatizovanog vandalizma, moraćete da ukucate riječi koje su prikazane u slici:
<br />([[{{ns:special}}:Captcha/help|Šta je ovo?]])',
	'captcha-addurl'             => 'Vaša izmjena uključuje nove URL poveznice; kao zaštita od automatizovanog vandalizma, moraćete da ukucate riječi koje su prikazane u slici:
<br />([[{{ns:special}}:Captcha/help|Šta je ovo?]])',
	'captcha-createaccount'      => 'Kao zaštita od automatizovanog vandalizma, moraćete da ukucate riječi koje se nalaze na slici da biste registrovali nalog:
<br />([[{{ns:special}}:Captcha/help|Šta je ovo?]])',
	'captcha-createaccount-fail' => 'Netačan unos ili nedostatak šifre za potvrđivanje.',
	'captcha-create'             => 'Vaša izmjena uključuje nove URL poveznice; kao zaštita od automatizovanog vandalizma, moraćete da ukucate riječi koje su prikazane u slici:
<br />([[{{ns:special}}:Captcha/help|Šta je ovo?]])',
	'captchahelp-text'           => "Vebsajtovi koji podržavaju slanje sadržaja iz javnosti, kao što je ovaj viki, često zloupotrebljavaju vandali koji koriste automatizovane alate da šalju svoje poveznice ka mnogim sajtovima.  Iako se ove neželjene poveznice mogu ukloniti, one ipak zadaju veliku muku.

Ponekad, pogotovo kad se dodaju nove internet poveznice na stranicu, viki softver Vam može pokazati sliku obojenog i izvrnutog teksta i tražiti da ukucate traženu riječ.  Pošto je teško automatizovati ovakav zadatak, on omogućuje svim pravim ljudima da vrše svoje izmjene, ali će zato spriječiti vandale i ostale robotske napadače.

Nažalost, ovo može da bude nepovoljno za korisnike sa ograničenim vidom i za one koji koriste brauzere bazirane na tekstu ili govoru.  U ovom trenutku, audio alternativa nije dostupna.  Molimo Vas da kontaktirate administratore sajta radi pomoći ako Vas ovo neočekivano ometa u pravljenju dobrih izmjena.

Kliknite 'nazad' ('back') dugme vašeg brauzera da se vratite na polje za unos teksta.",
);

/** Catalan (Català)
 * @author SMP
 * @author Toniher
 * @author Siebrand
 */
$messages['ca'] = array(
	'captcha-edit'               => 'Per a poder editar aquesta pàgina cal que resolgueu aquesta simple suma i introduïu el resultat en el quadre ([[Special:Captcha/help|més informació]]):',
	'captcha-addurl'             => 'La vostra edició conté enllaços externs nous. Com a protecció contra la brossa de propaganda automàtica, cal que resolgueu aquesta simple suma i introduïu el resultat en el quadre a continuació ([[Special:Captcha/help|més informació]]):',
	'captcha-badlogin'           => "Per a ajudar en la protecció contra l'obtenció automatitzada de contrasenyes haureu de resoldre la suma que apareix a continuació ([[Special:Captcha/help|més informació]]):",
	'captcha-createaccount'      => "Com a protecció contra la creació automàtica de comptes d'usuari necessitem que resolgueu aquesta simple suma i introduïu el resultat en el quadre a continuació ([[Special:Captcha/help|més informació]]):",
	'captcha-createaccount-fail' => 'Manca el codi de confirmació, o bé és incorrecte.',
	'captcha-create'             => 'La vostra edició conté enllaços externs nous. Com a protecció contra la brossa de propaganda automàtica, cal que resolgueu aquesta simple suma i introduïu el resultat en el quadre a continuació ([[Special:Captcha/help|més informació]]):',
	'captchahelp-title'          => 'Ajuda amb el sistema captcha',
	'captchahelp-cookies-needed' => "Heu d'activar les galetes al vostre navegador per a que funcioni.",
	'captchahelp-text'           => "Els webs que accepten la publicació de missatges per part del seu públic, com aquesta wiki, són sovint víctimes de spam per part de robots automàtics que hi posen enllaços cap als seus webs. Aquests enllaços poden anar essent esborrats, però són un important destorb.

Quan creeu nous comptes d'usuari o voleu afegir enllaços a una pàgina se us pot demanar que respongueu una pregunta fàcil, una suma o que digueu quina paraula apareix en una imatge distorsionada. Aquestes tasques són molt difícils de fer per a un programa automàtic i per tant permet que la majoria d'usuaris humans puguin introduir la informació que creguin i alhora atura la majoria d'atacants robots.

Malauradament, aquest sistema pot suposar un inconvenient per a usuaris amb problemes de visió o que utilitzin navegadors de text simple o de veu. Actualment no disposem de cap alternativa auditiva disponible. Contacteu els administradors del web si aquests sistema us impedeix de fer edicions legítimes.

Necessitareu tenir les galetes activades en el vostre navegador per a que funcioni.

Cliqueu el botó de retrocedir del vostre navegador per a tornar al formulari.",
	'captcha-addurl-whitelist'   => " #<!-- deixeu aquesta línia tal com està --> <pre>
# La sintaxi és la següent:
#  * Totes les línies que comencen amb un # son considerades comentaris
#  * Tota línia no buida és un fragment d'expressió regular (regexp) que enllaçarà amb els hosts de les URL
  #</pre> <!-- deixeu aquesta línia tal com està -->",
	'right-skipcaptcha'          => 'Fer les accions que requereixen de captcha sense haver-lo de passar',
);

/** Min Dong Chinese (Mìng-dĕ̤ng-ngṳ̄) */
$messages['cdo'] = array(
	'captcha-edit'      => "Nṳ̄ gă-tiĕng lāu sĭng gì nguôi-buô lièng-giék. Ôi lāu ê̤ṳ-huòng ô tiàng-sê̤ṳ cê̤ṳ-dông huák-buó bóng-só̤ séng-sék (''spam''), kī-dâe̤ng nṳ̄ gié-sáung â-dā̤ gāng-dăng gì gă-huák, gái ciŏng dák-áng siā diē gáh-gáh diē-sié ([[Special:Captcha/help|gáing sâ̤ séng-sék]]):",
	'captchahelp-title' => 'Captcha bŏng-cô',
	'captchahelp-text'  => "Chiông wiki dēng kăi-huóng gì uōng-câng sèu-sèu ké̤ṳk bóng-só̤ séng-sék huák-buó-nè̤ng (\\'\\'spammer\\'\\') páh-chā: ĭ-gáuk-nè̤ng kĕk cê̤ṳ-dông-huá gì gă-sĭ táik bóng-só̤ guōng-gó̤ lièng gáu ĭ gì uōng-câng. Chŭi-iòng cī piĕ bóng-só̤ séng-sék â̤ dù lâi gì, dáng-sê iâ cêng-go̤ tō̤-iéng.

Ô sèng-hâiu, dĕk-biék sê găk nṳ̄ gă-tiĕng sĭng gì nguôi-buô lièng-giék gáu wiki gì sèng-hâiu, wiki â̤ hiēng-sê sáik-ké gáuk-iông hĕ̤k-ciā sê hìng-câung ô gāi-biéng gì ùng-cê dù-chiông, giéu nṳ̄ páh diē nṳ̄ sū káng giéng gì cê hĕ̤k sṳ̀ (hô̤ lō̤ \"captcha\"). Ĭng-ôi gĭ-ké-nè̤ng mâ̤ chiàng ciā êng-ô, gó-chṳ̄ cêu â̤ huòng-cī duâi-buô-hông iù gĭ-ké-nè̤ng huák-buó bóng-só̤ séng-sék (bók-guó, cĭng nè̤ng huák-buó  bóng-só̤ séng-sék, ciā huŏng-huák huòng mâ̤ lì).

Cĭng mì-hâng, dó̤i hī piĕ mĕ̤k-ciŭ mâ̤ hō̤, hĕ̤k-ciā sê sāi-ê̤ṳng gĭ-ṳ̀ ùng-buōng (\\'\\'text-based\\'\\') hĕ̤k gĭ-ṳ̀ siăng-ĭng (\\'\\'speech-based\\'\\') gì báuk-lāng-ké (\\'\\'browser\\'\\') gì ê̤ṳng-hô lì gōng, cūng-kuāng cĭng mâ̤ lê-biêng. Cī òng, nàng-gă gó mò̤ 1 cṳ̄ng gá hō̤ gì huŏng-huák. Nâ sê gōng, cuòi īng-hiōng nṳ̄ ciáng-siòng piĕng-cĭk, chiāng nṳ̄ lièng-hiê guāng-lī-uòng.

Ôi lāu captcha gì ciáng-siòng gĕ̤ng-cáuk, nṳ̄ diŏh páh kŭi báuk-lāng-ké gì cookie.

Buóh diōng kó̤ piĕng-cĭk hiĕk-miêng, áik \"diōng kó̤ sèng 1 hiĕk\" (\\'\\'back\\'\\').",
);

/** Czech (Česky)
 * @author Li-sung
 * @author Danny B.
 * @author Matěj Grabovský
 * @author Siebrand
 */
$messages['cs'] = array(
	'captcha-edit'               => 'Abyste mohli editovat tuto stránku, musíte vyřešit následující jednoduchý součet a napsat výsledek. ([[Special:Captcha/help|Co tohle znamená?]])',
	'captcha-desc'               => 'Jednoduchá implementace ověřovacího kódu (captcha)',
	'captcha-addurl'             => 'Vaše editace obsahuje nové odkazy formou URL; v zájmu ochrany před automatickým spamováním musíte vyřešit následující jednoduchý součet a napsat výsledek. ([[Special:Captcha/help|Co tohle znamená?]])',
	'captcha-badlogin'           => 'V rámci ochrany před automatickým pokusům uhodnout heslo musíte vyřešit následující jednoduchý součet a napsat výsledek. ([[Special:Captcha/help|Co tohle znamená?]]):',
	'captcha-createaccount'      => 'V rámci ochrany před automatickým vytvářením účtů musíte pro provedení registrace vyřešit následující jednoduchý součet a napsat výsledek. ([[Special:Captcha/help|Co tohle znamená?]])',
	'captcha-createaccount-fail' => 'Chybějící či neplatný potvrzovací kód.',
	'captcha-create'             => 'Abyste mohli založit stránku musíte vyřešit následující jednoduchý součet a napsat výsledek. ([[Special:Captcha/help|Co tohle znamená?]])',
	'captchahelp-title'          => 'Nápověda ke captcha',
	'captchahelp-cookies-needed' => 'Musíte mít zapnuty cookies ve svém prohlížeči.',
	'captchahelp-text'           => 'Webové stránky, do kterých mohou přispívat jejich návštěvníci (jako například tato wiki), jsou často terčem spammerů, kteří pomocí automatických nástrojů vkládají své odkazy na velké množství stránek. Přestože lze tento spam odstranit, představuje nepříjemné obtěžování.

Někdy, zvláště při přidávání nových webových odkazů, vám může wiki ukázat obrázek barevného či pokrouceného textu a požádat vás o opsání zobrazených znaků. Jelikož takovou úlohu lze jen těžko automatizovat, skuteční lidé mohou dále přispívat, zatímco většinu spammerů a jiných robotických útočníků to zastaví.

Bohužel to však může představovat nepříjemný problém pro uživatele se zrakovým postižením či uživatele používající textové prohlížeče či hlasové čtečky. V současné době nemáme alternativní zvukovou verzi. Kontaktujte laskavě správce serveru, pokud vám to brání v užitečných příspěvcích a potřebujete pomoc.

Pro návrat na předchozí stránku stiskněte ve svém prohlížeči tlačítko „zpět“.',
	'captcha-addurl-whitelist'   => ' #<!-- leave this line exactly as it is --> <pre>
# Syntaxe je následující:
#  * Všechno od zaku „#“ do konce řádku je komentář
#  * Každý neprázdný řádek je fragment regulárního výrazu, kterého shody budou pouze stroje v rámci URL
  #</pre> <!-- leave this line exactly as it is -->',
	'right-skipcaptcha'          => 'Vykonávání akcí spojených s CAPTCHA bez nutnosti jejího řešení',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'captcha-edit'               => "Er mwyn gallu golygu'r dudalen, gwnewch y swm isod a gosodwch y canlyniad yn y blwch ([[Special:Captcha/help|rhagor o wybodaeth]]):",
	'captcha-desc'               => 'Gweithredu "captcha" syml',
	'captcha-addurl'             => 'Mae eich golygiad yn cynnwys cysylltiadau URL newydd. Er mwyn profi nad ydych yn beiriant sbam, teipiwch y geiriau canlynol yn y blwch isod os gwelwch yn dda. <br />([[Arbennig:Captcha/help|Mwy o wybodaeth]])',
	'captcha-badlogin'           => 'Er mwyn ceisio rhwystro peiriannau datrys cyfrineiriau, byddwch gystal â gwneud y swm isod a gosod yr ateb yn y blwch ([[Special:Captcha/help|rhagor o wybodaeth]]):',
	'captcha-createaccount'      => "Teipiwch y geiriau sy'n ymddangos yn y ddelwedd isod os gwelwch yn dda. Mae'r nodwedd hon yn rhwystro rhaglenni sbam rhag creu cyfrifon i'w hunain. <br />([[Arbennig:Captcha/help|Mwy o wybodaeth]])",
	'captcha-createaccount-fail' => "Côd cadarnhau ar goll neu'n anghywir.",
	'captcha-create'             => "Er mwyn gallu creu'r dudalen, gwnewch y swm isod a gosodwch y canlyniad yn y blwch ([[Special:Captcha/help|rhagor o wybodaeth]]):",
	'captchahelp-title'          => 'Cymorth "captcha"',
	'captchahelp-cookies-needed' => "Er mwyn i hyn weithio mae'n rhaid bod cookies wedi eu galluogi ar eich gwe-lywiwr.",
	'captchahelp-text'           => "Yn anffodus, mae safleoedd gwe fel Wicipedia, sy'n caniatau i'r cyhoedd ysgrifennu iddi, yn darged beunyddiol i sbamwyr sy'n defnyddio rhaglenni arbennig i bostio eu cysylltiadau. Gellir dileu'r dolenni o'r dudalen, ond mae hyn yn drafferth mawr. O dro i dro, fe fydd y safle hon yn dangos delwedd o destun, ac fe fydd yn rhaid i chi deipio'r geiriau a ddangosir. Mae hyn yn dasg anodd iawn i ragenni cyfrifiadurol, felly dylai golygwyr go iawn gyflawni'r dasg yn di-drafferth, yn wahanol i'r rhaglenni sbam. Mae hyn yn amlwg yn creu trafferthion i'r sawl sydd yn defnyddio porwyr testun neu sydd yn colli eu golwg. Ar hyn o bryd nid oes fersiwn sain ar gael. Cysylltwch â gweinyddwyr y safle os ydi'r nodwedd hon yn eich rhwystro rhag ychwanegu golygiadau dilys. Gwasgwch botwm 'nôl' eich porwr er mwyn dychwelyd.",
	'captcha-addurl-whitelist'   => '#<!-- leave this line exactly as it is --> <pre>
#
# Dyma\'r gystrawen:
#   * Mae popeth o nod "#" hyd at ddiwedd y llinell yn sylwad
#   * Mae pob llinell nad yw\'n wag yn ddarn regex sydd ddim ond yn cydweddu 
#   * gwesteiwyr tu mewn i gyfeiriadau URL

 #</pre> <!-- leave this line exactly as it is -->',
);

/** Danish (Dansk)
 * @author Wegge
 * @author Morten
 */
$messages['da'] = array(
	'captcha-edit'               => 'For at redigere denne side, skal du give svaret på regnestyket nedenfor, og angive resultatet i feltet under det. ([[Special:Captcha/help|mere information]]):',
	'captcha-addurl'             => 'Din redigering tilføjer nye eksterne henvisninger til artiklen. Som beskyttelse mod automatiseret spam, skal du give svaret på regnestyket nedenfor, og angive resultatet i feltet under det. ([[Special:Captcha/help|mere information]]):',
	'captcha-badlogin'           => 'For at beskytte mod automatiserede gæt på kodeord, skal du give svaret på regnestyket nedenfor, og angive resultatet i feltet under det. ([[Special:Captcha/help|mere information]]):',
	'captcha-createaccount'      => 'For at beskytte mod automatisk oprettelse af brugernavne, skal du give svaret på regnestyket nedenfor, og angive resultatet i feltet under det. ([[Special:Captcha/help|mere information]]):',
	'captcha-createaccount-fail' => 'Forkert eller manglende kodeord.',
	'captcha-create'             => 'For at oprette en ny side, skal du give svaret på regnestyket nedenfor, og angive resultatet i feltet under det. ([[Special:Captcha/help|mere information]]):',
	'captchahelp-title'          => 'Captcha-hjælp',
	'captchahelp-cookies-needed' => 'Din browser skal understøtte cookies, før dette kan gennemføres.',
	'captchahelp-text'           => "Websites der accepterer indhold fra offentligheden, bliver ofte udsat for angreb fra spammere. Disse angreb sker med automatiske værktøjer, der anbringer de samme links på et stort antal websites på kort tid. Selvom disse links kan fjernes, er de en vedligeholdelsesmæssig byrde.

I visse tilfælde, specielt når der tilføjes nye links til denne wiki, vil softwaren vise dig et billede af et stykke forvredet og sløret tekst. Du skal indtaste det ord, der vises, før du kan gennemføre handlingen. Formålet er at skelne mellem mennesker og automatiserede værktøjer, da de sidste har meget svært ved at genkende ordene.

Desværre kan dette medføre problemer for svagtseende brugere, og brugere der bruger software der oplæser indholdet af siden. For øjeblikket findes der ikke et lydbaseret alternativ. Kontakt venligst en administrator med henblik på at få hjælp, hvis dette forhindrer tilføjelsen af godartet materiale.

Tryk på 'tilbage'-knappen i din browser for at returnere til redigeringssiden.",
	'captcha-addurl-whitelist'   => ' #<!-- Undlad at rette denne linie --> <pre>
# Vejledning:
#   * Alt fra et "#"-tegn til slutningen af en linie er en kommentar
#   * Alle ikke-blanke linier benyttes som regulært udtryk, der anvendes på hostnavne i URLer
 #</pre> <!-- Undlad at rette denne linie -->',
);

/** German (Deutsch)
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'captcha-edit'               => 'Zur Bearbeitung der Seite löse die nachfolgende Rechenaufgabe und trage das Ergebnis in das Feld unten ein [[Special:Captcha/help|(Fragen oder Probleme?)]].',
	'captcha-desc'               => 'Einfache Captcha-Implementierung',
	'captcha-addurl'             => 'Deine Bearbeitung enthält neue externe Links.
Zum Schutz vor automatisiertem Spamming löse die nachfolgende Rechenaufgabe und trage das Ergebnis in das Feld unten ein. Klicke dann erneut auf „Seite speichern“ [[Special:Captcha/help|(Fragen oder Probleme?)]].',
	'captcha-badlogin'           => 'Zum Schutz vor einer Kompromittierung deines Benutzerkontos löse die nachfolgende Rechenaufgabe und trage das Ergebnis in das Feld unten ein [[Special:Captcha/help|(Fragen oder Probleme?)]]:',
	'captcha-createaccount'      => 'Zum Schutz vor automatisierter Anlage von Benutzerkonten löse die nachfolgende Rechenaufgabe und trage das Ergebnis in das Feld unten ein [[Special:Captcha/help|(Fragen oder Probleme?)]].',
	'captcha-createaccount-fail' => 'Falscher oder fehlender Bestätigungscode.',
	'captcha-create'             => 'Zur Erstellung der Seite löse die nachfolgende Rechenaufgabe und trage das Ergebnis in das Feld unten ein [[Special:Captcha/help|(Fragen oder Probleme?)]].',
	'captchahelp-title'          => 'Captcha-Hilfe',
	'captchahelp-cookies-needed' => "'''Wichtiger Hinweis:''' Es müssen Cookies im Browser erlaubt sein.",
	'captchahelp-text'           => 'Internetangebote, die für Beiträge von praktisch jedem offen sind — so wie das {{SITENAME}}-Wiki — werden oft von Spammern missbraucht, die ihre Links automatisch auf vielen Webseiten platzieren. Diese Spam-Links können wieder entfernt werden, sie sind aber ein erhebliches Ärgernis. In manchen Fällen, insbesondere beim Hinzufügen von neuen Weblinks zu einer Seite, kann es vorkommen, dass dieses Wiki ein Bild mit einem farbigen und verzerrten Text anzeigt und dazu auffordert, die angezeigten Wörter einzutippen. Da eine solche Aufgabe nur schwer automatisch erledigt werden kann, werden dadurch die meisten Spammer, die mit automatischen Werkzeugen arbeiten, gestoppt, wogegen menschliche Benutzer ihren Beitrag absenden können. Leider kann dies zu Schwierigkeiten für Personen führen, die über eine eingeschränkte Sehfähigkeit verfügen oder text- oder sprachbasierte Browser verwenden. Eine Lösung ist die reguläre Anmeldung als Benutzer. Der „Zurück“-Knopf des Browsers führt zurück in das Bearbeitungsfenster.',
	'captcha-addurl-whitelist'   => ' #<!-- leave this line exactly as it is --> <pre>
#  Syntax:
#   * Alles von einem #-Zeichen bis zum Ende der Zeile ist ein Kommentar
#   * Jeder nicht-leere Zeile ist ein Regex-Fragment, das gegenüber den Hostnamen einer URL geprüft wird
 #</pre> <!-- leave this line exactly as it is -->',
	'right-skipcaptcha'          => 'Überspringen der Captcha-Eingabe',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author Raimond Spekking
 */
$messages['de-formal'] = array(
	'captcha-edit'          => 'Zur Bearbeitung der Seite lösen Sie die nachfolgende Rechenaufgabe und tragen Sie das Ergebnis in das Feld unten ein [[{{ns:special}}:Captcha/help|(Fragen oder Probleme?)]].',
	'captcha-addurl'        => 'Ihre Bearbeitung enthält neue externe Links. Zum Schutz vor automatisiertem Spamming lösen Sie die nachfolgende Rechenaufgabe und tragen Sie das Ergebnis in das Feld unten ein. Klicken Sie dann erneut auf „Seite speichern“ [[{{ns:special}}:Captcha/help|(Fragen oder Probleme?)]].',
	'captcha-badlogin'      => 'Zum Schutz vor einer Kompromittierung Ihres Benutzerkontos lösen Sie die nachfolgende Rechenaufgabe und tragen Sie das Ergebnis in das Feld unten ein [[{{ns:special}}:Captcha/help|(Fragen oder Probleme?)]]:',
	'captcha-createaccount' => 'Zum Schutz vor automatisierter Anlage von Benutzerkonten lösen Sie die nachfolgende Rechenaufgabe und tragen Sie das Ergebnis in das Feld unten ein [[{{ns:special}}:Captcha/help|(Fragen oder Probleme?)]].',
	'captcha-create'        => 'Zur Erstellung der Seite lösen Sie die nachfolgende Rechenaufgabe und tragen Sie das Ergebnis in das Feld unten ein [[{{ns:special}}:Captcha/help|(Fragen oder Probleme?)]].',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Siebrand
 * @author ZaDiak
 * @author Badseed
 */
$messages['el'] = array(
	'captcha-badlogin'           => 'Για να βοηθήσετε στην προστασία ενάντια στον "σπασμένο" κωδικό πρόσβασης, παρακαλώ λύστε αυτή την απλή πράξη και εισάγετε το αποτέλεσμα της στο παρακάτω κενό ([[Special:Captcha/help|περισσότερες πληροφορίες]]):',
	'captcha-createaccount'      => 'Για να βοηθήσετε στην προστασία ενάντια στην αυτοματοποιημένη δημιουργία λογαριασμού, παρακαλώ λύστε την απλή πράξη
και εισάγετε την λύση της στο παρακάτω κενό
([[Special:Captcha/help|περισσότερες πληροφορίες]]):',
	'captcha-createaccount-fail' => 'Λάθος ή αγνοούμενος κωδικός ολοκλήρωσης.',
	'captchahelp-cookies-needed' => 'Θα πρέπει να έχετε τα cookies ενεργοποιημένα στον φυλλομετρητή σας για να εκτελεστεί η λειτουργία.',
	'captchahelp-text'           => "Οι ιστοσελίδες που δέχονται τις επεξεργασίες από το κοινό, όπως αυτό το wiki, δεν χρησιμοποιούνται συχνά σωστά από τους spammers που χρησιμοποιούν τα αυτοματοποιημένα εργαλεία για να αποστείλουν τις συνδέσεις τους με πολλές σελίδες. Αυτές οι spam συνδέσεις  μπορούν να αφαιρεθούν, επειδή είναι σημαντικά ενοχλητικές.

Μερικές φορές, ειδικά κατά την προσθήκη νέων συνδέσμων σε μια σελίδα, το wiki μπορεί να σας παρουσιάσει μια εικόνα με ένα χρωματισμένο ή διαστρεβλωμένο κείμενο και να σας ζητήσει να πληκτρολογήσετε τις λέξεις που παρουσιάζονται. Δεδομένου ότι αυτό είναι ένας στόχος που είναι δύσκολο να αυτοματοποιηθεί, θα επιτρέψει στους περισσότερους χρήστες να κάνουν τις επεξεργασίες τους, σταματώντας τους spammers και άλλους ρομποτικά επιτιθέμενους.

Δυστυχώς αυτό μπορεί να ενοχλήσει τους χρήστες περιορίζοντας το όραμα τους ή αυτούς που βασίζονται στο κείμενο ή στην ομιλία που βασίζεται στις μηχανές αναζήτησης. Προς το παρόν δεν έχουμε μια διαθέσιμη εναλλακτική λύση. Παρακαλώ ελάτε σε επαφή με τους διαχειριστές των σελίδων για βοήθεια, εάν αυτό σας αποτρέπει απροσδόκητα από την παραγωγή των νόμιμων επεξεργασιών.

Πατήστε το κουμπί 'πίσω' στη μηχανή αναζήτησης σας για να επιστρέψετε στο συντάκτη σελίδων.",
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'captcha-edit'               => 'Por redakti ĉi tiun paĝon, bonvolu solvi la simplan sumon jenan kaj enigi la respondon en la skatolo ([[Special:Captcha/help|plua informo]]):',
	'captcha-desc'               => 'Simpla realigo de Captcha',
	'captcha-addurl'             => 'Via redakto entenas novajn eksterajn ligilojn.
Por malhelpi aŭtomatan spamadon, bonvolu solvi la simplan problemon sube kaj entajpu la respondon en la kesto ([[Special:Captcha/help|pli da informo]]):',
	'captcha-badlogin'           => 'Helpi protekti kontraŭ aŭtomata divenado de pasvortoj, bonvolu solvi la simplan sumon kaj enigi la respondon en la skatolo ([[Special:Captcha/help|plua informo]]):',
	'captcha-createaccount'      => 'Helpi protekti kontraŭ aŭtomata konto-kreado, bonvolu solvi la simplan sumon suben
kaj enigi la respondon en la skatolo ([[Special:Captcha/help|plua informo]]):',
	'captcha-createaccount-fail' => 'Nekorekta aŭ mankanta konfirmkodo.',
	'captcha-create'             => 'Por krei la paĝon, bonvolu solvi la simplan sumon jenan kaj enigi la respondon en la skatolo ([[Special:Captcha/help|plua informo]]):',
	'captchahelp-title'          => 'Helpo por Captcha',
	'captchahelp-cookies-needed' => 'Vi devas ebligi kuketojn en via retumilo por ĉi tiu funkcii.',
	'captchahelp-text'           => "Retejoj kiuj akcepti informon de publiko, kiel ĉi tiu vikio, estas ofte misuzitaj de spamistoj kiu uzas aŭtomatajn ilojn por sendi ligilojn al multaj retejoj.
Kvankam ĉi tiu spam-ligiloj povas esti forigitaj, ili estas ĝeno.

Iufoje, ja kiam aldonante novajn retligilojn al paĝo, la vikio eble montros al vi bildon de bunta aŭ misformita teksto, kaj petos al vi tajpi la vortojn montratajn.
Tial ĉi tiu tasko estas malfacila por fari per roboto, elbigos al pliparto da homoj fari aldonaĵojn, kaj malebligos spamistojn kaj aliaj robotaj atakantoj.

Bedaŭrinde, ĉi tio eble ĝenetos uzantojn kun malbona vidkapablo kiu utiligas tekstajn aŭ voĉajn retumilojn.
Ĉi-momente, neniu aŭda alternativo estas havebla.
Bonvolu kontakti la administrantojn de la retejo por helpo se ĉi tio malebligas al vi fari bonan aldonon.

Klaku la 'reiru' butonon en via retumilo por reiri al la paĝo-redaktilo.",
	'captcha-addurl-whitelist'   => '  #<!-- ne ŝanĝu ĉi tiun linion iel ajn --> <pre>
# Sintakso estas jen:
#  * Ĉio ekde "#" signo al la fino de linio estas komento
#  * Ĉiu linio ne malplena estas ero de regex kiu kongruos retnodojn nur ene de ttt-adresoj
  #</pre> <!-- ne ŝanĝu ĉi tiun linion iel ajn -->',
	'right-skipcaptcha'          => "Faru ''captcha''-spronantaj agoj sen farante la ''captcha''-on",
);

/** Spanish (Español)
 * @author Icvav
 * @author Jatrobat
 * @author Lin linao
 */
$messages['es'] = array(
	'captcha-edit'               => 'Para editar este artículo, por favor resuelve la sencilla suma que aparece abajo e introduce la solución en la caja ([[Special:Captcha/help|más información]]):',
	'captcha-addurl'             => 'Tu edición incluye nuevos enlaces externos. Para ayudar a proteger contra el spam automatizado, por favor resuelve la sencilla suma de abajo e introduce la respuesta en la caja ([[Special:Captcha/help|más información]]):',
	'captcha-badlogin'           => 'Lo siguiente se ha implementado para resguardarse de la generación automática de cuentas. Por favor, resuelve la suma de más abajo e introduce el resultado en la caja ([[Special:Captcha/ayuda|más información]]):',
	'captcha-createaccount'      => 'Para ayudar a protegernos de la creación automática de cuentas, por favor resuelve la simple suma de abajo e introduce la respuesta en la caja ([[Special:Captcha/help|más información]]):',
	'captcha-createaccount-fail' => 'Falta el código de confirmación, o éste es incorrecto.',
	'captcha-create'             => 'Para crear la página, por favor resuelve la simple suma de abajo e introduce la respuesta en la caja ([[Special:Captcha/help|más información]]):',
	'captchahelp-title'          => 'Ayuda sobre el captcha',
	'captchahelp-cookies-needed' => 'Debe tener las cookies activadas en el navegador para que el sistema funcione.',
	'captchahelp-text'           => 'Los sitios web que aceptan mensajes del público, como esta wiki, son a menudo objeto de abusos  por spammers que utilizan programas para incluir automáticamente sus enlaces. Si bien estos enlaces pueden quitarse, son una gran molestia.

En ocasiones, especialmente cuando añada nuevos enlaces a una página, la wiki le mostrará una imagen de texto coloreado o distorsionado y le pedirá que escriba las palabras que muestra. Dado que esta es una tarea difícil de automatizar, permite a la mayoría de las personas enviar sus textos, a la vez que detiene a la mayoría de los spammers y otros atacantes automáticos.',
);

/** Estonian (Eesti)
 * @author BrokenArrow
 */
$messages['et'] = array(
	'captcha-edit'               => 'Teie muudatuses on uusi linke; kaitseks spämmi vastu peate sisestama järgneval pildil olevad sõnad:<br /> ([[Special:Captcha/help|Mis see on?]])',
	'captcha-addurl'             => 'Teie muudatuses on uusi linke; kaitseks spämmi vastu peate sisestama järgneval pildil olevad sõnad:<br /> ([[Special:Captcha/help|Mis see on?]])',
	'captcha-createaccount'      => 'Kaitsena spämmi vastu peate konto registreerimiseks lahtrisse kirjutama järgneva tehte tulemuse.<br /> ([[Special:Captcha/help|Mis see on?]])',
	'captcha-createaccount-fail' => 'Puuduv või valesti sisestatud kinnituskood.',
	'captcha-create'             => 'Teie muudatuses on uusi linke; kaitseks spämmi vastu peate sisestama järgneval pildil olevad sõnad:<br /> ([[Special:Captcha/help|Mis see on?]])',
	'captchahelp-title'          => 'Mis on Captcha?',
	'captchahelp-text'           => 'Internetisaite, mis lubavad külastajatel sisu muuta (nagu ka see Viki), kasutavad sageli spämmerid ära, postitades reklaamlinke - spämmi. Kuigi neid linke saab alati ära võtta, on nad ikkagi üpris tülikad. Omale kasutajakontot registreerides või mõnele lehele uusi internetiaadresse postitades näidatakse teile moonutatud tekstiga pilti ning palutakse teil sisestada seal näidatud sõnad. Kuna selliselt pildilt on arvutil raske teksti välja lugeda, on see efektiivseks kaitseks spämmirobotite vastu, samas lubades tavainimestel oma muudatusi rahus teha. Kahjuks võib see tekitada ebamugavusi nägemisraskustega inimestele või neile, kes kasutavad kõnesüntesaatorit või tekstipõhist brauserit. Hetkel pole meil helipõhist alternatiivi. Kui teil tekib ootamatult raskusi oma muudatuste tegemisel, siis kirjutage sellest [[Vikipeedia:Üldine arutelu|üldise arutelu]] lehele. Konto registreerimise lehele või lehe redigeerimisele tagasi jõudmiseks vajutage oma brauseri tagasi-nuppu.',
);

/** Basque (Euskara)
 * @author SPQRobin
 * @author BrokenArrow
 */
$messages['eu'] = array(
	'captcha-edit'               => 'Zure aldaketan URL lotura berriak daude; spam-a saihesteko, jarraian dagoen irudiko hitzak idaztea beharrezkoa da:<br /> ([[Special:Captcha/help|Zer da hau?]])',
	'captcha-addurl'             => 'Zure aldaketan URL lotura berriak daude; spam-a saihesteko, jarraian dagoen irudiko hitzak idaztea beharrezkoa da:<br /> ([[Special:Captcha/help|Zer da hau?]])',
	'captcha-createaccount'      => 'Spam-a saihesteko, mesedez, irudian agertzen den hizki edo zenbaki kodea, beheko laukian idatzi zure kontua sortzeko:<br /> ([[Special:Captcha/help|Zer da hau?]])',
	'captcha-createaccount-fail' => 'Baieztatze kode ezegokia.',
	'captcha-create'             => 'Zure aldaketan URL lotura berriak daude; spam-a saihesteko, jarraian dagoen irudiko hitzak idaztea beharrezkoa da:<br /> ([[Special:Captcha/help|Zer da hau?]])',
	'captchahelp-title'          => 'Captcha laguntza',
	'captchahelp-cookies-needed' => 'Beharrezkoa da nabigatzailean cookieak gaituta izatea honek funtzionatzeko.',
	'captchahelp-text'           => "Publikoki aldaketak egiteko aukerak dituzten webguneetan, wiki honetan bezalaxe, spam testuak gehitzen dira sarritan tresna automatikoak erabiliz. Lotura horiek ezabatu egin daitezkeen arren, traba dira. Batzutan, eta bereziki webgune berri bateko loturak gehitzen dituzunean, hitz batzuk dituen irudi bat agertuko zaizu, eta bertan ageri den testua idazteko eskatuko zaizu. Lan hori automatizatzeko zaila da, eta pertsonei ezer kostatzen ez zaigunez, spam testuak saihesteko lagungarria da. Zoritxarrez, ikusmen mugatua edo testu bidezko nabigatzaileak erabiltzen dituzten erabiltzeek arazoak izan ditzakete. Horrelako zerbait gertatzen bazaizu, mesedez, jarri administratzaileekin harremanetan. Zure nabigatzaileko 'atzera' lotura erabili aldaketen orrialdera itzultzeko.",
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'captcha-edit'               => 'برای ویرایش این مقاله، لطفاً حاصل جمع زیر را حساب کنید و نتیجه را در جعبه وارد کنید ([[Special:Captcha/help|اطلاعات بیشتر]]):',
	'captcha-desc'               => 'پیاده‌سازی سادهٔ CAPTCHA',
	'captcha-addurl'             => 'ویرایش شما شامل پیوندهای تازه‌ای به بیرون است. برای کمک به جلوگیری از ارسال خودکار هرزنامه‌ها، لطفاً حاصل جمع زیر را حساب کنید و نتیجه را در جعبه وارد کنید ([[Special:Captcha/help|اطلاعات بیشتر]]):',
	'captcha-badlogin'           => 'برای کمک به جلوگیری از سرقت خودکار کلمه عبور، لطفاً حاصل جمع زیر را حساب کنید و نتیجه را در جعبه وارد کنید ([[Special:Captcha/help|اطلاعات بیشتر]]):',
	'captcha-createaccount'      => 'برای جلوگیری از ایجاد خودکار حساب کاربری، لطفاً حاصل جمع زیر را حساب کنید و نتیجه را در جعبه وارد کنید ([[Special:Captcha/help|اطلاعات بیشتر]]):',
	'captcha-createaccount-fail' => 'کلمه تایید نادرست یا گم‌شده:',
	'captcha-create'             => 'برای ایجاد صفحه لطفاً حاصل جمع زیر را حساب کنید و نتیجه را در جعبه وارد کنید ([[Special:Captcha/help|اطلاعات بیشتر]]):',
	'captchahelp-title'          => 'راهنمای Captcha',
	'captchahelp-cookies-needed' => 'برای کار کردن آن، شما باید کوکی‌های مرورگرتان را فعال کنید.',
	'captchahelp-text'           => 'وبگاه‌هایی مثل این ویکی که به عموم اجازهٔ نوشتن مطلب می‌دهند، غالباً مورد سوءاستفادهٔ هرزفرستندگانی می‌شوند که با ابزارهای خودکار پیوندهای بیرونی به وبگاه‌های موردنظرشان وارد می‌کنند. این پیوندهای هرز و تبلیغاتی را می‌توان دستی حذف کرد، ولی به هر حال باعث اعصاب‌خردی زیادی می‌شوند.

گاهی اوقات، خصوصاً هنگامی که پیوندهای بیرونی جدیدی به صفحه اضافه می‌شود، ویکی ممکن است به شما تصویری رنگی و کج‌وکوله از متنی نشان بدهد و از شما بخواهد که کلمه‌های نشان‌داده‌شده را تایپ کنید. از آنجا که خودکارسازی این کار دشوار است، انسانهای واقعی می‌توانند پیوندهاشان را وارد کنند ولی برنامه‌های خودکار تبلیغاتی از خرابکاری باز خواهند ماند.
متأسفانه این امر ممکن است باعث مزاحمت برای کاربرانی شود که چشمشان ضعیف است یا از مرورگرهای متنی یا گفتاری استفاده می‌کنند. در حال حاضر ما جایگزین صوتی‌ای برای این کار نداریم. لطفاً اگر برای واردساختن پیوندهای مشروع دچار مشکل شده‌اید با مدیران این وبگاه تماس بگیرید.

دکمهٔ «بازگشت» را در مرورگر خود فشار دهید تا به صفحهٔ ویرایش بازگردید.',
	'captcha-addurl-whitelist'   => ' #<!-- این سطر را همان‌گونه که هست رها کنید --> <pre>
# قواعد به این شکل است:
#  * همه‌چیز از «#» تا آخر سطر یک توضیح در نظر گرفته می‌شود.
#  * هر سطری که خالی نباشد یک قطعه در نظر گرفته می‌شود که فقط با نام میزبان اینترنتی سنجیده می‌شود.
  #</pre> <!-- این سطر را همان‌گونه که هست رها کنید -->',
	'right-skipcaptcha'          => 'انجام کارهایی که CAPTCHA را فعال می‌کنند بدون نیاز به گذر از CAPTCHA',
);

/** Finnish (Suomi)
 * @author Nike
 * @author Siebrand
 * @author Crt
 */
$messages['fi'] = array(
	'captcha-edit'               => 'Ratkaise alla oleva summa jatkaaksesi ([[Special:Captcha/help|lisätietoja]]):',
	'captcha-desc'               => 'Yksinkertainen ihmisvarmennustoteutus.',
	'captcha-addurl'             => 'Muokkauksesi sisältää uusia linkkejä muille sivuille. Ratkaise alla oleva summa jatkaaksesi ([[Special:Captcha/help|lisätietoja]]):',
	'captcha-badlogin'           => 'Salasananmurtajasovellusten takia, ratkaise alla oleva summa jatkaaksesi ([[Special:Captcha/help|lisätietoja]]):',
	'captcha-createaccount'      => 'Ratkaise alla oleva summa jatkaaksesi ([[Special:Captcha/help|lisätietoja]]):',
	'captcha-createaccount-fail' => 'Väärä tai puuttuva varmistuskoodi.',
	'captcha-create'             => 'Ratkaise alla oleva summa jatkaaksesi ([[Special:Captcha/help|lisätietoja]]):',
	'captchahelp-title'          => 'Captcha-ohje',
	'captchahelp-cookies-needed' => 'Tämä toiminto vaatii evästeiden hyväksymistä.',
	'captchahelp-text'           => 'Verkkosivut, jotka sallivat ulkopuolisten lisätä sisältöä, joutuvat usein spam-hyökkäysten kohteeksi. Spam-hyökkäyksessä spammerit käyttävät työkaluja, jotka automaattisesti lisäävät linkkejä monille sivuille. Vaikka nämä linkit voidaan poistaa, aiheutuu niistä silti merkittävä haitta.

Joskus, erityisesti kun lisäät uusia linkkejä, saatat nähdä kuvan, jossa on värillistä ja vääristynyttä tekstiä, ja sinua pyydetään kirjoittamaan sen sisältämät sanat. Koska tätä tehtävää on vaikea automatisoida, se sallii melkein kaikkien oikeiden ihmisten tehdä muutoksensa, mutta estää automaattiset lisäykset.

Valitettavasti tämä saattaa estää käyttäjiä, joilla on rajoittunut näkökyky tai käyttäjiä, jotka käyttävät teksti- tai puhepohjaisia selaimia. Ota yhteyttä sivuston ylläpitäjään, jos et pysty tekemään kunnollisia muutoksia.

Varmistus ei toimi, jos evästeet eivät ole käytössä.

Voit palata muokkaustilaan selaimen paluutoiminnolla.',
	'captcha-addurl-whitelist'   => ' #<!-- leave this line exactly as it is --> <pre>
# Syntaksi on seuraava:
#  * Kaikki #-merkistä eteenpäin on kommenttia
#  * Jokainen ei-tyhjä rivi on säännöllisen lausekkeen osa, joka suoritetaan vain linkeissä esiintyville verkkonimille.
  #</pre> <!-- leave this line exactly as it is -->',
);

/** Faroese (Føroyskt)
 * @author Spacebirdy
 */
$messages['fo'] = array(
	'captcha-createaccount' => 'Sum ein vernd ímóti sjálvvirknum spam, er neyðugt hjá tær at skriva inn tey orð, sum koma fyri á myndini fyri at stovna eina kontu: <br />([[Special:Captcha/help|Hvat er hetta?]])',
	'captchahelp-title'     => 'Captcha hjálp',
);

/** French (Français)
 * @author Urhixidur
 * @author Grondin
 * @author Sherbrooke
 * @author Meithal
 * @author Siebrand
 * @author Seb35
 */
$messages['fr'] = array(
	'captcha-edit'               => 'Pour modifier cette page, vous être prié d’effectuer le calcul ci-dessous et d’en inscrire le résultat dans le champ ([[Special:Captcha/help|Plus d’infos]]) :',
	'captcha-desc'               => 'Simple implémentation captcha',
	'captcha-addurl'             => 'Votre édition inclut de nouveaux liens externes. Comme protection contre le pourriel automatique, veuillez entrer le résultat de l’opération ci-dessous dans la boîte ([[Special:Captcha/help|plus d’informations]]) :',
	'captcha-badlogin'           => 'Afin de lutter contre le piratage automatisé de mots de passe par des bots, vous être prié d’effectuer le calcul ci-dessous et d’en inscrire le résultat dans le champ ci-dessous ([[Special:Captcha/help|plus d’infos]]) :',
	'captcha-createaccount'      => 'Comme protection contre les créations de compte abusives, veuillez entrer le résultat de l’opération dans la boîte ci-dessous ([[Special:Captcha/help|plus d’informations]]) :',
	'captcha-createaccount-fail' => 'Code de confirmation erroné ou manquant.',
	'captcha-create'             => 'Pour modifier la page, vous être prié d’effectuer le calcul ci-dessous et d’en inscrire le résultat dans le champ ([[Special:Captcha/help|Plus d’infos]]) :',
	'captchahelp-title'          => 'Aide sur les captcha',
	'captchahelp-cookies-needed' => "Il faut activer les témoins (''cookies'') de votre navigateur Web pour que cela fonctionne.",
	'captchahelp-text'           => "Les sites Web acceptant des contributions du public, comme ce wiki, sont souvent utilisés par des spammeurs qui utilisent des outils automatiques pour placer de nombreux liens vers leurs sites.
Même si ces liens de « spam » peuvent être enlevés, ils n'en représentent pas moins une nuisance.

Parfois, en particulier lors de l’ajout de nouveaux liens externes à une page, le wiki peut vous montrer une image représentant un texte brouillé et vous demander de taper les mots indiqués.
Cette tâche est difficile à automatiser, et permet aux humains de faire leurs contributions tout en stoppant la plupart des spammeurs.

Cette solution peut malheureusement gêner les utilisateurs malvoyants ou ceux utilisant un navigateur en texte seul.
Nous ne disposons pas d’alternative audio pour l’instant.
Veuillez contacter un administrateur du site si vous ne parvenez pas à faire vos contributions.

Cliquez sur le bouton « Précédent » de votre navigateur pour revenir sur la page d’édition.",
	'captcha-addurl-whitelist'   => " #<!-- laissez cette ligne exactement telle quelle --> <pre>
# La syntaxe est la suivante :
#   * Tout caractère suivant « # » jusqu'à la fin de la ligne sera interprêté comme un commentaire
#   * Toute ligne non vide est un code regex qui sera utilisé uniquement à l'intérieur des liens hypertextes.
  #</pre> <!-- laissez cette ligne exactement telle quelle -->",
	'right-skipcaptcha'          => 'Accomplit le déclenchement des actions de captcha sans devoir passer par l’intermédiaire de ce dernier',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'captcha-edit'               => 'Por modifiar ceta pâge, volyéd entrar lo rèsultat de l’opèracion dens la bouèta ce-desot ([[Special:Captcha/help|més d’enformacions]]) :',
	'captcha-desc'               => 'Simpla emplèmentacion captcha',
	'captcha-addurl'             => 'Voutra modificacion encllut de novéls lims de defôr. Coment protèccion contre lo spame ôtomatico, volyéd entrar lo rèsultat de l’opèracion dens la bouèta ce-desot ([[Special:Captcha/help|més d’enformacions]]) :',
	'captcha-badlogin'           => 'Coment protèccion contre lo piratâjo ôtomatisâ de mots de pâssa per des bots, volyéd entrar lo rèsultat de l’opèracion dens la bouèta ce-desot ([[Special:Captcha/help|més d’enformacions]]) :',
	'captcha-createaccount'      => 'Coment protèccion contre les crèacions de compto abusives, volyéd entrar lo rèsultat de l’opèracion dens la bouèta ce-desot ([[Special:Captcha/help|més d’enformacions]]) :',
	'captcha-createaccount-fail' => 'Code de confirmacion fôx ou manquent.',
	'captcha-create'             => 'Por crèar ceta pâge, volyéd entrar lo rèsultat de l’opèracion dens la bouèta ce-desot ([[Special:Captcha/help|més d’enformacions]]) :',
	'captchahelp-title'          => 'Éde sur los captcha',
	'captchahelp-cookies-needed' => "Fôt activar los tèmouens (''cookies'') dens voutron navigator por que cen fonccione.",
	'captchahelp-text'           => 'Los setos Malyâjo accèptent des contribucions du publico, coment ceti vouiqui, sont sovent utilisâs per des spamors qu’utilisont des outils ôtomaticos por placiér tot plen de lims vers lors setos. Quand ben que celos lims de « spame » porriant étre enlevâs, reprèsentont una nuésence.

Des côps, en particuliér pendent l’aponsa de novéls lims de defôr a una pâge, lo vouiqui pôt vos montrar una émâge reprèsentent un tèxte colorâ ou ben tordu et vos demandar de buchiér los mots montrâs. Cél ovrâjo est dificilo a ôtomatisar, et pèrmèt ux homos de fâre lors contribucions tot en arrètent la plepârt des spamors.

Mâlherosament ceta solucion pôt gênar los utilisators mâl-veyents ou utilisent un navigator en tèxte solèt. Nos disposens pas d’altèrnativa ôdiô por lo moment. Volyéd vos veriér vers un [[Special:Listusers/sysop|administrator]] du seto se vos arrevâd pas a fâre voutres contribucions.

Clicâd sur lo boton « Prècèdent » de voutron navigator por tornar a la pâge d’èdicion.',
	'captcha-addurl-whitelist'   => ' #<!-- lèssiéd ceta legne justo d’ense --> <pre>
# La sintaxa est la siuventa :
#  * Tot caractèro siuvent « # » tant qu’a la fin de la legne serat entèrprètâ coment un comentèro.
#  * Tota legne pas voueda est un bocon de RegEx que serat utilisâ ren qu’u dedens des lims hipèrtèxte.
  #</pre> <!-- lèssiéd ceta legne justo d’ense -->',
);

/** Friulian (Furlan)
 * @author Klenje
 */
$messages['fur'] = array(
	'captcha-edit'               => 'Par cambiâ cheste pagjine, tu âs di risolvi cheste facile some e inserî la rispueste inte casele ([[Special:Captcha/help|altris informazions]]):',
	'captcha-createaccount-fail' => 'Il codiç di control al mancje o nol è just.',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'captcha-addurl'             => 'Jo hawwe keppelings om utens oanpast/taheakke. As ekstra beskerming tsjin automatysk oanmakke reklame (SPAM) wurdt jo frege it antwurd op de ûndersteande som te jaan ([[Special:Captcha/help|meer ynformaasje]]):',
	'captcha-createaccount'      => 'As beskerming tsjin it automatysk oanmeitsjen fan meidochnammen wurdt jo frege it antwurd op de ûndersteande som te jaan ([[Special:Captcha/help|meer ynformaasje]]):',
	'captcha-createaccount-fail' => 'It antwurd op de som kloppet net.',
	'captcha-create'             => 'Om de side oan te meitsjen wurdt jo frege it antwurd op de ûndersteande som te jaan ([[Special:Captcha/help|meer ynformaasje]]):',
	'captchahelp-text'           => "Websteeën dêr't it publyk op skriuwe kin, lykas dizze wiki, kinne lêst hawwe fan lju dy't automatysk keppelings oan de websiden tafoegje. Op dizze wiki kinne sokke feroarings maklik weromset wurde, mar dat nimt al tiid dy't ek oars brûkt wurde kin.

By it oanmelden as meidogger, en fierders benammen at jo keppelings om utens oan in side tafoegje, kinne jo fan de  wiki in lettertoets krije. De wiki lit dan kleurde of ferwrongen letters sjen, en jo wurdt frege dy oer te tikken. Om't dit net maklik automatisearre wurde kin, hâldt dit it automatysk tafoegjen tsjin. It spitigernôch ek in lytse lêst foar de meidoggers.

In probleem dêr't noch gjin oplossing foar is it dat it in tûkelteam is foar minsken dy't net goed sjen kinne of dy't in tekst-blêder of lûd-blêder brûke. Hjir soe in lûd-ferzje foar komme moatte, mar dy is der noch net. Oerlis mei in [[Wikipedy:Behearders|behearder]] at dit foar jo problemen jout.

(Gean tebek mei de tebek-knop fan jo blêder.)",
);

/** Irish (Gaeilge)
 * @author SPQRobin
 * @author Alison
 */
$messages['ga'] = array(
	'captcha-edit'               => 'Tá naisc URL nua san athrú seo atá tú ar tí a dhéanamh; mar chosaint in éadan turscair uathoibrithe, caithfidh tú na focail san íomhá seo a ionchur: <br />([[Special:Captcha/help|Céard é seo?]])',
	'captcha-addurl'             => 'Tá naisc URL nua san athrú seo atá tú ar tí a dhéanamh; mar chosaint in éadan turscair uathoibrithe, caithfidh tú na focail san íomhá seo a ionchur: <br />([[Speisialta:Captcha/help|Céard é seo?]])',
	'captcha-createaccount'      => 'Mar chosaint in éadan turscair uathoibrithe, caithfidh tú na focail san íomhá seo a ionchur chun cuntas a chlárú: <br />([[Speisialta:Captcha/help|Céard é seo?]])',
	'captcha-createaccount-fail' => 'Ní raibh an cód deimhnithe ceart sa bhosca, nó ní raibh aon chód ann ar chor ar bith.',
	'captcha-create'             => 'Tá naisc URL nua san athrú seo atá tú ar tí a dhéanamh; mar chosaint in éadan turscair uathoibrithe, caithfidh tú na focail san íomhá seo a ionchur: <br />([[Special:Captcha/help|Céard é seo?]])',
	'captchahelp-title'          => 'Cabhair maidir le Captcha',
);

/** Galician (Galego)
 * @author Toliño
 * @author Alma
 * @author Siebrand
 * @author Xosé
 */
$messages['gl'] = array(
	'captcha-edit'               => 'Para editar esta páxina, resolva a suma simple que aparece embaixo e introduza a resposta na caixa ([[Special:Captcha/help|máis información]]):',
	'captcha-desc'               => 'Introdución sinxela do Captcha',
	'captcha-addurl'             => 'A súa edición inclúe novas ligazóns externas.
Como protección fronte ás ferramentas de publicación automática de ligazóns publicitarias, por favor resolva a simple suma de embaixo e teclee resposta na caixa ([[Special:Captcha/help|máis información]]):',
	'captcha-badlogin'           => 'Como protección para que non se descubra o contrasinal por medios automáticos, resolva a simple suma de embaixo e introduza a resposta na caixa ([[Special:Captcha/help|máis información]]):',
	'captcha-createaccount'      => 'Como protección fronte á creación automática de contas de usuario ten que resolver a suma de embaixo e teclear a resposta na caixa ([[Special:Captcha/help|máis información]]):',
	'captcha-createaccount-fail' => 'Falta o código de confirmación ou é incorrecto.',
	'captcha-create'             => 'Para crear a páxina, resolva a suma simple que aparece embaixo e introduza a resposta na caixa ([[Special:Captcha/help|Que é isto?]]):',
	'captchahelp-title'          => 'Axuda acerca do Captcha',
	'captchahelp-cookies-needed' => 'Necesita ter as <i>cookies</i> habilitadas no seu navegador para que funcione.',
	'captchahelp-text'           => "'''CAPTCHA''' (acrónimo de \"'''C'''ompletely '''A'''utomated '''P'''ublic '''T'''uring test to tell '''C'''omputers and '''H'''umans '''A'''part\") é un test de autentificación do tipo desafío-resposta usado nos contornos informáticos para distinguir usuarios humanos de máquinas.

Os sitios web que aceptan publicar as contribucións dos usuarios, coma este wiki, sofren, con frecuencia, o abuso por parte de ''spammers'' que usan ferramentas que automatizan a inclusión de lixo en forma de ligazóns publicitarias, nunha chea de páxinas, en pouco tempo.
Mentres ditas ligazóns non son eliminadas supoñen unha molestia e unha perda de tempo.

En ocasións, en particular cando engada algunha nova ligazón externa, o wiki pode amosar unha imaxe dun texto coloreado e distorsionado e pedirlle que teclee as palabras amosadas.
Como esta tarefa é difícil de automatizar, permite distinguir entre persoas e robots e dificulta os ataques automatizados dos ''spammers''.

Por desgraza, isto é un inconveniente para aqueles usuarios con dificultades de visión ou que utilicen navegadores de texto ou navegadores baseados en sistemas de voz.
Polo de agora non dispoñemos dunha alternativa de audio.
Por favor, contacte cun administrador do wiki para solicitar axuda se o sistema lle impide rexistrarse para facer contribucións lexítimas.

Prema no botón \"atrás\" para voltar á páxina na que estaba editando.",
	'captcha-addurl-whitelist'   => ' #<!-- deixe esta liña exactamente como está --> <pre>
# A sintaxe é a seguinte:
#   * Todo o que vai desde o carácter "#" até o final da liña é un comentario
#   * Cada liña que non estea en branco é un fragmento de expresión regular que só coincidirá con hosts dentro de URLs
  #</pre> <!-- deixe esta liña exactamente como está -->',
	'right-skipcaptcha'          => 'Levar a cabo as accións que requiren captcha sen ter que introducilo',
);

/** Gujarati (ગુજરાતી)
 * @author Dsvyas
 * @author Siebrand
 */
$messages['gu'] = array(
	'captcha-edit'               => 'આ લેખમાં ફેરફાર કરવા માટે નીચે આપેલા સરળ દાખલાનો જવાબ તેની બાજુના ખાનામાં લખો ([[Special:Captcha/help|more info]]):',
	'captcha-addurl'             => 'તમે કરેલા ફેરફારોમાં નવી બાહ્ય કડીઓ સામેલ છે. સ્વચાલિત સ્પેમ/સ્પામ(spam) થી બચવા માટે નીચે આપેલા સરળ દાખલાનો જવાબ તેની બાજુના ખાનામાં લખો
([[Special:Captcha/help|more info]]):',
	'captcha-badlogin'           => 'આપોઆપ થતી ગુપ્તસંજ્ઞાની ચોરી (password cracking)થી બચાવવા માટે નીચે આપેલા સરળ દાખલાનો જવાબ તેની બાજુના ખાનામાં લખો ([[Special:Captcha/help|more info]]):',
	'captcha-createaccount'      => 'આપોઆપ નવા ખાતા ખુલતા રોકવા માટે નીચે આપેલા સરળ દાખલાનો જવાબ તેની બાજુના ખાનામાં લખો',
	'captcha-createaccount-fail' => 'ખોટી અથવા ખૂટતી પુષ્ટિ સંજ્ઞા',
	'captcha-create'             => 'નવું પાનું બનાવવા માટે નીચે આપેલા સરળ દાખલાનો જવાબ તેની બાજુના ખાનામાં લખો  ([[Special:Captcha/help|more info]]):',
	'captchahelp-title'          => 'કેપ્ટ્ચા/કેપ્ચા (Captcha) મદદ',
	'captchahelp-cookies-needed' => 'આ વ્યવસ્થિત રીતે જોઇ શકાય તે માટે તમારા બ્રાઉઝરમાં કુકીઝ એનેબલ કરેલી હોવી જોઇશે.',
	'captchahelp-text'           => "આપણી વિકિ જેવી વૅબ સાઇટો કે જે લોકોને યોગદાન કરવાની પરવાનગી આપે છે, તેમેનો સ્પામરો દ્વારા દુરૂપયોગ થતો આવ્યો છે. આવા સ્પામરો તેમની કડીઓ એક સાથે અનેક વૅબ સાઇટો પર મુકવા માટે સ્વચાલિત સાધનો (Tools) વાપરે છે. આવી કડીઓ ખરેખર એક દૂષણ છે અને તેને દૂર કરવાના ઉપાય કરવા જોઇએ.

ક્યારેક, ખાસ કરીને જ્યારે તમે તમારા લેખમાં બાહ્ય કડી ઉમેરતા હોવ ત્યારે, વિકિ તમને એક રંગીન કે તુટેલા-ફુટેલા અક્ષરો કે શબ્દોનું ચિત્ર બતાવે અને તેમા વંચાતા શબ્દો બાજુનાં ખાનામાં લખવા માટે પુછે એવું બને. આનું કારણ એ છે કે આ એક એવી પદ્ધતિ છે જે સ્વચાલિત રીતે કરવી લગભગ અશક્ય છે, અને ફક્ત વ્યક્તિગત રીતે જ થઇ
શકે છે, જે સ્પામરો અને અન્ય ઘુસણખોરો ના હુમલાને ખાળે છે.

કમભાગ્યે આ પદ્ધતિ, એવા લોકોને તકલિફ આપે તેમ છે જેઓની દૃષ્ટિ નબળી છે અથવાતો જેઓ વાચા આધારીત કે સાદા બ્રાઉઝરનો ઉપયોગ કરે છે. હાલમા અમારી પાસે આવા ચિત્રોની વાચા આધારિત વ્યવસ્થા નથી. જો આ કારણે આપ કોઇ લેખમાં પ્રદાન ન કરી શકતા હોવ તો વધુ સહાય માટે કૃપા કરી પ્રબંધકનો સંપર્ક સાધો.

લેખમા ફેરફાર કરવાના પાના ઉપર પાછા ફરવા માટી આપના બ્રાઉઝરના 'બેક' બટન ઉપર ક્લિક કરો.",
	'captcha-addurl-whitelist'   => ' #<!-- આ લીટીને જેમ છે તેમ જ રહેવા દો --> <pre>
# સીન્ટેક્સ (Syntax) આ પ્રમાણે છે :  
#  * "#" સંજ્ઞાથી શરૂ કરીને લીટીના અંત સુધીનું વર્ણન એક ટીપ્પણી છે
#  * ખાલી ન હોય તેવી દરેક લીટી રેજેક્સનો ભાગ છે, જે ફક્ત URLsમાંના હોસ્ટ સાથે જ મેળ ખાશે
  #</pre> <!-- આ લીટીને જેમ છે તેમ જ રહેવા દો -->',
);

/** Hebrew (עברית)
 */
$messages['he'] = array(
	'captcha-edit'               => 'כדי לערוך את הדף, אנא פיתרו את תרגיל החיבור הפשוט שלהלן והקלידו את התשובה בתיבה ([[Special:Captcha/help|מידע נוסף]]):',
	'captcha-desc'               => 'מימוש פשוט של CAPTCHA',
	'captcha-addurl'             => 'עריכתכם כוללת קישורים חיצוניים חדשים. כהגנה מפני ספאם אוטומטי, אנא פיתרו את תרגיל החיבור הפשוט שלהלן והקלידו את התשובה בתיבה ([[Special:Captcha/help|מידע נוסף]]):',
	'captcha-badlogin'           => 'כהגנה מפני פריצת סיסמאות אוטומטית, אנא פיתרו את תרגיל החיבור הפשוט שלהלן והקלידו את התשובה בתיבה ([[Special:Captcha/help|מידע נוסף]]):',
	'captcha-createaccount'      => 'כהגנה מפני יצירת חשבונות אוטומטית, אנא פיתרו את תרגיל החיבור הפשוט שלהלן והקלידו את התשובה בתיבה ([[Special:Captcha/help|מידע נוסף]]):',
	'captcha-createaccount-fail' => 'לא הקלדתם קוד אישור, או שהוא שגוי.',
	'captcha-create'             => 'כדי ליצור את הדף, אנא פיתרו את תרגיל החיבור הפשוט שלהלן והקלידו את התשובה בתיבה ([[Special:Captcha/help|מידע נוסף]]):',
	'captchahelp-title'          => 'עזרה במערכת הגנת הספאם',
	'captchahelp-cookies-needed' => 'עליכם להפעיל את תכונת העוגיות (Cookies) בדפדפן שלכם כדי שזה יעבוד.',
	'captchahelp-text'           => "פעמים רבות מנצלים ספאמרים אתרים שמקבלים תוכן מהציבור, כמו הוויקי הזה, כדי לפרסם את הקישורים שלהם לאתרים רבים באינטרנט, באמצעות כלים אוטומטיים. אמנם ניתן להסיר את קישורי הספאם הללו, אך זהו מטרד משמעותי.

לעיתים, בעיקר כשאתם מכניסים קישורי אינטרנט חדשים לתוך עמוד, הוויקי עשוי להראות תמונה של טקסט צבעוני או מעוקם ויבקש מכם להקליד את המילים המוצגות. כיוון שזו משימה שקשה לבצעה בצורה אוטומטית, הדבר יאפשר לבני־אדם אמיתיים לשלוח את הדפים, אך יעצור את רוב הספאמרים והמתקיפים הרובוטיים.

לרוע המזל, הדבר עשוי לגרום לאי נוחות למשתמשים עם דפדפן בגרסה מוגבלת, או שמשתמשים בדפדפנים מבוססי טקסט או דיבור. כרגע, אין לנו חלופה קולית זמינה. אנא צרו קשר עם מנהלי האתר לעזרה אם המערכת מונעת מכם באופן בלתי צפוי לבצע עריכות לגיטימיות.

אנא לחצו על הכפתור 'Back' בדפדפן שלכם כדי לחזור לדף העריכה.",
	'captcha-addurl-whitelist'   => ' #<!-- יש להשאיר שורה זו בדיוק כפי שהיא כתובה --> <pre>
# זהו תחביר ההודעה:
#   * כל דבר בשורה שנכתב לאחר סימן "#" הוא הערה
#   * כל שורה לא ריקה היא ביטוי רגולרי שיתאים לאתרים בכתובות URL
 #</pre> <!-- יש להשאיר שורה זו בדיוק כפי שהיא כתובה -->',
	'right-skipcaptcha'          => 'ביצוע פעולות הדורשות פיתרון CAPTCHA ללא צורך בפיתרונו',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 * @author Shyam
 */
$messages['hi'] = array(
	'captcha-edit'               => 'यह पन्ना संपादित करने के लिये, नीचे दिये हुए आसान राशि का जवाब दिये हुए टेक्स्टबॉक्समें लिखें ([[Special:Captcha/help|अधिक ज़ानकारी]]):',
	'captcha-desc'               => 'आसानसे कॅपचा (captcha) का इस्तेमाल',
	'captcha-addurl'             => 'आपके बदलावोंमें नई बाह्यकड़ियां हैं। अपने आप होने वाले स्पॅमसे बचने के लिये, नीचे दिये हुए आसान राशि का जवाब दिये हुए टेक्स्टबॉक्समें लिखें ([[Special:Captcha/help|अधिक ज़ानकारी]]):',
	'captcha-badlogin'           => 'अपने आप होनेवाले कूटशब्द के भेद से बचने के लिये, नीचे दिये हुए आसान राशि का जवाब दिये हुए टेक्स्टबॉक्समें लिखें ([[Special:Captcha/help|अधिक ज़ानकारी]]):',
	'captcha-createaccount'      => 'अपने आप होने वाले सदस्य पंजीकरण से बचने के लिये, नीचे दिये हुए आसान राशि का जवाब दिये हुए टेक्स्टबॉक्समें लिखें ([[Special:Captcha/help|अधिक ज़ानकारी]]):',
	'captcha-createaccount-fail' => 'गलत या खाली सहमती कोड।',
	'captcha-create'             => 'यह पन्ना बनाने के लिये, नीचे दिये हुए आसान राशि का जवाब दिये हुए टेक्स्टबॉक्समें लिखें ([[Special:Captcha/help|अधिक ज़ानकारी]]):',
	'captchahelp-title'          => 'कॅप्टचा सहायता',
	'captchahelp-cookies-needed' => 'यह कार्य करने के लिये आपने कूकीज (cookies) एनेबल किया होना आवश्यक हैं।',
	'captchahelp-text'           => "वेब साईट, जो की स्वतंत्र एवं मुक्त रूप से सभी लेख स्वीकार कराती है, जैसे यह विकी, प्राय: अनचाहे तत्वों द्वारा दूषित होती रहती है, जो कि यंत्रचलित उपकरणों से कई साईट के अपने सम्पर्क दर्शाती हैं।
जबकि यह अनचाहे सम्पर्क हटाये जा सकते हैं, फिर भी यह एक बहुत बड़ा उपद्रव है।

कुछ बार, विशेषत: जब एक पृष्ठ पर एक नया वेब सम्पर्क जोडा जाता है, तब विकी एक विकृत विषय वस्तु या रंगीन चित्र दर्शाती है और आपको दिखाए गए शब्द लिखने के लिए कहती है।
क्योंकि यह एक ऐसा कार्य है जो कि स्वचालित हो पाना मुश्किल है, यह अधिकांशत: वास्तविक मनुष्यों को ही अपने लेख लिखने कि अनुमति देती है और अधिकांश अनचाहे तत्वों एवं अन्य स्वचालित आक्रमकों को रोकती है।

दुर्भाग्यवश इससे सदस्यों को सीमित दर्शन अथवा विषय वस्तु-आधारित या भाषण-आधारित ब्राउजर के प्रयोग के साथ असुविधा होती है।
इस समय हमारे पास श्रव्य विकल्प उपलब्ध नहीं है।
यदि यह आपको तर्कसंगत लिखावट से अनपेक्षित रूप से वंचित कर रहा है तो कृपया साईट प्रशासक से सहायता के लिए सम्पर्क करें।

पृष्ठ संपादक तक लौटने के लिए आपके ब्राउजर में 'back' बटन पर वार करें।",
	'captcha-addurl-whitelist'   => ' #<!-- leave this line exactly as it is --> <pre>
# इसकी रुपरेषा इस प्रकार हैं:
#  * "#" से शुरु होनेवाली सभी लाईनें टिप्पणीयाँ हैं।
#  * हर अन्य लाईन regex fragment हैं जो सिर्फ URL के होस्टस्‌ को जोडता हैं
   #</pre> <!-- leave this line exactly as it is -->',
	'right-skipcaptcha'          => 'Captcha में जाये बिना Captcha का इस्तेमाल करने के लिये मजबूर करें',
);

/** Croatian (Hrvatski)
 * @author SpeedyGonsales
 * @author Dnik
 * @author Dalibor Bosits
 */
$messages['hr'] = array(
	'captcha-edit'               => 'Da uredite ovu stranicu, molimo riješite jednostavno zbrajanje ispod i unesite rezultat u rubriku ([[Special:Captcha/help|više informacija]]):',
	'captcha-desc'               => 'Jednostavna implementacija captcha sustava',
	'captcha-addurl'             => 'Vaše uređivanje sadrži nove vanjske poveznice. Kao zaštitu od automatskog spama, trebate unijeti slova koja vidite na slici: <br />([[Special:Captcha/help|Pomoć?]])',
	'captcha-badlogin'           => 'Da se spriječi automatizirano pogađanje lozinki,
molimo zbrojite donje brojeve i upišite rezultat ([[Special:Captcha/help|pomoć]]):',
	'captcha-createaccount'      => 'Kao zaštitu od automatskog spama, pri otvaranju računa trebate unijeti slova koja vidite na slici: <br />([[Special:Captcha/help|Pomoć]])',
	'captcha-createaccount-fail' => 'Potvrdni kod je nepotpun ili netočan.',
	'captcha-create'             => 'Vaše uređivanje sadrži nove vanjske poveznice. Kao zaštitu od automatskog spama, trebate unijeti slova koja vidite na slici: <br />([[Special:Captcha/help|Pomoć?]])',
	'captchahelp-title'          => 'Antispam pomoć',
	'captchahelp-cookies-needed' => "Trebate imati uključene kolačiće (''cookies'') u vašem web pregledniku za ovu funkciju.",
	'captchahelp-text'           => 'Web poslužitelje koji rade na temelju javnih doprinosa, poput wiki, često zloupotrebljavaju spameri.
Oni koriste automatske alate pomoću kojih generiraju poveznice od vlastitog interesa.

Iako se te poveznice najčešće uklanjaju, mogu predstavljati neugodnost pri radu.
Ponekad se dogodi da wiki prikaže sliku čudnog tekstualnog sadržaja uz koju morate unijeti prikazana slova.
Budući da je takvu radnju teško automatizirati, većina se napadača obeshrabri, a pravi suradnici bez većih smetnji nastavljaju pridonositi.

Ukoliko ste suradnik koji koristi tekstualni klijent te vas česte ovakve provjere ometaju pri dodavanju važećih sadržaja, molimo da se obratite administratorima.',
	'captcha-addurl-whitelist'   => ' #<!-- leave this line exactly as it is --> <pre>
# Rabi se slijedeća sintaksa:
#   * Sve od "#" znaka do kraja linije je komentar
#   * Svaki neprazni redak je regularni izraz (regex) koji odgovara poslužitelju unutar URL-a
  #</pre> <!-- leave this line exactly as it is -->',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'captcha-edit'               => 'Zo by stronu wobdźěłał, rozrisaj prošu slědowacy ličenski nadawk a zapodaj wuslědk do kašćika ([[Special:Captcha/help|Dalše informacije]]):',
	'captcha-desc'               => 'Jednora implementacija captcha',
	'captcha-addurl'             => 'W twojej změnje su nowe eksterne wotkazy. Jako škitna naprawa přećiwo spamej dyrbiš slědowacy nadawk wuličeć a wuslědk do kašćika zapisować. Klikń potom znowa na „Składować”.<br />
[[Special:Captcha/help|(Čehodla?)]]',
	'captcha-badlogin'           => 'Zo by so awtomatiskemu zadobywanju do hesłow zadźěwało, dyrbiš slědowacy nadawk wuličeć a wuslědk do kašćika zapisować. [[Special:Captcha/help|(Prašenja abo problemy?)]]',
	'captcha-createaccount'      => 'Jako škitna naprawa přećiwo awtomatiskemu wutworjenju wužiwarskich kontow dyrbiš slědowacy nadawk wuličeć. [[Special:Captcha/help|(Prašenja abo problemy?)]]',
	'captcha-createaccount-fail' => 'Wopačny abo pobrachowacy wuslědk.',
	'captcha-create'             => 'Zo by stronu wutworił, rozrisaj prošu slědowacy ličenski nadawk a zapodaj wuslědk do kašćika ([[Special:Captcha/help|Dalše informacije]]):',
	'captchahelp-title'          => 'Pomoc z captcha',
	'captchahelp-cookies-needed' => 'Dyrbiš placki (cookies) w swojim wobhladowaku zmóžnić.',
	'captchahelp-text'           => 'Sydła kaž {{SITENAME}}, kotrež móža so swobodnje wot kóždeho wobdźěłować su často z woporom spamarjow, kotřiž swoje wotkazy awtomatisce we wjele sydłach broja. Tute spam-wotkazy móža so zaso wotstronjeć, wubudźa pak njesnadne mjerzanje. W někotrych padach, wosebje při přidawanju nowych eksternych wotkazow, móže so stać, zo pokazuje tutón wiki wobraz z pisanym abo skomolenym tekstom abo kaza jednory ličenski nadawk wuličeć, kotrehož wuslědk dyrbi so potom do zapodawanskeho kašćika zapisować. Dokelž hodźi so tajki nadawk jenož ćežko z awtomatiskimi srědkami spamarjow spjelnić, móža so tajcy wotdźeržować, druzy wužiwarjo pak móža swoje změny składować. Bohužel móže to k wobćežnosćam za tutych wužiwarjow dowjesć, kotrychž kmanosć widźenja je wobmjezowana abo kotřiž dźěłaja z wobhladowakami kiž su na tekstowe abo rěčne wudawanje wusměrjene. Móžne rozrisanje tutoho problema je přizjewjenje jako wužiwar. Tłóčatko „Wróćo” swojeho wobhladowaka dowjedźe tebje zaso do wobdźěłowanskeho pola.',
	'captcha-addurl-whitelist'   => ' #<!-- leave this line exactly as it is --> <pre>
# Syntaks je slědowaca:
# * Wšo wot znamješka "#" hač do kónca linky je komentar
# * Kóžda popisana linka je fragment regex (regularneho wuraza) kotryž so z mjenom hosta wěsteje URL přirunuje

 #</pre> <!-- leave this line exactly as it is -->',
);

/** Haitian (Kreyòl ayisyen)
 * @author Masterches
 */
$messages['ht'] = array(
	'captcha-edit'          => 'Pou ou kapab modifye paj sa, nou mande w kalkile ti adisyon fasil sa epitou mete rezilta, repons ou an nan bwat ki bò kote l ([[Special:Captcha/help|konnen plis sou fonksyon sa]]):',
	'captcha-desc'          => 'Yon enplemantasyon captcha senp',
	'captcha-addurl'        => 'Edisyon ou an genyen lyen pou sòti nan sistèm an.
Pou ede nou pwoteje sistèm an kont spam, imèl/mesaj otomatik, souple, kalkile ti pwoblèm adisyon fasil sa epi bay repons ou an nan bwat sa ([[Special:Captcha/help|plis èd sou fonksyon sa]]):',
	'captcha-badlogin'      => 'Pou ede nou lite kont moun ki ap krake, pirate mopas yo, souple rezoud ti adisyon fasil sa epi mete repons ou an nan bwat li ([[Special:Captcha/help|konnen plis sou fonksyon sa]]):',
	'captcha-createaccount' => 'Pou ede nou lite kont kreyasyon kont otomatik yo, souple rezoud ti adisyon sa epi mete nan bwat an repons ou an ([[Special:Captcha/help|konnen plis sou fonksyon sa]]):',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Siebrand
 */
$messages['hu'] = array(
	'captcha-edit'               => 'A lap szerkesztéséhez meg kell, hogy kérjünk, írd be a lenti dobozba az alábbi egyszerű összeadás eredményét ([[Special:Captcha/help|segítség]]):',
	'captcha-desc'               => 'Egyszerű captcha implementáció',
	'captcha-addurl'             => 'Szerkesztésed új külső linket tartalmaz. A reklámokat elhelyező robotok kiszűrése érdekében meg kell, hogy kérjünk, írd be a lenti dobozba az alábbi matematikai művelet eredményét. ([[Special:Captcha/help|segítség]])',
	'captcha-badlogin'           => 'Az automatikus jelszófeltörés kiszűrése érdekében meg kell, hogy kérjünk, írd be a lenti dobozba az alábbi egyszerű számtani művelet eredményét ([[Special:Captcha/help|segítség]]):',
	'captcha-createaccount'      => 'A felhasználói fiókok automatizált létrehozásának kiszűrése érdekében meg kell, hogy kérjünk, írd be a lenti dobozba az alábbi egyszerű számtani művelet eredményét. ([[Special:Captcha/help|segítség]])',
	'captcha-createaccount-fail' => 'Hibás vagy hiányzó ellenőrző kód.',
	'captcha-create'             => 'Az oldal elkészítéséhez meg kell, hogy kérjünk, írd be a lenti dobozba az alábbi egyszerű számtani művelet eredményét. ([[Special:Captcha/help|segítség]])',
	'captchahelp-title'          => 'Captcha segítség',
	'captchahelp-cookies-needed' => 'Engedélyezned kell a böngésződben a sütiket.',
	'captchahelp-text'           => 'Az olyan weboldalakat, amelyekre bárki írhat, gyakran támadják meg spammerek olyan eszközök felhasználásával, amelyek képesek automatikusan, emberi felügyelet nélkül elhelyezni egy linket sok különböző oldalon. Az ilyen linkek kézi eltávolítása rengeteg energiát emésztene fel, ezért néha, különösen ha egy külső linket teszel egy cikkbe, a wiki egy valamilyen módon eltorzított szöveget (captcha-t) jelenít meg, és arra kér, hogy gépeld be azt. Mivel ezt automatikusan nagyon nehéz megtenni, a valódi szerkesztők így könnyen megkülönböztethetőek a spammerek robotjaitól.

Sajnos ez komoly kényelmetlenséget jelenthet azoknak a felhasználóknak, akik gyengén látnak, vagy szöveges vagy hang-alapú böngészőt használnak. Jelenleg nem tudunk hang-alapú alternatívával szolgálni; ha a captcha megakadályoz abban, hogy szerkeszd a wikit, vedd fel a kapcsolatot az adminisztrátorokkal. Ahhoz, hogy a capctha-t meg tudd oldani, engedélyezned kell a sütiket a böngésződben.

Ha a captcha megoldása helyett inkább visszatérnél a szöveg szerkesztéséhez, használd a böngésződ „vissza” gombját.',
	'captcha-addurl-whitelist'   => ' #<!-- ezt a sort hagyd pontosan így --> <pre>
# A szintaktika a következő:
#  * Minden „#” karakterrel kezdődő sor megjegyzés
#  * Minden nem üres sor egy reguláris kifejezés darabja, amely csak az URL-ekben található kiszolgálókra keres
  #</pre> <!-- ezt a sort hagyd pontosan így -->',
	'right-skipcaptcha'          => 'captcha átugrása',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'captcha-edit'               => 'Pro modificar iste pagina, per favor resolve le simple calculo infra e entra le responsa in le quadro ([[Special:Captcha/help|plus info]]):',
	'captcha-desc'               => 'Implementation de captcha simple',
	'captcha-addurl'             => 'Tu modification include nove ligamines externe.
Como protection contra le spam automatic, per favor resolve le simple calculo infra e entra le resultato in le quadro [[Special:Captcha/help|plus info]]):',
	'captcha-badlogin'           => 'Como protection contra le piratage automatic de contrasignos, per favor resolve le simple calculo infra e entra le resultato in le quadro ([[Special:Captcha/help|plus info]]):',
	'captcha-createaccount'      => 'Como protection contra le creation automatic de contos, per favor resolve le simple calculo infra e entra le resultato in le quadro ([[Special:Captcha/help|plus info]]):',
	'captcha-createaccount-fail' => 'Codice de confirmation incorrecte o mancante.',
	'captcha-create'             => 'Pro crear le pagina, per favor resolve le simple calculo infra e entra le resultato in le quadro ([[Special:Captcha/help|plus info]]):',
	'captchahelp-title'          => 'Adjuta super le captcha',
	'captchahelp-cookies-needed' => 'Tu debe haber le cookies activate in tu navigator a fin que isto pote functionar.',
	'captchahelp-text'           => "Le sitos web que accepta contributiones del publico, como iste wiki, es sovente abusate per spammatores que usa instrumentos automatic pro publicar lor ligamines in multe sitos.
Ben que iste ligamines spam pote esser eliminate, illos constitue un considerabile incommoditate.

Alcun vices, specialmente quando tu adde nove ligamines web a un pagina, le wiki pote monstrar te un imagine de texto colorate o distorquite e demandar que tu entra le parolas monstrate.
Viste que isto es un carga difficile a automatisar, isto permittera al major parte del humanos real de facer lor contributiones, ben que le major parte del spammatores e altere attaccatores robotic es stoppate.

Infelicemente isto pote incommodar le usatores con vision limitate o usante navigatores a base de texto o synthese vocal.
Al momento nos non dispone de un alternativa audio.
Per favor contacta le administratores del sito pro assistentia si isto te impedi de facer contributiones legitime.

Clicca le button 'retro' in tu navigator pro retornar al pagina de modification.",
	'captcha-addurl-whitelist'   => '  #<!-- non modificar in alcun modo iste linea --> <pre>
# Le syntaxe es lo sequente:
#  * Toto a partir de un character "#" usque al fin del linea es un commento
#  * Omne linea non vacue es un fragmento regex applicabile solmente a nomines de host intra adresses URL
  #</pre> <!-- non modificar in alcun modo iste linea -->',
	'right-skipcaptcha'          => 'Executar le actiones que activarea le captcha sin deber passar per le captcha',
);

/** Indonesian (Bahasa Indonesia)
 * @author Borgx
 * @author Rex
 * @author IvanLanin
 */
$messages['id'] = array(
	'captcha-edit'               => 'Untuk menyunting halaman ini, harap pecahkan penjumlahan sederhana di bawah ini dan masukkan jawaban di kotak yang tersedia ([[Special:Captcha/help|info lengkap]]):',
	'captcha-desc'               => 'Implementasi sederhana captcha',
	'captcha-addurl'             => "Suntingan Anda menyertakan pralana luar baru. Sebagai perlindungan terhadap ''spam'' otomatis, Anda harus mengetikkan kata atau hasil perhitungan yang tertera berikut ini:<br />
([[Special:Captcha/help|info lengkap]])",
	'captcha-badlogin'           => 'Untuk membantu perlindungan terhadap perengkahan kunci sandi otomatis, tolong masukkan kata atau hasil perhitungan sederhana berikut dalam kotak yang tersedia ([[Special:Captcha/help|info lengkap]]):',
	'captcha-createaccount'      => 'Sebagai perlindungan melawan spam, Anda diharuskan untuk mengetikkan kata atau hasil perhitungan di bawah ini di kotak yang tersedia untuk dapat mendaftarkan pengguna baru:<br />
([[Special:Captcha/help|info lengkap]])',
	'captcha-createaccount-fail' => 'Kode konfirmasi salah atau belum diisi.',
	'captcha-create'             => 'Untuk menyunting halaman ini, silakan pecahkan penjumlahan sederhana di bawah ini dan masukkan jawaban di kotak yang tersedia ([[Special:Captcha/help|info lengkap]]):',
	'captchahelp-title'          => 'Mengenai Captcha',
	'captchahelp-cookies-needed' => 'Anda perlu mengaktifkan cookie pada penjelajah web Anda untuk menggunakan fitur ini.',
	'captchahelp-text'           => "Situs-situs web yang menerima masukan data dari publik, seperti {{ns:project}} ini, kerapkali disalahgunakan oleh pengguna-pengguna yang tidak bertanggungjawab untuk mengirimkan spam dengan menggunakan program-program otomatis. Walaupun pranala-pranala spam tersebut dapat dibuang, tetapi tetap saja menimbulkan gangguan berarti.

Ketika menambahkan pranala web baru ke suatu halaman, kadang-kadang {{ns:project}} akan menampilkan sebuah bentuk gambar dari tulisan yang terdistorsi dan meminta Anda untuk mengetikkan kata yang dimaksud. Karena ini merupakan suatu pekerjaan yang sulit diotomatisasi, pembatasan ini akan dapat dengan mudah dilakukan oleh manusia, sambil di sisi lain dapat menghentikan hampir semua serangan spam dan robot otomatis.

Sayangnya, hal ini dapat menimbulkan kesulitan bagi pengguna dengan keterbatasan penglihatan atau pengguna yang menggunakan penjelajah web berbasis teks atau suara.
Saat ini, kami belum memiliki suatu alternatif suara untuk hal ini.
Silakan minta bantuan dari pengurus situs jika hal ini menghambat Anda untuk mengirimkan suntingan yang layak.

Tekan tombol 'back' di penjelajah web Anda untuk kembali ke halaman penyuntingan.",
	'captcha-addurl-whitelist'   => '  #<!-- biarkan baris ini sebagaimana adanya --> <pre>
# Sintaksisnya adalah sebagai berikut:
#   * Semua yang diawali dengan karakter "#" hingga akhir baris adalah komentar
#   * Semua baris yang tidak kosong adalah fragmen regex yang hanya akan dicocokkan dengan nama host di dalam URL
  #</pre> <!-- biarkan baris ini sebagaimana adanya -->',
	'right-skipcaptcha'          => 'Melakukan tindakan pemicu captcha tanpa melalui Captcha',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'captcha-edit'               => 'Til að breyta þessari síðu, gjörðu svo vel og finndu summuna að neðan og skrifaðu svarið í
kassann ([[Special:Captcha/help|frekari upplýsinngar]]):',
	'captcha-addurl'             => 'Breyting þín felur í sér viðbætta ytri tengla. Til að hjálpa okkur að verjast sjálfvirku
auglýsingarusli gjörðu svo vel og finndu summuna að neðan og skrifaðu svarið í kassann ([[Special:Captcha/help|frekari upplýsinngar]]):',
	'captcha-badlogin'           => 'Til að hjálpa okkur að verjast sjálfvirku leyniorðaárásum, gjörðu svo vel og finndu summuna að neðan og skrifaðu svarið í
kassann ([[Special:Captcha/help|frekari upplýsinngar]]):',
	'captcha-createaccount'      => 'Til að hjálpa okkur að verjast sjálfvirkri gerð aðganga gjörðu svo vel og finndu summuna að neðan og skrifaðu svarið í kassann ([[Special:Captcha/help|frekari upplýsinngar]]):',
	'captcha-createaccount-fail' => 'Staðfestingarkóðinn var rangur eða ekki til staðar.',
	'captcha-create'             => 'Til að búa síðuna til, gjörðu svo vel og finndu summuna að neðan og skrifaðu svarið í kassann ([[Special:Captcha/help|frekari upplýsinngar]]):',
	'captchahelp-title'          => 'Captcha-hjálp',
	'captchahelp-cookies-needed' => 'Þú verður að leyfa vefkökur til þess að þetta virki.',
	'captchahelp-text'           => 'Vefsíður sem að leyfa framlög frá frá almenningi, líkt og þessi wiki-vefur, eru oft misnotaðar af svokölluðum „spömmurum“ sem nota sjálfvirk tól til þess að setja inn tengla á aðrar vefsíður. Aðrir notendur geta fjarlægt þessa tengla en töluverð truflun er af þeim.

Stundum þegar þú breytir síðum, sérstaklega ef breytingin felur í sér nýja tengla á aðra vefi, getur gerst að þú sért beðin(n) um að skrifa inn orð sem birtast á lituðum eða óskýrum myndum. Fyrir flesta notendur af holdi og blóði er þetta lítið mál en sjálfvirk tól ráða ekki við þetta.

Því miður kann þetta að valda notendum óþægindum sem hafa skerta sjón eða notast við talmálsvafra. Enn sem komið er eru ekki til aðrir valkostir fyrir þau tilvik. Ef þetta kemur í veg fyrir lögmætar breytingar af þinni hálfu getur þú leitað aðstoðar hjá stjórnendum vefsins.

Notaðu „back“-hnapp vafrans til að halda áfram.',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Darth Kule
 * @author Siebrand
 */
$messages['it'] = array(
	'captcha-edit'               => 'Per modificare la pagina è necessario risolvere il semplice calcolo presentato di seguito e inserire il risultato nella casella
([[Special:Captcha/help|maggiori informazioni]]):',
	'captcha-desc'               => 'Semplice implementazione di un Captcha',
	'captcha-addurl'             => "La modifica richiesta aggiunge dei nuovi collegamenti esterni alla pagina; come misura precauzionale contro l'inserimento automatico di spam, è necessario risolvere il semplice calcolo presentato di seguito e inserire il risultato nella casella ([[Special:Captcha/help|maggiori informazioni]]):",
	'captcha-badlogin'           => 'Come misura precauzionale contro i tentativi di forzatura automatica della password, è necessario risolvere il semplice calcolo presentato di seguito e inserire il risultato nella casella ([[Special:Captcha/help|maggiori informazioni]]):',
	'captcha-createaccount'      => 'Come misura precauzionale contro i tentativi di creazione automatica degli account, per registrarsi è necessario risolvere il semplice calcolo presentato di seguito e inserire il risultato nella casella ([[Special:Captcha/help|maggiori informazioni]]):',
	'captcha-createaccount-fail' => 'Codice di verifica errato o mancante.',
	'captcha-create'             => 'Per creare la pagina è necessario risolvere il semplice calcolo presentato di seguito e inserire il risultato nella casella:<br />
([[Special:Captcha/help|maggiori informazioni]]):',
	'captchahelp-title'          => "Cos'è il captcha?",
	'captchahelp-cookies-needed' => 'È necessario abilitare i cookie sul proprio browser per proseguire',
	'captchahelp-text'           => "Capita spesso che i siti Web che accettano messaggi pubblici, come questo wiki, siano presi di mira da spammer che usano strumenti automatici per inserire collegamenti pubblicitari verso un gran numero di siti. Per quanto i collegamenti indesiderati si possano rimuovere, si tratta comunque di una seccatura non indifferente.

In alcuni casi, ad esempio quando si tenta di aggiungere nuovi collegamenti Web in una pagina, il software wiki può mostrare una immagine con un breve testo colorato e/o distorto chiedendo di riscriverlo in un'apposita finestrella. Poiché si tratta di un'azione difficile da replicare da parte di un computer, questo meccanismo consente a (quasi tutti) gli utenti reali di completare l'inserimento desiderato, impedendo l'accesso alla maggior parte degli spammer e degli altri attacchi automatizzati.

Sfortunatamente, queste misure di sicurezza possono mettere in difficoltà gli utenti con problemi visivi o coloro che utilizzano browser testuali o basati sulla sintesi vocale. Purtroppo al momento non è disponibile un meccanismo alternativo basato su messaggi audio; se queste procedure impediscono l'inserimento informazioni che si ritengono legittime, si prega di contattare gli amministratori del sito e chiedere loro assistenza.

Fare clic sul pulsante 'back' del browser per tornare alla pagina di modifica.",
	'captcha-addurl-whitelist'   => ' #<!-- non modificare in alcun modo questa riga --> <pre>
# La sintassi è la seguente:
#  * Tutto ciò che segue un carattere "#" è un commento, fino al termine della riga
#  * Tutte le righe non vuote sono frammenti di espressioni regolari che si applicano al solo nome dell\'host nelle URL
  #</pre> <!-- non modificare in alcun modo questa riga -->',
	'right-skipcaptcha'          => 'Compie le azioni che attiverebbero il captcha senza dover passare per il captcha',
);

/** Japanese (日本語)
 * @author JtFuruhata
 */
$messages['ja'] = array(
	'captcha-edit'               => 'このページを編集するには下記に現れる数式の答えを入力してください。<br />
([[Special:Captcha/help|詳細]])',
	'captcha-desc'               => '簡単な CAPTCHA（画像認証）の実装',
	'captcha-addurl'             => 'あなたの編集には新たに外部リンクが追加されています。スパム防止のため、下記の数式の答えを入力してください<br />
([[Special:Captcha/help|詳細]])',
	'captcha-badlogin'           => '自動化スクリプトによるパスワードクラック攻撃を防止するため、下記に現れる数式の答えを入力してください<br />
([[Special:Captcha/help|詳細]])',
	'captcha-createaccount'      => 'スパム防止のため、アカウントを登録するには、下記に現れる数式の答えを入力してください<br />
([[Special:Captcha/help|詳細]])',
	'captcha-createaccount-fail' => '確認コードの入力がないか、間違っています。',
	'captcha-create'             => 'あなたの編集は新たに外部リンクが追加されています。スパム防止のため、下記に現れる数式の答えを入力してください<br />
([[Special:Captcha/help|詳細]])',
	'captchahelp-title'          => 'CAPTCHA（画像認証） ヘルプ',
	'captchahelp-cookies-needed' => 'ブラウザのクッキー機能を有効にする必要があります。',
	'captchahelp-text'           => '当Wikiのような、投稿が公開されているウェブサイトは、多くのサイトに自分たちへのリンクを自動投稿するツールを用いるスパマーにより荒らされます。これらのスパムは除去できるものの、その作業大変うっとうしいものです。

時々、特に新しいリンクをページに追加したとき、Wikiは色の付いた、もしくは、ゆがめられた文字を提示し、その入力をお願いすることがあります。この作業は自動化が難しいため、本当の人間の投稿を可能にしつつ、多くのスパマーやロボットの攻撃を防ぐことが出来ます。

しかし、残念なことに、テキストベースやスピーチベースのブラウザを使っている、視覚障害者に不便をおかけする場合があります。現時点では、音声版の代替物がありません。正当な投稿をするにあたって、これが障害となっている場合、サイト管理者に連絡し、協力を求めてください。

編集ページに戻るには、ブラウザの戻るボタンを押してください。',
	'captcha-addurl-whitelist'   => ' #<!-- この行は変更しないでください --> <pre>
# 構文は以下のとおりです:
#  * "#"文字から行末まではコメントとして扱われます
#  * 空白を含んでいない行は、URLに含まれるホスト名との一致を検出する正規表現です
  #</pre> <!-- この行は変更しないでください -->',
);

/** Jutish (Jysk)
 * @author Huslåke
 * @author Ælsån
 */
$messages['jut'] = array(
	'captcha-edit'               => 'For at redigere denne side, skal du give svaret på regnestyket nedenfor, og angive resultatet i feltet under det. ([[Special:Captcha/help|mere information]]):',
	'captcha-desc'               => 'Semple captcha implementåsje',
	'captcha-addurl'             => 'Din redigering tilføjer nye eksterne henvisninger til artiklen. Som beskyttelse mod automatiseret spam, skal du give svaret på regnestyket nedenfor, og angive resultatet i feltet under det. ([[Special:Captcha/help|mere information]]):',
	'captcha-badlogin'           => 'For at beskytte mod automatiserede gæt på kodeord, skal du give svaret på regnestyket nedenfor, og angive resultatet i feltet under det. ([[Special:Captcha/help|mere information]]):',
	'captcha-createaccount'      => 'For at beskytte mod automatisk oprettelse af brugernavne, skal du give svaret på regnestyket nedenfor, og angive resultatet i feltet under det. ([[Special:Captcha/help|mere information]]):',
	'captcha-createaccount-fail' => 'Forkert eller manglende kodeord.',
	'captcha-create'             => 'For at oprette en ny side, skal du give svaret på regnestyket nedenfor, og angive resultatet i feltet under det. ([[Special:Captcha/help|mere information]]):',
	'captchahelp-title'          => 'Captcha-hjælp',
	'captchahelp-cookies-needed' => 'Din browser skal understøtte cookies, før dette kan gennemføres.',
	'captchahelp-text'           => "Websites der accepterer indhold fra offentligheden, bliver ofte udsat for angreb fra spammere. Disse angreb sker med automatiske værktøjer, der anbringer de samme links på et stort antal websites på kort tid. Selvom disse links kan fjernes, er de en vedligeholdelsesmæssig byrde.

I visse tilfælde, specielt når der tilføjes nye links til denne wiki, vil softwaren vise dig et billede af et stykke forvredet og sløret tekst. Du skal indtaste det ord, der vises, før du kan gennemføre handlingen. Formålet er at skelne mellem mennesker og automatiserede værktøjer, da de sidste har meget svært ved at genkende ordene.

Desværre kan dette medføre problemer for svagtseende brugere, og brugere der bruger software der oplæser indholdet af siden. For øjeblikket findes der ikke et lydbaseret alternativ. Kontakt venligst en administrator med henblik på at få hjælp, hvis dette forhindrer tilføjelsen af godartet materiale.

Tryk på 'tilbage'-knappen i din browser for at returnere til redigeringssiden.",
	'captcha-addurl-whitelist'   => '  #<!-- Undlad at rette denne linie --> <pre>
# Vejledning:
#  * Alt fra et "#"-tegn til slutningen af en linie er en kommentar
#  * Alle ikke-blanke linier benyttes som regulært udtryk, der anvendes på hostnavne i URLer
  #</pre> <!-- Undlad at rette denne linie -->',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'captcha-edit'               => 'Kanggo nyunting kaca iki, mangga pecahna tambah-tambahan ing ngisor iki lan lebokna wangsulané ing kothak cedaké ([[Special:Captcha/help|info sabanjuré]]):',
	'captcha-desc'               => 'Implementasi prasaja captcha',
	'captcha-addurl'             => "Suntingan panjenengan iku nyertakaké pranala jaba anyar.
Kanggo ngéwangi ngreksa lawan ''spam'' otomatis, tulung pecahna itung-itungan ing ngisor iki lan lebokna kasilna sajroning kothak ([[Special:Captcha/help|info sabanjuré]]):",
	'captcha-badlogin'           => 'Kanggo ngreksa lawan parengkahan kunci sandhi otomatis, tulung lebokna tembung utawa kasil itung-itungan gampang ing ngisor sajroning kothak sing wis sumedya ([[Special:Captcha/help|info sabanjuré]]):',
	'captcha-createaccount'      => 'Kanggo ngreksa lawan panggawéyan rékening (akun) otomatis, tulung pecahna itung-itungan ing ngisor iki lan lebokna kasilna sajroning kothak ([[Special:Captcha/help|info sabanjuré]]):',
	'captcha-createaccount-fail' => 'Kode pandhedhesan (konfirmasi) salah utawa durung diisi.',
	'captcha-create'             => 'Kanggo nggawé kaca iki, mangga itung-itungan ing ngisor iki diwangsuli sajroning kothak ([[Special:Captcha/help|info sabanjuré]]):',
	'captchahelp-title'          => 'Pitulung Captcha',
	'captchahelp-cookies-needed' => 'Panjenengan perlu ngaktifaké cookie ing panjlajah wèb panjenengan kanggo nganggo fitur iki.',
	'captchahelp-text'           => "Situs-situs wèb sing nampa masukan data saka umum, kaya ta wiki iki, kerep disalahgunakaké déning panganggo-panganggo sing ora bertanggungjawab kanggo ngirimaké ''spam'' mawa program-program otomatis. Senadyan spam-spam iku bisa dibuang kabèh, nanging waé tetep ngrusuhi lan dianggep gawé masalah.

Kadhangkala, utamané yèn mènèhi pranala wèb anyar ing sawijinig kaca, wiki iki bisa nuduhaké gambar sawijining gambar tulisan sing ana wernané utawa sing rusak lan njaluk panjenengan ngetik ulang tembung sing ana gambar iki.
Amerga pagawéyan iki angèl diotomatisasi, pawatesan iki bisa ngidinaké mèh kabèh wong asli mbanjuraké sumbangsihé ngirim suntingan nanging menggak para pangirim spam lan robot otomatis.

Émané, perkara iki bisa nggawé sawetara panganggo kangélan nyunting kaca iki, utamané sing daya pandelengané kurang utawa para panganggo sing nganggo panjlajah tèks adhedhasar tèks utawa swara. Saiki iki awaké dhéwé ora duwé alternatif audio kanggo iki. Mangga nyuwun pitulung karo para pangurus yèn perkara iki menggak panjenengan ngirimaké suntingan sing layak.

Pencèten tombol 'back' ing panjlajah wèb panjenengan kanggo bali menyang kaca panyuntingan.",
	'captcha-addurl-whitelist'   => '  #<!-- leave this line exactly as it is --> <pre>
# Sintaksisé kaya mengkéné:
#  * Kabèh sing diawali mawa karakter "#" nganti pungkasané baris iku komentar
#  * Kabèh garis sing ora kosong iku fragmèn regex sing namung cocog karo jeneng host sajroning URL
  #</pre> <!-- leave this line exactly as it is -->',
	'right-skipcaptcha'          => 'Nglakokaké aksi-aksi sing murupaké captcha tanpa kudu ngliwati captcha',
);

/** Kara-Kalpak (Qaraqalpaqsha)
 * @author Atabek
 */
$messages['kaa'] = array(
	'captcha-createaccount-fail' => "Tastıyıqlawshı kodın'ız nadurıs yamasa jazılmag'an",
);

/** Kazakh (Arabic script) (‫قازاقشا (تٴوتە)‬) */
$messages['kk-arab'] = array(
	'captcha-edit'               => 'بۇل بەتتٸ ٶڭدەۋ ٷشٸن, تٶمەندەگٸ قوسىندىلاۋدى شەشٸڭٸز دە, نٵتيجەسٸن
اۋماققا ەنگٸزٸڭٸز ([[{{ns:special}}:Captcha/help|كٶبٸرەك اقپارات]]):',
	'captcha-addurl'             => 'تٷزەتۋٸڭٸزدە جاڭا سىرتقى سٸلتەمەلەر بار ەكەن. ٶزدٸكتٸك «سپام» جاسالۋىنان قورعانۋ ٷشٸن,
تٶمەندەگٸ قاراپايىم قوسىندىلاۋدى شەشٸڭٸز دە, نٵتيجەسٸن اۋماققا ەنگٸزٸڭٸز ([[{{ns:special}}:Captcha/help|كٶبٸرەك اقپارات]]):',
	'captcha-badlogin'           => 'قۇپييا سٶزدٸ ٶزدٸكتٸك قيراتۋدان قورعانۋ ٷشٸن,
تٶمەندەگٸ قاراپايىم قوسىندىلاۋدى شەشٸڭٸز دە, نٵتيجەسٸن اۋماققا ەنگٸزٸڭٸز ([[{{ns:special}}:Captcha/help|كٶبٸرەك اقپارات]]):',
	'captcha-createaccount'      => 'جاڭا تٸركەلگٸ ٶزدٸكتٸك جاسالۋىنان قورعانۋ ٷشٸن, تٶمەندەگٸ قاراپايىم قوسىندىلاۋدى
شەشٸڭٸز دە, نٵتيجەسٸن اۋماققا ەنگٸزٸڭٸز ([[{{ns:special}}:Captcha/help|كٶبٸرەك اقپارات]]):',
	'captcha-createaccount-fail' => 'كۋٵلاندىرۋ كودى دۇرىس ەمەس نەمەسە جوق.',
	'captcha-create'             => 'جاڭا بەتتٸ باستاۋ ٷشٸن, تٶمەندەگٸ قاراپايىم قوسىندىلاۋدى شەشٸڭٸز دە,
نٵتيجەسٸن اۋماققا ەنگٸزٸڭٸز ([[{{ns:special}}:Captcha/help|كٶبٸرەك اقپارات]]):',
	'captchahelp-title'          => 'CAPTCHA انىقتاماسى',
	'captchahelp-cookies-needed' => 'بۇل جۇمىس ٸستەۋ ٷشٸن, شولعىشىڭىزدا  «cookies»  دەگەندٸ ەندٸرٸڭٸز.',
	'captchahelp-text'           => 'ٶزدٸكتٸك قۇرالدارى بار «سپاممەرلەر», بارشادان جٸبەرٸلگەن حاباردى قابىلدايتىن, بۇل ۋيكي سيياقتى, ۆەب-توراپتارعا سٸلتەمەلەرٸمەن جيٸ جاۋدىرادى. وسىنداي «سپام» سٸلتەمەلەرٸن الاستاۋ بولعاندا دا, بۇل مٵندٸ ىزا كەلتٸرەدٸ.

كەيدە, ٵسٸرەسە بەتكە جاڭا ۆەب سٸلتەمەسٸن قوسقاندا, ۋيكي ٶڭٸ ٶزگەرگەن نە قيسايعان مٵتٸندٸ كٶرسەتٸپ جٵنە سول سٶزدەردٸ ەنگٸزۋ سۇراۋى مٷمكٸن. بۇل تاپسىرىس ٶزدٸك تٷردە اتقارۋ ٶتە قيىن, سوندىقتان بۇل يماندى ادام كٶپشٸلٸگٸنە كەدەرگٸ بولمايدى, بٸراق «سپاممەرلەردٸ» جٵنە بۇزاقى بوتپەن باسقا شابۋىل جاساعانداردى توقتاتادى.

ٶكٸنٸشكە وراي, بۇل كٶرۋٸ تٶمەندەگەن, نەمەسە مٵتٸن نە داۋىس نەگٸزٸندەگٸ شولعىشتى قولداناتىن پايدالانۋشىعا ىڭعايسىزدىق كەلتٸرۋگە مٷمكٸن. وسى قازٸر بٸزدە دىبىستى بالاما جوق. ەگەر بۇل ادال جازۋىڭىزعا كەدەرگٸلەسە, توراپ باقىلاۋشىلارىنا قاتىناسىڭىز.

بۇل جۇمىستى ٸستەۋ ٷشٸن شولعىشىڭىزدا «cookies» دەگەندٸ ەندٸرۋ قاجەت.

بەت ٶڭدەۋٸنە قايتۋ بارۋ ٷشٸن «ارتقا» دەگەن تٷيمەسٸن باسىڭىز.',
);

/** Kazakh (Cyrillic) (Қазақша (Cyrillic)) */
$messages['kk-cyrl'] = array(
	'captcha-edit'               => 'Бұл бетті өңдеу үшін, төмендегі қосындылауды шешіңіз де, нәтижесін
аумаққа енгізіңіз ([[{{ns:special}}:Captcha/help|көбірек ақпарат]]):',
	'captcha-addurl'             => 'Түзетуіңізде жаңа сыртқы сілтемелер бар екен. Өздіктік «спам» жасалуынан қорғану үшін,
төмендегі қарапайым қосындылауды шешіңіз де, нәтижесін аумаққа енгізіңіз ([[{{ns:special}}:Captcha/help|көбірек ақпарат]]):',
	'captcha-badlogin'           => 'Құпия сөзді өздіктік қиратудан қорғану үшін,
төмендегі қарапайым қосындылауды шешіңіз де, нәтижесін аумаққа енгізіңіз ([[{{ns:special}}:Captcha/help|көбірек ақпарат]]):',
	'captcha-createaccount'      => 'Жаңа тіркелгі өздіктік жасалуынан қорғану үшін, төмендегі қарапайым қосындылауды
шешіңіз де, нәтижесін аумаққа енгізіңіз ([[{{ns:special}}:Captcha/help|көбірек ақпарат]]):',
	'captcha-createaccount-fail' => 'Куәландыру коды дұрыс емес немесе жоқ.',
	'captcha-create'             => 'Жаңа бетті бастау үшін, төмендегі қарапайым қосындылауды шешіңіз де,
нәтижесін аумаққа енгізіңіз ([[{{ns:special}}:Captcha/help|көбірек ақпарат]]):',
	'captchahelp-title'          => 'CAPTCHA анықтамасы',
	'captchahelp-cookies-needed' => 'Бұл жұмыс істеу үшін, шолғышыңызда  «cookies»  дегенді ендіріңіз.',
	'captchahelp-text'           => 'Өздіктік құралдары бар «спаммерлер», баршадан жіберілген хабарды қабылдайтын, бұл уики сияқты, веб-тораптарға сілтемелерімен жиі жаудырады. Осындай «спам» сілтемелерін аластау болғанда да, бұл мәнді ыза келтіреді.

Кейде, әсіресе бетке жаңа веб сілтемесін қосқанда, уики өңі өзгерген не қисайған мәтінді көрсетіп және сол сөздерді енгізу сұрауы мүмкін. Бұл тапсырыс өздік түрде атқару өте қиын, сондықтан бұл иманды адам көпшілігіне кедергі болмайды, бірақ «спаммерлерді» және бұзақы ботпен басқа шабуыл жасағандарды тоқтатады.

Өкінішке орай, бұл көруі төмендеген, немесе мәтін не дауыс негізіндегі шолғышты қолданатын пайдаланушыға ыңғайсыздық келтіруге мүмкін. Осы қазір бізде дыбысты балама жоқ. Егер бұл адал жазуыңызға кедергілесе, торап бақылаушыларына қатынасыңыз.

Бұл жұмысты істеу үшін шолғышыңызда «cookies» дегенді ендіру қажет.

Бет өңдеуіне қайту бару үшін «Артқа» деген түймесін басыңыз.',
);

/** Kazakh (Latin) (Қазақша (Latin)) */
$messages['kk-latn'] = array(
	'captcha-edit'               => 'Bul betti öñdew üşin, tömendegi qosındılawdı şeşiñiz de, nätïjesin
awmaqqa engiziñiz ([[{{ns:special}}:Captcha/help|köbirek aqparat]]):',
	'captcha-addurl'             => 'Tüzetwiñizde jaña sırtqı siltemeler bar eken. Özdiktik «spam» jasalwınan qorğanw üşin,
tömendegi qarapaýım qosındılawdı şeşiñiz de, nätïjesin awmaqqa engiziñiz ([[{{ns:special}}:Captcha/help|köbirek aqparat]]):',
	'captcha-badlogin'           => 'Qupïya sözdi özdiktik qïratwdan qorğanw üşin,
tömendegi qarapaýım qosındılawdı şeşiñiz de, nätïjesin awmaqqa engiziñiz ([[{{ns:special}}:Captcha/help|köbirek aqparat]]):',
	'captcha-createaccount'      => 'Jaña tirkelgi özdiktik jasalwınan qorğanw üşin, tömendegi qarapaýım qosındılawdı
şeşiñiz de, nätïjesin awmaqqa engiziñiz ([[{{ns:special}}:Captcha/help|köbirek aqparat]]):',
	'captcha-createaccount-fail' => 'Kwälandırw kodı durıs emes nemese joq.',
	'captcha-create'             => 'Jaña betti bastaw üşin, tömendegi qarapaýım qosındılawdı şeşiñiz de,
nätïjesin awmaqqa engiziñiz ([[{{ns:special}}:Captcha/help|köbirek aqparat]]):',
	'captchahelp-title'          => 'CAPTCHA anıqtaması',
	'captchahelp-cookies-needed' => 'Bul jumıs istew üşin, şolğışıñızda  «cookies»  degendi endiriñiz.',
	'captchahelp-text'           => 'Özdiktik quraldarı bar «spammerler», barşadan jiberilgen xabardı qabıldaýtın, bul wïkï sïyaqtı, veb-toraptarğa siltemelerimen jïi jawdıradı. Osındaý «spam» siltemelerin alastaw bolğanda da, bul mändi ıza keltiredi.

Keýde, äsirese betke jaña veb siltemesin qosqanda, wïkï öñi özgergen ne qïsaýğan mätindi körsetip jäne sol sözderdi engizw surawı mümkin. Bul tapsırıs özdik türde atqarw öte qïın, sondıqtan bul ïmandı adam köpşiligine kedergi bolmaýdı, biraq «spammerlerdi» jäne buzaqı botpen basqa şabwıl jasağandardı toqtatadı.

Ökinişke oraý, bul körwi tömendegen, nemese mätin ne dawıs negizindegi şolğıştı qoldanatın paýdalanwşığa ıñğaýsızdıq keltirwge mümkin. Osı qazir bizde dıbıstı balama joq. Eger bul adal jazwıñızğa kedergilese, torap baqılawşılarına qatınasıñız.

Bul jumıstı istew üşin şolğışıñızda «cookies» degendi endirw qajet.

Bet öñdewine qaýtw barw üşin «Artqa» degen tüýmesin basıñız.',
);

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'captcha-edit'               => 'ដើម្បីកែប្រែ​ទំព័រនេះ សូមដោះស្រាយ​ប្រមាណវិធីបូក​ខាងក្រោម​នេះរួច​បញ្ជូលចំលើយ​ទៅក្នុង​ប្រអប់សិន([[Special:Captcha/help|ពត៌មាន​បន្ថែម]])៖',
	'captcha-addurl'             => 'កំនែ​របស់អ្នក​មាន​តំនភ្ជាប់ក្រៅ​ថ្មី។ ដើម្បី​ជួយបង្ការ​ស្ប៉ាម​ស្វ័យប្រវត្តិ សូមដោះស្រាយ​ប្រមាណវិធីបូក​ខាងក្រោម​នេះរួច​បញ្ជូលចំលើយ​ទៅក្នុង​ប្រអប់សិន([[Special:Captcha/help|ពត៌មាន​បន្ថែម]])៖',
	'captcha-badlogin'           => 'ដើម្បីការពារការបំបែកពាក្យសំងាត់ដោយស្វ័យប្រវត្តិ សូមដោះស្រាយផលបូកខាងក្រោមរួចបញ្ជូលចំលើយទៅក្នុងប្រអប់ ([[Special:Captcha/help|ពត៌មានបន្ថែម]])៖',
	'captcha-createaccount'      => 'ដើម្បី​បង្ការការបង្កើត​គណនី​ស្វ័យប្រវត្តិ សូមដោះស្រាយ​ប្រមាណវិធីបូក​ខាងក្រោម​នេះរួច​បញ្ជូលចំលើយ​ទៅក្នុង​ប្រអប់សិន([[Special:Captcha/help|ពត៌មាន​បន្ថែម]])៖',
	'captcha-createaccount-fail' => 'អក្សរកូដផ្ទៀងផ្ទាត់ បាត់បង់ ឬ មិនត្រឹមត្រូវ',
	'captcha-create'             => 'ដើម្បី​បង្កើត​ទំព័រ សូមដោះស្រាយ​ប្រមាណវិធីបូក​ខាងក្រោម​នេះរួច​បញ្ជូលចំលើយ​ទៅក្នុង​ប្រអប់សិន([[Special:Captcha/help|ពត៌មាន​បន្ថែម]])៖',
	'captchahelp-title'          => 'ជំនួយអំពី Captcha',
);

/** Korean (한국어)
 * @author Klutzy
 * @author Siebrand
 * @author ToePeu
 */
$messages['ko'] = array(
	'captcha-edit'               => '글을 편집하기 위해서는, 아래의 간단한 덧셈 값을 입력상자에 적어 주세요([[Special:Captcha/help|자세한 정보]]):',
	'captcha-addurl'             => '편집 내용에 다른 웹 사이트 링크가 포함되어 있습니다. 자동 스팸을 막기 위해, 아래의 간단한 계산 값을 입력상자에 적어 주세요([[Special:Captcha/help|자세한 정보]]):',
	'captcha-badlogin'           => '계정 암호 해킹을 막기 위해, 아래의 간단한 계산 값을 입력상자에 적어 주세요([[Special:Captcha/help|자세한 정보]]):',
	'captcha-createaccount'      => '자동 가입을 막기 위해, 아래 문제의 답을 적어야만 가입이 가능합니다([[Special:Captcha/help|관련 도움말]]):',
	'captcha-createaccount-fail' => '입력값이 잘못되었거나 없습니다.',
	'captcha-create'             => '문서를 만들기 위해서는, 아래의 간단한 계산 값을 입력상자에 적어 주세요([[Special:Captcha/help|자세한 정보]]):',
	'captchahelp-title'          => 'Captcha 도움말',
	'captchahelp-cookies-needed' => '정상적으로 작동하려면 웹 브라우저의 쿠키 사용이 활성화되어있어야 합니다.',
	'captchahelp-text'           => "이곳의 위키와 같이 사용자들의 공개적인 참여가 가능한 웹 사이트에서는, 자동 프로그램이 스팸을 뿌리는 경우가 있습니다. 물론 이러한 스팸은 제거할 수는 있지만 귀찮은 작업이 늘어납니다.

이러한 스팸을 방지하기 위해서, 이곳 위키의 문서에 웹 사이트 주소를 추가하거나 하는 등의 행동을 할 경우에는, 비틀린 글자가 들어있는 그림을 보여주고 그 그림의 글자를 입력해 달라고 하는 경우가 있습니다. 이 글자 입력 작업은 자동 프로그램을 만들기가 힘들기 때문에, 스팸을 효과적으로 막으면서 일반 사용자를 막지 않을 수 있습니다.

웹 브라우저에서 그림을 완벽하게 표시할 수 없거나, 또는 그림이 나오지 않는 텍스트 방식이나 음성 합성 방식 웹 브라우저를 사용하는 경우에는 이러한 입력이 불가능합니다. 아직까지는 이런 경우에 대한 대안책이 없습니다. 이 경우 사이트 관리자에게 도움을 요청해주세요.

이전의 편집창으로 돌아가려면 웹 브라우저의 '뒤로' 버튼을 눌러 주세요.",
	'captcha-addurl-whitelist'   => ' #<!-- leave this line exactly as it is --> <pre>
# 문법은 다음과 같습니다:
#  * "#"로 시작하는 줄은 주석입니다.
#  * 빈 줄이 아닌 줄은 정규식으로, URL의 호스트만을 검사합니다.
  #</pre> <!-- leave this line exactly as it is -->',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'captcha-desc'      => 'En eijfach „Kaptscha“.',
	'right-skipcaptcha' => 'de Opforderung fum Captcha överjonn',
);

/** Latin (Latina)
 * @author UV
 */
$messages['la'] = array(
	'captcha-edit'               => 'Ad hanc paginam recensendum, necesse est tibi solvere calculationem subter et responsum in capsam inscribere ([[Special:Captcha/help|Quidst illud?]]):',
	'captcha-addurl'             => 'Emendatione tua insunt nexus externi; ut spam automaticum vitemus, necesse est tibi solvere calculationem subter et responsum in capsam inscribere ([[Special:Captcha/help|Quidst illud?]]):',
	'captcha-badlogin'           => 'Ut vitemus ne tesserae frangantur, necesse est tibi solvere calculationem subter et responsum in capsam inscribere ([[Special:Captcha/help|Quidst illud?]]):',
	'captcha-createaccount'      => 'Ut creationem rationum automaticam vitemus, necesse est tibi solvere calculationem subter et responsum in capsam inscribere ([[Special:Captcha/help|Quidst illud?]]):',
	'captcha-createaccount-fail' => 'Codex affirmationis aut non scriptus est aut male.',
	'captcha-create'             => 'Ad paginam creandum, necesse est tibi solvere calculationem subter et responsum in capsam inscribere ([[Special:Captcha/help|Quidst illud?]]):',
	'captchahelp-title'          => 'Captcha auxilium',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'captcha-edit'               => "Fir dës Säit z'änneren, léist w.e.g. dës Rechenaufgab a gitt d'Resultat an d'Këscht ënnendrënner an ([[Special:Captcha/help|méi Informatiounen]]):",
	'captcha-desc'               => 'Einfach Captcha-Implementatioun',
	'captcha-addurl'             => 'An ärer Ännerung sinn nei extern Linken. Fir eis virun automatiséiertem Spamming ze schütze froe mir iech fir déi folgend einfach  Rechenaufgab ze léisen an d\'Resultat an d\'Feld ënnen anzedroën. Klickt duerno w.e.g. nach eng Kéier op "Säit ofspäicheren" [[Special:Captcha/help|méi Informatiounen]].',
	'captcha-badlogin'           => "Fir eis géint automatescht Hacke vu Passwierder ze schützen, léist w.e.g. déi einfach Additioun hei ënnendrënner an tippt d'Äntwert an d'Këscht ([[Special:Captcha/help|méi Informatiounen]]):",
	'captcha-createaccount'      => "Fir eis géint d'autamescht Uleeë vu Benotzerkonten ze schützen, léist w.e.g. déi einfach Additioun hei ënnendrënner an tippt d'Äntwert an d'Këscht ([[Special:Captcha/help|méi Informatiounen]]):",
	'captcha-createaccount-fail' => 'Falschen oder keen Konfirmatiouns-Code.',
	'captcha-create'             => "Fir eng Nei Säit unzleeën, léist w.e.g. déi einfach Additioun hei ënnendrënner an tippt d'Äntwert an d'Këscht ([[Special:Captcha/help|méi Informatiounen]]):",
	'captchahelp-title'          => 'Captcha-Hëllef',
	'captchahelp-cookies-needed' => 'Dir musst Cookieën an ärem Browser erlaben fir dat dëst fonktionéiert.',
	'captchahelp-text'           => "Websiten, déi jidferengem et erlaben Ännerunge virzehuelen, sou wéi op dëser wiki, ginn dacks vu sougenannte Spammer mëssbraucht, déi automatiséiert hir Linkën op vill Internetsitë setzen. Esou Spam-Linkë kënne wuel geläscht ginn, mee si sinn trotzdem e grousst Iergernëss.

Heiandsdo, besonnesch wann nei Internet-Linkën op eng Säit derbäigesat ginn, weist dës Wiki iech e Bild mat farwegëm oder verzerrtëm Text a freet iech fir déi gewise Wierder anzetipppen. Well dëst eng Aufgab ass déi schwéier ze automatiséieren ass, erlaabt dëst dat Mënschen hir Ännerunge kënnen agi wärend déi meescht Spammer an aner Roboter-Attacken kënnen ofgewiert ginn.

Leider kann dëst zu Schwierigkeete féiere fir Persounen déi net esou gutt gesinn oder déi text-baséiert oder sprooch-baséiert Browser benotzen. Zu dësem Zäitpunkt hu mir leider keng audio-Alternativ zu eiser Verfügung. Eng Léisung ass d'Umeldung als Benotzer oder kontaktéiert een Administrateur fir Hëllef wann dëst iech onerwarter Wäis vu legitimen Editen ofhält.

Dréckt op den 'Zréck' Knäppchen vun ärem Browser fir an d'Beaarbectungsfënster zréckzekommen.",
	'captcha-addurl-whitelist'   => '   #<!-- Dës Linn onverännert loossen --> <pre>
#  Syntax:
#  * Alles mat engem #-Zeechen u bis zum Enn vun däer Zeil ass eng Bemierkung
#  * All Zeil déi net eidel ass, ass ee Regex-Fragment, dat nëmme mat Hosten bannent URLë fonktionéiert
   #</pre> <!-- Dës Linn onverännert loossen -->',
	'right-skipcaptcha'          => 'Aktiounen déi eng Captcha-Aktioun verlaangen ausféieren, ouni dës maachen ze mussen',
);

/** Limburgish (Limburgs)
 * @author Matthias
 * @author Ooswesthoesbes
 * @author Siebrand
 */
$messages['li'] = array(
	'captcha-edit'               => "Geer wil dees pazjena bewerke. Veur estebleef 't antjwaord op de óngerstäönde einvawdife som in 't inveurvenster in ([[Special:Captcha/help|mieë informatie]]):",
	'captcha-desc'               => 'Einvawdige implementatie van captcha',
	'captcha-addurl'             => "Uw bewerking bevat nieuwe externe links (URL's). Voer ter bescherming tegen geautomatiseerde spam alstublieft het antwoord op de onderstaande eenvoudige som in in het invoerveld ([[Special:Captcha/help|meer informatie]]):",
	'captcha-badlogin'           => 'Los alstublieft de onderstaande eenvoudige som op en voer het antwoord in het invoervenster in ter bescherming tegen het automatisch kraken van wachtwoorden ([[Special:Captcha/help|meer informatie]]):',
	'captcha-createaccount'      => 'Voer ter bescherming tegen geautomatiseerde spam het antwoord op de onderstaande eenvoudige som in het invoervenster in ([[Special:Captcha/help|meer informatie]]):',
	'captcha-createaccount-fail' => 'De bevestigingscode ontbreekt of is onjuist.',
	'captcha-create'             => 'U wilt een nieuwe pagina aanmaken. Voer alstublieft het antwoord op de onderstaande eenvoudige som in het invoervenster in ([[Special:Captcha/help|meer informatie]]):',
	'captchahelp-title'          => 'Captcha-hölp',
	'captchahelp-cookies-needed' => 'Ge dient in uw browser cookies ingeschakeld te hebbe om dit te laote werke.',
	'captchahelp-text'           => "Websites die vrij te bewerken zijn, zoals deze wiki, worden vaak misbruikt door spammers die er met hun programma's automatisch links op zetten naar vele websites. Hoewel deze externe links weer verwijderd kunnen worden, leveren ze wel veel hinder en administratief werk op.

Soms, en in het bijzonder bij het toevoegen van externe links op pagina's, toont de wiki u een afbeelding met gekleurde of vervormde tekst en wordt u gevraagd de getoonde tekst in te voeren. Omdat dit proces lastig te automatiseren is, zijn vrijwel alleen mensen in staat dit proces succesvol te doorlopen en worden hiermee spammers en andere geautomatiseerde aanvallen geweerd.

Helaas levert deze bevestiging voor gebruikers met een visuele handicap of een tekst- of spraakgebaseerde browser problemen op. Op het moment is er geen alternatief met geluid beschikbaar. Vraag alstublieft assistentie van de sitebeheerders als dit proces u verhindert een nuttige bijdrage te leveren.

Klik op de knop 'terug' in uw browser om terug te gaan naar het tekstbewerkingsscherm.",
	'captcha-addurl-whitelist'   => ' #<!-- laot deze regel --> <pre>
# De syntaxis is as volgt:
#  * Alle tekst vanaaf \'t karakter "#" tot het einde van de regels wordt gezien als opmerking
#  * Iedere niet-lege regel is een fragment van een reguliere uitdrukking die alleen van toepassing is op hosts binnen URL\'s
  #</pre> <!-- laot deze regel -->',
	'right-skipcaptcha'          => 'Captchahandelinge oetveure zonder captcha te hove oplosse',
);

/** Lao (ລາວ) */
$messages['lo'] = array(
	'captcha-edit'               => 'ການດັດແກ້ ຂອງ ທ່ານ ມີລິ້ງູຄ໌ພາຍນອກ. ເພື່ອ ເປັນການຊ່ອຍປ້ອງກັນ ສະແປມອັດຕະໂນມັດ, ກະລຸນາແກ້ເລກບວກ ງ່າຍໆຂ້າງລຸ່ມນີ້ ແລ້ວ ພິມຄຳຕອບໃສ່ໃນ ກັບ ([[Special:Captcha/help|more info]]):',
	'captcha-addurl'             => 'ການດັດແກ້ຂອງທ່ານ ມີ ການກາງລິ້ງຄ໌ຫາພາຍນອກ. ເພື່ອເປັນການຊ່ອຍປ້ອງກັນ ສະແປມອັດຕະໂນມັດ ກະລຸນາ ແກ້ເລກບວກງ່າຍໆຂ້າງລຸ່ມນີ້ ແລ້ວ ພິມຜົນບວກ ໃສ່ ກັບ ([[Special:Captcha/help|ຂໍ້ມູນເພີ່ມເຕີມ]]):',
	'captcha-createaccount'      => 'ເພື່ອປ້ອງກັນ ການສ້າງບັນຊີແບບອັດຕະໂນມັດ, ກະລຸນາ ແກ້ເລກບວກງ່າຍໆ ຂ້າງລຸ່ມ ແລ້ວ ພິມຄຳຕອບໃສ່ ກັບ ([[Special:Captcha/help|more info]]):',
	'captcha-createaccount-fail' => 'ບໍ່ຖືກ ຫຼື ບໍ່ມີລະຫັດຢືນຢັນ.',
	'captcha-create'             => 'ກະລຸນາ ແກ້ເລກບວກງ່າຍໆລຸ່ມນີ້ ແລະ ພິມຜົນບວກໃສ່ໃນກັບ ເພື່ອ ສ້າງໜ້ານີ້ ([[Special:Captcha/help|ຂໍ້ມູນເພີ່ມເຕີມ]]):',
);

/** Lithuanian (Lietuvių)
 * @author Matasg
 * @author Garas
 */
$messages['lt'] = array(
	'captcha-edit'               => 'Kad redaguotumėte šį straipsnį, prašome apskaičiuokite šią paprastą sumą ir įveskite atsakymą į laukelį ([[Special:Captcha/help|daugiau informacijos]]):',
	'captcha-createaccount-fail' => 'Blogas arba nerastas patvirtinimo kodas.',
);

/** Latvian (Latviešu)
 * @author BrokenArrow
 * @author Yyy
 */
$messages['lv'] = array(
	'captcha-edit'               => 'Lai izmainītu šo lapu, atrisini šo vienādojumu un iegūto skaitli ieraksti šajā lodziņā: <br />([[Special:Captcha/help|Kāpēc tā?]])',
	'captcha-addurl'             => 'Tavas izmaiņas ietver jaunu URL saiti. Lai pasargātos no automātiskas mēstuļošanas, Tev ir jāieraksta vārds, kas redzams šajā attēlā: <br />([[Special:Captcha/help|Kāpēc tā?]])',
	'captcha-createaccount'      => 'Lai pasargātos no automātiskas mēstuļošanas, Tev reģistrējoties ir jāieraksta vārds, kas redzams šajā attēlā: <br />([[Special:Captcha/help|Kāpēc tā?]])',
	'captcha-createaccount-fail' => 'Nepareizs apstiprinājuma kods vai arī tas nav ievadīts.',
	'captcha-create'             => 'Lai izveidotu šo lapu, atrisini šo vienādojumu un rezulātu ieraksti šajā lodziņā: <br />([[Special:Captcha/help|Kāpēc tā?]])',
	'captchahelp-text'           => "Interneta lapas, kurās iespējams pievienot tekstu, kā šajā wiki, bieži cieš no mēstuļotājiem, kuri izmanto automatizētus līdzekļus, lai pievienotu savus saites daudzās jo daudzās interneta lapās. Kaut arī šīs saites var viegli dzēst, tomēr tās ir nozīmīgs traucēklis. Reizēm, jo īpaši pievienojot jaunas interneta saites, wiki programmatūra var parādīt Tev attēlu, kurā ir krāsains vai sagrozīts teksts. Šis teksts ir jāpārraksta un to ir ļoti grūti izdarīt automātiski, tā apgrūtinot lielāko daļu mēstuļotāju, savukārt gandrīz visi parastie lietotāji to var izdarīt bez grūtībām. Diemžēl tas var apgrūtināt lietotājus, kuriem ir redzes traucējumi vai kuri izmanto teksta pārlūkus vai dzirdes pārlūkus. Šobrīd nav pieejama audio alternatīva, bet sazinies ar wiki administratoriem, ja tas liedz Tev veikt labi domātus papildinājumus. Spied pārlūka pogu \"Atpakaļ\" (''Back''), lai atgrieztos iepriekšējā lapā.",
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'captcha-edit'               => 'ഈ താള്‍ തിരുത്തുവാന്‍, ദയവായി താഴെ കൊടുത്തിരിക്കുന്ന ലഘു ഗണിത ക്രിയ ചെയ്ത് അതിന്റെ ഉത്തരം താഴെയുള്ള പെട്ടിയില്‍ ടൈപ്പു ചെയ്യുക ([[Special:Captcha/help|കൂടുതല്‍ വിവരങ്ങള്‍]]):',
	'captcha-desc'               => 'ലളിതമായ CAPTCHA നടപ്പിലാക്കല്‍',
	'captcha-addurl'             => 'താങ്കളുടെ തിരുത്തലലില്‍ പുറം കണ്ണികള്‍ ഉള്‍പ്പെട്ടിരിക്കുന്നു.
യാന്ത്രിക സ്പാമിനെതിരെയുള്ള സം‌രക്ഷണത്തിന്റെ ഭാഗമായി, ദയവായി താഴെ കൊടുത്തിരിക്കുന്ന ലഘു ഗണിത ക്രിയ ചെയ്ത് അതിന്റെ ഉത്തരം താഴെയുള്ള പെട്ടിയില്‍ ടൈപ്പു ചെയ്യുക ([[Special:Captcha/help|കൂടുതല്‍ വിവരങ്ങള്‍]]):',
	'captcha-badlogin'           => 'യാന്ത്രിക രഹസ്യവാക്ക് പൊളിക്കലിനെതിരായുള്ള സം‌രക്ഷണത്തിന്റെ ഭാഗമായി, ദയവായി താഴെ കൊടുത്തിരിക്കുന്ന ലഘു ഗണിത ക്രിയ ചെയ്ത് അതിന്റെ ഉത്തരം താഴെയുള്ള പെട്ടിയില്‍ ടൈപ്പു ചെയ്യുക ([[Special:Captcha/help|കൂടുതല്‍ വിവരങ്ങള്‍]]):',
	'captcha-createaccount'      => 'യാന്ത്രിക അക്കൗണ്ട് സൃഷ്ടിക്കലിനെതിരെയുള്ള സം‌രക്ഷണത്തിന്റെ ഭാഗമായി, ദയവായി താഴെ കൊടുത്തിരിക്കുന്ന ലഘു ഗണിത ക്രിയ ചെയ്ത് അതിന്റെ ഉത്തരം താഴെയുള്ള പെട്ടിയില്‍ ടൈപ്പു ചെയ്യുക ([[Special:Captcha/help|കൂടുതല്‍ വിവരങ്ങള്‍]]):',
	'captcha-createaccount-fail' => 'അസാധുവായതോ കാണ്‍‌മാനില്ലാത്തതോ ആയ സ്ഥിരീകരണ കോഡ്.',
	'captcha-create'             => 'ഈ താള്‍ സൃഷ്ടിക്കുവാന്‍, ദയവായി താഴെ കൊടുത്തിരിക്കുന്ന കൂട്ടല്‍ ക്രിയയുടെ ഉത്തരം താഴെയുള്ള പെട്ടിയില്‍ എഴുതുക  ([[Special:Captcha/help|കൂടുതല്‍ വിവരങ്ങള്‍ക്ക്]]):',
	'captchahelp-title'          => 'CAPTCHA സഹായം',
	'captchahelp-cookies-needed' => 'ഇതു പ്രവര്‍ത്തിക്കണമെങ്കില്‍ താങ്കളുടെ ബ്രൗസറില്‍ കുക്കികള്‍ സജ്ജീകരിച്ചിരിക്കണം.',
	'captcha-addurl-whitelist'   => ' #<!-- leave this line exactly as it is --> <pre>
# സിന്റാക്സ് താഴെ കാണുന്ന പ്രകാരമാണ്‌:
#  * "#" എന്ന അക്ഷരത്തില്‍ തുടങ്ങുന്ന എല്ലാ വരികളും കുറിപ്പുകളായിരിക്കും
#  * Every non-blank line is a regex fragment which will only match hosts inside URLs
  #</pre> <!-- leave this line exactly as it is -->',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'captcha-edit'               => 'हे पान संपादित करण्यासाठी, खाली दिलेले सोपे गणित सोडवून त्याचे उत्तर दिलेल्या पृष्ठपेटी मध्ये लिहा ([[Special:Captcha/help|अधिक माहिती]]):',
	'captcha-desc'               => 'सोप्या कॅप्टचाचा वापर',
	'captcha-addurl'             => 'तुमच्या संपादनात नवीन बाह्यदुवे आहेत. आपोआप होणार्‍या स्पॅम पासून वाचण्यासाठी, खाली दिलेले सोपे गणित सोडवून त्याचे उत्तर दिलेल्या पृष्ठपेटी मध्ये लिहा ([[Special:Captcha/help|अधिक माहिती]]):',
	'captcha-badlogin'           => 'आपोआप होणार्‍या परवलीच्या शब्दाच्या चोरीपासून वाचण्यासाठी, खाली दिलेले सोपे गणित सोडवून त्याचे उत्तर दिलेल्या पृष्ठपेटी मध्ये लिहा ([[Special:Captcha/help|अधिक माहिती]]):',
	'captcha-createaccount'      => 'आपोआप होणार्‍या सदस्य नोंदणीपासून वाचण्यासाठी, खाली दिलेले सोपे गणित सोडवून त्याचे उत्तर दिलेल्या पृष्ठपेटी मध्ये लिहा ([[Special:Captcha/help|अधिक माहिती]]):',
	'captcha-createaccount-fail' => 'चुकीचा अथवा रिकामा सहमती कोड',
	'captcha-create'             => 'हे पान तयार करण्यासाठी, खाली दिलेले सोपे गणित सोडवून त्याचे उत्तर दिलेल्या पृष्ठपेटी मध्ये लिहा ([[Special:Captcha/help|अधिक माहिती]]):',
	'captchahelp-title'          => 'कॅप्टचा साहाय्य',
	'captchahelp-cookies-needed' => 'हे काम करण्यासाठी तुम्ही कूकीज (cookies) एनेबल केलेल्या असणे गरजेचे आहे.',
	'captchahelp-text'           => "ज्या संकेतस्थळांवर जसे की हा विकि, सर्वसामान्य लोकांकडून संपादने करण्याची परवानगी असते, तिथे आपोआप होणारी स्वत:च्या संकेतस्थळांचे दुवे देणारी संपादने (Spam) कायम होत असतात.
अशी संपादने जरी काढता आली तरी ती एक डोकेदुखी होऊ शकते.

काहीवेळा, जेव्हा एखाद्या पानावर नवीन बाह्यदुवा देताना, विकि तुम्हाला एक चित्र दाखवून त्यांतील शब्द भरण्यास सांगू शकतो.
हे काम संगणकाकरवी करून घेण्यास अवघड असल्याने, फक्त खरी माणसेच संपादने करू शकतील व स्पॅमर्सना आळा बसू शकेल.

पण खेदाची गोष्ट अशी की ह्यामुळे अर्धांध व्यक्ती तसेच ज्या व्यक्ती फक्त मजकूर दाखविणारा न्याहाळक वापरतात, अशांना असुविधा होऊ शकते.
सध्या आमच्याकडे आवाज ऐकण्याची सुविधा नाही. 
कृपया विकिवरील प्रबंधकांशी या बाबतीत संपर्क करावा.

पृष्ठ संपादनाकडे परत जाण्यासाठी आपल्या ब्राउझरची ’Back' ही कळ दाबा.",
	'captcha-addurl-whitelist'   => ' #<!-- leave this line exactly as it is --> <pre>
# रुपरेषा खालीलप्रमाणे:
#  * "#" ने सुरु होणारे व ओळीच्या शेवटपर्यंत जाणारे वाक्य सूचना (Comment) आहे.
#  * प्रत्येक रिकामी नसलेली ओळ ही regex fragment आहे जी फक्त URLमधील होस्टसच्या जोड्या लावेल
  #</pre> <!-- leave this line exactly as it is -->',
	'right-skipcaptcha'          => 'कॅपचा मध्ये न जाता कॅपचाचा वापर करणार्‍या क्रिया करा',
);

/** Malay (Bahasa Melayu)
 * @author Aviator
 */
$messages['ms'] = array(
	'captcha-edit'               => 'Untuk menyunting laman ini, sila selesaikan kira-kira di bawah dan masukkan jawapannya dalam kotak yang disediakan ([[Special:Captcha/help|maklumat lanjut]]):',
	'captcha-desc'               => 'Pelaksanaan CAPTCHA ringan',
	'captcha-addurl'             => 'Suntingan anda mengandungi pautan luar baru.
Untuk membanteras kegiatan spam automatik, anda diminta menyelesaikan kira-kira di bawah dan masukkan jawapannya dalam kotak yang disediakan ([[Special:Captcha/help|maklumat lanjut]]):',
	'captcha-badlogin'           => 'Untuk membanteras kegiatan meneka kata laluan secara automatik, anda diminta menyelesaikan kira-kira di bawah dan masukkan jawapannya dalam kotak yang disediakan ([[Special:Captcha/help|maklumat lanjut]]):',
	'captcha-createaccount'      => 'Untuk membanteras kegiatan pembukaan akaun secara automatik, anda diminta menyelesaikan kira-kira di bawah dan masukkan jawapannya dalam kotak yang disediakan ([[Special:Captcha/help|maklumat lanjut]]):',
	'captcha-createaccount-fail' => 'Kod pengesahan salah.',
	'captcha-create'             => 'Untuk mencipta laman tersebut, sila selesaikan kira-kira di bawah dan masukkan jawapannya dalam kotak yang disediakan ([[Special:Captcha/help|maklumat lanjut]]):',
	'captchahelp-title'          => 'Bantuan CAPTCHA',
	'captchahelp-cookies-needed' => "Sila aktifkan ''cookies'' pada pelayar web anda.",
	'captchahelp-text'           => "Tapak web yang menerima sumbangan daripada orang awam, seperti wiki ini, adalah mudah terdedah kepada serangan spam. Biasanya, si penyerang menggunakan atur cara komputer untuk mengirim pautan-pautan ke tapak web mereka secara automatik.

Apabila anda menambah pautan baru pada sesebuah laman, wiki ini akan memaparkan sebuah imej yang mengandungi teks yang berwarna atau samar-samar dan meminta supaya anda menaip perkataan yang ditunjukkan.
Oleh sebab tugas tersebut sukar dilakukan oleh komputer, manusia sebenar boleh mengirim seperti biasa, manakala atur cara komputer terhalang daripada melakukan serangan automatik.

Walau bagaimanapun, perkara ini boleh menyukarkan pengguna yang mengalami masalah penglihatan atau sedang menggunakan pelayar web teks atau tuturan. Pada masa ini kami tidak mempunyai alternatif dalam bentuk bunyi. Sila hubungi pentadbir tapak web untuk mendapatkan bantuan sekiranya perkara ini menghalang anda daripada membuat sumbangan yang sah.

Sila tekan butang 'back' untuk kembali ke borang sunting.",
	'captcha-addurl-whitelist'   => '  #<!-- jangan ubah baris ini --> <pre>
# Sintaks:
#  * Aksara "#" sampai akhir baris diabaikan
#  * Ungkapan nalar dibaca daripada setiap baris dan dipadankan dengan nama hos sahaja
  #</pre> <!-- jangan ubah baris ini -->',
	'right-skipcaptcha'          => 'Melepasi pemeriksaan CAPTCHA',
);

/** Min Nan Chinese (Bân-lâm-gú) */
$messages['nan'] = array(
	'captcha-createaccount'      => 'Ūi beh ī-hông lâng iōng ke-si chū-tōng chù-chheh koh tah kóng-kò, chhiáⁿ lí kā chhut-hiān tī ang-á lāi-bīn ê jī phah 1 piàn (thang chèng-bêng lí m̄ sī ki-khì-lâng): <br />
([[Special:Captcha/help|Che sī siáⁿ-hòe?]])',
	'captcha-createaccount-fail' => 'Khak-jīn-bé chhò-gō· iah-sī làu-kau.',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 * @author Siebrand
 */
$messages['nds'] = array(
	'captcha-edit'               => 'Disse Siet to ännern, musst du disse lütte Rekenopgaav lösen un dat Resultat in dat Feld ingeven ([[{{ns:Special}}:Captcha/help|mehr dorto]]):',
	'captcha-createaccount'      => 'Dat hier nich Brukers automaatsch anleggt warrt, musst du disse lütte Rekenopgaav lösen ([[Special:Captcha/help|mehr dorto]]):',
	'captcha-createaccount-fail' => 'Kood to’n Bestätigen is verkehrt oder fehlt.',
	'captchahelp-title'          => 'Help to Captchas',
	'captcha-addurl-whitelist'   => ' #<!-- leave this line exactly as it is --> <pre>
# Op disse Siet staht de Websteden, bi de en Bruker,
# de nich anmellt is un en ne’en Lenk in de Siet infögen deit,
# keen Captcha utfüllen mutt.
#
# Syntax is disse:
#  * Allens vun en „#“-Teken bet na’t Enn vun de Reeg is en Kommentar
#  * All de annern Regen, de nich leddig sünd, warrt as regulären Utdruck bekeken,
#    de för Delen vun de Domään steiht.

  #</pre> <!-- leave this line exactly as it is -->',
);

/** Dutch (Nederlands)
 * @author Siebrand
 * @author SPQRobin
 */
$messages['nl'] = array(
	'captcha-edit'               => 'U wilt deze pagina bewerken.
Voer alstublieft het antwoord op de onderstaande eenvoudige som in het invoervenster in ([[Special:Captcha/help|meer informatie]]):',
	'captcha-desc'               => 'Eenvoudige implementatie van captcha',
	'captcha-addurl'             => "Uw bewerking bevat nieuwe externe links (URL's).
Voer ter bescherming tegen geautomatiseerde spam alstublieft het antwoord op de onderstaande eenvoudige som in in het invoerveld ([[Special:Captcha/help|meer informatie]]):",
	'captcha-badlogin'           => 'Los alstublieft de onderstaande eenvoudige som op en voer het antwoord in het invoervenster in ter bescherming tegen het automatisch kraken van wachtwoorden ([[Special:Captcha/help|meer informatie]]):',
	'captcha-createaccount'      => 'Voer ter bescherming tegen geautomatiseerde spam het antwoord op de onderstaande eenvoudige som in het invoervenster in ([[Special:Captcha/help|meer informatie]]):',
	'captcha-createaccount-fail' => 'De bevestigingscode ontbreekt of is onjuist.',
	'captcha-create'             => 'U wilt een nieuwe pagina aanmaken. Voer alstublieft het antwoord op de onderstaande eenvoudige som in het invoervenster in ([[Special:Captcha/help|meer informatie]]):',
	'captchahelp-title'          => 'Captcha-hulp',
	'captchahelp-cookies-needed' => 'U dient in uw browser cookies ingeschakeld te hebben om dit te laten werken.',
	'captchahelp-text'           => "Websites die vrij te bewerken zijn, zoals deze wiki, worden vaak misbruikt door spammers die er met hun programma's automatisch links op zetten naar vele websites.
Hoewel deze externe links weer verwijderd kunnen worden, leveren ze wel veel hinder en administratief werk op.

Soms, en in het bijzonder bij het toevoegen van externe links op pagina's, ziet u een afbeelding met gekleurde of vervormde tekst en wordt u gevraagd de weergegeven tekst in te voeren.
Omdat dit proces lastig te automatiseren is, zijn vrijwel alleen mensen in staat dit proces succesvol te doorlopen en worden hiermee spammers en andere geautomatiseerde aanvallen geweerd.

Helaas levert deze bevestiging voor gebruikers met een visuele handicap of een tekst- of spraakgebaseerde browser problemen op.
Op het moment is er geen alternatief met geluid beschikbaar.
Vraag alstublieft assistentie van de sitebeheerders als dit proces u verhindert een nuttige bijdrage te leveren.

Klik op de knop 'terug' in uw browser om terug te gaan naar het tekstbewerkingsscherm.",
	'captcha-addurl-whitelist'   => ' #<!-- laat deze regel zoals hij is --> <pre> 
# De syntaxis is als volgt: 
#   * Alle tekst vanaf het karakter "#" tot het einde van de regels wordt gezien als opmerking
#   * Iedere niet-lege regel is een fragment van een reguliere uitdrukking die alleen van toepassing is op hosts binnen URL\'s
 #</pre> <!-- laat deze regel zoals hij is -->',
	'right-skipcaptcha'          => 'Captchahandelingen uitvoeren zonder captcha te hoeven oplossen',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Eirik
 */
$messages['nn'] = array(
	'captcha-edit'               => 'For å endre denne sida, ver venleg og løys det enkle reknestykket nedanfor og skriv svaret i ruta ([[Special:Captcha/help|Kva er dette?]]):',
	'captcha-desc'               => 'Enkel implementering av captcha-system.',
	'captcha-addurl'             => 'Endringa di inkluderer nye lenkjer; som eit vern mot automatisert reklame (spam) er du nøydd til skrive inn orda i dette bildet: <br />([[Special:Captcha/help|Kva er dette?]])',
	'captcha-badlogin'           => 'For å sikra oss mot automatisk passordtjuveri, ver venleg og skriv inn svaret på det enkle reknestykket i boksen nedanfor ([[Special:Captcha/help|meir informasjon]]):',
	'captcha-createaccount'      => 'For å verne Wikipedia mot reklame (spam) må du skrive inn orda i biletet for å registrere ein konto. <br />([[Special:Captcha/help|Kva er dette?]])',
	'captcha-createaccount-fail' => 'Feil eller manglande godkjenningskode.',
	'captcha-create'             => 'For å opprette denne sida, ver venleg og løys det enkle reknestykket nedanfor og skriv svaret i ruta ([[Special:Captcha/help|Kva er dette?]]):',
	'captchahelp-title'          => 'Captcha-hjelp',
	'captchahelp-cookies-needed' => 'Du må ha informasjonskapslar aktivert i nettlesaren din for at dette skal verke.',
	'captchahelp-text'           => 'Internettsider som kan verte endra av alle, som denne wikien, vert ofte misbrukte av reklameinnleggjarar (spammarar) som nyttar bottar til å poste mange lenkjer om gongen.
Sjølv om slike reklamelenkjer kan verte fjerna er dei til stor irritasjon.

Nokre gonger, særleg viss du vil leggje til nye internettlenker til ei side, kan wikien vise deg eit bilete av ein farga eller ujamn tekst og be deg skrive inn orda som vert viste.
Sidan det er vanskeleg å automatisere denne oppgåva, vil funksjonen sleppe dei fleste verkelege menneska gjennom, men stoppe reklamerobotar.

Diverre finst det i augeblikket ikkje noko lydalternativ for brukarar med nedsett syn som brukar tekst- eller talebaserte nettlesarar.
Ver venleg å kontakte administratorane viss denne funksjonen hindrar deg i å gjere skikkelege endringar.
Trykk på «attende»-knappen for å kome tilbake til endringssida.',
	'captcha-addurl-whitelist'   => ' #<!-- la denne lina vere akkurat som ho er --> <pre>
# Syntaksen er slik:
#  * Alt frå teiknet «#» til enden av lina er ein kommentar
#  * Alle liner som ikkje er tomme er fragment av regulære uttrykk som sjekkar vertar i URL-ar
  #</pre> <!-- la denne lina vere akkurat som ho er -->',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Siebrand
 */
$messages['no'] = array(
	'captcha-edit'               => 'Skriv inn summen nedenfor i boksen for å kunne redigere denne siden ([[Special:Captcha/help|mer informasjon]]):',
	'captcha-desc'               => 'Enkel captcha-implementering',
	'captcha-addurl'             => 'Din redigering inneholder nye eksterne lenker. Løs det enkle regnestykket i boksen nedenfor for å hjelpe oss å beskytte oss mot automatisk spam ([[Special:Captcha/help|mer informasjon]]):',
	'captcha-badlogin'           => 'Løs det enkle regnestykket i boksen nedenfor for å hjelpe oss å beskytte oss mot automatisk passordtyveri ([[Special:Captcha/help|mer informasjon]]):',
	'captcha-createaccount'      => 'Løs det enkle regnestykket i boksen nedenfor for å hjelpe oss å beskytte oss mot automatisk kontoopprettelse ([[Special:Captcha/help|mer informasjon]]):',
	'captcha-createaccount-fail' => 'Ukorrekt eller manglende bekreftelseskode.',
	'captcha-create'             => 'Løs det enkle regnestykket i boksen nedenfor for å opprette siden ([[Special:Captcha/help|mer informasjon]]):',
	'captchahelp-title'          => 'Hjelp med Captcha',
	'captchahelp-cookies-needed' => 'Du må slå på informasjonskapsler for at dette skal fungere.',
	'captchahelp-text'           => 'Internettsider som kan redigeres av alle, som denne wikien, blir ofte misbrukt av spammere som bruker roboter for å poste massive antall lenker. Selv om slike spamlenker kan fjernes er de til betydelig irritasjon.

Noen ganger, særlig hvis du vil legge til nye internettlenker til en side, kan wikien vise deg et bilde av en farvet eller ujevn tekst og be deg skrive inn ordene som vises. Siden det er vanskelig å automatisere denne oppgaven, vil funksjonen slippe de fleste virkelige mennesker igjennom, men stoppe spammere.

Dessverre finnes det i øyeblikket ikke noe audioalternativ for brukere med begrenset syn som som bruker tekst- eller talebaserte nettlesere. Vennlig kontakt administratorene hvis denne funksjonen forhindrer deg i å foreta legitime endringer.

Trykk på «tilbake»-knappen for å komme tilbake til redigeringssiden.',
	'captcha-addurl-whitelist'   => ' #<!-- leave this line exactly as it is --> <pre>
# Syntaksen er som følger:
#  * Alle linjer som begynner med «#» er kommentarer
#  * Alle linjer som ikke er blanke er fragmenter av regulære uttrykk som sjekker verter i URL-er
  #</pre> <!-- leave this line exactly as it is -->',
	'right-skipcaptcha'          => 'Utføre handlinger som normalt krever «captcha»-bekreftelse uten å bruke «captcha»',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'captcha-edit'               => "Per modificar aquesta pagina, vos cal efectuar lo calcul çaijós e n'inscriure lo resultat dins lo camp ([[Special:Captcha/help|Mai d’entresenhas]]) :",
	'captcha-desc'               => 'Implementacion captcha simpla',
	'captcha-addurl'             => "Vòstra modificacion inclutz de ligams URL novèla ; per empachar las connexions automatizadas, devètz picar los mots que s’afichan dins l’imatge que seguís : <br />([[Special:Captcha/help|Qu'es aquò?]])",
	'captcha-badlogin'           => "Per ensajar de contornar las temptativas de cracatge de senhals automatizadas per de robòts, recopiatz lo tèxt çaijós dins la bóstia de tèxt plaçada al dejós d'aqueste. ([[Special:Captcha/help|Mai d’entresenhas]])",
	'captcha-createaccount'      => 'Coma proteccion contra las creacions de compte abusivas, entratz lo resultat de l’addicion dins la bóstia çaijós:<br />
([[Special:Captcha/help|mai d’entresenhas]])',
	'captcha-createaccount-fail' => 'Còde de confirmacion mancant o erronèu.',
	'captcha-create'             => "Per modificar la pagina, vos cal de resòldre l'operacion çaijós e n'inscriure lo resultat dins lo camp ([[Special:Captcha/help|Mai d'infòs]]) :",
	'captchahelp-title'          => 'Ajuda suls Captcha',
	'captchahelp-cookies-needed' => "Vos cal aver los cookies activats dins vòstre navigador per qu'aquò foncione.",
	'captchahelp-text'           => "Los sits webs que permeton al mai grand nombre de participar, coma aqueste wiki, sovent son atacats per de spammers qu'utilizan d'espleches automatizas per mandar lor ligams sus fòrça sits a l'encòp.
Son fòrt aisits de suprimir mas avèm francament de causas mai risolièras de far.

De còps quand apondètz de ligams novèls vèrs lo web, lo wiki vos pòt mostrar un imatge amb un tèxt coloriat o torçut e vos demandar de lo picar. Es una tasca relativament complicada d'automatizar, çò que permet de diferenciar un uman real d'un logicial automatic malvolent.

Malurosament, aqueste sistèma es pas adaptat a d'utilizaires mal-vesents o utilizant de navigadors textuals o àudio. Actualament, prepausem pas d'alternativas adaptadas. Se avètz besonh d'ajuda esitetz pas a contactar los administrators del sit. 

Clicatz sul boton 'precedent' de vòstre navigador per tornar a l'editor.",
	'captcha-addurl-whitelist'   => '#<!-- daissatz aquesta linha exactament tala coma es --> <pre> # La sintaxi es la seguenta: # * Tot caractèr seguissent "#" fins a la fin de la linha serà interpretat coma un comentari # * Tota linha non voida es un còde regex que serà utilizat unicament a l\'interior dels ligams hypertext. #</pre> <!-- daissatz aquesta linha exactament tala coma es -->',
	'right-skipcaptcha'          => "Acomplís lo desenclavament de las accions de captcha sens dever passar per l'intermediari aqueste darrièr",
);

/** Pampanga (Kapampangan)
 * @author SPQRobin
 */
$messages['pam'] = array(
	'captcha-createaccount'      => 'Bang ala na kabud laltong account, pakipakibatan me ing papacuenta ra king lalam at ibili me ing pakibat ketang cahun ([[Special:Captcha/help|more info]]):',
	'captcha-createaccount-fail' => 'E ustu o ala yu ing confirmation code.',
	'captchahelp-text'           => "Maralas, mayayabusu la reng karinan king Aptas (websites) kareng spammer a gagamit automatic a paralan ba rong ipasquil kareng dakal a karinan deng karelang suglung.  Lipat ning malyari lang ilako deti, maragul la muring sakit buntuk.

Neng kayi, lalu na neng mangibiling karagdagang suglung king metung a bulung, mapalyaring magpalto yang larawan ning sulat a maki kule o anting medisporma ing wiki, at pakisabi nang i-type me itang makasulat. Uling e malagwang gawang automatic ing dapat a iti, paintulutan nong magpasquil deng keraklan kareng tau, kabang sasabatan no reng keraklan kareng spammer at lulub a robot.

Makalungkut mu pin at magkasakit la uli na niti deng gagamit a mapula mata o maki paglibut ( browser) a makabasi king sulat (text-based) o king siwala (speech-based). Ala keng alternatibu o kayaliling pakiramdaman king salukuyan. Nung malyari, pasaup ko sana ketang manibala king kekayung karinan (site administrator) nung magkasakit kayung magpasquil ulin na niti.

Mangaylangan kang manyalanging cookie king kekang paglibut (browser) para king obrang iti.

Timid me ing 'back' button king kekang browser bang mibalik ketang panaliling bulung (page editor).",
);

/** Polish (Polski)
 * @author Sp5uhe
 * @author Derbeth
 * @author Leinad
 */
$messages['pl'] = array(
	'captcha-edit'               => 'Możesz edytować tę stronę, jednak najpierw musisz rozwiązać poniższe proste działanie matematyczne i wpisać wynik do pola tekstowego ([[Special:Captcha/help|pomoc]]):',
	'captcha-desc'               => 'Proste zabezpieczenie przed automatami',
	'captcha-addurl'             => 'Dodałeś nowe linki zewnętrzne. Ze względu na ochronę przed zautomatyzowanym spamem musisz wykonać proste działanie matematyczne i wpisać wynik w pole obok ([[Special:Captcha/help|więcej informacji]]):',
	'captcha-badlogin'           => 'Zabezpieczenie przed automatycznym łamaniem haseł. Wpisz w pole poniżej wynik prostego działania matematycznego ([[Special:Captcha/help|pomoc]]).',
	'captcha-createaccount'      => 'Zabezpieczenie przed automatycznie dodawanym spamem. Wpisz w pole poniżej wynik prostego działania matematycznego ([[Special:Captcha/help|pomoc]]).',
	'captcha-createaccount-fail' => 'Nieprawidłowy kod lub brak kodu potwierdzającego.',
	'captcha-create'             => 'Aby utworzyć stronę wykonaj proste działanie i wpisz wynik w pole tekstowe ([[Special:Captcha/help|pomoc]]):',
	'captchahelp-title'          => 'Pomoc dla ochrony antyspamowej',
	'captchahelp-cookies-needed' => 'Musisz mieć włączone w przeglądarce ciasteczka (cookies), aby ta opcja działała.',
	'captchahelp-text'           => 'Strony internetowe akceptujące edycje dokonywane przez każdego, tak jak ta wiki, są często atakowane przez spamerów, którzy używają automatycznych narzędzi, aby dodawać linki prowadzące do ich stron.
Chociaż te linki mogą być usunięte, jest to uciążliwe.

Czasami, zwłaszcza przy dodawaniu nowych linków do strony albo przy rejestracji, wiki może pokazać obrazek z kolorowym lub zniekształconym tekstem i poprosić Cię o przepisanie zamieszczonego na nim wyrazu.
Może pojawić się też prośba o wpisanie wyniku prostego działania matematycznego.
Ponieważ są to zadania trudne do zautomatyzowania, takie zabezpieczenia nie uniemożliwia większości ludziom dokonywania edycji, jednocześnie skutecznie powstrzymując większość spamerów i inne automatyczne ataki.

Niestety, może być to niewygodne dla użytkowników z wadą wzroku lub używających przeglądarek tekstowych lub głosowych.
Obecnie nie mamy alternatywnego rozwiązania audio.
Skontaktuj się z administratorami strony by uzyskać pomoc, jeśli nie możesz z tego powodu dokonywać uprawnionych edycji.

Wciśnij przycisk „wstecz” w przeglądarce by powrócić do edycji strony.',
	'captcha-addurl-whitelist'   => '  #<!-- nie modyfikuj tej linii --> <pre>
# Składnia jest następująca:
#   * Linie zaczynające się od znaku „#” są komentarzami
#   * Każda linia, która nie jest pusta, jest wyrażeniem regularnym, które ma pasować do adresu serwera (fragmentu URL)
  #</pre> <!-- nie modyfikuj tej linii -->',
	'right-skipcaptcha'          => 'Dostęp do czynności zabezpieczonych pytaniem o treść obrazka lub rozwiązanie zadania, z pominięciem zabezpieczenia',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 * @author Siebrand
 */
$messages['pms'] = array(
	'captcha-edit'               => "Për fe-ie dle modìfiche ansima a st'artìcol-sì, për piasì ch'a fasa ël total ambelessì sota 
e ch'a buta l'arzulta ant ël quadrèt ([[Special:Captcha/help|për savejne dë pì]]):",
	'captcha-addurl'             => "Soa modìfica a la gionta dj'anliure esterne. Për giutene a vardesse da la reclam aotomatisà, për piasì ch'a fasa ël total ambelessì sota e ch'a buta l'arzultà ant ël quadrèt ([[Special:Captcha/help|për savejne dë pì]]):",
	'captcha-badlogin'           => "Për giutene a vardesse da 'nt ij programa ch'a fan ciav fàosse n'aotomàtich, për piasì ch'a fasa ël total ambelessì sota e ch'a buta l'arzultà ant ël quadrèt ([[Special:Captcha/help|për savejne dë pì]]):",
	'captcha-createaccount'      => "Për giutene a vardesse da ij programa ch'a deurbo dij cont n'aotomàtich, për piasì ch'a fasa ël total ambelessì sota
e ch'a buta l'arzultà ant ël quadrèt ([[Special:Captcha/help|për savejne dë pì]]):",
	'captcha-createaccount-fail' => "Ël còdes ëd verìfica ò ch'a manca d'autut ò ch'a l'é pa bon.",
	'captcha-create'             => "Për creé d'amblé sta pàgina-sì, për piasì ch'a fasa ël total ambelessì sota e ch'a buta l'arzultà<br />
ant ël quadrèt ([[Special:Captcha/help|për savejne dë pì]]):",
	'captchahelp-title'          => 'Còs é-lo mai ës captcha?',
	'captchahelp-cookies-needed' => "Për podej dovré sossì a l'ha da manca che sò navigator (browser) a pija ij cookies.",
	'captchahelp-text'           => "Soèns a-i riva che ij sit dla Ragnà che la gent a peul dovré për ëscrive chèich-còs, coma sta wiki-sì, a resto ambërlifà ëd reclam da màchine che a carìo soa ròba dadsà e dadlà n'aotomàtich. Për tant che sta reclam un a peula peuj gavela, a resta sempe un gran fastudi.

Dle vire, dzortut quand un a caria dj'anliure esterne neuve ansime a na pàgina, la wiki a peul ësmon-je na figurin-a con dël test colora ò pura tut ëstòrt e ciameje d'arbate lòn ch'a-i é scrit andrinta. Da già ch'a l'é grama scrive un programa ch'a lo fasa, a ven che la pì gran part dla gent a-i la fa a scrive, ma la ói part dle màchine a-i la fa pa.

Për maleur sossì a peul fastudié j'uetnt ch'a ës-ciàiro nen tant bin, col ch'a dòvro dij navigator mach a test ò pura dij navigator vocaj. Për adess i l'oma nen n'altërnativa disponibila ch'a fasa lese ël test a vos. Për piasì, ch'a contata j'aministrator dël sit se sossì a dovèissa mai nen lasseje carié dël test ch'a sia legitim (visadì, nen dla reclam).

Ch'a-i bata ansima al boton 'andré' ant sò navigator për torné andré a l'editor dla pàgina.",
	'captcha-addurl-whitelist'   => " #<!-- leave this line exactly as it is --> <pre>
# La sintassi a l'é costa:
#  * tut lòn ch'a-i ven dapress a un caràter \"#\" (fin-a a la fin dla riga) a l'é mach ëd coment
#  * minca riga nen veujda a l'é un frament d'espression regolar ch'as dòvra për identifiché j'adrësse dle màchine servente ant j'anliure
  #</pre> <!-- leave this line exactly as it is -->",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'captcha-create'             => 'ددې لپاره چې نوی ليکنه ترسره کړی، لطفاً د همدغه ساده شمېرو ځواب په ورکړ شوي چوکاټ کې وليکی ([[Special:Captcha/help|نور مالومات]]):',
	'captchahelp-cookies-needed' => 'ددې کړنې د ترسره کېدلو لپاره تاسو ته پکار ده چې د خپل کتنمل (browser) کوکيز (cookies) چارن کړی.',
);

/** Portuguese (Português)
 * @author Malafaya
 * @author Siebrand
 * @author 555
 */
$messages['pt'] = array(
	'captcha-edit'               => 'Para editar esta página será necessário que você digite as palavras exibidas na seguinte imagem no box apropriado ([[Special:Captcha/help|o que é isto?]])',
	'captcha-desc'               => 'Uma implementação simples de um sistema captcha',
	'captcha-addurl'             => 'Sua edição inclui novas ligações externas; como prevenção contra sistemas automatizados que inserem spam, será necessário que você digite as palavras exibidas na seguinte imagem no box apropriado ([[Special:Captcha/help|o que é isto?]])',
	'captcha-badlogin'           => 'Como prevenção contra formas automatizadas de pesquisa e descoberta de senhas, será necessário que você digite as palavras exibidas na seguinte imagem no box apropriado ([[Special:Captcha/help|o que é isto?]])',
	'captcha-createaccount'      => 'Como prevenção contra sistemas automatizados que inserem spam, será necessário que você digite as palavras exibidas na seguinte imagem para que possa se cadastrar:<br />
([[Special:Captcha/help|O que é isto?]])',
	'captcha-createaccount-fail' => 'Código incorreto ou não preenchido.',
	'captcha-create'             => 'Como prevenção contra sistemas automatizados que inserem spam, será necessário que você digite as palavras exibidas na seguinte imagem no box apropriado ([[Special:Captcha/help|o que é isto?]])',
	'captchahelp-title'          => 'Ajuda com o Captcha',
	'captchahelp-cookies-needed' => 'Você precisará ter cookies habilitados em seu navegador para que possa funcionar',
	'captchahelp-text'           => "Sítios abertos a inserções públicas, como é o caso deste wiki, são vulneráveis a spammers que utilizem ferramentas automatizadas para inserir seus links em diversos locais. Remover tais links posteriormente poderá ser um significativo incômodo.

Algumas vezes, especialmente ao adicionar novos links externos em uma página, o sistema exibirá uma imagem com um texto colorido ou distorcido e pedirá que você digite as palavras exibidas. Uma vez que essa é uma tarefa um tanto difícil de ser automatizada, ela possibilita que vários humanos façam as suas inserções ao mesmo tempo que inibe as que forem feitas por spammers e mecanismos automatizados.

Infelizmente, isso pode ser dificultoso a utilizadores com limitações visuais ou que naveguem através de  mecanismos baseados em texto ou baseados em voz. No momento não há uma alternativa em áudio. Por gentileza, contacte os administradores do sítio em casos que seja necessária a assistência de alguém para que você possa fazer as suas inserções legítimas.

Pressione o botão 'voltar' de seu navegador para retornar à página de edição.",
	'captcha-addurl-whitelist'   => ' #<!-- deixe este linha exactamente como está --> <pre>
# A sintaxe é a que se segue:
#  * Tudo desde o caracter "#" até ao fim da linha é um comentário
#  * Qualquer linha não vazia é um fragmento de regex que irá apenas verificar o servidor anfitrião dentro das URLs
  #</pre> <!-- deixe este linha exactamente como está -->',
	'right-skipcaptcha'          => 'Executar acções despoletadoras de captcha sem ter que passar pelo captcha',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'captchahelp-title' => 'Captcha nisqamanta yanapay',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 * @author BrokenArrow
 * @author Firilacroco
 */
$messages['ro'] = array(
	'captcha-edit'               => 'Editarea include legături externe noi. Pentru a evita spam-ul automat, vă rugăm să rezolvaţi adunarea de mai jos şi introduceţi rezultatul în căsuţă ([[Special:Captcha/help|detalii]]):',
	'captcha-desc'               => 'Implementare simplă captcha',
	'captcha-addurl'             => 'Editarea include legături externe noi. Pentru a evita spam-ul automat, vă rugăm să rezolvaţi adunarea de mai jos şi introduceţi rezultatul în căsuţă ([[Special:Captcha/help|detalii]]):',
	'captcha-badlogin'           => 'Ca măsură de protecţie împotriva spargerii de parole, vă rugăm să rezolvaţi adunarea de mai jos şi introduceţi rezultatul în căsuţă ([[Special:Captcha/help|detalii]]):',
	'captcha-createaccount'      => 'Pentru a evita crearea automată de conturi, vă rugăm să rezolvaţi adunarea de mai jos şi introduceţi rezultatul în căsuţă ([[Special:Captcha/help|detalii]]):',
	'captcha-createaccount-fail' => 'Cod de confirmare incorect sau lipsă.',
	'captcha-create'             => 'Editarea include legături externe noi. Pentru a evita spam-ul automat, vă rugăm să rezolvaţi adunarea de mai jos şi introduceţi rezultatul în căsuţă ([[Special:Captcha/help|detalii]]):',
	'captchahelp-title'          => 'Despre „Captcha”',
	'captchahelp-cookies-needed' => 'Trebuie ca browserul dumneavoastră să accepte cookie-uri pentru ca aceasta să funcţioneze.',
	'captchahelp-text'           => 'Siturile Web care acceptă postări din partea publicului, precum acest wiki, sunt de obicei abuzate de persoane care folosesc unelte automate pentru a introduce legături către multe situri. Deşi aceste legături de spam pot fi scoase, acest lucru reprezintă o muncă inconvenientă.

Uneori, mai ales la adăugarea de legături web noi într-o pagină, situl wiki vă poate arăta o imagine cu un text colorat sau distorsionat şi ruga să introduceţi cuvintele arătate. Deoarece aceasta este o sarcină greu de automatizat, va permite majorităţii persoanelor reale să posteze şi va opri majoritatea atacatorilor.

Din nefericire, această metodă îi poate deranja pe utilizatorii cu vedere limitată sau care folosesc browsere bazate pe text sau sunet. În acest moment nu avem o alternativă audio disponibilă. Vă rugăm, contactaţi administratorii sitului pentru asistenţă dacă metoda vă opreşte de la a face postări legitime.

Va fi nevoie ca browserul folosit să suporte module cookie.',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 * @author Siebrand
 * @author Kalan
 * @author Ahonc
 */
$messages['ru'] = array(
	'captcha-edit'               => 'Чтобы отредактировать эту страницу, пожалуйста, решите простой пример и введите ответ в текстовое поле ([[Special:Captcha/help|подробнее]]):',
	'captcha-desc'               => 'Простая реализация CAPTCHA',
	'captcha-addurl'             => 'Вы добавили ссылку на внешний сайт;
в целях защиты от автоматического спама, введите буквы изображённые на картинке:<br />
([[Special:Captcha/help|Что это такое?]])',
	'captcha-badlogin'           => 'В целях защиты от автоматического взлома пароля, пожалуйста, выполните следующее простое арифметическое действие и введите ответ в текстовое поле ниже ([[Special:Captcha/help|подробнее]]):',
	'captcha-createaccount'      => 'В качестве меры против автоматического спама, вы должны ввести буквы, изображённые на картинке, чтобы зарегистрироваться в системе:<br />
([[Special:Captcha/help|Что это такое?]])',
	'captcha-createaccount-fail' => 'Контрольная комбинация неверна или не введена.',
	'captcha-create'             => 'Чтобы создать страницу, решите простой пример и введите ответ в текстовое поле ([[Special:Captcha/help|что это?]]):',
	'captchahelp-title'          => 'Справка о CAPTCHA',
	'captchahelp-cookies-needed' => 'Вам нужно включить куки в браузере, чтобы эта функция заработала.',
	'captchahelp-text'           => 'Веб-сайты, позволяющие добавлять и изменять своё содержимое, в том числе вики, часто становятся целью спамеров, использующих программы для автоматического добавления ссылок. Хотя такие ссылки могут быть удалены, они являются существенной помехой.

Иногда, например при добавлении на страницу новой веб-ссылки, вики может показать вам картинку с цветным или искажённым текстом и предложить ввести текст, который вы видите. Так как подобная задача трудноавтоматизируема, это даёт возможность большинству людей разместить свои изменения, в то время, как большинство спамерских и вандальных программ не могут это сделать.

К сожалению, подобная защита может причинить неудобства людям с ограничениями по зрению или тем, кто использует читающие браузеры. В настоящее время у нас нет звуковой альтернативы данной проверке. Пожалуйста, обратитесь за помощью к администраторам, если подобная проверка мешает вам добросовестно работать с сайтом.

Нажмите кнопку «Назад» в вашем браузере, чтобы вернуться к редактированию.',
	'captcha-addurl-whitelist'   => ' #<!-- leave this line exactly as it is --> <pre>
# Описание синтаксиса:
#  * Всё, начиная с символа "#" и до конца строки считается комментарием
#  * Каждая непустая строка считается фрагментом регулярного выражения соответствующего имени узла в URL
  #</pre> <!-- leave this line exactly as it is -->',
	'right-skipcaptcha'          => 'выполнение требующих CAPTCHA-проверки действий без прохождения CAPTCHA',
);

/** Yakut (Саха тыла)
 * @author HalanTul
 * @author Siebrand
 */
$messages['sah'] = array(
	'captcha-edit'               => 'Сирэйи уларытыаххын баҕардаххына, манна баар примеры суоттаа уонна эппиэтин аналлаах сиргэ суруй ([[Special:Captcha/help|сиһилии]]):',
	'captcha-desc'               => 'CAPTCHA судургу барыла',
	'captcha-addurl'             => 'Тас саайка ыйынньык туруорбуккун; спаамтан көмүскэнэр соруктаах суолу толор - манна баар буукубалары хатылаа: <br />
([[{{ns:special}}:Captcha/help|Сиһилии]])',
	'captcha-badlogin'           => 'Киирии тылы аптамаат алдьаппатын туһугар оҥоһуллубут харыстыыр дьайыыны толор, манна баар примеры суоттаа уонна эппиэтин анал сиргэ суруй ([[Special:Captcha/help|сиһилии]]):',
	'captcha-createaccount'      => 'Бэлиэтэнэргэр аптамаатынан алдьатыыттан харыстыыр соруктаах дьайыыны оҥор, манна баар буукубалары анал сиргэ киллэр:<br />
([[{{ns:special}}:Captcha/help|Сиһилии]])',
	'captcha-createaccount-fail' => 'Бигэргэтии куода суох эбэтэр атын.',
	'captcha-create'             => 'Сирэйи оҥорорго бу примеры суоттаа ([[Special:Captcha/help|сиһилии]]):',
	'captchahelp-title'          => 'Captcha көмөтө',
	'captchahelp-cookies-needed' => 'Бу дьайыы үлэлиирин курдук браузергар куукины холбоо.',
	'captchahelp-text'           => 'Биһиги саайпыт курдук иһинээҕитин уларытары көҥүллүүр саайтарга сороҕор спам ыытар программалар аптаматынан бэйэлэрин ыйынньыктарын угаллар.
Оннук аптамаатынан эбиллибит ыйынньыктары суох оҥорор кыах баар эрээри, ол элбэх мэһэйдэри үөскэтиэн сөп.

Ол иһин сороҕор, холобур саҥа ыйынньыгы эбэргэ, программа өҥнөөх эбэтэр хаанньары барбыт тиэкистээх ойууну көрдөрөн, ол тиэкиһи анал түннүккэ хатылатыан сөп.
Маннык көрдөһүүнү аптамаат кыайан толорбот, оттон киһи үксэ чэпчэкитик толорор.

Ол гынан баран маннык көмүскэл сорох дьоҥҥо (көрбөт эбэтэр ааҕар браузердары туһанар дьоҥҥо) моһоллору үөскэтиэн сөп.
Билигин бу моһолу суох оҥорор кыах суох.
Оннук мэһэй таҕыстаҕына бука диэн баалама, биир эмит администраатарга этээр, көмөлөһүө.

Көннөрүүгэ төттөрү тиийэргэ браузерыҥ «Назад» тимэҕин баттаа.',
	'captcha-addurl-whitelist'   => ' #<!-- leave this line exactly as it is --> <pre>
# Синтаксиһын быһаарыыта:
#  * "#" бэлиэттэн строка бүтүөр дылы барыта хос быһаарыы курдук ааҕыллар
#  * Хас биирдии кураанах буолбатах строка URL сорҕотун курдук ааҕыллар
  #</pre> <!-- leave this line exactly as it is -->',
);

/** Scots (Scots)
 * @author OchAyeTheNoo
 */
$messages['sco'] = array(
	'captcha-edit' => 'Tae edit this airticle, please dae the eisy sum ablo an put the answer in the box ([[Special:Captcha/help|mair info]])',
);

/** Slovak (Slovenčina)
 * @author Helix84
 * @author Siebrand
 */
$messages['sk'] = array(
	'captcha-edit'               => 'Aby ste mohli upravovať túto stránku, vyriešte prosím tento jednoduchý súčet a napíšte výsledok do poľa ([[Special:Captcha/help|viac informácií]]):',
	'captcha-desc'               => 'Jednoduchá implementácia captcha',
	'captcha-addurl'             => 'Vaša úprava obsahuje nové externé odkazy. Ako pomoc pri ochrane pred automatickým spamom vyriešte prosím tento jednoduchý súčet a zadajte výsledok do poľa ([[Special:Captcha/help|viac informácií]]):',
	'captcha-badlogin'           => 'Ako ochranu proti automatizovanému lámaniu hesiel, prosím vyriešte nasledujúci súčet a zadajte ho do poľa pre odpoveď ([[Special:Captcha/help|viac informácií]]):',
	'captcha-createaccount'      => 'Kvôli ochrane proti automatizovanému spamu je potrebné napísať slová zobrazené na tomto obrázku, až potom bude vytvorený nový účet:
<br />([[Special:Captcha/help|Čo je toto?]])',
	'captcha-createaccount-fail' => 'Nesprávny alebo chýbajúci potvrdzovací kód.',
	'captcha-create'             => 'Aby ste mohli vytvoriť túto stránku, vyriešte prosím tento jednoduchý súčet a napíšte výsledok do poľa ([[Special:Captcha/help|viac informácií]]):',
	'captchahelp-title'          => 'Pomocník ku captcha',
	'captchahelp-cookies-needed' => 'Aby toto fungovalo, budete si musieť v prehliadači zapnúť koláčiky (cookies).',
	'captchahelp-text'           => 'Webstránky prijímajúce príspevky od verejnosti ako táto wiki sú často cieľom zneužitia spammermi, ktorí používajú automatizované nástroje na to, aby svoje odkazy umiestnili na množstvo stránok. Hoci je možné tieto odkazy odstrániť, zbytočne to zaťažuje používateľov.

Niekedy, obzvlášť keď pridávate webové odkazy k článkom, wiki vám môže zobraziť obrázok so zafarbeným alebo pokriveným textom a požiadať Vás o prepísanie zobrazených slov. Keďže takúto úlohu je ťažké zautomatizovať a umožní skutočným ľuďom poslať svoje príspevky, zastaví to väčšinu spammerov a iných robotických útočníkov.

Naneštastie, môže to byť prekážkou pre používateľov so zrakovým postihnutím alebo tých, ktorí používajú textové alebo hovoriace prehliadače. Momentálne nemáme dostupnú audio zvukovú alternatívu. Kontaktujte prosím správcov stránok, ak vám to neočakávane komplikuje umiestňovanie oprávnených príspevkov.

Stlačením tlačidla „späť“ vo vašom prehliadači sa vrátite do editora stránky.',
	'captcha-addurl-whitelist'   => ' #<!-- leave this line exactly as it is --> <pre>
# Syntax je nasledovná:
#   * Všetko od znaku „#“ do konca riadka je komentár
#   * Každý neprázdny riadok je fragment regulárneho výrazu, ktorého zhody budú iba stroje v rámci URL
  #</pre> <!-- leave this line exactly as it is -->',
	'right-skipcaptcha'          => 'Vykonávať činnosti spúšťajúce captcha bez toho, aby bolo potrebné vyriešiť captcha',
);

/** Slovenian (Slovenščina)
 * @author BrokenArrow
 */
$messages['sl'] = array(
	'captcha-edit'               => 'Vaše urejanje vključuje nove URL-povezave; zaradi zaščite pred avtomatizirano navlako boste morali vpisati besede, ki se pojavijo v okencu: <br />([[{{ns:Special}}:Captcha/help|Kaj je to?]])',
	'captcha-addurl'             => 'Vaše urejanje vključuje nove URL-povezave; zaradi zaščite pred avtomatizirano navlako boste morali vpisati besede, ki se pojavijo v okencu: <br />([[{{ns:Special}}:Captcha/help|Kaj je to?]])',
	'captcha-createaccount'      => 'Za registracijo je zaradi zaščite pred neželenimi reklamnimi sporočili treba vpisati prikazane besede: <br />([[{{ns:special}}:Captcha|Kaj je to?]])',
	'captcha-createaccount-fail' => 'Nepravilna ali manjkajoča potrditvena koda.',
	'captcha-create'             => 'Vaše urejanje vključuje nove URL-povezave; zaradi zaščite pred avtomatizirano navlako boste morali vpisati besede, ki se pojavijo v okencu: <br />([[{{ns:Special}}:Captcha/help|Kaj je to?]])',
	'captchahelp-title'          => 'Pomoč za captcha',
	'captchahelp-text'           => "Spletne strani, ki omogočajo objavljanje širši javnosti, kot na primer ta wiki, pogosto zlorabljajo spamerji, ki za objavo svojih povezav na mnogih straneh uporabljajo avtomatizirana orodja. Čeprav se te neželene povezave da odstraniti, so precejšnja nadloga.

Včasih, zlasti pri dodajanju novih spletnih povezav na stran, vam bo morda wiki prikazal sliko obarvanega ali popačenega besedila in zahteval vpis prikazanih besed. Ker je to opravilo težko avtomatizirati, bo s tem večini ljudi objavljanje dovoljeno, spamerji in druge robotski napadalci pa bodo ustavljeni.

Žal lahko to povzroči nevšečnosti uporabnikom s slabim vidom in tistim, ki uporabljajo besedilne ali govorne brskalnike. Glasovna možnost trenutno še ni na razpolago. Če vam to nepričakovano preprečuje legitimno objavo, se, prosimo, obrnite na administratorje spletišča.

Za vrnitev v urejevalnik izberite gumb 'nazaj' vašega brskalnika.",
);

/** Albanian (Shqip)
 * @author BrokenArrow
 * @author Dori
 */
$messages['sq'] = array(
	'captcha-edit'               => 'Për të redaktuar këtë faqe ju lutem zgjidhni shumën e mëposhtme dhe vendosni përgjigjen në kuti ([[Special:Captcha/help|më shumë informacion]]):',
	'captcha-desc'               => 'Pajisje me captcha të thjeshtë',
	'captcha-addurl'             => 'Redaktimi juaj ka lidhje URL të reja dhe si mbrojtje kundër abuzimeve automatike duhet të shtypni çfarë shfaqet tek figura e mëposhtme:<br /> ([[Special:Captcha|Çfarë është kjo?]])',
	'captcha-badlogin'           => 'Për tu mbrojtur nga metoda automatike të gjetjes së fjalëkalimeve ju kërkojmë të gjeni zgjidhni shumën e mëposhtme dhe të vendosni përgjigjen në kuti ([[Special:Captcha/help|më shumë informacion]]):',
	'captcha-createaccount'      => 'Për mbrojtje kundër regjistrimeve automatike duhet të zgjidhni ekuacionin e mëposhtëm para se të hapni llogarinë:<br />([[Special:Captcha|Çfarë është kjo?]])',
	'captcha-createaccount-fail' => 'Mesazhi që duhej shtypur mungon ose nuk është shtypur siç duhet.',
	'captcha-create'             => 'Për të krijuar këtë faqe ju lutem zgjidhni shumën e mëposhtme dhe vendosni përgjigjen në kuti ([[Special:Captcha/help|më shumë informacion]]):',
	'captchahelp-title'          => 'Ndihmë rreth sistemit "Captcha"',
	'captchahelp-cookies-needed' => 'Duhet të pranoni "biskota" nga shfletuesi juaj për këtë veprim.',
	'captchahelp-text'           => 'Faqet e rrjetit që pranojnë shkrime nga publiku, siç është edhe kjo wiki, shpesh abuzohen nga njerëz që duan të përfitojnë duke reklamuar ose promovuar lidhjet e tyre. Këto lloj abuzimesh mund të hiqen kollaj por janë një bezdi dhe shpenzim kohe i papranueshëm.

Ndonjëherë, sidomos kur po hapni një llogari të re apo kur po shtoni lidhje të reja nëpërmjet redaktimit tuaj, sistemi mund t\'ju shfaqi një figurë që përmban fjalë me gërma ose numra të shtrembruara ose me ngjyra të ndryshme të cilat ju duhet të shtypni para se të mund të kryeni veprimin në fjalë. Kjo bëhet pasi është shumë e vështirë për një robot ose mjet automatik të kryejë të njëjtën punë. Kështu mund të dallohet nëse jeni me të vërtetë një njeri apo një robot. Ky lloj sistemi s\'mund të ndalojë tërë abuzimet por ndalon një pjesë të mirë të tyre, sidomos ato që janë automatike dhe të shumta në numër.

Fatkeqësisht ky lloj sistemi mund të bezdisi përdoruesit me pamje të kufizuar ose ata që përdorin mjete teksti ose shfletues leximi me zë. Tani për tani nuk kemi mundësi për të ofruar një sistem me zë në vend të figurave. Ju lutem lidhuni me administruesit nëse ky sistem po ju ndalon të jepni kontribute të vlefshme.

Shtypni butonin "prapa" ("back") të shfletuesit tuaj për tu kthyer tek faqja e mëparshme.',
	'captcha-addurl-whitelist'   => '  #<!-- lëreni këtë rresht siç është --> <pre>
# Sintaksa është si më poshtë:
#  * Çdo gjë nga simboli "#" deri në fund të rreshtit është koment
#  * Çdo rresht jo-bosh është një pjesë regex që duhet t\'i përputhet emrat të shërbyesve brenda një URL-i
  #</pre> <!-- lëreni këtë rresht siç është -->',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Millosh
 */
$messages['sr-ec'] = array(
	'captcha-edit'               => 'За измену ове стране, реши једноставан збри испод и унеси одговор у кутију ([[Special:Captcha/help|детаљније]]):',
	'captcha-desc'               => 'једноставна капча имплементација',
	'captcha-addurl'             => 'Твоја измена укључује нове спољашње везе. У циљу заштите против аутоматског спама, реши једноставан збир испод и упиши одговор у кутију ([[Special:Captcha/help|детаљније]]):',
	'captcha-badlogin'           => 'У циљу заштите од аутоматске провале у лозинку, реши једноставан збир испод и унеси одговор у кутију ([[Special:Captcha/help|детаљније]]):',
	'captcha-createaccount'      => 'У циљу заштите од аутоматског стварања налога, реши једноставан збир доле и унеси га у кутију ([[Special:Captcha/help|детаљније]]):',
	'captcha-createaccount-fail' => 'Неправилан или непостојећи код за потврду.',
	'captcha-create'             => 'За стварање стране реши једноставан збир доле и унеси га у кутију ([[Special:Captcha/help|детаљније]]):',
	'captchahelp-title'          => 'помоћ за капчу',
	'captchahelp-cookies-needed' => 'Да би ово урадио, неопходно је да су ти колачићи омогућени у браузеру.',
	'right-skipcaptcha'          => 'Изведи акције капче без потребе да се прође кроз капчу.',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 * @author Siebrand
 */
$messages['stq'] = array(
	'captcha-edit'               => 'Tou Beoarbaidenge fon ju Siede löös ätterfoulgjende Reekenapgoawe un dräch dät Resultoat in dät Fäild hierunner ien ([[Special:Captcha/help|(Froagen of Probleme?]]):',
	'captcha-addurl'             => 'Dien Beoarbaidenge änthaalt näie externe Ferbiendengen. Toun Schuts foar automatisierde Spammenge löös ju ätterfoulgjende Reekenapgoawe un dräch dät Resultoat in dät Fäild hierunner ien. Klik dan fonnäien ap „Siede spiekerje“ [[{{ns:special}}:Captcha/help|(Froagen of Probleme?)]].',
	'captcha-badlogin'           => 'Toun Schuts foar ne Kompromittierenge fon dien Benutserkonto löös ju ätterfoulgjende Reekenapgoawe un dräch dät Resultoat in dät Fäild hierunner ien [[{{ns:special}}:Captcha/help|(Froagen of Probleme?)]]:',
	'captcha-createaccount'      => 'Toun Schuts foar automatisierden Anloage fon Benutserkonten löös ju ätterfoulgjende Reekenapgoawe un dräch dät Resultoat in dät Fäild hierunner ien [[{{ns:special}}:Captcha/help|(Froagen of Probleme?)]].',
	'captcha-createaccount-fail' => 'Falske of failjende Bestäätigengscode.',
	'captcha-create'             => 'Uum disse Siede tou moakjen, löös juu ätterfoulgjende Reekenapgoawe ap un dräch dät Resultoat in dät Fäild hier unner ien [[{{ns:special}}:Captcha/help|(Froagen of Probleme?)]].',
	'captchahelp-title'          => 'Captcha-Hälpe',
	'captchahelp-cookies-needed' => "'''Wichtige Waiwiesenge:''' Der mouten Cookies in dän Browser ferlööwed weese.",
	'captchahelp-text'           => 'Internetboode, do der foar Biedraage fon praktisk älkuneen eepen sunt - so as dät {{SITENAME}}-Wiki — wäide oafte fon Spammere misbruukt, do hiere Ferbiendengen automatisk ap fuul Websieden platzierje. Disse Spam-Ferbiendengen konnen wier wächhoald wäide, man jo sunt n groot Ferträit.

In fuul Falle, besunners bie dät Bietouföigjen fon näie Webferbiendengen tou ne Siede, kon dät foarkuume, dät dit Wiki ne Bielde mäd n faawigen un fertroalden Text anwiest un deertou apfoardert, do anwiesde Woude ientoutippen. Deer sun Apgoawe man stuur automatisk ouhonneld wäide kon, wäide deertruch do maaste Spammere, do der mäd automatiske Reewen oarbaidje, stopped, wierjuun moanskelke Benutsere hieren Biedraach seende konnen.

Spietelk genouch kon dät tou Meelasje foar Persoone fiere, do der minner goud sjo konnen of text- of sproakbasierde Browsere ferweende. Ne Löösenge is ju reguläre Anmäldenge as Benutser. Die „Tourääch“-Knoop fon dän Browser fiert tourääch in dät Beoarbaidengsfinster.',
	'captcha-addurl-whitelist'   => ' #<!-- leave this line exactly as it is --> <pre>
#  Syntax:
#   * Alles fon n #-Teeken bit tou dän Eend fon ju Riege is n Kommentoar
#   * Älke nit-loose Riege is n Regex-Fragment, dät juunuur den Hostnoome fon ne URL wröiged wäd
  #</pre> <!-- leave this line exactly as it is -->',
);

/** Sundanese (Basa Sunda)
 * @author Kandar
 * @author Irwangatot
 */
$messages['su'] = array(
	'captcha-edit'               => 'Pikeun ngédit artikel ieu, mangga eusian itungan di handap ([[Special:Captcha/help|émbaran lengkep]]):',
	'captcha-desc'               => 'Implementasi basajan captcha',
	'captcha-addurl'             => 'Éditan anjeun ngawengku tumbu kaluar anyar.
Pikeun nyegah spam, mangga eusian itungan di handap ieu
([[Special:Captcha/help|émbaran lengkep]]):',
	'captcha-createaccount'      => 'Pikeun nyegah dijieunna rekening sacara otomatis, mangga eusian itungan di handap ieu ([[Special:Captcha/help|émbaran lengkep]]):',
	'captcha-createaccount-fail' => 'Sandi konfirmasina salah atawa can dieusian.',
	'captcha-create'             => 'Pikeun nyieun kacana, mangga eusian itungan di handap ieu ([[Special:Captcha/help|émbaran lengkep]]):',
	'captchahelp-title'          => 'Pitulung Captcha',
	'captchahelp-text'           => "Ramatloka nu nampa tulisan ti masarakat umum kawas ieu wiki mindeng diganggu ku spammer nu maké pakakas otomatis pikeun midangkeun tumbu-tumbuna ka loba loka. Najan tumbu spam ieu bisa dihapus, ari loba-loba teuing mah matak nyapékeun.

Sometimes, especially when adding new web links to a page, the wiki may show you an image of colored or distorted text and ask you to type the words shown. Since this is a task that's hard to automate, it will allow most real humans to make their posts while stopping most spammers and other robotic attackers.

Unfortunately this may inconvenience users with limited vision or using text-based or speech-based browsers. At the moment we do not have an audio alternative available. Please contact the site administrators for assistance if this is unexpectedly preventing you from making legitimate posts.

You will need to have cookies enabled in your browser for this to work.

Hit the 'back' button in your browser to return to the page editor.",
	'right-skipcaptcha'          => 'Ngalakonan pamicu captcha tanpa ngaliwatan Captcha',
);

/** Swedish (Svenska)
 * @author M.M.S.
 * @author Lejonel
 */
$messages['sv'] = array(
	'captcha-edit'               => 'För att redigera den här sidan måste du först skriva svaret på följande
räkneuppgift i rutan ([[Special:Captcha/help|mer information]]):',
	'captcha-desc'               => 'Enkel implementation av captcha-system',
	'captcha-addurl'             => 'Din ändring lägger till nya externa länkar i texten. För att skydda wikin mot
automatisk spam måste du skriva svaret på följande räkneuppgift i rutan ([[Special:Captcha/help|mer information]]):',
	'captcha-badlogin'           => 'För att skydda mot wikin mot automatiserad lösenordsknäckning måste du skriva
svaret på följande räkneuppgift i rutan ([[Special:Captcha/help|mer information]]):',
	'captcha-createaccount'      => 'För att skydda wikin mot automatiskt skapade användarkonton måste du
skriva svaret på följande räkneuppgift i rutan ([[Special:Captcha/help|mer information]]):',
	'captcha-createaccount-fail' => 'Bekräftelsekoden är felaktig eller saknas.',
	'captcha-create'             => 'För att skapa den här sidan måste du skriva svaret på följande räkneuppgift
i rutan ([[Special:Captcha/help|mer information]]):',
	'captchahelp-title'          => 'Captchahjälp',
	'captchahelp-cookies-needed' => 'Du måste ha cookies aktiverade i din webbläsare för att det här ska fungera.',
	'captchahelp-text'           => 'Webbplatser som tillåter inlägg från allmänheten, som den här wikin gör, kan
missbrukas av spammare. De använder ofta automatiserade verktyg för att lägga till länkar på många webbsajter. Även om
dessa spamlänkar kan tas bort så är de till stort besvär.

Ibland, speciellt då du lägger till nya externa länkar på en sida, visar wikin en bild på en färgad eller förvriden text
och ber dig skriva texten som visas. Den uppgiften är svår att automatisera, men oftast lätt för en människa att utföra.
På så sätt stoppas spammare och andra robotattacker, medan riktiga mäniskor kan göra sina redigeringar.

Tyvärr kan det här orsaka problem för användare med nedsatt syn eller som använder text- eller talbaserade webbläsare.
För tillfället finns inga ljudbaserade alternativ tillgängliga. Om det här hindrar dig från att göra legitima ändringar
kan du be någon av administratörerna om hjälp.

Tryck på bakåtknappen i din webbläsare för att gå tillbaks till sidredigeringsläget.',
	'captcha-addurl-whitelist'   => ' #<!-- leave this line exactly as it is --> <pre>
# Syntaxen är följande:
#   * Allting från ett "#" till slutet av en rad är en kommentar
#   * Varje icketom rad är ett reguljärt uttryck som matchar domänen i en URL
 #</pre> <!-- leave this line exactly as it is -->',
	'right-skipcaptcha'          => 'Utför handlingar som normalt kräver "captcha"-bekräftning utan att använda "captcha"',
);

/** Telugu (తెలుగు)
 * @author Mpradeep
 * @author Veeven
 * @author Chaduvari
 */
$messages['te'] = array(
	'captcha-edit'               => 'ఈ పేజీని సరిదిద్దడానికి, కింది ఇచ్చిన చిన్న లెక్కని చేసి జవాబుని పక్కనున్న పెట్టెలో టైపు చెయ్యండి ([[ప్రత్యేక:Captcha/help|మరింత సమాచారం]]):',
	'captcha-desc'               => 'సరళమైన అమకవేప అమలు',
	'captcha-addurl'             => 'మీ దిద్దుబాటులో కొత్త బయటి లింకులు ఉన్నాయి. ఆటోమేటెడ్ స్పాము నుండి రక్షించేందుకు గాను, కింద ఇచ్చిన లెక్క యొక్క జవాబును ఇక్కడున్న పెట్టెలో రాయండి ([[Special:Captcha/help|మరింత సహాయం]]):',
	'captcha-badlogin'           => 'పాసువోర్డును బాట్ల ద్వారా తెలుసుకోకుండా ఉండేందుకు, కింద ఇచ్చిన లెక్క యొక్క జవాబును ఇక్కడున్న పెట్టెలో రాయండి ([[Special:Captcha/help|మరింత సహాయం]]):',
	'captcha-createaccount'      => 'బాట్ల ద్వారా ఖాతాలను సృష్టించకుండా నిరోధించటానికి, కింద ఇచ్చిన లెక్క యొక్క జవాబును ఇక్కడున్న పెట్టెలో రాయండి ([[Special:Captcha/help|మరింత సహాయం]]):',
	'captcha-createaccount-fail' => 'దృవీకరించుకోవడానికి విలువ ఇవ్వలేదు లేదా దానిని తప్పుగా ఇచ్చారు.',
	'captcha-create'             => 'కొత్తపేజీని సృష్టించడానికి, కింద ఇచ్చిన లెక్క యొక్క జవాబును ఇక్కడున్న పెట్టెలో రాయండి ([[Special:Captcha/help|మరింత సహాయం]]):',
	'captchahelp-title'          => 'ఆమకవేప సహాయం',
	'captchahelp-cookies-needed' => 'ఇది పని చెయ్యాలంటే మీ బ్రౌజరులో కూకీలు సశక్తమై ఉండాలి.',
	'captchahelp-text'           => "''ఆమకవేప'' అంటే '''ఆ'''టోమాటిక్ గా '''మ'''నుష్యులను, '''కం'''ప్యూటర్లను '''వే'''రుచేసే '''ప'''రీక్ష అని అర్థం.

ప్రజలనుండి రచనలను స్వీకరించే ఈ వికీ వంటి వెబ్‌సైట్లు, ఆటోమాటిక్ ప్రోగ్రాములతో తమ స్వంత లింకులను చేర్చే స్పాముష్కరుల దాడులకు గురవడం తరచూ జరుగుతూ ఉంటుంది. ఆ లింకులను తీసేయడం పెద్ద విషయం కాకపోయినప్పటికీ, అవి తలనెప్పి అనేది మాత్రం నిజం.

కొన్నిసార్లు, ముఖ్యంగా ఏదైనా పేజీ నుండి బయటకు లింకులు ఇచ్చేటపుడు, వంకర్లు తిరిగిపోయి ఉన్న పదాల బొమ్మను చూపించి ఆ పదాన్ని టైపు చెయ్యమని వికీ మిమ్మల్ని అడగవచ్చు. దీన్ని ఆటోమాటిక్ టూల్సుతో చెయ్యడం చాలా కష్టం కాబట్టి, స్పాము జిత్తులు చెల్లవు; మనుష్యులు మాత్రం మామూలుగానే చెయ్యగలరు.

దురదృష్టవశాత్తూ, చూపు సరిగా లేనివారికి, టెక్స్టు బ్రౌజర్లు మాత్రమే వాడేవారికి ఇది అసౌకర్యం కలిగిస్తుంది. ప్రస్తుతానికి శబ్దం వినిపించే వెసులుబాటు మాకు లేదు. మీరు రచనలు చెయ్యకుండా ఇది అడ్డుపడుతుంటే, సహాయం కోసం సైటు నిర్వాహకుణ్ణి సంప్రదించండి.

మీ బ్రౌజర్లోని బ్యాక్(back) మీటను నొక్కి ఇంతకు ముందరి పేజీకి వెళ్ళండి.",
	'captcha-addurl-whitelist'   => ' #<!-- ఈ వాఖ్యాన్ని మొత్తం ఉన్నదున్నట్లు ఇలాగే వదిలేయండి --> <pre>
# ఇక్కడ రాయాల్సిన విధానం ఇదీ:
#  * "#" అనే అక్ధరం తరువా నుండి ఆ వాఖ్యం చివరివరకూ ఒక కామెంటు
#  * ఖాళీగా లేని ప్రతీ లైను ఒక regex భాగము, ఇవి పేజీలో ఉన్న URLల్ల యొక్క హోష్టుతో మాత్రమే సరిచూడబడుతుంది
  #</pre> <!-- ఈ వాఖ్యాన్ని మొత్తం ఉన్నదున్నట్లు ఇలాగే వదిలేయండి -->',
	'right-skipcaptcha'          => 'ఆమకవేప ద్వారా పోకుండానే దాని ట్రిగ్గరు చర్యలను అమలు చెయ్యి',
);

/** Tajik (Cyrillic) (Тоҷикӣ/tojikī (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'captcha-edit'               => 'Барои вироиши ин мақола, лутфан ҳосили ҷамъи зеринро ҳисоб кунед ва натиҷаро дар ҷаъба ворид кунед ([[Special:Captcha/help|иттилооти бештар]]):',
	'captcha-desc'               => 'Татбиқи соддаи CAPTCHA',
	'captcha-addurl'             => 'Вироиши шумо пайвандҳои ҷадиди хориҷиро дар бар мегирад. Барои кӯмак ба пешгири аз ирсоли худкори ҳаразномаҳо, лутфан ҳосили ҷамъи зеринро ҳисоб кунед ва натиҷаро дар ҷаъба ворид кунед ([[Special:Captcha/help|иттилооти бештар]]):',
	'captcha-badlogin'           => 'Барои кӯмак ба пешгири аз шикастани калимаи убур, лутфан ҳосили ҷамъи зеринро ҳисоб кунед ва натиҷаро дар ҷаъба ворид кунед  ([[Special:Captcha/help|иттилооти бештар]]):',
	'captcha-createaccount'      => 'Барои кӯмак ба пешгири аз эҷоди худкори ҳисоби корбарӣ, лутфан ҳосили ҷамъи зеринро ҳисоб кунед ва натиҷаро дар ҷаъба ворид кунед  ([[Special:Captcha/help|иттилооти бештар]]):',
	'captcha-createaccount-fail' => 'Коди таъйид нодуруст ё гумшуда.',
	'captcha-create'             => 'Барои эҷоди саҳифа, лутфан ҳосили ҷамъи зеринро ҳисоб кунед ва натиҷаро дар ҷаъба ворид кунед  ([[Special:Captcha/help|иттилооти бештар]]):',
	'captchahelp-title'          => 'Роҳнамои Captcha',
	'captchahelp-cookies-needed' => 'Барои кор кардани он, шумо бояд кукиҳои мурургаратонро фаъол кунед.',
	'captchahelp-text'           => "Сомонаҳое, ки имкони тағйир тавассути ҳамагон дар онҳо вуҷуд дорад, монанди ин вики, гоҳ ё ногоҳ тавассути ҳаразнигориҳое, ки тавассути абзорҳои худкор пайванди худро дар чандин сомонаҳо мефиристанд, мавриди сӯъистифода қарор мегиранд.

Дар пораи аз маворид, ба вижа замоне, ки як пайванди интернетии ҷадид ба саҳифа изофа мешавад, вики метавонад, як тасвир аз ҳуруфи рангӣ ё матни бенурро ба шумо нишон бидиҳад ва аз шумо ворид кардани калимаи нишондодашударо пурсон мешавад. Ба хотири ин ки анҷоми ин кор ба шакли худкор душвор аст, ин амал ба аксари инсонҳое иҷозат медиҳад, ки ба ирсоли матолиб бипардозанд, дар ҳоле ки бештар роботҳои ҳамлакунанда ва ҳаразнигорҳоро мутавақиф мекунад.

Мутассифона ин равиш мумкин аст, корбароне, ки қувваи босираашон суст ё аз мурургарҳои матнӣ ё овозӣ истифода мекунанд, дучори маҳдудиятҳое бикунад. Дар ҳоли ҳозир ҳеҷ чойгузини савтӣ барои ин равиш мавҷуд нест. Чунончи ин масъала шуморо дучори маҳдудияте дур аз интизор дар ирсоли навиштаҳои миҷоз мекунад, бо мудирони сомона оиди кӯмак тамос бигиред.  

Дар муругаратон тугмаи 'бозгашт'-ро бо пахш кардан ба саҳифаи вироишгар баргардед.",
	'captcha-addurl-whitelist'   => ' #<!—ин сатрро ҳамон гуна, ки ҳаст раҳо кунед --> <pre>
# Қоида ба ин шакл аст:
#  * Ҳама чиз аз "#" то охири сатр як тавзеҳ ба назар гирифта мешавад
#  * Ҳар сатре, ки холӣ набошад як қитъа дар назар гирифта мешавад, ки фақат бо номи мизбони интернетӣ санҷида мешавад
  #</pre> <!-- ин сатрро ҳамон гуна, ки ҳаст раҳо кунед-->',
);

/** Thai (ไทย)
 * @author Passawuth
 */
$messages['th'] = array(
	'captcha-edit'               => 'เพื่อที่จะแก้ไขหน้านี้ กรุณาตอบโจทย์ปัญหาทางคณิตศาสตร์ข้างล่าง และใส่คำตอบลงในกล่อง ([[Special:Captcha/help|รายละเอียดเพิ่มเติม]]) :',
	'captcha-createaccount-fail' => 'โค้ดสำหรับการยืนยันยังไม่ได้ใส่หรือผิด',
);

/** Turkish (Türkçe)
 * @author Runningfridgesrule
 * @author SPQRobin
 */
$messages['tr'] = array(
	'captcha-edit'               => 'Bu sayfayı değiştirebilmek için lütfen aşağıdaki basit soruyu cevaplayın ve cevabı kutunun içine yazın ([[Special:Captcha/help|ayrıntılı bilgiler]]):',
	'captcha-addurl'             => 'Değişikliğiniz yeni dış bağlantılar içeriyor.
Otomatik spamdan korunmak için, lütfen aşağıdaki basit soruyu cevaplayın ve cevabı kutunun içine yazın ([[Special:Captcha/help|ayrıntılı bilgiler]]):',
	'captcha-badlogin'           => 'Otomatik parola çözülmesinden korunmak için, lütfen aşağıdaki basit soruyu cevaplayın ve kutunın içinde cevabı yazın ([[Special:Captcha/help|ayrıntılı bilgiler]]):',
	'captcha-createaccount'      => 'Otomatik spama karşı bir koruma olarak, hesabınızı kaydetmek için bu resimde gözüken kelimeleri tuşlamanız gerekmektedir ([[Special:Captcha/help|Bu nedir?]]):',
	'captcha-createaccount-fail' => 'Hatalı ya da eksik onay kodu.',
	'captcha-create'             => 'Bu sayfayı oluşturmak için, lütfen aşağıdaki basit soruyu cevaplayın ve kutunun içinde cevabı yazın ([[Special:Captcha/help|ayrıntılı bilgiler]]):',
	'captchahelp-title'          => 'Captcha yardımı',
	'captchahelp-cookies-needed' => 'Bunun çalışabilmesi için tarayıcınızın çerezleri kabul edilmesi gerekiyor.',
	'captchahelp-text'           => "{{SITENAME}} gibi dışarıdan katılıma izin veren internet siteleri, pek çok siteye bağlantılar yaratan otomatik araçlarını çalıştıran ''spam''cilerin saldırılarına sıklıkla maruz kalırlar. Bu spam nitelikli bağlantılar silinebilir, fakat bu temizlik önemli bir sıkıntı yaratacaktır.

Bazen, özellikle bir başka internet sitesine bağ eklerken, bozulmuş ve renklendirilmiş harflerden oluşan bir resim gösterilebilir ve sizden bu harfleri kutucuğa girmenizi istenir. Bu, otomatizasyonu oldukça zor bir iş olduğu için, gerçek insanlar bu işlemi yerine getirebilirken, spam yapmaya yarayan araçlar bunu yapmakta zorlanacaklardır.

Ne var ki bu durum, görme sorunları yaşayan kişiler ve salt yazı-tabanlı veya salt ses tabanlı internet tarayıcı programları kullanan kimseler için rahatsızlık yaratmaktadır. Ne yazık ki, şu an için sesli bir alternatifimiz bulunmamaktadır. Şayet bu sizin yeni hesap açmanızı engelliyorsa, yardım için site yöneticilerinden yardım isteyiniz.

Sayfa düzenleyiciye dönmek için tarayıcınızın 'geri' tuşuna basınız.",
);

/** Ukrainian (Українська)
 * @author Ahonc
 */
$messages['uk'] = array(
	'captcha-edit'               => 'Щоб відредагувати цю сторінку, будь ласка, виконайте просту арифметичну дію і введіть відповідь у текстове поле ([[Special:Captcha/help|докладніше]]):',
	'captcha-desc'               => 'Проста реалізація CAPTCHA',
	'captcha-addurl'             => 'Ви додали посилання на зовнішній сайт.
Із метою захисту від автоматичного спаму, будь ласка, виконайте просту арифметичну дію і введіть відповідь у текстове поле ([[Special:Captcha/help|докладніше]]):',
	'captcha-badlogin'           => 'Із метою захисту від автоматичного злому пароля, будь ласка, виконайте просту арифметичну дію і введіть відповідь у текстове поле ([[Special:Captcha/help|докладніше]]):',
	'captcha-createaccount'      => 'Із метою захисту від автоматичного створення облікового запису, будь ласка, виконайте просту арифметичну дію і введіть відповідь у текстове поле ([[Special:Captcha/help|докладніше]]):',
	'captcha-createaccount-fail' => 'Неправильний або відсутній код підтвердження.',
	'captcha-create'             => 'Щоб створити сторінку, будь ласка, виконайте просту арифметичну дію і введіть відповідь у текстове поле ([[Special:Captcha/help|докладніше]]):',
	'captchahelp-title'          => 'Довідка про CAPTCHA',
	'captchahelp-cookies-needed' => 'Вам потрібно ввімкнути куки у браузері, щоб ця функція запрацювала.',
	'captchahelp-text'           => 'Веб-сайти, що дозволяють додавати або змінювати свій вміст, у тому числі вікі, часто стають ціллю спамерів, які використовують програми для автоматичного додавання посилань.
Хоча такі посилання і можуть бути вилучені, вони є істотною вадою.

Іноді, наприклад при додаванні на сторінку нового веб-посилання, вікі може показати вам картинку з кольоровим або спотвореним текстом і запропонувати ввести текст, який ви бачите.
Так як подібну задачу важко автоматизувати, це дає можливість більшості людей робити свої зміни, в той час, як більшість спамерських і вандальних програм не можуть цього зробити.

На жаль, подібний захист може спричинити незручності для людей із вадами зору. Зараз у нас нема звукової альтернативи для такої перевірки. Будь ласка, зверніться по допомогу до адміністраторів, якщо подібна перевірка заважає вам добросовісно працювати з сайтом.

Натисніть кнопку «Назад» у вашому браузері, щоб повернутися до редагування.',
	'captcha-addurl-whitelist'   => '#<!-- leave this line exactly as it is --> <pre>
# Опис синтаксису:
#  * Все, що починається з символу "#" до кінця рядка, вважається коментарем
#  * Кожний непорожній рядок вважається фрагментом регулярного виразу відповідної назви вузла в URL
   #</pre> <!-- leave this line exactly as it is -->',
	'right-skipcaptcha'          => 'Виконання дій, що вимагають CAPTCHA-перевірки, без проходження CAPTCHA',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'captcha-edit'               => 'Par modificar la pagina te ghè da risòlvar sto senplice calcolo presentà de seguito e inserir el risultato ne la casela
([[Special:Captcha/help|magiori informazion]]):',
	'captcha-desc'               => 'Senplice inplementazion de un Captcha',
	'captcha-addurl'             => "La modifica richiesta la zonta dei colegamenti foresti novi a la pagina; come misura precauzional contro l'inserimento automatico de spam, te ghè da risòlvar sto senplice calcolo presentà de seguito e inserir el risultato ne la casela ([[Special:Captcha/help|magiori informazion]]):",
	'captcha-badlogin'           => 'Come misura precauzional contro i tentativi de forzatura automatica de la password, te ghè da risòlvar sto senplice calcolo presentà de seguito e inserir el risultato ne la casela ([[Special:Captcha/help|magiori informazion]]):',
	'captcha-createaccount'      => 'Come misura precauzional contro i tentativi de creazion automatica dei account, par registrarse te ghè da risòlvar sto senplice calcolo presentà de seguito e inserir el risultato ne la casela ([[Special:Captcha/help|magiori informazion]]):',
	'captcha-createaccount-fail' => 'Codice de verifica sbaglià o mancante.',
	'captcha-create'             => 'Per crear la pagina te ghè da risòlvar sto senplice calcolo presentà de seguito e inserir el risultato ne la casela ([[Special:Captcha/help|magiori informazion]]):',
	'captchahelp-title'          => "Coss'èlo sto captcha?",
	'captchahelp-cookies-needed' => 'Te ghè da verghe i cookies abilità sul to browser par proseguir.',
	'captchahelp-text'           => "Sucéde spesso che i siti web che i acèta messagi publici, come sta wiki, i sia tolti de mira da spammer che dòpara strumenti automatici par inserir colegamenti publicitari verso un gran nùmaro de siti. Anca se i colegamenti insiderài i se pol cavar, se trata comunque de na secadura mìa da póco.

In çerti casi, par esenpio quando se çerca de zontar novi colegamenti web in te na pagina, el software wiki el pol mostrar na imagine con un breve testo colorà e/o distorto, domandàndoghe a l'utente de riscrìvarlo drento na casela fata aposta. Sicome i computer no i xe mìa boni de replicar a la perfezion sta azion, sto mecanismo el ghe consente a (quasi tuti) i utenti reali de conpletar l'inserimento che i volea, inpedéndoghe l'acesso a la magior parte dei spammer e dei altri atachi automatizà.

Sfortunatamente, ste misure de sicureza le pole métar in dificoltà i utenti che gà problemi de vista o quei che dòpara browser testuali o basà su la sintesi vocale. Purtropo al momento no xe disponibile nissun mecanismo alternativo basà su messagio audio; se ste procedure le inpedisse l'inserimento de informazion che se ritien legìtime, se prega de contatar i aministradori del sito e domandarghe assistensa.

Struca el boton \"Indrìo\" del to browser par tornar a la pagina de modifica.",
	'captcha-addurl-whitelist'   => '  #<!-- no sta modificar in alcun modo sta riga --> <pre>
# La sintassi la xe la seguente:
#  * Tuto quel che segue un caràtere "#" el xe un comento, fin a la fine de la riga
#  * Tute le righe mìa vode le xe framenti de espressioni regolari che se àplica al solo nome de l\'host ne le URL
   #</pre> <!-- no sta modificar in alcun modo sta riga -->',
	'right-skipcaptcha'          => 'Esegui le funsion de triggering del captcha sensa passar par el captcha',
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 * @author Minh Nguyen
 * @author Siebrand
 */
$messages['vi'] = array(
	'captcha-edit'               => 'Để sửa đổi trang này, xin hãy giải phép cộng đơn giản dưới đây và gõ câu trả lời vào ô ([[Special:Captcha/help|thông tin thêm]]):',
	'captcha-desc'               => 'Bộ CAPTCHA đơn giản',
	'captcha-addurl'             => 'Sửa đổi của bạn có chứa các liên kết ra bên ngoài. Để giúp tránh spam tự động, xin hãy giải phép toán đơn giản ở dưới và gõ kết quả vào ô ([[Special:Captcha/help|thông tin thêm]]):',
	'captcha-badlogin'           => 'Để giúp tránh hành động bẻ mật khẩu tự động, xin hãy giải phép cộng
đơn giản ở dưới và gõ kết quả vào ô ([[Special:Captcha/help|thông tin thêm]]):',
	'captcha-createaccount'      => 'Để giúp tránh việc tạo tài khoản tự động, xin hãy giải phép cộng
đơn giản ở dưới và gõ kết quả vào ô ([[Special:Captcha/help|thông tin thêm]]):',
	'captcha-createaccount-fail' => 'Thiếu mã xác nhận hoặc mã xác nhận sai.',
	'captcha-create'             => 'Để tạo mới trang, xin hãy giải phép cộng đơn giản ở dưới và gõ
câu trả lời vào ô ([[Special:Captcha/help|thông tin thêm]]):',
	'captchahelp-title'          => 'Trợ giúp Captcha',
	'captchahelp-cookies-needed' => 'Bạn sẽ cần phải bật cookie trong trình duyệt của bạn để chức năng này hoạt động',
	'captchahelp-text'           => 'Những website cho phép bất kỳ ai cũng có thể gửi thông tin như wiki thường bị các tay spam lạm dụng dùng công cụ tự động gửi các liên kết của họ tới rất nhiều website khác. Tuy chúng ta có thể xóa các liên kết này khỏi trang, chúng vẫn gây nhiều phiền toái.

Đôi khi, nhất là khi bạn bổ sung liên kết mới vào trang, wiki có thể hiển thị một hình có chữ dạng màu mè và méo mó rồi yêu cầu bạn gõ lại các chữ trong hình này. Do các phần mềm tự động khó đọc những hình này, nên mọi người bình thường có thể tiếp tục gửi thông tin, đồng thời chặn được các spam và robot phá hoại.

Tuy vậy, tính năng này có thể bất tiện đối với những độc giả có thị giác yếu hay đang sử dụng trình duyệt bằng văn bản thuần hay trình duyệt bằng tiếng nói. Hiện tại chúng tôi chưa có chức năng phát âm thay thế. Xin hãy liên lạc với người quản trị trang web để được trợ giúp nếu điều này vô tình ngăn cản bạn đóng góp nội dung tốt.

Nhấn chuột vào nút “Back” của trình duyệt để trở lại trang soạn thảo.',
	'captcha-addurl-whitelist'   => ' #<!-- xin để dòng này đừng thay đổi --> <pre>
# Cú pháp như sau:
#   * Mọi thứ bắt đầu bằng ký tự “#” là lời chú thích
#   * Mọi hàng không trắng là một đoạn biểu thức chính quy (regex) sẽ chỉ được so trùng với tên máy chủ trong URL
  #</pre> <!-- xin để dòng này đừng thay đổi -->',
	'right-skipcaptcha'          => 'Tự động bỏ qua các hình CAPTCHA',
);

/** Volapük (Volapük)
 * @author Smeira
 * @author Malafaya
 */
$messages['vo'] = array(
	'captcha-edit'               => 'Ad redakön yegedi at, dunolös, begö! saedami dono e penolös saedoti in bokil ([[Special:Captcha/help|nüns pluik]]):',
	'captcha-addurl'             => 'Redakam olik keninükon yümis plödik nulik. Ad jelön siti ta peneds itjäfidik, dunolös, begö! saedami sököl, e penolös saedoti in bokil ([[Special:Captcha/help|nüns pluik]]):',
	'captcha-badlogin'           => 'Ad jelön siti ta daget itjäfidik letavödas, dunolös, begö! saedami sököl e penolös saedoti in bokil ([[Special:Captcha/help|nüns pluik]]):',
	'captcha-createaccount'      => 'Ad jelön siti ta kalijafam itjäfidik, dunolös, begö! saedami sököl e penolös saedoti in bokil ([[Special:Captcha/help|nüns pluik]]):',
	'captcha-createaccount-fail' => 'Kot fümükama paneveräton u paseleton.',
	'captcha-create'             => 'Ad jafön padi, dunolös saedami balugik dono e penolös saedoti in bokil ([[Special:Captcha/help|nüns pluik]]):',
	'captchahelp-title'          => 'Yuf ela Captcha',
	'captchahelp-cookies-needed' => 'Nedol mögükön „kekilis“ bevüresodanaföme olik ad dunön atosi.',
	'captcha-addurl-whitelist'   => ' #<!-- leave this line exactly as it is --> <pre>
# Süntag binon sökölos:
#  * Valikos de malat: „#“ jü fin liena binon küpet
#  * Lien no vägik alik binon brekot: „regex“, kel poleigodon te ko vöds ninü els URLs
  #</pre> <!-- leave this line exactly as it is -->',
);

/** Walloon (Walon)
 * @author BrokenArrow
 */
$messages['wa'] = array(
	'captcha-edit'               => "Dins vos candjmints i gn a des novelès hårdêyes (URL); po s' mete a houte des robots di spam, nos vs dimandans d' acertiner ki vos estoz bén ene djin, po çoula, tapez les mots k' aparexhèt dins l' imådje chal pa dzo:<br />([[{{ns:special}}:Captcha/help|Pocwè fjhans ns çoula?]])",
	'captcha-addurl'             => "Dins vos candjmints i gn a des novelès hårdêyes (URL); po s' mete a houte des robots di spam, nos vs dimandans d' acertiner ki vos estoz bén ene djin, po çoula, tapez les mots k' aparexhèt dins l' imådje chal pa dzo:<br />([[{{ns:special}}:Captcha/help|Pocwè fjhans ns çoula?]])",
	'captcha-createaccount'      => "Po s' mete a houte des robots di spam, nos vs dimandans d' acertiner ki vos estoz bén ene djin po-z ahiver vosse conte, po çoula, tapez les mots k' aparexhèt dins l' imådje chal pa dzo:<br />([[{{ns:special}}:Captcha/help|Pocwè fjhans ns çoula?]])",
	'captcha-createaccount-fail' => "Li côde d' acertinaedje est incorek ou mancant.",
	'captcha-create'             => "Dins vos candjmints i gn a des novelès hårdêyes (URL); po s' mete a houte des robots di spam, nos vs dimandans d' acertiner ki vos estoz bén ene djin, po çoula, tapez les mots k' aparexhèt dins l' imådje chal pa dzo:<br />([[{{ns:special}}:Captcha/help|Pocwè fjhans ns çoula?]])",
	'captchahelp-title'          => "Aidance passete d' acertinaedje",
	'captchahelp-text'           => "Les waibes k' acceptèt des messaedjes do publik, come ci wiki chal, sont sovint eployîs pa des må-fjhants spameus, po pleur mete, avou des usteyes otomatikes, des loyéns di rclame viè les sites da zels.
Bén seur, on pout todi les disfacer al mwin, mins c' est on soyant ovraedje.

Adon, pa côps, copurade cwand vos radjoutez des hårdêyes a ene pådje, ou å moumint d' ahiver on novea conte sol wiki, on eployrè ene passete d' acertinaedje, dj' ô bén k' on vos mostere ene imådje avou on tecse kitoirdou eyet vs dimander di taper les mots so l' imådje. Come li ricnoxhance di ç' tecse la est målåjheye a fé otomaticmint pa on robot, çoula permete di leyî les vraiyès djins fé leus candjmints tot arestant l' plupårt des spameus et des sfwaitès atakes pa robot.

Målureuzmint çoula apoite eto des målåjhminces po les cis k' ont des problinmes po vey, ou k' eployèt des betchteus e môde tecse ou båzés sol vwès. Pol moumint, nos n' avans nén ene alternative odio. S' i vs plait contactez les manaedjeus do site po d' l' aidance si çoula vos espaitche di fé vos candjmints ledjitimes.

Clitchîz sol boton «En erî» di vosse betchteu waibe po rivni al pådje di dvant.",
);

/** Yue (粵語) */
$messages['yue'] = array(
	'captcha-edit'               => '要編輯呢一篇文，請答出一個簡單嘅加數和，跟住響個盒度打入 ([[Special:Captcha/help|更多資料]]):',
	'captcha-desc'               => '簡單嘅 captcha 實行',
	'captcha-addurl'             => '你編輯嘅內容裏面有新嘅URL連結；為咗避免受到自動垃圾程式的侵擾，請答出一個簡單嘅加數和，跟住響個盒度打入 ([[Special:Captcha/help|更多資料]]):',
	'captcha-badlogin'           => '為咗防止程式自動破解密碼，請答出一個簡單嘅加數和，跟住響個盒度打入 ([[Special:Captcha/help|更多資料]]):',
	'captcha-createaccount'      => '為咗防止程式自動註冊，請答出一個簡單嘅加數和，跟住響個盒度打入 ([[Special:Captcha/help|更多資料]]):',
	'captcha-createaccount-fail' => '驗證碼錯誤或者唔見咗。',
	'captcha-create'             => '要開呢一版，請答出一個簡單嘅加數和，跟住響個盒度打入 ([[Special:Captcha/help|更多資料]]):',
	'captchahelp-title'          => 'Captcha 幫助',
	'captchahelp-cookies-needed' => '你需要開咗響瀏覽器度嘅cookies先至可以用呢樣嘢。',
	'captchahelp-text'           => '就好似呢個wiki咁，對公眾開放編輯嘅網站係會經常受到垃圾連結騷擾。嗰啲人利用自動化垃圾程序將佢哋嘅連結張貼到好多網站。雖然呢啲連結可以被清除，但係呢啲嘢確實令人十分之討厭。

有時，特別係當響一頁添加新嘅網頁連結嗰陣，呢個網站會畀你睇一幅有顏色的或者有變形文字嘅圖像，跟住要你輸入所顯示嘅文字。因為咁係難以自動完成嘅一項任務，它將允許人保存佢哋嘅編輯，同時亦阻止大多數發送垃圾郵件者同其它機械人嘅攻擊。

令人遺憾嘅係，咁會令到視力唔好嘅人，或者利用基於文本或者基於聲音嘅瀏覽器用戶感到不便。而目前我哋仲未能夠提供音頻嘅選擇。如果咁樣咁啱阻止到你進行正常嘅編輯，請同管理員聯繫以獲得幫助。

撳一下響瀏覽器度嘅「後退」掣返去你之前所編輯緊嘅頁面。',
	'captcha-addurl-whitelist'   => ' #<!-- leave this line exactly as it is --> <pre>
# 語法好似下面噉:
#   * 所有由 "#" 字元之後嘅嘢到行尾係註解
#   * 所有非空白行係一個regex部份，只係會同裏面嘅URL主機相符
 #</pre> <!-- leave this line exactly as it is -->',
	'right-skipcaptcha'          => '執行captcha引發嘅動作時唔需要經過captcha',
);

/** Simplified Chinese (‪中文(简体)‬) */
$messages['zh-hans'] = array(
	'captcha-edit'               => '要编辑这篇文章，请答出一个简单的加法，然後在框内输入 ([[Special:Captcha/help|更多资料]]):',
	'captcha-desc'               => '简单的 captcha 实行',
	'captcha-addurl'             => '你编辑的内容中含有一个新的URL连结；为了免受自动垃圾程式的侵扰，请答出一个简单的加法，然後在框内输入 ([[Special:Captcha/help|更多资料]]):',
	'captcha-badlogin'           => '为了防止程式自动破解密码，请答出一个简单的加法，然後在框内输入 ([[Special:Captcha/help|更多资料]]):',
	'captcha-createaccount'      => '为了防止程式自动注册，请答出一个简单的加法，然後在框内输入 ([[Special:Captcha/help|更多资料]]):',
	'captcha-createaccount-fail' => '验证码错误或丢失。',
	'captcha-create'             => '要创建页面，请答出一个简单的加法，然後在框内输入 ([[Special:Captcha/help|更多资料]]):',
	'captchahelp-title'          => 'Captcha 说明',
	'captchahelp-cookies-needed' => '您需要开启浏览器上的cookies方可使用这个工具。',
	'captchahelp-text'           => '像本站一样，对公众开放编辑的网站经常被垃圾连结骚扰。那些人使用自动化垃圾程序将他们的连结张贴到很多网站。虽然这些连结可以被清除，但是这些东西确实令人十分讨厌。

有时，特别是当给一个页面添加新的网页连结时，本站会让你看一幅有颜色的或者有变形文字的图像，并且要你输入所显示的文字。因为这是难以自动完成的一项任务，它将允许人保存他们的编辑，同时阻止大多数发送垃圾邮件者和其他机器人的攻击。

令人遗憾是，这会使得视力不好的人，或者使用基於文本或者基於声音的浏览器的用户感到不便。而目前我们还没有提供的音频的选择。如果这正好阻止你进行正常的编辑，请和管理员联系获得帮助。

点击浏览器中的「後退」按钮返回你所编辑的页面。',
	'captcha-addurl-whitelist'   => ' #<!-- leave this line exactly as it is --> <pre>
# 语法像下面这样:
#   * 所有由 "#" 字元之後嘅字元至行尾是注解
#   * 所有非空白行是一个regex部份，只是跟在里面的URL主机相符
 #</pre> <!-- leave this line exactly as it is -->',
	'right-skipcaptcha'          => '执行captcha引发的动作时不需要经过captcha',
);

/** Traditional Chinese (‪中文(繁體)‬) */
$messages['zh-hant'] = array(
	'captcha-edit'               => '要編輯這篇文章，請答出一個簡單的加法，然後在框內輸入 ([[Special:Captcha/help|更多資料]]):',
	'captcha-desc'               => '簡單的 captcha 實行',
	'captcha-addurl'             => '你編輯的內容中含有一個新的URL連結；為了免受自動垃圾程式的侵擾，請答出一個簡單的加法，然後在框內輸入 ([[Special:Captcha/help|更多資料]]):',
	'captcha-badlogin'           => '為了防止程式自動破解密碼，請答出一個簡單的加法，然後在框內輸入 ([[Special:Captcha/help|更多資料]]):',
	'captcha-createaccount'      => '為了防止程式自動註冊，請答出一個簡單的加法，然後在框內輸入 ([[Special:Captcha/help|更多資料]]):',
	'captcha-createaccount-fail' => '驗證碼錯誤或丟失。',
	'captcha-create'             => '要創建頁面，請答出一個簡單的加法，然後在框內輸入 ([[Special:Captcha/help|更多資料]]):',
	'captchahelp-title'          => 'Captcha 說明',
	'captchahelp-cookies-needed' => '您需要開啟瀏覽器上的cookies方可使用這個工具。',
	'captchahelp-text'           => '像本站一樣，對公眾開放編輯的網站經常被垃圾連結騷擾。那些人使用自動化垃圾程序將他們的連結張貼到很多網站。雖然這些連結可以被清除，但是這些東西確實令人十分討厭。

有時，特別是當給一個頁面添加新的網頁連結時，本站會讓你看一幅有顏色的或者有變形文字的圖像，並且要你輸入所顯示的文字。因為這是難以自動完成的一項任務，它將允許人保存他們的編輯，同時阻止大多數發送垃圾郵件者和其他機器人的攻擊。

令人遺憾是，這會使得視力不好的人，或者使用基於文本或者基於聲音的瀏覽器的用戶感到不便。而目前我們還沒有提供的音頻的選擇。如果這正好阻止你進行正常的編輯，請和管理員聯繫獲得幫助。

點擊瀏覽器中的「後退」按鈕返回你所編輯的頁面。',
	'captcha-addurl-whitelist'   => ' #<!-- leave this line exactly as it is --> <pre>
# 語法像下面這樣:
#   * 所有由 "#" 字元之後嘅字元至行尾是註解
#   * 所有非空白行是一個regex部份，只是跟在裏面的URL主機相符
 #</pre> <!-- leave this line exactly as it is -->',
	'right-skipcaptcha'          => '執行captcha引發的動作時不需要經過captcha',
);

