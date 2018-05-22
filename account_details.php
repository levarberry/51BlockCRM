<?include_once 'header.php'?>

<?php
    //Get Account Details
    $account_id = $_GET['aid'];
    $sql = "Select accounts.* , parent.account_name parent_account_name, agency_name
          from accounts 
          left join agencies on agency_id = account_agency_id 
          left join accounts parent on parent.account_id = accounts.account_parent_id 
          where accounts.account_id = $account_id
          ";
         
  

    //Check for Adding
    $action = "nada";

    if (isset($_POST['action'])) {
        $action = $_POST['action'];
    }

    switch ($action) {
        case "add":
            account_add($con);
            echo " &nbsp;&nbsp;<span></span>";
            echo "<script>toastr.success(\"Added\");</script>";
            break;
        case "save":
            echo " &nbsp;&nbsp;<span></span>";
            echo "<script>toastr.success(\"Saved\");</script>";
            account_save($con);
            
            break;
        case "delete":
            account_delete($con);
            echo " &nbsp;&nbsp;<span></span>";
            echo "<script>toastr.success(\"Removed\");</script>";
            break;
        case "nada":
            break;

    }
  $res = $con->query($sql);
    echo mysqli_error($con);
    $account = $res->fetch_object();

?>

<?php
    function account_save($con)
    {
        // echo "Inside Function now";
        
        $ins = $con->prepare("update accounts SET 
                    account_name =? ,account_agency_id=?,account_parent_id=?, 
                    account_phone=?, account_status=?
                    where account_id = ?
                    ");
        $ins->bind_param("siissi", $account_name,$account_agency_id,$account_parent_id, $account_phone, $account_status,$account_id);
        $account_name = $_POST['account_name'];
        $account_agency_id = $_POST['account_agency_id'];
        $account_parent_id = $_POST['account_parent_id'];
        $account_phone = $_POST['account_phone'];
        $account_status = $_POST['account_status'];
        $account_id = $_GET['aid'];
        
        $ins->execute();
    }

    function account_delete($con) {
        $rm = "delete from accounts where account_id=" . $_POST['account_id'];
        $con->query($rm);
        
    }
    function agency_save($con){
        $edt = "update agencies set agency_name='" . $_POST['agency_name'] . "' where agency_id=" . $_POST['agency_id'];
        $con->query($edt);
    }
?>




<div class="container">
    <div width="100%">
        <h4>Accounts Details: <?=$account->account_name?> </h4>
         
    </div>
     
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#main" role="#tab" id="main-tab"> Details</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#contacts" role="#tab" id="contacts-tab">Contacts</a></li>
        
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#services" role="#tab" id="services-tab">Services</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#logins" role="#tab" id="logins-tab">Logins</a></li>
    </ul>

    <div class="tab-content" id="mTabContent">
        <div id="main" class="tab-pane fade show active"  role="tabpanel" aria-labelledby="main-tab">
            <?php require_once("./forms/account_detail_edit.php");?>
        </div>
        <div class="tab-pane fade" id="contacts" role="tabpanel" aria-labelledby="contactss-tab">
            <?php require_once("./forms/account_detail_contacts.php");?>
        </div>
        <div class="tab-pane fade" id="services" role="tabpanel" aria-labelledby="services-tab">
            <?php require_once("./forms/account_detail_services.php");?>
        </div>
        <div class="tab-pane fade" id="logins" role="tabpanel" aria-labelledby="logins-tab">
            <?php require_once("./forms/account_detail_logins.php");?>
        </div>
    </div>



</div>



