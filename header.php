<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script
      src="https://api-maps.yandex.ru/2.1/?apikey=38132be4-7458-41e9-a522-7e70672cfb8e&lang=ru_RU" type="text/javascript">
    </script>
    <title><?php if(is_404()) {echo 'Ошибка 404';} else {the_title();}?></title>
  <?php wp_head(); ?>
</head>