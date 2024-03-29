@extends('layouts.master')

@section('pageTitle', $pageTitle)

@section('breadcrumb')
<ol class="breadcrumb m-0">
    <li class="breadcrumb-item"><a href="javascript: void(0);">Cemara App</a></li>
<li class="breadcrumb-item active">Jo Selesai</li>
</ol>
@endsection

@section('content')
<div id="job-list">
    @if( (Auth::user()->role->id = 1) || (Auth::user()->role->id = 2) )
    <div class="text-center">
        <a href="{{ route('jo.cemara.create') }}" class="btn btn-primary"><i class="mdi mdi-plus-circle"></i> Buat JO baru</a>
    </div>
    @endif

    <div class="text-center mt-3 mb-3">
        <div class="btn-group" role="group">
            <a href="{{ route('job') }}" class="btn btn-sm btn-outline-dark"><i class="mdi mdi-checkbox-marked-circle-outline"></i>Semua JO</a>
            <a href="{{ route('job-waiting-list') }}" class="btn btn-sm btn-outline-danger"><i class="mdi mdi-checkbox-marked-circle-outline"></i> Jo Waiting List</a>
            <a href="{{ route('job-progress') }}" class="btn btn-sm btn-outline-success"><i class="mdi mdi-plus"></i> Jo Progress</a>
            <a href="{{ route('job-done') }}" class="btn btn-sm btn-primary"><i class="mdi mdi-checkbox-marked-circle-outline"></i>  Jo Selesai</a>
        </div>
    </div>

    @if ($message = Session::get('success'))
    <script>

    </script>
    @endif
    
    <div class="table-rep-plugin">
        <div class="table-responsive mb-0" data-pattern="priority-columns">
            <table id="table-cemara-inventory" class="table table-striped">
                <thead>
                <tr>
                    <th>Jo Kode</th>
                    <th data-priority="1">Nama</th>
                    <th data-priority="2">Tanggal Masuk</th>
                    <th data-priority="3">Deadline</th>
                    <th class="d-none" data-priority="4">Material</th>
                    <th class="d-none" data-priority="5">Finishing</th>
                    <th data-priority="6">Status JO</th>

                    @if(Auth::user()->role->id == 3)
                        <th data-priority="7">Action</th>
                    @endif
                    
                    @if(Auth::user()->role->id != 3)
                        <th data-priority="8">Edit</th>
                    @endif

                    <th data-priority="9">Buka</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<ul id="pagination" class="justify-content-center mt-3"></ul>

<!-- Create Item Modal -->
@include('jo.jo-ajax.create')

<!-- Edit Item Modal -->
@include('jo.jo-ajax.edit')

<!-- Progress JO -->
@include('jo.jo-ajax.update-status')

<!-- Done JO -->
@include('jo.jo-ajax.selesai')

<!-- Show Jo Item -->
@include('jo.jo-ajax.show')

<script>
var url = "{{ route('ajaxjo-done') }}";
var page = 1;
var current_page = 1;
var total_page = 0;
var is_ajax_fire = 0;



manageData();

function manageData() {
    $.ajax({
        dataType: 'json',
        url: url,
        data: {page:page}
    }).done(function(data){
        total_page = data.last_page;
        current_page = data.current_page;

        $('#pagination').twbsPagination({
            totalPages: total_page,
            visiblePages: current_page,

            onPageClick: function (event, pageL) {
                page = pageL;
                if(is_ajax_fire != 0){
                        getPageData();
                }
            }
        });

        manageRow(data.data);
        is_ajax_fire = 1;
    });
}

$.ajaxSetup({
    headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});

function getPageData() {
	$.ajax({
        dataType: 'json',
        url: url,
        data: {page:page}
	}).done(function(data){
		manageRow(data.data);
	});
}

