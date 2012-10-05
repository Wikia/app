package com.wikia.webdriver.Common.Properties;

import java.io.File;

import com.wikia.webdriver.Common.Core.Global;
import com.wikia.webdriver.Common.Core.XMLFunctions;

public class Properties {

	public static String userName;
	public static String password;
	
	public static String userName2;
	public static String password2;
	
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
	
	public static String userNameFB;
	public static String passwordFB;
	
	
	
	private static void setVariables()
	{
		userName = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.regular.username");
		password = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.regular.password");
		
		userName2 = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.regular2.username");
		password2 = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.regular2.password");
		
		userNameNonLatin = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.nonLatin.username");
		userNameNonLatinEncoded = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.nonLatin.usernameenc");
		passwordNonLatin = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.nonLatin.password");
		
		userNameWithUnderScore = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.underscore.username");
		passwordWithUnderScore = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.underscore.password");
		
		userNameWithBackwardSlash = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.backwardslash.username");
		userNameWithBackwardSlashEncoded = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.backwardslash.usernameenc");
		passwordWithBackwardSlash = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.backwardslash.password");
		
		userNameLong = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.long.username");
		passwordLong = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.long.password");
		
		userNameStaff = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.wikiastaff.username");
		passwordStaff = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.wikiastaff.password");
		
		userNameFB = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.facebook.username");
		passwordFB = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.user.facebook.password");
		
		email = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.email.generic.username");
		emailPassword = XMLFunctions.getXMLConfiguration(Global.CONFIG_FILE, "ci.email.generic.password");
	
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
		Global.CAPTCHA_FILE = new File(System.getProperty("captcha"));
		Global.DOMAIN = System.getProperty("base-address");
		Global.LIVE_DOMAIN = System.getProperty("live-domain");
		Global.LOG_VERBOSE = 2;
	}
	
	private static void setPropertiesManually()
	{
		Global.BROWSER = "CHROME";
		Global.DOMAIN = "http://mediawiki119.wikia.com/";
		Global.LIVE_DOMAIN = "http://preview.www.wikia.com/";
		Global.CONFIG_FILE = new File("c:"+File.separator+"wikia-qa"+File.separator+"config.xml");
		Global.CAPTCHA_FILE = new File("c:"+File.separator+"wikia-qa"+File.separator+"captcha.txt");
		Global.LOG_VERBOSE = 2;
	}
}
