<?php
/**
 * Internationalisation file for extension SpamRegex.
 *
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Bartek Łapiński
 */
$messages['en'] = array(
	'spamregex'                      => 'Spam regex',
	'spamregex-desc'                 => '[[Special:SpamRegex|Filter]] out unwanted phrases in edited pages, based on regular expressions',
	'spamregex-error-unblocking' => 'Error unblocking "$1". Probably there is no such pattern.',
	'spamregex-summary'              => 'The text was found in the page\'s summary.',
	'spamregex-intro'                => 'Use this form to effectively block expressions from saving into a page\'s text.
If the text contains the given expression, change would not be saved and an explanation will be displayed to user that tried to save the page.
Caution advised, expressions should not be too short or too common.',
	'spamregex-page-title'           => 'Spam regex unwanted expressions block',
	'spamregex-currently-blocked'    => "'''Currently blocked phrases:'''",
	'spamregex-move' => 'The reason you entered contained a blocked phrase. ',
	'spamregex-no-currently-blocked' => "'''There are no blocked phrases.'''",
	'spamregex-log-1'                => '* \'\'\'$1\'\'\' $2 ([{{SERVER}}$3&text=$4 remove]) added by ',
	'spamregex-log-2'                => ' on $1',
	'spamregex-page-title-1'         => 'Block phrase using regular expressions',
	'spamregex-unblock-success'      => 'Unblock succedeed',
	'spamregex-unblock-message'      => 'Phrase \'\'\'$1\'\'\' has been unblocked from editing.',
	'spamregex-page-title-2'         => 'Block phrases from saving using regular expressions',
	'spamregex-block-success'        => 'Block succedeed',
	'spamregex-block-message'        => 'Phrase \'\'\'$1\'\'\' has been blocked.',
	'spamregex-warning-1'            => 'Give a phrase to block.',
	'spamregex-error-1'              => 'Invalid regular expression.',
	'spamregex-warning-2'            => 'Please check at least one blocking mode.',
	'spamregex-already-blocked'      => '"$1" is already blocked',
	'spamregex-phrase-block'         => 'Phrase to block:',
	'spamregex-phrase-block-text'    => 'block phrase in page text',
	'spamregex-phrase-block-summary' => 'block phrase in summary',
	'spamregex-block-submit'         => 'Block&nbsp;this&nbsp;phrase',
	'spamregex-text'                 => '(Text)',
	'spamregex-summary-log'          => '(Summary)',
);

/** Message documentation (Message documentation)
 * @author Jon Harald Søby
 * @author Purodha
 */
$messages['qqq'] = array(
	'spamregex-desc' => 'Shown in [[Special:Version]] as a short description of this extension. Do not translate links.',
	'spamregex-already-blocked' => '{{Identical|$1 is already blocked}}',
	'spamregex-text' => '{{Identical|Text}}',
	'spamregex-summary-log' => '{{Identical|Summary}}',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'spamregex-summary-log' => '(Fakakatoakatoa)',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 * @author SPQRobin
 */
$messages['af'] = array(
	'spamregex-already-blocked' => '"$1" is reeds geblok',
	'spamregex-text' => '(Teks)',
	'spamregex-summary-log' => '(Opsomming)',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'spamregex-text' => '(ጽሕፈት)',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'spamregex-already-blocked' => '"$1" ya yera bloqueyato',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'spamregex' => 'تعبير منتظم لسبام',
	'spamregex-desc' => '[[Special:SpamRegex|فلتر]] العبارات غير المرغوب فيها في الصفحات المعدلة، بالاعتماد على التعبيرات المنتظمة',
	'spamregex-error-unblocking' => 'خطأ رفع منع "$1". على الأرجح لا يوجد نمط كهذا.',
	'spamregex-summary' => 'النص تم العثور عليه في ملخص الصفحة.',
	'spamregex-intro' => 'استخدم هذه الاستمارة لمنع تعبيرات من الحفظ في نص صفحة بكفاءة.
لو أن النص يحتوي على التعبير المعطى، لن يتم حفظ التغيير وسيتم عرض تفسير للمستخدم الذي حاول حفظ الصفحة.
ينصح بالحذر، التعبيرات لا ينبغي أن تكون قصيرة جدا أو شائعة جدا.',
	'spamregex-page-title' => 'منع تعبير منتظم لسبام التعبيرات غير المرغوب فيها',
	'spamregex-currently-blocked' => "'''العبارات الممنوعة حاليا:'''",
	'spamregex-move' => 'السبب الذي أدخلته يحتوي على عبارة ممنوعة.',
	'spamregex-no-currently-blocked' => "'''لا توجد عبارات ممنوعة.'''",
	'spamregex-log-1' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 إزالة]) تمت إضافتها بواسطة",
	'spamregex-log-2' => ' في $1',
	'spamregex-page-title-1' => 'منع عبارة باستخدام التعبيرات المنتظمة',
	'spamregex-unblock-success' => 'رفع المنع نجح',
	'spamregex-unblock-message' => "العبارة '''$1''' تم رفع المنع عنها ضد التحرير.",
	'spamregex-page-title-2' => 'منع العبارات من الحفظ باستخدام التعبيرات المنتظمة',
	'spamregex-block-success' => 'المنع نجح',
	'spamregex-block-message' => "العبارة '''$1''' تم منعها.",
	'spamregex-warning-1' => 'أعط عبارة للمنع.',
	'spamregex-error-1' => 'تعبير منتظم غير صحيح.',
	'spamregex-warning-2' => 'من فضلك علم على نمط منع واحد على الأقل.',
	'spamregex-already-blocked' => '"$1" ممنوعة بالفعل',
	'spamregex-phrase-block' => 'العبارة للمنع:',
	'spamregex-phrase-block-text' => 'منع عبارة في نص صفحة',
	'spamregex-phrase-block-summary' => 'منع عبارة في ملخص',
	'spamregex-block-submit' => 'منع&nbsp;هذه&nbsp;العبارة',
	'spamregex-text' => '(نص)',
	'spamregex-summary-log' => '(ملخص)',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 */
$messages['arz'] = array(
	'spamregex' => 'تعبير منتظم لسبام',
	'spamregex-desc' => '[[Special:SpamRegex|فلتر]] العبارات غير المرغوب فيها فى الصفحات المعدلة، بالاعتماد على التعبيرات المنتظمة',
	'spamregex-error-unblocking' => 'خطأ رفع منع "$1". على الأرجح لا يوجد نمط كهذا.',
	'spamregex-summary' => 'النص تم العثور عليه فى ملخص الصفحة.',
	'spamregex-intro' => 'استخدم الاستمارة دى لمنع تعبيرات من الحفظ فى نص صفحة بكفاءة.
لو أن النص يحتوى على التعبير المعطى، مش هايتحفظ التغيير و هايتعرض تفسير لليوزر اللى حاول حفظ الصفحة.
ينصح بالحذر، التعبيرات لازم ماتكونش قصيرة جدا أو شائعة جدا.',
	'spamregex-page-title' => 'منع تعبير منتظم لسبام التعبيرات غير المرغوب فيها',
	'spamregex-currently-blocked' => "'''العبارات الممنوعة حاليا:'''",
	'spamregex-move' => 'السبب الذى أدخلته يحتوى على عبارة ممنوعة.',
	'spamregex-no-currently-blocked' => "'''لا توجد عبارات ممنوعة.'''",
	'spamregex-log-1' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 إزالة]) تمت إضافتها بواسطة",
	'spamregex-log-2' => ' فى $1',
	'spamregex-page-title-1' => 'منع عبارة باستخدام التعبيرات المنتظمة',
	'spamregex-unblock-success' => 'رفع المنع نجح',
	'spamregex-unblock-message' => "العبارة '''$1''' تم رفع المنع عنها ضد التحرير.",
	'spamregex-page-title-2' => 'منع العبارات من الحفظ باستخدام التعبيرات المنتظمة',
	'spamregex-block-success' => 'المنع نجح',
	'spamregex-block-message' => "العبارة '''$1''' تم منعها.",
	'spamregex-warning-1' => 'أعط عبارة للمنع.',
	'spamregex-error-1' => 'تعبير منتظم غير صحيح.',
	'spamregex-warning-2' => 'من فضلك علم على نمط منع واحد على الأقل.',
	'spamregex-already-blocked' => '"$1" ممنوعة بالفعل',
	'spamregex-phrase-block' => 'العبارة للمنع:',
	'spamregex-phrase-block-text' => 'منع عبارة فى نص صفحة',
	'spamregex-phrase-block-summary' => 'منع عبارة فى ملخص',
	'spamregex-block-submit' => 'منع&nbsp;هذه&nbsp;العبارة',
	'spamregex-text' => '(نص)',
	'spamregex-summary-log' => '(ملخص)',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Spiritia
 */
