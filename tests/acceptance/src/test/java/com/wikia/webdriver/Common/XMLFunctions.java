package com.wikia.webdriver.Common;

import java.io.File;

import org.apache.commons.configuration.ConfigurationException;
import org.apache.commons.configuration.XMLConfiguration;

public class XMLFunctions 
{

	public static String getXMLConfiguration(File file, String key)
	{
		try{
			
		
		XMLConfiguration xml = new XMLConfiguration(file);
		return xml.getString(key);
		}
		catch(Exception e)
		{
			return e.toString();
		}
	}
}
