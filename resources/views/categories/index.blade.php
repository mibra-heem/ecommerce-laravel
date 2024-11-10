@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="col">
            <h2>Categories</h2>
        </div>
        <div class="col d-flex justify-content-end">
            <!-- Button to open Add Category Modal -->
            <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Add
                Category</button>
        </div>

        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr id="category-{{ $category->id }}">
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <!-- Button to open Edit Category Modal -->
                            <button class="btn btn-secondary btn-md edit-category" data-id="{{ $category->id }}"
                                data-name="{{ $category->name }}">Edit</button>
                        </td>
                        <td>
                            <button class="btn btn-danger btn-md delete-category"
                                data-id="{{ $category->id }}">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addCategoryForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="name" class="form-control" placeholder="Category Name" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editCategoryForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editCategoryId">
                        <input type="text" name="name" id="editCategoryName" class="form-control"
                            placeholder="Category Name" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <!-- AJAX and JavaScript -->
    <script>
        $(document).ready(function() {
            // Add Category
            $('#addCategoryForm').on('submit', function(e) {

                console.log('submitted');
                e.preventDefault();
                $.ajax({
                    url: "{{ route('categories.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#addCategoryModal').modal('hide');
                        // Append the new category to the table
                        console.log(response);
                        $('tbody').append(`
            <tr id="category-${response.category.id}">
                <th scope="row">${response.category.id}</th>
                <td>${response.category.id}</td>
                <td>${response.category.name}</td>
                <td><button class="btn btn-secondary btn-md edit-category" data-id="${response.category.id}" data-name="${response.category.name}">Edit</button></td>
                <td><button class="btn btn-danger btn-md delete-category" data-id="${response.category.id}">Delete</button></td>
            </tr>
        `);
                    }
                });

            });

            // Show Edit Modal
            $(document).on('click', '.edit-category', function() {
                $('#editCategoryId').val($(this).data('id'));
                $('#editCategoryName').val($(this).data('name'));
                $('#editCategoryModal').modal('show');
            });

            // Edit Category
            $('#editCategoryForm').on('submit', function(e) {
                e.preventDefault();
                var id = $('#editCategoryId').val();
                $.ajax({
                    url: `/categories/${id}`,
                    method: "PUT",
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#editCategoryModal').modal('hide');
                        $(`#category-${id} td:nth-child(3)`).text(response.name);
                    }
                });
            });

            // Delete Category
            $(document).on('click', '.delete-category', function() {
                var id = $(this).data('id');
                if (confirm("Are you sure you want to delete this category?")) {
                    $.ajax({
                        url: `/categories/${id}`,
                        method: "DELETE",
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            $(`#category-${id}`).remove();
                        }
                    });
                }
            });
        });
    </script>
@endsection