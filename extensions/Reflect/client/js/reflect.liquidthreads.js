/* Copyright (c) 2010 Travis Kriplean (http://www.cs.washington.edu/homes/travis/)
 * Licensed under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * 
 * Overrides default Reflect options & classes to support MediaWiki/LiquidThreads.  
 * 
 */


if ( typeof liquidThreads != 'undefined' ) {
	Reflect.config.study = wgReflectStudyEnabled;
	
	/* see documentation about components in Reflect.js */
	$j.extend( Reflect.config.contract, {
			components : [ {
				comment_identifier : '.lqt-post-wrapper',
				comment_offset : 8,
				comment_text : '.lqt_post',
				get_commenter_name : function ( comment_id ) {
					var sel = '#comment-' + comment_id 
							+ ' .lqt-thread-user-signature:first a';
					return $j( sel )
							.text();
				}
			} ]
		} );
	
	/* see documentation about Contract in Reflect.js */		
	Reflect.Contract = Reflect.Contract.extend( {
		init : function ( config ) {
			this._super( config );
			this.components = config.components;
			this.domain = config.domain;
		},
		user_name_selector : function () {
			if ( $j( '#pt-userpage a' ).length > 0 ) {
				return '#pt-userpage a';
			} else {
				return '#pt-anonuserpage a';
			}
		},
		modifier : function () {
			$j( '.lqt-post-wrapper' ).each( function () {
				$j( this ).attr( 'id', 'comment-' 
						+ $j( this ).parent()
							.attr( 'id' ).substring( 14 ) );
			} );
		},
		get_comment_thread : function () {
			return $j( '#bodyContent' );
		}
	} );

	$j.extend( Reflect.config.api, {
		domain : 'liquidthreads',
		server_loc : wgScriptPath + '/api.php',
		media_dir : wgScriptPath + '/extensions/Reflect/client/media/'
	} );

	/* Interfaces directly with Mediawiki server API. 
	 * 
	 * All gets/posts request a token from the server before
	 * making the request in order to protect against CSRF attacks. 
	 * */
	Reflect.api.DataInterface = Reflect.api.DataInterface.extend( {

		get_templates : function ( callback ) {
			$j.get( wgScriptPath 
					+ '/extensions/Reflect/client/templates/templates.html', 
					callback );
		},
		get_current_user : function () {
			return wgUser;
		},
		is_admin : function () {
			return wgIsAdmin;
		},
		post_bullet : function ( params ) {
			var me = this;
			liquidThreads.getToken( function ( token ) {
				params.params.action = 'reflectaction';
				params.params.format = 'json';
				params.params.reflectaction = 'post_bullet';
				params.params.token = token;

				$j.ajax( {
					url : me.server_loc,
					type : 'POST',
					data : params.params,
					error : function ( data ) {
						if ( typeof data == "string" ) {
							data = JSON.parse( data );
						}
						params.error( data['reflectaction'] );
					},
					success : function ( data ) {
						if ( typeof data == "string" ) {
							data = JSON.parse( data );
						}
						params.success( data['reflectaction'] );
					}
				} );
			} );
		},
		post_response : function ( params ) {
			var me = this;
			liquidThreads.getToken( function ( token ) {
				params.params.action = 'reflectaction';
				params.params.format = 'json';
				params.params.reflectaction = 'post_response';
				params.params.token = token;

				$j.ajax( {
					url : me.server_loc,
					type : 'POST',
					data : params.params,
					error : function ( data ) {
						if ( typeof data == "string" ) {
							data = JSON.parse( data );
						}
						params.error( data['reflectaction'] );
					},
					success : function ( data ) {
						if ( typeof data == "string" ) {
							data = JSON.parse( data );
						}
						params.success( data['reflectaction'] );
					}
				} );
			} );
		},

		get_data : function ( params, callback ) {
			var me = this;
			liquidThreads.getToken( function ( token ) {
				params.action = 'reflectaction';
				params.format = 'json';
				params.reflectaction = 'get_data';
				params.token = token;

				$j.getJSON( me.server_loc, params, function ( data ) {
					if ( data ) {
						callback( data['reflectaction'] );
					} else {
						callback( data );
					}
				} );
			} );
		},

		/***************************************************************
		 * Research study API 
		 * 
		 * These really should go in a separate file
		 * like reflect.study.liquidthreads.js. Maybe reflect.study.js?
		 */
		post_survey_bullets : function ( params ) {
			var me = this;
			liquidThreads.getToken( function ( token ) {
				params.params.action = 'reflectstudyaction';
				params.params.format = 'json';
				params.params.reflectstudyaction = 'post_survey_bullets';
				params.params.token = token;

				$j.ajax( {
					url : me.server_loc,
					type : 'POST',
					data : params.params,
					error : function ( data ) {
						if ( typeof data == "string" ) {
							data = JSON.parse( data );
						}
						params.error( data['reflectstudyaction'] );
					},
					success : function ( data ) {
						if ( typeof data == "string" ) {
							data = JSON.parse( data );
						}
						params.success( data['reflectstudyaction'] );
					}
				} );
			} );

		},
		get_survey_bullets : function ( params, callback ) {
			var me = this;
			liquidThreads.getToken( function ( token ) {
				params.action = 'reflectstudyaction';
				params.format = 'json';
				params.reflectstudyaction = 'get_survey_responses';
				params.token = token;
				$j.getJSON( me.server_loc, params, function ( data ) {
					if ( data ) {
						callback( data['reflectstudyaction'] );
					} else {
						callback( data );
					}
				} );

			}

			);
		}

	} );
}