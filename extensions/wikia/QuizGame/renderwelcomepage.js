
	function uploadError(message){
		$('imageUpload-frame').src = 'index.php?title=Special:QuestionGameUpload&wpThumbWidth=75&wpCategory=Quizgames';
		$El('quizgame-picture-upload').show();
	}
	
	function completeImageUpload(){
		$El('quizgame-picture-upload').hide();
		$('quizgame-picture-preview').innerHTML = '<img src="../../images/common/ajax-loader-white.gif" \>';
	}
	
	function uploadComplete(imgSrc, imgName, imgDesc){
		$('quizgame-picture-preview').innerHTML = imgSrc;
		document.quizGameCreate.quizGamePictureName.value = imgName;
		$('imageUpload-frame').src = 'index.php?title=Special:QuestionGameUpload&wpThumbWidth=75&wpCategory=Quizgames';
		$El('quizgame-picture-reupload').show();
	}

	function showAnswerBox(id){
		YAHOO.widget.Effects.Appear('quizgame-answer-' + id);
		//Effect.Appear('quizgame-answer-' + id);
		if(id == 2)
			$El('startButton').show();
	}
	
	function update_answer_boxes(){
		
		for(x=1;x<=(__quiz_max_answers__-1);x++){

			if($("quizgame-answer-"+x).value){
				$El("quizgame-answer-container-"+(x+1)).show()
				//Effect.Appear("quizgame-answer-container-"+(x+1), {duration:0.5, fps:32})
			}
		}
	}
	
	function toggleCheck(thisBox){
		for(x=1;x<=(__quiz_max_answers__-1);x++){
			$('quizgame-isright-'+x).checked = false;
		}
		thisBox.checked = true;
	}
	
	function startGame(){

		var errorText = '';
		
		answers=0;
		for(x=1;x<=__quiz_max_answers__;x++){
			if($("quizgame-answer-"+x).value){
				answers++;
			}
		}
		
		if(answers<2){
			errorText += __quiz_create_error_numanswers__ + "<p>";
		}
		if(!$("quizgame-question").value){
			errorText += __quiz_create_error_noquestion__ + "<p>";
		}
		
		right=0;
		for(x=1;x<=__quiz_max_answers__;x++){
			if($("quizgame-isright-"+x).checked){
				right++;
			}
		}
		
		if(right!=1){
			errorText += __quiz_create_error_numcorrect__ + "<p>";
		}
		
		if(!errorText){
			$('quizGameCreate').submit();
		}else{
			$('quiz-game-errors').innerHTML = "<h2>" + errorText + "<h2>";
		}
	}
	
	function showAttachPicture(){
		$El('quizgame-picture-preview').hide();
		$El('quizgame-picture-reupload').hide();
		$El('quizgame-picture-upload').show();
	}


