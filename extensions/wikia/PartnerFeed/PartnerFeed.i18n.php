<?php
/**
 * Internationalisation file for PartnerFeed extension.
 *
 * @addtogroup Extensions
*/

$messages = array();

/**
 * Prepare extension messages
 *
 * @return array
 */
$messages['en'] = array(
	'partner-feed-desc'                 => 'Partner Feed extension',
	'partner-feed-achievements-leaderboard' => 'Wikis achievements leaderboard',
	'partner-feed-earned-badges'		=> 'Recently earned badges for a specific Wiki',
	'partner-feed-recent-blog-posts'	=> 'Recent blog posts related to a promotion',
	'partner-feed-latest-images'		=> 'Gallery of the latest images that have been uploaded',
	'partner-feed-hotcontent'		=> 'Hub / verticals "Hot Content" as ranked by number of editors',
	'partner-feed-recent-blog-comments'	=> 'Recent comments related to specified blog post.',
	'partner-feed-recent-changes'		=> 'Recent changes',
	'partnerfeed'				=> 'Partner feed',
	'error-no-article'			=> 'Error: No "article" param passed',
	'feed-title-blogposts'			=> 'Recent blog posts',
	'feed-title-recent-badges'		=> 'Recent badges',
	'feed-title-recent-images'		=> 'Recent images',
	'feed-title-leaderboard'		=> 'Achievements leaderboard',
	'feed-main-title'			=> 'Fandom partner feed',
	'all-blog-posts'			=> 'all categories',
	'blog-posts-from-listing'		=> 'from listing: $1',
	'feed-title-hot-content'		=> 'Hot content - $1',
	'feed-title-blogcomments'		=> 'Comments to $1',
	'feed-title-recentchanges'		=> 'Recent changes',
	'partner-feed-error-no-blogpost-found' => '<b>Error:</b> Blog post $1 does not exist.'
);

/** Message documentation (Message documentation)
 * @author Purodha
 * @author Shirayuki
 */
$messages['qqq'] = array(
	'partner-feed-desc' => '{{desc}}',
	'partner-feed-hotcontent' => 'Both terms "Hub" and "verticals" have the same meaning in this context. The meaning is "Portals", i.e. the grouping of wikis by their theme. Examples of portals are "Gaming", "Entertainment", "Education", "Music", etc.',
	'partner-feed-recent-changes' => '{{Identical|Recent changes}}',
	'blog-posts-from-listing' => 'Parameters:
* $1 is a link to a listing with the listing page title as link description.',
	'feed-title-hot-content' => 'Parameters:
* $1 is a hub title.',
	'feed-title-blogcomments' => 'Parameters:
* $1 is a blog post title.',
	'feed-title-recentchanges' => '{{Identical|Recent changes}}',
	'partner-feed-error-no-blogpost-found' => 'Displayed when the provided blog post does not exist.
Parameters:
* $1 is a blog post title.',
);

/** Arabic (العربية)
 * @author Achraf94
 * @author Claw eg
 */
$messages['ar'] = array(
	'partner-feed-achievements-leaderboard' => 'قائمة متصدري الإنجازات الخاصة بالويكيات',
	'partner-feed-earned-badges' => 'الإنجازات المتحصل عليها حديثا في ويكي محددة',
	'partner-feed-recent-blog-posts' => 'مشاركات المدونات المؤخرة مرتبطة بترويج',
	'partner-feed-latest-images' => 'معرض لأحدث الصور التي تم رفعها',
	'partner-feed-hotcontent' => 'محور / قطاعات "المحتوى الساخن" كما هي مرتبة حسب عدد المحررين',
	'partner-feed-recent-blog-comments' => 'تعليقات حديثة متعلقة بمشاركة مدونة محددة',
	'partner-feed-recent-changes' => 'أحدث التغييرات',
	'partnerfeed' => 'قائمة الشركاء',
	'error-no-article' => 'خطأ: لا "مقالة" معلمة نجحت',
	'feed-title-blogposts' => 'أحدث معلقات المدونة',
	'feed-title-recent-badges' => 'أحدث الشارات',
	'feed-title-recent-images' => 'أحدث الصور',
	'feed-title-leaderboard' => 'قائمة متصدري الإنجازات',
	'feed-main-title' => 'قائمة شركاء ويكيا',
	'all-blog-posts' => 'جميع التصنيفات',
	'blog-posts-from-listing' => 'من قائمة: $1',
	'feed-title-hot-content' => 'محتوى المحور - $1',
	'feed-title-blogcomments' => 'التعليقات على $1',
	'feed-title-recentchanges' => 'أحدث التغييرات',
	'partner-feed-error-no-blogpost-found' => '<b>خطأ:</b> مشاركة المدونة $1 غير موجودة.',
);

/** Bulgarian (български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'partner-feed-recent-changes' => 'Последни промени',
	'all-blog-posts' => 'всички категории',
	'feed-title-recentchanges' => 'Последни промени',
);

/** Breton (brezhoneg)
 * @author Fohanno
 * @author Y-M D
 */
$messages['br'] = array(
	'partner-feed-earned-badges' => 'Badjoù gounezet nevez zo gant ur Wiki difer',
	'partner-feed-recent-changes' => 'Kemmoù diwezhañ',
	'partnerfeed' => 'Keveler gwazh',
	'error-no-article' => 'Fazi : N\'eo ket bet kaset an arventenn "pennad"',
	'feed-title-blogposts' => 'Blogadennoù nevez',
	'feed-title-recent-badges' => 'Badjoù diwezhañ',
	'feed-title-recent-images' => 'Skeudennoù diwezhañ',
	'feed-main-title' => 'Gwazh keveler Wikia',
	'all-blog-posts' => 'an holl rummadoù',
	'blog-posts-from-listing' => 'eus ar roll : $1',
	'feed-title-blogcomments' => 'Evezhiadenn da $1',
	'feed-title-recentchanges' => 'Kemmoù diwezhañ',
);

/** Catalan (català)
 * @author Alvaro Vidal-Abarca
 * @author Roxas Nobody 15
 * @author Unapersona
 */
