<?php 

require_once('includes/checkLogin.inc.php'); // session is started in here
require_once('classes/DBAccess.php');

// 
// var_dump($_REQUEST); exit;

function PrintRunnersCSV($runners)
{
	// Open up a file pointer to stdout so that I can use fputcsv();
	// fputcsv handles cases where there's a common in the input.
	$fp = fopen('php://output', 'w');

	if (empty($runners)) {
		fprintf($fp, "<pre>\n");
		fprintf($fp, "No Runners found!\n");
		fprintf($fp, "</pre>\n");
		return;
	}

	fprintf($fp, "<pre>\n");
	fprintf($fp, "Event, School, First, Last, Grade, Sex, Race\n");
	foreach ($runners as $r)
	{
		$line = array($r['event_name'], $r['school_name'], $r['first_name'], $r['last_name'], $r['grade'], $r['sex'], $r['race_description']);
		fputcsv($fp, $line, ",");
	}
	fprintf($fp, "</pre>");
	fclose($fp);
	return;
}


function PrintRunnersTable($runners)
{
	$event_name = PHPSession::Instance()->GetSessionVariable('event_name');
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
		<h2>School Listing for Event: $event_name</h2>
		<table>
			<thead>
				<tr>
					<td>Count</td>
					<td>School</td>
					<td>First Name</td>
					<td>Last Name</td>
					<td>Grade</td>
               <td>Sex</td>
               <td>Race</td>
				</tr>
			</thead>
			<tbody>
EOT;

	$k = 0;
	foreach ($runners as $r)
	{
		$k++;
		$school_name = $r['school_name'];
		$first_name = $r['first_name'];
		$last_name = $r['last_name'];
		$grade = $r['grade'];
      $sex = $r['sex'];
      $race = $r['race_description'];
		print <<< EOT
			<tr>
				<td>$k</td>
				<td>$school_name</td>
				<td>$first_name</td>
				<td>$last_name</td>
				<td>$grade</td>
            <td>$sex</td>
            <td>$race</td>
			</tr>
EOT;
	} 
	print <<< EOT
		</tbody>
		</table>
		</body>
		</html>
EOT;

}

if ($_REQUEST['button'] == "print")
{
	$last_error = "";
	$event_id 	= PHPSession::Instance()->GetSessionVariable('event_db'); 
	$role 		= PHPSession::Instance()->GetSessionVariable('role');
	$school_id 	= PHPSession::Instance()->GetSessionVariable('school_id');

   $runners = GetRunnerListing();
	
	switch ($_REQUEST['format']) {
		case "csv":
			PrintRunnersCSV($runners);
			break;
		case "table":
		default:
			PrintRunnersTable($runners);
			break;
	}
	
	//header("location: RunnersMain.php");
	exit;
}

header("location: RunnersMain.php");
exit;
?>