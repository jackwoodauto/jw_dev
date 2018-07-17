<?php
class database {

	private $conn, $stmt, $arr, $eof=true, $error, $inserted_id=-1;


    public function __construct() {
        $this->conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DB);
        if(mysqli_connect_errno()) $this->error = mysqli_connect_error();
    }

    public function __destruct() {
        if($this->stmt) mysqli_stmt_close($this->stmt);
        mysqli_close($this->conn);

    }

    /** Executes a prepared SQL query on the database
      *
      * The second argument (optional) is the types list, followed by the parameters
      * e.g. query('SELECT * FROM table WHERE id = ? OR name = ?', 'is', 5, 'Joe')
      *
      * @param string $query is the sql statement to execute
      * @return mixed false on error,
      *               true on successful select, or
      *               the number of affected rows
      */
    public function query($query,$args=array()) {
        // create a new prepared statement
        $stmt = mysqli_prepare($this->conn, $query);
        if(!$stmt) {
            $this->error = mysqli_error($this->conn);
            return false;
        }

        // apply the arguments if any exist
		// e.g. $args = array("ss","string_1","string_2");
        if(count($args)>0) {

            //$args = array_slice(func_get_args(), 1);
            $refs = array();
            foreach($args as $key=>&$value) $refs[$key] = &$value;
			call_user_func_array(array($stmt, 'bind_param'), $refs);
        }
        // run the query
        $stmt->execute();
        if($stmt->errno) {
            $this->error = mysqli_error($this->conn);
            return false;
        }

        // if the query was not a select, return the number of rows affected
        if($stmt->affected_rows > -1) {
            $rows = $stmt->affected_rows;
			$this->inserted_id = $stmt->insert_id;
            mysqli_stmt_close($stmt);
            return $rows;
        }

        // close any previous statement
        if($this->stmt) mysqli_stmt_close($this->stmt);
        $this->stmt = $stmt;
        $this->eof = false;

        // bind the results to the associative array
        $this->arr = array();
        $refs = array();
        $meta = mysqli_stmt_result_metadata($stmt);
        while($column = mysqli_fetch_field($meta)) {
            $refs[] = &$this->arr[str_replace(' ', '_', $column->name)];
        }
        call_user_func_array(array($stmt, 'bind_result'), $refs);

        // make the first result set available
        $this->next();
        return true;
    }

    // fetches the next row
    public function next() {
        if($this->stmt) {
            $ret = mysqli_stmt_fetch($this->stmt); // populates $this->arr
            $this->eof = ($ret !== true);
            if($ret === false) $this->error = mysqli_error($this->conn);

        }
    }

    // returns an associative array of the results
    public function results() {
        // must make a copy when returning the entire array because
        // the array holds references that may be updated
        $ret = array();
        foreach($this->arr as $key=>$value) $ret[$key] = $value;
        return $ret;
    }

	public function all(){

		$results = array();
		while($this->eof() !== true){

			$results[] = $this->results();
			$this->next();

		}

		return $results;
	}

	public function get_insert_id(){

		return $this->inserted_id;

	}

    // return the value for the specified field
    public function result($field) { return $this->arr[$field]; }
    public function __get($field) { return $this->result($field); }

    // returns true if eof has occured or an error
    public function eof() { return $this->eof; }

    // returns the number of rows in the result set
    public function count() { return ($this->stmt ? $this->stmt->num_rows : 0); }

    // returns the last error message, if clear is true, clears the error as well
    public function error($clear=false) {
        $err = $this->error;
        if($clear) $this->error = '';
        return $err;
    }













