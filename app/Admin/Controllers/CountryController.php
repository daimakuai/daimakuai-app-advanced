<?php

namespace App\Admin\Controllers;

use App\Models\Articles;

use App\Models\User;
use App\Http\Controllers\Controller;
use Jblv\Admin\Form;
use Jblv\Admin\Grid;
use Jblv\Admin\Facades\Admin;
use Jblv\Admin\Layout\Content;
use Jblv\Admin\Controllers\ModelForm;
use Jblv\Admin\Widgets\Box;
use Jblv\Admin\Widgets\Tab;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Country::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->country()->editable();

            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Articles::class, function (Form $form) {

            $form->display('id', 'ID');

            // load options by ajax
            $form->select('author_id')->options(function ($id) {
                $user = User::find($id);

                if ($user) {
                    return [$user->id => $user->name];
                }
            })->ajax('/admin/api/users');

            $form->text('title')->rules('required');
            $form->textarea('content')->rules('required');
            $form->image('picture');

            $form->switch('recommend');
            $form->switch('hot');
            $form->switch('new');

            $form->number('rate');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }



    /**
     * Load options for select.
     *
     * GET /admin/api/users?q=xxx
     *
     * @param Request $request
     * @return mixed
     */
    public function users(Request $request)
    {
        $q = $request->get('q');

        return User::where('name', 'like', "%$q%")->paginate(null, ['id', 'name as text']);
    }

    /**
     * POST /admin/demo/posts/release
     *
     * @param Request $request
     * @return void
     */
    public function release(Request $request)
    {
        foreach (Post::find($request->get('ids')) as $post) {
            $post->released = $request->get('action');
            $post->save();
        }
    }

    /**
     * POST /admin/demo/posts/restore
     *
     * @param Request $request
     * @return void
     */
    public function restore(Request $request)
    {
        return Post::onlyTrashed()->find($request->get('ids'))->each(function ($post) {
            $post->restore();
        });
    }
}
