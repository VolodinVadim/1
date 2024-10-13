<?php

session_start();

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Бассейн "АкваПлюс"</title>
  <!-- Bootstrap CSS -->
  <link href="./css/bootstrap.min.css" rel="stylesheet">
  <!-- Дополнительные стили -->
  <style>
    .hero {
      background: url('./img/hero_bg.png') no-repeat center center;
      background-size: cover;
      height: 100vh;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
    }
    .hero-overlay {
      background: rgba(0, 0, 0, 0.5);
      padding: 50px;
      border-radius: 10px;
    }
    .footer {
      background-color: #f8f9fa;
      padding: 20px 0;
    }
    body {
      padding-top: 70px; /* Для отступа под фиксированную навигационную панель */
    }
  </style>
</head>
<body>

  <!-- Навигационная панель -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="index.php">АкваПлюс</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
              aria-controls="navbarNav" aria-expanded="false" aria-label="Переключить навигацию">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Главная</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#about">О нас</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#services">Услуги</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#contact">Контакты</a>
          </li>
          <?php if (isset($user)): ?>
        
        <div class="nav-link"><?= htmlspecialchars($user["name"]) ?></div>                     
        <p><a href="logout.php" class="nav-link">Выйти</a></p>    
      <?php else: ?>
        <li class="nav-item">
        <a class="nav-link" href="signup.html">Регистрация</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="login.php">Вход</a>
      </li>                    
      <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Главный экран (Hero) -->
  <section class="hero">
    <div class="hero-overlay">
      <h1 class="display-4">Добро пожаловать в АкваПлюс</h1>
      <p class="lead">Лучший бассейн для отдыха и тренировок в вашем городе.</p>
      <a href="signup.html" class="btn btn-primary btn-lg">Зарегистрироваться</a>
    </div>
  </section>

  <!-- О нас -->
  <section id="about" class="py-5">
    <div class="container">
      <h2 class="mb-4 text-center">О нас</h2>
      <div class="row">
        <div class="col-md-6">
          <p>Бассейн "АкваПлюс" предлагает современные условия для занятий плаванием, водными видами спорта и отдыха. Мы обеспечиваем чистую воду, профессиональных тренеров и комфортную атмосферу для всех наших гостей.</p>
          <p>Наши услуги включают аренду бассейна, проведение уроков плавания, организацию мероприятий и многое другое.</p>
        </div>
        <div class="col-md-6">
          <img src="./img/pool.png" class="img-fluid rounded" alt="Бассейн">
        </div>
      </div>
    </div>
  </section>

  <!-- Услуги (Аренда) -->
  <section id="services" class="bg-light py-5">
    <div class="container">
      <h2 class="mb-4 text-center">Наши услуги</h2>
      <div class="row">
        <!-- Услуга 1 -->
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <img src="./img/swimming_pool.png" card-img-top" alt="Аренда бассейна">
            <div class="card-body">
              <h5 class="card-title">Аренда бассейна</h5>
              <p class="card-text">Арендуйте бассейн для частных мероприятий, корпоративных встреч или семейных праздников.</p>
            </div>
          </div>
        </div>
        <!-- Услуга 2 -->
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <img src="./img/swimlessons.png" class="card-img-top" alt="Уроки плавания">
            <div class="card-body">
              <h5 class="card-title">Уроки плавания</h5>
              <p class="card-text">Профессиональные тренеры помогут вам освоить технику плавания независимо от вашего уровня подготовки.</p>
            </div>
          </div>
        </div>
        <!-- Услуга 3 -->
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <img src="./img/chill.png" class="card-img-top" alt="Отдых у бассейна">
            <div class="card-body">
              <h5 class="card-title">Отдых и релаксация</h5>
              <p class="card-text">Наслаждайтесь солнечными днями у бассейна, заказывайте напитки и отдыхайте в уютной зоне отдыха.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="container mt-5">
  <h2 class="text-center">Поиск услуг</h2>
  <form action="search.php" method="GET">
    <div class="input-group mb-3">
      <input type="text" class="form-control" name="query" placeholder="Введите название услуги" required>
      <button class="btn btn-primary" type="submit">Поиск</button>
    </div>
  </form>

  <!-- Результаты поиска -->
  <div id="results">
    <?php
    // Включение файла search.php для отображения результатов
    if (isset($_GET['query'])) {
        include 'search.php';
    }
    ?>
  </div>
</div>

  <!-- Контакты -->
  <section id="contact" class="bg-light py-5">
    <div class="container">
      <h2 class="mb-4 text-center">Контакты</h2>
      <div class="row">
        <div class="col-md-6 mb-4">
          <h5>Адрес:</h5>
          <p>г. Москва, ул. Примерная, д. 123</p>
          <h5>Телефон:</h5>
          <p>+7 (999) 999-99-99</p>
          <h5>Email:</h5>
          <p>info@aquaplus.ru</p>
        </div>
        <div class="col-md-6">
          <h5>Мы на карте:</h5>
          <div class="ratio ratio-16x9">
          <script type="text/javascript" charset="utf-8" src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A053bd947d462cc1a45aeba4070defff75501905071c0eaf68436ac9976ec698c&amp;width=514&amp;height=326&amp;lang=ru_RU&amp;"></script>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Футер -->
  <footer class="footer text-center">
    <div class="container">
      <p class="mb-0">&copy; 2024 Бассейн "АкваПлюс". Все права защищены.</p>
    </div>
  </footer>

  <!-- Bootstrap JS и зависимости -->
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
