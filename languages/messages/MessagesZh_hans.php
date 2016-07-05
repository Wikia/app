<?php
/** Simplified Chinese (‪中文(简体)‬)
 *
 * See MessagesQqq.php for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Alebcay
 * @author Anakmalaysia
 * @author Bencmq
 * @author Biŋhai
 * @author Breawycker
 * @author Chenxiaoqino
 * @author Chenzw
 * @author Chinalace
 * @author Dingyuang
 * @author Fantasticfears
 * @author Franklsf95
 * @author Gaoxuewei
 * @author Gzdavidwong
 * @author Happy
 * @author Hercule
 * @author Horacewai2
 * @author Hydra
 * @author Hzy980512
 * @author Jding2010
 * @author Jidanni
 * @author Jimmy xu wrk
 * @author Kaganer
 * @author KaiesTse
 * @author Kuailong
 * @author Liangent
 * @author Mark85296341
 * @author MarkAHershberger
 * @author Mys 721tx
 * @author O
 * @author Onecountry
 * @author PhiLiP
 * @author Shinjiman
 * @author Shizhao
 * @author Tommyang
 * @author Waihorace
 * @author Wilsonmess
 * @author Wmr89502270
 * @author Wong128hk
 * @author Wrightbus
 * @author Xiaomingyan
 * @author Yfdyh000
 * @author 阿pp
 */

$fallback8bitEncoding = 'windows-936';

$namespaceNames = array(
	NS_MEDIA            => '媒体文件',
	NS_SPECIAL          => '特殊',
	NS_TALK             => '讨论',
	NS_USER             => '用户',
	NS_USER_TALK        => '用户讨论',
	NS_PROJECT_TALK     => '$1讨论',
	NS_FILE             => '文件',
	NS_FILE_TALK        => '文件讨论',
	NS_MEDIAWIKI        => 'MediaWiki',
	NS_MEDIAWIKI_TALK   => 'MediaWiki讨论',
	NS_TEMPLATE         => '模板',
	NS_TEMPLATE_TALK    => '模板讨论',
	NS_HELP             => '帮助',
	NS_HELP_TALK        => '帮助讨论',
	NS_CATEGORY         => '分类',
	NS_CATEGORY_TALK    => '分类讨论',
);

$namespaceAliases = array(
	'媒体'	=> NS_MEDIA,
	'特殊'  => NS_SPECIAL,
	'对话'  => NS_TALK,
	'讨论'	=> NS_TALK,
	'用户'  => NS_USER,
	'用户对话' => NS_USER_TALK,
	'用户讨论' => NS_USER_TALK,
	'图像' => NS_FILE,
	'档案' => NS_FILE,
	'文件' => NS_FILE,
	'Image' => NS_FILE,
	'Image_talk' => NS_FILE_TALK,
	'图像对话' => NS_FILE_TALK,
	'图像讨论' => NS_FILE_TALK,
	'档案对话' => NS_FILE_TALK,
	'档案讨论' => NS_FILE_TALK,
	'文件对话' => NS_FILE_TALK,
	'文件讨论' => NS_FILE_TALK,
	'模板'	=> NS_TEMPLATE,
	'模板对话' => NS_TEMPLATE_TALK,
	'模板讨论' => NS_TEMPLATE_TALK,
	'帮助'	=> NS_HELP,
	'帮助对话' => NS_HELP_TALK,
	'帮助讨论' => NS_HELP_TALK,
	'分类'	=> NS_CATEGORY,
	'分类对话' => NS_CATEGORY_TALK,
	'分类讨论' => NS_CATEGORY_TALK,
);

