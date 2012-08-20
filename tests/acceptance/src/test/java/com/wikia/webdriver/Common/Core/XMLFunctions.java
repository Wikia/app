package com.wikia.webdriver.Common.Core;

import java.io.File;

import org.apache.commons.configuration.ConfigurationException;
import org.apache.commons.configuration.XMLConfiguration;

public class XMLFunctions 
{

	/**
	 * method used to get credentials from configuration xml
	 * @param file
	 * @param key
	 * @return
	 * @author Karol Kujawiak
	 */
	public static String getXMLConfiguration(File file, String key)
	{
		try
		{
			XMLConfiguration xml = new XMLConfiguration(file);
			return xml.getString(key);
		}
		catch(Exception e)
		{
			return e.toString();
		}
	}
}
