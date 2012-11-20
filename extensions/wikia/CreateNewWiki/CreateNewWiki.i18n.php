<?php
/**
* Internationalisation file for the CreateNewWiki extension.
*
* @addtogroup Languages
*/

$messages = array();

$messages['en'] = array(
	// general messages
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Wiki creation wizard]]',
	'cnw-next' => 'Next',
	'cnw-back' => 'Back',
	'cnw-or' => 'or',
	'cnw-title' => 'Create New Wiki',
	// step1 - create a wiki
	'cnw-name-wiki-headline' => 'Start a Wiki',
	'cnw-name-wiki-creative' => 'Wikia is the best place to build a website and grow a community around what you love.',
	'cnw-name-wiki-label' => 'Name your wiki',
	'cnw-name-wiki-wiki' => 'Wiki',
	'cnw-name-wiki-domain-label' => 'Give your wiki an address',
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
	'cnw-userauth-marketing-body' => 'You need an account to create a wiki on Wikia. It only takes a minute to [[Special:UserSignup|sign up]]!',
	'cnw-userauth-signup-button' => 'Sign up',
	// step3 - wiki description
	'cnw-desc-headline' => 'What\'s your wiki about?',
	'cnw-desc-creative' => 'Describe your topic',
	'cnw-desc-placeholder' => 'This will appear on the main page of your wiki.',
	'cnw-desc-tip1' => 'Hint',
	'cnw-desc-tip1-creative' => 'Use this space to tell people about your wiki in a sentence or two',
	'cnw-desc-tip2' => 'Psst',
	'cnw-desc-tip2-creative' => 'Give your visitors some specific details about your subject',
	'cnw-desc-tip3' => 'Pro Tip',
	'cnw-desc-tip3-creative' => 'Let people know they can help your wiki grow by editing and adding pages',
	'cnw-desc-choose' => 'Choose a category',
	'cnw-desc-select-one' => 'Select one',
	'cnw-desc-default-lang' => 'Your wiki will be in $1',
	'cnw-desc-change-lang' => 'change',
	'cnw-desc-lang' => 'Language',
	'cnw-desc-wiki-submit-error' => 'Please choose a category',
	// step4 - select theme
	'cnw-theme-headline' => 'Choose a theme',
	'cnw-theme-creative' => 'Choose a theme below, you\'ll be able to see a preview of each theme as you select it.',
	'cnw-theme-instruction' => 'You can also design your own theme later by going to "My Tools".',
	// step5 - upgrade
	'cnw-upgrade-headline' => 'Do you want to upgrade?',
	'cnw-upgrade-creative' => 'Upgrading to Wikia Plus allows you to remove ads from <span class="wiki-name"></span>, a one time offer only available to new founders.',
	'cnw-upgrade-marketing' => 'Wikia Plus is a great solution for:<ul>
<li>Professional Wikis</li>
<li>Non-profits</li>
<li>Families</li>
<li>Schools</li>
<li>Personal projects</li>
</ul>
Upgrade through PayPal to get an ad-free wiki for only $4.95 per month!',
	'cnw-upgrade-now' => 'Upgrade Now',
	'cnw-upgrade-decline' => 'No thanks, continue to my wiki',
	// wiki welcome message
	'cnw-welcome-headline' => 'Congratulations! $1 has been created',
	'cnw-welcome-instruction1' => 'Click the button below to start adding pages to your wiki.',
	'cnw-welcome-instruction2' => 'You\'ll see this button throughout your wiki, use it any time you want to add a new page.',
	'cnw-welcome-help' => 'Find answers, advice, and more on <a href="http://community.wikia.com">Community Central</a>.',
	// error messages
	'cnw-error-general' => 'Something went wrong while creating your wiki.  Please try again later.',
	'cnw-error-general-heading' => 'Create New Wiki Error',
	'cnw-error-database' => 'Database Error: $1',
	'cnw-badword-header' => 'Whoa there',
	'cnw-badword-msg' => 'Hi, please refrain from using these bad words or banned words in your Wiki Description: $1',
	'cnw-error-wiki-limit-header' => 'Wiki limit reached',
	'cnw-error-wiki-limit' => 'Hi, you are limited to {{PLURAL:$1|$1 wiki creation|$1 wiki creations}} per day. Wait 24 hours before creating another wiki.',
	'cnw-error-blocked-header' => 'Account blocked',
	'cnw-error-blocked' => 'You have been blocked by $1. The reason given was: $2. (Block ID for reference: $3)',
	'cnw-error-torblock' => 'Creating wikis via the Tor Network is not allowed.',
	'cnw-error-bot' => 'We have detected that you may be a bot.  If we made a mistake, please contact us describing that you have been falsely detected as a bot, and we will aid you in creating your wiki: [http://www.wikia.com/Special:Contact/general Contact Us]',
	'cnw-error-bot-header' => 'You have been detected as a bot',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Siebrand
 * @author Wyz
 */
$messages['qqq'] = array(
	'cnw-next' => 'Text for "Next" Button',
	'cnw-back' => 'Text for "Back" Button
{{Identical|Back}}',
	'cnw-or' => 'Division for login or Facebook login',
	'cnw-title' => 'General Title for this feature',
	'cnw-name-wiki-headline' => 'H1 for this step',
	'cnw-name-wiki-creative' => 'Creative or instruction for this step following H1',
	'cnw-name-wiki-label' => 'Label for wiki name field',
	'cnw-name-wiki-wiki' => '"Wiki"',
	'cnw-name-wiki-domain-label' => 'Label for wiki domain field',
	'cnw-name-wiki-submit-error' => 'Error message to display when the there are errors in the fields',
	'cnw-login' => 'Text for "Log In" Button',
	'cnw-signup' => 'Text for "Create account" Button',
	'cnw-signup-prompt' => 'ask if user needs to create an account',
	'cnw-call-to-signup' => 'Call to action to create an account (clickable link)',
	'cnw-login-prompt' => 'ask if user already has a login',
	'cnw-call-to-login' => 'Call to action to login (clickable link)',
	'cnw-auth-headline' => 'H1 for this step',
	'cnw-auth-creative' => 'Creative or instruction for this step following H1 for login',
	'cnw-auth-signup-creative' => 'Creative or instruction for this step following H1 for signup',
	'cnw-auth-facebook-signup' => '"Sign up with Facebook" Button',
	'cnw-auth-facebook-login' => '"Login with Facebook" Button',
	'cnw-userauth-headline' => 'Heading for user login/signup box at the top',
	'cnw-userauth-creative' => 'Sublabel that says "log in"',
	'cnw-userauth-marketing-heading' => 'Heading to create an account in form of a question on the right side of the box',
	'cnw-userauth-marketing-body' => 'Marketing blurb with link to user signup on the right side.  Please append uselang=es(or other lang) on the link.',
	'cnw-userauth-signup-button' => 'Label for sign up button on the right side.',
	'cnw-desc-headline' => 'H1 for this step',
	'cnw-desc-creative' => 'Creative or instruction for this step following H1',
	'cnw-desc-placeholder' => 'Placeholder for the textarea',
	'cnw-desc-tip1' => 'First Tip label',
	'cnw-desc-tip1-creative' => 'The first tip<br />
Be carefull to keep it short as there are 3 successive balloon tips to display in a small space',
	'cnw-desc-tip2' => 'Second Tip label',
	'cnw-desc-tip2-creative' => 'The second tip<br />
Be carefull to keep it short as there are 3 successive balloon tips to display in a small space',
	'cnw-desc-tip3' => 'Third Tip label',
	'cnw-desc-tip3-creative' => 'The third tip<br />
Be carefull to keep it short as there are 3 successive balloon tips to display in a small space',
	'cnw-desc-choose' => 'Label for category',
	'cnw-desc-select-one' => 'Default empty label for category',
	'cnw-desc-default-lang' => 'Letting user know which language this wiki will be in.  $1 will be wiki language',
	'cnw-desc-change-lang' => 'Call to action to change the language',
	'cnw-desc-lang' => 'Label for language',
	'cnw-desc-wiki-submit-error' => 'General error message for not selecting category',
	'cnw-theme-headline' => 'H1 for this step',
	'cnw-theme-creative' => 'Creative or instruction for this step following H1',
	'cnw-theme-instruction' => 'Details on how Toolbar can be used as an alternative later',
	'cnw-upgrade-headline' => 'H1 for this step',
	'cnw-upgrade-creative' => 'Creative for this step. Leave the span in there for wiki name',
	'cnw-upgrade-marketing' => 'Marketing Pitch for Wikia plus upgrade',
	'cnw-upgrade-now' => 'Call to action button to upgrade to Wikia plus',
	'cnw-upgrade-decline' => 'Wikia plus rejection',
	'cnw-welcome-headline' => 'Headliner for modal. $1 is wikiname',
	'cnw-welcome-instruction1' => 'First line of instruction to add a page',
	'cnw-welcome-instruction2' => 'Second line of instruction to add a page after the button',
	'cnw-welcome-help' => 'Message to Community central with embedded anchor. (leave blank if community does not exist)',
	'cnw-error-general' => 'Generic error message to alert users that something went wrong while creating wiki',
	'cnw-error-general-heading' => 'Heading for generic error in modal dialog',
	'cnw-error-blocked' => 'Parameters:
* $1 is a username
* $2 is a block reason
* $3 is a block ID',
	'cnw-error-bot' => 'Message describing you may be a bot and link to contact page',
	'cnw-error-bot-header' => 'Message header for modal box',
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
	'cnw-desc-tip3' => 'Protip',
	'cnw-desc-choose' => "Kies 'n kategorie",
	'cnw-desc-select-one' => 'Kies een',
	'cnw-desc-default-lang' => 'Die hooftaal van u wiki is: $1',
	'cnw-desc-change-lang' => 'wysig',
	'cnw-desc-lang' => 'Taal',
	'cnw-desc-wiki-submit-error' => "Kies 'n kategorie",
	'cnw-theme-headline' => 'Ontwerp u wiki',
	'cnw-upgrade-headline' => 'Wil u opgradeer?',
	'cnw-upgrade-now' => 'Opgradeer nou',
	'cnw-badword-header' => 'Pas op!',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 * @author ترجمان05
 * @author زكريا
 */
$messages['ar'] = array(
	'cnw-next' => 'التالي',
	'cnw-back' => 'رجوع',
	'cnw-or' => 'أو',
	'cnw-title' => 'إنشاء ويكي جديدة',
	'cnw-name-wiki-headline' => 'بدء ويكي',
	'cnw-login' => 'تسجيل الدخول',
	'cnw-signup' => 'أنشئ حسابا',
	'cnw-call-to-login' => 'لج هنا',
	'cnw-auth-headline' => 'تسجيل الدخول',
	'cnw-auth-headline2' => 'أنشئ حسابًا',
	'cnw-userauth-creative' => 'تسجيل الدخول',
	'cnw-userauth-marketing-heading' => 'ليس لديك حساب؟',
	'cnw-desc-lang' => 'اللغة',
);

/** Kotava (Kotava)
 * @author Wikimistusik
 */
$messages['avk'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Tcicesiki va redura va wiki]]',
	'cnw-next' => 'Radim-',
	'cnw-back' => 'Dim-',
	'cnw-or' => 'ok',
	'cnw-title' => 'Redura va warzafi wiki',
	'cnw-name-wiki-headline' => 'Bokara va wiki',
	'cnw-name-wiki-creative' => 'Wikia tir telo xonyo ta kolnara va internetxo is laumara ke doda aname rinaf albaks.',
	'cnw-name-wiki-label' => 'Yoltara va bati wiki',
	'cnw-name-wiki-wiki' => 'Wiki',
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
	'cnw-userauth-marketing-body' => 'Enide va redura va wiki dene Wikia, pata tir adrafa. Ta [[Special:UserSignup|dogluyara]] nemon tanoya wexa !',
	'cnw-userauth-signup-button' => 'Dogluyara',
	'cnw-desc-headline' => 'Toka watsa ke bati wiki tir ?',
	'cnw-desc-creative' => 'Va bate detce pimtal',
	'cnw-desc-placeholder' => 'Batcoba moe emudexo ke wiki awitir.',
	'cnw-desc-tip1' => 'Palsera',
	'cnw-desc-tip2' => 'Psst',
	'cnw-desc-tip2-creative' => 'Va yona aptolafa pinta pu worasik icde rinafa watsa bilder',
	'cnw-desc-tip3' => 'Pro Tip',
	'cnw-desc-tip3-creative' => 'bettan betason va bu iku loplekuson va latrara va bati wiki ropomar',
	'cnw-desc-choose' => 'Kiblara va loma',
	'cnw-desc-select-one' => 'Va tanoy rebal',
	'cnw-desc-default-lang' => 'Bati wiki dene $1 tigitir',
	'cnw-desc-change-lang' => 'betara',
	'cnw-desc-lang' => 'Ava',
	'cnw-desc-wiki-submit-error' => 'Va loma vay kiblal',
	'cnw-theme-headline' => 'Kiblara va watsa',
	'cnw-upgrade-headline' => 'Kas djufabdul ?',
	'cnw-upgrade-now' => 'Dure fabdura',
	'cnw-welcome-headline' => 'Sendara ! $1 su zo redur',
	'cnw-welcome-instruction1' => 'Ta loplekura va bu den bati wiki va vlevefo uzadjo vulegal.',
	'cnw-welcome-instruction2' => 'Va bato uzadjo dene bati wiki witil, ta loplekura va warzafu bu kotviele rozanudal.',
	'cnw-error-general' => 'Rotaca sokiyir bak redura va wiki. Vay fure gire laredul.',
	'cnw-error-general-heading' => 'Rokla va redura va warzafi wiki',
	'cnw-error-database' => 'Rokla ko origak : $1',
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
	'cnw-name-wiki-wiki' => 'Viki',
	'cnw-login' => 'Daxil ol',
	'cnw-auth-headline' => 'Daxil ol',
	'cnw-desc-lang' => 'Dil',
);

/** Bavarian (Boarisch)
 * @author Mucalexx
 */
$messages['bar'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Assistent zan Dastejn vahram Wiki]]',
	'cnw-next' => 'Naxde',
	'cnw-back' => 'Zruck',
	'cnw-or' => 'óder',
	'cnw-title' => 'Neichs Wiki erstejn',
	'cnw-name-wiki-headline' => 'A Wiki starten',
	'cnw-name-wiki-creative' => 'Wikia is da béste Ort, um rund um deih Liablingsthéma a Webseiten afzbaun und a Gmoahschoft woxen zan lossen.',
	'cnw-name-wiki-label' => 'Gib an Wiki an Naum',
	'cnw-name-wiki-wiki' => 'Wiki',
	'cnw-name-wiki-domain-label' => 'Gib deim Wiki a Adress',
);

/** Bulgarian (български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Съветник за създаване на уики]]',
	'cnw-next' => 'Продължаване',
	'cnw-back' => 'Връщане',
	'cnw-or' => 'или',
	'cnw-title' => 'Създаване на ново уики',
	'cnw-name-wiki-headline' => 'Създаване на уики',
	'cnw-name-wiki-creative' => 'Уикия е най-доброто място за изграждане на уебсайт и изграждане на общност около темите, които ви вълнуват.',
	'cnw-name-wiki-label' => 'Изберете име на уикито',
	'cnw-name-wiki-wiki' => 'Уики',
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
	'cnw-userauth-creative' => 'Влизане',
	'cnw-userauth-signup-button' => 'Регистриране',
	'cnw-desc-headline' => 'За какво е вашето уики?',
	'cnw-desc-creative' => 'Опишете темата',
	'cnw-desc-placeholder' => 'Съдържанието от тази кутия ще бъде публикувано на началната страница на вашето уики.',
	'cnw-desc-tip1' => 'Съвет',
	'cnw-desc-tip1-creative' => 'Използвайте това пространство, за да разкажете и опишете с едно-две изречение вашето уики пред потребителите',
	'cnw-desc-tip2' => 'Псст',
	'cnw-desc-tip3' => 'Про съвет',
	'cnw-desc-tip3-creative' => 'Нека хората знаят, че могат да помогнат на уикито ви да се развива, като редактират или създават нови страници',
	'cnw-desc-choose' => 'Избиране на категория',
	'cnw-desc-select-one' => 'Избиране',
	'cnw-desc-default-lang' => 'Вашето уики ще бъде на $1',
	'cnw-desc-change-lang' => 'промяна',
	'cnw-desc-lang' => 'Език',
	'cnw-desc-wiki-submit-error' => 'Необходимо е да бъде избрана категория',
	'cnw-theme-headline' => 'Избиране на тема',
	'cnw-theme-creative' => 'Изберете тема от списъка по-долу; можете да видите предварителен преглед на всяка тема, като я изберете.',
	'cnw-theme-instruction' => 'Също така можете да направите своя тема по-късно като отидете в „Моите инструменти“.',
	'cnw-upgrade-marketing' => 'Уикия Плюс е страхотно решение за:<ul>
<li>Професионални уикита</li>
<li>Некомерсиални организации</li>
<li>Семейства</li>
<li>Училища</li>
<li>Лични проекти</li>
</ul>
Преминаването към Уикия Плюс се извършва чрез PayPal за получаване на уики без реклами само за $4.95 месечно!',
	'cnw-upgrade-decline' => 'Не благодаря, продължаване към моето уики',
	'cnw-welcome-headline' => 'Поздравления! Уикито $1 беше създадено',
	'cnw-welcome-instruction1' => 'Щракнете върху бутона по-долу, за да започнете да добавяте страници към вашето уики.',
	'cnw-welcome-instruction2' => 'Ще виждате този бутон навсякъде във вашето уики, използвайте го по всяко време, когато желаете да добавите нова страница.',
	'cnw-welcome-help' => 'Можете да откриете отговори, съвети и други полезни неща в <a href="http://community.wikia.com">Централната общност</a>.',
	'cnw-error-database' => 'Грешка в базата данни: $1',
	'cnw-error-blocked-header' => 'Сметката е блокирана',
	'cnw-error-blocked' => 'Потребителската ви сметка е била блокирана от $1. Причината за блокирането, която е посочена, е: $2. (Номер на блокирането, за референции: $3)',
	'cnw-error-torblock' => 'Създаването на укита чрез Tor мрежа не е позволено.',
);

/** Breton (brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Skoazeller evit krouiñ wikioù]]',
	'cnw-next' => "War-lerc'h",
	'cnw-back' => 'Distreiñ',
	'cnw-or' => 'pe',
	'cnw-title' => 'Krouiñ ur wiki nevez',
	'cnw-name-wiki-headline' => 'Kregiñ gant ur wiki',
	'cnw-name-wiki-creative' => "Wikia eo al lec'h gwellañ evit sevel ul lec'hienn wiki ha lakaat ur gumuniezh da greskiñ en-dro d'ar pezh a garit.",
	'cnw-name-wiki-label' => "Roit un anv d'ho wiki",
	'cnw-name-wiki-wiki' => 'Wiki',
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
	'cnw-userauth-headline' => 'Hag ur gont ho peus ?',
	'cnw-userauth-creative' => 'Kevreañ',
	'cnw-userauth-marketing-heading' => "N'hoc'h eus kont ebet ?",
	'cnw-userauth-signup-button' => 'En em enskrivañ',
	'cnw-desc-headline' => 'Eus petra zo kaoz en ho wiki ?',
	'cnw-desc-creative' => 'Deskrivit ho sujed',
	'cnw-desc-placeholder' => 'Dont a ray war wel war bajenn bennañ ho wiki.',
	'cnw-desc-tip1' => 'Tun',
	'cnw-desc-tip1-creative' => "Implijit ar c'horn-mañ da zisplegañ d'an dud krak-ha-berr eus petra zo kaoz en ho wiki",
	'cnw-desc-tip2' => 'Kuzul 2',
	'cnw-desc-tip2-creative' => 'Merkit un nebeud displegadurioù war an danvez evit ar weladennerien',
	'cnw-desc-tip3' => 'Tun digant unan a-vicher',
	'cnw-desc-tip3-creative' => "Kelaouiñ an dud e c'hellont dont evit sikour da greskiñ ho wiki en ur gemmañ pe en ur ouzhpennañ pajennoù",
	'cnw-desc-choose' => 'Dibabit ur rummad',
	'cnw-desc-select-one' => 'Diuzañ unan',
	'cnw-desc-default-lang' => 'E $1 e vo ho wiki',
	'cnw-desc-change-lang' => 'kemmañ',
	'cnw-desc-lang' => 'Yezh',
	'cnw-desc-wiki-submit-error' => 'Dibabit ur rummad, mar plij',
	'cnw-theme-headline' => 'Krouit ho wiki',
	'cnw-theme-creative' => "Dibabit un dodenn amañ dindan, gellout a reoc'h rakwelet pep dodenn en ur ziuzañ anezhi.",
	'cnw-theme-instruction' => 'Gellout a rit ivez krouiñ ho todenn hiniennel un tamm diwezhatoc\'h en ur vont e "Ma ostilhoù".',
	'cnw-upgrade-headline' => "C'hoant hoc'h eus da lakaat a-live ?",
	'cnw-upgrade-creative' => "Hizivaat war-zu Wikia Plus a aotre ac'hanoc'h da dennañ ar bruderezhioù eus <span class=\"wiki-name\"></span>, ur c'hinnig dibar evit an diazezourien nevez hepken.",
	'cnw-upgrade-marketing' => 'Un diskoulm a-feson eo Wikia Plus evit :<ul>
<li>Wikioù a-vicher</li>
<li>Kevredigezhioù</li>
<li>Familhoù</li>
<li>Skolioù</li>
<li>Raktresoù personel</li>
</ul>
Hizivait dre PayPal evit kaout ur wiki nevez ouzhpenn evit $4.95 ar miz nemetken !',
	'cnw-upgrade-now' => 'Lakaat a-live bremañ',
	'cnw-upgrade-decline' => "N'eo ket dav, kenderc'hel gant ma wiki",
	'cnw-welcome-headline' => "Gourc'hemennoù, krouet hoc'h eus $1",
	'cnw-welcome-instruction1' => "Klikit war ar bouton amañ dindan evit kregiñ da ouzhpennañ pajennoù d'ho wiki.",
	'cnw-welcome-instruction2' => "Gwelet a reot ar bouton-mañ hed-ha-hed ho wiki, grit gantañ bep tro ha ma fello deoc'h ouzhpennañ ur bajenn nevez.",
	'cnw-welcome-help' => 'Kavout a reot respontoù, kuzulioù ha kement zo war <a href="http://community.wikia.com">Kalonenn ar gumuniezh</a>.',
	'cnw-error-general' => "Un dra bennak a zo aet a-dreuz pa veze krouet ho wiki. Mar plij adklaskit diwezhatoc'h.",
	'cnw-error-general-heading' => "Ur fazi 'zo bet e-pad krouidigezh ur wiki nevez",
	'cnw-error-database' => 'Fazi en diaz roadennoù : $1',
	'cnw-badword-msg' => "Ac'hanta, mar plij chomit hep implijout gerioù vil pe difennet e deskrivadur ho wiki : $1",
	'cnw-error-wiki-limit-header' => 'Bevenn ar wikioù bet tizhet',
	'cnw-error-wiki-limit' => "Ac'hanta, bevennet eo ar c'hrouiñ wikioù da $1 wiki dre zen ha dre zevezh. Gortozit 24 eurvezh a-benn gellout krouiñ unan all.", # Fuzzy
	'cnw-error-blocked-header' => 'Kont stanket',
);

/** Czech (česky)
 * @author Chmee2
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
	'cnw-name-wiki-wiki' => 'Wiki',
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
	'cnw-desc-headline' => 'O čem je vaše wiki?',
	'cnw-desc-creative' => 'Popište vaše téma',
	'cnw-desc-tip1' => 'Tip',
	'cnw-desc-tip2' => 'Pššt',
	'cnw-desc-choose' => 'Zvolte kategorii',
	'cnw-desc-select-one' => 'Jeden vyberte',
	'cnw-desc-change-lang' => 'změnit',
	'cnw-desc-lang' => 'Jazyk',
	'cnw-theme-headline' => 'Zvolte téma',
	'cnw-error-database' => 'Chyba databáze: $1',
	'cnw-error-wiki-limit-header' => 'Dosažen limit Wiki',
	'cnw-error-blocked-header' => 'Účet zablokován',
);

/** German (Deutsch)
 * @author Claudia Hattitten
 * @author Dennis07
 * @author Geitost
 * @author George Animal
 * @author LWChris
 * @author Quedel
 * @author Tiin
 */
