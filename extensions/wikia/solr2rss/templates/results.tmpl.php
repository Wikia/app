<?php echo "<?xml version=\"1.0\"?>\n"; ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
 <channel>
  <title>RSS format of Wikia Solr search results</title>
  <description>Feed from: <?php echo htmlspecialchars($url); ?></description>
  <link><?php echo htmlspecialchars($url); ?></link>
  <atom:link href="<?php echo htmlspecialchars($url); ?>" rel="self" type="application/rss+xml" />
  <pubDate><?php echo date($dateFormat); ?></pubDate>
  <generator><?php echo htmlspecialchars($url); ?></generator>
  <?php foreach ($docs as $doc): ?>
   <item>
    <title><?php echo htmlspecialchars($doc->title); ?></title>
    <link><?php echo htmlspecialchars($doc->url); ?></link>
    <description><?php echo htmlspecialchars($doc->html); ?></description>
    <pubDate><?php echo date($dateFormat, strtotime($doc->created)); ?></pubDate>
    <guid isPermaLink="true"><?php echo htmlspecialchars($doc->url); ?></guid>
   </item>
  <?php endforeach; ?>
 </channel>
</rss>
