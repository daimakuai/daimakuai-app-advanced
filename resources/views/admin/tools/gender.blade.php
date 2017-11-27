<?php
/**
 * Create by HappyOnion
 * author: yt
 * gender.blade.php 上午12:03
 * Date: 2017/5/12  Time: 上午12:03
 */
?>
<div class="btn-group" data-toggle="buttons">
@foreach($options as $option => $label)
<label class="btn btn-default btn-sm {{ \Request::get('gender', 'all') == $option ? 'active' : '' }}">
    <input type="radio" class="user-gender" value="{{ $option }}">{{$label}}
</label>
@endforeach
</div>