<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    <style>
        .tab-content {
            padding: 20px;
        }
        .image-preview {
            max-width: 300px;
            margin: 10px 0;
        }
        .cropper-container {
            max-height: 400px;
        }
        #cropperModal .modal-body {
            height: 400px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1>Admin Panel</h1>
        
        <ul class="nav nav-tabs" id="adminTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="photoshop-tab" data-bs-toggle="tab" href="#photoshop" role="tab">Photoshop</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="audio-tab" data-bs-toggle="tab" href="#audio" role="tab">Audio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="programming-tab" data-bs-toggle="tab" href="#programming" role="tab">Programming</a>
            </li>
        </ul>

        <div class="tab-content" id="adminTabsContent">
            <!-- Photoshop Tab -->
            <div class="tab-pane fade show active" id="photoshop" role="tabpanel">
                <h2>Photoshop Entries</h2>
                <button class="btn btn-primary mb-3" onclick="showAddModal('photoshop')">Add New Entry</button>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="photoshopTableBody">
                            @foreach($photoshops as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->description }}</td>
                                <td><img src="{{ $item->cropped_image }}" alt="Cropped" style="width: 100px;"></td>
                                <td>
                                    <button class="btn btn-sm btn-warning" onclick="editItem('photoshop', {{ $item->id }})">Edit</button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteItem('photoshop', {{ $item->id }})">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Audio Tab -->
            <div class="tab-pane fade" id="audio" role="tabpanel">
                <h2>Audio Entries</h2>
                <button class="btn btn-primary mb-3" onclick="showAddModal('audio')">Add New Entry</button>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="audioTableBody">
                            @foreach($audios as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->description }}</td>
                                <td><img src="{{ $item->cropped_image }}" alt="Cropped" style="width: 100px;"></td>
                                <td>
                                    <button class="btn btn-sm btn-warning" onclick="editItem('audio', {{ $item->id }})">Edit</button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteItem('audio', {{ $item->id }})">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Programming Tab -->
            <div class="tab-pane fade" id="programming" role="tabpanel">
                <h2>Programming Entries</h2>
                <button class="btn btn-primary mb-3" onclick="showAddModal('programming')">Add New Entry</button>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="programmingTableBody">
                            @foreach($programmings as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->description }}</td>
                                <td><img src="{{ $item->cropped_image }}" alt="Cropped" style="width: 100px;"></td>
                                <td>
                                    <button class="btn btn-sm btn-warning" onclick="editItem('programming', {{ $item->id }})">Edit</button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteItem('programming', {{ $item->id }})">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="itemModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Entry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="itemForm">
                        <input type="hidden" id="itemId">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" accept="image/*" required>
                            <img id="imagePreview" class="image-preview d-none">
                        </div>
                        <div id="programmingFields" class="d-none">
                            <div class="mb-3">
                                <label for="additionalImages" class="form-label">Additional Images</label>
                                <input type="file" class="form-control" id="additionalImages" accept="image/*" multiple>
                                <div id="additionalImagesPreview" class="mt-2"></div>
                            </div>
                        </div>
                        <div id="audioFields" class="d-none">
                            <div class="mb-3">
                                <label for="mp3File" class="form-label">MP3 File</label>
                                <input type="file" class="form-control" id="mp3File" accept="audio/mp3">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveItem()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Cropper Modal -->
    <div class="modal fade" id="cropperModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crop Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <img id="cropperImage" src="" style="max-width: 100%;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="cropImage()">Crop</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script>
        let currentType = '';
        let cropper = null;
        let itemModal = new bootstrap.Modal(document.getElementById('itemModal'));
        let cropperModal = new bootstrap.Modal(document.getElementById('cropperModal'));

        function showAddModal(type) {
            currentType = type;
            document.getElementById('itemForm').reset();
            document.getElementById('itemId').value = '';
            document.getElementById('audioFields').classList.toggle('d-none', type !== 'audio');
            document.getElementById('programmingFields').classList.toggle('d-none', type !== 'programming');
            document.querySelector('#itemModal .modal-title').textContent = `Add New ${type.charAt(0).toUpperCase() + type.slice(1)} Entry`;
            itemModal.show();
        }

        function editItem(type, id) {
            currentType = type;
            // Fetch item data and populate form
            fetch(`/api/${type}/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('itemId').value = data.id;
                    document.getElementById('name').value = data.name;
                    document.getElementById('description').value = data.description;
                    document.getElementById('imagePreview').src = data.cropped_image;
                    document.getElementById('imagePreview').classList.remove('d-none');
                    if (type === 'audio') {
                        document.getElementById('audioFields').classList.remove('d-none');
                    }
                    itemModal.show();
                });
        }

        function deleteItem(type, id) {
            if (confirm('Are you sure you want to delete this item?')) {
                fetch(`/api/${type}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                }).then(() => {
                    location.reload();
                });
            }
        }

        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && currentType !== 'programming') {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('cropperImage').src = e.target.result;
                    cropperModal.show();
                    if (cropper) {
                        cropper.destroy();
                    }
                    cropper = new Cropper(document.getElementById('cropperImage'), {
                        aspectRatio: 1,
                        viewMode: 1,
                        dragMode: 'move',
                        autoCropArea: 1,
                        restore: false,
                        guides: true,
                        center: true,
                        highlight: false,
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        toggleDragModeOnDblclick: false,
                    });
                };
                reader.readAsDataURL(file);
            } else if (file && currentType === 'programming') {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            }
        });

        function cropImage() {
            const canvas = cropper.getCroppedCanvas({
                width: 300,
                height: 300
            });
            document.getElementById('imagePreview').src = canvas.toDataURL();
            document.getElementById('imagePreview').classList.remove('d-none');
            cropperModal.hide();
        }

        document.getElementById('additionalImages').addEventListener('change', function(e) {
            const files = e.target.files;
            const previewContainer = document.getElementById('additionalImagesPreview');
            previewContainer.innerHTML = '';
            
            for (let file of files) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '100px';
                    img.style.margin = '5px';
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });

        function saveItem() {
            const formData = new FormData();
            formData.append('name', document.getElementById('name').value);
            formData.append('description', document.getElementById('description').value);
            
            if (currentType === 'programming') {
                formData.append('cropped_image', document.getElementById('imagePreview').src);
                
                // Handle additional images
                const additionalImages = document.getElementById('additionalImages').files;
                for (let i = 0; i < additionalImages.length; i++) {
                    formData.append('additional_images[]', additionalImages[i]);
                }
            } else {
                formData.append('image_link', document.getElementById('imagePreview').src);
                formData.append('cropped_image', document.getElementById('imagePreview').src);
            }

            if (currentType === 'audio') {
                formData.append('mp3_file', document.getElementById('mp3File').files[0]);
            }

            const id = document.getElementById('itemId').value;
            const method = id ? 'PUT' : 'POST';
            const url = id ? `/api/${currentType}/${id}` : `/api/${currentType}`;

            console.log('Request URL:', url);
            console.log('Request Method:', method);
            console.log('Form Data:', Object.fromEntries(formData));

            fetch(url, {
                method: method,
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).then(response => {
                console.log('Response status:', response.status);
                return response.json();
            }).then(data => {
                console.log('Response data:', data);
                location.reload();
            }).catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</body>
</html> 