$messages['bg'] = array(
	'spamregex-desc' => '[[Special:SpamRegex|Филтриране]] на нежелани фрази в редактираните страници с помощта на регулярни изрази',
	'spamregex-summary' => 'Текстът е намерен в резюмето на страницата.',
	'spamregex-currently-blocked' => "'''Текущо блокирани фрази:'''",
	'spamregex-move' => 'Въведената причина съдържа блокирана фраза.',
	'spamregex-no-currently-blocked' => "'''Няма блокирани фрази.'''",
	'spamregex-log-2' => ' на $1',
	'spamregex-page-title-1' => 'Блокиране на фрази чрез регулярни изрази',
	'spamregex-unblock-success' => 'Успешно разблокиране',
	'spamregex-unblock-message' => "Фразата '''$1''' беше отблокирана за редактиране.",
	'spamregex-page-title-2' => 'Блокиране на съхранението на фраза посредством регулярни изрази',
	'spamregex-block-success' => 'Успешно блокиране',
	'spamregex-block-message' => "Фразата '''$1''' беше блокирана.",
	'spamregex-error-1' => 'Невалиден регулярен израз.',
	'spamregex-already-blocked' => '„$1“ е вече блокиран',
	'spamregex-phrase-block' => 'Фраза за блокиране:',
	'spamregex-phrase-block-text' => 'блокиране на фраза в текста на статията',
	'spamregex-phrase-block-summary' => 'блокиране на фраза в резюмето',
	'spamregex-block-submit' => 'Блокиране&nbsp;на&nbsp;фразата',
	'spamregex-text' => '(Текст)',
	'spamregex-summary-log' => '(Резюме)',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'spamregex-already-blocked' => '"$1" je već blokiran',
);

/** Catalan (Català)
 * @author SMP
 */
$messages['ca'] = array(
	'spamregex-already-blocked' => '«$1» ja està blocat',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'spamregex-text' => '(Tekst)',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author Revolus
 */
$messages['de'] = array(
	'spamregex' => 'Spam regex',
	'spamregex-desc' => '[[Special:SpamRegex|Filtere]] ungewollte Phrasen, basierend auf regulären Ausdrücken, aus geänderten Seiten aus',
	'spamregex-error-unblocking' => 'Konnte „$1“ nicht freigeben. Wahrscheinlich existiert kein solches Muster.',
	'spamregex-summary' => 'Der Text wurde in der Zusammenfassung gefunden.',
	'spamregex-intro' => 'Benutze dieses Formular, um effektiv zu verhindern, dass angegebene Phrasen in den Text einer Seite eingefügt werden.
Wenn der Text die angegebene Phrase enthält, wird die Änderung nicht gespeichert und ein Hinweis an den Benutzer ausgegeben, der versucht hat, die Seite zu speichern.
Sei aber vorsichtig, Phrasen sollten nicht zu kurz oder zu allgemein sein.',
	'spamregex-page-title' => 'Filtern ungewollter Ausdrücke',
	'spamregex-currently-blocked' => "'''Derzeit gesperrte Phrasen:'''",
	'spamregex-move' => 'Die Zusammenfassung, die du angabst, enthält eine gesperrte Phrase.',
	'spamregex-no-currently-blocked' => "'''Es gibt derzeit keine gesperrten Phrasen.'''",
	'spamregex-log-1' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 entfernen]), hinzugefügt von",
	'spamregex-log-2' => '  auf $1',
	'spamregex-page-title-1' => 'Sperre Phrase als regulären Ausdruck',
	'spamregex-unblock-success' => 'Entsperrung erfolgreich',
	'spamregex-unblock-message' => "Phrase „'''$1'''“ wurde für Bearbeitungen entsperrt.",
	'spamregex-page-title-2' => 'Sperre das Speichern der Phrase als regulären Ausdruck',
	'spamregex-block-success' => 'Sperrung erfolgreich',
	'spamregex-block-message' => "Phrase „'''$1'''“ wurde gesperrt.",
	'spamregex-warning-1' => 'Phrase zum Sperren angeben',
	'spamregex-error-1' => 'Ungültiger regulärer Ausdruck.',
	'spamregex-warning-2' => 'Bitte wähle mindestens eine Sperrmethode aus.',
	'spamregex-already-blocked' => '„$1“ ist bereits gesperrt',
	'spamregex-phrase-block' => 'Zu sperrende Phrase:',
	'spamregex-phrase-block-text' => 'Phrase im Seitentext sperren',
	'spamregex-phrase-block-summary' => 'Phrase in der Zusammenfassung sperren',
	'spamregex-block-submit' => 'Phrase sperren',
	'spamregex-text' => '(Text)',
	'spamregex-summary-log' => '(Zusammenfassung)',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author ChrisiPK
 */
$messages['de-formal'] = array(
	'spamregex-intro' => 'Benutzen Sie dieses Formular, um effektiv zu verhindern, dass angegebene Phrasen in den Text einer Seite eingefügt werden.
Wenn der Text die angegebene Phrase enthält, wird die Änderung nicht gespeichert und ein Hinweis an den Benutzer ausgegeben, der versucht hat, die Seite zu speichern.
Seien Sie aber vorsichtig, Phrasen sollten nicht zu kurz oder zu allgemein sein.',
	'spamregex-warning-2' => 'Bitte wählen Sie mindestens eine Sperrmethode aus.',
);

/** Greek (Ελληνικά)
 * @author Consta
 */
$messages['el'] = array(
	'spamregex-text' => '(κείμενο)',
	'spamregex-summary-log' => '(Περίληψη)',
);

/** Esperanto (Esperanto)
 * @author Melancholie
 * @author Yekrats
 */
$messages['eo'] = array(
	'spamregex-summary' => 'La teksto estis trovita en la resumo de la paĝo.',
	'spamregex-currently-blocked' => "'''Nune forbaritaj frazeroj:'''",
	'spamregex-move' => 'La kialo kiun vi enigis enhavis forbaritajn frazeron.',
	'spamregex-no-currently-blocked' => "'''Ne estas iuj ajn forbaritaj vortaj kombinaĵoj.'''",
	'spamregex-log-2' => 'je $1',
	'spamregex-page-title-1' => 'Forbari frazero uzante regularajn esprimojn',
	'spamregex-unblock-success' => 'Malforbaro sukcesis',
	'spamregex-unblock-message' => "Frazero '''$1''' estis malforbarita de redaktado.",
	'spamregex-page-title-2' => 'Malpermesigi frazerojn kontraŭ konservado per regularaj esprimoj',
	'spamregex-block-success' => 'Forbaro sukcesis',
	'spamregex-block-message' => "Frazero '''$1''' estis forbarita.",
	'spamregex-warning-1' => 'Eligi frazeron por forbari.',
	'spamregex-error-1' => 'Nevalida regula esprimo.',
	'spamregex-already-blocked' => '"$1" jam estas forbarita.',
	'spamregex-phrase-block' => 'Vorta kombinaĵo por forbari:',
	'spamregex-phrase-block-text' => 'forbari frazon en paĝa teksto',
	'spamregex-phrase-block-summary' => 'forbari frazeron en resumo',
	'spamregex-block-submit' => 'Forbari&nbsp;ĉi&nbsp;tiun&nbsp;frazeron',
	'spamregex-text' => '(Teksto)',
	'spamregex-summary-log' => '(Resumo)',
);

/** Spanish (Español)
 * @author Imre
 */
$messages['es'] = array(
	'spamregex-text' => '(Texto)',
	'spamregex-summary-log' => '(Resumen)',
);

/** Basque (Euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'spamregex-text' => '(Testu)',
	'spamregex-summary-log' => '(Laburpen)',
);

/** Finnish (Suomi)
 * @author Str4nd
 */
