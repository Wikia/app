/** IMPLEMENTATION USING CANVAS **/

if (typeof PhotoPop === 'undefined') {
	PhotoPop = {};
}

if (typeof PhotoPop.FlipBoard === 'undefined') {
	/**
	 * FlipBoard is a class which is used in PhotoPop to hold a "front" image and a "back" (obscured) image
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
	 */
	PhotoPop.FlipBoard = function(){
		var self = this;
		this.debug = false; // whether to log a whole bunch of info to console.log

		this.canvas = null;
		this.context = null;

		// URLs of the images
		//this.frontImageSrc = 'http://images4.wikia.nocookie.net/__cb20110304030006/lyricwiki/images/b/b7/Deadmau5_-_It_Sounds_Like.jpg'; // this shows up immediately
		this.frontImageSrc = 'http://sean.wikia-dev.com/extensions/wikia/PhotoPop/front.png'; // this shows up immediately
		//this.backImageSrc = "http://images1.wikia.nocookie.net/__cb20110606201926/lyricwiki/images/3/39/Deadmau5_-_Project_56.jpg"; // this is the one that's obscured
		this.backImageSrc = "http://images1.wikia.nocookie.net/__cb20100113214904/glee/images/3/3f/Kurtmercedes.jpg"; // this is the one that's obscured
		this.frontImage = null;
		this.backImage = null;

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
		 * Calculates the _tileWidth and _tileHeight values, sets up clickhandling, loads the front and back images.
		 *
		 * Takes in a callback function which will be called after both of the images are loaded.
		 */
		this.init = function(callback){
			self.canvas = document.getElementById("photoPopCanvas");
			if( self.canvas.getContext ){
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

			// Load the images before continuing.
			self.frontImage = new Image();
			self.frontImage.src = self.frontImageSrc;
			self.frontImage.onload = function(){
				self.backImage = new Image();
				self.backImage.src = self.backImageSrc;
				self.backImage.onload = function(){
					// Attach click-handler.
					self.canvas.addEventListener('click', self.handleClick, false);
					
					// We're done loading things, call the callback.
					if(typeof callback == "function"){
						callback();
					}
				};
			};
		};

		/**
		 * Toggles the display of the tile at the given row and column.
		 */
		this.flip = function(row, col){
			if(typeof self.isBackShowing[row] != "undefined"){
				if(typeof self.isBackShowing[row][col] != "undefined"){
				
					// TODO: Animation for the flip.
					// TODO: Animation for the flip.
				
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
				self.log(rowStr + "\n");
			}
		};

		/**
		 * Draws the entire image to the board, taking into account which tiles are revelaed
		 * according to isBackShowing.
		 */
		this.drawBoard = function(){
			// Display the unaltered image first.
			
			// Draw the front image at the top-left of the canvas... scaled & centered as needed.
			self._drawImageAutoScaled(self.frontImage, 0, 0, self.canvas.width, self.canvas.height, 0, 0, self.canvas.width, self.canvas.height);

			// Display the back-image only in spots that are flipped.
			for(var row=0; row < self.numRows; row++){
				for(var col=0; col < self.numCols; col++){
					// Since we displayed the whole front image, we can skip updating this tile unless it is showing the back tile.
					if((self.isBackShowing[row]) && (self.isBackShowing[row][col] === 1)){
						this.drawTile(row, col);
					}
				}
			}
		};

		/**
		 * Updates the display of a single tile (much faster than redrawing the whole board when one tile changes).
		 */
		this.drawTile = function(row, col){
			var imageToUse;
			self.log("== SHOWING TILE AT (" + row + ", " + col + ") ==");
			if((self.isBackShowing[row]) && (self.isBackShowing[row][col] === 1)){
				imageToUse = self.backImage;
				self.log("[showing back image for this tile]");
			} else {
				imageToUse = self.frontImage;
				self.log("[showing front image for this tile]");
			}

			var sourceX = (self._tileWidth * col);
			var sourceY = (self._tileHeight * row);
			var sourceWidth = self._tileWidth;
			var sourceHeight = self._tileHeight;
			var destWidth = sourceWidth;
			var destHeight = sourceHeight;
			var destX = sourceX;
			var destY = sourceY;

			self._drawImageAutoScaled(imageToUse, sourceX, sourceY, sourceWidth, sourceHeight, destX, destY, destWidth, destHeight);
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
			var offsetX = ( Math.abs(imageObject.width - (self.canvas.width / scalingFactor)) / 2 );
			var offsetY = ( Math.abs(imageObject.height - (self.canvas.height / scalingFactor)) / 2 );
			self.log("Scaling factor: " + scalingFactor);
			self.log("\tOffset X: " + offsetX);
			self.log("\tOffset Y: " + offsetY);
			
			// Scale the width and height to act like they were the size of the screen all along (so if the screen is 500px wide and sourceWidth starts
			// at 250px, we'll end up passing in half of the actual width of the scaled source image).
			var scaledSourceWidth = Math.round(sourceWidth / scalingFactor);
			var scaledSourceHeight = Math.round(sourceHeight / scalingFactor);
			
			var scaledX = Math.floor(offsetX + (sourceX / scalingFactor));
			var scaledY = Math.floor(offsetY + (sourceY / scalingFactor));

			self._drawImage(imageObject, scaledX, scaledY, scaledSourceWidth, scaledSourceHeight, destX, destY, destWidth, destHeight);
		};

		/**
		 * Wrapper around context.drawImage() just for the sake of easily being able to debug all of the variables passed to it.
		 */
		this._drawImage = function(imageObject, sourceX, sourceY, sourceWidth, sourceHeight, destX, destY, destWidth, destHeight){
			var debug = true;
			if(debug){
				self.log("Drawing " + imageObject.src);
				self.log("\tsourceX,Y: (" + sourceX + ", " + sourceY + ")\n");
				self.log("\tsourceW: "+ sourceWidth +"\n");
				self.log("\tsourceH: "+ sourceHeight +"\n");
				self.log("\tdestX,Y: (" + destX + ", " + destY + ")\n");
				self.log("\tdestW: "+ destWidth +"\n");
				self.log("\tdestH: "+ destHeight +"\n");
			}
			self.context.drawImage(imageObject, sourceX, sourceY, sourceWidth, sourceHeight, destX, destY, destWidth, destHeight);
		};
		
		/**
		 * Given an image, returns the appropriate scaling factor using our algorithm for scaling described at the top
		 * of this class. Both the width and the height of the image should be scaled by the same factor to avoid
		 * distortion (maintain the same aspect ratio).
		 */
		this._getScalingFactor = function(imgObject){
		//	self.log("_getScalingFactor()");

			var scalingFactor = 1;

			var imgW = imgObject.width;
			var imgH = imgObject.height;
			var imgAspectRatio = (imgW / imgH);
		//	self.log("\tIMAGE WIDTH:  " + imgW);
		//	self.log("\tIMAGE HEIGHT: " + imgW);
		//	self.log("\tASPECT RATIO: " + imgAspectRatio);

			var screenAspectRatio = (self.canvas.width / self.canvas.height);
		//	self.log("\tSCREEN WIDTH:  " + self.canvas.width);
		//	self.log("\tSCREEN HEIGHT: " + self.canvas.height);
		//	self.log("\tASPECT RATIO: " + screenAspectRatio);
			if(imgAspectRatio > screenAspectRatio){
				// Scale the height to fit the screen exactly (width may overflow a bit so that the left & right get cropped off a bit).
				scalingFactor = (self.canvas.height / imgH);
			} else {
				// Scale the width to fit the screen exactly (height may overflow a bit so top & bottom would get cropped off a bit).
				scalingFactor = (self.canvas.width / imgW);
			}

		//	self.log("\t= SCALING FACTOR: " + scalingFactor);
			return scalingFactor;
		};

		/**
		 * Click-handler which recieves all clicks on the canvas.
		 */
		this.handleClick = function(e){
			var tile = self._getTileByClick(e);

			self.log("Click on tile: (" + tile.row + ", " + tile.col + ")");

			self.flip( tile.row, tile.col );
			self.drawTile( tile.row, tile.col ); // TODO: Should this be part of the flip/show functions by default?
		};
		
		/**
		 * Given a click event, calculates what cell on the board the click occurred in.
		 *
		 * Cross-platform trickery courtesy of:
		 * http://answers.oreilly.com/topic/1929-how-to-use-the-canvas-and-draw-elements-in-html5/
		 *
		 * @return a PhotoPop.FlipBoard.Tile (which is just a wrapper for the coordinates)
		 */
		this._getTileByClick = function(e){
			var x;
			var y;
			if (e.pageX || e.pageY) {
			  x = e.pageX;
			  y = e.pageY;
			}
			else {
			  x = e.clientX + document.body.scrollLeft +
				   document.documentElement.scrollLeft;
			  y = e.clientY + document.body.scrollTop +
				   document.documentElement.scrollTop;
			}
			
			x -= self.canvas.offsetLeft;
			y -= self.canvas.offsetTop;
			
			var tile = new PhotoPop.FlipBoard.Tile();
			tile.row = Math.floor(y / self._tileWidth);
			tile.col = Math.floor(x / self._tileHeight);

			return tile;
		};
		
		/**
		 * Simple wrapper for console.log to allow us to turn on/off debugging for this
		 * whole class at once.
		 */
		this.log = function(msg){
			if(self.debug){
				console.log(msg);
			}
		};
	};
	
	/**
	 * Currently just a wrapper for the row and column coordinates of a tile.  The coordinates are
	 * relative to the tiles not to pixels.  For example, if we had a FlipBoard with 6 columns and
	 * 4 rows of Tiles and the tiles were 80 pixels squared, this class would be used to hold a value
	 * between (0,0) and (5,3).
	 *
	 * This is primarily used as  a convenience-type for passing coordinates around & isn't intended to
	 * balloon into holding a bunch of functionality (since Tiles themselves are more of a locational
	 * concept at the moment and not strictly-speaking objects - the front and back of the tile do not
	 * belong to the tile, but rather are calculated at display-time given the location of the tile and
	 * whether the front image or back image is supposed to be displayed).
	 */
	PhotoPop.FlipBoard.Tile = function(){
		this.row = -1;
		this.col = -1;
	};
}






/**
 * Called by body onload, this function creates the game in the canvas.
 */
function initGame()
{
	//console.log("Started...");
	var flipBoard = new PhotoPop.FlipBoard();
	flipBoard.init(function(){
		/*flipBoard.show(0,0);
		//flipBoard.show(0,1);
		flipBoard.show(0,2);
		//flipBoard.show(1,0);
		flipBoard.show(1,1);
		//flipBoard.show(1,2);
		flipBoard.show(2,0);
		//flipBoard.show(2,1);
		flipBoard.show(2,2);
		flipBoard.show(3,3);
		flipBoard.show(4,1);*/

		flipBoard.logState();
		flipBoard.drawBoard();
	});

} // end initGame()
