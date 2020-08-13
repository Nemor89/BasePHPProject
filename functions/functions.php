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

	$login = trim(mysqli_real_escape_string($link, $_POST['login']));
	$email = trim(mysqli_real_escape_string($link, $_POST['email']));
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
	$_SESSION['username'] = $user['username'];
	$_SESSION['userid'] = $user['id'];
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
			$_SESSION['userid'] = $user['id'];
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

//BLOG ADD

function blog_add() {

	if (mb_strlen($_POST['blogdesc']) < 10 || mb_strlen($_POST['blogdesc']) > 512) {
		$errorMsg = 'Описание должено быть длиной от 10 до 512 символов';
		return $errorMsg; 
	} elseif (empty($_POST['category'])) {
		$errorMsg = 'Укажите хотя бы одну категорию';
		return $errorMsg;
	} elseif (count($_POST['category']) > 5) {
		$errorMsg = 'Укажите не более пяти категорий';
		return $errorMsg;
	} elseif (mb_strlen($_POST['blogtext']) < 20) {
		$errorMsg = 'Текст должен быть длиной не менее 20 символов';
		return $errorMsg;
	} elseif ((!empty ($_FILES['attachment-file'])) && (my_upload() !== 'OK')) {
		$errorMsg = my_upload();
		return $errorMsg;
	} else {

		$link = my_connect() or die (mysqli_error($link));

		$description = $_POST['blogdesc'];
		$text = $_POST['blogtext'];
		$author = trim(mysqli_real_escape_string($link, $_SESSION['username']));
		
		$query = "INSERT INTO blogs (description, text, author) VALUES ('$description', '$text', '$author')";
		$result = mysqli_query($link, $query) or die (mysqli_error($link));
		$id = mysqli_insert_id($link); // получаем последний добавленный id

		if (!empty ($_FILES['attachment-file']['tmp_name'])) {
			$pathInfo = pathinfo($_FILES['attachment-file']['name']);
		    $exp = $pathInfo['extension'];
		    $blogimg = '../img/blogimg/' . $id . '_img.' . $exp;
			move_uploaded_file($_FILES['attachment-file']['tmp_name'], $blogimg);
			$query = "UPDATE blogs SET picture='$blogimg' WHERE id='$id'";
			$result = mysqli_query($link, $query) or die (mysqli_error($link));
		} else {
			$query = "UPDATE blogs SET picture='../img/blogimg/stnd_blogimage.png' WHERE id='$id'";
			$result = mysqli_query($link, $query) or die (mysqli_error($link));
		}

		foreach ($_POST['category'] as $category_id) {
			$query = "INSERT INTO blog_cat (blog_id, category_id) VALUES ('$id', '$category_id')";
			$result = mysqli_query($link, $query) or die (mysqli_error($link));
		}
	}
	header('Location: /admin/blogs.php');
}

//BLOG VIEW

function blog_view() {

	$link = my_connect() or die (mysqli_error($link));
	$query = "SELECT * FROM blogs";
	$resultblogs = mysqli_query($link, $query) or die (mysqli_error($link));
	
	if (mysqli_num_rows($resultblogs) > 0) {

		if(empty($_GET['page']) or $_GET['page'] <= 1) {
			$_GET['page'] = 1;
			$page = $_GET['page'];
		} else {
			$page = $_GET['page'];
		}
	
		$notesOnPage = 4;
		$from = ($page - 1) * $notesOnPage;
		
		$query = "SELECT * FROM blogs ORDER BY date DESC LIMIT $from, $notesOnPage";
		$result = mysqli_query($link, $query) or die (mysqli_error($link));
		$blogs = mysqli_fetch_all($result, MYSQLI_ASSOC) or die (mysqli_error($link));
	
		$i = 1;
		foreach ($blogs as $blog) {
	        echo "<div class=\"blog{$i}\" id=\"blog{$i}\">";
	        echo "<p class=\"blogtext\">Дата добавления: " . $blog['date'] . "</p>";
	        echo "<p class=\"blogtext\">Автор: " . $blog['author'] . "</p>";
	        echo "<a href=\"article.php?id=" . $blog['id'] . "\"><img class=\"blogimg\" src=\"" . $blog['picture']. "\"></a>";
	        echo "<p class=\"description\">" . $blog['description'] . "</p>";
	        echo "</div>";
	        $i++;
		}
		if (mysqli_num_rows($resultblogs) > 4) {
			blog_buttons();
		}
	}
}

