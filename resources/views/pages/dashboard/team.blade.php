    @extends('layouts.admin')

    @section('title', 'Manajemen Team')

    @section('content')
        <div x-data="teamCrud()">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold">Manajemen Team</h1>
                <button @click="openModal('add')"
                    class="inline-flex items-center justify-center rounded-md bg-persada-primary p-2 text-sm font-semibold text-white hover:bg-persada-dark-hover sm:px-4">
                    <x-heroicon-o-plus class="h-5 w-5" />
                    <span class="hidden sm:ml-2 sm:inline">Tambah Team</span>
                </button>
            </div>

            <div class="mt-6 overflow-x-auto bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                No.
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                Nama
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                Email
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @forelse ($teams as $team)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                    {{ ($teams->currentPage() - 1) * $teams->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                    {{ $team->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $team->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                    <div class="flex items-center gap-x-2">
                                        <button @click="openModal('edit', @js($team))"
                                            class="p-1.5 rounded bg-amber-500 text-white hover:bg-amber-600 dark:bg-amber-600 dark:hover:bg-amber-700">
                                            <x-heroicon-o-pencil class="w-4 h-4" />
                                        </button>
                                        <form action="{{ route('teams.destroy', $team->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete(this.closest('form'))"
                                                class="p-1.5 rounded bg-red-600 text-white hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800">
                                                <x-heroicon-o-trash class="w-4 h-4" />
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Belum ada data tim.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $teams->links() }}
            </div>

            <div x-show="isOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                <div @click.away="closeModal()" class="w-full max-w-lg bg-white rounded-lg p-6 dark:bg-gray-800">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white" x-text="modalTitle"></h3>

                    <form :action="formAction" method="POST" class="space-y-4">
                        @csrf
                        <template x-if="!isAddMode">
                            <input type="hidden" name="_method" value="PATCH">
                        </template>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                            <input type="text" name="name" x-model="formData.name"
                                class="mt-1 w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-persada-primary focus:border-persada-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <input type="email" name="email" x-model="formData.email"
                                class="mt-1 w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-persada-primary focus:border-persada-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                            <input type="password" name="password"
                                class="mt-1 w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-persada-primary focus:border-persada-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Konfirmasi
                                Password</label>
                            <input type="password" name="password_confirmation"
                                class="mt-1 w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-persada-primary focus:border-persada-primary">
                        </div>

                        <div class="flex justify-end gap-2 pt-4">
                            <button type="button" @click="closeModal()"
                                class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-persada-primary text-white rounded hover:bg-persada-dark-hover"
                                x-text="submitText"></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script>
            function teamCrud() {
                return {
                    isOpen: false,
                    isAddMode: true,
                    modalTitle: '',
                    submitText: '',
                    formAction: '',
                    formData: {
                        id: null,
                        name: '',
                        email: ''
                    },

                    openModal(mode, team = null) {
                        this.isOpen = true;

                        if (mode === 'add') {
                            this.isAddMode = true;
                            this.modalTitle = 'Tambah Tim Baru';
                            this.submitText = 'Simpan';
                            this.formAction = '{{ route('teams.store') }}';
                            this.formData = {
                                id: null,
                                name: '',
                                email: ''
                            };
                        } else {
                            this.isAddMode = false;
                            this.modalTitle = 'Edit Tim';
                            this.submitText = 'Simpan';

                            let updateUrl = '{{ route('teams.update', ['team' => ':id']) }}';
                            this.formAction = updateUrl.replace(':id', team.id);

                            this.formData = {
                                id: team.id,
                                name: team.name,
                                email: team.email
                            };
                        }
                    },

                    closeModal() {
                        this.isOpen = false;
                    }
                }
            }
        </script>
    @endpush
