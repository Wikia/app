@ie6-bug  @ie7-bug  @ie8-bug  @ie9-bug @ie10-bug @test2.wikipedia.org @en.wikipedia.beta.wmflabs.org @login
Feature: VisualEditor Headings

  @edit_user_page
  Scenario Outline: Cycle through headings values
    When I click the down arrow on Headings interface
      And I click <headings_interface_name>
      And I click Save page
      And I click Review your changes
    Then <headings_string> should appear in the diff view
      And I can click the up arrow on the save box
  Examples:
    | headings_interface_name | headings_string  |
    | Paragraph               | '^Editing'       |
    | Heading                 | '^==Editing'     |
    | Subheading1             | '^===Editing'    |
    | Subheading2             | '^====Editing'   |
    | Subheading3             | '^=====Editing'  |
    | Subheading4             | '^======Editing' |
    | Preformatted            | ' Editing'       |
    | Page title              | '^=Editing'      |