function blog_buttons() {

	$link = my_connect() or die (mysqli_error($link));
	$query = mysqli_query($link, "SELECT COUNT(*) FROM blogs");
	$rows = mysqli_fetch_row($query)[0];

	if(empty($_GET['page']) or $_GET['page'] <= 1) {
		echo "<a id =\"prev\" href=\"/?page=" . $_GET['page'] . "\">Сюда</a>";
	} else {
		echo "<a id =\"prev\" href=\"/?page=" . ($_GET['page'] - 1) . "\">Сюда</a>";  
	}
	if ($_GET['page'] < ceil($rows / 4)) {
		echo "<a id =\"next\" href=\"/?page=" . ($_GET['page'] + 1) . "\">Туда</a>";
	} else {
		echo "<a id =\"next\" href=\"/?page=" . $_GET['page'] . "\">Туда</a>";
	}
}

function blog_view_admin() {

	$link = my_connect() or die (mysqli_error($link));
	$query = "SELECT * FROM blogs";
	$resultBlogs = mysqli_query($link, $query) or die (mysqli_error($link));
	
	if (mysqli_num_rows($resultBlogs) > 0) {

		if(empty($_GET['page']) or $_GET['page'] <= 1) {
			$_GET['page'] = 1;
			$page = $_GET['page'];
		} else {
			$page = $_GET['page'];
		}
	
		$notesOnPage = 6;
		$from = ($page - 1) * $notesOnPage;

		// ВЫБОРКА КАТЕГОРИЙ
		$query = "SELECT DISTINCT blog_id, blogs.id as blogs_id, date, author, description, name FROM blogs INNER JOIN blog_cat on blogs.id=blog_cat.blog_id INNER JOIN categories on blog_cat.category_id=categories.id";
		$result = mysqli_query($link, $query) or die (mysqli_error($link));
		$cats = mysqli_fetch_all($result, MYSQLI_ASSOC) or die (mysqli_error($link));
		foreach ($cats as $key => $value) {
			$arr[] = [$value["blogs_id"] => $value['name']];
		}

		// ВЫБОРКА БЛОГОВ
		$query = "SELECT * FROM blogs LIMIT $from, $notesOnPage";
		$result = mysqli_query($link, $query) or die (mysqli_error($link));
		$blogs = mysqli_fetch_all($result, MYSQLI_ASSOC) or die (mysqli_error($link));
		foreach ($blogs as $blog) {
			echo "<tr>";
			echo "<td>" . $blog['id'] ."</td>";
            echo "<td>" . $blog['date'] ."</td>";
            echo "<td>" . $blog['author'] ."</td>";
            echo "<td>" . $blog['description'] ."</td>";
            echo "<td>";
            foreach ($arr as $key => $cat) {
            	foreach ($cat as $key => $value) {
            		if ($key == $blog['id']){
                   	echo $cat[$key] . '<br>';
            		}
            	}
            }
            echo "</td>";
            echo "<td><a id =\"blogtable\" href=\"blogedit.php?edit=" . $blog['id'] . "\"</a>Редактировать</td>";
            echo "<td><a id =\"blogtable\" href=\"?del=" . $blog['id'] . "\"</a>Удалить</td>";
            echo "</tr>";
		}
	}
}

