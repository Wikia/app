<?php
/**
 * Internationalisation file for YouTubeAuthSub extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Travis Derouin
 */
$messages['en'] = array(
	'youtubeauthsub'                     => 'Upload YouTube video',
	'youtubeauthsub-desc'                => 'Allows users to [[Special:YouTubeAuthSub|upload videos]] directly to YouTube',
	'youtubeauthsub_info'                => "To upload a video to YouTube to include on a page, fill out the following information:",
	'youtubeauthsub_title'               => 'Title',
	'youtubeauthsub_description'         => 'Description',
	'youtubeauthsub_password'            => "YouTube password",
	'youtubeauthsub_username'            => "YouTube username",
	'youtubeauthsub_keywords'            => 'Keywords',
	'youtubeauthsub_category'            => 'Category',
	'youtubeauthsub_submit'              => 'Submit',
	'youtubeauthsub_clickhere'           => 'Click here to log in to YouTube',
	'youtubeauthsub_tokenerror'          => 'Error generating authorization token, try refreshing.',
	'youtubeauthsub_success'             => "Congratulations!
Your video is uploaded.
<a href='http://www.youtube.com/watch?v=$1'>View your video</a>.
YouTube may require some time to process your video, so it might not be ready just yet.

To include your video in a page on the wiki, insert the following code into a page:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => "To upload a video, you will be required to first log in to YouTube.",
	'youtubeauthsub_uploadhere'          => "Upload your video from here:",
	'youtubeauthsub_uploadbutton'        => 'Upload',
	'youtubeauthsub_code'                => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 View this video]',
	'youtubeauthsub_summary'             => 'Uploading YouTube video',
	'youtubeauthsub_uploading'           => 'Your video is being uploaded.
Please be patient.',
	'youtubeauthsub_viewpage'            => 'Alternatively, you can [[$1|view your video]].',
	'youtubeauthsub_jserror_nokeywords'  => 'Please enter 1 or more keywords.',
	'youtubeauthsub_jserror_notitle'     => 'Please enter a title for the video.',
	'youtubeauthsub_jserror_nodesc'      => 'Please enter a description for the video.',
);

/** Message documentation (Message documentation)
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Purodha
 * @author Siebrand
 */
$messages['qqq'] = array(
	'youtubeauthsub-desc' => '{{desc}}',
	'youtubeauthsub_title' => '{{Identical|Title}}',
	'youtubeauthsub_description' => '{{Identical|Description}}',
	'youtubeauthsub_category' => '{{Identical|Category}}',
	'youtubeauthsub_submit' => '{{Identical|Submit}}',
);

/** адыгэбзэ (адыгэбзэ)
 * @author Celekan
 */
$messages['ady-cyrl'] = array(
	'youtubeauthsub_title' => 'Тхылъышъхьэ',
);

/** Afrikaans (Afrikaans)
 * @author Adriaan
 * @author Arnobarnard
 * @author Naudefj
 */
$messages['af'] = array(
	'youtubeauthsub' => 'Laai YouTube-video op',
	'youtubeauthsub-desc' => "Stel gebruikers in staat om video's direk na YouTube [[Special:YouTubeAuthSub|op te laai]]",
	'youtubeauthsub_info' => "Verskaf die volgende inligting in om 'n video na YouTube op te laai sodat dit later op 'n bladsy bygevoeg kan word.",
	'youtubeauthsub_title' => 'Titel',
	'youtubeauthsub_description' => 'Beskrywing',
	'youtubeauthsub_password' => 'YouTube-wagwoord',
	'youtubeauthsub_username' => 'YouTube-gebruikersnaam',
	'youtubeauthsub_keywords' => 'Sleutelwoorde',
	'youtubeauthsub_category' => 'Kategorie',
	'youtubeauthsub_submit' => 'Oplaai',
	'youtubeauthsub_clickhere' => 'Kliek hier om by YouTube aan te teken',
	'youtubeauthsub_tokenerror' => 'Fout met die generasie van die sekuriteitsbewys. Herlaai die bladsy.',
	'youtubeauthsub_success' => "Baie geluk! 
Jou video is opgelaai.
<a href='http://www.youtube.com/watch?v=$1'>Kyk na u video.</a>
YouTube mag moontlik tyd neem om u video te verwerk en miskien is dit nog nie gereed nie.

Gebruik die volgende kode om u video op 'n bladsy op die wiki te plaas:<code>
{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => "U moet eers op YouTube aanteken alvorens u 'n video kan oplaai.",
	'youtubeauthsub_uploadhere' => 'Laai u video van hier op:',
	'youtubeauthsub_uploadbutton' => 'Laai op',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 U kan hierdie video kyk]',
	'youtubeauthsub_summary' => 'Besig om YouTube-video op te laai',
	'youtubeauthsub_uploading' => 'Jou video word opgelaai.
Wees asseblief geduldig.',
	'youtubeauthsub_viewpage' => 'Alternatiewelik kan u na [[$1|u video kyk]].',
	'youtubeauthsub_jserror_nokeywords' => 'Verskaf asseblief een of meer sleutelwoorde.',
	'youtubeauthsub_jserror_notitle' => "Verskaf asseblief 'n titel vir die video.",
	'youtubeauthsub_jserror_nodesc' => "Verskaf asseblief 'n beskrywing vir die video.",
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'youtubeauthsub' => 'Ngarko YouTube video',
	'youtubeauthsub-desc' => 'Lejon përdoruesit të [[Special:YouTubeAuthSub|ngarkoni videot]] drejtpërdrejt në YouTube',
	'youtubeauthsub_info' => 'Për të ngarkoj një video në YouTube për të përfshirë në një faqe, plotësoni informacionin e mëposhtëm:',
	'youtubeauthsub_title' => 'Titull',
	'youtubeauthsub_description' => 'Përshkrim',
	'youtubeauthsub_password' => 'Fjalëkalimi YouTube',
	'youtubeauthsub_username' => 'username YouTube',
	'youtubeauthsub_keywords' => 'Fjalë kyçe',
	'youtubeauthsub_category' => 'Kategori',
	'youtubeauthsub_submit' => 'Submit',
	'youtubeauthsub_clickhere' => 'Kliko këtu për të hyni brënda për të YouTube',
	'youtubeauthsub_tokenerror' => 'autorizim Gabim gjeneruar shenjë, do të përpiqen të freskëta.',
	'youtubeauthsub_success' => "Urime!
Video juaj është ngarkuar.
<a href='http://www.youtube.com/watch?v=$1'>View video tuaj</a>.
 YouTube mund të kërkojë pak kohë për procesin video tuaj, kështu që nuk mund të jetë gati vetëm ende.

Për të përfshijnë video tuaj në një faqe në wiki, futni kodin e mëposhtëm në një faqe: <code>{{#ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Për të ngarkoj një video, ju do të kërkohet të hyni brënda për të parë në YouTube.',
	'youtubeauthsub_uploadhere' => 'Upload your video nga këtu:',
	'youtubeauthsub_uploadbutton' => 'Ngarko',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}. [http://www.youtube.com/watch?v=$1 Shiko këtë video]',
	'youtubeauthsub_summary' => 'Ngarkimi YouTube video',
	'youtubeauthsub_uploading' => 'video juaj është duke u ngarkuar së fundi. Ju lutemi keni durim.',
	'youtubeauthsub_viewpage' => 'Përndryshe, ju mund të [[$1|view video tuaj]].',
	'youtubeauthsub_jserror_nokeywords' => 'Ju lutemi shkruani 1 ose më shumë fjalë kyçe.',
	'youtubeauthsub_jserror_notitle' => 'Ju lutemi shkruani një titull për videon.',
	'youtubeauthsub_jserror_nodesc' => 'Ju lutemi shkruani një përshkrim për videon.',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'youtubeauthsub_title' => 'አርዕስት',
	'youtubeauthsub_password' => 'የYouTube መግቢያ ቃል',
	'youtubeauthsub_category' => 'መደብ',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'youtubeauthsub_description' => 'Descripción',
	'youtubeauthsub_submit' => 'Ninviar',
);

/** Old English (Ænglisc)
 * @author Wōdenhelm
 */
$messages['ang'] = array(
	'youtubeauthsub' => 'YouTube scēaƿe forþsendan',
	'youtubeauthsub_title' => 'Nama',
	'youtubeauthsub_description' => 'Mearcung',
	'youtubeauthsub_password' => 'YouTube þafungƿord',
	'youtubeauthsub_username' => 'YouTube brūcendnama',
	'youtubeauthsub_keywords' => 'Cǣȝƿord',
	'youtubeauthsub_category' => 'Flocc',
	'youtubeauthsub_submit' => 'Forþsendan',
	'youtubeauthsub_clickhere' => 'Hēr cnæppan to inmeldienne to YouTube',
	'youtubeauthsub_tokenerror' => 'Ƿōh scieppende þafunge tācn, fande nīƿian.',
	'youtubeauthsub_authsubinstructions' => 'To forþsendenne scēaƿe, þū scealt formest to YouTube inmeldian.',
	'youtubeauthsub_uploadhere' => 'Þīnu scēaƿe forþsendan fram hēr:',
	'youtubeauthsub_uploadbutton' => 'Forþsendan',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Þās scēaƿe sēon]',
	'youtubeauthsub_summary' => 'Forþsendende YouTube scēaƿe',
	'youtubeauthsub_uploading' => 'Þīnu scēaƿe forþsendþ.
Bidde þole.',
	'youtubeauthsub_viewpage' => 'Bȳ ōðrum ȝescēadum, þū meaht [[$1|þīne scēaƿe sēon]].',
	'youtubeauthsub_jserror_nokeywords' => 'Bidde ƿrīt 1 oþþe mā cǣȝƿord.',
	'youtubeauthsub_jserror_notitle' => 'Bidde ƿrīt nama for þǣre scēaƿe.',
	'youtubeauthsub_jserror_nodesc' => 'Bidde ƿrīt mearcunge for þǣre scēaƿe.',
);

/** Angika (अङ्गिका)
 * @author Angpradesh
 */
$messages['anp'] = array(
	'youtubeauthsub' => 'यूट्यूब व्हीडियो अपलोड करॊ',
	'youtubeauthsub-desc' => 'सदस्य सीनी कॆ [[Special:YouTubeAuthSub|व्हीडियो अपलोड]] यूट्यूब पर सोझे अनुमति',
	'youtubeauthsub_info' => 'यूट्यूब पर वीडियो अपलोड करी कॆ पन्ना पर जोरै लेली, निम्नांकित जानकारी भरॊ :',
	'youtubeauthsub_title' => ')शीर्षक',
	'youtubeauthsub_description' => ')ज़ानकारी',
	'youtubeauthsub_password' => 'यूट्यूब पासवर्ड',
	'youtubeauthsub_keywords' => 'शोधशब्द',
	'youtubeauthsub_category' => 'श्रेणी',
	'youtubeauthsub_submit' => 'भेजॊ',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'youtubeauthsub' => 'رفع فيديو يوتيوب',
	'youtubeauthsub-desc' => 'يسمح للمستخدمين [[Special:YouTubeAuthSub|برفع الفيديو]] مباشرة إلى يوتيوب',
	'youtubeauthsub_info' => 'لرفع فيديو إلى يوتيوب لتضمينه في صفحة، املأ المعلومات التالية:',
	'youtubeauthsub_title' => 'عنوان',
	'youtubeauthsub_description' => 'وصف',
	'youtubeauthsub_password' => 'كلمة سر يوتيوب',
	'youtubeauthsub_username' => 'اسم مستخدم يوتيوب',
	'youtubeauthsub_keywords' => 'كلمات مفتاحية',
	'youtubeauthsub_category' => 'تصنيف',
	'youtubeauthsub_submit' => 'أرسل',
	'youtubeauthsub_clickhere' => 'أنقر هنا لتسجيل الدخول لليوتيوب',
	'youtubeauthsub_tokenerror' => 'خطأ توليد توكين السماح، حاول التحديث.',
	'youtubeauthsub_success' => "تهانينا!
الفيديو الخاص بك تم رفعه.
<a href='http://www.youtube.com/watch?v=$1'>عرض الفيديو الخاص بك</a>.
يوتيوب ربما يحتاج إلى بعض الوقت لمعالجة الفيديو الخاص بك، لذا ربما لا يكون جاهزا بعد.

لتضمين الفيديو الخاص بك في صفحة على الويكي، أدخل الشيفرة التالي في صفحة:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'لرفع فيديو، سيتعين عليك تسجيل الدخول أولا إلى يوتيوب.',
	'youtubeauthsub_uploadhere' => 'رفع مقاطع الفيديو الخاصة بك من هنا:',
	'youtubeauthsub_uploadbutton' => 'ارفع',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 عرض هذا الفيديو]',
	'youtubeauthsub_summary' => 'رفع فيديو يوتيوب',
	'youtubeauthsub_uploading' => 'الفيديو الخاص بك يتم رفعه.
من فضلك كن صبورا.',
	'youtubeauthsub_viewpage' => 'كخيار آخر، يمكنك [[$1|رؤية الفيديو الخاص بك]].',
	'youtubeauthsub_jserror_nokeywords' => 'رجاءً أدخل كلمة مفتاحية أو أكثر.',
	'youtubeauthsub_jserror_notitle' => 'رجاءً أدخل عنوانا للفيديو.',
	'youtubeauthsub_jserror_nodesc' => 'رجاءً أدخل وصفا للفيديو.',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'youtubeauthsub_category' => 'ܣܕܪܐ',
	'youtubeauthsub_uploadbutton' => 'ܐܣܩ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 */
$messages['arz'] = array(
	'youtubeauthsub' => 'تحميل فيديو يوتيوب',
	'youtubeauthsub-desc' => 'السماح لليوزرز [[Special:YouTubeAuthSub|بتحميل الفيديو]] مباشرة ليوتيوب',
	'youtubeauthsub_info' => 'لتحميل فيديو على يوتيوب لتضمينه فى صفحة، املا المعلومات دى:',
	'youtubeauthsub_title' => 'عنوان',
	'youtubeauthsub_description' => 'وصف',
	'youtubeauthsub_password' => 'كلمة سر يوتيوب',
	'youtubeauthsub_username' => 'اسم يوزر يوتيوب',
	'youtubeauthsub_keywords' => 'كلمات مفتاحية',
	'youtubeauthsub_category' => 'تصنيف',
	'youtubeauthsub_submit' => 'تنفيذ',
	'youtubeauthsub_clickhere' => 'أنقر هنا لتسجيل الدخول لليوتيوب',
	'youtubeauthsub_tokenerror' => 'خطأ توليد توكين السماح، حاول التحديث.',
	'youtubeauthsub_success' => "تهانينا!
الفيديو بتاعك اتحمل.
لرؤية الفيديو بتاعك اضغط <a href='http://www.youtube.com/watch?v=$1'>هنا</a>.
يوتيوب ربما يحتاج لبعض الوقت لمعالجة الفيديو بتاعك،  ربما لا يكون جاهزا بعد.

لتضمين الفيديو بتاعك  فى صفحة على الويكى، حط  الكود التالى فى صفحة:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'لرفع فيديو، سيتعين عليك تسجيل الدخول أولا إلى يوتيوب.',
	'youtubeauthsub_uploadhere' => 'رفع مقاطع الفيديو الخاصة بك من هنا:',
	'youtubeauthsub_uploadbutton' => 'رفع',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

الفيديو ده ممكن تشوفه [http://www.youtube.com/watch?v=$1 هنا]',
	'youtubeauthsub_summary' => 'رفع فيديو يوتيوب',
	'youtubeauthsub_uploading' => 'الفيديو الخاص بك يتم رفعه.
من فضلك كن صبورا.',
	'youtubeauthsub_viewpage' => 'كاختيار تانى، ممكن تشوف الفيديو بتاعك [[$1|هنا]].',
	'youtubeauthsub_jserror_nokeywords' => 'رجاءً أدخل كلمة مفتاحية أو أكثر.',
	'youtubeauthsub_jserror_notitle' => 'رجاءً أدخل عنوانا للفيديو.',
	'youtubeauthsub_jserror_nodesc' => 'رجاءً أدخل وصفا للفيديو.',
);

/** Assamese (অসমীয়া)
 * @author Chaipau
 */
$messages['as'] = array(
	'youtubeauthsub_category' => 'শ্ৰেণী',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'youtubeauthsub_title' => 'Başlıq',
	'youtubeauthsub_keywords' => 'Açar sözlər',
	'youtubeauthsub_category' => 'Kateqoriya',
	'youtubeauthsub_submit' => 'Təsdiq et',
	'youtubeauthsub_uploadbutton' => 'Yüklə',
);

/** Bashkir (Башҡортса)
 * @author Comp1089
 * @author Haqmar
 */
$messages['ba'] = array(
	'youtubeauthsub_title' => 'Исем',
	'youtubeauthsub_description' => 'Тасуирлама',
	'youtubeauthsub_password' => 'YouTube паролегеҙ',
	'youtubeauthsub_username' => 'YouTube ҡулланыусы исеме',
);

/** Bavarian (Boarisch)
 * @author Mucalexx
 */
$messages['bar'] = array(
	'youtubeauthsub' => 'YouTube-Video auffeloon',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'youtubeauthsub' => 'آپلود کن ویدیو یوتیوبء',
	'youtubeauthsub_title' => 'عنوان',
	'youtubeauthsub_description' => 'توضیح',
	'youtubeauthsub_keywords' => 'کلیدی کلمات',
	'youtubeauthsub_category' => 'دسته',
	'youtubeauthsub_submit' => 'دیم دی',
	'youtubeauthsub_uploadbutton' => 'آپلود',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'youtubeauthsub' => 'Загрузка відэафайла YouTube',
	'youtubeauthsub-desc' => 'Дазваляе ўдзельнікам [[Special:YouTubeAuthSub|загружаць відэа]] непасрэдна на YouTube',
	'youtubeauthsub_info' => 'Каб загрузіць відэа на YouTube і дадаць яго на старонку, падайце наступную інфармацыю:',
	'youtubeauthsub_title' => 'Назва',
	'youtubeauthsub_description' => 'Апісаньне',
	'youtubeauthsub_password' => 'Пароль у YouTube',
	'youtubeauthsub_username' => 'Імя ўдзельніка ў YouTube',
	'youtubeauthsub_keywords' => 'Ключавыя словы',
	'youtubeauthsub_category' => 'Катэгорыя',
	'youtubeauthsub_submit' => 'Даслаць',
	'youtubeauthsub_clickhere' => 'Націсьніце тут, каб увайсьці ў YouTube',
	'youtubeauthsub_tokenerror' => 'Памылка стварэньня токэна аўтарызацыі, паспрабуйце абнавіць старонку.',
	'youtubeauthsub_success' => "Віншуем!
Ваша відэа загружана.
<a href='http://www.youtube.com/watch?v=$1'>Націсьніце тут, каб праглядзець загружанае відэа</a>.
YouTube можа патрабавацца пэўны час, каб апрацаваць Вашае відэа, таму яшчэ яно можа быць недасяжным.

Каб дадаць Вашае відэа на вікі-старонку, устаўце на старонку наступны код:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Каб загрузіць відэа, Вам неабходна спачатку ўвайсьці ў YouTube.',
	'youtubeauthsub_uploadhere' => 'Загрузіць Ваша відэа адсюль:',
	'youtubeauthsub_uploadbutton' => 'Загрузіць',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Праглядзець гэтае відэа]',
	'youtubeauthsub_summary' => 'Загрузка відэа YouTube',
	'youtubeauthsub_uploading' => 'Ваша відэа загружаецца.
Калі ласка, пачакайце.',
	'youtubeauthsub_viewpage' => 'Таксама, Вы можаце [[$1|паглядзець Вашае відэа]].',
	'youtubeauthsub_jserror_nokeywords' => 'Калі ласка, увядзіце адно ці некалькі ключавых словаў.',
	'youtubeauthsub_jserror_notitle' => 'Калі ласка, увядзіце назву відэа.',
	'youtubeauthsub_jserror_nodesc' => 'Калі ласка, увядзіце апісаньне відэа.',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Spiritia
 * @author Stanqo
 */
$messages['bg'] = array(
	'youtubeauthsub' => 'Качване на видео в YouTube',
	'youtubeauthsub-desc' => 'Позволява на потребителите да [[Special:YouTubeAuthSub|качват видеоматериали]] диретно в YouTube',
	'youtubeauthsub_info' => 'За качване на видео в YouTube, което да бъде включено в страница, е необходимо попълване на следната информация:',
	'youtubeauthsub_title' => 'Заглавие',
	'youtubeauthsub_description' => 'Описание',
	'youtubeauthsub_password' => 'Парола в YouTube',
	'youtubeauthsub_username' => 'Потребителско име в YouTube',
	'youtubeauthsub_keywords' => 'Ключови думи',
	'youtubeauthsub_category' => 'Категория',
	'youtubeauthsub_submit' => 'Изпращане',
	'youtubeauthsub_clickhere' => 'Щракнете тук за влизане в YouTube',
	'youtubeauthsub_tokenerror' => 'Грешка при генериране на оторизиращата информация, опитайте да опресните.',
	'youtubeauthsub_success' => "Поздравления!
Видеото беше качено.
Можете да прегледате видеото <a href='http://www.youtube.com/watch?v=$1'>тук</a>.
Възможно е YouTube да имат нужда от известно време за обработка на видеото, затова е възможно то все още да е недостъпно.

За включване на видеото в страница от уикито е необходимо да се вмъкне следният код в страницата:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'За качване на видео е необходимо влизане в YouTube.',
	'youtubeauthsub_uploadhere' => 'Качване на видео оттук:',
	'youtubeauthsub_uploadbutton' => 'Качване',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Преглеждане на каченото видео]',
	'youtubeauthsub_summary' => 'Качване на видео в YouTube',
	'youtubeauthsub_uploading' => 'Вашето видео е в процес на качване.
Молим за търпение.',
	'youtubeauthsub_viewpage' => 'Алтернативно, можете да [[$1|видите вашето видео]].',
	'youtubeauthsub_jserror_nokeywords' => 'Необходимо е да се въведе една или повече ключови думи.',
	'youtubeauthsub_jserror_notitle' => 'Необходимо е да се въведе заглавие на видеото.',
	'youtubeauthsub_jserror_nodesc' => 'Необходимо е да се въведе описание на видеото.',
);

/** Banjar (Bahasa Banjar)
 * @author Ezagren
 */
$messages['bjn'] = array(
	'youtubeauthsub_submit' => 'Kirim',
	'youtubeauthsub_clickhere' => 'Klik di sia gasan masuk log ka YouTube',
	'youtubeauthsub_uploadbutton' => 'Unggah',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Ehsanulhb
 * @author Prometheus.pyrphoros
 */
$messages['bn'] = array(
	'youtubeauthsub' => 'ইউটিউব ভিডিও আপলোড',
	'youtubeauthsub-desc' => 'ব্যবহারকারীকে সরাসরি ইউটিউবে [[Special:YouTubeAuthSub|ভিডিও আপলোড]] করার অনুমতি দেয়',
	'youtubeauthsub_info' => 'পাতায় যোগের জন্য কোন ভিডিও ইউটিউবে আপলোড করতে চাইলে, এই তথ্যগুলো প্রদান করুন:',
	'youtubeauthsub_title' => 'শিরোনাম',
	'youtubeauthsub_description' => 'বিবরণ',
	'youtubeauthsub_password' => 'ইউটিউব শব্দচাবি',
	'youtubeauthsub_username' => 'ইউটিউব ব্যবহারকারী নাম',
	'youtubeauthsub_keywords' => 'মূলশব্দ',
	'youtubeauthsub_category' => 'বিষয়শ্রেণী',
	'youtubeauthsub_submit' => 'জমা দাও',
	'youtubeauthsub_clickhere' => 'ইউটিউবে লগইন করার জন্য এখানে ক্লিক করুন',
	'youtubeauthsub_tokenerror' => 'অথরাইজেশন টোকেন তৈরিতে ত্রুটি দেখাচ্ছে, রিফ্রেস করুন।',
	'youtubeauthsub_success' => "অভিনন্দন!
আপনার ভিডিও আপলোড হয়েছে।
<a href='http://www.youtube.com/watch?v=$1'>আপনার ভিডিওটি দেখুন</a>।
ইউটিউবে ভিডিওটির প্রক্রিয়াকরণে সামান্য সময় লাগতে পারে, তাই এখনই হয়তো ভিডিওটি প্রস্তুত নয়।

আপনার ভিডিওটি উইকির কোন পাতায় অন্তর্ভুক্ত করতে এই কোডটি কোন পাতায় যোগ করুন:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'কোন ভিডিও আপলোড করার জন্য, অবশ্যই প্রথমে ইউটিউবে প্রবেশ করা প্রয়োজন।',
	'youtubeauthsub_uploadhere' => 'এখান থেকে আপনার ভিডিও আপলোড করুন:',
	'youtubeauthsub_uploadbutton' => 'আপলোড',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 এই ভিডিও দেখাও]',
	'youtubeauthsub_summary' => 'ইউটিউব ভিডিও আপলোড',
	'youtubeauthsub_uploading' => 'আপনার ভিডিওটি আপলোড করা হচ্ছে।
অনুগ্রহ করে অপেক্ষা করুন।',
	'youtubeauthsub_viewpage' => 'বিকল্প পন্থায়, আপনি [[$1|আপনার ভিডিও দেখতে পারেন]]।',
	'youtubeauthsub_jserror_nokeywords' => 'অনুগ্রহ করে এক বা একাধিক মূলশব্দ টাইপ করুন',
	'youtubeauthsub_jserror_notitle' => 'অনুগ্রহ করে ভিডিও এর শিরোনাম দিন।',
	'youtubeauthsub_jserror_nodesc' => 'অনুগ্রহ করে ভিডিও এর বর্ণনা দিন।',
);

/** Tibetan (བོད་ཡིག)
 * @author Freeyak
 */
$messages['bo'] = array(
	'youtubeauthsub' => 'ཡུ་ཁྲུབ་གློག་བརྙན་ཡར་འཇུག',
	'youtubeauthsub_title' => 'ཁ་བྱང་།',
	'youtubeauthsub_description' => 'འགྲེལ་བཤད།',
	'youtubeauthsub_password' => 'ཡུ་ཁྲུབ་ལམ་ཡིག',
	'youtubeauthsub_username' => 'ཡུ་ཁྲུབ་བཀོལ་མིང་།',
	'youtubeauthsub_category' => 'དཀར་ཆག',
	'youtubeauthsub_uploadbutton' => 'ཡར་འཇོག',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'youtubeauthsub' => 'Enporzhiañ ur video YouTube',
	'youtubeauthsub-desc' => 'Aotren a ra an implijerien da [[Special:YouTubeAuthSub|enporzhiañ videoioù]] war-eeun war YouTube',
	'youtubeauthsub_info' => 'Evit enporzhiañ ur video war YouTube a-benn e lakaat war ur bajenn, merkit an titouroù da-heul :',
	'youtubeauthsub_title' => 'Titl',
	'youtubeauthsub_description' => 'Deskrivadur',
	'youtubeauthsub_password' => 'Ger-tremen YouTube',
	'youtubeauthsub_username' => 'Anv implijer YouTube',
	'youtubeauthsub_keywords' => "Gerioù alc'hwez",
	'youtubeauthsub_category' => 'Rummad',
	'youtubeauthsub_submit' => 'Kas',
	'youtubeauthsub_clickhere' => 'Klikañ amañ evit kevreañ ouzh YouTube',
	'youtubeauthsub_tokenerror' => 'Fazi e-ser krouiñ an aotre, klaskit freskaat ar bajenn.',
	'youtubeauthsub_success' => "Gourc'hemennoù!
Enporzhiet eo bet ho video.
<a href='http://www.youtube.com/watch?v=$1'>Sellet ouzh ho video</a>.
Un tamm amzer en deus ezhomm YouTube evit kargañ ho video, setu marteze n'eo ket prest diouzhtu c'hoazh.

Evit enframmañ ho video en ur bajenn eus ar wiki, lakait enni ar c'hod da-heul :
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => "A-raok enporzhiañ ur video e vo ret deoc'h kevreañ ouzh YouTube.",
	'youtubeauthsub_uploadhere' => 'Enporzhiit ho video eus amañ :',
	'youtubeauthsub_uploadbutton' => 'Enporzhiañ',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Sellet ouzh ar video-mañ]',
	'youtubeauthsub_summary' => 'Enporzhiañ ur video YouTube',
	'youtubeauthsub_uploading' => 'Emeur o kargañ ho video. 
Un tamm pasianted mar plij.',
	'youtubeauthsub_viewpage' => "A-hend-all e c'hallit [[$1|sellet ouzh ho video]].",
	'youtubeauthsub_jserror_nokeywords' => 'Lakait ur ger-tremen pe meur a hini.',
	'youtubeauthsub_jserror_notitle' => 'Lakait un titl evit ar video mar plij',
	'youtubeauthsub_jserror_nodesc' => 'Lakait un deskrivadur evit ar video mar plij',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'youtubeauthsub' => 'Postavi video na YouTube',
	'youtubeauthsub-desc' => 'Omogućava korisnicima da [[Special:YouTubeAuthSub|postavljaju video snimke]] direktno na YouTube',
	'youtubeauthsub_info' => 'Da bi ste postavili video na YouTube i uključili ga na stranicu, popunite slijedeće informacije:',
	'youtubeauthsub_title' => 'Naslov',
	'youtubeauthsub_description' => 'Opis',
	'youtubeauthsub_password' => 'Šifra za YouTube',
	'youtubeauthsub_username' => 'Korisničko ime na YouTube',
	'youtubeauthsub_keywords' => 'Ključne riječi',
	'youtubeauthsub_category' => 'Kategorija',
	'youtubeauthsub_submit' => 'Pošalji',
	'youtubeauthsub_clickhere' => 'Kliknite ovdje za prijavu na YouTube',
	'youtubeauthsub_tokenerror' => 'Greška pri generisanju tokena autorizacije, pokušajte osvježiti.',
	'youtubeauthsub_success' => "Čestitamo!
Vaš video je postavljen.
<a href='http://www.youtube.com/watch?v=$1'>Pogledate Vaš video</a>.
Stranica YouTube možda treba malo vremena da procesira Vaš video, tako da možda još nije spreman.

Da bi ste uključili Vaš video na neku wiki stranicu, ubacite slijedeći kod na stanicu:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Da bi ste postavili video, bit će te primorani da se prvo prijavite na YouTube.',
	'youtubeauthsub_uploadhere' => 'Postavite Vaš video odavde:',
	'youtubeauthsub_uploadbutton' => 'Postavi',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Pogledajte ovaj video]',
	'youtubeauthsub_summary' => 'Postavljanje YouTube videa',
	'youtubeauthsub_uploading' => 'Vaš video se postavlja.
