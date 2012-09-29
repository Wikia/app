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

public class CommonExpectedConditions {

	private final static Logger log = Logger.getLogger(ExpectedConditions.class.getName());
	
	private static WebDriver driver = DriverProvider.getWebDriver();

	
	/**
	 * An expectation for checking if the given text is present in the specified
	 * element.
	 *
	 * @author Michal Nowierski
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
	 * An expectation for checking if the given text is present in the specified
	 * element.
	 *
	 * @author Michal Nowierski
	 */
	public static ExpectedCondition<Boolean> valueToNotBePresentInElementsAttribute(
	      final By locator, final String attribute, final String value) {

	    return new ExpectedCondition<Boolean>() {
	      public Boolean apply(WebDriver from) {
	        try {
	          String elementsAttributeValue = findElement(locator, from).getAttribute(attribute);
	          return !elementsAttributeValue.contains(value);
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

	public static ExpectedCondition<Boolean> classRemovedFromElement(final WebElement element, final String className)
	{
		return new ExpectedCondition<Boolean>() {
			public Boolean apply(WebDriver from) {
				String classString = element.getAttribute("class");
				boolean hasClass = classString.matches("^"   + className + "$")
								|| classString.matches("\\s" + className + "$")
								|| classString.matches("^"   + className + "\\s")
								|| classString.matches("\\s" + className + "\\s");
				return !hasClass;
			}
		};
	}
	  
	  /**
	   * An expectation for checking if the page URL contains givenString
	   * 
	   * @author Michal Nowierski
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
	   * An Expectation for checking an element is visible and enabled such that you
	   * can click it.
	   * 
	   * @param GivenElement element to be checked
	   * @author Michal Nowierski
	   */
	  public static ExpectedCondition<WebElement> elementToBeClickable(
	      final WebElement GivenElement) {
	    return new ExpectedCondition<WebElement>() {

	      public ExpectedCondition<WebElement> visibilityOfElement =
	          ExpectedConditions.visibilityOf(GivenElement);

	      public WebElement apply(WebDriver driver) {
	        WebElement element = visibilityOfElement.apply(driver);
	        try {
	          if (element != null && element.isEnabled()) {
	            return element;
	          } else {
	            return null;
	          }
	        } catch (StaleElementReferenceException e) {
	          return null;
	        }
	      }

	      @Override
	      public String toString() {
	        return "element to be clickable: " + GivenElement.getTagName();
	      }
	    };
	  }
	  
	  /**
	   * An Expectation for checking an element is visible and not enabled such that you
	   * can not click it.
	   * 
	   * @param GivenElement element to be checked
	   * @author Michal Nowierski
	   */
	  public static ExpectedCondition<WebElement> elementNotToBeClickable(
	      final WebElement GivenElement) {
	    return new ExpectedCondition<WebElement>() {

	      public ExpectedCondition<WebElement> visibilityOfElement =
	          ExpectedConditions.visibilityOf(GivenElement);

	      public WebElement apply(WebDriver driver) {
	        WebElement element = visibilityOfElement.apply(driver);
	        try {
	          if (element != null && !element.isEnabled()) {
	            return element;
	          } else {
	            return null;
	          }
	        } catch (StaleElementReferenceException e) {
	          return null;
	        }
	      }

	      @Override
	      public String toString() {
	        return "element to be clickable: " + GivenElement.getTagName();
	      }
	    };
	  }
	  
	  /**
	   * An expectation for checking if the given text is present in the specified
	   * element.
	   */
	  public static ExpectedCondition<Boolean> textToBePresentInElement(
		final WebElement GivenElement, final String text) {

	    return new ExpectedCondition<Boolean>() {
	      public Boolean apply(WebDriver from) {
	        try {
	          String elementText = GivenElement.getText();
	          return elementText.contains(text);
	        } catch (StaleElementReferenceException e) {
	          return null;
	        }
	      }

	      @Override
	      public String toString() {
	        return String.format("text ('%s') to be present in element %s",
	            text, GivenElement.getTagName());
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
	  
	  private static boolean findInvisibleElement(By by, WebDriver driver) 
	  {
		  try
		  {
			  driver.findElement(by);
			  return false;
		  }
		  catch (NoSuchElementException e)
		  {
			  return true;
		  }
	  }
	  
	  public static ExpectedCondition<Boolean> invisibilityOfElementLocated(
		      final By locator) {
		    return new ExpectedCondition<Boolean>() {
		      public Boolean apply(WebDriver driver) {
		        try {
		          return (findInvisibleElement(locator, driver));
		        }
		        catch (StaleElementReferenceException e) 
		        {
		          // Returns true because stale element reference implies that element
		          // is no longer visible.
		          return true;
		        }
		      }

		      @Override
		      public String toString() {
		        return "element to no longer be visible: " + locator;
		      }
		    };
		  }
	  
 
	  
}
