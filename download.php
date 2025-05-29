<?php
header("Cache-Control: max-age=3600, public");
header('Content-Type: application/json');

$dir = "downloads/";
$metadata_file = $dir . "metadata.json";
$allowed_extensions = ['pdf'];

// Read metadata
$display_names = file_exists($metadata_file) ? json_decode(file_get_contents($metadata_file), true) : [];

// Get valid PDF files
$safe_files = array_filter(array_diff(scandir($dir), ['.', '..', 'metadata.json']), function($file) use ($dir, $allowed_extensions) {
    $path = $dir . $file;
    return is_file($path) && 
           in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), $allowed_extensions);
});

// Output list of files with display names
$result = [];
foreach ($safe_files as $file) {
    $result[] = [
        "filename" => $file,
        "display" => $display_names[$file] ?? $file
    ];
}
echo json_encode($result);
?>
