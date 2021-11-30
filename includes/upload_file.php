<?php
include "includes/config.php";
class UploadFile {
  private $con;
    function __construct($con) {
        $this->con = $con;
  }
  function uploadFile1($path,$fileTypes,$fileSize,$file) {
    $target_file = $path .uniqid().basename($_FILES["file1"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if(FALSE==array_search($imageFileType,$fileTypes)){
      $returnData['status']=FALSE;
      $returnData['message']="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      return $returnData;
    }
    // Check file size
    if ($_FILES["file1"]["size"] > ($fileSize*1000)) {
      $returnData['status']=FALSE;
      $returnData['message']="file Size Must less than ".$fileSize."KB";
      return $returnData;
    }
    if (move_uploaded_file($_FILES["file1"]["tmp_name"], $target_file)) {
        $returnData['status']=TRUE;
        $returnData['data']=["fileURL"=>$target_file];
        $returnData['message']="The file ". htmlspecialchars( basename( $_FILES["file1"]["name"])). " has been uploaded.";
        return $returnData;
      } else {
        $returnData['status']=FALSE;
        $returnData['message']="Sorry, there was an error uploading your file.";
        return $returnData;
      }
    }
    function get_name() {
      return $this->name;
    }
    function deleteFile($file_pointer){
        if (!unlink($file_pointer)) {
          $returnData['status']=true;
          $returnData['data']=["fileURL"=>$file_pointer];
          $returnData['message']="File has been deleted.";
          return $returnData;
        }
        else {
          $returnData['status']=false;
          $returnData['data']=["fileURL"=>$file_pointer];
          $returnData['message']="File has not been deleted.";
          return $returnData;
        }

    }
}
?>
<!DOCTYPE html>
<html>
<body>

<form action="" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="file1" id="file1">
  <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>
<?php
$target_dir = "files/";
$con=NULL;
$obj=new UploadFile($con);
if(isset($_POST['submit'])){
  $data=$obj->uploadFile1($target_dir,$types,500000,$_FILES['file1']);
  var_dump($data);
}
//var_dump($obj->deleteFile("../files/dummy/downlhkjhoad.png"));
?>