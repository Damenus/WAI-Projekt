<!DOCTYPE html>
<html>
<head>

    <title>Rejestracja</title>
    <?php include "fragments/layout/head.php"; ?>
	
</head>
<body>

<div id="wrapper">

	<?php include "fragments/warning_view.php";  ?>
	<?php include "fragments/layout/navigation_div.php";  ?>
 
	<div id="content">

		<form method="post">
			<label>
				<span>Adres email:</span>
				<input type="text" name="email" required/>
			</label>
			<label>
				<span>Login:</span>
				<input type="text" name="login" required/>
			</label>
			 <label>
				<span>Hasło:</span>
				<input type="password" name="password" required/>
			</label>
			 <label>
				<span>Powtórz hasło:</span>
				<input type="password" name="repeatpassword" required/>
			</label>

			<div>
				<a href="products" class="cancel">Anuluj</a>
				<input type="submit" value="Zapisz"/>
			</div>
		</form>

		<?php include "fragments/layout/footer.php"; ?>

	</div>
	
</div>

</body>
</html>
