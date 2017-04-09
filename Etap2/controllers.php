<?php
require_once 'business.php';
require_once 'controller_utils.php';

function login(&$model){
	
	if (!empty($_POST['login']) &&
        !empty($_POST['password']) 
    ) {
		$password = $_POST['password'];
		$login = $_POST['login'];
		$user = login_user($login);
			
		if($user !== null && password_verify($password, $user['password'])) {
			session_regenerate_id();
			$_SESSION['user_id'] = $user['_id'];
			$_SESSION['user_login'] = $user['login'];
			$warning = "Zalogowany!";
		}	else {
				$warning = "Niepoprawny login lub hasło!";
				}
	}	
	if (isset($warning))
		$model['warning'] = $warning;
}

function logout(&$model)
{
	session_destroy();
	//
	//$params = session_get_cookie_params();
	//setcookie(session_name(), '', time() - 42000,
	//$params["path"], $params["domain"],
	//$params["secure"], $params["httponly"]
	//);
	
	return 'redirect:products';
}

function products(&$model)
{
	login($model);
    $products = get_products();  
	
	if ($products->count()) {
        foreach ($products as $product)
			if ((!empty($_SESSION['user_id']) && $_SESSION['user_id'] == $product['author_id']) || $product['author_id'] == NULL)
				$produkty[] = $product;
			
		$model['products'] = $produkty;
		$model['products_count'] = $products->count();
	}

    return 'products_view';
}

function edit(&$model)
{	
	login($model);
	
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		
		if (!empty($_POST['textToWatermark']) &&
		!empty($_POST['author']) &&
		!empty($_POST['title']) 
    )	{
			$id = (isset($_SESSION['user_id']) && ($_POST['type'] == 'privat')) ? $_SESSION['user_id'] : null;				
			
			$product = [
				'author' => $_POST['author'],
				'title' => $_POST['title'],
				'name' => $_FILES["fileToUpload"]["name"],
				'type' => $_POST['type'],
				'author_id' => $id, 
			];						
			$target_dir = "images/";
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			
			//Miniatura
			$width_mini = 200;
			$height_mini = 125;
			$min_save_file = ''.$target_dir.'miniature/'.$_FILES["fileToUpload"]["name"].''; // name of miniature	
			//Watermark
			$watermark_save_file = ''.$target_dir.'watermark/'.$_FILES["fileToUpload"]["name"].'';
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			
			

			$uploadOk = 1;
			
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$file_name_type = $_FILES['fileToUpload']['tmp_name'];
			$mime_type = finfo_file($finfo, $file_name_type);
			
			if ($mime_type !== 'image/jpeg' && $mime_type !== 'image/jpg' && $mime_type !== 'image/png') {
				$uploadOk = 0;
				$warning[] = 'Niepoprawny format.';
			}
			
		    if (file_exists($target_file)) {
				$warning[] =  "Plik istnieje.";
				$uploadOk = 0;
			}

			if ($_FILES["fileToUpload"]["size"] > 1000000) {
				$warning[] = "Plik jest za duży. Maksymalny rozmiar to 1MB.";
				$uploadOk = 0;
			}
			
			if ($uploadOk == 0) {
				$warning[] = "Plik nie został przesłany.";
			}
			
			$upload_dir = '/var/www/prod/web/images/';
			$file = $_FILES["fileToUpload"];
			$file_name = basename($file['name']);
			$target = $upload_dir . $file_name;
			$tmp_path = $file["tmp_name"];
			
			if ($uploadOk != 0) {
				if(move_uploaded_file($tmp_path, $target)){
					$warning[] = "Upload przebiegł pomyślnie!\n";
				}	else {
					$warning[] = "Błąd podczas przesyłania!";
					$uploadOk = 0;					
				}	
			}
			
			if ($uploadOk == 1) {
				if($imageFileType == "jpg"  || $imageFileType == "jpeg" ) { //&& $imageFileType == "png"
					$image = imagecreatefromjpeg($target_file);	
				} else 
					$image = imagecreatefrompng($target_file);	
				
				$watermark_color_text = ImageColorAllocate($image,0 ,0 ,0); //black

				list($width_img, $height_img) = getimagesize($target_file);
				
			// Makeing miniature		
				$img_mini = imagecreatetruecolor($width_mini, $height_mini);
				imagecopyresampled($img_mini, $image, 0, 0, 0, 0, $width_mini, $height_mini, $width_img, $height_img); 
				imagejpeg($img_mini, $min_save_file, 90); // 90 means how quality
				
			// Makeing watermark
				ImageString($image, 10, 10, 10, $_POST["textToWatermark"], $watermark_color_text);				
				imagejpeg($image, $watermark_save_file, 90);
				
				imagedestroy($img_mini);
				imagedestroy($image);
				
			//add to mongodb	
				if (save_product($product)) {
					$model['warning'] = $warning;
					return 'redirect:products';
				}
			}			
		}
	}
	if (isset($warning)) {
		$warning = implode(" ", $warning);
		$model['warning'] = $warning;
	}
    return 'new_image_view'; 
}

