Краткое описание файлов:
import_litres_data.php  – Пример работы API get_fresh_book. основной скрипт для работы с API. Импортирует данные из xml потока Литреса в локальную sql базу партнера в таблицу litres_data (для создания таблицы litres_data используйте файл dump.php)
Можно настроить под себя: убираем подключение include("config.php"), если не хотим использовать для Wordpress или DLE.
dump.php                - сведения для создания таблицы litres_data
checklist.php           - выводит в браузер список не совпавших книг (работает с существующей базой книг партнера движка Wordpress или DLE)
compare_bases.php       - сравнение базы книг литрес (из таблицы litres_data) и локальных книг партнера (работает с существующей базой книг партнера движка Wordpress или DLE)
functions.php           - основные функции, нужны для Wordpress или DLE плагина
config.php              - utm метки admon заполняются тут

Плагин для вордпресса
http://erminesoft.ru/wp-litres-plugin.4.0.2.zip

Плагин для DLE - UTF-8 версия
http://erminesoft.ru/dle-litres-plugin.4.0.2.zip

Плагин для DLE - Windows-1251 версия
http://erminesoft.ru/dle-litres-plugin-win1251.4.0.2.zip