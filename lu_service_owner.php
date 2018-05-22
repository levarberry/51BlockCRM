<?include_once 'header.php'?>

<?
//Get All Service Owners
$sql = "Select *, concat(service_owner_first_name,' ', service_owner_last_name) fullname from service_owner order by service_owner_first_name,service_owner_last_name";
$res = $con->query($sql);
echo mysqli_error($con);

//Check for Adding
$action = "nada";

if (isset($_POST['action'])) {
    $action = $_POST['action'];
}

switch ($action) {
    case "add":
        owner_add($con);
        echo " &nbsp;&nbsp;<span></span>";
        echo "<script>toastr.success(\"Added\");</script>";
        break;
    case "save":
        echo " &nbsp;&nbsp;<span></span>";
        echo "<script>toastr.success(\"Saved\");</script>";
        owner_save($con);
        break;
    case "delete":
        owner_delete($con);
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
            <h4> Insert Service Owner </h4>
        </div>
        <form method="POST" class="form-inline">

        <div class="form-group row">

            <input type="hidden" name="action" value="add">
            <label for="agency_name" class="col-lg-4 col-form-label">Owner:</label>

            <div class="col-lg-6" >
                <input type="text" class="form-control"  name="service_owner_first_name" placeholder="Insert First Name">
                <input type="text" class="form-control"  name="service_owner_last_name" placeholder=".. Last Name">
            </div>
            <div class="col-lg-2">
                <input type="submit" value="Add" class="form-control btn btn-success">
            </div>

        </div>
        </form>
    </div>
    <hr>
    <div class="section row">
        
        <div class="col-ms-12 hdr"> Service Owner Name</div>
    </div>
    <!-- Now we're looping -->
    <div class="section">
    <?php
while ($obj = $res->fetch_object()) {
    ?>
            <div class='lst row'>
                 
                  
                 
                <div class='col-md-4'>
                  <?=$obj->service_owner_first_name?> 
                  <?=$obj->service_owner_last_name?> 
                  
                </div>
                <div class="col-md-8  col-xs-4">
                  <form method="POST">
                      <input type="hidden" name="action" value="edit">
                      <input type="hidden" name="service_owner_id" value="<?=$obj->service_owner_id?>">
                     <button type="button" class="btn btn-primary" onClick="edititm(this.form,'<?=$obj->service_owner_last_name?>' , '<?=$obj->service_owner_last_name?>' , '<?=$obj->service_owner_id?>' )"><i class="fa fa-edit"></i></button>
                
                      <button type="button"  class="btn btn-danger" onClick="removeitm(this.form, '<?=$obj->service_owner_fullname?>')"><i class="fa fa-trash"></i></button>
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
           <input type="hidden" name="service_owner_id" id="edt_id">
        <div class="form-group">
            <label for="edt_nm">Edit Name:</label>
            <div class="form-control">
                <input type="text" class="form-control" name="service_owner_first_name" id="edt_fnm">
                <input type="text" class="form-control" name="service_owner_last_name" id="edt_lnm">
            </div>
           <button class="btn btn-primary">Save</button>
           <button class="btn btn-default" onClick="cancelitm()">Cancel</button>
           
       </form>
    </div>
</div>

<?php
    function owner_add($con)
    {
        // echo "Inside Function now";
        $ins = "insert into service_owner(service_owner_first_name,service_owner_last_name)
                 values('" . $_POST['service_owner_first_name'] . "','" . $_POST['service_owner_last_name'] . "')";
        
        $con->query($ins);
        echo mysqli_error($con);
    }

    function owner_delete($con) {
        $rm = "delete from service_owner where service_owner_id=" . $_POST['service_owner_id'];
        $con->query($rm);
        
    }
    function owner_save($con){
        $edt = "update servie_owners set 
            sr_owner_first_name='" . $_POST['service_owner_first_name'] .
            ", sr_owner_last_name='" . $_POST['service_owner_last_name'] 
            
            . "' where agency_id=" . $_POST['agency_id'];
        $con->query($edt);
    }
?>

<script>
    function removeitm(frm,nm) {
        frm["action"].value="delete";

        var bcheck = confirm("Delete this Service Owner: " + nm);
        
        if(bcheck) {
            //alert(frm["agency_id"].value);
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
        var div_lnm = document.getElementById("edt_lnm");
        var div_fnm = document.getElementById("edt_fnm");
        var div_id = document.getElementById("edt_id");
        div_lnm.value = "";
        div_fnm.value = "";
        
        div_id.value = "";

        modal.style.display = "none"; 
    }

</script>