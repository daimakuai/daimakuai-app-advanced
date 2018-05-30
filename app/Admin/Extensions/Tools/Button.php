<?php

namespace App\Admin\Extensions\Tools;

use Jblv\Admin\Grid\Tools\AbstractTool;

class Button extends AbstractTool
{
    public function render()
    {
        return '<button type="button" class="btn btn-sm btn-default">Action</button>';
    }
}
