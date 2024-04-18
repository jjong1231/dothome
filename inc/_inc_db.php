<?php
	//////////////////// mysqli 사용자함수 /////////////////////////
	//stmt 레코드수 구하기
	function stmt_count($stmt_object, $free_reusult=0){
		$stmt_object->store_result();							//결과를 미리 저장
		$row_cnt = $stmt_object->num_rows;				//레코드수
		if($free_reusult)	$stmt_object->free_result();
		return $row_cnt;
	}

	//mysqli 레코드얻기
	function mysqli_rs($query){
		global $mysqli;
		$arr_value =array();
		$result = $mysqli->query($query);
		if($result -> num_rows){
			while($rs = $result->fetch_assoc())		$arr_value[] = $rs;
			$result->close();
			unset($rs);
		}
		return $arr_value;
	}

	//autocommit
	function autocommit($bool){
		global $DB;
		$DB->autocommit($bool);
	}
	//rollback
	function rollback($error_code=""){
		global $DB, $_ARR_ERROR_MSG;
		$DB->rollback();
		if($error_code){
			$msg = $_ARR_ERROR_MSG[$error_code];
			if(!trim($msg)) $msg = $error_code;
			Alert_back($msg);
			exit;
		}
	}
	//commit
	function commit(){
		global $DB;
		$DB->commit();
	}

	//////////////////// mysqli 클래스 /////////////////////////
	class DB
	{
	    public $connection;

	    #establish db connection
	    //"58.180.82.104", "2beon", "2beon0221&*", "2beon")
	    public function __construct($host="localhost", $user="jjong1231", $pass="dh779859!", $db="jjong1231")
	    {
	        $this->connection = new mysqli($host, $user, $pass, $db);
	        $this->connection->query("SET NAMES 'utf8'");

	        if(mysqli_connect_errno())
	        {
	            echo("Database connect Error : "
	            . mysqli_connect_error($mysqli));
	        }
	    }

	    #store mysqli object
	    public function connect()
	    {
	        return $this->connection;
	    }

	    #run a prepared query
	    public function runPreparedQuery($query, $params_r)
	    {
	        $stmt = $this->connection->prepare($query);
	        $this->bindParameters($stmt, $params_r);
	        if ($stmt->execute()) {
	            return $stmt;
	        } else {
	            echo("Error in $statement: "
	                      . mysqli_error($this->connection));
	            return 0;
	        }

	    }
	 # To run a select statement with bound parameters and bound results.
	 # Returns an associative array two dimensional array which u can easily
	 # manipulate with array functions.

	    public function preparedSelect($query, $bind_params_r)
	    {
	        $select = $this->runPreparedQuery($query, $bind_params_r);
	        $fields_r = $this->fetchFields($select);

	        foreach ($fields_r as $field) {
	            $bind_result_r[] = &${$field};
	        }

	        $this->bindResult($select, $bind_result_r);

	        $result_r = array();
	        $i = 0;
	        while ($select->fetch()) {
	            foreach ($fields_r as $field) {
	                $result_r[$i][$field] = $$field;
	            }
	            $i++;
	        }
	        $select->close();
	        return $result_r;
	    }

		//변경 2011.03.23 박영식
	     public function preparedInsert($query, $bind_params_r)
	    {
	        $select = $this->runPreparedQuery($query, $bind_params_r);
			$insert_id = $select->insert_id;
			$select->close();
			return $insert_id;			//추가된 PK 반환
	    }

	    //추가 2011.03.23 박영식
	     public function preparedUpdate($query, $bind_params_r)
	    {
	        $select = $this->runPreparedQuery($query, $bind_params_r);
	        $affected_rows = $select->affected_rows;
			$select->close();
			return $affected_rows;			//변경된 레코드수 반환
	    }


	    #takes in array of bind parameters and binds them to result of
	    #executed prepared stmt

	    private function bindParameters(&$obj, &$bind_params_r)
	    {
//	    	call_user_func_array(array($obj, "bind_param"), $bind_params_r);
	    	call_user_func_array(array($obj, "bind_param"), $this->refValues($bind_params_r));
	    }

	    private function bindResult(&$obj, &$bind_result_r)
	    {
//	        call_user_func_array(array($obj, "bind_result"), $bind_result_r);
	        call_user_func_array(array($obj, "bind_result"), $this->refValues($bind_result_r));
	    }

	    #returns a list of the selected field names

	    private function fetchFields($selectStmt)
	    {
	        $metadata = $selectStmt->result_metadata();
	        $fields_r = array();
	        while ($field = $metadata->fetch_field()) {
	            $fields_r[] = $field->name;
	        }

	        return $fields_r;
	    }
	    private function refValues($arr)
	    {
	       if (strnatcmp(phpversion(),'5.3') >= 0) //Reference is required for PHP 5.3+
		    {
		        $refs = array();
		        foreach($arr as $key => $value)
		            $refs[$key] = &$arr[$key];
		         return $refs;
		     }
		     return $arr;
	    }
	    function db_stmt_bind_params($stmt, $params)
			{
			    $funcArg[] = $stmt;
			    foreach($params as $val=>$type)
			    {
			        $funcArg['type'] .= $type;
			        $funcArg[] = $val;
			    }
			    return call_user_func_array('mysqli_stmt_bind_param', $funcArgs);
			}

		//신규추가 2011.03.31 박영식
		/************************************************
			사용법 :
			$arr_bindType_cols[]=array("i",$value1);
			$arr_bindType_cols[]=array("s",$value2);
			$arr_bindType_cols[]=array("i",$value3);
			$result = aquery($query, $arr_bindType_cols);
		************************************************/
		public function aquery($query, $arr_bindType_cols=null)
		{
			if(is_array($arr_bindType_cols)){
				$bind_params_r = array();
				$bind_params_r[0] = ""; // notice 오류로 인한 초기화 추가
				while(list($_key, $_array)=each($arr_bindType_cols)){
					$bind_params_r[0].= $_array[0];
					$bind_params_r[] = $_array[1];
				}
				$ret = $this->pquery($query, $bind_params_r);
			}else{
				if($arr_bindType_cols){
					echo "<b style='font-size:14px'>aquery Method Error : input type is not an array</b><br>[query]$query";
					exit;
				}else{
					$ret = $this->query($query);
				}
			}
			return $ret;
		}

		//prepared 쿼리용 - 추가 2011.03.23 박영식
		public function pquery($query, $bind_params_r)
		{
			$tmp_query = preg_replace("/\s+/"," ",trim($query));
			$arr_tmp = explode(" ", strtolower(substr($tmp_query,0,10)));
			$query_type = $arr_tmp[0];
			$ret = 0;
			switch($query_type){
				case "select":
					$ret = $this->preparedSelect($query, $bind_params_r);
					break;
				case "insert":
					$ret = $this->preparedInsert($query, $bind_params_r);
					break;
				case "update":case "delete":
					$ret = $this->preparedUpdate($query, $bind_params_r);
					break;
				default:
					$ret = $this->runPreparedQuery($query, $bind_params_r);

			}
			return $ret;
		}

		//일반 쿼리용(stmt 미사용)
		public function query($query)
	    {
			$tmp_query = preg_replace("/\s+/"," ",trim($query));
			$arr_tmp = explode(" ", strtolower(substr($tmp_query,0,10)));
			$query_type = $arr_tmp[0];

			$ret = 0;
			switch($query_type){
				case "select":
					$ret = $this->select($query);
					break;
				case "insert":
					$ret = $this->insert($query);
					break;
				case "update":case "delete":
					$ret = $this->update($query);
					break;
				default:
					$ret = $this->runQuery($query);
			}
			return $ret;
	    }
		public function runQuery($query)
		{
	        $result = $this->connection->query($query);
			if($result){
	            return $result;
	        } else {
	            echo("Error in $statement: ". mysqli_error($this->connection));
	            return 0;
	        }
	    }
	    public function select($query)
	    {
			$select = $this->runQuery($query);
			if($select){
				$i=0;
				while ($row = $select->fetch_assoc()) {
					$result_r[$i] = $row;
					$i++;
				}
			}
			$select->close();
			return $result_r;
	    }
	     public function insert($query)
	    {
			$insert = $this->runQuery($query);
			$insert_id = $this->connection->insert_id;
			return $insert_id;			//추가된 PK 반환
	    }
	     public function update($query)
	    {
			$update = $this->runQuery($query);
			$affected_rows = $this->connection->affected_rows;
			return $affected_rows;			//변경된 레코드수 반환
	    }

		//오토커밋
		public function autocommit($bool){
			$this->connection->autocommit($bool);
		}

		//커밋
		public function commit(){
			$this->connection->commit();
		}

		//롤백
		public function rollback(){
			$this->connection->rollback();
		}
	}

	$DB = NEW DB();	
?>