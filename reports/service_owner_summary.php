<?include_once '../header.php'?>

<?php
    $sql ="select service_owner_fullname , count(*) CNTPER 
         FROM vw_service_owner
         inner join account_services asr on asr.account_services_service_owner_id = service_owner_id
         Group by service_owner_fullname";
    $rpt = $con->query($sql);

    echo mysqli_error($con);
    

    //var_dump($objs);
?><h4> Service Owner Summary </h4>
   <table class="table table-striped" width="50%">
       <tr>
           <th> Owner Name</th>
           <th> #</th>
</tr>
       <?php
    while ($objs = $rpt->fetch_object()) {
        echo "<tr><td>" . $objs->service_owner_fullname . "</td><td>" . $objs->CNTPER   . "</td></tr>";
    }
    ?>
    </table>