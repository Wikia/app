
if (typeof FoggyFoto === 'undefined') {
	FoggyFoto = {};
}

if (typeof FoggyFoto.FlipBoard === 'undefined') {
	/**
	 * FlipBoard is a class which is used in FoggyFoto to hold a "front" image and a "back" (obscured) image
	 * which is conceptually broken up into a number of tiles.  Each tile can individually be transitioned/revealed
	 * to show the back-image.
	 *
	 * NOTE ON IMAGE-SCALING: The algorithm for image-scaling is to scale the image up or down maintaining the aspect
	 * ratio (ie: no distortion) until it is as close as possible to a fit, then centering along the other dimension
	 * which will result in some cropping.  More specifically:
	 * - If the image aspect ratio is greater than the screen aspect ratio, scale the height of the image to fit,
	 *   then center the image vertically (crops off the top/bottom as needed).
	 * - If the image aspect ratio is less than or equal to the screen aspect ratio, scale the width of the image to
	 *   fit, then center the image horizontally (cropping some off both sides as needed).
	 *
	 * TODO: Create a function to allow debugging to be enabled/disabled across the whole class.
	 */
	FoggyFoto.FlipBoard = function(){
		var self = this;
		
		this.canvas = null;
		this.context = null;

		// URLs of the images
		this.frontImageSrc = 'http://images4.wikia.nocookie.net/__cb20110304030006/lyricwiki/images/b/b7/Deadmau5_-_It_Sounds_Like.jpg'; // this shows up immediately
		this.backImageSrc = "http://images1.wikia.nocookie.net/__cb20110606201926/lyricwiki/images/3/39/Deadmau5_-_Project_56.jpg"; // this is the one that's obscured

		this.width = 480;
		this.height = 320;

		// Dimensions for the number of tiles
		this.numRows = 4;
		this.numCols = 6;

		// Dimensions (in pixels) of the tiles.
		// NOTE: Calculated based on numRows and numCols in init().
		this._tileWidth = 0;
		this._tileHeight = 0;

		this.isBackShowing = [[]]; // matrix of binary values for whether the back tile is showing at a given coordinate

		/**
		 * After setting the dimensions of the flip board, this should be called once to set up the isBackShowing matrix
		 * to the right size.
		 *
		 * Also, calculates the _tileWidth and _tileHeight values.
		 */
		this.init = function(){
			self.canvas = document.getElementById("foggyCanvas");
			if( self.canvas.getContext )
			{
				self.context = self.canvas.getContext("2d");
			}

			// Calculate the size of the tiles in pixels.
			self._tileWidth = (self.width / self.numCols);
			self._tileHeight = (self.height / self.numRows);
		
			// Initialize the matrix of what is revealed.
			for(var row=0; row < self.numRows; row++){
				for(var col=0; col < self.numCols; col++){
					if(!self.isBackShowing[row]){
						self.isBackShowing[row] = [];
					}

					self.isBackShowing[row][col] = 0; // back is completely obscured by default
				}
			}
		};
		
		/**
		 * Toggles the display of the tile at the given row and column.
		 */
		this.flip = function(row, col){
			if(typeof self.isBackShowing[row] != "undefined"){
				if(typeof self.isBackShowing[row][col] != "undefined"){
					self.isBackShowing[row][col] = (self.isBackShowing[row][col] === 0 ? 1 : 0);
				}
			}
		};
		
		/**
		 * Assure that the tile at the given row and column is showing the back image.
		 */
		this.show = function(row, col){
			if(typeof self.isBackShowing[row] != "undefined"){
				if(typeof self.isBackShowing[row][col] != "undefined"){
					self.isBackShowing[row][col] = 1;
				}
			}
		};

		/**
		 * Assure that the tile at the given row and column is hiding the back image (ie: make the front show there).
		 */
		this.hide = function(row, col){
			if(typeof self.isBackShowing[row] != "undefined"){
				if(typeof self.isBackShowing[row][col] != "undefined"){
					self.isBackShowing[row][col] = 0;
				}
			}
		};
		
		/**
		 * Dumps a human-readable output to the console indicating which tiles are showing.
		 */
		this.logState = function(){
			for(var row=0; row < self.numRows; row++){
				var rowStr = "";
				for(var col=0; col < self.numCols; col++){
					rowStr += "" + self.isBackShowing[row][col] + " ";
				}
				console.log(rowStr + "\n");
			}
		};

		/**
		 * Draws the images to the board, taking into account which tiles are revelaed
		 * according to isBackShowing.
		 */
		this.drawBoard = function(){
			// Display the unaltered image first.
			var frontImage = new Image();
			frontImage.src = self.frontImageSrc;
			frontImage.onload = function(){
				// Draw the front image at the top-left of the canvas... scaled & centered as needed.
//				var fsf = self._getScalingFactor(frontImage); // scaling factor for the front image (Front Scaling Factor == fsf)
//				var frontOffsetX = ( Math.abs((frontImage.width * fsf) - self.canvas.width) / 2 );
//				var frontOffsetY = ( Math.abs((frontImage.height * fsf) - self.canvas.height) / 2 );
//				self._drawImage(frontImage, frontOffsetX, frontOffsetY, (frontImage.width * fsf), (frontImage.height * fsf), 0, 0, self.canvas.width, self.canvas.height);
				self._drawImageAutoScaled(frontImage, 0, 0, self.canvas.width, self.canvas.height, 0, 0, self.canvas.width, self.canvas.height);

				// Once the front image is loaded, load the back image and display it only in spots that are flipped.
				var backImage = new Image();
				backImage.src = self.backImageSrc;
				backImage.onload = function(){
					for(var row=0; row < self.numRows; row++){
						for(var col=0; col < self.numCols; col++){
							if((self.isBackShowing[row]) && (self.isBackShowing[row][col] === 1)){
								console.log("== SHOWING TILE AT (" + row + ", " + col + ") ==");
								var sourceX = (self._tileWidth * col);
								var sourceY = (self._tileHeight * row);
								var sourceWidth = self._tileWidth;
								var sourceHeight = self._tileHeight;
								var destWidth = sourceWidth;
								var destHeight = sourceHeight;
								var destX = sourceX;
								var destY = sourceY;

								self._drawImageAutoScaled(backImage, sourceX, sourceY, sourceWidth, sourceHeight, destX, destY, destWidth, destHeight);
							}
						}
					}
				};			
			}
		};
		
		/**
		 * Uses the scaling factor to draw the given image to the canvas.  Takes care of converting the image object so that it acts as though it is the size it
		 * would be if all dimensions were multiplied by the scaling factor and the image was centered so the center of the image and the centere of the screen align.
		 *
		 * It essentially allows the calling code to act as though it is guaranteed that the input-image is the exact same size as the screen (even though it might
		 * not be). This requires you to ignore how big the source image is though, so if you want to display the full width, use the full width of the SCREEN, rather
		 * than imageObject.width.
		 */
		this._drawImageAutoScaled = function(imageObject, sourceX, sourceY, sourceWidth, sourceHeight, destX, destY, destWidth, destHeight){
			var scalingFactor = self._getScalingFactor(imageObject);
//			var offsetX = ( Math.abs((imageObject.width * scalingFactor) - self.canvas.width) / 2 );
//			var offsetY = ( Math.abs((imageObject.height * scalingFactor) - self.canvas.height) / 2 );
			var offsetX = ( Math.abs(imageObject.width - (self.canvas.width / scalingFactor)) / 2 );
			var offsetY = ( Math.abs(imageObject.height - (self.canvas.height / scalingFactor)) / 2 );
			console.log("Scaling factor: " + scalingFactor);
			console.log("\tOffset X: " + offsetX);
			console.log("\tOffset Y: " + offsetY);
			
			// Scale the width and height to act like they were the size of the screen all along (so if the screen is 500px wide and sourceWidth starts
			// at 250px, we'll end up passing in half of the actual width of the scaled source image).
			var scaledSourceWidth = Math.round(sourceWidth / scalingFactor);
			var scaledSourceHeight = Math.round(sourceHeight / scalingFactor);
			
			var scaledX = (offsetX + (sourceX / scalingFactor));
			var scaledY = (offsetY + (sourceY / scalingFactor));

			self._drawImage(imageObject, scaledX, scaledY, scaledSourceWidth, scaledSourceHeight, destX, destY, destWidth, destHeight);
		};
		
		/**
		 * Wrapper around context.drawImage() just for the sake of easily being able to debug all of the variables passed to it.
		 */
		this._drawImage = function(imageObject, sourceX, sourceY, sourceWidth, sourceHeight, destX, destY, destWidth, destHeight){
			var debug = true;
			if(debug){
				console.log("Drawing " + imageObject.src);
				console.log("\tsourceX,Y: (" + sourceX + ", " + sourceY + ")\n");
				console.log("\tsourceW: "+ sourceWidth +"\n");
				console.log("\tsourceH: "+ sourceHeight +"\n");
				console.log("\tdestX,Y: (" + destX + ", " + destY + ")\n");
				console.log("\tdestW: "+ destWidth +"\n");
				console.log("\tdestH: "+ destHeight +"\n");
			}
			self.context.drawImage(imageObject, sourceX, sourceY, sourceWidth, sourceHeight, destX, destY, destWidth, destHeight);
		};
		
		/**
		 * Given an image, returns the appropriate scaling factor using our algorithm for scaling described at the top
		 * of this class. Both the width and the height of the image should be scaled by the same factor to avoid
		 * distortion (maintain the same aspect ratio).
		 */
		this._getScalingFactor = function(imgObject){
		//	console.log("_getScalingFactor()");

			var scalingFactor = 1;

			var imgW = imgObject.width;
			var imgH = imgObject.height;
			var imgAspectRatio = (imgW / imgH);
		//	console.log("\tIMAGE WIDTH:  " + imgW);
		//	console.log("\tIMAGE HEIGHT: " + imgW);
		//	console.log("\tASPECT RATIO: " + imgAspectRatio);

			var screenAspectRatio = (self.canvas.width / self.canvas.height);
		//	console.log("\tSCREEN WIDTH:  " + self.canvas.width);
		//	console.log("\tSCREEN HEIGHT: " + self.canvas.height);
		//	console.log("\tASPECT RATIO: " + screenAspectRatio);
			if(imgAspectRatio > screenAspectRatio){
				// Scale the height to fit the screen exactly (width may overflow a bit so that the left & right get cropped off a bit).
				scalingFactor = (self.canvas.height / imgH);
			} else {
				// Scale the width to fit the screen exactly (height may overflow a bit so top & bottom would get cropped off a bit).
				scalingFactor = (self.canvas.width / imgW);
			}

		//	console.log("\t= SCALING FACTOR: " + scalingFactor);
			return scalingFactor;
		};
	};
}







/**
 * Called by body onload, this function creates the game in the canvas.
 */
function initGame()
{
	console.log("Started...");
	var flipBoard = new FoggyFoto.FlipBoard();
	flipBoard.init();

	flipBoard.show(0,0);
	//flipBoard.show(0,1);
	flipBoard.show(0,2);
	//flipBoard.show(1,0);
	flipBoard.show(1,1);
	//flipBoard.show(1,2);
	flipBoard.show(2,0);
	//flipBoard.show(2,1);
	flipBoard.show(2,2);
	flipBoard.show(3,3);
	flipBoard.show(4,1);

	flipBoard.logState();
	flipBoard.drawBoard();

} // end initGame()
