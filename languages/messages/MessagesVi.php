<?php
/** Vietnamese (Tiếng Việt)
 *
 * See MessagesQqq.php for message documentation incl. usage of parameters
 * To improve a translation please visit http://translatewiki.net
 *
 * @ingroup Language
 * @file
 *
 * @author Apple
 * @author Arisa
 * @author DHN
 * @author Kaganer
 * @author Minh Nguyen
 * @author Mxn
 * @author Neoneurone
 * @author Nguyễn Thanh Quang
 * @author Thaisk
 * @author Thanhtai2009
 * @author Tmct
 * @author Trần Nguyễn Minh Huy
 * @author Trần Thế Trung
 * @author Tttrung
 * @author Vietbio
 * @author Vinhtantran
 * @author Vương Ngân Hà
 * @author לערי ריינהארט
 */

$namespaceNames = array(
	NS_MEDIA            => 'Phương_tiện',
	NS_SPECIAL          => 'Đặc_biệt',
	NS_TALK             => 'Thảo_luận',
	NS_USER             => 'Thành_viên',
	NS_USER_TALK        => 'Thảo_luận_Thành_viên',
	NS_PROJECT_TALK     => 'Thảo_luận_$1',
	NS_FILE             => 'Tập_tin',
	NS_FILE_TALK        => 'Thảo_luận_Tập_tin',
	NS_MEDIAWIKI        => 'MediaWiki',
	NS_MEDIAWIKI_TALK   => 'Thảo_luận_MediaWiki',
	NS_TEMPLATE         => 'Bản_mẫu',
	NS_TEMPLATE_TALK    => 'Thảo_luận_Bản_mẫu',
	NS_HELP             => 'Trợ_giúp',
	NS_HELP_TALK        => 'Thảo_luận_Trợ_giúp',
	NS_CATEGORY         => 'Thể_loại',
	NS_CATEGORY_TALK    => 'Thảo_luận_Thể_loại',
);

$namespaceAliases = array(
	'Hình' => NS_FILE,
	'Thảo_luận_Hình' => NS_FILE_TALK,
	'Tiêu_bản' => NS_TEMPLATE,
	'Thảo_luận_Tiêu_bản' => NS_TEMPLATE_TALK,
);

