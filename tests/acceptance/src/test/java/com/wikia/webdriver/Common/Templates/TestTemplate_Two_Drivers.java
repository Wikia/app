package com.wikia.webdriver.Common.Templates;

import java.io.File;
import java.io.IOException;
import java.lang.reflect.Method;

import org.openqa.selenium.Dimension;
import org.openqa.selenium.WebDriver;
import org.testng.annotations.AfterMethod;
import org.testng.annotations.AfterSuite;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.BeforeSuite;

import com.wikia.webdriver.Common.Core.CommonUtils;
import com.wikia.webdriver.Common.Core.Global;
import com.wikia.webdriver.Common.DriverProvider.DriverProvider;
import com.wikia.webdriver.Common.Logging.PageObjectLogging;
import com.wikia.webdriver.Common.Properties.Properties;

public class TestTemplate_Two_Drivers {
	
	public WebDriver driver;
	public WebDriver driver2;
	
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
		try 
		{
			if (Global.BROWSER.equals("IE"))
			{
				String sysArch = System.getProperty("os.arch");
				if (sysArch.equals("x86"))
				{
					Runtime.getRuntime().exec("taskkill /F /IM IEDriverServer_x86.exe");
				} 
				else
				{
					Runtime.getRuntime().exec("taskkill /F /IM IEDriverServer_x64.exe");
				}							
			}
			else if (Global.BROWSER.equals("CHROME"))
			{
				Runtime.getRuntime().exec("taskkill /F /IM chromedriver.exe");
			}
			else if (Global.BROWSER.equals("FF"))
			{
				Runtime.getRuntime().exec("taskkill /F /IM firefox.exe");
			}
		}

		catch (IOException e) 
		{
			// TODO Auto-generated catch block
			e.printStackTrace();
		}		
	}

	
	@BeforeMethod(alwaysRun = true)
	public void start(Method method)
	{
		startBrowsers();
		PageObjectLogging.startLoggingMethod(getClass().getSimpleName().toString(), method.getName());
	}
	
	@AfterMethod(alwaysRun = true)
	public void stop()
	{
		stopBrowsers();
		PageObjectLogging.stopLoggingMethod();
	}
	
	
	private void startBrowsers()
	{
		driver = DriverProvider.getInstance().getWebDriver();
		driver2 = DriverProvider.getInstanceFF().getWebDriver();
	}
	
	private void stopBrowsers()
	{
		if (driver != null)
		{
			driver.close();
			driver = null;
		}
		if (driver2 != null)
		{
			driver2.close();
			driver2 = null;
		}
	}
	
	protected void switchToWindow(WebDriver maximized)
	{
		Dimension min = new Dimension(10,10);
		driver.manage().window().setSize(min);
		driver2.manage().window().setSize(min);
		maximized.manage().window().maximize();
	}
}