Molimo budite strpljivi.',
	'youtubeauthsub_viewpage' => 'Također, možete [[$1|pogledati Vaš video]].',
	'youtubeauthsub_jserror_nokeywords' => 'Molimo Vas unesite 1 ili više ključnih riječi.',
	'youtubeauthsub_jserror_notitle' => 'Molimo unesite naslov za video.',
	'youtubeauthsub_jserror_nodesc' => 'Molimo Vas unesite opis za video.',
);

/** Catalan (Català)
 * @author Aleator
 * @author Jordi Roqué
 * @author Paucabot
 * @author SMP
 * @author Solde
 */
$messages['ca'] = array(
	'youtubeauthsub' => 'Carregueu vídeo de YouTube',
	'youtubeauthsub-desc' => 'Permet els usuaris de [[Special:YouTubeAuthSub|carregar vídeos]] directament a YouTube',
	'youtubeauthsub_info' => "Per carregar un vídeo a YouTube a fi d'incloure'l en una pàgina, completeu la informació següent:",
	'youtubeauthsub_title' => 'Títol',
	'youtubeauthsub_description' => 'Descripció',
	'youtubeauthsub_password' => 'Contrasenya de YouTube',
	'youtubeauthsub_username' => "Nom d'usuari de YouTube",
	'youtubeauthsub_keywords' => 'Descriptors',
	'youtubeauthsub_category' => 'Categoria',
	'youtubeauthsub_submit' => 'Trametre',
	'youtubeauthsub_clickhere' => 'Fes clic aquí per a connectar-te al YouTube',
	'youtubeauthsub_tokenerror' => "Error en generar la demanda d'autorització, provi de recarregar la pàgina.",
	'youtubeauthsub_success' => "Enhorabona!
El vostre video s'ha carregat.
<a href='http://www.youtube.com/watch?v=$1'>Vegeu el vostre vídeo</a>.
YouTube pot necessitar algun temps per a processar el vostre vídeo, per la qual cosa pot ser que encara no estigui a punt.

Per incloure el vostre vídeo en una pàgina wiki, afegiu el següent codi en la pàgina:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Per carregar un vídeo, primer us haureu de registrar a YouTube',
	'youtubeauthsub_uploadhere' => "Carregueu el vostre vídeo des d'aquí:",
	'youtubeauthsub_uploadbutton' => 'Carrega',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Veure aquest vídeo]',
	'youtubeauthsub_summary' => "S'està carregant el vídeo de YouTube",
	'youtubeauthsub_uploading' => "El teu vídeo s'està carregant.
Si us plau, tingues paciència.",
	'youtubeauthsub_viewpage' => 'Alternativament, podeu [[$1|veure el vostre vídeo]].',
	'youtubeauthsub_jserror_nokeywords' => 'Si us plau, introdueixi 1 o més paraules.',
	'youtubeauthsub_jserror_notitle' => 'Si us plau, introdueixi un títol pel vídeo.',
	'youtubeauthsub_jserror_nodesc' => 'Si us plau, introdueixi una descripció per al vídeo.',
);

/** Sorani (کوردی)
 * @author Asoxor
 * @author Marmzok
 */
$messages['ckb'] = array(
	'youtubeauthsub' => 'بارکردنی ڤیدیۆ لە یووتیوب',
	'youtubeauthsub_info' => 'بۆ بارکردنی ڤیدیۆیەک بۆ سەر یووتیوب کە لە لاپەرەیەکدا پیشان بدرێت، ئەو زانیاریانەی خوارەوە پڕ کەوە:',
	'youtubeauthsub_title' => 'سەردێڕ',
	'youtubeauthsub_description' => 'وەسف',
	'youtubeauthsub_password' => 'وشەی‌نهێنی یووتیوب',
	'youtubeauthsub_username' => 'ناوی بەکارهێنەری یووتیوب',
	'youtubeauthsub_keywords' => 'گرنگ‌وشەکان',
	'youtubeauthsub_category' => 'هاوپۆلەکان',
	'youtubeauthsub_submit' => 'ناردن',
	'youtubeauthsub_clickhere' => 'ئێرە کرتە بکە بۆ چوونەژوورەوەی یووتیوب',
	'youtubeauthsub_success' => "پیرۆزبایی !
ڤیدیۆکەت بارکرا.
<a href='http://www.youtube.com/watch?v=$1'>ڤیدیۆکەت ببینە</a>.
لەوانەیە یووتیوب هێندێ کاتی پێویست بێت بۆ هەڵسەنگاندنی ڤیدیۆکەت، لەبەر ئەوە، لەوانەی هێشتا ڤیدیۆکەت ئامادە نەبێت.

بۆ ئەوەی ئەم ڤیدیۆیە لە لاپەڕەیەک لە ویکی‌دا دابنێی، ئەم دەقە لەو لاپەڕەدا دابنێ:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'بۆ بارکردنی ڤیدیۆ، پێویستە لە پێش‌دا لە یووتیوب بڕۆیتەژوورەوە.',
	'youtubeauthsub_uploadhere' => 'ڤیدیۆکەت لێراوە بار بکە:',
	'youtubeauthsub_uploadbutton' => 'بارکردن',
	'youtubeauthsub_summary' => 'بارکردنی ڤیدیۆی یووتیوب',
	'youtubeauthsub_uploading' => 'ڤیدیۆکەت بارکرا.
تکایە چاوەڕوان بە.',
	'youtubeauthsub_jserror_nokeywords' => 'تکایە یەک یا زیاتر گرنگ‌وشە بنووسە.',
	'youtubeauthsub_jserror_notitle' => 'تکایە سەردێڕێک بۆ ڤیدیۆکە بنووسە.',
	'youtubeauthsub_jserror_nodesc' => 'تکایە پێناسەیەک بۆ بۆ ڤیدیۆکە بنووسە.',
);

/** Capiznon (Capiceño)
 * @author Oxyzen
 */
$messages['cps'] = array(
	'youtubeauthsub_title' => 'Titulo',
	'youtubeauthsub_description' => 'Deskripsyon',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'youtubeauthsub' => 'Nahrát YouTube video',
	'youtubeauthsub-desc' => 'Umožňuje uživatelům [[Special:YouTubeAuthSub|nahrávat videa]] přimo na YouTube',
	'youtubeauthsub_info' => 'Abyste mohli nahrát video na YouTube pro následné použití na stránce, vyplňte následující informace:',
	'youtubeauthsub_title' => 'Název',
	'youtubeauthsub_description' => 'Popis',
	'youtubeauthsub_password' => 'YouTube heslo',
	'youtubeauthsub_username' => 'Uživatelské jméno na YouTube',
	'youtubeauthsub_keywords' => 'Klíčová slova',
	'youtubeauthsub_category' => 'Kategorie',
	'youtubeauthsub_submit' => 'Poslat',
	'youtubeauthsub_clickhere' => 'Kliknutím sem se přihlásíte na YouTube',
	'youtubeauthsub_tokenerror' => 'Chyba při vytváření autentifikačního tokenu. Zkuste obnovit stránku.',
	'youtubeauthsub_success' => "Gratulujeme!
Vaše vide je nahrané.
<a href='http://www.youtube.com/watch?v=$1'>Podívejte se na svoje video</a>.
YouTube může nějaký čas trvat, než vaše video zpracuje, takže ještě není připravené.

Video můžete na wiki stránku vložit pomocí následujícího kódu:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Abyste mohli nahrát video, musíte se nejprve přihlásit na YouTube.',
	'youtubeauthsub_uploadhere' => 'Nahrajte svoje video odtud:',
	'youtubeauthsub_uploadbutton' => 'Nahrát',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Podívejte se na svoje video].',
	'youtubeauthsub_summary' => 'Nahrává se YouTube video',
	'youtubeauthsub_uploading' => 'Vaše video se nahrává.
Buďte prosím trpěliví.',
	'youtubeauthsub_viewpage' => 'Jinak si můžete video [[$1|prohlédnout zde]].',
	'youtubeauthsub_jserror_nokeywords' => 'Prosím, zadejte jedno nebo více klíčových slov.',
	'youtubeauthsub_jserror_notitle' => 'Prosím, zadejte název videa.',
	'youtubeauthsub_jserror_nodesc' => 'Prosím, zadejte popis videa.',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'youtubeauthsub_category' => 'катигорі́ꙗ',
);

/** Welsh (Cymraeg)
 * @author Fulup
 * @author Lloffiwr
 * @author Xxglennxx
 */
$messages['cy'] = array(
	'youtubeauthsub' => 'Uwchlwytho fideo YouTube',
	'youtubeauthsub-desc' => 'Yn caniatáu i ddefnyddwyr [[Special:YouTubeAuthSub|uwchlwytho fideos]] yn syth i YouTube',
	'youtubeauthsub_info' => 'I uwchlwytho fideo i YouTube er mwyn ei gynnwys ar dudalen, rhowch y wybodaeth ganlynol:',
	'youtubeauthsub_title' => 'Teitl',
	'youtubeauthsub_description' => 'Disgrifiad',
	'youtubeauthsub_password' => 'Cyfrinair YouTube',
	'youtubeauthsub_username' => 'Enw defnyddiwr YouTube',
	'youtubeauthsub_keywords' => 'Allweddeiriau',
	'youtubeauthsub_category' => 'Categori',
	'youtubeauthsub_submit' => 'Cyflwyner',
	'youtubeauthsub_clickhere' => 'Cliciwch yma i fewngofnodi i YouTube',
	'youtubeauthsub_tokenerror' => "Gwall wrth gynhyrchu tocyn awdurdodi. Rhowch gynnig ar ail-lwytho'r dudalen.",
	'youtubeauthsub_success' => "Llongyfarchiadau!
Uwchlwythwyd eich fideo.
<a href='http://www.youtube.com/watch?v=$1'>Edrychwch arno</a>.
Efallai bod angen mwy o amser prosesu ar YouTube, ac na fydd yn barod yn syth.

I gynnwys eich fideo mewn tudalen ar y wici, gosodwch y cod yma:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'I uwchlwytho fideo, bydd angen mewngofnodi i YouTube yn gyntaf arnoch.',
	'youtubeauthsub_uploadhere' => "Uwchlwytho'ch fideo o fan hyn:",
	'youtubeauthsub_uploadbutton' => 'Uwchlwyther',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Edrych ar y fideo hwn]',
	'youtubeauthsub_summary' => 'Yn uwchlwytho fideo YouTube',
	'youtubeauthsub_uploading' => "Mae'n eich fideo wrthi'n cael ei uwchlwytho.
Arhoswch, os gwelwch yn dda.",
	'youtubeauthsub_viewpage' => 'Neu gallwch [[$1|edrych ar eich fideo]].',
	'youtubeauthsub_jserror_nokeywords' => 'Rhowch un neu ragor o allweddeiriau.',
	'youtubeauthsub_jserror_notitle' => 'Rhowch deitl ar gyfer y fideo.',
	'youtubeauthsub_jserror_nodesc' => 'Rhowch ddisgrifiad ar gyfer y fideo.',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 * @author Masz
 */
$messages['da'] = array(
	'youtubeauthsub' => 'Læg en YouTube-video op',
	'youtubeauthsub-desc' => 'Giver brugere mulighed for at [[Special:YouTubeAuthSub|lægge videoer op]] på YouTube.',
	'youtubeauthsub_info' => 'For at lægge en video op på YouTube, skal du udfylde de nedenstående informationer:',
	'youtubeauthsub_title' => 'Titel',
	'youtubeauthsub_description' => 'Beskrivelse',
	'youtubeauthsub_password' => 'YouTube-adgangskode',
	'youtubeauthsub_username' => 'YouTube-brugernavn',
	'youtubeauthsub_keywords' => 'Nøgleord',
	'youtubeauthsub_category' => 'Kategori',
	'youtubeauthsub_submit' => 'Læg op',
	'youtubeauthsub_clickhere' => 'Tryk her for at logge ind på YouTube',
	'youtubeauthsub_tokenerror' => 'Fejl under oprettelse af autorisationstoken; prøv at opdatere.',
	'youtubeauthsub_success' => "Tillykk!
Din video er blevet lagt op.
<a href='http://www.youtube.com/watch?v=$1'>Se din video</a>.
Det kan tage lidt tid før YouTube har behandlet din video, så den er måske ikke klar endnu.
For at vise din video på en side på denne wiki, skal du indsætte følgende kode:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Du skal først logge ind på YouTube, før du kan lægge videoer op.',
	'youtubeauthsub_uploadhere' => 'Læg din video op herfra:',
	'youtubeauthsub_uploadbutton' => 'Læg op',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Vis denne video]',
	'youtubeauthsub_summary' => 'Lægger YouTube-video op',
	'youtubeauthsub_uploading' => 'Din video bliver lagt op.
Vær tålmodig.',
	'youtubeauthsub_viewpage' => 'Alternativt kan du [[$1|vise din video]].',
	'youtubeauthsub_jserror_nokeywords' => 'Skriv 1 eller flere nøgleord.',
	'youtubeauthsub_jserror_notitle' => 'Vælg en titel for videoen.',
	'youtubeauthsub_jserror_nodesc' => 'Skriv en beskrivelse af videoen.',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author LWChris
 * @author Purodha
 * @author Revolus
 * @author Umherirrender
 */
$messages['de'] = array(
	'youtubeauthsub' => 'YouTube-Video hochladen',
	'youtubeauthsub-desc' => 'Ermöglicht es Benutzern, Videos direkt zu YouTube [[Special:YouTubeAuthSub|hochzuladen]]',
	'youtubeauthsub_info' => 'Um ein Video zu YouTube hochzuladen, um es anschließend auf einer Seite einzubetten, musst du folgende Felder ausfüllen:',
	'youtubeauthsub_title' => 'Titel',
	'youtubeauthsub_description' => 'Beschreibung',
	'youtubeauthsub_password' => 'YouTube-Passwort',
	'youtubeauthsub_username' => 'YouTube-Benutzername',
	'youtubeauthsub_keywords' => 'Schlüsselwörter',
	'youtubeauthsub_category' => 'Kategorie',
	'youtubeauthsub_submit' => 'Senden',
	'youtubeauthsub_clickhere' => 'Hier klicken zum Einloggen bei YouTube',
	'youtubeauthsub_tokenerror' => 'Fehler beim Erstellen eines Authorisierungstokens. Versuche die Seite neu zuladen.',
	'youtubeauthsub_success' => "Gratuliere!
Dein Video wurde hochgeladen.
<a href='http://www.youtube.com/watch?v=$1'>Sieh dir dein Video an</a>.
YouTube könnte etwas Zeit brauchen, um dein Video zu verarbeiten, sodass die Seite eventuell noch nicht bereit ist.

Um das Video auf einer Seite einzubetten, füge folgenden Text ein:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Du musst dich zuerst bei YouTube anmelden, um ein Video hochzuladen.',
	'youtubeauthsub_uploadhere' => 'Video von dort hochladen:',
	'youtubeauthsub_uploadbutton' => 'Hochladen',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Dieses Video ansehen]',
	'youtubeauthsub_summary' => 'Lade YouTube-Video hoch',
	'youtubeauthsub_uploading' => 'Dein Video wird gerade hochgeladen.
Bitte habe Geduld.',
	'youtubeauthsub_viewpage' => 'Alternativ kann du [[$1|dein Video ansehen]].',
	'youtubeauthsub_jserror_nokeywords' => 'Bitte gib ein oder mehr Schlüsselwörter an.',
	'youtubeauthsub_jserror_notitle' => 'Bitte gib einen Titel für das Video an.',
	'youtubeauthsub_jserror_nodesc' => 'Bitte gib eine Beschreibung für das Video an.',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author ChrisiPK
 * @author Imre
 * @author LWChris
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'youtubeauthsub_info' => 'Um ein Video zu YouTube hochzuladen, um es anschließend auf einer Seite einzubetten, müssen Sie folgende Felder ausfüllen:',
	'youtubeauthsub_tokenerror' => 'Fehler beim Erstellen eines Authorisierungstokens. Versuchen Sie die Seite neu zuladen.',
	'youtubeauthsub_success' => "Gratulation!
Ihr Video wurde hochgeladen.
<a href='http://www.youtube.com/watch?v=$1'>Sehen Sie sich ihr Video an</a>.
YouTube könnte etwas Zeit brauchen, um dein Video zu verarbeiten, sodass die Seite eventuell noch nicht bereit ist.

Um das Video auf einer Seite einzubetten, fügen Sie folgenden Text ein:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Sie müssen sich zuerst bei YouTube anmelden, um ein Video hochzuladen.',
	'youtubeauthsub_uploading' => 'Ihr Video wird gerade hochgeladen.
Bitte haben Sie Geduld.',
	'youtubeauthsub_viewpage' => 'Alternativ können Sie [[$1|Ihr Video ansehen]].',
	'youtubeauthsub_jserror_nokeywords' => 'Bitte geben Sie ein oder mehr Schlüsselwörter an.',
	'youtubeauthsub_jserror_notitle' => 'Bitte geben Sie einen Titel für das Video an.',
	'youtubeauthsub_jserror_nodesc' => 'Bitte geben Sie eine Beschreibung für das Video an.',
);

/** Zazaki (Zazaki)
 * @author Mirzali
 */
$messages['diq'] = array(
	'youtubeauthsub_description' => 'Tarif',
	'youtubeauthsub_category' => 'Kategoriye',
	'youtubeauthsub_uploadbutton' => 'Bar ke',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'youtubeauthsub' => 'Wideo YouTube nagraś',
	'youtubeauthsub-desc' => 'Zmóžnja wužywarjam wideo direktnje k YouTube [[Special:YouTubeAuthSub|nagraś]]',
	'youtubeauthsub_info' => 'Aby nagrał wideo k YouTube, aby zapśěgnuł jo na boku, musyš slědujuce informacije pódaś:',
	'youtubeauthsub_title' => 'Titel',
	'youtubeauthsub_description' => 'Wopisanje',
	'youtubeauthsub_password' => 'Gronidło YouTube',
	'youtubeauthsub_username' => 'Wužywarske mě YouTube',
	'youtubeauthsub_keywords' => 'Klucowe słowa',
	'youtubeauthsub_category' => 'Kategorija',
	'youtubeauthsub_submit' => 'Wótpósłaś',
	'youtubeauthsub_clickhere' => 'How kliknuś, aby se pśizjawił pla YouTube',
	'youtubeauthsub_tokenerror' => 'Zmólka pśi napóranju awtorzěrowańskego tokena. Wopyt bok hyšći raz zacytaś.',
	'youtubeauthsub_success' => "Gratulaciju!
Twójo wideo jo se nagrało.
<a href='http://www.youtube.com/watch?v=$1'>Swójo wideo se woglědaś</a>.
YouTube trjeba snaź pitśu casa, aby pśeźěłał twójo wideo, tak až snaź hyšći njejo gótowy.

Aby zapśěgnuł swójo wideo do boka we wikiju, zasajź slědujucy kod do boka:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Musyš se nejpjerwjej pźizjawił pla YouTube, aby nagrał wideo.',
	'youtubeauthsub_uploadhere' => 'Nagraj swójo wideo wót how:',
	'youtubeauthsub_uploadbutton' => 'Nagraś',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Toś to wideo se woglědaś]',
	'youtubeauthsub_summary' => 'YouTube wideo se nagrawa',
	'youtubeauthsub_uploading' => 'Twójo wideo se nagrawa.
Pšosym buź sćerpny.',
	'youtubeauthsub_viewpage' => 'Alternatiwnje móžoš se [[$1|swójo wideo woglědaś]].',
	'youtubeauthsub_jserror_nokeywords' => 'Pšosym zapódaj 1 klucow słowo abo někotare klucowe słowa.',
	'youtubeauthsub_jserror_notitle' => 'Pšosym zapódaj titel za wideo.',
	'youtubeauthsub_jserror_nodesc' => 'Pšosym zapódaj wopisanje za wideo.',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Omnipaedista
 */
$messages['el'] = array(
	'youtubeauthsub' => 'Επιφόρτωση βίντεο του YouTube',
	'youtubeauthsub-desc' => 'Επιτρέπει στους χρήστες να [[Special:YouTubeAuthSub|ανεβάσουν βίντεο]] απευθείας στο YouTube',
	'youtubeauthsub_info' => 'Για να ανεβάσετε κάποιο βίντεο στο YouTube για να περιληφθεί σε κάποια σελίδα, συμπληρώστε τις ακόλουθες πληροφορίες:',
	'youtubeauthsub_title' => 'Τίτλος',
	'youtubeauthsub_description' => 'Περιγραφή',
	'youtubeauthsub_password' => 'Κωδικός πρόσβασης στο YouTube',
	'youtubeauthsub_username' => 'Ψευδώνυμο στο YouTube',
	'youtubeauthsub_keywords' => 'Λέξεις κλειδιά',
	'youtubeauthsub_category' => 'Κατηγορία',
	'youtubeauthsub_submit' => 'Υποβολή',
	'youtubeauthsub_clickhere' => 'Πατήστε εδώ για να συνδεθείτε στο YouTube',
	'youtubeauthsub_tokenerror' => 'Σφάλμα κατά την παραγωγή ένδειξης εξουσιοδότησης. Δοκιμάστε να ανανεώσετε την σελίδα.',
	'youtubeauthsub_success' => "Συγχαρητήρια!
Το βίντεο σας είναι ανεβασμένο.
<a href='http://www.youtube.com/watch?v=$1'>Δείτε το βίντεο σας</a>.
Το YouTube μπορεί να χρειαστεί χρόνο για να συμπεριλάβει το βίντεο σας, γι' αυτό ίσως να μην ακόμη έτοιμο.

Για να συμπεριληφθεί το βίντεο σας σε μια σελίδα στο wiki, εισάγετε τον ακόλουθο κώδικα σε μια σελίδα:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Για να ανεβάσετε ένα βίντεο, θα πρέπει πρώτα να συνδεθείτε στο YouTube.',
	'youtubeauthsub_uploadhere' => 'Ανεβάστε το βίντεο σας από εδώ:',
	'youtubeauthsub_uploadbutton' => 'Επιφόρτωση',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Προβολή του βίντεο]',
	'youtubeauthsub_summary' => 'Επιφόρτωση βίντεο του YouTube',
	'youtubeauthsub_uploading' => 'Το βίντεό σας ανεβαίνει.
Παρακαλούμε κάνετε υπομονή.',
	'youtubeauthsub_viewpage' => 'Διαφορετικά, μπορείτε να [[$1|δείτε το βίντεο σας]].',
	'youtubeauthsub_jserror_nokeywords' => 'Παρακαλούμε εισάγεται 1 ή περισσότερες λέξεις κλειδιά.',
	'youtubeauthsub_jserror_notitle' => 'Παρακαλώ εισάγετε έναν τίτλο για το βίντεο.',
	'youtubeauthsub_jserror_nodesc' => 'Παρακαλούμε εισάγετε μια περιγραφή για το βίντεο.',
);

/** British English (British English)
 * @author Reedy
 */
$messages['en-gb'] = array(
	'youtubeauthsub_tokenerror' => 'Error generating authorisation token, try refreshing.',
);

/** Esperanto (Esperanto)
 * @author Michawiki
 * @author Yekrats
 */
$messages['eo'] = array(
	'youtubeauthsub' => 'Alŝuti YouTube Videon',
	'youtubeauthsub-desc' => 'Permesas al uzantoj [[Special:YouTubeAuthSub|alŝuti videojn]] rekte al YouTube',
	'youtubeauthsub_info' => 'Por alŝuti videon al YouTube inkluzivi en paĝo, plenumi la jenan informon:',
	'youtubeauthsub_title' => 'Titolo',
	'youtubeauthsub_description' => 'Priskribo',
	'youtubeauthsub_password' => 'YouTube Pasvorto',
	'youtubeauthsub_username' => 'YouTube Salutnomo',
	'youtubeauthsub_keywords' => 'Ŝlosilvortoj',
	'youtubeauthsub_category' => 'Kategorio',
	'youtubeauthsub_submit' => 'Ek',
	'youtubeauthsub_clickhere' => 'Klaku ĉi tien por ensaluti YouTube-on',
	'youtubeauthsub_tokenerror' => 'Eraro dum generado de aŭtentokontrola ĵetono; bonvolu refreŝigi.',
	'youtubeauthsub_success' => "Gratulon! 
Via video estas alŝutita.
<a href='http://www.youtube.com/watch?v=$1'>Spekti vian videon</a>.
YouTube povas bezoni iom da tempo procezi vian videon, do eble ĝi ne pretas ĵus nun.

Por inkluzivi vian videon en paĝo en la vikio, enmeti la jenan kodon en paĝon: 
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Por alŝuti videon, vi estos devigita ensaluti retejon YouTube.',
	'youtubeauthsub_uploadhere' => 'Alŝuti vian videon de ĉi tie:',
	'youtubeauthsub_uploadbutton' => 'Alŝuti',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Vidi ĉi tiun videon]',
	'youtubeauthsub_summary' => 'Alŝutante YouTube videon',
	'youtubeauthsub_uploading' => 'Via video estas alŝutanta.
Bonvolu pacienciĝi.',
	'youtubeauthsub_viewpage' => 'Alternative, vi povas [[$1|spekti vian videon]].',
	'youtubeauthsub_jserror_nokeywords' => 'Bonvolu enigi 1 aŭ pluraj ŝlosilvortoj',
	'youtubeauthsub_jserror_notitle' => 'Bonvolu eniri titolon por la video.',
	'youtubeauthsub_jserror_nodesc' => 'Bonvolu eniri priskribon por la video.',
);

/** Spanish (Español)
 * @author Sanbec
 */
$messages['es'] = array(
	'youtubeauthsub' => 'Subir un video a YouTube',
	'youtubeauthsub-desc' => 'Permite a los usuarios [[Special:YouTubeAuthSub|subir vídeos]] directamente a YouTube',
	'youtubeauthsub_info' => 'Para subir un vídeo a YouTube e incluirlo en una página, rellena la siguiente información:',
	'youtubeauthsub_title' => 'Título',
	'youtubeauthsub_description' => 'Descripción',
	'youtubeauthsub_password' => 'Contraseña en YouTube',
	'youtubeauthsub_username' => 'Usuario en YouTube',
	'youtubeauthsub_keywords' => 'Palabras clave',
	'youtubeauthsub_category' => 'Categoría',
	'youtubeauthsub_submit' => 'Enviar',
	'youtubeauthsub_clickhere' => 'Pulsa aquí para iniciar sesión en YouTube',
	'youtubeauthsub_tokenerror' => 'Error al generar la demanda de autorización, intenta recargar la página.',
	'youtubeauthsub_success' => "¡Enhorabuena!
Has subido tu vídeo.
Ya puedes <a href='http://www.youtube.com/watch?v=$1'>ver tu vídeo</a>.
YouTube puede necesitar algún tiempo para procesar tu vídeo, por lo que puede que aún no esté listo.

Para poner tu vídeo en una página de la wiki, añade el siguiente código:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Para subir un vídeo, tendrás que iniciar sesión previamente en YouTube.',
	'youtubeauthsub_uploadhere' => 'Subir tu vídeo desde aquí:',
	'youtubeauthsub_uploadbutton' => 'Subir',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Ver este vídeo]',
	'youtubeauthsub_summary' => 'Subiendo vídeo a YouTube',
	'youtubeauthsub_uploading' => 'Tu vídeo se está subiendo.
Por favor, sé paciente.',
	'youtubeauthsub_viewpage' => 'Alternativamente, puedes [[$1|ver tu vídeo aquí]].',
	'youtubeauthsub_jserror_nokeywords' => 'Por favor, introduce una o más palabras clave.',
	'youtubeauthsub_jserror_notitle' => 'Por favor, pon un título para el vídeo.',
	'youtubeauthsub_jserror_nodesc' => 'Por favor, pon una descripción para el vídeo.',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Hendrik
 * @author KalmerE.
 */
$messages['et'] = array(
	'youtubeauthsub' => "Lae üles YouTube'i video",
	'youtubeauthsub_title' => 'Pealkiri',
	'youtubeauthsub_description' => 'Kirjeldus',
	'youtubeauthsub_password' => 'YouTube salasõna',
	'youtubeauthsub_username' => 'YouTube kasutajanimi',
	'youtubeauthsub_keywords' => 'Võtmesõnad',
	'youtubeauthsub_category' => 'Kategooria',
	'youtubeauthsub_submit' => 'Saada',
	'youtubeauthsub_clickhere' => "Kliki siia, et YouTube'i sisse logida",
	'youtubeauthsub_authsubinstructions' => "Enne video üleslaadimist on vajalik YouTube'i sisselogimine.",
	'youtubeauthsub_uploadhere' => 'Lae oma video üles siit:',
	'youtubeauthsub_uploadbutton' => 'Lae üles',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Vaata seda videot]',
	'youtubeauthsub_summary' => "YouTube'i video üleslaadimine",
	'youtubeauthsub_uploading' => 'Sinu videot laetakse üles.
Ole kannatlik.',
	'youtubeauthsub_viewpage' => 'Võid [[$1|videot vaadata ka siit]].',
	'youtubeauthsub_jserror_nokeywords' => 'Palun sisesta 1 või rohkem võtmesõnu.',
	'youtubeauthsub_jserror_notitle' => 'Palun sisesta videole pealkiri.',
	'youtubeauthsub_jserror_nodesc' => 'Palun sisesta videole kirjeldus.',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Theklan
 */
$messages['eu'] = array(
	'youtubeauthsub' => 'YouTube bideoa igo',
	'youtubeauthsub-desc' => 'Zuzenean YouTubera [[Special:YouTubeAuthSub|bideoak igotzea]] baimentzen du',
	'youtubeauthsub_info' => 'YouTubeko orri batera bideoa igotzeko, bete ondorengo informazioa:',
	'youtubeauthsub_title' => 'Izenburua',
	'youtubeauthsub_description' => 'Deskribapena',
	'youtubeauthsub_password' => 'YouTube pasahitza',
	'youtubeauthsub_username' => 'YouYube erabiltzaile izena',
	'youtubeauthsub_keywords' => 'Hitz gakoak',
	'youtubeauthsub_category' => 'Kategoria',
	'youtubeauthsub_submit' => 'Bidali',
	'youtubeauthsub_clickhere' => 'Klik egin hemen YouTuben sartzeko',
	'youtubeauthsub_tokenerror' => 'Akatsa egon da autorizazio gakoa sortzen, saia zaitez orrialdea berritzen.',
	'youtubeauthsub_success' => "Zorionak!
Zure bideoa igo da.

<a href='http://www.youtube.com/watch?v=$1'>Zure bideoa ikusi</a>.
YouTubek denbora beharko du zure bideoa prozesatzen, beraz agian ez dago justu hortze prest.

Zure bideoa wiki orrialde batean txertatzeko sartu hurrengo kodea orrialde batean:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Bideo bat igotzeko lehenengo YouTuben izena eman beharko duzu.',
	'youtubeauthsub_uploadhere' => 'Igo zure bideoa hemendik:',
	'youtubeauthsub_uploadbutton' => 'Igo',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Ikus ezazu bideo hau]',
	'youtubeauthsub_summary' => 'YouTibe bideoa igotzen',
	'youtubeauthsub_uploading' => 'Zure bideoa igotzen ari da.