$messages['de'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Assistent zum Erstellen eines Wikis]]',
	'cnw-next' => 'Nächste',
	'cnw-back' => 'Zurück',
	'cnw-or' => 'oder',
	'cnw-title' => 'Neues Wiki erstellen',
	'cnw-name-wiki-headline' => 'Ein Wiki starten',
	'cnw-name-wiki-creative' => 'Wikia ist der beste Ort, um rund um dein Lieblingsthema eine Website aufzubauen und eine Community wachsen zu lassen.',
	'cnw-name-wiki-label' => 'Benenne dein Wiki',
	'cnw-name-wiki-wiki' => 'Wiki',
	'cnw-name-wiki-domain-label' => 'Gib deinem Wiki eine Adresse',
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
	'cnw-userauth-marketing-body' => 'Du benötigst ein Benutzerkonto auf Wikia. Nach einer Minute bist du bereits [[Special:UserSignup|Mitglied]]!',
	'cnw-userauth-signup-button' => 'Registrieren',
	'cnw-desc-headline' => 'Worum geht es in deinem Wiki?',
	'cnw-desc-creative' => 'Beschreibe dein Thema',
	'cnw-desc-placeholder' => 'Dies wird auf der Hauptseite deines Wikis erscheinen.',
	'cnw-desc-tip1' => 'Tipp',
	'cnw-desc-tip1-creative' => 'Nutze dieses Feld, um den Leuten dein Wiki in ein oder zwei Sätzen vorzustellen',
	'cnw-desc-tip2' => 'Psst',
	'cnw-desc-tip2-creative' => 'Gib deinen Besuchern ein paar spezifische Details zu deinem Thema',
	'cnw-desc-tip3' => 'Profi Tipp',
	'cnw-desc-tip3-creative' => 'Lass die Leute wissen, dass sie deinem Wiki durch Bearbeiten und Hinzufügen von Seiten dabei helfen können zu wachsen',
	'cnw-desc-choose' => 'Eine Kategorie auswählen',
	'cnw-desc-select-one' => 'Bitte wählen',
	'cnw-desc-default-lang' => 'Die Sprache deines Wikis wird $1',
	'cnw-desc-change-lang' => 'ändern',
	'cnw-desc-lang' => 'Sprache',
	'cnw-desc-wiki-submit-error' => 'Bitte wähle eine Kategorie',
	'cnw-theme-headline' => 'Wähle ein Theme',
	'cnw-theme-creative' => 'Wähle unten ein Theme, du wirst eine Vorschau jedes Themes sehen sobald du es auswählst.',
	'cnw-theme-instruction' => 'Du kannst später auch dein eigenes Theme entwerfen, indem du auf "Werkzeugkasten" klickst.',
	'cnw-upgrade-headline' => 'Möchtest du ein Upgrade?',
	'cnw-upgrade-creative' => 'Ein Upgrade auf Wikia Plus ermöglicht es dir, Anzeigen von <span class="wiki-name"></span> zu entfernen, ein einmaliges Angebot, nur für neue Gründer verfügbar.',
	'cnw-upgrade-marketing' => 'Wikia Plus ist eine großartige Lösung für:<ul>
<li>Professionelle Wikis</li>
<li>Nicht kommerzielle</li>
<li>Familien</li>
<li>Schulen</li>
<li>Persönliche Projekte</li>
</ul>
Upgrade mit PayPal um ein werbefreies Wiki für nur $4,95 pro Monat zu bekommen!',
	'cnw-upgrade-now' => 'Jetzt upgraden',
	'cnw-upgrade-decline' => 'Nein danke, weiter zu meinem Wiki',
	'cnw-welcome-headline' => 'Herzlichen Glückwunsch! $1 wurde erstellt',
	'cnw-welcome-instruction1' => 'Klick auf die Schaltfläche unten, um Seiten zu deinem Wiki hinzufügen.',
	'cnw-welcome-instruction2' => 'Du wirst diese Schaltfläche in deinem ganzen Wiki sehen, nutze sie jedes Mal wenn du eine neue Seite hinzufügen willst.',
	'cnw-welcome-help' => 'Finde Antworten, Ratschläge und mehr auf <a href="http://community.wikia.com">Community Central</a>.',
	'cnw-error-general' => 'Bei der Erstellung deines Wikis ist etwas schief gelaufen. Bitte versuche es später erneut.',
	'cnw-error-general-heading' => 'Neues Wiki Erstellen Fehler',
	'cnw-error-database' => 'Datenbank-Fehler: $1',
	'cnw-badword-header' => 'Ganz ruhig',
	'cnw-badword-msg' => 'Hallo, bitte verwende keines der folgenden Schimpfwörter oder unerlaubten Begriffe in deiner Wiki-Beschreibung: $1',
	'cnw-error-wiki-limit-header' => 'Wiki Limit erreicht',
	'cnw-error-wiki-limit' => 'Hallo, du darfst nur {{PLURAL:$1|ein Wiki|$1 Wikis}} am Tag gründen. Warte 24 Stunden, bevor du ein weiteres Wiki gründest.',
	'cnw-error-blocked-header' => 'Konto gesperrt',
	'cnw-error-blocked' => 'Du wurdest von $1 gesperrt. Die Begründung lautet: $2. (Block-ID zu Referenzzwecken: $3)',
	'cnw-error-torblock' => 'Das Erstellen von Wikis über das Tor-Netzwerk ist nicht erlaubt.',
	'cnw-error-bot' => 'Wir haben festgestellt, dass dies wahrscheinlich ein Bot-Account ist. Wenn wir damit falsch liegen, kontaktiere uns bitte mit dem Hinweis, dass wir dich fälschlicherweise als Bot festgestellt haben. Dann können wir dir helfen. [http://www.wikia.com/Special:Contact/general Kontaktformular]',
	'cnw-error-bot-header' => 'Du wurdest als Bot identifiziert.',
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
 * @author Mirzali
 */
$messages['diq'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Wikiyo newe vırazdar]]',
	'cnw-next' => 'Ver şo',
	'cnw-back' => 'Peyser',
	'cnw-or' => 'ya na',
	'cnw-title' => 'Wikiyo newe vıraze',
	'cnw-name-wiki-headline' => 'Wikiyo newe pêkerdış',
	'cnw-name-wiki-label' => 'Namey wiki da şıma',
	'cnw-name-wiki-wiki' => 'Wiki',
	'cnw-login' => 'Qeyd be',
	'cnw-signup' => 'Hesab Vıraze',
	'cnw-signup-prompt' => 'Hesabê şıma çıniyo?',
	'cnw-call-to-signup' => 'Tiya qeyd bê',
	'cnw-login-prompt' => 'Xora yew hesabê şıma esto?',
	'cnw-call-to-login' => 'Tiya cı kewê',
	'cnw-auth-headline' => 'Qeyd vıraze',
	'cnw-auth-headline2' => 'Deqew de',
	'cnw-auth-facebook-signup' => 'Ebe Facebook cı kewê',
	'cnw-auth-facebook-login' => "Facebook'i sera cıkewtış",
	'cnw-userauth-headline' => 'Yew hesabê şıma esto?',
	'cnw-userauth-creative' => 'Ronıştış akerê',
	'cnw-userauth-signup-button' => 'Hesabo Newe Ake',
	'cnw-desc-tip2' => 'Psst',
	'cnw-desc-select-one' => 'Yewi weçine',
	'cnw-desc-change-lang' => 'bıvurne',
	'cnw-desc-lang' => 'Zıwan',
	'cnw-desc-wiki-submit-error' => 'Reca kenime, yew kategoriye weçine',
	'cnw-theme-headline' => 'tema weçinê',
	'cnw-upgrade-headline' => 'Şıma qayılê ke berz kerê?',
	'cnw-upgrade-marketing' => 'Qandê Wikia Plusi rê tewr zaf aguznayış:<ul>
<li>Wikiyê Profesyoneli</li>
<li>Nê-kari</li>
<li>Kufleti</li>
<li>Mektebi</li>
<li>Proceyê şexsiy</li>
</ul>
Aşme de tenya 4,95 $ gırewtışê wikiyê bêreklami be PayPali berz ke!',
	'cnw-upgrade-now' => 'Nıka berz ke',
	'cnw-error-database' => 'Datay $1 qedya',
	'cnw-badword-header' => 'Oha',
	'cnw-error-wiki-limit-header' => 'Reşt sinorê wikiy',
	'cnw-error-blocked-header' => 'Hesab biyo kılit',
);

/** Spanish (español)
 * @author Benfutbol10
 * @author Ciencia Al Poder
 * @author Geitost
 * @author VegaDark
 */
$messages['es'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Asistente de creación de wikis]]',
	'cnw-next' => 'Siguiente',
	'cnw-back' => 'Atrás',
	'cnw-or' => 'o',
	'cnw-title' => 'Crear un nuevo wiki',
	'cnw-name-wiki-headline' => 'Comenzar una wiki',
	'cnw-name-wiki-creative' => 'Wikia es el mejor sitio para construir un sitio web y hacer crecer una comunidad en torno a lo que te gusta.',
	'cnw-name-wiki-label' => 'Nombre de tu wiki',
	'cnw-name-wiki-wiki' => 'Wiki',
	'cnw-name-wiki-domain-label' => 'Dale a tu wiki una dirección',
	'cnw-name-wiki-submit-error' => '¡Oops! Asegúrate que todos los campos estén rellenados con las entradas válidas anteriores.',
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
	'cnw-userauth-marketing-body' => 'Necesitas una cuenta para crear un wiki en Wikia. ¡Solo tardas un minuto en [[Special:UserSignup|registrarte]]!',
	'cnw-userauth-signup-button' => 'Registrarse',
	'cnw-desc-headline' => '¿De qué trata tu wiki?',
	'cnw-desc-creative' => 'Describe el tema',
	'cnw-desc-placeholder' => 'Esto aparecerá en la página principal de tu wiki.',
	'cnw-desc-tip1' => 'Sugerencia',
	'cnw-desc-tip1-creative' => 'Dile a la gente de qué trata tu wiki',
	'cnw-desc-tip2' => 'Consejo 2',
	'cnw-desc-tip2-creative' => 'Asegúrate de incluir detalles',
	'cnw-desc-tip3' => 'Consejo 3',
	'cnw-desc-tip3-creative' => 'Invita a la gente para que ayude a editar',
	'cnw-desc-choose' => 'Elige una categoría',
	'cnw-desc-select-one' => 'Selecciona una',
	'cnw-desc-default-lang' => 'Tu wiki será en $1',
	'cnw-desc-change-lang' => 'cambiar',
	'cnw-desc-lang' => 'Idioma',
	'cnw-desc-wiki-submit-error' => 'Por favor, elige una categoría',
	'cnw-theme-headline' => 'Diseña tu wiki',
	'cnw-theme-creative' => 'Escoge un tema que se ajuste a tu wiki.',
	'cnw-theme-instruction' => 'Puedes cambiar el tema o diseñar tu propio en cualquier momento usando "Mis Herramientas" situada en la barra de herramientas en la parte inferior de la página.',
	'cnw-upgrade-headline' => '¿Deseas actualizar?',
	'cnw-upgrade-creative' => 'Actualizarte a Wikia Plus te permite eliminar la publicidad de <span class="wiki-name"></span>, oferta única disponible a los nuevos fundadores',
	'cnw-upgrade-marketing' => 'Wikia Plus es una gran solución para:<ul>
<li>Wiki profesionales</li>
<li>Sin fines de lucro</li>
<li>Familias</li>
<li>Escuelas</li>
<li>Proyectos personales</li>
</ul>
Actualizar a través de PayPal para conseguir una wiki sin publicidad ¡por solo $4.95 al mes!',
	'cnw-upgrade-now' => 'Actualizar ahora',
	'cnw-upgrade-decline' => 'No, gracias, ir a mi wiki',
	'cnw-welcome-headline' => '¡Enhorabuena! Has creado $1',
	'cnw-welcome-instruction1' => 'Ahora haz clic al botón de abajo para empezar a llenar tu wiki con información.',
	'cnw-welcome-instruction2' => 'Verás este botón a través de tu wiki. Úsalo en cualquier momento cuando quieras agregar una página nueva.',
	'cnw-welcome-help' => 'Encuentra respuestas, consejos, y más en la <a href="http://es.wikia.com">Comunidad Central</a>.',
	'cnw-error-general' => 'Algo salió mal al crear tu wiki. Por favor, inténtalo de nuevo más tarde.',
	'cnw-error-general-heading' => 'Error',
	'cnw-error-database' => 'Error en la base de datos: $1',
	'cnw-badword-header' => '¡Oops!',
	'cnw-badword-msg' => 'Hola, por favor abstente de usar estas malas palabras o palabras prohibidas en la descripción de tu wiki: $1',
	'cnw-error-wiki-limit-header' => 'Has alcanzado el límite de wikis',
	'cnw-error-wiki-limit' => 'Hola, estás limitado a {{PLURAL:$1|$1 creación|$1 creaciones}} de wikis por día. Espera 24 horas antes de crear otro wiki.',
	'cnw-error-blocked-header' => 'Cuenta bloqueada',
	'cnw-error-blocked' => 'Tu usuario ha sido bloqueado por $1. El motivo proporcionado fue: $2. (Identificador del bloqueo para referencia: $3)',
	'cnw-error-torblock' => 'No está permitido crear wikis a través de la red Tor.',
	'cnw-error-bot' => 'Hemos detectado que puedes ser un bot. Si hemos cometido un error, por favor contáctanos y describe que has sido detectado como si fueras un bot y te ayuderamos en crear tu wiki: [http://www.wikia.com/Special:Contact/general Contáctanos]',
	'cnw-error-bot-header' => 'Has sido detectado como un bot',
);

/** Basque (euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'cnw-next' => 'Hurrengoa',
	'cnw-back' => 'Atzera',
	'cnw-or' => 'edo',
	'cnw-name-wiki-wiki' => 'Wikia',
	'cnw-desc-lang' => 'Hizkuntza',
);

/** Persian (فارسی)
 * @author BlueDevil
 */
$messages['fa'] = array(
	'cnw-login' => 'ورود به سامانه',
	'cnw-signup' => 'ایجاد حساب جدید',
	'cnw-auth-headline' => 'ورود به سامانه',
	'cnw-auth-headline2' => 'ثبت نام',
	'cnw-desc-tip1' => 'راهنمایی',
);

/** Finnish (suomi)
 * @author Ilkea
 * @author Lukkipoika
 * @author Tofu II
 * @author VezonThunder
 */
$messages['fi'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Ohjattu wikin luonti]]',
	'cnw-next' => 'Seuraava',
	'cnw-back' => 'Takaisin',
	'cnw-or' => 'tai',
	'cnw-title' => 'Luo uusi Wiki',
	'cnw-name-wiki-headline' => 'Perusta Wiki',
	'cnw-name-wiki-creative' => 'Wikia on paras paikka rakentaa nettisivu ja kasvattaa yhteisö sen ympärille.',
	'cnw-name-wiki-label' => 'Nimeä wikisi',
	'cnw-name-wiki-wiki' => 'Wiki',
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
	'cnw-userauth-marketing-body' => 'Tarvitset käyttäjätunnuksen, jotta voit luoda wikin Wikia:n. [[Special:UserSignup|Rekisteröityminen]] vie vain hetken!',
	'cnw-userauth-signup-button' => 'Rekisteröidy',
	'cnw-desc-headline' => 'Mistä wikisi kertoo?',
	'cnw-desc-creative' => 'Kuvaile aihettasi',
	'cnw-desc-placeholder' => 'Tämä ilmestyy wikisi etusivulle.',
	'cnw-desc-tip1' => 'Vihje',
	'cnw-desc-tip1-creative' => 'Käytä tämä tila kertomaan ihmisille wikistäsi parilla lauseella',
	'cnw-desc-tip2' => 'Psst',
	'cnw-desc-tip2-creative' => 'Kerro vierailijoille jotain erityisiä tietoja aiheestasi',
	'cnw-desc-tip3' => 'Ammattilaisvinkki',
	'cnw-desc-tip3-creative' => 'Kerro ihmisille miten he voivat auttaa wikiäsi kasvamaan muokkaamalla ja lisäämällä sivuja',
	'cnw-desc-choose' => 'Valitse kategoria',
	'cnw-desc-select-one' => 'Valitse yksi',
	'cnw-desc-default-lang' => 'Wikisi kieli tulee olemaan $1',
	'cnw-desc-change-lang' => 'vaihda',
	'cnw-desc-lang' => 'Kieli',
	'cnw-desc-wiki-submit-error' => 'Valitse luokka',
	'cnw-theme-headline' => 'Valitse teema',
	'cnw-theme-creative' => 'Valitse alta teema, näet esikatselun jokaisesta teemasta kun valitset sen.',
	'cnw-theme-instruction' => 'Pystyt myös suunnittelemaan oman teema myöhemmin menemällä "Omiin työkaluihin".',
	'cnw-upgrade-headline' => 'Haluatko päivittää?',
	'cnw-upgrade-creative' => 'Päivittämällä Wikia Plus:san pystyt poistamaan mainokset <span class="wiki-name"></span>, ainutkertainen mahdollisuus ainoastaan uusille perustajille.',
	'cnw-upgrade-marketing' => 'Wikia Plus on hyvä valinta:<ul>
<li>Ammattilais-Wikeille</li>
<li>Voittoatavoittelemattomille</li>
<li>Perheille</li>
<li>Kouluille</li>
<li>Yksityisille projekteille</li>
</ul>
Päivitä PayPal avulla saadaksesi mainoksettoman wikin ainoastaan $4.95 kuukaudessa!',
	'cnw-upgrade-now' => 'Päivitä nyt',
	'cnw-upgrade-decline' => 'Ei kiitos, jatka wikiini',
	'cnw-welcome-headline' => 'Onnittelut! $1 on luotu',
	'cnw-welcome-instruction1' => 'Klikkaa painiketta alta aloittaaksesi sivujen lisäämisen wikiisi.',
	'cnw-welcome-instruction2' => 'Näet tämän painikkeen joka puolella wikissäsi, käytä sitä kun haluat lisätä uuden sivun.',
	'cnw-welcome-help' => 'Löydä vastauksia, neuvoa, ja muuta <a href="http://community.wikia.com">Community Central:sta</a>',
	'cnw-error-general' => 'Jokin meni vikaan wikin luonnissasi. Yritä uudestaan myöhemmin.',
	'cnw-error-general-heading' => 'Virhe uuden wikin luonnissa',
	'cnw-error-database' => 'Tietokanta virhe: $1',
	'cnw-badword-header' => 'Hei siellä',
	'cnw-badword-msg' => 'Hei, vältä käyttämästä näitä rumia sanoja tai kiellettyjä sanoja Wikisi kuvauksesta: $1',
	'cnw-error-wiki-limit-header' => 'Wikien enimmäis määrä saavutettu',
	'cnw-error-wiki-limit' => 'Hei, olet rajoitettu luomaan {{PLURAL:$1|$1 wikin|$1 wikiä}} päivässä. Odota 24 tuntia ennen wikin luontia.',
	'cnw-error-blocked-header' => 'Käyttäjätunnus estetty',
	'cnw-error-blocked' => '$1 esti sinut. Syy oli: $2. (Eston ID valitusta varten: $3)',
	'cnw-error-torblock' => 'Wikin luonti Tor-verkkoa käyttäen ei ole sallittu.',
	'cnw-error-bot' => 'Havaitsimme että voit olla botti. Jos olemme tehneet virheen, ota yhteyttä kertoen että sinut on virheellisesti havaittu botiksi, ja me avustamme wikisi luonnissa: [http://www.wikia.com/Special:Contact/general Ota yhteyttä]',
	'cnw-error-bot-header' => 'Sinut on havaittu botiksi',
);

