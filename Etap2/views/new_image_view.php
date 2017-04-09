<!DOCTYPE html>
<html>
<head>

    <title>Nowe zdjęcie</title>
    <?php include "fragments/layout/head.php"; ?>
	
</head>
<body>

<div id="wrapper">

	 <?php include "fragments/warning_view.php";  ?>
	 <?php include "fragments/layout/login.php"; ?>
	 <?php include "fragments/layout/navigation_div.php";  ?>
	 
	<div id="content">

		<form method="post"	enctype="multipart/form-data">
			
			<input type="file" 	name="fileToUpload" required/><br/>
			
			<label>
				<span>Tekst znaku wodnego:</span>
				<input type="text" 	name="textToWatermark"/>
			</label>
			<label>
				<span>Autor:</span>
				<input type="text" 	name="author" value="<?= !empty($_SESSION['user_id'])? $_SESSION['user_login']: "" ?>" required/>
			</label>
			<label>
				<span>Tytyuł:</span>
				<input type="text" 	name="title"  required/>
			</label>
			
			<?php if (!empty($_SESSION['user_id'])): ?>
				<input type="radio" name="type" value="public" checked>Publiczny<br>
				<input type="radio" name="type" value="privat">Prywatny
				<?php else: ?>
				<input type="radio" name="type" value="public" disabled="disabled" checked>Publiczny<br>
				<input type="radio" name="type" value="privat" disabled="disabled">Prywatny
				<input type="hidden" name="type" value="public">	
			<?php endif ?>
					
			<div>
				<br />
				<a href="products" class="cancel">Anuluj</a>
				<input type="submit" value="Wyślij"/><br/>
			</div>
			
		</form>

	</div>	
	
	<?php include "fragments/layout/footer.php"; ?>
	
</div>	

</body>
</html>
