<?php
/* http://www.collegiumvocaleeindhoven.nl/nieuwsbrieven/nieuwsbrief.php
   Use url parameter latest=1 to automatically forward to the most recent newsletter.
   */

function scan_and_order_dir($dir) {
    $files = array();    
    foreach (scandir($dir) as $file) {
        $files[$file] = filemtime($dir . '/' . $file);
    }

    arsort($files);
    $files = array_keys($files);

    return ($files) ? $files : false;
}

$latest = false;
if ($_GET["latest"])
{
	$latest = true;
}
$files = scan_and_order_dir(".");
$output = "";
if ($files != false)
{
	$output = "<html><body>";
	foreach ($files as $filename) {
		if (preg_match("/Nieuwsbrief_(\w+)(\d{4})\.htm/", $filename, $regs))
		{
			if ($latest)
			{
				header("Location: http://www.collegiumvocaleeindhoven.nl/nieuwsbrieven/{$filename}");
				exit;
			}
			
			$month = $regs[1];
			$year = $regs[2];
			$output .= "<li><a href='{$filename}'>Nieuwsbrief {$month} {$year}</a></li>\n";
		}
	}
	$output .= "</body>";	
	echo $output;
}
?>

</body>