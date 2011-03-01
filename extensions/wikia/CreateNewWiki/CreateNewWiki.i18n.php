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
);

/** Message documentation (Message documentation) */
$messages['qqq'] = array(
	'cnw-next' => 'Text for "Next" Button',
	'cnw-back' => 'Text for "Back" Button',
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
	'cnw-desc-headline' => 'H1 for this step',
	'cnw-desc-creative' => 'Creative or instruction for this step following H1',
	'cnw-desc-placeholder' => 'Placeholder for the textarea',
	'cnw-desc-tip1' => 'First Tip label',
	'cnw-desc-tip1-creative' => 'The first tip',
	'cnw-desc-tip2' => 'Second Tip label',
	'cnw-desc-tip2-creative' => 'The second tip',
	'cnw-desc-tip3' => 'Third Tip label',
	'cnw-desc-tip3-creative' => 'The third tip',
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
	'cnw-desc-tip1' => 'Wenk',
	'cnw-desc-tip2' => 'Pst!',
	'cnw-desc-tip3' => 'Protip',
	'cnw-theme-headline' => 'Ontwerp u wiki',
	'cnw-upgrade-headline' => 'Wil u opgradeer?',
	'cnw-upgrade-now' => 'Opgradeer nou',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 */
$messages['br'] = array(
	'cnw-next' => "War-lerc'h",
	'cnw-back' => 'A-raok',
	'cnw-or' => 'pe',
	'cnw-title' => 'Krouiñ ur wiki nevez',
	'cnw-name-wiki-headline' => 'Kregiñ gant ur wiki',
	'cnw-name-wiki-creative' => "Wikia eo al lec'h gwellañ evit sevel ul lec'hienn wiki ha lakaat ur gumuniezh da greskiñ en-dro d'ar pezh a garit.",
	'cnw-name-wiki-label' => "Roit un anv d'ho wiki",
	'cnw-name-wiki-wiki' => 'Wiki',
	'cnw-name-wiki-domain-label' => "Roit ur chomlec'h d'ho wiki",
	'cnw-name-wiki-submit-error' => 'Bezit sur eo bet leuniet mat an holl vaeziennoù a-us gant monedoù reizh.',
	'cnw-login' => 'Kevreañ',
	'cnw-signup' => 'Krouiñ ur gont',
	'cnw-signup-prompt' => "Ezhomm hoc'h eus ur gont ?",
	'cnw-call-to-signup' => 'Sinit amañ',
	'cnw-login-prompt' => "Ur gont hoc'h eus dija ?",
	'cnw-call-to-login' => 'Kevreit amañ',
	'cnw-auth-headline' => 'Kregiñ gant ur wiki',
	'cnw-auth-creative' => "Kevreit ouzh ho kont evit kenderc'hel da sevel ho wiki.",
	'cnw-desc-headline' => 'Eus petra zo kaoz en ho wiki ?',
	'cnw-desc-creative' => 'Deskrivit ho sujed',
	'cnw-desc-placeholder' => 'Dont a ray war wel war bajenn bennañ ho wiki.',
	'cnw-desc-tip1' => 'Tun 1',
	'cnw-desc-tip1-creative' => "Lavarit d'an dud eus petra zo kaoz en ho wiki",
	'cnw-desc-tip2' => 'Tun 2',
	'cnw-desc-tip2-creative' => 'Ouzhpennit munudoù',
	'cnw-desc-tip3' => 'Tun 3',
	'cnw-desc-choose' => 'Dibabit ur rummad',
	'cnw-desc-select-one' => 'Diuzañ unan',
	'cnw-desc-default-lang' => 'E brezhoneg e vo ho wiki',
	'cnw-desc-change-lang' => 'kemmañ',
	'cnw-desc-lang' => 'Yezh',
	'cnw-desc-wiki-submit-error' => 'Dibabit ur rummad, mar plij',
	'cnw-theme-headline' => 'Krouit ho wiki',
	'cnw-theme-creative' => 'Dibabit un tem a zere ouzh ho wiki.',
	'cnw-upgrade-headline' => "C'hoant hoc'h eus da lakaat a-live ?",
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
	'cnw-welcome-instruction1' => 'Klikit bremañ war ar bouton amañ dindan evit kregiñ da leuniañ ho wiki gant titouroù :',
	'cnw-welcome-instruction2' => "Gwelet a reot ar bouton-mañ hed-ha-hed ho wiki.<br />Grit gantañ bep tro ha ma fello deoc'h ouzhpennañ ur bajenn nevez.",
	'cnw-welcome-help' => 'Kavout a reot respontoù, kuzulioù ha kement zo war <a href="http://community.wikia.com">Kalonenn ar gumuniezh</a>.',
);

/** German (Deutsch)
 * @author George Animal
 * @author LWChris
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
	'cnw-desc-default-lang' => 'Dein Wiki wird in englischer Sprache sein',
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
);

/** Spanish (Español)
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
	'cnw-name-wiki-submit-error' => 'Asegúrate que todos los campos estén rellenados con las entradas válidas anteriores.',
	'cnw-login' => 'Entrar',
	'cnw-signup' => 'Crear una cuenta',
	'cnw-signup-prompt' => '¿Necesitas una cuenta?',
	'cnw-call-to-signup' => 'Regístrate aquí',
	'cnw-login-prompt' => '¿Ya tienes una cuenta?',
	'cnw-call-to-login' => 'Iniciar sesión aquí',
	'cnw-auth-headline' => 'Comenzar una wiki',
	'cnw-auth-creative' => 'Inicia sesión con tu cuenta para continuar la contrucción de tu wiki.',
	'cnw-auth-signup-creative' => 'Necesitarás una cuenta para seguir construyendo tu wiki.<br />¡Solamente tardarás un minuto para registrarte!',
	'cnw-desc-headline' => '¿De qué trata tu wiki?',
	'cnw-desc-creative' => 'Describe el tema',
	'cnw-desc-placeholder' => 'Esto aparecerá en la página principal de tu wiki.',
	'cnw-desc-tip1' => 'Consejo 1',
	'cnw-desc-tip1-creative' => 'Dile a la gente de qué trata tu wiki',
	'cnw-desc-tip2' => 'Consejo 2',
	'cnw-desc-tip2-creative' => 'Asegúrate de incluir detalles',
	'cnw-desc-tip3' => 'Consejo 3',
	'cnw-desc-tip3-creative' => 'Invita a la gente para que ayude a editar',
	'cnw-desc-choose' => 'Elige una categoría',
	'cnw-desc-select-one' => 'Selecciona una',
	'cnw-desc-default-lang' => 'Tu wiki será en inglés',
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
	'cnw-welcome-instruction1' => 'Ahora haz clic al botón de abajo para empezar a llenar tu wiki con información:',
	'cnw-welcome-instruction2' => 'Verás este botón a través de tu wiki.<br />Úsalo en cualquier momento cuando quieras agregar una página nueva.',
	'cnw-welcome-help' => 'Encuentra respuestas, consejos, y más en la <a href="http://es.wikia.com">Comunidad Central</a>.',
);

/** Basque (Euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'cnw-next' => 'Hurrengoa',
	'cnw-back' => 'Atzera',
	'cnw-or' => 'edo',
	'cnw-name-wiki-wiki' => 'Wikia',
	'cnw-desc-lang' => 'Hizkuntza',
);

/** Finnish (Suomi)
 * @author Tofu II
 */
$messages['fi'] = array(
	'cnw-name-wiki-label' => 'Nimeä wikisi',
	'cnw-desc-wiki-submit-error' => 'Valitse luokka',
	'cnw-upgrade-now' => 'Päivitä nyt',
);

/** Hebrew (עברית)
 * @author Amire80
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
	'cnw-desc-default-lang' => 'הוויקי שלכם יהיה באנגלית',
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

/** Interlingua (Interlingua)
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
	'cnw-desc-default-lang' => 'Tu wiki essera in anglese',
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
);

/** Kurdish (Latin) (Kurdî (Latin))
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'cnw-or' => 'an',
	'cnw-signup' => 'Hesabekî çêke',
	'cnw-desc-lang' => 'Ziman',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'createnewwiki-desc' => '[[Special:CreateNewWiki|Помошник за создавање на вики]]',
	'cnw-next' => 'Следно',
	'cnw-back' => 'Назад',
	'cnw-or' => 'или',
	'cnw-title' => 'Создај ново вики',
	'cnw-name-wiki-headline' => 'Започнете вики',
	'cnw-name-wiki-creative' => 'Викија е најдоброто место за да изработите мрежно место и да создадете растечка заедница што се темели на она што го сакате.',
	'cnw-name-wiki-label' => 'Именувајте го викито',
	'cnw-name-wiki-wiki' => 'Вики',
	'cnw-name-wiki-domain-label' => 'Дајте му адреса на викито',
	'cnw-name-wiki-submit-error' => 'Упс! Ќе треба да ги пополните обете горенаведени полиња за да продолжите.',
	'cnw-login' => 'Најава',
	'cnw-signup' => 'Создај сметка',
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
	'cnw-desc-default-lang' => 'Викито ќе биде на македонски јазик',
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
	'cnw-desc-default-lang' => 'Uw wiki wordt in het Engels geschreven',
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
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 */
$messages['no'] = array(
	'cnw-upgrade-marketing' => 'Wikia Pluss er en flott løsning for:<ul>
<li>Profesjonelle wikier</li>
<li>Ideelle prosjekter</li>
<li>Familier</li>
<li>Skoler</li>
<li>Personlige prosjekter</li>
</ul>
Oppgrader gjennom PayPal for å få en reklamefri wiki til kun $4,95 per måned!',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
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
	'cnw-auth-headline' => 'يو ويکي پيلول',
	'cnw-desc-headline' => 'ستاسې ويکي د څه په اړه دی؟',
	'cnw-desc-placeholder' => 'دا به ستاسې د ويکي په لومړي مخ ښکاره شي.',
	'cnw-desc-tip1-creative' => 'خلکو ته ووايۍ چې ستاسې ويکي د څه په اړه دی',
	'cnw-desc-choose' => 'يوه وېشنيزه ټاکل',
	'cnw-desc-select-one' => 'يو وټاکۍ',
	'cnw-desc-default-lang' => 'ستاسې ويکي به په انګرېزي ژبه وي',
	'cnw-desc-change-lang' => 'بدلول',
	'cnw-desc-lang' => 'ژبه',
	'cnw-desc-wiki-submit-error' => 'يوه وېشنيزه وټاکۍ',
	'cnw-theme-headline' => 'خپل ويکي سکښتل',
	'cnw-welcome-headline' => 'بختور مو شه، د $1 ويکي جوړ شو',
);

/** Serbian Cyrillic ekavian (‪Српски (ћирилица)‬)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'cnw-next' => 'Напред',
	'cnw-back' => 'Назад',
	'cnw-or' => 'или',
	'cnw-title' => 'Прављење нове викије',
	'cnw-name-wiki-headline' => 'Започињање викије',
	'cnw-name-wiki-label' => 'Дајте назив викији',
	'cnw-name-wiki-wiki' => 'Викија',
	'cnw-login' => 'Пријави ме',
	'cnw-signup' => 'Отвори налог',
	'cnw-signup-prompt' => 'Немате налог?',
	'cnw-call-to-signup' => 'Отворите налог овде',
	'cnw-call-to-login' => 'Пријавите се овде',
	'cnw-auth-headline' => 'Започните викију',
	'cnw-desc-headline' => 'Шта се ради на овој викији?',
	'cnw-desc-creative' => 'Опишите тему',
	'cnw-desc-tip1' => 'Први савет',
	'cnw-desc-tip2' => 'Други савет',
	'cnw-desc-tip2-creative' => 'Не заборавите да додате детаље',
	'cnw-desc-tip3' => 'Трећи савет',
	'cnw-desc-choose' => 'Изаберите категорију',
	'cnw-desc-change-lang' => 'промени',
	'cnw-desc-lang' => 'Језик',
	'cnw-desc-wiki-submit-error' => 'Изаберите категорију',
	'cnw-upgrade-headline' => 'Желите ли да доградите?',
);

/** Swedish (Svenska)
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'cnw-next' => 'Nästa',
	'cnw-back' => 'Tillbaka',
	'cnw-or' => 'eller',
	'cnw-title' => 'Skapa en ny Wiki',
	'cnw-name-wiki-headline' => 'Starta en Wiki',
	'cnw-name-wiki-label' => 'Ge din wiki ett namn',
	'cnw-name-wiki-wiki' => 'Wiki',
	'cnw-login' => 'Logga in',
	'cnw-signup' => 'Skapa konto',
	'cnw-signup-prompt' => 'Behöver du ett konto?',
	'cnw-call-to-signup' => 'Registrera dig här',
	'cnw-login-prompt' => 'Har du redan ett konto?',
	'cnw-call-to-login' => 'Logga in här',
	'cnw-auth-headline' => 'Starta en wiki',
	'cnw-auth-creative' => 'Logga in på ditt konto för att fortsätta bygga på din wiki.',
	'cnw-auth-signup-creative' => 'Du kommer att behöva ett konto för att fortsätta bygga på din wiki. <br /> Det tar bara en minut att registrera dig!',
	'cnw-desc-headline' => 'Vad handlar din wiki om?',
	'cnw-desc-creative' => 'Beskriv ditt ämne',
	'cnw-desc-placeholder' => 'Det här kommer att visas på huvudsidan i din wiki.',
	'cnw-desc-tip1' => 'Tips 1',
	'cnw-desc-tip1-creative' => 'Berätta för folk vad din wiki handlar om',
	'cnw-desc-tip2' => 'Tips 2',
	'cnw-desc-tip3' => 'Tips 3',
	'cnw-desc-choose' => 'Välj en kategori',
	'cnw-desc-select-one' => 'Välj en',
	'cnw-desc-default-lang' => 'Din wiki kommer att vara på engelska',
	'cnw-desc-change-lang' => 'ändra',
	'cnw-desc-lang' => 'Språk',
	'cnw-desc-wiki-submit-error' => 'Välj en kategori',
	'cnw-theme-headline' => 'Designa din wiki',
	'cnw-theme-creative' => 'Välj ett tema som passar din wiki.',
	'cnw-upgrade-headline' => 'Vill du uppgradera?',
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
	'cnw-welcome-instruction1' => 'Klicka på knappen nedan för att börja fylla din wiki med information:',
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
	'cnw-auth-headline' => 'వికీని మొదలుపెట్టడం',
	'cnw-desc-tip1' => 'చిట్కా 1',
	'cnw-desc-tip1-creative' => 'మీ వికీ దేని గురించో ప్రజలకు చెప్పండి',
	'cnw-desc-tip2' => 'చిట్కా 2',
	'cnw-desc-tip2-creative' => 'వివరాలను చేర్చడం మర్చిపోకండి',
	'cnw-desc-tip3' => 'చిట్కా 3',
	'cnw-desc-tip3-creative' => 'తోడ్పడమని ప్రజలని ఆహ్వానించండి',
	'cnw-desc-choose' => 'వర్గాన్ని ఎంచుకోండి',
	'cnw-desc-default-lang' => 'మీ వికీ ఆంగ్లంలో ఉంటుంది',
	'cnw-desc-change-lang' => 'మార్చండి',
	'cnw-desc-lang' => 'భాష',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hydra
 */
$messages['zh-hans'] = array(
	'cnw-next' => '下一步',
	'cnw-back' => '前一步',
	'cnw-or' => '或',
	'cnw-title' => '创造一个新的维基',
	'cnw-name-wiki-headline' => '开始一个维基',
	'cnw-login' => '登录',
);

