<?php

/**
 * Internationalization for Answer extension
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
 */

$messages = array();

$messages['en'] = array(
	'answer_title' => 'Answer',
	'answered_by' => 'Answered by',
	'unregistered' => 'Unregistered',
	'anonymous_edit_points' => '$1 {{PLURAL:$1|helper|helpers}}',
	'edit_points' => '{{PLURAL:$1|edit point|edit points}}',
	'ask_a_question' => 'Ask a question...',
	'ask_a_question-widget' => 'Ask a question...',
	'in_category' => '...in category',
	'ask_button' => 'Ask',
	'ask_thanks' => 'Thanks for the rockin\' question!',
	'question_asked_by' => 'Question asked by',
	'question_asked_by_a_wikia_user' => 'Question asked by a Wikia user',
	'new_question_comment' => 'new question',
	'answers_toolbox' => 'Wikianswers toolbox',
	'improve_this_answer' => 'Improve this answer',
	'answer_this_question' => 'Answer this question',
	'notify_improved' => 'Email me when improved',
	'research_this' => 'Research this',
	'notify_answered' => 'Email me when answered',
	'recent_asked_questions' => 'Recently Asked Questions',
	'recent_answered_questions' => 'Recently Answered Questions',
	'recent_edited_questions' => 'Recently Edited Questions',
	'unanswered_category' => 'Un-answered questions',
	'answered_category' => 'Answered questions',
	'related_questions' => 'Related questions',
	'related_answered_questions' => 'Related answered questions',
	'recent_unanswered_questions' => 'Recent Unanswered Questions',
	'popular_categories' => 'Popular Categories',
	'createaccount-captcha' => 'Please type the word below',
	'inline-register-title' => 'Notify me when my question is answered!',
	'inline-welcome' => 'Welcome to Wikianswers',
	'skip_this' => 'Skip this',
	'see_all_changes' => 'See all changes',
	'toolbox_anon_message' => '<i>"Wikianswers leverages the unique characterstics of a wiki to form the very best answers to any question."</i><br /><br /> <b>Jimmy Wales</b><br /> founder of Wikipedia and Wikianswers',
	'no_questions_found' => 'No questions found',
	'widget_settings'	=> 'Question Settings',
	'style_settings'	=> 'Style Settings',
	'get_widget_title' => 'Add Questions to your site',
	'background_color' => 'Background color',
	'widget_category' => 'Type of Questions',
	'category' => 'Category Name',
	'custom_category' => 'Custom Category',
	'number_of_items' => 'Number of items to show',
	'width'		=> 'Width',
	'next_page'		=> 'Next &raquo;',
	'prev_page'		=> '&laquo; Prev',
	'see_all'		=> 'See all',
	'get_code'	=> 'Grab Code',
	'link_color'	=> 'Question Link Color',
	'widget_order' => 'Question Order',
	'widget_ask_box' => 'Include ask box',
	'question_redirected_help_page' => 'Why was my question redirected here',
	'twitter_hashtag' => 'wikianswers',
	'twitter_ask' => 'Ask on Twitter',
	'facebook_ask' => 'Ask on Facebook',
	'facebook_send_request' => 'Send Directly to Friends',
	'ask_friends' => 'Ask your friends to help answer:',
	'facebook_send_request_content' => 'Can you help answer this? $1',
	'facebook_signed_in' => 'You are signed into Facebook Connect',
	'ads_by_google' => 'Ads by Google',
	'magic_answer_headline' => 'Does this answer your question?',
	'magic_answer_yes' => 'Yes, use this as a starting point',
	'magic_answer_no' => 'No, don\'t use this',
	'magic_answer_credit' => 'Provided by Yahoo Answers',
	'rephrase' => 'Rephrase this question',
	'rephrase_this' => '<a href="$1" $2>Reword the question</a>',
	'question_not_answered' => 'This question has not been answered',
	'you_can' => 'You can:',
	'answer_this' => '<a href="$1">Answer this question</a>, even if you don\'t know the whole answer',
	'research_this_on_wikipedia' => '<a href="$1">Research this question</a> on Wikipedia',
	'receive_email' => '<a href="$1" $2>Receive an email</a> when this question is answered',
	'ask_friends_on_twitter' => 'Ask Friends on <a href="$1" $2>Twitter</a>',
	'quick_action_panel' => 'Quick Action Panel',
	'categorize' => 'Categorize',
	'categorize_help' => 'One category per line',
	'answers_widget_admin_note' => '<b>Admins:</b> If you\'d like to be an admin on <a href="http://answers.wikia.com" target="_blank">Wikianswers</a>, <a href="http://answers.wikia.com/wiki/Wikianswers:Become_an_admin" target="_blank">click here</a>.',
	'answers_widget_user_note' => 'Can you help by becoming a <a href="http://answers.wikia.com/wiki/Wikianswers:Sign_up_for_a_category" target="_blank">category editor</a> on <a href="http://answers.wikia.com" target="_blank">Wikianswers</a>?',
	'answers_widget_anon_note' => '<a href="http://answers.wikia.com" target="_blank">Wikianswers</a> is a Q&amp;A wiki where answers are improved, wiki-style.',
	'answers-category-count-answered' => 'This category contains $1 answered questions.',
	'answers-category-count-unanswered' => 'This category contains $1 unanswered questions.',
	'answers_widget_no_questions' => '<a href="http://answers.wikia.com" target="_blank">Wikianswers</a> is a site where you can ask questions and contribute answers. We\'re aiming to create the best answer to any question. <a href="http://answers.wikia.com/wiki/Special:Search" target="_blank">Find</a> and answer <a href="http://answers.wikia.com/wiki/Category:Un-answered_questions">unanswered</a> questions. It\'s a wiki - so be bold!',
	'answers_widget_no_questions_askabout' => '<br /><br />Get started by asking a question about "{{PAGENAME}}"',
	'reword_this' => '<a href="$1" $2>Reword this question</a> ',
	'no_related_answered_questions' => 'There are no related questions yet. Get a <a href="http://answers.wikia.com/wiki/Special:Randomincategory/answered_questions">random answered question instead</a>, or ask a new one!<br />
	<div class="createbox" align="center">
	<p></p><form name="createbox" action="/index.php" method="get" class="createboxForm">
	<input name="action" value="create" type="hidden">
	<input name="prefix" value="Special:CreateQuestionPage/" type="hidden">
	<input name="editintro" value="" type="hidden">
	<input class="createboxInput" name="title" value="" size="50" type="text">
	<input name="create" class="createboxButton" value="Type your question and click here" type="submit"></form></div>',
	'auto_friend_request_body' => 'Will you add me as a friend?',
	'tog-hidefromattribution' => 'Hide my avatar and name from attribution list',
	'q' => '<!-- -->',
	'a' => 'Answer:',
	'?' => '?',
	'answering_tips' => "<h3>Tips for answering:</h3> When contributing an answer, try to be as accurate as you can. If you're getting information from another source such as Wikipedia, put a link to this in the text. And thank you for contributing to {{SITENAME}}!",
	'header_questionmark_pre' => '',
	'header_questionmark_post' => '?',
	'plus_x_more_helpers' => '... plus $1 more helpers',
	'answer_this_question' => 'Answer this question:',
	'plus_x_more_helpers' => '... plus $1 more helpers',
	'answer_this_question' => 'Answer this question:',
	'anwb-step1-headline' => 'What\'s your wiki about?',
	'anwb-step1-text' => 'Your Wikianswers site needs a <strong>tagline</strong>.<br /><br />Your tagline will help people find your site from search engines, so try to be clear about what your site is about.',
	'anwb-step1-example' => 'Answers for all your pro-wrestling questions!',
	'anwb-choose-logo' => 'Choose your logo',
	'anwb-step2-text' => 'Next, choose a logo for {{SITENAME}}. It\'s best to upload a picture that you think represents your Answers site.<br />You can skip this step if you don\'t want to do it right now.<br /><br />',
	'anwb-step2-example' => 'This would be a good logo for a skateboarding answers site.',
	'anwb-fp-headline' => 'Create some questions!',
	'anwb-fp-text' => 'Your Answers site should start off with some questions!<br /><br />Add a list of questions, and then provide the answers yourself. It\'s important to get some useful information on the site, so people can find it and ask and answer even more questions.',
	'anwb-fp-example' => '<strong>Example</strong><br /><br />For a pet care answers site:<br /><br /><ul><li>Should I buy cat litter?</li><li>What\'s the best breed of dog?</li><li>What\'s the best way to train a cat?</li><li></ul><br /><br />For a health care answers site:<br /><br /><ul><li>What are the health benefits of exercise?</li><li>How can I find a good doctor in my area?</li><li>How can I lose weight easily?</li></ul>',
	'nwb-thatisall-headline' => 'That\'s it - you\'re done!',
	'anwb-thatisall-text' => 'That\'s it - you\'re ready to roll!<br /><br />Now it\'s time to start writing more questions and answers, so that your site can be found more easily in search engines.<br /><br />The list of questions added in the last step has been put into your questions site. Head in to answer your questions, and start your own answers community!',
	'anwb-logo-preview' => 'Here\'s a preview of your logo',
	'anwb-save-tagline' => 'Save tagline',
	'badWords' => 'fuck', // testing a bug

	// toolbox
	'qa-toolbox-button' => 'Answer a random question',
	'qa-toolbox-share' => 'Share',
	'qa-toolbox-tools' => 'Advanced tools»',
	'qa-toolbox-protect' => 'Protect this question',
	'qa-toolbox-delete' => 'Delete this question',
	'qa-toolbox-history' => 'Past versions of this page',
	'qa-featured-sites' => '-',

	// Skin Chooser
	'answers_skins' => 'Answers',
	'answers-bluebell' => 'Bluebell',
	'answers-leaf' => 'Leaf',
	'answers-carnation' => 'Carnation',
	'answers-sky' => 'Sky',
	'answers-spring' => 'Spring',
	'answers-forest' => 'Forest',
	'answers-moonlight' => 'Moonlight',
	'answers-carbon' => 'Carbon',
	'answers-obsession' => 'Obsession',
	'answers-custom' => 'Custom',
);

