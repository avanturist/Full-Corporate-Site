<div class="content group" id="content-page" >
        <div class="hentry group ">
            <h3>Главное меню сайта</h3>
            <div class="short-table ">
               <table class="table ">
                   <thead>
                        <tr>
                            <th>Заголовок</th>
                            <th>Путь(ссылка)</th>
                            <th>Действие</th>
                        </tr>
                   </thead>
                   <tbody>
                       @if($menus)
                           <!-- roots() повертає батьківське меню -->
                            @include(config('settings.theme').'.Admin.Menu.customMenuItems', ['items'=>$menus->roots(), 'paddingLeft'=>''])
                        @endif
                   </tbody>
               </table>
            </div>
            {!! link_to('admin/menus/create','Добавить меню',['class'=>'btn btn-add']) !!}
        </div>
</div>