$messages['fi'] = array(
	'spamregex-unblock-success' => 'Eston poisto onnistui',
	'spamregex-block-success' => 'Esto onnistui',
	'spamregex-error-1' => 'Virheellinen säännöllinen lauseke.',
);

/** French (Français)
 * @author Grondin
 * @author IAlex
 * @author Meno25
 * @author Urhixidur
 */
$messages['fr'] = array(
	'spamregex' => 'Expressions régulières de pourriels',
	'spamregex-desc' => '[[Special:SpamRegex|Filtre]], dans les pages, les phrases ou mots indésirables, basé sur des expressions régulières',
	'spamregex-error-unblocking' => 'Erreur de déblocage de « $1 ». Il n’y a pas probablement aucun modèle.',
	'spamregex-summary' => 'Le texte en question a été détecté dans le commentaire de la page.',
	'spamregex-intro' => 'Utilisez ce formulaire pour bloquer effectivement les expressions pouvant être sauvegardées dans une page texte. Si le texte contient les expressions définies, les changements ne pourront être sauvegardés et un motif explicatif sera affiché à l’utilisateur qui a voulu sauvegarder la page. Il est important de prendre en considération que les expressions ne devront être ni trop longues ni trop courantes.',
	'spamregex-page-title' => 'Blocage des expressions régulières de pourriels',
	'spamregex-currently-blocked' => "'''Phrases actuellement bloquées :'''",
	'spamregex-move' => 'Le motif que vous avez inscrit contenait une phrase bloquée.',
	'spamregex-no-currently-blocked' => "'''Il n’y a aucune phrase bloquée.'''",
	'spamregex-log-1' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 supprimer]) ajouté par",
	'spamregex-log-2' => ' le $1',
	'spamregex-page-title-1' => 'Blocage d’une phrase utilisant des expressions régulières',
	'spamregex-unblock-success' => 'Le déblocage a réussi',
	'spamregex-unblock-message' => "La phrase '''$1''' a été débloquée à l’édition.",
	'spamregex-page-title-2' => 'Blocage des phrases en utilisant des expression régulières',
	'spamregex-block-success' => 'Le blocage a réussi',
	'spamregex-block-message' => "La phrase '''$1''' a été bloquée.",
	'spamregex-warning-1' => 'Indiquez une phrase à bloquer.',
	'spamregex-error-1' => 'Expression régulière invalide.',
	'spamregex-warning-2' => 'Choisissez au moins un mode de blocage.',
	'spamregex-already-blocked' => '« $1 » est déjà bloqué',
	'spamregex-phrase-block' => 'Phrase à bloquer :',
	'spamregex-phrase-block-text' => 'bloquer la phrase dans le texte de la page',
	'spamregex-phrase-block-summary' => 'bloquer la phrase dans le commentaire',
	'spamregex-block-submit' => 'Bloquer&nbsp;cette&nbsp;phrase',
	'spamregex-text' => '(Texte)',
	'spamregex-summary-log' => '(Commentaire)',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'spamregex-already-blocked' => '"$1" is al útsluten',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'spamregex' => 'SpamRegex',
	'spamregex-desc' => '[[Special:SpamRegex|Filtro]] de frases non desexadas nas páxinas editadas, baseado en expresións regulares',
	'spamregex-error-unblocking' => 'Erro ao desbloquear "$1". Probablemente non hai tal patrón.',
	'spamregex-summary' => 'O texto foi atopado no resumo da páxina.',
	'spamregex-intro' => 'Use este formulario para bloquear de maneira efectiva expresións para que non se poidan gardar no texto dunha páxina.
Se o texto contén a expresión dada, o cambio non poderá ser gardado e unha explicación será amosada ao usuario que intentou gardar a páxina.
Teña en conta que as expresións non deberían ser moi curtas ou moi comúns.',
	'spamregex-page-title' => 'Bloqueo spam regex de expresións non desexadas',
	'spamregex-currently-blocked' => "'''Frases actualmente bloqueadas:'''",
	'spamregex-move' => 'O motivo que inseriu contén unha frase bloqueada.',
	'spamregex-no-currently-blocked' => "'''Non hai frases bloqueadas.'''",
	'spamregex-log-1' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 eliminar]) engadido por",
	'spamregex-log-2' => 'en $1',
	'spamregex-page-title-1' => 'Bloquear frase usando expresións regulares',
	'spamregex-unblock-success' => 'Desbloqueo con éxito',
	'spamregex-unblock-message' => "A frase '''$1''' foi desbloqueada para a edición.",
	'spamregex-page-title-2' => 'Bloquear frases usando expresións regulares para que non poidan ser guardadas',
	'spamregex-block-success' => 'Bloqueo con éxito',
	'spamregex-block-message' => "A frase '''$1''' foi bloqueada.",
	'spamregex-warning-1' => 'Dar unha frase para bloquear.',
	'spamregex-error-1' => 'Expresión regular non válida.',
	'spamregex-warning-2' => 'Por favor, comprobe, polo menos, un modo de bloqueo.',
	'spamregex-already-blocked' => '"$1" xa está bloqueado',
	'spamregex-phrase-block' => 'Frase para bloquear:',
	'spamregex-phrase-block-text' => 'bloquear unha frase no texto da páxina',
	'spamregex-phrase-block-summary' => 'bloquear frase no resumo',
	'spamregex-block-submit' => 'Bloquear&nbsp;esta&nbsp;frase',
	'spamregex-text' => '(Texto)',
	'spamregex-summary-log' => '(Resumo)',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'spamregex' => 'ביטוי רגולרי לספאם',
	'spamregex-desc' => '[[Special:SpamRegex|סינון]] מונחים בלתי רצויים בדפים שנערכים, בהתבסס על ביטויים רגולריים',
	'spamregex-error-unblocking' => 'שגיאה בביטול חסימת "$1". ייתכן שלא קיימת תבנית כזו.',
	'spamregex-summary' => 'הטקסט נמצא בתקציר הדף.',
	'spamregex-intro' => 'השתמשו בטופס זה כדי לחסום באופן יעיל את אפשרות השמירה של ביטויים מסוימים לטקסט הדף.
אם הטקסט מכיל את הביטוי הנתון, השינוי לא יישמר, ובמקום זאת יופיע הסבר למשתמש שניסה לשמור את הדף.
שימו לב, מומלץ להימנע מביטויים קצרים מדי או נפוצים מדי.',
	'spamregex-page-title' => 'חסימת ביטויי ספאם בלתי רצויים',
	'spamregex-currently-blocked' => "'''מונחים הנחסמים נכון לעכשיו:'''",
	'spamregex-move' => 'הסיבה שכתבתם מכילה מונח שנחסם.',
	'spamregex-no-currently-blocked' => "'''אין מונחים חסומים.'''",
	'spamregex-log-1' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 הסרה]) נוספה על ידי",
	'spamregex-log-2' => 'ב־$1',
	'spamregex-page-title-1' => 'חסימת ביטוי באמצעות ביטויים רגולריים',
	'spamregex-unblock-success' => 'הסרת החסימה הושלמה בהצלחה',
	'spamregex-unblock-message' => "הוסרה חסימת המונח '''$1''' מעריכה.",
	'spamregex-page-title-2' => 'חסימת מונחים משמירה באמצעות שימוש בביטויים רגולריים',
	'spamregex-block-success' => 'החסימה הושלמה בהצלחה',
	'spamregex-block-message' => "המונח '''$1''' נחסם.",
	'spamregex-warning-1' => 'הקלידו מונח לחסימה.',
	'spamregex-error-1' => 'הביטוי הרגולרי אינו תקין.',
	'spamregex-warning-2' => 'אנא סמנו לפחות מצב חסימה אחד.',
	'spamregex-already-blocked' => '"$1" כבר נחסם',
	'spamregex-phrase-block' => 'מונח לחסימה:',
	'spamregex-phrase-block-text' => 'חסימת המונח בטקסט שבדף',
	'spamregex-phrase-block-summary' => 'חסימת המונח בתקציר',
	'spamregex-block-submit' => 'חסימת&nbsp;מונח&nbsp;זה',
	'spamregex-text' => '(טקסט)',
	'spamregex-summary-log' => '(תקציר)',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'spamregex-already-blocked' => '"$1" को पहलेसे ब्लॉक किया हुआ हैं',
	'spamregex-summary-log' => '(संक्षिप्त ज़ानकारी)',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'spamregex-summary-log' => '(Kabilogan)',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 */
