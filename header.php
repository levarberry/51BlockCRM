<!DOCTYPE html>
<html lang="en">
<?php 
error_reporting(0);
session_start();
ini_set('display_errors', 'On');
error_reporting(E_ALL); 
require("dbconfig.php");

/*
    if (isset($_SESSION["currentUser"])) { 
        $usr = $_SESSION["currentUser"];
    
    } 
    
    else {
        echo "<script> window.location.href=\"login.php\"; </script>";
    }
    */
function getOptions($con,$tbl,$fld,$keyname) {
    $ss = "Select $fld , $keyname from $tbl order by $fld";
    $res = $con->query($ss);
    //echo $ss;
    $rtn = '';
    while($obj = $res->fetch_object()){
        $rtn .= "<option value='" . $obj->$keyname . "'>" .$obj->$fld .   "</option>";
    }
    return $rtn;

}

function getOptionsSelected($con,$tbl,$fld,$keyname,$currval) {
    $ss = "Select $fld , $keyname from $tbl order by $fld";
    $res = $con->query($ss);
    //echo $ss;
    $rtn = '';
    while($obj = $res->fetch_object()){
        $selected = "";
        if ($obj->$keyname == $currval) {
            $selected = "selected";
        }
        $rtn .= "<option $selected value='" . $obj->$keyname . "'>" .$obj->$fld .   "</option>";
    }
    return $rtn;

}
?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>51Block&copy; Simple Client DB</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/twitter/bootstrap/dist/css/bootstrap.min.csss" rel="stylesheet">
   
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
  
	 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
 

    <!-- Custom Fonts -->
    <link href="vendor/components/font-awesome/css/fontawesome-all.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery -->
    <!--script src="vendor/jquery/jquery.min.js"></script-->
    <!-- Bootstrap Core JavaScript -->

     <link href="bootstrap/css/style.css" rel="stylesheet">
	
	<!-- Toastr -->
	<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

</head>
<?include_once 'menu.php'?>