function manageRow(data) {
    var	rows = '';
    console.log(data);
	$.each( data, function( key, value ) {
        rows = rows + '<tr data-joid='+ value.id+'>';
        
        // invisible rows
        rows = rows + '<td data-jo="jo_client_id" class="d-none">'+value.client.id+'</td>';
        rows = rows + '<td data-jo="jo_client_name" class="d-none">'+value.client.name+'</td>';
        rows = rows + '<td data-jo="jo_client_phone" class="d-none">'+value.client.phone+'</td>';
        rows = rows + '<td data-jo="jo_client_email" class="d-none">'+value.client.email+'</td>';
        rows = rows + '<td data-jo="jo_client_address" class="d-none">'+value.client.address+'</td>';

        rows = rows + '<td data-jo="jo_notes" class="d-none">'+value.notes+'</td>';

        rows = rows + '<td data-jo="jo_description" class="d-none">'+value.description+'</td>';

        rows = rows + '<td data-jo="jo_image" class="d-none">'+value.image_url+'</td>';

        rows = rows + '<td data-jo="jo_size" class="d-none">'+value.size+'</td>';

        rows = rows + '<td data-jo="jo_qty" class="d-none">'+value.qty+'</td>';
        
        rows = rows + '<td data-jo="jo_code"><span class="badge badge-primary badge-sn">'+value.jo_code+'</span></td>';

        rows = rows + '<td style="max-width:252px" data-jo="jo_title">'+value.title+'</td>';

        rows = rows + '<td data-jo="start_date" class="timestamp">'+value.start_date+'</td>';

        rows = rows + '<td data-jo="deadline" class="timestamp">'+value.deadline+'</td>';

        rows = rows + '<td data-jo="jo_material" class="d-none">'+value.material+'</td>';

        rows = rows + '<td data-jo="jo_finishing" class="d-none">'+value.finishing+'</td>';
        
        '@if(Auth::user()->role->id == 2 || Auth::user()->role->name == "Admin"))'
            if(value.jo_status.id == 2) {
                rows = rows + '<td data-jo="jo_status"><span data-id="'+value.id+'" jo-code="'+value.jo_code+'" class="not-allowed btn btn-sm text-white text-left" style="width:115px; background-color:'+value.jo_status.color+'"><i class="mdi mdi-trending-up"></i> '+value.jo_status.name+'</span></td>';
            } else if(value.jo_status.id == 1) {
                rows = rows + '<td data-jo="jo_status"><span data-id="'+value.id+'" jo-code="'+value.jo_code+'" class="not-allowed btn btn-sm text-white text-left" style="width:115px; background-color:'+value.jo_status.color+'"><i class="mdi mdi-clock-outline"></i> '+value.jo_status.name+'</span></td>';
            } else {
                rows = rows + '<td data-jo="jo_status"><span data-id="'+value.id+'" jo-code="'+value.jo_code+'" class="not-allowed btn btn-sm text-white text-left" style="width:115px; background-color:'+value.jo_status.color+'"><i class="mdi mdi-checkbox-marked-circle-outline"></i> '+value.jo_status.name+'</span></td>';
            }
        '@else'
            if(value.jo_status.id == 2) {
                rows = rows + '<td data-jo="jo_status"><span data-id="'+value.id+'" jo-code="'+value.jo_code+'" class="submit-done btn btn-sm text-white text-left" style="width:115px; background-color:'+value.jo_status.color+'"><i class="mdi mdi-trending-up"></i> '+value.jo_status.name+'</span></td>';
            } else if(value.jo_status.id == 1) {
                rows = rows + '<td data-jo="jo_status"><span data-id="'+value.id+'" jo-code="'+value.jo_code+'" class="submit-progress btn btn-sm text-white text-left" style="width:115px; background-color:'+value.jo_status.color+'"><i class="mdi mdi-clock-outline"></i> '+value.jo_status.name+'</span></td>';
            } else {
                rows = rows + '<td data-jo="jo_status"><span data-id="'+value.id+'" jo-code="'+value.jo_code+'" class="submit-waitinglist btn btn-sm text-white text-left" style="width:115px; background-color:'+value.jo_status.color+'"><i class="mdi mdi-checkbox-marked-circle-outline"></i> '+value.jo_status.name+'</span></td>';
            }
        '@endif'
        
        /** action button 
            Tombol untuk Waiting list ke Progress
            atau Progress ke Selesai */
        
        // Hanya tim Produksi yang boleh 
        '@if(Auth::user()->role->id == 3)'
            rows = rows + '<td data-id="'+value.id+'">';
            rows = rows + '<div class="btn-group" role="group">';
                if(value.jo_status.id == 2) {
                    rows = rows + '<button data-id="'+value.id+'" jo-code="'+value.jo_code+'" class="submit-waitinglist btn btn-sm btn-outline-danger edit-item"><i class="mdi mdi-clock-outline"></i></button>';
                    rows = rows + '<button data-id="'+value.id+'" jo-code="'+value.jo_code+'" class="submit-progress btn btn-sm btn-success show-item data-toggle="tooltip" data-placement="top" title="'+value.jo_status.name+'""><i class="mdi mdi-trending-up"></i></button> ';
                    rows = rows + '<button data-id="'+value.id+'" jo-code="'+value.jo_code+'" class="submit-done btn btn-sm btn-outline-primary show-item"><i class="mdi mdi-check"></i></button> ';
                } else if(value.jo_status.id == 1) {
                    rows = rows + '<button data-id="'+value.id+'" jo-code="'+value.jo_code+'" class="submit-waitinglist btn btn-sm btn-danger edit-item data-toggle="tooltip" data-placement="top" title="'+value.jo_status.name+'"><i class="mdi mdi-clock-outline"></i></button>';
                    rows = rows + '<button data-id="'+value.id+'" jo-code="'+value.jo_code+'" class="submit-progress btn btn-sm btn-outline-success show-item"><i class="mdi mdi-trending-up"></i></button> ';
                    rows = rows + '<button data-id="'+value.id+'" jo-code="'+value.jo_code+'" class="submit-done btn btn-sm btn-outline-primary show-item"><i class="mdi mdi-check"></i></button> ';
                } else {
                    rows = rows + '<button data-id="'+value.id+'" jo-code="'+value.jo_code+'" class="submit-waitinglist btn btn-sm btn-outline-danger edit-item"><i class="mdi mdi-clock-outline"></i></button>';
                    rows = rows + '<button data-id="'+value.id+'" jo-code="'+value.jo_code+'" class="submit-progress btn btn-sm btn-outline-success show-item"><i class="mdi mdi-trending-up"></i></button> ';
                    rows = rows + '<button data-id="'+value.id+'" jo-code="'+value.jo_code+'" class="submit-done btn btn-sm btn-primary show-item data-toggle="tooltip" data-placement="top" title="'+value.jo_status.name+'"><i class="mdi mdi-check"></i></button> ';
                }
            rows = rows + '</div>';
            rows = rows + '</td>';
        '@endif'
        
        '@if(Auth::user()->role->id != 3)'
            rows = rows + '<td data-id="'+value.id+'"><a class="btn btn-sm btn-jo-edit-custom btn-dark" href="{{ route('jo.cemara.index') }}/'+value.id+'/edit"><i class="mdi mdi-pencil"></i> Edit</a></td>';
        '@endif'

        rows = rows + '<td data-id="'+value.id+'">';
		rows = rows + '<div class="btn-group" role="group">';
            // rows = rows + '<button data-toggle="modal" data-target="#edit-item" class="btn btn-sm btn-outline-success edit-item"><i class="mdi mdi-pencil"></i></button>';
            rows = rows + '<button data-id="'+value.id+'" data-toggle="modal" data-target="#show-item" class="btn btn-sm btn-outline-primary show-item"><i class="mdi mdi-eye"></i> Buka</button> ';
        rows = rows + '</div>';
        rows = rows + '</td>';

        rows = rows + '</tr>';
	});

	$("tbody").html(rows);
}


