<?php
    /*
		Title Function That Echo The Page Title In Case The Page Has The Variable $pageTitle And Echo Default Title For Other Pages
	*/
	function getTitle()
	{
		global $pageTitle;
		if(isset($pageTitle))
			echo $pageTitle." | AL AIN IT CONSULTANT -  ";
		else
			echo "AL AIN IT CONSULTANT - ";
	}

	/*
		This function returns the number of items in a given table
	*/

    function countItems($item, $table)
{
    global $dbconn;
    try {
      $stat_ = $dbconn->prepare("SELECT COUNT($item) FROM $table"); 
        $stat_->execute();
        return $stat_->fetchColumn();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

function checkItem($select, $from, $value)
{
    global $dbconn;
    try {
        $statment = $conn->prepare("SELECT $select FROM $from WHERE $select = ? ");
        $statment->execute(array($value));
        $count = $statment->rowCount();
        return $count;
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}


  	/*
    	==============================================
    	TEST INPUT FUNCTION, IS USED FOR SANITIZING USER INPUTS
    	AND REMOVE SUSPICIOUS CHARS and Remove Extra Spaces
    	==============================================
	
	*/

  	function test_input($data) 
  	{
      	$data = trim($data);
      	$data = stripslashes($data);
      	$data = htmlspecialchars($data);
      	return $data;
  	}

?>

