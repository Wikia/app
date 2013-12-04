<?php
//$q = urlencode($argv[1]);
$q =ucwords($_GET['query']);
$endp = 'http://search-s10.wikia-prod:8983/solr/main/select?';


function _sums($in,$x = 0)
{
	$out = '';
	$c = count($in);
	if($x<$c)
	{
		return 'sum('.$in[$x]. ','._sums($in,$x+1).')';
	}
	else return '0';
}

$deny = '-wid:58191 -wid:95  -wid:547090 -wid:43339';
$qw = $q.' Wiki';
$arr =  [
	'lowercaseOperators' => 'true',
	'debugQuery' => 'true',
	'fl' => 'wid, title_en, url, id,wiki_official_b,ns,backlinks,wikipages,views,words,pageid,page_images,wiki_images,redirect_titles_mv_en',
	'indent' => 'true',
	'q' => '+(title_en:"'.$q.'" OR redirect_titles_mv_en:"'.$q.'"^0.5 OR html_en:"'.$q.'" OR titleStrict:"'.$q.'" OR wikititle_en:"'.$qw.'"^20 OR nolang_txt:"'.$q.'"^1000) +ns:0 +lang:en '.$deny,
	//'bf' => 'product(atan(div(wikipages,200)),10000000) product(div(backlinks,wikipages),1000000) if(wiki_official_b,10000,1) product(termfreq(redirect_titles_mv_en,$aa),1000000)  if(termfreq(\'titleStrict\',$aa),10000000,0) product(atan(div(words,1500)),10000)  product(atan(div(views,150)),10000) ',
	'aa' => $q,
	'aw' =>$q.' Wiki',
	'qs' => 2,
	'stopwords' => 'true',
	'wt' => 'json',
	'rows' => 4,
	'defType' => 'edismax',
];


$alg = ['product(div(backlinks,wikipages),10000000)',
		'product(atan(div(wikipages,2000)),10000000)',
		'if(wiki_official_b,1000000,1)',
		'if(termfreq(\'titleStrict\',$aa),1000000000,0)',
		'product(termfreq(\'redirect_titles_mv_en\',$aa),10000000)',
		'product(termfreq(\'redirect_titles_mv_en\',$aw),20000000)',
		'product(termfreq(\'wikititle_en\',$aw),20000000)',
		'product(atan(div(words,200)),1000000)',
		'product(atan(div(views,150)),10000000)',
		'product(atan(div(wiki_images,200)),10000000)'
	//	'product(product(div(page_images,wiki_images),100000),product(log(div(wiki_images,wikipages)),100000))'
];
//die();

$arr['bf'] = _sums($alg);
$arr_wikis = $arr;
$arr_wikis['aa'] = $q.' Wiki';
$arr_wikis['q'] = '+(wiki_description_txt:"'.$q.'" OR title_en:"'.$q.'") +ns:0 '.$deny;


$alg = [
	'product(termfreq(html_en,$aa),1000)',
	'if(wiki_official_b,1000,1)',
	'product(product(div(page_images,wiki_images),100000),product(log(div(wiki_images,wikipages)),100000))'
];
$arr_wikis['bf'] = _sums($alg);

$wlist = file_get_contents($endp.http_build_query($arr_wikis));
$obj = json_decode($wlist);
$arr1 = [];
if($obj && isset($obj->response))
{
	$arr1 = $obj->response->docs;
}
//die();
//echo "Articles:\n\n";


$a = $endp.http_build_query($arr);


/*
$a = 'http://search-s10.wikia-prod:8983/solr/main/select?q=%2Btitle_en%3A%22'.$q.'%22%0A%2Bns%3A0&fl=wid%2C+title_en%2C+url%2C+id%2Cwiki_official_b%2Cns%2Cbacklinks%2Cwikipages%2Cviews&wt=json&indent=true&debugQuery=true&defType=edismax&qs=2&bf=sum%28product%28product%28atan%28div%28wikipages%2C100%29%29%2Cproduct%28div%28backlinks%2Cwikipages%29%2C1000000%29%29%2Cif%28wiki_official_b%2C10%2C1%29%29%2Cproduct%28termfreq%28%27titleStrict%27%2C%24aa%29%2C10000000%29%29&stopwords=true&rows=3&lowercaseOperators=true&aa='.$q;
*/


$j = file_get_contents($a);
$obj = json_decode($j);
//print_r($obj);
//die();

$ar2 = [];
if($obj && isset($obj->response))
{
	$arr2 = $obj->response->docs;
}


$out = [];
for($i =0;$i<4;$i++){
	/*if(!empty($arr1))
	{
		$a = array_shift($arr1);
		$out[$a->id] = ['wikiId'=>$a->wid, 'articleId' =>$a->pageid,'title'=>$a->title_en, 'url'=>$a->url];
	}*/

	if(!empty($arr2))
	{
		$a = array_shift($arr2);
		$out[$a->id] = ['wikiId'=>$a->wid, 'articleId' =>$a->pageid,'title'=>$a->title_en, 'url'=>$a->url];
	}
}
header('Content-type: application/json');
echo json_encode(['articles'=>array_values($out)]);
//*/

//var_dump($arr2);

