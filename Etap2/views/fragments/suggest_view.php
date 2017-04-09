<?php if (isset($suggestion) && $suggestion != NULL): ?>
	<table>
		<thead>
		<tr>
			<th>Autor</th>
			<th>Tytuł</th>
			<th>Obrazek</th>
		</tr>
		</thead>
		<tbody>	
			<?php foreach ($suggestion as $product): ?>
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
					</tr>	
			<?php endforeach ?>	
		</tbody>
	</table>
<?php endif ?>	