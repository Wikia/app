/**
 * Copyright (c) 2005 - 2009, James Auldridge
 * All rights reserved.
 *
 * Licensed under the BSD, MIT, and GPL (your choice!) Licenses:
 *  http://code.google.com/p/cookies/wiki/License
 *
 */
var jaaulde = window.jaaulde || {};
jaaulde.utils = jaaulde.utils || {};
jaaulde.utils.cookies = ( function()
{
	var cookies = [];

	var defaultOptions = {
		hoursToLive: null,
		path: '/',
		domain:  null,
		secure: false
	};
	/**
	 * resolveOptions - receive an options object and ensure all options are present and valid, replacing with defaults where necessary
	 *
	 * @access private
	 * @static
	 * @parameter Object options - optional options to start with
	 * @return Object complete and valid options object
	 */
	var resolveOptions = function( options )
	{
		var returnValue;

		if( typeof options !== 'object' || options === null )
		{
			returnValue = defaultOptions;
		}
		else
		{
			returnValue = {
				hoursToLive: ( typeof options.hoursToLive === 'number' && options.hoursToLive !== 0 ? options.hoursToLive : defaultOptions.hoursToLive ),
				path: ( typeof options.path === 'string' && options.path !== '' ? options.path : defaultOptions.path ),
				domain: ( typeof options.domain === 'string' && options.domain !== '' ? options.domain : defaultOptions.domain ),
				secure: ( typeof options.secure === 'boolean' && options.secure ? options.secure : defaultOptions.secure )
			};
		}

		return returnValue;
	};
	/**
	 * expiresGMTString - add given number of hours to current date/time and convert to GMT string
	 *
	 * @access private
	 * @static
	 * @parameter Integer hoursToLive - number of hours for which cookie should be valid
	 * @return String - GMT time representing current date/time plus number of hours given
	 */
	var expiresGMTString = function( hoursToLive )
	{
		var dateObject = new Date();
		dateObject.setTime( dateObject.getTime() + ( hoursToLive * 60 * 60 * 1000 ) );

		return dateObject.toGMTString();
	};
	/**
	 * assembleOptionsString - analyze options and assemble appropriate string for setting a cookie with those options
	 *
	 * @access private
	 * @static
	 * @parameter Object options - optional options to start with
	 * @return String - complete and valid cookie setting options
	 */
	var assembleOptionsString = function( options )
	{
		options = resolveOptions( options );

		return (
			( typeof options.hoursToLive === 'number' ? '; expires=' + expiresGMTString( options.hoursToLive ) : '' ) +
			'; path=' + options.path +
			( typeof options.domain === 'string' ? '; domain=' + options.domain : '' ) +
			( options.secure === true ? '; secure' : '' )
		);
	};
	/**
	 * splitCookies - retrieve document.cookie string and break it into a hash
	 *
	 * @access private
	 * @static
	 * @return Object - hash of cookies from document.cookie
	 */
	var splitCookies = function()
	{
		cookies = {};
		var pair, name, value, separated = document.cookie.split( ';' );
		for( var i = 0; i < separated.length; i = i + 1 )
		{
			pair = separated[i].split( '=' );
			name = pair[0].replace( /^\s*/, '' ).replace( /\s*$/, '' );
			value = decodeURIComponent( pair[1] );
			cookies[name] = value;
		}
		return cookies;
	};

	var constructor = function(){};
	
	/**
	 * get - get one, several, or all cookies
	 *
	 * @access public
	 * @paramater Mixed cookieName - String:name of single cookie; Array:list of multiple cookie names; Void (no param):if you want all cookies
	 * @return Mixed - String:if single cookie requested and found; Null:if single cookie requested and not found; Object:hash of multiple or all cookies
	 */
	constructor.prototype.get = function( cookieName )
	{
		var returnValue;
		
		splitCookies();

		if( typeof cookieName === 'string' )
		{
			returnValue = ( typeof cookies[cookieName] !== 'undefined' ) ? cookies[cookieName] : null;
		}
		else if( typeof cookieName === 'object' && cookieName !== null )
		{
			returnValue = {};
			for( var item in cookieName )
			{
				if( typeof cookies[cookieName[item]] !== 'undefined' )
				{
					returnValue[cookieName[item]] = cookies[cookieName[item]];
				}
				else
				{
					returnValue[cookieName[item]] = null;
				}
			}
		}
		else
		{
			returnValue = cookies;
		}

		return returnValue;
	};
	/**
	 * filter - get array of cookies whose names match the provided RegExp
	 *
	 * @access public
	 * @paramater Object RegExp - The regular expression to match against cookie names
	 * @return Mixed - Object:hash of cookies whose names match the RegExp
	 */
	constructor.prototype.filter = function( cookieNameRegExp )
	{
		var returnValue = {};

		splitCookies();

		if( typeof cookieNameRegExp === 'string' )
		{
			cookieNameRegExp = new RegExp( cookieNameRegExp );
		}

		for( var cookieName in cookies )
		{
			if( cookieName.match( cookieNameRegExp ) )
			{
				returnValue[cookieName] = cookies[cookieName];
			}
		}

		return returnValue;
	};
	/**
	 * set - set or delete a cookie with desired options
	 *
	 * @access public
	 * @paramater String cookieName - name of cookie to set
	 * @paramater Mixed value - Null:if deleting, String:value to assign cookie if setting
	 * @paramater Object options - optional list of cookie options to specify (hoursToLive, path, domain, secure)
	 * @return void
	 */
	constructor.prototype.set = function( cookieName, value, options )
	{
		if( typeof value === 'undefined' || value === null )
		{
			if( typeof options !== 'object' || options === null )
			{
				options = {};
			}
			value = '';
			options.hoursToLive = -8760;
		}
		
		var optionsString = assembleOptionsString( options );

		document.cookie = cookieName + '=' + encodeURIComponent( value ) + optionsString;
	};
	/**
	 * del - delete a cookie (domain and path options must match those with which the cookie was set; this is really an alias for set() with parameters simplified for this use)
	 *
	 * @access public
	 * @paramater MIxed cookieName - String name of cookie to delete, or Bool true to delete all
	 * @paramater Object options - optional list of cookie options to specify ( path, domain )
	 * @return void
	 */
	constructor.prototype.del = function( cookieName, options )
	{
		var allCookies = {};

		if( typeof options !== 'object' || options === null )
		{
			options = {};
		}

		if( typeof cookieName === 'boolean' && cookieName === true )
		{
			allCookies = this.get();
		}
		else if( typeof cookieName === 'string' )
		{
			allCookies[cookieName] = true;
		}

		for( var name in allCookies )
		{
			if( typeof name === 'string' && name !== '' )
			{
				this.set( name, null, options );
			}
		}
	};
	/**
	 * test - test whether the browser is accepting cookies
	 *
	 * @access public
	 * @return Boolean
	 */
	constructor.prototype.test = function()
	{
		var returnValue = false, testName = 'cT', testValue = 'data';

		this.set( testName, testValue );

		if( this.get( testName ) === testValue )
		{
			this.del( testName );
			returnValue = true;
		}

		return returnValue;
	};
	/**
	 * setOptions - set default options for calls to cookie methods
	 *
	 * @access public
	 * @param Object options - list of cookie options to specify (hoursToLive, path, domain, secure)
	 * @return void
	 */
	constructor.prototype.setOptions = function( options )
	{
		if( typeof options !== 'object' )
		{
			options = null;
		}

		defaultOptions = resolveOptions( options );
	};

	return new constructor();
} )();

