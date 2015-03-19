<?php
class Setup_model extends CI_Model
{
	function runSQL($filename)
	{
		// Temporary variable, used to store current query
		$templine = '';
		
		// delimiter
		$delimiter = ";";

		// Read in entire file
		$lines = file($filename);
		
		// Loop through each line
		foreach ($lines as $line_num => $line) {
			$line = trim($line);
			
			// Only continue if it's not a comment
			if (strtoupper(substr($line, 0, 9)) == 'DELIMITER') {
				$delimiter = substr($line, -1, 1);
				//print "Line: ".$line." Changed delimited to ".$delimiter."<br>";
			}
			elseif (substr($line, 0, 2) != '--' && $line != '') {
				// Add this line to the current segment
				$templine .= ' '.$line;
				
				// If it has a delimiter at the end, it's the end of the query
				if (substr($line, -1, 1) == $delimiter) {
					// remove the delimiter
					$templine = rtrim($templine, $delimiter); 
					
					// Perform the query
					$this->db->query($templine) or print('Error performing query \'<b>' . $templine . '</b>\': ' . mysql_error() . '<br /><br />');
					// Reset temp variable to empty
					$templine = '';
				}
			}
			//echo "Delimiter: ".$delimiter.". SQL: ".$templine."<br>";
		}
	}
}