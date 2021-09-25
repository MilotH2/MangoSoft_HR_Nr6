
<div class="card">
    <div class="header">
        <h2>Results searching for: <strong>{{$search}}</strong></h2>
    </div>
    <div class="body">
        <div class="table-responsive">
            <table class="table table-hover js-basic-example dataTable table-custom m-b-0">
                <thead>
                <tr>
                    <th>Name / Email</th>
                    <th>Mobile</th>
                    <th>Location</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($searchResults as $contact)
                    <tr>
                        <td>
                            <h6 class="mb-0">{!! $contact->firstname !!} {!! $contact->lastname !!}</h6>
                            <span>{!! $contact->email !!}</span>
                        </td>
                        <td><span class="badge badge-danger">{{$contact->mobile}}</span></td>
                        <td>{!! $contact->location !!}</td>
                        <td>
                            @if($contact->freelancer==1) <span class="badge badge-info">Freelancer</span>@endif
                            @if($contact->permanent==1) <span class="badge badge-primary">Permanent</span>@endif
                        </td>
                        <td>
                            <a href="/contact/update/{{$contact->id}}" type="button" class="btn btn-sm btn-outline-secondary" title="Edit"><i class="fa fa-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <br />
            {{$searchResults->links()}}
        </div>
    </div>
</div>
