<div class="vc-two-wysiwygs row col-xs-12">
    <div class="col-xs-6">
        {!! json_decode($content)[0] !!}
    </div>
    <div class="col-xs-6">
        {!! json_decode($content)[1] !!}
    </div>
</div>

<style>
.vc-two-wysiwygs {
	background: white;
	box-shadow: 0 2px 18px #00000040;
	padding: 25px;
	margin-bottom: 30px;
}

.vc-two-wysiwygs > div:first-child {
	border-right: solid 1px lightgray;
}
</style>
