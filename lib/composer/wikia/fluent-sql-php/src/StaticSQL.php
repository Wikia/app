<?php
namespace FluentSql;

class StaticSQL {
	private static $class = "FluentSql\\SQL";

	/**
	 * @return SQL
	 */
	private static function getSql() {
		return new self::$class();
	}

	public static function setClass($class) {
		self::$class = $class;
	}

	public static function WITH($name, SQL $sql){
		return self::getSql()->WITH($name, $sql);
	}

	public static function WITH_RECURSIVE($name, SQL $sql){
		return self::getSql()->WITH_RECURSIVE($name, $sql);
	}

	/**
	 * @return SQL
	 */
	public static function SELECT(/*...*/){
		return call_user_func_array([self::getSql(), 'SELECT'], func_get_args());
	}

	public static function SELECT_ALL(){
		return self::getSql()->SELECT_ALL();
	}

	public static function COUNT($sql){
		return self::getSql()->COUNT($sql);
	}

	public static function MIN($sql){
		return self::getSql()->MIN($sql);
	}

	public static function MAX($sql){
		return self::getSql()->MAX($sql);
	}

	public static function SUM($sql){
		return self::getSql()->SUM($sql);
	}
	public static function AVG($sql){
		return self::getSql()->AVG($sql);
	}

	public static function LOWER($sql){
		return self::getSql()->LOWER($sql);
	}

	public static function UPPER($sql){
		return self::getSql()->UPPER($sql);
	}

	/**
	 * @return SQL
	 */
	public static function NOW() {
		return self::getSql()->NOW();
	}

	/**
	 * @return SQL
	 */
	public static function CURDATE() {
		return self::getSql()->CURDATE();
	}

	/**
	 * @return SQL
	 */
	public static function CASE_() {
		return self::getSql()->CASE_();
	}

	public static function RAW($sql, $params=[]) {
		return self::getSql()->RAW($sql, $params);
	}
}