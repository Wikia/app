package com.wikia.webdriver.Templates;

import org.openqa.selenium.WebDriver;
import org.testng.annotations.AfterMethod;
import org.testng.annotations.BeforeMethod;

import com.wikia.webdriver.DriverProvider.DriverProvider;
import com.wikia.webdriver.Logging.PageObjectLogging;

public class TestTemplate {
	
	public WebDriver driver;
	
	@BeforeMethod
	public void start()
	{
		PageObjectLogging.startLogging(getClass().getName().toString());
		driver = DriverProvider.getInstance().getWebDriver();
	}
	
	@AfterMethod
	public void stop()
	{
		driver.close();
	}

}