$messages['hr'] = array(
	'spamregex-summary-log' => '(Sažetak)',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'spamregex' => 'SpamRegex',
	'spamregex-desc' => 'Njewitane frazy na wobdźěłanych stronach z pomocu regularnych wurazow [[Special:SpamRegex|wufiltrować]]',
	'spamregex-error-unblocking' => 'Zmylk při wotblokowanju "$1". Snano tajki muster njeeksistuje.',
	'spamregex-summary' => 'Tekst je so w zjeću strony namakał.',
	'spamregex-intro' => 'Wužij tutón formular, zo by wurazy skutkownje přećiwo składowanju w teksće strony blokował. Jel tekst daty wuraz wobsahuje, změna njeby so składowała a wujasnjenje so wužiwarjej, kiž je spytał stronu składować, pokaza. Jewi so warnowanje, zo wurazy njesmědźa překrótke abo přepowšitkowne być.',
	'spamregex-page-title' => 'Spam Regex Blokowanje njepožadanych wurazow',
	'spamregex-currently-blocked' => "'''Tuchwilu zablokowane frazy:'''",
	'spamregex-move' => 'Přičina, kotruž sy podał, je zablokowanu frazu wobsahowała.',
	'spamregex-no-currently-blocked' => "'''Zablokowane frazy njejsu.'''",
	'spamregex-log-1' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 wotstronić]) přidaty wot",
	'spamregex-log-2' => 'na $1',
	'spamregex-page-title-1' => 'Frazu, kotraž regularne wurazy wužiwa, blokować',
	'spamregex-unblock-success' => 'Wotblokowanje wuspěšne',
	'spamregex-unblock-message' => "Fraza '''$1''' bu za wobdźěłowanje dopušćena.",
	'spamregex-page-title-2' => 'Frazy z pomocu regularnych wurazow za składowanje blokować',
	'spamregex-block-success' => 'Blokowanje wuspěšne',
	'spamregex-block-message' => "Fraza '''$1''' bu zablokowana.",
	'spamregex-warning-1' => 'Podaj frazu za blokowanje.',
	'spamregex-error-1' => 'Njepłaćiwy regularny wuraz.',
	'spamregex-warning-2' => 'Prošu přepruwuj znajmjeńša jedyn blokowanski modus.',
	'spamregex-already-blocked' => '"$1" je hižo zablokowany',
	'spamregex-phrase-block' => 'Fraza, kotraž ma so blokować:',
	'spamregex-phrase-block-text' => 'frazu w teksće stronya blokować',
	'spamregex-phrase-block-summary' => 'frazu w zjeću blokować',
	'spamregex-block-submit' => 'Tutu&nbsp;frazu&nbsp;blokować',
	'spamregex-text' => '(Tekst)',
	'spamregex-summary-log' => '(Zjeće)',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'spamregex' => 'Regex antispam',
	'spamregex-desc' => '[[Special:SpamRegex|Filtrar]] phrases non desirabile in paginas modificate, a base de expressiones regular',
	'spamregex-error-unblocking' => 'Error durante le disblocada de "$1". Probabilemente non existe tal patrono.',
	'spamregex-summary' => 'Le texto esseva trovate in le summario del pagina.',
	'spamregex-intro' => 'Usa iste formulario pro effectivemente blocar certe expressiones de figurar in le texto de un pagina.
Si le texto de un modification contine un expression date hic, le modification non es immagazinate, e un explication se monstra al usator qui voleva publicar le pagina.
Caution avisate: le expressiones non debe esser troppo curte o troppo commun.',
	'spamregex-page-title' => 'Blocada de expressiones non desirate per medio de regex antispam',
	'spamregex-currently-blocked' => "'''Phrases actualmente blocate:'''",
	'spamregex-move' => 'Le motivo que tu entrava contineva un phrase blocate.',
	'spamregex-no-currently-blocked' => "'''Il non ha phrases blocate.'''",
	'spamregex-log-1' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 retirar]) addite per",
	'spamregex-log-2' => '  le $1',
	'spamregex-page-title-1' => 'Blocar un phrase per medio de expressiones regular',
	'spamregex-unblock-success' => 'Disblocada succedite',
	'spamregex-unblock-message' => "Le phrase '''$1''' ha essite disblocate de figurar in modificationes.",
	'spamregex-page-title-2' => 'Blocar phrases de esser publicate per medio de expressiones regular',
	'spamregex-block-success' => 'Blocada succedite',
	'spamregex-block-message' => "Le phrase '''$1''' ha essite blocate.",
	'spamregex-warning-1' => 'Da un phrase a blocar.',
	'spamregex-error-1' => 'Expression regular invalide.',
	'spamregex-warning-2' => 'Per favor selige al minus un modo de blocada.',
	'spamregex-already-blocked' => '"$1" es ja blocate',
	'spamregex-phrase-block' => 'Phrase a blocar:',
	'spamregex-phrase-block-text' => 'blocar phrase in texto de pagina',
	'spamregex-phrase-block-summary' => 'blocar phrase in summario',
	'spamregex-block-submit' => 'Blocar&nbsp;iste&nbsp;phrase',
	'spamregex-text' => '(Texto)',
	'spamregex-summary-log' => '(Summario)',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'spamregex-already-blocked' => '„$1“ er nú þegar í banni',
);

/** Japanese (日本語)
 * @author Fryed-peach
 */
$messages['ja'] = array(
	'spamregex-already-blocked' => '"$1" は既にブロックされています',
	'spamregex-summary-log' => '(要約)',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'spamregex' => 'SpamRegex',
	'spamregex-block-message' => "Ukara '''$1''' wis diblokir.",
	'spamregex-warning-1' => 'Wènèhana ukara sing kudu diblokir.',
	'spamregex-already-blocked' => '"$1" wis diblokir',
	'spamregex-phrase-block' => 'Ukara sing diblokir:',
	'spamregex-text' => '(Tèks)',
	'spamregex-summary-log' => '(Ringkesan)',
);

/** Kazakh (Cyrillic) (Қазақша (Cyrillic))
 * @author GaiJin
 */
$messages['kk-cyrl'] = array(
	'spamregex-summary-log' => '(Түйіндемесі)',
);

/** Kazakh (Latin) (Қазақша (Latin))
 * @author GaiJin
 */
