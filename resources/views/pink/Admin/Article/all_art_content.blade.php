@if($allArt)
    <div id="content-page" class="content group" >
        <div class="clear"></div>

        <div class="articles">
            <h1><i>{{ (Config::get('app.locale') == 'ru') ? Lang::get('ru.all_articles') : 'Articles Manager '}}</i></h1>
            @if(session('status'))
                <div class="alert alert-box center">{{ session('status') }}</div>
            @endif

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Заголовок</th>
                            <th>Текст</th>
                            <th>Изображение</th>
                            <th>Категория</th>
                            <th>Псевдоним</th>
                            <th>Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allArt as $item)
                            <tr>
                                <td class="align-left">{{ $item->id }}</td>
                                <td class="align-left article_edit">{!! link_to('/admin/articles/'.$item->alias.'/edit', $item->name)  !!}</td>
                                <td class="align-left">{!! str_limit($item->text, 200) !!}</td>
                                <td class="align-left">
                                    @if(isset($item->img->mini))
                                        {!! Html::image(asset(config('settings.theme').'/images/articles/'.$item->img->mini), 'alt', ['class'=>'img-responsive']) !!}
                                    @endif
                                </td>
                                <td class="align-left">{{ $item->category->title }}</td>
                                <td class="align-left">{!! $item->alias !!}</td>
                                <td class="align-left">
                                    {!! Form::open(['url'=>'/admin/articles/'.$item->alias, 'method' => 'DELETE' ]) !!}

                                    {!! Form::submit('X', ['class'=>'btn btn-danger']) !!}


                                    {!! Form::close() !!}

                                </td>

                            </tr>
                            @endforeach

                    </tbody>


                </table>
        </div>
        {!! link_to('/admin/articles/create','Добавить новый материал',['class'=>'btn btn-success']) !!}
    </div>

@endif