/** French (français)
 * @author Gomoko
 * @author Od1n
 * @author Peter17
 * @author Verdy p
 * @author Wyz
 */
$messages['fr'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Assistant de création de wiki]]',
	'cnw-next' => 'Suite',
	'cnw-back' => 'Retour',
	'cnw-or' => 'ou',
	'cnw-title' => 'Créer un nouveau wiki',
	'cnw-name-wiki-headline' => 'Commencer un wiki',
	'cnw-name-wiki-creative' => 'Wikia est le meilleur endroit pour construire un site Web et monter une communauté autour de ce que vous aimez.',
	'cnw-name-wiki-label' => 'Nommez votre wiki',
	'cnw-name-wiki-wiki' => 'Wiki',
	'cnw-name-wiki-domain-label' => 'Donnez une adresse à votre wiki',
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
	'cnw-userauth-marketing-body' => "Vous avez besoin d'un compte pour créer un wiki sur Wikia. Il suffit d'une minute pour [[Special:UserSignup|s'inscrire]]!",
	'cnw-userauth-signup-button' => "S'inscrire",
	'cnw-desc-headline' => 'De quoi parle votre wiki ?',
	'cnw-desc-creative' => 'Décrivez le sujet',
	'cnw-desc-placeholder' => 'Ceci apparaîtra sur la page d’accueil de votre wiki.',
	'cnw-desc-tip1' => 'Astuce',
	'cnw-desc-tip1-creative' => 'Utilisez ceci pour indiquer de quoi parle votre wiki en une phrase ou deux',
	'cnw-desc-tip2' => 'Psst',
	'cnw-desc-tip2-creative' => 'Donnez à vos visiteurs quelques détails spécifiques à propos du sujet',
	'cnw-desc-tip3' => 'Conseil d’expert',
	'cnw-desc-tip3-creative' => 'Faites savoir aux gens qu’ils peuvent aider à faire grandir votre wiki en modifiant ou en ajoutant des pages',
	'cnw-desc-choose' => 'Choisissez une catégorie',
	'cnw-desc-select-one' => 'Sélectionnez-en une',
	'cnw-desc-default-lang' => 'Votre wiki sera en $1',
	'cnw-desc-change-lang' => 'modifier',
	'cnw-desc-lang' => 'Langue',
	'cnw-desc-wiki-submit-error' => 'Veuillez choisir une catégorie',
	'cnw-theme-headline' => 'Choisissez un thème',
	'cnw-theme-creative' => 'Choisissez un thème ci-dessous, vous pourrez voir un aperçu de chaque thème lorsque vous le sélectionnerez.',
	'cnw-theme-instruction' => 'Vous pouvez aussi concevoir votre propre thème plus tard via « Mes outils ».',
	'cnw-upgrade-headline' => 'Souhaitez-vous mettre à niveau ?',
	'cnw-upgrade-creative' => 'Mettre à niveau vers Wikia Plus vous permet de retirer les publicités de <span class="wiki-name"></span>, une offre unique disponible uniquement aux nouveaux fondateurs.',
	'cnw-upgrade-marketing' => 'Wikia Plus est une solution idéale pour :<ul>
<li>Les wikis professionnels</li>
<li>Les projets à but non lucratif</li>
<li>Les familles</li>
<li>Les écoles</li>
<li>Les projets personnels</li>
</ul>
Mettez à niveau via PayPal pour obtenir un wiki sans publicité pour seulement 4,95 $ par mois !',
	'cnw-upgrade-now' => 'Mettre à niveau maintenant',
	'cnw-upgrade-decline' => 'Non merci, continuer vers mon wiki',
	'cnw-welcome-headline' => 'Félicitations ! $1 a été créé.',
	'cnw-welcome-instruction1' => 'Cliquez sur le bouton ci-dessous pour commencer à ajouter des pages à votre wiki.',
	'cnw-welcome-instruction2' => 'Vous verrez ce bouton partout sur votre wiki, utilisez-le chaque fois que vous souhaitez ajouter une nouvelle page.',
	'cnw-welcome-help' => 'Trouvez des réponses, conseils et plus sur sur <a href="http://community.wikia.com">Community Central</a>.',
	'cnw-error-general' => 'Quelque chose s’est mal passé lors de la création de votre wiki. Veuillez réessayer plus tard.',
	'cnw-error-general-heading' => 'Erreur lors de la création d’un nouveau wiki',
	'cnw-error-database' => 'Erreur de base de données : $1',
	'cnw-badword-header' => 'Eh Oh',
	'cnw-badword-msg' => 'Bonjour, veuillez éviter d’utiliser des mots grossiers ou interdits dans la description de votre wiki : $1',
	'cnw-error-wiki-limit-header' => 'Limite de wikis atteinte',
	'cnw-error-wiki-limit' => 'Bonjour, vous êtes limité à la création de {{PLURAL:$1|$1 wiki|$1 wikis}} par jour. Attendez 24 heures avant de créer un autre wiki.',
	'cnw-error-blocked-header' => 'Compte bloqué',
	'cnw-error-blocked' => 'Vous avez été bloqué par $1. La raison invoquée était : $2. (ID de blocage pour référence : $3)',
	'cnw-error-torblock' => "Créer des wikis via le réseau Tor n'est pas autorisé.",
	'cnw-error-bot' => 'Nous avons détecté que vous pouvez être un robot. Si nous nous sommes trompés, veuillez nous contacter en indiquant que vous avez été pris à tort pour un robot, nous vous aiderons alors à créer votre wiki : [http://www.wikia.com/Special:Contact/general Nous contacter].',
	'cnw-error-bot-header' => 'Vous avez été détecté comme étant un robot',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Asistente para a creación de wikis]]',
	'cnw-next' => 'Seguinte',
	'cnw-back' => 'Volver',
	'cnw-or' => 'ou',
	'cnw-title' => 'Crear un novo wiki',
	'cnw-name-wiki-headline' => 'Comezar un wiki',
	'cnw-name-wiki-creative' => 'Wikia é o mellor sitio para construír unha páxina web e facer medrar unha comunidade ao redor do tema que lle gusta.',
	'cnw-name-wiki-label' => 'Déalle un nome ao seu wiki',
	'cnw-name-wiki-wiki' => 'Wiki',
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
	'cnw-userauth-creative' => 'Acceda ao sistema',
	'cnw-userauth-marketing-heading' => 'Non está rexistrado?',
	'cnw-userauth-marketing-body' => 'Necesita unha conta para crear un wiki en Wikia. Leva un minuto [[Special:UserSignup|rexistrarse]]!',
	'cnw-userauth-signup-button' => 'Rexístrese',
	'cnw-desc-headline' => 'De que vai o seu wiki?',
	'cnw-desc-creative' => 'Describa o seu tema',
	'cnw-desc-placeholder' => 'Isto aparecerá na páxina principal do seu wiki.',
	'cnw-desc-tip1' => 'Suxestión',
	'cnw-desc-tip1-creative' => 'Use este espazo para contar á xente de que vai o wiki nunha ou dúas oracións',
	'cnw-desc-tip2' => 'Consello',
	'cnw-desc-tip2-creative' => 'Dea aos visitantes algúns detalles específicos sobre o tema',
	'cnw-desc-tip3' => 'Consello de experto',
	'cnw-desc-tip3-creative' => 'Faga saber á xente que poden axudar a que medre o wiki editando e engadindo páxinas',
	'cnw-desc-choose' => 'Seleccione unha categoría',
	'cnw-desc-select-one' => 'Seleccione unha',
	'cnw-desc-default-lang' => 'O seu wiki será en $1',
	'cnw-desc-change-lang' => 'cambiar',
	'cnw-desc-lang' => 'Lingua',
	'cnw-desc-wiki-submit-error' => 'Seleccione unha categoría',
	'cnw-theme-headline' => 'Escolla un tema visual',
	'cnw-theme-creative' => 'Escolla un dos temas visuais que hai a continuación; verá unha vista previa do tema cando o seleccione.',
	'cnw-theme-instruction' => 'Tamén pode deseñar o seu propio tema visual máis tarde indo ata "As miñas ferramentas".',
	'cnw-upgrade-headline' => 'Quere realizar a actualización?',
	'cnw-upgrade-creative' => 'Se actualiza a Wikia Plus poderá eliminar os anuncios de <span class="wiki-name"></span>, unha oferta única dispoñible para os novos fundadores.',
	'cnw-upgrade-marketing' => 'Wikia Plus é a solución ideal para:<ul>
<li>Wikis profesionais</li>
<li>Organizacións sen fins de lucro</li>
<li>Familias</li>
<li>Escolas</li>
<li>Proxectos persoais</li>
</ul>
Faga a actualización a través do PayPal para conseguir un wiki libre de anuncios por 4,95$ ao mes!',
	'cnw-upgrade-now' => 'Actualizar agora',
	'cnw-upgrade-decline' => 'Non, grazas. Quero continuar ata o meu wiki',
	'cnw-welcome-headline' => 'Parabéns! Creouse $1',
	'cnw-welcome-instruction1' => 'Prema no botón que hai a continuación para comezar a engadir páxinas ao seu wiki.',
	'cnw-welcome-instruction2' => 'Verá este botón ao longo do wiki; úseo cada vez que queira engadir unha nova páxina.',
	'cnw-welcome-help' => 'Atope respostas, consellos e máis cousas na <a href="http://community.wikia.com">central da comunidade</a>.',
	'cnw-error-general' => 'Algo foi mal durante a creación do seu wiki. Inténteo de novo máis tarde.',
	'cnw-error-general-heading' => 'Erro durante a creación do novo wiki',
	'cnw-error-database' => 'Erro na base de datos: $1',
	'cnw-badword-header' => 'Vaites!',
	'cnw-badword-msg' => 'Por favor, abstéñase de empregar palabras groseiras na descrición do seu wiki: $1',
	'cnw-error-wiki-limit-header' => 'Alcanzouse o límite de wikis',
	'cnw-error-wiki-limit' => 'Desculpe, hai un límite que impide crear máis {{PLURAL:$1|de $1 wiki|de $1 wikis}} ao día. Agarde 24 horas antes de crear outro wiki.',
	'cnw-error-blocked-header' => 'Conta bloqueada',
	'cnw-error-blocked' => 'Foi bloqueado por $1. A razón que deu foi: $2. (ID do bloqueo para referencia: $3)',
	'cnw-error-torblock' => 'Non está permitido crear wikis a través da rede Tor.',
	'cnw-error-bot' => 'Detectamos que pode ser un bot. Se estamos equivocados, póñase en contacto con nós indicando que foi detectado de xeito erróneo como un bot e axudarémolo a crear o seu wiki: [http://www.wikia.com/Special:Contact/general Contacte con nós]',
	'cnw-error-bot-header' => 'Detectamos que é un bot',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author שומבלע
 */
$messages['he'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|אשף יצירת ויקי]]',
	'cnw-next' => 'הבא',
	'cnw-back' => 'הקודם',
	'cnw-or' => 'או',
	'cnw-title' => 'יצירת ויקי חדש',
	'cnw-name-wiki-headline' => 'להתחיל ויקי',
	'cnw-name-wiki-creative' => 'ויקיה – המקום הטוב ביותר לבנות אתר ולטפל קהילה סביב דברים שאתם אוהבים.',
	'cnw-name-wiki-label' => 'שם הוויקי',
	'cnw-name-wiki-wiki' => 'ויקי',
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
	'cnw-desc-headline' => 'על מה הוויקי שלכם?',
	'cnw-desc-creative' => 'תארו את הנושא שלכם',
	'cnw-desc-placeholder' => 'זה יופיע בדף הראשי של הוויקי שלכם.',
	'cnw-desc-tip1' => 'עצה',
	'cnw-desc-tip1-creative' => 'השתמשו במרווח הזה כדי לספר לאנשים על הוויקי שלכם במשפט או שניים',
	'cnw-desc-tip2' => 'אהם־אהם',
	'cnw-desc-tip2-creative' => 'תנו למבקרים שלכם כמה פרטים על הנושא שלכם',
	'cnw-desc-tip3' => 'עצה למקצוענים',
	'cnw-desc-tip3-creative' => 'ספרו לאנשים שהם יכולים לעזור לוויקי לצמוח על ידי עריכה והוספת מידע לדפים',
	'cnw-desc-choose' => 'בחירת קטגוריה',
	'cnw-desc-select-one' => 'לבחור אחת',
	'cnw-desc-default-lang' => 'הוויקי שלכם יהיה ב$1',
	'cnw-desc-change-lang' => 'לשנות',
	'cnw-desc-lang' => 'שפה',
	'cnw-desc-wiki-submit-error' => 'נא לבחור קטגוריה',
	'cnw-theme-headline' => 'נא לבחור ערכת עיצוב',
	'cnw-theme-creative' => 'נא לבחור באחת מערכות העיצוב להלן. אפשר יהיה לראות תצוגה מקדימה של כל ערכה תוך כדי הבחירה.',
	'cnw-theme-instruction' => 'אפשר גם לעצב ערכת עיצוב משלכם דרך "הכלים שלי".',
	'cnw-upgrade-headline' => 'לשדרג?',
	'cnw-upgrade-creative' => 'שדרוג ל־Wikia Plus מאפשר להסיר פרסומות מעל <span class="wiki-name"></span>, הצעה חד־פעמית למייסדי ויקי חדש.',
	'cnw-upgrade-marketing' => 'Wikia Plus – פתרון נהדר בשביל:<ul>
<li>אתרי ויקי מקצועיים</li>
<li>מוסדות ללא כוונת רווח</li>
<li>משפחות</li>
<li>מוסדות חינוך</li>
<li>מיזמים אישיים</li>
</ul>
שדרגו באמצעות פייפאל כדי לקבל ויקי נקי מפרסומות עבוק 4.95 דולר לחודש בלבד!',
	'cnw-upgrade-now' => 'לשדרג עכשיו',
	'cnw-upgrade-decline' => 'לא, תודה, אני רוצה ללכת לוויקי שלי',
	'cnw-welcome-headline' => 'ברכות! הוויקי $1 נוצר',
	'cnw-welcome-instruction1' => 'לחצו על הכפתור להלן כדי להתחיל להוסיף דפים לוויקי שלכם.',
	'cnw-welcome-instruction2' => 'הכפתור הזה יופיע בכל דף בוויקי, אפשר להשתמש בו בכל זמן שאתם רוצים להוסיף עמוד חדש.',
	'cnw-welcome-help' => 'מצאו תשובות, עצות ועוד ב־<a href="http://community.wikia.com">Community Central</a>.',
);

/** Hungarian (magyar)
 * @author Dani
 * @author Dj
 * @author TK-999
 */
$messages['hu'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Wikikészítő varázsló]]',
	'cnw-next' => 'Következő',
	'cnw-back' => 'Vissza',
	'cnw-or' => 'vagy',
	'cnw-title' => 'Új wiki létrehozása',
	'cnw-name-wiki-headline' => 'Wiki indítása',
	'cnw-name-wiki-creative' => 'Wikia a legjobb hely, ha kedvenc témádnak egy új weboldalt akarsz készíteni, és közösséget építeni hozzá.',
	'cnw-name-wiki-label' => 'A wiki neve',
	'cnw-name-wiki-wiki' => 'Wiki',
	'cnw-name-wiki-domain-label' => 'Adj a wikinek egy címet',
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
	'cnw-userauth-marketing-body' => 'Felhasználói fiókra van szükséged, hogy wikit hozhass létre a Wikián. Csak egy percbe telik a [[Special:UserSignup|regisztráció]]!',
	'cnw-userauth-signup-button' => 'Regisztráció',
	'cnw-desc-headline' => 'Miről szól a wiki?',
	'cnw-desc-creative' => 'Írd körül a témát',
	'cnw-desc-placeholder' => 'Ez a wiki kezdőlapján fog megjelenni.',
	'cnw-desc-tip1' => 'Tipp',
	'cnw-desc-tip1-creative' => 'Itt egy-két mondatban mesélj az wikidről az idelátogató embereknek',
	'cnw-desc-tip2' => 'Pszt',
	'cnw-desc-tip2-creative' => 'Közölj a látogatókkal valami egyedi részletet a témádról',
	'cnw-desc-tip3' => 'Profi tipp',
	'cnw-desc-tip3-creative' => 'Tudasd az emberekkel, hogy szerkesztéssel és új lapok létrehozásával segíthetnek a wikid növekedésében',
	'cnw-desc-choose' => 'Válassz egy kategóriát',
	'cnw-desc-select-one' => 'Válassz egyet',
	'cnw-desc-default-lang' => 'A wikid a $1 kategóriába lesz',
	'cnw-desc-change-lang' => 'módosítás',
	'cnw-desc-lang' => 'Nyelv',
	'cnw-desc-wiki-submit-error' => 'Válassz egy kategóriát',
	'cnw-theme-headline' => 'Válassz egy témát',
	'cnw-theme-creative' => 'Válassz az alábbi témák közöl. Ha kiválasztasz egy témát, akkor annak látható lesz az előnézeti képe.',
	'cnw-theme-instruction' => 'Saját stílusodat később is megtervezheted a "My Tools" eszköztáron keresztül.',
	'cnw-upgrade-headline' => 'Szeretnél frissíteni?',
	'cnw-upgrade-creative' => 'A Wikia Plus szolgáltatásra váltás lehetővé teszi a hirdetések eltávolítását a <span class="wiki-name"></span> wikiről; ez egy egyszeri lehetőség csak új alapítók számára.',
	'cnw-upgrade-marketing' => 'A Wikia Plus remek megoldás:<ul>
<li>professzionális wikinek,</li>
<li>nonprofit szervezeteknek,</li>
<li>családoknak,</li>
<li>iskoláknak,</li>
<li>személyes projekteknek.</li>
</ul>
Válts a PayPal használatával, hogy havi 4.95 dollárért hirdetésmentes wikit kapj!',
	'cnw-upgrade-now' => 'Válts most',
	'cnw-upgrade-decline' => 'Nem, köszönöm, menjen tovább a wikihez',
	'cnw-welcome-headline' => 'Gratulálunk!A(z) $1 létrehozása sikerült.',
	'cnw-welcome-instruction1' => 'Kattints a lenti gombra, hogy elkezdd a lapok hozzáadását a wikidhez.',
	'cnw-welcome-instruction2' => 'Ezt a gombot wiki-szerte láthatod, és bármikor használhatod új lap létrehozásához.',
	'cnw-welcome-help' => 'Keress válaszokat, tanácsot és sok mást a <a href="http://community.wikia.com">Community Central</a> wikin.',
	'cnw-error-general' => 'Valami hiba történt a wikid létrehozása közben. Kérlek, próbáld újra később.',
	'cnw-error-general-heading' => 'Hiba új wiki létrehozásakor',
	'cnw-error-database' => 'Adatbázis hiba: $1',
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

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Assistente pro crear wikis]]',
	'cnw-next' => 'Sequente',
	'cnw-back' => 'Retornar',
	'cnw-or' => 'o',
	'cnw-title' => 'Crear nove wiki',
	'cnw-name-wiki-headline' => 'Comenciar un wiki',
	'cnw-name-wiki-creative' => 'Wikia es le optime loco pro construer un sito web e cultivar un communitate circa lo que tu ama.',
	'cnw-name-wiki-label' => 'Nomina tu wiki',
	'cnw-name-wiki-wiki' => 'Wiki',
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
	'cnw-userauth-marketing-body' => 'Un conto es necessari pro crear un wiki in Wikia. Il prende solmente un minuta [[Special:UserSignup|crear un conto]]!',
	'cnw-userauth-signup-button' => 'Crear un conto',
	'cnw-desc-headline' => 'Que es le thema de tu wiki?',
	'cnw-desc-creative' => 'Describe tu topico',
	'cnw-desc-placeholder' => 'Isto apparera in le pagina principal de tu wiki.',
	'cnw-desc-tip1' => 'Consilio',
	'cnw-desc-tip1-creative' => 'Usa iste spatio pro explicar le thema de tu wiki al visitatores in un phrase o duo',
	'cnw-desc-tip2' => 'Psst',
	'cnw-desc-tip2-creative' => 'Specifica al visitatores alcun detalios a proposito de tu thema',
	'cnw-desc-tip3' => 'Consilio extra',
	'cnw-desc-tip3-creative' => 'Dice al gente que illes pote adjutar tu wiki a crescer per modificar e adder paginas',
	'cnw-desc-choose' => 'Selige un categoria',
	'cnw-desc-select-one' => 'Selige un',
	'cnw-desc-default-lang' => 'Tu wiki essera in $1',
	'cnw-desc-change-lang' => 'cambiar',
	'cnw-desc-lang' => 'Lingua',
	'cnw-desc-wiki-submit-error' => 'Per favor selige un categoria',
	'cnw-theme-headline' => 'Designar tu wiki',
	'cnw-theme-creative' => 'Selige un apparentia hic infra. Tu videra un previsualisation de cata apparentia quando tu lo selige.',
	'cnw-theme-instruction' => 'Es equalmente possibile designar tu proprie apparentia usante "Mi instrumentos".',
	'cnw-upgrade-headline' => 'Vole tu actualisar?',
	'cnw-upgrade-creative' => 'Le actualisation a Wikia Plus permitte remover le publicitate de <span class="wiki-name"></span>. Iste offerta es disponibile solmente pro le nove fundatores.',
	'cnw-upgrade-marketing' => 'Wikia Plus es un ideal solution pro:<ul>
