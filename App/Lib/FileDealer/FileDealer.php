<?php
namespace App\Lib\FileDealer;
class FileDealer
{
    public function uploadMedia(string $folder, int $id)
    {   
        if (isset($_FILES["pictures"])) {
            $urls=[];

            $targetDir = "/uploads/";
            foreach ($_FILES["pictures"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $fileExtensionsAllowed = ['jpeg', 'jpg', 'png'];
                    
                    $errors = [];
                    $fileName = $_FILES['pictures']['name'][$key];
                    $fileTmpName = $_FILES['pictures']['tmp_name'][$key];
                    $uploadOk = 1;
                    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    $targetName=$folder. "-" . $id . "-" . $key ;
                    $targetFile = __DIR__.$targetDir . $folder ."/".hash("sha256",$targetName). ".".$fileExtension;


                    $check = getimagesize($_FILES["pictures"]["tmp_name"][$key]);
                    if ($check !== false) {
                        echo "File is an image - " . $check["mime"] . ".";
                        $uploadOk = 1;
                    } else {
                        $errors[] = "File is not an image";
                        $uploadOk = 0;
                    }


                    if ($_FILES["pictures"]["size"][$key] > 5000000) {
                        $errors[] = "Sorry, your file is too large.";
                        $uploadOk = 0;
                    }

                    if (!in_array($fileExtension, $fileExtensionsAllowed)) {
                        $errors[] = "Sorry, only JPG, JPEG & PNG files are allowed.";
                        $uploadOk = 0;
                    }

                    if (empty($errors)) {
                        $didUpload = move_uploaded_file($fileTmpName, $targetFile);

                        if ($didUpload) {
                            echo "The file " . basename($fileName) . " has been uploaded";
                            $urls[]=$targetFile;
                        } else {
                            echo "An error occurred. Please contact the administrator.";
                        }
                    } else {
                        foreach ($errors as $error) {
                            echo $error . "These are the errors" . "\n";
                        }
                    }
                }
                
            }
        }
        return $urls;

    }

}