$messages['kk-latn'] = array(
	'spamregex-summary-log' => '(Tüýindemesi)',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 */
$messages['km'] = array(
	'spamregex-summary' => 'អក្សរ​ត្រូវ​បាន​រកឃើញ​នៅក្នុង​សេចក្ដីសង្ខេប​នៃ​ទំព័រ​។',
	'spamregex-block-success' => 'ហាមឃាត់ដោយជោគជ័យ',
	'spamregex-block-message' => "ឃ្លា '''$1''' ត្រូវ​បាន​ទប់ស្កាត់​។",
	'spamregex-warning-1' => 'ផ្ដល់​ឃ្លា​មួយ​ដើម្បី​ទប់ស្កាត់​។',
	'spamregex-warning-2' => 'សូម​ពិនិត្យ​របៀប​ទប់ស្កាត់​យ៉ាងហោច​មួយ​។',
	'spamregex-already-blocked' => '"$1" ត្រូវ​បាន​ទប់ស្កាត់​ហើយ',
	'spamregex-phrase-block' => 'ឃ្លា​​ត្រូវ​ទប់ស្កាត់​៖',
	'spamregex-phrase-block-text' => 'ទប់ស្កាត់​ឃ្លា​នៅ​ក្នុង​អត្ថបទ​ទំព័រ',
	'spamregex-phrase-block-summary' => 'ទប់ស្កាត់​ឃ្លា​ជា​សង្ខេប',
	'spamregex-block-submit' => 'ទប់ស្កាត់&nbsp;ឃ្លា&nbsp;នេះ',
	'spamregex-text' => '(ឃ្លា)',
	'spamregex-summary-log' => '(សេចក្តីសង្ខេប)',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'spamregex' => 'Spam regex',
	'spamregex-desc' => 'Övver <i lang="en">regular expressions</i>, [[Special:SpamRegex|sök esu en Texstöcke eruß]] uß fresch jeänderte Sigge, di mer doh nit han welle.',
	'spamregex-error-unblocking' => 'Ene Fähler es opjetrodde: Mer kunnte „$1“ nit frei jevve. Wascheinlesch jit et esu e Dinge nit.',
	'spamregex-summary' => 'Dä Tex wood en dä Zosammefaßung för di Sigg jevonge.',
	'spamregex-intro' => "Övver dat Fommulaa hee kanns De Textstöcke un <i lang=\"en\">regular expressions</i>
sperre, dat se nit em Tex fun Sigge enjedrare wäde künne.
Wann esu jet en ener Sigg steiht, die eine avspeichere well, dann jeiht
dat nit, un dä kritt ene Fähler jemeldt.
<br />
'''Opjepaß:''' Maat Ühr jesperrte Ußdröck nit zo koot un nit zo jewöönlesch!",
	'spamregex-page-title' => 'Spam regex — Texshtöck sperre, die mer nit avspeichere wolle.',
	'spamregex-currently-blocked' => "'''De aktoäll jesperrte Texstöcke:'''",
	'spamregex-move' => 'Wat De unger „{{int:Summary}}“ enjejovve häß, dat jeiht esu nit,
do es e Stöck Tex dren, dä jesperrt es.',
	'spamregex-no-currently-blocked' => "'''Mer han_er kei jesperrt_Texstöck.'''",
	'spamregex-log-1' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 fott domet!]) — dobei jedonn vum",
	'spamregex-log-2' => '  op $1',
	'spamregex-page-title-1' => 'Als en <i lang="en">regular expression</i> sperre',
	'spamregex-unblock-success' => 'Frei jejovve',
	'spamregex-unblock-message' => 'Dat Textstöck „$1“ es frei jejovve.',
	'spamregex-page-title-2' => 'Texshtöck med <i lang="en">regular expressions</i> jäje et Avspeichere sperre',
	'spamregex-block-success' => 'Jesperrt',
	'spamregex-block-message' => "Dat Texstöck  „'''$1'''“ es jesperrt.",
	'spamregex-warning-1' => 'Wat sull dann nu jesperrt wäde? Jif do jet en!',
	'spamregex-error-1' => 'Dat es en kappodde <i lang="en">regular expression</i>.',
	'spamregex-warning-2' => 'Winnischßtens ein Aat ze Sperre bruch e Höksche!',
	'spamregex-already-blocked' => '„$1“ es ald jesperrt',
	'spamregex-phrase-block' => 'Dat Texstöck för zom Sperre',
	'spamregex-phrase-block-text' => 'esu e Texstöck em Tex fun en de Sigge sperre',
	'spamregex-phrase-block-summary' => 'esu e Texstöck en de Zosammefassung sperre',
	'spamregex-block-submit' => 'Dat&nbsp;Texstöck&nbsp;sperre',
	'spamregex-text' => '(Tex)',
	'spamregex-summary-log' => '(Zosammefaßung)',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'spamregex-error-unblocking' => 'Feeler bäim ophiewe vun der Spär: "$1". Et gëtt wahrscheinlech keen esou e Muster.',
	'spamregex-summary' => 'Dësen Text gouf am Resumé vun der Säit fonnt',
	'spamregex-currently-blocked' => "'''Sätz déi elo gespaart sinn:'''",
	'spamregex-no-currently-blocked' => "'''Et gëtt keng gespaarte Sätz.'''",
	'spamregex-log-1' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 ewech huelen]) derbäigest vum",
	'spamregex-log-2' => 'den $1',
	'spamregex-unblock-success' => 'Spär ass opgehuewen',
	'spamregex-block-success' => 'Gespaart',
	'spamregex-block-message' => "De Saatz '''$1''' gouf gespaart.",
	'spamregex-already-blocked' => '"$1" ass scho gespaart',
	'spamregex-phrase-block' => 'Saatz fir ze spären',
	'spamregex-phrase-block-summary' => 'Saatz am Resumé spären',
	'spamregex-block-submit' => 'Spär&nbsp;dëse&nbsp;Saz',
	'spamregex-text' => '(Text)',
	'spamregex-summary-log' => '(Resumé)',
);

/** Moksha (Мокшень)
 * @author Khazar II
 */
$messages['mdf'] = array(
	'spamregex-already-blocked' => '"$1" сёлкфоль ни',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'spamregex-summary-log' => '(Чылаже)',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'spamregex-log-2' => '$1 ന്‌',
	'spamregex-unblock-success' => 'സ്വതന്ത്രമാക്കല്‍ വിജയിച്ചിരിക്കുന്നു',
	'spamregex-block-success' => 'തടയല്‍ വിജയിച്ചിരിക്കുന്നു',
	'spamregex-already-blocked' => '"$1" ഇതിനകം തന്നെ തടയപ്പെട്ടിരിക്കുന്നു.',
	'spamregex-summary-log' => '(ചുരുക്കം)',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'spamregex' => 'स्पॅमरेजएक्स',
	'spamregex-desc' => 'संपादित पानांमधील नको असलेल्या नोंदी रेग्युलर एक्स्प्रेशन आधारित प्रणाली वापरून [[Special:SpamRegex|वेगळ्या करा]].',
	'spamregex-summary' => 'या पानाच्या सारांशामध्ये हा मजकूर सापडला.',
	'spamregex-intro' => 'एखाद्या पानाच्या मजकूरात काही फ्रेजेस जतन होण्यापासून पूर्णपणे थांबविण्यासाठी ह्या अर्जाचा वापर करा.
जर मजकूरा मध्ये दिलेले एक्स्प्रेशन आले तर बदल जतन होणार नाहीत, व जतन करु इच्छिणार्‍या सदस्याला कारण दर्शविले जाईल.
काळजी घ्या, एक्स्प्रेशन्स खूप छोटे किंवा नेहमीच्या वापरातले नकोत.',
	'spamregex-page-title' => 'स्पॅम रेजएक्स नको असलेल्या एक्स्प्रेशन्स ब्लॉक',
	'spamregex-currently-blocked' => "'''सध्या ब्लॉक केलेले फ्रेजेस:'''",
	'spamregex-no-currently-blocked' => "'''सध्या एकही ब्लॉक केलेला फ्रेज नाही.'''",
	'spamregex-log-1' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 काढा]) (ने) वाढविलेला",
	'spamregex-log-2' => '$1वर',
	'spamregex-page-title-1' => 'रेग्युलर एक्स्प्रेशन्स वापरून फ्रेज ब्लॉक करा',
	'spamregex-unblock-success' => 'अनब्लॉक यशस्वी',
	'spamregex-unblock-message' => "फ्रेज '''$1''' ला संपादित करण्यापासून अनब्लॉक केलेले आहे.",
	'spamregex-page-title-2' => 'रेग्युलर एक्स्प्रेशन्सचा वापर करून फ्रेजेस जतन होण्यापासून ब्लॉक करा',
	'spamregex-block-success' => 'ब्लॉक यशस्वी',
	'spamregex-block-message' => "फ्रेज '''$1''' ला ब्लॉक केलेले आहे.",
	'spamregex-warning-1' => 'ब्लॉक करण्यासाठी एक फ्रेज द्या.',
	'spamregex-error-1' => 'चुकीची रेग्युलर एक्स्प्रेशन्स.',
	'spamregex-warning-2' => 'कृपया कमीतकमी एक ब्लॉकिंग मोड तपासा.',
	'spamregex-already-blocked' => '"$1" ला अगोदरच ब्लॉक केलेले आहे',
	'spamregex-phrase-block' => 'ब्लॉक करण्यासाठी फ्रेज:',
	'spamregex-phrase-block-text' => 'पानाच्या मजकूरातून फ्रेज ब्लॉक करा',
	'spamregex-phrase-block-summary' => 'सारांशातून फ्रेज ब्लॉक करा',
	'spamregex-block-submit' => 'ही&nbsp;फ्रेज&nbsp;ब्लॉक&nbsp;करा',
	'spamregex-text' => '(मजकूर)',
	'spamregex-summary-log' => 'आढावा',
);