<li>Wikis professional</li>
<li>Organisationes sin scopo lucrative</li>
<li>Familias</li>
<li>Scholas</li>
<li>Projectos personal</li>
</ul>
Compra le actualisation per PayPal pro obtener un wiki sin publicitate pro solmente 4,95$ per mense!',
	'cnw-upgrade-now' => 'Actualisar ora',
	'cnw-upgrade-decline' => 'No gratias, continuar a mi wiki',
	'cnw-welcome-headline' => 'Felicitationes, tu ha create $1',
	'cnw-welcome-instruction1' => 'Clicca sur le button hic infra pro comenciar a adder paginas a tu wiki.',
	'cnw-welcome-instruction2' => 'Tu videra iste button ubique in tu wiki. Usa lo cata vice que tu vole adder un nove pagina.',
	'cnw-welcome-help' => 'Trova responsas, consilios e plus in <a href="http://community.wikia.com">le centro del communitate</a>.',
	'cnw-error-general' => 'Qualcosa errava durante le creation de tu wiki. Per favor reproba plus tarde.',
	'cnw-error-general-heading' => 'Error de creation de nove wiki',
	'cnw-error-database' => 'Error del base de datos: $1',
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

/** Ingush (ГӀалгӀай)
 * @author Sapral Mikail
 */
$messages['inh'] = array(
	'cnw-name-wiki-wiki' => 'ВIикIи',
);

/** Italian (italiano)
 * @author Lexaeus 94
 * @author Minerva Titani
 */
$messages['it'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Procedura guidata per la creazione di una wiki]]',
	'cnw-next' => 'Avanti',
	'cnw-back' => 'Indietro',
	'cnw-or' => 'o',
	'cnw-title' => 'Crea una nuova wiki',
	'cnw-name-wiki-headline' => 'Crea una wiki',
	'cnw-name-wiki-creative' => 'Wikia è il posto migliore per costruire un sito web e far crescere una community intorno a ciò che ti piace.',
	'cnw-name-wiki-label' => 'Dai un nome alla tua wiki',
	'cnw-name-wiki-wiki' => 'Wiki',
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
	'cnw-userauth-marketing-body' => 'È necessario avere un account per continuare a costruire la tua wiki. <br />Ci vuole solo un minuto per [[Special:UserSignup|registrarsi]]!',
	'cnw-userauth-signup-button' => 'Registrati',
	'cnw-desc-headline' => "Qual è l'argomento della tua wiki?",
	'cnw-desc-creative' => 'Descrivi il tuo argomento',
	'cnw-desc-placeholder' => 'Questo testo apparirà nella pagina principale della tua wiki.',
	'cnw-desc-tip1' => 'Suggerimento',
	'cnw-desc-tip1-creative' => 'Utilizza questo spazio per descrivere alle persone la tua wiki con poche parole',
	'cnw-desc-tip2' => 'Psst',
	'cnw-desc-tip2-creative' => 'Fornisci ai visitatori alcuni dettagli specifici sul tuo argomento',
	'cnw-desc-tip3' => 'Suggerimento avanzato',
	'cnw-desc-tip3-creative' => 'Fai sapere alle persone che possono aiutarti a far crescere la wiki creando e modificando le pagine',
	'cnw-desc-choose' => 'Scegli una categoria',
	'cnw-desc-select-one' => 'Seleziona',
	'cnw-desc-default-lang' => 'La tua wiki sarà in $1',
	'cnw-desc-change-lang' => 'Cambia',
	'cnw-desc-lang' => 'Lingua',
	'cnw-desc-wiki-submit-error' => 'Per favore scegli una categoria',
	'cnw-theme-headline' => 'Scegli un tema',
	'cnw-theme-creative' => "Scegli uno dei temi qui sotto. Puoi vedere l'anteprima di ogni tema quando lo selezioni.",
	'cnw-theme-instruction' => 'Puoi anche creare il tuo tema personalizzato più avanti tramite "I miei strumenti".',
	'cnw-upgrade-headline' => "Vuoi effettuare l'aggiornamento?",
	'cnw-upgrade-creative' => 'L\'aggiornamento a Wikia Plus ti permette di rimuovere la pubblicità da <span class="wiki-name"></span>; si tratta di un\'offerta disponibile una volta solo per i nuovi fondatori.',
	'cnw-upgrade-marketing' => "Wikia Plus è un'ottima soluzione per:<ul>
<li>Le wiki professionali</li>
<li>Le associazioni no-profit</li>
<li>Le famiglie</li>
<li>Le scuole</li>
<li>I progetti personali</li>
</ul>
Effettua l'aggiornamento tramite PayPal per avere una wiki senza pubblicità a soli 4,95\$ al mese!",
	'cnw-upgrade-now' => "Effettua l'aggiornamento ora",
	'cnw-upgrade-decline' => 'No grazie, voglio continuare con la mia wiki',
	'cnw-welcome-headline' => 'Complimenti! $1 è stata creata',
	'cnw-welcome-instruction1' => 'Clicca il pulsante sottostante per iniziare a creare pagine nella tua wiki.',
	'cnw-welcome-instruction2' => 'Vedrai questo pulsante in tutta la wiki: utilizzalo ogni volta che vuoi creare una nuova pagina.',
	'cnw-welcome-help' => 'Puoi trovare risposte, consigli e altro nella <a href="http://it.community.wikia.com/wiki/Wiki_della_Community">Wiki della Community</a>.',
	'cnw-error-general' => 'Qualcosa è andato storto durante la creazione della tua wiki. Si prega di riprovare più tardi.',
	'cnw-error-general-heading' => 'Errore nella creazione di una nuova wiki',
	'cnw-error-database' => 'Errore del database: $1',
	'cnw-badword-header' => 'Hey!',
	'cnw-badword-msg' => 'Ciao, per favore non utilizzare parole non consone o proibite nella descrizione della tua wiki: $1',
	'cnw-error-wiki-limit-header' => 'Raggiunto il limite di wiki',
	'cnw-error-wiki-limit' => "Ciao, puoi creare un massimo di {{PLURAL:$1|$1 wiki|$1 wiki}} al giorno. Attendi 24 ore prima di creare un'altra wiki.",
	'cnw-error-blocked-header' => 'Account bloccato',
	'cnw-error-blocked' => 'Sei stato bloccato da $1. La motivazione è la seguente: $2. (ID di riferimento del blocco: $3)',
	'cnw-error-torblock' => 'Non è permesso creare wiki tramite la rete Tor.',
	'cnw-error-bot' => 'Ti abbiamo indentificato come un probabile bot. Se si tratta di un errore, per favore contattaci dicendoci che sei stato erroneamente rilevato come bot e ti aiuteremo a creare la tua wiki: [http://www.wikia.com/Special:Contact/general Contattaci]',
	'cnw-error-bot-header' => 'Sei stato identificato come un bot',
);

/** Japanese (日本語)
 * @author Shirayuki
 * @author Tommy6
 * @author Wrightbus
 */
$messages['ja'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|ウィキ作成ウィザード]]',
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
	'cnw-userauth-creative' => 'ログイン',
	'cnw-desc-headline' => 'どんなウィキを作成しますか？',
	'cnw-desc-creative' => 'このウィキでどんな話題を扱うのかを記入してください',
	'cnw-desc-placeholder' => 'ここに入力した内容がメインページに表示されます。',
	'cnw-desc-tip1' => 'ヒント',
	'cnw-desc-tip1-creative' => 'この領域を利用し、訪問者に対してこのウィキがどのようなウィキであるかを1・2文で伝えましょう。',
	'cnw-desc-tip2' => 'ちょっとした補足',
	'cnw-desc-tip2-creative' => 'このウィキが扱う話題について、具体的な内容をいくつか挙げましょう。',
	'cnw-desc-tip3' => '上級',
	'cnw-desc-tip3-creative' => 'さらに、訪問者に対して、あなたもページの編集や作成によってウィキの成長を手助けできるということを伝えましょう。',
	'cnw-desc-choose' => 'カテゴリを選択',
	'cnw-desc-select-one' => '1つを選択',
	'cnw-desc-default-lang' => 'ウィキの言語設定は $1 になっています',
	'cnw-desc-change-lang' => '変更する',
	'cnw-desc-lang' => '言語',
	'cnw-desc-wiki-submit-error' => 'カテゴリを選択してください',
	'cnw-theme-headline' => 'テーマを選択',
	'cnw-theme-creative' => '下の一覧からテーマを選んでください。それぞれのテーマをクリックすると、選択したテーマのプレビューを確認できます。',
	'cnw-theme-instruction' => '後で「マイツール」から独自のテーマをデザインすることもできます。',
	'cnw-welcome-headline' => 'おめでとうございます！ $1 が作成されました',
	'cnw-welcome-instruction1' => '下のボタンをクリックすると、新しいページを作成できます。',
	'cnw-welcome-instruction2' => 'このボタンはウィキ上の様々な場所にも設置されており、いつでも新しいページを作成できます。',
	'cnw-welcome-help' => '助言を求めたいとき、質問したい時などは <a href="http://ja.wikia.com/">Community Central 日本語版</a> までお越しください。',
	'cnw-error-general' => 'ウィキの作成中に問題が発生しました。時間をおいてもう一度お試しください。',
	'cnw-error-general-heading' => 'ウィキ作成エラー',
	'cnw-error-database' => 'データベースエラー: $1',
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
	'cnw-name-wiki-wiki' => 'វិគី',
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
	'cnw-desc-tip3' => 'គន្លឺះថ្នាក់ខ្ពស់',
	'cnw-desc-tip3-creative' => 'អោយអ្នកដទៃបានដឹងថាពួកគេអាចជួយពង្រីកវិគីរបស់អ្នក​តាមរយៈការកែប្រែនិងបន្ថែមទំព័រ',
	'cnw-desc-choose' => 'ជ្រើសរើសចំណាត់ថ្នាក់ក្រុម',
	'cnw-desc-select-one' => 'ជ្រើសរើសមួយ',
	'cnw-desc-default-lang' => 'វិគីរបស់នឹងត្រូវសរសេរជា $1',
	'cnw-desc-change-lang' => 'ផ្លាស់ប្តូរ',
	'cnw-desc-lang' => 'ភាសា',
	'cnw-desc-wiki-submit-error' => 'សូមជ្រើសរើសចំណាត់ថ្នាក់ក្រុមមួយ',
	'cnw-theme-headline' => 'ជ្រើសរើសរចនាបថ',
	'cnw-theme-creative' => 'ជ្រើសរើសរចនាបថខាងក្រោម។ អ្នកនឹងអាចមើលរចនាបថនោះជាមុនពេលដែលជ្រើសរើសវា។',
	'cnw-theme-instruction' => 'អ្នកក៏អាចធ្វើការឌីស្សាញរចនាបថដោយខ្លួនអ្នកនាពេលក្រោយដោយចូលទៅ"ឧបករណ៍"។',
	'cnw-upgrade-decline' => 'ទេ។ បន្តទៅវិគីរបស់ខ្ញុំ',
	'cnw-welcome-headline' => 'សូមអបអរសាទរ! $1 ត្រូវបានបង្កើតហើយ',
	'cnw-welcome-instruction1' => 'ចុចលើប៊ូតុងខាងក្រោមដើម្បីចាប់ផ្ដើមបន្ថែមទំព័រទៅលើវិគីរបស់អ្នក។',
	'cnw-welcome-instruction2' => 'អ្នកនឹងឃើញប៊ូតុងនេះគ្រប់ទីកន្លែងលើវិគីរបស់អ្នក។ សូមប្រើវានៅពេលណាក៏បានដើម្បីបន្ថែមទំព័រថ្មីមួយ។',
	'cnw-welcome-help' => 'រកចំលើយ ដំបូន្មាន និង អ្វីៗបន្ថែមទៀតនៅលើ<a href="http://community.wikia.com">មជ្ឍមណ្ឌលសហគមន៍</a>។',
	'cnw-error-general' => 'មានបញ្ហាពេលបង្កើតវិគីរបស់អ្នក។ សូមព្យាយាមម្ដងទៀតនៅពេលក្រោយ។',
	'cnw-error-general-heading' => 'បញ្ហាក្នុងការបង្កើតវិគីថ្មី',
);

/** Korean (한국어)
 * @author Wrightbus
 * @author 아라
 */
$messages['ko'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|위키 만들기 마법사]]',
	'cnw-next' => '다음',
	'cnw-back' => '뒤로',
	'cnw-or' => '또는',
	'cnw-title' => '새 위키 만들기',
	'cnw-name-wiki-headline' => '위키 시작하기',
	'cnw-name-wiki-label' => '위키 이름을 입력하세요',
	'cnw-name-wiki-wiki' => '위키',
	'cnw-name-wiki-domain-label' => '위키 주소를 입력하세요',
	'cnw-login' => '로그인',
	'cnw-signup' => '계정 만들기',
	'cnw-signup-prompt' => '계정이 필요합니까?',
	'cnw-call-to-signup' => '여기서 가입하세요',
	'cnw-login-prompt' => '계정이 이미 있습니까?',
	'cnw-call-to-login' => '여기서 로그인하세요',
	'cnw-auth-headline' => '로그인',
	'cnw-auth-headline2' => '가입하기',
	'cnw-auth-facebook-signup' => '페이스북으로 가입',
	'cnw-auth-facebook-login' => '페이스북으로 로그인',
	'cnw-userauth-headline' => '계정이 있나요?',
	'cnw-userauth-creative' => '로그인',
	'cnw-userauth-marketing-heading' => '계정이 없나요?',
	'cnw-userauth-signup-button' => '가입하기',
	'cnw-desc-headline' => '어떤 위키를 만들겠습니까?',
	'cnw-desc-creative' => '주제에 대한 설명',
	'cnw-desc-tip1' => '힌트',
	'cnw-desc-tip2' => '약간의 보충',
	'cnw-desc-tip3' => '전문 팁',
	'cnw-desc-choose' => '분류를 선택하세요',
	'cnw-desc-select-one' => '1개 선택',
	'cnw-desc-default-lang' => '위키 언어는 $1입니다',
	'cnw-desc-change-lang' => '바꾸기',
	'cnw-desc-lang' => '언어',
	'cnw-desc-wiki-submit-error' => '분류를 선택하세요',
	'cnw-theme-headline' => '테마 선택',
	'cnw-upgrade-headline' => '업그레이드하겠습니까?',
	'cnw-upgrade-now' => '지금 업그레이드합니다',
	'cnw-upgrade-decline' => '괜찮습니다, 위키를 계속합니다',
	'cnw-welcome-headline' => '축하합니다! $1(을)를 만들었습니다',
	'cnw-error-general-heading' => '새 위키 만들기 오류',
	'cnw-error-database' => '데이터베이트 오류: $1',
	'cnw-error-wiki-limit-header' => '위키 제한에 도달함',
	'cnw-error-blocked-header' => '계정이 차단됨',
);

/** Kurdish (Latin script) (Kurdî (latînî)‎)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'cnw-or' => 'an',
	'cnw-signup' => 'Hesabekî çêke',
	'cnw-desc-lang' => 'Ziman',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'cnw-next' => 'Weider',
	'cnw-back' => 'Zréck',
	'cnw-or' => 'oder',
	'cnw-name-wiki-headline' => 'Eng Wiki ufänken',
	'cnw-name-wiki-label' => 'Gitt Ärer Wiki en Numm',
	'cnw-name-wiki-wiki' => 'Wiki',
	'cnw-login' => 'Aloggen',
	'cnw-auth-headline' => 'Aloggen',
	'cnw-desc-tip1' => 'Tipp',
	'cnw-desc-tip2' => 'Psst',
	'cnw-desc-choose' => 'Eng Kategorie wielen',
	'cnw-desc-select-one' => 'Een/Eng eraussichen',
	'cnw-desc-change-lang' => 'änneren',
	'cnw-desc-lang' => 'Sprooch',
	'cnw-upgrade-headline' => 'Wëllt Dir en Upgrade maachen?',
	'cnw-upgrade-now' => 'Elo aktualiséieren',
);

/** Lithuanian (lietuvių)
 * @author Eitvys200
 * @author Vpovilaitis
 */
$messages['lt'] = array(
	'cnw-next' => 'Kitas',
	'cnw-back' => 'Atgal',
	'cnw-or' => 'arba',
	'cnw-title' => 'Sukurti Naują Wiki',
	'cnw-name-wiki-headline' => 'Sukurti naują Wiki',
	'cnw-name-wiki-wiki' => 'Wiki',
	'cnw-login' => 'Prisijungti',
	'cnw-signup' => 'Sukurti Sąskaitą',
	'cnw-signup-prompt' => 'Reikia sąskaitos?',
	'cnw-login-prompt' => 'Jau turite sąskaitą?',
	'cnw-auth-facebook-signup' => 'Registruotis su Facebook',
	'cnw-auth-facebook-login' => 'Prisijungti su Facebook',
	'cnw-userauth-creative' => 'Prisijungti',
	'cnw-userauth-signup-button' => 'Registracija',
	'cnw-desc-headline' => 'Apie ką jūsų wiki?',
	'cnw-desc-creative' => 'Aprašykite savo temą',
	'cnw-desc-tip1' => 'Patarimas',
	'cnw-desc-tip2' => 'Psst',
	'cnw-desc-choose' => 'Pasirinkite kategoriją',
	'cnw-desc-select-one' => 'Pasirinkite vieną',
	'cnw-desc-change-lang' => 'keisti',
	'cnw-desc-wiki-submit-error' => 'Prašome pasirinkti kategoriją',
	'cnw-welcome-headline' => 'Sveikiname! $1 buvo sukurtas',
	'cnw-error-wiki-limit-header' => 'Pasiektas Wiki limitas',
	'cnw-error-blocked-header' => 'Sąskaita užblokuota',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 * @author Rancher
 */
$messages['mk'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Помошник за создавање на вики]]',
	'cnw-next' => 'Следно',
	'cnw-back' => 'Назад',
	'cnw-or' => 'или',
	'cnw-title' => 'Создавање ново вики',
	'cnw-name-wiki-headline' => 'Започнете вики',
	'cnw-name-wiki-creative' => 'Викија е најдоброто место за да изработите мрежно место и да создадете растечка заедница што се темели на она што го сакате.',
	'cnw-name-wiki-label' => 'Именувајте го викито',
	'cnw-name-wiki-wiki' => 'вики',
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
	'cnw-userauth-marketing-body' => 'Ќе ви треба сметка за да можете да создадете вики на Викија. [[Special:UserSignup|Регистрацијата]] ќе ви земе само минутка!',
	'cnw-userauth-signup-button' => 'Регистрација',
	'cnw-desc-headline' => 'Која е тематиката на викито?',
	'cnw-desc-creative' => 'Опишете ја вашата тема',
	'cnw-desc-placeholder' => 'Ова ќе се прикажува на главната страница на викито',
	'cnw-desc-tip1' => 'Совет',
	'cnw-desc-tip1-creative' => 'Овој простор користете го за да ги известите луѓето за вашето вики во една до две реченици',
	'cnw-desc-tip2' => 'Псст',
	'cnw-desc-tip2-creative' => 'Наведете што повеќе подробности за тематиката',
	'cnw-desc-tip3' => 'Совет за стручњаци',
	'cnw-desc-tip3-creative' => 'Соопштете им на луѓето дека можат да уредуваат страници на викито и така да помогнат во неговиот развој',
	'cnw-desc-choose' => 'Одберете категорија',
	'cnw-desc-select-one' => 'Одберете една категорија',
	'cnw-desc-default-lang' => 'Викито ќе биде на $1',
	'cnw-desc-change-lang' => 'измени',
	'cnw-desc-lang' => 'Јазик',
	'cnw-desc-wiki-submit-error' => 'Одберете категорија',
	'cnw-theme-headline' => 'Уредете го изгледот на викито',
	'cnw-theme-creative' => 'Подолу изберете изглед. За секој избран изглед ќе се прикаже преглед .',
	'cnw-theme-instruction' => 'Подоцна можете да изработите свој изглед преку „Мои алатки“.',
	'cnw-upgrade-headline' => 'Сакате да се надградите?',
	'cnw-upgrade-creative' => 'Надградуваќи се на Викија Плус добивате можност да ги отстраните рекламите од <span class="wiki-name"></span> - еднократна понуда само за нови основачи',
	'cnw-upgrade-marketing' => 'Викија Плус е одлично решение за:<ul>