$specialPageAliases = array(
	'Activeusers'               => array( 'Người_dùng_tích_cực' ),
	'Allmessages'               => array( 'Mọi_thông_báo' ),
	'Allpages'                  => array( 'Mọi_bài' ),
	'Ancientpages'              => array( 'Trang_cũ' ),
	'Blankpage'                 => array( 'Trang_trắng' ),
	'Block'                     => array( 'Cấm_IP' ),
	'Blockme'                   => array( 'Khóa_tôi', 'Khoá_tôi' ),
	'Booksources'               => array( 'Nguồn_sách' ),
	'BrokenRedirects'           => array( 'Đổi_hướng_sai' ),
	'Categories'                => array( 'Thể_loại' ),
	// begin wikia change
	// VOLDEV-94
	'ChangeEmail'				=> array( 'Đổi_thư_điện_tử' ),
	// end wikia change
	'ChangePassword'            => array( 'Đổi_mật_khẩu' ),
	'ComparePages'              => array( 'So_sánh_trang' ),
	'Confirmemail'              => array( 'Xác_nhận_thư' ),
	'Contributions'             => array( 'Đóng_góp' ),
	'CreateAccount'             => array( 'Đăng_ký', 'Đăng_kí' ),
	'Deadendpages'              => array( 'Trang_đường_cùng' ),
	'DeletedContributions'      => array( 'Đóng_góp_bị_xóa', 'Đóng_góp_bị_xoá' ),
	'Disambiguations'           => array( 'Trang_định_hướng' ),
	'DoubleRedirects'           => array( 'Đổi_hướng_kép' ),
	'EditWatchlist'             => array( 'Sửa_danh_sách_theo_dõi' ),
	'Emailuser'                 => array( 'Gửi_thư', 'Gửi_thư_điện_tử' ),
	'Export'                    => array( 'Xuất' ),
	'Fewestrevisions'           => array( 'Ít_phiên_bản_nhất' ),
	'FileDuplicateSearch'       => array( 'Tìm_tập_tin_trùng' ),
	'Filepath'                  => array( 'Đường_dẫn_tập_tin', 'Đường_dẫn_file' ),
	'Import'                    => array( 'Nhập' ),
	'Invalidateemail'           => array( 'Hủy_thư', 'Hủy_thư_điện_tử', 'Huỷ_thư', 'Huỷ_thư_điện_tử', 'Tắt_thư' ),
	'BlockList'                 => array( 'Danh_sách_cấm' ),
	'LinkSearch'                => array( 'Tìm_liên_kết' ),
	'Listadmins'                => array( 'Danh_sách_bảo_quản_viên', 'Danh_sách_admin' ),
	'Listbots'                  => array( 'Danh_sách_bot', 'Danh_sách_robot' ),
	'Listfiles'                 => array( 'Danh_sách_hình', 'Danh_sách_tập_tin' ),
	'Listgrouprights'           => array( 'Quyền_nhóm_người_dùng' ),
	'Listredirects'             => array( 'Trang_đổi_hướng' ),
	'Listusers'                 => array( 'Danh_sách_thành_viên' ),
	'Lockdb'                    => array( 'Khóa_CSDL', 'Khóa_cơ_sở_dữ_liệu', 'Khoá_CSDL', 'Khoá_cơ_sở_dữ_liệu' ),
	'Log'                       => array( 'Nhật_trình' ),
	'Lonelypages'               => array( 'Trang_mồ_côi' ),
	'Longpages'                 => array( 'Trang_dài' ),
	'MergeHistory'              => array( 'Trộn_lịch_sử' ),
	'MIMEsearch'                => array( 'Tìm_MIME' ),
	'Mostcategories'            => array( 'Thể_loại_lớn_nhất' ),
	'Mostimages'                => array( 'Tập_tin_liên_kết_nhiều_nhất' ),
	'Mostlinked'                => array( 'Liên_kết_nhiều_nhất' ),
	'Mostlinkedcategories'      => array( 'Thể_loại_liên_kết_nhiều_nhất' ),
	'Mostlinkedtemplates'       => array( 'Bản_mẫu_liên_kết_nhiều_nhất', 'Tiêu_bản_liên_kết_nhiều_nhất' ),
	'Mostrevisions'             => array( 'Nhiều_phiên_bản_nhất' ),
	'Movepage'                  => array( 'Di_chuyển', 'Đổi_tên_trang' ),
	'Mycontributions'           => array( 'Đóng_góp_của_tôi', 'Tôi_đóng_góp' ),
	'Mypage'                    => array( 'Trang_tôi', 'Trang_cá_nhân' ),
	'Mytalk'                    => array( 'Thảo_luận_tôi', 'Trang_thảo_luận_của_tôi' ),
	'Myuploads'                 => array( 'Tập_tin_tôi' ),
	'Newimages'                 => array( 'Tập_tin_mới', 'Hình_mới' ),
	'Newpages'                  => array( 'Trang_mới' ),
	'PasswordReset'             => array( 'Tái_tạo_mật_khẩu', 'Đặt_lại_mật_khẩu' ),
	'PermanentLink'             => array( 'Liên_kết_thường_trực' ),
	'Popularpages'              => array( 'Trang_phổ_biến' ),
	'Preferences'               => array( 'Tùy_chọn', 'Tuỳ_chọn' ),
	'Prefixindex'               => array( 'Tiền_tố' ),
	'Protectedpages'            => array( 'Trang_khóa' ),
	'Protectedtitles'           => array( 'Tựa_đề_bị_khóa' ),
	'Randompage'                => array( 'Ngẫu_nhiên' ),
	'Randomredirect'            => array( 'Đổi_hướng_ngẫu_nhiên' ),
	'Recentchanges'             => array( 'Thay_đổi_gần_đây' ),
	'Recentchangeslinked'       => array( 'Thay_đổi_liên_quan' ),
	'Revisiondelete'            => array( 'Xóa_phiên_bản' ),
	'RevisionMove'              => array( 'Di_chuyển_phiên_bản' ),
	'Search'                    => array( 'Tìm_kiếm' ),
	'Shortpages'                => array( 'Trang_ngắn' ),
	'Specialpages'              => array( 'Trang_đặc_biệt' ),
	'Statistics'                => array( 'Thống_kê' ),
	'Tags'                      => array( 'Thẻ' ),
	'Unblock'                   => array( 'Bỏ_cấm' ),
	'Uncategorizedcategories'   => array( 'Thể_loại_chưa_phân_loại' ),
	'Uncategorizedimages'       => array( 'Tập_tin_chưa_phân_loại', 'Hình_chưa_phân_loại' ),
	'Uncategorizedpages'        => array( 'Trang_chưa_phân_loại' ),
	'Uncategorizedtemplates'    => array( 'Bản_mẫu_chưa_phân_loại', 'Tiêu_bản_chưa_phân_loại' ),
	'Undelete'                  => array( 'Phục_hồi' ),
	'Unlockdb'                  => array( 'Mở_khóa_CSDL', 'Mở_khóa_cơ_sở_dữ_liệu', 'Mở_khoá_CSDL', 'Mở_khoá_cơ_sở_dữ_liệu' ),
	'Unusedcategories'          => array( 'Thể_loại_chưa_dùng' ),
	'Unusedimages'              => array( 'Tập_tin_chưa_dùng', 'Hình_chưa_dùng' ),
	'Unusedtemplates'           => array( 'Bản_mẫu_chưa_dùng', 'Tiêu_bản_chưa_dùng' ),
	'Unwatchedpages'            => array( 'Trang_chưa_theo_dõi' ),
	'Upload'                    => array( 'Tải_lên' ),
	'UploadStash'               => array( 'Hàng_đợi_tải_lên' ),
	'Userlogin'                 => array( 'Đăng_nhập' ),
	'Userlogout'                => array( 'Đăng_xuất' ),
	'Userrights'                => array( 'Quyền_thành_viên' ),
	'Version'                   => array( 'Phiên_bản' ),
	'Wantedcategories'          => array( 'Thể_loại_cần_thiết' ),
	'Wantedfiles'               => array( 'Tập_tin_cần_thiết' ),
	'Wantedpages'               => array( 'Trang_cần_thiết' ),
	'Wantedtemplates'           => array( 'Bản_mẫu_cần_thiết', 'Tiêu_bản_cần_thiết' ),
	'Watchlist'                 => array( 'Danh_sách_theo_dõi' ),
	'Whatlinkshere'             => array( 'Liên_kết_đến_đây' ),
	'Withoutinterwiki'          => array( 'Không_liên_wiki', 'Không_interwiki' ),
);

