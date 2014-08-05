<?php

class MetaCSVService extends UploadFromFile {
	const CSV_MAX_LINE_LEN = 4096;
	const CSV_DELIMITER = ";";
	const CSV_QUOTE = '"';
	const FORM_FILE = 'meta';
	const FIELD_TITLE = 'title';

	protected $availFields = [ self::FIELD_TITLE, 'fingerprints', 'quest_id','ability_id', 'map_region' ];
	protected $arrayFields = [ 'fingerprints' ];
	protected $inputFile;



	public function LoadDataFromFile( $f ) {
		if ( !file_exists( $f ) || !is_readable( $f ) ) {
			throw new MetaException( "Unable to load file" );
		}
		$fp = fopen( $f, 'r' );
		$out = [ ];
		while ( $data = fgetcsv( $fp, self::CSV_MAX_LINE_LEN, self::CSV_DELIMITER, self::CSV_QUOTE ) ) {
			$row = [ ];
			foreach ( $this->availFields as $key => $field ) {
				$value = $data[ $key ];
				if( in_array( $field, $this->arrayFields ) ){
					$value = explode( ',', $value );
				}
				$row[ $field ] = $value;
			}
			$title = $row[ self::FIELD_TITLE ];
			unset( $row[ self::FIELD_TITLE ] );
			$out[ $title ] = $row;
		}
		return $out;
	}

	public function getUploadedFileFromRequest() {
		if(!isset( $_FILES[ self::FORM_FILE ])){
			return false;
		}
		if ( $_FILES[ self::FORM_FILE ][ "size" ] == 0 || !$_FILES[ self::FORM_FILE ][ 'name' ] ) {
			throw new MetaException( "Uploaded file is empty" );
		}
		if ( $_FILES[ self::FORM_FILE ][ "error" ] > 0 ) {
			throw new MetaException( "Upload file error" );
		}

		return $_FILES[ self::FORM_FILE ][ "tmp_name" ];
	}

	public function storeMetaInDb($data){
		$errors = [];
		foreach($data as $title => $meta){
			$errors[$title] = 'OK';
			try{
				$model = ArticleMetadataModel::newFromString($title);
				foreach($meta as $field => $val){
					$model->setField($field, $val);
				}
				$model->save( true );
			}catch(TitleNotFoundException $e){
				$errors[$title] = 'Title not found';
			}catch(FieldNotArrayException $e){
				$errors[$title] = 'Field should not be an array: '. $e->getMessage();
			}catch(NotValidPOIMetadataFieldException $e){
				$errors[$title] = 'Unknown field: '. $e->getMessage();
			}
		}
		return $errors;
	}

	public function generateOutputCsv($data,$errors){
		$file = fopen("php://memory", "w+");
		foreach($data as $title=>$fields){
			$out = [];
			$fields[self::FIELD_TITLE] = $title;
			foreach($this->availFields as $key){
				$val = isset($fields[$key]) ? $fields[$key] : "";
				if(is_array($val)){
					$val = implode(',', $val);
				}
				$out[] = $val;
			}
			$out[] = $errors[$title];
			fputcsv($file,$out,self::CSV_DELIMITER,self::CSV_QUOTE);
		}
		fseek($file,0);
		$csv = '';
		while($chunk = fread($file,1024)){
			$csv.=$chunk;
		}

		fclose($file);
		return $csv;
	}

}

class MetaException extends WikiaException {
}