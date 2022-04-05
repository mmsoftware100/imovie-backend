<?php

if(isset($this->data)&&$this->data!==false){

    $this->header(200);
    echo $this->return_success("data: successfully deleted category",$this->data,$this->rows);
}else{

    $this->header(503);
    echo $this->return_success("data: unable to delete category",$this->data);
}

?>