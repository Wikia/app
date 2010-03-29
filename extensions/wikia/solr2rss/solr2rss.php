<?php
/* For the supplied solr search query, fetch from solr backend and convert to RSS.
 *
 * Sample url:
 * http://$host/solr2rss.php?q=hub:Wikianswers&sort=created+desc&rows=15
 *
 * Making changes? Validate them here:
 * http://beta.feedvalidator.org/
 *
 * Story:
 *
The answers home page has an activity feed that pulled in recently
created answers pages. Before solr2rss, it was using a and a
Yahoo! Pipes feed (http://tinyurl.com/ydnknbj). This was less
than desirable because A) It's an external dependency and B) it
required us to manually update it when we add new answers sites.
Since we will soon be adding a large number of answers sites, this
won't work well.

Solr/Lucene seems to be a good solution. Jason has helped me craft a
query that is limited to hub=answers and sorted by creation date.
Assuming that all new answers sits are created with a hub of
answers, this should work nicely.  The only wrinkle is that Solr
does not natively support RSS as one of it's output formats (Boo!).
So I wrote a thin PHP script that downloads results from Solar in
the native PHP format, and outputs RSS.

Other ideas explored
) Extending lucene search to output RSS directly (Jason said not easy)
) Creating a new extension that would pull the results down and
display them directly from solr (reinventing the RSS2Wiki extension)

This doesn't really use mediawiki, so it doesn't really make sense
to be in the extensions directory. If you have a better idea, go ahead.

-Nick
 */

define('RSS_DATE_FORMAT', 'D, d M Y H:i:s O');
$hostname = trim(`hostname`);

$params = $_GET;
if (empty($params)){
	echo "<!--\n";
	echo "A search query must be supplied. Example:\n";
	echo "http://{$_SERVER['HTTP_HOST']}/solr2rss.php?q=hub:Wikianswers&sort=created+desc&rows=15";
	echo "-->\n";
	exit;
}


// ********  Fetch from solr
$params['wt'] = 'php'; // hard code to php output
// No more than 100 results
if (empty($params['rows']) || $params['rows'] > 100){
	$params['rows'] = 15;	
}

// Curl setup
$ch = curl_init();
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// No varnishes on dev boxes 
if (preg_match('/dev/', $hostname)){
	$host = "10.8.2.216:8983";
} else {
	// Live site use local varnish proxy
	curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:6081');
	$host = "search";
} 

$result = curl_exec($ch);
if (curl_error($ch) || empty($result)){
	echo "<!--\n";
	echo "Error fetching $url: " . curl_error($ch); 
	echo "-->\n";
	exit;
}

eval('$parsedResult=' . $result . ';');


header('Cache-Control: max-age=60');
//********* Format as rss
header('Content-Type: text/xml');
echo '<?xml version="1.0"?>' . "\n";
?>
<rss version="2.0">
   <channel>
      <title>RSS format of Wikia Solr search results</title>
      <description>Feed from <?php echo htmlspecialchars($url)?></description>
      <link><?php echo htmlspecialchars($url)?></link>
      <pubDate><?php echo date(RSS_DATE_FORMAT)?></pubDate>
      <generator>http://<?php $_SERVER['HTTP_HOST'] . '/' . basename(__FILE__) ?></generator>
  <?php foreach ($parsedResult['response']['docs'] as $r) {?>
      <item>
         <title><?php echo htmlspecialchars(str_replace('_', ' ', $r['title']))?></title>
         <link><?php echo htmlspecialchars($r['url'])?></link>
         <description><?php echo htmlspecialchars($r['html'])?></description>
         <pubDate><?php echo date(RSS_DATE_FORMAT, strtotime($r['created']))?></pubDate>
	 <guid isPermaLink="true"><?php echo htmlspecialchars($r['url'])?></guid>
      </item>
  <?php } // foreach ?>
  </channel>
</rss>
<!-- Served by <?php echo $hostname ?> -->