/** Maltese (Malti)
 * @author Roderick Mallia
 */
$messages['mt'] = array(
	'spamregex-already-blocked' => '"$1" diġà bblokkjat',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'spamregex-log-2' => ' īpan $1',
	'spamregex-summary-log' => '(Tlahcuilōltōn)',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'spamregex-log-2' => 'op $1',
	'spamregex-text' => '(Text)',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'spamregex' => 'SpamRegex',
	'spamregex-desc' => "Ongewilde zinnen [[Special:SpamRegex|uitfilteren]] in bewerkte pagina's, gebaseerd op reguliere expressies",
	'spamregex-error-unblocking' => 'Fout bij het opheffen van de blokkade van "$1". Wellicht bestaat het patroon niet.',
	'spamregex-summary' => 'De tekst is gevonden in de paginasamenvatting.',
	'spamregex-intro' => 'Gebruik dit formulier om doeltreffend te voorkomen dat uitdrukkingen worden opgeslagen in een paginatekst.
Als de tekst de gegeven uitdrukkingen bevat, dan wordt de wijziging niet opgeslagen en wordt een uitleg aan de gebruiker weergegeven die de pagina probeerde op te slaan.
Zorg dat de uitdrukkingen niet te kort of veelvoorkomend zijn.',
	'spamregex-page-title' => 'Blokkeren van uitdrukkingen met regex',
	'spamregex-currently-blocked' => "'''Huidig geblokkeerde zinnen:'''",
	'spamregex-move' => 'De opgegeven reden bevat een tekstdeel dat op de zwarte lijst staat.',
	'spamregex-no-currently-blocked' => "'''Er zijn geen geblokkeerde zinnen.'''",
	'spamregex-log-1' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 verwijderen]) toegevoegd door",
	'spamregex-log-2' => ' op $1',
	'spamregex-page-title-1' => 'Zinnen blokkeren met reguliere uitdrukkingen',
	'spamregex-unblock-success' => 'Deblokkade gelukt',
	'spamregex-unblock-message' => "Zin '''$1''' is gedeblokkeerd van bewerkingen.",
	'spamregex-page-title-2' => 'Zinnen blokkeren van opslaan met reguliere uitdrukkingen',
	'spamregex-block-success' => 'Blokkade gelukt.',
	'spamregex-block-message' => "Zin '''$1''' is geblokkeerd.",
	'spamregex-warning-1' => 'Geef een zin om te blokkeren.',
	'spamregex-error-1' => 'Ongeldige reguliere uitdrukking.',
	'spamregex-warning-2' => 'Gelieve tenminste één blokkeermogelijkheid aan te klikken.',
	'spamregex-already-blocked' => '"$1" is al geblokkeerd',
	'spamregex-phrase-block' => 'Zin om te blokkeren:',
	'spamregex-phrase-block-text' => 'zin blokkeren in paginatekst',
	'spamregex-phrase-block-summary' => 'zin blokkeren in samenvatting',
	'spamregex-block-submit' => 'Deze&nbsp;zin&nbsp;blokkeren',
	'spamregex-text' => '(Tekst)',
	'spamregex-summary-log' => '(Samenvatting)',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Frokor
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'spamregex' => 'SpamRegex',
	'spamregex-desc' => '[[Special:SpamRegex|Filtrer ut]] uønska fraser i endra sider, basert på regulære uttrykk',
	'spamregex-error-unblocking' => 'Feil ved avblokkering av «$1». Eit slikt mønster finst nok ikkje.',
	'spamregex-summary' => 'Teksten vart funne i samandraget til sida.',
	'spamregex-intro' => 'Bruk dette skjemaet for å effektivt blokkere uttrykk fra å bli lagra på sidene. Om teksten inneheld visse uttrykk, vil endringa ikke bli lagra, og ei forklaring vil visast til brukeren som prøvde å lagre sida. Ver obs på at uttrykk ikkje bør vere for korte eller for vanlege.',
	'spamregex-page-title' => 'Blokkering av uønska uttrykk med regulære uttrykk',
	'spamregex-currently-blocked' => "'''Noverande blokkerte uttrykk:'''",
	'spamregex-move' => 'Årsaka du skreiv inn inneheldt eit blokkert uttrykk.',
	'spamregex-no-currently-blocked' => "'''Det er ingen blokkerte uttrykk.'''",
	'spamregex-log-1' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 fjern]) lagt til av",
	'spamregex-log-2' => 'på $1',
	'spamregex-page-title-1' => 'Blokker uttrykk ved hjelp av regulære uttrykk',
	'spamregex-unblock-success' => 'Avblokkering utført',
	'spamregex-unblock-message' => "Uttrykket '''$1''' er ikkje lenger blokkert.",
	'spamregex-page-title-2' => 'Blokker uttrykk frå å kunne lagrast ved hjelp av regulære uttrykk.',
	'spamregex-block-success' => 'Blokkering utført',
	'spamregex-block-message' => "Uttrykket '''$1''' er blokkert.",
	'spamregex-warning-1' => 'Oppgje eit uttrykk som skal blokkerast.',
	'spamregex-error-1' => 'Ugyldig regulært uttrykk.',
	'spamregex-warning-2' => 'Du må velje minst ein blokkeringsmodus.',
	'spamregex-already-blocked' => '«$1» er alt blokkert',
	'spamregex-phrase-block' => 'Uttrykk å blokkere:',
	'spamregex-phrase-block-text' => 'blokker uttrykk i sidetekst',
	'spamregex-phrase-block-summary' => 'blokker uttrykk i samandrag',
	'spamregex-block-submit' => 'Blokker&nbsp;dette&nbsp;uttrykket',
	'spamregex-text' => '(Tekst)',
	'spamregex-summary-log' => '(Samandrag)',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'spamregex' => 'SpamRegex',
	'spamregex-desc' => '[[Special:SpamRegex|Filtrer ut]] uønskede fraser i redigerte sider, basert på regulære uttrykk',
	'spamregex-error-unblocking' => 'Feil ved avblokkering av «$1». Det er nok ikke noe slikt mønster.',
	'spamregex-summary' => 'Teksten ble funnet i sidens sammendrag.',
	'spamregex-intro' => 'Bruk dette skjemaet for å effektivt blokkere uttrykk fra å bli lagret på sidene. Om teksten inneholder gitt uttrykk, vil endringen ikke bli lagret, og en forklaring vil vises til brukeren som prøvde å lagre siden. Vær obs på at uttrykk ikke bør være for korte eller for vanlige.',
	'spamregex-page-title' => 'Blokkering av uønskede uttrykk med regulære uttrykk',
	'spamregex-currently-blocked' => "'''Nåværende blokkerte fraser:'''",
	'spamregex-move' => 'Årsaken du skrev inn inneholdt en blokkert frase.',
	'spamregex-no-currently-blocked' => "'''Det er ingen blokkerte fraser.'''",
	'spamregex-log-1' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 fjern]) lagt til av",
	'spamregex-log-2' => ' $1',
	'spamregex-page-title-1' => 'Blokker frase ved hjelp av regulære uttrykk',
	'spamregex-unblock-success' => 'Avblokkering lyktes',
	'spamregex-unblock-message' => "Frasen '''$1''' er ikke lenger blokkert.",
	'spamregex-page-title-2' => 'Blokker fraser fra å kunne lagres ved hjelp av regulære uttrykk.',
	'spamregex-block-success' => 'Blokkering lyktes',
	'spamregex-block-message' => "Frasen '''$1''' er blokkert.",
	'spamregex-warning-1' => 'Oppgi en frase å blokkere.',
	'spamregex-error-1' => 'Ugyldig regulært uttrykk.',
	'spamregex-warning-2' => 'Du må velge minst en blokkeringsmodus.',
	'spamregex-already-blocked' => '«$1» er allerede blokkert',
	'spamregex-phrase-block' => 'Frase å blokkere:',
	'spamregex-phrase-block-text' => 'blokker frase i sidetekst',
	'spamregex-phrase-block-summary' => 'blokker frase i sammendrag',
	'spamregex-block-submit' => 'Blokker&nbsp;denne&nbsp;frasen',
	'spamregex-text' => '(Tekst)',
	'spamregex-summary-log' => '(Sammendrag)',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'spamregex' => 'Expressions regularas de Spams',
	'spamregex-desc' => "[[Special:SpamRegex|Filtre]], dins las paginas, las frasas o mots indesirables, basat sus d'expressions regularas",
	'spamregex-error-unblocking' => 'Error de desblocatge de « $1 ». I a probablament pas cap de modèl.',
	'spamregex-summary' => 'Lo tèxt en question es estat detectat dins lo comentari de la pagina.',
	'spamregex-intro' => "Utilizatz aqueste formulari per blocar efièchament las expressions que pòdon èsser salvadas dins una pagina tèxt. Se lo tèxt conten las expressions definidas, los cambiaments poiràn pas èsser salvats e un motiu explicatiu serà afichat a l’utilizaire qu'a volgut salvar la pagina. Es important de prendre en consideracion que las expressions deuràn pas èsser ni tròp longas ni tròp correntas.",
	'spamregex-page-title' => 'Blocatge de las expressions regularas de spams',
	'spamregex-currently-blocked' => "'''Frasas actualament blocadas :'''",
	'spamregex-move' => "Lo motiu qu'avètz inscrich conteniá una frasa blocada.",
	'spamregex-no-currently-blocked' => "'''I a pas cap de frasa blocada.'''",
	'spamregex-log-1' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 suprimir]) apondut per",
	'spamregex-log-2' => 'lo $1',
	'spamregex-page-title-1' => "Blocatge d’una frasa utilizant d'expressions regularas",
	'spamregex-unblock-success' => 'Lo desblocatge a capitat',
	'spamregex-unblock-message' => "La frasa '''$1''' es estada desblocada a l’edicion.",
	'spamregex-page-title-2' => "Blocatge de las frasas en utilizant d'expression regularas",
	'spamregex-block-success' => 'Lo blocatge a capitat',
	'spamregex-block-message' => "La frasa '''$1''' a estada blocada.",
	'spamregex-warning-1' => 'Indicatz una frasa de blocar.',
	'spamregex-error-1' => 'Expression regulara invalida.',
	'spamregex-warning-2' => 'Causissètz almens un mòde de blocatge.',
	'spamregex-already-blocked' => '« $1 » ja es blocat',
	'spamregex-phrase-block' => 'Frasa de blocar :',
	'spamregex-phrase-block-text' => 'blocar la frasa dins lo tèxt de l’article',
	'spamregex-phrase-block-summary' => 'blocar la frasa dins lo comentari',
	'spamregex-block-submit' => 'Blocar&nbsp;aquesta&nbsp;frasa',
	'spamregex-text' => '(Tèxt)',
	'spamregex-summary-log' => '(Comentari)',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Leinad
 * @author Maikking
 * @author Sp5uhe
 * @author Wpedzich
 */
