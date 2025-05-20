# Unified Communication Microservice

---

## Описание / Description

Этот проект представляет собой микросервис для управления сообщениями, каналами и WebRTC видеозвонками на PHP 8.2 (native PHP, MVC), дополненный микросервисом на Python для мультиплексирования и записи звонков. Веб-интерфейс реализован на jQuery.

This project is a microservice for managing messages, channels, and WebRTC video calls using native PHP 8.2 (MVC architecture), complemented by a Python microservice for multiplexing and recording calls. The web UI is implemented with jQuery.

---

## Структура проекта / Project structure

/php-microservice/ # PHP код: модели, контроллеры, виды, маршруты
/python-multimedia-service/ # Python WebSocket сервер для звонков и записи
/public_html/ # Публичная часть, включая UI на jQuery и точки входа
/call_records/ # Папка для записей звонков (создаётся автоматически)
/README.md # Этот файл
/LICENSE # Лицензия MIT


---

## Требования / Requirements

- PHP 8.2+
- Web сервер с поддержкой PHP (например, Apache, Nginx + PHP-FPM)
- Python 3.8+
- Пакет Python: `websockets` (`pip install websockets`)
- Поддержка WebSocket в браузере

---

## Установка и запуск / Installation and Running

### 1. Настройка PHP микросервиса

- Скопируйте папку `php-microservice` на сервер с PHP.
- Настройте вебсервер на доступ к `public_html`.
- Импортируйте миграции в вашу БД MySQL/PostgreSQL (используйте скрипты из `php-microservice/migrations`).
- Настройте .htaccess или другие правила для авторизации в админке.

### 2. Запуск Python микросервиса

- Перейдите в папку `python-multimedia-service`.
- Установите зависимости:  
  ```bash
  pip install websockets

    Создайте папку call_records в корне проекта (рядом с python-multimedia-service).

    Запустите сервис:

    python server.py

3. Запуск веб-интерфейса

    Откройте в браузере адрес вашего сервера.

    Для звонков UI подключается к WebSocket серверу на порту 8765 (настройте адрес в конфиге JS).

Использование / Usage

    Управляйте каналами и сообщениями через админку.

    Совершайте видеозвонки через UI.

    Все звонки записываются в call_records в формате JSON (сигнализация).

    Историю сообщений и звонков можно просмотреть через админку и UI.

Лицензия / License

MIT License
Дополнительно / Additional notes

    Запись медиа потоков (аудио/видео) не реализована — используйте специализированные медиасерверы (Janus, Kurento).

    Все компоненты могут работать локально в изолированной сети.

    Рекомендуется использовать SSL/TLS для WebSocket соединений в продакшене.

Контакты / Contacts

По вопросам и предложениям открывайте issue или свяжитесь напрямую.


Если хочешь, могу подготовить архив с этим README и файлами или помочь с отдельными файлами.

You said:
