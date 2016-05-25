 <?php

$onerecord = new \stdClass();
$onerecord->ids = [1,2,3];
$onerecord->gradations=[];
$gr1 = new \stdClass();
$gr1->price=0.15;
$gr1->from=100;
$gr1->to=300;
$onerecord->gradations[] = $gr1;
$gr2 = new \stdClass();
$gr2->price=0.17;
$gr2->from=300;
$gr2->to=500;
$onerecord->gradations[] = $gr2;
$encodedData = json_encode($onerecord);

echo $encodedData.PHP_EOL;

?>