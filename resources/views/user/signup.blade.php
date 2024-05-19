
@extends('layout.main')
@section('body')
    @auth
        {{-- {{route('blogRoute')}} --}}
    @else
        <div class="container-fluid row bg-dark min-vh-100">
            <div class="col-md-2 col-lg-3 d-none d-md-block"></div>
            <div class="col-md-8 col-lg-6">
                <div class="p-2 mt-4 me-auto d-inline-block position-relative">
                    <a href="{{route('loginRoute')}}" class="link-underline-opacity-0 link-underline-opacity-25-hover link-warning link-underlin-warning stretched-link">
                        <i class="fa-solid fa-circle-arrow-left"></i>
                        back to login
                    </a>
                </div>
                <hr class="text-secondary my-5">
                <form action="api/signup.php" method="post" class="need-validate" novalidate>
                    <div class="row mb-4">
                        <div class="col-sm-6 g-3">
                        <label for="fn" class="form-label text-warning">first name</label>
                        <input type="text" class="form-control" id="fn" name="fn" placeholder="ex:Ahmed" required>
                        <div class="valid-feedback">valid name.</div>
                        <div class="invalid-feedback">must type name here.</div>
                        </div>
                        <div class="col-sm-6 g-3">
                            <label for="ln" class="form-label text-warning">last name</label>
                            <input type="text" class="form-control" id="ln" name="ln" placeholder="ex:mohammed" required>
                            <div class="valid-feedback">valid name.</div>
                            <div class="invalid-feedback">must type name here.</div>
                            </div>
                    </div>
                    <div class="row mb-4">
                        <label for="em" class="form-label text-warning">email</label>
                        <div>
                        <input type="email" name="em" id="em" class="form-control" placeholder="example@domain.com" required>
                        <div class="valid-feedback">valid email.</div>
                        <div class="invalid-feedback">invalid email.</div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="pw" class="form-label text-warning">password</label>
                        <div class="input-group has-validation">
                            <input type="password" name="pw" id="pw" class="form-control" placeholder="A-Z,a-z,0-9,#$%^..." required>
                            <button class="btn btn-outline-info text-warning" id="pw-viewer">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <!-- <div class="valid-feedback">valid password.</div> -->
                            <div class="invalid-feedback">you must enter at least one of each uppercase character, lowercase character, number symbol character except &gt; &lt; &#40; &#41; &#123; &#125;.</div>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-end">
                        <button type="submit" class="btn btn-outline-primary text-uppercase">sign up</button>
                        <div class="vr text-secondary d-none d-sm-inline"></div>
                        <button type="reset" class="btn btn-outline-danger text-uppercase">reset</button>
                    </div>
                </form>
            </div>
            <div class="col-md-2 col-lg-3 d-none d-md-block"></div>
        </div>
    @endauth
@endsection