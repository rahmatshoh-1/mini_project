<?php
function generateFlashMassage($flashMassage, $type = 'error') {
    $_SESSION[$type] = $flashMassage;
}

function redirect($to) {
    header("Location: $to");
    exit;
}
function validateNumber($number){
    if (!preg_match('/^\d+$/', $number)) {
        generateFlashMassage("Введите только цифры.", 'error');
        redirect('/mini_project/index.php');
        exit;
    }
}