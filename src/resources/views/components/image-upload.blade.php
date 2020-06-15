<div class="form-group">
    {!! Form::label($field, !empty($label) ? $label :"Image") !!}
    {!! Form::file($field, null, ['class' => 'form-control']) !!}
    @php
    $properties = $content->getImageProperties()[$field] ?? [];
    $validation = !empty($content->getValidationFields()[$field]) ? explode("|",
    $content->getValidationFields()[$field]) : [];
    @endphp
    <div class="d-flex">
        @if(!empty($properties['width']) && !empty($properties['height']))
        <div class="alert alert-info mt-2 mr-2">
            {{$properties['width']}}px x {{$properties['height']}}px
        </div>
        @endif
        @foreach($validation as $validationField)
        @php
        try {
        list($vField, $value) = explode(":", $validationField);
        }catch(\Exception $e) {
        continue;
        }
        @endphp
        <div class="alert alert-info mt-2 mr-2">
            {{$value}}{{$vField == 'max' ? 'kb' : ''}}
        </div>
        @endforeach
    </div>

    <div class="mt-2">
        @if(!empty($content->$field))
        <img src="{{$content->getFilePath($field)}}" class="w-100 rounded" alt="Image {{$field}}" />
        @endif
    </div>
</div>
