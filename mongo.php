<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json;charset=UTF-8');

class Monitor {
public $VirtualMemory_MB;
public $PageFaults;
public $CurrentConnections;
public $NetworkIO_In_MB;
public $NetworkIO_Out_MB;
public $SpeedIO_Avg_ms;
public $LockRatio_Per;
public $ReadersLocked;
public $WritersLocked;
public $ObjectsInDatabase;
public $DatabaseDataSize_MB;
public $DatabaseIndexSize_MB;
public $IndexMissRatio_Per;
public $CursorsTimedOut;
public $DeleteSelectRatio_Per;
public $InsertSelectRatio_Per;
public $UpdateSelectRatio_Per;
}

if (!isset($_REQUEST['db'])) {
header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
echo json_encode(array('status'=>0,'message'=>'db is missing'));
exit;
}
$databaseName = $_REQUEST['db'];


// connect
$m = new MongoClient();

// select a database
$db = $m->$databaseName;
$ret = $db->execute('db.stats();');

$result = new Monitor;
$result->ObjectsInDatabase = $ret["retval"]["objects"];
$result->DatabaseDataSize_MB = $ret["retval"]["dataSize"];
$result->DatabaseIndexSize_MB = $ret["retval"]["indexSize"];
//var_dump($ret);

$ret = $db->execute('db.serverStatus();');
$result->VirtualMemory_MB = $ret["retval"]["mem"]["virtual"];
$result->PageFaults = $ret["retval"]["extra_info"]["page_faults"];
$result->CurrentConnections = $ret["retval"]["connections"]["current"];
$result->NetworkIO_In_MB = $ret["retval"]["network"]["bytesIn"]/1000000;
$result->NetworkIO_Out_MB = $ret["retval"]["network"]["bytesOut"]/1000000;
$result->SpeedIO_Avg_ms = $ret["retval"]["backgroundFlushing"]["average_ms"];
$result->LockRatio_Per = $ret["retval"]["globalLock"]["lockTime"]/$ret["retval"]["globalLock"]["totalTime"]*100;
$result->ReadersLocked = $ret["retval"]["globalLock"]["currentQueue"]["readers"];
$result->WritersLocked = $ret["retval"]["globalLock"]["currentQueue"]["writers"];
$result->IndexMissRatio_Per = $ret["retval"]["indexCounters"]["btree"]["missRatio"];
$result->CursorsTimedOut = $ret["retval"]["cursors"]["timedOut"];
$result->DeleteSelectRatio_Per = $ret["retval"]["opcounters"]["delete"]/$ret["retval"]["opcounters"]["query"]*100;
$result->InsertSelectRatio_Per = $ret["retval"]["opcounters"]["insert"]/$ret["retval"]["opcounters"]["query"]*100;
$result->UpdateSelectRatio_Per = $ret["retval"]["opcounters"]["update"]/$ret["retval"]["opcounters"]["query"]*100;

echo json_encode($result);
?>