<?PHP

$file_handle = fopen("mutualfund.csv", "r");

while (!feof($file_handle) ) {

$line_of_text = fgetcsv($file_handle, 874);

print $line_of_text[0] . $line_of_text[1]. $line_of_text[2] . "<BR>";

}

fclose($file_handle);

?>
