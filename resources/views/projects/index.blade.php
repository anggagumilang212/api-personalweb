<!DOCTYPE html>
<html>

<head>
    <title>Daftar Projects</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="p-8 bg-gray-100">

    <h1 class="text-2xl font-bold mb-4">Tambah Project</h1>
    <form method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data"
        class="bg-white p-4 rounded shadow-md mb-8">
        @csrf
        <input type="text" name="judul" placeholder="Judul" class="block w-full mb-2 p-2 border rounded">
        <textarea name="deskripsi" placeholder="Deskripsi" class="block w-full mb-2 p-2 border rounded"></textarea>
        <input type="text" name="url" placeholder="URL Demo" class="block w-full mb-2 p-2 border rounded">
        <input type="file" name="foto" class="block w-full mb-2">

        <label class="block mb-1">Upload Icon Tech Stack (boleh banyak):</label>
        <input type="file" name="tech[]" multiple accept="image/*" class="block w-full mb-4">

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
    </form>


    <h1 class="text-2xl font-bold mb-4">Daftar Project</h1>

    @foreach ($projects as $project)
        <div class="bg-white p-4 mb-4 rounded shadow-md">
            <h2 class="text-xl font-semibold">{{ $project->judul }}</h2>
            <p>{{ $project->deskripsi }}</p>
            <img src="{{ $project->image_url }}" class="w-64 mt-2">
            <p class="mt-2">Tech Stack:</p>
            <div class="flex gap-2 mt-2">
                @foreach (json_decode($project->tech) ?? [] as $tech)
                    <img src="{{ $tech }}" alt="tech" width="30">
                @endforeach
            </div>

            <form method="POST" action="{{ route('projects.update', $project->id) }}" class="mt-2">
                @csrf
                <input type="text" name="judul" value="{{ $project->judul }}" class="border p-1">
                <input type="text" name="deskripsi" value="{{ $project->deskripsi }}" class="border p-1">
                <input type="text" name="url" value="{{ $project->url }}" class="border p-1">
                <input type="text" name="tech[]" value="{{ $project->tech[0] ?? '' }}" class="border p-1">
                <button class="bg-yellow-500 text-white px-2 py-1 rounded">Update</button>
            </form>
            <form method="POST" action="{{ route('projects.destroy', $project->id) }}" class="mt-2">
                @csrf
                @method('DELETE')
                <button class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
            </form>
        </div>
    @endforeach

</body>

</html>
