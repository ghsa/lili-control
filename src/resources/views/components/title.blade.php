<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{$slot}}</h1>
    @if(!empty($link))
    <a href="{{$link}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        @if(!empty($icon))
        <i class="{{$icon}} text-white-100 mr-"></i>
        @endif
        {{$linkText}}</a>
    @endif
</div>
