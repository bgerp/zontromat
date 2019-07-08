<?php

// Базовата директория за целия пакет
define('ZTM_ROOT', str_replace(DIRECTORY_SEPARATOR, '/', dirname(__DIR__)));

// Регистрираме функция за автоматично зареждане на класовете
spl_autoload_register('loadClass', true, true);

// Вътрешно кодиране
mb_internal_encoding('UTF-8');
        
// Локал за функции като basename
setlocale(LC_ALL, 'en_US.UTF8');

// Дали се вика от командна линия
define('ZTM_IS_CLI', (!isset($_SERVER['SERVER_SOFTWARE']) && (php_sapi_name() == 'cli' || (is_numeric($_SERVER['argc']) && $_SERVER['argc'] > 0))));

/**
 * Дефинира константа, ако преди това не е била дефинирана
 * Ако вторият и аргумент започва с '[#', то изпълнението се спира
 * с изискване за дефиниция на константата
 */
function defIfNot($name, $value = null)
{
    if (!defined($name)) {
        define($name, $value);
    }
}

/**
 * Форматира обекти и скалари към HTML
 */
function dump($data, $isHtml = true)
{
    if(!is_scalar($data)) {
        $str = json_encode($data, JSON_PRETTY_PRINT);
    } else {
        $str = $data;
    }

    if($isHtml) {
        $str = "<pre>{$str}</pre>";
    }

    return $str;
}


/**
 * Отпечатва съдържанието на аргумента си на конзолата
 */
function debug($data)
{
    $str = dump($data, false);

    file_put_contents("php://stdout", "\n===DEBUG==\n{$str}\n===END====\n");
}


/**
 * Показва грешка и спира изпълнението.
 */
function error($error = '500 Server Error', $dump = null)
{
    $dump = func_get_args();
    array_shift($dump);

    throw new except_Error($error, 'Error', $dump);
}


/**
 * Генерира грешка, ако аргумента не е TRUE
 *
 * @var mixed   $inspect Обект, масив или скалар, който се подава за инспекция
 * @var boolean $condition
 */
function expect($cond)
{
    if (!(boolean) $cond) {
        $dump = func_get_args();
        array_shift($dump);

        throw new except_Error('500 Server Error', 'Failed expect', $dump);
    }
}


/**
 * Връща пътя до файла, който съдържа посочения клас
 */
function getClassPath($name)
{
    $path = ZTM_ROOT . '/' . preg_replace("/[^0-9a-z]/i", '/', $name) . '.php';

    return $path;
}


/**
 * Зарежда посоченият клас
 */
function loadClass($name)
{
    $path = getClassPath($name);
    
    require_once($path);

    expect(class_exists($name), $name, $path);
}




