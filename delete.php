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
                        $files[$file][] = $innerfile;
                }
            }
        } else{
          $arr = explode('.', $file);
            $files[] = $file;
        }
    }
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="./style.css" media="all"/>
<title>Malware Upload</title>
</head>
<body>
<h1>Upload file</h1>
<div class="general">
<table>
<b>Files</b>
<?php foreach ($files as $file) { echo "<tr><td><a href=\"./delete.php?file=".$file."\">".$file."</a></td></tr>";} ?><br>
</table>
<br>
<br>
<b>Menu</b>
<a href="./index.php">Back to Home</a><br>
<a href="./__sample.index">View File Index</a><br>
<a href="./delete.php">Delete files</a>
</form>
</div>
</body>
</html>

