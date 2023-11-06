<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Notification <i class="fas fa-bell" id="notification-icon"></i>({{ auth()->user()->unread_notifications->count() }})
                </div>
                <ul id="notification-list">
                    @foreach(auth()->user()->unread_notifications as $notification)
                    <li class="notification_text" id="notification_{{ $notification->id }}">{{ $notification->text }} <input type="checkbox" class="checkbox_name" name="checkbox_name" value="checkbox_value" data-id="{{ $notification->id }}">Mark read</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>

<script defer>
    

    const checkboxElements = document.querySelectorAll('.checkbox_name');

    for (const checkboxElement of checkboxElements) {
        checkboxElement.addEventListener('click', function() {
            const dataId = this.dataset.id;

            // Create an object to hold the data
            const data = { notification_id: dataId, user_id: {{ auth()->id() }} };

            // Convert the data to JSON
            const jsonData = JSON.stringify(data);

            // Get the CSRF token from the meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const xhr = new XMLHttpRequest();
            xhr.open('POST', "{{ route('admin.notification.read') }}", true);
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

            // Send the POST request with the JSON payload
            xhr.send(jsonData);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log('The notification was successfully marked as read.');
                } else {
                    console.log('An error occurred while marking the notification as read.');
                }
            };
        });
    }


</script>
