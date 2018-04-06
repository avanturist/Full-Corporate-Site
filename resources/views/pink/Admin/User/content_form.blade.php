<div id="content-page" class="content group" >
    <div class="clear"></div>

    <div class="create_new">
        <h1>{{ isset($user) ? 'Форма редактирования пользователя' : 'Форма добавления нового пользователя' }}</h1>

        {!! Form::open(['url'=>(isset($user->id)) ? 'admin/users/'.$user->id :'admin/users', 'method'=>'post']) !!}
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::label('name', 'Имя пользователя:', ['class'=> 'control-label']) !!}
            {!! Form::text('name', isset($user->name) ? $user->name :old('name'), ['class' => 'form-control']) !!}
            @if($errors->has('name'))
                <i class="alert-danger">{{ $errors->first('name') }}</i>
            @endif
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('email', 'Email пользователя:', ['class'=> 'control-label']) !!}
            {!! Form::email('email', isset($user->email) ? $user->email :old('email'), ['class' => 'form-control']) !!}
            @if($errors->has('email'))
                <i class="alert-danger">{{ $errors->first('email') }}</i>
            @endif
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('password', 'Пароль пользователя:', ['class'=> 'control-label']) !!}
            {!! Form::password('password',  ['class' => 'form-control', 'placeholder'=>isset($user) ? 'Введите пароль!' : '']) !!}
            @if($errors->has('password'))
                <i class="alert-danger">{{ $errors->first('password') }}</i>
            @endif
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('password_confirmation', 'Повтор пароля:', ['class'=> 'control-label']) !!}
            {!! Form::password('password_confirmation',  ['class' => 'form-control']) !!}
            @if($errors->has('password_confirmation'))
                <i class="alert-danger">{{ $errors->first('password_confirmation') }}</i>
            @endif
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('login', 'Логин пользователя:', ['class'=> 'control-label']) !!}
            {!! Form::text('login', isset($user->login) ? $user->login :old('login'), ['class' => 'form-control']) !!}
            @if($errors->has('login'))
                <i class="alert-danger">{{ $errors->first('login') }}</i>
            @endif
        </div>

        @if($roles && is_array($roles))
            <div class="form-group col-md-6">
                {!! Form::label('role_id', 'Роль пользователя:', ['class'=> 'control-label']) !!}
                {!! Form::select('role_id', $roles, isset($user) ? $user->roles()->first()->id : '', ['class' => 'form-control']) !!}
                @if($errors->has('role_id'))
                    <i class="alert-danger">{{ $errors->first('role_id') }}</i>
                @endif
            </div>
        @endif
    <!-- for EDIT -->
        @if(isset($user))
            {{ method_field('PUT') }}
        @endif
    <!------------------>
        <div class="form-group col-md-12">
            {!! Form::submit('Сохранить', ['class' => 'btn btn-save']) !!}
        </div>
    </div>
        {!! Form::close() !!}

    </div>
</div>
