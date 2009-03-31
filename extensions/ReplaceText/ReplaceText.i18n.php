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
	'replacetext_note' => 'Note: this will not replace text in "Talk" pages and project pages.',
	'replacetext_originaltext' => 'Original text',
	'replacetext_replacementtext' => 'Replacement text',
	'replacetext_movepages' => 'Replace text in page titles as well, when possible',
	'replacetext_choosepages' => 'Please select the {{PLURAL:$3|page|pages}} for which you want to replace \'$1\' with \'$2\':',
	'replacetext_choosepagesformove' => 'Replace text in the {{PLURAL:$1|name of the following page|names of the following pages}}:',
	'replacetext_cannotmove' => 'The following {{PLURAL:$1|page|pages}} cannot be moved:',
	'replacetext_invertselections' => 'Invert selections',
	'replacetext_replace' => 'Replace',
	'replacetext_success' => '\'$1\' will be replaced with \'$2\' in $3 {{PLURAL:$3|page|pages}}.',
	'replacetext_noreplacement' => 'No pages were found containing the string \'$1\'.',
	'replacetext_warning' => 'There {{PLURAL:$1|is $1 page that already contains|are $1 pages that already contain}} the replacement string, \'$2\'.
If you make this replacement you will not be able to separate your replacements from these strings.
Continue with the replacement?',
	'replacetext_blankwarning' => 'Because the replacement string is blank, this operation will not be reversible.
Do you want to continue?',
	'replacetext_continue' => 'Continue',
	'replacetext_cancel' => '(Click the "Back" button in your browser to cancel the operation.)',
	// content messages
	'replacetext_editsummary' => 'Text replace - \'$1\' to \'$2\'',
);

/** Message documentation (Message documentation)
 * @author McMonster
 * @author Nike
 * @author Purodha
 */
$messages['qqq'] = array(
	'replacetext' => "This message is displayed as a title of this extension's special page.",
	'replacetext-desc' => 'Short description of this extension, shown in [[Special:Version]]. Do not translate or change links.',
	'replacetext_docu' => "Description of how to use this extension, displayed on the extension's special page ([[Special:ReplaceText]]).",
	'replacetext_note' => 'This message appears just under the [[MediaWiki:Replacetext]] docu on the [[Special:ReplaceText]] page.',
	'replacetext_originaltext' => 'Label of the text field, where user enters original piece of text, which would be replaced.',
	'replacetext_choosepages' => 'Displayed over the list of pages where the given text was found.',
	'replacetext_replace' => 'Label of the button, which triggers the begin of replacment.',
);

/** Arabic (العربية)
 * @author Alnokta
 * @author Meno25
 * @author OsamaK
 * @author Ouda
 */
$messages['ar'] = array(
	'replacetext' => 'استبدل النص',
	'replacetext-desc' => 'يوفر [[Special:ReplaceText|صفحة خاصة]] للسماح للإداريين للقيام بعملية أوجد واستبدل على نص في كل صفحات المحتوى لويكي',
	'replacetext_docu' => "لاستبدال سلسلة نص بأخرى عبر كل الصفحات العادية في هذا الويكي، أدخل قطعتي النص هنا ثم اضغط 'استمرار'. سيعرض عليك بعد ذلك قائمة بالصفحات التي تحتوي على نص البحث، ويمكنك اختيار اللواتي تريد الاستبدال فيها. اسمك سيظهر في تواريخ الصفحات كالمستخدم المسؤول عن أية تغييرات.",
	'replacetext_note' => 'ملاحظة: هذا لن يستبدل النص في صفحات "النقاش" وصفحات المشروع.',
	'replacetext_originaltext' => 'النص الأصلي',
	'replacetext_replacementtext' => 'نص الاستبدال',
	'replacetext_movepages' => 'أستبدل نص في عناوين الصفحة ، عندما يكون ممكنا',
	'replacetext_choosepages' => "من فضلك اختر الصفحات التي فيها تريد استبدال ب'$1' '$2':",
	'replacetext_choosepagesformove' => ': أستبدل نص في اسماء الصفحات التالية',
	'replacetext_cannotmove' => ':الصفحات التالية لا يمكن نقلها',
	'replacetext_invertselections' => 'عكس الاختيارات',
	'replacetext_replace' => 'استبدل',
	'replacetext_success' => "'$2' سيتم استبدالها ب'$1' في $3 صفحة.",
	'replacetext_noreplacement' => "لا صفحات تم العثور عليها تحتوي على السلسلة '$1'.",
	'replacetext_warning' => "توجد $1 صفحة تحتوي بالفعل على سلسلة الاستبدال، '$2'؛ لو أنك قمت بهذا الاستبدال فلن تصبح قادرا على فصل استبدالاتك من هذه السلاسل. استمرار مع الاستبدال؟",
	'replacetext_blankwarning' => 'لأن سلسلة الاستبدال فارغة، هذه العملية لن تكون عكسية؛ استمر؟',
	'replacetext_continue' => 'استمر',
	'replacetext_cancel' => '(اضغط زر "رجوع" لإلغاء العملية.)',
	'replacetext_editsummary' => "استبدال النص - '$1' ب'$2'",
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'replacetext' => 'استبدل النص',
	'replacetext-desc' => 'يوفر [[Special:ReplaceText|صفحة خاصة]] للسماح للإداريين للقيام بعملية أوجد واستبدل على نص فى كل صفحات المحتوى لويكي',
	'replacetext_docu' => "لاستبدال سلسلة نص بأخرى عبر كل الصفحات العادية فى هذا الويكي، أدخل قطعتى النص هنا ثم اضغط 'استمرار'. سيعرض عليك بعد ذلك قائمة بالصفحات التى تحتوى على نص البحث، ويمكنك اختيار اللواتى تريد الاستبدال فيها. اسمك سيظهر فى تواريخ الصفحات كالمستخدم المسؤول عن أية تغييرات.",
	'replacetext_note' => 'ملاحظة: ده مش هايستبدل النص فى صفحات "Talk" و صفحات المشروع، و مش هايستبدل النص فى عناوين الصفحات نفسها.',
	'replacetext_originaltext' => 'النص الأصلي',
	'replacetext_replacementtext' => 'نص الاستبدال',
	'replacetext_choosepages' => "من فضلك اختار الصفحات اللى فيها عايز تستبدل ب'$1' '$2':",
	'replacetext_invertselections' => 'عكس الاختيارات',
	'replacetext_replace' => 'استبدل',
	'replacetext_success' => "'$1' ح تتبدل بـ '$2' في $3 {{PLURAL:$3|صفحه|صفحات}}.",
	'replacetext_noreplacement' => "لا صفحات تم العثور عليها تحتوى على السلسلة '$1'.",
	'replacetext_warning' => "فيه $1 صفحة فيها سلسلة الاستبدال، '$2'؛ لو أنك قمت بالاستبدال ده مش  هاتقدر تفصل استبدالاتك من السلاسل دى. استمرار مع الاستبدال؟",
	'replacetext_blankwarning' => 'لأن سلسلة الاستبدال فارغة، هذه العملية لن تكون عكسية؛ استمر؟',
	'replacetext_continue' => 'استمر',
	'replacetext_cancel' => '(اضغط زر "رجوع" علشان إلغاء العملية.)',
	'replacetext_editsummary' => "استبدال النص - '$1' ب'$2'",
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'replacetext' => 'Заместване на текст',
	'replacetext-desc' => 'Предоставя [[Special:ReplaceText|специална страница]], чрез която администраторите могат да извършват глобално откриване-и-заместване на низове в страниците на уикито',
	'replacetext_note' => 'Забележка: този метод няма да замести текста в дискусионните страници и проектните страници, както няма да го замести и в заглавията на страниците.',
	'replacetext_originaltext' => 'Оригинален текст',
	'replacetext_replacementtext' => 'Текст за заместване',
	'replacetext_choosepages' => "Изберете страници, в които желаете да замените '$1' с '$2':",
	'replacetext_replace' => 'Заместване',
	'replacetext_success' => "Заместване на '$1' с '$2' в $3 страници.",
	'replacetext_noreplacement' => "Не бяха открити страници, съдържащи низа '$1'.",
	'replacetext_blankwarning' => 'Тъй като низът за заместване е празен, процесът на заместване е необратим; продължаване?',
	'replacetext_continue' => 'Продължаване',
	'replacetext_cancel' => '(натиснете бутона „Back“ за прекратяване на действието.)',
	'replacetext_editsummary' => "Заместване на текст - '$1' на '$2'",
);

