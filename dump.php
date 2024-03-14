<?php

if ($argc !== 4) {
    echo "Usage: php dump_memory.php [PID] [startIndex] [endIndex]\n";
    exit(1);
}

$pid = $argv[1];
$startIndex = hexdec($argv[2]);
$endIndex = hexdec($argv[3]);
$size = $endIndex - $startIndex;

$memPath = "/proc/${pid}/mem";
$dumpFile = "memory_dump_${pid}.bin";

// Open the memory file of the process
$memHandle = fopen($memPath, 'rb');

if (!$memHandle) {
    echo "Failed to open memory of process ${pid}.\n";
    exit(1);
}

// Seek to the start index
fseek($memHandle, $startIndex);

// Read the memory region
$memoryContent = fread($memHandle, $size);

// Close the handle
fclose($memHandle);

// Write the memory content to a file
file_put_contents($dumpFile, $memoryContent);

echo "Memory dump completed: ${dumpFile}\n";
