When(/^I click the Link button$/) do
  sleep 1 #Chrome seems to not honor when_present correctly as of 5 Dec 2013
  on(VisualEditorPage).ve_link_icon_element.when_present.click
end

Given(/^I can see the Link User Inteface$/) do
  on(VisualEditorPage) do |page|
    page.ve_link_ui_element.when_present
    page.ve_link_ui.should match Regexp.escape("Link")
  end
end

When(/^I click the blue text$/) do
  on(VisualEditorPage).linksuggestion_element.when_present.click
end

When(/^I click < to close Link User Interface$/) do
  on(VisualEditorPage).leftarrowclose_element.when_present.click
end

Then(/^an external link appears in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.links_diff_view.include? "example.com"
    end
    page.links_diff_view.should match Regexp.escape("[http://www.example.com Links]")
  end
end

When(/^I click the blue text for Matching Page$/) do
  on(VisualEditorPage).internal_linksuggestion_element.when_present.click
end

Then(/^an internal link appears in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.links_diff_view.include? "Main Page"
    end
    page.links_diff_view.should match Regexp.escape("[[Main Page|Links]]")
  end
end

When(/^I click the blue text for New Page$/) do
  on(VisualEditorPage).newpage_linksuggestion_element.when_present.click
end

Then(/^a non\-existing link appears in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.links_diff_view.include? "DoesNotExist"
    end
    page.links_diff_view.should match Regexp.escape("[[DoesNotExist|Links]]")
  end
end

When(/^I enter (.+) into link Content box$/) do |content|
  on(VisualEditorPage) do |page|
    page.link_textfield_element.when_present
    page.link_textfield_element.send_keys(content)
  end
end

When(/^I click Links Review your changes$/) do
  on(VisualEditorPage).links_review_changes_element.when_present.click
end

