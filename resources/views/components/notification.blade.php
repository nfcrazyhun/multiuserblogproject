<!-- Global notification manager -->
<div
    x-data="{
        messages: [],
        remove(message) {
            this.messages.splice(this.messages.indexOf(message), 1);
        },
    }"
    @notify.window="let message = $event.detail; messages.push(message); setTimeout(() => { remove(message) }, 3000)"
    class="fixed inset-0 flex flex-col items-end justify-start px-3 py-5 sm:p-5 space-y-4 pointer-events-none"
>
    <template x-for="(message, messageIndex) in messages" :key="messageIndex" hidden>
        <div x-transition class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto">
            <div class="rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 flex items-start">
                        <div class="pr-3">
                            <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="w-0 flex-1 pt-0.5">
                            <p x-text="message" class="text-base font-semibold text-gray-900"></p>
                        </div>
                        <div class="">
                            <button @click="remove(message)" class="text-gray-500">
                                <svg class="h-5 w-5" viewBox="0 0 22 22" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                </div>
            </div>
        </div>
    </template>
</div>
