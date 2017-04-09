<!DOCTYPE html>
<html>
<head>

    <title>Zaznaczone produkty</title>
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
			<th>Obrazek</th>
			<th>Operacje</th>
		</tr>
		</thead>

		<form action="clear" method="post" class="wide" data-role="cart_form">
			<tbody>
			<?php if (isset($list)): ?>
				<?php foreach ($list as $product): ?>
					<tr>
						<td>
							<?= $product['author'] ?>
						</td>
						<td>
							<?= $product['title'] ?>
						</td>
						<td>
							<a href="http://192.168.56.10/images/watermark/<?= $product['name'] ?>">
							<img src="http://192.168.56.10/images/miniature/<?= $product['name'] ?>" alt="<?= $product['name'] ?>"/></a>
						</td>
						
						<td>
							<input type="checkbox" name="unsave_image[<?= $product['_id'] ?>]" value="<?= $product['_id'] ?>"> <br/>
						</td>
					</tr>
				<?php endforeach ?>
			<?php else: ?>
				<tr>
					<td colspan="4">Brak zdjęć</td>
				</tr>
			<?php endif ?>	
			</tbody>
			
			
			<tfoot>
			<tr>
				<td colspan="3">Usuń zaznaczone z zapamiętanych</td>
				<td>
					<input type="submit" name="clear" value="Usuń"/>
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
