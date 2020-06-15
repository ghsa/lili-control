@component('lili::components.title')
    {{$model->getPageTitle()}}
@endcomponent

<form action="{{route($model->getBaseRouteName().'.store')}}" method="post" enctype="multipart/form-data" >
    {!! csrf_field() !!}
    @include($model->getBaseRouteName() . '.form')
    <div class="col-sm-12">
        <button type="submit" class="btn btn-primary"> <i class="fas fa-save"></i> Save</button>
    </div>
</form>
