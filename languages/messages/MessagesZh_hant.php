<?php
/** Traditional Chinese (‪中文(繁體)‬)
 *
 * See MessagesQqq.php for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Alexsh
 * @author Anakmalaysia
 * @author Andrew971218
 * @author Bencmq
 * @author Breawycker
 * @author FireJackey
 * @author Frankou
 * @author Gaoxuewei
 * @author Hakka
 * @author Horacewai2
 * @author Hydra
 * @author Hzy980512
 * @author Jidanni
 * @author Jimmy xu wrk
 * @author Kaganer
 * @author KaiesTse
 * @author Kuailong
 * @author Lauhenry
 * @author Liangent
 * @author Mark85296341
 * @author Oapbtommy
 * @author Pbdragonwang
 * @author PhiLiP
 * @author Philip
 * @author Shinjiman
 * @author Shizhao
 * @author Skjackey tse
 * @author Waihorace
 * @author Wmr89502270
 * @author Wong128hk
 * @author Wrightbus
 * @author Xiaomingyan
 * @author Yuyu
 */

$fallback = 'zh-hans';

$fallback8bitEncoding = 'windows-950';

$namespaceNames = array(
	NS_MEDIA            => '媒體',
	NS_SPECIAL          => '特殊',
	NS_TALK             => '討論',
	NS_USER             => '用戶',
	NS_USER_TALK        => '用戶討論',
	NS_PROJECT_TALK     => '$1討論',
	NS_FILE             => '檔案',
	NS_FILE_TALK        => '檔案討論',
	NS_MEDIAWIKI        => 'MediaWiki',
	NS_MEDIAWIKI_TALK   => 'MediaWiki討論',
	NS_TEMPLATE         => '模板',
	NS_TEMPLATE_TALK    => '模板討論',
	NS_HELP             => '幫助',
	NS_HELP_TALK        => '幫助討論',
	NS_CATEGORY         => '分類',
	NS_CATEGORY_TALK    => '分類討論',
);

$namespaceAliases = array(
	"媒體" => NS_MEDIA,
	"特殊" => NS_SPECIAL,
	"對話" => NS_TALK,
	"討論" => NS_TALK,
	"用戶" => NS_USER,
	"用戶對話" => NS_USER_TALK,
	"用戶討論" => NS_USER_TALK,
	# This has never worked so it's unlikely to annoy anyone if I disable it -- TS
	# "{{SITENAME}}_對話" => NS_PROJECT_TALK
	"圖像" => NS_FILE,
	"檔案" => NS_FILE,
	"文件" => NS_FILE,
	'Image' => NS_FILE,
	'Image_talk' => NS_FILE_TALK,
	"圖像對話" => NS_FILE_TALK,
	"圖像討論" => NS_FILE_TALK,
	"檔案對話" => NS_FILE_TALK,
	"檔案討論" => NS_FILE_TALK,
	"文件對話" => NS_FILE_TALK,
	"文件討論" => NS_FILE_TALK,
	"樣板" => NS_TEMPLATE,
	"模板" => NS_TEMPLATE,
	"樣板對話" => NS_TEMPLATE_TALK,
	"樣板討論" => NS_TEMPLATE_TALK,
	"模板對話" => NS_TEMPLATE_TALK,
	"模板討論" => NS_TEMPLATE_TALK,
	"幫助" => NS_HELP,
	"幫助對話" => NS_HELP_TALK,
	"幫助討論" => NS_HELP_TALK,
	"分類" => NS_CATEGORY,
	"分類對話" => NS_CATEGORY_TALK,
	"分類討論" => NS_CATEGORY_TALK,
);

