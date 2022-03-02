<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tasks') }}
            </h2>
            <a href="{{route('task.create')}}" class="border border-green-400 px-3 py-1">{{__('Add New')}}</a>
        </div>

    </x-slot>

    @if (Session('success'))
    <div class="py-2 bg-emerald-300 text-emerald-700 text-center" id="status_message">
        <p>{{Session('success')}}</p>
    </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             <div class="bg-white rounded-md py-10 mb-6 {{request('client_id') || request('status') || request('fromDate') || request('client_id')
                || request('endDate') || request('price')? '': 'hidden'}}" id="task_filter">
            <h2 class="text-center font-bold mb-6">Filter Task</h2>
            <form action="{{ route('task.index') }}" method="GET">
                        @csrf

                        <div class="flex space-x-3 items-end justify-center">
                            <div class="">
                                @error('client_id')
                                <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                                <label for="client_id" class="formLabel">Select Client</label>
                                <select name="client_id" id="client_id" class="formInput">
                                    <option value="">Select Client</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{$client->id == old('client_id') || $client->id == request('client_id')? 'selected' : ''}}>{{ $client->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="">
                                @error('status')
                                <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                                <label for="status" class="formLabel">Status</label>
                                <select name="status" id="status" class="formInput">
                                    <option value="">Status</option>
                                    <option value="pending" {{ old('status') == 'pending' || request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="complete" {{ old('status') == 'complete' || request('status')=='complete' ? 'selected' : '' }}>Complete</option>
                                </select>
                            </div>
                            <div class="">
                            @error('fromDate')
                                <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                                <label for="fromDate" class="formLabel">Start Date</label>
                                <input type="date" class="formInput" name="fromDate" id="fromDate"
                                    max="{{ now()->format('Y-m-d') }}" value="{{ request('fromDate') }}">

                            </div>
                            <div class="">
                                @error('endDate')
                                <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                                <label for="endDate" class="formLabel">End Date</label>
                                <input type="date" class="formInput" name="endDate" id="endDate"
                                    value="{{ request('endDate') !='' ? request('endDate') : '' }}"
                                    max="{{ now()->format('Y-m-d') }}">

                            </div>
                            <div class="">
                                @error('price')
                                <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                                <label for="price" class="formLabel">Price</label>
                                <input type="number" class="formInput" name="price" id="price" value="{{request('price')}}">

                            </div>
                            <div class="">
                                <button type="submit" class="bg-purple-600 text-white px-3 py-2">Search</button>
                            </div>
                        </div>
                </form>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-right">
                        <button type="button" id="tesk_filter_btn" class="px-3 py-1 bg-blue-400 text-white mb-6
                        ">{{request('client_id') || request('status') || request('fromDate') || request('client_id')
                || request('endDate') || request('price')? 'Close Filter': 'Filter'}}</button>
                    </div>
                    <table class="w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="border py-2">Name</th>
                                <th class="border py-2 w-20">Price</th>
                                <th class="border py-2">Clients</th>
                                <th class="border py-2 w-40">Status</th>
                                <th class="border py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                            <tr>
                                <td class="border py-2 text-left px-2">
                                <a class="font-bold text-base hover:text-purple-700" href="{{route('task.show',$task->slug)}}">{{$task->name}}</a>
                                </td>
                                <td class="border py-2 text-center text-sm">{{$task->price}}</td>
                                <td class="border py-2 text-left px-3">
                                    <a class="text-lime-800 hover:text-purple-700" href="{{route('task.index')}}?client_id=
                                    {{$task->client->id}}">{{$task->client->name}}</a></td>
                                <td class="border py-2 text-center capitalize">
                                    {{$task->status}}

                                    @if($task->status == 'pending')
                                        <form action="{{route('markAsComplete',$task)}}" method="POST"
                                              onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="bg-teal-600 w-full border-2 text-white hover:bg-transparent
                                              hover:text-black transition-all duration-300 mr-2 px-3 py-1">Done</button>
                                        </form>
                                    @endif

                                </td>
                                <td class="border py-2 text-center">
                                    <div class="flex justify-center">



                                        <a href="{{route('task.edit',$task->id)}}" class="bg-emerald-600  px-3 py-1 mr-2">Edit</a>

                                        <form action="{{route('task.destroy',$task->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600  px-3 py-1">Delete</button>
                                        </form>


                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-5">
                        {{$tasks->links()}}
                    </div>
                </div>
        </div>
    </div>
</x-app-layout>
