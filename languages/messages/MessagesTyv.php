<?php
/** Tuvinian (Тыва дыл)
 *
 * @ingroup Language
 * @file
 *
 * @author Andrijko Z.
 * @author Krice from Tyvanet.com
 * @author Sborsody
 * @author friends at tyvawiki.org
 * @author לערי ריינהארט
 */

$namespaceNames = array(
	NS_MEDIA            => 'Медиа',
	NS_SPECIAL          => 'Тускай',
	NS_TALK             => 'Чугаа',
	NS_USER             => 'Aжыглакчы',
	NS_USER_TALK        => 'Aжыглакчы_чугаазу',
	NS_PROJECT_TALK     => '$1_чугаазу',
	NS_FILE             => 'Файл',
	NS_FILE_TALK        => 'Файл_чугаазу',
	NS_MEDIAWIKI        => 'МедиаВики',
	NS_MEDIAWIKI_TALK   => 'МедиаВики_чугаазу',
	NS_TEMPLATE         => 'Хээ',
	NS_TEMPLATE_TALK    => 'Хээ_чугаазу',
	NS_HELP             => 'Дуза',
	NS_HELP_TALK        => 'Дуза_чугаазу',
	NS_CATEGORY         => 'Бөлүк',
	NS_CATEGORY_TALK    => 'Бөлүк_чугаазу',
);

$namespaceAliases = array(
	'Aжыглакчы_чугаа' => NS_USER_TALK,
	'$1_чугаа'        => NS_PROJECT_TALK,
	'Чурук'           => NS_FILE,
	'Чурук_чугаа'     => NS_FILE_TALK,
	'МедиаВики_чугаа' => NS_MEDIAWIKI_TALK,
	'Хээ_чугаа'       => NS_TEMPLATE_TALK,
	'Дуза_чугаа'      => NS_HELP_TALK,
	'Бөлүк_чугаа'     => NS_CATEGORY_TALK,
);

$bookstoreList = array(
	'ОЗОН' => 'http://www.ozon.ru/?context=advsearch_book&isbn=$1',
	'Books.Ru' => 'http://www.books.ru/shop/search/advanced?as%5Btype%5D=books&as%5Bname%5D=&as%5Bisbn%5D=$1&as%5Bauthor%5D=&as%5Bmaker%5D=&as%5Bcontents%5D=&as%5Binfo%5D=&as%5Bdate_after%5D=&as%5Bdate_before%5D=&as%5Bprice_less%5D=&as%5Bprice_more%5D=&as%5Bstrict%5D=%E4%E0&as%5Bsub%5D=%E8%F1%EA%E0%F2%FC&x=22&y=8',
	'Яндекс.Маркет' => 'http://market.yandex.ru/search.xml?text=$1',
	'Amazon.com' => 'http://www.amazon.com/exec/obidos/ISBN=$1',
	'AddALL' => 'http://www.addall.com/New/Partner.cgi?query=$1&type=ISBN',
	'PriceSCAN' => 'http://www.pricescan.com/books/bookDetail.asp?isbn=$1',
	'Barnes & Noble' => 'http://shop.barnesandnoble.com/bookSearch/isbnInquiry.asp?isbn=$1'
);

$fallback8bitEncoding = "windows-1251";