Izan pazientzia, arren.',
	'youtubeauthsub_viewpage' => 'Bestela, [[$1|zure bideoa ikus]] dezakezu.',
	'youtubeauthsub_jserror_nokeywords' => 'Sar itzazu mesedez hitz gako 1 edo gehiago.',
	'youtubeauthsub_jserror_notitle' => 'Sar ezazu mesedez izenburu bat bideoarentzat.',
	'youtubeauthsub_jserror_nodesc' => 'Sar ezazu mesedez deskripzio bat bideoarentzat.',
);

/** Persian (فارسی)
 * @author BlueDevil
 * @author Ebraminio
 * @author Huji
 * @author Mardetanha
 */
$messages['fa'] = array(
	'youtubeauthsub' => 'بارگذاری ویدیوی یوتوب',
	'youtubeauthsub_title' => 'عنوان',
	'youtubeauthsub_description' => 'توضیح',
	'youtubeauthsub_password' => 'گذرواژهٔ یوتیوب',
	'youtubeauthsub_username' => 'نام کاربری یوتیوب',
	'youtubeauthsub_keywords' => 'کلیدواژه‌ها',
	'youtubeauthsub_category' => 'رده',
	'youtubeauthsub_submit' => 'ارسال',
	'youtubeauthsub_clickhere' => 'برای ورود به یوتیوب اینجا کلیک کنید',
	'youtubeauthsub_uploadhere' => 'کلیپ خود را از اینجا بارگذاری کنید:',
	'youtubeauthsub_uploadbutton' => 'بارگذاری',
	'youtubeauthsub_uploading' => 'کلیپ شما در حال بارگذاریست .
لطفا صبور باشید.',
	'youtubeauthsub_jserror_nokeywords' => 'لطفا یک کلیدواژه یا بیشتر وارد کنید.',
	'youtubeauthsub_jserror_notitle' => 'لطفا برای کلیپ خود عنوان انتخاب کنید.',
	'youtubeauthsub_jserror_nodesc' => 'لطفا برای کلیپ خود توضیحاتی وارد کنید.',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Mobe
 * @author Nike
 * @author Str4nd
 * @author Vililikku
 */
$messages['fi'] = array(
	'youtubeauthsub' => 'Lähetä YouTube-video',
	'youtubeauthsub-desc' => 'Mahdollistaa käyttäjien [[Special:YouTubeAuthSub|lähettää videoita]] suoraan YouTubeen.',
	'youtubeauthsub_info' => 'Täytä seuraavat tiedot, niin voit tallentaa videon YouTubeen sivulla käytettäväksi.',
	'youtubeauthsub_title' => 'Nimi',
	'youtubeauthsub_description' => 'Kuvaus',
	'youtubeauthsub_password' => 'YouTube-salasana',
	'youtubeauthsub_username' => 'YouTube-käyttäjätunnus',
	'youtubeauthsub_keywords' => 'Avainsanat',
	'youtubeauthsub_category' => 'Luokka',
	'youtubeauthsub_submit' => 'Lähetä',
	'youtubeauthsub_clickhere' => 'Kirjaudu YouTubeen',
	'youtubeauthsub_tokenerror' => 'Tunnistusvarmenteen luominen epäonnistui. Yritä uudelleen.',
	'youtubeauthsub_success' => "Onnittelut!
Videosi on tallennettu.
<a href='http://www.youtube.com/watch?v=$1'>Katso video</a>.
Uuden videon käsittely voi kestää YouTubessa hetken, joten se ei ehkä ole vielä valmis.

Lisää video wikisivulle seuraavalla koodilla:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Kirjaudu sisään YouTubeen ennen videon lähettämistä.',
	'youtubeauthsub_uploadhere' => 'Lähetä videosi täältä:',
	'youtubeauthsub_uploadbutton' => 'Lähetä',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Katso tämä video]',
	'youtubeauthsub_summary' => 'Lähetetään YouTube-videota',
	'youtubeauthsub_uploading' => 'Videotasi lähetetään.
Ole kärsivällinen.',
	'youtubeauthsub_viewpage' => 'Voit [[$1|katsoa videosi myös täällä]].',
	'youtubeauthsub_jserror_nokeywords' => 'Anna yksi tai useampi avainsana.',
	'youtubeauthsub_jserror_notitle' => 'Anna videolle otsikko.',
	'youtubeauthsub_jserror_nodesc' => 'Anna videolle kuvaus.',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author IAlex
 * @author Louperivois
 * @author Mihai
 * @author PieRRoMaN
 */
$messages['fr'] = array(
	'youtubeauthsub' => 'Téléverser une vidéo YouTube',
	'youtubeauthsub-desc' => 'Permet aux utilisateurs de [[Special:YouTubeAuthSub|téléverser des vidéos]] directement sur YouTube',
	'youtubeauthsub_info' => 'Pour téléverser une vidéo sur YouTube afin de l’incorporer dans une page, renseignez les informations suivantes :',
	'youtubeauthsub_title' => 'Titre',
	'youtubeauthsub_description' => 'Description',
	'youtubeauthsub_password' => 'Mot de passe sur YouTube',
	'youtubeauthsub_username' => 'Nom d’utilisateur sur YouTube',
	'youtubeauthsub_keywords' => 'Mots clefs',
	'youtubeauthsub_category' => 'Catégorie',
	'youtubeauthsub_submit' => 'Soumettre',
	'youtubeauthsub_clickhere' => 'Cliquez ici pour vous connecter sur YouTube',
	'youtubeauthsub_tokenerror' => 'Erreur lors de la demande d’autorisation, essayez de rafraîchir la page.',
	'youtubeauthsub_success' => "Félicitations !
Votre vidéo est téléversée.
<a href='http://www.youtube.com/watch?v=$1'>Visionnez votre vidéo</a>.
Il se peut que YouTube ait besoin d’un certain temps pour prendre en compte votre vidéo, il est donc possible qu’elle ne soit pas encore disponible.

Pour incorporer votre vidéo dans une page du wiki, insérez le code suivant dans celle-ci :
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Pour téléverser une vidéo, vous devrez d’abord vous connecter sur YouTube.',
	'youtubeauthsub_uploadhere' => 'Téléverser votre vidéo depuis ici :',
	'youtubeauthsub_uploadbutton' => 'Téléverser',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Voir cette vidéo]',
	'youtubeauthsub_summary' => 'Téléverser une vidéo YouTube',
	'youtubeauthsub_uploading' => 'Votre vidéo est en cours de téléversement.
Veuillez patienter.',
	'youtubeauthsub_viewpage' => 'Sinon, vous pouvez [[$1|visionner votre vidéo]].',
	'youtubeauthsub_jserror_nokeywords' => 'Veuillez entrer un ou plusieurs mots clefs.',
	'youtubeauthsub_jserror_notitle' => 'Veuillez entrer un titre pour la vidéo.',
	'youtubeauthsub_jserror_nodesc' => 'Veuillez entrer une description pour la vidéo.',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'youtubeauthsub' => 'Tèlèchargiér una vidèô YouTube',
	'youtubeauthsub-desc' => 'Pèrmèt ux utilisators de [[Special:YouTubeAuthSub|tèlèchargiér des vidèôs]] tot drêt dessus YouTube.',
	'youtubeauthsub_info' => 'Por tèlèchargiér una vidèô dessus YouTube por l’apondre a una pâge, rensègnéd cetes enformacions :',
	'youtubeauthsub_title' => 'Titro',
	'youtubeauthsub_description' => 'Dèscripcion',
	'youtubeauthsub_password' => 'Contresegno dessus YouTube',
	'youtubeauthsub_username' => 'Nom d’utilisator dessus YouTube',
	'youtubeauthsub_keywords' => 'Mots-cllâfs',
	'youtubeauthsub_category' => 'Catègorie',
	'youtubeauthsub_submit' => 'Sometre',
	'youtubeauthsub_clickhere' => 'Clicâd ique por vos branchiér dessus YouTube',
	'youtubeauthsub_tokenerror' => 'Èrror pendent la demanda d’ôtorisacion, tâchiéd de rafrèchir la pâge.',
	'youtubeauthsub_success' => "Fèlicitacions !
Voutra vidèô est tèlèchargiê.
<a href='http://www.youtube.com/watch?v=$1'>Vêde voutra vidèô</a>.
Sè pôt que YouTube èye fôta d’un pou de temps por prendre en compto voutra vidèô, o est vêr possiblo que seye p’oncor disponibla.

Por apondre voutra vidèô dens una pâge du vouiqui, entrebetâd ceti code dens ceta :
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Por tèlèchargiér una vidèô, vos vos devréd d’abôrd branchiér dessus YouTube.',
	'youtubeauthsub_uploadhere' => 'Tèlèchargiér voutra vidèô dês ique :',
	'youtubeauthsub_uploadbutton' => 'Tèlèchargiér',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Vêde cela vidèô]',
	'youtubeauthsub_summary' => 'Tèlèchargiér una vidèô YouTube',
	'youtubeauthsub_uploading' => 'Voutra vidèô est aprés étre tèlèchargiê.
Volyéd pacientar.',
	'youtubeauthsub_viewpage' => 'Ôtrament, vos pouede [[$1|vêre voutra vidèô]].',
	'youtubeauthsub_jserror_nokeywords' => 'Volyéd buchiér yon ou ben un mouél de mots-cllâfs.',
	'youtubeauthsub_jserror_notitle' => 'Volyéd buchiér un titro por la vidèô.',
	'youtubeauthsub_jserror_nodesc' => 'Volyéd buchiér una dèscripcion por la vidèô.',
);

/** Western Frisian (Frysk)
 * @author SK-luuut
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'youtubeauthsub' => 'YouTube-filmke oanbiede',
	'youtubeauthsub_title' => 'Namme',
	'youtubeauthsub_description' => 'Beskriuwing',
	'youtubeauthsub_password' => 'YouTube-wachtwurd',
	'youtubeauthsub_username' => 'YouTube-meidoggersnamme',
	'youtubeauthsub_keywords' => 'Stekwurden',
	'youtubeauthsub_category' => 'Kategory',
	'youtubeauthsub_submit' => 'Oanbiede',
	'youtubeauthsub_clickhere' => 'Klik hjir om dy by YouTube oan te melden',
	'youtubeauthsub_tokenerror' => 'Flater by het meitsjen fan it tagongskaartsje, fernij de side.',
);

/** Irish (Gaeilge)
 * @author Alison
 * @author Moilleadóir
 */
$messages['ga'] = array(
	'youtubeauthsub_title' => 'Teideal',
	'youtubeauthsub_category' => 'Catagóir',
	'youtubeauthsub_uploadbutton' => 'Uaslódaigh',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'youtubeauthsub' => 'Cargar un vídeo ao YouTube',
	'youtubeauthsub-desc' => 'Permite aos usuarios [[Special:YouTubeAuthSub|cargar vídeos]] directamente ao YouTube',
	'youtubeauthsub_info' => 'Para cargar un vídeo ao YouTube e incluílo nunha páxina, enche a seguinte información:',
	'youtubeauthsub_title' => 'Título',
	'youtubeauthsub_description' => 'Descrición',
	'youtubeauthsub_password' => 'Contrasinal YouTube',
	'youtubeauthsub_username' => 'Alcume YouTube',
	'youtubeauthsub_keywords' => 'Palabras clave',
	'youtubeauthsub_category' => 'Categoría',
	'youtubeauthsub_submit' => 'Enviar',
	'youtubeauthsub_clickhere' => 'Fai clic aquí para acceder ao sistema YouTube',
	'youtubeauthsub_tokenerror' => 'Erro ao xerar a autorización de mostra, proba a refrescar a páxina.',
	'youtubeauthsub_success' => "Parabéns!
O teu vídeo foi cargado.
<a href='http://www.youtube.com/watch?v=$1'>Ve o teu vídeo</a>.
Pode que YouTube necesite uns minutos para procesar o teu vídeo, polo que pode non estar aínda dispoñible.

Para incluír o teu vídeo nunha páxina do wiki, insire o seguinte código nela:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Para cargar un vídeo, primeiro necesitará acceder ao sistema YouTube.',
	'youtubeauthsub_uploadhere' => 'Cargar o teu vídeo desde:',
	'youtubeauthsub_uploadbutton' => 'Cargar',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Ver este vídeo]',
	'youtubeauthsub_summary' => 'Cargando vídeo ao YouTube',
	'youtubeauthsub_uploading' => 'O teu vídeo está sendo cargado.
Por favor, sexa paciente.',
	'youtubeauthsub_viewpage' => 'De maneira alternativa, podes [[$1|ver o teu vídeo]].',
	'youtubeauthsub_jserror_nokeywords' => 'Por favor, insira 1 ou máis palabras clave.',
	'youtubeauthsub_jserror_notitle' => 'Por favor, insira un título para o vídeo.',
	'youtubeauthsub_jserror_nodesc' => 'Por favor, insira unha descrición para o vídeo.',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'youtubeauthsub_title' => 'Ἐπιγραφή',
	'youtubeauthsub_description' => 'Περιγραφή',
	'youtubeauthsub_password' => 'Σύνθημα ἐν τῷ YouTube',
	'youtubeauthsub_username' => 'Ὄνομα χρωμένου ἐν τῷ YouTube',
	'youtubeauthsub_keywords' => 'Λέξεις κλειδία',
	'youtubeauthsub_category' => 'Κατηγορία',
	'youtubeauthsub_submit' => 'Ὑποβάλλειν',
	'youtubeauthsub_uploadbutton' => 'Ἐπιφόρτισις',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'youtubeauthsub' => 'YouTube-Video uffelade',
	'youtubeauthsub-desc' => 'Macht s Benutzer möglich, Video diräkt uf YouTube [[Special:YouTubeAuthSub|uffezlade]]',
	'youtubeauthsub_info' => 'Zum e Video uf YouTube uffezlade go s in e Syte yyfüege, muesch die Fälder usfülle:',
	'youtubeauthsub_title' => 'Titel',
	'youtubeauthsub_description' => 'Bschryybig',
	'youtubeauthsub_password' => 'YouTube-Passwort',
	'youtubeauthsub_username' => 'YouTube-Benutzername',
	'youtubeauthsub_keywords' => 'Schlisselwerter',
	'youtubeauthsub_category' => 'Kategorii',
	'youtubeauthsub_submit' => 'Schicke',
	'youtubeauthsub_clickhere' => 'Da drucke zum Aamälde bi YouTube',
	'youtubeauthsub_tokenerror' => 'Fähler bim Aalege von eme Authorisierigs-Token. Versuech d Syte nöi z lade.',
	'youtubeauthsub_success' => "Härzleche Glückwunsch!
Dyy Video isch uffeglade worde.
<a href='http://www.youtube.com/watch?v=$1'>Lueg Di Dyy Video aa</a>.
S cha syy, dass YouTube e chly Zyt brucht, zum Dyy Video z verarbeite, villicht isch d Syte wäge däm nonig bereit.

Go s Video uf ere Syte yybette, füeg dää Tekscht yy:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Du muesch Di zerscht bi YouTube aamälde go ne Video uffezlade.',
	'youtubeauthsub_uploadhere' => 'Video vo da uffelade:',
	'youtubeauthsub_uploadbutton' => 'Uffelade',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Das Video aaluege]',
	'youtubeauthsub_summary' => 'YouTube-Video uffelade',
	'youtubeauthsub_uploading' => 'Dyy Video wird grad uffeglade.
Bitte ha e chly Geduld.',
	'youtubeauthsub_viewpage' => 'Alternativ chasch [[$1|Dyy Video aaluege]].',
	'youtubeauthsub_jserror_nokeywords' => 'Bitte gib ei oder meh Schlüsselwörter aa.',
	'youtubeauthsub_jserror_notitle' => 'Bitte gib e Titel für s Video aa.',
	'youtubeauthsub_jserror_nodesc' => 'Bitte gib e Bschryybig für s Video aa.',
);

/** Gujarati (ગુજરાતી) */
$messages['gu'] = array(
	'youtubeauthsub_title' => 'શિર્ષક',
	'youtubeauthsub_category' => 'શ્રેણી',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'youtubeauthsub' => 'Laadey neese feeshan YouTube',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'youtubeauthsub_category' => 'Rukuni',
);

/** Hawaiian (Hawai`i)
 * @author Kalani
 * @author Singularity
 */
$messages['haw'] = array(
	'youtubeauthsub_password' => 'ʻŌlelo hūnā no YouTube',
	'youtubeauthsub_username' => 'ʻEʻe no YouTube',
	'youtubeauthsub_category' => 'Mahele',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 ʻIke i kēia wikiō',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'youtubeauthsub' => 'העלאת סרטון ל־YouTube',
	'youtubeauthsub-desc' => 'אפשרות למשתמשים [[Special:YouTubeAuthSub|להעלות סרטונים]] ישירות ל־YouTube',
	'youtubeauthsub_info' => 'על מנת להעלות סרטון ל־YouTube ולהכלילו בדף, מלאו את הפרטים הבאים:',
	'youtubeauthsub_title' => 'כותרת',
	'youtubeauthsub_description' => 'תיאור',
	'youtubeauthsub_password' => 'הסיסמה ב־YouTube',
	'youtubeauthsub_username' => 'שם המשתמש ב־YouTube',
	'youtubeauthsub_keywords' => 'מילות מפתח',
	'youtubeauthsub_category' => 'קטגוריה',
	'youtubeauthsub_submit' => 'שליחה',
	'youtubeauthsub_clickhere' => 'לחצו כאן כדי להתחבר ל־YouTube',
	'youtubeauthsub_tokenerror' => 'שגיאה ביצירת אסימון אימות, נסו לרענן.',
	'youtubeauthsub_success' => "ברכות!
הסרטון שלכם הועלה.
<a href='http://www.youtube.com/watch?v=$1'>צפייה בוידאו שלכם</a>.
ייתכן שיידרש ל־YouTube מעט זמן לעיבוד הסרטון שלך, כך שייתכן שאינו מוכן עדיין.

כדי לכלול את הסרטון שלך בדף בוויקי, יש להוסיף לדף את הקוד הבא:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'על מנת להעלות סרטון, ראשית עליכם להתחבר ל־YouTube',
	'youtubeauthsub_uploadhere' => 'העלו את הסרטון שלכם מכאן:',
	'youtubeauthsub_uploadbutton' => 'העלאה',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 לצפייה בסרטון זה]',
	'youtubeauthsub_summary' => 'העלאת סרטון ל־YouTube',
	'youtubeauthsub_uploading' => 'הסרטון שלכם נמצא כעת בתהליכי העלאה.
אנא האזרו בסבלנות.',
	'youtubeauthsub_viewpage' => 'לחלופין, תוכלו [[$1|לצפות בסרטון שלכם]].',
	'youtubeauthsub_jserror_nokeywords' => 'נא הזינו מילת מפתח אחת או יותר.',
	'youtubeauthsub_jserror_notitle' => 'נא הזינו כותרת לסרטון.',
	'youtubeauthsub_jserror_nodesc' => 'נא הזינו תיאור לסרטון.',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'youtubeauthsub_title' => 'शीर्षक',
	'youtubeauthsub_description' => 'ज़ानकारी',
	'youtubeauthsub_category' => 'श्रेणी',
	'youtubeauthsub_submit' => 'भेजें',
);

/** Croatian (Hrvatski)
 * @author Mvrban
 * @author Tivek
 */
$messages['hr'] = array(
	'youtubeauthsub' => 'Postavi YouTube video',
	'youtubeauthsub-desc' => 'Omogući suradnicima izravno [[Special:YouTubeAuthSub|postavljanje videa]] na YouTube',
	'youtubeauthsub_info' => 'Da biste postavili YouTube video na stranicu, popunite sljedeće podatke:',
	'youtubeauthsub_title' => 'Naslov',
	'youtubeauthsub_description' => 'Opis',
	'youtubeauthsub_password' => 'YouTube lozinka',
	'youtubeauthsub_username' => 'YouTube korisničko ime',
	'youtubeauthsub_keywords' => 'Ključne riječi',
	'youtubeauthsub_category' => 'Kategorija',
	'youtubeauthsub_submit' => 'Pošalji',
	'youtubeauthsub_clickhere' => 'Kliknite ovdje za prijavu na YouTube',
	'youtubeauthsub_tokenerror' => 'Greška u stvaranju autorizacijskog tokena, pokušajte osvježiti stranicu.',
	'youtubeauthsub_success' => "Čestitke!
Vaš video je postavljen.
<a href='http://www.youtube.com/watch?v=$1'>Pogledajte Vaš video</a>.
YouTubeu treba određeno vrijeme da procesira Vaš video, pa video možda još nije spreman.

Ako želite umetnuti video u stranicu na wikiju, umetnite sljedeći kôd u stranicu:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Da biste postavili video, prvo ćete se morati prijaviti na YouTube.',
	'youtubeauthsub_uploadhere' => 'Postavite svoj video odavde:',
	'youtubeauthsub_uploadbutton' => 'Postavljanje',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Pogledajte ovaj video]',
	'youtubeauthsub_summary' => 'Postavljam YouTube video',
	'youtubeauthsub_uploading' => 'Vaš video se postavlja.
Budite strpljivi.',
	'youtubeauthsub_viewpage' => 'Inače, možete [[$1|pogledati Vaš video]].',
	'youtubeauthsub_jserror_nokeywords' => 'Unesite 1 ili više ključnih riječi.',
	'youtubeauthsub_jserror_notitle' => 'Unesite naslov videa.',
	'youtubeauthsub_jserror_nodesc' => 'Unesite opis za video.',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'youtubeauthsub' => 'Widejo YouTube nahrać',
	'youtubeauthsub-desc' => 'Zmóžnja wužiwarjam wideja direktnje k YouTube [[Special:YouTubeAuthSub|nahrać]]',
	'youtubeauthsub_info' => 'Zo by widejo k YouTube nahrał, zo by je do strony zapřijał, wupjelń prošu slědowace pola:',
	'youtubeauthsub_title' => 'Titul',
	'youtubeauthsub_description' => 'Wopisanje',
	'youtubeauthsub_password' => 'Hesło YouTube',
	'youtubeauthsub_username' => 'Wužiwarske mjeno YouTube',
	'youtubeauthsub_keywords' => 'Klučowe słowa',
	'youtubeauthsub_category' => 'Kategorija',
	'youtubeauthsub_submit' => 'Pósłać',
	'youtubeauthsub_clickhere' => 'Za přizjewjenje do YouTube sem kliknyć',
	'youtubeauthsub_tokenerror' => 'Zmylk při wutworjenju awtorizowanskeho wuraza. Spytaj stronu aktualizować.',
	'youtubeauthsub_success' => "Gratulacija!
Waše widejo je nahrate.
<a href='http://www.youtube.com/watch?v=$1'>Widejo sej wobhladać</a>.
YouTube móhł trochu čas trjebał, zo by twoje widejo předźěłał, tak zo snano hišće hotowe njeje.

Zo by swoje widejo do strony we wikiju zapřijał, zasuń slědowacy kod do strony:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Zo by widejo nahrał, dyrbiš so najprjedy pola YouTube přizjewić.',
	'youtubeauthsub_uploadhere' => 'Twoje widejo wottud nahrać:',
	'youtubeauthsub_uploadbutton' => 'Nahrać',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Tute widejo sej wobhladać]',
	'youtubeauthsub_summary' => 'Widejo YouTube nahrawa so',
	'youtubeauthsub_uploading' => 'Twoje widejo so runje nahrawa.
Prošu budź sćerpliwy.',
	'youtubeauthsub_viewpage' => 'Alternatiwnje móžeš [[$1|swoje widejo wobhladać]].',
	'youtubeauthsub_jserror_nokeywords' => 'Prošu podaj 1 klučowe słowo abo wjacore klučowe słowa.',
	'youtubeauthsub_jserror_notitle' => 'Prošu zapodaj titul za widejo.',
	'youtubeauthsub_jserror_nodesc' => 'Prošu zapodaj wopisanje za widejo.',
);

/** Hungarian (Magyar)
 * @author Bdamokos
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'youtubeauthsub' => 'YouTube videó feltöltése',
	'youtubeauthsub-desc' => 'Lehetővé teszi a szerkesztők számára, hogy közvetlenül [[Special:YouTubeAuthSub|töltsenek fel videókat]] a YouTube-ra',
	'youtubeauthsub_info' => 'A videó feltöltéséhez meg kell adnod a következő információkat:',
	'youtubeauthsub_title' => 'Cím',
	'youtubeauthsub_description' => 'Leírás',
	'youtubeauthsub_password' => 'Jelszó a YouTube-on',
	'youtubeauthsub_username' => 'Felhasználói név a YouTube-on',
	'youtubeauthsub_keywords' => 'Kulcsszavak',
	'youtubeauthsub_category' => 'Kategória',
	'youtubeauthsub_submit' => 'Elküldés',
	'youtubeauthsub_clickhere' => 'Kattints ide a YouTube-ra való bejelentkezéshez',
	'youtubeauthsub_tokenerror' => 'Hiba törént az azonosítótoken készítése közben, próbáld meg frissíteni a lapot.',
	'youtubeauthsub_success' => "Gratulálunk!
A videód feltöltve.
Megtekintéshez kattints <a href='http://www.youtube.com/watch?v=$1'>ide</a>.
Szükség lehet egy kis időre a feldolgozásához, ezért lehet, hogy még nincs kész.

Egy wiki oldalra való beágyazásához illeszd be a következő kódot:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Videó feltöltéséhez be kell jelentkezned a YouTube-ba.',
	'youtubeauthsub_uploadhere' => 'Videó feltöltése innen:',
	'youtubeauthsub_uploadbutton' => 'Feltöltés',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

A videó [http://www.youtube.com/watch?v=$1 itt] tekinthető meg',
	'youtubeauthsub_summary' => 'YouTube videó feltöltése',
	'youtubeauthsub_uploading' => 'A videó most töltődik fel.
Kérlek várj türelemmel.',
	'youtubeauthsub_viewpage' => 'A videód [[$1|itt]] is megtekintheted.',
	'youtubeauthsub_jserror_nokeywords' => 'Adj meg egy vagy több kulcsszót.',
	'youtubeauthsub_jserror_notitle' => 'Kérlek, add meg a videó címét.',
	'youtubeauthsub_jserror_nodesc' => 'Kérlek, add meg a videó leírását.',
);

/** Interlingua (Interlingua)
 * @author Malafaya
 * @author McDutchie
 */
$messages['ia'] = array(
	'youtubeauthsub' => 'Incargar video YouTube',
	'youtubeauthsub-desc' => 'Permitte al usatores de [[Special:YouTubeAuthSub|incargar videos]] directemente in YouTube',
	'youtubeauthsub_info' => 'Pro incargar un video in YouTube a includer in un pagina, completa le sequente informationes:',
	'youtubeauthsub_title' => 'Titulo',
	'youtubeauthsub_description' => 'Description',
	'youtubeauthsub_password' => 'Contrasigno de YouTube',
	'youtubeauthsub_username' => 'Nomine de usator de YouTube',
	'youtubeauthsub_keywords' => 'Parolas-clave',
	'youtubeauthsub_category' => 'Categoria',
	'youtubeauthsub_submit' => 'Submitter',
	'youtubeauthsub_clickhere' => 'Clicca hic pro aperir un session in YouTube',
	'youtubeauthsub_tokenerror' => 'Error durante le generation del indicio de autorisation; prova refrescar le pagina.',
	'youtubeauthsub_success' => "Felicitationes!
Tu video ha essite incargate.
<a href='http://www.youtube.com/watch?v=$1'>Vider tu video</a>.
YouTube pote requirer un certe tempore pro processar tu video, dunque illo pote non ancora esser preste.

Pro includer tu video in un pagina in le wiki, insere le sequente codice in un pagina:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Pro incargar un video, essera necessari primo aperir un session in YouTube.',
	'youtubeauthsub_uploadhere' => 'Carga tu video ab hic:',
	'youtubeauthsub_uploadbutton' => 'Incargar',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Vider iste video]',
	'youtubeauthsub_summary' => 'Cargamento de video YouTube',
	'youtubeauthsub_uploading' => 'Tu video es in curso de incargamento.
Per favor sia patiente.',
	'youtubeauthsub_viewpage' => 'Alternativemente, tu pote [[$1|vider tu video]].',
	'youtubeauthsub_jserror_nokeywords' => 'Per favor entra 1 o plus parolas-clave.',
	'youtubeauthsub_jserror_notitle' => 'Per favor entra un titulo pro le video.',
	'youtubeauthsub_jserror_nodesc' => 'Per favor entra un description pro le video.',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Rex
 */
$messages['id'] = array(
	'youtubeauthsub' => 'Unggah video YouTube',
	'youtubeauthsub-desc' => 'Mengizinkan pengguna untuk [[Special:YouTubeAuthSub|mengunggah video]] langsung ke YouTube',
	'youtubeauthsub_info' => 'Untuk mengunggah video ke YouTube dan memasukkannya dalam suatu halaman, silakan isi informasi berikut ini:',
	'youtubeauthsub_title' => 'Judul',
	'youtubeauthsub_description' => 'Keterangan',
	'youtubeauthsub_password' => 'Kata sandi YouTube',
	'youtubeauthsub_username' => 'Nama pengguna YouTube',
	'youtubeauthsub_keywords' => 'Kata kunci',
	'youtubeauthsub_category' => 'Kategori',
	'youtubeauthsub_submit' => 'Kirim',
	'youtubeauthsub_clickhere' => 'Klik di sini untuk masuk log ke YouTube',
	'youtubeauthsub_tokenerror' => 'Gagal menghasilkan token otorisasi, coba muat kembali.',
	'youtubeauthsub_success' => "Selamat!
Video Anda berhasil dimuatkan.
<a href='http://www.youtube.com/watch?v=$1'>Lihat video Anda</a>.
YouTube mungkin memerlukan beberapa saat untuk memproses video Anda, sehingga video tersebut mungkin belum siap pada saat ini.

Untuk menampilkan video Anda di suatu halaman wiki, gunakan kode berikut di halaman tersebut: <code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Untuk mengunggah video, Anda harus masuk log terlebih dahulu di YouTube.',
	'youtubeauthsub_uploadhere' => 'Unggah video Anda dari sini:',
	'youtubeauthsub_uploadbutton' => 'Unggah',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Lihat video ini]',
	'youtubeauthsub_summary' => 'Sedang memuatkan video YouTube',
	'youtubeauthsub_uploading' => 'Video Anda sedang dimuatkan.
