<?php

class CSV{
    public $fileObj;
    function __construct($filename){
        $this->fileObj=fopen($filename, 'w+');
    }
    function setHeader($headerData){
        fputcsv($this->fileObj, $headerData);
    }
    function setData($data){
        fputcsv($this->fileObj, $data);
    }
    function close(){
       fclose($this->fileObj);
    }
}

// $CSVObj=new CSV('dummy.csv');
// $CSVObj->setHeader(['name','mobile no']);
// $data = ['FB','585955'];
// $CSVObj->setData($data);
?>