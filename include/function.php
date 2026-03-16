<?php
function hsc($value)
{
    return htmlspecialchars(is_null($value) ? "" : $value);
}
?>