<?php
if (isset($message)) {
    foreach ($message as $message) {
        echo '
      <div class="message">
          <span>' . $message . '</span>
          <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
    }
}
?>

<header class="header">
    <a href="#" class="logo">Goat</a>

    <a href="auth/login.php" class="user-icon">
        <i class="fas fa-user"></i>
    </a>
</header>