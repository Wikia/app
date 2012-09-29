package com.wikia.webdriver.Common.Templates;

import java.io.File;
import java.io.IOException;
import java.lang.reflect.Method;

import org.browsermob.proxy.ProxyServer;
import org.browsermob.proxy.jetty.jetty.Server;
import org.openqa.selenium.WebDriver;
import org.testng.annotations.AfterMethod;
import org.testng.annotations.AfterSuite;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.BeforeSuite;

import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Core.CommonUtils;
import com.wikia.webdriver.Common.Core.Global;
import com.wikia.webdriver.Common.DriverProvider.DriverProvider;
import com.wikia.webdriver.Common.Logging.PageObjectLogging;
import com.wikia.webdriver.Common.Properties.Properties;

public class TestTemplate {
	
	public WebDriver driver;
	public ProxyServer server;
	
	@BeforeSuite(alwaysRun = true)
	public void beforeSuite()
	{
		CommonUtils.deleteDirectory("."+File.separator+"logs");
		CommonUtils.createDirectory("."+File.separator+"logs");
		PageObjectLogging.startLoggingSuite();
		
		Properties.setProperties();
		
	}
	
	@AfterSuite(alwaysRun = true)
	public void afterSuite()
	{
		PageObjectLogging.stopLoggingSuite();
//		try 
//		{
//			if (Global.BROWSER.equals("IE"))
//			{
//				String sysArch = System.getProperty("os.arch");
//				if (sysArch.equals("x86"))
//				{
//					Runtime.getRuntime().exec("taskkill /F /IM IEDriverServer_x86.exe");
//				} 
//				else
//				{
//					Runtime.getRuntime().exec("taskkill /F /IM IEDriverServer_x64.exe");
//				}							
//			}
//			else if (Global.BROWSER.equals("CHROME"))
//			{
//				Runtime.getRuntime().exec("taskkill /F /IM chromedriver.exe");
//			}
//			else if (Global.BROWSER.equals("FF"))
//			{
//				Runtime.getRuntime().exec("taskkill /F /IM firefox.exe");
//			}
//		}
//
//		catch (IOException e) 
//		{
//			// TODO Auto-generated catch block
//			e.printStackTrace();
//		}		
	}

	
	@BeforeMethod(alwaysRun = true)
	public void start(Method method)
	{
		startBrowser();
//		CommonFunctions.MoveCursorTo(0, 0);
		PageObjectLogging.startLoggingMethod(getClass().getSimpleName().toString(), method.getName());
	}
	
	@AfterMethod(alwaysRun = true)
	public void stop()
	{
		stopBrowser();
//		CommonFunctions.MoveCursorTo(0, 0);
		PageObjectLogging.stopLoggingMethod();
	}
	
	
	private void startBrowser()
	{
		DriverProvider.getInstance();
		driver = DriverProvider.getWebDriver();
		server = DriverProvider.getServer();
	}
	
	private void stopBrowser()
	{
		driver = DriverProvider.getWebDriver();
		if (driver != null)
		{
			if (Global.BROWSER.equals("CHROME"))
			{
				driver.quit();
			}
			else
			{
				driver.close();				
			}
			driver = null;
		}
	}
	
	
	

}
