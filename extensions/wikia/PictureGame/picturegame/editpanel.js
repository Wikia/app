
			var currImg = 0;

			/* Shows the upload frame*/
			function loadUploadFrame(filename, img){

				currImg = img;

				if(img == 1) {
					$("edit-image-text").innerHTML = "<h2> " + __picturegame_editgameediting__ + " Image 1 </h2>";
				}
				else {
					$("edit-image-text").innerHTML = "<h2> " + __picturegame_editgameediting__ + " Image 2 </h2>";
				}

				$("upload-frame").src = __request_url__ + "&picGameAction=uploadForm&wpOverwriteFile=true&wpDestFile=" + filename;
				$El("edit-image-frame").show();
			}

			function uploadError(message){
				$El("loadingImg").hide();
				alert(message);
				$El("edit-image-frame").show();
				$("upload-frame").src = $("upload-frame").src;
			}

			/* Called when the upload starts */
			function completeImageUpload(){
				$El("edit-image-frame").hide();
				$El("loadingImg").show();
			}

			/* Called when the upload is complete
				imgSrc will be HTML for the image thumbnail
				imgName is the MediaWiki image name
				imgDesc is the MediaWiki image descriptions
			*/
			function uploadComplete(imgSrc, imgName, imgDesc){
				$El("loadingImg").hide();

				if(currImg == 1)
					$("image-one-tag").innerHTML = imgSrc;
				else
					$("image-two-tag").innerHTML = imgSrc;
			}

