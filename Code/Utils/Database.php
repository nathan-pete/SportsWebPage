<?php
	function connectDatabase(): bool|mysqli
	{
		require __DIR__ . "/credentials.php";
		if ($DB = mysqli_connect($host, $user, $pass, $database)) {
			return $DB;
		}
		return FALSE;
	}
	
	function prepareStatement($DB, $sqlStatement): bool|mysqli_stmt
	{
		if ($sqlPrepared = mysqli_prepare($DB, $sqlStatement)) {
			return $sqlPrepared;
		}
		return FALSE;
	}
	
	function prepareAndConnect($sqlStatement): bool|array
	{
		if ($DB = connectDatabase()) {
			if ($sqlGood = prepareStatement($DB, $sqlStatement)) {
				// If everything is ok return the prepared sql query
				return [$sqlGood, $DB];
			}
			// If failed to prepare the statement close connection to the database
			closeConnection($DB);
		}
		
		// If a check above is not working return FALSE
		return FALSE;
	}
	
	function closeConnection($DB = NULL, $sql = NULL)
	{
		// In case the connection went wrong the script will not throw an error
		if ($sql != NULL) {
			mysqli_stmt_close($sql);
		}
		if ($DB != NULL) {
			mysqli_close($DB);
		}
	}
?>
