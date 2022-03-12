@if(!empty($model->id))
    @component('lili::components.card', ['title' => 'Galeria de Imagens'])
        {!! Form::model($model, ['route' => [$model->getBaseRouteName().'.sendImage', $model->id], 'enctype' => 'multipart/form-data']) !!}
        {!! Form::hidden('id', null) !!}
        {!! Form::hidden('_method', 'post') !!}
        <div class="row">
            <div class="col-sm-8">
                <input type="file" accept="image/jpeg, image/png" name="image"/>
            </div>
            <div class="col-sm-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Enviar Imagem</button>
            </div>
        </div>
        {!! Form::close() !!}
        <hr>
        <div class="row">
            @foreach($model->getMedia('images') as $media)
                <div class="col-sm-2">
                    <a href="{{$media->getUrl()}}" target="_blank">
                        <img src="{{$media->getUrl()}}" alt="Image" class="w-100"/>
                    </a>
                    <form method="post"
                          action="{{route($model->getBaseRouteName() . '.destroyImage', ['id' => $media->id])}}">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="DELETE"/>
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            @endforeach
        </div>
    @endcomponent
@endif
