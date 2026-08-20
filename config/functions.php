<?php

fuction redirect($path){
    header("Location: " . BASE_URL . $path);
    exit;
}

?>