$(".crud-submit").click(function(e){
    e.preventDefault();
    var form_action = $("#create-item").find("form").attr("action");
    var title = $("#create-item").find("input[name='title']").val();
    var details = $("#create-item").find("textarea[name='details']").val();

    $.ajax({
        dataType: 'json',
        type:'POST',
        url: form_action,
        data:{title:title, details:details}
    }).done(function(data){
        getPageData();
        $(".modal").modal('hide');
        toastr.success('Post Created Successfully.', 'Success Alert', {timeOut: 5000});
    });
});


$("body").on("click",".edit-item",function(){
    var id = $(this).parent("td").data('id');
    var title = $(this).parent("td").prev("td").prev("td").text();
    var details = $(this).parent("td").prev("td").text();

    $("#edit-item").find("input[name='title']").val(title);
    $("#edit-item").find("textarea[name='details']").val(details);
    $("#edit-item").find("form").attr("action",url + '/' + id);
});

$(".crud-submit-edit").click(function(e){
    e.preventDefault();

    var form_action = $("#edit-item").find("form").attr("action");
    var title = $("#edit-item").find("input[name='title']").val();
    var details = $("#edit-item").find("textarea[name='details']").val();

    $.ajax({
        dataType: 'json',
        type:'PUT',
        url: form_action,
        data:{title:title, details:details}
    }).done(function(data){
        getPageData();
        $(".modal").modal('hide');
        toastr.success('Post Updated Successfully.', 'Success Alert', {timeOut: 5000});
    });
});




