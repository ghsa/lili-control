@component('lili::components.title', [
    'link' => route($model->getBaseRouteName() . '.create'),
    'linkText' => 'New',
    'icon' => 'fas fa-plus'
])
    {{$model->getPageTitle()}}
@endcomponent

@component('lili::components.card', ['title' => 'List'])
    <table class="table table-dashed table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $result)
            <tr>
                <td>
                    {{$result->name}}
                </td>
                <td>
                    {{$result->email}}
                </td>
                <td>
                    <a href="{{route($result->getBaseRouteName() . '.show', ['id' => $result->id])}}"
                        class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endcomponent
