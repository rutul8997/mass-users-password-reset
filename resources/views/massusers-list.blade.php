@extends(config('mass-users-password-reset.layout', 'layouts.app'))

@section(config('mass-users-password-reset.section', 'content'))
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Mass Password Reset</h3>
        </div>
        
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    @if(session('passwords'))
                        <div class="mt-3">
                            <strong>Generated Passwords:</strong>
                            <table class="table table-sm table-bordered mt-2">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>Password</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(session('passwords') as $userId => $password)
                                        <tr>
                                            <td>{{ $userId }}</td>
                                            <td><code>{{ $password }}</code></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <small class="text-muted">Please save these passwords securely. They will not be shown again.</small>
                        </div>
                    @endif
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form method="POST" action="{{ route('mass-users-password-reset.store') }}" id="password-reset-form">
                @csrf
                
                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Search Users</label>
                        <input type="text" 
                               name="search" 
                               class="form-control" 
                               placeholder="Search by name or email..."
                               value="{{ $filters['search'] ?? '' }}"
                               id="user-search">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Filter by Role (optional)</label>
                        <input type="text" 
                               name="role" 
                               class="form-control" 
                               placeholder="Enter role name..."
                               value="{{ $filters['role'] ?? '' }}"
                               id="role-filter">
                    </div>
                </div>

                <div class="mb-3">
                    <button type="button" class="btn btn-sm btn-secondary" onclick="filterUsers()">
                        Apply Filters
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="clearFilters()">
                        Clear Filters
                    </button>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Select Users</label>
                    @include('mass-users-password-reset::components.user-select', ['users' => $users])
                </div>

                <div class="mb-3">
                    <label class="form-label">Custom Password (Optional)</label>
                    <input type="text" 
                           name="custom_password" 
                           class="form-control" 
                           placeholder="Leave empty to generate random passwords"
                           minlength="8">
                    <small class="form-text text-muted">If provided, all selected users will receive this password. Minimum 8 characters.</small>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Notification Method</label>
                    <select name="notification_method" class="form-select" required>
                        <option value="email">Email users their new password</option>
                        <option value="show">Show password on screen (for manual distribution)</option>
                        <option value="force_change">Force password change on next login</option>
                    </select>
                    <small class="form-text text-muted">Choose how users will receive their new passwords.</small>
                </div>
                
                <button type="submit" class="btn btn-primary" id="submit-btn">
                    Reset Passwords for Selected Users
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.user-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    document.getElementById('password-reset-form').addEventListener('submit', function(e) {
        const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
        if (checkedBoxes.length === 0) {
            e.preventDefault();
            alert('Please select at least one user.');
            return false;
        }
        
        const submitBtn = document.getElementById('submit-btn');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Processing...';
    });

    function filterUsers() {
        const search = document.getElementById('user-search').value;
        const role = document.getElementById('role-filter').value;
        const params = new URLSearchParams();
        
        if (search) params.append('search', search);
        if (role) params.append('role', role);
        
        window.location.href = '{{ route("mass-users-password-reset.index") }}?' + params.toString();
    }

    function clearFilters() {
        document.getElementById('user-search').value = '';
        document.getElementById('role-filter').value = '';
        window.location.href = '{{ route("mass-users-password-reset.index") }}';
    }
</script>
@endpush
@endsection