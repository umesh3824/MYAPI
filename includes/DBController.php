<?php
include "includes/config.php";
class DBController{
    private $con;
    public $queryObject;
    function __construct($con) {
        $this->queryObject="NO";
        $this->con = $con;
    }
    function bindQueryParamsExecute($sql, $param_type, $param_value_array) {
        //Prepared Query
        $this->queryObject=$this->con->prepare($sql);

        //Binding Parameter
        $param_value_reference[] = & $param_type;
        for($i=0; $i<count($param_value_array); $i++) {
            $param_value_reference[] = & $param_value_array[$i];
        }
        call_user_func_array(array(
            $this->queryObject,
            'bind_param'
        ), $param_value_reference);
        
        //Execute Query
        $this->queryObject->execute();
    }

    function setSelectData($successMessage,$failMessage){
        $listOfData=$this->queryObject->get_result()->fetch_all(MYSQLI_ASSOC); // fetch an array of rows
        if (count( $listOfData)>0) {
                $returnData['status']=TRUE;
                $returnData['data']=$listOfData;
                $returnData['message']=$successMessage;
        } else {
            $returnData['status']=FALSE;
            $returnData['message']=$failMessage;
        }
        $this->queryObject->close();
        return $returnData;
    }
    function setUpdateDeleteData($successMessage,$failMessage){
        if ($this->queryObject->affected_rows>0) {
            $returnData['status']=TRUE;
            $returnData['message']=$successMessage;
        } else {
            $returnData['status']=FALSE;
            $returnData['message']=$failMessage;
        }
        $this->queryObject->close();
        return $returnData;
    }
    function setInsertData($successMessage,$failMessage){
        if ($this->queryObject->affected_rows>0) {
            $returnData['status']=TRUE;
            $returnData['data']=["insertedId"=>$this->queryObject->insert_id];
            $returnData['message']=$successMessage;
        } else {
            $returnData['status']=FALSE;
            $returnData['message']=$failMessage;
        }
        $this->queryObject->close();
        return $returnData;
    }

    function insert($sql,$param_types,$param_values,$successMessage,$failMessage){
        $this->bindQueryParamsExecute($sql, $param_types, $param_values);
        return $this->setInsertData($successMessage,$failMessage);
    }

    function update($sql,$param_types,$param_values,$successMessage,$failMessage){
        $this->bindQueryParamsExecute($sql, $param_types, $param_values);
        return $this->setUpdatedeleteData($successMessage,$failMessage);
    }

    function delete($sql,$param_types,$param_values,$successMessage,$failMessage){
        $this->bindQueryParamsExecute($sql, $param_types, $param_values);
        return $this->setUpdatedeleteData($successMessage,$failMessage);
    }

    function select($sql,$param_types,$param_values,$successMessage,$failMessage){
        $this->bindQueryParamsExecute($sql, $param_types, $param_values);
        return $this->setSelectData($successMessage,$failMessage);
    }

    function selectAll($sql,$successMessage,$failMessage){
        $this->queryObject=$this->con->prepare($sql);
        $this->queryObject->execute();
        return $this->setSelectData($successMessage,$failMessage);
    }
}




$db=new DBController($con);
//for insert
// $sql="INSERT INTO users(user_name,user_contactNo,user_mail) VALUES (?,?,?)";
// $param_type="sis";
// $var=$db->insert($sql,$param_type,["AMol",258963,"abc@gmail.com"],"success full","failed");

//for select with parameter
// $sql="SELECT * FROM users WHERE user_id=?";
// $param_type="i";
// $var=$db->select($sql,$param_type,[3],"success full","failed");

//for select without parameter OR select All
// $sql="SELECT * FROM users";
// $var=$db->selectAll($sql,"success full","failed");

//for Update
// $sql="UPDATE users SET user_name=?,user_contactNo=?,user_mail=? WHERE user_Id=?";
// $param_type="sssi";
// $var=$db->update($sql,$param_type,["rahul",852365,"ccc@gmail.com",1],"success full","failed");


//for Delete
// $sql="DELETE FROM users WHERE user_Id=?";
// $param_type="i";
// $var=$db->delete($sql,$param_type,[18],"success full","failed");







var_dump($var);

?>