// Show
$("body").on("click",".show-item",function(){
    var joID = $(this).attr('data-id');
    var tableTR = $('#table-cemara-inventory tbody tr[data-joid="'+joID+'"]');

    var joCode, joTitle, joStatus, joDescription, material, size, qty, startDate, deadline, finishing, joImage, clientName, clientId, clietPhone, clientEmail, clientAddress;

    joCode      = tableTR.find('td[data-jo="jo_code"]').text();
    joTitle     = tableTR.find('td[data-jo="jo_title"]').text();
    joStatus     = tableTR.find('td[data-jo="jo_status"]').text();
    joImage     = tableTR.find('td[data-jo="jo_image"]').text();
    startDate = tableTR.find('td[data-jo="start_date"]').text();
    deadline = tableTR.find('td[data-jo="deadline"]').text();
    size = tableTR.find('td[data-jo="jo_size"]').text();
    material = tableTR.find('td[data-jo="jo_material"]').text();
    qty = tableTR.find('td[data-jo="jo_qty"]').text();
    finishing = tableTR.find('td[data-jo="jo_finishing"]').text();
    joDescription = tableTR.find('td[data-jo="jo_description"]').text();
    notes = tableTR.find('td[data-jo="jo_notes"]').text();

    clientID = tableTR.find('td[data-jo="jo_client_id"]').text();
    clientName = tableTR.find('td[data-jo="jo_client_name"]').text();
    clientPhone = tableTR.find('td[data-jo="jo_client_phone"]').text();
    clientEmail = tableTR.find('td[data-jo="jo_client_email"]').text();
    clientAddress = tableTR.find('td[data-jo="jo_client_address"]').text();
    
    /* Letakan data di DOM */
    $("#jo_code").html(joCode);
    $("#jo-item").find("#jo_image").attr('src', '{{ asset('uploads/jo') }}/'+joImage+'');
    $("#jo-item").find("#jo_status").html(joStatus);
    $("#jo-item").find("#jo_title").html(joTitle);
    $("#jo-item").find("#jo_start_date").html(startDate);
    $("#jo-item").find("#jo_deadline").html(deadline);
    $("#jo-item").find("#jo_size").html(size);
    $("#jo-item").find("#jo_material").html(material);
    $("#jo-item").find("#jo_qty").html(qty);
    $("#jo-item").find("#jo_finishing").html(finishing);
    $("#jo-item").find("#jo_description").html(joDescription);
    $("#jo-item").find("#jo_notes").html(notes);

    $("#jo-item").find("#jo_client_name").html(clientName);
    $("#jo-item").find("#jo_client_phone").html(clientPhone);
    $("#jo-item").find("#jo_client_email").html(clientEmail);
    $("#jo-item").find("#jo_client_address").html(clientAddress);
    $("#jo-item").find("#url-client").attr('href', '{{ route("client.index") }}/'+clientID+'');
});




