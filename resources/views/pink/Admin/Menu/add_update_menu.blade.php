<div class="content group" id="content-page" >
    <div class="hentry group ">
        <h3>{{ isset($menu) ? 'Редактировать пункт меню' : 'Добавить пункт меню' }}</h3>

            {!! Form::open(['url' => isset($menu->id) ? 'admin/menus/'.$menu->id : 'admin/menus', 'method'=>'post']) !!}

                @if(isset($menu))
                    {!! method_field('PUT') !!}
                @endif
                <div class="row">
                    <div class="form-group col-md-6">
                        {!! Form::label('title','Заголовок Меню:', ['class' => 'control-label']) !!}
                        @if($errors->has('title'))
                            <i class="alert-danger">{{ $errors->first('title') }}</i>
                         @endif
                        {!! Form::text('title', isset($menu->title) ? $menu->title : old('title'),['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group col-md-6">
                        {!! Form::label('parent','Родительский пункт меню:', ['class' => 'control-label']) !!}
                        @if($errors->has('parent'))
                            <i class="alert-danger">{{ $errors->first('parent') }}</i>
                        @endif

                        {!! Form::select('parent',$select, isset($menu) ? $menu->id: '' ) !!}
                    </div>
                </div>

                <div style="clear: both"></div>

                <div id="accordion" class="accordion">
                   <h3>

                        {!! Form::label('custom_link','Пользовательская Ссылка:', ['class' => 'control-label']) !!}
                   </h3>

                        <div class="form-group ">
                            {!! Form::radio('type', 'customLink' ,((isset($type) && $type == 'customLink') ? TRUE : FALSE), ['id'=>'custom_link()']) !!}
                            {!! Form::text('custom_link', isset($menu->path) ? $menu->path : old('custom_link'), ['class'=>'form-control', 'placeholder'=>'Путь для ссылки']) !!}
                        </div>

                    <h3>

                        {!! Form::label('linkblog', 'Раздел Блог') !!}
                    </h3>
                    <div class="row">
                        <div class="form-group col-md-6">
                            {!! Form::radio('type', 'link_blog', (isset($type) && $type == 'link_blog') ? TRUE : FALSE) !!}
                            @if($list)
                                {!! Form::select('linkblog', $list, isset($menu->id) ? $list->alias : '') !!}
                            @endif

                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('linkarticle', 'Ссылка на материал Блога') !!}
                            {!! Form::select('linkarticle', $link_article) !!}
                        </div>
                    </div>
                    <h3>

                        {!! Form::label('linkportfolio', 'Раздел Портфолио') !!}
                    </h3>
                    <div class="row">
                        <div class="form-group col-md-6">
                            {!! Form::radio('type', 'link_portfolio', (isset($type) && $type == 'link_portfolio') ? TRUE : FALSE) !!}
                            {!! Form::select('linkportfolio', $link_portf) !!}
                        </div>

                        <div class="form-group col-md-6">
                            {!! Form::label('linkfilter', 'Ссылка на материал портфолио') !!}
                            {!! Form::select('linkfilter', $link_filter) !!}

                        </div>
                    </div>


                </div>


            <div class="form-group col-md-12">
                {!! Form::submit('Сохранить',['class'=>'btn btn-add']) !!}
            </div>

            {!! Form::close() !!}

    </div>
</div>
