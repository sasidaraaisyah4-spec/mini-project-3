<?php
function validateQty($quantity) {
    $qty = filter_var($quantity, FILTER_VALIDATE_INT);
    return ($qty !== false && $qty > 0) ? $qty : false;
}
?>
