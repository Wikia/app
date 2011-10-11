<?php
/**
 * @author Sean Colombo
 * @date 20111011
 *
 * This file will serve as the endpoint for hitting all API Gate pages.  The .htaccess
 * file will make sure the page arrives here in the 'title' URL parameter.  So "/pages/test"
 * will hit here with title="test".
 */

print "ApiGate page dispatcher isn't written yet (we're not using it for Wikia anyway).";

$title = isset($_GET['title']) ? $_GET['title'] : "";

print "TODO: Use the ApiGate_Dispatcher to call the master template files (for the page, menus, header, footer, etc.) and then make the call out for the <strong>$title</strong> template (the page body).\n";