( function()
{
	if( window.jQuery )
	{
		( function( $ )
		{
			$.cookies = jaaulde.utils.cookies;

			var extensions = {
				/**
				 * $( 'selector' ).cookify - set the value of an input field or the innerHTML of an element to a cookie by the name or id of the field or element
				 *                           (radio and checkbox not yet supported)
				 *                           (field or element MUST have name or id attribute)
				 *
				 * @access public
				 * @param Object options - list of cookie options to specify
				 * @return Object jQuery
				 */
				cookify: function( options )
				{
					return this.each( function()
					{
						var i, resolvedName = false, resolvedValue = false, name = '', value = '', nameAttrs = ['name', 'id'], nodeName, inputType;

						for( i in nameAttrs )
						{
							if( ! isNaN( i ) )
							{
								name = $( this ).attr( nameAttrs[ i ] );
								if( typeof name === 'string' && name !== '' )
								{
									resolvedName = true;
									break;
								}
							}
						}

						if( resolvedName )
						{
							nodeName = this.nodeName.toLowerCase();
							if( nodeName !== 'input' && nodeName !== 'textarea' && nodeName !== 'select' && nodeName !== 'img' )
							{
								value = $( this ).html();
								resolvedValue = true;
							}
							else
							{
								inputType = $( this ).attr( 'type' );
								if( typeof inputType === 'string' && inputType !== '' )
								{
									inputType = inputType.toLowerCase();
								}
								if( inputType !== 'radio' && inputType !== 'checkbox' )
								{
									value = $( this ).val();
									resolvedValue = true;
								}
							}
							
							if( resolvedValue )
							{
								if( typeof value !== 'string' || value === '' )
								{
									value = null;
								}
								$.cookies.set( name, value, options );
							}
						}
					} );
				},
				/**
				 * $( 'selector' ).cookieFill - set the value of an input field or the innerHTML of an element from a cookie by the name or id of the field or element
				 *
				 * @access public
				 * @return Object jQuery
				 */
				cookieFill: function()
				{
					return this.each( function()
					{
						var i, resolvedName = false, name = '', value, nameAttrs = ['name', 'id'], iteration = 0, nodeName;

						for( i in nameAttrs )
						{
							if( ! isNaN( i ) )
							{
								name = $( this ).attr( nameAttrs[ i ] );
								if( typeof name === 'string' && name !== '' )
								{
									resolvedName = true;
									break;
								}
							}
						}

						if( resolvedName )
						{
							value = $.cookies.get( name );
							if( value !== null )
							{
								nodeName = this.nodeName.toLowerCase();
								if( nodeName === 'input' || nodeName === 'textarea' || nodeName === 'select' )
								{
								    $( this ).val( value );
								}
								else
								{
									$( this ).html( value );
								}
							}
						}

						iteration = 0;
					} );
				},
				/**
				 * $( 'selector' ).cookieBind - call cookie fill on matching elements, and bind their change events to cookify()
				 *
				 * @access public
				 * @param Object options - list of cookie options to specify
				 * @return Object jQuery
				 */
				cookieBind: function( options )
				{
					return this.each( function()
					{
						$( this ).cookieFill().change( function()
						{
							$( this ).cookify( options );
						} );
					} );
				}
			};

			$.each( extensions, function( i )
			{
				$.fn[i] = this;
			} );

		} )( window.jQuery );
	}
} )();