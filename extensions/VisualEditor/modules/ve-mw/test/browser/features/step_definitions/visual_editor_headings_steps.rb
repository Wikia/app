When(/^I click the down arrow on Headings interface$/) do
  on(VisualEditorPage).downarrow_element.when_present.click
end

When(/^I click Paragraph$/) do
  on(VisualEditorPage).paragraph_element.when_present.click
end

Then(/^a paragraph should appear in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.paragraph_diff_view.include? 'Editing '
    end
    page.paragraph_diff_view.should match Regexp.escape('Editing with ')
  end
end

Then(/^I should be able to click the up arrow on the save box$/) do
  on(VisualEditorPage).uparrow_element.when_present.click
end

When(/^I click Heading$/) do
  on(VisualEditorPage).heading_element.when_present.click
end

Then(/^a heading should appear in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.heading_diff_view.include? '==Editing '
    end
    page.heading_diff_view.should match Regexp.escape('==Editing with ')
  end
end

When(/^I click Sub\-Heading1$/) do
  on(VisualEditorPage).subheading1_element.when_present.click
end

Then(/^a sub\-heading1 should appear in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.heading_diff_view.include? '===Editing '
    end
    page.heading_diff_view.should match Regexp.escape('===Editing with ')
  end
end

When(/^I click Sub\-Heading2$/) do
  on(VisualEditorPage).subheading2_element.when_present.click
end

Then(/^a sub\-heading2 should appear in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
     page.heading_diff_view.include? '====Editing '
    end
    page.heading_diff_view.should match Regexp.escape('====Editing with ')
  end
end

When(/^I click Sub\-Heading3$/) do
  on(VisualEditorPage).subheading3_element.when_present.click
end

Then(/^a sub\-heading3 should appear in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.heading_diff_view.include? '=====Editing '
    end
    page.heading_diff_view.should match Regexp.escape('=====Editing with ')
  end
end

When(/^I click Sub\-Heading4$/) do
  on(VisualEditorPage).subheading4_element.when_present.click
end

Then(/^a sub\-heading4 should appear in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.heading_diff_view.include? '======Editing '
    end
    page.heading_diff_view.should match Regexp.escape('======Editing with ')
  end
end

When(/^I click Preformatted$/) do
  on(VisualEditorPage).preformatted_element.when_present.click
end

Then(/^a Preformatted should appear in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.heading_diff_view.include? ' Editing '
    end
    page.heading_diff_view.should match Regexp.escape(' Editing with ')
  end
end

 When(/^I click Page title$/) do
  on(VisualEditorPage).page_title_element.when_present.click
end

Then(/^a Page title should appear in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.heading_diff_view.include? '=Editing '
    end
    page.heading_diff_view.should match Regexp.escape('=Editing with ')
  end
end
