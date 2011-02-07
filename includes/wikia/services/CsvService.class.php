<?php

	class CsvService extends Service {

		public function output( $headers, $data ) {
			// XXX: add headers to content-type: csv

			$fp = fopen('php://temp', 'r+');
			fputcsv($fp, $headers, $delimiter, $enclosure);
			foreach ($data as $row) {
				fputcsv($fp, $headers, $delimiter, $enclosure);
			}
			rewind($fp);
			$csv = fgets($fp);

			echo $csv;

			return true;
		}

	}