<?

/* CDBS Packages Index Page
 *
 * $Id: index.php,v 1.1 2003/12/12 17:27:50 asg Exp $
 */

//Include Credentials
include("../conf/conf.php");
?>

<html>
<head>
<title>The Debian CDBS Packages Project</title>
</head>
<body>
<hr />
<center>
	<table border='1'>
<?
//Connect to database or print a nice 'unavailable' message
if($dbh = mysql_connect($DBSERVER, $DBUSER, $DBPASS)) {

// echo the HTML Table Header
?>
	<tr>
		<th>Package Name</th>
		<th>Distribution</th>
		<th>Architecture</th>
		<th>Version</th>
	</tr>
<?

		//Select the database to use
		mysql_select_db($DATABASE, $dbh);


		// Performing SQL query
		$query = "
			SELECT 
				pkg_name,
				pkg_distro,
				pkg_arch,
				pkg_version,
				pkg_filename
			FROM
				packages
			ORDER BY
				pkg_distro,
				pkg_name
			";
						// Run the DB query or print a nice 'unavailable' message
						if($result = mysql_query($query)) {
							
								/* Used to partition listing by distro. Thankfully, 
								 * the ORDER BY returns them in a sane way (i.e.
								 * stable, testing, unstable )
								 * 
								 * :)
								 */
								$current_distro = "unknown";

								// Print results
								while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {

									// Check if we need a spacer
									if(!($line{'pkg_distro'} == $current_distro)) {
?>
	<tr>
		<td colspan='4'>&nbsp;&nbsp;</td>
	</tr>
<?
									}
									$current_distro = $line{'pkg_distro'};
?>
	<tr>
		<td><a href='<?echo $DLSTEM . "/" . $line{'pkg_filename'};?>'><?echo $line{'pkg_name'};?></a></td>
		<td align='center'><?echo $line{'pkg_distro'};?></td>
		<td align='center'><?echo $line{'pkg_arch'};?></td>
		<td><?echo $line{'pkg_version'};?></td>
	</tr>
<?
								}
						}

				// Free resultset
				mysql_free_result($result);

		// Closing connection
		mysql_close($dbh);
} else {
?>
	<tr><td colspan='4'>&nbsp;&nbsp;</td></tr>
	<tr><td colspan='4'>The <strong>package listing</strong> is currently unavailable</td></tr>
	<tr><td colspan='4'>&nbsp;&nbsp;</td></tr>
<?
}
?>
	</table>
</center>
<hr />
</body>
</html>