/** Message documentation (Message documentation)
 * @author Siebrand
 */
$messages['qqq'] = array(
	'answers-category-count-answered' => 'Parameters:
* $1 is the number of answered questions.',
	'answers-category-count-unanswered' => 'Parameters:
* $1 is the number of unanswered questions.',
);

/** Afrikaans (Afrikaans) */
$messages['af'] = array(
	'research_this' => 'Vors dit na',
);

/** Breton (Brezhoneg) */
$messages['br'] = array(
	'research_this' => 'Klask-se',
);

/** German (Deutsch) */
$messages['de'] = array(
	'research_this' => 'Das hier recherchieren',
);

/** Greek (Ελληνικά) */
$messages['el'] = array(
	'research_this' => 'Αναζητήστε αυτό',
);

/** Spanish (Español) */
$messages['es'] = array(
	'research_this' => 'Investigar esto',
);

/** Finnish (Suomi) */
$messages['fi'] = array(
	'research_this' => 'Tutki tätä',
);

/** French (Français) */
$messages['fr'] = array(
	'research_this' => 'Rechercher ceci',
);

/** Galician (Galego) */
$messages['gl'] = array(
	'research_this' => 'Pescudar isto',
);

/** Hungarian (Magyar) */
$messages['hu'] = array(
	'research_this' => 'Kutatás ez után',
);

/** Interlingua (Interlingua) */
$messages['ia'] = array(
	'research_this' => 'Recercar isto',
);

/** Japanese (日本語) */
$messages['ja'] = array(
	'research_this' => 'この質問について調べる',
);

