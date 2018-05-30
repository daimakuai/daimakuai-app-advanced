<?php

/**
 * Daimakuai - admin builder based on Laravel.
 * @author happyonion <https://github.com/happyonion>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Jblv\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Jblv\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

Jblv\Admin\Form::forget(['map', 'editor']);

use App\Admin\Extensions\Column\ExpandRow;
use App\Admin\Extensions\Column\OpenMap;
use App\Admin\Extensions\Column\FloatBar;
use App\Admin\Extensions\Column\Qrcode;
use App\Admin\Extensions\Column\UrlWrapper;
use App\Admin\Extensions\Form\WangEditor;
use App\Admin\Extensions\Nav\Links;
use Jblv\Admin\Grid;
use Jblv\Admin\Form;
use Jblv\Admin\Facades\Admin;
use Jblv\Admin\Grid\Column;

Form::forget(['map', 'editor']);

Form::extend('editor', WangEditor::class);

Admin::css('/vendor/prism/prism.css');
Admin::js('/vendor/prism/prism.js');
Admin::js('/vendor/clipboard/dist/clipboard.min.js');

Column::extend('expand', ExpandRow::class);
Column::extend('openMap', OpenMap::class);
Column::extend('floatBar', FloatBar::class);
Column::extend('qrcode', Qrcode::class);
Column::extend('urlWrapper', UrlWrapper::class);
Column::extend('action', Grid\Displayers\Actions::class);

Column::extend('prependIcon', function ($value, $icon) {

    return "<span style='color: #999;'><i class='fa fa-$icon'></i>  $value</span>";

});

Admin::navbar(function (\Jblv\Admin\Widgets\Navbar $navbar) {

    $navbar->left(view('admin.search-bar'));

    $navbar->right(new Links());

});