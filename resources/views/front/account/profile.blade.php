@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success flash-message">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            <div class="col-lg-3">
                @include('front.account.sidebar')
            </div>
            <div class="col-lg-9">
                <div class="card border-0 shadow mb-4">
                    <div class="card-body p-4">
                        <h3 class="fs-4 mb-1">My Profile</h3>
                        <form id="profileForm">
                            @csrf
                            <div class="mb-4">
                                <label for="name" class="mb-2">Name*</label>
                                <input type="text" name="name" id="name" placeholder="Enter Name" class="form-control" value="{{ $user->name }}">
                                <p id="nameError" class="text-danger"></p>
                            </div>
                            <div class="mb-4">
                                <label for="email" class="mb-2">Email*</label>
                                <input type="text" name="email" id="email" placeholder="Enter Email" class="form-control" value="{{ $user->email }}">
                                <p id="emailError" class="text-danger"></p>
                            </div>
                            <div class="mb-4">
                                <label for="designation" class="mb-2">Designation*</label>
                                <input type="text" name="designation" id="designation" placeholder="Designation" class="form-control" value="{{ $user->designation }}">
                                <p id="designationError" class="text-danger"></p>
                            </div>
                            <div class="mb-4">
                                <label for="mobile" class="mb-2">Mobile*</label>
                                <input type="text" name="mobile" id="mobile" placeholder="Mobile" class="form-control" value="{{ $user->mobile }}">
                                <p id="mobileError" class="text-danger"></p>
                            </div>
                            <button type="submit"  class="btn btn-primary">Update</button>
                        </form>
                        <div class="mt-3"id="profileMessage"></div>
                    </div>
                </div>

                <div class="card border-0 shadow mb-4">
                    <div class="card-body p-4">
                        <h3 class="fs-4 mb-1">Change Password</h3>
                        <div class="mb-4">
                            <label for="" class="mb-2">Old Password*</label>
                            <input type="password" placeholder="Old Password" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">New Password*</label>
                            <input type="password" placeholder="New Password" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Confirm Password*</label>
                            <input type="password" placeholder="Confirm Password" class="form-control">
                        </div>
                    </div>
                    <div class="card-footer  p-4">
                        <button type="button" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $('#profileForm').on('submit', function(e) {
        e.preventDefault();
        $('#nameError').text('');
        $('#emailError').text('');
        $('#designationError').text('');
        $('#mobileError').text('');
        $.ajax({
            url: "{{ route('account.update.profile') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                if (response.status) {
                    location.reload();
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    if (errors.name) {
                        $('#nameError').text(errors.name[0]);
                    }
                    if (errors.email) {
                        $('#emailError').text(errors.email[0]);
                    }
                    if (errors.designation) {
                        $('#designationError').text(errors.designation[0]);
                    }
                    if (errors.mobile) {
                        $('#mobileError').text(errors.mobile[0]);
                    }
                }
            }
        });
    });
    setTimeout(() => {
        $('.flash-message').fadeOut('slow', function(){ $(this).remove(); });
    }, 2000);
});
</script>
@endsection
