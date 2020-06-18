<?php
session_start();

// SQL

function my_connect() {
	$SQLhost = 'localhost';
	$SQLuser = 'root';
	$SQLpassword = '';
	$SQLdatebase = 'basephp_project';

	return mysqli_connect($SQLhost, $SQLuser, $SQLpassword, $SQLdatebase);
}

// HEADER

function visitor_name() {
	if (empty ($_SESSION['username'])) {
		$name = "Гость!";
	} else {
		$name = $_SESSION['username'] . '!';
	}

	if (date('G') >= 5 and date('G') <= 11) {
		return "Доброе утро, " . $name;
	} elseif (date('G') > 11 and date('G') <= 17) {
		return "Добрый день, " . $name;
	} elseif (date('G') > 17 and date('G') <= 23) {
		return "Добрый вечер, " . $name;
	} else {
		return "Доброй ночи, " . $name;
	}
}

function my_daytime() {
	setlocale(LC_ALL, 'russian');
	$mon = strftime('%B');
	$mon = iconv('windows-1251', 'utf-8', $mon);
	$day = strftime('%A');
	$day = iconv('windows-1251', 'utf-8', $day);

	return "Сегодня $day, " . date('d.m.Y') . " года";
}

function avatar_view() {
	if ($_SESSION['auth']) {
		$username = $_SESSION["username"];
		$link = my_connect() or die (mysqli_error($link));
		$query = "SELECT * FROM users WHERE username='$username'";
		$result = mysqli_query($link, $query) or die (mysqli_error($link));
		$user = mysqli_fetch_assoc($result) or die (mysqli_error($link));

		if (isset($user["avatar"])) {
			$result = '<figure>';
			$result .= '<img class="avatar" src="' . $user["avatar"] . '">';
			$result .= '</figure>';
		}

		return $result;
	}
}

//MENU

function header_menu() {
	if (empty ($_SESSION['auth'])) {
		$headerMenu = [
			'Регистрация' => 'registr.php',
			'Войти' => 'login.php'
		];

		$result = '';

		foreach ($headerMenu as $name => $href) {
			$result .= "<div class=\"login\"><a id =\"top\" href =$href>$name</a></div>";
		}

		return $result;
	} else {
		$headerMenu = [
			'Настройки' => '#',
			'Выйти' => 'logout.php'
		];

		$result = '';

		foreach ($headerMenu as $name => $href) {
			$result .= "<div class=\"login\"><a id =\"top\" href =$href>$name</a></div>";
		}

		return $result;
	}
}

function left_menu() {
	$leftMenu = [
		'Главная' => 'index.php',
		'Новое' => '#',
		'Популярное' => '#',
		'Категории' => '#',
		'Оставить отзыв' => 'review.php',
		'Исходники' => 'source.php'
	];

	$result = '';

	foreach ($leftMenu as $name => $href) {
		$result .= "<li class=\"left\"><a id =\"left\" href = $href>$name</a></li>";
	}

	return $result;
}

function bottom_menu() {
	$bottomMenu = [
		'О сайте' => 'about.php',
		'Контакты' => '#',
		'Кнопка' => '#',
	];

	$result = '';

	foreach ($bottomMenu as $name => $href) {
		$result .= "<div class=\"botbuttons\"><a id =\"bot\" href=$href>$name</a></div>";
	}

	return $result;
}

//ADMIN MENU

function admin_header_menu() {
	if (empty ($_SESSION['auth'])) {
		$headerMenu = [
			'Регистрация' => '../registr.php',
			'Войти' => '../login.php'
		];

		$result = '';

		foreach ($headerMenu as $name => $href) {
			$result .= "<div class=\"login\"><a id =\"top\" href =\"$href\">$name</a></div>";
		}

		return $result;
	} else {
		$headerMenu = [
			'Настройки' => '#',
			'Выйти' => '../logout.php'
		];

		$result = '';

		foreach ($headerMenu as $name => $href) {
			$result .= "<div class=\"login\"><a id =\"top\" href =$href>$name</a></div>";
		}

		return $result;
	}
}

function admin_left_menu() {
	$leftMenu = [
		'Главная' => '../index.php',
		'Админка' => 'index.php',
		'Блоги' => 'blogs.php',
		'Пользователи' => 'users.php',
		'Коментарии' => 'comments.php',
		'Отзывы' => 'reviews.php'
	];

	$result = '';

	foreach ($leftMenu as $name => $href) {
		$result .= "<li class=\"left\"><a id =\"left\" href = $href>$name</a></li>";
	}

	return $result;
}

function admin_bottom_menu() {
	$bottomMenu = [
		'О сайте' => '../about.php',
		'Контакты' => '#',
		'Кнопка' => '#',
	];

	$result = '';

	foreach ($bottomMenu as $name => $href) {
		$result .= "<div class=\"botbuttons\"><a id =\"bot\" href=$href>$name</a></div>";
	}

	return $result;
}

//REGISTRATION

