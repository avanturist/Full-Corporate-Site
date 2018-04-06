@if($article_edit)
<div id="content-page" class="content group" >
    <div class="clear"></div>

    <div class="create_new">
        <h1>Форма редактирования материала </h1>
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

        {!! Form::open(['url'=>'/admin/articles/'.$article_edit->alias, 'files'=>true]) !!}
        {!! Form::hidden('_method', 'PUT') !!}
        {!! Form::token() !!}

        <div class="form-group col-md-6">
            {!! Form::label('name','Имя Статьи:') !!}
            @if($errors->has('name'))
                <i class="alert-danger">{{ $errors->first('name') }}</i>
            @endif
            {!! Form::text('name',$article_edit->name,['class'=>'form-control']) !!}

        </div>

        <div class="form-group col-md-6">
            {!! Form::label('alias','Псевдоним Статьи:') !!}
            @if($errors->has('alias') )
                <i class="alert-danger">{{ $errors->first('alias') }}</i>
            @endif
            @if($errors->has('error') )
                <i class="alert-danger">{{ $errors->first('error') }}</i>
            @endif
            {!! Form::text('alias',$article_edit->alias,['class'=>'form-control','placeholder'=>'Не обязательно к заполнению!']) !!}

        </div>

        <div class="form-group col-md-6">
            {!! Form::label('keywords','Ключевые слова:') !!}
            @if($errors->has('keywords'))
                <i class="alert-danger">{{ $errors->first('keywords') }}</i>
            @endif
            {!! Form::text('keywords',$article_edit->keywords,['class'=>'form-control']) !!}

        </div>
        <div class="form-group col-md-6">
            {!! Form::label('meta_desc','Мета описание:') !!}
            @if($errors->has('meta_desc'))
                <i class="alert-danger">{{ $errors->first('meta_desc') }}</i>
            @endif
            {!! Form::text('meta_desc',$article_edit->meta_desc,['class'=>'form-control']) !!}

        </div>
        <div class="form-group col-md-12">
            {!! Form::label('text','Текст:') !!}
            @if($errors->has('text'))
                <i class="alert-danger">{{ $errors->first('text') }}</i>
            @endif
            {!! Form::textarea('text',$article_edit->text, ['id'=>'text']) !!}

        </div>
        <div class="form-group col-md-12">
            {!! Form::label('desc','Описание Статьи:',['class'=>'control-label']) !!}
            @if($errors->has('desc'))
                <i class="alert-danger">{{ $errors->first('desc') }}</i>
            @endif
            {!! Form::textarea('desc',$article_edit->desc, ['id'=>'desc']) !!}

        </div>

        <div class="form-group col-md-6">
            {!! Form::label('old_img', 'Старое изображение:') !!}
            {!! Html::image(config('settings.theme').'/images/articles/'.$article_edit->img->path, $article_edit->img->mini, ['class'=>'img-responsive', 'width'=>'50%']) !!}
            {!! Form::hidden('old_img',$article_edit->img->mini) !!}
        </div>


        <div class="form-group col-md-6">
            {!! Form::label('Изображение', null, ['class'=>'control-label']) !!}
            {!! Form::file('img', ['class'=>'filestyle', 'data-Text'=>'Выберите изображение', 'data-btnClass'=>'btn-primary', 'data-placeholder'=>$article_edit->img->mini])  !!}

        </div>

        <div class="form-group col-md-6">
            @if($cat_list)
                {!! Form::label('category_id', 'Выбирите Категорию:') !!}
                {!! Form::select('category_id', $cat_list, isset($article_edit->category_id) ? $article_edit->category_id : '' ,['class'=>'form-control']) !!}
            @endif
        </div>


        <div class="form-group col-md-12">
            {!! Form::submit('Сохранить статью', ['class'=>'btn btn-success']) !!}
            {!! Form::close() !!}
        </div>

    </div>

</div>
    @endif