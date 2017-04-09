<div id="login">
<?php if (empty($_SESSION['user_id'])): ?>
<form method="post">
    <input type="text" name="login" placeholder="login" required/>
    <input type="password" name="password" placeholder="password" required/>
	Nie masz konta? <a href="registration">Rejestracja</a>
    <input type="submit" value="Zaloguj"/>
</form>

<?php else: ?>
Witaj, <?php echo $_SESSION['user_login']; ?>! <a href="logout">Wyloguj</a>
<?php endif ?>
</div>
