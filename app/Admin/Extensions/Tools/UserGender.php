<?php
/**
 * Create by HappyOnion
 * author: yt
 * UserGender.php
 * Date: 2017/5/12  Time: 上午12:01
 */

namespace App\Admin\Extensions\Tools;

use Jblv\Admin\Admin;
use Jblv\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class UserGender extends AbstractTool
{
    public function script()
    {
        $url = Request::fullUrlWithQuery(['gender' => '_gender_']);

        return <<<EOT

$('input:radio.user-gender').change(function () {

    var url = "$url".replace('_gender_', $(this).val());

    $.pjax({container:'#pjax-container', url: url });

});

EOT;
    }

    public function render()
    {
        Admin::script($this->script());

        $options = [
            'all'   => trans('user.gender.all'),
            'm'     => trans('user.gender.male'),
            'f'     => trans('user.gender.female'),
        ];

        return view('admin.tools.gender', compact('options'));
    }
}