function blog_buttons_admin() {
	$articleID = $_GET['id'];
	$uri = explode('?', $_SERVER['REQUEST_URI']);

	$link = my_connect() or die (mysqli_error($link));
	if ($uri[0] == '/admin/users.php') {
		$query = mysqli_query($link, "SELECT COUNT(*) FROM users");
	} elseif ($uri[0] == '/admin/blogs.php') {
		$query = mysqli_query($link, "SELECT COUNT(*) FROM blogs");
	} elseif ($uri[0] == '/admin/reviews.php') {
		$query = mysqli_query($link, "SELECT COUNT(*) FROM reviews");
	} elseif ($uri[0] == '/article.php') {
		$query = mysqli_query($link, "SELECT COUNT(*) FROM comments");
	}

	$rows = mysqli_fetch_row($query)[0];

	if ($uri[0] == '/article.php') {
		if(empty($_GET['page']) or $_GET['page'] <= 1) {
			echo "<a id =\"prev_admin\" href=\"?id=" . $articleID . "&page=" . $_GET['page'] . "\">Сюда</a>";
		} else {
			echo "<a id =\"prev_admin\" href=\"?id=" . $articleID . "&page=" . ($_GET['page'] - 1) . "\">Сюда</a>";  
		}
		if ($_GET['page'] < ceil($rows / 10)) {
			echo "<a id =\"next_admin\" href=\"?id=" . $articleID . "&page=" . ($_GET['page'] + 1) . "\">Туда</a>";
		} else {
			echo "<a id =\"next_admin\" href=\"?id=" . $articleID . "&page=" . $_GET['page'] . "\">Туда</a>";
		}
	} else {
		if(empty($_GET['page']) or $_GET['page'] <= 1) {
			echo "<a id =\"prev_admin\" href=\"?page=" . $_GET['page'] . "\">Сюда</a>";
		} else {
			echo "<a id =\"prev_admin\" href=\"?page=" . ($_GET['page'] - 1) . "\">Сюда</a>";  
		}
		if ($uri[0] == '/admin/blogs.php') {
			if ($_GET['page'] < ceil($rows / 6)) {
				echo "<a id =\"next_admin\" href=\"?page=" . ($_GET['page'] + 1) . "\">Туда</a>";
			} else {
				echo "<a id =\"next_admin\" href=\"?page=" . $_GET['page'] . "\">Туда</a>";
			}
		} else {
			if ($_GET['page'] < ceil($rows / 23)) {
				echo "<a id =\"next_admin\" href=\"?page=" . ($_GET['page'] + 1) . "\">Туда</a>";
			} else {
				echo "<a id =\"next_admin\" href=\"?page=" . $_GET['page'] . "\">Туда</a>";
			}
		}
	}
}

function blog_edit() {
	if (mb_strlen($_POST['blogdesc']) < 10 || mb_strlen($_POST['blogdesc']) > 512) {
		$errorMsg = 'Описание должено быть длиной от 10 до 512 символов';
		return $errorMsg; 
	} elseif (empty($_POST['category'])) {
		$errorMsg = 'Укажите хотя бы одну категорию';
		return $errorMsg;
	} elseif (mb_strlen($_POST['blogtext']) < 20) {
		$errorMsg = 'Текст должен быть длиной не менее 20 символов';
		return $errorMsg;
	} elseif ((!empty ($_FILES['attachment-file'])) && (my_upload() !== 'OK')) {
		$errorMsg = my_upload();
		return $errorMsg;
	} elseif (empty ($_FILES['attachment-file']['tmp_name'])) {
		$errorMsg = 'Добавьте картинку';
		return $errorMsg;
	} else {

		$link = my_connect() or die (mysqli_error($link));

		$description = $_POST['blogdesc'];
		$text = $_POST['blogtext'];
		$author = trim(mysqli_real_escape_string($link, $_SESSION['username']));
		
		$id = $_GET['edit'];
		$date = date('Y-m-d H:i:s');
		$query = "UPDATE blogs SET date='$date', description='$description', text='$text', author='$author' WHERE id=$id";
		$result = mysqli_query($link, $query) or die (mysqli_error($link));

		if (!empty ($_FILES['attachment-file']['tmp_name'])) {
			$pathInfo = pathinfo($_FILES['attachment-file']['name']);
		    $exp = $pathInfo['extension'];
		    $blogimg = '../img/blogimg/' . $id . '_img.' . $exp;
			move_uploaded_file($_FILES['attachment-file']['tmp_name'], $blogimg);
			$query = "UPDATE blogs SET picture='$blogimg' WHERE id='$id'";
			$result = mysqli_query($link, $query) or die (mysqli_error($link));
		} else {
			$query = "UPDATE blogs SET picture='../img/blogimg/stnd_blogimage.png' WHERE id='$id'";
			$result = mysqli_query($link, $query) or die (mysqli_error($link));
		}
		$query = "DELETE FROM blog_cat WHERE blog_id=$id";
		$result = mysqli_query($link, $query) or die (mysqli_error($link));
		foreach ($_POST['category'] as $category_id) {
			$query = "INSERT INTO blog_cat (blog_id, category_id) VALUES ('$id', '$category_id')";
			$result = mysqli_query($link, $query) or die (mysqli_error($link));
		}
	}

	header('Location: /admin/blogs.php');
}

