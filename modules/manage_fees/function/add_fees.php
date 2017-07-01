<?php
include("../../../Resources/sessions.php");

require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Fees.php");
$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);
$user_id = 1; //To Do: Change This
$fees = new Fees($dbConnect->getInstance());
if(isset($_REQUEST["id"]) && $_REQUEST["fees_input"]){
    if($fees->addFees($_REQUEST["id"],$_REQUEST["fees_input"])){
        $fees->parentPageRedirect("Fees updated successfully");
    }else{
        $fees->parentPageRedirect("Error while processing");
    }
}else{
    $fees->parentPageRedirect("Error while processing");
}

?>