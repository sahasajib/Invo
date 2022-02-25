@if (Session('success'))
<div class="bg-emerald-200 text-emerald-700 text-center py-2" id="status_message">
    <p>{{ Session('success') }}</p>
</div>
@endif