function blog_edit_view() {
	$id = $_GET['edit'];
	$link = my_connect() or die (mysqli_error($link));
	$query = "SELECT blogs.id, blogs.description, blogs.text, categories.name as category_name FROM blogs INNER JOIN blog_cat ON blogs.id=blog_cat.blog_id INNER JOIN categories ON blog_cat.category_id=categories.id WHERE blogs.id=$id";
	$resultBlog = mysqli_query($link, $query) or die (mysqli_error($link));
	$blog = mysqli_fetch_all($resultBlog, MYSQLI_ASSOC) or die (mysqli_error($link));

	echo "<p class=\"categoryp\">Выберите категории:</p>";
	echo "<div class=\"categoryadddiv\">";
	categories($id, $blog);
	echo "</div>";
	echo "<p class=\"categoryp\">Введите описание блога:</p>";
	echo "<textarea class=\"blogadddesc\" name=\"blogdesc\">" . $blog[0]['description'] . "</textarea>";
	echo "<p class=\"categoryp\">Введите текст блога:</p>";
	echo "<textarea class=\"blogaddtext\" name=\"blogtext\">" . $blog[0]['text'] . "</textarea>";
	echo "<div class=\"example-2\">";
    echo "<label for=\"custom-file-upload\" class=\"filupp\"><span class=\"filupp-file-name js-value\">Загрузить картинку</span>";
    echo "<input type=\"file\" class=\"avatar\" name=\"attachment-file\" value=\"1\" id=\"custom-file-upload\" accept=\"image/jpeg,image/png\">";
    echo "</label>";
    echo "</div>";
    echo "<input class=\"regbtn\" type=\"submit\" name=\"blogedit\" value=\"Изменить\">";
}

function categories($id = null, $blog = null) {
	$link = my_connect() or die (mysqli_error($link));
	$query = "SELECT * FROM categories";
	$resultCat = mysqli_query($link, $query) or die (mysqli_error($link));
	$categories = mysqli_fetch_all($resultCat, MYSQLI_ASSOC) or die (mysqli_error($link));

	if (isset ($id) && isset ($blog)) {
		foreach ($blog as $catname) {
			$arr[] = $catname['category_name'];
		}

		$value = 1;
		foreach ($categories as $category) {
			if (in_array($category['name'], $arr)) {
				echo "<input type=\"checkbox\" id=\"category\" name=\"category[]\" value=\"" . $value . "\" multiple checked>" . $category['name'];
				$value++;
			} else {
				echo "<input type=\"checkbox\" id=\"category\" name=\"category[]\" value=\"" . $value . "\" multiple>" . $category['name'];
				$value++;	
			}
		}		
	} else {
		$value = 1;
		foreach ($categories as $category) {
		echo "<input type=\"checkbox\" id=\"category\" name=\"category[]\" value=\"" . $value . "\" multiple>" . $category['name'];
		$value++;
		}	
	}
}

