### Описание

Консольная утилита которая позволяет слушать песни из разных источников. На данным момент есть возможность прослушать песню из ютуба и с локального компа.

### Зависимости

Для корректной работы программы, нужно установить эти зависимости:
* php 8.0
* mpv


### Установка

Есть два способа установки:
1. Локально
2. Глобально

_Локально_ - это когда мы устанавливаем в определенную папку и чтобы использовать программу, нужно будет заходить в эту папку и там запускать.

_Глобально_ - это когда мы устанавливаем в `~/.config/composer` и наша программа будет доступна глобально, везде, в любой директорий. Рекомендую этот способ.

**Локально**

```
composer require nero/radion
```

Заходим в папку в которую установили программу и обращаться к интерфейсу можем по `./radion command`


**Глобально**
```
composer global require nero/radion
```

После установки, можем где угодно сделать `radion command` и команда выполниться.


### Запуск

После установки мы можем пользоваться программой.

Но чтобы слушать песни, нам сперва нужно добавить песни которые мы будем слушать, программа же не знает, что вы хотите прослушать. 
Чтобы дать понять, что нужно воспроизводить, нам нужно добавить песню. 

Делается это с помощью, вот такой команды:

```
radion add "https://www.youtube.com/watch?v=sOiMD45QGLs" "Title song"

or

radion add "/home/user/Music/file.mp3" "Title song"
```

Бонус от автора, это песни в `lists.example.json` :)


### Интерфейс

Теперь, после установки и добавления песен, мы можем уже слушать наши песни!

Вот список доступных команд:

`radion play` - воспроизведение песни

`radion stop` - остановка воспроизводящей песни

`radion next` - перемотка на следующую песню

`radion prev` - отмотка песни на предыдущую

`radion lists` - показать все доступные песни

`radion add "absolute_path_to_mp3 || youtube_link" "Song title"` - добавление песни в список воспроизводимых

