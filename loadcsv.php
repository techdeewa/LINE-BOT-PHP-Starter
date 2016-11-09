<?PHP

$file_handle = fopen("mutualfund.csv", "r");

while (!feof($file_handle) ) {

$line_of_text = fgetcsv($file_handle, 874);

print "FUND : " . $line_of_text[0] . "<BR>";
print "NAME : " . $line_of_text[2] . "<BR>";
print "CODE : " . $line_of_text[3] . "<BR>";
print "ASSET : " . $line_of_text[4] . "<BR>";
print "NAV  " . $line_of_text[5] . "<BR>";
print "======================================================================" . "<BR>";  
}

fclose($file_handle);

?>
