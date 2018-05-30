<?php

namespace App\Admin\Controllers;

use App\Models\Articles;
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

class ArticlesController extends Controller
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

            $content->header('文章管理');
            $content->description('列表');

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

            $content->header('文章管理');
            $content->description('新增');

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
        return Admin::grid(Articles::class, function (Grid $grid) {


            if (request('trashed') == 1) {
                $grid->model()->onlyTrashed();
            }

            $grid->model()->ordered();

            $grid->id('ID')->sortable();

            $grid->title()->editable();//$grid->title()->ucfirst()->limit(30);
            $grid->content()->editable();
            $grid->picture()->image();

            $states = [
                'on' => ['text' => 'YES'],
                'off' => ['text' => 'NO'],
            ];


            $grid->column('switch_group')->switchGroup([
                'recommend' => '推荐', 'hot' => '热门', 'new' => '最新'
            ], $states);

            $grid->tags()->pluck('name')->label();

            $grid->rate()->display(function ($rate) {
                $html = "<i class='fa fa-star' style='color:#ff8913'></i>";

                return join('&nbsp;', array_fill(0, min(5, $rate), $html));
            });

            $grid->filter(function ($filter) {

                $filter->between('created_at')->datetime();

                $filter->where(function ($query) {

                    $input = $this->input;

                    $query->whereHas('tags', function ($query) use ($input) {
                        $query->where('name', $input);
                    });


                },  'Has tag', 'tag');
            });


            $grid->tools(function ($tools) {

                $tools->append(new Trashed());

                $tools->batch(function (Grid\Tools\BatchActions $batch) {

                    $batch->add('Restore', new RestorePost());
                    $batch->add('Release', new ReleasePost(1));
                    $batch->add('Unrelease', new ReleasePost(0));
                    $batch->add('Show selected', new ShowSelected());
                });

            });

            $grid->column('float_bar')->floatBar();

            $grid->rows(function (Grid\Row $row) {
                if ($row->id % 2) {
                    $row->setAttributes(['style' => 'background:#ddedf9;']);
                }
            });

            $grid->order()->orderable();

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
            $form->select('作者')->options(function ($id) {
                $user = User::find($id);

                if ($user) {
                    return [$user->id => $user->name];
                }
            })->ajax('/admin/api/users');

            $form->text('标题')->rules('min:3|max:5')->help('这里填写标题');
            $form->textarea('内容')->rules('required')->rows(19)->help('必须填写文章内容');
            $form->image('图片');

            $form->switch('是否推荐');
            $form->switch('是否热门');
            $form->switch('是否最新');

            $form->number('评分');

            $form->multipleSelect('tags')->options(Tag::all()->pluck('name', 'id'));

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
     * POST /admin/articles/release
     *
     * @param Request $request
     * @return void
     */
    public function release(Request $request)
    {
        foreach (Articles::find($request->get('ids')) as $post) {
            $post->released = $request->get('action');
            $post->save();
        }
    }

    /**
     * POST /admin/articles/restore
     *
     * @param Request $request
     * @return void
     */
    public function restore(Request $request)
    {
        return Articles::onlyTrashed()->find($request->get('ids'))->each(function ($post) {
            $post->restore();
        });
    }
}
