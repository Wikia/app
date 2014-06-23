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
 on(VisualEditorPage).ve_numbering_element.when_present(15).click
end

Then(/^a \# is added in front of input string in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.diff_view.include? "# This "
    end
    page.diff_view.should match Regexp.new(/^\# This is a new line/)
  end
end

When(/^I click Bullets$/) do
  on(VisualEditorPage).ve_bullets_element.when_present(15).click
end

Then(/^a \* is added in front of input string in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.diff_view.include? "* This "
    end
    page.diff_view.should match Regexp.new(/^\* This is a new line/)
  end
end

When(/^I click Increase indentation$/) do
  on(VisualEditorPage).increase_indentation_on_element.when_present(15).click
end

Then(/^a \#\# is added in front of input string in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.diff_view.include? "## This "
    end
    page.diff_view.should match Regexp.new(/^\#\# This is a new line/)
  end
end

Then(/^a \*\* is added in front of input string in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.diff_view.include? "** This "
    end
    page.diff_view.should match Regexp.new(/^\*\* This is a new line/)
  end
end


When(/^I click Decrease indentation$/) do
  on(VisualEditorPage).decrease_indentation_on_element.when_present(15).click
end

Then(/^nothing is added in front of input string in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.diff_view.include? "This "
    end
    page.diff_view.should match Regexp.new(/^This is a new line/)
  end
end

Then(/^Decrease indentation should be disabled$/) do
  on(VisualEditorPage).decrease_indentation_element.should be_visible
end

Then(/^Increase indentation should be disabled$/) do
  on(VisualEditorPage).increase_indentation_element.should be_visible
end


Then(/^Decrease indentation should be enabled$/) do
  on(VisualEditorPage).decrease_indentation_on_element.class_name.should_not match /disabled/
end

Then(/^Increase indentation should be enabled$/) do
  on(VisualEditorPage).increase_indentation_on_element.class_name.should_not match /disabled/
end

When(/^I undo Bullets$/) do
   on(VisualEditorPage).ve_bullets_element.when_present(15).click
end

When(/^I undo Numbering$/) do
  on(VisualEditorPage).ve_numbering_element.when_present(15).click
end
