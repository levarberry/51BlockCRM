<?include_once 'header.php'?>

<?
//Get All account_status
$sql = "Select * from account_status order by account_status_name";
$res = $con->query($sql);

//Check for Adding
$action = "nada";

if (isset($_POST['action'])) {
    $action = $_POST['action'];
}

switch ($action) {
    case "add":
        status_add($con);
        echo " &nbsp;&nbsp;<span></span>";
        echo "<script>toastr.success(\"Added\");</script>";
        break;
    case "save":
        echo " &nbsp;&nbsp;<span></span>";
        echo "<script>toastr.success(\"Saved\");</script>";
        status_save($con);
        break;
    case "delete":
        status_delete($con);
        echo " &nbsp;&nbsp;<span></span>";
        echo "<script>toastr.success(\"Removed\");</script>";
        break;
    case "nada":
        break;

}

$res = $con->query($sql); 
?>

<div class="container">
    <div class="section">
        <div>
            <h4> Insert Status </h4>
        </div>
        <form method="POST" class="form-inline">

        <div class="form-group row">

            <input type="hidden" name="action" value="add">
            <label for="status_name" class="col-lg-4 col-form-label">Status:</label>

            <div class="col-lg-6" >
                <input type="text" class="form-control"  name="status_name" placeholder="Insert Status Name">
            </div>
            <div class="col-lg-2">
                <input type="submit" value="Add" class="form-control btn btn-success">
            </div>

        </div>
        </form>
    </div>
    <hr>
    <div class="section row">
        
        <div class="col-ms-12 hdr"> Status Name</div>
    </div>
    <!-- Now we're looping -->
    <div class="section">
    <?php
while ($obj = $res->fetch_object()) {
    ?>
            <div class='lst row'>
                 
                  
                 
                <div class='col-md-4'>
                  <?=$obj->account_status_name?>
                </div>
                <div class="col-md-8  col-xs-4">
                  <form method="POST">
                      <input type="hidden" name="action" value="edit">
                      <input type="hidden" name="status_id" value="<?=$obj->account_status_id?>">
                     <button type="button" class="btn btn-primary" onClick="edititm(this.form, '<?=$obj->account_status_name?>' , '<?=$obj->account_status_id?>' )"><i class="fa fa-edit"></i></button>
                
                      <button type="button"  class="btn btn-danger" onClick="removeitm(this.form, '<?=$obj->account_status_name?>')"><i class="fa fa-trash"></i></button>
                    </form>
                </div>
            </div>
          <?php
}
//echo $res->num_rows;

?>
    </div><!-- end section -->
</div>

<div id="editbox"  class="modal">
    <!-- Modal content -->
    <div class="modal-content" >
       <form method="POST">
           <input type="hidden" name="action" value="save">
           <input type="hidden" name="status_id" id="edt_id">
        <div class="form-group">
            <label for="edt_nm">Edit Name:</label>
            <div class="form-control">
                <input type="text" class="form-control" name="status_name" id="edt_nm">
            </div>
           <button class="btn btn-primary">Save</button>
           <button class="btn btn-default" onClick="cancelitm()">Cancel</button>
           
       </form>
    </div>
</div>

<?php
    function status_add($con)
    {
        // echo "Inside Function now";
        $ins = "insert into account_status(account_status_name) values('" . $_POST['status_name'] . "')";
        
        $con->query($ins);
    }

    function status_delete($con) {
        $rm = "delete from account_status where account_status_id=" . $_POST['status_id'];
        $con->query($rm);
        
    }
    function status_save($con){
        $edt = "update account_status set account_status_name='" . $_POST['status_name'] . "' where account_status_id=" . $_POST['status_id'];
        $con->query($edt);
    }
?>

<script>
    function removeitm(frm,nm) {
        frm["action"].value="delete";

        var bcheck = confirm("Delete this status: " + nm);
        
        if(bcheck) {
            //alert(frm["status_id"].value);
            frm.submit();
        }
        else {
             
            return false;
        }
    }

    function edititm(frm,nm,id) {
        var modal = document.getElementById('editbox');
        var div_nm = document.getElementById("edt_nm");
        var div_id = document.getElementById("edt_id");
        div_nm.value = nm;
        div_id.value = id;

        modal.style.display = "block"; 
       

    }

    function cancelitm(){
        var modal = document.getElementById('editbox');
        var div_nm = document.getElementById("edt_nm");
        var div_id = document.getElementById("edt_id");
        div_nm.value = "";
        div_id.value = "";

        modal.style.display = "none"; 
    }

</script>