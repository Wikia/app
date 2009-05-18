					
					function toggleCheck(thisBox){
						for(x=1;x<=(__choices_count__);x++){
							$G('quizgame-isright-'+x).checked = false;
						}
						thisBox.checked = true;
					}
					
					function uploadError(message){
						$G('ajax-messages').innerHTML = message;
						$G('quizgame-picture').innerHTML = '';
						
						$G('imageUpload-frame').src = 'index.php?title=Special:QuestionGameUpload&wpThumbWidth=80&wpCategory=Quizgames&wpOverwriteFile=true&wpDestFile=' + $G('quizGamePicture').value;
						YAHOO.widget.Effects.Show('quizgame-upload');
					}
					
					function completeImageUpload(){
						YAHOO.widget.Effects.Hide('quizgame-upload');
						$G('quizgame-picture').innerHTML = '<img src="http://images.wikia.com/common/wikiany/images/ajax-loader-white.gif?1"\>';
					}
					
					function uploadComplete(imgSrc, imgName, imgDesc){
						$G('quizgame-picture').innerHTML = imgSrc;
						
						//$G('quizgame-picture').down().src = $G('quizgame-picture').down().src + '?' + Math.floor( Math.random()*100 );
						$G('quizgame-picture').firstChild.src = $G('quizgame-picture').firstChild.src + '?' + Math.floor( Math.random()*100 );
						
						document.quizGameEditForm.quizGamePicture.value = imgName;
						
						$G('imageUpload-frame').src = 'index.php?title=Special:QuestionGameUpload&wpThumbWidth=80&wpCategory=Quizgames&wpOverwriteFile=true&wpDestFile=' + imgName;
						
						$G('quizgame-editpicture-link').innerHTML = '<a href=\"javascript:showUpload()\">Edit Picture</a>';
						YAHOO.widget.Effects.Show('quizgame-editpicture-link');
					}
					
					function showUpload(){
						YAHOO.widget.Effects.Hide('quizgame-editpicture-link');
						YAHOO.widget.Effects.Show('quizgame-upload');	
					}
					
