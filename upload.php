<?php
   if(isset($_FILES['file'])){
      $errors= array();
      $file_name = $_FILES['file']['name'];
      $file_size = $_FILES['file']['size'];
      $file_tmp = $_FILES['file']['tmp_name'];
      $file_type = $_FILES['file']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
      $expensions= array("bin","gz","bin.gz","exe","zip","7z", "pdf", "doc", "docx", "xlsx", "pptx");
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a zip, 7z, bin, gz, bin.gz or exe file extension.";
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
<h1>Upload file</h1>
<p>Upload files compressed with descriptive name and filetype. e.g wcry.bin.gz</p>
<p>Accepted filetypes: .bin.gz, .gz, .bin, .zip, .7z, .exe (.exe NOT preferred)</p>
<form action="upload.php" method="post" enctype="multipart/form-data">
<input type="file" value="Filename" name="file">
<input type="submit" name="submit" value="Upload">
         <ul>
            <li>Sent file: <?php echo $_FILES['file']['name'];  ?>
            <li>File size: <?php echo $_FILES['file']['size'];  ?>
            <li>File type: <?php echo $_FILES['file']['type'] ?>
            <li>SHA265 Hash: <?php echo $hash ?>
         </ul>
<a href="http://localhost/malware_samples/">Back to File Index</a>
</form>
</html>