$messages['ca'] = array(
	'partner-feed-desc' => 'Extensió de Partner Feed',
	'partner-feed-achievements-leaderboard' => 'Taula de líders amb més exits',
	'partner-feed-earned-badges' => 'Recentment va guanyar insígnies per a un determinat Wiki',
	'partner-feed-recent-blog-posts' => 'Darreres entrades del bloc relacionades amb la promoció',
	'partner-feed-latest-images' => "Galeria de les últimes imatges que s'han pujat",
	'partner-feed-hotcontent' => 'Hub / verticals "Hot Contingut com ordenades per nombre de redactors',
	'partner-feed-recent-blog-comments' => "Comentaris recents relacionats amb un bloc l'especificat .",
	'partner-feed-recent-changes' => 'Canvis Recents',
	'partnerfeed' => 'Partner feed',
	'error-no-article' => 'Error: No hi ha "article" parametre passat',
	'feed-title-blogposts' => 'Entrades de blog recents',
	'feed-title-recent-badges' => 'Insígnies Recents',
	'feed-title-recent-images' => 'Imatges recents',
	'feed-title-leaderboard' => 'Taula de Exits',
	'feed-main-title' => 'Fandom partner feed',
	'all-blog-posts' => 'totes les categories',
	'blog-posts-from-listing' => 'des de la llista:$1',
	'feed-title-hot-content' => 'Contenido Novedós - $1',
	'feed-title-blogcomments' => 'Comentaris - $1',
	'feed-title-recentchanges' => 'Canvis Recents',
	'partner-feed-error-no-blogpost-found' => "<b>Error:</b> L'entrada de bloc $1 no existeix.",
);

/** Chechen (нохчийн)
 * @author Умар
 */
$messages['ce'] = array(
	'partner-feed-recent-changes' => 'Керла нисдарш',
	'feed-title-recentchanges' => 'Керла нисдарш',
);

/** Czech (čeština)
 * @author Chmee2
 */
$messages['cs'] = array(
	'partner-feed-recent-changes' => 'Poslední změny',
	'feed-title-recent-images' => 'Poslední obrázky',
	'all-blog-posts' => 'všechny kategorie',
	'feed-title-recentchanges' => 'Poslední změny',
);

/** German (Deutsch)
 * @author Diebuche
 * @author George Animal
 * @author LWChris
 * @author Metalhead64
 * @author ✓
 */
