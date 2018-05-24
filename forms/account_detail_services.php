<script>
  function addService() {
      toastr.success("Added Service....");
  }
  function showServiceTab() {
      $('#services-tab').tab('show');
  }

function delService(frm,id){
     // alert(frm);
      frm.submit();
  }
</script>
<?php
$services = "Select asv.*, s.service_name, o.service_owner_first_name, o.service_owner_last_name,
        concat(o.service_owner_first_name ,' ', o.service_owner_last_name) owner_name
         from 
        account_services  asv
        left join services s on s.service_id = asv.account_services_service_id
        left join service_owner o on o.service_owner_id = account_services_service_owner_id
        where account_id=$account_id";$trs = "";
//echo $logins;

$showThisTab = "<script>showServiceTab();</script>";

if (isset($_POST['action'])) {
    $action = $_POST['action'];
}

switch ($action) {
    case "addService":
        service_add($con,$account_id);
        echo " &nbsp;&nbsp;<span></span>";
        echo "<script>toastr.success(\"Added\");</script>";
        echo $showThisTab;
        break;
    case "saveService":
        echo " &nbsp;&nbsp;<span></span>";
        echo $showThisTab;
        echo "<script>toastr.success(\"Saved\");</script>";
        service_save($con);
        break;
    case "deleteService":
        service_delete($con);
        echo " &nbsp;&nbsp;<span></span>";
        echo $showThisTab;
        echo "<script>toastr.success(\"Removed\");</script>";
        break;
    case "nada":
        break;

}




$res_services = $con->query($services);

echo mysqli_error($con);
while ($obj = $res_services->fetch_object()) {
    $trs .= "<form method='POST'><input type='hidden' name='action' value='deleteService'>";
    $trs .= "<input type='hidden' name='account_services_id' value='". $obj->account_services_id . "'>";
    $trs .= "<tr><td>".  $obj->service_name . "</td>";
    $trs .= "<td>".  $obj->owner_name . "</td>";
    $trs .= "<td><a target='_new' href='http://".  $obj->account_services_url . "'>" . $obj->account_services_url   . "  </a></td>";
    $trs .= "<td>$".  $obj->account_services_price . "</td>";
    $trs .= "<td>
              <button type='buton' class='btn btn-danger' onClick='delService(this.form," . $obj->account_services_id . ")'>Delete</button></td>";
    $trs .="</tr></form>";
    
    
}

?>
<div>
    <div>
       

    </div>

    <table class="table striped">
        <thead>
            <tr class="hdr">
            <th>
                Service
            </th>
            <th>
                Owner
            </th>
            <th>
                URL
            </th>
            <th>
                Price
            </th>
            <th>
                 
            </th>
        </tr>
        <tr>
            <form name="account_services_add" method="POST">
                <input type="hidden" name="action" value="addService">
            <td><select name="account_services_service_id" id="contact_first_name" class="form-control" required>
                <option value=""></option>
                <?=getOptions($con,'services', 'service_name','service_id')?>
                </select>
            </td>
            <td><select type="text" name="account_services_service_owner_id" id="contact_last_name" class="form-control">
                <option value=""></option>
                <?=getOptions($con,'vw_service_owner','service_owner_fullname' ,'service_owner_id')?>
            </select></td>
            <td><input type="text" name="account_services_url" id="account_services_url" required class="form-control"></td>
            <td><input type="text" name="account_services_price" id="account_services_price" class="form-control"></td>
            <td><input type="submit" class="btn btn-success" value="Save" onClick="addService()"></td>
        
        </form>
            
        </tr>
        </thead>
        
        <tbody>
            <?=$trs?>
        </tbody>

    </table>
</div>

<?php
function service_add($con,$account_id) {
    $add = "insert into account_services(account_id, 
            account_services_service_id, 
            account_services_service_owner_id, account_services_url, account_services_price)
    values(? , ? , ? , ?, ? )";
    $stmt = $con->prepare($add);
    echo mysqli_error($con);

    $stmt->bind_param("issss",$account_id,$account_services_service_id,$account_services_service_owner_id,
    $account_services_url, $account_services_price);
   
    $account_services_service_id = $_POST['account_services_service_id'];
    $account_services_service_owner_id = $_POST['account_services_service_owner_id'];
    $account_services_url = $_POST['account_services_url'];
    $account_services_price = $_POST['account_services_price'];
    
    $stmt->execute();
}
function service_delete($con) {
    $del = "delete from account_services where account_services_id = " . $_POST['account_services_id'];
    $con->query($del);
}
?>