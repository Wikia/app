					
					function toggleCheck(thisBox){
						for(x=1;x<=(__choices_count__);x++){
							$('quizgame-isright-'+x).checked = false;
						}
						thisBox.checked = true;
					}
					
					function uploadError(message){
						$('ajax-messages').innerHTML = message;
						$('quizgame-picture').innerHTML = '';
						
						$('imageUpload-frame').src = 'index.php?title=Special:QuestionGameUpload&wpThumbWidth=80&wpCategory=Quizgames&wpOverwriteFile=true&wpDestFile=' + $('quizGamePicture').value;
						YAHOO.widget.Effects.Show('quizgame-upload');
					}
					
					function completeImageUpload(){
						YAHOO.widget.Effects.Hide('quizgame-upload');
						$('quizgame-picture').innerHTML = '<img src="http://images.wikia.com/common/wikiany/images/ajax-loader-white.gif?1"\>';
					}
					
					function uploadComplete(imgSrc, imgName, imgDesc){
						$('quizgame-picture').innerHTML = imgSrc;
						
						//$('quizgame-picture').down().src = $('quizgame-picture').down().src + '?' + Math.floor( Math.random()*100 );
						$('quizgame-picture').firstChild.src = $('quizgame-picture').firstChild.src + '?' + Math.floor( Math.random()*100 );
						
						document.quizGameEditForm.quizGamePicture.value = imgName;
						
						$('imageUpload-frame').src = 'index.php?title=Special:QuestionGameUpload&wpThumbWidth=80&wpCategory=Quizgames&wpOverwriteFile=true&wpDestFile=' + imgName;
						
						$('quizgame-editpicture-link').innerHTML = '<a href=\"javascript:showUpload()\">Edit Picture</a>';
						YAHOO.widget.Effects.Show('quizgame-editpicture-link');
					}
					
					function showUpload(){
						YAHOO.widget.Effects.Hide('quizgame-editpicture-link');
						YAHOO.widget.Effects.Show('quizgame-upload');	
					}
					
