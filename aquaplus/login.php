<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: index.php");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Вход - АкваПлюс</title>
  <!-- Bootstrap CSS -->
  <link href="./css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .login-container {
      max-width: 400px;
      margin: 100px auto;
    }
  </style>
</head>
<body>

  <div class="login-container">
    <h2 class="text-center mb-4">Вход</h2>
    <?php if ($is_invalid): ?>
                <em>Invalid login</em>
            <?php endif; ?>
    <form method="post">
      <div class="mb-3">
        <label for="email" class="form-label">Электронная почта</label>
        <input class="form-control" type="email" name="email" id="email"
        value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Пароль</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Введите пароль" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Войти</button>
    </form>
    <div class="text-center mt-3">
      <p>Нет аккаунта? <a href="signup.html">Зарегистрироваться</a></p>
    </div>
  </div>

  <!-- Bootstrap JS и зависимости -->
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
