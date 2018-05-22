<script>
  function addContact() {
      toastr.success("Added Contact....");
  }
  function showContactTab() {
      $('#contacts-tab').tab('show');
  }
  function delContact(frm,id){
      frm.submit();
  }
</script>
<?php
$logins = "Select * from contacts where account_id=$account_id";
$trs = "";
$showThisTab = "<script>showContactTab();</script>";
//echo $logins;

if (isset($_POST['action'])) {
    $action = $_POST['action'];
}

switch ($action) {
    case "addContact":
        contact_add($con,$account_id);
        echo " &nbsp;&nbsp;<span></span>";
        echo "<script>toastr.success(\"Added Login\");</script>";
        echo $showThisTab;
        break;
    case "saveContact":
        echo " &nbsp;&nbsp;<span></span>";
        echo "<script>toastr.success(\"Saved\");</script>";
        echo $showThisTab;
        account_save($con);
        break;
    case "deleteContact":
        echo $showThisTab;
        contact_delete($con);
        echo " &nbsp;&nbsp;<span></span>";
        echo "<script>toastr.success(\"Removed\");</script>";
        break;
    case "nada":
        break;

}




$res_logins = $con->query($logins);

echo mysqli_error($con);
while ($obj = $res_logins->fetch_object()) {
    $trs .= "<form method='POST'><input type='hidden' name='action' value='deleteContact'>";
    $trs .= "<input type='hidden' name='contact_id' value='". $obj->contact_id . "'>";
    $trs .= "<tr><td>" .  $obj->contact_first_name . "</td>";
    $trs .= "<td>".  $obj->contact_last_name . "</td>";
    $trs .= "<td>".  $obj->contact_phone . "</td>";
    $trs .= "<td>".  $obj->contact_email . "</td>";
    $trs .= "<td><button type='buton' class='btn btn-danger' onClick='delContact(this.form," . $obj->contact_id . ")'>Delete</button></td>";
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
                First Name
            </th>
            <th>
                Last Name
            </th>
            <th>
                Phone
            </th>
            <th>
                Email
            </th>
            <th>
                <button type="buton" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Add </button>
            </th>
        </tr>
        <tr>
            <form name="account_login_add" method="POST">
                <input type="hidden" name="action" value="addContact">
            <td><input type="text" name="contact_first_name" id="contact_first_name" class="form-control"></td>
            <td><input type="text" name="contact_last_name" id="contact_last_name" class="form-control"></td>
            <td><input type="text" name="contact_phone" id="contact_phone" class="form-control"></td>
            <td><input type="text" name="contact_email" id="contact_email" class="form-control"></td>
            <td><input type="submit" class="btn btn-success" value="Save" onClick="addContact()"></td>
        
        </form>
            
        </tr>
        </thead>
        
        <tbody>
            <?=$trs?>
        </tbody>

    </table>
</div>

<?php
function contact_add($con,$account_id) {
    $add = "insert into contacts(account_id,contact_first_name, contact_last_name,contact_phone, contact_email)
    values(? , ? , ? , ?, ? )";
    $stmt = $con->prepare($add);
    echo mysqli_error($con);

    $stmt->bind_param("issss",$account_id,$contact_first_name,$contact_last_name,$contact_phone, $contact_email);
   
    $contact_first_name = $_POST['contact_first_name'];
    $contact_last_name = $_POST['contact_last_name'];
    $contact_phone = $_POST['contact_phone'];
    $contact_email = $_POST['contact_email'];
    
    $stmt->execute();
}
function contact_delete($con) {
    $del = "delete from contacts where contact_id = " . $_POST['contact_id'];
    $con->query($del);
}
?>