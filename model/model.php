<?php

class Model {
	private $conn;
	public function __construct(){
		$this->connect();

	}

	
	public function connect(){
		$this->conn = new mysqli('localhost','root','024306','mood_trace');
		if($this->conn->connect_errno){
			die('Connect Error:'.$this->conn->connect_errno.$this->conn->connect_error);
		}
	}

	public function pre_query($sql,$param_val){
		$stmt = $this->conn->prepare($sql);
		if($stmt === false){
			echo 'prepare error:'.$this->conn->errno.$this->conn->error;
			return false;
		} else {
			$key_str = '';
			$val_attr = array();	
			foreach($param_val as $key=>$val){
				$key_str .= $key; 		
				$val_attr[] = &$param_val[$key];
			}	
			$val_attr = array_merge(array($key_str),$val_attr);
			call_user_func_array(array($stmt,"bind_param"),$val_attr);
			$stmt->execute();
			$result = $stmt->get_result();
			if($stmt->errno){
				echo 'get result Error:'.$stmt->errno.$stmt->error;
				return false;
			}

			while($rtn = $result->fetch_assoc()){
				print_r($rtn);
			}
			$stmt->close();
		}

	}

	public function __destruct(){
		if($this->conn->connect_errno == 0) {
			$this->conn->close();	
		}

	}

}

?>