Silakan menunggu.',
	'youtubeauthsub_viewpage' => 'Pilihan lain, Anda dapat [[$1|melihat video Anda]].',
	'youtubeauthsub_jserror_nokeywords' => 'Silakan masukkan 1 kata kunci atau lebih.',
	'youtubeauthsub_jserror_notitle' => 'Silakan masukkan judul untuk video tersebut.',
	'youtubeauthsub_jserror_nodesc' => 'Silakan masukkan keterangan untuk video tersebut.',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'youtubeauthsub' => 'Bo nlènlé YouTube na élu',
	'youtubeauthsub_title' => 'Ishi edemede',
	'youtubeauthsub_description' => 'Nkȯwá',
	'youtubeauthsub_password' => 'Okwúngáfè YouTube',
	'youtubeauthsub_username' => "Áhà ọ'bànifé YouTube",
	'youtubeauthsub_keywords' => 'Mkpurụ edemede ngodi',
	'youtubeauthsub_category' => 'Ébéonọr',
	'youtubeauthsub_submit' => 'Dànyé',
	'youtubeauthsub_authsubinstructions' => 'I nweríkí tinyé enyónyó-na-jé gi na elú, I ga buzọr banyé ime YouTube.',
	'youtubeauthsub_uploadhere' => 'Tinyé enyónyó-na-jé nke gi nélú shi nga:',
	'youtubeauthsub_uploadbutton' => 'Tinyénélú',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Le enyónyó-na-jé nka]',
	'youtubeauthsub_summary' => 'Nè bo nlènlé YouTube na élu',
	'youtubeauthsub_uploading' => 'Enyónyó-na-jé gi na nyiri elú.
Biko nweré nkásị obi.',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'youtubeauthsub_title' => 'Titulo',
	'youtubeauthsub_category' => 'Kategorio',
	'youtubeauthsub_submit' => 'Sendez',
	'youtubeauthsub_uploadbutton' => 'Adkargez',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'youtubeauthsub' => 'Hlaða inn YouTube-myndbandi',
	'youtubeauthsub-desc' => 'Heimilar notendum að [[Special:YouTubeAuthSub|hlaða inn]] myndböndum beint frá YouTube',
	'youtubeauthsub_title' => 'Titill',
	'youtubeauthsub_description' => 'Lýsing',
	'youtubeauthsub_keywords' => 'Lykilorð',
	'youtubeauthsub_category' => 'Flokkur',
	'youtubeauthsub_submit' => 'Senda',
	'youtubeauthsub_uploadbutton' => 'Hlaða inn',
);

/** Italian (Italiano)
 * @author Darth Kule
 * @author Melos
 * @author Xpensive
 */
$messages['it'] = array(
	'youtubeauthsub' => 'Carica video su YouTube',
	'youtubeauthsub-desc' => 'Permette agli utenti di [[Special:YouTubeAuthSub|caricare video]] direttamente su YouTube',
	'youtubeauthsub_info' => 'Per caricare un video su YouTube da includere in una pagina, inserisci le informazioni seguenti:',
	'youtubeauthsub_title' => 'Titolo',
	'youtubeauthsub_description' => 'Descrizione',
	'youtubeauthsub_password' => 'Password di YouTube',
	'youtubeauthsub_username' => 'Nome utente di YouTube',
	'youtubeauthsub_keywords' => 'Parole chiave',
	'youtubeauthsub_category' => 'Categoria',
	'youtubeauthsub_submit' => 'Invia',
	'youtubeauthsub_clickhere' => 'Fai clic qui per effettuare il log in su YouTube',
	'youtubeauthsub_tokenerror' => 'Errore nella generazione del token di autorizzazione, prova ad aggiornare.',
	'youtubeauthsub_success' => "Complimenti!
Il tuo video è stato caricato.
<a href='http://www.youtube.com/watch?v=$1'>Guarda il tuo video</a>.
YouTube potrebbe richiedere un po' di tempo per elaborare il tuo video, quindi potrebbe non essere ancora pronto.

Per includere il tuo video in una pagina della wiki, inserisci il codice seguente in una pagina: <code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Per caricare un video ti verrà richiesto di effettuare prima il log in a YouTube.',
	'youtubeauthsub_uploadhere' => 'Carica il tuo video da qui:',
	'youtubeauthsub_uploadbutton' => 'Carica',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Guarda questo video]',
	'youtubeauthsub_summary' => 'Caricamento video YouTube',
	'youtubeauthsub_uploading' => 'Il tuo video è in fase di caricamento.
Sii paziente.',
	'youtubeauthsub_viewpage' => 'Oppure puoi [[$1|guardare il tuo video]].',
	'youtubeauthsub_jserror_nokeywords' => "Inserisci un'altra parola chiave.",
	'youtubeauthsub_jserror_notitle' => 'Inserisci un titolo per il video.',
	'youtubeauthsub_jserror_nodesc' => 'Inserisci una descrizione per il video.',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fievarsty
 * @author Fryed-peach
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'youtubeauthsub' => 'YouTube動画をアップロード',
	'youtubeauthsub-desc' => '利用者に直接 YouTube へ[[Special:YouTubeAuthSub|動画をアップロード]]できるようにする',
	'youtubeauthsub_info' => 'YouTubeへアップロードした動画をページに挿入するには、以下の情報を書き込んでください:',
	'youtubeauthsub_title' => 'タイトル',
	'youtubeauthsub_description' => '説明',
	'youtubeauthsub_password' => 'YouTube パスワード',
	'youtubeauthsub_username' => 'YouTube ユーザー名',
	'youtubeauthsub_keywords' => 'キーワード',
	'youtubeauthsub_category' => 'カテゴリ',
	'youtubeauthsub_submit' => '送信',
	'youtubeauthsub_clickhere' => 'YouTubeにログインするにはここをクリックしてください',
	'youtubeauthsub_tokenerror' => '認証トークンの生成時エラー。更新してみてください。',
	'youtubeauthsub_success' => "おめでとうございます！
あなたの動画はアップロードされました。
<a href='http://www.youtube.com/watch?v=$1'>あなたのビデオを見る</a>。
YouTubeがあなたの動画を処理するまで、いくらかの時間を必要とする可能性があります。

あなたの動画をウィキ内のページに埋め込むには、次のコードをページの中に挿入してください:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => '動画をアップロードするには、最初にYouTubeにログインする必要があります。',
	'youtubeauthsub_uploadhere' => 'ここから動画をアップロード:',
	'youtubeauthsub_uploadbutton' => 'アップロード',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}。

[http://www.youtube.com/watch?v=$1 この動画を見る]',
	'youtubeauthsub_summary' => 'YouTube動画をアップロード中',
	'youtubeauthsub_uploading' => 'あなたの動画をアップロードしています。 
しばらくお待ちください。',
	'youtubeauthsub_viewpage' => '代わりに、[[$1|自分の動画を見る]]ことができます。',
	'youtubeauthsub_jserror_nokeywords' => '1つ以上のキーワードを入力してください。',
	'youtubeauthsub_jserror_notitle' => '動画のタイトルを入力してください。',
	'youtubeauthsub_jserror_nodesc' => '動画の説明を入力してください。',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'youtubeauthsub' => 'Ngunggahaké vidéo YouTube',
	'youtubeauthsub-desc' => 'Ngidinaké para panganggo [[Special:YouTubeAuthSub|ngunggahaké vidéo]] sacara langsung ing YouTube',
	'youtubeauthsub_info' => 'Kanggo ngunggahaké vidéo ing YouTube supaya bisa dilebokaké ing sawijining kaca, isinen dhisik informasi iki:',
	'youtubeauthsub_title' => 'Irah-irahan (judhul)',
	'youtubeauthsub_description' => 'Dèskripsi',
	'youtubeauthsub_password' => 'Tembung sandhi YouTube',
	'youtubeauthsub_username' => 'Jeneng panganggo YouTube',
	'youtubeauthsub_keywords' => 'Tembung-tembung kunci',
	'youtubeauthsub_category' => 'Kategori',
	'youtubeauthsub_submit' => 'Kirim',
	'youtubeauthsub_clickhere' => 'Klik ing kéné kanggo log mlebu ing YouTube',
	'youtubeauthsub_tokenerror' => 'Ana sing salah nalika nggawé token otorisasi, tulung coba direfresh.',
	'youtubeauthsub_success' => "Slamet!
Vidéo panjenengan wis kasil diunggahaké.
<a href='http://www.youtube.com/watch?v=$1'>Pirsani vidéo panjenengan</a>.
YouTube manawa merlokaké sawetara wektu kanggo mrosès vidéo panjenengan, dadi mbokmanawa saiki durung cumepak.

Kanggo masang vidéo panjenengan ing kaca wiki, lebokna kodhe sing kapacak ing ngisor iki jroning kaca kasebut:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Kanggo ngunggahaké vidéo, panjenengan kudu log mlebu dhisik ing YouTube.',
	'youtubeauthsub_uploadhere' => 'Unggahna vidéo panjenengan saka kéné:',
	'youtubeauthsub_uploadbutton' => 'Unggah',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Pirsani vidéo iki]',
	'youtubeauthsub_summary' => 'Ngunggahaké vidéo YouTube',
	'youtubeauthsub_uploading' => 'Vidéo panjenengan lagi diunggahaké.
Tulung sabar dhisik.',
	'youtubeauthsub_viewpage' => 'Pilihan liya, panjenengan bisa [[$1|mirsani vidéo panjenengan]].',
	'youtubeauthsub_jserror_nokeywords' => 'Mangga lebokna 1 utawa luwih tembung kunci.',
	'youtubeauthsub_jserror_notitle' => 'Mangga lebokna irah-irahan (judhul) kanggo vidéo iki.',
	'youtubeauthsub_jserror_nodesc' => 'Mangga lebokna dèskripsi kanggo vidéo iki.',
);

/** Georgian (ქართული)
 * @author Alsandro
 * @author David1010
 * @author Temuri rajavi
 */
$messages['ka'] = array(
	'youtubeauthsub' => 'YouTube ვიდეოს ატვირთვა',
	'youtubeauthsub-desc' => 'შესაძლებლობას აძლევს მომხმარებლებს YouTube-ზე პირდაპირ [[Special:YouTubeAuthSub|ატვირთონ ვიდეო]]',
	'youtubeauthsub_info' => 'გვერდზე მისათითებელი ვიდეოს YouTube-ზე ატვირთვისთვის, შეავსეთ შემდეგი ინფორმაცია:',
	'youtubeauthsub_title' => 'სათაური',
	'youtubeauthsub_description' => 'აღწერა',
	'youtubeauthsub_password' => 'პაროლი YouTube–ზე',
	'youtubeauthsub_username' => 'მომხმარებლის სახელი YouTube–ზე',
	'youtubeauthsub_keywords' => 'საძიებო სიტყვები',
	'youtubeauthsub_category' => 'კატეგორია',
	'youtubeauthsub_submit' => 'გაგზავნა',
	'youtubeauthsub_clickhere' => 'აქ დააწკაპუნეთ YouTube-ში შესასვლელად',
	'youtubeauthsub_tokenerror' => 'შეცდომა ავტორიზაციაში, სცადეთ გვერდის განახლება.',
	'youtubeauthsub_success' => "გილოცავთ!
თქვენი ვიდეო აიტვირთა.
<a href='http://www.youtube.com/watch?v=$1'>იხილეთ თქვენი ვიდეო</a>.
YouTube-ს შესაძლოა გარკვეული დრო დასჭირდეს თქვენი ვიდეოს დადასტურებისთვის, შესაბამისად, ის ჯერ შესაძლოა მზად არ იყოს.

თქვენი ვიდეოს ჩასამატებლად რომელიმე გვერდზე ვიკიში, გვერდში ჩასვით შემდეგი კოდი:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'ვიდეოს ასატვირთად, მოგიწევთ ჯერ YouTube-ში დარეგისტრირება.',
	'youtubeauthsub_uploadhere' => 'ატვირთეთ თქვენი ვიდეო აქედან:',
	'youtubeauthsub_uploadbutton' => 'ატვირთვა',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 იხილეთ ეს ვიდეო]',
	'youtubeauthsub_summary' => 'YouTube ვიდეოს ატვირთვა',
	'youtubeauthsub_uploading' => 'მიმდინარეობს თქვენი ვიდეოს ატვირთვა.
გთხოვთ მოითმინოთ.',
	'youtubeauthsub_viewpage' => 'ალტერნატიულად, შეგიძლიათ [[$1|იხილოთ თქვენი ვიდეო]].',
	'youtubeauthsub_jserror_nokeywords' => 'გთხოვთ მიუთითოთ 1 ან მეტი საძიებო სიტყვა.',
	'youtubeauthsub_jserror_notitle' => 'გთხოვთ მიუთითოთ ვიდეოს სათაური.',
	'youtubeauthsub_jserror_nodesc' => 'გთხოვთ მიუთითოთ ვიდეოს აღწერა.',
);

/** Kirmanjki (Kırmancki)
 * @author Mirzali
 */
$messages['kiu'] = array(
	'youtubeauthsub_category' => 'Kategoriye',
	'youtubeauthsub_uploadbutton' => 'Bar ke',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Thearith
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'youtubeauthsub' => 'ផ្ទុកឡើងវីដេអូយូធ្យូប (YouTube)',
	'youtubeauthsub-desc' => 'អនុញ្ញាត​ឱ្យ​អ្នកប្រើប្រាស់នានា ​[[Special:YouTubeAuthSub|ផ្ទុកឡើង​វីដេអូ]]ដោយ​ផ្ទាល់ពី​យូធ្យូប (YouTube)',
	'youtubeauthsub_info' => 'មុននឹង​ផ្ទុក​ឡើង​នូវ​វីដេអូ​យូធ្យូប(YouTube) បញ្ចូលទៅ​ក្នុងទំព័រមួយ សូមបំពេញ​ព័ត៌មាន​ទាំងឡាយដូចតទៅ៖',
	'youtubeauthsub_title' => 'ចំណងជើង',
	'youtubeauthsub_description' => 'ពិពណ៌នា',
	'youtubeauthsub_password' => 'លេខ​សំងាត់យូធ្យូប (YouTube)',
	'youtubeauthsub_username' => 'អត្តនាមក្នុង​យូធ្យូប (YouTube)',
	'youtubeauthsub_keywords' => 'ពាក្យគន្លឹះ​នានា',
	'youtubeauthsub_category' => 'ចំណាត់ថ្នាក់ក្រុម',
	'youtubeauthsub_submit' => 'ស្នើឡើង',
	'youtubeauthsub_clickhere' => 'សូម​ចុចត្រង់នេះ​ ដើម្បី​ឡុកអ៊ីកចូលក្នុងយូធ្យូប (YouTube)',
	'youtubeauthsub_tokenerror' => 'មានកំហុសពេលកំពុងបង្កើតសុំការអនុញាត, សូមព្យាយាម refreshing ។',
	'youtubeauthsub_success' => "សូមអបអរសាទរ!

វីដេអូរបស់អ្នកបានផ្ទុកឡើងហើយ។

<a href='http://www.youtube.com/watch?v=$1'>មើល​វីដេអូ​របស់​អ្នក</a>.

យូធ្យូប(YouTube)អាចត្រូវការពេលវេលាមួយរយៈដើម្បីរៀបចំវីដេអូនេះ។ ហេតុនេះវាអាចនឹងមិនទាន់អាចមើលបានទេនៅពេលនេះ។


ដើម្បីបញ្ជូលវីដេអូរបស់អ្នកទៅក្នុងទំព័រមួយរបស់វិគី សូមចម្លងកូដខាងក្រោមបញ្ជូលទៅក្នុងទំព័រនោះ៖

<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'ដើម្បីផ្ទុកវីដេអូឡើង អ្នកនឹងត្រូវកត់ឈ្មោះចូលទៅក្នុងយូធ្យូប(YouTube)ជាមុនសិន។',
	'youtubeauthsub_uploadhere' => 'ផ្ទុកឡើងវីដេអូរបស់អ្នកពីទីនេះ៖',
	'youtubeauthsub_uploadbutton' => 'ផ្ទុកឡើង',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}​។

[http://www.youtube.com/watch?v=$1 មើល​វីដេអូ​នេះ]',
	'youtubeauthsub_summary' => 'កំពុង​ផ្ទុកឡើង​វីដេអូ​យូធ្យូប(YouTube)',
	'youtubeauthsub_uploading' => 'វីដេអូ​របស់អ្នក​កំពុង​ត្រូវបាន​ផ្ទុកឡើង។
សូម​មានការអត់ធ្មត់។',
	'youtubeauthsub_viewpage' => 'ម្យ៉ាងវិញទៀត អ្នក​ក៏​អាច [[$1|មើល​វីដេអូ​របស់​អ្នក]]​។',
	'youtubeauthsub_jserror_nokeywords' => 'សូមបញ្ជូលពាក្យគន្លឹះមួយឬច្រើន',
	'youtubeauthsub_jserror_notitle' => 'សូមដាក់ចំណងជើងឱ្យវីដេអូ។',
	'youtubeauthsub_jserror_nodesc' => 'សូមសរសេរការពិពណ៌នាឱ្យវីដេអូ។',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'youtubeauthsub_title' => 'ಶೀರ್ಷಿಕೆ',
	'youtubeauthsub_description' => 'ವಿವರ',
	'youtubeauthsub_category' => 'ವರ್ಗ',
);

/** Korean (한국어)
 * @author Klutzy
 * @author Kwj2772
 * @author ToePeu
 * @author Yknok29
 */
$messages['ko'] = array(
	'youtubeauthsub' => '유튜브 동영상 올리기',
	'youtubeauthsub-desc' => '유튜브에 [[Special:YouTubeAuthSub|동영상 올리기]] 기능을 추가합니다.',
	'youtubeauthsub_info' => '유튜브에 영상을 올리려면 아래 칸에 정보를 채워 주세요:',
	'youtubeauthsub_title' => '제목',
	'youtubeauthsub_description' => '설명',
	'youtubeauthsub_password' => '유튜브 비밀번호',
	'youtubeauthsub_username' => '유튜브 계정 이름',
	'youtubeauthsub_keywords' => '키워드',
	'youtubeauthsub_category' => '분류',
	'youtubeauthsub_submit' => '제출',
	'youtubeauthsub_clickhere' => '유튜브에 로그인하려면 여기를 클릭해 주세요',
	'youtubeauthsub_tokenerror' => '인증 토큰을 만드는 도중 오류가 발생했습니다. 다시 시도해 주세요.',
	'youtubeauthsub_success' => "축하합니다! 영상 업로드에 성공했습니다. <a href='http://www.youtube.com/watch?v=$1'>여기</a>에서 해당 영상을 볼 수 있습니다.
유튜브 서버에서 해당 영상을 재생할 수 있으려면 어느 정도 시간이 걸릴 수도 있습니다.

해당 영상을 문서에 추가하려면 다음을 복사해 주세요:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => '영상을 올리려면 유튜브에 로그인을 해야 합니다.',
	'youtubeauthsub_uploadhere' => '다음의 주소로 영상 올리기:',
	'youtubeauthsub_uploadbutton' => '올리기',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 이 영상 보기]',
	'youtubeauthsub_summary' => '유튜브 영상을 올리는 중',
	'youtubeauthsub_uploading' => '영상을 올리는 중입니다. 잠시 기다려 주세요.',
	'youtubeauthsub_viewpage' => '그 대신, [[$1|영상을 볼 수]] 있습니다.',
	'youtubeauthsub_jserror_nokeywords' => '키워드를 입력해 주세요.',
	'youtubeauthsub_jserror_notitle' => '영상의 제목을 입력해 주세요.',
	'youtubeauthsub_jserror_nodesc' => '영상에 대한 설명을 입력해 주세요.',
);

/** Karachay-Balkar (Къарачай-Малкъар)
 * @author Iltever
 * @author Къарачайлы
 */
$messages['krc'] = array(
	'youtubeauthsub' => 'YouTube видеону джюкле',
	'youtubeauthsub-desc' => 'Къошулгъанлагъа [[Special:YouTubeAuthSub|видео джюклерге]] мадар береди',
	'youtubeauthsub_info' => 'YouTube сайтха видеону джюклер ючюн эмда аны бетге салыр ючюн, бу билгилени толтуругъуз:',
	'youtubeauthsub_title' => 'Башлыкъ',
	'youtubeauthsub_description' => 'Ачыкълау',
	'youtubeauthsub_password' => 'YouTube пароль',
	'youtubeauthsub_username' => 'YouTube-ха къошулуучуну аты',
	'youtubeauthsub_keywords' => 'Ачхыч сёзле',
	'youtubeauthsub_category' => 'Категория',
	'youtubeauthsub_submit' => 'Джибер',
	'youtubeauthsub_clickhere' => 'YouTube сайтха кирир ючюн былайгъа бас',
	'youtubeauthsub_tokenerror' => 'Авторизацияны токенин къурауда халат, бетни джангыртыб кёрюгюз.',
	'youtubeauthsub_success' => "Алгъышлайбыз!
Видеогъуз джюкленди.
<a href='http://www.youtube.com/watch?v=$1'>Видеогузгъа къарагъыз</a>.
YouTube, видеогъузну ишлетир ючюн бир кесек заман алыргъа боллукъду, ол себебден бусагъатда ачалмазгъа болурсуз.

Викиге видеогъузну салыр ючюн, бу кодну бетге салыкъыз:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Видеону джюклер ючюн, Сизге эм алгъа YouTube-ха киригре/регистрацияны ётерге керекди.',
	'youtubeauthsub_uploadhere' => 'Видеогъуз былайдан джюкленсин:',
	'youtubeauthsub_uploadbutton' => 'Джюкле',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Бу видеогъа къараргъа]',
	'youtubeauthsub_summary' => 'YouTube видеону джюклеу',
	'youtubeauthsub_uploading' => 'Сизни видеогъуз джюклене турады.
Бир кесек сакълагъыз.',
	'youtubeauthsub_viewpage' => 'Дагъыда, [[$1|видеогъузгъа къараргъа]] боллукъсуз.',
	'youtubeauthsub_jserror_nokeywords' => 'Бир неда талай ачхыч сёзлени джазыгъыз.',
	'youtubeauthsub_jserror_notitle' => 'Видеону атын джазыгъыз.',
	'youtubeauthsub_jserror_nodesc' => 'Видеону ачыкълауун джазыгъыз.',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'youtubeauthsub_category' => 'Kategorya',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'youtubeauthsub' => 'Donn Ding <i lang="en">YouTube</i> Viddeo huhlade',
	'youtubeauthsub-desc' => 'Määt et müjjesch, dat Metmaacher ier Viddeos direk noh <i lang="en">YouTube</i> [[Special:YouTubeAuthSub|huhlade]].',
	'youtubeauthsub_info' => 'Öm ene Viddejo op <i lang="en">YouTube</i> en ene Sigg opnemme ze künne, donn hee di Enfommazjuhne aanjevve:',
	'youtubeauthsub_title' => 'Tittel',
	'youtubeauthsub_description' => 'Beschrievung',
	'youtubeauthsub_password' => 'Ding Passwoot op <i lang="en">YouTube</i>',
	'youtubeauthsub_username' => 'Dinge Metmaacher-Name op <i lang="en">YouTube</i>',
	'youtubeauthsub_keywords' => 'Steschwööter op <i lang="en">YouTube</i>',
	'youtubeauthsub_category' => 'Kattejori op <i lang="en">YouTube</i>',
	'youtubeauthsub_submit' => 'Lohß Jonn!',
	'youtubeauthsub_clickhere' => 'Kleck för et Enlogge op <i lang="en">YouTube</i>',
	'youtubeauthsub_tokenerror' => 'Mer hatte ene Fähler, un kunnte keine Eimohl-Zohjangsschlößel krijje, dröm versök et ens domet, die Sigg neu opzeroofe udder neu ze laade.',
	'youtubeauthsub_success' => 'Jrattoleere!

Dinge Viddejo es huhjelade.

Öm Dinge Viddejo aanzeloore, donn op
<a href="http://www.youtube.com/watch?v=$1">YouTube <tt>/watch?v=$1</tt></a>
jonn. Di bruche ävver e beßje Zick, öm Dinge Viddejo
doh opzenämme, dröm künnd et sinn, dat dä noch nit janz
fäädisch es, em Momänt.

Öm Dinge Viddejo en en Sigg hee em Wiki enzeboue, 
donn dat wat hee follesch en en Sigg erenn schriive:
 <code>{{&#35;ev:youtube|$1}}</code>',
	'youtubeauthsub_authsubinstructions' => 'Öm ene Viddejo huhzelade, moß De eets op <i lang="en">YouTube</i> enjelogg han.',
	'youtubeauthsub_uploadhere' => 'Don Dinge Viddejo fun huhlade fun:',
	'youtubeauthsub_uploadbutton' => 'Huhlaade',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Dä Viddeje kam_mer hee beloore]',
	'youtubeauthsub_summary' => 'Ene YouTube Viddejo huhlade',
	'youtubeauthsub_uploading' => 'Dä Viddejo weet jrad noch huhjelaade.
Bes jet jedoldesch.',
	'youtubeauthsub_viewpage' => 'Do kanns Der och hee [[$1|Dinge Viddejo beloore]].',
	'youtubeauthsub_jserror_nokeywords' => 'Bes esu joot, jiff mieh Steshwööter aan.',
	'youtubeauthsub_jserror_notitle' => 'Jeff ene Tittel för dä Viddejo aan.',
	'youtubeauthsub_jserror_nodesc' => 'Don dä Viddejo winneßtens med enem Satz udder zwei beschrieve, söns weet dat nix, hee.',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'youtubeauthsub_title' => 'Sernav',
	'youtubeauthsub_category' => 'Kategorî',
);

/** Cornish (Kernowek)
 * @author Kernoweger
 * @author Kw-Moon
 */
$messages['kw'] = array(
	'youtubeauthsub_title' => 'Titel',
	'youtubeauthsub_password' => 'Ger-tremena YouTube',
	'youtubeauthsub_username' => 'Hanow-usyer YouTube',
	'youtubeauthsub_category' => 'Class',
	'youtubeauthsub_uploadbutton' => 'Ughcarga',
	'youtubeauthsub_summary' => 'Owth ughcarga video YouTube',
);

/** Ladino (Ladino)
 * @author Universal Life
 */
$messages['lad'] = array(
	'youtubeauthsub_title' => 'Títůlo',
	'youtubeauthsub_password' => 'YouTube Kóddiche',
	'youtubeauthsub_username' => 'YouTube Nombre de Usador',
	'youtubeauthsub_category' => 'Categoría',
	'youtubeauthsub_uploadbutton' => 'Cargar dosya',
	'youtubeauthsub_viewpage' => 'I también, puedes [[$1|ver tu viddeo aquí]].',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'youtubeauthsub' => 'YouTube Video eroplueden',
	'youtubeauthsub-desc' => 'Erlaabt de Benotzer fir [[Special:YouTubeAuthSub|Videoen direkt op YouTube eropzelueden]]',
	'youtubeauthsub_info' => 'Fir ee Video op YouTube eropzelueden, a fir deen op eng Säit anzebannen, gitt w.e.g. dës Informatiounen un:',
	'youtubeauthsub_title' => 'Titel',
	'youtubeauthsub_description' => 'Beschreiwung',
	'youtubeauthsub_password' => 'YouTube Passwuert',
	'youtubeauthsub_username' => 'YouTube Benotzernumm',
	'youtubeauthsub_keywords' => 'Stéchwierder',
	'youtubeauthsub_category' => 'Kategorie',
	'youtubeauthsub_submit' => 'Späicheren',
	'youtubeauthsub_clickhere' => 'Klickt hei fir Iech op YouTube eranzeloggen',
	'youtubeauthsub_tokenerror' => "Feeler beim generéiere vun der Autorisatioun, versicht et nach emol andeems Dir d'Säit aktualiséiert.",
	'youtubeauthsub_success' => "Gratulatioun!

Äre Video ass eropgelueden.

<a href='http://www.youtube.com/watch?v=$1'>Kuckt äre Video</a>.
YouTube brauch e bëssen Zäit fir äre Video ze verschaffen, do wéint kéint et sinn datt en nach net prätt ass.

Fir äre Video an eng Wiki-Säit anzebannen, gitt w.e.g. de folgende Code an eng Säit an:

<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => "Fir ee Video eropzeluede musst Dir Iech fir d'éischt op YouTube eraloggen.",
	'youtubeauthsub_uploadhere' => 'Äre Video vun hei eroplueden:',
	'youtubeauthsub_uploadbutton' => 'Eroplueden',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Kuckt dëse Video].',
	'youtubeauthsub_summary' => 'YouTube Video gëtt eropgelueden',
	'youtubeauthsub_uploading' => 'Äre Video gëtt eropgelueden.

Hutt w.e.g. e bësse Gedold!',
	'youtubeauthsub_viewpage' => 'alternativ kënnt Dir [[$1|äre Video kucken]].',
	'youtubeauthsub_jserror_nokeywords' => 'Gitt w.e.g. een oder méi Stechwierder un.',
	'youtubeauthsub_jserror_notitle' => 'Gitt w.e.g. een Titel fir de Video un.',
	'youtubeauthsub_jserror_nodesc' => 'Gitt w.e.g eng Beschreiwung vum Video.',
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'youtubeauthsub' => 'YouTubevideo uploade',
	'youtubeauthsub-desc' => "Laot gebroekers drek [[Special:YouTubeAuthSub|video's hoeaglaje]] óp YouTube",
	'youtubeauthsub_info' => "Gaef de volgende informatie op om 'ne video óp YouTube hoeag te laje om dae later aan 'n pagina te kinne toevoge:",
	'youtubeauthsub_title' => 'Naam',
	'youtubeauthsub_description' => 'Besjrieving',
	'youtubeauthsub_password' => 'YouTubewachwaord',
	'youtubeauthsub_username' => 'YouTubegebroeker',
	'youtubeauthsub_keywords' => 'Trèfwaord',
	'youtubeauthsub_category' => 'Categorie',
	'youtubeauthsub_submit' => 'Bievoge',
	'youtubeauthsub_clickhere' => 'Klik hie om aan te melje bie YouTube',
	'youtubeauthsub_tokenerror' => "Fout bie 't make van 't autorisatieteike. Vernuuj de pagina.",
	'youtubeauthsub_uploadbutton' => 'Upload',
	'youtubeauthsub_jserror_nokeywords' => 'Gaef e.t.b. ein of mier trefweurd op.',
	'youtubeauthsub_jserror_notitle' => "Gaef e.t.b. 'ne naam veur de video op.",
	'youtubeauthsub_jserror_nodesc' => "Gaef e.t.b. 'n besjrieving veur de video op.",
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 * @author Matasg
 */
