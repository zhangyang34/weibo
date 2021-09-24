<div class="list-group-item">
  <img class="mr-3" src="{{$v->gravatar()}}" alt="{{ $v->name }}" width="40">
  <a href="{{ route('users.show',$v) }}">
    {{ $v->name }}
  </a>
</div>

