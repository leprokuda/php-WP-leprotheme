<?php
/*
Template Name: main
*/
    get_header();
?>

<body>

  <!--   Подключаем Яндекс.Карты   -->
  <script type="text/javascript">
    // Функция ymaps.ready() будет вызвана, когда
    // загрузятся все компоненты API, а также когда будет готово DOM-дерево.
    ymaps.ready(init);

    function init() {
        var myMap = new ymaps.Map('map', {
                center: [55.7, 37.5],
                zoom: 4,
                controls: ['zoomControl']
            }),
            // Создаем коллекцию.
            myCollection = new ymaps.GeoObjectCollection(),
            // Создаем массив с данными.
            myPoints = clinicPoints;

        // Заполняем коллекцию данными.
        for (var i = 0, l = myPoints.length; i < l; i++) {
            var point = myPoints[i];
            myCollection.add(new ymaps.Placemark(
                point.coords, {
                    balloonContentBody: point.text
                }
            ));
        }

        // Добавляем коллекцию меток на карту.
        myMap.geoObjects.add(myCollection);

        // Создаем экземпляр класса ymaps.control.SearchControl
        var mySearchControl = new ymaps.control.SearchControl({
            options: {
                // Заменяем стандартный провайдер данных (геокодер) нашим собственным.
                provider: new CustomSearchProvider(myPoints),
                // Не будем показывать еще одну метку при выборе результата поиска,
                // т.к. метки коллекции myCollection уже добавлены на карту.
                noPlacemark: true,
                resultsPerPage: 5
            }});

        // Добавляем контрол в верхний правый угол,
        myMap.controls
            .add(mySearchControl, { float: 'right' });
    }


    // Провайдер данных для элемента управления ymaps.control.SearchControl.
    // Осуществляет поиск геообъектов в по массиву points.
    // Реализует интерфейс IGeocodeProvider.
    function CustomSearchProvider(points) {
        this.points = points;
    }

    // Провайдер ищет по полю text стандартным методом String.ptototype.indexOf.
    CustomSearchProvider.prototype.geocode = function (request, options) {
        var deferred = new ymaps.vow.defer(),
            geoObjects = new ymaps.GeoObjectCollection(),
            // Сколько результатов нужно пропустить.
            offset = options.skip || 0,
            // Количество возвращаемых результатов.
            limit = options.results || 20;

        var points = [];
        // Ищем в свойстве text каждого элемента массива.
        for (var i = 0, l = this.points.length; i < l; i++) {
            var point = this.points[i];
            if (point.text.toLowerCase().indexOf(request.toLowerCase()) != -1) {
                points.push(point);
            }
        }
        // При формировании ответа можно учитывать offset и limit.
        points = points.splice(offset, limit);
        // Добавляем точки в результирующую коллекцию.
        for (var i = 0, l = points.length; i < l; i++) {
            var point = points[i],
                coords = point.coords,
                text = point.text;

            geoObjects.add(new ymaps.Placemark(coords, {
                name: text + ' name',
                description: text + ' description',
                balloonContentBody: '<p>' + text + '</p>',
                boundedBy: [coords, coords]
            }));
        }

        deferred.resolve({
            // Геообъекты поисковой выдачи.
            geoObjects: geoObjects,
            // Метаинформация ответа.
            metaData: {
                geocoder: {
                    // Строка обработанного запроса.
                    request: request,
                    // Количество найденных результатов.
                    found: geoObjects.getLength(),
                    // Количество возвращенных результатов.
                    results: limit,
                    // Количество пропущенных результатов.
                    skip: offset
                }
            }
        });

        // Возвращаем объект-обещание.
        return deferred.promise();
    };
</script>

  <div class="header container">
    <?php
      wp_nav_menu([
        'theme_location' => 'top',
        'container' => 'container',
        'menu_class' => 'header__menu',
        'menu_id' => ''
      ])
    ?>
  </div>
  
  <div class="main container">
    <h2 class="page-title"><?php the_title();?></h2>
    
    <div id="map" class="my-map">
      <?= the_content() ?>
      
      <script type="text/javascript">
          const clinicPosts =
              `
                <?php $clinics_posts = get_posts(
                    array(
                        'post_type' => 'clinics',
                        'numberposts' => '20',
                    )
                );
                echo json_encode($clinics_posts);
                ?>
              `
          const parsedPosts = JSON.parse(clinicPosts)
          const postTitles = parsedPosts.map(el => el.post_title)
          const clinicCoordinates =
              `
                <?php
                  $clinics_posts = get_posts(
                    array(
                      'post_type' => 'clinics',
                      'numberposts' => '20',
                    )
                  );
                  foreach ($clinics_posts as $post) {
                      echo get_field('place');
                      echo '; ';
                  }
                ?>
              `
          const arrayCoordinates = clinicCoordinates.trim().split('; ')
          const coords = arrayCoordinates.map(el => el.replace(';', '').split(', '))
          const clinicPoints = []
          for (var i = 0; i < parsedPosts.length; i++) {
            const point = {
                text: postTitles[i],
                coords: coords[i]
            }
            clinicPoints.push(point)
          }
          console.log(clinicPoints)
      </script>
      
    </div>
    
  </div>



</body>

<?php get_footer();?>