function blog_del() {
	$id = $_GET['del'];
	$link = my_connect() or die (mysqli_error($link));
	$query = "SELECT picture FROM blogs WHERE id=$id";
	$resultBlogPic = mysqli_query($link, $query) or die (mysqli_error($link));
	$result = mysqli_fetch_assoc($resultBlogPic);
	$imagePath = $result['picture'];
	$query = "DELETE FROM blogs WHERE id=$id";
	$resultBlogDel = mysqli_query($link, $query) or die (mysqli_error($link));
	$query = "DELETE FROM blog_cat WHERE blog_id=$id";
	$resultCatDel = mysqli_query($link, $query) or die (mysqli_error($link));
	if ($imagePath != '../img/blogimg/stnd_blogimage.png') {
		unlink($imagePath);
	}
	$errorMsg = 'Блог удален';
	return $errorMsg;
}

// ADMIN HOME PAGE
function statistics() {
	$link = my_connect() or die (mysqli_error($link));
	$query1 = mysqli_query($link, "SELECT COUNT(*) FROM blogs");
	$blogs = mysqli_fetch_row($query1)[0];
	$query2 = mysqli_query($link, "SELECT COUNT(*) FROM users");
	$users = mysqli_fetch_row($query2)[0];
	$query3 = mysqli_query($link, "SELECT COUNT(*) FROM comments");
	$comments = mysqli_fetch_row($query3)[0];
	$query4 = mysqli_query($link, "SELECT COUNT(*) FROM reviews");
	$reviews = mysqli_fetch_row($query4)[0];
	echo "<p id=\"count\">Всего опубликовано <span id=\"number\">$blogs</span> блогов.</p>";
	echo "<p id=\"count\">Всего зарегистрировано <span id=\"number\">$users</span> пользователей.</p>";
	echo "<p id=\"count\">Всего оставлено <span id=\"number\">$comments</span> комментариев.</p>";
	echo "<p id=\"count\">Всего оставлено <span id=\"number\">$reviews</span> отзывов.</p>";
}

// ADD REVIEWS
function review_submit() {
	if ($_SESSION['auth'] !== true) {
		$errorMsg = 'Чтобы оставить отзыв необходимо авторизоваться!';
		return $errorMsg;
	} elseif (mb_strlen($_POST['review']) > 1000) {
		$errorMsg = 'Отзыв не может быть длиннее 1000 символов!';
		return $errorMsg;
	} else {
		$review = $_POST['review'];
		$userID = $_SESSION['userid'];
	
		$link = my_connect() or die (mysqli_error($link));
		$query = "INSERT INTO reviews SET user_id={$userID}, review='$review'";
		$resultUsers = mysqli_query($link, $query) or die (mysqli_error($link));

		$errorMsg = 'Спасибо за отзыв!';
		return $errorMsg;
	}
}

function reviews_view() {
	$link = my_connect() or die (mysqli_error($link));
	$query = "SELECT * FROM reviews";
	$resultReviews = mysqli_query($link, $query) or die (mysqli_error($link));
	
	if (mysqli_num_rows($resultReviews) > 0) {

		if(empty($_GET['page']) or $_GET['page'] <= 1) {
			$_GET['page'] = 1;
			$page = $_GET['page'];
		} else {
			$page = $_GET['page'];
		}
	
		$notesOnPage = 23;
		$from = ($page - 1) * $notesOnPage;
		

		$query = "SELECT *, reviews.id as reviews_id FROM reviews INNER JOIN users ON reviews.user_id=users.id ORDER BY date DESC LIMIT $from, $notesOnPage";
		$result = mysqli_query($link, $query) or die (mysqli_error($link));

		$reviews = mysqli_fetch_all($result, MYSQLI_ASSOC) or die (mysqli_error($link));
		foreach ($reviews as $review) {
			echo "<tr>";
			echo "<td>" . $review['reviews_id'] ."</td>";
            echo "<td>" . $review['username'] ."</td>";
            echo "<td>" . $review['date'] ."</td>";
            echo "<td><a id =\"blogtable\" href=\"reviewread.php?readrev=" . $review['reviews_id'] . "\"</a>Читать</td>";
            echo "<td><a id =\"blogtable\" href=\"?delrev=" . $review['reviews_id'] . "\"</a>Удалить</td>";
            echo "</tr>";
		}
	}
}

function review_del() {
	$link = my_connect() or die (mysqli_error($link));
	$query = "DELETE FROM reviews WHERE id={$_GET['delrev']}";
	$resultReviewDel = mysqli_query($link, $query) or die (mysqli_error($link));
	$errorMsg = 'Отзыв удален';
	return $errorMsg;
}

function review_read($id) {
	$link = my_connect() or die (mysqli_error($link));
	$query = "SELECT *, users.id as user_id FROM reviews INNER JOIN users ON reviews.user_id=users.id WHERE reviews.id=$id";
	$resultReview = mysqli_query($link, $query) or die (mysqli_error($link));
	$reviewRead = mysqli_fetch_all($resultReview, MYSQLI_ASSOC);

	foreach ($reviewRead as $key => $value) {
		echo "<p class=\"reviewRead\">Автор: <span class=\"reviewspan\">" . $value['username'] . "</span></p>";
		echo "<p class=\"reviewRead\"> Дата добавления: <span class=\"reviewspan\">" . $value['date'] . "</span></p>";
		echo "<textarea class=\"reviewarea\">" . $value['review'] . "</textarea>";
	}
}

// ADMIN USERS
function users_view() {
	$link = my_connect() or die (mysqli_error($link));
	$query = "SELECT * FROM users";
	$resultUsers = mysqli_query($link, $query) or die (mysqli_error($link));
	
	if (mysqli_num_rows($resultUsers) > 0) {

		if(empty($_GET['page']) or $_GET['page'] <= 1) {
			$_GET['page'] = 1;
			$page = $_GET['page'];
		} else {
			$page = $_GET['page'];
		}
	
		$notesOnPage = 23;
		$from = ($page - 1) * $notesOnPage;
		

		$query = "SELECT *, users.id as user_id FROM users INNER JOIN status ON status.id=users.status_id ORDER BY user_id LIMIT $from, $notesOnPage";
		$result = mysqli_query($link, $query) or die (mysqli_error($link));

		$users = mysqli_fetch_all($result, MYSQLI_ASSOC) or die (mysqli_error($link));

		foreach ($users as $user) {
			echo "<tr>";
			echo "<td>" . $user['user_id'] . "</td>";
            echo "<td>" . $user['username'] . "</td>";
            echo "<td>" . $user['status'] . "</td>";
            echo "<td><a id =\"blogtable\" href=\"?del=" . $user['user_id'] . "\"</a>Удалить</td>";
            if ($user['banned'] == 0) {
            	echo "<td><a id =\"blogtable\" href=\"?ban=" . $user['user_id'] . "\"</a>Забанить</td>";
            } elseif ($user['banned'] == 1) {
            	echo "<td><a id =\"blogtable\" href=\"?ban=" . $user['user_id'] . "\"</a>Разбанить</td>";
            }
            echo "<td><a id =\"blogtable\" href=\"userstatus.php?status=" . $user['user_id'] . "\"</a>Сменить статус</td>";
            echo "</tr>";
		}
	}
}

function user_del() {
	$id = $_GET['del'];
	if ($_SESSION['userid'] == $id) {
		$errorMsg = 'Нельзя удалить текущего пользователя';
		return $errorMsg;
	}
	$link = my_connect() or die (mysqli_error($link));
	$query = "SELECT avatar FROM users WHERE id=$id";
	$resultUserAva = mysqli_query($link, $query) or die (mysqli_error($link));
	$result = mysqli_fetch_assoc($resultUserAva);
	$AvaPath = $result['avatar'];
	$query = "DELETE FROM users WHERE id=$id";
	$resultBlogDel = mysqli_query($link, $query) or die (mysqli_error($link));
	if ($AvaPath != 'img/avatars/stnd_ava.png') {
		$path = '../' . $AvaPath;
		unlink($path);
	}
	$errorMsg = 'Пользователь удален';
	return $errorMsg;
}

