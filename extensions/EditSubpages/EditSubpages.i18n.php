<?php
/**
 * Internationalisation file for the EditSubpages extension
 * @addtogroup Extensions
*/

$messages = array();

/** English
 @author Ryan Schmidt
 */
$messages['en'] = array(
	'editsubpages-desc' => "Allows sysops to unlock a page and all subpages of that page for anonymous editing via [[MediaWiki:Unlockedpages]]",
	'unlockedpages'     => ' #<!-- leave this line alone --><pre>
# Put pages you want to unlock below using
# * Pagename
# Unlocked pages must begin with a bullet to be counted,
# everything else is considered a comment
# Pagenames may be [[links]] and are case-sensitive
# Also, talk pages will be automatically unlocked with the page
# See http://www.mediawiki.org/wiki/Extension:EditSubpages for more info
 #</pre><!-- leave this line alone -->',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'editsubpages-desc' => 'يسمح لمديري النظام بإزالة غلق صفحة وكل الصفحات الفرعية لهذه الصفحة للتعديل المجهول من خلال [[MediaWiki:Unlockedpages]]',
	'unlockedpages'     => '  #<!-- leave this line alone --><pre>
# ضع الصفحات التي تريد رفع غلقها بالأسفل
# * اسم الصفحة
# الصفحات المرفوع غلقها يجب أن تبدأ برصاصة ليتم احتسابها،
# كل شيء آخر يتم اعتباره تعليق
# اسم الصفحة ربما يكون [[وصلات]] وهو حساس لحالة الحروف
# أيضا، صفحات النقاش سيتم رفع غلقها تلقائيا مع الصفحة
# انظر http://www.mediawiki.org/wiki/Extension:EditSubpages لمزيد من المعلومات
  #</pre><!-- leave this line alone -->',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'editsubpages-desc' => 'Позволява на администраторите чрез [[MediaWiki:Unlockedpages]] да свалят защитата на страница и всички нейни подстраници за анонимно редактиране',
);

/** German (Deutsch)
 * @author Flominator
 */
$messages['de'] = array(
	'editsubpages-desc' => 'Gibt den Administratoren die Möglichkeit, eine Seite und deren Unterseiten für das unangemeldete Bearbeiten über [[MediaWiki:Unlockedpages]] freizuschalten',
	'unlockedpages'     => ' #<!-- Diese Zeile nicht verändern --><pre>
# Freigegebene Seiten mittels
# * Seitenname
# auflisten
# Zu entsperrende Seiten müssen mit einem * gelistet werden.
# Alle anderen Einträge werden als Kommentar gewertet.
# Diskussionsseiten werden ebenfalls entsperrt.
# Mehr Informationen: http://www.mediawiki.org/wiki/Extension:EditSubpages 
 #</pre><!-- Diese Zeile nicht verändern -->',
);

/** Finnish (Suomi)
 * @author Jack Phoenix
 * @author Nike
 * @author Crt
 */
$messages['fi'] = array(
	'editsubpages-desc' => 'Ylläpitäjät voivat sallia sivun ja sen kaikkien alasivujen muokkaamisen kirjautumattomille käyttäjille sivulla [[MediaWiki:Unlockedpages]].',
	'unlockedpages'     => '  #<!-- älä koske tähän riviin --><pre>
# Lisää sivut, jotka haluat sallia kirjautumattomien käyttäjien muokkauksille alapuolelle käyttäen muotoa:
# * sivun nimi
# Avattavien sivujen nimien tulee alkaa *:llä jotta ne laskettaisiin.
# Kaikki muu lasketaan kommenteiksi.
# Sivujen nimet voivat olla [[linkkejä]] ja ovat kirjainkoosta riippuvaisia.
# Myös keskustelusivut avataan sivun kanssa.
# Lisätietoja on sivulla http://www.mediawiki.org/wiki/Extension:EditSubpages
  #</pre><!-- älä koske tähän riviin -->',
);

/** French (Français)
 * @author Grondin
 */
