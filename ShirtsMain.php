<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('includes/head.inc.php');

$school_name = PHPSession::Instance()->GetSessionVariable('school_name');
$school_id   = PHPSession::Instance()->GetSessionVariable('school_id');
$role        = PHPSession::Instance()->GetSessionVariable('role');
$collect_shirt_order = PHPSession::Instance()->GetSessionVariable ('collect_shirt_info');


$status_msg = "";
if (isset($_REQUEST['status_msg']) && strlen($_REQUEST['status_msg'])) 
{
    $status_msg = $_REQUEST['status_msg'];
}


function DisplayStatusMessage($status_msg) 
{   
    if (isset($status_msg) && strlen($status_msg)) 
    {
        echo "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">";
        echo "<span aria-hidden=\"true\">&times;</span></button>";
        echo $status_msg;
        echo "</div>";
    }
}

?>

<body>

<?php 
require_once('includes/navbar.inc.php'); 
OutputNavBar("Shirts");
?>

<br/>

<?php 
if ($role == "admin")
{
?>

<div class="container">
<div class="panel panel-primary">
<div class="panel-heading">Shirt Orders Per School</div>
<div class="panel-body">
    <div class="row">
        <div class="col-xs-12">
            <?php DisplayStatusMessage($status_msg); ?>
            <div class="table-responsive">
                <table class="table table-condensed table-bordered table-hover set-bg" id="sortable-table">
                    <thead>
                        <tr>
                            <!-- <th>School ID</th> -->
                            <th>School Name</th>
                            <th>Youth MD</th>
                            <th>Youth LG</th>
                            <th>Adult SM</th>
                            <th>Adult MD</th>
                            <th>Adult LG</th>
                            <th>Adult XL</th>
                            <th>Adult XXL</th>
                            <th>Change</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $event_db = PHPSession::Instance()->GetSessionVariable('event_db'); 
                            $school_shirt_listing = ReadShirtsAllSchools($event_db, $last_error);
                            $total_youth_medium = $total_youth_large = $total_adult_small =
                                $total_adult_medium = $total_adult_large = $total_adult_xlarge = 
                                $total_adult_xxlarge = $total = 0;
                            foreach ($school_shirt_listing as $s) 
                            {
                                $school_id          = $s['school_id'];
                                if ($school_id != 0) 
                                {                                    
                                    $school_name        = $s['school_name'];      
                                    $num_youth_medium   = $s['num_youth_medium']; $total_youth_medium  += $num_youth_medium;
                                    $num_youth_large    = $s['num_youth_large'];  $total_youth_large   += $num_youth_large;
                                    $num_adult_small    = $s['num_adult_small'];  $total_adult_small   += $num_adult_small; 
                                    $num_adult_medium   = $s['num_adult_medium']; $total_adult_medium  += $num_adult_medium;
                                    $num_adult_large    = $s['num_adult_large'];  $total_adult_large   += $num_adult_large;
                                    $num_adult_xlarge   = $s['num_adult_xl'];     $total_adult_xlarge  += $num_adult_xlarge;
                                    $num_adult_xxlarge  = $s['num_adult_xxl'];    $total_adult_xxlarge += $num_adult_xxlarge;

                                    echo "<tr>";
                                    /* echo "<td>" . $school_id . "</td>"; */
                                    echo "<td>" . $school_name   . "</td>";
                                    echo "<td>" . $num_youth_medium . "</td>";
                                    echo "<td>" . $num_youth_large . "</span></td>";
                                    echo "<td>" . $num_adult_small . "</td>";
                                    echo "<td>" . $num_adult_medium . "</td>";
                                    echo "<td>" . $num_adult_large . "</td>";
                                    echo "<td>" . $num_adult_xlarge . "</td>";
                                    echo "<td>" . $num_adult_xxlarge . "</td>";
                                    echo "<td>" . "<a class=\"btn btn-primary btn-xs\" href=\"ShirtsModifyForm.php?school_id=$school_id\">Change</a>" . "</td>";
                                    echo "</tr>";
                                }
                            }
                            $total = $total_youth_medium + $total_youth_large + $total_adult_small + 
                                        $total_adult_medium + $total_adult_large + $total_adult_xlarge + $total_adult_xxlarge;
                        ?>
                        <td>Totals</td>
                        <th><span id="total_youth_md"  class="badge">?</span></th>
                        <th><span id="total_youth_lg"  class="badge">?</span></th>
                        <th><span id="total_adult_sm"  class="badge">?</span></th>
                        <th><span id="total_adult_md"  class="badge">?</span></th>
                        <th><span id="total_adult_lg"  class="badge">?</span></th>
                        <th><span id="total_adult_xl"  class="badge">?</span></th>
                        <th><span id="total_adult_xxl" class="badge">?</span></th>
                        <th><span id="total_shirts"    class="badge"></span></th>
                    </tbody>
                    <script>
                        /* Update the total user and runner counts in the table header */
                        span = document.getElementById("total_youth_md");
                        txt_node = document.createTextNode("<?php echo $total_youth_medium;?>");
                        span.innerText = txt_node.textContent;

                        span = document.getElementById("total_youth_lg");
                        txt_node = document.createTextNode("<?php echo $total_youth_large;?>");
                        span.innerText = txt_node.textContent;

                        span = document.getElementById("total_adult_sm");
                        txt_node = document.createTextNode("<?php echo $total_adult_small;?>");
                        span.innerText = txt_node.textContent;

                        span = document.getElementById("total_adult_md");
                        txt_node = document.createTextNode("<?php echo $total_adult_medium;?>");
                        span.innerText = txt_node.textContent;

                        span = document.getElementById("total_adult_lg");
                        txt_node = document.createTextNode("<?php echo $total_adult_large;?>");
                        span.innerText = txt_node.textContent;

                        span = document.getElementById("total_adult_xl");
                        txt_node = document.createTextNode("<?php echo $total_adult_xlarge;?>");
                        span.innerText = txt_node.textContent;

                        span = document.getElementById("total_adult_xxl");
                        txt_node = document.createTextNode("<?php echo $total_adult_xxlarge;?>");
                        span.innerText = txt_node.textContent;

                    </script>
                </table>
            </div>
        </div>
    </div>
</div> <!-- panel-body -->
</div> <!-- panel default -->
</div>

<?php 
} else if (!$collect_shirt_order) {
?>

<div class="container">
<div class="panel panel-primary">
<div class="panel-heading">Shirt Order</div>
<div class="panel-body">
<?php DisplayStatusMessage("Shirt Orders for this event are not accepted through this website!"); ?>
</div>
</div> <!-- panel-body -->
</div> <!-- panel default -->
</div>

<?php 
} else {
?>


<div class="container">
<div class="panel panel-primary">
<div class="panel-heading">Current Shirt Order</div>
<div class="panel-body">
    <div class="row">
        <div class="col-xs-12">
            <?php DisplayStatusMessage($status_msg); ?>
            <div class="table-responsive">
                <table class="table table-condensed table-bordered table-hover set-bg" id="sortable-table">
                    <thead>
                        <tr>
                            <!-- <th>School ID</th> -->
                            <th>School Name</th>
                            <th>Youth MD</th>
                            <th>Youth LG</th>
                            <th>Adult SM</th>
                            <th>Adult MD</th>
                            <th>Adult LG</th>
                            <th>Adult XL</th>
                            <th>Adult XXL</th>
                            <th>Change</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $event_db = PHPSession::Instance()->GetSessionVariable('event_db'); 
                            $school_name = PHPSession::Instance()->GetSessionVariable('school_name');    

                            $s = ReadShirtsBySchoolId($event_db, $school_id, $last_error);

                            $num_youth_medium   = $s['num_youth_medium']; 
                            $num_youth_large    = $s['num_youth_large']; 
                            $num_adult_small    = $s['num_adult_small'];
                            $num_adult_medium   = $s['num_adult_medium'];
                            $num_adult_large    = $s['num_adult_large']; 
                            $num_adult_xlarge   = $s['num_adult_xl'];
                            $num_adult_xxlarge  = $s['num_adult_xxl']; 

                            echo "<tr>";
                            /* echo "<td>" . $school_id . "</td>"; */
                            echo "<td>" . $school_name   . "</td>";
                            echo "<td>" . $num_youth_medium . "</td>";
                            echo "<td>" . $num_youth_large . "</span></td>";
                            echo "<td>" . $num_adult_small . "</td>";
                            echo "<td>" . $num_adult_medium . "</td>";
                            echo "<td>" . $num_adult_large . "</td>";
                            echo "<td>" . $num_adult_xlarge . "</td>";
                            echo "<td>" . $num_adult_xxlarge . "</td>";
                            echo "<td>" . "<a class=\"btn btn-primary btn-xs\" href=\"ShirtsModifyForm.php?school_id=$school_id\">Change</a>" . "</td>";
                            echo "</tr>";
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> <!-- panel-body -->
</div> <!-- panel default -->
</div>

<?php
}
?>

<?php 
require_once('includes/footer.inc.php'); 
?>