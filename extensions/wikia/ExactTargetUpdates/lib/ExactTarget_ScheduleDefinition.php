<?php
class ExactTarget_ScheduleDefinition {
	public $Name; // string
	public $Description; // string
	public $Recurrence; // ExactTarget_Recurrence
	public $RecurrenceType; // ExactTarget_RecurrenceTypeEnum
	public $RecurrenceRangeType; // ExactTarget_RecurrenceRangeTypeEnum
	public $StartDateTime; // dateTime
	public $EndDateTime; // dateTime
	public $Occurrences; // int
	public $Keyword; // string
}
