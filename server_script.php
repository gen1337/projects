<?php
// Получаем данные о рекордах из файла
$records_file = 'records.json';
$records = json_decode(file_get_contents($records_file), true);

// Функция для сохранения списка рекордов в файл
function saveRecords($records) {
    global $records_file;
    file_put_contents($records_file, json_encode($records));
}

// Обработка запроса на добавление нового рекорда
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_record = json_decode(file_get_contents('php://input'), true);
    $records[] = $new_record;
    usort($records, function($a, $b) {
        return $b['time'] - $a['time'];
    });
    $records = array_slice($records, 0, 3);
    saveRecords($records);
    echo json_encode($records);
    exit;
}

// Обработка запроса на получение топ-3 рекордов
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode($records);
    exit;
}
?>
