<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                {{-- Komponen Chat Utama dengan Alpine.js --}}
                <div
                    class="flex h-[80vh]" {{-- Sedikit lebih tinggi untuk kenyamanan --}}
                    x-data="chatComponent()"
                    x-init="init({{ $activeConversationId ?? 'null' }})"
                >
                    {{-- 1. Sidebar Daftar Percakapan (Tampilan Ditingkatkan) --}}
                    <div class="w-1/3 border-r border-gray-200 dark:border-gray-700 flex flex-col">
                        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="font-bold text-lg text-gray-900 dark:text-white">Percakapan</h3>
                        </div>
                        <div class="flex-1 overflow-y-auto">
                            <ul class="p-2 space-y-1">
                                <template x-if="conversations.length === 0">
                                    <li class="p-4 text-center text-gray-400">
                                        Tidak ada percakapan.
                                    </li>
                                </template>
                                <template x-for="conversation in conversations" :key="conversation.id">
                                    <div 
                                        @click="openConversation(conversation.id)"
                                        class="flex items-center p-3 rounded-lg transition-colors duration-200 space-x-3 cursor-pointer group"
                                        :class="{ 'bg-red-500 text-white': activeConversationId === conversation.id, 'hover:bg-gray-100 dark:hover:bg-gray-700': activeConversationId !== conversation.id }"
                                    >
                                        <img :src="getPartner(conversation).profile_photo_url || 'https://via.placeholder.com/40'" alt="Partner Avatar" class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                                        
                                        <div class="flex-1 overflow-hidden">
                                            <p class="font-bold truncate" :class="{'text-white': activeConversationId === conversation.id, 'text-gray-800 dark:text-gray-200': activeConversationId !== conversation.id }" x-text="getPartner(conversation).name"></p>
                                            <p class="text-sm truncate" :class="{'text-gray-200': activeConversationId === conversation.id, 'text-gray-500 dark:text-gray-400': activeConversationId !== conversation.id }" x-text="getLastMessageSnippet(conversation)"></p>
                                        </div>

                                        {{-- TOMBOL HAPUS --}}
                                        <button 
                                            @click.stop="confirmDelete(conversation.id, getPartner(conversation).name)"
                                            class="p-2 rounded-full text-gray-400 opacity-0 group-hover:opacity-100 hover:bg-gray-200 dark:hover:bg-gray-600 transition"
                                            :class="{'opacity-100': activeConversationId === conversation.id}"
                                            title="Hapus Percakapan"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </ul>
                        </div>
                    </div>

                    {{-- 2. Jendela Chat Utama (Tampilan Ditingkatkan) --}}
                    <div class="w-2/3 flex flex-col bg-gray-50 dark:bg-gray-900">
                        {{-- Header Chat --}}
                        <template x-if="activePartner">
                            <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex items-center space-x-4 bg-white dark:bg-gray-800 shadow-sm">
                                <img :src="activePartner.profile_photo_url || 'https://via.placeholder.com/40'" alt="Partner Avatar" class="w-10 h-10 rounded-full object-cover">
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white" x-text="activePartner.name"></h3>
                                </div>
                            </div>
                        </template>

                        {{-- Jendela Pesan --}}
                        <div class="flex-1 p-6 overflow-y-auto" x-ref="messageWindow">
                            {{-- State saat loading --}}
                            <template x-if="isLoading">
                                <div class="flex items-center justify-center h-full">
                                    <div class="w-8 h-8 border-4 border-dashed rounded-full animate-spin border-red-500"></div>
                                </div>
                            </template>
                            {{-- State saat belum memilih percakapan --}}
                            <template x-if="!activeConversationId && !isLoading">
                                <div class="flex flex-col items-center justify-center h-full text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    <p>Pilih percakapan untuk memulai chat.</p>
                                </div>
                            </template>

                            {{-- Menampilkan pesan --}}
                            <template x-for="message in messages" :key="message.id">
                                <div class="mb-4" :class="{ 'text-right': message.user_id === authUserId }">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1"
                                       :class="{ 'mr-2': message.user_id === authUserId, 'ml-2': message.user_id !== authUserId }"
                                       x-text="message.user ? message.user.name : ''">
                                    </p>
                                    <div class="inline-block py-2 px-4 rounded-xl"
                                         :class="{ 'bg-red-500 text-white': message.user_id === authUserId, 'bg-white dark:bg-gray-700': message.user_id !== authUserId }">
                                        <p class="text-left" x-text="message.body"></p>
                                        <span class="text-xs opacity-70" x-text="formatTime(message.created_at)"></span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        {{-- Form Input Pesan --}}
                        <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                            <template x-if="activeConversationId">
                                <div class="flex items-center space-x-3">
                                    <input type="text"
                                           x-model="newMessageBody"
                                           @keydown.enter.prevent="sendMessage()"
                                           :disabled="isSending"
                                           placeholder="Ketik pesan Anda..."
                                           class="flex-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 disabled:opacity-50">
                                    <button @click="sendMessage()" :disabled="isSending" class="p-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition disabled:opacity-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transform rotate-90" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function chatComponent() {
            return {
                conversations: [],
                messages: [],
                activeConversationId: null,
                activePartner: null,
                newMessageBody: '',
                isLoading: false,
                isSending: false,
                authUserId: {{ auth()->id() }},

                init(initialConversationId) {
                    fetch("{{ route('api.conversations.index') }}")
                        .then(response => response.json())
                        .then(data => {
                            this.conversations = data;
                            if (initialConversationId) {
                                this.openConversation(initialConversationId);
                            }
                        })
                        .catch(error => console.error('Error fetching conversations:', error));
                },

                openConversation(conversationId) {
                    if (this.isLoading || this.activeConversationId === conversationId) return;

                    this.isLoading = true;
                    if (this.activeConversationId) {
                        window.Echo.leave('conversation.' + this.activeConversationId);
                    }
                    this.activeConversationId = conversationId;
                    this.messages = [];
                    this.activePartner = this.getPartner(this.conversations.find(c => c.id === conversationId));

                    fetch(`/api/conversations/${conversationId}/messages`)
                        .then(response => response.json())
                        .then(data => {
                            this.messages = data;
                            this.scrollToBottom();
                        })
                        .catch(error => console.error('Error fetching messages:', error))
                        .finally(() => this.isLoading = false);

                    window.Echo.private('conversation.' + conversationId)
                        .listen('MessageSent', (e) => {
                            if (e.message.user_id !== this.authUserId) {
                                this.messages.push(e.message);
                                this.scrollToBottom();
                            }
                        });
                },

                sendMessage() {
                    if (this.newMessageBody.trim() === '' || this.isSending) return;

                    this.isSending = true;
                    const messageBody = this.newMessageBody;
                    this.newMessageBody = '';

                    fetch(`/api/conversations/${this.activeConversationId}/messages`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ body: messageBody })
                    })
                    .then(response => response.json())
                    .then(savedMessage => {
                        this.messages.push(savedMessage);
                        this.scrollToBottom();
                    })
                    .catch(error => {
                        console.error('Error sending message:', error);
                        this.newMessageBody = messageBody; // Kembalikan teks jika gagal kirim
                    })
                    .finally(() => this.isSending = false);
                },

                confirmDelete(conversationId, partnerName) {
                    Swal.fire({
                        title: 'Hapus Percakapan?',
                        text: `Anda yakin ingin menghapus percakapan dengan ${partnerName}? Aksi ini tidak bisa dibatalkan.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Buat form dinamis untuk mengirim request DELETE
                            let form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `/chat/conversations/${conversationId}`;
                            
                            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                            
                            form.innerHTML = `
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="${csrfToken}">
                            `;
                            
                            document.body.appendChild(form);
                            form.submit();
                        }
                    })
                },

                getPartner(conversation) {
                    if (!conversation) return { name: '...' };
                    return conversation.users.find(user => user.id !== this.authUserId) || { name: 'User Dihapus' };
                },

                getLastMessageSnippet(conversation) {
                    // Anda perlu menyesuaikan backend untuk menyertakan pesan terakhir
                    return "Klik untuk membuka percakapan...";
                },

                formatTime(dateTimeString) {
                    if (!dateTimeString) return '';
                    return new Date(dateTimeString).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                },

                scrollToBottom() {
                    this.$nextTick(() => {
                        if (this.$refs.messageWindow) {
                            this.$refs.messageWindow.scrollTop = this.$refs.messageWindow.scrollHeight;
                        }
                    });
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
