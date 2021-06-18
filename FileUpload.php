<?php


class FileUpload
{


    public static function upload($image, $target)
    {
        $target = rtrim($target, "/");
        $explode = explode(".", $image['name']);
        $extention = end($explode);

        $newImgName = time()."-".rand(111111,999999).".".$extention;
        $photoDirection = "$target/$newImgName";
        return move_uploaded_file($image['tmp_name'], $photoDirection) ? $newImgName : false;
    }


    public static function remove($name, $target)
    {
        $target = rtrim($target, "/");

        unlink("$target/$name");
    }
}