$messages['pl'] = array(
	'spamregex' => 'Spam regex',
	'spamregex-desc' => '[[Special:SpamRegex|Filtrowanie]] niepożądanych zwrotów na edytowanych stronach z użyciem wyrażeń regularnych',
	'spamregex-currently-blocked' => "'''Aktualnie zablokowane wyrażenia:'''",
	'spamregex-no-currently-blocked' => "'''Nie ma zablokowanych wyrażeń.'''",
	'spamregex-page-title-1' => 'Blokuj frazę za pomocą wyrażenia regularnego',
	'spamregex-unblock-success' => 'Odblokowano',
	'spamregex-unblock-message' => "Fraza '''$1''' została odblokowana.",
	'spamregex-block-success' => 'Zablokowano',
	'spamregex-block-message' => "Wyrażenie '''$1''' zostało zablokowane.",
	'spamregex-warning-1' => 'Podaj wyrażenie do zablokowania.',
	'spamregex-error-1' => 'Nieprawidłowe wyrażenie regularne.',
	'spamregex-already-blocked' => '„$1” jest już zablokowany',
	'spamregex-phrase-block' => 'Wyrażenie do zablokowania:',
	'spamregex-block-submit' => 'Blokuj&nbsp;to&nbsp;wyrażenie',
	'spamregex-text' => '(Tekst)',
	'spamregex-summary-log' => '(Podsumowanie)',
);

/** Portuguese (Português)
 * @author Lijealso
 * @author Malafaya
 */
$messages['pt'] = array(
	'spamregex-unblock-success' => 'Desbloqueio com sucesso',
	'spamregex-block-success' => 'Bloqueio bem sucedido',
	'spamregex-error-1' => 'Expressão regular inválida.',
	'spamregex-already-blocked' => '"$1" já está bloqueado',
	'spamregex-phrase-block' => 'Frase a bloquear:',
	'spamregex-text' => '(Texto)',
	'spamregex-summary-log' => '(Sumário)',
);

/** Tarifit (Tarifit)
 * @author Jose77
 */
$messages['rif'] = array(
	'spamregex-summary-log' => '(Asgbr)',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'spamregex-already-blocked' => '"$1" este deja blocat',
	'spamregex-text' => '(Text)',
	'spamregex-summary-log' => '(Rezumat)',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'spamregex-text' => '(Teste)',
	'spamregex-summary-log' => '(Riepileghe)',
);

/** Russian (Русский)
 * @author Rubin
 */
$messages['ru'] = array(
	'spamregex-text' => '(Текст)',
);

/** Sassaresu (Sassaresu)
 * @author Felis
 */
$messages['sdc'] = array(
	'spamregex-already-blocked' => '"$1" è già broccaddu',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'spamregex' => 'SpamRegex',
	'spamregex-desc' => '[[Special:SpamRegex|Filtrovanie]] neželaných výrazov v upravovaných stránkach na základe regulárnych výrazov',
	'spamregex-error-unblocking' => 'Chyba pri odblokovaní „$1”. Taký vzor pravdepodobne neexistuje.',
	'spamregex-summary' => 'Text bol nájdený v zhrnutí úprav stránky.',
	'spamregex-intro' => 'Tento formulár slúži na efektívne zamedzenie ukladania nežiaduceho textu stránok. Ak text obsahuje uvedený výraz, zmeny nebude možné uložiť a používateľovi sa zobrazí upozornenie. Odporúča sa opatrnosť - výrazy by nemali byť príliš krátke ani bežne sa vyskytujúce.',
	'spamregex-page-title' => 'Blokovanie nežiaduceho spamu pomocou regulárnych výrazov',
	'spamregex-currently-blocked' => "'''Momentálne zablokované frázy.'''",
	'spamregex-move' => 'Dôvod, ktorý ste zadali, obsahoval zablokovaný výraz.',
	'spamregex-no-currently-blocked' => "'''Nie sú žiadne zablokované frázy.'''",
	'spamregex-log-1' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 remove]) pridal",
	'spamregex-log-2' => '$1',
	'spamregex-page-title-1' => 'Zablokovať frázu pomocou regulárnych výrazov',
	'spamregex-unblock-success' => 'Odblokovanie úspešné',
	'spamregex-unblock-message' => 'Bol zrušený zákaz uložiť frázu „$1“.',
	'spamregex-page-title-2' => 'Blokovať ukladanie fráz pomocou regulárnych výrazov',
	'spamregex-block-success' => 'Blokovanie úspešné',
	'spamregex-block-message' => "Fráza '''$1''' bola zablokovaná.",
	'spamregex-warning-1' => 'Zadajte frázu, ktorú chcete blokovať.',
	'spamregex-error-1' => 'Neplatný regulárny výraz.',
	'spamregex-warning-2' => 'Prosím, označte aspoň jeden režim blokovania.',
	'spamregex-already-blocked' => '„$1“ je už blokované',
	'spamregex-phrase-block' => 'Blokovať frázu:',
	'spamregex-phrase-block-text' => 'blokovať frázu v texte stránky',
	'spamregex-phrase-block-summary' => 'blokovať frázu v zhrnutí úprav',
	'spamregex-block-submit' => 'Blokovať&nbsp;túto&nbsp;frázu',
	'spamregex-text' => '(v texte)',
	'spamregex-summary-log' => '(v zhrnutí)',
);

/** Southern Sami (Åarjelsaemien)
 * @author M.M.S.
 */
