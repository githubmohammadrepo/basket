<?php
require_once("connection.php");

$object = new stdClass();

class GetPlaceLocation
{
    public $allStates=null;
    public $allCities=null;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    /**
     * get hikashop user id
     */
    public function getAllStates()
    {
        $statusComplete = false;
        
        try {
            // run your code here
            $sql = "SELECT * FROM `pish_province`";
            
            $result = $this->conn->query($sql);
            if ($result) {
                $rowcount = $result->num_rows;
                if ($rowcount > 0) {
                    
                  $this->allStates =Array();
                  while($row = $result->fetch_assoc()) {
                      $this->allStates[]=$row;
                    }
                    
                    $statusComplete = true;

                } else {
                    $statusComplete = false;
                }
            } else {
                $statusComplete = false;
                
            }
        } catch (exception $e) {
            //code to handle the exception
            return false;
        }
        return $statusComplete;
    }

    /**
     * show all states
     *  */    
    public function showAllStates(&$object){
      if($this->getAllStates()){
        if($this->allStates){
          $object->response = 'ok';
          $object->data = $this->allStates;
        }else{
          $object->response = 'notok';
        }
      }else{
        $object->response = 'notok';
      }
    }


    /**
     * get all city by state id
     */
    public function getAllCities($state_id)
    {
        $statusComplete = false;
        
        try {
          $sql='';
          if(strlen($state_id)){
            // run your code here
            $sql = "SELECT * from `pish_city` \n"
        
            . "WHERE province_id = $state_id";
          }else{
            $sql = "SELECT * FROM `pish_city` WHERE 1";
          }
            $result = $this->conn->query($sql);
            if ($result) {
                $rowcount = $result->num_rows;
                if ($rowcount > 0) {
                    
                  $this->allCities =Array();
                  while($row = $result->fetch_assoc()) {
                      $this->allCities[]=$row;
                    }
                    
                    $statusComplete = true;

                } else {
                    $statusComplete = false;
                }
            } else {
                $statusComplete = false;
                
            }
        } catch (exception $e) {
            //code to handle the exception
            return false;
        }
        return $statusComplete;
    }

    /**
     * show all cities by state id
     *  */    
    public function showAllCities(&$object,$state_id){
        
      if($this->getAllCities($state_id)){
          
        if($this->allCities){
          $object->response = 'ok';
          $object->data = $this->allCities;
        }else{
          $object->response = 'notok';
        }
      }else{
        $object->response = 'notok';
      }
    }
    
  }

//   using class
$json = file_get_contents('php://input');
$post = json_decode($json, true);
$typeGetData = $post['typeGetData'];
$state_id  = $post['state_id'];

if ($post && $typeGetData) {

    $object = new stdClass();
    $store = new GetPlaceLocation($conn);

    if($typeGetData == 'getAllState'){
      $store->showAllStates($object);
    }elseif($typeGetData == 'getAllCity'){
      if(strlen($state_id)){
        $store->showAllCities($object,$state_id);  
      }else{
        $store->showAllCities($object,'');
      }
    }else{
      $object->response =  'notok';
    }
    echo json_encode([$object], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

}else{
    $object->response = 'notok';
    echo json_encode([$object], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

}

