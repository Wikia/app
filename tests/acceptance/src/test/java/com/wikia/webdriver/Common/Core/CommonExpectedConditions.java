package com.wikia.webdriver.Common.Core;
//http://code.google.com/p/selenium/source/browse/trunk/java/client/src/org/openqa/selenium/support/ui/ExpectedConditions.java
import java.util.logging.Level;
import java.util.logging.Logger;

import org.openqa.selenium.By;
import org.openqa.selenium.NoSuchElementException;
import org.openqa.selenium.StaleElementReferenceException;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebDriverException;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.ui.ExpectedCondition;
import org.openqa.selenium.support.ui.ExpectedConditions;

import com.wikia.webdriver.Common.DriverProvider.DriverProvider;

public class CommonExpectedConditions  {

	private final static Logger log = Logger.getLogger(ExpectedConditions.class.getName());
	
	private static WebDriver driver = DriverProvider.getWebDriver();

	
	 /**
	   * An expectation for checking if the given text is present in the specified
	   * element.
	   */
	  public static ExpectedCondition<Boolean> valueToBePresentInElementsAttribute(
	      final By locator, final String attribute, final String value) {

	    return new ExpectedCondition<Boolean>() {
	      public Boolean apply(WebDriver from) {
	        try {
	          String elementsAttributeValue = findElement(locator, from).getAttribute(attribute);
	          return elementsAttributeValue.contains(value);
	        } catch (StaleElementReferenceException e) {
	          return null;
	        }
	      }

	      @Override
	      public String toString() {
	        return String.format("value ('%s') to be present in element found by %s",
	        		value, locator);
	      }
	    };
	  }
	  
		 /**
	   * An expectation for checking if the page URL contains givenString
	   * 
	   */
	  public static ExpectedCondition<Boolean> givenStringtoBePresentInURL(final String givenString) {

		 driver = DriverProvider.getWebDriver();
	    return new ExpectedCondition<Boolean>() {
			public Boolean apply(WebDriver d) {
				Boolean contains;
				contains = driver.getCurrentUrl().contains(givenString);
				return contains;
			}
	    };
	  }
	  

	  
	  /**
	   * Looks up an element. Logs and re-throws WebDriverException if thrown. <p/>
	   * Method exists to gather data for http://code.google.com/p/selenium/issues/detail?id=1800
	   */
	  private static WebElement findElement(By by, WebDriver driver) {
	    try {
	      return driver.findElement(by);
	    } catch (NoSuchElementException e) {
	      throw e;
	    } catch (WebDriverException e) {
	      log.log(Level.WARNING,
	          String.format("WebDriverException thrown by findElement(%s)", by), e);
	      throw e;
	    }
	  }
	  

	  
}
