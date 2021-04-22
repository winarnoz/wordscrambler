<x-app-layout>
    <x-slot name="header">
        <div>SCORE: </div> <div id="score" style="font-size:200%;">0</div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6" >
                    <div id="shuffled-word" style="font-size:300%; text-align:center">LOADING...</div>
                    <div class="mt-6">
                        <input id="id-field" type="hidden"/>
                        <input id="answer-field" placeholder="Type your answer here" type="text" style="width:100%; border-radius: 5px; text-align:center" />
                    </div>
                    <div class="mt-6" style="text-align:center">
                        <div id="wrong-notif" hidden style="color:red; font-weight:bold">WRONG ANSWER</div>
                        <div id="correct-notif" hidden style="color:green; font-weight:bold">CORRECT ANSWER</div>
                        <div id="definition" hidden class="mt-2" style="color:black; font-weight:bold">DEFINITION:</div>
                        <div id="definition-notif" hidden style="color:black; "></div>
                    </div>
                    <div class="mt-6">
                        <button class="pushable" id="button-answer">
                        <span class="front">
                            SUBMIT
                        </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

</x-app-layout>

