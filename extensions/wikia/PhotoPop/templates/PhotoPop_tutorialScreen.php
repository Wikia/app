<?php

	// The tutorial screen is just a special rendering of the playGame controller.  This makes it so that we
	// won't have to update the tutorial screen every time something changes in the game screen, in addition
	// it will make sure the board scales nicely to fit the screen (as opposed to a static image).
	
	// The main differences in the two renderings is that we just don't include Javascript in tutorial mode (so that only
	// the Home button from the normal game works) and we show an extra div with the tutorial text on it.

	$app = F::app();
	$response = $app->sendRequest( 'PhotoPop', 'playGame' );
	$response->setVal('isTutorial', true);
	$response->setVal('width', $boardWidth);
	$response->setVal('height', $boardHeight);
	print $response->render();
