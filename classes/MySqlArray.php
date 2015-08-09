<?php

class MySqlArrayBasic {

	private $qvar; //Query string variable
	private $numrows;
	private $numcols;
	private $colname = array();
	private $tableArray = array(); //2-dimensional array containing query output


	public function __construct($qvar) { //constructor takes query string as a parameter
		include ("/home/ubuntu/workspace/db_connect.php"); //contains $conn - Oracle connection info
		$this->qvar = $qvar;

		$sql = $mysqli->query($this->qvar);

		$this->numcols = mysqli_num_fields($sql);

		$this->colname = mysqli_fetch_fields($sql);

		$this->numrows = mysqli_num_rows($sql);

		while($row = mysqli_fetch_assoc($sql))
	    {
	        $this->tableArray[] = $row;
	    }

		$sql->close();

	}

	public function getRows(){
		return $this->numrows;
	}

	//NEEDS TESTING - NOT WORKING
	public function getCols(){
		return $this->numcols;
	}

	//NEEDS TESTING - NOT WORKING
	public function getColName(){
		return $this->colname;

	//getColName use example
	/*
		$colname = $supplies->getColName();

		foreach($colname as $col){
			echo $col->name;
		}
	*/
	}

	public function getArray(){ //get 2d array
		return $this->tableArray;
	}

	//alternative way to loop through 2d array rather than using createTable()
	/*
	for($i = 0; $i < $this->numrows; $i++){
		echo "<tr>\n";
		//for($j = 0; $j < $this->numcols; $j++){
			echo "<td>" . $this->tableArray[$i][$j] . "</td>\n";
		}
		echo "</tr>\n";
	}*/

	public function createTable(){
		echo "<table>\n";
		echo "<thead>\n";

		foreach($this->colname as $val){
			echo "<th>" . $val->name . "</th>\n";
		}

		echo "</thead>\n";
		echo "<tbody>\n";

		foreach($this->tableArray as $col){
			echo "<tr>\n";
			foreach($col as $item){
				echo "<td>" . $item . "</td>\n";
			}
			echo "</tr>\n";
		}
		echo "</tbody>";
		echo "</table>\n";
	}

}

?>