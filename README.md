### Описание

Консольная утилита которая позволяет слушать песни из разных источников. На данным момент есть возможность прослушать песню из ютуба и с локального компа.

### Зависимости

Для корректной работы данной утилиты нужно установить эти зависимости:
* php 8.0
* composer
* mpv

После установки этих зависимостей, в корне проекта выполняем эту команду:
```
composer install --no-dev
```

### Запуск

После того как мы установили зависимости и выполнили команду, мы можем воспользоваться программой. 

Но чтобы слушать песни, нам сперва нужно добавить песни которые мы будем слушать, программа же не знает, что вы хотите прослушать. 
И чтобы дать понять что нужно воспроизводить, нам нужно создать файл `lists.json`. 

Этот файл будет парситься и программа будет брать от туда песни для воспроизведения, его то и мы должны заполнить.

Пример заполнения:
```
[
    ["https://www.youtube.com/watch?v=znZiSZHcQaU", "Title for song"], // Указываем сюда ссылки ютуба
    ["/home/user/Music/file_.mp3", "Title for song"], // Указываем сюда путь до файла
    ["/home/user/Music/file_.mp3", "Title for song"],
    ["https://www.youtube.com/watch?....", "Title for song"], 
    ["/home/user/Music/....mp3", "Title for song"],
    ["https://www.youtube.com/watch?....", "Title for song"], 
    ["/home/user/Music/....mp3", "Title for song"],
    .....
]
```

Т.е мы заполняем просто массив данных. Как пример, можете посмотреть структуру `lists.example.json`, так и должен выглядеть `lists.json`.

Бонус от автора, это песни в `lists.example.json` :)


### Доступность глобально

Чтобы иметь возможность использовать программу глобально, есть два способа:

1. Добавить путь до radion-файла в PATH
2. Создать символическую ссылку на radion-файл и переместить в /bin (/usr/bin)

Мы воспользуемся вторым способом. Выполняем эту команду:
```
ln -s path_to_radion /usr/bin/radion

Пример:
ln -s /usr/share/radion/radion /usr/bin/radion
```

Может вам нужно будет выполнить эту команду с **sudo**, все равно выполняйте. Дальше можно проверять работоспособность, выполнив команду `radion` в любом месте.



### Интерфейс

Теперь, после установки и заполнения `lists.json`, мы можем уже слушать наши песни!

Вот список доступных команд:

`radion play` - воспроизведение песни

`radion stop` - остановка воспроизводящей песни

`radion next` - перемотка на следующую песню

`radion prev` - отмотка песни на предыдущую

`radion lists` - показать все доступные песни

