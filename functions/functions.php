<?php
// HEADER

function visitor_name() {
	if (empty ($_SESSION['username'])) {
		$name = "Гость!";
	} else {
		$name = $_SESSION['username'] . '!';
	}

	if (date('G') >= 5 and date('G') <= 12) {
		return "Доброе утро, " . $name;
	} elseif (date('G') > 12 and date('G') <= 17) {
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

function header_menu() {
	if (empty ($_SESSION['login'])) {
		$headerMenu = [
			'Регистрация' => 'registr.php',
			'Войти' => 'login.php'
		];

		$result = '';

		foreach ($headerMenu as $name => $href) {
			$result .= "<div class=\"login\"><a id =\"top\" href =$href>$name</a></div>";
		}

		return $result;
	} else {}
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