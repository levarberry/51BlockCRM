<?include_once 'header.php'?>

<?php
    //Get All Agencies
    $sql = "Select contacts.* , accounts.account_name
          from contacts 
          left join accounts on contacts.account_id = accounts.account_id 
          order by contact_first_name, contact_last_name";
    $res = $con->query($sql);

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
?>

<?php
    function contact_add($con)
    {
        // echo "Inside Function now";
        
        $ins = $con->prepare("insert into accounts(
                    account_name,account_agency_id,account_parent_id, account_phone, account_status
                    ) values(? , ? , ? , ? , ?  )");
        $ins->bind_param("siiss", $account_name,$account_agency_id,$account_parent_id, $account_phone, $account_status);
        $account_name = $_POST['account_name'];
        $account_agency_id = $_POST['account_agency_id'];
        $account_parent_id = $_POST['account_parent_id'];
        $account_phone = $_POST['account_phone'];
        $account_status = $_POST['account_status'];
        
        $ins->execute();
    }

    function contact_delete($con) {
        $rm = "delete from contacts where contact_id=" . $_POST['contact_id'];
        $con->query($rm);
        
    }
    function contact_save($con){
        $edt = "update contacts set agency_name='" . $_POST['agency_name'] . "' where agency_id=" . $_POST['agency_id'];
        $con->query($edt);
    }
?>




<div class="container">
    <div width="100%">
        <h4 style="display:inline">Contacts </h4>
        <span class="btn btn-info pull-right" onClick="showAdd()">Add</span>
    </div>

<div class="table">
 <div class="hdr row">
     <div class="col-sm-2">
         Contact Name

    </div>
    <div class="col-sm-2">
         Account

    </div>
    <div class="col-sm-2">
         Phone

    </div>
    <div class="col-sm-2">
         Email

    </div>
    <div class="col-sm-2">
         Position 

    </div>

 </div> <!-- END TBL HDR ROW -->

   <?php
        //Loop Through All Accounts
        while ($obj = $res->fetch_object()) {
    ?>
            <div class='lst row'>
                 
                  
                 
                <div class='col-sm-2'>
                   <?=$obj->contact_first_name?>  <?=$obj->contact_last_name?> 
                </div>

                <div class='col-sm-2'>
                <a href="account_details.php?aid=<?=$obj->account_id?>"><?=$obj->account_name?></a>
                </div>

                <div class='col-sm-2'>
                  <?=$obj->contact_phone?>  
                </div>

                <div class='col-sm-2'>
                   <?=$obj->contact_email?> 
                </div>

                <div class='col-sm-2'>
                   <?=$obj->contact_position?> 
                </div>
                
            </div>
          <?php
}
//echo $res->num_rows;

?>





</div>





<div class="modal" id="account_add">
    <div class="modal-content">
    <form method="POST">
        <input type="hidden" name="action" value="add">
        <div class="form-group">
            <label for="acct_name">Account Name</label>
            <input class="form-control" required id="acct_name" name="account_name" id="acct_name">
        </div>
        <div class="form-group">
            <label for="acct_name">Agency</label>
            <select class="form-control" required id="acct_name" name="account_agency_id">
                <option value=""></option>
                <?=getOptions($con,'agencies', 'agency_name','agency_id')?>
            </select>
        </div>

        <div class="form-group">
            <label for="acct_name">Parent Account</label>
            <select class="form-control"  id="acct_name" name="account_parent_id">
                <option value=""></option>
                <?=getOptions($con,'accounts', 'account_name','account_id')?>
            </select>
        </div>
        <div class="form-group">
            <label for="acct_name">Phone</label>
            <input class="form-control"  id="acct_name" name="account_phone" id="acct_name">
        </div>

        <div class="form-group">
            <label for="acct_name">Status</label>
            <select class="form-control" required id="acct_name" name="account_status">
                <?=getOptions($con,'account_status', 'account_status_name','account_status_name')?>
            </select>
        </div>
 
        <div>
            <button class="btn btn-success">Save</button> &nbsp; &nbsp; &nbsp; 
            <button type="button" class="btn btn-secondary" onClick="cancelAdd()">Cancel</button>
</button>

    </form>
</div>

</div>


<script>

    var account_add = document.getElementById("account_add");
    console.log(account_add);

    function showAdd(){
        account_add.style.display = "block";
    }

    function cancelAdd() {
        account_add.style.display = "none"; 
    }

</script>