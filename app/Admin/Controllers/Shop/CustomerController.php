<?php

namespace App\Admin\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Customer;
use Jblv\Admin\Form;
use Jblv\Admin\Grid;
use Jblv\Admin\Facades\Admin;
use Jblv\Admin\Layout\Content;
use Jblv\Admin\Controllers\ModelForm;


class CustomerController extends Controller
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
        return Admin::grid(Customer::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->column('name');

            $grid->store_id('Store link')->value(function ($store_id) {
                return "<a href='/admin/sakila/stores/$store_id/edit'>store link</a>";
            });

            $grid->email();

            $grid->active()->value(function ($active) {
                return $active ?
                    "<i class='fa fa-check' style='color:green'></i>" :
                    "<i class='fa fa-close' style='color:red'></i>";
            });

            $grid->created_at();
            $grid->updated_at();

            $grid->rows(function ($row) {
                $name = "$row->first_name $row->last_name";
                $row->column('name', $name);
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
        return Admin::form(Customer::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('store_id');
            $form->text('first_name');
            $form->text('last_name');
            $form->email('email');
            $form->text('address_id');
            $form->switch('active');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
