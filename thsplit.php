<?php


include(dirname(FILE) . DIRECTORY_SEPARATOR . 'THSplitLib/segment.php');

echo "Start";


$segment = new Segment();

//var_dump($segment);

$result = $segment->get_segment_array("คำที่ต้องการตัด");


echo implode(' | ', $result);

?>
