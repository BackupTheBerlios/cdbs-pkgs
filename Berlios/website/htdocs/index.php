<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?

/* CDBS Packages Index Page
 *
 * $Id: index.php,v 1.4 2003/12/13 00:19:55 asg Exp $
 */

//Include Credentials
include("./conf/conf.php");
?>
<html>
<head>
<title>The Debian CDBS Packages Project</title>
</head>
<body>
<p>
<h1>The Debian CDBS Packages Project</h1>
</p>
<p>
This is the homepage for the Debian CDBS Packages Project. The following packages are available for download by clicking on their name. 
</p>
<table border='0'>
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
<p>
Alternately, you can use the following <strong>apt</strong> sources.
</p>
<p>
<i>deb http://cdbs-pkgs.berlios.de/debian/ stable main contrib non-free</i><br />
<i>deb http://cdbs-pkgs.berlios.de/debian/ testing main contrib non-free</i><br />
<i>deb http://cdbs-pkgs.berlios.de/debian/ unstable main contrib non-free</i><br />
</p>
<hr />
<div align='left'>
	Copyright &copy; 2003-2004 <a href='mailto:beta3@users.berlios.de'>Dan Weber</a>
</div>
<div align='right'>
	Hosted By<br />
	<a href='http://developer.berlios.de'>
		<img src='http://developer.berlios.de/bslogo.php?group_id=0&type=1' width='124' height='32' border='0' alt='BerliOS Logo' />
	</a>
</div>
</body>
</html>
