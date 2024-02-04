<x-app-layout>
    @section('title') Activity - plan @endsection
    <style>
        #exampleModal2 .form-label {
            margin-right: 5px;
            width: 75px;
        }
    </style>

    <div class="col-xl-12 px-0">
        <div class="card">
            <div class="card-body">
                <div class="">
                    <div class="d-flex" style="justify-content: space-between;">
                        <h4 style="font-size: 20px;">Activity List</h4>
                    </div>
                    <div class="col-xl-12 mt-4">
                        <table id="myexpense" width="100%" class="datatable-init table"
                            data-nk-container="table-responsive table-border">
                            <thead>
                                <tr>
                                    <th><span class="overline-title">#</span></th>
                                    <th><span class="overline-title">Activity</span></th>
                                    <th><span class="overline-title">Date and Time</span></th>
                                </tr>
                            </thead>

                            <tbody>
                                @if (count($activity) > 0)
                                    @foreach ($activity as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td>{{ Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
