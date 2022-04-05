<?php

if(isset($this->data)&&$this->data!==false){

    $this->header(201);
    echo $this->return_success("data: successfully created resolution",$this->data,$this->rows);
}else{

    $this->header(503);
    echo $this->return_success("data: unable to create resolution",$this->data);
}
?>