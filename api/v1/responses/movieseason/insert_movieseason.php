<?php

if(isset($this->data)&&$this->data!==false){

    $this->header(201);
    echo $this->return_success("data: successfully created movie season",$this->data,$this->rows);
}else{

    $this->header(503);
    echo $this->return_success("data: unable to create movie season",$this->data);
}
?>