<?php
require("config.php");
require("safe.php");

if(isset($_GET['post'])) {
  $allowedExts = array("jpg", "jpeg", "gif", "png", "mp3", "mp4", "wma", "PNG", "JPG", "JPEG", "FLV", "flv", "MOV", "mov", "MP4", "avi", "AVI");
  $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
  
  if ((($_FILES["file"]["type"] == "video/mp4")
  || ($_FILES["file"]["type"] == "audio/mp3")
  || ($_FILES["file"]["type"] == "audio/wma")
  || ($_FILES["file"]["type"] == "image/pjpeg")
  || ($_FILES["file"]["type"] == "image/gif")
  || ($_FILES["file"]["type"] == "audio/avi")
  || ($_FILES["file"]["type"] == "audio/mov")
  || ($_FILES["file"]["type"] == "audio/flv")
  || ($_FILES["file"]["type"] == "image/png")
  || ($_FILES["file"]["type"] == "image/PNG")
  || ($_FILES["file"]["type"] == "image/jpg")
  || ($_FILES["file"]["type"] == "image/jpeg"))
  
  && ($_FILES["file"]["size"] < 2999999)
  && in_array($extension, $allowedExts))
  
    {
    if ($_FILES["file"]["error"] > 0)
      {
      echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
      }
    else
      {
      echo "Upload: " . $_FILES["file"]["name"] . "<br />";
      echo "Type: " . $_FILES["file"]["type"] . "<br />";
      echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
      echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
  
      if (file_exists("upload/" . $_FILES["file"]["name"]))
        {
        echo $_FILES["file"]["name"] . " already exists. ";
        }
      else
        {
        move_uploaded_file($_FILES["file"]["tmp_name"],
        "../upload/" . $_FILES["file"]["name"]);
        echo "Stored in: " . "../upload/" . $_FILES["file"]["name"];
      
      $type = $_POST['type'];
      $title = $_POST['title'];
      $description = $_POST['description'];
      $url = $_FILES["file"]["name"];
      $userid = $_COOKIE['userid'];

      $type = safe($type);
      $title = safe($title);
      $description = safe($description);

      $description = str_replace("\n", "<br />", $description);

      $sql = "INSERT INTO posts VALUES (\"\", \"$title\", \"$description\", \"$type\", \"$url\", \"$userid\")";
      $res = mysql_query($sql,$dbh);
      
      header("Location: ../profile.php");
        }
      }
    }
  else
    {
    echo "Invalid file";
    }
} else {
  $allowedExts = array("jpg", "jpeg", "gif", "png", "mp3", "mp4", "wma", "PNG", "JPG", "JPEG", "FLV", "flv", "MOV", "mov", "MP4", "avi", "AVI");
  $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
  
  if ((($_FILES["file"]["type"] == "video/mp4")
  || ($_FILES["file"]["type"] == "audio/mp3")
  || ($_FILES["file"]["type"] == "audio/wma")
  || ($_FILES["file"]["type"] == "audio/avi")
  || ($_FILES["file"]["type"] == "audio/mov")
  || ($_FILES["file"]["type"] == "audio/flv")
  || ($_FILES["file"]["type"] == "image/pjpeg")
  || ($_FILES["file"]["type"] == "image/gif")
  || ($_FILES["file"]["type"] == "image/png")
  || ($_FILES["file"]["type"] == "image/jpg")
  || ($_FILES["file"]["type"] == "image/jpeg"))
  
  && ($_FILES["file"]["size"] < 2999999)
  && in_array($extension, $allowedExts))
  
    {
    if ($_FILES["file"]["error"] > 0)
      {
      echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
      }
    else
      {
      echo "Upload: " . $_FILES["file"]["name"] . "<br />";
      echo "Type: " . $_FILES["file"]["type"] . "<br />";
      echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
      echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
  
      if (file_exists("upload/" . $_FILES["file"]["name"]))
        {
        echo $_FILES["file"]["name"] . " already exists. ";
        }
      else
        {
        move_uploaded_file($_FILES["file"]["tmp_name"],
        "../upload/" . $_FILES["file"]["name"]);
        echo "Stored in: " . "../upload/" . $_FILES["file"]["name"];
      
      $profile = $_FILES["file"]["name"];
      $userid = $_COOKIE['userid'];
      $sql = "UPDATE users SET profileimg = \"$profile\" WHERE id = $userid";
      $res = mysql_query($sql,$dbh);
      echo $res;
      
      header("Location: ../profile.php");
        }
      }
    }
  else
    {
    echo "Invalid file";
    }
}

?>