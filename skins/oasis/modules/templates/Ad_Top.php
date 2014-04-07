<div class="WikiaTopAds" id="WikiaTopAds">
<div class="WikiaTopAdsInner">

<?php

echo $app->renderView('Ad', 'Index', ['slotName' => $leaderboardName, 'pageTypes' => ['homepage_logged', 'corporate', 'all_ads']]);
echo $app->renderView('Ad', 'Index', ['slotName' => 'TOP_BUTTON_WIDE']);

?>

</div>

<?= $app->renderView('Ad', 'Index', ['slotName' => 'INVISIBLE_SKIN', 'pageTypes' => ['homepage_logged', 'all_ads']]); ?>

</div>
