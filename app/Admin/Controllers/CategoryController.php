<?php

namespace App\Admin\Controllers;

use App\Models\Category;

use App\Http\Controllers\Controller;
use Jblv\Admin\Form;
use Jblv\Admin\Grid;
use Jblv\Admin\Facades\Admin;
use Jblv\Admin\Layout\Content;
use Jblv\Admin\Controllers\ModelForm;
use Jblv\Admin\Tree;


class CategoryController extends Controller
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
            $content->header(trans('admin.category'));
            $content->description(trans('admin.list'));

            $content->body($this->tree());
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
            $content->header(trans('admin.edit'));
            $content->description(trans('admin.category'));

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
            $content->header('admin.create');
            $content->description(trans('admin.category'));
            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function tree()
    {
        return Category::tree(function (Tree $tree) {

            $tree->branch(function ($branch) {

                $src = config('admin.upload.host') . '/' . $branch['logo'] ;

                $logo = "<img src='$src' style='max-width:30px;max-height:30px' class='img'/>";

                return "{$branch['id']} - {$branch['title']} $logo";

            });

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Category::form(function (Form $form) {

            $form->display('id', 'ID');

            $form->select('parent_id')->options(Category::selectOptions());

            $form->text('title')->rules('required');
            $form->textarea('describe')->rules('required');
            $form->image('logo');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }



}
