<!-- Served by <?php echo trim(`hostname`) ?> -->
<?php
require_once dirname(__FILE__) . "/../AnalyticsEngine/AnalyticsEngine.php";
echo AnalyticsEngine::track('GA_Urchin', AnalyticsEngine::EVENT_PAGEVIEW);
?>
</body>
</html>
