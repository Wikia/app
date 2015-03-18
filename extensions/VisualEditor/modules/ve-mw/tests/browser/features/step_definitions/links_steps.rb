Given(/^I can see the Link User Inteface$/) do
  on(VisualEditorPage).ve_link_ui_element.when_present
end

When(/^I click Done to close Link User Interface$/) do
  on(VisualEditorPage).links_done_element.when_present.click
end

When(/^I click the Link button$/) do
  on(VisualEditorPage).ve_link_icon_element.when_present.click
end

When(/^I enter external link (.+) into link Content box$/) do |link_content|
  on(VisualEditorPage) do |page|
    page.link_textfield_element.when_present
    page.link_textfield_element.send_keys(link_content)
    page.link_overlay_external_link_element.when_present
  end
end

When(/^I enter internal link (.+) into link Content box$/) do |link_content|
  on(VisualEditorPage) do |page|
    page.link_textfield_element.when_present
    page.link_textfield_element.send_keys(link_content)
    page.link_overlay_wiki_page_element.when_present
  end
end

When(/^I enter non existing link (.+) into link Content box$/) do |link_content|
  on(VisualEditorPage) do |page|
    page.link_textfield_element.when_present
    page.link_textfield_element.send_keys(link_content)
    page.link_overlay_does_not_exist_element.when_present
  end
end

Then(/^a non\-existing link appears in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.diff_view.include? 'DoesNotExist'
    end
    expect(page.diff_view).to match '[[DoesNotExist|Links]]'
  end
end

Then(/^an external link appears in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.diff_view.include? 'example.com'
    end
    expect(page.diff_view).to match '[http://www.example.com Links]'
  end
end

Then(/^an internal link appears in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.diff_view.include? 'Main Page'
    end
    expect(page.diff_view).to match '[[Main Page|Links]]'
  end
end
