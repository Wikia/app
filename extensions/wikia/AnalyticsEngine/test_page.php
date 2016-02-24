<html>
<head>
<script>
var wgIsMainpage=true;
</script>
<?php
$wgDBname = "muppet";
$wgCityId = "831";
ini_set('display_errors', true);
require_once 'AnalyticsEngine.php';
echo AnalyticsEngine::track('QuantServe', AnalyticsEngine::EVENT_PAGEVIEW);
?>
</head>
<body>
Hi
</body>
</html>
