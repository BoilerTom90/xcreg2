<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('classes/DBAccess.php');
require_once('includes/adminusercheck.inc.php');


function PrintSchoolsTableFormat($schools)
{
	print <<< EOT
		<!DOCTYPE html>
		<html>
			<head>
				<style>
					table {
    					border-collapse: collapse;
					}

					table, th, td {
		    			border: 1pt solid black;
					}

					td {
    					padding: 10px;
					}
				</style>
			</head>
		<body>
		<h2>School Listing</h2>
		<table>
			<thead>
				<tr>
					<td>Count</td>
					<td>School ID</td>
					<td>School Name</td>
					<td>#Females<br><em><small>All Events</small></em></td>
					<td>#Males<br><em><small>All Events</small></em></td>
					<td>Total<br><em><small>All Events</small></em></td>
				</tr>
			</thead>
			<tbody>
EOT;

	$k = 0; 
	$total_females = 0;
   $total_males = 0;
   $runnersObj = new RunnersTable();
	foreach ($schools as $school)
	{
		$school_id = $school['id'];
		if ($school_id > 0) { // skip the admin school 
			$k++;
         $school_name = $school['name'];
         $girlRecs = $runnersObj->ReadBySchoolAndSex($school_id, RunnerSexValues::Girl);
         $boyRecs = $runnersObj->ReadBySchoolAndSex($school_id, RunnerSexValues::Boy);
         //var_dump($girlRecs); var_dump($boyRecs); exit;
			
			$num_females = empty($girlRecs) ? 0 : count($girlRecs);
         $num_males = empty($boyRecs) ? 0 : count($boyRecs);
			$total = $num_females + $num_males;
			$total_females += $num_females;
			$total_males += $num_males;

			print <<< EOT
				<tr>
					<td>$k</td>
					<td>$school_id</td>
					<td>$school_name</td>
					<td>$num_females</td>
					<td>$num_males</td>
					<td>$total</td>
				</tr>
EOT;
		}

	}

	$total = $total_females + $total_males;
	print <<< EOT
		<tr>
			<td colspan=3>Totals <em><small>All Events</small></em></td>
			<td>$total_females</td>
			<td>$total_males</td>
			<td>$total</td>
		</tr>
EOT;

	print <<< EOT
		</tbody>
		</table>
		</body>
		</html>
EOT;

}

$schoolsObj = new SchoolsTable();
$schools = $schoolsObj->ReadAll();
PrintSchoolsTableFormat($schools);

exit;
?>