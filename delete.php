<?php
if(isset($_GET['file'])){
$delfile = $_GET['file'];
echo $delfile;
unlink("uploaded_samples/".$delfile);
header('Location: delete.php');
exit;
die;
}

$dir = '/var/www/html/uploaded_samples/'; //irectory to pull from
$skip = array('.','..'); //a few directories to ignore

$dp = opendir($dir); //open a connection to the directory
$files = array();

if ($dp) {
    while ($file = readdir($dp)) {
        if (in_array($file, $skip)) continue;
        if (is_dir("$dir$file")) {
            $innerdp = opendir("$dir$file");
            if ($innerdp) {
                while ($innerfile = readdir($innerdp)) {
                    if (in_array($innerfile, $skip)) continue;
                    $arr = explode('.', $innerfile);
                    if (strtolower($arr[count($arr) - 1]) == 'bin') {
                        $files[$file][] = $innerfile;
                    }
                }
            }
        } else{
          $arr = explode('.', $file);
          if (strtolower($arr[count($arr) - 1]) == 'bin') {
            $files[] = $file;
          }
        }
    }
}
?>
<table>
<?php foreach ($files as $file) { echo "<tr><td><a href=\"./delete.php?file=".$file."\">".$file."</a></td></tr>";} ?><br>
<a href="/index.php">Back to Home</a>
</table>



