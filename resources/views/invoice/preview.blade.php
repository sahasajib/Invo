<x-app-layout>
    <x-slot name="header">
    <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invoice') }}
        </h2>
        <a href="{{route('invoice.create')}}" class="border border-green-400 px-3 py-1">{{ __('Back')}}</a>
    </div>    
    </x-slot>

    <div class="py-12 bg-white border-t">
        <div class="container mx-auto">
            @include('invoice.pdf')
        </div>
    </div>
</x-app-layout>