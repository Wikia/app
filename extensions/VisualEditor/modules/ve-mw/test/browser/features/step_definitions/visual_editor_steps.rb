Given(/^I am at my user page$/) do
  visit(VisualEditorPage)
end

When(/^I click Review and Save$/) do
  on(VisualEditorPage) do |page|
    page.container_disabled_element.when_not_visible.should_not exist
    page.review_and_save_element.when_visible.click
  end
end

When(/^I click Looks good to me$/) do
  on(VisualEditorPage) do |page|
    page.diff_view_element.when_visible.should be_visible
    page.looks_good_element.click
  end
end

When(/^I click This is a minor edit$/) do
  on(VisualEditorPage).minor_edit_element.when_present.click
end

When(/^I click Save page$/) do
  on(VisualEditorPage) do |page|
    sleep 2 # blame Chris for this!
    page.save_page_element.when_present.click
  end
end

When(/^I click Save page the second time$/) do
    on(VisualEditorPage).second_save_page_element.when_present.click
end

When(/^I do not see This is a minor edit$/) do
  on(VisualEditorPage).minor_edit_element.should_not be_visible
end

When(/^I edit the page with a string$/) do
  on(VisualEditorPage) do |page|
    page.edit_ve_element.when_present.click
    #This begin/rescue clause dismisses the VE warning message when it exists, and does not fail when it does not exist
    begin
      page.beta_warning_element.when_present.click
    rescue
    end
    page.content_element.fire_event('onfocus')
    page.content_element.when_present.send_keys("Editing with #{@does_not_exist_page_name}")
  end
end

When(/^I click Return to save form$/) do
  on(VisualEditorPage) do |page|
    page.diff_view_element.when_present
    page.return_to_save_element.when_present.click
  end
end

When(/^I click Review your changes$/) do
  on(VisualEditorPage).review_changes_element.when_present.click
end

When(/^I edit the description of the change$/) do
  on(VisualEditorPage).describe_change_element.when_visible.send_keys("Describing with #{@does_not_exist_page_name}")
end

When(/^I see the IP warning signs$/) do
  on(VisualEditorPage).ip_warning.should match Regexp.escape("Your IP address")
end

Then(/^Page text should contain the string$/) do
  on(VisualEditorPage).page_text_element.when_present.text.should match Regexp.escape("Editing with #{@does_not_exist_page_name}")
end
