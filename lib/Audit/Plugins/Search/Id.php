<?php

/**
* @author Tim Rupp
*/
class Audit_Plugins_Search_Id {
	/**
	*
	*/
	const IDENT = __CLASS__;

	/**
	* @throws Audit_Plugins_Search_Exception
	* @return array
	*/
	public function search($query, $page = 1, $limit = 15) {
		$config = Ini_Config::getInstance();
		$log = App_Log::getInstance(self::IDENT);
		$db = App_Db::getInstance($config->database->plugin);
		$fuzzy = false;
		$testQuery = str_replace('*','',$query);

		if (!is_numeric($testQuery)) {
			throw new Audit_Plugins_Search_Exception('The specified ID is not a number');
		}

		if (substr($query, 0, 1) == '*') {
			$query = '%' . substr($query, 1);
			$fuzzy = true;
		}

		if (substr($query, -1) == '*') {
			$query = substr($query, 0, -1) . '%';
			$fuzzy = true;
		}

		$sql = $db->select()
			->from('plugins')
			->order(array(
				'id ASC'
			)
		);

		if (!empty($limit)) {
			$sql->limitPage($page, $limit);
		}

		try {
			if ($fuzzy === true) {
				$sql->where(sprintf('%s::text LIKE %s',
					$db->quoteIdentifier('id'),
					$db->quote($query))
				);
			} else {
				$sql->where(sprintf('%s = %s',
					$db->quoteIdentifier('id'),
					$db->quote($query))
				);
			}

			$log->debug($sql->__toString());
			$stmt = $sql->query();
			return $stmt->fetchAll();
		} catch (Exception $error) {
			throw new Audit_Plugins_Search_Exception($error->getMessage());
		}
	}

	/**
	* @throws Audit_Plugins_Search_Exception
	* @return array
	*/
	public function families($query, $page = 1, $limit = 15) {
		$config = Ini_Config::getInstance();
		$log = App_Log::getInstance(self::IDENT);
		$db = App_Db::getInstance($config->database->plugin);
		$fuzzy = false;
		$testQuery = str_replace('*','',$query);

		if (!is_numeric($testQuery)) {
			throw new Audit_Plugins_Search_Exception('The specified ID is not a number');
		}

		if (substr($query, 0, 1) == '*') {
			$query = '%' . substr($query, 1);
			$fuzzy = true;
		}

		if (substr($query, -1) == '*') {
			$query = substr($query, 0, -1) . '%';
			$fuzzy = true;
		}

		$sql = $db->select()
			->from(array('p' => 'plugins'),
				array(
					'id' => 'family', 
					'count' => sprintf('COUNT(%s)', 
						$db->quoteIdentifier('family')
					)
				)
			)
			->group('family');

		if (!empty($limit)) {
			$sql->limitPage($page, $limit);
		}

		try {
			if ($fuzzy === true) {
				$sql->where(sprintf('%s::text LIKE %s',
					$db->quoteIdentifier('id'),
					$db->quote($query))
				);
			} else {
				$sql->where(sprintf('%s = %s',
					$db->quoteIdentifier('id'),
					$db->quote($query))
				);
			}

			$log->debug($sql->__toString());
			$stmt = $sql->query();
			return $stmt->fetchAll();
		} catch (Exception $error) {
			throw new Audit_Plugins_Search_Exception($error->getMessage());
		}
	}

	/**
	* @throws Audit_Plugins_Search_Exception
	* @return array
	*/
	public function categories($query, $page = 1, $limit = 15) {
		$config = Ini_Config::getInstance();
		$log = App_Log::getInstance(self::IDENT);
		$db = App_Db::getInstance($config->database->plugin);
		$fuzzy = false;
		$testQuery = str_replace('*','',$query);

		if (!is_numeric($testQuery)) {
			throw new Audit_Plugins_Search_Exception('The specified ID is not a number');
		}

		if (substr($query, 0, 1) == '*') {
			$query = '%' . substr($query, 1);
			$fuzzy = true;
		}

		if (substr($query, -1) == '*') {
			$query = substr($query, 0, -1) . '%';
			$fuzzy = true;
		}

		$sql = $db->select()
			->from(array('p' => 'plugins'),
				array(
					'id' => 'category', 
					'count' => sprintf('COUNT(%s)', 
						$db->quoteIdentifier('category')
					)
				)
			)
			->group('category');

		if (!empty($limit)) {
			$sql->limitPage($page, $limit);
		}

		try {
			if ($fuzzy === true) {
				$sql->where(sprintf('%s::text LIKE %s',
					$db->quoteIdentifier('id'),
					$db->quote($query))
				);
			} else {
				$sql->where(sprintf('%s = %s',
					$db->quoteIdentifier('id'),
					$db->quote($query))
				);
			}

			$log->debug($sql->__toString());
			$stmt = $sql->query();
			return $stmt->fetchAll();
		} catch (Exception $error) {
			throw new Audit_Plugins_Search_Exception($error->getMessage());
		}
	}
}

?>
