/*
*
*   Copyright (c) Microsoft. 
*
*	This code is licensed under the Apache License, Version 2.0.
*   THIS CODE IS PROVIDED *AS IS* WITHOUT WARRANTY OF
*   ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING ANY
*   IMPLIED WARRANTIES OF FITNESS FOR A PARTICULAR
*   PURPOSE, MERCHANTABILITY, OR NON-INFRINGEMENT.
*
*   The apache license details from 
*   ‘http://www.apache.org/licenses/’ are reproduced 
*   in ‘Apache2_license.txt’ 
*
*/

/*
* This file defines template mappings that would be handled by WikiBhasha beta.
* At first level, language pairs for which mappings are defined are specified.
* In the second level, mappings between specific templates that exist in 
* source and target languages are specified.
* In the third level, mappings between specific attributes of source language template 
*	to specific attributes of target language template are specified.

*	SAMPLE MAPPING
*
*	 <templateMapBetweenLangPair SrcLang='src' tgtLang='tgt'>
*		<templateMap srcTemplateName='srcTemplate1' tgtTemplateName='tlTemplate1'>
*			<param srcTemplateParamName="srcTemAttr1" tgtTemplateParamName="tgtTemAttr1"/>
*			<param srcTemplateParamName="srcTemAttr2" tgtTemplateParamName="tgtTemAttr2"/>
*			...	
*		
*		</templateMap>
*	 </templateMapperBetweenLangPair>

*
* Caveats:
*	1. WikiBhasha would automatically convert 'EnTemplate1' to 'JaTemplate1' with specified 
*	    mapping of attributes.  The attribute values of corresponding English template attributes
*	    would be translated and put into the corresponding Japanese template attributes. All the 
*       above template names and attribute names are assumed as valid.  If the underlying 
*	    templates change, please modify this map configuration file, accordingly.
*	2. Those English template attributes that does not have a specified mapping in the above 
*	   template map would be dropped.
*	3. Those Japnese template attributes that does not have a corresponding mapping in the above 
*	   template map would be preserved, but filled with NO value.
*	4. Note that any source language template that is not in this configuration file, would be pointing
*	   to the source language template itself, with values translated.
*
* NOTE: The configuration information is available as a value of variable ‘templateMapConfig’ in this 
* file. This is to avoid cross site scripting. This configuration information will be moved as content 
* of a separate XML file once this application deployed in Wikipedia. 
*/

// Make sure the base namespace exists.
// includes all the available configurations for the application.
if (typeof (wikiBhasha.configurations) === "undefined") {
    wikiBhasha.configurations = {};
}

// describes the configuration required for template mapping from source language article to target language article.
wikiBhasha.configurations.templateMappers = {
    templateMapConfig: '<?xml version="1.0"?>\
                        <templateMapConfig>\
	                        <templateMapBetweenLangPair srcLang="en" tgtLang="ja">\
		                        <templateMap srcTemplateName="EnTemplate1" tgtTemplateName="JaTempalte1">\
			                        <param srcTemplateParamName="EnTemAttr1" tgtTemplateParamName="JaTemAttr1"/>\
			                        <param srcTemplateParamName="EnTemAttr2" tgtTemplateParamName="JaTemAttr2"/>\
		                        </templateMap>\
		                    </templateMapBetweenLangPair>\
		                    <templateMapBetweenLangPair srcLang="en" tgtLang="hi">\
		                        <templateMap srcTemplateName="Age in weeks" tgtTemplateName="उमर_सप्ताह_मे">\
			                        <param srcTemplateParamName="month1" tgtTemplateParamName="महिना1"/>\
			                        <param srcTemplateParamName="day1" tgtTemplateParamName="दिन1"/>\
			                        <param srcTemplateParamName="year1" tgtTemplateParamName="साल1"/>\
			                        <param srcTemplateParamName="month2" tgtTemplateParamName="महिना2"/>\
			                        <param srcTemplateParamName="day2" tgtTemplateParamName="दिन2"/>\
			                        <param srcTemplateParamName="year2" tgtTemplateParamName="साल2"/>\
		                        </templateMap>\
		                    </templateMapBetweenLangPair>\
		                </templateMapConfig>'
};
