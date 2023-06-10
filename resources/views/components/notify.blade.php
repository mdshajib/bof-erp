@once

@push('header')
<link rel="stylesheet" href="{{ asset('assets/notify/css/simple-notify.min.css') }}">
@endpush

@push('footer')
<script src="{{ asset('assets/notify/js/simple-notify.min.js') }}"></script>
<script>
    window.addEventListener('notify', function(event) {
        const title = () => {
            return event.detail.type.charAt(0).toUpperCase()+event.detail.type.substr(1).toLowerCase();
        };
        new Notify({
            status: event.detail.type,
            title: title(),
            text: event.detail.message,
            effect:'slide',
            showIcon: true,
            position:'right top',
            autoclose: true,
            autotimeout: 5000
        });
    });
</script>
@endpush
@endonce