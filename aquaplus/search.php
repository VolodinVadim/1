<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поиск услуг</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
    <?php
// Включение отображения ошибок для отладки
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Подключение к базе данных
require_once 'database.php';  // Убедитесь, что путь правильный

// Получаем поисковый запрос от пользователя и очищаем его
$query = isset($_GET['query']) ? trim($_GET['query']) : '';

// Проверяем, что запрос не пустой
if ($query !== '') {
    try {
        // Подготовка SQL-запроса с использованием подготовленных выражений
        $sql = "SELECT * FROM services WHERE name LIKE :query OR description LIKE :query";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['query' => '%' . $query . '%']);
        $services = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($services) {
            echo "<h3>Результаты поиска для: " . htmlspecialchars($query, ENT_QUOTES, 'UTF-8') . "</h3>";
            echo "<div class='row'>";  // Начало рядов для карточек

            foreach ($services as $service) {
                echo "<div class='col-md-4'>";  // Определяем, что карточка занимает 1/3 ширины на экране среднего размера
                echo "<div class='card mb-4'>";  // Создание карточки
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>" . htmlspecialchars($service['name'], ENT_QUOTES, 'UTF-8') . "</h5>";
                echo "<p class='card-text'>" . htmlspecialchars($service['description'], ENT_QUOTES, 'UTF-8') . "</p>";
                echo "<p class='card-text'><strong>Цена:</strong> " . htmlspecialchars($service['price'], ENT_QUOTES, 'UTF-8') . " руб.</p>";
                echo "<a href='#' class='btn btn-primary'>Забронировать</a>";  // Кнопка для бронирования
                echo "</div>";  // Закрытие card-body
                echo "</div>";  // Закрытие card
                echo "</div>";  // Закрытие col-md-4
            }

            echo "</div>";  // Закрытие row
        } else {
            echo "<p>Услуги не найдены.</p>";
        }
    } catch (PDOException $e) {
        // Обработка ошибок SQL-запроса
        echo "Ошибка выполнения запроса: " . $e->getMessage();
    }
} else {
    echo "<p>Пожалуйста, введите запрос для поиска.</p>";
}
?>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
