<?php
/**
 * Internationalization file for AutoCreateWiki extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	"autocreatewiki" => "Create a new wiki",
	"autocreatewiki-desc" => "Create wiki in WikiFactory by user requests",
	"autocreatewiki-page-title-default" => "Create a new wiki",
	"autocreatewiki-page-title-answers" => "Create a new Answers site",
	"createwiki"=> "Create a new wiki",
	"autocreatewiki-chooseone" => "Choose one",
	"autocreatewiki-required" => "$1 = required",
	"autocreatewiki-web-address" => "Web address:",
	"autocreatewiki-category-select" => "Select one",
	"autocreatewiki-language-top" => "Top $1 languages",
	"autocreatewiki-language-all" => "All languages",
	"autocreatewiki-birthdate" => "Birth date:",
	"autocreatewiki-blurry-word" => "Blurry word:",
	"autocreatewiki-remember" => "Remember me",
	"autocreatewiki-create-account" => "Create an account",
	"autocreatewiki-done" => "done",
	"autocreatewiki-error" => "error",
	"autocreatewiki-language-top-list" => "de,en,es,he,fr,it,ja,no,pl,pt,pt-br,zh",
	"autocreatewiki-haveaccount-question" => "Do you already have a Wikia account?",
	"autocreatewiki-success-title-default" => "Your wiki has been created!",
	"autocreatewiki-success-title-answers" => "Your answers site has been created!",
	"autocreatewiki-success-subtitle" => "You can now begin working on your wiki by visiting:",
	"autocreatewiki-success-has-been-created" => "has been created!",
	"autocreatewiki-success-get-started" => "Get Started",
// form messages
	"autocreatewiki-info-domain" => "It's best to use a word likely to be a search keyword for your topic.",
	"autocreatewiki-info-topic" => "Add a short description such as \"Star Wars\" or \"TV shows\".",
	"autocreatewiki-info-category-default" => "This will help visitors find your wiki.",
	"autocreatewiki-info-category-answers" => "This will help visitors find your Answers site.",
	"autocreatewiki-info-language" => "This will be the default language for visitors to your wiki.",
	"autocreatewiki-info-email-address" => "Your email address is never shown to anyone on Wikia.",
	"autocreatewiki-info-realname" => "If you choose to provide it, this will be used for giving you attribution for your work.",
	"autocreatewiki-info-birthdate" => "Wikia requires all users to provide their real date of birth as both a safety precaution and as a means of preserving the integrity of the site while complying with federal regulations.",
	"autocreatewiki-info-blurry-word" => "To help protect against automated account creation, please type the blurry word that you see into this field.",
	"autocreatewiki-info-terms-agree" => "By creating a wiki and a user account, you agree to the <a href=\"http://www.wikia.com/wiki/Terms_of_use\">Wikia's Terms of Use</a>",
	"autocreatewiki-info-staff-username" => "<b>Staff only:</b> The specified user will be listed as the founder.",
	"autocreatewiki-title-template" => "$1 Wiki",
	"autocreatewiki-tagline" => "",
// errors
	"autocreatewiki-limit-day" => "Wikia has exceeded the maximum number of wiki creations today ($1).",
	"autocreatewiki-limit-creation" => "You have exceeded the maximum number of wiki creation in 24 hours ($1).",
	"autocreatewiki-empty-field" => "Please complete this field.",
	"autocreatewiki-bad-name" => "The name cannot contain special characters (like $ or @) and must be a single lower-case word without spaces.",
	"autocreatewiki-invalid-wikiname" => "The name cannot contain special characters (like $ or @) and cannot be empty",
	"autocreatewiki-violate-policy" => "This wiki name contains a word that violates our naming policy",
	"autocreatewiki-name-taken" => "A wiki with this name already exists. You are welcome to join us at <a href=\"http://$1.wikia.com\">http://$1.wikia.com</a>",
	"autocreatewiki-name-too-short" => "This name is too short. Please choose a name with at least 3 characters.",
	"autocreatewiki-name-too-long" => "This name is too long. Please choose a name with maximum 50 characters.",
	"autocreatewiki-similar-wikis" => "Below are the wikis already created on this topic. We suggest editing one of them.",
	"autocreatewiki-invalid-username" => "This username is invalid.",
	"autocreatewiki-busy-username" => "This username is already taken.",
	"autocreatewiki-blocked-username" => "You cannot create account.",
	"autocreatewiki-user-notloggedin" => "Your account was created but not logged in!",
	"autocreatewiki-empty-language" => "Please select the language for the wiki.",
	"autocreatewiki-empty-category" => "Please select a category.",
	"autocreatewiki-empty-wikiname" => "The name of the wiki cannot be empty.",
	"autocreatewiki-empty-username" => "Username cannot be empty.",
	"autocreatewiki-empty-password" => "Password cannot be empty.",
	"autocreatewiki-empty-retype-password" => "Retype password cannot be empty.",
	"autocreatewiki-category-label" => "Category:",
	"autocreatewiki-category-other" => "Other",
	"autocreatewiki-set-username" => "Set username first.",
	"autocreatewiki-invalid-category" => "Invalid value of category.
Please select proper from dropdown list.",
	"autocreatewiki-invalid-language" => "Invalid value of language.
Please select proper from dropdown list.",
	"autocreatewiki-invalid-retype-passwd" => "Please retype the same password as above",
	"autocreatewiki-invalid-birthday" => "Invalid birth date",
	"autocreatewiki-limit-birthday" => "Unable to create registration.",
// processing
	"autocreatewiki-log-title" => "Your wiki is being created",
	"autocreatewiki-step0" => "Initializing process ...",
	"autocreatewiki-stepdefault" => "Process is running, please wait ...",
	"autocreatewiki-errordefault" => "Process was not finished ...",
	"autocreatewiki-step1" => "Creating images folder ...",
	"autocreatewiki-step2" => "Creating database ...",
	"autocreatewiki-step3" => "Setting default information in database ...",
	"autocreatewiki-step4" => "Copying default images and logo ...",
	"autocreatewiki-step5" => "Setting default variables in database ...",
	"autocreatewiki-step6" => "Setting default tables in database ...",
	"autocreatewiki-step7" => "Setting language starter ...",
	"autocreatewiki-step8" => "Setting user groups and categories ...",
	"autocreatewiki-step9" => "Setting variables for new wiki ...",
	"autocreatewiki-step10" => "Setting pages on central wiki ...",
	"autocreatewiki-step11" => "Sending email to user ...",
	"autocreatewiki-redirect" => "Redirecting to new wiki: $1 ...",
	"autocreatewiki-congratulation" => "Congratulations!",
	"autocreatewiki-welcometalk-log" => "Welcome Message",
	"autocreatewiki-regex-error-comment" => "used in wiki $1 (whole text: $2)",
// processing errors
	"autocreatewiki-step2-error" => "Database exists!",
	"autocreatewiki-step3-error" => "Cannot set default information in database!",
	"autocreatewiki-step6-error" => "Cannot set default tables in database!",
	"autocreatewiki-step7-error" => "Cannot copy starter database for language!",
	"requestwiki-filter-language" => "kh,kp,mu,als,an,ast,de-form,de-weig,dk,en-gb,ia,ie,ksh,mwl,pdc,pfl,simple,tokipona,tp,zh-cn,zh-hans,zh-hant,zh-hk,zh-mo,zh-my,zh-sg,zh-tw",
// task
	"autocreatewiki-protect-reason" => 'Part of the official interface',
    "autocreatewiki-welcomesubject" => "$1 has been created!",
    "autocreatewiki-welcomebody" => "Hello, $2,

The Wikia you requested is now available at <$1> We hope to see you editing there soon!

We've added some Information and Tips on your User Talk Page (<$5>) to help you get started.

If you have any problems, you can ask for community help on the wiki at <http://www.wikia.com/wiki/Forum:Help_desk>, or via email to community@wikia.com. You can also visit our live #wikia IRC chat channel <http://irc.wikia.com>.

I can be contacted directly by email or on my talk page, if you have any questions or concerns.

Good luck with the project!

$3

Wikia Community Team

<http://www.wikia.com/wiki/User:$4>",
    "autocreatewiki-welcometalk" => "== Welcome! ==
<div style=\"font-size:120%; line-height:1.2em;\">Hi $1 -- we're excited to have '''$4''' as part of the Wikia community!

Now you've got a whole website to fill up with information, pictures and videos about your favorite topic. But right now, it's just blank pages staring at you... Scary, right? Here are some ways to get started.

* '''Introduce your topic''' on the front page. This is your opportunity to explain to your readers what your topic is all about. Write as much as you want! Your description can link off to all the important pages on your site.

* '''Start some new pages''' -- just a sentence or two is fine to get started. Don't let the blank page stare you down! A wiki is all about adding and changing things as you go along. You can also add pictures and videos, to fill out the page and make it more interesting.

And then just keep going! People like visiting wikis when there's lots of stuff to read and look at, so keep adding stuff, and you'll attract readers and editors. There's a lot to do, but don't worry -- today's your first day, and you've got plenty of time. Every wiki starts the same way -- a little bit at a time, starting with the first few pages, until it grows into a huge, busy site.

If you've got questions, you can e-mail us through our [[Special:Contact|contact form]]. Have fun!

-- [[User:$2|$3]] <staff /></div>",
// new wikis - special page
	"newwikis" => "New wikis",
	"newwikisstart" => "Display wikis starting at:",

// retention emails
	"autocreatewiki-reminder-subject" => "{{SITENAME}}",
	"autocreatewiki-reminder-body" => "
Dear $1:

Congratulations on starting your new wiki, {{SITENAME}}! You can come back and add more to your wiki by visiting $2.

This is a brand-new project, so please write to us if you have any questions!


-- Wikia Community Team",
	"autocreatewiki-reminder-body-HTML" => "
<p>Dear $1:</p>

<p>Congratulations on starting your new wiki, {{SITENAME}}! You can come back and add more to your wiki by visiting
<a href=\"$2\">$2</a>.</p>

<p>This is a brand-new project, so please write to us if you have any questions!</p>

<p>-- Wikia Community Team</p>",
	'autocreatewiki-subname-answers' => 'Answers',
);

/** Message documentation (Message documentation)
 * @author Prima klasy4na
 * @author Siebrand
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'autocreatewiki-desc' => '{{desc}}',
	'autocreatewiki-create-account' => '{{Identical|Create an account}}',
	'autocreatewiki-success-has-been-created' => 'Used as a subtitle to complete the page title, which displays the domain name of the created wiki.',
	'autocreatewiki-info-realname' => '{{Identical|Real name attribution}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'autocreatewiki' => "Skep 'n nuwe Wiki",
	'autocreatewiki-page-title-default' => "Skep 'n nuwe Wiki",
	'createwiki' => "Skep 'n nuwe Wiki",
	'autocreatewiki-chooseone' => 'Kies een',
	'autocreatewiki-required' => '$1 = word vereis',
	'autocreatewiki-web-address' => 'Webtuiste:',
	'autocreatewiki-category-select' => 'Kies een',
	'autocreatewiki-language-top' => 'Top $1 tale',
	'autocreatewiki-language-all' => 'Alle tale',
	'autocreatewiki-birthdate' => 'Dag van geboorte:',
	'autocreatewiki-blurry-word' => 'Wasige woord:',
	'autocreatewiki-remember' => 'Onthou my',
	'autocreatewiki-create-account' => "Skep 'n rekening",
	'autocreatewiki-done' => 'gedoen',
	'autocreatewiki-error' => 'fout',
	'autocreatewiki-success-get-started' => 'Begin',
	'autocreatewiki-info-staff-username' => '<b>Slegs vir personeel:</b> die gespesifiseerde gebruiker sal as die stigter gelys word.',
	'autocreatewiki-empty-field' => 'Voltooi asseblief hierdie veld.',
	'autocreatewiki-invalid-username' => 'Hierdie gebruikersnaam is ongeldig.',
	'autocreatewiki-busy-username' => 'Hierdie gebruikersnaam is reeds geneem.',
	'autocreatewiki-user-notloggedin' => 'U rekening is geskep maar nie ingeteken nie.',
	'autocreatewiki-empty-language' => 'Kies asseblief die Wiki se taal.',
	'autocreatewiki-empty-category' => 'Kies asseblief een van die kategorieë.',
	'autocreatewiki-empty-wikiname' => 'Die naam van die Wiki kan nie leeg wees nie.',
	'autocreatewiki-empty-username' => 'Gebruikersnaam kan nie leeg wees nie.',
	'autocreatewiki-empty-password' => 'Wagwoord kan nie leeg wees nie.',
	'autocreatewiki-empty-retype-password' => 'Herhaling van wagwoord kan nie leeg wees nie.',
	'autocreatewiki-category-other' => 'Ander',
	'autocreatewiki-set-username' => 'Stel eers die gebruikersnaam.',
	'autocreatewiki-invalid-birthday' => 'Ongeldige geboortedatum',
	'autocreatewiki-step2' => 'Besig om databasis te skep...',
	'autocreatewiki-congratulation' => 'Baie geluk!',
	'autocreatewiki-step2-error' => 'Databasis bestaan al!',
	'autocreatewiki-protect-reason' => 'Deel van die amptelike koppelvlak',
	'autocreatewiki-welcomesubject' => '$1 is geskep!',
	'newwikis' => "Nuwe wiki's",
	'newwikisstart' => "Wys wiki's, beginnende by:",
	'autocreatewiki-reminder-subject' => '{{SITENAME}}',
);

/** Arabic (العربية)
 * @author Achraf94
 */
