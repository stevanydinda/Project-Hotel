<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon"
        href=""
        type="image/x-icon">
    <title>ASTON</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Optional: Add a simple background color to the body for a better look */
        body {
            background-color: #f8f9fa; /* Light gray background */
        }
        /* Style to vertically center the content */
        .full-height {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    {{-- Use a container to center and constrain the content --}}
    <div class="container full-height">
        <div class="row justify-content-center w-100">
            {{-- Use a slightly wider column for Sign Up since it has more fields --}}
            <div class="col-md-8 col-lg-6 col-xl-5">

                {{-- Card for the Sign Up Form --}}
                <div class="card shadow-4-strong">
                    <div class="card-body p-5">
                        <h2 class="card-title text-center mb-4 fw-bold text-dark">Create Your ASTON Account</h2>

                        <form method="POST" action="{{ route('signup.register') }}">
                            {{-- - csrf: generate token yg menjadi syarat bagi FE mengirim data ke server/backend - --}}
                            @csrf

                            <div class="row mb-4">
                                <div class="col">
                                    {{-- First Name --}}
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="text" id="form3Example1"
                                            class="form-control @error('first_name') is-invalid @enderror" name= "first_name"
                                            value="{{ old('first_name') }}" required />
                                        <label class="form-label" for="form3Example1">First name</label>
                                    </div>
                                    {{-- memunculkan tulisan error validasi @error('name_input') --}}
                                    @error('first_name')
                                        <p class="text-danger small mt-n3 mb-3">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col">
                                    {{-- Last Name --}}
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="text" id="form3Example2"
                                            class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                            value="{{ old('last_name') }}" required />
                                        <label class="form-label" for="form3Example2">Last name</label>
                                    </div>
                                    @error('last_name')
                                        <p class="text-danger small mt-n3 mb-3">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="email" id="form3Example3" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" />
                                <label class="form-label" for="form3Example3">Email address</label>
                            </div>
                            @error('email')
                                <p class="text-danger small mt-n3 mb-3">{{ $message }}</p>
                            @enderror

                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="password" id="form3Example4" class="form-control @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="new-password" />
                                <label class="form-label" for="form3Example4">Password</label>
                            </div>
                            @error('password')
                                <p class="text-danger small mt-n3 mb-3">{{ $message }}</p>
                            @enderror

                            {{-- Submit Button --}}
                            <button data-mdb-input-init type="submit" class="btn btn-warning btn-lg btn-block shadow-3-strong mt-2">Sign Up</button>

                            <div class="text-center mt-4">
                                <p class="text-muted mb-1">Sudah punya akun? <a href="{{ route('login.auth') }}" class="text-decoration-none">Login di sini</a></p>
                                <a href="{{ route('home') }}" class="text-decoration-none text-muted small">← Kembali ke Halaman Utama</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.umd.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
        integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous">
    </script>
</body>

</html>
