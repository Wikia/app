$j(document).ready( function() {
    // Set defaults if included as a gadget, otherwise they should
    // be defined by the extension.
    if ( typeof wgJSBreadCrumbsMaxCrumbs == "undefined" ) {
        wgJSBreadCrumbsMaxCrumbs = 5;
    }
    if ( typeof wgJSBreadCrumbsSeparator == "undefined" ) {
        wgJSBreadCrumbsSeparator = "»";
    }
    if ( typeof wgJSBreadCrumbsCookiePath == "undefined" ) {
        wgJSBreadCrumbsCookiePath = "/";
    }
    if ( typeof wgJSBreadCrumbsLeadingDescription == "undefined" ) {
        wgJSBreadCrumbsLeadingDescription = "Navigation trail";
    }
    if ( typeof wgJSBreadCrumbsShowSiteName == "undefined" ) {
    	wgJSBreadCrumbsShowSiteName = false;
    }

    if ( wgCanonicalSpecialPageName == "Userlogout" ) {
    	$j.cookie( 'mwext-bc-title', '', { path: wgJSBreadCrumbsCookiePath } );
    	$j.cookie( 'mwext-bc-url', '', { path: wgJSBreadCrumbsCookiePath } );
    	$j.cookie( 'mwext-bc-site', '', { path: wgJSBreadCrumbsCookiePath } );
    }
    // Get the breadcrumbs from the cookies
    var titleState = ( $j.cookie( 'mwext-bc-title' ) || "" ).split( '|' );
    var urlState = ( $j.cookie( 'mwext-bc-url' ) || "" ).split( '|' );
    var siteState = ( $j.cookie( 'mwext-bc-site' ) || "" ).split( '|' );

    // Strip the first title/url if it is empty
    if ( titleState[0].length == 0 ) {
        titleState.splice( 0, 1 );
        urlState.splice( 0, 1 );
        siteState.splice( 0, 1 );
    }

    // Get the full title
    var title = wgTitle;
    if ( wgNamespaceNumber != 0 ) {
        title = wgFormattedNamespaces[wgNamespaceNumber] + ":" + wgTitle;
    }

    // Remove duplicates
    var matchTitleIndex = $j.inArray( title, titleState );
    var matchUrlIndex = $j.inArray( location.pathname + location.search, urlState );
    if ( matchTitleIndex != -1 && ( matchUrlIndex == matchTitleIndex ) ) {
        titleState.splice( matchTitleIndex, 1 );
        urlState.splice( matchTitleIndex, 1 );
        siteState.splice( matchTitleIndex, 1 );
    }
 
    // Add the current page
    titleState.push( title );
    urlState.push( location.pathname + location.search );
    siteState.push( wgSiteName );

    // Ensure we only display the maximum breadcrumbs set 
    if ( titleState.length > wgJSBreadCrumbsMaxCrumbs ) {
        titleState = titleState.slice( titleState.length - wgJSBreadCrumbsMaxCrumbs );
        urlState = urlState.slice( urlState.length - wgJSBreadCrumbsMaxCrumbs );
        siteState = siteState.slice( siteState.length - wgJSBreadCrumbsMaxCrumbs );
    }

    // Insert the span we are going to populate 
    $j( "#top" ).before( '<span id="mwext-bc" class="noprint plainlinks breadcrumbs"></span>' );

    var mwextbc = $j( "#mwext-bc" );

    // Add the bread crumb description 
    mwextbc.append( wgJSBreadCrumbsLeadingDescription + ': ' );

    // Add the bread crumbs
    for ( var i = 0; i < titleState.length; i++ ) {
        if ( wgJSBreadCrumbsShowSiteName == true ) {
            urltoappend = '<a href="' + urlState[i] + '">' + '(' + siteState[i] + ') ' + titleState[i] + '</a> ';
        } else {
            urltoappend = '<a href="' + urlState[i] + '">' + titleState[i] + '</a> ';
        }
        // Only add the separator if this isn't the last title
        if ( i < titleState.length - 1 ) {
		    urltoappend = urltoappend + wgJSBreadCrumbsSeparator + ' ';
        }
        mwextbc.append( urltoappend );
    }

    // Save the bread crumb states to the cookies
    $j.cookie( 'mwext-bc-title', titleState.join( '|' ), { path: wgJSBreadCrumbsCookiePath } );
    $j.cookie( 'mwext-bc-url', urlState.join( '|' ), { path: wgJSBreadCrumbsCookiePath } );
    $j.cookie( 'mwext-bc-site', siteState.join( '|' ), { path: wgJSBreadCrumbsCookiePath } );
});