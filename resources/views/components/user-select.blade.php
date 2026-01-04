<div class="table-responsive">
    @if(isset($users) && $users->count() > 0)
        <table class="table table-hover">
            <thead>
                <tr>
                    <th width="50px">
                        <input type="checkbox" id="select-all" title="Select All">
                    </th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            <input type="checkbox" 
                                   name="user_ids[]" 
                                   value="{{ $user->id }}" 
                                   class="user-checkbox">
                        </td>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name ?? 'N/A' }}</td>
                        <td>{{ $user->email ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-muted">
            <small>Total users: {{ $users->count() }}</small>
        </div>
    @else
        <div class="alert alert-info">
            <p class="mb-0">No users found. 
                @if(isset($filters) && (!empty($filters['search']) || !empty($filters['role'])))
                    Try adjusting your filters.
                @else
                    There are no users in the system.
                @endif
            </p>
        </div>
    @endif
</div>