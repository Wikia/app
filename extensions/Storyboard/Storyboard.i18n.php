<?php
/**
 * Internationalization file for the Storyboard extension.
 *
 * @file Storyboard.i18n.php
 * @ingroup Storyboard
 *
 * @author Jeroen De Dauw
 */

$messages = array();

/** English
 * @author Jeroen De Dauw
 */
$messages['en'] = array(
	// General
	'storyboard-name' => 'Storyboard',
	'storyboard-desc' => 'Provides a [[Special:Story|landing page for donors]], a page where stories can be [[Special:StorySubmission|submitted]] and a [[Special:StoryReview|story moderation interface]]',
	'right-storyreview' => 'Review, edit, publish, and hide stories',
	'storyboard-anerroroccured' => 'An error occured: $1',

	// Story states
	'storyboard-unpublished' => 'Unpublished',
	'storyboard-published' => 'Published',
	'storyboard-hidden' => 'Hidden',
	'storyboard-unpublish' => 'Unpublish',
	'storyboard-publish' => 'Publish',
	'storyboard-hide' => 'Hide',

	'storyboard-option-unpublished' => 'unpublished',
	'storyboard-option-published' => 'published',
	'storyboard-option-hidden' => 'hidden',

	// Special:Story
	'story' => 'Story',
	'storyboard-submittedbyon' => 'Submitted by $1 on $2, $3.',
	'storyboard-viewstories' => 'View stories',
	'storyboard-nosuchstory' => 'The story you requested does not exist.
It might have been removed.',
	'storyboard-storyunpublished' => 'The story you requested has not been published yet.',
	'storyboard-nostorytitle' => 'You need to specify the title or ID of the story you want to view.',
	'storyboard-cantedit' => 'You are not allowed to edit stories.',
	'storyboard-canedit' => 'You can [$1 edit] and publish this story.',
	'storyboard-createdandmodified' => 'Created on $1, $2 and last modified on $3, $4',
	'storyboard-authorname' => 'Author name',
	'storyboard-authorlocation' => 'Author location',
	'storyboard-authoroccupation' => 'Author occupation',
	'storyboard-authoremail' => 'Author e-mail address',
	'storyboard-thestory' => 'The story',
	'storyboard-storystate' => 'State',
	'storyboard-language' => 'Language',

	// Storyboard tag
	'storyboard-storymetadata' => 'Submitted by $1 on $2, $3.',
	'storyboard-storymetadatafrom' => 'Submitted by $1 from $2 on $3, $4.',

	// Story submission tag
	'storyboard-yourname' => 'Your name (required)',
	'storyboard-location' => 'Your location',
	'storyboard-occupation' => 'Your occupation',
	'storyboard-story' => 'Your story',
	'storyboard-photo' => 'Have a photo of yourself?
Why not share it?',
	'storyboard-email' => 'Your e-mail address (required)',
	'storyboard-storytitle' => 'A short, descriptive title (required)',
	'storyboard-agreement' => 'I agree with the publication and use of this story under the terms of the [http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution/Share-Alike License].',
	'storyboard-charsleft' => '($1 {{PLURAL:$1|character|characters}} left)',
	'storyboard-cannotbelonger' => 'Your story is <b>$1</b> {{PLURAL:$1|character|characters}} too long!',
	'storyboard-charsneeded' => '($1 more {{PLURAL:$1|character|characters}} needed)',
	'storyboard-needtoagree' => 'You need to agree to the publication of your story to submit it.',

	// Special:StorySubmission
	'storyboard-submissioncomplete' => 'Submission complete',
	'storyboard-submissionincomplete' => 'Submission failed',
	'storyboard-alreadyexists' => '"$1" is already taken.',
	'storyboard-alreadyexistschange' => '"{0}" is already taken, please choose a different title.', // Use {0} not $1!
	'storyboard-changetitle' => 'Change the title.',
	'storyboard-notsubmitted' => 'Authentication failed, no story has been saved.',
	'storyboard-charstomany' => '$1 characters too many!',
	'storyboard-morecharsneeded' => '$1 more characters needed',
	'storyboard-charactersleft' => '$1 characters left',
	'storyboard-needtoagree' => 'You need to agree to the publication of your story to submit it.',
	'storyboard-createdsuccessfully' => 'Thank you for sharing your story with us!
We will review it shortly.
You can [$1 read published stories].',
	'storyboard-emailtitle' => 'Story submission successful',
	'storyboard-emailbody' => 'Your story titled "$1" has been successfully submitted.
We will review it shortly.
You can [$2 read published stories].',

	// Story review
	'storyreview' => 'Story review',
	'storyboard-deleteimage' => 'Delete image',
	'storyboard-done' => 'Done',
	'storyboard-working' => 'Working...',
	'storyboard-imagedeletionconfirm' => "Are you sure you want to permanently delete this story's image?",
	'storyboard-imagedeleted' => 'Image deleted',
	'storyboard-showimage' => 'Show image',
	'storyboard-hideimage' => 'Hide image',
	'storyboard-deletestory' => 'Remove',
	'storyboard-storydeletionconfirm' => 'Are you sure you want to permanently delete this story?'
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Hamilton Abreu
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'storyboard-desc' => '{{desc}}',
	'right-storyreview' => '{{doc-right|storyreview}}',
	'storyboard-hidden' => '{{Identical|Hidden}}',
	'storyboard-publish' => '{{Identical|Publish}}',
	'storyboard-hide' => '{{Identical|Hide}}',
	'storyboard-language' => '{{Identical|Language}}',
	'storyboard-alreadyexists' => '$1 is a story title',
	'storyboard-done' => '{{Identical|Done}}',
	'storyboard-deletestory' => '{{Identical|Remove}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'storyboard-name' => 'Storiebord',
	'storyboard-desc' => "Bied 'n landingsbladsy vir skenkers, 'n bladsy waar verhale ingestuur kan word en 'n koppelvlak om stories te beheer",
	'right-storyreview' => 'Hersien, wysig, publiseer en verberg stories',
	'storyboard-unpublished' => 'Ongepubliseer',
	'storyboard-published' => 'Gepubliseer',
	'storyboard-hidden' => 'Versteek',
	'storyboard-publish' => 'Publiseer',
	'storyboard-viewstories' => 'Wys verhale',
	'storyboard-thestory' => 'Die verhaal',
	'storyboard-language' => 'Taal',
	'storyboard-location' => 'U ligging',
	'storyboard-occupation' => 'U beroep',
	'storyboard-story' => 'U verhaal',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'storyboard-notsubmitted' => 'Authentication dështuar, nuk ka histori është ruajtur.',
	'storyboard-charstomany' => '$1 shkronja shumë!',
	'storyboard-morecharsneeded' => 'karaktere $1 më të nevojshme',
	'storyboard-charactersleft' => '$1 shkronja majtë',
	'storyboard-createdsuccessfully' => 'Thank you for sharing historinë tënde me ne! Ne do të analizojmë atë së shpejti. Ju mund [$1 të lexuar të botuar tregimet].',
	'storyboard-emailtitle' => 'paraqitjes Story suksesshëm',
	'storyboard-emailbody' => 'Historia juaj me titull "$1" është paraqitur me sukses. Ne do të analizojmë atë së shpejti. Ju mund [$2 lexuar botuar tregimet].',
	'storyreview' => 'shqyrtim Story',
	'storyboard-deleteimage' => 'image Fshije',
	'storyboard-done' => 'E bërë',
	'storyboard-working' => 'Duke punuar ...',
	'storyboard-imagedeletionconfirm' => 'A jeni i sigurt që dëshironi të fshijë imazhin kjo histori e?',
	'storyboard-imagedeleted' => 'Image fshirë',
	'storyboard-showimage' => 'image Show',
	'storyboard-hideimage' => 'image Hide',
	'storyboard-deletestory' => 'Heq',
	'storyboard-storydeletionconfirm' => 'A jeni i sigurt se doni te fshini përgjithmonë këtë histori?',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'storyboard-publish' => 'Publicar',
	'storyboard-language' => 'Idioma',
);

/** Arabic (العربية)
 * @author AwamerT
 * @author OsamaK
 */
$messages['ar'] = array(
	'storyboard-name' => 'القصة المصورة',
	'storyboard-desc' => 'يقدم [[Special:Story|landing page for donors]] الصفحة التي ستحتوي على القصص [[Special:StorySubmission|submitted]] و [[Special:StoryReview|story moderation interface]]',
	'right-storyreview' => 'مراجعة, تعديل, نشر، وإخفاء القصص',
	'storyboard-anerroroccured' => 'حدث خطأ:$1',
	'storyboard-unpublished' => 'لم تنشر',
	'storyboard-published' => 'تم نشره',
	'storyboard-hidden' => 'مخفي',
	'storyboard-unpublish' => 'ألغِ النشر',
	'storyboard-publish' => 'انشر',
	'storyboard-hide' => 'أخفِ',
	'storyboard-option-unpublished' => 'غير منشور',
	'storyboard-option-published' => 'تم نشره',
	'storyboard-option-hidden' => 'مخفي',
	'story' => 'قصة',
	'storyboard-submittedbyon' => 'قدمت بنسبة $1 على $2 ، $3 .',
	'storyboard-viewstories' => 'إعرض القصص',
	'storyboard-nosuchstory' => 'القصة التي طلبتها غير موجودة,, من الممكن انه قد تمت إزالتها.',
	'storyboard-storyunpublished' => 'القصة التي طلبتها لم تنشر بعد.',
	'storyboard-nostorytitle' => 'انت بحاجة الى تحديد عنوان القصة التي ترغب بعرضها او تحديد رقم التعريف الخاص بها.',
	'storyboard-cantedit' => 'انت غير مسموح لك بتعديل القصص',
	'storyboard-canedit' => 'يمكنك [$1 edit] ونشر هذه القصة.',
	'storyboard-createdandmodified' => 'أنشأت على $1 ، $2 وآخر تعديل على $3 ، $4',
	'storyboard-authorname' => 'اسم المؤلف',
	'storyboard-authorlocation' => 'موقع المؤلف',
	'storyboard-authoroccupation' => 'مهنة المؤلف',
	'storyboard-authoremail' => 'عنوان البريد الإلكتروني للمؤلف',
	'storyboard-thestory' => 'القصة',
	'storyboard-storystate' => 'حالة',
	'storyboard-language' => 'اللغة',
	'storyboard-storymetadata' => 'قدمت بنسبة $1 على $2 ، $3 .',
	'storyboard-storymetadatafrom' => 'قدمت بـنسبة  $1 من $2 على $3 ، $4',
	'storyboard-yourname' => 'اسمك (مطلوب)',
	'storyboard-location' => 'موقعك',
	'storyboard-occupation' => 'مهنتك',
	'storyboard-story' => 'قصتك',
	'storyboard-photo' => 'هل لديك صوره لك؟ لماذا لا تشارك بها؟',
	'storyboard-email' => 'البريد الالكتروني (مطلوب)',
	'storyboard-storytitle' => 'وصف مختصر للعنوان',
	'storyboard-agreement' => 'أنا أوافق على شروط نشر واستخدام هذه القصة تحت بنود [http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution/Share-Alike License].',
	'storyboard-charsleft' => '($1 {{PLURAL:$1|character|characters}} يسار)',
	'storyboard-cannotbelonger' => 'قصتك <b>$1</b> {{PLURAL:$1|character|characters}} طويله جداً',
	'storyboard-charsneeded' => '($1 more {{PLURAL:$1|character|characters}} مطلوب)',
	'storyboard-needtoagree' => 'تحتاج إلى ان توافق على نشر قصتك لتقديمها.',
	'storyboard-submissioncomplete' => 'تم التقدبم',
	'storyboard-submissionincomplete' => 'فشل التقديم',
	'storyboard-alreadyexists' => '"$1" بالفعل محجوز.',
	'storyboard-alreadyexistschange' => '"{0}" غير متاح ، الرجاء اختيار عنوان آخر.',
	'storyboard-changetitle' => 'تغيير العنوان.',
	'storyboard-notsubmitted' => 'فشل المصادقة ، لم يتم حفظ أي قصة',
	'storyboard-charstomany' => '$1 شخصيات كثيره جداً',
	'storyboard-morecharsneeded' => '$1 بحاجة الى شخصيات أكثر',
	'storyboard-charactersleft' => '$1 شخصيه متبقيه',
	'storyboard-createdsuccessfully' => 'شكراً لك على مشاركة قصتك معنا
 سنراجعها قريبا
يمكنك [$1 read published stories]',
	'storyboard-emailtitle' => 'قدمت القصة بنجاح',
	'storyboard-emailbody' => 'تم تقديم قصتك المعنونة بــ  "$1"  بنجاح
سنستعرضها قريباً
يمكنك [$2 read published stories]',
	'storyreview' => 'مراجعة القصة',
	'storyboard-deleteimage' => 'حذف الصورة',
	'storyboard-done' => 'تم',
	'storyboard-working' => 'العمل جارٍ',
	'storyboard-imagedeletionconfirm' => 'هل أنت متأكد أنك تريد حذف صورة هذه القصة؟',
	'storyboard-imagedeleted' => 'تم حذف صورة',
	'storyboard-showimage' => 'أظهر الصورة',
	'storyboard-hideimage' => 'أخف الصورة',
	'storyboard-deletestory' => 'إزالة',
	'storyboard-storydeletionconfirm' => 'هل أنت متأكد أنك تريد حذف صورة هذه القصة؟',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'storyboard-hide' => 'ܛܫܝ',
	'storyboard-language' => 'ܠܫܢܐ',
	'storyboard-hideimage' => 'ܛܫܝ ܨܘܪܬܐ',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'storyboard-language' => 'Dil',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'storyboard-name' => 'Дошка гісторыяў',
	'storyboard-desc' => 'Прадстаўляе [[Special:Story|старонку]] для [[Special:StorySubmission|разьмяшчэньня]] гісторыяў ахвяравальнікаў, а таксама [[Special:StoryReview|інтэрфэйс яе мадэрацыі]].',
	'right-storyreview' => 'рэцэнзаваньне, рэдагаваньне, публікацыя і хаваньне гісторыяў',
	'storyboard-anerroroccured' => 'Узьнікла памылка: $1',
	'storyboard-unpublished' => 'Неапублікаваныя',
	'storyboard-published' => 'Апублікаваныя',
	'storyboard-hidden' => 'Схаваныя',
	'storyboard-unpublish' => 'Прыбраць',
	'storyboard-publish' => 'Апублікаваць',
	'storyboard-hide' => 'Схаваць',
	'storyboard-option-unpublished' => 'неапублікаваная',
	'storyboard-option-published' => 'апублікаваная',
	'storyboard-option-hidden' => 'схаваная',
	'story' => 'Гісторыя',
	'storyboard-submittedbyon' => 'Адпраўленая $1 $2, $3.',
	'storyboard-viewstories' => 'Паказаць гісторыі',
	'storyboard-nosuchstory' => 'Гісторыя, якую Вы запыталі, не існуе.
Верагодна, яна была выдаленая.',
	'storyboard-storyunpublished' => 'Гісторыя, якую Вы запыталі, яшчэ не была апублікаваная.',
	'storyboard-nostorytitle' => 'Вам неабходна падаць назву альбо ідэнтыфікатар гісторыі, якую Вы жадаеце праглядзець.',
	'storyboard-cantedit' => 'Вам не дазволена рэдагаваць гісторыі.',
	'storyboard-canedit' => 'Вы можаце [$1 рэдагаваць] і апублікаваць гэтую гісторыю.',
	'storyboard-createdandmodified' => 'Створаная $1, $2 і апошні раз зьмянялася $3, $4',
	'storyboard-authorname' => 'Імя аўтара',
	'storyboard-authorlocation' => 'Месцазнаходжаньне аўтара',
	'storyboard-authoroccupation' => 'Род заняткаў аўтара',
	'storyboard-authoremail' => 'Адрас электроннай пошты аўтара',
	'storyboard-thestory' => 'Гісторыя',
	'storyboard-storystate' => 'Стан',
	'storyboard-language' => 'Мова',
	'storyboard-storymetadata' => 'Адпраўленая $1 $2, $3.',
	'storyboard-storymetadatafrom' => 'Дасланая $1 з $2 $3, $4.',
	'storyboard-yourname' => 'Ваша імя (абавязкова)',
	'storyboard-location' => 'Ваша месцазнаходжаньне',
	'storyboard-occupation' => 'Ваш род заняткаў',
	'storyboard-story' => 'Ваша гісторыя',
	'storyboard-photo' => 'Вы маеце сваё фота?
Чаму б яго не разьмясьціць?',
	'storyboard-email' => 'Адрас Вашай электроннай пошты (абавязкова)',
	'storyboard-storytitle' => 'Кароткі, апісваючы загаловак (абавязкова)',
	'storyboard-agreement' => 'Я згодны з публікацыяй і выкарыстаньнем гэтай гісторыі на ўмовах ліцэнзіі [http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution/Share-Alike License].',
	'storyboard-charsleft' => '({{PLURAL:$1|застаўся $1 сымбаль|засталося $1 сымбалі|засталося $1 сымбаляў}})',
	'storyboard-cannotbelonger' => 'Ваша гісторыя даўжэй на <b>$1</b> {{PLURAL:$1|сымбаль|сымбалі|сымбаляў}}!',
	'storyboard-charsneeded' => '({{PLURAL:$1|неабходны яшчэ $1 сымбаль|неабходныя яшчэ $1 сымбалі|неабходныя яшчэ $1 сымбаляў}})',
	'storyboard-needtoagree' => 'Вам неабходна пагадзіцца на публікацыю Вашай гісторыі перад яе адпраўкай.',
	'storyboard-submissioncomplete' => 'Адпраўка скончаная',
	'storyboard-submissionincomplete' => 'Памылка адпраўкі',
	'storyboard-alreadyexists' => '«$1» ужо занятая.',
	'storyboard-alreadyexistschange' => '«{0}» ужо занятая, калі ласка, выберыце іншую назву.',
	'storyboard-changetitle' => 'Зьмяніць назву.',
	'storyboard-notsubmitted' => 'Памылка аўтэнтыфікацыі, ніякія гісторыі не былі захаваныя.',
	'storyboard-charstomany' => '$1 — зашмат сымбаляў!',
	'storyboard-morecharsneeded' => 'неабходна больш за $1 {{PLURAL:$1|сымбаль|сымбалі|сымбаляў}}',
	'storyboard-charactersleft' => '{{PLURAL:$1|застаўся $1 сымбаль|засталіся $1 сымбалі|засталіся $1 сымбаляў}}',
	'storyboard-createdsuccessfully' => 'Дзякуй Вам за тое, што падзяліліся з намі Вашай гісторыяй!
Мы разгледзім яе ў бліжэйшы час.
Вы можаце [$1 пачытаць ужо апублікаваныя гісторыі].',
	'storyboard-emailtitle' => 'Гісторыя дасланая пасьпяхова',
	'storyboard-emailbody' => 'Ваша гісторыя з назвай «$1» пасьпяхова дасланая.
Хутка Вы зможаце яе праглядзець.
Вы можаце [$2 пачытаць апублікаваныя гісторыі].',
	'storyreview' => 'Рэцэнзаваньне гісторыі',
	'storyboard-deleteimage' => 'Выдаліць выяву',
	'storyboard-done' => 'Выканана',
	'storyboard-working' => 'Працуе…',
	'storyboard-imagedeletionconfirm' => 'Вы ўпэўнены, што жадаеце назаўсёды выдаліць выяву гэтай гісторыі?',
	'storyboard-imagedeleted' => 'Выява выдаленая',
	'storyboard-showimage' => 'Паказаць выяву',
	'storyboard-hideimage' => 'Схаваць выяву',
	'storyboard-deletestory' => 'Выдаліць',
	'storyboard-storydeletionconfirm' => 'Вы ўпэўненыя, што жадаеце назаўсёды выдаліць гэтую гісторыю?',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'storyboard-language' => 'Език',
	'storyboard-deletestory' => 'Премахване',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'storyboard-name' => 'Storyboard',
	'storyboard-desc' => 'Reiñ a ra [[Special:Story|ur bajenn voned evit ar roerien]], ur bajenn evit [[Special:StorySubmission|kinnig]] istorioù hag un [[Special:StoryReview|etrefas evit merañ an istorioù]]',
	'right-storyreview' => 'Adlenn, kemmañ, embann, ha kuzhat an istorioù',
	'storyboard-anerroroccured' => 'Ur fazi a zo bet : $1',
	'storyboard-unpublished' => 'Diembann',
	'storyboard-published' => 'Embannet',
	'storyboard-hidden' => 'Kuzhet',
	'storyboard-unpublish' => 'Diembann',
	'storyboard-publish' => 'Embann',
	'storyboard-hide' => 'Kuzhat',
	'storyboard-option-unpublished' => 'Diembann',
	'storyboard-option-published' => 'embannet',
	'storyboard-option-hidden' => 'kuzhet',
	'story' => 'Istor',
	'storyboard-submittedbyon' => "Kinniget gant $1 d'an $2, $3.",
	'storyboard-viewstories' => 'Gwelet an istorioù',
	'storyboard-nosuchstory' => "N'eus ket eus an istor hoc'h eus goulennet. Marteze eo bet dilamet.",
	'storyboard-storyunpublished' => "N'eo ket bet embannet c'hoazh an istor hoc'h eus goulennet.",
	'storyboard-nostorytitle' => "Rankout a rit merkañ titl hag ID an istor hoc'h eus c'hoant da welet.",
	'storyboard-cantedit' => "N'ho peus ket ar gwirioù ret evit kemmañ istorioù.",
	'storyboard-canedit' => 'Gellout a rit [$1 kemmañ] hag embann an istor-mañ.',
	'storyboard-createdandmodified' => "Krouet d'an $1, $2 ha kemm diwezhañ d'an $3, $4",
	'storyboard-authorname' => 'Anv an oberour',
	'storyboard-authorlocation' => "Lec'hiadur an oberour",
	'storyboard-authoroccupation' => 'Oberiantiz an oberour',
	'storyboard-authoremail' => "Chomlec'h postel an oberour",
	'storyboard-thestory' => 'An istor',
	'storyboard-storystate' => 'Stad',
	'storyboard-language' => 'Yezh',
	'storyboard-storymetadata' => 'Kaset gant $1 war $2, $3.',
	'storyboard-storymetadatafrom' => "Kinniget gant $1 eus $2 d'an $3, $4.",
	'storyboard-yourname' => "Hoc'h anv (ret)",
	'storyboard-location' => "Ho lec'hiadur",
	'storyboard-occupation' => 'Ho micher',
	'storyboard-story' => 'Ho istor',
	'storyboard-photo' => "Ur poltred ouzhoc'h hoc'h eus ?
Perak chom hep rannañ anezhi ?",
	'storyboard-email' => "Ho chomlec'h postel (ret)",
	'storyboard-storytitle' => 'Un titl, berr hag evit deskrivañ (ret)',
	'storyboard-agreement' => 'Degemer a ran embann hag implij an istor-mañ dindan an aotre-implijout [http://creativecommons.org/licenses/by-sa/3.0/ Deroadenn Creative Commons/Share-Alike License].',
	'storyboard-charsleft' => '($1 arouezenn{{PLURAL:$1||}} a chom{{PLURAL:$1||}})',
	'storyboard-cannotbelonger' => '<b>$1</b> arouezenn{{PLURAL:$1||}} e re en deus ho istor !',
	'storyboard-charsneeded' => "(ezhomm 'zo $1 arouezenn ouzhpenn{{PLURAL:$1||}})",
	'storyboard-needtoagree' => 'Rankout a rit aprouiñ embannadur ho istor evit gellet kinnig anezhi.',
	'storyboard-submissioncomplete' => 'Kinnig echuet',
	'storyboard-submissionincomplete' => "C'hwitet en deus ar c'has",
	'storyboard-alreadyexists' => '"$1" a zo kemeret dija.',
	'storyboard-alreadyexistschange' => 'Kemeret eo dija "{0}", mar plij dibabit un titl disheñvel.',
	'storyboard-changetitle' => 'Kemmañ an titl.',
	'storyboard-notsubmitted' => "Ar c'hevreañ en deus c'hwitet. N'eo bet enrollet istor ebet.",
	'storyboard-charstomany' => '$1 arouezenn e re !',
	'storyboard-morecharsneeded' => "Ezhomm 'zo $1 arouezenn c'hoazh",
	'storyboard-charactersleft' => 'Chom a ra $1 arouezenn',
	'storyboard-createdsuccessfully' => 'Trugarez evit bezañ rannet ho istor ganeomp !
Studiet e vo a-benn nebeut.
Gellout a rit [$1 lenn istorioù embannet].',
	'storyboard-emailtitle' => 'Kinnig an istor graet mat',
	'storyboard-emailbody' => 'Ho istor anvet "$1" a zo bet kinniget.
Adlennet e vo ganeomp a-benn nebeut.
Gellout a rit [$2 lenn an istorioù embannet].',
	'storyreview' => 'Barnadenn an istor',
	'storyboard-deleteimage' => 'Diverkañ ar skeudenn',
	'storyboard-done' => 'Graet',
	'storyboard-working' => "Oc'h ober...",
	'storyboard-imagedeletionconfirm' => "Ha sur oc'h hoc'h eus c'hoant da zilemel ar skeudenn-mañ eus an istor da vat ?",
	'storyboard-imagedeleted' => 'Skeudenn dilamet',
	'storyboard-showimage' => 'Gwelet ar skeudenn',
	'storyboard-hideimage' => 'Kuzhat ar skeudenn',
	'storyboard-deletestory' => 'Dilemel',
	'storyboard-storydeletionconfirm' => "Ha sur oc'h hoc'h eus c'hoant da zilemel an istor-mañ da vat ?",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'storyboard-name' => 'Ploča za priče',
	'storyboard-desc' => 'Omogućava [[Special:Story|stranicu za donatore]], stranicu gdje se priče mogu [[Special:StorySubmission|poslati]] i [[Special:StoryReview|interfejs za uređivanje priča]]',
	'right-storyreview' => 'Pregledanje, uređivanje, objavljivanje i sakrivanje priča',
	'storyboard-anerroroccured' => 'Desila se greška: $1',
	'storyboard-unpublished' => 'Neobjavljeno',
	'storyboard-published' => 'Objavljeno',
	'storyboard-hidden' => 'Sakriveno',
	'storyboard-unpublish' => 'Poništi objavljivanje',
	'storyboard-publish' => 'Objavi',
	'storyboard-hide' => 'Sakrij',
	'storyboard-option-unpublished' => 'neobjavljeno',
	'storyboard-option-published' => 'objavljeno',
	'storyboard-option-hidden' => 'sakriveno',
	'story' => 'Priča',
	'storyboard-submittedbyon' => 'Poslano od strane $1 dana $2, $3.',
	'storyboard-viewstories' => 'Pogledaj priče',
	'storyboard-nosuchstory' => 'Priča koju ste zahtijevali ne postoji.
Možda je uklonjena.',
	'storyboard-storyunpublished' => 'Priča koju ste zahtijevali još nije objavljena.',
	'storyboard-nostorytitle' => 'Morate odrediti naslov ili iD priče koju želite da pogledate.',
	'storyboard-cantedit' => 'Nije Vam dopušteno da uređujete priče.',
	'storyboard-canedit' => 'Možete [$1 urediti] i objaviti ovu priču.',
	'storyboard-createdandmodified' => 'Napravljeno dana $1, $2, a posljednji put izmijenjeno $3, $4',
	'storyboard-authorname' => 'Ime autora',
	'storyboard-authorlocation' => 'Mjesto autora',
	'storyboard-authoroccupation' => 'Autorovo zanimanje',
	'storyboard-authoremail' => 'Adresa e-pošte autora',
	'storyboard-thestory' => 'Priča',
	'storyboard-storystate' => 'Status',
	'storyboard-language' => 'Jezik',
	'storyboard-story' => 'Vaša priča',
);

