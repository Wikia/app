<?php
/**
 * Internationalisation file for ImageTagging extension.
 *
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Tomasz Klim
 * @author Tristan Harris
 */
$messages['en'] = array(
	'taggedimages'                          => 'Tagged images',
	'imagetagging-desc'                     => 'Lets a user select regions of an embedded image and associate a page with that region',
	'imagetagging-addimagetag'              => 'Tag this image',
	'imagetagging-article'                  => 'Page:',
	'imagetagging-articletotag'             => 'Page to tag',
	'imagetagging-canteditothermessage'		=> 'You cannot edit this page, either because you do not have the rights to do so or because the page is locked down for other reasons.',
	'imagetagging-imghistory'               => 'History',
	'imagetagging-images'                   => 'images',
	'imagetagging-inthisimage'              => 'In this image: $1',
	'imagetagging-logentry'                 => 'Removed tag to page [[$1]] by $2',
	'imagetagging-log-tagged'               => 'Image [[$1|$2]] was tagged to page [[$3]] by $4',
	'imagetagging-new'                      => '<sup><span style="color:red">New!</span></sup>',
	'imagetagging-removetag'                => 'remove tag',
	'imagetagging-done-button'              => 'Done tagging',
	'imagetagging-tag-button'               => 'Tag',
	'imagetagging-tagcancel-button'         => 'Cancel',
	'imagetagging-tagging-instructions'     => 'Click on people or things in the image to tag them.',
	'imagetagging-addingtag'                => 'Adding tag…',
	'imagetagging-removingtag'              => 'Removing tag…',
	'imagetagging-addtagsuccess'            => 'Added tag.',
	'imagetagging-removetagsuccess'         => 'Removed tag.',
	'imagetagging-canteditneedloginmessage' => 'You cannot edit this page.
It may be because you need to login to tag images.
Do you want to login now?',
	'imagetagging-oneactionatatimemessage'  => 'Only one tagging action at a time is allowed.
Please wait for the existing action to complete.',
	'imagetagging-oneuniquetagmessage'      => 'This image already has a tag with this name.',
	'imagetagging-imagetag-seemoreimages'   => 'See more images of "$1" ($2)',
	'imagetagging-taggedimages-title'       => 'Images of "$1"',
	'imagetagging-taggedimages-displaying'  => 'Displaying $1 - $2 of $3 images of "$4"',
	'tag-logpagename'						=> 'Tagging log',
	'tag-logpagetext'						=> 'This is a log of all image tag additions and removals.',
);

/** Message documentation (Message documentation)
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author M.M.S.
 * @author Purodha
 * @author Tgr
 * @author The Evil IP address
 */
$messages['qqq'] = array(
	'imagetagging-desc' => '{{desc}}',
	'imagetagging-article' => '{{Identical|Page}}',
	'imagetagging-imghistory' => '{{Identical|History}}',
	'imagetagging-images' => '{{Identical|Image}}',
	'imagetagging-tagcancel-button' => '{{Identical|Cancel}}',
	'imagetagging-imagetag-seemoreimages' => 'Shown in articles; $1 is the name of the article, $2 is the number of images which have a region tagged with this article.',
);

/** Faeag Rotuma (Faeag Rotuma)
 * @author Jose77
 */
