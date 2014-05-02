<?php 
/* init */
$filename 		= $_GET['filename'];
$tablename		= substr($filename, 0, strlen($filename) -4);
$sqlFilename	= $tablename . ".sql";
$htmlHeaders	= null;
$sqlRecords		= null; 
$sql			= null;
//$mysqli			= new MySQLi("localhost", "my_user", "my_password", "world");

if (!empty($filename)){
	$file = file($filename);
	
	/* process the component */
	$i = 0;
	foreach ($file as &$line) {
    	$line = explode(';', trim($line));
		
		/* remove the eol */
		$line = preg_replace('/\r\n|\r|\n/', ' ', $line);
		
		if ($i ==0){
			file_put_contents("first.txt", $line);
			
			$sql 			= "`" . implode("`, `", $line) . "`";
			$sql			= "INSERT INTO `$tablename` ($sql) VALUES ";

			$htmlHeaders	= "<th>" . implode("</th><th>", $line) . "</th>";

		} else {
			/* create the rows */
			$sqlRecord 	= null;
			$htmlRow 	= null;
			foreach ($line as $cell){
				if (strlen($cell) > 40){
					$htmlRow	.= "<td>" . substr($cell,0,40) . "...</td>";					
				} else {
					$htmlRow	.= "<td>$cell</td>";					
				}
				
				/* sql string */
				/* 0 is recognized as null */
				if (empty($cell) && !is_numeric($cell)){					
					$cell = "null";
				} else {
					if (!is_numeric($cell)){
						/* do some escaping. Cnt use the mysqli->real_escape_string because i have no db connection */
						$cell = str_replace("'", "\\'", $cell);
						
						$cell = "'" . $cell . "'";
					}
				}
				if (empty($sqlRecord)){
					$sqlRecord = $cell;				
				} else {
					$sqlRecord .= ", " . $cell;				
				}
				
			}
			$htmlRows[$i - 1]		= $htmlRow;

			$sqlRecord = "(" . $sqlRecord . ")";
			$sqlRecords[$i - 1]		= $sqlRecord;
		}
		$i++;
	}	
	
	/* display the table */
	?>
	<table>
		<tr>
        	<?php echo $htmlHeaders; ?>
        </tr>
		<?php
		foreach ($htmlRows as $htmlRow){
			echo "<tr>" . $htmlRow . "</tr>";
		}
		?>
    </table>
	<?php

	/* create an sql file */
	foreach($sqlRecords as $sqlRecord){
		if (empty($sqlRows)){
			$sqlRows = $sqlRecord;
		} else {
			$sqlRows .= ", " . $sqlRecord ;
		}
	}
	$sql .= $sqlRows . ";";
	
	/* dump it */
	file_put_contents($sqlFilename, $sql);
//	file_put_contents($sqlFilename, $sqlRecords);
		
	
}
?>
