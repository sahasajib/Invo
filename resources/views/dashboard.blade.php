<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="container mx-auto py-10">
            <div class="grid grid-cols-4 gap-5">
                <div class="bg-gradient-to-tr from-teal-200 to-yellow-500 rounded-md">
                    <a href="" class="flex px-10 py-14 flex-col items-center">
                        <h1 class="font-bold text-3xl">07</h1>
                        <h2 class="text-emerald-900 font-black uppercase">Clients</h2>
                    </a>
                </div>
                <div class="bg-gradient-to-tl from-teal-200 to-yellow-500 rounded-md">
                    <a href="" class="flex px-10 py-14 flex-col items-center">
                        <h1 class="font-bold text-3xl">07</h1>
                        <h2 class="text-emerald-900 font-black uppercase">Pending Tasks</h2>
                    </a>
                </div>
                <div class="bg-gradient-to-bl from-orange-400 to-emerald-300 rounded-md">
                    <a href="" class="flex px-10 py-14 flex-col items-center">
                        <h1 class="font-bold text-3xl">07</h1>
                        <h2 class="text-emerald-900 font-black uppercase">Completed Tasks</h2>
                    </a>
                </div>
                <div class="bg-gradient-to-br from-orange-400 to-emerald-300 rounded-md">
                <a href="" class="flex px-10 py-14 flex-col items-center">
                        <h1 class="font-bold text-3xl">07</h1>
                        <h2 class="text-emerald-900 font-black uppercase">Due Invoice</h2>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="">
        <div class="container mx-auto">
            <div class="flex space-x-10">
                <div class="prose max-w-none">
                    <h3>Todo:</h3>

                    <ul class="bg-slate-300 px-10 py-4 inline-block">
                        <li><a href="">Lorem ipsum dolor sit.</a></li>
                        <li><a href="">Lorem ipsum dolor sit.</a></li>
                        <li><a href="">Lorem ipsum dolor sit.</a></li>
                        <li><a href="">Lorem ipsum dolor sit.</a></li>
                        <li><a href="">Lorem ipsum dolor sit.</a></li>
                    </ul>
                </div>
                <div class="prose max-w-none">
                    <h3>Payment History:</h3>

                    <ul class="bg-amber-400 px-5 py-4">
                        <li class="flex justify-between space-x-10 items-center"><span class="text-sm">10 Feb, 2020</span><span>Jhon Doe</span><span>$500</span></li>
                        <li class="flex justify-between space-x-10 items-center"><span class="text-sm">10 Feb, 2020</span><span>Jhon Doe</span><span>$500</span></li>
                        <li class="flex justify-between space-x-10 items-center"><span class="text-sm">10 Feb, 2020</span><span>Jhon Doe</span><span>$500</span></li>
                    </ul>
                </div>
            
                </div>
        </div>
    </div>
</x-app-layout>