/** Czech (Česky)
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'replacetext' => 'Nahradit text',
	'replacetext_originaltext' => 'Původní text',
	'replacetext_replacementtext' => 'Nahradit textem',
	'replacetext_replace' => 'Nahradit',
	'replacetext_continue' => 'Pokračovat',
	'replacetext_cancel' => '(Operaci zrušíte kliknutím na tlačítko „Zpět“ ve vašem prohlížeči.)',
	'replacetext_editsummary' => 'Nahrazení textu „$1“ textem „$2“',
);

/** German (Deutsch)
 * @author Leithian
 * @author Melancholie
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'replacetext' => 'Text ersetzen',
	'replacetext-desc' => 'Ergänzt eine [[Special:ReplaceText|Spezialseite]], die es Administratoren ermöglicht, eine globale Text suchen-und-ersetzen Operation in allen Inhaltseiten des Wikis durchzuführen',
	'replacetext_docu' => 'Um einen Text durch einen anderen Text auf allen Inhaltsseiten zu ersetzen, gib die beiden Textteile hier ein und klicke auf die Ersetzen-Schaltfläche. Dein Benutzername wird in der Versionsgeschichte aufgenommen.',
	'replacetext_note' => 'Bitte beachten: es wird kein Text auf Diskussions- und Projektseiten ausgetauscht.',
	'replacetext_originaltext' => 'Originaltext',
	'replacetext_replacementtext' => 'Neuer Text',
	'replacetext_movepages' => 'Ersetze Text auch in Seitentiteln, wenn möglich',
	'replacetext_choosepages' => 'Bitte die {{PLURAL:$3|Seite|Seiten}} auswählen, bei denen du „$1“ durch „$2“ ersetzen möchtest:',
	'replacetext_choosepagesformove' => 'Ersetze Text {{PLURAL:$1|im Namen der folgenden Seite|in den Namen der folgenden Seiten}}:',
	'replacetext_cannotmove' => 'Die {{PLURAL:$1|folgende Seite kann|folgenden Seiten können}} nicht verschoben werden:',
	'replacetext_invertselections' => 'Auswahl umkehren',
	'replacetext_replace' => 'Ersetzen',
	'replacetext_success' => '„$1“ wird durch „$2“ in $3 {{PLURAL:$3|Seite|Seiten}} ersetzt.',
	'replacetext_noreplacement' => 'Es wurde keine Seite gefunden, die den Text „$1“ enthält.',
	'replacetext_warning' => '$1 {{PLURAL:$1|Seite enthält|Seiten enthalten}} bereits den zu ersetzenden Textteil „$2“.
Eine Trennung der Ersetzungen mit den bereits vorhandenen Textteilen ist nicht möglich.
Möchtest du weitermachen?',
	'replacetext_blankwarning' => 'Der zu ersetzende Textteil ist leer, die Operation kann nicht rückgängig gemacht werden, trotzdem fortfahren?',
	'replacetext_continue' => 'Fortfahren',
	'replacetext_cancel' => '(Klicke auf die „Zurück“-Schaltfläche, um die Operation abzubrechen.)',
	'replacetext_editsummary' => 'Textersetzung - „$1“ durch „$2“',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'replacetext' => 'Anstataŭigi tekston',
	'replacetext_originaltext' => 'Originala teksto',
	'replacetext_replacementtext' => 'Anstataŭigita teksto',
	'replacetext_movepages' => 'Anstataŭigi tekston en paĝaj titoloj ankaŭ, kiam eble',
	'replacetext_invertselections' => 'Inversigi selektojn',
	'replacetext_replace' => 'Anstataŭigi',
	'replacetext_success' => "'$1' estos anstataŭigita de '$2' en $3 paĝoj.",
	'replacetext_noreplacement' => "Neniuj paĝoj estis trovitaj enhavantaj la ĉenon '$1'.",
	'replacetext_continue' => 'Reaktivigi',
	'replacetext_editsummary' => "Teksta anstataŭigo - '$1' al '$2'",
);

/** Spanish (Español)
 * @author Imre
 */
$messages['es'] = array(
	'replacetext' => 'Reemplazar texto',
	'replacetext_replace' => 'Reemplazar',
);

/** Basque (Euskara)
 * @author Kobazulo
 */
$messages['eu'] = array(
	'replacetext' => 'Testua ordezkatu',
	'replacetext_originaltext' => 'Jatorrizko testua',
	'replacetext_movepages' => 'Posiblea denean, orrialdeen izenburuetan ere testua ordezkatzen du',
	'replacetext_cannotmove' => 'Hurrengo {{PLURAL:$1|orrialdea ezin da mugitu:|orrialdeak ezin dira mugitu:}}',
	'replacetext_invertselections' => 'Hautaketak alderantzikatu',
	'replacetext_replace' => 'Ordezkatu',
	'replacetext_noreplacement' => "Ez da aurkitu '$1' karaktere-katea duen orrialderik.",
	'replacetext_continue' => 'Jarraitu',
	'replacetext_cancel' => '(Zure nabigatzailearen atzerako botoia sakatu ekintza deuseztatzeko.)',
	'replacetext_editsummary' => "Testu aldaketa - '$1'(e)tik '$2'(e)ra.",
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'replacetext' => 'جایگزینی متن',
	'replacetext-desc' => 'یک [[Special:ReplaceText|صفحهٔ ویژه]] اضافه می‌کند که به مدیران اجازه می‌دهد یک جستجو و جایگزینی سراسری در تمام محتوای ویکی انجام دهند',
	'replacetext_docu' => 'برای جایگزین کردن یک رشتهٔ متنی با رشته دیگر در کل داده‌های این ویکی، شما می‌توانید دو متن را در زیر وارد کرده و دکمهٔ «جایگزین کن» را بزنید. اسم شما در تاریخچهٔ صفحه‌ها به عنوان کاربری که مسئول این تغییرها است ثبت می‌شود.',
	'replacetext_note' => 'نکته: این روش متن صفحه‌های بحث و صفحه‌های پروژه را تغییر نمی‌دهد، و عنوان صفحه‌ها را نیز تغییر نمی‌دهد.',
	'replacetext_originaltext' => 'متن اصلی',
	'replacetext_replacementtext' => 'متن جایگزین',
	'replacetext_replace' => 'جایگزین کن',
	'replacetext_success' => "در $3 صفحه '$1' را با '$2' جایگزین کرد.",
	'replacetext_noreplacement' => "جایگزینی انجام نشد؛ صفحه‌ای که حاوی '$1' باشد پیدا نشد.",
	'replacetext_warning' => "در حال حاضر $1 حاوی متن جایگزین، '$2'، هستند؛ اگر شما این جایگزینی را انجام دهید قادر نخواهید بود که مواردی که جایگزین کردید را از مواردی که از قبل وجود داشته تفکیک کنید. آیا ادامه می‌دهید؟",
	'replacetext_blankwarning' => 'چون متن جایگزین خالی است، این عمل قابل بازگشت نخواهد بود؛ ادامه می‌دهید؟',
	'replacetext_continue' => 'ادامه',
	'replacetext_cancel' => '(دکمهٔ «بازگشت» را بزنید تا عمل را لغو کنید.)',
	'replacetext_editsummary' => "جایگزینی متن - '$1' به '$2'",
);

/** Finnish (Suomi)
 * @author Nike
 * @author Str4nd
 */