function registr() {
	
	$link = my_connect() or die (mysqli_error($link));

	$login = trim($_POST['login']);
	$email = trim($_POST['email']);
	$password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

	$query = "SELECT * FROM users WHERE username='$login'";
	$resultlogin = mysqli_query($link, $query);

	$query = "SELECT * FROM users WHERE useremail='$email'";
	$resultEmail = mysqli_query($link, $query);

	if (!preg_match('#([A-Za-z0-9-]+){5,15}#', $_POST['login'])) {
		$errorMsg = 'Логин должен быть длиной от 5 до 15 символов и состоять из букв латинского алфавита, или цифр';
		return $errorMsg; 
	} elseif (mysqli_num_rows($resultlogin) > 0) {
		$errorMsg = 'Пользователь с таким логином уже существует';
		return $errorMsg;
	} elseif (!preg_match('#([A-Za-z0-9-\*!\.\?_]+){5,15}#', $_POST['password'])) {
		$errorMsg = 'Пароль должен быть длиной от 5 до 15 символов  и состоять из букв латинского алфавита, цифр или спецсимволов';
		return $errorMsg;
	} elseif ($_POST['password'] != $_POST['confirm']) {
		$errorMsg = 'Пароли не совпадают';
		return $errorMsg;
	} elseif (!empty($_POST['email']) && !preg_match('#^([A-Za-z0-9_\.-])+?@([A-Za-z0-9_\.-])+?\.([A-Za-z\.]{2,6})$#', $_POST['email'])) {
		$errorMsg = 'Некорректный email';
		return $errorMsg;
	} elseif (!empty($_POST['email']) && mysqli_num_rows($resultEmail) > 0) {
		$errorMsg = 'Такой email уже используется';
		return $errorMsg;
	} elseif ((!empty ($_FILES['attachment-file'])) && (my_upload() !== 'OK')) {
		$errorMsg = my_upload();
		return $errorMsg;
	} else {
	
	$query = "INSERT INTO users (username, useremail, password) VALUES ('$login', '$email', '$password')";
	$result = mysqli_query($link, $query) or die (mysqli_error($link));

	$query = "SELECT * FROM users WHERE username='$login'";
	$result = mysqli_query($link, $query) or die (mysqli_error($link));
	$user = mysqli_fetch_assoc($result) or die (mysqli_error($link));

	if (!empty ($_FILES['attachment-file']['tmp_name'])) {
		$pathInfo = pathinfo($_FILES['attachment-file']['name']);
	    $exp = $pathInfo['extension'];
	    $avatar = 'img/avatars/' . $user['id'] . '_ava.' . $exp;
		move_uploaded_file($_FILES['attachment-file']['tmp_name'], $avatar);
		$query = "UPDATE users SET avatar='$avatar' WHERE id='{$user['id']}'";
		$result = mysqli_query($link, $query) or die (mysqli_error($link));
	} else {
		$avatar = 'img/avatars/stnd_ava.png';
		$query = "UPDATE users SET avatar='$avatar' WHERE id='{$user['id']}'";
		$result = mysqli_query($link, $query) or die (mysqli_error($link));
	}

	session_start();
	$_SESSION['auth'] = true;
	$_SESSION['username'] = $user ['username'];
	$_SESSION['status'] = $user['status_id'];

	header('Location: index.php');
	}  
}

//AUTHORIZATION

function authorization() {
	$login = $_POST['login'];

	$link = my_connect() or die (mysqli_error($link));
	$query = "SELECT * FROM users WHERE username='$login'"; // получаем юзера по логину
	$result = mysqli_query($link, $query) or die (mysqli_error($link));
	$user = mysqli_fetch_assoc($result);

	if (!empty($user)) {
		$hash = $user['password'];

		if (password_verify($_POST['password'], $hash) && ($user['banned'] == 0)) {
			session_start();
			$_SESSION['auth'] = true;
			$_SESSION['username'] = $user ['username'];
			$_SESSION['status'] = $user['status_id'];
			header('Location: index.php');
		} elseif (!password_verify($_POST['password'], $hash)) {
			$errorMsg = 'Неверный логин, или пароль';
			return $errorMsg;
		} elseif ($user['banned'] == 1) {
			$errorMsg = 'Вы забанены. Свяжитесь с администратором';
			return $errorMsg;
		}
	} else {
		$errorMsg = 'Неверный логин, или пароль';
		return $errorMsg;
	}
}

//FILEUPLOAD

function my_upload() {
	if (!empty ($_FILES['attachment-file']['tmp_name'])) {
		$filePath  = $_FILES['attachment-file']['tmp_name'];
		$fi = finfo_open(FILEINFO_MIME_TYPE);
		$mime = (string) finfo_file($fi, $filePath);
		if (strpos($mime, 'image') === false) {
			$errorMsg = 'Можно загружать только изображения';
			return $errorMsg;
		}
		$image = getimagesize($filePath);
		$limitBytes  = 1024 * 1024 * 2;
		$limitWidth  = 1280;
		$limitHeight = 1280;
		if (filesize($filePath) > $limitBytes) {
			$errorMsg = 'Размер изображения не должен превышать 2 Мбайт';
			return $errorMsg;
		}
		if ($image[1] > $limitHeight) {
			$errorMsg = 'Высота изображения не должна превышать 1280 точек';
			return $errorMsg;
		}
		if ($image[0] > $limitWidth) {
			$errorMsg = 'Ширина изображения не должна превышать 1280 точек';
			return $errorMsg;
		}
		return 'OK';
	} else {
		return 'OK';
	}
}