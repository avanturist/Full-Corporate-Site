@foreach($items as $item)

        <tr>
            <td style="{{ $paddingLeft == 1 ? 'text-align:rigth; background:lightblue;' : 'text-align:left' }} ">{{ link_to('admin/menus/'.$item->id.'/edit', $item->title, ['class'=>'admin_menus_link']) }}</td>
            <td>{{ $item->url()}}</td>
            <td>
                {!! Form::open(['url' => 'admin/menus/'.$item->id, 'method'=>'post']) !!}
                {!! method_field('DELETE') !!}

                {!! Form::submit('Удалить', ['class'=>'btn btn-danger']) !!}
                {!! Form::close() !!}
            </td>
        </tr>
        @if($item->hasChildren())
            <ul class="sub-menu">
                @include(config('settings.theme'). '.Admin.Menu.customMenuItems', ['items'=>$item->children()], ['paddingLeft' => 1])
            </ul>

        @endif




@endforeach
