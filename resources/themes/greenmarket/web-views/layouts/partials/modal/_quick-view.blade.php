<!-- Quick View Modal -->
<div id="quick-view-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black bg-opacity-50" onclick="document.getElementById('quick-view-modal').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-lg max-w-4xl w-full p-6">
            <button onclick="document.getElementById('quick-view-modal').classList.add('hidden')" 
                    class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <div id="quick-view-content">
                <!-- Content will be loaded dynamically -->
            </div>
        </div>
    </div>
</div>