<li>Стручни деловни викија</li>
<li>Непрофитни организации</li>
<li>Семејства</li>
<li>Училишта</li>
<li>Лични проекти</li>
</ul>
Надградете се преку PayPal и вашето вики ќе биде без реклами за само $4,95 месечно!',
	'cnw-upgrade-now' => 'Надгради веднаш',
	'cnw-upgrade-decline' => 'Не, благодарам. Однеси ме на викито.',
	'cnw-welcome-headline' => 'Честитаме! Го создадовте $1',
	'cnw-welcome-instruction1' => 'Стиснете на копчето подолу за да почнете да додавате страници на викито.',
	'cnw-welcome-instruction2' => 'Ова копче ќе биде присутно ширум целото вики. Користете го секогаш кога сакате да додадете нова страница.',
	'cnw-welcome-help' => 'Одговори на прашања, совети и друго ќе добиете на <a href="http://community.wikia.com">Центарот на заедницата</a>.',
	'cnw-error-general' => 'Нешто тргна наопаку при создавањето на вашето вики. Обидете се подоцна.',
	'cnw-error-general-heading' => 'Грешка при создавање на ново вики',
	'cnw-error-database' => 'Грешка во базата: $1',
	'cnw-badword-header' => 'Предупредување',
	'cnw-badword-msg' => 'Здраво. Ве молиме да се воздржите од употреба на непристојни зборови или забранетите зборови наведени во описот на викито: $1',
	'cnw-error-wiki-limit-header' => 'Границата на создадени викија е достигната',
	'cnw-error-wiki-limit' => 'Здраво. Можете да создавате само по {{PLURAL:$1|$1 вики|$1 викија}} дневно. Почекајте 24 часа, па потоа создајте друго.',
	'cnw-error-blocked-header' => 'Сметката е блокирана',
	'cnw-error-blocked' => 'Блокирани сте од $1. Понудената причина гласи: $2. (назнака или навод на блокирањето: $3)',
	'cnw-error-torblock' => 'Не е дозволено создавање на викија преку Tor-мрежа.',
	'cnw-error-bot' => 'Утврдивме дека можеби сте бот. Ако ова е погрешно, тогаш контактирајте нè и кажете дека сме ве погрешиле за бот. Тогаш ние ќе ви помогнеме да го направите викито: [http://www.wikia.com/Special:Contact/general?uselang=mk Пишете ни]',
	'cnw-error-bot-header' => 'Утврдено е дека сте бот',
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
	'cnw-name-wiki-wiki' => 'വിക്കി',
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
	'cnw-desc-choose' => 'ഒരു വർഗ്ഗം തിരഞ്ഞെടുക്കുക',
	'cnw-desc-select-one' => 'ഒരെണ്ണം തിരഞ്ഞെടുക്കുക',
	'cnw-desc-change-lang' => 'മാറ്റംവരുത്തുക',
	'cnw-desc-lang' => 'ഭാഷ',
	'cnw-desc-wiki-submit-error' => 'ദയവായി ഒരു വർഗ്ഗം തിരഞ്ഞെടുക്കുക',
	'cnw-welcome-headline' => 'അഭിനന്ദനങ്ങൾ! $1 സൃഷ്ടിക്കപ്പെട്ടിരിക്കുന്നു',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Pendeta penciptaan Wiki]]',
	'cnw-next' => 'Berikutnya',
	'cnw-back' => 'Sebelumnya',
	'cnw-or' => 'atau',
	'cnw-title' => 'Cipta Wiki Baru',
	'cnw-name-wiki-headline' => 'Cipta Wiki Baru',
	'cnw-name-wiki-creative' => 'Wikia ialah tempat terbaik untuk membina sebuah tapak web dan menghimpunkan sebuah komuniti yang berkongsi kegemaran anda.',
	'cnw-name-wiki-label' => 'Namakan wiki anda',
	'cnw-name-wiki-wiki' => 'Wiki',
	'cnw-name-wiki-domain-label' => 'Berikan alamat wiki anda',
	'cnw-name-wiki-submit-error' => 'Eh eh! Anda perlu mengisi kedua-dua kotak di atas sebelum menyambung.',
	'cnw-login' => 'Log masuk',
	'cnw-signup' => 'Buka Akaun',
	'cnw-signup-prompt' => 'Perlukan akaun?',
	'cnw-call-to-signup' => 'Daftar di sini',
	'cnw-login-prompt' => 'Sudah ada akaun?',
	'cnw-call-to-login' => 'Log masuk di sini',
	'cnw-auth-headline' => 'Log masuk',
	'cnw-auth-headline2' => 'Daftar Diri',
	'cnw-auth-creative' => 'Log masuk ke dalam akaun anda untuk terus membina wiki anda.',
	'cnw-auth-signup-creative' => 'Anda perlukan akaun untuk terus membina wiki anda.<br />Pendaftaran hanya mengambil masa seminit!',
	'cnw-auth-facebook-signup' => 'Berdaftar dengan Facebook',
	'cnw-auth-facebook-login' => 'Log masuk dengan Facebook',
	'cnw-userauth-headline' => 'Dah buka akaun?',
	'cnw-userauth-creative' => 'Log masuk',
	'cnw-userauth-marketing-heading' => 'Belum buka akaun?',
	'cnw-userauth-marketing-body' => 'Anda memerlukan akaun untuk membuka wiki baru di Wikia. Seminit saja untuk [[Special:UserSignup|mendaftar]]!',
	'cnw-userauth-signup-button' => 'Daftar diri',
	'cnw-desc-headline' => 'Apakah topik wiki anda?',
	'cnw-desc-creative' => 'Jelaskan topik anda',
	'cnw-desc-placeholder' => 'Ini akan terpapar pada laman utama wiki anda.',
	'cnw-desc-tip1' => 'Petua',
	'cnw-desc-tip1-creative' => 'Gunakan ruangan ini untuk menjelaskan wiki anda secara ringkas.',
	'cnw-desc-tip2' => 'Psst',
	'cnw-desc-tip2-creative' => 'Nyatakan perincian tentang subjek anda untuk makluman para pengunjung.',
	'cnw-desc-tip3' => 'Petua Pro',
	'cnw-desc-tip3-creative' => 'Jemput orang ramai untuk menyunting dan menambahkan laman supaya wiki anda berkembang',
	'cnw-desc-choose' => 'Pilih kategori',
	'cnw-desc-select-one' => 'Pilih satu',
	'cnw-desc-default-lang' => 'Wiki anda adalah dalam $1',
	'cnw-desc-change-lang' => 'ubah',
	'cnw-desc-lang' => 'Bahasa',
	'cnw-desc-wiki-submit-error' => 'Sila pilih kategori',
	'cnw-theme-headline' => 'Pilih tema',
	'cnw-theme-creative' => 'Pilih tema di bawah. Anda boleh melihat pralihat untuk setiap tema yang anda pilih.',
	'cnw-theme-instruction' => 'Anda boleh mereka tema anda lain kali dengan menggunakan "Alatan Saya".',
	'cnw-upgrade-headline' => 'Nak naik taraf?',
	'cnw-upgrade-creative' => 'Jika anda naik taraf ke Wikia Plus, anda boleh gugurkan iklan dari <span class="wiki-name"></span>, tawaran sekali sahaja buat pengasas baru.',
	'cnw-upgrade-marketing' => 'Wikia Plus merupakan yang terbaik untuk:<ul>
<li>Wiki Profesional</li>
<li>Pertubuhan bukan untang</li>
<li>Keluarga</li>
<li>Sekolah</li>
<li>Projek peribadi</li>
</ul>
Naik taraf wiki anda kepada wiki tanpa iklan dengan membayar $4.95 (USD) sebulan melalui PayPal!',
	'cnw-upgrade-now' => 'Naik Taraf Sekarang',
	'cnw-upgrade-decline' => 'Tak apalah, terus ke wiki saya',
	'cnw-welcome-headline' => 'Bagus! $1 telah dicipta',
	'cnw-welcome-instruction1' => 'Klik butang di bawah untuk mulai membuka laman pada wiki anda.',
	'cnw-welcome-instruction2' => 'Anda akan melihat butang ini di seluruh wiki. Gunakannya pada bila-bila masa anda ingin menambahkan laman baru.',
	'cnw-welcome-help' => 'Cari jawapan, nasihat, dan banyak lagi di <a href="http://community.wikia.com">Community Central</a>.',
	'cnw-error-general' => 'Kami menghadapi masalah ketika memproseskan penciptaan wiki anda. Sila cuba lagi lain kali.',
	'cnw-error-general-heading' => 'Ralat Penciptaan Wiki Baru',
	'cnw-error-database' => 'Ralat pangkalan data: $1',
	'cnw-badword-header' => 'Nanti kejap',
	'cnw-badword-msg' => 'Hai, sila hindari penggunaan kata-kata kesat/terlarang dalam Penerangan Wiki anda: $1',
	'cnw-error-wiki-limit-header' => 'Had wiki dicapai',
	'cnw-error-wiki-limit' => 'Maaf, anda tidak boleh membuka lebih daripada $1 wiki sehari. Tunggi 24 jam sebelum membuka satu lagi wiki.',
	'cnw-error-blocked-header' => 'Akaun disekat',
	'cnw-error-blocked' => 'Anda telah disekat oleh $1. Sebab yang diberikan ialah: $2. (ID sekatan untuk rujukan: $3)',
	'cnw-error-torblock' => 'Pembentukan wiki melalui Tor Network tidak dibenarkan.',
	'cnw-error-bot' => 'Kami telah mengesan bahawa anda mungkin sebuah bot. Jika kami tersilap, sila hubungi kami untuk menerangkan bahawa anda telah tersalah dikesan sebagai bot, dan kami akan membantu anda untuk membuat wiki anda: [http://www.wikia.com/Special:Contact/general Hubungi Kami]',
	'cnw-error-bot-header' => 'Anda telah dikesan sebagai bot',
);

/** Norwegian Bokmål (norsk (bokmål)‎)
 * @author Audun
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Veiviser for opprettelse av wiki]]',
	'cnw-next' => 'Neste',
	'cnw-back' => 'Tilbake',
	'cnw-or' => 'eller',
	'cnw-title' => 'Opprett ny wiki',
	'cnw-name-wiki-headline' => 'Start en wiki',
	'cnw-name-wiki-creative' => 'Wikia er det beste stedet å bygge et nettsted og lage en fellesskap rundt det du elsker.',
	'cnw-name-wiki-label' => 'Navngi wikien din',
	'cnw-name-wiki-wiki' => 'Wiki',
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
	'cnw-userauth-marketing-body' => 'Du trenger en konto for å opprette en wiki hos Wikia. Det tar bare et minutt å [[Special:UserSignup|registrere deg]]!',
	'cnw-userauth-signup-button' => 'Registrer deg',
	'cnw-desc-headline' => 'Hva handler wikien din om?',
	'cnw-desc-creative' => 'Beskriv emnet ditt',
	'cnw-desc-placeholder' => 'Dette vil vises på hovedsiden til wikien din.',
	'cnw-desc-tip1' => 'Hint',
	'cnw-desc-tip1-creative' => 'Bruk denne plassen til å fortelle folk om wikien din med en setning eller to',
	'cnw-desc-tip2' => 'Psst',
	'cnw-desc-tip2-creative' => 'Gi dine besøkende noen spesifikke detaljer om feltet ditt',
	'cnw-desc-tip3' => 'Eksperttips',
	'cnw-desc-tip3-creative' => 'La folk få vite at de kan hjelpe wikien din med å vokse ved å redigere og legge til sider',
	'cnw-desc-choose' => 'Velg kategori',
	'cnw-desc-select-one' => 'Velg en',
	'cnw-desc-default-lang' => 'Wikien din vil være på $1',
	'cnw-desc-change-lang' => 'endre',
	'cnw-desc-lang' => 'Språk',
	'cnw-desc-wiki-submit-error' => 'Vennligst velg en kategori',
	'cnw-theme-headline' => 'Velg et tema',
	'cnw-theme-creative' => 'Velg et tema under. Du vil kunne se en forhåndsvisning av hvert tema når du markerer det.',
	'cnw-theme-instruction' => 'Du kan også utforme ditt eget tema senere ved å gå til «Mine verktøy».',
	'cnw-upgrade-headline' => 'Vil du oppgradere?',
	'cnw-upgrade-creative' => 'Å oppgradere til Wikia Pluss lar deg fjerne annonser fra <span class="wiki-name"></span>. Et engangstilbud er tilgjengelig kun for nye grunnleggere.',
	'cnw-upgrade-marketing' => 'Wikia Pluss er en flott løsning for:<ul>
<li>Profesjonelle wikier</li>
<li>Ideelle prosjekter</li>
<li>Familier</li>
<li>Skoler</li>
<li>Personlige prosjekter</li>
</ul>
Oppgrader gjennom PayPal for å få en reklamefri wiki til kun $4,95 per måned!',
	'cnw-upgrade-now' => 'Oppgrader nå',
	'cnw-upgrade-decline' => 'Nei takk, fortsett til wikien min',
	'cnw-welcome-headline' => 'Gratulerer! $1 har blitt opprettet',
	'cnw-welcome-instruction1' => 'Trykk på knappen under for å begynne å legge til siden på wikien din.',
	'cnw-welcome-instruction2' => 'Du vil se denne knappen på wikien din, bruk den når du vil legge til en ny side.',
	'cnw-welcome-help' => 'Finn svar, råd, og mer på <a href="http://community.wikia.com">Community Central</a>.',
	'cnw-error-general' => 'Noe gikk galt under opprettning av wikien din. Vennligst prøv igjen senere.',
	'cnw-error-general-heading' => 'Opprett ny wiki-feil',
	'cnw-error-database' => 'Databasefeil: $1',
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

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Wiki Wizard wiki aanmaken]]',
	'cnw-next' => 'Volgende',
	'cnw-back' => 'Vorige',
	'cnw-or' => 'of',
	'cnw-title' => 'Nieuwe wiki aanmaken',
	'cnw-name-wiki-headline' => 'Wiki oprichten',
	'cnw-name-wiki-creative' => 'Wikia is de beste plaats om een website te bouwen en een gemeenschap te laten groeien om het onderwerp dat u aan het hart gaat.',
	'cnw-name-wiki-label' => 'Geef uw wiki een naam',
	'cnw-name-wiki-wiki' => 'Wiki',
	'cnw-name-wiki-domain-label' => 'Geef uw wiki een adres',
	'cnw-name-wiki-submit-error' => 'U moet beide bovenstaande velden invullen om door te kunnen gaan.',
	'cnw-login' => 'Aanmelden',
	'cnw-signup' => 'Registreren',
	'cnw-signup-prompt' => 'Wilt u zich registreren?',
	'cnw-call-to-signup' => 'Hier aanmelden',
	'cnw-login-prompt' => 'Hebt u al een gebruiker?',
	'cnw-call-to-login' => 'Hier aanmelden',
	'cnw-auth-headline' => 'Aanmelden',
	'cnw-auth-headline2' => 'Registreren',
	'cnw-auth-creative' => 'Meld u aan om door te gaan met het opbouwen van uw wiki.',
	'cnw-auth-signup-creative' => 'U hebt een gebruiker nodig om door te kunnen gaan met het bouwen van uw wiki.<br />Registreren kost maar een minuutje van uw tijd!',
	'cnw-auth-facebook-signup' => 'Aanmelden met Facebook',
	'cnw-auth-facebook-login' => 'Aanmelden met Facebook',
	'cnw-userauth-headline' => 'Hebt u een geregistreerde gebruiker?',
	'cnw-userauth-creative' => 'Aanmelden',
	'cnw-userauth-marketing-heading' => 'Hebt u geen geregistreerde gebruiker?',
	'cnw-userauth-marketing-body' => 'U hebt een gebruiker nodig om een wiki aan te maken bij Wikia. Het kost u slechts een minuutje om te [[Special:UserSignup|registreren]].',
	'cnw-userauth-signup-button' => 'Registreren',
	'cnw-desc-headline' => 'Waar gaat uw wiki over?',
	'cnw-desc-creative' => 'Beschrijf uw onderwerp',
	'cnw-desc-placeholder' => 'Dit wordt weergegeven op de hoofdpagina van uw wiki.',
	'cnw-desc-tip1' => 'Tip',
	'cnw-desc-tip1-creative' => 'Gebruik deze ruimte om mensen over uw wiki te vertellen in een paar zinnen',
	'cnw-desc-tip2' => 'Pst!',
	'cnw-desc-tip2-creative' => 'Geef uw bezoeker wat details over uw onderwerp',
	'cnw-desc-tip3' => 'Protip',
	'cnw-desc-tip3-creative' => "Laat mensen weten dat ze kunnen helpen om uw wiki te bewerken en pagina's toe te voegen",
	'cnw-desc-choose' => 'Kies een categorie',
	'cnw-desc-select-one' => 'Maak een keuze',
	'cnw-desc-default-lang' => 'De hoofdtaal van uw wiki is: $1',
	'cnw-desc-change-lang' => 'wijzigen',
	'cnw-desc-lang' => 'Taal',
	'cnw-desc-wiki-submit-error' => 'Kies een categorie',
	'cnw-theme-headline' => 'Ontwerp uw wiki',
	'cnw-theme-creative' => 'Kies hieronder een vormgeving. Als u een vormgeving selecteert, wordt een voorvertoning weergegeven.',
	'cnw-theme-instruction' => 'U kunt uw thema of ontwerp altijd later aanpassen via "Mijn hulpmiddelen".',
	'cnw-upgrade-headline' => 'Wilt u upgraden?',
	'cnw-upgrade-creative' => 'Upgraden naar Wikia Plus maakt het mogelijk om advertenties te verwijderen van <span class="wiki-name"></span>. Deze aanbieding is alleen beschikbaar voor nieuwe oprichters.',
	'cnw-upgrade-marketing' => "Wikia Plus is prima oplossing voor:<ul>
<li>Professionele wiki's</li>
<li>Organisaties zonder winstoogmerk</li>
<li>Families</li>
<li>Scholen</li>
<li>Persoonlijke projecten</li>
</ul>
Schaf uw upgrade aan via PayPal. Geen advertenties voor maar $4,95 per maand!",
	'cnw-upgrade-now' => 'Nu upgraden',
	'cnw-upgrade-decline' => 'Nee, bedankt. Ik wil naar mijn wiki',
	'cnw-welcome-headline' => 'Gefeliciteerd. U hebt de wiki $1 aangemaakt',
	'cnw-welcome-instruction1' => "Klik op de onderstaande knop om pagina's aan uw wiki toe te voegen.",
	'cnw-welcome-instruction2' => 'U ziet deze knop overal in uw wiki. Gebruik hem als u een nieuwe pagina wilt toevoegen.',
	'cnw-welcome-help' => 'Antwoorden, advies en meer op <a href="http://community.wikia.com">Community Central</a>.',
	'cnw-error-general' => 'Er is iets misgegaan tijdens het aanmaken van uw wiki. Probeer het later opnieuw.',
	'cnw-error-general-heading' => 'Fout bij het aanmaken van een nieuwe wiki',
	'cnw-error-database' => 'Databasefout: $1',
	'cnw-badword-header' => 'Pas op!',
	'cnw-badword-msg' => 'Hallo. Probeer u te onthouden van het gebruiken van ongewenste woorden in uw wikibeschrijving: $1',
	'cnw-error-wiki-limit-header' => 'De wikilimiet is bereikt',
	'cnw-error-wiki-limit' => "Hallo. U mag maximaal $1 {{PLURAL:$1|wiki|wiki's}} per dag aanmaken. Wacht 24 uur om een nieuwe wiki aan te kunnen maken.",
	'cnw-error-blocked-header' => 'Gebruiker geblokkeerd',
	'cnw-error-blocked' => 'U bent geblokkeerd door $1. De reden die gegeven is: $2. (Blokkadenummer voor referentie: $3)',
	'cnw-error-torblock' => "Wiki's aanmaken via het Tor Network is niet toegestaan.",
	'cnw-error-bot' => 'We denken dat u wellicht een geautomatiseerd programma bent. Als deze aanname onjuist is, neem dan alstublieft [http://www.wikia.com/Special:Contact/general contact met ons op], en geef aan waarop u denk dat u onterecht bent aangemerkt als een robot. Dit stelt ons in staat u verder te helpen met het aanmaken van uw wiki.',
	'cnw-error-bot-header' => 'U bent geïdentificeerd als een geautomatiseerd proces',
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
	'cnw-desc-tip3-creative' => "Laat mensen weten dat ze kunnen helpen om je wiki te bewerken en pagina's toe te voegen",
	'cnw-desc-default-lang' => 'De hoofdtaal van je wiki is: $1',
	'cnw-theme-creative' => 'Kies hieronder een vormgeving. Als je een vormgeving selecteert, wordt een voorvertoning weergegeven.',
	'cnw-theme-instruction' => 'Je kunt je thema of ontwerp altijd later aanpassen via "Mijn hulpmiddelen".',
	'cnw-upgrade-headline' => 'Wil je upgraden?',
	'cnw-welcome-instruction1' => "Klik op de onderstaande knop om pagina's aan je wiki toe te voegen.",
	'cnw-welcome-instruction2' => 'Je ziet deze knop overal in je wiki. Gebruik hem als je een nieuwe pagina wilt toevoegen.',
	'cnw-error-general' => 'Er is iets misgegaan tijdens het aanmaken van je wiki. Probeer het later opnieuw.',
	'cnw-error-wiki-limit' => "Hoi. Je mag maximaal $1 {{PLURAL:$1|wiki|wiki's}} per dag aanmaken. Wacht 24 uur om een nieuwe wiki aan te kunnen maken.",
);

/** Pälzisch (Pälzisch)
 * @author Manuae
 */
