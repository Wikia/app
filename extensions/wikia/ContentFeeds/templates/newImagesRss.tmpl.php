<?php echo "<?xml version=\"1.0\"?>\n"; ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
 <channel>
  <title><?php echo wfMsg( 'contentfeeds-newimages-rss-title' ); ?></title>
  <description><?php echo wfMsg( 'contentfeeds-newimages-rss-desc', array( htmlspecialchars($url) ) ); ?></description>
  <link><?php echo htmlspecialchars($url); ?></link>
  <atom:link href="<?php echo htmlspecialchars($url); ?>" rel="self" type="application/rss+xml" />
  <pubDate><?php echo date($dateFormat); ?></pubDate>
  <generator><?php echo htmlspecialchars($url); ?></generator>
  <?php foreach ($images as $image): ?>
   <item>
    <title><?php echo htmlspecialchars($image->img_name); ?></title>
    <link><?php echo $image->img_file_url; ?></link>
    <description><?php echo htmlspecialchars($image->img_description); ?></description>
    <pubDate><?php echo date($dateFormat, strtotime($image->img_timestamp)); ?></pubDate>
    <guid isPermaLink="true"><?php echo $image->img_file_url; ?></guid>
   </item>
  <?php endforeach; ?>
 </channel>
</rss>
