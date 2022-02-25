<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Invoice') }}
            </h2>
            <a href="{{route('invoice.create')}}" class="border border-green-400 px-3 py-1">{{__('Add New')}}</a>
        </div>

    </x-slot>

    @if (Session('success'))
    <div class="py-2 bg-emerald-300 text-emerald-700 text-center" id="status_message">
        <p>{{Session('success')}}</p>
    </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-md py-10 mb-6">
            <form action="{{ route('invoice.create') }}" method="GET">
                        @csrf

                        <div class="flex space-x-3 items-end justify-center">
                            <div class="">
                                @error('status')
                                <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                                <label for="status" class="formLabel">Select Status</label>
                                <select name="status" id="status" class="formInput">
                                    <option value="none">Select Status</option>
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
                                    value="{{ request('endDate') !='' ? request('endDate') : now()->format('Y-m-d') }}"
                                    max="{{ now()->format('Y-m-d') }}">

                            </div>
                            <div class="">
                                <button type="submit" class="bg-purple-600 text-white px-3 py-2">Search</button>
                            </div>
                        </div>
                </form>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="border py-2">#</th>
                                <th class="border py-2">Client</th>
                                <th class="border py-2">Status</th>
                                <th class="border py-2">PDF</th>
                                <th class="border py-2">Email Sent</th>
                                <th class="border py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($invoices as $invoice)
                            <tr>
                                <td class="border py-2 text-center">{{$invoice->invoice_id}}</td>
                                <td class="border py-2 text-left px-2 text-center">{{$invoice->client->name}}</td>
                                <td class="border py-2 text-center capitalize">{{$invoice->status}}</td>
                                <td class="border py-2 text-center capitalize">
                                    <a target="_blank" href="{{asset('storage/invoice/' .  $invoice->download_url) }}" class="bg-purple-800 text-white px-3 py-1 mr-2">View PDF</a>
                                </td>
                                <td class="border py-2 text-center capitalize">{{$invoice->email_sent}}</td>
                                <td class="border py-2 text-center">
                                    <div class="flex justify-center">
                                        <a href="{{route('invoice.sendEmail',$invoice)}}" class="bg-green-600  px-3 py-1 mr-2">Send Mail</a>
                                        @if($invoice->status == 'unpaid')
                                        <form action="{{route('invoice.update',$invoice->id)}}" method="post" 
                                        onsubmit="return confirm('did you get paid?');">
                                        @csrf
                                        @method('put')
                                        <button type="submit" class="bg-emerald-600  px-3 py-1 mr-2 ">Paid</button>
                                        </form>
                                        @endif
                                        <form action="{{route('invoice.destroy',$invoice->id)}}" method="post"
                                        onsubmit="return confirm('did you really want to delete?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600  px-3 py-1">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-center border py-2" colspan="5"> No Invoice Found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    <div class="mt-5">
                        {{$invoices->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