function lists(&$model)
{
	$list = get_list();
	
	if (isset($list) && $list != NULL)
		foreach ($list as $id) {
			$product = get_product($id);
			$result[] = $product;
		}
		
	if (isset($result)) 
		$model['list'] = $result;
	
    return 'list_view';
}

function save(&$model)
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_image'])) {		
		$list = &get_list();
		$save_image = $_POST['save_image'];
		$list = $save_image;
	}
	return 'redirect:products';
}

function clear(&$model)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$unsave_image = $_POST['unsave_image'];

	    $list = &get_list();

		$result = array_diff($list, $unsave_image);		
	    $list = $result;

		return 'redirect:lists';        
    }
}

function clear_all(&$model)
{
	$_SESSION['list'] = [];	
	return 'redirect:products';
}

function registration(&$model)
{
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		 if (!empty($_POST['email']) &&
            !empty($_POST['login']) &&
			!empty($_POST['password']) &&
			!empty($_POST['repeatpassword'])
        ) {
			if ($_POST['repeatpassword'] === $_POST['password']) {				
				if (!get_user_by_login($_POST['login'])){
					if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) { 
						$user = [
							'email' => $_POST['email'],
							'login' => $_POST['login'],
							'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
						];						
				
						if (save_user($user)) {
							//$warning = "Zarejestrowano!";
							return 'redirect:products';
						}
					} else $warning = "Błędny mail!"; 
				} else $warning = "Podany login jest już zajęty!";
			} else $warning = "Różne hasła";
        } 
    }
	
	if (isset($warning))
		$model['warning'] = $warning;
	
    return 'registration_view';
		
}

function gethint(&$model)
{
	$products = get_products();
	foreach($products as $product) {
		if ((!empty($_SESSION['user_id']) && $_SESSION['user_id'] == $product['author_id']) || $product['author_id'] == NULL)
		{	
			$b1[] = $product['title']; //tablica ze wszystkimi nazwami
			$b2[] = $product['_id'];   //tablice z indeksami
			$a[] = $product['title'];  //tablica do operacji na niej
		}
	}

	$q = $_REQUEST["q"];

	$hint = "";

	if ($q !== "") {
		$q = strtolower($q);
		$len=strlen($q);
		foreach($a as $name) {
			if (stristr($q, substr($name, 0, $len))) { 
				$h[] =  $name; 
				if ($hint === "") {
					$hint = $name;
					
				} else {
					$hint .= ", $name";
				}
			}
		}
	}
	
	$i = 0;
	foreach($b1 as $title) {
		if (isset($h))
		foreach($h as $title1) {
			if($title == $title1) {
				$wynik[] = $b2[$i];
			}
		}
		$i = $i + 1;	
	}
	
	
	if (isset($wynik)) {
		$result = array_unique($wynik);
		
		foreach ($result as $id)  {
			$product = get_product($id);
			if ((!empty($_SESSION['user_id']) && $_SESSION['user_id'] == $product['author_id']) || $product['author_id'] == NULL)
				$res[] = $product;
		}
		
		$model['suggestion'] = $res;
	}
	
	echo $hint === "" ? "no suggestion" : $hint; 
	return 'fragments/suggest_view';
	
} 

function search(&$model)
{	                      
	return 'search_view';
}