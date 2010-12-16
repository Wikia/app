 /**
  * Javascript utility functions for Semantic Maps.
  *
  * @file SMUtilityFunctions.js
  * @ingroup SemanticMaps
  *
  * @author Robert Buzink
  * @author Yaron Koren   
  * @author Jeroen De Dauw
  */

function convertLatToDMS (val) {
	return Math.abs(val) + "° " + ( val < 0 ? "S" : "N" );
}

function convertLngToDMS (val) {
	return Math.abs(val) + "° " + ( val < 0 ? "W" : "E" );

}