$messages['lt'] = array(
	'youtubeauthsub' => 'Įkelti YouTube video',
	'youtubeauthsub-desc' => 'Leidžia naudotojams [[Special:YouTubeAuthSub|įkelti video]] tiesiai į YouTube',
	'youtubeauthsub_info' => 'Norėdami įkelti video į YouTube, siekiant įdėti jį puslapyje, užpildykite šią informaciją:',
	'youtubeauthsub_title' => 'Pavadinimas',
	'youtubeauthsub_description' => 'Aprašymas',
	'youtubeauthsub_password' => 'YouTube slaptažodis',
	'youtubeauthsub_username' => 'YouTube naudotojo vardas',
	'youtubeauthsub_keywords' => 'Raktažodžiai',
	'youtubeauthsub_category' => 'Kategorija',
	'youtubeauthsub_submit' => 'Siųsti',
	'youtubeauthsub_clickhere' => 'Paspauskite čia norint prisijungti prie YouTube',
	'youtubeauthsub_tokenerror' => 'Klaida kuriant leidimo ženklą, pabandykite atnaujinti puslapį.',
	'youtubeauthsub_success' => "Sveikiname! 
Jūsų video įkeltas.
<a href='http://www.youtube.com/watch?v=$1'>Peržiūrėti įrašą</a>.
YouTube gali pareikalauti šiek tiek laiko apdoroti jūsų vaizdo įrašą, todėl jis dar gali būti neparuoštas. 

Norėdami įdėti savo video į wiki puslapį, į jį įterpkite šį kodą : 
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Norint įkelti video, pirma turite prisijungti prie YouTube.',
	'youtubeauthsub_uploadhere' => 'Įkelti savo video iš čia:',
	'youtubeauthsub_uploadbutton' => 'Įkelti',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Peržiūrėti vaizdo įrašą]',
	'youtubeauthsub_summary' => 'Įkeliamas YouTube video',
	'youtubeauthsub_uploading' => 'Jūsų vaizdo įrašas įkeliamas. 
Prašome būti kantriems.',
	'youtubeauthsub_viewpage' => 'Taip pat galite [[$1|peržiūrėti savo video]].',
	'youtubeauthsub_jserror_nokeywords' => 'Prašome įvesti 1 arba daugiau raktinių žodžių.',
	'youtubeauthsub_jserror_notitle' => 'Prašome įvesti pavadinimą.',
	'youtubeauthsub_jserror_nodesc' => 'Prašome įvesti vaizdo aprašimą.',
);

/** Latgalian (Latgaļu)
 * @author Dark Eagle
 */
$messages['ltg'] = array(
	'youtubeauthsub_category' => 'Kategoreja',
);

/** Lazuri (Lazuri)
 * @author Bombola
 */
$messages['lzz'] = array(
	'youtubeauthsub_category' => "K'at'egori",
);

/** Malagasy (Malagasy)
 * @author Jagwar
 */
$messages['mg'] = array(
	'youtubeauthsub' => 'Hampiditra video YouTube',
	'youtubeauthsub-desc' => "Hahafahan'ny mpikambana [[Special:YouTubeAuthSub|mampiditra video]] avy eo amin'i Youtube",
	'youtubeauthsub_info' => "Fenoy ny tokony hofenoina rehefa te-hampiditra video avy any amin'ny YouTube :",
	'youtubeauthsub_title' => 'Lohateny',
	'youtubeauthsub_description' => 'Visavisa',
	'youtubeauthsub_password' => "Tenimiafina amin'ny YouTube",
	'youtubeauthsub_username' => "Solonanarana eo amin'ny YouTube",
	'youtubeauthsub_keywords' => 'Keyword',
	'youtubeauthsub_category' => 'Sokajy',
	'youtubeauthsub_submit' => 'Alefa',
	'youtubeauthsub_clickhere' => "Tsindrio eto ra tia hiditra anatin'ny Youtube",
	'youtubeauthsub_tokenerror' => 'Tsi-fetezana teo am-pangatahana ilay alalana, avaozy ny pejy.',
	'youtubeauthsub_authsubinstructions' => "Raha ampiditra video ianao, dia midira aloha eo amin'i Youtube.",
	'youtubeauthsub_uploadhere' => 'Hampiditra ny video-nao avy eto :',
	'youtubeauthsub_uploadbutton' => 'Hampiditra',
	'youtubeauthsub_summary' => 'Hampiditra video YouTube',
	'youtubeauthsub_uploading' => 'Mampiditra ny video-nao ny rindrankajy.
Andraso.',
	'youtubeauthsub_jserror_nokeywords' => 'Mampidira teny iray na maro.',
	'youtubeauthsub_jserror_notitle' => "Mampidira lohateny ho an'ilay video.",
	'youtubeauthsub_jserror_nodesc' => "Mampidira ambangovangony ho an'ilay video.",
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'youtubeauthsub' => 'Подигни YouTube видеоснимка',
	'youtubeauthsub-desc' => 'Овозможува корисниците да [[Special:YouTubeAuthSub|подигаат видеоснимки]] директно на YouTube',
	'youtubeauthsub_info' => 'За да подигнете видеоснимка на YouTube за вметнување во страница, пополнете ги следните полиња:',
	'youtubeauthsub_title' => 'Наслов',
	'youtubeauthsub_description' => 'Опис',
	'youtubeauthsub_password' => 'YouTube лозинка',
	'youtubeauthsub_username' => 'YouTube корисничко име',
	'youtubeauthsub_keywords' => 'Клучни зборови',
	'youtubeauthsub_category' => 'Категорија',
	'youtubeauthsub_submit' => 'Поднеси',
	'youtubeauthsub_clickhere' => 'Кликнете тука за да се најавите на YouTube',
	'youtubeauthsub_tokenerror' => 'Грешка при создавањето на потврдниот жетон. Обидете се повторно.',
	'youtubeauthsub_success' => "Честитаме!
Вашата видеоснимка е подигната.
<a href='http://www.youtube.com/watch?v=$1'>Поглдајте ја снимката</a>.
На YouTube може да му треба извесно време за да обработи видеоснимката, па затоа може да не е достапна веднаш.

За да ја вметнете снимката на некоја вики-страница, внесете го следниов код:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'За подигање на видеоснимка потребно е најпрвин да се најавите на YouTube.',
	'youtubeauthsub_uploadhere' => 'Подигнете го видео-записот од овде:',
	'youtubeauthsub_uploadbutton' => 'Подигни',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Погледајте ја видеоснимката]',
	'youtubeauthsub_summary' => 'Подигање на видеоснимка на YouTube',
	'youtubeauthsub_uploading' => 'Видео записот се подигнува.
Почекајте ...',
	'youtubeauthsub_viewpage' => 'Или пак можете да го [[$1|погледнете видео записот]].',
	'youtubeauthsub_jserror_nokeywords' => 'Внесете еден или повеќе клучни зборови.',
	'youtubeauthsub_jserror_notitle' => 'Внесете наслов на видео записот.',
	'youtubeauthsub_jserror_nodesc' => 'Внесете опис на видео записот.',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'youtubeauthsub' => 'യൂട്യൂബ് വീഡിയോ അപ്‌ലോഡ് ചെയ്യുക',
	'youtubeauthsub-desc' => 'യൂട്യൂബിലേക്കു നേരിട്ട് [[Special:YouTubeAuthSub|വീഡിയോ അപ്‌ലോഡ് ചെയ്യാൻ]] ഉപയോക്താക്കളെ സഹായിക്കുന്നു',
	'youtubeauthsub_title' => 'ശീർഷകം',
	'youtubeauthsub_description' => 'വിവരണം',
	'youtubeauthsub_password' => 'യൂട്യൂബ് രഹസ്യവാക്ക്',
	'youtubeauthsub_username' => 'യൂട്യൂബ് യൂസർനാമം',
	'youtubeauthsub_keywords' => 'അടയാളവാക്കുകൾ',
	'youtubeauthsub_category' => 'വർഗ്ഗം',
	'youtubeauthsub_submit' => 'സമർപ്പിക്കുക',
	'youtubeauthsub_clickhere' => 'യൂട്യൂബിലേക്ക് ലോഗിൻ ചെയ്യാൻ ഇവിടെ ഞെക്കുക',
	'youtubeauthsub_uploadhere' => 'താങ്കളുടെ വീഡിയോ ഇവിടെ നിന്നും അപ്‌ലോഡ് ചെയ്യുക:',
	'youtubeauthsub_uploadbutton' => 'അപ്‌ലോഡ്',
	'youtubeauthsub_summary' => 'യൂട്യൂബ് വീഡിയോ അപ്‌ലോഡ് ചെയ്തുകൊണ്ടിരിക്കുന്നു',
	'youtubeauthsub_uploading' => 'താങ്കളുടെ വീഡിയോ അപ്‌ലോഡ് ചെയ്യപ്പെട്ടിരിക്കുന്നു. ദയവായി കാത്തിരിക്കൂ.',
	'youtubeauthsub_viewpage' => 'മറ്റുരീതിയിൽ, താങ്കൾക്ക് താങ്കളുടെ വീഡിയോ [[$1|ഇവിടെ നിന്നും]] കാണാവുന്നതാണ്‌.',
	'youtubeauthsub_jserror_nokeywords' => 'ഒന്നോ അതിലധികമോ കീവേർഡുകൾ ചേർക്കുക.',
	'youtubeauthsub_jserror_notitle' => 'വീഡിയോയ്ക്കു ഒരു ശീർഷകം ചേർക്കുക.',
	'youtubeauthsub_jserror_nodesc' => 'വീഡിയോയെപ്പറ്റി ഒരു ലഘുവിവരണം ചേർക്കുക.',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 * @author E.shijir
 */
