<?php
class Setup_model extends CI_Model
{
	function runSQL($filename)
	{
		// Temporary variable, used to store current query
		$templine = '';

		// Read in entire file
		$lines = file($filename);
		
		// Loop through each line
		foreach ($lines as $line_num => $line) {
			// Only continue if it's not a comment
			if (substr($line, 0, 2) != '--' && $line != '') {
				// Add this line to the current segment
				$templine .= $line;
				// If it has a semicolon at the end, it's the end of the query
				if (substr(trim($line), -1, 1) == ';') {
					// Perform the query
					$this->db->query($templine) or print('Error performing query \'<b>' . $templine . '</b>\': ' . mysql_error() . '<br /><br />');
					// Reset temp variable to empty
					$templine = '';
				}
			}
		}
	}
}