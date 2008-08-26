<?php
/**
 * Internationalization file for the Replace Text extension
 *
 * @addtogroup Extensions
*/

$messages = array();

/** English
 * @author Yaron Koren
 */
$messages['en'] = array(
	// user messages
	'replacetext' => 'Replace text',
	'replacetext-desc' => 'Provides a [[Special:ReplaceText|special page]] to allow administrators to do a global string find-and-replace on all the content pages of a wiki',
	'replacetext_docu' => 'To replace one text string with another across all regular pages on this wiki, enter the two pieces of text here and then hit \'Continue\'. You will then be shown a list of pages that contain the search text, and you can choose the ones in which you want to replace it. Your name will appear in page histories as the user responsible for any changes.',
	'replacetext_note' => 'Note: this will not replace text in "Talk" pages and project pages, and it will not replace text in page titles themselves.',
	'replacetext_originaltext' => 'Original text',
	'replacetext_replacementtext' => 'Replacement text',
	'replacetext_choosepages' => 'Please select the pages for which you want to replace \'$1\' with \'$2\':',
	'replacetext_replace' => 'Replace',
	'replacetext_success' => '\'$1\' will be replaced with \'$2\' in $3 pages.',
	'replacetext_noreplacement' => 'No pages were found containing the string \'$1\'.',
	'replacetext_warning' => 'There are $1 pages that already contain the replacement string, \'$2\'; if you make this replacement you will not be able to separate your replacements from these strings. Continue with the replacement?',
	'replacetext_blankwarning' => 'Because the replacement string is blank, this operation will not be reversible; continue?',
	'replacetext_continue' => 'Continue',
	'replacetext_cancel' => '(Hit the "Back" button to cancel the operation.)',
	// content messages
	'replacetext_editsummary' => 'Text replace - \'$1\' to \'$2\'',
);

/** Arabic (العربية)
 * @author Alnokta
 * @author OsamaK
 * @author Meno25
 */
