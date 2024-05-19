@extends('layout.main')
@section('body')
    @auth
        {{-- {{route('blogRoute')}} --}}
    @else
        <div class="container-fluid min-vh-100 bg-warning d-flex justify-content-center align-items-center">
            <div class="border border-light rounded">
                <div class="card border border-light rounded p-2 border-w-1 max-w-100">
                    <div class="card-body">
                        <div class="card-title mb-2 fs-1">Log In</div>
                        <hr class="text-success mb-2">
                        <form action="{{route('authenticateRoute')}}" method="post" class="need-validate" novalidate>
                            @csrf
                            <label for="em" class="form-label text-dark">email:</label>
                            <input type="email" name="em" id="em" class="form-control mb-2" placeholder="example@domain.com" required>
                            <label for="pw" class="form-label text-dark">password:</label>
                            <div class="input-group">
                                <input type="password" name="pw" id="pw" class="form-control" placeholder="A-Z,a-z,0-9,#$%^..." required>
                                <button class="btn btn-outline-info text-dark" id="pw-viewer">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                            <div class="form-check mt-2 form-switch">
                                <input class="form-check-input" type="checkbox" name="remmber" value="" id="checkbox">
                                <label class="text-capitalize form-check-label" for="checkbox">
                                    remmber me.
                                </label>
                            </div>
                            <hr class="text-success mb-2">
                            <div class="card-text text-end mb-3">
                                New user: 
                                <a href="{{route('signupRoute')}}" class="link-primary link-underline-opacity-0 link-underline-opacity-10-hover link-offset-3">regester now</a>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-outline-primary">Log iIn</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endauth

@endsection