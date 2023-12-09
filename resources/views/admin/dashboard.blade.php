<!DOCTYPE html>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
    
    <style>
        .center{
            text-align: center;
        }
        .w100{
            width: 100%;
        }
    </style>
</head>

<body class="app">
    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="col-sm-12">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd" style="width: fit-content; float: right;">Add Data</button>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="center">Soal</th>
                                            <th class="center">Jawaban A</th>
                                            <th class="center">Jawaban B</th>
                                            <th class="center">Jawaban C</th>
                                            <th class="center">Jawaban D</th>
                                            <th class="center">Jawaban E</th>
                                            <th class="center">Jawaban Benar</th>
                                            <th class="center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($getDataQeustion as $val)
                                        <tr>
                                            <td>{{$val->QNS}}</td>
                                            <td>{{$val->A}}</td>
                                            <td>{{$val->B}}</td>
                                            <td>{{$val->C}}</td>
                                            <td>{{$val->D}}</td>
                                            <td>{{$val->E}}</td>
                                            <td class="center">{{$val->REAL_CHOICE}}</td>
                                            <td class="center">
                                                <button class="btn btn-primary editSoal" data-bs-toggle="modal" id="EditSoal" data-bs-target="#modalEdit" data-id="{{$val->ID_DATA}}">Edit Data</button>
                                                <button class="btn btn-danger" id="DeleteData" data-id="{{$val->ID_DATA}}">Delete Data</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Add -->
        <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{route('insertDataSoal')}}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Data Soal</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table">
                                <tr>
                                    <td><p>Soal</p></td>
                                    <td> : </td>
                                    <td><textarea name="question" type="text" class="w100 form-control"></textarea></td>
                                </tr>
                                <tr>
                                    <td><p>Jawaban A</p></td>
                                    <td> : </td>
                                    <td><input name="ans_a" type="text" class="w100 form-control"></td>
                                </tr>
                                <tr>
                                    <td><p>Jawaban B</p></td>
                                    <td> : </td>
                                    <td><input name="ans_b" type="text" class="w100 form-control"></td>
                                </tr>
                                <tr>
                                    <td><p>Jawaban C</p></td>
                                    <td> : </td>
                                    <td><input name="ans_c" type="text" class="w100 form-control"></td>
                                </tr>
                                <tr>
                                    <td><p>Jawaban D</p></td>
                                    <td> : </td>
                                    <td><input name="ans_d" type="text" class="w100 form-control"></td>
                                </tr>
                                <tr>
                                    <td><p>Jawaban E</p></td>
                                    <td> : </td>
                                    <td><input name="ans_e" type="text" class="w100 form-control"></td>
                                </tr>
                                <tr>
                                    <td><p>Jawaban Benar</p></td>
                                    <td> : </td>
                                    <td>
                                        <select class="form-control" name="jawaban_benar">
                                            <option disabled selected>-- Pilih Jawaban Benar --</option>
                                            <option>A</option>
                                            <option>B</option>
                                            <option>C</option>
                                            <option>D</option>
                                            <option>E</option>
                                        </select>
                                    </td>
                                </tr>
                                
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Modal Edit -->
        <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{route('editDataSoal')}}" method="post">
                    <div class="modal-content">
                        {{ csrf_field() }}
                        <input type="hidden" id="idData" name="id_data">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data Soal</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table">
                                <tr>
                                    <td><p>Soal</p></td>
                                    <td> : </td>
                                    <td><textarea name="Edt_qns" id="Edt_qns" type="text" class="w100 form-control"></textarea></td>
                                </tr>
                                <tr>
                                    <td><p>Jawaban A</p></td>
                                    <td> : </td>
                                    <td><input name="Edt_ans_a" id="Edt_ans_a" type="text" class="w100 form-control"></td>
                                </tr>
                                <tr>
                                    <td><p>Jawaban B</p></td>
                                    <td> : </td>
                                    <td><input name="Edt_ans_b" id="Edt_ans_b" type="text" class="w100 form-control"></td>
                                </tr>
                                <tr>
                                    <td><p>Jawaban C</p></td>
                                    <td> : </td>
                                    <td><input name="Edt_ans_c" id="Edt_ans_c" type="text" class="w100 form-control"></td>
                                </tr>
                                <tr>
                                    <td><p>Jawaban D</p></td>
                                    <td> : </td>
                                    <td><input name="Edt_ans_d" id="Edt_ans_d" type="text" class="w100 form-control"></td>
                                </tr>
                                <tr>
                                    <td><p>Jawaban E</p></td>
                                    <td> : </td>
                                    <td><input name="Edt_ans_e" id="Edt_ans_e" type="text" class="w100 form-control"></td>
                                </tr>
                                <tr>
                                    <td><p>Jawaban Benar</p></td>
                                    <td> : </td>
                                    <td>
                                        <select class="form-control" id="Edt_chs" name="Edt_jawaban_benar">
                                            <option disabled selected>-- Pilih Jawaban Benar --</option>
                                            <option>A</option>
                                            <option>B</option>
                                            <option>C</option>
                                            <option>D</option>
                                            <option>E</option>
                                        </select>
                                    </td>
                                </tr>
                                
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
                                

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script type="text/javascript">

            const dtModal = document.getElementById('modalEdit')
            dtModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget
                const recipient = button.getAttribute('data-bs-whatever')
                const modalTitle = dtModal.querySelector('.modal-title')
                const modalBodyInput = dtModal.querySelector('.modal-body input')
            })

            $(document).on("click", "#EditSoal", function(){
                var idData = $(this).data("id");
                $.ajax({
                    url : "{{url('getDataEditQns')}}" + '/' + idData,
                    type: "GET",
                    success: function(data){
                        $("#Edt_qns").val(data[0].QNS);
                        $("#Edt_ans_a").val(data[0].A);
                        $("#Edt_ans_b").val(data[0].B);
                        $("#Edt_ans_c").val(data[0].C);
                        $("#Edt_ans_d").val(data[0].D);
                        $("#Edt_ans_e").val(data[0].E);
                        $("#Edt_chs").val(data[0].REAL_CHOICE);
                        $("#idData").val(data[0].ID_DATA);
                    },  
                });
            })

            $(document).on("click", "#DeleteData", function(){

                var idData = $(this).data("id");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete this Data?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deteDataQuestions(idData)
                    }
                })
            })

            function deteDataQuestions(idData){
                
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url : "{{url('DeteleDataEditQns')}}" + '/' + idData,
                    type : 'POST',
                    success:function(response){
                        Swal.fire({
                        icon: 'success',
                        title : 'success',
                        text: 'Success Hapus Data',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(()=>{
                        location.reload()
                    },1000)
                    },
                    error : function(response){
                        Swal.fire({
                        icon: 'error',
                        title: 'error',
                        text : 'Gagal Hapus Data',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    },complete: function (data) {}
                    
                });
            }
        </script>
    </div>
</body>

</html>