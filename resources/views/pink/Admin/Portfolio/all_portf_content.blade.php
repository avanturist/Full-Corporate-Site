@if($portfolios)
<div id="content-page" class="content group" >
    <div class="clear"></div>

    <div class="portfolio">
        <h1><i>{{ (Config::get('app.locale') == 'ru') ? Lang::get('ru.all_portfolios') : 'Portfolios Manager'}}</i></h1>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Заголовок</th>
                    <th>Текст</th>
                    <th>Клиент</th>
                    <th>Псевдоним</th>
                    <th>Изображение</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
                @foreach($portfolios as $portfolio)
                    <tr>
                        <td>{{ $portfolio->id }}</td>
                        <td>{{ link_to('admin/portfolios/'.$portfolio->alias.'/edit', $portfolio->title) }}</td>
                        <td>{!! str_limit($portfolio->text,200) !!}</td>
                        <td>{!! $portfolio->customer !!}</td>
                        <td>{{ $portfolio->alias }}</td>
                        <td>{!! Html::image(asset(config('settings.theme').'/images/projects/'.$portfolio->img->mini),'alt',['class'=>'img-responsive']) !!}</td>

                        <td>
                            {!! Form::open(['url'=> 'admin/portfolios/'.$portfolio->alias, 'method'=> 'post']) !!}

                            {!! method_field('DELETE') !!}
                            {!! Form::submit('X', ['class'=>'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        </td>


                    </tr>
                    @endforeach
            </tbody>

        </table>
        {!! link_to('admin/portfolios/create', 'Добавить портфолио' ,['class'=>'btn btn-success']) !!}
    </div>
</div>
    @endif