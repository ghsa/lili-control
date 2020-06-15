<div class="card shadow mb-4">
    @if(!empty($title))
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold ">{{$title}}</h6>
    </div>
    @endif
    <div class="card-body">
        {{$slot}}
    </div>
</div>
