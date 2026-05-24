@extends('superadmin.layouts.superadmin')
@section('page_title', 'All Categories')
@section('content')

<div class="sa-alert-success"></div>

<div class="sa-card">
    <div class="sa-card__header">
        <h5><i class="fa fa-tags" style="color:#c8a96e; margin-right:8px;"></i> All Categories</h5>
    </div>
    <div style="padding:0;">
        <table class="sa-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Slug</th>
                    <th>Products</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $key => $cat)
                    <tr id="cat-row-{{ $cat->id }}">
                        <td style="color:#999;">{{ $key + 1 }}</td>
                        <td style="font-weight:700;">{{ $cat->name }}</td>
                        <td>
                            <span style="background:#f0f0f0; color:#666; padding:3px 10px; font-size:11px; font-weight:700;">
                                {{ ucfirst($cat->gender) }}
                            </span>
                        </td>
                        <td style="font-size:12px; color:#999;">{{ $cat->slug }}</td>
                        <td>
                            <span style="background:#f0f8ff; color:#2980b9; padding:3px 10px; font-size:12px; font-weight:700;">
                                {{ $cat->products_count }}
                            </span>
                        </td>
                        <td>
                            <button class="sa-btn sa-btn-delete" onclick="deleteCat({{ $cat->id }})">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center; color:#999; padding:40px;">No categories found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function deleteCat(id) {
        if (confirm('Delete this category? Products inside may be affected.')) {
            $.ajax({
                type: 'DELETE',
                url: '/superadmin/categories/' + id,
                success: function(response) {
                    $('#cat-row-' + id).fadeOut(400, function() { $(this).remove(); });
                    showSuccess(response.success);
                }
            });
        }
    }
</script>
@endpush