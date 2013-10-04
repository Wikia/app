@ie6-bug  @ie7-bug  @ie8-bug  @ie9-bug @ie10-bug @test2.wikipedia.org @login
Feature: VisualEditor Indent, Outdent

@make_selectable_line
 Scenario: Check indentation controls disabled by default
    Then Decrease indentation should be disabled
      And Increase indentation should be disabled

@make_selectable_line
  Scenario Outline: check indent and outdent enable and disable
    When I click <control>
    Then Decrease indentation should be <initial_state>
      And Increase indentation should be <initial_state>
      And I undo <control>
      And Decrease indentation should be <final_state>
      And Increase indentation should be <final_state>
  Examples:
    | control   | initial_state | final_state |
    | Bullets   | enabled       | disabled    |
    | Numbering | enabled       | disabled    |