$messages['de'] = array(
	'partner-feed-desc' => 'Partner-Feed-Erweiterung',
	'partner-feed-achievements-leaderboard' => 'Wiki Rangliste',
	'partner-feed-earned-badges' => 'Kürzlich verdiente Abzeichen für ein bestimmtes Wiki',
	'partner-feed-recent-blog-posts' => 'Letzte Blog-Beiträge in Verbindung mit einer Förderung',
	'partner-feed-latest-images' => 'Galerie der neuesten Bilder, die hochgeladen wurden',
	'partner-feed-hotcontent' => 'Hub / vertikaler "Hot Content" geordnet nach Anzahl der Bearbeiter',
	'partner-feed-recent-blog-comments' => 'Neueste Kommentare zu einem bestimmten Blog-Post.',
	'partner-feed-recent-changes' => 'Letzte Änderungen',
	'partnerfeed' => 'Partner-Feed',
	'error-no-article' => 'Fehler: Kein "article"-Parameter übergeben',
	'feed-title-blogposts' => 'Neueste Blogeinträge',
	'feed-title-recent-badges' => 'Kürzlich vergebene Abzeichen',
	'feed-title-recent-images' => 'Neueste Bilder',
	'feed-title-leaderboard' => 'Rangliste',
	'feed-main-title' => 'Wikia Partner-Feed',
	'all-blog-posts' => 'alle Kategorien',
	'blog-posts-from-listing' => 'von der Liste: $1',
	'feed-title-hot-content' => 'Hot Content - $1',
	'feed-title-blogcomments' => 'Kommentare zu $1',
	'feed-title-recentchanges' => 'Letzte Änderungen',
	'partner-feed-error-no-blogpost-found' => '<b>Fehler:</b> Der Blogbeitrag $1 ist nicht vorhanden.',
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 * @author Marmase
 * @author Mirzali
 */
$messages['diq'] = array(
	'partner-feed-recent-changes' => 'Vurnayışê peyêni',
	'feed-title-recent-images' => 'Vurnayışê resiman',
	'all-blog-posts' => 'kategoriy pêro',
	'feed-title-blogcomments' => 'Vatışê - ($1)',
	'feed-title-recentchanges' => 'Vurnayışê peyêni',
);

/** Spanish (español)
 * @author VegaDark
 */
$messages['es'] = array(
	'partner-feed-desc' => 'Extensión de Partner Feed',
	'partner-feed-achievements-leaderboard' => 'Tabla de líderes con más logros',
	'partner-feed-earned-badges' => 'Logros recientemente ganados para un wiki específico',
	'partner-feed-recent-blog-posts' => 'Entradas de blog recientes relacionadas con una promoción',
	'partner-feed-latest-images' => 'Galería de las últimas imágenes que han sido subidas',
	'partner-feed-hotcontent' => 'Hub / "Contenido Novedoso" clasificado por el número de editores',
	'partner-feed-recent-blog-comments' => 'Comentarios recientes relacionados a una entrada de blog especificada.',
	'partner-feed-recent-changes' => 'Cambios recientes',
	'partnerfeed' => 'ModalidadesRSS',
	'error-no-article' => 'Error: No fue pasado el parámetro "artículo"',
	'feed-title-blogposts' => 'Entradas de blog recientes',
	'feed-title-recent-badges' => 'Logros recientes',
	'feed-title-recent-images' => 'Imágenes recientes',
	'feed-title-leaderboard' => 'Tablón de logros',
	'feed-main-title' => 'Fandom partner feed',
	'all-blog-posts' => 'todas las categorías',
	'blog-posts-from-listing' => 'de la lista: $1',
	'feed-title-hot-content' => 'Contenido Novedoso - $1',
	'feed-title-blogcomments' => 'Comentarios de $1',
	'feed-title-recentchanges' => 'Cambios recientes',
	'partner-feed-error-no-blogpost-found' => '<b>Error:</b> La entrada de blog $1 no existe.',
);

/** Basque (euskara)
 * @author Subi
 */
$messages['eu'] = array(
	'all-blog-posts' => 'kategoria guztiak',
);

/** Persian (فارسی)
 * @author BlueDevil
 * @author Reza1615
 */
$messages['fa'] = array(
	'partner-feed-recent-changes' => 'تغییرات اخیر',
	'feed-title-blogposts' => 'پست‌های اخیر وبلاگ',
	'feed-title-recent-badges' => 'نشانهای اخیر',
	'feed-title-recent-images' => 'تصاویر اخیر',
	'feed-title-leaderboard' => 'تابلوی رهبری دستاوردها',
	'feed-title-recentchanges' => 'تغییرات اخیر',
);

/** Finnish (suomi)
 * @author Centerlink
 * @author Elseweyr
 * @author Nedergard
 * @author Nike
 * @author Tofu II
 */
$messages['fi'] = array(
	'partner-feed-achievements-leaderboard' => 'Wikien saavutuksien tilastot',
	'partner-feed-earned-badges' => 'Äskettäin ansaitut merkit tietyssä wikissä',
	'partner-feed-recent-blog-posts' => 'Uusimmat promootioon liittyvät blogiartikkelit',
	'partner-feed-latest-images' => 'Viimeisimmäksi ladattujen kuvien galleria',
	'partner-feed-recent-blog-comments' => 'Tiettyyn blogiartikkeliin liittyvät viimeisimmät kommentit.',
	'partner-feed-recent-changes' => 'Viimeisimmät muutokset',
	'partnerfeed' => 'Kumppanisyöte',
	'error-no-article' => 'Virhe: Ei "artikkeli" -parametria annettu',
	'feed-title-blogposts' => 'Tuoreet blogimerkinnät',
	'feed-title-recent-badges' => 'Viimeaikaiset rintanapit',
	'feed-title-recent-images' => 'Viimeaikaiset kuvat',
	'feed-title-leaderboard' => 'Saavutuksien leaderboard',
	'feed-main-title' => 'Wikia kumppanisyöte',
	'all-blog-posts' => 'kaikki kategoriat',
	'blog-posts-from-listing' => 'listauksesta $1',
	'feed-title-hot-content' => 'Kuuma sisältö - $1',
	'feed-title-blogcomments' => 'Kommentit artikkelista $1',
	'feed-title-recentchanges' => 'Tuoreet muutokset',
	'partner-feed-error-no-blogpost-found' => '<b>Virhe:</b> Blogiartikkelia $1 ei ole olemassa.',
);

/** French (français)
 * @author Gomoko
 * @author Jean-Frédéric
 * @author Peter17
 * @author Verdy p
 * @author Wyz
 */
$messages['fr'] = array(
	'partner-feed-desc' => 'Extension de flux partenaire',
	'partner-feed-achievements-leaderboard' => 'Tableau des challenges des wikis',
	'partner-feed-earned-badges' => 'Badges récemment gagnés pour un wiki donné',
	'partner-feed-recent-blog-posts' => 'Billets de blog récemment postés pour une promotion',
	'partner-feed-latest-images' => 'Galerie des dernières images importées',
	'partner-feed-hotcontent' => 'Centre des contenus actifs classés par nombre d’éditeurs',
	'partner-feed-recent-blog-comments' => 'Commentaires récents liés au billet de blog spécifié.',
	'partner-feed-recent-changes' => 'Modifications récentes',
	'partnerfeed' => 'Partenaire de flux',
	'error-no-article' => 'Erreur : paramètre « article » non passé',
	'feed-title-blogposts' => 'Billets récents',
	'feed-title-recent-badges' => 'Badges récents',
	'feed-title-recent-images' => 'Images récentes',
	'feed-title-leaderboard' => 'Tableau de bord des réalisations',
	'feed-main-title' => 'Flux de partenaire Wikia',
	'all-blog-posts' => 'toutes les catégories',
	'blog-posts-from-listing' => 'depuis la liste : $1',
	'feed-title-hot-content' => 'Contenu à l’actualité — $1',
	'feed-title-blogcomments' => 'Commentaires à $1',
	'feed-title-recentchanges' => 'Modifications récentes',
	'partner-feed-error-no-blogpost-found' => '<b>Erreur :</b> le billet de blog $1 n’existe pas.',
);

/** Galician (galego)
 * @author Toliño
 * @author Xanocebreiro
 */
$messages['gl'] = array(
	'partner-feed-achievements-leaderboard' => 'Taboleiro de logros dos wikis',
	'partner-feed-earned-badges' => 'Insignias gañadas recentemente nun wiki específico',
	'partner-feed-recent-blog-posts' => 'Entradas de blogue recentes relacionadas cunha promoción',
	'partner-feed-latest-images' => 'Galería das últimas imaxes cargadas',
	'partner-feed-hotcontent' => 'Portal de contidos populares clasificados por número de editores',
	'partner-feed-recent-blog-comments' => 'Comentarios recentes relacionados cunha entrada de blogue especificada.',
	'partner-feed-recent-changes' => 'Cambios recentes',
	'partnerfeed' => 'Fonte de novas adicional',
	'error-no-article' => 'Erro: Parámetro "artigo" non pasado',
	'feed-title-blogposts' => 'Entradas de blogue recentes',
	'feed-title-recent-badges' => 'Insignias recentes',
	'feed-title-recent-images' => 'Imaxes recentes',
	'feed-title-leaderboard' => 'Taboleiro de logros',
	'feed-main-title' => 'Fonte de novas adicional de Wikia',
	'all-blog-posts' => 'todas as categorías',
	'blog-posts-from-listing' => 'desde a lista: $1',
	'feed-title-hot-content' => 'Contido popular - $1',
	'feed-title-blogcomments' => 'Comentario sobre $1',
	'feed-title-recentchanges' => 'Cambios recentes',
	'partner-feed-error-no-blogpost-found' => '<b>Erro:</b> A entrada de blogue "$1" non existe.',
);

/** Hungarian (magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'feed-title-blogposts' => 'Legújabb blogbejegyzések',
	'feed-title-recent-badges' => 'Legújabb jelvények',
	'feed-title-recent-images' => 'Legújabb képek',
	'all-blog-posts' => 'összes kategória',
	'feed-title-recentchanges' => 'Friss változtatások',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'partner-feed-achievements-leaderboard' => 'Classamento de successos pro wikis',
	'partner-feed-earned-badges' => 'Insignias recentemente ganiate pro un wiki specific',
	'partner-feed-recent-blog-posts' => 'Recente articulos de blog a proposito de un promotion',
	'partner-feed-latest-images' => 'Galeria de imagines recentemente incargate',
	'partner-feed-hotcontent' => '"Contento popular" del centro, classificate per numero de contributores',
	'partner-feed-recent-blog-comments' => 'Recente commentos a proposito de un articulo de blog specificate.',
	'partner-feed-recent-changes' => 'Modificationes recente',
	'partnerfeed' => 'Syndication de partner',
	'error-no-article' => 'Error: nulle parametro "article" passate',
	'feed-title-blogposts' => 'Recente articulos de blog',
	'feed-title-recent-badges' => 'Insignias recente',
	'feed-title-recent-images' => 'Imagines recente',
	'feed-title-leaderboard' => 'Classamento de successos',
	'feed-main-title' => 'Syndication de partners de Wikia',
	'all-blog-posts' => 'tote le categorias',
	'blog-posts-from-listing' => 'del lista: $1',
	'feed-title-hot-content' => 'Contento popular - $1',
	'feed-title-blogcomments' => 'Commentos a $1',
	'feed-title-recentchanges' => 'Modificationes recente',
);

/** Italian (italiano)
 * @author Minerva Titani
 */
$messages['it'] = array(
	'partner-feed-achievements-leaderboard' => 'Classifica dei successi nella wiki',
);

/** Japanese (日本語)
 * @author Barrel0116
 * @author Plover-Y
 */
$messages['ja'] = array(
	'partner-feed-recent-changes' => '最近の変更',
	'all-blog-posts' => 'すべてのカテゴリ',
	'feed-title-recentchanges' => '最近の更新',
	'partnerfeed' => 'パートナーフィード',
);

/** Kannada (ಕನ್ನಡ)
 * @author VASANTH S.N.
 */
$messages['kn'] = array(
	'partner-feed-recent-changes' => 'ಇತ್ತೀಚಿನ ಬದಲಾವಣೆಗಳು',
);

/** Korean (한국어)
 * @author Miri-Nae
 * @author 아라
 */
$messages['ko'] = array(
	'partner-feed-desc' => '파트너 피드 확장 기능',
	'partner-feed-achievements-leaderboard' => '위키 도전 과제 리더보드',
	'partner-feed-earned-badges' => '최근 특정 위키에서 얻은 배지',
	'partner-feed-recent-blog-posts' => '홍보와 연관된 최근 블로그 글',
	'partner-feed-latest-images' => '가장 최근에 올라온 그림 목록',
	'partner-feed-hotcontent' => '편집자 수에 따라 매겨진, 허브 및 분야의 "핫 콘텐츠"',
	'partner-feed-recent-blog-comments' => '특정 블로그 글과 연관된 최근 덧글',
	'partnerfeed' => '파트너 피드',
	'feed-title-blogposts' => '최근 블로그 게시물',
	'feed-title-recent-badges' => '최근 배지',
	'feed-title-recent-images' => '최근 그림',
	'feed-title-leaderboard' => '배지 현황판',
	'feed-main-title' => '위키아 파트너 피드',
	'feed-title-recentchanges' => '최근 바뀜',
);

/** Kurdish (Latin script) (Kurdî (latînî)‎)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'partner-feed-recent-changes' => 'Guherandinên dawî',
	'feed-title-recent-images' => 'Wêneyên dawî',
	'feed-title-recentchanges' => 'Guherandinên dawî',
);

/** Latin (Latina)
 * @author Rsa23899
 */
$messages['la'] = array(
	'partner-feed-recent-changes' => 'Nūper mūtāta',
	'feed-title-recentchanges' => 'Nūper mūtāta',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'partner-feed-latest-images' => 'Galerie vun de rezente Biller déi eropgeluede goufen',
	'partner-feed-recent-changes' => 'Rezent Ännerungen',
	'feed-title-recent-badges' => 'Rezent Badger',
	'feed-title-recent-images' => 'Rezent Biller',
	'all-blog-posts' => 'all Kategorien',
	'feed-title-blogcomments' => 'Bemierkungen iwwer $1',
	'feed-title-recentchanges' => 'Rezent Ännerungen',
);

/** Northern Luri (لوری مینجایی)
 * @author Mogoeilor
 */
$messages['lrc'] = array(
	'partner-feed-recent-changes' => 'آلشتیا تازه باو',
	'feed-title-recent-images' => 'عسکیا تازه باو',
	'feed-title-recentchanges' => 'آلشتیا تازه باو',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'partner-feed-achievements-leaderboard' => 'Предводници',
	'partner-feed-earned-badges' => 'Неодамна добиени значки за извесно вики',
	'partner-feed-recent-blog-posts' => 'Неодамнешни блог-записи поврзани со унапредување',
	'partner-feed-latest-images' => 'Галерија на најнови подигнати слики',
	'partner-feed-hotcontent' => 'Средиште / список на „Актуелни содржини“ според број на уредници',
	'partner-feed-recent-blog-comments' => 'Скорешни коментари поврзани со одреден блог-запис.',
	'partner-feed-recent-changes' => 'Скорешни промени',
	'partnerfeed' => 'Партнерски канал',
	'error-no-article' => 'Грешка: Не е добиен параметар „статија“',
	'feed-title-blogposts' => 'Скорешни блог-записи',
	'feed-title-recent-badges' => 'Скорешни значки',
	'feed-title-recent-images' => 'Скорешни слики',
	'feed-title-leaderboard' => 'Предводници',
	'feed-main-title' => 'Партнерска испорака',
	'all-blog-posts' => 'сите категории',
	'blog-posts-from-listing' => 'од списокот: $1',
	'feed-title-hot-content' => 'Актуелна содржина - $1',
	'feed-title-blogcomments' => 'Коментари на $1',
	'feed-title-recentchanges' => 'Скорешни промени',
	'partner-feed-error-no-blogpost-found' => '<b>Грешка:</b> Блоговскиот запис $1 не постои.',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'partner-feed-recent-changes' => 'സമീപകാല മാറ്റങ്ങൾ',
	'feed-title-recent-images' => 'സമീപകാല ചിത്രങ്ങൾ',
	'all-blog-posts' => 'എല്ലാ വർഗ്ഗങ്ങളും',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'partner-feed-desc' => 'Sambungan Partner Feed',
	'partner-feed-achievements-leaderboard' => 'Papan teraju pencapaian Wiki',
	'partner-feed-earned-badges' => 'Lencana-lencana yang baru diraih untuk Wiki tertentu',
	'partner-feed-recent-blog-posts' => 'Kiriman blog terkini yang berkenaan promosi',
	'partner-feed-latest-images' => 'Galeri gambar-gambar terbaru yang dimuat naik',
	'partner-feed-hotcontent' => '"Kandungan Hangat" portal seperti yang dinilai oleh penyunting',
	'partner-feed-recent-blog-comments' => 'Ulasan terkini berkenaan kiriman blog tertentu.',
	'partner-feed-recent-changes' => 'Perubahan terkini',
	'partnerfeed' => 'Suapan rakan kongsi',
	'error-no-article' => 'Perhatian: Tiada parameter "article" diluluskan',
	'feed-title-blogposts' => 'Kiriman blog terbaru',
	'feed-title-recent-badges' => 'Lencana terbaru',
	'feed-title-recent-images' => 'Gambar terbaru',
	'feed-title-leaderboard' => 'Papan teraju pencapaian',
	'feed-main-title' => 'Suapan rakan kongsi Wikia',
	'all-blog-posts' => 'semua kategori',
	'blog-posts-from-listing' => 'daripada senarai: $1',
	'feed-title-hot-content' => 'Kandungan hangat - $1',
	'feed-title-blogcomments' => 'Ulasan pada $1',
	'feed-title-recentchanges' => 'Perubahan terkini',
	'partner-feed-error-no-blogpost-found' => '<b>Ralat:</b> Catatan blog $1 tidak wujud.',
);

/** Mazanderani (مازِرونی)
 * @author محک
 */
$messages['mzn'] = array(
	'partner-feed-recent-changes' => 'تازه دگاردسته‌ئون',
	'feed-title-recentchanges' => 'تازه دگاردسته‌ئون',
);

/** Norwegian Bokmål (norsk bokmål)
 * @author Audun
 */
$messages['nb'] = array(
	'partner-feed-achievements-leaderboard' => 'Wikiens toppliste over utmerkelser',
	'partner-feed-earned-badges' => 'Nylig tildelte utmerkelser for en bestemt Wiki',
	'partner-feed-recent-blog-posts' => 'Siste blogginnlegg relatert til en kampanje',
	'partner-feed-latest-images' => 'Galleri av de siste bildene som har blitt lastet opp',
	'partner-feed-hotcontent' => 'Hub / vertikalt «Hett innhold» som rangert etter antall redaktører',
	'partner-feed-recent-blog-comments' => 'Siste kommentarer tilknyttet spesifiserte blogginnlegg.',
	'partner-feed-recent-changes' => 'Siste endringer',
	'partnerfeed' => 'Partner-feed',
	'error-no-article' => 'Feil: Ikke noe «artikkel»-parameter sendt',
	'feed-title-blogposts' => 'Siste blogginnlegg',
	'feed-title-recent-badges' => 'Siste utmerkelser',
	'feed-title-recent-images' => 'Siste bilder',
	'feed-title-leaderboard' => 'Toppliste over utmerkelser',
	'feed-main-title' => 'Wikia-partner-feed',
	'all-blog-posts' => 'alle kategorier',
	'blog-posts-from-listing' => 'fra opplisting: $1',
	'feed-title-hot-content' => 'Hot innhold - $1',
	'feed-title-blogcomments' => 'Kommentarer til $1',
	'feed-title-recentchanges' => 'Siste endringer',
);

/** Dutch (Nederlands)
 * @author McDutchie
 * @author Siebrand
 */
$messages['nl'] = array(
	'partner-feed-achievements-leaderboard' => "Scorebord prestaties voor wiki's",
	'partner-feed-earned-badges' => 'Recent verdiende speldjes voor een specifieke wiki',
	'partner-feed-recent-blog-posts' => 'Recente blogberichten over aanbiedingen',
	'partner-feed-latest-images' => 'Galerij van de laatst toegevoegde afbeeldingen',
	'partner-feed-hotcontent' => '"Populaire inhoud" van hub geordend op aantal auteurs',
	'partner-feed-recent-blog-comments' => 'Recente opmerkingen bij specifieke blogberichten.',
	'partner-feed-recent-changes' => 'Recente wijzigingen',
	'partnerfeed' => 'Partnerfeed',
	'error-no-article' => 'Fout: de parameter "article" is niet doorgegeven',
	'feed-title-blogposts' => 'Recente blogberichten',
	'feed-title-recent-badges' => 'Recente speldjes',
	'feed-title-recent-images' => 'Recente afbeeldingen',
	'feed-title-leaderboard' => 'Ranglijst voor prestaties',
	'feed-main-title' => 'Wikia partnerfeed',
	'all-blog-posts' => 'alle categorieën',
	'blog-posts-from-listing' => 'van lijst: $1',
	'feed-title-hot-content' => 'Populaire inhoud - $1',
	'feed-title-blogcomments' => 'Opmerkingen bij $1',
	'feed-title-recentchanges' => 'Recente wijzigingen',
	'partner-feed-error-no-blogpost-found' => '<b>Fout:</b> Blogbericht $1 bestaat niet.',
);

/** Occitan (occitan)
 * @author Cedric31
 * @author Hulothe
 */
$messages['oc'] = array(
	'partner-feed-recent-changes' => 'Darrièrs cambiaments',
	'partnerfeed' => 'Partenari de flux',
	'feed-title-blogposts' => 'Darrièrs bilhets',
	'feed-main-title' => 'Flux de partenari Wikia',
	'feed-title-blogcomments' => 'Comentaris a $1',
	'feed-title-recentchanges' => 'Darrièrs cambiaments',
);

/** Polish (polski)
 * @author BeginaFelicysym
 * @author Sovq
 */
$messages['pl'] = array(
	'partner-feed-achievements-leaderboard' => 'Ranking odznaczeń na wiki',
	'partner-feed-earned-badges' => 'Niedawno przyznane odznaczenia dla określonego typu wiki',
	'partner-feed-recent-blog-posts' => 'Ostatnie wpisy na blogach związane z promocją',
	'partner-feed-latest-images' => 'Galerie z najnowszymi przesłanymi obrazami',
	'partner-feed-hotcontent' => 'Portale uszeregowane według liczby edytorów',
	'partner-feed-recent-blog-comments' => 'Ostatnie komentarze dotyczące określonego wpisu na blogu.',
	'partner-feed-recent-changes' => 'Ostatnie zmiany',
	'partnerfeed' => 'Subskrybuj kanał',
	'error-no-article' => 'Błąd: Brak parametru "artykuł"',
	'feed-title-blogposts' => 'Ostatnie wpisy na blogu',
	'feed-title-recent-badges' => 'Ostatnie odznaczenia',
	'feed-title-recent-images' => 'Najnowsze obrazy',
	'feed-title-leaderboard' => 'Ranking odznaczeń',
	'feed-main-title' => 'Kanał partnerów Wikii',
	'all-blog-posts' => 'wszystkie kategorie',
	'blog-posts-from-listing' => 'z wykazu: $1',
	'feed-title-hot-content' => 'Gorące treści - $1',
	'feed-title-blogcomments' => 'Komentarze do $1',
	'feed-title-recentchanges' => 'Ostatnie zmiany',
	'partner-feed-error-no-blogpost-found' => '<b>Błąd:</b> Wpis na blogu $1 nie istnieje.',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'partner-feed-achievements-leaderboard' => 'Tàula dle realisassion dle Wiki',
	'partner-feed-earned-badges' => 'Distintiv vagnà recentement për na Wiki specifica',
	'partner-feed-recent-blog-posts' => 'Mëssagi dë scartari recent relativ a na promossion',
	'partner-feed-latest-images' => "Galarìa dj'ùltime figure ch'a son ëstàite carià",
	'partner-feed-hotcontent' => "Sènter ëd contnù ativ classificà për nùmer d'editor",
	'partner-feed-recent-blog-comments' => 'Coment recent colegà al mëssagi dë scartari specificà.',
	'partner-feed-recent-changes' => 'Ùltime modìfiche',
	'partnerfeed' => 'Cambrada ëd fluss',
	'error-no-article' => 'Eror: Gnun paràmetr "artìcol" passà',
	'feed-title-blogposts' => 'Mëssagi dë Scartari recent',
	'feed-title-recent-badges' => 'Distintiv recent',
	'feed-title-recent-images' => 'Figure recente',
	'feed-title-leaderboard' => 'Tàula dij sucess',
	'feed-main-title' => 'Fluss ëd cambrada Wikia',
	'all-blog-posts' => 'tute le categorìe',
	'blog-posts-from-listing' => 'da listé: $1',
	'feed-title-hot-content' => 'Contnù càud - $1',
	'feed-title-blogcomments' => 'Coment a $1',
	'feed-title-recentchanges' => 'Ùltime modìfiche',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'partner-feed-recent-changes' => 'وروستي بدلونونه',
	'feed-title-recent-images' => 'تازه انځورونه',
	'all-blog-posts' => 'ټولې وېشنيزې',
);

/** Portuguese (português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'partner-feed-achievements-leaderboard' => 'Liderança de medalhas das wikis',
	'partner-feed-earned-badges' => 'Medalhas ganhas recentemente numa wiki específica',
	'partner-feed-recent-blog-posts' => 'Entradas recentes em blogues, relacionadas com uma promoção',
	'partner-feed-latest-images' => 'Galeria das últimas imagens enviadas',
	'partner-feed-hotcontent' => '"Pontos Quentes" dos portais, de acordo com o número de editores',
	'partner-feed-recent-blog-comments' => 'Comentários recentes relacionados com uma entrada de blogue especificada.',
	'partner-feed-recent-changes' => 'Mudanças recentes',
	'partnerfeed' => 'Feeds adicionais',
	'error-no-article' => 'Erro: Não foi passado o parâmetro "article"',
	'feed-title-blogposts' => 'Entradas recentes em blogues',
	'feed-title-recent-badges' => 'Medalhas recentes',
	'feed-title-recent-images' => 'Imagens recentes',
	'feed-title-leaderboard' => 'Liderança de medalhas',
	'feed-main-title' => 'Feeds adicionais da Wikia',
	'all-blog-posts' => 'todas as categorias',
	'blog-posts-from-listing' => 'da listagem: $1',
	'feed-title-hot-content' => 'Conteúdo popular - $1',
	'feed-title-blogcomments' => 'Comentários a $1',
	'feed-title-recentchanges' => 'Mudanças recentes',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Aristóbulo
 * @author Cainamarques
 * @author Giro720
 */
$messages['pt-br'] = array(
	'partner-feed-achievements-leaderboard' => 'Liderança de medalhas das wikis',
	'partner-feed-earned-badges' => 'Medalhas ganhas recentemente numa wiki específica',
	'partner-feed-recent-blog-posts' => 'Posts recentes em blogues, relacionadas com uma promoção',
	'partner-feed-latest-images' => 'Galeria das últimas imagens enviadas',
	'partner-feed-hotcontent' => '"Pontos Quentes" dos portais, de acordo com o número de editores',
	'partner-feed-recent-blog-comments' => 'Comentários recentes relacionados com um post de blogue especificado.',
	'partner-feed-recent-changes' => 'Mudanças recentes',
	'partnerfeed' => 'Feed de um parceiro',
	'error-no-article' => 'Erro: Não foi passado o parâmetro "article"',
	'feed-title-blogposts' => 'Posts recentes em blogues',
	'feed-title-recent-badges' => 'Condecorações recentes',
	'feed-title-recent-images' => 'Imagens recentes',
	'feed-title-leaderboard' => 'Liderança de medalhas',
	'feed-main-title' => 'Feed de um parceiro da Wikia',
	'all-blog-posts' => 'todas as categorias',
	'blog-posts-from-listing' => 'da listagem: $1',
	'feed-title-hot-content' => 'Conteúdo popular - $1',
	'feed-title-blogcomments' => 'Comentários em $1',
	'feed-title-recentchanges' => 'Mudanças recentes',
	'partner-feed-error-no-blogpost-found' => '<b>Error:</b> O post $1 não existe.',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'partner-feed-recent-changes' => 'Cangiaminde recende',
	'all-blog-posts' => 'tutte le categorije',
	'blog-posts-from-listing' => 'da elengà: $1',
	'feed-title-hot-content' => 'Condenute cavede - $1',
	'feed-title-blogcomments' => 'Commende a $1',
	'feed-title-recentchanges' => 'Cangiaminde recende',
);

/** Russian (русский)
 * @author DCamer
 * @author Eleferen
 * @author Kuzura
 * @author Okras
 */
$messages['ru'] = array(
	'partner-feed-achievements-leaderboard' => 'Лидеры по наградам на вики',
	'partner-feed-earned-badges' => 'Недавно заработанные значки на конкретной вики',
	'partner-feed-recent-blog-posts' => 'Последние записи в блоге, связанные с рекламой',
	'partner-feed-latest-images' => 'Галерея из последних изображений, которые были загружены на вики',
	'partner-feed-hotcontent' => 'Портал / по вертикали "Hot Content" отсортировано по количеству редакторов',
	'partner-feed-recent-blog-comments' => 'Последние комментарии, связанные с указанным блогом.',
	'partner-feed-recent-changes' => 'Свежие правки',
	'partnerfeed' => 'Партнерская рассылка',
	'error-no-article' => 'Ошибка: нет "статьи" с такими параметрами',
	'feed-title-blogposts' => 'Последние записи в блоге',
	'feed-title-recent-badges' => 'Последние значки',
	'feed-title-recent-images' => 'Последние изображения',
	'feed-title-leaderboard' => 'Лидеры по наградам',
	'feed-main-title' => 'Партнерская рассылка Wikia',
	'all-blog-posts' => 'все категории',
	'blog-posts-from-listing' => 'из списка: $1',
	'feed-title-hot-content' => 'Топ контент - $1',
	'feed-title-blogcomments' => 'Комментарии к $1',
	'feed-title-recentchanges' => 'Свежие правки',
	'partner-feed-error-no-blogpost-found' => '<b>Ошибка:</b> Сообщение $1 в блоге не существует.',
);

/** Serbian (Cyrillic script) (српски (ћирилица)‎)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'partner-feed-recent-changes' => 'Скорашње измене',
	'feed-title-recent-badges' => 'Скорашње значке',
	'feed-title-recent-images' => 'Скорашње слике',
);

/** Swedish (svenska)
 * @author Tobulos1
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'partner-feed-desc' => 'Tillägg för partnersmatning',
	'partner-feed-achievements-leaderboard' => 'Wikins topplista för utmärkelser',
	'partner-feed-earned-badges' => 'Nyligen tjänade emblem för en viss Wiki',
	'partner-feed-recent-blog-posts' => 'Senaste blogginläggen med anknytning till en befordran',
	'partner-feed-latest-images' => 'Galleri med de senaste bilderna som har laddats upp',
	'partner-feed-hotcontent' => 'Hub / vertikalt "Hett innehåll" som rangordnas efter antalet redigerare',
	'partner-feed-recent-blog-comments' => 'Senaste kommentarer som anknyter till specifika blogginlägg.',
	'partner-feed-recent-changes' => 'Senaste ändringar',
	'partnerfeed' => 'Partnerflöde',
	'error-no-article' => 'Fel: Ingen "artikel"-parameter passerade',
	'feed-title-blogposts' => 'Senaste blogginlägg',
	'feed-title-recent-badges' => 'Senaste emblem',
	'feed-title-recent-images' => 'Senaste bilder',
	'feed-title-leaderboard' => 'Topplista för utmärkelser',
	'feed-main-title' => 'Wikias partnerflöde',
	'all-blog-posts' => 'alla kategorier',
	'blog-posts-from-listing' => 'från lista: $1',
	'feed-title-hot-content' => 'Hett innehåll - $1',
	'feed-title-blogcomments' => 'Kommentarer till $1',
	'feed-title-recentchanges' => 'Senaste ändringar',
	'partner-feed-error-no-blogpost-found' => '<b>Fel:</b> Blogginlägget $1 finns inte.',
);

/** Tamil (தமிழ்)
 * @author Karthi.dr
 */
$messages['ta'] = array(
	'partner-feed-earned-badges' => 'குறிப்பிட்ட விக்கிக்காக அண்மையில் ஈட்டப்பட்ட பதக்கங்கள்',
	'feed-title-recent-images' => 'அண்மைய படங்கள்',
	'all-blog-posts' => 'அனைத்து பகுப்புகளும்',
	'feed-title-recentchanges' => 'அண்மைய மாற்றங்கள்',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'partner-feed-recent-changes' => 'ఇటీవలి మార్పులు',
	'all-blog-posts' => 'అన్ని వర్గాలు',
	'feed-title-recentchanges' => 'ఇటీవలి మార్పులు',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'partner-feed-achievements-leaderboard' => 'Pinunong pisara ng mga nakamit na pang mga wiki',
	'partner-feed-earned-badges' => 'Kamakailang nakamit na mga tsapa para sa isang partikular na Wiki',
	'partner-feed-recent-blog-posts' => 'Kamakailang mga pagpapaskil na blog kaugnay ng isang patalastas',
	'partner-feed-latest-images' => 'Tanghalan ng pinakabagong mga larawan na naikargang papaitaas',
	'partner-feed-hotcontent' => 'Pusod / lagusan ng "Maiinit na mga Nilalaman" ayon sa pagkakaranggo sa pamamagitan ng bilang ng mga patnugot',
	'partner-feed-recent-blog-comments' => 'Kamakailang mga puna na may kaugnayan sa tinukoy na paskil na blog.',
	'partner-feed-recent-changes' => 'Kamakailang mga pagbabago',
	'partnerfeed' => 'Pakain ng katambal',
	'error-no-article' => 'Kamalian: Walang pumasang mga parametro ng "artikulo"',
	'feed-title-blogposts' => 'Kamakailang mga pagpapaskil ng blog',
	'feed-title-recent-badges' => 'Kamakailang mga tsapa',
	'feed-title-recent-images' => 'Kamakailang mga larawan',
	'feed-title-leaderboard' => 'Pinunong pisara ng mga nakamit',
	'feed-main-title' => 'Pakain ng katambal ng Wikia',
	'all-blog-posts' => 'lahat ng mga kategorya',
	'blog-posts-from-listing' => 'mula sa pagkakalista: $1',
	'feed-title-hot-content' => 'Mainit na nilalaman - $1',
	'feed-title-blogcomments' => 'Mga puna sa $1',
	'feed-title-recentchanges' => 'Kamakailang mga pagbabago',
);

/** Turkish (Türkçe)
 * @author Sucsuzz
 */
$messages['tr'] = array(
	'feed-title-recentchanges' => 'Son değişiklikler',
);

/** Ukrainian (українська)
 * @author A1
 * @author Andriykopanytsia
 * @author Ua2004
 * @author Тест
 */
$messages['uk'] = array(
	'partner-feed-achievements-leaderboard' => 'Список нагороджених на вікі',
	'partner-feed-earned-badges' => 'Нещодавні відзнаки на конкретній Вікі',
	'partner-feed-recent-blog-posts' => "Останні записи в блозі пов'язані з рекламою",
	'partner-feed-latest-images' => 'Останні зображень, що були завантажені на вікі',
	'partner-feed-hotcontent' => 'Портал / по вертикалі "Hot Content" відсортовано за кількістю редакторів',
	'partner-feed-recent-blog-comments' => "Останні коментарі, пов'язані із зазначеним блогом.",
	'partner-feed-recent-changes' => 'Нові редагування',
	'partnerfeed' => 'Партнерська розсилка',
	'error-no-article' => 'Помилка: ні "статті" з такими параметрами',
	'feed-title-blogposts' => 'Останні записи в блозі',
	'feed-title-recent-badges' => 'Останні відзнаки',
	'feed-title-recent-images' => 'Останні зображення',
	'feed-title-leaderboard' => 'Список нагороджених на вікі',
	'feed-main-title' => 'Партнерська розсилка Wikia',
	'all-blog-posts' => 'усі категорії',
	'blog-posts-from-listing' => 'зі списку: $1',
	'feed-title-hot-content' => 'Топ контент - $1',
	'feed-title-blogcomments' => 'Коментарі до $1',
	'feed-title-recentchanges' => 'Нові редагування',
	'partner-feed-error-no-blogpost-found' => '<b>Помилка:</b> Повідомлення в блозі  $1  не існує.',
);

/** Vietnamese (Tiếng Việt)
 * @author Baonguyen21022003
 */
$messages['vi'] = array(
	'partner-feed-achievements-leaderboard' => 'Wiki bảng dẫn thành lựu',
	'partner-feed-earned-badges' => 'Huy hiệu vừa đạt được cho một liên kết cụ thể',
	'partner-feed-recent-blog-posts' => 'Bài viết blog gần đây liên quan đến một quảng cáo',
	'partner-feed-latest-images' => 'Bộ sưu tập của những hình ảnh mới nhất mà đã được tải lên',
	'partner-feed-hotcontent' => 'Trung tâm / dọc "nội dung nóng" như xếp hạng theo số biên tập viên',
	'partner-feed-recent-blog-comments' => 'Ý kiến gần đây liên quan đến quy định bài đăng blog.',
	'partner-feed-recent-changes' => 'Thay đổi gần đây',
	'partnerfeed' => 'Nguồn cấp dữ liệu đối tác',
	'error-no-article' => 'Lỗi: Không có tham số "bài viết" thông qua',
	'feed-title-blogposts' => 'Blog đăng gần đây',
	'feed-title-recent-badges' => 'Thay đổi phù hiệu gần đây',
	'feed-title-recent-images' => 'Thay đổi hình ảnh gần đây',
	'feed-title-leaderboard' => 'Bảng dẫn thành lựu',
	'feed-main-title' => 'Wikia đối tác nguồn cấp dữ liệu',
	'all-blog-posts' => 'Tất cả thể loại',
	'blog-posts-from-listing' => 'từ bảng liệt kê: $1',
	'feed-title-hot-content' => 'Nội dung nóng - $1',
	'feed-title-blogcomments' => 'Bình luận cho $1',
	'feed-title-recentchanges' => 'Thay đổi gần đây',
	'partner-feed-error-no-blogpost-found' => '<b>Lỗi:</b> Bài đăng blog $1 không tồn tại.',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Dimension
 * @author Hydra
 * @author Liuxinyu970226
 * @author Yfdyh000
 */
$messages['zh-hans'] = array(
	'partner-feed-desc' => '合作伙伴订阅点扩展',
	'partner-feed-achievements-leaderboard' => 'Wiki成就排行榜',
	'partner-feed-earned-badges' => '最近在特定wiki获得的徽章',
	'partner-feed-recent-blog-posts' => '最近有关宣传的博客文章',
	'partner-feed-latest-images' => '图片库中的最新图像已被更新',
	'partner-feed-hotcontent' => '门户中的“热门内容”是通过编辑次数排名',
	'partner-feed-recent-blog-comments' => '有关指定博客文章的最近的评论。',
	'partner-feed-recent-changes' => '最近更改',
	'partnerfeed' => '合作伙伴订阅点',
	'error-no-article' => '错误：未传递“article”参数',
	'feed-title-blogposts' => '最近的博客文章',
	'feed-title-recent-badges' => '最新徽章',
	'feed-title-recent-images' => '最近的图片',
	'feed-title-leaderboard' => '成就排行榜',
	'feed-main-title' => 'Wikia合作伙伴订阅点',
	'all-blog-posts' => '全部分类',
	'blog-posts-from-listing' => '来自列表：$1',
	'feed-title-hot-content' => '热点内容 - $1',
	'feed-title-blogcomments' => '评论 $1',
	'feed-title-recentchanges' => '最近更改',
	'partner-feed-error-no-blogpost-found' => '<b>错误：</b>博客文章$1不存在。',
);

/** Traditional Chinese (中文（繁體）‎)
 * @author EagerLin
 */
$messages['zh-hant'] = array(
	'partner-feed-recent-changes' => '近期變動',
	'feed-title-recentchanges' => '近期變動',
);
