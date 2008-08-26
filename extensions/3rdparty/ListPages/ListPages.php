<?php
$wgExtensionFunctions[] = "wfListPages";

function wfListPages() {
    global $wgParser ,$wgOut;
	$wgOut->addScript("<script type=\"text/javascript\" src=\"extensions/ListPages/ListPages.js\"></script>\n");
    $wgParser->setHook( "ListPages", "ListPages" );
}

function ListPages( $input ) {
	require_once ('ListPagesClass.php');
	//purgePage();
	$details = 1;
	
	getValue($ctg,$input,"category");
	getValue($count,$input,"count");
	getValue($order,$input,"sort");
	getValue($orderMethod,$input,"order");
	getValue($level,$input,"level");
	getValue($details,$input,"details");
	getValue($showpub,$input,"published");
	getValue($showuser,$input,"showuser");
	getValue($random,$input,"random");
	getValue($nav,$input,"nav");
	getValue($showctg,$input,"showcategories");
	getValue($showpic,$input,"showpicture");
	getValue($showblurb,$input,"showblurb");
	getValue($blurbfontsize,$input,"blurbfontsize");
	getValue($cache,$input,"cache");
	getValue($showRating,$input,"rating");
	getValue($date,$input,"showdate");
	getValue($stats,$input,"showstats");
	getValue($votebox,$input,"votebox");
	getValue($ratingMin,$input,"rating minimum");
	if(strpos(strtoupper($details),"VOTEBOXTITLE") !== false){
		$list = new ListPagesView();
	}else{
		$list = new ListPages();
	}
	$list->setCategory($ctg);
	$list->setShowCount($count);
	$list->setPageNo(1);
	$list->setSortBy($order);
	$list->setOrder($orderMethod);
	$list->setLevel($level);
	$list->setShowDetails($details);
	$list->setShowPublished($showpub);
	$list->setShowBlurb($showblurb);
	$list->setBlurbFontSize($blurbfontsize);
	$list->setHash($input);
	$list->setRatingMin($ratingMin);
	
	$list->setBool("ShowUser",$showuser);
	$list->setBool("ShowNav",$nav);
	$list->setBool("random",$random);
	$list->setBool("ShowCtg",$showctg);
	$list->setBool("ShowPic",$showpic);
	$list->setBool("ShowRating",$showRating);
	$list->setBool("ShowDate",$date);
	$list->setBool("ShowStats",$stats);
	$list->setBool("ShowVoteBox",$votebox);
	$list->setBool("useCache",$cache);

	$output  = $list->DisplayList();

    return $output;
}

?>