$messages['mn'] = array(
	'youtubeauthsub' => 'Youtube-н бичлэг оруулах',
	'youtubeauthsub_title' => 'Гарчиг',
	'youtubeauthsub_password' => 'YouTube нууц үг',
	'youtubeauthsub_username' => 'YouTube хэрэглэгчийн нэр',
	'youtubeauthsub_keywords' => 'Түлхүүр үгнүүд',
	'youtubeauthsub_submit' => 'Явуулах',
	'youtubeauthsub_uploadbutton' => 'Оруулах',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'youtubeauthsub' => 'यूट्यूब व्हीडियो चढवा',
	'youtubeauthsub-desc' => 'सदस्यांना थेट यूट्यूबवर [[Special:YouTubeAuthSub|व्हीडियो चढविण्याची]] परवानगी देतो',
	'youtubeauthsub_info' => 'एखादा व्हिडियो एखाद्या पानावर देण्यासाठी, यूट्यूब मध्ये चढविण्यासाठी, खालील माहिती भरा:',
	'youtubeauthsub_title' => 'शीर्षक',
	'youtubeauthsub_description' => 'माहिती',
	'youtubeauthsub_password' => 'यूट्यूब परवलीचा शब्द',
	'youtubeauthsub_username' => 'यूट्यूब सदस्यनाव',
	'youtubeauthsub_keywords' => 'शोधशब्द',
	'youtubeauthsub_category' => 'वर्ग',
	'youtubeauthsub_submit' => 'पाठवा',
	'youtubeauthsub_clickhere' => 'यूट्यूब मध्ये प्रवेश करण्यासाठी इथे टिचकी द्या',
	'youtubeauthsub_tokenerror' => 'अधिकृत करण्याचे टोकन तयार करण्यामध्ये त्रुटी, ताजेतवाने करून पहा.',
	'youtubeauthsub_success' => "अभिनंदन!
तुमचा व्हिडियो चढविण्यात आलेला आहे.
तुमचा व्हिडियो पाहण्यासाठी <a href='http://www.youtube.com/watch?v=$1'>इथे</a> टिचकी द्या.
यूट्यूबला तुमचा व्हिडियो दाखविण्यासाठी काही वेळ लागू शकतो.

तुमचा व्हिडियो एखाद्या विकि पानावर दाखविण्यासाठी, खालील कोड वापरा:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'व्हिडीयो चढविण्यासाठी तुम्ही यूट्यूब वर प्रवेश केलेला असणे आवश्यक आहे.',
	'youtubeauthsub_uploadhere' => 'इथून तुमचा व्हिडियो चढवा:',
	'youtubeauthsub_uploadbutton' => 'चढवा',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

हा व्हिडियो [http://www.youtube.com/watch?v=$1 इथे] पाहता येईल',
	'youtubeauthsub_summary' => 'यूट्यूब व्हिडियो चढवित आहे',
	'youtubeauthsub_uploading' => 'तुमचा व्हिडियो चढवित आहोत.
कृपया धीर धरा.',
	'youtubeauthsub_viewpage' => 'किंवा, तुम्ही तुमचा व्हिडियो [[$1|इथे]] पाहू शकता.',
	'youtubeauthsub_jserror_nokeywords' => 'कृपया १ किंवा अधिक शोधशब्द लिहा.',
	'youtubeauthsub_jserror_notitle' => 'कृपया व्हिडियोचे शीर्षक लिहा.',
	'youtubeauthsub_jserror_nodesc' => 'कृपया व्हिडियोची माहिती लिहा.',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Diagramma Della Verita
 * @author Izzudin
 */
$messages['ms'] = array(
	'youtubeauthsub' => 'Muat naik video YouTube',
	'youtubeauthsub-desc' => 'Benarkan pengguna [[Special:YouTubeAuthSub|memuat naik video]] terus ke YouTube',
	'youtubeauthsub_info' => 'Untuk muat naik video ke YouTube bagi disertakan dalam laman, isikan maklumat berikut:',
	'youtubeauthsub_title' => 'Tajuk',
	'youtubeauthsub_description' => 'Keterangan',
	'youtubeauthsub_password' => 'Kata laluan YouTube',
	'youtubeauthsub_username' => 'Nama pengguna YouTube',
	'youtubeauthsub_keywords' => 'Kata kunci',
	'youtubeauthsub_category' => 'Kategori',
	'youtubeauthsub_submit' => 'Hantar',
	'youtubeauthsub_clickhere' => 'Klik untuk log masuk ke YouTube',
	'youtubeauthsub_tokenerror' => 'Ralat dalam menjana token kebenaran, cuba muat semula.',
	'youtubeauthsub_success' => "Tahniah!
Video anda telah dimuat naik.
<a href='http://www.youtube.com/watch?v=$1'>Tonton video anda</a>.
YouTube memerlukan masa untuk memproses video anda, ia mungkin belum sedia buat masa ini.

Untuk letak video anda dalam laman wiki, letakkan kod berikut dalam laman:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Anda perlu log masuk sebelum boleh muat naik video ke YouTube.',
	'youtubeauthsub_uploadhere' => 'Muat naik video dari sini:',
	'youtubeauthsub_uploadbutton' => 'Muat naik',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Tonton video ini]',
	'youtubeauthsub_summary' => 'Video YouTube sedang dimuat naik',
	'youtubeauthsub_uploading' => 'Video anda sedang dimuat naik. 
Kerjasama anda amat dihargai.',
	'youtubeauthsub_viewpage' => 'Cara lain, anda dapat [[$1|tonton video anda]].',
	'youtubeauthsub_jserror_nokeywords' => 'Sila masukkan 1 atau lebih kata kunci.',
	'youtubeauthsub_jserror_notitle' => 'Sila sertakan tajuk video',
	'youtubeauthsub_jserror_nodesc' => 'Sila sertakan penerangan dan maklumat tentang video',
);

/** Maltese (Malti)
 * @author Chrisportelli
 * @author Giangian15
 */
$messages['mt'] = array(
	'youtubeauthsub' => "Tella' vidjo tal-YouTube",
	'youtubeauthsub-desc' => 'Tippermetti lill-utenti biex [[Special:YouTubeAuthSub|itellgħu vidjos]] direttament fuq YouTube',
	'youtubeauthsub_info' => "Sabiex ittella' vidjo fuq YouTube biex tagħmel użu minnu fuq paġna, imla l-informazzjoni segwenti:",
	'youtubeauthsub_title' => 'Titlu',
	'youtubeauthsub_description' => 'Deskrizzjoni',
	'youtubeauthsub_password' => 'Password tal-YouTube',
	'youtubeauthsub_username' => 'Isem tal-utent tal-YouTube',
	'youtubeauthsub_keywords' => 'Kliem ċavetta',
	'youtubeauthsub_category' => 'Kategorija',
	'youtubeauthsub_submit' => 'Ibgħat',
	'youtubeauthsub_clickhere' => 'Agħfas hawn biex tillogja fuq YouTube',
	'youtubeauthsub_tokenerror' => "Kien hemm problema biex jinħoloq it-token tal-awtorizazzjoni, prova tella' l-paġna mill-ġdid.",
	'youtubeauthsub_success' => "Prosit!<br />
Il-vidjo tiegħek ġie mtella.<br />
<a href='http://www.youtube.com/watch?v=$1'>Ara l-vidjo</a>.
YouTube ikun irid ftit żmien sabiex jiproċessa l-vidjo tiegħek, allura jista' jkun li ma jkunx għadu lest.

Biex tinkludi l-vidjo tiegħek fuq paġna tal-wiki, daħħal il-kodiċi segwenti fil-paġna:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => "Biex ittella' vidjo, hemm bżonn li l-ewwel tidħol fil-kont tiegħek fuq YouTube.",
	'youtubeauthsub_uploadhere' => "Tella' l-vidjo tiegħek hawnhekk:",
	'youtubeauthsub_uploadbutton' => "Tella'",
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Ara dan il-vidjo]',
	'youtubeauthsub_summary' => "Il-vidjo tal-YouTube qiegħed jiġi mtella'",
	'youtubeauthsub_uploading' => "Il-vidjo tiegħek qed jittella'.<br />
Jekk jogħġbok kun pazjenti.",
	'youtubeauthsub_viewpage' => "Minflok, tista' tara l-vidjo tiegħek [[$1|hawnhekk]].",
	'youtubeauthsub_jserror_nokeywords' => 'Jekk jogħġbok daħħal kelma jew aktar kliem ċavetta.',
	'youtubeauthsub_jserror_notitle' => 'Jekk jogħġbok daħħal titlu għall-vidjo.',
	'youtubeauthsub_jserror_nodesc' => 'Jekk jogħġbok daħħal deskrizzjoni għall-vidjo.',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 * @author Sura
 */
$messages['myv'] = array(
	'youtubeauthsub' => 'Ёвкстамс YouTube видеот',
	'youtubeauthsub_title' => 'Конякс',
	'youtubeauthsub_description' => 'Чарькодевтемгакс',
	'youtubeauthsub_password' => 'YouTube совамо вал',
	'youtubeauthsub_username' => 'YouTube теицянь лем',
	'youtubeauthsub_keywords' => 'Панжомакс вал',
	'youtubeauthsub_category' => 'Явовкс',
	'youtubeauthsub_submit' => 'Максомс',
	'youtubeauthsub_uploadhere' => 'Ёвкстамс видеот тияня:',
	'youtubeauthsub_uploadbutton' => 'Ёвкстамс',
	'youtubeauthsub_summary' => 'Моли YouTube видеонь ёвкставома',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 * @author Ricardo gs
 * @author Teòtlalili
 */
$messages['nah'] = array(
	'youtubeauthsub' => 'Videoquetza īhuīc YouTube',
	'youtubeauthsub_title' => 'Tōcāitl',
	'youtubeauthsub_password' => 'YouTube tlahtōlichtacāyōtl',
	'youtubeauthsub_username' => 'YouTube tlatequitiltilīltōcāitl',
	'youtubeauthsub_category' => 'Tlaìxmatkàtlàlilòtl',
	'youtubeauthsub_submit' => 'Tiquihuāz',
	'youtubeauthsub_uploadbutton' => 'Ticquetzāz',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Tiquittāz inīn vīdeo]',
	'youtubeauthsub_summary' => 'Moquetzacah YouTube vīdeo',
	'youtubeauthsub_viewpage' => 'Ahnozo, tihuelīti [[$1|tiquittāz movīdeo]].',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Laaknor
 */
$messages['nb'] = array(
	'youtubeauthsub' => 'Last opp YouTube-video',
	'youtubeauthsub-desc' => 'Lar brukere [[Special:YouTubeAuthSub|laste opp videoer]] på YouTube',
	'youtubeauthsub_info' => 'Fyll inn følgende informasjon for å laste opp en video på YouTube for å bruke den på en side:',
	'youtubeauthsub_title' => 'Tittel',
	'youtubeauthsub_description' => 'Beskrivelse',
	'youtubeauthsub_password' => 'YouTube-passord',
	'youtubeauthsub_username' => 'YouTube-brukernavn',
	'youtubeauthsub_keywords' => 'Nøkkelord',
	'youtubeauthsub_category' => 'Kategori',
	'youtubeauthsub_submit' => 'Lagre',
	'youtubeauthsub_clickhere' => 'Klikk her for å logge inn på YouTube',
	'youtubeauthsub_tokenerror' => 'Feil i oppretting av godkjenningstegn; prøv å oppdatere.',
	'youtubeauthsub_success' => 'Gratulerer!
Videoen din er lastet opp.
<a href="http://youtube.com/watch?v=$1">Se videoen din</a>.
Det kan ta litt tid før YouTube har behandlet videoen din, så det kan hende den ikke er klar ennå.

Sett inn følgende kode på en side for å inkludere videoen på en side på wikien:
<code>{{&#35;ev:youtube|$1}}</code>',
	'youtubeauthsub_authsubinstructions' => 'For å laste opp en video må du første logge inn på YouTube.',
	'youtubeauthsub_uploadhere' => 'Last opp din video herfra:',
	'youtubeauthsub_uploadbutton' => 'Last opp',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}

[http://youtube.com/watch?v=$1 Vis denne videoen]',
	'youtubeauthsub_summary' => 'Laster opp YouTube-video',
	'youtubeauthsub_uploading' => 'Videoen din blir lastet opp. Vær tålmodig.',
	'youtubeauthsub_viewpage' => 'Alternativt kan du [[$1|se videoen din]].',
	'youtubeauthsub_jserror_nokeywords' => 'Skriv inn ett eller flere nøkkelord.',
	'youtubeauthsub_jserror_notitle' => 'Velg enn tittel for videoen.',
	'youtubeauthsub_jserror_nodesc' => 'Skriv inn en beskrivelse av videoen.',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'youtubeauthsub' => 'YouTube-Video hoochladen',
	'youtubeauthsub-desc' => 'Verlööft Brukers Videos direkt op YouTube [[Special:YouTubeAuthSub|hoochtoladen]]',
	'youtubeauthsub_info' => 'Geev disse Informatschonen an, dat du en Video na YouTube hoochladen kannst:',
	'youtubeauthsub_title' => 'Titel',
	'youtubeauthsub_description' => 'Beschrieven',
	'youtubeauthsub_password' => 'YouTube-Passwoord',
	'youtubeauthsub_keywords' => 'Slötelwöör',
	'youtubeauthsub_category' => 'Kategorie',
	'youtubeauthsub_submit' => 'Hoochladen',
	'youtubeauthsub_uploadbutton' => 'Hoochladen',
);

/** Dutch (Nederlands)
 * @author Siebrand
 * @author Tvdm
 */
$messages['nl'] = array(
	'youtubeauthsub' => 'YouTube-video uploaden',
	'youtubeauthsub-desc' => "Laat gebruikers direct [[Special:YouTubeAuthSub|video's uploaden]] naar YouTube",
	'youtubeauthsub_info' => 'Geef de volgende informatie op om een video naar YouTube te uploaden om die later aan een pagina te kunnen toevoegen:',
	'youtubeauthsub_title' => 'Naam',
	'youtubeauthsub_description' => 'Beschrijving',
	'youtubeauthsub_password' => 'YouTube-wachtwoord',
	'youtubeauthsub_username' => 'YouTube-gebruikersnaam',
	'youtubeauthsub_keywords' => 'Trefwoorden',
	'youtubeauthsub_category' => 'Categorie',
	'youtubeauthsub_submit' => 'Uploaden',
	'youtubeauthsub_clickhere' => 'Klik hier om aan te melden bij YouTube',
	'youtubeauthsub_tokenerror' => 'Fout bij het maken van het autorisatietoken. Vernieuw de pagina.',
	'youtubeauthsub_success' => "Gefeliciteerd!
Uw video is geüpload.
<a href='http://www.youtube.com/watch?v=$1'>Bekijk uw video</a>.
Het komt voor dat YouTube enige tijd nodig heeft om uw video te verwerken, dus wellicht is die nog niet beschikbaar.

Voeg de volgende code toe om uw video in een pagina op te nemen:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => "Meld u eerst aan bij YouTube voordat u video's gaat uploaden.",
	'youtubeauthsub_uploadhere' => 'Uw video van hier uploaden:',
	'youtubeauthsub_uploadbutton' => 'Uploaden',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 U kunt deze video bekijken]',
	'youtubeauthsub_summary' => 'Bezig met uploaden van de YouTube-video',
	'youtubeauthsub_uploading' => 'Uw video wordt geüpload.
Even geduld alstublieft.',
	'youtubeauthsub_viewpage' => 'U kunt uw video ook [[$1|bekijken]].',
	'youtubeauthsub_jserror_nokeywords' => 'Geef alstublieft een of meer trefwoorden op.',
	'youtubeauthsub_jserror_notitle' => 'Geef een naam op voor de video.',
	'youtubeauthsub_jserror_nodesc' => 'Geef alstublieft een beschrijving voor de video op.',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Frokor
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'youtubeauthsub' => 'Last opp YouTube-video',
	'youtubeauthsub-desc' => 'Lar brukarar [[Special:YouTubeAuthSub|laste opp videoar]] på YouTube',
	'youtubeauthsub_info' => 'For å laste opp ein video på YouTube for bruk på ei side, fyll inn følgjande informasjon:',
	'youtubeauthsub_title' => 'Tittel',
	'youtubeauthsub_description' => 'Skildring',
	'youtubeauthsub_password' => 'YouTube-passord',
	'youtubeauthsub_username' => 'YouTube-brukarnamn',
	'youtubeauthsub_keywords' => 'Nøkkelord',
	'youtubeauthsub_category' => 'Kategori',
	'youtubeauthsub_submit' => 'Lagre',
	'youtubeauthsub_clickhere' => 'Klikk her for å logge inn på YouTube',
	'youtubeauthsub_tokenerror' => 'Feil i oppretting av godkjenningsteikn; prøv å oppdatere.',
	'youtubeauthsub_success' => 'Gratulerer!
Videoen din er lasta opp.
<a href="http://youtube.com/watch?v=$1">Sjå videoen din</a>.
Det kan ta litt tid før YouTube har handsama videoen din, så det kan hende han ikkje er klar enno.

Sett inn følgjande kode på ei side for å inkludere videoen på ei side på wikien:
<code>{{&#35;ev:youtube|$1}}</code>',
	'youtubeauthsub_authsubinstructions' => 'For å laste opp ein video må du første logge inn på YouTube.',
	'youtubeauthsub_uploadhere' => 'Last opp videoen din herfrå:',
	'youtubeauthsub_uploadbutton' => 'Last opp',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}

[http://youtube.com/watch?v=$1 Sjå denne videoen]',
	'youtubeauthsub_summary' => 'Lastar opp YouTube-video',
	'youtubeauthsub_uploading' => 'Videoen din lastar opp. Ver snill og vent.',
	'youtubeauthsub_viewpage' => 'Alternativt kan du [[$1|sjå videoen din]].',
	'youtubeauthsub_jserror_nokeywords' => 'Skriv inn eitt eller fleire nøkkelord.',
	'youtubeauthsub_jserror_notitle' => 'Velg ein tittel for videoen.',
	'youtubeauthsub_jserror_nodesc' => 'Skriv inn ei skildring av videoen.',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'youtubeauthsub' => 'Importar una vidèo YouTube',
	'youtubeauthsub-desc' => "Permet als utilizaires de [[Special:YouTubeAuthSub|d'importar de vidèos]] dirèctament sus YouTube",
	'youtubeauthsub_info' => "Per importar una vidèo sus YouTube per l'incorporar dins una pagina, entresenhatz las informacions seguentas :",
	'youtubeauthsub_title' => 'Títol',
	'youtubeauthsub_description' => 'Descripcion',
	'youtubeauthsub_password' => 'Senhal sus YouTube',
	'youtubeauthsub_username' => 'Nom d’utilizaire sus YouTube',
	'youtubeauthsub_keywords' => 'Mots claus',
	'youtubeauthsub_category' => 'Categoria',
	'youtubeauthsub_submit' => 'Sometre',
	'youtubeauthsub_clickhere' => 'Clicatz aicí per vos connectar sus YouTube',
	'youtubeauthsub_tokenerror' => 'Error dins la creacion de la presa d’autorizacion, ensajatz de refrescar la pagina.',
	'youtubeauthsub_success' => "Felicitacions :
Vòstra vidèo es importada.
<a href='http://www.youtube.com/watch?v=$1'>Visionatz vòstra vidèo</a>.
YouTube pòt demandar un brieu de temps per prendre en compte vòstra vidèo, tanben, pòt èsser pas encara prèst.

Per incorporar vòstra vidèo dins una pagina del wiki, inserissètz lo còde seguent dins aquesta darrièra :
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Per importar una vidèo, vos serà demandat de vos connectar d’en primièr sus YouTube.',
	'youtubeauthsub_uploadhere' => 'Importar vòstra vidèo dempuèi aicí :',
	'youtubeauthsub_uploadbutton' => 'Importar',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Vejatz aquesta vidèo]',
	'youtubeauthsub_summary' => 'Importar una vidèo YouTube',
	'youtubeauthsub_uploading' => 'Vòstra vidèo es en cors d’importacion.
Siatz pacient.',
	'youtubeauthsub_viewpage' => 'Siquenon, podètz [[$1|visionar vòstra vidèo]].',
	'youtubeauthsub_jserror_nokeywords' => 'Mercés de picar un o mantun mot clau.',
	'youtubeauthsub_jserror_notitle' => 'Mercés de picar un títol per la vidèo.',
	'youtubeauthsub_jserror_nodesc' => 'Picatz una descripcion per la vidèo.',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Psubhashish
 */
$messages['or'] = array(
	'youtubeauthsub_title' => 'ଶିରୋନାମା',
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'youtubeauthsub_title' => 'Сæргонд',
	'youtubeauthsub_description' => 'Афыст',
	'youtubeauthsub_password' => 'YouTube-æй пароль',
	'youtubeauthsub_username' => 'YouTube-æй архайæджы ном',
	'youtubeauthsub_category' => 'Категори',
	'youtubeauthsub_submit' => 'Афтæ уæд',
	'youtubeauthsub_uploadhere' => 'Дæ видео ам сæвæр:',
	'youtubeauthsub_uploadbutton' => 'Сæвæр',
	'youtubeauthsub_jserror_notitle' => 'Дæ хорзæхæй, дæ видеойæн сæргонд ныффысс.',
	'youtubeauthsub_jserror_nodesc' => 'Дæ хорзæхæй, дæ видео сфысс.',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'youtubeauthsub_title' => 'Titel',
	'youtubeauthsub_password' => 'YouTube-Paesswatt',
	'youtubeauthsub_keywords' => 'Keywadde',
	'youtubeauthsub_category' => 'Abdeeling',
	'youtubeauthsub_uploadbutton' => 'Ufflaade',
);

/** Polish (Polski)
 * @author Sp5uhe
 * @author Wpedzich
 */
$messages['pl'] = array(
	'youtubeauthsub' => 'Prześlij plik wideo YouTube',
	'youtubeauthsub-desc' => 'Pozwala użytkownikom na [[Special:YouTubeAuthSub|przesyłanie plików wideo]] bezpośrednio do serwisu YouTube',
	'youtubeauthsub_info' => 'By przesłać do serwisu YouTube plik wideo, który ma być potem wykorzystywany na stronach wiki, podaj poniższe informacje:',
	'youtubeauthsub_title' => 'Tytuł',
	'youtubeauthsub_description' => 'Opis',
	'youtubeauthsub_password' => 'Hasło do serwisu YouTube',
	'youtubeauthsub_username' => 'Nazwa użytkownika w serwisie YouTube',
	'youtubeauthsub_keywords' => 'Słowa kluczowe',
	'youtubeauthsub_category' => 'Kategoria',
	'youtubeauthsub_submit' => 'Prześlij',
	'youtubeauthsub_clickhere' => 'Kliknij, by zalogować się do serwisu YouTube',
	'youtubeauthsub_tokenerror' => 'Podczas generowania tokenu uwierzytelniającego wystąpił błąd. Spróbuj załadować stronę jeszcze raz.',
	'youtubeauthsub_success' => "Gratulacje!
Twój plik wideo został przesłany.
<a href='http://www.youtube.com/watch?v=$1'>Podgląd przesłanego pliku</a>.
Serwis YouTube może potrzebować na przetworzenie tego pliku nieco czasu, więc materiał może nie być jeszcze dostępny.

Jeśli chcesz dołączyć przesłany plik wideo do materiału w serwisie wiki, wstaw na żądaną stronę kod
<code>{{&#35;ev:youtube|$1}}</code>.",
	'youtubeauthsub_authsubinstructions' => 'Jeśli chcesz przesłać plik, najpierw musisz zalogować sie do serwisu YouTube.',
	'youtubeauthsub_uploadhere' => 'Plik wideo możesz przesłać z następującej lokalizacji:',
	'youtubeauthsub_uploadbutton' => 'Prześlij',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Zobacz film].',
	'youtubeauthsub_summary' => 'Przesyłanie pliku wideo YouTube',
	'youtubeauthsub_uploading' => 'Pliki wideo są przesyłane.
Czekaj.',
	'youtubeauthsub_viewpage' => 'Swój plik wideo możesz również zobaczyć [[$1|tutaj]].',
	'youtubeauthsub_jserror_nokeywords' => 'Wprowadź jedno lub więcej słów kluczowych.',
	'youtubeauthsub_jserror_notitle' => 'Wprowadź tytuł materiału wideo.',
	'youtubeauthsub_jserror_nodesc' => 'Wprowadź opis materiału wideo.',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 */
$messages['pms'] = array(
	'youtubeauthsub' => 'Caria un filmà YouTube',
	'youtubeauthsub-desc' => "A lassa che j'utent a [[Special:YouTubeAuthSub|cario dij filmà]] diret su You Tube",
	'youtubeauthsub_info' => "Për carié un filmà su YouTube për anserilo an na pàgina, ch'a daga j'anformassion sì-dapress:",
	'youtubeauthsub_title' => 'Tìtol',
	'youtubeauthsub_description' => 'Descrission',
	'youtubeauthsub_password' => 'Soa ciav su YouTube',
	'youtubeauthsub_username' => 'Sò stranòm su YouTube',
	'youtubeauthsub_keywords' => 'Paròle ciav',
	'youtubeauthsub_category' => 'Categorìa',
	'youtubeauthsub_submit' => 'Manda',
	'youtubeauthsub_clickhere' => 'Sgnaché ambelessì për rintré an YouTube',
	'youtubeauthsub_tokenerror' => "Eror durant l'arcesta d'autorisassion, sërché d'agiorné la pàgina",
	'youtubeauthsub_success' => "Congratulassion!
Sò filmà a l'é carià.
<a href='http://www.youtube.com/watch?v=$1'>Ch'a bèica sò filmà</a>.
Peul desse che YouTube a l'abia damanca d'un pòch ëd temp për livré la procedura su sò filmà, a l'é donca possìbil ch'a sia ancor nen disponìbil.

Për anserì sò filmà an na pàgina dla wiki, ch'a buta ël còdes sì-dapress ant la pàgina:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Për carié un filmà, a-j sarà prima ciamà ëd rintré su YouTube.',
	'youtubeauthsub_uploadhere' => "Carié sò filmà d'ambelessì:",
	'youtubeauthsub_uploadbutton' => 'Carié',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Beiché cost filmà]',
	'youtubeauthsub_summary' => 'Carié un filmà YouTube',
	'youtubeauthsub_uploading' => "Sò filmà a l'é an camin ch'as caria.
Për piasì, ch'a l'abia passiensa",
	'youtubeauthsub_viewpage' => 'Dësnò, a peul [[$1|beiché sò filmà]].',
	'youtubeauthsub_jserror_nokeywords' => "Për piasì, ch'a buta un-a o pì paròle ciav.",
	'youtubeauthsub_jserror_notitle' => "Për piasì, ch'a buta un tìtol al filmà.",
	'youtubeauthsub_jserror_nodesc' => "Për piasì, ch'a buta na descrission për ël filmà.",
);

/** Pontic (Ποντιακά)
 * @author Omnipaedista
 * @author Sinopeus
 */
$messages['pnt'] = array(
	'youtubeauthsub_title' => 'Τίτλον',
	'youtubeauthsub_description' => 'Περιγραφήν',
	'youtubeauthsub_category' => 'Κατηγορίαν',
	'youtubeauthsub_submit' => 'Στείλον',
	'youtubeauthsub_uploadbutton' => 'Φόρτωμαν',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'youtubeauthsub' => 'د يوټيوب ويډيو پورته کول',
	'youtubeauthsub-desc' => 'يو کارن په دې توانوي چې يوټيوب ته راساً [[Special:YouTubeAuthSub|ويډيوګانې ورپورته کړي]]',
	'youtubeauthsub_info' => 'يوټيوب (YouTube) کې د يوې ويډيو د پورته کولو او بيا په يوه مخ کې د ويډيو ورټومبلو لپاره، د مالوماتو اړونده ځايونه ډک کړۍ:',
	'youtubeauthsub_title' => 'سرليک',
	'youtubeauthsub_description' => 'څرګندونه',
	'youtubeauthsub_password' => 'د يوټيوب پټنوم',
	'youtubeauthsub_username' => 'د يوټيوب کارن-نوم',
	'youtubeauthsub_keywords' => 'آروييونه',
	'youtubeauthsub_category' => 'وېشنيزه',
	'youtubeauthsub_submit' => 'سپارل',
	'youtubeauthsub_clickhere' => 'يوټيوب کې د ننوتلو لپاره دلته وټوکۍ',
	'youtubeauthsub_success' => "مبارک مو شه!

ستاسې ويډيو په برياليتوب سره پورته شوه.
<a href='http://www.youtube.com/watch?v=$1'>خپله ويډيو دلته وګورۍ</a>.
د نوې ويډيو په چمتو کولو کې لږ وخت لږېږي، نو کېدای شي چې ستاسې ويډيو لا تر اوسه نه وي چمتو شوې.

که چېرته د ويکي په يو مخ باندې خپله ويډيو ورټومبل غواړۍ، نو په هماغه مخ کې دغه لاندينی کوډ ورګډ کړی:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'ددې لپاره چې يوه ويډيو پورته کړی، نو تاسې ته پکار ده چې لومړی په يوټيوب کې ننوځۍ.',
	'youtubeauthsub_uploadhere' => 'خپله ويډيو له دې ځاي نه پورته کړی:',
	'youtubeauthsub_uploadbutton' => 'پورته کول',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 همدا ويډيو وګورۍ]',
	'youtubeauthsub_summary' => 'د يوټيوب ويډيو ورپورته کول',
	'youtubeauthsub_uploading' => 'ستاسې ويډيو د پورته کېدلو په حال کې ده.

لطفاً لږ صبر وکړی.',
	'youtubeauthsub_viewpage' => 'په اختياري توګه، تاسې [[$1|خپله ويډيو کتلای شی]].',
	'youtubeauthsub_jserror_nokeywords' => 'لطفاً يوه او يا څو آروييونه وليکۍ.',
	'youtubeauthsub_jserror_notitle' => 'لطفاً د ويډيو لپاره مو يو سرليک ورکړی.',
	'youtubeauthsub_jserror_nodesc' => 'مهرباني وکړۍ د ويډيو څرګندونه مو وکړۍ.',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'youtubeauthsub' => 'Carregar vídeo do YouTube',
	'youtubeauthsub-desc' => 'Permite que os utilizadores [[Special:YouTubeAuthSub|carreguem vídeos]] directamente para o YouTube',
	'youtubeauthsub_info' => 'Para carregar um vídeo para o YouTube para incluir numa página, preencha a informação seguinte:',
	'youtubeauthsub_title' => 'Título',
	'youtubeauthsub_description' => 'Descrição',
	'youtubeauthsub_password' => 'Palavra-chave no YouTube',
	'youtubeauthsub_username' => 'Nome de utilizador no YouTube',
	'youtubeauthsub_keywords' => 'Palavras-chave',
	'youtubeauthsub_category' => 'Categoria',
	'youtubeauthsub_submit' => 'Enviar',
	'youtubeauthsub_clickhere' => 'Carregue aqui para se ligar ao YouTube',
	'youtubeauthsub_tokenerror' => 'Erro ao gerar o token de autorização. Tente refrescar a página.',
	'youtubeauthsub_success' => "Parabéns!
O seu vídeo foi carregado.
<a href='http://www.youtube.com/watch?v=$1'>Ver o seu vídeo</a>.
O YouTube pode necessitar de algum tempo para processar o seu vídeo, e este pode ainda não estar disponível.

Para incluir o seu vídeo numa página da wiki, insira o seguinte código numa página:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Para carregar um vídeo, será necessário que se autentique primeiro no YouTube.',
	'youtubeauthsub_uploadhere' => 'Carregar o seu vídeo a partir de:',
	'youtubeauthsub_uploadbutton' => 'Carregar',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Ver este vídeo]',
	'youtubeauthsub_summary' => 'A carregar vídeo YouTube',
	'youtubeauthsub_uploading' => 'O seu vídeo está a ser carregado.
Por favor seja paciente.',
	'youtubeauthsub_viewpage' => 'Como alternativa, pode [[$1|ver o seu vídeo]].',
	'youtubeauthsub_jserror_nokeywords' => 'Por favor, introduza 1 ou mais palavras-chave.',
	'youtubeauthsub_jserror_notitle' => 'Por favor, introduza um título para o vídeo.',
	'youtubeauthsub_jserror_nodesc' => 'Por favor, introduza uma descrição para o vídeo.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'youtubeauthsub' => 'Carregar vídeo do YouTube',
	'youtubeauthsub-desc' => 'Permite aos usuários [[Special:YouTubeAuthSub|carregar vídeos]] diretamente no TouTube',
	'youtubeauthsub_info' => 'Para carregar um vídeo para o YouTube para incluir numa página, preencha a seguinte informação:',
	'youtubeauthsub_title' => 'Título',
	'youtubeauthsub_description' => 'Descrição',
	'youtubeauthsub_password' => 'Palavra-chave no YouTube',
	'youtubeauthsub_username' => 'Nome de utilizador no YouTube',
	'youtubeauthsub_keywords' => 'Palavras-chave',
	'youtubeauthsub_category' => 'Categoria',
	'youtubeauthsub_submit' => 'Enviar',
	'youtubeauthsub_clickhere' => 'Clique aqui para se autenticar no YouTube',
	'youtubeauthsub_tokenerror' => 'Erro ao gerar o token de autorização. Tente atualizar a página.',
	'youtubeauthsub_success' => "Parabéns!
O seu vídeo foi carregado.
<a href='http://www.youtube.com/watch?v=$1'>Veja o seu video</a>.
O YouTube pode necessitar de algum tempo para processar o seu vídeo, de modo que poderá não estar já disponível.

Para incluir o seu vídeo numa página da wiki, insira o seguinte código numa página:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Para carregar um vídeo, será necessário que se autentique primeiro no YouTube.',
	'youtubeauthsub_uploadhere' => 'Carregar o seu vídeo a partir de:',
	'youtubeauthsub_uploadbutton' => 'Carregar',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Veja este vídeo]',
	'youtubeauthsub_summary' => 'Carregando vídeo no YouTube',
	'youtubeauthsub_uploading' => 'O seu vídeo está sendo carregado.
Por favor seja paciente.',
	'youtubeauthsub_viewpage' => 'Como alternativa, você pode [[$1|ver o seu vídeo]].',
	'youtubeauthsub_jserror_nokeywords' => 'Por favor, introduza 1 ou mais palavras-chave.',
	'youtubeauthsub_jserror_notitle' => 'Por favor, introduza um título para o vídeo.',
	'youtubeauthsub_jserror_nodesc' => 'Por favor, introduza uma descrição para o vídeo.',
);

/** Romanian (Română)
 * @author Emily
 * @author KlaudiuMihaila
 * @author Mihai
 */
$messages['ro'] = array(
	'youtubeauthsub' => 'Încarcă video YouTube',
	'youtubeauthsub-desc' => 'Permite utilizatorilor să [[Special:YouTubeAuthSub|încarce videoclipuri]] direct la YouTube',
	'youtubeauthsub_info' => 'Pentru a încărca un video la YouTube, pentru a-l include într-o pagină, completați următoarele informații:',
	'youtubeauthsub_title' => 'Titlu',
	'youtubeauthsub_description' => 'Descriere',
	'youtubeauthsub_password' => 'Parolă YouTube',
	'youtubeauthsub_username' => 'Nume de utilizator YouTube',
	'youtubeauthsub_keywords' => 'Cuvinte cheie',
	'youtubeauthsub_category' => 'Categorie',
	'youtubeauthsub_submit' => 'Aplică',
	'youtubeauthsub_clickhere' => 'Apasă aici pentru a te autentifica la YouTube',
	'youtubeauthsub_tokenerror' => 'Eroare la generarea autentificării, apăsați butonul refresh.',
	'youtubeauthsub_success' => "Felicitări!
Fișierul video este încărcat.
<a href='http://www.youtube.com/watch?v=$1'>Vezi fișierul video</a>.
Uneori YouTube are nevoie de timp pentru a procesa fișierul tău, astfel că acesta poate să nu fie disponibil imediat.

Pentru a include fișierul tău într-o pagină wiki, introdu acest cod:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Pentru a încărca un fișier video sunteți rugați să vă logați la YouTube.',
	'youtubeauthsub_uploadhere' => 'Încarcă fișierul video de aici:',
	'youtubeauthsub_uploadbutton' => 'Încarcă',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Vizualizează acest videoclip]',
	'youtubeauthsub_summary' => 'Încărcare video YouTube',
	'youtubeauthsub_uploading' => 'Videoclipul dumneavoastră este în curs de încărcare.
Vă rugăm să aveți răbdare.',
	'youtubeauthsub_viewpage' => 'Alternativ, puteți [[$1|vizualiza fișierul video]].',
	'youtubeauthsub_jserror_nokeywords' => 'Vă rugăm să introduceți cel puțin un cuvânt cheie.',
	'youtubeauthsub_jserror_notitle' => 'Vă rugăm să introduceți un titlu pentru videoclip.',
	'youtubeauthsub_jserror_nodesc' => 'Vă rugăm să introduceți o descriere pentru videoclip.',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'youtubeauthsub' => 'Careche ìnu video de YouTube',
	'youtubeauthsub-desc' => "Permitte a l'utinde de [[Special:YouTubeAuthSub|carecà le filmete]] direttamende sus a YouTube",
	'youtubeauthsub_info' => "Pe carecà 'nu filmete sus a YouTube da mettere jndr'à 'na pàgene, mitte le 'mbormaziune ca avènene mò:",
	'youtubeauthsub_title' => 'Titele',
	'youtubeauthsub_description' => 'Descrizione',
	'youtubeauthsub_password' => 'Password de YouTube',
	'youtubeauthsub_username' => 'Nome utende de YouTube',
	'youtubeauthsub_keywords' => 'Parole chiave',
	'youtubeauthsub_category' => 'Categorije',
	'youtubeauthsub_submit' => 'Conferme',
	'youtubeauthsub_clickhere' => 'Cazze aqquà pe collegarte sus a YouTube',
	'youtubeauthsub_tokenerror' => "Errore mendre ca ste ccrejeve 'u gettone pe l'autorizzazione, reprueve a aggiornà.",
	'youtubeauthsub_success' => "Comblimende!
'U filmete tue ha state carechete.
<a href='http://www.youtube.com/watch?v=$1'>Vide 'u filmete</a>.
YouTube pò mettere 'nu picche de timbe pe processà 'u filmete tue, accussì pò essere ca angore non g'è pronde.

Pe ingludere 'u filmete tue jndr'à 'na pàgene sus a Uicchi, mitte 'u codece ca avène jndr'à pàgene:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => "Pe carecà 'nu filmete sus a YouTube, apprime t'à collegà.",
	'youtubeauthsub_uploadhere' => "Careche 'u video tue d'aqquà:",
	'youtubeauthsub_uploadbutton' => 'Careche',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Vide stu filmete]',
	'youtubeauthsub_summary' => "Stoche a careche 'u video de YouTube",
	'youtubeauthsub_uploading' => "'U filmete tue ste avene carechete.
Pe piacere puerte 'nu picche de pascenze.",
	'youtubeauthsub_viewpage' => "In alternative, tu puè [[$1|vedè 'u filmete tue]].",
	'youtubeauthsub_jserror_nokeywords' => 'Pe piacere mitte 1 o cchiù parole chiave',
	'youtubeauthsub_jserror_notitle' => "Pe piacere mitte 'nu titele p'u video.",
	'youtubeauthsub_jserror_nodesc' => "Pe piacere mitte 'na descrizione p'u filmete.",
);

/** Russian (Русский)
 * @author Ahonc
 * @author Ferrer
 * @author Innv
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'youtubeauthsub' => 'Загрузка видео YouTube',
	'youtubeauthsub-desc' => 'Позволяет участникам [[Special:YouTubeAuthSub|загружать видео]] напрямую в YouTube',
	'youtubeauthsub_info' => 'Чтобы загрузить видео на YouTube и вставить его на страницу, заполните следующие поля:',
	'youtubeauthsub_title' => 'Заголовок',
	'youtubeauthsub_description' => 'Описание',
	'youtubeauthsub_password' => 'Пароль на YouTube',
	'youtubeauthsub_username' => 'Имя пользователя на YouTube',
	'youtubeauthsub_keywords' => 'Ключевые слова',
	'youtubeauthsub_category' => 'Категория',
	'youtubeauthsub_submit' => 'Отправить',
	'youtubeauthsub_clickhere' => 'Нажмите здесь, чтобы войти в YouTube',
	'youtubeauthsub_tokenerror' => 'ошибка создания токена авторизации, попробуйте обновить страницу.',
	'youtubeauthsub_success' => "Поздравляем!
Ваше видео загружено.
<a href='http://www.youtube.com/watch?v=$1'>Просмотреть видео</a>.
YouTube, возможно, будет некоторое время обрабатывать ваше видео, поэтому оно может быть недоступно прямо сейчас.

Чтобы добавить ваше видео на вики-страницу, вставьте на страницу следующий код:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Чтобы загрузить видео, вам необходимо сначала зайти/зарегистрироваться в YouTube.',
	'youtubeauthsub_uploadhere' => 'Загрузить ваше видео отсюда:',
	'youtubeauthsub_uploadbutton' => 'Загрузить',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Просмотреть это видео]',
	'youtubeauthsub_summary' => 'Загрузка видео YouTube',
	'youtubeauthsub_uploading' => 'Ваше видео загружается.
Пожалуйста, подождите.',
	'youtubeauthsub_viewpage' => 'Также, вы можете [[$1|просмотреть ваше видео]].',
	'youtubeauthsub_jserror_nokeywords' => 'Пожалуйста, введите одно или несколько ключевых слов.',
	'youtubeauthsub_jserror_notitle' => 'Пожалуйста, введите название видео.',
	'youtubeauthsub_jserror_nodesc' => 'Пожалуйста, введите описание видео.',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'youtubeauthsub' => 'Награти відео YouTube',
	'youtubeauthsub-desc' => 'Доволює хоснователям [[Special:YouTubeAuthSub|награти відео]] прямо до YouTube',
	'youtubeauthsub_title' => 'Назва',
	'youtubeauthsub_description' => 'Попис',
	'youtubeauthsub_password' => 'Гесло на YouTube',
	'youtubeauthsub_username' => 'Мено хоснователя на YouTube',
	'youtubeauthsub_keywords' => 'Ключовы слова',
	'youtubeauthsub_category' => 'Катеґорія',
	'youtubeauthsub_submit' => 'Послати',
	'youtubeauthsub_clickhere' => 'Кликнутём ту ся приголосите до YouTube',
	'youtubeauthsub_success' => "Ґратулуєме!
Ваше відео є награте.
<a href='http://www.youtube.com/watch?v=$1'>Посмотьте ся на ваше відео</a>.
YouTube може даякый час тырвати, покы ся ваше відео зпрацує, также іщі не є приправлене.

Відео можете на вікі сторінку вложыти помочов наслїдуючого коду:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Жебы сьте могли награти відео, мусите ся наперед приголосити на YouTube.',
	'youtubeauthsub_uploadhere' => 'Награйте своє відео стады:',
	'youtubeauthsub_uploadbutton' => 'Награти',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Посмотрити відео]',
	'youtubeauthsub_summary' => 'Награвать ся відео YouTube',
	'youtubeauthsub_uploading' => 'Ваше відео ся награвать.
Просиме, почекайте.',
	'youtubeauthsub_viewpage' => 'Інакше, тыж собі можете [[$1|посмотрити ваше відео]].',
	'youtubeauthsub_jserror_nokeywords' => 'Просиме, задайте єдно або веце ключовых слов.',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'youtubeauthsub' => 'YouTube-ка видео хачайдааһын',
	'youtubeauthsub_category' => 'Категория',
);

/** Sardinian (Sardu)
 * @author Andria
 * @author Marzedu
 */
$messages['sc'] = array(
	'youtubeauthsub_title' => 'Tìtulu',
	'youtubeauthsub_description' => 'Descritzione',
	'youtubeauthsub_password' => 'Password de YouTube',
	'youtubeauthsub_username' => 'Nòmene usuàriu de YouTube',
	'youtubeauthsub_category' => 'Categoria',
);

/** Sicilian (Sicilianu)
 * @author Santu
 */
$messages['scn'] = array(
	'youtubeauthsub' => "Càrica vìdiu supr'a YouTube",
	'youtubeauthsub-desc' => "Pirmetti a l'utenti di [[Special:YouTubeAuthSub|caricari vìdiu]] direttamenti supr'a YouTube",
	'youtubeauthsub_info' => "Pi caricari nu vìdiu supr'a YouTube pi mittìrilu nti na pàggina, nzirisci li nfurmazzioni ccà di sècutu:",
	'youtubeauthsub_title' => 'Tìtulu',
	'youtubeauthsub_description' => 'Discrizzioni',
	'youtubeauthsub_password' => 'Password di YouTube',
	'youtubeauthsub_username' => 'Nomu utenti di YouTube',
	'youtubeauthsub_keywords' => 'Palori chiavi',
	'youtubeauthsub_category' => 'Catigurìa',
	'youtubeauthsub_submit' => 'Manna',
	'youtubeauthsub_clickhere' => 'Fà clic ccà pi fari lu log in supra a YouTube',
	'youtubeauthsub_tokenerror' => 'Sbagghiu ntô ginirari lu token di pirmessu, prova a aggiurnari.',
	'youtubeauthsub_success' => "Bravu, cumprimenti! 
Lu tò vìdiu vinni caricatu. 
Pi taliari lu tò vìdiu hà fari clic <a href='http://www.youtube.com/watch?v=$1'>ccà</a>.
YouTube putissi addumannari anticchia di tempu pi elabburari lu tò vìdiu, pi chissu  putissi èssiri ca ancora non è prontu.

Pi mèttiri lu tò vìdiu nti na pàggina dâ wiki, nzirisci nti na pàggina lu còdici ccà di sècutu: <code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Pi caricari nu vìdiu ti veni addumannatu di fari prima lu log in a YouTube.',
	'youtubeauthsub_uploadhere' => 'Càrica lu tò vìdiu di ccà:',
	'youtubeauthsub_uploadbutton' => 'Càrica',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

Stu vìdiu pò èssiri taliatu [http://www.youtube.com/watch?v=$1 ccà]',
	'youtubeauthsub_summary' => 'Caricamentu vìdiu YouTube',
	'youtubeauthsub_uploading' => 'Lu tò vìdiu si sta caricannu.
Hà aviri pacenzia.',
	'youtubeauthsub_viewpage' => 'Poi taliari lu tò vìdiu macari [[$1|ccà]].',
	'youtubeauthsub_jserror_nokeywords' => "Nzirisci n'àutra palora chiavi.",
	'youtubeauthsub_jserror_notitle' => 'Nzirisci nu tìtulu pô vìdiu.',
	'youtubeauthsub_jserror_nodesc' => 'Nzirisci na spiecazzioni pô vìdiu.',
);

/** Serbo-Croatian (Srpskohrvatski)
 * @author OC Ripper
 */
$messages['sh'] = array(
	'youtubeauthsub_submit' => 'Unesi',
);

/** Sinhala (සිංහල)
 * @author Asiri wiki
 * @author Calcey
 * @author චතුනි අලහප්පෙරුම
 * @author රොමානිස් සැමුවෙල්
 */
$messages['si'] = array(
	'youtubeauthsub' => 'YouTube වීඩියෝව උඩුගතකරන්න',
	'youtubeauthsub-desc' => 'පරිශීලකයින්ට ඍජුවම YouTube වෙත  [[Special:YouTubeAuthSub|වීඩියෝ උඩුගත කිරීම]]ට ඉඩ හරියි.',
	'youtubeauthsub_info' => 'පිටුවකට කිරීම සඳහා YouTube වෙත වීඩියෝවක් උඩුගත කිරීමට,පහත තොරතුරු පුරවන්න:',
	'youtubeauthsub_title' => 'ශීර්ෂය',
	'youtubeauthsub_description' => 'විස්තරය',
	'youtubeauthsub_password' => 'YouTube මුරපදය',
	'youtubeauthsub_username' => 'YouTube පරිශීලක නාමය',
	'youtubeauthsub_keywords' => 'මූලපද',
	'youtubeauthsub_category' => 'වර්ගය',
	'youtubeauthsub_submit' => 'යොමන්න',
	'youtubeauthsub_clickhere' => 'YouTube වෙත පිවිසීම‍ට ‍මෙතැන ක්ලික් කරන්න',
	'youtubeauthsub_tokenerror' => 'වරදාන ටෝකනය ‍සදොස් ය, නැවුම් කර යළි උත්සහ කරන්න.',
	'youtubeauthsub_success' => "සුබ පැතුම්!
ඔබේ වීඩියෝව උ‍‍ඩුගතවී ඇත.
ඔබේ වීඩියෝව නැරඹීම‍ට <a href='http://www.youtube.com/watch?v=$1'> මෙතැන </a>.ක්ලික් කරන්න.
ඔබේ වීඩියෝව සැකසීමට YouTube සඳහා යම් කාලයක් අවශ්‍ය විය හැකි බැවින්,එය තවමත් සුදානම් නොමඅති විය හැක. 

වීඩියෝව ඔබගේ විකි පිටුවකට යෙදීමක‍ට නම් පහත දැක්වෙන කේත පි‍ටුව‍ට ඇතුල් කරන්න:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => ' වීඩියෝවත් උඩුගත කිරීමට,ඔබ ප්‍රථමයෙන්ම YouTube වෙත පිවිසිය යුතුය.',
	'youtubeauthsub_uploadhere' => 'ඔබේ වීඩීයෝව මෙතැනින් උඩුගතකරන්න:',
	'youtubeauthsub_uploadbutton' => 'උඩුගතකරන්න',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.
‍[මෙම වීඩියෝව http://www.youtube.com/watch?v=$1 ] මෙතැනින් නැරඹීය හැකිය.',
	'youtubeauthsub_summary' => 'YouTube වීඩියෝව උඩුගත වෙමින් පවතී',
	'youtubeauthsub_uploading' => 'ඔබගේ වීඩියෝව උඩුගත වෙමින් පවතී,මඳක් ඉවසන්න.',
	'youtubeauthsub_viewpage' => 'විකල්ප ලෙසින්, ඔබට [[$1|ඔබගේ වීඩියෝව නැරඹුම]] කල හැක.',
	'youtubeauthsub_jserror_nokeywords' => 'කරුණාකර 1 හෝ ඊට වඩා මූලපද ගනනක් ඇතුලත් කරන්න.',
	'youtubeauthsub_jserror_notitle' => 'කරුණාකර විඩියාව සඳහා ශීර්ෂයක් සපයන්න.',
	'youtubeauthsub_jserror_nodesc' => 'කරුණාකර විඩියෝව සඳහා විස්තරයක් සපයන්න.',
);

/** Slovak (Slovenčina)
 * @author Helix84
 * @author Rudko
 */
$messages['sk'] = array(
	'youtubeauthsub' => 'Nahrať video YouTube',
	'youtubeauthsub-desc' => 'Umožňuje používateľom [[Special:YouTubeAuthSub|nahrávať vidá]] priamo na YouTube',
	'youtubeauthsub_info' => 'Aby ste mohli nahrať video na YouTube, ktoré použijete na stránke, vyplňte nasledovné informácie:',
	'youtubeauthsub_title' => 'Názov',
	'youtubeauthsub_description' => 'Popis',
	'youtubeauthsub_password' => 'YouTube heslo',
	'youtubeauthsub_username' => 'Používateľské meno na YouTube',
	'youtubeauthsub_keywords' => 'Kľúčové slová',
	'youtubeauthsub_category' => 'Kategória',
	'youtubeauthsub_submit' => 'Poslať',
	'youtubeauthsub_clickhere' => 'Kliknutím sem sa prihlásite na YouTube',
	'youtubeauthsub_tokenerror' => 'Chyba pri vytváraní autentifikačného tokenu. Skúste obnoviť stránku.',
	'youtubeauthsub_success' => "Gratulujeme!
Vaše video je nahrané.
Svoje video si môžete pozrieť po <a href='http://www.youtube.com/watch?v=$1'>kliknutí sem</a>.
YouTube môže nejaký čas trvať, kým vaše video spracuje, takže možno ešte nie je pripravené.

Video na wiki stránku môžete vložiť pomocou nasledovného kódu:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Aby ste mohli nahrať video, budete sa musieť najprv prihlásiť na YouTube.',
	'youtubeauthsub_uploadhere' => 'Nahrajte svoje video odtiaľto:',
	'youtubeauthsub_uploadbutton' => 'Nahrať',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Zobraziť video]',
	'youtubeauthsub_summary' => 'Nahráva sa video na YouTube',
	'youtubeauthsub_uploading' => 'Vaše video sa nahráva.
Buďte prosím trpezliví.',
	'youtubeauthsub_viewpage' => 'Inak si video môžete [[$1|pozrieť tu]].',
	'youtubeauthsub_jserror_nokeywords' => 'Prosím, zadajte jedno alebo viac kľúčových slov.',
	'youtubeauthsub_jserror_notitle' => 'Prosím, zadajte názov videa.',
	'youtubeauthsub_jserror_nodesc' => 'Prosím, zadajte popis videa.',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'youtubeauthsub' => 'Naložite video YouTube',
	'youtubeauthsub-desc' => 'Omogoča uporabnikom [[Special:YouTubeAuthSub|nalaganje videev]] neposredno na YouTube',
	'youtubeauthsub_info' => 'Za nalaganje videa na YouTube za uporabo na strani vnesite naslednje podatke:',
	'youtubeauthsub_title' => 'Naslov',
	'youtubeauthsub_description' => 'Opis',
	'youtubeauthsub_password' => 'Geslo YouTube',
	'youtubeauthsub_username' => 'Uporabniško ime YouTube',
	'youtubeauthsub_keywords' => 'Ključne besede',
	'youtubeauthsub_category' => 'Kategorija',
	'youtubeauthsub_submit' => 'Potrdi',
	'youtubeauthsub_clickhere' => 'Kliknite tukaj za prijavo v YouTube',
	'youtubeauthsub_tokenerror' => 'Napaka pri ustvarjanju overitvenega žetona, poskusite z osvežitvijo.',
	'youtubeauthsub_success' => "Čestitamo!
Vaš video je naložen.
<a href='http://www.youtube.com/watch?v=$1'>Oglejte si svoj video</a>.
YouTube lahko potrebuje nekaj časa, da obdela vaš video, zato morda še ni pripravljen.

Če želite vključiti vaš video na stran v wikiju, vstavite na stran naslednjo kodo:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Če želite naložiti video, se boste morali naprej prijaviti v YouTube',
	'youtubeauthsub_uploadhere' => 'Naložite vaš video od tukaj:',
	'youtubeauthsub_uploadbutton' => 'Naloži',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Oglej si ta video]',
	'youtubeauthsub_summary' => 'Nalaganje videa YouTube',
	'youtubeauthsub_uploading' => 'Vaš video se nalaga.
Prosimo, bodite potrpežljivi.',
	'youtubeauthsub_viewpage' => 'Lahko pa si [[$1|ogledate svoj video]].',
	'youtubeauthsub_jserror_nokeywords' => 'Prosimo, vnesite eno ali več ključnih besed.',
	'youtubeauthsub_jserror_notitle' => 'Prosimo, vnesite naslov videa.',
	'youtubeauthsub_jserror_nodesc' => 'Prosimo, vnesite opis videa.',
);

/** Lower Silesian (Schläsch)
 * @author Schläsinger
 * @author Äberlausitzer
 */
$messages['sli'] = array(
	'youtubeauthsub_title' => 'Tittel',
	'youtubeauthsub_description' => 'Beschreibung',
	'youtubeauthsub_password' => 'YouTube-Passwurt',
	'youtubeauthsub_username' => 'YouTube-Benutzernoame',
	'youtubeauthsub_category' => 'Kategorie',
);

/** Somali (Soomaaliga)
 * @author Maax
 */
$messages['so'] = array(
	'youtubeauthsub_category' => 'Qeybta',
);

/** Albanian (Shqip)
 * @author Puntori
 */
$messages['sq'] = array(
	'youtubeauthsub' => 'Ngarko YouTube video',
	'youtubeauthsub-desc' => 'Lejon përdoruesit të ngarkojnë [[Special:YouTubeAuthSub|video copa]] direkt në YouTube',
	'youtubeauthsub_info' => 'Për të ngarkuar video copa në YouTube e për të përfshirë në faqe, plotëso të dhënat në vijim:',
	'youtubeauthsub_title' => 'Titulli',
	'youtubeauthsub_description' => 'Përshkrimi',
	'youtubeauthsub_password' => 'YouTube fjalëkalimi',
	'youtubeauthsub_username' => 'YouTube identiteti',
	'youtubeauthsub_keywords' => 'Fjalët kyçe',
	'youtubeauthsub_category' => 'Kategoria',
	'youtubeauthsub_submit' => 'Dërgo',
	'youtubeauthsub_clickhere' => 'Kliko këtu për tu kyçur në YouTube',
	'youtubeauthsub_tokenerror' => 'Gabim në gjenerimin e shenjës së autorizimit, rifresko.',
	'youtubeauthsub_success' => "Urime!
Video copa juaj është ngarkuar.
<a href='http://www.youtube.com/watch?v=$1'>Shih video copën</a>.
Ndoshta YouTube ka nevojë për ca kohë për të përpunuar videon tuaj, pra ndoshta nuk është gati që tani.

Për të përfshirë video copën tuaj në një wiki faqe vendose kodin në vijim në faqe:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Për të ngarkuar video copë fillimisht duhet që të kyçeni në YouTube.',
	'youtubeauthsub_uploadhere' => 'Ngarkoni video copën tuaj nga këtu:',
	'youtubeauthsub_uploadbutton' => 'Ngarko',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Shiko këtë video]',
	'youtubeauthsub_summary' => 'Duke ngarkuar YouTube video',
	'youtubeauthsub_uploading' => 'Kjo video është duke u ngarkuar.
Ju lutemi keni durim.',
	'youtubeauthsub_viewpage' => 'Zgjedhore, mund të e [[$1|shikoni]] video copën tuaj.',
	'youtubeauthsub_jserror_nokeywords' => 'Ju lutemi vendosni 1 ose më shumë fjalë kyçe.',
	'youtubeauthsub_jserror_notitle' => 'Ju lutemi vendosni titull për video copën tuaj.',
	'youtubeauthsub_jserror_nodesc' => 'Ju lutemi vendosni përshkrim për video copën tuaj.',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Sasa Stefanovic
 * @author Јованвб
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'youtubeauthsub' => 'Отпреми снимак с Јутјуба',
	'youtubeauthsub-desc' => 'Омогућава корисницима да [[Special:YouTubeAuthSub|отпремају видео-снимке]] директно на Јутјуб',
	'youtubeauthsub_info' => 'Попуните следећи образац да бисте отпремили видео-снимак на Јутјуб и убацили га на страницу:',
	'youtubeauthsub_title' => 'Наслов',
	'youtubeauthsub_description' => 'Опис',
	'youtubeauthsub_password' => 'Лозинка на Јутјубу',
	'youtubeauthsub_username' => 'Корисничко име на Јутјубу',
	'youtubeauthsub_keywords' => 'Кључне речи',
	'youtubeauthsub_category' => 'Категорија',
	'youtubeauthsub_submit' => 'Пошаљи',
	'youtubeauthsub_clickhere' => 'Кликните овде да се пријавите на Јутјуб',
	'youtubeauthsub_tokenerror' => 'Грешка при стварању потврдног жетона. Покушајте поново.',
	'youtubeauthsub_success' => "Честитамо!
Ваш видео-снимак је отпремљен.
<a href='http://www.youtube.com/watch?v=$1'>Погледајте га овде</a>.
Видео-снимак можда неће бити одмах доступан, јер Јутјубу треба времена да га обради.

Да бисте убацили снимак на вики-страницу, унесите следећи код:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Да бисте отпремили видео-снимак, прво се пријавите на Јутјуб.',
	'youtubeauthsub_uploadhere' => 'Отпремите видео-снимак одавде:',
	'youtubeauthsub_uploadbutton' => 'Отпреми',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Погледајте видео-снимак]',
	'youtubeauthsub_summary' => 'Отпремање видео-снимка на Јутјуб',
	'youtubeauthsub_uploading' => 'Видео-снимак се отпрема. Будите стрпљиви.',
	'youtubeauthsub_viewpage' => 'Или пак можете да [[$1|погледате видео-снимак]].',
	'youtubeauthsub_jserror_nokeywords' => 'Унесите једну или више кључних речи.',
	'youtubeauthsub_jserror_notitle' => 'Унесите наслов видео-снимка.',
	'youtubeauthsub_jserror_nodesc' => 'Унесите опис видео-снимка.',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Rancher
 */
