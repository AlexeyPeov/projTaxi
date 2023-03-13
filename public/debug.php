<?php
function dd()
{
    foreach (func_get_args() as $value) {
        echo "<pre>";
        var_dump($value);
        echo "</pre>";
    }
 die();
}