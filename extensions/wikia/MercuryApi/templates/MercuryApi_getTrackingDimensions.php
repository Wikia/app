window.trackingDimensions = [];
<?php
foreach( $dimensions as $key => $value ) {
	echo "window.trackingDimensions[$key] = '$value';\n";
}
