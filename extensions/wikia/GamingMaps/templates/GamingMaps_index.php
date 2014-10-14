<?php if( !empty( $warning ) ) { ?>
    <h1><?=$warning?></h1>
<?php }else{ ?>
    <div id="map"  style="height: <?=$height ?>px; width: <?=$width ?>px; position: relative; " class=" leaflet-container leaflet-fade-anim"></div>
<?}?>