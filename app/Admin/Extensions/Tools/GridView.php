<?php

namespace App\Admin\Extensions\Tools;

use Illuminate\Support\Facades\Request;
use Jblv\Admin\Admin;
use Jblv\Admin\Grid\Tools\AbstractTool;


class GridView extends AbstractTool
{
    public function script()
    {
        $url = Request::fullUrlWithQuery(['view' => '_view_']);

        return <<<EOT

$('input:radio.grid-view').change(function () {

    var url = "$url".replace('_view_', $(this).val());

    $.pjax({container:'#pjax-container', url: url });

});

EOT;
    }

    public function render()
    {
        Admin::script($this->script());

        $options = [
            'card' => 'image',
            'table' => 'list',
        ];

        return view('admin.tools.grid-view', compact('options'));
    }
}
