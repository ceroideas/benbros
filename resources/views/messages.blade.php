@foreach ($messages as $m)
	<div class="answer {{ $m->from == Auth::id() ? 'right' : 'left' }}">
      <div class="avatar">
        <div class="img inside" style="background-image: url('{{url('uploads/avatars',$m->fromUser->avatar)}}');"></div>
        {{-- <div class="status online"></div> --}}
      </div>
      <div class="name">{{$m->fromUser->name}}</div>
      <div class="text">
        {{$m->message}}
      </div>
      <div class="time">{{$m->created_at->format('d-m-Y H:i')}}</div>
    </div>
@endforeach