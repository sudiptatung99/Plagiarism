<x-app-layout>
    <div class="row g-gs">
        <div class="col-xl-12 px-0">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row justify-content-between">

                        <div class="d-flex" style="justify-content: space-between">
                            <h4 style="margin-bottom: 15px; font-size: 20px;margin:0 auto">Update Password</h4>
                        </div>
                        <div class="col-9 m-auto">
                            <form action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="col-12 mt-2">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <label for="exampleFormControlInputText1" class="mb-1"> Current
                                                Password</label>
                                            <input type="password" required name="current_password"
                                                value="{{ old('current_password') }}" class="form-control">
                                        </div>
                                    </div>
                                    <span class="text-danger">
                                        @error('current_password')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="col-12 mt-2">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <label for="exampleFormControlInputText1" class="mb-1"> Password</label>
                                            <input type="password" required name="password"
                                                value="{{ old('password') }}" class="form-control">
                                        </div>
                                    </div>
                                    <span class="text-danger">
                                        @error('password')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="col-12 mt-2">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <label for="exampleFormControlInputText1" class="mb-1">Confirm
                                                Password</label>
                                            <input type="password" required name="password_confirmation"
                                                value="{{ old('password_confirmation') }}" class="form-control">
                                        </div>
                                    </div>
                                    <span class="text-danger">
                                        @error('password_confirmation')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="save_btn">
                                    <button class="btn btn-primary mt-4" type="submit">Change Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</x-app-layout>
