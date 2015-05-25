<?php
/**
* Internationalisation file for the CreateNewWiki extension.
*
* @addtogroup Languages
*/

$messages = array();

$messages['en'] = array(
	// general messages
	'createnewwiki-desc' => 'Wiki creation wizard',
	'cnw-next' => 'Next',
	'cnw-back' => 'Back',
	'cnw-or' => 'or',
	'cnw-title' => 'Create New Wiki',
	// step1 - create a wiki
	'cnw-name-wiki-headline' => 'Start a wikia',
	'cnw-name-wiki-creative' => 'Build a website, grow a community, and embark on your ultimate fan experience.',
	'cnw-name-wiki-label' => 'Name your wikia',
	'cnw-name-wiki-domain-label' => 'Give your wikia an address',
	'cnw-name-wiki-language' => '',
	'cnw-name-wiki-domain' => '.wikia.com',
	'cnw-name-wiki-submit-error' => 'Oops! You need to fill in both of the boxes above to keep going.',
	// step2 - signup/login
	'cnw-login' => 'Log In',
	'cnw-signup' => 'Create Account',
	'cnw-signup-prompt' => 'Need an account?',
	'cnw-call-to-signup' => 'Sign up here',
	'cnw-login-prompt' => 'Already have an account?',
	'cnw-call-to-login' => 'Log in here',
	'cnw-auth-headline' => 'Log In',
	'cnw-auth-headline2' => 'Sign Up',
	'cnw-auth-creative' => 'Log in to your account to continue building your wiki.',
	'cnw-auth-signup-creative' => 'You\'ll need an account to continue building your wiki.<br />It only takes a minute to sign up!',
	'cnw-auth-facebook-signup' => 'Sign up with Facebook',
	'cnw-auth-facebook-login' => 'Login with Facebook',
	// step2 - Wikia user signup
	'cnw-userauth-headline' => 'Have an account?',
	'cnw-userauth-creative' => 'Log in',
	'cnw-userauth-marketing-heading' => 'Don\'t have an account?',
	'cnw-userauth-marketing-body' => 'You need an account to create a wiki on Wikia. It only takes a minute to sign up!',
	'cnw-userauth-signup-button' => 'Sign up',
	// step3 - wiki description
	'cnw-desc-headline' => 'What\'s your wikia about?',
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
	// step4 - select theme
	'cnw-theme-headline' => 'Choose a theme',
	'cnw-theme-creative' => 'Make it look good! Select a theme to see a preview of it.',
	'cnw-theme-instruction' => 'Want to customize it? You can design your own theme later by going to Theme Designer via your Admin Dashboard.',
	// wiki welcome message
	'cnw-welcome-headline' => 'Congratulations! You successfully created $1',
	'cnw-welcome-instruction1' => 'Click the button below to start adding pages to your wikia.',
	'cnw-welcome-help' => 'Continue your fan experience. Find answers, advice, and more on <a href="http://community.wikia.com">Community Central</a>.',
	// error messages
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
	'createnewwiki-desc' => 'Tcicesiki va redura va wiki', # Fuzzy
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
	'cnw-userauth-marketing-body' => 'Enide va redura va wiki dene Wikia, pata tir adrafa. Ta dogluyara nemon tanoya wexa !', # Fuzzy
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
	'cnw-error-general' => 'Rotaca sokiyir bak redura va wiki. Vay fure gire laredul.', # Fuzzy
	'cnw-error-general-heading' => 'Rokla va redura va warzafi wiki', # Fuzzy
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

/** South Azerbaijani (تورکجه)
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
	'cnw-name-wiki-label' => 'شمی ویکی ئی نام', # Fuzzy
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
	'cnw-error-wiki-limit' => "Ac'hanta, bevennet eo ar c'hrouiñ wikioù da $1 wiki dre zen ha dre zevezh. Gortozit 24 eurvezh a-benn gellout krouiñ unan all.", # Fuzzy
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
	'cnw-desc-all-ages' => 'Ngamin na edad', # Fuzzy
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
 * @author Chmee2
 * @author H4nek
 * @author Jezevec
 * @author Reaperman
 */
$messages['cs'] = array(
	'cnw-next' => 'Další',
	'cnw-back' => 'Zpět',
	'cnw-or' => 'nebo',
	'cnw-title' => 'Vytvořit novou Wiki',
	'cnw-name-wiki-headline' => 'Vytvořit Wiki',
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
	'cnw-auth-facebook-signup' => 'Registrovat se prostřednictvím Facebooku',
	'cnw-auth-facebook-login' => 'Přihlásit se prostřednictvím Facebooku',
	'cnw-userauth-headline' => 'Máte účet?',
	'cnw-userauth-creative' => 'Přihlásit se',
	'cnw-userauth-marketing-heading' => 'Nemáte účet?',
	'cnw-userauth-signup-button' => 'Zaregistrovat se',
	'cnw-desc-headline' => 'O čem je vaše wiki?', # Fuzzy
	'cnw-desc-creative' => 'Popište vaše téma', # Fuzzy
	'cnw-desc-tip1' => 'Tip',
	'cnw-desc-tip2' => 'Pššt',
	'cnw-desc-select-one' => 'Jeden vyberte',
	'cnw-desc-all-ages' => 'Všechny stránky', # Fuzzy
	'cnw-desc-default-lang' => 'Vaše wiki bude v $1',
	'cnw-desc-change-lang' => 'změnit',
	'cnw-desc-lang' => 'Jazyk',
	'cnw-desc-wiki-submit-error' => 'Prosím vyberte kategorii',
	'cnw-theme-headline' => 'Zvolte téma',
	'cnw-error-general-heading' => 'Omlouváme se',
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
	'createnewwiki-desc' => 'Assistent zum Erstellen eines Wikis',
	'cnw-next' => 'Nächste',
	'cnw-back' => 'Zurück',
	'cnw-or' => 'oder',
	'cnw-title' => 'Neues Wiki erstellen',
	'cnw-name-wiki-headline' => 'Ein Wiki starten', # Fuzzy
	'cnw-name-wiki-creative' => 'Erstelle eine Website, baue eine Gemeinschaft auf und steig ein in dein ultimatives Fanerlebnis.',
	'cnw-name-wiki-label' => 'Benenne dein Wikia',
	'cnw-name-wiki-domain-label' => 'Gib deinem Wikia eine Adresse',
	'cnw-name-wiki-submit-error' => 'Ups! Du musst beide Felder oben ausfüllen um weiterzumachen.',
	'cnw-login' => 'Anmelden',
	'cnw-signup' => 'Benutzerkonto erstellen',
	'cnw-signup-prompt' => 'Brauchst du ein Benutzerkonto?',
	'cnw-call-to-signup' => 'Hier registrieren',
	'cnw-login-prompt' => 'Hast du bereits ein Benutzerkonto?',
	'cnw-call-to-login' => 'Hier anmelden',
	'cnw-auth-headline' => 'Anmelden',
	'cnw-auth-headline2' => 'Registrieren',
	'cnw-auth-creative' => 'Melde dich mit deinem Benutzerkonto an, um mit der Erstellung deines Wikis fortzufahren.',
	'cnw-auth-signup-creative' => 'Du benötigst ein Konto, um mit der Erstellung deines Wikis fortzufahren.<br />Es dauert nur eine Minute sich zu registrieren!',
	'cnw-auth-facebook-signup' => 'Über Facebook registrieren',
	'cnw-auth-facebook-login' => 'Über Facebook anmelden',
	'cnw-userauth-headline' => 'Bereits ein Mitglied?',
	'cnw-userauth-creative' => 'Anmelden',
	'cnw-userauth-marketing-heading' => 'Noch kein Mitglied?',
	'cnw-userauth-marketing-body' => 'Du benötigst ein Benutzerkonto auf Wikia. Nach einer Minute bist du bereits Mitglied!',
	'cnw-userauth-signup-button' => 'Registrieren',
	'cnw-desc-headline' => 'Worum geht es in deinem Wikia?',
	'cnw-desc-creative' => 'Hilf Menschen, dein Wikia mit einer hervorragenden Beschreibung zu finden.',
	'cnw-desc-placeholder' => 'Mach es gut! Dein Text erscheint auf der Hauptseite deines Wikias.',
	'cnw-desc-tip1' => 'Hier ist ein Tipp!',
	'cnw-desc-tip1-creative' => 'Nutze dieses Feld, um den Leuten zu erzählen, warum dieses Wikia wichtig ist und den Grund für deine Erstellung.',
	'cnw-desc-tip2' => 'PS',
	'cnw-desc-tip2-creative' => 'Ermutige andere dazu, in unsere Gemeinschaft einzutreten durch das Anbieten von Einzelheiten über dein Wikia.',
	'cnw-desc-select-vertical' => 'Eine Hub-Kategorie auswählen',
	'cnw-desc-select-categories' => 'Zusätzliche Kategorien markieren',
	'cnw-desc-select-one' => 'Bitte wählen',
	'cnw-desc-all-ages' => 'Ist dieses Wikia für Kinder bestimmt?',
	'cnw-desc-tip-all-ages' => 'Ist das Thema dieses Wikias auf Kinder zugeschnitten? Zur Einhaltung von US-Recht haben wir ein Auge auf Wikias, die Kinder unter 13 Jahren direkt ansprechen.',
	'cnw-desc-default-lang' => 'Die Sprache deines Wikias wird $1',
	'cnw-desc-change-lang' => 'ändern',
	'cnw-desc-lang' => 'Sprache',
	'cnw-desc-wiki-submit-error' => 'Bitte wähle eine Kategorie',
	'cnw-theme-headline' => 'Wähle ein Theme',
	'cnw-theme-creative' => 'Mach es gutaussehend! Wähle ein Theme aus, um eine Vorschau zu sehen.',
	'cnw-theme-instruction' => 'Möchtest du es anpassen? Du kannst später dein eigenes Theme entwerfen, indem du zum Themedesigner über dein Admin-Dashboard gehst.',
	'cnw-welcome-headline' => 'Herzlichen Glückwunsch! Du hast erfolgreich $1 erstellt',
	'cnw-welcome-instruction1' => 'Klick auf die Schaltfläche unten, um Seiten zu deinem Wikia hinzuzufügen.',
	'cnw-welcome-help' => 'Weite dein Fanerlebnis aus. Finde Antworten, Ratschläge und mehr auf <a href="http://community.wikia.com">Community Central</a>.',
	'cnw-error-general' => 'Huch! Etwas ist unsererseits schief gelaufen. Bitte versuche es erneut oder [[Special:Contact|kontaktiere uns]], wenn du Hilfe brauchst.',
	'cnw-error-general-heading' => 'Wir bitten um Entschuldigung',
	'cnw-badword-header' => 'Ganz ruhig',
	'cnw-badword-msg' => 'Hallo, bitte verwende keines der folgenden Schimpfwörter oder unerlaubten Begriffe in deiner Wiki-Beschreibung: $1',
	'cnw-error-wiki-limit-header' => 'Wiki Limit erreicht',
	'cnw-error-wiki-limit' => 'Hallo, du darfst nur {{PLURAL:$1|ein Wiki|$1 Wikis}} am Tag gründen. Warte 24 Stunden, bevor du ein weiteres Wiki gründest.',
	'cnw-error-blocked-header' => 'Benutzerkonto gesperrt',
	'cnw-error-blocked' => 'Du wurdest von $1 gesperrt. Die Begründung lautet: $2. (Block-ID zu Referenzzwecken: $3)',
	'cnw-error-anon-user-header' => 'Bitte anmelden',
	'cnw-error-anon-user' => 'Das Erstellen von Wikis für anonyme Benutzer wurde deaktiviert. Bitte [[Special:UserLogin|melde dich an]] und versuche es erneut.',
	'cnw-error-torblock' => 'Das Erstellen von Wikis über das Tor-Netzwerk ist nicht erlaubt.',
	'cnw-error-bot' => 'Wir haben festgestellt, dass dies wahrscheinlich ein Bot-Account ist. Wenn wir damit falsch liegen, kontaktiere uns bitte mit dem Hinweis, dass wir dich fälschlicherweise als Bot festgestellt haben. Dann können wir dir helfen. [http://www.wikia.com/Special:Contact/general Kontaktformular]',
	'cnw-error-bot-header' => 'Du wurdest als Bot identifiziert.',
	'cnw-error-unconfirmed-email-header' => 'Deine E-Mail-Adresse wurde nicht bestätigt',
	'cnw-error-unconfirmed-email' => 'Deine E-Mail-Adresse sollte zum Erstellen eines Wikis bestätigt werden.',
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
	'createnewwiki-desc' => 'Wikiyo newe vırazdar', # Fuzzy
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
	'createnewwiki-desc' => 'Asistente para la creación de Wikis',
	'cnw-next' => 'Siguiente',
	'cnw-back' => 'Atrás',
	'cnw-or' => 'o',
	'cnw-title' => 'Crear un nuevo wiki',
	'cnw-name-wiki-headline' => 'Comenzar una wikia',
	'cnw-name-wiki-creative' => 'Construye un sitio web, haz crecer una comunidad y dirígela hacia tus experiencias como fan.',
	'cnw-name-wiki-label' => 'Nombre de tu wikia',
	'cnw-name-wiki-domain-label' => 'Dale a tu wikia una dirección',
	'cnw-name-wiki-submit-error' => 'Asegúrate de rellenar ambos cuadros antes de continuar.',
	'cnw-login' => 'Entrar',
	'cnw-signup' => 'Crear una cuenta',
	'cnw-signup-prompt' => '¿Necesitas una cuenta?',
	'cnw-call-to-signup' => 'Regístrate aquí',
	'cnw-login-prompt' => '¿Ya tienes una cuenta?',
	'cnw-call-to-login' => 'Iniciar sesión aquí',
	'cnw-auth-headline' => 'Entrar',
	'cnw-auth-headline2' => 'Registrarse',
	'cnw-auth-creative' => 'Inicia sesión con tu cuenta para continuar la contrucción de tu wiki.',
	'cnw-auth-signup-creative' => 'Necesitarás una cuenta para seguir construyendo tu wiki.<br />¡Solamente tardarás un minuto para registrarte!',
	'cnw-auth-facebook-signup' => 'Registraste con Facebook',
	'cnw-auth-facebook-login' => 'Entrar con Facebook',
	'cnw-userauth-headline' => '¿Tienes una cuenta?',
	'cnw-userauth-creative' => 'Iniciar sesión',
	'cnw-userauth-marketing-heading' => '¿No tienes una cuenta?',
	'cnw-userauth-marketing-body' => 'Necesitas una cuenta para crear un wiki en Wikia. ¡Solo tardas un minuto en registrarte!',
	'cnw-userauth-signup-button' => 'Registrarse',
	'cnw-desc-headline' => '¿De qué trata tu wikia?',
	'cnw-desc-creative' => 'Ayuda a las personas a encontrar tu wikia con una descripción llamativa.',
	'cnw-desc-placeholder' => 'Tu texto aparecerá en la página principal de tu wikia.',
	'cnw-desc-tip1' => '¡Sugerencia!',
	'cnw-desc-tip1-creative' => 'Utiliza este espacio para decirle a la gente de qué trata tu wikia y la razón por la que la creaste.',
	'cnw-desc-tip2' => 'PS',
	'cnw-desc-tip2-creative' => 'Anima a otros a unirse a tu comunidad, ofreciéndoles detalles acerca de tu wikia.',
	'cnw-desc-select-vertical' => 'Selecciona una categoría',
	'cnw-desc-select-categories' => 'Selecciona categorías adicionales',
	'cnw-desc-select-one' => 'Selecciona una',
	'cnw-desc-all-ages' => '¿Esta wikia está destinada a un público infantil?',
	'cnw-desc-tip-all-ages' => '¿Esto es acerca de un tema para niños? Para ayudarnos a cumplir con una ley de Estados Unidos mantenemos un seguimiento constante de aquellas wikias que interesan directamente a los niños menores de 12 años.',
	'cnw-desc-default-lang' => 'Tu wikia estará en $1',
	'cnw-desc-change-lang' => 'cambiar',
	'cnw-desc-lang' => 'Idioma',
	'cnw-desc-wiki-submit-error' => 'Por favor, elige una categoría',
	'cnw-theme-headline' => 'Diseña tu wiki',
	'cnw-theme-creative' => '¡Que se vea bien! Selecciona un tema para ver una vista previa.',
	'cnw-theme-instruction' => 'Puedes cambiar el tema o diseñar tu propio en cualquier momento usando "Mis Herramientas" en tu Panel de Administración.',
	'cnw-welcome-headline' => '¡Felicitaciones! Has creado $1',
	'cnw-welcome-instruction1' => 'Ahora haz clic al botón de abajo para empezar a añadir páginas a tu wikia.',
	'cnw-welcome-help' => 'Continúa con tu experiencia. Encuentra respuestas, consejos, y más en la <a href="http://comunidad.wikia.com">Comunidad Central</a>.',
	'cnw-error-general' => '¡Algo salió mal en nuestro sistema! Por favor inténtalo de nuevo o [[Special:Contact|contáctanos]] para obtener ayuda.',
	'cnw-error-general-heading' => 'Lo sentimos',
	'cnw-badword-header' => '¡Oops!',
	'cnw-badword-msg' => 'Hola, por favor abstente de usar estas malas palabras o palabras prohibidas en la descripción de tu wiki: $1',
	'cnw-error-wiki-limit-header' => 'Has alcanzado el límite de wikis',
	'cnw-error-wiki-limit' => 'Hola, estás limitado a {{PLURAL:$1|$1 creación|$1 creaciones}} de wikis por día. Espera 24 horas antes de crear otro wiki.',
	'cnw-error-blocked-header' => 'Cuenta bloqueada',
	'cnw-error-blocked' => 'Tu usuario ha sido bloqueado por $1. El motivo proporcionado fue: $2. (Identificador del bloqueo para referencia: $3)',
	'cnw-error-anon-user-header' => 'Inicia sesión',
	'cnw-error-anon-user' => 'Se ha desactivado la creación de wikis por parte de anónimos. [[Special:UserLogin|Inicia sesión]] e inténtalo de nuevo.',
	'cnw-error-torblock' => 'No está permitido crear wikis a través de la red Tor.',
	'cnw-error-bot' => 'Hemos detectado que puedes ser un bot. Si hemos cometido un error, por favor contáctanos y describe que has sido detectado como si fueras un bot y te ayuderamos en crear tu wiki: [http://www.wikia.com/Special:Contact/general Contáctanos]',
	'cnw-error-bot-header' => 'Has sido detectado como un bot',
	'cnw-error-unconfirmed-email-header' => 'Tu correo electrónico no ha sido confirmado',
	'cnw-error-unconfirmed-email' => 'Tu correo electrónico debe ser confirmado para crear un Wiki.',
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
	'cnw-name-wiki-headline' => 'شروع یک ویکی', # Fuzzy
	'cnw-name-wiki-creative' => 'ویکیا از بهترین مکان‌ها برای ساخت وب‌گاهی است که می‌تواند رشد کند و موضوع مورد علاقه شما را گسترش دهد.', # Fuzzy
	'cnw-name-wiki-label' => 'نام ویکی شما', # Fuzzy
	'cnw-name-wiki-domain-label' => 'آدرس ویکی شما', # Fuzzy
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
	'cnw-desc-creative' => 'توصیف شما به دیگران کمک می‌کند تا بهتر ویکی شما را پیدا کنند', # Fuzzy
	'cnw-desc-tip1' => 'راهنمایی', # Fuzzy
	'cnw-desc-tip1-creative' => 'با یک یا دو جمله، از این فضا استفاده کنید تا دیگران بدانند از چه ویکی استفاده می‌کنند', # Fuzzy
	'cnw-desc-select-vertical' => 'یک دایرکتوری مادر انتخاب کنید', # Fuzzy
	'cnw-desc-select-categories' => 'دسته‌بندی دقیق‌تر', # Fuzzy
	'cnw-desc-select-one' => 'یکی را انتخاب کنید',
	'cnw-desc-change-lang' => 'تغییر',
	'cnw-desc-lang' => 'زبان',
	'cnw-theme-headline' => 'انتخاب قالب',
	'cnw-theme-creative' => 'از نمونه‌های زیر یک قالب را انتخاب کنید. شما این امکان را دارید تا پیش‌نمایشی از قالب انتخابی خود را مشاهده کنید.', # Fuzzy
	'cnw-theme-instruction' => 'شما همچنین می‌توانید قالب اختصاصی خود را بعدا با کمک "ابزارهای من" ایجاد کنید.', # Fuzzy
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
	'cnw-name-wiki-headline' => 'Perusta Wiki',
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
 * @author Gomoko
 * @author Jgaignerot
 * @author Od1n
 * @author Peter17
 * @author Verdy p
 * @author Windes
 * @author Wyz
 */
$messages['fr'] = array(
	'createnewwiki-desc' => 'Assistant de création de wiki',
	'cnw-next' => 'Suite',
	'cnw-back' => 'Retour',
	'cnw-or' => 'ou',
	'cnw-title' => 'Créer un nouveau wiki',
	'cnw-name-wiki-headline' => 'Commencer un wiki', # Fuzzy
	'cnw-name-wiki-creative' => 'Construire un site Web, monter une communauté, et embarquer sur une expérience ultime pour les fans.',
	'cnw-name-wiki-label' => 'Nommez votre wikia',
	'cnw-name-wiki-domain-label' => 'Donnez une adresse à votre wikia',
	'cnw-name-wiki-submit-error' => 'Désolé ! Vous devez remplir les deux champs ci-dessus pour continuer.',
	'cnw-login' => 'Se connecter',
	'cnw-signup' => 'Créer un compte',
	'cnw-signup-prompt' => 'Il faut un compte ?',
	'cnw-call-to-signup' => 'Inscrivez-vous ici',
	'cnw-login-prompt' => 'Vous avez déjà un compte ?',
	'cnw-call-to-login' => 'Connectez-vous ici',
	'cnw-auth-headline' => 'Se connecter',
	'cnw-auth-headline2' => 'S’inscrire',
	'cnw-auth-creative' => 'Connectez-vous à votre compte pour continuer à construire votre wiki.',
	'cnw-auth-signup-creative' => 'Vous aurez besoin d’un compte pour continuer à construire votre wiki.<br />Cela ne prendre qu’une minute pour vous inscrire !',
	'cnw-auth-facebook-signup' => 'S’identifier avec Facebook',
	'cnw-auth-facebook-login' => 'Se connecter avec Facebook',
	'cnw-userauth-headline' => 'Avez-vous un compte?',
	'cnw-userauth-creative' => 'Connexion',
	'cnw-userauth-marketing-heading' => 'Vous n’avez pas encore de compte ?',
	'cnw-userauth-marketing-body' => "Vous avez besoin d'un compte pour créer un wiki sur Wikia. Il suffit d’une minute pour s’inscrire !",
	'cnw-userauth-signup-button' => "S'inscrire",
	'cnw-desc-headline' => 'De quoi parle votre wikia ?',
	'cnw-desc-creative' => 'Aider les gens à trouver votre wikia à l’aide d’une superbe description.',
	'cnw-desc-placeholder' => 'Faites ça bien ! Votre texte apparaîtra sur la page d’accueil de votre wikia.',
	'cnw-desc-tip1' => 'Voici une astuce !',
	'cnw-desc-tip1-creative' => 'Utilisez cet espace pour indiquer aux gens pourquoi ce wikia est important et la raison pour laquelle vous l’avez créé.',
	'cnw-desc-tip2' => 'PS',
	'cnw-desc-tip2-creative' => 'Encourager les autres à rejoindre votre communauté en donnant des détails sur votre wikia.',
	'cnw-desc-select-vertical' => 'Sélectionnez un thème',
	'cnw-desc-select-categories' => 'Sélectionnez des catégories supplémentaires',
	'cnw-desc-select-one' => 'Sélectionnez-en une',
	'cnw-desc-all-ages' => 'Ce wikia est-il destiné aux enfants ?',
	'cnw-desc-tip-all-ages' => 'Est-ce un sujet qui pourrait intéresser les enfants ? Afin de nous aider à respecter les lois des États-Unis, nous gardons la trace des wikias sur des sujets qui s’adressent directement à des enfants de 12 ans et moins.',
	'cnw-desc-default-lang' => 'Votre wikia sera en $1',
	'cnw-desc-change-lang' => 'modifier',
	'cnw-desc-lang' => 'Langue',
	'cnw-desc-wiki-submit-error' => 'Veuillez choisir une catégorie',
	'cnw-theme-headline' => 'Choisissez un thème',
	'cnw-theme-creative' => 'Faites bonne impression ! Choisissez un thème pour en voir un aperçu.',
	'cnw-theme-instruction' => 'Vous voulez le personnaliser ? Vous pourrez concevoir votre propre thème plus tard en allant sur le Concepteur de thèmes via votre Tableau de bord d’administration.',
	'cnw-welcome-headline' => 'Félicitations ! Vous avez bien créé $1',
	'cnw-welcome-instruction1' => 'Cliquez sur le bouton ci-dessous pour commencer à ajouter des pages à votre wikia.',
	'cnw-welcome-help' => 'Poursuivez votre expérience de fan. Trouvez des réponses, des conseils et plus sur le <a href="http://community.wikia.com">Centre de la communauté</a>.',
	'cnw-error-general' => 'Oups, quelque chose s’est mal passé de notre côté ! Veuillez réessayer plus tard ou [[Special:Contact|nous contacter]] pour obtenir de l’aide.',
	'cnw-error-general-heading' => 'Toutes nos excuses',
	'cnw-badword-header' => 'Eh Oh',
	'cnw-badword-msg' => 'Bonjour, veuillez éviter d’utiliser des mots grossiers ou interdits dans la description de votre wiki : $1',
	'cnw-error-wiki-limit-header' => 'Limite de wikis atteinte',
	'cnw-error-wiki-limit' => 'Bonjour, vous êtes limité à la création de {{PLURAL:$1|$1 wiki|$1 wikis}} par jour. Attendez 24 heures avant de créer un autre wiki.',
	'cnw-error-blocked-header' => 'Compte bloqué',
	'cnw-error-blocked' => 'Vous avez été bloqué par $1. La raison invoquée était : $2. (ID de blocage pour référence : $3)',
	'cnw-error-anon-user-header' => 'Veuillez vous connecter',
	'cnw-error-anon-user' => 'Créer des wikis est désactivés pour les utilisateurs anonymes. Veuillez [[Special:UserLogin|vous connecter]] et réessayer.',
	'cnw-error-torblock' => "Créer des wikis via le réseau Tor n'est pas autorisé.",
	'cnw-error-bot' => 'Nous avons détecté que vous pouvez être un robot. Si nous nous sommes trompés, veuillez nous contacter en indiquant que vous avez été pris à tort pour un robot, nous vous aiderons alors à créer votre wiki : [http://www.wikia.com/Special:Contact/general Nous contacter].',
	'cnw-error-bot-header' => 'Vous avez été détecté comme étant un robot',
	'cnw-error-unconfirmed-email-header' => "Votre adresse de courriel n'a pas été confirmée",
	'cnw-error-unconfirmed-email' => 'Votre adresse de courriel doit être confirmée pour créer un wiki.',
);

/** Western Frisian (Frysk)
 * @author Robin0van0der0vliet
 */
$messages['fy'] = array(
	'cnw-next' => 'Folgjende',
	'cnw-back' => 'Foarige',
	'cnw-or' => 'of',
	'cnw-login' => 'Oanmelde',
	'cnw-desc-tip2' => 'Psst', # Fuzzy
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
	'cnw-desc-headline' => 'De que vai o seu wiki?', # Fuzzy
	'cnw-desc-creative' => 'Describa o seu tema', # Fuzzy
	'cnw-desc-placeholder' => 'Isto aparecerá na páxina principal do seu wiki.',
	'cnw-desc-tip1' => 'Suxestión',
	'cnw-desc-tip1-creative' => 'Use este espazo para contar á xente de que vai o wiki nunha ou dúas oracións', # Fuzzy
	'cnw-desc-tip2' => 'Consello',
	'cnw-desc-tip2-creative' => 'Dea aos visitantes algúns detalles específicos sobre o tema',
	'cnw-desc-select-vertical' => 'Seleccione unha categoría Hub',
	'cnw-desc-select-one' => 'Seleccione unha',
	'cnw-desc-all-ages' => 'Todas as idades', # Fuzzy
	'cnw-desc-tip-all-ages' => 'Este wiki trata un tema de interese para os nenos? Para axudarnos a cumprir coa lei dos EUA, levamos un seguimento dos wikis sobre temas dirixidos directamente a cativos de 12 anos ou menos.', # Fuzzy
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
	'cnw-name-wiki-headline' => 'להתחיל ויקי', # Fuzzy
	'cnw-name-wiki-creative' => 'ויקיה – המקום הטוב ביותר לבנות אתר ולטפל קהילה סביב דברים שאתם אוהבים.', # Fuzzy
	'cnw-name-wiki-label' => 'שם הוויקי', # Fuzzy
	'cnw-name-wiki-domain-label' => 'כתובת הוויקי', # Fuzzy
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
	'cnw-desc-creative' => 'התיאור שלכם יסייע לאנשים למצוא את הוויקיה', # Fuzzy
	'cnw-desc-placeholder' => 'זה יופיע בדף הראשי של הוויקי שלכם.', # Fuzzy
	'cnw-desc-tip1' => 'עצה', # Fuzzy
	'cnw-desc-tip1-creative' => 'השתמשו בשדה זה כדי לספר לאנשים על הוויקיה שלכם במשפט אחד או שניים', # Fuzzy
	'cnw-desc-tip2' => 'אהם־אהם', # Fuzzy
	'cnw-desc-tip2-creative' => 'תנו למבקרים שלכם כמה פרטים על הנושא שלכם', # Fuzzy
	'cnw-desc-select-vertical' => 'בחירת קטגוריה', # Fuzzy
	'cnw-desc-select-categories' => 'בחירת קטגוריות נוספות', # Fuzzy
	'cnw-desc-select-one' => 'לבחור אחת',
	'cnw-desc-all-ages' => 'האם המיזם מיועד לילדים?',
	'cnw-desc-tip-all-ages' => 'האם עוסק המיזם בנושא המעניין ילדים? בהתאם לחוק בארה"ב, אנו עוקבים אחרי מיזמי ויקיה על נושאים הפונים באופן ישיר לילדים בני 12 ומטה.',
	'cnw-desc-default-lang' => 'הוויקי שלכם יהיה ב$1', # Fuzzy
	'cnw-desc-change-lang' => 'לשנות',
	'cnw-desc-lang' => 'שפה',
	'cnw-desc-wiki-submit-error' => 'נא לבחור קטגוריה',
	'cnw-theme-headline' => 'נא לבחור ערכת עיצוב',
	'cnw-theme-creative' => 'נא לבחור באחת מערכות העיצוב להלן. אפשר יהיה לראות תצוגה מקדימה של כל ערכה תוך כדי הבחירה.', # Fuzzy
	'cnw-theme-instruction' => 'אפשר גם לעצב ערכת עיצוב משלכם דרך "הכלים שלי".', # Fuzzy
	'cnw-welcome-headline' => 'ברכות! הוויקי $1 נוצר', # Fuzzy
	'cnw-welcome-instruction1' => 'לחצו על הכפתור להלן כדי להתחיל להוסיף דפים לוויקי שלכם.', # Fuzzy
	'cnw-welcome-help' => 'מצאו תשובות, עצות ועוד ב־<a href="http://community.wikia.com">Community Central</a>.', # Fuzzy
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
	'cnw-name-wiki-headline' => 'Wiki indítása', # Fuzzy
	'cnw-name-wiki-creative' => 'Wikia a legjobb hely, ha kedvenc témádnak egy új weboldalt akarsz készíteni, és közösséget építeni hozzá.', # Fuzzy
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
	'cnw-desc-creative' => 'Írd körül a témát', # Fuzzy
	'cnw-desc-placeholder' => 'Ez a wiki kezdőlapján fog megjelenni.', # Fuzzy
	'cnw-desc-tip1' => 'Itt egy tipp!',
	'cnw-desc-tip1-creative' => 'Itt egy-két mondatban mesélj az wikiádról az idelátogató embereknek', # Fuzzy
	'cnw-desc-tip2' => 'Pszt', # Fuzzy
	'cnw-desc-tip2-creative' => 'Közölj a látogatókkal valami egyedi részletet a témádról', # Fuzzy
	'cnw-desc-select-one' => 'Válassz egyet',
	'cnw-desc-default-lang' => 'A wikid a $1 kategóriába lesz', # Fuzzy
	'cnw-desc-change-lang' => 'módosítás',
	'cnw-desc-lang' => 'Nyelv',
	'cnw-desc-wiki-submit-error' => 'Válassz egy kategóriát',
	'cnw-theme-headline' => 'Válassz egy témát',
	'cnw-theme-creative' => 'Válassz az alábbi témák közöl. Ha kiválasztasz egy témát, akkor annak látható lesz az előnézeti képe.', # Fuzzy
	'cnw-theme-instruction' => 'Saját stílusodat később is megtervezheted a "My Tools" eszköztáron keresztül.', # Fuzzy
	'cnw-welcome-headline' => 'Gratulálunk!A(z) $1 létrehozása sikerült.', # Fuzzy
	'cnw-welcome-instruction1' => 'Kattints a lenti gombra, hogy elkezdd a lapok hozzáadását a wikidhez.', # Fuzzy
	'cnw-welcome-help' => 'Keress válaszokat, tanácsot és sok mást a <a href="http://community.wikia.com">Community Central</a> wikin.', # Fuzzy
	'cnw-error-general' => 'Valami hiba történt a wikid létrehozása közben. Kérlek, próbáld újra később.', # Fuzzy
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
	'cnw-userauth-marketing-body' => 'Un conto es necessari pro crear un wiki in Wikia. Il prende solmente un minuta crear un conto!', # Fuzzy
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
	'cnw-error-general' => 'Qualcosa errava durante le creation de tu wiki. Per favor reproba plus tarde.', # Fuzzy
	'cnw-error-general-heading' => 'Error de creation de nove wiki', # Fuzzy
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
	'cnw-name-wiki-headline' => 'Memulai sebuah Wiki', # Fuzzy
	'cnw-name-wiki-creative' => 'Wikia adalah tempat terbaik untuk membangun sebuah situs web dan komunitas yang Anda suka.', # Fuzzy
	'cnw-name-wiki-label' => 'Nama wiki Anda', # Fuzzy
	'cnw-name-wiki-domain-label' => 'Berikan alamat ke wiki Anda', # Fuzzy
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
	'cnw-desc-creative' => 'Deskripsi Anda akan membantu orang menemukan wikia Anda', # Fuzzy
	'cnw-desc-placeholder' => 'Ini akan muncul pada halaman utama Anda wiki.', # Fuzzy
	'cnw-desc-tip1' => 'Petunjuk', # Fuzzy
	'cnw-desc-tip1-creative' => 'Gunakan ruang ini untuk memberitahu orang-orang tentang wikia Anda dalam satu atau dua kalimat', # Fuzzy
	'cnw-desc-tip2' => 'Psst', # Fuzzy
	'cnw-desc-tip2-creative' => 'Memberi pengunjung Anda beberapa rincian spesifik tentang subjek Anda', # Fuzzy
	'cnw-desc-select-vertical' => 'Pilih Pusat Kategori', # Fuzzy
	'cnw-desc-select-categories' => 'Pilih Kategori Tambahan', # Fuzzy
	'cnw-desc-select-one' => 'Pilih salah satu',
	'cnw-desc-all-ages' => 'Apakah wikia ini ditujukan untuk anak-anak?',
	'cnw-desc-tip-all-ages' => 'Apakah wiki ini berisi tentang topik yang menarik bagi anak-anak? Untuk membantu kami mematuhi undang-undang AS kami melacak wiki-wiki tentang topik yang secara langsung menarik kepada anak-anak 12 tahun ke bawah.',
	'cnw-desc-default-lang' => 'Wiki Anda akan berada di $1', # Fuzzy
	'cnw-desc-change-lang' => 'ubah',
	'cnw-desc-lang' => 'Bahasa',
	'cnw-desc-wiki-submit-error' => 'Silakan pilih kategori',
	'cnw-theme-headline' => 'Pilih tema',
	'cnw-theme-creative' => 'Pilih tema di bawah ini, Anda akan dapat melihat pratayang dari setiap tema yang Anda pilih.', # Fuzzy
	'cnw-theme-instruction' => 'Anda juga dapat merancang tema Anda sendiri kemudian dengan pergi ke "Peralatanku".', # Fuzzy
	'cnw-welcome-headline' => 'Selamat! $1 telah dibuat', # Fuzzy
	'cnw-welcome-instruction1' => 'Klik tombol di bawah untuk memulai menambahkan halaman ke wiki Anda.', # Fuzzy
	'cnw-welcome-help' => 'Temukan jawaban, saran, dan masih banyak lagi pada <a href="http://community.wikia.com">Community Central</a>.', # Fuzzy
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
	'createnewwiki-desc' => 'Procedura guidata per la creazione di una wiki',
	'cnw-next' => 'Avanti',
	'cnw-back' => 'Indietro',
	'cnw-or' => 'o',
	'cnw-title' => 'Crea una nuova wiki',
	'cnw-name-wiki-headline' => 'Crea una wiki',
	'cnw-name-wiki-creative' => 'Wikia è il posto migliore per costruire un sito web e far crescere una community intorno a ciò che ti piace.',
	'cnw-name-wiki-label' => 'Dai un nome alla tua wiki',
	'cnw-name-wiki-domain-label' => 'Dai un indirizzo alla tua wiki',
	'cnw-name-wiki-submit-error' => 'Ops! Devi riempire entrambi i campi qui sopra per continuare.',
	'cnw-login' => 'Login',
	'cnw-signup' => 'Crea un account',
	'cnw-signup-prompt' => 'Ti serve un account?',
	'cnw-call-to-signup' => 'Registrati qui',
	'cnw-login-prompt' => 'Hai già un account?',
	'cnw-call-to-login' => 'Effettua qui il login',
	'cnw-auth-headline' => 'Login',
	'cnw-auth-headline2' => 'Registrati',
	'cnw-auth-creative' => 'Effettua il login per continuare a costruire la tua wiki.',
	'cnw-auth-signup-creative' => 'È necessario avere un account per continuare a costruire la tua wiki. <br />Ci vuole solo un minuto per registrarsi!',
	'cnw-auth-facebook-signup' => 'Registrati con Facebook',
	'cnw-auth-facebook-login' => 'Effettua il login con Facebook',
	'cnw-userauth-headline' => 'Hai un account?',
	'cnw-userauth-creative' => 'Entra',
	'cnw-userauth-marketing-heading' => 'Non hai un account?',
	'cnw-userauth-marketing-body' => 'È necessario avere un account per continuare a costruire la tua wiki. <br />Ci vuole solo un minuto per registrarsi!',
	'cnw-userauth-signup-button' => 'Registrati',
	'cnw-desc-headline' => "Qual è l'argomento della tua wiki?", # Fuzzy
	'cnw-desc-creative' => 'Descrivi il tuo argomento', # Fuzzy
	'cnw-desc-placeholder' => 'Questo testo apparirà nella pagina principale della tua wiki.',
	'cnw-desc-tip1' => 'Suggerimento',
	'cnw-desc-tip1-creative' => 'Utilizza questo spazio per descrivere alle persone la tua wiki con poche parole', # Fuzzy
	'cnw-desc-tip2' => 'Psst',
	'cnw-desc-tip2-creative' => 'Fornisci ai visitatori alcuni dettagli specifici sul tuo argomento',
	'cnw-desc-select-one' => 'Seleziona',
	'cnw-desc-default-lang' => 'La tua wiki sarà in $1',
	'cnw-desc-change-lang' => 'cambia',
	'cnw-desc-lang' => 'Lingua',
	'cnw-desc-wiki-submit-error' => 'Per favore scegli una categoria',
	'cnw-theme-headline' => 'Scegli un tema',
	'cnw-theme-creative' => "Scegli uno dei temi qui sotto. Puoi vedere l'anteprima di ogni tema quando lo selezioni.",
	'cnw-theme-instruction' => 'Puoi anche creare il tuo tema personalizzato più avanti tramite "I miei strumenti".',
	'cnw-welcome-headline' => 'Complimenti! $1 è stata creata',
	'cnw-welcome-instruction1' => 'Clicca il pulsante sottostante per iniziare a creare pagine nella tua wiki.',
	'cnw-welcome-help' => 'Puoi trovare risposte, consigli e altro nella <a href="http://it.community.wikia.com/wiki/Wiki_della_Community">Wiki della Community</a>.',
	'cnw-error-general' => 'Qualcosa è andato storto durante la creazione della tua wiki. Si prega di riprovare più tardi.', # Fuzzy
	'cnw-error-general-heading' => 'Errore nella creazione di una nuova wiki',
	'cnw-badword-header' => 'Hey!',
	'cnw-badword-msg' => 'Ciao, per favore non utilizzare parole non consone o proibite nella descrizione della tua wiki: $1',
	'cnw-error-wiki-limit-header' => 'Raggiunto il limite di wiki',
	'cnw-error-wiki-limit' => "Ciao, puoi creare un massimo di {{PLURAL:$1|$1 wiki|$1 wiki}} al giorno. Attendi 24 ore prima di creare un'altra wiki.",
	'cnw-error-blocked-header' => 'Account bloccato',
	'cnw-error-blocked' => 'Sei stato bloccato da $1. La motivazione è la seguente: $2. (ID di riferimento del blocco: $3)',
	'cnw-error-anon-user-header' => 'Sei pregato di connetterti',
	'cnw-error-torblock' => 'Non è permesso creare wiki tramite la rete Tor.',
	'cnw-error-bot' => 'Ti abbiamo indentificato come un probabile bot. Se si tratta di un errore, per favore contattaci dicendoci che sei stato erroneamente rilevato come bot e ti aiuteremo a creare la tua wiki: [http://www.wikia.com/Special:Contact/general Contattaci]',
	'cnw-error-bot-header' => 'Sei stato identificato come un bot',
	'cnw-error-unconfirmed-email-header' => 'Il tuo indirizzo e-mail non è stato confermato',
	'cnw-error-unconfirmed-email' => 'Il tuo indirizzo e-mail deve essere confermato per creare un Wiki.',
);

/** Japanese (日本語)
 * @author Barrel0116
 * @author BryghtShadow
 * @author Shirayuki
 * @author Tommy6
 * @author Wrightbus
 */
$messages['ja'] = array(
	'createnewwiki-desc' => 'ウィキ作成ウィザード',
	'cnw-next' => '次へ',
	'cnw-back' => '戻る',
	'cnw-or' => 'または',
	'cnw-title' => '新しいウィキを作成',
	'cnw-name-wiki-headline' => 'ウィキを作成する',
	'cnw-name-wiki-creative' => 'ウィキアは、あなたが好きなものに関するウェブサイトやコミュニティを構築するのに最適の場所です。',
	'cnw-name-wiki-label' => 'ウィキの名称を入力してください',
	'cnw-name-wiki-domain-label' => 'ウィキのアドレスを入力してください',
	'cnw-name-wiki-submit-error' => '上の入力欄2つとも記入する必要があります。',
	'cnw-login' => 'ログイン',
	'cnw-signup' => 'アカウント作成',
	'cnw-signup-prompt' => 'アカウントが必要ですか？',
	'cnw-call-to-signup' => 'こちらでアカウントを登録してください',
	'cnw-login-prompt' => '既にアカウントをお持ちですか？',
	'cnw-call-to-login' => 'こちらでログインしてください',
	'cnw-auth-headline' => 'ログインする',
	'cnw-auth-headline2' => 'アカウントを作成する',
	'cnw-auth-creative' => '続けるにはログインする必要があります。',
	'cnw-auth-signup-creative' => '続けるにはアカウントを作成する必要があります。<br />アカウントの作成は数分で完了します。',
	'cnw-auth-facebook-signup' => 'Facebook を利用してアカウントを登録',
	'cnw-auth-facebook-login' => 'Facebook を利用してログイン',
	'cnw-userauth-headline' => 'アカウントをお持ちですか？',
	'cnw-userauth-creative' => 'ログイン',
	'cnw-userauth-marketing-heading' => '登録がまだの場合',
	'cnw-userauth-signup-button' => '利用者登録',
	'cnw-desc-headline' => 'どんなウィキを作成しますか？', # Fuzzy
	'cnw-desc-creative' => 'このウィキでどんな話題を扱うのかを記入してください', # Fuzzy
	'cnw-desc-placeholder' => 'ここに入力した内容がメインページに表示されます。',
	'cnw-desc-tip1' => 'ヒント',
	'cnw-desc-tip1-creative' => 'この領域を利用し、訪問者に対してこのウィキがどのようなウィキであるかを1・2文で伝えましょう。', # Fuzzy
	'cnw-desc-tip2' => 'ちょっとした補足',
	'cnw-desc-tip2-creative' => 'このウィキが扱う話題について、具体的な内容をいくつか挙げましょう。',
	'cnw-desc-select-one' => '1つを選択',
	'cnw-desc-all-ages' => 'すべての年齢', # Fuzzy
	'cnw-desc-default-lang' => 'ウィキの言語設定は $1 になっています',
	'cnw-desc-change-lang' => '変更する',
	'cnw-desc-lang' => '言語',
	'cnw-desc-wiki-submit-error' => 'カテゴリを選択してください',
	'cnw-theme-headline' => 'テーマを選択',
	'cnw-theme-creative' => '下の一覧からテーマを選んでください。それぞれのテーマをクリックすると、選択したテーマのプレビューを確認できます。',
	'cnw-theme-instruction' => '後で「マイツール」から独自のテーマをデザインすることもできます。',
	'cnw-welcome-headline' => 'おめでとうございます！ $1 が作成されました',
	'cnw-welcome-instruction1' => '下のボタンをクリックすると、新しいページを作成できます。',
	'cnw-welcome-help' => '助言を求めたいとき、質問したい時などは <a href="http://ja.wikia.com/">Community Central 日本語版</a> までお越しください。',
	'cnw-error-general' => 'ウィキの作成中に問題が発生しました。時間をおいてもう一度お試しください。または、私たちに[[Special:Contact|ご連絡]]ください。',
	'cnw-error-general-heading' => 'ウィキ作成エラー', # Fuzzy
	'cnw-error-blocked-header' => 'ブロックされたアカウント',
	'cnw-error-anon-user-header' => 'ログインしてください',
	'cnw-error-bot-header' => 'あなたがボットとして検出されています',
	'cnw-error-unconfirmed-email' => 'Wikiを作成するには、あなたのEメールを確認する必要があります。',
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
	'cnw-error-general' => 'មានបញ្ហាពេលបង្កើតវិគីរបស់អ្នក។ សូមព្យាយាមម្ដងទៀតនៅពេលក្រោយ។', # Fuzzy
	'cnw-error-general-heading' => 'បញ្ហាក្នុងការបង្កើតវិគីថ្មី', # Fuzzy
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
	'cnw-name-wiki-creative' => '위키아는 당신이 사랑하는 것의 웹사이트를 세우고 공동체를 자라게 하는 데 최적의 장소입니다.', # Fuzzy
	'cnw-name-wiki-label' => '위키 이름을 입력하세요', # Fuzzy
	'cnw-name-wiki-domain-label' => '위키 주소를 입력하세요', # Fuzzy
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
	'cnw-desc-creative' => '다른 사람들이 쉽게 위키아를 찾을 수 있도록 설명을 써주세요', # Fuzzy
	'cnw-desc-placeholder' => '이것은 위키의 대문에 나타납니다.', # Fuzzy
	'cnw-desc-tip1' => '힌트', # Fuzzy
	'cnw-desc-tip1-creative' => '간단한 문장으로 위키아를 다른 사람들에게 소개해보세요', # Fuzzy
	'cnw-desc-tip2' => '잠깐', # Fuzzy
	'cnw-desc-tip2-creative' => '방문자에게 주제에 대해 몇 가지 구체적인 내용을 주세요', # Fuzzy
	'cnw-desc-select-vertical' => '허브 분류 선택', # Fuzzy
	'cnw-desc-select-categories' => '추가 분류 선택', # Fuzzy
	'cnw-desc-select-one' => '하나 선택',
	'cnw-desc-all-ages' => '어린이들이 볼 수 있는 위키인가요?',
	'cnw-desc-tip-all-ages' => '어린이들이 관심을 가질만한 내용인가요? 12세 이하의 어린이들이 관심을 가질 만한 내용이라면 저희는 해당 위키아를 주시할 것입니다.',
	'cnw-desc-default-lang' => '위키 언어는 $1입니다', # Fuzzy
	'cnw-desc-change-lang' => '바꾸기',
	'cnw-desc-lang' => '언어',
	'cnw-desc-wiki-submit-error' => '분류를 선택하세요',
	'cnw-theme-headline' => '테마 선택',
	'cnw-theme-creative' => '아래 테마를 선택하면, 선택한 각 테마의 미리 보기를 볼 수 있습니다.', # Fuzzy
	'cnw-theme-instruction' => '"내 도구"로 하고 나서 자신의 테마를 디자인할 수도 있습니다.', # Fuzzy
	'cnw-welcome-headline' => '축하합니다! $1(을)를 만들었습니다', # Fuzzy
	'cnw-welcome-instruction1' => '위키에 문서를 추가하기 시작하려면 아래 버튼을 클릭하세요.', # Fuzzy
	'cnw-welcome-help' => '<a href="http://community.wikia.com">위키아 중앙 커뮤니티</a>에서 도움을 구해보세요.', # Fuzzy
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

/** لوری (لوری)
 * @author Hosseinblue
 * @author Mogoeilor
 */
$messages['lrc'] = array(
	'cnw-next' => 'نها',
	'cnw-back' => 'وا دما',
	'cnw-or' => 'يا',
	'cnw-title' => 'يه گل ويكی تازه راس بكيت',
	'cnw-name-wiki-headline' => 'یه گل ویکی نه شرو بکید',
	'cnw-name-wiki-label' => 'نوم ویکی تو', # Fuzzy
	'cnw-name-wiki-domain-label' => 'سی ویکی تو تیرنشو راس بکیت', # Fuzzy
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
	'cnw-desc-tip2' => 'پی اس اس تی', # Fuzzy
	'cnw-desc-select-one' => 'یه گل نه انتخاو بکید',
	'cnw-desc-all-ages' => 'همه بلگيا', # Fuzzy
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
	'cnw-error-general' => 'Noe gikk galt under opprettning av wikien din. Vennligst prøv igjen, eller [[Special:Contact|kontakt oss]] for hjelp.', # Fuzzy
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
	'cnw-desc-all-ages' => 'सबै उमेरहरू', # Fuzzy
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
	'cnw-name-wiki-headline' => 'Begin een wiki op Wikia.',
	'cnw-name-wiki-creative' => 'Wikia is de beste plaats om een website te bouwen en een gemeenschap te laten groeien om het onderwerp dat u aan het hart gaat.', # Fuzzy
	'cnw-name-wiki-label' => 'Geef uw wiki een naam', # Fuzzy
	'cnw-name-wiki-domain-label' => 'Geef uw wiki een adres', # Fuzzy
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
	'cnw-desc-creative' => 'Uw beschrijving helpt bij het zoeken naar uw wikia', # Fuzzy
	'cnw-desc-placeholder' => 'Dit wordt weergegeven op de hoofdpagina van uw wiki.', # Fuzzy
	'cnw-desc-tip1' => 'Tip', # Fuzzy
	'cnw-desc-tip1-creative' => 'Gebruik deze ruimte om mensen over uw Wikia te vertellen in een paar zinnen', # Fuzzy
	'cnw-desc-tip2' => 'Pst!', # Fuzzy
	'cnw-desc-tip2-creative' => 'Geef uw bezoeker wat details over uw onderwerp', # Fuzzy
	'cnw-desc-select-vertical' => 'Selecteer een Hubcategorie', # Fuzzy
	'cnw-desc-select-categories' => 'Selecteer extra categorieën', # Fuzzy
	'cnw-desc-select-one' => 'Maak een keuze',
	'cnw-desc-all-ages' => 'Is deze wikia bedoeld voor kinderen?',
	'cnw-desc-tip-all-ages' => "Gaat dit over een onderwerp waar kinderen interesse in hebben? Om ons aan de Amerikaanse wetgeving te houden, houden we bij welke wikia's over onderwerpen gaan waar kinderen van 12 jaar en jonger interesse in hebben.",
	'cnw-desc-default-lang' => 'De hoofdtaal van uw wiki is: $1', # Fuzzy
	'cnw-desc-change-lang' => 'wijzigen',
	'cnw-desc-lang' => 'Taal',
	'cnw-desc-wiki-submit-error' => 'Kies een categorie',
	'cnw-theme-headline' => 'Ontwerp uw wiki',
	'cnw-theme-creative' => 'Kies hieronder een vormgeving. Als u een vormgeving selecteert, wordt een voorvertoning weergegeven.', # Fuzzy
	'cnw-theme-instruction' => 'U kunt uw thema of ontwerp altijd later aanpassen via "Mijn hulpmiddelen".', # Fuzzy
	'cnw-welcome-headline' => 'Gefeliciteerd. U hebt de wiki $1 aangemaakt', # Fuzzy
	'cnw-welcome-instruction1' => "Klik op de onderstaande knop om pagina's aan uw wiki toe te voegen.", # Fuzzy
	'cnw-welcome-help' => 'Antwoorden, advies en meer op <a href="http://community.wikia.com">Community Central</a>.', # Fuzzy
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

	'cnw-error-general' => 'Er is iets misgegaan tijdens het aanmaken van je wiki. Probeer het later opnieuw.', # Fuzzy
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

/** Pälzisch (Pälzisch)
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
	'createnewwiki-desc' => 'Kreator tworzenia wiki',
	'cnw-next' => 'Dalej',
	'cnw-back' => 'Wstecz',
	'cnw-or' => 'lub',
	'cnw-title' => 'Utwórz nową Wiki',
	'cnw-name-wiki-headline' => 'Utwórz wiki',
	'cnw-name-wiki-creative' => 'Wikia to najlepsze miejsce do budowania własnej wiki i tworzenia społeczności wokół tego co kochasz.',
	'cnw-name-wiki-label' => 'Nazwij swoją wiki',
	'cnw-name-wiki-domain-label' => 'Nadaj adres swojej wiki',
	'cnw-name-wiki-submit-error' => 'Opps! Musisz wypełnić oba pola aby przejść dalej',
	'cnw-login' => 'Zaloguj się',
	'cnw-signup' => 'Utwórz konto',
	'cnw-signup-prompt' => 'Założyć konto?',
	'cnw-call-to-signup' => 'Zarejestruj się',
	'cnw-login-prompt' => 'Posiadasz już konto?',
	'cnw-call-to-login' => 'Zaloguj się',
	'cnw-auth-headline' => 'Zaloguj się',
	'cnw-auth-headline2' => 'Zarejestruj się',
	'cnw-auth-creative' => 'Zaloguj się aby kontynuować tworzenie swojej wiki',
	'cnw-auth-signup-creative' => 'Potrzebujesz konta aby kontynuować.<br />Zajmie to tylko kilka chwil!',
	'cnw-auth-facebook-signup' => 'Zarejestruj się poprzez Facebooka',
	'cnw-auth-facebook-login' => 'Zaloguj się poprzez Facebooka',
	'cnw-userauth-headline' => 'Posiadasz konto?',
	'cnw-userauth-creative' => 'Zaloguj się',
	'cnw-userauth-marketing-heading' => 'Nie masz konta?',
	'cnw-userauth-marketing-body' => 'Posiadanie konta jest wymagane do utworzenia wiki. Rejestracja zajmuje tylko minutę!',
	'cnw-userauth-signup-button' => 'Zarejestruj się',
	'cnw-desc-headline' => 'O czym traktuje twoja wiki?',
	'cnw-desc-creative' => 'Opis pomoże znaleźć ludziom twoją wiki.',
	'cnw-desc-placeholder' => 'To pojawi się na stronie głównej Twojej wiki',
	'cnw-desc-tip1' => 'Wskazówka 1',
	'cnw-desc-tip1-creative' => 'Użyć tego miejsca, aby opowiedzieć innym o swojej wiki.',
	'cnw-desc-tip2' => 'Wskazówka 2',
	'cnw-desc-tip2-creative' => 'Podziel się z innymi szczegółami o Twojej wiki',
	'cnw-desc-select-vertical' => 'Wybierz kategorię Huba',
	'cnw-desc-select-categories' => 'Wybierz dodatkowe kategorie',
	'cnw-desc-select-one' => 'Wybierz',
	'cnw-desc-all-ages' => 'Czy ta wikia przeznaczona jest dla dzieci?',
	'cnw-desc-tip-all-ages' => 'Czy to jest wiki o tematyce, którą dzieci będą zainteresowane? W celu zgodności z prawem Stanów Zjednoczonych obserwujemy wiki o tematyce kierowanej bezpośrednio do dzieci w wieku 12 lat i poniżej.',
	'cnw-desc-default-lang' => 'Twoja wiki będzie w języku: $1',
	'cnw-desc-change-lang' => 'zmień',
	'cnw-desc-lang' => 'Język',
	'cnw-desc-wiki-submit-error' => 'Proszę wybrać kategorię',
	'cnw-theme-headline' => 'Wybierz motyw',
	'cnw-theme-creative' => 'Wybierz jeden z poniższych motywów aby zobaczyć podgląd i zdecydować o wyborze.',
	'cnw-theme-instruction' => 'Możesz także zaprojektować motyw później, korzystając z menu "Moje narzędzia".',
	'cnw-welcome-headline' => 'Gratulacje! $1 została utworzona',
	'cnw-welcome-instruction1' => 'Kliknij na poniższy przycisk aby zacząć dodawanie stron do Twojej wiki',
	'cnw-welcome-help' => 'Znajdź odpowiedzi, porady i więcej w <a href="http://spolecznosc.wikia.com">Centrum Społeczności</a>.',
	'cnw-error-general' => 'Ups, coś poszło nie tak po naszej stronie! Spróbuj ponownie, lub [[Special:Contact|napisz do nas]].',
	'cnw-error-general-heading' => 'Przepraszamy',
	'cnw-badword-header' => 'Uwaga',
	'cnw-badword-msg' => 'Witaj, proszę nie używaj tych niedozwolonych słów w opisie wiki: $1',
	'cnw-error-wiki-limit-header' => 'Osiągnięto limit wiki',
	'cnw-error-wiki-limit' => 'Możesz utworzyć tylko {{PLURAL:$1|$1}} wiki dziennie. Zaczekaj 24 godziny aby utworzyć inną wiki.',
	'cnw-error-blocked-header' => 'Konto zablokowane',
	'cnw-error-blocked' => 'Użytkownik został zablokowany przez  $1. Jako przyczynę podano:  $2. (ID blokady:  $3 )',
	'cnw-error-anon-user-header' => 'Zaloguj się',
	'cnw-error-anon-user' => 'Utworzyć wiki mogą jedynie zarejestrowani użytkownicy. [[Special:UserLogin|Zaloguj się]] i spróbuj ponownie.',
	'cnw-error-torblock' => 'Tworzenie wiki za pośrednictwem Tor Network nie jest dozwolone.',
	'cnw-error-bot' => 'Wykryto, że to konto może być botem. Jeżeli popełniono błąd, proszę daj nam znać: [http://www.wikia.com/Special:Contact/general Kontakt]',
	'cnw-error-bot-header' => 'Zostałeś zidentyfikowany jako bot',
	'cnw-error-unconfirmed-email-header' => 'Twój e-mail nie został potwierdzony',
	'cnw-error-unconfirmed-email' => 'Twój e-mail musi być potwierdzony, aby stworzyć wiki.',
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
	'cnw-userauth-marketing-body' => "It l'has dabzògn d'un cont për creé na wiki dzor Wikia. A-i và mach na minuta për registrete!", # Fuzzy
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
	'cnw-error-general' => "Contacc, quaicòs a l'é andàit mal da nòstra part. Për piasì, ch'a preuva torna pi tard, o <a href=\"/Special:Contact\">ch'a contata</a> për dl'agiut.", # Fuzzy
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
	'cnw-name-wiki-headline' => 'يو ويکي پيلول', # Fuzzy
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
	'cnw-desc-placeholder' => 'دا به ستاسې د ويکي په لومړي مخ ښکاره شي.', # Fuzzy
	'cnw-desc-tip1-creative' => 'دلته په يوې يا دوه کرښو کې خلکو ته مالومات ورکړۍ چې ستاسې ويکي د څه په اړه دی', # Fuzzy
	'cnw-desc-select-categories' => 'اضافه وېشنيزې ټاکل', # Fuzzy
	'cnw-desc-select-one' => 'يو وټاکۍ',
	'cnw-desc-default-lang' => 'ستاسې ويکي به په $1 ژبه وي',
	'cnw-desc-change-lang' => 'بدلول',
	'cnw-desc-lang' => 'ژبه',
	'cnw-desc-wiki-submit-error' => 'يوه وېشنيزه وټاکۍ',
	'cnw-theme-headline' => 'خپل ويکي سکښتل',
	'cnw-welcome-headline' => 'بختور مو شه، د $1 ويکي جوړ شو', # Fuzzy
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
	'createnewwiki-desc' => 'Assistente de criação de wikis',
	'cnw-next' => 'Seguinte',
	'cnw-back' => 'Anterior',
	'cnw-or' => 'ou',
	'cnw-title' => 'Criar uma wiki nova',
	'cnw-name-wiki-headline' => 'Iniciar uma Wiki',
	'cnw-name-wiki-creative' => 'A Wikia é o melhor sítio para criar um site e desenvolver uma comunidade em torno de um tema do teu agrado.',
	'cnw-name-wiki-label' => 'Nome da tua wiki',
	'cnw-name-wiki-domain-label' => 'Dá um endereço à tua wiki',
	'cnw-name-wiki-submit-error' => 'Para continuar tens de preencher ambas as caixas acima.',
	'cnw-login' => 'Entrar',
	'cnw-signup' => 'Criar conta',
	'cnw-signup-prompt' => 'Precisas de uma conta?',
	'cnw-call-to-signup' => 'Regista-te aqui',
	'cnw-login-prompt' => 'Já tens uma conta?',
	'cnw-call-to-login' => 'Inicia uma sessão aqui',
	'cnw-auth-headline' => 'Entrar',
	'cnw-auth-headline2' => 'Registar-te',
	'cnw-auth-creative' => 'Entra a tua conta para continuar a criar a wiki',
	'cnw-auth-signup-creative' => 'Precisas de ter uma conta para continuar a construir a tua wiki.<br />Só leva um minuto a registar-te!',
	'cnw-auth-facebook-signup' => 'Regista-te pelo Facebook',
	'cnw-auth-facebook-login' => 'Entrar pelo Facebook',
	'cnw-userauth-headline' => 'Tens uma conta?',
	'cnw-userauth-creative' => 'Entrar',
	'cnw-userauth-marketing-heading' => 'Não tens nenhuma conta?',
	'cnw-userauth-marketing-body' => 'Precisas de uma conta para criar uma wiki na Wikia. Só demora um minuto para registar-te!',
	'cnw-userauth-signup-button' => 'Regista-te',
	'cnw-desc-headline' => 'Qual é o assunto da tua wikia?',
	'cnw-desc-creative' => 'A tua descrição irá ajudar as pessoas a encontrar a tua wikia',
	'cnw-desc-placeholder' => 'Isto irá aparecer na página principal da tua wiki.',
	'cnw-desc-tip1' => 'Sugestão',
	'cnw-desc-tip1-creative' => 'Usa este espaço para descrever a tua wikia aos visitantes numa frase ou duas',
	'cnw-desc-tip2' => 'Conselho',
	'cnw-desc-tip2-creative' => 'Dá aos visitantes detalhes específicos sobre o assunto da tua wiki',
	'cnw-desc-select-one' => 'Selecciona uma',
	'cnw-desc-all-ages' => 'Esta wikia é dirigida a crianças?',
	'cnw-desc-tip-all-ages' => 'Esta wikia é sobre um tema infantil? Para obedecer à lei dos Estados Unidos, monitorizamos as wikias sobre temas de interesse para crianças até aos 12 anos de idade.',
	'cnw-desc-default-lang' => 'A tua wiki será em $1',
	'cnw-desc-change-lang' => 'alterar',
	'cnw-desc-lang' => 'Língua',
	'cnw-desc-wiki-submit-error' => 'Escolhe uma categoria, por favor',
	'cnw-theme-headline' => 'Escolhe uma variante do tema',
	'cnw-theme-creative' => 'Escolhe uma variante do tema; podes ver uma antevisão de cada variante, clicando-a.',
	'cnw-theme-instruction' => 'Também podes criar uma variante personalizada mais tarde, usando “As minhas ferramentas”.',
	'cnw-welcome-headline' => 'Parabéns! A $1 foi criada',
	'cnw-welcome-instruction1' => 'Clica o botão abaixo para começar a criar páginas na tua wiki.',
	'cnw-welcome-help' => 'Vais encontrar respostas, conselhos e mais na <a href="http://pt.wikia.com">Comunidade Central</a>.',
	'cnw-error-general' => 'Ops, algo correu mal da nossa parte! Por favor tente de novo, ou [[Special:Contact|contacte-nos]] para obter ajuda.',
	'cnw-error-general-heading' => 'As nossas desculpas',
	'cnw-badword-header' => 'Atenção',
	'cnw-badword-msg' => 'Não uses estas palavras impróprias ou proibidas na Descrição da Wiki, por favor: $1',
	'cnw-error-wiki-limit-header' => 'O limite de wikis foi atingido',
	'cnw-error-wiki-limit' => 'Olá, estás limitado à criação de $1 {{PLURAL:$1|wiki|wikis}} por dia. Aguarda 24 horas antes de criar outra wiki.',
	'cnw-error-blocked-header' => 'Conta bloqueada',
	'cnw-error-blocked' => 'Foi bloqueado por $1. O motivo apresentado foi: $2. (Identificação do bloqueio para referência: $3)',
	'cnw-error-anon-user-header' => 'Por favor, inicie sessão.',
	'cnw-error-anon-user' => 'A criação de wikis para utilizadores sem registar-se está desativada. Faz favor, [[Special:UserLogin|regista-te]] e tenta-o de novo.',
	'cnw-error-torblock' => 'Não é permitido criar wikis através da rede Tor.',
	'cnw-error-bot' => 'Detetámos que podes ser um robô. Se errámos, contata-nos descrevendo esta falsa identificação e podemos ajudar-te a criar a tua wiki: [http://www.wikia.com/Special:Contact/general Contate-nos]',
	'cnw-error-bot-header' => 'Detetámos que és um robô',
	'cnw-error-unconfirmed-email-header' => 'O teu e-mail não foi confirmado',
	'cnw-error-unconfirmed-email' => 'O teu e-mail deve ser confirmado antes poderes criar uma Wiki.',
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
	'cnw-name-wiki-creative' => 'A Wikia é o melhor lugar para criar um site e desenvolver uma comunidade em torno de um tema do seu agrado.', # Fuzzy
	'cnw-name-wiki-label' => 'Nome da sua wikia', # Fuzzy
	'cnw-name-wiki-domain-label' => 'Dê um endereço a sua wikia', # Fuzzy
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
	'cnw-desc-creative' => 'Sua descrição vai ajudar as pessoas a encontrar a seu wikia', # Fuzzy
	'cnw-desc-placeholder' => 'Isso vai aparecer na página principal da sua wikia.', # Fuzzy
	'cnw-desc-tip1' => 'Sugestão', # Fuzzy
	'cnw-desc-tip1-creative' => 'Use este espaço para descrever a sua wikia aos visitantes numa frase ou duas', # Fuzzy
	'cnw-desc-tip2' => 'Psiu', # Fuzzy
	'cnw-desc-tip2-creative' => 'Dê aos visitantes alguns detalhes específicos sobre o assunto', # Fuzzy
	'cnw-desc-select-vertical' => 'Selecione uma categoria Hub', # Fuzzy
	'cnw-desc-select-categories' => 'Selecione categorias adicionais', # Fuzzy
	'cnw-desc-select-one' => 'Selecione uma',
	'cnw-desc-all-ages' => 'Esta wikia é destinada a crianças?',
	'cnw-desc-tip-all-ages' => 'Esta wikia é sobre um assunto no qual crianças estariam interessadas? A fim de nos ajudar a cumprir a lei dos Estados Unidos, nós mantemos o controle de wikias sobre assuntos que se dirigem diretamente para crianças de até 12 anos.',
	'cnw-desc-default-lang' => 'Sua wikia será em $1', # Fuzzy
	'cnw-desc-change-lang' => 'alterar',
	'cnw-desc-lang' => 'Idioma',
	'cnw-desc-wiki-submit-error' => 'Por favor, escolha uma categoria',
	'cnw-theme-headline' => 'Escolha um tema',
	'cnw-theme-creative' => 'Escolha um tema abaixo, você será capaz de ver uma prévia de cada tema, quando você selecioná-lo.', # Fuzzy
	'cnw-theme-instruction' => "Você também pode criar o seu próprio tema mais tarde usando ''Minhas Ferramentas''.", # Fuzzy
	'cnw-welcome-headline' => 'Parabéns! A $1 foi criada', # Fuzzy
	'cnw-welcome-instruction1' => 'Clique no botão abaixo para começar a criar páginas na sua wikia.', # Fuzzy
	'cnw-welcome-help' => 'Encontre respostas, conselhos, e muito mais na <a href="http://comunidade.wikia.com">Central da Comunidade Wikia</a>.', # Fuzzy
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
	'cnw-name-wiki-headline' => 'Начать вики',
	'cnw-name-wiki-creative' => 'Викия - это лучшее место для создания веб-сайта о том, что вы любите, и роста сообщества вокруг этого.', # Fuzzy
	'cnw-name-wiki-label' => 'Название вашей викии',
	'cnw-name-wiki-domain-label' => 'Задайте адрес для вашей викии',
	'cnw-name-wiki-submit-error' => 'Вам нужно заполнить оба полях выше для того, чтобы продолжить.',
	'cnw-login' => 'Представиться системе',
	'cnw-signup' => 'Создать учётную запись',
	'cnw-signup-prompt' => 'Нужен аккаунт?',
	'cnw-call-to-signup' => 'Регистрация здесь',
	'cnw-login-prompt' => 'Вы уже зарегистрированы?',
	'cnw-call-to-login' => 'Войти в систему',
	'cnw-auth-headline' => 'Представиться системе',
	'cnw-auth-headline2' => 'Регистрация',
	'cnw-auth-creative' => 'Войти в свою учётную запись, чтобы продолжить создание вики.',
	'cnw-auth-signup-creative' => 'Вам нужна учётная запись, чтобы продолжить создание вики.<br />Регистрация займёт всего одну минуту!',
	'cnw-auth-facebook-signup' => 'Зарегистрироваться через Facebook',
	'cnw-auth-facebook-login' => 'Войти через Facebook',
	'cnw-userauth-headline' => 'Есть аккаунт?',
	'cnw-userauth-creative' => 'Войти',
	'cnw-userauth-marketing-heading' => 'Нет аккаунта?',
	'cnw-userauth-marketing-body' => 'Вам необходим аккаунт для создания вики на Викия. Всего минута на регистрацию!',
	'cnw-userauth-signup-button' => 'Регистрация',
	'cnw-desc-headline' => 'О чём ваша викия?',
	'cnw-desc-creative' => 'Описание, которое поможет людям найти вашу викию', # Fuzzy
	'cnw-desc-placeholder' => 'Это будет отображаться на заглавной странице вики.', # Fuzzy
	'cnw-desc-tip1' => 'Вот подсказка!',
	'cnw-desc-tip1-creative' => 'Используйте это место, чтобы кратко рассказать людям о вашей викии в одно или два предложения', # Fuzzy
	'cnw-desc-tip2' => 'PS',
	'cnw-desc-tip2-creative' => 'Раскройте посетителям вики некоторые подробности вашей темы', # Fuzzy
	'cnw-desc-select-vertical' => 'Выберите категорию хаба',
	'cnw-desc-select-categories' => 'Проверьте дополнительные категории',
	'cnw-desc-select-one' => 'Выберите одно',
	'cnw-desc-all-ages' => 'Эта викия предназначена для детей?',
	'cnw-desc-tip-all-ages' => 'Это проект о теме, которая интересна детям? Для того, чтобы соответствовать законодательству США, мы отслеживаем проекты о темах, которые непосредственно касаются детей в возрасте 12 лет и младше.',
	'cnw-desc-default-lang' => 'Ваша викия будет в разделе $1',
	'cnw-desc-change-lang' => 'изменить',
	'cnw-desc-lang' => 'Язык',
	'cnw-desc-wiki-submit-error' => 'Пожалуйста, выберите категорию',
	'cnw-theme-headline' => 'Выбрать тему',
	'cnw-theme-creative' => 'Выберите тему ниже; вы можете просмотреть каждую тему до того, как сделать окончательный выбор.', # Fuzzy
	'cnw-theme-instruction' => 'Вы также можете создавать свои собственные темы позже, перейдя в "Мои инструменты".', # Fuzzy
	'cnw-welcome-headline' => 'Поздравляем! Вы успешно создали $1',
	'cnw-welcome-instruction1' => 'Нажмите на кнопку ниже, чтобы начать добавлять страницы на вики.', # Fuzzy
	'cnw-welcome-help' => 'Найти ответы, советы и многое другое на <a href="http://community.wikia.com">Центральной вики</a>.', # Fuzzy
	'cnw-error-general' => 'Оппаньки, что-то тут не сработало на нашей стороне! Пожалуйста, попробуйте еще раз или [[Special:Contact|обратитесь к нам]] за помощью.',
	'cnw-error-general-heading' => 'Наши извинения',
	'cnw-badword-header' => 'Эй там',
	'cnw-badword-msg' => 'Пожалуйста, воздержитесь от использования плохих или запрещенных слов в описании вики: $1',
	'cnw-error-wiki-limit-header' => 'Лимит создания вики',
	'cnw-error-wiki-limit' => 'Привет, вы достигли ограничения по созданию {{PLURAL:$1|$1 вики|$1 викии|$1 викий}} в день. Подождите 24 часа перед созданием другой вики..',
	'cnw-error-blocked-header' => 'Учётная запись заблокирована',
	'cnw-error-blocked' => 'Вы были заблокированы $1. Причиной было: $2. (Для справки: $3)',
	'cnw-error-anon-user-header' => 'Представьтесь, пожалуйста',
	'cnw-error-anon-user' => 'Создание вики для анонимов отключено. Пожалуйста, [[Special:UserLogin|представьтесь]] и повторите попытку.',
	'cnw-error-torblock' => 'Создание вики через сеть Tor не допускается.',
	'cnw-error-bot' => 'Мы обнаружили, что вы можете быть ботом. Если мы сделали ошибку, пожалуйста, свяжитесь с нами и подтвердите, что  вы не бот, и мы поможем вам в создании новой вики: [http://www.wikia.com/Special:Contact/general связь с нами]',
	'cnw-error-bot-header' => 'Вы были определены как бот',
	'cnw-error-unconfirmed-email-header' => 'Ваш адрес электронной почты не был подтверждён',
	'cnw-error-unconfirmed-email' => 'Ваш адрес электронной почты должен быть подтверждён для создания Вики.',
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
	'cnw-error-general' => 'Дошло је до грешке при стварању викија. Покушајте касније.', # Fuzzy
	'cnw-error-general-heading' => 'Грешка при стварању новог викија', # Fuzzy
	'cnw-badword-header' => 'Упозорење',
	'cnw-badword-msg' => 'Здраво. Молимо вас да се уздржите од употребе непристојних и забрањених речи које се налазе у опису викија: $1',
	'cnw-error-wiki-limit-header' => 'Достигнуто је ограничење направљених викија',
	'cnw-error-wiki-limit' => 'Здраво. Можете да направите само по $1 вики дневно. Сачекајте 24 часа, па потом направите други.', # Fuzzy
	'cnw-error-blocked-header' => 'Налог је блокиран',
	'cnw-error-blocked' => '{{GENDER:$1|Блокирао вас је корисник|Блокирала вас је корисница|Блокирао вас је корисник}} $1. Наведени разлог гласи: $2 (назнака блокаде: $3).',
	'cnw-error-torblock' => 'Није дозвољено стварање викија преко Тор мреже.',
	'cnw-error-bot' => 'Утврдили смо да сте можда бот. Ако је ово погрешно, обратите нам се, а ми ћемо вам помоћи да направите вики: [http://www.wikia.com/Special:Contact/general Пишите нам].',
	'cnw-error-bot-header' => 'Препознати сте као бот',
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
	'createnewwiki-desc' => '[[Special:CreateNewWiki|వికీని సృష్టించే విజార్డు]]', # Fuzzy
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
	'cnw-error-general' => 'May masamang bagay na nangyari habang nililikha ang wiki mo. Paki subukan ulit mamaya.', # Fuzzy
	'cnw-error-general-heading' => 'Kamalian sa Paglikha ng Bagong Wiki', # Fuzzy
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

/** толышә зывон (толышә зывон)
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
	'createnewwiki-desc' => 'Вики ясау остаханәсе', # Fuzzy
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
	'cnw-userauth-marketing-body' => 'Вики төзү өчен сезгә теркәлергә кирәк. Теркәлү бер генә минут!', # Fuzzy
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
	'cnw-error-general' => 'Викине ясаганда ниндидер хата киткән. Зинһар өчен, соңрак кабатлап карагыз.', # Fuzzy
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
	'cnw-name-wiki-headline' => 'Tạo lập một Wiki',
	'cnw-name-wiki-creative' => 'Wikia là nơi tốt nhất để xây dựng một trang web và phát triển một cộng đồng xung quanh những gì bạn yêu thích.',
	'cnw-name-wiki-label' => 'Tên wiki của bạn',
	'cnw-name-wiki-domain-label' => 'Tặng cho wiki của bạn một địa chỉ',
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
	'cnw-desc-creative' => 'Mô tả chủ đề của mình giúp những người khác tìm được wikia của bạn',
	'cnw-desc-placeholder' => 'Điều này sẽ xuất hiện trên trang chính của wiki.',
	'cnw-desc-tip1' => 'Gợi ý',
	'cnw-desc-tip1-creative' => 'Sử dụng khoảng trống này để nói với mọi người về wikia của bạn với một hai câu',
	'cnw-desc-tip2' => 'Xem này',
	'cnw-desc-tip2-creative' => 'Cung cấp cho người truy cập một số chi tiết cụ thể về chủ đề của bạn',
	'cnw-desc-select-vertical' => 'Chọn một thể loại trung tâm',
	'cnw-desc-select-categories' => 'Chọn danh mục bổ sung',
	'cnw-desc-select-one' => 'Chọn một',
	'cnw-desc-all-ages' => 'Có phải wikia này dành cho trẻ em?',
	'cnw-desc-tip-all-ages' => 'Đây có phải là nơi giới thiệu một chủ đề mà trẻ em có thể quan tâm? Để giúp chúng tôi tuân thủ luật pháp Hoa Kỳ, chúng tôi theo dõi các wikia về những chủ đề dành cho cho trẻ em từ 12 tuổi trở xuống.',
	'cnw-desc-default-lang' => 'Wiki của bạn sẽ đặt tại $1',
	'cnw-desc-change-lang' => 'thay đổi',
	'cnw-desc-lang' => 'Ngôn ngữ',
	'cnw-desc-wiki-submit-error' => 'Hãy chọn một thể loại',
	'cnw-theme-headline' => 'Chọn một chủ đề',
	'cnw-theme-creative' => 'Chọn một chủ đề dưới đây, bạn sẽ có thể xem thử từng chủ đề mà bạn đã chọn.',
	'cnw-theme-instruction' => 'Bạn cũng có thể thiết kế chủ đề sau này bằng cách vào "Công cụ".',
	'cnw-welcome-headline' => 'Chúc mừng! $1 đã được tạo lập thành công',
	'cnw-welcome-instruction1' => 'Nhấp vào nút dưới đây để bắt đầu thêm các trang cho wiki của bạn.',
	'cnw-welcome-help' => 'Tìm câu trả lời, lời khuyên và nhiều hơn trên <a href="http://congdong.wikia.com">Cộng đồng Wikia tiếng Việt</a>.',
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
	'cnw-title' => '创造一个新的维基',
	'cnw-name-wiki-headline' => '开始一个维基', # Fuzzy
	'cnw-name-wiki-creative' => '建造一个网站，发展一个社区，并从事您终极的粉丝体验。',
	'cnw-name-wiki-label' => '命名您的wikia',
	'cnw-name-wiki-domain-label' => '给您的wikia一个地址',
	'cnw-name-wiki-submit-error' => '哎呀！您需要填写以上的两个框才能延续下去。',
	'cnw-login' => '登录',
	'cnw-signup' => '创建帐户',
	'cnw-signup-prompt' => '需要一个帐户吗？',
	'cnw-call-to-signup' => '在这里注册',
	'cnw-login-prompt' => '已有帐户？',
	'cnw-call-to-login' => '在这里登录',
	'cnw-auth-headline' => '登入',
	'cnw-auth-headline2' => '注册',
	'cnw-auth-creative' => '登入进您的账户来继续建立您的维基。',
	'cnw-auth-signup-creative' => '您需要一个账户来继续建立您的维基。<br />注册只须一分钟！',
	'cnw-auth-facebook-signup' => '使用脸书账号登录',
	'cnw-auth-facebook-login' => '使用脸书登录',
	'cnw-userauth-headline' => '已拥有帐户？',
	'cnw-userauth-creative' => '登录',
	'cnw-userauth-marketing-heading' => '没有帐户？',
	'cnw-userauth-marketing-body' => '您需要一个账户才能在wikia上创建wiki。只需要一分钟即可注册！',
	'cnw-userauth-signup-button' => '注册',
	'cnw-desc-headline' => '您的wikia是关于什么的？',
	'cnw-desc-creative' => '通过华丽的描述，帮助人们找到您的wikia。',
	'cnw-desc-placeholder' => '这会在您的维基首页出现。',
	'cnw-desc-tip1' => '下面是一个提示！',
	'cnw-desc-tip1-creative' => '在此空格中使用一两句话向大家介绍您的维基', # Fuzzy
	'cnw-desc-tip2' => '顺带一提',
	'cnw-desc-tip2-creative' => '给访客提供一些关于你主题的某些特定信息', # Fuzzy
	'cnw-desc-select-vertical' => '选择一个集线器分类',
	'cnw-desc-select-categories' => '选择额外分类',
	'cnw-desc-select-one' => '选一',
	'cnw-desc-all-ages' => '此wikia适合儿童浏览么？',
	'cnw-desc-tip-all-ages' => '这是有关于孩子们感兴趣的话题么？为了使我们遵守美国法律，我们要保持跟踪面向12岁及以下儿童的话题的wikia站点。',
	'cnw-desc-default-lang' => '您的维基将位于$1',
	'cnw-desc-change-lang' => '改变',
	'cnw-desc-lang' => '语言',
	'cnw-desc-wiki-submit-error' => '请选一个分类',
	'cnw-theme-headline' => '选择一个主题',
	'cnw-theme-creative' => '在下面选择一个主题，您将会看见您选择的主题的预览。',
	'cnw-theme-instruction' => '您也可以在“我的工具”里设计自己的主题。',
	'cnw-welcome-headline' => '恭喜！您已成功创建$1',
	'cnw-welcome-instruction1' => '点击以下的按钮来开始在您的维基新增页面。',
	'cnw-welcome-help' => '继续您的爱好者体验。在<a href="http://community.wikia.com">社区中心</a>中找到答案、建议和更多。',
	'cnw-error-general' => '哎呀，我们这边出错了！请再试一次，或者[[Special:Contact|联系我们]]取得帮助。',
	'cnw-error-general-heading' => '抱歉',
	'cnw-badword-header' => '哇',
	'cnw-badword-msg' => '您好，请不要在您的维基说明使用这些不良的和被禁止的字词：$1',
	'cnw-error-wiki-limit-header' => '维基限制已达到了',
	'cnw-error-wiki-limit' => '您好，您已被限制为一天只能创建$1个Wiki。请等待24小时后再创建另一个Wiki。',
	'cnw-error-blocked-header' => '帐户被封禁',
	'cnw-error-blocked' => '您已被$1封禁。原因是：$2。（参考封禁ID：$3）',
	'cnw-error-anon-user-header' => '请登录',
	'cnw-error-anon-user' => '匿名用户不能创建维基。请先[[Special:UserLogin|登陆]]，然后再试。',
	'cnw-error-torblock' => '不能使用Tor网络创建Wiki。',
	'cnw-error-bot' => '我们发现您可能是一个及其软件。如果这是个错误，请联系并告诉我们您被误认为是一个机器人，然后让我们协助您创建Wiki：[http://www.wikia.com/Special:Contact/general 联系我们]',
	'cnw-error-bot-header' => '您已被识别为机器人',
	'cnw-error-unconfirmed-email-header' => '您的电子柚子尚未得到证实',
	'cnw-error-unconfirmed-email' => '您需要验证邮件以创建Wiki',
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
	'cnw-name-wiki-headline' => '建立新的wiki', # Fuzzy
	'cnw-name-wiki-creative' => 'Wikia是建立你所喜好的網站和發展社群最好的選擇。', # Fuzzy
	'cnw-name-wiki-label' => '給您的wiki一個名字', # Fuzzy
	'cnw-name-wiki-domain-label' => '給您的 wiki 的一個網址', # Fuzzy
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
	'cnw-desc-creative' => '您的描述將幫忙人們找到您的 wikia', # Fuzzy
	'cnw-desc-placeholder' => '這將顯示你的 wiki 的首頁上。', # Fuzzy
	'cnw-desc-tip1' => '提示', # Fuzzy
	'cnw-desc-tip1-creative' => '使用此空間以一兩句話來向其他人講述你的 wiki。', # Fuzzy
	'cnw-desc-tip2-creative' => '向訪問者提供一些有關你的主題的特定詳細資訊', # Fuzzy
	'cnw-desc-select-one' => '請選擇一項',
	'cnw-desc-all-ages' => '所有年齡', # Fuzzy
	'cnw-desc-tip-all-ages' => '這個Wiki有關於孩子們感興趣的話題嗎？为了遵守美國法律，我們持續追縱直接與12歲及以下兒童相關主題的wiki。', # Fuzzy
	'cnw-desc-default-lang' => '您的 wiki 將位於 $1', # Fuzzy
	'cnw-desc-change-lang' => '變更',
	'cnw-desc-lang' => '語言',
	'cnw-desc-wiki-submit-error' => '請選擇一個分類',
	'cnw-theme-headline' => '選擇一個主題',
	'cnw-theme-creative' => '選擇下面其中一個樣式，選擇之後您可以看到每個樣式的預覽。', # Fuzzy
	'cnw-theme-instruction' => '您還可以稍後透過"我的工具"設計您自己的樣式。', # Fuzzy
	'cnw-welcome-headline' => '恭喜！ $1 已建立', # Fuzzy
	'cnw-welcome-instruction1' => '按一下下面的按鈕以開始將頁面添加到你的 wiki。', # Fuzzy
	'cnw-welcome-help' => '要找尋解答、建議以及其他，可到 <a href="http://community.wikia.com">社群中心</a>.', # Fuzzy
	'cnw-error-general' => '哎呀，我們這邊出了一些問題 ！請重試，或 [[Special： Contact|聯絡我們]]以得到幫助。', # Fuzzy
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
