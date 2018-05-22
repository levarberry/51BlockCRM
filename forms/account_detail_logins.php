<script>
  function addLogin() {
      toastr.success("Added Login....");
  }
  function showLoginTab() {
      $('#logins-tab').tab('show');
  }
</script>
<?php
$logins = "Select * from account_logins where account_id=$account_id";$trs = "";
//echo $logins;

if (isset($_POST['action'])) {
    $action = $_POST['action'];
}

switch ($action) {
    case "addLogin":
        login_add($con,$account_id);
        echo " &nbsp;&nbsp;<span></span>";
        echo "<script>toastr.success(\"Added Login\");</script>";
        echo "<script>showLoginTab();</script>";
        break;
    case "saveLogin":
        echo " &nbsp;&nbsp;<span></span>";
        echo "<script>toastr.success(\"Saved\");</script>";
        account_save($con);
        break;
    case "deleteLogin":
        account_delete($con);
        echo " &nbsp;&nbsp;<span></span>";
        echo "<script>toastr.success(\"Removed\");</script>";
        break;
    case "nada":
        break;

}




$res_logins = $con->query($logins);

echo mysqli_error($con);
while ($obj = $res_logins->fetch_object()) {
    $trs .= "<tr><td>".  $obj->account_login_name . "</td>";
    $trs .= "<td>".  $obj->account_login_url . "</td>";
    $trs .= "<td>".  $obj->account_login_username . "</td>";
    $trs .= "<td>".  $obj->account_login_password . "</td>";
    $trs .= "<td><button type='buton' class='btn btn-danger'>Delete</button></td>";
    $trs .="</tr>";
    
    
}

?>
<div>
    <div>
       

    </div>

    <table class="table striped">
        <thead>
            <tr class="hdr">
            <th>
                Login Name
            </th>
            <th>
                URL
            </th>
            <th>
                Username
            </th>
            <th>
                Password
            </th>
            <th>
                <button type="buton" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Add Login</button>
            </th>
        </tr>
        <tr>
            <form name="account_login_add" method="POST">
                <input type="hidden" name="action" value="addLogin">
            <td><input type="text" name="account_login_name" id="account_login_name" class="form-control"></td>
            <td><input type="text" name="account_login_url" id="account_login_url" class="form-control"></td>
            <td><input type="text" name="account_login_username" id="account_login_username" class="form-control"></td>
            <td><input type="text" name="account_login_password" id="account_login_password" class="form-control"></td>
            <td><input type="submit" class="btn btn-success" value="Save" onClick="addLogin()"></td>
        
        </form>
            
        </tr>
        </thead>
        
        <tbody>
            <?=$trs?>
        </tbody>

    </table>
</div>

<?php
function login_add($con,$account_id) {
    $addLogin = "insert into account_logins(account_id,account_login_name, account_login_url,account_login_username, account_login_password)
    values(? , ? , ? , ?, ? )";
    $stmt = $con->prepare($addLogin);
    echo mysqli_error($con);

    $stmt->bind_param("issss",$account_id,$account_login_name,$account_login_url,$account_login_username, $account_login_password);
   
    $account_login_name = $_POST['account_login_name'];
    $account_login_url = $_POST['account_login_url'];
    $account_login_username = $_POST['account_login_username'];
    $account_login_password = $_POST['account_login_password'];
    
    $stmt->execute();
}
?>