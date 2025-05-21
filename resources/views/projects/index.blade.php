<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Projects</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 min-h-screen font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-500 to-purple-600">
                    Project Management
                </span>
            </h1>
            <p class="mt-3 text-gray-500 sm:mt-4">Kelola project portfoliomu dengan mudah dan efisien</p>
        </div>

        <!-- Form Tambah Project -->
        <div class="mb-10">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-purple-600">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <i class="fas fa-plus-circle mr-2"></i> Tambah Project Baru
                    </h2>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="col-span-2 sm:col-span-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Project</label>
                                <input type="text" name="judul" placeholder="Masukkan judul project"
                                    class="block w-full px-3 py-2 border border-gray-200 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">URL Demo</label>
                                <input type="text" name="url" placeholder="https://example.com"
                                    class="block w-full px-3 py-2 border border-gray-200 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                <textarea name="deskripsi" placeholder="Jelaskan project anda..." rows="3"
                                    class="block w-full px-3 py-2 border border-gray-200 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"></textarea>
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Foto Project</label>
                                <div class="flex items-center justify-center w-full">
                                    <label
                                        class="w-full flex flex-col items-center px-4 py-6 bg-white rounded-lg shadow-sm border border-gray-200 cursor-pointer hover:bg-gray-50 transition">
                                        <i class="fas fa-cloud-upload-alt text-blue-500 text-3xl mb-2"></i>
                                        <span class="text-sm text-gray-500">Upload thumbnail</span>
                                        <input type="file" name="foto" class="hidden" accept="image/*">
                                    </label>
                                </div>
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Icon Tech Stack</label>
                                <div class="flex items-center justify-center w-full">
                                    <label
                                        class="w-full flex flex-col items-center px-4 py-6 bg-white rounded-lg shadow-sm border border-gray-200 cursor-pointer hover:bg-gray-50 transition">
                                        <i class="fas fa-code text-purple-500 text-3xl mb-2"></i>
                                        <span class="text-sm text-gray-500">Upload tech icons (multiple)</span>
                                        <input type="file" name="tech[]" multiple accept="image/*" class="hidden">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                class="px-6 py-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5 flex items-center">
                                <i class="fas fa-save mr-2"></i> Simpan Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Project List -->
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-folder-open text-blue-500 mr-3"></i> Daftar Projects
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($projects as $project)
                    <div
                        class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition">
                        <div class="relative">
                            <img src="{{ $project->image_url }}" alt="{{ $project->judul }}"
                                class="w-full h-40 object-cover">
                            <div
                                class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                                <h3 class="text-lg font-semibold text-white">{{ $project->judul }}</h3>
                            </div>
                        </div>

                        <div class="p-4">
                            <p class="text-gray-600 text-sm line-clamp-2 h-10">{{ $project->deskripsi }}</p>

                            <!-- Tech Stack -->
                            <div class="mt-3">
                                <p class="text-xs font-medium text-gray-500 mb-2">TECH STACK</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach (json_decode($project->tech) ?? [] as $tech)
                                        <img src="{{ $tech }}" alt="tech" class="h-6 w-6 object-contain">
                                    @endforeach
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-4 pt-3 border-t border-gray-100 flex justify-between">
                                <a href="{{ $project->url }}" target="_blank"
                                    class="text-blue-500 hover:text-blue-700 text-sm font-medium flex items-center">
                                    <i class="fas fa-external-link-alt mr-1"></i> Demo
                                </a>
                                <div class="flex space-x-2">
                                    <button type="button" onclick="toggleEdit({{ $project->id }})"
                                        class="text-yellow-500 hover:text-yellow-700 text-sm flex items-center">
                                        <i class="fas fa-edit mb-2"></i>
                                    </button>
                                    <form method="POST" action="{{ route('projects.destroy', $project->id) }}"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-500 hover:text-red-700 text-sm flex items-center">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Form (Hidden by default) -->
                        <div id="edit-{{ $project->id }}" class="hidden p-4 bg-gray-50 border-t border-gray-100">
                            <form method="POST" action="{{ route('projects.update', $project->id) }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Judul</label>
                                        <input type="text" name="judul" value="{{ $project->judul }}"
                                            class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Deskripsi</label>
                                        <textarea name="deskripsi" rows="2" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg">{{ $project->deskripsi }}</textarea>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">URL</label>
                                        <input type="text" name="url" value="{{ $project->url }}"
                                            class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg">
                                    </div>

                                    <!-- Edit Foto Project -->
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Foto
                                            Project</label>
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0 h-12 w-12 rounded border overflow-hidden">
                                                <img src="{{ $project->image_url }}"
                                                    class="h-full w-full object-cover" alt="Current image">
                                            </div>
                                            <div class="flex-grow">
                                                <label
                                                    class="flex items-center px-3 py-2 bg-white rounded-lg shadow-sm border border-gray-200 cursor-pointer hover:bg-gray-50 transition">
                                                    <i class="fas fa-image text-blue-500 mr-2"></i>
                                                    <span class="text-xs text-gray-500">Ganti foto</span>
                                                    <input type="file" name="foto" class="hidden">
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Edit Tech Stack Icons -->
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Tech Stack
                                            Icons</label>
                                        <div class="mb-2 flex flex-wrap gap-2">
                                            @foreach (json_decode($project->tech) ?? [] as $index => $tech)
                                                <div class="relative group">
                                                    <img src="{{ $tech }}" class="h-6 w-6 object-contain"
                                                        alt="tech">
                                                    <div
                                                        class="absolute -top-1 -right-1 opacity-0 group-hover:opacity-100 transition">
                                                        <button type="button"
                                                            class="h-4 w-4 bg-red-500 rounded-full text-white flex items-center justify-center text-xs">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <label
                                            class="flex items-center px-3 py-2 bg-white rounded-lg shadow-sm border border-gray-200 cursor-pointer hover:bg-gray-50 transition">
                                            <i class="fas fa-code text-purple-500 mr-2"></i>
                                            <span class="text-xs text-gray-500">Tambah tech stack baru
                                                (multiple)</span>
                                            <input type="file" name="tech[]" multiple accept="image/*"
                                                class="hidden">
                                        </label>
                                        <input type="hidden" name="keep_tech" value="1">
                                    </div>

                                    <div class="flex justify-end space-x-2">
                                        <button type="button" onclick="toggleEdit({{ $project->id }})"
                                            class="px-4 py-1 bg-gray-400 text-white text-sm rounded-lg">
                                            Batal
                                        </button>
                                        <button type="submit"
                                            class="px-4 py-1 bg-yellow-500 text-white text-sm rounded-lg">
                                            <i class="fas fa-save mr-1"></i> Update
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function toggleEdit(id) {
            const editForm = document.getElementById(`edit-${id}`);
            editForm.classList.toggle('hidden');
        }

        // Handle file uploads and show previews
        document.addEventListener('DOMContentLoaded', function() {
            // Handle main form upload previews
            const mainFotoInput = document.querySelector(
                'form[action="{{ route('projects.store') }}"] input[name="foto"]');
            const mainTechInput = document.querySelector(
                'form[action="{{ route('projects.store') }}"] input[name="tech[]"]');

            if (mainFotoInput) {
                mainFotoInput.addEventListener('change', function(e) {
                    const parent = this.closest('label');
                    const icon = parent.querySelector('i');
                    const textSpan = parent.querySelector('span');

                    if (this.files.length > 0) {
                        const file = this.files[0];
                        icon.className = 'fas fa-check-circle text-green-500 text-3xl mb-2';
                        textSpan.textContent = file.name;

                        // Create preview if doesn't exist
                        let preview = parent.querySelector('.preview-img');
                        if (!preview) {
                            preview = document.createElement('div');
                            preview.className =
                                'preview-img mt-2 w-full h-24 bg-gray-100 rounded flex items-center justify-center overflow-hidden';
                            parent.appendChild(preview);
                        }

                        // Show image preview
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.innerHTML =
                                `<img src="${e.target.result}" class="h-full object-contain">`;
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }

            if (mainTechInput) {
                mainTechInput.addEventListener('change', function(e) {
                    const parent = this.closest('label');
                    const icon = parent.querySelector('i');
                    const textSpan = parent.querySelector('span');

                    if (this.files.length > 0) {
                        icon.className = 'fas fa-check-circle text-green-500 text-3xl mb-2';
                        textSpan.textContent = `${this.files.length} file dipilih`;

                        // Create preview container if doesn't exist
                        let previewContainer = parent.querySelector('.preview-container');
                        if (!previewContainer) {
                            previewContainer = document.createElement('div');
                            previewContainer.className = 'preview-container mt-2 flex flex-wrap gap-2';
                            parent.appendChild(previewContainer);
                        } else {
                            previewContainer.innerHTML = '';
                        }

                        // Show previews for each selected file
                        Array.from(this.files).forEach(file => {
                            const reader = new FileReader();
                            const previewItem = document.createElement('div');
                            previewItem.className =
                                'h-8 w-8 bg-gray-100 rounded flex items-center justify-center overflow-hidden';

                            reader.onload = function(e) {
                                previewItem.innerHTML =
                                    `<img src="${e.target.result}" class="h-full object-contain">`;
                            }
                            reader.readAsDataURL(file);
                            previewContainer.appendChild(previewItem);
                        });
                    }
                });
            }

            // Handle edit form upload previews
            document.querySelectorAll('form[action^="/projects/"]').forEach(form => {
                const fotoInput = form.querySelector('input[name="foto"]');
                const techInput = form.querySelector('input[name="tech[]"]');

                if (fotoInput) {
                    fotoInput.addEventListener('change', function(e) {
                        const label = this.closest('label');
                        const textSpan = label.querySelector('span');
                        const previewImg = this.closest('div.flex').querySelector('img');

                        if (this.files.length > 0) {
                            const file = this.files[0];
                            textSpan.textContent = file.name;

                            // Update preview image
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                previewImg.src = e.target.result;
                            }
                            reader.readAsDataURL(file);
                        }
                    });
                }

                if (techInput) {
                    techInput.addEventListener('change', function(e) {
                        const label = this.closest('label');
                        const textSpan = label.querySelector('span');

                        if (this.files.length > 0) {
                            textSpan.textContent = `${this.files.length} file baru dipilih`;

                            // Add preview of new tech icons
                            const parentDiv = label.closest('div');
                            let newPreviewDiv = parentDiv.querySelector('.new-tech-preview');

                            if (!newPreviewDiv) {
                                newPreviewDiv = document.createElement('div');
                                newPreviewDiv.className =
                                    'new-tech-preview mt-2 flex flex-wrap gap-2';
                                newPreviewDiv.innerHTML =
                                    '<p class="w-full text-xs text-gray-500">Preview icon baru:</p>';
                                parentDiv.insertBefore(newPreviewDiv, label.nextSibling);
                            } else {
                                // Clear previous previews but keep the title
                                const title = newPreviewDiv.querySelector('p');
                                newPreviewDiv.innerHTML = '';
                                newPreviewDiv.appendChild(title);
                            }

                            Array.from(this.files).forEach(file => {
                                const reader = new FileReader();
                                const previewItem = document.createElement('div');
                                previewItem.className =
                                    'h-6 w-6 bg-gray-100 rounded flex items-center justify-center overflow-hidden';

                                reader.onload = function(e) {
                                    previewItem.innerHTML =
                                        `<img src="${e.target.result}" class="h-full object-contain">`;
                                }
                                reader.readAsDataURL(file);
                                newPreviewDiv.appendChild(previewItem);
                            });
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>
