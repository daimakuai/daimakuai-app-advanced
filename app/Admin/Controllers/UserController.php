<?php

namespace App\Admin\Controllers;


use App\Admin\Extensions\Tools\UserGender;
use App\Http\Controllers\Controller;
use App\Models\ChinaArea;
use App\Models\User;
use Illuminate\Http\Request;
use Jblv\Admin\Form;
use Jblv\Admin\Grid;
use Jblv\Admin\Facades\Admin;
use Jblv\Admin\Layout\Content;
use Jblv\Admin\Layout\Row;
use Jblv\Admin\Controllers\ModelForm;
use Jblv\Admin\Widgets\Table;

;

class UserController extends Controller
{
    use ModelForm;

    protected function index()
    {
        return Admin::content(function (Content $content) {
            $content->header(trans('admin.user'));
            $content->description(trans('admin.list'));
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

            $content->header(trans('admin.user'));
            $content->description(trans('admin.edit'));

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

            $content->header(trans('admin.user'));
            $content->description(trans('admin.new'));

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
        return Admin::grid(User::class, function (Grid $grid) {

            $grid->model()->gender(Request::get('gender'));

            $grid->model()->with('profile')->orderBy('id', 'DESC');

            $grid->paginate(20);

            $grid->id('ID')->sortable();

            $grid->name(trans('admin.name'))->editable();

            $grid->column(trans('admin.expand'))->expand(function () {

                $profile = array_only($this->profile, ['homepage', 'gender', 'birthday', 'address', 'last_login_at', 'last_login_ip', 'lat', 'lng']);

                return new Table([], $profile);

            }, 'Profile');
//
            $grid->column('position', trans('user.profile.position'))->openMap(function () {

                return [$this->profile['lat'], $this->profile['lng']];

            }, 'Position');

            $grid->column('profile.homepage', trans('user.profile.homepage'))->urlWrapper();

            $grid->email(trans('user.profile.email'))->prependIcon('envelope');


            //$grid->profile()->mobile()->prependIcon('phone');

            //$grid->column('profile.age')->progressBar(['success', 'striped'], 'xs')->sortable();

            $grid->profile()->age(trans('user.profile.age'))->sortable();


            //子表不能再这里处理
            //$grid->profile()->gender(trans('user.gender.title'))->radio(['m' => trans('user.gender.female'), 'f'=> trans('user.gender.male')]);

            $grid->created_at(trans('admin.created_at'));

            $grid->updated_at(trans('admin.updated_at'));

            $grid->filter(function (Grid\Filter $filter) {

//                $filter->disableIdFilter();

                $filter->equal('address.province_id', 'Province')
                    ->select(ChinaArea::province()->pluck('name', 'id'))
                    ->load('address.city_id', '/demo/api/china/city');

                $filter->equal('address.city_id', 'City')->select()
                    ->load('address.district_id', '/demo/api/china/district');

                $filter->equal('address.district_id', 'District')->select();
            });

            $grid->tools(function ($tools) {
                $tools->append(new UserGender());
            });

            $grid->actions(function ($actions) {

                if ($actions->getKey() % 2 == 0) {
                    $actions->disableDelete();
                    $actions->append('<a href=""><i class="fa fa-eye"></i></a>');
                } else {
                    $actions->disableEdit();
                    $actions->prepend('<a href=""><i class="fa fa-paper-plane"></i></a>');
                }
            });
        });
    }

    public function form()
    {
        return User::form(function (Form $form) {

            $form->model()->makeVisible('password');

            $form->tab(trans('user.basic.title'), function (Form $form) {

                $form->display('id');

                //$form->input('name')->rules('required');

                $form->text('name', trans('admin.name'))/*->rules('required')*/
                ;
                $form->email('email', trans('user.profile.email'))->rules('required');
                $form->display('created_at', trans('admin.created_at'));
                $form->display('updated_at', trans('admin.updated_at'));

            })->tab(trans('user.profile.title'), function (Form $form) {

                $form->url('profile.homepage', trans('user.profile.homepage'));
                $form->ip('profile.last_login_ip', trans('user.profile.last_login_ip'));
                $form->datetime('profile.last_login_at', trans('user.profile.last_login_at'));
                //$form->radio('gender',trans('user.gender'))->options(['m' => trans('user.gender.female'), 'f'=> trans('user.gender.male')])->default('m');
                $form->color('profile.color', trans('user.profile.color'))->default('#c48c20');
                $form->mobile('profile.mobile', trans('user.profile.mobile'))->default(13524120142);
                $form->date('profile.birthday', trans('user.profile.birthday'));

                //$form->map('profile.lat', 'profile.lng', trans('user.profile.position'))->useTencentMap();
                $form->slider('profile.age', trans('user.profile.age'))->options(['max' => 50, 'min' => 20, 'step' => 1, 'postfix' => 'years old']);
                $form->datetimeRange('profile.created_at', 'profile.updated_at', trans('user.profile.time_line'));

            })->tab(trans('user.sns.title'), function (Form $form) {

                $form->text('sns.qq', trans('user.sns.qq'));
                $form->text('sns.wechat', trans('user.sns.wechat'))->rules('required');
                $form->text('sns.weibo', trans('user.sns.weibo'));
                $form->text('sns.github', trans('user.sns.github'));
                $form->text('sns.google', trans('user.sns.google'));
                $form->text('sns.facebook', trans('user.sns.facebook'));
                $form->text('sns.twitter', trans('user.sns.twitter'));
                $form->display('sns.created_at', trans('user.sns.created_at'));
                $form->display('sns.updated_at', trans('user.sns.updated_at'));

            })->tab(trans('user.address.title'), function (Form $form) {

                $form->select('address.province_id', trans('user.address.province_id'))->options(
                    ChinaArea::province()->pluck('name', 'id')
                )
                    ->load('address.city_id', '/demo/api/china/city')
                    ->load('test', '/demo/api/china/city');

                $form->select('address.city_id', trans('user.address.city_id'))->options(function ($id) {
                    return ChinaArea::options($id);
                })->load('address.district_id', '/demo/api/china/district');

                $form->select('address.district_id', trans('user.address.district_id'))->options(function ($id) {
                    return ChinaArea::options($id);
                });

                $form->text('address.address', trans('user.address.address'));

            })->tab(trans('user.password'), function (Form $form) {

                $form->password('password', trans('user.password'))->rules('confirmed');
                $form->password('password_confirmation', trans('user.password_confirmation'));

            });

            $form->ignore(['password_confirmation']);
        });
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function users(Request $request)
    {
        $q = $request->get('q');

        return User::where('name', 'like', "%$q%")->paginate(null, ['id', 'name as text']);
    }


}