$messages['fr'] = array(
	'editsubpages-desc' => 'Permet aux administrateurs de déverrouiller une page et tous ses sous-pages pour les modifications anonymes grâce à [[MediaWiki:Unlockedpages]]',
	'unlockedpages'     => '  #<!-- Laisser cette ligne telle quelle --><pre>
# Indiquer, ci-dessous, les pages que vous désirez déverrouiller en utilisant
# * nomdelapage
# Les pages déverrouillées doivent commencer par une liste à puce pour être prises en considération,
# Toute autre caractère sera considéré comme un commentaire.
# Les noms de pages peuvent être des [[liens]] et sont sensibles à la casse
# Aussi, les pages de discussion seront déverrouillées automatiquement avec sa page principale.
# Voir http://www.mediawiki.org/wiki/Extension:EditSubpages pour plus d’informations
  #</pre><!-- Laisser cette ligne telle quelle -->',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'editsubpages-desc' => 'Permite aos administradores desprotexer unha páxina e todas as subpáxinas que esta contén para que os usuarios anónimos editen via [[MediaWiki:Unlockedpages]]',
	'unlockedpages'     => '  #<!-- deixe esta liña como está --><pre>
# Poña as páxinas que desexe desprotexer embaixo usando
# * nomedapáxina
# As páxinas desprotexidas deben comezar cun # para que sexan contabilizadas,
# o resto consideranrase comentarios
# Nomesdapáxina serán [[ligazóns]] e son sensibles á causa
# Tamén, as páxinas de conversa serán desprotexidas automaticamente coa páxina
# Véxase http://www.mediawiki.org/wiki/Extension:EditSubpages para máis información
  #</pre><!-- deixe esta liña como está -->',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'editsubpages-desc' => 'Permette agli amministratori di sbloccare una pagine e tutte le relative sottopagine per permettere le modifiche agli utenti anonimi attraverso [[MediaWiki:Unlockedpages]]',
	'unlockedpages'     => "  #<!-- lascia questa linea così com'è --><pre>
# Inserisci le pagine che vuoi sbloccare di seguito scrivendo
# * Nome pagina
# Le pagine da sbloccare devono essere precedute dal segno * per essere contate,
# tutto il resto è considerato un commento
# I nomi delle pagine possono essere [[collegamenti]] e sono case-sensitive
# Inoltre, le pagine di discussione verranno automaticamente sbloccate insieme alla pagina
# Visita http://www.mediawiki.org/wiki/Extension:EditSubpages per maggiori informazioni
  #</pre><!-- lascia questa linea così com'è -->",
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'editsubpages-desc' => "Erlaabt engem Adiministrateur fir d'Spär vu Säiten opzehiewen an all Ënnersäite vun däer Säit fir anonym Ännerungen via [[MediaWiki:Unlockedpages|Säiten denen hir Spär opgehuewen ass]]",
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'editsubpages-desc' => 'സിസോപ്പിനു അജ്ഞാതരുടെ തിരുത്തലിനു വേണ്ടി ഒരു താളും അതിന്റെ ഉപതാളുകളും സ്വതന്ത്രക്കുവാന്‍ സാധിക്കുന്നു. [[MediaWiki:Unlockedpages]]',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'editsubpages-desc' => '[[MediaWiki:Unlockedpages]] इथे प्रबंधकांना अनामिकरित्या संपादित करण्यासाठी पाने व त्यांची उपपाने असुरक्षित करण्याची परवानगी देते.',
	'unlockedpages'     => '#<!-- leave this line alone --><pre>
# तुम्ही असुरक्षित करू इच्छित असलेली पाने खालीलप्रमाणे लिहा
# * लेखनाव
# असुरक्षित करण्यासाठी पानाचे नाव * ने सुरु होणे आवश्यक आहे,
# बाकी सर्व हे शेरा किंवा सूचना समजले जाईल
# लेखनाव [[दुव्यांच्या]] स्वरुपात दिलेली चालतील
# तसेच, लेखाबरोबर चर्चा पाने सुद्धा असुरक्षित होतील
# अधिक माहितीसाठी http://www.mediawiki.org/wiki/Extension:EditSubpages पहा
  #</pre><!-- leave this line alone -->',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'editsubpages-desc' => "Geeft beheerders de mogelijkheid een pagina en alle subpagina's van die pagina te deblokkeren voor anoniem bewekren via [[MediaWiki:Unlockedpages]]",
	'unlockedpages'     => "  #<!-- deze regel niet wijzigen --><pre>
# Zet pagina's die u wilt vrijgeven hieronder als volgt:
# * pagename
# Vrijgegeven pagina's moeten als ongenummerde lijst worden toegevoegd,
# anders worden ze genegeerd. Alle overige tekst wordt behandeld als
# Opmerkingen. Paginanamen kunnen [[links]] zijn, en zijn hoofdlettergevoelig.
# Overlegpagina's worden automatisch vrijgegeven voor hun bijbehorende
# pagina's. Zie http://www.mediawiki.org/wiki/Extension:EditSubpages voor
# meer informatie.
  #</pre><!-- deze regel niet wijzigen -->",
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'editsubpages-desc' => 'Lar administratorer låse opp en side og alle dens undersider for endringer av uregistrerte via [[MediaWiki:Unlockedpages]]',
	'unlockedpages'     => '  #<!-- la denne linja være som den er --><pre>
# Skriv inn sider du vil låse opp nedenfor på formen
# * sidenavn
# Navnene må begynne med stjerne,
# alt annet regnes som kommentar
# Sidenavn kan være [[lenker]], og
# man må skille mellom store og små bokstaver.
# Diskusjonssider blir automatisk låst opp sammen med hovedsiden
# Se http://www.mediawiki.org/wiki/Extension:EditSubpages for mer informasjon
  #</pre><!-- la denne linja være som den er -->',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'editsubpages-desc' => 'Permet als administrators de desvarrolhar una pagina e totas sas sospaginas per las modificacions anonimas gràcia a [[MediaWiki:Unlockedpages]]',
	'unlockedpages'     => '  #<!-- Daissatz aquesta linha tala coma es --><pre>
# Indicatz, çaijós, las paginas que desiratz desvarrolhar en utilizant
# * nomdelapagina
# Las paginas desvarrolhadas devon començar per una lista amb de piuses per èsser presas en consideracion,
# Tot autre caractèr serà considerat coma un comentari.
# Los noms de paginas pòdon èsser de [[ligams]] e son sensibles a la cassa
# Tanben, las paginas de discussion seràn desvarrolhadas automaticament amb sa pagina principala.
# Vejatz http://www.mediawiki.org/wiki/Extension:EditSubpages per mai d’entresenhas
  #</pre><!-- Daissatz aquesta linha tala coma es -->',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'editsubpages-desc' => 'Umożliwia administratorom odblokowanie edycji strony i jej wszystkich podstron dla niezalogowanych użytkowników poprzez [[MediaWiki:Unlockedpages]]',
	'unlockedpages'     => '  #<!-- nie zmieniaj treści tej linii --><pre>
# Umieść poniżej nazwy stron, które chcesz odblokować wpisując
# * NazwaStrony
# Każda nazwa odblokowywanej strony musi być poprzedzona gwiazdką.
# Wszystko inne zostanie uznane za komentarz.
# NazwaStrony może być [[odnośnikiem]] i jest czuła na wielkość znaków.
# Strony dyskusji zostaną automatycznie odblokowane.
# Zobacz http://www.mediawiki.org/wiki/Extension:EditSubpages jeśli chcesz uzyskać więcej informacji.
  #</pre><!-- nie zmieniaj treści tej linii -->',
);

