<?php
/**
 * Create by HappyOnion
 * author: yt
 * 1.php 下午10:26
 * Date: 2017/5/12  Time: 下午10:26
 */


namespace App\Admin\Controllers;
use App\Models\ChinaArea;


use App\Http\Controllers\Controller;
use Jblv\Admin\Form;
use Jblv\Admin\Grid;
use Illuminate\Http\Request;
use Jblv\Admin\Facades\Admin;
use Jblv\Admin\Layout\Content;
use Illuminate\Support\Facades\DB;


class ChinaAreaController extends Controller
{

    public function nested(Request $request)
    {
        return Admin::content(function (Content $content) use ($request) {

            $content->header('Schema');

            $form = new Form($request->all());
            $form->method('GET');
            $form->action('/admin/china-area/nested');

            // first level
            $form->select('province')->options(

                ChinaArea::province()->pluck('name', 'id')

            )->load('city', '/admin/api/china-area/city');

            // second level
            $form->select('city')->options(function ($id) {

                return ChinaArea::options($id);

            })->load('district', '/admin/api/china-area/district');

            // third level
            $form->select('district')->options(function ($id) {

                return ChinaArea::options($id);

            });

            $content->body(new Box('多级联动', $form));
        });
    }

    // GET /admin/api/china-area/city?q=1
    public function city(Request $request)
    {
        $provinceId = $request->get('q');

        return ChinaArea::city()->where('parent_id', $provinceId)->get(['id', DB::raw('name as text')]);
    }

    // GET /admin/api/china-area/district?q=1
    public function district(Request $request)
    {
        $cityId = $request->get('q');

        return ChinaArea::district()->where('parent_id', $cityId)->get(['id', DB::raw('name as text')]);
    }

}