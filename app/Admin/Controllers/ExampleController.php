<?php

namespace App\Admin\Controllers;

use Jblv\Admin\Form;
use Jblv\Admin\Grid;
use Jblv\Admin\Facades\Admin;
use Jblv\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Jblv\Admin\Controllers\ModelForm;

class ExampleController extends Controller
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
        return Admin::grid(YourModel::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

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
        return Admin::form(YourModel::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }


    /**
     *  Tab 示例代码
     * @return mixed
     */
    public function tab()
    {
        return Admin::content(function (Content $content) {
            $content->header('选项卡');
            $content->description('Description...');

            $tab = new Tab();

            $form = new Form();

            $form->action('example');

            $form->date('date');
            $form->time('time');
            $form->datetime('datetime');
            $form->divide();
            $form->dateRange('date_start', 'date_end', '日期范围');
            $form->timeRange('time_start', 'time_end', '时间范围');
            $form->dateTimeRange('date_time_start', 'date_time_end', '时间范围');

            $tab->add('Form', $form);

            $box = new Box('第二个容器', '<p>Lorem ipsum dolor sit amet</p><p>consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>');
            $tab->add('Box', $box);

            $headers = ['Id', 'Email', 'Name', 'age', 'Company'];
            $rows = [
                [1, 'labore21@yahoo.com', 'Ms. Clotilde Gibson', 25, 'Goodwin-Watsica'],
                [2, 'omnis.in@hotmail.com', 'Allie Kuhic', 28, 'Murphy, Koepp and Morar'],
                [3, 'quia65@hotmail.com', 'Prof. Drew Heller', 35, 'Kihn LLC'],
                [4, 'xet@yahoo.com', 'William Koss', 20, 'Becker-Raynor'],
                [5, 'ipsa.aut@gmail.com', 'Ms. Antonietta Kozey Jr.', 41, 'MicroBist'],
            ];

            $table = new Table($headers, $rows);
            $tab->add('Table', $table);

            $content->row($tab);
        });
    }

    /**
     * Alerts and Callouts
     *
     * @return mixed
     */
    public function notice()
    {
        return Admin::content(function (Content $content) {
            $content->header('Alerts and Callouts');
            $content->description('Description...');

            $content->row(function (Row $row) {

                $words = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                    Maecenas feugiat consequat diam. Maecenas metus. Vivamus diam purus, cursus a, commodo non,
                    facilisis vitae, nulla. Aenean dictum lacinia tortor. Nunc iaculis, nibh non iaculis aliquam,
                    orci felis euismod neque, sed ornare massa mauris sed velit. Nulla pretium mi et risus.';

                $row->column(6, function (Column $column) use ($words) {
                    $column->append(new Alert($words));
                    $column->append((new Alert($words, '警告'))->style('success')->icon('user'));
                    $column->append((new Alert($words))->style('warning')->icon('book'));
                    $column->append((new Alert($words))->style('info')->icon('info'));
                });

                $row->column(6, function (Column $column) use ($words) {
                    $column->append(new Callout($words));
                    $column->append((new Callout($words))->style('warning'));
                    $column->append((new Callout($words))->style('info'));
                    $column->append((new Callout($words, '警告'))->style('success'));
                });
            });
        });
    }
}
