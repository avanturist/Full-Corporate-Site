<div class="content group" id="content-page" >
    <div class="hentry group ">
        <div style="margin-top: 70px">
            <h3>Менеджер Привилегий</h3>

            <form action="/admin/permissions" method="post">
                {{ csrf_field() }}

                <table class="table table-bordered table-hover ">
                    <thead>
                        <tr>
                            <th>Привилегии</th>
                            @if(!$roles->isEmpty())
                                @foreach($roles as $role)
                                    <th style="background: #cccccc">{{ $role->name }}</th>
                                @endforeach
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if(!$permiss->isEmpty())

                                @foreach($permiss as $perm)
                                    <tr>
                                        <td>{{ $perm->name }}</td>
                                             @foreach($roles as $role)
                                                 @for($i=0; $i<count($role); $i++)

                                                    <td class="my_checkbox" style="text-align: right;">
                                                        <!-- В моделі Role опишимо метод який перевіряє наявність дозволів в конкретної ролі -->
                                                        @if($role->hasPermission($perm))
                                                            <label><input checked type="checkbox" name="{{ $role->id }}[]" value="{{ $perm->id }}"></label>
                                                        @else
                                                            <label><input  type="checkbox" name="{{ $role->id }}[]" value="{{ $perm->id }}"></label>
                                                        @endif

                                                    </td>
                                                 @endfor

                                            @endforeach

                                    </tr>

                                 @endforeach

                            @endif
                        <tr>
                            <td>

                                    @if($role->getUserRole())
                                        <input type="submit" value="Обновить" class="btn btn-success">
                                    @else
                                    <input type="submit" value="Обновить" class="btn btn-success" disabled>
                                    @endif

                            </td>
                        </tr>
                    </tbody>
                </table>

            </form>

        </div>
    </div>
</div>