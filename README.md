# LiliControl

A simple lib to help developers using Laravel to create dashboards very quickly.

### LiliModel

```php
...
use LiliControl\LiliModel;

class Post extends LiliModel 
{
  
  protected $fillable = ['category_id', 'title', 'description', 'image'];
  
  public function getValidationFields()
  {
    return [
      'title' => 'required',
      'description' => 'required',
      'image' => 'mimes:png|max:200'
    ];
  }
  
  public function getImageProperties()
  {
    return [
      'image' => [
        'width' => 200,
        'height' => 200,
        'quality' => 80
      ]
    ];
  }
  
  public function applyQueryBuilder($builder)
  {
    	$builder->select('categories.*')
        	->join('categories', 'categories.id', '=', 'posts.category_id');
    	return $builder;
  }
  
}
```



### LiliController

```php
...
use App\Post;
use LiliControl\LiliController;

class UserController extends LiliController
{
    public function __construct(Post $model) 
    {
      $this->model = $model;
      // Authorization rule using AuthorizesRequests::authorize
      $this->permission = 'post'; 
    }
  
  ...

```

#### Routes

```php
...
Route::group(['prefix' => 'post', 'as' => 'post.'], function () {
  Route::get('/', 'PostController@index')->name('index');
  Route::get('/show/{id}', 'PostController@show')->name('show');
  Route::post('/', 'PostController@index')->name('search');
  Route::put('/{id}', 'PostController@update')->name('update');
  Route::get('/create', 'PostController@create')->name('create');
  Route::post('/store', 'PostController@store')->name('store');
  Route::delete('/destroy/{id}', 'PostController@destroy')->name('destroy');
});
```



### Components

#### Title

```php
@component('lili::components.title', [
  'link' => route($model->getBaseRouteName() . '.index'),
  'linkText' => 'Back',
  'icon' => 'fas fa-arrow-left'
])
	Page Title
@endcomponent
```



#### Card

```php
@component('lili::components.card', ['title' => 'Card Title'])
	...content...
@endcomponent
```



#### Modal

```php
@component('lili::components.modal', ['title' => 'Modal Title', 'id' => 'id-modal'])
  <div class="modal-body">
    ... Modal Body ...
  </div>
  <div class="modal-footer">
    ... Modal Footer ...
  </div>
@endcomponent
```



### LiliFilterHandler

....



### LiliOrderFilterHandler

....
