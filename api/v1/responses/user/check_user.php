<?php

if (isset($this->data) && $this->data !== false) {

    $this->header(200);
    echo $this->return_success("data: successfully login", $this->data, false, $this->jwt);
} else {

    $this->header(401);
    echo $this->return_success("data: unable to access", $this->data);
}
