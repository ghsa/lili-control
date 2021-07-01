<?php

namespace LiliControl;

use App\Http\Controllers\Controller;
use LiliControl\Traits\UploadFileTrait;
use Illuminate\Database\Eloquent\Model;

class LiliController extends Controller
{

    use UploadFileTrait;

    public $model;
    public $permission = null;
    public $paginate = 10;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $this->permission ? $this->authorize($this->permission, $this->model) : null;
        $query = $this->model->query();
        $query = $this->model->applyQueryBuilder($query);
        $filters = $this->setFilters($query);
        $query = $this->setOrder($query);
        $results = $query->paginate($this->paginate);

        $model = $this->model;
        return view(
            $model->getBaseRouteName() . '.index',
            compact('model', 'filters', 'results')
        );
    }

    public function csv()
    {
        $this->permission ? $this->authorize($this->permission, $this->model) : null;
        $query = $this->model->query();
        $query->select($this->model->selectCSVFields());
        $query = $this->model->applyQueryBuilder($query);
        $this->setFilters($query);
        $query = $this->setOrder($query);
        $results = $query->get()->toArray();
        $csvContent = '';
        foreach ($results as $result) {
            foreach ($this->model->selectCSVComputedFields() as $key => $computedField) {
                if (array_key_exists($key, $result)) {
                    $result[$key] = $computedField($result[$key]);
                }
            }
            $csvContent .= implode(";", $result) . "\n";
        }

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=export_file.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $csvContent;
    }

    protected function setFilters(&$query)
    {
        $filters = new LiliFilterHandler($this->model);
        $query = $filters->applyFilters($query);
        return $filters;
    }

    protected function setOrder($query)
    {
        $order = new LiliOrderFilterHandler($this->model);
        $query = $order->applyOrder($query);
        return $query;
    }

    public function create()
    {
        $model = $this->model;
        return view($this->model->getBaseRouteName() . '.create', compact('model'));
    }

    public function store()
    {
        request()->validate($this->model->getValidationFields());

        $this->saveModelFromRequest();

        return redirect()
            ->route($this->model->getBaseRouteName() . ".show", ['id' => $this->model->id])
            ->with(['success' => "Criado com sucesso!"]);
    }

    public function update($id)
    {
        $this->model = $this->model->find($id);

        request()->validate($this->model->getValidationFields());

        $this->saveModelFromRequest();

        return redirect()
            ->route($this->model->getBaseRouteName() . ".show", ['id' => $this->model->id])
            ->with(['success' => "Atualizado com sucesso!"]);
    }

    /**
     * Handle data that shoud be saved on model
     */
    protected function saveModelFromRequest()
    {
        $this->model->fill(request()->only($this->model->getFillableFields()));
        $this->handleFilesToUpload();
        $this->model->save();
    }

    public function show($id)
    {
        $model = $this->model->find($id);
        return view($this->model->getBaseRouteName() . '.show', compact('model'));
    }

    public function destroy($id)
    {
        $content = $this->model->find($id);
        $content->delete();
        return redirect(route($this->model->getBaseRouteName() . '.index'))
            ->with(['success' => "Deletado com sucesso!"]);
    }
}
