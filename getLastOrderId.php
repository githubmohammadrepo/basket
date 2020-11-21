<?php
require_once("connection.php");

$object = new stdClass();

class SendTo20Store
{

    private $hika_user_id;
    private $conn;
    public $last_id;
    public $row;
    
    public function __construct($conn,$user_id)
    {
        $this->conn = $conn;
        // set hikashop user_id
        $this->getHikashopUserId($user_id);
        //get order infos
    }
    /**
     * get hikashop user id
     */
    public function getHikashopUserId($user_id)
    {
        $statusComplete = false;
        
        try {
            // run your code here
        $sql = "SELECT `user_id` FROM pish_hikashop_user WHERE user_cms_id=$user_id LIMIT 1";
            
            $result = $this->conn->query($sql);
            if ($result) {
                $rowcount = $result->num_rows;
                if ($rowcount > 0) {
                    
                    $row = $result->fetch_assoc();
                    $this->hika_user_id = $row['user_id'];

                } else {
                    $statusComplete = false;
                }
            } else {
                $statusComplete = false;
                throw new Exception("error accured when get order_product infos");
                
            }
        } catch (exception $e) {
            //code to handle the exception
            return $e->getMessage();
        }
        return $statusComplete;
    }


    /***
     * find last order table id
     */
    public function getLastOrderTableId()
    {
        $this->row =$sql = "SELECT * FROM `pish_hikashop_order`".
        " WHERE `order_user_id` = ".$this->hika_user_id." ".
        " AND order_type = 'sale'".
        " order by order_created DESC".
        " limit 1"; //have error
        $rows = $this->conn->query($sql);
        if ($rows->num_rows > 0) {
            $row = $rows->fetch_assoc();
            
            // $this->last_id = $rows['order_id'];
            $this->last_id = $row['order_id'];
            
            $this->error = $row;
            return true;
        } else {
            $this->last_id = -1;
            return false;
        }
    }

  
}

//using class

//other code
$json = file_get_contents('php://input');
$post = json_decode($json, true);
// $post = $card;
if($post && count($post)){
        
    $user_id = $post["user_id"];
    if($user_id){

        try {
            // throw new Exception("Some error message");

            if ($user_id) {
                $sendStore = new SendTo20Store($conn, $user_id);
                
                
                // step 1 => get order by user_id
                if($sendStore->getLastOrderTableId()){
                    // $object->response = $sendStore->row->order_id;
                    $object->response = $sendStore->last_id;
                }else{
                    $object->response = 'notok';
                }

                //stemp3 ===last ***  => sent chat message

            } else {
                $object->response = 'notok';
            }


            // $object->response = 'ok';
        } catch (Exception $e) {
            // echo $e->getMessage();
            $object->response = 'notok';
        }
        // print_r(json_encode(['name' => $sendStore->row]));

        
      }else{
        $object->response = 'notok';
      }
}else{
  $object->response = 'notok';
}

$jsonEncode = json_encode($object, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        echo $jsonEncode;

?>