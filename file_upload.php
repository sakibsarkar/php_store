<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload with Preview</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-size: 16px;
            margin-bottom: 10px;
        }

        input[type="file"] {
            padding: 10px;
            font-size: 14px;
            margin-bottom: 15px;
            display: block;
            width: 100%;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        #preview {
            margin-top: 15px;
            max-width: 100%;
            border-radius: 5px;
            border: 1px solid #ddd;
            display: none;
        }
    </style>
</head>
<body>
    <form action="api/file_upload_.php" method="POST" enctype="multipart/form-data">
        <h1>Upload a File</h1>
        <label for="file">Choose a file:</label>
        <input type="file" name="file" id="file" onchange="previewFile()">
        
        <img id="preview" src="" alt="Image preview">
        
        <input type="submit" name="submit" value="Upload">
    </form>

    <script>
        function previewFile() {
            const preview = document.getElementById('preview');
            const file = document.getElementById('file').files[0];
            const reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
                preview.style.display = 'block'; 
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        }
    </script>
</body>
</html>
