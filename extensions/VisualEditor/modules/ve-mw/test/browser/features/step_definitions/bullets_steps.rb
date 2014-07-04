
Given(/^I close the VE information window$/) do
  pending # express the regexp above with the code you wish you had
end

   When(/^I type in an input string$/) do
  on(VisualEditorPage) do |page|
    #extra space after 'line' below is a workaround for FF issue where VE is sending BACKSPACE before RETURN
    #probably caused by https://bugzilla.wikimedia.org/show_bug.cgi?id=56274
    page.content_element.when_present(10).send_keys "This is a new line "
    page.content_element.when_present(10).send_keys :return
  end
end

When(/^select the string$/) do
  require "watir-webdriver/extensions/select_text"
  on(VisualEditorPage).content_element.select_text "This is a new line"
  sleep 1 # turn the sleep on if this test fails with bullet/number in front of string NOT "This is.."
end

When(/^I click Numbering$/) do
  on(VisualEditorPage) do |page|
    page.bullet_number_selector_element.when_present(15).click
    page.ve_numbering_element.when_present.click
  end
end

Then(/^a \# is added in front of input string in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.diff_view.include? "# #{@wikitext}"
    end
    page.diff_view.should match Regexp.new(/^\# #{@wikitext}/)
  end
end

When(/^I click Bullets$/) do
  on(VisualEditorPage) do |page|
    page.bullet_number_selector_element.when_present(15).click
    page.ve_bullets_element.when_present.click
  end
end

Then(/^a \* is added in front of input string in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.diff_view.include? "* #{@wikitext}"
    end
    page.diff_view.should match Regexp.new(/^\* #{@wikitext}/)
  end
end

When(/^I click Increase indentation$/) do
  on(VisualEditorPage) do |page|
    page.bullet_number_selector_element.when_present(15).click
    page.increase_indentation_element.when_present.click
  end
end

Then(/^a \#\# is added in front of input string in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.diff_view.include? "## #{@wikitext}"
    end
    page.diff_view.should match Regexp.new(/^\#\# #{@wikitext}/)
  end
end

Then(/^a \*\* is added in front of input string in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.diff_view.include? "** #{@wikitext}"
    end
    page.diff_view.should match Regexp.new(/^\*\* #{@wikitext}/)
  end
end


When(/^I click Decrease indentation$/) do
  on(VisualEditorPage) do |page|
    sleep 2 #this is waiting for the Review Your Changes iframe to disappear
    page.bullet_number_selector_element.when_present(15).click
    page.decrease_indentation_element.when_present.click
  end
end

Then(/^nothing is added in front of input string in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.review_failed_element.when_present.text.include? "No changes to review"
    end
    page.review_failed_element.when_present.text.should match "No changes to review"
  end
end

Then(/^Decrease indentation should be disabled$/) do
  on(VisualEditorPage).decrease_indentation_element.should_not be_visible
end

Then(/^Increase indentation should be disabled$/) do
  on(VisualEditorPage).increase_indentation_element.should_not be_visible
end


Then(/^Decrease indentation should be enabled$/) do
  on(VisualEditorPage).decrease_indentation_element.class_name.should_not match /disabled/
end

Then(/^Increase indentation should be enabled$/) do
  on(VisualEditorPage).increase_indentation_element.class_name.should_not match /disabled/
end

When(/^I undo Bullets$/) do
  on(VisualEditorPage) do |page|
    page.bullet_number_selector_element.when_present(15).click
    page.ve_bullets_element.when_present.click
  end
end

When(/^I undo Numbering$/) do
  on(VisualEditorPage) do |page|
    page.bullet_number_selector_element.when_present(15).click
    page.ve_numbering_element.when_present.click
  end
end
