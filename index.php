<?php
   if(isset($_FILES['file'])){
      $errors= array();
      $file_name = $_FILES['file']['name'];
      $file_size = $_FILES['file']['size'];
      $file_tmp = $_FILES['file']['tmp_name'];
      $file_type = $_FILES['file']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
      $expensions= array("bin","gz","bin.gz","zip","7z", "pdf", "doc", "docx", "xlsx", "pptx");
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a zip, 7z, bin, gz, bin.gz, doc, pdf, xlsx, pptx file extension.";
      }
      if(empty($errors)==true) {
         move_uploaded_file($file_tmp,"./uploaded_samples/".$file_name);
         $filepath = "./uploaded_samples/".$file_name;
         $sampleindex = "__sample.index";
         $hash = hash_file('sha256', $filepath);
         $current = file_get_contents($sampleindex);
         $current .= $file_name." ".$hash."\n";
         file_put_contents($sampleindex, $current);
      }else{
         print_r($errors);
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
<p>Accepted filetypes: .bin.gz, .gz, .bin, .zip, .7z, .exe (.exe NOT preferred)</p>
<form action="index.php" method="post" enctype="multipart/form-data">
<input type="file" value="Filename" name="file">
<input type="submit" name="submit" value="Upload">
         <ul>
            <li>Sent file: <?php echo $_FILES['file']['name'];  ?>
            <li>File size: <?php echo $_FILES['file']['size'];  ?>
            <li>File type: <?php echo $_FILES['file']['type'] ?>
            <li>SHA265 Hash: <?php echo $hash ?>
         </ul>
<a href="./uploaded_samples/">Back to File Index</a><br>
<a href="./__sample.index">View File Index</a><br>
<a href="./delete.php">Delete files</a>
</form>
</div>
</body>
</html>

