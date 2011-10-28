<?php

	class CsvService extends Service {

		protected $delimiter = ',';
		protected $enclosure = '"';

		public function setDelimiter( $delimiter ) {
			$this->delimiter = $delimiter;
		}

		public function setEnclosure( $enclosure ) {
			$this->enclosure = $enclosure;
		}

		public function printHeaders( $fileName ) {
			// http headers
			header("Pragma: private");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Content-Type: application/octet-stream; charset=utf-8");
			header("Content-Disposition: attachment;filename=".str_replace(" ", "_", $fileName));

			global $wgOut;
			$wgOut->setArticleBodyOnly(true);
		}

		public function printRow( $row ) {
			return $this->printRows(array($row));
		}

		public function printRows( $rows ) {
			$fp = fopen('php://temp', 'br+');
			foreach ($rows as $row) {
				fputcsv($fp, $row, $this->delimiter, $this->enclosure);
			}
			rewind($fp);
			fpassthru($fp);
			fclose($fp);

			return true;
		}

	}