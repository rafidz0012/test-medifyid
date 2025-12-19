<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

function getData(){
    let table = $('#table').DataTable();
    table.clear().draw();

    $.get("{{ url('categories/search') }}", {
        kode: $('#filter-kode').val(),
        nama: $('#filter-nama').val()
    }, function(res){
        $.each(res.data, function(i, item){
            let action = `
                 <a href="{{ url('categories/view') }}/${item.id}"
                class="btn btn-outline-info btn-sm me-1"
                title="View">
                    <i class="bi bi-eye"></i>
                </a>

                <a href="{{ url('categories/form/edit') }}/${item.id}"
                class="btn btn-outline-warning btn-sm me-1"
                title="Edit">
                    <i class="bi bi-pencil-square"></i>
                </a>

                <a href="javascript:void(0)"
                data-id="${item.id}"
                class="btn btn-outline-danger btn-sm btn-delete"
                title="Delete">
                    <i class="bi bi-trash"></i>
                </a>
            `;

            table.row.add([
                item.kode,
                item.nama,
                action
            ]).draw(false);
        });
    });
}
$(document).on('click', '.btn-delete', function(){
    let id = $(this).data('id');
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = "{{ url('categories/delete') }}/" + id;
        }
    })
});
$(document).ready(function(){
    $('#table').DataTable();
    getData();

    $('.btn-get-data').click(function(){
        getData();
    });
});
</script>
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Success',
    text: "{{ session('success') }}",
    timer: 2000,
    showConfirmButton: false
});
</script>
@endif