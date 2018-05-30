<?php

namespace App\Admin\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Payment;
use App\Models\Shop\Address;
use App\Models\Shop\Customer;
use App\Models\Shop\Staff;
use Jblv\Admin\Form;
use Jblv\Admin\Grid;
use Jblv\Admin\Facades\Admin;
use Jblv\Admin\Layout\Content;
use Jblv\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PaymentController extends Controller
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

        return Admin::grid(Payment::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->customer()->value(function ($customer) {
                return "{$customer['first_name']} {$customer['last_name']}";
            });
            $grid->staff()->value(function ($staff) {
                return "{$staff['first_name']} {$staff['last_name']}";
            });

            //$grid->rental_id();
            $grid->amount()->value(function ($amount) {
                return "\$$amount";
            })->badge('green');
            $grid->payment_date();

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
        return Admin::form(Payment::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->select('customer_id')->options(function ($id) {
                $customer = Customer::find($id);

                if ($customer) {
                    return [$customer->id => "$customer->first_name $customer->last_name"];
                }
            })->ajax('/admin/api/shop/customers');

            $form->select('staff_id')->options(function ($id) {
                $staff = Staff::find($id);

                if ($staff) {
                    return [$staff->id => "$staff->first_name $staff->last_name"];
                }
            })->ajax('/admin/api/shop/staffs');

            //$form->number('rental_id');
            $form->currency('amount');
            $form->date('payment_date');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }

    // GET /admin/api/shop/customers?q=XX
    public function customers(Request $request)
    {
        $q = $request->get('q');

        return Customer::where('first_name', 'like', "%$q%")->paginate(null, ['id',DB::raw('concat(first_name, " ", last_name) as text')]);
    }



}
