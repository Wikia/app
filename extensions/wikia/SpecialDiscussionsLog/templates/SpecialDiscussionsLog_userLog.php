{{#userErrorMessage}}
	<p>{{userErrorMessage}}</p>
{{/userErrorMessage}}
{{^userErrorMessage}}
	{{#noUserLogRecords}}
		<p>No mobile app activity by {{userName}} in the past two weeks!</p>
	{{/noUserLogRecords}}
	{{^noUserLogRecords}}
		<p>Log data for user {{userName}} (ID: {{userId}})</p>
		<table>
			<thead>
			<tr>
				<th style="padding-right:8px">IP Address</th>
				<th style="padding-right:8px">Location</th>
				<th style="padding-right:8px">Language</th>
				<th style="padding-right:8px">User Agent</th>
				<th style="padding-right:8px">App</th>
				<th style="padding-right:8px">Timestamp</th>
			</tr>
			</thead>
			{{#userLogRecords}}
				<tr>
					<td style=\"padding-right:8px\">{{ip}}</td>
					<td style=\"padding-right:8px\">{{location}}</td>
					<td style=\"padding-right:8px\">{{language}}</td>
					<td style=\"padding-right:8px\">{{userAgent}}</td>
					<td style=\"padding-right:8px\">{{app}}</td>
					<td style=\"padding-right:8px\">{{timestamp}}</td>
				</tr>
			{{/userLogRecords}}
		</table>
	{{/noUserLogRecords}}
{{/userErrorMessage}}