<html>
<head>
<script>
var wgIsMainpage=true;
</script>
<?php
$wgDBname = "muppet";
$wgCityId = "831";
ini_set('display_errors', true);
require 'AnalyticsEngine.php';
echo AnalyticsEngine::track('QuantServe', AnalyticsEngine::EVENT_PAGEVIEW);
echo AnalyticsEngine::track('GA_Urchin', AnalyticsEngine::EVENT_PAGEVIEW);
?>
</head>
<body>
Hi
</body>
<?php
echo AnalyticsEngine::track('GA_Urchin', 'dbname', array($wgDBname));
echo AnalyticsEngine::track('GA_Urchin', 'main_page');
echo AnalyticsEngine::track('GA_Urchin', 'onewiki', array($wgCityId));
?>
</html>
