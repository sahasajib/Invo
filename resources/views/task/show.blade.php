<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('View Tasks') }}
            </h2>
            <a href="{{route('task.index')}}" class="border border-green-400 px-3 py-1">{{ __('Back')}}</a>
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="">
                        <h1>Task:{{$task-> name}}</h1>
                        <h1>Price:${{$task-> price}}</h1>
                        <h1>Client:{{$task-> client->name }}</h1>
                        <div class="flex justify-between items-center">
                            <div class="capitalize bg-blue-300 px-3 py-2 rounded-md inline-block">
                                <p>{{$task->status}}</p>
                            </div>
                            @if ($task->status == 'pending')
                            <div class="">
                                <form action="{{route('markAsComplete',$task)}}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="capitalize bg-blue-300 px-3 py-2 rounded-md inline-block">Mark as Complete</button>
                                </form>
                            </div>
                            @endif
                        </div>
                        <h1 class="my-3 font-bold">Task Details</h1>
                        <div class="border my-4 p-5 prose max-w-none">
                            {!! $task->description !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
