@extends('front.layouts.app')

@section('main')
<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                @if (session('success'))
                <div class="alert alert-success flash-message">
                    {{ session('success') }}
                </div>
                @endif
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Register</h1>
                    <form action="" name="registrationForm" id="registrationForm">
                        <div class="mb-3">
                            <label for="" class="mb-2">Name*</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name">
                            <p></p>
                        </div>
                        <div class="mb-3">
                            <label for="" class="mb-2">Email*</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email">
                            <p></p>
                        </div>
                        <div class="mb-3">
                            <label for="" class="mb-2">Password*</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
                            <p></p>
                        </div>
                        <div class="mb-3">
                            <label for="" class="mb-2">Confirm Password*</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password">
                            <p></p>
                        </div>
                        <button class="btn btn-primary mt-2">Register</button>
                    </form>
                </div>
                <div class="mt-4 text-center">
                    <p>Have an account? <a href="{{ route('account.login') }}">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script>
    $("#registrationForm").submit(function(e) {
        e.preventDefault();
        $("input").removeClass("is-invalid");
        $("p").removeClass("invalid-feedback").html("");
        $.ajax({
            url: '{{ route("account.process.registration") }}',
            type: 'post',
            data: $("#registrationForm").serializeArray(),
            dataType: 'json',
            success: function(response) {
                if (response.status == false) {
                    $.each(response.errors, function(key, value) {
                        $("#" + key)
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(value);
                    });
                } else {
                    window.location.href = response.redirect; // redirect after success
                }
            }
        })
    });
    // Auto hide flash messages after 2 seconds
    setTimeout(function() {
        $(".flash-message").fadeOut("slow");
    }, 2000);
</script>
@endsection