$messages['sr-el'] = array(
	'youtubeauthsub' => 'Slanje videa sa Jutuba',
	'youtubeauthsub-desc' => 'Omogući korisnicima da [[Special:YouTubeAuthSub|šalju videe]] direktno na Jutub',
	'youtubeauthsub_info' => 'Popunite sledeći obrazac da biste otpremili video-snimak na Jutjub i ubacili ga na stranicu:',
	'youtubeauthsub_title' => 'Naslov:',
	'youtubeauthsub_description' => 'Opis',
	'youtubeauthsub_password' => 'Lozinka na Jutubu',
	'youtubeauthsub_username' => 'Korisničko ime na Jutubu',
	'youtubeauthsub_keywords' => 'Ključne reči',
	'youtubeauthsub_category' => 'Kategorija',
	'youtubeauthsub_submit' => 'Prihvati',
	'youtubeauthsub_clickhere' => 'Kliknite ovde da biste se ulogovali na Jutub',
	'youtubeauthsub_tokenerror' => 'Greška pri generisanju autorizacionog ključa, pokušajte sa osveživanjem stranice.',
	'youtubeauthsub_success' => "Čestitamo!
Vaš video-snimak je otpremljen.
<a href='http://www.youtube.com/watch?v=$1'>Pogledajte ga ovde</a>.
Video-snimak možda neće biti odmah dostupan, jer Jutjubu treba vremena da ga obradi.

Da biste ubacili snimak na viki-stranicu, unesite sledeći kod:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Da biste otpremili video-snimak, prvo se prijavite na Jutjub.',
	'youtubeauthsub_uploadhere' => 'Otpremite video-snimak odavde:',
	'youtubeauthsub_uploadbutton' => 'Slanje',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Pogledajte video-snimak]',
	'youtubeauthsub_summary' => 'Slanje videa na Jutub.',
	'youtubeauthsub_uploading' => 'Video-snimak se otprema. Budite strpljivi.',
	'youtubeauthsub_viewpage' => 'Ili pak možete da [[$1|pogledate video-snimak]].',
	'youtubeauthsub_jserror_nokeywords' => 'Molimo Vas, unesite jednu ili više ključnih reči.',
	'youtubeauthsub_jserror_notitle' => 'Unesite naslov video-snimka.',
	'youtubeauthsub_jserror_nodesc' => 'Unesite opis video-snimka.',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'youtubeauthsub' => 'YouTube-Video hoochleede',
	'youtubeauthsub-desc' => 'Moaket dät foar Benutsere muugelk, Videos fluks tou YouTube [[Special:YouTubeAuthSub|hoochtouleeden]]',
	'youtubeauthsub_info' => 'Uum n Video tou YouTube hoochtouleeden, uum et ansluutend ap ne Siede ientoubäädjen, moast du do foulgjende Fäilde uutfälle:',
	'youtubeauthsub_title' => 'Tittel',
	'youtubeauthsub_description' => 'Beschrieuwenge',
	'youtubeauthsub_password' => 'YouTube-Paaswoud',
	'youtubeauthsub_username' => 'YouTube-Benutsernoome',
	'youtubeauthsub_keywords' => 'Koaiwoude',
	'youtubeauthsub_category' => 'Kategorie',
	'youtubeauthsub_submit' => 'Seende',
	'youtubeauthsub_clickhere' => 'Hier klikke toun Ienlogjen bie YouTube',
	'youtubeauthsub_tokenerror' => 'Failer bie dät Moakjen fon n Authorisierengstoken. Fersäik ju Siede näi tou leeden.',
	'youtubeauthsub_success' => "Grätlierje!
Dien Video wuud hoochleeden.
<a href='http://www.youtube.com/watch?v=$1'>Bekiekje dien Video</a>.
YouTube kuud wät Tied bruuke, uum dien Video tou feroarbaidjen, sodät ju Siede eventuell noch nit kloor is.

Uum dät Video ap ne Siede ientoubäädjen, föich foulgjenden Text ien:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Du moast die eerste bie YouTube ienlogje, uum n Video hoochtouleeden.',
	'youtubeauthsub_uploadhere' => 'Video fon deer hoochleede:',
	'youtubeauthsub_uploadbutton' => 'Hoochleede',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Dit Video bekiekje]',
	'youtubeauthsub_summary' => 'Leed YouTube-Video hooch',
	'youtubeauthsub_uploading' => 'Dien Video wäd fluks hoochleeden.
Ieuwen täiwe.',
	'youtubeauthsub_viewpage' => 'Alternativ koast du [[$1|dien Video bekiekje]].',
	'youtubeauthsub_jserror_nokeywords' => 'Reek een of moor Koaiwoude ien.',
	'youtubeauthsub_jserror_notitle' => 'Reek n Tittel foar dät Video an.',
	'youtubeauthsub_jserror_nodesc' => 'Reek ne Beskrieuwenge foar dät Video ien.',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 * @author Kandar
 */
$messages['su'] = array(
	'youtubeauthsub' => 'Muatkeun vidéo YouTube',
	'youtubeauthsub-desc' => 'Bisa dipaké pikeun [[Special:YouTubeAuthSub|ngamuat vidéo]] langsung ka YouTube',
	'youtubeauthsub_info' => 'Pikeun bisa ngamuat vidéo ka YouTube sarta bisa diselapkeun dina hiji kaca, mangga eusian formulir di handap:',
	'youtubeauthsub_title' => 'Judul',
	'youtubeauthsub_description' => 'Pedaran',
	'youtubeauthsub_password' => 'Sandi di YouTube',
	'youtubeauthsub_username' => 'Landihan di YouTube',
	'youtubeauthsub_keywords' => 'Kecap konci',
	'youtubeauthsub_category' => 'Kategori',
	'youtubeauthsub_submit' => 'Kirim',
	'youtubeauthsub_clickhere' => 'Klik di dieu pikeun asup log ka YouTube',
	'youtubeauthsub_tokenerror' => "Gagal ngahasilkeun token otorisasi, coba dimuat ulang (''refresh/reload'').",
	'youtubeauthsub_success' => "Wilujeng!
Vidéo anjeun geus dimuat.
<a href='http://www.youtube.com/watch?v=$1'>Tempo vidéo anjeun</a>.
Bisa jadi YouTube perlu waktu pikeun ngolah vidéona, ku kituna bisa jadi teu bisa langsung midang.

Pikeun nyelapkeun vidéo kana kaca wiki, asupkeun skrip ieu <code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Ngarah bisa ngamuat vidéo, anjeun kudu asup log YouTube heula.',
	'youtubeauthsub_uploadhere' => 'Muat vidéo anjeun ti dieu:',
	'youtubeauthsub_uploadbutton' => 'Muatkeun',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Tempo ieu vidéo]',
	'youtubeauthsub_summary' => 'Ngamuat vidéo YouTube',
	'youtubeauthsub_uploading' => 'Vidéo anjeun keur dimuat.
Antos heula.',
	'youtubeauthsub_viewpage' => 'Pilihan séjén, anjeun bisa [[$1|nempo vidéona]].',
	'youtubeauthsub_jserror_nokeywords' => 'Asupkeun hiji atawa dua kecap konci.',
	'youtubeauthsub_jserror_notitle' => 'Mangga asupkeun judul pikun vidéona.',
	'youtubeauthsub_jserror_nodesc' => 'Mangga lebetkeun pedaran ngeunaan vidéona:',
);

/** Swedish (Svenska)
 * @author M.M.S.
 * @author Najami
 * @author Sannab
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'youtubeauthsub' => 'Ladda upp en YouTube-video',
	'youtubeauthsub-desc' => 'Tillåter användare att [[Special:YouTubeAuthSub|ladda upp videoklipp]] direkt på YouTube',
	'youtubeauthsub_info' => 'För att ladda upp en video på YouTube för användning på en sida, fyll i följande information:',
	'youtubeauthsub_title' => 'Titel',
	'youtubeauthsub_description' => 'Beskrivning',
	'youtubeauthsub_password' => 'YouTube-lösenord',
	'youtubeauthsub_username' => 'YouTube-användarnamn',
	'youtubeauthsub_keywords' => 'Nyckelord',
	'youtubeauthsub_category' => 'Kategori',
	'youtubeauthsub_submit' => 'Spara',
	'youtubeauthsub_clickhere' => 'Klicka här för att logga in på YouTube',
	'youtubeauthsub_tokenerror' => 'Fel generering av auktoriseringstecken, pröva att uppdatera.',
	'youtubeauthsub_success' => "Gratulerar!
Din video är uppladdad.
<a href='http://www.youtube.com/watch?v=$1'>Visa din video</a>.
YouTube kan behöva viss tid att behandla din video, så den är kanske inte klar ännu.

För att inkludera din video i en sida på wikin, sätt in följande kod i en sida:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'För att ladda upp en video, måste du först logga in på YouTube.',
	'youtubeauthsub_uploadhere' => 'Ladda upp din video här ifrån:',
	'youtubeauthsub_uploadbutton' => 'Ladda upp',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Visa den här videon]',
	'youtubeauthsub_summary' => 'Laddar upp YouTube-video',
	'youtubeauthsub_uploading' => 'Din video har börjat uppladdas.
Var tålmodig.',
	'youtubeauthsub_viewpage' => 'Alternativt, kan du [[$1|visa din video]].',
	'youtubeauthsub_jserror_nokeywords' => 'Var god välj 1 eller fler nyckelord.',
	'youtubeauthsub_jserror_notitle' => 'Var god välj en titel för videon.',
	'youtubeauthsub_jserror_nodesc' => 'Var god välj en beskrivning för videon.',
);

/** Swahili (Kiswahili)
 * @author Lloffiwr
 * @author Muddyb Blast Producer
 */
$messages['sw'] = array(
	'youtubeauthsub' => 'Pakia video ya YouTube',
	'youtubeauthsub-desc' => 'Inaruhusu watumiaji [[Special:YouTubeAuthSub|kupakia video]] zao moja kwa moja katika YouTube',
	'youtubeauthsub_info' => 'Kupakia video katika YouTube na kuiweka kwenye ukurasa, jaza maelezo yafuatayo:',
	'youtubeauthsub_title' => 'Jina',
	'youtubeauthsub_description' => 'Maelezo',
	'youtubeauthsub_password' => 'Neno la siri la YouTube',
	'youtubeauthsub_username' => 'Jina la mtumiaji la YouTube',
	'youtubeauthsub_keywords' => 'Maneno ya msingi',
	'youtubeauthsub_category' => 'Jamii',
	'youtubeauthsub_submit' => 'Wasilisha',
	'youtubeauthsub_clickhere' => 'Bonyeza hapa kwa kuingia kwenye YouTube',
	'youtubeauthsub_tokenerror' => 'Dalili za hitilafu ya kutengeza idhinisho, jaribu kufanya upya.',
	'youtubeauthsub_success' => "Hongera!
Video yako imepakiwa.
<a href='http://www.youtube.com/watch?v=$1'>Tazama video yako</a>.
YouTube inaweza kuhitaji muda kidogo wa kuchakata video yako, hivyo basi inaweza isiwe tayari kwa sasa.

Kuingiza video yako kwenye ukurasa wa wiki, ingiza kodi zifuatazo kwenye ukurasa:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Ili kupakia video, utahitajika uingie kwenye YouTube kwanza.',
	'youtubeauthsub_uploadhere' => 'Pakia video yako kutoka hapa:',
	'youtubeauthsub_uploadbutton' => 'Pakia',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Tazama video hii]',
	'youtubeauthsub_summary' => 'Inapakia video YouTube',
	'youtubeauthsub_uploading' => 'Video yako inapakiwa.
Tafadhali kuwa na subira.',
	'youtubeauthsub_viewpage' => 'Njia nyingine, unaweza [[$1|kutazama video yako]].',
	'youtubeauthsub_jserror_nokeywords' => 'Tafadhali ingiza neno la msingi 1 au zaidi.',
	'youtubeauthsub_jserror_notitle' => 'Tafadhali ingiza jina la video yako.',
	'youtubeauthsub_jserror_nodesc' => 'Tafadhali ingiza maelezo kwa ajili ya video.',
);

/** Silesian (Ślůnski)
 * @author Lajsikonik
 * @author Timpul
 */
