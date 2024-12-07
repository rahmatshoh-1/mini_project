<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['number'])) {
    $number = $_POST['number'];
    if (!isset($_SESSION['remaining_attempts'])) {
        $_SESSION['remaining_attempts'] = 10;
    }
    $_SESSION['remaining_attempts']--;
    if ($_SESSION['remaining_attempts'] <= 0) {
        generateFlashMassage("Попытки закончились! Попробуйте снова: $number", 'error');
        unset($_SESSION['remaining_attempts']);
        redirect('/mini_project/index.php');
        exit;
    }
    validateNumber($number);
    $number = intval($number);
    if (!($number >= 0 && $number <= 20)) {
        generateFlashMassage("Неправильно Введено: $number", 'error');
        redirect('/mini_project/index.php');
        exit;
    } else {
        $random = rand(0, 20);
        if ($random > $number){
            generateFlashMassage("Загаданное число больше: $random", 'info');
        }else{
            generateFlashMassage("Загаданное число меньше: $random", 'info');
        }
        if ($random == $number) {
            generateFlashMassage("Вы угадали! Загаданное число: $random", 'success');
        } 
        else {
            generateFlashMassage("Рандом ($random) не совпал с введённым числом ($number)", 'error');
        }
        redirect('/mini_project/index.php');
    }
}

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