$specialPageAliases = array(
	'Activeusers'               => array( '活跃用户' ),
	'Allmessages'               => array( '所有信息' ),
	'Allpages'                  => array( '所有页面' ),
	'Ancientpages'              => array( '最早页面' ),
	'Blankpage'                 => array( '空白页面' ),
	'Block'                     => array( '封禁用户' ),
	'Blockme'                   => array( '自我封禁' ),
	'Booksources'               => array( '网络书源' ),
	'BrokenRedirects'           => array( '损坏的重定向页' ),
	'Categories'                => array( '页面分类' ),
	'ChangeEmail'               => array( '修改邮箱' ),
	'ChangePassword'            => array( '修改密码' ),
	'ComparePages'              => array( '比较页面' ),
	'Confirmemail'              => array( '确认电子邮件' ),
	'Contributions'             => array( '用户贡献' ),
	'CreateAccount'             => array( '创建账户' ),
	'Deadendpages'              => array( '断链页面' ),
	'DeletedContributions'      => array( '已删除的用户贡献' ),
	'Disambiguations'           => array( '消歧义页' ),
	'DoubleRedirects'           => array( '双重重定向页', '两次重定向页' ),
	'EditWatchlist'             => array( '编辑监视列表' ),
	'Emailuser'                 => array( '电子邮件用户' ),
	'Export'                    => array( '导出页面' ),
	'Fewestrevisions'           => array( '最少修订页面' ),
	'FileDuplicateSearch'       => array( '搜索重复文件' ),
	'Filepath'                  => array( '文件路径' ),
	'Import'                    => array( '导入页面' ),
	'Invalidateemail'           => array( '无效电邮地址' ),
	'BlockList'                 => array( '封禁列表' ),
	'LinkSearch'                => array( '搜索网页链接' ),
	'Listadmins'                => array( '管理员列表' ),
	'Listbots'                  => array( '机器人列表' ),
	'Listfiles'                 => array( '文件列表' ),
	'Listgrouprights'           => array( '用户组权限' ),
	'Listredirects'             => array( '重定向页列表' ),
	'Listusers'                 => array( '用户列表' ),
	'Lockdb'                    => array( '锁定数据库' ),
	'Log'                       => array( '日志' ),
	'Lonelypages'               => array( '孤立页面' ),
	'Longpages'                 => array( '长页面' ),
	'MergeHistory'              => array( '合并历史' ),
	'MIMEsearch'                => array( 'MIME搜索' ),
	'Mostcategories'            => array( '最多分类页面' ),
	'Mostimages'                => array( '最多链接文件' ),
	'Mostlinked'                => array( '最多链接页面' ),
	'Mostlinkedcategories'      => array( '最多链接分类' ),
	'Mostlinkedtemplates'       => array( '最多链接模板' ),
	'Mostrevisions'             => array( '最多修订页面' ),
	'Movepage'                  => array( '移动页面' ),
	'Mycontributions'           => array( '我的贡献' ),
	'Mypage'                    => array( '我的用户页' ),
	'Mytalk'                    => array( '我的讨论页' ),
	'Myuploads'                 => array( '我上传的文件', '我的上传' ),
	'Newimages'                 => array( '新建文件' ),
	'Newpages'                  => array( '新建页面' ),
	'PasswordReset'             => array( '重设密码' ),
	'PermanentLink'             => array( '永久链接' ),
	'Popularpages'              => array( '热点页面' ),
	'Preferences'               => array( '参数设置', '系统设置' ),
	'Prefixindex'               => array( '前缀索引' ),
	'Protectedpages'            => array( '已保护页面' ),
	'Protectedtitles'           => array( '已保护标题' ),
	'Randompage'                => array( '随机页面' ),
	'Randomredirect'            => array( '随机重定向页' ),
	'Recentchanges'             => array( '最近更改' ),
	'Recentchangeslinked'       => array( '链出更改' ),
	'Revisiondelete'            => array( '删除或恢复版本' ),
	'RevisionMove'              => array( '修订版本移动' ),
	'Search'                    => array( '搜索' ),
	'Shortpages'                => array( '短页面' ),
	'Specialpages'              => array( '特殊页面' ),
	'Statistics'                => array( '统计信息' ),
	'Tags'                      => array( '标签' ),
	'Unblock'                   => array( '解除封禁' ),
	'Uncategorizedcategories'   => array( '无分类分类' ),
	'Uncategorizedimages'       => array( '无分类文件' ),
	'Uncategorizedpages'        => array( '无分类页面' ),
	'Uncategorizedtemplates'    => array( '无分类模板' ),
	'Undelete'                  => array( '恢复被删页面' ),
	'Unlockdb'                  => array( '解除数据库锁定' ),
	'Unusedcategories'          => array( '未使用分类' ),
	'Unusedimages'              => array( '未使用文件' ),
	'Unusedtemplates'           => array( '未使用模板' ),
	'Unwatchedpages'            => array( '未受监视页面' ),
	'Upload'                    => array( '上传文件' ),
	'UploadStash'               => array( '上传藏匿' ),
	'Userlogin'                 => array( '用户登录', '用户登入' ),
	'Userlogout'                => array( '用户退出', '用户登出' ),
	'Userrights'                => array( '用户权限' ),
	'Version'                   => array( '版本信息' ),
	'Wantedcategories'          => array( '待撰分类' ),
	'Wantedfiles'               => array( '需要的文件' ),
	'Wantedpages'               => array( '待撰页面' ),
	'Wantedtemplates'           => array( '需要的模板' ),
	'Watchlist'                 => array( '监视列表' ),
	'Whatlinkshere'             => array( '链入页面' ),
	'Withoutinterwiki'          => array( '无跨Wiki链接的页面', '无跨维基链接页面' ),
);