$messages['szl'] = array(
	'youtubeauthsub' => 'Wkludź plik wideo s YouTube',
	'youtubeauthsub-desc' => 'Dozwalo użytkowńikům na [[Special:YouTubeAuthSub|wćepywańy plikůw wideo]] bezpostrzedńo do serwisu YouTube',
	'youtubeauthsub_info' => 'Coby wćepać do serwisa YouTube plik wideo, kery mo by ńyskorzi wykorzistywany na zajtach tyj wiki, podej půńiższe informacyje:',
	'youtubeauthsub_title' => 'Titel',
	'youtubeauthsub_description' => 'Uopis',
	'youtubeauthsub_password' => 'Hasło do serwisa YouTube',
	'youtubeauthsub_username' => 'Mjano użytkowńika we serwiśe YouTube',
	'youtubeauthsub_keywords' => 'Słowa kluczowe',
	'youtubeauthsub_category' => 'Katygoryja',
	'youtubeauthsub_submit' => 'Wćepej',
	'youtubeauthsub_clickhere' => 'Kliknij, coby zalogować śe do serwisa YouTube',
	'youtubeauthsub_tokenerror' => 'Podczas generowańo tokena uwjerzitelńajůncygo zdorzył śe feler.
Sprůbuj załadować zajta zaś.',
	'youtubeauthsub_success' => "Gratulacje!
Twůj plik wideo zostoł wćepany.
Jeli chcesz uobejzdrzeć wćepany matyrjoł wideo, kliknij <a href='http://www.youtube.com/watch?v=$1'>sam</a>.
Serwis YouTube może potrzybować na przetworzyńy Twojygo plika trocha czasu, skiż tygo matyrjoł może ńy być jeszcze dostympny.

Jeli chcesz dołůnczyć wćepany plik wideo do matyrjołu we serwiśe wiki, wstow na żůndano zajta kod <code>{{&#35;ev:youtube|$1}}</code>.",
	'youtubeauthsub_authsubinstructions' => 'Jeli chcesz wćepać plik, nojpjyrw muśisz zalogować śe do serwisa YouTube.',
	'youtubeauthsub_uploadhere' => 'Plik wideo możesz wćepać s nastympujůncyj lokalizacyji:',
	'youtubeauthsub_uploadbutton' => 'Wćepńij',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

Tyn plik wideo idźe uobejzdrzyć [http://www.youtube.com/watch?v=$1 sam]',
	'youtubeauthsub_summary' => 'Wćepywańy plika wideo YouTube',
	'youtubeauthsub_uploading' => 'Pliki wideo sům wćepywane.
Czekej.',
	'youtubeauthsub_viewpage' => 'Uopcjůnalńy plik wideo idźe uobejzdrzeć [[$1|sam]].',
	'youtubeauthsub_jserror_nokeywords' => 'Wkludź jydno abo wjyncyj słów kluczowych.',
	'youtubeauthsub_jserror_notitle' => 'Wkludź mjano matyrjołu wideo.',
	'youtubeauthsub_jserror_nodesc' => 'Wkludź uopis matyrjołu wideo.',
);

/** Tamil (தமிழ்)
 * @author TRYPPN
 * @author அருட்செல்வன்
 */
$messages['ta'] = array(
	'youtubeauthsub' => 'யூடியூப்(YouTube) வீடியோவை தரவேற்றம் செய்யவும்',
	'youtubeauthsub-desc' => 'பயனர்கள் யூடியூபிற்கு நேரடியாக [[Special:YouTubeAuthSub|வீடியோக்களைத் தரவேற்றம் செய்ய]] உதவுகிறது',
	'youtubeauthsub_info' => 'ஒரு பக்கத்தில் சேர்க்கும் பொருட்டு யூடியூபில் ஒரு வீடியோவை தரவேற்றம் செய்வதற்கு, கீழ்க்கண்ட விவரங்களை நிரப்பவும்:',
	'youtubeauthsub_title' => 'தலைப்பு',
	'youtubeauthsub_description' => 'விவரிப்பு',
	'youtubeauthsub_password' => 'யூடியூப் கடவுச்சொல்',
	'youtubeauthsub_username' => 'யூடியூப் பயனர்பெயர்',
	'youtubeauthsub_keywords' => 'குறிச்சொற்கள்',
	'youtubeauthsub_category' => 'பகுப்பு',
	'youtubeauthsub_submit' => 'சமர்ப்பி',
	'youtubeauthsub_clickhere' => 'யூடியூபில் நுழைவதற்கு இங்கே சொடுக்கவும்',
	'youtubeauthsub_uploadbutton' => 'பதிவேற்றம்',
);

/** Telugu (తెలుగు)
 * @author Kiranmayee
 * @author Veeven
 */
$messages['te'] = array(
	'youtubeauthsub' => 'యూట్యూబ్ వీడియోని ఎగుమతిచేయండి',
	'youtubeauthsub-desc' => 'వాడుకర్లను నేరుగా యూట్యూబులోనికి [[Special:YouTubeAuthSub|వీడియోలను ఎగుమతి]] చేసుకోనిస్తుంది',
	'youtubeauthsub_info' => 'ఓ పేజీలోనికి చేర్చడానికి వీడియోని యూట్యూబులోనికి ఎగుమతిచేయడానికి, క్రింద సమాచారాన్ని పూరించండి:',
	'youtubeauthsub_title' => 'శీర్షిక',
	'youtubeauthsub_description' => 'వివరణ',
	'youtubeauthsub_password' => 'యూట్యూబ్ సంకేతపదం',
	'youtubeauthsub_username' => 'యూట్యూబ్ వాడుకరిపేరు',
	'youtubeauthsub_keywords' => 'కీలకపదాలు',
	'youtubeauthsub_category' => 'వర్గం',
	'youtubeauthsub_submit' => 'దాఖలుచెయ్యి',
	'youtubeauthsub_clickhere' => 'యూట్యూబ్ లోనికి ప్రవేశించడానికి ఇక్కడ నొక్కండి',
	'youtubeauthsub_tokenerror' => 'గుర్తింపు టోకేనును సృష్టించడంలో పొరపాటు జరిగినది, మళ్లీ ప్రయత్నించండి.',
	'youtubeauthsub_success' => "అభినందనలు!
మీ దృశ్యకాన్ని ఎక్కించాం.
<a href='http://www.youtube.com/watch?v=$1'>మీ దృశ్యకాన్ని చూడండి</a>.
మీ దృశ్యకాన్ని పరిక్రియాపించడానికి యూట్యూబ్ మరికొంత సమయం తీసుకోవచ్చు, కాబట్టి అదింకా తయారుగా ఉండకపోవచ్చు.

మీ దృశ్యకాన్ని వికీ పేజీలలో ఉంచడానికి, పేజీలో ఈ క్రింది సంకేతాన్ని ఉపయోగించండి:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'ఒక వీడియోని ఎగుమతి చేయడానికి, మీరు ముందు యూట్యూబు లోనికి ప్రవేశించాల్సివుంటుంది.',
	'youtubeauthsub_uploadhere' => 'మీ వీడియోని ఇక్కడ నుండి ఎగుమతి చేయండి:',
	'youtubeauthsub_uploadbutton' => 'ఎక్కించు',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

ఈ వీడియోని [http://www.youtube.com/watch?v=$1 ఇక్కడ] చూడవచ్చు',
	'youtubeauthsub_summary' => 'యూట్యూబులోనికి వీడియోని ఎగుమతిచేస్తున్నాం',
	'youtubeauthsub_uploading' => 'మీ వీడియో ఎగుమతవుతూండి.
దయచేసి ఓపిక వహించండి.',
	'youtubeauthsub_viewpage' => 'లేదా, [[$1|మీ వీడియో]]ని చూడవచ్చు.',
	'youtubeauthsub_jserror_nokeywords' => 'దయచేసి 1 లేదా అంతకంటే ఎక్కువ కీపదాలు ఇవ్వండి.',
	'youtubeauthsub_jserror_notitle' => 'ఈ వీడియోకి ఓ పేరు ఇవ్వండి.',
	'youtubeauthsub_jserror_nodesc' => 'ఈ వీడియో గురించి వివరణ ఇవ్వండి.',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'youtubeauthsub_title' => 'Títulu',
	'youtubeauthsub_username' => "Naran uza-na'in iha YouTube",
	'youtubeauthsub_category' => 'Kategoria',
	'youtubeauthsub_clickhere' => "Klike iha ne'e ba log in iha YouTube",
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'youtubeauthsub' => 'Навореро ба YouTube боргузорӣ кунед',
	'youtubeauthsub-desc' => 'Ба корбарон имкони бевосита [[Special:YouTubeAuthSub|боргузори кардани наворҳоро]] ба YouTube медиҳад',
	'youtubeauthsub_info' => 'Барои боргузори кардани наворе ба YouTube барои шомиле саҳифе кардан, иттилооте зеринро пур кунед:',
	'youtubeauthsub_title' => 'Унвон',
	'youtubeauthsub_description' => 'Тавсифот',
	'youtubeauthsub_password' => 'YouTube Гузарвожа',
	'youtubeauthsub_username' => 'YouTube Номи корбарӣ',
	'youtubeauthsub_keywords' => 'Калидвожаҳо',
	'youtubeauthsub_category' => 'Гурӯҳ',
	'youtubeauthsub_submit' => 'Ирсол',
	'youtubeauthsub_clickhere' => 'Барои вуруд шудан ба YouTube инҷо клик кунед',
	'youtubeauthsub_tokenerror' => 'Дар тавлиди иҷозаи рамзӣ бо хатое бархӯрд, саҳифаро аз нав бор кунед.',
	'youtubeauthsub_success' => "Табрик!
Навори шумо боргузорӣ шуд.
Барои дидани наворатон <a href='http://www.youtube.com/watch?v=$1'>инҷо</a> клик кунед.
YouTube метавонад каме вақтеро барои пешкаш кардани наворатон талаб кунад, чун он шояд тайёр набошад.

Барои илова кардани навори худ ба вики, коди зеринро ба саҳифа дохил кунед:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Барои боргузорӣ кардани навор, аввал ба шумо лозим аст ба YouTube ворид шавед.',
	'youtubeauthsub_uploadhere' => 'Наворҳоятонро аз инҷо боргузорӣ кунед:',
	'youtubeauthsub_uploadbutton' => 'Боргузорӣ',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

Ин навор метавонад [http://www.youtube.com/watch?v=$1 инҷо] қобили тамошо бошад',
	'youtubeauthsub_summary' => 'Дар ҳоли богузории навор ба YouTube',
	'youtubeauthsub_uploading' => 'Навори шумо дар ҳоли боргузорӣ аст.
Лутфан сабр кунед.',
	'youtubeauthsub_viewpage' => 'Бо тарзи дигар, шумо метавонед навори худро [[$1|инҷо]] тамошо кунед.',
	'youtubeauthsub_jserror_nokeywords' => 'Лутфан 1 ё якчанд калидвожаҳоро ворид кунед.',
	'youtubeauthsub_jserror_notitle' => 'Лутфан як унвонеро барои навор ворид кунед.',
	'youtubeauthsub_jserror_nodesc' => 'Лутфан як тавсиф барои навор ворид кунед.',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'youtubeauthsub' => 'Navorero ba YouTube borguzorī kuned',
	'youtubeauthsub-desc' => 'Ba korbaron imkoni bevosita [[Special:YouTubeAuthSub|borguzori kardani navorhoro]] ba YouTube medihad',
	'youtubeauthsub_info' => 'Baroi borguzori kardani navore ba YouTube baroi şomile sahife kardan, ittiloote zerinro pur kuned:',
	'youtubeauthsub_title' => 'Unvon',
	'youtubeauthsub_description' => 'Tavsifot',
	'youtubeauthsub_password' => 'YouTube Guzarvoƶa',
	'youtubeauthsub_username' => 'YouTube Nomi korbarī',
	'youtubeauthsub_keywords' => 'Kalidvoƶaho',
	'youtubeauthsub_category' => 'Gurūh',
	'youtubeauthsub_submit' => 'Irsol',
	'youtubeauthsub_clickhere' => 'Baroi vurud şudan ba YouTube inço klik kuned',
	'youtubeauthsub_tokenerror' => 'Dar tavlidi içozai ramzī bo xatoe barxūrd, sahifaro az nav bor kuned.',
	'youtubeauthsub_authsubinstructions' => 'Baroi borguzorī kardani navor, avval ba şumo lozim ast ba YouTube vorid şaved.',
	'youtubeauthsub_uploadhere' => 'Navorhojatonro az inço borguzorī kuned:',
	'youtubeauthsub_uploadbutton' => 'Borguzorī',
	'youtubeauthsub_summary' => 'Dar holi boguzoriji navor ba YouTube',
	'youtubeauthsub_uploading' => 'Navori şumo dar holi borguzorī ast.
Lutfan sabr kuned.',
	'youtubeauthsub_jserror_nokeywords' => 'Lutfan 1 jo jakcand kalidvoƶahoro vorid kuned.',
	'youtubeauthsub_jserror_notitle' => 'Lutfan jak unvonero baroi navor vorid kuned.',
	'youtubeauthsub_jserror_nodesc' => 'Lutfan jak tavsif baroi navor vorid kuned.',
);

/** Thai (ไทย)
 * @author Manop
 * @author Passawuth
 */
$messages['th'] = array(
	'youtubeauthsub' => 'อัปโหลดคลิปวิดีโอยูทูบ',
	'youtubeauthsub-desc' => 'อนุญาตให้ผู้ใช้[[Special:YouTubeAuthSub|อัปโหลดคลิปวิดีโอ]]โดยตรงไปที่ยูทูบ',
	'youtubeauthsub_info' => 'เพื่อที่จะอัปโหลดคลิปวิดีโอบนยูทูบ กรุณาใส่ข้อมูลดังต่อไปนี้ :',
	'youtubeauthsub_title' => 'ชื่อคลิป',
	'youtubeauthsub_description' => 'คำอธิบาย',
	'youtubeauthsub_password' => 'รหัสผ่านบนยูทูบ',
	'youtubeauthsub_username' => 'ชื่อผู้ใช้บนยูทูบ',
	'youtubeauthsub_keywords' => 'คำสำคัญ',
	'youtubeauthsub_category' => 'หมวดหมู่',
	'youtubeauthsub_submit' => 'ตกลง',
	'youtubeauthsub_clickhere' => 'คลิกตรงนี้เพื่อล็อกอินเข้ายูทูบ',
	'youtubeauthsub_tokenerror' => 'มีข้อผิดพลาดเกิดขึ้น กรุณาลองโหลดหน้านี้ใหม่ดูอีกครั้ง',
	'youtubeauthsub_success' => "ขอแสดงความยินดี !
คลิปวิดีโอของคุณถูกอัปโหลดแล้ว
<a href='http://www.youtube.com/watch?v=$1'>ดูคลิปวิดีโอของคุณ</a>
ยูทูบอาจจะต้องการเวลาสักพักเพื่อที่จะประมวลผลคลิปวิดีโอของคุณ ดังนั้นมันอาจจะยังไม่พร้อม

หากคุณต้องการใส่คลิปวิดีโอของคุณลงไปในวิกิ เพิ่มโค้ดดังต่อไปนี้ลงไปในหน้า :
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'เพื่อที่จะอัปโหลดคลิปวิดีโอ กรุณาล็อกอินเข้ายูทูบก่อน',
	'youtubeauthsub_uploadhere' => 'อัปโหลดคลิปวิดีโอของคุณจากที่นี่ :',
	'youtubeauthsub_uploadbutton' => 'อัปโหลด',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}

[http://www.youtube.com/watch?v=$1 ดูคลิปวิดีโอนี้]',
	'youtubeauthsub_summary' => 'กำลังอัปโหลดคลิปวิดีโอยูทูบ',
	'youtubeauthsub_uploading' => 'คลิปวิดีโอของคุณกำลังถูกอัปโหลดอยู่
กรุณารอสักครู่',
	'youtubeauthsub_viewpage' => 'นอกจากนี้ คุณสามารถ[[$1|ดูคลิปวิดีโอของคุณ]]',
	'youtubeauthsub_jserror_nokeywords' => 'กรุณาใส่คำสำคัญอย่างน้อย 1 คำ หรือ มากกว่า',
	'youtubeauthsub_jserror_notitle' => 'กรุณาใส่ชื่อสำหรับคลิปวิดีโอด้วย',
	'youtubeauthsub_jserror_nodesc' => 'กรุณาใส่คำอธิบายสำหรับคลิปวิดีโอนี้ด้วย',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'youtubeauthsub_title' => 'At',
	'youtubeauthsub_description' => 'Düşündiriş',
	'youtubeauthsub_password' => 'YouTube paroly',
	'youtubeauthsub_username' => 'YouTube ulanyjy ady',
	'youtubeauthsub_keywords' => 'Açarlar',
	'youtubeauthsub_category' => 'Kategoriýa',
	'youtubeauthsub_submit' => 'Tabşyr',
	'youtubeauthsub_uploadbutton' => 'Ýükle',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'youtubeauthsub' => 'Ikarga ang panooring (bidyo) nagmula sa YouTube',
	'youtubeauthsub-desc' => 'Pinapahintulutan ang mga tagagamit na tuwirang [[Special:YouTubeAuthSub|makapagkarga ng mga panoorin (bidyo)]] patungo sa YouTube',
	'youtubeauthsub_info' => 'Para makapagkarga ng isang panoorin/bidyo sa YouTube na maibibilang sa ibabaw ng isang pahina, punuin ng laman ang sumusunod na mga hinihinging kabatiran:',
	'youtubeauthsub_title' => 'Pamagat',
	'youtubeauthsub_description' => 'Paglalarawan',
	'youtubeauthsub_password' => 'Hudyat para sa YouTube',
	'youtubeauthsub_username' => 'Pangalan ng tagagamit sa YouTube',
	'youtubeauthsub_keywords' => "Mga susing-salita o salitang-naglalarawan (''keyword'')",
	'youtubeauthsub_category' => 'Kaurian',
	'youtubeauthsub_submit' => 'Ipasa',
	'youtubeauthsub_clickhere' => 'Pindutin rito para makalagda sa YouTube',
	'youtubeauthsub_tokenerror' => 'May kamalian sa paglikha ng sagisag ng pagbibigay ng pahintulot, subuking sariwain.',
	'youtubeauthsub_success' => "Maligayang bati!
Naikarga na ang iyong palabas (''video'').
Para mapanood ang iyong bidyo pindutin <a href='http://www.youtube.com/watch?v=$1'>ito</a>.
Maaaring mangailangan ang ''YouTube'' ng ilang panahon para maisagawa (maproseso) ang palabas mo, kaya maaaring hindi pa ito ganap na nakahanda.

Para maisama ang iyong palabas sa isang pahina ng wiki, isingit ang sumusunod na kodigo sa loob ng isang pahina:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Para makapagkarga ng panoorin (bidyo), kakailanganin mong lumagda muna sa YouTube.',
	'youtubeauthsub_uploadhere' => 'Ikarga ang iyong panoorin/bidyo mula rito:',
	'youtubeauthsub_uploadbutton' => 'Ikarga',
	'youtubeauthsub_code' => "{{#ev:youtube|$1}}.

Mapapanood ang palabas (''video'') magmula [http://www.youtube.com/watch?v=$1 rito]",
	'youtubeauthsub_summary' => 'Ikinakarga ang bidyo/panooring pang-YouTube',
	'youtubeauthsub_uploading' => 'Ikinakarga na ang iyong panoorin (bidyo).
Magtiyaga po lamang.',
	'youtubeauthsub_viewpage' => "O kaya, maaari mong panoorin ang palabas (''video'') mo mula [[$1|rito]].",
	'youtubeauthsub_jserror_nokeywords' => "Magpasok po ng 1 o higit pang mga \"susing-salita\" (''keyword'').",
	'youtubeauthsub_jserror_notitle' => 'Magpasok ng isang pamagat para sa panoorin.',
	'youtubeauthsub_jserror_nodesc' => 'Magpasok ng isang paglalarawan para sa panoorin.',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Karduelis
 * @author Runningfridgesrule
 */
$messages['tr'] = array(
	'youtubeauthsub' => "YouTube'a video yükle",
	'youtubeauthsub-desc' => "Kullanıcıların YouTube'a doğrudan [[Special:YouTubeAuthSub|video yüklemelerine]] olanak sağlar",
	'youtubeauthsub_info' => "Bir sayfaya dahil etmek için YouTube'a video yüklemek için, aşağıdaki bilgileri doldurun:",
	'youtubeauthsub_title' => 'Başlık',
	'youtubeauthsub_description' => 'Tanım',
	'youtubeauthsub_password' => 'YouTube şifresi',
	'youtubeauthsub_username' => 'YouTube kullanıcı adı',
	'youtubeauthsub_keywords' => 'Anahtar kelimeler',
	'youtubeauthsub_category' => 'Kategori',
	'youtubeauthsub_submit' => 'Gönder',
	'youtubeauthsub_clickhere' => "YouTube'da oturum açmak için buraya tıklayın",
	'youtubeauthsub_tokenerror' => 'Yetki dizgeciği oluşturulurken hata, yenilemeyi deneyin.',
	'youtubeauthsub_success' => "Tebrikler!
Videonuz yüklendi.
<a href='http://www.youtube.com/watch?v=$1'>Videonuzu izleyin</a>.
YouTube, videoyu işletmek için belki biraz zamana ihtiyacı olabilir, bu yüzden hemen hazır olmayabilir.

Vikiye videonuzu eklemek için, şu sıradaki kodu bir sayfaya ekleyin: <code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => "Bir video yüklemek için, öncelikle YouTube'a oturum açmanız gereklidir.",
	'youtubeauthsub_uploadhere' => 'Videonuzu buradan yükleyin:',
	'youtubeauthsub_uploadbutton' => 'Yükle',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Bu videoyu izleyin]',
	'youtubeauthsub_summary' => 'YouTube videosu yükleniyor',
	'youtubeauthsub_uploading' => 'Videonuz yükleniyor.
Lütfen sabırlı olun.',
	'youtubeauthsub_viewpage' => 'Alternatif olarak, [[$1|videonuzu izleyebilirsiniz]].',
	'youtubeauthsub_jserror_nokeywords' => 'Lütfen 1 veya daha fazla anahtar kelime girin.',
	'youtubeauthsub_jserror_notitle' => 'Lütfen video için bir başlık girin.',
	'youtubeauthsub_jserror_nodesc' => 'Lütfen video için bir tanım girin.',
);

/** Tatar (Cyrillic script) (Татарча)
 * @author KhayR
 */
$messages['tt-cyrl'] = array(
	'youtubeauthsub' => 'YouTube видеосын кертү',
	'youtubeauthsub-desc' => 'YouTube кулланучыларына [[Special:YouTubeAuthSub|видео кертергә]] мөмкинлек бирә',
);

/** Uyghur (Arabic script) (ئۇيغۇرچە)
 * @author Sahran
 */
$messages['ug-arab'] = array(
	'youtubeauthsub' => 'YouTube سىن يۈكلە',
	'youtubeauthsub_title' => 'ماۋزۇ',
	'youtubeauthsub_description' => 'چۈشەندۈرۈش',
	'youtubeauthsub_password' => 'YouTube ئىم',
	'youtubeauthsub_username' => 'YouTube ئاتى',
	'youtubeauthsub_keywords' => 'ھالقىلىق سۆز',
	'youtubeauthsub_category' => 'تۈر',
	'youtubeauthsub_submit' => 'تاپشۇر',
	'youtubeauthsub_clickhere' => 'بۇ جاي چېكىلسە YouTube قا كىرىدۇ',
	'youtubeauthsub_uploadhere' => 'سىننى بۇ جايدىن يۈكلەڭ:',
	'youtubeauthsub_uploadbutton' => 'يۈكلە',
	'youtubeauthsub_summary' => 'YouTube سىن يۈكلەۋاتىدۇ',
);

/** Ukrainian (Українська)
 * @author A1
 * @author AS
 * @author Ahonc
 */
$messages['uk'] = array(
	'youtubeauthsub' => 'Завантаження відео YouTube',
	'youtubeauthsub-desc' => 'Дозволяє користувачам [[Special:YouTubeAuthSub|завантажувати відео]] напряму до YouTube',
	'youtubeauthsub_info' => 'Щоб завантажити відео на YouTube і вставити його на сторінку, заповніть такі поля:',
	'youtubeauthsub_title' => 'Заголовок',
	'youtubeauthsub_description' => 'Опис',
	'youtubeauthsub_password' => 'Пароль на YouTube',
	'youtubeauthsub_username' => "Ім'я користувача на YouTube",
	'youtubeauthsub_keywords' => 'Ключові слова',
	'youtubeauthsub_category' => 'Категорія',
	'youtubeauthsub_submit' => 'Надіслати',
	'youtubeauthsub_clickhere' => 'Клацніть сюди, щоб увійти до YouTube',
	'youtubeauthsub_tokenerror' => 'Помилка створення токена авторизації, спробуйте оновити сторінку.',
	'youtubeauthsub_success' => "Вітаємо!
Ваше відео завантажене.
<a href='http://www.youtube.com/watch?v=$1'>Переглянути відео</a>.
YouTube може знадобитися деякий час, щоб обробити ваше відео, тому воно може бути недоступним прямо зараз.

Щоб додати відео на вашу вікі-сторінку, вставте такий код на сторінку:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Щоб завантажити відео, вам потрібно спочатку авторизуватися/зареєструватися в YouTube.',
	'youtubeauthsub_uploadhere' => 'Завантажити ваше відео звідси:',
	'youtubeauthsub_uploadbutton' => 'Завантажити',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Переглянути відео]',
	'youtubeauthsub_summary' => 'Завантаження відео YouTube',
	'youtubeauthsub_uploading' => 'Ваше відео завантажується.
Будь ласка, зачекайте.',
	'youtubeauthsub_viewpage' => 'Ви також можете [[$1|переглянути ваше відео]].',
	'youtubeauthsub_jserror_nokeywords' => 'Будь ласка, введіть хоча б одне ключове слово.',
	'youtubeauthsub_jserror_notitle' => 'Будь ласка, введіть назву відео.',
	'youtubeauthsub_jserror_nodesc' => 'Будь ласка, введіть опис відео.',
);

/** Vèneto (Vèneto)
 * @author Candalua
 * @author Vajotwo
 */
$messages['vec'] = array(
	'youtubeauthsub' => 'Carga un video de YouTube',
	'youtubeauthsub-desc' => 'Permeti ai utenti de [[Special:YouTubeAuthSub|cargar dei video]] diretamente su YouTube',
	'youtubeauthsub_info' => 'Par cargar un video su YouTube e inserirlo in te na pagina, inpenìssi el modulo con le seguenti informassion:',
	'youtubeauthsub_title' => 'Titolo',
	'youtubeauthsub_description' => 'Descrission',
	'youtubeauthsub_password' => 'Password de YouTube',
	'youtubeauthsub_username' => 'Nome utente so YouTube',
	'youtubeauthsub_keywords' => 'Parole chiave',
	'youtubeauthsub_category' => 'Categoria',
	'youtubeauthsub_submit' => 'Invia',
	'youtubeauthsub_clickhere' => 'Struca qua par far login su YouTube',
	'youtubeauthsub_tokenerror' => "No s'à mìa podù generar el token de autorizassion, próa a agiornar la pagina.",
	'youtubeauthsub_success' => "Conplimenti!
El to video el xe stà cargà.
<a href='http://www.youtube.com/watch?v=$1'>Varda el to video</a>.
Podarìa volerghe del tenpo a YouTube par elaborar el to video, quindi el podarìa no èssar gnancora pronto.

Par inserir sto video in te na pagina de sta wiki, inserìssi el còdese seguente drento na pagina:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Par cargar un video, ti ga prima de far login su YouTube.',
	'youtubeauthsub_uploadhere' => 'Carga el to video da chì:',
	'youtubeauthsub_uploadbutton' => 'Carga',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Varda sto video]',
	'youtubeauthsub_summary' => 'Cargar un video de YouTube',
	'youtubeauthsub_uploading' => "So drio cargar el to video.
Par piaser speta n'atimo.",
	'youtubeauthsub_viewpage' => 'In alternativa, ti pol [[$1|vardar el to video]].',
	'youtubeauthsub_jserror_nokeywords' => 'Par piaser, inserissi una o più parole chiave.',
	'youtubeauthsub_jserror_notitle' => 'Par piaser inserissi un titolo par el video.',
	'youtubeauthsub_jserror_nodesc' => 'Par piaser inserissi na descrission par el video.',
);

/** Veps (Vepsän kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'youtubeauthsub' => 'Jügutoitta video YouTuba-saitalpäi',
	'youtubeauthsub-desc' => 'Laskeb kävutajile [[Special:YouTubeAuthSub|jügutoitta videod]] YouTube-saitalpäi.',
	'youtubeauthsub_info' => 'Miše jügutoitta video YouTube-saitalpäi da panda se lehtpolele, täutkat nened pöudod:',
	'youtubeauthsub_title' => 'Pälkirjutez',
	'youtubeauthsub_description' => 'Ümbrikirjutand',
	'youtubeauthsub_password' => 'YouTube-peitsana',
	'youtubeauthsub_username' => 'Kävutajan nimi YouTube-saital',
	'youtubeauthsub_keywords' => 'Avadimsanad',
	'youtubeauthsub_category' => 'Kategorii',
	'youtubeauthsub_submit' => 'Oigeta',
	'youtubeauthsub_clickhere' => 'Paingat nakhu, miše tulda YouTube-saitale',
	'youtubeauthsub_tokenerror' => "Avtorizacijan tokenan sämižen petuz. Lat'kat udištada lehtpol'.",
	'youtubeauthsub_success' => "Ozatam!
Teiden video om jügetoittud.
<a href='http://www.youtube.com/watch?v=$1'>Kacta video</a>.
YouTube-le tarbiž völ aigad, miše augotada teiden video, i sikš teile, voib olda, pidab varastada, miše kacta sidä.

Miše panda teiden video vikin lehtpolele, pangat sinnä nece kod:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => 'Miše jügetoitta video, teile pidab ezmäi tulda YouTube-he.',
	'youtubeauthsub_uploadhere' => 'Jügutoitta teiden video täspäi:',
	'youtubeauthsub_uploadbutton' => 'Jügutoitta',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Kacta nece video]',
	'youtubeauthsub_summary' => 'YouTube-videod jügutoitand',
	'youtubeauthsub_uploading' => 'Teiden videod jügutoittas.
Olgat hüväd, varastagat.',
	'youtubeauthsub_viewpage' => 'Voit [[$1|kacta teiden videod]] mugažo täs.',
	'youtubeauthsub_jserror_nokeywords' => "Olgat hüväd, kirjutagat üks' avadimsana vai kuverdan-ni avadimsanoid.",
	'youtubeauthsub_jserror_notitle' => 'Olgat hüväd, kirjutagat videon nimi.',
	'youtubeauthsub_jserror_nodesc' => 'Olgat hüväd, tehkat videon lühüd ümbrikirjutuz.',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'youtubeauthsub' => 'Tải lên video YouTube',
	'youtubeauthsub-desc' => 'Để người dùng [[Special:YouTubeAuthSub|tải lên video]] thẳng từ YouTube',
	'youtubeauthsub_info' => 'Để tải lên video từ YouTube và chèn nó vào trang, hãy ghi vào những thông tin sau:',
	'youtubeauthsub_title' => 'Tựa đề',
	'youtubeauthsub_description' => 'Miêu tả',
	'youtubeauthsub_password' => 'Mật khẩu YouTube',
	'youtubeauthsub_username' => 'Tên hiệu YouTube',
	'youtubeauthsub_keywords' => 'Từ khóa',
	'youtubeauthsub_category' => 'Thể loại',
	'youtubeauthsub_submit' => 'Đăng nhập',
	'youtubeauthsub_clickhere' => 'Hãy nhấn chuột vào đây để đăng nhập vào YouTube',
	'youtubeauthsub_tokenerror' => 'Có lỗi khi tạo số hiệu đăng nhập. Hãy thử làm tươi trang.',
	'youtubeauthsub_success' => 'Chúc mừng bạn đã tải lên video thành công! <a href="http://www.youtube.com/watch?v=$1">Coi video này</a>. YouTube có thể cần một tí thì giờ để xử lý video của bạn, nên có thể nó chưa sẵn.

Để chèn video này vào một trang wiki, hãy dùng mã sau:
<code>{{&#35;ev:youtube|$1}}</code>',
	'youtubeauthsub_authsubinstructions' => 'Để tải lên video, bạn cần phải đăng nhập vào YouTube trước tiên.',
	'youtubeauthsub_uploadhere' => 'Hãy tải lên video ở đây:',
	'youtubeauthsub_uploadbutton' => 'Tải lên',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 Coi video này]',
	'youtubeauthsub_summary' => 'Đang tải lên video YouTube',
	'youtubeauthsub_uploading' => 'Đang tải lên video. Xin chờ đợi tí.',
	'youtubeauthsub_viewpage' => 'Bạn cũng có thể [[$1|coi video này]].',
	'youtubeauthsub_jserror_nokeywords' => 'Xin hãy chọn ít nhất một từ khóa.',
	'youtubeauthsub_jserror_notitle' => 'Xin hãy chọn tên cho video.',
	'youtubeauthsub_jserror_nodesc' => 'Xin hãy miêu tả video.',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'youtubeauthsub_title' => 'Tiäd',
	'youtubeauthsub_description' => 'Bepenam',
	'youtubeauthsub_password' => 'Letavöd (YouTube)',
	'youtubeauthsub_username' => 'Gebananem (YouTube)',
	'youtubeauthsub_keywords' => 'Kikavöds',
	'youtubeauthsub_category' => 'Klad',
	'youtubeauthsub_submit' => 'Sedön',
	'youtubeauthsub_uploadbutton' => 'Löpükön',
);

/** Waray (Winaray)
 * @author Harvzsf
 */
$messages['war'] = array(
	'youtubeauthsub_category' => 'Kaarangay',
);

/** Wu (吴语) */
$messages['wuu'] = array(
	'youtubeauthsub_title' => '标题',
	'youtubeauthsub_description' => '描述',
	'youtubeauthsub_category' => '分类',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'youtubeauthsub' => 'אַרויפֿלאָדן YouTube ווידעא',
	'youtubeauthsub-desc' => ' ערמעגלעכט באַניצער צו [[Special:YouTubeAuthSub|אַרויפֿלאָדן ווידעאס]] גלײַך צו  YouTube',
	'youtubeauthsub_info' => 'כדי ארויפֿלאָדן אַ ווידעא צו יוטוב צו ווערן ארײַגעשלאסן אויף אַ בלאַט, פֿילט אויס די ווייַטערדיקע אינפֿאָרמאַציע:',
	'youtubeauthsub_title' => 'קעפל',
	'youtubeauthsub_description' => 'שילדערונג',
	'youtubeauthsub_password' => 'יוטוב פאַסווארט',
	'youtubeauthsub_username' => 'YouTube באַניצער נאָמען',
	'youtubeauthsub_keywords' => 'שליסלווערטער',
	'youtubeauthsub_category' => 'קאַטעגאריע',
	'youtubeauthsub_submit' => 'אײַנגעבן',
	'youtubeauthsub_clickhere' => 'דרוקט דאָ ארײַנלאגירן צו YouTube',
	'youtubeauthsub_authsubinstructions' => 'כדי אַרויפֿלאָדן א ווידעא, דאַרפֿט איר פֿריער אַרײַנלאגירן צו יוטוב.',
	'youtubeauthsub_uploadhere' => 'לאָדט אַרויף אייער ווידעא פֿון דאַנעט:',
	'youtubeauthsub_uploadbutton' => 'ארויפֿלאָדן',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 זען דעם ווידעא]',
	'youtubeauthsub_summary' => 'אַרויפֿלאָדן יוטוב ווידעא',
);

/** Yoruba (Yorùbá)
 * @author Demmy
 */
$messages['yo'] = array(
	'youtubeauthsub_title' => 'Àkọlé',
	'youtubeauthsub_description' => 'Ìjúwe',
	'youtubeauthsub_password' => 'Ọ̀rọ̀ìpamọ́ Youtube',
	'youtubeauthsub_username' => 'Orúkọ oníṣe Youtube',
	'youtubeauthsub_category' => 'Ẹ̀ka',
	'youtubeauthsub_uploadbutton' => 'Ìrùsókè',
);

/** Cantonese (粵語) */
$messages['yue'] = array(
	'youtubeauthsub_title' => '標題',
	'youtubeauthsub_description' => '描述',
	'youtubeauthsub_category' => '分類',
	'youtubeauthsub_submit' => '遞交',
	'youtubeauthsub_uploadbutton' => '上載',
);

/** Zhuang (Vahcuengh)
 * @author Biŋhai
 */
$messages['za'] = array(
	'youtubeauthsub_title' => 'Daezmoeg',
	'youtubeauthsub_category' => 'Feandingz',
);

/** Chinese (China) (‪中文(中国大陆)‬)
 * @author Gzdavidwong
 */
$messages['zh-cn'] = array(
	'youtubeauthsub_info' => '如要为一个页面上传视频到YouTube，需填写如下信息：',
	'youtubeauthsub_success' => "成功！
您的视频已经上传。
<a href='http://www.youtube.com/watch?v=$1'>观看该视频</a>。
YouTube可能需要一些时间处理您的视频，所以可能不会立即出现。

如要将您的视频放入一个维基页面，请在页面中加入如下代码：
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_viewpage' => '或者，您可以[[$1|观看该视频]]。',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gaoxuewei
 * @author Xiaomingyan
 */
$messages['zh-hans'] = array(
	'youtubeauthsub' => '上传YouTube视频',
	'youtubeauthsub-desc' => '允许用户直接[[Special:YouTubeAuthSub|上传视频]]到YouTube',
	'youtubeauthsub_info' => '如要为一个页面上传视频到YouTube，需填写如下信息：',
	'youtubeauthsub_title' => '名称',
	'youtubeauthsub_description' => '说明',
	'youtubeauthsub_password' => 'YouTube密码',
	'youtubeauthsub_username' => 'YouTube用户名',
	'youtubeauthsub_keywords' => '关键词',
	'youtubeauthsub_category' => '分类',
	'youtubeauthsub_submit' => '提交',
	'youtubeauthsub_clickhere' => '点击这里登录YouTube',
	'youtubeauthsub_tokenerror' => '认证用户信息时出错，请刷新。',
	'youtubeauthsub_success' => "成功！
您的视频已经上传。
<a href='http://www.youtube.com/watch?v=$1'>观看该视频</a>。
YouTube可能需要一些时间处理您的视频，所以可能不会立即出现。

如要将您的视频放入一个维基页面，请在页面中加入如下代码：
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => '如要上传视频，您首先需要登录YouTube。',
	'youtubeauthsub_uploadhere' => '源文件名：',
	'youtubeauthsub_uploadbutton' => '上传',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}.

[http://www.youtube.com/watch?v=$1 观看该视频]',
	'youtubeauthsub_summary' => '正在将视频上传到YouTube',
	'youtubeauthsub_uploading' => '您的视频正在上传。
请稍等。',
	'youtubeauthsub_viewpage' => '或者，您可以[[$1|观看该视频]]。',
	'youtubeauthsub_jserror_nokeywords' => '请输入关键字。',
	'youtubeauthsub_jserror_notitle' => '请输入视频名称。',
	'youtubeauthsub_jserror_nodesc' => '请输入视频描述。',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Alexsh
 * @author Mark85296341
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'youtubeauthsub' => '上傳 YouTube 影片',
	'youtubeauthsub-desc' => '容許使用者直接[[Special:YouTubeAuthSub|上傳影片]]至 YouTube。',
	'youtubeauthsub_info' => '在上傳 YouTube 影片至包含頁面前，請填寫以下資料：',
	'youtubeauthsub_title' => '標題',
	'youtubeauthsub_description' => '描述',
	'youtubeauthsub_password' => 'YouTube 密碼',
	'youtubeauthsub_username' => 'YouTube 使用者名稱',
	'youtubeauthsub_keywords' => '關鍵字',
	'youtubeauthsub_category' => '分類',
	'youtubeauthsub_submit' => '提交',
	'youtubeauthsub_clickhere' => '按這裡登入 YouTube',
	'youtubeauthsub_tokenerror' => '驗證使用者訊息發生錯誤，請重新整理頁面。',
	'youtubeauthsub_success' => "上傳成功！
您的影片已上傳。
按<a href='http://www.youtube.com/watch?v=$1'這裡</a>觀看您的影片。
YouTube 需要一些時間去處理閣下的影片，因此或未能即時觀看它。

要把影片放進 wiki 的頁面內，請使用以下代碼：
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => '在上傳影片前，您需先登入 YouTube。',
	'youtubeauthsub_uploadhere' => '從這裡上傳您的影片：',
	'youtubeauthsub_uploadbutton' => '上傳',
	'youtubeauthsub_code' => '{{#ev:youtube|$1}}

本影片可在[http://www.youtube.com/watch?v=$1 這裡]觀看',
	'youtubeauthsub_summary' => '上傳 YouTube 影片中',
	'youtubeauthsub_uploading' => '您的影片正在上傳中。
請耐心等候。',
	'youtubeauthsub_viewpage' => '除此之外，您也可在[[$1|這裡]]觀看影片。',
	'youtubeauthsub_jserror_nokeywords' => '請輸入一個或以上的關鍵詞。',
	'youtubeauthsub_jserror_notitle' => '請輸入影片標題',
	'youtubeauthsub_jserror_nodesc' => '請輸入影片描述。',
);

/** Zulu (isiZulu) */
$messages['zu'] = array(
	'youtubeauthsub_category' => 'Uhlobo',
	'youtubeauthsub_submit' => 'Yisa',
);

