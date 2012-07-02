<?php
/**
 * Internationalisation file for extension WebStore.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'inplace_access_disabled'          => 'Access to this service has been disabled for all clients.',
	'inplace_access_denied'            => 'This service is restricted by client IP.',
	'inplace_scaler_no_temp'           => 'No valid temporary directory.
Set $wgLocalTmpDirectory to a writeable directory.',
	'inplace_scaler_not_enough_params' => 'Not enough parameters.',
	'inplace_scaler_invalid_image'     => 'Invalid image, could not determine size.',
	'inplace_scaler_failed'            => 'An error was encountered during image scaling: $1',
	'inplace_scaler_no_handler'        => 'No handler for transforming this MIME type',
	'inplace_scaler_no_output'         => 'No transformation output file was produced.',
	'inplace_scaler_zero_size'         => 'Transformation produced a zero-sized output file.',

	'webstore-desc'          => 'Web-only (non-NFS) file storage middleware',
	'webstore_access'        => 'This service is restricted by client IP.',
	'webstore_path_invalid'  => 'The filename was invalid.',
	'webstore_dest_open'     => 'Unable to open destination file "$1".',
	'webstore_dest_lock'     => 'Failed to get lock on destination file "$1".',
	'webstore_dest_mkdir'    => 'Unable to create destination directory "$1".',
	'webstore_archive_lock'  => 'Failed to get lock on archive file "$1".',
	'webstore_archive_mkdir' => 'Unable to create archive directory "$1".',
	'webstore_src_open'      => 'Unable to open source file "$1".',
	'webstore_src_close'     => 'Error closing source file "$1".',
	'webstore_src_delete'    => 'Error deleting source file "$1".',

	'webstore_rename'      => 'Error renaming file "$1" to "$2".',
	'webstore_lock_open'   => 'Error opening lock file "$1".',
	'webstore_lock_close'  => 'Error closing lock file "$1".',
	'webstore_dest_exists' => 'Error, destination file "$1" exists.',
	'webstore_temp_open'   => 'Error opening temporary file "$1".',
	'webstore_temp_copy'   => 'Error copying temporary file "$1" to destination file "$2".',
	'webstore_temp_close'  => 'Error closing temporary file "$1".',
	'webstore_temp_lock'   => 'Error locking temporary file "$1".',
	'webstore_no_archive'  => 'Destination file exists and no archive was given.',

	'webstore_no_file'       => 'No file was uploaded.',
	'webstore_move_uploaded' => 'Error moving uploaded file "$1" to temporary location "$2".',

	'webstore_invalid_zone' => 'Invalid zone "$1".',

	'webstore_no_deleted'            => 'No archive directory for deleted files is defined.',
	'webstore_curl'                  => 'Error from cURL: $1',
	'webstore_404'                   => 'File not found.',
	'webstore_php_warning'           => 'PHP Warning: $1',
	'webstore_metadata_not_found'    => 'File not found: $1',
	'webstore_postfile_not_found'    => 'File to post not found.',
	'webstore_scaler_empty_response' => 'The image scaler gave an empty response with a 200 response code.
This could be due to a PHP fatal error in the scaler.',

	'webstore_invalid_response' => "Invalid response from server:

$1",
	'webstore_no_response'      => 'No response from server',
	'webstore_backend_error'    => "Error from storage server:

$1",
	'webstore_php_error'        => 'PHP errors were encountered:',
	'webstore_no_handler'       => 'No handler for transforming this MIME type',
);

/** Message documentation (Message documentation)
 * @author Jon Harald Søby
 * @author Purodha
 * @author Siebrand
 * @author The Evil IP address
 */
