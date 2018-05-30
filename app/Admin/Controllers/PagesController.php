<?php

namespace App\Admin\Controllers;

use App\Models\Pages;
use App\Admin\Extensions\ExcelExporter;
use App\Admin\Extensions\Tools\ReleasePost;
use App\Admin\Extensions\Tools\RestorePost;
use App\Admin\Extensions\Tools\ShowSelected;
use App\Admin\Extensions\Tools\Trashed;
use App\Models\Tag;
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

class PagesController extends Controller
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
        return Admin::grid(Pages::class, function (Grid $grid) {


            $grid->id('ID')->sortable();
            $grid->url()->editable();
            $grid->title()->editable();//$grid->title()->ucfirst()->limit(30);
            $grid->picture()->image();

            $grid->filter(function ($filter) {

                $filter->between('created_at')->datetime();

             });


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
        return Admin::form(Pages::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('url')->help('');
            $form->text('title')->rules('min:3|max:5')->help('');
            $form->textarea('content')->rules('required')->rows(19)->help('');
            $form->image('picture');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }


}
