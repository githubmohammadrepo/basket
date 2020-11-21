<?php
require_once("connection.php");

class GetJchatSessionIdsByVendorOwnerIds
{
  private $conn;
  private $vendorOwnerIds;
  public $result;
  public $error;

  public function __construct($conn)
  {
    $this->conn = $conn;
  }

  /**
   * set vendorOwner ids 
   */
  public function setVendorOwnerIds($vendorOwnerIds)
  {
    $this->vendorOwnerIds = $vendorOwnerIds;
  }

  /**
   * !important law
   *    sessionId last user in pish_session is equal to jchat_sessionstatus session_id
   *  result => pish_session.session_id == jchat_sessionstatus.session_id
   * 
   */
  public function getVendorOwnerIds()
  {
    $statusComplete = false;
    try {
      // run your code here

      $this->error =  $sql = "SELECT session_id,userid from pish_session" .
        " WHERE userid IN (" . implode(",", $this->vendorOwnerIds) . ")" .
        " GROUP by userid" .
        " ORDER BY time DESC;";
      $result = $this->conn->query($sql);
      if ($result) {
        $rowcount = $result->num_rows;
        if ($rowcount > 0) {
          $dev_array = array();
          for ($i = 0; $i < $result->num_rows; $i++) {
            $row = $result->fetch_assoc();
            $dev_array[$i] = $row;
          }

          $this->result = $dev_array;
          return true;
        } else {
          $statusComplete = false;
        }
      } else {
        $statusComplete = false;
        return false;
      }
    } catch (exception $e) {
      //code to handle the exception
      return false;
    }
    return $statusComplete;
  }
}

/**
 * using class
 */

//get posted data
$json = file_get_contents('php://input');
$post = json_decode($json, true);

if ($post && count($post)) {

  $vendorOwnerIds = $post['vedorOwnerIds'];
  if(count($vendorOwnerIds)){

    //create init from class
    $init =  new GetJchatSessionIdsByVendorOwnerIds($conn);
    
    $init->setVendorOwnerIds($vendorOwnerIds);
    
    $result = $init->getVendorOwnerIds();
    if($result){
      echo json_encode($init->result);
    }else{
      echo json_encode([]);
    }

  }else{
    echo json_encode([]);
  }

} else {
  echo json_encode([]);
}
