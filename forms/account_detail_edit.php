<div id="account_add">
    <div class="content">
    <form method="POST">
        <input type="hidden" name="action" value="save">
        <input type="hidden" name="account_id" value="<?=$account_id?>">
        <div class="form-group">
            <label for="acct_name">Account Name</label>
            <input class="form-control" required id="acct_name" name="account_name" id="acct_name" value="<?=$account->account_name?>">
        </div>
        <div class="form-group">
            <label for="acct_name">Agency</label>
            <select class="form-control" required id="acct_name" name="account_agency_id">
                <option value=""></option>
                <?=getOptionsSelected($con,'agencies', 'agency_name','agency_id', $account->account_agency_id)?>
            </select>
        </div>

        <div class="form-group">
            <label for="acct_name">Parent Account</label>
            <select class="form-control"  id="acct_name" name="account_parent_id">
            <option value=""></option>
                <?=getOptionsSelected($con,'accounts', 'account_name','account_id',$account->account_parent_id)?>
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
        </div>
 

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