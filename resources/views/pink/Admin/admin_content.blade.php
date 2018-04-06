<div class="inner group admin_content">
    <h1>Приветствуем Вас в Панели Администратора</h1>
    @if(session('status'))
        <div class = 'alert alert-info'>{{ session('status') }}</div>
    @endif
    <div class="img_content_admin">
    <img src="{{ asset(config('settings.theme')).'/images/admin/admin_logo.png' }}" alt="" class="img-responsive">
    </div>
</div>