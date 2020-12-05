<?php
include "connection.php";
/**
 * before doing any thing fireJomla session
 */
function fireJomlaSession(){
  session_start();
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  require_once("connection.php");

  define( '_JEXEC', 1 );
  define( 'JPATH_BASE', realpath(dirname(__FILE__).'/..' ));

  require_once ( JPATH_BASE. '/includes/defines.php' );
  require_once ( JPATH_BASE. '/includes/framework.php' );
  $mainframe = JFactory::getApplication('site');
  $mainframe->initialise();
}
fireJomlaSession();


/**
 * response class for just response to some thing
 */
class Response
{
  
  /**
   * general fail response
   */
  public function failResponse()
    {
      $dev_array[0]['id'] = "notok";
      $dev_array[1]['user_id'] = "null";
      $dev_array[2]['distance'] = "null";
  
      $jsonEncode = json_encode($dev_array, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
  
      echo $jsonEncode;
    }
}
/**
 * main class for operation selectNearestShop
 */
class SelectNearestShop extends Response
{
  private $conn;
  private $regesteredStoreList = Array();
  private $regesteredStoreCount = 0;
  private $unRegesteredStoreList = Array();
  public $cityId;
  public $provinceId;

  private $lat;
  private $lng;

  public $smsCount;
  private $successSms=0;
  private $failSms =0;

  public function __construct($conn,$cityId,$provinceId,$lat,$lng)
  {
    $this->conn  = $conn;
    $this->cityId = $cityId;
    $this->provinceId = $provinceId;

    $this->lat = $lat;
    $this->lng = $lng;
  }

  //get all nearest shop that was regestered
  public function getAllRegesteredStores()
  {
    $sql = "(SELECT id,user_id, ( 6371* acos(cos(radians(29.807903289794923)) * cos(radians(latitude)) * cos(radians(longitude) - radians(52.48660659790040)) + sin(radians(29.807903289794923)) * sin(radians(latitude))) ) AS distance FROM pish_phocamaps_marker_store WHERE user_id is not null AND user_id REGEXP '^[0-9]' AND city = $this->cityId AND province = $this->provinceId ORDER BY distance LIMIT 0, 40 )";
    $result = $this->conn->query($sql);
    
    $this->regesteredStoreCount = $result->num_rows;
    if ($this->regesteredStoreCount > 0) {
      for ($i = 0; $i < $result->num_rows; $i++) {
        $row = $result->fetch_assoc();
        $this->regesteredStoreList[$i] = $row;
      }
      return true;
    } else {
      return false;
    }
  }

  //validate number of shop that regestered
  public function validateRegesteredStores()
  {
    if ($this->getAllRegesteredStores()) {
      if ($this->regesteredStoreCount >= 20) {
        //continue complete order
        return true;
      } else {
        //sent sms to 1000 store or all store that have the same city and state
        $this->sendSmsToUnregesteredStores();
        return 'sentSms';
      }
    } else {
      return false;
    }
  }

  //send sms to 1000 store owner that live in same city and province(state)
  private function sendSmsToUnregesteredStores(){
    //get 1000 store owner mobile phone
    $this->smsCount = 40;
    if($this->getAllUnRegesteredStores($this->smsCount)){
      foreach ($this->unRegesteredStoreList as $key => $row) {
        $message ='فروشگاه عزیز لطفا  ثبت نام بکنید';
        $mobile = $row['MobilePhone'];
        
        //solve problem with phone number
        if(strlen($mobile)==10 && $mobile[0]!=0){
          $sub = $mobile;
          $mobile='0'.$sub;
        }

        // if phone number is correct
        if(strlen($mobile)==11){
          //phone number is correct and sent sms
          if($this->sendOneSms($mobile,$message)){
            $this->successSms++;
          }else{
            $this->failSms++;
          }
        }else{  
          //phone number is not correct
          $this->failSms++;
        }
      }
    }else{
      return false;
    }
  }

  /**
   * get list unregestered store by resultCount
   */
  public function getAllUnRegesteredStores($resultCount=40)
  {
    $sql = "(SELECT id,user_id, ( 6371* acos(cos(radians(29.807903289794923)) * cos(radians(latitude)) * cos(radians(longitude) - radians(52.48660659790040)) + sin(radians(29.807903289794923)) * sin(radians(latitude))) ) AS distance FROM pish_phocamaps_marker_store WHERE user_id is null AND city = $this->cityId AND province = $this->provinceId ORDER BY distance LIMIT 0, 40 )";
    $result = $this->conn->query($sql);
    $this->unRegesteredStoreCount = $result->num_rows;
    if ($this->unRegesteredStoreCount > 0) {
      for ($i = 0; $i < $result->num_rows; $i++) {
        $row = $result->fetch_assoc();
        $this->unRegesteredStoreList[$i] = $row;
      }
      return true;
    } else {
      return false;
    }
  }

  /**
   * sent one sms to one mobile phone
   */
  private function sendOneSms($mobile,$text)
  {
    try {
      $user = "rjabrisham";
      $pass = "rj9354907433";

      $client = new SoapClient("http://188.0.240.110/class/sms/wsdlservice/server.php?wsdl");
      $user = $user;
      $pass = $pass;
      $fromNum = "500010708120";
      $toNum = array($mobile);
      $pattern_code = "3ahrlw9s7d";
      $input_data = array(
        "verification-code" => $text
      );

      $res =  $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_data);
      if($res){
        return true;
      }else{
        return false;
      }
    } catch (SoapFault $ex) {
      // echo "$ex->faultstring";
      return false;
    }
  }

  //show result
  public function showResult()
  {
    if($this->validateRegesteredStores()===true){
      //20 store is returned and continue complete order
      $this->sucessResponse();
    }elseif($this->validateRegesteredStores()=='sentSms'){
      $this->sentSmsResponse();
    }else{
      //validation regestered is false and error when return stores
      $this->failResponse();

    }
    
  }

   /**
   * success response
   */
  private function sucessResponse()
  {
    $jsonEncode = json_encode($this->regesteredStoreList, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    echo $jsonEncode;
  }

  /**
   * sent sms response
   */
  private function sentSmsResponse()
  {
    $dev_array[0]['id'] = "sentSms";
    $dev_array[1]['storeCount'] = $this->smsCount;
    $dev_array[2]['successCount'] = $this->successSms;
    $dev_array[2]['failCount'] = $this->failSms;

    $jsonEncode = json_encode($dev_array, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    echo $jsonEncode;
  }

  /**
   * fail response
   */
  public function failResponse()
  {
    $dev_array[0]['id'] = "notok";
    $dev_array[1]['user_id'] = "null";
    $dev_array[2]['distance'] = "null";

    $jsonEncode = json_encode($dev_array, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    echo $jsonEncode;
  }
}

// using class
$json = file_get_contents('php://input');
$post = json_decode($json, true);

if ($post && count($post)) {
  $lat = $post["lat"];
  $lng = $post["lng"];

  $cityId = $post["city"];
  $provinceId = $post["province"];

  $response = new Response();
  if ($lat && $lng && $cityId && $provinceId) {
    $selectNearest = new SelectNearestShop($conn,$cityId,$provinceId,$lat,$lng);
    $selectNearest->showResult();
  } else {
    $response->failResponse();
  }
} else {
  $response->failResponse();
}



