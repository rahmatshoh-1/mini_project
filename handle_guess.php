<?php
session_start();
require_once('functions.php');
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
    } 
    if(($number >= 0 && $number <= 20)){
        $random = rand(0, 20);
        if ($random > $number){
            generateFlashMassage("Загаданное число больше", 'info');
        }
        if ($random < $number){
            generateFlashMassage("Загаданное число меньше", 'info');
        }
        if ($random == $number) {
            generateFlashMassage("Вы угадали! Загаданное число: $random", 'success');
        } 
        redirect('/mini_project/index.php');
    }
}

generateFlashMassage($flashMassage, $type = 'error');
redirect($to);
validateNumber($number);
