<div class="content group" id="content-page" >
        <div class="hentry group ">
            <div style="margin-top: 70px">
                <h3>Зарегестрированные пользователи</h3>
                    <table class="table table-hover">
                       <thead>
                           <tr>
                                <th>id</th>
                                <th>Имя пользователя</th>
                                <th>Email</th>
                                <th>Логин</th>
                                <th>Роль</th>
                                <th>Действие</th>
                            </tr>
                       </thead>
                        @if($users)
                            <tbody>

                                @foreach($users as $user)
                                    <tr>
                                        <td class="center">{{ $user->id }}</td>
                                        <td class="center">{!! link_to('admin/users/'.$user->id.'/edit', $user->name) !!}</td>
                                        <td class="center">{{ $user->email }}</td>
                                        <td class="center">{{ $user->login }}</td>
                                        <td class="center"> {{ $user->roles->implode('name', ', ')}}
                                        </td>
                                        <td class="center">
                                            {!! Form::open(['url' => 'admin/users/'.$user->id, 'method'=>'post']) !!}
                                            {!! method_field('DELETE') !!}
                                            {!! Form::submit('Удалить', ['class'=>'btn btn-danger']) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @endif
                    </table>
            </div>
            {!! link_to('admin/users/create', 'Добавить пользователя' ,['class' => 'btn btn-add']) !!}
        </div>
    </div>

