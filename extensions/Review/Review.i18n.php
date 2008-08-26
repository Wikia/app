<?php
/**
 * Internationalisation file for Review extension.
 *
 * @addtogroup Extensions
*/

$messages = array();

$messages['en'] = array(
	'review_sidebar_title' => "Review",
	'review-desc' => 'The resurrected [[Special:Review|validation]] feature.',
	'review_topics' => "# The following is the list of topics and ranges for the review extension.
# Each topic is defined by a line of five values, separated by ':' (all other lines are ignored).
# The order is: numerical key (>0), name, max range (>1; 2=yes/no), meaning of lowest value (e.g., 'bad'), meaning of highest value (e.g., 'good').
1:Quality:5:bad:good
2:Ready for 1.0:2:no:yes",
	'review_topic_page' => "Review topics",
	'review_sidebar_explanation' => "The leftmost checkbox always means 'no opinion'.",
	'review_save' => "Store review",
	'review_your_review' => "Your review of this page/revision:",
	'review_sidebar_you_have_other_reviews_for_this_article' => "You have already reviewed other versions of this page. Your other ratings will be merged into this one where you selected 'no opinion'.",
	'review_page_link' => "review statistics",
	'review_sidebar_final' => "For review data of this page view, see its $1",
	'review_for_page' => "Review for page \"$1\"",
	'review_for_user' => "Review for user \"$1\"",
	'review_error' => "Something's wrong!",
	'review_no_reviews_for_page' => "There are currently no reviews for \"$1\".",
	'review_total_statistics' => "Total",
	'review_statistics_left_corner' => "Revision",
	'review_version_link' => "Revision #$1",
	'review_statistic_cell' => "Average: $1 of $2<br />($4 users, $5 anons)",
	'review_version_statistic_cell' => "$1 of $2",
	'review_version_reviews_link' => "<small>(version reviews)</small>",
	'review_concerns_page' => "This review is about the page \"$1\".",
	'review_concerns_user' => "This is about reviews by user \"$1\".",
	'review_user_reviews' => "<small>(reviews by this user)</small>",
	'review_user_page_list' => "The user reviewed the following pages:",
	'review_user_details_link' => "(details)",
	'review_do_merge' => "Merge my reviews of other revisions of this page into this one",
	'review_has_been_stored' => "<span id='review_has_been_stored'>Your review has been stored!</span>",
	'revision_review_this_page_version_link' => "Review this version of the page.",
	'review_page_review' => "Review of page \"$1\"",
	'review_blocked' => "You're blocked, go away.",
	'review_wrong_namespace' => "Pages in this namespace cannot be reviewed!",
	'review_topic' => "Topic",
	'review_no_opinion' => "No opinion",
	'review_rating' => "Rating",
	'review_comment' => "Comment",
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 */
$messages['af'] = array(
	'review_total_statistics'  => 'Totaal',
	'review_user_details_link' => '(details)',
	'review_comment'           => 'Opmerking',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'review_user_details_link' => '(detalles)',
	'review_comment'           => 'Comentario',
);

/** Arabic (العربية)
 * @author Meno25
 * @author Siebrand
 */
$messages['ar'] = array(
	'review_sidebar_title'                                   => 'مراجعة',
	'review-desc'                                            => 'خاصية [[Special:Review|التحقق]] المشهورة.',
	'review_topics'                                          => "# التالي هو قائمة المواضيع والنطاقات لامتداد المراجعة.
# كل موضوع معرف بواسطة سطر من خمس قيم، مفصولة بواسطة ':' (كل السطور الأخرى سيتم تجاهلها).
# الترتيب هو: مفتاح رقمي (>0)، اسم، أقصى نطاق (>1؛ 2=نعم/لا)، معنى أقل قيمة (مثال، 'سيء')، معنى أعلى قيمة (مثال، 'جيد').
1:الجودة:5:سيء:جيد
2:مستعد ل 1.0:2:لا:نعم",
	'review_topic_page'                                      => 'مراجعة المواضيع',
	'review_sidebar_explanation'                             => "الصندوق في أقصى اليسار دائما يعني 'لا رأي'.",
	'review_save'                                            => 'خزن المراجعة',
	'review_your_review'                                     => 'مراجعتك لهذه الصفحة/النسخة:',
	'review_sidebar_you_have_other_reviews_for_this_article' => "لقد راجعت بالفعل نسخا أخرى من هذه الصفحة. تقييماتك الأخرى ستدمج إلى هذه المراجعة حيث اخترت 'لا رأي'.",
	'review_page_link'                                       => 'مراجعة الإحصاءات',
	'review_sidebar_final'                                   => 'لبيانات مراجعة رؤية هذه الصفحة، انظر $1',
	'review_for_page'                                        => 'المراجعة للصفحة "$1"',
	'review_for_user'                                        => 'المراجعة للمستخدم "$1"',
	'review_error'                                           => 'هناك شيء ما خطأ!',
	'review_no_reviews_for_page'                             => 'لا توجد حاليا مراجعات ل"$1".',
	'review_total_statistics'                                => 'الإجمالي',
	'review_statistics_left_corner'                          => 'النسخة',
	'review_version_link'                                    => 'النسخة #$1',
	'review_statistic_cell'                                  => 'المتوسط: $1 من $2<br />($4 مستخدم، $5 مجهول)',
	'review_version_statistic_cell'                          => '$1 من $2',
	'review_version_reviews_link'                            => '<small>(مراجعات النسخة)</small>',
	'review_concerns_page'                                   => 'هذه المراجعة هي حول الصفحة "$1".',
	'review_concerns_user'                                   => 'هذا حول المراجعات بواسطة المستخدم "$1".',
	'review_user_reviews'                                    => '<small>(المراجعات بواسطة هذا المستخدم)</small>',
	'review_user_page_list'                                  => 'المستخدم راجع الصفحات التالية:',
	'review_user_details_link'                               => '(تفاصيل)',
	'review_do_merge'                                        => 'ادمج مراجعاتي للنسخ الأخرى لهذه الصفحة إلى هذه المراجعة',
	'review_has_been_stored'                                 => "<span id='review_has_been_stored'>مراجعتك تم تخزينها!</span>",
	'revision_review_this_page_version_link'                 => 'مراجعة هذه النسخة من الصفحة.',
	'review_page_review'                                     => 'مراجعة صفحة "$1"',
	'review_blocked'                                         => 'أنت ممنوع، اذهب بعيدا.',
	'review_wrong_namespace'                                 => 'الصفحات في هذا النطاق لا يمكن مراجعتها!',
	'review_topic'                                           => 'الموضوع',
	'review_no_opinion'                                      => 'لا رأي',
	'review_rating'                                          => 'التقييم',
	'review_comment'                                         => 'تعليق',
);

/** Asturian (Asturianu)
 * @author Esbardu
 * @author Siebrand
 */
$messages['ast'] = array(
	'review_sidebar_title'                                   => 'Revisar',
	'review_topics'                                          => "# Llista d'elementos y valores pa la estensión \"review\".
# Cada elementu ta definíu por una llinia de cinco valores, separtaos por ':' (les demás llinies inórense).
# L'orde ye: identificador numéricu (>0), nome, valor máximu (>1; 2=sí/non), significación del valor más baxu (ex. 'malu'), significación del valor más altu (ex. 'bonu').
1:Calidá:5:malu:bonu
2:Preparáu pa 1.0:2:non:sí",
	'review_topic_page'                                      => 'Revisar elementos',
	'review_sidebar_explanation'                             => "El caxellu más a manzorga siempre significa 'ensin opinión'.",
	'review_save'                                            => 'Guardar revisión',
	'review_your_review'                                     => "La to revisión d'esta páxina/revisión:",
	'review_sidebar_you_have_other_reviews_for_this_article' => "Yá revisasti otres versiones d'esta páxina. Les otres evaluaciones tuyes van ser fusionaes con esta si seleicionasti 'ensin opinión'.",
	'review_page_link'                                       => 'estadístiques de revisión',
	'review_sidebar_final'                                   => "Pa revisar los datos de la vista d'esta páxina, mira les sos $1",
	'review_for_page'                                        => 'Revisión de la páxina "$1"',
	'review_for_user'                                        => 'Revisión del usuariu "$1"',
	'review_error'                                           => '¡Hai daqué que ta mal!',
	'review_no_reviews_for_page'                             => 'Nestos momentos nun hai revisiones de "$1".',
	'review_total_statistics'                                => 'Total',
	'review_statistics_left_corner'                          => 'Revisión',
	'review_version_link'                                    => 'Revisión númberu $1',
	'review_statistic_cell'                                  => 'Media: $1 de $2<br />($4 usuarios rexistraos, $5 anónimos)',
	'review_version_statistic_cell'                          => '$1 de $2',
	'review_version_reviews_link'                            => '<small>(revisiones de versiones)</small>',
	'review_concerns_page'                                   => 'Esta revisión ye de la páxina "$1".',
	'review_concerns_user'                                   => 'Estes son les revisiones del usuariu "$1".',
	'review_user_reviews'                                    => "<small>(revisiones d'esti usuariu)</small>",
	'review_user_page_list'                                  => "L'usuariu revisó les páxines siguientes:",
	'review_user_details_link'                               => '(detalles)',
	'review_do_merge'                                        => "Fusionar con esta les otres revisiones míes d'esta páxina",
	'review_has_been_stored'                                 => "<span id='review_has_been_stored'>¡Guardóse la to revisión!</span>",
	'revision_review_this_page_version_link'                 => 'Revisar esta versión de la páxina.',
	'review_page_review'                                     => 'Revisión de la páxina "$1"',
	'review_blocked'                                         => 'Tas bloquiáu, nun pues siguir.',
	'review_wrong_namespace'                                 => "¡Les páxines d'esti espaciu de nomes nun puen ser revisaes!",
	'review_topic'                                           => 'Elementu',
	'review_no_opinion'                                      => 'Ensin opinión',
	'review_rating'                                          => 'Evaluación',
	'review_comment'                                         => 'Comentariu',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'review_comment' => 'Камэнтар',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'review_total_statistics'       => 'Общо',
	'review_statistics_left_corner' => 'Редакция',
	'review_version_link'           => 'Редакция #$1',
	'review_version_statistic_cell' => '$1 от $2',
	'review_user_details_link'      => '(детайли)',
	'review_blocked'                => 'Вие сте блокиран, разкарайте се.',
	'review_topic'                  => 'Тема',
	'review_rating'                 => 'Рейтинг',
	'review_comment'                => 'Коментар',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'review_sidebar_title'                                   => 'Adweladenn',
	'review-desc'                                            => "Adlañsañ a ra arc'hwel [[Special:Review|kadarnaat]] ur pennad.",
	'review_topics'                                          => "# Roll an dodennoù evit astenn \"adwelet\" wiki.
# Termenet eo pep dodenn gant ul linenn 5 talvoud enni, dispartiet dre ':' (ne gemer ket e kont al linennoù all).
# Setu urzh an talvoudoù : alc'hwez niverel (>0), anv, emled (>1; 2=ya/ket), talvoudegezh an talvoud izelañ (evel, 'fall'), talvoudegezh ar talvoud uhelañ (da skouer, 'mat').
1: Perzhded: 5:fall:mat
2: Prest evit 1.0:2: ya:ket",
	'review_topic_page'                                      => 'Dodennoù da adwelet',
	'review_sidebar_explanation'                             => 'Al log askañ ar muiañ a-gleiz a dalvez atav  "hep tamm soñj ebet".',
	'review_save'                                            => 'Saveteiñ an adweladenn',
	'review_your_review'                                     => "Hoc'h adweladenn/reizhadenn eus ar bajenn-mañ :",
	'review_sidebar_you_have_other_reviews_for_this_article' => "Adwelet eo bet ganeoc'h stummoù all ar bajenn-mañ c'hoazh. Kendeuzet e vo ho priziadennoù kent gant ar re-mañ m'hoc'h eus dibabet \"hep tamm soñj ebet\".",
	'review_page_link'                                       => 'Stadegoù adwelet',
	'review_sidebar_final'                                   => 'Evit gwelet roadennoù adwelet gweladenn ar bajenn-mañ, mont da $1',
	'review_for_page'                                        => 'Adweladennoù evit ar bajenn "$1"',
	'review_for_user'                                        => 'Adweladennoù an implijer "$1"',
	'review_error'                                           => 'Un dra bennak a-dreuz zo!',
	'review_no_reviews_for_page'                             => 'Evit poent n\'eus bet adweladenn ebet "$1".',
	'review_total_statistics'                                => 'Hollad',
	'review_statistics_left_corner'                          => 'Adweladenn',
	'review_version_link'                                    => 'Adweladenn #$1',
	'review_statistic_cell'                                  => 'Keidenn : $1 diwar $2<br />($4 implijer enskrivet, $5 dianv)',
	'review_version_statistic_cell'                          => '$1 diwar $2',
	'review_version_reviews_link'                            => 'small>(adweladennoù stumm)</small>',
	'review_concerns_page'                                   => 'Diwar-benn ar bajenn "$1" eo an adweladenn-mañ.',
	'review_concerns_user'                                   => 'Diwar-benn adweladennoù an implijer "$1" eo.',
	'review_user_reviews'                                    => '<small>(adweladennoù gant an implijer-mañ)</small>',
	'review_user_page_list'                                  => 'Adwelet eo bet ar pajennoù da-heul gant an implijer :',
	'review_user_details_link'                               => '(munudoù)',
	'review_do_merge'                                        => 'Kendeuziñ ma adweladennoù eus ar reizhadennoù all gant ar bajenn-mañ',
	'review_has_been_stored'                                 => "<span id='review_has_been_stored'>Enrollet eo bet hoc'h adweladenn</span>",
	'revision_review_this_page_version_link'                 => 'Adwelet ar stumm-mañ eus ar bajenn.',
	'review_page_review'                                     => 'Adweladenn ar bajenn "$1"',
	'review_blocked'                                         => "Stanket oc'h, kit kuit.",
	'review_wrong_namespace'                                 => "N'haller ket adwelet ar pajennoù en esaouen anv-mañ.",
	'review_topic'                                           => 'Danvez',
	'review_no_opinion'                                      => 'Hep tamm soñj ebet',
	'review_rating'                                          => 'Priziadenn',
	'review_comment'                                         => 'Notenn',
);

/** Catalan (Català)
 * @author Jordi Roqué
 */
$messages['ca'] = array(
	'review_comment' => 'Comentari',
);

/** Danish (Dansk)
 * @author Morten
 */
$messages['da'] = array(
	'review_sidebar_title' => 'Gennemse',
	'review-desc'          => 'Den genopstandne [[Special:Review|valideringsfeature]].',
);

/** Greek (Ελληνικά)
 * @author Consta
 */
$messages['el'] = array(
	'review_user_details_link' => '(λεπτομέρειες)',
	'review_no_opinion'        => 'Καμία γνώμη',
	'review_rating'            => 'Αξιολόγηση',
	'review_comment'           => 'Σχόλιο',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'review_sidebar_title'          => 'Kontrolu',
	'review_page_link'              => 'rigardu statistikojn',
	'review_error'                  => 'Io fuŝas!',
	'review_total_statistics'       => 'Tuto',
	'review_statistics_left_corner' => 'Revizio',
	'review_version_link'           => 'Revizio #$1',
	'review_version_statistic_cell' => '$1 de $2',
	'review_user_details_link'      => '(detaloj)',
	'review_blocked'                => 'Vi estas forbarita. Foriru.',
	'review_topic'                  => 'Temo',
	'review_no_opinion'             => 'Neniu opinio',
	'review_rating'                 => 'Takso',
	'review_comment'                => 'Komento',
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'review_sidebar_title'                                   => 'بازبینی',
	'review_topics'                                          => "# آن چه در ادامه می‌بینید فهرست عنوان‌ها و بازه‌های افزونهٔ بازبینی است.
# هر عنوان با یک سطر حاوی پنج مقدار مشخص می‌شود که با علامت ':' از هم جدا شده‌اند (بقیهٔ سطرها نادیده گرفته می‌شوند).
# ترتیب آن‌ها از این قراراست: یک کلید عددی (بزرگتر از صفر)، نام، حداکثر بازه (بزرگتر از ۱؛ ۲=بلی/خیر)، معنای کمترین مقدار (مثلاً «بد»)، معنای بیشترین مقدار (مثلاً «خوب»)
1:کیفیت:5:بد:خوب
2:آماده برای نسخه ۱٫۰ :2:خیر:بله",
	'review_topic_page'                                      => 'بازبینی عنوان‌ها',
	'review_sidebar_explanation'                             => 'اولین جعبه از سمت چپ همیشه به معنای «نظری ندارم» است.',
	'review_save'                                            => 'ذخیره نتیجه بازبینی',
	'review_your_review'                                     => 'نتیجه بازبینی شما برای این صفحه/نسخه:',
	'review_sidebar_you_have_other_reviews_for_this_article' => 'شما پیش از این نسخهٔ دیگری از این صفحه را بازبینی کرده‌اید. برای گزینه‌هایی که «نظری ندارم» را انتخاب کنید، نتیجه بازبینی قبلی شما با نتیجه بازبینی فعلی ادغام خواهد شد.',
	'review_page_link'                                       => 'آمار بازبینی‌ها',
	'review_sidebar_final'                                   => 'برای نتایج بازبینی این صفحه، $1 آن را ببینید',
	'review_for_page'                                        => 'بازبینی برای صفحهٔ «$1»',
	'review_for_user'                                        => 'بازبینی برای کاربر «$1»',
	'review_error'                                           => 'خطایی رخ داده‌است!',
	'review_no_reviews_for_page'                             => 'در حال حاضر بازبینی‌ای برای «$1» انجام نشده است.',
	'review_total_statistics'                                => 'جمع',
	'review_statistics_left_corner'                          => 'نسخه',
	'review_version_link'                                    => 'نسخهٔ شمارهٔ $1',
	'review_statistic_cell'                                  => 'میانگین: $1 از $2<br />($4 کاربر، $5 ناشناس)',
	'review_version_statistic_cell'                          => '$1 از $2',
	'review_version_reviews_link'                            => '<small>(بازبینی‌های نسخه‌ها)</small>',
	'review_concerns_page'                                   => 'این بازبینی در مورد صفحهٔ «$1» است.',
	'review_concerns_user'                                   => 'این در مورد بازبینی‌های کاربر «$1» است.',
	'review_user_reviews'                                    => '<small>(بازبینی‌های انجام شده توسط این کاربر)</small>',
	'review_user_page_list'                                  => 'این کاربر صفحه‌های زیر را بازبینی کرده‌است:',
	'review_user_details_link'                               => '(توضیح)',
	'review_do_merge'                                        => 'نتیجه بازبینی‌های قبلی من از این صحفه را با بازبینی فعلی ادغام کن',
	'review_has_been_stored'                                 => "<span id='review_has_been_stored'>نتیجهٔ بازبینی شما ثبت شد!</span>",
	'revision_review_this_page_version_link'                 => 'بازبینی این نسخه از صفحه',
	'review_page_review'                                     => 'بازبینی صفحهٔ «$1»',
	'review_blocked'                                         => 'دسترسی شما قطع شده‌است، دور شوید.',
	'review_wrong_namespace'                                 => 'صفحه‌های این فضای نام را نمی‌توان بازبینی کرد!',
	'review_topic'                                           => 'عنوان',
	'review_no_opinion'                                      => 'نظری ندارم',
	'review_rating'                                          => 'رتبه',
	'review_comment'                                         => 'توضیح',
);

/** Finnish (Suomi)
 * @author Str4nd
 */
$messages['fi'] = array(
	'review_has_been_stored' => "<span id='review_has_been_stored'>Arvostelusi tallennettiin.</span>",
);

/** French (Français)
 * @author Sherbrooke
 * @author Urhixidur
 * @author Dereckson
 * @author Grondin
 * @author IAlex
 */
$messages['fr'] = array(
	'review_sidebar_title'                                   => 'Révision',
	'review-desc'                                            => 'Relance la fonctionnalité de [[Special:Review|validation]] d’un article.',
	'review_topics'                                          => "# Liste de sujets pour l'extension « review » de MediaWiki.
# ....
# Chaque sujet est défini par une liste de données séparées par « : » (toute autre liste est ignorée).
# ....
# Les données dans l'ordre sont :
## identifiant numérique (>0)
## nom
## étendue (>1)
## signification de la plus petite valeur (ex. « mauvais »)
## signification de la plus grande valeur (ex. « bon »)
# ....
# Par exemple, s'il faut seulement choisir « non » ou « oui », l'étendue vaut 2.
# Par exemple, s'il faut choisir entre « médiocre », « mauvais », « à améliorer », « bien » ou « très bien », l'étendue vaut 5.
# ....
1:Qualité:5:mauvais:bon
2:Prêt pour 1.0:2:non:oui",
	'review_topic_page'                                      => 'Sujets à révision',
	'review_sidebar_explanation'                             => 'La boîte à cocher la plus à gauche toute signifie toujours « sans opinion ».',
	'review_save'                                            => 'Sauvegarder la révision',
	'review_your_review'                                     => 'Votre révision de cette page ou révision :',
	'review_sidebar_you_have_other_reviews_for_this_article' => 'Vous avez déjà révisé les autres versions de cette page. Vos autres évaluations seront fusionnées avec celle-ci si vous avez sélectionné « sans opinion ».',
	'review_page_link'                                       => 'Statistiques de révisions',
	'review_sidebar_final'                                   => 'Pour voir les données de révision de la vue de cette page, aller à $1',
	'review_for_page'                                        => 'Révision pour la page « $1 »',
	'review_for_user'                                        => 'Révision pour contributeur « $1 »',
	'review_error'                                           => 'Quelque chose cloche.',
	'review_no_reviews_for_page'                             => "Il n'y a pas de révisions pour « $1 ».",
	'review_total_statistics'                                => 'Total',
	'review_statistics_left_corner'                          => 'Révision',
	'review_version_link'                                    => 'Révision #$1',
	'review_statistic_cell'                                  => 'Moyenne : $1 de $2<br />($4 utilisateurs inscrits, $5 anonymes)',
	'review_version_statistic_cell'                          => '$1 de $2',
	'review_version_reviews_link'                            => '<small>(révisions de version)</small>',
	'review_concerns_page'                                   => 'Cete révision est à propos de la page « $1 ».',
	'review_concerns_user'                                   => "C'est à propos des revisions faites par le contributeur « $1 ».",
	'review_user_reviews'                                    => '<small>(révisions par ce contributeur)</small>',
	'review_user_page_list'                                  => 'Le contributeur a révisé les pages suivantes :',
	'review_user_details_link'                               => '(détails)',
	'review_do_merge'                                        => 'Fusionner mes passages en revue des autres révisions de cette page avec celle-ci',
	'review_has_been_stored'                                 => "<span id='review_has_been_stored'>Votre révision a été enregistrée.</span>",
	'revision_review_this_page_version_link'                 => 'Réviser cette version de la page',
	'review_page_review'                                     => 'Révision de la page « $1 »',
	'review_blocked'                                         => 'Vous êtes bloqué.',
	'review_wrong_namespace'                                 => 'Les pages dans cet espace de nom ne peuvent être révisées.',
	'review_topic'                                           => 'Sujet',
	'review_no_opinion'                                      => 'Sans opinion',
	'review_rating'                                          => 'Évaluation',
	'review_comment'                                         => 'Commentaire',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Siebrand
 */
$messages['gl'] = array(
	'review_sidebar_title'                                   => 'Revisar',
	'review-desc'                                            => 'A característica de [[Special:Review|validación]] resucitada.',
	'review_topics'                                          => '# O que segue é unha lista de temas e rangos para a extensión de revisión.
# Cada tema é definido por unha liña de cinco valores, separados por ":" (todas as outras liñas son ignoradas).
# A orde é: tecla numérica (>0), nome, rango máximo (>1; 2=si/non), significado do valor máis baixo (por exemplo, "malo"), significado do valor máis alto (por exemplo, "bo").
1:Calidade:5:malo:bo
2:Preparado para 1.0:2:non:si',
	'review_topic_page'                                      => 'Revisados os temas',
	'review_sidebar_explanation'                             => "O extremo esquerdo da caixiña sempre significa 'sen opinión'.",
	'review_save'                                            => 'Gardar a revisión',
	'review_your_review'                                     => 'O seu exame desta páxina/revisión:',
	'review_sidebar_you_have_other_reviews_for_this_article' => "Xa ten revisado outras versións desta páxina. As súas outras calificación serán fusionadas con esta na que seleccionou 'sen opinión'.",
	'review_page_link'                                       => 'revisar estatísticas',
	'review_sidebar_final'                                   => 'Para revisar os datos desta páxina, véxase $1',
	'review_for_page'                                        => 'Revisión para a páxina "$1"',
	'review_for_user'                                        => 'Revisión para o usuario "$1"',
	'review_error'                                           => 'Algo está fallando!',
	'review_no_reviews_for_page'                             => 'Actualmente non hai revisións para "$1".',
	'review_total_statistics'                                => 'Total',
	'review_statistics_left_corner'                          => 'Revisión',
	'review_version_link'                                    => 'Revisión #$1',
	'review_statistic_cell'                                  => 'Promedio: $1 de $2<br />($4 usuarios, $5 anónimos)',
	'review_version_statistic_cell'                          => '$1 de $2',
	'review_version_reviews_link'                            => '<small>(versión revisada)</small>',
	'review_concerns_page'                                   => 'Esta revisión é acerca da páxina "$1".',
	'review_concerns_user'                                   => 'Isto é acerca das revisións polo usuario "$1".',
	'review_user_reviews'                                    => '<small>(revisións por este usuario)</small>',
	'review_user_page_list'                                  => 'O usuario revisou as seguintes páxinas:',
	'review_user_details_link'                               => '(detalles)',
	'review_do_merge'                                        => 'Fusionar as miñas revisións coas outras revisións desta páxina dentro desta',
	'review_has_been_stored'                                 => "<span id='review_has_been_stored'>A súa revisión foi almacenada!</span>",
	'revision_review_this_page_version_link'                 => 'Examinar esta versión desta páxina.',
	'review_page_review'                                     => 'Revisión da páxina "$1"',
	'review_blocked'                                         => 'Vostede está bloqueado, desaparecerá.',
	'review_wrong_namespace'                                 => 'As páxinas no espazo de nomes non poden ser revisadas!',
	'review_topic'                                           => 'Tema',
	'review_no_opinion'                                      => 'Sen opinión',
	'review_rating'                                          => 'Avaliación',
	'review_comment'                                         => 'Comentario',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'review_total_statistics' => 'Yn clane',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'review_sidebar_title'                   => 'अवलोकन',
	'review-desc'                            => 'पुनर्जिवीत [[Special:Review|पुष्टीकरण]] वैशिष्ठ्य',
	'review_topic_page'                      => 'विषय अवलोकन',
	'review_sidebar_explanation'             => "सबसे बाईंओर के चेक बॉक्स का मतलब हमेशा 'मत नहीं' ऐसा हैं।",
	'review_save'                            => 'अवलोकन संजोयें',
	'review_your_review'                     => 'इस पन्ने/अवतरण का आपने किया हुआ अवलोकन:',
	'review_page_link'                       => 'अवलोकन सांख्यिकी',
	'review_sidebar_final'                   => 'इस पन्ने को मिले भेटोंका अवलोकन करने के लिये, उसका $1 देखें',
	'review_for_page'                        => '"$1" पन्नेका अवलोकन',
	'review_for_user'                        => '"$1" सदस्यका अवलोकन',
	'review_error'                           => 'कुछ तो गड़बड हैं!',
	'review_no_reviews_for_page'             => 'अभी "$1" का अवलोकन नहीं किया हुआ है।',
	'review_total_statistics'                => 'कुल',
	'review_statistics_left_corner'          => 'अवतरण',
	'review_version_link'                    => 'अवतरण #$1',
	'review_statistic_cell'                  => 'एवरेज़: $2 के $1<br />($4 सदस्य, $5 अनामक)',
	'review_version_statistic_cell'          => '$2 के $1',
	'review_version_reviews_link'            => '<small>(अवतरण अवलोकन)</small>',
	'review_concerns_page'                   => 'यह अवलोकन "$1" इस पन्ने का हैं।',
	'review_concerns_user'                   => 'यह "$1" इस सदस्यने किया हुआ अवलोकन है।',
	'review_user_reviews'                    => '<small>(इस सदस्यने किया हुआ अवलोकन)</small>',
	'review_user_page_list'                  => 'इस सदस्यने निम्नलिखित पन्नोंका अवलोकन किया हुआ हैं:',
	'review_user_details_link'               => '(विस्तॄत ज़ानकारी)',
	'revision_review_this_page_version_link' => 'इस पन्नेके इस अवतरणका अवलोकन करें।',
	'review_page_review'                     => '"$1" पन्नेका अवलोकन',
	'review_blocked'                         => 'आपको ब्लॉक कर दिया गया हैं, यहां से चले जायें।',
	'review_topic'                           => 'विषय',
	'review_no_opinion'                      => 'मत नहीं',
	'review_rating'                          => 'गुणांकन',
	'review_comment'                         => 'टिप्पणी',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 * @author Siebrand
 */
$messages['hsb'] = array(
	'review_sidebar_title'                                   => 'Přepruwować',
	'review-desc'                                            => 'Wobnowjena [[Special:Review|pruwowanska]] funkcija.',
	'review_topics'                                          => "# Deleka je lisćina temow a wobwodow za rozšěrjenje Review.
# Kóžda tema definuje so přez linku pjeć hódnotow wotdźělenych přez ':' (wšě druhe linki ignoruja so).
# Porjad je: numeriski kluč (>0), mjeno, maksimalny wobwod (>1; 2=haj/ně), woznam najnišeje hódnoty (na př. 'špatny'), woznam najwyšeje hódnoty (na př. 'dobry').
1:Kajkosć:5:špatny:dobry
2:Hotowy za 1.0:2:ně:haj",
	'review_topic_page'                                      => 'Temy přepruwować',
	'review_sidebar_explanation'                             => "Lěwy kontrolowy kašćik přeco 'žane měnjenje' woznamjenja.",
	'review_save'                                            => 'Přepruwowanje składować',
	'review_your_review'                                     => 'Waše přepruwowanje tuteje strony/wersije:',
	'review_sidebar_you_have_other_reviews_for_this_article' => "Sy hižo druhe wersije tuteje strony přepruwował. Twoje druhe pohódnoćenja budu so z tutej zjednoćeć, hdźež sy 'žane měnjenje' wubrał.",
	'review_page_link'                                       => 'Statistiku přepruwować',
	'review_sidebar_final'                                   => 'Za přepruwowanske daty tutoho napohlada strony, hlej jeho $1',
	'review_for_page'                                        => 'Přepruwowanje za stronu "$1"',
	'review_for_user'                                        => 'Přepruwowanje za wužiwarja "$1"',
	'review_error'                                           => 'Je někajki zmylk!',
	'review_no_reviews_for_page'                             => 'Tuchwilu žane přepruwowanja za "$1" njejsu.',
	'review_total_statistics'                                => 'Dohromady',
	'review_statistics_left_corner'                          => 'Wersija',
	'review_version_link'                                    => 'Wersija #$1',
	'review_statistic_cell'                                  => 'Přerězk: $1 z $2<br />($4 {{PLURAL:$4|wužiwar|wužiwarjej|wužiwarjo|wužiwarjow}}, $5 {{PLURAL:$5|anonymny|anonymnej|anonymne|anonymnych}})',
	'review_version_statistic_cell'                          => '$1 z $2',
	'review_version_reviews_link'                            => '<small>(wersijowe přepruwowanja)</small>',
	'review_concerns_page'                                   => 'Tute přepruwowanje je za stronu "$1".',
	'review_concerns_user'                                   => 'To je wo přepruwowanjach wot wužiwarja "$1".',
	'review_user_reviews'                                    => '<small>(přepruwowanja wot tutoho wužiwarja)</small>',
	'review_user_page_list'                                  => 'Wužiwar je slědowace strony přepruwował:',
	'review_user_details_link'                               => '(podrobnosće)',
	'review_do_merge'                                        => 'Moje přepruwowanja druhich wersijow tuteje strony z tutym zjednoćić',
	'review_has_been_stored'                                 => "<span id='review_has_been_stored'>Waše přepruwowanje je so składowało!</span>",
	'revision_review_this_page_version_link'                 => 'Přepruwuj tutu wersiju strony.',
	'review_page_review'                                     => 'Přepruwowanje strony "$1"',
	'review_blocked'                                         => 'Sy blokowany, dźi preč.',
	'review_wrong_namespace'                                 => 'Strony w tutym mjenowym rumje njehodźa so přepruwować!',
	'review_topic'                                           => 'Tema',
	'review_no_opinion'                                      => 'Žane měnjenje',
	'review_rating'                                          => 'Pohódnoćenje',
	'review_comment'                                         => 'Komentar',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'review_comment' => 'Commento',
);

/** Indonesian (Bahasa Indonesia)
 * @author Irwangatot
 * @author Rex
 */
$messages['id'] = array(
	'review_total_statistics'  => 'Total',
	'review_user_details_link' => '(rincian)',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'review_error'                  => 'Ana sing salah!',
	'review_total_statistics'       => 'Gunggungé',
	'review_statistics_left_corner' => 'Révisi',
	'review_version_link'           => 'Révisi #$1',
	'review_version_statistic_cell' => '$1 saka $2',
	'review_user_details_link'      => '(détail)',
	'review_blocked'                => 'Panjenengan iku diblokir, mangga lungaa.',
	'review_topic'                  => 'Topik',
	'review_no_opinion'             => 'Ora ana komentar',
	'review_comment'                => 'Komentar',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 */
$messages['km'] = array(
	'review_total_statistics'  => 'សរុប',
	'review_user_details_link' => '(លំអិត)',
	'review_topic'             => 'ប្រធានបទ',
	'review_no_opinion'        => 'គ្មានមតិ',
	'review_comment'           => 'យោបល់',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'review_total_statistics'  => 'Zosamme',
	'review_user_details_link' => '(Einzelheite)',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'review_save'                   => 'Versioun späicheren',
	'review_page_link'              => 'Statistike vum Nokucken',
	'review_error'                  => 'Et ass eppes falsch!',
	'review_total_statistics'       => 'Total',
	'review_statistics_left_corner' => 'Versioun',
	'review_version_link'           => 'Versioun #$1',
	'review_version_statistic_cell' => '$1 vu(n) $2',
	'review_user_details_link'      => '(Detailer)',
	'review_blocked'                => 'Dir sidd gespaart.',
	'review_topic'                  => 'Thema',
	'review_no_opinion'             => 'Keng Meenung',
	'review_comment'                => 'Bemierkung',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'review_sidebar_title'                   => 'സം‌ശോധനം',
	'review_topic_page'                      => 'സം‌ശോധനം ചെയ്യാനുള്ള വിഷയങ്ങള്‍',
	'review_save'                            => 'സം‌ശോധനം സേവ് ചെയ്യുക',
	'review_your_review'                     => 'ഈ താളിനുള്ള‌/പതിപ്പിനുള്ള താങ്കളുടെ സം‌ശോധനം:',
	'review_page_link'                       => 'സം‌ശോധന സ്ഥിതിവിവരക്കണക്കുകള്‍',
	'review_sidebar_final'                   => 'ഈ താളിന്റെ സം‌ശോധന ഡാറ്റയ്ക്കു $1 കാണുക',
	'review_for_page'                        => '"$1" എന്ന താളിനുള്ള സം‌ശോധനം',
	'review_for_user'                        => '"$1" എന്ന ഉപയോക്താവിന്റെ സം‌ശോധനം',
	'review_error'                           => 'എന്തോ പ്രശ്നമുണ്ട്!',
	'review_no_reviews_for_page'             => '"$1" നു നിലവില്‍ സം‌ശോധനം ഒന്നുമില്ല.',
	'review_total_statistics'                => 'മൊത്തം',
	'review_statistics_left_corner'          => 'പതിപ്പ്',
	'review_version_link'                    => 'പതിപ്പ് #$1',
	'review_statistic_cell'                  => 'ശരാശരി: $1 of $2<br />($4 ഉപയോക്താക്കള്‍, $5 അജ്ഞാതര്‍)',
	'review_version_statistic_cell'          => '$1 ന്റെ $2',
	'review_version_reviews_link'            => '<small>(പതിപ്പിന്റെ സം‌ശോധനങ്ങള്‍)</small>',
	'review_concerns_page'                   => 'ഈ സം‌ശോധനം "$1" എന്ന താളിനെ കുറിച്ചാണ്‌.',
	'review_concerns_user'                   => 'ഇതു "$1" എന്ന ഉപയോക്താവിന്റെ സം‌ശോധനങ്ങളെക്കുറിച്ചാണ്‌.',
	'review_user_reviews'                    => '<small>(ഈ ഉപയോക്താവിന്റെ സംശോധനങ്ങള്‍)</small>',
	'review_user_page_list'                  => 'ഈ ഉപയോക്താവ് താഴെ പ്രദര്‍ശിപ്പിച്ചിരിക്കുന്ന താളുകള്‍ സംശോധനം ചെയ്തു:',
	'review_user_details_link'               => '(വിശദാംശങ്ങള്‍:)',
	'revision_review_this_page_version_link' => 'താളിന്റെ ഈ പതിപ്പ് സംശോധനം ചെയ്യുക.',
	'review_page_review'                     => '"$1" എന്ന താളിന്റെ സം‌ശോധനം',
	'review_blocked'                         => 'താങ്കള്‍ തടയപ്പെട്ടിക്കുന്നു. ഇവിടെ പ്രവേശനം ഇല്ല.',
	'review_wrong_namespace'                 => 'ഈ നേംസ്പേസിലുള്ള താളുകള്‍ സം‌ശോധനം ചെയ്യുക സാദ്ധ്യമല്ല!',
	'review_topic'                           => 'വിഷയം',
	'review_no_opinion'                      => 'അഭിപ്രായമില്ല',
	'review_comment'                         => 'അഭിപ്രായം:',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'review_sidebar_title'                                   => 'अवलोकन',
	'review-desc'                                            => 'पुनर्जिवीत [[Special:Review|पुष्टीकरण]] वैशिष्ठ्य',
	'review_topics'                                          => "# अवलोकन विस्तारकक्षासाठी आवश्यक अशा विषय तसेच रेंजची ही यादी आहे.
# प्रत्येक विषय हा पाच वेगवेगळ्या किंमतींनी दर्शविलेला आहे, ज्यामध्ये ':' दिलेला आहे (बाकी सर्व ओळी दुर्लक्षित केलेल्या आहेत).
# त्यांची मांडणी अशी: सांख्यिक किंमत (>0), नाव, जास्तीत जास्त रेंज (>1; 2=हो/नाही), कमीत कमी किंमतीचा अर्थ (उदा, 'वाईट'), जास्तीतजास्त किंमतीचा अर्थ (e.g., 'उत्तम').
1:गुणवत्ता:5:वाईट:उत्तम
2:१.० साठी तयार:2:नाही:हो",
	'review_topic_page'                                      => 'विषय अवलोकन',
	'review_sidebar_explanation'                             => "सर्वात डावीकडील चेक बॉक्स चा अर्थ कायम 'मत नाही' असा आहे.",
	'review_save'                                            => 'अवलोकन जतन करा',
	'review_your_review'                                     => 'ह्या पानाचे/आवृत्तीचे तुम्ही केलेले अवलोकन:',
	'review_sidebar_you_have_other_reviews_for_this_article' => "तुम्ही अगोदरच या पानाच्या इतर आवृत्तींचे अवलोकन केलेले आहे. जिथे तुम्ही 'मत नाही' अशी खूण देत आहात तिथे तुम्ही आधी दिलेले मत विचारात घेतले जाईल.",
	'review_page_link'                                       => 'अवलोकन सांख्यिकी',
	'review_sidebar_final'                                   => 'ह्या पानाच्या भेटींचे अवलोकन करण्यासाठी, त्याचे $1 पहा',
	'review_for_page'                                        => '"$1" पानाचे अवलोकन',
	'review_for_user'                                        => '"$1" सदस्याचे अवलोकन',
	'review_error'                                           => 'काहीतरी चुकत आहे!',
	'review_no_reviews_for_page'                             => 'सद्यस्थितीत "$1" चे अवलोकन केलेले नाही.',
	'review_total_statistics'                                => 'एकूण',
	'review_statistics_left_corner'                          => 'आवृत्ती',
	'review_version_link'                                    => 'आवृत्ती #$1',
	'review_statistic_cell'                                  => 'सरासरी: $2 चे $1<br />($4 सदस्य, $5 अनामिक)',
	'review_version_statistic_cell'                          => '$2 चे $1',
	'review_version_reviews_link'                            => '<small>(आवृत्ती अवलोकन)</small>',
	'review_concerns_page'                                   => 'हे अवलोकन "$1" या पानाचे आहे.',
	'review_concerns_user'                                   => 'हे "$1" या सदस्याने केलेले अवलोकन आहे.',
	'review_user_reviews'                                    => '<small>(या सदस्याने केलेले अवलोकन)</small>',
	'review_user_page_list'                                  => 'या सदस्याने खालील पानांचे अवलोकन केलेले आहे:',
	'review_user_details_link'                               => '(विस्तृत माहिती)',
	'review_do_merge'                                        => 'या पानाच्या इतर आवृत्त्यांचे मी केलेले अवलोकन इथे एकत्र करा',
	'review_has_been_stored'                                 => "<span id='review_has_been_stored'>तुमचे अवलोकन जतन केलेले आहे!</span>",
	'revision_review_this_page_version_link'                 => 'या पानाच्या या आवृत्तीचे अवलोकन करा.',
	'review_page_review'                                     => '"$1" पानाचे अवलोकन',
	'review_blocked'                                         => 'तुम्हाला ब्लॉक केलेले आहे, इथून निघून जा.',
	'review_wrong_namespace'                                 => 'या नामविश्वातील पानांचे अवलोकन करू शकत नाही!',
	'review_topic'                                           => 'विषय',
	'review_no_opinion'                                      => 'मत नाही',
	'review_rating'                                          => 'गुणांकन',
	'review_comment'                                         => 'टिप्पणी',
);

/** Nahuatl (Nahuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'review_sidebar_title'                   => 'Ticceppahuīz',
	'review_topic_page'                      => 'Tiquinceppahuīz tlamantli',
	'review_your_review'                     => 'Moceppahuiliz inīn zāzaniltechcopa/ceppahuiliztli:',
	'review_page_link'                       => 'ticceppahuīz tlapōhualiztli',
	'review_for_page'                        => 'Ceppahuiliztli "$1" ītechcopa',
	'review_for_user'                        => 'Ceppahuiliztli "$1" ītechcopa',
	'review_error'                           => '¡Cequi ahcualli cah!',
	'review_no_reviews_for_page'             => 'Āxcān, in ahmo cateh ceppahuiliztli "$1" ītechcopa.',
	'review_total_statistics'                => 'Mochīntīn',
	'review_statistics_left_corner'          => 'Ceppahuiliztli',
	'review_version_link'                    => 'Ceppahuiliztli #$1',
	'review_concerns_page'                   => 'Inīn ceppahuiliztli cah "$1" ītechcopa.',
	'review_concerns_user'                   => 'Inīn cah tlatēquitiltilīlpal "$1" īceppahuiliztechcopa.',
	'review_user_reviews'                    => '<small>(ceppahuiliztli tlatēquitiltilīlli)</small>',
	'review_has_been_stored'                 => "<span id='review_has_been_stored'>¡Moceppahuiliz ōmopix!</span>",
	'revision_review_this_page_version_link' => 'Ticceppahuīz inīn zāzanilmachiyōtzin.',
	'review_page_review'                     => 'Ceppahuiliztli "$1" zāzaniltechcopa',
	'review_blocked'                         => 'Tehhuātl cah ōtzacuili, ¡xōx!',
	'review_topic'                           => 'Tlamantli',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'review_sidebar_title'                                   => 'Beoordelen',
	'review-desc'                                            => 'De wederopstanding van de [[Special:Review|waarderingsfunctie]]',
	'review_topics'                                          => "# The following is the list of topics and ranges for the review extension.
# Each topic is defined by a line of five values, separated by ':' (all other lines are ignored).
# The order is: numerical key (>0), name, max range (>1; 2=yes/no), meaning of lowest value (e.g., 'bad'), meaning of highest value (e.g., 'good').
1:Kwaliteit:5:slecht:goed
2:Klaar voor 1.0:2:nee:ja",
	'review_topic_page'                                      => 'Onderwerpen beoordelen',
	'review_sidebar_explanation'                             => "Het meest linkse vakje betekent altijd 'geen mening'.",
	'review_save'                                            => 'Beoordeling opslaan',
	'review_your_review'                                     => 'Uw beoordeling van deze pagina/versie:',
	'review_sidebar_you_have_other_reviews_for_this_article' => "U hebt al een beoordeling gedaan voor andere versies van deze pagina.
Uw andere waarderingen worden samengevoegd met deze waar u 'geen mening' hebt opgegeven.",
	'review_page_link'                                       => 'beoordelingsstatistieken',
	'review_sidebar_final'                                   => 'Zie $1 voor beoordelingsgegevens van deze pagina',
	'review_for_page'                                        => 'Beoordeling voor pagina "$1"',
	'review_for_user'                                        => 'Beoordeling voor gebruiker "$1"',
	'review_error'                                           => 'Er is iets niet in orde!',
	'review_no_reviews_for_page'                             => 'Er zijn op dit moment geen beoordelingen voor "$1".',
	'review_total_statistics'                                => 'Totaal',
	'review_statistics_left_corner'                          => 'Versie',
	'review_version_link'                                    => 'Versie #$1',
	'review_statistic_cell'                                  => 'Gemiddelde: $1 van $2<br />($4 gebruikers, $5 anomienen)',
	'review_version_statistic_cell'                          => '$1 van $2',
	'review_version_reviews_link'                            => '<small>(versiebeoordelingen)</small>',
	'review_concerns_page'                                   => 'Deze beoordeling gaat over de pagina "$1".',
	'review_concerns_user'                                   => 'Dit gaat over beoordelingen van gebruiker "$1".',
	'review_user_reviews'                                    => '<small>(beoordelingen van deze gebruiker)</small>',
	'review_user_page_list'                                  => "De gebruiker beoordeelde de volgende pagina's:",
	'review_user_details_link'                               => '(details)',
	'review_do_merge'                                        => 'Mijn beoordelingen van andere versies van deze pagina met deze versie samenvoegen',
	'review_has_been_stored'                                 => "<span id='review_has_been_stored'>Uw beoordeling is opgeslagen!</span>",
	'revision_review_this_page_version_link'                 => 'Deze versie van de pagina beoordelen.',
	'review_page_review'                                     => 'Beoordeling van pagina "$1"',
	'review_blocked'                                         => 'U bent geblokkeerd. Ga weg.',
	'review_wrong_namespace'                                 => "Pagina's in deze naamruimte kunnen niet beoordeeld worden!",
	'review_topic'                                           => 'Onderwerp',
	'review_no_opinion'                                      => 'Geen mening',
	'review_rating'                                          => 'Waardering',
	'review_comment'                                         => 'Opmerking',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'review_user_details_link' => '(detaljar)',
	'review_comment'           => 'Kommentar',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'review_sidebar_title'                                   => 'Gå gjennom',
	'review-desc'                                            => 'Den gjenoppståtte [[Special:Review|valideringsfunksjonen]].',
	'review_topics'                                          => '# Følgende er en liste over emner og verdier for valideringsutvidelse.
# Hvert emne defineres av en linje på fem verdier, skilt fra hverandre med «:» (alle andre linjer ignoreres).
# Rekkeølgen er: Numerisk verdi (>0), navn, maksimum verdi (>1; 2=yes/no), betydning av laveste verdi (f.eks. «dårlig»), betydning av høyeste verdi (f.eks. «bra»).
1:Kvalitet:5:dårlig:bra
2:Klar for 1.0:2:no:yes',
	'review_topic_page'                                      => 'Gjennomgangsemner',
	'review_sidebar_explanation'                             => 'Den venstre avmerkingsboksen betyr alltid «ingen mening».',
	'review_save'                                            => 'Lagre gjennomgang',
	'review_your_review'                                     => 'Din gjennomgang av denne siden/revisjonen:',
	'review_sidebar_you_have_other_reviews_for_this_article' => 'Du har allerede gått gjennom andre versjoner av denne siden. De andre vurderingene dine vil slås sammen med denne der du har valgt «ingen mening».',
	'review_page_link'                                       => 'gjennomgangsstatistikk',
	'review_sidebar_final'                                   => 'For gjennomgangsinformasjon om denne siden, se $1',
	'review_for_page'                                        => 'Gjennomgang av siden «$1»',
	'review_for_user'                                        => 'Gjennomgang av brukeren «$1»',
	'review_error'                                           => 'Noe er feil!',
	'review_no_reviews_for_page'                             => 'Det er ingen nåværende gjennomganger av «$1».',
	'review_total_statistics'                                => 'Totalt',
	'review_statistics_left_corner'                          => 'Revisjon',
	'review_version_link'                                    => 'Revisjon #$1',
	'review_statistic_cell'                                  => 'Gjennomsnitt: $1 av $2<br />($4 registrerte, $5 uregistrerte)',
	'review_version_statistic_cell'                          => '$1 av $2',
	'review_version_reviews_link'                            => '<small>(versjonsgjennomganger)</small>',
	'review_concerns_page'                                   => 'Denne gjennomgangen gjelder siden «$1».',
	'review_concerns_user'                                   => 'Dette er om gjennomganger av brukeren «$1».',
	'review_user_reviews'                                    => '<small>(gjennomganger av denne brukeren)</small>',
	'review_user_page_list'                                  => 'Brukeren har gjennomgått følgende sider:',
	'review_user_details_link'                               => '(detaljer)',
	'review_do_merge'                                        => 'Slå sammen mine gjennomganger av andre revisjoner av denne siden med denne',
	'review_has_been_stored'                                 => '<span id="review_has_been_stored">Gjennomgangen din har blitt lagret!</span>',
	'revision_review_this_page_version_link'                 => 'Gå gjennom denne versjonen av siden.',
	'review_page_review'                                     => 'Gjennomgang av siden «$1»',
	'review_blocked'                                         => 'Du er blokkert, gå vekk.',
	'review_wrong_namespace'                                 => 'Kan ikke gå gjennom sider i dette navnerommet.',
	'review_topic'                                           => 'Emne',
	'review_no_opinion'                                      => 'Ingen mening',
	'review_rating'                                          => 'Vurdering',
	'review_comment'                                         => 'Kommentar',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'review_total_statistics'       => 'Yohle',
	'review_statistics_left_corner' => 'Poeletšo',
	'review_version_link'           => 'Poeletšo #$1',
	'review_version_statistic_cell' => '$1 ya $2',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'review_sidebar_title'                                   => 'Revision',
	'review-desc'                                            => 'Torna aviar la foncionalitat de [[Special:Review|validacion]] d’un article.',
	'review_topics'                                          => "# Lista de subjèctes per l'extension « review » de MediaWiki. 
# .... 
# Cada subjècte es definit per una lista de donadas separadas per « : » (tota autra lista es ignorada).
# ....
# Las donadas dins l'òrdre son : ## identificant numeric (>0) ## nom ## espandida (>1) ## significacion de la valor mai pichona (ex. « marrit ») ## significacion de la valor mai granda (ex. « bon ») # .... # Per exemple, se cal solament causir « non » o « òc », l'espandida val 2. # Per exemple, se cal causir entre « mejancièr », « marrit », « de melhorar », « plan » o « fòrt plan », l'espandida val 5. # .... 1:Qualitat:5:marrit:bon 2:Prèst per 1.0:2:non:òc",
	'review_topic_page'                                      => 'Subjèctes a revision',
	'review_sidebar_explanation'                             => 'La bóstia de marcar a esquèrra tota significa totjorn « sens opinion ».',
	'review_save'                                            => 'Salvar la revision',
	'review_your_review'                                     => "Vòstra revision d'aquesta pagina o revision :",
	'review_sidebar_you_have_other_reviews_for_this_article' => "Ja avètz revisat las autras versions d'aquesta pagina. Vòstras autras evaluacions seràn fusionadas amb aquesta se avètz seleccionat « sens opinion ».",
	'review_page_link'                                       => 'Estatisticas de revisions',
	'review_sidebar_final'                                   => "Per veire las donadas de revision de la vista d'aquesta pagina, anatz a $1",
	'review_for_page'                                        => 'Revision per la pagina « $1 »',
	'review_for_user'                                        => 'Revision per contributor « $1 »',
	'review_error'                                           => 'Quicòm es copat!',
	'review_no_reviews_for_page'                             => 'I a pas de revisions per « $1 ».',
	'review_total_statistics'                                => 'Soma',
	'review_statistics_left_corner'                          => 'Revision',
	'review_version_link'                                    => 'Revision #$1',
	'review_statistic_cell'                                  => 'Mejana : $1 de $2<br />($4 utilizaires inscriches, $5 anonims)',
	'review_version_statistic_cell'                          => '$1 de $2',
	'review_version_reviews_link'                            => '<small>(revisions de version)</small>',
	'review_concerns_page'                                   => 'Aquesta revision es a prepaus de la pagina « $1 ».',
	'review_concerns_user'                                   => 'Es a prepaus de las revisions fachas pel contributor « $1 ».',
	'review_user_reviews'                                    => '<small>(revisions per aqueste contributor)</small>',
	'review_user_page_list'                                  => 'Lo contributor a revisat las paginas seguentas :',
	'review_user_details_link'                               => '(detalhs)',
	'review_do_merge'                                        => "Fusionar mos passatges en revista de las autras revisions d'aquesta pagina amb aquesta",
	'review_has_been_stored'                                 => "<span id='review_has_been_stored'>Vòstra revision es estada salvada.</span>",
	'revision_review_this_page_version_link'                 => 'Revisar aquesta version de la pagina',
	'review_page_review'                                     => 'Revision de la pagina « $1 »',
	'review_blocked'                                         => 'Sètz blocat(ada).',
	'review_wrong_namespace'                                 => 'Las paginas dins aqueste espaci de nom pòdon pas èsser revisadas.',
	'review_topic'                                           => 'Subjècte',
	'review_no_opinion'                                      => 'Sens opinion',
	'review_rating'                                          => 'Evaluacion',
	'review_comment'                                         => 'Comentari',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'review_sidebar_title'                   => 'oceń',
	'review-desc'                            => 'Narzędzie ponownej [[Special:Review|oceny]] artykułów.',
	'review_topic_page'                      => 'Oceniane tematy',
	'review_save'                            => 'Zapisz ocenę',
	'review_your_review'                     => 'Twoja ocena tej strony lub wersji',
	'review_page_link'                       => 'statystyka oceniania',
	'review_for_page'                        => 'Ocena strony „$1”',
	'review_for_user'                        => 'Ocena artykułów użytkownika „$1”',
	'review_error'                           => 'Wystąpił błąd!',
	'review_no_reviews_for_page'             => 'Brak obecnie recenzji dla artykułu „$1”.',
	'review_total_statistics'                => 'Podsumowanie',
	'review_statistics_left_corner'          => 'Wersja',
	'review_version_link'                    => 'Wersja $1',
	'review_statistic_cell'                  => 'Średnia: $1 z $2<br />($4 zalogowanych, $5 anonimowych)',
	'review_version_statistic_cell'          => '$1 lub $2',
	'review_version_reviews_link'            => '<small>(recenzje tej wersji)</small>',
	'review_concerns_page'                   => 'Ta recenzja dotyczy strony „$1”.',
	'review_concerns_user'                   => 'O recenzjach wykonanych przez użytkownika „$1”.',
	'review_user_reviews'                    => '<small>(recenzje tego użytkownika)</small>',
	'review_user_page_list'                  => 'Użytkownik recenzował następujące strony:',
	'review_user_details_link'               => '(szczegóły)',
	'review_do_merge'                        => 'Połącz moją recenzję z innymi recenzjami tej strony',
	'review_has_been_stored'                 => "<span id='review_has_been_stored'>Twoja recenzja została zapisana!</span>",
	'revision_review_this_page_version_link' => 'Recenzuj tą wersję strony.',
	'review_page_review'                     => 'Recenzja strony „$1”',
	'review_blocked'                         => 'Zostałeś zablokowany.',
	'review_wrong_namespace'                 => 'Strony w tej przestrzeni nazw nie mogą być recenzowane!',
	'review_topic'                           => 'Temat',
	'review_no_opinion'                      => 'Brak opinii',
	'review_rating'                          => 'Ocena',
	'review_comment'                         => 'Komentarz',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'review_sidebar_title'     => 'مخکتنه',
	'review_total_statistics'  => 'ټولټال',
	'review_user_details_link' => '(تفصيل)',
);

/** Portuguese (Português)
 * @author Malafaya
 * @author Lijealso
 */
$messages['pt'] = array(
	'review_error'                  => 'Algo está errado!',
	'review_total_statistics'       => 'Total',
	'review_statistics_left_corner' => 'REvisão',
	'review_version_link'           => 'Revisão #$1',
	'review_statistic_cell'         => 'Média: $1 de $2<br />($4 utilizadores, $5 anónimos)',
	'review_version_statistic_cell' => '$1 de $2',
	'review_user_details_link'      => '(detalhes)',
	'review_has_been_stored'        => "<span id='review_has_been_stored'>A sua revisão analisada foi guardada!</span>",
	'review_topic'                  => 'Tópico',
	'review_no_opinion'             => 'Sem opinião',
	'review_comment'                => 'Comentário',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'review_total_statistics'  => 'Total',
	'review_user_details_link' => '(detalii)',
	'review_comment'           => 'Comentariu',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'review_sidebar_title'                                   => 'Оценка',
	'review-desc'                                            => 'Возрождённая функция [[Special:Review|оценки]]',
	'review_topics'                                          => '# Ниже представлен список тем и диапазонов для расширения оценки.
# Каждая тема определяется в строке из пяти значений, разделённых «:» (все другие строки игнорируются).
# Порядок следующий: числовой ключ (>0), имя, максимальное значение (>1; 2=yes/no), описание низшего значения (например, «плохая»), описание высшего значения (например, «хорошая»).
1:Quality:5:bad:good
2:Ready for 1.0:2:no:yes',
	'review_topic_page'                                      => 'Оценка по критериям',
	'review_sidebar_explanation'                             => 'Левое значение всегда означает «нет мнения».',
	'review_save'                                            => 'Сохранить оценку',
	'review_your_review'                                     => 'Ваша оценка этой страницы или версии:',
	'review_sidebar_you_have_other_reviews_for_this_article' => 'Вы уже оценивали другие версии этой страницы. Ваши другие оценки будут объединены с текущими там, где вы указали «нет мнения».',
	'review_page_link'                                       => 'статистике оценок',
	'review_sidebar_final'                                   => 'Результаты см. в $1',
	'review_for_page'                                        => 'Оценка страницы «$1»',
	'review_for_user'                                        => 'Оценки участника «$1»',
	'review_error'                                           => 'Что-то неправильно!',
	'review_no_reviews_for_page'                             => 'Сейчас нет оценок для «$1».',
	'review_total_statistics'                                => 'Всего',
	'review_statistics_left_corner'                          => 'Версия',
	'review_version_link'                                    => 'Версия #$1',
	'review_statistic_cell'                                  => 'Среднее: $1 из $2<br />($4 участ., $5 анонимов)',
	'review_version_statistic_cell'                          => '$1 из $2',
	'review_version_reviews_link'                            => '<small>(оценки версий)</small>',
	'review_concerns_page'                                   => 'Это оценка страницы «$1».',
	'review_concerns_user'                                   => 'Это об оценках участника «$1».',
	'review_user_reviews'                                    => '<small>(оценки этого участника)</small>',
	'review_user_page_list'                                  => 'Участник оценил следующие страницы:',
	'review_user_details_link'                               => '(подробности)',
	'review_do_merge'                                        => 'Перенести мои оценки других версий этой страницы на эту версию',
	'review_has_been_stored'                                 => "<span id='review_has_been_stored'>Ваша оценка сохранена!</span>",
	'revision_review_this_page_version_link'                 => 'Оценить эту версию страницы.',
	'review_page_review'                                     => 'Оценка страницы «$1»',
	'review_blocked'                                         => 'Вы заблокированы, уходите.',
	'review_wrong_namespace'                                 => 'Страницы в этом пространстве имён не могут быть оценены!',
	'review_topic'                                           => 'Категория',
	'review_no_opinion'                                      => 'Нет мнения',
	'review_rating'                                          => 'Оценка',
	'review_comment'                                         => 'Примечание',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'review_sidebar_title'                                   => 'Kontrola',
	'review-desc'                                            => 'Oživená možnosť [[Special:Review|overovania]].',
	'review_topics'                                          => '# Toto je zoznam téma a rozsahov rozšírenia Kontrola (Review)
# Každú tému definuje riadok s piatimi hodnotami oddelenými „:“ (všetky ostatné riadky sú ignorované).
# Poradie je: číselný kľúč (>0), názov, max. rozsah (>1; 2=áno/nie), význam najnižšej hodnoty (napr., „zlý“), význam najvyššej hodnoty (napr., „dobrý“).
1:Kvalita:5:zlá:dobrá
2:Vhodný do 1.0:2:nie:áno',
	'review_topic_page'                                      => 'Kontrola tém',
	'review_sidebar_explanation'                             => 'Zaškrtávacie pole vľavo vždy znamená „bez názoru“.',
	'review_save'                                            => 'Uložiť kontrolu',
	'review_your_review'                                     => 'Vaša kontrola tejto stránky/revízie:',
	'review_sidebar_you_have_other_reviews_for_this_article' => 'Už ste vykonali kontrolu iných verzií tejto stránky. Vaše ostatné hodnotenia sa zlúčia do tohto, kde ste vybrali „bez názoru“.',
	'review_page_link'                                       => 'štatistika kontroly',
	'review_sidebar_final'                                   => 'Údaje o kontrole tejto stránky, pozri $1',
	'review_for_page'                                        => 'Kontrola stránky „$1“',
	'review_for_user'                                        => 'Kontrola používateľa „$1“',
	'review_error'                                           => 'Niečo nie je v poriadku!',
	'review_no_reviews_for_page'                             => '„$1“ zatiaľ nebola skontrolovaná.',
	'review_total_statistics'                                => 'Celkom',
	'review_statistics_left_corner'                          => 'Revízia',
	'review_version_link'                                    => 'Revízia #$1',
	'review_statistic_cell'                                  => 'Priemer: $1 z $2<br />($4 používateľov, $5 anonymov)',
	'review_version_statistic_cell'                          => '$1 z $2',
	'review_version_reviews_link'                            => '<small>(kontroly verzie)</small>',
	'review_concerns_page'                                   => 'Toto je kontrola stránky „$1“.',
	'review_concerns_user'                                   => 'Toto je o kontrolách od používateľa „$1“.',
	'review_user_reviews'                                    => '<small>(kontroly od tohto používateľa)</small>',
	'review_user_page_list'                                  => 'Tento používateľ kontroloval nasledovné stránky:',
	'review_user_details_link'                               => '(podrobnosti)',
	'review_do_merge'                                        => 'Zlúčiť moje kontroly iných revízií tejto stránky do tejto',
	'review_has_been_stored'                                 => "<span id='review_has_been_stored'>Vaša kontrola bola uložená!</span>",
	'revision_review_this_page_version_link'                 => 'Skontrolovať túto verziu stránky.',
	'review_page_review'                                     => 'Kontrola stránky „$1“',
	'review_blocked'                                         => 'Ste zablokovaný, choďte preč.',
	'review_wrong_namespace'                                 => 'Stránky v tomto mennom priestore nemožno kontrolovať!',
	'review_topic'                                           => 'Téma',
	'review_no_opinion'                                      => 'bez názoru',
	'review_rating'                                          => 'Hodnotenie',
	'review_comment'                                         => 'Komentár',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Sasa Stefanovic
 */
$messages['sr-ec'] = array(
	'review_comment' => 'Коментар',
);

/** Swedish (Svenska)
 * @author M.M.S.
 */
$messages['sv'] = array(
	'review_sidebar_title'                                   => 'Granska',
	'review-desc'                                            => 'Den återupplivade [[Special:Review|kontrolleringsfunktionen]].',
	'review_topics'                                          => '# Följande är listan över ämnen och rankningar för kontrolleringstillägget.
# Varje ämne definieras av en linje på fem värden, skiljt från varandra med ":" (alla andra linjer ignoreras).
# Följden är: numeriskt värde (>0), namn, maximalt värde (>1; 2=yes/no), betydelsen av de lägsta värdena (t.ex. "dålig"), betydelse av högsta värde (t.ex. "bra").
1:Kvalitet:5:dålig:bra
2:Klar för 1.0:2:no:yes',
	'review_topic_page'                                      => 'Granska ämnen',
	'review_sidebar_explanation'                             => 'Den vänstra kryssrutan betyder alltid "ingen mening".',
	'review_save'                                            => 'Spara granskning',
	'review_your_review'                                     => 'Din granskning av den här sidan/versionen:',
	'review_sidebar_you_have_other_reviews_for_this_article' => 'Du har redan granskat andra versioner av den här sidan. Dina andra värderingar kommer slås samman med denna när du har väljt "ingen mening".',
	'review_page_link'                                       => 'granska statistik',
	'review_sidebar_final'                                   => 'För granskningsdata om den här sidan, se $1',
	'review_for_page'                                        => 'Granskning av sidan "$1"',
	'review_for_user'                                        => 'Granskning av användaren "$1"',
	'review_error'                                           => 'Något är fel!',
	'review_no_reviews_for_page'                             => 'Den finns just nu inga granskningar av "$1".',
	'review_total_statistics'                                => 'Total',
	'review_statistics_left_corner'                          => 'Revision',
	'review_version_link'                                    => 'Revision #$1',
	'review_statistic_cell'                                  => 'Genomsnitt: $1 av $2<br />($4 registrerade, $5 andra)',
	'review_version_statistic_cell'                          => '$1 av $2',
	'review_version_reviews_link'                            => '<small>(versionsgranskningar)</small>',
	'review_concerns_page'                                   => 'Den här granskningen gäller sidan "$1".',
	'review_concerns_user'                                   => 'Den här är om granskningar av användaren "$1".',
	'review_user_reviews'                                    => '<small>(granskningar av den här användaren)</small>',
	'review_user_page_list'                                  => 'Användaren har granskat följande sidor:',
	'review_user_details_link'                               => '(detaljer)',
	'review_do_merge'                                        => 'Slå ihop mina granskningar av andra versioner av den här sidan med denna',
	'review_has_been_stored'                                 => '<span id="review_has_benn_stored">Din granskning har sparats!</span>',
	'revision_review_this_page_version_link'                 => 'Granska den här versionen av sidan.',
	'review_page_review'                                     => 'Granskning av sidan "$1"',
	'review_blocked'                                         => 'Du är blockerad, gå bort.',
	'review_wrong_namespace'                                 => 'Sidor i den här namnrymden kan inte granskas!',
	'review_topic'                                           => 'Ämne',
	'review_no_opinion'                                      => 'Ingen mening',
	'review_rating'                                          => 'Värdering',
	'review_comment'                                         => 'Kommentar',
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 */
$messages['szl'] = array(
	'review_total_statistics' => 'Do kupy',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'review_sidebar_title'                   => 'సమీక్ష',
	'review_topic_page'                      => 'విషయాలని సమీక్షించండి',
	'review_save'                            => 'సమీక్షని భద్రపరచు',
	'review_your_review'                     => 'ఈ పేజీ/కూర్పు పై మీ సమీక్ష:',
	'review_page_link'                       => 'సమీక్షా గణాంకాలు',
	'review_for_page'                        => '"$1" అనే పేజీకై సమీక్ష',
	'review_for_user'                        => '"$1" అనే వాడుకరికై సమీక్ష',
	'review_error'                           => 'ఏదో తప్పు జరిగింది!',
	'review_no_reviews_for_page'             => '"$1"కి ప్రస్తుతం సమీక్షలు లేవు.',
	'review_total_statistics'                => 'మొత్తం',
	'review_statistics_left_corner'          => 'కూర్పు',
	'review_version_link'                    => 'కూర్పు #$1',
	'review_statistic_cell'                  => 'సగటు: $2 లో $1 <br />($4 వాడుకరులు, $5 అనామకులు)',
	'review_version_reviews_link'            => '<small>(కూర్పు సమీక్షలు)</small>',
	'review_concerns_page'                   => 'ఈ సమీక్ష "$1" అనే పేజీ గురించి.',
	'review_user_reviews'                    => '<small>(ఈ వాడుకరి చేసిన సమీక్షలు)</small>',
	'review_user_page_list'                  => 'ఆ వాడుకరి ఈ క్రింద పేర్కొన్న పేజీలను సమీక్షించారు:',
	'review_user_details_link'               => '(వివరాలు)',
	'review_has_been_stored'                 => "<span id='review_has_been_stored'>మీ సమీక్ష భద్రమయ్యింది!</span>",
	'revision_review_this_page_version_link' => 'పేజీ యొక్క ఈ కూర్పుని సమీక్షించండి.',
	'review_page_review'                     => '"$1" పేజీ యొక్క సమీక్ష',
	'review_blocked'                         => 'మిమ్మల్ని నిరోధించారు, వెళ్ళిపోండి.',
	'review_topic'                           => 'విషయం',
	'review_no_opinion'                      => 'అభిప్రాయం లేదు',
	'review_rating'                          => 'రేటింగు',
	'review_comment'                         => 'వ్యాఖ్య',
);

/** Tajik (Cyrillic) (Тоҷикӣ/tojikī (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'review_sidebar_title'          => 'Пешнамоиш',
	'review_topic_page'             => 'Бозбинии унвонҳо',
	'review_save'                   => 'Захираи натиҷаи бозбини',
	'review_page_link'              => 'омори бозбиниҳо',
	'review_version_statistic_cell' => '$1 аз $2',
	'review_blocked'                => 'Шумо баста шудаед, равед.',
	'review_comment'                => 'Тавзеҳ',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'review_sidebar_title'                                   => 'Duyệt',
	'review-desc'                                            => 'Tính năng [[Special:Review|phê chuẩn]] được phục hồi.',
	'review_topics'                                          => "# Dưới đây là danh sách các chủ đề và tầm vực của gói mở rộng duyệt bài.
# Mỗi chủ đề được định nghĩa bằng một dòng năm giá trị, cách nhau bởi      Normal   0               false   false   false      EN-US   JA   X-NONE                                                         MicrosoftInternetExplorer4                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     ‘:’  (tất cả những dòng khác được bỏ qua).
# Thứ tự là: khóa số (>0), tên, tầm lớn nhất (>1; 2=có/không), ý nghĩa của giá trị nhỏ nhất (ví dụ, 'tồi'), ý nghĩa của giá trị cao nhất (ví dụ, 'tốt').
1:Chất lượng:5:tồi:tốt
2:Sẵn sàng cho 1.0:2:không:có",
	'review_topic_page'                                      => 'Duyệt chủ đề',
	'review_sidebar_explanation'                             => 'Hộp kiểm ngoài cùng bên trái luôn có nghĩa là      Normal   0               false   false   false      EN-US   JA   X-NONE                                                         MicrosoftInternetExplorer4                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     ‘không có ý kiến’.',
	'review_save'                                            => 'Lưu trữ duyệt bài',
	'review_your_review'                                     => 'Lần duyệt trang/phiên bản này của bạn:',
	'review_sidebar_you_have_other_reviews_for_this_article' => 'Bạn đã duyệt những phiên bản khác của trang này. Những xếp hạng khác của bạn sẽ được trộn vào cái này nếu bạn chọn ‘không có ý kiến’.',
	'review_page_link'                                       => 'thống kê duyệt bài',
	'review_sidebar_final'                                   => 'Đối với dữ liệu duyệt của trang này, xem $1 của nó',
	'review_for_page'                                        => 'Duyệt trang "$1"',
	'review_for_user'                                        => 'Duyệt thành viên "$1"',
	'review_error'                                           => 'Có gì đó bị sai!',
	'review_no_reviews_for_page'                             => 'Hiện không có lần duyệt nào cho "$1".',
	'review_total_statistics'                                => 'Tổng cộng',
	'review_statistics_left_corner'                          => 'Phiên bản',
	'review_version_link'                                    => 'Phiên bản #$1',
	'review_statistic_cell'                                  => 'Trung bình: $1 của $2<br />($4 thành viên, $5 vô danh)',
	'review_version_statistic_cell'                          => '$1 trong $2',
	'review_version_reviews_link'                            => '<small>(duyệt phiên bản)</small>',
	'review_concerns_page'                                   => 'Lần duyệt này là về trang "$1".',
	'review_concerns_user'                                   => 'Đây là về lần duyệt của thành viên "$1".',
	'review_user_reviews'                                    => '<small>(duyệt bởi thành viên này)</small>',
	'review_user_page_list'                                  => 'Thành viên đã duyệt những trang sau:',
	'review_user_details_link'                               => '(chi tiết)',
	'review_do_merge'                                        => 'Trộn những lần duyệt các phiên bản của trang này của tôi vào cái này',
	'review_has_been_stored'                                 => "<span id='review_has_been_stored'>Lần duyệt của bạn đã được lưu!</span>",
	'revision_review_this_page_version_link'                 => 'Duyệt phiên bản này của trang.',
	'review_page_review'                                     => 'Duyệt trang "$1"',
	'review_blocked'                                         => 'Bạn đã bị cấm, hãy rời khỏi đây.',
	'review_wrong_namespace'                                 => 'Những trang trong không gian tên này không thể duyệt được!',
	'review_topic'                                           => 'Chủ đề',
	'review_no_opinion'                                      => 'Không có ý kiến',
	'review_rating'                                          => 'Xếp hạng',
	'review_comment'                                         => 'Bình luận',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Alexsh
 */
$messages['zh-hant'] = array(
	'review_total_statistics' => '總數',
);