/** Portuguese (Português)
 * @author Malafaya
 */
$messages['pt'] = array(
	'editsubpages-desc' => 'Permite a administradores desbloquearem uma página e todas as suas subpáginas para edição anónima através de [[MediaWiki:Unlockedpages]]',
	'unlockedpages'     => "  #<!-- deixe esta linha como está --><pre>
# Coloque páginas que pretende desbloquear abaixo, usando
# * nome da página
# Páginas desbloqueadas devem começar com uma 'bala' (*) para serem consideradas,
# tudo o resto é considerado um comentário
# Os nomes de páginas podem ser [[ligações]] e são sensíveis à capitalização
# As páginas de discussão serão também automaticamente desbloqueadas com a página
# Veja http://www.mediawiki.org/wiki/Extension:EditSubpages para mais informação
  #</pre><!-- deixe esta linha como está -->",
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'editsubpages-desc' => 'Позволяет администраторам с помощью [[MediaWiki:Unlockedpages]] открыть для анонимного редактирования страницу и её подстраницы',
	'unlockedpages'     => '  #<!-- не трогайте эту строчку --><pre>
# Разместите здесь названия страниц, которые вы хотите открыть
# * имя страницы
# Названия страниц должны быть в маркированном списке,
# всё остальное будет рассматриваться как комментарий.
# Имена страниц могут быть оформлены как [[ссылки]], имена чувствительны к регистру.
# Соответствующие страницы обсуждений будут также открыты.
# Подробнее см. http://www.mediawiki.org/wiki/Extension:EditSubpages
  #</pre><!-- не трогайте эту строчку -->',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'editsubpages-desc' => 'Umožniť správcom odomknúť stránku so všetkými podstránkami danej stránky pre anonymné úpravy prostredníctvom [[MediaWiki:Unlockedpages]]',
	'unlockedpages'     => '  #<!-- nechajte tento riadok ako je --><pre>
# Stránky, ktoré chcete odomknúť uveďte v zozname nižšie pomocou
# * názov stránky
# Stránky, ktoré sa majú odomknúť musia začínať odrážkou, aby sa počítali,
# všetko ostatné sa považuje za komentár
# Názvy stránok môžu byť [[odkazmi]] a na veľkosti písmen záleží.
# Budú odomknuté aj diskusné stránky uvedených stránok.
# Podrobnosti pozri na  http://www.mediawiki.org/wiki/Extension:EditSubpages
  #</pre><!-- nechajte tento riadok ako je -->',
);

