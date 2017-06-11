<?php

$row = 1;
$fb_data = array();
$final_data = array();

// Store all csv data in an array
if (($file = fopen("dataset_Facebook.csv", "r")) !== FALSE) {

    while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
        
    	$fb_data[] = $data;
    	
    }

    fclose($file);

}

// Store column name in seperate array
// And rest of the records in another array
$column_names = array_shift($fb_data); // remove first element


// Gnerate key => value pair where column names are keys and records are its values
foreach ($fb_data as $key => $value) {

	$final_data[] = array_combine($column_names, $value);

}

// Add label '-' if no. of likes is less than 100 else add '+'
foreach ($final_data as $key => $value) {
	
	if ($value['like'] < 100) {

		$final_data[$key]['Label'] = '-';

	} else {

		$final_data[$key]['Label'] = '+';

	}

}

// Add 'Label' as last element in $column_names array
array_push($column_names, 'Label');

function outputCSV($column_names, $data) {

	header("Content-type: text/csv");
	header("Content-Disposition: attachment; filename=file.csv");
	  
	$output = fopen("php://output", "w");

	// Put column names in csv comma separated
	fputcsv($output, $column_names, ',');

	foreach ($data as $row) {

		// Put each record in csv comma separated
		fputcsv($output, $row, ','); // here delimiter/enclosure can be changed

	}

	fclose($output);
}

outputCSV($column_names, $final_data);
?>