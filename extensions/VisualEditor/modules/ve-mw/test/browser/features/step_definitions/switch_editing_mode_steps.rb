When(/^I clear the confirm dialog$/) do
  on(VisualEditorPage).confirm_switch_element.when_present.click
end

When(/^I enter the wikitext editor$/) do
  on(VisualEditorPage) do |page|
    page.edit_wikitext_element.when_present.click
    page.wikitext_editor_element.when_present
  end
end

When(/^I click the Switch to source editing menu option$/) do
  on(VisualEditorPage) do |page|
    page.alert do
      page.tools_menu_element.when_present.click
      page.switch_to_source_editing_element.when_present.click
    end
  end
end

When(/^I click Edit for VisualEditor from this page$/) do
  on(VisualEditorPage) do |page|
    page.alert do
      page.edit_ve_element.when_present.click
    end
  end
end

When(/^I see the wikitext editor$/) do
  on(VisualEditorPage).wikitext_editor_element.when_present(10).should be_visible
end

Then(/^I should be in wikitext editing mode$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(15) do
      page.text.include? "Editing Edit page for"
    end
  end
  @browser.url.should eql(ENV['MEDIAWIKI_URL'] + "Edit page for " + ENV['BROWSER'] + "?action=submit")
end

Then(/^I should be in Visual Editor editing mode$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(15) do
      page.text.include? "Edit page for"
    end
  end
  expected_url = /w\/index\.php\?title=Edit_page_for_#{ENV['BROWSER']}&veaction=edit/
  @browser.url.should match Regexp.new(expected_url)
end

Then(/^I should be in Visual Editor editing alternate mode$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(15) do
      page.text.include? "Edit page for"
    end
    page.content_element.when_present.should be_visible
  end
end
