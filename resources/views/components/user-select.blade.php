<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th width="50px"><input type="checkbox" id="select-all"></th>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td>
                        <input type="checkbox" name="user_ids[]" value="" class="user-checkbox">
                    </td>
                    <td>name1</td>
                    <td>email</td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="user_ids[]" value="" class="user-checkbox">
                    </td>
                    <td>name</td>
                    <td>email</td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="user_ids[]" value="" class="user-checkbox">
                    </td>
                    <td>name</td>
                    <td>email</td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="user_ids[]" value="" class="user-checkbox">
                    </td>
                    <td>name</td>
                    <td>email</td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="user_ids[]" value="" class="user-checkbox">
                    </td>
                    <td>name</td>
                    <td>email</td>
                </tr>

        </tbody>
    </table>
</div>

@push('scripts')
<script>
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.user-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>
@endpush