$messages['pfl'] = array(
	'cnw-badword-header' => 'Imma longsoam',
);

/** Polish (polski)
 * @author BeginaFelicysym
 * @author Sovq
 * @author Woytecr
 */
$messages['pl'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Kreator tworzenia wiki]]',
	'cnw-next' => 'Dalej',
	'cnw-back' => 'Wstecz',
	'cnw-or' => 'lub',
	'cnw-title' => 'Utwórz nową Wiki',
	'cnw-name-wiki-headline' => 'Utwórz wiki',
	'cnw-name-wiki-creative' => 'Wikia to najlepsze miejsce do budowania własnej wiki i tworzenia społeczności wokół tego co kochasz.',
	'cnw-name-wiki-label' => 'Nazwij swoją wiki',
	'cnw-name-wiki-wiki' => 'Wiki',
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
	'cnw-userauth-marketing-body' => 'Posiadanie konta jest wymagane do utworzenia wiki. [[Special:UserSignup|Rejestracja]] zajmuje tylko minutę!',
	'cnw-userauth-signup-button' => 'Zarejestruj się',
	'cnw-desc-headline' => 'O czym będzie twoja wiki?',
	'cnw-desc-creative' => 'Opisz temat swojej wiki',
	'cnw-desc-placeholder' => 'To pojawi się na stronie głównej Twojej wiki',
	'cnw-desc-tip1' => 'Wskazówka 1',
	'cnw-desc-tip1-creative' => 'Wpisz kilka zdań które w skrócie opiszą Twoją wiki',
	'cnw-desc-tip2' => 'Wskazówka 2',
	'cnw-desc-tip2-creative' => 'Podziel się z innymi szczegółami o Twojej wiki',
	'cnw-desc-tip3' => 'Wskazówka 3',
	'cnw-desc-tip3-creative' => 'Daj innym znać, że mogą pomóc tej wiki rosnąć poprzez edytowanie i dodawanie stron',
	'cnw-desc-choose' => 'Wybierz kategorię',
	'cnw-desc-select-one' => 'Wybierz',
	'cnw-desc-default-lang' => 'Twoja wiki będzie w języku: $1',
	'cnw-desc-change-lang' => 'zmień',
	'cnw-desc-lang' => 'Język',
	'cnw-desc-wiki-submit-error' => 'Proszę wybrać kategorię',
	'cnw-theme-headline' => 'Wybierz motyw',
	'cnw-theme-creative' => 'Wybierz jeden z poniższych motywów aby zobaczyć podgląd i zdecydować o wyborze.',
	'cnw-theme-instruction' => 'Możesz także zaprojektować motyw później, korzystając z menu "Moje narzędzia".',
	'cnw-upgrade-headline' => 'Czy chcesz uaktualnić?',
	'cnw-upgrade-creative' => 'Uaktualnienie do Wikia Plus umożliwia usunięcie reklam z <span class="wiki-name"> </span>, jest jednorazową ofertą skierowaną do nowych założycieli wiki.',
	'cnw-upgrade-marketing' => 'Wikia Plus jest idealną propozycją dla:<ul>
<li>Profesjonalnych wiki</li>
<li>Organizacji non-profit</li>
<li>Rodzin</li>
<li>Szkół</li>
<li>Osobistych projektów</li>
</ul>
Uaktualnij poprzez PayPal aby utworzyć wiki wolną od reklam za jedyne $4.95 na miesiąc!',
	'cnw-upgrade-now' => 'Uaktualnij teraz',
	'cnw-upgrade-decline' => 'Nie, dziękuję, przejdź dalej',
	'cnw-welcome-headline' => 'Gratulacje! $1 została utworzona',
	'cnw-welcome-instruction1' => 'Kliknij na poniższy przycisk aby zacząć dodawanie stron do Twojej wiki',
	'cnw-welcome-instruction2' => 'Znajdziesz ten przycisk w wielu miejscach na Twojej wiki, użyj go, jeżeli chcesz dodać nową stronę.',
	'cnw-welcome-help' => 'Znajdź odpowiedzi, porady i więcej w <a href="http://spolecznosc.wikia.com">Centrum Społeczności</a>.',
	'cnw-error-general' => 'Coś poszło nie tak podczas tworzenia wiki. Proszę spróbuj ponownie później.',
	'cnw-error-general-heading' => 'Błąd kreatora wiki',
	'cnw-error-database' => 'Błąd bazy danych:$1',
	'cnw-badword-header' => 'Uwaga',
	'cnw-badword-msg' => 'Witaj, proszę nie używaj tych niedozwolonych słów w opisie wiki: $1',
	'cnw-error-wiki-limit-header' => 'Osiągnięto limit wiki',
	'cnw-error-wiki-limit' => 'Możesz utworzyć tylko {{PLURAL:$1|$1}} wiki dziennie. Zaczekaj 24 godziny aby utworzyć inną wiki.',
	'cnw-error-blocked-header' => 'Konto zablokowane',
	'cnw-error-blocked' => 'Użytkownik został zablokowany przez  $1. Jako przyczynę podano:  $2. (ID blokady:  $3 )',
	'cnw-error-torblock' => 'Tworzenie wiki za pośrednictwem Tor Network nie jest dozwolone.',
	'cnw-error-bot' => 'Wykryto, że to konto może być botem. Jeżeli popełniono błąd, proszę daj nam znać: [http://www.wikia.com/Special:Contact/general Kontakt]',
	'cnw-error-bot-header' => 'Zostałeś zidentyfikowany jako bot',
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
	'cnw-name-wiki-label' => 'خپله ويکي نومول',
	'cnw-name-wiki-wiki' => 'ويکي',
	'cnw-name-wiki-domain-label' => 'خپل ويکي ته يوه پته ورکول',
	'cnw-login' => 'ننوتل',
	'cnw-signup' => 'ګڼون جوړول',
	'cnw-signup-prompt' => 'آيا يو ګڼون غواړۍ؟',
	'cnw-call-to-signup' => 'نومليکل دلته ترسره کېږي',
	'cnw-login-prompt' => 'آيا وار دمخې يو ګڼون لرۍ؟',
	'cnw-call-to-login' => 'دلته ننوتل',
	'cnw-auth-headline' => 'ننوتل',
	'cnw-auth-headline2' => 'نومليکل',
	'cnw-auth-facebook-signup' => 'د فېسبوک له لارې نومليکل',
	'cnw-auth-facebook-login' => 'د فېسبوک له لارې ننوتل',
	'cnw-userauth-headline' => 'آيا يو ګڼون لرې؟',
	'cnw-userauth-creative' => 'ننوتل',
	'cnw-userauth-marketing-heading' => 'ګڼون نه لرې؟',
	'cnw-userauth-signup-button' => 'نومليکل',
	'cnw-desc-headline' => 'ستاسې ويکي د څه په اړه دی؟',
	'cnw-desc-placeholder' => 'دا به ستاسې د ويکي په لومړي مخ ښکاره شي.',
	'cnw-desc-tip1-creative' => 'دلته په يوې يا دوه کرښو کې خلکو ته مالومات ورکړۍ چې ستاسې ويکي د څه په اړه دی',
	'cnw-desc-choose' => 'يوه وېشنيزه ټاکل',
	'cnw-desc-select-one' => 'يو وټاکۍ',
	'cnw-desc-default-lang' => 'ستاسې ويکي به په $1 ژبه وي',
	'cnw-desc-change-lang' => 'بدلول',
	'cnw-desc-lang' => 'ژبه',
	'cnw-desc-wiki-submit-error' => 'يوه وېشنيزه وټاکۍ',
	'cnw-theme-headline' => 'خپل ويکي سکښتل',
	'cnw-welcome-headline' => 'بختور مو شه، د $1 ويکي جوړ شو',
	'cnw-error-blocked-header' => 'پر ګڼون بنديز ولګېد',
);

/** Portuguese (português)
 * @author Geitost
 * @author Hamilton Abreu
 * @author Malafaya
 * @author SandroHc
 */
$messages['pt'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Assistente de criação de wikis]]',
	'cnw-next' => 'Seguinte',
	'cnw-back' => 'Anterior',
	'cnw-or' => 'ou',
	'cnw-title' => 'Criar uma Wiki Nova',
	'cnw-name-wiki-headline' => 'Iniciar uma Wiki',
	'cnw-name-wiki-creative' => 'A Wikia é o melhor sítio para criar um site e desenvolver uma comunidade em torno de um tema do seu agrado.',
	'cnw-name-wiki-label' => 'Nome da sua wiki',
	'cnw-name-wiki-wiki' => 'Wiki',
	'cnw-name-wiki-domain-label' => 'Dê um endereço à sua wiki',
	'cnw-name-wiki-submit-error' => 'Para continuar tem de preencher ambas as caixas acima.',
	'cnw-login' => 'Iniciar Sessão',
	'cnw-signup' => 'Criar Conta',
	'cnw-signup-prompt' => 'Precisa de uma conta?',
	'cnw-call-to-signup' => 'Registe-se aqui',
	'cnw-login-prompt' => 'Já tem uma conta?',
	'cnw-call-to-login' => 'Inicie uma sessão aqui',
	'cnw-auth-headline' => 'Iniciar Sessão',
	'cnw-auth-headline2' => 'Registar',
	'cnw-auth-creative' => 'Entre na sua conta para continuar a criar a wiki',
	'cnw-auth-signup-creative' => 'Precisa de ter uma conta para continuar a construir a sua wiki.<br />Só leva um minuto a registar-se!',
	'cnw-auth-facebook-signup' => 'Registe-se pelo Facebook',
	'cnw-auth-facebook-login' => 'Entrar pelo Facebook',
	'cnw-userauth-headline' => 'Tem uma conta?',
	'cnw-userauth-creative' => 'Entrar',
	'cnw-userauth-marketing-heading' => 'Não tem conta?',
	'cnw-userauth-marketing-body' => 'Você precisa de uma conta para criar uma wiki na Wikia. Só demora um minuto para te [[Special:UserSignup|registares]]!',
	'cnw-userauth-signup-button' => 'Registe-se',
	'cnw-desc-headline' => 'Qual é o assunto da sua wiki?',
	'cnw-desc-creative' => 'Descreva o seu assunto',
	'cnw-desc-placeholder' => 'Isto irá aparecer na página principal da sua wiki.',
	'cnw-desc-tip1' => 'Sugestão',
	'cnw-desc-tip1-creative' => 'Use este espaço para descrever a sua wiki aos visitantes numa frase ou duas',
	'cnw-desc-tip2' => 'Conselho',
	'cnw-desc-tip2-creative' => 'Dê aos visitantes detalhes específicos sobre o assunto da sua wiki',
	'cnw-desc-tip3' => 'Dica Profissional',
	'cnw-desc-tip3-creative' => 'Diga às pessoas que podem ajudar a desenvolver a wiki editando e acrescentando páginas',
	'cnw-desc-choose' => 'Escolher uma categoria',
	'cnw-desc-select-one' => 'Seleccione uma',
	'cnw-desc-default-lang' => 'A sua wiki será em $1',
	'cnw-desc-change-lang' => 'alterar',
	'cnw-desc-lang' => 'Língua',
	'cnw-desc-wiki-submit-error' => 'Escolha uma categoria, por favor',
	'cnw-theme-headline' => 'Escolha uma variante do tema',
	'cnw-theme-creative' => 'Escolha uma variante do tema; pode ver uma antevisão de cada variante, clicando-a.',
	'cnw-theme-instruction' => 'Também pode criar uma variante personalizada mais tarde, usando "As Minhas Ferramentas".',
	'cnw-upgrade-headline' => 'Pretende a versão melhorada?',
	'cnw-upgrade-creative' => 'A versão Wikia Plus permite-lhe remover os anúncios da <span class="wiki-name"></span>, uma oferta única só disponível para novos fundadores.',
	'cnw-upgrade-marketing' => 'A versão Wikia Plus é excelente para:<ul>
<li>Wikis Profissionais</li>
<li>Organizações sem Fins Lucrativos</li>
<li>Famílias</li>
<li>Escolas</li>
<li>Projectos Pessoais</li>
</ul>
Adopte esta versão através do PayPal para ter uma wiki livre de anúncios por apenas $4.95 por mês!',
	'cnw-upgrade-now' => 'Usar a Versão Melhorada',
	'cnw-upgrade-decline' => 'Não obrigado, continuar para a minha wiki',
	'cnw-welcome-headline' => 'Parabéns! A $1 foi criada',
	'cnw-welcome-instruction1' => 'Clique o botão abaixo para começar a criar páginas na sua wiki.',
	'cnw-welcome-instruction2' => 'Verá este botão em todas as páginas da wiki; use-o em qualquer altura para criar uma página nova.',
	'cnw-welcome-help' => 'Encontrará respostas, conselhos e mais na <a href="http://pt.wikia.com">Comunidade Central</a>.',
	'cnw-error-general' => 'Ocorreu um erro não identificado ao criar a sua wiki. Tente novamente mais tarde, por favor.',
	'cnw-error-general-heading' => 'Erro ao Criar Wiki Nova',
	'cnw-error-database' => 'Erro da Base de Dados: $1',
	'cnw-badword-header' => 'Atenção',
	'cnw-badword-msg' => 'Não use estas palavras impróprias ou proibidas na Descrição da Wiki, por favor: $1',
	'cnw-error-wiki-limit-header' => 'O limite de wikis foi atingido',
	'cnw-error-wiki-limit' => 'Olá, está limitado à criação de $1 {{PLURAL:$1|wiki|wikis}} por dia. Aguarde 24 horas antes de criar outra wiki.',
	'cnw-error-blocked-header' => 'Conta bloqueada',
	'cnw-error-blocked' => 'Você foi bloqueado por $1. Pelo seguinte motivo: $2. (ID do Bloqueio para referência: $3)',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Aristóbulo
 * @author Caio1478
 * @author Luckas Blade
 * @author TheGabrielZaum
 */
$messages['pt-br'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Assistente de criação de wikis]]',
	'cnw-next' => 'Próximo',
	'cnw-back' => 'Voltar',
	'cnw-or' => 'ou',
	'cnw-title' => 'Criar uma Wiki Nova',
	'cnw-name-wiki-headline' => 'Iniciar uma Wiki',
	'cnw-name-wiki-creative' => 'A Wikia é o melhor lugar para criar um site e desenvolver uma comunidade em torno de um tema do seu agrado.',
	'cnw-name-wiki-label' => 'Nome da sua wiki',
	'cnw-name-wiki-wiki' => 'Wiki',
	'cnw-name-wiki-domain-label' => 'Dê um endereço à sua wiki',
	'cnw-name-wiki-submit-error' => 'Para continuar tem de preencher ambas as caixas acima.',
	'cnw-login' => 'Iniciar Sessão',
	'cnw-signup' => 'Criar Conta',
	'cnw-signup-prompt' => 'Precisa de uma conta?',
	'cnw-call-to-signup' => 'Registe-se aqui',
	'cnw-login-prompt' => 'Já tem uma conta?',
	'cnw-call-to-login' => 'Inicie uma sessão aqui',
	'cnw-auth-headline' => 'Iniciar Sessão',
	'cnw-auth-headline2' => 'Registar',
	'cnw-auth-creative' => 'Entre na sua conta para continuar a criar a wiki',
	'cnw-auth-signup-creative' => 'Precisa de ter uma conta para continuar a construir a sua wiki.<br />Só leva um minuto para registrar-se!',
	'cnw-auth-facebook-signup' => 'Registre-se pelo Facebook',
	'cnw-auth-facebook-login' => 'Entrar pelo Facebook',
	'cnw-desc-headline' => 'Qual é o assunto da sua wiki?',
	'cnw-desc-creative' => 'Descreva o seu assunto',
	'cnw-desc-placeholder' => 'Isto irá aparecer na página principal da sua wiki.',
	'cnw-desc-tip1' => 'Sugestão',
	'cnw-desc-tip1-creative' => 'Use este espaço para descrever a sua wiki aos visitantes numa frase ou duas',
	'cnw-desc-tip2' => 'Ei',
	'cnw-desc-tip2-creative' => 'Dê aos visitantes alguns detalhes específicos sobre o assunto',
	'cnw-desc-tip3' => 'Sugestão Para Profissionais',
	'cnw-desc-tip3-creative' => 'Informe as pessoas de que podem ajudar a desenvolver a wiki editando e acrescentando páginas',
	'cnw-desc-choose' => 'Escolher uma categoria',
	'cnw-desc-select-one' => 'Selecione uma',
	'cnw-desc-default-lang' => 'A sua wiki será em $1',
	'cnw-desc-change-lang' => 'alterar',
	'cnw-desc-lang' => 'Língua',
	'cnw-desc-wiki-submit-error' => 'Escolha uma categoria, por favor',
	'cnw-theme-headline' => 'Escolha um Compositor de temas',
	'cnw-theme-creative' => 'Escolha uma compositor de temas abaixo; verá uma antevisão de cada compositor à medida que a escolher.',
	'cnw-theme-instruction' => 'Tambem poderá criar um compositor personalizado mais tarde, usando "As Minhas Ferramentas".',
	'cnw-upgrade-headline' => 'Pretende a versão melhorada?',
	'cnw-upgrade-creative' => 'A versão Wikia Plus permite-lhe remover os anúncios da <span class="wiki-name"></span>, uma oferta única só disponível para novos fundadores.',
	'cnw-upgrade-marketing' => 'A versão Wikia Plus é excelente para:<ul>
<li>Wikis Profissionais</li>
<li>Organizações sem Fins Lucrativos</li>
<li>Famílias</li>
<li>Escolas</li>
<li>Projetos Pessoais</li>
</ul>
Adote esta versão através do PayPal para ter uma wiki livre de anúncios por apenas $4.95 por mês!',
	'cnw-upgrade-now' => 'Usar a Versão Melhorada',
	'cnw-upgrade-decline' => 'Não obrigado, continuar para a minha wiki',
	'cnw-welcome-headline' => 'Parabéns! A $1 foi criada',
	'cnw-welcome-instruction1' => 'Clique o botão abaixo para começar a criar páginas na sua wiki.',
	'cnw-welcome-instruction2' => 'Verá este botão em toda a wiki; use-o em qualquer altura para criar uma página nova.',
	'cnw-welcome-help' => 'Encontrará respostas, conselhos e mais na <a href="http://pt.wikia.com">Comunidade Central</a>.',
	'cnw-error-general' => 'Algo deu errado ao criar a sua wiki. Por favor, tente novamente mais tarde.',
	'cnw-error-general-heading' => 'Erro ao Criar uma Wiki Nova',
	'cnw-badword-header' => 'Atenção',
	'cnw-badword-msg' => 'Olá, por favor não use estas palavras grosseiras ou banidas na sua Descrição da Wiki: $1',
	'cnw-error-blocked-header' => 'Conta bloqueada',
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
	'cnw-desc-tip3-creative' => 'Informează oamenii despre faptul că pot să ajute wiki-ul tău să crească prin modificarea şi adăugarea de pagini',
	'cnw-desc-choose' => 'Alege o categorie',
	'cnw-desc-select-one' => 'Selectează una',
	'cnw-desc-default-lang' => 'Wiki-ul tău va fi în $1',
	'cnw-desc-change-lang' => 'schimbă',
	'cnw-desc-lang' => 'Limbă',
	'cnw-desc-wiki-submit-error' => 'Te rugăm alege o categorie',
	'cnw-theme-headline' => 'Alege o temă',
	'cnw-upgrade-headline' => 'Doriţi să realizaţi o actualizare?',
	'cnw-upgrade-marketing' => 'Wikia Plus este o soluţie nemaipomenită pentru:<ul>
<li>Wiki-urile profesionale</li>
<li>Acţiunile nonprofit</li>
<li>Familii</li>
<li>Școli</li>
<li>Proiecte personale</li>
</ul>
Actualizează prin PayPal pentru a obţine un wiki cu reclame gratis pentru doar 4.95$ pe lună!',
	'cnw-upgrade-now' => 'Actualizează acum',
	'cnw-upgrade-decline' => 'Nu, mulţumesc. Continuă spre wiki-ul meu',
	'cnw-welcome-instruction1' => 'Apasă pe butonul de mai jos pentru a începe să adaugi pagini wiki-ului tău.',
);

/** Russian (русский)
 * @author DCamer
 * @author Kuzura
 */
