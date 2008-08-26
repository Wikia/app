
				/* Unflags an image */
				function unflag(id){
					YAHOO.widget.Effects.Fade('' + id + ''); 
					var sUrl = "index.php?title=Special:PictureGameHome&picGameAction=adminPanelUnflag&chain=" + __admin_panel_now__ + "&key=" + __admin_panel_key__ + "&id=" + id + "";	
					var callback =
					{
					  success: function(t) {
						  alert(t.responseText);
					  },
					  failure: function(t) {
						  alert('Error was: ' + t.responseText);
					  }
					}
					var transaction = YAHOO.util.Connect.asyncRequest('GET', sUrl, callback, null);


				}

				/* Deletes the image:
					img1 and img2 are the MediaWiki names */
				function deleteimg(id, img1, img2){
					YAHOO.widget.Effects.Fade('' + id + '');

					var sUrl = "index.php?title=Special:PictureGameHome&picGameAction=adminPanelDelete&chain=" + __admin_panel_now__ + "&key=" + __admin_panel_key__ + "&id=" + id + "&img1=" + img1 + "&img2=" + img2;
					var callback =
					{
					  success: function(t) {
						  alert(t.responseText);
					  },
					  failure: function(t) {
						  alert('Error was: ' + t.responseText);
					  }
					}
					var transaction = YAHOO.util.Connect.asyncRequest('GET', sUrl, callback, null);

				}

				/* Unprotects an image */
				function unprotect(id){
					YAHOO.widget.Effects.Fade('' + id + '');

					var sUrl = "index.php?title=Special:PictureGameHome&picGameAction=unprotectImages&chain=" +  __admin_panel_now__ + "&key=" +  __admin_panel_key__ + "&id=" + id + "";
					var callback =
					{
					  success: function(t) {
						  alert(t.responseText);
					  },
					  failure: function(t) {
						  alert('Error was: ' + t.responseText);
					  }
					}
					var transaction = YAHOO.util.Connect.asyncRequest('GET', sUrl, callback, null);
					
				}

