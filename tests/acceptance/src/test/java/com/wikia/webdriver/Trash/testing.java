package com.wikia.webdriver.Trash;

import org.openqa.selenium.By;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.internal.seleniumemulation.WaitForCondition;
import org.testng.annotations.Test;

import com.wikia.webdriver.Common.Templates.TestTemplate;
import com.wikia.webdriver.PageObjects.PageObject.BasePageObject;

public class testing extends TestTemplate{
	
	@Test(groups = {"trash"})
	public void CreateNewWiki()
	{
//		driver.get(Global.LIVE_DOMAIN);
//		Har har1 = server.getHar();
//		har1.writeTo(new File("c:/b.har"));
		BasePageObject b = new BasePageObject(driver);
		driver.get("http://wikia.com/");
		JavascriptExecutor js = (JavascriptExecutor) driver;
//		js.executeScript("document.querySelectorAll(\".wikia-menu-button\")[0].click()");
//		js.executeScript("document.querySelectorAll(\".wikia-menu-button\")[0].click()");
//		driver.findElement(By.cssSelector("#article-comm")).click();
//		WebElement a = driver.findElement(By.cssSelector("nav[class='wikia-menu-button contribute secondary combined']"));
//		
		
		((JavascriptExecutor)driver).executeScript("$('.Video_Games').mouseleave()");
		((JavascriptExecutor)driver).executeScript("$('.Video_Games').mouseenter()");
		((JavascriptExecutor)driver).executeScript("$('.Video_Games').mouseleave()");
		((JavascriptExecutor)driver).executeScript("$('.Video_Games').mouseenter()");
//		((JavascriptExecutor)driver).executeScript("$('.Video_Games').mouseenter()");
//		((JavascriptExecutor)driver).executeScript("$('.Video_Games').mouseenter()");
//		((JavascriptExecutor)driver).executeScript("$('.Video_Games').mouseleave()");
//		((JavascriptExecutor)driver).executeScript("$('.Video_Games').mouseleave()");
//		((JavascriptExecutor)driver).executeScript("$('.Video_Games').mouseenter()");
//		((JavascriptExecutor)driver).executeScript("$('.Video_Games').mouseenter()");
//		((JavascriptExecutor)driver).executeScript("$('.Video_Games').mouseleave()");
//		((JavascriptExecutor)driver).executeScript("$('.Video_Games').mouseleave()");
//		((JavascriptExecutor)driver).executeScript("$('.Video_Games').mouseenter()");
//		((JavascriptExecutor)driver).executeScript("$('.Video_Games').mouseenter()");
//		((JavascriptExecutor)driver).executeScript("$('.Video_Games').mouseleave()");
//		((JavascriptExecutor)driver).executeScript("$('.Video_Games').mouseleave()");
//		((JavascriptExecutor)driver).executeScript("$('.Video_Games').mouseenter()");
//		((JavascriptExecutor)driver).executeScript("$('.Video_Games').mouseenter()");
//		((JavascriptExecutor)driver).executeScript("$('.Video_Games').mouseleave()");
//		((JavascriptExecutor)driver).executeScript("$('.Video_Games').mouseleave()");

//		b.executeScript("$('.Video_Games').mouseenter()");
//		b.executeScript("$('.Video_Games').mouseenter()");
//		a.click();
//		b.aaa();
		
	}
	
	
	
	
	
	

}
