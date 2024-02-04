<x-app-layout>
    @section('title') plan - create @endsection
    <div class="row g-gs">
        <div class="px-0 col-xl-12">
            <div class="mb-3 card">
                <div class="card-body">
                    <div class="row justify-content-between">

                        <div class="d-flex" style="justify-content: space-between">
                            <h4 style="margin-bottom: 15px; font-size: 20px;">Add New Plan </h4>
                            <a href="{{ route('plan.index') }}" class="btn btn-primary">All Plan List</a>
                        </div>
                        <div class="m-auto col-9">
                            <form action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mt-2 col-12">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <label for="exampleFormControlInputText1" class="mb-1">Plan Name</label>
                                            <input type="text" name="name" value="{{ old('name') }}"
                                                class="form-control" placeholder="Enter Plan Name">
                                        </div>
                                    </div>
                                    <span class="text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mt-2 col-12">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <label for="exampleFormControlInputText1" class="mb-1">Plan Tag</label>
                                            <input type="text" name="tag" value="{{ old('tag') }}"
                                                class="form-control" placeholder="Enter Plan Tag">
                                        </div>
                                    </div>
                                    <span class="text-danger">
                                        @error('tag')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mt-2 col-12">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <label for="exampleFormControlInputText1" class="mb-1">Plan For</label>
                                            <input type="text" name="for" value="{{ old('for') }}"
                                                class="form-control" placeholder="Enter Plan For">
                                        </div>
                                    </div>
                                    <span class="text-danger">
                                        @error('for')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mt-2 col-12">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <label for="exampleFormControlInputText1" class="mb-1">Plan Price</label>
                                            <input type="text" name="price" value="{{ old('price') }}"
                                                class="form-control" placeholder="Enter Plan Price">
                                        </div>
                                    </div>
                                    <span class="text-danger">
                                        @error('price')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mt-2 col-12">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <label for="exampleFormControlInputText1" class="mb-1">Number Of Documents </label>
                                            <input type="text" name="letter_count" value="{{ old('letter_count') }}"
                                                class="form-control" placeholder="Enter Number Of Letter">
                                        </div>
                                    </div>
                                    <span class="text-danger">
                                        @error('letter_count')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mt-2 col-12">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <label for="exampleFormControlInputText1" class="mb-1">Plan Detail</label>
                                            <textarea name="detail" class="form-control">{{ old('detail') }}</textarea>
                                        </div>
                                    </div>
                                    <span class="text-danger">
                                        @error('detail')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="save_btn">
                                    <button class="mt-4 btn btn-primary" type="submit">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</x-app-layout>