function user_ban() {
	$id = $_GET['ban'];
	if ($_SESSION['userid'] == $id) {
		$errorMsg = 'Нельзя забанить текущего пользователя';
		return $errorMsg;
	}
	$link = my_connect() or die (mysqli_error($link));
	$query = "SELECT * FROM users WHERE id=$id";
	$resultUser = mysqli_query($link, $query) or die (mysqli_error($link));
	$user = mysqli_fetch_all($resultUser, MYSQLI_ASSOC) or die (mysqli_error($link));
	if ($user[0]["banned"] == 0) {
		$query = "UPDATE users SET banned=1 WHERE id=$id";
		$resultUser = mysqli_query($link, $query) or die (mysqli_error($link));
		header('Location: /admin/users.php');
	} elseif ($user[0]["banned"] == 1) {
		$query = "UPDATE users SET banned=0 WHERE id=$id";
		$resultUser = mysqli_query($link, $query) or die (mysqli_error($link));

		header('Location: /admin/users.php');
	}

}

function user_status() {
	$id = $_GET['status'];

	$link = my_connect() or die (mysqli_error($link));
	$query = "SELECT * FROM status";
	$resultStatus = mysqli_query($link, $query) or die (mysqli_error($link));
	$status = mysqli_fetch_all($resultStatus, MYSQLI_ASSOC) or die (mysqli_error($link));

	$query = "SELECT *, users.id as user_id FROM users INNER JOIN status ON status.id=users.status_id WHERE users.id=$id";
	$result = mysqli_query($link, $query) or die (mysqli_error($link));
	$user = mysqli_fetch_all($result, MYSQLI_ASSOC) or die (mysqli_error($link));

	echo "<div class=\"categoryadddiv\">";
		foreach ($status as $value) {
			if ($user[0]['status'] == $value['status']) {
				echo "<input type=\"radio\" id=\"category\" name=\"statusname\" value=\"" . $value['id'] . "\"checked>" . $value['status'];
			} else {
				echo "<input type=\"radio\" id=\"category\" name=\"statusname\" value=\"" . $value['id'] . "\">" . $value['status'];
				
			}		
		}
	echo "</div>";
	echo "<input class=\"regbtn\" type=\"submit\" name=\"statusupdate\" value=\"Изменить\">";
}

function user_status_update() {
	$id = $_GET['status'];
	$statusId = $_POST['statusname'];

	if ($_SESSION['userid'] == $id) {
		$errorMsg = 'Нельзя менять статус текущего пользователя';
		return $errorMsg;
	}

	$link = my_connect() or die (mysqli_error($link));
	$query = "UPDATE users SET status_id=$statusId WHERE id=$id";
	$resultStatus = mysqli_query($link, $query) or die (mysqli_error($link));

	header('Location: /admin/users.php');
}