$specialPageAliases = array(
	'Activeusers'               => array( '活躍用戶' ),
	'Allmessages'               => array( '所有信息' ),
	'Allpages'                  => array( '所有頁面' ),
	'Ancientpages'              => array( '最早頁面' ),
	'Blankpage'                 => array( '空白頁面' ),
	'Block'                     => array( '查封用戶' ),
	'Blockme'                   => array( '封禁我' ),
	'Booksources'               => array( '網絡書源' ),
	'BrokenRedirects'           => array( '損壞的重定向頁' ),
	'Categories'                => array( '頁面分類' ),
	'ChangePassword'            => array( '修改密碼' ),
	'ComparePages'              => array( '頁面比較' ),
	'Confirmemail'              => array( '確認電子郵件' ),
	'Contributions'             => array( '用戶貢獻' ),
	'CreateAccount'             => array( '創建賬戶' ),
	'Deadendpages'              => array( '斷鏈頁面' ),
	'DeletedContributions'      => array( '已刪除的用戶貢獻' ),
	'Disambiguations'           => array( '消歧義頁' ),
	'DoubleRedirects'           => array( '雙重重定向頁面' ),
	'EditWatchlist'             => array( '編輯監視列表' ),
	'Emailuser'                 => array( '電郵用戶' ),
	'Export'                    => array( '導出頁面' ),
	'Fewestrevisions'           => array( '最少修訂頁面' ),
	'FileDuplicateSearch'       => array( '搜索重複文件' ),
	'Filepath'                  => array( '文件路徑' ),
	'Import'                    => array( '導入頁面' ),
	'Invalidateemail'           => array( '不可識別的電郵地址' ),
	'BlockList'                 => array( '封禁列表' ),
	'LinkSearch'                => array( '搜索網頁鏈接' ),
	'Listadmins'                => array( '管理員列表' ),
	'Listbots'                  => array( '機器人列表' ),
	'Listfiles'                 => array( '文件列表' ),
	'Listgrouprights'           => array( '群組權限' ),
	'Listredirects'             => array( '重定向頁面列表' ),
	'Listusers'                 => array( '用戶列表' ),
	'Lockdb'                    => array( '鎖定數據庫' ),
	'Log'                       => array( '日誌' ),
	'Lonelypages'               => array( '孤立頁面' ),
	'Longpages'                 => array( '長頁面' ),
	'MergeHistory'              => array( '合併歷史' ),
	'MIMEsearch'                => array( 'MIME搜索' ),
	'Mostcategories'            => array( '最多分類頁面' ),
	'Mostimages'                => array( '最多鏈接文件' ),
	'Mostlinked'                => array( '最多鏈接頁面' ),
	'Mostlinkedcategories'      => array( '最多鏈接分類' ),
	'Mostlinkedtemplates'       => array( '最多鏈接模板' ),
	'Mostrevisions'             => array( '最多修訂頁面' ),
	'Movepage'                  => array( '移動頁面' ),
	'Mycontributions'           => array( '我的貢獻' ),
	'Mypage'                    => array( '我的用戶頁' ),
	'Mytalk'                    => array( '我的討論頁' ),
	'Myuploads'                 => array( '我的上傳' ),
	'Newimages'                 => array( '新建文件' ),
	'Newpages'                  => array( '新頁面' ),
	'PasswordReset'             => array( '重設密碼' ),
	'PermanentLink'             => array( '永久連結' ),
	'Popularpages'              => array( '熱點頁面' ),
	'Preferences'               => array( '參數設置' ),
	'Prefixindex'               => array( '前綴索引' ),
	'Protectedpages'            => array( '已保護頁面' ),
	'Protectedtitles'           => array( '已保護標題' ),
	'Randompage'                => array( '隨機頁面' ),
	'Randomredirect'            => array( '隨機重定向頁面' ),
	'Recentchanges'             => array( '最近更改' ),
	'Recentchangeslinked'       => array( '鏈出更改' ),
	'Revisiondelete'            => array( '刪除或恢復版本' ),
	'RevisionMove'              => array( '版本移動' ),
	'Search'                    => array( '搜索' ),
	'Shortpages'                => array( '短頁面' ),
	'Specialpages'              => array( '特殊頁面' ),
	'Statistics'                => array( '統計信息' ),
	'Tags'                      => array( '標籤' ),
	'Unblock'                   => array( '解除封禁' ),
	'Uncategorizedcategories'   => array( '未歸類分類' ),
	'Uncategorizedimages'       => array( '未歸類文件' ),
	'Uncategorizedpages'        => array( '未歸類頁面' ),
	'Uncategorizedtemplates'    => array( '未歸類模板' ),
	'Undelete'                  => array( '恢復被刪頁面' ),
	'Unlockdb'                  => array( '解除數據庫鎖定' ),
	'Unusedcategories'          => array( '未使用分類' ),
	'Unusedimages'              => array( '未使用文件' ),
	'Unusedtemplates'           => array( '未使用模板' ),
	'Unwatchedpages'            => array( '未被監視的頁面' ),
	'Upload'                    => array( '上傳文件' ),
	'UploadStash'               => array( '上傳藏匿' ),
	'Userlogin'                 => array( '用戶登錄' ),
	'Userlogout'                => array( '用戶登出' ),
	'Userrights'                => array( '用戶權限' ),
	'Version'                   => array( '版本信息' ),
	'Wantedcategories'          => array( '待撰分類' ),
	'Wantedfiles'               => array( '需要的文件' ),
	'Wantedpages'               => array( '待撰頁面' ),
	'Wantedtemplates'           => array( '需要的模板' ),
	'Watchlist'                 => array( '監視列表' ),
	'Whatlinkshere'             => array( '鏈入頁面' ),
	'Withoutinterwiki'          => array( '沒有跨語言鏈接的頁面' ),
);

$bookstoreList = array(
	'博客來書店' => 'http://www.books.com.tw/exep/prod/booksfile.php?item=$1',
	'三民書店' => 'http://www.sanmin.com.tw/page-qsearch.asp?ct=search_isbn&qu=$1',
	'天下書店' => 'http://www.cwbook.com.tw/search/result1.jsp?field=2&keyWord=$1',
	'新絲路書店' => 'http://www.silkbook.com/function/Search_list_book_data.asp?item=5&text=$1'
);

