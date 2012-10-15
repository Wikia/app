<?php
/*
Page:           _drawrating.php
Created:        Aug 2006
Last Mod:       Mar 11 2007
The function that draws the rating bar.
--------------------------------------------------------- 
ryan masuga, masugadesign.com
ryan@masugadesign.com 
--------------------------------------------------------- */

function rating_bar($id,$units='',$static='') 
{ 
  //set some variables
  if(isset($_SERVER['REMOTE_ADDR']))
    $ip = $_SERVER['REMOTE_ADDR'];
  else
    $ip = "127.0.0.1";

  $tableName     = 'ratings';
  if (!$units) {$units = 10;}
  if (!$static) {$static = FALSE;}
  $unitwidth     = 30; // the width (in pixels) of each rating unit (star, etc.)

  $dbw = wfGetDB( DB_MASTER );
  
  $qr = $dbw->query("SELECT total_votes, total_value, used_ips FROM $tableName WHERE id='$id' ")or die(" Error: ".mysql_error());
  $query = $qr->result;

  // insert the id in the DB if it doesn't exist already
  // see: http://www.masugadesign.com/the-lab/scripts/unobtrusive-ajax-star-rating-bar/#comment-121

  if (mysql_num_rows($query) == 0) 
  {
    $sql = "INSERT INTO $tableName (`id`,`total_votes`, `total_value`, `used_ips`) VALUES ('$id', '0', '0', '')";
    $qr = $dbw->query($sql);
    // who cares ... $result = $qr->result;
  }

  $numbers=mysql_fetch_assoc($query);
  $count=$numbers['total_votes']; //how many votes total
  $current_rating=$numbers['total_value']; //total number of rating added together and stored
  $tense=($count==1) ? "Stimme" : "Stimmen"; //plural form votes/vote

  // determine whether the user has voted, so we know how to draw the ul/li
  $qr = $dbw->query("SELECT used_ips FROM $tableName WHERE used_ips LIKE '%".$ip."%' AND id='".$id."' "); 
  $voted=mysql_num_rows($qr->result); 

  // now draw the rating bar
  $rput = "";

  $rating_width = @number_format($current_rating/$count,2)*$unitwidth;
  $rating1 = @number_format($current_rating/$count,1);
  $rating2 = @number_format($current_rating/$count,2);



  $uwidth = $unitwidth * $units;

  $rput .= <<<ETX

  <div class="ratingblock">

  <div id="unit_long">
		  <ul id="unit_ul$id" class="unit-rating" style="width:${uwidth}px;">
		  <li class="current-rating" style="width:${rating_width}px;">Bewertung $rating2/$units</li>
ETX;
	  for ($ncount = 1; $ncount <= $units; $ncount++) { // loop from 1 to the number of units
		  if(!$voted) { // if the user hasn't yet voted, draw the voting stars 

  $formurl = Title::newFromText( 'RatingDB', NS_SPECIAL )->getFullURL();

  $rput .= <<<ETX
  <li><a href="$formurl?j=$ncount&amp;q=$id&amp;t=$ip&amp;c=$units" title="$ncount von $units" class="r$ncount-unit rater" rel="nofollow">$ncount</a></li>
ETX;

	   } 
    }
	  $ncount=0; // resets the count

  if($voted)
    $pclass = " class=\"voted\"";
  else
    $pclass = "";

  if($count == "")
    $count = "keine";

  $rput .= <<<ETX
		  </ul>
		  <p$pclass><strong>$rating1</strong> von $units<br />($count $tense abgegeben)
		  </p>
  </div>
  </div>
ETX;

  return $rput;
}
