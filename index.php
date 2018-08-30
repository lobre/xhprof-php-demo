<?php

$GLOBALS['XHPROF_LIB_ROOT'] = '/var/www/xhprof/xhprof_lib';
require_once $GLOBALS['XHPROF_LIB_ROOT'].'/display/xhprof.php';

/* Start of profiling */
tideways_xhprof_enable(TIDEWAYS_XHPROF_FLAGS_MEMORY | TIDEWAYS_XHPROF_FLAGS_CPU);

function insertion_Sort($my_array) {
    for ($i = 0; $i < count($my_array); $i++) {
        $val = $my_array[$i];
        $j = $i - 1;
        while($j >= 0 && $my_array[$j] > $val) {
            $my_array[$j+1] = $my_array[$j];
            $j--;
        }
        $my_array[$j+1] = $val;
    }
    return $my_array;
}
$test_array = array(3, 0, 2, 5, -1, 4, 1);
echo "Original Array :\n";
echo implode(', ',$test_array);
echo "\nSorted Array :\n";
print_r(insertion_Sort($test_array));

/* End of profiling */
$xhprofData = tideways_xhprof_disable();

$profilerNamespace = 'test';

$xhprofRuns = new XHProfRuns_Default('/tmp');
$runId = $xhprofRuns->save_run($xhprofData, $profilerNamespace);

$profilerUrl = sprintf(
 'http://localhost:8081/index.php?run=%s&source=%s',
 $runId,
 $profilerNamespace
);

echo "<br><br><a href='$profilerUrl'>Link to profiling</a>";
?>
