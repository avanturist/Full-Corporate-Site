@extends(config('settings.theme').'.layouts.admin')

@section('content')

    <div id="content-page" class="content group">
        <div class="hentry group">

            <form id="contact-form-contact-us" class="form-group" method="post" action="{{ url('/login') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                        <div class="col-md-12" style="width: 300px;  margin:0 30% ">


                            <label for="login-contact-us">
                                <span class="label">login</span>
                                <br /><span class="sublabel">{{ \Config::get('app.locale') == 'en' ? 'Enter login':\Config::get('settings.enter_to_admin')['login']  }}</span>
                            </label>
                            <div></span><input type="text" name="login" id="login-contact-us"  value="{{ old('login') }}" class="form-control" ></div>
                            <div class="msg-error">
                                @if($errors->has('login'))
                                    <p class="alert-danger">{{ $errors->first('login') }}</p>
                                @endif
                            </div>



                            <label for="password-contact-us">
                                <span class="label">password</span>
                                <br /><span class="sublabel">{{ \Config::get('app.locale') == 'en' ? 'Enter password':\Config::get('settings.enter_to_admin')['password']  }}</span>
                            </label>
                            <div></span><input type="password" name="password"   value="{{ old('password') }}" class="form-control"/></div>
                            <div class="msg-error">
                                @if($errors->has('password'))
                                    <p class="alert-danger">{{ $errors->first('password') }}</p>
                                @endif
                            </div>
                            <div style="float: right">
                                <a href="{{ route('registr') }}">Регистрация</a>
                            </div>
                            <div style="margin-top: 10px">
                                <input type="submit" value="{{ \Config::get('app.locale') == 'en' ? 'LogIn':'Войти'  }}" class="btn btn-success" />
                            </div>

                        </div>

                </div>

            </form>

        </div>

    </div>

    @endsection