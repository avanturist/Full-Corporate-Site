@if(Config::get('app.locale') == 'en')
    <h3>...Say Hello! :)</h3>
    <h4>Get in touch with Pink Rio team</h4>
@else
    <h3>...Скажи привет! :)</h3>
    <h4>Будте на связи с нашей командой</h4>

@endif

@if(session('status'))
    <div class="box success-box">
        {{ session('status') }}
    </div>
@endif