$messages['sma'] = array(
	'spamregex-text' => '(Tjaalege)',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'spamregex-already-blocked' => '"$1" geus dipeungpeuk',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author M.M.S.
 */
$messages['sv'] = array(
	'spamregex' => 'SpamRegex',
	'spamregex-desc' => '[[Special:SpamRegex|Filtrera ut]] oönskade fraser i redigerade sidor, baserade på reguljära uttryck',
	'spamregex-error-unblocking' => 'Fel vid avblockering av "$1". Förmodligen finns det inget sådand mönster.',
	'spamregex-summary' => 'Texten hittades i sidans sammanfattning.',
	'spamregex-intro' => 'Använd det här formuläret för att effektivt blockera uttryck från att sparas på sidorna.
Om texten innehåller det angivna uttrycket, kommer ändringen inte att sparas, och en förklaring kommer visas för användaren som försökte att spara sidan.
Var observant på att uttryck inte bör vara för korta eller för vanliga.',
	'spamregex-page-title' => 'Blockering av oönskade uttryck med reguljära uttryck',
	'spamregex-currently-blocked' => "'''Nuvarande blockerade fraser:'''",
	'spamregex-move' => 'Anledningen du skrev in innehöll en blockerad fras.',
	'spamregex-no-currently-blocked' => "'''Det finns inga blockerade fraser.'''",
	'spamregex-log-1' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 ta bort]) tillaggd av",
	'spamregex-log-2' => ' på $1',
	'spamregex-page-title-1' => 'Blockera fras med hjälp av reguljära uttryck',
	'spamregex-unblock-success' => 'Avblockering lyckades',
	'spamregex-unblock-message' => "Frasen '''$1''' är inte längre blockerad.",
	'spamregex-page-title-2' => 'Blockera fraser från att kunna sparas med hjälp av reguljära uttryck',
	'spamregex-block-success' => 'Blockering lyckades',
	'spamregex-block-message' => "Frasen '''$1''' har blockerats.",
	'spamregex-warning-1' => 'Ange en fras att blockera.',
	'spamregex-error-1' => 'Ogiltigt reguljärt uttryck.',
	'spamregex-warning-2' => 'Du måste välja minst en blockeringsmetod.',
	'spamregex-already-blocked' => '"$1" är redan blockerad',
	'spamregex-phrase-block' => 'Fras att blockera:',
	'spamregex-phrase-block-text' => 'blockera fras i sidtext',
	'spamregex-phrase-block-summary' => 'blockera fras i sammanfattning',
	'spamregex-block-submit' => 'Blockera&nbsp;den&nbsp;här&nbsp;frasen',
	'spamregex-text' => '(Text)',
	'spamregex-summary-log' => '(Sammanfattning)',
);

/** Tamil (தமிழ்)
 * @author Trengarasu
 */
$messages['ta'] = array(
	'spamregex-text' => '(உரை)',
	'spamregex-summary-log' => '(சுருக்கம்)',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'spamregex-summary' => 'పేజీ యొక్క సంగ్రహంలో ఆ పాఠ్యం కనబడింది.',
	'spamregex-currently-blocked' => "'''ప్రస్తుతం నిరోధంలో ఉన్న పదబంధాలు:'''",
	'spamregex-unblock-success' => 'నిరోధం ఎత్తివేత విజయవంతం',
	'spamregex-block-success' => 'నిరోధం విజయవంతమయ్యింది',
	'spamregex-error-1' => 'తప్పుడు రెగ్యులర్ ఎక్స్&zwnj;ప్రెషన్.',
	'spamregex-warning-2' => 'కనీసం ఒక్క నిరోధపు పద్ధతినైనా ఎంచుకోండి.',
	'spamregex-already-blocked' => '"$1"ని ఈసరికే నిరోధించాం',
	'spamregex-phrase-block' => 'నిరోధించాల్సిన పదబంధం:',
	'spamregex-phrase-block-text' => 'పదబంధాన్ని పేజీ పాఠ్యంలో ఉంటే నిరోధించు',
	'spamregex-phrase-block-summary' => 'పదబంధాన్ని సంగ్రహంలో ఉంటే నిరోధించు',
	'spamregex-block-submit' => 'ఈ&nbsp;పదబంధాన్ని&nbsp;నిరోధించండి',
	'spamregex-text' => '(పాఠ్యం)',
	'spamregex-summary-log' => '(సంగ్రహం)',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'spamregex-text' => '(Testu)',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'spamregex-error-1' => 'Ибораи оддии номӯътабар',
	'spamregex-already-blocked' => '"$1" аллакай баста шудааст',
	'spamregex-text' => '(Матн)',
	'spamregex-summary-log' => '(Хулоса)',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'spamregex' => "Pangkaraniwang pagsasaad na pang-\"manlulusob\" (''spam'')",
	'spamregex-desc' => '[[Special:SpamRegex|Salain]]g tinatanggal ang hindi ninanais na mga parirala sa loob ng mga pahinang binago, batay sa pangkaraniwang mga pagsasaad',
	'spamregex-error-unblocking' => 'Kamalian sa pagtatanggal ng hadlang sa "$1".  Marahil walang ganyang gayahan (parisan/padron).',
	'spamregex-summary' => 'Natagpuan ang teksto mula sa loob ng buod ng pahina.',
	'spamregex-intro' => 'Gamitin ang pormularyong ito upang ganap na mahadlangan ang mga pagsasaad mula sa pagsasagip patungo sa teksto ng isang pahina.
Kung naglalaman ang teksto ng ibinigay na pagsasaad, hindi masasagip ang pagbabago at ipapakita sa tagagamit na sumubok na magsagip ng pahina ang isang paliwanag.
Imimungkahi ang pagiingat, hindi dapat na napakaiksi o napakapangkaraniwan ang mga pagsasaad.',
	'spamregex-page-title' => "Paghahadlang sa hindi ninanais na mga pagpapahayag ng pangkaraniwang pagsasaad ng \"manlulusob\" (''spam'')",
	'spamregex-currently-blocked' => "'''Pangkasalukuyang hinahadlangang mga parirala:'''",
	'spamregex-move' => 'Naglalaman ng isang hinadlangang parirala ang ipinasok/inilagay mong dahilan.',
	'spamregex-no-currently-blocked' => "'''Walang hinahadlangang mga parirala.'''",
	'spamregex-log-1' => "* '''$1''' $2 ([{{SERVER}}$3&text=$4 tanggalin]) idinagdag ni",
	'spamregex-log-2' => '  sa $1',
	'spamregex-page-title-1' => 'Hinadlangang parirala na gumagamit ng pangkaraniwang mga pagsasaad',
	'spamregex-unblock-success' => 'Nagtagumpay ang pagtanggal ng paghadlang/pagharang',
	'spamregex-unblock-message' => "Tinanggal ang pagkakaharang mula sa pamamatnugot (paggawa ng pagbabago) ang pariralang '''$1'''.",
	'spamregex-page-title-2' => 'Hadlangan ang pagsasagip ng mga parirala na ginagamitan ng pangkaraniwang mga pagsasaad',
	'spamregex-block-success' => 'Nagtagumpay ang paghadlang',
	'spamregex-block-message' => "Hinadlangan na ang pariralang '''$1'''.",
	'spamregex-warning-1' => 'Magbigay ng isang pariralang hahadlangan.',
	'spamregex-error-1' => 'Hindi tanggap na pangkaraniwang pagsasaad.',
	'spamregex-warning-2' => 'Pakilagyan ng tsek ang kahit na isang modalidad ng paghahadlang.',
	'spamregex-already-blocked' => 'Nahadlangan na ang "$1"',
	'spamregex-phrase-block' => 'Pariralang hahadlangan:',
	'spamregex-phrase-block-text' => 'hadlangan ang pariralang nasa teksto ng pahina',
	'spamregex-phrase-block-summary' => 'hadlangan ang pariralang nasa buod',
	'spamregex-block-submit' => 'Hadlangan&nbsp;ang&nbsp;pariralang&nbsp;ito',
	'spamregex-text' => '(Teksto)',
	'spamregex-summary-log' => '(Buod)',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'spamregex-already-blocked' => '“$1” đã bị cấm rồi',
);

/** Volapük (Volapük)
 * @author Malafaya
 */
$messages['vo'] = array(
	'spamregex-text' => '(Vödem)',
);

