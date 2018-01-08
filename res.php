<?php

require_once  __DIR__ . '/M_Post.php';

if (isset($_POST['send'])) {

	$values = M_Post::sendUsers();
	echo 'Пользователи выгружены в файл! ';
	require_once  __DIR__ . '/sheet.php';

} elseif (isset($_POST['save'])) {

	$name = M_Post::clearStr($_POST['name']);
	$surname = M_Post::clearStr($_POST['surname']);
	$age = (int)($_POST['age']);

	if ($name && $surname && $age) {

		$users = M_Post::saveUsers($name, $surname, $age);

		if ($users) {
			echo 'Пользователь сохранен!';
		} else {
			echo 'Ошибка сохранения в Базу';
		}

	} else {
		echo 'Ошибка сохранения в базу. Заполните все поля!';
	}	

} else {
	echo 'Ошибка запроса';
}

