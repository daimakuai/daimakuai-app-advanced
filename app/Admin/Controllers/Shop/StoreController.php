<?php

namespace App\Admin\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Address;
use App\Models\Shop\Store;
use App\Models\Shop\Staff;
use Jblv\Admin\Form;
use Jblv\Admin\Grid;
use Jblv\Admin\Facades\Admin;
use Jblv\Admin\Layout\Content;
use Jblv\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class StoreController extends Controller
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
        return Admin::grid(Address::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->address()->editable('textarea');
            $grid->district()->editable('textarea');
            $grid->postal_code()->editable();
            $grid->phone()->editable();

            $grid->city()->city();

            $grid->created_at();
            $grid->updated_at();

            $grid->filter(function ($filter) {
                $filter->like('address');
                $filter->like('city.city', 'City');
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
        return Admin::form(Store::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->select('address_id')->options(function ($id) {
                $address = Address::find($id);

                if ($address) {
                    return [$address->id => $address->address];
                }
            })->ajax('/admin/api/shop/address');

            $form->select('manager_staff_id')->options(function ($id) {
                $staff = Staff::find($id);

                if ($staff) {
                    return [$staff->id => "$staff->first_name $staff->last_name"];
                }
            })->ajax('/admin/api/shop/staffs');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }


    // GET /admin/api/shop/staffs?q=XX
    public function staffs(Request $request)
    {
        $q = $request->get('q');

        return Staff::where('first_name', 'like', "%$q%")->paginate(null, ['id',DB::raw('concat(first_name, " ", last_name) as text')]);
    }

    // GET /admin/api/shop/address?q=XX
    public function address(Request $request)
    {
        $q = $request->get('q');

        return Address::where('address', 'like', "%$q%")->paginate(null, ['id',DB::raw('address as text')]);
    }
}