/** Luxembourgish (Lëtzebuergesch) */
$messages['lb'] = array(
	'research_this' => 'Dëst nosichen',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'answer_title' => 'Одговори',
	'answered_by' => 'Одговорено од',
	'unregistered' => 'Нерегистрирани',
	'anonymous_edit_points' => '$1 {{PLURAL:$1|помошник|помошници}}',
	'edit_points' => '{{PLURAL:$1|уреднички бод|уреднички бодови}}',
	'ask_a_question' => 'Постави прашање...',
	'ask_a_question-widget' => 'Постави прашање...',
	'in_category' => '...во категоријата',
	'ask_button' => 'Прашај',
	'ask_thanks' => 'Фала за феноменалното прашање!',
	'question_asked_by' => 'Прашања го поставил',
	'question_asked_by_a_wikia_user' => 'Прашањето го поставил корисник на Викија',
	'new_question_comment' => 'ново прашање',
	'answers_toolbox' => 'Алатник на Викиодговори',
	'improve_this_answer' => 'Подобри го одговорот',
	'answer_this_question' => 'Одогворете го прашањево:',
	'notify_improved' => 'Испрати ми е-пошта кога ќе се подобри',
	'research_this' => 'Истражи го ова',
	'notify_answered' => 'Испрати ми е-пошта кога ќе добие одговор',
	'recent_asked_questions' => 'Неодамна поставени прашања',
	'recent_answered_questions' => 'Неодамна одговорени прашања',
	'recent_edited_questions' => 'Неодамна уредени прашања',
	'unanswered_category' => 'Неодговорени прашања',
	'answered_category' => 'Одговорени прашања',
	'related_questions' => 'Поврзани прашања',
	'related_answered_questions' => 'Поврзани одговорени прашања',
	'recent_unanswered_questions' => 'Поврзани неодговорени прашања',
	'popular_categories' => 'Популарни категории',
	'createaccount-captcha' => 'Внесете го зборот подолу',
	'inline-register-title' => 'Извести ме кога моето прашање ќе добие одговор!',
	'inline-welcome' => 'Добредојдовте на Викиодговори',
	'skip_this' => 'Прескокни',
	'see_all_changes' => 'Сите промени',
	'toolbox_anon_message' => '<i>„Викиодговори ги користи уникатните карактеристики на викито за да оформи најдобри одговори на прашањата.“</i><br /><br /> <b>Џими Велс</b><br /> основач на Википедија и Викиодговори',
	'no_questions_found' => 'Не пронајдов ниедно прашање',
	'widget_settings' => 'Нагодувања за прашањата',
	'style_settings' => 'Нагодувања на стилот',
	'get_widget_title' => 'Додајте прашања на вашата страница',
	'background_color' => 'Боја на позадината',
	'widget_category' => 'Тип на прашања',
	'category' => 'Назив на категорија',
	'custom_category' => 'Прилагодена категорија',
	'number_of_items' => 'Број на ставки за прикажување',
	'width' => 'Ширина',
	'next_page' => 'След &raquo;',
	'prev_page' => '&laquo; Прет',
	'see_all' => 'Сите',
	'get_code' => 'Преземи код',
	'link_color' => 'Боја на врската на прашањето',
	'widget_order' => 'Редослед на прашањата',
	'widget_ask_box' => 'Вклучи поле за поставање прашање',
	'question_redirected_help_page' => 'Зошто ми е преместено прашањето тука',
	'twitter_hashtag' => 'викиодговори',
	'twitter_ask' => 'Постави на Twitter',
	'facebook_ask' => 'Постави на Facebook',
	'facebook_send_request' => 'Испрати директно на пријателите',
	'ask_friends' => 'Побарајте помош од пријателите:',
	'facebook_send_request_content' => 'Можеш да ми помогнеш да го одговориме ова? $1',
	'facebook_signed_in' => 'Не сте најавени на Facebook Connect',
	'ads_by_google' => 'Реклами од Google',
	'magic_answer_headline' => 'Дали ова е соодветен одговор на вашето прашање?',
	'magic_answer_yes' => 'Да, употреби го како почетна точка',
	'magic_answer_no' => 'Не, не го користи',
	'magic_answer_credit' => 'Овозможено од Yahoo Answers',
	'rephrase' => 'Преформулирај го прашањево',
	'rephrase_this' => '<a href="$1" $2>Преформулирај го прашањето</a>',
	'question_not_answered' => 'Ова прашање не е одговорено',
	'you_can' => 'Можете да:',
	'answer_this' => '<a href="$1">Одговорете го прашањето</a>, дури и да не знаете да одговорите целосно',
	'research_this_on_wikipedia' => '<a href="$1">Истражете за прашањево</a> на Википедија',
	'receive_email' => '<a href="$1" $2>Испрати е-пошта</a> кога прашањево ќе добие одговор',
	'ask_friends_on_twitter' => 'Прашај пријатели на <a href="$1" $2>Twitter</a>',
	'quick_action_panel' => 'Табла за брзи постапки',
	'categorize' => 'Категоризирај',
	'categorize_help' => 'По една категорија во секој ред',
	'answers_widget_admin_note' => '<b>Администратори:</b> Ако сакате да станете администратор на <a href="http://answers.wikia.com?uselang=mk" target="_blank">Викиодговори</a>, <a href="http://answers.wikia.com/wiki/Wikianswers:Become_an_admin?uselang=mk" target="_blank">стиснете тука</a>.',
	'answers_widget_user_note' => 'Можете ли да ни помогнете со тоа што ќе станете <a href="http://answers.wikia.com/wiki/Wikianswers:Sign_up_for_a_category?uselang=mk" target="_blank">уредник на категории</a> на <a href="http://answers.wikia.com?uselang=mk" target="_blank">Викиодговори</a>?',
	'answers_widget_anon_note' => '<a href="http://answers.wikia.com?uselang=mk" target="_blank">Викиодговори</a> е вики за прашања и одговори каде одговорите се подобруваат во вики-стил.',
	'answers-category-count-answered' => 'Оваа категорија содржи $1 одговорени прашања.',
	'answers-category-count-unanswered' => 'Оваа категорија содржи $1 неодговорени прашања.',
	'answers_widget_no_questions' => '<a href="http://answers.wikia.com?uselang=mk" target="_blank">Викиодговори</a> е мрежно место кајшто можете да поставувате прашања и да давата ваши одговори. Се стремиме да дадеме најдобар одговор на било кое прашање. <a href="http://answers.wikia.com/wiki/Special:Search?uselang=mk" target="_blank">Најдете</a> <a href="http://answers.wikia.com/wiki/Category:Un-answered_questions?uselang=mk">неодговорени</a> прашања и одговорете ги. Ова е вики - бидете смели!',
	'answers_widget_no_questions_askabout' => '<br /><br />Започнете со постаување на прашање во врска со „{{PAGENAME}}“',
	'reword_this' => '<a href="$1" $2>Преформулирајте го прашањево</a>',
	'no_related_answered_questions' => 'Сè уште нема поврзани прашања. Погледајте <a href="http://answers.wikia.com/wiki/Special:Randomincategory/answered_questions?uselang=mk">случајно одговорено прашање</a>, или пак поставете ново!<br />
	<div class="createbox" align="center">
	<p></p><form name="createbox" action="/index.php" method="get" class="createboxForm">
	<input name="action" value="create" type="hidden">
	<input name="prefix" value="Special:CreateQuestionPage/" type="hidden">
	<input name="editintro" value="" type="hidden">
	<input class="createboxInput" name="title" value="" size="50" type="text">
	<input name="create" class="createboxButton" value="Внесете го прашањето и стиснете тука" type="submit"></form></div>',
	'auto_friend_request_body' => 'Сакаш да ме додадеш за пријател?',
	'tog-hidefromattribution' => 'Скриј ми го аватарот и името од списокот на заслуги',
	'a' => 'Одговор:',
	'answering_tips' => '<h3>Совети за одговарање:</h3> Кога давате одговор, бидете што попрецизни. Ако преземате информации од друг извор како Википедија, ставете врска до тој текст. Ви благодариме што учествувате на {{SITENAME}}!',
	'plus_x_more_helpers' => '... плус уште $1 помошници',
	'anwb-step1-headline' => 'Која е тематиката на викито?',
	'anwb-step1-text' => 'На вашата страница на Викиодговори ѝ треба <strong>гесло</strong>.<br /><br />Со помош на геслото, луѓето можат полесно да го најдат страницата во пребарувачите, и ќе дознаат на што е посветена.',
	'anwb-step1-example' => 'Одговори на сите ваши кечерски прашања!',
	'anwb-choose-logo' => 'Одберете лого',
	'anwb-step2-text' => 'Сега одберете лого за {{SITENAME}}. Подигнете слика што е претставителна за тематиката на страницата.<br />Ова можете да го прескокнете ако не сакате да го направите сега.<br /><br />',
	'anwb-step2-example' => 'Ова би било добро лого за страница посветена на скејтбордингот',
	'anwb-fp-headline' => 'Поставете прашања!',
	'anwb-fp-text' => 'Вашата страница со одговори мора да најпрвин да започне со прашања!<br /><br />Поставете список на прашања и самите напишете одговори. Важное е да внесете корисни информации на страницата, за да можат читателите да ги најдат и да поставуваат други прашања.',
	'anwb-fp-example' => '<strong>Пример</strong><br /><br />На страница за нега на миленици:<br /><br /><ul><li>Треба ли да купам песок за мачката?</li><li>Која е најдобра кучешка раса?</li><li>Како најдобро да издресирам мачка?</li><li></ul><br /><br />На страница за здравје:<br /><br /><ul><li>Како вежбањето помага на здравјето?</li><li>Каде да најдам добар доктор во околината?</li><li>Како лесно да ослабам?</li></ul>',
	'nwb-thatisall-headline' => 'Толку - готово!',
	'anwb-thatisall-text' => 'Толку - готови сте!<br /><br />Сега почнете да пишувате повеќе прашања и одговори, за да можат пребарувачите да ви ја пронајдат страницата полесно.<br /><br />Списокот на прашањата додадени во последниот чекор сега е сместен на вашето мреж. место. Појдете, одговорете ги прашањата и започнете своја заедница на прашања и одговори!',
	'anwb-logo-preview' => 'Еве преглед на вашето лого',
	'anwb-save-tagline' => 'Зачувај гесло',
	'qa-toolbox-button' => 'Одговори случајно прашање',
	'qa-toolbox-share' => 'Сподели',
	'qa-toolbox-tools' => 'Напредни алатки »',
	'qa-toolbox-protect' => 'Заштити го прашањево',
	'qa-toolbox-delete' => 'Избриши го прашањево',
	'qa-toolbox-history' => 'Претходни верзии на оваа страница.',
	'answers_skins' => 'Одговори',
	'answers-bluebell' => 'Зумбул',
	'answers-leaf' => 'Лист',
	'answers-carnation' => 'Каранфил',
	'answers-sky' => 'Небо',
	'answers-spring' => 'Пролет',
	'answers-forest' => 'Шума',
	'answers-moonlight' => 'Месечева светлина',
	'answers-carbon' => 'Јаглерод',
	'answers-obsession' => 'Опсесија',
	'answers-custom' => 'Прилагодено',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'answer_title' => 'Jawapan',
	'answered_by' => 'Dijawab oleh',
	'unregistered' => 'Tidak berdaftar',
	'anonymous_edit_points' => '$1 pembantu',
	'edit_points' => '$1 titik suntingan',
	'ask_a_question' => 'Tanya...',
	'ask_a_question-widget' => 'Tanya...',
	'in_category' => '...dalam kategori',
	'ask_button' => 'Tanya',
	'ask_thanks' => 'Terima kasih kerana bertanya!',
	'question_asked_by' => 'Soalan yang ditanyakan oleh',
	'question_asked_by_a_wikia_user' => 'Soalan yang ditanyakan oleh pengguna Wikia',
	'new_question_comment' => 'soalan baru',
	'answers_toolbox' => 'Kotak alatan Wikianswers',
	'improve_this_answer' => 'Perbaiki jawapan ini',
	'answer_this_question' => 'Jawab soalan ini:',
	'notify_improved' => 'E-mel saya apabila diperbaiki',
	'research_this' => 'Selidik',
	'notify_answered' => 'E-mel saya apabila dijawab',
	'recent_asked_questions' => 'Soalan Terbaru',
	'recent_answered_questions' => 'Soalan Terjawab Terbaru',
	'recent_edited_questions' => 'Soalan Tersunting Terbaru',
	'unanswered_category' => 'Soalan yang tak terjawab',
	'answered_category' => 'Soalan yang dijawab',
	'related_questions' => 'Soalan berkaitan',
	'related_answered_questions' => 'Soalan terjawab berkaitan',
	'recent_unanswered_questions' => 'Soalan Tak Terjawab Terbaru',
	'popular_categories' => 'Kategori Popular',
	'createaccount-captcha' => 'Sila taipkan perkataan berikut',
	'inline-register-title' => 'Beritahu saya apabila soalan saya dijawab!',
	'inline-welcome' => 'Selamat datang ke Wikianswers',
	'skip_this' => 'Langkau',
	'see_all_changes' => 'Lihat semua perubahan',
	'toolbox_anon_message' => '<i>"Wikianswers memanfaarkan ciri-ciri unik wiki untuk menyampaikan jawapan yang terbaik sekali untuk sebarang soalan."</i><br /><br /> <b>Jimmy Wales</b><br /> pengasas Wikipedia dan Wikianswers',
	'no_questions_found' => 'Tiada soalan ditemui',
	'widget_settings' => 'Tetapan Soalan',
	'style_settings' => 'Tetapan Gaya',
	'get_widget_title' => 'Tambahkan Soalan pada tapak web anda',
	'background_color' => 'Warna latar belakang',
	'widget_category' => 'Jenis Soalan',
	'category' => 'Nama Kategori',
	'custom_category' => 'Kategori Tersuai',
	'number_of_items' => 'Bilangan butiran untuk ditunjukkan',
	'width' => 'Lebar',
	'next_page' => 'Berikutnya &raquo;',
	'prev_page' => '&laquo; Sebelumnya',
	'see_all' => 'Lihat semua',
	'get_code' => 'Ambil Kod',
	'link_color' => 'Warna Pautan Soalan',
	'widget_order' => 'Susunan Soalan',
	'widget_ask_box' => 'Sertakan kotak pertanyaan',
	'question_redirected_help_page' => 'Mengapa soalan saya dilencongkan ke sini',
	'twitter_hashtag' => 'wikianswers',
	'twitter_ask' => 'Tanya di Twitter',
	'facebook_ask' => 'Tanya di Facebook',
	'facebook_send_request' => 'Hantar Terus ke Kawan-Kawan',
	'ask_friends' => 'Minta kawan-kawan tolong jawab:',
	'facebook_send_request_content' => 'Bolehkah anda membantu menjawab soalan ini? $1',
	'facebook_signed_in' => 'Anda telah mendaftar masuk ke Facebook Connect',
	'ads_by_google' => 'Iklan oleh Google',
	'magic_answer_headline' => 'Adakah ini menjawab soalan anda?',
	'magic_answer_yes' => 'Ya, gunakannya sebagai titik permulaan',
	'magic_answer_no' => 'Tidak, jangan gunakan ini',
	'magic_answer_credit' => 'Disediakan oleh Yahoo Answers',
	'rephrase' => 'Susun semula soalan ini',
	'rephrase_this' => '<a href="$1" $2>Tuliskan semula soalan supaya lebih mudah difahami</a>',
	'question_not_answered' => 'Soalan ini belum dijawab',
	'you_can' => 'Anda boleh:',
	'answer_this' => '<a href="$1">Jawab soalan in</a>, walaupun tak tahu seluruh jawapannya',
	'research_this_on_wikipedia' => '<a href="$1">Selidik soalan ini</a> di Wikipedia',
	'receive_email' => '<a href="$1" $2>Terima e-mel</a> apabila soalan ini dijawab',
	'ask_friends_on_twitter' => 'Tanya Kawan di <a href="$1" $2>Twitter</a>',
	'quick_action_panel' => 'Panel Tindakan Pantas',
	'categorize' => 'Kategorikan',
	'categorize_help' => 'Satu kategori sebaris',
	'answers_widget_admin_note' => '<b>Pentadbir:</b> Jika anda hendak menjadi pentadbir di <a href="http://answers.wikia.com" target="_blank">Wikianswers</a>, <a href="http://answers.wikia.com/wiki/Wikianswers:Become_an_admin" target="_blank">klik di sini</a>.',
	'answers_widget_user_note' => 'Bolehkah anda membantu dengan menjadi seorang <a href="http://answers.wikia.com/wiki/Wikianswers:Sign_up_for_a_category" target="_blank">penyunting kategori</a> di <a href="http://answers.wikia.com" target="_blank">Wikianswers</a>?',
	'answers_widget_anon_note' => '<a href="http://answers.wikia.com" target="_blank">Wikianswers</a> ialah sebuah wiki Soal Jawab di mana jawapan boleh diperbaiki seperti dalam wiki.',
	'answers-category-count-answered' => 'Kategori ini mempunyai $1 soalan terjawab.',
	'answers-category-count-unanswered' => 'Kategori ini mempunyai $1 soalan tak terjawab.',
	'answers_widget_no_questions' => '<a href="http://answers.wikia.com" target="_blank">Wikianswers</a> ialah tapak web di mana anda boleh menanyakan soalan dan menyumbangkan jawapan. Kami berusaha memberikan jawapan terbaik kepada sebarang soalan. <a href="http://answers.wikia.com/wiki/Special:Search" target="_blank">Cari</a> dan jawab soalan-soalan yang <a href="http://answers.wikia.com/wiki/Category:Un-answered_questions">belum dijawab</a>. Jangan segan, kan ini wiki!',
	'answers_widget_no_questions_askabout' => '<br /><br />Mulakan dengan menanyakan soalan tentang "{{PAGENAME}}"',
	'reword_this' => '<a href="$1" $2>Susun semula soalan ini</a>',
	'auto_friend_request_body' => 'Boleh tak saya berkawan dengan kamu?',
	'tog-hidefromattribution' => 'Sorokkan avatar dan nama saya daripada senarai atribusi',
	'a' => 'Jawapan:',
	'plus_x_more_helpers' => '... serta $1 lagi pembantu',
	'anwb-step1-headline' => 'Apakah topik wiki anda?',
	'anwb-choose-logo' => 'Pilih logo anda',
	'anwb-fp-headline' => 'Buatlah soalan!',
	'anwb-logo-preview' => 'Inilah pralihat logo anda',
	'qa-toolbox-share' => 'Kongsi',
	'qa-toolbox-tools' => 'Peralatan lanjutan»',
	'answers_skins' => 'Answers',
	'answers-bluebell' => 'Blubel',
	'answers-leaf' => 'Daun',
	'answers-carnation' => 'Teluki',
	'answers-sky' => 'Langit',
	'answers-spring' => 'Musim Bunga',
	'answers-forest' => 'Hutan',
	'answers-moonlight' => 'Cahaya Bulan',
	'answers-carbon' => 'Karbon',
	'answers-obsession' => 'Obsesi',
	'answers-custom' => 'Tersuai',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'answer_title' => 'Antwoord',
	'answered_by' => 'Beantwoord door',
	'unregistered' => 'Niet-geregistreerd',
	'anonymous_edit_points' => '$1 {{PLURAL:$1|hulpje|hulpjes}}',
	'edit_points' => '{{PLURAL:$1|bewerkingspunt|bewerkingspuntent}}',
	'ask_a_question' => 'Stel een vraag...',
	'ask_a_question-widget' => 'Stel een vraag...',
	'in_category' => '...in categorie',
	'ask_button' => 'Vragen',
	'ask_thanks' => 'Bedankt voor uw vraag!',
	'question_asked_by' => 'Vraag gesteld door',
	'question_asked_by_a_wikia_user' => 'Vraag gesteld door een Wikia-gebruiker',
	'new_question_comment' => 'nieuwe vraag',
	'answers_toolbox' => 'Wikiantwoordenpaneel',
	'improve_this_answer' => 'Dit antwoord verbeteren',
	'answer_this_question' => 'Deze vraag beantwoorden:',
	'notify_improved' => 'E-mail mij als een antwoord wordt verbeterd',
	'research_this' => 'Opzoeken',
	'notify_answered' => 'E-mail mij als een vraag wordt beantwoord',
	'recent_asked_questions' => 'Recent gestelde vragen',
	'recent_answered_questions' => 'Recent beantwoorde vragen',
	'recent_edited_questions' => 'Recent bewerkte vragen',
	'unanswered_category' => 'Onbeantwoorde vragen',
	'answered_category' => 'Beantwoorde vragen',
	'related_questions' => 'Gerelateerde vragen',
	'related_answered_questions' => 'Gerelateerde beantwoorde vragen',
	'recent_unanswered_questions' => 'Recente onbeantwoorde vragen',
	'popular_categories' => 'Populaire categorieën',
	'createaccount-captcha' => 'Typ het woord hieronder',
	'inline-register-title' => 'Laat me weten wanneer mijn vraag wordt beantwoord!',
	'inline-welcome' => 'Welkom bij Wikiantwoorden',
	'skip_this' => 'Overslaan',
	'see_all_changes' => 'Alle wijzigingen weergeven',
	'toolbox_anon_message' => '<i>"Wikiantwoorden borduurt voort op de unieke eigenschappen van een wiki om het beste antwoord op iedere vraag te krijgen."</i><br /><br /><b>Jimmy Wales</b><br /> oprichter van Wikipedia en Wikiantwoorden',
	'no_questions_found' => 'Geen vragen gevonden',
	'widget_settings' => 'Instellingen voor vragen',
	'style_settings' => 'Instellingen voor vormgeving',
	'get_widget_title' => 'Vragen toevoegen aan uw site',
	'background_color' => 'Achtergrondkleur',
	'widget_category' => 'Vraagtypen',
	'category' => 'Categorienaam',
	'custom_category' => 'Aangepaste categorie',
	'number_of_items' => 'Aantal weer te geven items',
	'width' => 'Breedte',
	'next_page' => 'Volgende &raquo;',
	'prev_page' => '&laquo; Vorige',
	'see_all' => 'Allemaal bekijken',
	'get_code' => 'Code kopieren',
	'link_color' => 'Vraagverwijzingskleur',
	'widget_order' => 'Vraagvolgorde',
	'widget_ask_box' => 'Venster voor nieuwe vraag toevoegen',
	'question_redirected_help_page' => 'Waarom is mijn vraag hiernaar doorverwezen',
	'twitter_hashtag' => 'wikiantwoorden',
	'twitter_ask' => 'Vragen op Twitter',
	'facebook_ask' => 'Vragen op Facebook',
	'facebook_send_request' => 'Direct naar vrienden verzenden',
	'ask_friends' => 'Vraag uw vrienden te helpen met beantwoorden:',
	'facebook_send_request_content' => 'Kunt u helpen deze vraag te beantwoorden? $1',
	'facebook_signed_in' => 'U bent aangemeld via Facebook Connect.',
	'ads_by_google' => 'Advertenties via Google',
	'magic_answer_headline' => 'Is uw vraag beantwoord?',
	'magic_answer_yes' => 'Ja, gebruik dit als beginpunt',
	'magic_answer_no' => 'Nee, niet gebruiken',
	'magic_answer_credit' => 'Aangeboden door Yahoo Antwoorden',
	'rephrase' => 'Deze vraag herformuleren',
	'rephrase_this' => '<a href="$1" $2>Vraag herformuleren</a>',
	'question_not_answered' => 'Deze vraag is niet beantwoord',
	'you_can' => 'U kunt:',
	'answer_this' => '<a href="$1">Deze vraag beantwoorden</a>, zelfs als u niet het hele antwoord weet',
	'research_this_on_wikipedia' => '<a href="$1">Deze vraag onderzoeken</a> op Wikipedia',
	'receive_email' => '<a href="$1" $2>Een e-mail ontvangen</a> wanneer deze vraag wordt beantwoordt',
	'ask_friends_on_twitter' => 'Vraag het vrienden op <a href="$1" $2>Twitter</a>',
	'quick_action_panel' => 'Snelle handelingen',
	'categorize' => 'Categorie toewijzen',
	'categorize_help' => 'Eén categorie per regel',
	'answers_widget_admin_note' => '<b>Beheerders:</b> als u beheerder wilt worden op <a href="http://answers.wikia.com" target="_blank">Wikiantwoorden</a>, <a href="http://answers.wikia.com/wiki/Wikianswers:Become_an_admin" target="_blank">klik hier</a>.',
	'answers-category-count-answered' => 'Deze categorie bevat $1 beantwoorde vragen.',
	'answers-category-count-unanswered' => 'Deze categorie bevat $1 onbeantwoorde vragen.',
	'reword_this' => '<a href="$1" $2>Vraag herformuleren</a>',
	'auto_friend_request_body' => 'Wilt u mij als vriend toevoegen?',
	'tog-hidefromattribution' => 'Mijn avatar en naam verbergen in de lijst met naamsvermeldingen',
	'a' => 'Antwoord:',
	'plus_x_more_helpers' => '... en $1 andere hulpjes',
	'anwb-step1-headline' => 'Waar gaat uw wiki over?',
	'anwb-choose-logo' => 'Kies uw logo',
	'anwb-fp-headline' => 'Stel wat vragen!',
	'nwb-thatisall-headline' => 'Dat is het. Klaar!',
	'anwb-logo-preview' => 'Hier is een voorbeeld van uw logo',
	'anwb-save-tagline' => 'Slogan opslaan',
	'qa-toolbox-button' => 'Een willekeurige vraag beantwoorden',
	'qa-toolbox-share' => 'Delen',
	'qa-toolbox-tools' => 'Geavanceerde hulpmiddelen»',
	'qa-toolbox-protect' => 'Deze vraag beschermen',
	'qa-toolbox-delete' => 'Deze vraag verwijderen',
	'qa-toolbox-history' => 'Eerdere versies van deze pagina',
	'answers_skins' => 'Antwoorden',
	'answers-bluebell' => 'Klokje',
	'answers-leaf' => 'BLaadje',
	'answers-carnation' => 'Anjer',
	'answers-sky' => 'Lucht',
	'answers-spring' => 'Lente',
	'answers-forest' => 'Bos',
	'answers-moonlight' => 'Maanlicht',
	'answers-carbon' => 'Koolstof',
	'answers-obsession' => 'Obsessie',
	'answers-custom' => 'Aangepast',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 */
$messages['no'] = array(
	'answer_title' => 'Svar',
	'answered_by' => 'Besvart av',
	'unregistered' => 'Uregistrert',
	'anonymous_edit_points' => '$1 {{PLURAL:$1|hjelper|hjelpere}}',
	'edit_points' => '{{PLURAL:$1|redigeringspoeng|redigeringspoeng}}',
	'ask_a_question' => 'Still et spørsmål...',
	'ask_a_question-widget' => 'Still et spørsmål...',
	'in_category' => '... i kategorien',
	'ask_button' => 'Spør',
	'ask_thanks' => 'Takk for det fantastiske spørsmålet!',
	'question_asked_by' => 'Spørsmål stilt av',
	'question_asked_by_a_wikia_user' => 'Spørsmål stilt av en Wikia-bruker',
	'new_question_comment' => 'nytt spørsmål',
	'answers_toolbox' => 'Verktøykasse for WikiSvar',
	'improve_this_answer' => 'Forbedre dette svaret',
	'answer_this_question' => 'Besvar dette spørsmålet:',
	'notify_improved' => 'Send meg en e-post når forbedret',
	'research_this' => 'Gransk dette',
	'notify_answered' => 'Send meg en e-post når besvart',
	'recent_asked_questions' => 'Siste stilte spørsmål',
	'recent_answered_questions' => 'Siste besvarte spørsmål',
	'recent_edited_questions' => 'Siste redigerte spørsmål',
	'unanswered_category' => 'Ubesvarte spørsmål',
	'answered_category' => 'Besvarte spørsmål',
	'related_questions' => 'Relaterte spørsmål',
	'related_answered_questions' => 'Relaterte besvarte spørsmål',
	'recent_unanswered_questions' => 'Siste ubesvarte spørsmål',
	'popular_categories' => 'Populære kategorier',
	'createaccount-captcha' => 'Vennligst skriv inn ordene under',
	'inline-register-title' => 'Varsle meg når spørsmålet mitt er besvart!',
	'inline-welcome' => 'Velkommen til WikiSvar',
	'skip_this' => 'Hopp over dette',
	'see_all_changes' => 'Se alle endringer',
	'toolbox_anon_message' => '<i>«WikiSvar utnytter den unike wiki-karakteristikken til å forme de beste svarene til ethvert spørsmål.»</i><br /><br /> <b>Jimmy Wales</b><br /> grunnleggeren av Wikipedia og WikiSvar',
	'no_questions_found' => 'Ingen spørsmål funnet',
	'widget_settings' => 'Spørsmålsinnstillinger',
	'style_settings' => 'Stilinnstillinger',
	'get_widget_title' => 'Legg spørsmål til siden din',
	'background_color' => 'Bakgrunnsfarge',
	'widget_category' => 'Spørsmålstyper',
	'category' => 'Kategorinavn',
	'custom_category' => 'Egendefinert kategori',
	'number_of_items' => 'Antall elementer å vise',
	'width' => 'Bredde',
	'next_page' => 'Neste &raquo;',
	'prev_page' => '&laquo; Forrige',
	'see_all' => 'Se alle',
	'get_code' => 'Hent kode',
	'link_color' => 'Farge på spørsmålslenke',
	'widget_order' => 'Rekkefølge på spørsmål',
	'widget_ask_box' => 'Inkludér spørreboks',
	'question_redirected_help_page' => 'Hvorfor ble spørsmålet mitt omdirigert hit',
	'twitter_hashtag' => 'wikianswers',
	'twitter_ask' => 'Spør på Twitter',
	'facebook_ask' => 'Spør på Facebook',
	'facebook_send_request' => 'Send direkte til venner',
	'ask_friends' => 'Be vennene dine om hjelp til å svare:',
	'facebook_send_request_content' => 'Kan du hjelpe til med å besvare dette? $1',
	'facebook_signed_in' => 'Du er logget inn med Facebook Connect',
	'ads_by_google' => 'Annonser fra Google',
	'magic_answer_headline' => 'Besvarer dette spørsmålet ditt?',
	'magic_answer_yes' => 'Ja, bruk dette som utgangspunkt',
	'magic_answer_no' => 'Nei, ikke bruk dette',
	'magic_answer_credit' => 'Levert av Yahoo Answers',
	'rephrase' => 'Omformuler dette spørsmålet',
	'rephrase_this' => '<a href="$1" $2>Omformuler spørsmålet</a>',
	'question_not_answered' => 'Dette spørsmålet har ikke blitt besvart',
	'you_can' => 'Du kan:',
	'answer_this' => '<a href="$1">Besvar dette spørsmålet</a>, selv om du ikke vet hele svaret',
	'research_this_on_wikipedia' => '<a href="$1">Undersøk dette spørsmålet</a> på Wikipedia',
	'receive_email' => '<a href="$1" $2>Motta en e-post</a> når dette spørsmålet er besvart',
	'ask_friends_on_twitter' => 'Spør venner på <a href="$1" $2>Twitter</a>',
	'quick_action_panel' => 'Hurtighandlingspanel',
	'categorize' => 'Kategorisér',
	'categorize_help' => 'Én kategori per linje',
	'answers_widget_admin_note' => '<b>Administratorer:</b> Hvis du ønsker å bli en administrator på <a href="http://answers.wikia.com" target="_blank">WikiSvar</a>, <a href="http://answers.wikia.com/wiki/Wikianswers:Become_an_admin" target="_blank">klikk her</a>.',
	'answers_widget_user_note' => 'Kan du hjelpe til ved å bli en <a href="http://answers.wikia.com/wiki/Wikianswers:Sign_up_for_a_category" target="_blank">kategoriredaktør</a> på <a href="http://answers.wikia.com" target="_blank">WikiSvar</a>?',
	'answers_widget_anon_note' => '<a href="http://answers.wikia.com" target="_blank">WikiSvar</a> er en spør-og-svar-wiki hvor svarene forbedres på wiki-vis.',
	'answers-category-count-answered' => 'Denne kategorien inneholder $1 besvarte spørsmål.',
	'answers-category-count-unanswered' => 'Denne kategorien inneholder $1 ubesvarte spørsmål.',
	'answers_widget_no_questions' => '<a href="http://answers.wikia.com" target="_blank">WikiSvar</a> er en side hvor du kan stille spørsmål og bidra med svar. Vi tar sikte på å ha det beste svaret på ethvert spørsmål. <a href="http://answers.wikia.com/wiki/Special:Search" target="_blank">Finn</a> og besvar <a href="http://answers.wikia.com/wiki/Kategori:Ubesvarte_spørsmål">ubesvarte</a> spørsmål. Det er en wiki – så vær modig!',
	'answers_widget_no_questions_askabout' => '<br /><br />Kom i gang ved å stille spørsmål om «{{PAGENAME}}»',
	'reword_this' => '<a href="$1" $2>Omformuler dette spørsmålet</a>',
	'no_related_answered_questions' => 'Det er ingen relaterte spørsmål ennå. Få et <a href="http://answers.wikia.com/wiki/Special:Randomincategory/answered_questions">tilfeldig besvart spørsmål istedenfor</a>, eller still et nytt!<br />
<div class="createbox" align="center">
<p></p><form name="createbox" action="/index.php" method="get" class="createboxForm">
<input name="action" value="create" type="hidden">
<input name="prefix" value="Special:CreateQuestionPage/" type="hidden">
<input name="editintro" value="" type="hidden">
<input class="createboxInput" name="title" value="" size="50" type="text">
<input name="create" class="createboxButton" value="Skriv spørsmålet ditt og trykk her" type="submit"></form></div>',
	'auto_friend_request_body' => 'Vil du legge meg til som venn?',
	'tog-hidefromattribution' => 'Skjul avataren og navnet mitt fra henvisningslisten',
	'q' => '<!-- -->',
	'a' => 'Svar:',
	'?' => '?',
	'answering_tips' => '<h3>Tips for besvaring:</h3> Når du bidrar med et svar, forsøk å være så presis som mulig. Hvis du får informasjon fra en annen kilde, slik som Wikia, legg til en lenke til denne i teksten. Og takk for ditt bidrag til {{SITENAME}}!',
	'header_questionmark_post' => '?',
	'plus_x_more_helpers' => '... pluss $1 andre hjelpere',
	'anwb-step1-headline' => 'Hva handler wikien din om?',
	'anwb-step1-text' => 'WikiSvar-siden din trenger et <strong>slagord</strong>.<br /><br />Slagordet ditt vil hjelpe folk å finne siden gjennom søkemotorer, så prøv å være tydelig på hva siden handler om.',
	'anwb-step1-example' => 'Svar på alle dine spørsmål om proffbryting!',
	'anwb-choose-logo' => 'Velg en logo',
	'anwb-step2-text' => 'Neste steg er å velge en logo for {{SITENAME}}. Det er best å laste opp et bilde som du synes representerer din Svar-side.<br />Du kan hoppe over dette trinnet hvis du ikke vil gjøre det akkurat nå.<br /><br />',
	'anwb-step2-example' => 'Dette ville vært en god logo for en svarside om skateboarding.',
	'anwb-fp-headline' => 'Still noen spørsmål!',
	'anwb-fp-text' => 'Svar-siden din bør starte opp med noen spørsmål!<br /><br />Legg til en liste med spørsmål, og så oppgi svarene selv. Det er viktig å ha litt nyttig informasjon på siden, slik at folk kan finne den og spørre og svare på enda flere spørsmål.',
	'anwb-fp-example' => '<strong>Eksempel</strong><br /><br />Til en svarside om dyrestell:<br /><br /><ul><li>Bør jeg kjøpe kattesand?</li><li>Hva er den beste hunderasen?</li><li>Hva er den beste måten å trene en katt på?</li><li></ul><br /><br />For en svarside om helse:<br /><br /><ul><li>Hva er de helsemessige fordelene ved trening?</li><li>Hvordan kan jeg finne en god doktor i mitt område?</li><li>Hvordan kan jeg enkelt gå ned i vekt?</li></ul>',
	'nwb-thatisall-headline' => 'Det var det – du er ferdig!',
	'anwb-thatisall-text' => 'Det var det – du er klar til å komme i gang!<br /><br />Nå er det på tide å begynne å skrive noen spørsmål og svar, slik at siden din lettere kan bli funnet av søkemotorer.<br /><br />Listen over spørsmål lagt til i det siste steget har blitt lagt til spørsmålssiden din. Gå og besvar spørsmålene, og start ditt eget svar-fellesskap!',
	'anwb-logo-preview' => 'Her er en forhåndsvisning av logoen din',
	'anwb-save-tagline' => 'Lagre slagord',
	'qa-toolbox-button' => 'Besvar et tilfeldig spørsmål',
	'qa-toolbox-share' => 'Del',
	'qa-toolbox-tools' => 'Avanserte verktøy»',
	'qa-toolbox-protect' => 'Beskytt dette spørsmålet',
	'qa-toolbox-delete' => 'Slett dette spørsmålet',
	'qa-toolbox-history' => 'Tidligere versjoner av denne siden',
	'answers_skins' => 'Svar',
	'answers-bluebell' => 'Blåklokke',
	'answers-leaf' => 'Blad',
	'answers-carnation' => 'Nellik',
	'answers-sky' => 'Himmel',
	'answers-spring' => 'Vår',
	'answers-forest' => 'Skog',
	'answers-moonlight' => 'Måneskinn',
	'answers-carbon' => 'Karbon',
	'answers-obsession' => 'Besettelse',
	'answers-custom' => 'Egendefinert',
);

/** Occitan (Occitan) */
$messages['oc'] = array(
	'research_this' => 'Recercar aquò',
);

/** Polish (Polski) */
$messages['pl'] = array(
	'research_this' => 'Wyszukaj',
);

/** Piedmontese (Piemontèis) */
$messages['pms'] = array(
	'research_this' => 'Sërché sòn',
);

/** Portuguese (Português) */
$messages['pt'] = array(
	'research_this' => 'Investigar isto',
);

/** Brazilian Portuguese (Português do Brasil) */
$messages['pt-br'] = array(
	'research_this' => 'Pesquisar isto',
);

/** Tarandíne (Tarandíne) */
$messages['roa-tara'] = array(
	'research_this' => 'Cerche quiste',
);

/** Russian (Русский) */
$messages['ru'] = array(
	'research_this' => 'Исследовать',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'new_question_comment' => 'కొత్త ప్రశ్న',
	'width' => 'వెడల్పు',
	'answers-sky' => 'ఆకాశం',
	'answers-forest' => 'అడవి',
);

/** Tagalog (Tagalog) */
$messages['tl'] = array(
	'research_this' => 'Saliksikin ito',
);

/** Ukrainian (Українська) */
$messages['uk'] = array(
	'research_this' => 'Дослідити',
);

