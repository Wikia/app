package com.wikia.webdriver.Properties;

import java.io.File;

import com.wikia.webdriver.Common.Global;
import com.wikia.webdriver.Common.XMLFunctions;

public class Properties {

	public static String userName;
	public static String password;
	
	public static String userNameNonLatin;
	public static String userNameNonLatinEncoded;
	public static String passwordNonLatin;
	
	public static String userNameWithUnderScore;
	public static String passwordWithUnderScore;
	
	public static String userNameWithBackwardSlash;
	public static String userNameWithBackwardSlashEncoded;
	public static String passwordWithBackwardSlash;
	
	public static String userNameLong;
	public static String passwordLong;
	
	public static String email;
	public static String emailPassword;
	
	
	public static String userNameStaff;
	public static String passwordStaff;
	
	private static void setVariables()
	{
		Properties.userName = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.regular.username");
		password = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.regular.password");
		
		userNameNonLatin = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.nonLatin.username");
		userNameNonLatinEncoded = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.nonLatin.usernameenc");
		passwordNonLatin = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.nonLatin.password");
		
		Properties.userNameWithUnderScore = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.underscore.username");
		passwordWithUnderScore = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.underscore.password");
		
		userNameWithBackwardSlash = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.backwardslash.username");
		userNameWithBackwardSlashEncoded = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.backwardslash.usernameenc");
		passwordWithBackwardSlash = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.backwardslash.password");
		
		userNameLong = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.long.username");
		passwordLong = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.long.password");
		
		userNameStaff = "";
		passwordStaff = "";
		
		email = "webdriverseleniumwikia@gmail.com";
		emailPassword = "";
	}
	
	public static void setProperties()
	{
		Global.RUN_BY_MAVEN = "true".equals(System.getProperty("run_mvn"));
		if (Global.RUN_BY_MAVEN)
		{	
			getPropertiesFromPom();
		}
		else
		{
			setPropertiesManually();
		}		
		setVariables();
	}
	
	private static void getPropertiesFromPom()
	{
		Global.BROWSER = System.getProperty("browser");
		Global.CONFIG_FILE = new File(System.getProperty("config"));
	}
	
	private static void setPropertiesManually()
	{
		Global.BROWSER = "FF";
		Global.CONFIG_FILE = new File("c:"+File.separator+"config.xml"+File.separator+"config.xml");
	}
	
	
}
