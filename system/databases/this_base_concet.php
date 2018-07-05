<?php
class This_base_concet
{
	private $link;
	public function __construct()
	{
		$this->link = mysql_connect(SERVER,USERNAME,PASSWORD) or exit('数据库连接错误');
		mysql_select_db(BASENAME) or exit('没有找到指定的数据库名称');
		mysql_query('set names utf8');
	}
	/**
	 * 执行sql语句,添、删、改、查
	 * @param string $sql
	 * @return 添、删、改=boolean
	 * @return 查=resource
	 */
	public function query($sql)
	{
		$resource = mysql_query($this->get_sql($sql)) or exit('sql语法错误 '.mysql_errno()."  <br/>\n\n  ".mysql_error()." <br/>\n\n ".$sql);
		return $resource;
	}
	/**
	 * 获取总记录数
	 * @param string $sql
	 * @return number
	 */
	public function counts($sql)
	{
		$resource = $this->query($this->get_sql($sql));
		$counts = mysql_num_rows($resource);
		return $counts;
	}
	/**
	 * 获取单条记录
	 * @param string $sql
	 * @return array
	 */
	public function row($sql)
	{
		$resource = $this->query($this->get_sql($sql));
		$row = mysql_fetch_assoc($resource);
		return $row;
	}
	/**
	 * 获取多条记录
	 * @param string $sql
	 * @return array
	 */
	public function rows($sql)
	{
		$resource = $this->query($this->get_sql($sql));
		$rows = array();
		while($row = mysql_fetch_assoc($resource))
		{
			$rows[] = $row; 
		}
		return $rows;
	}
	/**
	 * 获取最新记录的ID号
	 * @return int
	 */
	public function insert_id()
	{
		$id = mysql_insert_id();
		return $id;
	}
	/**
	 * 获取sql语句
	 * @param string $sql
	 * @return string
	 */
	public function get_sql($sql)
	{
		return $sql;
	}
	/**
	 * 关闭链接
	 */
	public function close()
	{
		mysql_close($this->link);
	}
	public function __destruct()
	{
		$this->close();
	}
}