/** Swedish (Svenska)
 * @author M.M.S.
 * @author Sannab
 * @author Micke
 */
$messages['sv'] = array(
	'editsubpages-desc' => 'Låter administratörer låsa upp en sida, och alla undersidor till den sidan, för redigering av oinloggade användare med hjälp av [[MediaWiki:Unlockedpages]]',
	'unlockedpages'     => '   #<!-- låt denna linje vara ifred --><pre>
# Skriv in sidor du vill låsa upp nedanför i formatet:
# * sidnamn
# Namnen ska börja med en stjärna,
# allt annat räknas som kommentar
# Sidnamn kan vara [[länkar]], och
# man ska skilja mellan stora och små bokstäver.
# Diskussionssidor blir automatiskt upplåsta tillsammans med huvudsidan
# Se http://www.mediawiki.org/wiki/Extension:EditSubpages för mer information
   #</pre><!-- låt denna linje vara ifred -->',
);

/** Ukrainian (Українська)
 * @author Ahonc
 */
$messages['uk'] = array(
	'editsubpages-desc' => 'Дозволяє адміністраторам за допомогою [[MediaWiki:Unlockedpages]] відкрити для анонімного редагування сторінку та її підсторінки',
	'unlockedpages'     => '#<!-- не чіпайте цей рядок --><pre>
# Розмістіть тут назви сторінок, які ви хочете відкрити для редагування
# * назва сторінки
# Назви сторінок повинні бути у маркованому списку,
# усе інше буде розглядатися як коментар.
# Назви сторінок можуть бути оформлені як [[посилання]], імена чутливі до регістру.
# Відповідні сторінки обговорень також будуть відкриті.
# Докладніше див. http://www.mediawiki.org/wiki/Extension:EditSubpages
   #</pre><!-- не чіпайте цей рядок -->',
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'editsubpages-desc' => 'Cho phép các quản lý mở khóa một trang và tất cả các trang con của nó để thành viên vô danh có thể sửa đổi thông qua [[MediaWiki:Unlockedpages]]',
	'unlockedpages'     => '  #<!-- đừng sửa vào dòng này --><pre>
# Đặt trang bạn muốn mở khóa vào dưới đây
# dùng tên trang là *
# Trang được mở khóa phải bắt đầu bằng dấu chấm mới được tính,
# mọi thứ khác được xem là chú thích
# Tên trang có thể là [[liên kết]] và là phân biệt chữ hoa chữ thường
# Ngoài ra, trang thảo luận sẽ được tự động mở khóa theo
# Xem http://www.mediawiki.org/wiki/Extension:EditSubpages để có thêm thông tin
  #</pre><!-- đừng sửa vào dòng này -->',
);

