const convertExcel = require('convert-excel-to-json');

var langCodes = ['EN','FR','DE','IT','JA','PL','PT-BR','RU','ES','ZH ZH-TW ZH-HK'];
var  defSheet = 'X.xlsx';

if(process.argv.length > 2){
	defSheet = process.argv[2];
	console.log(process.argv[2]);
}

var result = convertExcel(
	{
		sourceFile: defSheet,
		sheets: langCodes,
		columnToKey: {
			B: 'title',
			C: 'url',
			D: 'thumbnailUrl'
		}
	}
);
var output = {};
langCodes.forEach(function(element){
	output[element.toLowerCase()] = {};
});



langCodes.forEach(function(element){
	for( var i =1; i < result[element].length; i++ ) {
		if(result[element][i]['A'] == "Example"){
			break;
		}

	output[element.toLowerCase()][i-1] = result[element][i];

}
});
var output2 = {'en': {}};

var fs = require('fs');
fs.writeFile('recommendations.json',JSON.stringify(output, null, "\t"),function(err){
	if(err){
		console.log('Something went horribly wrong');
	}
	console.log('Output in ./recommendations.json\n');

});

