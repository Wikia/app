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
      page.text.include? "Editing User:"
    end
  end
  @browser.url.should eql(ENV['MEDIAWIKI_URL'] + "User:" + ENV['MEDIAWIKI_USER'] + "?action=submit")
end

Then(/^I should be in Visual Editor editing mode$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(15) do
      page.text.include? "User:"
    end
  end
  expected_url = /w\/index\.php\?title=User:(.+)&veaction=edit/
  @browser.url.should match Regexp.new(expected_url)
end

Then(/^I should be in Visual Editor editing alternate mode$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(15) do
      page.text.include? "User:"
    end
    page.content_element.when_present.should be_visible
  end
end