$magicWords = array(
	'redirect'                => array( '0', '#đổi', '#REDIRECT' ),
	'notoc'                   => array( '0', '__KHÔNGMỤCMỤC__', '__NOTOC__' ),
	'nogallery'               => array( '0', '__KHÔNGALBUM__', '__NOGALLERY__' ),
	'forcetoc'                => array( '0', '__LUÔNMỤCLỤC__', '__FORCETOC__' ),
	'toc'                     => array( '0', '__MỤCLỤC__', '__TOC__' ),
	'noeditsection'           => array( '0', '__KHÔNGSỬAMỤC__', '__NOEDITSECTION__' ),
	'currentmonth'            => array( '1', 'THÁNGNÀY', 'THÁNGNÀY2', 'CURRENTMONTH', 'CURRENTMONTH2' ),
	'currentmonth1'           => array( '1', 'THÁNGNÀY1', 'CURRENTMONTH1' ),
	'currentmonthname'        => array( '1', 'TÊNTHÁNGNÀY', 'CURRENTMONTHNAME' ),
	'currentmonthnamegen'     => array( '1', 'TÊNDÀITHÁNGNÀY', 'CURRENTMONTHNAMEGEN' ),
	'currentmonthabbrev'      => array( '1', 'TÊNNGẮNTHÁNGNÀY', 'CURRENTMONTHABBREV' ),
	'currentday'              => array( '1', 'NGÀYNÀY', 'CURRENTDAY' ),
	'currentday2'             => array( '1', 'NGÀYNÀY2', 'CURRENTDAY2' ),
	'currentdayname'          => array( '1', 'TÊNNGÀYNÀY', 'CURRENTDAYNAME' ),
	'currentyear'             => array( '1', 'NĂMNÀY', 'CURRENTYEAR' ),
	'currenttime'             => array( '1', 'GIỜNÀY', 'CURRENTTIME' ),
	'localmonth'              => array( '1', 'THÁNGĐỊAPHƯƠNG', 'LOCALMONTH', 'LOCALMONTH2' ),
	'localmonth1'             => array( '1', 'THÁNGĐỊAPHƯƠNG1', 'LOCALMONTH1' ),
	'localmonthname'          => array( '1', 'TÊNTHÁNGĐỊAPHƯƠNG', 'LOCALMONTHNAME' ),
	'localmonthabbrev'        => array( '1', 'THÁNGĐỊAPHƯƠNGTẮT', 'LOCALMONTHABBREV' ),
	'localday'                => array( '1', 'NGÀYĐỊAPHƯƠNG', 'LOCALDAY' ),
	'localday2'               => array( '1', 'NGÀYĐỊAPHƯƠNG2', 'LOCALDAY2' ),
	'localdayname'            => array( '1', 'TÊNNGÀYĐỊAPHƯƠNG', 'LOCALDAYNAME' ),
	'localyear'               => array( '1', 'NĂMĐỊAPHƯƠNG', 'LOCALYEAR' ),
	'localtime'               => array( '1', 'GIỜĐỊAPHƯƠNG', 'LOCALTIME' ),
	'numberofpages'           => array( '1', 'SỐTRANG', 'NUMBEROFPAGES' ),
	'numberofarticles'        => array( '1', 'SỐBÀI', 'NUMBEROFARTICLES' ),
	'numberoffiles'           => array( '1', 'SỐTẬPTIN', 'NUMBEROFFILES' ),
	'numberofusers'           => array( '1', 'SỐTHÀNHVIÊN', 'NUMBEROFUSERS' ),
	'numberofactiveusers'     => array( '1', 'SỐTHÀNHVIÊNTÍCHCỰC', 'NUMBEROFACTIVEUSERS' ),
	'numberofedits'           => array( '1', 'SỐSỬAĐỔI', 'NUMBEROFEDITS' ),
	'numberofviews'           => array( '1', 'SỐLẦNXEM', 'NUMBEROFVIEWS' ),
	'pagename'                => array( '1', 'TÊNTRANG', 'PAGENAME' ),
	'pagenamee'               => array( '1', 'TÊNTRANG2', 'PAGENAMEE' ),
	'namespace'               => array( '1', 'KHÔNGGIANTÊN', 'NAMESPACE' ),
	'talkspace'               => array( '1', 'KGTTHẢOLUẬN', 'TALKSPACE' ),
	'subjectspace'            => array( '1', 'KGTNỘIDUNG', 'SUBJECTSPACE', 'ARTICLESPACE' ),
	'fullpagename'            => array( '1', 'TÊNTRANGĐỦ', 'FULLPAGENAME' ),
	'subpagename'             => array( '1', 'TÊNTRANGPHỤ', 'SUBPAGENAME' ),
	'basepagename'            => array( '1', 'TÊNTRANGGỐC', 'BASEPAGENAME' ),
	'talkpagename'            => array( '1', 'TÊNTRANGTHẢOLUẬN', 'TALKPAGENAME' ),
	'subjectpagename'         => array( '1', 'TÊNTRANGNỘIDUNG', 'SUBJECTPAGENAME', 'ARTICLEPAGENAME' ),
	'msg'                     => array( '0', 'NHẮN:', 'MSG:' ),
	'subst'                   => array( '0', 'THẾ:', 'SUBST:' ),
	'msgnw'                   => array( '0', 'NHẮNMỚI:', 'MSGNW:' ),
	'img_thumbnail'           => array( '1', 'nhỏ', 'thumbnail', 'thumb' ),
	'img_manualthumb'         => array( '1', 'nhỏ=$1', 'thumbnail=$1', 'thumb=$1' ),
	'img_right'               => array( '1', 'phải', 'right' ),
	'img_left'                => array( '1', 'trái', 'left' ),
	'img_none'                => array( '1', 'không', 'none' ),
	'img_center'              => array( '1', 'giữa', 'center', 'centre' ),
	'img_framed'              => array( '1', 'khung', 'framed', 'enframed', 'frame' ),
	'img_page'                => array( '1', 'trang=$1', 'trang $1', 'page=$1', 'page $1' ),
	'img_upright'             => array( '1', 'đứng', 'đứng=$1', 'đứng $1', 'upright', 'upright=$1', 'upright $1' ),
	'img_link'                => array( '1', 'liên_kết=$1', 'link=$1' ),
	'int'                     => array( '0', 'NỘI:', 'INT:' ),
	'sitename'                => array( '1', 'TÊNMẠNG', 'SITENAME' ),
	'ns'                      => array( '0', 'KGT:', 'NS:' ),
	'localurl'                => array( '0', 'URLĐỊAPHƯƠNG:', 'LOCALURL:' ),
	'articlepath'             => array( '0', 'LỐIBÀI', 'ARTICLEPATH' ),
	'server'                  => array( '0', 'MÁYCHỦ', 'SERVER' ),
	'servername'              => array( '0', 'TÊNMÁYCHỦ', 'SERVERNAME' ),
	'scriptpath'              => array( '0', 'ĐƯỜNGDẪNSCRIPT', 'SCRIPTPATH' ),
	'grammar'                 => array( '0', 'NGỮPHÁP:', 'GRAMMAR:' ),
	'gender'                  => array( '0', 'GIỐNG:', 'GENDER:' ),
	'notitleconvert'          => array( '0', '__KHÔNGCHUYỂNTÊN__', '__NOTITLECONVERT__', '__NOTC__' ),
	'nocontentconvert'        => array( '0', '__KHÔNGCHUYỂNNỘIDUNG__', '__NOCONTENTCONVERT__', '__NOCC__' ),
	'currentweek'             => array( '1', 'TUẦNNÀY', 'CURRENTWEEK' ),
	'localweek'               => array( '1', 'TUẦNĐỊAPHƯƠNG', 'LOCALWEEK' ),
	'revisionid'              => array( '1', 'SỐBẢN', 'REVISIONID' ),
	'revisionday'             => array( '1', 'NGÀYBẢN', 'REVISIONDAY' ),
	'revisionday2'            => array( '1', 'NGÀYBẢN2', 'REVISIONDAY2' ),
	'revisionmonth'           => array( '1', 'THÁNGBẢN', 'REVISIONMONTH' ),
	'revisionmonth1'          => array( '1', 'THÁNGBẢN1', 'REVISIONMONTH1' ),
	'revisionyear'            => array( '1', 'NĂMBẢN', 'REVISIONYEAR' ),
	'plural'                  => array( '0', 'SỐNHIỀU:', 'PLURAL:' ),
	'fullurl'                 => array( '0', 'URLĐỦ:', 'FULLURL:' ),
	'newsectionlink'          => array( '1', '__LIÊNKẾTMỤCMỚI__', '__NEWSECTIONLINK__' ),
	'nonewsectionlink'        => array( '1', '__KHÔNGLIÊNKẾTMỤCMỚI__', '__NONEWSECTIONLINK__' ),
	'currentversion'          => array( '1', 'BẢNNÀY', 'CURRENTVERSION' ),
	'urlencode'               => array( '0', 'MÃHÓAURL:', 'URLENCODE:' ),
	'language'                => array( '0', '#NGÔNNGỮ:', '#LANGUAGE:' ),
	'contentlanguage'         => array( '1', 'NGÔNNGỮNỘIDUNG', 'CONTENTLANGUAGE', 'CONTENTLANG' ),
	'pagesinnamespace'        => array( '1', 'CỠKHÔNGGIANTÊN:', 'CỠKGT:', 'PAGESINNAMESPACE:', 'PAGESINNS:' ),
	'numberofadmins'          => array( '1', 'SỐQUẢNLÝ', 'NUMBEROFADMINS' ),
	'formatnum'               => array( '0', 'PHÂNCHIASỐ', 'FORMATNUM' ),
	'defaultsort'             => array( '1', 'XẾPMẶCĐỊNH:', 'DEFAULTSORT:', 'DEFAULTSORTKEY:', 'DEFAULTCATEGORYSORT:' ),
	'filepath'                => array( '0', 'ĐƯỜNGDẪNTẬPTIN', 'FILEPATH:' ),
	'tag'                     => array( '0', 'thẻ', 'tag' ),
	'hiddencat'               => array( '1', '__THỂLOẠIẨN__', '__HIDDENCAT__' ),
	'pagesincategory'         => array( '1', 'CỠTHỂLOẠI', 'PAGESINCATEGORY', 'PAGESINCAT' ),
	'pagesize'                => array( '1', 'CỠTRANG', 'PAGESIZE' ),
	'numberingroup'           => array( '1', 'CỠNHÓM', 'NUMBERINGROUP', 'NUMINGROUP' ),
	'staticredirect'          => array( '1', '__ĐỔIHƯỚNGNHẤTĐỊNH__', '__STATICREDIRECT__' ),
);

