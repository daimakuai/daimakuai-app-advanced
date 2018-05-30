<?php

namespace App\Admin\Extensions\Tools;

use Illuminate\Support\Facades\Request;
use Jblv\Admin\Admin;
use Jblv\Admin\Grid\Tools\AbstractTool;


class Messagekind extends AbstractTool
{
    public function script()
    {
        $url = Request::fullUrlWithQuery(['kind' => '_kind_']);

        return <<<EOT

$('input:radio.message-kind').change(function () {

    var url = "$url".replace('_kind_', $(this).val());

    $.pjax({container:'#pjax-container', url: url });

});

EOT;
    }

    public function render()
    {
        Admin::script($this->script());

        $options = [
            'inbox'   => 'Inbox',
            'outbox'  => 'Outbox',
        ];

        return view('admin.tools.message-kind', compact('options'));
    }
}