$messages['ru'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Мастер создания вики]]',
	'cnw-next' => 'Далее',
	'cnw-back' => 'Назад',
	'cnw-or' => 'или',
	'cnw-title' => 'Создать новую вики',
	'cnw-name-wiki-headline' => 'Начать вики',
	'cnw-name-wiki-creative' => 'Викия - это лучшее место для создания веб-сайта о том, что вы любите, и роста сообщества вокруг этого.',
	'cnw-name-wiki-label' => 'Название вики',
	'cnw-name-wiki-wiki' => 'Вики',
	'cnw-name-wiki-domain-label' => 'Задайте вашей вики адрес',
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
	'cnw-userauth-marketing-body' => 'Вам необходим аккаунт для создания вики на Викия.   Всего минута  на [[Special:UserSignup|регистрацию]]!',
	'cnw-userauth-signup-button' => 'Регистрация',
	'cnw-desc-headline' => 'О чём будет ваша вики?',
	'cnw-desc-creative' => 'Опишите вашу тему',
	'cnw-desc-placeholder' => 'Это будет отображаться на заглавной странице вики.',
	'cnw-desc-tip1' => 'Подсказка',
	'cnw-desc-tip1-creative' => 'Используйте это место, чтобы кратко рассказать людям о вашей вики в одно или два предложения.',
	'cnw-desc-tip2' => 'Псс',
	'cnw-desc-tip2-creative' => 'Раскройте посетителям вики некоторые подробности вашей темы',
	'cnw-desc-tip3' => 'Совет',
	'cnw-desc-tip3-creative' => 'Люди должны знать, что они могут помочь вашей вики расти, редактируя и добавляя страницы',
	'cnw-desc-choose' => 'Выберите категорию',
	'cnw-desc-select-one' => 'Выберите одно',
	'cnw-desc-default-lang' => 'Ваша вики будет в разделе $1',
	'cnw-desc-change-lang' => 'изменить',
	'cnw-desc-lang' => 'Язык',
	'cnw-desc-wiki-submit-error' => 'Пожалуйста, выберите категорию',
	'cnw-theme-headline' => 'Выбрать тему',
	'cnw-theme-creative' => 'Выберите тему ниже; вы можете просмотреть каждую тему до того, как сделать окончательный выбор.',
	'cnw-theme-instruction' => 'Вы также можете создавать свои собственные темы позже, перейдя в "Мои инструменты".',
	'cnw-upgrade-headline' => 'Вы хотите обновить?',
	'cnw-upgrade-creative' => 'Обновление до Wikia Plus позволяет удалит рекламу с <span class="wiki-name"></span>, единовременное предложение доступно только для новых основателей.',
	'cnw-upgrade-marketing' => 'Wikia Plus — это великолепное решение для:<ul>
<li>Профессиональных вики</li>
<li>Некоммерческих организаций</li>
<li>Семей</li>
<li>Школ</li>
<li>Личных проектов</li>
</ul>
Обновитесь через PayPal и получить вики без рекламы всего за $4 95 в месяц!',
	'cnw-upgrade-now' => 'Обновить сейчас',
	'cnw-upgrade-decline' => 'Нет, спасибо; продолжить создание моей вики',
	'cnw-welcome-headline' => 'Поздравляем! $1 создана',
	'cnw-welcome-instruction1' => 'Нажмите на кнопку ниже, чтобы начать добавлять страницы на вики.',
	'cnw-welcome-instruction2' => 'Вы будете видеть эту кнопку всегда и можете использовать её в любое время, когда захотите добавить новую страницу.',
	'cnw-welcome-help' => 'Найти ответы, советы и многое другое на <a href="http://community.wikia.com">Центральной вики</a>.',
	'cnw-error-general' => 'Что-то пошло не так при создании вики. Пожалуйста, повторите попытку позже.',
	'cnw-error-general-heading' => 'Ошибка при создании новой вики',
	'cnw-error-database' => 'Ошибка базы данных: $1',
	'cnw-badword-header' => 'Эй там',
	'cnw-badword-msg' => 'Пожалуйста, воздержитесь от использования плохих или запрещенных слов в описании вики: $1',
	'cnw-error-wiki-limit-header' => 'Лимит создания вики',
	'cnw-error-wiki-limit' => 'Привет, вы достигли ограничения по созданию {{PLURAL:$1|$1 вики|$1 викии|$1 викий}} в день. Подождите 24 часа перед созданием другой вики..',
	'cnw-error-blocked-header' => 'Учётная запись заблокирована',
	'cnw-error-blocked' => 'Вы были заблокированы $1. Причиной было: $2. (Для справки: $3)',
	'cnw-error-torblock' => 'Создание вики через сеть Tor не допускается.',
	'cnw-error-bot' => 'Мы обнаружили, что вы можете быть ботом. Если мы сделали ошибку, пожалуйста, свяжитесь с нами и подтвердите, что  вы не бот, и мы поможем вам в создании новой вики: [http://www.wikia.com/Special:Contact/general связь с нами]',
	'cnw-error-bot-header' => 'Вы были определены как бот',
);

/** Serbian (Cyrillic script) (српски (ћирилица)‎)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Помоћник за стварање викија]]',
	'cnw-next' => 'Следеће',
	'cnw-back' => 'Назад',
	'cnw-or' => 'или',
	'cnw-title' => 'Стварање новог викија',
	'cnw-name-wiki-headline' => 'Направите вики',
	'cnw-name-wiki-creative' => 'Викија је најбоље место да направите веб-сајт и створите растућу заједницу која се темељи на ономе што волите.',
	'cnw-name-wiki-label' => 'Именујте вики:',
	'cnw-name-wiki-wiki' => 'вики',
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
	'cnw-desc-tip3' => 'Савет за стручњаке',
	'cnw-desc-tip3-creative' => 'Обавестите људе да могу да уређују странице на викију и тако помогну у његовом развоју.',
	'cnw-desc-choose' => 'Изаберите категорију:',
	'cnw-desc-select-one' => 'изаберите',
	'cnw-desc-default-lang' => 'Вики ће бити на $1',
	'cnw-desc-change-lang' => 'промени',
	'cnw-desc-lang' => 'Језик:',
	'cnw-desc-wiki-submit-error' => 'Изаберите категорију',
	'cnw-theme-headline' => 'Изаберите тему',
	'cnw-theme-creative' => 'Изаберите неку од тема испод. Преглед ће се појавити истог тренутка.',
	'cnw-theme-instruction' => 'Касније можете да израдите сопствену тему преко „Мојих алатки“.',
	'cnw-upgrade-headline' => 'Желите ли да доградите?',
	'cnw-upgrade-creative' => 'Викија плус вам омогућава да уклоните огласе са <span class="wiki-name"></span>. Ово је једнократна понуда која је доступна само за нове осниваче.',
	'cnw-upgrade-marketing' => 'Викија плус је одлично решење за:<ul>
<li>професионалне викије</li>
<li>непрофитне организације</li>
<li>породицу</li>
<li>школе</li>
<li>личне пројекте</li>
</ul>
Доградите налог преко Пејпала и опростите се од огласа. Само 4,95 долара месечно!',
	'cnw-upgrade-now' => 'Догради',
	'cnw-upgrade-decline' => 'Не, хвала. Одведи ме на вики.',
	'cnw-welcome-headline' => 'Честитамо! Вики $1 је направљен',
	'cnw-welcome-instruction1' => 'Кликните на дугме испод да почнете с додавањем страница на вики.',
	'cnw-welcome-instruction2' => 'Ово дугме ће бити присутно широм викија. Користите га сваки пут када желите да додате нову страницу.',
	'cnw-welcome-help' => 'Одговори на питања, савети и друго се налазе на <a href="http://community.wikia.com">Центру заједнице</a>.',
	'cnw-error-general' => 'Дошло је до грешке при стварању викија. Покушајте касније.',
	'cnw-error-general-heading' => 'Грешка при стварању новог викија',
	'cnw-error-database' => 'Грешка у бази: $1',
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
 * @author Lokal Profil
 * @author McDutchie
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Guide för att skapa en wiki]]',
	'cnw-next' => 'Nästa',
	'cnw-back' => 'Tillbaka',
	'cnw-or' => 'eller',
	'cnw-title' => 'Skapa en ny Wiki',
	'cnw-name-wiki-headline' => 'Starta en Wiki',
	'cnw-name-wiki-creative' => 'Wikia är den bästa platsen att bygga en webbplats och växa en gemenskap kring det du älskar.',
	'cnw-name-wiki-label' => 'Ge din wiki ett namn',
	'cnw-name-wiki-wiki' => 'Wiki',
	'cnw-name-wiki-domain-label' => 'Ge din wiki en adress',
	'cnw-name-wiki-submit-error' => 'Hoppsan! Du måste fylla i båda rutorna ovan att hålla igång.',
	'cnw-login' => 'Logga in',
	'cnw-signup' => 'Skapa konto',
	'cnw-signup-prompt' => 'Behöver du ett konto?',
	'cnw-call-to-signup' => 'Registrera dig här',
	'cnw-login-prompt' => 'Har du redan ett konto?',
	'cnw-call-to-login' => 'Logga in här',
	'cnw-auth-headline' => 'Logga in',
	'cnw-auth-headline2' => 'Registrera dig',
	'cnw-auth-creative' => 'Logga in på ditt konto för att fortsätta bygga på din wiki.',
	'cnw-auth-signup-creative' => 'Du kommer att behöva ett konto för att fortsätta bygga på din wiki. <br /> Det tar bara en minut att registrera dig!',
	'cnw-auth-facebook-signup' => 'Registrera dig med Facebook',
	'cnw-auth-facebook-login' => 'Logga in med Facebook',
	'cnw-userauth-headline' => 'Har du ett konto?',
	'cnw-userauth-creative' => 'Logga in',
	'cnw-userauth-marketing-heading' => 'Har du inget konto?',
	'cnw-userauth-marketing-body' => 'Du behöver ett konto för att skapa en wiki på Wikia. Det tar bara en minut att [[Special:UserSignup|registrera dig]]!',
	'cnw-userauth-signup-button' => 'Registrera',
	'cnw-desc-headline' => 'Vad handlar din wiki om?',
	'cnw-desc-creative' => 'Beskriv ditt ämne',
	'cnw-desc-placeholder' => 'Det här kommer att visas på huvudsidan i din wiki.',
	'cnw-desc-tip1' => 'Tips',
	'cnw-desc-tip1-creative' => 'Använd detta utrymme för att berätta för folk vad din wiki handlar om med en mening eller två',
	'cnw-desc-tip2' => 'Psst',
	'cnw-desc-tip2-creative' => 'Ge dina besökare några specifika detaljer om ditt ämne',
	'cnw-desc-tip3' => 'Experttips',
	'cnw-desc-tip3-creative' => 'Låt folk vet att de kan hjälpa din wiki växa genom att redigera och lägga till sidor',
	'cnw-desc-choose' => 'Välj en kategori',
	'cnw-desc-select-one' => 'Välj en',
	'cnw-desc-default-lang' => 'Din wiki kommer att vara på $1',
	'cnw-desc-change-lang' => 'ändra',
	'cnw-desc-lang' => 'Språk',
	'cnw-desc-wiki-submit-error' => 'Välj en kategori',
	'cnw-theme-headline' => 'Designa din wiki',
	'cnw-theme-creative' => 'Välj ett tema nedan. Du kommer att se en förhandsgranskning av varje tema när du markerar det.',
	'cnw-theme-instruction' => 'Du kan också utforma ditt egna tema senare på "Mina verktyg".',
	'cnw-upgrade-headline' => 'Vill du uppgradera?',
	'cnw-upgrade-creative' => 'Om du uppgraderar till Wikia Plus kan du ta bort annonser från <span class="wiki-name"></span>. Ett engångserbjudande endast tillgängligt för nya grundare.',
	'cnw-upgrade-marketing' => 'Wikia Plus är en bra lösning för:<ul>
<li>Professionella Wikis</li>
<li>Ideella organisationer</li>
<li>Familjer</li>
<li>Skolor</li>
<li>Personliga projekt</li>
</ul>
Uppgradera via PayPal för att få en reklamfri wiki för endast $4,95 per månad!',
	'cnw-upgrade-now' => 'Uppgradera nu',
	'cnw-upgrade-decline' => 'Nej tack, fortsätt till min wiki',
	'cnw-welcome-headline' => 'Gratulerar, har du skapat $1',
	'cnw-welcome-instruction1' => 'Klicka på knappen nedan för att börja lägga till sidor på din wiki.',
	'cnw-welcome-instruction2' => 'Du kommer att se den här knappen på din wiki, använd den när du vill lägga till en ny sida.',
	'cnw-welcome-help' => 'Hitta svar, råd och mer på <a href="http://community.wikia.com">Community Central</a> .',
	'cnw-error-general' => 'Någonting gick fel när du skapade din wiki. Var god försök igen senare.',
	'cnw-error-general-heading' => 'Skapa ny Wiki-fel',
	'cnw-error-database' => 'Databasfel: $1',
	'cnw-badword-header' => 'Hallå där',
	'cnw-badword-msg' => 'Hej, var god avstå från att använda dessa grova eller fula ord i beskrivningen av din wiki: $1',
	'cnw-error-wiki-limit-header' => 'Wiki-gräns nådd',
	'cnw-error-wiki-limit' => 'Hej, du är begränsad till {{PLURAL:$1|$1 wikiskapelse|$1 skapelser av wikis}} per dag. Vänta 24 timmar innan du skapar en annan wiki.',
	'cnw-error-blocked-header' => 'Konto blockerat',
	'cnw-error-blocked' => 'Du har blivit blockerad av $1. Anledningen var:  $2. (Blockerings-ID för referens: $3)',
	'cnw-error-torblock' => 'Skapa wikis via Tor-nätverket är inte tillåtet.',
	'cnw-error-bot' => 'Vi har upptäckt att du kan vara en bot. Om vi gjort ett misstag, kontakta oss och beskriv att du har felaktigt identifierats som en bot, och vi kommer att hjälpa dig med att skapa din wiki: [http://www.wikia.com/Special:Contact/general Kontakta oss]',
	'cnw-error-bot-header' => 'Du har identifierats som en bot',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'cnw-next' => 'తదుపరి',
	'cnw-back' => 'వెనుకకు',
	'cnw-or' => 'లేదా',
	'cnw-name-wiki-label' => 'మీ వికీ పేరు',
	'cnw-name-wiki-wiki' => 'వికీ',
	'cnw-name-wiki-domain-label' => 'వికీ చిరునామా',
	'cnw-signup-prompt' => 'ఖాతా కావాలా?',
	'cnw-call-to-signup' => 'ఇక్కడ నమోదు చేసుకోండి',
	'cnw-login-prompt' => 'ఇప్పటికే మీకు ఖాతా ఉందా?',
	'cnw-call-to-login' => 'ఇక్కడ ప్రవేశించండి',
	'cnw-auth-headline' => 'వికీని మొదలుపెట్టడం', # Fuzzy
	'cnw-desc-headline' => 'మీ వికీ దేని గురించి?',
	'cnw-desc-tip1' => 'చిట్కా',
	'cnw-desc-tip1-creative' => 'మీ వికీ దేని గురించో ప్రజలకు చెప్పండి', # Fuzzy
	'cnw-desc-tip2' => 'చిట్కా 2', # Fuzzy
	'cnw-desc-tip2-creative' => 'వివరాలను చేర్చడం మర్చిపోకండి', # Fuzzy
	'cnw-desc-tip3' => 'చిట్కా 3', # Fuzzy
	'cnw-desc-tip3-creative' => 'తోడ్పడమని ప్రజలని ఆహ్వానించండి', # Fuzzy
	'cnw-desc-choose' => 'వర్గాన్ని ఎంచుకోండి',
	'cnw-desc-default-lang' => 'మీ వికీ $1 లో ఉంటుంది',
	'cnw-desc-change-lang' => 'మార్చండి',
	'cnw-desc-lang' => 'భాష',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Madyikerong panlikha ng Wiki]]',
	'cnw-next' => 'Susunod',
	'cnw-back' => 'Bumalik',
	'cnw-or' => 'o',
	'cnw-title' => 'Lumikha ng Bagong Wiki',
	'cnw-name-wiki-headline' => 'Magsimula ng isang Wiki',
	'cnw-name-wiki-creative' => 'Ang Wikia ang pinakamahusay na pook upang makapagtatag ng isang websayt at makapagpalaki ng isang pamayanan sa paligid ng minamahal mong bagay.',
	'cnw-name-wiki-label' => 'Pangalanan ang wiki mo',
	'cnw-name-wiki-wiki' => 'Wiki',
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
	'cnw-userauth-creative' => 'Lumagda',
	'cnw-userauth-marketing-heading' => 'Wala pang akawnt?',
	'cnw-userauth-marketing-body' => 'Kailangan mo ang isang akawnt upang makalikha ng isang wiki sa Wikia. Gugugol lamang ito ng isang minuto upang [[Special:UserSignup|makapagpatala]]!',
	'cnw-userauth-signup-button' => 'Magpatala',
	'cnw-desc-headline' => 'Tungkol ba saan ang wiki mo?',
	'cnw-desc-creative' => 'Ilarawan ang paksa mo',
	'cnw-desc-placeholder' => 'Lilitaw ito sa pangunahing pahina ng wiki mo.',
	'cnw-desc-tip1' => 'Pahiwatig',
	'cnw-desc-tip1-creative' => 'Gamitin ang puwang na ito upang sabihin sa mga tao ang tungkol sa wiki mo sa pamamagitan ng isa o dalawang mga pangungusap',
	'cnw-desc-tip2' => 'Hoy',
	'cnw-desc-tip2-creative' => 'Bigyan ang mga panauhin mo ng ilang partikular na mga detalye ukol sa paksa mo',
	'cnw-desc-tip3' => 'Pahiwatig ng Dalubhasa',
	'cnw-desc-tip3-creative' => 'Ipaalam sa mga tao na makakatulong sila sa pagpapalaki ng wiki mo sa pamamagitan ng pamamatnugot at pagdaragdag ng mga pahina',
	'cnw-desc-choose' => 'Pumili ng isang kategorya',
	'cnw-desc-select-one' => 'Pumili ng isa',
	'cnw-desc-default-lang' => 'Ang wiki mo ay magiging nasa $1',
	'cnw-desc-change-lang' => 'baguhin',
	'cnw-desc-lang' => 'Wika',
	'cnw-desc-wiki-submit-error' => 'Mangyaring pumili ng isang kategorya',
	'cnw-theme-headline' => 'Pumili ng isang tema',
	'cnw-theme-creative' => 'Pumili ng isang temang nasa ibaba, magagawa mong makakita ng isang paunang pagtanaw ng bawat tema habang pinipili mo ito.',
	'cnw-theme-instruction' => 'Makakapagdisenyo ka rin ng sarili mong tema paglaon sa pamamagitan ng pagpunta sa "Mga Kasangkapan Ko".',
	'cnw-upgrade-headline' => 'Nais mo bang magpataas ng antas?',
	'cnw-upgrade-creative' => 'Ang pagpapataas upang maging Wikia Plus ay nagpapahintulot sa iyong matanggal ang mga anunsiyo mula sa <span class="wiki-name"></span>, isang pang-isang ulit lamang na alok na makukuha ng bagong mga tagapagtatag.',
	'cnw-upgrade-marketing' => 'Ang Wikia Plus ay isang mahusay na tugon para sa:<ul>
<li>Mga Wiking Pangdalubhasa</li>
<li>Hindi nakikinabang</li>
<li>Mga mag-anak</li>
<li>Mga paaralan</li>
<li>Mga proyektong pansarili</li>
</ul>
Magpataas ng antas sa pamamagitan ng PayPal upang makakuha ng wiking walang anunsiyo sa halagang $4.95 lang bawat buwan!',
	'cnw-upgrade-now' => 'Itaas na ang Antas Ngayon',
	'cnw-upgrade-decline' => 'Salamat ngunit ayaw ko, magpatuloy sa aking wiki',
	'cnw-welcome-headline' => 'Maligayang bati! Nalikha na ang $1',
	'cnw-welcome-instruction1' => 'Pindutin ang pindutang nasa ibaba upang makapagsimulang magdagdag ng mga pahina sa wiki mo.',
	'cnw-welcome-instruction2' => 'Makikita mo ang pindutang ito sa kabuuan ng wiki mo, gamitin ito anumang oras na nais mong magdagdag ng isang bagong pahina.',
	'cnw-welcome-help' => 'Maghanap ng mga sagot, mga payo, at marami pa sa <a href="http://community.wikia.com">Lunduyan ng Pamayanan</a>.',
	'cnw-error-general' => 'May masamang bagay na nangyari habang nililikha ang wiki mo. Paki subukan ulit mamaya.',
	'cnw-error-general-heading' => 'Kamalian sa Paglikha ng Bagong Wiki',
	'cnw-error-database' => 'Kamalian ng Kalipunan ng Dato: $1',
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
	'cnw-name-wiki-wiki' => 'Вики',
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
 * @author Suelnur
 */
$messages['tr'] = array(
	'cnw-or' => 'ya da',
	'cnw-signup' => 'Hesap Oluştur',
	'cnw-desc-change-lang' => 'değiştir',
	'cnw-desc-lang' => 'Dil',
	'cnw-badword-header' => 'Oops!',
);

/** Tatar (Cyrillic script) (татарча)
 * @author Ajdar
 */
$messages['tt-cyrl'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Вики ясау остаханәсе]]',
	'cnw-next' => 'Киләсе',
	'cnw-back' => 'Артка',
	'cnw-or' => 'яки',
	'cnw-title' => 'Яңа вики ясау',
	'cnw-name-wiki-headline' => 'Вики башлау',
	'cnw-name-wiki-creative' => 'Викия - сез яраткан нәрсәләр турында веб-сайт төзү өчен иң кулай урын.',
	'cnw-name-wiki-label' => 'Викиның исеме',
	'cnw-name-wiki-wiki' => 'Вики',
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
	'cnw-userauth-marketing-body' => 'Вики төзү өчен сезгә теркәлергә кирәк. [[Special:UserSignup|Теркәлү]] бер генә минут!',
	'cnw-userauth-signup-button' => 'Теркәлү',
	'cnw-desc-headline' => 'Сезнең вики нәрсә турында булачак?',
	'cnw-desc-creative' => 'Темагызны тасвирлагыз',
	'cnw-desc-placeholder' => 'Бу сезнең викиның баш битендә булачак.',
	'cnw-desc-tip1' => 'Ярдәм',
	'cnw-desc-tip1-creative' => 'Бу урынны кешеләргә сезнең вики турында бер-ике җөмлә белән сөйләр өчен кулланыгыз.',
	'cnw-desc-tip2' => 'Псс',
	'cnw-desc-tip2-creative' => 'Вики кунакларына сезнең теманың кайбер үзенчәлекләрен сөйләп китегез.',
	'cnw-desc-tip3' => 'Киңәш',
	'cnw-desc-change-lang' => 'үзгәртү',
	'cnw-desc-lang' => 'Тел',
	'cnw-desc-wiki-submit-error' => 'Зинһар өчен, төркем сайлагыз',
	'cnw-theme-headline' => 'Тема сайлау',
	'cnw-upgrade-headline' => 'Сез яңартырга телисезме?',
	'cnw-upgrade-marketing' => 'Wikia Plus түбәндәгеләр өчен иң уңай нәрсә:<ul>
