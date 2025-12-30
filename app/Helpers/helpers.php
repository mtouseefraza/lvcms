<?php
if (!function_exists('permission')) {
    function permission()
    {
       return ['VIEW','UPDATE','DELETE','EXPORT'];
    }
}
?>