/** Jo ke Progress */
$("body").on("click",".submit-progress",function(e){
    e.preventDefault();
    var progresskanJoID = $(this).attr('data-id');
    var progresskanJoCode = $(this).attr('jo-code');
    $("#progresskanjo").find("form").attr("action", '{{ url("") }}/joajax' + '/' + progresskanJoID);
    var fromActionJoAjaxUpdate = $("#progresskanjo").find("form").attr("action");
        $.ajax({
            dataType: 'json',
            type:'PUT',
            url: fromActionJoAjaxUpdate,
            data:{jo_status_id : 2 } // 2 adalah progress
        }).done(function(data){
            getPageData();

            Swal.fire({
                icon: 'success',
                title: '<strong>Oke Sip lah!</strong>',
                html:
                    'Status JO <b class="badge badge-success">'+progresskanJoCode+'</b>' +
                    ' masuk ke Progress',
            });
        });
});



/* JO ke Selesai */
$("body").on("click",".submit-done",function(e){
    e.preventDefault();
    var progresskanJoID = $(this).attr('data-id');
    var progresskanJoCode = $(this).attr('jo-code');
    $("#progresskanjo").find("form").attr("action", '{{ url("") }}/joajax' + '/' + progresskanJoID);
    var fromActionJoAjaxUpdate = $("#progresskanjo").find("form").attr("action");
        $.ajax({
            dataType: 'json',
            type:'PUT',
            url: fromActionJoAjaxUpdate,
            data:{jo_status_id : 3 } // 3 adalah selesai
        }).done(function(data){
            getPageData();

            Swal.fire({
                icon: 'success',
                title: '<strong>Good Job!</strong>',
                html:
                    'Status JO <b class="badge badge-primary">'+progresskanJoCode+'</b>' +
                    ' Selesai',
            });
        });
});


/* 
Submit JO ke Waiting List 
(Balikan Statusnya ke waiting list) 

Ini bisa jadi karena kesalahan pencet sang opeator kemudian ingin mengembalikan ke waiting list lagi
*/
function submitWaitingList(joid) {
    var progresskanJoID = $(this).attr('data-id');
    var progresskanJoCode = $(this).attr('jo-code');
    $("#progresskanjo").find("form").attr("action", '{{ url("") }}/joajax' + '/' + joid);
    var fromActionJoAjaxUpdate = $("#progresskanjo").find("form").attr("action");
        $.ajax({
            dataType: 'json',
            type:'PUT',
            url: fromActionJoAjaxUpdate,
            data:{jo_status_id : 1 } // 1 adalah waiting list
        }).done(function(data){
            getPageData();
        });
}

$("body").on("click", ".submit-waitinglist", function(e){
    e.preventDefault();
    var progresskanJoID = $(this).attr('data-id');
    var progresskanJoCode = $(this).attr('jo-code');
    Swal.fire({
        title: '<strong>Yakin Mau Balikin ke Waiting List ?</strong>',
        html: 'Status JO <b class="badge badge-danger">'+progresskanJoCode+'</b>' +
            ' akan di kembalikan ke <strong>Waiting List</strong>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, saya Yakin!'
    }).then((result) => {
        if (result.value) {
            submitWaitingList(progresskanJoID);
            Swal.fire(
                'Yey.. Berhasil!',
                'Jo  kembali ke waiting lis.',
                'success'
            )
        }
    });
    playSound("coin");
});
</script>

<script>
function convertWaktu(timeHere){

    // Unixtimestamp
    var unixtimestamp = $('.timestamp').value;

    // Months array
    var months_arr = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Aug','Sep','Okt','Nov','Des'];

    // Convert timestamp to milliseconds
    var date = new Date(unixtimestamp*1000);

    // Year
    var year = date.getFullYear();

    // Month
    var month = months_arr[date.getMonth()];

    // Day
    var day = date.getDate();

    // Hours
    var hours = date.getHours();

    // Minutes
    var minutes = "0" + date.getMinutes();

    // Seconds
    var seconds = "0" + date.getSeconds();

    // Display date time in MM-dd-yyyy h:m:s format
    var timeHere = month+'-'+day+'-'+year+' '+hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);

    return timeHere;
}
</script>


<script src="{{ asset('assets/js/jquery.twbsPagination.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>

@endsection