<?php
/**
* Internationalisation file for the CreateNewWiki extension.
*
* @addtogroup Languages
*/

$messages = array();

$messages['en'] = array(
	'createnewwiki-desc' => 'Wiki creation wizard',
	'cnw-next' => 'Next',
	'cnw-back' => 'Back',
	'cnw-or' => 'or',
	'cnw-title' => 'Create New Wiki',
	'cnw-name-wiki-headline' => 'Start a wikia',
	'cnw-name-wiki-creative' => 'Build a website, grow a community, and embark on your ultimate fan experience.',
	'cnw-name-wiki-label' => 'Name your wikia',
	'cnw-name-wiki-domain-label' => 'Give your wikia an address',
	'cnw-name-wiki-language' => '',
	'cnw-name-wiki-domain' => '.wikia.com',
	'cnw-name-wiki-submit-error' => 'Oops! You need to fill in both of the boxes above to keep going.',
	'cnw-login' => 'Log In',
	'cnw-signup' => 'Create Account',
	'cnw-signup-prompt' => 'Need an account?',
	'cnw-call-to-signup' => 'Sign up here',
	'cnw-login-prompt' => 'Already have an account?',
	'cnw-call-to-login' => 'Log in here',
	'cnw-auth-headline' => 'Log In',
	'cnw-auth-headline2' => 'Sign Up',
	'cnw-auth-creative' => 'Log in to your account to continue building your wiki.',
	'cnw-auth-signup-creative' => "You'll need an account to continue building your wiki.<br />It only takes a minute to sign up!",
	'cnw-auth-facebook-signup' => 'Sign up with Facebook',
	'cnw-auth-facebook-login' => 'Login with Facebook',
	'cnw-userauth-headline' => 'Have an account?',
	'cnw-userauth-creative' => 'Log in',
	'cnw-userauth-marketing-heading' => "Don't have an account?",
	'cnw-userauth-marketing-body' => 'You need an account to create a wiki on Wikia. It only takes a minute to sign up!',
	'cnw-userauth-signup-button' => 'Sign up',
	'cnw-desc-headline' => "What's your wikia about?",
	'cnw-desc-creative' => 'Help people find your wikia with a superb description.',
	'cnw-desc-placeholder' => 'Make it good! Your text will appear on the main page of your wikia.',
	'cnw-desc-tip1' => "Here's a tip!",
	'cnw-desc-tip1-creative' => 'Use this space to tell people why this wikia matters and the reason you created it.',
	'cnw-desc-tip2' => 'PS',
	'cnw-desc-tip2-creative' => 'Encourage others to join your community by offering details about your wikia.',
	'cnw-desc-select-vertical' => 'Select a Hub category',
	'cnw-desc-select-categories' => 'Check additional categories',
	'cnw-desc-select-one' => 'Select one',
	'cnw-desc-all-ages' => 'Is this wikia intended for kids?',
	'cnw-desc-tip-all-ages' => 'Is this about a topic that children are interested in? In order to help us comply with US law we keep track of wikias about topics that directly appeal to children 12 and under.',
	'cnw-desc-default-lang' => 'Your wikia will be in $1',
	'cnw-desc-change-lang' => 'change',
	'cnw-desc-lang' => 'Language',
	'cnw-desc-wiki-submit-error' => 'Please choose a category',
	'cnw-theme-headline' => 'Choose a theme',
	'cnw-theme-creative' => 'Make it look good! Select a theme to see a preview of it.',
	'cnw-theme-instruction' => 'Want to customize it? You can design your own theme later by going to Theme Designer via your Admin Dashboard.',
	'cnw-welcome-headline' => 'Congratulations! You successfully created $1',
	'cnw-welcome-instruction1' => 'Click the button below to start adding pages to your wikia.',
	'cnw-welcome-help' => 'Continue your fan experience. Find answers, advice, and more on <a href="http://community.wikia.com">Community Central</a>.',
	'cnw-error-general' => 'Oops, something went wrong on our side!  Please try again, or [[Special:Contact|contact us]] for help.',
	'cnw-error-general-heading' => 'Our apologies',
	'cnw-badword-header' => 'Whoa there',
	'cnw-badword-msg' => 'Hi, please refrain from using these bad words or banned words in your Wiki Description: $1',
	'cnw-error-wiki-limit-header' => 'Wiki limit reached',
	'cnw-error-wiki-limit' => 'Hi, you are limited to {{PLURAL:$1|$1 wiki creation|$1 wiki creations}} per day. Wait 24 hours before creating another wiki.',
	'cnw-error-blocked-header' => 'Account blocked',
	'cnw-error-blocked' => 'You have been blocked by $1. The reason given was: $2. (Block ID for reference: $3)',
	'cnw-error-anon-user-header' => 'Please log in',
	'cnw-error-anon-user' => 'Creating wikis for anons is disabled. Please [[Special:UserLogin|log in]] and try again.',
	'cnw-error-torblock' => 'Creating wikis via the Tor Network is not allowed.',
	'cnw-error-bot' => 'We have detected that you may be a bot.  If we made a mistake, please contact us describing that you have been falsely detected as a bot, and we will aid you in creating your wiki: [http://www.wikia.com/Special:Contact/general Contact Us]',
	'cnw-error-bot-header' => 'You have been detected as a bot',
	'cnw-error-unconfirmed-email-header' => 'Your e-mail has not been confirmed',
	'cnw-error-unconfirmed-email' => 'Your e-mail should be confirmed to create a Wiki.',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Shirayuki
 * @author Siebrand
 * @author Wyz
 */
$messages['qqq'] = array(
	'cnw-next' => 'Text for "Next" Button.
{{Identical|Next}}',
	'cnw-back' => 'Text for "Back" Button
{{Identical|Back}}',
	'cnw-or' => 'Division for login or Facebook login.
{{Identical|Or}}',
	'cnw-title' => 'General Title for this feature',
	'cnw-name-wiki-headline' => 'H1 for this step',
	'cnw-name-wiki-creative' => 'Creative or instruction for this step following H1',
	'cnw-name-wiki-label' => 'Label for wiki name field',
	'cnw-name-wiki-domain-label' => 'Label for wiki domain field',
	'cnw-name-wiki-submit-error' => 'Error message to display when the there are errors in the fields',
	'cnw-login' => 'Text for "Log In" Button',
	'cnw-signup' => 'Text for "Create account" Button.
{{Identical|Create account}}',
	'cnw-signup-prompt' => 'ask if user needs to create an account',
	'cnw-call-to-signup' => 'Call to action to create an account (clickable link)',
	'cnw-login-prompt' => 'ask if user already has a login',
	'cnw-call-to-login' => 'Call to action to login (clickable link)',
	'cnw-auth-headline' => 'H1 for this step',
	'cnw-auth-headline2' => '{{Identical|Sign up}}',
	'cnw-auth-creative' => 'Creative or instruction for this step following H1 for login',
	'cnw-auth-signup-creative' => 'Creative or instruction for this step following H1 for signup',
	'cnw-auth-facebook-signup' => '"Sign up with Facebook" Button',
	'cnw-auth-facebook-login' => '"Login with Facebook" Button',
	'cnw-userauth-headline' => 'Heading for user login/signup box at the top',
	'cnw-userauth-creative' => 'Sublabel that says "log in".
{{Identical|Log in}}',
	'cnw-userauth-marketing-heading' => 'Heading to create an account in form of a question on the right side of the box.
{{Identical|Do not have an account}}',
	'cnw-userauth-marketing-body' => 'Marketing blurb with link to user signup on the right side.  Please append uselang=es(or other lang) on the link.',
	'cnw-userauth-signup-button' => 'Label for sign up button on the right side.
{{Identical|Sign up}}',
	'cnw-desc-headline' => 'H1 for this step',
	'cnw-desc-creative' => 'Creative or instruction for this step following H1',
	'cnw-desc-placeholder' => 'Placeholder for the textarea',
	'cnw-desc-tip1' => 'First Tip label.
{{Identical|Hint}}',
	'cnw-desc-tip1-creative' => 'The first tip<br />
Be careful to keep it short as there are 2 successive balloon tips to display in a small space',
	'cnw-desc-tip2' => 'Second Tip label',
	'cnw-desc-tip2-creative' => 'The second tip<br />
Be careful to keep it short as there are 2 successive balloon tips to display in a small space',
	'cnw-desc-select-vertical' => 'Label for selecting Hub Category',
	'cnw-desc-select-categories' => 'Label for selecting Additional Categories',
	'cnw-desc-select-one' => 'Default empty label for category.
{{Identical|Select one}}',
	'cnw-desc-all-ages' => "Label for checkbox defining wiki as directed to all ages. It's imposed by US law regulations [[Wikipedia:Children's_Online_Privacy_Protection_Act]].",
	'cnw-desc-tip-all-ages' => 'Detailed description of checkbox defining wiki as directed to all ages. Extension of message cnw-desc-all-ages.',
	'cnw-desc-default-lang' => 'Letting user know which language this wiki will be in.  $1 will be wiki language',
	'cnw-desc-change-lang' => 'Call to action to change the language.
{{Identical|Change}}',
	'cnw-desc-lang' => 'Label for language.
{{Identical|Language}}',
	'cnw-desc-wiki-submit-error' => 'General error message for not selecting category',
	'cnw-theme-headline' => 'H1 for this step',
	'cnw-theme-creative' => 'Creative or instruction for this step following H1',
	'cnw-theme-instruction' => 'Details on how Toolbar can be used as an alternative later',
	'cnw-welcome-headline' => 'Headliner for modal. $1 is wikiname',
	'cnw-welcome-instruction1' => 'First line of instruction to add a page',
	'cnw-welcome-help' => 'Message to Community central with embedded anchor. (leave blank if community does not exist)',
	'cnw-error-general' => 'Generic error message to alert users that something went wrong while creating wiki',
	'cnw-error-general-heading' => 'Heading for generic error in modal dialog',
	'cnw-error-blocked' => 'Parameters:
* $1 is a username
* $2 is a block reason
* $3 is a block ID',
	'cnw-error-anon-user-header' => 'Header for error dialog, displayed when when anon user tries to create new wiki.
{{Identical|Please log in}}',
	'cnw-error-anon-user' => 'Error message when anon user tries to create new wiki.',
	'cnw-error-bot' => 'Message describing you may be a bot and link to contact page',
	'cnw-error-bot-header' => 'Message header for modal box',
	'cnw-error-unconfirmed-email-header' => 'Message header for modal box',
	'cnw-error-unconfirmed-email' => 'Message describing your e-mail has not been confirmed yet therefore you cannot process with Wiki creation',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'cnw-next' => 'Volgende',
	'cnw-back' => 'Vorige',
	'cnw-or' => 'of',
	'cnw-title' => "Skep 'n nuwe wiki",
	'cnw-name-wiki-headline' => "Begin 'n Wiki",
	'cnw-signup' => 'Skep gebruiker',
	'cnw-auth-facebook-login' => 'Teken aan met Facebook',
	'cnw-desc-headline' => 'Waaroor gaan u wiki?',
	'cnw-desc-creative' => 'Beskryf u onderwerp',
	'cnw-desc-tip1' => 'Wenk',
	'cnw-desc-tip2' => 'Pst!',
	'cnw-desc-select-one' => 'Kies een',
	'cnw-desc-default-lang' => 'Die hooftaal van u wiki is: $1',
	'cnw-desc-change-lang' => 'wysig',
	'cnw-desc-lang' => 'Taal',
	'cnw-desc-wiki-submit-error' => "Kies 'n kategorie",
	'cnw-theme-headline' => 'Ontwerp u wiki',
	'cnw-badword-header' => 'Pas op!',
);

/** Aragonese (aragonés)
 * @author Willtron
 */
$messages['an'] = array(
	'cnw-call-to-signup' => 'Rechistra-te aquí',
	'cnw-userauth-marketing-heading' => 'No tiene garra cuenta?',
);

/** Arabic (العربية)
 * @author Achraf94
 * @author Claw eg
 * @author Gagnabil
 * @author Khaled
 * @author Kuwaity26
 * @author Meno25
 * @author OsamaK
 * @author ترجمان05
 * @author زكريا
 */
$messages['ar'] = array(
	'createnewwiki-desc' => 'صانع الويكيات',
	'cnw-next' => 'التالي',
	'cnw-back' => 'رجوع',
	'cnw-or' => 'أو',
	'cnw-title' => 'إنشاء ويكي جديدة',
	'cnw-name-wiki-headline' => 'بدء ويكي',
	'cnw-name-wiki-creative' => 'ويكيا هو أفضل مكان لبناء موقع على شبكة الإنترنت وتنمية مجتمع حول ما تحب.',
	'cnw-name-wiki-label' => 'اختر اسما للويكي',
	'cnw-name-wiki-domain-label' => 'اختر عنوان للويكي',
	'cnw-name-wiki-submit-error' => 'عفوا! أنت بحاجة لملء كلا من المربعين أعلاه للمواصلة.',
	'cnw-login' => 'تسجيل الدخول',
	'cnw-signup' => 'أنشئ حسابا',
	'cnw-signup-prompt' => 'تحتاج إلى حساب؟',
	'cnw-call-to-signup' => 'قم بالتسجيل هنا',
	'cnw-login-prompt' => 'لديك حساب؟',
	'cnw-call-to-login' => 'لج هنا',
	'cnw-auth-headline' => 'تسجيل الدخول',
	'cnw-auth-headline2' => 'أنشئ حسابًا',
	'cnw-auth-creative' => 'سجل الدخول إلى الحساب الخاص بك لمواصلة بناء الويكي.',
	'cnw-auth-signup-creative' => 'تحتاج إلى حساب لمواصلة بناء الويكي.<br />التسجيل لن يستغرق سوى دقيقة واحدة!',
	'cnw-auth-facebook-signup' => 'قم بالإشتراك عن طريق الفايسبوك',
	'cnw-auth-facebook-login' => 'زر "تسجيل الدخول عبر فيس بوك"',
	'cnw-userauth-headline' => 'لديك حساب؟',
	'cnw-userauth-creative' => 'تسجيل الدخول',
	'cnw-userauth-marketing-heading' => 'ليس لديك حساب؟',
	'cnw-userauth-marketing-body' => 'أنت بحاجة إلى حساب لإنشاء ويكي على ويكيا. التسجيل يستغرق سوى دقيقة!',
	'cnw-userauth-signup-button' => 'التسجيل',
	'cnw-desc-headline' => 'ماهو موضوع الويكيا؟',
	'cnw-desc-creative' => 'يساعد الوصف الناس لكي يجدوا الويكي الخاصة بك',
	'cnw-desc-placeholder' => 'سوف يظهر هذا عل الصفحة الرئيسية في الويكي',
	'cnw-desc-tip1' => 'نصيحة',
	'cnw-desc-tip1-creative' => 'استخدم هذه المساحة لتقول للناس حول الويكيا الخاصة بك في جملة أو اثنين',
	'cnw-desc-tip2' => 'ملاحظة',
	'cnw-desc-tip2-creative' => 'قم بإعطاء الزوار بعض التفاصيل حول موضوع هذه الويكي',
	'cnw-desc-select-vertical' => 'اختر المحور',
	'cnw-desc-select-categories' => 'أختر تصنيفات اضافية',
	'cnw-desc-select-one' => 'إختر واحدة',
	'cnw-desc-all-ages' => 'هل هذه الويكيا مجعولة من أجل الأطفال؟',
	'cnw-desc-tip-all-ages' => 'هل هذه الويكيا عن موضوع للأطفال؟ لأجل مساعدتنا للامتثال للقانون الأمريكي، نستمر بمتابعة الويكيات التي تناسب مواضيعها مباشرة الأطفال بسن 12 أو أقل.',
	'cnw-desc-default-lang' => 'سوف تكون هذه الويكي باللغة $1',
	'cnw-desc-change-lang' => 'تغيير',
	'cnw-desc-lang' => 'اللغة',
	'cnw-desc-wiki-submit-error' => 'الرجاء اختيار فئة',
	'cnw-theme-headline' => 'إختيار المظهر',
	'cnw-theme-creative' => 'اختر أحد المظاهر أدناه، سوف تتمكن من رؤية معاينة حول كل مظهر لكي تختاره',
	'cnw-theme-instruction' => 'يمكنك أيضا تصميم مظهر خاص بك في وقت لاحق عن طريق "أدواتي".',
	'cnw-welcome-headline' => 'تهانينا! لقد تم إنشاء $1',
	'cnw-welcome-instruction1' => 'انقر الزر أدناه لبدء إضافة صفحات في الويكي الخاص بك.',
	'cnw-welcome-help' => 'إبحث عن إجابات و نصائح و معلومات أكثر في  <a href="http://ar.wikia.com"> مركز ويكيا</a>.',
	'cnw-error-general' => 'عفوا! حدث خطأ من جهتنا! الرجاء المحاولة مرة أخرى أو [[Special:Contact|الاتصال بنا]] للحصول على المساعدة.',
	'cnw-error-general-heading' => 'نحن نعتذر',
	'cnw-badword-header' => 'قف هناك',
	'cnw-badword-msg' => 'مرحبا، يرجى عدم استعمال الكلمات السيئة والعبارات المحظورة هذه في وصف الويكي: $1',
	'cnw-error-wiki-limit-header' => 'لقد وصلت للحد الأعلى للويكي',
	'cnw-error-wiki-limit' => 'مرحبا، ليس بإمكانك إلا {{PLURAL:$1|إنشاء ويكي $1|إنشاء $1 ويكي}} في اليوم الواحد. انتظر لمدة ٢٤ ساعة قبل إنشاء ويكي آخر.',
	'cnw-error-blocked-header' => 'الحساب محظور',
	'cnw-error-blocked' => 'لقد تم حظرك من قبل $1. السبب الذي قدم هو: $2. (رقم الحظر المرجعي: $3)',
	'cnw-error-anon-user-header' => 'من فضلك سجل الدخول',
	'cnw-error-anon-user' => 'إنشاء الويكي للمجهولين معطل. من فضلط [[Special:UserLogin|سجل الدخول]] وحاول مجددًا.',
	'cnw-error-torblock' => 'إنشاء الويكي عن طريق شبكة تور غير مسموح.',
	'cnw-error-bot' => 'لقد اكتشفنا بأنك بوت. إذا ارتكبنا خطأ الرجاء الاتصال بنا لإعلامنا بأنه تم رصدك كبوت بالخطأ، و سوف نساعدك في إنشاء الويكي: [http://www.wikia.com/Special:Contact/general إتصل بنا]',
	'cnw-error-bot-header' => 'لقد تم رصدك بأنك بوت (مستخدم أوتوماتيكي)',
	'cnw-error-unconfirmed-email-header' => 'لم يتم تأكيد البريد الإلكتروني الخاص بك',
	'cnw-error-unconfirmed-email' => 'ينبغي تأكيد البريد الإلكتروني الخاص بك لإنشاء ويكي.',
);

/** Kotava (Kotava)
 * @author Wikimistusik
 */
$messages['avk'] = array(
	'createnewwiki-desc' => 'Tcicesiki va redura va wiki',
	'cnw-next' => 'Radim-',
	'cnw-back' => 'Dim-',
	'cnw-or' => 'ok',
	'cnw-title' => 'Redura va warzafi wiki',
	'cnw-name-wiki-headline' => 'Bokara va wiki',
	'cnw-name-wiki-creative' => 'Wikia tir telo xonyo ta kolnara va internetxo is laumara ke doda aname rinaf albaks.',
	'cnw-name-wiki-label' => 'Yoltara va bati wiki',
	'cnw-name-wiki-domain-label' => 'Bazera va mane tori bati wiki',
	'cnw-login' => 'Dogluyara',
	'cnw-signup' => 'Pataredura',
	'cnw-signup-prompt' => 'Va pata olegal ?',
	'cnw-call-to-signup' => 'Batliz pilkomodara',
	'cnw-login-prompt' => 'Kas va pata ixam digil ?',
	'cnw-call-to-login' => 'Batliz dogluyara',
	'cnw-auth-headline' => 'Dogluyara',
	'cnw-auth-headline2' => 'Dogluyara',
	'cnw-auth-creative' => 'Va int dogluyal enide va bati wiki wan kolnal',
	'cnw-auth-signup-creative' => 'Enide va bati wiki wan kolnal, pata tir adrafa.<br /> Taon nemon tanoya wexa !',
	'cnw-auth-facebook-signup' => 'Kan Facebook dogluyara',
	'cnw-auth-facebook-login' => 'Kan Facebook dogluyara',
	'cnw-userauth-headline' => 'Kas va pata digil ?',
	'cnw-userauth-creative' => 'Dogluyara',
	'cnw-userauth-marketing-heading' => 'Kas va pata me digil ?',
	'cnw-userauth-marketing-body' => 'Enide va redura va wiki dene Wikia, pata tir adrafa. Ta dogluyara nemon tanoya wexa !',
	'cnw-userauth-signup-button' => 'Dogluyara',
	'cnw-desc-headline' => 'Toka watsa ke bati wiki tir ?',
	'cnw-desc-creative' => 'Va bate detce pimtal',
	'cnw-desc-placeholder' => 'Batcoba moe emudexo ke wiki awitir.',
	'cnw-desc-tip1' => 'Palsera',
	'cnw-desc-tip2' => 'Psst',
	'cnw-desc-tip2-creative' => 'Va yona aptolafa pinta pu worasik icde rinafa watsa bilder',
	'cnw-desc-select-one' => 'Va tanoy rebal',
	'cnw-desc-default-lang' => 'Bati wiki dene $1 tigitir',
	'cnw-desc-change-lang' => 'betara',
	'cnw-desc-lang' => 'Ava',
	'cnw-desc-wiki-submit-error' => 'Va loma vay kiblal',
	'cnw-theme-headline' => 'Kiblara va watsa',
	'cnw-welcome-headline' => 'Sendara ! $1 su zo redur',
	'cnw-welcome-instruction1' => 'Ta loplekura va bu den bati wiki va vlevefo uzadjo vulegal.',
	'cnw-error-general' => 'Rotaca sokiyir bak redura va wiki. Vay fure gire laredul.',
	'cnw-error-general-heading' => 'Rokla va redura va warzafi wiki',
	'cnw-badword-header' => '"Whoa" batlize',
	'cnw-error-wiki-limit-header' => 'Kima ke wiki zomena',
	'cnw-error-wiki-limit' => 'Vieleafa kimara tir {{PLURAL:$1|$1 ta redura va wiki|$1 ta redura va wiki}}. Va tanoy viel abdi redura va ari wiki kel.',
	'cnw-error-blocked-header' => 'Pata elekana',
	'cnw-error-blocked' => 'Gan $1 su zo elekal. Bazena lazava tiyir : $2. (Block ID vas vuestesiki : $3)',
	'cnw-error-torblock' => 'Redura va wiki kan "Tor Network" zo zuker.',
	'cnw-error-bot-header' => 'Wetce stiernik su zo karavotal',
);

/** Azerbaijani (azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'cnw-next' => 'Növbəti',
	'cnw-back' => 'Əvvəlki',
	'cnw-or' => 'və ya',
	'cnw-login' => 'Daxil ol',
	'cnw-auth-headline' => 'Daxil ol',
	'cnw-desc-lang' => 'Dil',
);

/** South Azerbaijani (تۆرکجه)
 * @author Koroğlu
 */
$messages['azb'] = array(
	'cnw-next' => 'سونراکی',
	'cnw-back' => 'دالی',
	'cnw-or' => 'یا دا',
	'cnw-title' => 'یئنی ویکی یارات',
	'cnw-name-wiki-headline' => 'یئنی بیر ویکی باشلات',
	'cnw-name-wiki-label' => 'ویکینیزین آدی',
	'cnw-name-wiki-domain-label' => 'ویکینیزی بیر آدرس سئچینیز',
	'cnw-login' => 'گیر',
	'cnw-signup' => 'حساب یارات',
	'cnw-signup-prompt' => 'بیر حسابا احتیاجینیز وارمی؟',
	'cnw-call-to-signup' => 'بورادان آد یازدیر',
	'cnw-login-prompt' => 'اؤنجه‌دن حسابینیز وارمی؟',
	'cnw-call-to-login' => 'بورادان گیرینیز',
	'cnw-auth-headline' => 'گیر',
	'cnw-auth-headline2' => 'آد یازدیر',
	'cnw-userauth-headline' => 'حسابینیز وارمی؟',
	'cnw-userauth-creative' => 'گیریش',
	'cnw-userauth-marketing-heading' => 'حسابینیز یوخ‌دورمو؟',
	'cnw-userauth-signup-button' => 'آد یازدیر',
	'cnw-desc-tip1' => 'قیلاووز',
	'cnw-desc-select-one' => 'بیرینی سئچ',
	'cnw-desc-change-lang' => 'دَییشیک',
	'cnw-desc-lang' => 'دیل',
);

/** Bavarian (Boarisch)
 * @author Mucalexx
 */
$messages['bar'] = array(
	'createnewwiki-desc' => 'Assistent zan Dastejn vahram Wiki',
	'cnw-next' => 'Naxde',
	'cnw-back' => 'Zruck',
	'cnw-or' => 'óder',
	'cnw-title' => 'Neichs Wiki erstejn',
	'cnw-name-wiki-headline' => 'A Wiki starten',
	'cnw-name-wiki-creative' => 'Wikia is da béste Ort, um rund um deih Liablingsthéma a Webseiten afzbaun und a Gmoahschoft woxen zan lossen.',
	'cnw-name-wiki-label' => 'Gib an Wiki an Naum',
	'cnw-name-wiki-domain-label' => 'Gib deim Wiki a Adress',
);

/** Bulgarian (български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'createnewwiki-desc' => 'Съветник за създаване на уики',
	'cnw-next' => 'Продължаване',
	'cnw-back' => 'Връщане',
	'cnw-or' => 'или',
	'cnw-title' => 'Създаване на ново уики',
	'cnw-name-wiki-headline' => 'Създаване на уики',
	'cnw-name-wiki-creative' => 'Уикия е най-доброто място за изграждане на уебсайт и изграждане на общност около темите, които ви вълнуват.',
	'cnw-name-wiki-label' => 'Изберете име на уикито',
	'cnw-name-wiki-domain-label' => 'Изберете адрес на уикито',
	'cnw-name-wiki-submit-error' => 'Опа! За да продължите напред е необходимо и двете полета по-горе да бъдат попълнени.',
	'cnw-login' => 'Влизане',
	'cnw-signup' => 'Създаване на сметка',
	'cnw-signup-prompt' => 'Имате нужда от сметка?',
	'cnw-call-to-signup' => 'Можете да се регистрирате тук',
	'cnw-login-prompt' => 'Вече имате сметка?',
	'cnw-call-to-login' => 'Можете да влезете оттук',
	'cnw-auth-headline' => 'Влизане',
	'cnw-auth-headline2' => 'Регистриране',
	'cnw-auth-creative' => 'Влезте в сметката си, за да продължите да създавате вашето уики.',
	'cnw-auth-signup-creative' => 'Необходима е сметка, за да продължите да създавате вашето уики.<br />Регистрацията отнема по-малко от минута!',
	'cnw-auth-facebook-signup' => 'Регистриране чрез Facebook',
	'cnw-auth-facebook-login' => 'Влизане с Facebook',
	'cnw-userauth-headline' => 'Имате сметка?',
	'cnw-userauth-creative' => 'Влизане',
	'cnw-userauth-marketing-heading' => 'Нямате сметка?',
	'cnw-userauth-signup-button' => 'Регистриране',
	'cnw-desc-headline' => 'За какво е вашето уики?',
	'cnw-desc-creative' => 'Опишете темата',
	'cnw-desc-placeholder' => 'Съдържанието от тази кутия ще бъде публикувано на началната страница на вашето уики.',
	'cnw-desc-tip1' => 'Съвет',
	'cnw-desc-tip1-creative' => 'Използвайте това пространство, за да разкажете и опишете с едно-две изречение вашето уики пред потребителите',
	'cnw-desc-tip2' => 'Псст',
	'cnw-desc-select-one' => 'Избиране',
	'cnw-desc-all-ages' => 'Всички възрасти',
	'cnw-desc-default-lang' => 'Вашето уики ще бъде на $1',
	'cnw-desc-change-lang' => 'промяна',
	'cnw-desc-lang' => 'Език',
	'cnw-desc-wiki-submit-error' => 'Необходимо е да бъде избрана категория',
	'cnw-theme-headline' => 'Избиране на тема',
	'cnw-theme-creative' => 'Изберете тема от списъка по-долу; можете да видите предварителен преглед на всяка тема, като я изберете.',
	'cnw-theme-instruction' => 'Също така можете да направите своя тема по-късно като отидете в „Моите инструменти“.',
	'cnw-welcome-headline' => 'Поздравления! Уикито $1 беше създадено',
	'cnw-welcome-instruction1' => 'Щракнете върху бутона по-долу, за да започнете да добавяте страници към вашето уики.',
	'cnw-welcome-help' => 'Можете да откриете отговори, съвети и други полезни неща в <a href="http://community.wikia.com">Централната общност</a>.',
	'cnw-error-blocked-header' => 'Сметката е блокирана',
	'cnw-error-blocked' => 'Потребителската ви сметка е била блокирана от $1. Причината за блокирането, която е посочена, е: $2. (Номер на блокирането, за референции: $3)',
	'cnw-error-torblock' => 'Създаването на укита чрез Tor мрежа не е позволено.',
);

/** Western Balochi (بلوچی رخشانی)
 * @author Baloch Afghanistan
 */
$messages['bgn'] = array(
	'cnw-next' => 'دیگرین',
	'cnw-back' => 'بیئرگشت',
	'cnw-or' => 'یا',
	'cnw-name-wiki-headline' => 'یک ویکی ئی شرو کورتین',
	'cnw-name-wiki-label' => 'شمی ویکی ئی نام',
	'cnw-signup' => 'کار زوروکین حسابئ جوڑ کورتین',
	'cnw-userauth-creative' => 'داخل بوتین',
	'cnw-userauth-marketing-heading' => 'شما کار زوروکین حسابئ نداریت؟',
	'cnw-desc-headline' => 'شمی ویکی بئ چه موریدا اینت؟',
	'cnw-desc-lang' => 'زبان',
);

/** Breton (brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Gwenn-Ael
 * @author Y-M D
 */
$messages['br'] = array(
	'createnewwiki-desc' => 'Skoazeller evit krouiñ wikioù',
	'cnw-next' => "War-lerc'h",
	'cnw-back' => 'Distreiñ',
	'cnw-or' => 'pe',
	'cnw-title' => 'Krouiñ ur wiki nevez',
	'cnw-name-wiki-headline' => 'Kregiñ gant ur wiki',
	'cnw-name-wiki-creative' => "Wikia eo al lec'h gwellañ evit sevel ul lec'hienn wiki ha lakaat ur gumuniezh da greskiñ en-dro d'ar pezh a garit.",
	'cnw-name-wiki-label' => "Roit un anv d'ho wiki",
	'cnw-name-wiki-domain-label' => "Roit ur chomlec'h d'ho wiki",
	'cnw-name-wiki-submit-error' => "Hopala ! Bezit sur eo bet leuniet mat an div vaezienn a-us evit gallout kenderc'hel.",
	'cnw-login' => 'Kevreañ',
	'cnw-signup' => 'Krouiñ ur gont',
	'cnw-signup-prompt' => "Ezhomm hoc'h eus ur gont ?",
	'cnw-call-to-signup' => 'Sinit amañ',
	'cnw-login-prompt' => "Ur gont hoc'h eus dija ?",
	'cnw-call-to-login' => 'Kevreit amañ',
	'cnw-auth-headline' => 'Kevreañ',
	'cnw-auth-headline2' => 'En em enskrivañ',
	'cnw-auth-creative' => "Kevreit ouzh ho kont evit kenderc'hel da sevel ho wiki.",
	'cnw-auth-signup-creative' => "Ezhomm ho po eus ur gont evit kenderc'hel da sevel ur wiki.<br />Ne bado nemet ur vunutenn evit bezañ enskrivet !",
	'cnw-auth-facebook-signup' => 'En em enskrivañ dre Facebook',
	'cnw-auth-facebook-login' => 'Kevreañ gant Facebook',
	'cnw-userauth-headline' => "Hag ur gont hoc'h eus krouet ?",
	'cnw-userauth-creative' => 'Kevreañ',
	'cnw-userauth-marketing-heading' => "N'hoc'h eus kont ebet ?",
	'cnw-userauth-marketing-body' => "Ezhomm ho peus ur gont evit krouiñ a wiki war Wikia. Trawalc'h zo gant ur vunutenn evit lakaat e anv !",
	'cnw-userauth-signup-button' => 'En em enskrivañ',
	'cnw-desc-headline' => 'Eus petra zo kaoz en ho wiki ?',
	'cnw-desc-creative' => 'Gant ho teskrivadur e vo skoazellet an dud da gavout ho wikia',
	'cnw-desc-placeholder' => 'Dont a ray war wel war bajenn bennañ ho wiki.',
	'cnw-desc-tip1' => 'Tun',
	'cnw-desc-tip1-creative' => "Implijit ar c'horn-mañ da zisplegañ d'an dud krak-ha-berr eus petra zo kaoz en ho wikia",
	'cnw-desc-tip2' => 'Kuzul 2',
	'cnw-desc-tip2-creative' => 'Merkit un nebeud displegadurioù war an danvez evit ar weladennerien',
	'cnw-desc-select-vertical' => 'Dibab un tem',
	'cnw-desc-select-categories' => 'Dibab ar rummadoù ouzhpenn',
	'cnw-desc-select-one' => 'Diuzañ unan',
	'cnw-desc-all-ages' => 'Hag evit ar vugale eo ar wikia-mañ ?',
	'cnw-desc-tip-all-ages' => "Daoust hag-eñ ez eo un danvez hag a c'hallfe dedennañ ar vugale ? Evit sikour ac'hanomp da zoujañ da lezennoù ar Stadoù-Unanet e viromp roudoù eus ar wikiaoù zo enno danvezioù savet war-eeun evit ar vugale 12 vloaz ha nebeutoc'h.",
	'cnw-desc-default-lang' => 'E $1 e vo ho wiki',
	'cnw-desc-change-lang' => 'kemmañ',
	'cnw-desc-lang' => 'Yezh',
	'cnw-desc-wiki-submit-error' => 'Dibabit ur rummad, mar plij',
	'cnw-theme-headline' => 'Krouit ho wiki',
	'cnw-theme-creative' => "Dibabit un dodenn amañ dindan, gellout a reoc'h rakwelet pep dodenn en ur ziuzañ anezhi.",
	'cnw-theme-instruction' => 'Gellout a rit ivez krouiñ ho todenn hiniennel un tamm diwezhatoc\'h en ur vont e "Ma ostilhoù".',
	'cnw-welcome-headline' => "Gourc'hemennoù, krouet hoc'h eus $1",
	'cnw-welcome-instruction1' => "Klikit war ar bouton amañ dindan evit kregiñ da ouzhpennañ pajennoù d'ho wiki.",
	'cnw-welcome-help' => 'Kavout a reot respontoù, kuzulioù ha kement zo war <a href="http://community.wikia.com">Kalonenn ar gumuniezh</a>.',
	'cnw-error-general' => 'Un dra bennak a zo aet a-dreuz eus hon tu ! Esaeit en-dro, mar plij pe [[Special:Contact|deuit e darempred ganimp]] evit bezañ sikouret.',
	'cnw-error-general-heading' => "Digarezit ac'hanomp",
	'cnw-badword-header' => "Oc'ho",
	'cnw-badword-msg' => "Ac'hanta, mar plij chomit hep implijout gerioù vil pe difennet e deskrivadur ho wiki : $1",
	'cnw-error-wiki-limit-header' => 'Bevenn ar wikioù bet tizhet',
	'cnw-error-wiki-limit' => "Ac'hanta, bevennet eo ar c'hrouiñ wikioù da $1 wiki dre zen ha dre zevezh. Gortozit 24 eurvezh a-benn gellout krouiñ unan all.",
	'cnw-error-blocked-header' => 'Kont stanket',
	'cnw-error-anon-user-header' => 'Kevreit mar plij',
	'cnw-error-torblock' => "N'eo ket aotreet krouiñ wikioù dre ar rouedad Tor.",
	'cnw-error-bot-header' => "Kavet hon eus ez oc'h ur robot",
	'cnw-error-unconfirmed-email-header' => "N'eo ket bet kadarnaet ho postel",
	'cnw-error-unconfirmed-email' => "Ret eo d'ho postel bezañ kadarnaet evit krouiñ ur Wiki.",
);

/** Iriga Bicolano (Iriga Bicolano)
 * @author Filipinayzd
 */
$messages['bto'] = array(
	'cnw-or' => 'o',
	'cnw-title' => 'Gumibo sa Bagong Wiki',
	'cnw-login' => 'Lumoog',
	'cnw-signup' => 'Gumibo sa Account',
	'cnw-auth-headline' => 'Lumoog',
	'cnw-userauth-marketing-heading' => 'Uda sa account?',
	'cnw-desc-all-ages' => 'Ngamin na edad',
);

/** Catalan (català)
 * @author Fitoschido
 * @author Marcmpujol
 * @author Roxas Nobody 15
 * @author Unapersona
 */
$messages['ca'] = array(
	'createnewwiki-desc' => 'Assistent de creació de wikis',
	'cnw-next' => 'Següent',
	'cnw-back' => 'Enrere',
	'cnw-or' => 'o',
	'cnw-title' => 'Crear un nou wiki',
	'cnw-name-wiki-headline' => 'Començar un Wiki',
	'cnw-name-wiki-creative' => "Wikia és el millor lloc per construir un lloc web i fer créixer una comunitat al voltant del que t'agrada.",
	'cnw-name-wiki-label' => 'Nom del teu wiki',
	'cnw-name-wiki-domain-label' => 'Dóna el teu wiki una adreça',
	'cnw-name-wiki-submit-error' => 'Ui! Cal omplir totes les caselles anteriors per poder seguir.',
	'cnw-login' => 'Inicia la sessió',
	'cnw-signup' => 'Crear un compte',
	'cnw-signup-prompt' => 'Necessites un compte?',
	'cnw-call-to-signup' => "Registra't aquí",
	'cnw-login-prompt' => 'Ja tens un compte?',
	'cnw-call-to-login' => 'Inicia la sessió aquí',
	'cnw-auth-headline' => 'Inicia la sessió',
	'cnw-auth-headline2' => "Registra't",
	'cnw-auth-creative' => 'Inicia la sessió en el teu compte per continuar la construcció del teu wiki.',
	'cnw-auth-signup-creative' => 'Necessitaràs un compte per continuar construint del teu wiki.<br />Només trigaràs un minut a registrar-te!',
	'cnw-auth-facebook-signup' => "Registra't amb Facebook",
	'cnw-auth-facebook-login' => 'Inicia la sessió amb Facebook',
	'cnw-userauth-headline' => 'Tens un compte?',
	'cnw-userauth-creative' => 'Inicia la sessió',
	'cnw-userauth-marketing-heading' => 'No tens un compte?',
	'cnw-userauth-marketing-body' => 'Necessites un compte per crear un wiki a Wikia. Només trigaràs un minut a registrar-te!',
	'cnw-userauth-signup-button' => "Registra't",
	'cnw-desc-headline' => 'De què tracta la teva wikia?',
	'cnw-desc-creative' => 'La teva descripció ajudarà a la gent a troba el teu wiki',
	'cnw-desc-placeholder' => 'Això apareixerà a la pàgina principal del teu wiki.',
	'cnw-desc-tip1' => 'Suggerència',
	'cnw-desc-tip1-creative' => 'Utilitza aquest espai per dir a la gent coses sobre el teu wiki en un parell de frases',
	'cnw-desc-tip2' => 'Suggerència 2',
	'cnw-desc-tip2-creative' => 'Dóna als teus visitants alguns detalls específics sobre el tema',
	'cnw-desc-select-vertical' => 'Seleccioneu un Hub',
	'cnw-desc-select-categories' => 'Seleccioneu categories addicionals',
	'cnw-desc-select-one' => 'Selecciona una',
	'cnw-desc-all-ages' => 'Aquest wikia està pensat per a nens?',
	'cnw-desc-tip-all-ages' => "Aquest wikia és sobre un tema d'interés pels nens? Per ajudar-nos a complir la llei dels Estats Units tenim un seguiment als wikis amb temes que afecten directament al nens de 12 o menys anys",
	'cnw-desc-default-lang' => 'El teu wiki serà en $1',
	'cnw-desc-change-lang' => 'canviar',
	'cnw-desc-lang' => 'Llengua',
	'cnw-desc-wiki-submit-error' => 'Trieu una categoria',
	'cnw-theme-headline' => 'Tria un tema',
	'cnw-theme-creative' => "Tria un tema que s'ajusti al teu wiki.",
	'cnw-theme-instruction' => 'Pots canviar el tema o dissenyar el teu propi en qualsevol moment utilitzant "Les meves Eines" situat en la barra d\'eines en la part inferior de la pàgina.',
	'cnw-welcome-headline' => 'Felicitats! Has creat $1',
	'cnw-welcome-instruction1' => 'Fes clic al botó de sota per començar a afegir pàgines al teu wiki.',
	'cnw-welcome-help' => 'Troba respostes, assessorament i més informació a <a href="http://ca.wikia.com">Comunitat Central</a>.',
	'cnw-error-general' => 'Ui! Alguna cosa ha sortit malament al nostre sistema!  Si us plau, torna-ho a provar un altre cop o [[Special:Contact|contacta amb nosaltres]] per obtenir ajuda.',
	'cnw-error-general-heading' => 'Les nostres disculpes',
	'cnw-badword-header' => 'Ui!',
	'cnw-badword-msg' => "Hola, si us plau, absten-te d'utilitzar aquestes paraules malsonants o paraules prohibides en la descripció del teu wiki: $1",
	'cnw-error-wiki-limit-header' => 'Has assolit el límit de wikis',
	'cnw-error-wiki-limit' => 'Hola, estàs limitat a {{PLURAL:$1|$1 creació|$1 creacions}} de wikis per dia. Espera 24 hores abans de crear un altre wiki.',
	'cnw-error-blocked-header' => 'Compte bloquejat',
	'cnw-error-blocked' => 'Has estat bloquejat per $1. La raó donada era: $2. (Identificador del bloqueig par a referència: $3)',
	'cnw-error-anon-user-header' => 'Entreu',
	'cnw-error-anon-user' => 'Els anònims no poden crear wikis. Si us plau, [[Special:UserLogin|entra a la sessió]] i intenta-ho de nou.',
	'cnw-error-torblock' => 'No està permès crear wikis mitjançant la xarxa Tor.',
	'cnw-error-bot' => "Hem detectat que pots ser un bot. Si hem comès un error, si us plau, contacta amb nosaltres i descriu que has estat falsament detectat com si fossis un bot, i t'ajudarem en la creació del teu wiki: [http://www.wikia.com/Special:Contact/general Contacta amb nosaltres]",
	'cnw-error-bot-header' => 'Has estat detectat com a un bot',
	'cnw-error-unconfirmed-email-header' => "El teu correu electrònic no s'ha confirmat",
	'cnw-error-unconfirmed-email' => 'Has de confirmar el teu correu electrònic per crear un wiki.',
);

/** Chechen (нохчийн)
 * @author Умар
 */
$messages['ce'] = array(
	'cnw-next' => 'Кхин дӀа',
	'cnw-desc-lang' => 'Мотт',
);

/** Czech (čeština)
 * @author Aktron
 * @author Chmee2
 * @author H4nek
 * @author Jezevec
 * @author Reaperman
 */
$messages['cs'] = array(
	'createnewwiki-desc' => 'Průvodce vytvořením wiki',
	'cnw-next' => 'Další',
	'cnw-back' => 'Zpět',
	'cnw-or' => 'nebo',
	'cnw-title' => 'Vytvořit novou Wiki',
	'cnw-name-wiki-headline' => 'Vytvořit Wiki',
	'cnw-name-wiki-creative' => 'Wikia je nejvhodnějším místem pro vytvoření takové webové stránky, kterou bude spravovat milující komunita.',
	'cnw-name-wiki-label' => 'Název vaší wiki',
	'cnw-name-wiki-domain-label' => 'Dejte vaší wiki adresu',
	'cnw-name-wiki-submit-error' => 'Hups! K pokračování musíte vyplnit obě políčka výše.',
	'cnw-login' => 'Přihlásit se',
	'cnw-signup' => 'Vytvořit účet',
	'cnw-signup-prompt' => 'Potřebujete účet?',
	'cnw-call-to-signup' => 'Zaregistrujte se zde',
	'cnw-login-prompt' => 'Máte již účet?',
	'cnw-call-to-login' => 'Přihlaste se zde',
	'cnw-auth-headline' => 'Přihlásit se',
	'cnw-auth-headline2' => 'Zaregistrovat se',
	'cnw-auth-creative' => 'Přihlašte se ke svému účtu a pokračujte s tvorbou vaší wiki.',
	'cnw-auth-facebook-signup' => 'Registrovat se prostřednictvím Facebooku',
	'cnw-auth-facebook-login' => 'Přihlásit se prostřednictvím Facebooku',
	'cnw-userauth-headline' => 'Máte účet?',
	'cnw-userauth-creative' => 'Přihlásit se',
	'cnw-userauth-marketing-heading' => 'Nemáte účet?',
	'cnw-userauth-signup-button' => 'Zaregistrovat se',
	'cnw-desc-headline' => 'O čem je vaše wiki?',
	'cnw-desc-creative' => 'Popište vaše téma',
	'cnw-desc-tip1' => 'Tip',
	'cnw-desc-tip2' => 'Pššt',
	'cnw-desc-select-one' => 'Jeden vyberte',
	'cnw-desc-all-ages' => 'Všechny stránky',
	'cnw-desc-default-lang' => 'Vaše wiki bude v $1',
	'cnw-desc-change-lang' => 'změnit',
	'cnw-desc-lang' => 'Jazyk',
	'cnw-desc-wiki-submit-error' => 'Prosím vyberte kategorii',
	'cnw-theme-headline' => 'Zvolte téma',
	'cnw-error-general-heading' => 'Omlouváme se',
	'cnw-badword-header' => 'Ahoj!',
	'cnw-badword-msg' => 'Ahoj. Prosím, zdržte se užívání sprostých nebo nevhodných slov ve svém popisu wiki: $1',
	'cnw-error-wiki-limit-header' => 'Dosažen limit Wiki',
	'cnw-error-blocked-header' => 'Účet zablokován',
	'cnw-error-anon-user-header' => 'Přihlaste se prosím',
	'cnw-error-bot-header' => 'Byli jste detekováni jako bot',
	'cnw-error-unconfirmed-email-header' => 'Váš e-mail nebyl potvrzen',
	'cnw-error-unconfirmed-email' => 'Váš e-mail musí být potvrzen před vytvořením Wiki.',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 * @author Thefartydoctor
 */
$messages['cy'] = array(
	'cnw-title' => 'Dechrau wici newydd',
	'cnw-name-wiki-headline' => 'Dechrau wici',
	'cnw-auth-facebook-login' => 'Mewngofnodi gyda Facebook',
	'cnw-userauth-creative' => 'Mewngofnodi',
	'cnw-desc-lang' => 'Iaith',
);

/** German (Deutsch)
 * @author Avatar
 * @author Claudia Hattitten
 * @author Das Schäfchen
 * @author Dennis07
 * @author Geitost
 * @author George Animal
 * @author LWChris
 * @author Metalhead64
 * @author Quedel
 * @author Tiin
 */
$messages['de'] = array(
	'createnewwiki-desc' => 'Assistent für die Erstellung eines Wikis',
	'cnw-next' => 'Weiter',
	'cnw-back' => 'Zurück',
	'cnw-or' => 'oder',
	'cnw-title' => 'Erstelle ein neues Wiki',
	'cnw-name-wiki-headline' => 'Starte ein Wikia',
	'cnw-name-wiki-creative' => 'Baue eine Website auf, lasse die Community wachsen und stelle dich auf ein unvergessliches Fanerlebnis ein.',
	'cnw-name-wiki-label' => 'Gib deinem Wikia einen Namen',
	'cnw-name-wiki-domain-label' => 'Gib deinem Wikia eine Adresse',
	'cnw-name-wiki-submit-error' => 'Hoppla! Um weitermachen zu können, musst du oben beide Felder ausfüllen.',
	'cnw-login' => 'Anmelden',
	'cnw-signup' => 'Benutzerkonto erstellen',
	'cnw-signup-prompt' => 'Brauchst du ein Benutzerkonto?',
	'cnw-call-to-signup' => 'Hier registrieren',
	'cnw-login-prompt' => 'Hast du bereits ein Benutzerkonto?',
	'cnw-call-to-login' => 'Hier anmelden',
	'cnw-auth-headline' => 'Anmelden',
	'cnw-auth-headline2' => 'Registrieren',
	'cnw-auth-creative' => 'Melde dich mit deinem Benutzerkonto an, um dein Wiki weiter auszubauen.',
	'cnw-auth-signup-creative' => 'Du benötigst ein Konto, um mit der Erstellung deines Wikis fortzufahren.<br />Die Registrierung dauert nur eine Minute!',
	'cnw-auth-facebook-signup' => 'Über Facebook registrieren',
	'cnw-auth-facebook-login' => 'Über Facebook anmelden',
	'cnw-userauth-headline' => 'Du bist bereits Mitglied?',
	'cnw-userauth-creative' => 'Anmelden',
	'cnw-userauth-marketing-heading' => 'Du hast noch kein Benutzerkonto?',
	'cnw-userauth-marketing-body' => 'Du benötigst ein Benutzerkonto auf Wikia. Das dauert nur eine Minute!',
	'cnw-userauth-signup-button' => 'Registrieren',
	'cnw-desc-headline' => 'Worum geht es in deinem Wikia?',
	'cnw-desc-creative' => 'Eine tolle Beschreibung hilft anderen dabei, dein Wikia zu finden.',
	'cnw-desc-placeholder' => 'Gib dir Mühe! Die Beschreibung wird auf der Hauptseite deines Wikias angezeigt.',
	'cnw-desc-tip1' => 'Und noch ein Tipp:',
	'cnw-desc-tip1-creative' => 'Nutze dieses Feld, um anderen mitzuteilen, warum dieses Wikia wichtig ist und warum du es erstellt hast.',
	'cnw-desc-tip2' => 'Übrigens...',
	'cnw-desc-tip2-creative' => 'Je mehr Details du zu deinem Wikia bereit stellst, desto mehr Leute werden deiner Community beitreten.',
	'cnw-desc-select-vertical' => 'Wähle eine Hub-Kategorie aus',
	'cnw-desc-select-categories' => 'Wähle zusätzliche Kategorien aus',
	'cnw-desc-select-one' => 'Wähle eine Kategorie aus',
	'cnw-desc-all-ages' => 'Richtet sich dieses Wikia an Kinder?',
	'cnw-desc-tip-all-ages' => 'Ist das Thema dieses Wikias für Kinder interessant? Zur Einhaltung geltender Rechte achten wir besonders auf Wikias, die Kinder unter 12 Jahren direkt ansprechen.',
	'cnw-desc-default-lang' => 'Die Sprache deines Wikias ist $1',
	'cnw-desc-change-lang' => 'ändern',
	'cnw-desc-lang' => 'Sprache',
	'cnw-desc-wiki-submit-error' => 'Bitte wähle eine Kategorie aus',
	'cnw-theme-headline' => 'Wähle ein Farbschema',
	'cnw-theme-creative' => 'Jetzt muss es nur noch gut aussehen! Wähle unten ein Farbschema aus, dann wird dir eine Vorschau angezeigt.',
	'cnw-theme-instruction' => 'Möchtest du dein Farbschema individuell gestalten? Du kannst später auch dein eigenes Farbschema entwerfen, indem du auf "Werkzeugkasten" klickst.',
	'cnw-welcome-headline' => 'Herzlichen Glückwunsch! $1 wurde erstellt',
	'cnw-welcome-instruction1' => 'Klicke unten auf die Schaltfläche, um Seiten zu deinem Wikia hinzufügen.',
	'cnw-welcome-help' => 'Weiter geht es mit dem Fanerlebnis! Finde Antworten, Ratschläge und mehr auf <a href="http://community.wikia.com">Community Central</a>.',
	'cnw-error-general' => 'Hoppla! Bei uns ist etwas schief gelaufen. Bitte versuche es erneut oder [[Special:Contact|kontaktiere uns]], wenn du Hilfe brauchst.',
	'cnw-error-general-heading' => 'Sorry!',
	'cnw-badword-header' => 'Immer mit der Ruhe!',
	'cnw-badword-msg' => 'Hallo, bitte verwende keines der folgenden Schimpfwörter bzw. keinen der unerlaubten Begriffe in deiner Wiki-Beschreibung: $1',
	'cnw-error-wiki-limit-header' => 'Limit an Wikis erreicht',
	'cnw-error-wiki-limit' => 'Hallo, du darfst nur {{PLURAL:$1|$1 Wiki|$1 Wikis}} pro Tag erstellen. Warte 24 Stunden, bevor du ein weiteres Wiki gründest.',
	'cnw-error-blocked-header' => 'Benutzerkonto gesperrt',
	'cnw-error-blocked' => 'Du wurdest von $1 gesperrt. Die Begründung lautet: $2. (Block-ID zu Referenzzwecken: $3)',
	'cnw-error-anon-user-header' => 'Melde dich bitte an',
	'cnw-error-anon-user' => 'Das Erstellen von Wikis für anonyme Benutzer wurde deaktiviert. Bitte [[Special:UserLogin|melde dich an]] und versuche es erneut.',
	'cnw-error-torblock' => 'Das Erstellen von Wikis über das Tor-Netzwerk ist nicht erlaubt.',
	'cnw-error-bot' => 'Wir haben festgestellt, dass dies wahrscheinlich ein Bot-Account ist. Wenn wir damit falsch liegen, kontaktiere uns bitte mit dem Hinweis, dass du fälschlicherweise als Bot identifiziert wurdest. Dann können wir dir bei der Erstellung deines Wikis weiterhelfen. [http://www.wikia.com/Special:Contact/general Kontaktformular]',
	'cnw-error-bot-header' => 'Du wurdest als Bot identifiziert.',
	'cnw-error-unconfirmed-email-header' => 'Deine E-Mail-Adresse wurde nicht bestätigt',
	'cnw-error-unconfirmed-email' => 'Deine E-Mail-Adresse muss zum Erstellen eines Wikis bestätigt werden.',
	'cnw-name-wiki-language' => '',
	'cnw-name-wiki-domain' => '.wikia.com',
	'autocreatewiki' => 'Erstelle ein neues Wiki',
	'autocreatewiki-desc' => 'Erzeugt ein Wiki in WikiFactory nach Benutzeranforderungen',
	'autocreatewiki-page-title-default' => 'Erstelle ein neues Wiki',
	'autocreatewiki-page-title-answers' => 'Eine neue Frage-Antwort-Site erstellen',
	'createwiki' => 'Ein neues Wiki erstellen',
	'autocreatewiki-chooseone' => 'Bitte auswählen',
	'autocreatewiki-required' => '$1 = notwendige Angabe',
	'autocreatewiki-web-address' => 'Web-Adresse:',
	'autocreatewiki-category-select' => 'Eine Option auswählen',
	'autocreatewiki-language-top' => 'Top-$1 Sprachen',
	'autocreatewiki-language-all' => 'Alle Sprachen',
	'autocreatewiki-remember' => 'Automatische Anmeldung',
	'autocreatewiki-create-account' => 'Benutzerkonto erstellen',
	'autocreatewiki-haveaccount-question' => 'Hast du bereits ein Benutzerkonto bei Wikia?',
	'autocreatewiki-info-domain' => 'Gib ein Wort ein, das am ehesten als Suchbegriff für dieses Thema verwendet wird.',
	'autocreatewiki-info-topic' => 'Füge eine kurze Beschreibung hinzu (z. B. „Star Wars“ oder „Fernsehserien“).',
	'autocreatewiki-info-category-default' => 'So können Besucher dein Wiki einfacher finden.',
	'autocreatewiki-info-category-answers' => 'So können Besucher deine Frage-Antwort-Site einfacher finden.',
	'autocreatewiki-info-language' => 'Dies wird die Standardsprache für Besucher deines Wikis.',
	'autocreatewiki-info-email-address' => 'Deine E-Mail-Adresse wird niemandem angezeigt.',
	'autocreatewiki-info-realname' => 'Wenn du dich dafür entscheidest, deinen realen Namen anzugeben, wird dies dafür verwendet, dir deine Beiträge zuzuordnen.',
	'autocreatewiki-info-birthdate' => 'Wikia verlangt von allen Nutzern, ihr tatsächliches Geburtsdatum anzugeben, sowohl als Sicherheitsmaßnahme, als auch als Mittel zur Wahrung der Integrität der Website unter Einhaltung der behördlichen Vorschriften.',
	'autocreatewiki-info-blurry-word' => 'Um die automatische Erstellung von Benutzerkonten zu verhindern, tippe bitte das verschwommene Wort ein.',
	'autocreatewiki-info-terms-agree' => 'Mit Erstellung eines Wikis und eines Benutzerkontos stimmst du Wikias {{#NewWindowLink: w:Terms of use | Nutzerbedingungen}} zu.',
	'autocreatewiki-info-staff-username' => '<b>Nur für Mitarbeiter:</b> Der angegebene Benutzer wird als Gründer aufgeführt.',
	'autocreatewiki-title-template' => '$1 Wikia',
	'autocreatewiki-tagline' => '',
	'autocreatewiki-limit-day' => 'Wikia hat die maximale Anzahl von Wiki-Erstellungen für heute überschritten ($1).',
	'autocreatewiki-limit-creation' => 'Du hast die maximale Anzahl an Wikis überschritten, die du in 24 Stunden erstellen kannst ($1).',
	'autocreatewiki-empty-field' => 'Fülle bitte dieses Feld aus.',
	'autocreatewiki-bad-name' => 'Der Name darf keine Sonderzeichen (wie $ oder @) enthalten und muss ein einzelnes Wort in Kleinbuchstaben ohne Leerzeichen sein.',
	'autocreatewiki-invalid-wikiname' => 'Der Name darf keine Sonderzeichen (wie $ oder @) enthalten und muss ausgefüllt werden.',
	'autocreatewiki-violate-policy' => 'Im Wikia-Namen ist ein Wort enthalten, dass unsere Richtlinien zur Namensgebung verletzt.',
	'autocreatewiki-name-taken' => 'Es gibt bereits ein Wiki mit dieser Adresse. Beteilige dich unter <a href="http://$1.wikia.com">http://$1.wikia.com</a> oder wähle eine andere Adresse.',
	'autocreatewiki-name-too-short' => 'Diese Adresse ist zu kurz, bitte wähle eine Adresse mit mindestens 3 Buchstaben aus.',
	'autocreatewiki-name-too-long' => 'Diese Adresse ist zu lang. Bitte wähle eine Adresse mit maximal 50 Zeichen aus.',
	'autocreatewiki-similar-wikis' => 'Weiter unten findest du die Wikis, die bereits zu diesem Thema erstellt wurden. Wir schlagen vor, dass du dich an einem davon beteiligst.',
	'autocreatewiki-invalid-username' => 'Dieser Benutzername ist ungültig.',
	'autocreatewiki-busy-username' => 'Dieser Benutzername existiert bereits.',
	'autocreatewiki-blocked-username' => 'Du kannst kein Benutzerkonto anlegen.',
	'autocreatewiki-user-notloggedin' => 'Dein Konto wurde erstellt aber nicht eingeloggt!',
	'autocreatewiki-empty-language' => 'Wähle bitte eine Sprache für dein Wiki aus.',
	'autocreatewiki-empty-category' => 'Bitte wähle eine Kategorie aus.',
	'autocreatewiki-empty-wikiname' => 'Bitte gib deinem Wiki einen Namen.',
	'autocreatewiki-empty-username' => 'Bitte gib einen Benutzernamen an.',
	'autocreatewiki-empty-password' => 'Bitte gib ein Passwort an.',
	'autocreatewiki-empty-retype-password' => 'Bitte gib das Passwort noch einmal ein.',
	'autocreatewiki-category-label' => 'Kategorie:',
	'autocreatewiki-category-other' => 'Andere',
	'autocreatewiki-set-username' => 'Wähle zuerst einen Benutzernamen.',
	'autocreatewiki-invalid-category' => 'Ungültige Kategorie-Auswahl.
Bitte wähle eine Kategorie aus der Dropdown-Liste aus.',
	'autocreatewiki-invalid-language' => 'Ungültige Sprach-Auswahl.
Bitte wähle eine Sprache aus der Dropdown-Liste aus.',
	'autocreatewiki-invalid-retype-passwd' => 'Bitte gib das gleiche Passwort wie oben ein',
	'autocreatewiki-invalid-birthday' => 'Ungültiges Geburtsdatum',
	'autocreatewiki-log-title' => 'Dein Wiki wird erstellt',
	'autocreatewiki-step0' => 'Prozess wird initialisiert ...',
	'autocreatewiki-stepdefault' => 'Prozess läuft, bitte warten ...',
	'autocreatewiki-errordefault' => 'Prozess wurde nicht beendet ...',
	'autocreatewiki-step1' => 'Bilderordner wird erstellt...',
	'autocreatewiki-step2' => 'Datenbank wird erstellt...',
	'autocreatewiki-step3' => 'Standard-Datenbankinformationen werden festgelegt...',
	'autocreatewiki-step4' => 'Standardbilder und Logo werden übertragen...',
	'autocreatewiki-step5' => 'Standard-Datenbankvariablen werden festgelegt...',
	'autocreatewiki-step6' => 'Standard-Datenbanktabellen werden festgelegt...',
	'autocreatewiki-step7' => 'Sprach-Basisversion wird festgelegt...',
	'autocreatewiki-step8' => 'Benutzergruppen und Kategorien werden festgelegt...',
	'autocreatewiki-step9' => 'Variablen für das neue Wiki werden festgelegt...',
	'autocreatewiki-step10' => 'Seiten im Central-Wikia werden festgelegt...',
	'autocreatewiki-step11' => 'E-Mail wird an Benutzer gesendet...',
	'autocreatewiki-redirect' => 'Weiterleitung zum neuen Wiki: $1 ...',
	'autocreatewiki-congratulation' => 'Glückwunsch!',
	'autocreatewiki-welcometalk-log' => 'Willkommensnachricht',
	'autocreatewiki-regex-error-comment' => 'verwendet in Wiki $1 (ganzer Text: $2)',
	'autocreatewiki-step2-error' => 'Datenbank existiert bereits!',
	'autocreatewiki-step3-error' => 'Initialisierung der Standard-Datenbankinformationen fehlgeschlagen!',
	'autocreatewiki-step6-error' => 'Initialisierung der Standard-Datenbanktabellen fehlgeschlagen!',
	'autocreatewiki-step7-error' => 'Fehler beim Übertragen der Sprach-Basisversion!',
	'requestwiki-filter-language' => 'als,an,ang,ast,bar,de2,de-at,de-ch,de-formal,de-weigsbrag,dk,en-gb,eshelp,fihelp,frc,frhelp,ia,ie,ithelp,jahelp,kh,kohelp,kp,ksh,nb,nds,nds-nl,mu,mwl,nlhelp,pdc,pdt,pfl,pthelp,pt-brhelp,ruhelp,simple,tokipona,tp,zh-classical,zh-cn,zh-hans,zh-hant,zh-hk,zh-min-nan,zh-mo,zh-my,zh-sg,zh-tw,zh-yue',
	'autocreatewiki-protect-reason' => 'Teil der offiziellen Oberfläche',
	'autocreatewiki-welcomesubject' => '$1 wurde erstellt!',
	'autocreatewiki-welcomebody' => 'Hallo $2,

das von dir erstellte Wiki ist nun unter <$1> erreichbar.

Bereit loszulegen? Wir haben auf deiner Diskussionsseite (<$5>) ein paar Links hinterlassen, die dir für den Anfang helfen sollen und dich hoffentlich ermutigen, die Hilfebereiche bei Wikia zu nutzen. Falls du einmal eine Frage hast oder nicht weiter weißt, dann antworte auf diese E-Mail oder sieh dir die Hilfeseiten <http://hilfe.wikia.com> an.

Du kannst dir auch das Gründer- und Administratoren-Blog <http://de.community.wikia.com/wiki/Blog:Gr%C3%BCnder_und_Administratoren> sowie das Wikia-Deutschland-News-Blog <http://de.community.wikia.com/wiki/Blog:Wikia_Deutschland_News> ansehen. Dort findest du Tipps und Tricks, Infos über neue Funktionen und Neuigkeiten rund um Wikia.

Viel Spaß beim Schreiben!

$3
Wikia Community-Support
<http://de.community.wikia.com/wiki/User:$4>

___________________________________________
* Wenn du weniger Nachrichten von uns erhalten möchtest, kannst du hier deine E-Mail-Einstellungen ändern: http://de.community.wikia.com/Spezial:Einstellungen',
	'autocreatewiki-welcometalk-wall-title' => 'Willkommen!',
	'autocreatewiki-welcometalk-wall' => 'Hallo! Wir freuen uns, dass {{subst:SITENAME}} jetzt auch Teil der Wikia-Gemeinschaft bist!

Es gibt noch einiges zu tun, deshalb hier nun als Hilfe ein paar Tipps und Links, damit dein Wikia ordentlich in Fahrt kommt!
* Sieh dir bei den [[Special:WikiFeatures|Wiki-Funktionen]] an, welche Erweiterungen - wie zum Beispiel den Chat oder die Herausforderungen - du in deinem Wikia aktivieren kannst.
* Du kannst das Aussehen deines Wikias im [[Special:ThemeDesigner|Theme-Designer]] individuell anpassen. Dort kannst du deinen Hintergrund und das Logo deines Wikias mit Farben und anderen Stilelementen verändern.
* Besuche die [[w:c:de.community|deutsche Wikia-Community]], um immer über [http://de.community.wikia.com/wiki/Blog:Wikia_Deutschland_News das aktuelle Wikia-Geschehen] informiert zu sein, Fragen im [[w:c:de.community:Special:Forum|Community-Forum]] zu stellen, an der [http://de.community.wikia.com/wiki/Wikia-Universit%C3%A4t Wikia-Universität] dein Wissen weiter zu vertiefen oder mit anderen Wikianern zu chatten.
* Außerdem kannst du alles zur Nutzung von Wikia auf unseren [[Hilfe:Übersicht|Hilfeseiten]] lernen. Besonders interessant sind zum Beispiel die Seiten, auf denen du lernst, wie du [[Hilfe:Neue_Seite|deinem Wikia eine neue Seite hinzufügen]], [[Hilfe:Benutzer_begeistern|neue Beitragende für dein Wikia finden]] und [[Hilfe:Benutzer|weitere Wiki-Admins hinzufügen]] kannst.

All diese Links sind gute Startpunkte, um sich zurechtzufinden und Spaß zu haben!',
	'autocreatewiki-welcometalk' => '== Willkommen! ==

Hallo! Wir freuen uns, dass {{subst:SITENAME}} jetzt auch Teil der Wikia-Gemeinschaft bist!

Es gibt noch einiges zu tun, deshalb hier nun als Hilfe ein paar Tipps und Links, damit dein Wikia ordentlich in Fahrt kommt!
* Sieh dir bei den [[Special:WikiFeatures|Wiki-Funktionen]] an, welche Erweiterungen - wie zum Beispiel den Chat oder die Herausforderungen - du in deinem Wikia aktivieren kannst.
* Du kannst das Aussehen deines Wikias im [[Special:ThemeDesigner|Theme-Designer]] individuell anpassen. Dort kannst du deinen Hintergrund und das Logo deines Wikias mit Farben und anderen Stilelementen verändern.
* Besuche die [[w:c:de.community|deutsche Wikia-Community]], um immer über [http://de.community.wikia.com/wiki/Blog:Wikia_Deutschland_News das aktuelle Wikia-Geschehen] informiert zu sein, Fragen im [[w:c:de.community:Special:Forum|Community-Forum]] zu stellen, an der [http://de.community.wikia.com/wiki/Wikia-Universit%C3%A4t Wikia-Universität] dein Wissen weiter zu vertiefen oder mit anderen Wikianern zu chatten.
* Außerdem kannst du alles zur Nutzung von Wikia auf unseren [[Hilfe:Übersicht|Hilfeseiten]] lernen. Besonders interessant sind zum Beispiel die Seiten, auf denen du lernst, wie du [[Hilfe:Neue_Seite|deinem Wikia eine neue Seite hinzufügen]], [[Hilfe:Benutzer_begeistern|neue Beitragende für dein Wikia finden]] und [[Hilfe:Benutzer|weitere Wiki-Admins hinzufügen]] kannst.

All diese Links sind gute Startpunkte, um sich zurechtzufinden und Spaß zu haben!

-- [[User:$2|$3]] <staff />',
	'autocreatewiki-language-top-list' => 'de,en,es,fr,it,ja,pl,pt-br,ru,zh',
);

/** German (formal address) (Deutsch (Sie-Form)‎)
 * @author Geitost
 * @author Tiin
 */
$messages['de-formal'] = array(
	'cnw-error-wiki-limit' => 'Guten Tag, Sie dürfen nur {{PLURAL:$1|ein Wiki|$1 Wikis}} am Tag gründen. Warten Sie 24 Stunden, bevor Sie ein weiteres Wiki gründen.',
	'cnw-error-blocked' => 'Sie wurden von $1 gesperrt. Die Begründung lautet: $2. (Block-ID zu Referenzzwecken: $3)',
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 * @author Marmase
 * @author Mirzali
 */
$messages['diq'] = array(
	'createnewwiki-desc' => 'Wikiyo newe vırazdar',
	'cnw-next' => 'Bahdoyên',
	'cnw-back' => 'Peyser',
	'cnw-or' => 'ya na',
	'cnw-title' => 'Wikiyo newe vıraze',
	'cnw-name-wiki-headline' => 'Wikiyo newe pêkerdış',
	'cnw-name-wiki-label' => 'Nameyê wikiyê şıma',
	'cnw-login' => 'Qeyd be',
	'cnw-signup' => 'Hesab vıraze',
	'cnw-signup-prompt' => 'Hesabê şıma çıniyo?',
	'cnw-call-to-signup' => 'Tiya qeyd bê',
	'cnw-login-prompt' => 'Xora yew hesabê şıma esto?',
	'cnw-call-to-login' => 'Tiya cı kewê',
	'cnw-auth-headline' => 'Qeyd vıraze',
	'cnw-auth-headline2' => 'Deqew de',
	'cnw-auth-facebook-signup' => 'Ebe Facebook cı kewê',
	'cnw-auth-facebook-login' => "Facebook'a cıkewtış",
	'cnw-userauth-headline' => 'Yew hesabê şıma esto?',
	'cnw-userauth-creative' => 'Cı kewe',
	'cnw-userauth-marketing-heading' => 'Hesabê şıma çıniyo?',
	'cnw-userauth-signup-button' => 'Hesabo Newe Ake',
	'cnw-desc-tip2' => 'Psst',
	'cnw-desc-select-one' => 'Yewi weçine',
	'cnw-desc-change-lang' => 'bıvurne',
	'cnw-desc-lang' => 'Zıwan',
	'cnw-desc-wiki-submit-error' => 'Reca kenime, yew kategoriye weçine',
	'cnw-theme-headline' => 'tema weçinê',
	'cnw-badword-header' => 'Oha',
	'cnw-error-wiki-limit-header' => 'Reşt sinorê wikiy',
	'cnw-error-blocked-header' => 'Hesab biyo kılit',
);

/** British English (British English)
 * @author Caliburn
 */
$messages['en-gb'] = array(
	'createnewwiki-desc' => 'Wiki creation wizard',
	'cnw-next' => 'Next',
);

/** Spanish (español)
 * @author Benfutbol10
 * @author Ciencia Al Poder
 * @author Fitoschido
 * @author Geitost
 * @author Ihojose
 * @author Light of Cosmos
 * @author Macofe
 * @author VegaDark
 */
$messages['es'] = array(
	'createnewwiki-desc' => 'Asistente para la creación de wikias',
	'cnw-next' => 'Siguiente',
	'cnw-back' => 'Atrás',
	'cnw-or' => 'o',
	'cnw-title' => 'Crear una nueva wikia',
	'cnw-name-wiki-headline' => 'Crear una wikia',
	'cnw-name-wiki-creative' => 'Crea una web, haz crecer una comunidad y embárcate en la experiencia fan definitiva.',
	'cnw-name-wiki-label' => 'Nombre de tu wikia',
	'cnw-name-wiki-domain-label' => 'Dale a tu wikia una dirección',
	'cnw-name-wiki-submit-error' => '¡Uy! Asegúrate de que los campos estén completados para continuar.',
	'cnw-login' => 'Iniciar sesión',
	'cnw-signup' => 'Crear una cuenta',
	'cnw-signup-prompt' => '¿Necesitas una cuenta?',
	'cnw-call-to-signup' => 'Regístrate aquí',
	'cnw-login-prompt' => '¿Ya tienes una cuenta?',
	'cnw-call-to-login' => 'Iniciar sesión aquí',
	'cnw-auth-headline' => 'Iniciar sesión',
	'cnw-auth-headline2' => 'Registrarse',
	'cnw-auth-creative' => 'Inicia sesión con tu cuenta para continuar la creación de tu wikia.',
	'cnw-auth-signup-creative' => 'Necesitarás una cuenta para seguir creando tu wikia.<br />¡Solamente tardarás un minuto en registrarte!',
	'cnw-auth-facebook-signup' => 'Registrarse con Facebook',
	'cnw-auth-facebook-login' => 'Iniciar sesión con Facebook',
	'cnw-userauth-headline' => '¿Tienes una cuenta?',
	'cnw-userauth-creative' => 'Iniciar sesión',
	'cnw-userauth-marketing-heading' => '¿No tienes una cuenta?',
	'cnw-userauth-marketing-body' => 'Necesitas una cuenta para crear una wikia en Wikia. ¡Solo tardas un minuto en registrarte!',
	'cnw-userauth-signup-button' => 'Registrarse',
	'cnw-desc-headline' => '¿De qué trata tu wikia?',
	'cnw-desc-creative' => 'Una buena descripción ayudará a la gente encontrar tu wikia.',
	'cnw-desc-placeholder' => '¡Hazlo bien! Este texto aparecerá en la portada de tu wikia.',
	'cnw-desc-tip1' => '¡Aquí tienes un consejo!',
	'cnw-desc-tip1-creative' => 'Usa este espacio para decirle a la gente por qué importa esta wikia y la razón por la que la creaste.',
	'cnw-desc-tip2' => 'PD:',
	'cnw-desc-tip2-creative' => 'Anima a otros a participar en tu comunidad ofreciendo más detalles.',
	'cnw-desc-select-vertical' => 'Selecciona una categoría',
	'cnw-desc-select-categories' => 'Selecciona algunas categorías adicionales si es necesario',
	'cnw-desc-select-one' => 'Selecciona una',
	'cnw-desc-all-ages' => '¿Esta wikia está destinada a un público infantil?',
	'cnw-desc-tip-all-ages' => '¿Tu wikia es acerca de un tema para niños? Para ayudarnos a cumplir con las leyes de Estados Unidos mantenemos un seguimiento constante de aquellas wikias que interesan directamente a los niños de 12 años y menores de 12.',
	'cnw-desc-default-lang' => 'Tu wikia estará en $1',
	'cnw-desc-change-lang' => 'cambiar',
	'cnw-desc-lang' => 'Idioma',
	'cnw-desc-wiki-submit-error' => 'Por favor, elige una categoría',
	'cnw-theme-headline' => 'Elige un diseño',
	'cnw-theme-creative' => '¡Que se vea bien! Escoge un tema y previsualiza cómo se verá.',
	'cnw-theme-instruction' => '¿Quieres personalizarlo? Puedes diseñar tu propio tema más tarde a través del diseñador de temas en el panel de administración.',
	'cnw-welcome-headline' => '¡Enhorabuena! Has creado $1 satisfactoriamente',
	'cnw-welcome-instruction1' => 'Ahora haz clic en el botón de abajo para empezar a añadir páginas en tu wikia.',
	'cnw-welcome-help' => 'Continua tu experiencia fan. Encuentra respuestas, consejos, y más en <a href="http://comunidad.wikia.com">Comunidad Central</a>.',
	'cnw-error-general' => '¡Algo salió mal en nuestro sistema! Por favor inténtalo de nuevo o [[Special:Contact|contáctanos]] para obtener ayuda.',
	'cnw-error-general-heading' => 'Lo sentimos',
	'cnw-badword-header' => '¡Rayos!',
	'cnw-badword-msg' => 'Hola, por favor abstente de usar estas palabras malsonantes o palabras prohibidas en la descripción de tu wikia: $1',
	'cnw-error-wiki-limit-header' => 'Has alcanzado el límite de wikias',
	'cnw-error-wiki-limit' => 'Hola, estás limitado a {{PLURAL:$1|una creación|$1 creaciones}} por día. Espera 24 horas antes de crear otra wikia.',
	'cnw-error-blocked-header' => 'Cuenta bloqueada',
	'cnw-error-blocked' => 'Tu cuenta ha sido bloqueada por $1. El motivo proporcionado fue: $2. (Identificador del bloqueo para referencia: $3)',
	'cnw-error-anon-user-header' => 'Por favor, inicia sesión',
	'cnw-error-anon-user' => 'Se ha desactivado la creación de wikias por parte de usuarios anónimos. [[Special:UserLogin|Inicia sesión]] e inténtalo de nuevo.',
	'cnw-error-torblock' => 'No está permitido crear wikias a través de la red Tor.',
	'cnw-error-bot' => 'Hemos detectado que puedes ser un bot. Si hemos cometido un error, por favor contáctanos y describe que has sido detectado como si fueras un bot y te ayudaremos a crear tu wikia: [http://comunidad.wikia.com/Special:Contact/general Contáctanos]',
	'cnw-error-bot-header' => 'Has sido identificado como un bot',
	'cnw-error-unconfirmed-email-header' => 'Tu correo electrónico no ha sido confirmado',
	'cnw-error-unconfirmed-email' => 'Tu correo electrónico debe ser confirmado para crear una wikia.',
	'cnw-name-wiki-language' => '',
	'cnw-name-wiki-domain' => '.wikia.com',
	'autocreatewiki' => 'Crear una nueva wikia',
	'autocreatewiki-desc' => 'Crear una wikia en WikiFactory a petición de un usuario',
	'autocreatewiki-page-title-default' => 'Crear una nueva wikia',
	'autocreatewiki-page-title-answers' => 'Crear un nuevo sitio de preguntas y respuestas',
	'createwiki' => 'Crea una nueva wikia',
	'autocreatewiki-chooseone' => 'Elige una',
	'autocreatewiki-required' => '$1 = requerido',
	'autocreatewiki-web-address' => 'Dirección web:',
	'autocreatewiki-category-select' => 'Selecciona una',
	'autocreatewiki-language-top' => 'Top $1 de idiomas',
	'autocreatewiki-language-all' => 'Todos los idiomas',
	'autocreatewiki-remember' => 'Recordarme',
	'autocreatewiki-create-account' => 'Crear una cuenta',
	'autocreatewiki-haveaccount-question' => '¿Ya tienes una cuenta en Wikia?',
	'autocreatewiki-info-domain' => 'Lo mejor es usar una palabra que probablemente sea una palabra clave en las búsquedas sobre tu tema.',
	'autocreatewiki-info-topic' => 'Añade una descripción corta como por ejemplo "Star Wars" o "Series de TV".',
	'autocreatewiki-info-category-default' => 'Esto ayudará a los visitantes a encontrar tu wikia.',
	'autocreatewiki-info-category-answers' => 'Esto ayudará a los visitantes a encontrar tu sitio de preguntas y respuestas.',
	'autocreatewiki-info-language' => 'Este será el idioma por defecto para los visitantes de tu wikia.',
	'autocreatewiki-info-email-address' => 'Tu dirección de correo electrónico no se mostrará a nadie en Wikia.',
	'autocreatewiki-info-realname' => 'Si optas por proporcionarlo, se usará para dar atribución a tu trabajo.',
	'autocreatewiki-info-birthdate' => 'Wikia solicita a todos los usuarios que pongan su fecha real de nacimiento como medida de seguridad y como forma de preservar la integridad del sitio mientras cumple con las regulaciones federales.',
	'autocreatewiki-info-blurry-word' => 'Para ayudar a protegernos contra la creación de cuentas automáticas, escribe la palabra borrosa que ves en este campo, por favor.',
	'autocreatewiki-info-terms-agree' => 'Al crear una wikia y una cuenta de usuario, aceptas los {{#NewWindowLink: w:c:es:Términos de uso|Términos de uso de Wikia}}',
	'autocreatewiki-info-staff-username' => '<b>Solamente Staff:</b> El usuario especificado figurará como el fundador de la wikia.',
	'autocreatewiki-title-template' => 'Wikia $1',
	'autocreatewiki-tagline' => '',
	'autocreatewiki-limit-day' => 'Wikia ha superado el número máximo de creaciones de wikias de hoy ($1).',
	'autocreatewiki-limit-creation' => 'Has excedido el número máximo de creación de wikias en 24 horas ($1).',
	'autocreatewiki-empty-field' => 'Por favor, completa este campo.',
	'autocreatewiki-bad-name' => 'El nombre no puede contener caracteres especiales (como $ o @) y debe componerse por palabras en minúscula y sin espacios.',
	'autocreatewiki-invalid-wikiname' => 'El nombre no puede contener caracteres especiales (como $ o @) y el campo no puede estar vacío.',
	'autocreatewiki-violate-policy' => 'El nombre de esta wikia contiene una palabra que viola nuestra política de nombres',
	'autocreatewiki-name-taken' => 'Ya existe una wikia con esta dirección. Comienza a editar en <a href="http://$1.wikia.com">http://$1.wikia.com</a> o escoge otra dirección.',
	'autocreatewiki-name-too-short' => 'Esta dirección es demasiado corta, por favor, elige una dirección con al menos 3 caracteres.',
	'autocreatewiki-name-too-long' => 'Esta dirección es demasiado larga, por favor, elige una dirección con un máximo de 50 caracteres.',
	'autocreatewiki-similar-wikis' => 'Debajo están las wikias ya creadas sobre este tema. Te sugerimos editar en alguna de ellas.',
	'autocreatewiki-invalid-username' => 'Este nombre de usuario no es válido.',
	'autocreatewiki-busy-username' => 'Este nombre de usuario ya está en uso.',
	'autocreatewiki-blocked-username' => 'No puedes crear la cuenta.',
	'autocreatewiki-user-notloggedin' => '¡Tu cuenta fue creada, pero no te identificaste!',
	'autocreatewiki-empty-language' => 'Por favor, selecciona el idioma de la wikia.',
	'autocreatewiki-empty-category' => 'Por favor, selecciona una categoría.',
	'autocreatewiki-empty-wikiname' => 'El campo del nombre de la wikia no puede estar vacío.',
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
	'autocreatewiki-log-title' => 'Tu wikia está siendo creada',
	'autocreatewiki-step0' => 'Iniciando proceso ...',
	'autocreatewiki-stepdefault' => 'El proceso está en marcha, por favor, espera un poco ...',
	'autocreatewiki-errordefault' => 'El proceso no fue terminado ...',
	'autocreatewiki-step1' => 'Creando directorio de imágenes ...',
	'autocreatewiki-step2' => 'Creando base de datos ...',
	'autocreatewiki-step3' => 'Configurando la información por defecto en la base de datos ...',
	'autocreatewiki-step4' => 'Copiando imágenes y logo por defecto ...',
	'autocreatewiki-step5' => 'Configurando variables por defecto en la base de datos ...',
	'autocreatewiki-step6' => 'Configurando tablas por defecto en la base de datos ...',
	'autocreatewiki-step7' => 'Configurando el idioma de comienzo ...',
	'autocreatewiki-step8' => 'Configurando grupos de usuarios y categorías ...',
	'autocreatewiki-step9' => 'Configurando las variables para la nueva wikia ...',
	'autocreatewiki-step10' => 'Configurando páginas en Comunidad Central ...',
	'autocreatewiki-step11' => 'Enviando correo electrónico al usuario ...',
	'autocreatewiki-redirect' => 'Redirigiendo a la nueva comunidad: $1 ...',
	'autocreatewiki-congratulation' => '¡Felicidades!',
	'autocreatewiki-welcometalk-log' => 'Mensaje de bienvenida',
	'autocreatewiki-regex-error-comment' => 'usados en $1 wiki (texto íntegro: $2)',
	'autocreatewiki-step2-error' => '¡La base de datos ya existe!',
	'autocreatewiki-step3-error' => '¡No se puede configurar la información por defecto en la base de datos!',
	'autocreatewiki-step6-error' => '¡No se pueden configurar las tablas por defecto en la base de datos!',
	'autocreatewiki-step7-error' => '¡No se puede copiar el idioma de comienzo en la base de datos!',
	'requestwiki-filter-language' => 'als,an,ang,ast,bar,de2,de-at,de-ch,de-formal,de-weigsbrag,dk,en-gb,eshelp,fihelp,frc,frhelp,ia,ie,ithelp,jahelp,kh,kohelp,kp,ksh,nb,nds,nds-nl,mu,mwl,nlhelp,pdc,pdt,pfl,pthelp,pt-brhelp,ruhelp,simple,tokipona,tp,zh-classical,zh-cn,zh-hans,zh-hant,zh-hk,zh-min-nan,zh-mo,zh-my,zh-sg,zh-tw,zh-yue',
	'autocreatewiki-protect-reason' => 'Parte de la interfaz oficial',
	'autocreatewiki-welcomesubject' => '¡$1 ha sido creada!',
	'autocreatewiki-welcomebody' => '¡Hola, $2!

¡Tu wikia ha sido creada! Échale un vistazo: <$1>

¿Todo preparado para comenzar? Hemos añadido algunos enlaces a tu muro de mensajes (<$5>) para ayudarte a comenzar y animarte a explorar las numerosas zonas útiles de Wikia. Si tienes alguna pregunta o estás un poco perdido responde a este correo electrónico o échale un vistazo a nuestras páginas de ayuda <http://comunidad.wikia.com/wiki/Ayuda:Contenido>.

También puedes consultar el blog del Staff de Wikia <http://comunidad.wikia.com/wiki/Blog%3ANoticias_de_Wikia> para encontrar noticias, consejos y trucos, información sobre las nuevas funcionalidades y las últimas novedades sobre lo que ocurre en Wikia.

¡Disfruta editando!

$3
El equipo comunitario de Wikia
<http://comunidad.wikia.com/wiki/Usuario:$4>

___________________________________________
* ¿Quieres recibir menos mensajes de nosotros? Puedes cancelar tu suscripción o cambiar tus preferencias de correo electrónico aquí: http://comunidad.wikia.com/wiki/Especial:Preferencias',
	'autocreatewiki-welcometalk-wall-title' => '¡Bienvenido/a!',
	'autocreatewiki-welcometalk-wall' => '¡Hola, estamos encantados de que {{subst:SITENAME}} forme parte de la comunidad de Wikia! 

Todavía queda mucho por hacer, así que aquí tienes algunos consejos y enlaces para mejorar tu wikia:
*Revisa la página de [[special:WikiFeatures|funcionalidades de Wikia]] para ver qué funcionalidades puedes activar en tu wikia, incluyendo el chat, los logros y muchas cosas más.
*Personaliza la apariencia de tu wikia visitando el [[Special:ThemeDesigner|diseñador de temas]], donde puedes añadir colores y tu propio estilo al fondo y al logo.
*Para por [[w:c:comunidad|Comunidad Central]] para mantenerte al día a través del [[w:c:comunidad:Blog:Noticias de Wikia|blog del staff]], haz preguntas en los [[w:c:comunidad:Special:Forum|foros de la comunidad]] y participa en el [[w:c:comunidad:special:chat|chat]] con otros wikinautas.
*Por último, visita nuestras [[ayuda:contenido|páginas de ayuda]] para descubrir todos los secretos de Wikia, incluyendo [[Ayuda:Página nueva|cómo añadir una nueva página en tu wikia]], [[Ayuda:Atrayendo editores|cómo atraer editores]] y [[Ayuda:Niveles de acceso de los usuarios|cómo añadir más administradores]].
*También puedes usar todas estas herramientas visitando el panel de administración, que puedes encontrar haciendo clic en el enlace "Panel de administración" de la barra de herramientas inferior.

Todos los enlaces anteriores son una genial forma de comenzar a explorar, pero por encima de todo, ¡diviértete!',
	'autocreatewiki-welcometalk' => "== ¡Recibe nuestra bienvenida! ==
¡Hola!

¡Nos encanta que '''$4''' sea parte de la comunidad Wikia! Ahora hay muchas cosas que hacer; aquí tienes algunos enlaces y consejos útiles para comenzar:

*Revisa las [[Special:WikiFeatures|funcionalidades de Wikia]] para ver las funcionalidades que puedes habilitar en tu wikia, incluyendo un chat, logros y mucho más.
*Pásate por [[w:c:comunidad|Comunidad Central]] para mantenerte al día a través de nuestro [[w:c:comunidad:Blog:Noticias de Wikia|blog del staff]], hacer tus preguntas en el [[w:c:comunidad:Especial:Foro|foro de la comunidad]], o conversar en directo con otros wikinautas.
*Finalmente, visita nuestras [[ayuda:contenido|páginas de ayuda]] para saber la información básica sobre cómo usar Wikia.

Todos los enlaces anteriores son un gran lugar para comenzar a explorar, ¡así que diviértete!

-- [[User:$3|$3]] <staff />",
	'autocreatewiki-language-top-list' => 'de,en,es,fr,it,ja,pl,pt-br,ru,zh',
);

/** Basque (euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'cnw-next' => 'Hurrengoa',
	'cnw-back' => 'Atzera',
	'cnw-or' => 'edo',
	'cnw-desc-lang' => 'Hizkuntza',
);

/** Persian (فارسی)
 * @author Alirezaaa
 * @author BlueDevil
 * @author Ebraminio
 * @author Hosseinblue
 * @author Movyn
 * @author Reza1615
 */
$messages['fa'] = array(
	'cnw-next' => 'بعدی',
	'cnw-back' => 'عقب',
	'cnw-or' => 'یا',
	'cnw-title' => 'ایجاد ویکی تازه',
	'cnw-name-wiki-headline' => 'شروع یک ویکی',
	'cnw-name-wiki-creative' => 'ویکیا از بهترین مکان‌ها برای ساخت وب‌گاهی است که می‌تواند رشد کند و موضوع مورد علاقه شما را گسترش دهد.',
	'cnw-name-wiki-label' => 'نام ویکی شما',
	'cnw-name-wiki-domain-label' => 'آدرس ویکی شما',
	'cnw-login' => 'ورود به سامانه',
	'cnw-signup' => 'ایجاد حساب تازه',
	'cnw-signup-prompt' => 'نیاز به حساب کاربری دارید؟',
	'cnw-call-to-signup' => 'ثبت نام کنید',
	'cnw-call-to-login' => 'وارد شوید',
	'cnw-auth-headline' => 'ورود به سامانه',
	'cnw-auth-headline2' => 'ثبت نام',
	'cnw-userauth-creative' => 'ورود به سامانه',
	'cnw-userauth-marketing-heading' => 'حساب کاربری ندارید؟',
	'cnw-userauth-signup-button' => 'ثبت نام',
	'cnw-desc-headline' => 'ویکی شما در چه موضوعی است؟',
	'cnw-desc-creative' => 'توصیف شما به دیگران کمک می‌کند تا بهتر ویکی شما را پیدا کنند',
	'cnw-desc-tip1' => 'راهنمایی',
	'cnw-desc-tip1-creative' => 'با یک یا دو جمله، از این فضا استفاده کنید تا دیگران بدانند از چه ویکی استفاده می‌کنند',
	'cnw-desc-select-vertical' => 'یک دایرکتوری مادر انتخاب کنید',
	'cnw-desc-select-categories' => 'دسته‌بندی دقیق‌تر',
	'cnw-desc-select-one' => 'یکی را انتخاب کنید',
	'cnw-desc-change-lang' => 'تغییر',
	'cnw-desc-lang' => 'زبان',
	'cnw-theme-headline' => 'انتخاب قالب',
	'cnw-theme-creative' => 'از نمونه‌های زیر یک قالب را انتخاب کنید. شما این امکان را دارید تا پیش‌نمایشی از قالب انتخابی خود را مشاهده کنید.',
	'cnw-theme-instruction' => 'شما همچنین می‌توانید قالب اختصاصی خود را بعدا با کمک "ابزارهای من" ایجاد کنید.',
	'cnw-error-anon-user-header' => 'لطفاً وارد شوید',
	'cnw-error-unconfirmed-email-header' => 'ایمیل شما تایید نشده است',
	'cnw-error-unconfirmed-email' => 'برای ساخت یک ویکی باید ایمیل شما تایید شود.',
);

/** Finnish (suomi)
 * @author Elseweyr
 * @author Ilkea
 * @author Lukkipoika
 * @author Nike
 * @author Pxos
 * @author Tofu II
 * @author VezonThunder
 * @author Ville96
 */
$messages['fi'] = array(
	'createnewwiki-desc' => 'Ohjattu wikin luonti',
	'cnw-next' => 'Seuraava',
	'cnw-back' => 'Takaisin',
	'cnw-or' => 'tai',
	'cnw-title' => 'Luo uusi Wiki',
	'cnw-name-wiki-headline' => 'Perusta wikia',
	'cnw-name-wiki-creative' => 'Wikia on paras paikka rakentaa nettisivu ja kasvattaa yhteisö sen ympärille.',
	'cnw-name-wiki-label' => 'Nimeä wikisi',
	'cnw-name-wiki-domain-label' => 'Anna wikillesi osoite',
	'cnw-name-wiki-submit-error' => 'Hups! Sinun pitää täyttää kummatkin laatikot alapuolelta voidaksesi jatkaa.',
	'cnw-login' => 'Kirjaudu sisään',
	'cnw-signup' => 'Luo käyttäjätunnus',
	'cnw-signup-prompt' => 'Tarvitsetko käyttäjätunnuksen?',
	'cnw-call-to-signup' => 'Rekisteröidy tästä',
	'cnw-login-prompt' => 'Onko sinulla jo käyttäjä?',
	'cnw-call-to-login' => 'Kirjaudu sisään täältä',
	'cnw-auth-headline' => 'Kirjaudu sisään',
	'cnw-auth-headline2' => 'Rekisteröidy',
	'cnw-auth-creative' => 'Kirjaudu sisään käyttäjällesi jatkaaksesi wikin luontia.',
	'cnw-auth-signup-creative' => 'Tarvitset käyttäjän jatkaaksesi wikin luontia.<br />Rekisteröityminen vie vain hetken!',
	'cnw-auth-facebook-signup' => 'Rekisteröidy Facebookin avulla',
	'cnw-auth-facebook-login' => 'Kirjaudu Facebookin avulla',
	'cnw-userauth-headline' => 'Onko sinulla käyttäjä?',
	'cnw-userauth-creative' => 'Kirjaudu sisään',
	'cnw-userauth-marketing-heading' => 'Eikö sinulla ole käyttäjää?',
	'cnw-userauth-marketing-body' => 'Tarvitset käyttäjätunnuksen, jotta voit luoda wikin Wikiaan. Rekisteröityminen vie vain hetken!',
	'cnw-userauth-signup-button' => 'Rekisteröidy',
	'cnw-desc-headline' => 'Mistä wikiasi kertoo?',
	'cnw-desc-creative' => 'Hyvä kuvaus auttaa ihmisiä löytämään wikiasi',
	'cnw-desc-placeholder' => 'Tämä ilmestyy wikisi etusivulle.',
	'cnw-desc-tip1' => 'Vihje',
	'cnw-desc-tip1-creative' => 'Käytä tätä tilaa kertomaan ihmisille wikiastasi parilla lauseella',
	'cnw-desc-tip2' => 'Psst',
	'cnw-desc-tip2-creative' => 'Kerro vierailijoille jotain erityisiä tietoja aiheestasi',
	'cnw-desc-select-one' => 'Valitse yksi',
	'cnw-desc-all-ages' => 'Onko tämä wikia tarkoitettu lapsille?',
	'cnw-desc-tip-all-ages' => 'Käsitteleekö tämä wikia aihetta, jota kiinnostaa lapsia? Noudattaaksemme Yhdysvaltojen lakia pidämme seurantaa wikioista, joiden aiheet viehättävät 12-vuotiaita tai nuorempia lapsia.',
	'cnw-desc-default-lang' => 'Wikisi kieli tulee olemaan $1',
	'cnw-desc-change-lang' => 'vaihda',
	'cnw-desc-lang' => 'Kieli',
	'cnw-desc-wiki-submit-error' => 'Valitse luokka',
	'cnw-theme-headline' => 'Valitse teema',
	'cnw-theme-creative' => 'Valitse alta teema, näet esikatselun jokaisesta teemasta kun valitset sen.',
	'cnw-theme-instruction' => 'Pystyt myös suunnittelemaan oman teema myöhemmin menemällä "Omiin työkaluihin".',
	'cnw-welcome-headline' => 'Onnittelut! $1 on luotu',
	'cnw-welcome-instruction1' => 'Klikkaa painiketta alta aloittaaksesi sivujen lisäämisen wikiisi.',
	'cnw-welcome-help' => 'Löydä vastauksia, neuvoa, ja muuta <a href="http://community.wikia.com">Community Central:sta</a>',
	'cnw-error-general' => 'Oho, jokin meni pieleen meidän puolellamme! Ole hyvä ja yritä uudelleen tai [[Special:Contact|ota meihin yhteyttä]] saadaksesi apua.',
	'cnw-error-general-heading' => 'Pahoittelumme',
	'cnw-badword-header' => 'Hei siellä',
	'cnw-badword-msg' => 'Hei, äläpä käytä seuraavia rumia tai kiellettyjä sanoja Wikisi kuvauksessa: $1',
	'cnw-error-wiki-limit-header' => 'Wikien enimmäis määrä saavutettu',
	'cnw-error-wiki-limit' => 'Hei, olet rajoitettu luomaan {{PLURAL:$1|$1 wikin|$1 wikiä}} päivässä. Odota 24 tuntia ennen wikin luontia.',
	'cnw-error-blocked-header' => 'Käyttäjätunnus estetty',
	'cnw-error-blocked' => '$1 esti sinut. Syy oli: $2. (Eston ID valitusta varten: $3)',
	'cnw-error-anon-user-header' => 'Ole hyvä ja kirjaudu sisään',
	'cnw-error-anon-user' => 'Anonyymi käyttäjä ei voi luoda wikiä. [[Special:UserLogin|Kirjaudu sisään]] ja yritä uudelleen.',
	'cnw-error-torblock' => 'Wikin luonti Tor-verkkoa käyttäen ei ole sallittu.',
	'cnw-error-bot' => 'Havaitsimme että voit olla botti. Jos olemme tehneet virheen, ota yhteyttä kertoen että sinut on virheellisesti havaittu botiksi, ja me avustamme wikisi luonnissa: [http://www.wikia.com/Special:Contact/general Ota yhteyttä]',
	'cnw-error-bot-header' => 'Sinut on havaittu botiksi',
	'cnw-error-unconfirmed-email-header' => 'Sähköpostiosoitettasi ei ole vahvistettu',
	'cnw-error-unconfirmed-email' => 'Sähköpostiosoitteesi on vahvistettava ennen wikin luomista.',
);

/** Faroese (føroyskt)
 * @author EileenSanda
 */
$messages['fo'] = array(
	'createnewwiki-desc' => 'Vegleiðing í at upprætta eina Wiki',
	'cnw-next' => 'Næsta',
	'cnw-back' => 'Aftur',
	'cnw-or' => 'ella',
	'cnw-title' => 'Upprætta eina nýggja Wiki',
	'cnw-name-wiki-headline' => 'Byrja eina Wiki',
	'cnw-name-wiki-label' => 'Navngev tína wiki',
	'cnw-name-wiki-domain-label' => 'Gev tínari wiki ein bústað',
	'cnw-name-wiki-submit-error' => 'Ups! Tú mást útfylla báðir teigarnar omanfyri fyri at halda fram.',
	'cnw-login' => 'Rita inn',
	'cnw-signup' => 'Upprætta konto',
	'cnw-signup-prompt' => 'Hevur tú tørv á einari konto?',
	'cnw-call-to-signup' => 'Skráset teg her',
	'cnw-login-prompt' => 'Hevur tú longu eina konto?',
	'cnw-call-to-login' => 'Rita inn her',
	'cnw-auth-headline' => 'Rita inn',
	'cnw-auth-headline2' => 'Skráset teg',
	'cnw-auth-creative' => 'Rita inn á tína konto og halt fram at byggja tína wiki.',
	'cnw-auth-signup-creative' => 'Tú hevur brúk fyri einari konto fyri at halda fram við at byggja tína wiki.<br />Tað tekur bert ein minutt at skráseta seg!',
	'cnw-auth-facebook-signup' => 'Skráset teg við Facebook',
	'cnw-auth-facebook-login' => 'Rita inn við Facebook',
	'cnw-userauth-headline' => 'Hevur tú eina konto?',
	'cnw-userauth-creative' => 'Rita inn',
	'cnw-userauth-marketing-heading' => 'Hevur tú ikki nakra kontu?',
	'cnw-userauth-signup-button' => 'Skráset teg',
	'cnw-desc-headline' => 'Hvat snýr tín wiki seg um?',
	'cnw-desc-creative' => 'Skriva frágreiðign um títt evni',
	'cnw-desc-placeholder' => 'Hetta verður víst á forsíðuni á tínari wiki.',
	'cnw-desc-select-one' => 'Vel ein',
	'cnw-desc-all-ages' => 'Allir aldursbólkar',
	'cnw-desc-change-lang' => 'broyt',
	'cnw-desc-lang' => 'Mál',
	'cnw-desc-wiki-submit-error' => 'Vinarliga vel ein bólk',
);

/** French (français)
 * @author Fujimaru-kun
 * @author Gomoko
 * @author Jgaignerot
 * @author Od1n
 * @author Peter17
 * @author Verdy p
 * @author Windes
 * @author Wyz
 */
$messages['fr'] = array(
	'createnewwiki-desc' => 'Assistant de création de wikia',
	'cnw-next' => 'Suite',
	'cnw-back' => 'Retour',
	'cnw-or' => 'ou',
	'cnw-title' => 'Créer un nouveau wikia',
	'cnw-name-wiki-headline' => 'Créer un wikia',
	'cnw-name-wiki-creative' => 'Construisez votre site, développez votre communauté et transformez votre passion en aventure.',
	'cnw-name-wiki-label' => 'Donnez un nom à votre wikia',
	'cnw-name-wiki-domain-label' => 'Donnez une adresse à votre wiki',
	'cnw-name-wiki-submit-error' => 'Oups, vous devez remplir les deux champs ci-dessus pour pouvoir continuer.',
	'cnw-login' => 'Se connecter',
	'cnw-signup' => 'Créer un compte',
	'cnw-signup-prompt' => 'Vous devez créer un compte ?',
	'cnw-call-to-signup' => 'Inscrivez-vous ici',
	'cnw-login-prompt' => 'Vous avez déjà un compte ?',
	'cnw-call-to-login' => 'Connectez-vous ici',
	'cnw-auth-headline' => 'Se connecter',
	'cnw-auth-headline2' => 'S’inscrire',
	'cnw-auth-creative' => 'Connectez-vous à votre compte pour continuer à construire votre wikia.',
	'cnw-auth-signup-creative' => "Pour construire un wikia, vous devez créer un compte.<br />Cela ne prendra qu'une minute !",
	'cnw-auth-facebook-signup' => "S'inscrire avec Facebook",
	'cnw-auth-facebook-login' => 'Se connecter avec Facebook',
	'cnw-userauth-headline' => 'Vous avez un compte ?',
	'cnw-userauth-creative' => 'Se connecter',
	'cnw-userauth-marketing-heading' => 'Vous n’avez pas encore de compte ?',
	'cnw-userauth-marketing-body' => "Pour créer un wikia, vous devez vous inscrire. Cela ne prendra qu'une minute !",
	'cnw-userauth-signup-button' => "S'inscrire",
	'cnw-desc-headline' => 'De quoi parle votre wikia ?',
	'cnw-desc-creative' => 'Une bonne description rendra votre wikia plus visible.',
	'cnw-desc-placeholder' => 'Ce texte apparaîtra sur la page principale de votre wikia.',
	'cnw-desc-tip1' => 'Astuce nº 1 :',
	'cnw-desc-tip1-creative' => 'Expliquez ici pourquoi ce wikia est important et ce qui vous a motivé à le créer.',
	'cnw-desc-tip2' => 'Astuce nº 2 :',
	'cnw-desc-tip2-creative' => 'Donnez des détails sur votre wikia et encouragez vos visiteurs à contribuer.',
	'cnw-desc-select-vertical' => 'Sélectionnez un thème',
	'cnw-desc-select-categories' => 'Catégories supplémentaires',
	'cnw-desc-select-one' => 'En choisir un',
	'cnw-desc-all-ages' => 'Ce wikia est-il destiné aux enfants ?',
	'cnw-desc-tip-all-ages' => 'Le sujet pourrait-il intéresser les enfants ? Afin de ne pas enfreindre les lois en vigueur aux États-Unis, nous suivons les wikias destinés aux enfants de 12 ans et moins.',
	'cnw-desc-default-lang' => 'Votre wikia sera en $1',
	'cnw-desc-change-lang' => 'modifier',
	'cnw-desc-lang' => 'Langue',
	'cnw-desc-wiki-submit-error' => 'Merci de choisir une catégorie',
	'cnw-theme-headline' => 'Choisir un thème',
	'cnw-theme-creative' => "Soignez l'apparence de votre wikia ! Choisissez un thème et prévisualisez le résultat.",
	'cnw-theme-instruction' => 'Personnalisez votre wikia grâce au Concepteur de thème disponible sur votre Tableau de bord administrateur.',
	'cnw-welcome-headline' => 'Félicitations !  Vous venez de créer $1 !',
	'cnw-welcome-instruction1' => 'Cliquez sur le bouton ci-dessous pour ajouter des pages à votre wikia.',
	'cnw-welcome-help' => 'Vivez votre passion de fan. Trouvez des réponses, conseils et plus sur le  <a href="http://communaute.wikia.com">Centre des communautés</a>.',
	'cnw-error-general' => 'Oups, un problème est survenu de notre côté ! Veuillez réessayer plus tard ou [[Special:Contact|nous contacter]] pour obtenir de l’aide.',
	'cnw-error-general-heading' => 'Toutes nos excuses',
	'cnw-badword-header' => 'Eh...',
	'cnw-badword-msg' => 'Bonjour, veuillez éviter d’utiliser des mots grossiers ou interdits dans la description de votre wikia : $1',
	'cnw-error-wiki-limit-header' => 'Nombre de wikias maximum atteint',
	'cnw-error-wiki-limit' => 'Bonjour, vous ne pouvez pas créer plus de $1 {{PLURAL:$1|wikia|wikias}} par jour. Patientez 24 heures avant de créer un autre wikia.',
	'cnw-error-blocked-header' => 'Compte bloqué',
	'cnw-error-blocked' => 'Vous avez été bloqué par $1. La raison invoquée était : $2. (ID de blocage pour référence : $3)',
	'cnw-error-anon-user-header' => 'Veuillez vous connecter',
	'cnw-error-anon-user' => 'Les utilisateurs anonymes ne peuvent pas créer de wikias. Veuillez [[Special:UserLogin|vous connecter]] et réessayer.',
	'cnw-error-torblock' => "La création de wikias via le réseau Tor n'est pas autorisée.",
	'cnw-error-bot' => "Nous avons détecté que vous pourriez être un robot. Si nous nous sommes trompés, veuillez nous contacter en indiquant qu'il s'agit d'une erreur. Nous vous aiderons alors à créer votre wikia : [http://fr.wikia.com/Special:Contact/general Nous contacter].",
	'cnw-error-bot-header' => 'Vous avez été détecté comme étant un robot.',
	'cnw-error-unconfirmed-email-header' => "Votre adresse e-mail n'a pas été confirmée.",
	'cnw-error-unconfirmed-email' => 'Avant de pouvoir créer un wikia, vous devez confirmer votre adresse e-mail.',
	'cnw-name-wiki-language' => '',
	'cnw-name-wiki-domain' => '.wikia.com',
	'autocreatewiki' => 'Créer un  nouveau wikia',
	'autocreatewiki-desc' => 'Crée un wikia dans WikiFactory à la demande des utilisateurs',
	'autocreatewiki-page-title-default' => 'Créer un nouveau wikia',
	'autocreatewiki-page-title-answers' => 'Créer un nouveau site de réponses',
	'createwiki' => 'Créer un nouveau wikia',
	'autocreatewiki-chooseone' => 'Choisissez-en un',
	'autocreatewiki-required' => '$1 = obligatoire',
	'autocreatewiki-web-address' => 'URL :',
	'autocreatewiki-category-select' => 'En choisir un',
	'autocreatewiki-language-top' => 'Les $1 langues les plus utilisées',
	'autocreatewiki-language-all' => 'Toutes les langues',
	'autocreatewiki-remember' => 'Se souvenir de moi',
	'autocreatewiki-create-account' => 'Créer un compte',
	'autocreatewiki-haveaccount-question' => 'Vous avez déjà un compte Wikia ?',
	'autocreatewiki-info-domain' => 'Choisissez de préférence un mot qui sera utilisé par des utilisateurs effectuant une recherche sur ce sujet.',
	'autocreatewiki-info-topic' => 'Ajoutez une courte description telle que « Star Wars » ou « séries ».',
	'autocreatewiki-info-category-default' => 'Cela permettra aux visiteurs de trouver votre wikia.',
	'autocreatewiki-info-category-answers' => 'Cela permettra aux visiteurs de trouver votre site de réponses.',
	'autocreatewiki-info-language' => "Il s'agit de la langue par défaut de votre wikia.",
	'autocreatewiki-info-email-address' => "Votre adresse e-mail n'est pas visible sur Wikia.",
	'autocreatewiki-info-realname' => 'Si vous choisissez de le partager, il sera utilisé pour vous attribuer les actions que vous avez effectuées.',
	'autocreatewiki-info-birthdate' => 'Wikia demande à tous les utilisateurs de fournir leur date de naissance réelle ; ceci est une mesure de sécurité et permet également de préserver l’intégrité du site tout en respectant les lois fédérales américaines.',
	'autocreatewiki-info-blurry-word' => 'Afin de nous aider à lutter contre la création de comptes automatisée, merci de saisir le mot flou dans ce champ.',
	'autocreatewiki-info-terms-agree' => "En créant un wikia et un compte utilisateur, vous acceptez nos {{#NewWindowLink:homepage:fr:Conditions d'utilisation|Conditions d'utilisation}}",
	'autocreatewiki-info-staff-username' => "<b>Staff uniquement :</b> l'utilisateur spécifié deviendra le fondateur du wikia.",
	'autocreatewiki-title-template' => 'Wikia $1',
	'autocreatewiki-tagline' => '',
	'autocreatewiki-limit-day' => "Le nombre de nouveaux wikias pouvant être créés aujourd'hui ($1) a été dépassé.",
	'autocreatewiki-limit-creation' => 'Vous avez dépassé le nombre maximum de wikias pouvant être créés en 24 heures ($1).',
	'autocreatewiki-empty-field' => 'Merci de compléter ce champ.',
	'autocreatewiki-bad-name' => 'Le nom ne doit pas contenir de caractères spéciaux (comme $ et @), doit être un mot unique, en minuscules et sans espaces.',
	'autocreatewiki-invalid-wikiname' => 'Le nom ne doit pas contenir de caractères spéciaux (comme $ et @) et ne doit pas être vide.',
	'autocreatewiki-violate-policy' => 'Le nom de ce wikia contient un mot qui enfreint notre règlement.',
	'autocreatewiki-name-taken' => 'Cette URL est déjà prise. Participez sur <a href="http://$1.wikia.com">http://$1.wikia.com</a> ou choisissez une autre URL.',
	'autocreatewiki-name-too-short' => 'Cette URL est trop courte, choisissez une URL avec au moins 3 caractères.',
	'autocreatewiki-name-too-long' => 'Cette URL est trop longue, choisissez une URL avec au maximum 50 caractères.',
	'autocreatewiki-similar-wikis' => "Vous trouverez ci-dessous une liste des wikias sur le même sujet. Peut-être pouvez-vous participer sur l'un d'entre eux ?",
	'autocreatewiki-invalid-username' => "Ce nom d'utilisateur n'est pas valide.",
	'autocreatewiki-busy-username' => "Ce nom d'utilisateur est déjà pris.",
	'autocreatewiki-blocked-username' => 'Vous ne pouvez pas créer de compte.',
	'autocreatewiki-user-notloggedin' => "Votre compte a été créé mais vous n'êtes pas connecté !",
	'autocreatewiki-empty-language' => 'Sélectionnez la langue du wikia.',
	'autocreatewiki-empty-category' => 'Sélectionnez une catégorie.',
	'autocreatewiki-empty-wikiname' => 'Le nom du wikia ne peut pas être vide.',
	'autocreatewiki-empty-username' => "Le nom d'utilisateur ne peut pas être vide.",
	'autocreatewiki-empty-password' => 'Le mot de passe ne peut pas être vide.',
	'autocreatewiki-empty-retype-password' => 'Veuillez saisir à nouveau le mot de passe.',
	'autocreatewiki-category-label' => 'Catégorie :',
	'autocreatewiki-category-other' => 'Autre',
	'autocreatewiki-set-username' => "Vous devez d'abord définir votre nom d'utilisateur.",
	'autocreatewiki-invalid-category' => 'Catégorie non valide. 
Merci de sélectionner une valeur dans le menu déroulant.',
	'autocreatewiki-invalid-language' => 'Langue non valide.
Merci de sélectionner une valeur dans le menu déroulant.',
	'autocreatewiki-invalid-retype-passwd' => 'Veuillez saisir le même mot de passe que celui ci-dessus.',
	'autocreatewiki-invalid-birthday' => 'Date de naissance non valide',
	'autocreatewiki-log-title' => 'Votre wikia est en cours de création.',
	'autocreatewiki-step0' => 'Initialisation...',
	'autocreatewiki-stepdefault' => 'Votre wikia est en cours de création, veuillez patienter...',
	'autocreatewiki-errordefault' => "La création du wikia n'est pas finie...",
	'autocreatewiki-step1' => 'Création du dossier des images en cours...',
	'autocreatewiki-step2' => 'Création de la base de données en cours...',
	'autocreatewiki-step3' => 'Ajout des informations par défaut dans la base de données en cours...',
	'autocreatewiki-step4' => 'Copie des images par défaut et du logo en cours...',
	'autocreatewiki-step5' => 'Ajout des variables par défaut dans la base de données en cours...',
	'autocreatewiki-step6' => 'Ajout des tables par défaut dans la base de données en cours...',
	'autocreatewiki-step7' => 'Ajout des bases pour la langue en cours...',
	'autocreatewiki-step8' => 'Ajout des groupes utilisateurs et catégories en cours...',
	'autocreatewiki-step9' => 'Ajout des variables du nouveau wikia en cours...',
	'autocreatewiki-step10' => 'Ajout des pages dans le wikia central en cours...',
	'autocreatewiki-step11' => "Envoi de l'e-mail à l'utilisateur en cours...",
	'autocreatewiki-redirect' => 'Redirection vers le nouveau wikia : $1...',
	'autocreatewiki-congratulation' => 'Félicitations !',
	'autocreatewiki-welcometalk-log' => 'Message de bienvenue',
	'autocreatewiki-regex-error-comment' => 'utilisé sur le wikia $1 (texte complet : $2)',
	'autocreatewiki-step2-error' => 'La base de données existe déjà !',
	'autocreatewiki-step3-error' => "Impossible d'ajouter les informations par défaut à la base de données !",
	'autocreatewiki-step6-error' => "Impossible d'ajouter les tables par défaut dans la base de données !",
	'autocreatewiki-step7-error' => 'Impossible de copier la base de données de base pour cette langue !',
	'requestwiki-filter-language' => 'als,an,ang,ast,bar,de2,de-at,de-ch,de-formal,de-weigsbrag,dk,en-gb,eshelp,fihelp,frc,frhelp,ia,ie,ithelp,jahelp,kh,kohelp,kp,ksh,nb,nds,nds-nl,mu,mwl,nlhelp,pdc,pdt,pfl,pthelp,pt-brhelp,ruhelp,simple,tokipona,tp,zh-classical,zh-cn,zh-hans,zh-hant,zh-hk,zh-min-nan,zh-mo,zh-my,zh-sg,zh-tw,zh-yue',
	'autocreatewiki-protect-reason' => "Partie de l'interface officielle",
	'autocreatewiki-welcomesubject' => "$1 vient d'être créé !",
	'autocreatewiki-welcomebody' => "Bonjour $2 !

Vous venez de créer un wikia !  Le voici : <$1>

Vous êtes prêt à commencer ?  Nous avons ajouté quelques liens sur votre page de discussion (<$5>) pour vous aider à faire vos premiers pas et vous rediriger vers les nombreuses pages d'aide de Wikia. Si vous avez des questions ou vous sentez un peu perdu, répondez à ce message ou consultez nos pages d'aide <http://communaute.wikia.com/wiki/Aide:Contenu>.

Nous vous encourageons également à lire le blog « Fondateur et administrateur » <http://communaute.wikia.com/wiki/Blog:Conseils_pour_fondateurs/administrateurs>  et le blog Actualité Wikia <http://communaute.wikia.com/wiki/Blog:Actualité_Wikia> ; vous y trouverez des astuces ainsi que des informations sur les nouvelles fonctionnalités de Wikia.

Merci d'avance pour vos contributions !

$3
L’équipe Support de Wikia
<http://communaute.wikia.com/wiki/Utilisateur:$4>

___________________________________________
* Vous souhaitez recevoir moins de notifications de notre part ? Vous pouvez vous désabonner ou modifier vos préférences e-mail ici : http://community.wikia.com/Special:Preferences",
	'autocreatewiki-welcometalk-wall-title' => 'Bienvenue !',
	'autocreatewiki-welcometalk-wall' => "Bonjour !

Nous sommes heureux d'accueillir {{subst:SITENAME}} dans la communauté Wikia ! Voici quelques liens et astuces utiles qui vous permettront de dynamiser et gérer votre wikia :

*Vous n'êtes pas sûr de savoir par où commencer ? Arrêtez-vous sur le [[w:fr:Accueil|Centre des communautés]] et lisez le blog « [[w:fr:Blog:Conseils pour fondateurs/administrateurs|Conseils pour fondateurs et administrateurs]] ». Vous y trouverez des astuces pour démarrer votre wikia et le faire évoluer.
*Consultez l'[[w:fr:Blog:Actualité Wikia|actualité Wikia]] pour vous tenir informé des derniers événements.
*Explorez le [[w:fr:Special:Forum|forum]] sur le Centre des communautés pour voir quelles questions posent les autres administrateurs.
*Personnalisez l'apparence de votre wikia en visitant le [[Special:ThemeDesigner|Concepteur de thème]] : ajoutez des couleurs, modifiez l'arrière-plan et le logo etc.
*Consultez la page [[Special:WikiFeatures|Composants de wikia]] pour découvrir quelles fonctionnalités vous pouvez activer sur votre wikia.
*Pour finir, parcourez les [[Aide:Contenu|pages d'aide]] pour trouver des réponses à vos questions.

Tous les liens ci-dessus sont un bon moyen de commencer à naviguer sur Wikia. Si vous êtes bloqué ou si vous avez toujours des questions, [[Special:Contact|contactez-nous]]. Mais le plus important est que vous vous amusiez !

Bonnes modifications !",
	'autocreatewiki-welcometalk' => "==Bienvenue !==
Bonjour !

Nous sommes heureux d'accueillir $4 dans la communauté Wikia ! Voici quelques liens et astuces utiles qui vous permettront de dynamiser et gérer votre wikia :

*Vous n'êtes pas sûr de savoir par où commencer ? Arrêtez-vous sur le [[w:fr:Accueil|Centre des communautés]] et lisez le blog « [[w:fr:Blog:Conseils pour fondateurs/administrateurs|Conseils pour fondateurs et administrateurs]] ». Vous y trouverez des astuces pour démarrer votre wikia et le faire évoluer.
*Consultez l'[[w:fr:Blog:Actualité Wikia|actualité Wikia]] pour vous tenir informé des derniers événements.
*Explorez le [[w:fr:Special:Forum|forum]] sur le Centre des communautés pour voir quelles questions posent les autres administrateurs.
*Personnalisez l'apparence de votre wikia en visitant le [[Special:ThemeDesigner|Concepteur de thème]] : ajoutez des couleurs, modifiez l'arrière-plan et le logo etc.
*Consultez la page [[Special:WikiFeatures|Composants de wikia]] pour découvrir quelles fonctionnalités vous pouvez activer sur votre wikia.
*Pour finir, parcourez les [[Aide:Contenu|pages d'aide]] pour trouver des réponses à vos questions.

Tous les liens ci-dessus sont un bon moyen de commencer à naviguer sur Wikia. Si vous êtes bloqué ou si vous avez toujours des questions, [[Special:Contact|contactez-nous]]. Mais le plus important est que vous vous amusiez !

Bonnes modifications !

— [[User:$2|$3]] <staff /></div>",
	'autocreatewiki-language-top-list' => 'de,en,es,fr,it,ja,pl,pt-br,ru,zh',
);

/** Western Frisian (Frysk)
 * @author Robin0van0der0vliet
 */
$messages['fy'] = array(
	'cnw-next' => 'Folgjende',
	'cnw-back' => 'Foarige',
	'cnw-or' => 'of',
	'cnw-login' => 'Oanmelde',
	'cnw-desc-tip2' => 'Psst',
	'cnw-desc-lang' => 'Taal',
);

/** Galician (galego)
 * @author Elisardojm
 * @author Toliño
 * @author Vivaelcelta
 */
$messages['gl'] = array(
	'createnewwiki-desc' => 'Asistente para a creación de wikis',
	'cnw-next' => 'Seguinte',
	'cnw-back' => 'Volver',
	'cnw-or' => 'ou',
	'cnw-title' => 'Crear un novo wiki',
	'cnw-name-wiki-headline' => 'Comezar un wiki',
	'cnw-name-wiki-creative' => 'Wikia é o mellor sitio para construír unha páxina web e facer medrar unha comunidade ao redor do tema que lle gusta.',
	'cnw-name-wiki-label' => 'Déalle un nome ao seu wiki',
	'cnw-name-wiki-domain-label' => 'Déalle un enderezo ao seu wiki',
	'cnw-name-wiki-submit-error' => 'Vaites! Ten que encher as dúas caixas superiores para poder continuar.',
	'cnw-login' => 'Rexistro',
	'cnw-signup' => 'Crear unha conta',
	'cnw-signup-prompt' => 'Necesita unha conta?',
	'cnw-call-to-signup' => 'Rexístrese aquí',
	'cnw-login-prompt' => 'Xa ten unha conta?',
	'cnw-call-to-login' => 'Acceder ao sistema',
	'cnw-auth-headline' => 'Rexistro',
	'cnw-auth-headline2' => 'Rexistrarse',
	'cnw-auth-creative' => 'Acceda á súa conta para continuar a construción do seu wiki.',
	'cnw-auth-signup-creative' => 'Necesitará unha conta para continuar a construción do seu wiki.<br />Tardará soamente un minuto en completar o rexistro!',
	'cnw-auth-facebook-signup' => 'Rexístrese co Facebook',
	'cnw-auth-facebook-login' => 'Acceda co Facebook',
	'cnw-userauth-headline' => 'Ten unha conta?',
	'cnw-userauth-creative' => 'Acceder ao sistema',
	'cnw-userauth-marketing-heading' => 'Non está rexistrado?',
	'cnw-userauth-marketing-body' => 'Necesita unha conta para crear un wiki en Wikia. Leva un minuto rexistrarse!',
	'cnw-userauth-signup-button' => 'Rexístrese',
	'cnw-desc-headline' => 'De que vai o seu wiki?',
	'cnw-desc-creative' => 'Describa o seu tema',
	'cnw-desc-placeholder' => 'Isto aparecerá na páxina principal do seu wiki.',
	'cnw-desc-tip1' => 'Suxestión',
	'cnw-desc-tip1-creative' => 'Use este espazo para contar á xente de que vai o wiki nunha ou dúas oracións',
	'cnw-desc-tip2' => 'Consello',
	'cnw-desc-tip2-creative' => 'Dea aos visitantes algúns detalles específicos sobre o tema',
	'cnw-desc-select-vertical' => 'Seleccione unha categoría Hub',
	'cnw-desc-select-one' => 'Seleccione unha',
	'cnw-desc-all-ages' => 'Todas as idades',
	'cnw-desc-tip-all-ages' => 'Este wiki trata un tema de interese para os nenos? Para axudarnos a cumprir coa lei dos EUA, levamos un seguimento dos wikis sobre temas dirixidos directamente a cativos de 12 anos ou menos.',
	'cnw-desc-default-lang' => 'O seu wiki será en $1',
	'cnw-desc-change-lang' => 'cambiar',
	'cnw-desc-lang' => 'Lingua',
	'cnw-desc-wiki-submit-error' => 'Seleccione unha categoría',
	'cnw-theme-headline' => 'Escolla un tema visual',
	'cnw-theme-creative' => 'Escolla un dos temas visuais que hai a continuación; verá unha vista previa do tema cando o seleccione.',
	'cnw-theme-instruction' => 'Tamén pode deseñar o seu propio tema visual máis tarde indo ata "As miñas ferramentas".',
	'cnw-welcome-headline' => 'Parabéns! Creouse $1',
	'cnw-welcome-instruction1' => 'Prema no botón que hai a continuación para comezar a engadir páxinas ao seu wiki.',
	'cnw-welcome-help' => 'Atope respostas, consellos e máis cousas na <a href="http://community.wikia.com">central da comunidade</a>.',
	'cnw-error-general' => 'Vaites! Fixemos algo mal pola nosa parte! Inténtao de novo ou [[Special:Contact|ponte en contacto con nós]] para solicitar axuda.',
	'cnw-error-general-heading' => 'As nosas desculpas',
	'cnw-badword-header' => 'Vaites!',
	'cnw-badword-msg' => 'Por favor, abstéñase de empregar palabras groseiras na descrición do seu wiki: $1',
	'cnw-error-wiki-limit-header' => 'Alcanzouse o límite de wikis',
	'cnw-error-wiki-limit' => 'Desculpe, hai un límite que impide crear máis {{PLURAL:$1|de $1 wiki|de $1 wikis}} ao día. Agarde 24 horas antes de crear outro wiki.',
	'cnw-error-blocked-header' => 'Conta bloqueada',
	'cnw-error-blocked' => 'Foi bloqueado por $1. A razón que deu foi: $2. (ID do bloqueo para referencia: $3)',
	'cnw-error-anon-user-header' => 'Inicia a sesión',
	'cnw-error-anon-user' => 'A creación de wikis está desactivada para os anónimos. [[Special:UserLogin|Inicia a sesión]] e inténtao de novo.',
	'cnw-error-torblock' => 'Non está permitido crear wikis a través da rede Tor.',
	'cnw-error-bot' => 'Detectamos que pode ser un bot. Se estamos equivocados, póñase en contacto con nós indicando que foi detectado de xeito erróneo como un bot e axudarémolo a crear o seu wiki: [http://www.wikia.com/Special:Contact/general Contacte con nós]',
	'cnw-error-bot-header' => 'Detectamos que é un bot',
	'cnw-error-unconfirmed-email-header' => 'Non confirmou o seu correo electrónico',
	'cnw-error-unconfirmed-email' => 'Debe confirmar o seu correo electrónico para crear un wiki.',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author LaG roiL
 * @author שומבלע
 */
$messages['he'] = array(
	'createnewwiki-desc' => 'אשף יצירת ויקי',
	'cnw-next' => 'הבא',
	'cnw-back' => 'הקודם',
	'cnw-or' => 'או',
	'cnw-title' => 'יצירת ויקי חדש',
	'cnw-name-wiki-headline' => 'להתחיל ויקי',
	'cnw-name-wiki-creative' => 'ויקיה – המקום הטוב ביותר לבנות אתר ולטפל קהילה סביב דברים שאתם אוהבים.',
	'cnw-name-wiki-label' => 'שם הוויקי',
	'cnw-name-wiki-domain-label' => 'כתובת הוויקי',
	'cnw-name-wiki-submit-error' => 'אוי! צריך למלא את שתי התיבות למעל כדי להמשיך.',
	'cnw-login' => 'כניסה',
	'cnw-signup' => 'יצירת חשבון',
	'cnw-signup-prompt' => 'צריכים חשבון?',
	'cnw-call-to-signup' => 'להירשם כאן',
	'cnw-login-prompt' => 'כבר יש לכם חשבון?',
	'cnw-call-to-login' => 'להיכנס כאן',
	'cnw-auth-headline' => 'כניסה',
	'cnw-auth-headline2' => 'הרשמה',
	'cnw-auth-creative' => 'כניסה לחשבון כדי להמשיך לבנות את הוויקי שלכם',
	'cnw-auth-signup-creative' => 'צריך חשבון כדי להמשיך לבנות את הוויקי שלכם.<br />לוקח רק דקה להירשם!',
	'cnw-auth-facebook-signup' => 'הרשמה עם פייסבוק',
	'cnw-auth-facebook-login' => 'התחברות עם פייסבוק',
	'cnw-userauth-headline' => 'בעל/ת חשבון?',
	'cnw-userauth-creative' => 'כניסה לחשבון',
	'cnw-userauth-marketing-heading' => 'אין לך חשבון?',
	'cnw-userauth-marketing-body' => 'נדרש חשבון ליצירת מיזם ויקי בוויקיה. הרשמה לוקחת דקה בלבד!',
	'cnw-userauth-signup-button' => 'הרשמה',
	'cnw-desc-headline' => 'על מה הוויקיה שלכם?',
	'cnw-desc-creative' => 'התיאור שלכם יסייע לאנשים למצוא את הוויקיה',
	'cnw-desc-placeholder' => 'זה יופיע בדף הראשי של הוויקי שלכם.',
	'cnw-desc-tip1' => 'עצה',
	'cnw-desc-tip1-creative' => 'השתמשו בשדה זה כדי לספר לאנשים על הוויקיה שלכם במשפט אחד או שניים',
	'cnw-desc-tip2' => 'אהם־אהם',
	'cnw-desc-tip2-creative' => 'תנו למבקרים שלכם כמה פרטים על הנושא שלכם',
	'cnw-desc-select-vertical' => 'בחירת קטגוריה',
	'cnw-desc-select-categories' => 'בחירת קטגוריות נוספות',
	'cnw-desc-select-one' => 'לבחור אחת',
	'cnw-desc-all-ages' => 'האם המיזם מיועד לילדים?',
	'cnw-desc-tip-all-ages' => 'האם עוסק המיזם בנושא המעניין ילדים? בהתאם לחוק בארה"ב, אנו עוקבים אחרי מיזמי ויקיה על נושאים הפונים באופן ישיר לילדים בני 12 ומטה.',
	'cnw-desc-default-lang' => 'הוויקי שלכם יהיה ב$1',
	'cnw-desc-change-lang' => 'לשנות',
	'cnw-desc-lang' => 'שפה',
	'cnw-desc-wiki-submit-error' => 'נא לבחור קטגוריה',
	'cnw-theme-headline' => 'נא לבחור ערכת עיצוב',
	'cnw-theme-creative' => 'נא לבחור באחת מערכות העיצוב להלן. אפשר יהיה לראות תצוגה מקדימה של כל ערכה תוך כדי הבחירה.',
	'cnw-theme-instruction' => 'אפשר גם לעצב ערכת עיצוב משלכם דרך "הכלים שלי".',
	'cnw-welcome-headline' => 'ברכות! הוויקי $1 נוצר',
	'cnw-welcome-instruction1' => 'לחצו על הכפתור להלן כדי להתחיל להוסיף דפים לוויקי שלכם.',
	'cnw-welcome-help' => 'מצאו תשובות, עצות ועוד ב־<a href="http://community.wikia.com">Community Central</a>.',
	'cnw-badword-msg' => 'שלום, נא להימנע משימוש במילים הגסות או האסורות להלן בתיאור הוויקיה: $1',
	'cnw-error-wiki-limit' => 'שלום, הינך מוגבל ליצירת {{PLURAL:$1|$1 ויקיה אחת|$1 ויקיות}} ביום. נא להמתין 24 שעות לפני יצירת ויקיה נוספת.',
	'cnw-error-blocked-header' => 'חשבונך חסום',
	'cnw-error-blocked' => 'נחסמת על ידי $1. הסיבה לכך היא: $2. (מספר החסימה: $3)',
	'cnw-error-anon-user-header' => 'נא להיכנס לחשבון',
	'cnw-error-anon-user' => 'למשתמשים אנונימיים לא ניתן ליצור ויקיות. נא [[Special:UserLogin|להיכנס לחשבון]] ולנסות שוב.',
	'cnw-error-torblock' => 'יצירת ויקיות דרך רשת Tor אסורה.',
	'cnw-error-unconfirmed-email-header' => 'כתובת הדוא"ל שלך לא אומתה',
	'cnw-error-unconfirmed-email' => 'יש לאמת את כתובת הדוא"ל שלך על מנת ליצור ויקי.',
);

/** Hungarian (magyar)
 * @author Dani
 * @author Dj
 * @author TK-999
 * @author Tacsipacsi
 */
$messages['hu'] = array(
	'createnewwiki-desc' => 'Wikikészítő varázsló',
	'cnw-next' => 'Következő',
	'cnw-back' => 'Vissza',
	'cnw-or' => 'vagy',
	'cnw-title' => 'Új wiki létrehozása',
	'cnw-name-wiki-headline' => 'Wiki indítása',
	'cnw-name-wiki-creative' => 'Wikia a legjobb hely, ha kedvenc témádnak egy új weboldalt akarsz készíteni, és közösséget építeni hozzá.',
	'cnw-name-wiki-label' => 'A wikiád neve',
	'cnw-name-wiki-domain-label' => 'Adj a wikiádnak egy címet',
	'cnw-name-wiki-submit-error' => 'Hoppá! Ki kell töltened mindkét fenti mezőt a folytatáshoz.',
	'cnw-login' => 'Bejelentkezés',
	'cnw-signup' => 'Fiók létrehozása',
	'cnw-signup-prompt' => 'Fiókra van szükséged?',
	'cnw-call-to-signup' => 'Itt regisztrálhatsz',
	'cnw-login-prompt' => 'Már van fiókod?',
	'cnw-call-to-login' => 'Itt bejelentkezhetsz',
	'cnw-auth-headline' => 'Bejelentkezés',
	'cnw-auth-headline2' => 'Regisztráció',
	'cnw-auth-creative' => 'Lépj be a felhasználói fiókodba, hogy folytathasd a wikid építését.',
	'cnw-auth-signup-creative' => 'Szükséged lesz egy felhasználói fiókra a wikid építésének folytatásához.<br />Egy perc alatt regisztrálhatsz!',
	'cnw-auth-facebook-signup' => 'Regisztráció Facebookkal',
	'cnw-auth-facebook-login' => 'Bejelentkezés Facebookkal',
	'cnw-userauth-headline' => 'Van már felhasználói fiókod?',
	'cnw-userauth-creative' => 'Bejelentkezés',
	'cnw-userauth-marketing-heading' => 'Még nem regisztráltál?',
	'cnw-userauth-marketing-body' => 'Felhasználói fiókra van szükséged, hogy wikit hozhass létre a Wikián. Csak egy percbe telik a regisztráció!',
	'cnw-userauth-signup-button' => 'Regisztráció',
	'cnw-desc-headline' => 'Miről szól a wikiád?',
	'cnw-desc-creative' => 'Írd körül a témát',
	'cnw-desc-placeholder' => 'Ez a wiki kezdőlapján fog megjelenni.',
	'cnw-desc-tip1' => 'Itt egy tipp!',
	'cnw-desc-tip1-creative' => 'Itt egy-két mondatban mesélj az wikiádról az idelátogató embereknek',
	'cnw-desc-tip2' => 'Pszt',
	'cnw-desc-tip2-creative' => 'Közölj a látogatókkal valami egyedi részletet a témádról',
	'cnw-desc-select-one' => 'Válassz egyet',
	'cnw-desc-default-lang' => 'A wikid a $1 kategóriába lesz',
	'cnw-desc-change-lang' => 'módosítás',
	'cnw-desc-lang' => 'Nyelv',
	'cnw-desc-wiki-submit-error' => 'Válassz egy kategóriát',
	'cnw-theme-headline' => 'Válassz egy témát',
	'cnw-theme-creative' => 'Válassz az alábbi témák közöl. Ha kiválasztasz egy témát, akkor annak látható lesz az előnézeti képe.',
	'cnw-theme-instruction' => 'Saját stílusodat később is megtervezheted a "My Tools" eszköztáron keresztül.',
	'cnw-welcome-headline' => 'Gratulálunk!A(z) $1 létrehozása sikerült.',
	'cnw-welcome-instruction1' => 'Kattints a lenti gombra, hogy elkezdd a lapok hozzáadását a wikidhez.',
	'cnw-welcome-help' => 'Keress válaszokat, tanácsot és sok mást a <a href="http://community.wikia.com">Community Central</a> wikin.',
	'cnw-error-general' => 'Valami hiba történt a wikid létrehozása közben. Kérlek, próbáld újra később.',
	'cnw-error-general-heading' => 'Elnézést',
	'cnw-badword-header' => 'Hoppácska',
	'cnw-badword-msg' => 'Szia, légyszíves tartózkodj a csúnya és tiltott szavak használatától a Wiki leírásban: $1',
	'cnw-error-wiki-limit-header' => 'Wiki korlátot elérte',
	'cnw-error-wiki-limit' => 'Szia! Naponta csak {{PLURAL:$1|egy|$1}} wikit hozhatsz létre. Várj 24 órát, mielőtt alapítanál egy újabbat.',
	'cnw-error-blocked-header' => 'Letiltott fiók',
	'cnw-error-blocked' => '$1 letiltotta a fiókodat. A megadott indok: $2. (Tiltás azonosító: $3)',
	'cnw-error-torblock' => 'Wiki létrehozása Tor hálózatból nem engedélyezett.',
	'cnw-error-bot' => 'Lehetséges botként azonosítottunk  Amennyiben tévedtünk, kérlek, lépj kapcsolatba velünk, elmondva, hogy helytelenül botként azonosítottunk, és segítünk a wikid létrehozásában: [http://www.wikia.com/Special:Contact/general Kapcsolat]',
	'cnw-error-bot-header' => 'Botként azonosítva',
);

/** Armenian (Հայերեն)
 * @author M hamlet
 */
$messages['hy'] = array(
	'cnw-error-anon-user-header' => 'Խնդրում ենք, մուտք գործեք',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'createnewwiki-desc' => 'Assistente pro crear wikis',
	'cnw-next' => 'Sequente',
	'cnw-back' => 'Retornar',
	'cnw-or' => 'o',
	'cnw-title' => 'Crear nove wiki',
	'cnw-name-wiki-headline' => 'Comenciar un wiki',
	'cnw-name-wiki-creative' => 'Wikia es le optime loco pro construer un sito web e cultivar un communitate circa lo que tu ama.',
	'cnw-name-wiki-label' => 'Nomina tu wiki',
	'cnw-name-wiki-domain-label' => 'Da un adresse a tu wiki',
	'cnw-name-wiki-submit-error' => 'Ups! Es necessari completar ambe le quadros hic supra pro continuar.',
	'cnw-login' => 'Aperir session',
	'cnw-signup' => 'Crear conto',
	'cnw-signup-prompt' => 'Necessita un conto?',
	'cnw-call-to-signup' => 'Inscribe te hic',
	'cnw-login-prompt' => 'Tu jam ha un conto?',
	'cnw-call-to-login' => 'Aperi session hic',
	'cnw-auth-headline' => 'Aperir session',
	'cnw-auth-headline2' => 'Crear conto',
	'cnw-auth-creative' => 'Aperi session a tu conto pro continuar le construction de tu wiki.',
	'cnw-auth-signup-creative' => 'Es necessari haber un conto pro continuar le construction de tu wiki.<br />Le inscription prende solmente un minuta!',
	'cnw-auth-facebook-signup' => 'Crear conto con Facebook',
	'cnw-auth-facebook-login' => 'Aperir session con Facebook',
	'cnw-userauth-headline' => 'Ha un conto?',
	'cnw-userauth-creative' => 'Aperir session',
	'cnw-userauth-marketing-heading' => 'Non ha un conto?',
	'cnw-userauth-marketing-body' => 'Un conto es necessari pro crear un wiki in Wikia. Il prende solmente un minuta crear un conto!',
	'cnw-userauth-signup-button' => 'Crear un conto',
	'cnw-desc-headline' => 'Que es le thema de tu wiki?',
	'cnw-desc-creative' => 'Describe tu topico',
	'cnw-desc-placeholder' => 'Isto apparera in le pagina principal de tu wiki.',
	'cnw-desc-tip1' => 'Consilio',
	'cnw-desc-tip1-creative' => 'Usa iste spatio pro explicar le thema de tu wiki al visitatores in un phrase o duo',
	'cnw-desc-tip2' => 'Psst',
	'cnw-desc-tip2-creative' => 'Specifica al visitatores alcun detalios a proposito de tu thema',
	'cnw-desc-select-one' => 'Selige un',
	'cnw-desc-default-lang' => 'Tu wiki essera in $1',
	'cnw-desc-change-lang' => 'cambiar',
	'cnw-desc-lang' => 'Lingua',
	'cnw-desc-wiki-submit-error' => 'Per favor selige un categoria',
	'cnw-theme-headline' => 'Designar tu wiki',
	'cnw-theme-creative' => 'Selige un apparentia hic infra. Tu videra un previsualisation de cata apparentia quando tu lo selige.',
	'cnw-theme-instruction' => 'Es equalmente possibile designar tu proprie apparentia usante "Mi instrumentos".',
	'cnw-welcome-headline' => 'Felicitationes, tu ha create $1',
	'cnw-welcome-instruction1' => 'Clicca sur le button hic infra pro comenciar a adder paginas a tu wiki.',
	'cnw-welcome-help' => 'Trova responsas, consilios e plus in <a href="http://community.wikia.com">le centro del communitate</a>.',
	'cnw-error-general' => 'Qualcosa errava durante le creation de tu wiki. Per favor reproba plus tarde.',
	'cnw-error-general-heading' => 'Error de creation de nove wiki',
	'cnw-badword-header' => 'Stop!',
	'cnw-badword-msg' => 'Salute, per favor abstine te de usar le sequente parolas improprie o bannite in le description de tu wiki: $1',
	'cnw-error-wiki-limit-header' => 'Limite de wikis attingite',
	'cnw-error-wiki-limit' => 'Salute, tu es limitate al creation de $1 {{PLURAL:$1|wiki|wikis}} per die. Attende 24 horas ante de crear un altere wiki.',
	'cnw-error-blocked-header' => 'Conto blocate',
	'cnw-error-blocked' => '$1 te ha blocate, specificante le motivo: $2. (Le ID del blocada pro referentia: $3)',
	'cnw-error-torblock' => 'Le creation de wikis via le rete Tor non es permittite.',
	'cnw-error-bot' => 'Nos ha detegite que tu pote esser un robot. Si nos ha facite un error, per favor contacta nos indicante que tu ha essite detegite falsemente como robot, e nos te adjutara a crear tu wiki: [http://www.wikia.com/Special:Contact/general Contactar nos]',
	'cnw-error-bot-header' => 'Tu ha essite detegite como robot',
);

/** Indonesian (Bahasa Indonesia)
 * @author C5st4wr6ch
 * @author Fate Kage
 * @author Riemogerz
 */
$messages['id'] = array(
	'createnewwiki-desc' => 'Ahli pembuatan Wiki',
	'cnw-next' => 'Selanjutnya',
	'cnw-back' => 'Kembali',
	'cnw-or' => 'atau',
	'cnw-title' => 'Buat Wiki Baru',
	'cnw-name-wiki-headline' => 'Memulai sebuah Wiki',
	'cnw-name-wiki-creative' => 'Wikia adalah tempat terbaik untuk membangun sebuah situs web dan komunitas yang Anda suka.',
	'cnw-name-wiki-label' => 'Nama wiki Anda',
	'cnw-name-wiki-domain-label' => 'Berikan alamat ke wiki Anda',
	'cnw-name-wiki-submit-error' => 'Ups! Anda perlu mengisi kedua kotak di atas untuk terus berjalan.',
	'cnw-login' => 'Masuk Log',
	'cnw-signup' => 'Buat akun',
	'cnw-signup-prompt' => 'Membutuhkan akun?',
	'cnw-call-to-signup' => 'Mendaftar di sini',
	'cnw-login-prompt' => 'Sudah terdaftar sebagai pengguna?',
	'cnw-call-to-login' => 'Masuk log di sini',
	'cnw-auth-headline' => 'Masuk log',
	'cnw-auth-headline2' => 'Mendaftar',
	'cnw-auth-creative' => 'Masuk ke akun Anda untuk terus membangun wiki Anda.',
	'cnw-auth-signup-creative' => 'Anda akan memerlukan akun untuk terus membangun wiki Anda.<br />Hanya butuh satu menit untuk mendaftar!',
	'cnw-auth-facebook-signup' => 'Daftar dengan Facebook',
	'cnw-auth-facebook-login' => 'Masuk log dengan Facebook',
	'cnw-userauth-headline' => 'Memerlukan akun?',
	'cnw-userauth-creative' => 'Masuk log',
	'cnw-userauth-marketing-heading' => 'Belum memiliki akun?',
	'cnw-userauth-marketing-body' => 'Anda memerlukan sebuah akun untuk membuat wiki di Wikia. Hanya butuh satu menit untuk mendaftar!',
	'cnw-userauth-signup-button' => 'Mendaftar',
	'cnw-desc-headline' => 'Tentang apa wikia Anda?',
	'cnw-desc-creative' => 'Deskripsi Anda akan membantu orang menemukan wikia Anda',
	'cnw-desc-placeholder' => 'Ini akan muncul pada halaman utama Anda wiki.',
	'cnw-desc-tip1' => 'Petunjuk',
	'cnw-desc-tip1-creative' => 'Gunakan ruang ini untuk memberitahu orang-orang tentang wikia Anda dalam satu atau dua kalimat',
	'cnw-desc-tip2' => 'Psst',
	'cnw-desc-tip2-creative' => 'Memberi pengunjung Anda beberapa rincian spesifik tentang subjek Anda',
	'cnw-desc-select-vertical' => 'Pilih Pusat Kategori',
	'cnw-desc-select-categories' => 'Pilih Kategori Tambahan',
	'cnw-desc-select-one' => 'Pilih salah satu',
	'cnw-desc-all-ages' => 'Apakah wikia ini ditujukan untuk anak-anak?',
	'cnw-desc-tip-all-ages' => 'Apakah wiki ini berisi tentang topik yang menarik bagi anak-anak? Untuk membantu kami mematuhi undang-undang AS kami melacak wiki-wiki tentang topik yang secara langsung menarik kepada anak-anak 12 tahun ke bawah.',
	'cnw-desc-default-lang' => 'Wiki Anda akan berada di $1',
	'cnw-desc-change-lang' => 'ubah',
	'cnw-desc-lang' => 'Bahasa',
	'cnw-desc-wiki-submit-error' => 'Silakan pilih kategori',
	'cnw-theme-headline' => 'Pilih tema',
	'cnw-theme-creative' => 'Pilih tema di bawah ini, Anda akan dapat melihat pratayang dari setiap tema yang Anda pilih.',
	'cnw-theme-instruction' => 'Anda juga dapat merancang tema Anda sendiri kemudian dengan pergi ke "Peralatanku".',
	'cnw-welcome-headline' => 'Selamat! $1 telah dibuat',
	'cnw-welcome-instruction1' => 'Klik tombol di bawah untuk memulai menambahkan halaman ke wiki Anda.',
	'cnw-welcome-help' => 'Temukan jawaban, saran, dan masih banyak lagi pada <a href="http://community.wikia.com">Community Central</a>.',
	'cnw-error-general' => 'Ups, ada sesuatu yang salah di pihak kami! Silakan coba lagi, atau [[Special:Contact|hubungi kami]] untuk bantuan.',
	'cnw-error-general-heading' => 'Permintaan maaf kami',
	'cnw-badword-header' => 'Wah ada',
	'cnw-badword-msg' => 'Hai, tolong jangan menggunakan kata-kata yang buruk atau kata-kata dilarang di Keterangan Wiki Anda: $1',
	'cnw-error-wiki-limit-header' => 'Wiki telah mencapai batas',
	'cnw-error-blocked-header' => 'Akun diblokir',
	'cnw-error-blocked' => 'Anda telah diblokir oleh $1. Alasan yang diberikan aadalah: $2. (ID Blok untuk referensi: $3)',
	'cnw-error-anon-user-header' => 'Silahkan masuk log',
	'cnw-error-anon-user' => 'Membuat wiki untuk anonim dinonaktifkan. Silahkan [[Special:UserLogin|masuk log]] dan coba lagi.',
	'cnw-error-torblock' => 'Membuat wiki melalui Jaringan Tor tidak diperbolehkan.',
	'cnw-error-bot' => 'Kami mendeteksi bahwa Anda mungkin bot. Jika kami melakukan kesalahan, silahkan hubungi kami dan menjelaskan bahwa Anda telah salah terdeteksi sebagai bot, dan kami akan membantu Anda dalam membuat wiki Anda: [http://www.wikia.com/Special:Contact/general Hubungi Kami]',
	'cnw-error-bot-header' => 'Anda telah terdeteksi sebagai bot',
	'cnw-error-unconfirmed-email-header' => 'Surel Anda tidak dikonfirmasi',
	'cnw-error-unconfirmed-email' => 'Surel Anda harus dikonfirmasi untuk membuat Wiki.',
);

/** Interlingue (Interlingue)
 * @author Makuba
 */
$messages['ie'] = array(
	'cnw-error-anon-user-header' => 'Ples inregistrar.',
	'cnw-error-anon-user' => 'Li creation de wikis por anonym usatores ha esset desactivat. Ples [[Special:UserLogin|inregistrar]] e prova denov.',
);

/** Ingush (ГӀалгӀай)
 * @author Sapral Mikail
 */
$messages['inh'] = array(
);

/** Italian (italiano)
 * @author Beta16
 * @author Gloria sah
 * @author Lexaeus 94
 * @author Minerva Titani
 */
$messages['it'] = array(
	'createnewwiki-desc' => 'Creazione guidata della wikia',
	'cnw-next' => 'Avanti',
	'cnw-back' => 'Indietro',
	'cnw-or' => 'oppure',
	'cnw-title' => 'Crea una nuova wikia',
	'cnw-name-wiki-headline' => 'Crea una wikia',
	'cnw-name-wiki-creative' => 'Wikia è il posto migliore per costruire un sito web e far crescere una community intorno alle tue passioni.',
	'cnw-name-wiki-label' => 'Dai un nome alla tua wikia',
	'cnw-name-wiki-domain-label' => 'Dai un indirizzo alla tua wikia',
	'cnw-name-wiki-submit-error' => 'Ops! Devi riempire entrambi i campi qui sopra per continuare.',
	'cnw-login' => 'Accedi',
	'cnw-signup' => 'Crea account',
	'cnw-signup-prompt' => 'Ti serve un account?',
	'cnw-call-to-signup' => 'Registrati qui',
	'cnw-login-prompt' => 'Hai già un account?',
	'cnw-call-to-login' => 'Accedi qui',
	'cnw-auth-headline' => 'Accedi',
	'cnw-auth-headline2' => 'Registrati',
	'cnw-auth-creative' => 'Accedi per continuare a costruire la tua wikia.',
	'cnw-auth-signup-creative' => 'Devi avere un account per continuare a costruire la tua wikia. <br />Basta solo un minuto per registrarsi!',
	'cnw-auth-facebook-signup' => 'Registrati con Facebook',
	'cnw-auth-facebook-login' => 'Accedi con Facebook',
	'cnw-userauth-headline' => 'Hai un account?',
	'cnw-userauth-creative' => 'Accedi',
	'cnw-userauth-marketing-heading' => 'Non hai un account?',
	'cnw-userauth-marketing-body' => 'Devi avere un account per creare una wikia su Wikia. Basta solo un minuto per registrarsi!',
	'cnw-userauth-signup-button' => 'Registrati',
	'cnw-desc-headline' => "Qual è l'argomento della tua wikia?",
	'cnw-desc-creative' => "Aiuta altri utenti a trovare la tua wikia grazie a un'eccellente descrizione.",
	'cnw-desc-placeholder' => 'Scrivilo bene! Questo testo apparirà nella pagina principale della tua wikia.',
	'cnw-desc-tip1' => 'Ti diamo un suggerimento.',
	'cnw-desc-tip1-creative' => "Utilizza questo spazio per descrivere l'importanza e lo scopo della tua wikia.",
	'cnw-desc-tip2' => 'Psst!',
	'cnw-desc-tip2-creative' => 'Incoraggia i visitatori a unirsi alla tua community offrendo dettagli sulla tua wikia.',
	'cnw-desc-select-one' => 'Scegline una',
	'cnw-desc-default-lang' => 'La tua wiki sarà in $1',
	'cnw-desc-change-lang' => 'cambia',
	'cnw-desc-lang' => 'Lingua',
	'cnw-desc-wiki-submit-error' => 'Scegli una categoria',
	'cnw-theme-headline' => 'Scegli un tema',
	'cnw-theme-creative' => "Cura l'aspetto della tua creazione! Scegli uno dei temi qui di seguito per vederne l'anteprima.",
	'cnw-theme-instruction' => 'Vuoi creare un tema personalizzato? Potrai farlo più avanti con il Theme Designer che si trova nel Pannello Admin.',
	'cnw-welcome-headline' => 'Complimenti! Hai creato $1',
	'cnw-welcome-instruction1' => 'Clicca il pulsante sottostante per iniziare a creare pagine nella tua wikia.',
	'cnw-welcome-help' => 'Puoi trovare risposte, consigli e altro nella <a href="http://it.community.wikia.com/wiki/Wiki_della_Community">Wiki della Community</a>.',
	'cnw-error-general' => 'Ops! Qualcosa non ha funzionato. Riprova più tardi o [[Special:Contact|contattaci]] per ricevere assistenza.',
	'cnw-error-general-heading' => 'Ci dispiace',
	'cnw-badword-header' => 'Hey!',
	'cnw-badword-msg' => 'Ciao. Per favore evita parole inappropriate o proibite nella descrizione della tua wikai: $1',
	'cnw-error-wiki-limit-header' => 'Limite massimo di wikia raggiunto',
	'cnw-error-wiki-limit' => "Ciao! Puoi creare fino a un massimo di {{PLURAL:$1|$1 wiki creation|$1 wiki creations}} al giorno. Attendi 24 ore prima di creare un'altra wikia.",
	'cnw-error-blocked-header' => 'Account bloccato',
	'cnw-error-blocked' => 'Sei stato bloccato da $1. La motivazione è la seguente: $2. (ID di riferimento del blocco: $3)',
	'cnw-error-anon-user-header' => 'Accedi, per favore',
	'cnw-error-torblock' => 'Non è permesso creare wikia tramite la rete Tor.',
	'cnw-error-bot' => 'Ti abbiamo identificato come un probabile bot. Se si tratta di un errore, contattaci per spiegare che sei stato erroneamente rilevato come bot e ti aiuteremo a creare la tua wikia: [http://www.wikia.com/Special:Contact/general_Contattaci]',
	'cnw-error-bot-header' => 'Sei stato identificato come un bot',
	'cnw-error-unconfirmed-email-header' => 'Il tuo indirizzo email non è stato confermato',
	'cnw-error-unconfirmed-email' => 'Il tuo indirizzo email deve essere confermato per creare una wikia.',
	'cnw-name-wiki-language' => '',
	'cnw-name-wiki-domain' => '.wikia.com',
	'cnw-desc-select-vertical' => "Seleziona una categoria dell'Hub",
	'cnw-desc-select-categories' => 'Seleziona una o più categorie aggiuntive',
	'cnw-desc-all-ages' => 'Questa wikia è per bambini?',
	'cnw-desc-tip-all-ages' => "Riguarda un tema d'interesse per il pubblico infantile? In osservanza delle leggi degli Stati Uniti, monitoriamo le wikia che riguardano tematiche che attirano bambini di età fino ai 12 anni.",
	'cnw-error-anon-user' => 'La creazione di wikia da parte di utenti anonimi è stata disattivata.  [[Special:UserLogin|Accedi]] e riprova.',
	'autocreatewiki' => 'Crea una nuova wikia',
	'autocreatewiki-desc' => "Crea una wikia in WikiFactory su richiesta dell'utente",
	'autocreatewiki-page-title-default' => 'Crea una nuova wikia',
	'autocreatewiki-page-title-answers' => 'Crea un nuovo sito di Wiki risposte',
	'createwiki' => 'Crea una nuova wikia',
	'autocreatewiki-chooseone' => 'Scegline una',
	'autocreatewiki-required' => '$1 = obbligatorio',
	'autocreatewiki-web-address' => 'Indirizzo web:',
	'autocreatewiki-category-select' => 'Scegline una',
	'autocreatewiki-language-top' => '$1 lingue principali',
	'autocreatewiki-language-all' => 'Tutte le lingue',
	'autocreatewiki-remember' => 'Ricordami',
	'autocreatewiki-create-account' => 'Crea un account',
	'autocreatewiki-haveaccount-question' => 'Hai già un account Wikia?',
	'autocreatewiki-info-domain' => 'È meglio usare una parola che sia una possibile parola chiave per le ricerche sul tuo argomento.',
	'autocreatewiki-info-topic' => 'Aggiungi una breve descrizione come "Guerre stellari" o "Spettacoli televisivi".',
	'autocreatewiki-info-category-default' => 'Aiuterà i visitatori a trovare la tua wikia.',
	'autocreatewiki-info-category-answers' => 'Aiuterà i visitatori a trovare il tuo sito di Wiki risposte.',
	'autocreatewiki-info-language' => 'Questa sarà la lingua di default per i visitatori della tua wikia.',
	'autocreatewiki-info-email-address' => 'Il tuo indirizzo email non viene mai mostrato agli utenti di Wikia.',
	'autocreatewiki-info-realname' => 'Se scegli di fornirlo, verrà usato per attribuirti il lavoro svolto.',
	'autocreatewiki-info-birthdate' => "Wikia richiede che tutti gli utenti forniscano la loro data di nascita effettiva, sia come misura di sicurezza sia come un modo per preservare l'integrità del sito nel rispetto delle regole federali.",
	'autocreatewiki-info-blurry-word' => 'Per aiutarci a contrastare la creazione automatica di account, inserisci la parola sfuocata che vedi in questo campo.',
	'autocreatewiki-info-terms-agree' => "Con la creazione di una wikia e di un account utente, accetti i {{#NewWindowLink: w:Terms of use | Wikia's Terms of Use}}",
	'autocreatewiki-info-staff-username' => "<b>Solo staff:</b> L'utente specificato verrà indicato come il fondatore.",
	'autocreatewiki-title-template' => '$1 Wikia',
	'autocreatewiki-tagline' => '',
	'autocreatewiki-limit-day' => 'Oggi Wikia ha superato il numero massimo di creazione di wikia ($1).',
	'autocreatewiki-limit-creation' => 'Hai superato il numero massimo di creazione di wikia in 24 ore ($1).',
	'autocreatewiki-empty-field' => 'Completa questo campo.',
	'autocreatewiki-bad-name' => 'Il nome non può contenere caratteri speciali (come $ o @) e deve essere una singola parola minuscola senza spazi.',
	'autocreatewiki-invalid-wikiname' => 'Il nome non può contenere caratteri speciali (come $ o @) e non può essere vuoto.',
	'autocreatewiki-violate-policy' => 'Il nome di questa wikia contiene una parola che viola la nostra politica di denominazione.',
	'autocreatewiki-name-taken' => 'C\'è già una wikia con questo indirizzo. Contribuisci a <a href="http://$1.wikia.com">http://$1.wikia.com</a> o scegli un altro indirizzo.',
	'autocreatewiki-name-too-short' => 'Questo indirizzo è troppo breve. Scegli un indirizzo di almeno 3 caratteri.',
	'autocreatewiki-name-too-long' => 'Questo indirizzo è troppo lungo. Scegli un indirizzo con un massimo di 50 caratteri.',
	'autocreatewiki-similar-wikis' => 'Di seguito trovi le wikia già create su questo argomento. Ti consigliamo di contribuire a una di queste.',
	'autocreatewiki-invalid-username' => 'Questo nome utente non è valido.',
	'autocreatewiki-busy-username' => 'Questo nome utente è già in uso.',
	'autocreatewiki-blocked-username' => 'Non puoi creare un account.',
	'autocreatewiki-user-notloggedin' => "Il tuo account è stato creato ma non hai eseguito l'accesso!",
	'autocreatewiki-empty-language' => 'Scegli la lingua per la wikia.',
	'autocreatewiki-empty-category' => 'Scegli una categoria.',
	'autocreatewiki-empty-wikiname' => 'Il nome della wiki non può essere vuoto.',
	'autocreatewiki-empty-username' => 'Il nome utente non può essere vuoto.',
	'autocreatewiki-empty-password' => 'La password non può essere vuota.',
	'autocreatewiki-empty-retype-password' => 'La ripetizione della password non può essere vuota.',
	'autocreatewiki-category-label' => 'Categoria:',
	'autocreatewiki-category-other' => 'Altro',
	'autocreatewiki-set-username' => 'Prima imposta il nome utente.',
	'autocreatewiki-invalid-category' => 'Categoria non valida.
Scegline una dal menu a comparsa.',
	'autocreatewiki-invalid-language' => 'Lingua non valida.
Scegline una dal menu a comparsa.',
	'autocreatewiki-invalid-retype-passwd' => 'Ripeti la stessa password di prima.',
	'autocreatewiki-invalid-birthday' => 'Data di nascita non valida',
	'autocreatewiki-log-title' => 'Stiamo creando la tua wiki',
	'autocreatewiki-step0' => 'Inizializzazione del processo...',
	'autocreatewiki-stepdefault' => 'Il processo è in corso, attendere prego...',
	'autocreatewiki-errordefault' => 'Il processo non è ancora completato...',
	'autocreatewiki-step1' => 'Creazione della cartella delle immagini...',
	'autocreatewiki-step2' => 'Creazione del database...',
	'autocreatewiki-step3' => 'Impostazione delle informazioni di default nel database...',
	'autocreatewiki-step4' => 'Copia delle immagini e del logo di default...',
	'autocreatewiki-step5' => 'Impostazione delle variabili di default nel database...',
	'autocreatewiki-step6' => 'Impostazione delle tabelle di default nel database...',
	'autocreatewiki-step7' => 'Impostazione dei dati iniziali della lingua...',
	'autocreatewiki-step8' => 'Impostazione dei gruppi utente e delle categorie...',
	'autocreatewiki-step9' => 'Impostazione delle variabili per la nuova wikia...',
	'autocreatewiki-step10' => 'Impostazione delle pagine nella wikia centrale...',
	'autocreatewiki-step11' => "Invio dell'email all'utente...",
	'autocreatewiki-redirect' => 'Reindirizzamento alla nuova wikia: $1...',
	'autocreatewiki-congratulation' => 'Congratulazioni!',
	'autocreatewiki-welcometalk-log' => 'Messaggio di benvenuto',
	'autocreatewiki-regex-error-comment' => 'usato nella wikia $1 (testo completo: $2)',
	'autocreatewiki-step2-error' => 'Il database esiste già!',
	'autocreatewiki-step3-error' => 'Impossibile impostare le informazioni di default nel database!',
	'autocreatewiki-step6-error' => 'Impossibile impostare le tabelle di default nel database!',
	'autocreatewiki-step7-error' => 'Impossibile copiare il database dei dati iniziali per la lingua!',
	'requestwiki-filter-language' => 'als,an,ang,ast,bar,de2,de-at,de-ch,de-formal,de-weigsbrag,dk,en-gb,eshelp,fihelp,frc,frhelp,ia,ie,ithelp,jahelp,kh,kohelp,kp,ksh,nb,nds,nds-nl,mu,mwl,nlhelp,pdc,pdt,pfl,pthelp,pt-brhelp,ruhelp,simple,tokipona,tp,zh-classical,zh-cn,zh-hans,zh-hant,zh-hk,zh-min-nan,zh-mo,zh-my,zh-sg,zh-tw,zh-yue',
	'autocreatewiki-protect-reason' => "Parte dell'interfaccia ufficiale",
	'autocreatewiki-welcomesubject' => '$1 è stata creata!',
	'autocreatewiki-welcomebody' => 'Ciao, $2!

La tua wikia è stata creata. Puoi trovarla qui: <$1>

Ti va di cominciare? Abbiamo aggiunto alcuni link alla tua pagina di discussione (<$5>) per darti una mano e per incoraggiarti a esplorare tutte le aree di Wikia. Per qualunque domanda o problema, rispondi a questa email o consulta le nostre pagine di Aiuto <http://help.wikia.com>.

Puoi inoltre visitare il Blog degli amministratori
<http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins> e il blog dello staff di Wikia <http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog> dove troverai suggerimenti e trucchi, oltre alle info sulle novità di Wikia.

Buon lavoro!

$3

Supporto comunitario di Wikia
<http://www.wikia.com/wiki/User:$4>

___________________________________________
* Vuoi ricevere meno messaggi da noi? Puoi modificare le preferenze sulla ricezione delle email qui: http://community.wikia.com/Special:Preferences/it',
	'autocreatewiki-welcometalk-wall-title' => 'Ti diamo il benvenuto!',
	'autocreatewiki-welcometalk-wall' => "Ciao. Siamo molto contenti di avere {{subst:SITENAME}} nella community di Wikia!

C'è ancora molto da fare; perciò ti vogliamo dare alcuni suggerimenti e link utili per mettere in moto la tua wikia:
*Dai un'occhiata a [[Special:WikiFeatures|Wiki Funzioni]] per vedere le funzioni che puoi attivare sulla tua wikia, come Chat, Successi e molto altro.
*Personalizza l'aspetto della tua wikia tramite il [[Special:ThemeDesigner|Theme Designer]] che ti permette di cambiare il colore e lo stile del tuo sfondo e del tuo logo.
*Fai un salto nella [[w:c:it.community|Wiki della Community]] per tenerti informato tramite il nostro [[w:c:it.community:Blog:Wikia_Staff_Blog|Blog ufficiale di Wikia Italia]], per fare delle domande nel [[w:c:it.community:Special:Forum|Forum della Community]], per partecipare ai nostri [[w:c:it.community:Help:Webinars|webinar]] o alla [[w:c:it.community:Special:Chat|chat]] con altri utenti di Wikia.
*Per finire, visita le nostre [[Help:Contents|pagine di aiuto]] per imparare al meglio come funziona Wikia: per esempio, [[Help:New page|come aggiungere una pagina alla tua wikia]], [[Help:Attracting contributors|come attrarre nuovi utenti]] e [[Help:User access levels|come aggiungere altri amministratori]].
* Puoi anche usare tutti questi strumenti esplorando il tuo Pannello di controllo Admin che troverai cliccando su \"Pannello Admin\" nella barra degli strumenti in basso.

Tutti questi link sono un buon punto di partenza per entrare nel mondo di Wikia e iniziare a divertirsi!",
	'autocreatewiki-welcometalk' => "==Ti diamo il benvenuto!==
Ciao!

Siamo molto contenti di avere $4 nella community di Wikia! C'è ancora molto da fare, perciò ti vogliamo dare alcuni suggerimenti e link utili per mettere in moto la tua wikia:

*Dai un'occhiata a [[Special:WikiFeatures|Wiki Funzioni]] per vedere le funzioni che puoi attivare sulla tua wikia, come Chat, Successi e molto altro.
*Fai un salto nella [[w:c:it.community|Wiki della Community]] per tenerti informato tramite il nostro [[w:c:it.community:Blog:Wikia_Staff_Blog|Blog ufficiale di Wikia Italia]], per fare delle domande nel [[w:c:it.community:Special:Forum|Forum della Community]], per partecipare ai nostri [[w:c:it.community:Help:Webinars|webinar]] o alla [[w:c:it:community:Special:Chat|chat]] con altri utenti di Wikia.
*Per finire, visita le nostre [[Help:Contents|pagine di aiuto]] per imparare al meglio come funziona Wikia.

Tutti questi link sono un buon punto di partenza per entrare nel mondo di Wikia e iniziare a divertirsi!

-- [[User:$2|$3]] <staff />",
	'autocreatewiki-language-top-list' => 'de,en,es,fr,it,ja,pl,pt-br,ru,zh',
);

/** Japanese (日本語)
 * @author Barrel0116
 * @author BryghtShadow
 * @author Shirayuki
 * @author Tommy6
 * @author Wrightbus
 */
$messages['ja'] = array(
	'createnewwiki-desc' => 'ウィキア作成ウィザード',
	'cnw-next' => '次へ',
	'cnw-back' => '戻る',
	'cnw-or' => 'または',
	'cnw-title' => '新しいウィキアを作成',
	'cnw-name-wiki-headline' => '新しいウィキアを作る',
	'cnw-name-wiki-creative' => 'ウィキアは、好きなものに関するウェブサイトやコミュニティを作り上げるのに最適な場所です。',
	'cnw-name-wiki-label' => 'ウィキアの名前を入力してください',
	'cnw-name-wiki-domain-label' => 'あなたのウィキアのアドレスを入力してください',
	'cnw-name-wiki-submit-error' => '次へ進むには、上の欄をどちらも入力する必要があります。',
	'cnw-login' => 'ログイン',
	'cnw-signup' => 'アカウント作成',
	'cnw-signup-prompt' => '新しいアカウントを作成しますか？',
	'cnw-call-to-signup' => 'こちらからサインアップしてください',
	'cnw-login-prompt' => 'すでにアカウントをお持ちですか？',
	'cnw-call-to-login' => 'こちらからログインしてください',
	'cnw-auth-headline' => 'ログイン',
	'cnw-auth-headline2' => 'サインアップ',
	'cnw-auth-creative' => 'ウィキアの作成を続行するにはアカウントにログインしてください。',
	'cnw-auth-signup-creative' => 'ウィキアの作成を続行するにはアカウントが必要です。<br />サインアップは数分ほどで完了することができます。',
	'cnw-auth-facebook-signup' => 'Facebookアカウントを使ってサインアップ',
	'cnw-auth-facebook-login' => 'Facebookアカウントを使ってログイン',
	'cnw-userauth-headline' => 'アカウントをお持ちの場合',
	'cnw-userauth-creative' => 'ログイン',
	'cnw-userauth-marketing-heading' => 'まだアカウントを お持ちでないですか？',
	'cnw-userauth-signup-button' => 'サインアップ',
	'cnw-desc-headline' => 'あなたのウィキアの内容についてご説明ください。',
	'cnw-desc-creative' => 'ピンポイントの説明を追加すると、あなたのウィキアを見つけてもらいやすくなります。',
	'cnw-desc-placeholder' => 'こちらに入力した内容はあなたのウィキアのメインページで表示されます。',
	'cnw-desc-tip1' => 'ヒント',
	'cnw-desc-tip1-creative' => 'ここでは、あなたのウィキアの良いところや作成した理由などを伝えてみましょう。',
	'cnw-desc-tip2' => 'PS',
	'cnw-desc-tip2-creative' => 'あなたのウィキアについて詳しい説明をして、他のユーザーをコミュニティに呼び込むようにしましょう。',
	'cnw-desc-select-one' => '1つ選択',
	'cnw-desc-all-ages' => 'このウィキアはお子様にも適したコミュニティですか。',
	'cnw-desc-default-lang' => 'このウィキアの言語は$1になります',
	'cnw-desc-change-lang' => '変更',
	'cnw-desc-lang' => '言語',
	'cnw-desc-wiki-submit-error' => 'カテゴリを選択してください',
	'cnw-theme-headline' => 'テーマを選択',
	'cnw-theme-creative' => 'テーマを選択すると、プレビューで確認することができます。',
	'cnw-theme-instruction' => 'ご自分でカスタマイズしたい場合には、管理者ダッシュボードのテーマデザイナーから、好きなテーマをデザインすることもできます。',
	'cnw-welcome-headline' => 'おめでとうございます！「$1」の作成に成功しました！',
	'cnw-welcome-instruction1' => '下のボタンをクリックすると、ウィキアに新しいページを追加することができます。',
	'cnw-welcome-help' => 'ヒントやアドバイスなどが必要な際には <a href="http://ja.community.wikia.com/">コミュニティ・セントラル</a> をご覧ください。',
	'cnw-error-general' => 'ウィキアの作成中に問題が発生しました。もう一度お試しいただくか、[[特別:Contact|こちら]]からご連絡ください。',
	'cnw-error-general-heading' => '申し訳ありません',
	'cnw-error-blocked-header' => 'アカウントがブロックされています',
	'cnw-error-anon-user-header' => 'ログインしてください',
	'cnw-error-bot-header' => 'ボットとして検出されました',
	'cnw-error-unconfirmed-email' => 'ウィキアを作成するには、メールの認証を行っていただく必要があります。',
	'cnw-name-wiki-language' => '',
	'cnw-name-wiki-domain' => '.wikia.com',
	'cnw-userauth-marketing-body' => 'ウィキアでコミュニティを作成するには、アカウントが必要です。サインアップは数分ほどで完了することができます。',
	'cnw-desc-select-vertical' => 'ジャンルを選んでください',
	'cnw-desc-select-categories' => '追加するカテゴリを選択してください',
	'cnw-desc-tip-all-ages' => 'このトピックはお子様に関心を持っていただくためのものですか？ウィキアでは、アメリカ合衆国の法律に準拠するため、12歳以下のお子様に直接アピールするトピックを扱うウィキアの確認を行っています。',
	'cnw-badword-header' => '不適切な言葉です',
	'cnw-badword-msg' => 'ウィキアの説明文での不適切な言葉、禁止されている言葉の使用はご遠慮ください：$1',
	'cnw-error-wiki-limit-header' => 'ウィキアの上限に達しました',
	'cnw-error-wiki-limit' => '1日に作成できるウィキアの数は{{PLURAL:$1|$1個|$1個}}までです。恐れ入りますが、新しいウィキアを作成するには24時間お待ちください。',
	'cnw-error-blocked' => '$1さんによりブロックされています。理由：$2（参照用ブロックID：$3）。',
	'cnw-error-anon-user' => '未登録ユーザーはウィキアを作成することができません。[[Special:UserLogin|ログイン]]してからもう一度お試しください。',
	'cnw-error-torblock' => 'Torネットワーク経由でウィキアを作成することはできません。',
	'cnw-error-bot' => 'ボットの可能性が検出されました。ボットでない場合には、誤ってボットと検出された旨を下記のお問い合わせからお知らせください。その後、ウィキアの作成をサポートさせていただきます：[http://www.wikia.com/Special:Contact/general お問い合わせ]',
	'cnw-error-unconfirmed-email-header' => 'メールの認証が完了していません',
	'autocreatewiki' => '新しいウィキアを作成',
	'autocreatewiki-desc' => 'ユーザーのリクエストにより、ウィキファクトリーにウィキアを作成します',
	'autocreatewiki-page-title-default' => '新しいウィキアの作成',
	'autocreatewiki-page-title-answers' => '新しいアンサーサイトの作成',
	'createwiki' => '新しいウィキアを作成',
	'autocreatewiki-chooseone' => '1つを選択',
	'autocreatewiki-required' => '$1は必須です',
	'autocreatewiki-web-address' => 'URL：',
	'autocreatewiki-category-select' => '1つを選択',
	'autocreatewiki-language-top' => '上位$1の言語',
	'autocreatewiki-language-all' => 'すべての言語',
	'autocreatewiki-remember' => 'パスワードを記憶させる',
	'autocreatewiki-create-account' => 'アカウントを作成',
	'autocreatewiki-haveaccount-question' => '既にウィキアアカウントをお持ちですか？',
	'autocreatewiki-info-domain' => 'ここでは、トピックの検索キーワードとなるような言葉を入力してください。',
	'autocreatewiki-info-topic' => '「スター・ウォーズ」や「テレビ番組」など、簡単な説明を追加してください。',
	'autocreatewiki-info-category-default' => 'あなたのウィキアを見つかりやすくしましょう。',
	'autocreatewiki-info-category-answers' => 'あなたのアンサーサイトを見つかりやすくしましょう。',
	'autocreatewiki-info-language' => 'ここで選択した言語があなたのウィキアを閲覧するユーザーのデフォルト言語となります。',
	'autocreatewiki-info-email-address' => 'あなたのメールアドレスがウィキア上で誰かに表示されることはありません。',
	'autocreatewiki-info-realname' => '本名を入力すると、作者名を表示する際に使用されます。',
	'autocreatewiki-info-birthdate' => 'ウィキアでは、アメリカ合衆国の法規定に則り、サイトの品質維持および安全対策として、すべてのユーザーに対して生年月日の入力を必須としています。',
	'autocreatewiki-info-blurry-word' => 'ボットなどによるアカウントの自動作成を防ぐため、表示されている文字を入力してください。',
	'autocreatewiki-info-terms-agree' => 'ウィキアおよびユーザーアカウントを作成すると、{{#NewWindowLink: w:Terms of use | ウィキアの利用規約}}に同意したと見なされます。',
	'autocreatewiki-info-staff-username' => '<b>スタッフのみ：</b>指定されたユーザーが設立者として表示されます。',
	'autocreatewiki-title-template' => '$1ウィキア',
	'autocreatewiki-tagline' => '',
	'autocreatewiki-limit-day' => '1日にウィキアが作成可能なウィキアの上限数（$1）を超えました。',
	'autocreatewiki-limit-creation' => '24時間以内に作成可能なウィキアの上限数（$1）を超えました。',
	'autocreatewiki-empty-field' => 'この項目は必須です。',
	'autocreatewiki-bad-name' => '名前には特殊文字（$や@など）は使えません。またローマ字は小文字で、スペースを入れずに入力してください。',
	'autocreatewiki-invalid-wikiname' => '名前には特殊文字（$や@など）は使えません。また、空白にすることもできません。',
	'autocreatewiki-violate-policy' => 'このウィキア名には、ウィキアのポリシーに違反する単語が含まれています。',
	'autocreatewiki-name-taken' => 'このアドレスのウィキアは既に存在しています。<a href="http://$1.wikia.com">http://$1.wikia.com</a> で編集に参加してみませんか？新たなウィキアを立ち上げるには、別のアドレスを指定してください。',
	'autocreatewiki-name-too-short' => 'アドレスが短すぎるようです。3文字以上のアドレスを指定してください。',
	'autocreatewiki-name-too-long' => 'アドレスが長すぎるようです。50文字以下のアドレスを指定してください。',
	'autocreatewiki-similar-wikis' => 'このトピックを扱っているウィキアには、以下ようなのものもあります。これらの編集もぜひご検討ください。',
	'autocreatewiki-invalid-username' => 'このユーザー名は無効です。',
	'autocreatewiki-busy-username' => 'このユーザー名は既に使用されています。',
	'autocreatewiki-blocked-username' => 'アカウントを作成できません。',
	'autocreatewiki-user-notloggedin' => 'アカウントの作成は完了しています。ログインしてください。',
	'autocreatewiki-empty-language' => 'このウィキアの言語を選択してください。',
	'autocreatewiki-empty-category' => 'カテゴリを選択してください。',
	'autocreatewiki-empty-wikiname' => 'ウィキア名は空白にできません。',
	'autocreatewiki-empty-username' => 'ユーザー名は空白にできません。',
	'autocreatewiki-empty-password' => 'パスワードは空白にできません。',
	'autocreatewiki-empty-retype-password' => 'パスワードの再入力は空白にできません。',
	'autocreatewiki-category-label' => 'カテゴリ：',
	'autocreatewiki-category-other' => 'その他',
	'autocreatewiki-set-username' => 'まずはユーザー名を指定してください。',
	'autocreatewiki-invalid-category' => 'カテゴリの値が無効です。
ドロップダウン・リストから適切なものを選択してください。',
	'autocreatewiki-invalid-language' => '言語の値が無効です。
ドロップダウン・リストから適切なものを選択してください。',
	'autocreatewiki-invalid-retype-passwd' => '上のパスワードを再入力してください。',
	'autocreatewiki-invalid-birthday' => '生年月日が不適切です。',
	'autocreatewiki-log-title' => 'あなたのウィキアを作成中です',
	'autocreatewiki-step0' => 'プロセスを初期化しています...',
	'autocreatewiki-stepdefault' => 'プロセスを実行しています。少々お待ちください...',
	'autocreatewiki-errordefault' => 'プロセスを完了することができませんでした...',
	'autocreatewiki-step1' => '画像フォルダを作成しています...',
	'autocreatewiki-step2' => 'データベースを作成しています...',
	'autocreatewiki-step3' => 'データベースに初期情報を設定しています...',
	'autocreatewiki-step4' => '初期画像とロゴをコピーしています...',
	'autocreatewiki-step5' => 'データベースに初期変数を設定しています...',
	'autocreatewiki-step6' => 'データベースに初期テーブルを設定しています...',
	'autocreatewiki-step7' => '言語スターターを設定しています...',
	'autocreatewiki-step8' => 'ユーザーグループとカテゴリを設定しています...',
	'autocreatewiki-step9' => '新しいウィキアの変数を設定しています...',
	'autocreatewiki-step10' => 'セントラルウィキアにページを設置しています...',
	'autocreatewiki-step11' => 'ユーザーにメールを送信しています...',
	'autocreatewiki-redirect' => '新しいウィキア（$1）に転送しています...',
	'autocreatewiki-congratulation' => '完了しました！',
	'autocreatewiki-welcometalk-log' => 'ウェルカム・メッセージ',
	'autocreatewiki-regex-error-comment' => 'ウィキア「$1」で使用されています（全文：$2）',
	'autocreatewiki-step2-error' => 'データベースは既に存在します。',
	'autocreatewiki-step3-error' => 'データベースに初期情報を設定できません。',
	'autocreatewiki-step6-error' => 'データベースに初期テーブルを設定できません。',
	'autocreatewiki-step7-error' => '言語スターターのデータベースをコピーできません。',
	'requestwiki-filter-language' => 'als,an,ang,ast,bar,de2,de-at,de-ch,de-formal,de-weigsbrag,dk,en-gb,eshelp,fihelp,frc,frhelp,ia,ie,ithelp,jahelp,kh,kohelp,kp,ksh,nb,nds,nds-nl,mu,mwl,nlhelp,pdc,pdt,pfl,pthelp,pt-brhelp,ruhelp,simple,tokipona,tp,zh-classical,zh-cn,zh-hans,zh-hant,zh-hk,zh-min-nan,zh-mo,zh-my,zh-sg,zh-tw,zh-yue',
	'autocreatewiki-protect-reason' => '公式インターフェースの一部です。',
	'autocreatewiki-welcomesubject' => '「$1」の作成が完了しました！',
	'autocreatewiki-welcomebody' => '$2さん

この度は新しいウィキアを作成していただきありがとうございます。早速<$1> をチェックしてみましょう！
トークページ（<$5>）にてリンクをいくつかご紹介しています。ウィキアの便利なツールなど、ご利用のヒントとしてご参照ください。その他ご不明な点がありましたら、このメールにご返信いただくか、ヘルプページ（<http://ja.community.wikia.com/wiki/ヘルプ:コンテンツ>）をご覧ください。

また、ウィキアのスタッフブログ（<http://ja.community.wikia.com/wiki/ブログ:ウィキアスタッフブログ>）も是非ともご覧ください。ご利用のヒント、新機能に関する情報、ウィキアでの最新情報などをご紹介しています。

それでは、どうぞ編集をお楽しみください。

$3
ウィキア・コミュニティ・サポート
<http://ja.community.wikia.com/wiki/User:$4>

___________________________________________
* ウィキアから送信される通知について変更をご希望の場合は、こちらでご登録を解除するか、メール設定をご変更ください：http://ja.community.wikia.com/Special:Preferences',
	'autocreatewiki-welcometalk-wall-title' => 'ようこそ！',
	'autocreatewiki-welcometalk-wall' => 'こんにちは！この度は、ウィキアで{{subst:SITENAME}}を立ち上げていただき、ありがとうございます！

こちらに、ウィキアを盛り上げていくためのヒントやリンクをご紹介します。ぜひご参照ください。
*[[特別:WikiFeatures|ウィキ・フィーチャーズ]]で、あなたのウィキアで有効にできる機能（チャット、アチーブメントなど）をチェックしてみよう！
*[[特別:ThemeDesigner|テーマデザイナー]]を使って、背景、ロゴ、色、スタイルなど、ウィキアのデザインをカスタマイズしてみよう！
*[[w:c:ja.communtiy|コミュニティ・セントラル]]の[[w:c:ja.communtiy:ブログ:ウィキアスタッフブログ|スタッフブログ]]で最新情報を入手したり、[[w:c:ja.communtiy:特別:Forum|コミュニティ・フォーラム]]で分からないことを質問してみよう！
*[[ヘルプ:コンテンツ|ヘルプページ]]で、[[ヘルプ:新規ページ|新規しいページを追加する方法]]、[[ヘルプ:コミュニティを作り上げる|コミュニティを作り上げる方法]]、[[ヘルプ:ユーザーアクセスレベル|管理者を追加する方法]]など、ウィキアについての様々な記事を見つけてみよう！
*管理者ダッシュボード（下部のツールバーの「管理作業」をクリック）で、上記のすべてのツールを見つけて使ってみよう！

このリンクを活用して、ウィキアをどんどんお楽しみください！',
	'autocreatewiki-welcometalk' => '==ようこそ！==

この度は、ウィキアで「$4」を立ち上げていただきありがとうございます！こちらに、ウィキアを盛り上げていくためのヒントやリンクをご紹介します。ぜひご参照ください。

*[[特別:WikiFeatures|ウィキ・フィーチャーズ]]で、あなたのウィキアで有効にできる機能（チャット、アチーブメントなど）をチェックしてみよう！
*[[w:c:ja.communtiy|コミュニティ・セントラル]]の[[w:c:ja.communtiy:ブログ:ウィキアスタッフブログ|スタッフブログ]]で最新情報を入手したり、[[w:c:ja.communtiy:特別:Forum|コミュニティ・フォーラム]]で分からないことを質問してみよう！
*[[ヘルプ:コンテンツ|ヘルプページ]]で、ウィキアについての様々な記事を見つけてみよう！

このリンクを活用して、ウィキアをどんどんお楽しみください！

-- [[User:$2|$3]] <staff />',
	'autocreatewiki-language-top-list' => 'de,en,es,fr,it,ja,pl,pt-br,ru,zh',
);

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'cnw-next' => 'បន្ទាប់',
	'cnw-back' => 'ត្រលប់ក្រោយ',
	'cnw-or' => 'ឬ',
	'cnw-title' => 'បង្កើតវិគីថ្មី',
	'cnw-name-wiki-headline' => 'ចាប់ផ្ដើមវិគីមួយ',
	'cnw-name-wiki-creative' => 'Wikia ជាកន្លែងដ៏ប្រសើរបំផុតក្នុងការស្ថាបនាវិបសៃថ៍និង​ពង្រីកសហគមន៍ជុំវិញអ្នកអ្វីដែលអ្នកស្រឡាញ់ចូលចិត្ត។',
	'cnw-name-wiki-label' => 'ឈ្មោះវិគីរបស់អ្នក',
	'cnw-name-wiki-domain-label' => 'ផ្ដល់អាសយដ្ឋានមួយដល់វិគីរបស់អ្នក',
	'cnw-name-wiki-submit-error' => 'អូ៎! អ្នកត្រូវតែបំពេញប្រអប់ទាំង២ខាងលើដើម្បីបន្តទៅមុខទៀត។',
	'cnw-login' => 'កត់ឈ្មោះចូល',
	'cnw-signup' => 'បង្កើតគណនី',
	'cnw-signup-prompt' => 'ត្រូវការគណនីមួយ?',
	'cnw-call-to-signup' => 'ចុះឈ្មោះនៅទីនេះ',
	'cnw-login-prompt' => 'មានគណនីមួយរួចហើយ?',
	'cnw-call-to-login' => 'កត់ឈ្មោះចូលនៅទីនេះ',
	'cnw-auth-headline' => 'កត់ឈ្មោះចូល',
	'cnw-auth-headline2' => 'ចុះឈ្មោះ',
	'cnw-auth-creative' => 'កត់ឈ្មោះចូលទៅក្នុងគណនីរបស់អ្នកដើម្បីបន្តស្ថាបនាវិគីរបស់អ្នក។',
	'cnw-auth-signup-creative' => 'អ្នកនឹងត្រូវការគណនីមួយដើម្បីបន្តស្ថាបនាវិគីរបស់អ្នក។ <br />អ្នកចំណាយពេលតែមួយនាទីប៉ុណ្ណោះក្នុងការចុះឈ្មោះ!',
	'cnw-auth-facebook-signup' => 'ចុះឈ្មោះដោយប្រើ Facebook',
	'cnw-auth-facebook-login' => 'កត់ឈ្មោះចូលដោយប្រើ Facebook',
	'cnw-desc-headline' => 'តើវិគីរបស់អ្នកនិយាយពីអ្វី?',
	'cnw-desc-creative' => 'ពណ៌នាពីប្រធានបទរបស់អ្នក',
	'cnw-desc-placeholder' => 'របស់នេះនឹងត្រូវបង្ហាញនៅលើទំព័រដើមរបស់វិគីរបស់អ្នក។',
	'cnw-desc-tip1' => 'គន្លឹះ',
	'cnw-desc-tip1-creative' => 'ប្រើកន្លែងទំនេរនេះ ដើម្បីសរសេរពីរបីល្បះរៀបរាប់ពីវិគីរបស់អ្នកអោយអ្នកដទៃ។',
	'cnw-desc-tip2' => 'គន្លឺះ',
	'cnw-desc-tip2-creative' => 'ផ្ដល់ព័ត៌មានលំអិតដល់អ្នកទស្សនា ស្ដីពីប្រធានបទរបស់អ្នក',
	'cnw-desc-select-one' => 'ជ្រើសរើសមួយ',
	'cnw-desc-default-lang' => 'វិគីរបស់នឹងត្រូវសរសេរជា $1',
	'cnw-desc-change-lang' => 'ផ្លាស់ប្តូរ',
	'cnw-desc-lang' => 'ភាសា',
	'cnw-desc-wiki-submit-error' => 'សូមជ្រើសរើសចំណាត់ថ្នាក់ក្រុមមួយ',
	'cnw-theme-headline' => 'ជ្រើសរើសរចនាបថ',
	'cnw-theme-creative' => 'ជ្រើសរើសរចនាបថខាងក្រោម។ អ្នកនឹងអាចមើលរចនាបថនោះជាមុនពេលដែលជ្រើសរើសវា។',
	'cnw-theme-instruction' => 'អ្នកក៏អាចធ្វើការឌីស្សាញរចនាបថដោយខ្លួនអ្នកនាពេលក្រោយដោយចូលទៅ"ឧបករណ៍"។',
	'cnw-welcome-headline' => 'សូមអបអរសាទរ! $1 ត្រូវបានបង្កើតហើយ',
	'cnw-welcome-instruction1' => 'ចុចលើប៊ូតុងខាងក្រោមដើម្បីចាប់ផ្ដើមបន្ថែមទំព័រទៅលើវិគីរបស់អ្នក។',
	'cnw-welcome-help' => 'រកចំលើយ ដំបូន្មាន និង អ្វីៗបន្ថែមទៀតនៅលើ<a href="http://community.wikia.com">មជ្ឍមណ្ឌលសហគមន៍</a>។',
	'cnw-error-general' => 'មានបញ្ហាពេលបង្កើតវិគីរបស់អ្នក។ សូមព្យាយាមម្ដងទៀតនៅពេលក្រោយ។',
	'cnw-error-general-heading' => 'បញ្ហាក្នុងការបង្កើតវិគីថ្មី',
);

/** Kannada (ಕನ್ನಡ)
 * @author VASANTH S.N.
 */
$messages['kn'] = array(
	'createnewwiki-desc' => 'ವಿಕಿ ನಿರ್ಮಾಣ ನಿಪುಣ ತಂತ್ರಾಂಶ',
	'cnw-next' => 'ನಂತರ',
	'cnw-back' => 'ಹಿಂದಕ್ಕೆ',
	'cnw-or' => 'ಅಥವಾ',
	'cnw-title' => 'ಹೊಸ ವಿಕಿ ನಿರ್ಮಿಸಿ',
	'cnw-name-wiki-headline' => 'ಒಂದು ಹೊಸ ವಿಕಿ ಪ್ರಾರಂಭಿಸಿ',
	'cnw-name-wiki-label' => 'ನಿಮ್ಮ ವಿಕಿಗೆ ಹೆಸರು ಕೊಡಿ',
	'cnw-name-wiki-domain-label' => 'ನಿಮ್ಮ ವಿಕಿಗೆ ಒಂದು ವಿಳಾಸಕೊಡಿ',
	'cnw-login' => 'ಲಾಗ್ ಇನ್',
	'cnw-signup' => 'ಖಾತೆಯನ್ನು ಸೃಷ್ಟಿಸಿ',
	'cnw-signup-prompt' => 'ಹೊಸ ಖಾತೆಯ ಅಗತ್ಯವಿದೆಯೆ?',
	'cnw-call-to-signup' => 'ಇಲ್ಲಿ ಪ್ರವೇಶಿಸಿ',
	'cnw-login-prompt' => 'ಈಗಾಗಲೇ ಖಾತೆಯಿದೆಯೇ?',
	'cnw-call-to-login' => 'ಇಲ್ಲಿ ಲಾಗಿನ್ ಆಗಿ',
	'cnw-auth-headline' => 'ಲಾಗ್ ಇನ್',
	'cnw-auth-headline2' => 'ಪ್ರವೇಶಿಸಿ',
	'cnw-auth-creative' => 'ನಿಮ್ಮ ವಿಕಿಯನ್ನು ಬೆಳೆಸಲು ನಿಮ್ಮ ಖಾತೆಗೆ ಇಲ್ಲಿ ಲಾಗಿನ್ ಆಗಿ.',
	'cnw-auth-facebook-signup' => 'ಫೇಸ್‍ಬುಕ್‍ಗೆ ಪ್ರವೇಶಿಸಿ',
	'cnw-auth-facebook-login' => 'ಫೇಸ್‍ಬುಕ್ ಮೂಲಕ ಲಾಗಿನ್ ಆಗಿ',
	'cnw-userauth-headline' => 'ಖಾತೆ ಇದೆಯೇ?',
	'cnw-userauth-creative' => 'ಲಾಗ್ ಇನ್',
	'cnw-userauth-marketing-heading' => 'ಖಾತೆ ಇಲ್ಲವೇ?',
	'cnw-userauth-marketing-body' => 'ವಿಕಿಯಾದಲ್ಲಿ ವಿಕಿಯನ್ನು ರಚಿಸಲು ನಿಮಗೆ ಖಾತೆಯ ಆವಶ್ಯಕತೆ ಇದೆ.ಕೆಲವೇ ನಿಮಿಷಗಳಲ್ಲಿ ನೀವು ಪ್ರವೇಶಿಸಬಹುದು.',
	'cnw-userauth-signup-button' => 'ಪ್ರವೇಶಿಸಿ',
	'cnw-desc-headline' => 'ನಿಮ್ಮ ವಿಕಿ ಬಗ್ಗೆ ಏನು?',
	'cnw-desc-creative' => 'ನಿಮ್ಮ ವಿಷಯವನ್ನು ವಿವರಿಸಿ',
	'cnw-desc-placeholder' => 'ಇದು ನಿಮ್ಮ ವಿಕಿಯ ಮುಖಪುಟದಲ್ಲಿ ಪ್ರದರ್ಶಿಸಲ್ಪಡುತ್ತದೆ.',
	'cnw-desc-tip1' => 'ಸೂಚನೆ',
	'cnw-desc-tip1-creative' => 'ನಿಮ್ಮ ವಿಕಿಯ ಬಗ್ಗೆ ಒಂದೆರಡು ವಾಕ್ಯಗಳಲ್ಲಿ ಜನರಿಗೆ ತಿಳಿಸಲು ಈ ಸ್ಥಳವನ್ನು ಉಪಯೋಗಿಸಿ',
	'cnw-desc-tip2-creative' => 'ನಿಮ್ಮ ವಿಷಯದ ಬಗ್ಗೆ ಬೇಟಿಕೊಡುವವರಿಗೆ ಕೆಲವು ವಿವರ ತಿಳಿಸಿ',
	'cnw-desc-select-one' => 'ಒಂದನ್ನು ಆಯ್ಕೆ ಮಾಡಿ',
	'cnw-desc-all-ages' => 'ಎಲ್ಲ ಪುಟಗಳು',
	'cnw-desc-default-lang' => 'ನಿಮ್ಮ ವಿಕಿಯು $1 ರಲ್ಲಿರುತ್ತದೆ',
	'cnw-desc-change-lang' => 'ಬದಲಾಯಿಸಿ',
	'cnw-desc-lang' => 'ಭಾಷೆ',
	'cnw-desc-wiki-submit-error' => 'ಒಂದು ವರ್ಗವನ್ನು ಆಯ್ಕೆಮಾಡಿ',
	'cnw-theme-headline' => 'ಲೇಖನಕ್ಕೆ ಒಂದು ವಸ್ತುವನ್ನು ಆಯ್ಕೆಮಾಡಿ',
	'cnw-welcome-headline' => 'ಅಭಿನಂದನೆಗಳು!$1 ಸೃಜಿಸಲ್ಪಟ್ಟಿದೆ',
	'cnw-welcome-instruction1' => 'ನಿಮ್ಮ ವಿಕಿಗೆ ಪುಟಗಳನ್ನು ಸೇರಿಸಿಸಲು ಕೆಳಗಿನ ಗುಂಡಿಯನ್ನು ಅದುಮಿ.',
	'cnw-error-general-heading' => 'ನಮ್ಮ ಕ್ಷಮಾಪಣೆಗಳು',
	'cnw-error-wiki-limit-header' => 'ವಿಕಿ ತನ್ನ ಮಿತಿಯನ್ನು ಮುಟ್ಟಿದೆ',
	'cnw-error-blocked-header' => 'ಖಾತೆಯನ್ನು ನಿರ್ಬಂಧಿಸಲಾಗಿದೆ',
	'cnw-error-anon-user-header' => 'ದಯವಿಟ್ಟು ಲಾಗಿನ್ ಆಗಿ',
	'cnw-error-unconfirmed-email-header' => 'ನಿಮ್ಮ ಮಿಂಚಂಚೆ ದೃಢಪಡಿಸಲಾಗಿಲ್ಲ',
	'cnw-error-unconfirmed-email' => 'ವಿಕಿಯನ್ನು ರಚಿಸಲು ನಿಮ್ಮ ಮಿಂಚಂಚೆಯು ದೃಢಪಡಬೇಕಾಗಿದೆ.',
);

/** Korean (한국어)
 * @author Miri-Nae
 * @author Wrightbus
 * @author Ysjbserver
 * @author 아라
 * @author 한글화담당
 */
$messages['ko'] = array(
	'createnewwiki-desc' => '위키 만들기 마법사',
	'cnw-next' => '다음',
	'cnw-back' => '뒤로',
	'cnw-or' => '또는',
	'cnw-title' => '새 위키 만들기',
	'cnw-name-wiki-headline' => '위키아 시작하기',
	'cnw-name-wiki-creative' => '위키아는 당신이 사랑하는 것의 웹사이트를 세우고 공동체를 자라게 하는 데 최적의 장소입니다.',
	'cnw-name-wiki-label' => '위키 이름을 입력하세요',
	'cnw-name-wiki-domain-label' => '위키 주소를 입력하세요',
	'cnw-name-wiki-submit-error' => '이런! 계속하려면 위 상자를 모두 채워야 합니다.',
	'cnw-login' => '로그인',
	'cnw-signup' => '계정 만들기',
	'cnw-signup-prompt' => '계정이 필요합니까?',
	'cnw-call-to-signup' => '여기서 가입하세요',
	'cnw-login-prompt' => '계정이 이미 있습니까?',
	'cnw-call-to-login' => '여기서 로그인하세요',
	'cnw-auth-headline' => '로그인',
	'cnw-auth-headline2' => '가입하기',
	'cnw-auth-creative' => '위키를 세우기를 계속하려면 당신의 계정으로 로그인하세요.',
	'cnw-auth-signup-creative' => '위키 만들기를 계속하려면 계정이 필요합니다.<br />가입하는 데에는 1분 정도면 충분합니다!',
	'cnw-auth-facebook-signup' => '페이스북으로 가입',
	'cnw-auth-facebook-login' => '페이스북으로 로그인',
	'cnw-userauth-headline' => '계정이 있나요?',
	'cnw-userauth-creative' => '로그인',
	'cnw-userauth-marketing-heading' => '계정이 없나요?',
	'cnw-userauth-marketing-body' => '위키아에 위키를 만드려면 계정이 필요합니다. 가입하는 데에는 1분 정도면 충분합니다!',
	'cnw-userauth-signup-button' => '가입하기',
	'cnw-desc-headline' => '위키의 주제는 무엇인가요?',
	'cnw-desc-creative' => '다른 사람들이 쉽게 위키아를 찾을 수 있도록 설명을 써주세요',
	'cnw-desc-placeholder' => '이것은 위키의 대문에 나타납니다.',
	'cnw-desc-tip1' => '힌트',
	'cnw-desc-tip1-creative' => '간단한 문장으로 위키아를 다른 사람들에게 소개해보세요',
	'cnw-desc-tip2' => '잠깐',
	'cnw-desc-tip2-creative' => '방문자에게 주제에 대해 몇 가지 구체적인 내용을 주세요',
	'cnw-desc-select-vertical' => '허브 분류 선택',
	'cnw-desc-select-categories' => '추가 분류 선택',
	'cnw-desc-select-one' => '하나 선택',
	'cnw-desc-all-ages' => '어린이들이 볼 수 있는 위키인가요?',
	'cnw-desc-tip-all-ages' => '어린이들이 관심을 가질만한 내용인가요? 12세 이하의 어린이들이 관심을 가질 만한 내용이라면 저희는 해당 위키아를 주시할 것입니다.',
	'cnw-desc-default-lang' => '위키 언어는 $1입니다',
	'cnw-desc-change-lang' => '바꾸기',
	'cnw-desc-lang' => '언어',
	'cnw-desc-wiki-submit-error' => '분류를 선택하세요',
	'cnw-theme-headline' => '테마 선택',
	'cnw-theme-creative' => '아래 테마를 선택하면, 선택한 각 테마의 미리 보기를 볼 수 있습니다.',
	'cnw-theme-instruction' => '"내 도구"로 하고 나서 자신의 테마를 디자인할 수도 있습니다.',
	'cnw-welcome-headline' => '축하합니다! $1(을)를 만들었습니다',
	'cnw-welcome-instruction1' => '위키에 문서를 추가하기 시작하려면 아래 버튼을 클릭하세요.',
	'cnw-welcome-help' => '<a href="http://community.wikia.com">위키아 중앙 커뮤니티</a>에서 도움을 구해보세요.',
	'cnw-error-general' => '이런, 뭔가 잘못된 것 같군요! 다시 시도하거나, 위키아 팀에게 [[Special:Contact|연락]]해주세요.',
	'cnw-error-general-heading' => '사과드립니다',
	'cnw-badword-header' => '우와',
	'cnw-badword-msg' => '안녕하세요, 위키 설명에 잘못된 낱말이나 금지된 낱말을 사용하지 말아주세요: $1',
	'cnw-error-wiki-limit-header' => '위키 제한에 도달함',
	'cnw-error-wiki-limit' => '안녕하세요, 하루에 {{PLURAL:$1|위키 $1개 만들기}}가 제한됩니다. 다른 위키를 만들기 전에 24시간을 기다리세요.',
	'cnw-error-blocked-header' => '계정이 차단됨',
	'cnw-error-blocked' => "당신은 $1님에 의해 차단되었습니다. 이유는 '$2'입니다. (차단된 ID: $3)",
	'cnw-error-anon-user-header' => '로그인하세요',
	'cnw-error-anon-user' => '익명이 위키를 만드는 것은 비활성화되어 있습니다. [[Special:UserLogin|로그인]]하고 나서 다시 시도하세요.',
	'cnw-error-torblock' => '토르 네트워크를 통해 위키를 만드는 것은 허용되지 않습니다.',
	'cnw-error-bot' => '우리는 당신이 로봇일 수 있는 것을 감지했습니다. 만약 우리가 실수했다면, 당신이 봇으로 틀리게 감지했음을 우리에게 문의하면, 우리는 위키를 만드는 것을 도울 것입니다: [http://www.wikia.com/Special:Contact/general 문의하기]',
	'cnw-error-bot-header' => '당신은 봇으로 감지되었습니다',
	'cnw-error-unconfirmed-email-header' => '이메일이 확인되지 않았습니다',
	'cnw-error-unconfirmed-email' => '위키를 만들려면 이메일을 확인해야 합니다.',
);

/** Karachay-Balkar (къарачай-малкъар)
 * @author Iltever
 */
$messages['krc'] = array(
	'cnw-back' => 'Артха',
	'cnw-or' => 'неда',
	'cnw-title' => 'Джангы вики къура',
	'cnw-userauth-creative' => 'Кириу',
	'cnw-userauth-marketing-heading' => 'Аккаунтугъуз джокъмуду?',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'cnw-name-wiki-headline' => 'Donn e Wikia bejenne',
);

/** Kurdish (Latin script) (Kurdî (latînî)‎)
 * @author Bikarhêner
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'cnw-next' => 'Pêşve',
	'cnw-back' => 'Paşve',
	'cnw-or' => 'an',
	'cnw-title' => 'Wikiyek Nû Çêke',
	'cnw-name-wiki-headline' => 'Wikiayekê bide destpêkirin',
	'cnw-name-wiki-label' => 'Navê wîkîya te',
	'cnw-login' => 'Têkeve',
	'cnw-signup' => 'Hesabekî çêke',
	'cnw-call-to-login' => 'Ji vir têkeve',
	'cnw-auth-headline' => 'Têkeve',
	'cnw-auth-facebook-signup' => 'Bi Facebookê têkeve',
	'cnw-auth-facebook-login' => 'Bi Facebookê têkeve',
	'cnw-userauth-headline' => 'Hesabekî te heye?',
	'cnw-userauth-creative' => 'Têkeve',
	'cnw-userauth-marketing-heading' => 'Hesabekî te nîne?',
	'cnw-desc-change-lang' => 'biguherîne',
	'cnw-desc-lang' => 'Ziman',
	'cnw-desc-wiki-submit-error' => 'Ji kerema xwe re kategoriyekê hilbijêre',
	'cnw-theme-headline' => 'Temayek hilbijêre',
	'cnw-error-blocked-header' => 'Hesab hat astengkirin',
	'cnw-error-anon-user-header' => 'Ji kerema xwe têkeve',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'cnw-next' => 'Weider',
	'cnw-back' => 'Zréck',
	'cnw-or' => 'oder',
	'cnw-title' => 'Nei Wiki uleeën',
	'cnw-name-wiki-headline' => 'Eng Wikia ufänken',
	'cnw-name-wiki-label' => 'Gitt Ärer Wikia en Numm',
	'cnw-name-wiki-domain-label' => 'Gitt Ärer Wikia eng Adress',
	'cnw-login' => 'Aloggen',
	'cnw-login-prompt' => 'Hutt Dir schonn e Benotzerkont?',
	'cnw-auth-headline' => 'Aloggen',
	'cnw-auth-facebook-login' => 'Mat Facebook aloggen',
	'cnw-userauth-headline' => 'Hutt Dir e Benotzerkont?',
	'cnw-userauth-creative' => 'Aloggen',
	'cnw-userauth-marketing-heading' => 'Hutt Dir kee Benotzerkont?',
	'cnw-desc-headline' => 'Wouriwwer ass Är Wikia?',
	'cnw-desc-creative' => 'Hëlleft de Leit mat enger gudder Beschreiwung fir Är Wikia ze fannen.',
	'cnw-desc-tip1' => 'Hei ass en Tipp!',
	'cnw-desc-tip1-creative' => 'Benotzt dës Plaz fir de Leit firwat Är Wikia wichteg ass a firwat Dir se opgemaach hutt.',
	'cnw-desc-tip2' => 'PS',
	'cnw-desc-select-vertical' => 'Eng Hub-Kategorie eraussichen',
	'cnw-desc-select-categories' => 'Zousätzlech Kategorien nokucken',
	'cnw-desc-select-one' => 'Een/Eng eraussichen',
	'cnw-desc-all-ages' => 'Ass dës Wikia fir Kanner geduecht?',
	'cnw-desc-default-lang' => 'Är Wikia ass op $1',
	'cnw-desc-change-lang' => 'änneren',
	'cnw-desc-lang' => 'Sprooch',
	'cnw-desc-wiki-submit-error' => 'Sicht w.e.g. eng Kategorie eraus',
	'cnw-theme-headline' => 'Sicht en Theme eraus',
	'cnw-error-general-heading' => 'Eis Entschëllegungen',
	'cnw-error-blocked-header' => 'Benotzerkont gespaart',
	'cnw-error-anon-user-header' => 'Loggt Iech w.e.g. an',
	'cnw-error-bot-header' => 'Dir gouft als Bot identifizéiert',
	'cnw-error-unconfirmed-email-header' => 'Är E-Mail-Adress gouf net confirméiert',
);

/** Lingua Franca Nova (Lingua Franca Nova)
 * @author Malafaya
 */
$messages['lfn'] = array(
	'cnw-or' => 'o',
	'cnw-desc-lang' => 'Lingua',
);

/** لەکی‎ (لەکی‎)
 * @author Hosseinblue
 */
$messages['lki'] = array(
	'createnewwiki-desc' => 'دورس گۀر جادوئی ویکی',
	'cnw-next' => 'بچؤ نووا-بعدی',
	'cnw-back' => 'بچو دؤما-گِلّ بارا',
	'cnw-or' => 'یا',
	'cnw-title' => 'ویکی تازۀ دورس کۀ',
	'cnw-name-wiki-headline' => 'ویکی باجؤگِلّ-شؤروع کۀ',
	'cnw-name-wiki-creative' => 'ویکی بئترین جا ئۀرا وبسایت سازینؤ کڵنْگا کردن خۀلکئ کۀ گه هؤمۀ دوست درینؤ',
	'cnw-name-wiki-label' => 'نؤم ویکی هؤمۀ',
	'cnw-login' => ' ئه سیستم هۀتن',
	'cnw-signup' => 'حساووئ دؤرس کۀن',
	'cnw-signup-prompt' => 'حساووتؤنئ مهِ-ئه گِرَۀَکۀ',
	'cnw-call-to-signup' => 'ائرۀ نؤم نؤیسی کۀن',
	'cnw-login-prompt' => 'ئه دووارۀ یه حساوو درینؤ؟',
	'cnw-call-to-login' => 'ائرۀ بونه نؤم',
	'cnw-auth-headline' => ' ئه سیستم هۀتن',
	'cnw-auth-headline2' => 'نؤم نؤیسی بکۀن',
	'cnw-auth-creative' => 'بووئه نؤم اکانتۀت تاویکی ئۀرا ووژت بسازین',
	'cnw-auth-facebook-signup' => 'ئۀ فیسبوکا نؤم نؤیسی کۀن',
	'cnw-auth-facebook-login' => 'ئۀ فیسبوکا بوونه نؤم',
	'cnw-userauth-headline' => 'ئآئا اکانت درینؤ؟',
	'cnw-userauth-creative' => ' ئه سیستم هۀتن',
	'cnw-userauth-marketing-heading' => 'یه حساوویج  نئرینؤ؟',
	'cnw-userauth-signup-button' => 'نؤم نؤیسی بکۀن',
	'cnw-desc-headline' => 'ویکیتؤ دربارۀ چئۀ؟',
	'cnw-desc-placeholder' => 'رئ نیشؤن دائن-راهنمایی',
	'cnw-desc-tip1' => 'رئ نیشؤن دائن-راهنمایی',
	'cnw-desc-select-one' => 'یه گِلّۀ انتخاب کۀ',
	'cnw-desc-change-lang' => 'پاڵانن-آڵشت کردن-تغیرۀل',
	'cnw-desc-lang' => 'زوون',
	'cnw-desc-wiki-submit-error' => 'لطفن رّزگئ-ردیف انتخاب کۀن',
	'cnw-theme-headline' => 'لطفن تم انتخاب کۀن',
	'cnw-error-general-heading' => 'عؤزرخوائیل ایمۀ',
	'cnw-badword-header' => 'مآوو بووسینا',
	'cnw-error-blocked-header' => 'حساوو بَسِریئائۀ',
	'cnw-error-anon-user-header' => 'لطفن بوونه نؤم',
	'cnw-error-unconfirmed-email-header' => 'رایانامۀت تأیید نِؤیۀ',
	'cnw-error-unconfirmed-email' => 'رایانامۀت بائد تأیید بوو ئۀرا ویکی سازین',
);

/** Northern Luri (لوری مینجایی)
 * @author Hosseinblue
 * @author Mogoeilor
 */
$messages['lrc'] = array(
	'cnw-next' => 'نها',
	'cnw-back' => 'وا دما',
	'cnw-or' => 'يا',
	'cnw-title' => 'يه گل ويكی تازه راس بكيت',
	'cnw-name-wiki-headline' => 'یه گل ویکی نه شرو بکید',
	'cnw-name-wiki-label' => 'نوم ویکی تو',
	'cnw-name-wiki-domain-label' => 'سی ویکی تو تیرنشو راس بکیت',
	'cnw-login' => 'وا مین اومائن',
	'cnw-signup' => 'حساو راست بكيد',
	'cnw-signup-prompt' => 'یه گل حساو می حایت؟',
	'cnw-call-to-signup' => 'ایچه ثوت نام بکید',
	'cnw-login-prompt' => 'ایسنی حساو کاریاری داریتو؟',
	'cnw-call-to-login' => 'ایچه بیایت وامین',
	'cnw-auth-headline' => 'وا مین اومائن',
	'cnw-auth-headline2' => 'ثوت نام كردن',
	'cnw-auth-facebook-signup' => 'ثوت نام وا فیس بوک',
	'cnw-auth-facebook-login' => 'اومائن وا مین وا فیس بوک',
	'cnw-userauth-headline' => 'یه گل حساو داریتو؟',
	'cnw-userauth-creative' => 'وا مین اومائن',
	'cnw-userauth-marketing-heading' => 'یه گل حساو ناریت؟',
	'cnw-userauth-signup-button' => 'ثوت نام كردن',
	'cnw-desc-headline' => 'ویکیتو دباره چنه؟',
	'cnw-desc-tip2' => 'پی اس اس تی',
	'cnw-desc-select-one' => 'یه گل نه انتخاو بکید',
	'cnw-desc-all-ages' => 'همه بلگيا',
	'cnw-desc-change-lang' => 'آلشت بكيد',
	'cnw-desc-lang' => 'زون',
	'cnw-error-blocked-header' => 'حساو قلف بیه',
	'cnw-error-anon-user-header' => 'لطف بکیت بیایت وامین',
);

/** Lithuanian (lietuvių)
 * @author Eitvys200
 * @author Mantak111
 * @author Vpovilaitis
 */
$messages['lt'] = array(
	'cnw-next' => 'Kitas',
	'cnw-back' => 'Atgal',
	'cnw-or' => 'arba',
	'cnw-title' => 'Sukurti Naują Wiki',
	'cnw-name-wiki-headline' => 'Sukurti naują Wiki',
	'cnw-login' => 'Prisijungti',
	'cnw-signup' => 'Sukurti Sąskaitą',
	'cnw-signup-prompt' => 'Reikia sąskaitos?',
	'cnw-call-to-signup' => 'Užsiregistruokite čia',
	'cnw-login-prompt' => 'Jau turite sąskaitą?',
	'cnw-call-to-login' => 'Prisijunkite čia',
	'cnw-auth-headline' => 'Prisijungti',
	'cnw-auth-headline2' => 'Užsiregistruoti',
	'cnw-auth-facebook-signup' => 'Registruotis su Facebook',
	'cnw-auth-facebook-login' => 'Prisijungti su Facebook',
	'cnw-userauth-headline' => 'Turite paskyrą?',
	'cnw-userauth-creative' => 'Prisijungti',
	'cnw-userauth-marketing-heading' => 'Neturite paskyros?',
	'cnw-userauth-signup-button' => 'Registracija',
	'cnw-desc-headline' => 'Apie ką jūsų wiki?',
	'cnw-desc-creative' => 'Aprašykite savo temą',
	'cnw-desc-tip1' => 'Patarimas',
	'cnw-desc-tip2' => 'Psst',
	'cnw-desc-select-one' => 'Pasirinkite vieną',
	'cnw-desc-change-lang' => 'keisti',
	'cnw-desc-lang' => 'Kalba',
	'cnw-desc-wiki-submit-error' => 'Prašome pasirinkti kategoriją',
	'cnw-theme-headline' => 'Pasirink temą',
	'cnw-welcome-headline' => 'Sveikiname! $1 buvo sukurtas',
	'cnw-error-general-heading' => 'Mūsų atsiprašymai',
	'cnw-error-wiki-limit-header' => 'Pasiektas Wiki limitas',
	'cnw-error-blocked-header' => 'Sąskaita užblokuota',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 * @author Rancher
 * @author Монтехристо
 */
$messages['mk'] = array(
	'createnewwiki-desc' => 'Помошник за создавање на вики',
	'cnw-next' => 'Следно',
	'cnw-back' => 'Назад',
	'cnw-or' => 'или',
	'cnw-title' => 'Создавање ново вики',
	'cnw-name-wiki-headline' => 'Започнете вики',
	'cnw-name-wiki-creative' => 'Викија е најдоброто место за да изработите мрежно место и да создадете растечка заедница што се темели на она што го сакате.',
	'cnw-name-wiki-label' => 'Именувајте го викито',
	'cnw-name-wiki-domain-label' => 'Дајте му адреса на викито',
	'cnw-name-wiki-submit-error' => 'Упс! Ќе треба да ги пополните обете горенаведени полиња за да продолжите.',
	'cnw-login' => 'Најава',
	'cnw-signup' => 'Направи сметка',
	'cnw-signup-prompt' => 'Ви треба сметка?',
	'cnw-call-to-signup' => 'Регистрирајте се тука',
	'cnw-login-prompt' => 'Веќе имате сметка?',
	'cnw-call-to-login' => 'Најавете се тука',
	'cnw-auth-headline' => 'Најавете се',
	'cnw-auth-headline2' => 'Регистрација',
	'cnw-auth-creative' => 'Најавете се на вашата сметка за да продолжите со изработка на викито.',
	'cnw-auth-signup-creative' => 'Ќе ви треба сметка за да продолжите со изработка на викито.<br />Регистрацијата ќе ви одземе само минутка!',
	'cnw-auth-facebook-signup' => 'Регистрација со Facebook',
	'cnw-auth-facebook-login' => 'Најава со Facebook',
	'cnw-userauth-headline' => 'Имате сметка?',
	'cnw-userauth-creative' => 'Најава',
	'cnw-userauth-marketing-heading' => 'Немате сметка?',
	'cnw-userauth-marketing-body' => 'Ќе ви треба сметка за да можете да создадете вики на Викија. Регистрацијата ќе ви земе само минутка!',
	'cnw-userauth-signup-button' => 'Регистрација',
	'cnw-desc-headline' => 'Која е тематиката на викито?',
	'cnw-desc-creative' => 'Опис што ќе им помогне на другите да ја најдат вашата викија',
	'cnw-desc-placeholder' => 'Ова ќе се прикажува на главната страница на викито',
	'cnw-desc-tip1' => 'Совет',
	'cnw-desc-tip1-creative' => 'Овој простор користете го за да ги известите луѓето за вашата викија во една до две реченици',
	'cnw-desc-tip2' => 'Псст',
	'cnw-desc-tip2-creative' => 'Наведете што повеќе подробности за тематиката',
	'cnw-desc-select-vertical' => 'Изберете главна јазолна категорија',
	'cnw-desc-select-categories' => 'Изберете дополнителни категории',
	'cnw-desc-select-one' => 'Одберете една категорија',
	'cnw-desc-all-ages' => 'Дали оваа викија е наменета за деца?',
	'cnw-desc-tip-all-ages' => 'Дали оваа викија е на тема што ги интересира децата? Законите на САД ни налагаат да водиме евиденција за темите од непосреден интерес за деца на возраст до 12 години.',
	'cnw-desc-default-lang' => 'Викито ќе биде на $1',
	'cnw-desc-change-lang' => 'измени',
	'cnw-desc-lang' => 'Јазик',
	'cnw-desc-wiki-submit-error' => 'Одберете категорија',
	'cnw-theme-headline' => 'Уредете го изгледот на викито',
	'cnw-theme-creative' => 'Подолу изберете изглед. За секој избран изглед ќе се прикаже преглед .',
	'cnw-theme-instruction' => 'Подоцна можете да изработите свој изглед преку „Мои алатки“.',
	'cnw-welcome-headline' => 'Честитаме! Го создадовте $1',
	'cnw-welcome-instruction1' => 'Стиснете на копчето подолу за да почнете да додавате страници на викито.',
	'cnw-welcome-help' => 'Одговори на прашања, совети и друго ќе добиете на <a href="http://community.wikia.com">Центарот на заедницата</a>.',
	'cnw-error-general' => 'Нешто тргна наопаку од кај вас! Обидете се подоцна или [[Special:Contact|конрактирајте нè]] за помош.',
	'cnw-error-general-heading' => 'Се извинуваме',
	'cnw-badword-header' => 'Предупредување',
	'cnw-badword-msg' => 'Здраво. Ве молиме да се воздржите од употреба на непристојни зборови или забранетите зборови наведени во описот на викито: $1',
	'cnw-error-wiki-limit-header' => 'Границата на создадени викија е достигната',
	'cnw-error-wiki-limit' => 'Здраво. Можете да создавате само по {{PLURAL:$1|$1 вики|$1 викија}} дневно. Почекајте 24 часа, па потоа создајте друго.',
	'cnw-error-blocked-header' => 'Сметката е блокирана',
	'cnw-error-blocked' => 'Блокирани сте од $1. Понудената причина гласи: $2. (назнака или навод на блокирањето: $3)',
	'cnw-error-anon-user-header' => 'Најавете се',
	'cnw-error-anon-user' => 'Создавањето на викија од анонимни корисници е оневозможено. [[Special:UserLogin|Најавете се]] и пробајте пак.',
	'cnw-error-torblock' => 'Не е дозволено создавање на викија преку Tor-мрежа.',
	'cnw-error-bot' => 'Утврдивме дека можеби сте бот. Ако ова е погрешно, тогаш контактирајте нè и кажете дека сме ве погрешиле за бот. Тогаш ние ќе ви помогнеме да го направите викито: [http://www.wikia.com/Special:Contact/general?uselang=mk Пишете ни]',
	'cnw-error-bot-header' => 'Утврдено е дека сте бот',
	'cnw-error-unconfirmed-email-header' => 'Вашата е-пошта не е потврдена',
	'cnw-error-unconfirmed-email' => 'Вашата е-пошта треба да е потврдена за да можете да направите Вики.',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'cnw-next' => 'അടുത്തത്',
	'cnw-or' => 'അഥവാ',
	'cnw-title' => 'പുതിയ വിക്കി സൃഷ്ടിക്കുക',
	'cnw-name-wiki-headline' => 'വിക്കി തുടങ്ങുക',
	'cnw-name-wiki-label' => 'താങ്കളുടെ വിക്കിയുടെ പേര്',
	'cnw-login' => 'പ്രവേശിക്കുക',
	'cnw-signup' => 'അംഗത്വമെടുക്കുക',
	'cnw-signup-prompt' => 'അംഗത്വം ആവശ്യമുണ്ടോ?',
	'cnw-call-to-signup' => 'ഇവിടെ അംഗത്വമെടുക്കുക',
	'cnw-login-prompt' => 'മുമ്പേ അംഗത്വമുണ്ടോ?',
	'cnw-call-to-login' => 'ഇവിടെ പ്രവേശിക്കുക',
	'cnw-auth-headline' => 'പ്രവേശിക്കുക',
	'cnw-auth-headline2' => 'അംഗത്വമെടുക്കുക',
	'cnw-auth-facebook-signup' => 'ഫേസ്ബുക്ക് ഉപയോഗിച്ച് അംഗത്വമെടുക്കുക',
	'cnw-auth-facebook-login' => 'ഫേസ്ബുക്ക് ഉപയോഗിച്ച് പ്രവേശിക്കുക',
	'cnw-desc-headline' => 'താങ്കളുടെ വിക്കി എന്തിനെക്കുറിച്ചുള്ളതാണ്?',
	'cnw-desc-creative' => 'താങ്കളുടെ വിഷയം വിശദമാക്കുക',
	'cnw-desc-select-one' => 'ഒരെണ്ണം തിരഞ്ഞെടുക്കുക',
	'cnw-desc-change-lang' => 'മാറ്റംവരുത്തുക',
	'cnw-desc-lang' => 'ഭാഷ',
	'cnw-desc-wiki-submit-error' => 'ദയവായി ഒരു വർഗ്ഗം തിരഞ്ഞെടുക്കുക',
	'cnw-welcome-headline' => 'അഭിനന്ദനങ്ങൾ! $1 സൃഷ്ടിക്കപ്പെട്ടിരിക്കുന്നു',
);

/** Mongolian (монгол)
 * @author Mongol
 */
$messages['mn'] = array(
	'createnewwiki-desc' => 'Вики үүсгэх хялбар хэрэгсэл (wizard)',
	'cnw-error-unconfirmed-email-header' => 'Таны имэйл баталгаажуулагдаагүй байна',
	'cnw-error-unconfirmed-email' => 'Вики үүсгэхийн тулд имэйл чинь баталгаажуулагдсан байх ёстой',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author SNN95
 */
$messages['ms'] = array(
	'createnewwiki-desc' => 'Pendeta cipta wiki',
	'cnw-next' => 'Berikutnya',
	'cnw-back' => 'Sebelumnya',
	'cnw-or' => 'atau',
	'cnw-title' => 'Cipta Wiki Baru',
	'cnw-name-wiki-headline' => 'Buka wikia baru',
	'cnw-name-wiki-creative' => 'Buka laman web, bangunkan komuniti, jadilah peminat terunggul',
	'cnw-name-wiki-label' => 'Namakan wikia anda',
	'cnw-name-wiki-domain-label' => 'Berikan alamat wikia anda',
	'cnw-name-wiki-submit-error' => 'Eh eh! Anda perlu mengisi kedua-dua kotak di atas sebelum menyambung.',
	'cnw-login' => 'Log Masuk',
	'cnw-signup' => 'Buka Akaun',
	'cnw-signup-prompt' => 'Perlukan akaun?',
	'cnw-call-to-signup' => 'Daftar di sini',
	'cnw-login-prompt' => 'Sudah ada akaun?',
	'cnw-call-to-login' => 'Log masuk di sini',
	'cnw-auth-headline' => 'Log Masuk',
	'cnw-auth-headline2' => 'Daftar Diri',
	'cnw-auth-creative' => 'Log masuk ke dalam akaun anda untuk terus membina wiki anda.',
	'cnw-auth-signup-creative' => 'Anda perlukan akaun untuk terus membina wiki anda.<br />Pendaftaran hanya mengambil masa seminit!',
	'cnw-auth-facebook-signup' => 'Berdaftar dengan Facebook',
	'cnw-auth-facebook-login' => 'Log masuk dengan Facebook',
	'cnw-userauth-headline' => 'Dah buka akaun?',
	'cnw-userauth-creative' => 'Log masuk',
	'cnw-userauth-marketing-heading' => 'Belum buka akaun?',
	'cnw-userauth-marketing-body' => 'Anda memerlukan akaun untuk membuka wiki baru di Wikia. Seminit sahaja untuk mendaftar!',
	'cnw-userauth-signup-button' => 'Daftar diri',
	'cnw-desc-headline' => 'Apakah topik wiki anda?',
	'cnw-desc-creative' => 'Bantu orang ramai cari wikia anda dengan huraian yang gempak.',
	'cnw-desc-placeholder' => 'Tulis elok-elok! Teks ini akan tersiar di halaman utama wikia anda.',
	'cnw-desc-tip1' => 'Tips!',
	'cnw-desc-tip1-creative' => 'Gunakan ruang ini untuk beritahu orang ramai mengapa wikia ini penting dan mengapa anda wujudkannya.',
	'cnw-desc-tip2' => 'Lagi satu',
	'cnw-desc-tip2-creative' => 'Galakkan orang ramai untuk menyertai komuniti anda dengan menawarkan butiran mengenai wikia anda.',
	'cnw-desc-select-vertical' => 'Pilih kategori Hab',
	'cnw-desc-select-categories' => 'Pilih kategori-kategori tambahan',
	'cnw-desc-select-one' => 'Pilih satu',
	'cnw-desc-all-ages' => 'Adakah wikia ini ditujukan untuk kanak-kanak?',
	'cnw-desc-tip-all-ages' => 'Adakah wiki ini mengenai topik yang diminati oleh kanak-kanak? Demi membantu kita untuk mematuhi undang-undang Amerika Syarikat, kami mengawasi wiki-wiki yang mengenai topik yang ditujukan secara langsung kepada kanak-kanak berumur 12 tahun ke bawah.',
	'cnw-desc-default-lang' => 'Wiki anda dalam $1',
	'cnw-desc-change-lang' => 'ubah',
	'cnw-desc-lang' => 'Bahasa',
	'cnw-desc-wiki-submit-error' => 'Sila pilih kategori',
	'cnw-theme-headline' => 'Pilih tema',
	'cnw-theme-creative' => 'Buat elok-elok! Pilih tema untuk melihat pratayang.',
	'cnw-theme-instruction' => 'Nak ubah suai? Anda boleh mereka tema sendiri kelak dengan Theme Designer melalui Papan Pemuka Admin anda.',
	'cnw-welcome-headline' => 'Tahniah! $1 sudah tercipta',
	'cnw-welcome-instruction1' => 'Klik butang di bawah untuk mula menambah halaman pada wikia anda.',
	'cnw-welcome-help' => 'Timbalah pengalaman sebagai peminat. Cari jawapan, nasihat, dan banyak lagi di <a href="http://community.wikia.com">Community Central</a>.',
	'cnw-error-general' => 'Maaf, terdapat masalah di pihak kami! Sila cuba lagi atau [[Special:Contact|hubungi kami]] untuk meminta bantuan.',
	'cnw-error-general-heading' => 'Harap maaf',
	'cnw-badword-header' => 'Nanti kejap',
	'cnw-badword-msg' => 'Hai, sila hindari penggunaan kata-kata kesat/terlarang dalam Penerangan Wiki anda: $1',
	'cnw-error-wiki-limit-header' => 'Had wiki dicapai',
	'cnw-error-wiki-limit' => 'Maaf, anda tidak boleh membuka lebih daripada $1 wiki sehari. Tunggi 24 jam sebelum membuka satu lagi wiki.',
	'cnw-error-blocked-header' => 'Akaun disekat',
	'cnw-error-blocked' => 'Anda telah disekat oleh $1. Sebab yang diberikan ialah: $2. (ID sekatan untuk rujukan: $3)',
	'cnw-error-anon-user-header' => 'Sila log masuk',
	'cnw-error-anon-user' => 'Pengguna awanama dilarang membuka wiki. Sila [[Special:UserLogin|log masuk]] dan cuba lagi.',
	'cnw-error-torblock' => 'Pembentukan wiki melalui Tor Network tidak dibenarkan.',
	'cnw-error-bot' => 'Kami telah mengesan bahawa anda mungkin sebuah bot. Jika kami tersilap, sila hubungi kami untuk menerangkan bahawa anda telah tersalah dikesan sebagai bot, dan kami akan membantu anda untuk membuat wiki anda: [http://www.wikia.com/Special:Contact/general Hubungi Kami]',
	'cnw-error-bot-header' => 'Anda telah dikesan sebagai bot',
	'cnw-error-unconfirmed-email-header' => 'E-mel anda belum disahkan',
	'cnw-error-unconfirmed-email' => 'Alamat e-mel anda perlu disahkan untuk membuka wiki.',
);

/** Neapolitan (Napulitano)
 * @author C.R.
 */
$messages['nap'] = array(
	'createnewwiki-desc' => "Procedura guidata p' 'a criazione 'e na wiki",
	'cnw-error-unconfirmed-email-header' => "Ll'e-mail d' 'o tujo nun è stato cunfermato",
	'cnw-error-unconfirmed-email' => "Ll'e-mail d' 'o tujo s'ha dda cunfermà pe' crià 'a Wiki.",
);

/** Norwegian Bokmål (norsk bokmål)
 * @author Audun
 * @author Laaknor
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'createnewwiki-desc' => 'Veiviser for opprettelse av wiki',
	'cnw-next' => 'Neste',
	'cnw-back' => 'Tilbake',
	'cnw-or' => 'eller',
	'cnw-title' => 'Opprett ny wiki',
	'cnw-name-wiki-headline' => 'Start en wiki',
	'cnw-name-wiki-creative' => 'Wikia er det beste stedet å bygge et nettsted og lage en fellesskap rundt det du elsker.',
	'cnw-name-wiki-label' => 'Navngi wikien din',
	'cnw-name-wiki-domain-label' => 'Gi wikien din en adresse',
	'cnw-name-wiki-submit-error' => 'Ops! Du må fylle ut begge boksene over for å fortsette.',
	'cnw-login' => 'Logg inn',
	'cnw-signup' => 'Opprett konto',
	'cnw-signup-prompt' => 'Trenger du en konto?',
	'cnw-call-to-signup' => 'Registrer deg her',
	'cnw-login-prompt' => 'Har du allerede en konto?',
	'cnw-call-to-login' => 'Logg inn her',
	'cnw-auth-headline' => 'Logg inn',
	'cnw-auth-headline2' => 'Registrer deg',
	'cnw-auth-creative' => 'Logg inn på kontoen din og fortsett å bygge wikien din.',
	'cnw-auth-signup-creative' => 'Du vil trenge en konto for å fortsette å bygge wikien din.<br />Det tar bare et øyeblikk å registrere seg!',
	'cnw-auth-facebook-signup' => 'Registrer deg med Facebook',
	'cnw-auth-facebook-login' => 'Logg inn med Facebook',
	'cnw-userauth-headline' => 'Har du en konto?',
	'cnw-userauth-creative' => 'Logg inn',
	'cnw-userauth-marketing-heading' => 'Har du ikke en konto?',
	'cnw-userauth-marketing-body' => 'Du trenger en konto for å opprette en wiki hos Wikia. Det tar bare et minutt å registrere deg!',
	'cnw-userauth-signup-button' => 'Registrer deg',
	'cnw-desc-headline' => 'Hva handler wikien din om?',
	'cnw-desc-creative' => 'Beskriv emnet ditt',
	'cnw-desc-placeholder' => 'Dette vil vises på hovedsiden til wikien din.',
	'cnw-desc-tip1' => 'Hint',
	'cnw-desc-tip1-creative' => 'Bruk denne plassen til å fortelle folk om wikien din med en setning eller to',
	'cnw-desc-tip2' => 'Psst',
	'cnw-desc-tip2-creative' => 'Gi dine besøkende noen spesifikke detaljer om feltet ditt',
	'cnw-desc-select-one' => 'Velg en',
	'cnw-desc-all-ages' => 'Alle aldere',
	'cnw-desc-default-lang' => 'Wikien din vil være på $1',
	'cnw-desc-change-lang' => 'endre',
	'cnw-desc-lang' => 'Språk',
	'cnw-desc-wiki-submit-error' => 'Vennligst velg en kategori',
	'cnw-theme-headline' => 'Velg et tema',
	'cnw-theme-creative' => 'Velg et tema under. Du vil kunne se en forhåndsvisning av hvert tema når du markerer det.',
	'cnw-theme-instruction' => 'Du kan også utforme ditt eget tema senere ved å gå til «Mine verktøy».',
	'cnw-welcome-headline' => 'Gratulerer! $1 har blitt opprettet',
	'cnw-welcome-instruction1' => 'Trykk på knappen under for å begynne å legge til siden på wikien din.',
	'cnw-welcome-help' => 'Finn svar, råd, og mer på <a href="http://community.wikia.com">Community Central</a>.',
	'cnw-error-general' => 'Noe gikk galt under opprettning av wikien din. Vennligst prøv igjen, eller [[Special:Contact|kontakt oss]] for hjelp.',
	'cnw-error-general-heading' => 'Våre unnskyldninger',
	'cnw-badword-header' => 'Hei der',
	'cnw-badword-msg' => 'Hei, vennligst unngå å bruke disse grove eller forbudte ordene i beskrivelsen av wikien: $1',
	'cnw-error-wiki-limit-header' => 'Wikigrense nådd',
	'cnw-error-wiki-limit' => 'Hei, du er begrenset til {{PLURAL:$1|$1 wikiopprettelse|$1 wikiopprettelser}} per dag.  Vent i 24 timer før du oppretter en ny wiki.',
	'cnw-error-blocked-header' => 'Konto blokkert',
	'cnw-error-blocked' => 'Du har blitt blokkert av $1. Begrunnelsen var: $2. (Blokkerings-ID for referanse: $3)',
	'cnw-error-torblock' => 'Å opprette wikier via Tor-nettverket er ikke tillatt.',
	'cnw-error-bot' => 'Vi har registrert at du kan være en bot. Hvis vi har gjort en feil, vennligst kontakt oss og gi beskjed om at du har blitt feilaktig registrert som en bot, og vi vil hjelpe deg med å opprette wikien din: [http://www.wikia.com/Special:Contact/general Kontakt oss]',
	'cnw-error-bot-header' => 'Du har blitt fanget opp som en bot',
);

/** Nepali (नेपाली)
 * @author Nirjal stha
 * @author सरोज कुमार ढकाल
 */
$messages['ne'] = array(
	'cnw-name-wiki-headline' => 'विकिया शुरू गर्नु होस्',
	'cnw-name-wiki-label' => 'तपाईको विकियालाई नाम दिनुहोस्',
	'cnw-name-wiki-domain-label' => 'तपाईको विकियाको ठेगाना दिनुहोस्',
	'cnw-login' => 'प्रवेश',
	'cnw-signup' => 'खाता खोल्नुहोस्',
	'cnw-login-prompt' => 'के तपाईँसँग पहिले देखि नै खाता छ ?',
	'cnw-auth-headline' => 'प्रवेश',
	'cnw-userauth-creative' => 'प्रवेश',
	'cnw-userauth-marketing-heading' => 'के खाता छैन ?',
	'cnw-desc-tip1' => 'यहाँ एउटा सुझाव छ!',
	'cnw-desc-tip2' => 'पिएस',
	'cnw-desc-select-vertical' => 'हब श्रेणी छान्नुहोस्',
	'cnw-desc-select-categories' => 'थप श्रेणीहरू जाँच गर्नुहोस्',
	'cnw-desc-all-ages' => 'सबै उमेरहरू',
	'cnw-desc-default-lang' => 'तपाईको विकिया $1 मा हुनेछ',
	'cnw-desc-change-lang' => 'परिवर्तन',
	'cnw-desc-lang' => 'भाषा',
	'cnw-welcome-headline' => 'बधाई छ ! तपाईले सफलतापूर्वक $1 तयार गर्नु भयो',
);

/** Dutch (Nederlands)
 * @author Hansmuller
 * @author Robin0van0der0vliet
 * @author Siebrand
 * @author Sjoerddebruin
 * @author Trijnstel
 * @author Yatalu
 */
$messages['nl'] = array(
	'createnewwiki-desc' => 'Wizard wiki aanmaken',
	'cnw-next' => 'Volgende',
	'cnw-back' => 'Vorige',
	'cnw-or' => 'of',
	'cnw-title' => 'Nieuwe wiki aanmaken',
	'cnw-name-wiki-headline' => 'Wiki oprichten',
	'cnw-name-wiki-creative' => 'Wikia is de beste plaats om een website te bouwen en een gemeenschap te laten groeien om het onderwerp dat u aan het hart gaat.',
	'cnw-name-wiki-label' => 'Geef uw wiki een naam',
	'cnw-name-wiki-domain-label' => 'Geef uw wiki een adres',
	'cnw-name-wiki-submit-error' => 'U moet beide bovenstaande velden invullen om door te kunnen gaan.',
	'cnw-login' => 'Aanmelden',
	'cnw-signup' => 'Registreren',
	'cnw-signup-prompt' => 'Wilt u zich registreren?',
	'cnw-call-to-signup' => 'Hier aanmelden',
	'cnw-login-prompt' => 'Hebt u al een account?',
	'cnw-call-to-login' => 'Hier aanmelden',
	'cnw-auth-headline' => 'Aanmelden',
	'cnw-auth-headline2' => 'Registreren',
	'cnw-auth-creative' => 'Meld u aan om door te gaan met het opbouwen van uw wiki.',
	'cnw-auth-signup-creative' => 'U hebt een gebruiker nodig om door te kunnen gaan met het bouwen van uw wiki.<br />Registreren kost maar een minuutje van uw tijd!',
	'cnw-auth-facebook-signup' => 'Aanmelden met Facebook',
	'cnw-auth-facebook-login' => 'Aanmelden met Facebook',
	'cnw-userauth-headline' => 'Hebt u een account?',
	'cnw-userauth-creative' => 'Aanmelden',
	'cnw-userauth-marketing-heading' => 'Hebt u geen account?',
	'cnw-userauth-marketing-body' => 'U hebt een gebruiker nodig om een wiki aan te maken bij Wikia. Het kost u slechts een minuutje om te registreren.',
	'cnw-userauth-signup-button' => 'Registreren',
	'cnw-desc-headline' => 'Waar gaat uw wikia over?',
	'cnw-desc-creative' => 'Uw beschrijving helpt bij het zoeken naar uw wikia',
	'cnw-desc-placeholder' => 'Dit wordt weergegeven op de hoofdpagina van uw wiki.',
	'cnw-desc-tip1' => 'Tip',
	'cnw-desc-tip1-creative' => 'Gebruik deze ruimte om mensen over uw Wikia te vertellen in een paar zinnen',
	'cnw-desc-tip2' => 'Pst!',
	'cnw-desc-tip2-creative' => 'Geef uw bezoeker wat details over uw onderwerp',
	'cnw-desc-select-vertical' => 'Selecteer een Hubcategorie',
	'cnw-desc-select-categories' => 'Selecteer extra categorieën',
	'cnw-desc-select-one' => 'Maak een keuze',
	'cnw-desc-all-ages' => 'Is deze wikia bedoeld voor kinderen?',
	'cnw-desc-tip-all-ages' => "Gaat dit over een onderwerp waar kinderen interesse in hebben? Om ons aan de Amerikaanse wetgeving te houden, houden we bij welke wikia's over onderwerpen gaan waar kinderen van 12 jaar en jonger interesse in hebben.",
	'cnw-desc-default-lang' => 'De hoofdtaal van uw wiki is: $1',
	'cnw-desc-change-lang' => 'wijzigen',
	'cnw-desc-lang' => 'Taal',
	'cnw-desc-wiki-submit-error' => 'Kies een categorie',
	'cnw-theme-headline' => 'Ontwerp uw wiki',
	'cnw-theme-creative' => 'Kies hieronder een vormgeving. Als u een vormgeving selecteert, wordt een voorvertoning weergegeven.',
	'cnw-theme-instruction' => 'U kunt uw thema of ontwerp altijd later aanpassen via "Mijn hulpmiddelen".',
	'cnw-welcome-headline' => 'Gefeliciteerd. U hebt de wiki $1 aangemaakt',
	'cnw-welcome-instruction1' => "Klik op de onderstaande knop om pagina's aan uw wiki toe te voegen.",
	'cnw-welcome-help' => 'Antwoorden, advies en meer op <a href="http://community.wikia.com">Community Central</a>.',
	'cnw-error-general' => 'Er is iets misgegaan tijdens het aanmaken van uw wiki. Probeer het later opnieuw of [[Special:Contact|neem contact met ons op]] voor hulp.',
	'cnw-error-general-heading' => 'Fout tijdens het aanmaken van een nieuwe wiki',
	'cnw-badword-header' => 'Pas op!',
	'cnw-badword-msg' => 'Hallo. Probeer u te onthouden van het gebruiken van ongewenste woorden in uw wikibeschrijving: $1',
	'cnw-error-wiki-limit-header' => 'De wikilimiet is bereikt',
	'cnw-error-wiki-limit' => "Hallo. U mag maximaal $1 {{PLURAL:$1|wiki|wiki's}} per dag aanmaken. Wacht 24 uur om een nieuwe wiki aan te kunnen maken.",
	'cnw-error-blocked-header' => 'Gebruiker geblokkeerd',
	'cnw-error-blocked' => 'U bent geblokkeerd door $1. De reden die gegeven is: $2. (Blokkadenummer voor referentie: $3)',
	'cnw-error-anon-user-header' => 'Meld u aan',
	'cnw-error-anon-user' => "Het aanmaken voor wiki's is uitgeschakeld voor anonieme gebruikers. [[Special:UserLogin|Meld u aan]] en probeer het opnieuw.",
	'cnw-error-torblock' => "Wiki's aanmaken via het Tor Network is niet toegestaan.",
	'cnw-error-bot' => 'We denken dat u wellicht een geautomatiseerd programma bent. Als deze aanname onjuist is, neem dan [http://www.wikia.com/Special:Contact/general contact met ons op], en geef aan waarop u denk dat u onterecht bent aangemerkt als een robot. Dit stelt ons in staat u verder te helpen met het aanmaken van uw wiki.',
	'cnw-error-bot-header' => 'U bent geïdentificeerd als een geautomatiseerd proces',
	'cnw-error-unconfirmed-email-header' => 'Uw e-mailadres is niet bevestigd',
	'cnw-error-unconfirmed-email' => 'Uw e-mailadres moet bevestigd zijn om een wiki te kunnen aanmaken.',
	'cnw-name-wiki-language' => '',
	'cnw-name-wiki-domain' => '.wikia.com',
	'autocreatewiki' => 'Begin een nieuwe wiki',
	'autocreatewiki-desc' => 'Wiki aanmaken in WikiFactory door gebruikersverzoeken',
	'autocreatewiki-page-title-default' => 'Nieuwe wiki aanmaken',
	'autocreatewiki-page-title-answers' => 'Nieuwe Antwoordensite aanmaken',
	'createwiki' => 'Nieuwe wiki aanmaken',
	'autocreatewiki-chooseone' => 'Kies er een',
	'autocreatewiki-required' => '$1 = vereist',
	'autocreatewiki-web-address' => 'Webadres:',
	'autocreatewiki-category-select' => 'Maak een keuze',
	'autocreatewiki-language-top' => 'Top $1 talen',
	'autocreatewiki-language-all' => 'Alle talen',
	'autocreatewiki-remember' => 'Aanmeldgegevens onthouden',
	'autocreatewiki-create-account' => 'Registreren',
	'autocreatewiki-haveaccount-question' => 'Hebt u al een Wikia-gebruiker?',
	'autocreatewiki-info-domain' => 'Het is het beste om een woord te kiezen dat vaak gebruikt wordt om uw onderwerp te vinden.',
	'autocreatewiki-info-topic' => 'Voeg een korte beschrijving toe, zoals "Star Wars" of "TV-programma".',
	'autocreatewiki-info-category-default' => 'Hierdoor kunnen bezoekers uw wiki vinden.',
	'autocreatewiki-info-category-answers' => 'Hierdoor kunnen bezoekers uw Antwoordensite vinden.',
	'autocreatewiki-info-language' => 'Dit wordt de standaardtaal voor bezoekers van uw wiki.',
	'autocreatewiki-info-email-address' => 'Uw e-mailadres wordt nooit bekend gemaakt aan welk persoon dan ook op Wikia.',
	'autocreatewiki-info-realname' => 'Geef uw naam op zodat deze gebruikt kan worden om u erkenning te geven voor uw werk.',
	'autocreatewiki-info-birthdate' => 'Wikia vraagt aan alle gebruikers om hun echte geboortedatum op te geven voor veiligheid, maar ook om de integriteit van de site aan de federale regels te laten voldoen.',
	'autocreatewiki-info-blurry-word' => 'Om het automatisch aanmaken van gebruikers tegen te gaan moet u het wazige woord dat u in dit veld ziet invoeren.',
	'autocreatewiki-info-terms-agree' => 'Door een wiki en een gebruiker aan te maken accepteert u de <a href="http://www.wikia.com/wiki/Terms_of_use">gebruiksvoorwaarden van Wikia</a>.',
	'autocreatewiki-info-staff-username' => '<b>Alleen voor stafleden:</b> de aangegeven gebruiker wordt vermeld als de oprichter.',
	'autocreatewiki-title-template' => '$1 wiki',
	'autocreatewiki-tagline' => '',
	'autocreatewiki-limit-day' => "Wikia heeft het maximum aantal nieuwe wiki's voor vandaag ($1) overschreden.",
	'autocreatewiki-limit-creation' => "U hebt het maximum aantal nieuwe wiki's in 24 uur ($1) overschreden.",
	'autocreatewiki-empty-field' => 'Vul dit veld in.',
	'autocreatewiki-bad-name' => 'De naam kan geen speciale tekens bevatten (zoals $ of @) en moet bestaan uit één woord, zonder hoofdletters en zonder spaties.',
	'autocreatewiki-invalid-wikiname' => 'De naam kan geen speciale tekens (zoals $ of @) bevatten en kan niet leeg zijn.',
	'autocreatewiki-violate-policy' => 'Deze wikinaam bevat een woord dat ons beleid voor namen schendt.',
	'autocreatewiki-name-taken' => 'Er bestaat al een wiki met dit adres.
U kunt meehelpen op <a href="http://$1.wikia.com">http://$1.wikia.com</a> of een ander adres kiezen.',
	'autocreatewiki-name-too-short' => 'Dit adres is te kort.
Kies alstublieft een adres met tenminste drie tekens.',
	'autocreatewiki-name-too-long' => 'Het adres is te lang.
Kies een naam met hoogstens vijftig tekens.',
	'autocreatewiki-similar-wikis' => "Hieronder staan de wiki's die al aangemaakt zijn voor dit onderwerp.
We raden u aan aan een van deze wiki's te gaan werken.",
	'autocreatewiki-invalid-username' => 'Deze gebruikersnaam is ongeldig.',
	'autocreatewiki-busy-username' => 'Deze gebruikersnaam is al in gebruik.',
	'autocreatewiki-blocked-username' => 'U kunt geen gebruiker aanmaken.',
	'autocreatewiki-user-notloggedin' => 'Uw gebruiker is aangemaakt maar u bent niet aangemeld!',
	'autocreatewiki-empty-language' => 'Selecteer de taal voor de wiki.',
	'autocreatewiki-empty-category' => 'Selecteer een categorie.',
	'autocreatewiki-empty-wikiname' => 'De naam van de wiki kan niet leeg zijn.',
	'autocreatewiki-empty-username' => 'De gebruikersnaam kan niet leeg zijn.',
	'autocreatewiki-empty-password' => 'Het wachtwoord kan niet leeg zijn.',
	'autocreatewiki-empty-retype-password' => 'Het herhaalde wachtwoord kan niet leeg zijn.',
	'autocreatewiki-category-label' => 'Categorie:',
	'autocreatewiki-category-other' => 'Overige',
	'autocreatewiki-set-username' => 'Stel eerst een gebruikersnaam in.',
	'autocreatewiki-invalid-category' => 'Ongeldige categoriekeuze.
Kies een categorie uit de lijst.',
	'autocreatewiki-invalid-language' => 'Ongeldige taalkeuze.
Kies een taal uit de lijst.',
	'autocreatewiki-invalid-retype-passwd' => 'Herhaal hetzelfde wachtwoord',
	'autocreatewiki-invalid-birthday' => 'Ongeldige geboortedatum',
	'autocreatewiki-log-title' => 'Uw wiki wordt aangemaakt',
	'autocreatewiki-step0' => 'Proces aan het initialiseren ...',
	'autocreatewiki-stepdefault' => 'Proces is aan het werk. Een moment geduld alstublieft...',
	'autocreatewiki-errordefault' => 'Het proces was niet afgerond...',
	'autocreatewiki-step1' => 'Afbeeldingenmap aanmaken…',
	'autocreatewiki-step2' => 'Database aan het aanmaken...',
	'autocreatewiki-step3' => 'Standaardgegevens in de database aan het laden...',
	'autocreatewiki-step4' => 'Standaard afbeeldingen en logo aan het kopiëren ...',
	'autocreatewiki-step5' => 'Standaard variabelen in de database aan het laden...',
	'autocreatewiki-step6' => 'Standaard tabellen in de database aan het laden...',
	'autocreatewiki-step7' => 'Taal aan het instellen...',
	'autocreatewiki-step8' => 'Gebruikersgroepen en categorieën aan het instellen ...',
	'autocreatewiki-step9' => 'Variabelen voor de nieuwe wiki aan het instellen...',
	'autocreatewiki-step10' => "Pagina's op centrale wiki aan het instellen...",
	'autocreatewiki-step11' => 'E-mail aan het verzenden naar gebruiker...',
	'autocreatewiki-redirect' => 'Bezig met het doorverwijzen naar de nieuwe wiki: $1 ...',
	'autocreatewiki-congratulation' => 'Gefeliciteerd!',
	'autocreatewiki-welcometalk-log' => 'Welkomstbericht',
	'autocreatewiki-regex-error-comment' => 'gebruikt in wiki $1 (volledige tekst: $2)',
	'autocreatewiki-step2-error' => 'De database bestaat al!',
	'autocreatewiki-step3-error' => 'Het was niet mogelijk de standaard gegevens in de database te laden!',
	'autocreatewiki-step6-error' => 'Het was niet mogelijk de standaard tabellen in de database te laden!',
	'autocreatewiki-step7-error' => 'Het was niet mogelijk de database voor de taal te kopiëren!',
	'requestwiki-filter-language' => 'als,an,ang,ast,bar,de2,de-at,de-ch,de-formal,de-weigsbrag,dk,en-gb,eshelp,fihelp,frc,frhelp,ia,ie,ithelp,jahelp,kh,kohelp,kp,ksh,nb,nds,nds-nl,mu,mwl,nlhelp,pdc,pdt,pfl,pthelp,pt-brhelp,ruhelp,simple,tokipona,tp,zh-classical,zh-cn,zh-hans,zh-hant,zh-hk,zh-min-nan,zh-mo,zh-my,zh-sg,zh-tw,zh-yue',
	'autocreatewiki-protect-reason' => 'Onderdeel van de officiële interface',
	'autocreatewiki-welcomesubject' => '$1 is aangemaakt!',
	'autocreatewiki-welcomebody' => "Hallo $2!

Uw wiki is aangemaakt! Ga maar kijken op <$1>

Bent u klaar om te beginnen? We hebben een aantal koppelingen op uw overlegpagina toegevoegd (<$5>) om u op weg te helpen en om u aan te moedigen om de vele handige bronnen rondom Wikia te verkennen. Als u vragen hebt of een beetje de weg kwijt bent, antwoord dan op deze e-mail of kijk op onze hulpppagina's: <http://help.wikia.com>.

U kunt ook op onze blog voor Oprichters en beheerders kijken <http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins> of op de blog van Wikiamedewerkers <http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog>. Daar vindt u tips en trucs, informatie over nieuwe functies en ander nieuws over Wikia.

Succes met uw project!

$3
Wikia Gemeenschapsondersteuning
<http://community.wikia.com/wiki/User:$4>

___________________________________________
* Wilt u minder berichten van ons ontvangen? U kunt hier uitschrijven of uw e-mailvoorjeuren wijzigen: http://community.wikia.com/Special:Preferences",
	'autocreatewiki-welcometalk-wall-title' => 'Welkom!',
	'autocreatewiki-welcometalk-wall' => "Hallo!
We zijn blij dat {{subst:SITENAME}} nu onderdeel is van de Wikiagemeenschap.

Er is nog veel te doen, dus hier zijn wat handige tips om uw wiki verder te helpen:
* Neem een kijkje op [[Special:WikiFeatures|Wikifuncties]] om te zien welke functies u voor uw wiki in kunt schakelen, waaronder chat, speldjes en nog veel meer.
* Ga langs bij [[w:c:community|Community Central]] om op de hoogte te blijven via onze [[w:c:community:Blog:Wikia_Staff_Blog|medewerkersblog]], stel vragen op ons [[w:c:community:Special:Forum|gemeenschapsforum]], neem deel aan onze [[w:c:community:Help:Webinars|webinars]] of chat live met mede-Wikianen.
* Tenslotte kunt u onze [[Help:Contents|Hulppagina's]] bekijken om alle ins en outs van Wikia te leren kennen.

Alle bovenstaande koppelingen zijn een prima plaats om te beginnen met het verkennen van Wikia. Veel plezier!",
	'autocreatewiki-welcometalk' => "==Hallo!==
We zijn blij dat $4 nu onderdeel is van de Wikiagemeenschap. Er is nog veel te doen, dus hier zijn wat handige tips om uw wiki verder te helpen:

* Neem een kijkje op [[Special:WikiFeatures|Wikifuncties]] om te zien welke functies u voor uw wiki in kunt schakelen, waaronder chat, speldjes en nog veel meer.
* Ga langs bij [[w:c:community|Community Central]] om op de hoogte te blijven via onze [[w:c:community:Blog:Wikia_Staff_Blog|medewerkersblog]], stel vragen op ons [[w:c:community:Special:Forum|gemeenschapsforum]], neem deel aan onze [[w:c:community:Help:Webinars|webinars]] of chat live met mede-Wikianen.
* Tenslotte kunt u onze [[Help:Contents|Hulppagina's]] bekijken om alle ins en outs van Wikia te leren kennen.

Alle bovenstaande koppelingen zijn een prima plaats om te beginnen met het verkennen van Wikia. Veel plezier!

-- [[User:$2|$3]] <staff />",
	'autocreatewiki-language-top-list' => 'de,en,es,fr,it,ja,pl,pt-br,ru,zh',
);

/** Nederlands (informeel)‎ (Nederlands (informeel)‎)
 * @author Geitost
 * @author MarkvA
 * @author Siebrand
 */
$messages['nl-informal'] = array(
	'cnw-name-wiki-creative' => 'Wikia is de beste plaats om een website te bouwen en een gemeenschap te laten groeien om het onderwerp dat je aan het hart gaat.',
	'cnw-name-wiki-label' => 'Geef je wiki een naam',
	'cnw-name-wiki-domain-label' => 'Geef je wiki een adres',
	'cnw-name-wiki-submit-error' => 'Je moet beide bovenstaande velden invullen om door te kunnen gaan.',
	'cnw-auth-creative' => 'Meld je aan om door te gaan met het opbouwen van je wiki.',
	'cnw-auth-signup-creative' => 'Je hebt een gebruiker nodig om door te kunnen gaan met het bouwen van uw wiki.<br />Registreren kost maar een minuutje van je tijd!',
	'cnw-desc-headline' => 'Waar gaat je wiki over?',
	'cnw-desc-creative' => 'Beschrijf je onderwerp',
	'cnw-desc-placeholder' => 'Dit wordt weergegeven op de hoofdpagina van je wiki.',
	'cnw-desc-tip1-creative' => 'Gebruik deze ruimte om mensen over je wiki te vertellen in een paar zinnen',
	'cnw-desc-tip2-creative' => 'Geef je bezoeker wat details over je onderwerp',
	'cnw-desc-default-lang' => 'De hoofdtaal van je wiki is: $1',
	'cnw-theme-creative' => 'Kies hieronder een vormgeving. Als je een vormgeving selecteert, wordt een voorvertoning weergegeven.',
	'cnw-theme-instruction' => 'Je kunt je thema of ontwerp altijd later aanpassen via "Mijn hulpmiddelen".',
	'cnw-welcome-instruction1' => "Klik op de onderstaande knop om pagina's aan je wiki toe te voegen.",
	'cnw-error-general' => 'Er is iets misgegaan tijdens het aanmaken van je wiki. Probeer het later opnieuw.',
	'cnw-error-wiki-limit' => "Hoi. Je mag maximaal $1 {{PLURAL:$1|wiki|wiki's}} per dag aanmaken. Wacht 24 uur om een nieuwe wiki aan te kunnen maken.",
);

/** Occitan (occitan)
 * @author Cedric31
 * @author Hulothe
 */
$messages['oc'] = array(
	'createnewwiki-desc' => 'Assistent de creacion de wiki',
	'cnw-next' => 'Seguent',
	'cnw-back' => 'Precedent',
	'cnw-or' => 'o',
	'cnw-title' => 'Crear un novèl wiki',
	'cnw-name-wiki-headline' => 'Començar un Wiki',
	'cnw-name-wiki-creative' => "Wikia es lo melhor endrech per bastir un site Web e crear una comunautat a l'entorn de çò que vos agrada.",
	'cnw-name-wiki-label' => 'Nomenatz vòstre wiki',
	'cnw-name-wiki-domain-label' => 'Donatz una adreça a vòstre wiki',
	'cnw-name-wiki-submit-error' => 'O planhèm ! Vos cal emplenar los dos camps çaisús per contunhar.',
	'cnw-login' => 'Se connectar',
	'cnw-signup' => 'Crear un compte',
	'cnw-signup-prompt' => 'Cal un compte ?',
	'cnw-call-to-signup' => 'Inscrivètz-vos aicí',
	'cnw-login-prompt' => 'Avètz ja un compte ?',
	'cnw-call-to-login' => 'Connectatz-vos aicí',
	'cnw-auth-headline' => 'Se connectar',
	'cnw-auth-headline2' => 'S’inscriure',
	'cnw-auth-creative' => 'Connectatz-vos a vòstre compte per contunhar de bastir vòstre wiki.',
	'cnw-auth-facebook-signup' => 'S’identificar amb Facebook',
	'cnw-auth-facebook-login' => 'Se connectar amb Facebook',
	'cnw-userauth-headline' => 'Avètz un compte?',
	'cnw-userauth-creative' => 'Se connectar',
	'cnw-userauth-marketing-heading' => 'Avètz pas encara de compte ?',
	'cnw-userauth-signup-button' => 'S’inscriure',
	'cnw-desc-headline' => 'De qué parla vòstre wikia ?',
	'cnw-desc-creative' => 'Vòstra descripcion ajudarà lo monde a trobar vòstre wikia',
	'cnw-desc-tip1' => 'Astúcia',
	'cnw-desc-tip2' => 'Psst',
	'cnw-desc-select-vertical' => 'Seleccionatz un tèma',
	'cnw-desc-select-categories' => 'Seleccionatz de categorias addicionalas',
	'cnw-desc-select-one' => 'Ne seleccionar una',
	'cnw-desc-all-ages' => 'Aqueste wikia es destinat als enfants ?',
	'cnw-desc-default-lang' => 'Vòstre wiki serà en $1',
	'cnw-desc-change-lang' => 'modificar',
	'cnw-desc-lang' => 'Lenga',
	'cnw-desc-wiki-submit-error' => 'Causissètz una categoria',
	'cnw-theme-headline' => 'Causissètz un tèma',
	'cnw-error-general-heading' => 'O planhèm',
	'cnw-badword-header' => 'Au !',
	'cnw-error-anon-user-header' => 'Connectatz-vos',
);

/** Palatine German (Pälzisch)
 * @author Manuae
 */
$messages['pfl'] = array(
	'cnw-badword-header' => 'Imma longsoam',
);

/** Polish (polski)
 * @author BeginaFelicysym
 * @author Chrumps
 * @author Matik7
 * @author NexGaming
 * @author Sovq
 * @author Vengir
 * @author Wedkarski
 * @author Woytecr
 */
$messages['pl'] = array(
	'createnewwiki-desc' => 'Kreator tworzenia Wiki',
	'cnw-next' => 'Dalej',
	'cnw-back' => 'Wstecz',
	'cnw-or' => 'lub',
	'cnw-title' => 'Utwórz nową Wiki',
	'cnw-name-wiki-headline' => 'Utwórz Wiki',
	'cnw-name-wiki-creative' => 'Stwórz stronę, zbierz wokół niej społeczność i rozpocznij odkrywanie świata fanów.',
	'cnw-name-wiki-label' => 'Nazwa twojej wiki',
	'cnw-name-wiki-domain-label' => 'Adres twojej wiki',
	'cnw-name-wiki-submit-error' => 'Ups! Musisz wypełnić oba pola powyżej, aby przejść dalej.',
	'cnw-login' => 'Zaloguj się',
	'cnw-signup' => 'Utwórz konto',
	'cnw-signup-prompt' => 'Chcesz założyć konto?',
	'cnw-call-to-signup' => 'Zarejestruj się',
	'cnw-login-prompt' => 'Masz już konto?',
	'cnw-call-to-login' => 'Zaloguj się tutaj',
	'cnw-auth-headline' => 'Zaloguj się',
	'cnw-auth-headline2' => 'Zarejestruj się',
	'cnw-auth-creative' => 'Zaloguj się, aby kontynuować tworzenie swojej wiki.',
	'cnw-auth-signup-creative' => 'Potrzebujesz konta, aby kontynuować.<br />Rejestracja zajmie Ci tylko kilka chwil!',
	'cnw-auth-facebook-signup' => 'Zarejestruj się przez Facebooka',
	'cnw-auth-facebook-login' => 'Zaloguj się przez Facebooka',
	'cnw-userauth-headline' => 'Masz już konto?',
	'cnw-userauth-creative' => 'Zaloguj się',
	'cnw-userauth-marketing-heading' => 'Nie masz konta?',
	'cnw-userauth-marketing-body' => 'Rejestracja zajmie Ci tylko chwilę! Posiadanie konta jest wymagane, aby tworzyć wiki na portalu Wikia.',
	'cnw-userauth-signup-button' => 'Zarejestruj się',
	'cnw-desc-headline' => 'O czym jest twoja wiki?',
	'cnw-desc-creative' => 'Pomóż znaleźć twoją wiki poprzez wspaniały opis.',
	'cnw-desc-placeholder' => 'Postaraj się! Twój tekst pojawi się na stronie głównej twojej wiki.',
	'cnw-desc-tip1' => 'Podpowiedź!',
	'cnw-desc-tip1-creative' => 'W tym miejscu opisz, dlaczego ta wiki jest ważna i dlaczego ją stworzyłeś.',
	'cnw-desc-tip2' => 'PS',
	'cnw-desc-tip2-creative' => 'Zachęć innych do dołączenia do twojej społeczności przez szczegółowe opisanie twojej wiki.',
	'cnw-desc-select-vertical' => 'Wybierz kategorię Huba',
	'cnw-desc-select-categories' => 'Wybierz dodatkowe kategorie',
	'cnw-desc-select-one' => 'Wybierz',
	'cnw-desc-all-ages' => 'Czy ta wikia jest przeznaczona dla dzieci?',
	'cnw-desc-tip-all-ages' => 'Czy to jest wiki o tematyce, którą dzieci będą zainteresowane? Aby pomóc Nam działać w zgodzie z prawem Stanów Zjednoczonych monitorujemy wiki o tematyce kierowanej bezpośrednio do dzieci w wieku 12 lat i poniżej.',
	'cnw-desc-default-lang' => 'Twoja wiki będzie w języku: $1',
	'cnw-desc-change-lang' => 'zmień',
	'cnw-desc-lang' => 'Język',
	'cnw-desc-wiki-submit-error' => 'Wybierz kategorię',
	'cnw-theme-headline' => 'Wybierz motyw',
	'cnw-theme-creative' => 'Stwórz piękną stronę! Wybierz jeden z poniższych motywów, aby zobaczyć podgląd.',
	'cnw-theme-instruction' => 'Chcesz zmienić motyw? Możesz zaprojektować go później, korzystając z Kreatora Motywu w Panelu Administratora.',
	'cnw-welcome-headline' => 'Gratulacje! $1 została utworzona',
	'cnw-welcome-instruction1' => 'Kliknij na poniższy przycisk, aby zacząć dodawanie stron do twojej wiki.',
	'cnw-welcome-help' => 'Znajdź odpowiedzi, porady i więcej w <a href="http://spolecznosc.wikia.com">Centrum Społeczności</a>.',
	'cnw-error-general' => 'Ups, coś poszło nie tak po naszej stronie! Spróbuj ponownie, lub [[Special:Contact|napisz do nas]].',
	'cnw-error-general-heading' => 'Przepraszamy',
	'cnw-badword-header' => 'Uwaga',
	'cnw-badword-msg' => 'Witaj, proszę nie używaj niedozwolonych słów w opisie wiki: $1',
	'cnw-error-wiki-limit-header' => 'Osiągnięto limit wiki',
	'cnw-error-wiki-limit' => 'Możesz utworzyć tylko {{PLURAL:$1|$1}} wiki dziennie. Zaczekaj 24 godziny, aby utworzyć kolejną wiki.',
	'cnw-error-blocked-header' => 'Konto zablokowane',
	'cnw-error-blocked' => 'Użytkownik został zablokowany przez  $1. Jako przyczynę podano:  $2. (Identyfikator blokady:  $3 )',
	'cnw-error-anon-user-header' => 'Zaloguj się',
	'cnw-error-anon-user' => 'Utworzyć wiki mogą jedynie zarejestrowani użytkownicy. [[Special:UserLogin|Zaloguj się]] i spróbuj ponownie.',
	'cnw-error-torblock' => 'Tworzenie wiki za pośrednictwem Tor Network nie jest dozwolone.',
	'cnw-error-bot' => 'Wykryto, że to konto może być botem. Jeżeli popełniono błąd, proszę skontaktuj się z nami i opisz, że błędnie potraktowano Cię jako bota, a my pomożemy w tworzeniu twojej wiki: [http://www.wikia.com/Special:Contact/general Kontakt]',
	'cnw-error-bot-header' => 'Zostałeś zidentyfikowany jako bot',
	'cnw-error-unconfirmed-email-header' => 'Twój e-mail nie został potwierdzony',
	'cnw-error-unconfirmed-email' => 'Twój e-mail musi być potwierdzony, aby stworzyć Wiki.',
	'cnw-name-wiki-language' => '',
	'cnw-name-wiki-domain' => '.wikia.com',
	'autocreatewiki' => 'Utwórz nową wiki',
	'autocreatewiki-desc' => 'Utwórz wiki w WikiFactory na prośbę użytkownika',
	'autocreatewiki-page-title-default' => 'Utwórz nową wiki',
	'autocreatewiki-page-title-answers' => 'Utwórz nową wiki Zapytaj',
	'createwiki' => 'Utwórz nową wiki',
	'autocreatewiki-chooseone' => 'Wybierz',
	'autocreatewiki-required' => '$1 = wymagane',
	'autocreatewiki-web-address' => 'Adres strony internetowej:',
	'autocreatewiki-category-select' => 'Wybierz',
	'autocreatewiki-language-top' => '$1 najpopularniejszych języków',
	'autocreatewiki-language-all' => 'Wszystkie języki',
	'autocreatewiki-remember' => 'Zapamiętaj mnie',
	'autocreatewiki-create-account' => 'Utwórz konto',
	'autocreatewiki-haveaccount-question' => 'Czy masz już konto na portalu Wikia?',
	'autocreatewiki-info-domain' => 'Najlepiej użyć słowa, które może być słowem kluczowym szukanego tematu.',
	'autocreatewiki-info-topic' => 'Dodaj krótki opis, taki jak „Gwiezdne Wojny” lub „Seriale”.',
	'autocreatewiki-info-category-default' => 'Pomoże to odnaleźć odwiedzającym Twoją wiki.',
	'autocreatewiki-info-category-answers' => 'Pomoże to odnaleźć odwiedzającym Twoją Zapytaj wiki.',
	'autocreatewiki-info-language' => 'Będzie to domyślny język dla odwiedzających Twoją wiki.',
	'autocreatewiki-info-email-address' => 'Twój adres e-mail nigdy nie będzie widoczny dla nikogo na portalu Wikia.',
	'autocreatewiki-info-realname' => 'Jeśli zdecydujesz się go podać, zostanie użyty, żeby oznaczyć Ciebie jako autora.',
	'autocreatewiki-info-birthdate' => 'Wikia wymaga od wszystkich użytkowników podania rzeczywistej daty urodzenia ze względów bezpieczeństwa oraz dla zachowania spójności strony, przy zapewnieniu zgodności z przepisami federalnymi.',
	'autocreatewiki-info-blurry-word' => 'Ze względu na ochronę przed automatycznym tworzeniem kont, przepisz zamazane słowo widoczne w tym polu.',
	'autocreatewiki-info-terms-agree' => 'Tworząc wiki i konto użytkownika, akceptujesz {{#NewWindowLink: w:Terms of use | Zasady Użytkowania portalu Wikia}}',
	'autocreatewiki-info-staff-username' => '<b>Tylko dla pracowników:</b> Wybrany użytkownik zostanie wyszczególniony jako założyciel.',
	'autocreatewiki-title-template' => '$1 Wikia',
	'autocreatewiki-tagline' => '',
	'autocreatewiki-limit-day' => 'Wikia przekroczyła dzisiaj maksymalną liczbę utworzonych wiki ($1).',
	'autocreatewiki-limit-creation' => 'Przekroczyłeś maksymalną liczbę wiki, które możesz utworzyć w ciągu 24 godzin ($1).',
	'autocreatewiki-empty-field' => 'Należy wypełnić to pole.',
	'autocreatewiki-bad-name' => 'Nazwa nie może zawierać znaków specjalnych (np. $ czy @) oraz musi stanowić jedno słowo zapisane małymi literami bez odstępów.',
	'autocreatewiki-invalid-wikiname' => 'Nazwa nie może zawierać znaków specjalnych (np. $ czy @) i nie może być pusta',
	'autocreatewiki-violate-policy' => 'Nazwa wiki zawiera słowo, które narusza nasze zasady nadawania tytułów',
	'autocreatewiki-name-taken' => 'Wiki o tym adresie już istnieje. Przyłącz się do edytowania na <a href="http://$1.wikia.com">http://$1.wikia.com</a> lub wybierz inny adres.',
	'autocreatewiki-name-too-short' => 'Adres jest zbyt krótki. Wybierz adres, który zawiera przynajmniej 3 znaki.',
	'autocreatewiki-name-too-long' => 'Adres jest zbyt długi. Wybierz adres, który zawiera maksymalnie 50 znaków.',
	'autocreatewiki-similar-wikis' => 'Poniżej znajdują się istniejące wiki dotyczące tego tematu. Proponujemy edycję jednej z nich.',
	'autocreatewiki-invalid-username' => 'Ta nazwa użytkownika jest nieprawidłowa.',
	'autocreatewiki-busy-username' => 'Ta nazwa użytkownika jest już wykorzystywana.',
	'autocreatewiki-blocked-username' => 'Nie można utworzyć konta.',
	'autocreatewiki-user-notloggedin' => 'Twoje konto zostało utworzone, ale nie jesteś zalogowany!',
	'autocreatewiki-empty-language' => 'Wybierz język dla tej wiki.',
	'autocreatewiki-empty-category' => 'Wybierz kategorię.',
	'autocreatewiki-empty-wikiname' => 'Nazwa wiki nie może być pusta.',
	'autocreatewiki-empty-username' => 'Nazwa użytkownika nie może być pusta.',
	'autocreatewiki-empty-password' => 'Hasło nie może być puste.',
	'autocreatewiki-empty-retype-password' => 'Powtórzone hasło nie może być puste.',
	'autocreatewiki-category-label' => 'Kategoria:',
	'autocreatewiki-category-other' => 'Inne',
	'autocreatewiki-set-username' => 'Najpierw podaj nazwę użytkownika.',
	'autocreatewiki-invalid-category' => 'Nieprawidłowa kategoria.
Wybierz prawidłową z listy.',
	'autocreatewiki-invalid-language' => 'Nieprawidłowy język.
Wybierz prawidłowy z listy.',
	'autocreatewiki-invalid-retype-passwd' => 'Przepisz hasło tak, aby było identyczne z powyższym',
	'autocreatewiki-invalid-birthday' => 'Nieprawidłowa data urodzenia',
	'autocreatewiki-log-title' => 'Twoja wiki jest w trakcie tworzenia',
	'autocreatewiki-step0' => 'Trwa inicjowanie procesu...',
	'autocreatewiki-stepdefault' => 'Proces trwa, proszę czekać...',
	'autocreatewiki-errordefault' => 'Proces nie został ukończony...',
	'autocreatewiki-step1' => 'Tworzenie folderu obrazów...',
	'autocreatewiki-step2' => 'Tworzenie bazy danych...',
	'autocreatewiki-step3' => 'Ustawianie domyślnych informacji w bazie danych...',
	'autocreatewiki-step4' => 'Kopiowanie domyślnych obrazów oraz logo...',
	'autocreatewiki-step5' => 'Ustawianie w bazie danych domyślnych zmiennych...',
	'autocreatewiki-step6' => 'Ustawianie w bazie danych domyślnych tabel...',
	'autocreatewiki-step7' => 'Ustawianie początkowych wartości dla języka...',
	'autocreatewiki-step8' => 'Ustawianie grup użytkowników i kategorii...',
	'autocreatewiki-step9' => 'Ustawianie zmiennych dla nowej wiki...',
	'autocreatewiki-step10' => 'Ustawianie stron na centralnej wiki...',
	'autocreatewiki-step11' => 'Wysyłanie e‐maila do użytkownika...',
	'autocreatewiki-redirect' => 'Przekierowanie do nowej wiki: $1 ...',
	'autocreatewiki-congratulation' => 'Gratulacje!',
	'autocreatewiki-welcometalk-log' => 'Wiadomość powitalna',
	'autocreatewiki-regex-error-comment' => 'wykorzystane na wiki $1 (pełny tekst: $2)',
	'autocreatewiki-step2-error' => 'Baza danych istnieje!',
	'autocreatewiki-step3-error' => 'Nie można ustawić domyślnych informacji w bazie danych!',
	'autocreatewiki-step6-error' => 'Nie można ustawić domyślnych tabel w bazie danych!',
	'autocreatewiki-step7-error' => 'Nie można skopiować do bazy danych początkowych wartości dla języka!',
	'requestwiki-filter-language' => 'als,an,ang,ast,bar,de2,de-at,de-ch,de-formal,de-weigsbrag,dk,en-gb,eshelp,fihelp,frc,frhelp,ia,ie,ithelp,jahelp,kh,kohelp,kp,ksh,nb,nds,nds-nl,mu,mwl,nlhelp,pdc,pdt,pfl,pthelp,pt-brhelp,ruhelp,simple,tokipona,tp,zh-classical,zh-cn,zh-hans,zh-hant,zh-hk,zh-min-nan,zh-mo,zh-my,zh-sg,zh-tw,zh-yue',
	'autocreatewiki-protect-reason' => 'Część oficjalnego interfejsu',
	'autocreatewiki-welcomesubject' => '$1 została utworzona!',
	'autocreatewiki-welcomebody' => 'Cześć $2,

Twoja wiki została utworzona! Zobacz: 
<$1>.

Czy jesteś gotowy, aby rozpocząć edytowanie? Dodaliśmy do Twojej strony dyskusji (<$5>) kilka linków, aby pomóc Ci na początku i zachęcić do przeglądania przydatnych miejsc na portalu Wikia. Jeśli masz jakiekolwiek pytania lub nie wiesz co robić, odpowiedz na ten e-mail albo wejdź na stronę <http://pomoc.wikia.com>.

Możesz też odwiedzić blog Założycieli i Administratorów <http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins>, lub blog  Wikia Staff <http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog.> Znajdziesz tam porady i wskazówki, informacje o nowych funkcjach oraz najświeższe informacje o tym, co dzieje się na portalu Wikia. 

Udanego edytowania!

$3
Wikia – Wsparcie Społeczności
<http://community.wikia.com/wiki/User:$4>


___________________________________________
* Chcesz otrzymywać mniej wiadomości? Możesz zrezygnować z otrzymywania powiadomień lub zmienić ustawienia powiadomień tutaj: http://community.wikia.com/Special:Preferences',
	'autocreatewiki-welcometalk-wall-title' => 'Witaj!',
	'autocreatewiki-welcometalk-wall' => 'Cieszymy się, że {{subst:SITENAME}} dołączyła do społeczności portalu Wikia. 

Pozostało wiele do zrobienia. Oto kilka wskazówek i linków na dobry początek:

*Sprawdź [[Special:WikiFeatures|Rozszerzenia Wiki]], żeby zobaczyć, które funkcje możesz włączyć na swojej wiki, w tym Chat, Osiągnięcia i wiele innych.
*Dostosuj wygląd swojej wiki odwiedzając [[Special:ThemeDesigner|Kreator Motywów]], gdzie możesz dodać kolor i style do tła i logo.
*Zajrzyj na [[w:c:community|Centrum Społeczności]], aby być na bieżąco dzięki [[w:c:community:Blog:Wikia_Staff_Blog|blogowi staff]], aby zadawać pytania wejdź na [[w:c:community:Special:Forum|forum społeczności]], bierz udział w naszych [[w:c:community:Help:Webinars|webinariach]], oraz w [[w:c:community:Special:Chat|chatach na żywo]] z innymi Wikianami.
*Odwiedź też [[Help:Contents|strony pomocy]], aby poznać tajniki korzystania z portalu Wikia, w tym, [[Help:New page|jak dodać nową stronę do twojej wiki]], [[Help:Attracting contributors|jak przyciągnąć współtwórców]], oraz [[Help:User access levels|jak dodać administratorów]].
* Możesz też skorzystać ze wszystkich tych narzędzi odwiedzając Panel administratora, który znajdziesz klikając w przycisk „Admin” na dolnym pasku narzędzi.

Wszystkie powyższe linki to świetne miejsca, od których możesz rozpocząć zabawę!',
	'autocreatewiki-welcometalk' => '==Witaj!==

Cieszymy się, że $4 dołączyła do społeczności portalu Wikia. Pozostało wiele do zrobienia. Oto kilka wskazówek i linków na dobry początek:

*Sprawdź [[Special:WikiFeatures|Rozszerzenia Wiki]], żeby zobaczyć, które funkcje możesz włączyć na swojej wiki, w tym Chat, Osiągnięcia i wiele innych. 
*Zajrzyj na [[w:c:community|Centrum Społeczności]], aby być na bieżąco dzięki
[[w:c:community:Blog:Wikia_Staff_Blog|blogowi staff]], aby zadawać pytania wejdź na [[w:c:community:Special:Forum|forum społeczności]], bierz udział w naszych [[w:c:community:Help:Webinars|webinariach]], oraz w [[w:c:community:Special:Chat|chatach na żywo]] z innymi Wikianami.
*Odwiedź też [[Help:Contents|strony pomocy]], aby poznać tajniki korzystania z portalu Wikia

Wszystkie powyższe linki to świetne miejsca, od których możesz rozpocząć zabawę!

-- [[Używkownik:$2|$3]] <staff />',
	'autocreatewiki-language-top-list' => 'de,en,es,fr,it,ja,pl,pt-br,ru,zh',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'createnewwiki-desc' => 'Creassion guidà ëd Wiki',
	'cnw-next' => 'Apress',
	'cnw-back' => 'André',
	'cnw-or' => 'o',
	'cnw-title' => 'Creé na Neuva Wiki',
	'cnw-name-wiki-headline' => 'Anandié na Wiki',
	'cnw-name-wiki-creative' => "Wikia a l'é ël mej pòst për fé un sit dla Ragnà e fé chërse na comunità dantorn a lòn ch'a-j pias.",
	'cnw-name-wiki-label' => 'Daje un nòm a toa wiki',
	'cnw-name-wiki-domain-label' => "Daje n'adrëssa a toa wiki",
	'cnw-name-wiki-submit-error' => 'Atension! A dev compilé tute doe le casele sì-dzora për andé anans.',
	'cnw-login' => 'Intré ant ël sistema',
	'cnw-signup' => 'Creé un Cont',
	'cnw-signup-prompt' => "Dabzògn d'un cont?",
	'cnw-call-to-signup' => "Ch'as anscriva ambelessì",
	'cnw-login-prompt' => 'Ha-lo già un cont?',
	'cnw-call-to-login' => "Ch'a intra ant ël sistema belessì",
	'cnw-auth-headline' => 'Intré ant ël sistema',
	'cnw-auth-headline2' => "Ch'as Anscriva",
	'cnw-auth-creative' => "Ch'as colega a sò cont për continué a batì soa wiki.",
	'cnw-auth-signup-creative' => "A l'avrà dabzògn d'un cont për continué a batì soa wiki.<br />A-i và mach na minuta për anscriv-se!",
	'cnw-auth-facebook-signup' => 'Anscriv-se con Facebook',
	'cnw-auth-facebook-login' => 'Intré ant ël sistema con Facebook',
	'cnw-userauth-headline' => 'Ha-lo un cont?',
	'cnw-userauth-creative' => 'Conession',
	'cnw-userauth-marketing-heading' => 'Ha-lo nen un cont?',
	'cnw-userauth-marketing-body' => "It l'has dabzògn d'un cont për creé na wiki dzor Wikia. A-i và mach na minuta për registrete!",
	'cnw-userauth-signup-button' => "Ch'as anscriva",
	'cnw-desc-headline' => "Ëd lòn ch'a parla soa wiki?",
	'cnw-desc-creative' => "Ch'a descriva l'argoment",
	'cnw-desc-placeholder' => "Sòn a comparirà an sla pàgina d'intrada ëd soa wiki.",
	'cnw-desc-tip1' => 'Sugeriment',
	'cnw-desc-tip1-creative' => "Ch'a deuvra së spassi për dije a la gent ëd lòn ch'a trata soa wiki ant na fras o doe",
	'cnw-desc-tip2' => "Ch'a scota",
	'cnw-desc-tip2-creative' => "Ch'a-j daga ai sò visitador chèich detaj specìfich a propòsit dël soget",
	'cnw-desc-select-one' => 'Sern-ne un-a',
	'cnw-desc-default-lang' => 'Toa wiki a sarà an $1',
	'cnw-desc-change-lang' => 'cambia',
	'cnw-desc-lang' => 'Lenga',
	'cnw-desc-wiki-submit-error' => "Për piasì, ch'a serna na categorìa",
	'cnw-theme-headline' => 'Sern un tema',
	'cnw-theme-creative' => "Ch'a serna un tema sì-sota, a podrà vëdde na preuva ëd minca tema an selessionandlo.",
	'cnw-theme-instruction' => 'A peul ëdcò progeté sò tema përsonal pi tard andasend su «Ij mè utiss».',
	'cnw-welcome-headline' => "Congratulassion! $1 a l'é stàita creà",
	'cnw-welcome-instruction1' => "Ch'a sgnaca an sël boton sì-sota për ancaminé a gionté dle pàgine a soa wiki.",
	'cnw-welcome-help' => 'Ch\'a treuva dle rispòste, dij consej, e ancor ëd pi dzora la <a href="http://community.wikia.com">Sentral dla comunità</a>.',
	'cnw-error-general' => "Contacc, quaicòs a l'é andàit mal da nòstra part. Për piasì, ch'a preuva torna pi tard, o <a href=\"/Special:Contact\">ch'a contata</a> për dl'agiut.",
	'cnw-error-general-heading' => 'Scus-ne',
	'cnw-badword-header' => "Ch'a scota",
	'cnw-badword-msg' => "Cerea, për piasì ch'a deuvra nen ste parolasse o paròle vietà ant ls Descrission ëd soa Wiki: $1",
	'cnw-error-wiki-limit-header' => 'Rivà al lìmit ëd Wiki',
	'cnw-error-wiki-limit' => "Cerea, it ses limità a {{PLURAL:$1|$1 creassion ëd wiki}} për di. Speta 24 ore prima ëd creé n'àutra wiki.",
	'cnw-error-blocked-header' => 'Cont blocà',
	'cnw-error-blocked' => "A l'é stàit blocà da $1. La rason dàita a l'era: $2. (ID ëd blocagi për arferiment: $3)",
	'cnw-error-torblock' => "Creé dle Wiki via la Rej Tor a l'é pa përmëttù.",
	'cnw-error-bot' => "I l'oma trovà che it peule esse un trigomiro. S'i l'oma fàit n'eror, për piasì contatne dëscrivend ch'it ses stàit falsament andividuà com un trigomiro, e it giuteroma a creé toa wiki: [http://www.wikia.com/Special:Contact/general ContatNe]",
	'cnw-error-bot-header' => 'It ses stàit andividuà com un trigomiro',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'cnw-next' => 'راتلونکی',
	'cnw-back' => 'پر شا کېدل',
	'cnw-or' => 'يا',
	'cnw-title' => 'يو نوی ويکي جوړول',
	'cnw-name-wiki-headline' => 'يو ويکي پيلول',
	'cnw-name-wiki-label' => 'خپله ويکي ونوموئ',
	'cnw-name-wiki-domain-label' => 'خپلې ويکييا ته يوه پته ځانگړې کړئ',
	'cnw-login' => 'ننوتل',
	'cnw-signup' => 'گڼون جوړول',
	'cnw-signup-prompt' => 'آيا يو گڼون غواړۍ؟',
	'cnw-call-to-signup' => 'نومليکل دلته ترسره کېږي',
	'cnw-login-prompt' => 'آيا وار دمخې يو گڼون لرۍ؟',
	'cnw-call-to-login' => 'دلته ننوتل',
	'cnw-auth-headline' => 'ننوتل',
	'cnw-auth-headline2' => 'نومليکل',
	'cnw-auth-facebook-signup' => 'د فېسبوک له لارې نومليکل',
	'cnw-auth-facebook-login' => 'د فېسبوک له لارې ننوتل',
	'cnw-userauth-headline' => 'آيا يو گڼون لرې؟',
	'cnw-userauth-creative' => 'ننوتل',
	'cnw-userauth-marketing-heading' => 'گڼون نه لرې؟',
	'cnw-userauth-signup-button' => 'نومليکل',
	'cnw-desc-headline' => 'ستاسې ويکييا د څه په اړه ده؟',
	'cnw-desc-placeholder' => 'دا به ستاسې د ويکي په لومړي مخ ښکاره شي.',
	'cnw-desc-tip1-creative' => 'دلته په يوې يا دوه کرښو کې خلکو ته مالومات ورکړۍ چې ستاسې ويکي د څه په اړه دی',
	'cnw-desc-select-categories' => 'اضافه وېشنيزې ټاکل',
	'cnw-desc-select-one' => 'يو وټاکۍ',
	'cnw-desc-default-lang' => 'ستاسې ويکي به په $1 ژبه وي',
	'cnw-desc-change-lang' => 'بدلول',
	'cnw-desc-lang' => 'ژبه',
	'cnw-desc-wiki-submit-error' => 'يوه وېشنيزه وټاکۍ',
	'cnw-theme-headline' => 'خپل ويکي سکښتل',
	'cnw-welcome-headline' => 'بختور مو شه، د $1 ويکي جوړ شو',
	'cnw-error-blocked-header' => 'پر گڼون بنديز ولگېد',
	'cnw-error-anon-user-header' => 'لطفاً ورننوځئ',
);

/** Portuguese (português)
 * @author Geitost
 * @author Hamilton Abreu
 * @author Imperadeiro98
 * @author Josep Maria 15.
 * @author Luckas
 * @author Malafaya
 * @author SandroHc
 * @author Vitorvicentevalente
 * @author Waldir
 */
$messages['pt'] = array(
	'createnewwiki-desc' => 'Assistente de criação de wikias',
	'cnw-next' => 'Próximo',
	'cnw-back' => 'Voltar',
	'cnw-or' => 'ou',
	'cnw-title' => 'Crie uma nova wikia',
	'cnw-name-wiki-headline' => 'Criar uma wikia',
	'cnw-name-wiki-creative' => 'Crie um site, desenvolva uma comunidade e embarque em sua melhor experiência como fã.',
	'cnw-name-wiki-label' => 'Nome da sua wikia',
	'cnw-name-wiki-domain-label' => 'Dê um endereço a sua wikia',
	'cnw-name-wiki-submit-error' => 'Opa! Você precisa preencher ambas as caixas acima para continuar.',
	'cnw-login' => 'Inicie sessão',
	'cnw-signup' => 'Crie uma conta',
	'cnw-signup-prompt' => 'Você precisa de uma conta?',
	'cnw-call-to-signup' => 'Registre-se aqui',
	'cnw-login-prompt' => 'Você já tem uma conta?',
	'cnw-call-to-login' => 'Inicie sessão aqui',
	'cnw-auth-headline' => 'Inicie sessão',
	'cnw-auth-headline2' => 'Registre-se',
	'cnw-auth-creative' => 'Entre na sua conta para continuar construindo a sua wikia.',
	'cnw-auth-signup-creative' => 'Você precisa de uma conta para continuar a construir sua wikia.<br />Leva apenas um minuto para se registrar!',
	'cnw-auth-facebook-signup' => 'Crie uma conta com Facebook',
	'cnw-auth-facebook-login' => 'Iniciar sessão com Facebook',
	'cnw-userauth-headline' => 'Você tem uma conta?',
	'cnw-userauth-creative' => 'Inicie sessão',
	'cnw-userauth-marketing-heading' => 'Você não tem uma conta?',
	'cnw-userauth-marketing-body' => 'Você precisa de uma conta para criar uma wikia na Wikia. Leva apenas um minuto para se registrar!',
	'cnw-userauth-signup-button' => 'Registre-se',
	'cnw-desc-headline' => 'Sobre o que é a sua wikia?',
	'cnw-desc-creative' => 'Ajude as pessoas a encontrar sua wikia com uma excelente descrição.',
	'cnw-desc-placeholder' => 'Capriche! Seu texto aparecerá na página principal da sua wikia.',
	'cnw-desc-tip1' => 'Aqui vai uma dica!',
	'cnw-desc-tip1-creative' => 'Use este espaço para descrever a sua wikia aos visitantes.',
	'cnw-desc-tip2' => 'Obs',
	'cnw-desc-tip2-creative' => 'Encoraje outros a juntar-se a sua comunidade oferecendo detalhes sobre sua wikia.',
	'cnw-desc-select-one' => 'Selecione uma',
	'cnw-desc-all-ages' => 'Esta wikia é destinada a crianças?',
	'cnw-desc-tip-all-ages' => 'Esta wikia é sobre um assunto que interessa a crianças? A fim de nos ajudar a cumprir a lei dos Estados Unidos, nós acompanhamos de perto as wikias sobre assuntos de interesse de crianças até 12 anos.',
	'cnw-desc-default-lang' => 'Sua wikia será em $1',
	'cnw-desc-change-lang' => 'alterar',
	'cnw-desc-lang' => 'Idioma',
	'cnw-desc-wiki-submit-error' => 'Por favor, escolha uma categoria',
	'cnw-theme-headline' => 'Escolha um tema',
	'cnw-theme-creative' => 'Capriche! Selecione um tema para ver uma prévia.
',
	'cnw-theme-instruction' => 'Quer personalizar? Você pode criar o seu próprio tema mais tarde usando o Designer de temas no Painel de administração.',
	'cnw-welcome-headline' => 'Parabéns! Você criou com êxito a $1',
	'cnw-welcome-instruction1' => 'Clique no botão abaixo para começar a criar páginas na sua wikia.',
	'cnw-welcome-help' => 'Encontre respostas, conselhos, e muito mais na <a href="http://comunidade.wikia.com">Central da Comunidade Wikia</a>.',
	'cnw-error-general' => 'Opa, algo deu errado em nosso sistema! Por favor, tente novamente ou [[Special:Contact|entre em contato]] conosco para obter ajuda.',
	'cnw-error-general-heading' => 'Nossas desculpas',
	'cnw-badword-header' => 'Atenção',
	'cnw-badword-msg' => 'Olá, por favor não use palavras grosseiras ou proibidas na descrição da Wikia: $1',
	'cnw-error-wiki-limit-header' => 'Limite de wikias atingido',
	'cnw-error-wiki-limit' => 'Olá, você está limitado a {{PLURAL:$1|criar $1 wikia|criar $1 wikias}} por dia. Espere 24 horas antes de criar outra wikia.',
	'cnw-error-blocked-header' => 'Conta bloqueada',
	'cnw-error-blocked' => 'Você foi bloqueado por $1. O motivo dado foi: $2. (ID de Bloqueio para referência: $3)',
	'cnw-error-anon-user-header' => 'Por favor, inicie sessão',
	'cnw-error-anon-user' => 'A criação de wikias para usuários anônimos está desativada. Por favor [[Special:UserLogin|faça login]] e tente novamente.',
	'cnw-error-torblock' => 'A criação de wikias usando a rede Tor não é permitida.',
	'cnw-error-bot' => 'Detectamos que você pode ser um robô. Se cometemos um engano, por favor descreva que você foi erroneamente detectado como um robô, e o ajudaremos a criar sua wikia: [http://www.wikia.com/Special:Contact/Contate-nos geral]',
	'cnw-error-bot-header' => 'Você foi detectado como um robô.',
	'cnw-error-unconfirmed-email-header' => 'Seu endereço de e-mail não foi confirmado.',
	'cnw-error-unconfirmed-email' => 'Seu endereço de e-mail deve ser confirmado para criar uma wikia.',
	'cnw-name-wiki-language' => '',
	'cnw-name-wiki-domain' => '.wikia.com',
	'cnw-desc-select-vertical' => 'Selecione um Portal',
	'cnw-desc-select-categories' => 'Selecione categorias adicionais',
	'autocreatewiki' => 'Crie uma nova wikia',
	'autocreatewiki-desc' => 'Crie uma wikia no WikiFactory a partir de pedidos de usuários.',
	'autocreatewiki-page-title-default' => 'Crie uma nova wikia',
	'autocreatewiki-page-title-answers' => 'Crie um novo site de Respostas',
	'createwiki' => 'Crie uma nova wikia',
	'autocreatewiki-chooseone' => 'Escolha um(a)',
	'autocreatewiki-required' => '$1 = necessário',
	'autocreatewiki-web-address' => 'Endereço web:',
	'autocreatewiki-category-select' => 'Escolha um(a)',
	'autocreatewiki-language-top' => 'Os $1 idiomas mais usados',
	'autocreatewiki-language-all' => 'Todos os idiomas',
	'autocreatewiki-remember' => 'Lembrar de mim',
	'autocreatewiki-create-account' => 'Crie uma conta',
	'autocreatewiki-haveaccount-question' => 'Você já tem uma conta Wikia?',
	'autocreatewiki-info-domain' => 'É melhor usar uma palavra que funcione como palavra-chave para facilitar a busca de seu tópico.',
	'autocreatewiki-info-topic' => 'Adicione uma breve descrição como "Star Wars" ou "Programas de TV".',
	'autocreatewiki-info-category-default' => 'Isto ajudará os visitantes a encontrar a sua wikia.',
	'autocreatewiki-info-category-answers' => 'Isto ajudará os visitantes a encontrar o seu site de Respostas.',
	'autocreatewiki-info-language' => 'Este será o idioma padrão para os visitantes da sua wikia.',
	'autocreatewiki-info-email-address' => 'Seu e-mail nunca é mostrado para ninguém na Wikia.',
	'autocreatewiki-info-realname' => 'Se você optar por fornecê-lo, isso será usado para dar atribuição por seu trabalho.',
	'autocreatewiki-info-birthdate' => 'A Wikia exige que todos os usuários forneçam suas datas de nascimento verdadeiras como medida de segurança e para preservar a integridade do site, mantendo a conformidade com os regulamentos federais.',
	'autocreatewiki-info-blurry-word' => 'Para ajudar a proteger o site contra a criação automática de contas, digite a palavra borrada que você vê dentro deste campo.',
	'autocreatewiki-info-terms-agree' => 'Ao criar uma wikia e uma conta de usuário, você está concordando com os {{#NewWindowLink: w: pt:Terms of use |Termos de Uso da Wikia}}',
	'autocreatewiki-info-staff-username' => '<b>Apenas para o staff:</b> O usuário especificado será listado como fundador.',
	'autocreatewiki-title-template' => 'Wikia $1',
	'autocreatewiki-tagline' => '',
	'autocreatewiki-limit-day' => 'A Wikia excedeu o número máximo de criação de wikias hoje ($1).',
	'autocreatewiki-limit-creation' => 'Você excedeu o número máximo de criação de wikias em 24 horas ($1).',
	'autocreatewiki-empty-field' => 'Por favor, preencha esse campo.',
	'autocreatewiki-bad-name' => 'O nome não pode conter caracteres especiais (como $ ou @) nem espaços e precisa estar todo em minúsculas.',
	'autocreatewiki-invalid-wikiname' => 'O nome não pode conter caracteres especiais (como $ ou @) e não pode estar vazio.',
	'autocreatewiki-violate-policy' => 'Esse nome contém uma palavra que viola as nossas políticas de nomeação',
	'autocreatewiki-name-taken' => 'Já existe uma wikia com este endereço. Você pode editá-la em <ahref="http://$1.wikia.com">http://$1.wikia.com</a> ou escolher outro endereço.',
	'autocreatewiki-name-too-short' => 'Este endereço é muito curto, por favor escolha outro com no mímino 3 caracteres.',
	'autocreatewiki-name-too-long' => 'Este endereço é muito longo. Escolha outro com no máximo 50 caracteres.',
	'autocreatewiki-similar-wikis' => 'Abaixo estão as wikias já criadas sobre este tópico. Nós sugerimos que você edite uma delas.',
	'autocreatewiki-invalid-username' => 'Este nome de usuário é inválido.',
	'autocreatewiki-busy-username' => 'Este nome de usuário já está sendo usado.',
	'autocreatewiki-blocked-username' => 'Você não pode criar uma conta.',
	'autocreatewiki-user-notloggedin' => 'Sua conta foi criada, mas você não está conectado!',
	'autocreatewiki-empty-language' => 'Por favor, selecione o idioma da wikia.',
	'autocreatewiki-empty-category' => 'Por favor, selecione uma categoria.',
	'autocreatewiki-empty-wikiname' => 'O nome da wikia não pode estar vazio.',
	'autocreatewiki-empty-username' => 'O nome de usuário não pode estar vazio.',
	'autocreatewiki-empty-password' => 'A senha não pode estar vazia.',
	'autocreatewiki-empty-retype-password' => '"Redigite sua senha" não pode estar vazio.',
	'autocreatewiki-category-label' => 'Categoria:',
	'autocreatewiki-category-other' => 'Outro',
	'autocreatewiki-set-username' => 'Primeiro defina o nome de usuário.',
	'autocreatewiki-invalid-category' => 'Categoria inválida.
Selecione uma apropriada da lista.',
	'autocreatewiki-invalid-language' => 'Idioma inválido.
Selecione um apropriado da lista.',
	'autocreatewiki-invalid-retype-passwd' => 'Redigite a mesma senha acima',
	'autocreatewiki-invalid-birthday' => 'Data de nascimento inválida',
	'autocreatewiki-log-title' => 'A sua wikia está sendo criada.',
	'autocreatewiki-step0' => 'Iniciando processo ...',
	'autocreatewiki-stepdefault' => 'Em processo, por favor aguarde...',
	'autocreatewiki-errordefault' => 'O processo não foi finalizado...',
	'autocreatewiki-step1' => 'Criando a pasta de imagens ...',
	'autocreatewiki-step2' => 'Criando o banco de dados...',
	'autocreatewiki-step3' => 'Definindo as informações padrão no banco de dados ...',
	'autocreatewiki-step4' => 'Copiando as imagens e logotipo padrões ...',
	'autocreatewiki-step5' => 'Definindo as variáveis padrão no banco de dados ...',
	'autocreatewiki-step6' => 'Definindo as tabelas padrão no banco de dados ...',
	'autocreatewiki-step7' => 'Definindo idioma inicial ...',
	'autocreatewiki-step8' => 'Definindo grupos de usuários e categorias ...',
	'autocreatewiki-step9' => 'Definindo variáveis da nova wikia ...',
	'autocreatewiki-step10' => 'Definindo páginas na wikia central ...',
	'autocreatewiki-step11' => 'Enviando e-mail para o usuário...',
	'autocreatewiki-redirect' => 'Redirecionando para a nova wikia: $1 ...',
	'autocreatewiki-congratulation' => 'Parabéns!',
	'autocreatewiki-welcometalk-log' => 'Mensagem de Boas-vindas',
	'autocreatewiki-regex-error-comment' => 'usado na wikia $1 (texto completo: $2)',
	'autocreatewiki-step2-error' => 'O banco de dados existe!',
	'autocreatewiki-step3-error' => 'Não é possível definir informações padrão no banco de dados!',
	'autocreatewiki-step6-error' => 'Não é possível definir as tabelas padrão no banco de dados!',
	'autocreatewiki-step7-error' => 'Não é possível copiar o banco de dados inicial para a língua!',
	'requestwiki-filter-language' => 'als,an,ang,ast,bar,de2,de-at,de-ch,de-formal,de-weigsbrag,dk,en-gb,eshelp,fihelp,frc,frhelp,ia,ie,ithelp,jahelp,kh,kohelp,kp,ksh,nb,nds,nds-nl,mu,mwl,nlhelp,pdc,pdt,pfl,pthelp,pt-brhelp,ruhelp,simple,tokipona,tp,zh-classical,zh-cn,zh-hans,zh-hant,zh-hk,zh-min-nan,zh-mo,zh-my,zh-sg,zh-tw,zh-yue',
	'autocreatewiki-protect-reason' => 'Parte da interface oficial',
	'autocreatewiki-welcomesubject' => '$1 foi criada!',
	'autocreatewiki-welcomebody' => 'Olá, $2!

Sua wiki foi criada! Dê uma olhada: <$1>

Pronto para começar? Adicionamos alguns links a sua página de discussão (<$5>) para o ajudar a começar e para encorajá-lo a explorar as variadas áreas úteis da Wikia. Caso tenha dúvidas ou se sinta um pouco perdido, responda a este e-mail ou confira nossas Páginas de Ajuda <http://help.wikia.com>.

Você também pode conferir o blog do Fundador & Administrador <http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins> e o blog do staff da Wikia <http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog>, onde você achará dicas, truques e informações sobre os novos recursos e novas coisas que estão acontecendo na Wikia.

Boa edição!

$3
Suporte da Comunidade Wikia
<http://community.wikia.com/wiki/User:$4>

___________________________________________
* Quer receber menos mensagens de nós? Você pode desinscrever-se ou configurar suas preferências de e-mail aqui: http://community.wikia.com/Special:Preferences',
	'autocreatewiki-welcometalk-wall-title' => 'Bem-vindo!',
	'autocreatewiki-welcometalk-wall' => 'Olá, estamos felizes em ter {{subst:SITENAME}} como parte da comunidade Wikia!

Ainda há muita coisa a fazer; aqui estão algumas dicas e links importantes para incrementar sua wikia:
*Confira os [[Special:WikiFeatures|Recursos da Wiki]] para ver quais recursos você pode ativar em sua wikia, incluindo Chat, Medalhas e muito mais.
*Personalize o visual de sua wikia visitando [[Special:ThemeDesigner|Theme Designer]], onde você pode adicionar cor e estilo ao seu background e ao logotipo.
*Pare na [[w:c:comunidade|Central da Comunidade]] para ficar informado através do nosso [[w:c:comunidade:Categoria:Notícias da Wikia|blog da equipe]], tenha suas dúvidas respondidas no nosso [[w:c:comunidade:Special:Forum|fórum da comunidade]], ou converse ao vivo com outros Wikianos.
*Por último, visite nossas [[Ajuda:Conteúdos|páginas de ajuda]] para aprender mais sobre as manhas de como usar a Wikia, incluindo [[Ajuda:Nova página|como adicionar uma nova página a sua wikia]], [[Ajuda:Atraindo contribuidores|como atrair contribuidores]] e [[Ajuda:Níveis_de_acesso_de_usuários|como adicionar outros administradores]].
* Você também pode utilizar todas essas ferramentas visitando o Painel de administração clicando "Admin" na barra de ferramentas inferior.

Todos os links acima são bons lugares para começar explorando, divirta-se!',
	'autocreatewiki-welcometalk' => '== Bem-vindo! ==
Olá!

Estamos felizes em ter $4 como parte da comunidade Wikia! Ainda há muita coisa a fazer; aqui estão algumas dicas e links importantes para incrementar sua wikia:

*Confira os [[Special:WikiFeatures|Recursos da Wiki]] para ver quais recursos você pode ativar em sua wikia, incluindo Chat, Medalhas e muito mais.
*Pare na [[w:c:comunidade|Central da Comunidade]] para ficar informado através do nosso [[w:c:comunidade:Categoria:Notícias da Wikia|blog da equipe]], tenha suas dúvidas respondidas no nosso [[w:c:comunidade:Special:Forum|fórum da comunidade]], ou converse ao vivo com outros Wikianos.
*Por último, visite nossas [[Ajuda:Conteúdos|páginas de ajuda]] para aprender mais sobre as manhas de como usar a Wikia.

Todos os links acima são ótimos lugares para começar explorando, divirta-se!

-- [[User:$2|$3]] <staff />',
	'autocreatewiki-language-top-list' => 'de,en,es,fr,it,ja,pl,pt-br,ru,zh',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Aristóbulo
 * @author Caio1478
 * @author Guilhermemau
 * @author JM Pessanha
 * @author Jefersonmoraes
 * @author Luckas
 * @author Luckas Blade
 * @author Sudastelaro
 * @author TheGabrielZaum
 */
$messages['pt-br'] = array(
	'createnewwiki-desc' => 'Assistente de criação de wikias',
	'cnw-next' => 'Próximo',
	'cnw-back' => 'Voltar',
	'cnw-or' => 'ou',
	'cnw-title' => 'Criar uma Nova Wikia',
	'cnw-name-wiki-headline' => 'Iniciar uma Wikia',
	'cnw-name-wiki-creative' => 'A Wikia é o melhor lugar para criar um site e desenvolver uma comunidade em torno de um tema do seu agrado.',
	'cnw-name-wiki-label' => 'Nome da sua wikia',
	'cnw-name-wiki-domain-label' => 'Dê um endereço a sua wikia',
	'cnw-name-wiki-submit-error' => 'Ops! Você precisa preencher ambas as caixas acima para continuar.',
	'cnw-login' => 'Login',
	'cnw-signup' => 'Criar Conta',
	'cnw-signup-prompt' => 'Precisa de uma conta?',
	'cnw-call-to-signup' => 'Registre-se aqui',
	'cnw-login-prompt' => 'Já tem uma conta?',
	'cnw-call-to-login' => 'Faça login aqui',
	'cnw-auth-headline' => 'Login',
	'cnw-auth-headline2' => 'Registrar-se',
	'cnw-auth-creative' => 'Faça login na sua conta para continuar construindo a sua wikia.',
	'cnw-auth-signup-creative' => 'Você vai precisar de uma conta para continuar a construir sua wikia.<br />Leva apenas um minuto para se registrar!',
	'cnw-auth-facebook-signup' => 'Registrar-se com Facebook',
	'cnw-auth-facebook-login' => 'Login com Facebook',
	'cnw-userauth-headline' => 'Você tem uma conta?',
	'cnw-userauth-creative' => 'Login',
	'cnw-userauth-marketing-heading' => 'Você não tem uma conta?',
	'cnw-userauth-marketing-body' => 'Você precisa de uma conta para criar uma wikia na Wikia. Leva apenas um minuto para se registrar!',
	'cnw-userauth-signup-button' => 'Registrar-se',
	'cnw-desc-headline' => 'Sobre o que é a sua wikia?',
	'cnw-desc-creative' => 'Sua descrição vai ajudar as pessoas a encontrar a seu wikia',
	'cnw-desc-placeholder' => 'Isso vai aparecer na página principal da sua wikia.',
	'cnw-desc-tip1' => 'Sugestão',
	'cnw-desc-tip1-creative' => 'Use este espaço para descrever a sua wikia aos visitantes numa frase ou duas',
	'cnw-desc-tip2' => 'Psiu',
	'cnw-desc-tip2-creative' => 'Dê aos visitantes alguns detalhes específicos sobre o assunto',
	'cnw-desc-select-vertical' => 'Selecione uma categoria Hub',
	'cnw-desc-select-categories' => 'Selecione categorias adicionais',
	'cnw-desc-select-one' => 'Selecione uma',
	'cnw-desc-all-ages' => 'Esta wikia é destinada a crianças?',
	'cnw-desc-tip-all-ages' => 'Esta wikia é sobre um assunto no qual crianças estariam interessadas? A fim de nos ajudar a cumprir a lei dos Estados Unidos, nós mantemos o controle de wikias sobre assuntos que se dirigem diretamente para crianças de até 12 anos.',
	'cnw-desc-default-lang' => 'Sua wikia será em $1',
	'cnw-desc-change-lang' => 'alterar',
	'cnw-desc-lang' => 'Idioma',
	'cnw-desc-wiki-submit-error' => 'Por favor, escolha uma categoria',
	'cnw-theme-headline' => 'Escolha um tema',
	'cnw-theme-creative' => 'Escolha um tema abaixo, você será capaz de ver uma prévia de cada tema, quando você selecioná-lo.',
	'cnw-theme-instruction' => "Você também pode criar o seu próprio tema mais tarde usando ''Minhas Ferramentas''.",
	'cnw-welcome-headline' => 'Parabéns! A $1 foi criada',
	'cnw-welcome-instruction1' => 'Clique no botão abaixo para começar a criar páginas na sua wikia.',
	'cnw-welcome-help' => 'Encontre respostas, conselhos, e muito mais na <a href="http://comunidade.wikia.com">Central da Comunidade Wikia</a>.',
	'cnw-error-general' => 'Opa, algo deu errado em nosso sistema! Por favor, tente novamente ou [[Special:Contact|entre em contato]] conosco para obter ajuda.',
	'cnw-error-general-heading' => 'Nossas desculpas',
	'cnw-badword-header' => 'Atenção',
	'cnw-badword-msg' => 'Olá, por favor não use estas palavras grosseiras ou banidas na sua Descrição da Wikia: $1',
	'cnw-error-wiki-limit-header' => 'Limite de wikias atingido',
	'cnw-error-wiki-limit' => 'Olá, você está limitado a {{PLURAL:$1|criar $1 wikia|criar $1 wikias}} por dia. Espere 24 horas antes de criar outra wikia.',
	'cnw-error-blocked-header' => 'Conta bloqueada',
	'cnw-error-blocked' => 'Você foi bloqueado por $1. O motivo dado foi: $2. (ID de Bloqueio para referência: $3)',
	'cnw-error-anon-user-header' => 'Por favor, faça login',
	'cnw-error-anon-user' => 'A criação de wikias para usuários anônimos está desativada. Por favor [[Special:UserLogin|faça login]] e tente novamente.',
	'cnw-error-torblock' => 'Criar wikias usando a rede Tor não é permitido.',
	'cnw-error-bot' => 'Detectamos que você pode ser um robô. Se cometemos um engano, por favor descreva que você foi erroneamente detectado como um robô, e o ajudaremos a criar sua wikia: [http://www.wikia.com/Special:Contact/Contate-nos geral]',
	'cnw-error-bot-header' => 'Você foi detectado como um robô',
	'cnw-error-unconfirmed-email-header' => 'Seu endereço de e-mail não foi confirmado',
	'cnw-error-unconfirmed-email' => 'Seu endereço de e-mail deve ser confirmado para criar uma wikia.',
);

/** Romanian (română)
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'cnw-or' => 'sau',
	'cnw-title' => 'Crează un nou wiki',
	'cnw-name-wiki-headline' => 'Porneşte un wiki',
	'cnw-name-wiki-creative' => 'Wikia este cel mai bun loc ca să construieşti un sait web şi să creşti o comunitate în jurul a ceea ce-ţi place.',
	'cnw-name-wiki-domain-label' => 'Dă-i wiki-ului tău o adresă',
	'cnw-name-wiki-submit-error' => 'Ups! Trebuie să completezi ambele căsuţe de mai sus pentru a continua.',
	'cnw-login' => 'Autentificare',
	'cnw-signup' => 'Crează un cont',
	'cnw-signup-prompt' => 'Ai nevoie de-un cont?',
	'cnw-call-to-signup' => 'Înscrie-te aici',
	'cnw-login-prompt' => 'Aveţi deja un cont?',
	'cnw-call-to-login' => 'Autentificaţi-vă aici',
	'cnw-auth-headline' => 'Autentificare',
	'cnw-auth-headline2' => 'Înregistrare',
	'cnw-auth-facebook-signup' => 'Înscrieţi-vă cu Facebook',
	'cnw-auth-facebook-login' => 'Autentificaţi-vă cu Facebook',
	'cnw-desc-creative' => 'Descrieţi-vă subiectul',
	'cnw-desc-placeholder' => 'Asta va apărea pe pagina principală a wiki-ului tău.',
	'cnw-desc-tip2-creative' => 'Dă-le vizitatorilor tăi unele detalii specifice despre subiectul tău',
	'cnw-desc-select-one' => 'Selectează una',
	'cnw-desc-default-lang' => 'Wiki-ul tău va fi în $1',
	'cnw-desc-change-lang' => 'schimbă',
	'cnw-desc-lang' => 'Limbă',
	'cnw-desc-wiki-submit-error' => 'Te rugăm alege o categorie',
	'cnw-theme-headline' => 'Alege o temă',
	'cnw-welcome-instruction1' => 'Apasă pe butonul de mai jos pentru a începe să adaugi pagini wiki-ului tău.',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'createnewwiki-desc' => "Procedure de ccrejazione d'a Uicchi",
	'cnw-next' => 'Prossime',
	'cnw-back' => 'Rrete',
	'cnw-or' => 'o',
	'cnw-title' => "Ccreje 'na uicchi nove",
	'cnw-name-wiki-headline' => "Fà partè 'na Uicchi",
	'cnw-name-wiki-label' => "Nome d'a uicchi tune",
	'cnw-name-wiki-domain-label' => "Da 'a uicchi toje 'n'indirizze",
	'cnw-login' => 'Tràse',
	'cnw-signup' => "Ccreje 'nu cunde",
	'cnw-signup-prompt' => "E' abvesògne de 'nu cunde?",
	'cnw-call-to-signup' => 'Reggistrate aqquà',
	'cnw-login-prompt' => "Tìne ggià 'nu cunde?",
	'cnw-call-to-login' => 'Tràse aqquà',
	'cnw-auth-headline' => 'Tràse',
	'cnw-auth-headline2' => 'Reggistrate',
	'cnw-auth-facebook-login' => 'Tràse cu Feisbuk',
	'cnw-userauth-headline' => "Tìne 'nu cunde?",
	'cnw-userauth-creative' => 'Tràse',
	'cnw-userauth-marketing-heading' => "Non ge tìne 'nu cunde?",
	'cnw-userauth-marketing-body' => "Tu è abbesògne de 'nu cunde pe ccrejà 'na uicchi sus a Uicchia. Te serve sulamende 'nu minute pe reggistrarte.",
	'cnw-userauth-signup-button' => 'Reggistrate',
	'cnw-desc-headline' => "Sus a ce ccose jè 'a uicchi toje?",
	'cnw-desc-creative' => "Dè 'na màne a le crestiane ca volene cu iacchiane 'a uicchi toje cu 'na descrizione a uerre probbie.",
	'cnw-desc-tip1' => "Aqquà ste 'nu consiglie!",
	'cnw-desc-tip1-creative' => 'Ause stu spazie pe dicere a le crestiane ce face sta uicchi e purcé ha state ccrejate.',
	'cnw-desc-tip2' => 'PS',
	'cnw-desc-select-one' => 'Scacchie une',
	'cnw-desc-all-ages' => 'Sta uicchi è pe le piccinne?',
	'cnw-desc-change-lang' => 'cange',
	'cnw-desc-lang' => 'Lènghe',
	'cnw-desc-wiki-submit-error' => "Pe piacere scacchie 'na categorije",
	'cnw-theme-headline' => "Scacchie 'nu teme",
	'cnw-error-general-heading' => 'Le scuse nostre',
	'cnw-error-blocked-header' => 'Cunde bloccate',
	'cnw-error-bot-header' => "Tu è state signalate cumme a 'nu bot",
);

/** Russian (русский)
 * @author DCamer
 * @author Ignatus
 * @author Kuzura
 * @author Okras
 * @author Дмитрий
 */
$messages['ru'] = array(
	'createnewwiki-desc' => 'Мастер создания вики',
	'cnw-next' => 'Далее',
	'cnw-back' => 'Назад',
	'cnw-or' => 'или',
	'cnw-title' => 'Создать новую вики',
	'cnw-name-wiki-headline' => 'Создание вики',
	'cnw-name-wiki-creative' => 'Создайте собственный сайт, найдите единомышленников и погрузитесь в невероятный мир Викия!',
	'cnw-name-wiki-label' => 'Дайте название вики',
	'cnw-name-wiki-domain-label' => 'Задайте адрес вики',
	'cnw-name-wiki-submit-error' => 'Чтобы продолжить, необходимо заполнить оба полях выше.',
	'cnw-login' => 'Войти',
	'cnw-signup' => 'Создать учётную запись',
	'cnw-signup-prompt' => 'Нужна учетная запись?',
	'cnw-call-to-signup' => 'Зарегистрироваться здесь',
	'cnw-login-prompt' => 'Уже есть учетная запись?',
	'cnw-call-to-login' => 'Войти в систему',
	'cnw-auth-headline' => 'Войти',
	'cnw-auth-headline2' => 'Регистрация',
	'cnw-auth-creative' => 'Войдите в свою учётную запись, чтобы продолжить создание вики.',
	'cnw-auth-signup-creative' => 'Чтобы продолжить создание вики, необходима учётная запись.<br />Регистрация займёт всего одну минуту!',
	'cnw-auth-facebook-signup' => 'Зарегистрироваться через Facebook',
	'cnw-auth-facebook-login' => 'Войти через Facebook',
	'cnw-userauth-headline' => 'Есть учетная запись?',
	'cnw-userauth-creative' => 'Войти',
	'cnw-userauth-marketing-heading' => 'Нет учетной записи?',
	'cnw-userauth-marketing-body' => 'Чтобы создать вики на Викия, необходима учетная запись. Регистрация займёт всего одну минуту!',
	'cnw-userauth-signup-button' => 'Регистрация',
	'cnw-desc-headline' => 'О чём ваша вики?',
	'cnw-desc-creative' => 'Составьте описание, которое поможет людям найти вашу вики.',
	'cnw-desc-placeholder' => 'Постарайтесь! Ваш текст будет отображаться на заглавной странице вики.',
	'cnw-desc-tip1' => 'Подсказка!',
	'cnw-desc-tip1-creative' => 'В этом поле расскажите о значении и целях вашей вики.',
	'cnw-desc-tip2' => 'PS',
	'cnw-desc-tip2-creative' => 'Чтобы сделать вашу вики более популярной, попробуйте раскрыть посетителям некоторые ее подробности.',
	'cnw-desc-select-vertical' => 'Выберите категорию портала',
	'cnw-desc-select-categories' => 'Выберите дополнительные категории',
	'cnw-desc-select-one' => 'Выберите категорию',
	'cnw-desc-all-ages' => 'Эта вики предназначена для детей?',
	'cnw-desc-tip-all-ages' => 'Тема проекта будет интересна детям? Для соблюдения законодательства США мы отслеживаем проекты по темам, которые непосредственно предназначены для детей в возрасте 12 лет и младше.',
	'cnw-desc-default-lang' => 'Язык вашей вики – $1',
	'cnw-desc-change-lang' => 'изменить',
	'cnw-desc-lang' => 'Язык',
	'cnw-desc-wiki-submit-error' => 'Необходимо выбрать категорию',
	'cnw-theme-headline' => 'Выбор темы',
	'cnw-theme-creative' => 'Сделайте свою вики красивой! Вы можете просмотреть каждую тему до того, как сделать окончательный выбор.',
	'cnw-theme-instruction' => 'Хотите проявить индивидуальность? Вы можете создать свои собственные темы позже, перейдя в «Конструктор тем» через панель администратора.',
	'cnw-welcome-headline' => 'Поздравляем! Вики «$1» создана',
	'cnw-welcome-instruction1' => 'Нажмите на кнопку ниже, чтобы начать добавлять страницы на вики.',
	'cnw-welcome-help' => 'Продолжайте в том же духе! Посетите <a href="http://ru.community.wikia.com/wiki/Викия">Вики Сообщества</a>, чтобы найти ответы на вопросы, полезные советы и многое другое.',
	'cnw-error-general' => 'Что-то не сработало в нашей системе! Попробуйте еще раз или [[Special:Contact|обратитесь к нам]] за помощью.',
	'cnw-error-general-heading' => 'Приносим свои извинения',
	'cnw-badword-header' => 'Эй там!',
	'cnw-badword-msg' => 'Здравствуйте! Воздержитесь от использования плохих или запрещенных слов в описании вики: $1.',
	'cnw-error-wiki-limit-header' => 'Лимит создания вики',
	'cnw-error-wiki-limit' => 'Привет, вы достигли предельного количества вики в день ({{PLURAL:$1|$1 вики|$1 викии|$1 вики}}). Подождите 24 часа перед созданием другой вики..',
	'cnw-error-blocked-header' => 'Учётная запись заблокирована',
	'cnw-error-blocked' => 'Вы были заблокированы пользователем $1. Причина: $2. (Для справки: $3)',
	'cnw-error-anon-user-header' => 'Пожалуйста, войдите в систему',
	'cnw-error-anon-user' => 'Создание вики для анонимов отключено. Пожалуйста, [[Special:UserLogin|войдите в систему]] и повторите попытку.',
	'cnw-error-torblock' => 'Создание вики через сеть Tor не допускается.',
	'cnw-error-bot' => 'Мы установили, что вы можете быть ботом. Если была допущена ошибка, пожалуйста, свяжитесь с нами и подтвердите, что вы не бот, и мы поможем вам в создании новой вики: [http://www.wikia.com/Special:Contact/general Связаться с нами]',
	'cnw-error-bot-header' => 'Вы были определены как бот',
	'cnw-error-unconfirmed-email-header' => 'Адрес электронной почты не был подтверждён',
	'cnw-error-unconfirmed-email' => 'Чтобы создать Вики, необходимо подтвердить адрес электронной почты.',
	'cnw-name-wiki-language' => '',
	'cnw-name-wiki-domain' => '.wikia.com',
	'autocreatewiki' => 'Создать новую вики',
	'autocreatewiki-desc' => 'Создать вики в WikiFactory по запросам участников',
	'autocreatewiki-page-title-default' => 'Создать новую вики',
	'autocreatewiki-page-title-answers' => 'Создать новый сайт ответов',
	'createwiki' => 'Создать новую вики',
	'autocreatewiki-chooseone' => 'Выберите из списка',
	'autocreatewiki-required' => '$1 = обязательно',
	'autocreatewiki-web-address' => 'Веб-адрес:',
	'autocreatewiki-category-select' => 'Выберите одну категорию',
	'autocreatewiki-language-top' => 'Наиболее используемые языки ($1)',
	'autocreatewiki-language-all' => 'Все языки',
	'autocreatewiki-remember' => 'Запомнить меня',
	'autocreatewiki-create-account' => 'Создание учётной записи',
	'autocreatewiki-haveaccount-question' => 'У вас уже есть учётная записи Викия?',
	'autocreatewiki-info-domain' => 'Рекомендуется использовать такое слово, которое для вашей темы будет ключевым при поиске.',
	'autocreatewiki-info-topic' => 'Добавьте краткое описание, например, «Звёздные войны» или «ТВ-шоу».',
	'autocreatewiki-info-category-default' => 'Это поможет посетителям найти вашу вики.',
	'autocreatewiki-info-category-answers' => 'Это поможет посетителям найти ваш сайт ответов.',
	'autocreatewiki-info-language' => 'Язык по умолчанию для посетителей вашей вики.',
	'autocreatewiki-info-email-address' => 'Викия никому не показывает адрес вашей электронной почты.',
	'autocreatewiki-info-realname' => 'Если вы решите предоставить его, он будет использован для указания авторства вашей работы.',
	'autocreatewiki-info-birthdate' => 'Согласно требованиям Викия, все пользователи должны указывать свою настоящую дату рождения. Это мера позволяет обеспечить безопасность и соответствие сайта требованиям федеральных правил.',
	'autocreatewiki-info-blurry-word' => 'Введите размытое слово, которое вы видите, в это поле. Это делается для защиты от автоматического создания учётных записей.',
	'autocreatewiki-info-terms-agree' => 'Создавая вики и учётную запись, вы соглашаетесь с {{#NewWindowLink: w:Terms of use |Условиями использования Викия}}.',
	'autocreatewiki-info-staff-username' => '<b>Только для сотрудников:</b> указанный участник будет показан как основатель.',
	'autocreatewiki-title-template' => 'Вики $1',
	'autocreatewiki-tagline' => '',
	'autocreatewiki-limit-day' => 'Сегодня Викия превысила максимальное число создаваемых вики ($1).',
	'autocreatewiki-limit-creation' => 'Вы превысили максимальное количество вики, которое можно создать за 24 часа ($1).',
	'autocreatewiki-empty-field' => 'Пожалуйста, заполните это поле.',
	'autocreatewiki-bad-name' => 'Название не может содержать специальные символы (например, $ или @) и должно быть представлено одним словом, написанным строчными буквами без пробелов.',
	'autocreatewiki-invalid-wikiname' => 'Название не может содержать специальные символы (например, $ или @) и является обязательным для заполнения.',
	'autocreatewiki-violate-policy' => 'Название вики содержит слово, нарушающее наши правила именования.',
	'autocreatewiki-name-taken' => 'Вики с таким адресом уже существует. Вы можете присоединиться к проекту <a href="http://$1.wikia.com">http://$1.wikia.com</a> или выбрать другой адрес.',
	'autocreatewiki-name-too-short' => 'Слишком короткий адрес. Выберите адрес длиной не менее 3 символов.',
	'autocreatewiki-name-too-long' => 'Слишком длинный адрес. Выберите адрес длиной не более 50 символов.',
	'autocreatewiki-similar-wikis' => 'Ниже приведены уже существующие вики по этой теме. Рекомендуется редактировать одну из них.',
	'autocreatewiki-invalid-username' => 'Недопустимое имя участника.',
	'autocreatewiki-busy-username' => 'Имя участника уже используется.',
	'autocreatewiki-blocked-username' => 'Вы не можете создать учётную запись.',
	'autocreatewiki-user-notloggedin' => 'Ваша учётная запись была создана, однако вы не вошли в систему!',
	'autocreatewiki-empty-language' => 'Необходимо выбрать язык для вики.',
	'autocreatewiki-empty-category' => 'Необходимо выбрать категорию.',
	'autocreatewiki-empty-wikiname' => 'Поле имени вики не может быть пустым.',
	'autocreatewiki-empty-username' => 'Поле имени участника не может быть пустым.',
	'autocreatewiki-empty-password' => 'Поле пароля не может быть пустым.',
	'autocreatewiki-empty-retype-password' => 'Поле повторного ввода пароля не может быть пустым.',
	'autocreatewiki-category-label' => 'Категория:',
	'autocreatewiki-category-other' => 'Другое',
	'autocreatewiki-set-username' => 'Сначала введите имя участника.',
	'autocreatewiki-invalid-category' => 'Неправильное значение категории.
Выберите подходящий вариант из выпадающего списка.',
	'autocreatewiki-invalid-language' => 'Неправильное значение языка.
Выберите подходящий вариант из выпадающего списка.',
	'autocreatewiki-invalid-retype-passwd' => 'Повторно введите тот же самый пароль.',
	'autocreatewiki-invalid-birthday' => 'Неверная дата рождения',
	'autocreatewiki-log-title' => 'Ваша вики создаётся',
	'autocreatewiki-step0' => 'Процесс начался …',
	'autocreatewiki-stepdefault' => 'Процесс запущен, пожалуйста, подождите …',
	'autocreatewiki-errordefault' => 'Процесс не был завершён …',
	'autocreatewiki-step1' => 'Создание директории изображений …',
	'autocreatewiki-step2' => 'Создание базы данных …',
	'autocreatewiki-step3' => 'Установка информации по умолчанию в базе данных …',
	'autocreatewiki-step4' => 'Копирование изображений по умолчанию и логотипа …',
	'autocreatewiki-step5' => 'Установка стандартных переменных в базе данных …',
	'autocreatewiki-step6' => 'Установка стандартных таблиц в базе данных …',
	'autocreatewiki-step7' => 'Настройка начального языка …',
	'autocreatewiki-step8' => 'Настройка групп участников и категорий …',
	'autocreatewiki-step9' => 'Настройка переменных для новой вики …',
	'autocreatewiki-step10' => 'Настройка страниц на центральной вики …',
	'autocreatewiki-step11' => 'Отправка электронного сообщения участнику …',
	'autocreatewiki-redirect' => 'Перенаправление на новую вики: $1 …',
	'autocreatewiki-congratulation' => 'Поздравляем!',
	'autocreatewiki-welcometalk-log' => 'Приветственное сообщение',
	'autocreatewiki-regex-error-comment' => 'использовано в вики «$1» (полный текст: $2)',
	'autocreatewiki-step2-error' => 'База данных существует!',
	'autocreatewiki-step3-error' => ' В базе данных не удаётся установить сведения по умолчанию!',
	'autocreatewiki-step6-error' => 'В базе данных не удаётся установить таблицы по умолчанию!',
	'autocreatewiki-step7-error' => 'Не удаётся скопировать начальную базу данных для языка!',
	'requestwiki-filter-language' => 'als,an,ang,ast,bar,de2,de-at,de-ch,de-formal,de-weigsbrag,dk,en-gb,eshelp,fihelp,frc,frhelp,ia,ie,ithelp,jahelp,kh,kohelp,kp,ksh,nb,nds,nds-nl,mu,mwl,nlhelp,pdc,pdt,pfl,pthelp,pt-brhelp,ruhelp,simple,tokipona,tp,zh-classical,zh-cn,zh-hans,zh-hant,zh-hk,zh-min-nan,zh-mo,zh-my,zh-sg,zh-tw,zh-yue',
	'autocreatewiki-protect-reason' => 'Часть официального интерфейса',
	'autocreatewiki-welcomesubject' => '«$1» успешно создана!',
	'autocreatewiki-welcomebody' => 'Здравствуйте, $2!

Ваша вики была создана! Взгляните: <$1>.

Готовы начать? Мы добавили несколько ссылок на вашу страницу обсуждения (<$5>), которые помогут вам начать работу и покажут множество полезных областей Викия. Если у вас есть какие-либо вопросы или вы немного растеряны, ответьте на это письмо или ознакомьтесь с нашей Справкой <http://ru.community.wikia.com/wiki/Справка:Содержание>.

Вы также можете посмотреть блог администраторов на Центральной Вики <http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins> или блог сотрудников Викия <http://community.wikia.com/wiki/Blog:Wikia_Staff_Blog>, чтобы узнать новости, найти полезные советы и информацию о новых функциях Викия.

Удачи в редактировании!

$3

Команда сообщества Викия

<http://community.wikia.com/wiki/User:$4>

___________________________________________
* Хотите получать от нас меньше писем? Вы можете отписаться от рассылки или изменить её параметры по ссылке: http://community.wikia.com/Special:Preferences.',
	'autocreatewiki-welcometalk-wall-title' => 'Добро пожаловать!',
	'autocreatewiki-welcometalk-wall' => 'Здравствуйте!
Мы рады, что вики «{{subst:SITENAME}}» стала частью сообщества Викия! 

Вам ещё многое предстоит сделать, поэтому позвольте дать несколько советов и полезных ссылок, которые помогут вам начать работу.
*Посетите страницу [[Special:WikiFeatures|Функции Вики]], чтобы узнать о том, какие функции можно активировать для вашей вики, включая чат, достижения и многие другие.
*[[Special:ThemeDesigner|Конструктор тем]] поможет сделать вашу вики индивидуальной – попробуйте добавить различные цвета и стили для фона и логотипа!
*Загляните на [[w:c:community|Вики Сообщества]] и будьте в курсе новостей благодаря [[w:c:community:Blog:Wikia_Staff_Blog|блогу сотрудников Викия]]. Вы можете задать вопросы на нашем [[w:c:community:Special:Forum|Форуме сообщества]], поучаствовать в [[w:c:community:Help:Webinars|вебинарах]] или [[w:c:community:Special:Chat|живом чате]] с другими фанатами Викия.
*Наконец, не забывайте о [[w:ru:Справка:Содержание|Справке]], на страницах которой вы узнаете обо всех особенностях использования Викия, включая [[w:ru:Справка:Новая_страница|добавление страниц]], [[w:ru:Справка:Продвижение Вики|продвижение]] и [[Help:User access levels|добавление новых администраторов для вашей вики]].
*Эти инструменты также можно найти в кабинете администратора, нажав на значок «Администратор» на панели инструментов внизу страницы.

Все перечисленные ресурсы позволят вам изучить основы создания вики и, самое главное, получать от нее удовольствие!',
	'autocreatewiki-welcometalk' => '== Добро пожаловать! ==
Приветствуем вас!
Мы рады, что вики «$4» стала частью сообщества Викия! Вам ещё многое предстоит сделать, поэтому позвольте дать несколько советов и полезных ссылок, которые помогут вам начать работу.

*Посетите страницу [[Special:WikiFeatures|Функции Вики]], чтобы узнать о том, какие функции можно активировать для вашей вики, включая чат, достижения и многие другие.
*Загляните на [[w:c:community|Вики Сообщества]] и будьте в курсе новостей благодаря [[w:c:community:Blog:Wikia_Staff_Blog|блогу сотрудников Викия]]. Вы можете задать вопросы на нашем [[w:c:community:Special:Forum|Форуме сообщества]], поучаствовать в [[w:c:community:Help:Webinars|вебинарах]] или [[w:c:community:Special:Chat|живом чате]] с другими фанатами Викия. 
*Наконец, не забывайте о [[w:ru:Справка:Содержание|Справке]], на страницах которой вы узнаете обо всех особенностях использования Викия.
Все перечисленные ресурсы позволят вам изучить основы создания вики и, самое главное, получать от нее удовольствие!

-- [[Участник:$2|$3]] <staff />',
	'autocreatewiki-language-top-list' => 'de,en,es,fr,it,ja,pl,pt-br,ru,zh',
);

/** Sanskrit (संस्कृतम्)
 * @author NehalDaveND
 */
$messages['sa'] = array(
	'cnw-next' => 'अग्रे',
	'cnw-back' => 'पृष्ठे',
	'cnw-or' => 'वा',
	'cnw-login' => 'प्रविश्यताम्',
	'cnw-signup' => 'सदस्यता प्राप्यताम्',
	'cnw-signup-prompt' => 'लेखा आवश्यकी ?',
	'cnw-login-prompt' => 'पूर्वस्मादेव लेखा अस्ति किं ?',
	'cnw-call-to-login' => 'अत्र प्रविश्यताम्',
	'cnw-auth-headline' => 'प्रविश्यताम्',
	'cnw-userauth-headline' => 'लेखा अस्ति किम् ?',
	'cnw-userauth-creative' => 'प्रविश्यताम्',
	'cnw-userauth-marketing-heading' => 'सदस्यता नास्ति किम् ?',
	'cnw-desc-change-lang' => 'परिवर्त्यताम्',
	'cnw-desc-lang' => 'भाषा',
);

/** Sicilian (sicilianu)
 * @author Gmelfi
 */
$messages['scn'] = array(
	'cnw-userauth-creative' => 'Trasi',
);

/** Scots (Scots)
 * @author John Reid
 */
$messages['sco'] = array(
	'createnewwiki-desc' => 'Wiki creaution worlock',
	'cnw-next' => 'Nex',
	'cnw-back' => 'Back',
	'cnw-or' => 'or',
	'cnw-title' => 'Creaut New Wiki',
	'cnw-name-wiki-headline' => 'Stairt ae Wikia',
	'cnw-name-wiki-creative' => 'Big a wabsteid, graw ae communitie, n embark oan yer ultimate fan exeriance.',
	'cnw-name-wiki-label' => 'Name yer wikia',
	'cnw-name-wiki-domain-label' => 'Gie yer wikia aen address',
	'cnw-name-wiki-submit-error' => 'Oops! Ye need tae fill in baith o the kists abuin tae keep gaun.',
	'cnw-login' => 'Log In',
	'cnw-signup' => 'Creaut Accoont',
	'cnw-signup-prompt' => 'Need aen accoont?',
	'cnw-call-to-signup' => 'Sign up here',
	'cnw-login-prompt' => 'Awreadie hae aen accoont?',
	'cnw-call-to-login' => 'Log in here',
	'cnw-auth-headline' => 'Log In',
	'cnw-auth-headline2' => 'Sign Up',
	'cnw-auth-creative' => 'Log in til yer accoont tae keep biggin yer wiki.',
	'cnw-auth-signup-creative' => "Ye'll need aen accoont tae keep biggin yer wiki.<br />It yinlie taks ae minute tae sign up!",
	'cnw-auth-facebook-signup' => 'Sign up wi Facebook',
	'cnw-auth-facebook-login' => 'Login wi Facebook',
	'cnw-userauth-headline' => 'Hae aen accoont?',
	'cnw-userauth-creative' => 'Log in',
	'cnw-userauth-marketing-heading' => 'Dinna hae aen accoont?',
	'cnw-userauth-marketing-body' => 'Ye need aen accoont tae creaut ae wiki oan Wikia. It yinlie taks ae minute tae sign up!',
	'cnw-userauth-signup-button' => 'Sign up',
	'cnw-desc-headline' => "Whit's yer wikia aneat?",
	'cnw-desc-creative' => 'Help fowk fynd yer wikia wi a superb descreeption.',
	'cnw-desc-placeholder' => 'Mak it guid! Yer tex will kith oan the main page o yer wikia.',
	'cnw-desc-tip1' => "Here's ae hint!",
	'cnw-desc-tip1-creative' => 'Uise this space tae tell fawk Why this wikia matters and why ye creautit it.',
	'cnw-desc-tip2' => 'PS',
	'cnw-desc-tip2-creative' => 'Encoorage ithers tae jyn yer communitie bi giein details aneatt yer wikia.',
	'cnw-desc-select-vertical' => 'Select ae Hub categerie',
	'cnw-desc-select-categories' => 'Check addeetional categeries',
	'cnw-desc-select-one' => 'Select yin',
	'cnw-desc-all-ages' => 'Is this wikia meant fer bairns?',
	'cnw-desc-tip-all-ages' => 'Is this aneat ae tapic that bairns ar interested in? In order tae heelp us complie wi US law we keep track o wikias aneat tapics that directlie appeal tae bairns 12 year auld n unner.',
	'cnw-desc-default-lang' => 'Yer wikia will be in $1',
	'cnw-desc-change-lang' => 'chynge',
	'cnw-desc-lang' => 'Leid',
	'cnw-desc-wiki-submit-error' => 'Please chuise ae categerie',
	'cnw-theme-headline' => 'Chuise ae theme',
	'cnw-theme-creative' => 'Mak it luik guid! Select ae theme tae see aen owerluik o it.',
	'cnw-theme-instruction' => 'Want tae customize it? Ye can design yer ain theme later bi gaein tae the Theme Designer bi wa o yerr Admin Controlboard.',
	'cnw-welcome-headline' => 'Weel Dun! Ye successfullie creautit $1',
	'cnw-welcome-instruction1' => 'Clap the button ablo tae stairt eikin pages tae yer wikia.',
	'cnw-welcome-help' => 'Continue yer fan experiance.
Fynd answers, advice, n mair oan <a href="http://community.wikia.com">Communitie Central</a>.',
	'cnw-error-general' => 'Oops, sommit went wrang oan oor side!  Please gie it anither gae, or [[Special:Contact|contact us]] fer heelp.',
	'cnw-error-general-heading' => 'Oor apologies',
	'cnw-badword-header' => 'Haud oan ae minute',
	'cnw-badword-msg' => 'Hallo, please dinna uise thir bad wairds or banned wairds in yer Wiki Descreeption: $1',
	'cnw-error-wiki-limit-header' => 'Wiki leemit reached',
	'cnw-error-wiki-limit' => "Hallo, ye'r leemitit tae {{PLURAL:$1|$1 wiki creaution|$1 wiki creautions}} ae day. Wait 24 hoors afore creautin anither wiki.",
	'cnw-error-blocked-header' => 'Accoont blockit',
	'cnw-error-blocked' => "Ye'v been blockit bi $1. The raison gien wis: $2. (Block ID fer referance: $3)",
	'cnw-error-anon-user-header' => 'Please log in',
	'cnw-error-anon-user' => 'Creautin wikis fer anons is disabled. Please [[Special:UserLogin|log in]] n gie it anither gae.',
	'cnw-error-torblock' => 'Creautin wikis bi wa o the Tor Network is no alloued.',
	'cnw-error-bot' => "We'v detectit that ye micht be ae bot. Gif we'v makit ae mistak, please contact us descreebin that ye'v been wranglie detectit aes ae bot, n we will heelp ye tae creaut yer wiki: [http://www.wikia.com/Special:Contact/general Contact Us]",
	'cnw-error-bot-header' => "Ye'v been detectit aes ae bot",
	'cnw-error-unconfirmed-email-header' => 'Yer e-mail haes no been confirmed',
	'cnw-error-unconfirmed-email' => 'Yer e-mail shid be confirmed tae creaut ae Wiki.',
);

/** Slovenian (slovenščina)
 * @author Eleassar
 */
$messages['sl'] = array(
	'cnw-signup' => 'Registracija',
);

/** Serbian (Cyrillic script) (српски (ћирилица)‎)
 * @author Aktron
 * @author Milicevic01
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'createnewwiki-desc' => 'Помоћник за стварање викија',
	'cnw-next' => 'Следеће',
	'cnw-back' => 'Назад',
	'cnw-or' => 'или',
	'cnw-title' => 'Стварање новог викија',
	'cnw-name-wiki-headline' => 'Направите вики',
	'cnw-name-wiki-creative' => 'Викија је најбоље место да направите веб-сајт и створите растућу заједницу која се темељи на ономе што волите.',
	'cnw-name-wiki-label' => 'Именујте вики:',
	'cnw-name-wiki-domain-label' => 'Унесите адресу викија:',
	'cnw-name-wiki-submit-error' => 'Упс! Потребно је да попуните оба поља да бисте наставили.',
	'cnw-login' => 'Пријави ме',
	'cnw-signup' => 'Отвори налог',
	'cnw-signup-prompt' => 'Немате налог?',
	'cnw-call-to-signup' => 'Отворите налог овде',
	'cnw-login-prompt' => 'Већ имате налог?',
	'cnw-call-to-login' => 'Пријавите се овде',
	'cnw-auth-headline' => 'Пријава',
	'cnw-auth-headline2' => 'Отварање налога',
	'cnw-auth-creative' => 'Пријавите се на свој налог да бисте наставили да градите вики.',
	'cnw-auth-signup-creative' => 'Требаће вам налог да бисте наставили да градите вики.<br />Отварање налога одузима непуну минуту!',
	'cnw-auth-facebook-signup' => 'Отвори налог преко Фејсбука',
	'cnw-auth-facebook-login' => 'Пријави ме преко Фејсбука',
	'cnw-userauth-creative' => 'Пријави ме',
	'cnw-userauth-marketing-heading' => 'Немате налог?',
	'cnw-userauth-signup-button' => 'Отворите налог',
	'cnw-desc-headline' => 'Која је тематика викија?',
	'cnw-desc-creative' => 'Опишите тему:',
	'cnw-desc-placeholder' => 'Текст који унесете овде ће бити приказан на главној страници викија.',
	'cnw-desc-tip1' => 'Савет',
	'cnw-desc-tip1-creative' => 'Овај простор користите да упознате људе с викијем у једној или две реченице.',
	'cnw-desc-tip2' => 'Псст',
	'cnw-desc-tip2-creative' => 'Наведите што више појединости о тематици.',
	'cnw-desc-select-one' => 'изаберите',
	'cnw-desc-default-lang' => 'Вики ће бити на $1',
	'cnw-desc-change-lang' => 'промени',
	'cnw-desc-lang' => 'Језик:',
	'cnw-desc-wiki-submit-error' => 'Изаберите категорију',
	'cnw-theme-headline' => 'Изаберите тему',
	'cnw-theme-creative' => 'Изаберите неку од тема испод. Преглед ће се појавити истог тренутка.',
	'cnw-theme-instruction' => 'Касније можете да израдите сопствену тему преко „Мојих алатки“.',
	'cnw-welcome-headline' => 'Честитамо! Вики $1 је направљен',
	'cnw-welcome-instruction1' => 'Кликните на дугме испод да почнете с додавањем страница на вики.',
	'cnw-welcome-help' => 'Одговори на питања, савети и друго се налазе на <a href="http://community.wikia.com">Центру заједнице</a>.',
	'cnw-error-general' => 'Дошло је до грешке при стварању викија. Покушајте касније.',
	'cnw-error-general-heading' => 'Грешка при стварању новог викија',
	'cnw-badword-header' => 'Упозорење',
	'cnw-badword-msg' => 'Здраво. Молимо вас да се уздржите од употребе непристојних и забрањених речи које се налазе у опису викија: $1',
	'cnw-error-wiki-limit-header' => 'Достигнуто је ограничење направљених викија',
	'cnw-error-wiki-limit' => 'Здраво. Можете да направите само по $1 вики дневно. Сачекајте 24 часа, па потом направите други.',
	'cnw-error-blocked-header' => 'Налог је блокиран',
	'cnw-error-blocked' => '{{GENDER:$1|Блокирао вас је корисник|Блокирала вас је корисница|Блокирао вас је корисник}} $1. Наведени разлог гласи: $2 (назнака блокаде: $3).',
	'cnw-error-torblock' => 'Није дозвољено стварање викија преко Тор мреже.',
	'cnw-error-bot' => 'Утврдили смо да сте можда бот. Ако је ово погрешно, обратите нам се, а ми ћемо вам помоћи да направите вики: [http://www.wikia.com/Special:Contact/general Пишите нам].',
	'cnw-error-bot-header' => 'Препознати сте као бот',
	'cnw-error-unconfirmed-email-header' => 'Ваша е-пошта није потврђен',
	'cnw-error-unconfirmed-email' => 'Ваша е-пошта мора бити потврђена да би направили Вики',
);

/** Swedish (svenska)
 * @author Geitost
 * @author Jopparn
 * @author Lokal Profil
 * @author McDutchie
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'createnewwiki-desc' => 'Guide för att skapa en wiki',
	'cnw-next' => 'Nästa',
	'cnw-back' => 'Tillbaka',
	'cnw-or' => 'eller',
	'cnw-title' => 'Skapa en ny Wiki',
	'cnw-name-wiki-headline' => 'Starta en wikia',
	'cnw-name-wiki-creative' => 'Bygg en webbplats, väx en gemenskap och ge dig av på din ultimata fanupplevelse.',
	'cnw-name-wiki-label' => 'Ge din wikia ett namn',
	'cnw-name-wiki-domain-label' => 'Ge din wikia en adress',
	'cnw-name-wiki-submit-error' => 'Hoppsan! Du måste fylla i båda rutorna ovan att hålla igång.',
	'cnw-login' => 'Logga in',
	'cnw-signup' => 'Skapa konto',
	'cnw-signup-prompt' => 'Behöver du ett konto?',
	'cnw-call-to-signup' => 'Registrera dig här',
	'cnw-login-prompt' => 'Har du redan ett konto?',
	'cnw-call-to-login' => 'Logga in här',
	'cnw-auth-headline' => 'Logga in',
	'cnw-auth-headline2' => 'Skapa ett konto',
	'cnw-auth-creative' => 'Logga in på ditt konto för att fortsätta bygga på din wiki.',
	'cnw-auth-signup-creative' => 'Du kommer att behöva ett konto för att fortsätta bygga på din wiki. <br /> Det tar bara en minut att registrera dig!',
	'cnw-auth-facebook-signup' => 'Registrera dig med Facebook',
	'cnw-auth-facebook-login' => 'Logga in med Facebook',
	'cnw-userauth-headline' => 'Har du ett konto?',
	'cnw-userauth-creative' => 'Logga in',
	'cnw-userauth-marketing-heading' => 'Har du inget konto?',
	'cnw-userauth-marketing-body' => 'Du behöver ett konto för att skapa en wiki på Wikia. Det tar bara en minut att registrera dig!',
	'cnw-userauth-signup-button' => 'Skapa ett konto',
	'cnw-desc-headline' => 'Vad handlar din wikia om?',
	'cnw-desc-creative' => 'Hjälp personer att hitta din wikia med en superb beskrivning.',
	'cnw-desc-placeholder' => 'Gör den bra! Din text kommer att visas på huvudsidan i din wikia.',
	'cnw-desc-tip1' => 'Här är ett tips!',
	'cnw-desc-tip1-creative' => 'Använd detta utrymme till att berätta för folk varför denna wikia spelar roll och anledningen till att du skapade den.',
	'cnw-desc-tip2' => 'PS',
	'cnw-desc-tip2-creative' => 'Uppmuntra andra att gå med i din gemenskap genom att ge info om din wikia.',
	'cnw-desc-select-vertical' => 'Välj en hubbkategori',
	'cnw-desc-select-categories' => 'Kolla ytterligare kategorier',
	'cnw-desc-select-one' => 'Välj en',
	'cnw-desc-all-ages' => 'Är denna wikia avsedd för barn?',
	'cnw-desc-tip-all-ages' => 'Handlar denna wikia om ett ämne som barn är intresserade i? För att vi ska kunna följa USA:s lagstiftning måste vi hålla reda på wikias med ämnen som riktar sig mot barn som är 12 och under.',
	'cnw-desc-default-lang' => 'Din wikia kommer att vara på $1',
	'cnw-desc-change-lang' => 'ändra',
	'cnw-desc-lang' => 'Språk',
	'cnw-desc-wiki-submit-error' => 'Välj en kategori',
	'cnw-theme-headline' => 'Designa din wiki',
	'cnw-theme-creative' => 'Gör den snygg! Välj ett tema för att se en förhandsvisning av det.',
	'cnw-theme-instruction' => 'Vill du anpassa den? Du kan utforma ditt egna tema senare med Temadesignern i instrumentpanelen för administratörer.',
	'cnw-welcome-headline' => 'Gratulerar! Du har skapat $1',
	'cnw-welcome-instruction1' => 'Klicka på knappen nedan för att börja lägga till sidor i din wikia.',
	'cnw-welcome-help' => 'Fortsätt din fanupplevelse. Hitta svar, råd och mer på <a href="http://community.wikia.com">Community Central</a>.',
	'cnw-error-general' => 'Hoppsan, någonting gick fel på vår sida! Var god försök igen eller [[Special:Contact|kontakta oss]] för hjälp.',
	'cnw-error-general-heading' => 'Vi beklagar',
	'cnw-badword-header' => 'Hallå där',
	'cnw-badword-msg' => 'Hej, var god avstå från att använda dessa grova eller fula ord i beskrivningen av din wiki: $1',
	'cnw-error-wiki-limit-header' => 'Wiki-gräns nådd',
	'cnw-error-wiki-limit' => 'Hej, du är begränsad till {{PLURAL:$1|$1 wikiskapelse|$1 skapelser av wikis}} per dag. Vänta 24 timmar innan du skapar en annan wiki.',
	'cnw-error-blocked-header' => 'Konto blockerat',
	'cnw-error-blocked' => 'Du har blivit blockerad av $1. Anledningen var:  $2. (Blockerings-ID för referens: $3)',
	'cnw-error-anon-user-header' => 'Var god logga in',
	'cnw-error-anon-user' => 'Anonyma användare kan inte skapa wikis. Var god [[Special:UserLogin|logga in]] och försök igen.',
	'cnw-error-torblock' => 'Skapa wikis via Tor-nätverket är inte tillåtet.',
	'cnw-error-bot' => 'Vi har upptäckt att du kan vara en bot. Om vi gjort ett misstag, kontakta oss och beskriv att du har felaktigt identifierats som en bot, och vi kommer att hjälpa dig med att skapa din wiki: [http://www.wikia.com/Special:Contact/general Kontakta oss]',
	'cnw-error-bot-header' => 'Du har identifierats som en bot',
	'cnw-error-unconfirmed-email-header' => 'Din e-postadress har inte bekräftats',
	'cnw-error-unconfirmed-email' => 'Din e-postadress bör bekräftas för att skapa en wiki.',
);

/** Tamil (தமிழ்)
 * @author ElangoRamanujam
 * @author Jayarathina
 */
$messages['ta'] = array(
	'cnw-next' => 'அடுத்து',
	'cnw-back' => 'பின்செல்க',
	'cnw-or' => 'அல்லது',
	'cnw-call-to-login' => 'இங்கு புகுபதிகை செய்க',
	'cnw-auth-headline' => 'புகுபதிகை',
	'cnw-desc-lang' => 'மொழி',
	'cnw-error-unconfirmed-email-header' => 'உங்கள் மின்னஞ்சல் உறுதி செய்யப்படவில்லை',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Ravichandra
 * @author Veeven
 */
$messages['te'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|వికీని సృష్టించే విజార్డు]]',
	'cnw-next' => 'తదుపరి',
	'cnw-back' => 'వెనుకకు',
	'cnw-or' => 'లేదా',
	'cnw-title' => 'కొత్త వికీని సృష్టించు',
	'cnw-name-wiki-headline' => 'ఓ వికీని మొదలుపెట్టండి',
	'cnw-name-wiki-creative' => 'ఓ వెబ్‍సైటును తయారుచేసుకుని, తద్వారా మీకు నచ్చిన అంశం చుట్టూ ఓ సముదాయాన్ని నిర్మించుకోడానికి వికియా చక్కటి స్థలం.',
	'cnw-name-wiki-label' => 'మీ వికీ పేరు',
	'cnw-name-wiki-domain-label' => 'వికీ చిరునామా',
	'cnw-name-wiki-submit-error' => 'అడెడె! పైనున్న పెట్టెలు రెండింటినీ కూడా పూర్తి చెయ్యాలండీ.',
	'cnw-login' => 'లాగిన్ చెయ్యి',
	'cnw-signup' => 'ఖాతా సృష్టించుకోండి',
	'cnw-signup-prompt' => 'ఖాతా కావాలా?',
	'cnw-call-to-signup' => 'ఇక్కడ నమోదు చేసుకోండి',
	'cnw-login-prompt' => 'ఇప్పటికే మీకు ఖాతా ఉందా?',
	'cnw-call-to-login' => 'ఇక్కడ ప్రవేశించండి',
	'cnw-auth-headline' => 'లాగినవండి',
	'cnw-auth-headline2' => 'నమోదు',
	'cnw-auth-creative' => 'మీ వికీని నిర్మించుకోడానికి మీ ఖాతాలోకి లాగినవండి.',
	'cnw-auth-signup-creative' => 'మీ వికీని నిర్మించుకోడానికి మీకు ఖాతా ఒకటి అవసరం.<br />ఖాతా తెరవడానికి ఒక్ఖ నిముషం చాలు!',
	'cnw-auth-facebook-signup' => 'ఫేస్‍బుక్ ద్వారా నమోదవండి',
	'cnw-auth-facebook-login' => 'ఫేస్‌బుక్‌ ద్వారా ప్రవేశించండి',
	'cnw-userauth-headline' => 'ఖాతా ఉందా?',
	'cnw-userauth-creative' => 'లాగినవండి',
	'cnw-userauth-marketing-heading' => 'ఖాతా లేదా?',
	'cnw-userauth-marketing-body' => 'మీ వికీని నిర్మించుకోడానికి మీకు ఖాతా ఒకటి అవసరం. ఖాతా తెరవడానికి ఒక్ఖ నిముషం చాలు!',
	'cnw-userauth-signup-button' => 'నమోదు చెయ్యి',
	'cnw-desc-headline' => 'మీ వికీ దేని గురించి?',
	'cnw-desc-creative' => 'మీ అంశాన్ని వివరించండి',
	'cnw-desc-placeholder' => 'ఇది మీ వికీ మొదటిపేజీలో కనిపిస్తుంది.',
	'cnw-desc-tip1' => 'చిట్కా',
	'cnw-desc-tip1-creative' => 'మీ వికీ గురించి ఒకటి రెండు వాక్యాల్లో చెప్పడానికి ఈ జాగాను వాడండి',
	'cnw-desc-tip2' => 'ఇస్.స్.స్.',
	'cnw-desc-tip2-creative' => 'మీ అంశం గురించిన కొన్ని విశిష్ట వివరాలను మీ సందర్శకులకు ఇవ్వండి',
	'cnw-desc-select-one' => 'ఒకటి ఎంచుకోండి',
	'cnw-desc-all-ages' => 'అన్ని వయసుల వారికీ',
	'cnw-desc-tip-all-ages' => 'ఈ వికీ పిల్లలకు ఆసక్తి కలిగించే అంశం గురించా? అమెరికా చట్టాలకు అనుగుణంగా 12 సంవత్సరాల లోపు పిల్లలను ఆకట్టుకునే అంశాలున్న వికీలను మేం గమనిస్తూంటాం.',
	'cnw-desc-default-lang' => 'మీ వికీ $1 లో ఉంటుంది',
	'cnw-desc-change-lang' => 'మార్చండి',
	'cnw-desc-lang' => 'భాష',
	'cnw-desc-wiki-submit-error' => 'ఓ వర్గాన్ని ఎంచుకోండి',
	'cnw-theme-headline' => 'ఓ థీమును ఎంచుకోండి',
	'cnw-theme-creative' => 'ఓ థీమును ఎంచుకోండి. ఏదైనా థీమును ఎంచుకోగానే మీరు దాని మునుజూపును చూడవచ్చు.',
	'cnw-theme-instruction' => 'తరువాత "నా పరికరాలు" కు వెళ్ళి మీ స్వంత థీమును తయారుచేసుకోవచ్చు కూడాను.',
	'cnw-welcome-headline' => 'అభినందనలు! $1 సృష్టించబడింది',
	'cnw-welcome-instruction1' => 'మీ వికీకి పేజీలను చేర్చేందుకు కింది బొత్తాన్ని నొక్కండి.',
	'cnw-welcome-help' => '<a href="http://community.wikia.com">సముదాయ కేంద్రం</a> లో జవాబులు, సలహాలు, ఇంకా ఇతర వివరాల్ను పొందండి.',
	'cnw-error-general' => 'అడెడె, మా వైపు ఏదో తప్పు జరిగింది! మళ్ళీ ప్రయత్నించండి, లేదా సహాయం కోసం [[Special:Contact|మమ్మల్ని సంప్రదించండి]].',
	'cnw-error-general-heading' => 'క్షమించండి',
	'cnw-badword-header' => 'ఎవరదీ..',
	'cnw-badword-msg' => 'మీ వికీ వివరణలో ఈ చెడ్డ మాటలను, నిషిద్ధ పదాలనూ వాడకండి: $1',
	'cnw-error-wiki-limit-header' => 'వికీ పరిమితికి చేరుకున్నారు',
	'cnw-error-wiki-limit' => 'రోజుకు {{PLURAL:$1|$1 వికీని|$1 వికీలను}} సృష్టించడం వరకే మీకు అనుమతి ఉంది. ఇంకో వికీని సృష్టించడానికి 24 ఆగండి.',
	'cnw-error-blocked-header' => 'ఖాతా నిషేధించబడింది',
	'cnw-error-blocked' => '$1 మిమ్మల్ని నిరోధించారు. కారణం ఏం చెప్పారంటే: $2. (ఆధారం కోసం నిరోధపు ఐడీ: $3)',
	'cnw-error-anon-user-header' => 'దయచేసి లాగినవండి',
	'cnw-error-anon-user' => 'అజ్ఞాతలు వికీని సృష్టించడాన్ని అచేతనం చేసాం. [[Special:UserLogin|లాగినై]] మళ్ళీ ప్రయత్నించండి.',
	'cnw-error-torblock' => 'Tor నెట్‍వర్కు ద్వారా వికీలను సృష్టించడానికి అనుమతి లేదు.',
	'cnw-error-bot' => 'మీరు బాట్ కావచ్చని మేం కనుక్కున్నాం. మేం పొరబడి ఉంటే, మిమ్మల్ని తప్పుగా భావించారని తెలియజేస్తూ మమ్మల్ని సంప్రదించండి. మేం మీ వికీని సృష్టించడంలో తోడ్పడతాం: [http://www.wikia.com/Special:Contact/general మమ్మల్ని సంప్రదించండి]',
	'cnw-error-bot-header' => 'మీరు బాట్ అని కనుక్కున్నాం',
	'cnw-error-unconfirmed-email-header' => 'మీ ఈమెయిలు ధృవీకరించబడలేదు',
	'cnw-error-unconfirmed-email' => 'ఒక వికీని సృష్టించడానికి మీ ఈమెయిలు ధృవీకరించబడాలి.',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 * @author Jojit fb
 */
$messages['tl'] = array(
	'createnewwiki-desc' => 'Madyikerong panlikha ng Wiki',
	'cnw-next' => 'Susunod',
	'cnw-back' => 'Bumalik',
	'cnw-or' => 'o',
	'cnw-title' => 'Lumikha ng Bagong Wiki',
	'cnw-name-wiki-headline' => 'Magsimula ng isang Wiki',
	'cnw-name-wiki-creative' => 'Ang Wikia ang pinakamahusay na pook upang makapagtatag ng isang websayt at makapagpalaki ng isang pamayanan sa paligid ng minamahal mong bagay.',
	'cnw-name-wiki-label' => 'Pangalanan ang wiki mo',
	'cnw-name-wiki-domain-label' => 'Bigyan ang wiki ng isang tirahan',
	'cnw-name-wiki-submit-error' => 'Naku! Dapat mong kapwa punuan ang mga kahong nasa itaas upang makapagpatuloy.',
	'cnw-login' => 'Lumagdang Papasok',
	'cnw-signup' => 'Lumikha ng Akawnt',
	'cnw-signup-prompt' => 'Kailangan mo ng isang akawnt?',
	'cnw-call-to-signup' => 'Magpatala rito',
	'cnw-login-prompt' => 'Mayroon ka nang isang akawnt?',
	'cnw-call-to-login' => 'Lumagda rito',
	'cnw-auth-headline' => 'Lumagdang Papasok',
	'cnw-auth-headline2' => 'Magpatala Na',
	'cnw-auth-creative' => 'Lumagda papasok sa akawnt mo upang makapagpatuloy sa pagtatayo ng wiki mo.',
	'cnw-auth-signup-creative' => 'Kakailanganin mo ang isang akawnt upang makapagpatuloy sa pagbubuo ng wiki mo.<br />Isang minuto lang ang kailangan sa pagpapatala!',
	'cnw-auth-facebook-signup' => 'Magpatalang may Facebook',
	'cnw-auth-facebook-login' => 'Lumagdang may Facebook',
	'cnw-userauth-headline' => 'Mayroon nang akawnt?',
	'cnw-userauth-creative' => 'Mag-login',
	'cnw-userauth-marketing-heading' => 'Wala pang akawnt?',
	'cnw-userauth-marketing-body' => 'Kailangan mo ang isang akawnt upang makalikha ng isang wiki sa Wikia. Gugugol lamang ito ng isang minuto upang makapagpatala!',
	'cnw-userauth-signup-button' => 'Magpatala',
	'cnw-desc-headline' => 'Tungkol ba saan ang wiki mo?',
	'cnw-desc-creative' => 'Ilarawan ang paksa mo',
	'cnw-desc-placeholder' => 'Lilitaw ito sa pangunahing pahina ng wiki mo.',
	'cnw-desc-tip1' => 'Pahiwatig',
	'cnw-desc-tip1-creative' => 'Gamitin ang puwang na ito upang sabihin sa mga tao ang tungkol sa wiki mo sa pamamagitan ng isa o dalawang mga pangungusap',
	'cnw-desc-tip2' => 'Hoy',
	'cnw-desc-tip2-creative' => 'Bigyan ang mga panauhin mo ng ilang partikular na mga detalye ukol sa paksa mo',
	'cnw-desc-select-one' => 'Pumili ng isa',
	'cnw-desc-default-lang' => 'Ang wiki mo ay magiging nasa $1',
	'cnw-desc-change-lang' => 'baguhin',
	'cnw-desc-lang' => 'Wika',
	'cnw-desc-wiki-submit-error' => 'Mangyaring pumili ng isang kategorya',
	'cnw-theme-headline' => 'Pumili ng isang tema',
	'cnw-theme-creative' => 'Pumili ng isang temang nasa ibaba, magagawa mong makakita ng isang paunang pagtanaw ng bawat tema habang pinipili mo ito.',
	'cnw-theme-instruction' => 'Makakapagdisenyo ka rin ng sarili mong tema paglaon sa pamamagitan ng pagpunta sa "Mga Kasangkapan Ko".',
	'cnw-welcome-headline' => 'Maligayang bati! Nalikha na ang $1',
	'cnw-welcome-instruction1' => 'Pindutin ang pindutang nasa ibaba upang makapagsimulang magdagdag ng mga pahina sa wiki mo.',
	'cnw-welcome-help' => 'Maghanap ng mga sagot, mga payo, at marami pa sa <a href="http://community.wikia.com">Lunduyan ng Pamayanan</a>.',
	'cnw-error-general' => 'May masamang bagay na nangyari habang nililikha ang wiki mo. Paki subukan ulit mamaya.',
	'cnw-error-general-heading' => 'Kamalian sa Paglikha ng Bagong Wiki',
	'cnw-badword-header' => 'Aba riyan',
	'cnw-badword-msg' => 'Hoy, paki tumigil mula sa paggamit ng ganitong masasamang mga salita o ipinagbabawal na mga salita sa loob ng iyong Paglalarawan ng Wiki: $1',
	'cnw-error-wiki-limit-header' => 'Naabot na ang hangganan ng wiki',
	'cnw-error-wiki-limit' => 'Kumusta, nakahangga ka lamang sa {{PLURAL:$1|$1 paglikha ng wiki|$1 paglikha ng mga wiki}} bawat araw. Maghintay ng 24 mga oras bago lumikha ng ibang wiki.',
	'cnw-error-blocked-header' => 'Hinarang ang akawnt',
	'cnw-error-blocked' => 'Hinadlangan ka ni $1. Ang ibinigay na dahilan ay: $2. (ID ng pagharang para sa pagsangguni: $3)',
	'cnw-error-torblock' => 'Hindi pinapayagan ang paglikha ng mga wiki sa pamamagitan ng Network ng Tor.',
	'cnw-error-bot' => 'Napansin namin na maaaring ikaw ay isang bot.  Kung nagawa kami ng kamalian, paki makipag-ugnayan sa amin na naglalarawan na ikaw napasinungalingan mapansin bilang isang bot, at tutulungan ka namin sa paglikha ng wiki mo: [http://www.wikia.com/Special:Contact/general Makipag-ugnayan sa Amin]',
	'cnw-error-bot-header' => 'Natiktikan na isa ka palang bot',
);

/** Talysh (толышә зывон)
 * @author Гусейн
 */
$messages['tly'] = array(
	'cnw-next' => 'Бәнав',
	'cnw-or' => 'јаанки',
	'cnw-login' => 'Ыштәни едаштеј',
	'cnw-call-to-signup' => 'Ғејдијот ијо',
	'cnw-login-prompt' => 'Шымә ыштәни ғејд кардәјоне?',
	'cnw-auth-headline' => 'Ыштәни едаштеј',
	'cnw-auth-headline2' => 'Ғејдијот',
	'cnw-desc-change-lang' => 'дәгиш кардеј',
	'cnw-desc-lang' => 'Зывон',
	'cnw-theme-headline' => 'Мывзу сәчын кардеј',
);

/** Turkish (Türkçe)
 * @author Emperyan
 * @author Erdemaslancan
 * @author Incelemeelemani
 * @author Joseph
 * @author Suelnur
 */
$messages['tr'] = array(
	'createnewwiki-desc' => 'Wiki oluşturma sihirbazı',
	'cnw-next' => 'Sonraki',
	'cnw-back' => 'Geri',
	'cnw-or' => 'ya da',
	'cnw-title' => 'Yeni bir wiki oluştur',
	'cnw-name-wiki-headline' => 'Bir Wiki Başlat',
	'cnw-name-wiki-creative' => 'Wikia bir web sitesi oluşturmak için en iyi yerdir ve sevgi çerçevesinde topluluk büyür.',
	'cnw-name-wiki-label' => 'Wikinizin adı',
	'cnw-name-wiki-domain-label' => 'Lütfen Wiki adresini ekleyin',
	'cnw-name-wiki-submit-error' => 'Oops! Devam et için yukarıdaki kutuların her ikisini de doldurmanız gerekir.',
	'cnw-login' => 'Oturum aç',
	'cnw-signup' => 'Hesap Oluştur',
	'cnw-signup-prompt' => 'Bir hesap gerekiyor?',
	'cnw-call-to-signup' => 'Buradan kaydolun',
	'cnw-login-prompt' => 'Zaten bir hesabınız var mı?',
	'cnw-call-to-login' => 'Giriş yapın',
	'cnw-auth-headline' => 'Oturum aç',
	'cnw-auth-headline2' => 'Kaydol',
	'cnw-auth-creative' => 'Wiki oluşturmaya devam etmek için oturum açın.',
	'cnw-auth-signup-creative' => 'Wiki oluşturmaya devam etmek için bir hesap oluşturmaya ihtiyacınız var.<br />Yalnızca bir dakika sürer, kaydolun!',
	'cnw-auth-facebook-signup' => 'Facebook ile giriş yap',
	'cnw-auth-facebook-login' => 'Facebook ile giriş',
	'cnw-userauth-headline' => 'Hesabınız var mı?',
	'cnw-userauth-creative' => 'Giriş yap',
	'cnw-userauth-marketing-heading' => 'Hesabın yok mu?',
	'cnw-userauth-marketing-body' => "Wikia'da bir wiki oluşturmak için üye olmanız gerekmektedir. Kayıt sadece bir dakika sürer!",
	'cnw-userauth-signup-button' => 'Kaydol',
	'cnw-desc-headline' => 'Wikiniz ne hakkında?',
	'cnw-desc-creative' => 'Konuyu açıklayın',
	'cnw-desc-placeholder' => 'Bu wikinizin ana sayfanızda görünecektir.',
	'cnw-desc-tip1' => 'İpucu',
	'cnw-desc-tip1-creative' => 'Wikinizin konusunu insanlara bir iki cümle ile anlatmak için bu alanı kullanın',
	'cnw-desc-tip2' => 'Hişt',
	'cnw-desc-tip2-creative' => 'Ziyaretçilerinize konu hakkında bazı özel bilgiler verin',
	'cnw-desc-select-one' => 'Birini seç',
	'cnw-desc-all-ages' => 'Tüm süreler',
	'cnw-desc-tip-all-ages' => 'Bu wiki çocukları ilgilendiren bir konu hakkında mı? ABD yasaları uyarınca ve yardımcı olmak için 12 yaş ve altı çocuklara hitap eden konuları takip ediyoruz.',
	'cnw-desc-default-lang' => 'Sizin wikiniz $1 olacak',
	'cnw-desc-change-lang' => 'değiştir',
	'cnw-desc-lang' => 'Dil',
	'cnw-desc-wiki-submit-error' => 'Lütfen bir kategori seçin',
	'cnw-theme-headline' => 'Bir tema seçin',
	'cnw-theme-creative' => 'Aşağıdan bir tema seçin. Seçtiğiniz her temanın ön izlemesini görebilirsiniz.',
	'cnw-theme-instruction' => 'Kendi temanızı "Araçlarım" bölümüne giderek, daha sonra da tasarlayabilirsiniz.',
	'cnw-welcome-headline' => 'Tebrikler!  $1  oluşturuldu',
	'cnw-welcome-instruction1' => 'Wikinize sayfalar eklemeye başlamak için aşağıdaki düğmeye tıklayın.',
	'cnw-welcome-help' => 'Daha fazla cevap ve öneri bulabilmek için <a href="http://community.wikia.com">Topluluk Merkezini</a> ziyaret edin.',
	'cnw-error-general' => 'Üzgünüz, ters giden bir şeyler var!  Lütfen tekrar deneyin veya yardım için  bizimle [[Special:Contact|iletişim]] kurun.',
	'cnw-error-general-heading' => 'Özür dileriz',
	'cnw-badword-header' => 'Dur bakalım',
	'cnw-badword-msg' => 'Merhaba, lütfen Wiki tanımınızda $1 gibi kötü kelimeler veya yasaklı kelimeler kullanmaktan kaçının.',
	'cnw-error-wiki-limit-header' => 'Wiki sınırına ulaşıldı',
	'cnw-error-wiki-limit' => 'Merhaba, günlük {{PLURAL:$1|$1 wiki oluşturma|$1 wiki oluşturma}} limiti bulunmaktadır. Başka bir wiki oluşturmadan önce 24 saat bekleyin.',
	'cnw-error-blocked-header' => 'Hesabınız engellendi',
	'cnw-error-blocked' => '$1 tarafından $2 gerekçesiyle engellendiniz. (Başvuru için referans numarası: $3)',
	'cnw-error-anon-user-header' => 'Lütfen oturum açın',
	'cnw-error-anon-user' => 'Wikilerde duyuru oluşturma devre dışı bırakılı. Lütfen [[Special:UserLogin|giriş yapın]] ve tekrar deneyin.',
	'cnw-error-torblock' => 'Tor ağı üzerinden wikiler oluşturmaya izin verilmemektedir.',
	'cnw-error-bot' => 'Sizin bir bot olabileceğinizi tespit ettik. Bir hata yaptıysanız, sizin yanlışlıkla bir bot olduğunuzu tespit etmiş olabiliriz. Wiki oluştururken size yardımcı olabilmemiz için bizimle [http://www.wikia.com/Special:Contact/general İletişime] geçin',
	'cnw-error-bot-header' => 'Sizin bir bot olduğunuz tespit edilmiştir',
);

/** Tatar (Cyrillic script) (татарча)
 * @author Ajdar
 */
$messages['tt-cyrl'] = array(
	'createnewwiki-desc' => 'Вики ясау остаханәсе',
	'cnw-next' => 'Киләсе',
	'cnw-back' => 'Артка',
	'cnw-or' => 'яки',
	'cnw-title' => 'Яңа вики ясау',
	'cnw-name-wiki-headline' => 'Вики башлау',
	'cnw-name-wiki-creative' => 'Викия - сез яраткан нәрсәләр турында веб-сайт төзү өчен иң кулай урын.',
	'cnw-name-wiki-label' => 'Викиның исеме',
	'cnw-name-wiki-domain-label' => 'Вики адресыгызны языгыз',
	'cnw-name-wiki-submit-error' => 'Дәвам итәр өчен, сезгә өстәге ике кырны тутырырга кирәк.',
	'cnw-login' => 'Керү',
	'cnw-signup' => 'Хисап язмасы төзү',
	'cnw-signup-prompt' => 'Аккаунт кирәкме?',
	'cnw-call-to-signup' => 'Теркәлү монда',
	'cnw-login-prompt' => 'Сез инде теркәлдегезме?',
	'cnw-call-to-login' => 'Системага керү',
	'cnw-auth-headline' => 'Керү',
	'cnw-auth-headline2' => 'Теркәлү',
	'cnw-auth-creative' => 'Вики төзүне дәвам итү өчен,  хисап язмасына керү',
	'cnw-auth-signup-creative' => 'Вики ясауны дәвам итү өчен, сезгә аккаунт кирәк. <br /> Теркәлү нибары бер минутлык кына!',
	'cnw-auth-facebook-signup' => 'Facebook аша теркәлү',
	'cnw-auth-facebook-login' => 'Facebook аша керү',
	'cnw-userauth-headline' => 'Аккаунт бармы?',
	'cnw-userauth-creative' => 'Керү',
	'cnw-userauth-marketing-heading' => 'Аккаунт юкмы?',
	'cnw-userauth-marketing-body' => 'Вики төзү өчен сезгә теркәлергә кирәк. Теркәлү бер генә минут!',
	'cnw-userauth-signup-button' => 'Теркәлү',
	'cnw-desc-headline' => 'Сезнең вики нәрсә турында булачак?',
	'cnw-desc-creative' => 'Темагызны тасвирлагыз',
	'cnw-desc-placeholder' => 'Бу сезнең викиның баш битендә булачак.',
	'cnw-desc-tip1' => 'Ярдәм',
	'cnw-desc-tip1-creative' => 'Бу урынны кешеләргә сезнең вики турында бер-ике җөмлә белән сөйләр өчен кулланыгыз.',
	'cnw-desc-tip2' => 'Псс',
	'cnw-desc-tip2-creative' => 'Вики кунакларына сезнең теманың кайбер үзенчәлекләрен сөйләп китегез.',
	'cnw-desc-select-one' => 'Берсен сайлагыз',
	'cnw-desc-default-lang' => 'Сезнең вики $1 бүлегендә булачак',
	'cnw-desc-change-lang' => 'үзгәртү',
	'cnw-desc-lang' => 'Тел',
	'cnw-desc-wiki-submit-error' => 'Зинһар өчен, төркем сайлагыз',
	'cnw-theme-headline' => 'Тема сайлау',
	'cnw-theme-creative' => 'Теманы астарак сайлагыз; сез төгәл карар кабул иткәнче, бөтен теманы да карап чыга аласыз.',
	'cnw-theme-instruction' => 'Соңрак, "Минем коралларым"а кереп, сез үзегезнең темаларыгызны ясый аласыз.',
	'cnw-welcome-headline' => 'Котлыйбыз! $1 ачылды!',
	'cnw-welcome-instruction1' => 'Викигә мәкаләләр өстәр өчен, астагы төймәгә басыгыз',
	'cnw-welcome-help' => 'Җаваплар, киңәшләр һәм башка бик күп кирәк нәрсәләрне <a href="http://community.wikia.com">Үзәк викидә</a> табарсыз.',
	'cnw-error-general' => 'Викине ясаганда ниндидер хата киткән. Зинһар өчен, соңрак кабатлап карагыз.',
	'cnw-error-general-heading' => 'Гафу үтенәбез',
	'cnw-badword-header' => 'Әй, кем анда!',
	'cnw-badword-msg' => 'Зинһар өчен, викине тасвирлаганда начар яки тыелган сүзләр кулланудан сакланыгыз: $1',
	'cnw-error-wiki-limit-header' => 'Вики ясау лимиты',
	'cnw-error-wiki-limit' => 'Сәлам, сез бер көнгә {{PLURAL:$1|$1 вики}} ясауның чигенә килеп җиттегез. Яңа вики ясаганчы, 24 сәгать сабыр итеп торыгыз...',
	'cnw-error-blocked-header' => 'Хисап язмасы тыелды',
	'cnw-error-blocked' => 'Сезне $1 тыйды. Сәбәбе: $2. (Мәгълүмат өчен: $3)',
	'cnw-error-torblock' => 'Tor челтәре аша вики ясау рөхсәт ителми.',
	'cnw-error-bot' => 'Без сезне бот дип уйлыйбыз. Әгәр ялгышабыз икән, зинһар өчен, безнең белән элемтәгә керегез һәм бот булмавыгызны дәлилләгез, аннары без сезгә яңа вики ясарга ярдәм итәрбез: [http://www.wikia.com/Special:Contact/general безнең белән элемтә]',
	'cnw-error-bot-header' => 'Сез бот буларак танылдыгыз',
);

/** Ukrainian (українська)
 * @author A1
 * @author Andriykopanytsia
 * @author Ua2004
 */
$messages['uk'] = array(
	'createnewwiki-desc' => 'Майстер створення вікі',
	'cnw-next' => 'Далі',
	'cnw-back' => 'Назад',
	'cnw-or' => 'або',
	'cnw-title' => 'Створити нову Вікі',
	'cnw-name-wiki-headline' => 'Створити вікі',
	'cnw-name-wiki-creative' => 'Вікія - це найкраще місце для створення веб-сайту про те, що ви любите, і зростання спільноти навколо цього.',
	'cnw-name-wiki-label' => 'Назва вашого вікі-сайту',
	'cnw-name-wiki-domain-label' => 'Дайте адресу вашому вікі-сайту',
	'cnw-name-wiki-submit-error' => 'Необхідно заповнити обидва поля',
	'cnw-login' => 'Вхід до системи',
	'cnw-signup' => 'Реєстрація',
	'cnw-signup-prompt' => 'Потрібен обліковий запис?',
	'cnw-call-to-signup' => 'Реєстрація тут',
	'cnw-login-prompt' => 'Ви вже зареєстровані?',
	'cnw-call-to-login' => 'Вхід у систему',
	'cnw-auth-headline' => 'Увійти',
	'cnw-auth-headline2' => 'Зареєструватися',
	'cnw-auth-creative' => 'Увійти для продовження створення вашого вікі-сайту',
	'cnw-auth-signup-creative' => 'Вам потрібен обліковий запис, щоб продовжити створення вікі. <br /> Реєстрація не відніме багато часу!',
	'cnw-auth-facebook-signup' => 'Зареєструватися через Facebook',
	'cnw-auth-facebook-login' => 'Увійти з Facebook',
	'cnw-userauth-headline' => 'Уже зареєстровані?',
	'cnw-userauth-creative' => 'Увійти',
	'cnw-userauth-marketing-heading' => 'Немає облікового запису?',
	'cnw-userauth-marketing-body' => 'Вам потрібний обліковий запис для створення вікі на Wikia. Це займе всього хвилину, щоб зареєструватися!',
	'cnw-userauth-signup-button' => 'Зареєструватися',
	'cnw-desc-headline' => 'Про що буде ваша вікія?',
	'cnw-desc-creative' => 'Ваш опис допомагатиме людям віднайти вашу вікію',
	'cnw-desc-placeholder' => 'Це відображатиметься на головній сторінці вікі.',
	'cnw-desc-tip1' => 'Підказка',
	'cnw-desc-tip1-creative' => 'Використовуйте це місце, щоб коротко розповісти людям про вашу вікію за одне або два речення.',
	'cnw-desc-tip2' => 'Писати',
	'cnw-desc-tip2-creative' => 'Про що ви зібралися писати?',
	'cnw-desc-select-vertical' => 'Виберіть категорію концентратора',
	'cnw-desc-select-categories' => 'Виберіть додаткові категорії',
	'cnw-desc-select-one' => 'Оберіть одну',
	'cnw-desc-all-ages' => 'Цей вікія призначена для дітей?',
	'cnw-desc-tip-all-ages' => "Цей текст на тему, якою цікавляться діти? Для того, щоб допомогти нам дотримуватися законодавства США, ми стежимо за вікії на теми, безпосередньо пов'язані з дітьми віком 12 років і молодшими.",
	'cnw-desc-default-lang' => 'Ваша вікі буде в розділі $1',
	'cnw-desc-change-lang' => 'змінити',
	'cnw-desc-lang' => 'Мова',
	'cnw-desc-wiki-submit-error' => 'Просимо вибрати категорію',
	'cnw-theme-headline' => 'Обрати тему',
	'cnw-theme-creative' => 'Виберіть тему нижче, ви можете переглянути кожну тему до того, як зробити остаточний вибір',
	'cnw-theme-instruction' => 'Ви також можете створювати свої власні теми пізніше, перейшовши в "Мої інструменти".',
	'cnw-welcome-headline' => 'Вітаємо! $1 створена',
	'cnw-welcome-instruction1' => 'Натисніть на кнопку нижче, щоб почати додавати сторінки на вікі.',
	'cnw-welcome-help' => 'Знайті відповіді, поради та багато іншого на <a href="http://community.wikia.com">Центральній вікі</a>.',
	'cnw-error-general' => "Ой, щось пішло не так на нашому боці! Будь ласка, спробуйте ще раз або [[Special:Contact|зв'яжіться з нами]].",
	'cnw-error-general-heading' => 'Просимо вибачення',
	'cnw-badword-header' => 'Шо за фігня?',
	'cnw-badword-msg' => 'Будь ласка, не вживайте русизмів на $1 !',
	'cnw-error-wiki-limit-header' => 'Ліміт створення вікі',
	'cnw-error-wiki-limit' => 'Привіт, ви обмежені створенням {{PLURAL:$1|$1 вікі}} за день. Почекайте 24 години перед створенням іншого вікі..',
	'cnw-error-blocked-header' => 'Облікований запис заблоковано',
	'cnw-error-blocked' => 'Ви заблоковані $1. Причиною було: $2. (Для довідки: $3)',
	'cnw-error-anon-user-header' => 'Будь ласка, увійдіть',
	'cnw-error-anon-user' => 'Створення вікі для анонімів вимкнено. Будь ласка, [[Special:UserLogin|увійдіть]] і повторіть спробу.',
	'cnw-error-torblock' => 'Не допускається створення вікі через мережу Tor.',
	'cnw-error-bot' => 'Нам здається, що ви - бот.  Якщо це не так, звертайтеся [http://www.wikia.com/Special:Contact/general сюди].',
	'cnw-error-bot-header' => 'Ми вважаємо, що ви бот',
	'cnw-error-unconfirmed-email-header' => 'Вашу адресу електронної пошти не підтверджено',
	'cnw-error-unconfirmed-email' => 'Ваша адреса електронної пошти повинні бути підтверджена для створення вікі.',
);

/** Veps (vepsän kel’)
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'cnw-next' => "Jäl'ghine",
	'cnw-desc-select-one' => "Valikat üks'",
	'cnw-desc-change-lang' => 'toižetada',
	'cnw-desc-lang' => 'Kel’',
	'cnw-badword-header' => 'Hei sigä',
);

/** Vietnamese (Tiếng Việt)
 * @author Baonguyen21022003
 * @author KhangND
 * @author Rémy Lee
 * @author Xiao Qiao
 * @author XiaoQiaoGrace
 */
$messages['vi'] = array(
	'createnewwiki-desc' => 'Thuật sĩ tạo lập wiki',
	'cnw-next' => 'Tiếp theo',
	'cnw-back' => 'Trở lại',
	'cnw-or' => 'hoặc',
	'cnw-title' => 'Tạo Wiki mới',
	'cnw-name-wiki-headline' => 'Tạo lập một Wikia',
	'cnw-name-wiki-creative' => 'Xây dựng một trang web, phát triển một cộng đồng và hòa mình vào trải nghiệm của fan.',
	'cnw-name-wiki-label' => 'Đặt tên wikia của bạn',
	'cnw-name-wiki-domain-label' => 'Tặng cho wikia của bạn một địa chỉ',
	'cnw-name-wiki-submit-error' => 'Rất tiếc! Bạn cần phải điền vào cả hai chỗ trên ở trên để tiếp tục.',
	'cnw-login' => 'Đăng nhập',
	'cnw-signup' => 'Tạo tài khoản',
	'cnw-signup-prompt' => 'Cần một tài khoản?',
	'cnw-call-to-signup' => 'Đăng ký ở đây',
	'cnw-login-prompt' => 'Bạn đã có tài khoản?',
	'cnw-call-to-login' => 'Đăng nhập tại đây',
	'cnw-auth-headline' => 'Đăng nhập',
	'cnw-auth-headline2' => 'Đăng ký',
	'cnw-auth-creative' => 'Đăng nhập vào tài khoản của bạn để tiếp tục xây dựng wiki.',
	'cnw-auth-signup-creative' => 'Bạn sẽ cần một tài khoản để tiếp tục xây dựng wiki của mình.<br />Chỉ mất một phút để đăng ký!',
	'cnw-auth-facebook-signup' => 'Đăng ký cùng Facebook',
	'cnw-auth-facebook-login' => 'Đăng nhập cùng Facebook',
	'cnw-userauth-headline' => 'Đã có tài khoản?',
	'cnw-userauth-creative' => 'Đăng nhập',
	'cnw-userauth-marketing-heading' => 'Chưa có tài khoản?',
	'cnw-userauth-marketing-body' => 'Bạn cần một tài khoản để tạo lập một wiki trên Wikia. Chỉ mất một phút để đăng ký!',
	'cnw-userauth-signup-button' => 'Đăng ký',
	'cnw-desc-headline' => 'Wikia của bạn đề cập vấn đề gì?',
	'cnw-desc-creative' => 'Giúp những người khác tìm được wikia của bạn bằng một mô tả tuyệt vời.',
	'cnw-desc-placeholder' => 'Hãy đặt cho hay! Văn bản sẽ xuất hiện trên trang chính wikia của bạn.',
	'cnw-desc-tip1' => 'Đây là mẹo vặt!',
	'cnw-desc-tip1-creative' => 'Sử dụng không gian này để nói với mọi người về wikia này và lý do bạn tạo.',
	'cnw-desc-tip2' => 'PS',
	'cnw-desc-tip2-creative' => 'Khuyến khích mọi người tham gia cộng đồng của bạn bằng cách cung cấp thông tin về wikia.',
	'cnw-desc-select-vertical' => 'Chọn một thể loại trung tâm',
	'cnw-desc-select-categories' => 'Chọn các thể loại bổ sung',
	'cnw-desc-select-one' => 'Chọn một',
	'cnw-desc-all-ages' => 'Có phải wikia này dành cho trẻ em?',
	'cnw-desc-tip-all-ages' => 'Đây có phải là nơi giới thiệu một chủ đề mà trẻ em có thể quan tâm? Để giúp chúng tôi tuân thủ luật pháp Hoa Kỳ, chúng tôi theo dõi các wikia về những chủ đề dành cho cho trẻ em từ 12 tuổi trở xuống.',
	'cnw-desc-default-lang' => 'Wikia của bạn sẽ đặt tại $1',
	'cnw-desc-change-lang' => 'thay đổi',
	'cnw-desc-lang' => 'Ngôn ngữ',
	'cnw-desc-wiki-submit-error' => 'Hãy chọn một thể loại',
	'cnw-theme-headline' => 'Chọn một chủ đề',
	'cnw-theme-creative' => 'Hãy trau chuốt thật đẹp! Chọn một chủ đề để xem trước.',
	'cnw-theme-instruction' => 'Muốn thay đổi nó? Bạn có thể thiết kế chủ đề của riêng bạn sau bằng cách đi đến trang Thiết kế chủ đề thông qua Bảng điều khiển Bảo quản viên.',
	'cnw-welcome-headline' => 'Chúc mừng! Bạn đã tạo thành công $1',
	'cnw-welcome-instruction1' => 'Nhấp vào nút dưới đây để bắt đầu thêm các trang cho wikia của bạn.',
	'cnw-welcome-help' => 'Tiếp tục trải nghiệm của bạn. Tìm câu trả lời, lời khuyên và nhiều hơn trên <a href="http://congdong.wikia.com">Cộng đồng Wikia tiếng Việt</a>.',
	'cnw-error-general' => 'Rất tiếc, đã có lỗi nào đó xảy ra! Xin vui lòng thử lại, hoặc [[Special:Contact|liên hệ chúng tôi]] để được hỗ trợ.',
	'cnw-error-general-heading' => 'Xin thứ lỗi chúng tôi',
	'cnw-badword-header' => 'Whoa có rồi',
	'cnw-badword-msg' => 'Chào bạn, xin vui lòng tránh sử dụng những từ ngữ phản cảm hoặc từ ngữ bị cấm trong các mô tả wiki: $1',
	'cnw-error-wiki-limit-header' => 'Wiki chạm đến giới hạn',
	'cnw-error-wiki-limit' => 'Xin chào, bạn bị giới hạn {{PLURAL:$1|tạo lập $1 wiki|tạo lập $1 wiki}} mỗi ngày. Hãy chờ 24 giờ trước khi tạo lập một wiki khác.',
	'cnw-error-blocked-header' => 'Tài khoản bị chặn',
	'cnw-error-blocked' => 'Bạn đã bị cấm bởi $1. Lý do đưa ra là: $2. (ID cấm để tham khảo: $3)',
	'cnw-error-anon-user-header' => 'Xin vui lòng đăng nhập',
	'cnw-error-anon-user' => 'Tạo wiki cho người dùng vô danh bị vô hiệu hóa. Xin vui lòng [[Special:UserLogin|đăng nhập]] và thử lại.',
	'cnw-error-torblock' => 'Tạo wiki qua mạng Tor không được cho phép.',
	'cnw-error-bot' => 'Chúng tôi đã phát hiện rằng bạn có thể là bot. Nếu chúng tôi đã nhầm, xin liên hệ với chúng tôi mô tả rằng bạn đã được phát hiện nhầm là bot và chúng tôi sẽ hỗ trợ bạn trong việc tạo lập wiki: [http://www.wikia.com/Special:Contact/general Liên hệ với chúng tôi]',
	'cnw-error-bot-header' => 'Bạn đã được phát hiện là bot',
	'cnw-error-unconfirmed-email-header' => 'Thư điện tử của bạn chưa được xác nhận',
	'cnw-error-unconfirmed-email' => 'Thư điện tử của bạn cần được xác nhận để tạo lập một Wiki.',
);

/** Chinese (中文)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 * @author Shirayuki
 */
$messages['zh'] = array(
	'createnewwiki-desc' => 'Wiki creation wizard',
	'cnw-next' => 'Next',
	'cnw-back' => 'Back',
	'cnw-or' => 'or',
	'cnw-title' => 'Create New Wiki',
	'cnw-name-wiki-headline' => 'Start a Wiki',
	'cnw-name-wiki-creative' => 'Wikia is the best place to build a website and grow a community around what you love.',
	'cnw-name-wiki-label' => 'Name your wiki',
	'cnw-name-wiki-domain-label' => 'Give your wiki an address',
	'cnw-name-wiki-submit-error' => 'Oops! You need to fill in both of the boxes above to keep going.',
	'cnw-login' => 'ننوتل',
	'cnw-signup' => 'Create Account',
	'cnw-signup-prompt' => 'Need an account?',
	'cnw-call-to-signup' => 'Sign up here',
	'cnw-login-prompt' => 'Already have an account?',
	'cnw-call-to-login' => 'Log in here',
	'cnw-auth-headline' => 'ننوتل',
	'cnw-auth-headline2' => 'Sign Up',
	'cnw-auth-creative' => 'Log in to your account to continue building your wiki.',
	'cnw-auth-signup-creative' => "You'll need an account to continue building your wiki.<br />It only takes a minute to sign up!",
	'cnw-auth-facebook-signup' => 'Sign up with Facebook',
	'cnw-auth-facebook-login' => 'Login with Facebook',
	'cnw-desc-headline' => "What's your wiki about?",
	'cnw-desc-creative' => 'Describe your topic',
	'cnw-desc-placeholder' => 'This will appear on the main page of your wiki.',
	'cnw-desc-tip1' => 'Hint',
	'cnw-desc-tip1-creative' => 'Use this space to tell people about your wiki in a sentence or two',
	'cnw-desc-tip2' => 'Psst',
	'cnw-desc-tip2-creative' => 'Give your visitors some specific details about your subject',
	'cnw-desc-select-one' => 'Select one',
	'cnw-desc-default-lang' => 'Your wiki will be in $1',
	'cnw-desc-change-lang' => 'change',
	'cnw-desc-lang' => 'Language',
	'cnw-desc-wiki-submit-error' => 'Please choose a category',
	'cnw-theme-headline' => 'Choose a theme',
	'cnw-theme-creative' => "Choose a theme below, you'll be able to see a preview of each theme as you select it.",
	'cnw-theme-instruction' => 'You can also design your own theme later by going to "My Tools".',
	'cnw-welcome-headline' => 'Congratulations! $1 has been created',
	'cnw-welcome-instruction1' => 'Click the button below to start adding pages to your wiki.',
	'cnw-welcome-help' => 'Find answers, advice, and more on <a href="http://community.wikia.com">Community Central</a>.',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Anakmalaysia
 * @author Dimension
 * @author Hydra
 * @author Hzy980512
 * @author LNDDYL
 * @author Liuxinyu970226
 * @author Liye
 * @author Sam Wang
 * @author TianyinLee
 * @author User670839245
 * @author Yfdyh000
 * @author 乌拉跨氪
 * @author 凡人丶
 */
$messages['zh-hans'] = array(
	'createnewwiki-desc' => '维基创建向导',
	'cnw-next' => '下一步',
	'cnw-back' => '上一步',
	'cnw-or' => '或',
	'cnw-title' => '创建新的维基',
	'cnw-name-wiki-headline' => '创建维基',
	'cnw-name-wiki-creative' => '建立网站、发展社区并开始您的终极粉丝体验。',
	'cnw-name-wiki-label' => '给您的维基命名',
	'cnw-name-wiki-domain-label' => '给您的维基一个地址',
	'cnw-name-wiki-submit-error' => '糟糕！需要填写上面两栏才能继续。',
	'cnw-login' => '登入',
	'cnw-signup' => '创建帐户',
	'cnw-signup-prompt' => '需要一个帐户？',
	'cnw-call-to-signup' => '在这里注册',
	'cnw-login-prompt' => '已有帐户？',
	'cnw-call-to-login' => '在这里登入',
	'cnw-auth-headline' => '登入',
	'cnw-auth-headline2' => '注册',
	'cnw-auth-creative' => '登入到您的账户继续建立您的维基网站。',
	'cnw-auth-signup-creative' => '您需要有账户才能继续建立您的维基。<br />注册只需要一分钟！',
	'cnw-auth-facebook-signup' => '用脸书账号登录',
	'cnw-auth-facebook-login' => '用脸书账号登入',
	'cnw-userauth-headline' => '已有帐户？',
	'cnw-userauth-creative' => '登入',
	'cnw-userauth-marketing-heading' => '还没有帐户？',
	'cnw-userauth-marketing-body' => '您需要有账户才能在wikia上创建维基。注册只需要一分钟！',
	'cnw-userauth-signup-button' => '注册',
	'cnw-desc-headline' => '您的wiki是关于什么的？',
	'cnw-desc-creative' => '用准确到位的描述帮助网友找到您的维基。',
	'cnw-desc-placeholder' => '写好一些！您的文字会显示在您的维基首页上。',
	'cnw-desc-tip1' => '这里有个提示！',
	'cnw-desc-tip1-creative' => '在此栏中说明您的维基的重要性及创建原因。',
	'cnw-desc-tip2' => '提示#2',
	'cnw-desc-tip2-creative' => '通过提供有关您维基的详细信息鼓励其他人加入您的社区。',
	'cnw-desc-select-vertical' => '选择主题类别',
	'cnw-desc-select-categories' => '查看其他类别',
	'cnw-desc-select-one' => '选择一项',
	'cnw-desc-all-ages' => '此维基适合儿童看吗？',
	'cnw-desc-tip-all-ages' => '这是孩子感兴趣的主题吗？为了有助于遵守美国法律，我们会跟踪12岁以下儿感兴趣主题的维基网站。',
	'cnw-desc-default-lang' => '您的维基是$1的。',
	'cnw-desc-change-lang' => '更改',
	'cnw-desc-lang' => '语言',
	'cnw-desc-wiki-submit-error' => '请选择一个类别',
	'cnw-theme-headline' => '选择一个样式',
	'cnw-theme-creative' => '让它看起来就很诱人！选择主题，并查看预览。',
	'cnw-theme-instruction' => '想要进行自定义？以后您可以再通过管理员控制台的主题设计应用来设计自己想要的主题。',
	'cnw-welcome-headline' => '恭喜您！$1已创建成功',
	'cnw-welcome-instruction1' => '点击下面的按钮开始在您的维基上添加页面。',
	'cnw-welcome-help' => '继续您的粉丝体验。在<a href="http://zh.community.wikia.com"> 社区中心</a>查找答案、建议和更多其它信息。',
	'cnw-error-general' => '糟糕，我们这边出错了！请再试一次，或[[Special:Contact|联系我们]]获取帮助。',
	'cnw-error-general-heading' => '我们很抱歉',
	'cnw-badword-header' => '哇',
	'cnw-badword-msg' => '您好，请不要在您的维基描述中使用下列不恰当或禁用的词语：$1',
	'cnw-error-wiki-limit-header' => '已达到维基数上限',
	'cnw-error-wiki-limit' => '您好，您一天只能创建{{PLURAL:$1|$1个维基|$1个维基}}。请等待24小时后再创建另一个维基。',
	'cnw-error-blocked-header' => '帐户被封禁',
	'cnw-error-blocked' => '您已被$1封禁。封禁原因是：$2。（参考封禁ID：$3）',
	'cnw-error-anon-user-header' => '请登入',
	'cnw-error-anon-user' => '无法由匿名用户创建维基。请先[[Special:UserLogin|登入]]，然后再试。',
	'cnw-error-torblock' => '不允许通过Tor创建维基。',
	'cnw-error-bot' => '我们已检测到您可能是一个机器软件。如果这是个错误，请与我们联系，并说明您被误认为是一个机器软件，我们会协助您创建您的维基。联系网址：[http://www.wikia.com/Special:Contact/general 联系我们]',
	'cnw-error-bot-header' => '您已被检测到是机器人。',
	'cnw-error-unconfirmed-email-header' => '您的电子邮件尚未验证。',
	'cnw-error-unconfirmed-email' => '您需要先验证邮件才能创建维基。',
	'cnw-name-wiki-language' => '',
	'cnw-name-wiki-domain' => '.wikia.com',
	'autocreatewiki' => '创建新的维基',
	'autocreatewiki-desc' => '按用户的请求在维基出厂配置中创建维基',
	'autocreatewiki-page-title-default' => '创建新的维基',
	'autocreatewiki-page-title-answers' => '创建新的问答网站',
	'createwiki' => '创建新的维基',
	'autocreatewiki-chooseone' => '选择一个',
	'autocreatewiki-required' => '$1 = 必选项',
	'autocreatewiki-web-address' => '网站地址：',
	'autocreatewiki-category-select' => '选择一个',
	'autocreatewiki-language-top' => '最常用的$1种语言',
	'autocreatewiki-language-all' => '所有语言',
	'autocreatewiki-remember' => '记住我',
	'autocreatewiki-create-account' => '创建帐户',
	'autocreatewiki-haveaccount-question' => '已经有Wikia帐户？',
	'autocreatewiki-info-domain' => '最好使用一个可能会搜索到你的主题的关键字。',
	'autocreatewiki-info-topic' => '添加简短的描述，如“星球大战”或“电视节目”。',
	'autocreatewiki-info-category-default' => '这会帮助访客找到您的维基。',
	'autocreatewiki-info-category-answers' => '这会帮助访客找到您的问答网站。',
	'autocreatewiki-info-language' => '这将是您的维基访客的默认语言。',
	'autocreatewiki-info-email-address' => '我们绝不会将您的电子邮件地址显示给Wikia上的任何人。',
	'autocreatewiki-info-realname' => '如果您选择提供此信息，这将用来表明这些工作是由您完成的。',
	'autocreatewiki-info-birthdate' => '作为安全预防措施，也为了遵守美国联邦法规而保持网站的完整性，Wikia要求所有用户提供自己的真实出生日期。',
	'autocreatewiki-info-blurry-word' => '为了避免自动创建帐户，请在此栏中键入您看到的模糊字词。',
	'autocreatewiki-info-terms-agree' => '创建维基和用户账户，即表示您同意并接受此{{#NewWindowLink: w:Terms of use | Wikia 使用条款}}',
	'autocreatewiki-info-staff-username' => '<b>仅供工作人员使用：</b>指定的用户将被列为创始人。',
	'autocreatewiki-title-template' => '$1Wiki',
	'autocreatewiki-tagline' => '',
	'autocreatewiki-limit-day' => '今天已超过了Wikia每日维基创建数上限($1)。',
	'autocreatewiki-limit-creation' => '您已超过了所允许的24小时维基创建数的上限($1)。',
	'autocreatewiki-empty-field' => '请填写此栏。',
	'autocreatewiki-bad-name' => '名称不能包含特殊字符（如$或@），且必须是不含空格、由小写字母组成的单词。',
	'autocreatewiki-invalid-wikiname' => '名称不能包含特殊字符（如$或@），且不能为空。',
	'autocreatewiki-violate-policy' => '此维基名中含有违反命名准则的字词。',
	'autocreatewiki-name-taken' => '已有用此地址创建的维基。可在<a href="http://$1.wikia.com">http://$1.wikia.com</a>页面进行编辑或选择其他地址。',
	'autocreatewiki-name-too-short' => '此地址过短，请选择一个至少含3个字符的地址。',
	'autocreatewiki-name-too-long' => '此地址过长，请选择一个最多含50个字符的地址。',
	'autocreatewiki-similar-wikis' => '下面是已经创建的关于该主题的维基。我们建议您参与编辑其中之一。',
	'autocreatewiki-invalid-username' => '此用户名无效。',
	'autocreatewiki-busy-username' => '此用户名已有人使用。',
	'autocreatewiki-blocked-username' => '无法创建帐户。',
	'autocreatewiki-user-notloggedin' => '您的帐户已创建，但未登入！',
	'autocreatewiki-empty-language' => '请选择维基的语言。',
	'autocreatewiki-empty-category' => '请选择一个类别。',
	'autocreatewiki-empty-wikiname' => '维基的名称不能为空。',
	'autocreatewiki-empty-username' => '用户名不能为空。',
	'autocreatewiki-empty-password' => '密码不能为空。',
	'autocreatewiki-empty-retype-password' => '重新键入密码栏不能为空。',
	'autocreatewiki-category-label' => '类别：',
	'autocreatewiki-category-other' => '其他',
	'autocreatewiki-set-username' => '请先设置用户名。',
	'autocreatewiki-invalid-category' => '类别值无效。
请从下拉列表中选择适当的类别。',
	'autocreatewiki-invalid-language' => '语言值无效。
请从下拉列表中选择适当的语言。',
	'autocreatewiki-invalid-retype-passwd' => '请重新输入与上栏密码相同的密码。',
	'autocreatewiki-invalid-birthday' => '出生日期无效。',
	'autocreatewiki-log-title' => '正在创建您的维基',
	'autocreatewiki-step0' => '正在进行初始化处理...',
	'autocreatewiki-stepdefault' => '进程正在运行，请稍候...',
	'autocreatewiki-errordefault' => '进程还没结束 …',
	'autocreatewiki-step1' => '正在创建图像文件夹...',
	'autocreatewiki-step2' => '正在创建数据库...',
	'autocreatewiki-step3' => '正在数据库中设置默认信息...',
	'autocreatewiki-step4' => '正在复制默认的图标和图像...',
	'autocreatewiki-step5' => '正在数据库中设置默认变量...',
	'autocreatewiki-step6' => '正在数据库中设置默认表格...',
	'autocreatewiki-step7' => '正在设置语言启动器...',
	'autocreatewiki-step8' => '正在设置用户组和类别...',
	'autocreatewiki-step9' => '正在为新的维基设置变量...',
	'autocreatewiki-step10' => '正在中央维基上设置页面...',
	'autocreatewiki-step11' => '正在给用户发送电子邮件...',
	'autocreatewiki-redirect' => '正在重定向到新的维基： $1...',
	'autocreatewiki-congratulation' => '恭喜您！',
	'autocreatewiki-welcometalk-log' => '欢迎辞',
	'autocreatewiki-regex-error-comment' => '已用于$1维基中（全文：$2）',
	'autocreatewiki-step2-error' => '数据库已存在！',
	'autocreatewiki-step3-error' => '无法在数据库中设置默认信息！',
	'autocreatewiki-step6-error' => '无法在数据库中设置默认表！',
	'autocreatewiki-step7-error' => '无法复制语言启动器数据库！',
	'requestwiki-filter-language' => 'als,an,ang,ast,bar,de2,de-at,de-ch,de-formal,de-weigsbrag,dk,en-gb,eshelp,fihelp,frc,frhelp,ia,ie,ithelp,jahelp,kh,kohelp,kp,ksh,nb,nds,nds-nl,mu,mwl,nlhelp,pdc,pdt,pfl,pthelp,pt-brhelp,ruhelp,simple,tokipona,tp,zh-classical,zh-cn,zh-hans,zh-hant,zh-hk,zh-min-nan,zh-mo,zh-my,zh-sg,zh-tw,zh-yue',
	'autocreatewiki-protect-reason' => '属於官方界面的一部分',
	'autocreatewiki-welcomesubject' => '$1已创建！',
	'autocreatewiki-welcomebody' => '$2!，您好，

您的维基已创建！请点击<$1>查看 。

准备好开始了吗？我们添加了一些链接到您的聊天页面（<$5>）帮助您开始，并鼓励您去探索与Wikia相关的许多有用信息。如有任何疑问或感到困惑，请回复此电子邮件或查看我们的帮助页面<http://zh.help.wikia.com>。

您还可以查阅一下创始人与管理员博客<http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins>（英文）和Wikia社区中心博客<http://zh.community.wikia.com/wiki/Category:%E7%A4%BE%E5%8C%BA%E4%B8%AD%E5%BF%83%E5%8D%9A%E5%AE%A2>。在这里您会找到很多提示和技巧，以及关于Wikia新事物和新功能的信息。

祝您编辑愉快！

$3
Wikia社区支持
<http://zh.community.wikia.com/wiki/用户:$4>

___________________________________________
* 不再希望收到任何消息?您可以前往以下页面取消订阅或更改您的电子邮件偏好设置：http://zh.community.wikia.com/Special:Preferences',
	'autocreatewiki-welcometalk-wall-title' => '欢迎光临！',
	'autocreatewiki-welcometalk-wall' => '嘿，您好！我们很高兴{{subst:SITENAME}}能成为Wikia社区的一部分！还有很多事情要做。这里有一些有用的提示和链接，能让您的维基运转起来：

*查看[[Special：WikiFeatures|维基功能]，看看您可以在您的维基上开启哪些功能，包括聊天、成就及更多其他功能。
 *通过访问 [[Special:ThemeDesigner|主题界面]]自定义您的维基的外观，在这里您可以给您的背景和文字添加颜色和样式。
*到[[w:c:zh.community|社区中心]]来看看，通过我们的[[w:c:zh.community:Category:社区中心博客|社区中心博客]]了解最新信息、在我们的[[w:c:zh.community:Special:Forum|社区论坛]]提问、参与我们的[[w:c:community:Help:Webinars|网络研讨会系列]]（英文）或与其他Wikia用户[[w:c:zh.community:Special:Chat|在线聊天]] 
*最后，请访问我们的[[Help:Contents|帮助页面]]了解如何使用Wikia的所有功能， 包括[[Help:New page|如何在您的维基上添加新页面]]、[[Help:Attracting contributors|如何吸引用户]] 以及[[Help:User access levels|如何添加其他管理员]]。
 * 您还可以到您的管理员控制面板使用上述所有工具，只需点击底部工具栏的“管理员”即可找到这些工具。

上面列出的所有链接都是开始探索的好起点。祝您玩得开心！',
	'autocreatewiki-welcometalk' => '==欢迎您==

嘿！

我们很高兴$4能成为维基社区的一部分！还有很多事情要做；这里有一些有用提示和链接，能让您的维基运转起来：

*查看[[Special：WikiFeatures|维基功能]，看看您可以在您的维基上开启哪些功能，包括聊天、成就及更多功能。
*到[[w:c:zh.community|社区中心]]来看看，通过我们的[[w:c:zh.community:Category:社区中心博客|社区中心博客]]了解最新信息、在我们的[[w:c:zh.community:Special:Forum|社区论坛]]提问、参与我们的[[w:c:community:Help:Webinars|网络研讨会系列]]（英文）或与其他wikia用户在线聊天
*最后，请访问我们的[[Help:Contents|帮助页面]]了解如何使用Wikia的所有功能

上面列出的所有链接都是开始探索的好起点。祝你玩得开心！

-- [[User:$2|$3]] <staff />',
	'autocreatewiki-language-top-list' => 'de,en,es,fr,it,ja,pl,pt-br,ru,zh',
);

/** Traditional Chinese (中文（繁體）‎)
 * @author Anakmalaysia
 * @author Cwlin0416
 * @author Ffaarr
 * @author LNDDYL
 * @author Liuxinyu970226
 * @author Oapbtommy
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'createnewwiki-desc' => 'Wiki 建立精靈',
	'cnw-next' => '下一步',
	'cnw-back' => '前一步',
	'cnw-or' => '或者',
	'cnw-title' => '建立新的 Wiki',
	'cnw-name-wiki-headline' => '建立新的wiki',
	'cnw-name-wiki-creative' => 'Wikia是建立你所喜好的網站和發展社群最好的選擇。',
	'cnw-name-wiki-label' => '給您的wiki一個名字',
	'cnw-name-wiki-domain-label' => '給您的 wiki 的一個網址',
	'cnw-name-wiki-submit-error' => '啊！您需要填寫上面兩欄之後才能繼續。',
	'cnw-login' => '登入',
	'cnw-signup' => '建立帳號',
	'cnw-signup-prompt' => '需要一個帳戶嗎？',
	'cnw-call-to-signup' => '在此處註冊',
	'cnw-login-prompt' => '已擁有帳戶嗎？',
	'cnw-call-to-login' => '在此登入',
	'cnw-auth-headline' => '登入',
	'cnw-auth-headline2' => '註冊',
	'cnw-auth-creative' => '登入到您的帳戶，繼續建立你的 wiki。',
	'cnw-auth-signup-creative' => '你需要一個帳戶以繼續wiki的創建<br />註冊只需要一分鐘！',
	'cnw-auth-facebook-signup' => '用facebook來註冊',
	'cnw-auth-facebook-login' => '以Facebook登入',
	'cnw-userauth-headline' => '擁有帳戶嗎？',
	'cnw-userauth-creative' => '登入',
	'cnw-userauth-marketing-heading' => '沒有帳戶嗎？',
	'cnw-userauth-marketing-body' => '您需要帳戶才能在wikia創建wiki。只需要一分鐘即可註冊!',
	'cnw-userauth-signup-button' => '註冊',
	'cnw-desc-headline' => '你的 wikia 是關於什麼的？',
	'cnw-desc-creative' => '您的描述將幫忙人們找到您的 wikia',
	'cnw-desc-placeholder' => '這將顯示你的 wiki 的首頁上。',
	'cnw-desc-tip1' => '提示',
	'cnw-desc-tip1-creative' => '使用此空間以一兩句話來向其他人講述你的 wiki。',
	'cnw-desc-tip2-creative' => '向訪問者提供一些有關你的主題的特定詳細資訊',
	'cnw-desc-select-one' => '請選擇一項',
	'cnw-desc-all-ages' => '所有年齡',
	'cnw-desc-tip-all-ages' => '這個Wiki有關於孩子們感興趣的話題嗎？为了遵守美國法律，我們持續追縱直接與12歲及以下兒童相關主題的wiki。',
	'cnw-desc-default-lang' => '您的 wiki 將位於 $1',
	'cnw-desc-change-lang' => '變更',
	'cnw-desc-lang' => '語言',
	'cnw-desc-wiki-submit-error' => '請選擇一個分類',
	'cnw-theme-headline' => '選擇一個主題',
	'cnw-theme-creative' => '選擇下面其中一個樣式，選擇之後您可以看到每個樣式的預覽。',
	'cnw-theme-instruction' => '您還可以稍後透過"我的工具"設計您自己的樣式。',
	'cnw-welcome-headline' => '恭喜！ $1 已建立',
	'cnw-welcome-instruction1' => '按一下下面的按鈕以開始將頁面添加到你的 wiki。',
	'cnw-welcome-help' => '要找尋解答、建議以及其他，可到 <a href="http://community.wikia.com">社群中心</a>.',
	'cnw-error-general' => '哎呀，我們這邊出了一些問題 ！請重試，或 [[Special： Contact|聯絡我們]]以得到幫助。',
	'cnw-error-general-heading' => '抱歉',
	'cnw-badword-header' => '哇',
	'cnw-badword-msg' => '嗨，請不要使用這些不好的、被禁止的字詞在您的 Wiki 描述：$1',
	'cnw-error-wiki-limit-header' => '到達 Wiki 限制',
	'cnw-error-wiki-limit' => '您好，您受限於每天的 {{PLURAL:$1|$1 wiki creation|$1 wiki創建}} 數量。 請等待24小時之後再創建另一個wiki。.',
	'cnw-error-blocked-header' => '帳戶被封禁',
	'cnw-error-blocked' => '您的帳戶被 $1封禁。 封禁原因是 $2. (被封禁ID: $3)',
	'cnw-error-anon-user-header' => '請登錄',
	'cnw-error-anon-user' => '匿名使用者不能建立維基。請先[[Special:UserLogin|登入]]後再試。',
	'cnw-error-torblock' => '不允許透過 Tor 網路建立 wiki 。',
	'cnw-error-bot' => '我們檢測到您可能是個機器人。如果我們搞錯了，請聯絡並告訴我們，您已經被誤以為是一個機器人，我們將協助您建立您的 wiki: [HTTP://www.wikia.com/Special:Contact/聯絡我們]',
	'cnw-error-bot-header' => '你已被檢測到是機器人',
);

$messages['zh-tw'] = array(
	'createnewwiki-desc' => '維基創建嚮導',
	'cnw-next' => '下一步',
	'cnw-back' => '前一步',
	'cnw-or' => '或者',
	'cnw-title' => '創建新的維基',
	'cnw-name-wiki-headline' => '創建維基',
	'cnw-name-wiki-creative' => '建立網站、發展社群並開始你的終極粉絲體驗。',
	'cnw-name-wiki-label' => '給你的維基命名',
	'cnw-name-wiki-domain-label' => '給你的維基一個網址',
	'cnw-name-wiki-language' => '',
	'cnw-name-wiki-domain' => '.wikia.com',
	'cnw-name-wiki-submit-error' => '抱歉！需要填寫上面兩欄才能繼續。',
	'cnw-login' => '登入',
	'cnw-signup' => '創建帳戶',
	'cnw-signup-prompt' => '需要一個帳戶？',
	'cnw-call-to-signup' => '在這裡註冊',
	'cnw-login-prompt' => '已有帳戶？',
	'cnw-call-to-login' => '在這裡登入',
	'cnw-auth-headline' => '登入',
	'cnw-auth-headline2' => '註冊',
	'cnw-auth-creative' => '登入到你的帳戶繼續建立你的維基網站。',
	'cnw-auth-signup-creative' => '你需要有帳戶才能繼續建立你的維基<br />註冊只需要一分鐘！',
	'cnw-auth-facebook-signup' => '用Facebook帳號註冊',
	'cnw-auth-facebook-login' => '用Facebook帳號登入',
	'cnw-userauth-headline' => '已有帳戶？',
	'cnw-userauth-creative' => '登入',
	'cnw-userauth-marketing-heading' => '還沒有帳戶？',
	'cnw-userauth-marketing-body' => '你需要有帳戶才能在Wikia上創建維基。註冊只需要一分鐘!',
	'cnw-userauth-signup-button' => '註冊',
	'cnw-desc-headline' => '你的維基的主題為何？',
	'cnw-desc-creative' => '用準確到位的描述幫助網友找到你的維基。',
	'cnw-desc-placeholder' => '寫好一點！你的文字會顯示在你的維基的首頁上。',
	'cnw-desc-tip1' => '提示：',
	'cnw-desc-tip1-creative' => '在此欄中説明你的維基的重要性及創建理由。',
	'cnw-desc-tip2' => '提示2：',
	'cnw-desc-tip2-creative' => '透過提供你的維基的相關詳細資訊鼓勵其他人加入你的社區。',
	'cnw-desc-select-vertical' => '選擇主題類別',
	'cnw-desc-select-categories' => '查看其它類別',
	'cnw-desc-select-one' => '選擇一項',
	'cnw-desc-all-ages' => '這個維基適合兒童看嗎？',
	'cnw-desc-tip-all-ages' => '這是孩子感興趣的話題嗎？為了幫助遵守美國法律，我們會追縱其主題直接針對12歲以下兒童的維基網站。',
	'cnw-desc-default-lang' => '你的維基是$1的。',
	'cnw-desc-change-lang' => '更改',
	'cnw-desc-lang' => '語言',
	'cnw-desc-wiki-submit-error' => '請選擇一個類別',
	'cnw-theme-headline' => '選擇一個樣式',
	'cnw-theme-creative' => '讓它看起來就很吸引人！選擇主題並查看預覽。',
	'cnw-theme-instruction' => '想要進行自訂？以後你還可以透過管理員控制臺的「主題設計」來設計自己想要的樣式。',
	'cnw-welcome-headline' => '恭喜你！已成功創建$1！',
	'cnw-welcome-instruction1' => '按一下下面的按鈕在你的維基增加新頁面。',
	'cnw-welcome-help' => '繼續你的粉絲體驗。在<a href="http://zh.community.wikia.com">社區中心</a>查找答案、建議和更多其他訊息。',
	'cnw-error-general' => '糟糕，我們這邊發生問題！請再試一次，或[[Special:Contact|聯絡我們]]以得到幫助。',
	'cnw-error-general-heading' => '我們很抱歉。',
	'cnw-badword-header' => '請注意',
	'cnw-badword-msg' => '你好，請不要在你的維基描述中使用下列不恰當或禁用的詞語：$1',
	'cnw-error-wiki-limit-header' => '已達到允許的維基數上限。',
	'cnw-error-wiki-limit' => '你好，你每天最多只能創建{{PLURAL:$1|$1個維基|$1個維基}}。 請等待24小時後再創建另一個維基。',
	'cnw-error-blocked-header' => '帳戶已被封禁。',
	'cnw-error-blocked' => '你已被$1封禁。封禁原因是：$2。（參考封禁ID：$3）',
	'cnw-error-anon-user-header' => '請登入',
	'cnw-error-anon-user' => '無法由匿名用戶創建維基。請先[[Special:UserLogin|登入]]，然後再試。',
	'cnw-error-torblock' => '不允許透過Tor創建維基。',
	'cnw-error-bot' => '我們檢測到你可能是個機器人。如果我們弄錯了，請聯絡我們，並説明你被錯誤地檢測為機器人，我們會協助你創建你的維基。請按一下 [HTTP://www.wikia.com/Special:Contact 聯繫我們]。',
	'cnw-error-bot-header' => '你已被檢測認定為機器人。',
	'cnw-error-unconfirmed-email-header' => '你的電子郵件尚未認證。',
	'cnw-error-unconfirmed-email' => '必須先認證你的電子郵件才能創建維基。',
	'autocreatewiki' => '創建新的維基',
	'autocreatewiki-desc' => '按用戶的請求在維基出廠配置中創建維基',
	'autocreatewiki-page-title-default' => '創建新的維基',
	'autocreatewiki-page-title-answers' => '創建新的問答網站',
	'createwiki' => '創建新的維基',
	'autocreatewiki-chooseone' => '選擇一個',
	'autocreatewiki-required' => '$1 = 必選項目',
	'autocreatewiki-web-address' => '網站位址：',
	'autocreatewiki-category-select' => '選擇一個',
	'autocreatewiki-language-top' => '最常用的$1種語言',
	'autocreatewiki-language-all' => '所有語言',
	'autocreatewiki-remember' => '記住我',
	'autocreatewiki-create-account' => '創建帳戶',
	'autocreatewiki-haveaccount-question' => '已經有Wikia帳戶？',
	'autocreatewiki-info-domain' => '最好使用一個可能會搜尋到你的主題的關鍵字。',
	'autocreatewiki-info-topic' => '增加簡短的描述，如「星際大戰」或「電視節目」。',
	'autocreatewiki-info-category-default' => '這會幫助訪客找到你的維基。',
	'autocreatewiki-info-category-answers' => '這會幫助訪客找到你的問答網站。',
	'autocreatewiki-info-language' => '這將是你的維基訪客的預設語言。',
	'autocreatewiki-info-email-address' => '我們絕不會把你的電子郵寄地址顯示給Wikia上的任何人。',
	'autocreatewiki-info-realname' => '如果您選擇提供此資訊，這將用來表明這些工作是由你完成的。',
	'autocreatewiki-info-birthdate' => '作爲安全措施，也作爲保持網站完整性的手段，同時也爲了遵守美國聯邦法規，Wikia要求所有用戶提供自己的真實出生日期。',
	'autocreatewiki-info-blurry-word' => '為了幫助防止自動創建帳戶，請在此欄中鍵入你看到的模糊字詞。',
	'autocreatewiki-info-terms-agree' => '創建維基和使用者帳戶，即表示你同意此<a {{#NewWindowLink: w:zh.Terms of use | Wikia使用條款}}</a>。',
	'autocreatewiki-info-staff-username' => '<b>僅供工作人員使用：</b>指定的用戶將被列爲創始人。',
	'autocreatewiki-title-template' => '$1Wiki',
	'autocreatewiki-tagline' => '',
	'autocreatewiki-limit-day' => '在今天已超過了Wikia每日維基創建數上限($1)。',
	'autocreatewiki-limit-creation' => '您已超出所允許的24小時維基創建數上限($1)。',
	'autocreatewiki-empty-field' => '請填寫此欄位。',
	'autocreatewiki-bad-name' => '名稱不能包含特殊字元 （如 $ 或 @），並且必須是沒有空格、由小寫字母組成的單字。',
	'autocreatewiki-invalid-wikiname' => '名稱不能包含特殊字元 （如 $ 或 @） 且不能為空白。',
	'autocreatewiki-violate-policy' => '此維基名稱中包含有違反我們的命名準則的字詞。',
	'autocreatewiki-name-taken' => '已經有用此網址創建的維基。可在<a href="http://<span class=" notranslate"="">$1.wikia.com">http:// $1.wikia.com</a> 進行編輯或選擇另一個位址。',
	'autocreatewiki-name-too-short' => '此網址太短，請選擇一個至少有3個字元的網址。',
	'autocreatewiki-name-too-long' => '此網址太長，請選擇一個50個字元以下的網址。',
	'autocreatewiki-similar-wikis' => '下面是已經創建的關於這一主題的維基。我們建議您參與編輯其中之一。',
	'autocreatewiki-invalid-username' => '此用戶名無效。',
	'autocreatewiki-busy-username' => '此用戶名已有人使用。',
	'autocreatewiki-blocked-username' => '無法創建帳戶。',
	'autocreatewiki-user-notloggedin' => '你的帳戶已創建，但未登入！',
	'autocreatewiki-empty-language' => '請選擇維基的語言。',
	'autocreatewiki-empty-category' => '請選擇一個類別。',
	'autocreatewiki-empty-wikiname' => '維基的名稱不能為空白。',
	'autocreatewiki-empty-username' => '使用者名稱不能為空白。',
	'autocreatewiki-empty-password' => '密碼不能為空白。',
	'autocreatewiki-empty-retype-password' => '重新鍵入密碼不能為空白。',
	'autocreatewiki-category-label' => '類別：',
	'autocreatewiki-category-other' => '其他',
	'autocreatewiki-set-username' => '請先設置使用者名稱。',
	'autocreatewiki-invalid-category' => '無效的類別。
請從下拉列表中選擇適當的類別。',
	'autocreatewiki-invalid-language' => '無效的語言。
請從下拉列表中選擇適當的語言。',
	'autocreatewiki-invalid-retype-passwd' => '請再輸入與上欄密碼相同的密碼。',
	'autocreatewiki-invalid-birthday' => '出生日期無效。',
	'autocreatewiki-log-title' => '正在創建你的維基',
	'autocreatewiki-step0' => '正在進行初始化處理...',
	'autocreatewiki-stepdefault' => '處理中，請稍候...',
	'autocreatewiki-errordefault' => '仍在處理中...',
	'autocreatewiki-step1' => '正在創建影像文件夾...',
	'autocreatewiki-step2' => '正在創建資料庫...',
	'autocreatewiki-step3' => '正在資料庫中設置預設資訊...',
	'autocreatewiki-step4' => '正在複製預設的圖標和圖像...',
	'autocreatewiki-step5' => '正在資料庫中設置預設變數...',
	'autocreatewiki-step6' => '正在資料庫中設置預設表格...',
	'autocreatewiki-step7' => '設置語言啟動器...',
	'autocreatewiki-step8' => '設置用戶組和類別...',
	'autocreatewiki-step9' => '正在為新的維基設置變數...',
	'autocreatewiki-step10' => '正在中央維基上設置頁面...',
	'autocreatewiki-step11' => '正在給用戶發送電子郵件...',
	'autocreatewiki-redirect' => '正在重定向到新的維基：$1 ...',
	'autocreatewiki-congratulation' => '恭喜你！',
	'autocreatewiki-welcometalk-log' => '歡迎辭',
	'autocreatewiki-regex-error-comment' => '已用於$1維基（全文：$2 ）',
	'autocreatewiki-step2-error' => '資料庫已存在！',
	'autocreatewiki-step3-error' => '無法在資料庫中設置預設資訊 ！',
	'autocreatewiki-step6-error' => '無法在資料庫中設置預設表格！',
	'autocreatewiki-step7-error' => '無法複製啟動資料庫的語言 ！',
	'requestwiki-filter-language' => 'als,an,ang,ast,bar,de2,de-at,de-ch,de-formal,de-weigsbrag,dk,en-gb,eshelp,fihelp,frc,frhelp,ia,ie,ithelp,jahelp,kh,kohelp,kp,ksh,nb,nds,nds-nl,mu,mwl,nlhelp,pdc,pdt,pfl,pthelp,pt-brhelp,ruhelp,simple,tokipona,tp,zh-classical,zh-cn,zh-hans,zh-hant,zh-hk,zh-min-nan,zh-mo,zh-my,zh-sg,zh-tw,zh-yue',
	'autocreatewiki-protect-reason' => '屬於官方介面',
	'autocreatewiki-welcomesubject' => '$1已創建！',
	'autocreatewiki-welcomebody' => '$2，你好！

 你的維基網站已創建！請點擊<$1>查看。

 準備好開始了嗎？我們在你的聊天頁面（<$5>）添加了一些連結以幫助你開始，並鼓勵你去探索與Wikia相關的很多有用資訊。如有任何疑問或感到困惑，請回覆此電子郵件或查看我們的幫助頁面<http://zh.help.wikia.com>。

 你還可以查閲一下創始人與管理員網誌<http://community.wikia.com/wiki/Blog%3AWikia_Founders_%26_Admins>（英文）和Wikia社區中心網誌<http://zh.community.wikia.com/wiki/Category:%E7%A4%BE%E5%8C%BA%E4%B8%AD%E5%BF%83%E5%8D%9A%E5%AE%A2>。在這裡你會找到很多提示和技巧，以及關於Wikia的新事物和新功能的資訊。

 祝你編輯愉快！

 $3
 Wikia社區支持
<http://zh.community.wikia.com/wiki/使用者:$4>

___________________________________________
 * 不再希望收到任何消息？你可以前往以下頁面取消訂閲或更改你的電子郵件首選項： http://zh.community.wikia.com/Special:Preferences',
	'autocreatewiki-welcometalk-wall-title' => '歡迎你！',
	'autocreatewiki-welcometalk-wall' => '嘿，你好！我們很高興{{subst:SITENAME}}能成爲Wikia社區的一部分！

 還有很多事情要做。這裡有一些有用的提示和連接，能讓你的維基運轉起來：
 *查看[[Special:WikiFeatures|維基功能]]，看看你可以在你的維基上開啓那些功能，包括聊天、成就及更多其他功能。
 *透過訪問[[Special:ThemeDesigner|主題界面]]自訂你的維基的外觀，在這裡你可以給你的背景和文字添加顔色和樣式。
 *到[[w:c:zh.community|社區中心]]來看看，透過我們的[[w:c:zh.community:Category:社区中心博客|社區中心網誌]]了解最新資訊、在我們的[[w:c:zh.community:Special:Forum|社區論壇]]提問、參與我們的[[w:c:community:Help:Webinars|網路研討會系列]]（英文）或與其他Wikia用户[[w:c:zh.community:Special:Chat|線上聊天]]。
 *最後，請訪問我們的[[Help:Contents|幫助頁面]]了解如何使用Wikia的所有功能，包括[[Help:New page|如何在你的維基上添加新頁面]]、 [[Help:Attracting contributors|如何吸引網友]]以及[[Help:User access levels|如何添加其他管理員]]。
 * 你還可以到你的管理員控制面板使用上述所有工具，只需按一下底部工具欄的「管理員」即可找到這些工具。

 上面列出的所有連結都是開始探索的好起點。祝你使用愉快！',
	'autocreatewiki-welcometalk' => '==歡迎你！==
 嘿，你好！

 你好！我們很高興{{subst:SITENAME}}能成爲Wikia社區的一部分！還有很多事情要做。這裡有一些有用的提示和連接，能讓你的維基開始運轉：

 *查看[[Special:WikiFeatures|維基功能]]，看看你可以在你的維基上開啓哪些功能，包括聊天、成就及更多其他功能。
 *到[[w:c:zh.community|社區中心]]來看看，透過我們的[[w:c:zh.community:Category:社区中心博客|社區中心網誌]]了解最新資訊、在我們的[[w:c:zh.community:Special:Forum|社區論壇]]提問、參與我們的[[w:c:community:Help:Webinars|網路研討會系列]]（英文）或與其他Wikia使用者[[w:c:zh.community:Special:Chat|線上聊天]]。
 *最後，請訪問我們的[[Help:Contents|幫助頁面]]了解如何使用Wikia的所有功能

上面列出的所有連接都是開始探索的好起點。祝你使用愉快！

 -- [[User:$2|$3]]  <staff />',
	'autocreatewiki-language-top-list' => 'de,en,es,fr,it,ja,pl,pt-br,ru,zh',
);