$messages['fi'] = array(
	'replacetext_originaltext' => 'Alkuperäinen teksti',
	'replacetext_replacementtext' => 'Korvaava teksti',
	'replacetext_movepages' => 'Korvaa teksti myös otsikoista, jos mahdollista',
	'replacetext_cannotmove' => '{{PLURAL:$1|Seuraavaa sivua|Seuraavia sivuja}} ei voi siirtää:',
	'replacetext_invertselections' => 'Käänteinen valinta',
	'replacetext_replace' => 'Korvaa',
	'replacetext_continue' => 'Jatka',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author IAlex
 * @author McDutchie
 * @author Verdy p
 * @author Zetud
 */
$messages['fr'] = array(
	'replacetext' => 'Remplacer le texte',
	'replacetext-desc' => 'Fournit une page spéciale permettant aux administrateurs de remplacer des chaînes de caractères par d’autres sur l’ensemble du wiki',
	'replacetext_docu' => "Pour remplacer une chaîne de caractères avec une autre sur l'ensemble des données des pages de ce wiki, vous pouvez entrez les deux textes ici et cliquer sur « Remplacer ». Votre nom apparaîtra dans l'historique des pages tel un utilisateur auteur des changements.",
	'replacetext_note' => 'Note : ceci ne remplacera pas le texte dans les pages de discussion ainsi que dans les pages « projet ».',
	'replacetext_originaltext' => 'Texte original',
	'replacetext_replacementtext' => 'Nouveau texte',
	'replacetext_movepages' => 'Remplacer le texte dans le titre des pages, si possible',
	'replacetext_choosepages' => 'Veuillez sélectionner {{PLURAL:$3|la pages|les pages}} dans {{PLURAL:$3|laquelle|lesquelles}} vous voulez remplacer « $1 » par « $2 » :',
	'replacetext_choosepagesformove' => 'Remplacer le texte dans {{PLURAL:$1|le nom de la page suivante|les noms des pages suivantes}} :',
	'replacetext_cannotmove' => "{{PLURAL:$1|La page suivante n'a pas pu être renommée|Les pages suivantes n'ont pas pu être renommées}} :",
	'replacetext_invertselections' => 'Inverser les sélections',
	'replacetext_replace' => 'Remplacer',
	'replacetext_success' => '« $1 » sera remplacé par « $2 » dans $3 fichier{{PLURAL:$3||s}}.',
	'replacetext_noreplacement' => 'Aucun fichier contenant la chaîne « $1 » n’a été trouvé.',
	'replacetext_warning' => 'Il y a $1 fichier{{PLURAL:$1| qui contient|s qui contiennent}} la chaîne de remplacement « $2 ».
Si vous effectuez cette substitution, vous ne pourrez pas séparer vos changements à partir de ces chaînes.
Voulez-vous continuer ces substitutions ?',
	'replacetext_blankwarning' => 'Parce que la chaîne de remplacement est vide, cette opération sera irréversible ; voulez-vous continuer ?',
	'replacetext_continue' => 'Continuer',
	'replacetext_cancel' => "(Cliquez sur le bouton  « Retour » de votre navigateur pour annuler l'opération.)",
	'replacetext_editsummary' => 'Remplacement du texte — « $1 » par « $2 »',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'replacetext' => 'Substituír un texto',
	'replacetext-desc' => 'Proporciona unha [[Special:ReplaceText|páxina especial]] para que os administradores poidan facer unha cadea global para atopar e substituír un texto no contido de todas as páxinas dun wiki',
	'replacetext_docu' => 'Para substituír unha cadea de texto por outra en todas as páxinas regulares deste wiki, teclee aquí as dúas pezas do texto e logo prema en "Continuar". Despois amosaráselle unha lista das páxinas que conteñen o texto buscado e pode elixir en cales quere substituílo. O seu nome aparecerá nos histotiais das páxinas como o usuario responsable de calquera cambio.',
	'replacetext_note' => 'Nota: isto non substituirá o texto nas páxinas de "Conversa" nin nas páxinas do proxecto.',
	'replacetext_originaltext' => 'Texto orixinal',
	'replacetext_replacementtext' => 'Reemprazo de texto',
	'replacetext_movepages' => 'Substituír tamén o texto nos títulos das páxinas, cando sexa posible',
	'replacetext_choosepages' => 'Por favor, seleccione {{PLURAL:$3|a páxina na|as páxinas nas}} que quere substituír "$1" por "$2":',
	'replacetext_choosepagesformove' => 'Substituír o texto {{PLURAL:$1|no nome da seguinte páxina|nos nomes das seguintes páxinas}}:',
	'replacetext_cannotmove' => '{{PLURAL:$1|A seguinte páxina|As seguintes páxinas}} non {{PLURAL:$1|pode|poden}} ser {{PLURAL:$1|movida|movidas}}:',
	'replacetext_invertselections' => 'Invertir as seleccións',
	'replacetext_replace' => 'Reemprazar',
	'replacetext_success' => '"$1" será substituído por "$2" {{PLURAL:$3|nunha páxina|en $3 páxinas}}.',
	'replacetext_noreplacement' => "Non foi atopada ningunha páxina que contivese a cadea '$1'.",
	'replacetext_warning' => 'Hai {{PLURAL:$1|unha páxina|$1 páxinas}} que xa {{PLURAL:$1|contén|conteñen}} a cadea de substitución "$2".
Se fai esta substitución non poderá separar as súas substitucións destas cadeas.
Quere continuar coa substitución?',
	'replacetext_blankwarning' => 'Debido a que a cadea de substitución está baleira, esta operación non será reversible; quere continuar?',
	'replacetext_continue' => 'Continuar',
	'replacetext_cancel' => '(Prema no botón "Atrás" do seu navegador para cancelar a operación.)',
	'replacetext_editsummary' => 'Reemprazo de texto - de "$1" a "$2"',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'replacetext' => 'החלפת טקסט',
	'replacetext-desc' => 'אספקת [[Special:ReplaceText|דף מיוחד]] כדי לאפשר למפעילים לבצע חיפוש והחלפה של מחרוזות בכל דפי התוכן בוויקי',
	'replacetext_note' => 'הערה: פעולה זו לא תחליף טקסט בדפי שיחה ובדפי המיזם.',
	'replacetext_originaltext' => 'הטקסט המקורי',
	'replacetext_replacementtext' => 'טקסט ההחלפה',
	'replacetext_movepages' => 'החלפת טקסט גם בכותרות הדפים, כשניתן',
	'replacetext_choosepages' => "אנא בחרו את הדפים בהם ברצונם להחליף את '$1' ב־'$2':",
	'replacetext_choosepagesformove' => 'החלפת טקסט בשמות הדפים הבאים:',
	'replacetext_cannotmove' => 'לא ניתן להעביר את הדפים הבאים:',
	'replacetext_invertselections' => 'הפיכת הבחירות',
	'replacetext_replace' => 'החלפה',
	'replacetext_success' => "'$1' יוחלף ב־'$2' ב־$3 דפים.",
	'replacetext_noreplacement' => "לא נמצאו דפים המכילים את המחרוזת '$1'.",
	'replacetext_blankwarning' => 'כיוון שמחרוזת ההחלפה ריקה, לא ניתן יהיה לבטל פעולה זו; להמשיך?',
	'replacetext_continue' => 'המשך',
	'replacetext_cancel' => '(לחצו על הלחצן "חזרה" כדי לבטל את הפעולה.)',
	'replacetext_editsummary' => "החלפת טקסט - $1 ל־'$2'",
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 */
$messages['hr'] = array(
	'replacetext' => 'Zamjeni tekst',
	'replacetext-desc' => 'Dodaje [[Special:ReplaceText|posebnu stranicu]] koja omogućava administratorima globalnu zamjenu teksta na principu nađi-zamjeni na svim stranicama wikija.',
	'replacetext_docu' => "Za zamjenu jednog teksta s drugim na svim stranicama wikija, upišite ciljani i zamjenski tekst ovdje i pritisnite 'Dalje'. Pokazati će vam se popis stranica koje sadrže ciljani tekst, i moći ćete odabrati u kojima od njih želite izvršiti zamjenu. Vaše ime će se pojaviti u povijesti stranice kao suradnik odgovoran za promjenu.",
	'replacetext_note' => 'Napomena: ovo neće zamijeniti tekst na stranicama za "razgovor" i stranicama projekta.',
	'replacetext_originaltext' => 'Izvorni tekst',
	'replacetext_replacementtext' => 'Zamjenski tekst',
	'replacetext_movepages' => 'Zamijeni i tekst u naslovima stranica, ako je moguće',
	'replacetext_choosepages' => "Molimo odaberite {{PLURAL:$3|stranicu|stranice}} na kojima želite zamijeniti '$1' za '$2':",
	'replacetext_choosepagesformove' => 'Zamijeni tekst u {{PLURAL:$1|naslovu sljedeće stranice|naslovima sljedećih stranica}}:',
	'replacetext_cannotmove' => '{{PLURAL:$1|Sljedeća stranica|Sljedeće stranice}} ne mogu biti premještene:',
	'replacetext_invertselections' => 'Izvrni odabir',
	'replacetext_replace' => 'Zamjeni',
	'replacetext_success' => "'$1' će biti zamijenjen za '$2' na $3 {{PLURAL:$3|stranici|stranice|stranica}}.",
	'replacetext_noreplacement' => "Nije pronađena ni jedna stranica koja sadrži '$1'.",
	'replacetext_warning' => "Postoji {{PLURAL:$1|$1 stranica koja već sadrži|$1 stranica koje već sadrže}} zamjenski tekst, '$2'. 
Ako napravite ovu zamjenu nećete moći odvojiti svoju zamjenu od ovog teksta. Nastaviti sa zamjenom?",
	'replacetext_blankwarning' => 'Zato što je zamjenski tekst prazan, ovaj postupak se neće moći vratiti; nastaviti?',
	'replacetext_continue' => 'Dalje',
	'replacetext_cancel' => '(Pritisnite tipku "Nazad" u svom pregledniku za zaustavljanje postupka.)',
	'replacetext_editsummary' => "Zamjena teksta - '$1' u '$2'",
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'replacetext' => 'Tekst narunać',
	'replacetext-desc' => 'Steji [[Special:ReplaceText|specialnu stronu]] k dispoziciji, kotraž administratoram zmóžnja, globalne pytanje a narunanje teksta na wšěch wobsahowych stronach wikija přewjesć',
	'replacetext_docu' => "Zo by tekst přez druhi tekst na wšěch regularnych stronach tutoho wikija narunał, zapodaj wobaj tekstowej dźělej a klikń potom na 'Dale'. Budźeš potom lisćinu stronow widźeć, kotrež pytany tekst wobsahuja a móžeš jednu z nich wubrać, w kotrejž chceš tekst narunać. Twoje mjeno zjewi so w stawiznach strony jako wužiwar, kotryž je zamołwity za změny.",
	'replacetext_note' => 'Kedźbu: tekst w diskusijnych a projektowych stronach so njenarunuje.',
	'replacetext_originaltext' => 'Originalny tekst',
	'replacetext_replacementtext' => 'Narunanski tekst',
	'replacetext_movepages' => 'Tekst w titulach stronow tež narunać, jeli móžno',
	'replacetext_choosepages' => "Prošu wubjer {{PLURAL:$3|stronu|stronje|strony|strony}}, za kotrež chceš '$1' přez '$2' narunać:",
	'replacetext_choosepagesformove' => 'Tekst w {{PLURAL:$1|mjenje slědowaceje strony|mjenomaj slědowaceju stronow|mjenach slědowacych stronow|mjenach slědowacych stronow}} narunać:',
	'replacetext_cannotmove' => '{{PLURAL:$1|Slědowaca strona njehodźi|Slědowacej stronje njehodźitej|Slědowace strony njehodźa|Slědowace strony njehodźa}} so přesunyć:',
	'replacetext_invertselections' => 'Wuběry wobroćić',
	'replacetext_replace' => 'Narunać',
	'replacetext_success' => "'$1' so w $3 {{PLURAL:$3|stronje|stronomaj|stronach|stronach}} přez '$2' naruna.",
	'replacetext_noreplacement' => "Njejsu so žane strony namakali, kotrež wuraz '$1' wobsahuja.",
	'replacetext_warning' => "{{PLURAL:$1|Je hižo $1 strona, kotraž wobsahuje|Stej hižo $1 stronje, kotejž wobsahujetej|Su hižo $1 strony, kotrež wobsahuja|Je hižo $1 stronow, kotrež wobsahuje}} narunanski tekst, '$2'. Jeli tute narunanje činiš, njemóžeš swoje narunanja wot tutoho teksta rozdźělić. Z narunanjom pokročować?",
	'replacetext_blankwarning' => 'Narunanski dźěl je prózdny, tohodla operacija njeda so cofnyć; njedźiwajo na to pokročować?',
	'replacetext_continue' => 'Dale',
	'replacetext_cancel' => '(Klikń na tłóčatko "Wróćo" w swojim wobhladowaku, zo by operaciju přetrohnył.)',
	'replacetext_editsummary' => "Tekstowe narunanje - '$1' do '$2'",
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'replacetext' => 'Reimplaciar texto',
	'replacetext-desc' => 'Forni un [[Special:ReplaceText|pagina special]] que permitte al administratores cercar e reimplaciar globalmente un catena de characteres in tote le paginas de contento de un wiki',
	'replacetext_docu' => "Pro reimplaciar un catena de characteres per un altere trans tote le paginas regular in iste wiki, entra le duo pecias de texto hic e clicca super 'Continuar'. Postea se monstrara un lista de paginas que contine le texto cercate, e tu potera seliger in quales tu vole reimplaciar lo. Tu nomine figurara in le historias del paginas como le usator responsabile de omne modificationes.",
	'replacetext_note' => 'Nota: isto non reimplaciara texto paginas de discussion e de projecto.',
	'replacetext_originaltext' => 'Texto original',
	'replacetext_replacementtext' => 'Nove texto',
	'replacetext_movepages' => 'Reimplaciar texto etiam in titulos de paginas, si possibile',
	'replacetext_choosepages' => "Per favor selige le {{PLURAL:$3|pagina in le qual|paginas in le quales}} tu vole reimplaciar '$1' per '$2':",
	'replacetext_choosepagesformove' => 'Reimplaciar texto in le {{PLURAL:$1|nomine del sequente pagina|nomines del sequente paginas}}:',
	'replacetext_cannotmove' => 'Le sequente {{PLURAL:$1|pagina|paginas}} non pote esser renominate:',
	'replacetext_invertselections' => 'Inverter selectiones',
	'replacetext_replace' => 'Reimplaciar',
	'replacetext_success' => "'$1' essera reimplaciate per '$2' in $3 {{PLURAL:$3|pagina|paginas}}.",
	'replacetext_noreplacement' => "Nulle pagina esseva trovate que contine le catena de characteres '$1'.",
	'replacetext_warning' => "Il ha $1 {{PLURAL:$1|pagina|paginas}} que contine ja le nove texto, '$2'.
Si tu face iste reimplaciamento, tu non potera distinguer inter tu reimplaciamentos e iste texto ja existente.
Continuar le reimplaciamento?",
	'replacetext_blankwarning' => 'Post que le nove texto es vacue, iste operation non essera reversibile; continuar?',
	'replacetext_continue' => 'Continuar',
	'replacetext_cancel' => '(Clicca le button "Retro" in tu navigator pro cancellar le operation.)',
	'replacetext_editsummary' => "Reimplaciamento de texto - '$1' per '$2'",
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'replacetext' => 'Ganti tèks',
	'replacetext_originaltext' => 'Tèks asli',
	'replacetext_continue' => 'Banjurna',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'replacetext' => 'ជំនួសអត្ថបទ',
	'replacetext_originaltext' => 'អត្ថបទដើម',
	'replacetext_replacementtext' => 'អត្ថបទជំនួស',
	'replacetext_movepages' => 'ជំនួស​អត្ថបទ​នៅក្នុង​ចំណងជើង​ទំព័រ​ឱ្យ​បាន​ល្អ នៅពេល​ដែល​អាច​ធ្វើ​បាន',
	'replacetext_choosepages' => "សូម​ជ្រើសរើស {{PLURAL:$3|ទំព័រ|ទំព័រ}} សម្រាប់​អ្វី​ដែល​អ្នក​ចង់​ជំនួស '$1' ដោយ '$2':",
	'replacetext_choosepagesformove' => 'ជំនួស​អត្ថបទ​នៅក្នុង {{PLURAL:$1|ឈ្មោះ​ទំព័រ​ដូចតទៅ|ឈ្មោះ​ទំព័រ​ដូចតទៅ}}:',
	'replacetext_invertselections' => 'ដាក់បញ្ច្រាស​ជម្រើស',
	'replacetext_replace' => 'ជំនួស',
	'replacetext_success' => "'$1'នឹងត្រូវបានជំនួសដោយ '$2' ក្នុង$3ទំព័រ។",
	'replacetext_noreplacement' => "រក​មិន​ឃើញ​ទំព័រ​ដែល​មាន​ខ្សែអក្សរ (string) '$1' ។",
	'replacetext_continue' => 'បន្ត',
	'replacetext_editsummary' => "អត្ថបទជំនួស - '$1' ទៅ '$2'",
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'replacetext' => 'Täx-Shtöcksher ußtuusche',
	'replacetext-desc' => 'Deit en [[Special:ReplaceText|Söndersigg]] en et Wiki, womet {{int:group-sysop}} aanjefbaa Täx-Shtöcksher en alle Atikelle em Wiki söke un ußtuusche künne.',
	'replacetext_docu' => 'Öm ene Täx en alle nomaale Sigge em Wiki ze söke un ußzetuusche, jif hee
zwei Täx-Shtöcksher en, un donn dann op „{{int:replacetext continue}}“ klecke.
Dann süühß De en Leß met Sigge, wo dö dä jesoohte Täx dren enthallde es,
un De kanns Der erußsöke, en wat för enne dovun dat De dä och jetuusch
han wells. Dinge Name als Metmaacher weed met dä neu veränderte Versione
fun dä Sigge faßjehallde als dä Schriiver, dä et jemaat hät.',
	'replacetext_note' => 'Opjepaß: Hee met don mer keine Täxstöcker op {{NS:talk}}-Sigge udder op {{NS:project}}-Sigge söke udder tuusche.',
	'replacetext_originaltext' => 'Dä ojinaal Täx för zem Ußtuusche',
	'replacetext_replacementtext' => 'Dä neue Täx zom erin tuusche',
	'replacetext_movepages' => 'Donn dä Täx en de Sigge ier Tittel ußtuusche, wan et jeiht',
	'replacetext_choosepages' => 'Don {{PLURAL:$3|en Sigg|die Sigge|nix aan Sigge}} ußsöke, en dänne De „$1“ jääje „$2“ jetuusch han wells:',
	'replacetext_choosepagesformove' => 'Donn dä Täx en hee dä {{PLURAL:$1|Sigg|Sigge|nix}} ußtuusche:',
	'replacetext_cannotmove' => 'Hee die {{PLURAL:$3|Sigg kann|Sigge künne|nix kann}} nit ömjenannt wäde:',
	'replacetext_invertselections' => 'De Ußwahl ömdrieje',
	'replacetext_replace' => 'Tuusche',
	'replacetext_success' => '„$1“ soll en {{PLURAL:$3|eine Sigg|$3 Sigge|nix}} dorsch „$2“ ußjetuusch wääde.',
	'replacetext_noreplacement' => 'Kein Sigge jefonge met däm Täxstöck „$1“ dren.',
	'replacetext_warning' => '
{{PLURAL:$1|Ein Sigg enthält|$1 Sigge enthallde}} ald dat Täxstöck „$2“, wat bemm Tuusche ennjeföch wääde sull.
Wenn De dat jemaat häs, dokam_mer die Änderong nit esu leich automattesch retuur maache, weil mer die ald do woore,
un de ennjetuuschte Tästöcker nit ungerscheide kann.
Wells De trozdämm wigger maache?',
	'replacetext_blankwarning' => 'Dat Täxstöck, wat beim Tuusche ennjfööch weed, is leddich,
dröm kam_mer die Änderong nit esu leich automattesch retuur maache.
Wells De trozdämm wigger maache?',
	'replacetext_continue' => 'Wiggermaache',
	'replacetext_cancel' => '(Kleck dä „Zerök“- ov „Retuur“-Knopp, öm dä Förjang afzebreche)',
	'replacetext_editsummary' => 'Täx-Shtöcker tuusche — vun „$1“ noh „$2“',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'replacetext' => 'Text ersetzen',
	'replacetext-desc' => "Weist eng [[Special:ReplaceText|Spezialsäit]] déi Administrateuren et erlaabt eng Rei vun Textzeechen op alle Contenu-säiten vun enger Wiki ze gesinn an z'ersetzen",
	'replacetext_note' => "'''Oppassen''': Dëst ersetzt net den Text op \"Diskussiounssäiten\" a Projetssäiten.",
	'replacetext_originaltext' => 'Originaltext',
	'replacetext_replacementtext' => 'Neien Text',
	'replacetext_movepages' => 'Text och an den Titele vun de Säiten ersetzen, wa méiglech',
	'replacetext_choosepages' => 'Wielt w.e.g. d\'{{PLURAL:$3|Säit op däer|Säiten op denen}} Dir "$1" duerch "$2" ersetze wëllt:',
	'replacetext_cannotmove' => 'Dës {{PLURAL:$1|Säit kann|Säite kënne}} net geréckelt ginn:',
	'replacetext_invertselections' => 'Auswiel ëmdréinen',
	'replacetext_replace' => 'Ersetzen',
	'replacetext_success' => "'$1' gëtt duerch '$2' op $3 {{PLURAL:$3|Säit|Säiten}} ersat.",
	'replacetext_noreplacement' => "Et goufe keng Säite mam Text '$1' fonnt.",
	'replacetext_blankwarning' => 'Well den Textdeel mat dem de gesichten Text ersat gi soll eidel ass, kann dës Aktioun net réckgängeg gemaach ginn; wëllt Dir awer weiderfueren?',
	'replacetext_continue' => 'Weiderfueren',
	'replacetext_cancel' => '(Klickt op de Knäppchen "Zréck" an Ärem Browser fir d\'Operatioun ofzebriechen)',
	'replacetext_editsummary' => "Text ersat - '$1' duerch '$2'",
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'replacetext_continue' => 'തുടരുക',
	'replacetext_cancel' => '(ഈ പ്രവര്‍ത്തനം നിരാകരിക്കുവാന്‍ "തിരിച്ചു പോവുക" ബട്ടണ്‍ ഞെക്കുക)',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'replacetext' => 'मजकूरावर पुनर्लेखन करा',
	'replacetext-desc' => 'एक [[Special:ReplaceText|विशेष पान]] देते ज्याच्यामुळे प्रबंधकांना एखाद्या विकिवरील सर्व पानांमध्ये शोधा व बदला सुविधा वापरता येते',
	'replacetext_docu' => "एखाद्या विकितील सर्व डाटा पानांवरील एखादा मजकूर बदलायचा झाल्यास, मजकूराचे दोन्ही तुकडे खाली लिहून 'पुनर्लेखन करा' कळीवर टिचकी द्या. तुम्हाला एक यादी दाखविली जाईल व त्यामधील कुठली पाने बदलायची हे तुम्ही ठरवू शकता. तुमचे नाव त्या पानांच्या इतिहास यादीत दिसेल.",
	'replacetext_note' => 'सूचना: ह्यामुळे "चर्चा" पाने तसेच प्रकल्प पाने यांच्यावर बदल होणार नाहीत, तसेच शीर्षके सुद्धा बदलली जाणार नाहीत.',
	'replacetext_originaltext' => 'मूळ मजकूर',
	'replacetext_replacementtext' => 'बदलण्यासाठीचा मजकूर',
	'replacetext_choosepages' => "ज्या पानांवर तुम्ही  '$1' ला '$2' ने बदलू इच्छिता ती पाने निवडा:",
	'replacetext_replace' => 'पुनर्लेखन करा',
	'replacetext_success' => "'$1' ला '$2' ने $3 पानांवर बदलले जाईल.",
	'replacetext_noreplacement' => "'$1' मजकूर असणारे एकही पान सापडले नाही.",
	'replacetext_warning' => "अगोदरच $1 पानांवर '$2' हा बदलण्यासाठीचा मजकूर आहे; जर तुम्ही पुनर्लेखन केले तर तुम्ही केलेले बदल तुम्ही या पानांपासून वेगळे करू शकणार नाही. पुनर्लेखन करायचे का?",
	'replacetext_blankwarning' => 'बदलण्यासाठीचा मजकूर रिकामा असल्यामुळे ही क्रिया उलटविता येणार नाही; पुढे जायचे का?',
	'replacetext_continue' => 'पुनर्लेखन करा',
	'replacetext_cancel' => '(क्रिया रद्द करण्यासाठी "Back" कळीवर टिचकी द्या.)',
	'replacetext_editsummary' => "मजकूर पुनर्लेखन - '$1' ते '$2'",
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'replacetext' => 'Tekst vervangen',
	'replacetext-desc' => "Beheerders kunnen via een [[Special:ReplaceText|speciale pagina]] tekst zoeken en vervangen in alle pagina's",
	'replacetext_docu' => "Om een stuk tekst te vervangen door een ander stuk tekst in alle pagina's van de wiki, kunt u hier deze twee tekstdelen ingeven en daarna op 'Vervangen' klikken.
U krijgt dan een lijst met pagina's te zien waar uw te vervangen tekstdeel in voorkomt, en u kunt kiezen in welke pagina's u de tekst ook echt wilt vervangen.
Uw naam wordt opgenomen in de geschiedenis van de pagina als verantwoordelijke voor de wijzigingen.",
	'replacetext_note' => "Nota bene: de tekst wordt niet vevangen in overlegpagina's en projectpagina's.",
	'replacetext_originaltext' => 'Oorspronkelijke tekst',
	'replacetext_replacementtext' => 'Vervangende tekst',
	'replacetext_movepages' => 'De tekst als mogelijk ook vervangen in paginanamen',
	'replacetext_choosepages' => "Selecteer de {{PLURAL:$3|pagina|pagina's}} waar u '$1' door '$2' wilt vervangen:",
	'replacetext_choosepagesformove' => 'De tekst vervangen in de volgende {{PLURAL:$1|paginanaam|paginanamen}}:',
	'replacetext_cannotmove' => "De volgende {{PLURAL:$1|pagina kan|pagina's kunnen}} niet hernoemd worden:",
	'replacetext_invertselections' => 'Selecties omkeren',
	'replacetext_replace' => 'Vervangen',
	'replacetext_success' => '"$1" wordt in $3 {{PLURAL:$3|pagina|pagina\'s}} vervangen door "$2".',
	'replacetext_noreplacement' => "Er waren geen pagina's die de tekst '$1' bevatten.",
	'replacetext_warning' => "Er {{PLURAL:$1|is $1 pagina|zijn $1 pagina's}} die het te vervangen tesktdeel al '$2' al {{PLURAL:$1|bevat|bevatten}}.
Als u nu doorgaat met vervangen, kunt u geen onderscheid meer maken.
Wilt u doorgaan met vervangen?",
	'replacetext_blankwarning' => 'Omdat u tekst vervangt door niets, kan deze handeling niet ongedaan gemaakt worden. Wilt u doorgaan?',
	'replacetext_continue' => 'Doorgaan',
	'replacetext_cancel' => '(Klik op de knop "Terug" in uw webbrowser om deze handeling te annuleren)',
	'replacetext_editsummary' => "Tekst vervangen - '$1' door '$2'",
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'replacetext' => 'Byt ut tekst',
	'replacetext-desc' => 'Gjev ei [[Special:ReplaceText|spesialsida]] som lèt administratorar søkja etter og byta ut tekst på alle innhaldssidene på ein wiki.',
	'replacetext_docu' => 'For å byta éin tekststreng med ein annan på alle datasidene på denne wikien kan du skriva inn dei to tekstane her og trykkja «Hald fram». Du vil då bli førd til ei lista over sidene som inneheld søkjestrengen, og du kan velja kva sider du ønskjer å byta han ut i. Namnet ditt vil stå i sidehistorikkane som han som er ansvarleg for endringane.',
	'replacetext_note' => 'Merk: dette vil ikkje byta ut tekst på diskusjons- og prosjektsider.',
	'replacetext_originaltext' => 'Originaltekst',
	'replacetext_replacementtext' => 'Ny tekst',
	'replacetext_movepages' => 'Byt òg ut tekst i sidetitlar der dette er mogleg',
	'replacetext_choosepages' => 'Vel {{PLURAL:$3|sida|sidene}} der du ønskjer å byta ut «$1» med «$2»:',
	'replacetext_choosepagesformove' => 'Byt ut tekst i {{PLURAL:$1|namnet på den følgjande sida|namna på dei følgjande sidene}}:',
	'replacetext_cannotmove' => '{{PLURAL:$1|Den følgjande sida|Dei følgjande sidene}} kan ikkje bli flytta:',
	'replacetext_invertselections' => 'Inverter val',
	'replacetext_replace' => 'Byt ut',
	'replacetext_success' => '$1» blir byta ut med «$2» på {{PLURAL:$3|éi sida|$3 sider}}.',
	'replacetext_noreplacement' => 'Fann ingen sider som inneheldt søkjestrengen «$1».',
	'replacetext_warning' => 'Det finst {{PLURAL:$1|éi sida|$1 sider}} som allereie inneheld strengen som skal bli sett inn, «$2».
Om du utfører denne utbytinga vil du ikkje vera i stand til å skilja utbytingane dine frå desse strengane.
Halda fram med utbytinga?',
	'replacetext_blankwarning' => 'Av di teksten som skal bli sett inn er tom, vil ikkje denne handlinga kunna bli køyrt omvendt.
Vil du halda fram?',
	'replacetext_continue' => 'Hald fram',
	'replacetext_cancel' => '(Trykk på «Attende»-knappen i nettlesaren din for å avbryta handlinga.)',
	'replacetext_editsummary' => 'Utbyting av tekst - «$1» til «$2»',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'replacetext' => 'Erstatt tekst',
	'replacetext-desc' => 'Lar administratorer kunne [[Special:ReplaceText|erstatte tekst]] på alle innholdssider på en wiki.',
	'replacetext_docu' => 'For å erstatte én tekststreng med en annen på alle datasider på denne wikien kan du skrive inn de to tekstene her og trykke «Erstatt». Du vil da bli ført til en liste over sider som inneholder søketeksten, og du kan velge hvilke sider du ønsker å erstatte den i. Navnet ditt vil stå i sidehistorikkene som den som er ansvarlig for endringene.',
	'replacetext_note' => 'Merk: dette vil ikke erstatte tekst på diskusjonssider og prosjektsider, og vil ikke erstatte tekst i sidetitler.',
	'replacetext_originaltext' => 'Originaltekst',
	'replacetext_replacementtext' => 'Erstatningstekst',
	'replacetext_choosepages' => 'Velg hvilke sider du ønsker å erstatte «$1» med «$2» i:',
	'replacetext_invertselections' => 'Inverter valg',
	'replacetext_replace' => 'Erstatt',
	'replacetext_success' => '«$1» blir erstattet med «$2» på {{PLURAL:$3|én side|$3 sider}}.',
	'replacetext_noreplacement' => 'Ingen sider ble funnet med strengen «$1».',
	'replacetext_warning' => 'Det er $1 sider som allerede har erstatningsteksten «$2». Om du gjør denne erstatningen vil du ikke kunne skille ut dine erstatninger fra denne teksten. Fortsette med erstattingen?',
	'replacetext_blankwarning' => 'Fordi erstatningsteksten er tom vil denne handlingen ikke kunne angres automatisk; fortsette?',
	'replacetext_continue' => 'Fortsett',
	'replacetext_cancel' => '(Trykk på «Tilbake»-knappen for å avbryte handlingen.)',
	'replacetext_editsummary' => 'Teksterstatting – «$1» til «$2»',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'replacetext' => 'Remplaçar lo tèxt',
	'replacetext-desc' => 'Provesís una [[Special:ReplaceText|pagina especiala]] que permet als administrators de remplaçar de cadenas de caractèrs per d’autras sus l’ensemble del wiki',
	'replacetext_docu' => "Per remplaçar una cadena de caractèrs amb una autra sus l'ensemble de las donadas de las paginas d'aqueste wiki, podètz picar los dos tèxtes aicí e clicar sus 'Remplaçar'. Vòstre nom apareiserà dins l'istoric de las paginas tal coma un utilizaire autor dels cambiaments.",
	'replacetext_note' => 'Nòta : aquò remplaçarà pas lo tèxt dins las paginas de discussion ni mai dins las paginas « projècte ».',
	'replacetext_originaltext' => 'Tèxt original',
	'replacetext_replacementtext' => 'Tèxt novèl',
	'replacetext_movepages' => 'Remplaçar lo tèxt dins lo títol de las paginas, se possible',
	'replacetext_choosepages' => 'Seleccionatz {{PLURAL:$3|la pagina|las paginas}} dins {{PLURAL:$3|la quala|las qualas}} volètz remplaçar « $1 » per « $2 » :',
	'replacetext_choosepagesformove' => 'Remplaçar lo tèxt dins {{PLURAL:$1|lo nom de las pagina seguenta|los noms de las paginas seguentas}} :',
	'replacetext_cannotmove' => '{{PLURAL:$1|La pagina seguenta a pas pogut èsser renomenada|Las paginas seguentas an pas pogut èsser renomenadas}} :',
	'replacetext_invertselections' => 'Inversar las seleccions',
	'replacetext_replace' => 'Remplaçar',
	'replacetext_success' => '« $1 » es estat remplaçat per « $2 » dins $3 fichièr{{PLURAL:$3||s}}.',
	'replacetext_noreplacement' => 'Cap de fichièr que conten la cadena « $1 » es pas estat trobat.',
	'replacetext_warning' => "I a $1 fichièr{{PLURAL:$1| que conten|s que contenon}} la cadena de remplaçament « $2 ».
Se efectuatz aquesta substitucion, poiretz pas separar vòstres cambiaments a partir d'aquestas cadenas.
Volètz contunhar aquestas substitucions ?",
	'replacetext_blankwarning' => 'Perque la cadena de remplaçament es voida, aquesta operacion serà irreversibla ; volètz contunhar ?',
	'replacetext_continue' => 'Contunhar',
	'replacetext_cancel' => "(Clicatz sul boton  « Retorn » de vòstre navigador per anullar l'operacion.)",
	'replacetext_editsummary' => 'Remplaçament del tèxt — « $1 » per « $2 »',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Maikking
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'replacetext' => 'Zastąp tekst',
	'replacetext-desc' => 'Dodaje [[Special:ReplaceText|stronę specjalną]], pozwalającą administratorom na wyszukanie i zamianę zadanego tekstu w treści wszystkich stron wiki',
	'replacetext_docu' => 'Możesz zastąpić jeden ciąg znaków innym, w treści wszystkich stron tej wiki. W tym celu wprowadź dwa fragmenty tekstu i naciśnij „Kontynuuj”. Zostanie pokazana lista stron, które zawierają wyszukiwany tekst. Będziesz mógł wybrać te strony, na których chcesz ten tekst zamienić na nowy. W historii zmian stron, do opisu autora edycji, zostanie użyta Twoja nazwa użytkownika.',
	'replacetext_note' => 'Uwaga: nie zastąpi tekstu na stronach dyskusji i stronach projektu.',
	'replacetext_originaltext' => 'Znajdź',
	'replacetext_replacementtext' => 'Zamień na',
	'replacetext_choosepages' => 'Wybierz {{PLURAL:$3|stronę|strony}}, na których chcesz „$1” zastąpić „$2”',
	'replacetext_replace' => 'Zastąp',
	'replacetext_success' => '„$1” zostanie zastąpiony przez „$2” na $3 {{PLURAL:$3|stronie|stronach}}.',
	'replacetext_noreplacement' => 'Nie znaleziono stron zawierających tekst „$1”.',
	'replacetext_warning' => '{{PLURAL:$1|Jest $1 strona|Są $1 strony|Jest $1 stron}} zawierających tekst „$2”, którym chcesz zastępować. Jeśli wykonasz zastępowanie nie będzie możliwe odseparowanie tych stron od wykonanych zastąpień.
Czy kontynuować zastępowanie?',
	'replacetext_blankwarning' => 'Ponieważ ciąg znaków, którym ma być wykonane zastępowanie jest pusty, operacja będzie nieodwracalna. Czy kontynuować?',
	'replacetext_continue' => 'Kontynuuj',
	'replacetext_cancel' => '(Wciśnij klawisz „Wstecz” w przeglądarce, aby przerwać operację.)',
	'replacetext_editsummary' => 'zamienił w treści „$1” na „$2”',
);

/** Portuguese (Português)
 * @author 555
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'replacetext' => 'Substituir texto',
	'replacetext-desc' => 'Provê uma [[Special:ReplaceText|página especial]] que permite que administradores procurem e substituam uma "string" global em todas as páginas de conteúdo de uma wiki.',
	'replacetext_docu' => 'Para substituir uma "string" de texto por outra em todas as páginas desta wiki você precisa fornecer as duas peças de texto a seguir, pressionando o botão \'Substituir\'. Será exibida uma lista de páginas que contenham o termo pesquisado, sendo possível selecionar em quais você deseja realizar substituições. Seu nome de utilizador aparecerá nos históricos de páginas como o responsável por ter feito as alterações.',
	'replacetext_note' => 'Nota: isto não substituirá textos em páginas de discussão e páginas do projeto.',
	'replacetext_originaltext' => 'Texto original',
	'replacetext_replacementtext' => 'Novo texto',
	'replacetext_movepages' => 'Substituir texto nos títulos das páginas também, quando possível',
	'replacetext_choosepages' => "Por favor, seleccione {{PLURAL:$3|a página na qual|as páginas nas quais}} deseja substituir '$1' por '$2':",
	'replacetext_choosepagesformove' => 'Substituir texto {{PLURAL:$1|no nome da seguinte página|nos nomes das seguintes páginas}}:',
	'replacetext_cannotmove' => '{{PLURAL:$1|A seguinte página não pode ser movida|As seguintes páginas não podem ser movidas}}:',
	'replacetext_invertselections' => 'Inverter selecções',
	'replacetext_replace' => 'Substituir',
	'replacetext_success' => "'$1' será substituído por '$2' em $3 {{PLURAL:$3|página|páginas}}.",
	'replacetext_noreplacement' => 'Não foram encontradas páginas contendo a "string" \'$1\'.',
	'replacetext_warning' => "Há {{PLURAL:$1|$1 página que já possui|$1 páginas que já possuem}} a cadeia de caracteres de substituição, '$2'.
Se você prosseguir com a substituição, não será possível distinguir as substituições feitas por si do texto já existente.
Deseja prosseguir com a substituição?",
	'replacetext_blankwarning' => 'Uma vez que a "string" de novo texto foi deixada em branco, esta operação não será reversível. Prosseguir?',
	'replacetext_continue' => 'Prosseguir',
	'replacetext_cancel' => '(Pressione o botão "Voltar" de seu navegador para cancelar a operação.)',
	'replacetext_editsummary' => "Substituindo texto '$1' por '$2'",
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Enqd
 */
$messages['pt-br'] = array(
	'replacetext' => 'Substituir texto',
	'replacetext-desc' => 'Fornece uma [[Special:ReplaceText|página especial]] que permite que administradores procurem e substituam uma "string" global em todas as páginas de conteúdo de uma wiki.',
	'replacetext_docu' => 'Para substituir uma "string" de texto por outra em todas as páginas desta wiki você precisa fornecer o texto a ser substituído e o novo texto, logo em seguida pressione o botão \'Substituir\'. Será exibida uma lista de páginas que contenham o termo pesquisado, sendo possível selecionar em quais você deseja realizar substituições. Seu nome de utilizador aparecerá nos históricos de páginas como o responsável por ter feito as alterações.',
	'replacetext_note' => 'Nota: isto não substituirá textos em páginas de discussão e organizacionais do projeto, além de não substituir texto nos títulos de páginas.',
	'replacetext_originaltext' => 'Texto original',
	'replacetext_replacementtext' => 'Novo texto',
	'replacetext_choosepages' => "Selecione as páginas nas quais deseja substituir '$1' por '$2':",
	'replacetext_replace' => 'Substituir',
	'replacetext_success' => "'$1' será substituído por '$2' em $3 páginas.",
	'replacetext_noreplacement' => 'Não foram encontradas páginas contendo a "string" \'$1\'.',
	'replacetext_warning' => 'Há $1 páginas que atualmente já possuem a "string" de substituição (\'$2\'); se você prosseguir, não será possível distinguir as substituições feitas por você desse texto já existente. Deseja prosseguir?',
	'replacetext_blankwarning' => 'Uma vez que a "string" de novo texto foi deixada em branco, esta operação não será reversível. Prosseguir?',
	'replacetext_continue' => 'Prosseguir',
	'replacetext_cancel' => '(pressione o botão "voltar" de seu navegador para cancelar a operação.)',
	'replacetext_editsummary' => "Substituindo texto '$1' por '$2'",
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'replacetext_originaltext' => 'Text original',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Rubin
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'replacetext' => 'Заменить текст',
	'replacetext_originaltext' => 'Оригинальный текст',
	'replacetext_replace' => 'Заменить',
	'replacetext_continue' => 'Продолжить',
	'replacetext_editsummary' => 'Текст заменён — «$1» на «$2»',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'replacetext' => 'Nahradiť text',
	'replacetext-desc' => 'Poskytuje [[Special:ReplaceText|špeciálnu stránku]], ktorá správcom umožňuje globálne nájsť a nahradiť text na všetkých stránkach celej wiki.',
	'replacetext_docu' => 'Nájsť text na všetkých stránkach tejto wiki a nahradiť ho iným textom môžete tak, že sem napíšete texty a stlačíte „Pokračovať”. Potom sa vám zobrazí zoznam stránok obsahujúcich hľadaný text a môžete si zvoliť tie, na ktorých ho chcete nahradiť. V histórii úprav sa zaznamená vaše meno.',
	'replacetext_note' => 'Pozn.: Týmto nemožno nahradiť text na diskusných a projektových stránkach.',
	'replacetext_originaltext' => 'Pôvodný text',
	'replacetext_replacementtext' => 'Nahradiť textom',
	'replacetext_movepages' => 'Nahradiť text aj v názvoch stránok, ak je to možné',
	'replacetext_choosepages' => 'Prosím, vyberte {{PLURAL:$3|stránku, na ktorej|stránky, na ktorých}} chcete nahradiť „$1“ za „$2“:',
	'replacetext_choosepagesformove' => 'Nahradiť text v {{PLURAL:$1|názve nasledovnej stránky|názvoch nasledovných stránok}}:',
	'replacetext_cannotmove' => '{{PLURAL:$1|Nasledovnú stránku|Nasledovné stránky}} nemožno presunúť:',
	'replacetext_invertselections' => 'Invertovať výber',
	'replacetext_replace' => 'Nahradiť',
	'replacetext_success' => 'Text „$1” bude nahradený textom „$2” na $3 {{PLURAL:$3|stránke|stránkach}}.',
	'replacetext_noreplacement' => 'Nenašli sa žiadne stránky obsahujúce text „$1”.',
	'replacetext_warning' => '$1 {{PLURAL:$1|stránka|stránok}} už obsahuje text „$2”, ktorým chcete text nahradiť; ak budete pokračovať a text nahradíte, nebudete môcť odlíšiť vaše nahradenia od existujúceho textu, ktorý tento reťazec už obsahuje. Pokračovať v nahradení?',
	'replacetext_blankwarning' => 'Pretože text, ktorým text chcete nahradiť je prázdny, operácia bude nevratná. Pokračovať?',
	'replacetext_continue' => 'Pokračovať',
	'replacetext_cancel' => '(Operáciu zrušíte stlačením tlačidla „Späť” vo vašom prehliadači.)',
	'replacetext_editsummary' => 'Nahradenie textu „$1” textom „$2”',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Sasa Stefanovic
 */
$messages['sr-ec'] = array(
	'replacetext_originaltext' => 'Оригинални текст',
	'replacetext_replacementtext' => 'Текст за преснимавање',
	'replacetext_replace' => 'Пресними',
	'replacetext_success' => "Преснимљен '$1' са '$2' на $3 страница.",
	'replacetext_continue' => 'Настави',
);

/** Swedish (Svenska)
 * @author M.M.S.
 * @author Najami
 */
$messages['sv'] = array(
	'replacetext' => 'Ersätt text',
	'replacetext-desc' => 'Låter administratörer [[Special:ReplaceText|ersätta text]] på alla innehållssidor på en wiki',
	'replacetext_docu' => 'För att ersätta en textträng med en annan på alla datasidor på den här wikin kan du skriva in de två texterna här och klicka på "Ersätt". Du kommer sedan att visas på en lista över sidor som innehåller söktexten, och du kan välja en av dom som du vill ersätta. Ditt namn kommer visas i sidhistoriken som den som är ansvarig för ändringarna.',
	'replacetext_note' => 'Notera: det här kommer inte ersätta text på "Diskussion"-sidor och projektsidor.',
	'replacetext_originaltext' => 'Originaltext',
	'replacetext_replacementtext' => 'Ersättningstext',
	'replacetext_movepages' => 'Ersätt text i sidtitlar när det är möjligt',
	'replacetext_choosepages' => "Var god ange för {{PLURAL:$3|vilken sida|vilka sidor}} du vill ersätta '$1' med '$2':",
	'replacetext_choosepagesformove' => 'Ersätt text i {{PLURAL:$1|namnet på den följande sidan|namnen på de följande sidorna}}:',
	'replacetext_cannotmove' => '{{PLURAL:$1|Den följande sidan|De följande sidorna}} kan inte flyttas:',
	'replacetext_invertselections' => 'Invertera val',
	'replacetext_replace' => 'Ersätt',
	'replacetext_success' => "'$1' kommer att ersättas med '$2' på $3 {{PLURAL:$3|sida|sidor}}.",
	'replacetext_noreplacement' => 'Inga sidor hittades med strängen "$1".',
	'replacetext_warning' => 'Det finns $1 sidor som redan har ersättningssträngen "$2". Om du gör den här ersättningen kommer du inte kunna separera dina ersättningar från den här texten. Vill du fortsätta med ersättningen?',
	'replacetext_blankwarning' => 'Eftersom ersättningstexten är tom kommer den här handlingen inte kunna upphävas; vill du fortsätta?',
	'replacetext_continue' => 'Fortsätt',
	'replacetext_cancel' => '(Klicka på "Tillbaka"-knappen för att avbryta handlingen.)',
	'replacetext_editsummary' => 'Textersättning - "$1" till "$2"',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'replacetext_originaltext' => 'అసలు పాఠ్యం',
	'replacetext_replacementtext' => 'మార్పిడి పాఠ్యం',
	'replacetext_continue' => 'కొనసాగించు',
);

/** Thai (ไทย)
 * @author Passawuth
 */
$messages['th'] = array(
	'replacetext_originaltext' => 'ข้อความดั้งเดิม',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'replacetext' => 'Palitan ang teksto',
	'replacetext-desc' => 'Nagbibigay ng isang [[Special:ReplaceText|natatanging pahina]] upang mapahintulutan ang mga tagapangasiwa na makagawa ng isang baging na pandaidigang hanapin-at-palitan sa ibabaw ng lahat ng mga pahina ng nilalaman ng isang wiki',
	'replacetext_docu' => "Upang mapalitan ang isang bagting ng teksto ng iba pang nasa kahabaan ng lahat ng pangkaraniwang mga pahinang nasa ibabaw ng wiking ito, ipasok ang dalawang piraso ng teksto dito at pindutin pagkatapos ang 'Magpatuloy'. Susunod na ipapakita naman sa iyo ang isang talaan ng mga pahinang naglalaman ng teksto ng paghanap, at mapipili mo ang mga maaari mong ipamalit dito. Lilitaw ang pangalan mo sa mga kasaysayan ng pahina bilang tagagamit na umaako sa anumang mga pagbabago.",
	'replacetext_note' => 'Paunawa: hindi nito papalitan ang tekstong nasa loob ng mga pahina ng "Usapan" at mga pahina ng proyekto.',
	'replacetext_originaltext' => 'Orihinal na teksto',
	'replacetext_replacementtext' => 'Pamalit na teksto',
	'replacetext_movepages' => 'Palitan din ang tekstong nasa loob ng mga pamagat ng pahina, kung kailan maaari',
	'replacetext_choosepages' => "Pakipili ang {{PLURAL:$3|pahina|mga pahina}} kung saan mo naisa na palitan ang '$1' ng '$2':",
	'replacetext_choosepagesformove' => 'Palitan ang tekstong nasa loob ng {{PLURAL:$1|pangalan ng sumusunod na pahina|mga pangalan ng sumusunod na mga pahina}}:',
	'replacetext_cannotmove' => 'Hindi maililipat ang sumusunod na {{PLURAL:$1|pahina|mga pahina}}:',
	'replacetext_invertselections' => 'Baligtarin ang mga pagpipilian',
	'replacetext_replace' => 'Palitan',
	'replacetext_success' => "Ang '$1' ay mapapalitan ng '$2' sa loob ng $3 {{PLURAL:$3|pahina|mga pahina}}.",
	'replacetext_noreplacement' => "Walang natagpuang mga pahinang naglalaman ng bagting na '$1'.",
	'replacetext_warning' => "Mayroong {{PLURAL:$1|$1 pahinang naglalaman na|$1 mga pahinang naglalaman na}} ng pamalit na bagting, '$2'.
Kapag ginawa mo ang pagpapalit na ito hindi mo na maihihiwalay ang mga pamalit mo mula sa mga bagting na ito.
Ipagpapatuloy pa rin ba ang pagpapalit?",
	'replacetext_blankwarning' => 'Dahil sa walang laman ang bagting ng pamalit, hindi na maibabalik pa sa dati ang gawaing ito/
Naisa mo bang magpatuloy pa?',
	'replacetext_continue' => 'Magpatuloy',
	'replacetext_cancel' => "(Pindutin ang pinduting \"Magbalik\" sa iyong pantingin-tingin o ''browser'' upang huwag nang maipagpatuloy ang gawain.)",
	'replacetext_editsummary' => "Palitan ang tekso - '$1' papunta sa '$2'",
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'replacetext' => 'Thay thế văn bản',
	'replacetext-desc' => 'Cung cấp một [[Special:ReplaceText|trang đặc biệt]] để cho phép bảo quản viên thực hiện tìm-kiếm-và-thay-thế thống nhất trên tất cả các trang có nội dung tại một wiki',
	'replacetext_docu' => "Để thay thế một chuỗi ký tự bằng một chuỗi khác trên toàn bộ các trang thông thường tại wiki này, hãy gõ vào hai đoạn văn bản ở đây và sau đó nhấn 'Tiếp tục'. Khi đó bạn thấy một danh sách các trang có chứa đoạn ký tự được tìm, và bạn có thể chọn những trang mà bạn muốn thay thế. Tên của bạn sẽ xuất hiện trong lịch sử trang như một thành viên chịu trách nhiệm về bất kỳ thay đổi nào.",
	'replacetext_note' => 'Chú ý: tác vụ này sẽ không thay thế văn bản trong những trang "Thảo luận" và trang dự án.',
	'replacetext_originaltext' => 'Văn bản nguồn',
	'replacetext_replacementtext' => 'Văn bản thay thế',
	'replacetext_choosepages' => 'Xin hãy chọn những trang mà bạn muốn thay   ‘$1’ bằng ‘$2’:',
	'replacetext_replace' => 'Thay thế',
	'replacetext_success' => '‘$1’ sẽ được thay bằng ‘$2’ trong ‘$3’ trang.',
	'replacetext_noreplacement' => 'Không tìm thấy trang nào có chứa chuỗi ‘$1’.',
	'replacetext_warning' => 'Có $1 trang đã có chứa chuỗi thay thế, ‘$2’; nếu bạn thực hiện thay thế này bạn sẽ không thể phân biệt sự thay thế của bạn với những chuỗi này. Tiếp tục thay thế chứ?',
	'replacetext_blankwarning' => 'Vì chuỗi thay thế là khoảng trắng, tác vụ này sẽ không thể hồi lại được; tiếp tục?',
	'replacetext_continue' => 'Tiếp tục',
	'replacetext_cancel' => '(Nhấn vào nút "Lùi" để hủy tác vụ.)',
	'replacetext_editsummary' => 'Thay thế văn bản - ‘$1’ thành ‘$2’',
);

/** Volapük (Volapük)
 * @author Smeira
 */
$messages['vo'] = array(
	'replacetext' => 'Plaädön vödemi',
	'replacetext_note' => 'Noet: vödem in bespikapads ed in proyegapads no poplaädon.',
	'replacetext_originaltext' => 'Rigavödem',
	'replacetext_replacementtext' => 'Plaädamavödem',
	'replacetext_movepages' => 'Plaädön vödemi i pö padatiäds, ven mögos',
	'replacetext_choosepages' => 'Välolös {{PLURAL:$3|padi, su kel|padis, su kels}} vilol plaädön vödemi: „$1“ me vödem: „$2“:',
	'replacetext_cannotmove' => '{{PLURAL:$1|Pad|Pads}} fovik no kanons patopätükön:',
	'replacetext_replace' => 'Plaädön',
	'replacetext_success' => 'Vödem: „$1“ poplaädon dub vödem: „$2“ su {{PLURAL:$3|pad bal|pads $3}}.',
	'replacetext_noreplacement' => 'Pads nonik labü vödem: „$1“ petuvons.',
	'replacetext_blankwarning' => 'Bi plaädamavödem binon vägik, dun at no kanon pasädunön. Vilol-li fümiko ledunön plaädami?',
	'replacetext_continue' => 'Ledunön',
	'replacetext_editsummary' => 'Vödemiplaädam - „$1“ ad „$2“',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Roc michael
 */
$messages['zh-hant'] = array(
	'replacetext' => '取代文字',
	'replacetext-desc' => '提供[[Special:ReplaceText|特殊頁面]]以利管理員以「尋找及取代」的方式更改所有文章頁面內的內容。',
	'replacetext_docu' => '取代儲存在此Wiki系統內所有頁面上的文字字串，請將「原始文字」及「取代的文字」分別填入下面的兩個欄位之中，按下「取代按鈕」後生效，您所作的修改會顯示在「歷史」頁面上，以對您自己編輯行為負責。',
	'replacetext_note' => '注意：在所有討論頁面及其他系統的計劃頁面上的文字不會被修改，此外，頁面名稱裡的文字亦不會被修改。',
	'replacetext_originaltext' => '原始文字',
	'replacetext_replacementtext' => '取代文字',
	'replacetext_replace' => '取代',
	'replacetext_success' => '已在 $3 個檔案內的「$1」取代為「$2」。',
	'replacetext_noreplacement' => '因無任何頁面內含有「$1」。',
	'replacetext_warning' => '僅有$1檔案內包含取代文字「$2」，如果您執行了取代作業，則可能會造成兩個相同字串相連，而難以分開，您要繼續執行取代作業嗎？',
	'replacetext_blankwarning' => '因為取代字串是空白的，這將造成難以復原的結果！您要繼續嗎？',
	'replacetext_continue' => '繼續',
	'replacetext_cancel' => '(按下 "返回" 按鈕以取消本次操作)',
	'replacetext_editsummary' => '取代文字 - 「$1」 取代為 「$2」',
);

/** Chinese (Taiwan) (‪中文(台灣)‬)
 * @author Roc michael
 */
$messages['zh-tw'] = array(
	'replacetext' => '取代文字',
	'replacetext-desc' => '提供[[Special:ReplaceText|特殊頁面]]以利管理員以「尋找及取代」的方式更改所有文章頁面內的內容。',
	'replacetext_docu' => '取代儲存在此Wiki系統內所有頁面上的文字字串，請將「原始文字」及「取代的文字」分別填入下面的兩個欄位之中，按下「取代按鈕」後生效，您所作的修改會顯示在「歷史」頁面上，以對您自己編輯行為負責。',
	'replacetext_note' => '注意：在所有討論頁面及其他系統的計劃頁面上的文字不會被修改，此外，頁面名稱裡的文字亦不會被修改。',
	'replacetext_originaltext' => '原始文字',
	'replacetext_replacementtext' => '取代文字',
	'replacetext_choosepages' => '請選擇頁面，以便將「$1」取代為「$2」：',
	'replacetext_replace' => '取代',
	'replacetext_success' => '已將 $3 個頁面內的「$1」取代為「$2」。',
	'replacetext_noreplacement' => '因無任何頁面內含有「$1」。',
	'replacetext_warning' => '僅有$1檔案內包含取代文字「$2」，如果您執行了取代作業，則可能會造成兩個相同字串相連，而難以分開，您要繼續執行取代作業嗎？',
	'replacetext_blankwarning' => '因為取代字串是空白的，這將造成難以復原的結果！您要繼續嗎？',
	'replacetext_continue' => '繼續',
	'replacetext_cancel' => '(按下 "返回" 按鈕以取消本次操作)',
	'replacetext_editsummary' => '取代文字 - 「$1」 取代為 「$2」',
);

