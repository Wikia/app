<?php

$functions = ['idf', 'tf', 'termfreq'];
$fieldsTxt = ['title_en', 'nolang_txt', 'html_en', 'wikititle_en', 'titleStrict'];
$qaFields = ['words', 'wiki_images', 'wiki_official_b', 'is_main_page', 'backlinks', 'wikipages', 'wikiviews_weekly', 'wikiarticles', 'page_images', 'activeusers', 'revcount'] ;


$text='';

foreach($functions as $v)
{
	foreach($fieldsTxt as $x)
	{
		$text.= $v.'('.$x.',$aa) ';
	}

}



//$q = urlencode($argv[1]);
$q ='Brad Pitt';
$endp = 'http://search-s10.wikia-prod:8983/solr/main/select?';

/*
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
*/

$arr =  [
	'lowercaseOperators' => 'true',
	'debugQuery' => 'true',
	'fl' => 'wid, title_en, url, id,' . (implode(',',$qaFields)) ,
	'indent' => 'true',
	'q' => 'url:http://religion.wikia.com/wiki/Brad_Pitt',
	'bf' => $text,
	'aa' => $q,
	'aw' =>$q.' Wiki',
	'qs' => 2,
	'stopwords' => 'true',
	'wt' => 'json',
	'rows' => 4,
	'defType' => 'edismax',
];

/*
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
*/
//die();


$a = $endp.http_build_query($arr);


/*
$a = 'http://search-s10.wikia-prod:8983/solr/main/select?q=%2Btitle_en%3A%22'.$q.'%22%0A%2Bns%3A0&fl=wid%2C+title_en%2C+url%2C+id%2Cwiki_official_b%2Cns%2Cbacklinks%2Cwikipages%2Cviews&wt=json&indent=true&debugQuery=true&defType=edismax&qs=2&bf=sum%28product%28product%28atan%28div%28wikipages%2C100%29%29%2Cproduct%28div%28backlinks%2Cwikipages%29%2C1000000%29%29%2Cif%28wiki_official_b%2C10%2C1%29%29%2Cproduct%28termfreq%28%27titleStrict%27%2C%24aa%29%2C10000000%29%29&stopwords=true&rows=3&lowercaseOperators=true&aa='.$q;
*/


$j = file_get_contents($a);
$obj = json_decode($j);
$docs = $obj->response->docs;
$doc = (array)array_shift($docs);

foreach($qaFields as $v )
{
	echo $doc[$v]."\n";
}
$a = (array)$obj->debug->explain;
$t = array_shift($a);

preg_match_all('~\s[a-z0-9]+\([^\)]+\)=[0-9.]+~m',$t,$m);
echo implode($m[0],"\n");

die();

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

