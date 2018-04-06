<div id="content-page" class="content group" >
    <div class="clear"></div>

    <div class="create_new">
        <h1>{{ isset($portfolio) ? 'Форма редактирования Портфолио' : 'Форма добавления нового Портфолио' }}</h1>

        {!! Form::open(['url'=> isset($portfolio) ? 'admin/portfolios/'.$portfolio->alias : 'admin/portfolios', 'method'=>'POST', 'files'=>true ]) !!}
        @if(isset($portfolio))
            {{ method_field("PUT") }}
        @endif

        <div class="form-group col-md-6">
            {!! Form::label('title', 'Заголовок портфолио:', ['class'=>'control-label']) !!}
            {!! Form::text('title', isset($portfolio) ? $portfolio->title : old('title'), ['class'=>'form-control'] ) !!}
            @if($errors->has('title'))
                <i>{{ $errors->first('title') }}</i>
            @endif
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('customer', 'Имя клиента:', ['class'=>'control-label']) !!}
            {!! Form::text('customer', isset($portfolio) ? $portfolio->customer : old('customer'), ['class'=>'form-control'] ) !!}
            @if($errors->has('customer'))
                <i>{{ $errors->first('customer') }}</i>
            @endif
        </div>

        <div class="form-group col-md-6">

            {!! Form::label('alias', 'Псевдоним:', ['class'=>'control-label']) !!}
            @if(session('error'))
                <i style="color: red">{{ session('error') }}</i>
            @endif
            {!! Form::text('alias', isset($portfolio) ? $portfolio->alias : old('alias'), ['class'=>'form-control', 'placeholder'=>'Заполнять не обязательно'] ) !!}
            @if($errors->has('alias'))
                <i>{{ $errors->first('alias') }}</i>
            @endif

        </div>

        <div class="form-group col-md-6">
            {!! Form::label('filter_id', 'Выберите фильтр:', ['class'=>'control-label']) !!}
            {!! Form::select('filter_id', $select, isset($portfolio) ? $portfolio->filter_id : '', ['class'=>'form-control']) !!}
        </div>


        <div class="form-group col-md-12">
            {!! Form::label('text', 'Текст:', ['class'=>'control-label']) !!}
            {!! Form::textarea('text', isset($portfolio) ? $portfolio->text : old('text'), ['class'=>'form-control'] ) !!}
            @if($errors->has('text'))
                <i>{{ $errors->first('text') }}</i>
            @endif
        </div>

        <div class="form-group col-md-6">
            @if(isset($portfolio))
                {!! Form::label('old_img','Старое изображение:') !!}
                {!! Html::image(config('settings.theme').'/images/projects/'.$portfolio->img->path , $portfolio->img->path, ['class' => 'img-responsive', 'width'=>'50%' ]) !!}
                {!! Form::hidden('old_img', $portfolio->img->path) !!}
             @endif

        </div>

        <div class="form-group col-md-12">
            {!! Form::label('img', 'Выберите изображение:', ['class'=>'control-label']) !!}
            {!! Form::file('img', ['class'=>'filestyle', 'data-text'=>'Выберите изображение', 'data-btnClasss'=>'btn-primary', 'data-placeholder'=>isset($portfolio) ? $portfolio->img->path : 'Файла нет!'] ) !!}

        </div>





        <div class="form-group col-md-12">
            {!! Form::submit('Сохранить', ['class' => 'btn btn-default']) !!}
        </div>
        {!! Form::close() !!}

    </div>
</div>