$messages['ar'] = array(
	'autocreatewiki' => 'أنشئ ويكي جديدة',
	'autocreatewiki-desc' => 'أنشأ ويكي في ويكيفاكتوري من قبل طلب المستخدم',
	'autocreatewiki-page-title-default' => 'إنشاء ويكي جديدة',
	'autocreatewiki-page-title-answers' => 'إنشاء موقع إجابات جديد',
	'createwiki' => 'إنشاء ويكي جديد',
	'autocreatewiki-chooseone' => 'إختر واحدة',
	'autocreatewiki-required' => '$1 = مطلوب',
	'autocreatewiki-web-address' => 'عنوان الويب:',
	'autocreatewiki-category-select' => 'إختر واحدة',
	'autocreatewiki-language-top' => ' أحسن $1 لغة',
	'autocreatewiki-language-all' => 'كل اللغات',
	'autocreatewiki-birthdate' => 'تاريخ الميلاد',
	'autocreatewiki-blurry-word' => 'كلمة غامضة:',
	'autocreatewiki-remember' => 'تذكرني',
	'autocreatewiki-create-account' => 'إنشاء حساب',
	'autocreatewiki-done' => 'تم',
	'autocreatewiki-error' => 'خطأ',
	'autocreatewiki-haveaccount-question' => 'هل لديك حساب على ويكيا؟',
	'autocreatewiki-success-title-default' => 'تم إنشاء الويكي !',
	'autocreatewiki-success-title-answers' => 'تم إنشاء موقع الأجوبة!',
	'autocreatewiki-success-subtitle' => 'يمكنك أن تبدأ العمل الآن على ويكي الخاص بك عن طريق زيارة :',
	'autocreatewiki-success-has-been-created' => 'وقد أنشئت!',
	'autocreatewiki-success-get-started' => 'إبدأ',
	'autocreatewiki-info-domain' => 'من الافضل لاستخدام كلمة المحتمل أن تكون كلمة رئيسية للبحث عن الموضوع الخاص بك',
	'autocreatewiki-info-topic' => 'أضف وصفا موجزا مثل "لوست" أو "ناروو".',
	'autocreatewiki-info-category-default' => 'هذا يساعد الزوار على العثور على الويكي التي تنشأها',
	'autocreatewiki-info-category-answers' => 'هذا سوف يساعد الزوار على العثور على موقع الإجابات الذي تنشأه.',
	'autocreatewiki-info-language' => ' ستكون هذه هي اللغة الافتراضية للزوار الويكي الخاص بك',
	'autocreatewiki-info-email-address' => 'بريدك الإلكروني لن يظهر لأي شخص على ويكيا.',
	'autocreatewiki-info-realname' => 'إذا إخترت أن تزود هذه المعلومة فستستعمل في إعطائك الشكر على عملك.',
	'autocreatewiki-info-birthdate' => 'ويكيا تطلب من جميع المستخدمين تقديم تاريخ الولادة الحقيقي على حد سواء وذلك كاجراء وقائي كوسيلة للحفاظ على سلامة الموقع مع الامتثال للقوانين الاتحادية.',
	'autocreatewiki-info-blurry-word' => 'لمساعدة في حماية ضد إنشاء الحساب الآلي ، يرجى كتابة كلمة الباهتة التي تشاهدها في هذا المجال.',
	'autocreatewiki-info-terms-agree' => 'عن طريق إنشاء ويكي و حساب مستخدم، أنت توافق على <a href="http://www.wikia.com/wiki/Terms_of_use">شروط إستخدام ويكيا</a>',
	'autocreatewiki-info-staff-username' => '<b>للموظفين فقط:</b> هذا المستخدم المحدد سيكون مدرجا كمؤسس.',
	'autocreatewiki-limit-day' => 'لقد تجاوزت عدد ويكيا الأقصى لإنشاء الويكيات في هذا اليوم($1).',
	'autocreatewiki-limit-creation' => 'لقد تجاوزت الحد الأقصى لعدد من إنشاء ويكي في 24 ساعة ($1).',
	'autocreatewiki-empty-field' => 'يرجى استكمال هذا المجال.',
	'autocreatewiki-bad-name' => 'هذا الإسم لا يمكنه أن يحتوي على أحرف خاصة (مثل $ أو @)و يجب أن يكون كلمة مفردة بدون مسافات.',
	'autocreatewiki-invalid-wikiname' => 'الإسم لا يمكن أن يحتوي على أحرف خاصة (مثل  $ أو @) و لا يمكن أن يكون فارغا',
	'autocreatewiki-log-title' => 'يتم الآن إنشاء الويكي',
	'autocreatewiki-step0' => 'تهيئة العملية ...',
	'autocreatewiki-welcometalk-log' => 'رسالة ترحيب',
	'autocreatewiki-welcometalk' => "== أهلا و سهلا ! ==
<div style=\"font-size:120%; line-height:1.2em;\"> مرحبا  \$1 -- نحن متحمسون جدا لوجود  '''\$4''' كجزء من مجتمع ويكيا العربية!

الآن لديك الموقع كله لملءه  بالمعلومات والصور وأشرطة الفيديو المفضلة لديك حول الموضوع الخاص بك. ولكن في الوقت الراهن ،  صفحات فارغة فقط تحدق فيك أنت... مخيف جدا ، أليس كذلك؟ فيما يلي بعض الطرق للبدء.

* '''قدم موضوعك''' في الصفحة الرئيسية. هذه فرصتك لفسر للقراء ماهو الموضوع الذي ستكون حوله هذه الويكي. أكتب بقدر ما تستطيع! 

* '''إبدأ بعض الصفحات الجديدة''' -- فقط عبارة أو اثنتين هما كافيتان للبداية. لا تدع الصفحات الفارغة تحبطك! الويكي هي حول الإضافة و تغيير الأشياء كلما تتقدم. يمكنك أيضا إضافة الصور و مقاطع الفيديو، لملأ الصفحات و جعلها جالبة أكثر.

ثم واصل إلى الأمام! الناس يحبون دائما زيارة الويكيات لأنهم لديهم الكثير من الوقت للقراءة و التصفح، لذلك دائما أضف أشياء، و سوف تجلب قراء و محررين. هناك الكثير من الأشياء التي يجب القيام بها لكن لا تقلق -- اليوم هو يومك الأول، و لديك الكثير من الوقت. كل ويكي تبدأ بنفس الطريقة -- مع بعض الوقت، وبداية صفحات جديدة، حتى تنمو و تصبح كبيرة، و موقعا رائعا.

أيضا لا تنسى زيارة موقع [[w:c:ar|ويكيا العربية]] للمزيد من المعلومات و المساعدة.

-- [[مستخدم:\$2|\$3]] <staff /></div>",
	'newwikis' => 'ويكيات جديدة',
	'autocreatewiki-subname-answers' => 'إجابات',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'autocreatewiki' => 'Стварыць новую вікі',
	'autocreatewiki-page-title-default' => 'Стварыць новую вікі',
	'autocreatewiki-language-all' => 'Усе мовы',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Spiritia
 */
$messages['bg'] = array(
	'autocreatewiki' => 'Създаване на ново уики',
	'autocreatewiki-page-title-default' => 'Заявка за ново уики',
	'createwiki' => 'Създаване на уики',
	'autocreatewiki-web-address' => 'Уеб адрес:',
	'autocreatewiki-language-all' => 'Всички езици',
	'autocreatewiki-birthdate' => 'Дата на раждане:',
	'autocreatewiki-done' => 'готово',
	'autocreatewiki-error' => 'грешка',
	'autocreatewiki-bad-name' => 'Името не може да съдържа специални символи (като $ или @) и е необходимо да е една дума, изписана с малки букви и без интервали.',
	'autocreatewiki-violate-policy' => 'Името на уикито съдържа дума, която нарушава политиката ни за наименуване',
	'autocreatewiki-name-taken' => 'Уики с такова име вече съществува. Каним ви да се присъедините към нас в <a href="http://$1.wikia.com">http://$1.wikia.com</a>',
	'autocreatewiki-name-too-short' => 'Това име е твърде късо. Моля, изберете име, състоящо се от най-малко 3 знака.',
	'autocreatewiki-name-too-long' => 'Това име е твърде дълго. Моля, изберете име, състоящо се от най-много 50 знака.',
	'autocreatewiki-similar-wikis' => 'По-долу са уикитата на тази тема, които вече съществуват. Обмислете да допринасяте към някое от тях.',
	'autocreatewiki-invalid-username' => 'Това потребителско име е невалидно.',
	'autocreatewiki-busy-username' => 'Избраното потребителско име е вече заето.',
	'autocreatewiki-congratulation' => 'Поздравления!',
	'autocreatewiki-step2-error' => 'Базата данни съществува!',
	'newwikis' => 'Нови уикита',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Gwenn-Ael
 * @author Y-M D
 */
$messages['br'] = array(
	'autocreatewiki' => 'Krouiñ ur Wiki nevez.',
	'autocreatewiki-desc' => 'Krouiñ ur wiki er WikiFactory dre rekedoù implijerien',
	'autocreatewiki-page-title-default' => 'Krouiñ ur wiki nevez',
	'autocreatewiki-page-title-answers' => "Krouiñ ul lec'hienn respontoù nevez",
	'createwiki' => 'Krouiñ ur Wiki nevez',
	'autocreatewiki-chooseone' => 'Dibab unan',
	'autocreatewiki-required' => '$1 = dre ret',
	'autocreatewiki-web-address' => "Chomlec'h web :",
	'autocreatewiki-category-select' => 'Diuzañ unan',
	'autocreatewiki-language-top' => 'Ar $1 yezh implijetañ',
	'autocreatewiki-language-all' => 'An holl yezhoù',
	'autocreatewiki-birthdate' => 'Deiziad ganedigezh :',
	'autocreatewiki-blurry-word' => 'Gerioù dispis  :',
	'autocreatewiki-remember' => "Derc'hel soñj ac'hanon",
	'autocreatewiki-create-account' => 'Krouiñ ur gont',
	'autocreatewiki-done' => 'graet',
	'autocreatewiki-error' => 'fazi',
	'autocreatewiki-language-top-list' => 'de,en,es,he,fr,it,ja,no,pl,pt,pt-br,zh',
	'autocreatewiki-haveaccount-question' => 'Hag ur gont Wikia ho peus dija ?',
	'autocreatewiki-success-title-default' => 'Krouet eo bet ho wiki !',
	'autocreatewiki-success-title-answers' => "Krouet eo bet ho lec'hienn respontoù.",
	'autocreatewiki-success-subtitle' => 'Gellout a rit kregiñ da labourat war ho wiki en ur weladenniñ :',
	'autocreatewiki-success-has-been-created' => 'a zo bet krouet !',
	'autocreatewiki-success-get-started' => 'Kregiñ',
	'autocreatewiki-info-domain' => "Ar gwellañ zo implijout ur ger a vo, evit doare, ur ger-alc'hwez evit klask diwar-benn ho tanvez.",
	'autocreatewiki-info-topic' => 'Ouzhpennañ un deskrivadur evel « Brezel ar Stered » pe « Abadenn skinwel ».',
	'autocreatewiki-info-category-default' => 'Sikour a raio an dra-mañ ar weladennerien da gavout ho wiki.',
	'autocreatewiki-info-category-answers' => "Sikour a raio an dra-mañ ar weladennerien da gavout ho lec'hienn Respontoù.",
	'autocreatewiki-info-language' => "An dra-se a c'hall bezañ ar yezh dre ziouer evit an dud a zeu da welet ho wiki.",
	'autocreatewiki-info-email-address' => "Morse ne vez diskouezet ho chomlec'h da zen ebet war wiki.",
	'autocreatewiki-info-realname' => "Ma tibabit reiñ ho kwir anv e vo implijet evit reiñ ho labour deoc'h.",
	'autocreatewiki-info-birthdate' => "Goulenn a ra Wikia digant an implijerien reiñ o deiziad ganedigezh gwirion evel doare gwareziñ hag evel doare diwall anterinder al lec'hienn en ur sevel a-du gant reolennoù kevredadel ar Stadoù-Unanet.",
	'autocreatewiki-info-blurry-word' => "Evit sikour ac'hanomp d'en em wareziñ a-enep krouiñ emgefreek kontoù, biskrivit ar ger dispis a welit er vaezienn-mañ.",
	'autocreatewiki-info-terms-agree' => 'Pa vez krouet ur wiki hag ur gont implijer ez asantit da <a href="http://www.wikia.com/wiki/Terms_of_use"> amplegadoù implijout Wiki</a>.',
	'autocreatewiki-info-staff-username' => '<b>Skipailh hepken:</b> an implijer spisaet a dremeno da ziazezer ar wiki.',
	'autocreatewiki-title-template' => 'Wiki $1',
	'autocreatewiki-limit-day' => 'Aet eo Wikia dreist bevenn krouiñ ar wikioù nevez hiziv ($1).',
	'autocreatewiki-limit-creation' => "Aet oc'h dreist bevenn uhelañ ar c'hrouiñ wiki dindan 24 eurvezh ($1).",
	'autocreatewiki-empty-field' => 'Mar plij leunit an takad-mañ.',
	'autocreatewiki-bad-name' => 'An anv zo da bezañ skrivet gant lizherennoù bihan, hep esaouennoù hag hep arouezennoù dibar (evel $ hag @).',
	'autocreatewiki-invalid-wikiname' => "Ne c'haller ket skrivañ an anv gant arouezennoù dibar (evel \$ hag @) ha ne c'hall ket bezañ goullo.",
	'autocreatewiki-violate-policy' => 'Un anv zo er wiki-se a dorr hor politikerezh a-fet reiñ anvioù.',
	'autocreatewiki-name-taken' => 'Ur wiki gant an anv-se zo anezhañ dija. Kit da welet war <a href="http://$1.wikia.com">http://$1.wikia.com</a>',
	'autocreatewiki-name-too-short' => "Re verr eo an anv-mañ, rankout a ra bezañ 3 araouezenn d'an nebeutañ.",
	'autocreatewiki-name-too-long' => "Re hir eo an anv-se. Dibabit, mar plij, un anv gant 50 arouezenn d'ar muiañ.",
	'autocreatewiki-similar-wikis' => "Ur roll wikioù krouet war an hevelep danvez zo diskwelet amañ dindan. Kinnig a reomp deoc'h mont war unan anezho.",
	'autocreatewiki-invalid-username' => "N'eo ket mat an anv-implijer-mañ.",
	'autocreatewiki-busy-username' => 'Kemeret eo an anv implijer dija.',
	'autocreatewiki-blocked-username' => "Ne c'heloc'h ket krouiñ ur gont.",
	'autocreatewiki-user-notloggedin' => "Krouet eo bet ho kont met n'oc'h ket kevreet !",
	'autocreatewiki-empty-language' => 'Dibabit yezh ar wiki, mar plij.',
	'autocreatewiki-empty-category' => 'Mar plij dibabit ur rummad.',
	'autocreatewiki-empty-wikiname' => "Goullo ne c'hall ket bezañ anv ar wiki.",
	'autocreatewiki-empty-username' => "Goullo ne c'hall ket bezañ an anv implijer.",
	'autocreatewiki-empty-password' => "Ne c'hell ket bezañ goullo ar ger tremen",
	'autocreatewiki-empty-retype-password' => "Goullo ne c'hall ket ar ger-tremen adlakaet bezañ",
	'autocreatewiki-category-label' => 'Rummad :',
	'autocreatewiki-category-other' => 'All',
	'autocreatewiki-set-username' => 'Termenit an anv implijer da gentañ.',
	'autocreatewiki-invalid-category' => 'Talvoud direizh evit ar rummad. Dibabit un talvoud er roll, mar plij.',
	'autocreatewiki-invalid-language' => 'Yezh direizh evit ar rummad. Dibabit ur yezh er roll, mar plij.',
	'autocreatewiki-invalid-retype-passwd' => 'Skrivit ar ger-tremen amañ a-us, mar plij.',
	'autocreatewiki-invalid-birthday' => 'Deiziad ganedigezh direizh',
	'autocreatewiki-limit-birthday' => "Ne c'haller ket krouiñ an enrolladenn.",
	'autocreatewiki-log-title' => 'Dindan krouiñ eo ho wiki.',
	'autocreatewiki-step0' => 'Adderaouekaat...',
	'autocreatewiki-stepdefault' => 'An argerzh zo dindan seveniñ , gortozit...',
	'autocreatewiki-errordefault' => "N'eo ket echu an argerzh...",
	'autocreatewiki-step1' => 'Krouiñ renkell ar skeudennoù...',
	'autocreatewiki-step2' => 'O krouiñ an diaz roadennoù...',
	'autocreatewiki-step3' => 'Ouzhpennañ titouroù dre ziouer war an diaz roadennoù...',
	'autocreatewiki-step4' => 'Eilañ ar skeudennoù dre ziouer hag al logo...',
	'autocreatewiki-step5' => 'Ouzhpennañ argemmennoù dre ziouer an diaz roadennoù...',
	'autocreatewiki-step6' => 'Ouzhpennañ an taolennoù dre ziouer en diaz roadennoù...',
	'autocreatewiki-step7' => 'Ouzhpennañ diazoù evit ar yezh...',
	'autocreatewiki-step8' => 'Ouzhpennañ strolladoù implijerien ha rummadoù...',
	'autocreatewiki-step9' => 'Ouzhpennañ argemmennoù ar wiki nevez...',
	'autocreatewiki-step10' => 'Ouzhpennañ pajennoù er wiki kreiz...',
	'autocreatewiki-step11' => "Kas ar postel d'an implijer...",
	'autocreatewiki-redirect' => 'Adkas war-du ar wiki nevez : $1 ...',
	'autocreatewiki-congratulation' => "Gourc'hemennoù !",
	'autocreatewiki-welcometalk-log' => 'Kemenadenn Degemer',
	'autocreatewiki-regex-error-comment' => 'implijet er wiki $1 (skrid  klok : $2)',
	'autocreatewiki-step2-error' => 'Bez ez eus eus an diaz roadennoù-se !',
	'autocreatewiki-step3-error' => "Ne c'haller ket ouzhpennañ an titouroù dre ziouer en diaz roadennoù !",
	'autocreatewiki-step6-error' => "Ne c'haller ket ouzhpennañ an taolennoù dre ziouer en diaz roadennoù !",
	'autocreatewiki-step7-error' => "Ne c'haller ket  eilañ an diaz roadenneoù diazez evit ar ar yezh-mañ !",
	'autocreatewiki-protect-reason' => 'Darn eus an etrefas ofisiel',
	'autocreatewiki-welcomesubject' => 'Krouet eo bet $1 !',
	'autocreatewiki-welcomebody' => "Demat, $2,

Ar Wikia zo bet goulennet ganeoc'h a c'haller kaout bremañ war <$1> Emichañ ez adkavimp ac'hanoc'h er c'hemmoù a-benn nebeut !

Ouzhpennet hon eus un nebeut titouroù war ho pajenn eskemm (<$5>) evit sikour ac'hanoc'h da gregiñ.

M'hoc'h eus goulennoù c'hoazh e c'hallit goulenn sikour ouzh ar gumuniezh war ar wiki <http://www.wikia.com /wiki/Forum:Help_desk>, pe dre bostel d'ar chomlec'h community@wikia.com. Gallout a rit respont pe sellet ouzh hor pajennoù skoazell : <http://irc.wikia.com>.

Grit berzh en hor raktres .


$3

Skipailh Kumuniezh Wikia

<http://www.wikia.com/wiki/User:$4>",
	'autocreatewiki-welcometalk' => "== Degemer mat ! ==
<div style=\"font-size:120%; line-height:1.2em;\">Bonjour \$1 -- lorc'h zo ennomp oc'h herberc'hiañ ho lec'hienn '''\$4''' er gumuniezh  Wiki!

Bremañ ho peus ul lec'hienn Genrouedad a vo ret kargañ gant titouroù, skeudennoù ha videoioù. Goullo eo  bremañ avat ha gortoz a ra ac'hanout... Aon ho peus rak se ? Setu un nebeud alioù evit kregiñ mat ganti.

* '''Deskrivit' an danvez''' war ar bajenn zegemer. Gant se e c'hallit displegañ d'ho lennerien peseurt danvezioù a blij deoc'h ar gwellañ. Skrivit kement tra ho peus c'hoant ! Gallout a rit krouiñ liammoù en ho teskrivadur war-du holl bajennoù pouezus ho wiki.

* '''Boulc'hit un nebeud pajennoù''' --  gant un nebeud frazennoù hepken evit kregiñ ganti. Na lezit pajenn wenn ebet ! Graet eo ur wiki ivez evit ouzhpennañ  skeudennoù ha videoioù, evit klokaat ar pajennoù ha lakaat anezho da vezañ dedennusoc'h.

Ha kendalc'hit goude ! Plijout a ra d'an dud mont war ar wikioù ma vez traoù da lenn, kendalc'hit neuze da skrivañ warno evit dedennañ al lennerien hag an embannerien. Kalz a draoù a chom d'ober -- ne rit ket biloù -- hiziv emañ an deiz kentañ, ha kalz amzer ho peus evit en ober. An holl wikioù zo bet krouet deiz pe zeiz -- ur pennad amzer zo ezhomm evit kregiñ da skrivañ un nebeud pajennoù, betek dont da vezañ ul lec'hienn vras

M'ho peus goulennoù da sevel e c'hallit skrivañ ur gerig dimp war ar bajenn  [[Special:Contact|contact form]]-mañ. Hetiñ a reomp kalz a blijadur deoc'h !

-- [[User:\$2|\$3]] <staff /></div>",
	'newwikis' => 'Wikioù nevez',
	'newwikisstart' => 'Diskouez ar Wikioù adal :',
	'autocreatewiki-reminder-body' => "$1 ker :

Plijet omp o c'houzout hoc'h eus da sevel ho wiki nevez, {{SITENAME}} ! Gourc'hemennoù ! Gallout a rit distreiñ warni hag ouzhpennañ traoù all war ho wiki en ur weladenniñ $2.

Ur raktres nevez-flamm an hini eo. Skrivit dimp, mar plij, m'hoc'h eus tra goulenn pe c'houlenn !

-- Skipailh ar gumuniezh Wikia",
	'autocreatewiki-reminder-body-HTML' => "<p>$1 ker :</p>

<p>Plijet omp o c'houzout hoc'h eus kroget da sevel ho wiki nevez, {{SITENAME}} ! Gourc'hemennoù ! Gallout a rit distreiñ warni hag ouzhpennañ traoù all war ho wiki en ur weladenniñ $2.</a>.</p>

<p>Ur raktres nevez-flamm an hini eo. Skrivit dimp, mar plij, m'hoc'h eus tra goulenn pe c'houlenn !</p>

</p>-- Skipailh ar gumuniezh Wikia</p>",
	'autocreatewiki-subname-answers' => 'Respontoù',
);

/** German (Deutsch)
 * @author LWChris
 * @author The Evil IP address
 */
$messages['de'] = array(
	'autocreatewiki' => 'Erstelle ein neues Wiki',
	'autocreatewiki-desc' => 'Erzeugt ein Wiki in WikiFactory nach Benutzeranforderungen',
	'autocreatewiki-page-title-default' => 'Erstelle ein neues Wiki',
	'autocreatewiki-page-title-answers' => 'Eine neue Answers-Seite erstellen',
	'createwiki' => 'Neues Wiki erstellen',
	'autocreatewiki-chooseone' => 'Bitte wählen',
	'autocreatewiki-required' => '$1 = notwendige Angabe',
	'autocreatewiki-web-address' => 'Web-Adresse:',
	'autocreatewiki-category-select' => 'Bitte wählen',
	'autocreatewiki-language-top' => 'Top-$1 Sprachen',
	'autocreatewiki-language-all' => 'Alle Sprachen',
	'autocreatewiki-birthdate' => 'Geburtsdatum:',
	'autocreatewiki-blurry-word' => 'Spam-Schutz:',
	'autocreatewiki-remember' => 'Dauerhaft anmelden',
	'autocreatewiki-create-account' => 'Benutzerkonto erstellen',
	'autocreatewiki-done' => 'Fertig',
	'autocreatewiki-error' => 'Fehler',
	'autocreatewiki-haveaccount-question' => 'Hast du bereits ein Benutzerkonto bei Wikia?',
	'autocreatewiki-success-title-default' => 'Dein Wiki wurde erstellt!',
	'autocreatewiki-success-title-answers' => 'Deine Answers Seite wurde erstellt!',
	'autocreatewiki-success-subtitle' => 'Du kannst sofort in deinem Wiki loslegen - besuche einfach:',
	'autocreatewiki-success-has-been-created' => 'wurde erstellt!',
	'autocreatewiki-success-get-started' => 'Auf gehts!',
	'autocreatewiki-info-domain' => 'Verwende am besten ein Wort, das vermutlich als Suchbegriff für dieses Thema verwendet wird.',
	'autocreatewiki-info-topic' => 'Wähle am besten einen kurzen, beschreibenden Namen (z. B. „Star Wars“ oder „Fernsehserien“).',
	'autocreatewiki-info-category-default' => 'Besucher können so dein Wiki einfacher finden.',
	'autocreatewiki-info-category-answers' => 'Besucher können so deine Answers Seite einfacher finden.',
	'autocreatewiki-info-language' => 'Dies wird die Standard-Sprache für Besucher deines Wikis.',
	'autocreatewiki-info-email-address' => 'Deine E-Mail-Adresse wird niemandem angezeigt.',
	'autocreatewiki-info-realname' => 'Damit kann dein bürgerlicher Name deinen Beiträgen zugeordnet werden.',
	'autocreatewiki-info-birthdate' => 'Wikia verlangt von allen Nutzern, ihr wahres Geburtsdatum anzugeben, sowohl als Sicherheitsmaßnahme, als auch als Mittel zur Wahrung der Integrität der Website unter Einhaltung der behördlichen Vorschriften.',
	'autocreatewiki-info-blurry-word' => 'Um die automatische Erstellung von Benutzerkonten zu verhindern, tippe bitte das verschwommene Wort ein.',
	'autocreatewiki-info-terms-agree' => 'Mit Erstellung eines Wikis und eines Benutzerkontos stimmst du Wikias <a href="http://www.wikia.com/wiki/Terms_of_use">Nutzungsbedingungen</a> zu.',
	'autocreatewiki-info-staff-username' => '<b>Nur für Mitarbeiter:</b> Der angegebene Benutzer wird als Gründer aufgeführt.',
	'autocreatewiki-title-template' => '$1 Wiki',
	'autocreatewiki-limit-day' => 'Wikia hat die maximale Anzahl von Wiki-Erstellungen für heute überschritten ($1).',
	'autocreatewiki-limit-creation' => 'Du hast die maximale Anzahl an Wikis überschritten, die in 24 Stunden erstellt werden können ($1).',
	'autocreatewiki-empty-field' => 'Fülle bitte dieses Feld aus.',
	'autocreatewiki-bad-name' => 'Der Name darf keine Sonderzeichen (wie $ oder @) enthalten und muss ein einzelnes Wort in Kleinbuchstaben ohne Leerzeichen sein.',
	'autocreatewiki-invalid-wikiname' => 'Der Name darf keine Sonderzeichen (wie $ oder @) enthalten und darf nicht leer sein',
	'autocreatewiki-violate-policy' => 'Im Wiki-Namen ist ein Wort enthalten, dass unseren Namens-Regeln nicht entspricht',
	'autocreatewiki-name-taken' => 'Ein Wiki mit diesem Namen existiert bereits. Du bist herzlich eingeladen, dich unter <a href="http://$1.wikia.com">http://$1.wikia.com</a> zu beteiligen',
	'autocreatewiki-name-too-short' => 'Dieser Name ist zu kurz, bitte wähle einen mit mindestens 3 Buchstaben.',
	'autocreatewiki-name-too-long' => 'Dieser Name ist zu lang. Bitte wähle einen Namen mit maximal 50 Zeichen.',
	'autocreatewiki-similar-wikis' => 'Unten sind die Wikis zu diesem Thema, die bereits erstellt wurden. Wir schlagen vor, dass du dich dort beteiligst.',
	'autocreatewiki-invalid-username' => 'Dieser Benutzername ist ungültig.',
	'autocreatewiki-busy-username' => 'Dieser Benutzername existiert bereits.',
	'autocreatewiki-blocked-username' => 'Du darfst kein Benutzerkonto anlegen.',
	'autocreatewiki-user-notloggedin' => 'Dein Konto wurde erstellt aber nicht eingeloggt!',
	'autocreatewiki-empty-language' => 'Wähle bitte eine Sprache für dein Wiki.',
	'autocreatewiki-empty-category' => 'Bitte wähle eine Kategorie.',
	'autocreatewiki-empty-wikiname' => 'Bitte gib deinem Wiki einen Namen.',
	'autocreatewiki-empty-username' => 'Bitte gib einen Benutzernamen an.',
	'autocreatewiki-empty-password' => 'Das Passwort darf nicht leer sein.',
	'autocreatewiki-empty-retype-password' => 'Das Passwort darf nicht leer sein.',
	'autocreatewiki-category-label' => 'Kategorie:',
	'autocreatewiki-category-other' => 'Andere',
	'autocreatewiki-set-username' => 'Wähle zuerst einen Benutzernamen.',
	'autocreatewiki-invalid-category' => 'Ungültige Kategorie-Auswahl.
Bitte wähle eine Kategorie aus der Liste.',
	'autocreatewiki-invalid-language' => 'Ungültige Sprach-Auswahl.
Bitte wähle eine Sprache aus der Liste.',
	'autocreatewiki-invalid-retype-passwd' => 'Bitte gib das gleiche Passwort wie oben ein',
	'autocreatewiki-invalid-birthday' => 'Ungültiges Geburtsdatum',
	'autocreatewiki-limit-birthday' => 'Eine Registrierung ist nicht möglich - wende dich bitte an Wikia.',
	'autocreatewiki-log-title' => 'Dein Wiki wird erstellt',
	'autocreatewiki-step0' => 'Initialisiere Prozess ...',
	'autocreatewiki-stepdefault' => 'Prozess läuft, bitte warten ...',
	'autocreatewiki-errordefault' => 'Der Prozess wurde nicht beendet ...',
	'autocreatewiki-step1' => 'Erstelle Bilder-Ordner ...',
	'autocreatewiki-step2' => 'Erstelle Datenbank ...',
	'autocreatewiki-step3' => 'Initialisiere Datenbank-Informationen ...',
	'autocreatewiki-step4' => 'Übertrage Logo und Standard-Bilder ...',
	'autocreatewiki-step5' => 'Initialisiere Datenbank-Variablen ...',
	'autocreatewiki-step6' => 'Initialisiere Datenbank-Tabellen ...',
	'autocreatewiki-step7' => 'Übertrage Sprach-Basisversion ...',
	'autocreatewiki-step8' => 'Erstelle Benutzer-Gruppen und Kategorien ...',
	'autocreatewiki-step9' => 'Anpassung der Variablen ...',
	'autocreatewiki-step10' => 'Erstelle Seiten im Zentral-Wikia ...',
	'autocreatewiki-step11' => 'Sende E-Mail an Benutzer ...',
	'autocreatewiki-redirect' => 'Weiterleitung zum neuen Wiki: $1 ...',
	'autocreatewiki-congratulation' => 'Glückwunsch!',
	'autocreatewiki-welcometalk-log' => 'Willkommensnachricht',
	'autocreatewiki-regex-error-comment' => 'verwendet in Wiki $1 (ganzer Text: $2)',
	'autocreatewiki-step2-error' => 'Datenbank existiert bereits!',
	'autocreatewiki-step3-error' => 'Initialisierung der Datenbank-Informationen fehlgeschlagen!',
	'autocreatewiki-step6-error' => 'Initialisierung der Datenbank-Tabellen fehlgeschlagen!',
	'autocreatewiki-step7-error' => 'Fehler beim Übertragen der Sprach-Basisversion!',
	'autocreatewiki-protect-reason' => 'Teil der offiziellen Oberfläche',
	'autocreatewiki-welcomesubject' => '$1 wurde erstellt!',
	'autocreatewiki-welcomebody' => 'Hallo $2,

Das von dir erstellte Wikia ist nun unter <$1> erreichbar. Hoffentlich sehen wir dich bald dort editieren!

Wir haben auf deiner Diskussionsseite (<$5>) ein paar Informationen und Tipps für den Start hinterlassen.

Falls du irgendwelche Probleme hast, kannst du unter <http://de.wikia.com/wiki/Forum:Übersicht> die Gemeinschaft um Hilfe bitten oder dich per E-Mail an community@wikia.com wenden. Du kannst auch unseren #wikia IRC-Channel besuchen <http://irc.wikia.com>.

Falls du noch weitere Fragen oder Probleme hast, kannst du dich auch direkt per Mail oder Diskussionsseite an mich wenden.

Viel Erfolg mit deinem Projekt!

$3

Wikia Community Team

<http://de.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => "== Willkommen! ==
<div style=\"font-size:120%; line-height:1.2em;\">Hi \$1 -- wir freuen uns, dass '''\$4''' jetzt Teil der Wikia-Gemeinschaft ist!

Jetzt hast du eine ganze Webseite, die du mit Informationen, Bildern und Videos über dein Lieblingsthema füllen kannst. Aber im Moment gibt es nur leere Seiten, die dich anstarren... Gruselig, nicht wahr? Hier einige Anregungen, wie du anfangen kannst.

* '''Stelle dein Thema vor''' - auf der Hauptseite. Diese Seite ist deine Chance, den Lesern alles über dein Thema zu verraten. Schreib so viel du willst! Deine Beschreibung kann zu allen wichtigen Seiten im Wiki verlinken.

* '''Erstelle einige neue Seiten''' - nur ein oder zwei Sätze um anzufangen. Lass dich nicht von den leeren Seiten unterkriegen! In einem Wiki werden laufend Dinge hinzugefügt oder verändert. Du kannst auch Bilder und Videos auf die Hauptseite packen um sie zu füllen und interessanter zu machen.

Und im Anschluss mach einfach weiter! Leute mögen große Wikis, in denen man viel entdecken kann. Also füg weiterhin Inhalte hinzu, und du wirst neue Leser und Benutzer anziehen. Es gibt viel zu tun, aber sei unbesorgt - heute ist dein erster Tag, und du hast genügend Zeit. Jedes Wiki fängt auf dieselbe Weise an - es braucht nur ein bisschen Zeit, und nach den ersten paar Seiten, und einer Weile wird das Wiki zu einer großen, häufig besuchten Seite anwachsen.

Wenn du Fragen hast, kannst du uns eine Mail über unser [[Special:Contact|Kontaktformular]] schreiben. Viel Spaß!

-- [[User:\$2|\$3]] <staff /></div>",
	'newwikis' => 'Neue Wikis',
	'newwikisstart' => 'Zeige Wikis ab:',
	'autocreatewiki-reminder-body' => 'Hallo $1,

Herzlichen Glückwunsch zu deinem neuen Wiki, {{SITENAME}}! Du kannst zurückkommen und mehr zu deinem Wiki hinzufügen indem du $2 besuchst.

Dies ist ein brandneues Projekt, wenn du also Fragen hast, lass sie uns wissen!


-- Wikia Community Team',
	'autocreatewiki-reminder-body-HTML' => '<p>Hallo $1,</p>

<p>Herzlichen Glückwunsch zu deinem neuen Wiki, {{SITENAME}}! Du kannst zurückkommen und mehr zu deinem Wiki hinzufügen
indem du <a href="$2">$2</a> besuchst.</p>

<p>Dies ist ein brandneues Projekt, wenn du also Fragen hast, lass sie uns wissen!</p>

<p>-- Wikia Community Team</p>',
	'autocreatewiki-subname-answers' => 'Antworten',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author LWChris
 * @author The Evil IP address
 */
$messages['de-formal'] = array(
	'autocreatewiki' => 'Ein neues Wiki erstellen',
	'autocreatewiki-page-title-default' => 'Ein neues Wiki erstellen',
	'autocreatewiki-haveaccount-question' => 'Haben Sie bereits ein Benutzerkonto bei Wikia?',
	'autocreatewiki-success-title-default' => 'Ihr Wiki wurde erstellt!',
	'autocreatewiki-success-title-answers' => 'Ihre Answers Seite wurde erstellt!',
	'autocreatewiki-success-subtitle' => 'Sie können sofort in Ihrem Wiki loslegen - besuchen Sie einfach:',
	'autocreatewiki-info-domain' => 'Verwenden Sie am besten ein Wort, das vermutlich als Suchbegriff für dieses Thema verwendet wird.',
	'autocreatewiki-info-topic' => 'Wählen Sie am besten einen kurzen, beschreibenden Namen (z. B. „Star Wars“ oder „Fernsehserien“).',
	'autocreatewiki-info-category-default' => 'Besucher können so Ihr Wiki einfacher finden.',
	'autocreatewiki-info-category-answers' => 'Besucher können so Ihre Answers Seite einfacher finden.',
	'autocreatewiki-info-language' => 'Dies wird die Standard-Sprache für Besucher Ihres Wikis.',
	'autocreatewiki-info-email-address' => 'Ihre E-Mail-Adresse wird niemandem angezeigt.',
	'autocreatewiki-info-realname' => 'Damit kann Ihr bürgerlicher Name Ihren Beiträgen zugeordnet werden.',
	'autocreatewiki-info-terms-agree' => 'Mit Erstellung eines Wikis und eines Benutzerkontos stimmen Sie Wikias <a href="http://www.wikia.com/wiki/Terms_of_use">Nutzungsbedingungen</a> zu.',
	'autocreatewiki-limit-creation' => 'Sie haben die maximale Anzahl an Wikis überschritten, die in 24 Stunden erstellt werden können ($1).',
	'autocreatewiki-empty-field' => 'Füllen Sie bitte dieses Feld aus.',
	'autocreatewiki-name-taken' => 'Ein Wiki mit diesem Namen existiert bereits. Sie sind herzlich eingeladen, sich unter <a href="http://$1.wikia.com">http://$1.wikia.com</a> zu beteiligen',
	'autocreatewiki-name-too-short' => 'Dieser Name ist zu kurz, bitte wählen Sie einen mit mindestens 3 Buchstaben.',
	'autocreatewiki-name-too-long' => 'Dieser Name ist zu lang. Bitte wählen Sie einen Namen mit maximal 50 Zeichen.',
	'autocreatewiki-similar-wikis' => 'Unten sind die Wikis zu diesem Thema, die bereits erstellt wurden. Wir schlagen vor, dass Sie sich dort beteiligen.',
	'autocreatewiki-blocked-username' => 'Sie dürfen kein Benutzerkonto anlegen.',
	'autocreatewiki-user-notloggedin' => 'Ihr Konto wurde erstellt aber nicht eingeloggt!',
	'autocreatewiki-empty-language' => 'Wählen Sie bitte eine Sprache für Ihr Wiki.',
	'autocreatewiki-empty-category' => 'Bitte wählen Sie eine Kategorie.',
	'autocreatewiki-empty-wikiname' => 'Bitte geben Sie Ihrem Wiki einen Namen.',
	'autocreatewiki-empty-username' => 'Bitte geben Sie einen Benutzernamen an.',
	'autocreatewiki-set-username' => 'Wählen Sie zuerst einen Benutzernamen.',
	'autocreatewiki-invalid-category' => 'Ungültige Kategorie-Auswahl.
Bitte wählen Sie eine Kategorie aus der Liste.',
	'autocreatewiki-invalid-language' => 'Ungültige Sprach-Auswahl.
Bitte wählen Sie eine Sprache aus der Liste.',
	'autocreatewiki-invalid-retype-passwd' => 'Bitte geben Sie das gleiche Passwort wie oben ein',
	'autocreatewiki-limit-birthday' => 'Eine Registrierung ist nicht möglich - wenden Sie sich bitte an Wikia.',
	'autocreatewiki-log-title' => 'Ihr Wiki wird erstellt',
	'autocreatewiki-welcomebody' => 'Hallo $2,

Das von Ihnen erstellte Wikia ist nun unter <$1> erreichbar. Hoffentlich sehen wir Sie bald dort editieren!

Wir haben auf Ihrer Diskussionsseite (<$5>) ein paar Informationen und Tipps für den Start hinterlassen.

Falls Sie irgendwelche Probleme haben, können Sie unter <http://de.wikia.com/wiki/Forum:Übersicht> die Gemeinschaft um Hilfe bitten oder sich per E-Mail an community@wikia.com wenden. Sie können auch unseren #wikia IRC-Channel besuchen <http://irc.wikia.com>.

Falls Sie noch weitere Fragen oder Probleme haben, können Sie sich auch direkt per Mail oder Diskussionsseite an mich wenden.

Viel Erfolg mit Ihrem Projekt!

$3

Wikia Community Team

<http://de.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => "== Willkommen! ==
<div style=\"font-size:120%; line-height:1.2em;\">Hallo \$1 -- wir freuen uns, dass '''\$4''' jetzt Teil der Wikia-Gemeinschaft ist!

Jetzt haben Sie eine ganze Webseite, die Sie mit Informationen, Bildern und Videos über dein Lieblingsthema füllen können. Aber im Moment gibt es nur leere Seiten... Unheimlich? Hier einige Anregungen, wie Sie anfangen können.

* '''Stellen Sie Ihr Thema vor''' - auf der Hauptseite. Diese Seite ist Ihre Chance, den Lesern alles über Ihr Thema zu verraten. Schreiben Sie so viel Sie wollen! Ihre Beschreibung kann zu allen wichtigen Seiten im Wiki verlinken.

* '''Erstellen Sie einige neue Seiten''' - nur ein oder zwei Sätze um anzufangen. Lassen Sie sich nicht von den leeren Seiten unterkriegen! In einem Wiki werden laufend Dinge hinzugefügt oder verändert. Sie können auch Bilder und Videos auf die Hauptseite packen um sie zu füllen und interessanter zu machen.

Machen Sie im Anschluss einfach weiter! Leute mögen große Wikis, in denen man viel entdecken kann. Fügen Sie also weiterhin Inhalte hinzu, und Sie werden schon bald neue Leser und Benutzer anziehen. Es gibt viel zu tun, aber seien Sie unbesorgt - heute ist Ihr erster Tag, und Sie haben genügend Zeit. Jedes Wiki fängt auf dieselbe Weise an - es braucht nur ein bisschen Zeit, und nach den ersten paar Seiten, und einer Weile wird das Wiki zu einer großen, häufig besuchten Seite anwachsen.

Wenn Sie Fragen haben, können Sie uns eine Mail über unser [[Special:Contact|Kontaktformular]] schreiben. Viel Spaß!

-- [[User:\$2|\$3]] <staff /></div>",
	'autocreatewiki-reminder-body' => 'Hallo $1,

Herzlichen Glückwunsch zu Ihrem neuen Wiki, {{SITENAME}}! Sie können zurückkommen und mehr zu Ihrem Wiki hinzufügen indem Sie $2 besuchen.

Dies ist ein ganz neues Projekt, wenn Sie also Fragen haben, lassen Sie sie uns wissen!


-- Ihr Wikia Community Team',
	'autocreatewiki-reminder-body-HTML' => '<p>Hallo $1,</p>

<p>Herzlichen Glückwunsch zu Ihrem neuen Wiki, {{SITENAME}}! Sie können zurückkommen und mehr zu Ihrem Wiki hinzufügen
indem Sie <a href="$2">$2</a> besuchen.</p>

<p>Dies ist ein ganz neues Projekt, wenn Sie also Fragen haben, lassen Sie sie uns wissen!</p>

<p>-- Ihr Wikia Community Team</p>',
);

/** Ewe (Eʋegbe) */
$messages['ee'] = array(
	'autocreatewiki-create-account' => 'Ŋlɔ ŋkɔ daɖi',
);

/** Greek (Ελληνικά)
 * @author Crazymadlover
 * @author Περίεργος
 */
$messages['el'] = array(
	'autocreatewiki' => 'Δημιουργήστε έναν νέο ιστότοπο τύπου Wiki',
	'autocreatewiki-desc' => 'Δημιουργήστε έναν ιστότοπο τύπου wiki στο WikiFactory από αιτήματα χρηστών',
	'autocreatewiki-page-title-default' => 'Δημιουργήστε έναν καινούργιο ιστότοπο τύπου Wiki',
	'createwiki' => 'Δημιουργήστε έναν ιστότοπο τύπου Wiki',
	'autocreatewiki-chooseone' => 'Διαλέξτε ένα',
	'autocreatewiki-required' => '$1 = απαιτείται',
	'autocreatewiki-web-address' => 'Ηλεκτρονική διεύθυνση:',
	'autocreatewiki-category-select' => 'Επιλέξτε ένα',
	'autocreatewiki-language-top' => 'Οι $1 πιο δημοφιλείς γλώσσες',
	'autocreatewiki-language-all' => 'Όλες οι γλώσσες',
	'autocreatewiki-birthdate' => 'Ημερομηνία γέννησης:',
	'autocreatewiki-remember' => 'Να με θυμάσαι',
	'autocreatewiki-create-account' => 'Δημιουργία λογαριασμού',
	'autocreatewiki-done' => 'έγινε',
	'autocreatewiki-error' => 'σφάλμα',
	'autocreatewiki-haveaccount-question' => 'Έχετε ήδη ένα λογαριασμό Wikia;',
	'autocreatewiki-success-title-default' => 'Το wiki σας έχει δημιουργηθεί!',
	'autocreatewiki-success-subtitle' => 'Μπορείτε τώρα να ξεκινήσετε να δουλεύετε το wiki σας επισκέπτοντας:',
	'autocreatewiki-success-has-been-created' => 'έχει δημιουργηθεί!',
	'autocreatewiki-success-get-started' => 'Ξεκινήστε',
	'autocreatewiki-info-domain' => 'Καλύτερα να χρησιμοποιήσετε μια λέξη-κλειδί αναζήτησης του θέματός σας.',
	'autocreatewiki-info-topic' => 'Βάλε τε μια σύντομη περιγραφή όπως "Διαδίκτυο" ή "Λογοτεχνεία".',
	'autocreatewiki-info-language' => 'Αυτή θα είναι η προεπιλεγμένη γλώσσα για τους επισκέπτες του wiki σας.',
	'autocreatewiki-info-email-address' => 'Το ηλεκτρονικό σας ταχυδρομείο δεν φαίνεται σε κανέναν στο Wikia.',
	'autocreatewiki-info-realname' => 'Αν το δώσετε, αυτό θα χρησιμοποιηθεί για να σας αποδωθεί η δουλειά σας.',
	'autocreatewiki-info-birthdate' => 'Η Wikia απαιτεί από όλους τους χρήστες να δώσουν την πραγματική ημερομηνία γέννησής τους ως μέτρο ασφάλειας και ως μέσο διατήρησης της ακεραιότητας του ιστότοπου ενόσω συμμορφώνεται με κανονισμούς των Ηνωμένων Πολιτειών Αμερικής.',
	'autocreatewiki-info-blurry-word' => 'Για αποφυγή αυτόματης δημιουργίας λογαριασμού, παρακαλώ πληκτρολογίστε τη θολή λέξη που βλέπετε στο πεδίο.',
	'autocreatewiki-name-too-short' => 'Αυτό το όνομα είναι πολύ μικρό, παρακαλώ διαλέξτε ένα όνομα με τουλάχιστον τρεις χαρακτήρες.',
	'autocreatewiki-invalid-username' => 'Αυτό το όνομα χρήστη δεν είναι έγκυρο.',
	'autocreatewiki-busy-username' => 'Αυτό το όνομα χρήστη υπάρχει ήδη.',
	'autocreatewiki-welcometalk-log' => 'Χαιρετιστήριο Μήνυμα',
);

/** Spanish (Español)
 * @author Bola
 * @author Crazymadlover
 * @author Locos epraix
 * @author Pertile
 * @author Peter17
 * @author Translationista
 */
$messages['es'] = array(
	'autocreatewiki' => 'Crear nuevo Wiki',
	'autocreatewiki-desc' => 'Crear un wiki en WikiFactory a petición de un usuario',
	'autocreatewiki-page-title-default' => 'Crear un nuevo wiki',
	'autocreatewiki-page-title-answers' => 'Crear un nuevo sitio de Respuestas',
	'createwiki' => 'Solicita un nuevo wiki',
	'autocreatewiki-chooseone' => 'Elije una',
	'autocreatewiki-required' => '$1 = requerido',
	'autocreatewiki-web-address' => 'Dirección Web',
	'autocreatewiki-category-select' => 'Selecciona una',
	'autocreatewiki-language-top' => 'Top $1 de idiomas',
	'autocreatewiki-language-all' => 'Todos los idiomas',
	'autocreatewiki-birthdate' => 'Fecha de nacimiento:',
	'autocreatewiki-blurry-word' => 'Palabra borrosa:',
	'autocreatewiki-remember' => 'Recordarme',
	'autocreatewiki-create-account' => 'Crear una Cuenta',
	'autocreatewiki-done' => 'hecho',
	'autocreatewiki-error' => 'error',
	'autocreatewiki-language-top-list' => 'de,en,es,he,fr,it,ja,no,pl,pt,pt-br,zh',
	'autocreatewiki-haveaccount-question' => '¿Tienes ya cuenta en Wikia?',
	'autocreatewiki-success-title-default' => '¡Tu wiki ha sido creado!',
	'autocreatewiki-success-title-answers' => '¡Su sitio de respuestas ha sido creada!',
	'autocreatewiki-success-subtitle' => 'Ya puedes comenzar a trabajar en tu wiki visitando:',
	'autocreatewiki-success-has-been-created' => 'ha sido creado!',
	'autocreatewiki-success-get-started' => 'Comenzar',
	'autocreatewiki-info-domain' => 'Lo mejor es usar las palabras que tengan más posibilidades de ser buscada sobre el tema de tu wiki. Por ejemplo si el tema es una serie de televisión, las palabras serían el nombre de la serie.',
	'autocreatewiki-info-topic' => 'Añade una descripción corta como por ejemplo "Star Wars" o "Series de TV".',
	'autocreatewiki-info-category-default' => 'Esto ayudará a los visitantes a encontrar su wiki.',
	'autocreatewiki-info-category-answers' => 'Esto ayudará a los visitantes a encontrar su sitio de Respuestas.',
	'autocreatewiki-info-language' => 'Este será el idioma por defecto para los visitantes de tu wiki.',
	'autocreatewiki-info-email-address' => 'Tu dirección de email no se mostrará a nadie en Wikia.',
	'autocreatewiki-info-realname' => 'Si optas por proporcionarlo, se usará para dar atribución a tu trabajo.',
	'autocreatewiki-info-birthdate' => 'Wikia solicita a todos los usuarios que pongan su fecha real de nacimiento como una medida de seguridad y como una forma de preservar la integridad del sitio mientras cumple con las regulaciones federales.',
	'autocreatewiki-info-blurry-word' => 'Para ayudar protegernos contra la creación de cuentas automáticas, escribe la palabra borrosa que ves en el campo que hay, por favor.',
	'autocreatewiki-info-terms-agree' => 'Con la creación de un wiki y una cuenta de usuario, aceptas los <a href="http://www.wikia.com/wiki/Terms_of_use">Términos de Uso de Wikia</a>',
	'autocreatewiki-info-staff-username' => '<b>Solamente Staff:</b> El usuario especificado figurará como el fundador del wiki.',
	'autocreatewiki-title-template' => 'Wiki $1',
	'autocreatewiki-limit-day' => 'Wikia ha superado el número máximo de creaciones de wikis de hoy ($1).',
	'autocreatewiki-limit-creation' => 'Has excedido el número máximo de creación de wikis en 24 horas ($1).',
	'autocreatewiki-empty-field' => 'Por favor, completa este campo.',
	'autocreatewiki-bad-name' => 'El nombre no puede contener caracteres especiales (como $ o @) y deben ser palabras simples y sin espacios.',
	'autocreatewiki-invalid-wikiname' => 'El nombre no puede contener caracteres especiales (como $ o @) y el campo no puede estar vacío.',
	'autocreatewiki-violate-policy' => 'El nombre del wiki contiene una palabra que viola nuestra política de nombres',
	'autocreatewiki-name-taken' => 'Ya existe un wiki con ese nombre. Eres bienvenido a participar con nosotros en <a href="http://$1.wikia.com">http://$1.wikia.com</a>',
	'autocreatewiki-name-too-short' => 'Este nombre es demasiado corto, por favor, elige un nombre con al menos 3 caracteres.',
	'autocreatewiki-name-too-long' => 'Este nombre es demasiado largo, por favor, elige un nombre con un máximo de 50 caracteres.',
	'autocreatewiki-similar-wikis' => 'Debajo están los wikis ya creados sobre este tema. Te sugerimos editar en alguno de ellos.',
	'autocreatewiki-invalid-username' => 'Este nombre de usuario no es válido',
	'autocreatewiki-busy-username' => 'Este nombre de usuario ya está en uso.',
	'autocreatewiki-blocked-username' => 'No puedes crear la cuenta.',
	'autocreatewiki-user-notloggedin' => '¡Tu cuenta fue creada, pero no te identificaste!',
	'autocreatewiki-empty-language' => 'Por favor, selecciona el idioma del wiki.',
	'autocreatewiki-empty-category' => 'Por favor, selecciona una de las categorías.',
	'autocreatewiki-empty-wikiname' => 'El campo del nombre del wiki no puede estar vacío.',
	'autocreatewiki-empty-username' => 'El campo del nombre de usuario no puede estar vacío.',
	'autocreatewiki-empty-password' => 'El campo de la contraseña no puede estar vacío.',
	'autocreatewiki-empty-retype-password' => 'El campo para repetir la contraseña no puede estar vacío.',
	'autocreatewiki-category-label' => 'Categoría:',
	'autocreatewiki-category-other' => 'Otro',
	'autocreatewiki-set-username' => 'Pon el nombre de usuario primero.',
	'autocreatewiki-invalid-category' => 'Valor inválido para la categoría. Por favor, selecciona el apropiado desde la lista desplegable de abajo.',
	'autocreatewiki-invalid-language' => 'Valor inválido para el idioma. Por favor, selecciona el apropiado desde la lista desplegable de abajo.',
	'autocreatewiki-invalid-retype-passwd' => 'Escribe la misma contraseña que arriba.',
	'autocreatewiki-invalid-birthday' => 'Fecha de nacimiento inválida',
	'autocreatewiki-limit-birthday' => 'Inhabilitado para crear registros.',
	'autocreatewiki-log-title' => 'Tu wiki está siendo creado',
	'autocreatewiki-step0' => 'Iniciando proceso ...',
	'autocreatewiki-stepdefault' => 'El proceso está en marcha, por favor, espera un poco ...',
	'autocreatewiki-errordefault' => 'El proceso no fue terminado...',
	'autocreatewiki-step1' => 'Creando carpeta de imágenes ...',
	'autocreatewiki-step2' => 'Creando base de datos ...',
	'autocreatewiki-step3' => 'Configurando la información por defecto en la base de datos ...',
	'autocreatewiki-step4' => 'Copiando imágenes y logo por defecto ...',
	'autocreatewiki-step5' => 'Configurando variables por defecto en la base de datos ...',
	'autocreatewiki-step6' => 'Configurando tablas por defecto en la base de datos ...',
	'autocreatewiki-step7' => 'Configurando el idioma del starter ...',
	'autocreatewiki-step8' => 'Configurando grupos de usuarios y categorías ...',
	'autocreatewiki-step9' => 'Configurando las variables para el nuevo wiki ...',
	'autocreatewiki-step10' => 'Configurando páginas de la central de Wikia ...',
	'autocreatewiki-step11' => 'Enviando email al usuario ...',
	'autocreatewiki-redirect' => 'Redirigiendo al nuevo Wiki: $1 ...',
	'autocreatewiki-congratulation' => '¡Felicidades!',
	'autocreatewiki-welcometalk-log' => 'Bienvenida al nuevo sysop',
	'autocreatewiki-regex-error-comment' => 'usados en $1 wiki (texto íntegro: $2)',
	'autocreatewiki-step2-error' => '¡La base de datos ya existe!',
	'autocreatewiki-step3-error' => '¡No se puede configurar la información por defecto en la base de datos!',
	'autocreatewiki-step6-error' => '¡No se pueden configurar las tablas por defecto en la base de datos!',
	'autocreatewiki-step7-error' => '¡No se puede copiar el starter para este idioma en la base de datos!',
	'autocreatewiki-protect-reason' => 'Parte de la interfaz oficial',
	'autocreatewiki-welcomesubject' => '¡$1 ha sido creado!',
	'autocreatewiki-welcomebody' => 'Hola, $2,

El wiki que solicitaste está disponible en <$1> ¡Esperamos verte editando ahí pronto!

Hemos añadido alguna Información y Consejos en tu Página de Discusión de Usuario (<$5>) para ayudarte a comenzar.

Si tienes cualquier problema, puedes preguntar por la comunidad de ayuda en el wiki en <http://es.wikia.com/wiki/Forum:Secci%C3%B3n_de_ayuda>, o vía email a community@wikia.com.

Puedes contactar conmigo directamente por email o en mi página de discusión, si tienes alguna pregunta o inquietud.

¡Buena suerte con el proyecto!

$3

Equipo Comunitario de Wikia

<http://www.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => "== ¡Bienvenidos! ==
<div style=\"font-size:120%; line-height:1.2em;\">Hola \$1 -- nos encanta que '''\$4''' sea parte de la comunidad Wikia!

Ahora tienes un sitio web entero que completar con informaciónm fotos y videos relacionados con tu tema favorito, pero de momento, sólo encontrarás páginas en blanco mirándote fijamente. Tenebroso ¿no? En adelante descubrirás algunas formas de comenzar.

* '''Escribe tu tema''' en la página principal. Esta es tu oportunidad para explicar a tus lectores de qué se trata el asunto. Escribe tanto como quieras. Tu descripción puede contener vínculos a todas las páginas importantes de tu sitio.

* '''Haz nuevas páginas''' -- Para empezar, una o dos oraciones son más que suficientes. ¡No permitas que la página en blanco se quede mirándote! Una wiki consiste en añadir y cambiar cosas con el tiempo. También puedes subir fotos y videos para completar la página y hacerla más interesante.

¡No te detengas! A las personas les gusta visitar wikis que tengan mucho contenido para leer y mirar. Así que sigue añadiendo cosas para atraer a leectores y editores. Hay mucho por hacer, pero no te amilanes. Hoy es apenas tu primer día y tienes mucho tiempo por delante. Cada wiki empieza de la misma manera: un poquito cada vez, comenzando por las primeras páginas hasta que se convierte en un grandísimo y movidísimo sitio.

Si tienes algunas dudas, envíanos un correo electrónico a través de nuestro [[Special:Contact|formulario de contacto]]. ¡Que te diviertas!

-- [[User:\$2|\$3]] <staff /></div>",
	'newwikis' => 'Nuevos wikis',
	'newwikisstart' => 'Mostrar wikis comenzando por:',
	'autocreatewiki-reminder-body' => '
Estimado/a $1,

Felicidades por comenzar tu nuevo wiki, Messaging Wiki! Puedes regresar a tu wiki y añadir más contenido visitando $2.

Esto es un nuevo proyecto de wiki, así que por favor, ¡escríbenos si tienes cualquier pregunta!

-- Equipo Comunitario de Wikia',
	'autocreatewiki-reminder-body-HTML' => '<p>Estimado/a $1,</p>

<p>¡Felicidades por comenzar tu nuevo wiki, {{SITENAME}}! Puedes regresar a tu wiki y añadir más contenido visitando <a href="$2">$2</a>.</p>

<p>Esto es un nuevo proyecto de wiki, así que por favor, ¡escríbenos si tienes cualquier pregunta!</p>

<p>-- Equipo Comunitario de Wikia</p>',
	'autocreatewiki-subname-answers' => 'Respuestas',
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'autocreatewiki' => 'ایجاد ویکی جدید',
	'autocreatewiki-page-title-default' => 'ایجاد ویکی جدید',
	'createwiki' => 'ایجاد ویکی جدید',
	'autocreatewiki-chooseone' => 'یکی را انتخاب کنید',
	'autocreatewiki-web-address' => 'نشانی اینترنتی:',
	'autocreatewiki-category-select' => 'یکی را انتخاب کنید',
	'autocreatewiki-birthdate' => 'تاریخ تولد:',
	'autocreatewiki-blurry-word' => 'لغت نامعلوم:',
	'autocreatewiki-create-account' => 'ایجاد حساب کاربری',
	'autocreatewiki-done' => 'تمام شد',
	'autocreatewiki-error' => 'خطا',
	'autocreatewiki-haveaccount-question' => 'آیا از قبل در ویکیا حساب کاربری دارید؟',
	'autocreatewiki-success-title-default' => 'ویکی شما ایجاد شد!',
	'autocreatewiki-success-subtitle' => 'با مراجعه به نشانی روبرو شما می‌توانید کار بر روی ویکی خود را آغاز کنید:',
	'autocreatewiki-info-domain' => 'بهتر است از کلمه‌ای استفاده کنید که درصد جستجو شدن آن در موضوع ویکی شما زیاد باشد.',
	'autocreatewiki-info-language' => 'این زبان پیش‌فرض ویکی شما خواهد بود.',
	'autocreatewiki-info-email-address' => 'آدرس پست الکترونیکی شما به کاربران ویکیا نمایش داده نخواهد شد.',
	'autocreatewiki-info-birthdate' => 'تمام کاربران ویکیا مستلزم هستند که تاریخ تولد اصلی خود را برای احتیاط و حفظ منافع وب‌گاه در برابر دولت ارائه کنند.',
	'autocreatewiki-info-blurry-word' => 'برای جلوگیری از ایجاد خودکار حساب کاربری، لطفا حروف بالا را در این فیلد وارد کنید.',
	'autocreatewiki-info-terms-agree' => 'با ایجاد ویکی و حساب کاربری شما <a href="http://www.wikia.com/wiki/Terms_of_use">شرایط استفاده از ویکیا</a> را قبول می‌کنید.',
	'autocreatewiki-empty-field' => 'لطفا این فیلد را کامل کنید.',
	'autocreatewiki-bad-name' => 'نام ویکی شامل کاراکترهای مخصوص (مانند $ یا @) نمی‌تواند باشد و باید حروف کوچک انگلیسی بدون فاصله باشد.',
	'autocreatewiki-violate-policy' => 'نام این ویکی شامل لغتی است که ناقض سیاست‌ نام‌گذاری ما است',
	'autocreatewiki-busy-username' => 'این نام کاربری از قبل انتخاب شده‌است.',
	'autocreatewiki-blocked-username' => 'شما اجازۀ ایجاد حساب کاربری ندارید.',
	'autocreatewiki-user-notloggedin' => 'حساب کاربری شما ساخته‌شد ولی هنوز به سامانه وارد نشده‌اید!',
	'autocreatewiki-empty-language' => 'لطفا زبان ویکی را انتخاب کنید.',
	'autocreatewiki-empty-category' => 'لطفا یکی از رده‌ها را انتخاب کنید.',
	'autocreatewiki-empty-wikiname' => 'نام ویکی نمی‌تواند خالی باشد.',
	'autocreatewiki-empty-username' => 'نام کاربری نمی‌تواند خالی باشد.',
	'autocreatewiki-empty-password' => 'گذرواژه نمی‌تواند خالی باشد.',
	'autocreatewiki-empty-retype-password' => 'فیلد تکرار گذرواژه نمی‌تواند خالی باشد.',
	'autocreatewiki-stepdefault' => 'فرآیند در حال انجام‌شدن است، لطفا صبر کنید ...',
	'autocreatewiki-errordefault' => 'عمل پایان نیافت ...',
	'autocreatewiki-step7' => 'در حال تنظیم نسخه آغازگر ویکی ...',
	'autocreatewiki-step8' => 'در حال تنظیم اختیارات گروه‌های کاربری و رده‌ها ...',
	'autocreatewiki-step9' => 'در حال تنظیم متغیرهای ویکی جدید ...',
	'autocreatewiki-congratulation' => 'مبارک باشد!',
	'autocreatewiki-welcometalk-log' => 'پیغام خوش‌آمد گویی',
	'autocreatewiki-step7-error' => 'نسخه‌برداری از پایگاه آغازگر ویکی با موفقیت انجام نشد!',
	'autocreatewiki-welcomesubject' => '$1 ساخته شد!',
	'autocreatewiki-welcomebody' => 'سلام $2،

ویکیایی که شما درخواست کرده‌بودید در <$1> قابل دسترسی است. ما امیدواریم به زودی شاهد ویرایش شما در آن‌جا باشیم!

ما یک سری اطلاعات و نکته‌هایی در صفحهٔ بحثتان (<$5>) اضافه کرده‌ایم تا به شما برای شروع ویکی‌تان کمک کند. اگر سوالی دارید، به این ایمیل پاسخ دهید یا در صفحات راهنمای ویکیا در <http://help.wikia.com> جستجو کنید.


$3

تیم جامعه ویکیا

<http://www.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => '<div align="right" dir="rtl" style="font-family: Tahoma;">
سلام $1، ما از داشتن \'\'\'$4\'\'\' در بین دیگر ویکیاهای ویکیا بسیار خوشحالیم!

شروع کردن ویکی جدید می‌تواند کار بزرگی باشد، ولی نگران نباشید، [[wikia:Community Team|تیم اجتماع ویکیا]] برای کمک اینجاست! ما راهنمایی‌هایی برای کمک به شروع ویکی جدید آماده کرده‌ایم. در کنار راهنمایی‌های ویکیا می‌توانید به ویکی‌های دیگر در [[w:c:fa:شرکت ویکیا|ویکیا]] برای گرفتن ایده جهت قالب بندی، رده بندی، و غیره سر بزنید. همه ما عضوی از خانواده بزرگ ویکیا هستیم که برای خوش گذرانی در اینجا با هم مشارکت می‌کنیم!
* [[w:c:help:Help:Starting this wiki|راهنمای شروع ویکی]] ما ۵ نکته به شما می‌دهد تا همین الان ویکی خود را به بهترین وجه تنظیم نمایید.
*ما همچنین [[w:c:help:Advice:Advice on starting a wiki| توصیه‌هایی برای شروع ویکی]] آماده  کرده‌ایم که اطلاعات عمیق‌تری برای ساخت ویکی جدید به شما می‌دهد.
*اگر شما کاربر جدید ویکیا هستید، ما به شما توصیه می‌کنیم که به [[w:c:fa:پرسش‌های رایج|پرسش‌های رایج کاربران جدید]]  مراجعه کنید.
اگر کمکی نیاز داشتید، می‌توانید به [[w:c:help|راهنمای ویکیا]] مراجعه کنید و یا از طریق [[Special:Contact|فرم تماس]] به ما پست الکترونیکی بزنید.

منتظر درخشش پروژه شما هستیم!

با آرزوی بهترین‌ها، [[User:$2|$3]] <staff />
</div>',
);

/** Finnish (Suomi)
 * @author Centerlink
 * @author Crt
 */
$messages['fi'] = array(
	'autocreatewiki' => 'Luo uusi wiki',
	'autocreatewiki-page-title-default' => 'Luo uusi wiki',
	'createwiki' => 'Luo uusi wiki',
	'autocreatewiki-chooseone' => 'Valitse yksi',
	'autocreatewiki-required' => '$1 = vaadittu',
	'autocreatewiki-category-select' => 'Valitse yksi',
	'autocreatewiki-language-all' => 'Kaikki kielet',
	'autocreatewiki-birthdate' => 'Syntymäaika:',
	'autocreatewiki-remember' => 'Muista minut',
	'autocreatewiki-create-account' => 'Luo tunnus',
	'autocreatewiki-done' => 'tehty',
	'autocreatewiki-error' => 'virhe',
	'autocreatewiki-haveaccount-question' => 'Onko sinulla jo Wikia-tili?',
	'autocreatewiki-busy-username' => 'Tämä käyttäjätunnus on jo varattu.',
	'autocreatewiki-empty-category' => 'Valitse yksi luokista.',
	'autocreatewiki-empty-wikiname' => 'Wikinimi ei voi olla tyhjä.',
	'autocreatewiki-empty-username' => 'Käyttäjätunnus ei voi olla tyhjä.',
	'autocreatewiki-empty-password' => 'Salasana ei voi olla tyhjä.',
	'autocreatewiki-category-other' => 'Muu',
	'autocreatewiki-set-username' => 'Aseta käyttäjätunnus ensin.',
	'autocreatewiki-invalid-birthday' => 'Virheellinen syntymäaika',
	'autocreatewiki-step1' => 'Luodaan kuvahakemisto...',
	'autocreatewiki-step2' => 'Luodaan tietokanta...',
	'autocreatewiki-step3' => 'Asetetaan oletustiedot tietokantaan...',
	'autocreatewiki-step4' => 'Kopioidaan oletuskuvat ja logo...',
	'autocreatewiki-redirect' => 'Ohjataan uuteen wikiin: $1...',
	'autocreatewiki-welcometalk-log' => 'Tervetuloviesti',
	'autocreatewiki-step2-error' => 'Tietokanta on olemassa!',
	'autocreatewiki-protect-reason' => 'Osa virallista käyttöliittymää',
	'autocreatewiki-welcomesubject' => '$1 on luotu.',
	'newwikis' => 'Uudet wikit',
);

/** French (Français)
 * @author IAlex
 * @author Iluvalar
 * @author Jean-Frédéric
 * @author McDutchie
 * @author Peter17
 */
$messages['fr'] = array(
	'autocreatewiki' => 'Créer un nouveau Wiki',
	'autocreatewiki-desc' => 'Crée un wiki dans WikiFactory par des requêtes des utilisateurs',
	'autocreatewiki-page-title-default' => 'Créer un wiki',
	'autocreatewiki-page-title-answers' => 'Créer un nouveau site de réponses',
	'createwiki' => 'Créer un wiki',
	'autocreatewiki-chooseone' => 'Choisissez-un un',
	'autocreatewiki-required' => '$1 = obligatoire',
	'autocreatewiki-web-address' => 'Adresse Web :',
	'autocreatewiki-category-select' => 'Sélectionnez-en un',
	'autocreatewiki-language-top' => 'Les $1 langues les plus utilisées',
	'autocreatewiki-language-all' => 'Toutes les langues',
	'autocreatewiki-birthdate' => 'Date de naissance :',
	'autocreatewiki-blurry-word' => 'Mot floué :',
	'autocreatewiki-remember' => 'Se souvenir de moi',
	'autocreatewiki-create-account' => 'Créer un compte',
	'autocreatewiki-done' => 'fait',
	'autocreatewiki-error' => 'erreur',
	'autocreatewiki-language-top-list' => 'de,en,es,he,fr,it,ja,no,pl,pt,pt-br,zh',
	'autocreatewiki-haveaccount-question' => 'Avez-vous déjà un compte Wikia ?',
	'autocreatewiki-success-title-default' => 'Votre wiki a bien été créé !',
	'autocreatewiki-success-title-answers' => 'Votre site de réponses a été créé.',
	'autocreatewiki-success-subtitle' => 'Vous pouvez commencer à travailler sur votre wiki en visitant :',
	'autocreatewiki-success-has-been-created' => 'a bien été créé !',
	'autocreatewiki-success-get-started' => 'Démarrer',
	'autocreatewiki-info-domain' => "Le mieux est d'utiliser un mot qui sera vraisemblablement un mot clé de recherche pour votre sujet.",
	'autocreatewiki-info-topic' => 'Ajoutez une courte description comme « Star Wars » ou « Émission TV ».',
	'autocreatewiki-info-category-default' => 'Ceci aidera les visiteurs à trouver votre wiki.',
	'autocreatewiki-info-category-answers' => 'Ceci aidera les visiteurs à trouver votre site de réponses.',
	'autocreatewiki-info-language' => 'Langue du wiki',
	'autocreatewiki-info-email-address' => "Votre adresse de courriel n'est jamais montrée à personne sur Wikia.",
	'autocreatewiki-info-realname' => 'Si vous choisissez de le donner, il sera utilisé pour vous attribuer votre travail.',
	'autocreatewiki-info-birthdate' => "Wikia requiert que les utilisateurs donnent leur réelle date de naissance comme mesure de précaution et comme un moyen de préserver l'intégrité du site tout en étant en accord avec les règles fédérales des États-Unis.",
	'autocreatewiki-info-blurry-word' => 'Pour nous aider à nous protéger contre la création automatisée de compte, veuillez taper le mot floué que vous voyez dans ce champ.',
	'autocreatewiki-info-terms-agree' => 'En créant un wiki et un compte utilisateur, vous acceptez les <a href="http://www.wikia.com/wiki/Terms_of_use">conditions d\'utilisation de Wiki</a>.',
	'autocreatewiki-info-staff-username' => "<b>Staff seulement :</b> l'utilisateur spécifié sera considéré comme le fondateur du wiki.",
	'autocreatewiki-title-template' => 'Wiki $1',
	'autocreatewiki-limit-day' => "Wikia a dépassé la limite de création de nouveaux wikis pour aujourd'hui ($1).",
	'autocreatewiki-limit-creation' => 'Vous avez dépassée la limite maximale de création de wiki en 24 heures ($1).',
	'autocreatewiki-empty-field' => 'Complétez ce champ.',
	'autocreatewiki-bad-name' => 'Le nom ne doit pas contenir de caractères spéciaux (comme $ et @) et doit être un simple mot en minuscules sans espaces.',
	'autocreatewiki-invalid-wikiname' => 'Le nom ne doit pas contenir de caractères spéciaux (comme $ et @) et ne peut pas être vide',
	'autocreatewiki-violate-policy' => 'Ce wiki contient un nom qui viole notre politique de nommage',
	'autocreatewiki-name-taken' => 'Un wiki avec le même nom existe déjà. Vous êtes encouragé à le rejoindre sur <a href="http://$1.wikia.com">http://$1.wikia.com</a>',
	'autocreatewiki-name-too-short' => 'Le nom est trop court, il doit contenir au moins 3 caractères.',
	'autocreatewiki-name-too-long' => 'Le nom est trop long, il doit contenir au plus 50 caractères.',
	'autocreatewiki-similar-wikis' => "Une liste des wikis créés sur le même sujet est affichée ci-dessous. Nous vous suggérons d'aller sur un de ceux-là.",
	'autocreatewiki-invalid-username' => "Le nom d'utilisateur est invalide.",
	'autocreatewiki-busy-username' => "Le nom d'utilisateur est déjà pris.",
	'autocreatewiki-blocked-username' => 'Vous ne pouvez pas créer un compte.',
	'autocreatewiki-user-notloggedin' => "Votre compte a été créé mais vous n'êtes pas connecté !",
	'autocreatewiki-empty-language' => 'Sélectionnez la langue du wiki.',
	'autocreatewiki-empty-category' => 'Sélectionnez une catégorie.',
	'autocreatewiki-empty-wikiname' => 'Le nom du wiki ne peut pas être vide.',
	'autocreatewiki-empty-username' => "Le nom d'utilisateur ne peut pas être vide.",
	'autocreatewiki-empty-password' => 'Le mot de passe ne peut pas être vide.',
	'autocreatewiki-empty-retype-password' => 'Le mot de passe ré-entré ne peut pas être vide.',
	'autocreatewiki-category-label' => 'Catégorie :',
	'autocreatewiki-category-other' => 'Autre',
	'autocreatewiki-set-username' => "Définissez le nom d'utilisateur d'abord.",
	'autocreatewiki-invalid-category' => 'Valeur invalide pour la catégorie. Veuillez sélectionner une valeur de la liste.',
	'autocreatewiki-invalid-language' => 'Valeur invalide pour la langue. Veuillez sélectionner une valeur de la liste',
	'autocreatewiki-invalid-retype-passwd' => 'Veuillez retaper le même mot de passe que ci-dessus',
	'autocreatewiki-invalid-birthday' => 'Date de naissance invalide',
	'autocreatewiki-limit-birthday' => "Impossible de créer l'enregistrement.",
	'autocreatewiki-log-title' => 'Votre wiki est en cours de création',
	'autocreatewiki-step0' => 'Initialisation ...',
	'autocreatewiki-stepdefault' => "Le processus est en cours d'exécution, veuillez patienter ...",
	'autocreatewiki-errordefault' => "Le processus ne s'est pas terminé ...",
	'autocreatewiki-step1' => 'Création du dossier des images ...',
	'autocreatewiki-step2' => 'Création de la base de données ...',
	'autocreatewiki-step3' => 'Ajout des informations par défaut dans la base de données ...',
	'autocreatewiki-step4' => 'Copie des images par défaut et du logo ...',
	'autocreatewiki-step5' => 'Ajout des variables par défaut dans la base de données ...',
	'autocreatewiki-step6' => 'Ajout des tables par défaut dans la base de données ...',
	'autocreatewiki-step7' => 'Ajout des bases pour la langue ...',
	'autocreatewiki-step8' => 'Ajout des groupes utilisateurs et catégories ...',
	'autocreatewiki-step9' => 'Ajout des variables du nouveau wiki ...',
	'autocreatewiki-step10' => 'Ajout des pages dans le wiki central ...',
	'autocreatewiki-step11' => "Envoi du courriel à l'utilisateur ...",
	'autocreatewiki-redirect' => 'Redirection vers le nouveau wiki : $1 ...',
	'autocreatewiki-congratulation' => 'Félicitations !',
	'autocreatewiki-welcometalk-log' => 'Message de bienvenue',
	'autocreatewiki-regex-error-comment' => 'utilisé dans le wiki $1 (texte complet : $2)',
	'autocreatewiki-step2-error' => 'La base de données existe !',
	'autocreatewiki-step3-error' => "Impossible d'ajouter les informations par défaut dans la base de données !",
	'autocreatewiki-step6-error' => "Impossible d'ajouter les tables par défaut dans la base de données !",
	'autocreatewiki-step7-error' => 'Impossible de copier la base de données de base pour cette langue !',
	'autocreatewiki-protect-reason' => "Partie de l'interface officielle",
	'autocreatewiki-welcomesubject' => '$1 a été créé!',
	'autocreatewiki-welcomebody' => "Bonjour $2,

Le wiki que vous avez demandé est maintenant disponible <$1>.  Nous espérons que nous vous retrouverons dans les modifications de celui-ci !

Nous avons ajouté quelques informations sur votre page de discussion (<$5>) pour vous aider à commencer. Si vous avez encore des questions, répondez à ce message ou regardez nos pages d'aide ici : <http://aide.wikia.com>.

Beaucoup de succès dans votre projet,

$3
Wikia Community Team
<http://www.wikia.com/wiki/User:$4>",
	'autocreatewiki-welcometalk' => "== Bienvenue ! ==

<div style=\"font-size:120%; line-height:1.2em;\">Bonjour \$1, nous sommes fiers d’héberger votre site '''\$4''' chez Wikia!

Maintenant vous avez un site web qu'il faudra remplir avec des informations, des images et des vidéos. Mais à présent il est juste vide et il vous attend... Cela vous faît-il peur ? Voici quelques conseils pour bien débuter.

* '''Décrivez le sujet''' sur la page d'accueil. Ceci est votre opportunité pour expliquer aux lecteurs vos sujets préférés. Écrivez-en autant que vous voulez ! Votre description peut avoir des liens vers toutes les pages importantes de votre wiki.

* '''Commencez quelques pages''' -- juste quelques phrases peuvent suffire. Ne laissez pas de pages blanches ! Un wiki est fait pour ajouter et modifier le contenu au fil de votre avancement. Vous pouvez aussi ajouter des images et des vidéos, pour compléter les pages et les rendre plus intéressantes.

Et ensuite continuez ! Les gens aiment aller sur des wikis où il y a beaucoup de choses à lire, donc continuez à ajouter du contenu pour attirer les lecteurs et les éditeurs. Il y a beaucoup à faire mais ne vos en faîtes pas -- aujourd'hui est le premier jour, et vous avez beaucoup de temps. Tous les wikis ont bien commencé un jour -- juste un peu de temps pour débuter quelques pages, jusqu'à ce qu'il devienne un grand site

Si vous avez des questions, vous pouvez nous écrire par cette page [[Special:Contact]]. Nous vous souhaitons bien du plaisir ! 

-- [[User:\$2|\$3]] <staff /></div>",
	'newwikis' => 'Nouveaux wikis',
	'newwikisstart' => 'Afficher les wikis depuis :',
	'autocreatewiki-reminder-subject' => '{{SITENAME}}',
	'autocreatewiki-reminder-body' => '
Cher $1 :

Félicitations pour le commencement de votre nouveau wiki, {{SITENAME}} ! Vous pouvez revenir et ajouter plus à votre wiki en visitant $2.

Ceci est un tout nouveau projet, veuillez nous écrire si avec une quelconque question !


-- Team de la communauté Wikia',
	'autocreatewiki-reminder-body-HTML' => '
<p>Cher $1 :</p>

<p>Félicitations pour le commencement de votre nouveau wiki, {{SITENAME}} ! Vous pouvez revenir et ajouter plus à votre wiki en visitant <a href="$2">$2</a>.</p>

<p>Ceci est un tout nouveau projet, veuillez nous écrire si avec une quelconque question !</p>

<p>-- Team de la communauté Wikia</p>',
	'autocreatewiki-subname-answers' => 'Réponses',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'autocreatewiki' => 'Crear un novo wiki',
	'autocreatewiki-desc' => 'Crea un wiki en WikiFactory mediante a solicitude dun usuario',
	'autocreatewiki-page-title-default' => 'Crear un novo wiki',
	'autocreatewiki-page-title-answers' => 'Crear un novo sitio de respostas',
	'createwiki' => 'Crear un novo wiki',
	'autocreatewiki-chooseone' => 'Escolla un',
	'autocreatewiki-required' => '$1 = obrigatorio',
	'autocreatewiki-web-address' => 'Enderezo web:',
	'autocreatewiki-category-select' => 'Seleccione un',
	'autocreatewiki-language-top' => 'As $1 linguas máis empregadas',
	'autocreatewiki-language-all' => 'Todas as linguas',
	'autocreatewiki-birthdate' => 'Data de nacemento:',
	'autocreatewiki-blurry-word' => 'Palabra borrosa:',
	'autocreatewiki-remember' => 'Lembrádeme',
	'autocreatewiki-create-account' => 'Crear unha conta',
	'autocreatewiki-done' => 'feito',
	'autocreatewiki-error' => 'erro',
	'autocreatewiki-language-top-list' => 'de,en,es,he,fr,it,ja,no,pl,pt,pt-br,zh',
	'autocreatewiki-haveaccount-question' => 'Xa ten unha conta Wikia?',
	'autocreatewiki-success-title-default' => 'Creouse o seu wiki!',
	'autocreatewiki-success-title-answers' => 'Creouse o seu sitio de respostas!',
	'autocreatewiki-success-subtitle' => 'Xa pode comezar a traballar no seu wiki, visite:',
	'autocreatewiki-success-has-been-created' => 'foi creado correctamente!',
	'autocreatewiki-success-get-started' => 'Introdución',
	'autocreatewiki-info-domain' => 'O mellor é usar como palabra clave unha que describa claramente o seu tema.',
	'autocreatewiki-info-topic' => 'Engada unha breve descrición, como "Star Wars" ou "series de televisión".',
	'autocreatewiki-info-category-default' => 'Isto axudará aos visitantes a atopar o seu wiki.',
	'autocreatewiki-info-category-answers' => 'Isto axudará aos visitantes a atopar o seu sitio de respostas.',
	'autocreatewiki-info-language' => 'Esta será a lingua por defecto para os visitantes do seu wiki.',
	'autocreatewiki-info-email-address' => 'Non se mostrará a ninguén en Wikia o seu enderezo de correo electrónico.',
	'autocreatewiki-info-realname' => 'Se escolle dalo utilizarase para atribuírlle o seu traballo.',
	'autocreatewiki-info-birthdate' => 'Wikia necesita que todos os usuarios acheguen a súa data de nacemento real como precaución de seguridade e como medio para preservar a integridade do sitio, respectando as normativas nacionais.',
	'autocreatewiki-info-blurry-word' => 'Para axudarnos á protección contra a creación de contas automáticas, escriba a palabra borrosa que vexa neste campo.',
	'autocreatewiki-info-terms-agree' => 'Ao crear un wiki e unha conta de usuario, vostede acepta os <a href="http://www.wikia.com/wiki/Terms_of_use">termos de uso de Wikia</a>',
	'autocreatewiki-info-staff-username' => '<b>Persoal só:</b> o usuario especificado será considerado o fundador.',
	'autocreatewiki-title-template' => 'Wiki $1',
	'autocreatewiki-limit-day' => 'Wikia superou o número máximo de novos wikis para hoxe ($1).',
	'autocreatewiki-limit-creation' => 'Superou o número máximo de novos wikis en 24 horas ($1).',
	'autocreatewiki-empty-field' => 'Por favor, encha este campo.',
	'autocreatewiki-bad-name' => 'O nome non pode conter caracteres especiais (como $ ou @) e debe ser unha soa palabra en minúsculas e sen espazos.',
	'autocreatewiki-invalid-wikiname' => 'O nome non pode conter caracteres especiais (como $ ou @) e non pode estar baleiro',
	'autocreatewiki-violate-policy' => 'O nome deste wiki contén unha palabra que viola a nosa política de nomes',
	'autocreatewiki-name-taken' => 'Xa existe un wiki con este nome. Animámolo a unirse a nós en <a href="http://$1.wikia.com">http://$1.wikia.com</a>',
	'autocreatewiki-name-too-short' => 'Este nome é moi curto, por favor, escolla un nome cun mínimo de 3 caracteres.',
	'autocreatewiki-name-too-long' => 'Este nome é moi longo, por favor, escolla un nome cun máximo de 50 caracteres.',
	'autocreatewiki-similar-wikis' => 'A continuación móstranse os wikis existentes sobre este tema. Suxerímoslle que edite nalgún deles.',
	'autocreatewiki-invalid-username' => 'Este nome de usuario non é válido.',
	'autocreatewiki-busy-username' => 'Este nome de usuario xa está en uso.',
	'autocreatewiki-blocked-username' => 'Non pode crear unha conta.',
	'autocreatewiki-user-notloggedin' => 'Creouse a súa conta, pero non accedeu ao sistema!',
	'autocreatewiki-empty-language' => 'Por favor, seleccione a lingua do wiki.',
	'autocreatewiki-empty-category' => 'Por favor, seleccione unha categoría.',
	'autocreatewiki-empty-wikiname' => 'O nome do wiki non pode estar baleiro.',
	'autocreatewiki-empty-username' => 'O nome de usuario non pode estar baleiro.',
	'autocreatewiki-empty-password' => 'O contrasinal non pode estar baleiro.',
	'autocreatewiki-empty-retype-password' => 'O campo para repetir o contrasinal non pode estar baleiro.',
	'autocreatewiki-category-label' => 'Categoría:',
	'autocreatewiki-category-other' => 'Outro',
	'autocreatewiki-set-username' => 'Defina o nome de usuario primeiro.',
	'autocreatewiki-invalid-category' => 'Valor inválido para a categoría. Por favor, escolla o valor axeitado da lista despregable.',
	'autocreatewiki-invalid-language' => 'Valor inválido para a lingua. Por favor, escolla o valor axeitado da lista despregable.',
	'autocreatewiki-invalid-retype-passwd' => 'Por favor, escriba o mesmo contrasinal que enriba',
	'autocreatewiki-invalid-birthday' => 'Data de nacemento non válida',
	'autocreatewiki-limit-birthday' => 'Non se puido crear o rexistro.',
	'autocreatewiki-log-title' => 'Estase creando o seu wiki',
	'autocreatewiki-step0' => 'Iniciando o proceso...',
	'autocreatewiki-stepdefault' => 'O proceso está en marcha, por favor, agarde...',
	'autocreatewiki-errordefault' => 'O proceso non rematou...',
	'autocreatewiki-step1' => 'Creando a carpeta de imaxes...',
	'autocreatewiki-step2' => 'Creando a base de datos...',
	'autocreatewiki-step3' => 'Definindo a información por defecto na base de datos...',
	'autocreatewiki-step4' => 'Copiando as imaxes por defecto e mais o logo...',
	'autocreatewiki-step5' => 'Definindo as variables por defecto na base de datos...',
	'autocreatewiki-step6' => 'Definindo as táboas por defecto na base de datos...',
	'autocreatewiki-step7' => 'Definindo o iniciador para a lingua...',
	'autocreatewiki-step8' => 'Definindo os grupos de usuario e mais as categorías...',
	'autocreatewiki-step9' => 'Definindo as variables para o novo wiki...',
	'autocreatewiki-step10' => 'Definindo as páxinas no wiki central...',
	'autocreatewiki-step11' => 'Enviando un correo electrónico ao usuario...',
	'autocreatewiki-redirect' => 'Redirixindo cara ao novo wiki: $1...',
	'autocreatewiki-congratulation' => 'Parabéns!',
	'autocreatewiki-welcometalk-log' => 'Mensaxe de benvida',
	'autocreatewiki-regex-error-comment' => 'empregado no wiki $1 (texto completo: $2)',
	'autocreatewiki-step2-error' => 'Xa existe a base de datos!',
	'autocreatewiki-step3-error' => 'Non se pode definir a información por defecto na base de datos!',
	'autocreatewiki-step6-error' => 'Non se poden definir as táboas por defecto na base de datos!',
	'autocreatewiki-step7-error' => 'Non se pode copiar o iniciador da base de datos para esta lingua!',
	'autocreatewiki-protect-reason' => 'Parte da interface oficial',
	'autocreatewiki-welcomesubject' => '$1 foi creado!',
	'autocreatewiki-welcomebody' => 'Ola $2,

O wiki que solicitou xa está dispoñible en <$1>. Agardamos velo editando por alí axiña!

Vimos de engadir información e consellos na súa páxina de conversa de usuario (<$5>) para axudalo a dar os primeiros pasos.

Se ten algún problema, pode pedir axuda da comunidade no wiki en <http://www.wikia.com/wiki/Forum:Help_desk> ou mediante correos electrónicos no enderezo community@wikia.com. Tamén pode visitar a nosa canle de conversa IRC #wikia en <http://irc.wikia.com>.

Se ten calquera dúbida ou problema, pode poñerse en contacto comigo directamente por correo electrónico ou na miña páxina de conversa.

Boa sorte co proxecto!

$3

O equipo comunitario de Wikia

<http://www.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => "== Benvido! ==
<div style=\"font-size:120%; line-height:1.2em;\">Ola \$1; estamos encantados de que '''\$4''' sexa parte da comunidade de Wikia!

Agora ten un sitio web enteiro para encher con información, fotos e vídeos sobre o seu tema preferido. Pero arestora, só hai páxinas en branco agardando por vostede... Asustado, non? Aquí hai algúns xeitos de comezar.

*'''Faga unha introdución ao seu tema''' na páxina principal. Esta é a súa oportunidade para explicarlles aos seus lectores sobre que trata o sitio. Escriba tanto como queira! A súa descrición pode conter ligazóns cara a todas as páxinas máis importantes.

*'''Comece algunhas páxinas novas''' aínda que sexa cunha ou dúas frases. Non deixe que a páxina en branco lle desanime! Un wiki constrúese aos poucos coas cousas que se van engadindo ou cambiando. Tamén pode incluír fotos e vídeos para encher a páxina e facela máis interesante.

Continúe a traballar! Á xente gústalle visitar os wikis cando hai moitas cousas que ler e mirar, así que siga engadindo cousas e atraerá a lectores e editores. Hai moito que facer, pero non se preocupe: hoxe é o seu primeiro día e ten tempo dabondo. Todos os wikis comezan da mesma maneira: un pouco de cada vez coas primeiras páxinas ata que medran e son un sitio web enorme.

Se ten algunha dúbida ou pregunta, pódenos enviar un correo electrónico a través do noso [[Special:Contact|formulario de contacto]]. Páseo ben!

-- [[User:\$2|\$3]] <staff /></div>",
	'newwikis' => 'Novos wikis',
	'newwikisstart' => 'Mostrar os wikis que comecen por:',
	'autocreatewiki-reminder-body' => '
Estimado $1:

Parabéns por comezar o seu novo wiki, {{SITENAME}}! Pode vir cando queira e engadir máis contidos ao seu wiki visitando $2.

Este é un proxecto completamente novo, así que escríbanos se ten algunha dúbida!


-- O equipo comunitario de Wikia',
	'autocreatewiki-reminder-body-HTML' => '<p>Estimado $1:</p>

<p>Parabéns por comezar o seu novo wiki, {{SITENAME}}! Pode vir cando queira e engadir máis contidos ao seu wiki visitando <a href="$2">$2</a>.</p>

<p>Este é un proxecto completamente novo, así que escríbanos se ten algunha dúbida!</p>


<p>-- O equipo comunitario de Wikia</p>',
	'autocreatewiki-subname-answers' => 'Respostas',
);

/** Hebrew (עברית)
 * @author 0ftal
 */
$messages['he'] = array(
	'autocreatewiki' => 'צור אתר וויקי חדש',
	'autocreatewiki-desc' => 'צור אתר ווקי במפעל הווקי עם הגדרות משתמש',
	'autocreatewiki-page-title-default' => 'צור אתר וויקי חדש',
	'createwiki' => 'צור אתר וויקי חדש',
	'autocreatewiki-chooseone' => 'בחר אחד',
	'autocreatewiki-required' => '1$ = חובה',
	'autocreatewiki-web-address' => 'כתובת האינטרנט:',
	'autocreatewiki-category-select' => 'בחר אחד',
	'autocreatewiki-language-top' => '$1 השפות המובילות',
	'autocreatewiki-language-all' => 'כל השפות',
	'autocreatewiki-birthdate' => 'תאריך לידה:',
	'autocreatewiki-blurry-word' => 'מילה מטושטשת:',
	'autocreatewiki-remember' => 'זכור אותי',
	'autocreatewiki-create-account' => 'יצירת חשבון',
	'autocreatewiki-done' => 'הושלם',
	'autocreatewiki-error' => 'שגיאה',
	'autocreatewiki-haveaccount-question' => 'האם יש לך כבר חשבון בוויקיה?',
	'autocreatewiki-success-title-default' => 'אתר הוויקי שלך נוצר!',
	'autocreatewiki-success-subtitle' => 'אתה יכול להתחיל לעבוד על אתר הוויקי שלך בכתובת:',
	'autocreatewiki-success-has-been-created' => 'נוצר!',
	'autocreatewiki-success-get-started' => 'צעדים ראשונים',
	'autocreatewiki-info-domain' => 'כדאי להשתמש במילה שהיא מילת מפתח לחיפוש הנושא שלך.',
	'autocreatewiki-info-topic' => 'הוסף תיאור קצר כגון "מלחמת הכוכבים" או "תוכניות טלוויזיה".',
	'autocreatewiki-info-language' => 'זו תהיה שפת ברירת המחדל עבור המבקרים בוויקי שלך.',
	'autocreatewiki-info-email-address' => 'כתובת הדוא"ל שלך נשמרת בסודיות ואף אחד לא יכול לראותה.',
	'autocreatewiki-info-realname' => 'את תבחרו לציין אותו, הוא ישמש לייחוס עבודתכם אליכם.',
	'newwikis' => 'אתרי וויקי חדשים',
	'newwikisstart' => 'הצג אתרי וויקי המתחילים ב:',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'autocreatewiki' => 'Új wiki létrehozása',
	'autocreatewiki-desc' => 'Új wiki létrehozása a Wikigyárban a felhasználói kérések alapján',
	'autocreatewiki-page-title-default' => 'Új wiki létrehozása',
	'createwiki' => 'Új wiki létrehozása',
	'autocreatewiki-chooseone' => 'Válassz egyet',
	'autocreatewiki-required' => '$1 = kötelező',
	'autocreatewiki-web-address' => 'Webcím:',
	'autocreatewiki-category-select' => 'Válassz egyet',
	'autocreatewiki-language-top' => 'Top $1 nyelv',
	'autocreatewiki-language-all' => 'Összes nyelv',
	'autocreatewiki-birthdate' => 'Születési dátum:',
	'autocreatewiki-blurry-word' => 'Elmosott szó:',
	'autocreatewiki-remember' => 'Emlékezzen rám',
	'autocreatewiki-create-account' => 'Fiók létrehozása',
	'autocreatewiki-done' => 'Kész.',
	'autocreatewiki-error' => 'hiba',
	'autocreatewiki-language-top-list' => 'de,en,es,he,fr,hu,it,ja,no,pl,pt,pt-br,zh',
	'autocreatewiki-haveaccount-question' => 'Már van Wikia-fiókod?',
	'autocreatewiki-success-title-default' => 'A wiki elkészült!',
	'autocreatewiki-success-subtitle' => 'Elkezdhetsz dolgozni a wikin a következő címre való látogatás után:',
	'autocreatewiki-success-has-been-created' => 'elkészült!',
	'autocreatewiki-success-get-started' => 'Első lépések',
	'autocreatewiki-info-topic' => 'Adj meg egy rövid leírást, például „Star Wars” vagy „TV-műsorok”.',
	'autocreatewiki-info-language' => 'Ez lesz a wikid alapértelmezett nyelve a látogatóid számára.',
	'autocreatewiki-info-email-address' => 'Az e-mail címedet sosem mutatjuk meg senkinek a Wikián.',
	'autocreatewiki-info-realname' => 'Ha megadod, ezen a néven leszel jelölve szerzőként a munkáidnál.',
	'autocreatewiki-invalid-username' => 'Ez a felhasználónév érvénytelen.',
	'autocreatewiki-empty-category' => 'Válassz egy kategóriát.',
	'autocreatewiki-category-other' => 'Egyéb',
	'autocreatewiki-invalid-birthday' => 'Érvénytelen születési dátum',
	'autocreatewiki-step2' => 'Adatbázis létrehozása…',
	'autocreatewiki-step2-error' => 'Az adatbázis létezik!',
	'autocreatewiki-welcomesubject' => '$1 elkészült!',
	'autocreatewiki-subname-answers' => 'Válaszok',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'autocreatewiki' => 'Crear un nove wiki',
	'autocreatewiki-desc' => 'Crear wiki in WikiFactory per requestas de usatores',
	'autocreatewiki-page-title-default' => 'Crear un nove wiki',
	'autocreatewiki-page-title-answers' => 'Crear un nove sito de responsas',
	'createwiki' => 'Crear un nove wiki',
	'autocreatewiki-chooseone' => 'Selige un',
	'autocreatewiki-required' => '$1 = requirite',
	'autocreatewiki-web-address' => 'Adresse web:',
	'autocreatewiki-category-select' => 'Selige un',
	'autocreatewiki-language-top' => 'Le $1 linguas le plus usate',
	'autocreatewiki-language-all' => 'Tote le linguas',
	'autocreatewiki-birthdate' => 'Data de nascentia:',
	'autocreatewiki-blurry-word' => 'Parola brumose:',
	'autocreatewiki-remember' => 'Memorar me',
	'autocreatewiki-create-account' => 'Crear un conto',
	'autocreatewiki-done' => 'facite',
	'autocreatewiki-error' => 'error',
	'autocreatewiki-haveaccount-question' => 'Ha tu ja un conto Wiki?',
	'autocreatewiki-success-title-default' => 'Tu wiki ha essite create!',
	'autocreatewiki-success-title-answers' => 'Tu sito de responsas ha essite create!',
	'autocreatewiki-success-subtitle' => 'Tu pote ora comenciar a laborar a tu wiki per visitar:',
	'autocreatewiki-success-has-been-created' => 'ha essite create!',
	'autocreatewiki-success-get-started' => 'Comenciar',
	'autocreatewiki-info-domain' => 'Es recommendate usar un parola susceptibile de esser cercate pro tu topico.',
	'autocreatewiki-info-topic' => 'Adde un breve description como "Star Wars" o "Series de TV".',
	'autocreatewiki-info-category-default' => 'Isto adjutara le visitatores a trovar tu wiki.',
	'autocreatewiki-info-category-answers' => 'Isto adjutara le visitatores a trovar tu sito de responsas.',
	'autocreatewiki-info-language' => 'Iste essera le lingua predefinite pro le visitatores de tu wiki.',
	'autocreatewiki-info-email-address' => 'Tu adresse de e-mail nunquam es monstrate a alcuno in Wikia.',
	'autocreatewiki-info-realname' => 'Si tu opta pro dar lo, illo essera usate pro dar te attribution pro tu contributiones.',
	'autocreatewiki-info-birthdate' => 'Wikia require que tote le usatores forni lor real data de nascentia como mesura de securitate e como medio de preservar le integritate del sito in conformitate con le regulationes federal statounitese.',
	'autocreatewiki-info-blurry-word' => 'Pro adjutar a proteger le sito contra le creation automatic de contos, per favor entra in iste campo le parola brumose que tu vide.',
	'autocreatewiki-info-terms-agree' => 'Per crear un wiki e un conto de usator, tu accepta le <a href="http://www.wikia.com/wiki/Terms_of_use">conditiones de uso de Wikia</a>.',
	'autocreatewiki-info-staff-username' => '<b>Personal solmente:</b> Le usator specificate essera listate qua fundator.',
	'autocreatewiki-title-template' => 'Wiki $1',
	'autocreatewiki-limit-day' => 'Wikia ha excedite le limite de creation de nove wikis pro hodie ($1).',
	'autocreatewiki-limit-creation' => 'Tu ha excedite le numero de wikis que tu pote crear durante 24 horas ($1).',
	'autocreatewiki-empty-field' => 'Per favor completa iste campo.',
	'autocreatewiki-bad-name' => 'Le nomine non pote continer characteres special (como $ o @) e debe esser un sol parola in minusculas e sin spatios.',
	'autocreatewiki-invalid-wikiname' => 'Le nomine non pote continer characteres special (como $ o @) e non pote esser vacue.',
	'autocreatewiki-violate-policy' => 'Iste nomine de wiki contine un parola que viola nostre politica de nomines.',
	'autocreatewiki-name-taken' => 'Un wiki con iste nomine ja existe. Tu es benvenite a participar in illo a <a href="http://$1.wikia.com">http://$1.wikia.com</a>.',
	'autocreatewiki-name-too-short' => 'Iste nomine es troppo curte. Per favor entra un nomine con al minus 3 characteres.',
	'autocreatewiki-name-too-long' => 'Iste nomine es troppo longe. Per favor entra un nomine con al plus 50 characteres.',
	'autocreatewiki-similar-wikis' => 'Ecce le wikis ja existente super iste thema. Nos suggere participar in un de illos.',
	'autocreatewiki-invalid-username' => 'Iste nomine de usator es invalide.',
	'autocreatewiki-busy-username' => 'Iste nomine de usator es ja in uso.',
	'autocreatewiki-blocked-username' => 'Tu non pote crear un conto.',
	'autocreatewiki-user-notloggedin' => 'Tu conto ha essite create ma le apertura del session non ha succedite!',
	'autocreatewiki-empty-language' => 'Per favor selige le lingua del wiki.',
	'autocreatewiki-empty-category' => 'Per favor selige un del categorias.',
	'autocreatewiki-empty-wikiname' => 'Le nomine del wiki non pote esser vacue.',
	'autocreatewiki-empty-username' => 'Le nomine de usator non pote esser vacue.',
	'autocreatewiki-empty-password' => 'Le contrasigno non pote esser vacue.',
	'autocreatewiki-empty-retype-password' => 'Le contrasigno repetite non pote esser vacue.',
	'autocreatewiki-category-label' => 'Categoria:',
	'autocreatewiki-category-other' => 'Altere',
	'autocreatewiki-set-username' => 'Defini primo le nomine de usator.',
	'autocreatewiki-invalid-category' => 'Valor invalide de categoria. Per favor selige un categoria del lista disrolante.',
	'autocreatewiki-invalid-language' => 'Valor invalide de lingua. Per favor selige un lingua del lista disrolante.',
	'autocreatewiki-invalid-retype-passwd' => 'Per favor repete le contrasigno entrate hic supra.',
	'autocreatewiki-invalid-birthday' => 'Data de nascentia invalide',
	'autocreatewiki-limit-birthday' => 'Impossibile crear registration.',
	'autocreatewiki-log-title' => 'Tu wiki es in curso de creation',
	'autocreatewiki-step0' => 'Initialisation del processo…',
	'autocreatewiki-stepdefault' => 'Le processo es in curso de execution, un momento…',
	'autocreatewiki-errordefault' => 'Le processo non ha finite…',
	'autocreatewiki-step1' => 'Creation del dossier de imagines…',
	'autocreatewiki-step2' => 'Creation del base de datos…',
	'autocreatewiki-step3' => 'Insertion del informationes predefinite in le base de datos…',
	'autocreatewiki-step4' => 'Copia del imagines predefinite e del logotypo…',
	'autocreatewiki-step5' => 'Configuration del variabiles predefinite in le base de datos…',
	'autocreatewiki-step6' => 'Configuration del tabellas predefinite in le base de datos…',
	'autocreatewiki-step7' => 'Configuration del initiator de lingua…',
	'autocreatewiki-step8' => 'Configuration del gruppos de usator e del categorias…',
	'autocreatewiki-step9' => 'Configuration del variabiles del nove wiki…',
	'autocreatewiki-step10' => 'Insertion de paginas in Wiki central…',
	'autocreatewiki-step11' => 'Invio de e-mail al usator…',
	'autocreatewiki-redirect' => 'Redirection verso le nove Wiki: $1…',
	'autocreatewiki-congratulation' => 'Felicitationes!',
	'autocreatewiki-welcometalk-log' => 'Message de benvenita',
	'autocreatewiki-regex-error-comment' => 'usate in le wiki $1 (texto complete: $2)',
	'autocreatewiki-step2-error' => 'Le base de datos existe!',
	'autocreatewiki-step3-error' => 'Impossibile inserer le informationes predefinite in le base de datos!',
	'autocreatewiki-step6-error' => 'Impossibile inserer le tabellas predefinite in le base de datos!',
	'autocreatewiki-step7-error' => 'Impossibile copiar le base de datos initial pro le lingua!',
	'autocreatewiki-protect-reason' => 'Parte del interfacie official',
	'autocreatewiki-welcomesubject' => '$1 ha essite create!',
	'autocreatewiki-welcomebody' => 'Salute $2,

Le Wikia que tu ha requestate es ora disponibile a <$1>. Nos spera vider te contribuer a illo tosto!

Nos ha addite alcun informationes e consilios in tu pagina de discussion personal (<$5>) pro adjutar te a comenciar.

Si tu ha problemas, tu pote peter adjuta del communitate in le wiki a <http://www.wikia.com/wiki/Forum:Help_desk>, o via e-mail a community@wikia.com. Tu pote tamben visitar nostre canal de conversation in directo (IRC), #wikia <http://irc.wikia.com>.

Contacta me directemente per e-mail o in mi pagina de discussion si tu ha questiones o preoccupationes.

Bon fortuna con le projecto!

$3

Equipa communitari de Wikia

<http://www.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => "== Benvenite! ==
<div style=\"font-size:120%; line-height:1.2em;\">Salute \$1 -- nos es felice de haber '''\$4''' como parte del communitate de Wikia!

Ora tu ha un tote sito web a impler con informationes, imagines e videos super tu thema favorite. Ma in iste momento, illo consiste solmente de paginas vacue… Intimidante, nonne? Ecce alcun modos de comenciar.

* '''Introduce tu thema''' in le pagina principal. Prende le opportunitate de exponer a tu lectores le essentiales de tu thema. Scribe tanto como tu vole! Le description pote continer ligamines a tote le paginas importante in tu sito.

* '''Comencia nove paginas'''. Non es un problema comenciar con un phrase o duo. Non lassa le pagina vacue intimidar te! In un wiki, il es normal adder e modificar le paginas in modo ad hoc. Tu pote tamben adder imagines e videos, pro completar le pagina e render lo plus interessante.

E postea simplemente continua! Un wiki attractive ha multe cosas a leger e reguardar, dunque continua a adder cosas e tu attrahera lectores e contributores. Il ha multo a facer, ma non te inquieta; hodie es le prime die, e tu ha multe tempore. Omne wiki comencia del mesme modo; pauco a pauco, comenciante con le prime pauc paginas, crescente e transformante se in un grande sito ben frequentate.

Si tu ha questiones, invia nos e-mail per nostre [[Special:Contact|formulario de contacto]]. Bon divertimento!

-- [[User:\$2|\$3]] <staff /></div>",
	'newwikis' => 'Nove wikis',
	'newwikisstart' => 'Monstrar wikis a partir de:',
	'autocreatewiki-reminder-body' => '
Car $1,

Felicitationes pro comenciar tu nove wiki, {{SITENAME}}! Tu pote revenir e adder plus a tu wiki per visitar $2.

Isto es un projecto totalmente nove, dunque per favor scribe nos si tu ha alcun question!


-- Equipa communitari de Wikia',
	'autocreatewiki-reminder-body-HTML' => '<p>Car $1,</p>

<p>Felicitationes pro comenciar tu nove wiki, {{SITENAME}}! Tu pote revenir e adder plus a tu wiki per visitar <a href="$2">$2</a>.</p>

<p>Isto es un projecto totalmente nove, dunque per favor scribe nos si tu ha alcun question!</p>

<p>-- Equipa communitari de Wikia</p>',
	'autocreatewiki-subname-answers' => 'Responsas',
);

/** Indonesian (Bahasa Indonesia)
 * @author Farras
 * @author Irwangatot
 */
$messages['id'] = array(
	'autocreatewiki' => 'Buat wiki baru',
	'autocreatewiki-desc' => 'Buat wiki di WikiFactory dari permintaan pengguna',
	'autocreatewiki-page-title-default' => 'Membuat wiki baru',
	'autocreatewiki-page-title-answers' => 'Buat situs Answers baru',
	'createwiki' => 'Buat wiki baru',
	'autocreatewiki-chooseone' => 'Pilih salah satu',
	'autocreatewiki-required' => '$1 = dibutuhkan',
	'autocreatewiki-web-address' => 'Alamat web:',
	'autocreatewiki-category-select' => 'Pilih salah satu',
	'autocreatewiki-language-top' => '$1 bahasa teratas',
	'autocreatewiki-language-all' => 'Semua bahasa',
	'autocreatewiki-birthdate' => 'Tanggal lahir:',
	'autocreatewiki-blurry-word' => 'Kata tersamar:',
	'autocreatewiki-remember' => 'Ingat saya',
	'autocreatewiki-create-account' => 'Buat akun',
	'autocreatewiki-done' => 'Selesai',
	'autocreatewiki-error' => 'kesalahan',
	'autocreatewiki-haveaccount-question' => 'Apakah anda sudah memiliki akun Wikia?',
	'autocreatewiki-success-title-default' => 'Wiki anda telah dibuat!',
	'autocreatewiki-success-title-answers' => 'Situs answers anda terlah dibuat!',
	'autocreatewiki-success-subtitle' => 'Sekarang anda dapat mulai bekerja di wiki Anda dengan mengunjungi:',
	'autocreatewiki-success-has-been-created' => 'telah dibuat!',
	'autocreatewiki-success-get-started' => 'Memulai',
	'autocreatewiki-info-domain' => 'Lebih baik menggunakan kata kunci pencarian paling digemari sebagai  topik anda.',
	'autocreatewiki-info-topic' => 'Tambahkan penjelasan singkat seperti "Star Wars" atau "Acara TV".',
	'autocreatewiki-info-category-default' => 'Hal ini akan membantu pengunjung menemukan wiki Anda.',
	'autocreatewiki-info-category-answers' => 'Hal ini akan membantu pengunjung menemukan situs Answers anda.',
	'autocreatewiki-info-language' => 'Ini akan menjadi bahasa baku untuk pengunjung ke wiki Anda.',
	'autocreatewiki-info-email-address' => 'Alamat surat elektronik Anda tidak pernah ditunjukkan kepada siapa pun di Wikia.',
	'autocreatewiki-info-realname' => 'Jika anda memilih menyediakan ini akan di gunakan  untuk memberi pengenalan atas hasil kerja Anda.',
	'autocreatewiki-info-birthdate' => 'Wikia mengharuskan semua pengguna untuk memberikan tanggal lahir nyata mereka sebagai tindakan pencegahan keamanan dan sebagai cara untuk menjaga integritas dari situs ini sekaligus mematuhi peraturan federal.',
	'autocreatewiki-info-blurry-word' => 'Untuk membantu melindungi terhadap pembuatan akun otomatis, silahkan ketik kata buram yang Anda lihat ke dalam bidang ini.',
	'autocreatewiki-info-terms-agree' => 'Dengan membuat wiki dan akun pengguna,Anda setuju dengan <a href="http://www.wikia.com/wiki/Terms_of_use">Syarat Penggunaan Wikia</a>',
	'autocreatewiki-info-staff-username' => '<b>Hanya staf:</b> Pengguna yang ditetapkan  akan terdaftar sebagai pendiri.',
	'autocreatewiki-title-template' => '$1 Wiki',
	'autocreatewiki-limit-day' => 'Wikia telah melampaui jumlah maksimum pembuatan wiki hari ini ($1).',
	'autocreatewiki-limit-creation' => 'Anda telah melebihi jumlah maksimum pembuatan wiki dalam 24 jam ($1).',
	'autocreatewiki-empty-field' => 'Silakan isi bagian ini.',
	'autocreatewiki-bad-name' => 'Nama tidak boleh berisi karakter khusus (seperti $ atau @) dan harus satu kata dalam huruf kecil tanpa spasi .',
	'autocreatewiki-invalid-wikiname' => 'Nama tidak boleh berisi karakter khusus (seperti $ atau @) dan tidak boleh kosong',
	'autocreatewiki-violate-policy' => 'Nama wiki ini berisi kata yang melanggar kebijakan penamaan kami',
	'autocreatewiki-name-taken' => 'Wiki dengan nama ini sudah ada. Anda dipersilakan untuk bergabung dengan kami di <a href="http://$1.wikia.com">http:// $1.wikia.com</a>',
	'autocreatewiki-name-too-short' => 'Nama ini terlalu pendek. Silakan pilih nama setidaknya memiliki 3 karakter.',
	'autocreatewiki-name-too-long' => 'Nama ini terlalu panjang. Silakan pilih nama maksimal 50 karakter.',
	'autocreatewiki-similar-wikis' => 'Di bawah ini adalah wiki yang sudah dibuat dengan topik ini. Kami menyarankan penyuntingan salah satu dari mereka.',
	'autocreatewiki-invalid-username' => 'Nama pengguna ini tidak sah.',
	'autocreatewiki-busy-username' => 'Nama pengguna ini sudah digunakan.',
	'autocreatewiki-blocked-username' => 'Anda tak dapat membuat Akun.',
	'autocreatewiki-user-notloggedin' => 'Akun anda telah dibuat tetapi belum masuk log!',
	'autocreatewiki-empty-language' => 'Silakan pilih bahasa untuk wiki.',
	'autocreatewiki-empty-category' => 'Silakan pilih salah satu kategori.',
	'autocreatewiki-empty-wikiname' => 'Nama wiki tidak boleh kosong.',
	'autocreatewiki-empty-username' => 'Nama pengguna tidak boleh kosong.',
	'autocreatewiki-empty-password' => 'Kata sandi tidak boleh kosong.',
	'autocreatewiki-empty-retype-password' => 'Kata sandi ulang tidak boleh kosong.',
	'autocreatewiki-category-label' => 'Kategori:',
	'autocreatewiki-category-other' => 'Lainnya',
	'autocreatewiki-set-username' => 'Atur nama pengguna lebih dulu.',
	'autocreatewiki-invalid-category' => 'Nilai tidak sah dari kategori. 
Silakan pilih yang benar dari daftar pilihan.',
	'autocreatewiki-invalid-language' => 'Nilai tidak sah dari bahasa. 
Silakan pilih yang benar dari daftar pilihan.',
	'autocreatewiki-invalid-retype-passwd' => 'Silahkan ketik kembali kata kunci yang sama seperti di atas',
	'autocreatewiki-invalid-birthday' => 'Tanggal lahir tidak sah',
	'autocreatewiki-limit-birthday' => 'Tidak dapat membuat pendaftaran.',
	'autocreatewiki-log-title' => 'Wiki anda telah dibuat!',
	'autocreatewiki-step0' => 'Memulai proses ...',
	'autocreatewiki-stepdefault' => 'Proses berjalan, harap tunggu ...',
	'autocreatewiki-errordefault' => 'Proses belum selesai ...',
	'autocreatewiki-step1' => 'Membuat folder gambar ...',
	'autocreatewiki-step2' => 'Membuat basis data...',
	'autocreatewiki-step3' => 'Mengatur informasi baku dalam basis data...',
	'autocreatewiki-step4' => 'Menyalin gambar dan logo baku ...',
	'autocreatewiki-step5' => 'Pengaturan variabel baku dalam basis data ...',
	'autocreatewiki-step6' => 'Mengatur tabel baku dalam basis data...',
	'autocreatewiki-step7' => 'Menetapkan bahasa pemulai...',
	'autocreatewiki-step8' => 'Mengatur kelompok pengguna dan kategori ...',
	'autocreatewiki-step9' => 'Pengaturan variabel untuk wiki baru ...',
	'autocreatewiki-step10' => 'Mengatur halaman pada wiki pusat ...',
	'autocreatewiki-step11' => 'Mengirim surel ke pengguna ...',
	'autocreatewiki-redirect' => 'Pengalihan ke wiki baru: $1 ...',
	'autocreatewiki-congratulation' => 'Selamat!',
	'autocreatewiki-welcometalk-log' => 'Pesan Selamat Datang',
	'autocreatewiki-regex-error-comment' => 'digunakan dalam wiki $1 (semua teks: $2)',
	'autocreatewiki-step2-error' => 'Database ada!',
	'autocreatewiki-step3-error' => 'Tidak dapat mengatur informasi baku dalam basisdata!',
	'autocreatewiki-step6-error' => 'Dapat tidak menetapkan tabel baku dalam basisdata!',
	'autocreatewiki-step7-error' => 'Tidak dapat menyalin basisdata pemulai untuk bahasa!',
	'autocreatewiki-protect-reason' => 'Bagian dari antarmuka resmi',
	'autocreatewiki-welcomesubject' => '$1 telah dibuat!',
	'autocreatewiki-welcomebody' => 'Halo, $2, 

Permintaan Wikia Anda sekarang tersedia di <$1> Kami berharap dapat melihat Anda meyunting disana segera! 

Kami telah menambahkan beberapa Informasi dan Tips pada halaman Pembicaraan Pengguna Anda (<$5>) untuk membantu Anda memulai. 

Jika Anda memiliki masalah, Anda dapat meminta bantuan komunitas di wiki di <http://www.wikia.com/wiki/Forum:Help_desk> , Atau melalui surel ke community@wikia.com. Anda juga dapat mengunjungi kami ruang obrolan IRC #wikia <http://irc.wikia.com> . 

Saya dapat dihubungi langsung melalui email atau di halaman pembicaraan saya, jika Anda memiliki pertanyaan atau masalah. 

Semoga berhasil dengan proyek ini! 

$3 

Tim Komunitas Wikia 

<http://www.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => "== Selamat Datang! ==
<div style=\"font-size:120%; line-height:1.2em;\">Hi \$1 -- kami sangat gembira untuk memiliki '''\$4''' sebagai bagian dari komunitas Wikia! 

Sekarang Anda punya website secara utuh untuk diisi dengan informasi, gambar dan video tentang topik kesukaan Anda. Tapi sekarang, itu hanya halaman kosong mengunggu anda ... Menyeramkan, bukan? Berikut adalah beberapa cara untuk memulai. 

*'''Mengenalkan topik Anda''' di halaman depan. Ini adalah kesempatan Anda untuk menjelaskan kepada pembaca tentang topik Anda. Menulis sebanyak yang Anda inginkan! deskripsi Anda dapat menghubungkan ke semua halaman yang penting di situs Anda. 

*'''Mulai beberapa halaman baru''' - hanya satu atau dua kalimat baik untuk memulai. Jangan biarkan halaman kosong menunggu! Wiki adalah semua tentang menambah dan mengubah hal-hal selama Anda pergi. Anda juga dapat menambahkan gambar dan video, untuk mengisi halaman dan membuatnya lebih menarik. 

Dan kemudian teruskan! Orang-orang senang mengunjungi wiki ketika ada banyak hal untuk dibaca dan dilihat, sehingga terus menambahkan hal-hal lain, dan Anda akan menarik pembaca dan penyunting. Ada banyak yang harus dilakukan, tapi jangan khawatir - hari ini hari pertama Anda, dan Anda punya banyak waktu. Setiap wiki dimulai dengan cara yang sama - sedikit demi sedikit, dimulai dengan beberapa halaman pertama, sampai tumbuh menjadi situs yang besar dan sibuk. 

Jika Anda punya pertanyaan, Anda dapat mengirim kami sur-el melalui [[Special:Contact|formulir]]. Selamat bersenang-senang! 

-- [[User:\$2|\$3]] <staff /></div>",
	'newwikis' => 'Wiki baru',
	'newwikisstart' => 'Tampilkan wiki diawali dengan:',
	'autocreatewiki-reminder-body' => 'Wahai $1:

Selamat atas dimulainya wiki, {{SITENAME}} baru Anda! Anda dapat kembali dan menambahkan lagi ke wiki Anda dengan mengunjungi $2.

Ini adalah proyek baru, jadi silahkan menulis kepada kami jika Anda memiliki pertanyaan!

-- Tim Komunitas Wikia',
	'autocreatewiki-reminder-body-HTML' => '<p>Wahai $1:</p>

<p>Selamat atas dimulainya wiki, {{SITENAME}} baru Anda! Anda dapat kembali dan menambahkan lagi ke wiki Anda dengan mengunjungi
<a href="$2">$2</a>.</p>

<p>Ini adalah proyek baru, jadi silahkan menulis kepada kami jika Anda memiliki pertanyaan!</p>

<p>-- Tim Komunitas Wikia</p>',
	'autocreatewiki-subname-answers' => 'Answers',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'autocreatewiki-category-select' => 'Kpàtá otụ',
	'autocreatewiki-category-label' => 'Ébéonọr:',
	'newwikis' => 'Wiki ne ohụru',
	'autocreatewiki-subname-answers' => 'Nza okwu',
);

/** Italian (Italiano)
 * @author Gifh
 */
$messages['it'] = array(
	'autocreatewiki' => 'Crea un nuovo wiki',
	'autocreatewiki-page-title-default' => 'Crea un nuovo wiki',
	'autocreatewiki-birthdate' => 'Data di nascita:',
	'autocreatewiki-create-account' => 'Crealo ora',
	'autocreatewiki-error' => 'errore',
	'autocreatewiki-category-other' => 'Altro',
	'autocreatewiki-congratulation' => 'Congratulazioni!',
	'autocreatewiki-protect-reason' => "parte dell'interfaccia ufficiale",
	'autocreatewiki-welcomebody' => 'Ciao $2,

La wikia che hai creato è ora disponibile su <$1>. Speriamo di vedere i tuoi contributi al più presto! <br /> Abbiamo aggiunto alcune informazione e suggerimenti alla tua pagina di discussione (<$5>) per aiutarti a mettere in moto la tua wiki. Per qualunque domanda, puoi rispondere a questa email o controllare sulle pagina di aiuto su <http://help.wikia.com>.

Buona fortuna per il progetto,

$3 Wikia Community Team <http://www.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => "== Benvenuto! ==
Ciao \$1 -- siamo molto contenti di avere '''\$4''' nella nostra Wikia community!   Grazie per la tua collaborazione! Ti vogliamo dare alcuni suggerimenti per aiutarti a mettere in moto la tua wiki.


=== '''I tuoi primi quattro passi:''' ===
1. '''Crea la tua [[Utente:\$1|Pagina Utente]]''' - è il posto per parlare di te stesso e farti conoscere (e fare pratica!)

2. '''Aggiungi un logo''' - impara come su [[w:c:help:Help:Logo|come creare un logo]], e poi <span class=\"plainlinks\">[[Speciale:Carica/Wiki.png|clicca qui]]</span> per aggiungerlo alla tua wiki.<div style=\"border: 1px solid black; margin: 0px 0px 5px 10px; padding: 5px; float: right; width: 25%;\"><center>Crea un articolo per questa wiki:</center>
   <createbox>
width=30
</createbox></div>
3. '''Crea i tuoi primi 10 articoli''' - usa il campo sulla destra per creare la pagine, iniziando con poche righe per ogni articolo.

4. '''Modifica la pagina principale''' - clicca sul logo e raggiungi la pagina principale. Ricordati di aggiungere dei link interni ([[come questo]]) per raggiungere le nuove pagine che hai appena creato.


Dopo aver seguito tutti i passi sei già a buon punto! La tua wiki deve sembrare attiva ed aperta ai nuovi utenti. Puoi sempre chiedere ai tuoi amici di aiutarti, oppure invitare nuove persone a creare nuovi articoli o modificare quelli già esistenti.

Più pagine e link vengono creati e più velocemente la tua wiki diventerà popolare. I visitatori che cercheranno \"\$4\" saranno in grado di trovarlo facilmente.

Per qualunque altre domanda, puoi leggere le [[Help:Contents|pagine di aiuto]], oppure spedirci un'e-mail attraverso il nostro [[Special:Contact|modulo dei contatti]]. Non dimenticare di controllare le altre wiki su [[wikia:Wikia|Wikia]] per idee, template, layout e molto altro!

Buona fortuna, [[User:\$2|\$3]] <staff />",
);

/** Japanese (日本語)
 * @author Naohiro19
 * @author Tommy6
 * @author 青子守歌
 */
$messages['ja'] = array(
	'autocreatewiki' => '新しいWikiを作成する',
	'autocreatewiki-desc' => '利用者からのリクエストによりWikiFactoryでウィキを作成する',
	'autocreatewiki-page-title-default' => '新しいウィキの作成',
	'autocreatewiki-page-title-answers' => '新しいQ&amp;Aサイトの作成',
	'createwiki' => '新しいウィキのお申し込みはこちら!',
	'autocreatewiki-chooseone' => '一つを選ぶ',
	'autocreatewiki-required' => '$1 = 必須',
	'autocreatewiki-web-address' => 'サイトのアドレス:',
	'autocreatewiki-category-select' => 'どれか一つを選ぶ',
	'autocreatewiki-language-top' => '上位$1言語',
	'autocreatewiki-language-all' => '全ての言語',
	'autocreatewiki-birthdate' => '生年月日:',
	'autocreatewiki-blurry-word' => '画像認証:',
	'autocreatewiki-remember' => 'パスワードを記憶する。',
	'autocreatewiki-create-account' => 'アカウントを作成する',
	'autocreatewiki-done' => '完了',
	'autocreatewiki-error' => 'エラー',
	'autocreatewiki-haveaccount-question' => 'すでにウィキアのアカウントをお持ちですか？',
	'autocreatewiki-success-title-default' => 'ウィキが作成されました！',
	'autocreatewiki-success-title-answers' => 'Q&amp;Aサイトが作成されました！',
	'autocreatewiki-success-subtitle' => '下記のURLをクリックして作業を開始できます',
	'autocreatewiki-success-has-been-created' => 'が作成されました！',
	'autocreatewiki-success-get-started' => 'さあ始めましょう',
	'autocreatewiki-info-domain' => 'ウィキが扱う内容を表し、検索キーワードとなるようなものがよいでしょう。',
	'autocreatewiki-info-topic' => '"Star Wars"や"テレビ番組"など、ウィキの主題を簡単に示すような名称にしましょう。',
	'autocreatewiki-info-category-default' => '作成したサイトを訪問者が見つけるられるような手がかりにするためのものです。',
	'autocreatewiki-info-category-answers' => '作成したサイトを訪問者が見つけるられるような手がかりにするためのものです。',
	'autocreatewiki-info-language' => 'ここで指定した言語が、ウィキの訪問者に対して標準で表示される言語になります。',
	'autocreatewiki-info-email-address' => 'あなたのメールアドレスがウィキア上で誰かに直接知らされることはありません。',
	'autocreatewiki-info-realname' => '本名を入力すると、ページ・クレジットに利用者名（アカウント名）の代わりに本名が表示されます。',
	'autocreatewiki-info-birthdate' => 'ウィキアでは、アメリカ合衆国の法規定を満たす上で、サイトの品質を維持するための手段及び安全のための予防策としてすべての利用者に対して生年月日の入力を求めています。',
	'autocreatewiki-info-blurry-word' => 'ツールなどによる自動アカウント作成を防ぐため、画像で表示された文字を入力してください。',
	'autocreatewiki-info-terms-agree' => 'ウィキ及びアカウントを作成すると、<a href="http://www.wikia.com/wiki/Terms_of_use">ウィキアの利用規約</a>（<a href="http://ja.wikia.com/wiki/%E5%88%A9%E7%94%A8%E8%A6%8F%E7%B4%84">非公式日本語訳</a>）に同意したことになります。',
	'autocreatewiki-info-staff-username' => '<b>スタッフオンリー:</b> 指定されたユーザーが設立者としてリストされます。',
	'autocreatewiki-title-template' => '$1 ウィキ',
	'autocreatewiki-limit-day' => '一日にウィキアが作成可能なウィキの最大数を超えています。($1)',
	'autocreatewiki-limit-creation' => '24時間であなたが作成できるウィキの最大数を超えています。($1)',
	'autocreatewiki-empty-field' => 'この項目は空白にはできません。',
	'autocreatewiki-bad-name' => 'URLには$や@などの文字は使えません。また、ローマ字は全てスペースなしの小文字でなければなりません。',
	'autocreatewiki-invalid-wikiname' => '&quot;&lt;&quot;など、一部の文字はウィキ名に使用できません。また、空白にもできません。',
	'autocreatewiki-violate-policy' => 'このウィキ名には、ウィキアの方針上問題のある単語が含まれています。',
	'autocreatewiki-name-taken' => 'この名称のウィキは既にあります。<a href="http://$1.wikia.com">http://$1.wikia.com</a>に是非ご参加ください。',
	'autocreatewiki-name-too-short' => 'アドレスが短すぎます。3文字以上のアドレスを指定してください。',
	'autocreatewiki-name-too-long' => 'アドレスが長すぎます。50文字以下のアドレスを指定してください。',
	'autocreatewiki-similar-wikis' => 'この主題について扱っているウィキとして下記のようなものがすでに存在します。これらのうちのどれかを編集することをお勧めいたします。',
	'autocreatewiki-invalid-username' => 'この利用者名は不適切です。',
	'autocreatewiki-busy-username' => 'この利用者名はすでに使われています。',
	'autocreatewiki-blocked-username' => 'アカウントを作成できません。',
	'autocreatewiki-user-notloggedin' => 'アカウントは作成されましたがログイン状態になっていません！',
	'autocreatewiki-empty-language' => 'ウィキで使用する言語を選んでください。',
	'autocreatewiki-empty-category' => 'どれか一つカテゴリを選んでください。',
	'autocreatewiki-empty-wikiname' => 'ウィキ名は空白にはできません。',
	'autocreatewiki-empty-username' => '利用者名は空にはできません。',
	'autocreatewiki-empty-password' => 'パスワードは空にはできません。',
	'autocreatewiki-empty-retype-password' => 'パスワードの再入力が空です。',
	'autocreatewiki-category-label' => 'カテゴリ：',
	'autocreatewiki-category-other' => 'その他',
	'autocreatewiki-set-username' => 'まず利用者名を設定してください。',
	'autocreatewiki-invalid-category' => 'カテゴリの値が不適切です。ドロップダウンリストから適切なものを選んでください。',
	'autocreatewiki-invalid-language' => '言語の値が不適切です。ドロップダウンリストから適切なものを選んでください。',
	'autocreatewiki-invalid-retype-passwd' => '上のパスワードと同じものを再入力してください。',
	'autocreatewiki-invalid-birthday' => '不適切な生年月日です',
	'autocreatewiki-limit-birthday' => '登録できません。',
	'autocreatewiki-log-title' => 'ウィキが作成されています...',
	'autocreatewiki-step0' => 'プロセスを初期化しています...',
	'autocreatewiki-stepdefault' => 'プロセスが進行中です, お待ちください...',
	'autocreatewiki-errordefault' => 'プロセスが完了しませんでした。',
	'autocreatewiki-step1' => 'imagesフォルダを作成しています...',
	'autocreatewiki-step2' => 'データベースを作成しています...',
	'autocreatewiki-step3' => 'データベースに初期情報を設定しています...',
	'autocreatewiki-step4' => '初期設定画像とロゴをコピーしています...',
	'autocreatewiki-step5' => 'データベースに初期変数を設定しています...',
	'autocreatewiki-step6' => 'データベースに初期テーブルを設定しています...',
	'autocreatewiki-step7' => '標準言語のスターターを設定しています...',
	'autocreatewiki-step8' => '利用者グループ及びカテゴリを設定しています...',
	'autocreatewiki-step9' => '新しいウィキに変数を設定しています...',
	'autocreatewiki-step10' => 'セントラルウィキアにページを設置しています...',
	'autocreatewiki-step11' => '利用者にメールを送信しています...',
	'autocreatewiki-redirect' => '新しいウィキに転送しています: $1 ...',
	'autocreatewiki-congratulation' => 'Congratulations!',
	'autocreatewiki-welcometalk-log' => '自動メッセージ',
	'autocreatewiki-regex-error-comment' => 'ウィキ $1 で使用されています（全文: $2）',
	'autocreatewiki-step2-error' => 'データベースは既に存在します！',
	'autocreatewiki-step3-error' => 'データベースに初期情報を設定できません！',
	'autocreatewiki-step6-error' => 'データベースに初期テーブルを設定できません！',
	'autocreatewiki-step7-error' => 'スターターのデータベースをコピーできません！',
	'autocreatewiki-protect-reason' => '公式インターフェースの一部です',
	'autocreatewiki-welcomesubject' => '$1 が作成されました！',
	'autocreatewiki-welcomebody' => '$2 さん、

申請ありがとうございます。申請されたウィキアは <$1> で利用可能です。すぐにでも編集を始めてくれるとこちらとしてもうれしく思います。

$2さんの会話ページ <$5> に、利用にあたっての情報などを追加しておきました。また、<http://ja.wikia.com/wiki/Help:%E3%83%88%E3%83%83%E3%83%97%E3%83%9A%E3%83%BC%E3%82%B8> にヘルプも用意されています。何か問題があったときは、フォーラム <http://ja.wikia.com/wiki/Forum:Index> でお尋ねください。また、freenode上のIRCチャンネル #wikia-ja でウィキを問わずコミュニティの方々が議論をしていますので、アドバイスが欲しい場合は遠慮無くログインしてみてください。

それでは、プロジェクトの今後を期待しております。

$3
コミュニティ・チーム
<http://www.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => '$1さん、$4の申請ありがとうございます。

ウィキを開始するというのはとても大変ですが、もし、何か困ったことがあったら、是非とも[[w:Community Team|ウィキアのコミュニティチーム]]までどうぞ。利用者向けガイドもいくつかこのウィキにありますので、是非とも御覧ください。サイトデザインやコンテンツの作り方に迷ったら、[[w:c:ja:プロジェクトポータル|ウィキアの他のプロジェクト]]をチェックして見てください。ウィキア全体がその良い参考例になるはずです。
* まずは、良いウィキを作るために[[w:c:ja:Help:ウィキの開始|ウィキを開始するにあたってのアドバイス]]を御覧ください。
* また、それらをまとめた[[w:c:ja:Help:良いウィキを作るコツ|ウィキを作るコツ]]も御覧になってください。
* ウィキ自体が初めてなら、[[w:c:ja:Help:FAQ|FAQ]]もあります。
ウィキア自体のヘルプを[[w:c:ja:Help:トップページ|日本語でまとめています]]ので、詳細な情報はこちらを御覧ください。相談ごとは、[[Special:Contact|連絡用ページ]]からどうぞ。IRCチャンネルの #wikia-ja で、他の利用者とコンタクトすることもできます。是非とも御利用ください。

それでは、今後とも、よろしくお願いします。--[[User:$2|$3]] <staff />',
	'newwikis' => '新しいウィキ',
	'newwikisstart' => '次の文字列から始まるウィキを表示:',
	'autocreatewiki-reminder-body' => '$1 さん、

新しいウィキの開始おめでとうございます。$1 さんが作成した $2 には、いつでも戻って情報を追加することができます。

このプロジェクトはできたばかりの状態です。もし、何か質問があれば、私たちまでおたずねください。

-- Wikia Community Team',
	'autocreatewiki-reminder-body-HTML' => '<p>$1 さん、</p>
<p>新しいウィキの開始おめでとうございます。$1 さんが作成した <a href="$2">$2</a> には、いつでも戻って情報を追加することができます。</p>
<p>このプロジェクトはできたばかりの状態です。もし、何か質問があれば、私たちまでおたずねください。</p>
<p>-- Wikia Community Team</p>',
	'autocreatewiki-subname-answers' => 'Answers',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'autocreatewiki' => 'Eng nei Wiki uleeën',
	'autocreatewiki-page-title-default' => 'Eng nei Wiki uleeën',
	'createwiki' => 'Eng nei Wiki uleeën',
	'autocreatewiki-chooseone' => 'Eng eraussichen',
	'autocreatewiki-category-select' => 'Eng eraussichen',
	'autocreatewiki-language-all' => 'All Sproochen',
	'autocreatewiki-birthdate' => 'Gebuertsdatum:',
	'autocreatewiki-remember' => 'Sech u mech erënneren',
	'autocreatewiki-done' => 'fäerdeg',
	'autocreatewiki-error' => 'Feeler',
	'autocreatewiki-success-get-started' => 'Ufänken',
	'autocreatewiki-invalid-username' => 'Dëse Benotzernumm ass net valabel.',
	'autocreatewiki-empty-username' => 'De Benotzernumm kann net eidel sinn.',
	'autocreatewiki-empty-password' => "D'Passwuert kann net eidel sinn.",
	'autocreatewiki-log-title' => 'Är Wiki gëtt ugeluecht',
	'autocreatewiki-congratulation' => 'Gratulatioun!',
	'autocreatewiki-welcometalk-log' => 'Wëllkommensmessage',
	'autocreatewiki-step2-error' => "D'Datebank gëtt et!",
	'newwikis' => 'Nei Wikien',
	'autocreatewiki-subname-answers' => 'Äntwerten',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'autocreatewiki' => 'Создај ново вики',
	'autocreatewiki-desc' => 'Создавање на вики во ВикиФабрика по барања на корисници',
	'autocreatewiki-page-title-default' => 'Создај ново вики',
	'autocreatewiki-page-title-answers' => 'Создај нова страница за одговори',
	'createwiki' => 'Создај ново вики',
	'autocreatewiki-chooseone' => 'Изберете',
	'autocreatewiki-required' => '$1 = задолжително',
	'autocreatewiki-web-address' => 'Мреж. адреса:',
	'autocreatewiki-category-select' => 'Одберете',
	'autocreatewiki-language-top' => 'Најуспешни $1 јазици',
	'autocreatewiki-language-all' => 'Сите јазици',
	'autocreatewiki-birthdate' => 'Датум на раѓање:',
	'autocreatewiki-blurry-word' => 'Заматен збор:',
	'autocreatewiki-remember' => 'Запомни ме',
	'autocreatewiki-create-account' => 'Создај сметка',
	'autocreatewiki-done' => 'готово',
	'autocreatewiki-error' => 'грешка',
	'autocreatewiki-language-top-list' => 'de,en,es,he,fr,it,ja,no,pl,pt,pt-br,zh',
	'autocreatewiki-haveaccount-question' => 'Дали веќе имате сметка на Викија?',
	'autocreatewiki-success-title-default' => 'Вашето вики е создадено!',
	'autocreatewiki-success-title-answers' => 'Вашата страница за одговори е создадена!',
	'autocreatewiki-success-subtitle' => 'Сега можете да почнете да работите на вашето вики со посетување на:',
	'autocreatewiki-success-has-been-created' => 'е создадено!',
	'autocreatewiki-success-get-started' => 'Започнете',
	'autocreatewiki-info-domain' => 'Најдобро е да се користи збор што веројатно би бил клучен збор за пребарување на вашата тема.',
	'autocreatewiki-info-topic' => 'Додајте краток опис, од типот „Војна на ѕвездите“, или „ТВ емисии“.',
	'autocreatewiki-info-category-default' => 'Ова ќе им помогне на посетителите да го  најдат вашето вики.',
	'autocreatewiki-info-category-answers' => 'Ова ќе им помогне на посетителите да ја најдат вашата страница за одговори.',
	'autocreatewiki-info-language' => 'Ова ќе биде автоматски-зададениот јазик за посетителите на вашето вики.',
	'autocreatewiki-info-email-address' => 'Вашата е-поштенска адреса никогаш не се покажува никому на Викија.',
	'autocreatewiki-info-realname' => 'Доколку изберете да го наведете вашето име, истото ќе се користи за оддавање на заслуги за вашата работа.',
	'autocreatewiki-info-birthdate' => 'Викија бара сите корисници да го наведат нивниот датум на раѓање како безбедносна мерка, но и каконачин на зачувување на интегритетот на ова мрежно место, истовремено придржувајќи се до федералните регулативи.',
	'autocreatewiki-info-blurry-word' => 'За да ни помогнете да се заштитиме од автоматизирано создавање на сметки, внесете го заматениот збор прикажан во ова поле.',
	'autocreatewiki-info-terms-agree' => 'Со тоа што го создавате ова вики и корисничка сметка, вие се согласувате со <a href="http://www.wikia.com/wiki/Terms_of_use">Условите на употреба на Викија</a>',
	'autocreatewiki-info-staff-username' => '<b>Само за персонал:</b> Назначениот корисник ќе биде заведен како основач.',
	'autocreatewiki-title-template' => '$1 вики',
	'autocreatewiki-limit-day' => 'Викија го надмина максималниот дозволен број на создадени викија за денес ($1).',
	'autocreatewiki-limit-creation' => 'Го надминавте максималниот број на создадени викија во рок од 24 часа ($1).',
	'autocreatewiki-empty-field' => 'Пополнете го ова поле.',
	'autocreatewiki-bad-name' => 'Името не може да содржи специјални знаци (како $ или @) и мора да еден збор составен од мали букви, без празни места помеѓу нив.',
	'autocreatewiki-invalid-wikiname' => 'Името не може да содржи специјални знаци (како $ или @) и не може да стои празно',
	'autocreatewiki-violate-policy' => 'Името на ова вики содржи збор што ги прекршува нашите правила за именување',
	'autocreatewiki-name-taken' => 'Веќе постои вики со тоа име. Добредојдени сте да ни се придружите на <a href="http://$1.wikia.com">http://$1.wikia.com</a>',
	'autocreatewiki-name-too-short' => 'Името е прекратко. Одберете име со барем 3 знаци.',
	'autocreatewiki-name-too-long' => 'Името е предолго. Одберете име со највеќе 50 знаци.',
	'autocreatewiki-similar-wikis' => 'Подолу се наведени веќе создадените викија на оваа тема. Ви предлагаме да уредувате некое од нив.',
	'autocreatewiki-invalid-username' => 'Ова корисничко име е неважечко.',
	'autocreatewiki-busy-username' => 'Ова корисничко име е веќе зафатено.',
	'autocreatewiki-blocked-username' => 'Не можете да создадете сметка.',
	'autocreatewiki-user-notloggedin' => 'Вашата сметка е создадена, но не сте најавени со неа!',
	'autocreatewiki-empty-language' => 'Одберете јазик за викито.',
	'autocreatewiki-empty-category' => 'Одберете една категорија.',
	'autocreatewiki-empty-wikiname' => 'Името на викито не може да стои празно.',
	'autocreatewiki-empty-username' => 'Корисничкото име не може да стои празно.',
	'autocreatewiki-empty-password' => 'Лозинката не може да стои празна.',
	'autocreatewiki-empty-retype-password' => 'Превнесувањето на лозинката не може да стои празно.',
	'autocreatewiki-category-label' => 'Категорија:',
	'autocreatewiki-category-other' => 'Друго',
	'autocreatewiki-set-username' => 'Најпрвин постави корисничко име.',
	'autocreatewiki-invalid-category' => 'Неважечка вредност на категоријата. Одберете правилна категорија од паѓачкиот список.',
	'autocreatewiki-invalid-language' => 'Неважечка вредност за јазик. Одберете правилна вредност од паѓачкиот список.',
	'autocreatewiki-invalid-retype-passwd' => 'Превнесете ја истата лозинка од погоре',
	'autocreatewiki-invalid-birthday' => 'Неважечки датум на раѓање',
	'autocreatewiki-limit-birthday' => 'Не можам да ја создадам регистрацијата.',
	'autocreatewiki-log-title' => 'Вашето вики се создава',
	'autocreatewiki-step0' => 'Иницијализација на процесот...',
	'autocreatewiki-stepdefault' => 'Процесот е во тек. Почекајте...',
	'autocreatewiki-errordefault' => 'Процесот не е довршен ...',
	'autocreatewiki-step1' => 'Ја создавам папката за слики ...',
	'autocreatewiki-step2' => 'Ја создавам базата на податоци ...',
	'autocreatewiki-step3' => 'Поставувам основно-зададени информации во базата на податоци ...',
	'autocreatewiki-step4' => 'Ги копирам основно-зададените слики и лого ...',
	'autocreatewiki-step5' => 'Ги поставувам основно-зададените променливи во базата на податоци ...',
	'autocreatewiki-step6' => 'Ги поставувам основно-зададените табели во базата на податоци ...',
	'autocreatewiki-step7' => 'Го поставувам почетниот утврдувач на јазик ...',
	'autocreatewiki-step8' => 'Поставувам кориснички групи и категории ...',
	'autocreatewiki-step9' => 'Поставувам променливи за новото вики ...',
	'autocreatewiki-step10' => 'Поставувам страници на централното вики ...',
	'autocreatewiki-step11' => 'Испраќам е-пошта до корисникот ...',
	'autocreatewiki-redirect' => 'Пренасочувам кон новото вики: $1 ...',
	'autocreatewiki-congratulation' => 'Честитки!',
	'autocreatewiki-welcometalk-log' => 'Порака за добредојде',
	'autocreatewiki-regex-error-comment' => 'се користи на викито $1 (цел текст: $2)',
	'autocreatewiki-step2-error' => 'Базата на податоци постои!',
	'autocreatewiki-step3-error' => 'Неможам да поставам основно-зададени информации во базата на податоци!',
	'autocreatewiki-step6-error' => 'Не можам да поставам основно-зададени табели во базата на податоци!',
	'autocreatewiki-step7-error' => 'Не можам да ја ископирам почетната база на податоци за јазик!',
	'autocreatewiki-protect-reason' => 'Дел од официјалниот посредник',
	'autocreatewiki-welcomesubject' => '$1 е создадено!',
	'autocreatewiki-welcomebody' => 'Здраво, $2,

Викијата која ја побаравте сега е достапна на <$1> Се надеваме дека наскоро ќе почнете да ја уредувате!

Додадовме и некои информации и совети на вашата корисничка страница за разговор (<$5>) за да ви помогнеме да започнете со работа.

Ако имате било какви проблеми, слободно побарајте помош од заедницата на <http://www.wikia.com/wiki/Forum:Help_desk>, или по е-пошта, на адресата community@wikia.com. Можете и да го посетите нашиот ИРЦ-канал #wikia за разговори во живо<http://irc.wikia.com>.

Ако имате било какви прашања и проблеми, можете да ме контактирате директно по е-пошта, или пак на мојата страница за разговор.

Со среќа!

$3

Екипата на Викија-заедницата

<http://www.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => "== Добредојдовте! ==
<div style=\"font-size:120%; line-height:1.2em;\">Здраво \$1 -- баш ни е драго што го имаме викито '''\$4''' како дел од заедницата на Викија!

Сега имате една цело мрежното место за пополнување со информации, слики и видеоснимки на вашите омилени теми. Но засега има само страници што зјаат во вас празни... Застрашувачки, нели? Еве како можете да започнете.

* '''Напишете вовед за вашата тема''' на насловната страница. Ова е прилика да им објасните на читателите за какво вики се работи и која е темата. Пишувајте колку што сакате! Во писот може да се поврзат сите важни страници на викито.

* '''Започнете некои нови страници''' -- за почеток доволни се реченица-две. Не дозволувајте празнотијата да ве уплаши! Секое вики служи за додавање и менување на разни нешта како што тече времето. Можете да додавате и слики и видеоснимки за да ја пополните страницата и да ја направите поинтересна.

И само терајте! Луѓето многу сакаат да посетуваат викија кајшто има многу што да се прочита и разгледа, па затоа постојано додавајте разни нешта, и така ќе привлечете читатели и уредници. Има многу што да се работи, но не грижете се -- денес ви е прв ден, и имате многу време. Секое вики започнува исто -- малку по малку, почнувајќи со првите неколку страници, па со време нараснува во огромно, посетено и активно мрежно место.

Ако имате било какви прашања, обратете ни се по е-пошта преку вашиот [[Special:Contact|контактен образец]]. Забавувајте се!

-- [[User:\$2|\$3]] <staff /></div>",
	'newwikis' => 'Нови викија',
	'newwikisstart' => 'Прикажи викија со почеток во:',
	'autocreatewiki-reminder-body' => 'Почитуван(а) $1:

Ви го честитаме започнувањето на вашето ново вики, {{SITENAME}}! Можете да се навратите и да додавате уште нешта на викито со посета на страницата $2.

Ова е сосем нов проект, и затоа би ве замолиме да ни пишете ако имате било какви прашања!


-- Екипата на Викија-заедницата',
	'autocreatewiki-reminder-body-HTML' => '<p>Почитуван(а) $1:</p>

<p>Ви честитаме на започнувањето на вашето ново вики, {{SITENAME}}! Можете да се навратите и да додавате уште нешта на викито со посета на
<a href="$2">$2</a>.</p>

<p>Ова е сосем нов проект, и затоа би ве замолиле да ни пишете ако имате вило какви прашања!</p>

<p>-- Екипата на Викија-заедницата</p>',
	'autocreatewiki-subname-answers' => 'Одговори',
);

/** Mazanderani (مازِرونی)
 * @author Firuz
 */
$messages['mzn'] = array(
	'autocreatewiki' => 'اتا نو ویکی درس هکردن',
	'autocreatewiki-page-title-default' => 'اتا نو ویکی درس هکردن',
);

/** Dutch (Nederlands)
 * @author McDutchie
 * @author Siebrand
 */
$messages['nl'] = array(
	'autocreatewiki' => 'Begin een nieuwe wiki',
	'autocreatewiki-desc' => 'Wiki aanmaken in WikiFactory door gebruikersverzoeken',
	'autocreatewiki-page-title-default' => 'Nieuwe wiki aanmaken',
	'autocreatewiki-page-title-answers' => 'Nieuwe Antwoordensite aanmaken',
	'createwiki' => 'Nieuwe wiki aanmaken',
	'autocreatewiki-chooseone' => 'Kies er een',
	'autocreatewiki-required' => '$1 = vereist',
	'autocreatewiki-web-address' => 'Webadres:',
	'autocreatewiki-category-select' => 'Kies er een',
	'autocreatewiki-language-top' => 'Top $1 talen',
	'autocreatewiki-language-all' => 'Alle talen',
	'autocreatewiki-birthdate' => 'Geboortedatum:',
	'autocreatewiki-blurry-word' => 'Wazige woord:',
	'autocreatewiki-remember' => 'Aanmeldgegevens onthouden',
	'autocreatewiki-create-account' => 'Registreren',
	'autocreatewiki-done' => 'volbracht',
	'autocreatewiki-error' => 'error',
	'autocreatewiki-language-top-list' => 'de,en,es,he,fr,it,ja,nl,no,pl,pt,pt-br,zh',
	'autocreatewiki-haveaccount-question' => 'Hebt u al een Wikia-gebruiker?',
	'autocreatewiki-success-title-default' => 'U wiki is aangemaakt!',
	'autocreatewiki-success-title-answers' => 'Uw Antwoordensite is aangemaakt!',
	'autocreatewiki-success-subtitle' => 'U kunt nu gaan werken aan uw wiki door deze pagina te bezoeken:',
	'autocreatewiki-success-has-been-created' => 'is aangemaakt!',
	'autocreatewiki-success-get-started' => 'Beginnen',
	'autocreatewiki-info-domain' => 'Het is het beste om een woord te kiezen dat vaak gebruikt wordt om uw onderwerp te vinden.',
	'autocreatewiki-info-topic' => 'Voeg een korte beschrijving toe, zoals "Star Wars" of "TV programma".',
	'autocreatewiki-info-category-default' => 'Hierdoor kunnen bezoekers uw wiki vinden.',
	'autocreatewiki-info-category-answers' => 'Hierdoor kunnen bezoekers uw Antwoordensite vinden.',
	'autocreatewiki-info-language' => 'Dit wordt de standaardtaal voor bezoekers van uw wiki.',
	'autocreatewiki-info-email-address' => 'Uw e-mailadres wordt nooit bekend gemaakt aan welk persoon dan ook op Wikia.',
	'autocreatewiki-info-realname' => 'Geef uw naam op zodat deze gebruikt kan worden om u erkenning te geven voor uw werk.',
	'autocreatewiki-info-birthdate' => 'Wikia vraagt aan alle gebruikers om hun echte geboortedatum op te geven voor veiligheid maar ook om de integriteit van de site aan de federale regels te laten voldoen.',
	'autocreatewiki-info-blurry-word' => 'Om het automatisch aanmaken van gebruikers tegen te gaan moet u het wazige woord dat u in dit veld ziet invoeren.',
	'autocreatewiki-info-terms-agree' => 'Door een wiki en een gebruiker aan te maken accepteert u de <a href="http://www.wikia.com/wiki/Terms_of_use">gebruikersvoorwaarden van Wikia</a>.',
	'autocreatewiki-info-staff-username' => '<b>Alleen voor staf:</b> de aangegeven gebruiker wordt vermeld als de oprichter.',
	'autocreatewiki-title-template' => '$1 wiki',
	'autocreatewiki-limit-day' => "Wikia heeft het maximum aantal nieuwe wiki's voor vandaag ($1) overschreden.",
	'autocreatewiki-limit-creation' => "U hebt het maximum aantal nieuwe wiki's in 24 uur ($1) overschreden.",
	'autocreatewiki-empty-field' => 'Vul dit veld alstublieft in.',
	'autocreatewiki-bad-name' => 'De naam kan geen speciale tekens bevatten (zoals $ of @) en moet bestaan uit één woord, zonder hoofdletters en zonder spaties.',
	'autocreatewiki-invalid-wikiname' => 'De naam kan geen speciale tekens (zoals $ of @) bevatten en kan niet leeg zijn.',
	'autocreatewiki-violate-policy' => 'Deze wiki bevat een naam dat ons beleid voor namen overschrijdt.',
	'autocreatewiki-name-taken' => 'Een wiki met deze naam bestaat al.
U kunt meehelpen op <a href="http://$1.wikia.com">http://$1.wikia.com</a>',
	'autocreatewiki-name-too-short' => 'Deze naam is te kort.
Kies alstublieft een naam met tenminste drie tekens.',
	'autocreatewiki-name-too-long' => 'Deze naam is te lang.
Kies een naam met hoogstens zestig tekens.',
	'autocreatewiki-similar-wikis' => "Hieronder staan de wiki's die al aangemaakt zijn met voor onderwerp.
We raden u aan aan een van wiki's te gaan werken.",
	'autocreatewiki-invalid-username' => 'Deze gebruikersnaam is ongeldig.',
	'autocreatewiki-busy-username' => 'Deze gebruikersnaam is al in gebruik.',
	'autocreatewiki-blocked-username' => 'U kunt geen gebruiker aanmaken.',
	'autocreatewiki-user-notloggedin' => 'Uw gebruiker is gemaakt maar u bent niet aangemeld!',
	'autocreatewiki-empty-language' => 'Selecteer alstublieft de taal voor de wiki.',
	'autocreatewiki-empty-category' => 'Selecteer alstublieft een van de categorieën.',
	'autocreatewiki-empty-wikiname' => 'De naam van de wiki kan niet leeg zijn.',
	'autocreatewiki-empty-username' => 'Gebruikersnaam kan niet leeg zijn.',
	'autocreatewiki-empty-password' => 'Wachtwoord kan niet leeg zijn.',
	'autocreatewiki-empty-retype-password' => 'Herhaling wachtwoord kan niet leeg zijn.',
	'autocreatewiki-category-label' => 'Categorie:',
	'autocreatewiki-category-other' => 'Overige',
	'autocreatewiki-set-username' => 'Plaats eerst gebruikersnaam.',
	'autocreatewiki-invalid-category' => 'Ongeldige keuze van categorie.
Kies er alstublieft een uit de dropdownlijst.',
	'autocreatewiki-invalid-language' => 'Ongeldige taalkeuze.
Kies er alstublieft een uit de dropdownlijst.',
	'autocreatewiki-invalid-retype-passwd' => 'Herhaal alstublieft hetzelfde wachtwoord.',
	'autocreatewiki-invalid-birthday' => 'Ongeldige geboortedatum',
	'autocreatewiki-limit-birthday' => 'Kan geen registratie creëren.',
	'autocreatewiki-log-title' => 'Uw wiki wordt aangemaakt',
	'autocreatewiki-step0' => 'Proces aan het initialiseren ...',
	'autocreatewiki-stepdefault' => 'Proces is aan het werk. Een moment geduld alstublieft...',
	'autocreatewiki-errordefault' => 'Proces was niet afgemaakt ...',
	'autocreatewiki-step1' => 'Afbeeldingenmap aan het aanmaken…',
	'autocreatewiki-step2' => 'Database aan het creëren ...',
	'autocreatewiki-step3' => 'Standaard informatie in de database aan het plaatsen ...',
	'autocreatewiki-step4' => 'Standaard afbeeldingen en logo aan het kopiëren ...',
	'autocreatewiki-step5' => 'Standaard variabelen in de database aan het plaatsen ...',
	'autocreatewiki-step6' => 'Standaard tabellen in de database aan het plaatsen ...',
	'autocreatewiki-step7' => 'Taal aan het plaatsen...',
	'autocreatewiki-step8' => 'Gebruikersgroepen en categorieën aan het plaatsen ...',
	'autocreatewiki-step9' => 'Variabelen voor de nieuwe wiki aan het instellen...',
	'autocreatewiki-step10' => "Pagina's op centrale wiki aan het instellen...",
	'autocreatewiki-step11' => 'E-mail aan het verzenden naar gebruiker...',
	'autocreatewiki-redirect' => 'Bezig met het doorverwijzen naar de nieuwe Wiki: $1 ...',
	'autocreatewiki-congratulation' => 'Gefeliciteerd!',
	'autocreatewiki-welcometalk-log' => 'Welkomstbericht',
	'autocreatewiki-regex-error-comment' => 'gebruikt in wiki $1 (volledige tekst: $2)',
	'autocreatewiki-step2-error' => 'Database bestaat al!',
	'autocreatewiki-step3-error' => 'Kan standaard informatie niet in de database plaatsen!',
	'autocreatewiki-step6-error' => 'Kan de standaard tabellen niet in de database plaatsen!',
	'autocreatewiki-step7-error' => 'Kan de starter database voor talen niet kopiëren!',
	'autocreatewiki-protect-reason' => 'Onderdeel van de officiële interface',
	'autocreatewiki-welcomesubject' => '$1 is aangemaakt!',
	'autocreatewiki-welcomebody' => 'Hallo $2!

De Wikia die u hebt aangevraagd is nu beschikbaar op de volgende URL: <$1>. We hopen dat u daar snel gaat bewerken!

We hebben informatie en tips op uw overlegpagina toegevoegd (<$5>) om u op weg te helpen.

Als u problemen ondervindt kunt u de gemeenschap om hulp vragen op de wiki (<http://www.wikia.com/wiki/Forum:Help_desk>), of via een e-mail naar community@wikia.com. U kunt ook ons live IRC-chatkanaal bezoeken via <http://irc.wikia.com>.

U kunt ook direct contact met mij opnemen per e-mail of op mijn overlegpagina bij vragen of zorgen.

Succes met uw project!

$3

Wikia Gemeenschapsteam

<http://www.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => "== Welkom! ==
<div style=\"font-size:120%; line-height:1.2em;\">Hallo \$1 -- we zijn erg blij dat '''\$4''' onderdeel is geworden van de Wikia-gemeenschap!

U hebt nu een hele website tot uw beschikking hebt die u met informatie, afbeeldingen en video over uw favoriete onderwerp kunt gaan vullen. Maar nu staart een lege pagina u aan. Spannend, toch? Hier volgen wat tips om u op weg te helpen.

* '''Leid uw onderwerp in''' op de hoofdpagina. Dit is uw gelegenheid om uw lezers aan te geven wat uw onderwerp van belang maakt. Schrijf zoveel u wilt. In uw beschrijving kunt u naar alle belangrijke pagina's op uw site verwijzen.

* '''Maak nieuwe pagina's aan''' -- soms zijn een paar zinnen al voldoende als beginnetje. Laat het geen lege pagina's zijn! Een belangrijke werkwijze in een wiki is toevoegen en later verbeteren en verfijnen. U kunt ook afbeeldingen en video toevoegen om de pagina te vullen en deze interessanter en spannender te maken.

En daarna vooral volhouden! De wiki's waar veel te lezen en te zien is zijn het meest aantrekkelijk, dus blijf vooral informatie toevoegen zodat u meer lezers krijgt en daardoor nieuwe gebruikers die ook bijdragen. Er is veel te doen, maar maak u geen zorgen. Vandaag is uw eerste dag en er is voldoende tijd. Iedere wiki start op dezelfde manier. Beetje voor beetje, de eerste pagina's eerst, om zich in de tijd mogelijk tot een grote, drukke website te ontwikkelen.

Als u vragen hebt, e-mail ons dan via het [[Special:Contact|contactformulier]]. Veel plezier!

-- [[User:\$2|\$3]] <staff /></div>",
	'newwikis' => "Nieuwe wiki's",
	'newwikisstart' => "Wiki's weergeven vanaf:",
	'autocreatewiki-reminder-body' => 'Beste $1.

Van harte gefeliciteerd met het starten van uw nieuwe wiki {{SITENAME}}! Kom vooral vaak terug om meer inhoud aan uw wiki toe te voegen op $2.

Dit is een volledig nieuw project, dus laat het ons weten als u met vragen zit.

-- Wikia gemeenschapsteam',
	'autocreatewiki-reminder-body-HTML' => '<p>Beste $1.</p>

<p>Van harte gefeliciteerd met het starten van uw nieuwe wiki {{SITENAME}}! Kom vooral vaak terug om meer inhoud aan uw wiki toe te voegen op <a href="$2">$2</a>.</p>

<p>Dit is een volledig nieuw project, dus laat het ons weten als u met vragen zit.</p>

<p>-- Wikia gemeenschapsteam</p>',
	'autocreatewiki-subname-answers' => 'Antwoorden',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'autocreatewiki' => 'Opprett en ny Wiki',
	'autocreatewiki-desc' => 'Opprett wiki i WikiFactory etter forespørsel fra bruker',
	'autocreatewiki-page-title-default' => 'Opprett en ny Wiki',
	'autocreatewiki-page-title-answers' => 'Opprett et nytt svar-nettsted',
	'createwiki' => 'Opprett en ny Wiki',
	'autocreatewiki-chooseone' => 'Velg en',
	'autocreatewiki-required' => '$1 = påkrevd',
	'autocreatewiki-web-address' => 'Nettadresse:',
	'autocreatewiki-category-select' => 'Velg en',
	'autocreatewiki-language-top' => 'Topp $1 språk',
	'autocreatewiki-language-all' => 'Alle språk',
	'autocreatewiki-birthdate' => 'Fødselsdato:',
	'autocreatewiki-blurry-word' => 'Forvrengt ord:',
	'autocreatewiki-remember' => 'Husk meg',
	'autocreatewiki-create-account' => 'Opprett en konto',
	'autocreatewiki-done' => 'ferdig',
	'autocreatewiki-error' => 'feil',
	'autocreatewiki-language-top-list' => 'de,en,es,he,fr,it,ja,no,pl,pt,pt-br,zh',
	'autocreatewiki-haveaccount-question' => 'Har du allerede en Wikia-konto?',
	'autocreatewiki-success-title-default' => 'Din wiki har blitt opprettet!',
	'autocreatewiki-success-title-answers' => 'Ditt svar-nettsted har blitt opprettet.',
	'autocreatewiki-success-subtitle' => 'Du kan nå begynne å jobbe med din wiki ved å besøke:',
	'autocreatewiki-success-has-been-created' => 'har blitt opprettet!',
	'autocreatewiki-success-get-started' => 'Sett igang',
	'autocreatewiki-info-domain' => 'Det er best å bruke et ord som mest synlig vil bli brukt som et søkeord for emnet ditt.',
	'autocreatewiki-info-topic' => 'Legg til en kort beskrivelse som «Star Wars» eller «TV-program».',
	'autocreatewiki-info-category-default' => 'Dette vil hjelpe besøkende å finne din wiki.',
	'autocreatewiki-info-category-answers' => 'Dette vil hjelpe besøkende å finne ditt svar-nettsted.',
	'autocreatewiki-info-language' => 'Dette blir standardspråket for besøkende til din wiki.',
	'autocreatewiki-info-email-address' => 'Din e-postadresse vil aldri bli vist til noen på Wikia.',
	'autocreatewiki-info-realname' => 'Om du velger å oppgi dette vil det bli brukt til å kreditere deg for ditt arbeid.',
	'autocreatewiki-info-birthdate' => 'Wikia krever at alle brukere oppgir deres virkelige fødselsdato, både som et sikkerhetsforetak og som et middel for å bevare integriteten til nettstedet, og samtidig etterkomme føderale bestemmelser.',
	'autocreatewiki-info-blurry-word' => 'For å beskytte mot automatisk opprettede kontoer vennligst skriv inn det forvrengte ordet som du ser i dette feltet.',
	'autocreatewiki-info-terms-agree' => 'Ved å opprette en wiki og en brukerkonto godtar du <a href="http://www.wikia.com/wiki/Terms_of_use">Wikias vilkår for bruk</a>',
	'autocreatewiki-info-staff-username' => '<b>Kun stab:</b> Den angitte brukeren vil bli listet opp som grunnlegger.',
	'autocreatewiki-title-template' => '$1 Wiki',
	'autocreatewiki-limit-day' => 'Wikia har overskredet maks antall wikier den kan opprette idag ($1).',
	'autocreatewiki-limit-creation' => 'Du har overskredet maks antall wikier du kan opprette innen 24 timer ($1).',
	'autocreatewiki-empty-field' => 'Fyll ut dette feltet.',
	'autocreatewiki-bad-name' => 'Navnet kan ikke innholde spesialtegn (som $ eller @) og må være kun ett ord skrevet med små bokstaver uten mellomrom.',
	'autocreatewiki-invalid-wikiname' => 'Navnet kan ikke inneholder spesialtegn (som $ eller @) og kan ikke være tomt',
	'autocreatewiki-violate-policy' => 'Dette wikinavnet inneholder et ord som bryter med våre retningslinjer for navngivning',
	'autocreatewiki-name-taken' => 'En wiki med dette navnet finnes allerede. Du er velkommen til å bli med oss på <a href="http://$1.wikia.com">http://$1.wikia.com</a>',
	'autocreatewiki-name-too-short' => 'Dette navnet er for kort, vennligst velg et navn med minst 3 tegn.',
	'autocreatewiki-name-too-long' => 'Dette navnet er for langt, vennligst velg et navn med maks 50 tegn.',
	'autocreatewiki-similar-wikis' => 'Nedenfor er wikiene som allerede er opprettet om temaet. Vi foreslår å redigere en av dem.',
	'autocreatewiki-invalid-username' => 'Brukernavnet er ugyldig.',
	'autocreatewiki-busy-username' => 'Brukernavnet er allerede tatt.',
	'autocreatewiki-blocked-username' => 'Du kan ikke opprette en konto.',
	'autocreatewiki-user-notloggedin' => 'Kontoen er opprettet men du er ikke logget inn!',
	'autocreatewiki-empty-language' => 'Vennligst velg språk på Wikien.',
	'autocreatewiki-empty-category' => 'Vennligst velg en kategori.',
	'autocreatewiki-empty-wikiname' => 'Navnet på Wikien kan ikke være tomt.',
	'autocreatewiki-empty-username' => 'Brukernavn kan ikke være tomt.',
	'autocreatewiki-empty-password' => 'Passord kan ikke være tomt.',
	'autocreatewiki-empty-retype-password' => 'Gjenta passord kan ikke være tomt.',
	'autocreatewiki-category-label' => 'Kategori:',
	'autocreatewiki-category-other' => 'Andre',
	'autocreatewiki-set-username' => 'Angi brukernavn først.',
	'autocreatewiki-invalid-category' => 'Ugyldig kategoriverdi.
Vennligst velg en riktig fra rullegardinlisten.',
	'autocreatewiki-invalid-language' => 'Ugyldig verdi for språk.
Velg riktig fra rullegardinlisten.',
	'autocreatewiki-invalid-retype-passwd' => 'Skriv inn det samme passordet som over',
	'autocreatewiki-invalid-birthday' => 'Ugyldig fødselsdato',
	'autocreatewiki-limit-birthday' => 'Kan ikke opprette registrering.',
	'autocreatewiki-log-title' => 'Wikien din blir opprettet',
	'autocreatewiki-step0' => 'Initialiserer prosess ...',
	'autocreatewiki-stepdefault' => 'Prosessen er i gang, vent ...',
	'autocreatewiki-errordefault' => 'Prosessen ble ikke ferdig ...',
	'autocreatewiki-step1' => 'Oppretter bildemappe ...',
	'autocreatewiki-step2' => 'Oppretter database ...',
	'autocreatewiki-step3' => 'Setter opp standardinformasjon i database ...',
	'autocreatewiki-step4' => 'Kopierer standardbilder og -logo ...',
	'autocreatewiki-step5' => 'Setter opp standardvariabler i database ...',
	'autocreatewiki-step6' => 'Setter opp standardtabeller i database ...',
	'autocreatewiki-step7' => 'Setter opp oppstartsspråk ...',
	'autocreatewiki-step8' => 'Setter opp brukergrupper og -kategorier ...',
	'autocreatewiki-step9' => 'Setter opp variabler for ny wiki ...',
	'autocreatewiki-step10' => 'Setter opp sider på en sentral wiki ...',
	'autocreatewiki-step11' => 'Sender e-post til bruker ...',
	'autocreatewiki-redirect' => 'Omdirigerer til ny wiki: $1 ...',
	'autocreatewiki-congratulation' => 'Gratulerer!',
	'autocreatewiki-welcometalk-log' => 'Velkomstmelding',
	'autocreatewiki-regex-error-comment' => 'brukt i wiki $1 (hele teksten: $2)',
	'autocreatewiki-step2-error' => 'Database finnes!',
	'autocreatewiki-step3-error' => 'Kan ikke sette standardinformasjon i database!',
	'autocreatewiki-step6-error' => 'Kan ikke sette standardtabeller i database!',
	'autocreatewiki-step7-error' => 'Kan ikke kopiere database for oppstartsspråk!',
	'autocreatewiki-protect-reason' => 'Del av det offisielle grensesnittet',
	'autocreatewiki-welcomesubject' => '$1 har blitt opprettet!',
	'autocreatewiki-welcomebody' => 'Hallo, $2,

Wikiaen du spør etter er nå tilgjengelig på <$1> Vi håper å se deg redigere der snart!

Vi har lagt til litt informasjon og tips på brukerdiskusjonssiden din (<$5>) for å hjelpe deg med å komme i gang.

Hvis du har problemer kan du spørre fellesskapet om hjelp på wikien på <http://www.wikia.com/wiki/Forum:Help_desk>, eller via e-post til community@wikia.com. Du kan også få svar direkte på #wikia IRC snakkekanal <http://irc.wikia.com>.

Jeg kan kontaktes direkte på e-post eller på diskusjonssiden min hvis du har spørsmål eller bekymringer.

Lykke til med prosjektet!

$3

Wikia Community Team

<http://www.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => "== Velkommen! == 
<div style=\"font-size:120%; line-height:1.2em;\">Hei \$1 -- vi er glade over å ha '''\$4''' som en del av Wikia Fellesskapet! 

Nå har du en hel nettside å fylle opp med informasjon, bilder og video om yndlingstemaet ditt. Men akkurat nå er det bare tomme sider som stirrer på deg... Skremmende, eller hva? Her er noen måter å komme i gang på.

* '''Introduser temaet ditt''' på forsiden. Dette er din mulighet til å forklare leserne mer om hva temaet handler om. Skriv så mye du vil! Beskrivelsen din kan lenke til alle slags viktige artikler på siden din.

* '''Opprett noen nye sider''' -- bare en setning eller to er flott i begynnelsen. Ikke la de tomme sidene stirre deg i senk! En wiki handler om å legge til og endre ting som det faller seg. Du kan også legge til bilder og video for å fylle siden og gjøre den mer interessant. 

Så er det bare å fortsette! Folk liker å besøke wikier med en masse å lese og se på, så fortsett å legge til ting, og du vil tiltrekke nye lesere og bidragsytere. Det er en masse å gjøre, men slapp av -- i dag er den første dagen, og du har masser av tid. Hver eneste wiki starter på samme måte -- litt om gangen, fra de første få sidene, til en stor og travel side. 

Hvis du har spørsmål, kan du sende oss en e-post gjennom vårt [[Special:Contact|kontaktskjema]]. Ha det gøy!

-- [[User:\$2|\$3]] <staff /></div>",
	'newwikis' => 'Nye wikier',
	'newwikisstart' => 'Vis wikier fra og med:',
	'autocreatewiki-reminder-body' => '
Kjære $1: 

Gratulerer med oppstart av din nye wiki, {{SITENAME}}! Du kan komme tilbake og legge til mer på wikien ved å besøke $2. 

Dette er et helt nytt prosjekt, så vennligst skriv til oss om du har noen spørsmål! 


-- Wikia Community Teamet',
	'autocreatewiki-reminder-body-HTML' => '
<p>Kjære $1:</p> 

<p>Gratulerer med oppstart av din nye wiki, {{SITENAME}}! Du kan komme tilbake og legge til mer på wikien ved å besøke 
<a href="$2">$2</a>.</p> 

<p>Dette er et helt nytt prosjekt, så vennligst skriv til oss om du har spørsmål!</p>

<p>-- Wikia Community Teamet</p>',
	'autocreatewiki-subname-answers' => 'Svar',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'autocreatewiki' => 'Utwórz nową wiki',
	'autocreatewiki-desc' => 'Tworzenie przez użytkownika nowej wiki w WikiFactory',
	'autocreatewiki-page-title-default' => 'Utwórz nową wiki',
	'autocreatewiki-page-title-answers' => 'Utwórz nowy serwis z odpowiedziami na pytania',
	'createwiki' => 'Utwórz nową wiki',
	'autocreatewiki-chooseone' => 'Wybierz',
	'autocreatewiki-required' => '$1 – wymagane',
	'autocreatewiki-web-address' => 'Adres strony internetowej',
	'autocreatewiki-category-select' => 'Wybierz',
	'autocreatewiki-language-top' => '$1 {{PLURAL:$1|najważniejszy język|najważniejsze języki|najważniejszych języków}}',
	'autocreatewiki-language-all' => 'Wszystkie języki',
	'autocreatewiki-birthdate' => 'Data urodzenia',
	'autocreatewiki-blurry-word' => 'Zamazane słowo',
	'autocreatewiki-remember' => 'Pamiętaj mnie',
	'autocreatewiki-create-account' => 'Zarejestruj się',
	'autocreatewiki-done' => 'gotowe',
	'autocreatewiki-error' => 'błąd',
	'autocreatewiki-haveaccount-question' => 'Masz już konto w Wikii?',
	'autocreatewiki-success-title-default' => 'Twoja wiki została utworzona!',
	'autocreatewiki-success-title-answers' => 'Witryna z odpowiedziami na pytania została utworzona!',
	'autocreatewiki-success-subtitle' => 'Możesz teraz rozpocząć pracę nad swoją wiki, odwiedzając stronę',
	'autocreatewiki-success-has-been-created' => 'została utworzona!',
	'autocreatewiki-success-get-started' => 'Wprowadzenie',
	'autocreatewiki-info-domain' => 'Najlepiej jest użyć słowa najbliższego dla tematyki strony.',
	'autocreatewiki-info-topic' => 'Dodaj krótki opis, taki jak „Gwiezdne Wojny” lub „Seriale TV”.',
	'autocreatewiki-info-category-default' => 'Pomoże to odnaleźć odwiedzającym Twoją wiki.',
	'autocreatewiki-info-category-answers' => 'Pomoże to odnaleźć odwiedzającym Twoją witrynę z odpowiedziami na pytania.',
	'autocreatewiki-info-language' => 'Będzie to domyślny język dla odwiedzających Twoją wiki.',
	'autocreatewiki-info-email-address' => 'Twój adres e‐mail nie zostanie nikomu wyświetlony w Wikii.',
	'autocreatewiki-info-realname' => 'Jeśli zdecydujesz się je podać, zostaną użyte, by udokumentować Twoje autorstwo.',
	'autocreatewiki-info-birthdate' => 'Wikia wymaga od wszystkich użytkowników podania przez nich rzeczywistej daty urodzenia zarówno ze względów bezpieczeństwa jak i ze względu na konieczność zapewnienia zgodności z przepisami federalnymi.',
	'autocreatewiki-info-blurry-word' => 'Ze względu na ochronę przed automatycznym tworzeniem kont, przepisz rozmazane słowo, które widać w tym polu.',
	'autocreatewiki-info-terms-agree' => 'Tworząc wiki i konto użytkownika, tym samym użytkownik wyraża zgodę <a href="http://www.wikia.com/wiki/Terms_of_use">na warunki korzystania z Wikii</a>',
	'autocreatewiki-info-staff-username' => '<b>Wyłącznie personel –</b> określony użytkownik zostanie wyświetlony jako założyciel.',
	'autocreatewiki-title-template' => 'Wiki $1',
	'autocreatewiki-limit-day' => 'Utworzono dziś w Wikii maksymalną liczbę wiki ($1).',
	'autocreatewiki-limit-creation' => 'Utworzyłeś w przeciągu ostatnich 24 godzin w Wikii maksymalną liczbę wiki ($1).',
	'autocreatewiki-empty-field' => 'Należy wypełnić to pole.',
	'autocreatewiki-bad-name' => 'Nazwa nie może zawierać znaków specjalnych (np. $ lub @) i musi być jednym słowem zapisanym małymi literami bez odstępów.',
	'autocreatewiki-invalid-wikiname' => 'Nazwa nie może zawierać znaków specjalnych (np. $ lub @) i nie może być pusta',
	'autocreatewiki-violate-policy' => 'Nazwa wiki zawiera słowo, które narusza naszą politykę nazewnictwa',
	'autocreatewiki-name-taken' => 'Wiki o tej nazwie już istnieje. Zapraszamy do przyłączenia się do nas na <a href="http://$1.wikia.com">http://$1.wikia.com</a>',
	'autocreatewiki-name-too-short' => 'Ta nazwa jest zbyt krótka. Należy wybrać nazwę o co najmniej 3 znakach.',
	'autocreatewiki-name-too-long' => 'Ta nazwa jest zbyt długa. Należy wybrać nazwę o maksymalnie 50 znakach.',
	'autocreatewiki-similar-wikis' => 'Poniżej znajdują się wiki dotyczące tego tematu. Proponujemy edycję jednej z nich.',
	'autocreatewiki-invalid-username' => 'Ta nazwa użytkownika jest nieprawidłowa.',
	'autocreatewiki-busy-username' => 'Ta nazwa użytkownika jest już wykorzystana.',
	'autocreatewiki-blocked-username' => 'Nie można utworzyć konta.',
	'autocreatewiki-user-notloggedin' => 'Twoje konto zostało utworzone, ale nie jesteś zalogowany!',
	'autocreatewiki-empty-language' => 'Określ język dla tej wiki.',
	'autocreatewiki-empty-category' => 'Wybierz kategorię.',
	'autocreatewiki-empty-wikiname' => 'Nazwa wiki nie może być pusta.',
	'autocreatewiki-empty-username' => 'Nazwa użytkownika nie może być pusta.',
	'autocreatewiki-empty-password' => 'Hasło nie może być puste.',
	'autocreatewiki-empty-retype-password' => 'Powtórzone hasło nie może być puste.',
	'autocreatewiki-category-label' => 'Kategoria',
	'autocreatewiki-category-other' => 'Inne',
	'autocreatewiki-set-username' => 'Najpierw określ nazwę użytkownika.',
	'autocreatewiki-invalid-category' => 'Nieprawidłowa kategoria. 
Wybierz prawidłową z listy rozwijanej.',
	'autocreatewiki-invalid-language' => 'Nieprawidłowy język. 
Wybierz prawidłowy z listy rozwijanej.',
	'autocreatewiki-invalid-retype-passwd' => 'Przepisz hasło tak aby było identyczne do powyższego',
	'autocreatewiki-invalid-birthday' => 'Nieprawidłowa data urodzenia',
	'autocreatewiki-limit-birthday' => 'Nie można przeprowadzić rejestracji.',
	'autocreatewiki-log-title' => 'Twoja wiki jest właśnie tworzona',
	'autocreatewiki-step0' => 'Proces inicjalizacji...',
	'autocreatewiki-stepdefault' => 'Proces jest wykonywany, proszę czekać...',
	'autocreatewiki-errordefault' => 'Proces nie został ukończony...',
	'autocreatewiki-step1' => 'Tworzenie folderu ilustracji...',
	'autocreatewiki-step2' => 'Tworzenie bazy danych...',
	'autocreatewiki-step3' => 'Ustawianie domyślnych informacji w bazie danych...',
	'autocreatewiki-step4' => 'Kopiowanie domyślnych ilustracji oraz logo...',
	'autocreatewiki-step5' => 'Ustawianie w bazie danych domyślnych wartości zmiennych...',
	'autocreatewiki-step6' => 'Ustawienie w bazie danych domyślnych tabel...',
	'autocreatewiki-step7' => 'Ustawienie początkowych wartości dla języka...',
	'autocreatewiki-step8' => 'Ustawianie grup użytkowników i kategorii...',
	'autocreatewiki-step9' => 'Ustawianie zmiennych dla nowej wiki...',
	'autocreatewiki-step10' => 'Ustawienie stron na centralnej wiki...',
	'autocreatewiki-step11' => 'Wysyłanie e‐maila do użytkownika...',
	'autocreatewiki-redirect' => 'Przekierowanie do nowej wiki – $1...',
	'autocreatewiki-congratulation' => 'Gratulacje!',
	'autocreatewiki-welcometalk-log' => 'Powitanie',
	'autocreatewiki-regex-error-comment' => 'wykorzystane w wiki $1 (pełny tekst – $2)',
	'autocreatewiki-step2-error' => 'Baza danych istnieje!',
	'autocreatewiki-step3-error' => 'Nie można ustawić domyślnych informacji w bazie danych!',
	'autocreatewiki-step6-error' => 'Nie można ustawić domyślnych tabel w bazie danych!',
	'autocreatewiki-step7-error' => 'Nie można skopiować do bazy danych początkowych wartości dla języka!',
	'autocreatewiki-protect-reason' => 'Część oficjalnego interfejsu',
	'autocreatewiki-welcomesubject' => 'Wiki $1 została utworzona!',
	'autocreatewiki-welcomebody' => 'Witaj $2,

Wiki, którą utworzyłeś, jest aktualnie dostępna na stronie <$1>. Mamy nadzieję, że szybko rozpoczniesz jej edycję.

Umieściliśmy na Twojej stronie dyskusji (<$5>) trochę informacji i porad, aby pomóc Ci na początku.

Jeśli napotkasz jakieś problemy, możesz poprosić o pomoc społeczność na stronie <http://www.wikia.com/wiki/Forum:Help_desk>, lub poprzez e‐mail wysłany na adres community@wikia.com. Możesz również odwiedzić na żywo kanał IRC #wikia na <http://irc.wikia.com>.

Możesz się ze mną skontaktować bezpośrednio przez e-mail lub na mojej stronie dyskusji, jeśli masz jakiekolwiek pytania lub wątpliwości. 

Życzymy powodzenia przy tworzeniu nowego projektu!

$3

Zespół Obsługi Społeczności Wikii

<http://www.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => "== Witaj! == 
<div style=\"font-size:120%; line-height:1.2em;\"> Cześć \$1. Cieszymy się, że '''\$4''' jest częścią społeczności Wikia!

Masz teraz własną witryną gotową do wypełnienia informacjami, zdjęciami oraz filmami na temat Twojej pasji. Jednak obecnie są tu tylko puste strony, które czekają na Ciebie... Przeraża Cię to? Oto kilka sposobów, aby rozpocząć.

* '''Wprowadzenie w temat''' na stronie głównej. To jest Twoja szansa, aby wyjaśnić czytelnikom, o czym jest ta wiki. Napisz tyle ile uznasz za stosowne! Twój opis może zawierać linki do wszystkich ważnych stron w witrynie. 

* '''Utwórz kilka nowych stron''' – wystarczy zdanie lub dwa, na dobry początek. Niech puste strony nie straszą czytelników! Wiki pozwala na dodawanie i wprowadzanie zmian bez ograniczeń. Możesz również dodawać zdjęcia i filmy, aby uzupełnić stronę i uczynić ją bardziej interesującą.

Po prostu nie poddawaj się! Ludzie odwiedzający wiki, gdy znajdą dużo ciekawej treści i atrakcyjnych ilustracji pozostaną jako czytelnicy i redaktorzy. Jest wiele do zrobienia, ale nie martw się – dziś to Twój pierwszy dzień – masz dużo czasu. Każda wiki rozpoczyna w ten sam sposób – potrzebuje czasu, zaczyna od kilku stron, a następnie rośnie aż staje się ogromną popularną witryną. 

Jeśli masz pytania, możesz zawsze napisać do nas e‐mail za pośrednictwem [[Special:Contact|formularza kontaktowego]]. Miłej zabawy! 

-- [[User:\$2|\$3]] <staff /></div>",
	'newwikis' => 'Nowe wiki',
	'newwikisstart' => 'Wyświetl wiki rozpoczynając od',
	'autocreatewiki-reminder-body' => 'Szanowny $1!

Gratulujemy utworzenia nowego projektu wiki „{{SITENAME}}”! Możesz teraz wejść na swoją wiki odwiedzając $2 i dodać informacje.

Jest to zupełnie nowy projekt, więc napisz do nas, jeżeli masz jakiekolwiek pytania!

-- Wikia Community Team',
	'autocreatewiki-reminder-body-HTML' => '<p>Szanowny $1,</p>

<p>Gratulujemy Ci utworzenia nowej wiki „{{SITENAME}}”! Możesz teraz wejść na swoją wiki odwiedzając <a href="$2">$2</a> i dodać nowe informacje..</p>

<p>Jest to zupełnie nowy projekt, więc napisz do nas jeśli masz jakieś pytania!</p>

<p>–– Zespół Społeczności Wikii</p>',
	'autocreatewiki-subname-answers' => 'Odpowiedzi',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'autocreatewiki' => 'Crea na neuva Wiki',
	'autocreatewiki-desc' => 'Crea wiki an WikiFactory për arcesta utent',
	'autocreatewiki-page-title-default' => 'Crea na neuva Wiki',
	'autocreatewiki-page-title-answers' => "Crea un sit neuv d'Arspòste",
	'createwiki' => 'Crea na neuva Wiki',
	'autocreatewiki-chooseone' => 'Sern-ne un-a',
	'autocreatewiki-required' => '$1 = ciamà',
	'autocreatewiki-web-address' => "Adrëssa dl'Aragnà:",
	'autocreatewiki-category-select' => 'Sern-ne un-a',
	'autocreatewiki-language-top' => 'Prime $1 lenghe',
	'autocreatewiki-language-all' => 'Tute lenghe',
	'autocreatewiki-birthdate' => 'Data ëd nàssita:',
	'autocreatewiki-blurry-word' => 'Paròla confondùa:',
	'autocreatewiki-remember' => 'Arcòrdme',
	'autocreatewiki-create-account' => 'Crea un Cont',
	'autocreatewiki-done' => 'fàit',
	'autocreatewiki-error' => 'eror',
	'autocreatewiki-language-top-list' => 'de,en,es,he,fr,it,ja,no,pl,pt,pt-br,zh',
	'autocreatewiki-haveaccount-question' => 'Ha-lo già un cont Wikia?',
	'autocreatewiki-success-title-default' => "Toa wiki a l'é stàita creà!",
	'autocreatewiki-success-title-answers' => "Tò sit d'arspòste a l'é stàit creà!",
	'autocreatewiki-success-subtitle' => 'It peule adess ancaminé a travajé dzora a toa wiki an visitand:',
	'autocreatewiki-success-has-been-created' => "a l'é stàita creà!",
	'autocreatewiki-success-get-started' => 'Ancamin-a',
	'autocreatewiki-info-domain' => "A l'é mej dovré na paròla ch'a peussa esse na ciav d'arserca për tò argoment.",
	'autocreatewiki-info-topic' => 'Gionté na descrission curta com "Guère Stelar" o "Spetàcol dla television".',
	'autocreatewiki-info-category-default' => 'Sòn a giuterà ij visitador a trové soa wiki.',
	'autocreatewiki-info-category-answers' => "Sòn a giutërà ij visitador a trové sò sit d'arspòste.",
	'autocreatewiki-info-language' => 'Costa a sarà la lenga dë stàndard për ij visitador ëd soa wiki.',
	'autocreatewiki-info-email-address' => "Soa adrëssa ëd pòsta eletrònica a l'é mai mostrà a gnun su Wikia.",
	'autocreatewiki-info-realname' => "S'a sern ëd delo, a sarà dovrà për atribuije sò travaj.",
	'autocreatewiki-info-birthdate' => "Wikia a ciama a tùit j'utent ëd dé soa vera data ëd nàssita sia për precaussion ëd sigurëssa sia com mojen ëd preeservé l'antegrità dël sit ant ël rispet dij regolament federaj.",
	'autocreatewiki-info-blurry-word' => "Për giuté a protege contra la creassion ëd cont automàtica, për piasì ch'a anserissa la paròla tërmolanta ch'a vëd an sto camp-sì.",
	'autocreatewiki-info-terms-agree' => "An creand na wiki e un cont utent, a l'é d'acòrdi con le <a href=\"http://www.wikia.com/wiki/Terms_of_use\">Condission d'usagi ëd Wikia</a>",
	'autocreatewiki-info-staff-username' => "<b>Mach Echip:</b> L'utent specificà a sarà listà com fondator.",
	'autocreatewiki-title-template' => '$1 Wiki',
	'autocreatewiki-limit-day' => "Wikia a l'ha passà ël màssim nùmer ëd creassion ëd wiki ancheuj ($1).",
	'autocreatewiki-limit-creation' => "It l'has passà ël màssim nùmer ëd creassion ëd wiki an 24 ore ($1).",
	'autocreatewiki-empty-field' => 'Për piasì completa sto camp-sì.',
	'autocreatewiki-bad-name' => 'Ël nòm a peul pa conten-e caràter speciaj (com $ o @) e a deuv esse na sola paròla minùscola sensa spassi.',
	'autocreatewiki-invalid-wikiname' => 'Ël nòm a peul pa conten-e caràter speciaj (com $ e @) e a peul pa esse veuid',
	'autocreatewiki-violate-policy' => "Sto nòm ëd wiki-sì a conten na paròla ch'a rispeta pa nòstre régole pr'ij nòm",
	'autocreatewiki-name-taken' => 'Na wiki con sto nòm-sì a esist già. A l\'é bin ëvnù a gionz-se a nojàutri su <a href="http://$1.wikia.com">http://$1.wikia.com</a>',
	'autocreatewiki-name-too-short' => "Sto nòm a l'é tròp curt, për piasì sern un nòm con almanch 3 caràter.",
	'autocreatewiki-name-too-long' => "Sto nòm a l'é tròp longh, për piasì sern un nòm con al pi 50 caràter.",
	'autocreatewiki-similar-wikis' => "Sì-sota a-i son le wiki già creà su sto argoment-sì. Nòst sugeriment a l'é ëd travajé su un-a ëd cole.",
	'autocreatewiki-invalid-username' => "Sto nòm utent a l'é pa bon.",
	'autocreatewiki-busy-username' => "Sto nòm utent a l'é già pijà.",
	'autocreatewiki-blocked-username' => 'It peule pa creé ëd cont.',
	'autocreatewiki-user-notloggedin' => "Sò cont a l'é stàit creà ma a l'é pa intrà ant ël sistema!",
	'autocreatewiki-empty-language' => 'Për piasì, selessioné la lenga dla Wiki.',
	'autocreatewiki-empty-category' => 'Për piasì, selession-a na categorìa.',
	'autocreatewiki-empty-wikiname' => 'Ël nòm ëd la Wiki a peul pa esse veuid.',
	'autocreatewiki-empty-username' => 'Ël nòm utent a peul pa esse veuid.',
	'autocreatewiki-empty-password' => 'La ciav a peul pa esse veuida.',
	'autocreatewiki-empty-retype-password' => 'La ciav torna scrivùa a peul pa esse veuida.',
	'autocreatewiki-category-label' => 'Categorìa:',
	'autocreatewiki-category-other' => 'Àutr',
	'autocreatewiki-set-username' => 'Ampòsta nòm utent prima.',
	'autocreatewiki-invalid-category' => "Valor ëd categorìa pa bon. Për piasì, ch'a selession-a col giust da la lista a ridò.",
	'autocreatewiki-invalid-language' => "Valor ëd lenga pa bon. Për piasì, ch'a selession-a col bon da la lista a ridò.",
	'autocreatewiki-invalid-retype-passwd' => "Për piasì, ch'a scriva torna la midema ciav ëd cola dëdzora",
	'autocreatewiki-invalid-birthday' => 'Data ëd nàssita pa bon-a',
	'autocreatewiki-limit-birthday' => "Impossìbil creé l'argistrassion.",
	'autocreatewiki-log-title' => "Toa wiki a l'é an creassion",
	'autocreatewiki-step0' => 'Process an camin ...',
	'autocreatewiki-stepdefault' => "Ël process a gira, për piasì ch'a speta ...",
	'autocreatewiki-errordefault' => "Ël process a l'é pa finì ...",
	'autocreatewiki-step1' => 'Creé cartela dle figure ...',
	'autocreatewiki-step2' => 'Creassion dla base ëd dàit ...',
	'autocreatewiki-step3' => "Amposté dj'anformassion dë stàndard ant la base ëd dàit ...",
	'autocreatewiki-step4' => 'Copia dle figure stàndard e dla marca ...',
	'autocreatewiki-step5' => 'Ampostassion dle variàbij dë stàndard ant la base ëd dàit ...',
	'autocreatewiki-step6' => 'Ampostassion dle tàule dë stàndard ant la base ëd dàit ...',
	'autocreatewiki-step7' => 'Amposté lenga inissial ...',
	'autocreatewiki-step8' => "Ampostassion dle partìe dj'utent e dle categorìe ...",
	'autocreatewiki-step9' => 'Ampostassion dle variàbij për la neuva Wiki ...',
	'autocreatewiki-step10' => 'Ampostassion dle pàgine an sla Wiki sentral ...',
	'autocreatewiki-step11' => "Spedission dël mëssagi a l'utent ...",
	'autocreatewiki-redirect' => 'Ridiression a la neuva Wiki: $1 ...',
	'autocreatewiki-congratulation' => 'Congratulassion!',
	'autocreatewiki-welcometalk-log' => 'Mëssagi ëd Bin ëvnù',
	'autocreatewiki-regex-error-comment' => 'dovrà ant la Wiki $1 (test antregh: $2)',
	'autocreatewiki-step2-error' => 'La base ëd dàit a esist!',
	'autocreatewiki-step3-error' => "Impossìbil amposté j'anformassion dë stàndard ant la base ëd dàit!",
	'autocreatewiki-step6-error' => 'Impossìbil amposté le tàule dë stàndard ant la base ëd dàit!',
	'autocreatewiki-step7-error' => 'Impossìbil copié la base ëd dàit inissial për la lenga!',
	'autocreatewiki-protect-reason' => "Part ëd l'antërfacia ufissial",
	'autocreatewiki-welcomesubject' => "$1 a l'é stàit creà!",
	'autocreatewiki-welcomebody' => "Cerea, $2,

la Wikia ch'a l'ha ciamà a l'é adess disponìbil a <$1> Noi i speroma ëd vëdde là tòst soe modìfiche!

Noi i l'oma giontà chèich Anformassion e sugeriment dzora a soa Ciaciarade (<$5>) për giutelo a ancaminé.

S'a l'ha qualsëssìa problema, a peule ciamé agiut a la comunità dzora la wiki a <http://www.wikia.com/wiki/Forum:Help_desk>, o për pòsta eletrònica a community@wikia.com. A peul ëdcò visité nòsta canal #wikia IRC ëd ciaciarade dal viv <http://irc.wikia.com>.

Mi i peusso esse contatà diretament për pòsta eletrònica o dzora a mia pàgina ëd discussion, s'a l'ha qualsëssìa chestion o dùbit.

Tant boneur con ël proget!

$3

Echip ëd la Comunità Wikia

<http://www.wikia.com/wiki/User:$4>",
	'autocreatewiki-welcometalk' => "== Bin ëvnù! ==
<div style=\"font-size:120%; line-height:1.2em;\">Cerea \$1 -- noi i soma content d'avèj '''\$4''' com part ëd la comunità Wikia!

Adess a l'ha 'n sit antregh da ampinì con anformassion, figure e filà dzora ai sò argoment favorì. Ma për ël moment, a-i é mach ëd pàgine bianche dëdnans a chiel ... Brut, pa vera? Ambelessì a-i son chèich manere d'ancaminé.

* '''Ch'a antroduva ij sò argoment''' ant la prima pàgina. Costa a l'é soa oportunità dë spieghé ai sò letor lòn che sò argoment a l'é. Ch'a scriva vàire ch'a veul! Soa descrission a peul avèj d'anliure a tute le pàgine amportante dzora a sò sit.

* '''Ch'a ancamin-a dle pàgine neuve''' -- mach na fras o doe a l'é giust për ancaminé. Ch'as fasa pa sbaruvé da le pàgine bianche! Na wiki a l'é mach gionté e cangé dle còse man a man. A peul ëdcò gionté ëd figure e filmà, për ampinì le pàgine e feje pi anteressante.

E peui ch'a la cudissa! A le përson-e a-i pias visité le wiki quand ch'a-i é motobin ëd ròba da lese e vardé, parèj ch'a continua a gionté 'd ròba, e as tirërà letor e contribudor. A-i é motobin da fé, ma ch'as sagrin-a pa -- ancheuj a l'é sò prim di, e a-i é motobin ëd temp. Minca wiki a part a la midema manera -- un tòch për vòta, ancaminand con le prime pòche pàgine, fin a chërse ant un sit gròss, pien.

S'a l'ha ëd chestion, a peul mandeje për pòsta eletrònica a nòstr [[Special:Contact|formolari ëd contat]]. Tant boneur!

-- [[User:\$2|\$3]] <staff /></div>",
	'newwikis' => 'neuve wiki',
	'newwikisstart' => 'Visualisa Wiki partend da:',
	'autocreatewiki-reminder-body' => "Car $1:

Congratulassion për la partensa ëd soa neuva wiki, {{SITENAME}}! A peul torné andré e gionté ròbe a soa wiki an visitand $2.

Cost-sì a l'é un proget neuv, antlora për piasì ch'a na scriva s'a l'ha qualsëssìa chestion!

-- L'Echip dla Comunità Wikia",
	'autocreatewiki-reminder-body-HTML' => '<p>Car $1:</p>

<p>Congratulassion për la partensa ëd soa neuva wiki, {{SITENAME}}! A peul torné andré e gionté ròbe a soa wiki an visitand 
<a href="$2">$2</a>.</p>

<p>Cost-sì a l\'é un proget neuv, antlora për piasì ch\'a na scriva s\'a l\'ha qualsëssìa chestion!</p>

<p>-- L\'Echip dla Comunità Wikia</p>',
	'autocreatewiki-subname-answers' => 'Rispòste',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'autocreatewiki' => 'یو نوی ويکي جوړول',
	'autocreatewiki-page-title-default' => 'یو نوی ويکي جوړول',
	'autocreatewiki-page-title-answers' => 'د ځوابونو يو نوی وېبځی جوړول',
	'createwiki' => 'یو نوی ويکي جوړول',
	'autocreatewiki-chooseone' => 'يو وټاکۍ',
	'autocreatewiki-web-address' => 'د جال پته:',
	'autocreatewiki-category-select' => 'يو وټاکۍ',
	'autocreatewiki-language-top' => 'د سر $1 ژبې',
	'autocreatewiki-language-all' => 'ټولې ژبې',
	'autocreatewiki-birthdate' => 'د زېږون نېټه:',
	'autocreatewiki-blurry-word' => 'تته ويکه:',
	'autocreatewiki-remember' => 'ما په ياد لره',
	'autocreatewiki-create-account' => 'يو کارن-حساب جوړول',
	'autocreatewiki-done' => 'ترسره شو',
	'autocreatewiki-error' => 'تېروتنه',
	'autocreatewiki-haveaccount-question' => 'آيا تاسې له پخوا نه په ويکييا کې يو کارن-حساب لرۍ؟',
	'autocreatewiki-success-title-default' => 'ستاسې ويکي جوړ شو!',
	'autocreatewiki-success-has-been-created' => 'جوړ شو!',
	'autocreatewiki-success-get-started' => 'پېلول',
	'autocreatewiki-invalid-username' => 'دا کارن نوم سم نه دی.',
	'autocreatewiki-busy-username' => 'دا کارن نوم بل چا ځانته ټاکلی.',
	'autocreatewiki-blocked-username' => 'تاسې کارن حساب نه شی جوړولای.',
	'autocreatewiki-empty-category' => 'لطفاً د وېشنيزو نه يوه وټاکۍ.',
	'autocreatewiki-category-label' => 'وېشنيزه:',
	'autocreatewiki-category-other' => 'بل',
	'autocreatewiki-set-username' => 'لومړی مو کارن نوم وټاکۍ.',
	'autocreatewiki-invalid-birthday' => 'ناسمه زېږون نېټه',
	'autocreatewiki-congratulation' => 'مبارک مو شه!',
	'autocreatewiki-welcometalk-log' => 'د ښه راغلاست پيغام',
	'autocreatewiki-welcomesubject' => '$1 جوړ شو!',
	'newwikis' => 'نوې ويکي ګانې',
	'autocreatewiki-subname-answers' => 'ځوابونه',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'autocreatewiki' => 'Criar uma wiki nova',
	'autocreatewiki-desc' => 'Criar uma wiki na FábricaDeWikis a pedido dos utilizadores',
	'autocreatewiki-page-title-default' => 'Criar uma wiki nova',
	'autocreatewiki-page-title-answers' => 'Criar um site novo de Respostas',
	'createwiki' => 'Criar uma wiki nova',
	'autocreatewiki-chooseone' => 'Escolha uma',
	'autocreatewiki-required' => '$1 = obrigatório',
	'autocreatewiki-web-address' => 'Endereço na internet:',
	'autocreatewiki-category-select' => 'Seleccione uma',
	'autocreatewiki-language-top' => 'As $1 línguas de topo',
	'autocreatewiki-language-all' => 'Todas as línguas',
	'autocreatewiki-birthdate' => 'Data de nascimento:',
	'autocreatewiki-blurry-word' => 'Palavra distorcida:',
	'autocreatewiki-remember' => 'Recordar-me entre sessões',
	'autocreatewiki-create-account' => 'Criar uma conta',
	'autocreatewiki-done' => 'finalizado',
	'autocreatewiki-error' => 'erro',
	'autocreatewiki-haveaccount-question' => 'Já tem uma conta Wikia?',
	'autocreatewiki-success-title-default' => 'A sua wiki foi criada!',
	'autocreatewiki-success-title-answers' => 'O seu site de Respostas foi criado!',
	'autocreatewiki-success-subtitle' => 'Pode começar a trabalhar na sua wiki no endereço:',
	'autocreatewiki-success-has-been-created' => 'foi criada!',
	'autocreatewiki-success-get-started' => 'Começar',
	'autocreatewiki-info-domain' => 'É melhor usar como tópico uma palavra que seja um alvo provável de pesquisas.',
	'autocreatewiki-info-topic' => 'Adicione uma descrição breve, como "Guerra das Estrelas" ou "Programas de televisão".',
	'autocreatewiki-info-category-default' => 'Isto ajuda visitantes a encontrar a sua wiki.',
	'autocreatewiki-info-category-answers' => 'Isto ajuda visitantes a encontrar o seu site de Respostas.',
	'autocreatewiki-info-language' => 'Esta será a língua por omissão para os visitantes da sua wiki.',
	'autocreatewiki-info-email-address' => 'O seu endereço de correio electrónico nunca é mostrado a terceiros na Wikia.',
	'autocreatewiki-info-realname' => 'Se optar por fornecê-lo, ele será usado para dar-lhe o crédito do seu trabalho.',
	'autocreatewiki-info-birthdate' => 'A Wikia requer que todos os utilizadores forneçam a sua data de nascimento verdadeira, tanto por medida de segurança como por ser uma forma de preservar a integridade do site e respeitar regulamentações federais dos Estados Unidos.',
	'autocreatewiki-info-blurry-word' => 'Para ajudar a prevenir a criação de contas automatizada, escreva a palavra distorcida que vê neste campo.',
	'autocreatewiki-info-terms-agree' => 'Ao criar uma wiki e um utilizador, concorda com as <a href="http://www.wikia.com/wiki/Terms_of_use">Condições de Uso da Wikia</a>',
	'autocreatewiki-info-staff-username' => '<b>Só para a equipa:</b> O utilizador especificado será listado como o fundador.',
	'autocreatewiki-title-template' => 'Wiki $1',
	'autocreatewiki-limit-day' => 'A Wikia excedeu o número máximo de criações de wikis hoje ($1).',
	'autocreatewiki-limit-creation' => 'Excedeu o número máximo de criações de wikis em 24 horas ($1).',
	'autocreatewiki-empty-field' => 'Preencha este campo, por favor.',
	'autocreatewiki-bad-name' => 'O nome não pode conter caracteres especiais (como $ ou @) e tem de ser uma só palavra, em minúsculas e sem espaços.',
	'autocreatewiki-invalid-wikiname' => 'O nome não pode conter caracteres especiais (como $ ou @) e não pode ficar vazio',
	'autocreatewiki-violate-policy' => 'O nome da wiki contém uma palavra que viola as nossas normas de nomenclatura',
	'autocreatewiki-name-taken' => 'Já existe uma wiki com este nome. Se quiser, pode juntar-se a nós em <a href="http://$1.wikia.com">http://$1.wikia.com</a>',
	'autocreatewiki-name-too-short' => 'Este nome é demasiado curto. Escolha um nome com um mínimo de 3 caracteres, por favor.',
	'autocreatewiki-name-too-long' => 'Este nome é demasiado longo. Escolha um nome com um máximo de 50 caracteres, por favor.',
	'autocreatewiki-similar-wikis' => 'Encontra abaixo as wikis já criadas sobre este tópico. Sugerimos que edite uma delas.',
	'autocreatewiki-invalid-username' => 'Este nome de utilizador é inválido.',
	'autocreatewiki-busy-username' => 'Este nome de utilizador já existe.',
	'autocreatewiki-blocked-username' => 'Não pode criar a conta.',
	'autocreatewiki-user-notloggedin' => 'A sua conta foi criada mas não foi iniciada uma sessão!',
	'autocreatewiki-empty-language' => 'Seleccione a língua da wiki, por favor.',
	'autocreatewiki-empty-category' => 'Seleccione uma das categorias, por favor.',
	'autocreatewiki-empty-wikiname' => 'O nome da wiki não pode ficar vazio.',
	'autocreatewiki-empty-username' => 'O nome do utilizador não pode ficar vazio.',
	'autocreatewiki-empty-password' => 'A palavra-chave não pode ficar vazia.',
	'autocreatewiki-empty-retype-password' => 'A repetição da palavra-chave não pode ficar vazia.',
	'autocreatewiki-category-label' => 'Categoria:',
	'autocreatewiki-category-other' => 'Outro',
	'autocreatewiki-set-username' => 'Primeiro defina o nome de utilizador.',
	'autocreatewiki-invalid-category' => 'Categoria inválida.
Seleccione uma apropriada da lista.',
	'autocreatewiki-invalid-language' => 'Língua inválida.
Seleccione uma apropriada da lista descendente.',
	'autocreatewiki-invalid-retype-passwd' => 'Repita a mesma palavra-chave, por favor',
	'autocreatewiki-invalid-birthday' => 'Data de nascimento inválida',
	'autocreatewiki-limit-birthday' => 'Não foi possível criar o registo.',
	'autocreatewiki-log-title' => 'A sua wiki está a ser criada',
	'autocreatewiki-step0' => 'A iniciar o processo ...',
	'autocreatewiki-stepdefault' => 'O processo está em execução; aguarde, por favor ...',
	'autocreatewiki-errordefault' => 'O processo não tinha terminado ...',
	'autocreatewiki-step1' => 'A criar o directório de imagens ...',
	'autocreatewiki-step2' => 'A criar a base de dados ...',
	'autocreatewiki-step3' => 'A definir os dados por omissão na base de dados ...',
	'autocreatewiki-step4' => 'A copiar as imagens e logótipo por omissão ...',
	'autocreatewiki-step5' => 'A definir as variáveis por omissão na base de dados ...',
	'autocreatewiki-step6' => 'A definir as tabelas por omissão na base de dados ...',
	'autocreatewiki-step7' => 'A definir base de dados inicial da língua ...',
	'autocreatewiki-step8' => 'A definir grupos de utilizadores e categorias ...',
	'autocreatewiki-step9' => 'A definir variáveis da nova wiki ...',
	'autocreatewiki-step10' => 'A definir páginas na wiki central ...',
	'autocreatewiki-step11' => 'A enviar correio electrónico para o utilizador ...',
	'autocreatewiki-redirect' => 'A reencaminhar para a nova wiki: $1 ...',
	'autocreatewiki-congratulation' => 'Parabéns!',
	'autocreatewiki-welcometalk-log' => 'Mensagem de Boas-vindas',
	'autocreatewiki-regex-error-comment' => 'usada na wiki $1 (texto completo: $2)',
	'autocreatewiki-step2-error' => 'A base de dados existe!',
	'autocreatewiki-step3-error' => 'Não foi possível definir os dados por omissão na base de dados!',
	'autocreatewiki-step6-error' => 'Não foi possível definir as tabelas por omissão na base de dados!',
	'autocreatewiki-step7-error' => 'Não foi possível copiar a base de dados inicial para a língua!',
	'autocreatewiki-protect-reason' => 'Parte da interface oficial',
	'autocreatewiki-welcomesubject' => '$1 foi criada!',
	'autocreatewiki-welcomebody' => 'Olá $2,

A Wikia que solicitou está agora disponível em <$1> Esperamos vê-lo a editá-la em breve!

Adicionámos alguma Informação e Dicas na sua página de dicussão do utilizador (<$5>) para ajudá-lo a começar.

Se tiver algum problema, pode pedir ajuda à comunidade de utilizadores da wiki em <http://www.wikia.com/wiki/Forum:Help_desk>, ou por correio electrónico para community@wikia.com. Também pode visitar o nosso canal  IRC #wikia de conversação ao vivo <http://irc.wikia.com>.

Se tiver quaisquer questões, pode contactar-me directamente por correio electrónico ou na minha página de discussão.

Boa sorte para o seu projecto!

$3

A Equipa da Comunidade Wikia

<http://www.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => "== Bem-vindo(a)! ==
<div style=\"font-size:120%; line-height:1.2em;\">Olá \$1 -- é óptimo contar com '''\$4''' na comunidade Wikia!

Agora tem um site completo na internet para preencher de informação, imagens e vídeos sobre o seu assunto preferido. Mas, para já, ele só contém páginas vazias... Assustador, não é? Aqui vão algumas sugestões para começar.

* '''Apresente o seu tópico''' na página inicial. Esta é a oportunidade de explicar aos visitantes tudo sobre o tema do seu tópico. Escreva tudo o que quiser! A sua descrição pode conter links para todas as páginas importantes do site.

* '''Crie algumas páginas novas''' -- só uma frase ou duas já serão um bom começo. Não se deixe bloquear pela página vazia! Uma wiki vive da adição e alteração de coisas ao longo do tempo. Também pode adicionar imagens e vídeos, para preencher a página e torná-la mais interessante.

E depois é só continuar! As pessoas gostam de visitar wikis com muito conteúdo para ler e ver, por isso continue a adicionar coisas e vai atrair leitores e editores. Há muito a fazer, mas não se preocupe -- hoje é só o seu primeiro dia e ainda tem muito tempo. Todas as wikis começam da mesma forma -- um pouco de cada vez, começando pelas primeiras páginas, até se tornarem num site enorme e muito visitado.

Se tiver alguma questão, pode enviar-nos correio electrónico usando o [[Special:Contact|formulário de contacto]]. Divirta-se!

-- [[User:\$2|\$3]] <staff /></div>",
	'newwikis' => 'Wikis novas',
	'newwikisstart' => 'Mostrar wikis, começando por:',
	'autocreatewiki-reminder-body' => '
Caro(a) $1:

Parabéns por ter iniciado a nova wiki, {{SITENAME}}! Pode regressar e adicionar mais conteúdos à sua wiki, visitando $2.

Este é um projecto acabado de estrear, por isso contacte-nos se tiver qualquer questão!


-- A Equipa da Comunidade Wikia',
	'autocreatewiki-reminder-body-HTML' => '
<p>Caro(a) $1:</p>

<p>Parabéns por ter iniciado a nova wiki, {{SITENAME}}! Pode regressar e adicionar mais conteúdos à sua wiki, visitando
<a href="$2">$2</a>.</p>

<p>Este é um projecto acabado de estrear, por isso contacte-nos se tiver qualquer questão!</p>

<p>-- A Equipa da Comunidade Wikia</p>',
	'autocreatewiki-subname-answers' => 'Respostas',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 * @author Jesielt
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'autocreatewiki' => 'Crie uma nova Wiki',
	'autocreatewiki-desc' => 'Crie uma wiki no WikiFactory a partir de pedidos de usuários',
	'autocreatewiki-page-title-default' => 'Crie uma nova Wiki',
	'autocreatewiki-page-title-answers' => 'Criar um site novo de Respostas',
	'createwiki' => 'Crie uma nova Wiki',
	'autocreatewiki-chooseone' => 'Escolha uma',
	'autocreatewiki-required' => '$1 = campos obrigatórios',
	'autocreatewiki-web-address' => 'Endereço:',
	'autocreatewiki-category-select' => 'Escolha uma',
	'autocreatewiki-language-top' => 'Os $1 idiomas mais usados',
	'autocreatewiki-language-all' => 'Todos os idiomas',
	'autocreatewiki-birthdate' => 'Data de nascimento:',
	'autocreatewiki-blurry-word' => 'Palavra borrada:',
	'autocreatewiki-remember' => 'Me lembre',
	'autocreatewiki-create-account' => 'Crie uma conta',
	'autocreatewiki-done' => 'feito',
	'autocreatewiki-error' => 'erro',
	'autocreatewiki-haveaccount-question' => 'Você já tem uma conta Wikia?',
	'autocreatewiki-success-title-default' => 'Sua wiki foi criada!',
	'autocreatewiki-success-title-answers' => 'O seu site de Respostas foi criado!',
	'autocreatewiki-success-subtitle' => 'Você pode agora começar a trabalhar na sua wiki visitando:',
	'autocreatewiki-success-has-been-created' => 'foi criado!',
	'autocreatewiki-success-get-started' => 'Comece',
	'autocreatewiki-info-domain' => 'É melhor usar uma palavra com a qual as pessoas irão encontrar seu tópico através de buscas.',
	'autocreatewiki-info-topic' => 'Coloque uma descrição curta como "Star Wars" ou "Programas de TV".',
	'autocreatewiki-info-category-default' => 'Isto ajudará os visitantes a encontrar a sua wiki.',
	'autocreatewiki-info-category-answers' => 'Isto ajudará os visitantes a encontrar o seu site de Respostas.',
	'autocreatewiki-info-language' => 'Esse irá ser o idioma padrão para os visitantes da sua wiki.',
	'autocreatewiki-info-email-address' => 'Seu e-mail nunca é mostrado para ninguém no Wikia.',
	'autocreatewiki-info-realname' => 'Se você optar por preencher este valor, ele vai ser usado para lhe dar uma atribuição pelo seu trabalho.',
	'autocreatewiki-info-birthdate' => 'O Wikia exige que todos os usuários providam suas verdadeiras datas de nascimento como uma medida de segurança e para preservar a integridade do site, mantendo a conformidade com os regulamentos federais.',
	'autocreatewiki-info-blurry-word' => 'Para ajudar a proteger o site contra a criação automática de contas, por favor digite a palavra borrada que você vê dentro deste campo.',
	'autocreatewiki-info-terms-agree' => 'Ao criar uma wiki e uma conta de usuário, você está concordando com os <a href="http://www.wikia.com/wiki/Terms_of_use">Termos de Uso do Wikia</a>',
	'autocreatewiki-info-staff-username' => '<b>Só o staff:</b> O usuário especificado será listado com o fundador.',
	'autocreatewiki-title-template' => 'Wiki $1',
	'autocreatewiki-limit-day' => 'O Wikia excedeu o número máximo de criação de wiki hoje ($1).',
	'autocreatewiki-limit-creation' => 'Você excedeu o máximo número de criação de wikis em 24 horas ($1).',
	'autocreatewiki-empty-field' => 'Por favor, preencha esse campo.',
	'autocreatewiki-bad-name' => 'O nome não pode conter caracteres especiais (como $ ou @) nem espaços e precisa estar todo em minúsculo.',
	'autocreatewiki-invalid-wikiname' => 'O nome não pode conter caracteres especiais (como $ ou @) e não pode estar vazio.',
	'autocreatewiki-violate-policy' => 'Esse nome de wiki contém uma palavra que viola as nossas políticas de nomeação.',
	'autocreatewiki-name-taken' => 'Já existe uma wiki com esse nome. Você é bem-vindo a partipar dela em <a href="http://$1.wikia.com">http://$1.wikia.com</a> .',
	'autocreatewiki-name-too-short' => 'Esse nome é muito curto, por favor escolha um nome com no mímino 3 caracteres.',
	'autocreatewiki-name-too-long' => 'Esse nome é muito longo, por favor escolha um nome com no máximo 50 caracteres.',
	'autocreatewiki-similar-wikis' => 'Abaixo estão as wikis já criadas nesse tópico. Nós sugerimos que você edite uma delas.',
	'autocreatewiki-invalid-username' => 'Esse nome de usuário é inválido.',
	'autocreatewiki-busy-username' => 'Esse nome de usuário já é usado.',
	'autocreatewiki-blocked-username' => 'Você não pode criar uma conta.',
	'autocreatewiki-user-notloggedin' => 'Sua conta foi criada, mas você não está logado.',
	'autocreatewiki-empty-language' => 'Por favor, selecione o idioma da Wiki.',
	'autocreatewiki-empty-category' => 'Por favor, selecione uma categoria.',
	'autocreatewiki-empty-wikiname' => 'O nome da Wiki não pode estar vazio.',
	'autocreatewiki-empty-username' => 'O nome de usuário não pode estar vazio.',
	'autocreatewiki-empty-password' => 'A senha não pode estar vazia.',
	'autocreatewiki-empty-retype-password' => '"Redigite sua senha" não pode estar vazio.',
	'autocreatewiki-category-label' => 'Categoria:',
	'autocreatewiki-category-other' => 'Outro',
	'autocreatewiki-set-username' => 'Primeiro defina o nome de usuário.',
	'autocreatewiki-invalid-category' => 'Categoria inválida.
Selecione uma apropriada da lista.',
	'autocreatewiki-invalid-language' => 'Língua inválida.
Selecione uma apropriada da lista.',
	'autocreatewiki-invalid-retype-passwd' => 'Repita a mesma senha, por favor',
	'autocreatewiki-invalid-birthday' => 'Data de nascimento inválida',
	'autocreatewiki-limit-birthday' => 'Não foi possível criar o registro.',
	'autocreatewiki-log-title' => 'A sua wiki está sendo criada',
	'autocreatewiki-step0' => 'Iniciando processo ...',
	'autocreatewiki-stepdefault' => 'O processo está sendo feito, por favor aguarde...',
	'autocreatewiki-errordefault' => 'O processo não foi finalizado...',
	'autocreatewiki-step1' => 'Criando o diretório de imagens ...',
	'autocreatewiki-step2' => 'Criando a base de dados ...',
	'autocreatewiki-step3' => 'Definindo os dados por padrão na base de dados ...',
	'autocreatewiki-step4' => 'Copiando as imagens e logotipo padrões ...',
	'autocreatewiki-step5' => 'Definindo as variáveis padrões na base de dados ...',
	'autocreatewiki-welcomesubject' => '$1 foi criado!',
	'autocreatewiki-welcomebody' => 'Olá, $2,

O Wikia que você requisitou está agora disponível em <$1>. Nós esperamos vê-lo editando lá em breve!

Nós adicionamos algumas informações e dicas na sua página de discussão de usuário <$5> pra ajudar-lhe a começar.

Se você tiver algum problema, você pode pedir a ajuda da comunidade na wiki em <http://www.wikia.com/wiki/Forum:Help_desk> ou via email para community@wikia.com . Você também pode visitar nosso canal de chat IRC #wikia IRC <http://irc.wikia.com>.

Eu posso ser contatado diretamente por email ou na minha página de discussão, caso você tenha alguma pergunta ou preocupação.

Boa sorte com o projeto!

$3

Equipe da comunidade do Wikia (Wikia Community Team)

<http://www.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => "== Boas-vindas! ==
<div style=\"font-size:120%; line-height:1.2em;\">Olá \$1 -- nós estamos felizes por ter '''\$4''' como parte da comunidade do Wikia!

Agora você tem um website inteiro para encher de informações, figuras e vídeos sobre os seus tópicos favoritos. Mas, agora mesmo, há apenas páginas vazias olhando para você... Assustador, certo? Aqui estão algumas formas de começar.

* '''Introduza seu tópico''' na página principal. Essa é sua oportunidade de explicar aos seus leitores sobre o que seu tópico trata. Escreva o quanto quiser! Sua descrição pode conter links para todas as páginas importantes do seu site.

* '''Inicie algumas páginas novas''' -- apenas uma frase ou duas já esta bom para começar. Não deixe as páginas em branco desanimarem você! Um wiki é exatamente acrescentar, adicionar e mudar enquanto você está criando. Você também pode carregar imagens e vídeos para dar conteúdo à página e deixá-la mais interessante.

Então, apenas continue editando! As pessoas gostam de visitar wikis quando há muitas informações e coisa para serem lidas e vistas, então continue adicionando coisas e aumentando sua wiki e você irá atrair leitores e editores. Há muita coisa a ser feita, mas não se preocupe, hoje é apenas o seu primeiro dia e você ainda tem tempo de sobra. Toda wiki começa do mesmo jeito, com um pouco de cada vez, começando com poucas páginas até crescer e se transformar num enorme e ocupado site.

Se você tiver alguma dúvida, você pode nos contatar através do nosso [[Special:Contact|formulário de contato]]. Divirta-se!

-- [[User:\$2|\$3]] <staff /></div>",
	'newwikis' => 'Novas wikis',
	'newwikisstart' => 'Mostrar Wikis começando com:',
	'autocreatewiki-reminder-body' => '
Caro(a) $1:

Parabéns por começar a seu nova wiki, {{SITENAME}}! Você pode voltar e adicionar mais informações a sua wiki visitando $2.

Esse é um projeto novo, então, por favor, nos escreva caso você tenha alguma dúvida!


-- Equipe da comunidade do Wikia (Wikia Community Team)',
	'autocreatewiki-reminder-body-HTML' => '<p>Caro(a) $1:</p>

<p>Parabéns por começar a seu nova wiki, {{SITENAME}}! Você pode voltar e adicionar mais informações a sua wiki visitando
<a href="$2">$2</a>.</p>

<p>Este é um projeto novo, então, por favor, nos escreva se você tiver alguma dúvida!</p>

<p>-- Equipe da comunidade do Wikia (Wikia Community Team)</p>',
);

/** Romanian (Română)
 * @author Minisarm
 * @author Misterr
 */
$messages['ro'] = array(
	'autocreatewiki' => 'Creează un site de tip wiki',
	'autocreatewiki-desc' => 'Creează wiki în Wikifactory la cererea unui utilizator',
	'autocreatewiki-page-title-default' => 'Creează un nou site de tip wiki',
	'autocreatewiki-page-title-answers' => 'Creează un nou site de răspunsuri',
	'createwiki' => 'Creează un nou site de tip wiki',
	'autocreatewiki-chooseone' => 'Alegeți una',
	'autocreatewiki-required' => '$1 = solicitat',
	'autocreatewiki-web-address' => 'Adresă web:',
	'autocreatewiki-category-select' => 'Selectați unul',
	'autocreatewiki-language-top' => 'Clasamentul primelor $1 (de) limbi',
	'autocreatewiki-language-all' => 'Toate limbile',
	'autocreatewiki-birthdate' => 'Data nașterii:',
	'autocreatewiki-blurry-word' => 'Cuvânt neclar:',
	'autocreatewiki-remember' => 'Ține-mă minte',
	'autocreatewiki-create-account' => 'Creați-vă un cont',
	'autocreatewiki-done' => 'rezolvat',
	'autocreatewiki-error' => 'eroare',
	'autocreatewiki-haveaccount-question' => 'Aveți deja un cont Wikia?',
	'autocreatewiki-success-title-default' => 'Site-ul dumneavoastră de tip wiki a fost creat cu succes!',
	'autocreatewiki-success-title-answers' => 'Site-ul dumneavoastră de răspunsuri a fost creat!',
	'autocreatewiki-success-subtitle' => 'Puteți începe acum lucrul pe acest wiki vizitând:',
	'autocreatewiki-success-has-been-created' => 'a fost creat!',
	'autocreatewiki-success-get-started' => 'Începeți',
	'autocreatewiki-info-domain' => 'Cel mai bun mod de a căuta un subiect este să utilizați cuvinte cheie.',
	'autocreatewiki-info-topic' => 'Adăugați o scurtă descriere, cum ar fi „Star Wars” sau „emisiuni TV”.',
	'autocreatewiki-info-category-default' => 'Acest lucru îi va ajuta pe vizitatori să găsească site-ul dumneavoastră de tip wiki.',
	'autocreatewiki-info-category-answers' => 'Acest lucru îi va ajuta pe vizitatori să găsească site-ul dumneavoastră de răspunsuri.',
	'autocreatewiki-info-language' => 'Aceasta va fi limba implicită a interfeței pentru vizitatorii site-ului dumneavoastră de tip wiki.',
	'autocreatewiki-info-email-address' => 'Adresa dvs. de email nu va fi niciodată văzută pe vreun proiect Wikia.',
	'autocreatewiki-limit-creation' => 'Ați depășit numărul maxim de site-uri wiki create în 24 de ore ($1).',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'autocreatewiki-done' => 'fatte',
	'autocreatewiki-error' => 'errore',
	'autocreatewiki-language-top-list' => 'de,en,es,he,fr,it,ja,no,pl,pt,pt-br,zh',
);

/** Russian (Русский)
 * @author DCamer
 * @author Grigol
 * @author Lockal
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'autocreatewiki' => 'Создать новую вики',
	'autocreatewiki-desc' => 'Создание вики на ВикиФабрике по запросам участников',
	'autocreatewiki-page-title-default' => 'Создание новой вики',
	'autocreatewiki-page-title-answers' => 'Создать новый сайт ответов',
	'createwiki' => 'Создание новой вики',
	'autocreatewiki-chooseone' => 'Выберите из списка',
	'autocreatewiki-required' => '$1 = обязательно',
	'autocreatewiki-web-address' => 'Веб-адрес:',
	'autocreatewiki-category-select' => 'Выберите',
	'autocreatewiki-language-top' => '$1 наиболее используемых языков',
	'autocreatewiki-language-all' => 'Все языки',
	'autocreatewiki-birthdate' => 'Дата рождения:',
	'autocreatewiki-blurry-word' => 'Размытое слово:',
	'autocreatewiki-remember' => 'Запомнить меня',
	'autocreatewiki-create-account' => 'Создание учётной записи',
	'autocreatewiki-done' => 'выполнено',
	'autocreatewiki-error' => 'ошибка',
	'autocreatewiki-language-top-list' => 'de,en,es,he,fr,it,ja,no,pl,pt,pt-br,zh',
	'autocreatewiki-haveaccount-question' => 'У вас уже есть учётная записи в Викиа?',
	'autocreatewiki-success-title-default' => 'Ваша вики была создана!',
	'autocreatewiki-success-title-answers' => 'Ваши сайт ответов был создан!',
	'autocreatewiki-success-subtitle' => 'Теперь вы можете начинать работать в вашей вики, перейдя на страницу:',
	'autocreatewiki-success-has-been-created' => 'был создан!',
	'autocreatewiki-success-get-started' => 'Начало работы',
	'autocreatewiki-info-domain' => 'Лучше использовать такое слово, которое для вашей темы является ключевым при поиске.',
	'autocreatewiki-info-topic' => 'Добавьте краткое описание, например, «Звёздные войны» или «ТВ-шоу».',
	'autocreatewiki-info-category-default' => 'Это поможет посетителям найти вашу вики.',
	'autocreatewiki-info-category-answers' => 'Это поможет посетителям найти ваш сайт ответов.',
	'autocreatewiki-info-language' => 'Язык по умолчанию для посетителей вашей вики.',
	'autocreatewiki-info-email-address' => 'Адрес вашей электронной почты никому не показывается в Викии.',
	'autocreatewiki-info-realname' => 'Если вы решите указать его, то оно будет использовано для указания авторства вашей работы.',
	'autocreatewiki-info-birthdate' => 'Wikia требует, чтобы все пользователи указывали свою настоящую дату рождения, это является мерой предосторожности, позволяет обеспечить соответствие сайта требованиям федеральных правил.',
	'autocreatewiki-info-blurry-word' => 'Пожалуйста, введите размытые слова, которые вы видите в этой области. Это делается для защиты от автоматического создания учётных записей.',
	'autocreatewiki-info-terms-agree' => 'Создавая вики и учётную запись, вы соглашаетесь с <a href="http://www.wikia.com/wiki/Terms_of_use">Условиями использования Wikia</a>',
	'autocreatewiki-info-staff-username' => '<b>Только для персонала:</b> Указанный участник будет показан как учредитель.',
	'autocreatewiki-title-template' => '$1 вики',
	'autocreatewiki-limit-day' => 'Wikia превысила максимальное число вики, создаваемых за день ($1).',
	'autocreatewiki-limit-creation' => 'Вы превысили максимальное количество вики, которое можно создать за 24 часа ($1).',
	'autocreatewiki-empty-field' => 'Пожалуйста, заполните это поле.',
	'autocreatewiki-bad-name' => 'Название не может содержать специальные символы (например, $ или @) и должно быть представлено одним словом, написанным строчными буквами без пробелов.',
	'autocreatewiki-invalid-wikiname' => 'Название не может содержать специальные символы (например, $ или @) и не может быть пустым',
	'autocreatewiki-violate-policy' => 'Это название вики содержит слова, которые нарушают наши правила именования',
	'autocreatewiki-name-taken' => 'Вики с таким названием уже существует. Вы можете присоединиться к проекту <a href="http://$1.wikia.com">http://$1.wikia.com</a>',
	'autocreatewiki-name-too-short' => 'Это название слишком коротко. Пожалуйста, выберите название длиной не менее 3 символов.',
	'autocreatewiki-name-too-long' => 'Это название слишком длинное. Пожалуйста, выберите название длиной не более 50 символов.',
	'autocreatewiki-similar-wikis' => 'Ниже приведены уже существующие вики по этой теме. Мы предлагаем редактировать одну из них.',
	'autocreatewiki-invalid-username' => 'Недопустимое имя участника.',
	'autocreatewiki-busy-username' => 'Это имя участника уже занято.',
	'autocreatewiki-blocked-username' => 'Вы не можете создать учётную запись.',
	'autocreatewiki-user-notloggedin' => 'Ваша учётная запись была создана, но вы не вошли в систему!',
	'autocreatewiki-empty-language' => 'Пожалуйста, выберите язык для вики.',
	'autocreatewiki-empty-category' => 'Пожалуйста, выберите одну из категорий.',
	'autocreatewiki-empty-wikiname' => 'Название вики не может быть пустым.',
	'autocreatewiki-empty-username' => 'Имя участника не может быть пустым.',
	'autocreatewiki-empty-password' => 'Пароль не может быть пустым.',
	'autocreatewiki-empty-retype-password' => 'Повтор пароля не может быть пустым.',
	'autocreatewiki-category-label' => 'Категория:',
	'autocreatewiki-category-other' => 'Другое',
	'autocreatewiki-set-username' => 'Сначала выберите имя участника.',
	'autocreatewiki-invalid-category' => 'Неправильное значение категории.
Пожалуйста, выберите возможный вариант из выпадающего списка.',
	'autocreatewiki-invalid-language' => 'Неправильное значение языка.
Пожалуйста, выберите возможный вариант из выпадающего списка.',
	'autocreatewiki-invalid-retype-passwd' => 'Пожалуйста, введите повторно тот же самый пароль',
	'autocreatewiki-invalid-birthday' => 'Неверная дата рождения',
	'autocreatewiki-limit-birthday' => 'Невозможно создать регистрацию.',
	'autocreatewiki-log-title' => 'Ваша вики создаётся',
	'autocreatewiki-step0' => 'Процесс инициализации…',
	'autocreatewiki-stepdefault' => 'Процесс запущен, пожалуйста, подождите …',
	'autocreatewiki-errordefault' => 'Процесс не был завершён …',
	'autocreatewiki-step1' => 'Создание директории изображений …',
	'autocreatewiki-step2' => 'Создание базы данных …',
	'autocreatewiki-step3' => 'Установка информации по умолчанию в базе данных …',
	'autocreatewiki-step4' => 'Копирование изображений по умолчанию и логотипа …',
	'autocreatewiki-step5' => 'Установка стандартных переменных в базе данных …',
	'autocreatewiki-step6' => 'Установка стандартных таблиц в базе данных …',
	'autocreatewiki-step7' => 'Установка начального языка …',
	'autocreatewiki-step8' => 'Настройка групп участников и категорий …',
	'autocreatewiki-step9' => 'Установка переменных для новой вики …',
	'autocreatewiki-step10' => 'Настройка страниц на центральной вики …',
	'autocreatewiki-step11' => 'Отправка сообщения на электронную почту участника …',
	'autocreatewiki-redirect' => 'Перенаправление в новую вики: $1 …',
	'autocreatewiki-congratulation' => 'Поздравляем!',
	'autocreatewiki-welcometalk-log' => 'Сообщение приветствия',
	'autocreatewiki-regex-error-comment' => 'использовано в вики $1 (полный текст: $2)',
	'autocreatewiki-step2-error' => 'База данных существует!',
	'autocreatewiki-step3-error' => 'Не удаётся установить в базе данных сведения по умолчанию!',
	'autocreatewiki-step6-error' => 'Не удаётся установить таблицы по умолчанию в базе данных!',
	'autocreatewiki-step7-error' => 'Не удаётся скопировать начальную базу данных для языка!',
	'autocreatewiki-protect-reason' => 'Часть официального интерфейса',
	'autocreatewiki-welcomesubject' => 'Создание $1 прошло успешно!',
	'autocreatewiki-welcomebody' => 'Здравствуйте, $2.

По вашему запросу создана Wikia, доступная сейчас по адресу <$1> Мы надеемся, что в ближайшее время вы начнёте её редактирование!

Мы добавили некоторую информацию и советы на вашу страницу обсуждения участника (<$5>), чтобы помочь вам начать работу.

Если у вас возникнут какие-либо проблемы, вы можете попросить сообщество помочь в вики <http://www.wikia.com/wiki/Forum:Help_desk>, или по электронной почте community@wikia.com. Вы также можете посетить наш IRC чат-канал #wikia <http://irc.wikia.com>.

Со мной можно связаться напрямую по электронной почте или на моей странице обсуждения, если у вас есть вопросы или замечания.

Удачи в развитии проекта!

$3

Команда сообщества Wikia

<http://www.wikia.com/wiki/User:$4>',
	'autocreatewiki-welcometalk' => "== Добро пожаловать! ==
<div style=\"font-size:120%; line-height:1.2em;\">Здравствуйте, \$1 — мы рады, что '''\$4''' — часть сообщества Wikia!

Теперь у вас есть целый сайт для добавления информации, фотографий и видео на свою любимую тему. Но сейчас на вас смотрят пустые страницы… Страшно, да? Вот некоторые способы, чтобы начать работу.

* '''Представьте свою тему''' на первой странице. Это ваша возможность объяснить вашим читателям, о чём ваша тема. Пишите сколько хотите! Ваше описание может связать все важные страницы на вашем сайте.

* '''Дайте начало новым страницам''' — только одно или два предложения чтобы начать. Не делайте пустых страниц! Смысл вики в добавлении и изменении статей по мере вашего продвижения вперёд. Вы также можете добавить фотографии и видео, чтобы заполнить страницу и сделать её более интересной.

А потом просто идите! Люди любят посещать вики с большим количеством материала для чтения и просмотра, поэтому продолжайте добавлять материал, и вы будете привлекать читателей и редакторов.  Предстоит много чего сделать, но не волнуйтесь — сегодня первый день, а у вас много времени. Любая вики начинается точно так же — понемногу за раз, начиная с первых нескольких страниц, пока она не превращается в огромный, оживлённый сайт.

Если у вас есть вопросы, вы можете написать нам через [[Special:Contact|контактную форму]]. Удачи!

— [[User:\$2|\$3]] <staff /></div>",
	'newwikis' => 'Новые вики',
	'newwikisstart' => 'Показать вики, начиная с:',
	'autocreatewiki-reminder-body' => 'Здравствуйте, $1.

Поздравляем с началом работы вашей новой вики, {{SITENAME}}! Вы можете вернуться и добавить ещё вики, посетив $2.

Это совершенно новый проект, поэтому, пожалуйста, напишите нам, если у вас есть какие-либо вопросы!

-- Команда сообщества Wikia',
	'autocreatewiki-reminder-body-HTML' => '<p>Здравствуйте, $1.</p>

<p>Поздравляем с началом работы вашей новой вики, translatewiki.net! Вы можете вернуться и добавить ещё вики, посетив <a href="$2">$2</a>.</p>

<p>Это совершенно новый проект, поэтому, пожалуйста, напишите нам, если у вас есть какие-либо вопросы!</p>

<p>-- Команда сообщества Wikia</p>',
	'autocreatewiki-subname-answers' => 'Ответы',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Rancher
 * @author Verlor
 * @author Жељко Тодоровић
 */
$messages['sr-ec'] = array(
	'autocreatewiki' => 'Направите нову вики',
	'autocreatewiki-page-title-default' => 'Направите нову Викију',
	'createwiki' => 'Направите нову вики',
	'autocreatewiki-category-select' => 'Одабери једну',
	'autocreatewiki-language-top' => 'Топ $1 језика',
	'autocreatewiki-language-all' => 'Сви језици',
	'autocreatewiki-birthdate' => 'Датум рођења:',
	'autocreatewiki-blurry-word' => 'Мутна реч:',
	'autocreatewiki-remember' => 'Запамти ме',
	'autocreatewiki-create-account' => 'Направите налог',
	'autocreatewiki-done' => ' учињено',
	'autocreatewiki-error' => ' грешка',
	'autocreatewiki-haveaccount-question' => 'Имате ли већ Викија налог?',
	'autocreatewiki-success-title-default' => ' Ваша викија је управо створена!',
	'autocreatewiki-success-has-been-created' => 'је направљена!',
	'autocreatewiki-success-get-started' => 'Увод',
	'autocreatewiki-info-category-default' => 'Ово ће помоћи да посетиоци нађу вашу викију.',
	'autocreatewiki-info-category-answers' => 'Ово ће помоћи посетиоцима да нађу ваш сајт са одговорима',
	'autocreatewiki-info-language' => 'Ово ће бити стандардни радни језик за посетиоце ваше викије.',
	'autocreatewiki-info-email-address' => 'Ваша адреса е-поште се никад ником не приказује на Викији.',
	'autocreatewiki-info-terms-agree' => 'Стварањем викије и налога ви прихватате <a href="http://www.wikia.com/wiki/Terms_of_use">Wikia\'s Terms of Use</a>',
	'autocreatewiki-empty-field' => 'Молимо Вас да унесете ово поље.',
	'autocreatewiki-invalid-username' => 'Ваше корисничко име не важи',
	'autocreatewiki-busy-username' => 'Ваше корисничко име неко већ користи',
	'autocreatewiki-blocked-username' => 'Не може да се направи налог',
	'autocreatewiki-user-notloggedin' => 'Ваш налог је направљен, али се нисте пријавили!',
	'autocreatewiki-empty-language' => 'Одаберите језик за ову вики',
	'autocreatewiki-empty-category' => 'Одаберите једну од категорија',
	'autocreatewiki-empty-wikiname' => 'Име викије не може да буде празно',
	'autocreatewiki-empty-username' => 'Име корисника не може да буде празно.',
	'autocreatewiki-empty-password' => 'Лозинка не сме бити празна',
	'autocreatewiki-empty-retype-password' => 'Поново укуцајте лозинку, јер не може да буде празна.',
	'autocreatewiki-category-label' => 'Категорија:',
	'autocreatewiki-category-other' => 'Друго',
	'autocreatewiki-set-username' => 'Унесите корисничко име',
	'autocreatewiki-invalid-birthday' => 'Неважећи датум рођења',
	'autocreatewiki-log-title' => 'Ваша викија је створена',
	'autocreatewiki-step0' => 'Почетак процеса .....',
	'autocreatewiki-stepdefault' => 'Процес у току, молимо да сачекате .....',
	'autocreatewiki-errordefault' => 'Процес није завршен ...',
	'autocreatewiki-step1' => 'Прављење фасцикле за слике...',
	'autocreatewiki-step2' => 'Прављење базе података...',
	'autocreatewiki-step11' => 'Слање е-поруке кориснику...',
	'autocreatewiki-redirect' => 'Преусмеравање на нови вики: $1...',
	'autocreatewiki-congratulation' => 'Честитамо!',
	'autocreatewiki-welcometalk-log' => 'Порука добродошлице',
	'autocreatewiki-step2-error' => 'Постоји база података!',
	'autocreatewiki-protect-reason' => 'Део званичног интерфејса',
	'autocreatewiki-welcomesubject' => '$1 је створен!',
	'autocreatewiki-reminder-body' => 'Драги $1:

Честитамо што сте покренули нову викију, {{SITENAME}}!  Можете да се вратите и да још тога додате у вашу викију посећујући $2.

Ово је нов-новцат пројекат,  па Вас молимо да нам пишете уколико имате неких питања!

-- Тим Викија заједнице',
	'autocreatewiki-reminder-body-HTML' => '<p>Драги $1:</p>

<p>Честитамо што сте покренули нову викију, {{SITENAME}}!  Можете да се вратите и да још тога додате у вашу викију посећујући 
<a href="$2">$2</a>.</p>

<p>Ово је нов-новцат пројекат,  па Вас молимо да нам пишете уколико имате неких питања!</p>

<p>-- Тим Викија заједнице</p>',
	'autocreatewiki-subname-answers' => 'Одговори',
);

/** Swahili (Kiswahili) */
$messages['sw'] = array(
	'autocreatewiki-create-account' => 'Sajili akaunti',
	'autocreatewiki-error' => 'hitilafu',
	'autocreatewiki-category-label' => 'Jamii:',
	'autocreatewiki-category-other' => 'Nyingine',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'autocreatewiki-language-all' => 'అన్ని భాషలు',
	'autocreatewiki-birthdate' => 'పుట్టిన రోజు:',
	'autocreatewiki-category-other' => 'ఇతర',
	'autocreatewiki-congratulation' => 'అభినందనలు!',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'autocreatewiki' => 'Lumikha ng isang bagong wiki',
	'autocreatewiki-desc' => 'Lumikha ng wiki sa WikiPabrika ayon sa mga kahilingan ng tagagamit',
	'autocreatewiki-page-title-default' => 'Lumikha ng isang bagong wiki',
	'autocreatewiki-page-title-answers' => 'Lumikha ng isang bagong sityo ng Mga Sagot',
	'createwiki' => 'Lumikha ng isang bagong wiki',
	'autocreatewiki-chooseone' => 'Pumili ng isa',
	'autocreatewiki-required' => '$1 = kailangan',
	'autocreatewiki-web-address' => 'Tirahan ng web:',
	'autocreatewiki-category-select' => 'Pumili ng isa',
	'autocreatewiki-language-top' => 'Pinakamataas na $1 na mga wika',
	'autocreatewiki-language-all' => 'Lahat ng mga wika',
	'autocreatewiki-birthdate' => 'Kaarawan:',
	'autocreatewiki-blurry-word' => 'Malabong salita:',
	'autocreatewiki-remember' => 'Tandaan ako',
	'autocreatewiki-create-account' => 'Lumikha ng isang akawnt',
	'autocreatewiki-done' => 'nagawa na',
	'autocreatewiki-error' => 'kamalian',
	'autocreatewiki-haveaccount-question' => 'Mayroon ka na bang isang akawnt sa Wikia',
	'autocreatewiki-success-title-default' => 'Nalikha na ang wiki mo!',
	'autocreatewiki-success-title-answers' => 'Nalikha na ang iyong sityo ng mga sagot!',
	'autocreatewiki-success-subtitle' => 'Makapagsisimula ka nang gumawa sa iyong wiki sa pamamagitan ng pagdalaw sa:',
	'autocreatewiki-success-has-been-created' => 'ay nalikha na!',
	'autocreatewiki-success-get-started' => 'Magsimula',
	'autocreatewiki-info-domain' => 'Pinakamainam na gamitin ang isang salitang mas malamang na isang susing-salita ng paghahanap para sa iyong paksa.',
	'autocreatewiki-info-topic' => 'Magdagdag ng isang maikling paglalarawan na katulad ng "Star Wars" o "mga palabas sa TV".',
	'autocreatewiki-info-category-default' => 'Makakatulong ito sa mga panauhin na matagpuan ang wiki mo.',
	'autocreatewiki-info-category-answers' => 'Makakatulong ito sa mga panauhin na matagpuan ang sityo mo ng Mga Sagot.',
	'autocreatewiki-info-language' => 'Ito ang magiging likas na nakatakdang wika para sa mga panauhin ng wiki mo.',
	'autocreatewiki-info-email-address' => 'Hindi ipapakita kailanman ng Wikia sa sinuman ang tirahan mo ng e-liham.',
	'autocreatewiki-empty-field' => 'Pakikumpleto ang lugar na ito.',
	'autocreatewiki-invalid-username' => 'Hindi tanggap ang pangalang pangtagagamit na ito.',
	'autocreatewiki-busy-username' => 'May nakakuha na ng pangalang pangtagagamit na ito.',
	'autocreatewiki-blocked-username' => 'Hindi mo malilikha ang akawnt.',
	'autocreatewiki-user-notloggedin' => 'Nalikha ang akawnt mo pero hindi nakalagda!',
	'autocreatewiki-empty-language' => 'Pakipili ang wika na para sa wiki.',
	'autocreatewiki-empty-category' => 'Paki pumili ng isang kategorya.',
	'autocreatewiki-empty-wikiname' => 'Hindi maaaring walang laman ang pangalan ng wiki.',
	'autocreatewiki-empty-username' => 'Hindi maaaring walang laman ang pangalang pangtagagamit.',
	'autocreatewiki-empty-password' => 'Hindi maaaring walang laman ang hudyat.',
	'autocreatewiki-empty-retype-password' => 'Hindi maaaring walang laman ang muling imakinilya ang hudyat.',
	'autocreatewiki-category-other' => 'Iba pa',
	'autocreatewiki-set-username' => 'Itakda muna ang pangalan ng tagagamit.',
	'autocreatewiki-invalid-birthday' => 'Hindi tanggap na petsa ng kaarawan',
	'autocreatewiki-limit-birthday' => 'Hindi nagawang likhain ang pagpapatala.',
	'autocreatewiki-log-title' => 'Nililikha na ang wiki mo',
	'autocreatewiki-step0' => 'Sinisimulan ang pagsasagawa ...',
	'autocreatewiki-stepdefault' => 'Tumatakbo ang pagsasagawa, pakihintay ...',
	'autocreatewiki-errordefault' => 'Hindi tapos ang pagsasagawa ...',
	'autocreatewiki-step1' => 'Nililikha ang sisidlan ng mga larawan ...',
	'autocreatewiki-step2' => 'Nililikha ang kalipunan ng dato ...',
	'autocreatewiki-step3' => 'Itinatalaga ang likas na nakatakdang kabatiran sa loob ng kalipunan ng dato ...',
	'autocreatewiki-step4' => 'Kinokopya ang likas na nakatakdang mga larawan at logo ...',
	'autocreatewiki-step5' => 'Itinatalaga ang likas na nakatakdang mga nagbabago sa loob ng kalipunan ng dato ...',
	'autocreatewiki-congratulation' => 'Maligayang bati!',
	'autocreatewiki-welcometalk-log' => 'Pambati sa Pagdating',
	'autocreatewiki-step2-error' => 'Umiiral ang kalipunan ng dato!',
);

/** Ukrainian (Українська)
 * @author NickK
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'autocreatewiki' => 'Створити нову Вікі',
	'autocreatewiki-page-title-default' => 'Створити нову Вікі',
	'createwiki' => 'Створити нову Вікі',
	'autocreatewiki-chooseone' => 'Виберіть зі списку',
	'autocreatewiki-required' => "$1 = обов'язково",
	'autocreatewiki-web-address' => 'Веб-адреса:',
	'autocreatewiki-category-select' => 'Виберіть одну',
	'autocreatewiki-create-account' => 'Створити обліковий запис',
	'autocreatewiki-error' => 'помилка',
	'autocreatewiki-info-topic' => 'Додайте короткий опис, наприклад, "Зоряні війни" або "ТВ-шоу".',
	'autocreatewiki-protect-reason' => 'Частина офіційного інтерфейсу',
	'newwikis' => 'Нові вікі',
);

/** Chinese (中文) */
$messages['zh'] = array(
	'autocreatewiki-page-title-default' => '申请wiki',
	'createwiki' => '申請Wiki',
	'autocreatewiki-info-language' => '的預設語文',
	'autocreatewiki-welcomesubject' => '$1 已建立!',
	'autocreatewiki-welcomebody' => '嗨 $2,

歡迎加入Wikia社群。相信很快能看到你對此站的貢獻。

如果您在使用上有任何問題，可先查閱說明頁面<http://help.wikia.com> (英文)，或是查看中文的[[w:c:zh:Category:中文說明|使用說明]]

祝您使用快

Wikia 社群團隊',
);

/** Chinese (China) (‪中文(中国大陆)‬) */
$messages['zh-cn'] = array(
	'autocreatewiki-page-title-default' => '申请wiki',
	'createwiki' => '申请wiki',
);

/** Simplified Chinese (‪中文(简体)‬) */
$messages['zh-hans'] = array(
	'autocreatewiki-page-title-default' => '申请wiki',
	'createwiki' => '申请wiki',
);

/** Traditional Chinese (‪中文(繁體)‬) */
$messages['zh-hant'] = array(
	'autocreatewiki-page-title-default' => '申請wiki',
	'createwiki' => '申請wiki',
);

/** Chinese (Hong Kong) (‪中文(香港)‬) */
$messages['zh-hk'] = array(
	'autocreatewiki-page-title-default' => '申請wiki',
	'createwiki' => '申請wiki',
);

/** Chinese (Singapore) (‪中文(新加坡)‬) */
$messages['zh-sg'] = array(
	'autocreatewiki-page-title-default' => '申请wiki',
	'createwiki' => '申请wiki',
);

/** Chinese (Taiwan) (‪中文(台灣)‬) */
$messages['zh-tw'] = array(
	'autocreatewiki-page-title-default' => '申請wiki',
	'createwiki' => '申請wiki',
);

