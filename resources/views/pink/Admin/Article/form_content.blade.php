<div id="content-page" class="content group" >
    <div class="clear"></div>

    <div class="create_new">
        <h1>Форма добавления нового материала</h1>
{{--
       @if($errors->any())
            <div   class="alert-danger" >
                <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif--}}

        {!! Form::open(['url'=>'/admin/articles', 'files'=>true]) !!}

        <div class="form-group col-md-6">
            {!! Form::label('name','Имя Статьи:') !!}
            @if($errors->has('name'))
                <i class="alert-danger">{{ $errors->first('name') }}</i>
            @endif
            {!! Form::text('name',old('name'),['class'=>'form-control']) !!}

        </div>

        <div class="form-group col-md-6">
            {!! Form::label('alias','Псевдоним Статьи:') !!}
            @if(session('error'))
                <i class="alert-danger">{{session('error') }}</i>
            @endif
            {!! Form::text('alias',old('alias'),['class'=>'form-control','placeholder'=>'Не обязательно к заполнению!']) !!}

        </div>

        <div class="form-group col-md-6">
            {!! Form::label('keywords','Ключевые слова:') !!}
            @if($errors->has('keywords'))
                <i class="alert-danger">{{ $errors->first('keywords') }}</i>
            @endif
            {!! Form::text('keywords',old('keywords'),['class'=>'form-control']) !!}

        </div>
        <div class="form-group col-md-6">
            {!! Form::label('meta_desc','Мета описание:') !!}
            @if($errors->has('meta_desc'))
                <i class="alert-danger">{{ $errors->first('meta_desc') }}</i>
            @endif
            {!! Form::text('meta_desc',old('meta_desc'),['class'=>'form-control']) !!}

        </div>
        <div class="form-group col-md-12">
            {!! Form::label('text','Текст:') !!}
            @if($errors->has('text'))
                <i class="alert-danger">{{ $errors->first('text') }}</i>
            @endif
            {!! Form::textarea('text',old('text'), ['id'=>'text']) !!}

        </div>
        <div class="form-group col-md-12">
            {!! Form::label('desc','Описание Статьи:',['class'=>'control-label']) !!}
            @if($errors->has('desc'))
                <i class="alert-danger">{{ $errors->first('desc') }}</i>
            @endif
            {!! Form::textarea('desc',old('desc'), ['id'=>'desc']) !!}

        </div>


         <div class="form-group col-md-6">
                {!! Form::label('Изображение', null, ['class'=>'control-label']) !!}
                {!! Form::file('img', ['class'=>'filestyle', 'data-Text'=>'Выберите изображение', 'data-btnClass'=>'btn-primary', 'data-placeholder'=>'Файла нет!'])  !!}
         </div>
         <div class="form-group col-md-6">
                @if($lists)
                   {!! Form::label('category_id', 'Выбирите Категорию:') !!}
                    {!! Form::select('category_id',$lists, ['class'=>'form-control']) !!}
                @endif
         </div>


        <div class="form-group col-md-12">
                {!! Form::submit('Сохранить статью', ['class'=>'btn btn-success']) !!}
                {!! Form::close() !!}
        </div>

    </div>

</div>