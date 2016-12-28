<?
include(dirname(FILE) . DIRECTORY_SEPARATOR . 'THSplitLib/segment.php');

$segment = new Segment();

$result = $segment->get_segment_array("คำที่ต้องการตัด");

echo implode(' | ', $result);

?>
