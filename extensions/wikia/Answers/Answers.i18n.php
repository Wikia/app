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
	'ask_a_question' => 'Постави прашање...',
	'ask_a_question-widget' => 'Постави прашање...',
	'in_category' => '...во категоријата',
	'ask_button' => 'Прашај',
	'research_this' => 'Истражи го ова',
	'toolbox_anon_message' => '<i>„Викиодговори ги користи уникатните карактеристики на викито за да оформи најдобри одговори на прашањата.“</i><br /><br /> <b>Џими Велс</b><br /> основач на Википедија и Викиодговори',
	'next_page' => 'След &raquo;',
	'prev_page' => '&laquo; Прет',
	'see_all' => 'Сите',
	'you_can' => 'Можете да:',
	'answers_widget_admin_note' => '<b>Администратори:</b> Ако сакате да станете администратор на <a href="http://answers.wikia.com?uselang=mk" target="_blank">Викиодговори</a>, <a href="http://answers.wikia.com/wiki/Wikianswers:Become_an_admin?uselang=mk" target="_blank">стиснете тука</a>.',
	'answers_widget_user_note' => 'Можете ли да ни помогнете со тоа што ќе станете <a href="http://answers.wikia.com/wiki/Wikianswers:Sign_up_for_a_category?uselang=mk" target="_blank">уредник на категории</a> на <a href="http://answers.wikia.com?uselang=mk" target="_blank">Викиодговори</a>?',
	'answers_widget_anon_note' => '<a href="http://answers.wikia.com?uselang=mk" target="_blank">Викиодговори</a> е вики за прашања и одговори каде одговорите се подобруваат во вики-стил.',
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
	'answer_this_question' => 'Deze vraag beantwoorden:',
	'research_this' => 'Opzoeken',
	'answered_category' => 'Beantwoorde vragen',
	'no_questions_found' => 'Geen vragen gevonden',
	'width' => 'Breedte',
	'rephrase' => 'Deze vraag herformuleren',
	'you_can' => 'U kunt:',
	'answer_this' => '<a href="$1">Deze vraag beantwoorden</a>, zelfs als u niet het hele antwoord weet',
	'research_this_on_wikipedia' => '<a href="$1">Deze vraag onderzoeken</a> op Wikipedia',
	'receive_email' => '<a href="$1" $2>Een e-mail ontvangen</a> wanneer deze vraag wordt beantwoordt',
	'categorize_help' => 'Eén categorie per regel',
	'anwb-step1-headline' => 'Waar gaat uw wiki over?',
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
	'header_questionmark_pre' => '&nbsp;',
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
	'badWords' => 'faen',
	'qa-toolbox-button' => 'Besvar et tilfeldig spørsmål',
	'qa-toolbox-share' => 'Del',
	'qa-toolbox-tools' => 'Avanserte verktøy»',
	'qa-toolbox-protect' => 'Beskytt dette spørsmålet',
	'qa-toolbox-delete' => 'Slett dette spørsmålet',
	'qa-toolbox-history' => 'Tidligere versjoner av denne siden',
	'qa-featured-sites' => '-',
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

/** Tagalog (Tagalog) */
$messages['tl'] = array(
	'research_this' => 'Saliksikin ito',
);

/** Ukrainian (Українська) */
$messages['uk'] = array(
	'research_this' => 'Дослідити',
);

