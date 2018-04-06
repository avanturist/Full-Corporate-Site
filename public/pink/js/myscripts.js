jQuery(document).ready(function ($) {
    $('.commentlist .comment').each(function (i) {
        /*номер кожного коммента до блока з класом commentNumber та # додаємо номер */
            $(this).find('div.commentNumber').text('#' + (i+1));
    });

            //--------відправка форми-----
        $('#commentform').on('click', '#submit', function (e) {
            //e-обєкт текущего собітия
            e.preventDefault();//клікаємо по сабміту і нічого не передажться томущо ми заборонили стандартну поведінку для кнопки
            //
            $('.wrap_result').css('color','blue').text('Сoхранение коментария').fadeIn(500,function(){
                //запрос типа ajax по відправки форми коментарію
                //витягуємо дані із полів форми
                var Adata = $('#commentform').serializeArray();
                //alert(data);
                $.ajax({
                    /*витягуємо атрибут -action- з форми де прописаний адрес*/
                    url:$('#commentform').attr('action'),
                    /*метод data спецфайл даних що буде відправлений на сервер */
                    data:Adata,
                    headers:{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type:'post',
                    /*dataType в якому вигляды ми бажаэмо получити дані*/
                    dataType:'JSON',
                    /*функція яка виконається в результаті успішного запроса*/
                    success:function (result) {
       //---КОД у випадку УСПІШНОГО ЗАПРОСУ AJAX ДО СЕРВЕРА-------------------------------------------
                        if(result.error){
                            //якщо в resulti є яцейка error (ми її передаємо у помилці валідаціі)

                            $('.wrap_result').css('color','red').append('<br /><strong>Ошибка:<br /></strong>' + result.error.join('<br />')).delay(2000).fadeOut(3000);
                        }
                        else if(result.success){
                            $('.wrap_result').append('<br/><strong>Сохранено</strong>').delay(2000).fadeOut(500, function () {
                                //перевірка чи є коментарій є відповідю на раніше добавлений комент
                                //якщо в переданих даних є parent_id > 0 то значить це відповідь на коментарій
                                if(result.data.parent_id > 0){
                                    // Повертаємо ВІДПОВІДЬ НА конкретний коммент який вже був раніше добавлений
                                        $('#submit').parents('div#respond').prev().after('<ul class ="children">' + result.comment + '</ul>')
                                }
                                else {
                                    // цей бок спрацює коли користувач добавляє батьківський коммент--
                                    //не перший тобто якщо вже існує мін 1 батьківський комент.(тоді список <ol> з класом commentlist існує  )
                                   if("ol:contains(commentlist)" ){
                                        //добавляємо на початок свіжий коммента
                                       $('.commentlist').prepend(result.comment);

                                   }
                                   else{
                                       //тут юзер добавляє перший коментарій, та створює список <ol>
                                        $('#respond').before('<ol class="commentlist group">' + result.comment + '</ol>');
                                   }

                                }

                                //закриваємо формочку імітуючи клік по кнопці Cancel reply
                                $('#cancel-comment-reply-link').click();
                            });
                        }
                    },
                    error:function () {
        //---якщо  AJAX не може зробити УСПІШНИЙ запрос до СЕРВЕРА ---------------
                        $('.wrap_result').css({'color':'red', 'font-size':'18px'}).append('<br /><strong>Ошибка сервера</strong>').delay(2000).fadeOut(500);

                    }
                    });
            });
        });



});


/*script for filtration portfolios*/

jQuery(document).ready(function ($) {
    $('.block button').click(function () {
        $('.current').removeClass('current');
        $(this).addClass('current');

        var el = $(this).text().toLowerCase().replace(' ', '-');
        //document.getElementById('show').innerHTML = el;

        if( el == 'all'){
            $('div.related_project').removeClass('hidden');
        }
        else{
            $('div.related_project').each(function () {
                if( $(this).hasClass(el) ){
                    $(this).removeClass('hidden');
                }
                else{
                    $(this).addClass('hidden');
                }
            })
        }

    })

});