$messages['qqq'] = array(
	'webstore-desc' => '{{desc}}',
	'webstore_404' => '{{Identical|File not found}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 * @author SPQRobin
 */
$messages['af'] = array(
	'inplace_scaler_not_enough_params' => 'Nie genoeg parameters nie.',
	'webstore_path_invalid' => 'Die lêernaam was ongeldig.',
	'webstore_src_open' => 'Kon nie die bronlêer "$1" oopmaak nie.',
	'webstore_no_file' => 'Geen lêer was opgelaai nie.',
	'webstore_invalid_zone' => 'Ongeldige sone "$1".',
	'webstore_curl' => 'Fout vanaf Curl: $1',
	'webstore_404' => 'Lêer nie gevind nie.',
	'webstore_php_warning' => 'PHP-waarskuwing: $1',
	'webstore_metadata_not_found' => 'Lêer is nie gevind nie: $1',
	'webstore_no_response' => 'Geen antwoord van die bediener',
	'webstore_php_error' => 'PHP-foute het voorgekom:',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'inplace_access_disabled' => 'Qasja në këtë shërbim ka qenë i paaftë për të gjithë klientët.',
	'inplace_access_denied' => 'Ky shërbim është i kufizuar nga klienti IP.',
	'inplace_scaler_no_temp' => 'Nuk ka të përkohshme Lista e vlefshme. Vendosur $wgLocalTmpDirectory në një directory writeable.',
	'inplace_scaler_not_enough_params' => 'Nuk parametrave të mjaftueshme.',
	'inplace_scaler_invalid_image' => 'imazhin e pavlefshme, nuk mund të përcaktojë madhësinë.',
	'inplace_scaler_failed' => 'Një gabim është hasur gjatë shkallë imazh: $1',
	'inplace_scaler_no_handler' => 'Nuk ka mbajtës për transformimin e këtij lloji MIME',
	'inplace_scaler_no_output' => 'Nuk ka dalje të transformimit file u prodhua.',
	'inplace_scaler_zero_size' => 'Transformimi prodhuar një fotografi zero-sized prodhimit.',
	'webstore-desc' => 'Web-vetëm (jo-NFS) file middleware magazinimit',
	'webstore_access' => 'Ky shërbim është i kufizuar nga klienti IP.',
	'webstore_path_invalid' => 'Emri i file të ishte i pavlefshëm.',
	'webstore_dest_open' => 'E pamundur hapja e file destinacion "$1".',
	'webstore_dest_lock' => 'E pamundur për të marrë bllokohet në destinacionin e skedës "$1".',
	'webstore_dest_mkdir' => 'Në pamundësi për të krijuar destinacion directory "$1".',
	'webstore_archive_lock' => 'E pamundur për të marrë bllokohet në arkivin e skedës "$1".',
	'webstore_archive_mkdir' => 'Në pamundësi për të krijuar arkivin directory "$1".',
	'webstore_src_open' => 'Në pamundësi për të hapur burimin e skedës "$1".',
	'webstore_src_close' => 'burim Gabim mbylljen e skedës "$1".',
	'webstore_src_delete' => 'Gabim gjatë fshirjes burim skedës "$1".',
	'webstore_rename' => 'Gabim riemërimin e skedës "$1" tek "$2.',
	'webstore_lock_open' => 'bllokoj Gabim gjatë hapjes së file "$1".',
	'webstore_lock_close' => 'bllokoj Gabim mbylljes skedës "$1".',
	'webstore_dest_exists' => 'Gabim, destinacionin file "$1" ekziston.',
	'webstore_temp_open' => 'Gabim gjatë hapjes së file të përkohshëm "$1".',
	'webstore_temp_copy' => 'Gabim gjatë kopjimit të file të përkohshëm "$1" në destinacionin file "$2".',
	'webstore_temp_close' => 'Gabim gjatë mbylljes së file të përkohshëm "$1".',
	'webstore_temp_lock' => 'Gabim mbyllje file të përkohshëm "$1".',
	'webstore_no_archive' => 'Skedari i destinacionit ekziston dhe nuk është dhënë arkivit.',
	'webstore_no_file' => 'Asnjë dokument nuk u ngarkuar së fundi.',
	'webstore_move_uploaded' => 'Gabim duke lëvizur kartelën e ngarkuar "$1" në një lokacion të përkohshëm "$2".',
	'webstore_invalid_zone' => 'Zona e pavlefshme "$1".',
	'webstore_no_deleted' => 'Nuk ka directory arkiv për fotografi fshihet është e definuar.',
	'webstore_curl' => 'Gabim nga rrotacioni: $1',
	'webstore_404' => 'File nuk u gjet.',
	'webstore_php_warning' => 'Kujdes PHP: $1',
	'webstore_metadata_not_found' => 'File nuk u gjet: $1',
	'webstore_postfile_not_found' => 'File nuk u gjet për të postuar.',
	'webstore_scaler_empty_response' => 'Scaler imazh i dha një përgjigje bosh me një përgjigje kodin 200. Kjo mund të jetë për shkak të një gabim fatal në PHP scaler.',
	'webstore_invalid_response' => 'Përgjigja e pavlefshme nga server: $1',
	'webstore_no_response' => 'Asnjë përgjigje nga serveri',
	'webstore_backend_error' => 'Gabim nga storage server: $1',
	'webstore_php_error' => 'gabime PHP ishin hasur:',
	'webstore_no_handler' => 'Nuk ka mbajtës për transformimin e këtij lloji MIME',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'webstore_path_invalid' => 'የፋይሉ ስም ልክ አልነበረም።',
	'webstore_404' => 'ፋይል አልተገኘም።',
	'webstore_metadata_not_found' => 'ፋይል አልተገኘም: $1',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'inplace_access_disabled' => 'الدخول إلى هذه الخدمة تم تعطيله لكل العملاء.',
	'inplace_access_denied' => 'هذه الخدمة مقيدة بواسطة أيبي عميل.',
	'inplace_scaler_no_temp' => 'لا مجلد مؤقت صحيح.
ضبط $wgLocalTmpDirectory لمجلد قابل للكتابة.',
	'inplace_scaler_not_enough_params' => 'لا محددات كافية.',
	'inplace_scaler_invalid_image' => 'صورة غير صحيحة، لم يمكن تحديد الحجم.',
	'inplace_scaler_failed' => 'حدث خطأ أثناء وزن الصورة: $1',
	'inplace_scaler_no_handler' => 'لا وسيلة لتحويل نوع MIME هذا',
	'inplace_scaler_no_output' => 'لا ملف تحويل خارج تم إنتاجه.',
	'inplace_scaler_zero_size' => 'التحويل أنتج ملف خروج حجمه صفر.',
	'webstore-desc' => 'وسيط تخزين للملفات على الويب فقط (ليس-NFS)',
	'webstore_access' => 'هذه الخدمة مقيدة بواسطة أيبي عميل.',
	'webstore_path_invalid' => 'اسم الملف كان غير صحيح.',
	'webstore_dest_open' => 'غير قادر على فتح الملف الهدف "$1".',
	'webstore_dest_lock' => 'فشل في الغلق على ملف الوجهة "$1".',
	'webstore_dest_mkdir' => 'غير قادر على إنشاء مجلد الوجهة "$1".',
	'webstore_archive_lock' => 'فشل في الغلق على ملف الأرشيف "$1".',
	'webstore_archive_mkdir' => 'غير قادر على إنشاء مجلد الأرشيف "$1".',
	'webstore_src_open' => 'غير قادر على فتح ملف المصدر "$1".',
	'webstore_src_close' => 'خطأ أثناء إغلاق ملف المصدر "$1".',
	'webstore_src_delete' => 'خطأ أثناء حذف ملف المصدر "$1".',
	'webstore_rename' => 'خطأ أثناء إعادة تسمية الملف "$1" إلى "$2".',
	'webstore_lock_open' => 'خطأ أثناء فتح غلق الملف "$1".',
	'webstore_lock_close' => 'خطأ أثناء إغلاق غلق الملف "$1".',
	'webstore_dest_exists' => 'خطأ، ملف الوجهة "$1" موجود.',
	'webstore_temp_open' => 'خطأ أثناء فتح الملف المؤقت "$1".',
	'webstore_temp_copy' => 'خطأ أثناء نسخ الملف المؤقت "$1" لملف الوجهة "$2".',
	'webstore_temp_close' => 'خطأ أثناء إغلاق الملف المؤقت "$1".',
	'webstore_temp_lock' => 'خطأ غلق الملف المؤقت "$1".',
	'webstore_no_archive' => 'ملف الوجهة موجود ولم يتم إعطاء أرشيف.',
	'webstore_no_file' => 'لم يتم رفع أي ملف.',
	'webstore_move_uploaded' => 'خطأ أثناء نقل الملف المرفوع "$1" إلى الموقع المؤقت "$2".',
	'webstore_invalid_zone' => 'منطقة غير صحيحة "$1".',
	'webstore_no_deleted' => 'لم يتم تعريف مجلد أرشيف للملفات المحذوفة.',
	'webstore_curl' => 'خطأ من cURL: $1',
	'webstore_404' => 'لم يتم إيجاد الملف.',
	'webstore_php_warning' => 'تحذير PHP: $1',
	'webstore_metadata_not_found' => 'الملف غير موجود: $1',
	'webstore_postfile_not_found' => 'الملف للإرسال غير موجود.',
	'webstore_scaler_empty_response' => 'وازن الصورة أعطى ردا فارغا مع 200 كود رد. هذا يمكن أن يكون نتيجة خطأ PHP قاتل في الوازن.',
	'webstore_invalid_response' => 'رد غير صحيح من الخادم:

$1',
	'webstore_no_response' => 'لا رد من الخادم',
	'webstore_backend_error' => 'خطأ من خادم التخزين:

$1',
	'webstore_php_error' => 'حدثت أخطاء PHP:',
	'webstore_no_handler' => 'لا وسيلة لتحويل نوع MIME هذا',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'inplace_access_disabled' => 'الدخول إلى هذه الخدمة تم تعطيله لكل العملاء.',
	'inplace_access_denied' => 'هذه الخدمة مقيدة بواسطة أيبى عميل.',
	'inplace_scaler_no_temp' => 'لا مجلد مؤقت صحيح.
ضبط $wgLocalTmpDirectory لمجلد قابل للكتابة.',
	'inplace_scaler_not_enough_params' => 'لا محددات كافية.',
	'inplace_scaler_invalid_image' => 'صورة غير صحيحة، لم يمكن تحديد الحجم.',
	'inplace_scaler_failed' => 'حدث خطأ أثناء وزن الصورة: $1',
	'inplace_scaler_no_handler' => 'لا وسيلة لتحويل نوع MIME هذا',
	'inplace_scaler_no_output' => 'لا ملف تحويل خارج تم إنتاجه.',
	'inplace_scaler_zero_size' => 'التحويل أنتج ملف خروج حجمه صفر.',
	'webstore-desc' => 'وسيط تخزين للملفات على الويب فقط (ليس-NFS)',
	'webstore_access' => 'هذه الخدمة مقيدة بواسطة أيبى عميل.',
	'webstore_path_invalid' => 'اسم الملف كان غير صحيح.',
	'webstore_dest_open' => 'غير قادر على فتح الملف الهدف "$1".',
	'webstore_dest_lock' => 'فشل فى الغلق على ملف الوجهة "$1".',
	'webstore_dest_mkdir' => 'غير قادر على إنشاء مجلد الوجهة "$1".',
	'webstore_archive_lock' => 'فشل فى الغلق على ملف الأرشيف "$1".',
	'webstore_archive_mkdir' => 'غير قادر على إنشاء مجلد الأرشيف "$1".',
	'webstore_src_open' => 'غير قادر على فتح ملف المصدر "$1".',
	'webstore_src_close' => 'خطأ أثناء إغلاق ملف المصدر "$1".',
	'webstore_src_delete' => 'خطأ أثناء حذف ملف المصدر "$1".',
	'webstore_rename' => 'خطأ أثناء إعادة تسمية الملف "$1" إلى "$2".',
	'webstore_lock_open' => 'خطأ أثناء فتح غلق الملف "$1".',
	'webstore_lock_close' => 'خطأ أثناء إغلاق غلق الملف "$1".',
	'webstore_dest_exists' => 'خطأ، ملف الوجهة "$1" موجود.',
	'webstore_temp_open' => 'خطأ أثناء فتح الملف المؤقت "$1".',
	'webstore_temp_copy' => 'خطأ أثناء نسخ الملف المؤقت "$1" لملف الوجهة "$2".',
	'webstore_temp_close' => 'خطأ أثناء إغلاق الملف المؤقت "$1".',
	'webstore_temp_lock' => 'خطأ غلق الملف المؤقت "$1".',
	'webstore_no_archive' => 'ملف الوجهة موجود ولم يتم إعطاء أرشيف.',
	'webstore_no_file' => 'لم يتم رفع أى ملف.',
	'webstore_move_uploaded' => 'خطأ أثناء نقل الملف المرفوع "$1" إلى الموقع المؤقت "$2".',
	'webstore_invalid_zone' => 'منطقة غير صحيحة "$1".',
	'webstore_no_deleted' => 'لم يتم تعريف مجلد أرشيف للملفات المحذوفة.',
	'webstore_curl' => 'خطأ من cURL: $1',
	'webstore_404' => 'لم يتم إيجاد الملف.',
	'webstore_php_warning' => 'تحذير PHP: $1',
	'webstore_metadata_not_found' => 'الملف غير موجود: $1',
	'webstore_postfile_not_found' => 'الملف للإرسال غير موجود.',
	'webstore_scaler_empty_response' => 'وازن الصورة أعطى ردا فارغا مع 200 كود رد. هذا يمكن أن يكون نتيجة خطأ PHP قاتل فى الوازن.',
	'webstore_invalid_response' => 'رد غير صحيح من الخادم:

$1',
	'webstore_no_response' => 'لا رد من الخادم',
	'webstore_backend_error' => 'خطأ من خادم التخزين:

$1',
	'webstore_php_error' => 'حدثت أخطاء PHP:',
	'webstore_no_handler' => 'لا وسيلة لتحويل نوع MIME هذا',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'webstore_no_response' => 'Mayong simbag hali sa server',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'inplace_access_disabled' => 'Доступ да гэтага сэрвісу быў адключаны для ўсіх кліентаў.',
	'inplace_access_denied' => 'Гэты сэрвіс быў абмежаваны праз ІР-адрас кліента.',
	'inplace_scaler_no_temp' => 'Часовая дырэкторыя не існуе.
Пазначце $wgLocalTmpDirectory для дырэкторыі даступнай для запісу.',
	'inplace_scaler_not_enough_params' => 'Недастаткова парамэтраў.',
	'inplace_scaler_invalid_image' => 'Няслушная выява, немагчыма вызначыць памер.',
	'inplace_scaler_failed' => 'Узьнікла памылка пад час маштабаваньня выявы: $1',
	'inplace_scaler_no_handler' => 'Няма апрацоўшчыка для пераўтварэньня гэтага MIME-тыпу',
	'inplace_scaler_no_output' => 'Мэтавы файл пераўтварэньня ня створаны .',
	'inplace_scaler_zero_size' => 'Пераўтварэньне стварыла файл з нулявым памерам.',
	'webstore-desc' => 'Праграмнае забесьпячэньне для захоўваньня файлаў у Інтэрнэт (NFS не ўжываецца)',
	'webstore_access' => 'Гэты сэрвіс забаронены для ІР-адрасу кліента.',
	'webstore_path_invalid' => 'Няслушная назва файла.',
	'webstore_dest_open' => 'Немагчыма адкрыць мэтавы файл «$1».',
	'webstore_dest_lock' => 'Немагчыма заблякаваць мэтавы файл «$1».',
	'webstore_dest_mkdir' => 'Немагчыма стварыць мэтавую дырэкторыю «$1».',
	'webstore_archive_lock' => 'Немагчыма заблякаваць архіўны файл «$1».',
	'webstore_archive_mkdir' => 'Немагчыма стварыць архіўную дырэкторыю «$1».',
	'webstore_src_open' => 'Немагчыма адкрыць крынічны файл «$1».',
	'webstore_src_close' => 'Памылка закрыцьця крынічнага файла «$1».',
	'webstore_src_delete' => 'Памылка выдаленьня крынічнага файла «$1».',
	'webstore_rename' => 'Памылка перайменаваньня файла «$1» у «$2».',
	'webstore_lock_open' => 'Памылка адкрыцьця файла блякаваньня «$1».',
	'webstore_lock_close' => 'Памылка закрыцьця файла блякаваньня «$1».',
	'webstore_dest_exists' => 'Памылка, мэтавы файл «$1» ужо існуе.',
	'webstore_temp_open' => 'Памылка адкрыцьця часовага файла «$1».',
	'webstore_temp_copy' => 'Памылка капіяваньня часовага файла «$1» у мэтавы файл «$2».',
	'webstore_temp_close' => 'Памылка закрыцьця часовага файла «$1».',
	'webstore_temp_lock' => 'Памылка блякаваньня часовага файла «$1».',
	'webstore_no_archive' => 'Мэтавы файл ужо існуе, архіў не пазначаны.',
	'webstore_no_file' => 'Ніякіх файлаў не загружана.',
	'webstore_move_uploaded' => 'Пад час перайменаваньня загружанага файла «$1» у часовую дырэкторыю «$2» узьнікла памылка.',
	'webstore_invalid_zone' => 'Няслушная зона «$1».',
	'webstore_no_deleted' => 'Не пазначана архіўная дырэкторыя для выдаленых файлаў.',
	'webstore_curl' => 'Памылка cURL: $1',
	'webstore_404' => 'Файл ня знойдзены.',
	'webstore_php_warning' => 'Папярэджаньне РНР: $1',
	'webstore_metadata_not_found' => 'Файл ня знойдзены: $1',
	'webstore_postfile_not_found' => 'Файл да апублікаваньня ня знойдзены.',
	'webstore_scaler_empty_response' => 'Пераўтваральнік маштабу выявы вярнуў пусты адказ з кодам памылкі 200.
Гэта магло адбыцца ў выніку крытычнай памылкі РНР у пераўтваральніку маштабу.',
	'webstore_invalid_response' => 'Памылковы адказ сэрвэра:

$1',
	'webstore_no_response' => 'Няма адказу сэрвэра.',
	'webstore_backend_error' => 'Сэрвэр, на якім захоўваюцца зьвесткі, вярнуў памылку:

$1',
	'webstore_php_error' => 'Узьніклі наступныя памылкі РНР:',
	'webstore_no_handler' => 'Ня знойдзены апрацоўшчык для пераўтварэньня гэтага тыпу MIME',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'inplace_access_disabled' => 'Достъпът до тази услуга е изключен за всички клиенти.',
	'inplace_access_denied' => 'Тази услуга е ограничена по клиентски IP адрес.',
	'inplace_scaler_no_temp' => 'Няма валидна временна директория.
Посочете в $wgLocalTmpDirectory директория с права за запис.',
	'inplace_scaler_not_enough_params' => 'Няма достатъчно параметри',
	'inplace_scaler_invalid_image' => 'Невалидна картинка, размерът й е невъзможно да бъде определен.',
	'inplace_scaler_failed' => 'Възникна грешка при скалирането на картинката: $1',
	'webstore_access' => 'Тази услуга е ограничена по клиентски IP адрес.',
	'webstore_path_invalid' => 'Името на файла е невалидно.',
	'webstore_dest_open' => 'Целевият файл „$1“ не може да бъде отворен.',
	'webstore_dest_mkdir' => 'Невъзможно е да бъде създадена целевата директория „$1“.',
	'webstore_archive_lock' => 'Неуспех при опит за заключване на архивния файл „$1“.',
	'webstore_archive_mkdir' => 'Невъзможно е да бъде създадена архивната директория „$1“.',
	'webstore_src_open' => 'Файлът-източник „$1“ не може да бъде отворен.',
	'webstore_src_close' => 'Грешка при затваряне на файла-източник „$1“.',
	'webstore_src_delete' => 'Грешка при изтриване на файла-източник „$1“.',
	'webstore_rename' => 'Грешка при преименуване на файла „$1“ като „$2“.',
	'webstore_lock_open' => 'Възникна грешка при отваряне на заключващия файл „$1“.',
	'webstore_lock_close' => 'Възникна грешка при затваряне на заключващия файл „$1“.',
	'webstore_dest_exists' => 'Грешка, целевият файл „$1“ съществува.',
	'webstore_temp_open' => 'Грешка при отваряне на временния файл „$1“.',
	'webstore_temp_copy' => 'Грешка при копиране на временния файл „$1“ като целеви файл „$2“.',
	'webstore_temp_close' => 'Грешка при затваряне на временния файл "$1".',
	'webstore_temp_lock' => 'Грешка при заключване на временния файл "$1".',
	'webstore_no_archive' => 'Целевият файл съществува и не е посочен архив.',
	'webstore_no_file' => 'Не беше качен файл.',
	'webstore_move_uploaded' => 'Грешка при преместване на качения файл „$1“ във временния склад „$2“.',
	'webstore_invalid_zone' => 'Невалидна зона "$1".',
	'webstore_no_deleted' => 'Не е указана архивна директория за изтритите файлове.',
	'webstore_curl' => 'Грешка от cURL: $1',
	'webstore_404' => 'Файлът не беше намерен.',
	'webstore_php_warning' => 'PHP Предупреждение: $1',
	'webstore_metadata_not_found' => 'Файлът не беше намерен: $1',
	'webstore_postfile_not_found' => 'Файлът за публикуване не беше открит.',
	'webstore_invalid_response' => 'Невалиден отговор от сървъра:

$1',
	'webstore_no_response' => 'Няма отговор от сървъра',
	'webstore_backend_error' => 'Грешка от складовия сървър:

$1',
	'webstore_php_error' => 'Възникнаха следните PHP грешки:',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Zaheen
 */
$messages['bn'] = array(
	'webstore_no_file' => 'কোন ফাইল আপলোড করা হয়নি।',
	'webstore_404' => 'ফাইল পাওয়া যায়নি।',
	'webstore_php_warning' => 'পিএইচপি সতর্কীকরণ: $1',
	'webstore_metadata_not_found' => 'ফাইল খুঁজে পাওয়া যায়নি: $1',
	'webstore_postfile_not_found' => 'পোস্ট করার জন্য ফাইল খুঁজে পাওয়া যায়নি।',
	'webstore_scaler_empty_response' => 'ছবি মাপবর্ধকটি ২০০নং উত্তর কোডসহ একটি খালি উত্তর পাঠিয়েছে। মাপবর্ধকে পিএইচপি অসমাধানযোগ্য ত্রুটির কারণে এটি হতে পারে।',
	'webstore_invalid_response' => 'সার্ভার থেকে অবৈধ উত্তর এসেছে:


$1',
	'webstore_no_response' => 'সার্ভার কোন উত্তর দিচ্ছে না',
	'webstore_backend_error' => 'স্টোরেজ সার্ভার থেকে প্রাপ্ত ত্রুটি:

$1',
	'webstore_php_error' => 'পিএইচপি ত্রুটি ঘটেছে:',
	'webstore_no_handler' => 'এই MIME ধরনটি রূপান্তরের জন্য কোন হ্যান্ডলার নেই',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'inplace_access_disabled' => "Diweredekaet eo ar moned d'ar servij-mañ evit an holl bratikoù.",
	'inplace_access_denied' => 'Bevennet eo ar servij-mañ diouzh IP ar pratik.',
	'inplace_scaler_no_temp' => 'N\'eus teul padennek reizh ebet, ret eo da $wgLocalTmpDirectory bezañ ennañ anv un teul gant gwirioù skrivañ.',
	'inplace_scaler_not_enough_params' => 'Diouer a arventennoù zo',
	'inplace_scaler_invalid_image' => 'Skeudenn direizh, dibosupl termeniñ ar vent.',
	'inplace_scaler_failed' => "C'hoarvezet ez eus ur fazi e-ser gwaskañ/diwaskañ ar skeudenn : $1",
	'inplace_scaler_no_handler' => "Arc'hwel ebet evit treuzfurmiñ ar furmad MIME-se",
	'inplace_scaler_no_output' => "N'eus bet krouet restr dreuzfurmiñ ebet.",
	'inplace_scaler_zero_size' => 'Krouet ez eus bet ur restr gant ur vent mann gant an treuzfumadur.',
	'webstore-desc' => 'Kreizant stokiñ restroù evit ar Web hepken (ket NFS)',
	'webstore_access' => "Bevennet eo ar servij-mañ diouzh chomlec'h IP ar pratik.",
	'webstore_path_invalid' => 'Direizh eo anv ar restr.',
	'webstore_dest_open' => 'Dibosupl digeriñ ar restr bal "$1".',
	'webstore_dest_lock' => 'C\'hwitet ar prennañ war ar restr bal "$1".',
	'webstore_dest_mkdir' => 'Dibosupl krouiñ ar c\'havlec\'h pal "$1".',
	'webstore_archive_lock' => 'C\'hwitet ar prennañ war ar restr diellaouet "$1".',
	'webstore_archive_mkdir' => 'Dibosupl krouiñ ar c\'havlec\'h diellaouiñ "$1".',
	'webstore_src_open' => 'Dibosupl digeriñ ar restr tarzh "$1".',
	'webstore_src_close' => 'Fazi en ur serriñ ar restr tarzh "$1".',
	'webstore_src_delete' => 'Fazi en ur ziverkañ ar restr tarzh "$1".',
	'webstore_rename' => 'Fazi en ur adenvel ar restr "$1" e "$2"..',
	'webstore_lock_open' => 'Fazi en ur zigeriñ ar restr prennet "$1".',
	'webstore_lock_close' => 'Fazi en ur serriñ ar restr prennet "$1".',
	'webstore_dest_exists' => 'Fazi, krouet eo bet ar restr bal "$1" dija.',
	'webstore_temp_open' => 'Fazi en ur zigeriñ ar restr padennek "$1".',
	'webstore_temp_copy' => 'Fazi en ur eilañ ar restr padennek "$1" war-du ar restr bal "$2".',
	'webstore_temp_close' => 'Fazi en ur serriñ ar restr padennek "$1".',
	'webstore_temp_lock' => 'Fazi en ur brennañ ar restr padennek "$1".',
	'webstore_no_archive' => "Bez'ez eus eus ar restr bal met n'eus bet roet diell ebet.",
	'webstore_no_file' => "N'eus bet enporzhiet restr ebet.",
	'webstore_move_uploaded' => 'Fazi en ur zilec\'hiañ ar restr enporzhiet "$1" war-du al lec\'h da c\'hortoz "$2".',
	'webstore_invalid_zone' => 'Takad "$1" direizh.',
	'webstore_no_deleted' => "N'eus bet spisaet kavlec'h diellaouiñ ebet evit ar restroù diverket.",
	'webstore_curl' => 'Fazi adal cURL: $1',
	'webstore_404' => "N'eo ket bet kavet ar restr.",
	'webstore_php_warning' => 'Kemenn PHP : $1',
	'webstore_metadata_not_found' => "N'eo ket bet kavet ar restr : $1",
	'webstore_postfile_not_found' => "N'eo ket bet kavet ar restr da enrollañ.",
	'webstore_scaler_empty_response' => "Distroet ez eus bet ur respont goullo hag ur c'hod 200 respont gant standilhonadur ar skeudenn. Marteze diwar ur fazi standilhonañ.",
	'webstore_invalid_response' => 'Respont direizh digant ar servijer :

$1',
	'webstore_no_response' => 'Direspont eo ar servijer.',
	'webstore_backend_error' => 'Fazi gant ar servijer stokañ :  

$1',
	'webstore_php_error' => 'Setu ar fazioù PHP bet kavet :',
	'webstore_no_handler' => "N'haller ket treuzfurmiñ ar seurt MIME-mañ.",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'inplace_access_disabled' => 'Pristup na ovaj servis je onemogućen za sve klijente.',
	'inplace_access_denied' => 'Ova usluga je zabranjena od strane IPa klijenta.',
	'inplace_scaler_no_temp' => 'Nema valjanog privremenog direktorijuma.
Postavite varijablu $wgLocalTmpDirectory kao direktorijum za pisanje.',
	'inplace_scaler_not_enough_params' => 'Nema dovoljno parametara.',
	'inplace_scaler_invalid_image' => 'Nevaljana slika, nije joj moguće odrediti veličinu.',
	'inplace_scaler_failed' => 'Desila se greška pri promjeni veličine slike: $1',
	'inplace_scaler_no_handler' => 'Nema programske rutine za transformiranje ovog MIME tipa',
	'inplace_scaler_no_output' => 'Nije napravljena transformacijska izlazna datoteka.',
	'inplace_scaler_zero_size' => 'Transformacija je proizvela datoteku veličine nula.',
	'webstore-desc' => 'Web pristup arhivi datoteka (bez NFS)',
	'webstore_access' => 'Ova usluga je onemogućena od IP klijenta.',
	'webstore_path_invalid' => 'Naziv datoteke nije valjan.',
	'webstore_dest_open' => 'Ne može se otvoriti odredišna datoteka "$1".',
	'webstore_dest_lock' => 'Greška pri zaključavanju odredišne datoteke "$1".',
	'webstore_dest_mkdir' => 'Nemoguće napraviti odredišni direktorij "$1".',
	'webstore_archive_lock' => 'Neuspjelo zaključavanje datoteke arhive "$1".',
	'webstore_archive_mkdir' => 'Nemoguće napraviti arhivski direktorij "$1".',
	'webstore_src_open' => 'Ne može se otvoriti izvorišna datoteka "$1".',
	'webstore_src_close' => 'Greška pri zatvaranju datoteke koda "$1".',
	'webstore_src_delete' => 'Greška pri brisanju datoteke izvora "$1".',
	'webstore_rename' => 'Greška pri promjeni imena datoteke "$1" u "$2".',
	'webstore_lock_open' => 'Greška pri otvaranju datoteke ključa "$1".',
	'webstore_lock_close' => 'Greška pri zatvaranju datoteka ključa "$1".',
	'webstore_dest_exists' => 'Greška, odredišna datoteka "$1" postoji.',
	'webstore_temp_open' => 'Greška pri otvaranju privremene datoteke "$1".',
	'webstore_temp_copy' => 'Greška pri kopiranju privremene datoteke "$1" na odredišnu datoteku "$2".',
	'webstore_temp_close' => 'Greška pri zatvaranju privremene datoteke "$1".',
	'webstore_temp_lock' => 'Greška pri zaključavanju privremene datoteke "$1".',
	'webstore_no_archive' => 'Odredišna datoteka postoji i nije navedena arhiva.',
	'webstore_no_file' => 'Nijedna datoteka nije postavljena.',
	'webstore_move_uploaded' => 'Greška pri premještanju postavljene datoteke "$1" na privremenu lokaciju "$2".',
	'webstore_invalid_zone' => 'Nevaljana zona "$1".',
	'webstore_no_deleted' => 'Nije definisan arhivski direktorijum za obrisane datoteke.',
	'webstore_curl' => 'Greška iz cURL: $1',
	'webstore_404' => 'Datoteka nije nađena.',
	'webstore_php_warning' => 'PHP upozorenje: $1',
	'webstore_metadata_not_found' => 'Datoteka nije nađena: $1',
	'webstore_postfile_not_found' => 'Datoteka za slanje nije pronađena.',
	'webstore_scaler_empty_response' => 'Skalar slika je vratio prazan odgovor sa kodom odgovora 200.
Ovo se možda desilo zbog fatalne greške PHP u skalaru.',
	'webstore_invalid_response' => 'Nevaljan odgovor od servera:

$1',
	'webstore_no_response' => 'Nema odgovora od servera',
	'webstore_backend_error' => 'Greška sa servera skladišta:

$1',
	'webstore_php_error' => 'PHP greške koje su se desile:',
	'webstore_no_handler' => 'Nema programske rutine za transformiranje ovog MIME tipa',
);

/** Catalan (Català)
 * @author Paucabot
 */
$messages['ca'] = array(
	'inplace_access_disabled' => "L'accés a aquest servei ha estat deshabilitat a tots els clients.",
	'webstore_access' => 'Aquest servei està restringit a la IP del client.',
	'webstore_path_invalid' => 'El nom del fitxer no és vàlid.',
	'webstore_no_file' => "No s'ha carregat cap fitxer.",
	'webstore_curl' => 'Error de cURL: $1',
	'webstore_404' => "No s'ha trobat el fitxer.",
	'webstore_php_warning' => 'Avís PHP: $1',
	'webstore_metadata_not_found' => "No s'ha trobat el fitxer: $1",
	'webstore_no_response' => 'Cap resposta del servidor',
	'webstore_php_error' => "S'han trobat errors PHP:",
);

/** Sorani (کوردی)
 * @author Marmzok
 */
$messages['ckb'] = array(
	'inplace_access_disabled' => 'ئه‌و ڕاژه‌یه‌ بۆ هه‌موو ڕاژه‌خوازان له‌ کارخستراوه‌.',
	'inplace_scaler_invalid_image' => 'له‌به‌ر شێوازی وێنه‌ی نه‌ناسراو، قه‌باره‌ ده‌رناکه‌وێت.',
	'webstore_path_invalid' => 'نێوی په‌ڕگه‌ نه‌ناسراو بوو.',
	'webstore_no_file' => 'هیچ په‌ڕگه‌یه‌ک بار نه‌کرا.',
	'webstore_404' => 'په‌ڕگه‌که‌ نه‌دۆزرایه‌وه‌.',
	'webstore_no_response' => 'وه‌ڵامێک له‌ ڕاژه‌کار نه‌هاته‌وه‌',
);

/** Czech (Česky)
 * @author Fryed-peach
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'inplace_access_disabled' => 'Přístup k této službě bylv vypnut pro všechny klienty.',
	'inplace_access_denied' => 'Tato služba je omezena na určené klientské IP adresy.',
	'inplace_scaler_no_temp' => 'Dočasný adresář není platný, nastavte $wgLocalTmpDirectory na zapisovatelný adresář.',
	'inplace_scaler_not_enough_params' => 'Nedostatek parametrů.',
	'inplace_scaler_invalid_image' => 'Neplatný obrázek, nebylo možné určit velikost.',
	'inplace_scaler_failed' => 'Během změny velikosti obrázku se vyskytla chyba: $1',
	'inplace_scaler_no_handler' => 'Pro transformaci tohoto MIME typu neexistuje obsluha',
	'inplace_scaler_no_output' => 'Nebyl vytvořen výstupní soubor této transformace.',
	'inplace_scaler_zero_size' => 'Transformace vytvořila výstupní soubor s nulovou velikostí.',
	'webstore-desc' => 'Middleware pouze webové úložiště (ne NFS)',
	'webstore_access' => 'Tato služba je omezena na určené klientské IP adresy.',
	'webstore_path_invalid' => 'Nový soubor byl neplatný.',
	'webstore_dest_open' => 'Nebylo možno otevřít cílový „$1“.',
	'webstore_dest_lock' => 'Nebylo možno získat zámek pro cílový soubor „$1“.',
	'webstore_dest_mkdir' => 'Nebylo možno vytvořit cílový adresář „$1“.',
	'webstore_archive_lock' => 'Nebylo možné získat zámek na soubor archívu „$1“.',
	'webstore_archive_mkdir' => 'Nebylo možné vytvořit archivní adresář „$1“.',
	'webstore_src_open' => 'Nebylo možné otevřít zdrojový soubor „$1“.',
	'webstore_src_close' => 'Chyba při zavírání zdrojového souboru „$1“.',
	'webstore_src_delete' => 'Chyba při mazání zdrojového souboru „$1“.',
	'webstore_rename' => 'Chyba při přejmenování souboru „$1“ na „$2“.',
	'webstore_lock_open' => 'Chyba při otevírání souboru zámku „$1“.',
	'webstore_lock_close' => 'Chyba při zavírání souboru zámku „$1“.',
	'webstore_dest_exists' => 'Chyba, cílový soubor „$1“ existuje.',
	'webstore_temp_open' => 'Chyba při otevírání dočasného souboru „$1“.',
	'webstore_temp_copy' => 'Chyba přo kopírování dočasného souboru „$1“ do cílového souboru „$2“.',
	'webstore_temp_close' => 'Chyba pří zavírání dočasného souboru „$1“.',
	'webstore_temp_lock' => 'Chyba při zamikání dočasného souboru „$1“.',
	'webstore_no_archive' => 'Cílový soubor existuje a nebyl zadán archív.',
	'webstore_no_file' => 'žádný soubor nebyl nahrán.',
	'webstore_move_uploaded' => 'Chyba při přesouvání nahraného souboru „$1“ na dočasné místo „$2“.',
	'webstore_invalid_zone' => 'Neplatná zóna „$1“.',
	'webstore_no_deleted' => 'Nebyl zadán žádný archivní adresář pro smazané soubory.',
	'webstore_curl' => 'Chyb od cURL: $1',
	'webstore_404' => 'Soubor nenalezen.',
	'webstore_php_warning' => 'Upozornění PHP: $1',
	'webstore_metadata_not_found' => 'Soubor nebyl nalezen: $1',
	'webstore_postfile_not_found' => 'Soubor na odeslání nebyl nalezen.',
	'webstore_scaler_empty_response' => 'Změna velikosti obrázku vrátila prázdnou odpověď s kódem 200. To by mohlo znamenat kritickou chybu PHP při změně velikosti obrázku.',
	'webstore_invalid_response' => 'Neplatná odpověď serveru:

$1',
	'webstore_no_response' => 'Žádná odpověď od serveru',
	'webstore_backend_error' => 'Chyba od úložného serveru:

$1',
	'webstore_php_error' => 'Vyskytly se chyby PHP:',
	'webstore_no_handler' => 'Pro transformaci tohoto MIME typu neexistuje obsluha',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author Leithian
 * @author Melancholie
 * @author Revolus
 */
$messages['de'] = array(
	'inplace_access_disabled' => 'Der Zugriff auf diesen Service wurde für alle Clients deaktiviert.',
	'inplace_access_denied' => 'Der Zugriff auf diesen Service wird durch die IP-Adresse des Clients reguliert.',
	'inplace_scaler_no_temp' => 'Kein gültiges temporäres Verzeichnis.
Setze $wgLocalTmpDirectory auf ein Verzeichnis mit Schreibzugriff.',
	'inplace_scaler_not_enough_params' => 'Zu wenige Parameter.',
	'inplace_scaler_invalid_image' => 'Ungültiges Bild, Größe konnte nicht festgestellt werden.',
	'inplace_scaler_failed' => 'Beim Skalieren des Bildes ist ein Fehler aufgetreten: $1',
	'inplace_scaler_no_handler' => 'Keine Routine zur Transformation dieses MIME-Typ vorhanden',
	'inplace_scaler_no_output' => 'Die Transformation erzeugte keine Ausgabedatei.',
	'inplace_scaler_zero_size' => 'Die Transformation erzeugte eine Ausgabedatei der Länge Null.',
	'webstore-desc' => 'Online-Zwischenanwendung zur Dateilagerung (kein NFS)',
	'webstore_access' => 'Der Zugriff auf diesen Service wird durch die IP-Adresse des Clients reguliert.',
	'webstore_path_invalid' => 'Der Dateiname war ungültig.',
	'webstore_dest_open' => 'Zieldatei „$1“ kann nicht geöffnet werden.',
	'webstore_dest_lock' => 'Zieldatei „$1“ kann nicht gesperrt werden.',
	'webstore_dest_mkdir' => 'Zielverzeichnis „$1“ kann nicht erstellt werden.',
	'webstore_archive_lock' => 'Archivdatei „$1“ kann nicht gesperrt werden.',
	'webstore_archive_mkdir' => 'Archivverzeichnis „$1“ kann nicht erstellt werden.',
	'webstore_src_open' => 'Quelldatei „$1“ kann nicht geöffnet werden.',
	'webstore_src_close' => 'Fehler beim Schließen von Quelldatei „$1“.',
	'webstore_src_delete' => 'Fehler beim Löschen von Quelldatei „$1“.',
	'webstore_rename' => 'Fehler beim Umbenennen der Datei „$1“ zu „$2“.',
	'webstore_lock_open' => 'Fehler beim Öffnen der Lockdatei „$1“.',
	'webstore_lock_close' => 'Fehler beim Schließen der Lockdatei „$1“.',
	'webstore_dest_exists' => 'Fehler, Zieldatei „$1“ existiert.',
	'webstore_temp_open' => 'Kann temporäre Datei „$1“ nicht öffnen.',
	'webstore_temp_copy' => 'Fehler beim Kopieren der temporären Datei „$1“ zur Zieldatei „$2“.',
	'webstore_temp_close' => 'Fehler beim Schließen der temporären Datei „$1“.',
	'webstore_temp_lock' => 'Fehler beim Sperren der temporären Datei „$1“.',
	'webstore_no_archive' => 'Zieldatei existiert und kein Archiv wurde angegeben.',
	'webstore_no_file' => 'Es wurde keine Datei hochgeladen.',
	'webstore_move_uploaded' => 'Fehler beim Verschieben der hochgeladenen Datei „$1“ zum Zwischenspeicherort „$2“.',
	'webstore_invalid_zone' => 'Ungültige Zone „$1“.',
	'webstore_no_deleted' => 'Es wurde kein Archivverzeichnis für gelöschte Dateien definiert.',
	'webstore_curl' => 'Fehler von cURL: $1',
	'webstore_404' => 'Datei nicht gefunden.',
	'webstore_php_warning' => 'PHP-Warnung: $1',
	'webstore_metadata_not_found' => 'Datei nicht gefunden: $1',
	'webstore_postfile_not_found' => 'Keine Datei zum Einstellen gefunden.',
	'webstore_scaler_empty_response' => 'Der Bildskalierer hat eine leere Antwort mit dem Antwortcode 200 zurückgegeben.
Dies könnte durch einen fatalen PHP-Fehler im Skalierer verursacht werden.',
	'webstore_invalid_response' => 'Ungültige Antwort vom Server:

$1',
	'webstore_no_response' => 'Keine Antwort vom Server',
	'webstore_backend_error' => 'Fehler vom Speicherserver:

$1',
	'webstore_php_error' => 'Es traten PHP-Fehler auf:',
	'webstore_no_handler' => 'Keine Routine zur Transformation dieses MIME-Typ vorhanden',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author ChrisiPK
 */
$messages['de-formal'] = array(
	'inplace_scaler_no_temp' => 'Kein gültiges temporäres Verzeichnis.
Setzen Sie $wgLocalTmpDirectory auf ein Verzeichnis mit Schreibzugriff.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'inplace_access_disabled' => 'Pśistup na toś tu słužbu jo se znjemóžnił za wšě klienty.',
	'inplace_access_denied' => 'Toś ta słužba wobgranicujo se pśez IP-adresu klienta.',
	'inplace_scaler_no_temp' => 'Žeden płaśiwy temporarny zapis.
Staj $wgLocalTmpDirectory na zapis z pisańskim pśistupom.',
	'inplace_scaler_not_enough_params' => 'Pśemało parametrow.',
	'inplace_scaler_invalid_image' => 'Njepłaśiwy wobraz, wjelikosć njejo se dała zwěsćiś.',
	'inplace_scaler_failed' => 'Zmólka jo nastała pśi skalowanju wobraza: $1',
	'inplace_scaler_no_handler' => 'Žedna programowa rutina za transformaciju toś togo typa MIME',
	'inplace_scaler_no_output' => 'Dataja wudaśa transformacije njejo se napórała.',
	'inplace_scaler_zero_size' => 'Transformacija jo napórała wudawańsku dataju z wjelikosću nul.',
	'webstore-desc' => 'Middleware za składowanje datajow jano za Web (nic NFS)',
	'webstore_access' => 'Słužba wobgranicujo se pśze IP-adresu klienta.',
	'webstore_path_invalid' => 'Datajowe mě jo było njepłaśiwe.',
	'webstore_dest_open' => 'Celowa dataja "$1" njedajo se wocyniś.',
	'webstore_dest_lock' => 'Celowa dataja "$1" njedajo se zastojaś.',
	'webstore_dest_mkdir' => 'Celowy zapis "$1" njedajo se napóraś.',
	'webstore_archive_lock' => 'Archiwowa dataja "$1" njedajo se zastojaś.',
	'webstore_archive_mkdir' => 'Archiwowy zapis "$1" njedajo se napóraś.',
	'webstore_src_open' => 'Žrědłowa dataja "$1" njedajo se wócyniś.',
	'webstore_src_close' => 'Zmólka pśi zacynjanju žrědłoweje dataje "$1".',
	'webstore_src_delete' => 'Zmólka pśi lašowanju žrědłoweje dataje "$1".',
	'webstore_rename' => 'Zmólka pśi pśemjenjowanju dataje "$1" do "$2".',
	'webstore_lock_open' => 'Zmólka pśi wócynjanju zastajoneje dataje "$1".',
	'webstore_lock_close' => 'Zmólka pśi zacynjanju zastajoneje dataje "$1".',
	'webstore_dest_exists' => 'Zmólka, celowa dataja "$1" eksistěrujo.',
	'webstore_temp_open' => 'Zmólka pśi wócynjanju temporarneje dataje "$1".',
	'webstore_temp_copy' => 'Zmólka pśi kopěrowanju temporarneje dataje "$1" do celoweje dataje "$2".',
	'webstore_temp_close' => 'Zmólka pśi zacynjanju temporarneje dataje "$1".',
	'webstore_temp_lock' => 'Zmólka pśi zastajanju temporarneje dataje "$1".',
	'webstore_no_archive' => 'Celowa dataja eksistěrujo a žeden archiw jo se pódał.',
	'webstore_no_file' => 'Žedna dataja jo se nagrała.',
	'webstore_move_uploaded' => 'Zmólka pśi pśesuwanju nagrateje dataje "$1" do temporarnego městna "$2".',
	'webstore_invalid_zone' => 'Njepłaśiwa cona "$1".',
	'webstore_no_deleted' => 'Archiwowy zapis za wulašowane dataje njejo se definěrował.',
	'webstore_curl' => 'Zmólka z cURL: $1',
	'webstore_404' => 'Dataja njenamakana.',
	'webstore_php_warning' => 'PHP-warnowanje: $1',
	'webstore_metadata_not_found' => 'Dataja njenamakana: $1',
	'webstore_postfile_not_found' => 'Dataja za wótpósłanje njejo se namakała.',
	'webstore_scaler_empty_response' => 'Wobrazowy skalěrowak jo wrośił prozne wótegrono z wótegronowym kodom 200.
Zawina by mógła wjelicka PHP-zmólka w skalěrowaku byś.',
	'webstore_invalid_response' => 'Njepłaśiwe wótegrono ze serwera:

$1',
	'webstore_no_response' => 'Žedno wótegrono ze serwera',
	'webstore_backend_error' => 'Zmólka ze składowańskego serwera:

$1',
	'webstore_php_error' => 'PHP-zmólki su nastali:',
	'webstore_no_handler' => 'Žedna programowa rutina za transformaciju toś togo typa MIME',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Lou
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'inplace_access_disabled' => 'Η πρόσβαση σε αυτή την υπηρεσία έχει απενεργοποιηθεί για όλους τους πελάτες.',
	'inplace_access_denied' => 'Η υπηρεσία είναι περιορισμένη από τον πάροχο IP',
	'inplace_scaler_not_enough_params' => 'Όχι αρκετοί παράμετροι',
	'inplace_scaler_invalid_image' => 'Μη έγκυρη εικόνα, δεν ήταν δυνατό να αποφασιστεί το μέγεθος.',
	'inplace_scaler_no_handler' => 'Κανένας χειριστής για την μεταμόρφωση αυτού του τύπου MIME',
	'inplace_scaler_no_output' => 'Κανένα αρχείο εξόδου δεν παρήχθη μέσω του μετασχηματισμού.',
	'webstore_access' => 'Η υπηρεσία είναι περιορισμένη από τον εξυπηρετητή ΙΡ.',
	'webstore_path_invalid' => 'Το όνομα αρχείου ήταν άκυρο.',
	'webstore_dest_open' => 'Αδύνατο να ανοίξει το αρχείο προορισμού "$1".',
	'webstore_dest_mkdir' => 'Αδύνατο να δημιουργήσει κατάλογο προορισμού "$1".',
	'webstore_archive_lock' => 'Απέτυχε η λήψη κλειδαριάς για το αρχείο αρχείου "$1".',
	'webstore_src_open' => 'Αδύνατο το άνοιγμα τρου αρχείου πηγής "$1".',
	'webstore_src_close' => 'Σφάλμα στο κλείσιμο του αρχείου πηγής "$1".',
	'webstore_src_delete' => 'Σφάλμα στη διαγραφή του αρχείου πηγής "$1".',
	'webstore_rename' => 'Σφάλμα στη μετονομασία του αρχείου "$1" σε "$2".',
	'webstore_lock_open' => 'Σφάλμα στο άνοιγμα του κλειδωμένου αρχείου "$1".',
	'webstore_lock_close' => 'Σφάλμα στο κλείσιμο του κλειδωμένου αρχείου "$1".',
	'webstore_dest_exists' => 'Σφάλμα, το αρχείο προορισμού "$1" υπάρχει.',
	'webstore_temp_open' => 'Σφάλμα στο άνοιγμα του προσωρινού αρχείου "$1".',
	'webstore_temp_copy' => 'Σφάλμα στην αντιγραφή του προσωρινού αρχείου "$1" στον προορισμό αρχείου "$2".',
	'webstore_temp_close' => 'Σφάλμα στο κλείσιμο του προσωρινού αρχείου "$1".',
	'webstore_temp_lock' => 'Σφάλμα στο κλείσιμο του προσωρινού αρχείου "$1".',
	'webstore_no_archive' => 'Το αρχείο προορισμού υπάρχει και δεν δώθηκε κανένα ιστορικό.',
	'webstore_no_file' => 'Δεν φορτώθηκε κανένα αρχείο.',
	'webstore_move_uploaded' => 'Σφάλμα στη μετακίνηση του φορτωμένου αρχείου "$1" στην προσωρινή τοποθεσία "$2".',
	'webstore_invalid_zone' => 'Άκυρη ζώνη "$1".',
	'webstore_no_deleted' => 'Δεν έχει οριστεί κατάλογος αρχείων για διαγραμμένα αρχεία.',
	'webstore_curl' => 'Σφάλμα από το cURL: $1',
	'webstore_404' => 'Το αρχείο δεν βρέθηκε.',
	'webstore_php_warning' => 'Προειδοποίηση PHP: $1',
	'webstore_metadata_not_found' => 'Το Αρχείο δεν βρέθηκε: $1',
	'webstore_postfile_not_found' => 'Δεν βρέθηκε το αρχείο προς δημοσίευση.',
	'webstore_invalid_response' => 'Μη έγκυρη απόκριση από τον εξυπηρετητή:

$1',
	'webstore_no_response' => 'Καμία απόκριση από τον εξυπηρετητή',
	'webstore_backend_error' => 'Σφάλμα από τον εξυπηρετητή αποθηκευτηρίου:

$1',
	'webstore_php_error' => 'Τα σφάλματα PHP αντιμετωπίστηκαν:',
	'webstore_no_handler' => 'Κανένας διαχειριστής για τη μετατροπή αυτού του τύπου MIME',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'inplace_access_denied' => 'Ĉi tiu servo estas limigita laŭ klienta IP-adreso.',
	'inplace_scaler_no_temp' => 'Ne estas valida provizora dosierujo.
Metu $wgLocalTmpDirectory al skribebla dosierujo.',
	'inplace_scaler_not_enough_params' => 'Ne sufiĉaj parametroj',
	'inplace_scaler_invalid_image' => 'Nevalida bildo; ne eblis determini pezon.',
	'inplace_scaler_failed' => 'Eraro okazis dum bilda skalado: $1',
	'webstore_access' => 'Ĉi tiu servo estas limigita laŭ klienta IP-adreso.',
	'webstore_path_invalid' => 'La dosiernomo estis nevalida.',
	'webstore_dest_open' => 'Ne eblas malfermi celan dosieron "$1".',
	'webstore_dest_lock' => 'Malsukcesis teni ŝloson por cela dosiero "$1".',
	'webstore_dest_mkdir' => 'Ne eblis krei celan dosierujon "$1".',
	'webstore_archive_lock' => 'Malsukcesis teni ŝloson en arkiva dosiero "$1".',
	'webstore_archive_mkdir' => 'Ne eblas krei arkivan dosierujon "$1".',
	'webstore_src_open' => 'Neeblas malfermi fontdosiero "$1".',
	'webstore_src_close' => 'Eraro fermante fontan dosieron "$1".',
	'webstore_src_delete' => 'Eraro forigante fontan dosieron "$1".',
	'webstore_rename' => 'Eraro alinomigante dosieron "$1" al $2".',
	'webstore_lock_open' => 'Eraro malfermante ŝlosan dosieron "$1".',
	'webstore_lock_close' => 'Eraro fermante ŝlosan dosieron "$1".',
	'webstore_dest_exists' => 'Eraro: Destina dosiero "$1" ekzistas.',
	'webstore_temp_open' => 'Eraro malfermante laboran dosieron "$1".',
	'webstore_temp_copy' => 'Eraro kopiante provizoran dosieron "$1" al cela dosiero "$2".',
	'webstore_temp_close' => 'Eraro fermante provizoran dosieron "$1".',
	'webstore_temp_lock' => 'Eraro ŝlosante provizoran dosieron "$1".',
	'webstore_no_archive' => 'Cela dosiero ekzistas kaj neniu arkivo estis donita.',
	'webstore_no_file' => 'Neniu dosiero estis alŝutita.',
	'webstore_invalid_zone' => 'Nevalida zono "$1".',
	'webstore_no_deleted' => 'Neniu arkiva dosierujo por forigitaj dosieroj estas difinita.',
	'webstore_curl' => 'Eraro de cURL: $1',
	'webstore_404' => 'Dosiero ne troviĝis.',
	'webstore_php_warning' => 'PHP-Averto: $1',
	'webstore_metadata_not_found' => 'Dosiero ne trovita: $1',
	'webstore_postfile_not_found' => 'Dosiero por afiŝado ne estis trovita.',
	'webstore_invalid_response' => 'Nevalida respondo de servilo:

$1',
	'webstore_no_response' => 'Servilo ne respondis',
	'webstore_backend_error' => 'Eraro de dosieruja servilo:

$1',
	'webstore_php_error' => 'Jen eraroj PHP:',
	'webstore_no_handler' => 'Neniu traktilo por transformi ĉi tiun MIME-tipon',
);

/** Spanish (Español)
 * @author Antur
 * @author Crazymadlover
 * @author Fitoschido
 * @author Fluence
 * @author Sanbec
 */
$messages['es'] = array(
	'inplace_access_disabled' => 'Se ha deshabilitado el acceso a este servicio para todos los clientes.',
	'inplace_access_denied' => 'Este servicio está restringido por IP de cliente.',
	'inplace_scaler_no_temp' => 'Directorio temporal no válido.
Poner $wgLocalTmpDirectory a un directorio editable.',
	'inplace_scaler_not_enough_params' => 'Sin parámetros suficientes.',
	'inplace_scaler_invalid_image' => 'Imagen no válida, no se pudo determinar el tamaño.',
	'inplace_scaler_failed' => 'Un error fue encontrado durante el escalado de la imagen: $1',
	'inplace_scaler_no_handler' => 'No existe un conversor para transformar este tipo MIME',
	'inplace_scaler_no_output' => 'No se generó archivo de salida',
	'inplace_scaler_zero_size' => 'Transformación produjo un archivo de salida de tamaño nulo.',
	'webstore-desc' => 'Conectividad exclusiva para Web de almacenamiento de archivos (no NFS)',
	'webstore_access' => 'Este servicio está restringido por el cliente IP.',
	'webstore_path_invalid' => 'El nombre de archivo no es válido.',
	'webstore_dest_open' => 'No es posible abrir el archivo de destino «$1».',
	'webstore_dest_lock' => 'No se pudo acceder al archivo de destino «$1».',
	'webstore_dest_mkdir' => 'No es posible crear el directorio de destino «$1».',
	'webstore_archive_lock' => 'No se pudo acceder al archivo «$1».',
	'webstore_archive_mkdir' => 'No se puede crear el directorio de archivo «$1».',
	'webstore_src_open' => 'No se puede abrir el archivo de origen «$1».',
	'webstore_src_close' => 'Error al cerrar el archivo de origen «$1».',
	'webstore_src_delete' => 'Error al borrar el archivo de origen «$1».',
	'webstore_rename' => 'Error al renombrar el archivo «$1» a «$2».',
	'webstore_lock_open' => 'Error al abrir el archivo de bloqueo «$1».',
	'webstore_lock_close' => 'Error al cerrar el archivo de bloqueo «$1».',
	'webstore_dest_exists' => 'Error, el archivo de destino «$1» existe.',
	'webstore_temp_open' => 'Error al abrir el archivo temporal «$1».',
	'webstore_temp_copy' => 'Error al copiar el archivo temporal «$1» en el archivo de destino «$2».',
	'webstore_temp_close' => 'Error al cerrar el archivo temporal «$1».',
	'webstore_temp_lock' => 'Error al bloquear el archivo temporal «$1».',
	'webstore_no_archive' => 'El archivo de destino existe y no se proporcionó ningún archivador.',
	'webstore_no_file' => 'No se ha cargado ningún archivo.',
	'webstore_move_uploaded' => 'Error al mover el archivo cargado «$1» a la ubicación temporal «$2».',
	'webstore_invalid_zone' => 'Zona no válida «$1».',
	'webstore_no_deleted' => 'Ningún directorio de archivo para archivos borrados está definido.',
	'webstore_curl' => 'Error de cURL: $1',
	'webstore_404' => 'Archivo no encontrado.',
	'webstore_php_warning' => 'Advertencia PHP: $1',
	'webstore_metadata_not_found' => 'Archivo no encontrado: $1',
	'webstore_postfile_not_found' => 'Archivo para remitir no encontrado.',
	'webstore_scaler_empty_response' => 'El escalador de imagen dio una respuesta vacía con un código de respuesta 200.
Esto podría deberse a un error fatal PHP en el escalador.',
	'webstore_invalid_response' => 'Respuesta no válida del servidor:

$1',
	'webstore_no_response' => 'Sin respuesta del servidor',
	'webstore_backend_error' => 'Error del servidor de almacenamiento:

$1',
	'webstore_php_error' => 'Errores PHP fueron encontrados:',
	'webstore_no_handler' => 'No hay procesador para transformar este tipo MIME.',
);

/** Estonian (Eesti)
 * @author Avjoska
 */
$messages['et'] = array(
	'webstore_404' => 'Faili ei leitud.',
	'webstore_metadata_not_found' => 'Faili ei leitud: $1',
	'webstore_no_response' => 'Server ei vasta',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'inplace_scaler_not_enough_params' => 'Parametro falta.',
	'inplace_scaler_invalid_image' => 'Baliogabeko irudia, tamaina ezin da zehaztu.',
	'webstore_path_invalid' => 'Fitxategiaren izena ez da baliozkoa.',
	'webstore_no_file' => 'Fitxategirik ez da igo.',
	'webstore_invalid_zone' => 'Baliogabeko "$1" eremua.',
	'webstore_curl' => 'cURL-(r)en errorea: $1',
	'webstore_404' => 'Fitxategirik ez da aurkitu.',
	'webstore_php_warning' => 'PHP Abisua: $1',
	'webstore_metadata_not_found' => 'Ez da fitxategia aurkitu: $1',
	'webstore_no_response' => 'Zerbitzaritik ez da erantzunik jaso.',
	'webstore_php_error' => 'PHPren erroreak aurkitu dira:',
);

/** Extremaduran (Estremeñu)
 * @author Better
 */
$messages['ext'] = array(
	'webstore_rename' => 'Marru rehucheandu el archivu "$1" a "$2".',
	'webstore_no_file' => 'Nu s´á empuntau dengún archivu.',
	'webstore_404' => 'Archivu nu alcuentrau.',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Silvonen
 * @author Str4nd
 */
$messages['fi'] = array(
	'inplace_access_denied' => 'Tämä palvelu on rajoitettu IP-osoitteiden perusteella.',
	'inplace_scaler_not_enough_params' => 'Ei tarpeeksi parametreja.',
	'inplace_scaler_invalid_image' => 'Virheellinen kuvatiedosto. Kokoa ei voitu määrittää.',
	'webstore_path_invalid' => 'Tiedostonimi oli epäkelpo.',
	'webstore_dest_open' => 'Kohdetiedostoa ”$1” ei voitu avata.',
	'webstore_dest_mkdir' => 'Kohdehakemistoa ”$1” ei voitu luoda.',
	'webstore_archive_mkdir' => 'Arkistohakemistoa ”$1” ei voitu luoda.',
	'webstore_src_open' => 'Lähdetiedostoa ”$1” ei voitu avata.',
	'webstore_src_close' => 'Virhe sulkiessa lähdetiedostoa ”$1”.',
	'webstore_src_delete' => 'Virhe sulkiessa lähdetiedostoa ”$1”.',
	'webstore_rename' => 'Virhe vaihtaessa tiedostoa ”$1” nimelle ”$2”.',
	'webstore_lock_open' => 'Virhe avatessa lukkotiedostoa ”$1”.',
	'webstore_lock_close' => 'Virhe sulkiessa lukkotiedostoa ”$1”.',
	'webstore_dest_exists' => 'Virhe, kohdetiedosto ”$1” on olemassa.',
	'webstore_temp_open' => 'Virhe avatessa väliaikaistiedostoa ”$1”.',
	'webstore_temp_copy' => 'Virhe kopioidessa väliaikaistiedostoa ”$1” kohdetiedostoon ”$2”.',
	'webstore_temp_close' => 'Virhe sulkiessa väliaikaistiedostoa ”$1”.',
	'webstore_temp_lock' => 'Virhe lukitessa väliaikaistiedostoa ”$1”.',
	'webstore_no_archive' => 'Kohdetiedosto on olemassa, eikä arkistoa ole määritelty.',
	'webstore_no_file' => 'Yhtään tiedostoa ei tallennettu.',
	'webstore_move_uploaded' => 'Virhe siirtäessä tallennettua tiedostoa ”$1” väliaikaiskohteeseen ”$2”.',
	'webstore_invalid_zone' => 'Virheellinen alue ”$1”.',
	'webstore_no_deleted' => 'Arkistohakemistoa poistettaville tiedostoille ei ole määritelty.',
	'webstore_curl' => 'Virhe cURL:lta: $1',
	'webstore_404' => 'Tiedostoa ei löydy.',
	'webstore_php_warning' => 'PHP-varoitus: $1',
	'webstore_metadata_not_found' => 'Tiedostoa ei löydy: $1',
	'webstore_invalid_response' => 'Virheellinen vastaus palvelimelta:

$1',
	'webstore_no_response' => 'Ei vastausta palvelimelta.',
	'webstore_backend_error' => 'Virhe tallennuspalvelimelta:

$1',
	'webstore_php_error' => 'Ilmeni PHP-virheitä:',
);

/** French (Français)
 * @author Crochet.david
 * @author Dereckson
 * @author Grondin
 * @author PieRRoMaN
 * @author Sherbrooke
 * @author Urhixidur
 */
$messages['fr'] = array(
	'inplace_access_disabled' => 'L’accès à ce service est désactivé pour tous les clients.',
	'inplace_access_denied' => 'Ce service est restreint sur la base de l’IP du client.',
	'inplace_scaler_no_temp' => 'Aucun répertoire temporaire valide.
$wgLocalTmpDirectory doit contenir le nom d’un répertoire accessible en écriture.',
	'inplace_scaler_not_enough_params' => 'Pas suffisamment de paramètres.',
	'inplace_scaler_invalid_image' => 'Image incorrecte, impossible de déterminer sa taille.',
	'inplace_scaler_failed' => 'Une erreur est survenue pendant le redimensionnement de l’image : $1',
	'inplace_scaler_no_handler' => 'Aucun gestionnaire ne prend en charge ce type MIME.',
	'inplace_scaler_no_output' => 'La transformation n’a suscité la génération d’aucun fichier de sortie.',
	'inplace_scaler_zero_size' => 'La transformation a produit un fichier de sortie de taille nulle.',
	'webstore-desc' => 'Intergiciel de stockage de fichiers pour le Web uniquement (non NFS)',
	'webstore_access' => 'Ce service est restreint par adresse IP.',
	'webstore_path_invalid' => 'Le nom de fichier n’est pas correct.',
	'webstore_dest_open' => 'Impossible d’ouvrir le fichier de destination « $1 ».',
	'webstore_dest_lock' => 'Échec d’obtention du verrou sur le fichier de destination « $1 ».',
	'webstore_dest_mkdir' => 'Impossible de créer le répertoire de destination « $1 ».',
	'webstore_archive_lock' => 'Échec d’obtention du verrou du fichier archivé « $1 ».',
	'webstore_archive_mkdir' => 'Impossible de créer le répertoire d’archivage « $1 ».',
	'webstore_src_open' => 'Impossible d’ouvrir le fichier source « $1 ».',
	'webstore_src_close' => 'Erreur de fermeture du fichier source « $1 ».',
	'webstore_src_delete' => 'Erreur de suppression du fichier source « $1 ».',
	'webstore_rename' => 'Erreur de renommage du fichier « $1 » en « $2 ».',
	'webstore_lock_open' => 'Erreur d’ouverture du fichier verrouillé « $1 ».',
	'webstore_lock_close' => 'Erreur de fermeture du fichier verrouillé « $1 ».',
	'webstore_dest_exists' => 'Erreur, le fichier de destination « $1 » existe.',
	'webstore_temp_open' => 'Erreur d’ouverture du fichier temporaire « $1 ».',
	'webstore_temp_copy' => 'Erreur de copie du fichier temporaire « $1 » vers le fichier de destination « $2 ».',
	'webstore_temp_close' => 'Erreur de fermeture du fichier temporaire « $1 ».',
	'webstore_temp_lock' => 'Erreur de verrouillage du fichier temporaire « $1 ».',
	'webstore_no_archive' => 'Le fichier de destination existe et aucune archive n’a été donnée.',
	'webstore_no_file' => 'Aucun fichier n’a été téléversé.',
	'webstore_move_uploaded' => 'Erreur de déplacement du fichier téléversé « $1 » vers l’emplacement temporaire « $2 ».',
	'webstore_invalid_zone' => 'Zone « $1 » invalide.',
	'webstore_no_deleted' => 'Aucun répertoire d’archive pour les fichiers supprimés n’a été défini.',
	'webstore_curl' => 'Erreur depuis cURL : $1',
	'webstore_404' => 'Fichier non trouvé.',
	'webstore_php_warning' => 'Avertissement PHP : $1',
	'webstore_metadata_not_found' => 'Fichier non trouvé : $1',
	'webstore_postfile_not_found' => 'Fichier à enregistrer non trouvé.',
	'webstore_scaler_empty_response' => 'Le redimensionneur d’image a donné une réponse nulle avec un code de réponse 200.
Ceci pourrait être dû à une erreur fatale de PHP dans le redimensionneur.',
	'webstore_invalid_response' => 'Réponse invalide de la part du serveur : 

$1',
	'webstore_no_response' => 'Le serveur ne répond pas',
	'webstore_backend_error' => 'Erreur depuis le serveur de stockage : 

$1',
	'webstore_php_error' => 'Les erreurs PHP suivantes sont survenues :',
	'webstore_no_handler' => 'Aucun gestionnaire ne prend en charge ce type MIME.',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'inplace_access_disabled' => 'L’accès a ceti sèrviço est dèsactivâ por tôs los cliants.',
	'inplace_access_denied' => 'Ceti sèrviço est rètrent per adrèce IP u cliant.',
	'inplace_scaler_not_enough_params' => 'Pas prod de paramètres.',
	'inplace_scaler_invalid_image' => 'Émâge fôssa, empossiblo de dètèrmenar sa talye.',
	'webstore_access' => 'Ceti sèrviço est rètrent per adrèce IP u cliant.',
	'webstore_path_invalid' => 'Lo nom de fichiér est pas justo.',
	'webstore_dest_open' => 'Empossiblo d’uvrir lo fichiér de dèstinacion « $1 ».',
	'webstore_dest_mkdir' => 'Empossiblo de fâre lo rèpèrtouèro de dèstinacion « $1 ».',
	'webstore_archive_mkdir' => 'Empossiblo de fâre lo rèpèrtouèro d’arch·ivâjo « $1 ».',
	'webstore_src_open' => 'Empossiblo d’uvrir lo fichiér sôrsa « $1 ».',
	'webstore_src_close' => 'Èrror de cllotura du fichiér sôrsa « $1 ».',
	'webstore_src_delete' => 'Èrror de suprèssion du fichiér sôrsa « $1 ».',
	'webstore_rename' => 'Èrror de changement de nom du fichiér « $1 » en « $2 ».',
	'webstore_lock_open' => 'Èrror d’uvèrtura du fichiér vèrrolyê « $1 ».',
	'webstore_lock_close' => 'Èrror de cllotura du fichiér vèrrolyê « $1 ».',
	'webstore_dest_exists' => 'Èrror, lo fichiér de dèstinacion « $1 » ègziste.',
	'webstore_temp_open' => 'Èrror d’uvèrtura du fichiér temporèro « $1 ».',
	'webstore_temp_copy' => 'Èrror de copia du fichiér temporèro « $1 » de vers lo fichiér de dèstinacion « $2 ».',
	'webstore_temp_close' => 'Èrror de cllotura du fichiér temporèro « $1 ».',
	'webstore_temp_lock' => 'Èrror de vèrrolyâjo du fichiér temporèro « $1 ».',
	'webstore_no_archive' => 'Lo fichiér de dèstinacion ègziste et pués niones arch·ives ont étâ balyês.',
	'webstore_no_file' => 'Nion fichiér at étâ tèlèchargiê.',
	'webstore_move_uploaded' => 'Èrror de dèplacement du fichiér tèlèchargiê « $1 » de vers l’emplacement temporèro « $2 ».',
	'webstore_invalid_zone' => 'Zona « $1 » envalida.',
	'webstore_no_deleted' => 'Nion rèpèrtouèro d’arch·ivâjo por los fichiérs suprimâs at étâ dèfeni.',
	'webstore_curl' => 'Èrror dês cURL : $1',
	'webstore_404' => 'Fichiér entrovâblo.',
	'webstore_php_warning' => 'Avèrtissement PHP : $1',
	'webstore_metadata_not_found' => 'Fichiér entrovâblo : $1',
	'webstore_postfile_not_found' => 'Fichiér a encartar entrovâblo.',
	'webstore_invalid_response' => 'Rèponsa envalida de la pârt du sèrvor :

$1',
	'webstore_no_response' => 'Lo sèrvor rèpond pas',
	'webstore_backend_error' => 'Èrror dês lo sèrvor de stocâjo :

$1',
	'webstore_php_error' => 'Cetes èrrors PHP sont arrevâs :',
	'webstore_no_handler' => 'Nion administrator prend en charge ceti tipo MIME.',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'webstore_src_open' => 'Ní féidir comhad foinsí "$1" a oscailt.',
	'webstore_src_close' => 'Earráid dunadh comhad foinsí "$1".',
	'webstore_src_delete' => 'Earráid scriosadh comhad foinsí "$1".',
);

/** Galician (Galego)
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'inplace_access_disabled' => 'Desactivouse o acceso a este servizo para todos os clientes.',
	'inplace_access_denied' => 'Este servizo está restrinxido polo IP do cliente.',
	'inplace_scaler_no_temp' => 'Non é un directorio temporal válido; configure $wgLocalTmpDirectory nun directorio no que se poida escribir.',
	'inplace_scaler_not_enough_params' => 'Os parámetros son insuficientes.',
	'inplace_scaler_invalid_image' => 'A imaxe non é válida, non se puido determinar o seu tamaño.',
	'inplace_scaler_failed' => 'Atopouse un erro mentres se ampliaba a imaxe: $1',
	'inplace_scaler_no_handler' => 'Non se definiu un programa para transformar este tipo MIME',
	'inplace_scaler_no_output' => 'Non se produciu ningún ficheiro de saída da transformación.',
	'inplace_scaler_zero_size' => 'A transformación produciu un ficheiro de saída de tamaño 0.',
	'webstore-desc' => 'Almacenamento de ficheiros na páxina web (non no sistema de ficheiros de rede)',
	'webstore_access' => 'Este servizo está restrinxido polo IP do cliente.',
	'webstore_path_invalid' => 'O nome do ficheiro non era válido.',
	'webstore_dest_open' => 'Non se puido abrir o ficheiro de destino "$1".',
	'webstore_dest_lock' => 'Non se puido bloquear o ficheiro de destino "$1".',
	'webstore_dest_mkdir' => 'Non se puido crear o directorio de destino "$1".',
	'webstore_archive_lock' => 'Non se puido bloquear o ficheiro de arquivo "$1".',
	'webstore_archive_mkdir' => 'Non se puido crear o directorio de arquivo "$1".',
	'webstore_src_open' => 'Non se puido abrir o ficheiro de orixe "$1".',
	'webstore_src_close' => 'Erro ao pechar o ficheiro de orixe "$1".',
	'webstore_src_delete' => 'Erro ao eliminar o ficheiro de orixe "$1".',
	'webstore_rename' => 'Erro ao lle mudar o nome a "$1" para "$2".',
	'webstore_lock_open' => 'Erro ao abrir o ficheiro de bloqueo "$1".',
	'webstore_lock_close' => 'Erro ao pechar o ficheiro de bloqueo "$1".',
	'webstore_dest_exists' => 'Erro, xa existe o ficheiro de destino "$1".',
	'webstore_temp_open' => 'Erro ao abrir o ficheiro temporal "$1".',
	'webstore_temp_copy' => 'Erro ao copiar o ficheiro temporal "$1" no ficheiro de destino "$2".',
	'webstore_temp_close' => 'Erro ao pechar o ficheiro temporal "$1".',
	'webstore_temp_lock' => 'Erro ao bloquear o ficheiro temporal "$1".',
	'webstore_no_archive' => 'O ficheiro de destino xa existe e non se deu un arquivo.',
	'webstore_no_file' => 'Non se enviou ningún ficheiro.',
	'webstore_move_uploaded' => 'Erro ao mover o ficheiro enviado "$1" para a localización temporal "$2".',
	'webstore_invalid_zone' => 'Zona "$1" non válida.',
	'webstore_no_deleted' => 'Non se definiu un directorio de arquivo para os ficheiros eliminados.',
	'webstore_curl' => 'Erro de cURL: $1',
	'webstore_404' => 'Non se atopou o ficheiro.',
	'webstore_php_warning' => 'Aviso de PHP: $1',
	'webstore_metadata_not_found' => 'Non se atopou o ficheiro: $1',
	'webstore_postfile_not_found' => 'Non se atopou o ficheiro enviado.',
	'webstore_scaler_empty_response' => 'O redimensionador de imaxes deu unha resposta baleira co código de resposta 200. Isto podería deberse a un erro fatal de PHP no redimensionador.',
	'webstore_invalid_response' => 'Resposta non válida do servidor:

$1',
	'webstore_no_response' => 'Sen resposta desde o servidor',
	'webstore_backend_error' => 'Erro do servidor de almacenamento:

$1',
	'webstore_php_error' => 'Atopáronse erros de PHP:',
	'webstore_no_handler' => 'Non hai un programa para transformar este tipo MIME',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'inplace_access_disabled' => 'Dr Zuegriff uf dää Service isch fir alli Client deaktiviert wore.',
	'inplace_access_denied' => 'Dr Zuegriff uf dää Service wird dur d IP-Adräss vum Client reguliert.',
	'inplace_scaler_no_temp' => 'Kei giltig temporär Verzeichnis.
Setz $wgLocalTmpDirectory uf e Verzeichnis mit Schryybzuegriff.',
	'inplace_scaler_not_enough_params' => 'Z wenig Parameter.',
	'inplace_scaler_invalid_image' => 'Uugiltig Bild, Greßi cha nit feschtgstellt wäre.',
	'inplace_scaler_failed' => 'Bim Skaliere vum Bild isch e Fähler ufträtte: $1',
	'inplace_scaler_no_handler' => 'S het kei Routine fir d Transformation vu däm MIME-Typ',
	'inplace_scaler_no_output' => 'D Transformation het kei Uusgabedatei erzyygt.',
	'inplace_scaler_zero_size' => 'D Transformation het e Uusgabedatei mit dr Längi Null erzyygt.',
	'webstore-desc' => 'Online-Zwischenaawändig fir d Dateilagerig (kei NFS)',
	'webstore_access' => 'Dr Zuegriff uf dää Service wird dur d IP-Adräss vum Client reguliert.',
	'webstore_path_invalid' => 'Dr Dateiname isch nit giltig gsi.',
	'webstore_dest_open' => 'Ziildatei „$1“ chaa nit ufgmacht wäre.',
	'webstore_dest_lock' => 'Ziildatei „$1“ het nit chenne gsperrt wäre.',
	'webstore_dest_mkdir' => 'Ziilverzeichnis „$1“ het nit chennen aagleit wäre.',
	'webstore_archive_lock' => 'Archivdatei „$1“ het nit chenne gspycheret wäre.',
	'webstore_archive_mkdir' => 'Archivverzeichnis „$1“ cha nit aagleit wäre.',
	'webstore_src_open' => 'Quälldatei „$1“ cha nit ufgmacht wäre.',
	'webstore_src_close' => 'Fähler bim Zuemache vu dr Quälldatei „$1“.',
	'webstore_src_delete' => 'Fähler bim Lesche vu dr Quälldatei „$1“.',
	'webstore_rename' => 'Fähler bim Umnänne vu dr Datei „$1“ in „$2“.',
	'webstore_lock_open' => 'Fähler bim Ufmache vu dr Lockdatei „$1“.',
	'webstore_lock_close' => 'Fähler bim Zuemache vu dr Lockdatei „$1“.',
	'webstore_dest_exists' => 'Fähler, Ziildatei „$1“ git s scho.',
	'webstore_temp_open' => 'Cha di temporär Datei „$1“ nit ufmache.',
	'webstore_temp_copy' => 'Fähler bim Kopiere vu dr temporäre Datei „$1“ zue dr Ziildatei „$2“.',
	'webstore_temp_close' => 'Fähler bim Zuemache vu dr temporäre Datei „$1“.',
	'webstore_temp_lock' => 'Fähler bim Sperre vu dr temporäre Datei „$1“.',
	'webstore_no_archive' => 'Ziildatei git s un kei Archiv isch aagee wore.',
	'webstore_no_file' => 'S isch kei Datei uffeglade wore.',
	'webstore_move_uploaded' => 'Fähler bim Verschiebe vu dr uffegladene Datei „$1“ zum Zwischespycherort „$2“.',
	'webstore_invalid_zone' => 'Uugiltigi Zone „$1“.',
	'webstore_no_deleted' => 'S isch kei Archivverzeichnis fir gleschti Dateie definiert wore.',
	'webstore_curl' => 'Fähler vu cURL: $1',
	'webstore_404' => 'Datei nit gfunde.',
	'webstore_php_warning' => 'PHP-Warnig: $1',
	'webstore_metadata_not_found' => 'Datei nit gfunde: $1',
	'webstore_postfile_not_found' => 'Kei Datei zum Yystelle gfunde.',
	'webstore_scaler_empty_response' => 'Dr Bildskalierer het e lääri Antwort mit em Antwortcode 200 zrugggee.
Des chennt dur e fatale PHP-Fähler im Skalierer verursacht syy.',
	'webstore_invalid_response' => 'Uugiltigi Antwort vum Server:

$1',
	'webstore_no_response' => 'Kei Antwort vum Server',
	'webstore_backend_error' => 'Fähler vum Spycherserver:

$1',
	'webstore_php_error' => 'S het PHP-Fähler gee:',
	'webstore_no_handler' => 'S git kei Routine fir d Transformation vu däm MIME-Typ',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'inplace_access_disabled' => 'הגישה לשירות זה בוטלה לכל הלקוחות.',
	'inplace_access_denied' => 'שירות זה מוגבל לפי כתובת ה־IP של הלקוח.',
	'inplace_scaler_no_temp' => 'אין תיקייה זמנית תקינה.
הגדירו את $wgLocalTmpDirectory לתיקייה הניתנת לכתיבה.',
	'inplace_scaler_not_enough_params' => 'אין מספיק פרמטרים.',
	'inplace_scaler_invalid_image' => 'התמונה אינה תקינה, לא ניתן לזהות את גודלה.',
	'inplace_scaler_failed' => 'אירעה שגיאה במהלך שינוי גודל התמונה: $1',
	'inplace_scaler_no_handler' => 'אין הגדרה להצגת קבצים מסוג MIME זה',
	'inplace_scaler_no_output' => 'לא נוצר קובץ הכולל את פלט המרה.',
	'inplace_scaler_zero_size' => 'ההמרה יצרה קובץ פלט בן 0 בתים.',
	'webstore-desc' => 'תוכנת תיווך לאיחסון קבצים ברשת בלבד (ללא NFS)',
	'webstore_access' => 'שירות זה מוגבל לפי כתובת ה־IP של הלקוח.',
	'webstore_path_invalid' => 'שם הקובץ שגוי.',
	'webstore_dest_open' => 'לא ניתן לפתוח את קובץ היעד "$1".',
	'webstore_dest_lock' => 'לא ניתן לבצע נעילת בלעדיות של קובץ היעד "$1".',
	'webstore_dest_mkdir' => 'לא ניתן ליצור את תיקיית היעד "$1".',
	'webstore_archive_lock' => 'לא ניתן לבצע נעילת בלעדיות על קובץ הארכיון "$1".',
	'webstore_archive_mkdir' => 'לא ניתן ליצור את תיקיית הארכיון "$1".',
	'webstore_src_open' => 'לא ניתן לפתוח את קובץ המקור "$1".',
	'webstore_src_close' => 'שגיאה בסגירת קובץ המקור "$1".',
	'webstore_src_delete' => 'שגיאה במחיקת קובץ המקור "$1".',
	'webstore_rename' => 'שגיאה בשינוי שם הקובץ מ־"$1" ל־"$2".',
	'webstore_lock_open' => 'שגיאה בפתיחת קובץ הנעילה "$1".',
	'webstore_lock_close' => 'שגיאה בסגירת קובץ הנעילה "$1".',
	'webstore_dest_exists' => 'שגיאה, קובץ היעד "$1" קיים.',
	'webstore_temp_open' => 'שגיאה בפתיחת הקובץ הזמני "$1".',
	'webstore_temp_copy' => 'שגיאה בהעתקת הקובץ הזמני "$1" לקובץ היעד "$2".',
	'webstore_temp_close' => 'שגיאה בסגירת הקובץ הזמני "$1".',
	'webstore_temp_lock' => 'שגיאה בנעילת הקובץ הזמני "$1".',
	'webstore_no_archive' => 'קובץ היעד קיים ולא ניתן ארכיון.',
	'webstore_no_file' => 'לא הועלה קובץ.',
	'webstore_move_uploaded' => 'שגיאה בהעברת הקובץ שהועלה "$1" אל התיקייה הזמנית "$2".',
	'webstore_invalid_zone' => 'אזור שגוי "$1".',
	'webstore_no_deleted' => 'לא הוגדרה תיקיית ארכיון עבור קבצים שנמחקו.',
	'webstore_curl' => 'שגיאת cURL: $1',
	'webstore_404' => 'הקובץ לא נמצא.',
	'webstore_php_warning' => 'אזהרת PHP: $1',
	'webstore_metadata_not_found' => 'הקובץ לא נמצא: $1',
	'webstore_postfile_not_found' => 'הקובץ לשליחה לא נמצא.',
	'webstore_scaler_empty_response' => 'משנה גודלי התמונות החזיר תגובה ריקה עם קוד התגובה 200.
יתכן והדבר נגרם עקב שגיאה קריטית של PHP במשנה הגודל.',
	'webstore_invalid_response' => 'תגובה בלתי תקינה מהשרת:

$1',
	'webstore_no_response' => 'אין תגובה מהשרת',
	'webstore_backend_error' => 'שגיאה משרת האיחסון:

$1',
	'webstore_php_error' => 'אירעו שגיאות PHP:',
	'webstore_no_handler' => 'אין הגדרה להצגת קבצים מסוג MIME זה',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 * @author आलोक
 */
$messages['hi'] = array(
	'webstore_404' => 'संचिका नहीं मिली।',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'inplace_access_disabled' => 'Přistup k tutej słužbje bu za wšě klienty znjemóžnjeny.',
	'inplace_access_denied' => 'Tuta słužba so přez klientowy IP wobmjezuje.',
	'inplace_scaler_no_temp' => 'Žadyn płaćiwy temporerny zapis, staj wariablu $wgLocalTmpDirectory na popisajomny zapis',
	'inplace_scaler_not_enough_params' => 'Falowace parametry.',
	'inplace_scaler_invalid_image' => 'Njepłaćiwy wobraz, wulkosć njeda so zwěsćić.',
	'inplace_scaler_failed' => 'Při skalowanju je zmylk wustupił: $1',
	'inplace_scaler_no_handler' => 'Žadyn rjadowak, zo by so tutón MIME-typ přetworił',
	'inplace_scaler_no_output' => 'Njeje so žana wudawanska dataja spłodźiła.',
	'inplace_scaler_zero_size' => 'Přetworjenje spłodźi prózdnu wudawansku dataju.',
	'webstore-desc' => 'Middleware jenož za webowe (nic NFS) datajowe składowanje',
	'webstore_access' => 'Tuta słužba so přez klientowy IP wobmjezuje.',
	'webstore_path_invalid' => 'Datajowe mjeno bě njepłaćiwe.',
	'webstore_dest_open' => 'Njeje móžno cilowu dataju "$1" wočinić.',
	'webstore_dest_lock' => 'Zawrjenje ciloweje dataje "$1" njeje so poradźiło.',
	'webstore_dest_mkdir' => 'Njeje móžno cilowy zapis "$1" wutworić.',
	'webstore_archive_lock' => 'Zawrjenje archiwneje dataje "$1" njeje so poradźiło.',
	'webstore_archive_mkdir' => 'Njeje móžno archiwowy zapis "$1" wutworić.',
	'webstore_src_open' => 'Njeje móžno žórłowu dataju "$1" wočinić.',
	'webstore_src_close' => 'Zmylk při začinjenju žórłoweje dataje "$1".',
	'webstore_src_delete' => 'Zmylk při zničenju dataje "$1".',
	'webstore_rename' => 'Zmylk při přemjenowanju dataje "$1" do "$2".',
	'webstore_lock_open' => 'Zmylk při wočinjenju blokowaceje dataje "$1".',
	'webstore_lock_close' => 'Zmylk při začinjenju blokowaceje dataje "$1".',
	'webstore_dest_exists' => 'Zmylk, cilowa dataja "$1" eksistuje.',
	'webstore_temp_open' => 'Zmylk při wočinjenju temporerneje dataje "$1".',
	'webstore_temp_copy' => 'Zmylk při kopěrowanju temporerneje dataje "$1" do ciloweje dataje "$2".',
	'webstore_temp_close' => 'Zmylk při začinjenju temporerneje dataje "$1".',
	'webstore_temp_lock' => 'Zmylk při zawrjenju temporerneje dataje "$1".',
	'webstore_no_archive' => 'Cilowa dataja eksistuje a žadyn archiw njebu podaty.',
	'webstore_no_file' => 'Žana dataja njebu nahrata.',
	'webstore_move_uploaded' => 'Zmylk při přesunjenju nahrateje dataje "$1" k nachwilnemu městnu "$2".',
	'webstore_invalid_zone' => 'Njepłaćiwy wobłuk "$1".',
	'webstore_no_deleted' => 'Njebu žadyn archiwowy zapis za zničene dataje definowany.',
	'webstore_curl' => 'Zmylk z cURL: $1',
	'webstore_404' => 'Dataja njenamakana.',
	'webstore_php_warning' => 'Warnowanje PHP: $1',
	'webstore_metadata_not_found' => 'Dataja njenamakana: $1',
	'webstore_postfile_not_found' => 'Dataja, kotraž ma so wotesłać, njebu namakana.',
	'webstore_scaler_empty_response' => 'Wobrazowy skalowar wróći prózdnu wotmołwu z wotmołwnym kodom 200. Přičina móhła ćežki zmylk PHP w skalowarju być.',
	'webstore_invalid_response' => 'Njepłaćiwa wotmołwa ze serwera:

$1',
	'webstore_no_response' => 'Žana wotmołwa ze serwera',
	'webstore_backend_error' => 'Zmylk ze składowanskeho serwera:

$1',
	'webstore_php_error' => 'Zmylki PHP su wustupili:',
	'webstore_no_handler' => 'Žadyn rjadowak, zo by so tutón MIME-typ přetworił',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'inplace_access_disabled' => 'A szolgáltatáshoz való hozzáférés letiltva az összes kliens számára.',
	'inplace_access_denied' => 'Ez a szolgáltatás korlátozott a kliensek IP címe alapján.',
	'inplace_scaler_no_temp' => 'Nincs érvényes ideiglenes könyvtár megadva.
Állítsd a $wgLocalTmpDirectory változót egy írható könyvtárra.',
	'inplace_scaler_not_enough_params' => 'Nincs elegendő paraméter.',
	'inplace_scaler_invalid_image' => 'Érvénytelen kép, nem lehet meghatározni a méretét.',
	'inplace_scaler_failed' => 'Hiba történt a kép átméretezése közben: $1',
	'inplace_scaler_no_handler' => 'Ehhez a MIME-típushoz nincs hozzárendelve kezelő',
	'inplace_scaler_no_output' => 'Nem készült átalakított kimeneti fájl.',
	'inplace_scaler_zero_size' => 'Az átalakítás során nulla méretű kimeneti fájl jött létre.',
	'webstore-desc' => 'Csak webalapú (nem NFS) fájltároló köztesréteg',
	'webstore_access' => 'Ez a szolgáltatás korlátozott kliens IP-címek alapján.',
	'webstore_path_invalid' => 'A fájlnév érvénytelen volt.',
	'webstore_dest_open' => 'Nem lehet megnyitni a(z) „$1” célfájlt.',
	'webstore_dest_lock' => 'Nem sikerült zárolni a(z) „$1” célfájlt.',
	'webstore_dest_mkdir' => 'Nem sikerült létrehozni a(z) „$1” célkönyvtárat.',
	'webstore_archive_lock' => 'Nem sikerült zárolni a(z) „$1” archívumfájlt.',
	'webstore_archive_mkdir' => 'Nem sikerült a(z) „$1” archívumkönyvtár létrehozása.',
	'webstore_src_open' => 'A(z) „$1” forrásfájl nem nyitható meg.',
	'webstore_src_close' => 'Hiba a(z) „$1” forrásfájl bezárásakor.',
	'webstore_src_delete' => 'Hiba a(z) „$1” forrásfájl törlésekor.',
	'webstore_rename' => 'Hiba a fájl átnevezésekor („$1” → „$2”).',
	'webstore_lock_open' => 'Hiba a(z) „$1” zárolófájl megnyitásakor.',
	'webstore_lock_close' => 'Hiba a(z) „$1” zárolófájl bezárásakor.',
	'webstore_dest_exists' => 'Hiba, a(z) „$1” célfájl létezik.',
	'webstore_temp_open' => 'Hiba a(z) „$1” ideiglenes fájl megnyitásakor.',
	'webstore_temp_copy' => 'Hiba a(z) „$1” ideiglenes fájl „$2” célfájlba másolásakor.',
	'webstore_temp_close' => 'Hiba a(z) „$1” ideiglenes fájl bezárása közben.',
	'webstore_temp_lock' => 'Hiba a(z) „$1” ideiglenes fájl zárolásakor.',
	'webstore_no_archive' => 'A célfájl létezik és nincs archívum megadva.',
	'webstore_no_file' => 'Nem lett fájl feltöltve.',
	'webstore_move_uploaded' => 'Hiba a(z) „$1” feltöltött fájl áthelyezésekor a(z) „$2” ideiglenes helyre.',
	'webstore_invalid_zone' => 'Érvénytelen zóna: „$1”.',
	'webstore_no_deleted' => 'Nincs megadva archívumkönyvtár a törölt fájlokhoz.',
	'webstore_curl' => 'Hiba a cURL-ből: $1',
	'webstore_404' => 'A fájl nem található.',
	'webstore_php_warning' => 'PHP figyelmeztetés: $1',
	'webstore_metadata_not_found' => 'A fájl nem található: $1',
	'webstore_postfile_not_found' => 'A feltöltendő fájl nem található.',
	'webstore_scaler_empty_response' => 'A képméretező üres választ adott 200-as válaszkóddal.
Ez lehet végzetes PHP hiba miatt a méretezőben.',
	'webstore_invalid_response' => 'Érvénytelen válasz a szervertől:

$1',
	'webstore_no_response' => 'Nincs válasz a szervertől',
	'webstore_backend_error' => 'Hiba a tárolószervertől:

$1',
	'webstore_php_error' => 'PHP hibák történtek:',
	'webstore_no_handler' => 'Nincs kezelő ennek a MIME-típusnak az átalakításához',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'inplace_access_disabled' => 'Le accesso a iste servicio ha essite disactivate pro tote le clientes.',
	'inplace_access_denied' => 'Iste servicio es restringite per adresse IP de cliente.',
	'inplace_scaler_no_temp' => 'Nulle directorio temporari valide.
Defini $wgLocalTmpDirectory a un directorio scribibile.',
	'inplace_scaler_not_enough_params' => 'Parametros insufficiente.',
	'inplace_scaler_invalid_image' => 'Imagine invalide, non poteva determinar le grandor.',
	'inplace_scaler_failed' => 'Un error esseva incontrate durante le scalamento del imagine: $1',
	'inplace_scaler_no_handler' => 'Nulle gestor pro transformar iste typo MIME',
	'inplace_scaler_no_output' => 'Nulle file de resultato del transformation esseva producite.',
	'inplace_scaler_zero_size' => 'Le transformation produceva un file de resultato a grandor zero.',
	'webstore-desc' => 'Middleware pro le immagazinage de files per Web (non NFS)',
	'webstore_access' => 'Iste servicio es restringite per adresse IP de cliente.',
	'webstore_path_invalid' => 'Le nomine del file es invalide.',
	'webstore_dest_open' => 'Impossibile aperir le file de destination "$1".',
	'webstore_dest_lock' => 'Impossibile serrar le file de destination "$1".',
	'webstore_dest_mkdir' => 'Impossible crear le directorio de destination "$1".',
	'webstore_archive_lock' => 'Impossibile serrar le file de archivo "$1".',
	'webstore_archive_mkdir' => 'Impossibile crear le directorio de archivo "$1".',
	'webstore_src_open' => 'Impossibile aperir le file de origine "$1".',
	'webstore_src_close' => 'Error durante le clausura del file de origine "$1".',
	'webstore_src_delete' => 'Error durante le deletion del file de origine "$1".',
	'webstore_rename' => 'Error durante le renomination del file "$1" a "$2".',
	'webstore_lock_open' => 'Error durante le apertura del file de serratura "$1".',
	'webstore_lock_close' => 'Error durante le clausura del file de serratura "$1".',
	'webstore_dest_exists' => 'Error, le file de destination "$1" existe ja.',
	'webstore_temp_open' => 'Error durante le apertura del file temporari "$1".',
	'webstore_temp_copy' => 'Error durante le copiar del file temporari "$1" verso le file de destination "$2".',
	'webstore_temp_close' => 'Error durante le clausura del file temporari "$1".',
	'webstore_temp_lock' => 'Error durante le serratura del file temporari "$1".',
	'webstore_no_archive' => 'Le file de destination existe ja e nulle archivo esseva date.',
	'webstore_no_file' => 'Nulle file esseva incargate.',
	'webstore_move_uploaded' => 'Error durante le displaciamento del file incargate "$1" verso le location temporari "$2".',
	'webstore_invalid_zone' => 'Zona "$1" invalide.',
	'webstore_no_deleted' => 'Nulle directorio de archivo pro le files delite ha essite definite.',
	'webstore_curl' => 'Error ab cURL: $1',
	'webstore_404' => 'File non trovate.',
	'webstore_php_warning' => 'Advertimento de PHP: $1',
	'webstore_metadata_not_found' => 'File non trovate: $1',
	'webstore_postfile_not_found' => 'File pro inviar non trovate.',
	'webstore_scaler_empty_response' => 'Le scalator de imagines dava un responsa vacue con un codice de responsa 200.
Isto pote esser debite a un error fatal de PHP in le scalator.',
	'webstore_invalid_response' => 'Responsa invalide ab le servitor:

$1',
	'webstore_no_response' => 'Nulle responsa ab le servitor',
	'webstore_backend_error' => 'Error ab le servitor de immagazinage:

$1',
	'webstore_php_error' => 'Errores de PHP esseva incontrate:',
	'webstore_no_handler' => 'Nulle gestor pro transformar iste typo de MIME',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author IvanLanin
 * @author Kandar
 */
$messages['id'] = array(
	'inplace_access_disabled' => 'Akses untuk layanan ini telah dimatikan bagi semua klien.',
	'inplace_access_denied' => 'Layanan ini dibatasi oleh IP klien.',
	'inplace_scaler_no_temp' => 'Tidak ada direktori temporer yang valid.
Setel $wgLocalTmpDirectory ke direktori bisa ditulisi.',
	'inplace_scaler_not_enough_params' => 'Parameter tidak mencukupi.',
	'inplace_scaler_invalid_image' => 'Gambar tak valid; ukuran tak bisa ditentukan.',
	'inplace_scaler_failed' => 'Terjadi kesalahan sewaktu mengubah ukuran berkas: $1',
	'inplace_scaler_no_handler' => 'Tak ada handler untuk mengubah tipe MIME ini',
	'inplace_scaler_no_output' => 'Berkas hasil transformasi tak bisa dibuat.',
	'inplace_scaler_zero_size' => 'Transformasi menghasilkan berkas keluaran berukuran nol.',
	'webstore-desc' => 'Peranti antara penyimpanan berkas hanya-web (non-NFS)',
	'webstore_access' => 'Layanan ini dibatasi oleh IP klien.',
	'webstore_path_invalid' => 'Nama berkas tidak valid.',
	'webstore_dest_open' => 'Tak bisa membuka berkas tujuan "$1".',
	'webstore_dest_lock' => 'Gagal mendapatkan kunci pada berkas tujuan "$1".',
	'webstore_dest_mkdir' => 'Tidak dapat membuat direktori tujuan "$1".',
	'webstore_archive_lock' => 'Gagal mendapatkan kunci pada berkas arsip "$1".',
	'webstore_archive_mkdir' => 'Tidak dapat membuat direktori arsip "$1".',
	'webstore_src_open' => 'Gagal membuka berkas sumber "$1".',
	'webstore_src_close' => 'Kesalahan sewaktu menutup berkas sumber "$1".',
	'webstore_src_delete' => 'Kesalahan sewaktu menghapus berkas sumber "$1".',
	'webstore_rename' => 'Kesalahan sewaktu mengubah nama berkas "$1" menjadi "$2".',
	'webstore_lock_open' => 'Kesalahan sewaktu membuka berkas kunci "$1".',
	'webstore_lock_close' => 'Kesalahan sewaktu menutup berkas kunci "$1".',
	'webstore_dest_exists' => 'Kesalahan, berkas tujuan "$1" sudah ada.',
	'webstore_temp_open' => 'Kesalahan membuka berkas temporer "$1".',
	'webstore_temp_copy' => 'Kesalahan menyalin berkas temporer "$1" ke berkas tujuan "$2".',
	'webstore_temp_close' => 'Kesalahan sewaktu menutup berkas temporer "$1".',
	'webstore_temp_lock' => 'Kesalahan mengunci berkas temporer "$1".',
	'webstore_no_archive' => 'Berkas tujuan sudah ada dan tidak ada arsip yang diberikan.',
	'webstore_no_file' => 'Tidak ada berkas yang diunggah.',
	'webstore_move_uploaded' => 'Kesalahan memindahkan berkas unggahan "$1" ke lokasi temporer "$2".',
	'webstore_invalid_zone' => 'Zona tidak valid "$1".',
	'webstore_no_deleted' => 'Tidak ada direktori arsip untuk berkas terhapus yang ditentukan.',
	'webstore_curl' => 'Kesalahan dari cURL: $1.',
	'webstore_404' => 'Berkas tidak ditemukan.',
	'webstore_php_warning' => 'Peringatan PHP: $1',
	'webstore_metadata_not_found' => 'Berkas tidak ditemukan: $1',
	'webstore_postfile_not_found' => 'Berkas untuk dikirim tidak ditemukan.',
	'webstore_scaler_empty_response' => 'Pengubah skala gambar memberikan respons kosong dengan kode respons 200 respon code.
Ini bisa disebabkan oleh kesalahan fatal PHP pada pengubah skala.',
	'webstore_invalid_response' => 'Respon dari server tidak valid:

$1',
	'webstore_no_response' => 'Tidak ada respons dari server',
	'webstore_backend_error' => 'Kesalahan dari server penyimpanan:

$1',
	'webstore_php_error' => 'Kesalahan PHP ditemukan:',
	'webstore_no_handler' => 'Tidak ada handler untuk mengubah tipe MIME ini',
);

/** Italian (Italiano)
 * @author Darth Kule
 * @author Gianfranco
 */
$messages['it'] = array(
	'inplace_access_disabled' => "L'accesso a questo servizio è stato disabilitato per tutti i client.",
	'inplace_scaler_invalid_image' => 'Immagine non valida, dimensione non riconosciuta.',
	'inplace_scaler_failed' => "Si è verificato un errore durante la miniaturizzazione dell'immagine: $1",
	'webstore_src_open' => 'Impossibile aprire il file di origine "$1".',
	'webstore_no_file' => 'Nessun file è stato caricato.',
	'webstore_404' => 'File non trovato.',
	'webstore_php_warning' => 'Avviso PHP: $1',
	'webstore_metadata_not_found' => 'File non trovato: $1',
	'webstore_no_response' => 'Nessuna risposta dal server',
	'webstore_php_error' => 'Si sono verificati errori PHP:',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'inplace_access_disabled' => 'このサービスへのアクセスは、すべてのクライアントに関して無効になっています。',
	'inplace_access_denied' => 'このサービスはクライアントのIPアドレスによって制限されています。',
	'inplace_scaler_no_temp' => '有効な一時ディレクトリがありません。$wgLocalTmpDirectory に書き込み可能なディレクトリを設定してください。',
	'inplace_scaler_not_enough_params' => '引数が不足しています。',
	'inplace_scaler_invalid_image' => '画像が不正なため、サイズを決定できませんでした。',
	'inplace_scaler_failed' => '画像の拡大縮小中にエラーが発生しました: $1',
	'inplace_scaler_no_handler' => 'このMIME型を変換するためのハンドラーはありません',
	'inplace_scaler_no_output' => '変換出力ファイルは作成されませんでした。',
	'inplace_scaler_zero_size' => '変換処理によって、サイズがゼロの出力ファイルが作成されました。',
	'webstore-desc' => 'ウェブ限定(非NFS)のファイルストレージ用ミドルウェア',
	'webstore_access' => 'このサービスはクライアントのIPアドレスによって制限されています。',
	'webstore_path_invalid' => 'ファイル名が無効です。',
	'webstore_dest_open' => '目的ファイル「$1」を開けません。',
	'webstore_dest_lock' => '目的ファイル「$1」のロック取得に失敗しました。',
	'webstore_dest_mkdir' => '目的ディレクトリ「$1」を作成できません。',
	'webstore_archive_lock' => 'アーカイブファイル「$1」のロック取得に失敗しました。',
	'webstore_archive_mkdir' => 'アーカイブディレクトリ「$1」を作成できません。',
	'webstore_src_open' => '起点ファイル「$1」を開けません。',
	'webstore_src_close' => '起点ファイル「$1」のクローズ中にエラーが発生しました。',
	'webstore_src_delete' => '起点ファイル「$1」の削除中にエラーが発生しました。',
	'webstore_rename' => 'ファイル「$1」から「$2」への改名中にエラーが発生しました。',
	'webstore_lock_open' => 'ロックファイル「$1」のオープン中にエラーが発生しました。',
	'webstore_lock_close' => 'ロックファイル「$1」のクローズ中にエラーが発生しました。',
	'webstore_dest_exists' => 'エラーです、目的ファイル「$1」は存在します。',
	'webstore_temp_open' => '一時ファイル「$1」のオープン中にエラーが発生しました。',
	'webstore_temp_copy' => '一時ファイル「$1」の目的ファイル「$2」への複製中にエラーが発生しました。',
	'webstore_temp_close' => '一時ファイル「$1」のクローズ中にエラーが発生しました。',
	'webstore_temp_lock' => '一時ファイル「$1」のロック中にエラーが発生しました。',
	'webstore_no_archive' => '目的ファイルは存在し、アーカイブは指定されていません。',
	'webstore_no_file' => 'ファイルはアップロードされませんでした。',
	'webstore_move_uploaded' => 'アップロードされたファイル「$1」を一時保管場所「$2」に移動している最中にエラーが発生しました。',
	'webstore_invalid_zone' => 'ゾーン「$1」が不正です。',
	'webstore_no_deleted' => '削除されたファイル用のアーカイブディレクトリが定義されていません。',
	'webstore_curl' => 'cURL のエラー: $1',
	'webstore_404' => 'ファイルが見つかりませんでした。',
	'webstore_php_warning' => 'PHP警告: $1',
	'webstore_metadata_not_found' => 'ファイルが見つかりません: $1',
	'webstore_postfile_not_found' => '投稿すべきファイルは見つかりませんでした。',
	'webstore_scaler_empty_response' => '画像の拡大縮小器が応答コード200で空の応答を返しました。これは拡大縮小器におけるPHPの致命的エラーによるものの可能性があります。',
	'webstore_invalid_response' => 'サーバーからの不正な応答:

$1',
	'webstore_no_response' => 'サーバーからの応答がありません',
	'webstore_backend_error' => 'ストレージサーバーからのエラー:

$1',
	'webstore_php_error' => 'PHPエラーが発生しました:',
	'webstore_no_handler' => 'このMIME型を変換するためのハンドラーはありません',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'inplace_access_disabled' => 'Aksès menyang layanan iki wis ditutup kanggo kabèh panganggo.',
	'inplace_access_denied' => 'Pangladènan iki diwatesi déning klièn IP.',
	'inplace_scaler_no_temp' => "Ora ana dirèktori sauntara sing sah.
Sèt \$wgLocalTmpDirectory menyang dirèktori sing bisa ditulisi (''writeable directory'').",
	'inplace_scaler_not_enough_params' => 'Paramèter ora cukup.',
	'inplace_scaler_invalid_image' => 'Gambar ora absah, ora bisa nemtokaké ukurané.',
	'inplace_scaler_failed' => "Ana kasalahan jroning nykala gambar (''image scalling''): $1",
	'inplace_scaler_no_handler' => "Ora ana ''handler'' kanggo ngowahi tipe MIME iki",
	'inplace_scaler_no_output' => "Ora ana berkas transformasi wetonan (''output'') sing dikasilaké.",
	'inplace_scaler_zero_size' => "Transformasi ngasilaké wetonan (''output'') berkas kanthi ukuran nul (''zero-sized'').",
	'webstore_access' => 'Pangladènan iki diwatesi déning client IP.',
	'webstore_path_invalid' => 'Jeneng berkasé ora absah.',
	'webstore_dest_open' => 'Ora bisa mbuka berkas tujuan "$1".',
	'webstore_dest_lock' => 'Gagal ngunci tujuan berkas "$1".',
	'webstore_dest_mkdir' => 'Ora bisa gawé dirèktori tujuan "$1".',
	'webstore_archive_lock' => 'Gagal ngunci berkas arsip "$1".',
	'webstore_archive_mkdir' => 'Ora bisa gawé dirèktori arsip "$1".',
	'webstore_src_open' => 'Ora bisa buka berkas sumber "$1".',
	'webstore_src_close' => 'Kaluputan nalika nutup berkas sumber "$1".',
	'webstore_src_delete' => 'Ana kaluputan nalika mbusak berkas sumber "$1".',
	'webstore_rename' => 'Kasalahan ganti jeneng berkas "$1" dadi "$2".',
	'webstore_lock_open' => 'Kasalahan mbukak kunci berkas "$1".',
	'webstore_lock_close' => 'Kasalahan nutup kunci berkas "$1".',
	'webstore_dest_exists' => 'Kasalahan, berkas sing dituju "$1" wis ana.',
	'webstore_temp_open' => 'Kasalahan mbukak berkas sauntara "$1".',
	'webstore_temp_copy' => 'Kasalahan nulad berkas sauntara "$1". menyang berkas tujuan "$2".',
	'webstore_temp_close' => 'Ana kaluputan nalika nutup berkas sauntara "$1".',
	'webstore_temp_lock' => 'Kaluputan ngunci berkas sementara "$1".',
	'webstore_no_archive' => 'Berkas tujuan ana lan ora ana arsip sing dituduhaké.',
	'webstore_no_file' => 'Ora ana berkas sing diunggahaké.',
	'webstore_move_uploaded' => 'Kasalahan mindhahaké berkas diunggahaké "$1" menyang lokasi sauntara "$2".',
	'webstore_invalid_zone' => 'Zona invalid "$1".',
	'webstore_no_deleted' => 'Ora ana dirèktori arsip saka berkas sing dibusak.',
	'webstore_curl' => 'Kaluputan saka cURL: $1',
	'webstore_404' => 'Berkas ora ditemokaké.',
	'webstore_php_warning' => 'Pèngetan PHP: $1',
	'webstore_metadata_not_found' => 'Berkas ora ditemokaké: $1',
	'webstore_postfile_not_found' => 'Berkas sing arep didokok ora ditemokaké.',
	'webstore_scaler_empty_response' => "Panyekala gambar (''image scaler'') mènèhi rèspon kothong (''empty response'') kanthi kodhe rèspon 200.
Bab iki bisa waé disebabaké kasalahan fatal PHP ing panyekala.",
	'webstore_invalid_response' => 'Wangsulan ora absah saka server:

$1',
	'webstore_no_response' => 'Ora ana wangsulan saka server',
	'webstore_backend_error' => 'Kaluputan saka server gudhang:

$1',
	'webstore_php_error' => 'Katemu kaluputan PHP:',
	'webstore_no_handler' => "Ora ana ''handler'' kanggo ngowahi (''transforming'') tipe MIME iki",
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'inplace_access_disabled' => 'ការចូលទៅប្រើប្រាស់សេវាកម្មនេះត្រូវបានបិទចំពោះអតិថិជនទាំងអស់។',
	'inplace_access_denied' => 'សេវា​នេះ​មិន​ត្រូវ​បាន​កម្រិត​ដោយ​ម៉ាស៊ីនភ្ញៀវ IP ទេ​។',
	'inplace_scaler_not_enough_params' => 'ប៉ារ៉ាម៉ែត្រមិនគ្រប់គ្រាន់។',
	'inplace_scaler_invalid_image' => 'រូបភាពមិនត្រឹមត្រូវ។ មិនអាចកំណត់ទំហំបាន។',
	'inplace_scaler_failed' => 'កំហុស១បានកើតឡើងក្នុងពេលកំពុងវាស់ទំហំរូបភាព៖ $1',
	'webstore_access' => 'សេវា​នេះ​មិន​ត្រូវ​បាន​កម្រិត​ដោយ​ម៉ាស៊ីនភ្ញៀវ IP ទេ​។',
	'webstore_path_invalid' => 'ឈ្មោះឯកសារមិនត្រឹមត្រូវ។',
	'webstore_dest_open' => 'មិនអាចបើកឯកសារគោលដៅ "$1"ទេ។',
	'webstore_archive_mkdir' => 'មិនអាច បង្កើត បញ្ជី បណ្ណសារ "$1" ។',
	'webstore_src_open' => 'មិនអាចបើកឯកសារប្រភព "$1" ទេ។',
	'webstore_src_close' => 'កំហុសក្នុងការបិទឯកសារប្រភព "$1" ។',
	'webstore_src_delete' => 'កំហុសក្នុងការលុបចោលឯកសារប្រភព "$1" ។',
	'webstore_rename' => 'កំហុសក្នុងការប្ដូរឈ្មោះឯកសារ "$1" ទៅជា "$2"។',
	'webstore_lock_open' => 'កំហុស​ក្នុង​ការបើកសោ​ឯកសារ "$1" ។',
	'webstore_lock_close' => 'កំហុស​ក្នុង​ការចាក់សោ​ឯកសារ "$1" ។',
	'webstore_dest_exists' => 'កំហុស! ឯកសារគោលដៅ "$1" មានរួចហើយ។',
	'webstore_temp_open' => 'កំហុសក្នុងការបើកឯកសារបណ្ដោះអាសន្ន "$1"។',
	'webstore_temp_copy' => 'កំហុសក្នុងការថតចម្លងឯកសារបណ្ដោះអាសន្ន "$1" ទៅកាន់ឯកសារគោលដៅ "$2"។',
	'webstore_temp_close' => 'កំហុសក្នុងការបិទឯកសារបណ្ដោះអាសន្ន "$1"។',
	'webstore_temp_lock' => 'កំហុសក្នុងការចាក់សោឯកសារបណ្ដោះអាសន្ន "$1"។',
	'webstore_no_file' => 'គ្មានឯកសារ ​បានត្រូវផ្ទុកឡើង ។',
	'webstore_move_uploaded' => 'កំហុសក្នុងការប្ដូរទីតាំងឯកសារដែលបានផ្ទុកឡើង "$1" ទៅកាន់ទីតាំងបណ្ដោះអាសន្ន "$2"។',
	'webstore_invalid_zone' => 'តំបន់មិនត្រឹមត្រូវ "$1"។',
	'webstore_curl' => 'កំហុសពី cURL: $1',
	'webstore_404' => 'រកមិនឃើញឯកសារទេ។',
	'webstore_php_warning' => 'ការព្រមាន PHP: $1',
	'webstore_metadata_not_found' => 'រកមិនឃើញ ឯកសារ ៖ $1',
	'webstore_invalid_response' => 'កំហុស​ឆ្លើយតប​ពី​ម៉ាស៊ីនបម្រើសេវា​៖

$1',
	'webstore_no_response' => 'គ្មានចម្លើយតប​ពី​ម៉ាស៊ីនបម្រើសេវា',
	'webstore_backend_error' => 'កំហុស​ពី​ឧបករណ៍ផ្ទុក​នៃ​ម៉ាស៊ីនបម្រើសេវា​៖

$1',
	'webstore_php_error' => 'មានកំហុស PHP:',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'inplace_access_disabled' => 'Dä Zohjang noh hee dämm Deenß es ußjeschalldt för Alle.',
	'inplace_access_denied' => 'Dä Deens hee es beschrängk op bestemmpte IP-Addräße.',
	'inplace_scaler_no_temp' => 'Mer han kei Verzeijschneß för jet zweschezeshpeischere.
Maach, dat <code>$wgLocalTmpDirectory</code> op e Verzeijschneß zeich,
wo mer erin schrieve künne.',
	'inplace_scaler_not_enough_params' => 'Nit jenooch Parammeetere.',
	'inplace_scaler_invalid_image' => 'Dat Belld es kapott, mer kunnte nit eruß fenge, wi jruuß dat dat es.',
	'inplace_scaler_failed' => 'Enne Fähler es opjedouch, wi mer hee dat Belld jrüüßer ov kleiner maache wullte: $1',
	'inplace_scaler_no_handler' => 'Mer han keij Projramm för hee dä <i lang="en">MIME</i>-Tüp ömzewandelle.',
	'inplace_scaler_no_output' => 'Beim Ömwandelle es kei Datei erus jekumme.',
	'inplace_scaler_zero_size' => 'Beim Ömwandelle es en Datei met nix dren eruß jekumme.',
	'webstore-desc' => 'En <i lang="en">middelware</i> för et Web (ävver nit <i lang="en">NFS</i>) för Dateie ze speichere.',
	'webstore_access' => 'Dä Deens hee es beschrängk op bestemmpte IP-Addräße.',
	'webstore_path_invalid' => 'Dä Name för di Datei es Kappes.',
	'webstore_dest_open' => 'Mer künne di Ziel-Datei „$1“ nit opmaache.',
	'webstore_dest_lock' => 'Mer künne de Ziel-Datei „$1“ nit sperre.',
	'webstore_dest_mkdir' => 'Mer künne dat Ziel-Verzeichnis „$1“ nit aanläje.',
	'webstore_archive_lock' => 'Mer künne de Aschiiv-Datei „$1“ nit sperre.',
	'webstore_archive_mkdir' => 'Mer künne dat Aschiiv-Verzeichnis „$1“ nit aanläje.',
	'webstore_src_open' => 'Mer künne de Quell-Datei „$1“ nit opmaache.',
	'webstore_src_close' => 'Mer künne de Quell-Datei „$1“ nit zomaache.',
	'webstore_src_delete' => 'Mer künne de Quell-Datei „$1“ nit fottmaache.',
	'webstore_rename' => 'Mer künne de Datei „$1“ nit op „$2“ ömnenne.',
	'webstore_lock_open' => 'Mer künne de Schotz-Datei „$1“ nit opmaache.',
	'webstore_lock_close' => 'Mer künne de Schotz-Datei „$1“ nit zomaache.',
	'webstore_dest_exists' => 'Fähler, de Ziel-Datei „$1“ jidd_et ald.',
	'webstore_temp_open' => 'Mer künne de Zwesche-Datei „$1“ nit opmaache.',
	'webstore_temp_copy' => 'Mer künne de Zwesche-Datei „$1“ nit op de Zieldate „$2“ ömkopeere.',
	'webstore_temp_close' => 'Mer künne de Zwesche-Datei „$1“ nit zomaache.',
	'webstore_temp_lock' => 'Mer künne de Zwesche-Datei „$1“ nit sperre.',
	'webstore_no_archive' => 'De Zieldatei es ald do, un en Aschiiv-Datei wohr nit aanjejovve.',
	'webstore_no_file' => 'Et wwod kei Datei huhjelade.',
	'webstore_move_uploaded' => 'Et hät nit jeklapp, de neu huhjelade Datei fun „$1“ op „$2“, dä Name fum Zwescheshpeijscher, ömzedäufe.',
	'webstore_invalid_zone' => 'Onjöltijje Bereisch — „$1“.',
	'webstore_no_deleted' => 'Mer han kei Aschiiv-Verzeijschneß för fottjeschmeße Dateie ennjestellt.',
	'webstore_curl' => 'Ene Fähler fum <code>cURL</code> es opjevalle: $1',
	'webstore_404' => 'Datei nit jefunge.',
	'webstore_php_warning' => 'PHP Warnung: $1',
	'webstore_metadata_not_found' => 'Datei nit jefonge: $1',
	'webstore_postfile_not_found' => 'De Dattei för huhzelade (met <i lang="en">post</i>) ham_mer nit jefonge.',
	'webstore_scaler_empty_response' => 'Dat Projramm för Bellder ze Verjrüüßere ov ze Verkleijnere
hät en Antwoot met enem <code>200-er Kood</code> jejovve.
Dat künnt fun enem schlemme PHP-Fähler en dämm Projramm kumme.',
	'webstore_invalid_response' => 'En onjöltije Antwoot fum Server:

$1',
	'webstore_no_response' => 'Kei Antwoot fun Server',
	'webstore_backend_error' => 'Dä <i lang="en">server</i> för Dateie ze speijschere meldt ene Fähler:

$1',
	'webstore_php_error' => 'Et sin PHP Fähler opjetrodde:',
	'webstore_no_handler' => 'Kei Projramm för et Ömwandelle för dä <i lang="en">MIME</i> tüp',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'inplace_access_disabled' => 'Den Zougang zu dësem Service gouf fir all Cliente gespaart.',
	'inplace_access_denied' => 'Dëse Service ass limitéiert wéinst der IP-Adress vum Client.',
	'inplace_scaler_not_enough_params' => 'Net genuch Parameteren.',
	'inplace_scaler_invalid_image' => "Net valabelt Bild, d'Gréisst konnt net festgestallt ginn",
	'inplace_scaler_failed' => 'Beim Redimensionéiere vum Bild ass e Feeler geschitt: $1',
	'inplace_scaler_no_handler' => 'Et gëtt keng Funktioun ("handler") fir dësen Typ vu MIME ëmzewandelen',
	'inplace_scaler_zero_size' => 'Bei der Ëmwandlung gouf en eidele Fichier generéiert.',
	'webstore_access' => 'Dëse Service ass pro IP-Adress limitéiert.',
	'webstore_path_invalid' => 'Den Numm vum Fichier war ongëlteg.',
	'webstore_dest_open' => 'Zildatei "$1" kann net opgemaach ginn.',
	'webstore_dest_lock' => 'Zildatei "$1" kann net gespaart ginn.',
	'webstore_src_open' => 'De Quellfichier "$1" konnt net opgemaach ginn.',
	'webstore_src_close' => 'Feeler bein Zoumaache vum Quellfichier "$1".',
	'webstore_src_delete' => 'Feeler beim Läsche vum Quellfichier "$1".',
	'webstore_rename' => 'Feeler beim Ëmbenenne vum Fichier "$1" op "$2".',
	'webstore_lock_open' => 'Feeler beim Opmaache vum gespaarte Fichier "$1".',
	'webstore_lock_close' => 'Feeler beim Zoumaache vum gespaarte Fichier "$1".',
	'webstore_dest_exists' => 'Feeler, den Zilfichier "$1" gëtt et.',
	'webstore_temp_open' => 'Feeler beim Opmaache vum temporäre Fichier "$1".',
	'webstore_temp_copy' => 'Feeler beim Kopéiere vum temporäre Fichier "$1" op den Zilfichier "$2".',
	'webstore_temp_close' => 'Feeler beim Zoumaache vum temporäre Fichier "$1".',
	'webstore_temp_lock' => 'Feeler beim Zoumaache vum tempräre Fichier "$1".',
	'webstore_no_archive' => 'Den Destinatiounsfichier existéiert an et gouf keen Archiv uginn.',
	'webstore_no_file' => 'Et gouf kee Fichier eropgelueden.',
	'webstore_move_uploaded' => 'Feeler beim eropgeluedene Fichier "$1" op d\'Tëschespäicherplaz "$2".',
	'webstore_invalid_zone' => 'Zon "$1" ass net valabel',
	'webstore_curl' => 'Feeler vun cURL: $1',
	'webstore_404' => 'De Fichier gouf net fonnt.',
	'webstore_php_warning' => 'PHP Warnung: $1',
	'webstore_metadata_not_found' => 'De Fichier $1 gouf net fonnt',
	'webstore_postfile_not_found' => 'De Fichier fir ze schécke gof net fonnt',
	'webstore_invalid_response' => 'Ongëlteg Äntwert vum Server:

$1',
	'webstore_no_response' => 'De Server äntwert net',
	'webstore_backend_error' => 'Feeler vum Server op dem Date gespäichert ginn:

$1',
	'webstore_php_error' => 'Dës PHP Feeler sinn opgetratt:',
	'webstore_no_handler' => 'Dësen Typ vu MIME kann net ëmgewandelt ginn',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'inplace_access_disabled' => 'Пристапот до оваа услуга е оневозможен за сите клиенти.',
	'inplace_access_denied' => 'Оваа услуга е ограничена по клиентска IP-адреса.',
	'inplace_scaler_no_temp' => 'Нема важечки привремен директориум.
Параметарот $wgLocalTmpDirectory треба да има назначено директориум на кој може да се запишува.',
	'inplace_scaler_not_enough_params' => 'Нема доволно параметри.',
	'inplace_scaler_invalid_image' => 'Неважечка слика; не може да се одреди големината.',
	'inplace_scaler_failed' => 'Се појави грешка при размерувањето на сликата: $1',
	'inplace_scaler_no_handler' => 'Нема обрасботувач за трансформирање на овој MIME-тип',
	'inplace_scaler_no_output' => 'Не беше создадена излезна податотека од трансформацијата.',
	'inplace_scaler_zero_size' => 'Трансформацијата даде излезна податотека со нулта големина.',
	'webstore-desc' => 'Само за мрежно складирање на податотеки (не NFS)',
	'webstore_access' => 'Оваа услуга е ограничена по клиентска IP-адреса.',
	'webstore_path_invalid' => 'Името на податотеката е погрешно.',
	'webstore_dest_open' => 'Не можам да ја отворам целната податотека „$1“.',
	'webstore_dest_lock' => 'Не успеав да ја заклучам целната податотека „$1“',
	'webstore_dest_mkdir' => 'Не може да се создаде целниот именик „$1“.',
	'webstore_archive_lock' => 'Не можев да ја заклучам архивската податотека „$1“',
	'webstore_archive_mkdir' => 'Не може да се создаде архивски именик „$1“.',
	'webstore_src_open' => 'Не можам да ја отворам изворната податотека „$1“',
	'webstore_src_close' => 'Грешка при затворањето на изворната податотека „$1“',
	'webstore_src_delete' => 'Грешка при бришењето на изворната податотека „$1“.',
	'webstore_rename' => 'Грешка при преименувањето наподатотеката „$1“ во „$2“.',
	'webstore_lock_open' => 'Грешка при отворањето на податотеката за заклучување „$1“.',
	'webstore_lock_close' => 'Грешка при затворањето на податотеката за заклучување „$1“.',
	'webstore_dest_exists' => 'Грешка, целната податотека „$1“ постои.',
	'webstore_temp_open' => 'Грешка при отворањето на привремената податотека „$1“.',
	'webstore_temp_copy' => 'Грешка при копирањето на привремената податотека „$1“ во целната податотека „$2“.',
	'webstore_temp_close' => 'Грешка при завторањето на привремената податотека „$1“.',
	'webstore_temp_lock' => 'Грешка при заклучувањето на привремената податотека „$1“.',
	'webstore_no_archive' => 'Целната податотека постои, а нема посочено архив.',
	'webstore_no_file' => 'Нема подигната податотека.',
	'webstore_move_uploaded' => 'Грешка при преместувањето на подигнатата податотека „$1“ на привременото место „$2“.',
	'webstore_invalid_zone' => 'Неважечка зона „$1“',
	'webstore_no_deleted' => 'Нема определено архивски директориум за избришаните податотеки.',
	'webstore_curl' => 'Грешка од cURL: $1',
	'webstore_404' => 'Податотеката не е најдена.',
	'webstore_php_warning' => 'PHP Предупредување: $1',
	'webstore_metadata_not_found' => 'Податотеката не е најдена: $1',
	'webstore_postfile_not_found' => 'Нема пронајдено податотека за испраќање.',
	'webstore_scaler_empty_response' => 'Размерувачот даде празен одговор со код 200.
Ова може да се должи на PHP фатална грешка во размерувачот.',
	'webstore_invalid_response' => 'Неважечки одговор од опслужувачот:

$1',
	'webstore_no_response' => 'Нема одговор од опслужувачот',
	'webstore_backend_error' => 'Грешка од складишниот опслужувач:

$1',
	'webstore_php_error' => 'Се јавија следните PHP грешки:',
	'webstore_no_handler' => 'Нема обработувач за трансформирање на овој MIME-тип',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'inplace_scaler_invalid_image' => 'അസാധുവായ ചിത്രം, വലിപ്പം നിർണ്ണയിക്കാൻ കഴിഞ്ഞില്ല.',
	'webstore_path_invalid' => 'പ്രമാണത്തിന്റെ പേര്‌ അസാധുവാണ്‌.',
	'webstore_src_open' => '"$1" എന്ന മൂലപ്രമാണം തുറക്കുവാൻ കഴിഞ്ഞില്ല',
	'webstore_src_close' => '"$1" എന്ന മൂലപ്രമാണം അടയ്ക്കുമ്പോൾ പിഴവ് സംഭവിച്ചു.',
	'webstore_src_delete' => '"$1" എന്ന മൂല പ്രമാണം മായ്ക്കുമ്പോൾ പഴവ് സംഭവിച്ചു.',
	'webstore_rename' => '"$1" എന്ന പ്രമാണം  "$2" എന്നു പുനഃനാമകരണം നടത്തുമ്പോൾ പിഴവ് സംഭവിച്ചു.',
	'webstore_dest_exists' => 'പിഴവ്, "$1" എന്ന ലക്ഷ്യപ്രമാണം നിലവിലുണ്ട്.',
	'webstore_temp_open' => '"$1" എന്ന താൽക്കാലിക പ്രമാണം തുറക്കുന്നതിൽ പിഴവ്.',
	'webstore_temp_copy' => '"$1" എന്ന താൽക്കാലിക പ്രമാണം "$2" എന്ന ലക്ഷ്യപ്രമാണത്തിലേക്കു പകർത്തുന്നതിൽ പിഴവ് സംഭവിച്ചു.',
	'webstore_temp_close' => '"$1" എന്ന താൽക്കാലിക പ്രമാണം അടയ്ക്കുന്നതിൽ പിഴവ്.',
	'webstore_no_file' => 'പ്രമാണമൊന്നും അപ്‌ലോഡ് ചെയ്തിട്ടില്ല.',
	'webstore_invalid_zone' => 'അസാധുവായ മേഖല "$1".',
	'webstore_404' => 'പ്രമാണം കണ്ടില്ല.',
	'webstore_metadata_not_found' => 'പ്രമാണം കണ്ടില്ല: $1',
	'webstore_no_response' => 'സെർ‌വറിൽ നിന്നു മറുപടിയൊന്നും ലഭിച്ചില്ല',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'inplace_access_denied' => 'ही सेवा क्लायंट आयपीने थांबविलेली आहे.',
	'inplace_scaler_no_temp' => 'योग्य तात्पुरती डिरेक्टरी नाही.
$wgLocalTmpDirectory ची किंमत योग्य अशा डिरेक्टरीने बदला.',
	'inplace_scaler_not_enough_params' => 'पुरेसे परमीटर्स नाहीत.',
	'inplace_scaler_invalid_image' => 'चुकीचे चित्र, आकार निश्चित करता आलेला नाही.',
	'webstore_access' => 'ही सेवा क्लायंट आयपीने थांबविलेली आहे.',
	'webstore_path_invalid' => 'संचिकानाव चुकीचे होते.',
	'webstore_dest_open' => 'लक्ष्य संचिका उघडू शकत नाही "$1".',
	'webstore_dest_lock' => 'लक्ष्य संचिकेला कुलुप लावता आलेले नाही "$1".',
	'webstore_dest_mkdir' => 'लक्ष्य डिरेक्टरी तयार करू शकलेलो नाही "$1".',
	'webstore_archive_lock' => 'आर्चिव्ह संचिकेला कुलुप लावता आलेले नाही "$1".',
	'webstore_archive_mkdir' => 'आर्चिव्ह डिरेक्टरी तयार करता आलेली नाही "$1".',
	'webstore_src_open' => 'स्रोत संचिका उघडता आलेली नाही "$1".',
	'webstore_src_close' => 'स्रोत संचिका बंद करण्यामध्ये त्रुटी "$1".',
	'webstore_src_delete' => 'स्रोत संचिका वगळण्यामध्ये त्रुटी "$1".',
	'webstore_rename' => 'संचिका "$1" चे नाव "$2" ला बदलण्यामध्ये त्रुटी.',
	'webstore_lock_open' => 'कुलुपबंद संचिका "$1" उघडण्यामध्ये त्रुटी.',
	'webstore_lock_close' => 'कुलुपबंद संचिका "$1" बंद करण्यामध्ये त्रुटी.',
	'webstore_dest_exists' => 'त्रुटी, लक्ष्य डिरेक्टरी "$1" अगोदरच अस्तित्वात आहे.',
	'webstore_temp_open' => 'तात्पुरती संचिका "$1" उघडण्यामध्ये त्रुटी.',
	'webstore_temp_copy' => 'तात्पुरती संचिका "$1" ची प्रत "$2" मध्ये करण्यात त्रुटी.',
	'webstore_temp_close' => 'तात्पुरती संचिका "$1" बंद करण्यामध्ये त्रुटी.',
	'webstore_temp_lock' => 'तात्पुरती संचिका "$1" ला कुलुप लावण्यात त्रुटी.',
	'webstore_no_file' => 'कोणतीही संचिका चढवली नाही',
	'webstore_invalid_zone' => 'चुकीचा झोन "$1".',
	'webstore_no_deleted' => 'वगळलेल्या संचिकांसाठी आर्चिव्ह डिरेक्टरी सांगितलेली नाही.',
	'webstore_curl' => ' cURL मध्ये त्रुटी: $1',
	'webstore_404' => 'संचिका सापडली नाही.',
	'webstore_php_warning' => 'PHP इशारा: $1',
	'webstore_metadata_not_found' => 'संचिका सापडली नाही: $1',
	'webstore_no_response' => 'सर्व्हरकडून उत्तर नाही',
	'webstore_php_error' => 'PHP त्रुट्या आलेल्या आहेत:',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'inplace_access_disabled' => 'Akses kepada perkhidmatan ini telah dimatikan untuk semua klien.',
	'inplace_access_denied' => 'Perkhidmatan ini disekat oleh IP klien.',
	'inplace_scaler_no_temp' => 'Tiada direktori sementara yang sah.
Tetapkan $wgLocalTmpDirectory kepada direktori yang boleh tulis.',
	'inplace_scaler_not_enough_params' => 'Parameter tidak cukup.',
	'inplace_scaler_invalid_image' => 'Imej tidak sah, saiz tidak dapat ditentukan.',
	'inplace_scaler_failed' => 'Berlakunya ralat sewaktu mengubah skala fail: $1',
	'inplace_scaler_no_handler' => 'Tiada pengelola untuk mentransformasikan jenis MIME ini',
	'inplace_scaler_no_output' => 'Tiada fail output transformasi yang dihasilkan.',
	'inplace_scaler_zero_size' => 'Transformasi menghasilkan fail output yang bersaiz kosong.',
	'webstore-desc' => 'Perisian tengah (middleware) storan fail dalam Web sahaja (bukan NFS)',
	'webstore_access' => 'Perkhidmatan ini disekat oleh IP klien.',
	'webstore_path_invalid' => 'Nama fail tidak sah.',
	'webstore_dest_open' => 'Fail destinasi "$1" tidak dapat dibuka.',
	'webstore_dest_lock' => 'Fail destinasi "$1" gagal diperoleh kuncinya.',
	'webstore_dest_mkdir' => 'Direktori destinasi "$1" gagal diwujudkan.',
	'webstore_archive_lock' => 'Fail arkib "$1" gagal diperoleh kuncinya.',
	'webstore_archive_mkdir' => 'Direktori arkib "$1" gagal diwujudkan.',
	'webstore_src_open' => 'Fail sumber "$1" tidak dapat dibuka.',
	'webstore_src_close' => 'Ralat ketika menutup fail sumber "$1".',
	'webstore_src_delete' => 'Ralat ketika menghapuskan fail sumber "$1".',
	'webstore_rename' => 'Ralat ketika mengubah nama fail "$1" kepada "$2".',
	'webstore_lock_open' => 'Ralat ketika membuka fail kunci "$1".',
	'webstore_lock_close' => 'Ralat ketika menutup fail kunci "$1".',
	'webstore_dest_exists' => 'Ralat, fail destinasi "$1" wujud.',
	'webstore_temp_open' => 'Ralat ketika membuka fail sementara "$1".',
	'webstore_temp_copy' => 'Ralat ketika menyalin fail sementara "$1" kepada fail destinasi "$2".',
	'webstore_temp_close' => 'Ralat ketika menutup fail sementara "$1".',
	'webstore_temp_lock' => 'Ralat ketika mengunci fail sementara "$1".',
	'webstore_no_archive' => 'Fail destinasi wujud tetapi tidak diberi arkib.',
	'webstore_no_file' => 'Tiada fail yang dimuat naik.',
	'webstore_move_uploaded' => 'Ralat ketika memindahkan fail termuat naik "$1" kepada lokasi sementara "$2".',
	'webstore_invalid_zone' => 'Zon "$1" tidak sah.',
	'webstore_no_deleted' => 'Tiada direktori arkib yang ditetapkan untuk fail-fail yang dihapuskan.',
	'webstore_curl' => 'Ralat dari cURL: $1',
	'webstore_404' => 'Fail tidak dijumpai.',
	'webstore_php_warning' => 'Amaran PHP: $1',
	'webstore_metadata_not_found' => 'Fail tidak dijumpai: $1',
	'webstore_postfile_not_found' => 'Fail yang ingin diposkan tidak dijumpai.',
	'webstore_scaler_empty_response' => 'Penskala imej memberikan gerak balas yang kosong dengan kod gerak balas 200.
Ini mungkin disebabkan oleh ralat mati PHP dalam penskala.',
	'webstore_invalid_response' => 'Gerak balas dari pelayan tidak sah:

$1',
	'webstore_no_response' => 'Tiada gerak balas dari pelayan',
	'webstore_backend_error' => 'Ralat dari pelayan storan:

$1',
	'webstore_php_error' => 'Ralat PHP ditemui:',
	'webstore_no_handler' => 'Tiada pengelola untuk mentransformasikan jenis MIME ini',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'webstore_404' => 'Файлась а муеви',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'webstore_path_invalid' => 'Ahcualli tlahcuilōltōcāitl',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'inplace_access_disabled' => 'Tilgangen til denne tjenesten har blitt slått av for alle klienter.',
	'inplace_access_denied' => 'Denne tjenesten begrenses av klientens IP.',
	'inplace_scaler_no_temp' => 'Ingen gyldig midlertidig mappe, sett $wgLocalTmpDirectory til en skrivbar mappe.',
	'inplace_scaler_not_enough_params' => 'Ikke not parametere.',
	'inplace_scaler_invalid_image' => 'Ugyldig bilde, kunne ikke fastslå størrelse.',
	'inplace_scaler_failed' => 'En feil oppsto under bildeskalering: $1',
	'inplace_scaler_no_handler' => 'Ingen behandler for endring av denne MIME-typen',
	'inplace_scaler_no_output' => 'Ingen endringsresultatfil ble produsert.',
	'inplace_scaler_zero_size' => 'Endringen produserte en tom resultatfil.',
	'webstore-desc' => 'Internettbasert (ikke-NFS) fillagringsmellomvare',
	'webstore_access' => 'Tjenesten begrenses av klientens IP.',
	'webstore_path_invalid' => 'Filnavnet var ugyldig.',
	'webstore_dest_open' => 'Kunne ikke åpne målfil «$1».',
	'webstore_dest_lock' => 'Kunne ikke låses på målfil «$1».',
	'webstore_dest_mkdir' => 'Kunne ikke opprette målmappe «$1».',
	'webstore_archive_lock' => 'Kunne ikke låses på arkivfil «$1».',
	'webstore_archive_mkdir' => 'Kunne ikke opprette arkivmappe «$1».',
	'webstore_src_open' => 'Kunne ikke åpne kildefil «$1».',
	'webstore_src_close' => 'Feil under lukking av kildefil «$1».',
	'webstore_src_delete' => 'Feil under sletting av kildefil «$1».',
	'webstore_rename' => 'Feil under omdøping av «$1» til «$2».',
	'webstore_lock_open' => 'Feil under åpning av låsfil «$1».',
	'webstore_lock_close' => 'Feil under lukking av låsfil «$1».',
	'webstore_dest_exists' => 'Feil, målfilen «$1» finnes.',
	'webstore_temp_open' => 'Feil under åpning av midlertidig fil «$1».',
	'webstore_temp_copy' => 'Feil under kopiering av midlertidig fil «$1» til målfil «$2».',
	'webstore_temp_close' => 'Feil under lukking av midlertidig fil «$1».',
	'webstore_temp_lock' => 'Feil under låsing av midlertidig fil «$1».',
	'webstore_no_archive' => 'Målfilen finnes og ikke noe arkiv ble gitt.',
	'webstore_no_file' => 'Ingen fil ble lastet opp.',
	'webstore_move_uploaded' => 'Feil under flytting av opplastet fil «$1» til midlertidig sted «$2».',
	'webstore_invalid_zone' => 'Ugyldig sone «$1».',
	'webstore_no_deleted' => 'Ingen arkivmappe for slettede filer er angitt.',
	'webstore_curl' => 'Feil fra cURL: $1',
	'webstore_404' => 'Fil ikke funnet.',
	'webstore_php_warning' => 'PHP-advarsel: $1',
	'webstore_metadata_not_found' => 'Fil ikke funnet: $1',
	'webstore_postfile_not_found' => 'Fil  som skal postes ikke funnet.',
	'webstore_scaler_empty_response' => 'Bildeskalereren ga et tomt svar med en 200-responskode. Dette kan være på grunn av en fatal PHP-feil i  skalereren.',
	'webstore_invalid_response' => 'Ugyldig svar fra tjener:

$1',
	'webstore_no_response' => 'Ingen respons fra tjener.',
	'webstore_backend_error' => 'Feil fra lagringstjener:

$1',
	'webstore_php_error' => 'PHP-feil ble funnet:',
	'webstore_no_handler' => 'Ingen behandler for endring av denne MIME-typen',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'inplace_scaler_not_enough_params' => 'Nich noog Parameters.',
	'webstore_404' => 'Datei nich funnen.',
);

/** Dutch (Nederlands)
 * @author Siebrand
 * @author Tvdm
 */
$messages['nl'] = array(
	'inplace_access_disabled' => 'Toegang tot deze dienst is uitgeschakeld voor alle clients.',
	'inplace_access_denied' => 'Deze dienst is afgeschermd op basis van het IP-adres van een client.',
	'inplace_scaler_no_temp' => 'Geen juiste tijdelijke map, geef schrijfrechten op $wgLocalTmpDirectory.',
	'inplace_scaler_not_enough_params' => 'Niet genoeg parameters.',
	'inplace_scaler_invalid_image' => 'Onjuiste afbeelding. Grootte kon niet bepaald worden.',
	'inplace_scaler_failed' => 'Er is een fout opgetreden bij het schalen van de afbeelding: $1',
	'inplace_scaler_no_handler' => 'Dit MIME-type kan niet getransformeerd worden',
	'inplace_scaler_no_output' => 'Er is geen uitvoerbestand voor de transformatie gemaakt.',
	'inplace_scaler_zero_size' => 'De grootte van het uitvoerbestand van de transformatie was nul.',
	'webstore-desc' => 'Alleen-web middleware voor bestandsopslag (niet via NFS)',
	'webstore_access' => 'Deze dienst is afgeschermd op basis van het IP-adres van een client.',
	'webstore_path_invalid' => 'De bestandnaam was ongeldig.',
	'webstore_dest_open' => 'Het doelbestand "$1" kon niet geopend worden.',
	'webstore_dest_lock' => 'Het doelbestand "$1" was niet te locken.',
	'webstore_dest_mkdir' => 'De doelmap "$1" kon niet aangemaakt worden.',
	'webstore_archive_lock' => 'Het archiefbestand "$1" was niet te locken.',
	'webstore_archive_mkdir' => 'De archiefmap "$1" kon niet aangemaakt worden.',
	'webstore_src_open' => 'Het bronbestand "$1" was niet te openen.',
	'webstore_src_close' => 'Fout bij het sluiten van bronbestand "$1".',
	'webstore_src_delete' => 'Fout bij het verwijderen van bronbestand "$1".',
	'webstore_rename' => 'Fout bij het hernoemen van "$1" naar "$2".',
	'webstore_lock_open' => 'Fout bij het openen van lockbestand "$1".',
	'webstore_lock_close' => 'Fout bij het sluiten van lockbestand "$1".',
	'webstore_dest_exists' => 'Fout, doelbestand "$1" bestaat al.',
	'webstore_temp_open' => 'Fout bij het openen van tijdelijk bestand "$1".',
	'webstore_temp_copy' => 'Fout bij het kopiren van tijdelijk bestand "$1" naar doelbestand "$2".',
	'webstore_temp_close' => 'Fout bij het sluiten van tijdelijk bestand "$1".',
	'webstore_temp_lock' => 'Fout bij het locken van tijdelijk bestand "$1".',
	'webstore_no_archive' => 'Doelbestand bestaat en er is geen archief opgegeven.',
	'webstore_no_file' => 'Er is geen bestand geüpload.',
	'webstore_move_uploaded' => 'Fout bij het verplaatsen van geüpload bestand "$1" naar tijdelijke locatie "$2".',
	'webstore_invalid_zone' => 'Ongeldige zone "$1".',
	'webstore_no_deleted' => 'Er is geen archiefmap voor verwijderde bestanden gedefinieerd.',
	'webstore_curl' => 'Fout van cURL: $1',
	'webstore_404' => 'Bestand niet gevonden.',
	'webstore_php_warning' => 'PHP-waarschuwing: $1',
	'webstore_metadata_not_found' => 'Bestand niet gevonden: $1',
	'webstore_postfile_not_found' => 'Te posten bestand niet gevonden.',
	'webstore_scaler_empty_response' => 'De afbeeldingenschaler gaf een leeg antwoord met een antwoordcode 200. Dit kan te maken hebben met een fatale PHP-fout in de schaler.',
	'webstore_invalid_response' => 'Ongeldig antwoord van de server:

$1',
	'webstore_no_response' => 'Geen antwoord van de server',
	'webstore_backend_error' => 'Fout van de opslagserver:

$1',
	'webstore_php_error' => 'Er zijn PHP-fouten opgetreden:',
	'webstore_no_handler' => 'Dit MIME-type kan niet getransformeerd worden',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Frokor
 * @author Harald Khan
 */
$messages['nn'] = array(
	'inplace_access_disabled' => 'Tilgangen til denne tenesta er slått av for alle klientar.',
	'inplace_access_denied' => 'Denne tenesta er avgrensa av IP-adressa til klienten.',
	'inplace_scaler_no_temp' => 'Inga gyldig mellombels mappe, sett $wgLocalTmpDirectory til ei skrivbar mappe.',
	'inplace_scaler_not_enough_params' => 'For få parametrar.',
	'inplace_scaler_invalid_image' => 'Ugyldig bilete, kunne ikkje fastslå storleik.',
	'inplace_scaler_failed' => 'Ein feil oppstod under biletskalering: $1',
	'inplace_scaler_no_handler' => 'Ingen handsamar for endring av denne MIME-typen',
	'inplace_scaler_no_output' => 'Inga endringsresultatfil vart produsert.',
	'inplace_scaler_zero_size' => 'Endringa skapte ei tom resultatfil.',
	'webstore-desc' => 'Internettbasert  (ikkje-NFS) fillagringsmellomvara',
	'webstore_access' => 'Tenesta er avgrensa av IP-adressa til klienten.',
	'webstore_path_invalid' => 'Filnamnet var ugyldig.',
	'webstore_dest_open' => 'Kunne ikkje opne målfil «$1».',
	'webstore_dest_lock' => 'Kunne ikkje låsast på målfil «$1».',
	'webstore_dest_mkdir' => 'Kunne ikkje opprette målmappe «$1».',
	'webstore_archive_lock' => 'Kunne ikkje låsast på arkivfil «$1».',
	'webstore_archive_mkdir' => 'Kunne ikkje opprette arkivmappe «$1».',
	'webstore_src_open' => 'Kunne ikkje opne kjeldefil «$1».',
	'webstore_src_close' => 'Feil under lukking av kjeldefil «$1».',
	'webstore_src_delete' => 'Feil under sletting av kjeldefil «$1».',
	'webstore_rename' => 'Feil under omdøyping av «$1» til «$2».',
	'webstore_lock_open' => 'Feil under opning av låsfil «$1».',
	'webstore_lock_close' => 'Feil under lukking av låsfil «$1».',
	'webstore_dest_exists' => 'Feil, målfila «$1» finst.',
	'webstore_temp_open' => 'Feil under opning av mellombels fil «$1».',
	'webstore_temp_copy' => 'Feil under kopiering av mellombels fil «$1» til målfil «$2».',
	'webstore_temp_close' => 'Feil under lukking av mellombels fil «$1».',
	'webstore_temp_lock' => 'Feil under låsing av mellombels fil «$1».',
	'webstore_no_archive' => 'Målfila finst og ikkje noko arkiv vart gjeve.',
	'webstore_no_file' => 'Inga fil vart lasta opp.',
	'webstore_move_uploaded' => 'Feil under flytting av opplasta fil «$1» til mellombels stad «$2».',
	'webstore_invalid_zone' => 'Ugyldig sone «$1».',
	'webstore_no_deleted' => 'Inga arkivmappe for sletta filer er definert.',
	'webstore_curl' => 'Feil frå cURL: $1',
	'webstore_404' => 'Fil ikkje funne.',
	'webstore_php_warning' => 'PHP-åtvaring: $1',
	'webstore_metadata_not_found' => 'Fil ikkje funne: $1',
	'webstore_postfile_not_found' => 'Fil som skal postast er ikkje funne.',
	'webstore_scaler_empty_response' => 'Biletskaleraren gav eit tomt svar med ein 200-responskode. Dette kan vere på grunn av ein fatal PHP-feil i skaleraren.',
	'webstore_invalid_response' => 'Ugyldig svar frå tenar:

$1',
	'webstore_no_response' => 'Ingen respons frå tenar.',
	'webstore_backend_error' => 'Feil frå lagringstenar:

$1',
	'webstore_php_error' => 'Fann PHP-feil:',
	'webstore_no_handler' => 'Ingen handsamar for endring av denne MIME-typen',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'inplace_access_disabled' => "L'accès a aqueste servici es desactivat per totes los clients.",
	'inplace_access_denied' => 'Aqueste servici es restrench sus la basa del IP del client.',
	'inplace_scaler_no_temp' => "Pas cap de dorsièr temporari valid, \$wgLocalTmpDirectory deu conténer lo nom d'un dorsièr amb dreches d'escritura.",
	'inplace_scaler_not_enough_params' => 'Pas pro de paramètres',
	'inplace_scaler_invalid_image' => 'Imatge incorrècte, pòt pas determinar sa talha',
	'inplace_scaler_failed' => "Una error es susvenguda pendent la decompression/compression (« scaling ») de l'imatge : $1",
	'inplace_scaler_no_handler' => 'Cap de foncion (« handler ») per transformar aqueste format MIME.',
	'inplace_scaler_no_output' => 'Cap de fichièr de transformacion generit',
	'inplace_scaler_zero_size' => 'La transformacion a creat un fichièr de talha zèro.',
	'webstore-desc' => "Intergicial d'estocatge de fichièrs per Internet unicament (pas NFS)",
	'webstore_access' => 'Aqueste servici es restrench per adreça IP.',
	'webstore_path_invalid' => 'Lo nom de fichièr es pas corrècte.',
	'webstore_dest_open' => 'Impossible de dobrir lo fichièr de destinacion "$1".',
	'webstore_dest_lock' => 'Fracàs per obténer lo varrolhatge sul fichièr de destinacion « $1 ».',
	'webstore_dest_mkdir' => 'Impossible de crear lo repertòri "$1".',
	'webstore_archive_lock' => 'Fracàs per obténer lo varrolhatge del fichièr archivat « $1 ».',
	'webstore_archive_mkdir' => "Impossible de crear lo repertòri d'archivatge « $1 ».",
	'webstore_src_open' => 'Impossible de dobrir lo fichièr font « $1 ».',
	'webstore_src_close' => 'Error de tampadura del fichièr font « $1 ».',
	'webstore_src_delete' => 'Error de supression del fichièr font « $1 ».',
	'webstore_rename' => 'Error de renomatge del fichièr « $1 » en « $2 ».',
	'webstore_lock_open' => 'Error de dobertura del fichièr varrolhat « $1 ».',
	'webstore_lock_close' => 'Error de tampadura del fichièr varrolhat « $1 ».',
	'webstore_dest_exists' => 'Error, lo fichièr de destinacion « $1 » existís.',
	'webstore_temp_open' => 'Error de dobertura del fichièr temporari « $1 ».',
	'webstore_temp_copy' => 'Error de còpia del fichièr temporari « $1 » cap al fichièr de destinacion « $2 ».',
	'webstore_temp_close' => 'Error de tampadura del fichièr temporari « $1 ».',
	'webstore_temp_lock' => 'Error de varrolhatge del fichièr temporari « $1 ».',
	'webstore_no_archive' => "Lo fichièr de destinacion existís e cap d'archiu es pas estat balhat.",
	'webstore_no_file' => 'Cap de fichièr es pas estat telecargat.',
	'webstore_move_uploaded' => 'Error de desplaçament del fichièr telecargat « $1 » cap a l’emplaçament temporari « $2 ».',
	'webstore_invalid_zone' => 'Zòna « $1 » invalida.',
	'webstore_no_deleted' => 'Cap de repertòri d’archius pels fichièrs suprimits es pas estat definit.',
	'webstore_curl' => 'Error dempuèi cURL : $1',
	'webstore_404' => 'Fichièr pas trobat.',
	'webstore_php_warning' => 'Atencion de PHP: $1',
	'webstore_metadata_not_found' => 'Fichièr pas trobat : $1',
	'webstore_postfile_not_found' => "Fichièr d'enregistrar pas trobat.",
	'webstore_scaler_empty_response' => "L’escandilhatge de l'imatge a balhat una responsa nulla amb un còde de 200 responsas. Aquò poiriá èsser degut a una error de l'escandilhatge.",
	'webstore_invalid_response' => 'Responsa invalida dempuèi lo servidor :  

$1',
	'webstore_no_response' => 'Lo servidor respon pas',
	'webstore_backend_error' => "Error dempuèi lo servidor d'estocatge :  

$1",
	'webstore_php_error' => 'Las errors PHP seguentas son susvengudas',
	'webstore_no_handler' => 'Aqueste tipe MIME pòt pas èsser transformat.',
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'inplace_scaler_not_enough_params' => 'Параметртæ фаг не сты.',
	'webstore_404' => 'Файл не ссардæуы.',
	'webstore_metadata_not_found' => 'Файл не ссардæуы: $1',
	'webstore_no_response' => 'Серверæй дзуапп нæ уыд',
	'webstore_php_error' => 'PHP-рæдыдтæ:',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Sp5uhe
 * @author Wpedzich
 */
$messages['pl'] = array(
	'inplace_access_disabled' => 'Dostęp do tej usługi został wyłączony dla wszystkich klientów.',
	'inplace_access_denied' => 'Ta usługa jest ograniczona przez IP klienta.',
	'inplace_scaler_no_temp' => 'Nie istnieje poprawny katalog tymczasowy, ustaw $wgLocalTmpDirectory na zapisywalny katalog.',
	'inplace_scaler_not_enough_params' => 'Niewystarczająca liczba parametrów.',
	'inplace_scaler_invalid_image' => 'Niepoprawna grafika, nie można określić rozmiaru.',
	'inplace_scaler_failed' => 'Wystąpił błąd przy skalowaniu grafiki: $1',
	'inplace_scaler_no_handler' => 'Brak handlera dla transformacji tego typu MIME',
	'inplace_scaler_no_output' => 'Nie stworzono pliku wyjściowego transformacji.',
	'inplace_scaler_zero_size' => 'Transformacja stworzyła plik o zerowej wielkości.',
	'webstore-desc' => 'Middleware dla sieciowego składowania plików (nie używa NFS)',
	'webstore_access' => 'Ta usługa ograniczona jest dla określonych adresów IP klienta.',
	'webstore_path_invalid' => 'Nieprawidłowa nazwa pliku.',
	'webstore_dest_open' => 'Nie udało się otworzyć pliku docelowego „$1”.',
	'webstore_dest_lock' => 'Nie udało się zablokować pliku docelowego „$1”.',
	'webstore_dest_mkdir' => 'Nie udało się stworzyć katalogu docelowego „$1”.',
	'webstore_archive_lock' => 'Nie udało się zablokować pliku archiwum „$1”.',
	'webstore_archive_mkdir' => 'Nie można utworzyć katalogu archiwum „$1”.',
	'webstore_src_open' => 'Nie udało się otworzyć pliku źródłowego „$1”.',
	'webstore_src_close' => 'Błąd podczas zamykania pliku źródłowego „$1”.',
	'webstore_src_delete' => 'Błąd podczas usuwania pliku źródłowego „$1”.',
	'webstore_rename' => 'Błąd zamiany nazwy pliku „$1” na „$2”.',
	'webstore_lock_open' => 'Błąd otwarcia pliku blokady „$1”.',
	'webstore_lock_close' => 'Błąd zamknięcia pliku blokady „$1”.',
	'webstore_dest_exists' => 'Błąd: Plik docelowy „$1” już istnieje.',
	'webstore_temp_open' => 'Błąd otwarcia pliku tymczasowego „$1”.',
	'webstore_temp_copy' => 'Błąd kopiowania pliku tymczasowego „$1” do lokalizacji „$2”.',
	'webstore_temp_close' => 'Błąd zamknięcia pliku tymczasowego „$1”.',
	'webstore_temp_lock' => 'Błąd zablokowania pliku tymczasowego „$1”.',
	'webstore_no_archive' => 'Plik docelowy już istnieje, nie podano też lokalizacji archiwum.',
	'webstore_no_file' => 'Nie przesłano pliku.',
	'webstore_move_uploaded' => 'Podczas przenoszenia przesłanego pliku „$1” do lokalizacji tymczasowej „$2” wystąpił błąd.',
	'webstore_invalid_zone' => 'Nieprawidłowa strefa „$1”.',
	'webstore_no_deleted' => 'Nie zdefiniowano katalogu archiwum dla usuwanych plików.',
	'webstore_curl' => 'Błąd cURL: $1',
	'webstore_404' => 'Nie odnaleziono pliku.',
	'webstore_php_warning' => 'Ostrzeżenie PHP $1',
	'webstore_metadata_not_found' => 'Nie odnaleziono pliku $1',
	'webstore_postfile_not_found' => 'Nie odnaleziono pliku do opublikowania.',
	'webstore_scaler_empty_response' => 'Moduł skalowania grafik zwrócił pustą odpowiedź z kodem błędu 200. Może to być wynikiem krytycznego błędu PHP w module skalowania.',
	'webstore_invalid_response' => 'Serwer odpowiedział nieprawidłowo:

$1',
	'webstore_no_response' => 'Serwer nie odpowiada',
	'webstore_backend_error' => 'Serwer przechowujący dane zwrócił błąd:

$1',
	'webstore_php_error' => 'Napotkano następujące błędy PHP:',
	'webstore_no_handler' => 'Nie odnaleziono wtyczki obsługującej dane tego typu MIME',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 * @author Dragonòt
 */
$messages['pms'] = array(
	'inplace_access_disabled' => "Ës servissi-sì a l'é stàit dësmortà për tuti ij client.",
	'inplace_access_denied' => "Ës servissi-sì a l'é limità a sconda dl'adrëssa IP dël client.",
	'inplace_scaler_no_temp' => "A-i é gnun dossié provisòri bon, ch'a buta un valor ëd \$wgLocalTmpDirectory ch'a men-a a un dossié ch'as peulo scriv-se.",
	'inplace_scaler_not_enough_params' => 'A-i é pa basta ëd paràmetr.',
	'inplace_scaler_invalid_image' => "Figura nen bon-a, a l'é nen podusse determiné l'amzura.",
	'inplace_scaler_failed' => "A l'é riva-ie n'eror ën ardimensionand la figura: $1",
	'inplace_scaler_no_handler' => "A-i manca l'utiss (handler) për ardimensioné sta sòrt MIME-sì",
	'inplace_scaler_no_output' => "La trasformassion a l'ha nen dàit gnun archivi d'arzultà.",
	'inplace_scaler_zero_size' => "La transformassion a l'ha dàit n'archivi d'arzultà veujd.",
	'webstore-desc' => "Middleware d'archiviassion dij file mach Web (pa NFS)",
	'webstore_access' => "Ës servissi-sì a l'é limità a sconda dl'adrëssa IP dël client.",
	'webstore_path_invalid' => "Ël nòm dl'archivi a l'é nen bon.",
	'webstore_dest_open' => 'As peul nen deurbe l\'archivi ëd destinassion "$1".',
	'webstore_dest_lock' => 'A l\'é nen podusse sëré ël luchèt ansima a l\'archivi ëd destinassion "$1".',
	'webstore_dest_mkdir' => 'A l\'é nen podusse creé ël dossié ëd destinassion "$1".',
	'webstore_archive_lock' => 'A l\'é nen podusse sëré ël luchèt ansima a l\'archivi "$1".',
	'webstore_archive_mkdir' => 'A l\'é nen podusse creé ël dossié da archivi "$1".',
	'webstore_src_open' => 'A l\'é nen podusse deurbe l\'archivi sorgiss "$1".',
	'webstore_src_close' => 'A l\'é riva-ie n\'eror ën sërand l\'archivi sorgiss "$1".',
	'webstore_src_delete' => 'A l\'é riva-ie n\'eror ën scanceland l\'archivi sorgiss "$1".',
	'webstore_rename' => 'A l\'é riva-ie n\'eror ën arbatiand l\'archivi "$1" coma "$2".',
	'webstore_lock_open' => 'A l\'é riva-ie n\'eror ën duvertand l\'archivi-luchèt "$1".',
	'webstore_lock_close' => 'A l\'é riva-ie n\'eror ën sërand l\'archivi-luchèt "$1".',
	'webstore_dest_exists' => 'Eror, l\'archivi ëd destinassion "$1" a-i é già.',
	'webstore_temp_open' => 'A l\'é riva-ie n\'eror ën duvertand l\'archivi provisòri "$1".',
	'webstore_temp_copy' => 'A l\'é riva-ie n\'eror ën tracopiand l\'archivi provisòri "$1" a l\'archivi ëd destinassion "$2".',
	'webstore_temp_close' => 'A l\'é riva-ie n\'eror ën sërand l\'archivi provisòri "$1".',
	'webstore_temp_lock' => "A l'é riva-ie n'eror ën butand-je 'l luchèt a l'archivi provisòri \"\$1\".",
	'webstore_no_archive' => "L'archivi ëd destinassion a-i é già e a l'é butasse gnun archivi.",
	'webstore_no_file' => 'Pa gnun archivi carià.',
	'webstore_move_uploaded' => 'A l\'é riva-ie n\'eror an tramudand l\'archivi carià "$1" a la locassion provisòria "$2".',
	'webstore_invalid_zone' => 'Zòna "$1" nen bon-a.',
	'webstore_no_deleted' => "A l'é pa specificasse gnun dossié da archivi për coj ch'as ëscancelo.",
	'webstore_curl' => "Eror da 'nt l'adrëssa (cURL): $1",
	'webstore_404' => 'Archivi nen trovà.',
	'webstore_php_warning' => 'Avis dël PHP: $1',
	'webstore_metadata_not_found' => 'Archivi nen trovà: $1',
	'webstore_postfile_not_found' => 'Archivi da mandé nen trovà.',
	'webstore_scaler_empty_response' => "Ël programa d'ardimensionament dle figure a l'ha dàit n'arspòsta veujda con un còdes d'arspòsta 200. Sòn a podrìa esse rivà për via d'un eror fatal ant ël PHP dël programa.",
	'webstore_invalid_response' => "Arspòsta nen bon-a da 'nt ël servent: $1",
	'webstore_no_response' => "Pa d'arspòsta da 'nt ël servent.",
	'webstore_backend_error' => "Eror da 'nt ël servent da stocagi: $1",
	'webstore_php_error' => "A son riva-ie dj'eror dël PHP:",
	'webstore_no_handler' => "A-i manca l'utiss (handler) për ardimensioné sta sòrt MIME-sì",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'webstore_path_invalid' => 'د دوتنې نوم مو سم نه وو.',
	'webstore_no_file' => 'هېڅ کومه دوتنه پورته نه شوه.',
	'webstore_invalid_zone' => 'ناسمه سيمه "$1".',
	'webstore_404' => 'دوتنه و نه موندل شوه.',
	'webstore_php_warning' => 'د PHP ګواښنه: $1',
	'webstore_metadata_not_found' => 'دوتنه و نه موندل شوه: $1',
	'webstore_no_response' => 'د پالنګر نه هېڅ کوم ځواب نشته',
	'webstore_backend_error' => 'د زېرمتون د پالنګر لخوا تېروتنه:

$1',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'inplace_access_disabled' => 'O acesso a este serviço foi impossibilitado para todos os clientes.',
	'inplace_access_denied' => 'Este serviço está restringido por IP de cliente.',
	'inplace_scaler_no_temp' => 'O directório temporário não é válido.
Defina em $wgLocalTmpDirectory um directório onde seja possível escrever.',
	'inplace_scaler_not_enough_params' => 'Parâmetros insuficientes.',
	'inplace_scaler_invalid_image' => 'Imagem inválida. Não foi possível determinar o tamanho.',
	'inplace_scaler_failed' => 'Foi encontrado um erro durante o escalamento da imagem: $1',
	'inplace_scaler_no_handler' => 'Nenhum manipulador definido para transformar este tipo MIME',
	'inplace_scaler_no_output' => 'Nenhum ficheiro de saída de transformação foi gerado.',
	'inplace_scaler_zero_size' => 'A transformação produziu um ficheiro de saída de tamanho zero.',
	'webstore-desc' => 'Middleware de armazenamento de ficheiros apenas Web (não NFS)',
	'webstore_access' => 'Este serviço está restrito por IP cliente.',
	'webstore_path_invalid' => 'O nome de ficheiro é inválido.',
	'webstore_dest_open' => 'Impossível abrir o ficheiro de destino "$1".',
	'webstore_dest_lock' => 'Falha ao bloquear o ficheiro de destino "$1".',
	'webstore_dest_mkdir' => 'Não foi possível criar o directório de destino "$1".',
	'webstore_archive_lock' => 'Falha ao bloquear o ficheiro de arquivo "$1".',
	'webstore_archive_mkdir' => 'Não foi possível criar o directório de arquivo "$1".',
	'webstore_src_open' => 'Impossível abrir o ficheiro original "$1".',
	'webstore_src_close' => 'Erro ao fechar o ficheiro original "$1".',
	'webstore_src_delete' => 'Erro ao eliminar o ficheiro original "$1".',
	'webstore_rename' => 'Erro ao alterar o nome do ficheiro "$1" para "$2".',
	'webstore_lock_open' => 'Erro ao abrir o ficheiro de bloqueio "$1".',
	'webstore_lock_close' => 'Erro ao fechar o ficheiro de bloqueio "$1".',
	'webstore_dest_exists' => 'Erro, o ficheiro de destino "$1" já existe.',
	'webstore_temp_open' => 'Erro ao abrir o ficheiro temporário "$1".',
	'webstore_temp_copy' => 'Erro ao copiar o ficheiro temporário "$1" para o ficheiro de destino "$2".',
	'webstore_temp_close' => 'Erro ao fechar o ficheiro temporário "$1".',
	'webstore_temp_lock' => 'Erro ao bloquear o ficheiro temporário "$1".',
	'webstore_no_archive' => 'Ficheiro de destino existe e não foi fornecido nenhum arquivo.',
	'webstore_no_file' => 'Não foi carregado nenhum ficheiro.',
	'webstore_move_uploaded' => 'Erro ao mover o ficheiro carregado "$1" para a localização temporária "$2".',
	'webstore_invalid_zone' => 'Zona "$1" inválida.',
	'webstore_no_deleted' => 'Não está definido nenhum directório de arquivo para os ficheiros eliminados.',
	'webstore_curl' => 'Erro da cURL: $1',
	'webstore_404' => 'Ficheiro não encontrado.',
	'webstore_php_warning' => 'Aviso PHP: $1',
	'webstore_metadata_not_found' => 'Ficheiro não encontrado: $1',
	'webstore_postfile_not_found' => 'Ficheiro a enviar não encontrado.',
	'webstore_scaler_empty_response' => 'O redimensionador da imagem devolveu uma mensagem com o código de resposta 200.
Isso pode ser devido a um erro fatal de PHP no redimensionador.',
	'webstore_invalid_response' => 'Resposta inválida do servidor:

$1',
	'webstore_no_response' => 'Sem resposta do servidor',
	'webstore_backend_error' => 'Erro do servidor de armazenamento:

$1',
	'webstore_php_error' => 'Foram encontrados erros PHP:',
	'webstore_no_handler' => 'Não há um tratador para transformar este tipo MIME',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'inplace_access_disabled' => 'O acesso a este serviço foi desabilitado para todos os clientes.',
	'inplace_access_denied' => 'Este serviço está restringido por IP de cliente.',
	'inplace_scaler_no_temp' => 'Não existe diretório temporário, defina $wgLocalTmpDirectory com uma diretório onde seja possível escrever.',
	'inplace_scaler_not_enough_params' => 'Parâmetros insuficientes.',
	'inplace_scaler_invalid_image' => 'Imagem inválida. Não foi possível determinar o tamanho.',
	'inplace_scaler_failed' => 'Foi encontrado um erro durante o escalamento da imagem: $1',
	'inplace_scaler_no_handler' => 'Nenhum manipulador definido para transformar este tipo MIME',
	'inplace_scaler_no_output' => 'Nenhum arquivo de saída de transformação foi gerado.',
	'inplace_scaler_zero_size' => 'A transformação produziu um arquivo de saída de tamanho zero.',
	'webstore-desc' => 'Middleware de armazenamento de arquivos apenas Web (não NFS)',
	'webstore_access' => 'Este serviço está restrito por IP cliente.',
	'webstore_path_invalid' => 'O nome de arquivo é inválido.',
	'webstore_dest_open' => 'Impossível abrir o arquivo de destino "$1".',
	'webstore_dest_lock' => 'Falha ao bloquear o arquivo de destino "$1".',
	'webstore_dest_mkdir' => 'Impossível criar o diretório de destino "$1".',
	'webstore_archive_lock' => 'Falha ao bloquear o arquivo "$1".',
	'webstore_archive_mkdir' => 'Impossível criar a pasta de arquivo "$1".',
	'webstore_src_open' => 'Impossível abrir o arquivo original "$1".',
	'webstore_src_close' => 'Erro ao fechar o arquivo original "$1".',
	'webstore_src_delete' => 'Erro ao eliminar o arquivo original "$1".',
	'webstore_rename' => 'Erro ao renomear o arquivo "$1" para "$2".',
	'webstore_lock_open' => 'Erro ao abrir o arquivo de bloqueio "$1".',
	'webstore_lock_close' => 'Erro ao fechar o arquivo de bloqueio "$1".',
	'webstore_dest_exists' => 'Erro, o arquivo de destino "$1" já existe.',
	'webstore_temp_open' => 'Erro ao abrir o arquivo temporário "$1".',
	'webstore_temp_copy' => 'Erro ao copiar o arquivo temporário "$1" para o arquivo de destino "$2".',
	'webstore_temp_close' => 'Erro ao fechar o arquivo temporário "$1".',
	'webstore_temp_lock' => 'Erro ao bloquear o arquivo temporário "$1".',
	'webstore_no_archive' => 'Arquivo destino existe e nenhum arquivo foi dado.',
	'webstore_no_file' => 'Nenhum arquivo foi carregado.',
	'webstore_move_uploaded' => 'Erro ao mover o arquivo carregado "$1" para a localização temporária "$2".',
	'webstore_invalid_zone' => 'Zona "$1" inválida.',
	'webstore_no_deleted' => 'Nenhuma pasta de arquivo para arquivos eliminados está definida.',
	'webstore_curl' => 'Erro da cURL: $1',
	'webstore_404' => 'Arquivo não encontrado.',
	'webstore_php_warning' => 'Aviso PHP: $1',
	'webstore_metadata_not_found' => 'Arquivo não encontrado: $1',
	'webstore_postfile_not_found' => 'Arquivo a enviar não encontrado.',
	'webstore_scaler_empty_response' => 'O redimensionador da imagem devolveu uma mensagem com o código de resposta 200.
Isso pode ser devido a um erro fatal de PHP no redimensionador.',
	'webstore_invalid_response' => 'Resposta inválida do servidor:

$1',
	'webstore_no_response' => 'Sem resposta do servidor',
	'webstore_backend_error' => 'Erro do servidor de armazenamento:

$1',
	'webstore_php_error' => 'Foram encontrados erros PHP:',
	'webstore_no_handler' => 'Não há um tratador para transformar este tipo MIME',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'inplace_access_disabled' => 'Accesul la acest serviciu a fost dezactivat pentru toți clienții.',
	'inplace_access_denied' => 'Acest serviciu este restricționat după adresa IP a clientului.',
	'inplace_scaler_not_enough_params' => 'Parametri insuficienți.',
	'inplace_scaler_invalid_image' => 'Imagine incorectă, nu s-a putut determina mărimea.',
	'inplace_scaler_zero_size' => 'Transformarea a produs un fișier de ieșire de mărime zero.',
	'webstore_access' => 'Acest serviciu este restricționat după adresa IP a clientului.',
	'webstore_path_invalid' => 'Numele fișierului a fost incorect.',
	'webstore_dest_open' => 'Nu s-a putut deschide fișierul de destinație "$1".',
	'webstore_dest_mkdir' => 'Nu s-a putut crea directorul destinație "$1".',
	'webstore_archive_mkdir' => 'Nu s-a putut crea directorul arhivă "$1".',
	'webstore_src_open' => 'Nu s-a putut deschide fișierul sursă "$1".',
	'webstore_src_close' => 'Eroare la închiderea fișierului sursă "$1".',
	'webstore_src_delete' => 'Eroare la ștergerea fișierului sursă "$1".',
	'webstore_rename' => 'Eroare la redenumirea fișierului "$1" în "$2".',
	'webstore_dest_exists' => 'Eroare, fișierul destinație "$1" există.',
	'webstore_temp_open' => 'Eroare la deschiderea fișierului temporar "$1".',
	'webstore_temp_copy' => 'Eroare la copierea fișierului temporar "$1" în fișierul destinație "$2".',
	'webstore_temp_close' => 'Eroare la închiderea fișierului temporar "$1".',
	'webstore_no_archive' => 'Fișierul destinație există și nu a fost oferită nici o arhivă.',
	'webstore_no_file' => 'Nici un fișier nu a fost încărcat.',
	'webstore_move_uploaded' => 'Eroare la mutarea fișierului încărcat "$1" în fișierul temporar "$2".',
	'webstore_invalid_zone' => 'Zona "$1" invalidă.',
	'webstore_no_deleted' => 'Nu este definită nici o arhivă pentru fișierele șterse.',
	'webstore_curl' => 'Eroare de la cURL: $1',
	'webstore_404' => 'Fișier negăsit.',
	'webstore_php_warning' => 'Avertizare PHP: $1',
	'webstore_metadata_not_found' => 'Fișier negăsit: $1',
	'webstore_invalid_response' => 'Răspuns incorect de la server:

$1',
	'webstore_no_response' => 'Nici un răspuns de la server',
	'webstore_backend_error' => 'Eroare de la serverul de stocare:

$1',
	'webstore_php_error' => 'Au fost întâlnite erori PHP:',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'webstore_invalid_zone' => 'Zone invalide "$1".',
	'webstore_invalid_response' => "Risposte sbagliete da 'u server:

$1",
	'webstore_no_response' => "Nisciuna risposte da 'u server",
);

/** Russian (Русский)
 * @author Aleksandrit
 * @author Ferrer
 * @author Rubin
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'inplace_access_disabled' => 'Доступ у сервису был отключён для всех клиентов',
	'inplace_access_denied' => 'Доступ к данной службе ограничен по IP-адресу',
	'inplace_scaler_no_temp' => 'Нет корректной временной директории.
Параметр $wgLocalTmpDirectory должен указывать на директорию, доступную для записи.',
	'inplace_scaler_not_enough_params' => 'Недостаточно параметров.',
	'inplace_scaler_invalid_image' => 'Проблемное изображение, невозможно определить размер.',
	'inplace_scaler_failed' => 'Произошла ошибка во время масштабирования изображения: $1',
	'inplace_scaler_no_handler' => 'Нет обработчика для преобразования этого MIME-типа',
	'inplace_scaler_no_output' => 'Не был создан выходной файл преобразования.',
	'inplace_scaler_zero_size' => 'В результате преобразования получился выходной файл нулевого размера.',
	'webstore-desc' => 'Веб-ориентированный способ хранения файлов (не NFS)',
	'webstore_access' => 'Доступ к этой службе ограничен по IP-адресу.',
	'webstore_path_invalid' => 'Неверное имя файла.',
	'webstore_dest_open' => 'Не удаётся открыть файл «$1».',
	'webstore_dest_lock' => 'Не удалось получить блокировку файла назначения «$1».',
	'webstore_dest_mkdir' => 'Не удаётся создать целевой каталог «$1».',
	'webstore_archive_lock' => 'Не удалось получить блокировку файла архива «$1».',
	'webstore_archive_mkdir' => 'Невозможно создать архивную директорию «$1».',
	'webstore_src_open' => 'Не удаётся открыть исходный файл «$1».',
	'webstore_src_close' => 'Ошибка закрытия исходного файла «$1».',
	'webstore_src_delete' => 'Ошибка при удалении исходного файла «$1».',
	'webstore_rename' => 'Ошибка при переименовании файла «$1» в «$2».',
	'webstore_lock_open' => 'Ошибка при открытии файла блокировки «$1».',
	'webstore_lock_close' => 'Ошибка закрытия файла блокировки «$1».',
	'webstore_dest_exists' => 'Ошибка, файла назначения «$1» существует.',
	'webstore_temp_open' => 'Ошибка открытия временного файла «$1».',
	'webstore_temp_copy' => 'Ошибка при копировании временного файла «$1» в файл назначения «$2».',
	'webstore_temp_close' => 'Ошибка при закрытии временного файла «$1».',
	'webstore_temp_lock' => 'Ошибка блокировки временного файла «$1».',
	'webstore_no_archive' => 'Файл назначения существует, архив не был передан.',
	'webstore_no_file' => 'Файл не был загружен.',
	'webstore_move_uploaded' => 'Ошибка перемещения загруженного файла «$1» во временное местоположение «$2».',
	'webstore_invalid_zone' => 'Ошибочная зона «$1».',
	'webstore_no_deleted' => 'Не определена архивная директория для удаляемых файлов.',
	'webstore_curl' => 'Ошибка в cURL: $1',
	'webstore_404' => 'Файл не найден.',
	'webstore_php_warning' => 'Предупреждение PHP: $1',
	'webstore_metadata_not_found' => 'Файл не найден: $1',
	'webstore_postfile_not_found' => 'Не найден файл для отправки.',
	'webstore_scaler_empty_response' => 'Инструмент масштабирования изображений выдал пустой ответ с кодом 200.
Причиной этого может быть фатальная ошибка PHP в инструменте масштабирования.',
	'webstore_invalid_response' => 'Ошибка в ответе сервера:

$1',
	'webstore_no_response' => 'Нет ответа от сервера.',
	'webstore_backend_error' => 'Ошибка сервера-хранилища:

$1',
	'webstore_php_error' => 'Возникли следующие ошибки PHP:',
	'webstore_no_handler' => 'Нет обработчика для преобразования этого MIME-типа',
);

/** Sinhala (සිංහල)
 * @author Calcey
 */
$messages['si'] = array(
	'inplace_access_disabled' => 'මෙම සේවාවට ප්‍රවේශවීම සියලුම සේවා දායකයන් සඳහා අක්‍රීය කර ඇත.',
	'inplace_access_denied' => 'මෙම සේවාව සේවා දායක IP මඟින් සීමා කරනු ලැබ ඇත.',
	'inplace_scaler_no_temp' => 'වලංගු තාවකාලික නාමාවලියක් නොමැත.
$wgLocalTmpDirectory ලිවිය හැකි නාමාවලියකට සකසන්න.',
	'inplace_scaler_not_enough_params' => 'ප්‍රමාණවත් පරාමිති නොමැත.',
	'inplace_scaler_invalid_image' => 'අවලංගු රූපයකි,විශාලත්වය නිර්ණය කළ නොහැකි විය.',
	'inplace_scaler_failed' => 'රූප පරිමාණකරණයේදී දෝෂයක් හමුවිය: $1',
	'inplace_scaler_no_handler' => 'මෙම MIME වර්ගය පරිණාමනය කිරීම සඳහා හසුරුවන්නෙක් නොමැත',
	'inplace_scaler_no_output' => 'පරිණාම ප්‍රතිදානයක් නිපදවා නැත.',
	'inplace_scaler_zero_size' => 'පරිණාමයෙන් විශාලත්වය ශුන්‍ය වූ ප්‍රතිදාන ගොනුවක් නිපදවන ලදී.',
	'webstore_access' => 'මෙම සේවාව සේවාදායක IP මඟින් සීමා කරනු ලැබ ඇත.',
	'webstore_path_invalid' => 'ගොනු නාමය වලංගු නොවේ.',
	'webstore_dest_open' => '"$1, ගමනාන්ත ගොනුව විවෘත කිරීමට නොහැකි විය.',
	'webstore_dest_lock' => '"$1" ගමනාන්ත ගොනුව මත අගුළු දැමීම අසාර්ථක විය.',
	'webstore_dest_mkdir' => '"$1" ගමනාන්ත නාමාවලිය නිර්මාණය කිරීමට නොහැකි විය.',
	'webstore_archive_lock' => '"$1" ලේඛනාගාර ගොනුව මත අගුළු දැමීම අසාර්ථක විය.',
	'webstore_archive_mkdir' => '"$1" ලේඛනාගාර නාමාවලිය නිර්මාණය කිරීමට නොහැකි විය.',
	'webstore_src_open' => ' "$1" මූලාශ්‍ර ගොනුව විවෘත කළ නොහැකි විය.',
	'webstore_src_close' => '"$1" මූලාශ්‍ර ගොනුව වැසීමේ දෝෂයකි.',
	'webstore_src_delete' => '"$1" මූපාශ්‍ර ගොනුව මැකීමේ දෝෂයකි.',
	'webstore_rename' => '"$1"  ගොනුව  "$2" ලෙස යළි නම් කිරීමේ දෝෂයකි.',
	'webstore_lock_open' => '"$1" අගුළු ගොනුව විවෘත කිරීමේ දෝෂයකි.',
	'webstore_lock_close' => '"$1" අගුළු ගොනුව වැසීමේ දෝෂයකි.',
	'webstore_dest_exists' => 'දෝෂයකි,"$1" ගමනාන්ත ගොනුව පවතී.',
	'webstore_temp_open' => '"$1" තාවකාලික ගොනුව විවෘත කිරීමේ දෝෂයකි.',
	'webstore_temp_copy' => '"$1" තාවකාලික ගොනුව "$2" ගමනාන්ත ගොනුවට පිටපත් කිරීමේ දෝෂයකි.',
	'webstore_temp_close' => '"$1" තාවකාලික ගොනුව වැසීමේ දෝෂයකි.',
	'webstore_temp_lock' => '"$1" තාවකාලික ගොනුව අගුළුලෑමේ දෝෂයකි.',
	'webstore_no_archive' => 'ගමනාන්ත ගොනුව පවතී,ලේඛනාගාරයක් දී නොමැත.',
	'webstore_no_file' => 'කිසිදු ගොනුවක් උඩුගත කරනු ලැබුවේ නැත.',
	'webstore_move_uploaded' => '"$1" උඩුගත කළ ගොනුව "$2" තාවකාලික පිහිටීමට චලනය කිරීමේ දෝෂයකි.',
	'webstore_invalid_zone' => '"$1" අවලංගු කලාපයකි.',
	'webstore_no_deleted' => 'මකා දමනු ලැබූ ගොනු සඳහා ලේඛනාගාර නාමාවලියක් නිර්වචනය කර නැත.',
	'webstore_curl' => 'cURL: $1හි දෝෂය',
	'webstore_404' => 'ගොනුව හමු වූයේ නැත.',
	'webstore_php_warning' => 'PHP අවවාදයයි: $1',
	'webstore_metadata_not_found' => 'ගොනුව හමු නොවුණි: $1',
	'webstore_postfile_not_found' => 'තැපැල් කිරීමට ගොනුව හමු නොවුණි.',
	'webstore_scaler_empty_response' => 'රූප පරිමාපය 200 ප්‍රතිචාර කේතයක් සමඟ හිස් ප්‍රතිචාරයක් ලබා දුන්නේය.
මෙය පරිමාපයේ මාරක PHP දෝෂයක් නිසා සිදු විය හැක.',
	'webstore_invalid_response' => 'සේවාදායකයෙන් වලංගු නොවූ ප්‍රතිචාරයක්: 
$1',
	'webstore_no_response' => 'සේවාදායකයෙන් ප්‍රතිචාරයක් නොමැත',
	'webstore_backend_error' => 'ගබඩා සේවාදායකයෙන් දෝෂයක්:
$1',
	'webstore_php_error' => 'PHP දෝෂයන් හමු විය:',
	'webstore_no_handler' => 'මෙම MIME වර්ගය පරිණාමනය කිරීම සඳහා හසුරුවන්නෙක් නොමැත',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'inplace_access_disabled' => 'Prístup k tejto službe bol vypnutý pre všetkých klientov.',
	'inplace_access_denied' => 'Táto služba je obmedzená na určené klientské IP adresy.',
	'inplace_scaler_no_temp' => 'Dočasný adresár nie je platný, nastavte $wgLocalTmpDirectory na zapisovateľný adresár.',
	'inplace_scaler_not_enough_params' => 'Nedostatok parametrov.',
	'inplace_scaler_invalid_image' => 'Neplatný obrázok, nebolo možné určiť veľkosť.',
	'inplace_scaler_failed' => 'Počas zmeny veľkosti obrázka sa vyskytla chyba: $1',
	'inplace_scaler_no_handler' => 'Pre transformáciu tohto typu MIME neexistuje obsluha',
	'inplace_scaler_no_output' => 'Nebol vytvorený výstupný súbor tejto transformácie.',
	'inplace_scaler_zero_size' => 'Transformácia vytvorila výstupný súbor s nulovou veľkosťou.',
	'webstore-desc' => 'Middleware pre iba webové (nie NFS) úložisko',
	'webstore_access' => 'Táto služba je obmedzená na určené klientské IP adresy.',
	'webstore_path_invalid' => 'Názov súboru bol neplatný.',
	'webstore_dest_open' => 'Nebolo možné otvoriť cieľový súbor „$1“.',
	'webstore_dest_lock' => 'Nebolo možné záskať zámok na cieľový súbor „$1“.',
	'webstore_dest_mkdir' => 'Nebolo možné vytvoriť cieľový adresár „$1“.',
	'webstore_archive_lock' => 'Nebolo možné získať zámok na súbor archívu „$1“.',
	'webstore_archive_mkdir' => 'Nebolo možné vytvoriť archívny adresár „$1“.',
	'webstore_src_open' => 'Nebolo možné otvoriť zdrojový súbor „$1“.',
	'webstore_src_close' => 'Chyba pri zatváraní zdrojového súboru „$1“.',
	'webstore_src_delete' => 'Chyba pri mazaní zdrojového súboru „$1“.',
	'webstore_rename' => 'Chyba pri premenovávaní súboru „$1“ na „$2“.',
	'webstore_lock_open' => 'Chyba pri otváraní súboru zámku „$1“.',
	'webstore_lock_close' => 'Chyba pri zatváraní súboru zámku „$1“.',
	'webstore_dest_exists' => 'Chyba, cieľový súbor „$1“ existuje.',
	'webstore_temp_open' => 'Chyba pri otváraní dočasného súboru „$1“.',
	'webstore_temp_copy' => 'Chyba pri kopírovaní dočasného súboru „$1“ do cieľového súboru „$2“.',
	'webstore_temp_close' => 'Chyba pri zatváraní dočasného súboru „$1“.',
	'webstore_temp_lock' => 'Chyba pri zamykaní dočasného súboru „$1“.',
	'webstore_no_archive' => 'Cieľový súbor existuje a nebol zadaný archív.',
	'webstore_no_file' => 'Žiadny súbor nebol nahraný.',
	'webstore_move_uploaded' => 'Chyba pri presúvaní nahraného súboru „$1“ na dočasné miesto „$2“.',
	'webstore_invalid_zone' => 'Neplatné zóna „$1“.',
	'webstore_no_deleted' => 'Nebol definovaný žiadny archívny adresár pre zmazané súbory.',
	'webstore_curl' => 'Chýba od cURL: $1',
	'webstore_404' => 'Súbor nenájdený.',
	'webstore_php_warning' => 'Upozornenie PHP: $1',
	'webstore_metadata_not_found' => 'Súbor nebol nájdený: $1',
	'webstore_postfile_not_found' => 'Súbor na odoslanie nebol nájdený.',
	'webstore_scaler_empty_response' => 'Zmena veľkosti obrázka vrátila prázdnu odpoveď s kódom 200. Toto by mohlo znamenať kritickú chybu PHP pri zmene veľkosti obrázka.',
	'webstore_invalid_response' => 'Neplatná odpoveď od servera:

$1',
	'webstore_no_response' => 'Žiadna odpoveď od servera',
	'webstore_backend_error' => 'Chyba od úložného servera:

$1',
	'webstore_php_error' => 'Vyskytli sa chyby PHP:',
	'webstore_no_handler' => 'Pre transformáciu tohto typu MIME neexistuje obsluha',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'inplace_access_disabled' => 'Приступ овом сервису је био онемогућен за све клијенте.',
	'inplace_access_denied' => 'Овај сервис ограничава приступ по IP клијента.',
	'inplace_scaler_no_temp' => 'Нема исправног привременог директоријума.
Поставите $wgLocalTmpDirectory на директоријум са дозволама за писање.',
	'inplace_scaler_not_enough_params' => 'Недовољно параметара.',
	'inplace_scaler_invalid_image' => 'Неисправна слика, није мога бити одређена величина.',
	'inplace_scaler_no_handler' => 'Нема хандлера за трансофрмисање овог MIME типа',
	'inplace_scaler_no_output' => 'Трансформисани фајл није направљен.',
	'inplace_scaler_zero_size' => 'Трансформацијом је настао излазни фајл нулте дужине (без садржаја).',
	'webstore_access' => 'Приступ овом сервису је ограничен оп IP клијента.',
	'webstore_path_invalid' => 'Име фајла је било погрешно.',
	'webstore_dest_open' => 'Циљани фајл "$1" није могао бити отворен.',
	'webstore_dest_lock' => 'Циљани фајл "$1" није могао бити закључан зарад измена.',
	'webstore_dest_mkdir' => 'Не могу да направим одредишну фасциклу „$1“.',
	'webstore_archive_lock' => 'Архивски фајл "$1" није могао бити закључан.',
	'webstore_archive_mkdir' => 'Не могу да направим архивску фасциклу „$1“.',
	'webstore_src_open' => 'Изворни фајл "$1" није могао бити отворен.',
	'webstore_src_close' => 'Грешка при затварању изворног фајла "$1".',
	'webstore_src_delete' => 'Грешка приликом брисања изворног фајла "$1".',
	'webstore_rename' => 'Грешка при преименовању фајла "$1" у "$2".',
	'webstore_lock_open' => 'Грешка приликом откључавања фајла "$1".',
	'webstore_dest_exists' => 'Грешка, циљани фајл "$1" постоји.',
	'webstore_temp_open' => 'Грешка приликом отварања привременог фајла "$1".',
	'webstore_temp_copy' => 'Грешка приликом копирања привременог фајла "$1" на место циљаног фајла "$2".',
	'webstore_temp_close' => 'Грешка приликом затварања привременог фајла "$1".',
	'webstore_temp_lock' => 'Грешка приликом закључавања привременог фајла "$1".',
	'webstore_no_archive' => 'Циљани фајл постоји и нкаква архива није наведена.',
	'webstore_no_file' => 'Датотека није послата.',
	'webstore_move_uploaded' => 'Грешка прилиокм премештања послатог фајла "$1" на привремено место "$2".',
	'webstore_invalid_zone' => 'Погрешна зона "$1".',
	'webstore_no_deleted' => 'Није наведен архивски директоријум за обрисане фајлове.',
	'webstore_curl' => 'Грешка од cURL: $1',
	'webstore_404' => 'Датотека није пронађена.',
	'webstore_php_warning' => 'PHP напомена: $1',
	'webstore_metadata_not_found' => 'Датотека није пронађена: $1',
	'webstore_postfile_not_found' => 'Није пронађен фајл за слање.',
	'webstore_invalid_response' => 'Неадекватан одговор од сервера:

$1',
	'webstore_no_response' => 'Сервер не одговара',
	'webstore_php_error' => 'Дошло је до PHP грешака:',
	'webstore_no_handler' => 'Није дефинисано трансформисање овог MIME типа',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Rancher
 */
$messages['sr-el'] = array(
	'inplace_access_disabled' => 'Pristup ovom servisu je bio onemogućen za sve klijente.',
	'inplace_access_denied' => 'Ovaj servis ograničava pristup po IP klijenta.',
	'inplace_scaler_no_temp' => 'Nema ispravnog privremenog direktorijuma.
Postavite $wgLocalTmpDirectory na direktorijum sa dozvolama za pisanje.',
	'inplace_scaler_not_enough_params' => 'Nedovoljno parametara.',
	'inplace_scaler_invalid_image' => 'Neispravna slika, nije moga biti određena veličina.',
	'inplace_scaler_no_handler' => 'Nema handlera za transofrmisanje ovog MIME tipa',
	'inplace_scaler_no_output' => 'Transformisani fajl nije napravljen.',
	'inplace_scaler_zero_size' => 'Transformacijom je nastao izlazni fajl nulte dužine (bez sadržaja).',
	'webstore_access' => 'Pristup ovom servisu je ograničen op IP klijenta.',
	'webstore_path_invalid' => 'Ime fajla je bilo pogrešno.',
	'webstore_dest_open' => 'Ciljani fajl "$1" nije mogao biti otvoren.',
	'webstore_dest_lock' => 'Ciljani fajl "$1" nije mogao biti zaključan zarad izmena.',
	'webstore_dest_mkdir' => 'Ciljani direktorijum "$1" nije mogao biti napravljen.',
	'webstore_archive_lock' => 'Arhivski fajl "$1" nije mogao biti zaključan.',
	'webstore_archive_mkdir' => 'Arhivski direktorijum "$1" nije mogao biti napravljen.',
	'webstore_src_open' => 'Izvorni fajl "$1" nije mogao biti otvoren.',
	'webstore_src_close' => 'Greška pri zatvaranju izvornog fajla "$1".',
	'webstore_src_delete' => 'Greška prilikom brisanja izvornog fajla "$1".',
	'webstore_rename' => 'Greška pri preimenovanju fajla "$1" u "$2".',
	'webstore_lock_open' => 'Greška prilikom otključavanja fajla "$1".',
	'webstore_dest_exists' => 'Greška, ciljani fajl "$1" postoji.',
	'webstore_temp_open' => 'Greška prilikom otvaranja privremenog fajla "$1".',
	'webstore_temp_copy' => 'Greška prilikom kopiranja privremenog fajla "$1" na mesto ciljanog fajla "$2".',
	'webstore_temp_close' => 'Greška prilikom zatvaranja privremenog fajla "$1".',
	'webstore_temp_lock' => 'Greška prilikom zaključavanja privremenog fajla "$1".',
	'webstore_no_archive' => 'Ciljani fajl postoji i nkakva arhiva nije navedena.',
	'webstore_no_file' => 'Datoteka nije poslata.',
	'webstore_move_uploaded' => 'Greška priliokm premeštanja poslatog fajla "$1" na privremeno mesto "$2".',
	'webstore_invalid_zone' => 'Pogrešna zona "$1".',
	'webstore_no_deleted' => 'Nije naveden arhivski direktorijum za obrisane fajlove.',
	'webstore_curl' => 'Greška od cURL: $1',
	'webstore_404' => 'Datoteka nije pronađena.',
	'webstore_php_warning' => 'PHP napomena: $1',
	'webstore_metadata_not_found' => 'Datoteka nije pronađena: $1',
	'webstore_postfile_not_found' => 'Nije pronađen fajl za slanje.',
	'webstore_invalid_response' => 'Neadekvatan odgovor od servera:

$1',
	'webstore_no_response' => 'Server ne odgovara',
	'webstore_php_error' => 'Došlo je do PHP grešaka:',
	'webstore_no_handler' => 'Nije definisano transformisanje ovog MIME tipa',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'inplace_access_disabled' => 'Die Tougriep ap dissen Service wuud foar aal Cliente deaktivierd.',
	'inplace_access_denied' => 'Die Tougriep ap dissen Service wäd truch ju IP-Adresse fon dän Client regulierd.',
	'inplace_scaler_no_temp' => 'Neen gultich temporär Ferteeknis.
Sät $wgLocalTmpDirectory ap n Ferteeknis mäd Skrieuwtougriep.',
	'inplace_scaler_not_enough_params' => 'Tou min Parametere.',
	'inplace_scaler_invalid_image' => 'Uungultige Bielde, Grööte kuud nit fääststoald wäide.',
	'inplace_scaler_failed' => 'Bie dät Skalierjen fon ju Bielde is n Failer aptreeden: $1',
	'inplace_scaler_no_handler' => 'Neen Routine tou ju Transformation fon dissen MIME-Typ deer',
	'inplace_scaler_no_output' => 'Ju Transformation moakede neen Uutgoawedoatäi.',
	'inplace_scaler_zero_size' => 'Ju Transformation moakede ne Utgoawedoatäi mäd laangte Nul.',
	'webstore-desc' => 'Online-Twiskenanweendenge tou ju Doatäileegerenge (neen NFS)',
	'webstore_access' => 'Die Tougriep ap dissen Service wäd truch ju IP-Adresse fon dän Client regulierd.',
	'webstore_path_invalid' => 'Die Doatäinoome waas uungultich.',
	'webstore_dest_open' => 'Sieldoatäi "$1" kon nit eepend wäide.',
	'webstore_dest_lock' => 'Sieldoatäi "$1" kon nit speerd wäide.',
	'webstore_dest_mkdir' => 'Sielferteeknis "$1" kon nit moaked wäide.',
	'webstore_archive_lock' => 'Archivdoatäi "$1" kon nit speerd wäide.',
	'webstore_archive_mkdir' => 'Archivferteeknis "$1" kon nit moaked wäide.',
	'webstore_src_open' => 'Wälledoatäi "$1" kon nit eepend wäide.',
	'webstore_src_close' => 'Failer bie dät Sluuten fon Wälledoatäi "$1".',
	'webstore_src_delete' => 'Failer bie dät Läskjen fon Wälledoatäi "$1".',
	'webstore_rename' => 'Failer bie dät Uumnaamen fon ju Doatäi „$1“ tou „$2“.',
	'webstore_lock_open' => 'Failer bie dät Eepenjen fon ju Lockdoatäi "$1".',
	'webstore_lock_close' => 'Failer bie dät Sluuten fon ju Lockdoatäi "$1".',
	'webstore_dest_exists' => 'Failer, Sieldoatäi "$1" existiert.',
	'webstore_temp_open' => 'Kon temporäre Doatäi "$1" nit eepenje.',
	'webstore_temp_copy' => 'Failer bie dät Kopierjen fon ju temporäre Doatäi "$1" tou ju Sieldoatäi "$2".',
	'webstore_temp_close' => 'Failer bie dät Sluuten fon ju temporäre Doatäi "$1".',
	'webstore_temp_lock' => 'Failer bie dät Speeren fon ju temporäre Doatäi "$1".',
	'webstore_no_archive' => 'Sieldoatäi existiert un neen Archiv wuud anroat.',
	'webstore_no_file' => 'Der wuud neen Doatäi hoochleeden.',
	'webstore_move_uploaded' => 'Failer bie dät Ferskuuwen fon ju hoochleedene Doatäi "$1" tou ju Twiskespiekersteede "$2".',
	'webstore_invalid_zone' => 'Uungultige Zone "$1".',
	'webstore_no_deleted' => 'Der wuud neen Achivferteeknis foar läskede Doatäie definierd.',
	'webstore_curl' => 'Failer fon cURL: $1',
	'webstore_404' => 'Doatäi nit fuunen.',
	'webstore_php_warning' => 'PHP-Woarskauenge: $1',
	'webstore_metadata_not_found' => 'Doatäi nit fuunen: $1',
	'webstore_postfile_not_found' => 'Neen Doatäi toun Ienstaalen fuunen.',
	'webstore_scaler_empty_response' => 'Die Bieldeskalierder häd ne loose Oantwoud mäd de Oantoudkode 200 touräächroat.
Dit kuud truch n fatoalen PHP-Failer in dän Skalierder feruurseeked wäide.',
	'webstore_invalid_response' => 'Uungultige Oantwoud fon dän Server:

$1',
	'webstore_no_response' => 'Neen Oantwoud fon dän Server',
	'webstore_backend_error' => 'Failer fon dän Spiekerserver:

$1',
	'webstore_php_error' => 'Der trieden PHP-Failere ap.',
	'webstore_no_handler' => 'Neen Routine tou ju Transformation fon dissen MIME-Typ deer',
);

/** Swedish (Svenska)
 * @author M.M.S.
 * @author Najami
 */
$messages['sv'] = array(
	'inplace_access_disabled' => 'Tillgången till den här tjänsten har stängts av för alla klienter.',
	'inplace_access_denied' => 'Den här tjänsten begränsas av klientens IP.',
	'inplace_scaler_no_temp' => 'Ingen giltig temporär mapp.
Ange $wgLocalTmpDirectory till en skrivbar mapp.',
	'inplace_scaler_not_enough_params' => 'Inte några parametrar.',
	'inplace_scaler_invalid_image' => 'Ogiltig bild, kunde inte fastslå storlek.',
	'inplace_scaler_failed' => 'Ett fel uppstod under bildskalering: $1',
	'inplace_scaler_no_handler' => 'Ingen behandlare för ändring av den här MIME-typen',
	'inplace_scaler_no_output' => 'Ingen ändringsresultatsfil producerades.',
	'inplace_scaler_zero_size' => 'Ändringen producerade en tom resultatsfil.',
	'webstore-desc' => 'Internetbaserad (ej NFS) fillagringsmellanvara',
	'webstore_access' => 'Tjänsten begränsas av klientens IP.',
	'webstore_path_invalid' => 'Filnamnet var ogiltigt.',
	'webstore_dest_open' => 'Kunde inte öppna målfil "$1".',
	'webstore_dest_lock' => 'Kunde inte låsas på målfil "$1".',
	'webstore_dest_mkdir' => 'Kunde inte skapa målmapp "$1".',
	'webstore_archive_lock' => 'Kunde inte låsas på arkivfil "$1".',
	'webstore_archive_mkdir' => 'Kunde inte skapa arkivmapp "$1".',
	'webstore_src_open' => 'Kunde inte öppna källfil "$1".',
	'webstore_src_close' => 'Fel under stängning av källfil "$1".',
	'webstore_src_delete' => 'Fel under radering av källfil "$1".',
	'webstore_rename' => 'Fel under namnbyte av "$1" till "$2".',
	'webstore_lock_open' => 'Fel under öppning av låsfil "$1".',
	'webstore_lock_close' => 'Fel under stängning av låsfil "$1".',
	'webstore_dest_exists' => 'Fel, målfilen "$1" existerar.',
	'webstore_temp_open' => 'Fel under öppning av temporär fil "$1".',
	'webstore_temp_copy' => 'Fel under kopiering av temporär fil "$1" till målfil "$2".',
	'webstore_temp_close' => 'Fel under låsning av temporär fil "$1".',
	'webstore_temp_lock' => 'Fel under låsning av temporär fil "$1".',
	'webstore_no_archive' => 'Målfilen existerar och inget arkiv angavs.',
	'webstore_no_file' => 'Ingen fil laddades upp.',
	'webstore_move_uploaded' => 'Fel under flyttning av uppladdad fil "$1" till temporär plats "$2".',
	'webstore_invalid_zone' => 'Ogiltig zon "$1".',
	'webstore_no_deleted' => 'Ingen arkivmapp för raderade filer angavs.',
	'webstore_curl' => 'Fel från cURL: $1',
	'webstore_404' => 'Filen hittades inte.',
	'webstore_php_warning' => 'PHP-varning: $1',
	'webstore_metadata_not_found' => 'Filen hittades inte: $1',
	'webstore_postfile_not_found' => 'Fil som ska postas hittades inte.',
	'webstore_scaler_empty_response' => 'Bildskaleraren gav ett tomt svar med en 200-responskod.
Detta kan bero på ett fatalt PHP-fel i skaleraren.',
	'webstore_invalid_response' => 'Ogiltigt svar från servern:

$1',
	'webstore_no_response' => 'Inget svar från servern.',
	'webstore_backend_error' => 'Fel från lagringsservern:

$1',
	'webstore_php_error' => 'PHP-fel hittades:',
	'webstore_no_handler' => 'Ingen behandlare för ändring av denna MIME-typ',
);

/** Silesian (Ślůnski)
 * @author Lajsikonik
 */
$messages['szl'] = array(
	'inplace_access_disabled' => 'Dostymp do tyj usługi zostoł wyłůnczůny lů wszyjstkich klijentůw.',
	'inplace_access_denied' => 'Ta usługa je uograńiczůno bez IP klijenta.',
	'inplace_scaler_no_temp' => 'Ńy ma sam poprawnygo kataloga tymczasowygo, nasztaluj $wgLocalTmpDirectory na katalog we kerym idźe szkryflać',
	'inplace_scaler_not_enough_params' => 'Ńywystarczajůnco liczba parametrůw.',
	'inplace_scaler_invalid_image' => 'Ńypoprawno grafika, ńy idźe uokryślić jeij rozmjaru.',
	'inplace_scaler_failed' => 'Zdorzył śe feler przi skalowańu grafiki: $1',
	'inplace_scaler_no_handler' => 'Ńy ma handlera lů transformacyje tyj zorty MIME',
	'inplace_scaler_no_output' => 'Ńy ůtworzůno plika wyjśćowygo transformacyje',
	'inplace_scaler_zero_size' => 'We wyńiku transformacyje powstoł plik uo zerowyj srogośći.',
	'webstore-desc' => 'Yno lů interneca (ńy-NFS) plac lů wćepywańo plikůw',
	'webstore_access' => 'Ta usuga je uograńiczůno lů uokreślůnych adresůw IP klijenta.',
	'webstore_path_invalid' => 'Felerne mjano plika.',
	'webstore_dest_open' => 'Ńy idźe uodymknůńć plika docelowygo "$1".',
	'webstore_dest_lock' => 'Ńy udoło śe zawrzyć plika docelowygo "$1".',
	'webstore_dest_mkdir' => 'Ńy idźe stworzić kataloga docelowygo "$1".',
	'webstore_archive_lock' => 'Ńy idźe zawrzić plika archiwům "$1".',
	'webstore_archive_mkdir' => 'Ńy idźe utworzić kataloga archiwům "$1".',
	'webstore_src_open' => 'Ńy idźe uodymknůńć plika zdrzůdłowygo "$1".',
	'webstore_src_close' => 'Feler podczos zawjyrańo plika zdrzůdłowygo "$1".',
	'webstore_src_delete' => 'Feler przi wyćepywańu plika zdrzůdłowygo "$1".',
	'webstore_rename' => 'Feler przi půmjyńańu mjana plika "$1" na "$2".',
	'webstore_lock_open' => 'Feler przi uodmykańu plika zawarćo "$1".',
	'webstore_lock_close' => 'Feler przi zawjyrańu plika zawarćo "$1".',
	'webstore_dest_exists' => 'Feler: Plik docylowy "$1" już sam můmy.',
	'webstore_temp_open' => 'Feler przi uodmykańu plika tymczasowygo "$1".',
	'webstore_temp_copy' => 'Feler kopjowańo plika tymczasowygo "$1" ku lokalizacyji "$2".',
	'webstore_temp_close' => 'Feler przi zawjyrańu plika tymczasowygo "$1".',
	'webstore_temp_lock' => 'Feler zawjyrańo uod sprowjyń plika tymczasowygo "$1".',
	'webstore_no_archive' => 'Plik docylowy już sam můmy, ńy uokreślůno tyż lokalizacyji archiwům.',
	'webstore_no_file' => 'Ńy wćepano plika.',
	'webstore_move_uploaded' => 'Zdorzył śe feler przi przekludzańu plika "$1" ku lokalizacyje tymczasowyj "$2".',
	'webstore_invalid_zone' => 'Felerno sztrefa "$1".',
	'webstore_no_deleted' => 'Ńy zdefińjowano kataloga archiwum lů wyćepywanych plikůw.',
	'webstore_curl' => 'Feler cURL: $1',
	'webstore_404' => 'Ńy znejdźůno plika.',
	'webstore_php_warning' => 'Uostrzeżyńe PHP $1',
	'webstore_metadata_not_found' => 'Ńy znejdźůno plika $1',
	'webstore_postfile_not_found' => 'Ńy znejdźůno plika do uopublikowańo.',
	'webstore_scaler_empty_response' => 'Modůł skalowańo grafik zwrůćił pusto uodpowjydź s kodym felera 200. Możebne co je tak skiż krytycznygo felera PHP we module skalowańo.',
	'webstore_invalid_response' => 'Serwer uodpedźoł felerńe:

$1',
	'webstore_no_response' => 'Serwer ńy uodpado',
	'webstore_backend_error' => 'Serwer kery przechowujy dane zwrůćůł feler:

$1',
	'webstore_php_error' => 'Trefjůno nastympujůnce felery PHP:',
	'webstore_no_handler' => 'Ńy znejdźůno handlera lů obsugi danych tyj zorty MIME',
);

/** Telugu (తెలుగు)
 * @author Kiranmayee
 * @author Veeven
 */
$messages['te'] = array(
	'inplace_scaler_not_enough_params' => 'సరిపడ పారామీటర్లు లేవు.',
	'inplace_scaler_invalid_image' => 'తప్పుడు బొమ్మ, పరిమాణాన్ని నిర్ణయించలేకున్నాం.',
	'webstore_path_invalid' => 'ఫైలుపేరు తప్పుగా ఉంది.',
	'webstore_dest_open' => '"$1" అనే గమ్యస్థానపు ఫైలుని తెరవలేకున్నాం.',
	'webstore_dest_exists' => 'పొరపాటు, "$1" అనే గమ్యస్థానపు ఫైలు ఇప్పటికే ఉంది.',
	'webstore_temp_open' => '"$1" అనే తాత్కాలిక ఫైలుని తెరవడంలో పొరపాటు.',
	'webstore_temp_close' => '"$1" అనే తాత్కాలిక ఫైలుని మూయడంలో పొరపాటు.',
	'webstore_no_file' => 'ఫైలేమీ ఎగుమతి కాలేదు.',
	'webstore_404' => 'ఫైలు కనబడలేదు.',
	'webstore_php_warning' => 'PHP హెచ్చరిక: $1',
	'webstore_metadata_not_found' => 'ఫైలు కనబడలేదు: $1',
	'webstore_invalid_response' => 'సర్వరు నుండి తప్పుడు స్పందన:

$1',
	'webstore_no_response' => 'సర్వరునుండి స్పందన లేదు',
	'webstore_backend_error' => 'భద్రపరిచే సర్వరు నుండి పొరపాటు:

$1',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'inplace_scaler_not_enough_params' => 'Параметрҳо нокифоя.',
	'webstore_path_invalid' => 'Номи парванда номӯътабар буд.',
	'webstore_no_file' => 'Ҳеҷ парвандае бор нашудааст.',
	'webstore_invalid_zone' => 'Ноҳияи номӯътабар "$1".',
	'webstore_no_deleted' => 'Ҳеҷ пӯшаи бойгонӣ барои парвандаҳои ҳазфшуда мушаххас нашудааст.',
	'webstore_404' => 'Парванда ёфт нашуд.',
	'webstore_php_warning' => 'Ҳушдори PHP: $1',
	'webstore_metadata_not_found' => 'Парванда ёфт нашуд: $1',
	'webstore_postfile_not_found' => 'Парванда барои фиристодан ёфт нашуд.',
	'webstore_php_error' => 'Хатоҳои PHP рух доданд:',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'inplace_scaler_not_enough_params' => 'Parametrho nokifoja.',
	'webstore_path_invalid' => "Nomi parvanda nomū'tabar bud.",
	'webstore_no_file' => 'Heç parvandae bor naşudaast.',
	'webstore_invalid_zone' => 'Nohijai nomū\'tabar "$1".',
	'webstore_no_deleted' => 'Heç pūşai bojgonī baroi parvandahoi hazfşuda muşaxxas naşudaast.',
	'webstore_404' => 'Parvanda joft naşud.',
	'webstore_php_warning' => 'Huşdori PHP: $1',
	'webstore_metadata_not_found' => 'Parvanda joft naşud: $1',
	'webstore_postfile_not_found' => 'Parvanda baroi firistodan joft naşud.',
	'webstore_php_error' => 'Xatohoi PHP rux dodand:',
);

/** Thai (ไทย)
 * @author Manop
 */
$messages['th'] = array(
	'inplace_scaler_not_enough_params' => 'พารามิเตอร์ไม่เพียงพอ',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'webstore_404' => 'Faýl tapylmady.',
	'webstore_php_warning' => 'PHP Duýduryşy: $1',
	'webstore_metadata_not_found' => 'Faýl tapylmady: $1',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'inplace_access_disabled' => 'Hindi pinaandar para sa lahat ng mga kliyente ang akseso o daan para sa ganitong paglilingkod/serbisyo .',
	'inplace_access_denied' => 'Ipinagbawal ng IP ng kliyente ang ganitong paglilingkod/serbisyo.',
	'inplace_scaler_no_temp' => 'Walang tanggap na pansamantalang direktoryo.
Itakda sa isang nasusulatan/masusulatang direktoryo ang $wgLocalTmpDirectory',
	'inplace_scaler_not_enough_params' => 'Hindi sapat na mga parametro (sukat).',
	'inplace_scaler_invalid_image' => 'Hindi tanggap na larawan, hindi matukoy ang sukat.',
	'inplace_scaler_failed' => 'May dinanas/nasalubong na kamalian habang sinusukat ang larawan: $1',
	'inplace_scaler_no_handler' => 'Walang tagapamahalang magsasagawa ng pagbago sa anyo ng ganitong uri ng MIME',
	'inplace_scaler_no_output' => 'Walang nagawang produkto/kinalabasang talaksan ng pagbabago.',
	'inplace_scaler_zero_size' => 'Nakagawa ang pagbabagong-anyo ng isang walang sukat na produkto/kinalabasang talaksan',
	'webstore-desc' => 'Pang-web lamang (hindi pang-NFS) na panggitnang-gamit na taguan ng talaksan',
	'webstore_access' => 'Pinagbawalan ng kliyente ng IP ang ganitong paglilingkod/serbisyo.',
	'webstore_path_invalid' => 'Hindi tanggap ang pangalan ng talaksan.',
	'webstore_dest_open' => 'Hindi nabuksan/mabuksan ang bukas na patutunguhang talaksang "$1".',
	'webstore_dest_lock' => 'Nabigo ang pagkapit/pagkabit sa patutunguhang talaksang "$1".',
	'webstore_dest_mkdir' => 'Hindi nagawang/magawang likhain ang patutunguhang direktoryong "$1".',
	'webstore_archive_lock' => 'Nabigo sa pagkapit/pagkabit sa sinupan/arkibong talaksang "$1".',
	'webstore_archive_mkdir' => 'Nabigo sa paglikha ng sinupan/arkibong direktoryong "$1".',
	'webstore_src_open' => 'Nabigo sa pagbukas ng pinagmulang talaksang "$1".',
	'webstore_src_close' => 'May kamalian sa pagsasara ng pinagmulang talaksang "$1".',
	'webstore_src_delete' => 'May kamalian sa pagbura ng pinagmulang talaksang "$1".',
	'webstore_rename' => 'May kamalian sa muling pagpapangalan ng talaksan mula sa "$1" patungong (upang maging) "$2".',
	'webstore_lock_open' => 'May kamalian sa pagbubukas ng may kandadong talaksang "$1".',
	'webstore_lock_close' => 'May kamalian sa pagsasara ng may kandadong talaksang "$1".',
	'webstore_dest_exists' => 'Kamalian, umiiral na ang kapupuntahang talaksang "$1".',
	'webstore_temp_open' => 'May kamalian sa pagbubukas ng pansamantalang talaksang "$1".',
	'webstore_temp_copy' => 'May kamalian sa pagkopya ng pansamantalang talaksang "$1" papunta sa kapupuntahang talaksang "$2".',
	'webstore_temp_close' => 'May kamalian sa pagsasara ng pansamantalang talaksang "$1".',
	'webstore_temp_lock' => 'May kamalian sa pagkakandado ng pansamantalang talaksang "$1".',
	'webstore_no_archive' => 'Umiiral ang kapupuntahang talaksan at walang ibinigay na sinupan/arkibo.',
	'webstore_no_file' => 'Walang naikargang talaksan.',
	'webstore_move_uploaded' => 'May kamalian sa paglilipat na ikinargang talaksang "$1" papunta sa pansamantalang lokasyon/pook na "$2".',
	'webstore_invalid_zone' => 'Hindi tanggap ang sonang "$1".',
	'webstore_no_deleted' => 'Walang nilarawang direktoryong sinupan/pang-arkibo para sa nabura/binurang mga talaksan.',
	'webstore_curl' => 'May kamalian mula sa cURL: $1',
	'webstore_404' => 'Hindi natagpuan ang talaksan.',
	'webstore_php_warning' => 'Babala ng PHP: $1',
	'webstore_metadata_not_found' => 'Hindi natagpuang talaksan: $1',
	'webstore_postfile_not_found' => 'Hindi natagpuan ang itatalang talaksan.',
	'webstore_scaler_empty_response' => 'Nagbigay ng walang lamang tugon (sagot) ang manunukat/tagapagsukat ng larawan na may kodigo sa pagtugong 200.
Maaaring dahil ito sa isang malubhang kamaliang pang-PHP sa loob ng pansukat.',
	'webstore_invalid_response' => 'Hindi tanggap na tugon mula sa serbidor:

$1',
	'webstore_no_response' => 'Walang tugon mula sa serbidor',
	'webstore_backend_error' => 'Kamalian mula sa taguang serbidor:

$1',
	'webstore_php_error' => 'May nasalubong na (nakaranas ng) mga kamaliang pang-PHP:',
	'webstore_no_handler' => 'Walang tagapamahala para sa pagbabago ng anyo ng ganitong uri ng MIME',
);

/** Turkish (Türkçe)
 * @author Karduelis
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'webstore_path_invalid' => 'Dosya adı geçersiz.',
	'webstore_404' => 'Dosya bulunamadı.',
	'webstore_php_warning' => 'PHP Uyarısı: $1',
	'webstore_metadata_not_found' => '$1 dosyası bulunamadı',
	'webstore_postfile_not_found' => 'Gönderilecek dosya bulunamadı.',
	'webstore_invalid_response' => 'Sunucudan geçersiz cevap:

$1',
	'webstore_no_response' => 'Sunucudan cevap yok',
	'webstore_php_error' => 'PHP hataları ile karşılaşıldı:',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'webstore_path_invalid' => 'Failannimi oli vär.',
	'webstore_dest_open' => 'Ei voi avaita "$1"-failad.',
	'webstore_404' => 'Fail ei ole löutud.',
	'webstore_php_warning' => 'PHP Varatuz: $1',
	'webstore_metadata_not_found' => 'Fail ei ole löutud: $1',
	'webstore_postfile_not_found' => 'Ei voi löuta failad oigetes.',
	'webstore_invalid_response' => 'Vär vastuz serveralpäi:

$1',
	'webstore_no_response' => 'Server ei anda vastust.',
	'webstore_backend_error' => 'Serveran-varaaitan petuz:

$1',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'inplace_scaler_not_enough_params' => 'Không có đủ tham số.',
	'inplace_scaler_invalid_image' => 'Hình không hợp lệ: không thể tính kích cỡ được.',
	'webstore_path_invalid' => 'Tên tập tin không hợp lệ.',
	'webstore_src_open' => 'Lỗi khi mở tập tin nguồn “$1”.',
	'webstore_src_close' => 'Lỗi khi đóng tập tin nguồn “$1”.',
	'webstore_src_delete' => 'Lỗi khi xóa tập tin nguồn “$1”.',
	'webstore_rename' => 'Lỗi khi đổi tên tập tin “$1” thành “$2”.',
	'webstore_lock_open' => 'Lỗi mở tập tin khóa “$1”.',
	'webstore_lock_close' => 'Lỗi đóng tập tin khóa “$1”.',
	'webstore_dest_exists' => 'Lỗi: tập tin đích “$1” đã tồn tại.',
	'webstore_temp_open' => 'Lỗi mở tập tin tạm “$1”.',
	'webstore_temp_copy' => 'Lỗi chép tập tin tạm “$1” qua tập tin đích “$2”.',
	'webstore_temp_close' => 'Lỗi đóng tập tin tạm “$1”.',
	'webstore_temp_lock' => 'Lỗi khóa tập tin tạm “$1”.',
	'webstore_no_file' => 'Chưa tải lên tập tin nào.',
	'webstore_curl' => 'Lỗi cURL: $1',
	'webstore_404' => 'Không tìm thấy tập tin.',
	'webstore_php_warning' => 'Cảnh báo PHP: $1',
	'webstore_metadata_not_found' => 'Không tìm thấy tập tin: $1',
	'webstore_postfile_not_found' => 'Không tìm thấy tập tin để đăng.',
	'webstore_php_error' => 'Gặp lỗi PHP:',
);

/** Volapük (Volapük)
 * @author Smeira
 */
$messages['vo'] = array(
	'inplace_access_disabled' => 'Dün at penemögükon gebanes valik.',
	'inplace_scaler_not_enough_params' => 'Paramets nesaidik',
	'inplace_scaler_invalid_image' => 'Magod no lonöföl, no eplöpos ad fümetön gretoti.',
	'webstore_path_invalid' => 'Ragivanem no lonöföl.',
	'webstore_dest_open' => 'No eplöpos ad maifükön zeilaragivi: „$1“.',
	'webstore_dest_mkdir' => 'Jafam zeilaragiviära: „$1“ no eplöpon.',
	'webstore_src_open' => 'No eplöpos ad maifükön ragivi: „$1“.',
	'webstore_src_close' => 'Pöl pö färmükam zeilaragiva: „$1“.',
	'webstore_src_delete' => 'Pöl pö moükam zeilaragiva: „$1“.',
	'webstore_rename' => 'Pöl pö votanemam ragiva: „$1“ as „$2“.',
	'webstore_lock_open' => 'Pöl pö maifükam lökaragiva: „$1“.',
	'webstore_lock_close' => 'Pöl pö färmükam lökaragiva: „$1“.',
	'webstore_dest_exists' => 'Pöl: zeilaragiv: „$1“ ya dabinon.',
	'webstore_temp_open' => 'Pöl pö maifükam ragiva nelaidüpik: „$1“.',
	'webstore_temp_copy' => 'Pök pö kopiedam ragiva nelaidüpik: „$1“ ad zeilaragiv: „$2“.',
	'webstore_temp_close' => 'Pöl pö färmükam ragiva nelaidüpik: „$1“.',
	'webstore_temp_lock' => 'Pöl pö lökofärmükam ragiva nelaidüpik: „$1“.',
	'webstore_no_file' => 'Ragiv nonik pelöpükon.',
	'webstore_move_uploaded' => 'Pöl pö topätükam ragiva pelöpüköl: „$1“ lü top nelaidüpik: „$2“.',
	'webstore_curl' => 'Pöl se cURL: $1',
	'webstore_404' => 'Ragiv no petuvon.',
	'webstore_php_warning' => 'Nuned-PHP: $1',
	'webstore_metadata_not_found' => 'Ragiv no petuvon: $1',
	'webstore_invalid_response' => 'Gespik no lonöföl se dünanünöm:

$1',
	'webstore_no_response' => 'Gespik nonik se dünanünöm',
	'webstore_php_error' => 'Pöls-PHP petuvons:',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'inplace_scaler_not_enough_params' => 'נישטא גענוג פאראמעטערס',
	'webstore_path_invalid' => 'טעקע נאמען איז אומגילטיק.',
	'webstore_dest_open' => 'קען נישט עפֿענען די ציל טעקע "$1"',
	'webstore_dest_lock' => 'נישט געקענט פֿאַרשפאַרן ציל טעקע "$1".',
	'webstore_archive_lock' => 'נישט געקענט פֿאַרשפאַרן אַרכיוו טעקע "$1".',
	'webstore_rename' => 'גרײַז בײַם ווידעראָנרופֿן טעקע פֿון "$1" צו "$2".',
);

/** Chinese (China) (‪中文(中国大陆)‬)
 * @author Gzdavidwong
 */
$messages['zh-cn'] = array(
	'inplace_scaler_invalid_image' => '图像不可识别，无法检测尺寸。',
	'inplace_scaler_failed' => '处理图像时遇到一个错误： $1',
	'webstore_path_invalid' => '文件名无法识别。',
	'webstore_no_file' => '上传文件未成功。',
	'webstore_404' => '文件未找到。',
	'webstore_php_warning' => 'PHP警告：$1',
	'webstore_metadata_not_found' => '文件未找到：$1',
	'webstore_no_response' => '服务器未响应',
	'webstore_php_error' => '遇到PHP错误：',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gaoxuewei
 */
$messages['zh-hans'] = array(
	'inplace_access_disabled' => '所有用户端均不能使用本服务。',
	'inplace_access_denied' => '您的IP无法访问本服务。',
	'inplace_scaler_no_temp' => '无法识别的临时目录。
请设置 $wgLocalTmpDirectory 到一个可写入的目录。',
	'inplace_scaler_not_enough_params' => '参数不足。',
	'inplace_scaler_invalid_image' => '图像不可识别，无法检测尺寸。',
	'inplace_scaler_failed' => '处理图像时遇到一个错误： $1',
	'webstore_access' => '您的IP无法访问本服务。',
	'webstore_path_invalid' => '文件名无法识别。',
	'webstore_dest_open' => '无法打开目标文件"$1"。',
	'webstore_dest_mkdir' => '无法创建目录"$1"。',
	'webstore_src_open' => '无法打开源文件"$1"。',
	'webstore_src_close' => '关闭源文件"$1"出现错误。',
	'webstore_src_delete' => '删除源文件"$1"出现错误。',
	'webstore_rename' => '文件"$1"修改名称为"$2"时出现错误。',
	'webstore_dest_exists' => '出错啦，目标文件"$1"已经存在。',
	'webstore_temp_open' => '打开临时文件"$1"出错。',
	'webstore_temp_copy' => '拷贝临时文件"$1"至目标文件"$2"时出错。',
	'webstore_temp_close' => '关闭临时文件"$1"出错。',
	'webstore_no_file' => '上传文件未成功。',
	'webstore_move_uploaded' => '移动上传的文件"$1"至临时地址"$2"时出错。',
	'webstore_404' => '文件未找到。',
	'webstore_php_warning' => 'PHP警告：$1',
	'webstore_metadata_not_found' => '文件未找到：$1',
	'webstore_invalid_response' => '服务器响应：

$1',
	'webstore_no_response' => '服务器未响应',
	'webstore_backend_error' => '存储服务器出现错误：

$1',
	'webstore_php_error' => '遇到PHP错误：',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Liangent
 * @author Mark85296341
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'inplace_access_disabled' => '所有客戶端均不能使用本服務。',
	'inplace_access_denied' => '您的 IP 無法訪問本服務。',
	'inplace_scaler_no_temp' => '無法識別的暫存目錄。
請設定 $wgLocalTmpDirectory 到一個可寫入的目錄。',
	'inplace_scaler_not_enough_params' => '參數不足。',
	'inplace_scaler_invalid_image' => '圖片無效，不能判斷大小。',
	'inplace_scaler_failed' => '在縮放圖片期間遇到錯誤：$1',
	'webstore_access' => '您的 IP 無法訪問本服務。',
	'webstore_path_invalid' => '檔名無效。',
	'webstore_dest_open' => '無法開啟目標檔案「$1」。',
	'webstore_dest_mkdir' => '無法建立目標目錄「$1」。',
	'webstore_src_open' => '無法打開源檔案「$1」。',
	'webstore_src_close' => '關閉來源檔案「$1」時發生錯誤。',
	'webstore_src_delete' => '刪除來源檔案「$1」時發生錯誤。',
	'webstore_rename' => '檔案「$1」修改名稱為「$2」時出現錯誤。',
	'webstore_dest_exists' => '錯誤，目標檔案「$1」已經存在。',
	'webstore_temp_open' => '開啟暫存檔案「$1」時發生錯誤。',
	'webstore_temp_copy' => '複製暫存檔案「$1」至目標檔案「$2」時發生錯誤。',
	'webstore_temp_close' => '關閉暫存檔案「$1」時發生錯誤。',
	'webstore_no_file' => '沒有上傳檔案。',
	'webstore_move_uploaded' => '移動上傳的檔案「$1」至暫存位址「$2」時發生錯誤。',
	'webstore_404' => '找不到檔案。',
	'webstore_php_warning' => 'PHP 警告：$1',
	'webstore_metadata_not_found' => '找不到檔案：$1',
	'webstore_invalid_response' => '伺服器傳回無效的反應：

$1',
	'webstore_no_response' => '伺服器沒有反應',
	'webstore_backend_error' => '儲存服務器出現錯誤：

$1',
	'webstore_php_error' => '遇到 PHP 錯誤：',
);

