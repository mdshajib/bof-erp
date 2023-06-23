@once

@push('header')
<link rel="stylesheet" href="{{ asset('assets/notify/css/simple-notify.min.css') }}">
@endpush

@push('footer')
<script src="{{ asset('assets/notify/js/simple-notify.min.js') }}"></script>
<script>
    window.addEventListener('notify', function(event) {
        new Notify({
            status: event.detail.type,
            title: event.detail.title,
            text: event.detail.message,
            effect:'slide',
            showIcon: true,
            position:'right top',
            autoclose: true,
            autotimeout: 3000
        });
    });
</script>
@endpush
@endonce
