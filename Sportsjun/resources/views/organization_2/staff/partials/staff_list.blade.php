<?php $is_widget = (isset($is_widget) && $is_widget) ? $is_widget : false; ?>
 <div class="row">
                <div class="col-md-12">
<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Role</th>
            <th>Added On</th>
            @if($is_owner)
            <th></th>
            @endif
        </tr>
        </thead>

        <tbody>
        @foreach($staffList as $staff)
   
            <tr class="record">
                <td>{{ $staff->name}}</td>
                <td>{{ $staff->roleForOrganization($id)->name }}</td>
                <td>{{ $staff->pivot->created_at->format('M d, Y') }}</td>
                @if($is_owner)
                    <td>
                        @if (!(isset($is_widget) && $is_widget))
                         <a href="javascript:void(0);" class="btn-close del_staff" staff_id='{{$staff->staff_id}}'> <i class="fa fa-times-circle fa-2x"></i> </a>
                        @endif
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table> {{-- /.table --}}
</div> {{-- /.table-responsive --}}
</div>
</div>
