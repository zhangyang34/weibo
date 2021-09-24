<div class="list-group-item">
  <img class="mr-3" src="{{$v->gravatar()}}" alt="{{ $v->name }}" width="40">
  <a href="{{ route('users.show',$v) }}">
    {{ $v->name }}
  </a>
  @can('destroy',$v)
    <form action="{{ route('users.destroy',$v->id) }}" method="post" class="float-right">
      {{--   等同于用户的token 令牌验证   --}}
      {{ csrf_field() }}
      {{ method_field('DELETE') }}
      <button type="submit" class="btn btn-sm btn-danger delete-btn">删除</button>
    </form>
  @endcan
</div>

