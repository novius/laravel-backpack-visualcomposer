<div class="row-template vc-minimal">
    <input type="hidden" value="{}">
</div>

@push('crud_fields_scripts')
    <script>
        window['vc_boot', {!!json_encode($template)!!}] = Function();
    </script>
@endpush
