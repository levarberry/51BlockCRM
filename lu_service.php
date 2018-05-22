<?include_once 'header.php'?>

<?
    //Get All Agencies
    $sql = "Select * from services order by service_name";
    $res = $con->query($sql);

    //Check for Adding
    $action = "nada";

    if (isset($_POST['action'])) {
        $action = $_POST['action'];
    }

    switch ($action) {
        case "add":
            agency_add($con);
            echo " &nbsp;&nbsp;<span></span>";
            echo "<script>toastr.success(\"Added\");</script>";
            break;
        case "save":
            echo " &nbsp;&nbsp;<span></span>";
            echo "<script>toastr.success(\"Saved\");</script>";
            agency_save($con);
            break;
        case "delete":
            agency_delete($con);
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
            <h4> Insert Service </h4>
        </div>
        <form method="POST" class="form-inline">

        <div class="form-group row">

            <input type="hidden" name="action" value="add">
            <label for="service_name" class="col-lg-4 col-form-label">Service:</label>

            <div class="col-lg-6" >
                <input type="text" class="form-control"  name="service_name" placeholder="Insert Service Name">
            </div>
            <div class="col-lg-2">
                <input type="submit" value="Add" class="form-control btn btn-success">
            </div>

        </div>
        </form>
    </div>
    <hr>
    <div class="section row">
        
        <div class="col-ms-12 hdr"> Service Name</div>
    </div>
    <!-- Now we're looping -->
    <div class="section">
    <?php
while ($obj = $res->fetch_object()) {
    ?>
            <div class='lst row'>
                 
                  
                 
                <div class='col-md-4'>
                  <?=$obj->service_name?>
                </div>
                <div class="col-md-8  col-xs-4">
                  <form method="POST">
                      <input type="hidden" name="action" value="edit">
                      <input type="hidden" name="service_id" value="<?=$obj->service_id?>">
                     <button type="button" class="btn btn-primary" onClick="edititm(this.form, '<?=$obj->service_name?>' , '<?=$obj->service_id?>' )"><i class="fa fa-edit"></i></button>
                
                      <button type="button"  class="btn btn-danger" onClick="removeitm(this.form, '<?=$obj->service_name?>')"><i class="fa fa-trash"></i></button>
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
           <input type="hidden" name="service_id" id="edt_id">
        <div class="form-group">
            <label for="edt_nm">Edit Name:</label>
            <div class="form-control">
                <input type="text" class="form-control" name="service_name" id="edt_nm">
            </div>
           <button class="btn btn-primary">Save</button>
           <button class="btn btn-default" onClick="cancelitm()">Cancel</button>
           
       </form>
    </div>
</div>

<?php
function agency_add($con)
{
    // echo "Inside Function now";
    $ins = "insert into services(service_name) values('" . $_POST['service_name'] . "')";
     
    $con->query($ins);
}

function agency_delete($con) {
    $rm = "delete from services where service_id=" . $_POST['service_id'];
    $con->query($rm);
     
}
function agency_save($con){
    $edt = "update services set service_name='" . $_POST['service_name'] . "' where service_id=" . $_POST['service_id'];
    $con->query($edt);
}
?>

<script>
    function removeitm(frm,nm) {
        frm["action"].value="delete";

        var bcheck = confirm("Delete this service: " + nm);
        
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
        var div_nm = document.getElementById("edt_nm");
        var div_id = document.getElementById("edt_id");
        div_nm.value = "";
        div_id.value = "";

        modal.style.display = "none"; 
    }

</script>