$datePreferences = array(
	'default',
	'vi normal',
	'vi spelloutmonth',
	'vi shortcolon',
	'vi shorth',
	'ISO 8601',
);

$defaultDateFormat = 'vi normal';

$dateFormats = array(
	'vi normal time' => 'H:i',
	'vi normal date' => '"ngày" j "tháng" n "năm" Y',
	'vi normal both' => 'H:i, "ngày" j "tháng" n "năm" Y',

	'vi spelloutmonth time' => 'H:i',
	'vi spelloutmonth date' => '"ngày" j xg "năm" Y',
	'vi spelloutmonth both' => 'H:i, "ngày" j xg "năm" Y',

	'vi shortcolon time' => 'H:i',
	'vi shortcolon date' => 'j/n/Y',
	'vi shortcolon both' => 'H:i, j/n/Y',

	'vi shorth time' => 'H"h"i',
	'vi shorth date' => 'j/n/Y',
	'vi shorth both' => 'H"h"i, j/n/Y',
);

$datePreferenceMigrationMap = array(
	'default',
	'vi normal',
	'vi normal',
	'vi normal',
);


$linkTrail = "/^([a-zàâçéèêîôûäëïöüùÇÉÂÊÎÔÛÄËÏÖÜÀÈÙ]+)(.*)$/sDu";
$separatorTransformTable = array( ',' => '.', '.' => ',' );