$messages['ar'] = array(
	'replacetext'                 => 'استبدل النص',
	'replacetext_originaltext'    => 'النص الأصلي',
	'replacetext_replacementtext' => 'نص الاستبدال',
	'replacetext_replace'         => 'استبدل',
	'replacetext_success'         => "'$2' سيتم استبدالها ب'$1' في $3 صفحة.",
	'replacetext_continue'        => 'استمر',
	'replacetext_editsummary'     => "استبدال النص - '$1' ب'$2'",
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Siebrand
 */
$messages['bg'] = array(
	'replacetext'                 => 'Заместване на текст',
	'replacetext-desc'            => 'Предоставя [[Special:ReplaceText|специална страница]], чрез която администраторите могат да извършват глобално откриване-и-заместване на низове в страниците на уикито',
	'replacetext_note'            => 'Забележка: този метод няма да замести текста в дискусионните страници и проектните страници, както няма да го замести и в заглавията на страниците.',
	'replacetext_originaltext'    => 'Оригинален текст',
	'replacetext_replacementtext' => 'Текст за заместване',
	'replacetext_choosepages'     => "Изберете страници, в които желаете да замените '$1' с '$2':",
	'replacetext_replace'         => 'Заместване',
	'replacetext_success'         => "Заместване на '$1' с '$2' в $3 страници.",
	'replacetext_noreplacement'   => "Не бяха открити страници, съдържащи низа '$1'.",
	'replacetext_blankwarning'    => 'Тъй като низът за заместване е празен, процесът на заместване е необратим; продължаване?',
	'replacetext_continue'        => 'Продължаване',
	'replacetext_cancel'          => '(натиснете бутона „Back“ за прекратяване на действието.)',
	'replacetext_editsummary'     => "Заместване на текст - '$1' на '$2'",
);

/** Czech (Česky)
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'replacetext'                 => 'Nahradit text',
	'replacetext_originaltext'    => 'Původní text',
	'replacetext_replacementtext' => 'Nahradit textem',
	'replacetext_replace'         => 'Nahradit',
	'replacetext_continue'        => 'Pokračovat',
	'replacetext_cancel'          => '(Operaci zrušíte kliknutím na tlačítko „Zpět“ ve vašem prohlížeči.)',
	'replacetext_editsummary'     => 'Nahrazení textu „$1“ textem „$2“',
);

/** German (Deutsch)
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'replacetext'                 => 'Text ersetzen',
	'replacetext-desc'            => 'Ergänzt eine [[Special:ReplaceText|Spezialseiten]], die es Administratoren ermöglicht, eine globale Text suchen-und-ersetzen Operation in allen Inhaltseiten des Wikis durchzuführen',
	'replacetext_docu'            => 'Um einen Text durch einen anderen Text auf allen Inhaltsseiten zu ersetzen, gib die beiden Textteile hier ein und klicke auf die Ersetzen-Schaltfläche. Dein Benutzername wird in der Versionsgeschichte aufgenommen.',
	'replacetext_note'            => 'Bitte beachten: es wird kein Text auf Diskussions- und Projektseiten ausgetauscht. Auch Text in Artikelnamen wird nicht ausgetauscht.',
	'replacetext_originaltext'    => 'Originaltext',
	'replacetext_replacementtext' => 'Neuer Text',
	'replacetext_replace'         => 'Ersetzen',
	'replacetext_success'         => '„$1“ wird durch „$2“ in $3 Seiten ersetzt.',
	'replacetext_noreplacement'   => 'Es wurde keine Seite gefunden, die den Text „$1“ enthält.',
	'replacetext_warning'         => '$1 Seiten enthalten bereits den zu ersetzenden Textteil „$2“; eine Trennug der Ersetzungen mit den bereits vorhandenen Textteilen ist nicht möglich. Möchtest du weitermachen?',
	'replacetext_blankwarning'    => 'Der zu ersetzende Textteil ist leer, die Operation kann nicht rückgängig gemacht werden, trotzdem fortfahren?',
	'replacetext_continue'        => 'Fortfahren',
	'replacetext_cancel'          => '(Klicke auf die „Zurück“-Schaltfläche, um die Operation abzubrechen.)',
	'replacetext_editsummary'     => 'Textersetzung - „$1“ durch „$2“',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'replacetext'                 => 'Anstataŭigi tekston',
	'replacetext_originaltext'    => 'Originala teksto',
	'replacetext_replacementtext' => 'Anstataŭigita teksto',
	'replacetext_replace'         => 'Anstataŭigi',
	'replacetext_success'         => "Anstataŭigis tekston '$1' kun '$2' en $3 paĝoj.",
	'replacetext_noreplacement'   => "Neniuj paĝoj estis trovitaj enhavantaj la ĉenon '$1'.",
	'replacetext_continue'        => 'Reaktivigi',
	'replacetext_editsummary'     => "Teksta anstataŭigo - '$1' al '$2'",
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'replacetext'                 => 'جایگزینی متن',
	'replacetext-desc'            => 'یک [[Special:ReplaceText|صفحهٔ ویژه]] اضافه می‌کند که به مدیران اجازه می‌دهد یک جستجو و جایگزینی سراسری در تمام محتوای ویکی انجام دهند',
	'replacetext_docu'            => 'برای جایگزین کردن یک رشتهٔ متنی با رشته دیگر در کل داده‌های این ویکی، شما می‌توانید دو متن را در زیر وارد کرده و دکمهٔ «جایگزین کن» را بزنید. اسم شما در تاریخچهٔ صفحه‌ها به عنوان کاربری که مسئول این تغییرها است ثبت می‌شود.',
	'replacetext_note'            => 'نکته: این روش متن صفحه‌های بحث و صفحه‌های پروژه را تغییر نمی‌دهد، و عنوان صفحه‌ها را نیز تغییر نمی‌دهد.',
	'replacetext_originaltext'    => 'متن اصلی',
	'replacetext_replacementtext' => 'متن جایگزین',
	'replacetext_replace'         => 'جایگزین کن',
	'replacetext_success'         => "در $3 صفحه '$1' را با '$2' جایگزین کرد.",
	'replacetext_noreplacement'   => "جایگزینی انجام نشد؛ صفحه‌ای که حاوی '$1' باشد پیدا نشد.",
	'replacetext_warning'         => "در حال حاضر $1 حاوی متن جایگزین، '$2'، هستند؛ اگر شما این جایگزینی را انجام دهید قادر نخواهید بود که مواردی که جایگزین کردید را از مواردی که از قبل وجود داشته تفکیک کنید. آیا ادامه می‌دهید؟",
	'replacetext_blankwarning'    => 'چون متن جایگزین خالی است، این عمل قابل بازگشت نخواهد بود؛ ادامه می‌دهید؟',
	'replacetext_continue'        => 'ادامه',
	'replacetext_cancel'          => '(دکمهٔ «بازگشت» را بزنید تا عمل را لغو کنید.)',
	'replacetext_editsummary'     => "جایگزینی متن - '$1' به '$2'",
);

/** French (Français)
 * @author Grondin
 * @author Verdy p
 */
$messages['fr'] = array(
	'replacetext'                 => 'Remplacer le texte',
	'replacetext-desc'            => 'Fournit une page spéciale permettant aux administrateurs de remplacer des chaînes de caractères par d’autres sur l’ensemble du wiki',
	'replacetext_docu'            => "Pour remplacer une chaîne de caractères avec une autre sur l'ensemble des données des pages de ce wiki, vous pouvez entrez les deux textes ici et cliquer sur « Remplacer ». Votre nom apparaîtra dans l'historique des pages tel un utilisateur auteur des changements.",
	'replacetext_note'            => 'Note : ceci ne remplacera pas le texte dans les pages de discussion ainsi que dans les pages « projet ». Il ne remplacera pas, non plus, le texte dans le titre lui-même.',
	'replacetext_originaltext'    => 'Texte original',
	'replacetext_replacementtext' => 'Nouveau texte',
	'replacetext_choosepages'     => 'Veuillez sélectionner les pages dans lesquelles vous voulez remplacer « $1 » par « $2 » :',
	'replacetext_replace'         => 'Remplacer',
	'replacetext_success'         => 'A remplacé « $1 » par « $2 » dans « $3 » fichiers.',
	'replacetext_noreplacement'   => 'Aucun fichier contenant la chaîne « $1 » n’a été trouvé.',
	'replacetext_warning'         => 'Il y a $1 fichiers qui contient la chaîne de remplacement « $2 » ; si vous effectuer cette substitution, vous ne pourrez pas séparer vos changements à partir de ces chaînes. Voulez-vous continuez ces substitutions ?',
	'replacetext_blankwarning'    => 'Parce que la chaîne de remplacement est vide, cette opération sera irréversible ; voulez-vous continuer ?',
	'replacetext_continue'        => 'Continuer',
	'replacetext_cancel'          => "(cliquez sur le bouton  « Retour » pour annuler l'opération.)",
	'replacetext_editsummary'     => 'Remplacement du texte — « $1 » par « $2 »',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'replacetext'                 => 'Substituír un texto',
	'replacetext-desc'            => 'Proporciona unha [[Special:ReplaceText|páxina especial]] para que os administradores poidan facer unha cadea global para atopar e substituír un texto no contido de todas as páxinas dun wiki',
	'replacetext_docu'            => 'Para substituír unha cadea de texto por outra en todas as páxinas regulares deste wiki, teclee aquí as dúas pezas do texto e logo prema en "Continuar". Despois amosaráselle unha lista das páxinas que conteñen o texto buscado e pode elixir en cales quere substituílo. O seu nome aparecerá nos histotiais das páxinas como o usuario responsable de calquera cambio.',
	'replacetext_note'            => 'Nota: isto non substituirá o texto nas páxinas de "Conversa" nin nas páxinas do proxecto, nin tampouco no texto dos títulos.',
	'replacetext_originaltext'    => 'Texto orixinal',
	'replacetext_replacementtext' => 'Reemprazo de texto',
	'replacetext_choosepages'     => "Por favor, seleccione as páxinas na que quere substituír '$1' por '$2':",
	'replacetext_replace'         => 'Reemprazar',
	'replacetext_success'         => "'$1' será reemprazado con '$2' en $3 páxinas.",
	'replacetext_noreplacement'   => "Non foi atopada ningunha páxina que contivese a cadea '$1'.",
	'replacetext_warning'         => "Hai $1 páxinas que xa conteñen a cadea de substitución '$2'; se fai esta substitución non poderá separar os seus reemprazamentos destas cadeas. Quere continuar coa substitución?",
	'replacetext_blankwarning'    => 'Debido a que a cadea de substitución está baleira, esta operación non será reversible; quere continuar?',
	'replacetext_continue'        => 'Continuar',
	'replacetext_cancel'          => '(Prema no botón "Atrás" do seu navegador para cancelar a operación.)',
	'replacetext_editsummary'     => 'Reemprazo de texto - de "$1" a "$2"',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'replacetext'              => 'Ganti tèks',
	'replacetext_originaltext' => 'Tèks asli',
	'replacetext_continue'     => 'Banjurna',
);

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'replacetext'                 => 'ជំនួសអត្ថបទ',
	'replacetext_originaltext'    => 'អត្ថបទដើម',
	'replacetext_replacementtext' => 'អត្ថបទជំនួស',
	'replacetext_replace'         => 'ជំនួស',
	'replacetext_success'         => "បានជំនួស '$1' ដោយ '$2' ក្នុង $3 ទំព័រ។",
	'replacetext_continue'        => 'បន្ត',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'replacetext'                 => 'Text ersetzen',
	'replacetext-desc'            => "Weist eng [[Special:ReplaceText|Spezialsäit]] déi Administrateuren et erlaabt eng Rei vun Textzeechen op alle Contenu-säiten vun enger Wiki ze gesinn an z'ersetzen",
	'replacetext_note'            => "'''Oppassen''': Den Text gëtt net an \"Diskussiounssäiten\" a Projetssäiten ersat, an den Text an de Säitenimm gëtt och net ersat.",
	'replacetext_originaltext'    => 'Originaltext',
	'replacetext_replacementtext' => 'Neien Text',
	'replacetext_replace'         => 'Ersetzen',
	'replacetext_success'         => "'$1' gëtt duerch '$2' op $3 Säiten ersat.",
	'replacetext_continue'        => 'Weiderfueren',
	'replacetext_editsummary'     => "Text ersat - '$1' duerch '$2'",
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'replacetext_continue' => 'തുടരുക',
	'replacetext_cancel'   => '(ഈ പ്രവര്‍ത്തനം നിരാകരിക്കുവാന്‍ "തിരിച്ചു പോവുക" ബട്ടണ്‍ ഞെക്കുക)',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Siebrand
 */
$messages['mr'] = array(
	'replacetext'                 => 'मजकूरावर पुनर्लेखन करा',
	'replacetext-desc'            => 'एक [[Special:ReplaceText|विशेष पान]] देते ज्याच्यामुळे प्रबंधकांना एखाद्या विकिवरील सर्व पानांमध्ये शोधा व बदला सुविधा वापरता येते',
	'replacetext_docu'            => "एखाद्या विकितील सर्व डाटा पानांवरील एखादा मजकूर बदलायचा झाल्यास, मजकूराचे दोन्ही तुकडे खाली लिहून 'पुनर्लेखन करा' कळीवर टिचकी द्या. तुम्हाला एक यादी दाखविली जाईल व त्यामधील कुठली पाने बदलायची हे तुम्ही ठरवू शकता. तुमचे नाव त्या पानांच्या इतिहास यादीत दिसेल.",
	'replacetext_note'            => 'सूचना: ह्यामुळे "चर्चा" पाने तसेच प्रकल्प पाने यांच्यावर बदल होणार नाहीत, तसेच शीर्षके सुद्धा बदलली जाणार नाहीत.',
	'replacetext_originaltext'    => 'मूळ मजकूर',
	'replacetext_replacementtext' => 'बदलण्यासाठीचा मजकूर',
	'replacetext_choosepages'     => "ज्या पानांवर तुम्ही  '$1' ला '$2' ने बदलू इच्छिता ती पाने निवडा:",
	'replacetext_replace'         => 'पुनर्लेखन करा',
	'replacetext_success'         => "'$1' ला '$2' ने $3 पानांवर बदलले जाईल.",
	'replacetext_noreplacement'   => "'$1' मजकूर असणारे एकही पान सापडले नाही.",
	'replacetext_warning'         => "अगोदरच $1 पानांवर '$2' हा बदलण्यासाठीचा मजकूर आहे; जर तुम्ही पुनर्लेखन केले तर तुम्ही केलेले बदल तुम्ही या पानांपासून वेगळे करू शकणार नाही. पुनर्लेखन करायचे का?",
	'replacetext_blankwarning'    => 'बदलण्यासाठीचा मजकूर रिकामा असल्यामुळे ही क्रिया उलटविता येणार नाही; पुढे जायचे का?',
	'replacetext_continue'        => 'पुनर्लेखन करा',
	'replacetext_cancel'          => '(क्रिया रद्द करण्यासाठी "Back" कळीवर टिचकी द्या.)',
	'replacetext_editsummary'     => "मजकूर पुनर्लेखन - '$1' ते '$2'",
);

/** Dutch (Nederlands)
 * @author Siebrand
 * @author SPQRobin
 */
$messages['nl'] = array(
	'replacetext'                 => 'Tekst vervangen',
	'replacetext-desc'            => "Beheerders kunnen via een [[Special:ReplaceText|speciale pagina]] tekst zoeken en vervangen in alle pagina's",
	'replacetext_docu'            => "Om een stuk tekst te vervangen door een ander stuk tekst in alle pagina's van de wiki, kunt u hier deze twee tekstdelen ingeven en daarna op 'Vervangen' klikken.
U krijgt dan een lijst met pagina's te zien waar uw te vervangen tekstdeel in voorkomt, en u kunt kiezen in welke pagina's u de tekst ook echt wilt vervangen.
Uw naam wordt opgenomen in de geschiedenis van de pagina als verantwoordelijke voor de wijzigingen.",
	'replacetext_note'            => "Nota bene: de tekst wordt niet vevangen in overlegpagina's en projectpagina's. Paginanamen worden ook niet aangepast.",
	'replacetext_originaltext'    => 'Oorspronkelijke tekst',
	'replacetext_replacementtext' => 'Vervangende tekst',
	'replacetext_choosepages'     => "Selecteer de pagina's waar u '$1' door '$2' wilt vervangen:",
	'replacetext_replace'         => 'Vervangen',
	'replacetext_success'         => "'$1' wordt in $3 pagina's vervangen door '$2'.",
	'replacetext_noreplacement'   => "Er waren geen pagina's die de tekst '$1' bevatten.",
	'replacetext_warning'         => "Er zijn $1 pagina's die het te vervangen tesktdeel al '$2' al bevatten. Als u nu doorgaat met vervangen, kunt u geen onderscheid meer maken. Wilt u doorgaan?",
	'replacetext_blankwarning'    => 'Omdat u tekst vervangt door niets, kan deze handeling niet ongedaan gemaakt worden. Wilt u doorgaan?',
	'replacetext_continue'        => 'Doorgaan',
	'replacetext_cancel'          => '(Klik op de knop "Terug" om deze handeling te annuleren)',
	'replacetext_editsummary'     => "Tekst vervangen - '$1' door '$2'",
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'replacetext'                 => 'Erstatt tekst',
	'replacetext-desc'            => 'Lar administratorer kunne [[Special:ReplaceText|erstatte tekst]] på alle innholdssider på en wiki.',
	'replacetext_docu'            => 'For å erstatte én tekststreng med en annen på alle datasider på denne wikien kan du skrive inn de to tekstene her og trykke «Erstatt». Du vil da bli ført til en liste over sider som inneholder søketeksten, og du kan velge hvilke sider du ønsker å erstatte den i. Navnet ditt vil stå i sidehistorikkene som den som er ansvarlig for endringene.',
	'replacetext_note'            => 'Merk: dette vil ikke erstatte tekst på diskusjonssider og prosjektsider, og vil ikke erstatte tekst i sidetitler.',
	'replacetext_originaltext'    => 'Originaltekst',
	'replacetext_replacementtext' => 'Erstatningstekst',
	'replacetext_choosepages'     => 'Velg hvilke sider du ønsker å erstatte «$1» med «$2» i:',
	'replacetext_replace'         => 'Erstatt',
	'replacetext_success'         => '«$1» blir erstattet med «$2» på {{PLURAL:$3|én side|$3 sider}}.',
	'replacetext_noreplacement'   => 'Ingen sider ble funnet med strengen «$1».',
	'replacetext_warning'         => 'Det er $1 sider som allerede har erstatningsteksten «$2». Om du gjør denne erstatningen vil du ikke kunne skille ut dine erstatninger fra denne teksten. Fortsette med erstattingen?',
	'replacetext_blankwarning'    => 'Fordi erstatningsteksten er tom vil denne handlingen ikke kunne angres automatisk; fortsette?',
	'replacetext_continue'        => 'Fortsett',
	'replacetext_cancel'          => '(Trykk på «Tilbake»-knappen for å avbryte handlingen.)',
	'replacetext_editsummary'     => 'Teksterstatting – «$1» til «$2»',
);

/** Occitan (Occitan)
 * @author Cedric31
 * @author Siebrand
 */
$messages['oc'] = array(
	'replacetext'                 => 'Remplaçar lo tèxt',
	'replacetext-desc'            => 'Provesís una [[Special:ReplaceText|pagina especiala]] que permet als administrators de remplaçar de cadenas de caractèrs per d’autras sus l’ensemble del wiki',
	'replacetext_docu'            => "Per remplaçar una cadena de caractèrs amb una autra sus l'ensemble de las donadas de las paginas d'aqueste wiki, podètz picar los dos tèxtes aicí e clicar sus 'Remplaçar'. Vòstre nom apareiserà dins l'istoric de las paginas tal coma un utilizaire autor dels cambiaments.",
	'replacetext_note'            => 'Nòta : aquò remplaçarà pas lo tèxt dins las paginas de discussion ni mai dins las paginas « projècte ». Remplaçarà pas, tanpauc, lo tèxt dins lo títol ele meteis.',
	'replacetext_originaltext'    => 'Tèxt original',
	'replacetext_replacementtext' => 'Tèxt novèl',
	'replacetext_choosepages'     => 'Seleccionatz las paginas sus lasqualas volètz remplaçar « $1 » per « $2 » :',
	'replacetext_replace'         => 'Remplaçar',
	'replacetext_success'         => '« $1 » es estat remplaçat per « $2 » dins « $3 » paginas.',
	'replacetext_noreplacement'   => 'Cap de fichièr que conten la cadena « $1 » es pas estat trobat.',
	'replacetext_warning'         => "I a $1 fichièrs que conten(on) la cadena de remplaçament « $2 » ; se efectuatz aquesta substitucion, poiretz pas separar vòstres cambiaments a partir d'aquestas cadenas. Volètz contunhar aquestas substitucions ?",
	'replacetext_blankwarning'    => 'Perque la cadena de remplaçament es voida, aquesta operacion serà irreversibla ; volètz contunhar ?',
	'replacetext_continue'        => 'Contunhar',
	'replacetext_cancel'          => "(clicatz sul boton  « Retorn » per anullar l'operacion.)",
	'replacetext_editsummary'     => 'Remplaçament del tèxt — « $1 » per « $2 »',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'replacetext'                 => 'Zastąp tekst',
	'replacetext-desc'            => 'Dodaje [[Special:ReplaceText|stronę specjalną]], pozwalającą administratorom na wyszukanie i zamianę zadanego tekstu w treści wszystkich stron wiki',
	'replacetext_docu'            => 'Możesz zastąpić jeden ciąg znaków innym, w treści wszystkich stron tej wiki. W tym celu wprowadź dwa fragmenty tekstu i naciśnij „Kontynuuj”. Zostanie pokazana lista stron, które zawierają wyszukiwany tekst. Będziesz mógł wybrać te strony, na których chcesz ten tekst zamienić na nowy. W historii zmian stron, do opisu autora edycji, zostanie użyta Twoja nazwa użytkownika.',
	'replacetext_note'            => 'Uwaga: wyszukiwanie i zastępowanie nie dotyczy stron dyskusji, stron projektów oraz tytułów stron.',
	'replacetext_originaltext'    => 'Znajdź',
	'replacetext_replacementtext' => 'Zamień na',
	'replacetext_choosepages'     => 'Wybierz strony, na których chcesz „$1” zmienić na „$2”',
	'replacetext_replace'         => 'Zastąp',
	'replacetext_success'         => '„$1” zostanie zastąpiony przez „$2” na $3 {{PLURAL:$3|stronie|stronach}}.',
	'replacetext_noreplacement'   => 'Nie znaleziono stron zawierających tekst „$1”.',
	'replacetext_warning'         => 'Jest $1 {{PLURAL:$1|strona|stron}} zawierających tekst „$2”, którym chcesz zastępować. Jeśli wykonasz zastępowanie nie będzie możliwe odseparowanie tych stron od wykonanych zastąpień. Czy mam kontynuować zastępowanie?',
	'replacetext_blankwarning'    => 'Ponieważ ciąg znaków, którym ma być wykonane zastępowanie jest pusty, operacja będzie nieodwracalna. Czy kontynuować?',
	'replacetext_continue'        => 'Kontynuuj',
	'replacetext_cancel'          => '(Wciśnij klawisz „Wstecz” aby przerwać operację)',
	'replacetext_editsummary'     => 'zamienił w treści „$1” na „$2”',
);

/** Portuguese (Português)
 * @author 555
 * @author Siebrand
 */
$messages['pt'] = array(
	'replacetext'                 => 'Substituir texto',
	'replacetext-desc'            => 'Provê uma [[Special:ReplaceText|página especial]] que permite que administradores procurem e substituam uma "string" global em todas as páginas de conteúdo de uma wiki.',
	'replacetext_docu'            => 'Para substituir uma "string" de texto por outra em todas as páginas desta wiki você precisa fornecer as duas peças de texto a seguir, pressionando o botão \'Substituir\'. Será exibida uma lista de páginas que contenham o termo pesquisado, sendo possível selecionar em quais você deseja realizar substituições. Seu nome de utilizador aparecerá nos históricos de páginas como o responsável por ter feito as alterações.',
	'replacetext_note'            => 'Nota: isto não substituirá textos em páginas de discussão e organizacionais do projeto, além de não substituir texto nos títulos de páginas.',
	'replacetext_originaltext'    => 'Texto original',
	'replacetext_replacementtext' => 'Novo texto',
	'replacetext_choosepages'     => "Seleccione as páginas nas quais deseja substituir '$1' por '$2':",
	'replacetext_replace'         => 'Substituir',
	'replacetext_success'         => "'$1' será substituído por '$2' em $3 páginas.",
	'replacetext_noreplacement'   => 'Não foram encontradas páginas contendo a "string" \'$1\'.',
	'replacetext_warning'         => 'Há $1 páginas que atualmente já possuem a "string" de substituição (\'$2\'); se você prosseguir, não será possível distinguir as substituições feitas por você desse texto já existente. Deseja prosseguir?',
	'replacetext_blankwarning'    => 'Uma vez que a "string" de novo texto foi deixada em branco, esta operação não será reversível. Prosseguir?',
	'replacetext_continue'        => 'Prosseguir',
	'replacetext_cancel'          => '(pressione o botão "voltar" de seu navegador para cancelar a operação.)',
	'replacetext_editsummary'     => "Substituindo texto '$1' por '$2'",
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Enqd
 */
$messages['pt-br'] = array(
	'replacetext'                 => 'Substituir texto',
	'replacetext-desc'            => 'Fornece uma [[Special:ReplaceText|página especial]] que permite que administradores procurem e substituam uma "string" global em todas as páginas de conteúdo de uma wiki.',
	'replacetext_docu'            => 'Para substituir uma "string" de texto por outra em todas as páginas desta wiki você precisa fornecer o texto a ser substituído e o novo texto, logo em seguida pressione o botão \'Substituir\'. Será exibida uma lista de páginas que contenham o termo pesquisado, sendo possível selecionar em quais você deseja realizar substituições. Seu nome de utilizador aparecerá nos históricos de páginas como o responsável por ter feito as alterações.',
	'replacetext_note'            => 'Nota: isto não substituirá textos em páginas de discussão e organizacionais do projeto, além de não substituir texto nos títulos de páginas.',
	'replacetext_originaltext'    => 'Texto original',
	'replacetext_replacementtext' => 'Novo texto',
	'replacetext_choosepages'     => "Selecione as páginas nas quais deseja substituir '$1' por '$2':",
	'replacetext_replace'         => 'Substituir',
	'replacetext_success'         => "'$1' será substituído por '$2' em $3 páginas.",
	'replacetext_noreplacement'   => 'Não foram encontradas páginas contendo a "string" \'$1\'.',
	'replacetext_warning'         => 'Há $1 páginas que atualmente já possuem a "string" de substituição (\'$2\'); se você prosseguir, não será possível distinguir as substituições feitas por você desse texto já existente. Deseja prosseguir?',
	'replacetext_blankwarning'    => 'Uma vez que a "string" de novo texto foi deixada em branco, esta operação não será reversível. Prosseguir?',
	'replacetext_continue'        => 'Prosseguir',
	'replacetext_cancel'          => '(pressione o botão "voltar" de seu navegador para cancelar a operação.)',
	'replacetext_editsummary'     => "Substituindo texto '$1' por '$2'",
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'replacetext'                 => 'Nahradiť text',
	'replacetext-desc'            => 'Poskytuje [[Special:ReplaceText|špeciálnu stránku]], ktorá správcom umožňuje globálne nájsť a nahradiť text na všetkých stránkach celej wiki.',
	'replacetext_docu'            => 'Nájsť text na všetkých stránkach tejto wiki a nahradiť ho iným textom môžete tak, že sem napíšete texty a stlačíte „Pokračovať”. Potom sa vám zobrazí zoznam stránok obsahujúcich hľadaný text a môžete si zvoliť tie, na ktorých ho chcete nahradiť. V histórii úprav sa zaznamená vaše meno.',
	'replacetext_note'            => 'Pozn.: Týmto nemožno nahradiť text na diskusných a projektových stránkach ani text v samotných názvoch stránok.',
	'replacetext_originaltext'    => 'Pôvodný text',
	'replacetext_replacementtext' => 'Nahradiť textom',
	'replacetext_choosepages'     => 'Prosím, vyberte stránky, na ktorých chcete nahradiť „$1“ za „$2“:',
	'replacetext_replace'         => 'Nahradiť',
	'replacetext_success'         => 'Text „$1” bude nahradený textom „$2” na {{PLURAL:$3|$3 stránke|$3 stránkach}}.',
	'replacetext_noreplacement'   => 'Nenašli sa žiadne stránky obsahujúce text „$1”.',
	'replacetext_warning'         => '$1 stránok už obsahuje text „$2”, ktorým chcete text nahradiť; ak budete pokračovať a text nahradíte, nebudete môcť odlíšiť vaše nahradenia od existujúceho textu, ktorý tento reťazec už obsahuje. Pokračovať?',
	'replacetext_blankwarning'    => 'Pretože text, ktorým text chcete nahradiť je prázdny, operácia bude nevratná. Pokračovať?',
	'replacetext_continue'        => 'Pokračovať',
	'replacetext_cancel'          => '(Operáciu zrušíte stlačením tlačidla „Späť” vo vašom prehliadači.)',
	'replacetext_editsummary'     => 'Nahradenie textu „$1” textom „$2”',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Sasa Stefanovic
 */
$messages['sr-ec'] = array(
	'replacetext_originaltext'    => 'Оригинални текст',
	'replacetext_replacementtext' => 'Текст за преснимавање',
	'replacetext_replace'         => 'Пресними',
	'replacetext_success'         => "Преснимљен '$1' са '$2' на $3 страница.",
	'replacetext_continue'        => 'Настави',
);

/** Swedish (Svenska)
 * @author M.M.S.
 */
$messages['sv'] = array(
	'replacetext'                 => 'Ersätt text',
	'replacetext-desc'            => 'Låter administratörer [[Special:ReplaceText|ersätta text]] på alla innehållssidor på en wiki',
	'replacetext_docu'            => 'För att ersätta en textträng med en annan på alla datasidor på den här wikin kan du skriva in de två texterna här och klicka på "Ersätt". Du kommer sedan att visas på en lista över sidor som innehåller söktexten, och du kan välja en av dom som du vill ersätta. Ditt namn kommer visas i sidhistoriken som den som är ansvarig för ändringarna.',
	'replacetext_note'            => 'Notera: detta kommer inte ersätta text på diskussionssidor och projektsidor, och kommer inte ersätts text i sidtitlar.',
	'replacetext_originaltext'    => 'Originaltext',
	'replacetext_replacementtext' => 'Ersättningstext',
	'replacetext_choosepages'     => 'Var god ange för vilka sidor du vill ersätta "$1" med "$2":',
	'replacetext_replace'         => 'Ersätt',
	'replacetext_success'         => '"$1" kommer ersättas med "$2" på $3 sidor.',
	'replacetext_noreplacement'   => 'Inga sidor hittades med strängen "$1".',
	'replacetext_warning'         => 'Det finns $1 sidor som redan har ersättningssträngen "$2". Om du gör den här ersättningen kommer du inte kunna separera dina ersättningar från den här texten. Vill du fortsätta med ersättningen?',
	'replacetext_blankwarning'    => 'Eftersom ersättningstexten är tom kommer den här handlingen inte kunna upphävas; vill du fortsätta?',
	'replacetext_continue'        => 'Fortsätt',
	'replacetext_cancel'          => '(Klicka på "Tillbaka"-knappen för att avbryta handlingen.)',
	'replacetext_editsummary'     => 'Textersättning - "$1" till "$2"',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'replacetext_originaltext'    => 'అసలు పాఠ్యం',
	'replacetext_replacementtext' => 'మార్పిడి పాఠ్యం',
	'replacetext_continue'        => 'కొనసాగించు',
);

/** Thai (ไทย)
 * @author Passawuth
 */
$messages['th'] = array(
	'replacetext_originaltext' => 'ข้อความดั้งเดิม',
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'replacetext'                 => 'Thay thế văn bản',
	'replacetext-desc'            => 'Cung cấp một [[Special:ReplaceText|trang đặc biệt]] để cho phép bảo quản viên thực hiện tìm-kiếm-và-thay-thế thống nhất trên tất cả các trang có nội dung tại một wiki',
	'replacetext_docu'            => "Để thay thế một chuỗi ký tự bằng một chuỗi khác trên toàn bộ các trang thông thường tại wiki này, hãy gõ vào hai đoạn văn bản ở đây và sau đó nhấn 'Tiếp tục'. Khi đó bạn thấy một danh sách các trang có chứa đoạn ký tự được tìm, và bạn có thể chọn những trang mà bạn muốn thay thế. Tên của bạn sẽ xuất hiện trong lịch sử trang như một thành viên chịu trách nhiệm về bất kỳ thay đổi nào.",
	'replacetext_note'            => 'Chú ý: điều này sẽ không thay thế văn bản trong những trang "Thảo luận" và trang dự án, và nó sẽ không thay thế văn bản trong chính tựa đề trang.',
	'replacetext_originaltext'    => 'Văn bản nguồn',
	'replacetext_replacementtext' => 'Văn bản thay thế',
	'replacetext_choosepages'     => 'Xin hãy chọn những trang mà bạn muốn thay   ‘$1’ bằng ‘$2’:',
	'replacetext_replace'         => 'Thay thế',
	'replacetext_success'         => '‘$1’ sẽ được thay bằng ‘$2’ trong ‘$3’ trang.',
	'replacetext_noreplacement'   => 'Không tìm thấy trang nào có chứa chuỗi ‘$1’.',
	'replacetext_warning'         => 'Có $1 trang đã có chứa chuỗi thay thế, ‘$2’; nếu bạn thực hiện thay thế này bạn sẽ không thể phân biệt sự thay thế của bạn với những chuỗi này. Tiếp tục thay thế chứ?',
	'replacetext_blankwarning'    => 'Vì chuỗi thay thế là khoảng trắng, tác vụ này sẽ không thể hồi lại được; tiếp tục?',
	'replacetext_continue'        => 'Tiếp tục',
	'replacetext_cancel'          => '(Nhấn vào nút "Lùi" để hủy tác vụ.)',
	'replacetext_editsummary'     => 'Thay thế văn bản - ‘$1’ thành ‘$2’',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Roc michael
 */
$messages['zh-hant'] = array(
	'replacetext'                 => '取代文字',
	'replacetext-desc'            => '提供[[Special:ReplaceText|特殊頁面]]以利管理員以「尋找及取代」的方式更改所有文章頁面內的內容。',
	'replacetext_docu'            => '取代儲存在此Wiki系統內所有頁面上的文字字串，請將「原始文字」及「取代的文字」分別填入下面的兩個欄位之中，按下「取代按鈕」後生效，您所作的修改會顯示在「歷史」頁面上，以對您自己編輯行為負責。',
	'replacetext_note'            => '注意：在所有討論頁面及其他系統的計劃頁面上的文字不會被修改，此外，頁面名稱裡的文字亦不會被修改。',
	'replacetext_originaltext'    => '原始文字',
	'replacetext_replacementtext' => '取代文字',
	'replacetext_replace'         => '取代',
	'replacetext_success'         => '已在 $3 個檔案內的「$1」取代為「$2」。',
	'replacetext_noreplacement'   => '因無任何頁面內含有「$1」。',
	'replacetext_warning'         => '僅有$1檔案內包含取代文字「$2」，如果您執行了取代作業，則可能會造成兩個相同字串相連，而難以分開，您要繼續執行取代作業嗎？',
	'replacetext_blankwarning'    => '因為取代字串是空白的，這將造成難以復原的結果！您要繼續嗎？',
	'replacetext_continue'        => '繼續',
	'replacetext_cancel'          => '(按下 "返回" 按鈕以取消本次操作)',
	'replacetext_editsummary'     => '取代文字 - 「$1」 取代為 「$2」',
);

/** Taiwan Chinese (‪中文(台灣)‬)
 * @author Roc michael
 */
$messages['zh-tw'] = array(
	'replacetext'                 => '取代文字',
	'replacetext-desc'            => '提供[[Special:ReplaceText|特殊頁面]]以利管理員以「尋找及取代」的方式更改所有文章頁面內的內容。',
	'replacetext_docu'            => '取代儲存在此Wiki系統內所有頁面上的文字字串，請將「原始文字」及「取代的文字」分別填入下面的兩個欄位之中，按下「取代按鈕」後生效，您所作的修改會顯示在「歷史」頁面上，以對您自己編輯行為負責。',
	'replacetext_note'            => '注意：在所有討論頁面及其他系統的計劃頁面上的文字不會被修改，此外，頁面名稱裡的文字亦不會被修改。',
	'replacetext_originaltext'    => '原始文字',
	'replacetext_replacementtext' => '取代文字',
	'replacetext_choosepages'     => '請選擇頁面，以便將「$1」取代為「$2」：',
	'replacetext_replace'         => '取代',
	'replacetext_success'         => '已將 $3 個頁面內的「$1」取代為「$2」。',
	'replacetext_noreplacement'   => '因無任何頁面內含有「$1」。',
	'replacetext_warning'         => '僅有$1檔案內包含取代文字「$2」，如果您執行了取代作業，則可能會造成兩個相同字串相連，而難以分開，您要繼續執行取代作業嗎？',
	'replacetext_blankwarning'    => '因為取代字串是空白的，這將造成難以復原的結果！您要繼續嗎？',
	'replacetext_continue'        => '繼續',
	'replacetext_cancel'          => '(按下 "返回" 按鈕以取消本次操作)',
	'replacetext_editsummary'     => '取代文字 - 「$1」 取代為 「$2」',
);

