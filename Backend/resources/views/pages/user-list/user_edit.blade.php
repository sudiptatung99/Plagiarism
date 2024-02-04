<x-app-layout>
    @section('title') User - edit @endsection
    <div class="row g-gs">
        <div class="px-0 col-xl-12">
            <div class="mb-3 card">
                <div class="card-body">
                    <div class="row justify-content-between">

                        <div class="d-flex" style="justify-content: space-between">
                            <h4 style="margin-bottom: 15px; font-size: 20px;">Update User </h4>
                            <a href="{{ route('user.all') }}" class="btn btn-primary">User List</a>
                        </div>
                        <div class="m-auto col-9">
                            <form action="{{ route('user.update',encrypt($user->id)) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mt-2 col-12">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <label for="exampleFormControlInputText1" class="mb-1">First Name</label>
                                            <input type="text" name="firstname" value="{{ $user->firstname }}"
                                                class="form-control" >
                                        </div>
                                    </div>
                                    <span class="text-danger">
                                        @error('firstname')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mt-2 col-12">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <label for="exampleFormControlInputText1" class="mb-1">Last Name</label>
                                            <input type="text" name="lastname" value="{{ $user->lastname }}"
                                                class="form-control" >
                                        </div>
                                    </div>
                                    <span class="text-danger">
                                        @error('lastname')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mt-2 col-12">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <label for="exampleFormControlInputText1" class="mb-1">Email</label>
                                            <input type="text" name="email" value="{{ $user->email }}"
                                                class="form-control" >
                                        </div>
                                    </div>
                                    <span class="text-danger">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mt-2 col-12">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <label for="exampleFormControlInputText1" class="mb-1">Phone Number</label>
                                            <input type="text" name="phone_number" value="{{ $user->phone_number }}"
                                                class="form-control" >
                                        </div>
                                    </div>
                                    <span class="text-danger">
                                        @error('phone_number')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mt-2 col-12">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <label for="exampleFormControlInputText1" class="mb-1">Company Name</label>
                                            <input type="text" name="company_name" value="{{ $user->company_name }}"
                                                class="form-control" >
                                        </div>
                                    </div>
                                    <span class="text-danger">
                                        @error('company_name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mt-2 col-12">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <label for="exampleFormControlInputText1" class="mb-1">Remain Documents </label>
                                            <input type="text" name="remain_doc" value="{{ $user->remain_doc }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <span class="text-danger">
                                        @error('remain_doc')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="save_btn">
                                    <button class="mt-4 btn btn-primary" type="submit">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</x-app-layout>
