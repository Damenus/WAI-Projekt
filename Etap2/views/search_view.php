<!DOCTYPE html>
<html>
<head>

	<title>AJAX - Wyszukiwarka</title>
	<?php include "fragments/layout/head.php"; ?>

<script>
function showHint(str) {
    if (str.length == 0) { 
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "gethint?q=" + str, true);		
        xmlhttp.send();
    }
}
</script>	
</head>
<body>

<div id="wrapper">

	 <?php include "fragments/warning_view.php";  ?>
	 <?php include "fragments/layout/login.php"; ?>
	 <?php include "fragments/layout/navigation_div.php";  ?>
	 
	<div id="content">

		<a href="products" class="cancel">Powrót</a><br />

		<form> 
			Wyszukaj: <input type="text" onkeyup="showHint(this.value)">
		</form>
		
		<p>Suggestions: <span id="txtHint"></span></p>

	</div>
	
	<?php include "fragments/layout/footer.php"; ?>
	
</div>

</body>
</html>


 