function article_view($id) {
	$link = my_connect() or die (mysqli_error($link));
	$query = "SELECT * FROM blogs WHERE id=$id";
	$resultArt = mysqli_query($link, $query) or die (mysqli_error($link));
	$article = mysqli_fetch_all($resultArt, MYSQLI_ASSOC) or die (mysqli_error($link));

	$query = "SELECT name FROM blog_cat INNER JOIN categories on category_id=categories.id WHERE blog_id=$id";
	$resultCat = mysqli_query($link, $query) or die (mysqli_error($link));
	$categories = mysqli_fetch_all($resultCat, MYSQLI_ASSOC) or die (mysqli_error($link));

	echo "<p class='art'><span class='art_span'>Автор: </span>" . $article[0]['author'] . "</p>";
	echo "<p class='art'><span class='art_span'>Дата создания: </span>" . $article[0]['date'] . "</p>";
	foreach ($categories as $key => $value) {
		foreach ($value as $key => $category) {
			$categ .= $category . '; ';
		}
	}
	$cat = rtrim($categ, ";	 ");
	echo "<p class='art'><span class='art_span'>Категории: </span>" . $cat . "</p>";
	echo "<p class='art'><span class='art_span'>Описание: </span>" . $article[0]['description'] . "</p>";
	echo "<img class='art_img' src=\"" . $article[0]['picture'] . "\">";
	echo "<hr color='#EE0C44'>";
	echo "<pre class='art_pre'>" . $article[0]['text'] . "</pre>";
	echo "<hr color='#EE0C44'><br>";
}

function comment_add() {
	$comment = trim($_POST['comment']);
	$blog_id = $_GET['id'];
	$author = $_SESSION['username'];

	$link = my_connect() or die (mysqli_error($link));
	$query = "INSERT INTO comments (author, comment) VALUES ('$author', '$comment')";
	$resultComment = mysqli_query($link, $query) or die (mysqli_error($link));
	$comment_id = mysqli_insert_id($link);

	$query = "INSERT INTO comments_blogs (blog_id, comment_id) VALUES ($blog_id, $comment_id)";
	$resultCommentBlog = mysqli_query($link, $query) or die (mysqli_error($link));
}

function comments_view() {
	$blog_id = $_GET['id'];

	$link = my_connect() or die (mysqli_error($link));
	$query = "SELECT * FROM comments_blogs WHERE blog_id=$blog_id";
	$resultComments = mysqli_query($link, $query) or die (mysqli_error($link));

	if(empty($_GET['page']) or $_GET['page'] <= 1) {
		$_GET['page'] = 1;
		$page = $_GET['page'];
	} else {
		$page = $_GET['page'];
	}
	$notesOnPage = 10;
	$from = ($page - 1) * $notesOnPage;

	if (mysqli_num_rows($resultComments) > 0) {
		$query = "SELECT comments.id, comments.author, comments.date, comment, avatar FROM users RIGHT JOIN comments ON users.username=comments.author INNER JOIN comments_blogs ON comments.id=comments_blogs.comment_id INNER JOIN blogs ON comments_blogs.blog_id=blogs.id WHERE blogs.id=$blog_id ORDER BY date DESC LIMIT $from, $notesOnPage";
		$result = mysqli_query($link, $query) or die (mysqli_error($link));
		$comment = mysqli_fetch_all($result, MYSQLI_ASSOC) or die (mysqli_error($link));
		foreach ($comment as $key => $value) {
				echo "<div class=\"comment\">";
				echo "<div class=\"imgauthor\">";
				echo "<img class=\"commentimg\" src=\"" . $value['avatar'] . "\">";
				echo "<span class=\"commentauthor\">" . $value['author'] . "</span><br>";
				echo "<span class=\"commentauthor\">" . $value['date'] . "</span><br>";
				if ($_SESSION['status'] == 3) {
					echo "<a href=\"admin/commentdel.php?comdel=" . $value['id'] . "\" name=\"commentdel\" id=\"commentdel\">Удалить</a>";
				}
				echo "</div>";
				echo "<div class=\"commentspan\"><pre>" . $value['comment'] . "</pre></div>";
				echo "</div>";
		}
		if (mysqli_num_rows($resultComments) > 10) {
			blog_buttons_admin();
		}
	}
}

function comment_del($id) {
	$link = my_connect() or die (mysqli_error($link));
	$query = "DELETE FROM comments WHERE id=$id";
	$result = mysqli_query($link, $query) or die (mysqli_error($link));
	$query = "DELETE FROM comments_blogs WHERE comment_id=$id";
	$result = mysqli_query($link, $query) or die (mysqli_error($link));
	header('Location: ' . $_SERVER["HTTP_REFERER"]);
}