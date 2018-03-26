<?php

/**
 * Класс БД
 *
 * Предназначен для соединения с базой данных - web приложения
 * включает в себя все необходимые настройки
 *
 */

class db {

	static $mysqli;
	static $last;

    /**
     * Метод construct
     *
     * Предназначен для соединения с необходимой базой данных - web приложения
     * через интерфейс mysqli - расширение
     *
     */

	public function __construct() {
		//Введите свои данные: "hostname.tld", "user", "password", "database"
		$this->mysqli = mysqli_connect('localhost', 'user', 'password', 'dbname');

	}

    /**
     * Функция обработки sql запроса
     *
     * @param $sql
     * @return array
     */

	public function query($sql) {
        /**
         * Берем аргументы функции (которые к нам пришли в массиве)
         */
        $args = func_get_args();
        /**
         * Выделили первый аргумет из начала массива
         */
		$sql = array_shift($args);
        /**
         * Фильтр массива
         */
        $link = $this->mysqli;
		$args = array_map(function ($param) use ($link) {
			return "'".$link->escape_string($param)."'";//экранирование
		},$args);
        /**
         * Замена символов
         * экранирование %
         * знак ? на %s
         */
		$sql = str_replace(array('%','?'), array('%%','%s'), $sql);
        /**
         * Поместили обратно в массив с аргументами
         */
		array_unshift($args, $sql);
        /**
         * В функцию sprintf поместили все пришедшие аргументы
         * Получаем готовый sql запрос
         */
		$sql = call_user_func_array('sprintf', $args);
        /**
         * Формируем last запрос
         */
		$this->last = mysqli_query($this->mysqli, $sql);
		if ($this->last === false) throw new Exception('Database error: '.$this->mysqli->error);
		return $this;
	}

    /**
     * Возвращает результат last запроса
     */

	public function assoc() {
		return $this->last->fetch_assoc();
	}

    /**
     * Возвращает все из last запроса
     *
     * @return array $result
     */

	public function all() {
		$result = array();
		while ($row = $this->last->fetch_assoc()) $result[] = $row;
		return $result;
	}

}