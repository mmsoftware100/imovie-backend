<?php

if(isset($this->data)&&$this->data!==false){

    $this->header(200);
    echo $this->return_success("data: successfully got movie file",$this->data,$this->rows);
}else{

    $this->header(503);
    echo $this->return_success("data: unable to get movie file",$this->data);
}

?>