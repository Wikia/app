When(/^I click the Link button$/) do
  on(VisualEditorPage).ve_link_icon_element.when_present.click
end

Given(/^I can see the Link User Inteface$/) do
 on(VisualEditorPage).ve_link_ui.should match Regexp.escape('Hyperlink')
end

When(/^I click the blue text$/) do
  on(VisualEditorPage).linksuggestion_element.when_present.click
end

When(/^I click < to close Link User Interface$/) do
  on(VisualEditorPage).leftarrowclose
end

Then(/^an external link appears in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.diff_view.include? 'example.com'
    end
    page.diff_view.should match Regexp.escape('[http://www.example.com Editing] ')
  end
end

When(/^I click the blue text for Matching Page$/) do
  on(VisualEditorPage).internal_linksuggestion_element.when_present.click
end

Then(/^an internal link appears in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.internal_diff_view.include? 'Main Page'
    end
    page.internal_diff_view.should match Regexp.escape('[[Main Page|Editing]]')
  end
end

When(/^I click the blue text for New Page$/) do
  on(VisualEditorPage).newpage_linksuggestion_element.when_present.click
end

Then(/^a non\-existing link appears in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.internal_diff_view.include? 'DoesNotExist'
    end
    page.internal_diff_view.should match Regexp.escape('[[DoesNotExist|Editing]]')
  end
end

When(/^I enter (.+) into link Content box$/) do |content|
  on(VisualEditorPage) do |page|
    page.link_textfield_element.when_present
    page.link_textfield_element.send_keys(content)
  end
end
