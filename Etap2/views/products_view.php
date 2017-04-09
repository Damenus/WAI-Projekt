<!DOCTYPE html>
<html>
<head>

    <title>Produkty</title>
    <?php include "fragments/layout/head.php"; ?>
	
</head>
<body>

<div id="wrapper">

	 <?php include "fragments/warning_view.php";  ?>
	 <?php include "fragments/layout/login.php"; ?>
	 <?php include "fragments/layout/navigation_div.php";  ?>
	 
	<div id="content">
		<table>
			<thead>
			<tr>
				<th>Autor</th>
				<th>Tytuł</th>
				<th>Zasięg</th>
				<th>Obrazek</th>
				<th>Operacje</th>
			</tr>
			</thead>

			<form action="save" method="post" class="wide">
				<tbody>
				<?php if (isset($products)): ?>
					<?php foreach ($products as $product): ?>
					
							<tr>
								<td>
									<?= $product['author'] ?>
								</td>
								<td>
									<?= $product['title'] ?>
								</td>
								<td>
									<?= $product['type'] ?>
								</td>
								<td>
									<a href="http://192.168.56.10/images/watermark/<?= $product['name'] ?>">
									<img src="http://192.168.56.10/images/miniature/<?= $product['name'] ?>" alt="<?= $product['name'] ?>"/></a>
								</td>
								
								<td>
									<input type="checkbox" name="save_image[<?= $product['_id'] ?>]" value="<?= $product['_id'] ?>" <?php if(isset($_SESSION['list']) && in_array($product['_id'], $_SESSION['list'])): echo 'checked'; endif ?> <br/>						
								</td>
							</tr>
					
					<?php endforeach ?>
				<?php else: ?>
					<tr>
						<td colspan="3">Brak zdjęć</td>
					</tr>
				<?php endif ?>	
				</tbody>	
				
				<tfoot>
				<tr>
					<td colspan="4">Łącznie przesłanych zdjęć przez użytkowników: <?php echo $products_count; ?></td><td></td>
				</tr>
				<tr>
					<td colspan="4"></td>
					<td>
						<input type="submit" name="save" value="Zapamiętaj wybór"/>
					</td>
				</tr>
				<tr>
					<td colspan="4"></td>
					<td>
						<a href="clearall">Wyczyść wybór</a>
					</td>
				</tr>
				</tfoot>
				
			</form>	
		</table>
	</div>
	
	<?php include "fragments/layout/footer.php"; ?>

</div>

</body>
</html>