$messages['rtm'] = array(
	'imagetagging-tagcancel-button' => "Mao'ạki",
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'imagetagging-imghistory' => 'Liu onoono atu ki tua',
	'imagetagging-tagcancel-button' => 'Tiaki',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 */
$messages['af'] = array(
	'imagetagging-article' => 'Bladsy:',
	'imagetagging-imghistory' => 'Geskiedenis',
	'imagetagging-images' => 'beelde',
	'imagetagging-tag-button' => 'Etiket',
	'imagetagging-tagcancel-button' => 'Kanselleer',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'taggedimages' => 'imazhe tagged',
	'imagetagging-desc' => 'Lejon një përdorues rajone të zgjidhni një imazh i ngulitur dhe i shoqërojnë një faqe me atë rajon',
	'imagetagging-addimagetag' => 'Tag këtë imazh',
	'imagetagging-article' => 'Faqe:',
	'imagetagging-articletotag' => 'Faqe të tag',
	'imagetagging-canteditothermessage' => 'Ju nuk mund ta redaktoni këtë faqe, ose për shkak se ju nuk keni të drejtat për të bërë këtë ose për shkak se faqja eshte mbyllur per arsye të tjera.',
	'imagetagging-imghistory' => 'Histori',
	'imagetagging-images' => 'imazhe',
	'imagetagging-inthisimage' => 'Në këtë imazh: $1',
	'imagetagging-logentry' => 'tag hoq në faqe [[$1]] nga $2',
	'imagetagging-log-tagged' => 'Image [[$1|$2]] ishte i pajisur me etiketë të faqe [[$3]] nga $4',
	'imagetagging-new' => '<span style="color:red"><sup>New!</sup></span>',
	'imagetagging-removetag' => 'hiqni tag',
	'imagetagging-done-button' => 'Done tagging',
	'imagetagging-tag-button' => 'Etiketë',
	'imagetagging-tagcancel-button' => 'Anuloj',
	'imagetagging-tagging-instructions' => 'Kliko mbi njerëzit ose gjërat në imazhe për tu tag tyre.',
	'imagetagging-addingtag' => 'Shtimi tag ...',
	'imagetagging-removingtag' => 'Heqja tag ...',
	'imagetagging-addtagsuccess' => 'tag Added.',
	'imagetagging-removetagsuccess' => 'tag Removed.',
	'imagetagging-canteditneedloginmessage' => 'Ju nuk mund ta redaktoni këtë faqe. Kjo mund të jetë për shkak se ju duhet të identifikoheni për tag imazhet. A doni të identifikoheni tani?',
	'imagetagging-oneactionatatimemessage' => 'Vetëm një veprim tagging në një kohë është i lejuar. Ju lutem prisni për të veprimit ekzistues për të kompletuar.',
	'imagetagging-oneuniquetagmessage' => 'Ky imazh tashmë ka një etiketë me këtë emër.',
	'imagetagging-imagetag-seemoreimages' => 'Shihni imazhet më e "$1" ($2)',
	'imagetagging-taggedimages-title' => 'Fotografitë e "$1"',
	'imagetagging-taggedimages-displaying' => 'Shfaqja e $1 - $2 prej $3 imazhet e "$4"',
	'tag-logpagename' => 'Tagging log',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'imagetagging-imghistory' => 'ታሪክ',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 * @author Remember the dot
 */
$messages['an'] = array(
	'imagetagging-article' => 'Pachina:',
	'imagetagging-imghistory' => 'Historial',
	'imagetagging-tagcancel-button' => 'Cancelar',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'taggedimages' => 'صور موسومة',
	'imagetagging-desc' => 'يسمح للمستخدم باختيار مناطق من صورة مضمنة ومصاحبة صفحة مع هذه المنطقة',
	'imagetagging-addimagetag' => 'وسم هذه الصورة',
	'imagetagging-article' => 'صفحة:',
	'imagetagging-articletotag' => 'صفحة للوسم',
	'imagetagging-canteditothermessage' => 'أنت لا يمكنك تعديل هذه الصفحة، إما لأنك لا تمتلك الصلاحية لفعل هذا أو لأن الصفحة محمية لأسباب أخرى.',
	'imagetagging-imghistory' => 'تاريخ',
	'imagetagging-images' => 'صور',
	'imagetagging-inthisimage' => 'في هذه الصورة: $1',
	'imagetagging-logentry' => 'أزال الوسم للصفحة [[$1]] بواسطة $2',
	'imagetagging-log-tagged' => 'الصورة [[$1|$2]] تم وسمها للصفحة [[$3]] بواسطة $4',
	'imagetagging-new' => '<sup><span style="color:red">جديد!</span></sup>',
	'imagetagging-removetag' => 'إزالة وسم',
	'imagetagging-done-button' => 'تم الوسم',
	'imagetagging-tag-button' => 'وسم',
	'imagetagging-tagcancel-button' => 'ألغِ',
	'imagetagging-tagging-instructions' => 'اضغط على الأشخاص أو الأشياء في الصورة لوسمهم.',
	'imagetagging-addingtag' => 'إضافة وسم...',
	'imagetagging-removingtag' => 'إزالة وسم...',
	'imagetagging-addtagsuccess' => 'تمت إضافة الوسم.',
	'imagetagging-removetagsuccess' => 'تمت إزالة الوسم.',
	'imagetagging-canteditneedloginmessage' => 'أنت لا يمكنك تعديل هذه الصفحة.
ربما يكون ذلك بسبب أنك تحتاج إلى تسجيل الدخول لوسم الصور.
هل تريد تسجيل الدخول الآن؟',
	'imagetagging-oneactionatatimemessage' => 'فقط فعل وسم واحد مسموح به كل مرة.
من فضلك انتظر الفعل الموجود ليكتمل.',
	'imagetagging-oneuniquetagmessage' => 'هذه الصورة لديها بالفعل وسم بهذا الاسم.',
	'imagetagging-imagetag-seemoreimages' => 'راجع المزيد من صور "$1" ($2)',
	'imagetagging-taggedimages-title' => 'صور "$1"',
	'imagetagging-taggedimages-displaying' => 'عرض $1 - $2 من $3 صورة ل"$4"',
	'tag-logpagename' => 'سجل الوسم',
	'tag-logpagetext' => 'هذا سجل بكل عمليات إضافة وإزالة وسم الصور.',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'imagetagging-article' => 'ܦܐܬܐ:',
	'imagetagging-imghistory' => 'ܬܫܥܝܬܐ',
	'imagetagging-images' => 'ܨܘܪ̈ܬܐ',
	'imagetagging-inthisimage' => 'ܒܗܕܐ ܨܘܪܬܐ: $1',
	'imagetagging-tagcancel-button' => 'ܒܛܘܠ',
	'imagetagging-taggedimages-title' => 'ܨܘܪ̈ܬܐ ܕ "$1"',
);

/** Araucanian (Mapudungun)
 * @author Remember the dot
 */
$messages['arn'] = array(
	'imagetagging-article' => 'Pakina:',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'taggedimages' => 'صور موسومة',
	'imagetagging-desc' => 'يسمح للمستخدم باختيار مناطق من صورة مضمنة ومصاحبة صفحة مع هذه المنطقة',
	'imagetagging-addimagetag' => 'وسم هذه الصورة',
	'imagetagging-article' => 'صفحة:',
	'imagetagging-articletotag' => 'صفحة للوسم',
	'imagetagging-canteditothermessage' => 'أنت لا يمكنك تعديل هذه الصفحة، إما لأنك لا تمتلك الصلاحية لفعل هذا أو لأن الصفحة محمية لأسباب أخرى.',
	'imagetagging-imghistory' => 'تاريخ',
	'imagetagging-images' => 'صور',
	'imagetagging-inthisimage' => 'فى هذه الصورة: $1',
	'imagetagging-logentry' => 'أزال الوسم للصفحة [[$1]] بواسطة $2',
	'imagetagging-log-tagged' => 'الصورة [[$1|$2]] تم وسمها للصفحة [[$3]] بواسطة $4',
	'imagetagging-new' => '<sup><span style="color:red">جديد!</span></sup>',
	'imagetagging-removetag' => 'إزالة وسم',
	'imagetagging-done-button' => 'تم الوسم',
	'imagetagging-tag-button' => 'وسم',
	'imagetagging-tagcancel-button' => 'إلغاء',
	'imagetagging-tagging-instructions' => 'اضغط على الأشخاص أو الأشياء فى الصورة لوسمهم.',
	'imagetagging-addingtag' => 'إضافة وسم...',
	'imagetagging-removingtag' => 'إزالة وسم...',
	'imagetagging-addtagsuccess' => 'تمت إضافة الوسم.',
	'imagetagging-removetagsuccess' => 'تمت إزالة الوسم.',
	'imagetagging-canteditneedloginmessage' => 'أنت لا يمكنك تعديل هذه الصفحة.
ربما يكون ذلك بسبب أنك تحتاج إلى تسجيل الدخول لوسم الصور.
هل تريد تسجيل الدخول الآن؟',
	'imagetagging-oneactionatatimemessage' => 'فقط فعل وسم واحد مسموح به كل مرة.
من فضلك انتظر الفعل الموجود ليكتمل.',
	'imagetagging-oneuniquetagmessage' => 'هذه الصورة لديها بالفعل وسم بهذا الاسم.',
	'imagetagging-imagetag-seemoreimages' => 'راجع المزيد من صور "$1" ($2)',
	'imagetagging-taggedimages-title' => 'صور "$1"',
	'imagetagging-taggedimages-displaying' => 'عرض $1 - $2 من $3 صورة ل"$4"',
	'tag-logpagename' => 'سجل الوسم',
	'tag-logpagetext' => 'هذا سجل بكل عمليات إضافة وإزالة وسم الصور.',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 * @author Vugar 1981
 */
$messages['az'] = array(
	'imagetagging-article' => 'Səhifə:',
	'imagetagging-imghistory' => 'Tarix',
	'imagetagging-images' => 'şəkillər',
	'imagetagging-done-button' => 'Etiketləmə başa çatdı',
	'imagetagging-tag-button' => 'Etiketlə',
	'imagetagging-tagcancel-button' => 'Ləğv et',
	'imagetagging-tagging-instructions' => 'Etiketləmək üçün şəkilin üzərinə klikləyin.',
	'imagetagging-addingtag' => 'Etiketləmə əlavə edilir...',
	'imagetagging-removingtag' => 'Etiketləmə ləğv edildi...',
	'imagetagging-addtagsuccess' => 'Etiketləmə əlavə edildi.',
	'imagetagging-removetagsuccess' => 'Etiketləmə ləğv edildi.',
);

/** Belarusian (Беларуская)
 * @author Тест
 */
$messages['be'] = array(
	'imagetagging-imghistory' => 'Гісторыя',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'taggedimages' => 'Выявы з пазнакамі',
	'imagetagging-desc' => 'Дазваляе удзельніку выбіраць рэгіёны убудаванай выявы і зьвязваць старонкі з гэтым рэгіёнамі',
	'imagetagging-addimagetag' => 'Пазначыць гэту выяву',
	'imagetagging-article' => 'Старонка:',
	'imagetagging-articletotag' => 'Старонка для пазнакі',
	'imagetagging-canteditothermessage' => 'Вы ня можаце рэдагаваць гэтую старонку, таму што Вы ня маеце адпаведных правоў, альбо таму што старонка абароненая ад рэдагаваньняў па іншых прычынах.',
	'imagetagging-imghistory' => 'Гісторыя',
	'imagetagging-images' => 'выявы',
	'imagetagging-inthisimage' => 'У гэтай выяве: $1',
	'imagetagging-logentry' => 'Выдаленая метка старонкі [[$1]] створаная $2',
	'imagetagging-log-tagged' => 'Выява [[$1|$2]] была зьвязана са старонкай [[$3]] удзельнікам $4',
	'imagetagging-new' => '<sup><span style="color:red">Новая!</span></sup>',
	'imagetagging-removetag' => 'выдаліць метку',
	'imagetagging-done-button' => 'Стварыць метку',
	'imagetagging-tag-button' => 'Метка',
	'imagetagging-tagcancel-button' => 'Скасаваць',
	'imagetagging-tagging-instructions' => 'Пазначце людзей ці рэчы ў выяве, якіх трэба памеціць.',
	'imagetagging-addingtag' => 'Даданьне меткі…',
	'imagetagging-removingtag' => 'Выдаленьне меткі…',
	'imagetagging-addtagsuccess' => 'Метка дададзеная.',
	'imagetagging-removetagsuccess' => 'Метка выдаленая.',
	'imagetagging-canteditneedloginmessage' => 'Вы ня можаце рэдагаваць гэтую старонку.
Вам неабходна ўвайсьці ў сыстэму, каб пазначаць выявы.
Вы жадаеце ўвайсьці ў сыстэму зараз?',
	'imagetagging-oneactionatatimemessage' => 'Адначасова можна пазначыць толькі адзін раз.
Пачакайце заканчэньне дзеяньня, якое адбываецца зараз.',
	'imagetagging-oneuniquetagmessage' => 'Гэта выява ўжо зьвязана з гэтай назвай.',
	'imagetagging-imagetag-seemoreimages' => 'Паглядзець болей выяваў «$1» ($2)',
	'imagetagging-taggedimages-title' => 'Выявы «$1»',
	'imagetagging-taggedimages-displaying' => 'Паказаныя $1 - $2 выяваў $3 удзельніка «$4»',
	'tag-logpagename' => 'Журнал метак',
	'tag-logpagetext' => 'Гэта журнал даданьня і выдаленьня метак выяваў.',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'imagetagging-article' => 'Страница:',
	'imagetagging-imghistory' => 'История',
	'imagetagging-images' => 'картинки',
	'imagetagging-inthisimage' => 'В тази картинка: $1',
	'imagetagging-new' => '<sup><span style="color:red">Ново!</span></sup>',
	'imagetagging-tagcancel-button' => 'Отказване',
	'imagetagging-imagetag-seemoreimages' => 'Преглеждане на още снимки на „$1“ ($2)',
	'imagetagging-taggedimages-displaying' => 'Показване на $1 - $2 от $3 снимки на „$4“',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'taggedimages' => 'ট্যাগকৃত চিত্রসমূহ',
	'imagetagging-addimagetag' => 'এই ছবিটি ট্যাগ করো',
	'imagetagging-article' => 'পাতা:',
	'imagetagging-articletotag' => 'পাতায় ট্যাগ করো',
	'imagetagging-imghistory' => 'ইতিহাস',
	'imagetagging-images' => 'চিত্রসমূহ',
	'imagetagging-inthisimage' => 'এই ছবিতে: $1',
	'imagetagging-removetag' => 'ট্যাগ অপসারণ:',
	'imagetagging-done-button' => 'ট্যাগিং সম্পূর্ণ',
	'imagetagging-tag-button' => 'ট্যাগ',
	'imagetagging-tagcancel-button' => 'বাতিল',
	'imagetagging-addingtag' => 'ট্যাগ যোগ..',
	'imagetagging-removingtag' => 'ট্যাগ অপসারণ..',
	'imagetagging-addtagsuccess' => 'ট্যাগ যোগ করা হয়েছে।',
	'imagetagging-removetagsuccess' => 'ট্যাগ অপসারণ করা হয়েছে।',
	'imagetagging-taggedimages-title' => '"$1"-এর ছবি',
	'tag-logpagename' => 'ট্যাগিং লগ',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'taggedimages' => 'Skeudennoù balizennet',
	'imagetagging-desc' => "Talvezout a ra d'an implijerien da diuzañ lodennoù eus ur skeudenn enframmet evit he stagañ ouzh ur bajenn.",
	'imagetagging-addimagetag' => 'Balizennañ ar skeudenn-mañ',
	'imagetagging-article' => 'Pajenn :',
	'imagetagging-articletotag' => 'Pajenn da valizennañ',
	'imagetagging-canteditothermessage' => "Ne c'hellit ket kemmañ ar bajenn-mañ, pe n'oc'h ket aotreet d'en ober pe ez eo gwarezet ar bajenn-mañ evit abegoù all.",
	'imagetagging-imghistory' => 'Istor',
	'imagetagging-images' => 'skeudennoù',
	'imagetagging-inthisimage' => 'Er skeudenn-mañ : $1',
	'imagetagging-logentry' => 'Balizenn bet tennet eus ar bajenn [[$1]] gant $2',
	'imagetagging-log-tagged' => "Ar skeudenn [[$1|$2]] a zo bet balizennet d'ar bajenn [[$3]] gant $4",
	'imagetagging-new' => '<sup><span style="color:red">Nevez!</span></sup>',
	'imagetagging-removetag' => 'Lemel ar valizenn',
	'imagetagging-done-button' => 'Graet eo ar balizennañ',
	'imagetagging-tag-button' => 'Balizenn',
	'imagetagging-tagcancel-button' => 'Nullañ',
	'imagetagging-tagging-instructions' => 'Klikañ war an dud pe an traoù er skeudenn evit balizennañ anezho.',
	'imagetagging-addingtag' => "Oc'h ouzhpennañ ur balizenn...",
	'imagetagging-removingtag' => 'O tennañ ur balizenn...',
	'imagetagging-addtagsuccess' => 'Ouzhpennet eo ar valizenn',
	'imagetagging-removetagsuccess' => 'Tennet eo bet ar balizenn.',
	'imagetagging-canteditneedloginmessage' => "Ne c'hallit ket aozañ ar bajenn-mañ.
Marteze e rankit kevreañ evit balizennañ ar skeudennoù.
Ha c'hoant hoc'h eus da gevreañ bremañ ?",
	'imagetagging-oneactionatatimemessage' => "N'haller kas da benn nemet ur balizadur war un dro.
Gortozit 'ta ma vo echuet an oberiadenn.",
	'imagetagging-oneuniquetagmessage' => 'Ar skeudenn-mañ he deus dija ur balizenn gant an anv-se.',
	'imagetagging-imagetag-seemoreimages' => 'Gwelet muioc\'h a skeudennoù eus "$1" ($2)',
	'imagetagging-taggedimages-title' => 'Skeudennoù eus « $1 »',
	'imagetagging-taggedimages-displaying' => 'Diskwel ar skeudennoù $1 – $2 war $3 eus "$4"',
	'tag-logpagename' => 'Marilh ar balizennañ',
	'tag-logpagetext' => 'Ar bajenn-mañ a zo marilh an holl balizennoù skeudennoù bet ouzhpennet pe tennet.',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'taggedimages' => 'Označene slike',
	'imagetagging-desc' => 'Omogućuje korisniku da odabere regione uklopljene slike i poveže ih sa željenom stranicom',
	'imagetagging-addimagetag' => 'Označi ovu sliku',
	'imagetagging-article' => 'Stranica:',
	'imagetagging-articletotag' => 'Stranica za označavanje',
	'imagetagging-canteditothermessage' => 'Ne možete uređivati ovu stranicu, ili nemate prava da to učinite ili jer je stranica zaključana iz drugih razloga.',
	'imagetagging-imghistory' => 'Historija',
	'imagetagging-images' => 'slike',
	'imagetagging-inthisimage' => 'Na ovoj slici: $1',
	'imagetagging-logentry' => 'Uklonjene oznake sa stranice [[$1]] od strane $2',
	'imagetagging-log-tagged' => 'Slika [[$1|$2]] je označena na stranici [[$3]] od strane $4',
	'imagetagging-new' => '<sup><span style="color:red">Novo!</span></sup>',
	'imagetagging-removetag' => 'uklanjanje oznake',
	'imagetagging-done-button' => 'Završi označavanje',
	'imagetagging-tag-button' => 'Označi',
	'imagetagging-tagcancel-button' => 'Odustani',
	'imagetagging-tagging-instructions' => 'Kliknite na osobe ili predmete na slici da ih označite.',
	'imagetagging-addingtag' => 'Dodajem oznaku…',
	'imagetagging-removingtag' => 'Uklanjam oznaku…',
	'imagetagging-addtagsuccess' => 'Dodana oznaka.',
	'imagetagging-removetagsuccess' => 'Uklonjena oznaka.',
	'imagetagging-canteditneedloginmessage' => 'Ne možete uređivati ovu stranicu.
Razlog može biti Vaša prijava za označavanje slika.
Da li se želite odmah prijaviti?',
	'imagetagging-oneactionatatimemessage' => 'Samo jedna akcija označavanja odjednom je dozvoljena.
Molimo pričekajte da se trenutna akcija završi.',
	'imagetagging-oneuniquetagmessage' => 'Ova slika već ima oznaku sa ovim nazivom.',
	'imagetagging-imagetag-seemoreimages' => 'Vidi više slika od "$1" ($2)',
	'imagetagging-taggedimages-title' => 'Slike od "$1"',
	'imagetagging-taggedimages-displaying' => 'Prikazane su $1 - $2 od $3 slika iz "$4"',
	'tag-logpagename' => 'Zapisnik označavanja',
	'tag-logpagetext' => 'Ovo je zapisnik svih dodavanja i uklanjanja oznaka slika.',
);

/** Catalan (Català)
 * @author Paucabot
 */
$messages['ca'] = array(
	'imagetagging-article' => 'Pàgina:',
	'imagetagging-imghistory' => 'Historial',
	'imagetagging-tag-button' => 'Etiqueta',
	'imagetagging-tagcancel-button' => 'Cancel·la',
	'imagetagging-addtagsuccess' => 'Etiqueta afegida.',
	'imagetagging-removetagsuccess' => 'Etiqueta eliminada.',
	'imagetagging-taggedimages-title' => 'Imatges de "$1"',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'taggedimages' => 'Označené obrázky',
	'imagetagging-desc' => 'Umožňuje uživatelům vybrat oblasti vloženého obrázku a k dané oblasti přiřadti stránku.',
	'imagetagging-addimagetag' => 'Označit tento obrázek',
	'imagetagging-article' => 'Stránka:',
	'imagetagging-articletotag' => 'Označit stránku:',
	'imagetagging-imghistory' => 'Historie',
	'imagetagging-images' => 'obrázky',
	'imagetagging-inthisimage' => 'V tomto obrázku: $1',
	'imagetagging-logentry' => '$2 odstranil značku na stránku [[$1]]',
	'imagetagging-log-tagged' => '$4 označil obrázek [[$1|$2]] na stránku [[$3]]',
	'imagetagging-new' => '<sup><span style="color: red;">Nové!</span></sup>',
	'imagetagging-removetag' => 'odstranit značku',
	'imagetagging-done-button' => 'Ukončit označování',
	'imagetagging-tag-button' => 'Značka',
	'imagetagging-tagcancel-button' => 'Zrušit',
	'imagetagging-tagging-instructions' => 'Kliknutím na ludi nebo věci na obrázku je můžete označit.',
	'imagetagging-addingtag' => 'Přidává se značka…',
	'imagetagging-removingtag' => 'Odstraňuje se značka…',
	'imagetagging-addtagsuccess' => 'Přidána značka.',
	'imagetagging-removetagsuccess' => 'Odstraněna značka.',
	'imagetagging-oneuniquetagmessage' => 'Tento obrázek už má značku s takovým názvem.',
	'imagetagging-imagetag-seemoreimages' => 'Zobrazit více obrázků „$1” ($2)',
	'imagetagging-taggedimages-title' => 'Obrázky „$1”',
	'imagetagging-taggedimages-displaying' => 'Zobrazuje se $1 - $2 z $3 obrázků „$4”',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'imagetagging-taggedimages-title' => 'Delweddau "$1"',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author DaSch
 * @author Imre
 * @author Kghbln
 * @author Melancholie
 * @author Purodha
 * @author Revolus
 * @author Umherirrender
 */
$messages['de'] = array(
	'taggedimages' => 'Bilder mit Tags',
	'imagetagging-desc' => 'Ermöglicht es Benutzern, Bereiche von eingebetteten Bildern auszuwählen und diese mit einer Seite zu verknüpfen',
	'imagetagging-addimagetag' => 'Markierungen auf diesem Bild zufügen',
	'imagetagging-article' => 'Seite:',
	'imagetagging-articletotag' => 'Seite, die getaggt wird',
	'imagetagging-canteditothermessage' => 'Du kannst diese Seite nicht bearbeiten, weil du entweder keine Berechtigung dazu hast oder weil die Seite aus einem anderen Grund gesperrt ist.',
	'imagetagging-imghistory' => 'Versionen',
	'imagetagging-images' => 'Bild',
	'imagetagging-inthisimage' => 'Auf diesem Bild: $1',
	'imagetagging-logentry' => 'Tag auf Seite [[$1]] wurde durch $2 entfernt',
	'imagetagging-log-tagged' => 'Bild [[$1|$2]] wurde von $4 markiert und mit [[$3]] verlinkt',
	'imagetagging-new' => '<sup><span style="color:red">Neu!</span></sup>',
	'imagetagging-removetag' => 'Tag entfernen',
	'imagetagging-done-button' => 'Tagging erledigt',
	'imagetagging-tag-button' => 'Taggen',
	'imagetagging-tagcancel-button' => 'Abbrechen',
	'imagetagging-tagging-instructions' => 'Klicke auf Personen oder Dinge in dem Bild, um sie mit einem Tag zu versehen.',
	'imagetagging-addingtag' => 'Füge Tag hinzu …',
	'imagetagging-removingtag' => 'Entferne Tag …',
	'imagetagging-addtagsuccess' => 'Hinzugefügte Tags.',
	'imagetagging-removetagsuccess' => 'Entfernte Tags.',
	'imagetagging-canteditneedloginmessage' => 'Du kannst diese Seite nicht bearbeiten.
Möglicherweise musst du dich anmelden, um Bilder zu taggen.
Möchtest du dich jetzt anmelden?',
	'imagetagging-oneactionatatimemessage' => 'Es ist nur eine gleichzeitige Tagging-Aktion erlaubt.
Bitte warte, bis die momentane Aktion abgeschlossen ist.',
	'imagetagging-oneuniquetagmessage' => 'Dieses Bild hat bereits einen Tag mit diesem Namen.',
	'imagetagging-imagetag-seemoreimages' => 'Siehe mehr Bilder von „$1“ ($2)',
	'imagetagging-taggedimages-title' => 'Bilder von „$1“',
	'imagetagging-taggedimages-displaying' => 'Angezeigt werden $1 - $2 von $3 Bilder aus „$4“',
	'tag-logpagename' => 'Tagging-Logbuch',
	'tag-logpagetext' => 'Dies ist ein Logbuch aller hinzugefügten und entfernten Bildertags.',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author ChrisiPK
 * @author Imre
 */
$messages['de-formal'] = array(
	'imagetagging-canteditothermessage' => 'Sie können diese Seite nicht bearbeiten, weil Sie entweder keine Berechtigung dazu haben oder weil die Seite aus einem anderen Grund gesperrt ist.',
	'imagetagging-tagging-instructions' => 'Klicken Sie auf Personen oder Dinge in dem Bild, um sie mit einem Tag zu versehen.',
	'imagetagging-canteditneedloginmessage' => 'Sie können diese Seite nicht bearbeiten.
Möglicherweise müssen Sie sich anmelden, um Bilder zu taggen.
Möchten Sie sich jetzt anmelden?',
	'imagetagging-oneactionatatimemessage' => 'Es ist nur eine gleichzeitige Tagging-Aktion erlaubt.
Bitte warten Sie, bis die momentane Aktion abgeschlossen ist.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'taggedimages' => 'Wobznamjenjone wobraze',
	'imagetagging-desc' => 'Zmóžnja wužywarjeju regiony ze zasajźonego wobraza wubraś a bok z toś tym regionom zwězaś',
	'imagetagging-addimagetag' => 'Toś ten wobraz wobznamjeniś',
	'imagetagging-article' => 'Bok:',
	'imagetagging-articletotag' => 'Bok, kótaryž ma se wobznamjeniś',
	'imagetagging-canteditothermessage' => 'Njamóžoš toś ten bok wobźěłaś, pak, dokulaž njamaš pšawa, aby to cynił, pak, dokulaž bok jo zastajony z drugich pśicynow.',
	'imagetagging-imghistory' => 'Stawizny',
	'imagetagging-images' => 'wobraze',
	'imagetagging-inthisimage' => 'W toś tom wobrazu: $1',
	'imagetagging-logentry' => 'Wobznamjenje k bokoju [[$1]] wót $2 wótpórane',
	'imagetagging-log-tagged' => 'Wobraz [[$1|$2]] jo se wobznamjenił k bokoju [[$3]] wót $4',
	'imagetagging-new' => '<sup><span style="color:red">Nowy!</span></sup>',
	'imagetagging-removetag' => 'Wobznamjenje wótpóraś',
	'imagetagging-done-button' => 'Wobznamjenjowanje wótbyte',
	'imagetagging-tag-button' => 'Wobznamjeniś',
	'imagetagging-tagcancel-button' => 'Pśetergnuś',
	'imagetagging-tagging-instructions' => 'Klikni na luźi abo wěcy we wobrazu, aby je wobznamjenił.',
	'imagetagging-addingtag' => 'Wobznamjenje se pśidawa...',
	'imagetagging-removingtag' => 'Wobznamjenje se wótwónoźujo...',
	'imagetagging-addtagsuccess' => 'Pśidane wobznamjenje.',
	'imagetagging-removetagsuccess' => 'Wótpórane wobznamjenje.',
	'imagetagging-canteditneedloginmessage' => 'Njamóžoš toś ten bok wobźěłaś.
Snaź musyš se pśizjawiś, aby wobznamjenił wobraze.
Coš se něnto pśizjawiś?',
	'imagetagging-oneactionatatimemessage' => 'Jano jadna wobznamjenjowańska akcija jo naraz dowólona.
Pšosym cakaj, až eksistěrujuca akcija jo se skóńcyła.',
	'imagetagging-oneuniquetagmessage' => 'Toś ten wobraz ma južo wobznamjenje z toś tym mjenim.',
	'imagetagging-imagetag-seemoreimages' => 'Glědaj dalšne wobraze wót "$1" ($2)',
	'imagetagging-taggedimages-title' => 'Wobraze wót "$1"',
	'imagetagging-taggedimages-displaying' => '{{PLURAL:$1|Zwobraznjujo|Zwobraznjujotej|Zwobraznjuju|Zwobraznjujo}} se $1 -  $2 z $3 wobrazow wót "$4"',
	'tag-logpagename' => 'Protokol wobznamjenjowanja',
	'tag-logpagetext' => 'To jo protokol wšych pśidanjow a wótpóranjow wobrazowych wobznamjenjow.',
);

/** Ewe (Eʋegbe) */
$messages['ee'] = array(
	'imagetagging-article' => 'Axa:',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['el'] = array(
	'taggedimages' => 'Εικόνες με ετικέτες',
	'imagetagging-addimagetag' => 'Τοποθέτηση ετικέτας σε αυτή την σελίδα',
	'imagetagging-article' => 'Σελίδα:',
	'imagetagging-articletotag' => 'Σελίδα στην οποία να μπει ετικέτα',
	'imagetagging-imghistory' => 'Ιστορικό',
	'imagetagging-images' => 'εικόνες',
	'imagetagging-inthisimage' => 'Σε αυτήν την εικόνα: $1',
	'imagetagging-new' => '<sup><span style="color:red">Νέο!</span></sup>',
	'imagetagging-removetag' => 'αφαίρεση ετικέτας',
	'imagetagging-done-button' => 'Η τοποθέτηση ετικετών ολοκληρώθηκε',
	'imagetagging-tag-button' => 'Ετικέτα',
	'imagetagging-tagcancel-button' => 'Ακύρωση',
	'imagetagging-addingtag' => 'Προστίθεται η ετικέτα...',
	'imagetagging-removingtag' => 'Αφαιρείται η ετικέτα...',
	'imagetagging-addtagsuccess' => 'Η ετικέτα προστέθηκε.',
	'imagetagging-removetagsuccess' => 'Η ετικέτα αφαιρέθηκε.',
	'imagetagging-imagetag-seemoreimages' => 'Προβολή περισσότερων εικόνων του "$1" ($2)',
	'imagetagging-taggedimages-title' => 'Εικόνες του "$1"',
	'tag-logpagename' => 'Αρχείο ετικετών',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'taggedimages' => 'Bildoj kun etikedoj',
	'imagetagging-addimagetag' => 'Marki ĉi tiun bildon',
	'imagetagging-article' => 'Paĝo',
	'imagetagging-articletotag' => 'Paĝo por marki',
	'imagetagging-imghistory' => 'Historio',
	'imagetagging-images' => 'bildoj',
	'imagetagging-inthisimage' => 'En ĉi tiu bildo: $1',
	'imagetagging-logentry' => 'Forigis etikedon de pago [[$1]] de $2',
	'imagetagging-log-tagged' => 'Bildo [[$1|$2]] ricevis etikedon al paĝo [[$3]] de $4',
	'imagetagging-new' => '<sup><span style="color:red">Nova!</span></sup>',
	'imagetagging-removetag' => 'forigi etikedon',
	'imagetagging-done-button' => 'Etikeda markado estas finita.',
	'imagetagging-tag-button' => 'Etikedo',
	'imagetagging-tagcancel-button' => 'Nuligi',
	'imagetagging-tagging-instructions' => 'Klaku homojn aŭ aĵojn en la bildo por marki kun etikedo.',
	'imagetagging-addingtag' => 'Aldonante etikedon...',
	'imagetagging-removingtag' => 'Forigante markon...',
	'imagetagging-addtagsuccess' => 'Aldoniĝis etikedo.',
	'imagetagging-removetagsuccess' => 'Foriĝis etikedo.',
	'imagetagging-canteditneedloginmessage' => 'Vi ne povas redakti ĉi tiun paĝon.
Eble tial vi devas ensaluti por aldoni etikedojn al bildoj.
Ĉu vi volas ensaluti nun?',
	'imagetagging-oneuniquetagmessage' => 'Ĉi tiu bildo jam havas etikedon kun ĉi tiu nomo.',
	'imagetagging-imagetag-seemoreimages' => 'Vidi pluajn bildojn pri "$1" ($2)',
	'imagetagging-taggedimages-title' => 'Bildoj de "$1"',
	'imagetagging-taggedimages-displaying' => 'Montrante $1 - $2 de $3 bildoj de "$4"',
	'tag-logpagename' => 'Etikeda protokolo',
	'tag-logpagetext' => 'Jen protokolo de ĉiuj aldonoj kaj forigoj de bildaj etikedoj.',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Imre
 * @author Mor
 * @author Translationista
 */
$messages['es'] = array(
	'taggedimages' => 'imágenes etiquetadas',
	'imagetagging-desc' => 'Permite a un usuario seleccionar regiones de una imagen incrustada y asociar una página a esa región',
	'imagetagging-addimagetag' => 'Etiquetar esta imagen',
	'imagetagging-article' => 'Página:',
	'imagetagging-articletotag' => 'Página a etiquetar',
	'imagetagging-canteditothermessage' => 'No puedes editar esta página porque no tienes permisos o porque la página está bloqueada por otras razones.',
	'imagetagging-imghistory' => 'Historial',
	'imagetagging-images' => 'imágenes',
	'imagetagging-inthisimage' => 'En esta imagen : $1',
	'imagetagging-logentry' => 'Se eliminó la etiqueta de la página [[$1]] por $2',
	'imagetagging-log-tagged' => 'La imagen [[$1|$2]] fue etiquetada hacia la página [[$3]] por $4',
	'imagetagging-new' => '<sup><span style="color:red">Nuevo!</span></sup>',
	'imagetagging-removetag' => 'remover etiqueta',
	'imagetagging-done-button' => 'Etiquetado hecho',
	'imagetagging-tag-button' => 'Etiqueta',
	'imagetagging-tagcancel-button' => 'Cancelar',
	'imagetagging-tagging-instructions' => 'Haz click sobre personas o cosas en la imagen para etiquetarles.',
	'imagetagging-addingtag' => 'Agregando etiqueta...',
	'imagetagging-removingtag' => 'Removiendo etiqueta...',
	'imagetagging-addtagsuccess' => 'Etiqueta agregada.',
	'imagetagging-removetagsuccess' => 'Etiqueta eliminada.',
	'imagetagging-canteditneedloginmessage' => 'No puede editar esta página.
Es posible que se deba a que tenga que acceder para etiquetar imágenes.
¿Desea acceder ahora?',
	'imagetagging-oneactionatatimemessage' => 'Sólo se permite un etiquetado a la vez.
Por favor, espere hasta que se complete la acción que se está ejecutando.',
	'imagetagging-oneuniquetagmessage' => 'Esta imagen ya tiene una etiqueta con este nombre.',
	'imagetagging-imagetag-seemoreimages' => 'Ver más imágenes de "$1" ($2)',
	'imagetagging-taggedimages-title' => 'Imágenes de "$1"',
	'imagetagging-taggedimages-displaying' => 'Mostrando $1 - $2 de $3 imágenes de "$4"',
	'tag-logpagename' => 'Registro de etiquetado',
	'tag-logpagetext' => 'Este es un registro de todas las adiciones y eliminaciones de etiquetas de imágenes.',
);

/** Estonian (Eesti)
 * @author Pikne
 */
$messages['et'] = array(
	'imagetagging-article' => 'Lehekülg:',
	'imagetagging-tagcancel-button' => 'Loobu',
	'tag-logpagename' => 'Märgistamislogi',
	'tag-logpagetext' => 'Sellel leheküljel on kõigi pildimärgiste lisamiste ja eemaldamiste logi.',
);

/** Finnish (Suomi)
 * @author Jack Phoenix
 */
$messages['fi'] = array(
	'taggedimages' => 'Merkityt kuvat',
	'imagetagging-addimagetag' => 'Merkitse tämä kuva',
	'imagetagging-article' => 'Sivu:',
	'imagetagging-canteditothermessage' => 'Et voi muokata tätä sivua, joko koska sinulla ei ole oikeuksia tai koska sivu on lukittu muista syistä.',
	'imagetagging-imghistory' => 'Historia',
	'imagetagging-images' => 'kuvat',
	'imagetagging-inthisimage' => 'Tässä kuvassa: $1',
	'imagetagging-logentry' => 'Poistettiin merkintä sivulle [[$1]] käyttäjän $2 toimesta',
	'imagetagging-log-tagged' => 'Kuva [[$1|$2]] merkittiin sivulle [[$3]] käyttäjän $4 toimesta',
	'imagetagging-new' => '<sup><span style="color:red">Uusi!</span></sup>',
	'imagetagging-removetag' => 'poista merkintä',
	'imagetagging-done-button' => 'Valmis',
	'imagetagging-tag-button' => 'Jatka',
	'imagetagging-tagcancel-button' => 'Peruuta',
	'imagetagging-tagging-instructions' => 'Napsauta ihmisiä tai asioita kuvassa merkitäksesi ne.',
	'imagetagging-addingtag' => 'Lisätään merkintää…',
	'imagetagging-removingtag' => 'Poistetaan merkintää…',
	'imagetagging-addtagsuccess' => 'Merkintä lisätty.',
	'imagetagging-removetagsuccess' => 'Merkintä poistettu.',
	'imagetagging-canteditneedloginmessage' => 'Et voi muokata tätä sivua.
Se saattaa johtua siitä, että sinun tulee kirjautua sisään merkitäksesi kuvia.
Haluatko kirjautua sisään nyt?',
	'imagetagging-oneactionatatimemessage' => 'Vain yksi merkitsemistapahtuma kerrallaan on sallittu.
Ole hyvä ja odota olemassaolevan tapahtuman päättymistä.',
	'imagetagging-oneuniquetagmessage' => 'Tällä kuvalla on jo samanniminen merkintä.',
	'imagetagging-imagetag-seemoreimages' => 'Katso lisää kuvia aiheesta "$1" ($2)',
	'imagetagging-taggedimages-title' => 'Kuvia aiheesta "$1"',
	'imagetagging-taggedimages-displaying' => 'Näytetään $1 - $2 kuvaa aiheesta "$4"; yhteensä $3 kuvaa',
	'tag-logpagename' => 'Merkintäloki',
	'tag-logpagetext' => 'Tämä on loki kaikista kuvien merkinnöistä ja merkintöjen poistoista.',
);

/** French (Français)
 * @author Cedric31
 * @author Grondin
 * @author McDutchie
 * @author Verdy p
 */
$messages['fr'] = array(
	'taggedimages' => 'Images balisées',
	'imagetagging-desc' => "Permet à un utilisateur de sélectionner les régions d’une image incrustée pour l'associer à une page.",
	'imagetagging-addimagetag' => 'Baliser cette image',
	'imagetagging-article' => 'Page :',
	'imagetagging-articletotag' => 'Page à baliser',
	'imagetagging-canteditothermessage' => 'Vous ne pouvez pas modifier cette page, soit parce que vous n’en disposez pas des droits nécessaire soit parce que la page est verrouillée pour diverses raisons.',
	'imagetagging-imghistory' => 'Historique',
	'imagetagging-images' => 'images',
	'imagetagging-inthisimage' => 'Dans cette image : $1',
	'imagetagging-logentry' => 'Balise retirée de la page [[$1]] par $2',
	'imagetagging-log-tagged' => "L'image [[$1|$2]] a été balisée pour la page [[$3]] par $4",
	'imagetagging-new' => '<sup><span style="color:red">Nouveau !</span></sup>',
	'imagetagging-removetag' => 'retirer la balise',
	'imagetagging-done-button' => 'Balisage effectué',
	'imagetagging-tag-button' => 'Balise',
	'imagetagging-tagcancel-button' => 'Annuler',
	'imagetagging-tagging-instructions' => 'Cliquer sur les personnes ou les choses dans l’image pour les baliser.',
	'imagetagging-addingtag' => 'Balise en cours d’ajout…',
	'imagetagging-removingtag' => 'Balise en cours de retrait…',
	'imagetagging-addtagsuccess' => 'Balise ajoutée.',
	'imagetagging-removetagsuccess' => 'Balise retirée.',
	'imagetagging-canteditneedloginmessage' => 'Vous ne pouvez pas modifier cette page.
Il se peut que vous deviez d’abord vous connecter pour baliser les images.
Voulez-vous vous connecter maintenant ?',
	'imagetagging-oneactionatatimemessage' => 'Une seule action de balisage est permise à la fois.
Veuillez attendre la fin de l’action en cours.',
	'imagetagging-oneuniquetagmessage' => 'Cette image a déjà une balise avec ce nom.',
	'imagetagging-imagetag-seemoreimages' => 'Voir plus d’images de « $1 » ($2)',
	'imagetagging-taggedimages-title' => 'Images de « $1 »',
	'imagetagging-taggedimages-displaying' => 'Affichage des images $1 – $2 sur $3 de « $4 »',
	'tag-logpagename' => 'Journal du balisage',
	'tag-logpagetext' => 'Ceci est le journal de tous les ajouts et de toutes les suppressions des balises d’image.',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'taggedimages' => 'Émâges balisâs',
	'imagetagging-addimagetag' => 'Balisar ceta émâge',
	'imagetagging-article' => 'Pâge :',
	'imagetagging-articletotag' => 'Pâge a balisar',
	'imagetagging-imghistory' => 'Historico',
	'imagetagging-images' => 'émâges',
	'imagetagging-inthisimage' => 'Dens ceta émâge : $1',
	'imagetagging-logentry' => 'Balisa enlevâ de la pâge [[$1]] per $2',
	'imagetagging-log-tagged' => 'L’émâge [[$1|$2]] at étâ balisâ por la pâge [[$3]] per $4',
	'imagetagging-new' => '<sup><span style="color:red">Novél !</span></sup>',
	'imagetagging-removetag' => 'enlevar la balisa',
	'imagetagging-done-button' => 'Balisâjo fêt',
	'imagetagging-tag-button' => 'Balisa',
	'imagetagging-tagcancel-button' => 'Anular',
	'imagetagging-addingtag' => 'Balisa en cors d’aponsa…',
	'imagetagging-removingtag' => 'Balisa en cors de retrèt…',
	'imagetagging-addtagsuccess' => 'Balisa apondua.',
	'imagetagging-removetagsuccess' => 'Balisa enlevâ.',
	'imagetagging-imagetag-seemoreimages' => 'Vêde més d’émâges de « $1 » ($2)',
	'imagetagging-taggedimages-title' => 'Émâges de « $1 »',
	'tag-logpagename' => 'Jornal du balisâjo',
);

/** Western Frisian (Frysk)
 * @author SK-luuut
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'imagetagging-article' => 'Side:',
	'imagetagging-tagcancel-button' => 'Ofbrekke',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'taggedimages' => 'Imaxes con etiquetas',
	'imagetagging-desc' => 'Deixa que un usuario seleccione as rexións dunha imaxe embebida e asociar unha páxina con esa rexión',
	'imagetagging-addimagetag' => 'Pór unha etiqueta a esta imaxe',
	'imagetagging-article' => 'Páxina:',
	'imagetagging-articletotag' => 'Páxinar para pór a etiqueta',
	'imagetagging-canteditothermessage' => 'Non pode editar esta páxina. Se ben pode ser porque non ten os permisos para facelo ou porque a páxina está protexida por outras razóns.',
	'imagetagging-imghistory' => 'Historial',
	'imagetagging-images' => 'imaxes',
	'imagetagging-inthisimage' => 'Nesta imaxe: $1',
	'imagetagging-logentry' => 'Eliminouse a etiqueta da páxina [[$1]] por $2',
	'imagetagging-log-tagged' => 'A etiqueta da imaxe [[$1|$2]] para a páxina [[$3]] foi posta por $4',
	'imagetagging-new' => '<sup><span style="color:red">Novo!</span></sup>',
	'imagetagging-removetag' => 'eliminar a etiqueta',
	'imagetagging-done-button' => 'A etiqueta foi posta',
	'imagetagging-tag-button' => 'Pór a etiqueta',
	'imagetagging-tagcancel-button' => 'Cancelar',
	'imagetagging-tagging-instructions' => 'Faga clic sobre a xente ou as cousas da imaxe para pórlles a etiqueta.',
	'imagetagging-addingtag' => 'Engadindo a etiqueta…',
	'imagetagging-removingtag' => 'Eliminando a etiqueta…',
	'imagetagging-addtagsuccess' => 'A etiqueta foi engadida.',
	'imagetagging-removetagsuccess' => 'A etiqueta foi eliminada.',
	'imagetagging-canteditneedloginmessage' => 'Non pode editar esta páxina.
Pode ser porque precise acceder ao sistema para pór etiquetas ás imaxes.
Desexa acceder ao sistema agora?',
	'imagetagging-oneactionatatimemessage' => 'Só se lle está permitido realizar unha acción á vez.
Por favor, agarde a que a acción actual remate.',
	'imagetagging-oneuniquetagmessage' => 'Esta imaxe xa ten unha etiqueta con ese nome.',
	'imagetagging-imagetag-seemoreimages' => 'Ver máis imaxes de "$1" ($2)',
	'imagetagging-taggedimages-title' => 'Imaxes de "$1"',
	'imagetagging-taggedimages-displaying' => 'Mostrando da $1 á $2, dun total de $3 imaxes de "$4"',
	'tag-logpagename' => 'Rexistro de etiquetas',
	'tag-logpagetext' => 'Este é un rexitro de todas as incorporacións e eliminacións de etiquetas de imaxe.',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'imagetagging-article' => 'Δέλτος:',
	'imagetagging-imghistory' => 'Αἱ προτέραι',
	'imagetagging-images' => 'εἰκόνες',
	'imagetagging-tag-button' => 'Προσάρτημα',
	'imagetagging-tagcancel-button' => 'Ἀκυροῦν',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'taggedimages' => 'Bilder mit Tag',
	'imagetagging-desc' => 'Macht s Benutzer megli, Berych vu yybettete Bilder uuszwehlen un die mit ere Syte z verchnipfe',
	'imagetagging-addimagetag' => 'Tag zue däm Bild zuefiege',
	'imagetagging-article' => 'Syte:',
	'imagetagging-articletotag' => 'Syte, wu taggt wird',
	'imagetagging-canteditothermessage' => 'Du chasch die Syte nit bearbeite, wel Du kei Berächtigung dezu hesch oder wel d Syten us eme andre Grund gsperrt isch.',
	'imagetagging-imghistory' => 'Versione',
	'imagetagging-images' => 'Bilder',
	'imagetagging-inthisimage' => 'In däm Bild: $1',
	'imagetagging-logentry' => 'Tag uf dr Syte [[$1]] isch dur $2 usegnuh wore',
	'imagetagging-log-tagged' => 'Bild [[$1|$2]] isch vu $4 mit [[$3]] taggt wore',
	'imagetagging-new' => '<sup><span style="color:red">Nej!</span></sup>',
	'imagetagging-removetag' => 'Tag useneh',
	'imagetagging-done-button' => 'Tagging isch gmacht',
	'imagetagging-tag-button' => 'Tagge',
	'imagetagging-tagcancel-button' => 'Abbräche',
	'imagetagging-tagging-instructions' => 'Druck uf Lyt oder Ding im Bild go si tagge.',
	'imagetagging-addingtag' => 'Fiegt e Tag zue ...',
	'imagetagging-removingtag' => 'Nimmt Tag use ...',
	'imagetagging-addtagsuccess' => 'Zuegfiegti Tag.',
	'imagetagging-removetagsuccess' => 'Tag, wu usegnuh wore sin.',
	'imagetagging-canteditneedloginmessage' => 'Du chasch die Syte nit bearbeite.
Villicht muesch Di aamälde go Bilder tagge.
Mechtsch Di jetz aamälde?',
	'imagetagging-oneactionatatimemessage' => 'Nume ei Tagging-Aktion isch ufeimol erlaubt.
Bitte wart, bis di momentan Aktion abgschlossen isch.',
	'imagetagging-oneuniquetagmessage' => 'Des Bild het scho ne Tag mit däm Name.',
	'imagetagging-imagetag-seemoreimages' => 'Lueg meh Bilder vu „$1“ ($2)',
	'imagetagging-taggedimages-title' => 'Bilder vu „$1“',
	'imagetagging-taggedimages-displaying' => 'Aazeigt wäre $1 - $2 vu $3 Bilder us „$4“',
	'tag-logpagename' => 'Tagging-Logbuech',
	'tag-logpagetext' => 'Des isch e Logbuech vu allene Bildertag, wu zuegfiegt un usegnuh wore sin.',
);

/** Gujarati (ગુજરાતી)
 * @author Ashok modhvadia
 */
$messages['gu'] = array(
	'taggedimages' => 'અંકિતક ચિત્ર',
	'imagetagging-addimagetag' => 'આ ચિત્રને અંકિત કરો',
	'imagetagging-article' => 'પાનું:',
	'imagetagging-articletotag' => 'અંકિતન માટેનું પાનું',
	'imagetagging-imghistory' => 'ઇતિહાસ',
	'imagetagging-images' => 'ચિત્રો',
	'imagetagging-inthisimage' => 'આ ચિત્રમાં: $1',
	'imagetagging-removetag' => 'અંકિતન દુર કરો',
	'imagetagging-done-button' => 'અંકિતન સંપૂર્ણ',
	'imagetagging-tag-button' => 'અંકિતક',
	'imagetagging-tagcancel-button' => 'રદ કરો',
	'imagetagging-addingtag' => 'અંકિતન ઉમેરો',
	'imagetagging-removingtag' => 'અંકિતન દુર કરો',
	'imagetagging-addtagsuccess' => 'ઉમેરેલ અંકિતક',
	'imagetagging-removetagsuccess' => 'દુર કરાયેલ અંકિતક',
	'imagetagging-imagetag-seemoreimages' => '"$1" ($2) નાં વધુ ચિત્રો જુઓ',
	'imagetagging-taggedimages-title' => '"$1" નાં ચિત્રો',
	'tag-logpagename' => 'અંકિતન નોંધ',
	'tag-logpagetext' => 'આ ઉમેરાયેલ કે દુર કરાયેલ તમામ ચિત્ર અંકિતકનીં નોંધ છે.',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'imagetagging-article' => 'Shafi:',
	'imagetagging-tagcancel-button' => 'Soke',
);

/** Hawaiian (Hawai`i)
 * @author Kalani
 * @author Singularity
 */
$messages['haw'] = array(
	'imagetagging-article' => '‘Ao‘ao:',
	'imagetagging-imghistory' => 'Mōʻaukala',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'taggedimages' => 'תמונות מתויגות',
	'imagetagging-desc' => 'אפשרות למשתמש לבחור אזורים מתמונה הנמצאת בדף, ולשייך דף לאזור זה',
	'imagetagging-addimagetag' => 'תיוג תמונה זו',
	'imagetagging-article' => 'דף:',
	'imagetagging-articletotag' => 'דף לתיוג',
	'imagetagging-canteditothermessage' => 'אינכם יכולים לערוך דף זה, כיוון שאין לכם את ההרשאות לעשות כך או כיוון שהדף נעול מסיבות אחרות.',
	'imagetagging-imghistory' => 'היסטוריה',
	'imagetagging-images' => 'תמונות',
	'imagetagging-inthisimage' => 'בתמונה זו: $1',
	'imagetagging-logentry' => 'הסיר את התגית של $2 לדף [[$1]]',
	'imagetagging-log-tagged' => 'התמונה [[$1|$2]] תויגה לדף [[$3]] על ידי $4',
	'imagetagging-new' => '<sup><span style="color:red">חדש!</span></sup>',
	'imagetagging-removetag' => 'הסרת תגית',
	'imagetagging-done-button' => 'סיום התיוג',
	'imagetagging-tag-button' => 'תגית',
	'imagetagging-tagcancel-button' => 'ביטול',
	'imagetagging-tagging-instructions' => 'לחיצה על אנשים או חפצים בתמונה מתייגת אותם.',
	'imagetagging-addingtag' => 'התגית נוספת...',
	'imagetagging-removingtag' => 'התגית מוסרת...',
	'imagetagging-addtagsuccess' => 'התגית נוספה.',
	'imagetagging-removetagsuccess' => 'התגית הוסרה.',
	'imagetagging-canteditneedloginmessage' => 'אינכם יכולים לערוך דף זה.
ייתכן שיהיה עליכם להיכנס לחשבון כדי לתייג תמונות.
האם ברצונכם להיכנס כעת לחשבון?',
	'imagetagging-oneactionatatimemessage' => 'מותר לבצע רק פעולת תיוג אחת בו זמנית.
אנא המתינו להשלמת הפעולה הנוכחית.',
	'imagetagging-oneuniquetagmessage' => 'לתמונה זו כבר ישנה תגית בשם זה.',
	'imagetagging-imagetag-seemoreimages' => 'הצגת תמונות נוספות עבור "$1" ($2)',
	'imagetagging-taggedimages-title' => 'תמונות של "$1"',
	'imagetagging-taggedimages-displaying' => 'הצגת $1 - $2 מתוך $3 תמונות של "$4"',
	'tag-logpagename' => 'יומן תיוג',
	'tag-logpagetext' => 'זהו יומן המציג את כל ההוספות וההסרות של התגיות מתמונות.',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 */
$messages['hr'] = array(
	'imagetagging-article' => 'Stranica',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'taggedimages' => 'Woznamjenjene wobrazy',
	'imagetagging-desc' => 'Zmóžnja wužiwarjej regiony zasadźeneho wobraza wubrać a stronu z tym regionom zwjazać',
	'imagetagging-addimagetag' => 'Tutón wobraz woznamjenić',
	'imagetagging-article' => 'Strona:',
	'imagetagging-articletotag' => 'Strona, kotraž ma so woznamjenić',
	'imagetagging-canteditothermessage' => 'Njemóžeš tutu stronu wobdźěłać, pak, dokelž nimaš prawa, zo by to činił, pak, dokelž strona je z druhich přičinow zawrjena.',
	'imagetagging-imghistory' => 'Stawizny',
	'imagetagging-images' => 'Wobrazy',
	'imagetagging-inthisimage' => 'W tutej wobrazu: $1',
	'imagetagging-logentry' => 'Woznamjenjenje na stronje [[$1]] wot $2 wotstronjene',
	'imagetagging-log-tagged' => 'Wobraz [[$1|$2]] bu na stronje [[$3]] wot $4 woznamjenjeny',
	'imagetagging-new' => '<sup><span style="color:red">Nowy!</span></sup>',
	'imagetagging-removetag' => 'Woznamjenjenje wotstronić',
	'imagetagging-done-button' => 'Woznamjenjowanje sčinjene',
	'imagetagging-tag-button' => 'Woznamjenjenje',
	'imagetagging-tagcancel-button' => 'Přetorhnyć',
	'imagetagging-tagging-instructions' => 'Klikń na ludźi abo wěcy we wobrazu, zo by je woznamjenił.',
	'imagetagging-addingtag' => 'Woznamjenjenje so přidawa...',
	'imagetagging-removingtag' => 'Woznamjenjenje so wotstronja...',
	'imagetagging-addtagsuccess' => 'Woznamjenjenje přidate.',
	'imagetagging-removetagsuccess' => 'Woznamjenjenje wotstronjene.',
	'imagetagging-canteditneedloginmessage' => 'Njemóžeš tutu stronu wobdźěłać.
Snano dyrbiš so přizjewić, zo by wobrazy woznamjenił.
Chceš so nětko přizjewić?',
	'imagetagging-oneactionatatimemessage' => 'Jenož akcija woznamjenjowanja naraz je dowolena.
Prošu čakaj, doniž eksistowaca akcija njeje so skónčena.',
	'imagetagging-oneuniquetagmessage' => 'Tutón wobraz je hižo woznamjenjenje z tutym mjenom.',
	'imagetagging-imagetag-seemoreimages' => 'Hlej dalše wobrazy wot "$1" ($2)',
	'imagetagging-taggedimages-title' => 'Wobrazy wot "$1"',
	'imagetagging-taggedimages-displaying' => '{{PLURAL:$1|Zwobraznja|Zwobraznjetej|Zowbraznjeja|Zwobraznja}} so $1 - $2 z $3 wobrazow wot "$4"',
	'tag-logpagename' => 'Protokol woznamjenjowanja',
	'tag-logpagetext' => 'To je protokol wšěch přidatych a wotstronjenych wobrazowych woznamjenjenjow.',
);

/** Hungarian (Magyar)
 * @author Bdamokos
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'taggedimages' => 'Felcímkézett képek',
	'imagetagging-desc' => 'Lehetővé teszi a felhasználóknak, hogy egy beágyazott kép egyes területeit kijelöljék és hivatkozást készítsenek velük lapokra',
	'imagetagging-addimagetag' => 'Kép felcímkézése',
	'imagetagging-article' => 'Lap:',
	'imagetagging-articletotag' => 'Felcímkézendő lap',
	'imagetagging-canteditothermessage' => 'Nem szerkesztheted ezt a lapot, vagy nincs jogosultságod hozzá, vagy a lap zárolva van más okokból.',
	'imagetagging-imghistory' => 'Történet',
	'imagetagging-images' => 'képek',
	'imagetagging-inthisimage' => 'Ezen a képen: $1',
	'imagetagging-logentry' => '$2 eltávolította a(z) [[$1]] lapra hivatkozó címkét',
	'imagetagging-log-tagged' => '$4 felcímkézte a(z) [[$1|$2]] képet a(z) [[$3]] lapra hivatkozva',
	'imagetagging-new' => '<sup><span style="color:red">Új!</span></sup>',
	'imagetagging-removetag' => 'címke eltávolítása',
	'imagetagging-done-button' => 'Címkézés kész',
	'imagetagging-tag-button' => 'Felcímkéz',
	'imagetagging-tagcancel-button' => 'Mégse',
	'imagetagging-tagging-instructions' => 'Kattints emberekre vagy tárgyakra a képen a felcímkézésükhöz.',
	'imagetagging-addingtag' => 'Címke hozzáadása…',
	'imagetagging-removingtag' => 'Címke eltávolítása…',
	'imagetagging-addtagsuccess' => 'Címke hozzáadva.',
	'imagetagging-removetagsuccess' => 'Címke eltávolítva.',
	'imagetagging-canteditneedloginmessage' => 'Nem szerkesztheted ezt a lapot.
Lehet hogy azért, mert a képek felcímkézéséhez be kell jelentkezned.
Szeretnél bejelentkezni?',
	'imagetagging-oneactionatatimemessage' => 'Egyszerre csak egy címkézési művelet engedélyezett.
Várj a folyamatban levő művelet befejezésére.',
	'imagetagging-oneuniquetagmessage' => 'Ezen a képen már van címke ilyen névvel.',
	'imagetagging-imagetag-seemoreimages' => 'Több kép megjelenítése innen: „$1” ($2)',
	'imagetagging-taggedimages-title' => '„$1” kép',
	'imagetagging-taggedimages-displaying' => '$1 – $2 kép megjelenítése innen: „$4” (összesen $3)',
	'tag-logpagename' => 'Címkézési napló',
	'tag-logpagetext' => 'Kép-címkék hozzáadásának hozzáadásának és eltávolításának naplója.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'taggedimages' => 'Imagines etiquettate',
	'imagetagging-desc' => 'Permitte que un usator selige regiones de un imagine incastrate e associa un pagina con ille region',
	'imagetagging-addimagetag' => 'Etiquettar iste imagine',
	'imagetagging-article' => 'Pagina:',
	'imagetagging-articletotag' => 'Le pagina a etiquettar',
	'imagetagging-canteditothermessage' => 'Tu non pote modificar iste pagina, o proque tu non ha le derectos de facer lo, o proque le pagina es serrate pro altere motivos.',
	'imagetagging-imghistory' => 'Historia',
	'imagetagging-images' => 'imagines',
	'imagetagging-inthisimage' => 'In iste imagine: $1',
	'imagetagging-logentry' => 'Removeva le etiquetta del pagina [[$1]] per $2',
	'imagetagging-log-tagged' => 'Le imagine [[$1|$2]] esseva etiquettate al pagina [[$3]] per $4',
	'imagetagging-new' => '<sup><span style="color:red">Nove!</span></sup>',
	'imagetagging-removetag' => 'remover etiquetta',
	'imagetagging-done-button' => 'Etiquettage complete',
	'imagetagging-tag-button' => 'Etiquetta',
	'imagetagging-tagcancel-button' => 'Cancellar',
	'imagetagging-tagging-instructions' => 'Clicca super personas o objectos in le imagine pro etiquettar los.',
	'imagetagging-addingtag' => 'Addition de etiquetta in curso…',
	'imagetagging-removingtag' => 'Elimination de etiquetta in curso…',
	'imagetagging-addtagsuccess' => 'Etiquetta addite.',
	'imagetagging-removetagsuccess' => 'Etiquetta removite.',
	'imagetagging-canteditneedloginmessage' => 'Tu non pote modificar iste pagina.
Es possibile que tu debe aperir un session pro poter etiquettar le imagines.
Esque tu vole aperir un session ora?',
	'imagetagging-oneactionatatimemessage' => 'Solmente un action de etiquettage es permittite a un vice.
Per favor attende le completion del action in curso.',
	'imagetagging-oneuniquetagmessage' => 'Iste imagine ha ja un etiquetta con iste nomine.',
	'imagetagging-imagetag-seemoreimages' => 'Vide plus imagines de "$1" ($2)',
	'imagetagging-taggedimages-title' => 'Imagines de "$1"',
	'imagetagging-taggedimages-displaying' => 'Visualisation de $1 - $2 de $3 imagines de "$4"',
	'tag-logpagename' => 'Registro de etiquettages',
	'tag-logpagetext' => 'Isto es un registro de tote le additiones e remotiones de etiquettas de imagines.',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Farras
 * @author Irwangatot
 * @author Rex
 */
$messages['id'] = array(
	'taggedimages' => 'Gambar yang diberi tag',
	'imagetagging-desc' => 'Memungkinkan pengguna memilih wilayah gambar tertanam dan menghubungkan halaman dengan wilayah itu',
	'imagetagging-addimagetag' => 'Beri tag pada gambar ini',
	'imagetagging-article' => 'Halaman:',
	'imagetagging-articletotag' => 'Halaman yang akan diberi tag',
	'imagetagging-canteditothermessage' => 'Anda tidak dapat mengedit halaman ini, baik karena Anda tidak memiliki hak untuk melakukannya atau karena halaman dikunci karena alasan lain.',
	'imagetagging-imghistory' => 'Versi',
	'imagetagging-images' => 'gambar',
	'imagetagging-inthisimage' => 'Pada gambar ini: $1',
	'imagetagging-logentry' => 'Hapus tag ke halaman [[$1]] oleh $2',
	'imagetagging-log-tagged' => 'Gambar [[$1|$2]] diberi tag ke halaman [[$3]] oleh $4',
	'imagetagging-new' => '<sup><span style="color:red">Baru!</span></sup>',
	'imagetagging-removetag' => 'Singkirkan penanda',
	'imagetagging-done-button' => 'Selesai memberi tag',
	'imagetagging-tag-button' => 'Tanda',
	'imagetagging-tagcancel-button' => 'Batalkan',
	'imagetagging-tagging-instructions' => 'Klik pada gambar orang atau benda di gambar ini untuk memberi tag.',
	'imagetagging-addingtag' => 'Menambahkan tag...',
	'imagetagging-removingtag' => 'Menghilangkan tag...',
	'imagetagging-addtagsuccess' => 'Tag ditambahkan.',
	'imagetagging-removetagsuccess' => 'Tag dihilangkan.',
	'imagetagging-canteditneedloginmessage' => '

Anda tidak dapat menyunting halaman ini. 
Mungkin karena Anda perlu login ke tag gambar. 
Apakah Anda ingin login sekarang?',
	'imagetagging-oneactionatatimemessage' => 'Hanya satu tindakan penandaan pada suatu waktu yang diperbolehkan. 
Silakan tunggu tindakan yang ada untuk selesai.',
	'imagetagging-oneuniquetagmessage' => 'Gambar ini telah memiliki tag dengan nama ini.',
	'imagetagging-imagetag-seemoreimages' => 'Lihat gambar lain dari "$1" ($2)',
	'imagetagging-taggedimages-title' => 'Gambar-gambar "$1"',
	'imagetagging-taggedimages-displaying' => 'Menampilkan $1 - $2 dari $3 gambar "$4"',
	'tag-logpagename' => 'Log tag',
	'tag-logpagetext' => 'Ini adalah log semua penambahan dan penghilangan tag gambar.',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'imagetagging-tagcancel-button' => 'Kàchá',
);

/** Italian (Italiano)
 * @author Darth Kule
 * @author Pietrodn
 */
$messages['it'] = array(
	'taggedimages' => 'Immagini taggate',
	'imagetagging-desc' => "Consente a un utente di selezionare regioni di un'immagine inclusa e associare una pagina con quella regione",
	'imagetagging-addimagetag' => 'Tagga questa immagine',
	'imagetagging-article' => 'Pagina:',
	'imagetagging-articletotag' => 'Pagina da taggare',
	'imagetagging-canteditothermessage' => 'Non puoi modificare questa pagina, o perché non hai i diritti per farlo, o perché la pagina è bloccata per altri motivi.',
	'imagetagging-imghistory' => 'Cronologia',
	'imagetagging-images' => 'immagini',
	'imagetagging-inthisimage' => 'In questa immagine: $1',
	'imagetagging-logentry' => 'Rimosso il tag alla pagina [[$1]] da parte di $2',
	'imagetagging-log-tagged' => "L'immagine [[$1|$2]], è stata taggata alla pagina [[$3]] da $4",
	'imagetagging-new' => '<span style="color:red"><sup>Nuovo!</sup></span>',
	'imagetagging-removetag' => 'rimuovi tag',
	'imagetagging-done-button' => 'Tagging eseguito',
	'imagetagging-tag-button' => 'Tagga',
	'imagetagging-tagcancel-button' => 'Annulla',
	'imagetagging-tagging-instructions' => "Fai clic su persone o cose nell'immagine per taggarle.",
	'imagetagging-addingtag' => 'Aggiungo il tag…',
	'imagetagging-removingtag' => 'Rimuovo il tag…',
	'imagetagging-addtagsuccess' => 'Tag aggiunto.',
	'imagetagging-removetagsuccess' => 'Tag rimosso.',
	'imagetagging-canteditneedloginmessage' => 'Non puoi modificare questa pagina.
Può essere perché è necessario effettuare il login per taggare le immagini.
Vuoi effettuare il login adesso?',
	'imagetagging-oneactionatatimemessage' => "È permessa solo un'azione di tag alla volte.
Per favore aspetta che venga completata l'azione esistente.",
	'imagetagging-oneuniquetagmessage' => 'Questa immagine ha già un tag con questo nome.',
	'imagetagging-imagetag-seemoreimages' => 'Vedi più immagini di "$1" ($2)',
	'imagetagging-taggedimages-title' => 'Immagini di "$1"',
	'imagetagging-taggedimages-displaying' => 'Visualizzo $1 - $2 di $3 immagini di "$4"',
	'tag-logpagename' => 'Registro dei tag',
	'tag-logpagetext' => 'Questo è un registro di tutte le aggiunte e rimozioni dei tag immagine.',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'taggedimages' => 'ラベル付画像',
	'imagetagging-desc' => '利用者がページ中の画像の領域を選択し、その領域にページを関連付けることをできるようにする',
	'imagetagging-addimagetag' => 'この画像をラベル付け',
	'imagetagging-article' => 'ページ:',
	'imagetagging-articletotag' => 'ラベルを付けるページ',
	'imagetagging-canteditothermessage' => 'あなたは必要な権限をもっていないか、ページがその他の理由でロックされているため、このページを編集できません。',
	'imagetagging-imghistory' => '履歴',
	'imagetagging-images' => '画像',
	'imagetagging-inthisimage' => 'この画像中: $1',
	'imagetagging-logentry' => '$2 が付けたページ [[$1]] へのラベルを除去',
	'imagetagging-log-tagged' => '$4 が画像 [[$1|$2]] に [[$3]] をラベル付け',
	'imagetagging-new' => '<sup><span style="color:red">新着</span></sup>',
	'imagetagging-removetag' => 'ラベルを除去',
	'imagetagging-done-button' => 'ラベル付け完了',
	'imagetagging-tag-button' => 'ラベル',
	'imagetagging-tagcancel-button' => '中止',
	'imagetagging-tagging-instructions' => '画像中でラベル付けしたい人物や風物をクリックしてください。',
	'imagetagging-addingtag' => 'ラベル追加中…',
	'imagetagging-removingtag' => 'ラベル除去中…',
	'imagetagging-addtagsuccess' => 'ラベル追加完了。',
	'imagetagging-removetagsuccess' => 'ラベル除去完了。',
	'imagetagging-canteditneedloginmessage' => 'あなたはこの画像を編集できません。画像にラベル付けするにはログインしなければならないことがあります。今ログインしますか？',
	'imagetagging-oneactionatatimemessage' => 'ラベル付けの操作は一度に一回しかできません。前の操作が完了するのを待ってください。',
	'imagetagging-oneuniquetagmessage' => 'この画像は既にこの名前でラベル付けされています。',
	'imagetagging-imagetag-seemoreimages' => '「$1」($2) の画像をもっと見る',
	'imagetagging-taggedimages-title' => '「$1」の画像',
	'imagetagging-taggedimages-displaying' => '「$4」の画像$3個中 $1 - $2個目を表示しています',
	'tag-logpagename' => 'ラベル付け記録',
	'tag-logpagetext' => 'これはすべての画像ラベルの追加と除去の記録です。',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'imagetagging-addimagetag' => 'ដាក់ប្លាកឱ្យរូបភាពនេះ',
	'imagetagging-article' => 'ទំព័រ៖',
	'imagetagging-imghistory' => 'ប្រវត្តិ',
	'imagetagging-images' => 'រូបភាព',
	'imagetagging-inthisimage' => 'ក្នុងរូបភាពនេះ: $1',
	'imagetagging-new' => '<sup><span style="color:red">ថ្មី!</span></sup>',
	'imagetagging-removetag' => 'ដាក​ស្លាក​ចេញ',
	'imagetagging-tag-button' => 'ស្លាក',
	'imagetagging-tagcancel-button' => 'បោះបង់',
	'imagetagging-addingtag' => 'កំពុងដាក់​ស្លាក…',
	'imagetagging-removingtag' => 'កំពុងដក​ស្លាកចេញ…',
	'imagetagging-addtagsuccess' => 'ប្លាក់ដែលបានដាក់៖',
	'imagetagging-removetagsuccess' => 'ស្លាក​ដែល​បាន​ដក​ចេញ​។',
	'imagetagging-imagetag-seemoreimages' => 'មើល​រូបភាព​បន្ថែម​នៃ "$1" ($2)',
	'imagetagging-taggedimages-title' => 'រួបភាពរបស់"$1"',
	'imagetagging-taggedimages-displaying' => 'កំពុង​បង្ហាញ $1 - $2 នៃ $3 រូបភាព​នៃ "$4"',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'imagetagging-article' => 'ಪುಟ:',
	'imagetagging-imghistory' => 'ಇತಿಹಾಸ',
	'imagetagging-images' => 'ಚಿತ್ರಗಳು',
	'imagetagging-tagcancel-button' => 'ರದ್ದು ಮಾಡು',
);

/** Krio (Krio)
 * @author Jose77
 */
$messages['kri'] = array(
	'imagetagging-imghistory' => 'Istri',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'taggedimages' => 'Belder met Makeerunge drop',
	'imagetagging-desc' => 'Määt et müjjelesch, ene Link op en Sigg em Wiki op Aandeile ov Berette fun enem Beld ze pussizjeneere.',
	'imagetagging-addimagetag' => 'Makeerunge op dat Beld donn',
	'imagetagging-article' => 'Sigg:',
	'imagetagging-articletotag' => 'De Sigg zom Makeere',
	'imagetagging-canteditothermessage' => 'Do kanns di Sigg he nit ändere. Entweder häs De nit dat Rääsch dozoh, udder de Sigg es sönsworöm jesperrt.',
	'imagetagging-imghistory' => 'Versione',
	'imagetagging-images' => 'Belder',
	'imagetagging-inthisimage' => 'En dämm Beld: $1',
	'imagetagging-logentry' => '!!Fuzzy!!Dä Metmaacher $2 hät de Makeerung op de Sigg [[$1]] fott jenumme.',
	'imagetagging-log-tagged' => 'Dat Beld [[$1|$2]] es vum $4 makeet, un ene Berett met dä Sigg [[$3]] verlengk woode.',
	'imagetagging-new' => '<sup><span style="color:red">Neu!</span></sup>',
	'imagetagging-removetag' => 'Makeerung fottnämme',
	'imagetagging-done-button' => 'Fädesch met Makeere!',
	'imagetagging-tag-button' => 'Makeere!',
	'imagetagging-tagcancel-button' => 'Draanjevve',
	'imagetagging-tagging-instructions' => 'Kleck op Lück odder Saache op däm Beld, öm se ze makeere.',
	'imagetagging-addingtag' => 'Makeerung dobei donn…',
	'imagetagging-removingtag' => 'Makeerung fottnämme…',
	'imagetagging-addtagsuccess' => 'Makeerung dobei jedonn.',
	'imagetagging-removetagsuccess' => 'Makeerung fottjenumme.',
	'imagetagging-canteditneedloginmessage' => 'Do kanns die Sigg hee nit ändere.
Künnt sin, et es weil de enjelogg sin moß, öm Belder ze makeere.
Wells de jez enlogge?',
	'imagetagging-oneactionatatimemessage' => 'Nur ein Makeerung op eijmol es müjjelich.
Donn drop wade, bes dä Vörjang fädesch es, dä jraad em Jang es.',
	'imagetagging-oneuniquetagmessage' => 'Dat belld hät alld_en Makeerung met däm Name.',
	'imagetagging-imagetag-seemoreimages' => 'Mieh Belder fun „$1“ beloore ($2)',
	'imagetagging-taggedimages-title' => 'Belder fun „$1“',
	'imagetagging-taggedimages-displaying' => 'Ben $1 am Zeije – $2 fun $3 Belder en „$4“',
	'tag-logpagename' => 'Logboch övver de Makeerunge',
	'tag-logpagetext' => 'Dat hee es dat Logboch met all dä Makeerungs-Vörjäng
(dobeijedonn un fott jenumme) aan Belder.',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author Gomada
 */
$messages['ku-latn'] = array(
	'taggedimages' => 'Wêneyên nîşankirî',
	'imagetagging-addimagetag' => 'Vî wêneyî nîşan bike',
	'imagetagging-article' => 'Rûpel:',
	'imagetagging-articletotag' => 'Rûpela nîşankirinê',
	'imagetagging-imghistory' => 'Dîrok',
	'imagetagging-images' => 'wêne',
	'imagetagging-inthisimage' => 'Di vî wêneyî de: $1',
	'imagetagging-new' => '<sup><span style="color:red">Nû!</span></sup>',
	'imagetagging-removetag' => 'Nîşankirinê rake',
	'imagetagging-done-button' => 'Nîşankirin çêbû',
	'imagetagging-tag-button' => 'Nîşankirin',
	'imagetagging-tagcancel-button' => 'Betal bike',
	'imagetagging-addingtag' => 'Nîşankirin pêk tê...',
	'imagetagging-removingtag' => 'Nîşankirin tê rakirin...',
	'imagetagging-addtagsuccess' => 'Nîşankirin pêkhat.',
	'imagetagging-removetagsuccess' => 'Nîşankirin hate rakirin.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'taggedimages' => 'Markéiert Biller',
	'imagetagging-desc' => "Erméiglecht et Benotzer fir Deeler vun agebonne Biller erauszesichen a se mat enger Säit z'associéieren",
	'imagetagging-addimagetag' => 'Markéierung op dëst Bild derbäisetzen',
	'imagetagging-article' => 'Säit:',
	'imagetagging-articletotag' => 'Säit fir ze markéieren',
	'imagetagging-canteditothermessage' => "Dir kënnt dës Säit net änneren, entweder well Dir net déi néideg Rechter hutt, oder well d'Säit aus anere Grënn gespaart ass.",
	'imagetagging-imghistory' => 'Versiounen',
	'imagetagging-images' => 'Biller',
	'imagetagging-inthisimage' => 'Op dësem Bild: $1',
	'imagetagging-new' => '<sup><span style="color:red">Nei!</span></sup>',
	'imagetagging-removetag' => 'Tag ewechhuelen',
	'imagetagging-tag-button' => 'Tag',
	'imagetagging-tagcancel-button' => 'Zréck',
	'imagetagging-tagging-instructions' => 'Klickt op Leit oder Saachen op dem Bild fir se ze markéieren.',
	'imagetagging-addingtag' => 'Markéierung derbäisetzen',
	'imagetagging-removingtag' => 'Markéierung ewechhuelen',
	'imagetagging-addtagsuccess' => 'Markéierugn déi derbäigesat gouf',
	'imagetagging-removetagsuccess' => 'Markéerung déi ewechgeholl gouf',
	'imagetagging-oneuniquetagmessage' => 'Dëst Bild huet schonn eng Markéierung mat dësem Numm.',
	'imagetagging-imagetag-seemoreimages' => 'Kuckt méi Biller vu(n) "$1" ($2)',
	'imagetagging-taggedimages-title' => 'Biller vun "$1"',
	'imagetagging-taggedimages-displaying' => 'Weis $1 - $2 vu(n) $3 Biller vu(n) "$4"',
	'tag-logpagename' => 'Logbuch vun de Markéierungen (Tagging log)',
);

/** Limburgish (Limburgs)
 * @author Remember the dot
 */
$messages['li'] = array(
	'imagetagging-article' => 'Pazjena:',
);

/** Latgalian (Latgaļu)
 * @author Dark Eagle
 */
$messages['ltg'] = array(
	'imagetagging-imghistory' => 'Viesture',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'imagetagging-article' => 'Лаштык:',
	'imagetagging-imghistory' => 'Историй',
	'imagetagging-tagcancel-button' => 'Чараш',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'taggedimages' => 'Означени слики',
	'imagetagging-desc' => 'Му дава на корисникот да избере региони на вметната слика и да асоцира страница со тој регион',
	'imagetagging-addimagetag' => 'Означи ја сликава',
	'imagetagging-article' => 'Страница:',
	'imagetagging-articletotag' => 'Страница за означување',
	'imagetagging-canteditothermessage' => 'Не можете да ја уредувате оваа страница, или бидејќи немате права на тоа, или бидејќи страницата е заклучена од други причини.',
	'imagetagging-imghistory' => 'Историја',
	'imagetagging-images' => 'слики',
	'imagetagging-inthisimage' => 'На сликава: $1',
	'imagetagging-logentry' => 'Ознаката е преместена на страницата [[$1]] од страна на $2',
	'imagetagging-log-tagged' => 'Сликата [[$1|$2]] беше означена кон страницата [[$3]] од страна на $4',
	'imagetagging-new' => '<sup><span style="color:red">Ново!</span></sup>',
	'imagetagging-removetag' => 'отстрани ознака',
	'imagetagging-done-button' => 'Означувањето е завршено',
	'imagetagging-tag-button' => 'Ознака',
	'imagetagging-tagcancel-button' => 'Откажи',
	'imagetagging-tagging-instructions' => 'Кликнете на луѓе или нешта на сликата за да ги означите.',
	'imagetagging-addingtag' => 'Додавам ознака...',
	'imagetagging-removingtag' => 'Отстранувам ознака...',
	'imagetagging-addtagsuccess' => 'Ја додадов ознаката.',
	'imagetagging-removetagsuccess' => 'Ја отстранив ознаката.',
	'imagetagging-canteditneedloginmessage' => 'Не можете да ја уредувате оваа страница.
Ова е можеби затоа што треба да сте најавени за да означувате слики.
Сакате да се најавите сега?',
	'imagetagging-oneactionatatimemessage' => 'Дозволено е да се означува едно по едно.
Почекајте да заврши моменталното дејство.',
	'imagetagging-oneuniquetagmessage' => 'Оваа слика веќе има ознака со такво име.',
	'imagetagging-imagetag-seemoreimages' => 'Погледајте повеќе слики со „$1“ ($2)',
	'imagetagging-taggedimages-title' => 'Слики со „$1“',
	'imagetagging-taggedimages-displaying' => 'Прикажани се $1 - $2 од вкупно $3 слики со „$4“',
	'tag-logpagename' => 'Дневник на означувања',
	'tag-logpagetext' => 'Ова е дневник на сите додавања на ознаки во слики и сите отстранувања.',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'imagetagging-addimagetag' => 'ഈ ചിത്രം ടാഗ് ചെയ്യുക',
	'imagetagging-article' => 'താൾ:',
	'imagetagging-articletotag' => 'ടാഗ് ചെയ്യാനുള്ള താൾ',
	'imagetagging-imghistory' => 'നാൾവഴി',
	'imagetagging-images' => 'ചിത്രങ്ങൾ',
	'imagetagging-inthisimage' => 'ഈ ചിത്രത്തിൽ: $1',
	'imagetagging-logentry' => '[[$1]] എന്ന  താളിലെ ടാഗ്  $2 മാറ്റിയിരിക്കുന്നു',
	'imagetagging-log-tagged' => '[[$1|$2]] എന്ന ചിത്രം [[$3]] എന്ന താളിലേക്ക്  $4 ടാഗ് ചെയ്തിരിക്കുന്നു',
	'imagetagging-removetag' => 'ടാഗ് മാറ്റുക',
	'imagetagging-tag-button' => 'റ്റാഗ്',
	'imagetagging-tagcancel-button' => 'റദ്ദാക്കുക',
	'imagetagging-addingtag' => 'ടാഗ് ചേർക്കുന്നു...',
	'imagetagging-removingtag' => 'ടാഗ് ഒഴിവാക്കുന്നു...',
	'imagetagging-addtagsuccess' => 'ടാഗ് ചേർത്തു.',
	'imagetagging-removetagsuccess' => 'ടാഗ് ഒഴിവാക്കി.',
	'imagetagging-oneuniquetagmessage' => 'ഈ ചിത്രത്തിനു ഈ പേരുള്ള ടാഗ് ഇപ്പോൾ തന്നെയുണ്ട്',
	'imagetagging-imagetag-seemoreimages' => '"$1"ന്റെ കൂടുതൽ ചിത്രങ്ങൾ കാണുക ($2)',
	'imagetagging-taggedimages-title' => '"$1"ന്റെ ചിത്രങ്ങൾ',
	'imagetagging-taggedimages-displaying' => '"$4"ന്റെ  $3 ചിത്രങ്ങളിൽ  $1 - $2 വരെയുള്ള  പ്രദർശിപ്പിക്കുന്നു',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'imagetagging-article' => 'Хуудас:',
	'imagetagging-tagcancel-button' => 'Цуцлах',
);

/** Marathi (मराठी)
 * @author Htt
 * @author Kaustubh
 */
$messages['mr'] = array(
	'taggedimages' => 'खुणा केलेली चित्रे',
	'imagetagging-desc' => 'एखाद्या सदस्याला चित्रातील क्षेत्रे निवडणे व त्या क्षेत्राला एखादे पान जोडण्याची अनुमती देते',
	'imagetagging-addimagetag' => 'या चित्रावर खूण करा',
	'imagetagging-article' => 'पान:',
	'imagetagging-articletotag' => 'खूण करण्यासाठीचे पान',
	'imagetagging-imghistory' => 'इतिहास',
	'imagetagging-images' => 'चित्रे',
	'imagetagging-inthisimage' => 'या चित्रामध्ये: $1',
	'imagetagging-logentry' => '$2 ने [[$1]] पानाची खूण काढली',
	'imagetagging-log-tagged' => '$4 ने [[$1|$2]] या चित्राची खूण  [[$3]] या पानावर दिली',
	'imagetagging-new' => '<sup><span style="color:red">नवीन!</span></sup>',
	'imagetagging-removetag' => 'खूण काढा',
	'imagetagging-done-button' => 'खूण दिली',
	'imagetagging-tag-button' => 'खूण',
	'imagetagging-tagcancel-button' => 'रद्द करा',
	'imagetagging-tagging-instructions' => 'या चित्रातील माणसे किंवा वस्तूंवर खूणा करण्यासाठी टिचकी द्या',
	'imagetagging-addingtag' => 'खूण देत आहे...',
	'imagetagging-removingtag' => 'खूण काढत आहे...',
	'imagetagging-addtagsuccess' => 'खूण वाढविली.',
	'imagetagging-removetagsuccess' => 'खूण काढली.',
	'imagetagging-canteditneedloginmessage' => 'तुम्ही हे पान संपादित करू शकत नाही.
कदाचित याचे कारण म्हणजे खूणा देण्यासाठी तुम्ही प्रवेश करणे आवश्यक असेल.
तुम्ही आता प्रवेश करू इच्छिता का?',
	'imagetagging-oneactionatatimemessage' => 'एकावेळी एकच खूण देता येईल.
कृपया चालू असलेली क्रिया पूर्ण होईपर्यंत वाट पहा.',
	'imagetagging-oneuniquetagmessage' => 'या चित्राला याच नावाची खूण अगोदरच दिलेली आहे.',
	'imagetagging-imagetag-seemoreimages' => '"$1" ($2) ची अजून चित्रे पहा',
	'imagetagging-taggedimages-title' => '"$1" ची चित्रे',
	'imagetagging-taggedimages-displaying' => '"$4" ची $3 चित्रांपैकी $1 - $2 दर्शविली आहेत',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'imagetagging-article' => 'Laman:',
	'imagetagging-imghistory' => 'Sejarah',
	'imagetagging-tagcancel-button' => 'Batalkan',
);

/** Maltese (Malti)
 * @author Roderick Mallia
 */
$messages['mt'] = array(
	'imagetagging-tagcancel-button' => 'Annulla',
);

/** Mirandese (Mirandés)
 * @author Malafaya
 */
$messages['mwl'] = array(
	'imagetagging-article' => 'Páigina:',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'imagetagging-article' => 'Лопась:',
	'imagetagging-imghistory' => 'Путовксонзо-йуронзо',
	'imagetagging-images' => 'неевтть',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'imagetagging-article' => 'Zāzanilli:',
	'imagetagging-imghistory' => 'Tlahcuilōlloh',
	'imagetagging-images' => 'īxiptli',
	'imagetagging-inthisimage' => 'Inīn īxippan: $1',
	'imagetagging-tagcancel-button' => 'Ticcuepāz',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'taggedimages' => 'Afbeeldingen annoteren',
	'imagetagging-desc' => 'Laat een gebruiker delen van een afbeeldingen selecteren en associëren met een pagina',
	'imagetagging-addimagetag' => 'Deze afbeelding annoteren',
	'imagetagging-article' => 'Pagina:',
	'imagetagging-articletotag' => 'Te annoteren pagina',
	'imagetagging-canteditothermessage' => 'U kunt deze pagina niet bewerken, omdat u geen rechten hebt om dat te doen, of omdat de pagina om een andere reden niet bewerkt kan worden.',
	'imagetagging-imghistory' => 'Geschiedenis',
	'imagetagging-images' => 'afbeeldingen',
	'imagetagging-inthisimage' => 'In deze afbeelding: $1',
	'imagetagging-logentry' => 'verwijderde annotatie naar pagina [[$1]] door $2',
	'imagetagging-log-tagged' => 'annoteerde afbeelding [[$1|$2]] naar pagina [[$3]] door $4',
	'imagetagging-new' => '<sup><span style="color:red">Nieuw!</span></sup>',
	'imagetagging-removetag' => 'annotatie verwijderen',
	'imagetagging-done-button' => 'Klaar met annoteren',
	'imagetagging-tag-button' => 'Annoteren',
	'imagetagging-tagcancel-button' => 'Annuleren',
	'imagetagging-tagging-instructions' => 'Klik op mensen of dingen op de afbeelding om ze te annoteren',
	'imagetagging-addingtag' => 'Annotatie aan het toevoegen…',
	'imagetagging-removingtag' => 'Annotatie aan het verwijderen…',
	'imagetagging-addtagsuccess' => 'Annotatie toegevoegd.',
	'imagetagging-removetagsuccess' => 'Annotatie verwijderd.',
	'imagetagging-canteditneedloginmessage' => 'U kunt deze pagina niet bewerken.
Dat kan zijn omdat u aangemeld moet zijn om afbeeldingen te annoteren.
Wilt u nu aanmelden?',
	'imagetagging-oneactionatatimemessage' => 'Er kan maar een handeling tegelijkertijd plaatsvinden.
Wacht totdat de huidige handeling is voltooid.',
	'imagetagging-oneuniquetagmessage' => 'Deze afbeelding heeft al een annotatie met deze naam.',
	'imagetagging-imagetag-seemoreimages' => 'Meer afbeeldingen bekijken van "$1" ($2)',
	'imagetagging-taggedimages-title' => 'Afbeeldingen van "$1"',
	'imagetagging-taggedimages-displaying' => 'De resultaten $1 tot $2 van $3 van afbeeldingen van "$4" worden weergegeven',
	'tag-logpagename' => 'Annotatielogboek',
	'tag-logpagetext' => 'In dit logboek worden toegevoegde en verwijderde annotaties bij afbeeldingen weergegeven.',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'taggedimages' => 'Merkte bilete',
	'imagetagging-desc' => 'Lèt ein brukar velja område på eit bilete og lenkja dette området til ei sida',
	'imagetagging-addimagetag' => 'Merk dette biletet',
	'imagetagging-article' => 'Sida:',
	'imagetagging-articletotag' => 'Sida som skal bli merkt',
	'imagetagging-canteditothermessage' => 'Du kan ikkje endra denne sida, anten av di du ikkje har rettane til å gjera det, eller av di sida er låst av andre grunnar.',
	'imagetagging-imghistory' => 'Historikk',
	'imagetagging-images' => 'bilete',
	'imagetagging-inthisimage' => 'På dette biletet: $1',
	'imagetagging-logentry' => 'Fjerna merke til sida [[$1]] av $2',
	'imagetagging-log-tagged' => 'Biletet [[$1|$2]] blei merkt til sida [[$3]] av $4',
	'imagetagging-new' => '<sup><span style="color:red">Ny!</span></sup>',
	'imagetagging-removetag' => 'fjern merke',
	'imagetagging-done-button' => 'Ferdig med å merkja',
	'imagetagging-tag-button' => 'Merk',
	'imagetagging-tagcancel-button' => 'Avbryt',
	'imagetagging-tagging-instructions' => 'Trykk på folk eller ting på biletet for å merkja dei.',
	'imagetagging-addingtag' => 'Legg til merke …',
	'imagetagging-removingtag' => 'Fjernar merke …',
	'imagetagging-addtagsuccess' => 'La til merke.',
	'imagetagging-removetagsuccess' => 'Fjerna merke.',
	'imagetagging-canteditneedloginmessage' => 'Du kan ikkje endra denne sida.
Det kan vera av di ein må logga inn for å merkja bilete.
Vil du logga in no?',
	'imagetagging-oneactionatatimemessage' => 'Berre éi merkehandling av gongen er tillate.
Vent til den førre handlinga er ferdig.',
	'imagetagging-oneuniquetagmessage' => 'Dette biletet har allereie eit merke med dette namnet.',
	'imagetagging-imagetag-seemoreimages' => 'Sjå fleire bilete av «$1» ($2)',
	'imagetagging-taggedimages-title' => 'Bilete av «$1»',
	'imagetagging-taggedimages-displaying' => 'Syner $1&ndash;$2 av $3 bilete av «$4»',
	'tag-logpagename' => 'Merkjelogg',
	'tag-logpagetext' => 'Dette er ein logg over alle biletmerke lagt til eller fjerna.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['nb'] = array(
	'taggedimages' => 'Merkede bilder',
	'imagetagging-desc' => 'Lar en bruker velge områder på et bilde og lenke dette området til en side',
	'imagetagging-addimagetag' => 'Merk dette bildet',
	'imagetagging-article' => 'Side:',
	'imagetagging-articletotag' => 'Side som skal merkes',
	'imagetagging-canteditothermessage' => 'Du kan ikke redigere denne siden, enten fordi du ikke har de nødvendige rettighetene eller fordi siden er låst av andre grunner.',
	'imagetagging-imghistory' => 'Historikk',
	'imagetagging-images' => 'bilder',
	'imagetagging-inthisimage' => 'På dette bildet: $1',
	'imagetagging-logentry' => 'Fjernet merking til siden [[$1]] av $2',
	'imagetagging-log-tagged' => 'Bildet [[$1|$2]] ble merket til siden [[$3]] av $4',
	'imagetagging-new' => '<sup><span style="color:red">Ny!</span></sup>',
	'imagetagging-removetag' => 'fjern merking',
	'imagetagging-done-button' => 'Ferdig med å merke',
	'imagetagging-tag-button' => 'Merk',
	'imagetagging-tagcancel-button' => 'Avbryt',
	'imagetagging-tagging-instructions' => 'Klikk på folk eller ting på bildet for å merke dem.',
	'imagetagging-addingtag' => 'Legger til merke …',
	'imagetagging-removingtag' => 'Fjerner merking …',
	'imagetagging-addtagsuccess' => 'La til merking.',
	'imagetagging-removetagsuccess' => 'Fjernet merking.',
	'imagetagging-canteditneedloginmessage' => 'Du kan ikke redigere denne siden.
Det er muligens fordi man må logge inn for å merke bilder.
Vil du logge inn nå?',
	'imagetagging-oneactionatatimemessage' => 'Kun én merkingshandling av gangen er tillatt.
Vent til den forrige handlingen er ferdig.',
	'imagetagging-oneuniquetagmessage' => 'Dette bildet har allerede et merke med dette navnet.',
	'imagetagging-imagetag-seemoreimages' => 'Se flere bilder av «$1» ($2)',
	'imagetagging-taggedimages-title' => 'Bilder av «$1»',
	'imagetagging-taggedimages-displaying' => 'Viser $1&ndash;$2 av $3 bilder av «$4»',
	'tag-logpagename' => 'Merkingslogg',
	'tag-logpagetext' => 'Dette er en logg over alle nye og fjernede bildemerkinger.',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'taggedimages' => 'Imatges balisats',
	'imagetagging-desc' => "Permet a un utilizaire de seleccionar las regions d’un imatge incrustat per l'associar a una pagina.",
	'imagetagging-addimagetag' => 'Balisar aqueste imatge',
	'imagetagging-article' => 'Pagina :',
	'imagetagging-articletotag' => 'Pagina de balisar',
	'imagetagging-canteditothermessage' => 'Podètz pas modificar aquesta pagina, siá perque avètz pas los dreches necessaris siá perque la pagina es varrolhada per divèrsas rasons.',
	'imagetagging-imghistory' => 'Istoric',
	'imagetagging-images' => 'imatges',
	'imagetagging-inthisimage' => 'Dins aqueste imatge : $1',
	'imagetagging-logentry' => 'Balisa levada de la pagina [[$1]] per $2',
	'imagetagging-log-tagged' => "L'imatge [[$1|$2]] es estat balisat per la pagina [[$3]] per $4",
	'imagetagging-new' => '<sup><span style="color:red">Novèl !</span></sup>',
	'imagetagging-removetag' => 'levar la balisa',
	'imagetagging-done-button' => 'Balisatge efectuat',
	'imagetagging-tag-button' => 'Balisa',
	'imagetagging-tagcancel-button' => 'Anullar',
	'imagetagging-tagging-instructions' => 'Clicar sus las personas o las causas dins l’imatge per las balisar.',
	'imagetagging-addingtag' => 'Balisa en cors d’ajust…',
	'imagetagging-removingtag' => 'Balisa en cors de levament…',
	'imagetagging-addtagsuccess' => 'Balisa aponduda.',
	'imagetagging-removetagsuccess' => 'Balisa levada.',
	'imagetagging-canteditneedloginmessage' => 'Podètz pas modificar aquesta pagina.
Aquò poiriá èsser perque avètz besonh de vos connectar per balisar los imatges.
Vos volètz connectar ara ?',
	'imagetagging-oneactionatatimemessage' => "Una accion de balisatge es permesa a l'encòp.
Esperatz la fin de l’accion en cors.",
	'imagetagging-oneuniquetagmessage' => 'Aqueste imatge ja a una balisa amb aqueste nom.',
	'imagetagging-imagetag-seemoreimages' => 'Vejatz mai d’imatges de « $1 » ($2)',
	'imagetagging-taggedimages-title' => 'Imatges de « $1 »',
	'imagetagging-taggedimages-displaying' => 'Afichatge de $1 - $2 sus $3 imatges de « $4 »',
	'tag-logpagename' => 'Balisatge del jornal',
	'tag-logpagetext' => 'Aquò es lo jornal de totes los ajustons e de totas las supressions de las balisas d’imatge.',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Jose77
 */
$messages['or'] = array(
	'imagetagging-imghistory' => 'ଇତିହାସ',
);

/** Ossetic (Ирон)
 * @author Amikeco
 * @author Bouron
 */
$messages['os'] = array(
	'imagetagging-imghistory' => 'Истори',
	'imagetagging-tagcancel-button' => 'Ныууадзын',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'imagetagging-article' => 'Blatt:',
	'imagetagging-imghistory' => 'Gschicht',
	'imagetagging-images' => 'Pikder',
);

/** Polish (Polski)
 * @author Maikking
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'taggedimages' => 'Oznaczone grafiki',
	'imagetagging-desc' => 'Pozwala użytkownikowi wybrać fragment grafiki i skojarzyć stronę z tym fragmentem',
	'imagetagging-addimagetag' => 'Oznacz coś na zdjęciu',
	'imagetagging-article' => 'Strona',
	'imagetagging-articletotag' => 'Strona dla znacznika',
	'imagetagging-canteditothermessage' => 'Nie możesz edytować tej strony, ponieważ nie masz do tego uprawnień lub strona jest zablokowana z innych powodów.',
	'imagetagging-imghistory' => 'Historia',
	'imagetagging-images' => 'grafiki',
	'imagetagging-inthisimage' => 'Na tej grafice: $1',
	'imagetagging-logentry' => '$2 usunął znacznik ze strony [[$1]]',
	'imagetagging-log-tagged' => '$4 dodał do grafiki [[$1|$2]] znacznik z linkiem do strony [[$3]]',
	'imagetagging-new' => '<sup><span style="color:red">Nowe!</span></sup>',
	'imagetagging-removetag' => 'usuń znacznik',
	'imagetagging-done-button' => 'Koniec dodawania znaczników',
	'imagetagging-tag-button' => 'Znacznik',
	'imagetagging-tagcancel-button' => 'Anuluj',
	'imagetagging-tagging-instructions' => 'Kliknij na człowieka lub przedmiot na grafice, aby je oznaczyć.',
	'imagetagging-addingtag' => 'Dodawanie znacznika...',
	'imagetagging-removingtag' => 'Usuwanie znacznika...',
	'imagetagging-addtagsuccess' => 'Znacznik został dodany.',
	'imagetagging-removetagsuccess' => 'Znacznik został usunięty.',
	'imagetagging-canteditneedloginmessage' => 'Nie możesz edytować tej strony. 
Możliwe, że musisz się zalogować, aby oznaczać zdjęcia. 
Czy chcesz zalogować się teraz?',
	'imagetagging-oneactionatatimemessage' => 'Jednocześnie można dodawać tyko jeden znacznik.
Poczekaj na zakończenie obecnych działań.',
	'imagetagging-oneuniquetagmessage' => 'Ta grafika ma już oznaczenie o tej nazwie.',
	'imagetagging-imagetag-seemoreimages' => 'Zobacz jedną z $2 grafik z „$1”',
	'imagetagging-taggedimages-title' => 'Grafiki z  „$1”',
	'imagetagging-taggedimages-displaying' => 'Wyświetlanie $1 – $2 z $3 grafiki z „$4”',
	'tag-logpagename' => 'Rejestr dodawania znaczników',
	'tag-logpagetext' => 'Rejestr dodawania i usuwania znaczników do grafik.',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'taggedimages' => 'Figure tagà',
	'imagetagging-desc' => "A përmet a n'utent ëd selessioné dle region ëd na figura anserìa e ëd gropé na pàgina con cole region",
	'imagetagging-addimagetag' => 'Ticheté sta figura-sì',
	'imagetagging-article' => 'Pàgina:',
	'imagetagging-articletotag' => 'Pàgina da ticheté',
	'imagetagging-canteditothermessage' => "It peule pa modifiché sta pàgina-sì, përchè it l'has pa ij drit ëd felo o përchè la pàgina a l'é blocà për d'àutre rason.",
	'imagetagging-imghistory' => 'Stòria',
	'imagetagging-images' => 'Figure',
	'imagetagging-inthisimage' => 'An sta figura-sì: $1',
	'imagetagging-logentry' => 'Tichëtta gavà a la pàgina [[$1]] da $2',
	'imagetagging-log-tagged' => "La figura [[$1|$2]] a l'é stàita tichetà a la pàgina [[$3]] da $4",
	'imagetagging-new' => '<sup><span style="color:red">Neuv!</span></sup>',
	'imagetagging-removetag' => 'gava tichëtta',
	'imagetagging-done-button' => 'Tichetagi fàit',
	'imagetagging-tag-button' => 'Tichëtta',
	'imagetagging-tagcancel-button' => 'Scancela',
	'imagetagging-tagging-instructions' => 'Sgnaca dzora a përson-e o còse ant la figura për ticheteje.',
	'imagetagging-addingtag' => "Tichëtta an camin ch'as gionta...",
	'imagetagging-removingtag' => "Tichëtta an camin ch'as gava...",
	'imagetagging-addtagsuccess' => 'Tichëtta giontà.',
	'imagetagging-removetagsuccess' => 'Tichëtta gavà.',
	'imagetagging-canteditneedloginmessage' => 'It peule pa modifiché sta pàgina-sì.
A peul esse përchè it deve intré ant ël sistema për ticheté dle figure.
It veule intré adess?',
	'imagetagging-oneactionatatimemessage' => "A l'é mach possìbil n'assion ëd tichetagi a la vira.
Për piasì speta che l'assion an cors a sia completa.",
	'imagetagging-oneuniquetagmessage' => "Sta figura-sì a l'ha già na tichëtta con sto nòm-sì.",
	'imagetagging-imagetag-seemoreimages' => 'Varda pi figure ëd "$1" ($2)',
	'imagetagging-taggedimages-title' => 'Figure ëd "$1"',
	'imagetagging-taggedimages-displaying' => 'Visualisé $1 - $2 dle $3 figure ëd "$4"',
	'tag-logpagename' => 'Registr dël tichetagi',
	'tag-logpagetext' => "Cost-sì a l'é un registr ëd tute le gionte e scancelassion dle tichëtte ëd le figure.",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'imagetagging-article' => 'مخ:',
	'imagetagging-imghistory' => 'پېښليک',
	'imagetagging-images' => 'انځورونه',
	'imagetagging-tagcancel-button' => 'ناګارل',
);

/** Portuguese (Português)
 * @author 555
 * @author Hamilton Abreu
 * @author MF-Warburg
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'taggedimages' => 'Imagens etiquetadas',
	'imagetagging-desc' => 'Permite que um utilizador selecione uma região de uma imagem incorporada e associe uma página a essa região',
	'imagetagging-addimagetag' => 'Etiquetar esta imagem',
	'imagetagging-article' => 'Página:',
	'imagetagging-articletotag' => 'Página a etiquetar',
	'imagetagging-canteditothermessage' => 'Não pode editar esta página, porque não tem permissões para fazê-lo, ou porque a página está bloqueada por outros motivos.',
	'imagetagging-imghistory' => 'Histórico',
	'imagetagging-images' => 'imagens',
	'imagetagging-inthisimage' => 'Nesta imagem: $1',
	'imagetagging-logentry' => 'Removida etiqueta para a página [[$1]] por $2',
	'imagetagging-log-tagged' => 'A etiqueta da imagem [[$1|$2]] para a página [[$3]] foi adicionada por $4',
	'imagetagging-new' => '<sup><span style="color:red">Nova!</span></sup>',
	'imagetagging-removetag' => 'Remover etiqueta',
	'imagetagging-done-button' => 'A etiqueta foi adicionada',
	'imagetagging-tag-button' => 'Etiquetar',
	'imagetagging-tagcancel-button' => 'Cancelar',
	'imagetagging-tagging-instructions' => 'Clique em pessoas ou objetos na imagem para os etiquetar.',
	'imagetagging-addingtag' => 'A adicionar etiqueta…',
	'imagetagging-removingtag' => 'A remover etiqueta…',
	'imagetagging-addtagsuccess' => 'Etiqueta adicionada.',
	'imagetagging-removetagsuccess' => 'Etiqueta removida.',
	'imagetagging-canteditneedloginmessage' => 'Não pode editar esta página.
Pode ser porque precisa de se autenticar para etiquetar imagens.
Deseja autenticar-se agora?',
	'imagetagging-oneactionatatimemessage' => 'Apenas uma ação de etiquetagem é permitida de cada vez.
Por favor, aguarde que a ação existente finalize.',
	'imagetagging-oneuniquetagmessage' => 'Esta imagem já tem uma etiqueta com este nome.',
	'imagetagging-imagetag-seemoreimages' => 'Ver mais imagens de "$1" ($2)',
	'imagetagging-taggedimages-title' => 'Imagens de "$1"',
	'imagetagging-taggedimages-displaying' => 'A mostrar $1 - $2 de $3 imagens de "$4"',
	'tag-logpagename' => 'Registo de etiquetagens',
	'tag-logpagetext' => 'Este é um registo de todas as adições e remoções de etiquetas de imagens.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Enqd
 */
$messages['pt-br'] = array(
	'taggedimages' => 'Imagens marcadas',
	'imagetagging-desc' => 'Permite que um utilizador selecione uma região de uma imagem incorporada e associe uma página a essa região',
	'imagetagging-addimagetag' => 'Marcar esta imagem',
	'imagetagging-article' => 'Página:',
	'imagetagging-articletotag' => 'Página a etiquetar',
	'imagetagging-canteditothermessage' => 'Você não pode editar esta página, porque não possui permissões para isso, ou porque a página está bloqueada por outros motivos.',
	'imagetagging-imghistory' => 'Histórico',
	'imagetagging-images' => 'imagens',
	'imagetagging-inthisimage' => 'Nesta imagem: $1',
	'imagetagging-logentry' => 'Removida etiqueta para a página [[$1]] por $2',
	'imagetagging-log-tagged' => 'A etiqueta da imagem [[$1|$2]] para a página [[$3]] foi adicionada por $4',
	'imagetagging-new' => '<sup><span style="color:red">Nova!</span></sup>',
	'imagetagging-removetag' => 'Remover etiqueta',
	'imagetagging-done-button' => 'Marcação concluída',
	'imagetagging-tag-button' => 'Marcar',
	'imagetagging-tagcancel-button' => 'Cancelar',
	'imagetagging-tagging-instructions' => 'Clique em pessoas ou objetos na imagem para os etiquetar.',
	'imagetagging-addingtag' => 'Adicionando etiqueta…',
	'imagetagging-removingtag' => 'Removendo etiqueta...',
	'imagetagging-addtagsuccess' => 'Etiqueta adicionada.',
	'imagetagging-removetagsuccess' => 'Etiqueta removida.',
	'imagetagging-canteditneedloginmessage' => 'Você não pode editar esta página.
Pode ser porque você precise se autenticar para etiquetar imagens.
Deseja autenticar-se agora?',
	'imagetagging-oneactionatatimemessage' => 'Apenas uma ação de etiquetagem é permitida de cada vez.
Por favor, aguarde que a ação existente finalize.',
	'imagetagging-oneuniquetagmessage' => 'Esta imagem já tem uma etiqueta com este nome.',
	'imagetagging-imagetag-seemoreimages' => 'Ver mais imagens de "$1" ($2)',
	'imagetagging-taggedimages-title' => 'Imagens de "$1"',
	'imagetagging-taggedimages-displaying' => 'Mostrando $1 - $2 de $3 imagens de "$4"',
	'tag-logpagename' => 'Registro de etiquetagens',
	'tag-logpagetext' => 'Este é um registro de todas as adições e remoções de etiquetas de imagens.',
);

/** Tarifit (Tarifit)
 * @author Jose77
 */
$messages['rif'] = array(
	'imagetagging-imghistory' => 'Amzruy',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'taggedimages' => 'Imagini etichetate',
	'imagetagging-addimagetag' => 'Etichetează această imagine',
	'imagetagging-article' => 'Pagină:',
	'imagetagging-articletotag' => 'Pagină de etichetat',
	'imagetagging-imghistory' => 'Istoric',
	'imagetagging-images' => 'imagini',
	'imagetagging-inthisimage' => 'În această imagine: $1',
	'imagetagging-log-tagged' => 'Imaginea [[$1|$2]] a fost etichetată paginii [[$3]] de către $4',
	'imagetagging-removetag' => 'elimină etichetă',
	'imagetagging-done-button' => 'Etichetare încheiată',
	'imagetagging-tag-button' => 'Etichetă',
	'imagetagging-tagcancel-button' => 'Anulează',
	'imagetagging-tagging-instructions' => 'Apasă pe persoane sau lucruri în imagine pentru a le eticheta.',
	'imagetagging-addingtag' => 'Adăugare etichetă…',
	'imagetagging-removingtag' => 'Eliminare etichetă…',
	'imagetagging-addtagsuccess' => 'Adăugat etichetă.',
	'imagetagging-removetagsuccess' => 'Şters etichetă.',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'imagetagging-article' => 'Pàgene:',
	'imagetagging-images' => 'immaggine',
	'imagetagging-inthisimage' => "Jndr'à sta immagine: $1",
	'imagetagging-tag-button' => 'Tag',
	'imagetagging-addtagsuccess' => 'Tag aggiunde.',
	'imagetagging-removetagsuccess' => 'Tag luate.',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'taggedimages' => 'Изображения с метками',
	'imagetagging-desc' => 'Позволяет участнику выбрать один из регионов для включённых изображений и ассоциировать страницу с этим регионом',
	'imagetagging-addimagetag' => 'Отметить это изображение',
	'imagetagging-article' => 'Страница:',
	'imagetagging-articletotag' => 'Страница для метки',
	'imagetagging-canteditothermessage' => 'Вы не можете править эту страницу, так как не имеете необходимых прав, или из-за того, что страница заблокирована по другим причинам.',
	'imagetagging-imghistory' => 'История',
	'imagetagging-images' => 'изображения',
	'imagetagging-inthisimage' => 'В изображении: $1',
	'imagetagging-logentry' => 'Удаление метки для страницы [[$1]] — $2',
	'imagetagging-log-tagged' => 'Изображение [[$1|$2]] было отмечено к странице [[$3]] — $4',
	'imagetagging-new' => '<sup><span style="color:red">Новое!</span></sup>',
	'imagetagging-removetag' => 'удалить метку',
	'imagetagging-done-button' => 'Отметка сделана',
	'imagetagging-tag-button' => 'Метка',
	'imagetagging-tagcancel-button' => 'Отмена',
	'imagetagging-tagging-instructions' => 'Нажмите на участника или деталь в изображении для отметки.',
	'imagetagging-addingtag' => 'Добавление метки…',
	'imagetagging-removingtag' => 'Удаление метки…',
	'imagetagging-addtagsuccess' => 'Метка добавлена.',
	'imagetagging-removetagsuccess' => 'Метка удалена.',
	'imagetagging-canteditneedloginmessage' => 'Вы не можете править эту страницу.
Требуется представиться системе для отметки изображений.
Вы желаете представиться системе сейчас?',
	'imagetagging-oneactionatatimemessage' => 'За один раз можно отметить только один объект.
Пожалуйста, подождите, пока выполниться текущее действие.',
	'imagetagging-oneuniquetagmessage' => 'Это изображение уже было отмечено с этим именем.',
	'imagetagging-imagetag-seemoreimages' => 'Смотреть больше изображений «$1» ($2)',
	'imagetagging-taggedimages-title' => 'Изображения «$1»',
	'imagetagging-taggedimages-displaying' => 'Отображать $1 — $2 из $3 изображений из «$4»',
	'tag-logpagename' => 'Журнал меток',
	'tag-logpagetext' => 'Это журнал добавления и удаления всех меток изображений.',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'imagetagging-article' => 'Сторінка:',
	'imagetagging-imghistory' => 'Історія',
	'imagetagging-images' => 'образкы',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'taggedimages' => 'Označené obrázky',
	'imagetagging-desc' => 'Umožňuje používateľom vybrať oblasti vloženého obrázka a k danej oblasti priradiť stránku.',
	'imagetagging-addimagetag' => 'Označiť tento obrázok',
	'imagetagging-article' => 'Stránka:',
	'imagetagging-articletotag' => 'Označiť stránku:',
	'imagetagging-canteditothermessage' => 'Túto stránku nemôžete upravovať, buď preto, že na to nemáte potrebné oprávnenie alebo preto, že stránka je zamknutá z iných dôvodov.',
	'imagetagging-imghistory' => 'História',
	'imagetagging-images' => 'obrázky',
	'imagetagging-inthisimage' => 'V tomto obrázku: $1',
	'imagetagging-logentry' => '$2 odstránil zmačku na stránku [[$1]]',
	'imagetagging-log-tagged' => '$4 označil obrázok [[$1|$2]] na stránku [[$3]]',
	'imagetagging-new' => '<sup><span style="color:red">Nové!</span></sup>',
	'imagetagging-removetag' => 'odstrániť štítok',
	'imagetagging-done-button' => 'Ukončiť označovanie',
	'imagetagging-tag-button' => 'Značka',
	'imagetagging-tagcancel-button' => 'Zrušiť',
	'imagetagging-tagging-instructions' => 'Kliknutím na ľudí alebo veci na obrázku ich môžete označiť.',
	'imagetagging-addingtag' => 'Pridáva sa značka…',
	'imagetagging-removingtag' => 'Odstraňuje sa značka…',
	'imagetagging-addtagsuccess' => 'Pridaná značka.',
	'imagetagging-removetagsuccess' => 'Odstránená značka.',
	'imagetagging-canteditneedloginmessage' => 'Túto stránku nemôžete upravovať.
Možno je to preto, že sa musíte prihlásiť, aby ste mohli označovať obrázky.
Chcete sa teraz prihlásiť?',
	'imagetagging-oneactionatatimemessage' => 'Je možné naraz označovať iba jeden obrázok.
Počkajte prosím, kým sa dokončí prebiehajúca operácia.',
	'imagetagging-oneuniquetagmessage' => 'Tento obrázok už má značku s takýmto názvom.',
	'imagetagging-imagetag-seemoreimages' => 'Zobraziť viac obrázkov „$1” ($2)',
	'imagetagging-taggedimages-title' => 'Obrázky „$1”',
	'imagetagging-taggedimages-displaying' => 'Zobrazujú sa $1 - $2 z $3 obrázkov „$4”',
	'tag-logpagename' => 'Záznam značenia',
	'tag-logpagetext' => 'Toto je záznam všetkých pridaní a odstránení značiek obrázkov.',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'taggedimages' => 'Označene slike',
	'imagetagging-addimagetag' => 'Označi sliko',
	'imagetagging-article' => 'Stran:',
	'imagetagging-articletotag' => 'Stran za označitev',
	'imagetagging-imghistory' => 'Zgodovina',
	'imagetagging-images' => 'slike',
	'imagetagging-inthisimage' => 'Na tej sliki: $1',
	'imagetagging-new' => '<sup><span style="color:red">Novo!</span></sup>',
	'imagetagging-removetag' => 'odstrani oznako',
	'imagetagging-tag-button' => 'Oznaka',
	'imagetagging-tagcancel-button' => 'Prekliči',
	'imagetagging-addingtag' => 'Dodajanje oznake ...',
	'imagetagging-removingtag' => 'Odstranjevanje oznake ...',
	'imagetagging-addtagsuccess' => 'Oznaka je dodana.',
	'imagetagging-removetagsuccess' => 'Oznaka je odstranjena.',
	'imagetagging-oneuniquetagmessage' => 'Ta slika že ima oznako s tem imenom.',
	'imagetagging-imagetag-seemoreimages' => 'Oglejte si več slik »$1« ($2)',
	'imagetagging-taggedimages-title' => 'Slike »$1«',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'taggedimages' => 'Таговане слике',
	'imagetagging-desc' => 'Омогућава кориснику да изабере регионе једне слике и придружи им чланке',
	'imagetagging-addimagetag' => 'Означи слику',
	'imagetagging-article' => 'Страна:',
	'imagetagging-articletotag' => 'Чланак за таговање',
	'imagetagging-canteditothermessage' => 'Не можете да мењате ову страну, због тога што немате потребна права приступа за то или због закључавања стране из других разлога.',
	'imagetagging-imghistory' => 'Историја',
	'imagetagging-images' => 'слике',
	'imagetagging-inthisimage' => 'На овој слици: $1',
	'imagetagging-logentry' => 'Ознака је премештена на страницу [[$1]] од стране $2',
	'imagetagging-log-tagged' => 'Слика [[$1|$2]] је тагована на страну [[$3]] од $4',
	'imagetagging-new' => '<sup><span style="color:red">Ново!</span></sup>',
	'imagetagging-removetag' => 'обриши ознаку',
	'imagetagging-done-button' => 'Таговање завршено',
	'imagetagging-tag-button' => 'Означи',
	'imagetagging-tagcancel-button' => 'Откажи',
	'imagetagging-tagging-instructions' => 'Кликните на људе или ствари на слици, како бисте их таговали.',
	'imagetagging-addingtag' => 'Додавање тага…',
	'imagetagging-removingtag' => 'Брисање тага…',
	'imagetagging-addtagsuccess' => 'Додата ознака.',
	'imagetagging-removetagsuccess' => 'Уклоњена ознака.',
	'imagetagging-canteditneedloginmessage' => 'Не можете мењати овај чланак.
Ово може бити због тога што је потребно да се улогујете како би таговали слике.
Да ли желите да се улогујете?',
	'imagetagging-oneactionatatimemessage' => 'Дозвољено је да се означава једно по једно.
Сачекајте да се заврши тренутна радња.',
	'imagetagging-oneuniquetagmessage' => 'Ова слика већ има ознаку с овим именом.',
	'imagetagging-imagetag-seemoreimages' => 'Види више слика од "$1" ($2)',
	'imagetagging-taggedimages-title' => 'Слике од "$1"',
	'imagetagging-taggedimages-displaying' => 'Приказ $1 - $2 од $3 слика од "$4"',
	'tag-logpagename' => 'Историја таговања',
	'tag-logpagetext' => 'Ово је историја свих додавања и брисања тагова са слика',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Rancher
 */
$messages['sr-el'] = array(
	'taggedimages' => 'Tagovane slike',
	'imagetagging-desc' => 'Omogućava korisniku da izabere regione jedne slike i pridruži im članke',
	'imagetagging-addimagetag' => 'Taguj ovu sliku',
	'imagetagging-article' => 'Strana:',
	'imagetagging-articletotag' => 'Članak za tagovanje',
	'imagetagging-canteditothermessage' => 'Ne možete da menjate ovu stranu, zbog toga što nemate potrebna prava pristupa za to ili zbog zaključavanja strane iz drugih razloga.',
	'imagetagging-imghistory' => 'Istorija',
	'imagetagging-images' => 'slike',
	'imagetagging-inthisimage' => 'Na ovoj slici: $1',
	'imagetagging-logentry' => 'Obrisan tag ka strani [[$1]], od $2',
	'imagetagging-log-tagged' => 'Slika [[$1|$2]] je tagovana na stranu [[$3]] od $4',
	'imagetagging-new' => '<sup><span style="color:red">Novo!</span></sup>',
	'imagetagging-removetag' => 'obriši tag',
	'imagetagging-done-button' => 'Tagovanje završeno',
	'imagetagging-tag-button' => 'Označi',
	'imagetagging-tagcancel-button' => 'Otkaži',
	'imagetagging-tagging-instructions' => 'Kliknite na ljude ili stvari na slici, kako biste ih tagovali.',
	'imagetagging-addingtag' => 'Dodavanje taga…',
	'imagetagging-removingtag' => 'Brisanje taga…',
	'imagetagging-addtagsuccess' => 'Dodat tag.',
	'imagetagging-removetagsuccess' => 'Izbrisan tag.',
	'imagetagging-canteditneedloginmessage' => 'Ne možete menjati ovaj članak.
Ovo može biti zbog toga što je potrebno da se ulogujete kako bi tagovali slike.
Da li želite da se ulogujete?',
	'imagetagging-oneactionatatimemessage' => 'Moguće je dodati samo jedan tag po akciji.
Molimo vas da sačekate da se prethodna akcija završi.',
	'imagetagging-oneuniquetagmessage' => 'Ova slika već ima tag sa ovim imenom.',
	'imagetagging-imagetag-seemoreimages' => 'Vidi više slika od "$1" ($2)',
	'imagetagging-taggedimages-title' => 'Slike od "$1"',
	'imagetagging-taggedimages-displaying' => 'Prikaz $1 - $2 od $3 slika od "$4"',
	'tag-logpagename' => 'Istorija tagovanja',
	'tag-logpagetext' => 'Ovo je istorija svih dodavanja i brisanja tagova sa slika',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'taggedimages' => 'Bielden mäd Tags',
	'imagetagging-desc' => 'Moaket dät Benutsere muugelk, Beräkke fon ienbäädede Bielden uuttouwäälen un do mäd ne Siede tou ferknätten',
	'imagetagging-addimagetag' => 'Markierengen ap disse Bielde touföigje',
	'imagetagging-article' => 'Siede:',
	'imagetagging-articletotag' => 'Siede, ju der tagged wäd',
	'imagetagging-canteditothermessage' => 'Du koast disse Siede nit beoarbaidje, deeruum dät du neen Begjuchtigenge deertou hääst of deeruum dät ju Siede uut n uur Gruund speerd is.',
	'imagetagging-imghistory' => 'Versione:',
	'imagetagging-images' => 'Bielde',
	'imagetagging-inthisimage' => 'In disse Bielde: $1',
	'imagetagging-logentry' => 'Tag ap Siede [[$1]] wuud fon $2 wächhoald',
	'imagetagging-log-tagged' => 'Bielde [[$1|$2]] wuud fon $4 markierd un mäd [[$3]] ferlinked',
	'imagetagging-new' => '<sup><span style="color:red">Näi !</span></sup>',
	'imagetagging-removetag' => 'Tag wächhoalje',
	'imagetagging-done-button' => 'Tagging däin',
	'imagetagging-tag-button' => 'Tagje',
	'imagetagging-tagcancel-button' => 'Oubreeke',
	'imagetagging-tagging-instructions' => 'Klik ap Persone of Dingere in ju Bielde uum do mäd n Tag tou fersjoon.',
	'imagetagging-addingtag' => 'Tag bietouföigje ...',
	'imagetagging-removingtag' => 'Tag wächhoalje ...',
	'imagetagging-addtagsuccess' => 'Bietouföigede Tags',
	'imagetagging-removetagsuccess' => 'Wächhoalde Tags.',
	'imagetagging-canteditneedloginmessage' => 'Du koast disse Siede nit beoarbaidje.
Muugelkerwiese moast du die anmäldje, uum Bielden tou tagjen.
Moatest du die nu anmäldje?',
	'imagetagging-oneactionatatimemessage' => 'Der is man een gliektiedige Tagging-Aktion ferlööwed.
Täif jädden, bit ju momentoane Aktion ousleeten is.',
	'imagetagging-oneuniquetagmessage' => 'Disse Bielde häd al n Tag mäd dissen Noome.',
	'imagetagging-imagetag-seemoreimages' => 'Sjuch moor Bielden fon "$1" ($2)',
	'imagetagging-taggedimages-title' => 'Bielden fon "$1"',
	'imagetagging-taggedimages-displaying' => 'Anwiesd wäide $1 - $2 fon $3 Bielden uut "$4"',
	'tag-logpagename' => 'Tagging-Logbouk',
	'tag-logpagetext' => 'Dit is n Logbouk fon aal do bietouföigede un wächhoalde Bieldetags.',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'imagetagging-imghistory' => 'Jujutan',
	'imagetagging-images' => 'gambar',
	'imagetagging-tagcancel-button' => 'Bolay',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author M.M.S.
 */
$messages['sv'] = array(
	'taggedimages' => 'Märkta bilder',
	'imagetagging-desc' => 'Låter en användare välja områden på en bild och länka de områdena till en sida',
	'imagetagging-addimagetag' => 'Märk den här bilden',
	'imagetagging-article' => 'Sida:',
	'imagetagging-articletotag' => 'Sida som ska märkas',
	'imagetagging-canteditothermessage' => 'Du kan inte redigera den här sidan, antingen för att du inte har behörighet att göra det eller för att sidan är låst av andra anledningar.',
	'imagetagging-imghistory' => 'Historik',
	'imagetagging-images' => 'bilder',
	'imagetagging-inthisimage' => 'På den här bilden: $1',
	'imagetagging-logentry' => 'Tog bort märkning till sidan [[$1]] av $2',
	'imagetagging-log-tagged' => 'Bilden [[$1|$2]] märktes till sidan [[$3]] av $4',
	'imagetagging-new' => '<sup><span style="color:red">Ny!</span></sup>',
	'imagetagging-removetag' => 'ta bort märkning',
	'imagetagging-done-button' => 'Färdig med att märka',
	'imagetagging-tag-button' => 'Märk',
	'imagetagging-tagcancel-button' => 'Avbryt',
	'imagetagging-tagging-instructions' => 'Klicka på folk eller saker på bilden för att märka dom.',
	'imagetagging-addingtag' => 'Lägger till märkning...',
	'imagetagging-removingtag' => 'Tar bort märkning...',
	'imagetagging-addtagsuccess' => 'Lade till märkning.',
	'imagetagging-removetagsuccess' => 'Tog bort märkning.',
	'imagetagging-canteditneedloginmessage' => 'Du kan inte redigera den här sidan.
Det kan bero på att man måste logga in för att märka bilder.
Vill du logga in nu?',
	'imagetagging-oneactionatatimemessage' => 'Endast en märkningshandling är den här gången tillåten.
Var god vänta tills den föregående handlingen är färdig.',
	'imagetagging-oneuniquetagmessage' => 'Den här bilden har redan en märkning med det här namnet.',
	'imagetagging-imagetag-seemoreimages' => 'Se mer bilder av "$1" ($2)',
	'imagetagging-taggedimages-title' => 'Bilder av "$1"',
	'imagetagging-taggedimages-displaying' => 'Visar $1 - $2 av $3 bilder av "$4"',
	'tag-logpagename' => 'Märkningslogg',
	'tag-logpagetext' => 'Det här är en logg över alla tillägg och borttagningar av bildmärkningar.',
);

/** Tamil (தமிழ்)
 * @author செல்வா
 */
$messages['ta'] = array(
	'taggedimages' => 'குறிச்சொல் இணைத்த படங்கள்',
	'imagetagging-desc' => 'ஒரு பயனரை உள்பதியப்பட்ட ஒரு படத்திலுள்ள பகுதிகளைத் தேர்ந்தெடுக்க இது அனுமதித்து அப்பகுதியுடன் ஒரு பக்கத்தை தொடர்புபடுத்துகின்றது',
	'imagetagging-addimagetag' => 'இப்படத்துக்குக் குறிச்சொல் இணை',
	'imagetagging-article' => 'பக்கம்:',
	'imagetagging-articletotag' => 'குறிச்சொல் இணைக்கவேண்டிய பக்கம்',
	'imagetagging-canteditothermessage' => 'இப்பக்கத்தை நீங்கள் தொகுக்க முடியாது, ஏனெனில் ஒன்று உங்களுக்கு அப்படிச் செய்ய உரிமைகள் இல்லாமல் இருகக்லாம் அல்லது இப்பக்கம் வேறு காரணங்களுக்காகப் பூட்டப்பட்டு இருக்கலாம்.',
	'imagetagging-imghistory' => 'வரலாறு',
	'imagetagging-images' => 'படங்கள்',
	'imagetagging-inthisimage' => 'இப் பக்கத்தில்: $1',
	'imagetagging-logentry' => '$2 ஆல் பக்கம் [[$1]] இன் குறிச்சொல் நீக்கப்பட்டது',
	'imagetagging-log-tagged' => '$4 ஆல் பக்கம் [[$3]] உக்கு படம் [[$1|$2]] இணைக்கப்பெற்றது',
	'imagetagging-new' => '<sup><span style="color:red">புதிது!</span></sup>',
	'imagetagging-removetag' => 'குறிச்சொல்லை நீக்கு',
	'imagetagging-tag-button' => 'குறிச்சொல்',
	'imagetagging-tagcancel-button' => 'செய்யாமல் விடுக',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Veeven
 */
$messages['te'] = array(
	'imagetagging-article' => 'పేజీ:',
	'imagetagging-canteditothermessage' => 'మీరు ఈ పేజీని మార్చలేరు, ఎందుకంటే అందుకు మీరు అనుమతులు లేవు లేదా ఇతర కారణాల వల్ల ఈ పేజీకి తాళం వేసారు.',
	'imagetagging-imghistory' => 'చరిత్ర',
	'imagetagging-images' => 'బొమ్మలు',
	'imagetagging-inthisimage' => 'ఈ బొమ్మలో: $1',
	'imagetagging-new' => '<sup><span style="color:red">కొత్తది!</span></sup>',
	'imagetagging-removetag' => 'ట్యాగు తీసివెయ్యి',
	'imagetagging-done-button' => 'ట్యాగు పెట్టడం అయింది',
	'imagetagging-tag-button' => 'ట్యాగు',
	'imagetagging-tagcancel-button' => 'రద్దుచేయి',
	'imagetagging-tagging-instructions' => 'బొమ్మలోని వ్యక్తులు లేదా వస్తువులకు ట్యాగు పెట్టేందుకు వాటి మీద నొక్కండి.',
	'imagetagging-addingtag' => 'ట్యాగును చేరుస్తున్నాం..',
	'imagetagging-removingtag' => 'ట్యాగును తీసేస్తున్నాం..',
	'imagetagging-addtagsuccess' => 'ట్యాగును చేర్చాం.',
	'imagetagging-removetagsuccess' => 'ట్యాగును తీసేసాం.',
	'imagetagging-canteditneedloginmessage' => 'మీ రీ పేజీని ఎడిట్ చెయ్యలేరు.
బొమ్మలకు ట్యాగు తగిలించాలంటే మీరు లాగిన్ కావాల్సి ఉండటం దానికి కారణం కావచ్చు
ఇప్పుడు లాగినవుతారా?',
	'imagetagging-oneactionatatimemessage' => 'ఏకకాలంలో ఒక ట్యాగింగు వ్యాపకం మాత్రమే చేసే వీలుంది.
ప్రస్తుతం జరుగుతున్న వ్యాపకాన్ని పుర్తయేదాకా ఆగండి.',
	'imagetagging-oneuniquetagmessage' => 'ఈ పేజీలో ఇదే పేరుతో ఈసరికే ఒక ట్యాగు ఉంది.',
	'imagetagging-imagetag-seemoreimages' => '"$1" యొక్క మరిన్ని చిత్రాలను చూడండి ($2)',
	'imagetagging-taggedimages-title' => '"$1" యొక్క చిత్రాలు',
	'tag-logpagename' => 'ట్యాగుల లాగ్',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'imagetagging-article' => 'Pájina:',
	'imagetagging-imghistory' => 'Istória',
	'imagetagging-tagcancel-button' => 'Para',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'imagetagging-article' => 'Sahypa:',
	'imagetagging-imghistory' => 'Geçmiş',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'taggedimages' => 'Mga larawang natatakan na',
	'imagetagging-desc' => 'Nagpapahintulot sa isang tagagamit na makapili ng mga rehiyon ng isang nakabaong larawan at iugnay ang isang pahina sa ganyang rehiyon',
	'imagetagging-addimagetag' => 'Tatakan ang larawang ito',
	'imagetagging-article' => 'Pahina:',
	'imagetagging-articletotag' => 'Pahinang tatatakan',
	'imagetagging-canteditothermessage' => 'Hindi mo mababago ang pahinang ito, maaaring dahil wala kang mga karapatang gawin ito o sapagkat ikinandado ang pahina dahil sa iba pang mga kadahilanan.',
	'imagetagging-imghistory' => 'Kasaysayan',
	'imagetagging-images' => 'mga larawan',
	'imagetagging-inthisimage' => 'Sa loob ng larawang ito: $1',
	'imagetagging-logentry' => 'Tinangal ni $2 ang tatak na nasa pahinang [[$1]]',
	'imagetagging-log-tagged' => 'Itinatak ni $4 ang larawang [[$1|$2]] sa pahinang [[$3]]',
	'imagetagging-new' => '<sup><span style="color:red">Bago!</span></sup>',
	'imagetagging-removetag' => 'tanggalin ang tatak',
	'imagetagging-done-button' => 'Tapos na ang pagtatatak',
	'imagetagging-tag-button' => 'Tatakan',
	'imagetagging-tagcancel-button' => 'Huwag ituloy',
	'imagetagging-tagging-instructions' => 'Pindutin ang mga tao o mga bagay na nasa loob ng larawan upang matatakan sila.',
	'imagetagging-addingtag' => 'Idinadagdag ang tatak...',
	'imagetagging-removingtag' => 'Tinatanggal ang tatak...',
	'imagetagging-addtagsuccess' => 'Idinagdag ang tatak.',
	'imagetagging-removetagsuccess' => 'Tinanggal ang tatak.',
	'imagetagging-canteditneedloginmessage' => 'Hindi mo mababago ang pahinang ito.
Maaaring kailangan mong lumagda muna upang makapagtatak ng mga larawan.
Nais mo bang lumagda na ngayon?',
	'imagetagging-oneactionatatimemessage' => 'Isang galaw ng pagtatatak lamang sa isang panahon ang pinapahintulutan.
Pakihintay lamang na mabuo muna ang umiiral na kilos.',
	'imagetagging-oneuniquetagmessage' => 'Ang larawang ito ay mayroon nang isang tatak na may ganitong pangalan.',
	'imagetagging-imagetag-seemoreimages' => 'Tingnan ang mas marami pang mga larawan ng "$1" ($2)',
	'imagetagging-taggedimages-title' => 'Mga larawan ng "$1"',
	'imagetagging-taggedimages-displaying' => 'Ipinapakita ang $1 - $2 ng $3 mga larawan ng "$4"',
	'tag-logpagename' => 'Tala ng pagtatatak',
	'tag-logpagetext' => 'Isa itong talaan ng lahat ng mga pagdaragdag at mga pagtatanggal ng tatak ng larawan.',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Karduelis
 * @author Manco Capac
 * @author Stultiwikia
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'taggedimages' => 'Etiketlenmiş resimler',
	'imagetagging-addimagetag' => 'Bu resmi etiketle',
	'imagetagging-article' => 'Madde:',
	'imagetagging-articletotag' => 'Etiketlenecek sayfa',
	'imagetagging-imghistory' => 'Geçmiş',
	'imagetagging-images' => 'Resimler',
	'imagetagging-removetag' => 'etiketi kaldır',
	'imagetagging-done-button' => 'Etiketleme tamamlandı',
	'imagetagging-tag-button' => 'Etiketle',
	'imagetagging-tagcancel-button' => 'İptal',
	'imagetagging-tagging-instructions' => 'Etiketlemek için resim üzerindeki kişilere ya da şeylere tıklayınız',
	'imagetagging-addingtag' => 'Etiket ekleniyor...',
	'imagetagging-removingtag' => 'Etiket kaldırılıyor...',
	'imagetagging-addtagsuccess' => 'Etiket eklendi.',
	'imagetagging-removetagsuccess' => 'Etiket kaldırıldı.',
	'imagetagging-oneuniquetagmessage' => 'Resim üzerinde bu isimde bir etiket zaten var.',
	'imagetagging-taggedimages-title' => '"$1" resimleri',
	'tag-logpagename' => 'Etiketleme kaydı',
);

/** Uyghur (Latin script) (Uyghurche‎)
 * @author Jose77
 */
$messages['ug-latn'] = array(
	'imagetagging-article' => 'Bet:',
);

/** Ukrainian (Українська)
 * @author Alex Khimich
 */
$messages['uk'] = array(
	'taggedimages' => 'Зображення з мітками',
	'imagetagging-desc' => 'Дозволяє учаснику вибрати ділянки на включеному зображенні і асоціювати сторінки з цими ділянками',
	'imagetagging-addimagetag' => 'Відмітити це зображення',
	'imagetagging-article' => 'Сторінка:',
	'imagetagging-articletotag' => 'Сторінка для мітки',
	'imagetagging-canteditothermessage' => 'Ви не можете редагувати цю сторінку, так як в Вас немає відповідних прав, або сторінка захищена від редагувань з інших причин.',
	'imagetagging-imghistory' => 'Історія',
	'imagetagging-images' => 'зображення',
	'imagetagging-inthisimage' => 'На цьому зображенні: $1',
	'imagetagging-logentry' => 'Мітка до сторінки [[$1]] була видалена $2',
	'imagetagging-log-tagged' => 'Зображення [[$1|$2]] було співставлене з сторінкою [[$3]] - $4',
	'imagetagging-new' => '<sup><span style="color:red">Нове!</span></sup>',
	'imagetagging-removetag' => 'вилучити мітку',
	'imagetagging-done-button' => 'Відмітка поставлена',
	'imagetagging-tag-button' => 'Мітка',
	'imagetagging-tagcancel-button' => 'Скасувати',
	'imagetagging-tagging-instructions' => 'Натисніть на зображення речей або людей на зображенні, щоб їх відмітити.',
	'imagetagging-addingtag' => 'Додання мітки...',
	'imagetagging-removingtag' => 'Видалення мітки...',
	'imagetagging-addtagsuccess' => 'Мітка додана.',
	'imagetagging-removetagsuccess' => 'Видалена мітка.',
	'imagetagging-canteditneedloginmessage' => 'Ви не можете редагувати цю сторінку.
Можливо, Вам потрібно виконати вхід до системи, щоб відмічати зображення.
Виконати вхід?',
	'imagetagging-oneactionatatimemessage' => "Одночасно можна відмітити тільки один об'єкт.
Будь ласка, дочекайтесь завершення попередньої дії.",
	'imagetagging-oneuniquetagmessage' => 'Мітка з таким іменем вже існує на зображенні.',
	'imagetagging-imagetag-seemoreimages' => 'Переглянути більше фотографій "$1" ($2)',
	'imagetagging-taggedimages-title' => 'Зображення "$1"',
	'imagetagging-taggedimages-displaying' => 'Відображення $1 - $2 з $3 зображень "$4"',
	'tag-logpagename' => 'Журнал міток',
	'tag-logpagetext' => 'Журнал додавання та видалення всіх міток зображень.',
);

/** Urdu (اردو) */
$messages['ur'] = array(
	'imagetagging-tagcancel-button' => 'منسوخ',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'imagetagging-article' => "Lehtpol':",
	'imagetagging-articletotag' => "Lehtpol' virgates",
	'imagetagging-imghistory' => 'Istorii',
	'imagetagging-images' => 'kuvad',
	'imagetagging-removetag' => 'heitta virg',
	'imagetagging-tag-button' => 'Virg',
	'imagetagging-tagcancel-button' => 'Heitta pätand',
	'imagetagging-addingtag' => 'Virgan ližadamine...',
	'imagetagging-removingtag' => 'Virgan heitmine...',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'taggedimages' => 'Hình có gắn thẻ',
	'imagetagging-desc' => 'Cho phép người dùng lựa chọn những khu vực của một hình được nhúng vào và gắn một trang vào khu vực đó',
	'imagetagging-addimagetag' => 'Gắn thẻ hình này',
	'imagetagging-article' => 'Trang:',
	'imagetagging-articletotag' => 'Trang gắn thẻ',
	'imagetagging-canteditothermessage' => 'Bạn không thể sửa đổi trang này, có thể do bạn không có quyền thực hiện hoặc do trang bị khóa vì một lý do nào khác.',
	'imagetagging-imghistory' => 'Lịch sử',
	'imagetagging-images' => 'hình',
	'imagetagging-inthisimage' => 'Trong hình này: $1',
	'imagetagging-logentry' => '$2 đã bỏ thẻ cho trang [[$1]]',
	'imagetagging-log-tagged' => 'Hình [[$1|$2]] đã được gắn vào trang [[$3]] bởi $4',
	'imagetagging-new' => '<sup><span style="color:red">Mới!</span></sup>',
	'imagetagging-removetag' => 'bỏ thẻ',
	'imagetagging-done-button' => 'Đã gắn thẻ xong',
	'imagetagging-tag-button' => 'Thẻ',
	'imagetagging-tagcancel-button' => 'Hủy bỏ',
	'imagetagging-tagging-instructions' => 'Nhấn vào người hoặc vật trong hình để gắn thẻ cho chúng.',
	'imagetagging-addingtag' => 'Đang thêm thẻ…',
	'imagetagging-removingtag' => 'Đang bỏ thẻ…',
	'imagetagging-addtagsuccess' => 'Đã thêm thẻ.',
	'imagetagging-removetagsuccess' => 'Đã bỏ thẻ.',
	'imagetagging-canteditneedloginmessage' => 'Bạn không sửa đổi trang này.
Có thể do bạn cần phải đăng nhập mới gắn thẻ cho hình được.
Bạn có muốn đăng nhập ngay bây giờ?',
	'imagetagging-oneactionatatimemessage' => 'Chỉ cho phép một tác vụ gắn thẻ vào một thời điểm.
Xin hãy chờ tác vụ hoàn thành.',
	'imagetagging-oneuniquetagmessage' => 'Hình này đã có một thẻ với tên này.',
	'imagetagging-imagetag-seemoreimages' => 'Xem nhiều hình của "$1" hơn ($2)',
	'imagetagging-taggedimages-title' => 'Hình của "$1"',
	'imagetagging-taggedimages-displaying' => 'Hiển thị $1 - $2 trong tổng số $3 hình của "$4"',
	'tag-logpagename' => 'Gắn thẻ cho nhật trình',
	'tag-logpagetext' => 'Đây là nhật trình ghi lại tất cả tác vụ thêm và bỏ thẻ hình ảnh.',
);

/** Wu (吴语) */
$messages['wuu'] = array(
	'imagetagging-tagcancel-button' => '取消',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'imagetagging-imghistory' => 'היסטאריע',
	'imagetagging-images' => 'בילדער',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Liangent
 * @author Wmr89502270
 * @author Wrightbus
 */
$messages['zh-hans'] = array(
	'imagetagging-addimagetag' => '标签这幅图片',
	'imagetagging-article' => '页面：',
	'imagetagging-imghistory' => '历史',
	'imagetagging-images' => '图片',
	'imagetagging-removetag' => '移除标签',
	'imagetagging-done-button' => '完成标签',
	'imagetagging-tag-button' => '标签',
	'imagetagging-tagcancel-button' => '取消',
	'imagetagging-addingtag' => '正在新增标签...',
	'imagetagging-removingtag' => '正在移除标签...',
	'imagetagging-addtagsuccess' => '已新增标签。',
	'imagetagging-removetagsuccess' => '已移除标签。',
	'tag-logpagename' => '标签记录',
	'tag-logpagetext' => '这是所有新增及移除图片标签的记录。',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Liangent
 * @author Mark85296341
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'imagetagging-addimagetag' => '標籤這幅圖片',
	'imagetagging-article' => '頁面：',
	'imagetagging-imghistory' => '歷史',
	'imagetagging-images' => '圖片',
	'imagetagging-removetag' => '移除標籤',
	'imagetagging-done-button' => '完成標籤',
	'imagetagging-tag-button' => '標籤',
	'imagetagging-tagcancel-button' => '取消',
	'imagetagging-addingtag' => '正在新增標籤......',
	'imagetagging-removingtag' => '正在移除標籤......',
	'imagetagging-addtagsuccess' => '已新增標籤。',
	'imagetagging-removetagsuccess' => '已移除標籤。',
	'tag-logpagename' => '標籤記錄',
	'tag-logpagetext' => '這是所有新增及移除圖片標籤的記錄。',
);

