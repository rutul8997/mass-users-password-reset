@extends(config('mass-password-reset.layout', 'layouts.app'))

@section(config('mass-password-reset.section', 'content'))
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Mass Password Reset</h3>
        </div>
        
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    @if(session('new_password'))
                        <div class="mt-3">
                            <strong>Temporary Password:</strong> {{ session('new_password') }}
                        </div>
                    @endif
                </div>
            @endif
            
            <form method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Select Users</label>
                    @include('mass-password-reset::components.user-select')
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Notification Method</label>
                    <select name="notification_method" class="form-select" required>
                        <option value="email">Email users their new password</option>
                        <option value="show">Show password on screen (for manual distribution)</option>
                        <option value="force_change">Force password change on next login</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    Reset Passwords for Selected Users
                </button>
            </form>
        </div>
    </div>
</div>
@endsection