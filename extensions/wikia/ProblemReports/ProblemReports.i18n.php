<?php

/**
 * Internationalization for ProblemReports extension
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Maciej Brencz <macbre@wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
 */

$messages = array();

$messages['en'] = array(
	'problemreports' => 'Problem reports list',
	'reportproblem' => 'Report a problem',

	'prlogtext' => 'Problem reports',
	'prlogheader' => 'List of reported problems and changes of their status',
	'prlog_reportedentry' => 'reported a problem on $1 ($2)',
	'prlog_changedentry' => 'marked problem $1 as "$2"',
	'prlog_typeentry'    => 'changed problem $1 type to "$2"',
	'prlog_removedentry' => 'removed problem $1',
	'prlog_emailedentry' => 'sent e-mail message to $2 ($3)',

	'pr_introductory_text' => 'Most pages on this wiki are editable, and you are welcome to edit the page and correct mistakes yourself!
If you need help doing that, see [[help:editing|how to edit]] and [[help:revert|how to revert vandalism]].

To contact staff or to report copyright problems, please see [[w:contact us|Wikia\'s "contact us" page]].

Software bugs can be reported on the forums.
Reports made here will be [[Special:ProblemReports|displayed on the wiki]].',

	'pr_what_problem' => 'Subject',
	'pr_what_problem_spam' => 'there is a spam link here',
	'pr_what_problem_vandalised' => 'this page has been vandalised',
	'pr_what_problem_incorrect_content' => 'this content is incorrect',
	'pr_what_problem_software_bug' => 'there is a bug in the wiki software',
	'pr_what_problem_other' => 'other',

	'pr_what_problem_select' => 'Please select problem type',
	'pr_what_problem_unselect' => 'all',
	'pr_what_problem_spam_short' => 'spam',
	'pr_what_problem_vandalised_short' => 'vandal',
	'pr_what_problem_incorrect_content_short' => 'content',
	'pr_what_problem_software_bug_short' => 'bug',
	'pr_what_problem_other_short' => 'other',

	'pr_what_problem_change' => 'Change problem type',

	'pr_describe_problem' => 'Message',
	'pr_what_page' => 'Title of the page',
	'pr_email_visible_only_to_staff' => 'visible only to staff',
	'pr_thank_you' => "Thank you for reporting a problem!

[[Special:ProblemReports/$1|You can watch progress of fixing it]].",
	'pr_thank_you_error' => 'Error occured when sending problem report, please try later...',
	'pr_spam_found' => 'Spam has been found in your report summary.
Please change summary content',
	'pr_empty_summary' => 'Please provide short problem description',
	'pr_empty_email' => 'Please provide your e-mail address',

	'pr_mailer_notice'  => 'The e-mail address you entered in your user preferences will appear as the "From" address of the mail, so the recipient will be able to reply.',
	'pr_mailer_subject' => 'Reported problem on',
	'pr_mailer_tmp_info' => 'You can [[MediaWiki:ProblemReportsResponses|edit templated responses]]',
	'pr_mailer_to_default' => 'Wikia User',
	'pr_mailer_go_to_wiki' => 'To send e-mail please go to [$1 wiki problem was reported from]',

	'pr_total_number'       => 'Total number of reports',
	'pr_view_archive'       => 'View archived problems',
	'pr_view_all'           => 'Show all reports',
	'pr_view_staff'         => 'Show reports that needs staff help',
	'pr_raports_from_this_wikia' => 'View reports from this Wikia only',
	'pr_reports_from'       => 'Reports only from: $1',
	'pr_no_reports' => 'No reports matching your criteria',

	'pr_sysops_notice' => 'You can <a href="$1">change status of problem reports</a> from your wiki...',

	'pr_table_problem_id'   => 'Problem ID',
	'pr_table_wiki_name'    => 'Wiki name',
	'pr_table_problem_type' => 'Problem type',
	'pr_table_page_link'    => 'Page',
	'pr_table_date_submitted' => 'Date submitted',
	'pr_table_reporter_name'=> 'Reporter name',
	'pr_table_description'  => 'Description',
	'pr_table_comments'     => 'Comments',
	'pr_table_status'       => 'Status',
	'pr_table_actions'      => 'Actions',

	'pr_status_0' => 'pending',
	'pr_status_1' => 'fixed',
	'pr_status_2' => 'closed',
	'pr_status_3' => 'need staff help',
	'pr_status_10' => 'remove report',

	'pr_status_undo' => 'Undo report status change',
	'pr_status_ask'  => 'Change report status?',

	'pr_remove_ask'  => 'Permanently remove report?',

	'pr_status_wait' => 'wait...',

	'pr_read_only' => 'New reports cannot be filled right now, please try again later.',

	'pr_msg_exceeded' => 'The maximum number of characters in the message field is 512.
Please rewrite your message.',
	'pr_msg_exchead' => 'Message is too long',

	'right-problemreports_action' => 'Change state and type of ProblemReports',
	'right-problemreports_global' => 'Change state and type of ProblemReports across wikis',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author LWChris
 * @author Siebrand
 * @author Translationista
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'prlog_reportedentry' => 'Log message. Preceded by something like "17:04, 9 July 2010 Username (Talk | contribs | block)"',
	'prlog_typeentry' => 'Log message. Preceded by something like "17:04, 9 July 2010 Username (Talk | contribs | block)"',
	'prlog_removedentry' => 'Log message. Preceded by something like "17:04, 9 July 2010 Username (Talk | contribs | block)"',
	'pr_what_problem' => '{{Identical|Subject}}',
	'pr_what_problem_other' => '{{Identical|Other}}',
	'pr_what_problem_spam_short' => '{{Identical|Spam}}',
	'pr_what_problem_incorrect_content_short' => '{{Identical|Content}}',
	'pr_what_problem_other_short' => '{{Identical|Other}}',
	'pr_describe_problem' => '{{Identical|Message}}',
	'pr_mailer_go_to_wiki' => '$1 is the URL to the wiki the problem was reported from',
	'pr_table_page_link' => '{{Identical|Page}}',
	'pr_table_description' => '{{Identical|Description}}',
	'pr_table_comments' => '{{Identical|Comment}}',
	'pr_table_status' => '{{Identical|Status}}',
	'pr_table_actions' => '{{Identical|Action}}',
	'right-problemreports_action' => '{{doc-right|problemreports action}}',
	'right-problemreports_global' => '{{doc-right|problemreports global}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'reportproblem' => "Rapporteer 'n probleem",
	'prlog_reportedentry' => "'n probleem gerapporteer op $1 ($2)",
	'prlog_changedentry' => 'probleem $1 gemerk as "$2"',
	'prlog_typeentry' => 'tipe probleem $1 verander na "$2"',
	'prlog_removedentry' => 'het probleem $1 verwyder',
	'prlog_emailedentry' => 'e-pos gestuur na $2 ($3)',
	'pr_what_problem' => 'Onderwerp',
	'pr_what_problem_spam' => "daar is 'n spam-skakel in",
	'pr_what_problem_vandalised' => 'die bladsy is gevandaliseer',
	'pr_what_problem_incorrect_content' => 'die inhoud is verkeerd',
	'pr_what_problem_software_bug' => "daar is 'n fout in die wiki-sagteware",
	'pr_what_problem_other' => 'ander',
	'pr_what_problem_select' => "Kies asseblief 'n probleem-tipe",
	'pr_what_problem_unselect' => 'alle',
	'pr_what_problem_spam_short' => 'spam',
	'pr_what_problem_vandalised_short' => 'vandalisme',
	'pr_what_problem_incorrect_content_short' => 'inhoud',
	'pr_what_problem_software_bug_short' => 'bug',
	'pr_what_problem_other_short' => 'ander',
	'pr_describe_problem' => 'Boodskap',
	'pr_what_page' => 'Titel van die bladsy',
	'pr_email_visible_only_to_staff' => 'slegs vir personeel sigbaar',
	'pr_empty_summary' => "Verskaf asseblief 'n kort probleembeskrywing",
	'pr_empty_email' => 'Verskaf asseblief u e-posadres',
	'pr_mailer_to_default' => 'Wikia-gebruiker',
	'pr_total_number' => 'Totale aantal verslae',
	'pr_view_archive' => 'Wys geargiveerde probleme',
	'pr_view_all' => 'Wys alle verslae',
	'pr_view_staff' => 'Wys verslae waar hulp vanaf personeel benodig word',
	'pr_raports_from_this_wikia' => 'Wys slegs hierdie Wikia se verslae',
	'pr_reports_from' => 'Slegs verslae van: $1',
	'pr_table_problem_id' => 'Probleem-ID',
	'pr_table_wiki_name' => 'Wiki-naam',
	'pr_table_problem_type' => 'Probleem-tipe',
	'pr_table_page_link' => 'Bladsy',
	'pr_table_date_submitted' => 'Datum ingedien',
	'pr_table_reporter_name' => 'Gerapporteer deur',
	'pr_table_description' => 'Beskrywing',
	'pr_table_comments' => 'Kommentaar',
	'pr_table_status' => 'Status',
	'pr_table_actions' => 'Aksies',
	'pr_status_0' => 'afwagtend',
	'pr_status_1' => 'Reggemaak',
	'pr_status_2' => 'gesluit',
	'pr_status_3' => 'benodig hulp van personeel',
	'pr_status_10' => 'verwyder verslag',
	'pr_status_wait' => 'wag...',
	'pr_msg_exchead' => 'Boodskap is te lank',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'pr_describe_problem' => 'Mensache',
	'pr_table_description' => 'Descripción',
	'pr_table_actions' => 'Accions',
);

/** Arabic (العربية)
 * @author OsamaK
 */
$messages['ar'] = array(
	'pr_status_wait' => 'انتظر...',
);

/** Azerbaijani (Azərbaycanca)
 * @author Sortilegus
 */
$messages['az'] = array(
	'pr_table_problem_id' => 'ID problemlər',
	'pr_table_wiki_name' => 'Vikinin adı',
	'pr_table_problem_type' => 'Problemin tipi',
	'pr_status_wait' => 'gözləyin...',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'problemreports' => 'Сьпіс паведамленьняў пра праблемы',
	'reportproblem' => 'Паведаміць пра праблему',
	'prlogtext' => 'Паведамленьні пра праблемы',
	'prlogheader' => 'Сьпіс паведамленьняў пра праблемы і зьменаў іх статусу',
	'prlog_reportedentry' => 'паведаміў пра праблему ў $1 ($2)',
	'prlog_changedentry' => 'пазначыў праблему $1 як «$2»',
	'prlog_typeentry' => 'зьмяніў тып праблемы $1 на «$2»',
	'prlog_removedentry' => 'выдаліў праблему $1',
	'prlog_emailedentry' => 'даслаў паведамленьне па электроннай пошце $2 ($3)',
	'pr_introductory_text' => 'Большасьць старонак {{GRAMMAR:родны|{{SITENAME}}}} могуць рэдагавацца, і мы запрашаем Вас рэдагаваць старонкі і выпраўляць памылкі!
Калі Вам патрэбная дапамога, глядзіце [[help:editing|дапамогу па рэдагаваньню]] і [[help:revert|выпраўленьню вандальных правак]].

Для сувязі з камандай альбо для паведамленьня пра праблемы з аўтарскімі правамі, калі ласка, глядзіце [[w:contact us|старонку кантактаў з Wikia]].

Пра памылкі ў праграмным забесьпячэньні можна паведамляць на форумах.
Паведамленьні, зробленыя тут, будуць [[Special:ProblemReports|паказаныя ў {{GRAMMAR:месны|{{SITENAME}}}}]].',
	'pr_what_problem' => 'Тэма',
	'pr_what_problem_spam' => 'тут знаходзіцца спам-спасылка',
	'pr_what_problem_vandalised' => 'Гэтая старонка была сапсаваная вандалам',
	'pr_what_problem_incorrect_content' => 'гэты зьмест зьяўляецца няслушным',
	'pr_what_problem_software_bug' => 'памылка праграмнага забесьпячэньня вікі',
	'pr_what_problem_other' => 'іншае',
	'pr_what_problem_select' => 'Калі ласка, выберыце тып праблемы',
	'pr_what_problem_unselect' => 'усе',
	'pr_what_problem_spam_short' => 'спам',
	'pr_what_problem_vandalised_short' => 'вандалізм',
	'pr_what_problem_incorrect_content_short' => 'зьмест',
	'pr_what_problem_software_bug_short' => 'памылка',
	'pr_what_problem_other_short' => 'іншая',
	'pr_what_problem_change' => 'Зьмяніць тып праблемы',
	'pr_describe_problem' => 'Паведамленьне',
	'pr_what_page' => 'Назва старонкі',
	'pr_email_visible_only_to_staff' => 'бачна толькі для супрацоўнікаў',
	'pr_thank_you' => 'Дзякуй за паведамленьне пра праблему!

[[Special:ProblemReports/$1|Вы можаце назіраць за яе вырашэньнем]].',
	'pr_thank_you_error' => 'Узьнікла памылка пад час адпраўкі паведамленьня пра праблему. Калі ласка, паспрабуйце пазьней…',
	'pr_spam_found' => 'У Вашым кароткім апісаньні быў знойдзены спам.
Калі ласка, зьмяніце зьмест кароткага апісаньня',
	'pr_empty_summary' => 'Калі ласка, падайце кароткае апісаньне праблемы',
	'pr_empty_email' => 'Калі ласка, падайце адрас Вашай электроннай пошты',
	'pr_mailer_notice' => 'Адрас электроннай пошты, які Вы падалі ў Вашых устаноўках, будзе пазначаны ў лісьце ў полі «Ад», таму атрымальнік будзе мець магчымасьць Вам адказаць.',
	'pr_mailer_subject' => 'Паведамленьне пра праблему ў',
	'pr_mailer_tmp_info' => 'Вы можаце [[MediaWiki:ProblemReportsResponses|рэдагаваць шаблёны адказаў]]',
	'pr_mailer_to_default' => 'Удзельнік Wikia',
	'pr_mailer_go_to_wiki' => 'Для адпраўкі электроннага ліста, калі ласка, перайдзіце на старонку, [$1 на якой была знойдзеная вікі-праблема]',
	'pr_total_number' => 'Агульная колькасьць паведамленьняў',
	'pr_view_archive' => 'Паказаць архіў праблемаў',
	'pr_view_all' => 'Паказаць усе паведамленьні',
	'pr_view_staff' => 'Паказаць паведамленьні, якія патрабуюць дапамогі супрацоўнікаў',
	'pr_raports_from_this_wikia' => 'Прагляд паведамленьняў толькі з гэтай Wikia',
	'pr_reports_from' => 'Паведамленьні толькі ад: $1',
	'pr_no_reports' => 'Няма паведамленьняў адпаведных Вашаму крытэрыю',
	'pr_sysops_notice' => 'Вы можаце <a href="$1">зьмяняць статус паведамленьняў пра праблему</a> з Вашай вікі…',
	'pr_table_problem_id' => 'Ідэнтыфікатар праблемы',
	'pr_table_wiki_name' => 'Назва вікі',
	'pr_table_problem_type' => 'Тып праблемы',
	'pr_table_page_link' => 'Старонка',
	'pr_table_date_submitted' => 'Дата адпраўкі',
	'pr_table_reporter_name' => 'Імя аўтара паведамленьня',
	'pr_table_description' => 'Апісаньне',
	'pr_table_comments' => 'Камэнтары',
	'pr_table_status' => 'Статус',
	'pr_table_actions' => 'Дзеяньні',
	'pr_status_0' => 'чакае',
	'pr_status_1' => 'выпраўлена',
	'pr_status_2' => 'закрыта',
	'pr_status_3' => 'неабходная дапамога супрацоўнікаў',
	'pr_status_10' => 'выдаліць паведамленьне',
	'pr_status_undo' => 'Адмяніць зьмену статусу паведамленьня',
	'pr_status_ask' => 'Зьмяніць статус паведамленьня?',
	'pr_remove_ask' => 'Выдаліць паведамленьне назаўсёды?',
	'pr_status_wait' => 'пачакайце…',
	'pr_read_only' => 'У цяперашні час новыя паведамленьні ня могуць быць запоўненыя. Калі ласка, паспрабуйце потым.',
	'pr_msg_exceeded' => 'Максымальная колькасьць сымбаляў у полі паведамленьня складае 512.
Калі ласка, перапішыце Вашае паведамленьне.',
	'pr_msg_exchead' => 'Паведамленьне занадта вялікае',
	'right-problemreports_action' => 'зьмена станаў і тыпаў паведамленьняў пра праблемы',
	'right-problemreports_global' => 'зьмена станаў і тыпаў паведамленьняў пра праблемы паміж ўсімі вікі',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Gwendal
 * @author Y-M D
 */
$messages['br'] = array(
	'problemreports' => 'Roll danevelloù kudennoù',
	'reportproblem' => 'Menegiñ ur gudennoù',
	'prlogtext' => 'Danevelloù kudennoù',
	'prlogheader' => "Roll ar c'hudennoù danevellet ha kemmoù ho statud",
	'prlog_reportedentry' => 'en deus meneget ur gudenn war $1 ($2)',
	'prlog_changedentry' => 'en deus merket ar gudenn  $1 evel "$2"',
	'prlog_typeentry' => 'en deus kemmet seurt ar gudenn $1 da "$2"',
	'prlog_removedentry' => 'en deus dilamet ar gudenn $1',
	'prlog_emailedentry' => 'en deus kaset ur postel da $2 ($3)',
	'pr_introductory_text' => "Gallout a reer degas kemmoù war ar pep brasañ eus pajennoù ar wiki-mañ ha pedet oc'h d'en ober ha da reizhañ ar fazioù c'hwi hoc'h-unan !
M'hoc'h eus ezhom skoazell evit se; sellit ouzh [[help:editing|penaos degas kemmoù]] hag ouzh [[help:revert|penaos disteuler ar vandalerezh]].

Evit mont e darempred gant ar skipailh pe kelaouiñ war kudennoù gwirioù aozer, implijit [[w:contact us|pajenn \"mont e darempred ganeomp\" Wikia]].

Drein ar meziant a c'haller kelaouiñ an dud diwar o fenn war ar foromoù.

Ar c'hudennoù dispaket amañ a vo [[Special:ProblemReports|diskouezet war ar wiki]].",
	'pr_what_problem' => 'Objed',
	'pr_what_problem_spam' => 'un liamm strob a zo amañ',
	'pr_what_problem_vandalised' => 'Vandalerezh a zo bet er bajenn-mañ',
	'pr_what_problem_incorrect_content' => 'direizh eo an danvez',
	'pr_what_problem_software_bug' => 'ur bug a zo e meziant ar wiki',
	'pr_what_problem_other' => 'all',
	'pr_what_problem_select' => 'Mar plij dibabit seurt ar gudenn',
	'pr_what_problem_unselect' => 'pep tra',
	'pr_what_problem_spam_short' => 'strob',
	'pr_what_problem_vandalised_short' => 'vandal',
	'pr_what_problem_incorrect_content_short' => 'danvez',
	'pr_what_problem_software_bug_short' => 'bug',
	'pr_what_problem_other_short' => 'all',
	'pr_what_problem_change' => 'Kemmañ seurt ar gudenn',
	'pr_describe_problem' => 'Kemennadenn',
	'pr_what_page' => 'Titl ar bajenn',
	'pr_email_visible_only_to_staff' => "n'eus nemet ar staff a well kement-mañ",
	'pr_thank_you' => 'Trugarez evit bezañ meneget ar gudenn !

[[Special:ProblemReports/$1|Gellout a rit heuliañ emdroadur an diskoulmadenn]].',
	'pr_thank_you_error' => "Ur fazi a zo bet pa 'veze kaset danevell ar gudenn, mar plij adklaskit diwezhatoc'h...",
	'pr_spam_found' => 'Stroboù a zo bet kavet e diverradenn ho tanevell.
Mar plij kemmit danvez an diverradenn.',
	'pr_empty_summary' => 'Mar plij deskrivit buan ha buan ar gudenn',
	'pr_empty_email' => "Mar plij roit ho chomlec'h postel",
	'pr_mailer_notice' => "Ar chomlec'h postel hoc'h eus lakaet en ho penndibaboù implijer a vo lakaet e zonenn \"Eus\" ar postel, ar pezh a servijo d'ar reseverien da respont dit.",
	'pr_mailer_subject' => 'Danevell diwar-benn',
	'pr_mailer_tmp_info' => "Posupl eo deoc'h kemmañ ho patromoù er respont [[MediaWiki:ProblemReportsResponses|amañ]].",
	'pr_mailer_to_default' => 'Implijer Wikia',
	'pr_mailer_go_to_wiki' => "Evit kas ur postel mar plij kit er [$1 ar wiki e lec'h ma 'z eus bet kaoz eus ar gudenn]",
	'pr_total_number' => 'Niver hollek a danevelloù',
	'pr_view_archive' => 'Gwelet an danevelloù diskouezet',
	'pr_view_all' => 'Diskouez an holl danevelloù',
	'pr_view_staff' => 'Diskouez an danevelloù evit pere ez eus ezhomm sikour ar staff',
	'pr_raports_from_this_wikia' => 'Gwelet danevelloù ar Wikia-mañ hepken',
	'pr_reports_from' => 'An danevelloù abaoe : $1 nemetken',
	'pr_no_reports' => "N'eus danevell ebet o klotañ gant ho tezverkoù",
	'pr_sysops_notice' => 'Ma fell deoc\'h kemmañ statud danevell ar gudenn adalek ho wiki, kit <a href="$1">amañ</a>...',
	'pr_table_problem_id' => 'ID ar gudenn',
	'pr_table_wiki_name' => 'Anv ar wiki',
	'pr_table_problem_type' => 'Seurt ar gudenn',
	'pr_table_page_link' => 'Pajenn',
	'pr_table_date_submitted' => 'Deiziad kas',
	'pr_table_reporter_name' => 'Anv an daneveller',
	'pr_table_description' => 'Deskrivadur',
	'pr_table_comments' => 'Evezhiadennoù',
	'pr_table_status' => 'Statud',
	'pr_table_actions' => 'Oberoù',
	'pr_status_0' => "o c'hortoz",
	'pr_status_1' => 'diskoulet',
	'pr_status_2' => 'serret',
	'pr_status_3' => "ezhomm 'zo sikour ar staff",
	'pr_status_10' => 'dilemel an danevell',
	'pr_status_undo' => 'Dizober kemm ar statud',
	'pr_status_ask' => 'Kemmañ statud an danevell ?',
	'pr_remove_ask' => 'Dilemel da viken an danevell ?',
	'pr_status_wait' => 'gortozit...',
	'pr_read_only' => "Ne c'heller ket ouzhpennañ danevelloù nevez er mare-mañ, mar plij adklaskit diwezhatoc'h.",
	'pr_msg_exceeded' => "D'ar muiañ e c'heller lakaat 512 arouezenn er zonenn-se.
Mar plij adskrivit ho kemenadenn.",
	'pr_msg_exchead' => 'Re hir eo ar gemenadenn',
	'right-problemreports_action' => 'Kemmañ statud ha seurt an DanevelloùKudennoù',
	'right-problemreports_global' => 'Kemmañ statud ha seurt an DanevelloùKudennoù dre wikioù',
);

/** German (Deutsch)
 * @author LWChris
 * @author The Evil IP address
 */
$messages['de'] = array(
	'problemreports' => 'Liste der Problemmeldungen',
	'reportproblem' => 'Problem melden',
	'prlogtext' => 'Problemmeldungs-Logbuch',
	'prlogheader' => 'Liste gemeldeter Probleme und des jeweiligen Status',
	'prlog_reportedentry' => 'meldete ein Problem mit $1 ($2)',
	'prlog_changedentry' => 'markierte Problem $1 als „$2“',
	'prlog_typeentry' => 'änderte Art des Problems $1 auf „$2“',
	'prlog_removedentry' => 'löschte Problem $1',
	'prlog_emailedentry' => 'sandte E-Mail an $2 ($3)',
	'pr_introductory_text' => 'Die meisten Seiten in diesem Wiki können bearbeitet werden und du bist ebenfalls herzlich eingeladen dies zu tun und Fehler selbst zu korrigieren!
Wenn du dabei Hilfe brauchst, lies die [[help:Editieren|Hilfe zum Bearbeiten]] und [[help:Zurücksetzen|Hilfe zum Zurücksetzen von Vandalismus]].

Um Wikia direkt zu kontaktieren oder Urheberrechtsprobleme zu melden, benutze bitte die Seite [[Special:Contact|Kontakt zu Wikia]].

Softwarefehler können in den Foren berichtet werden.
Hier abgeschickte Berichte werden [[Special:ProblemReports|im Wiki anzeigt]].',
	'pr_what_problem' => 'Betreff',
	'pr_what_problem_spam' => 'Seite enthält Spam',
	'pr_what_problem_vandalised' => 'Die Seite wurde vandaliert',
	'pr_what_problem_incorrect_content' => 'Der Inhalt ist falsch',
	'pr_what_problem_software_bug' => 'Fehler in der Wiki-Software',
	'pr_what_problem_other' => 'Sonstiges',
	'pr_what_problem_select' => 'Bitte wähle die Art des Problems',
	'pr_what_problem_unselect' => 'Alle',
	'pr_what_problem_spam_short' => 'Spam',
	'pr_what_problem_vandalised_short' => 'Vandalismus',
	'pr_what_problem_incorrect_content_short' => 'Inhalt',
	'pr_what_problem_software_bug_short' => 'Bug',
	'pr_what_problem_other_short' => 'Sonstiges',
	'pr_what_problem_change' => 'Art des Problems ändern',
	'pr_describe_problem' => 'Nachricht',
	'pr_what_page' => 'Name der Seite',
	'pr_email_visible_only_to_staff' => 'nur sichtbar für Staff',
	'pr_thank_you' => 'Danke für die Meldung des Problems!

[[Special:ProblemReports/$1|Du kannst den aktuellen Status hier verfolgen]].',
	'pr_thank_you_error' => 'Ein Fehler ist beim Versand der Problemmeldung aufgetreten, bitte versuche es später noch einmal...',
	'pr_spam_found' => 'In deiner Zusammenfassung wurde Spam gefunden. Bitte passe sie an.',
	'pr_empty_summary' => 'Bitte gib eine kurze Problembeschreibung an',
	'pr_empty_email' => 'Bitte gib deine E-Mail-Adresse an',
	'pr_mailer_notice' => 'Die von dir in deinen Einstellungen angegebene E-Mail-Adresse wird als Absender der Mail angegeben, so dass der Empfänger dir antworten kann.',
	'pr_mailer_subject' => 'Problembericht über',
	'pr_mailer_tmp_info' => 'Du kannst die Antwortvorlagen [[MediaWiki:ProblemReportsResponses|hier]] anpassen.',
	'pr_mailer_to_default' => 'Wikia-Benutzer',
	'pr_mailer_go_to_wiki' => 'Um eine E-Mail zu schicken, gehe bitte zum [$1 Wiki, wo das Problem gemeldet wurde]',
	'pr_total_number' => 'Gesamtzahl Problemmeldungen',
	'pr_view_archive' => 'Zeige archivierte Meldungen',
	'pr_view_all' => 'Zeige alle Meldungen',
	'pr_view_staff' => 'Zeige Meldungen die Staff-Hilfe benötigen',
	'pr_raports_from_this_wikia' => 'Zeige nur Problemmeldungen dieses Wikis',
	'pr_reports_from' => 'Zeige nur Meldungen von: $1',
	'pr_no_reports' => 'Keine passenden Problemmeldungen gefunden',
	'pr_sysops_notice' => 'Wenn du den Status von Problemmeldungen deines Wikis ändern möchtest, kannst du das <a href="$1">hier</a> tun...',
	'pr_table_problem_id' => 'Problem-ID',
	'pr_table_wiki_name' => 'Wiki-Name',
	'pr_table_problem_type' => 'Art des Problems',
	'pr_table_page_link' => 'Seite',
	'pr_table_date_submitted' => 'Gemeldet am',
	'pr_table_reporter_name' => 'Gemeldet von',
	'pr_table_description' => 'Beschreibung',
	'pr_table_comments' => 'Kommentare',
	'pr_table_status' => 'Status',
	'pr_table_actions' => 'Aktionen',
	'pr_status_0' => 'offen',
	'pr_status_1' => 'behoben',
	'pr_status_2' => 'geschlossen',
	'pr_status_3' => 'benötigt Hilfe von Staff',
	'pr_status_10' => 'Meldung entfernen',
	'pr_status_undo' => 'Änderung des Status rückgängig machen',
	'pr_status_ask' => 'Status der Meldung ändern?',
	'pr_remove_ask' => 'Meldung endgültig löschen?',
	'pr_status_wait' => 'Etwas Geduld...',
	'pr_read_only' => 'Im Moment können keine neue Berichte ausgefüllt werden, bitte versuche es später erneut.',
	'pr_msg_exceeded' => 'Die maximale Anzahl der Zeichen in diesem Nachrichtenfeld ist 512.
Bitte schreibe deine Nachricht neu.',
	'pr_msg_exchead' => 'Die Nachricht ist zu lang',
	'right-problemreports_action' => 'Zustand und Art von Problemmeldungen ändern',
	'right-problemreports_global' => 'Zustand und Art von Problemmeldungen wikiübergreifend ändern',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author LWChris
 */
$messages['de-formal'] = array(
	'prlog_changedentry' => 'markierte Problem $1 als "$2"',
	'prlog_typeentry' => 'änderte Art des Problems $1 auf "$2"',
	'pr_introductory_text' => 'Die meisten Seiten in diesem Wiki können bearbeitet werden und Sie sind ebenfalls herzlich eingeladen dies zu tun und Fehler selbst zu korrigieren!
Wenn Sie dabei Hilfe brauchen, lesen Sie die [[help:Editieren|Hilfe zum Bearbeiten]] und [[help:Zurücksetzen|Hilfe zum Zurücksetzen von Vandalismus]].

Um Wikia direkt zu kontaktieren oder Urheberrechtsprobleme zu melden, benutzen Sie bitte die Seite [[Special:Contact|Kontakt zu Wikia]].

Softwarefehler können in den Foren berichtet werden.
Hier abgeschickte Berichte werden [[Special:ProblemReports|im Wiki anzeigt]].',
	'pr_what_problem_select' => 'Bitte wählen Sie die Art des Problems',
	'pr_thank_you' => 'Danke für die Meldung des Problems!

[[Special:ProblemReports/$1|Sie können den aktuellen Status hier verfolgen]].',
	'pr_thank_you_error' => 'Ein Fehler ist beim Versand der Problemmeldung aufgetreten, bitte versuchen Sie es später noch einmal...',
	'pr_spam_found' => 'In Ihrer Zusammenfassung wurde Spam gefunden. Bitte passen Sie sie an.',
	'pr_empty_summary' => 'Bitte geben Sie eine kurze Problembeschreibung an',
	'pr_empty_email' => 'Bitte geben Sie Ihre E-Mail-Adresse an',
	'pr_mailer_notice' => 'Die von Ihnen in Ihren Einstellungen angegebene E-Mail-Adresse wird als Absender der Mail angegeben, sodass der Empfänger Ihnen antworten kann.',
	'pr_mailer_tmp_info' => 'Sie können die Antwortvorlagen [[MediaWiki:ProblemReportsResponses|hier]] anpassen.',
	'pr_mailer_go_to_wiki' => 'Um eine Mail zu schicken, gehen Sie bitte zum [$1 Wiki, wo das Problem gemeldet wurde]',
	'pr_sysops_notice' => 'Wenn Sie den Status von Problemmeldungen Ihres Wikis ändern möchten, können Sie das <a href="$1">hier</a> tun...',
	'pr_read_only' => 'Im Moment können keine neue Berichte ausgefüllt werden, bitte versuchen Sie es später erneut.',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Locos epraix
 * @author Translationista
 */
$messages['es'] = array(
	'problemreports' => 'Lista de informes de problemas',
	'reportproblem' => 'Informar sobre un problema',
	'prlogtext' => 'Problemas notificados',
	'prlogheader' => 'Lista de informes sobre problemas y cambios de sus estados',
	'prlog_reportedentry' => 'reportado un problema en $1 ($2)',
	'prlog_changedentry' => 'marcado problema $1 como "$2"',
	'prlog_typeentry' => 'cambiado problema de tipo $1 a "$2"',
	'prlog_removedentry' => 'borrado problema $1',
	'prlog_emailedentry' => 'envió un correo electrónico a $2 ($3)',
	'pr_introductory_text' => 'La mayoría de las páginas de este wiki son editables, así que ¡siéntete libre de editar la página y corregir los errores que encuentres! Si necesitas ayuda al respecto, visita [[help:editing|cómo editar]] y [[help:revert|cómo revertir vandalismos]].

Para contactar con el equipo o para informar sobre problemas de derechos de autor, por favor visita[[w:contact us|la página de "contáctanos" de Wikia]].

Puedes reportar errores de software en los foros.
Los reportes que se hagan acá [[Special:ProblemReports|se mostrarán en el wiki]].',
	'pr_what_problem' => 'Tema',
	'pr_what_problem_spam' => 'hay spam aquí',
	'pr_what_problem_vandalised' => 'esta página ha sido vandalizada',
	'pr_what_problem_incorrect_content' => 'este contenido es incorrecto',
	'pr_what_problem_software_bug' => 'hay un bug en el software wiki',
	'pr_what_problem_other' => 'otro',
	'pr_what_problem_select' => 'Selecciona el tipo de problema',
	'pr_what_problem_unselect' => 'todo',
	'pr_what_problem_spam_short' => 'spam',
	'pr_what_problem_vandalised_short' => 'vándalo',
	'pr_what_problem_incorrect_content_short' => 'contenido',
	'pr_what_problem_software_bug_short' => 'error',
	'pr_what_problem_other_short' => 'otro',
	'pr_what_problem_change' => 'Cambia el tipo de problema',
	'pr_describe_problem' => 'Describe el problema',
	'pr_what_page' => 'Nombre de la página',
	'pr_email_visible_only_to_staff' => 'visible solamente para el staff',
	'pr_thank_you' => '¡Gracias por informar sobre un problema! [[Special:ProblemReports/$1|Tú puedes ver su progreso de reparación]]',
	'pr_thank_you_error' => 'Ha ocurrido un error mientras enviaba el informe sobre un problema, por favor, inténtelo más tarde...',
	'pr_spam_found' => 'Ha sido encontrado en el sumario de tu informe spam. Por favor cambia el contenido del sumario',
	'pr_empty_summary' => 'Por favor da una pequeña descripción del problema',
	'pr_empty_email' => 'Por favor da tu dirección de correo electrónico',
	'pr_mailer_notice' => 'La dirección de correo electrónico que tú introduciste en tus preferencias de usuario aparecerá en "De", para que el destinatario pueda responder.',
	'pr_mailer_subject' => 'Problema reportado en',
	'pr_mailer_tmp_info' => 'Puedes  [[MediaWiki:ProblemReportsResponses|editar respuestas convertidas en plantilla]]',
	'pr_mailer_to_default' => 'Usuario Wikia',
	'pr_mailer_go_to_wiki' => 'Para enviar un correo electrónico, por favor dirígete a [$1 problema de wiki fue reportado desde]',
	'pr_total_number' => 'Número total de informes',
	'pr_view_archive' => 'Ver problemas archivados',
	'pr_view_all' => 'Mostrar todos los informes',
	'pr_view_staff' => 'Mostrar informes que necesiten ayuda del staff',
	'pr_raports_from_this_wikia' => 'Ver informes solamente de este wiki',
	'pr_reports_from' => 'Informes solamente de: $1',
	'pr_no_reports' => 'No hay informes con este criterio',
	'pr_sysops_notice' => 'Si tú quieres cambiar el estado de un informe sobre un problema de tu wiki, por favor ve <a href="$1">aquí</a>...',
	'pr_table_problem_id' => 'ID del problema',
	'pr_table_wiki_name' => 'Nombre del wiki',
	'pr_table_problem_type' => 'Tipo de problema',
	'pr_table_page_link' => 'Página',
	'pr_table_date_submitted' => 'Fecha de envío',
	'pr_table_reporter_name' => 'Quién informa',
	'pr_table_description' => 'Descripción',
	'pr_table_comments' => 'Comentarios',
	'pr_table_status' => 'Estado',
	'pr_table_actions' => 'Acciones',
	'pr_status_0' => 'pendiente',
	'pr_status_1' => 'reparado',
	'pr_status_2' => 'cerrado',
	'pr_status_3' => 'necesaria ayuda del equipo',
	'pr_status_10' => 'borrar informe',
	'pr_status_undo' => 'Deshacer cambio en el estado del informe',
	'pr_status_ask' => '¿Cambiar estado del informe?',
	'pr_remove_ask' => '¿Borrar permanentemente el informe?',
	'pr_status_wait' => 'espere...',
	'pr_read_only' => 'Los nuevos informes no pueden ser introducidos por ahora, por favor inténtalo más tarde.',
	'pr_msg_exceeded' => 'El número máximo de caracteres en el mensaje es de 512. Por favor, reescribe tu mensaje.',
	'pr_msg_exchead' => 'Mensaje demasiado largo',
	'right-problemreports_action' => 'Cambiar el estado y el tipo de InformeDeProblemas',
	'right-problemreports_global' => 'Cambiar el estado y tipo de InformeDeProblemas en los wikis',
);

/** Persian (فارسی) */
$messages['fa'] = array(
	'problemreports' => 'فهرست گزارش‌ اشکال‌ها',
	'reportproblem' => 'گزارش اشکال',
	'pr_status_1' => 'اصلاح شد',
);

/** Finnish (Suomi)
 * @author Crt
 */
$messages['fi'] = array(
	'problemreports' => 'Ongelmaraporttien lista',
	'reportproblem' => 'Ilmoita ongelmasta',
	'prlogtext' => 'Ongelmaraportit',
	'prlogheader' => 'Lista ilmoitetuista ongelmista ja muutoksista niiden tilaan',
	'prlog_reportedentry' => 'ilmoitti ongelman sivussa $1 ($2)',
	'prlog_changedentry' => 'merkitsi ongelmalle $1 tilan ”$2”',
	'prlog_removedentry' => 'poisti ongelman $1',
	'pr_introductory_text' => 'Useimmat tämän wikin sivut ovat muokattavissa, ja olet tervetullut muokkaamaan niitä ja korjaamaan virheitä itse! Jos tarvitset apua, katso [[Help:Muokkaaminen|kuinka muokataan]] ja [[Help:Palauttaminen|kuinka vandalismia kumotaan]].

Ottaaksesi yhteyttä henkilökuntaan tai ilmoittaaksesi tekijänoikeusongelmista, katso [[w:c:fi:Ota yhteyttä|Wikian ”ota yhteyttä” -sivu]].

Ohjelmistovirheistä voi ilmoittaa foorumeilla. Tämän lomakkeen kautta tehdyt ilmoitukset [[Special:ProblemReports|näkyvät wikissä]].',
	'pr_what_problem' => 'Aihe',
	'pr_what_problem_spam' => 'täällä on mainoslinkki',
	'pr_what_problem_vandalised' => 'tätä sivua on vandalisoitu',
	'pr_what_problem_incorrect_content' => 'tämä sisältö on virheellistä',
	'pr_what_problem_software_bug' => 'ohjelmistovirhe wikiohjelmistossa',
	'pr_what_problem_other' => 'muu',
	'pr_what_problem_unselect' => 'kaikki',
	'pr_what_problem_spam_short' => 'mainoslinkki',
	'pr_what_problem_vandalised_short' => 'vandalisoitu sivu',
	'pr_what_problem_incorrect_content_short' => 'sisältö',
	'pr_what_problem_software_bug_short' => 'ohjelmistovirhe',
	'pr_what_problem_other_short' => 'muu',
	'pr_describe_problem' => 'Viesti',
	'pr_what_page' => 'Ongelmasivun nimi',
	'pr_email_visible_only_to_staff' => 'näkyy vain henkilökunnalle',
	'pr_thank_you' => 'Kiitos ongelman ilmoittamisesta.

[[Special:ProblemReports/$1|Voit tarkkailla ongelman korjausprosessia]].',
	'pr_thank_you_error' => 'Tapahtui virhe, kun ongelmaraporttia lähetettiin. Yritä myöhemmin uudestaan...',
	'pr_spam_found' => 'Raportin yhteenvedosta löytyi mainoslinkki. Muuta yhteenvedon sisältöä.',
	'pr_empty_summary' => 'Anna lyhyt kuvaus ongelmasta',
	'pr_total_number' => 'Raporttien yhteismäärä',
	'pr_view_archive' => 'Näytä arkistoidut ongelmat',
	'pr_view_all' => 'Näytä kaikki ilmoitukset',
	'pr_view_staff' => 'Näytä ilmoitukset, joissa tarvitaan henkilökunnan apua',
	'pr_raports_from_this_wikia' => 'Näytä ilmoitukset vain tästä Wikiasta',
	'pr_reports_from' => 'Raportit vain: $1',
	'pr_no_reports' => 'Mikään ilmoitus ei täsmää kriteereihisi',
	'pr_table_problem_id' => 'Ongelmatunniste',
	'pr_table_wiki_name' => 'Wikin nimi',
	'pr_table_problem_type' => 'Ongelman tyyppi',
	'pr_table_page_link' => 'Sivu',
	'pr_table_date_submitted' => 'Päivä, jolloin jätetty',
	'pr_table_reporter_name' => 'Raportoijan nimi',
	'pr_table_description' => 'Kuvaus',
	'pr_table_comments' => 'Kommentit',
	'pr_table_actions' => 'Toiminnot',
	'pr_status_0' => 'odottaa',
	'pr_status_1' => 'korjattu',
	'pr_status_2' => 'suljettu',
	'pr_status_3' => 'tarvitsee henkilökunnan apua',
	'pr_status_10' => 'poista ilmoitus',
	'pr_status_undo' => 'Kumoa ilmoituksen tilan muutos',
	'pr_status_ask' => 'Vaihda ilmoituksen tilaa?',
	'pr_remove_ask' => 'Poista ilmoitus pysyvästi?',
	'pr_status_wait' => 'odota...',
);

/** French (Français)
 * @author IAlex
 * @author Slamduck
 * @author Wyz
 * @author Zetud
 */
$messages['fr'] = array(
	'problemreports' => 'Liste des rapports de problèmes',
	'reportproblem' => 'Rapporter un problème',
	'prlogtext' => 'Rapports de problème',
	'prlogheader' => 'Liste des problèmes rapportés et les modifications de leurs statuts',
	'prlog_reportedentry' => 'a rapporté un problème sur $1 ($2)',
	'prlog_changedentry' => 'a marqué le problème $1 comme « $2 »',
	'prlog_typeentry' => 'a modifié le type du problème $1 à « $2 »',
	'prlog_removedentry' => 'a supprimé le problème $1',
	'prlog_emailedentry' => 'a envoyé un courriel $ $2 ($3)',
	'pr_introductory_text' => "La plupart des pages de ce wiki sont modifiables, et vous êtes invité à les modifier et corriger les erreurs vous-même ! Si vous avez besoin d'aide pour cela, voyez [[help:editing|comment modifier]] et [[help:revert|comment révoquer le vandalisme]].

Pour contacter le personnel ou rapporter des problèmes de droits d'auteur, utilisez [[w:contact us|la page « contactez nous » de Wikia]].

Les bogues du logiciel peuvent être rapportés sur les forums. Les rapports faits ici seront [[Special:ProblemReports|affichés sur le wiki]].",
	'pr_what_problem' => 'Objet',
	'pr_what_problem_spam' => 'il y a un lien de spam ici',
	'pr_what_problem_vandalised' => 'cette page a été vandalisée',
	'pr_what_problem_incorrect_content' => 'ce contenu est incorrect',
	'pr_what_problem_software_bug' => 'il y a un bogue dans le logiciel du wiki',
	'pr_what_problem_other' => 'autre',
	'pr_what_problem_select' => 'Sélectionnez le type du problème',
	'pr_what_problem_unselect' => 'tout',
	'pr_what_problem_spam_short' => 'spam',
	'pr_what_problem_vandalised_short' => 'vandale',
	'pr_what_problem_incorrect_content_short' => 'contenu',
	'pr_what_problem_software_bug_short' => 'bogue',
	'pr_what_problem_other_short' => 'autre',
	'pr_what_problem_change' => 'Modifier le type de problème',
	'pr_describe_problem' => 'Message',
	'pr_what_page' => 'Titre de la page',
	'pr_email_visible_only_to_staff' => 'visible uniquement au staff',
	'pr_thank_you' => "Merci d'avoir rapporté votre problème !

[[Special:ProblemReports/$1|Vous pouvez suivre de progrès de sa résolution]].",
	'pr_thank_you_error' => "Une erreur est survenue lors de l'envoi du rapport de problème, veuillez réessayer plus tard...",
	'pr_spam_found' => 'Du spam a été trouvé dans le résumé de votre rapport. Veuillez changer le contenu du résumé.',
	'pr_empty_summary' => 'Merci de fournir une courte description du problème',
	'pr_empty_email' => 'Veuillez fournir votre adresse de courriel',
	'pr_mailer_notice' => "L'adresse de courriel que vous avez entrée dans vos préférences utilisateur apparaîtra and le champ « De » du courriel, ce qui permettra aux destinataires de vous répondre.",
	'pr_mailer_subject' => 'Problème rapporté sur',
	'pr_mailer_tmp_info' => 'Vous pouvez modifier vos modèles de la réponse [[MediaWiki:ProblemReportsResponses|ici]].',
	'pr_mailer_to_default' => 'Utilisateur de Wikia',
	'pr_mailer_go_to_wiki' => 'Pour envoyer un courriel allez sur [$1 le wiki sur lequel le problème a été rapporté]',
	'pr_total_number' => 'Nombre total de rapports',
	'pr_view_archive' => 'Voir les rapports affichés',
	'pr_view_all' => 'Afficher tous les rapports',
	'pr_view_staff' => "Afficher les rapports qui nécessitent l'aide du staff",
	'pr_raports_from_this_wikia' => 'Voir les rapports de ce Wikia seulement',
	'pr_reports_from' => 'Rapports seulement depuis : $1',
	'pr_no_reports' => 'Aucun rapport ne correspond à vos critères',
	'pr_sysops_notice' => 'Si vous voulez changer le statut du rapport de problème depuis votre wiki, allez <a href="$1">ici</a>...',
	'pr_table_problem_id' => 'ID du problème',
	'pr_table_wiki_name' => 'Nom du wiki',
	'pr_table_problem_type' => 'Type du problème',
	'pr_table_page_link' => 'Page',
	'pr_table_date_submitted' => 'Date de soumission',
	'pr_table_reporter_name' => 'Nom du rapporteur',
	'pr_table_description' => 'Description',
	'pr_table_comments' => 'Commentaires',
	'pr_table_status' => 'Statut',
	'pr_table_actions' => 'Actions',
	'pr_status_0' => 'en attente',
	'pr_status_1' => 'résolu',
	'pr_status_2' => 'fermé',
	'pr_status_3' => "nécessite l'aide du personnel",
	'pr_status_10' => 'supprimer le rapport',
	'pr_status_undo' => 'Défaire la modification de statut',
	'pr_status_ask' => 'Modifier le statut du rapport ?',
	'pr_remove_ask' => 'Supprimer le rapport de manière permanente ?',
	'pr_status_wait' => 'patientez...',
	'pr_read_only' => 'Les nouveaux rapports ne peuvent pas êtres ajoutés actuellement, veuillez réessayer plus tard.',
	'pr_msg_exceeded' => 'Le nombre maximum de caractères du champs de saisie est de 512. Veuillez réécrire votre message.',
	'pr_msg_exchead' => 'Le message est trop long',
	'right-problemreports_action' => 'Modifier le statut et le type de rapports de problèmes',
	'right-problemreports_global' => 'Modifier le statut et le type de rapports de problèmes au travers des wikis',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'problemreports' => 'Lista de informes de problemas',
	'reportproblem' => 'Informar sobre un problema',
	'prlogtext' => 'Informes de problemas',
	'prlogheader' => 'Lista de informes de problemas e cambios dos seus estados',
	'prlog_reportedentry' => 'informou sobre un problema en $1 ($2)',
	'prlog_changedentry' => 'marcou o problema $1 como "$2"',
	'prlog_typeentry' => 'cambiou o tipo do problema $1 a "$2"',
	'prlog_removedentry' => 'eliminou o problema $1',
	'prlog_emailedentry' => 'enviou unha mensaxe de correo a $2 ($3)',
	'pr_introductory_text' => 'A maioría das páxinas deste wiki pódense editar. De feito, está convidado a corrixir calquera erro que atope! Se necesita axuda para facelo, consulte [[help:editing|como editar]] e [[help:revert|como desfacer un vandalismo]].

Para poñerse en contacto co persoal ou informar sobre un problema cos dereitos de autor, consulte [[w:contact us|a páxina "contacte con nós" de Wikia]].

Pode informar dos erros do software nos foros. Os informes feitos aquí [[Special:ProblemReports|mostraranse no wiki]].',
	'pr_what_problem' => 'Asunto',
	'pr_what_problem_spam' => 'hai unha ligazón de spam aquí',
	'pr_what_problem_vandalised' => 'esta páxina foi vandalizada',
	'pr_what_problem_incorrect_content' => 'este contido é incorrecto',
	'pr_what_problem_software_bug' => 'hai un erro no software do wiki',
	'pr_what_problem_other' => 'outro',
	'pr_what_problem_select' => 'Por favor, seleccione o tipo de problema',
	'pr_what_problem_unselect' => 'todos',
	'pr_what_problem_spam_short' => 'spam',
	'pr_what_problem_vandalised_short' => 'vándalo',
	'pr_what_problem_incorrect_content_short' => 'contido',
	'pr_what_problem_software_bug_short' => 'erro',
	'pr_what_problem_other_short' => 'outro',
	'pr_what_problem_change' => 'Cambiar o tipo de problema',
	'pr_describe_problem' => 'Mensaxe',
	'pr_what_page' => 'Título da páxina',
	'pr_email_visible_only_to_staff' => 'visible soamente para o persoal',
	'pr_thank_you' => 'Grazas por informar sobre o problema!

[[Special:ProblemReports/$1|Pode vixiar o progreso da súa resolución]].',
	'pr_thank_you_error' => 'Houbo un erro ao enviar o informe de problemas, por favor, inténteo de novo máis tarde...',
	'pr_spam_found' => 'Atopouse spam no resumo do seu informe. Por favor, cambie os contidos do resumo',
	'pr_empty_summary' => 'Por favor, dea unha pequena descrición do problema',
	'pr_empty_email' => 'Por favor, dea o seu enderezo de correo electrónico',
	'pr_mailer_notice' => 'O enderezo de correo electrónico que inseriu nas súas preferencias de usuario aparecerá no campo "De" do correo electrónico, de xeito que o destinatario sexa capaz de responder.',
	'pr_mailer_subject' => 'Informou sobre un problema en',
	'pr_mailer_tmp_info' => 'Pode editar os modelos de resposta [[MediaWiki:ProblemReportsResponses|aquí]]',
	'pr_mailer_to_default' => 'Usuario de Wikia',
	'pr_mailer_go_to_wiki' => 'Para enviar un correo electrónico, vaia [$1 ao wiki onde se informou sobre o problema]',
	'pr_total_number' => 'Número total de informes',
	'pr_view_archive' => 'Ollar o arquivo de problemas',
	'pr_view_all' => 'Mostrar todos os informes',
	'pr_view_staff' => 'Mostrar os informes que precisan a axuda do persoal',
	'pr_raports_from_this_wikia' => 'Ollar soamente os informes deste Wikia',
	'pr_reports_from' => 'Soamente os informes de: $1',
	'pr_no_reports' => 'Non hai ningún informe que coincida cos seus criterios',
	'pr_sysops_notice' => 'Se quere mudar o estado do informe sobre un problema do seu wiki, vaia <a href="$1">aquí</a>...',
	'pr_table_problem_id' => 'ID do problema',
	'pr_table_wiki_name' => 'Nome do wiki',
	'pr_table_problem_type' => 'Tipo de problema',
	'pr_table_page_link' => 'Páxina',
	'pr_table_date_submitted' => 'Data de envío',
	'pr_table_reporter_name' => 'Nome do informador',
	'pr_table_description' => 'Descrición',
	'pr_table_comments' => 'Comentarios',
	'pr_table_status' => 'Estado',
	'pr_table_actions' => 'Accións',
	'pr_status_0' => 'á espera',
	'pr_status_1' => 'arranxado',
	'pr_status_2' => 'pechado',
	'pr_status_3' => 'necesita a axuda do persoal',
	'pr_status_10' => 'eliminar o informe',
	'pr_status_undo' => 'Desfacer o cambio de estado do informe',
	'pr_status_ask' => 'Quere cambiar o estado do informe?',
	'pr_remove_ask' => 'Quere eliminar permanentemente o informe?',
	'pr_status_wait' => 'agarde...',
	'pr_read_only' => 'Nestes intres non se poden cubrir novos informes, por favor, inténteo de novo máis tarde.',
	'pr_msg_exceeded' => 'O número máximo de caracteres no campo da mensaxe é de 512. Por favor, volva escribir a súa mensaxe.',
	'pr_msg_exchead' => 'A mensaxe é demasiado longa',
	'right-problemreports_action' => 'Cambiar o estado e tipo de informe sobre un problema',
	'right-problemreports_global' => 'Cambiar o estado e tipo de informe sobre un problema no resto de wikis',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'pr_table_page_link' => 'Shafi',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 * @author Misibacsi
 */
$messages['hu'] = array(
	'problemreports' => 'Problémajelentések',
	'reportproblem' => 'Probléma jelentése',
	'prlogtext' => 'Problémajelentések',
	'prlogheader' => 'A jelentett problémák listája és a változások azok állapotában',
	'pr_what_problem' => 'Tárgy',
	'pr_what_problem_spam' => 'ez egy spam link',
	'pr_what_problem_vandalised' => 'ezt az oldalt megrongálták',
	'pr_what_problem_incorrect_content' => 'ez a tartalom nem megfelelő',
	'pr_what_problem_software_bug' => 'van egy hiba a wiki szoftverben',
	'pr_what_problem_other' => 'egyéb',
	'pr_what_problem_select' => 'Kérjük, válassza ki a probléma típusát',
	'pr_what_problem_unselect' => 'összes',
	'pr_what_problem_spam_short' => 'spam',
	'pr_what_problem_vandalised_short' => 'vandalizmus',
	'pr_what_problem_incorrect_content_short' => 'tartalom',
	'pr_what_problem_software_bug_short' => 'bug',
	'pr_what_problem_other_short' => 'egyéb',
	'pr_what_problem_change' => 'Probléma típusának megváltoztatása',
	'pr_describe_problem' => 'Üzenet',
	'pr_what_page' => 'A lap címe',
	'pr_email_visible_only_to_staff' => 'csak személyzet láthatja',
	'pr_thank_you' => 'Köszönjük, hogy jelentette a problémát! 

[[Special:ProblemReports/$1|Itt követhető a kijavítása]].',
	'pr_thank_you_error' => 'Hiba történt a hibajelentés küldése közben, próbálkozz később...',
	'pr_empty_summary' => 'Add meg a probléma rövid leírását',
	'pr_empty_email' => 'Add meg az e-mail címedet',
	'pr_mailer_notice' => 'A beállításaidnál megadott email cím lesz a levél küldője, így a címzett tud válaszolni.',
	'pr_mailer_subject' => 'Problémabejelentése ideje:',
	'pr_mailer_to_default' => 'Wikia felhasználó',
	'pr_total_number' => 'Hibajelentések száma összesen',
	'pr_view_all' => 'Összes bejelentés megjelenítése',
	'pr_table_problem_id' => 'Probléma azonosító',
	'pr_table_wiki_name' => 'Wiki neve',
	'pr_table_problem_type' => 'Probléma típusa',
	'pr_table_page_link' => 'Lap',
	'pr_table_date_submitted' => 'Beküldve',
	'pr_table_reporter_name' => 'Bejelentő neve',
	'pr_table_description' => 'Leírás',
	'pr_table_comments' => 'Megjegyzések',
	'pr_table_status' => 'Állapot',
	'pr_table_actions' => 'Műveletek',
	'pr_status_0' => 'függőben',
	'pr_status_1' => 'javítva',
	'pr_status_2' => 'lezárva',
	'pr_status_10' => 'jelentés eltávolítása',
	'pr_remove_ask' => 'Hibajelentés végleges törlése?',
	'pr_status_wait' => 'várj…',
	'pr_msg_exchead' => 'Az üzenet túl hosszú',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'problemreports' => 'Lista de reportos de problemas',
	'reportproblem' => 'Reportar un problema',
	'prlogtext' => 'Reportos de problemas',
	'prlogheader' => 'Lista de problemas reportate e cambios de lor stato',
	'prlog_reportedentry' => 'reportava un problema super $1 ($2)',
	'prlog_changedentry' => 'marcava le problema $1 como "$2"',
	'prlog_typeentry' => 'cambiava le typo del problema $1 a "$2"',
	'prlog_removedentry' => 'removeva le problema $1',
	'prlog_emailedentry' => 'inviava un message de e-mail a $2 ($3)',
	'pr_introductory_text' => 'Le majoritate del paginas in iste wiki es modificabile, e tu es benvenite a modificar le pagina e corriger errores tu mesme! Si tu ha necessitate de adjuta con isto, vide [[help:editing|como modificar]] e [[help:revert|como reverter vandalismo]].

Pro contactar le personal o pro reportar problemas de copyright, vide [[w:contact us|le pagina "contacta nos" de Wikia]].

Defectos in le software pote esser reportate in le foros. Le reportos facite hic essera [[Special:ProblemReports|publicate in le wiki]].',
	'pr_what_problem' => 'Subjecto',
	'pr_what_problem_spam' => 'il ha un ligamine de spam hic',
	'pr_what_problem_vandalised' => 'iste pagina ha essite vandalisate',
	'pr_what_problem_incorrect_content' => 'iste contento es incorrecte',
	'pr_what_problem_software_bug' => 'il ha un defecto in le software del wiki',
	'pr_what_problem_other' => 'altere',
	'pr_what_problem_select' => 'Selige le typo del problema',
	'pr_what_problem_unselect' => 'totes',
	'pr_what_problem_spam_short' => 'spam',
	'pr_what_problem_vandalised_short' => 'vandalo',
	'pr_what_problem_incorrect_content_short' => 'contento',
	'pr_what_problem_software_bug_short' => 'defecto',
	'pr_what_problem_other_short' => 'altere',
	'pr_what_problem_change' => 'Cambiar le typo de problema',
	'pr_describe_problem' => 'Message',
	'pr_what_page' => 'Titulo del pagina',
	'pr_email_visible_only_to_staff' => 'visibile solmente al personal',
	'pr_thank_you' => 'Gratias pro reportar un problema!

[[Special:ProblemReports/$1|Tu pote observar le progresso de su reparation]].',
	'pr_thank_you_error' => 'Un error occurreva durante le invio del reporto, per favor reproba plus tarde…',
	'pr_spam_found' => 'Spam ha essite trovate in le summario de tu reporto. Per favor cambia le contento del summario',
	'pr_empty_summary' => 'Per favor entra un curte description del problema',
	'pr_empty_email' => 'Per favor entra tu adresse de e-mail',
	'pr_mailer_notice' => 'Le adresse de e-mail que tu entrava in tu preferentias apparera in le campo "De" in le e-mail, de sorta que destinatario potera responder.',
	'pr_mailer_subject' => 'Problema reportate super',
	'pr_mailer_tmp_info' => 'Tu pote modificar le patronos de responsas [[MediaWiki:ProblemReportsResponses|hic]].',
	'pr_mailer_to_default' => 'Usator de Wikia',
	'pr_mailer_go_to_wiki' => 'Pro inviar e-mail, visita le [$1 wiki ubi le problema ha essite reportate].',
	'pr_total_number' => 'Numero total de reportos',
	'pr_view_archive' => 'Vider le reportos archivate',
	'pr_view_all' => 'Monstrar tote le reportos',
	'pr_view_staff' => 'Monstra le reportos que necessita le adjuta del personal',
	'pr_raports_from_this_wikia' => 'Vider reportos solmente de iste Wikia',
	'pr_reports_from' => 'Reportos solmente de: $1',
	'pr_no_reports' => 'Nulle reporto corresponde a tu criterios.',
	'pr_sysops_notice' => 'Si tu vole cambiar le stato del reportos de problemas ab tu wiki, visita <a href="$1">iste pagina</a>...',
	'pr_table_problem_id' => 'ID del problema',
	'pr_table_wiki_name' => 'Nomine del wiki',
	'pr_table_problem_type' => 'Typo del problema',
	'pr_table_page_link' => 'Pagina',
	'pr_table_date_submitted' => 'Data de submission',
	'pr_table_reporter_name' => 'Nomine del reportator',
	'pr_table_description' => 'Description',
	'pr_table_comments' => 'Commentos',
	'pr_table_status' => 'Stato',
	'pr_table_actions' => 'Actiones',
	'pr_status_0' => 'pendente',
	'pr_status_1' => 'reparate',
	'pr_status_2' => 'claudite',
	'pr_status_3' => 'necessita le adjuta del personal',
	'pr_status_10' => 'remover reporto',
	'pr_status_undo' => 'Disfacer cambio del stato del reporto',
	'pr_status_ask' => 'Cambiar le stato del reporto?',
	'pr_remove_ask' => 'Remover permanentemente le reporto?',
	'pr_status_wait' => 'un momento…',
	'pr_read_only' => 'Non es possibile adder nove reportos al momento, per favor reproba plus tarde.',
	'pr_msg_exceeded' => 'Le numero maxime de characteres in le campo Message es 512. Per favor rescribe tu message.',
	'pr_msg_exchead' => 'Le message es troppo longe',
	'right-problemreports_action' => 'Modificar le stato e typo de reportos de problemas',
	'right-problemreports_global' => 'Cambiar le stato e typo de reportos de problemas trans wikis',
);

/** Indonesian (Bahasa Indonesia)
 * @author Irwangatot
 */
$messages['id'] = array(
	'pr_what_problem_unselect' => 'semua',
	'pr_what_problem_vandalised_short' => 'perusak',
	'pr_describe_problem' => 'Pesan',
	'pr_table_wiki_name' => 'Nama wiki',
	'pr_table_problem_type' => 'Jenis masalah',
	'pr_table_page_link' => 'Halaman',
	'pr_table_date_submitted' => 'Tanggal ditambahkan',
	'pr_table_reporter_name' => 'Nama pelapor',
	'pr_msg_exchead' => 'Pesan terlalu panjang',
);

/** Igbo (Igbo) */
$messages['ig'] = array(
	'pr_describe_problem' => 'Ozi',
	'pr_table_actions' => 'Mmèmé',
);

/** Italian (Italiano) */
$messages['it'] = array(
	'pr_what_problem' => 'Oggetto',
	'pr_what_problem_other' => 'altro',
	'pr_what_problem_unselect' => 'tutti',
	'pr_what_problem_incorrect_content_short' => 'contenuto',
	'pr_what_problem_other_short' => 'altro',
	'pr_describe_problem' => 'Messaggio',
	'pr_what_page' => 'Titolo della pagina',
	'pr_table_page_link' => 'Pagina',
	'pr_table_description' => 'Descrizione',
	'pr_table_comments' => 'Commenti',
	'pr_table_status' => 'Stato',
	'pr_table_actions' => 'Azioni',
	'pr_status_2' => 'chiusa',
);

/** Japanese (日本語)
 * @author Hosiryuhosi
 * @author Naohiro19
 * @author Tommy6
 */
$messages['ja'] = array(
	'problemreports' => '報告された問題のリスト',
	'reportproblem' => '問題の報告',
	'prlogtext' => '問題を報告する',
	'prlogheader' => '問題の報告と問題のステータス変更についての記録です。',
	'prlog_reportedentry' => '$1 ($2) の問題を報告',
	'prlog_changedentry' => '問題 $1 を "$2" にマーク',
	'prlog_typeentry' => '問題のタイプを $1 から $2 へ変更',
	'prlog_emailedentry' => '$2 に $3 についてのメールを送信',
	'pr_introductory_text' => 'このウィキのほとんどのページは編集可能です。もし間違いがあったら、是非とも編集して、間違いを直してしまってください。編集の仕方がわからない場合は、[[Help:編集の仕方|ヘルプページ]]などをご覧ください。

スタッフと連絡をとったり、著作権上の問題を報告する場合は、[[w:c:ja:連絡先|ウィキアの連絡用ページ]]をご覧ください。

ソフトウェアのバグは、[[w:c:ja:Forum:不具合・要望|フォーラム]]で報告できます。ウィキに報告された各種問題は、[[Special:ProblemReports|こちら]]で見ることができます。',
	'pr_what_problem' => '問題の種類',
	'pr_what_problem_spam' => '宣伝リンクがあります',
	'pr_what_problem_vandalised' => 'ページが荒されています',
	'pr_what_problem_incorrect_content' => '内容に誤りがあります',
	'pr_what_problem_software_bug' => 'ソフトウェアにバグがあります',
	'pr_what_problem_other' => 'その他',
	'pr_what_problem_select' => '問題の種類を教えてください',
	'pr_what_problem_unselect' => '全て',
	'pr_what_problem_spam_short' => 'スパム',
	'pr_what_problem_vandalised_short' => '荒し',
	'pr_what_problem_incorrect_content_short' => '内容の誤り',
	'pr_what_problem_software_bug_short' => 'バグ',
	'pr_what_problem_other_short' => 'その他',
	'pr_what_problem_change' => '問題のタイプを変更',
	'pr_describe_problem' => '詳細',
	'pr_what_page' => 'ページ名',
	'pr_email_visible_only_to_staff' => 'スタッフに対してのみ表示',
	'pr_thank_you' => '報告ありがとうございます!

[[Special:ProblemReports/$1|こちらから修正の確認を行えます]]',
	'pr_thank_you_error' => 'エラーが発生して、問題の送信が出来ませんでした。あとでもう一度お願いいたします。',
	'pr_spam_found' => '報告の要約の中にスパムと思われるものが見つかりました。要約の内容を変更してください。',
	'pr_empty_summary' => '問題の詳細を入力してください',
	'pr_empty_email' => 'メールアドレスを入力してください',
	'pr_mailer_notice' => 'メールを受け取った人が返信できるように、あなたがオプションページで設定したEメールアドレスが送信されるメールの送信元 (From) として設定されます。',
	'pr_mailer_subject' => '報告された問題について',
	'pr_mailer_tmp_info' => '[[MediaWiki:ProblemReportsResponses|返信用のテンプレートを編集できます]]',
	'pr_mailer_to_default' => 'Wikia User',
	'pr_mailer_go_to_wiki' => 'メールを送信するには[$1 問題が報告されたウィキを訪れる必要があります]。',
	'pr_total_number' => '報告の総数',
	'pr_view_archive' => 'アーカイブにされた問題を見る',
	'pr_view_all' => '全ての報告を見る',
	'pr_view_staff' => 'スタッフのヘルプが必要な問題を見る',
	'pr_table_problem_id' => 'ID',
	'pr_table_wiki_name' => 'ウィキ名',
	'pr_table_problem_type' => '問題のタイプ',
	'pr_table_page_link' => 'ページ',
	'pr_table_date_submitted' => '報告された日時',
	'pr_table_reporter_name' => '報告者',
	'pr_table_description' => '解説',
	'pr_table_comments' => 'コメント',
	'pr_table_status' => '状況',
	'pr_table_actions' => '問題の状況の変更',
	'pr_status_0' => '継続中',
	'pr_status_1' => '解決',
	'pr_status_2' => '終了',
	'pr_status_3' => 'スタッフによるヘルプが必要',
	'pr_status_wait' => 'お待ちください....',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'pr_describe_problem' => 'ಸಂದೇಶ',
	'pr_table_description' => 'ವಿವರ',
	'pr_table_status' => 'ಸ್ಥಾನಮಾನ',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'pr_what_problem' => 'Sujet',
	'pr_what_problem_other' => 'anerer',
	'pr_what_problem_spam_short' => 'Spam',
	'pr_what_problem_vandalised_short' => 'Vandal',
	'pr_what_problem_software_bug_short' => 'Bug',
	'pr_what_problem_other_short' => 'anerer',
	'pr_describe_problem' => 'Message',
	'pr_what_page' => 'Titel vun der Säit',
	'pr_mailer_to_default' => 'Wikia Benotzer',
	'pr_table_wiki_name' => 'Numm vun der Wiki',
	'pr_table_page_link' => 'Säit',
	'pr_table_description' => 'Beschreiwung',
	'pr_table_actions' => 'Aktiounen',
	'pr_status_1' => 'geléist',
	'pr_status_2' => 'zougemaach',
	'pr_status_wait' => 'waart w.e.g. ...',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'problemreports' => 'Список на пријавени проблеми',
	'reportproblem' => 'Пријави проблем',
	'prlogtext' => 'Пријавени проблеми',
	'prlogheader' => 'Список на пријавени проблеми и промени во нивниот статус',
	'prlog_reportedentry' => 'пријавен проблем на $1 ($2)',
	'prlog_changedentry' => 'означен проблемот $1 како „$2“',
	'prlog_typeentry' => 'променет типот на проблемот $1 во „$2“',
	'prlog_removedentry' => 'отстранет проблем $1',
	'prlog_emailedentry' => 'испратена порака по е-пошта на $2 ($3)',
	'pr_introductory_text' => 'Највеќето страници на ова вики се уредливи, и затоа сте добредојдени самите да ја уредите страницата и да ги поправите грешките! Ако ви треба помош со тоа, погледајте ги напатствијата [[help:editing|како се уредува]] и [[help:revert|како се враќаат вандализми]].

За да го контактирате персоналот или да пријавите проблеми со авторски права, одете на [[w:contact us|страницата за контакт на Викија]].

Грешките во програмот можат да се пријават на форумите. Таквите пријави ќе бидат [[Special:ProblemReports|истакнати на викито]].',
	'pr_what_problem' => 'Наслов',
	'pr_what_problem_spam' => 'тука има спам-врска',
	'pr_what_problem_vandalised' => 'оваа страница е вандализирана',
	'pr_what_problem_incorrect_content' => 'оваа содржина не е точна',
	'pr_what_problem_software_bug' => 'има грешка во викисофтверот',
	'pr_what_problem_other' => 'друго',
	'pr_what_problem_select' => 'Изберете тип на проблем',
	'pr_what_problem_unselect' => 'сите',
	'pr_what_problem_spam_short' => 'спам',
	'pr_what_problem_vandalised_short' => 'вандализам',
	'pr_what_problem_incorrect_content_short' => 'содржина',
	'pr_what_problem_software_bug_short' => 'грешка',
	'pr_what_problem_other_short' => 'друго',
	'pr_what_problem_change' => 'Промени тип на проблем',
	'pr_describe_problem' => 'Порака',
	'pr_what_page' => 'Наслов на страницата',
	'pr_email_visible_only_to_staff' => 'видливо само за персонал',
	'pr_thank_you' => 'Ви благодариме што пријавивте проблем!

[[Special:ProblemReports/$1|Можете да го набљудувате напредокот во неговото поправање]].',
	'pr_thank_you_error' => 'Се појави грешка при испраќањето на пријавата. Обидете се подоцна...',
	'pr_spam_found' => 'Во описот на вашата пријава е пронајден спам. Променете ја содржината на описот',
	'pr_empty_summary' => 'Накратко опишете го проблемот',
	'pr_empty_email' => 'Наведете ја вашата е-поштенска адреса',
	'pr_mailer_notice' => 'Е-поштенската адреса што ја внесовте во вашите кориснички нагодувања ќе се прикаже како адреса на испраќачот („Од“) во писмото, за да може примачот да ви одговори.',
	'pr_mailer_subject' => 'Пријавен проблем на',
	'pr_mailer_tmp_info' => 'Можете да уредувате шаблонизирани одговори [[MediaWiki:ProblemReportsResponses|овде]]',
	'pr_mailer_to_default' => 'Корисник на Викија',
	'pr_mailer_go_to_wiki' => 'За да испратите е-пошта одете на [$1 викито од кое е пријавен проблемот]',
	'pr_total_number' => 'Вкупен број на пријави',
	'pr_view_archive' => 'Прикажи архивирани проблеми',
	'pr_view_all' => 'Прикажи ги сите пријави',
	'pr_view_staff' => 'Прикажи пријави што бараат помош од персонал',
	'pr_raports_from_this_wikia' => 'Прикажи пријави само од оваа Викија',
	'pr_reports_from' => 'Само пријави од: $1',
	'pr_no_reports' => 'Нема пријави што се совпаѓаат со бараното',
	'pr_sysops_notice' => 'Ако сакате да го промените статусот на некој пријавен проблем за вашето вики, појдете <a href="$1">тука</a>...',
	'pr_table_problem_id' => 'ID на проблемот',
	'pr_table_wiki_name' => 'Име на викито',
	'pr_table_problem_type' => 'Тип на проблем',
	'pr_table_page_link' => 'Страница',
	'pr_table_date_submitted' => 'Поднесено на',
	'pr_table_reporter_name' => 'Име на пријавувачот',
	'pr_table_description' => 'Опис',
	'pr_table_comments' => 'Коментари',
	'pr_table_status' => 'Статус',
	'pr_table_actions' => 'Мерки',
	'pr_status_0' => 'во исчекување',
	'pr_status_1' => 'поправено',
	'pr_status_2' => 'затворено',
	'pr_status_3' => 'потребна помош од персонал',
	'pr_status_10' => 'отстрани пријава',
	'pr_status_undo' => 'Врати промена на статус на пријавата',
	'pr_status_ask' => 'Да го променам статусот на пријавата?',
	'pr_remove_ask' => 'Да ја отстранам пријавата засекогаш?',
	'pr_status_wait' => 'почекајте...',
	'pr_read_only' => 'Во моментов не можат да се поднесуваат нови пријави. Обидете се подоцна.',
	'pr_msg_exceeded' => 'Во полето за пишување на порака дозволени се највеќе 512 знаци. Препишете ја пораката пократко.',
	'pr_msg_exchead' => 'Пораката е преголема',
	'right-problemreports_action' => 'Измени состојба и тип на ПријавувањеПроблеми',
	'right-problemreports_global' => 'Менување на состојба и тип на ПријавувањПроблеми низ разни викија',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'pr_table_page_link' => 'Хуудас',
);

/** Dutch (Nederlands)
 * @author McDutchie
 * @author Siebrand
 */
$messages['nl'] = array(
	'problemreports' => 'Lijst probleemmeldingen',
	'reportproblem' => 'Meld een probleem',
	'prlogtext' => 'Probleemmeldingen',
	'prlogheader' => 'Lijst van gemelde problemen en veranderingen van hun status',
	'prlog_reportedentry' => 'heeft een probleem gemeld op $1 ($2)',
	'prlog_changedentry' => 'heeft probleem $1 gemarkeerd als "$2"',
	'prlog_typeentry' => 'heeft het probleemtype van $1 veranderd in "$2"',
	'prlog_removedentry' => 'heeft probleem $1 verwijderd',
	'prlog_emailedentry' => 'e-mail verstuurd naar $2 ($3)',
	'pr_introductory_text' => 'De meeste pagina\'s op deze wiki kunnen bewerkt worden, en het staat u vrij de pagina te bewerken en fouten te corrigeren!
Als u hierbij help nodig hebt, zie dan de hulppagina\'s "[[help:editing|Hoe te bewerken]]" en "[[help:revert|hoe vandalisme terug te draaien]]."

Om contact op te nemen met staf of om auteursrechtenproblemen te melden, kunt u gebruik make van de [[w:contact us|contactpagina van Wikia]].

Softwareproblemen kunt u melden op de forums.
Hier gemelde problemen zijn [[Special:ProblemReports|zichtbaar op de wiki]].',
	'pr_what_problem' => 'Onderwerp',
	'pr_what_problem_spam' => 'er is hier een spamlink',
	'pr_what_problem_vandalised' => 'deze pagina is gevandaliseerd',
	'pr_what_problem_incorrect_content' => 'deze inhoud is incorrect',
	'pr_what_problem_software_bug' => 'er is een bug in de wiki software',
	'pr_what_problem_other' => 'overige',
	'pr_what_problem_select' => 'Kies een type probleem',
	'pr_what_problem_unselect' => 'alle',
	'pr_what_problem_spam_short' => 'spam',
	'pr_what_problem_vandalised_short' => 'vandalisme',
	'pr_what_problem_incorrect_content_short' => 'inhoud',
	'pr_what_problem_software_bug_short' => 'bug',
	'pr_what_problem_other_short' => 'overige',
	'pr_what_problem_change' => 'Probleemtype wijzigen',
	'pr_describe_problem' => 'Bericht',
	'pr_what_page' => 'Paginanaam',
	'pr_email_visible_only_to_staff' => 'alleen zichtbaar voor stafmedewerkers',
	'pr_thank_you' => 'Bedankt voor het melden van een probleem!

[[Special:ProblemReports/$1|U kunt de status van het oplossen ervan volgen.]]',
	'pr_thank_you_error' => 'Er is een fout opgetreden bij het versturen van het probleem.
Probeer het later alstublieft nog een keer...',
	'pr_spam_found' => 'Er is spam gevonden in de samenvatting van uw melding.
Wijzig de tekst van de samenvatting alstublieft.',
	'pr_empty_summary' => 'Geef een korte probleembeschrijving op',
	'pr_empty_email' => 'Geef uw e-mailadres op',
	'pr_mailer_notice' => 'Het e-mailadres dat u hebt ingevuld bij uw gebruikersvoorkeuren wordt gebruikt als het "Van"-adres voor de e-mail, zodat de ontvanger kan antwoorden.',
	'pr_mailer_subject' => 'Probleem gemeld op',
	'pr_mailer_tmp_info' => 'U kunt de [[MediaWiki:ProblemReportsResponses|antwoordsjablonen bewerken]]',
	'pr_mailer_to_default' => 'Wikia-gebruiker',
	'pr_mailer_go_to_wiki' => 'U kunt een e-mail sturen vanuit [$1 de wiki waar het probleem gemeld is]',
	'pr_total_number' => 'Totaal aantal meldingen',
	'pr_view_archive' => 'Bekijk gearchiveerde meldingen',
	'pr_view_all' => 'Bekijk alle meldingen',
	'pr_view_staff' => 'Bekijk meldingen waarbij hulp van staff nodig is',
	'pr_raports_from_this_wikia' => 'Bekijk alleen meldingen van deze Wikia',
	'pr_reports_from' => 'Alleen meldingen van: $1',
	'pr_no_reports' => 'Er zijn geen meldingen die voldoen aan uw criteria',
	'pr_sysops_notice' => '<a href="$1">Wijzig de status van probleemrapporten van uw wiki</a>.',
	'pr_table_problem_id' => 'Probleem ID',
	'pr_table_wiki_name' => 'Naam van de wiki',
	'pr_table_problem_type' => 'Type probleem',
	'pr_table_page_link' => 'Pagina',
	'pr_table_date_submitted' => 'Datum gemeld',
	'pr_table_reporter_name' => 'Naam van de melder',
	'pr_table_description' => 'Beschrijving',
	'pr_table_comments' => 'Opmerkingen',
	'pr_table_status' => 'Status',
	'pr_table_actions' => 'Handelingen',
	'pr_status_0' => 'in behandeling',
	'pr_status_1' => 'opgelost',
	'pr_status_2' => 'gesloten',
	'pr_status_3' => 'hulp van staff nodig',
	'pr_status_10' => 'verwijder melding',
	'pr_status_undo' => 'Maak de verandering van status ongedaan',
	'pr_status_ask' => 'De status van de melding veranderen?',
	'pr_remove_ask' => 'De melding voorgoed verwijderen?',
	'pr_status_wait' => 'wacht...',
	'pr_read_only' => 'Nieuwe meldingen kunnen nu niet toegevoegd worden, probeer het a.u.b. later.',
	'pr_msg_exceeded' => 'Het maximum aantal tekens in het berichtveld is 512.
Kort uw bericht alstublieft in.',
	'pr_msg_exchead' => 'Bericht is te lang',
	'right-problemreports_action' => 'Status en type van probeemrapporten wijzigen',
	'right-problemreports_global' => "Status en type van probeemrapporten in alle wiki's wijzigen",
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'problemreports' => 'Problemrapportsliste',
	'reportproblem' => 'Rapporter et problem',
	'prlogtext' => 'Problemrapporter',
	'prlogheader' => 'Liste over rapporterte problem og endringer i deres status',
	'prlog_reportedentry' => 'rapporterte et problem på $1 ($2)',
	'prlog_changedentry' => 'markerte problem $1 som «$2»',
	'prlog_typeentry' => 'endret problem $1 sin type til «$2»',
	'prlog_removedentry' => 'fjernet problem $1',
	'prlog_emailedentry' => 'sendte e-postmelding til $2 ($3)',
	'pr_introductory_text' => 'De fleste sider på denne wikien kan redigeres og du må gjerne redigere sider og rette opp feil selv.
Om du trenger hjelp med dette, se [[help:editing|hvordan redigere]] og [[help:revert|hvordan tilbakestille vandalisme]].

For å kontakte staben eller rapportere brudd på opphavsrett, se [[w:contact us|Wikias «kontakt oss»-side]].

Programvarefeil kan rapporteres på forumene.
Rapporter som gjøres her vil bli [[Special:ProblemReports|vist på wikien]].',
	'pr_what_problem' => 'Emne',
	'pr_what_problem_spam' => 'det er en søppellenke her',
	'pr_what_problem_vandalised' => 'denne siden har blitt vandalisert',
	'pr_what_problem_incorrect_content' => 'dette innholdet er ukorrekt',
	'pr_what_problem_software_bug' => 'det er en feil i wiki-programvaren',
	'pr_what_problem_other' => 'andre',
	'pr_what_problem_select' => 'Vennligst velg problemtype',
	'pr_what_problem_unselect' => 'alle',
	'pr_what_problem_spam_short' => 'spam',
	'pr_what_problem_vandalised_short' => 'vandal',
	'pr_what_problem_incorrect_content_short' => 'innhold',
	'pr_what_problem_software_bug_short' => 'feil',
	'pr_what_problem_other_short' => 'andre',
	'pr_what_problem_change' => 'Endre problemtype',
	'pr_describe_problem' => 'Melding',
	'pr_what_page' => 'Tittel på siden',
	'pr_email_visible_only_to_staff' => 'kun synlig for stab',
	'pr_thank_you' => 'Takk for at du rapporterte et problem.

[[Special:ProblemReports/$1|Du kan følge løsningen av det her]].',
	'pr_thank_you_error' => 'En feil oppsto under innsending av problemrapporten, prøv igjen senere...',
	'pr_spam_found' => 'Søppel ble funnet i rapportsammendraget ditt.
Endre innholdet i sammendraget',
	'pr_empty_summary' => 'Gi en kort beskrivelse av problemet',
	'pr_empty_email' => 'Oppgi e-postadressen din',
	'pr_mailer_notice' => 'E-postadressen du oppga i brukerinnstillingene dine vil stå som «Fra»-adresse i e-posten slik at mottakeren kan svare deg.',
	'pr_mailer_subject' => 'Rapportert problem om',
	'pr_mailer_tmp_info' => 'Du kan [[MediaWiki:ProblemReportsResponses|redigere svarmaler]]',
	'pr_mailer_to_default' => 'Wikiabruker',
	'pr_mailer_go_to_wiki' => 'For å sende e-post, gå til [$1 wikien problemet ble rapportert fra]',
	'pr_total_number' => 'Totalt antall rapporter',
	'pr_view_archive' => 'Vis arkiverte problem',
	'pr_view_all' => 'Vis alle rapporter',
	'pr_view_staff' => 'Vis rapporter som trenger hjelp fra staben',
	'pr_raports_from_this_wikia' => 'Vis rapporter fra bare denne Wikiaen',
	'pr_reports_from' => 'Rapporter kun fra: $1',
	'pr_no_reports' => 'Ingen rapporter passet dine kriterier',
	'pr_sysops_notice' => 'Du kan <a href="$1">endre status på problemrapporter</a> fra din wiki...',
	'pr_table_problem_id' => 'Problem-ID',
	'pr_table_wiki_name' => 'Wikinavn',
	'pr_table_problem_type' => 'Problemtype',
	'pr_table_page_link' => 'Side',
	'pr_table_date_submitted' => 'Dato innsendt',
	'pr_table_reporter_name' => 'Rapportør',
	'pr_table_description' => 'Beskrivelse',
	'pr_table_comments' => 'Kommentarer',
	'pr_table_status' => 'Status',
	'pr_table_actions' => 'Handlinger',
	'pr_status_0' => 'venter',
	'pr_status_1' => 'fikset',
	'pr_status_2' => 'lukket',
	'pr_status_3' => 'trenger hjelp fra stab',
	'pr_status_10' => 'fjern rapport',
	'pr_status_undo' => 'Angre endring av rapportstatus',
	'pr_status_ask' => 'Endre rapportstatus?',
	'pr_remove_ask' => 'Fjerne rapport permanent?',
	'pr_status_wait' => 'vent ...',
	'pr_read_only' => 'Nye rapporter kan ikke sendes akkurat nå, prøv igjen senere.',
	'pr_msg_exceeded' => 'Maks antall tegn i meldingsfeltet er 512.
Skriv meldingen din på nytt.',
	'pr_msg_exchead' => 'Meldingen er for lang',
	'right-problemreports_action' => 'Endre tilstand og type på problemrapporter',
	'right-problemreports_global' => 'Endre tilstand og type på problemrapporter på tvers av wikier',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'pr_table_page_link' => 'Blatt',
	'pr_table_comments' => 'Aamaerickinge',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'problemreports' => 'Lista zgłoszonych problemów',
	'reportproblem' => 'Zgłoś problem',
	'prlogtext' => 'Zgłoszone problemy',
	'prlogheader' => 'Lista zgłoszonych problemów i zmian w ich statusach',
	'prlog_reportedentry' => 'zgłoszono problem z $1 ($2)',
	'prlog_changedentry' => 'oznaczono problem $1 jako "$2"',
	'prlog_typeentry' => 'zmieniono rodzaj problemu $1 na "$2"',
	'prlog_removedentry' => 'usunięto problem $1',
	'prlog_emailedentry' => 'wysłał wiadomość email do $2 ($3)',
	'pr_introductory_text' => 'Większość stron na tej wiki jest edytowalna i zachęcamy Ciebie do ich edycji oraz korygowania błędów w ich treści! Jeśli potrzebujesz pomocy, zobacz poradnik [[help:editing|jak edytować strony]] i [[help:revert|jak usuwać wandalizmy]].

Aby skontaktować się z zarządcami wiki lub zgłosić problem związany z prawami autorskimi, zajrzyj na stronę [[w:contact us|kontakt z Wikią]].

Błędy w oprogramowaniu mogą być zgłaszane na forach. Problemy zgłaszane tutaj będą [[Special:ProblemReports|widoczne na wiki]].',
	'pr_what_problem' => 'Temat',
	'pr_what_problem_spam' => 'na stronie znajduje się link spamera',
	'pr_what_problem_vandalised' => 'strona padła ofiarą wandala',
	'pr_what_problem_incorrect_content' => 'zawartość strony jest niepoprawna',
	'pr_what_problem_software_bug' => 'w oprogramowaniu znajduje się błąd',
	'pr_what_problem_other' => 'inny',
	'pr_what_problem_select' => 'Proszę wybrać rodzaj problemu',
	'pr_what_problem_unselect' => 'wszystkie',
	'pr_what_problem_spam_short' => 'spam',
	'pr_what_problem_vandalised_short' => 'wandalizm',
	'pr_what_problem_incorrect_content_short' => 'zawartość',
	'pr_what_problem_software_bug_short' => 'błąd',
	'pr_what_problem_other_short' => 'inny',
	'pr_what_problem_change' => 'Zmień rodzaj problemu',
	'pr_describe_problem' => 'Wiadomość',
	'pr_what_page' => 'Tytuł strony',
	'pr_email_visible_only_to_staff' => 'dostępny tylko dla administracji Wikii',
	'pr_thank_you' => 'Dziękujemy za zgłoszenie problemu!

[[Special:ProblemReports/$1|Możesz obserować postępy w jego rozwiązywaniu]].',
	'pr_thank_you_error' => 'Wystąpił problem w czasie wysyłania raportu, spróbuj później...',
	'pr_spam_found' => 'Wykryto spam w treści komentarza. Prosimy skorygować jego treść',
	'pr_empty_summary' => 'Podaj krótki opis problemu',
	'pr_empty_email' => 'Podaj swój adres emailowy',
	'pr_mailer_notice' => 'Adres e-mailowy, który został przez Ciebie wprowadzony w Twoich preferencjach pojawi się w polu "Od", dzięki temu odbiorca będzie mógł Ci odpowiedzieć',
	'pr_mailer_subject' => 'Zgłoszono problem związany z',
	'pr_mailer_tmp_info' => 'Możesz edytować schematy odpowiedzi na [[MediaWiki:ProblemReportsResponses|tej stronie]]',
	'pr_mailer_to_default' => 'Użytkownik Wikii',
	'pr_mailer_go_to_wiki' => 'Aby wysłać e-mail przejdź na stronę [$1 na której został zgłoszony wiki problem]',
	'pr_total_number' => 'Łączna liczba raportów',
	'pr_view_archive' => 'Przejrzyj archiwalne raporty',
	'pr_view_all' => 'Przeglądaj wszystkie raporty',
	'pr_view_staff' => 'Przejrzyj raporty wymagające pomocy administracji Wikii',
	'pr_raports_from_this_wikia' => 'Przejrzyj raporty dotyczące tylko tej Wikii',
	'pr_reports_from' => 'Raporty wyłącznie z $1',
	'pr_no_reports' => 'Brak raportów',
	'pr_sysops_notice' => 'Jeśli chcesz dokonać zmian w statusie raportów, proszę przejść <a href="$1">tutaj</a>...',
	'pr_table_problem_id' => 'ID problemu',
	'pr_table_wiki_name' => 'Nazwa Wikii',
	'pr_table_problem_type' => 'Rodzaj problemu',
	'pr_table_page_link' => 'Strona',
	'pr_table_date_submitted' => 'Data zgłoszenia',
	'pr_table_reporter_name' => 'Kto zgłosił',
	'pr_table_description' => 'Opis',
	'pr_table_comments' => 'Komentarze',
	'pr_table_status' => 'Status',
	'pr_table_actions' => 'Akcje',
	'pr_status_0' => 'oczekuje',
	'pr_status_1' => 'naprawione',
	'pr_status_2' => 'to nie jest problem',
	'pr_status_3' => 'konieczna pomoc',
	'pr_status_10' => 'usuń raport',
	'pr_status_undo' => 'Cofnij zmianę statusu raportu',
	'pr_status_ask' => 'Zmienić status raportu?',
	'pr_remove_ask' => 'Na pewno usunąć raport?',
	'pr_status_wait' => 'czekaj...',
	'pr_read_only' => 'Nowe zgłoszenia nie mogą zostać teraz dodane, prosimy spróbować później.',
	'pr_msg_exceeded' => 'Maksymalna liczba znaków w polu Wiadomości wynosi 512, prosimy o zmianę zawartości tego pola.',
	'pr_msg_exchead' => 'Wiadomość jest zbyt długa',
	'right-problemreports_action' => 'Zmiana stanu i typu raportów o problemach.',
	'right-problemreports_global' => 'Zmiana stanu i typu raportów o problemach pomiędzy różnymi wiki',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'problemreports' => 'Lista dij rapòrt ëd problema',
	'reportproblem' => 'Arpòrta un problema',
	'prlogtext' => 'Rapòrt ëd problema',
	'prlogheader' => 'Lista dij problema riportà e dij cangiament dij sò stat',
	'prlog_reportedentry' => "a l'ha arportà un problema su $1 ($2)",
	'prlog_changedentry' => 'a l\'ha marcà ël problema $1 com "$2"',
	'prlog_typeentry' => 'a l\'ha cangià la sòrt dël problema $1 a "$2"',
	'prlog_removedentry' => "a l'ha gavà ël problema $1",
	'prlog_emailedentry' => "a l'ha mandà un mëssagi ëd pòsta eletrònica a $2 ($3)",
	'pr_introductory_text' => "La pi part ëd le pàgine su sta wiki-sì a son modificàbij, e chiel-midem a l'é bin ëvnù a modifiché pàgine e corege j'eror! S'a l'ha dabzògn d'agiut për felo, ch'a varda [[help:editing|com modifiché]] e [[help:revert|com gavé ij vandalism]].

Për contaté l'echip o për arporté problema ëd drit d'autor, për piasì ch'a varda la [[w:contact us|pàgina \"contatne\" ëd Wikia]].

Ij difet dël programa a peulo esse arportà an sle piasse ëd discussion. Ij rapòrt fàit ambelelà a saran [[Special:ProblemReports|visualisà an sla wiki]].",
	'pr_what_problem' => 'Soget',
	'pr_what_problem_spam' => 'a-i é un colegament ëd rumenta sì',
	'pr_what_problem_vandalised' => "sta pàgina-sì a l'é stàita vandalisà",
	'pr_what_problem_incorrect_content' => "sto contnù-sì a l'é pa giust",
	'pr_what_problem_software_bug' => 'a-i é un bigat ant ël programa dla wiki',
	'pr_what_problem_other' => 'àutr',
	'pr_what_problem_select' => "Për piasì, ch'a selession-a ël tipo ëd problema",
	'pr_what_problem_unselect' => 'tut',
	'pr_what_problem_spam_short' => 'rumenta',
	'pr_what_problem_vandalised_short' => 'vàndal',
	'pr_what_problem_incorrect_content_short' => 'contnù',
	'pr_what_problem_software_bug_short' => 'bigat',
	'pr_what_problem_other_short' => 'àutr',
	'pr_what_problem_change' => 'cangé sòrt ëd problema',
	'pr_describe_problem' => 'Mëssagi',
	'pr_what_page' => 'Tìtol ëd la pàgina',
	'pr_email_visible_only_to_staff' => "visìbil mach a l'echip",
	'pr_thank_you' => "Mersì d'avèj arpòrtà un problema!

[[Special:ProblemReports/$1|A peule ten-e sot euj ël progress ëd soa coression]].",
	'pr_thank_you_error' => "Eror capità an mandand ël rapòrt ëd problema, për piasì ch'a preuva pi tard...",
	'pr_spam_found' => "A l'é stàita trovà dla rumenta ant ël resumé ëd tò rapòrt. Për piasì ch'a cangia ël contnù dël resumé.",
	'pr_empty_summary' => 'Për piasì, dé na curta descrission dël problema',
	'pr_empty_email' => "Për piasì, ch'a buta soa adrëssa ëd pòsta eletrònica",
	'pr_mailer_notice' => "L'adrëssa ëd pòsta eletrònica ch'a l'ha anserì ant ij sò gust d'utent a comparirà ant ël camp \"Da\" dël mëssagi, parèj ël destinatari a podrà arsponde.",
	'pr_mailer_subject' => 'Problema arportà dzora a',
	'pr_mailer_tmp_info' => "It peule modifiché j'arsposte a stamp [[MediaWiki:ProblemReportsResponses|ambelessì]]",
	'pr_mailer_to_default' => 'Utent ëd Wikia',
	'pr_mailer_go_to_wiki' => "Për mandé un mëssagi ëd pòsta eletrònica, për piasì ch'a vada an sla [$1 wiki anté che 'l problema a l'é stàit arportà]",
	'pr_total_number' => 'Nùmer total ëd rapòrt',
	'pr_view_archive' => 'Vëdde ij problema archivià',
	'pr_view_all' => 'Smon-e tùit ij rapòrt',
	'pr_view_staff' => "Smon-e ij rapòrt ch'a l'han dabzògn ëd l'agiut ëd l'echip",
	'pr_raports_from_this_wikia' => 'Varda mach ij rapòrt da sta Wikia-sì',
	'pr_reports_from' => 'Rapòrt mach da: $1',
	'pr_no_reports' => 'Pa gnun rapòrt a rispeta tò criteri',
	'pr_sysops_notice' => 'S\'a veul cangé lë stat dij rapòrt ëd problema da soa wiki, për piasì ch\'a vada a <a href="$1">ambelessì</a>...',
	'pr_table_problem_id' => 'ID dël problema',
	'pr_table_wiki_name' => 'Nòm dla wiki',
	'pr_table_problem_type' => 'Sòrt ëd problema',
	'pr_table_page_link' => 'Pàgina',
	'pr_table_date_submitted' => 'Data ëd presentassion',
	'pr_table_reporter_name' => "Nòm ëd chi a l'ha fàit ël rapòrt",
	'pr_table_description' => 'Descrission',
	'pr_table_comments' => 'Coment',
	'pr_table_status' => 'Stat',
	'pr_table_actions' => 'Assion',
	'pr_status_0' => "ch'a speto",
	'pr_status_1' => 'coregiù',
	'pr_status_2' => 'sarà',
	'pr_status_3' => "a l'han dabzògn ëd l'agiut ëd l'echip",
	'pr_status_10' => 'gava rapòrt',
	'pr_status_undo' => 'Gavé ël cangiament dlë stat dël rapòrt',
	'pr_status_ask' => 'Cangé stat dël rapòrt?',
	'pr_remove_ask' => 'Gavé rapòrt përmanentement?',
	'pr_status_wait' => 'speta...',
	'pr_read_only' => "Ij rapòrt neuv a peulo pa esse compilà ant ës moment-sì, për piasì ch'a preuva torna pi tard.",
	'pr_msg_exceeded' => "Ël nùmer màssim ëd caràter ant ël camp Mëssagi a l'é 512. Për piasì, ch'a scriva torna sò mëssagi.",
	'pr_msg_exchead' => 'Mëssagi tròp longh',
	'right-problemreports_action' => 'Cangé lë statù e la sòrt ëd Rapòrt ëd Problema',
	'right-problemreports_global' => 'Cangé statù e sòrt ëd Rapòrt ëd Problema a travers dle wiki',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'pr_what_problem' => 'سکالو',
	'pr_what_problem_other' => 'بل',
	'pr_what_problem_unselect' => 'ټول',
	'pr_what_problem_other_short' => 'بل',
	'pr_describe_problem' => 'پيغام',
	'pr_mailer_to_default' => 'د ويکي يا کارن',
	'pr_table_wiki_name' => 'ويکي نوم',
	'pr_table_page_link' => 'مخ',
	'pr_table_description' => 'څرګندونه',
	'pr_table_comments' => 'تبصرې',
	'pr_table_status' => 'دريځ',
	'pr_status_2' => 'تړل شوی',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'problemreports' => 'Lista de problemas reportados',
	'reportproblem' => 'Reportar um problema',
	'prlogtext' => 'Relatórios de problemas',
	'prlogheader' => 'Lista dos problemas reportados e das alterações do seu estado',
	'prlog_reportedentry' => 'reportou um problema em $1 ($2)',
	'prlog_changedentry' => 'marcou o problema $1 como "$2"',
	'prlog_typeentry' => 'alterou o tipo do problema $1 para "$2"',
	'prlog_removedentry' => 'removeu o problema $1',
	'prlog_emailedentry' => 'enviou mensagem de correio para $2 ($3)',
	'pr_introductory_text' => 'A maioria das páginas nesta wiki são editáveis; pode editar a página e corrigir os erros que existam!
Se precisa de ajuda, consulte [[help:editing|como editar]] e [[help:revert|como reverter vandalismo]].

Para contactar a equipa ou reportar problemas relacionados com direitos de autor, consulte [[w:contact us|a página "contactos" da Wikia]].

Problemas do software podem ser reportados nos fóruns.
Os problemas reportados aqui serão [[Special:ProblemReports|apresentados na wiki]].',
	'pr_what_problem' => 'Assunto',
	'pr_what_problem_spam' => 'existe aqui um link de spam',
	'pr_what_problem_vandalised' => 'esta página foi vandalizada',
	'pr_what_problem_incorrect_content' => 'este conteúdo está incorrecto',
	'pr_what_problem_software_bug' => 'há um problema no software da wiki',
	'pr_what_problem_other' => 'outro',
	'pr_what_problem_select' => 'Seleccione o tipo de problema, por favor',
	'pr_what_problem_unselect' => 'todos',
	'pr_what_problem_spam_short' => 'spam',
	'pr_what_problem_vandalised_short' => 'vandalismo',
	'pr_what_problem_incorrect_content_short' => 'conteúdo',
	'pr_what_problem_software_bug_short' => 'software',
	'pr_what_problem_other_short' => 'outro',
	'pr_what_problem_change' => 'Alterar o tipo do problema',
	'pr_describe_problem' => 'Mensagem',
	'pr_what_page' => 'Título da página',
	'pr_email_visible_only_to_staff' => 'só visível para a equipa',
	'pr_thank_you' => 'Obrigado por reportar o problema!

[[Special:ProblemReports/$1|Pode acompanhar o progresso da resolução]].',
	'pr_thank_you_error' => 'Ocorreu um erro ao enviar o relatório do problema; tente novamente mais tarde, por favor...',
	'pr_spam_found' => 'Foi identificado spam no seu relatório do problema.
Altere o conteúdo do resumo, por favor',
	'pr_empty_summary' => 'Introduza uma descrição breve do problema, por favor',
	'pr_empty_email' => 'Introduza o seu correio electrónico, por favor',
	'pr_mailer_notice' => 'O endereço de correio electrónico que introduziu nas suas preferências irá aparecer como endereço de origem da mensagem, por isso o destinatário poderá responder-lhe.',
	'pr_mailer_subject' => 'Reportou o problema em',
	'pr_mailer_tmp_info' => 'Pode [[MediaWiki:ProblemReportsResponses|editar os modelos de respostas]]',
	'pr_mailer_to_default' => 'Utilizador da Wikia',
	'pr_mailer_go_to_wiki' => 'Para enviar uma mensagem electrónica visite a [$1 wiki de onde o problema foi reportado], por favor',
	'pr_total_number' => 'Número total de problemas',
	'pr_view_archive' => 'Ver problemas arquivados',
	'pr_view_all' => 'Mostrar todos os problemas',
	'pr_view_staff' => 'Mostrar problemas que necessitam de ajuda da equipa',
	'pr_raports_from_this_wikia' => 'Ver somente os problemas desta Wikia',
	'pr_reports_from' => 'Só os problemas de: $1',
	'pr_no_reports' => 'Não existem problemas para os critérios fornecidos',
	'pr_sysops_notice' => 'Pode <a href="$1">alterar o estado dos problemas reportados</a> a partir da sua wiki...',
	'pr_table_problem_id' => 'ID do problema',
	'pr_table_wiki_name' => 'Nome da wiki',
	'pr_table_problem_type' => 'Tipo do problema',
	'pr_table_page_link' => 'Página',
	'pr_table_date_submitted' => 'Data de envio',
	'pr_table_reporter_name' => 'Nome do autor',
	'pr_table_description' => 'Descrição',
	'pr_table_comments' => 'Comentários',
	'pr_table_status' => 'Estado',
	'pr_table_actions' => 'Acções',
	'pr_status_0' => 'pendente',
	'pr_status_1' => 'corrigido',
	'pr_status_2' => 'fechado',
	'pr_status_3' => 'é necessária ajuda da equipa',
	'pr_status_10' => 'remover problema',
	'pr_status_undo' => 'Desfazer a alteração do estado',
	'pr_status_ask' => 'Alterar o estado do problema?',
	'pr_remove_ask' => 'Remover o problema de forma definitiva?',
	'pr_status_wait' => 'aguarde...',
	'pr_read_only' => 'Não podem ser criados relatórios novos neste momento; tente novamente mais tarde, por favor',
	'pr_msg_exceeded' => 'O número máximo de caracteres permitidos no campo da mensagem é 512.
Altere a mensagem, por favor.',
	'pr_msg_exchead' => 'A mensagem é demasiado longa',
	'right-problemreports_action' => 'Alterar o estado e tipo dos problemas reportados',
	'right-problemreports_global' => 'Alterar o estado e tipo dos problemas reportados em todas as wikis',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 * @author Jesielt
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'problemreports' => 'Lista de problemas reportados',
	'reportproblem' => 'Reporte um problema',
	'prlogtext' => 'Problemas reportados',
	'prlogheader' => 'Lista de problemas reportados e mudanças em seus estados',
	'prlog_reportedentry' => 'reportado um problema em $1 ($2)',
	'prlog_changedentry' => 'problema $1 marcado como "$2"',
	'prlog_typeentry' => 'alterou o tipo do problema $1 para "$2"',
	'prlog_removedentry' => 'removido problema $1',
	'prlog_emailedentry' => 'mensagem de email enviada a $2 ($3)',
	'pr_introductory_text' => 'A maioria das páginas nessa wiki são editáveis e você é bem-vindo para editá-las e corrigir erros você mesmo! Se você está procurando por ajuda, veja [[help:editing|como editar]] e [[help:revert|como reverter vandalismos]].

Para contatar o pessoal para reportar violações de direitos autorais, por favor, veja a página [[w:contact us|"fale conosco" do Wikia]].

Bugs do software podem ser reportados nos fóruns. As reportagens feitas aqui serão [[Special:ProblemReports|mostradas nessa wiki]].',
	'pr_what_problem' => 'Assunto',
	'pr_what_problem_spam' => 'há um link spam aqui',
	'pr_what_problem_vandalised' => 'essa página foi vandalizada',
	'pr_what_problem_incorrect_content' => 'esse conteúdo está incorreto',
	'pr_what_problem_software_bug' => 'há um bug no software wiki',
	'pr_what_problem_other' => 'outro',
	'pr_what_problem_select' => 'Por favor selecione um tipo de problema',
	'pr_what_problem_unselect' => 'tudo',
	'pr_what_problem_spam_short' => 'spam',
	'pr_what_problem_vandalised_short' => 'vândalo',
	'pr_what_problem_incorrect_content_short' => 'conteúdo',
	'pr_what_problem_software_bug_short' => 'bug',
	'pr_what_problem_other_short' => 'outro',
	'pr_what_problem_change' => 'Mudar o tipo de problema',
	'pr_describe_problem' => 'Mensagem',
	'pr_what_page' => 'Título da página',
	'pr_email_visible_only_to_staff' => 'Visível apenas para o pessoal',
	'pr_thank_you' => 'Obrigado por reportar um problema!

[[Special:ProblemReports/$1|Você pode vigiar o progresso da correção dele aqui]].',
	'pr_thank_you_error' => 'Ocorreu um erro enquanto estava sendo enviado a reportagem de problema, por favor, tente novamente mais tarde...',
	'pr_spam_found' => 'Um spam foi encontrado no sumário do seu relatório.
Por favor, mude o conteúdo do sumário.',
	'pr_empty_summary' => 'Por favor, faça uma pequena descrição do problema',
	'pr_empty_email' => 'Por favor, coloque o seu endereço de email',
	'pr_mailer_notice' => 'O endereço de email que você colocou nas suas preferências irá aparecer na mensagem como o "remetente", assim o destinatário poderá te responder diretamente.',
	'pr_mailer_subject' => 'Problema reportado em',
	'pr_mailer_tmp_info' => 'Você pode [[MediaWiki:ProblemReportsResponses|editar a predefinição de respostas]]',
	'pr_mailer_to_default' => 'Usuário Wikia',
	'pr_mailer_go_to_wiki' => 'Para enviar um email, por favor, vá a [$1 problema da wiki foi reportado de]',
	'pr_total_number' => 'Número total de reportagens',
	'pr_view_archive' => 'Ver problemas arquivados',
	'pr_view_all' => 'Mostrar todas as reportagens',
	'pr_view_staff' => 'Mostrar reportagens que precisam da ajuda da equipe de ajuda (staff)',
	'pr_raports_from_this_wikia' => 'Ver reportagens somente desta wiki',
	'pr_reports_from' => 'Só os problemas de: $1',
	'pr_no_reports' => 'Não há reportagens com esse critério',
	'pr_sysops_notice' => 'Você pode <a href="$1">mudar o status das reportagens de problemas</a> da sua wiki...',
	'pr_table_problem_id' => 'ID do problema',
	'pr_table_wiki_name' => 'Nome da Wiki',
	'pr_table_problem_type' => 'Tipo de problema',
	'pr_table_page_link' => 'Página',
	'pr_table_date_submitted' => 'Data de Envio',
	'pr_table_reporter_name' => 'Nome do reportante',
	'pr_table_description' => 'Descrição',
	'pr_table_comments' => 'Comentários',
	'pr_table_status' => 'Estado',
	'pr_table_actions' => 'Ações',
	'pr_status_0' => 'pendente',
	'pr_status_1' => 'resolvido',
	'pr_status_2' => 'fechado',
	'pr_status_3' => 'precisa da ajuda da equipe de apoio (staff)',
	'pr_status_10' => 'remover reportagem',
	'pr_status_undo' => 'Desfazer mudança no estado do relatório',
	'pr_status_ask' => 'Mudar estado da reportagem?',
	'pr_remove_ask' => 'Remover a reportagem permanentemente?',
	'pr_status_wait' => 'aguarde...',
	'pr_read_only' => 'Novas reportagens não podem ser feitas agora, por favor, tente novamente mais tarde.',
	'pr_msg_exceeded' => 'O número máximo de caracteres da mesnagem é te 512. 
Por favor, reescreva a sua mensagem.',
	'pr_msg_exchead' => 'A mensagem está muito grande.',
	'right-problemreports_action' => 'Alterar o estado e tipo dos problemas reportados',
	'right-problemreports_global' => 'Alterar o estado e tipo dos problemas reportados em todas as wikis',
);

/** Russian (Русский)
 * @author Eleferen
 * @author Lockal
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'problemreports' => 'Список сообщений о проблемах',
	'reportproblem' => 'Сообщить о проблеме',
	'prlogtext' => 'Сообщения о проблемах',
	'prlogheader' => 'Список сообщений о проблемах и изменений их статуса',
	'prlog_reportedentry' => 'сообщил о проблеме в $1 ($2)',
	'prlog_changedentry' => 'установил отметку «$2» для проблемы $1',
	'prlog_typeentry' => 'изменил изменил тип проблемы $1 на «$2»',
	'prlog_removedentry' => 'удалил проблему $1',
	'prlog_emailedentry' => 'отправил сообщение по электронной почте $2 ($3)',
	'pr_introductory_text' => 'Большинство страниц в этой вики доступны для редактирования, что позволяет изменить их и исправить ошибки самостоятельно. Если вам нужна помощь в этом, см. [[help:editing|справку по редактированию]] и [[help:revert|по откату вандализма]].

Для связи с сотрудниками или сообщений о проблемах с авторским правом, пожалуйста, используйте [[w:contact us|страницу обратной связи Викия]].

Об ошибках в программном обеспечении можно сообщить на форуме. Такие сообщения будут [[Special:ProblemReports|отображены в вики]].',
	'pr_what_problem' => 'Тема',
	'pr_what_problem_spam' => 'здесь присутствует спам-ссылка',
	'pr_what_problem_vandalised' => 'эта страница была вандализирована',
	'pr_what_problem_incorrect_content' => 'содержательная ошибка',
	'pr_what_problem_software_bug' => 'ошибка в программном обеспечении вики',
	'pr_what_problem_other' => 'другое',
	'pr_what_problem_select' => 'Пожалуйста, выберите тип проблемы',
	'pr_what_problem_unselect' => 'все',
	'pr_what_problem_spam_short' => 'спам',
	'pr_what_problem_vandalised_short' => 'вандализм',
	'pr_what_problem_incorrect_content_short' => 'содержание',
	'pr_what_problem_software_bug_short' => 'ошибка',
	'pr_what_problem_other_short' => 'другое',
	'pr_what_problem_change' => 'Измените тип проблемы',
	'pr_describe_problem' => 'Сообщение',
	'pr_what_page' => 'Название страницы',
	'pr_email_visible_only_to_staff' => 'отображается только для сотрудников',
	'pr_thank_you' => 'Благодарим вас за сообщение о проблеме!

[[Special:ProblemReports/$1|Вы можете следить за её решением]].',
	'pr_thank_you_error' => 'Произошла ошибка при отправке сообщения о проблеме, пожалуйста, повторите попытку позже…',
	'pr_spam_found' => 'В кратком описании сообщения обнаружен спам.
Пожалуйста, изменение содержание краткого описания.',
	'pr_empty_summary' => 'Пожалуйста, предоставьте краткое описание проблемы',
	'pr_empty_email' => 'Пожалуйста, укажите адрес вашей электронной почты',
	'pr_mailer_notice' => 'Заданный в ваших настройках адрес электронной почты будет указан в поле письма «От кого», поэтому получатель будет иметь возможность ответить.',
	'pr_mailer_subject' => 'Сообщение о проблеме в',
	'pr_mailer_tmp_info' => 'Вы можете [[MediaWiki:ProblemReportsResponses|редактировать шаблоны ответов]]',
	'pr_mailer_to_default' => 'Участник Викии',
	'pr_mailer_go_to_wiki' => 'Для отправки письма, пожалуйста, перейдите на страницу [$1 вики проблемы, полученной от]',
	'pr_total_number' => 'Общее число сообщений',
	'pr_view_archive' => 'Просмотр архива проблем',
	'pr_view_all' => 'Показать все сообщения',
	'pr_view_staff' => 'Показать сообщения, требующие помощи сотрудников',
	'pr_raports_from_this_wikia' => 'Просмотр сообщений только из этой Wikia',
	'pr_reports_from' => 'Сообщения только от: $1',
	'pr_no_reports' => 'Нет сообщений, соответствующих заданному критерию',
	'pr_sysops_notice' => 'Вы можете <a href="$1">изменять статус сообщений о проблемах</a> в вашей вики…',
	'pr_table_problem_id' => 'ID проблемы',
	'pr_table_wiki_name' => 'Название вики',
	'pr_table_problem_type' => 'Тип проблемы',
	'pr_table_page_link' => 'Страница',
	'pr_table_date_submitted' => 'Дата отправки',
	'pr_table_reporter_name' => 'Имя сообщившего',
	'pr_table_description' => 'Описание',
	'pr_table_comments' => 'Комментарии',
	'pr_table_status' => 'Статус',
	'pr_table_actions' => 'Действия',
	'pr_status_0' => 'на рассмотрении',
	'pr_status_1' => 'исправлена',
	'pr_status_2' => 'закрыта',
	'pr_status_3' => 'необходима помощь сотрудников',
	'pr_status_10' => 'удалить сообщение',
	'pr_status_undo' => 'Отменить изменение статуса сообщения',
	'pr_status_ask' => 'Изменить статус сообщения?',
	'pr_remove_ask' => 'Удалить сообщение навсегда?',
	'pr_status_wait' => 'подождите…',
	'pr_read_only' => 'В настоящее время новые сообщения не могут быть оформлены, пожалуйста, повторите попытку позже.',
	'pr_msg_exceeded' => 'Максимальное количество символов в поле сообщения составляет 512.
Пожалуйста, перепишите ваше сообщение.',
	'pr_msg_exchead' => 'Слишком длинное сообщение',
	'right-problemreports_action' => 'изменение состояний и типов сообщений об проблемах',
	'right-problemreports_global' => 'изменение состояний и типов сообщений о проблемах во всех вики',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'pr_table_page_link' => 'Stran',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Verlor
 */
$messages['sr-ec'] = array(
	'reportproblem' => 'Пријави проблем',
	'prlogtext' => 'Извештај о проблему',
	'pr_what_problem' => 'Тема',
	'pr_what_problem_spam' => 'Постоји један спам линк',
	'pr_what_problem_vandalised' => 'Страница је вандализована',
	'pr_what_problem_incorrect_content' => 'Садржај није тачан',
	'pr_what_problem_software_bug' => 'Постоји буг у вики софтверу',
	'pr_what_problem_other' => 'остало',
	'pr_what_problem_select' => 'Молимо Вас да изаберете тип проблема',
	'pr_what_problem_unselect' => 'све',
	'pr_what_problem_spam_short' => 'спам',
	'pr_what_problem_vandalised_short' => 'вандал',
	'pr_what_problem_incorrect_content_short' => 'садржај',
	'pr_what_problem_software_bug_short' => 'буг (софтверска грешка)',
	'pr_what_problem_other_short' => 'остало',
	'pr_what_problem_change' => 'Промените тип проблема',
	'pr_describe_problem' => 'Порука',
	'pr_what_page' => 'Наслов стране',
	'pr_email_visible_only_to_staff' => 'Видљиво само за особље',
	'pr_empty_summary' => 'Молимо Вас да укратко опишете проблем',
	'pr_empty_email' => 'Молимо Вас да дате адресу е-поште',
	'pr_mailer_to_default' => 'Викија корисник',
	'pr_total_number' => 'Укупни број извештаја',
	'pr_view_archive' => 'Погледај архивиране проблеме',
	'pr_view_all' => 'Покажи све извештаје',
	'pr_raports_from_this_wikia' => 'Покажи извештаје само са ове Викије',
	'pr_table_problem_id' => 'ИД проблема',
	'pr_table_wiki_name' => 'Име викије',
	'pr_table_problem_type' => 'Тип проблема',
	'pr_table_page_link' => 'Страна',
	'pr_table_date_submitted' => 'Датум слања',
	'pr_table_reporter_name' => 'Име известиоца проблема',
	'pr_table_description' => 'Опис',
	'pr_table_comments' => 'коментари',
	'pr_table_status' => 'Статус',
	'pr_table_actions' => 'Акције',
	'pr_status_0' => 'На чекању',
	'pr_status_1' => 'Отклоњен проблем',
	'pr_status_2' => 'Затворено',
	'pr_status_3' => 'Потребна помоћ особља',
	'pr_status_10' => 'Уклоњен извештај',
	'pr_status_wait' => 'причекајте...',
	'pr_msg_exchead' => 'Порука је предугачка',
);

/** Swedish (Svenska)
 * @author Per
 */
$messages['sv'] = array(
	'problemreports' => 'Problemrapportlista',
	'reportproblem' => 'Rapportera ett problem',
	'prlogtext' => 'Problemrapporter',
	'prlogheader' => 'Lista över rapporterade problem och ändringar på deras status',
	'prlog_reportedentry' => 'rapportera ett problem med $1 ($2)',
	'prlog_typeentry' => 'ändrat problemet $1s typ till "$2"',
	'prlog_emailedentry' => 'skickat e-post till $2 ($3)',
	'pr_what_problem' => 'Ärende',
	'pr_what_problem_spam' => 'det finns en spam-länk här',
	'pr_what_problem_vandalised' => 'den här sidan har blivit vandaliserad',
	'pr_what_problem_incorrect_content' => 'innehållet är felaktigt',
	'pr_what_problem_software_bug' => 'Det finns en bug i wiki-mjukvaran',
	'pr_what_problem_other' => 'annat',
	'pr_what_problem_select' => 'Välj typ av problem',
	'pr_what_problem_unselect' => 'alla',
	'pr_what_problem_spam_short' => 'spam',
	'pr_what_problem_vandalised_short' => 'vandal',
	'pr_what_problem_incorrect_content_short' => 'innehåll',
	'pr_what_problem_software_bug_short' => 'bug',
	'pr_what_problem_other_short' => 'annat',
	'pr_what_problem_change' => 'Ändra problemtyp',
	'pr_describe_problem' => 'Meddelande',
	'pr_empty_summary' => 'Ge en kort problembeskrivning',
	'pr_empty_email' => 'Ange din e-postadress',
	'pr_mailer_subject' => 'Rapportera problem angående',
	'pr_mailer_to_default' => 'Wikia-användare',
	'pr_total_number' => 'Totalt antal rapporter',
	'pr_view_all' => 'Visa alla rapporter',
	'pr_reports_from' => 'Rapporter endast från: $1',
	'pr_no_reports' => 'Inga rapporter stämmer in på angivna kriterier',
	'pr_table_problem_id' => 'Problem-ID',
	'pr_table_wiki_name' => 'Wiki-namn',
	'pr_table_problem_type' => 'Problem typ',
	'pr_table_page_link' => 'Sida',
	'pr_table_date_submitted' => 'Rapportdatum',
	'pr_table_reporter_name' => 'Rapportör',
	'pr_table_description' => 'Beskrivning',
	'pr_table_comments' => 'Kommentarer',
	'pr_table_status' => 'Status',
	'pr_status_0' => 'öppen',
	'pr_status_1' => 'fixat',
	'pr_status_2' => 'stängt',
	'pr_status_3' => 'behöver hjälp från anställd',
	'pr_status_10' => 'ta bort rapport',
	'pr_status_wait' => 'vänta...',
	'pr_msg_exchead' => 'Meddelandet är för långt',
);

/** Tamil (தமிழ்)
 * @author TRYPPN
 */
$messages['ta'] = array(
	'pr_what_problem_unselect' => 'அனைத்தும்',
	'pr_what_problem_spam_short' => 'வீண்செய்தி',
	'pr_what_problem_incorrect_content_short' => 'உள்ளடக்கம்',
	'pr_what_problem_other_short' => 'மற்றவை',
	'pr_describe_problem' => 'செய்தி',
	'pr_table_description' => 'விளக்கம்',
	'pr_table_comments' => 'கருத்துரைகள்',
	'pr_table_status' => 'நிலைமை',
	'pr_table_actions' => 'செயல்கள்',
	'pr_status_0' => 'நிலுவையிலுள்ளது',
	'pr_status_1' => 'நிலையானது',
	'pr_status_2' => 'மூடப்பட்டது',
	'pr_status_wait' => 'காத்திருக்கவும்...',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'problemreports' => 'Talaan ng mga ulat ng suliranin',
	'reportproblem' => 'Mag-ulat ng suliranin',
	'prlogtext' => 'Mga ulat ng suliranin',
	'prlogheader' => 'Talaan ng naiulat na mga suliranin at mga pagbabago sa kanilang katayuan',
	'prlog_reportedentry' => 'nag-ulat ng isang suliranin noong $1 ($2)',
	'prlog_changedentry' => 'minarkahan ang suliraning $1 bilang "$2"',
	'prlog_typeentry' => 'binago ang uri ng suliranin na $1 na naging "$2"',
	'prlog_removedentry' => 'inalis ang suliraning $1',
	'prlog_emailedentry' => 'nagpadala ng mensaheng e-liham kay $2 ($3)',
	'pr_introductory_text' => 'Karamihan sa mga pahinang nasa wiking ito ang mababago, at malugod kang makapagbabago ng pahina at makapagtatama ka ng mga kamalian!  Kung kailangan mo ng tulong sa pagsasagawa niyan, tingnan ang [[help:editing|paano magbago]] at [[help:revert|paano magbalik sa dati ng pambababoy]].

Upang makapag-ugnayan sa tauhan o upang makapag-ulat ng mga suliraning pangkarapatang-ari, pakitingnan ang [[w:contact us|pahinang "makipag-ugnayan sa amin" ng Wikia]].

Maaaring iulat ang mga depekto ng sopwer sa mga poro.
Ang mga pag-uulat na ginawa rito ay [[Special:ProblemReports|ipapakita sa wiki]].',
	'pr_what_problem' => 'Paksa',
	'pr_what_problem_spam' => 'may isang kawing ng manlulusob dito',
	'pr_what_problem_vandalised' => 'nababoy ang pahinang ito',
	'pr_what_problem_incorrect_content' => 'hindi tama ang nilalamang ito',
	'pr_what_problem_software_bug' => 'may isang depekto sa loob ng sopwer ng wiki',
	'pr_what_problem_other' => 'iba pa',
	'pr_what_problem_select' => 'Pumili po ng uri ng suliranin',
	'pr_what_problem_unselect' => 'lahat',
	'pr_what_problem_spam_short' => 'manlulusob',
	'pr_what_problem_vandalised_short' => 'taong mapanira',
	'pr_what_problem_incorrect_content_short' => 'nilalaman',
	'pr_what_problem_software_bug_short' => 'surot',
	'pr_what_problem_other_short' => 'iba pa',
	'pr_what_problem_change' => 'Baguhin ang uri ng problema',
	'pr_describe_problem' => 'Mensahe',
	'pr_what_page' => 'Pamagat ng pahina',
	'pr_email_visible_only_to_staff' => 'makikita lamang ng tauhan',
	'pr_thank_you' => 'Salamat sa pag-uulat mo ng isang suliranin!

[[Special:ProblemReports/$1|Maaari mong panoorin ang pagsulong ng pag-aayos nito]].',
	'pr_thank_you_error' => 'Naganap ang isang kamalian habang ipinapadala ang ulat ng suliranin, sumubok ulit mamaya...',
	'pr_spam_found' => 'May natagpuang manlulusob sa loob ng buod ng iyong ulat.
Pakibago ang nilalaman ng buod',
	'pr_empty_summary' => 'Mangyaring magbigay ng maikling paglalarawan ng suliranin',
	'pr_empty_email' => 'Pakibigay ang tirahan mo ng e-liham',
	'pr_mailer_notice' => 'Ang ipinasok mong tirahan ng e-liham sa iyong mga nais ng tagagamit ay lilitaw bilang ang tirahang "Mula kay" ng liham, upang makapagbigay ng tugon ang tatanggap.',
	'pr_mailer_subject' => 'Nag-ulat ng suliranin sa',
	'pr_mailer_tmp_info' => 'Maaari mong [[MediaWiki:ProblemReportsResponses|baguhin ang mga katugunang may suleras]]',
	'pr_mailer_to_default' => 'Tagagamit ng Wikia',
	'pr_mailer_go_to_wiki' => 'Upang makapagpadala ng e-liham mangyaring pumunta sa [$1 wiking pinagsumbungan ng suliranin]',
	'pr_total_number' => 'Kabuuang bilang ng mga ulat',
	'pr_view_archive' => 'Tingnan ang mga suliraning nasinop',
	'pr_view_all' => 'Ipakita ang lahat ng mga ulat',
	'pr_view_staff' => 'Ipakita ang mga ulat na nangangailangan ng tulong ng tauhan',
	'pr_raports_from_this_wikia' => 'Tingnan ang mga ulat na nagmula lamang sa Wikiang ito',
	'pr_reports_from' => 'Nag-uulat lamang magmula sa: $1',
	'pr_no_reports' => 'Walang mga ulat na tumutugma sa iyong pamantayan',
	'pr_sysops_notice' => 'Maaari mong <a href="$1">baguhin ang katayuan ng mga ulat ng problema</a> mula sa iyong wiki...',
	'pr_table_problem_id' => 'ID ng suliranin',
	'pr_table_wiki_name' => 'Pangalan ng wiki',
	'pr_table_problem_type' => 'Uri ng suliranin',
	'pr_table_page_link' => 'Pahina',
	'pr_table_date_submitted' => 'Petsa ng pagpasa',
	'pr_table_reporter_name' => 'Pangalan ng tagapag-ulat',
	'pr_table_description' => 'Paglalarawan',
	'pr_table_comments' => 'Mga puna',
	'pr_table_status' => 'Katayuan',
	'pr_table_actions' => 'Mga galaw',
	'pr_status_0' => 'nakabinbin',
	'pr_status_1' => 'naayos na',
	'pr_status_2' => 'nakasara na',
	'pr_status_3' => 'kailangan ang tulong ng tauhan',
	'pr_status_10' => 'tanggalin ang ulat',
	'pr_status_undo' => 'Bawiin ang pagbabago sa ulat ng kalagayan',
	'pr_status_ask' => 'Baguhin ang kalagayan ng ulat?',
	'pr_remove_ask' => 'Panatilihing tanggal na ang ulat?',
	'pr_status_wait' => 'maghintay...',
	'pr_read_only' => 'Hindi mapupuno ang bagong mga ulat sa ngayon, sumubok uli mamaya.',
	'pr_msg_exceeded' => 'Ang pinakamataas na bilang ng mga panitik sa loob ng lugar ng mensahe ay 512.
Mangyaring pakisulat uli ang mensahe mo.',
	'pr_msg_exchead' => 'Napakahaba ng mensahe',
	'right-problemreports_action' => 'Baguhin ang katayuan at uri ng Mga Ulat ng Suliranin',
	'right-problemreports_global' => 'Baguhin ang katayuan at uri ng Mga Ulat ng Suliranin sa kahabaan ng mga wiki',
);

/** Tatar (Cyrillic) (Татарча/Tatarça (Cyrillic))
 * @author Ильнар
 */
$messages['tt-cyrl'] = array(
	'pr_what_problem_other_short' => 'башка',
	'pr_table_page_link' => 'Бит',
);

/** Ukrainian (Українська)
 * @author NickK
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'problemreports' => 'Список повідомлень про проблеми',
	'reportproblem' => 'Повідомити про проблему',
	'prlogtext' => 'Повідомлення про проблеми',
	'prlog_reportedentry' => 'повідомив про проблему сторінки $1 ($2)',
	'prlog_changedentry' => 'позначив проблему $1 як "$2"',
	'prlog_typeentry' => 'змінив тип проблеми $1 на "$2"',
	'prlog_removedentry' => 'вилучив проблему $1',
	'pr_what_problem' => 'Тема',
	'pr_what_problem_software_bug' => 'помилка у програмному забезпеченні вікі',
	'pr_what_problem_other' => 'інше',
	'pr_what_problem_select' => 'Будь ласка, виберіть тип проблеми',
	'pr_what_problem_spam_short' => 'спам',
	'pr_what_problem_vandalised_short' => 'вандал',
	'pr_what_problem_incorrect_content_short' => 'вміст',
	'pr_what_problem_software_bug_short' => 'помилка',
	'pr_what_problem_other_short' => 'інше',
	'pr_what_problem_change' => 'Змінити тип проблеми',
	'pr_describe_problem' => 'Повідомлення',
	'pr_what_page' => 'Назва сторінки',
	'pr_empty_summary' => 'Будь ласка, надайте короткий опис проблеми',
	'pr_empty_email' => 'Будь ласка, вкажіть вашу адресу електронної пошти',
	'pr_table_problem_id' => 'ID (ідентифікатор) проблеми',
	'pr_table_wiki_name' => 'Назва вікі',
	'pr_table_problem_type' => 'Тип проблеми',
	'pr_table_page_link' => 'Сторінка',
	'pr_table_description' => 'Опис',
	'pr_table_comments' => 'Коментарі',
	'pr_table_status' => 'Статус',
	'pr_table_actions' => 'Дії',
	'pr_status_0' => 'в очікуванні',
	'pr_status_10' => 'вилучити повідомлення',
	'pr_msg_exceeded' => 'Максимальна кількість символів у полі «Повідомлення» — 512. Будь ласка, перепишіть своє повідомлення.',
	'pr_msg_exchead' => 'Повідомлення занадто довге',
);

/** Chinese (中文) */
$messages['zh'] = array(
	'reportproblem' => '問題回報',
	'pr_what_problem_change' => '更改問題類型',
	'pr_mailer_notice' => '您在個人資料中所留下的電子郵件，將會自動顯示在「發信人」的欄位中，所以收件人能直接回覆您的信件。',
	'pr_total_number' => '回報總數',
	'pr_view_all' => '顯示所有回報',
	'pr_table_problem_id' => '問題編號',
	'pr_table_problem_type' => '問題類型',
	'pr_table_reporter_name' => '回報人',
	'pr_table_status' => '狀態',
);

/** Chinese (China) (‪中文(中国大陆)‬) */
$messages['zh-cn'] = array(
	'problemreports' => '问题回报列表',
	'reportproblem' => '问题回报',
	'pr_what_problem_change' => '更改问题类型',
	'pr_mailer_notice' => '您在个人资料中所留下的电子邮件，将会自动显示在「发信人」的栏位中，所以收件人能直接回覆您的信件。',
	'pr_total_number' => '回报总数',
	'pr_view_all' => '显示所有回报',
	'pr_table_problem_id' => '问题编号',
	'pr_table_problem_type' => '问题类型',
	'pr_table_reporter_name' => '回报人',
	'pr_table_status' => '状态',
);

/** Simplified Chinese (‪中文(简体)‬) */
$messages['zh-hans'] = array(
	'problemreports' => '问题回报列表',
	'pr_what_problem_change' => '更改问题类型',
	'pr_mailer_notice' => '您在个人资料中所留下的电子邮件，将会自动显示在「发信人」的栏位中，所以收件人能直接回覆您的信件。',
	'pr_total_number' => '回报总数',
	'pr_view_all' => '显示所有回报',
	'pr_table_problem_id' => '问题编号',
	'pr_table_reporter_name' => '回报人',
	'pr_table_status' => '状态',
);

/** Traditional Chinese (‪中文(繁體)‬) */
$messages['zh-hant'] = array(
	'problemreports' => '問題回報列表',
	'reportproblem' => '問題回報',
	'pr_what_problem_change' => '更改問題類型',
	'pr_mailer_notice' => '您在個人資料中所留下的電子郵件，將會自動顯示在「發信人」的欄位中，所以收件人能直接回覆您的信件。',
	'pr_total_number' => '回報總數',
	'pr_view_all' => '顯示所有回報',
	'pr_table_problem_id' => '問題編號',
	'pr_table_problem_type' => '问题类型',
	'pr_table_reporter_name' => '回報人',
	'pr_table_status' => '狀態',
);

/** Chinese (Hong Kong) (‪中文(香港)‬) */
$messages['zh-hk'] = array(
	'problemreports' => '問題回報列表',
	'reportproblem' => '問題回報',
	'pr_what_problem_change' => '更改問題類型',
	'pr_mailer_notice' => '您在個人資料中所留下的電子郵件，將會自動顯示在「發信人」的欄位中，所以收件人能直接回覆您的信件。',
	'pr_total_number' => '回報總數',
	'pr_view_all' => '顯示所有回報',
	'pr_table_problem_id' => '問題編號',
	'pr_table_problem_type' => '問題類型',
	'pr_table_reporter_name' => '回報人',
	'pr_table_status' => '狀態',
);

/** Chinese (Singapore) (‪中文(新加坡)‬) */
$messages['zh-sg'] = array(
	'reportproblem' => '问题回报',
	'pr_what_problem_change' => '更改问题类型',
	'pr_mailer_notice' => '您在个人资料中所留下的电子邮件，将会自动显示在「发信人」的栏位中，所以收件人能直接回覆您的信件。',
	'pr_total_number' => '回报总数',
	'pr_view_all' => '显示所有回报',
	'pr_table_problem_id' => '问题编号',
	'pr_table_problem_type' => '问题类型',
	'pr_table_reporter_name' => '回报人',
	'pr_table_status' => '状态',
);

/** Chinese (Taiwan) (‪中文(台灣)‬) */
$messages['zh-tw'] = array(
	'problemreports' => '問題回報列表',
	'reportproblem' => '問題回報',
	'pr_what_problem_change' => '更改問題類型',
	'pr_thank_you' => '感謝您的回報！',
	'pr_mailer_notice' => '您在個人資料中所留下的電子郵件，將會自動顯示在「發信人」的欄位中，所以收件人能直接回覆您的信件。',
	'pr_total_number' => '回報總數',
	'pr_view_all' => '顯示所有回報',
	'pr_raports_from_this_wikia' => '僅檢視此Wikia的回報',
	'pr_table_problem_id' => '問題編號',
	'pr_table_problem_type' => '問題類型',
	'pr_table_reporter_name' => '回報人',
	'pr_table_comments' => '發表意見',
	'pr_table_status' => '狀態',
	'pr_status_10' => '移除回報',
	'pr_status_ask' => '更改提報問題的狀態？',
);

