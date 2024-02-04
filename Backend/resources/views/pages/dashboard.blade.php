<x-app-layout>
    @section('title')
        Home
    @endsection
    <div class="row g-gs">
        <div class="px-5 col-xl-12 mt-5">
            <div class="mb-3 m-auto">
                <div class="row justify-content-between">
                    <div class="card text-center" style="width: 18rem;background: #DCFCE7;">
                        <div class="card-body">
                            <h5 class="card-title"><em class="icon ni ni-users-fill mx-2"></em>Total Users</h5>
                            <h6 class="card-subtitle mb-2 text-muted text-center mt-3">{{ $totalUser }}</h6>

                        </div>
                    </div>
                    <div class="card text-center" style="width: 18rem;background: #F3E8FF;" >
                        <div class="card-body">
                            <h5 class="card-title"><em class="icon ni ni-tags-fill mx-2"></em>Total Plans</h5>
                            <h6 class="card-subtitle mb-2 text-muted text-center mt-3">{{ $totalPlan }}</h6>

                        </div>
                    </div>
                    <div class="card text-center" style="width: 18rem;background: #FFE2E5;">
                        <div class="card-body" >
                            <h5 class="card-title"><em class="icon ni ni-file-docs mx-2 "></em>Total Uploaded Documents</h5>
                            <h6 class="card-subtitle mb-2 text-muted text-center mt-3">{{ $totalDocument }}</h6>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