$magicWords = array(
	'redirect'                => array( '0', '#重定向', '#REDIRECT' ),
	'notoc'                   => array( '0', '_无目录_', '__NOTOC__' ),
	'nogallery'               => array( '0', '_无图库_', '__NOGALLERY__' ),
	'forcetoc'                => array( '0', '_强显目录_', '__FORCETOC__' ),
	'toc'                     => array( '0', '_目录_', '__TOC__' ),
	'noeditsection'           => array( '0', '_无段落编辑_', '__NOEDITSECTION__' ),
	'currentmonth'            => array( '1', '本月', 'CURRENTMONTH', 'CURRENTMONTH2' ),
	'currentmonth1'           => array( '1', '本月1', 'CURRENTMONTH1' ),
	'currentmonthname'        => array( '1', '本月名称', 'CURRENTMONTHNAME' ),
	'currentmonthabbrev'      => array( '1', '本月简称', 'CURRENTMONTHABBREV' ),
	'currentday'              => array( '1', '今天', 'CURRENTDAY' ),
	'currentday2'             => array( '1', '今天2', 'CURRENTDAY2' ),
	'currentyear'             => array( '1', '今年', 'CURRENTYEAR' ),
	'numberofpages'           => array( '1', '页数', 'NUMBEROFPAGES' ),
	'numberofarticles'        => array( '1', '条目数', 'NUMBEROFARTICLES' ),
	'numberoffiles'           => array( '1', '文件数', 'NUMBEROFFILES' ),
	'numberofusers'           => array( '1', '用户数', 'NUMBEROFUSERS' ),
	'numberofactiveusers'     => array( '1', '活跃用户数', 'NUMBEROFACTIVEUSERS' ),
	'numberofedits'           => array( '1', '编辑数', 'NUMBEROFEDITS' ),
	'numberofviews'           => array( '1', '访问数', 'NUMBEROFVIEWS' ),
	'pagename'                => array( '1', '页名', 'PAGENAME' ),
);

$linkTrail = '/^()(.*)$/sD';

$extraUserToggles = array(
	'nolangconversion',
);
$datePreferences = array(
	'default',
	'ISO 8601',
);
$defaultDateFormat = 'zh';
$dateFormats = array(
	'zh time' => 'H:i',
	'zh date' => 'Y年n月j日',
	'zh both' => 'Y年n月j日 (D) H:i',
);

$bookstoreList = array(
	'AddALL' => 'http://www.addall.com/New/Partner.cgi?query=$1&type=ISBN',
	'PriceSCAN' => 'http://www.pricescan.com/books/bookDetail.asp?isbn=$1',
	'Barnes & Noble' => 'http://search.barnesandnoble.com/bookSearch/isbnInquiry.asp?isbn=$1',
	'亚马逊' => 'http://www.amazon.com/exec/obidos/ISBN=$1',
	'卓越亚马逊' => 'http://www.amazon.cn/mn/advancedSearchApp?isbn=$1',
	'当当网' => 'http://search.dangdang.com/search.aspx?key=$1',
	'博客来书店' => 'http://www.books.com.tw/exep/prod/booksfile.php?item=$1',
	'三民书店' => 'http://www.sanmin.com.tw/page-qsearch.asp?ct=search_isbn&qu=$1',
	'天下书店' => 'http://www.cwbook.com.tw/search/result1.jsp?field=2&keyWord=$1',
	'新丝路书店' => 'http://www.silkbook.com/function/Search_list_book_data.asp?item=5&text=$1'
);

