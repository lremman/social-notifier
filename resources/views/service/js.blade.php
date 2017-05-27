<script src="{{ url('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ url('theme/bootstrap.min.js') }}"></script>
{{-- <script src="{{ url('plugins/summernote/summernote.min.js') }}"></script> --}}
<script src="{{ url('plugins/select2/dist/js/select2.full.min.js') }}"></script>
<script>
    window.csrf_token = '{{ csrf_token() }}';
    window.csrf_token_url = '{{ action('ServiceController@getCsrfToken') }}';
</script>
<script src="{{ url('plugins/lodash.js') }}"></script>
<script src="{{ url('js/service.js') }}"></script>