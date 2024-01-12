<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            margin-bottom: 10px;
        }

        .image-container {
            display: flex;
            flex-wrap: wrap;
        }

        img {
            max-width: 100%;
            height: auto;
            margin: 5px;
        }
    </style>
</head>
<body>

    <h2>Upload Images</h2>

    <form action="/upload" method="post" enctype="multipart/form-data">
        @csrf
        <label for="category">Select Category:</label>
        <select name="category" id="category">
            <option value="space">Space</option>
            <option value="block">Block</option>
        </select>

        <br>

        <label for="images">Choose Images:</label>
        <input type="file" name="image" id="images" multiple accept="image/*">

        <br>

        <button type="submit">Upload</button>
    </form>

    <hr>

    <h2>Space Images</h2>
    <div class="image-container">
        @empty($spaceImages)
            <div>No image</div>
        @else
            @foreach ($spaceImages as $image)
                <img src="https://election-storage.sgp1.digitaloceanspaces.com/quiz/{{ $image->name }}" alt="">
            @endforeach
        @endempty
    </div>

    <hr>

    {{-- <h2>Block Images</h2>
    <div class="image-container">
        @empty($blockImages)
            <div>No image</div>
        @else
            @foreach ($blockImages as $block)
            <img src="{{ asset('volume_sgp1_02/' . $block->name) }}" >
            @endforeach
        @endempty
    </div> --}}

</body>
</html>