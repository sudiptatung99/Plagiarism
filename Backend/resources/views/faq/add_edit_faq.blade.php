<x-app-layout>
    @section('title')
        {{ isset($faq) ? 'FAQ - Update' : 'FAQ - Create' }}
    @endsection
    <div class="row g-gs">
        <div class="px-0 col-xl-12">
            <div class="mb-3 card">
                <div class="card-body">
                    <div class="row justify-content-between">

                        <div class="d-flex" style="justify-content: space-between">
                            <h4 style="margin-bottom: 15px; font-size: 20px;">
                                {{ isset($faq) ? 'Update FAQ' : 'Add New FAQ' }}</h4>
                            <a href="{{ route('faq.index') }}" class="btn btn-primary">FAQ List</a>
                        </div>
                        <div class="m-auto col-9">
                            <form action="{{ isset($faq) ? route('faq.edit', encrypt($faq->id)) : route('faq.create') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mt-2 col-12">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <label for="exampleFormControlInputText1" class="mb-1">Question</label>
                                            <input type="text" name="question"
                                                value="{{ isset($faq) ? $faq->question : old('question') }}"
                                                class="form-control">
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
                                            <label for="exampleFormControlInputText1" class="mb-1">Answer</label>
                                            <textarea type="text" name="answer" class="form-control">{{ isset($faq) ? $faq->answer : old('answer') }}</textarea>
                                        </div>
                                    </div>
                                    <span class="text-danger">
                                        @error('tag')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                @if (isset($faq))
                                    <div class="save_btn">
                                        <button class="mt-4 btn btn-primary" type="submit">Update</button>
                                    </div>
                                @else
                                    <div class="save_btn">
                                        <button class="mt-4 btn btn-primary" type="submit">Save</button>
                                    </div>
                                @endif

                            </form>
                        </div>
                    </div>
                </div>
            </div>
</x-app-layout>
