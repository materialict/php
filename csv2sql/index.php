<?php 
/**
This is a two stage process this component shows the CSV files in the folder and the XLS2SQL.php process the csv.
*/

/* get the CSV files */
$files = glob("*.csv");

if (empty($files)){
	echo "No files to process!!";
} else {
	foreach($files as $file){
	?>
    	<a href="csv2sql.php?filename=<?php echo $file; ?>"><?php echo $file; ?></a>
	<?php
	}
}

?>