/** Czech (Česky) */
$messages['cs'] = array(
	'storyboard-hide' => 'Skrýt',
	'storyboard-option-hidden' => 'skrytý',
	'storyboard-language' => 'Jazyk',
	'storyboard-location' => 'Vaše poloha',
	'storyboard-done' => 'Hotovo',
	'storyboard-deletestory' => 'Odstranit',
);

/** German (Deutsch)
 * @author Kghbln
 * @author The Evil IP address
 */
$messages['de'] = array(
	'storyboard-name' => 'Schwarzes Brett für Botschaften',
	'storyboard-desc' => 'Stellt eine [[Special:Story|Anlaufstelle]] für Förderer, eine Seite auf der Botschaften [[Special:StorySubmission|eingereicht]], sowie eine Seite mit der diese [[Special:StoryReview|betreut]] werden können, zur Verfügung.',
	'right-storyreview' => 'Überprüfen, Bearbeiten, Veröffentlichen und Verbergen von Botschaften',
	'storyboard-anerroroccured' => 'Ein Fehler ist aufgetreten: $1',
	'storyboard-unpublished' => 'Unveröffentlicht',
	'storyboard-published' => 'Veröffentlicht',
	'storyboard-hidden' => 'Verborgen',
	'storyboard-unpublish' => 'Veröffentlichung zurückziehen',
	'storyboard-publish' => 'Veröffentlichen',
	'storyboard-hide' => 'Verbergen',
	'storyboard-option-unpublished' => 'Unveröffentlicht',
	'storyboard-option-published' => 'Veröffentlicht',
	'storyboard-option-hidden' => 'Verborgen',
	'story' => 'Botschaft',
	'storyboard-submittedbyon' => 'Eingereicht von $1 am $2, $3.',
	'storyboard-viewstories' => 'Botschaften lesen',
	'storyboard-nosuchstory' => 'Die Botschaft, die du aufrufen wolltest, existiert nicht. Vielleicht wurde sie gelöscht.',
	'storyboard-storyunpublished' => 'Die Botschaft, die du aufrufen wolltest, wurde bislang noch nicht veröffentlicht.',
	'storyboard-nostorytitle' => 'Du musst den Titel oder die Kennung der Botschaft angeben, die du lesen möchtest.',
	'storyboard-cantedit' => 'Du hast nicht die Berechtigung Botschaften zu bearbeiten.',
	'storyboard-canedit' => 'Du kannst diese Botschaft [$1 bearbeiten] und veröffentlichen.',
	'storyboard-createdandmodified' => 'Am $1, $2 erstellt und letztmalig am $3, $4 bearbeitet.',
	'storyboard-authorname' => 'Name des Autors',
	'storyboard-authorlocation' => 'Standort des Autors',
	'storyboard-authoroccupation' => 'Beruf des Autors',
	'storyboard-authoremail' => 'E-Mail-Adresse des Autors',
	'storyboard-thestory' => 'Die Botschaft',
	'storyboard-storystate' => 'Land',
	'storyboard-language' => 'Sprache',
	'storyboard-storymetadata' => 'Eingereicht von $1 am $2, $3.',
	'storyboard-storymetadatafrom' => 'Eingereicht von $1 aus $2 am $3, $4.',
	'storyboard-yourname' => 'Dein Name (erforderlich)',
	'storyboard-location' => 'Dein Standort',
	'storyboard-occupation' => 'Dein Beruf',
	'storyboard-story' => 'Deine Botschaft',
	'storyboard-photo' => 'Gibt es ein Foto von dir? Was spricht dagegen es zu veröffentlichen?',
	'storyboard-email' => 'Deine E-Mail-Adresse (erforderlich)',
	'storyboard-storytitle' => 'Ein kurzer, aussagekräftiger Titel (erforderlich)',
	'storyboard-agreement' => 'Ich stimme der Veröffentlichung und Nutzung dieser Botschaft unter den Bedingungen der Lizenz [http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Namensnennung-Weitergabe unter gleichen Bedingungen] zu.',
	'storyboard-charsleft' => '($1 {{PLURAL:$1|Zeichen|Zeichen}} verfügbar)',
	'storyboard-cannotbelonger' => "Deine Botschaft ist '''$1''' {{PLURAL:$1|Zeichen|Zeichen}} zu lang!",
	'storyboard-charsneeded' => '($1 {{PLURAL:$1|weiterer|weitere}} {{PLURAL:$1|Zeichen|Zeichen}} notwendig)',
	'storyboard-needtoagree' => 'Du musst der Veröffentlichung deiner Botschaft zustimmen, um sie einreichen zu können.',
	'storyboard-submissioncomplete' => 'Die Einreichung ist abgeschlossen',
	'storyboard-submissionincomplete' => 'Einreichung gescheitert',
	'storyboard-alreadyexists' => '„$1“ wird bereits verwendet.',
	'storyboard-alreadyexistschange' => '„{0}“ ist bereits vergeben. Bitte wähle einen anderen Titel.',
	'storyboard-changetitle' => 'Ändere den Titel',
	'storyboard-notsubmitted' => 'Die Authentifizierung ist fehlgeschlagen und es wurde keine Botschaft gespeichert.',
	'storyboard-charstomany' => '$1 {{PLURAL:$1|Zeichen|Zeichen}} zu lang!',
	'storyboard-morecharsneeded' => '$1 {{PLURAL:$1|Zeichen|Zeichen}} werden noch benötigt',
	'storyboard-charactersleft' => 'Noch $1 {{PLURAL:$1|Zeichen|Zeichen}} verfügbar',
	'storyboard-createdsuccessfully' => 'Vielen Dank, dass du uns deine Botschaft mitgeteilt hast! Wir werden sie in Kürze überprüfen.
Du kannst bereits veröffentlichte Botschaften [$1 hier] lesen.',
	'storyboard-emailtitle' => 'Die Einreichung deiner Botschaft war erfolgreich.',
	'storyboard-emailbody' => 'Deine Botschaft mit dem Titel „$1“ wurde erfolgreich übermittelt. Wir werden sie in Kürze überprüfen. Einstweilen kannst du [$2 hier] bereits veröffentlichte Botschaften lesen.',
	'storyreview' => 'Botschaft überprüfen',
	'storyboard-deleteimage' => 'Bild löschen',
	'storyboard-done' => 'Erledigt',
	'storyboard-working' => 'Am Verarbeiten …',
	'storyboard-imagedeletionconfirm' => 'Bist du sicher, dass du das Bild zu dieser Botschaft dauerhaft löschen möchtest?',
	'storyboard-imagedeleted' => 'Das Bild wurde gelöscht',
	'storyboard-showimage' => 'Das Bild anzeigen',
	'storyboard-hideimage' => 'Bild verbergen',
	'storyboard-deletestory' => 'Entfernen',
	'storyboard-storydeletionconfirm' => 'Bist du sicher, dass du diese Botschaft dauerhaft löschen möchtest?',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Kghbln
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'storyboard-nosuchstory' => 'Die Botschaft, die Sie aufrufen wollten, existiert nicht. Vielleicht wurde sie gelöscht.',
	'storyboard-storyunpublished' => 'Die Botschaft, die Sie aufrufen wollten, wurde bislang noch nicht veröffentlicht.',
	'storyboard-nostorytitle' => 'Sie müssen den Titel oder die Kennung der Botschaft angeben, die Sie lesen möchten.',
	'storyboard-cantedit' => 'Sie haben nicht die Berechtigung Botschaften zu bearbeiten.',
	'storyboard-canedit' => 'Sie können diese Botschaft [$1 bearbeiten] und veröffentlichen.',
	'storyboard-yourname' => 'Ihr Name (erforderlich)',
	'storyboard-location' => 'Ihr Standort',
	'storyboard-occupation' => 'Ihr Beruf',
	'storyboard-story' => 'Ihre Botschaft',
	'storyboard-photo' => 'Gibt es ein Foto von Ihnen? Was spricht dagegen es zu veröffentlichen?',
	'storyboard-email' => 'Ihre E-Mail-Adresse (erforderlich)',
	'storyboard-cannotbelonger' => "Ihre Botschaft ist '''$1''' {{PLURAL:$1|Zeichen|Zeichen}} zu lang!",
	'storyboard-needtoagree' => 'Sie müssen der Veröffentlichung Ihrer Botschaft zustimmen, um sie einreichen zu können.',
	'storyboard-alreadyexistschange' => '„{0}“ ist bereits vergeben. Bitte wählen Sie einen anderen Titel.',
	'storyboard-changetitle' => 'Ändern Sie den Titel',
	'storyboard-createdsuccessfully' => 'Vielen Dank, dass Sie uns Ihre Botschaft mitgeteilt haben! Wir werden sie in Kürze überprüfen.
Sie können bereits veröffentlichte Botschaften [$1 hier] lesen.',
	'storyboard-emailtitle' => 'Die Einreichung Ihrer Botschaft war erfolgreich.',
	'storyboard-emailbody' => 'Ihre Botschaft mit dem Titel „$1“ wurde erfolgreich übermittelt. Wir werden sie in Kürze überprüfen. Einstweilen können Sie [$2 hier] bereits veröffentlichte Botschaften lesen.',
	'storyboard-imagedeletionconfirm' => 'Sind Sie sicher, dass Sie das Bild zu dieser Botschaft dauerhaft löschen möchten?',
	'storyboard-storydeletionconfirm' => 'Sind Sie sicher, dass Sie diese Botschaft dauerhaft löschen möchten?',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'storyboard-name' => 'Storyboard',
	'storyboard-desc' => 'Bitujo [[Special:Story|bok pśidostaśa za pósćiwarjow]], bok, źož tšojenja daju se [[Special:StorySubmission|zawostajiś]] a [[Special:StoryReview|pówjerch za moderaciju tšojenjow]]',
	'right-storyreview' => 'Tšojenja pśeglědaś, wobźěłaś, wózjawiś a schowaś',
	'storyboard-anerroroccured' => 'Zmólka jo nastała: $1',
	'storyboard-unpublished' => 'Njewózjawjony',
	'storyboard-published' => 'Wózjawjony',
	'storyboard-hidden' => 'Schowany',
	'storyboard-unpublish' => 'Wózjawjenje slědk śěgnuś',
	'storyboard-publish' => 'Wózjawiś',
	'storyboard-hide' => 'Schowaś',
	'storyboard-option-unpublished' => 'njewózjawjony',
	'storyboard-option-published' => 'wózjawjony',
	'storyboard-option-hidden' => 'schowany',
	'story' => 'Tšojenje',
	'storyboard-submittedbyon' => 'Wót $1 dnja $2, $3 zawóstajony.',
	'storyboard-viewstories' => 'Tšojenja se woglědaś',
	'storyboard-nosuchstory' => 'Tšojenje, kótarež sy pominał, njeeksistěrujo.
Móžno, až jo se wótporało.',
	'storyboard-storyunpublished' => 'Tšojenje, kótarež sy pominał, hyšći njejo wózjawjone.',
	'storyboard-nostorytitle' => 'Musyśo titel abo ID tšojenja, kótarež cośo se woglědaś, pódaś.',
	'storyboard-cantedit' => 'Njesmějośo tšojenja wobźěłas.',
	'storyboard-canedit' => 'Móžośo tšojenje [$1 wobźěłaś] a wózjawiś.',
	'storyboard-createdandmodified' => 'Dnja $1, $2 napórane a dnja $3, $4 slědny raz změnjone.',
	'storyboard-authorname' => 'Mě awtora',
	'storyboard-authorlocation' => 'Městno awtora',
	'storyboard-authoroccupation' => 'Pówołanje awtora',
	'storyboard-authoremail' => 'E-mailowa adresa awtora',
	'storyboard-thestory' => 'Tšojenje',
	'storyboard-storystate' => 'Stat',
	'storyboard-language' => 'Rěc',
	'storyboard-storymetadata' => 'Wót $1 $2 dnja, $3 zawóstajeny.',
	'storyboard-storymetadatafrom' => 'Wót $1 z $2 dnja $3, $4 zawóstajeny.',
	'storyboard-yourname' => 'Wašo mě (trěbne)',
	'storyboard-location' => 'Wašo městno',
	'storyboard-occupation' => 'Wašo pówołanje',
	'storyboard-story' => 'Wašo tšojenje',
	'storyboard-photo' => 'Maśo foto wót sebje?
Cogodla  njestajaśo jo k našej dispoziciji?',
	'storyboard-email' => 'Waša e-mailowa adresa (trěbna)',
	'storyboard-storytitle' => 'Krotki, wugroniwy titel (trěbny)',
	'storyboard-agreement' => 'Zwólijom do wózjawjenja a wužywanja toś togo tšojenja pód wuměnjenjami licence [http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution/Share-Alike License].',
	'storyboard-charsleft' => '($1 {{PLURAL:$1|znamuško|znamušce|znamuška|znamuškow}} wušej)',
	'storyboard-cannotbelonger' => 'Wašo tšojenjo jo <b>$1</b> {{PLURAL:$1|znamuško|znamušce|znamuška|znamuškow}} pśedłujko!',
	'storyboard-charsneeded' => '($1 {{PLURAL:$1|dalšne znamuško trěbne|dalšnej znamušce trěbnej|dalšne znamuška trěbne|dalšnych znamuškow trěbnych}})',
	'storyboard-needtoagree' => 'Musyśo do wózjawjenja swójogo tšojenja zwóliś, aby wy jo zapódał.',
	'storyboard-submissioncomplete' => 'Zapódaśe dopołne',
	'storyboard-submissionincomplete' => 'Zapódaśe jo se njeraźiło',
	'storyboard-alreadyexists' => '"$1" južo eksistěrujo.',
	'storyboard-alreadyexistschange' => '"{0}" južo eksistěrujo, pšosym wubjeŕśo drugi titel.',
	'storyboard-changetitle' => 'Titel změniś.',
	'storyboard-notsubmitted' => 'Awtentifikacija jo se njeraźiła, žedno tšojenje jo se składowało.',
	'storyboard-charstomany' => '$1 {{PLURAL:$1|znamuško|znamušce|znamuška|znamuškow}} pśedłujko!',
	'storyboard-morecharsneeded' => '$1 {{PLURAL:$1|dalšne znamuško trěbne|dalšnej znamušce trěbnej|dalšne znamuška trěbne|dalšnych znamuškow trěbnych}}',
	'storyboard-charactersleft' => 'Hyšći $1 {{PLURAL:$1|znamuško|znamušce|znamuška|znamuškow}} k dispoziciji',
	'storyboard-createdsuccessfully' => 'Źěkujomy se wam, až sćo nam swójo tšojenje k dispoziciji stajił!
Buźomy se skóro pśeglědowaś.
Móžośo [$1 wózjawjone tšojenja cytaś].',
	'storyboard-emailtitle' => 'Zawóstajenje tšojenja wuspěšne',
	'storyboard-emailbody' => 'Twójo tšojenje z titelom "$1" jo se wuspěšnje zawóstajiło. Buźomy jo skóro pśeglědowaś. Móžoš [$2 wózjawjone tšojenja cytaś].',
	'storyreview' => 'Pśeglědanje tšojenja',
	'storyboard-deleteimage' => 'Wobraz wulašowaś',
	'storyboard-done' => 'Cynjony',
	'storyboard-working' => 'Źěła se...',
	'storyboard-imagedeletionconfirm' => 'Cośo napšawdu wobraz toś togo tšojenja na pśecej lašowaś?',
	'storyboard-imagedeleted' => 'Wobraz wulašowany',
	'storyboard-showimage' => 'Wobraz pokazaś',
	'storyboard-hideimage' => 'Wobraz schowaś',
	'storyboard-deletestory' => 'Wótpóraś',
	'storyboard-storydeletionconfirm' => 'Cośo napšawdu toś to tšojenje na pśecej wulašowaś?',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'storyboard-unpublished' => 'Nepublikigita',
	'storyboard-published' => 'Publikigita',
	'storyboard-hidden' => 'Kaŝita',
	'storyboard-unpublish' => 'Malpublikigi',
	'storyboard-publish' => 'Publikigi',
	'storyboard-hide' => 'Kaŝi',
	'storyboard-option-unpublished' => 'malpublikigita',
	'storyboard-option-published' => 'publikigita',
	'storyboard-option-hidden' => 'kaŝita',
	'story' => 'Historio',
	'storyboard-submittedbyon' => 'Sendita de $1 je $2, $3.',
	'storyboard-viewstories' => 'Vidi rakontojn',
	'storyboard-nosuchstory' => 'La petita rakonto ne ekzistas.
Eble ĝi estis forigita.',
	'storyboard-storyunpublished' => 'La rakonto petita ne estis ankoraŭ eldonita.',
	'storyboard-nostorytitle' => 'Vi devas specifigi la titolon aŭ identigon de la rakonto kiun vi volas vidi.',
	'storyboard-authorname' => 'Nomo de aŭtoro',
	'storyboard-authorlocation' => 'Loko de aŭtoro',
	'storyboard-authoroccupation' => 'Laboro de aŭtoro',
	'storyboard-authoremail' => 'Retadreso de aŭtoro',
	'storyboard-thestory' => 'La rakonto',
	'storyboard-storystate' => 'Ŝtato',
	'storyboard-language' => 'Lingvo',
	'storyboard-storymetadata' => 'Sendita de $1 je $2, $3.',
	'storyboard-storymetadatafrom' => 'Sendita de $1 de $2 la $3, $4.',
	'storyboard-yourname' => 'Via nomo (deviga)',
	'storyboard-location' => 'Via loko',
	'storyboard-occupation' => 'Via laboro',
	'storyboard-story' => 'Via rakonto',
	'storyboard-photo' => 'Ĉu vi havas foton de vi?
Bonvolu prezenti ĝin!',
	'storyboard-email' => 'Via retpoŝtadreso (deviga)',
	'storyboard-storytitle' => 'Mallonga, priskribema titolo (deviga)',
	'storyboard-agreement' => 'Mi konsentas la publikigado kaj uzado de ĉi tiu rakonto sub la kondiĉoj de la [http://creativecommons.org/licenses/by-sa/3.0/deed.eo Creative Commons Permesilo Atribuite-Samkondiĉe].',
	'storyboard-charsleft' => '($1 {{PLURAL:$1|signo|signoj}} plu permesita)',
	'storyboard-cannotbelonger' => 'Via rakonto estas <b>$1</b> {{PLURAL:$1|signo|signoj}} tro longa!',
	'storyboard-charsneeded' => '($1 plu {{PLURAL:$1|bezona signo|bezonaj signoj}})',
	'storyboard-needtoagree' => 'Vi devas konsenti al la publikigado de via rakonto por sendi ĝin.',
	'storyboard-submissioncomplete' => 'Sendado finiĝis.',
	'storyboard-submissionincomplete' => 'Sendado malsukcesis',
	'storyboard-alreadyexists' => '"$1" jam estas prenita.',
	'storyboard-alreadyexistschange' => '"{0}" jam estas uzita, bonvolu elekti malsaman titolon.',
	'storyboard-changetitle' => 'Ŝanĝi la titolon.',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Locos epraix
 * @author Mor
 * @author Tempestas
 */
$messages['es'] = array(
	'storyboard-name' => 'Panel histórico',
	'storyboard-desc' => 'Proporciona una [[Special:Story|Página de destino para los donantes]], una página donde las historias pueden ser [[Special:StorySubmission|presentadas]] y un [[Special:StoryReview|historia de la moderación de la interfaz]]',
	'right-storyreview' => 'Revisar, editar, publicar y ocultar historias',
	'storyboard-anerroroccured' => 'Ocurrió un error: $1',
	'storyboard-unpublished' => 'Inédito',
	'storyboard-published' => 'Publicado',
	'storyboard-hidden' => 'Oculto',
	'storyboard-unpublish' => 'No publicar',
	'storyboard-publish' => 'Publicar',
	'storyboard-hide' => 'Ocultar',
	'storyboard-option-unpublished' => 'Sin publicar',
	'storyboard-option-published' => 'Publicado',
	'storyboard-option-hidden' => 'Oculto',
	'story' => 'Historia',
	'storyboard-submittedbyon' => 'Enviado por $1 en $2, $3.',
	'storyboard-viewstories' => 'Ver historias.',
	'storyboard-nosuchstory' => 'La historia solicitada no existe.
Puede haber sido eliminada.',
	'storyboard-storyunpublished' => 'La historia solicitada aún no ha sido publicada.',
	'storyboard-nostorytitle' => 'Necesita especificar el titulo o la ID de la historia que desea ver.',
	'storyboard-cantedit' => 'No tiene permiso para editar historias.',
	'storyboard-canedit' => 'Puede [$1 editar] y publicar esta historia.',
	'storyboard-createdandmodified' => 'Creado en $1, $2 y última modificación en $3, $4',
	'storyboard-authorname' => 'Nombre de autor',
	'storyboard-authorlocation' => 'Ubicación de autor',
	'storyboard-authoroccupation' => 'Ocupación de autor',
	'storyboard-authoremail' => 'Dirección de correo electrónico de autor',
	'storyboard-thestory' => 'La historia',
	'storyboard-storystate' => 'Estado',
	'storyboard-language' => 'Idioma',
	'storyboard-storymetadata' => 'Enviado por $1 en $2, $3.',
	'storyboard-storymetadatafrom' => 'Enviada por $1 de $2 el $3, $4.',
	'storyboard-yourname' => 'Tu nombre (requerido)',
	'storyboard-location' => 'Tu ubicación',
	'storyboard-occupation' => 'Tu ocupación',
	'storyboard-story' => 'Su historia.',
	'storyboard-photo' => '¿Tiene una foto propia?
¿Por qué no compartirla?',
	'storyboard-email' => 'Tu dirección de correo electrónico (requerido)',
	'storyboard-storytitle' => 'Un título corto y descriptivo (requerido)',
	'storyboard-agreement' => 'Estoy de acuerdo con la publicación y el uso de esta historia bajo los términos de la licencia [http://creativecommons.org/licenses/by-sa/3.0/deed.es Creative Commons Atribución/Compartir-Igual].',
	'storyboard-charsleft' => '({{PLURAL:$1|queda un carácter|quedan $1 caracteres}})',
	'storyboard-cannotbelonger' => 'Su historia es <b>$1</b> {{PLURAL:$1|carácter|caracteres}} ¡demasiado largo!',
	'storyboard-charsneeded' => '({{PLURAL:$1|se necesita un carácter más|se necesitan $1 caracteres más}})',
	'storyboard-needtoagree' => 'Necesita llegar a un acuerdo para la publicación de la presentación de su historia.',
	'storyboard-submissioncomplete' => 'Presentación completada.',
	'storyboard-submissionincomplete' => 'Envío fracasó',
	'storyboard-alreadyexists' => '"$1" ya está tomada.',
	'storyboard-alreadyexistschange' => '"{0}" ya está usada, por favor escoger un título diferente.',
	'storyboard-changetitle' => 'Cambiar el título.',
	'storyboard-notsubmitted' => 'Error de autenticación, ninguna historia ha sido grabada.',
	'storyboard-charstomany' => '$1 caracteres demasiado!',
	'storyboard-morecharsneeded' => 'son necesarios $1 caracteres más',
	'storyboard-charactersleft' => '$1 caracteres restantes',
	'storyboard-createdsuccessfully' => '¡Gracias por compartir su historia con nosotros!
La revisaremos en breve.
Puede [$1 Leer historias publicadas]',
	'storyboard-emailtitle' => 'Envío de historia exitosa',
	'storyboard-emailbody' => 'Tu título de historia "$1" ha sido exitosamente enviado. Lo revisaremos prontamente. Puedes [$2 leer historias publicadas].',
	'storyreview' => 'Revisión de historia',
	'storyboard-deleteimage' => 'Borrar imagen',
	'storyboard-done' => 'Hecho',
	'storyboard-working' => 'Procesando...',
	'storyboard-imagedeletionconfirm' => 'Estás seguro de querer borrar permanentemente esta imagen de la historia?',
	'storyboard-imagedeleted' => 'Imagen borrada',
	'storyboard-showimage' => 'Mostrar imagen',
	'storyboard-hideimage' => 'Ocultar imagen',
	'storyboard-deletestory' => 'Quitar',
	'storyboard-storydeletionconfirm' => 'Estás seguro que deseas borrar permanentemente esta historia?',
);

/** Finnish (Suomi)
 * @author Centerlink
 * @author Crt
 */
$messages['fi'] = array(
	'right-storyreview' => 'Tarkistaa, muokata, julkaista ja piilotaa tarinoita',
	'storyboard-published' => 'Julkaistu',
	'storyboard-hidden' => 'Piilotettu',
	'storyboard-hide' => 'Piilota',
	'storyboard-language' => 'Kieli',
	'storyboard-done' => 'Valmis',
	'storyboard-deletestory' => 'Poista',
);

/** French (Français)
 * @author IAlex
 * @author Jean-Frédéric
 * @author Peter17
 * @author PieRRoMaN
 * @author Verdy p
 */
$messages['fr'] = array(
	'storyboard-name' => 'Storyboard',
	'storyboard-desc' => 'Fournit une [[Special:Story|page cible pour les donateurs]], une page pour [[Special:StorySubmission|proposer une histoire]], et une [[Special:StoryReview|interface de modération des histoires]]',
	'right-storyreview' => 'Relire, modifier, publier, et masquer les histoires',
	'storyboard-anerroroccured' => 'Une erreur s’est produite : $1',
	'storyboard-unpublished' => 'Non publié',
	'storyboard-published' => 'Publié',
	'storyboard-hidden' => 'Masqué',
	'storyboard-unpublish' => 'Dépublier',
	'storyboard-publish' => 'Publier',
	'storyboard-hide' => 'Masquer',
	'storyboard-option-unpublished' => 'non publié',
	'storyboard-option-published' => 'publié',
	'storyboard-option-hidden' => 'caché',
	'story' => 'Histoire',
	'storyboard-submittedbyon' => 'Proposée par $1 le $2, $3',
	'storyboard-viewstories' => 'Voir les histoires',
	'storyboard-nosuchstory' => 'L’histoire que vous avez demandée n’existe pas. Elle a peut-être été supprimée.',
	'storyboard-storyunpublished' => 'L’histoire que vous avez demandée n’a pas encore été publiée.',
	'storyboard-nostorytitle' => 'Vous devez indiquer le titre ou l’identifiant de l’histoire que vous voulez afficher.',
	'storyboard-cantedit' => 'Vous n’avez pas les droits pour modifier des histoires.',
	'storyboard-canedit' => 'Vous pouvez [$1 modifier] et publier cette histoire.',
	'storyboard-createdandmodified' => 'Créée le $1, $2 et dernière modification le $3, $4',
	'storyboard-authorname' => 'Nom de l’auteur',
	'storyboard-authorlocation' => 'Localisation de l’auteur',
	'storyboard-authoroccupation' => 'Activité de l’auteur',
	'storyboard-authoremail' => 'Adresse de courriel de l’auteur',
	'storyboard-thestory' => 'L’histoire',
	'storyboard-storystate' => 'Statut',
	'storyboard-language' => 'Langue',
	'storyboard-storymetadata' => 'Soumis par $1 sur $2, $3.',
	'storyboard-storymetadatafrom' => 'Proposé par $1 de $2 le $3, $4.',
	'storyboard-yourname' => 'Votre nom (requis)',
	'storyboard-location' => 'Votre localisation',
	'storyboard-occupation' => 'Votre métier',
	'storyboard-story' => 'Votre histoire',
	'storyboard-photo' => 'Vous avez une photo de vous-même ? Pourquoi ne pas la partager ?',
	'storyboard-email' => 'Votre adresse électronique (requise)',
	'storyboard-storytitle' => 'Un titre court et descriptif (requis)',
	'storyboard-agreement' => 'J’accepte la publication et l’utilisation de cette histoire sous les termes de la [http://creativecommons.org/licenses/by-sa/3.0/ licence Creative Commons Paternité – Partage des conditions initiales à l’identique].',
	'storyboard-charsleft' => '($1 {{PLURAL:$1|signe|signes}} {{PLURAL:$1|restant|restants}})',
	'storyboard-cannotbelonger' => 'Votre histoire est trop longue de <b>$1</b> {{PLURAL:$1|signe|signes}} !',
	'storyboard-charsneeded' => '($1 {{PLURAL:$1|signe supplémentaire|signes supplémentaires}} requis)',
	'storyboard-needtoagree' => 'Vous devez approuver la publication de votre histoire pour pouvoir la proposer.',
	'storyboard-submissioncomplete' => 'Proposition achevée',
	'storyboard-submissionincomplete' => 'La soumission a échoué',
	'storyboard-alreadyexists' => '« $1 » est déjà pris.',
	'storyboard-alreadyexistschange' => '"{0}" est déjà pris, veuillez choisir un autre titre.',
	'storyboard-changetitle' => 'Modifier le titre.',
	'storyboard-notsubmitted' => 'L’identification a échoué. Aucune histoire n’a été enregistrée.',
	'storyboard-charstomany' => '$1 signes en trop !',
	'storyboard-morecharsneeded' => 'Encore $1 signes requis',
	'storyboard-charactersleft' => '$1 signes restants',
	'storyboard-createdsuccessfully' => 'Merci d’avoir partagé votre histoire avec nous !
Nous allons l’examiner sous peu.
Vous pouvez [$1 lire des histoires publiées].',
	'storyboard-emailtitle' => "Soumission de l'histoire réussie",
	'storyboard-emailbody' => 'Votre histoire intitulée « $1 » a été soumise avec succès. Nous allons la relire sous peu. Vous pouvez [$2 lire les histoires publiées].',
	'storyreview' => 'Critique de l’histoire',
	'storyboard-deleteimage' => 'Supprimer l’image',
	'storyboard-done' => 'Effectué',
	'storyboard-working' => 'En cours…',
	'storyboard-imagedeletionconfirm' => 'Êtes-vous sûr de vouloir supprimer définitivement l’image de cette histoire?',
	'storyboard-imagedeleted' => 'Image supprimée',
	'storyboard-showimage' => 'Voir l’image',
	'storyboard-hideimage' => 'Masquer l’image',
	'storyboard-deletestory' => 'Enlever',
	'storyboard-storydeletionconfirm' => 'Voulez-vous vraiment supprimer définitivement cette histoire ?',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'storyboard-name' => 'Storyboard',
	'right-storyreview' => 'Revêre, changiér, publeyér, et pués cachiér les histouères',
	'storyboard-anerroroccured' => 'Una èrror est arrevâ : $1',
	'storyboard-unpublished' => 'Pas publeyê',
	'storyboard-published' => 'Publeyê',
	'storyboard-hidden' => 'Cachiê',
	'storyboard-unpublish' => 'Pas publeyér',
	'storyboard-publish' => 'Publeyér',
	'storyboard-hide' => 'Cachiér',
	'storyboard-option-unpublished' => 'pas publeyê',
	'storyboard-option-published' => 'publeyê',
	'storyboard-option-hidden' => 'cachiê',
	'story' => 'Histouère',
	'storyboard-submittedbyon' => 'Proposâ per $1 lo $2, $3.',
	'storyboard-viewstories' => 'Vêre les histouères',
	'storyboard-cantedit' => 'Vos avéd pas los drêts por changiér des histouères.',
	'storyboard-canedit' => 'Vos pouede [$1 changiér] et publeyér cela histouère.',
	'storyboard-createdandmodified' => 'Fêta lo $1, $2 et dèrriér changement lo $3, $4',
	'storyboard-authorname' => 'Nom a l’ôtor',
	'storyboard-authorlocation' => 'Localisacion a l’ôtor',
	'storyboard-authoroccupation' => 'Metiér a l’ôtor',
	'storyboard-authoremail' => 'Adrèce èlèctronica a l’ôtor',
	'storyboard-thestory' => 'L’histouère',
	'storyboard-storystate' => 'Ètat',
	'storyboard-language' => 'Lengoua',
	'storyboard-storymetadata' => 'Somês per $1 lo $2, $3.',
	'storyboard-storymetadatafrom' => 'Somês per $1 de $2 lo $3, $4.',
	'storyboard-yourname' => 'Voutron nom (nècèssèro)',
	'storyboard-location' => 'Voutra localisacion',
	'storyboard-occupation' => 'Voutron metiér',
	'storyboard-story' => 'Voutra histouère',
	'storyboard-email' => 'Voutra adrèce èlèctronica (nècèssèra)',
	'storyboard-storytitle' => 'Un titro côrt et dèscriptif (nècèssèro)',
	'storyboard-charsleft' => '($1 {{PLURAL:$1|caractèro que réste|caractèros que réstont}})',
	'storyboard-submissioncomplete' => 'La somission est chavonâ',
	'storyboard-submissionincomplete' => 'La somission at pas reussia',
	'storyboard-alreadyexists' => '« $1 » est ja prês.',
	'storyboard-alreadyexistschange' => '« {0} » est ja prês, volyéd chouèsir un ôtro titro.',
	'storyboard-changetitle' => 'Changiér lo titro.',
	'storyboard-notsubmitted' => 'L’ôtentificacion at pas reussia, niona histouère at étâ encartâ.',
	'storyboard-charactersleft' => '$1 caractèros que réstont',
	'storyboard-emailtitle' => 'La somission de l’histouère at reussia',
	'storyreview' => 'Critica de l’histouère',
	'storyboard-deleteimage' => 'Suprimar l’émâge',
	'storyboard-done' => 'Fêt',
	'storyboard-working' => 'En cors...',
	'storyboard-imagedeleted' => 'Émâge suprimâ',
	'storyboard-showimage' => 'Fâre vêre l’émâge',
	'storyboard-hideimage' => 'Cachiér l’émâge',
	'storyboard-deletestory' => 'Enlevar',
);

/** Galician (Galego)
 * @author McDutchie
 * @author Tempestas
 * @author Toliño
 */
$messages['gl'] = array(
	'storyboard-name' => 'Taboleiro de historias',
	'storyboard-desc' => 'Proporciona unha [[Special:Story|páxina de chegada para os doantes]], unha páxina desde a que se poden [[Special:StorySubmission|enviar]] historias e unha [[Special:StoryReview|interface para moderar o seu envío]]',
	'right-storyreview' => 'Revisar, editar, publicar e agochar historias',
	'storyboard-anerroroccured' => 'Houbo un erro: $1',
	'storyboard-unpublished' => 'Sen publicar',
	'storyboard-published' => 'Publicada',
	'storyboard-hidden' => 'Agochada',
	'storyboard-unpublish' => 'Retirar a publicación',
	'storyboard-publish' => 'Publicar',
	'storyboard-hide' => 'Agochar',
	'storyboard-option-unpublished' => 'non publicada',
	'storyboard-option-published' => 'publicada',
	'storyboard-option-hidden' => 'agochada',
	'story' => 'Historia',
	'storyboard-submittedbyon' => 'Enviada por $1 o $2 ás $3.',
	'storyboard-viewstories' => 'Ver as historias',
	'storyboard-nosuchstory' => 'A historia solicitada non existe.
Pode ter sido eliminada.',
	'storyboard-storyunpublished' => 'A historia que solicitou aínda non foi publicada.',
	'storyboard-nostorytitle' => 'Ten que especificar o título ou o ID da historia que desexa ver.',
	'storyboard-cantedit' => 'Non ten os permisos necesarios para editar historias.',
	'storyboard-canedit' => 'Pode [$1 editar] e publicar esta historia.',
	'storyboard-createdandmodified' => 'Creada o $1 ás $2 e modificada por última vez o $3 ás $4',
	'storyboard-authorname' => 'Nome do autor',
	'storyboard-authorlocation' => 'Localización do autor',
	'storyboard-authoroccupation' => 'Profesión do autor',
	'storyboard-authoremail' => 'Enderezo de correo electrónico do autor',
	'storyboard-thestory' => 'A historia',
	'storyboard-storystate' => 'Estado',
	'storyboard-language' => 'Lingua',
	'storyboard-storymetadata' => 'Enviada por $1 o $2 ás $3.',
	'storyboard-storymetadatafrom' => 'Enviada por $1 desde $2 o $3 ás $4.',
	'storyboard-yourname' => 'O seu nome (obrigatorio)',
	'storyboard-location' => 'A súa localización',
	'storyboard-occupation' => 'A súa profesión',
	'storyboard-story' => 'A súa historia',
	'storyboard-photo' => 'Ten unha foto de si mesmo?
Por que non compartila?',
	'storyboard-email' => 'O seu enderezo de correo electrónico (obrigatorio)',
	'storyboard-storytitle' => 'Un título curto e descritivo (obrigatorio)',
	'storyboard-agreement' => 'Acepto a publicación e o uso desta historia baixo os termos da [http://creativecommons.org/licenses/by-sa/3.0/deed.gl licenza Creative Commons recoñecemento compartir igual].',
	'storyboard-charsleft' => '($1 {{PLURAL:$1|carácter restante|caracteres restantes}})',
	'storyboard-cannotbelonger' => 'A súa historia ten {{PLURAL:$1|<b>un</b> carácter|<b>$1</b> caracteres}} de máis!',
	'storyboard-charsneeded' => '({{PLURAL:$1|necesítase un carácter máis|necesítanse $1 caracteres máis}})',
	'storyboard-needtoagree' => 'Ten que estar de acordo coa publicación da súa historia para enviala.',
	'storyboard-submissioncomplete' => 'Envío completado',
	'storyboard-submissionincomplete' => 'Erro no envío',
	'storyboard-alreadyexists' => '"$1" xa existe.',
	'storyboard-alreadyexistschange' => '"{0}" xa existe. Escolla un título diferente.',
	'storyboard-changetitle' => 'Cambie o título.',
	'storyboard-notsubmitted' => 'Erro na autenticación. Non se gardou a historia.',
	'storyboard-charstomany' => 'Hai $1 caracteres de máis!',
	'storyboard-morecharsneeded' => 'Necesítanse $1 caracteres máis',
	'storyboard-charactersleft' => 'Quedan $1 caracteres',
	'storyboard-createdsuccessfully' => 'Grazas por compartir a súa historia connosco!
Analizarémola en breve.
Entrementres, pode [$1 ler outras historias publicadas].',
	'storyboard-emailtitle' => 'A historia enviouse correctamente',
	'storyboard-emailbody' => 'A súa historia, titulada "$1", enviouse correctamente.
Analizarémola en breve.
Entrementres, pode [$2 ler outras historias publicadas].',
	'storyreview' => 'Revisión da historia',
	'storyboard-deleteimage' => 'Borrar a imaxe',
	'storyboard-done' => 'Feito',
	'storyboard-working' => 'En proceso...',
	'storyboard-imagedeletionconfirm' => 'Está seguro de querer borrar permanentemente a imaxe desta historia?',
	'storyboard-imagedeleted' => 'Imaxe borrada',
	'storyboard-showimage' => 'Mostrar a imaxe',
	'storyboard-hideimage' => 'Agochar a imaxe',
	'storyboard-deletestory' => 'Eliminar',
	'storyboard-storydeletionconfirm' => 'Está seguro de querer borrar permanentemente esta historia?',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'storyboard-name' => 'Storyboard',
	'storyboard-desc' => 'Stellt e [[Special:Story|Aalaufstell]] z Verfiegig fir Ferderer, e Syte, wu Botschafte [[Special:StorySubmission|chenne yygee wäre]] un e Syte, wu die dermit chenne [[Special:StoryReview|pflägt wäre]].',
	'right-storyreview' => 'Gschichte priefe, bearbeite un uusblände',
	'storyboard-anerroroccured' => 'E Fähler isch ufträtte: $1',
	'storyboard-unpublished' => 'Uuvereffentligt',
	'storyboard-published' => 'Vereffentligt',
	'storyboard-hidden' => 'Uusbländet',
	'storyboard-unpublish' => 'Vereffetlichung zruckneh',
	'storyboard-publish' => 'Vereffetlige',
	'storyboard-hide' => 'Uusblände',
	'storyboard-option-unpublished' => 'Uuvereffentligt',
	'storyboard-option-published' => 'Vereffentligt',
	'storyboard-option-hidden' => 'Uusbländet',
	'story' => 'Botschaft',
	'storyboard-submittedbyon' => 'Yygee vu $1 am $2, $3.',
	'storyboard-viewstories' => 'Botschafte läse',
	'storyboard-nosuchstory' => 'Die Botschaft, wu Du hesch welle ufruefe, git s nit.
Villicht isch si glescht wore.',
	'storyboard-storyunpublished' => 'Die Botschaft, wu Du hesch welle ufruefe, isch nonig vereffentligt wore.',
	'storyboard-nostorytitle' => 'Du muesch dr Titel oder d ID vu dr Botschaft aagee, wu Du witt aaluege.',
	'storyboard-cantedit' => 'Du derfsch Botschafte nit bearbeite.',
	'storyboard-canedit' => 'Du chasch die Botschaft [$1 bearbeite] un vereffentlige.',
	'storyboard-createdandmodified' => 'Am $1 am $2 aagleit un s letsch Mol bearbeitet am $3 am $4.',
	'storyboard-authorname' => 'Name vum Autor',
	'storyboard-authorlocation' => 'Standort vum Autor',
	'storyboard-authoroccupation' => 'Beruef vum Autor',
	'storyboard-authoremail' => 'E-Mail-Adräss vum Autor',
	'storyboard-thestory' => 'D Botschaft',
	'storyboard-storystate' => 'Land',
	'storyboard-language' => 'Sproch',
	'storyboard-storymetadata' => 'Yygee vu $1 am $2 am $3.',
	'storyboard-storymetadatafrom' => 'Yygee vu $1 vu $2 am $3 am $4.',
	'storyboard-yourname' => 'Dyy Name (notwändig)',
	'storyboard-location' => 'Dyy Standort',
	'storyboard-occupation' => 'Dyy Beruef',
	'storyboard-story' => 'Dyy Botschaft',
	'storyboard-photo' => 'Git s e Foto vu Dir?
Witt s nit yyfiege?',
	'storyboard-email' => 'Dyy E-Mail-Adräss (notwändig)',
	'storyboard-storytitle' => 'E churze, pregnante Titel (notwändig)',
	'storyboard-agreement' => 'Ich stimm dr Vereffentlichung un Nutzig vu däre Botschaft zue unter dr Bedingige vu dr Lizänz [http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Namensnännig-Wytergabe unter glyyche Bedingige].',
	'storyboard-charsleft' => '($1 {{PLURAL:$1|Zeiche|Zeiche}} ibrig)',
	'storyboard-cannotbelonger' => "Dyy Botschaft isch '''$1''' {{PLURAL:$1|Zeiche|Zeiche}} z lang!",
	'storyboard-charsneeded' => '(No $1 {{PLURAL:$1|Zeiche|Zeiche}} notwändig)',
	'storyboard-needtoagree' => 'Du muesch dr Vereffentlichung vu Dyyre Botschaft zuestimme go si yygee chenne.',
	'storyboard-submissioncomplete' => 'Yygab fertig',
	'storyboard-submissionincomplete' => 'Yygab fähl gschlaa',
	'storyboard-alreadyexists' => '„$1“ wird scho brucht.',
	'storyboard-alreadyexistschange' => '„{0}“ isch scho vergee. Bitte wehl e andere Titel.',
	'storyboard-changetitle' => 'Titel ändere',
	'storyboard-notsubmitted' => 'D Authentifizierig isch fähl gschlaa, s isch kei Botschaft gspycheret wore.',
	'storyboard-charstomany' => '$1 Zeiche z lang!',
	'storyboard-morecharsneeded' => 'S brucht no $1 Zeiche',
	'storyboard-charactersleft' => 'No $1 Zeiche ibrig',
	'storyboard-createdsuccessfully' => 'Dankschen, ass Du is Dyy Botschaft mitteilt hesch. Mir dien si bal iberpriefe.
Du chasch [$1 vereffentligti Botschafte] läse.',
	'storyboard-emailtitle' => 'Yygab vu dr Botschaft erfolgryych',
	'storyboard-emailbody' => 'Dyy Botschaft mit em Titel „$1“ isch erfolgryych yygee wore. Mir dien si bal iberpriefe. Derwylscht chasch  [$2 vereffetligti Botschafte] läse.',
	'storyreview' => 'Botschaft iberpriefe',
	'storyboard-deleteimage' => 'Bild lesche',
	'storyboard-done' => 'Gmacht',
	'storyboard-working' => 'Am Mache …',
	'storyboard-imagedeletionconfirm' => 'Bisch sicher, ass Du des Bild zue däre Botschaft witt fir immer lesche?',
	'storyboard-imagedeleted' => 'Bild glescht',
	'storyboard-showimage' => 'Bild aazeige',
	'storyboard-hideimage' => 'Bild uusblände',
	'storyboard-deletestory' => 'Uuseneh',
	'storyboard-storydeletionconfirm' => 'Bisch sicher, ass Du die Botschaft fir immer witt lesche?',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author YaronSh
 */
$messages['he'] = array(
	'storyboard-name' => 'סיפורים',
	'storyboard-desc' => 'יצירת [[Special:Story|דף נחיתה לתורמים]], שבו אפשר [[Special:StorySubmission|לשלוח]] את סיפוריהם ו[[Special:StoryReview|ממשק סינון לסיפורים]]',
	'right-storyreview' => 'לסקור, לערוך, לפרסם ולהחביא סיפורים',
	'storyboard-anerroroccured' => 'אירעה שגיאה: $1',
	'storyboard-unpublished' => 'לא פורסם',
	'storyboard-published' => 'פורסם',
	'storyboard-hidden' => 'חבוי',
	'storyboard-unpublish' => 'לבטל פרסום',
	'storyboard-publish' => 'לפרסם',
	'storyboard-hide' => 'להחביא',
	'storyboard-option-unpublished' => 'לא פורסם',
	'storyboard-option-published' => 'פורסם',
	'storyboard-option-hidden' => 'חבוי',
	'story' => 'סיפור',
	'storyboard-submittedbyon' => 'נשלח על־ידי $1 ב־$2, $3',
	'storyboard-viewstories' => 'הצגת סיפורים',
	'storyboard-nosuchstory' => 'הסיפור שביקשתם אינו קיים.
ייתכן שהוא נמחק.',
	'storyboard-storyunpublished' => 'הסיפור שביקשתם טרם פורסם.',
	'storyboard-nostorytitle' => 'יש לציין את הכותרת או המזהה של הסיפור שאתם רוצים לראות.',
	'storyboard-cantedit' => 'אינכם מורשים לערוך סיפורים.',
	'storyboard-canedit' => 'אתם יכולים [$1 לערוך] ולפרסם את הסיפור הזה.',
	'storyboard-createdandmodified' => 'נוצר ב־$1, $2 ושונה בפעם האחרונה ב־$3, $4',
	'storyboard-authorname' => 'שם המחבר',
	'storyboard-authorlocation' => 'מיקום המחבר',
	'storyboard-authoroccupation' => 'עיסוק המחבר',
	'storyboard-authoremail' => 'כתובת הדואר האלקטרוני של המחבר',
	'storyboard-thestory' => 'הסיפור',
	'storyboard-storystate' => 'מצב',
	'storyboard-language' => 'שפה',
	'storyboard-storymetadata' => 'נשלח על־ידי $1 ב־$2, $3.',
	'storyboard-storymetadatafrom' => 'נשלח על־ידי $1 מ{{GRAMMAR:תחילית|$2}} ב־2$, $3, $4.',
	'storyboard-yourname' => 'שמך (נדרש)',
	'storyboard-location' => 'המיקום שלך',
	'storyboard-occupation' => 'העיסוק שלך',
	'storyboard-story' => 'הסיפור שלך',
	'storyboard-photo' => 'יש לך תמונה של עצמך?
למה לא לשתף אותה?',
	'storyboard-email' => 'כתובת הדואר האלקטרוני שלך (נדרש)',
	'storyboard-storytitle' => 'כותרת קצרה שמתארת את הסיפור (נדרש)',
	'storyboard-agreement' => 'אני מסכים שהסיפור יפורסם ושייעשה בו שימוש לפי התמאים של [http://creativecommons.org/licenses/by-sa/3.0/ רישיון קריאייטיב קומונז–ייחוס–שיתוף זהה].',
	'storyboard-charsleft' => '({{PLURAL:$1|תו אחד נותר|$1 תווים נותרו}})',
	'storyboard-cannotbelonger' => 'הסיפור שלך ארוך ב{{PLURAL:$1|<b>תו אחד|־<b>$1 תווים}}</b> מהנדרש!',
	'storyboard-charsneeded' => '({{PLURAL:$1|נדרש עוד תו אחד|נדרשים עוד $1 תווים}} לפחות)',
	'storyboard-needtoagree' => 'יש להסכים לפרסום הסיפור לפני שליחתו.',
	'storyboard-submissioncomplete' => 'השליחה הושלמה',
	'storyboard-submissionincomplete' => 'השליחה נכשלה',
	'storyboard-alreadyexists' => '"$1" כבר תפוס.',
	'storyboard-alreadyexistschange' => '"{0}" כבר תפוס, נא לבחור כותרת אחרת.',
	'storyboard-changetitle' => 'שינוי הכותרת.',
	'storyboard-notsubmitted' => 'האימות נכשל, הסיפור לא נשמר.',
	'storyboard-charstomany' => '{{PLURAL:$1|תו אחד|$1 תווים}} יותר מדי!',
	'storyboard-morecharsneeded' => '{{PLURAL:$1|נדרש עוד תו אחד|נדרשים עוד $1 תווים}}',
	'storyboard-charactersleft' => '{{PLURAL:$1|נותר תו אחד|נותרו $1 תווים}}',
	'storyboard-createdsuccessfully' => 'תודה על שיתוף הסיפור שלך אתנו!
אנחנו נסקור אותו בקרוב.
אפשר [$1 לקרוא את הסיפורים שכבר פורסמו].',
	'storyboard-emailtitle' => 'שליחת הסיפור הצליחה',
	'storyboard-emailbody' => 'הסיפור שלכם "$1" השלח בהצלחה.
אנחנו נסקור אותו בקרוב.
אפשר [$2 לקרוא את הסיפורים שכבר פורסמו].',
	'storyreview' => 'סקירת סיפור',
	'storyboard-deleteimage' => 'מחיקת תמונה',
	'storyboard-done' => 'בוצע',
	'storyboard-working' => 'בעבודה...',
	'storyboard-imagedeletionconfirm' => 'האם אתם בטוחים שאתם רוצים למחוק את התמונה של הסיפור הזה?',
	'storyboard-imagedeleted' => 'התמונה נמחקה',
	'storyboard-showimage' => 'הצגת תמונה',
	'storyboard-hideimage' => 'הסתרת התמונה',
	'storyboard-deletestory' => 'הסרה',
	'storyboard-storydeletionconfirm' => 'האם אתם בטוחים שאתם רוצים למחוק את הסיפור הזה?',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'storyboard-name' => 'Storyboard',
	'storyboard-desc' => 'Skića [[Special:Story|přichadnu stronu za darićelow]], strona, hdźež so hodźa powědančka [[Special:StorySubmission|zawostajić]] a [[Special:StoryReview|powjerch za moderaciju powědančkow]]',
	'right-storyreview' => 'Powědančka přehladać, wobdźěłać, wozjewić a schować',
	'storyboard-anerroroccured' => 'Zmylk je wustupił: $1',
	'storyboard-unpublished' => 'Njewozjewjena',
	'storyboard-published' => 'Wozjewjeny',
	'storyboard-hidden' => 'Schowany',
	'storyboard-unpublish' => 'Wozjewjenje cofnyć',
	'storyboard-publish' => 'Wozjewić',
	'storyboard-hide' => 'Schować',
	'storyboard-option-unpublished' => 'njewozjewjeny',
	'storyboard-option-published' => 'wozjewjeny',
	'storyboard-option-hidden' => 'schowany',
	'story' => 'Powědančko',
	'storyboard-submittedbyon' => 'Zawostajene wot $1 dnja $2, $3.',
	'storyboard-viewstories' => 'Powědančka pokazać',
	'storyboard-nosuchstory' => 'Powědančko, kotrež sće požadał, njeeksistuje.
Móžno, zo je so wotstroniło.',
	'storyboard-storyunpublished' => 'Powědančko, kotrež sće požadał, hišće njeje wozjewjene.',
	'storyboard-nostorytitle' => 'Dyrbiće titul abo ID powědančka podać, kotrež chceće sej wobhladać.',
	'storyboard-cantedit' => 'Njesměće powědančka wobdźěłać.',
	'storyboard-canedit' => 'Móžeće tute pwědančko [$1 wobdźěłać] a wozjewić.',
	'storyboard-createdandmodified' => 'Dnja $1, $2 wutworjene a dnja $3, $4 posledni raz změnjene',
	'storyboard-authorname' => 'Mjeno awtora',
	'storyboard-authorlocation' => 'Městno awtora',
	'storyboard-authoroccupation' => 'Powołanje awtora',
	'storyboard-authoremail' => 'E-mejlowa adresa awtora',
	'storyboard-thestory' => 'Powědančko',
	'storyboard-storystate' => 'Stat',
	'storyboard-language' => 'Rěč',
	'storyboard-storymetadata' => 'Wot $1 dnja $2, $3 zawostajeny.',
	'storyboard-storymetadatafrom' => 'Wot $1 z $2 dnja $3, $4 zawostajeny.',
	'storyboard-yourname' => 'Waše mjeno (trěbne)',
	'storyboard-location' => 'Waše městno',
	'storyboard-occupation' => 'Waše powołanje',
	'storyboard-story' => 'Waše powědančko',
	'storyboard-photo' => 'Maće foto wot sebje?
Čehodla njedaće druhich na njo dźěl měć?',
	'storyboard-email' => 'Twoja e-mejlowa adresa (trěbna)',
	'storyboard-storytitle' => 'Krótki, wuprajiwy titul (trěbny)',
	'storyboard-agreement' => 'Zwolim do wozjewjenja a wužiwanja tutoho powědančka pod wuměnjenjemi licency [http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution/Share-Alike License].',
	'storyboard-charsleft' => '($1 {{PLURAL:$1|znamješko|znamješce|znamješka|znamješkow}} wyše)',
	'storyboard-cannotbelonger' => 'Waše powědančko je <b>$1</b> {{PLURAL:$1|znamješko|znamješce|znamješka|znamješkow}} předołho!',
	'storyboard-charsneeded' => '($1 {{PLURAL:$1|dalše znamješko trěbne|dalšej znamješce trěbnej|dalše znamješka trěbne|dalšich znamješkow trěbnych}})',
	'storyboard-needtoagree' => 'Dyrbiće do wozjewjenja wašeho powědančka zwolić, zo byšće jo zapodał.',
	'storyboard-submissioncomplete' => 'Zapodaće dospołne',
	'storyboard-submissionincomplete' => 'Zapodaće je so njeporadźiło',
	'storyboard-alreadyexists' => '"$1" hižo eksistuje.',
	'storyboard-alreadyexistschange' => '"{0}" hižo eksistuje, prošu wubjerće druhi titul.',
	'storyboard-changetitle' => 'Titul změnić.',
	'storyboard-notsubmitted' => 'Awtentifikacija je so njeporadźiła, žane powědančko je so składowało.',
	'storyboard-charstomany' => '$1 {{PLURAL:$1|znamješko|znamješce|znamješka|znamješkow}} předołhi!',
	'storyboard-morecharsneeded' => '$1 {{PLURAL:$1|dalše znameško trěbne|dalšej znamješce trěbnej|dalše znamješka trěbne|dalšich znamješkow trěbnych}}',
	'storyboard-charactersleft' => 'Hišće $1 {{PLURAL:$1|znamješko|znamješce|znamješka|znamješkow}} k dispoziciji',
	'storyboard-createdsuccessfully' => 'Dźakujemy so wam, zo sće swoje powědančko nam k dispoziciji stajił!
Budźemy jo bórze přepruwować.
Móžeće [$1 wozjewjene powědančka čitać].',
	'storyboard-emailtitle' => 'Zawostajenje powědančka wuspěšne',
	'storyboard-emailbody' => 'Waše powědančko z titulom "$1" je so wuspěšnje zawostajiło. Budźemy jo bórze pruwować.  Móžeće [$2 wozjewjene powědančka čitać].',
	'storyreview' => 'Přepruwowanje powědančka',
	'storyboard-deleteimage' => 'Wobraz zhašeć',
	'storyboard-done' => 'Sčinjeny',
	'storyboard-working' => 'Dźěła...',
	'storyboard-imagedeletionconfirm' => 'Chceće woprawdźe wobraz tutoho powědančka na přeco hašeć?',
	'storyboard-imagedeleted' => 'Wobraz zhašeny',
	'storyboard-showimage' => 'Wobraz pokazać',
	'storyboard-hideimage' => 'Wobraz schować',
	'storyboard-deletestory' => 'Wotstronić',
	'storyboard-storydeletionconfirm' => 'Chceće woprawdźe tute powědančko na přeco zhašeć?',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'storyboard-anerroroccured' => 'Hiba történt: $1',
	'storyboard-unpublished' => 'Nincs közzétéve',
	'storyboard-published' => 'Közzétéve',
	'storyboard-hidden' => 'Rejtett',
	'storyboard-unpublish' => 'Közzététel visszavonása',
	'storyboard-publish' => 'Közzététel',
	'storyboard-hide' => 'Elrejtés',
	'storyboard-option-unpublished' => 'nincs közzétéve',
	'storyboard-option-published' => 'közzétéve',
	'storyboard-option-hidden' => 'elrejtve',
	'story' => 'Történet',
	'storyboard-viewstories' => 'Történetek megtekintése',
	'storyboard-authorname' => 'Szerző neve',
	'storyboard-authoroccupation' => 'Szerző foglalkozása',
	'storyboard-authoremail' => 'Szerző e-mail címe',
	'storyboard-thestory' => 'A történet',
	'storyboard-storystate' => 'Megye/állam',
	'storyboard-language' => 'Nyelv',
	'storyboard-yourname' => 'A neved (kötelező)',
	'storyboard-occupation' => 'A foglalkozásod',
	'storyboard-story' => 'A történeted',
	'storyboard-email' => 'Az email címed (kötelező)',
	'storyboard-storytitle' => 'Egy rövid, beszédes cím (kötelező)',
	'storyboard-charsleft' => '({{PLURAL:$1|egy|$1}} karakter maradt)',
	'storyboard-cannotbelonger' => 'A történeted túl hosszú, <b>{{PLURAL:$1|egy|$1}}</b> karakteres!',
	'storyboard-charsneeded' => '({{PLURAL:$1|$1|egy}} karakter kell még)',
	'storyboard-submissioncomplete' => 'A beküldés kész',
	'storyboard-submissionincomplete' => 'A beküldés meghiúsult',
	'storyboard-alreadyexists' => 'A(z) „$1” már foglalt',
	'storyboard-changetitle' => 'Cím megváltoztatása.',
	'storyboard-notsubmitted' => 'A hitelesítés nem sikerült, a történet nem lett elmentve.',
	'storyboard-charstomany' => '$1 karakterrel több, mint lehetne!',
	'storyboard-morecharsneeded' => 'még $1 karakter szükséges',
	'storyboard-charactersleft' => '$1 karakter maradt',
	'storyboard-emailtitle' => 'Történet beküldése sikerült',
	'storyreview' => 'Történet ellenőrzése',
	'storyboard-deleteimage' => 'Kép törlése',
	'storyboard-done' => 'Kész',
	'storyboard-working' => 'Feldolgozás…',
	'storyboard-imagedeleted' => 'Kép törölve',
	'storyboard-showimage' => 'Kép megjelenítése',
	'storyboard-hideimage' => 'Kép elrejtése',
	'storyboard-deletestory' => 'Eltávolítás',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'storyboard-name' => 'Storyboard',
	'storyboard-desc' => 'Provide un [[Special:Story|pagina de arrivata pro donatores]], un pagina ubi historias pote esser [[Special:StorySubmission|submittite]] e un [[Special:StoryReview|interfacie pro moderation de historias]].',
	'right-storyreview' => 'Revider, modificar, publicar e celar historias',
	'storyboard-anerroroccured' => 'Un error ha occurrite: $1',
	'storyboard-unpublished' => 'Non publicate',
	'storyboard-published' => 'Publicate',
	'storyboard-hidden' => 'Celate',
	'storyboard-unpublish' => 'Dispublicar',
	'storyboard-publish' => 'Publicar',
	'storyboard-hide' => 'Celar',
	'storyboard-option-unpublished' => 'non publicate',
	'storyboard-option-published' => 'publicate',
	'storyboard-option-hidden' => 'celate',
	'story' => 'Historia',
	'storyboard-submittedbyon' => 'Submittite per $1 le $2 a $3.',
	'storyboard-viewstories' => 'Vider historias',
	'storyboard-nosuchstory' => 'Le historia que tu ha demandate non existe.
Illo pote haber essite removite.',
	'storyboard-storyunpublished' => 'Le historia que tu ha demandate non ha ancora essite publicate.',
	'storyboard-nostorytitle' => 'Tu debe specificar le titulo o ID del historia que tu vole vider.',
	'storyboard-cantedit' => 'Tu non ha le permission de modificar historias.',
	'storyboard-canedit' => 'Tu pote [$1 modificar] e publicar iste historia.',
	'storyboard-createdandmodified' => 'Creation: le $1 a $2; ultime modification: le $3 a $4',
	'storyboard-authorname' => 'Nomine del autor',
	'storyboard-authorlocation' => 'Loco del autor',
	'storyboard-authoroccupation' => 'Occupation del autor',
	'storyboard-authoremail' => 'Adresse de e-mail del autor',
	'storyboard-thestory' => 'Le historia',
	'storyboard-storystate' => 'Stato',
	'storyboard-language' => 'Lingua',
	'storyboard-storymetadata' => 'Submittite per $1 le $2 a $3.',
	'storyboard-storymetadatafrom' => 'Submittite per $1 ex $2 le $3 a $4.',
	'storyboard-yourname' => 'Tu nomine (obligatori)',
	'storyboard-location' => 'Tu loco',
	'storyboard-occupation' => 'Tu occupation',
	'storyboard-story' => 'Tu historia',
	'storyboard-photo' => 'Ha tu un photo de te?
Proque non facer vider lo?',
	'storyboard-email' => 'Tu adresse de e-mail (obligatori)',
	'storyboard-storytitle' => 'Un titulo curte e descriptive (obligatori)',
	'storyboard-agreement' => 'Io accepta le publication e le uso de iste historia sub le conditiones del [http://creativecommons.org/licenses/by-sa/3.0/ licentia Creative Commons Attribution/Share-Alike].',
	'storyboard-charsleft' => '($1 {{PLURAL:$1|character|characteres}} restante)',
	'storyboard-cannotbelonger' => 'Tu historia es troppo longe de <b>$1</b> {{PLURAL:$1|character|characteres}}!',
	'storyboard-charsneeded' => '($1 plus {{PLURAL:$1|character|characteres}} necessari)',
	'storyboard-needtoagree' => 'Tu debe approbar le publication de tu historia pro submitter lo.',
	'storyboard-submissioncomplete' => 'Submission complete',
	'storyboard-submissionincomplete' => 'Submission fallite',
	'storyboard-alreadyexists' => '"$1" es ja in uso.',
	'storyboard-alreadyexistschange' => '"{0}" es ja in uso, per favor selige un altere titulo.',
	'storyboard-changetitle' => 'Cambia le titulo.',
	'storyboard-notsubmitted' => 'Authentication fallite, nulle historia ha essite salveguardate.',
	'storyboard-charstomany' => '$1 characteres in excesso!',
	'storyboard-morecharsneeded' => '$1 plus characteres necessari',
	'storyboard-charactersleft' => '$1 characteres resta disponibile',
	'storyboard-createdsuccessfully' => 'Gratias pro partir tu historia con nos!
Nos lo revidera tosto.
Tu pote [$1 leger le historias ja publicate].',
	'storyboard-emailtitle' => 'Historia submittite con successo',
	'storyboard-emailbody' => 'Vostre historia titulate "$1" ha essite submittite con successo.
Nos lo revidera tosto.
Tu pote [$2 leger le historias ja publicate].',
	'storyreview' => 'Revision del historia',
	'storyboard-deleteimage' => 'Deler imagine',
	'storyboard-done' => 'Finite',
	'storyboard-working' => 'In processo...',
	'storyboard-imagedeletionconfirm' => 'Es tu secur de voler deler permanentemente le imagine de iste historia?',
	'storyboard-imagedeleted' => 'Imagine delite',
	'storyboard-showimage' => 'Monstrar imagine',
	'storyboard-hideimage' => 'Celar imagine',
	'storyboard-deletestory' => 'Remover',
	'storyboard-storydeletionconfirm' => 'Es tu secur de voler deler iste historia permanentemente?',
);

/** Indonesian (Bahasa Indonesia)
 * @author Farras
 * @author Kenrick95
 */
$messages['id'] = array(
	'storyboard-name' => 'Papan cerita',
	'storyboard-desc' => 'Menyediakan sebuah [[Special:Story|halaman utama untuk penyumbang]], yaitu halaman tempat cerita dapat [[Special:StorySubmission|dikirim]] dan sebuah [[Special:StoryReview|antarmuka moderasi cerita]]',
	'right-storyreview' => 'Tinjau, sunting, terbitkan, dan sembunyikan cerita',
	'storyboard-anerroroccured' => 'Kesalahan terjadi: $1.',
	'storyboard-unpublished' => 'Belum Diterbitkan',
	'storyboard-published' => 'Diterbitkan',
	'storyboard-hidden' => 'Tersembunyi',
	'storyboard-unpublish' => 'Jangan terbitkan',
	'storyboard-publish' => 'Terbitkan',
	'storyboard-hide' => 'Sembunyikan',
	'storyboard-option-unpublished' => 'belum diterbitkan',
	'storyboard-option-published' => 'diterbitkan',
	'storyboard-option-hidden' => 'tersembunyi',
	'story' => 'Cerita',
	'storyboard-submittedbyon' => 'Dikirim oleh $1 pada $2, $3.',
	'storyboard-viewstories' => 'Lihat cerita',
	'storyboard-nosuchstory' => 'Cerita yang Anda minta tidak ditemukan.
Cerita itu mungkin telah dihapus.',
	'storyboard-storyunpublished' => 'Cerita yang Anda minta belum diterbitkan.',
	'storyboard-nostorytitle' => 'Anda perlu menyebutkan judul atau ID cerita yang ingin Anda lihat.',
	'storyboard-cantedit' => 'Anda tidak diizinkan untuk menyunting cerita.',
	'storyboard-canedit' => 'Anda dapat [$1 menyunting] dan menerbitkan cerita ini.',
	'storyboard-createdandmodified' => 'Dibuat pada $1, $2 dan terakhir diubah pada $3, $4',
	'storyboard-authorname' => 'Nama penulis',
	'storyboard-authorlocation' => 'Lokasi penulis',
	'storyboard-authoroccupation' => 'Pekerjaan penulis',
	'storyboard-authoremail' => 'Alamat surel penulis',
	'storyboard-thestory' => 'Cerita',
	'storyboard-storystate' => 'Keadaan',
	'storyboard-language' => 'Bahasa',
	'storyboard-storymetadata' => 'Dikirim oleh $1 pada $2, $3.',
	'storyboard-storymetadatafrom' => 'Dikirim oleh $1 dari $2 pada $3, $4.',
	'storyboard-yourname' => 'Nama Anda (dibutuhkan)',
	'storyboard-location' => 'Lokasi Anda',
	'storyboard-occupation' => 'Pekerjaan Anda',
	'storyboard-story' => 'Cerita Anda',
	'storyboard-photo' => 'Punya foto pribadi?
Berbagilah dengan kami.',
	'storyboard-email' => 'Alamat surel Anda (dibutuhkan)',
	'storyboard-storytitle' => 'Judul deskriptif pendek (dibutuhkan)',
	'storyboard-agreement' => 'Saya menyetujui penerbitan dan penggunaan cerita ini di bawah persyaratan [http://creativecommons.org/licenses/by-sa/3.0/ Lisensi Creative Commons Atribusi/BerbagiSerupa].',
	'storyboard-charsleft' => '($1 {{PLURAL:$1|karakter|karakter}} tersisa)',
	'storyboard-cannotbelonger' => 'Cerita Anda <b>$1</b> {{PLURAL:$1|karakter|karakter|}} lebih panjang!',
	'storyboard-charsneeded' => '($1 {{PLURAL:$1|karakter|karakter}} dibutuhkan)',
	'storyboard-needtoagree' => 'Anda perlu menyetujui penerbitan cerita Anda agar bisa mengirimkannya.',
	'storyboard-submissioncomplete' => 'Pengiriman selesai',
	'storyboard-submissionincomplete' => 'Pengiriman gagal',
	'storyboard-alreadyexists' => '"$1" telah digunakan.',
	'storyboard-alreadyexistschange' => '"{0}" telah digunakan, mohon pilih judul yang lain.',
	'storyboard-changetitle' => 'Ganti judul.',
	'storyboard-notsubmitted' => 'Otentikasi gagal, cerita tidak disimpan.',
	'storyboard-charstomany' => '$1 karakter lebih banyak!',
	'storyboard-morecharsneeded' => '$1 karakter dibutuhkan',
	'storyboard-charactersleft' => '$1 karakter tersisa',
	'storyboard-createdsuccessfully' => 'Terima kasih telah berbagi cerita dengan kami!
Kami segera meninjaunya.
Anda dapat [$1 membaca cerita yang telah diterbitkan].',
	'storyboard-emailtitle' => 'Pengiriman cerita berhasil',
	'storyboard-emailbody' => 'Cerita Anda yang berjudul "$1" berhasil dikirim.
Kami segera meninjaunya.
Anda dapat [$2 membaca cerita yang telah diterbitkan].',
	'storyreview' => 'Tinjauan cerita',
	'storyboard-deleteimage' => 'Hapus gambar',
	'storyboard-done' => 'Selesai',
	'storyboard-working' => 'Bekerja...',
	'storyboard-imagedeletionconfirm' => 'Anda yakin ingin menghapus gambar cerita ini secara permanen?',
	'storyboard-imagedeleted' => 'Gambar dihapus',
	'storyboard-showimage' => 'Tampilkan gambar',
	'storyboard-hideimage' => 'Sembunyikan gambar',
	'storyboard-deletestory' => 'Hapus',
	'storyboard-storydeletionconfirm' => 'Anda yakin ingin menghapus cerita ini secara permanen?',
);

/** Igbo (Igbo) */
$messages['ig'] = array(
	'storyboard-hide' => 'Zonari',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Joe Elkins
 * @author Kanon und wikipedia
 * @author 青子守歌
 */
$messages['ja'] = array(
	'storyboard-name' => '絵コンテ',
	'storyboard-desc' => 'ストーリーの[[Special:StorySubmission|投稿]]ができる[[Special:Story|提供者のための着地ページ]]と[[Special:StoryReview|ストーリー改変インターフェース]]を準備する。',
	'right-storyreview' => '査読、編集、公開、ストーリーを非表示にする',
	'storyboard-anerroroccured' => 'エラーが発生しました：$1',
	'storyboard-unpublished' => '非公開',
	'storyboard-published' => '公開',
	'storyboard-hidden' => '非表示',
	'storyboard-unpublish' => '非公開',
	'storyboard-publish' => '公開',
	'storyboard-hide' => '非表示にする',
	'storyboard-option-unpublished' => '非公開',
	'storyboard-option-published' => '公開',
	'storyboard-option-hidden' => '非表示',
	'story' => 'ストーリー',
	'storyboard-submittedbyon' => '$1が $2$3に投稿',
	'storyboard-viewstories' => 'ストーリーを表示',
	'storyboard-nosuchstory' => 'リクエストしたストーリーは存在していません。削除されたのかもしれません。',
	'storyboard-storyunpublished' => 'リクエストしたストーリーはまだ公開されていません。',
	'storyboard-nostorytitle' => '閲覧したいストーリーのタイトルまたはIDを指定する必要があります。',
	'storyboard-cantedit' => 'ストーリーを編集する権限がありません。',
	'storyboard-canedit' => 'このストーリーを[$1 編集]および公開することができます。',
	'storyboard-createdandmodified' => '$1$2に作成、$3$4に最終更新',
	'storyboard-authorname' => '著者名',
	'storyboard-authorlocation' => '作者の住所',
	'storyboard-authoroccupation' => '作者の職業',
	'storyboard-authoremail' => '作者の電子メールアドレス',
	'storyboard-thestory' => 'ストーリー',
	'storyboard-storystate' => '状態',
	'storyboard-language' => '言語',
	'storyboard-storymetadata' => '$1が $2$3に投稿',
	'storyboard-storymetadatafrom' => '$1によって、$2から、$4の$3に送信',
	'storyboard-yourname' => 'あなたの名前（必須）',
	'storyboard-location' => 'あなたの位置',
	'storyboard-occupation' => 'あなたの職業',
	'storyboard-story' => 'あなたのストーリー',
	'storyboard-photo' => 'ご自分の写真をお持ちですか？公開してみませんか？',
	'storyboard-email' => 'あなたの電子メールアドレス（必須）',
	'storyboard-storytitle' => '短く説明的なタイトル（必須）',
	'storyboard-agreement' => '私はこのストーリーの公開と使用を[http://creativecommons.org/licenses/by-sa/3.0/deed.ja Creative Commons 表示-継承ライセンス]の条件の下に行なうことに同意します。',
	'storyboard-charsleft' => '(残り$1文字)',
	'storyboard-cannotbelonger' => 'あなたのストーリーは文字数を<b>$1</b>文字分超過しています！',
	'storyboard-charsneeded' => '($1文字不足)',
	'storyboard-needtoagree' => '投稿するにはストーリーの公開に同意する必要があります。',
	'storyboard-submissioncomplete' => '投稿完了',
	'storyboard-submissionincomplete' => '投稿失敗',
	'storyboard-alreadyexists' => '"$1"は既に使用されています。',
	'storyboard-alreadyexistschange' => '「{0}」は既に利用されています。別のタイトルを選択して下さい。',
	'storyboard-changetitle' => 'タイトルを変更。',
	'storyboard-notsubmitted' => '認証に失敗したため、ストーリーは保存されませんでした。',
	'storyboard-charstomany' => '$1 文字が多すぎます！',
	'storyboard-morecharsneeded' => '$1 文字がさらに必要です',
	'storyboard-charactersleft' => '残り$1文字',
	'storyboard-createdsuccessfully' => 'ストーリーを私たちと共有してくださってありがとうございます！すぐに評価を行なう予定です。[$1 公開されているストーリーを読む]ことができます。',
	'storyboard-emailtitle' => 'ストーリーの送信に成功',
	'storyboard-emailbody' => 'ストーリー「$1」は送信に成功しました。
すぐに確認されます。
[$2 公開されたストーリーを読む]こともできます。',
	'storyreview' => 'ストーリーの評価',
	'storyboard-deleteimage' => '画像を削除',
	'storyboard-done' => '完了',
	'storyboard-working' => '処理中...',
	'storyboard-imagedeletionconfirm' => 'このストーリーから画像を永久に削除してもよろしいですか？',
	'storyboard-imagedeleted' => '画像は削除されました',
	'storyboard-showimage' => '画像を表示する',
	'storyboard-hideimage' => '画像を隠す',
	'storyboard-deletestory' => '除去',
	'storyboard-storydeletionconfirm' => 'このストーリーを永久に削除してもよろしいですか？',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'storyboard-desc' => 'Brängg en [[Special:Story|Aanloufsigg för Jävver]] en et Wiki, woh Jescheschte [[Special:StorySubmission|enjeshtallt]] wääde künne, un en [[Special:StoryReview|Schnettshtäll för Jescheeschte ze betreue]].',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author Gomada
 */
$messages['ku-latn'] = array(
	'storyboard-authorname' => 'Navê nivîskar',
	'storyboard-authorlocation' => 'Cihê nivîskar',
	'storyboard-authoroccupation' => 'Pîşeyê nivîskar',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'storyboard-name' => 'Storyboard',
	'storyboard-desc' => 'Stellt eng [[Special:Story|Entréessäit fir Donateuren]] zur Verfügung, eng Säit wou Temoignage [[Special:StorySubmission|presentéiert]] kënne ginn, an e [[Special:StoryReview|Moderatiouns-Interface fir Temoignagen]]',
	'right-storyreview' => 'Temoignagen nokucken, änneren, publizéieren a verstoppen',
	'storyboard-anerroroccured' => 'Et ass e Feeler geschitt: $1',
	'storyboard-unpublished' => 'Net verëffentlecht',
	'storyboard-published' => 'Verëffentlecht',
	'storyboard-hidden' => 'Verstoppt',
	'storyboard-unpublish' => 'Verëffentlecung zréckzéien',
	'storyboard-publish' => 'Verëffentlechen',
	'storyboard-hide' => 'Verstoppen',
	'storyboard-option-unpublished' => 'net verëfentlecht',
	'storyboard-option-published' => 'verëffentlecht',
	'storyboard-option-hidden' => 'verstoppt',
	'story' => 'Temoignage',
	'storyboard-submittedbyon' => 'Vum $1 den $2, $3 geschéckt',
	'storyboard-viewstories' => 'Temoignage weisen',
	'storyboard-nosuchstory' => 'Den Temoignage deen Dir ugefrot hutt gëtt et net.
Et ka sinn datt en ewechgeholl gouf.',
	'storyboard-storyunpublished' => 'Den Temoignage deen Dir ugefrot hutt gouf nach net verëffentlecht.',
	'storyboard-nostorytitle' => "Dir musst den Titel oder d'ID vum Temoignage uginn dee gewise soll ginn.",
	'storyboard-cantedit' => 'Dir däerft Temoignagen net änneren.',
	'storyboard-canedit' => 'Dir kënnt dësen  Temoignage [$1 änneren] a verëffentlechen.',
	'storyboard-createdandmodified' => "Ugeluecht den $1, $2 a fir d'lescht geännert den $3, $4",
	'storyboard-authorname' => 'Numm vum Auteur',
	'storyboard-authorlocation' => 'Plaz vum Auteur',
	'storyboard-authoroccupation' => 'Beruff vum Auteur',
	'storyboard-authoremail' => 'E-Mailadress vum Auteur',
	'storyboard-thestory' => 'Den Temoignage',
	'storyboard-storystate' => 'Staat',
	'storyboard-language' => 'Sprooch',
	'storyboard-storymetadata' => 'Vum $1 den $2, $3 geschéckt',
	'storyboard-storymetadatafrom' => 'Vum $1 vun $2 den $3 ëm $4 geschéckt.',
	'storyboard-yourname' => 'Ären Numm (obligatoresch)',
	'storyboard-location' => 'Plaz wou Dir sidd',
	'storyboard-occupation' => 'Äre Beruff',
	'storyboard-story' => 'Ären Temoignage',
	'storyboard-photo' => 'Hutt dir eng Photo vun Iech?
Firwat se net hei weisen?',
	'storyboard-email' => 'Är E-Mailadress (obligatoresch)',
	'storyboard-storytitle' => 'E kuerzen Titel de beschreift wourëms et geet (obligatoresch)',
	'storyboard-agreement' => "Ech si mat der Publikatioun vun dësem Temoignage ënnert de Bedingunge vun der [http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution/Share-Alike Lizenz] d'accord.",
	'storyboard-charsleft' => '($1{{PLURAL:$1|Buschtaf|Buschtawen}} iwwreg)',
	'storyboard-cannotbelonger' => 'Ären Temoignage huet <b>$1</b> {{PLURAL:$1|Zeechen|Zeechen}} ze vill!',
	'storyboard-charsneeded' => '($1{{PLURAL:$1|Buschtaf|Buschtawen}} si gefrot )',
	'storyboard-needtoagree' => "Dir musst d'accord sinn datt Ären Temoignage verëffentlecht gëtt fir se ze schécken.",
	'storyboard-submissioncomplete' => 'Areechen ofgeschloss',
	'storyboard-submissionincomplete' => "D'Eraschécken huet net fonctionnéiert",
	'storyboard-alreadyexists' => '"$1" gëtt et schonn.',
	'storyboard-alreadyexistschange' => '"{0}" gëtt scho benotzt, sicht w.e.g. en aneren Titel.',
	'storyboard-changetitle' => 'Den Titel änneren.',
	'storyboard-notsubmitted' => "D'Authentifikatioun huet net fonctionnéiert, den Temoignage gouf net gespäichert.",
	'storyboard-charstomany' => '$1 Buschtawen ze vill!',
	'storyboard-morecharsneeded' => '$1 Buchstawe méi, gi gebraucht',
	'storyboard-charactersleft' => '$1 Buschtawen iwwreg',
	'storyboard-createdsuccessfully' => 'Merci datt dir Ären Temoignage mat eis deelt!
Mir kucken se demnächst no.
Dir kënnt [$1 publizéiert Temoignage liesen].',
	'storyboard-emailtitle' => 'Den Temoignage ass elo ofgespäichert',
	'storyboard-emailbody' => 'Ären Temoignage mam Titel "$1" gouf iwwerdro.
Mir kucken e geschwënn no.
Dir kënnt [$2 déi publizéiert Temoignage liesen].',
	'storyreview' => 'Temoignage nokucken',
	'storyboard-deleteimage' => 'Bild läschen',
	'storyboard-done' => 'Fäerdeg',
	'storyboard-working' => 'am gaang...',
	'storyboard-imagedeletionconfirm' => "Sidd Dir sécher datt Dir d'Bild vun dësem Temoignage definitiv läsche wëllt?",
	'storyboard-imagedeleted' => 'Bild geläscht',
	'storyboard-showimage' => 'Bild weisen',
	'storyboard-hideimage' => 'Bild verstoppen',
	'storyboard-deletestory' => 'Ewechhuelen',
	'storyboard-storydeletionconfirm' => 'Sidd Dir sécher datt Dir dësen Temoignage definitiv läsche wëllt?',
);

/** Latgalian (Latgaļu)
 * @author Dark Eagle
 */
$messages['ltg'] = array(
	'storyboard-hide' => 'Nūglobuot',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'storyboard-name' => 'Раскажувачница',
	'storyboard-desc' => 'Дава [[Special:Story|страница за дарителите]], кадешто можат [[Special:StorySubmission|да објават]] своја приказна, како и [[Special:StoryReview|посредник за модерација на приказните]]',
	'right-storyreview' => 'Прегледување, уредување, објавување и сокривање на приказни',
	'storyboard-anerroroccured' => 'Се појави гешка: $1',
	'storyboard-unpublished' => 'Необјавено',
	'storyboard-published' => 'Објавено',
	'storyboard-hidden' => 'Сокриено',
	'storyboard-unpublish' => 'Тргни',
	'storyboard-publish' => 'Објави',
	'storyboard-hide' => 'Скриј',
	'storyboard-option-unpublished' => 'необјавени',
	'storyboard-option-published' => 'објавени',
	'storyboard-option-hidden' => 'скриени',
	'story' => 'Приказна',
	'storyboard-submittedbyon' => 'Поднесено од $1 на $2, $3.',
	'storyboard-viewstories' => 'Преглед на приказни',
	'storyboard-nosuchstory' => 'Приказната што ја побаравте не постои.
Може да била отстранета.',
	'storyboard-storyunpublished' => 'Приказната што ја побаравте сè уште не е објавена.',
	'storyboard-nostorytitle' => 'Треба да назначите наслов или ID на приказната што сакате да ја видите.',
	'storyboard-cantedit' => 'Не ви е дозволено да ги менувате приказните.',
	'storyboard-canedit' => 'Можете да ја [$1 уредите] и објавите приказнава.',
	'storyboard-createdandmodified' => 'Создадено на $1, $2, а последно изменето на $3, $4',
	'storyboard-authorname' => 'Име на авторот',
	'storyboard-authorlocation' => 'Место на живеење на авторот',
	'storyboard-authoroccupation' => 'Занимање на авторот',
	'storyboard-authoremail' => 'Е-пошта на авторот',
	'storyboard-thestory' => 'Приказната',
	'storyboard-storystate' => 'Сојуз. држава',
	'storyboard-language' => 'Јазик',
	'storyboard-storymetadata' => 'Поднесена од $1 на $2, $3.',
	'storyboard-storymetadatafrom' => 'Поднесена од $1 од $2 на $3, $4.',
	'storyboard-yourname' => 'Вашето име (задолжително)',
	'storyboard-location' => 'Место на живеење',
	'storyboard-occupation' => 'Вашето занимање',
	'storyboard-story' => 'Вашата приказна',
	'storyboard-photo' => 'Имате ваша фотографија?
Зошто не ја споделите?',
	'storyboard-email' => 'Ваша е-пошта (задолжително)',
	'storyboard-storytitle' => 'Краток описен наслов (задолжително)',
	'storyboard-agreement' => 'Се согласувам приказнава да се објави и користи согласно условите на лиценцата [http://creativecommons.org/licenses/by-sa/3.0/deed.mk Creative Commons Наведи извор/Сподели под исти услови].',
	'storyboard-charsleft' => '({{PLURAL:$1|Ви преостанува уште|Ви преостануваат уште}} $1 {{PLURAL:$1|знак|знаци}})',
	'storyboard-cannotbelonger' => 'Вашата приказна е за <b>$1</b> {{PLURAL:$1|знак|знаци}} подолга од дозволеното!',
	'storyboard-charsneeded' => '({{PLURAL:$1|потребен е|потребни се}} уште $1 {{PLURAL:$1|знак|знаци}})',
	'storyboard-needtoagree' => 'Мора да се согласите да ја објавите приказната за да ја поднесете.',
	'storyboard-submissioncomplete' => 'Поднесувањето е завршено',
	'storyboard-submissionincomplete' => 'Поднесувањето не успеа',
	'storyboard-alreadyexists' => '„$1“ е веќе зафатено.',
	'storyboard-alreadyexistschange' => '„{0}“ е зафатено. Одберете друг наслов.',
	'storyboard-changetitle' => 'Смени наслов',
	'storyboard-notsubmitted' => 'Потврдувањето не успеа. Приказната не беше зачувана.',
	'storyboard-charstomany' => 'Имате $1 знаци над дозволеното!',
	'storyboard-morecharsneeded' => 'Се бараат уште $1 знаци',
	'storyboard-charactersleft' => 'Преостануваат уште $1 знаци',
	'storyboard-createdsuccessfully' => 'Ви благодаримне што ја споделивте Вашата приказна со нас!
Набргу ќе ја прегледаме.
Можете да ги [$1 прочитате објавените приказни].',
	'storyboard-emailtitle' => 'Поднесувањето на приказната е успешно',
	'storyboard-emailbody' => 'Вашата приказна насловена како „$1“ е успешно поднесена.
Истата ќе биде набргу прегледана.
Можете да [$2 прочитате објавени приказни].',
	'storyreview' => 'Преглед на приказна',
	'storyboard-deleteimage' => 'Избриши слика',
	'storyboard-done' => 'Готово',
	'storyboard-working' => 'Работата е во тек...',
	'storyboard-imagedeletionconfirm' => 'Дали сте сигурни дека сакате трајно да ја избришете оваа слика?',
	'storyboard-imagedeleted' => 'Сликата е избришана',
	'storyboard-showimage' => 'Прикажи слика',
	'storyboard-hideimage' => 'Скриј слика',
	'storyboard-deletestory' => 'Отстрани',
	'storyboard-storydeletionconfirm' => 'Дали сте дигурни дека сакате трајно да ја избришете приказнава?',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'storyboard-name' => 'കഥാവേദി',
	'right-storyreview' => 'കഥകൾ സംശോധനം ചെയ്യുക, തിരുത്തുക, പ്രസിദ്ധീകരിക്കുക, ഒപ്പം മറയ്ക്കുക',
	'storyboard-anerroroccured' => 'ഒരു പിഴവ് ഉണ്ടായിരിക്കുന്നു: $1',
	'storyboard-unpublished' => 'പ്രസിദ്ധീകരിക്കപ്പെടാത്തത്',
	'storyboard-published' => 'പ്രസിദ്ധീകരിച്ചത്',
	'storyboard-hidden' => 'മറയ്ക്കപ്പെട്ടവ',
	'storyboard-unpublish' => 'പ്രസിദ്ധീകരിക്കൽ ഒഴിവാക്കുക',
	'storyboard-publish' => 'പ്രസിദ്ധീകരിക്കുക',
	'storyboard-hide' => 'മറയ്ക്കുക',
	'storyboard-option-unpublished' => 'പ്രസിദ്ധീകരിക്കാത്തവ',
	'storyboard-option-published' => 'പ്രസിദ്ധീകരിച്ചവ',
	'storyboard-option-hidden' => 'മറയ്ക്കപ്പെട്ടവ',
	'story' => 'കഥ',
	'storyboard-submittedbyon' => 'സമർപ്പിച്ചത് $1, തീയതി $2, $3.',
	'storyboard-viewstories' => 'കഥകൾ കാണുക',
	'storyboard-nosuchstory' => 'താങ്കൾ ആവശ്യപ്പെട്ട കഥ നിലവിലില്ല.
അത് നീക്കം ചെയ്യപ്പെട്ടിട്ടുണ്ടാകണം.',
	'storyboard-storyunpublished' => 'താങ്കൾ ആവശ്യപ്പെട്ട കഥ ഇതുവരെ പ്രസിദ്ധീകരിച്ചിട്ടില്ല.',
	'storyboard-nostorytitle' => 'താങ്കൾക്ക് കാണേണ്ട കഥയുടെ തലക്കെട്ടോ ഐ.ഡി.യോ വ്യക്തമാക്കേണ്ടതാണ്.',
	'storyboard-cantedit' => 'കഥകൾ തിരുത്താൻ താങ്കൾക്ക് അനുവാദമില്ല.',
	'storyboard-canedit' => 'ഈ കഥ താങ്കൾക്ക് [$1 തിരുത്താവുന്നതും] പ്രസിദ്ധീകരിക്കാവുന്നതുമാണ്.',
	'storyboard-createdandmodified' => 'സൃഷ്ടിച്ചത് $1, $2 ഒടുവിൽ മാറ്റം വരുത്തിയത് $3, $4',
	'storyboard-authorname' => 'രചയിതാവിന്റെ പേര്',
	'storyboard-authorlocation' => 'രചയിതാവിന്റെ സ്ഥലം',
	'storyboard-authoroccupation' => 'രചയിതാവിന്റെ ജോലി',
	'storyboard-authoremail' => 'രചയിതാവിന്റെ ഇമെയിൽ വിലാസം',
	'storyboard-thestory' => 'കഥ',
	'storyboard-storystate' => 'സംസ്ഥാനം',
	'storyboard-language' => 'ഭാഷ',
	'storyboard-storymetadata' => 'സമർപ്പിച്ചത് $1 തീയതി $2, $3.',
	'storyboard-yourname' => 'താങ്കളുടെ പേര് (ആവശ്യമാണ്)',
	'storyboard-location' => 'താങ്കളുടെ സ്ഥലം',
	'storyboard-occupation' => 'താങ്കളുടെ ജോലി',
	'storyboard-story' => 'താങ്കളുടെ കഥ',
	'storyboard-photo' => 'താങ്കളുടെ ഒരു ഫോട്ടോ ഉണ്ടോ?
ഇവിടെ നൽകൂ?',
	'storyboard-email' => 'താങ്കളുടെ ഇമെയിൽ വിലാസം (ആവശ്യമാണ്)',
	'storyboard-storytitle' => 'ചെറുതും വിവരണാത്മകവുമായ തലക്കെട്ട് (ആവശ്യമാണ്)',
	'storyboard-agreement' => 'ഈ കഥ [http://creativecommons.org/licenses/by-sa/3.0/ ക്രിയേറ്റീവ് കോമൺസ് ആട്രിബ്യൂഷൻ/ഷെയർ-എലൈക് അനുമതി] പ്രകാരം പ്രസിദ്ധീകരിക്കാനും ഉപയോഗിക്കാനും എനിക്ക് സമ്മതമാണ്.',
	'storyboard-charsleft' => '({{PLURAL:$1|ഒരു അക്ഷരം|$1 അക്ഷരങ്ങൾ}} ബാക്കി കിടക്കുന്നു)',
	'storyboard-cannotbelonger' => 'താങ്കളുടെ കഥ {{PLURAL:$1|<b>ഒരു</b> അക്ഷരത്തിന്|<b>$1</b> അക്ഷരങ്ങൾക്ക്}} വലുതാണ്!',
	'storyboard-charsneeded' => '(കൂടുതൽ {{PLURAL:$1|ഒരു അക്ഷരം|$1 അക്ഷരങ്ങൾ}} വേണം)',
	'storyboard-needtoagree' => 'താങ്കളുടെ കഥ സമർപ്പിക്കാൻ അത് പ്രസിദ്ധീകരിക്കാനുള്ള താങ്കളുടെ സമ്മതം വേണം.',
	'storyboard-submissioncomplete' => 'സമർപ്പിക്കൽ സമ്പൂർണ്ണം',
	'storyboard-submissionincomplete' => 'സമർപ്പിക്കൽ പരാജയപ്പെട്ടു',
	'storyboard-alreadyexists' => '"$1" മുമ്പേ എടുത്തിരിക്കുന്നു.',
	'storyboard-alreadyexistschange' => '"{0}" മുമ്പേ എടുത്തിരിക്കുന്നു, ദയവായി മറ്റൊരു തലക്കെട്ട് തിരഞ്ഞെടുക്കുക.',
	'storyboard-changetitle' => 'ശീർഷകം മാറ്റുക',
	'storyboard-notsubmitted' => 'ആധികാരികതാ പരിശോധന പരാജയപ്പെട്ടു, കഥ സേവ് ചെയ്തിട്ടില്ല.',
	'storyboard-charstomany' => '$1 അക്ഷരങ്ങൾ കൂടുതലുണ്ട്!',
	'storyboard-morecharsneeded' => '$1 അക്ഷരങ്ങൾ കൂടെ വേണം',
	'storyboard-charactersleft' => '$1 അക്ഷരങ്ങൾ ബാക്കി കിടക്കുന്നു',
	'storyboard-createdsuccessfully' => 'താങ്കളുടെ കഥ പങ്ക് വെച്ചതിനു നന്ദി!
ഞങ്ങളത് ഉടനേ സംശോധനം ചെയ്യും.
താങ്കൾക്ക് [$1 പ്രസിദ്ധീകരിച്ച കഥകൾ വായിക്കാവുന്നതാണ്].',
	'storyboard-emailtitle' => 'കഥാ സമർപ്പണം വിജയകരമായി',
	'storyboard-emailbody' => '"$1" തലക്കെട്ടിലുള്ള താങ്കളുടെ കഥ വിജയകരമായി സമർപ്പിച്ചിരിക്കുന്നു.
ഞങ്ങളത് ഉടനേ സംശോധനം ചെയ്യും.
താങ്കൾക്ക് [$2 പ്രസിദ്ധീകരിച്ചിട്ടുള്ള കഥകൾ വായിക്കാവുന്നതാണ്].',
	'storyreview' => 'കഥാ സംശോധനം',
	'storyboard-deleteimage' => 'ചിത്രം മായ്ക്കുക',
	'storyboard-done' => 'ചെയ്തു കഴിഞ്ഞു.',
	'storyboard-working' => 'ശ്രമിക്കുന്നു...',
	'storyboard-imagedeletionconfirm' => 'ഈ കഥയുടെ ചിത്രം സ്ഥിരമായി മായ്ച്ചുകളയുകയാണോ വേണ്ടത്?',
	'storyboard-imagedeleted' => 'ചിത്രം മായ്ച്ചിരിക്കുന്നു',
	'storyboard-showimage' => 'ചിത്രം പ്രദർശിപ്പിക്കുക',
	'storyboard-hideimage' => 'ചിത്രം മറയ്ക്കുക',
	'storyboard-deletestory' => 'നീക്കം ചെയ്യുക',
	'storyboard-storydeletionconfirm' => 'ഈ കഥ സ്ഥിരമായി മായ്ച്ചുകളയാണോ താങ്കൾക്കാവശ്യം?',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'storyboard-language' => 'Хэл',
);

/** Marathi (मराठी)
 * @author Mahitgar
 */
$messages['mr'] = array(
	'storyboard-publish' => 'प्रकाशित करा',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'storyboard-language' => 'Bahasa',
	'storyboard-deletestory' => 'Padamkan',
);

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = array(
	'storyboard-hide' => 'Aħbi',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'storyboard-hide' => 'Кекшемс',
	'storyboard-option-hidden' => 'кекшезь',
	'storyboard-authorname' => 'Теицянь лемезэ',
	'storyboard-authorlocation' => 'Косо теицясь ашти',
	'storyboard-authoroccupation' => 'Теицясь мезесэ важоди',
	'storyboard-authoremail' => 'Теицянть е-сёрмапаргозо',
	'storyboard-thestory' => 'Ёвтнемась',
	'storyboard-language' => 'Кель',
	'storyboard-yourname' => 'Тонть леметь (эряви)',
	'storyboard-location' => 'Косо аштят',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'storyboard-anerroroccured' => 'En feil oppsto: $1',
	'storyboard-unpublished' => 'Upubliserte',
	'storyboard-published' => 'Publiserte',
	'storyboard-hidden' => 'Skjulte',
	'storyboard-unpublish' => 'Upubliser',
	'storyboard-publish' => 'Publiser',
	'storyboard-hide' => 'Skjul',
	'storyboard-option-unpublished' => 'upublisert',
	'storyboard-option-published' => 'publisert',
	'storyboard-option-hidden' => 'skjult',
	'story' => 'Historie',
	'storyboard-submittedbyon' => 'Insendt av $1 den $2, $3.',
	'storyboard-viewstories' => 'Vis historier',
	'storyboard-canedit' => 'Du kan [$1 endre] og publisere denne historien.',
	'storyboard-createdandmodified' => 'Opprettet $1, $2 og sist endret $3, $4',
	'storyboard-authorname' => 'Forfatters navn',
	'storyboard-authorlocation' => 'Forfatters plassering',
	'storyboard-authoroccupation' => 'Forfatters yrke',
	'storyboard-authoremail' => 'Forfatters e-postadresse',
	'storyboard-thestory' => 'Historien',
	'storyboard-storystate' => 'Status',
	'storyboard-language' => 'Språk',
	'storyboard-storymetadata' => 'Innsendt av $1 den $2, $3.',
	'storyboard-storymetadatafrom' => 'Innsendt av $1 fra $2 den $3, $4.',
	'storyboard-yourname' => 'Ditt navn (nødvendig)',
	'storyboard-location' => 'Din plassering',
	'storyboard-occupation' => 'Ditt yrke',
	'storyboard-story' => 'Din historie',
	'storyboard-photo' => 'Har du et bilde av degselv?
Hvorfor ikke dele det?',
	'storyboard-email' => 'Din e-postadresse (nødvendig)',
	'storyboard-storytitle' => 'En kort, beskrivende tittel (nødvendig)',
	'storyboard-agreement' => 'Jeg er enig med publiseringen og bruken av denne historien under lisensvilkårene i [http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Navngivelse-Del på samme vilkår]',
	'storyboard-charsleft' => '({{PLURAL:$1|ett|$1}} tegn igjen)',
	'storyboard-cannotbelonger' => 'Historien din er <b>$1</b> tegn for {{PLURAL:$1|langt|lang}}!',
	'storyboard-charsneeded' => '(trenger {{PLURAL:$1|ett|$1}} tegn til)',
	'storyboard-needtoagree' => 'Du må godta publiseringen av historien din for å sende den inn.',
	'storyboard-submissioncomplete' => 'Innsending fullført',
	'storyboard-submissionincomplete' => 'Innsending mislyktes',
	'storyboard-alreadyexists' => '«$1» er allerede tatt.',
	'storyboard-alreadyexistschange' => '«{0}» er allerede tatt, velg en annen tittel.',
	'storyboard-changetitle' => 'Endre tittelen.',
	'storyboard-charstomany' => '$1 tegn for mange!',
	'storyboard-morecharsneeded' => '$1 flere tegn trengs',
	'storyboard-charactersleft' => '$1 tegn igjen',
	'storyboard-deleteimage' => 'Slett bilde',
	'storyboard-done' => 'Ferdig',
	'storyboard-working' => 'Jobber...',
	'storyboard-imagedeletionconfirm' => 'Er du sikker på at du vil slette denne historiens bilde?',
	'storyboard-imagedeleted' => 'Bilde slettet',
	'storyboard-showimage' => 'Vis bilde',
	'storyboard-hideimage' => 'Skjul bilde',
	'storyboard-deletestory' => 'Fjern',
	'storyboard-storydeletionconfirm' => 'Er du sikker på at du vil slette denne historien?',
);

/** Dutch (Nederlands)
 * @author McDutchie
 * @author Siebrand
 */
$messages['nl'] = array(
	'storyboard-name' => 'Storyboard',
	'storyboard-desc' => 'Biedt een [[Special:Story|aankomstpagina voor donateurs]], een [[Special:StorySubmission|pagina waar verhalen ingezonden kunnen worden]] en een [[Special:StoryReview|interface voor beoordeling van verhalen]]',
	'right-storyreview' => 'Verhalen beoordelen, bewerken, publiceren en verbergen',
	'storyboard-anerroroccured' => 'Er is een fout opgetreden: $1',
	'storyboard-unpublished' => 'Ongepubliceerd',
	'storyboard-published' => 'Gepubliceerd',
	'storyboard-hidden' => 'Verborgen',
	'storyboard-unpublish' => 'Publicatie terugtrekken',
	'storyboard-publish' => 'Publiceren',
	'storyboard-hide' => 'Verbergen',
	'storyboard-option-unpublished' => 'ongepubliceerd',
	'storyboard-option-published' => 'gepubliceerd',
	'storyboard-option-hidden' => 'verborgen',
	'story' => 'Verhaal',
	'storyboard-submittedbyon' => 'Ingezonden door $1 op $2 om $3.',
	'storyboard-viewstories' => 'Verhalen bekijken',
	'storyboard-nosuchstory' => 'Het door u opgevraagde verhaal bestaat niet.
Mogelijk is het verwijderd.',
	'storyboard-storyunpublished' => 'Het verhaal dat u heeft opgevraagd is nog niet gepubliceerd.',
	'storyboard-nostorytitle' => 'U moet de naam of het ID van het verhaal dat u wilt bekijken opgeven.',
	'storyboard-cantedit' => 'U mag verhalen niet bewerken.',
	'storyboard-canedit' => 'U kunt dit verhaal [$1 bewerken] en publiceren.',
	'storyboard-createdandmodified' => 'Aangemaakt op $1 om $2 en voor het laatst bewerkt op $3 om $4',
	'storyboard-authorname' => 'Naam auteur',
	'storyboard-authorlocation' => 'Locatie auteur',
	'storyboard-authoroccupation' => 'Beroep auteur',
	'storyboard-authoremail' => 'E-mailadres auteur',
	'storyboard-thestory' => 'Het verhaal',
	'storyboard-storystate' => 'Status',
	'storyboard-language' => 'Taal',
	'storyboard-storymetadata' => 'Ingezonden door $1 op $2 om $3.',
	'storyboard-storymetadatafrom' => 'Ingezonden door $1 vanaf $2 op $3 om $4.',
	'storyboard-yourname' => 'Uw naam (verplicht)',
	'storyboard-location' => 'Uw locatie',
	'storyboard-occupation' => 'Uw beroep',
	'storyboard-story' => 'Uw verhaal',
	'storyboard-photo' => 'Wilt u een foto van uzelf toevoegen?',
	'storyboard-email' => 'Uw e-mailadres (verplicht)',
	'storyboard-storytitle' => 'Een korte, beschrijvende titel (verplicht)',
	'storyboard-agreement' => 'Ik ga akkoord met de publicatie van dit verhaal onder de voorwaarden van de licentie [http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Naamsvermelding-Gelijk delen].',
	'storyboard-charsleft' => '($1 {{PLURAL:$1|teken|tekens}} over)',
	'storyboard-cannotbelonger' => 'Uw verhaal is <b>$1</b> {{PLURAL:$1|teken|tekens}} te lang!',
	'storyboard-charsneeded' => '(er {{PLURAL:$1|is nog 1 teken|zijn nog $1 tekens}} meer nodig)',
	'storyboard-needtoagree' => 'U moet akkoord gaan met het publiceren van uw verhaal voordat u het kunt inzenden.',
	'storyboard-submissioncomplete' => 'Verzenden is voltooid',
	'storyboard-submissionincomplete' => 'Het insturen is mislukt',
	'storyboard-alreadyexists' => '"$1" wordt al als verhaalnaam gebruikt.',
	'storyboard-alreadyexistschange' => '"{0}" wordt al gebruikt. Kies een andere naam.',
	'storyboard-changetitle' => 'Wijzig de verhaalnaam.',
	'storyboard-notsubmitted' => 'Authenticatie mislukt.
Het verhaal is niet opgeslagen.',
	'storyboard-charstomany' => '$1 tekens te veel!',
	'storyboard-morecharsneeded' => '$1 tekens meer nodig',
	'storyboard-charactersleft' => '$1 tekens over',
	'storyboard-createdsuccessfully' => 'Bedankt voor het delen van uw verhaal!
We gaan het snel beoordelen.
U kunt [$1 gepubliceerde verhalen lezen].',
	'storyboard-emailtitle' => 'Het verhaal is ontvangen',
	'storyboard-emailbody' => 'Uw verhaal "$1" is ontvangen.
We gaan er snel naar kijken.
U kunt [$2 gepubliceerde verhalen lezen] als u dat wilt.',
	'storyreview' => 'Verhalen beoordelen',
	'storyboard-deleteimage' => 'Afbeelding verwijderen',
	'storyboard-done' => 'Afgerond',
	'storyboard-working' => 'Bezig met verwerken...',
	'storyboard-imagedeletionconfirm' => 'Weet u zeker dat u de afbeelding bij het verhaal permanent wilt verwijderen?',
	'storyboard-imagedeleted' => 'Afbeelding verwijderd',
	'storyboard-showimage' => 'Afbeelding weergeven',
	'storyboard-hideimage' => 'Afbeelding verbergen',
	'storyboard-deletestory' => 'Verwijderen',
	'storyboard-storydeletionconfirm' => 'Weet u zeker dat u dit verhaal permanent wilt verwijderen?',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Nghtwlkr
 */
$messages['nn'] = array(
	'storyboard-createdandmodified' => 'Oppretta $1, $2 og sist endra $3, $4',
	'storyboard-authorname' => 'Namnet til forfattar',
	'storyboard-charsleft' => '({{PLURAL:$1|eitt|$1}} teikn igjen)',
	'storyboard-charsneeded' => '(treng {{PLURAL:$1|eitt|$1}} teikn til)',
	'storyboard-charstomany' => '$1 teikn for mange!',
	'storyboard-morecharsneeded' => '$1 fleire teikn trengst',
	'storyboard-charactersleft' => '$1 teikn igjen',
	'storyboard-deleteimage' => 'Slett bilete',
	'storyboard-deletestory' => 'Fjern',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'storyboard-name' => 'Storyboard',
	'storyboard-desc' => "Ofrís una pagina d'aterrissatge pels donators ont las istòrias pòdon èsser somesas e una interfàcia de moderacion de las istòrias",
	'right-storyreview' => 'Relegir, modificar, publicar, e amagar las istòrias',
	'storyboard-unpublish' => 'Despublicar',
	'storyboard-publish' => 'Publicar',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'storyboard-language' => 'Schprooch',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'storyboard-name' => 'Opowiadania',
	'storyboard-desc' => '[[Special:Story|Strona dla autorów]], na której można [[Special:StorySubmission|zamieszczać]] opowiadania oraz [[Special:StoryReview|interfejs do zarządzania nimi]]',
	'right-storyreview' => 'Przeglądanie, edycja, publikowanie i ukrywanie opowiadań',
	'storyboard-anerroroccured' => 'Wystąpił błąd – $1',
	'storyboard-unpublished' => 'Niepublikowane',
	'storyboard-published' => 'Opublikowane',
	'storyboard-hidden' => 'Ukryte',
	'storyboard-unpublish' => 'Cofnij publikację',
	'storyboard-publish' => 'Publikuj',
	'storyboard-hide' => 'Ukryj',
	'storyboard-option-unpublished' => 'niepublikowane',
	'storyboard-option-published' => 'opublikowane',
	'storyboard-option-hidden' => 'ukryte',
	'story' => 'Opowiadanie',
	'storyboard-submittedbyon' => 'Napisane przez $1 dnia $2 o $3',
	'storyboard-viewstories' => 'Pokaż opowiadania',
	'storyboard-nosuchstory' => 'To opowiadanie nie istnieje.
Możliwe, że zostało usunięte.',
	'storyboard-storyunpublished' => 'To opowiadanie nie zostało jeszcze opublikowane.',
	'storyboard-nostorytitle' => 'Musisz określić tytuł lub identyfikator opowiadania, które chcesz zobaczyć.',
	'storyboard-cantedit' => 'Nie możesz edytować opowiadań.',
	'storyboard-canedit' => 'Możesz [$1 napisać] i opublikować to opowiadanie.',
	'storyboard-createdandmodified' => 'Utworzone $1 o $2 i ostatnio poprawiane $3 o $4.',
	'storyboard-authorname' => 'Imię i nazwisko autora',
	'storyboard-authorlocation' => 'Lokalizacja autora',
	'storyboard-authoroccupation' => 'Zawód autora',
	'storyboard-authoremail' => 'Adres e‐mail autora',
	'storyboard-thestory' => 'Opowiadanie',
	'storyboard-storystate' => 'Stan',
	'storyboard-language' => 'Język',
	'storyboard-storymetadata' => 'Napisane przez $1 dnia $2 o $3',
	'storyboard-storymetadatafrom' => 'Przesłane przez $1 z $2 dnia $3 o $4.',
	'storyboard-yourname' => 'Twoje imię i nazwisko (wymagane)',
	'storyboard-location' => 'Twoja lokalizacja',
	'storyboard-occupation' => 'Twój zawód',
	'storyboard-story' => 'Twoje opowiadanie',
	'storyboard-photo' => 'Masz swoje zdjęcie?
Dlaczego miałbyś go nie pokazać?',
	'storyboard-email' => 'Twój adres e‐mail (wymagany)',
	'storyboard-storytitle' => 'Krótki, opisowy tytuł (wymagany)',
	'storyboard-agreement' => 'Wyrażam zgodę na publikację i wykorzystanie opowiadania na warunkach licencji [http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Za uznaniem autora Na tych samych warunkach].',
	'storyboard-charsleft' => '({{PLURAL:$1|pozostał $1 znak|pozostały $1 znaki|pozostało $1 znaków}})',
	'storyboard-cannotbelonger' => 'Twoje opowiadanie jest zbyt długie o <b>$1</b> {{PLURAL:$1|znak|znaki|znaków}}!',
	'storyboard-charsneeded' => '(dodaj jeszcze $1 {{PLURAL:$1|znak|znaki|znaków}})',
	'storyboard-needtoagree' => 'Musisz zgodzić się na publikację opowiadania aby je zapisać.',
	'storyboard-submissioncomplete' => 'Zapisane',
	'storyboard-submissionincomplete' => 'Zapisanie nieudane',
	'storyboard-alreadyexists' => '„$1” jest już zajęte.',
	'storyboard-alreadyexistschange' => '„{0}” jest już zajęte, wybierz inny tytuł.',
	'storyboard-changetitle' => 'Zmień tytuł.',
	'storyboard-notsubmitted' => 'Uwierzytelnienie nie powiodło się, opowiadanie nie zostało zapisane.',
	'storyboard-charstomany' => '$1 {{PLURAL:$1|znak|znaki|znaków}} za dużo!',
	'storyboard-morecharsneeded' => 'Dodaj jeszcze $1 {{PLURAL:$1|znak|znaki|znaków}}',
	'storyboard-charactersleft' => '{{PLURAL:$1|Pozostał $1 znak|Pozostały $1 znaki|Pozostało $1 znaków}}',
	'storyboard-createdsuccessfully' => 'Dziękujemy za to, że podzieliłeś się z nami opowiadaniem!
Opublikujemy je najszybciej jak to będzie możliwe.
Możesz [$1 przeczytać dotychczas opublikowane] opowiadania.',
	'storyboard-emailtitle' => 'Opowiadanie zostało zapisane',
	'storyboard-emailbody' => 'Opowiadanie pod tytułem „$1” zostało zapisane.
Opublikujemy je najszybciej, jak to będzie możliwe.
Możesz [$2 przeczytać dotychczas opublikowane] opowiadania.',
	'storyreview' => 'Sprawdzenie opowiadanie',
	'storyboard-deleteimage' => 'Usuń ilustrację',
	'storyboard-done' => 'Gotowe',
	'storyboard-working' => 'Operacja jest wykonywana...',
	'storyboard-imagedeletionconfirm' => 'Czy na pewno chcesz trwale usunąć tę ilustrację opowiadania?',
	'storyboard-imagedeleted' => 'Ilustracja została usunięta',
	'storyboard-showimage' => 'Pokaż ilustrację',
	'storyboard-hideimage' => 'Ukryj ilustrację',
	'storyboard-deletestory' => 'Usuń',
	'storyboard-storydeletionconfirm' => 'Czy na pewno chcesz trwale usunąć to opowiadanie?',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'storyboard-name' => 'Disegn ëd la senegiadura',
	'storyboard-desc' => "A dà na [[Special:Story|pàgina d'ariv për ij donator]], na [[Special:StorySubmission|pàgina andoa le stòrie a peulo esse butà]], e n'[[Special:StoryReview|antërfacia ëd moderassion dle stòrie]]",
	'right-storyreview' => 'Lese torna, modifiché, publiché e stërmé le stòrie',
	'storyboard-anerroroccured' => "A l'é staje n'eror: $1",
	'storyboard-unpublished' => 'Nen publicà',
	'storyboard-published' => 'Publicà',
	'storyboard-hidden' => 'Stërmà',
	'storyboard-unpublish' => 'Pùblica pa',
	'storyboard-publish' => 'Publiché',
	'storyboard-hide' => 'Stërma',
	'storyboard-option-unpublished' => 'pa publicà',
	'storyboard-option-published' => 'publicà',
	'storyboard-option-hidden' => 'stërmà',
	'story' => 'Stòria',
	'storyboard-submittedbyon' => 'Mandà da $1 ël $2, $3.',
	'storyboard-viewstories' => 'Vëdde le stòrie',
	'storyboard-nosuchstory' => "La stòria ch'it l'has ciamà a esist pa.
A podrìa esse stàita gavà.",
	'storyboard-storyunpublished' => "La stòria ch'it l'has ciamà a l'é pa anco' stàita publicà.",
	'storyboard-nostorytitle' => "A venta ch'a spessifica ël tìtol o l'identificativ ëd la stòria ch'a veule vëdde.",
	'storyboard-cantedit' => "A l'ha nen ël drit ëd modifiché dle stòrie.",
	'storyboard-canedit' => 'It peule [modifiché $1] e publiché sta stòria.',
	'storyboard-createdandmodified' => "Creà ël $1, $2 e modificà për l'ùltima vira ël $3, $4",
	'storyboard-authorname' => "Nòm ëd l'autor",
	'storyboard-authorlocation' => "Pais ëd l'autor",
	'storyboard-authoroccupation' => "Travaj dl'autor",
	'storyboard-authoremail' => "Adrëssa ed pòsta eletrònica ëd l'autor",
	'storyboard-thestory' => 'La stòria',
	'storyboard-storystate' => 'Stat',
	'storyboard-language' => 'Lenga',
	'storyboard-storymetadata' => 'Mandà da $1 ël $2, $3.',
	'storyboard-storymetadatafrom' => 'Mandà da $1 dal $2 ël $3, $4.',
	'storyboard-yourname' => 'Tò nòm (obligatòri)',
	'storyboard-location' => 'Tò pais',
	'storyboard-occupation' => 'Tò travaj',
	'storyboard-story' => 'Toa stòria',
	'storyboard-photo' => "L'has-to na toa fòto?
Përchè it la condivide pa?",
	'storyboard-email' => 'Soa adrëssa ëd pòsta eletrònica (obligatòria)',
	'storyboard-storytitle' => 'Un tìtol curt e descritiv (obligatòri)',
	'storyboard-agreement' => "I son d'acòrdi con la publicassion e l'usagi ëd costa stòria-sì sota le condission dla [http://creativecommons.org/licenses/by-sa/3.0/ Atribussion Creative Commons/Licensa ëd partagi ugual].",
	'storyboard-charsleft' => '($1 {{PLURAL:$1|caràter|caràter}} restà)',
	'storyboard-cannotbelonger' => "Toa stòria a l'é <b>$1</b> {{PLURAL:$1|caràter|caràter}} tròp longa!",
	'storyboard-charsneeded' => '(a-i va $1 ancor {{PLURAL:$1|caràter|caràter}})',
	'storyboard-needtoagree' => "A dev esse d'acòrdi con la publicassion ëd soa stòria për mandela.",
	'storyboard-submissioncomplete' => 'Spedission completà',
	'storyboard-submissionincomplete' => "La spedission a l'é falìa",
	'storyboard-alreadyexists' => '"$1" a l\'é già dovrà.',
	'storyboard-alreadyexistschange' => '"(0)" a l\'é già dovrà, për piasì ch\'a serna un tìtol diferent.',
	'storyboard-changetitle' => 'Cangia ël tìtol.',
	'storyboard-notsubmitted' => 'Autenticassion falìa, pa gnun-e stòrie a son ëstàite salvà.',
	'storyboard-charstomany' => '$1 caràter ëd tròp!',
	'storyboard-morecharsneeded' => "anco' $1 caràter necessari",
	'storyboard-charactersleft' => '$1 caràter restant',
	'storyboard-createdsuccessfully' => 'Mersì për condivide toa stòria con noi!
I la revisioneroma an pressa.
It peule [$1 lese le stòrie publicà].',
	'storyboard-emailtitle' => 'Spedission ëd la stòria andàita bin',
	'storyboard-emailbody' => 'Toa stòria antitolà "$1" a l\'é stàita mandà da bin.
I la revisioneroma an pressa.
It peule [lese $2 stòrie publicà].',
	'storyreview' => 'Revision dla stòria',
	'storyboard-deleteimage' => 'Scancelé la figura',
	'storyboard-done' => 'Fàit',
	'storyboard-working' => 'Al travaj...',
	'storyboard-imagedeletionconfirm' => 'É-lo sigur ëd vorèj scancelé përmanentement la figura ëd sa stòria?',
	'storyboard-imagedeleted' => 'Figura scancelà',
	'storyboard-showimage' => 'Smon-e la figura',
	'storyboard-hideimage' => 'Stërmé la figura',
	'storyboard-deletestory' => 'Gava',
	'storyboard-storydeletionconfirm' => 'É-lo sigur ëd vorèj scancelé përmanentement sta stòria?',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'storyboard-unpublished' => 'ناخپاره',
	'storyboard-published' => 'خپاره شوي',
	'storyboard-hidden' => 'پټ',
	'storyboard-publish' => 'خپرول',
	'storyboard-hide' => 'پټول',
	'storyboard-option-hidden' => 'پټ',
	'story' => 'کيسه',
	'storyboard-authorname' => 'د ليکوال نوم',
	'storyboard-authorlocation' => 'د ليکوال ځای',
	'storyboard-authoroccupation' => 'د ليکوال دنده',
	'storyboard-authoremail' => 'د ليکوال برېښليک پته',
	'storyboard-thestory' => 'کيسه',
	'storyboard-storystate' => 'ايالت',
	'storyboard-language' => 'ژبه',
	'storyboard-yourname' => 'ستاسې نوم (اړينه برخه)',
	'storyboard-location' => 'ستاسې ځای',
	'storyboard-occupation' => 'ستاسې دنده',
	'storyboard-story' => 'ستاسې کيسه',
	'storyboard-email' => 'ستاسې برېښليک پته (اړينه برخه)',
	'storyboard-charsleft' => '($1 {{PLURAL:$1|توری|توري}} پاتې دي)',
	'storyboard-cannotbelonger' => 'ستاسې کيسه <b>$1</b> {{PLURAL:$1|توری|تورې}} ډېره اوږده ده!',
	'storyboard-alreadyexists' => '"$1" له پخوا نه اخيستل شوی.',
	'storyboard-changetitle' => 'سرليک بدلول.',
	'storyboard-charactersleft' => '$1 توري پاتې دي',
	'storyboard-deleteimage' => 'انځور ړنګول',
	'storyboard-done' => 'ترسره شو',
	'storyboard-imagedeleted' => 'انځور ړنګ شو',
	'storyboard-showimage' => 'انځور ښکاره کول',
	'storyboard-hideimage' => 'انځور پټول',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'storyboard-name' => 'Histórias',
	'storyboard-desc' => 'Fornece uma [[Special:Story|página de destino para beneméritos]], uma página onde se podem [[Special:StorySubmission|enviar]] histórias e uma [[Special:StoryReview|interface de moderação das histórias]]',
	'right-storyreview' => 'Rever, editar, publicar e ocultar histórias',
	'storyboard-anerroroccured' => 'Ocorreu um erro: $1',
	'storyboard-unpublished' => 'Não publicada',
	'storyboard-published' => 'Publicada',
	'storyboard-hidden' => 'Ocultada',
	'storyboard-unpublish' => 'Retirar de publicação',
	'storyboard-publish' => 'Publicar',
	'storyboard-hide' => 'Ocultar',
	'storyboard-option-unpublished' => 'não publicada',
	'storyboard-option-published' => 'publicada',
	'storyboard-option-hidden' => 'oculta',
	'story' => 'História',
	'storyboard-submittedbyon' => 'Enviada por $1 em $2, às $3.',
	'storyboard-viewstories' => 'Ver histórias',
	'storyboard-nosuchstory' => 'A história que solicitou não existe.
Pode ter sido ocultada.',
	'storyboard-storyunpublished' => 'A história que solicitou ainda não foi publicada.',
	'storyboard-nostorytitle' => 'Tem de especificar o título ou a identificação da história que pretende ver.',
	'storyboard-cantedit' => 'Não lhe é permitido editar histórias.',
	'storyboard-canedit' => 'Pode [$1 editar] e publicar esta história.',
	'storyboard-createdandmodified' => 'Criada em $1, às $2 e modificada pela última vez em $3, às $4',
	'storyboard-authorname' => 'Nome do autor',
	'storyboard-authorlocation' => 'Localização do autor',
	'storyboard-authoroccupation' => 'Profissão do autor',
	'storyboard-authoremail' => 'Endereço de correio electrónico do autor',
	'storyboard-thestory' => 'A história',
	'storyboard-storystate' => 'Estado',
	'storyboard-language' => 'Língua',
	'storyboard-storymetadata' => 'Enviada por $1 em $2, às $3.',
	'storyboard-storymetadatafrom' => 'Publicada por $1 de $2 em $3, às $4.',
	'storyboard-yourname' => 'O seu nome (obrigatório)',
	'storyboard-location' => 'A sua localização',
	'storyboard-occupation' => 'A sua profissão',
	'storyboard-story' => 'A sua história',
	'storyboard-photo' => 'Tem uma fotografia sua?
Que tal partilhá-la?',
	'storyboard-email' => 'O seu endereço de correio electrónico (obrigatório)',
	'storyboard-storytitle' => 'Um título curto e descritivo (obrigatório)',
	'storyboard-agreement' => 'Concordo com a publicação e uso desta história nos termos da licença [http://creativecommons.org/licenses/by-sa/3.0/deed.pt Creative Commons - Atribuição - Partilha nos Mesmos Termos]',
	'storyboard-charsleft' => '(restam $1 {{PLURAL:$1|carácter|caracteres}})',
	'storyboard-cannotbelonger' => 'A sua história tem <b>$1</b> {{PLURAL:$1|carácter|caracteres}} a mais!',
	'storyboard-charsneeded' => '(é preciso mais $1 {{PLURAL:$1|carácter|caracteres}})',
	'storyboard-needtoagree' => 'Para enviar a sua história tem de concordar com a sua publicação.',
	'storyboard-submissioncomplete' => 'Envio finalizado',
	'storyboard-submissionincomplete' => 'Envio falhou',
	'storyboard-alreadyexists' => '"$1" já foi usado.',
	'storyboard-alreadyexistschange' => '"{0}" já foi usado; escolha outro título, por favor.',
	'storyboard-changetitle' => 'Alterar o título.',
	'storyboard-notsubmitted' => 'A autenticação falhou; não foi gravada nenhuma história.',
	'storyboard-charstomany' => '$1 caracteres a mais!',
	'storyboard-morecharsneeded' => 'são necessários mais $1 caracteres',
	'storyboard-charactersleft' => 'restam $1 caracteres',
	'storyboard-createdsuccessfully' => 'Obrigado por partilhar connosco a sua história.
Iremos revê-la em breve.
Pode [$1 ler histórias publicadas].',
	'storyboard-emailtitle' => 'História submetida com sucesso',
	'storyboard-emailbody' => 'A sua história intitulada "$1" foi submetida com sucesso. Será revista em breve. Pode [$2 ler as histórias publicadas].',
	'storyreview' => 'Revisão da história',
	'storyboard-deleteimage' => 'Apagar imagem',
	'storyboard-done' => 'Terminado',
	'storyboard-working' => 'A processar...',
	'storyboard-imagedeletionconfirm' => 'Tem a certeza de que pretende apagar o histórico desta imagem de forma definitiva?',
	'storyboard-imagedeleted' => 'Imagem eliminada',
	'storyboard-showimage' => 'Mostrar imagem',
	'storyboard-hideimage' => 'Ocultar imagem',
	'storyboard-deletestory' => 'Remover',
	'storyboard-storydeletionconfirm' => 'Tem a certeza de que deseja eliminar esta história de forma definitiva?',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 */
$messages['pt-br'] = array(
	'storyboard-name' => 'Histórias',
	'storyboard-desc' => 'Fornece uma [[Special:Story|página de destino para os doadores]], uma página onde se podem [[Special:StorySubmission|enviar]] histórias e uma [[Special:StoryReview|interface de moderação das histórias]]',
	'right-storyreview' => 'Revisar, editar, publicar e ocultar histórias',
	'storyboard-anerroroccured' => 'Ocorreu um erro: $1',
	'storyboard-unpublished' => 'Não publicada',
	'storyboard-published' => 'Publicada',
	'storyboard-hidden' => 'Ocultada',
	'storyboard-unpublish' => 'Retirar de publicação',
	'storyboard-publish' => 'Publicar',
	'storyboard-hide' => 'Ocultar',
	'storyboard-option-unpublished' => 'não publicada',
	'storyboard-option-published' => 'publicada',
	'storyboard-option-hidden' => 'oculta',
	'story' => 'História',
	'storyboard-submittedbyon' => 'Enviada por $1 em $2, às $3.',
	'storyboard-viewstories' => 'Ver as histórias',
	'storyboard-nosuchstory' => 'A história que você solicitou não existe.
Ela pode ter sido removida.',
	'storyboard-storyunpublished' => 'A história que solicitou ainda não foi publicada.',
	'storyboard-nostorytitle' => 'Você precisa especificar o título ou a identificação da história que pretende ver.',
	'storyboard-cantedit' => 'Você não tem permissão para editar histórias.',
	'storyboard-canedit' => 'Você pode [$1 editar] e publicar esta história.',
	'storyboard-createdandmodified' => 'Criada em $1, às $2 e modificada pela última vez em $3, às $4',
	'storyboard-authorname' => 'Nome do autor',
	'storyboard-authorlocation' => 'Localização do autor',
	'storyboard-authoroccupation' => 'Profissão do autor',
	'storyboard-authoremail' => 'Endereço de e-mail do autor',
	'storyboard-thestory' => 'A história',
	'storyboard-storystate' => 'Estado',
	'storyboard-language' => 'Língua',
	'storyboard-storymetadata' => 'Enviada por $1 em $2, às $3.',
	'storyboard-storymetadatafrom' => 'Publicada por $1 de $2 em $3, às $4.',
	'storyboard-yourname' => 'O seu nome (obrigatório)',
	'storyboard-location' => 'A sua localização',
	'storyboard-occupation' => 'A sua profissão',
	'storyboard-story' => 'A sua história',
	'storyboard-photo' => 'Tem uma fotografia sua?
Que tal partilhá-la?',
	'storyboard-email' => 'O seu endereço de e-mail (obrigatório)',
	'storyboard-storytitle' => 'Um título curto e descritivo (obrigatório)',
	'storyboard-agreement' => 'Concordo com a publicação e uso desta história nos termos da licença [http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Atribuição-Partilha nos Termos da Mesma Licença]',
	'storyboard-charsleft' => '(restam $1 {{PLURAL:$1|caractere|caracteres}})',
	'storyboard-cannotbelonger' => 'A sua história tem <b>$1</b> {{PLURAL:$1|caractere|caracteres}} a mais do que o permitido!',
	'storyboard-charsneeded' => '(é preciso mais $1 {{PLURAL:$1|caractere|caracteres}})',
	'storyboard-needtoagree' => 'Para enviar a sua história, você tem de concordar com a sua publicação.',
	'storyboard-submissioncomplete' => 'Envio finalizado',
	'storyboard-submissionincomplete' => 'Falha no envio',
	'storyboard-alreadyexists' => '"$1" já foi usado.',
	'storyboard-alreadyexistschange' => '"{0}" já foi usado; escolha outro título, por favor.',
	'storyboard-changetitle' => 'Alterar o título.',
	'storyboard-notsubmitted' => 'A autenticação falhou; nenhuma história foi salva.',
	'storyboard-charstomany' => '$1 caracteres a mais!',
	'storyboard-morecharsneeded' => 'são necessários mais $1 caracteres',
	'storyboard-charactersleft' => 'restam $1 caracteres',
	'storyboard-createdsuccessfully' => 'Obrigado por partilhar conosco a sua história.
Iremos revisá-la em breve.
Você pode [$1 ler as histórias publicadas].',
	'storyboard-emailtitle' => 'História submetida com sucesso',
	'storyboard-emailbody' => 'A sua história intitulada "$1" foi submetida com sucesso.
Iremos revisá-la em breve.
Você pode [$2 ler as histórias publicadas].',
	'storyreview' => 'Revisão da história',
	'storyboard-deleteimage' => 'Apagar imagem',
	'storyboard-done' => 'Feito',
	'storyboard-working' => 'Processando...',
	'storyboard-imagedeletionconfirm' => 'Você tem certeza de que pretende apagar o histórico desta imagem de forma definitiva?',
	'storyboard-imagedeleted' => 'Imagem eliminada',
	'storyboard-showimage' => 'Mostrar imagem',
	'storyboard-hideimage' => 'Ocultar imagem',
	'storyboard-deletestory' => 'Remover',
	'storyboard-storydeletionconfirm' => 'Você tem certeza de que deseja eliminar esta história de forma definitiva?',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'storyboard-name' => 'Доска историй',
	'storyboard-desc' => 'Предоставляет [[Special:Story|страницу]] для [[Special:StorySubmission|размещения историй]] жертвователей, а также [[Special:StoryReview|интерфейс модерации]] этих историй',
	'right-storyreview' => 'проверка, правка, публикация и сокрытие историй',
	'storyboard-anerroroccured' => 'Возникла ошибка: $1',
	'storyboard-unpublished' => 'Неопубликована',
	'storyboard-published' => 'Опубликована',
	'storyboard-hidden' => 'Скрыта',
	'storyboard-unpublish' => 'Убрать',
	'storyboard-publish' => 'Опубликовать',
	'storyboard-hide' => 'Скрыть',
	'storyboard-option-unpublished' => 'неопубликована',
	'storyboard-option-published' => 'опубликована',
	'storyboard-option-hidden' => 'скрыта',
	'story' => 'История',
	'storyboard-submittedbyon' => 'Отправлена $1 $2 $3.',
	'storyboard-viewstories' => 'Просмотр историй',
	'storyboard-nosuchstory' => 'Запрошенной вами истории не существует.
Возможно, она была удалена.',
	'storyboard-storyunpublished' => 'Запрашиваемая вами история ещё не была опубликована.',
	'storyboard-nostorytitle' => 'Вы должны указать название или идентификатор истории, которую вы хотите просмотреть.',
	'storyboard-cantedit' => 'Вы не можете редактировать истории.',
	'storyboard-canedit' => 'Вы можете [$1 изменить] и опубликовать эту историю.',
	'storyboard-createdandmodified' => 'Создана $1 $2, изменена $3 $4',
	'storyboard-authorname' => 'Имя автора',
	'storyboard-authorlocation' => 'Местонахождение автора',
	'storyboard-authoroccupation' => 'Род занятий автора',
	'storyboard-authoremail' => 'Адрес эл. почты автора',
	'storyboard-thestory' => 'История',
	'storyboard-storystate' => 'Состояние',
	'storyboard-language' => 'Язык',
	'storyboard-storymetadata' => 'Отправлена $1 $2, $3.',
	'storyboard-storymetadatafrom' => 'Отправлена $1 с $2 $3 $4.',
	'storyboard-yourname' => 'Ваше имя (обяз.)',
	'storyboard-location' => 'Ваше местоположение',
	'storyboard-occupation' => 'Ваш род занятий',
	'storyboard-story' => 'Ваша история',
	'storyboard-photo' => 'У вас есть ваша фотография?
Почему бы не разместить её?',
	'storyboard-email' => 'Ваш адрес эл. почты (обяз.)',
	'storyboard-storytitle' => 'Короткий описательный заголовок (обяз.)',
	'storyboard-agreement' => 'Я согласен с публикацией и использованием этой истории в соответствии с условиями [http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution/Share-Alike License].',
	'storyboard-charsleft' => '({{PLURAL:$1|осталcя $1 символ|осталось $1 символа|осталось $1 символов}})',
	'storyboard-cannotbelonger' => 'Ваша история длиннее на <b>$1</b> {{PLURAL:$1|символ|символа|символов}}!',
	'storyboard-charsneeded' => '({{PLURAL:$1|необходим ещё $1 символ|необходимо ещё $1 символа|необходимо ещё $1 символов}})',
	'storyboard-needtoagree' => 'Вы должны дать согласие на публикацию своей истории перед её отправкой.',
	'storyboard-submissioncomplete' => 'Подача произведена',
	'storyboard-submissionincomplete' => 'Ошибка при отправке',
	'storyboard-alreadyexists' => '«$1» уже занято.',
	'storyboard-alreadyexistschange' => '«{0}» уже занят, пожалуйста, выберите другой заголовок.',
	'storyboard-changetitle' => 'Изменить название.',
	'storyboard-notsubmitted' => 'Аутентификация не удалась, ни одна история не была сохранена.',
	'storyboard-charstomany' => 'Превышение числа символов на $1!',
	'storyboard-morecharsneeded' => '{{PLURAL:$1|Необходим ещё $1 символ|Необходимо ещё $1 символа|Необходимо ещё $1 символов}}',
	'storyboard-charactersleft' => '{{PLURAL:$1|Остался $1 символ|Осталось $1 символа|Осталось $1 символов}}',
	'storyboard-createdsuccessfully' => 'Спасибо, что рассказали нам свою историю!
Мы рассмотрим её в ближайшее время.
Вы можете [$1 прочитать уже опубликованные истории].',
	'storyboard-emailtitle' => 'История успешно отправлена',
	'storyboard-emailbody' => 'Ваша история «$1» была успешно опубликована.
В ближайшее время мы её рассмотрим.
Вы можете [$2 почитать уже опубликованные истории].',
	'storyreview' => 'Проверка истории',
	'storyboard-deleteimage' => 'Удалить изображение',
	'storyboard-done' => 'Сделано',
	'storyboard-working' => 'Обработка…',
	'storyboard-imagedeletionconfirm' => 'Вы уверены, что хотите удалить изображение из этого рассказа?',
	'storyboard-imagedeleted' => 'Изображение удалено',
	'storyboard-showimage' => 'Показать изображение',
	'storyboard-hideimage' => 'Скрыть изображение',
	'storyboard-deletestory' => 'Удалить',
	'storyboard-storydeletionconfirm' => 'Вы уверены, что хотите удалить эту историю?',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'storyboard-authorname' => 'Мено автора',
	'storyboard-authorlocation' => 'Місце де жыє автор',
	'storyboard-authoremail' => 'Авторова адреса електронічной пошты',
	'storyboard-language' => 'Язык',
	'storyboard-done' => 'Готово',
	'storyboard-working' => 'Робить ся...',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'storyboard-anerroroccured' => 'Дошло је до грешке: $1',
	'storyboard-unpublished' => 'Повучено из објаве',
	'storyboard-published' => 'Објављено',
	'storyboard-hidden' => 'Сакривено',
	'storyboard-unpublish' => 'Повуци објаву',
	'storyboard-publish' => 'Објави',
	'storyboard-hide' => 'Сакриј',
	'storyboard-option-unpublished' => 'необјављено',
	'storyboard-option-published' => 'објављено',
	'storyboard-option-hidden' => 'сакривено',
	'story' => 'Прича',
	'storyboard-submittedbyon' => 'Послато од $1, на $2, $3.',
	'storyboard-viewstories' => 'Види приче',
	'storyboard-cantedit' => 'Немате дозволу да мењате приче.',
	'storyboard-canedit' => 'Можете да [$1 измените] и објавите ову причу.',
	'storyboard-authorname' => 'Име аутора',
	'storyboard-authorlocation' => 'Локација аутора',
	'storyboard-authoroccupation' => 'Занимање аутора',
	'storyboard-authoremail' => 'Ауторова адресе електронске поште',
	'storyboard-storystate' => 'Стање',
	'storyboard-language' => 'Језик',
	'storyboard-storymetadata' => 'Послато од $1, на $2, $3.',
	'storyboard-storymetadatafrom' => 'Послато од $1 из $2, на $3, $4.',
	'storyboard-yourname' => 'Важе име (потребно)',
	'storyboard-location' => 'Место живљења',
	'storyboard-occupation' => 'Ваше занимање',
	'storyboard-story' => 'Ваша прича',
	'storyboard-photo' => 'Имате ли своју слику?
Зашто је не бисте показали?',
	'storyboard-email' => 'Адреса Ваше електронске поште (потребно)',
	'storyboard-storytitle' => 'Кратак, дескриптиван наслов (потребно)',
	'storyboard-charsneeded' => '({{PLURAL:$1|потребан је још $1 карактер|потребна су још $1 карактера|потребна су још $1 карактера|потребна су још $1 карактера|потребно је још $1 карактера}})',
	'storyboard-submissioncomplete' => 'Слање комплетирано',
	'storyboard-submissionincomplete' => 'Слање није успело',
	'storyboard-changetitle' => 'Промените наслов.',
	'storyboard-charstomany' => '$1 слова је превише!',
	'storyboard-morecharsneeded' => '$1 више слова је потребно',
	'storyboard-charactersleft' => '$1 слова је преостало',
	'storyboard-deleteimage' => 'Обриши слику',
	'storyboard-done' => 'Урађено',
	'storyboard-working' => 'Обрада у току...',
	'storyboard-imagedeleted' => 'Слика обрисана',
	'storyboard-showimage' => 'Прикажи слику',
	'storyboard-hideimage' => 'Сакриј слику',
	'storyboard-deletestory' => 'Обриши',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Rancher
 */
$messages['sr-el'] = array(
	'storyboard-anerroroccured' => 'Došlo je do greške: $1',
	'storyboard-unpublished' => 'Povučeno iz objave',
	'storyboard-published' => 'Objavljeno',
	'storyboard-hidden' => 'Sakriveno',
	'storyboard-unpublish' => 'Povuci objavu',
	'storyboard-publish' => 'Objavi',
	'storyboard-hide' => 'Sakrij',
	'storyboard-option-unpublished' => 'neobjavljeno',
	'storyboard-option-published' => 'objavljeno',
	'storyboard-option-hidden' => 'sakriveno',
	'story' => 'Priča',
	'storyboard-submittedbyon' => 'Poslato od $1, na $2, $3.',
	'storyboard-viewstories' => 'Vidi priče',
	'storyboard-cantedit' => 'Nemate dozvolu da menjate priče.',
	'storyboard-canedit' => 'Možete da [$1 izmenite] i objavite ovu priču.',
	'storyboard-authorname' => 'Ime autora',
	'storyboard-authorlocation' => 'Lokacija autora',
	'storyboard-authoroccupation' => 'Zanimanje autora',
	'storyboard-authoremail' => 'Autorova adrese elektronske pošte',
	'storyboard-storystate' => 'Stanje',
	'storyboard-language' => 'Jezik',
	'storyboard-storymetadata' => 'Poslato od $1, na $2, $3.',
	'storyboard-storymetadatafrom' => 'Poslato od $1 iz $2, na $3, $4.',
	'storyboard-yourname' => 'Važe ime (potrebno)',
	'storyboard-location' => 'Vaša lokacija',
	'storyboard-occupation' => 'Vaše zanimanje',
	'storyboard-story' => 'Vaša priča',
	'storyboard-photo' => 'Imate li svoju sliku?
Zašto je ne biste pokazali?',
	'storyboard-email' => 'Adresa Vaše elektronske pošte (potrebno)',
	'storyboard-storytitle' => 'Kratak, deskriptivan naslov (potrebno)',
	'storyboard-charsneeded' => '({{PLURAL:$1|potreban je još $1 karakter|potrebna su još $1 karaktera|potrebna su još $1 karaktera|potrebna su još $1 karaktera|potrebno je još $1 karaktera}})',
	'storyboard-submissioncomplete' => 'Slanje kompletirano',
	'storyboard-submissionincomplete' => 'Slanje nije uspelo',
	'storyboard-changetitle' => 'Promenite naslov.',
	'storyboard-charstomany' => '$1 slova je previše!',
	'storyboard-morecharsneeded' => '$1 više slova je potrebno',
	'storyboard-charactersleft' => '$1 slova je preostalo',
	'storyboard-deleteimage' => 'Obriši sliku',
	'storyboard-done' => 'Urađeno',
	'storyboard-working' => 'Obrada u toku...',
	'storyboard-imagedeleted' => 'Slika obrisana',
	'storyboard-showimage' => 'Prikaži sliku',
	'storyboard-hideimage' => 'Sakrij sliku',
	'storyboard-deletestory' => 'Obriši',
);

/** Swedish (Svenska)
 * @author Ainali
 * @author Dafer45
 */
$messages['sv'] = array(
	'storyboard-unpublished' => 'Ej publicerad',
	'storyboard-published' => 'Publicerad',
	'storyboard-hidden' => 'Dold',
	'storyboard-unpublish' => 'Ej publicerad',
	'storyboard-publish' => 'Publicera',
	'storyboard-hide' => 'Dölj',
	'storyboard-option-unpublished' => 'ej publicerad',
	'storyboard-option-published' => 'publicerad',
	'storyboard-option-hidden' => 'dold',
	'storyboard-submittedbyon' => 'Insänt av $1 på $2, $3.',
	'storyboard-authorname' => 'Författarnamn',
	'storyboard-language' => 'Språk',
	'storyboard-yourname' => 'Ditt namn (krävs)',
	'storyboard-occupation' => 'Ditt yrke',
	'storyboard-photo' => 'Har du ett foto på dig själv?
Varför inte dela med dig av det?',
	'storyboard-email' => 'Din e-postadress (krävs)',
	'storyboard-storytitle' => 'En kort, beskrivande titel (krävs)',
	'storyboard-charsneeded' => '($ 1 fler ((plural: $ 1 | tecken | tecken)) behövs)',
	'storyboard-submissioncomplete' => 'Inlämning komplett',
	'storyboard-submissionincomplete' => 'Inlämning misslyckades',
	'storyboard-alreadyexists' => '"$1" är redan upptagen.',
	'storyboard-alreadyexistschange' => '"{0}" är redan upptaget, välj en annan titel.',
	'storyboard-changetitle' => 'Ändra titeln.',
	'storyboard-notsubmitted' => 'Autentisering misslyckades, ingen berättelse har sparats.',
	'storyboard-charstomany' => '$1 tecken för mycket!',
	'storyboard-morecharsneeded' => '$1 fler tecken behövs',
	'storyboard-charactersleft' => '$1 tecken kvar',
	'storyboard-createdsuccessfully' => 'Tack för att du delar din berättelse med oss! 
 Vi kommer att granska den inom kort. 
 Du kan [$1 Läsa publicerade berättelser].',
	'storyboard-deleteimage' => 'Radera bild',
	'storyboard-done' => 'Klar',
	'storyboard-working' => 'Arbetar...',
	'storyboard-imagedeleted' => 'Bild raderad',
	'storyboard-showimage' => 'Visa bild',
	'storyboard-hideimage' => 'Dölj bild',
	'storyboard-deletestory' => 'Radera',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'right-storyreview' => 'కథనాల సమీక్ష, కూర్పు, ప్రచురణ, మరియు దాచడం చేయగలగడం',
	'storyboard-unpublished' => 'అప్రచురితం',
	'storyboard-published' => 'ప్రచురితం',
	'storyboard-publish' => 'ప్రచురించు',
	'storyboard-hide' => 'దాచు',
	'story' => 'కథనం',
	'storyboard-authorname' => 'రచయిత పేరు',
	'storyboard-authorlocation' => 'రచయిత ప్రాంతం',
	'storyboard-authoroccupation' => 'రచయిత వృత్తి',
	'storyboard-authoremail' => 'రచయిత ఈ-మెయిలు చిరునామా',
	'storyboard-thestory' => 'కథనం',
	'storyboard-storystate' => 'స్థితి',
	'storyboard-language' => 'భాష',
	'storyboard-yourname' => 'మీ పేరు (తప్పనిసరి)',
	'storyboard-location' => 'మీ ప్రాంతం',
	'storyboard-occupation' => 'మీ వృత్తి',
	'storyboard-story' => 'మీ కథనం',
	'storyboard-photo' => 'మీ ఫొటో ఉందా?
మాతో పంచుకోకూడదా?',
	'storyboard-email' => 'మీ ఈ-మెయిలు చిరునామా (తప్పనిసరి)',
	'storyboard-storytitle' => 'క్లుప్త, వివరణాత్మకమైన శీర్షిక (తప్పనిసరి)',
	'storyboard-charsleft' => '($1 {{PLURAL:$1|అక్షరం మిగిలివుంది|అక్షరాలు మిగిలివున్నాయి}})',
	'storyboard-cannotbelonger' => 'మీ కథనం <b>$1</b> {{PLURAL:$1|అక్షరం|అక్షరాలు}} చాలా పెద్దగా ఉంది!',
	'storyboard-charsneeded' => '(ఇంకా $1 {{PLURAL:$1|అక్షరం|అక్షరాలు}} కావాలి)',
	'storyboard-submissioncomplete' => 'సమర్పణ పూర్తి',
	'storyboard-submissionincomplete' => 'దాఖలు విఫలమైంది',
	'storyboard-changetitle' => 'శీర్షికని మార్చండి.',
	'storyboard-done' => 'పూర్తయ్యింది',
	'storyboard-showimage' => 'చిత్రాన్ని చూపించు',
	'storyboard-hideimage' => 'చిత్రాన్ని దాచు',
	'storyboard-deletestory' => 'తొలగించు',
	'storyboard-storydeletionconfirm' => 'మీరు నిజంగానే ఈ కథనాన్ని తొలగించాలనుకుంటున్నారా?',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'storyboard-language' => 'Lian',
	'storyboard-deletestory' => 'Hasai',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'storyboard-name' => 'Talahanayan ng salaysay',
	'storyboard-desc' => 'Nagbibigay ng isang [[Special:Story|lapagang pahina para sa mga tagapagkaloob]], isang pahina kung saan [[Special:StorySubmission|maipapasa]] ang mga kuwento at isang [[Special:StoryReview|hangganang-mukha ng pagtimpla ng kuwento]]',
	'right-storyreview' => 'Suriin, baguhin, ilathala, at itago ang mga kuwento',
	'storyboard-anerroroccured' => 'Naganap ang isang kamalian: $1',
	'storyboard-unpublished' => 'Hindi pa nalathala',
	'storyboard-published' => 'Nalathala na',
	'storyboard-hidden' => 'Nakatago',
	'storyboard-unpublish' => 'Huwag ilathala',
	'storyboard-publish' => 'Ilathala',
	'storyboard-hide' => 'Itago',
	'storyboard-option-unpublished' => 'hindi pa nalathala',
	'storyboard-option-published' => 'nalathala na',
	'storyboard-option-hidden' => 'nakatago',
	'story' => 'Kuwento',
	'storyboard-submittedbyon' => 'Ipinasa ni $1 noong $2, $3.',
	'storyboard-viewstories' => 'Tingnan ang mga kuwento',
	'storyboard-nosuchstory' => 'Hindi umiirl ang hiniling mong kuwento.
Maaaring tinanggal ito.',
	'storyboard-storyunpublished' => 'Hindi pa nalalathala ang hiniling mong kuwento.',
	'storyboard-nostorytitle' => 'Dapat kang tumukoy ng isang pamagat o ID ng kuwentong nais mong tingnan.',
	'storyboard-cantedit' => 'Wala kang pahintulot na mamatnugot ng mga kuwento.',
	'storyboard-canedit' => 'Maaari mong [$1 baguhin] at ilathala ang kuwentong ito.',
	'storyboard-createdandmodified' => 'Nilikha noong $1, $2 at huling binago noong $3, $4',
	'storyboard-authorname' => 'Pangalan ng may-akda',
	'storyboard-authorlocation' => 'Lugar ng may-akda',
	'storyboard-authoroccupation' => 'Hanapbuhay ng may-akda',
	'storyboard-authoremail' => 'Tirahan ng e-liham ng may-akda',
	'storyboard-thestory' => 'Ang kuwento',
	'storyboard-storystate' => 'Estado',
	'storyboard-language' => 'Wika',
	'storyboard-storymetadata' => 'Ipinasa ni $1 noong $2, $3.',
	'storyboard-storymetadatafrom' => 'Ipinasa ni $1 mula sa $2 noong $3, $4.',
	'storyboard-yourname' => 'Pangalan mo (kailangan)',
	'storyboard-location' => 'Lokasyon mo',
	'storyboard-occupation' => 'Hanapbuhay mo',
	'storyboard-story' => 'Ang kuwento mo',
	'storyboard-photo' => 'May larawan ka ng sarili mo?
Bakit hindi mo ito ibahagi?',
	'storyboard-email' => 'Tirahan mo ng e-liham (kailangan)',
	'storyboard-storytitle' => 'Isang maikli, mapaglarawang pamagat (kailangan)',
	'storyboard-agreement' => 'Sumasang-ayon ako sa paglalathala at paggamit ng kuwentong ito sa ilalim ng mga patakaran ng [http://creativecommons.org/licenses/by-sa/3.0/ Lisensiya ng Malikhaing mga Pangkaraniwang Atribusyon/Pamamahaging Magkatulad].',
	'storyboard-charsleft' => '($1 natitirang {{PLURAL:$1|panitik|mga panitik}})',
	'storyboard-cannotbelonger' => 'Ang kuwento mo ay mahaba ng <b>$1</b> {{PLURAL:$1|panitik|mga panitik}}!',
	'storyboard-charsneeded' => '($1 pang {{PLURAL:$1|panitik|mga panitik}} ang  kailangan)',
	'storyboard-needtoagree' => 'Kailangan mong sumang-ayon sa paglalathala ng iyong kuwento upang maipasa ito.',
	'storyboard-submissioncomplete' => 'Buo na ang pagpapasa',
	'storyboard-submissionincomplete' => 'Nabigo ang pagpapasa',
	'storyboard-alreadyexists' => 'May nakakuha na ng "$1".',
	'storyboard-alreadyexistschange' => 'May nakakuha na ng "{0}", mangyaring pumili ng ibang pamagat.',
	'storyboard-changetitle' => 'Baguhin ang pamagat.',
	'storyboard-notsubmitted' => 'Nabigo ang pagpapatunay, walang nasagip na kuwento.',
	'storyboard-charstomany' => 'Labis ng $1 mga panitik!',
	'storyboard-morecharsneeded' => '$1 pang mga panitik ang kinakailangan',
	'storyboard-charactersleft' => '$1 mga panitik ang natitira',
	'storyboard-createdsuccessfully' => 'Salamat sa pagbabahagi ng iyong kuwento sa amin!
Susuriin namin ito maya-maya.
Maaari kang [$1 magbasa ng nalathalang mga kuwento].',
	'storyboard-emailtitle' => 'Matagumpay ang pagpapasa ng kuwento',
	'storyboard-emailbody' => 'Ang iyong kuwentong pinamagatang "$1" ay matagumpay na naipasa.
Susuriin namin ito mamaya-maya.
Maaari kang [$2 magbasa ng nalathalang mga kuwento].',
	'storyreview' => 'Muling pagsusuri ng kuwento',
	'storyboard-deleteimage' => 'Burahin ang larawan',
	'storyboard-done' => 'Nagawa na',
	'storyboard-working' => 'Gumagawa...',
	'storyboard-imagedeletionconfirm' => 'Nakatitiyak ka bang nais mong burahin ng pamalagian ang larawan ng kuwento?',
	'storyboard-imagedeleted' => 'Nabura na ang larawan',
	'storyboard-showimage' => 'Ipakita ang larawan',
	'storyboard-hideimage' => 'Ikubli ang larawan',
	'storyboard-deletestory' => 'Tanggalin',
	'storyboard-storydeletionconfirm' => 'Natitiyak mo bang nais mong burahin ng pamalagian ang kuwento?',
);

/** Ukrainian (Українська)
 * @author Тест
 */
$messages['uk'] = array(
	'storyboard-hidden' => 'Прихована',
	'storyboard-publish' => 'Опублікувати',
	'storyboard-hide' => 'Сховати',
	'storyboard-authorname' => "Ім'я автора",
	'storyboard-language' => 'Мова',
	'storyboard-changetitle' => 'Змінити заголовок.',
	'storyboard-deleteimage' => 'Вилучити зображення',
	'storyboard-done' => 'Виконано',
	'storyboard-imagedeleted' => 'Зображення вилучено',
	'storyboard-showimage' => 'Показати зображення',
	'storyboard-hideimage' => 'Сховати зображення',
	'storyboard-deletestory' => 'Вилучити',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'storyboard-hidden' => 'פֿאַרבאָרגן',
	'storyboard-authorname' => 'מחבר נאָמען',
	'storyboard-language' => 'שפראַך',
);

/** Simplified Chinese (‪中文(简体)‬) */
$messages['zh-hans'] = array(
	'storyboard-hidden' => '隐藏',
	'storyboard-hide' => '隐藏',
	'storyboard-option-hidden' => '隐藏',
	'storyboard-storystate' => '州份/省份',
	'storyboard-language' => '语言',
	'storyboard-done' => '完成',
	'storyboard-showimage' => '显示图片',
	'storyboard-hideimage' => '隐藏图片',
	'storyboard-deletestory' => '移除',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'storyboard-hidden' => '隱藏',
	'storyboard-hide' => '隱藏',
	'storyboard-option-hidden' => '隱藏',
	'storyboard-storystate' => '州份/省份',
	'storyboard-language' => '語言',
	'storyboard-done' => '完成',
	'storyboard-showimage' => '顯示圖片',
	'storyboard-hideimage' => '隱藏圖片',
	'storyboard-deletestory' => '移除',
);

