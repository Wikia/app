/* JavaScript */

$j( document ).ready( function() {

	var currentViewID = 'fundraiserstats-view-box-0';
	function replaceView( newLayerID ) {
		var currentLayer = document.getElementById( currentViewID );
		var newLayer = document.getElementById( newLayerID );
		currentLayer.style.display = 'none';
		newLayer.style.display = 'block';
		currentViewID = newLayerID;
	}

	var currentChartID = 'fundraiserstats-chart-totals';
	function replaceChart( newLayerID ) {
		var currentLayer = document.getElementById( currentChartID );
		var currentTab = document.getElementById( currentChartID + '-tab' );
		var newLayer = document.getElementById( newLayerID );
		var newTab = document.getElementById( newLayerID + '-tab' );
		currentLayer.style.display = 'none';
		currentTab.setAttribute( 'class', 'fundraiserstats-chart-tab-normal' );
		newLayer.style.display = 'block';
		newTab.setAttribute( 'class', 'fundraiserstats-chart-tab-current' );
		currentChartID = newLayerID;
	}

	$j( '.fundraiserstats-bar' ).hover( function() {
		replaceView( $j(this).attr( 'rel' ) )
	} );
	$j( '.fundraiserstats-chart-tab' ).click( function() {
		replaceChart( $j(this).attr( 'rel' ) )
	} );
	$j( '.fundraiserstats-current' ).each( function() {
		replaceView( $j(this).attr( 'rel' ) )
	} );
	// When someone clicks on a year, hide or show that year in the charts
	$j( '#configholder .yeartoggle' ).click( function() {
		var checked = $j(this).is( ':checked' );
		$j( '.fundraiserstats-' + $j(this).attr( 'id' ) ).each( function() {
			if ( checked ) {
				$j(this).css( 'display', 'block' );
			} else {
				$j(this).css( 'display', 'none' );
			}
		} );
	} );
	// When someone clicks on Customize, display pop-up menu and change arrow icon.
	$j( '#configtoggle' ).click( function() {
		$j( '#configholder' ).toggle();
		if ($j( '#configtoggle a' ).css( 'background-position' ) == '0px -18px') {
			$j( '#configtoggle a' ).css( 'background-position', '0px -3px' );
		} else {
			$j( '#configtoggle a' ).css( 'background-position','0px -18px' );
		}
	} );

} );