<li>Профессиональ викилар </li>
<li>Табышсыз оешмалар</li>
<li>Гаиләләр</li>
<li>Мәктәпләр</li>
<li>Шәхси проектлар</li>
</ul>
Upgrade through PayPal to get an ad-free wiki for only $4.95 per month!',
	'cnw-upgrade-now' => 'Хәзер яңартырга',
);

/** Ukrainian (українська)
 * @author A1
 */
$messages['uk'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Майстер створення вікі]]',
	'cnw-next' => 'Далі',
	'cnw-back' => 'Назад',
	'cnw-or' => 'або',
	'cnw-title' => 'Створити нову Вікі',
	'cnw-name-wiki-headline' => 'Створити вікі',
	'cnw-name-wiki-creative' => 'Вікія - це найкраще місце для створення веб-сайту про те, що ви любите, і зростання спільноти навколо цього.',
	'cnw-name-wiki-label' => 'Назва вашого вікі-сайту',
	'cnw-name-wiki-wiki' => 'Вікі',
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
	'cnw-userauth-creative' => 'Увійти',
	'cnw-userauth-marketing-heading' => 'Немає облікового запису?',
	'cnw-userauth-marketing-body' => 'Вам потрібний обліковий запис для створення вікі Wikia. [[Special:UserSignup|Створити]]!',
	'cnw-userauth-signup-button' => 'Зареєструватися',
	'cnw-desc-headline' => 'Про що буде ваша вікі?',
	'cnw-desc-creative' => 'Опишіть вашу тему',
	'cnw-desc-placeholder' => 'Це відображатиметься на головній сторінці вікі.',
	'cnw-desc-tip1' => 'Підказка',
	'cnw-desc-tip1-creative' => 'Використовуйте це місце, щоб коротко розповісти людям про вашу вікі в одне або два речення.',
	'cnw-desc-tip2' => 'Писати',
	'cnw-desc-tip2-creative' => 'Про що ви зібралися писати?',
	'cnw-desc-tip3' => 'Порада',
	'cnw-desc-tip3-creative' => 'Люди повинні знати, що вони можуть допомогти вашій вікі рости, редагуючи і додаючи сторінки',
	'cnw-desc-choose' => 'Оберіть категорію',
	'cnw-desc-select-one' => 'Оберіть одну',
	'cnw-desc-default-lang' => 'Ваша вікі буде в розділі $1',
	'cnw-desc-change-lang' => 'змінити',
	'cnw-desc-lang' => 'Мова',
	'cnw-desc-wiki-submit-error' => 'Просимо вибрати категорію',
	'cnw-theme-headline' => 'Обрати тему',
	'cnw-theme-creative' => 'Виберіть тему нижче, ви можете переглянути кожну тему до того, як зробити остаточний вибір',
	'cnw-theme-instruction' => 'Ви також можете створювати свої власні теми пізніше, перейшовши в "Мої інструменти".',
	'cnw-upgrade-headline' => 'Хочете оновити?',
	'cnw-upgrade-marketing' => 'Wikia Plus це рішення для крутеликів! Викиньте якихось там  $4.95 в місяць через PayPal і ви в шоколаді!',
	'cnw-upgrade-now' => 'Оновити зараз',
	'cnw-upgrade-decline' => 'Дякую, але я продовжу створювати власну вікі',
	'cnw-welcome-headline' => 'Вітаємо! $1 створена',
	'cnw-welcome-instruction1' => 'Натисніть на кнопку нижче, щоб почати додавати сторінки на вікі.',
	'cnw-welcome-instruction2' => 'Ви будете бачити цю кнопку завжди і можете використовувати її в будь-який час, коли захочете додати нову сторінку.',
	'cnw-welcome-help' => 'Знайті відповіді, поради та багато іншого на <a href="http://community.wikia.com">Центральній вікі</a>.',
	'cnw-error-general' => 'Сталась якась лажа. Спробуйте пізніше.',
	'cnw-error-general-heading' => 'Система облажалася',
	'cnw-error-database' => 'Помилка бази даних: $1',
	'cnw-badword-header' => 'Шо за фігня?',
	'cnw-badword-msg' => 'Будь ласка, не вживайте русизмів на $1 !',
	'cnw-error-wiki-limit-header' => 'Ліміт створення вікі',
	'cnw-error-wiki-limit' => 'Ви досягли обмеження $1 на створення вікі в день. Чекайте 24 години.', # Fuzzy
	'cnw-error-blocked-header' => 'Облікований запис заблоковано',
	'cnw-error-blocked' => 'Ви заблоковані $1. Причиною було: $2. (Для довідки: $3)',
	'cnw-error-bot' => 'Нам здається, що ви - бот.  Якщо це не так, звертайтеся [http://www.wikia.com/Special:Contact/general сюди].',
	'cnw-error-bot-header' => 'Ми вважаємо, що ви бот',
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
 * @author Xiao Qiao
 * @author XiaoQiaoGrace
 */
$messages['vi'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Thuật sĩ tạo Wiki]]',
	'cnw-next' => 'Tiếp theo',
	'cnw-back' => 'Trở lại',
	'cnw-or' => 'hoặc',
	'cnw-title' => 'Tạo Wiki mới',
	'cnw-name-wiki-headline' => 'Tạo lập một Wiki',
	'cnw-name-wiki-creative' => 'Wikia là nơi tốt nhất để xây dựng một trang web và phát triển một cộng đồng xung quanh những gì bạn yêu thích.',
	'cnw-name-wiki-label' => 'Tên wiki của bạn',
	'cnw-name-wiki-wiki' => 'Wiki',
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
	'cnw-auth-creative' => 'Đăng nhập vào tài khoản của bạn để tiếp tục xây dựng wiki của mình.',
	'cnw-auth-signup-creative' => 'Bạn sẽ cần một tài khoản để tiếp tục xây dựng wiki của mình.<br />Chỉ mất một phút để đăng ký!',
	'cnw-auth-facebook-signup' => 'Đăng ký cùng Facebook',
	'cnw-auth-facebook-login' => 'Đăng nhập cùng Facebook',
	'cnw-userauth-headline' => 'Đã có tài khoản?',
	'cnw-userauth-creative' => 'Đăng nhập',
	'cnw-userauth-marketing-heading' => 'Chưa có tài khoản?',
	'cnw-userauth-marketing-body' => 'Bạn cần một tài khoản để tạo ra một wiki trên Wikia.  Nó chỉ mất một phút để [[Special:UserSignup|đăng ký]]!',
	'cnw-userauth-signup-button' => 'Đăng ký',
	'cnw-desc-headline' => 'Wiki của bạn đề cập về?',
	'cnw-desc-creative' => 'Mô tả chủ đề của bạn',
	'cnw-desc-placeholder' => 'Điều này sẽ xuất hiện trên trang chính của wiki bạn.',
	'cnw-desc-tip1' => 'Gợi ý',
	'cnw-desc-tip1-creative' => 'Sử dụng khoảng trống này để nói với mọi người về wiki của bạn trong một hoặc hai câu',
	'cnw-desc-tip2' => 'Xem này',
	'cnw-desc-tip2-creative' => 'Cung cấp cho người truy cập một số chi tiết cụ thể về chủ đề của bạn',
	'cnw-desc-tip3' => 'Mẹo hữu dụng',
	'cnw-desc-tip3-creative' => 'Hãy để mọi người biết họ có thể giúp wiki của bạn phát triển bằng cách sửa đổi và tạo các trang',
	'cnw-desc-choose' => 'Chọn một thể loại',
	'cnw-desc-select-one' => 'Chọn một',
	'cnw-desc-default-lang' => 'Wiki của bạn sẽ đặt tại $1',
	'cnw-desc-change-lang' => 'thay đổi',
	'cnw-desc-lang' => 'Ngôn ngữ',
	'cnw-desc-wiki-submit-error' => 'Hãy chọn một thể loại',
	'cnw-theme-headline' => 'Chọn một chủ đề',
	'cnw-theme-creative' => 'Chọn một chủ đề dưới đây, bạn sẽ có thể xem thử từng chủ đề như bạn đã chọn nó.',
	'cnw-theme-instruction' => 'Bạn cũng có thể thiết kế chủ đề sau này bằng cách vào "Công cụ của tôi".',
	'cnw-upgrade-headline' => 'Bạn có muốn nâng cấp?',
	'cnw-upgrade-creative' => 'Nâng cấp lên Wikia Cộng cho phép bạn để loại bỏ quảng cáo từ <span class="wiki-name"></span> , một thời gian cung cấp chỉ dành cho những sáng lập viên mới.',
	'cnw-upgrade-marketing' => 'Wikia Cộng là một giải pháp tuyệt vời cho:<ul>
<li>Wiki chuyên nghiệp</li>
<li>Phi lợi nhuận</li>
<li>Gia đình</li>
<li>Trường học</li>
<li>Dự án cá nhân</li>
</ul>
Nâng cấp thông qua PayPal để có được một quảng cáo wiki miễn phí với chỉ $4,95 cho một tháng!',
	'cnw-upgrade-now' => 'Nâng cấp ngay',
	'cnw-upgrade-decline' => 'Không, cảm ơn, tiếp tục wiki của tôi',
	'cnw-welcome-headline' => 'Chúc mừng! $1 đã được tạo ra',
	'cnw-welcome-instruction1' => 'Nhấn vào nút dưới đây để bắt đầu thêm các trang cho wiki của bạn.',
	'cnw-welcome-instruction2' => 'Bạn sẽ thấy nút này trong suốt wiki của bạn, sử dụng nó bất cứ lúc nào bạn muốn thêm một trang mới.',
	'cnw-welcome-help' => 'Tìm câu trả lời, lời khuyên và nhiều hơn trên <a href="http://vi.wikia.com/wiki/Trang_Chính">Wikia Tiếng Việt</a>.',
	'cnw-error-general' => 'Một cái gì đó đã xảy ra trong khi tạo ra wiki của bạn. Xin vui lòng thử lại sau.',
	'cnw-error-general-heading' => 'Lỗi tạo Wiki mới',
	'cnw-error-database' => 'Lỗi Cơ sở dữ liệu: $1',
	'cnw-badword-header' => 'Whoa có rồi',
	'cnw-badword-msg' => 'Chào bạn, xin vui lòng tránh sử dụng những từ ngữ xấu hoặc từ bị cấm trong các mô tả Wiki: $1',
	'cnw-error-wiki-limit-header' => 'Wiki đã đạt đến giới hạn',
	'cnw-error-wiki-limit' => 'Xin chào, bạn bị giới hạn {{PLURAL:$1|tạo lập $1 wiki|tạo lập $1 wiki}} mỗi ngày. Hãy chờ 24 giờ trước khi tạo lập một wiki khác.',
	'cnw-error-blocked-header' => 'Tài khoản bị chặn',
	'cnw-error-blocked' => 'Bạn đã bị cấm bởi  $1. Lý do đưa ra là: $2 . (ID cấm để tham khảo: $3 )',
	'cnw-error-torblock' => 'Tạo wiki qua mạng Tor là không được phép.',
	'cnw-error-bot' => 'Chúng tôi đã phát hiện rằng bạn có thể là một bot. Nếu chúng tôi đã làm sai, hãy liên hệ với chúng tôi mô tả rằng bạn đã được phát hiện sai là một bot, và chúng tôi sẽ hỗ trợ bạn trong việc tạo ra của wiki bạn: [http://www.wikia.com/Special:Contact/general Liên hệ với Chúng tôi]',
	'cnw-error-bot-header' => 'Bạn đã được phát hiện là một bot',
);

/** Chinese (中文)
 */
$messages['zh'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Wiki creation wizard]]',
	'cnw-next' => 'Next',
	'cnw-back' => 'Back',
	'cnw-or' => 'or',
	'cnw-title' => 'Create New Wiki',
	'cnw-name-wiki-headline' => 'Start a Wiki',
	'cnw-name-wiki-creative' => 'Wikia is the best place to build a website and grow a community around what you love.',
	'cnw-name-wiki-label' => 'Name your wiki',
	'cnw-name-wiki-wiki' => 'Wiki',
	'cnw-name-wiki-domain-label' => 'Give your wiki an address',
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
	'cnw-desc-headline' => "What's your wiki about?",
	'cnw-desc-creative' => 'Describe your topic',
	'cnw-desc-placeholder' => 'This will appear on the main page of your wiki.',
	'cnw-desc-tip1' => 'Hint',
	'cnw-desc-tip1-creative' => 'Use this space to tell people about your wiki in a sentence or two',
	'cnw-desc-tip2' => 'Psst',
	'cnw-desc-tip2-creative' => 'Give your visitors some specific details about your subject',
	'cnw-desc-tip3' => 'Pro Tip',
	'cnw-desc-tip3-creative' => 'Let people know they can help your wiki grow by editing and adding pages',
	'cnw-desc-choose' => 'Choose a category',
	'cnw-desc-select-one' => 'Select one',
	'cnw-desc-default-lang' => 'Your wiki will be in $1',
	'cnw-desc-change-lang' => 'change',
	'cnw-desc-lang' => 'Language',
	'cnw-desc-wiki-submit-error' => 'Please choose a category',
	'cnw-theme-headline' => 'Choose a theme',
	'cnw-theme-creative' => "Choose a theme below, you'll be able to see a preview of each theme as you select it.",
	'cnw-theme-instruction' => 'You can also design your own theme later by going to "My Tools".',
	'cnw-upgrade-headline' => 'Do you want to upgrade?',
	'cnw-upgrade-creative' => 'Upgrading to Wikia Plus allows you to remove ads from <span class="wiki-name"></span>, a one time offer only available to new founders.',
	'cnw-upgrade-marketing' => 'Wikia Plus is a great solution for:<ul>
<li>Professional Wikis</li>
<li>Non-profits</li>
<li>Families</li>
<li>Schools</li>
<li>Personal projects</li>
</ul>
Upgrade through PayPal to get an ad-free wiki for only $4.95 per month!',
	'cnw-upgrade-now' => 'Upgrade Now',
	'cnw-upgrade-decline' => 'No thanks, continue to my wiki',
	'cnw-welcome-headline' => 'Congratulations! $1 has been created',
	'cnw-welcome-instruction1' => 'Click the button below to start adding pages to your wiki.',
	'cnw-welcome-instruction2' => "You'll see this button throughout your wiki, use it any time you want to add a new page.",
	'cnw-welcome-help' => 'Find answers, advice, and more on <a href="http://community.wikia.com">Community Central</a>.',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Anakmalaysia
 * @author Dimension
 * @author Hydra
 * @author Sam Wang
 * @author Yfdyh000
 */
$messages['zh-hans'] = array(
	'cnw-next' => '下一步',
	'cnw-back' => '上一步',
	'cnw-or' => '或',
	'cnw-title' => '创造一个新的维基',
	'cnw-name-wiki-headline' => '开始一个维基',
	'cnw-name-wiki-label' => '给您的维基一个名字',
	'cnw-name-wiki-wiki' => '维基',
	'cnw-login' => '登录',
	'cnw-signup' => '创建帐户',
	'cnw-signup-prompt' => '需要一个帐户吗？',
	'cnw-call-to-signup' => '在这里注册',
	'cnw-login-prompt' => '已有帐户？',
	'cnw-call-to-login' => '在这里登录',
	'cnw-auth-headline' => '登入',
	'cnw-auth-headline2' => '注册',
	'cnw-userauth-headline' => '已拥有帐户？',
	'cnw-userauth-creative' => '登录',
	'cnw-userauth-marketing-heading' => '没有帐户？',
	'cnw-userauth-signup-button' => '注册',
	'cnw-desc-creative' => '描述您的主题',
	'cnw-desc-tip1' => '暗示',
	'cnw-desc-tip1-creative' => '在这里用一两句话向大家介绍您的维基',
	'cnw-desc-tip2' => '喂',
	'cnw-desc-choose' => '选择一个分类',
	'cnw-desc-select-one' => '选一',
	'cnw-desc-default-lang' => '您的维基将位于$1',
	'cnw-desc-change-lang' => '改变',
	'cnw-desc-lang' => '语言',
	'cnw-desc-wiki-submit-error' => '请选一个分类',
	'cnw-theme-headline' => '选择一个主题',
	'cnw-upgrade-headline' => '您是否希望升级？',
	'cnw-upgrade-now' => '立即升级',
	'cnw-upgrade-decline' => '不了谢谢，请继续到我的维基',
	'cnw-welcome-headline' => '恭喜！$1 已创建',
	'cnw-error-database' => '数据库错误：$1',
	'cnw-error-blocked-header' => '帐户被封禁',
	'cnw-error-bot-header' => '您已被识别为机器人',
);

/** Traditional Chinese (中文（繁體）‎)
 * @author Ffaarr
 * @author Oapbtommy
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Wiki 創建嚮導]]',
	'cnw-next' => '下一步',
	'cnw-back' => '前一步',
	'cnw-or' => '或者',
	'cnw-title' => '創建新的 Wiki',
	'cnw-name-wiki-headline' => '建立新的wiki',
	'cnw-name-wiki-creative' => 'Wikia是建立你所喜好的網站和發展社群最好的選擇。',
	'cnw-name-wiki-label' => '給您的wiki一個名字',
	'cnw-name-wiki-wiki' => 'Wiki',
	'cnw-name-wiki-domain-label' => '給您的 wiki 的一個網址',
	'cnw-name-wiki-submit-error' => '啊！您需要填寫上面兩欄之後才能繼續。',
	'cnw-login' => '登入',
	'cnw-signup' => '創建帳號',
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
	'cnw-userauth-marketing-body' => '您需要帳戶才能在wikia創建wiki。只需要一分鐘即可 [[Special:UserSignup|註冊]]!',
	'cnw-userauth-signup-button' => '註冊',
	'cnw-desc-headline' => '你的wiki是關於什麼？',
	'cnw-desc-creative' => '描述您的主題',
	'cnw-desc-placeholder' => '這將顯示你的 wiki 的首頁上。',
	'cnw-desc-tip1' => '提示',
	'cnw-desc-tip1-creative' => '使用此空間以一兩句話來向其他人講述你的 wiki。',
	'cnw-desc-tip2-creative' => '向訪問者提供一些有關你的主題的特定詳細資訊',
	'cnw-desc-tip3' => '提示',
	'cnw-desc-tip3-creative' => '讓人們知道他們可以編輯和增加頁面來幫助你的wiki 增長',
	'cnw-desc-choose' => '選擇一個分類',
	'cnw-desc-select-one' => '選擇一個',
	'cnw-desc-default-lang' => '你的 wiki 將使用$1',
	'cnw-desc-change-lang' => '變更',
	'cnw-desc-lang' => '語言',
	'cnw-desc-wiki-submit-error' => '請選擇一個分類',
	'cnw-theme-headline' => '選擇一個主題',
	'cnw-theme-creative' => '選擇下面其中一個樣式，選擇之後您可以看到每個樣式的預覽。',
	'cnw-theme-instruction' => '您還可以稍後通過"我的工具"設計您自己的樣式。',
	'cnw-upgrade-headline' => '是否要升級？',
	'cnw-upgrade-creative' => '升級到 Wikia Plus 允許您從<span class="wiki-name"></span>，刪除廣告，該功能僅提供於新的創始人，且只能使用一次。',
	'cnw-upgrade-now' => '立即升級',
	'cnw-upgrade-decline' => '不，謝謝，繼續我的 wiki',
	'cnw-welcome-headline' => '恭喜 ！ $1 已創建',
	'cnw-welcome-instruction1' => '按一下下面的按鈕以開始將頁面添加到你的 wiki。',
	'cnw-welcome-instruction2' => '你會在你的 wiki 各頁面看到此按鈕，任何時候可使用它來新加頁面。',
	'cnw-welcome-help' => '要找尋解答、建議以及其他，可到 <a href="http://community.wikia.com">社群中心</a>.',
	'cnw-error-general' => '創建你的 wiki 時發生錯誤，請稍後再試。',
	'cnw-error-general-heading' => '創建新Wiki時發生錯誤',
	'cnw-error-database' => '資料庫錯誤：$1',
	'cnw-badword-msg' => '嗨，請不要使用這些不好的、被禁止的字詞在您的 Wiki 描述：$1',
	'cnw-error-wiki-limit-header' => '到達 Wiki 限制',
	'cnw-error-wiki-limit' => '您好，您受限於每天的 {{PLURAL:$1|$1 wiki creation|$1 wiki創建}} 數量。 請等待24小時之後再創建另一個wiki。.',
	'cnw-error-blocked-header' => '帳戶被封禁',
	'cnw-error-blocked' => '您的帳戶被 $1封禁。 封禁原因是 $2. (被封禁ID: $3)',
	'cnw-error-torblock' => '不允許通過 Tor 網路創建 wiki 。',
	'cnw-error-bot-header' => '你已被檢測到是機器人',
);