// function to run all sql statments
  // inputs :  $cmd = insert,delete,update,select / $table_name = "name_of_table" / $whereLocation = "column of the where statement" / $whereValue = "the value input into the where command $whereOperator = should be = < > or some type of sql operator / $fields = should be a array of the columns your about to use / $values = should be a array of the values your about to use / $valueTypes = should be a string of letters representing your value array e.g. "sssi" s for string i for interger    "
  // process: do the sql command that the input sets up
  // in detail process: the first
  // outputs : should output if it is successful or if it failed as well as a error message if it did
  public function execute_sql($cmd,$table_name,$whereLocation,$whereValue,$whereOperator,$fields,$values,$valueTypes){

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
       if(empty($cmd) ||						//error checking to see if anything is empty
       empty($table_name) ||
       empty($whereLocation) ||
       empty($whereValue) ||
       empty($whereOperator) ||
       empty($fields) ||
       empty($values) ||
       empty($valueTypes))
    {
        $errors .= "\n Error: all fields are required if your not using one of them just set it to 1 or something that is not blank. For example you will not use the where variables in a insert command ";	//setting up the error string
        return $error;				//returning the error string
    }

    $fieStr = implode(", ",$fields);			// turns the array into a string with , seperating the values
    $value_question_marks = "";							//setting up the value question mark variable
    foreach ($values as $key => $value) {		//making a for each loop that runs  for as many inputs as there are to set up the question marks
      $value_question_marks .= " ?,";					// sppending on to the $value question mark string another ?,
    }
    $value_question_marks = substr($value_question_marks, "0", -1); 	// removing the last comma from the $value_question_marks string,
    $args = array($valueTypes);																									//setting up the argument array with only the value types
    $args = array_merge($args, $values);																				// merging the value array onto the oend of the arguments
    $sql = "";																																	//setting sql to blank


  if ($cmd == "delete" || $cmd ==  'DELETE') { // $cmd error checking for delete
    $sql = "delete from $table_name WHERE $whereLocation $whereOperator $whereValue";
  }
  else if ($cmd == "update" || $cmd ==  'UPDATE') {  // $cmd error checking for update
                                                      // i was not sure if i should use a string or a array so im going to do both and test to see witch one is easier
    $update_array = array();													//$setting up the update array
    $update_array_count = -1;													//$setting up the $update array count it starts at -1 becaause the 11st time it goes around it will add 1 making it 0 and the array starts at 0
    $update_string = "";															// setting up the update string
    foreach ($values as $key => $value) {							//making a for each loop that runs  for as many inputs as there are to set up the question marks
      $update_array_count = + 1;											//add 1 to the update array count
			echo $update_array_count;
      $value_that_is_being_input = $values[$update_array_count];			// get the next value that is going to be inputed by using the update array count
			echo $update_array_count;
      $field_that_is_being_used = $fields[$update_array_count];				// get the next field  that is going to be inputed by using the update array count
      $prepared_update_input_statment = $field_that_is_being_used."='".$value_that_is_being_input."',";		// set up the input update command by making the correct statmetnt that is col=val,
      $update_string .= $prepared_update_input_statment;																								//adding the last input command onto the end of the final string
      $update_array[] = $prepared_update_input_statment;																								//adding the last input command onto the end of the array
    }
		   $update_string  = substr( $update_string , "0", -1);																								// removing the last comma from the  string,
      $sql = "update $table_name set $update_string WHERE $whereLocation $whereOperator $whereValue;";			//setting the update sql statment
			echo $sql;
  }
  else if ($cmd == "insert" || $cmd ==  'INSERT') { // $cmd error checking for delete
    $sql = "insert into $table_name ($fieStr) VALUES ($value_question_marks)";														//setting the delete sql statment
  }
  else if ($cmd == "select" || $cmd ==  'SELECT') { // $cmd error checking for delete
    $sql = "select $fieStr from $table_name WHERE $whereLocation $whereOperator $whereValue VALUES ($value_question_marks)";			//setting the select sql statment
  }
  else {  // $cmd error checking if there is no correct input
    $fail = "the command variable has to be delete update or insert";																			//setting the fail string
    return $fail;																																												//returning the fail string
  }
  if ($sql != ""){
    $db = new database();																												//setting up a new database class
    if ($db->query($sql, $args))																								//doing the query
    {
      return "sql run successfully";																				//if it works return a succcess string
    }
    else
    {
      return($db->error());    $db = null;         															// if it fails return the database errorr and close connection to the database
    }
    $db = null;																															// close connection to the database
  } else {
    return "error sql is empty";																					// if there is no sql for some reason return the error string
  }
  }

  }



?>
