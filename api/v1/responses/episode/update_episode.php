<?php

if(isset($this->data)&&$this->data!==false){

    $this->header(200);
    echo $this->return_success("data: successfully updated episode",$this->data,$this->rows);
}else{

    $this->header(503);
    echo $this->return_success("data: unable to update episode",$this->data);
}

?>