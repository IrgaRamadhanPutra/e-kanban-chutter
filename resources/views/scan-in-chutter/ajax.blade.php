<script>
    $(document).ready(function() {
        // Deklarasi Variable
        var input1 = $("#input1");
        var input2 = $("#input2");
        var reset = $("#reset");

        // var table = $("#tblChutter").DataTable();
        var table = $('#tblChutter').DataTable({
            "paging": false, // Nonaktifkan paging
            "searching": false,
            "ordering": false,
            "lengthChange": false,
            "responsive": true,
            "drawCallback": function(settings) {
                // Tambahkan style border biru pada seluruh tabel
                $('#tblChutter').css({
                    "border": "1px solid blue" // Border style
                });
                // Tambahkan style border biru pada sel header
                $('#tblChutter thead th').css({
                    "border": "1px solid blue" // Border style
                });
                // Tambahkan style border biru pada sel data
                $('#tblChutter tbody td').css({
                    "border": "1px solid blue" // Border style
                });
            }
        });

        input1.focus();
        // Input field 1
        input1.on("keydown", function(e) {
            if (event.key === "Enter") {
                // checkInput();
                if (input1.val() != "") {
                    var value = input1.val();
                    // var spliteData1 = value.split(',');
                    // jika berisi koma
                    if (value.includes(',')) {
                        var spliteData1 = value.split(',');
                        // inputan koma 7
                        if (spliteData1.length === 7) {
                            if (spliteData1.length > 1) {
                                // console.log(spliteData1);
                                var getItemcodelocal = spliteData1[3];
                                // console.log(getItemcodelocal);
                                $("#itemcodeLokal").val(getItemcodelocal);
                                // input1.attr('readonly', true);
                                var itemLokal = $('#itemcodeLokal').val();
                                // console.log(itemLokal);
                                // alert(itemLokal);
                                addDataToTable(spliteData1);
                                $('#input1').focus();
                            } else {
                                input1.val("");

                                $('#input1').focus();
                            }

                            // inputan koma 8
                        } else if (spliteData1.length === 8) {
                            if (spliteData1.length > 1) {
                                var getItemcodelocal = spliteData1[4];
                                // console.log(spliteData1);
                                // console.log(getItemcodelocal);
                                $("#itemcodeLokal").val(getItemcodelocal);
                                var itemLokal = $('#itemcodeLokal').val();
                                addDataToTable2(spliteData1);
                            } else {
                                input1.val("");
                                $('#input1').focus();
                            }
                        } else {
                            // Jika jumlah koma tidak sesuai, berikan pesan atau tindakan yang sesuai
                            // alert("Jumlah koma tidak sesuai. Input tidak dapat diproses.");
                            input1.val("");
                            $('#input1').focus();
                        }
                    } else {
                        // Jika tidak ada koma dalam input
                        // alert("Input tidak mengandung koma. Input tidak dapat diproses.");
                        input1.val("");
                        $('#input1').focus();
                    }

                } else {
                    // reset.removeClass("d-none")
                    // input1.attr("readonly", true);
                }
                return false;
            }
        });

        // funtion add to tabel to koma 7
        // validasi include max only
        function addDataToTable(spliteData1) {
            // console.log(spliteData1);
            var getKanban = spliteData1[0];
            var getSquence = spliteData1[1];
            var getPartno = spliteData1[2];
            var getItemcode = spliteData1[3];
            var getQty = spliteData1[4];
            var getCustcode = spliteData1[5];

            // Menampilkan loading spinner
            function showLoading() {
                $('.loading-spinner-container').show();
            }

            // Menyembunyikan loading spinner
            function hideLoading() {
                $('.loading-spinner-container').hide();
            }

            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });

            // $.ajax({
            //     url: "{{ route('validasi_access_account') }}",
            //     type: "get",
            //     data: {
            //         getCustcode
            //     },
            //     dataType: 'json',
            //     beforeSend: function() {
            //         showLoading(); // Memanggil fungsi showLoading sebelum request
            //     },
            //     success: function(response) {
            //         hideLoading(); // Hide loading spinner after the request

            //         // Check the message in the response
            //         if (response.message === "success") {
            //             // Handle the success case
            //             // alert("Success");
            //             allValidasi(getItemcode, getSquence, getPartno, getItemcode, getQty,
            //                 getKanban);
            //             // Additional actions for success
            //         } else if (response.message === "error") {
            //             // Handle the error case
            //             // console.error("Error:", response.detail);
            //             // Additional actions for error
            //             hideLoading();
            //             // alert('data tidak ada');
            //             if ("vibrate" in navigator) {
            //                 navigator.vibrate([1000]);
            //             }
            //             document.getElementById('Audioerror').play();
            //             swal.fire({
            //                 icon: 'error',
            //                 title: 'User Not Found',
            //                 text: response.detail,
            //                 showConfirmButton: true,
            //                 // timer: 2000, // Menampilkan selama 2 detik
            //             });
            //             input1.val("");
            //             input1.focus();
            //         }
            //     },
            // });
            allValidasi(getItemcode, getSquence, getPartno, getItemcode, getQty,
            getKanban);
        }

        // add to table for koma 8 format
        // validasi include max only
        function addDataToTable2(spliteData1) {

            var getKanban = spliteData1[1];
            var getSquence = spliteData1[2];
            var getPartno = spliteData1[3];
            var getItemcode = spliteData1[4];
            var getQty = spliteData1[5];
            var getCustcode = spliteData1[6];
            // console.log(spliteData1);
            // console.log(getSquence);
            // console.log(getPartno);
            // console.log(getItemcode);
            function showLoading() {
                $('.loading-spinner-container').show();
            }

            // Menyembunyikan loading spinner
            function hideLoading() {
                $('.loading-spinner-container').hide();
            }

            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });

            // $.ajax({
            //     url: "{{ route('validasi_access_account2') }}",
            //     type: "get",
            //     data: {
            //         getCustcode
            //     },
            //     dataType: 'json',
            //     beforeSend: function() {
            //         showLoading(); // Memanggil fungsi showLoading sebelum request
            //     },
            //     success: function(response) {
            //         hideLoading(); // Hide loading spinner after the request

            //         // Check the message in the response
            //         if (response.message === "success") {
            //             // Handle the success case
            //             // alert("Success");
            //             allValidasi(getItemcode, getSquence, getPartno, getItemcode, getQty,
            //                 getKanban);
            //             // Additional actions for success
            //         } else if (response.message === "error") {
            //             // Handle the error case
            //             // console.error("Error:", response.detail);
            //             // Additional actions for error
            //             hideLoading();
            //             // alert('data tidak ada');
            //             if ("vibrate" in navigator) {
            //                 navigator.vibrate([1000]);
            //             }
            //             document.getElementById('Audioerror').play();
            //             swal.fire({
            //                 icon: 'error',
            //                 title: 'User Not Found',
            //                 text: response.detail,
            //                 showConfirmButton: true,
            //                 // timer: 2000, // Menampilkan selama 2 detik
            //             });
            //             input1.val("");
            //             input1.focus();
            //         }
            //     },
            // });
            allValidasi(getItemcode, getSquence, getPartno, getItemcode, getQty,
            getKanban);


        }

        function allValidasi(getItemcode, getSquence, getPartno, getItemcode, getQty, getKanban) {
            // alert('masuk all validasi');
            function showLoading() {
                $('.loading-spinner-container').show();
            }

            function hideLoading() {
                $('.loading-spinner-container').hide();
            }

            // validasi eknban chuter fg
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('validasi_fgout1') }}",
                type: "get",
                data: {
                    getKanban:getKanban,
                    getItemcode: getItemcode,
                    getSquence: getSquence
                },
                dataType: 'json',
                beforeSend: function() {
                    showLoading();
                },
                success: function(data) {
                    if (data == "") {
                        validasiFgIn(getItemcode, getSquence,getKanban);
                    } else {
                        // alert('data sudah ada fg out');
                        hideLoading();
                        if ("vibrate" in navigator) {
                            navigator.vibrate([1000]);
                        }
                        document.getElementById('Audioerror').play();
                        swal.fire({
                            icon: 'error',
                            title: 'DATA SUDAH DI CHUTER OUT',
                            text: 'Data Already Exist',
                            showConfirmButton: true,
                        });
                        input1.val("");
                        input1.focus();
                    }
                }
            });


            function validasiFgIn(getItemcode, getSquence,getKanban) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('validasi_fgin1') }}",
                    type: "get",
                    data: {
                        getKanban:getKanban,
                        getItemcode: getItemcode,
                        getSquence: getSquence
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.message === "data_not") {
                            hideLoading();
                            // alert('data tidak ada');
                            if ("vibrate" in navigator) {
                                navigator.vibrate([1000]);
                            }
                            document.getElementById('Audioerror').play();
                            swal.fire({
                                icon: 'error',
                                title: 'Data Not Found',
                                text: 'Data Belum di Scan In Fg',
                                showConfirmButton: true,
                            });
                            input1.val("");
                            input1.focus();
                        } else if (data.message == "null") {
                            // var table = $("#tblChutter").DataTable();
                            // var qty = 0;
                            // var getQtyInt = parseInt(getQty, 10);
                            // if (table.data().count() !== 0) {
                            //     table.rows().every(function() {
                            //         var rowData = this.data();
                            //         var qtyValue = parseInt($(rowData[3]).val(), 10);
                            //         qty += isNaN(qtyValue) ? 0 : qtyValue;
                            //     });
                            // }
                            // var resultQty = getQtyInt + qty;
                            // validasiMaxChuter(getItemcode, resultQty);
                            validasiChuteraddress(getItemcode);
                        } else if (data.message == "not_null") {
                            // alert('cutter address suda ada');
                            hideLoading();
                            if ("vibrate" in navigator) {
                                navigator.vibrate([1000]);
                            }
                            document.getElementById('Audioerror').play();
                            swal.fire({
                                icon: 'error',
                                title: 'Data Sudah Di Scan Chutter',
                                text: 'Data Already Exist',
                                showConfirmButton: true,
                            });
                            input1.val("");
                            input1.focus();
                        }
                    }
                });
            }

            function validasiChuteraddress(getItemcode) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('validasi_chuteraddress') }}",
                    type: "get",
                    data: {
                        getItemcode: getItemcode,
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.message ===  "not_null") {
                            // alert('untk validasi max');
                            // validasi kanban over flow by date print  kanban
                            hideLoading();

                            var table = $("#tblChutter").DataTable();
                            var qty = 0;
                            var getQtyInt = parseInt(getQty, 10);
                            if (table.data().count() !== 0) {
                                table.rows().every(function() {
                                    var rowData = this.data();
                                    var qtyValue = parseInt($(rowData[3]).val(), 10);
                                    qty += isNaN(qtyValue) ? 0 : qtyValue;
                                });
                            }
                            var resultQty = getQtyInt + qty;
                            validasiMaxChuter(getItemcode, resultQty);
                        }else if (data.message ==="data_null") {
                            hideLoading();
                            if ("vibrate" in navigator) {
                                navigator.vibrate([1000]);
                            }
                            document.getElementById('Audioerror').play();
                            swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Master Min Max Not Found',
                                showConfirmButton: true,
                            });
                            input1.val("");
                            input1.focus();
                        }
                    },
                });
            }
            function validasiMaxChuter(getItemcode, resultQty) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('validasi_max_chuter') }}",
                    type: "get",
                    data: {
                        getItemcode: getItemcode,
                        resultQty: resultQty
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.message ===
                            "success") {
                            // validasi kanban over flow by date print  kanban
                            hideLoading
                                ();
                            var table =
                                $(
                                    "#tblChutter"
                                )
                                .DataTable();
                            if (table
                                .data()
                                .count() ===
                                0
                            ) {
                                // Tabel kosong, langsung tambahkan data
                                var t =
                                    $(
                                        '#tblChutter'
                                    )
                                    .DataTable();
                                var counter =
                                    t
                                    .rows()
                                    .count();
                                var jml_row =
                                    Number(
                                        counter
                                    ) +
                                    1;
                                var Itemcode =
                                    "Itemcode" +
                                    jml_row;
                                var part_no =
                                    "part_no" +
                                    jml_row;
                                var Squence =
                                    "Squence" +
                                    jml_row;
                                var Qty =
                                    "Qty" +
                                    jml_row;
                                var Kanban_no =
                                    "Kanban_no" +
                                    jml_row;
                                t.row
                                    .add(
                                        [

                                            '<input type="text" class="text-center" id="' +
                                            Itemcode +
                                            '" name="Itemcode[]" value="' +
                                            getItemcode +
                                            '" readonly>',
                                            '<input type="text" class="text-center" id="' +
                                            part_no +
                                            '" name="part_no[]" value="' +
                                            getPartno +
                                            '" readonly>',

                                            '<input type="text" class="text-center" id="' +
                                            Squence +
                                            '" name="Squence[]" value="' +
                                            getSquence +
                                            '" readonly>',
                                            '<input type="text" class="text-center" id="' +
                                            Qty +
                                            '" name="Qty[]" value="' +
                                            getQty +
                                            '" readonly>',
                                            '<input type="text" class="text-center" name="Kanban_no[]" id="' +
                                            Kanban_no +
                                            '" value="' +
                                            getKanban +
                                            '">', // Tambahkan value dengan getKanban
                                        ]
                                    )
                                    .draw();
                                input1
                                    .val(
                                        ""
                                    );
                                $('#input1')
                                    .focus();
                            } else {
                                // validasi data kosong
                                // Tabel tidak kosong, periksa apakah Part No sudah ada dalam tabel
                                var partNoExists =
                                    false;
                                table
                                    .rows()
                                    .every(
                                        function() {
                                            var rowData =
                                                this
                                                .data();

                                            var existingPartNo =
                                                rowData[
                                                    1
                                                ];
                                            var valuePartno =
                                                $(
                                                    existingPartNo
                                                )
                                                .val();
                                            if (valuePartno ==
                                                getPartno
                                            ) {
                                                partNoExists
                                                    =
                                                    true;
                                                return false; // Keluar dari perulangan jika sudah ditemukan Part No yang cocok
                                            }
                                        }
                                    );
                                // jika data nya sama
                                if (
                                    partNoExists
                                ) {
                                    var sq =
                                        true;
                                    table
                                        .rows()
                                        .every(
                                            function() {
                                                var rowData =
                                                    this
                                                    .data();
                                                // console.log(rowData);
                                                var exitingSq =
                                                    rowData[
                                                        2
                                                    ];
                                                // console.log(exitingSq);
                                                var valueSq =
                                                    $(
                                                        exitingSq
                                                    )
                                                    .val();
                                                // console.log(valueSq);
                                                // console.log(getSquence);
                                                if (valueSq ==
                                                    getSquence
                                                ) {
                                                    sq =
                                                        false;
                                                }
                                            }
                                        );
                                    // jika squence nya tidak sama
                                    // console.log(sq);
                                    if (
                                        sq
                                    ) {
                                        // alert('Squence tidak sama');
                                        var table =
                                            $(
                                                "#tblChutter"
                                            )
                                            .DataTable();

                                        // Mengambil data dari seluruh baris dalam tabel
                                        var data =
                                            table
                                            .rows()
                                            .data();
                                        var colKanban =
                                            "";
                                        var colSeq =
                                            "";

                                        if (data
                                            .length >
                                            0
                                        ) {
                                            var rowData =
                                                data[
                                                    data
                                                    .length -
                                                    1
                                                ]; // Mendapatkan data dari baris terakhir
                                            colKanban
                                                =
                                                $(rowData[
                                                    4
                                                ])
                                                .val();
                                            colSeq
                                                =
                                                $(rowData[
                                                    2
                                                ])
                                                .val(); // Mengambil nilai dari elemen pertama
                                        }
                                        //  validasi kanban harus sama pada tabel dan kolom
                                        // DI SINI VALIDASI DATE
                                        // validasi_date
                                        validasiDate(colKanban, colSeq, getItemcode, getSquence);
                                        // jika squence nya sama
                                    } else {
                                        // alert('error squence sama');
                                        // notif bergetar
                                        hideLoading
                                            ();
                                        if ("vibrate" in
                                            navigator
                                        ) {
                                            navigator
                                                .vibrate(
                                                    [
                                                        1000
                                                    ]
                                                );
                                        }
                                        document
                                            .getElementById(
                                                'Audioerror'
                                            )
                                            .play();
                                        swal.fire({
                                            icon: 'error',
                                            title: 'Squence Tidak Boleh Sama',
                                            text: 'Squence Sudah di Scan',
                                            showConfirmButton: true, // Menampilkan tombol OK
                                            // timer: 2000, // Menampilkan selama 2 detik
                                        });
                                        input1
                                            .val(
                                                ""
                                            );

                                        $('#input1')
                                            .focus();
                                    }



                                } else {
                                    // jika part no nya tidak sama
                                    hideLoading
                                        ();
                                    // alert('partno tidak sama');
                                    input1
                                        .val(
                                            ""
                                        );

                                    $('#input1')
                                        .focus();
                                    if ("vibrate" in
                                        navigator
                                    ) {
                                        navigator
                                            .vibrate(
                                                [
                                                    1000
                                                ]
                                            );
                                    }
                                    document
                                        .getElementById(
                                            'Audioerror'
                                        )
                                        .play();
                                    swal.fire({
                                        icon: 'error',
                                        title: 'Part No Tidak Sama',
                                        text: 'Part No Tidak Sama',
                                        showConfirmButton: true, // Menampilkan tombol OK
                                    });
                                }

                            }
                        } else if (data.message ===
                            "error") {
                            hideLoading();
                            if ("vibrate" in
                                navigator) {
                                navigator.vibrate([
                                    1000
                                ]);
                            }
                            document.getElementById(
                                    'Audioerror')
                                .play();
                            swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Qty Melebihi Max',
                                showConfirmButton: true, // Menampilkan tombol OK
                            });
                            input1.val("");
                            input1.focus();
                        }
                    },
                });
            }

            function validasiDate(colKanban, colSeq, getItemcode, getSquence) {

                $.ajax({
                    url: "{{ route('validasi_date') }}",
                    type: "get",
                    data: {
                        colKanban: colKanban,
                        colSeq: colSeq,
                        getKanban: getKanban,
                        getSquence: getSquence

                    }, // Data yang akan dikirim ke server
                    dataType: 'json',

                    success: function(
                        response
                    ) {
                        if (response
                            .message ===
                            "success"
                        ) {
                            var t =
                                $(
                                    '#tblChutter'
                                )
                                .DataTable();
                            var counter =
                                t
                                .rows()
                                .count();
                            var jml_row =
                                Number(
                                    counter
                                ) +
                                1;
                            var Itemcode =
                                "Itemcode" +
                                jml_row;
                            var part_no =
                                "part_no" +
                                jml_row;
                            var Squence =
                                "Squence" +
                                jml_row;
                            var Kanban_no =
                                "Kanban_no" +
                                jml_row;
                            var Qty =
                                "Qty" +
                                jml_row;
                            t.row
                                .add(
                                    [

                                        '<input type="text" class="text-center" id="' +
                                        Itemcode +
                                        '" name="Itemcode[]" value="' +
                                        getItemcode +
                                        '" readonly>',
                                        '<input type="text" class="text-center" id="' +
                                        part_no +
                                        '" name="part_no[]" value="' +
                                        getPartno +
                                        '" readonly>',
                                        '<input type="text" class="text-center" id="' +
                                        Squence +
                                        '" name="Squence[]" value="' +
                                        getSquence +
                                        '" readonly>',
                                        '<input type="text" class="text-center" id="' +
                                        Qty +
                                        '" name="Qty[]" value="' +
                                        getQty +
                                        '" readonly>',
                                        '<input type="text" class="text-center" name="Kanban_no[]" id="' +
                                        Kanban_no +
                                        '" value="' +
                                        getKanban +
                                        '">', // Tambahkan value dengan getKanban
                                    ]
                                )
                                .draw();
                            input1
                                .val(
                                    ""
                                );

                            $('#input1')
                                .focus();
                            // alert('masuk');
                        } else if (
                            response
                            .message ===
                            "error"
                        ) {
                            if ("vibrate" in
                                navigator
                            ) {
                                navigator
                                    .vibrate(
                                        [
                                            1000
                                        ]
                                    );
                            }
                            document
                                .getElementById(
                                    'Audioerror'
                                )
                                .play();
                            input1
                                .val(
                                    ""
                                );

                            $('#input1')
                                .focus();
                            swal.fire({
                                icon: 'error',
                                title: 'TANGGAL TIDAK SAMA',
                                text: 'Error',
                                showConfirmButton: true, // Menampilkan tombol OK
                                // timer: 2000, // Menampilkan selama 2 detik
                            });
                        }
                    }
                })

            }
        }







        // include validasi max and validasi overflow chuter
        // function addDataToTable(spliteData1) {
        //     var getKanban = spliteData1[0];
        //     var getSquence = spliteData1[1];
        //     var getPartno = spliteData1[2];
        //     var getItemcode = spliteData1[3];
        //     var getQty = spliteData1[4];

        //     // Menampilkan loading spinner
        //     function showLoading() {
        //         $('.loading-spinner-container').show();
        //     }

        //     // Menyembunyikan loading spinner
        //     function hideLoading() {
        //         $('.loading-spinner-container').hide();
        //     }
        //     // validasi fg out
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
        //                 .attr('content')
        //         }
        //     });
        //     $.ajax({
        //         url: "{{ route('validasi_fgout1') }}",
        //         type: "get",
        //         data: {
        //             getItemcode: getItemcode,
        //             getSquence: getSquence
        //         },
        //         dataType: 'json',
        //         beforeSend: function() {
        //             showLoading(); // Memanggil fungsi showLoading sebelum request
        //         },
        //         success: function(data) {

        //             if (data == "") {
        //                 $.ajaxSetup({
        //                     headers: {
        //                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
        //                             .attr('content')
        //                     }
        //                 });
        //                 $.ajax({
        //                     url: "{{ route('validasi_fgin1') }}",
        //                     type: "get",
        //                     data: {
        //                         getItemcode: getItemcode,
        //                         getSquence: getSquence
        //                     },
        //                     dataType: 'json',
        //                     success: function(data) {
        //                         // console.log(data);
        //                         if (data.message === "data_not") {
        //                             hideLoading();
        //                             // alert('data tidak ada');
        //                             if ("vibrate" in navigator) {
        //                                 navigator.vibrate([1000]);
        //                             }
        //                             document.getElementById('Audioerror').play();
        //                             swal.fire({
        //                                 icon: 'error',
        //                                 title: 'Data Not Found',
        //                                 text: 'Data Belum di Scan In Fg',
        //                                 showConfirmButton: true, // Menampilkan tombol OK
        //                                 // timer: 2000, // Menampilkan selama 2 detik
        //                             });
        //                             input1.val("");
        //                             input1.focus();
        //                         } else if (data.message == "null") {
        //                             var table = $("#tblChutter").DataTable();
        //                             var qty = 0; // Variabel untuk menyimpan total qty
        //                             var getQtyInt = parseInt(getQty, 10);
        //                             // Mengecek apakah tabel memiliki baris
        //                             if (table.data().count() !== 0) {
        //                                 table.rows().every(function() {
        //                                     var rowData = this.data();
        //                                     var qtyValue = parseInt($(rowData[
        //                                             3]).val(),
        //                                         10
        //                                     ); // Mengambil dan mengubah nilai qty menjadi integer
        //                                     qty += isNaN(qtyValue) ? 0 :
        //                                         qtyValue; // Menambahkan nilai qty ke total jika valid
        //                                 });
        //                             }
        //                             //hasil qty inputan dan qty pada tabel
        //                             var resultQty = getQtyInt + qty;
        //                             // alert(resultQty);
        //                             // console.log(resultQty);
        //                             // // validasi max pada master min max
        //                             $.ajaxSetup({
        //                                 headers: {
        //                                     'X-CSRF-TOKEN': $(
        //                                             'meta[name="csrf-token"]')
        //                                         .attr('content')
        //                                 }
        //                             });
        //                             $.ajax({
        //                                 url: "{{ route('validasi_max_chuter') }}",
        //                                 type: "get",
        //                                 data: {
        //                                     getItemcode: getItemcode,
        //                                     resultQty: resultQty
        //                                 },
        //                                 dataType: 'json',
        //                                 success: function(data) {
        //                                     if (data.message ===
        //                                         "success") {
        //                                         // validasi kanban over flow by date print  kanban
        //                                         $.ajaxSetup({
        //                                             headers: {
        //                                                 'X-CSRF-TOKEN': $(
        //                                                         'meta[name="csrf-token"]'
        //                                                     )
        //                                                     .attr(
        //                                                         'content'
        //                                                     )
        //                                             }
        //                                         });
        //                                         $.ajax({
        //                                             url: "{{ route('validasi_overflow') }}",
        //                                             type: "get",
        //                                             data: {
        //                                                 getKanban: getKanban,
        //                                                 getSquence: getSquence
        //                                             },
        //                                             dataType: 'json',
        //                                             success: function(
        //                                                 data) {
        //                                                 if (data
        //                                                     .message ===
        //                                                     "success"
        //                                                 ) {
        //                                                     // Masukkan data pada kolom
        //                                                     hideLoading
        //                                                         ();
        //                                                     var table =
        //                                                         $(
        //                                                             "#tblChutter"
        //                                                         )
        //                                                         .DataTable();
        //                                                     if (table
        //                                                         .data()
        //                                                         .count() ===
        //                                                         0
        //                                                     ) {
        //                                                         // Tabel kosong, langsung tambahkan data
        //                                                         var t =
        //                                                             $(
        //                                                                 '#tblChutter'
        //                                                             )
        //                                                             .DataTable();
        //                                                         var counter =
        //                                                             t
        //                                                             .rows()
        //                                                             .count();
        //                                                         var jml_row =
        //                                                             Number(
        //                                                                 counter
        //                                                             ) +
        //                                                             1;
        //                                                         var Itemcode =
        //                                                             "Itemcode" +
        //                                                             jml_row;
        //                                                         var part_no =
        //                                                             "part_no" +
        //                                                             jml_row;
        //                                                         var Squence =
        //                                                             "Squence" +
        //                                                             jml_row;
        //                                                         var Qty =
        //                                                             "Qty" +
        //                                                             jml_row;
        //                                                         var Kanban_no =
        //                                                             "Kanban_no" +
        //                                                             jml_row;
        //                                                         t.row
        //                                                             .add(
        //                                                                 [

        //                                                                     '<input type="text" class="text-center" id="' +
        //                                                                     Itemcode +
        //                                                                     '" name="Itemcode[]" value="' +
        //                                                                     getItemcode +
        //                                                                     '" readonly>',
        //                                                                     '<input type="text" class="text-center" id="' +
        //                                                                     part_no +
        //                                                                     '" name="part_no[]" value="' +
        //                                                                     getPartno +
        //                                                                     '" readonly>',

        //                                                                     '<input type="text" class="text-center" id="' +
        //                                                                     Squence +
        //                                                                     '" name="Squence[]" value="' +
        //                                                                     getSquence +
        //                                                                     '" readonly>',
        //                                                                     '<input type="text" class="text-center" id="' +
        //                                                                     Qty +
        //                                                                     '" name="Qty[]" value="' +
        //                                                                     getQty +
        //                                                                     '" readonly>',
        //                                                                     '<input type="text" class="text-center" name="Kanban_no[]" id="' +
        //                                                                     Kanban_no +
        //                                                                     '" value="' +
        //                                                                     getKanban +
        //                                                                     '">', // Tambahkan value dengan getKanban
        //                                                                 ]
        //                                                             )
        //                                                             .draw();
        //                                                         input1
        //                                                             .val(
        //                                                                 ""
        //                                                             );
        //                                                         $('#input1')
        //                                                             .focus();
        //                                                     } else {
        //                                                         // validasi data kosong
        //                                                         // Tabel tidak kosong, periksa apakah Part No sudah ada dalam tabel
        //                                                         var partNoExists =
        //                                                             false;
        //                                                         table
        //                                                             .rows()
        //                                                             .every(
        //                                                                 function() {
        //                                                                     var rowData =
        //                                                                         this
        //                                                                         .data();

        //                                                                     var existingPartNo =
        //                                                                         rowData[
        //                                                                             1
        //                                                                         ];
        //                                                                     var valuePartno =
        //                                                                         $(
        //                                                                             existingPartNo
        //                                                                         )
        //                                                                         .val();
        //                                                                     if (valuePartno ==
        //                                                                         getPartno
        //                                                                     ) {
        //                                                                         partNoExists
        //                                                                             =
        //                                                                             true;
        //                                                                         return false; // Keluar dari perulangan jika sudah ditemukan Part No yang cocok
        //                                                                     }
        //                                                                 }
        //                                                             );
        //                                                         // jika data nya sama
        //                                                         if (
        //                                                             partNoExists
        //                                                         ) {
        //                                                             var sq =
        //                                                                 true;
        //                                                             table
        //                                                                 .rows()
        //                                                                 .every(
        //                                                                     function() {
        //                                                                         var rowData =
        //                                                                             this
        //                                                                             .data();
        //                                                                         // console.log(rowData);
        //                                                                         var exitingSq =
        //                                                                             rowData[
        //                                                                                 2
        //                                                                             ];
        //                                                                         // console.log(exitingSq);
        //                                                                         var valueSq =
        //                                                                             $(
        //                                                                                 exitingSq
        //                                                                             )
        //                                                                             .val();
        //                                                                         // console.log(valueSq);
        //                                                                         // console.log(getSquence);
        //                                                                         if (valueSq ==
        //                                                                             getSquence
        //                                                                         ) {
        //                                                                             sq =
        //                                                                                 false;
        //                                                                         }
        //                                                                     }
        //                                                                 );
        //                                                             // jika squence nya tidak sama
        //                                                             // console.log(sq);
        //                                                             if (
        //                                                                 sq
        //                                                             ) {
        //                                                                 // alert('Squence tidak sama');
        //                                                                 var table =
        //                                                                     $(
        //                                                                         "#tblChutter"
        //                                                                     )
        //                                                                     .DataTable();

        //                                                                 // Mengambil data dari seluruh baris dalam tabel
        //                                                                 var data =
        //                                                                     table
        //                                                                     .rows()
        //                                                                     .data();
        //                                                                 var colKanban =
        //                                                                     "";
        //                                                                 var colSeq =
        //                                                                     "";

        //                                                                 if (data
        //                                                                     .length >
        //                                                                     0
        //                                                                 ) {
        //                                                                     var rowData =
        //                                                                         data[
        //                                                                             data
        //                                                                             .length -
        //                                                                             1
        //                                                                         ]; // Mendapatkan data dari baris terakhir
        //                                                                     colKanban
        //                                                                         =
        //                                                                         $(rowData[
        //                                                                             4
        //                                                                         ])
        //                                                                         .val();
        //                                                                     colSeq
        //                                                                         =
        //                                                                         $(rowData[
        //                                                                             2
        //                                                                         ])
        //                                                                         .val(); // Mengambil nilai dari elemen pertama
        //                                                                 }
        //                                                                 //  validasi kanban harus sama pada tabel dan kolom
        //                                                                 $.ajax({
        //                                                                     url: "{{ route('validasi_date') }}",
        //                                                                     type: "get",
        //                                                                     data: {
        //                                                                         colKanban: colKanban,
        //                                                                         colSeq: colSeq,
        //                                                                         getKanban: getKanban,
        //                                                                         getSquence: getSquence

        //                                                                     }, // Data yang akan dikirim ke server
        //                                                                     dataType: 'json',

        //                                                                     success: function(
        //                                                                         response
        //                                                                     ) {
        //                                                                         if (response
        //                                                                             .message ===
        //                                                                             "success"
        //                                                                         ) {
        //                                                                             var t =
        //                                                                                 $(
        //                                                                                     '#tblChutter'
        //                                                                                 )
        //                                                                                 .DataTable();
        //                                                                             var counter =
        //                                                                                 t
        //                                                                                 .rows()
        //                                                                                 .count();
        //                                                                             var jml_row =
        //                                                                                 Number(
        //                                                                                     counter
        //                                                                                 ) +
        //                                                                                 1;
        //                                                                             var Itemcode =
        //                                                                                 "Itemcode" +
        //                                                                                 jml_row;
        //                                                                             var part_no =
        //                                                                                 "part_no" +
        //                                                                                 jml_row;
        //                                                                             var Squence =
        //                                                                                 "Squence" +
        //                                                                                 jml_row;
        //                                                                             var Kanban_no =
        //                                                                                 "Kanban_no" +
        //                                                                                 jml_row;
        //                                                                             var Qty =
        //                                                                                 "Qty" +
        //                                                                                 jml_row;
        //                                                                             t.row
        //                                                                                 .add(
        //                                                                                     [

        //                                                                                         '<input type="text" class="text-center" id="' +
        //                                                                                         Itemcode +
        //                                                                                         '" name="Itemcode[]" value="' +
        //                                                                                         getItemcode +
        //                                                                                         '" readonly>',
        //                                                                                         '<input type="text" class="text-center" id="' +
        //                                                                                         part_no +
        //                                                                                         '" name="part_no[]" value="' +
        //                                                                                         getPartno +
        //                                                                                         '" readonly>',
        //                                                                                         '<input type="text" class="text-center" id="' +
        //                                                                                         Squence +
        //                                                                                         '" name="Squence[]" value="' +
        //                                                                                         getSquence +
        //                                                                                         '" readonly>',
        //                                                                                         '<input type="text" class="text-center" id="' +
        //                                                                                         Qty +
        //                                                                                         '" name="Qty[]" value="' +
        //                                                                                         getQty +
        //                                                                                         '" readonly>',
        //                                                                                         '<input type="text" class="text-center" name="Kanban_no[]" id="' +
        //                                                                                         Kanban_no +
        //                                                                                         '" value="' +
        //                                                                                         getKanban +
        //                                                                                         '">', // Tambahkan value dengan getKanban
        //                                                                                     ]
        //                                                                                 )
        //                                                                                 .draw();
        //                                                                             input1
        //                                                                                 .val(
        //                                                                                     ""
        //                                                                                 );

        //                                                                             $('#input1')
        //                                                                                 .focus();
        //                                                                             // alert('masuk');
        //                                                                         } else if (
        //                                                                             response
        //                                                                             .message ===
        //                                                                             "error"
        //                                                                         ) {
        //                                                                             if ("vibrate" in
        //                                                                                 navigator
        //                                                                             ) {
        //                                                                                 navigator
        //                                                                                     .vibrate(
        //                                                                                         [
        //                                                                                             1000
        //                                                                                         ]
        //                                                                                     );
        //                                                                             }
        //                                                                             document
        //                                                                                 .getElementById(
        //                                                                                     'Audioerror'
        //                                                                                 )
        //                                                                                 .play();
        //                                                                             input1
        //                                                                                 .val(
        //                                                                                     ""
        //                                                                                 );

        //                                                                             $('#input1')
        //                                                                                 .focus();
        //                                                                             swal.fire({
        //                                                                                 icon: 'error',
        //                                                                                 title: 'TANGGAL TIDAK SAMA',
        //                                                                                 text: 'Error',
        //                                                                                 showConfirmButton: true, // Menampilkan tombol OK
        //                                                                                 // timer: 2000, // Menampilkan selama 2 detik
        //                                                                             });
        //                                                                         }
        //                                                                     }
        //                                                                 })

        //                                                                 // jika squence nya sama
        //                                                             } else {
        //                                                                 // alert('error squence sama');
        //                                                                 // notif bergetar
        //                                                                 hideLoading
        //                                                                     ();
        //                                                                 if ("vibrate" in
        //                                                                     navigator
        //                                                                 ) {
        //                                                                     navigator
        //                                                                         .vibrate(
        //                                                                             [
        //                                                                                 1000
        //                                                                             ]
        //                                                                         );
        //                                                                 }
        //                                                                 document
        //                                                                     .getElementById(
        //                                                                         'Audioerror'
        //                                                                     )
        //                                                                     .play();
        //                                                                 swal.fire({
        //                                                                     icon: 'error',
        //                                                                     title: 'Squence Tidak Boleh Sama',
        //                                                                     text: 'Squence Sudah di Scan',
        //                                                                     showConfirmButton: true, // Menampilkan tombol OK
        //                                                                     // timer: 2000, // Menampilkan selama 2 detik
        //                                                                 });
        //                                                                 input1
        //                                                                     .val(
        //                                                                         ""
        //                                                                     );

        //                                                                 $('#input1')
        //                                                                     .focus();
        //                                                             }



        //                                                         } else {
        //                                                             // jika part no nya tidak sama
        //                                                             hideLoading
        //                                                                 ();
        //                                                             // alert('partno tidak sama');
        //                                                             input1
        //                                                                 .val(
        //                                                                     ""
        //                                                                 );

        //                                                             $('#input1')
        //                                                                 .focus();
        //                                                             if ("vibrate" in
        //                                                                 navigator
        //                                                             ) {
        //                                                                 navigator
        //                                                                     .vibrate(
        //                                                                         [
        //                                                                             1000
        //                                                                         ]
        //                                                                     );
        //                                                             }
        //                                                             document
        //                                                                 .getElementById(
        //                                                                     'Audioerror'
        //                                                                 )
        //                                                                 .play();
        //                                                             swal.fire({
        //                                                                 icon: 'error',
        //                                                                 title: 'Part No Tidak Sama',
        //                                                                 text: 'Part No Tidak Sama',
        //                                                                 showConfirmButton: true, // Menampilkan tombol OK
        //                                                             });
        //                                                         }

        //                                                     }
        //                                                 } else if (
        //                                                     data
        //                                                     .message ===
        //                                                     "error"
        //                                                 ) {
        //                                                     hideLoading
        //                                                         ();
        //                                                     if ("vibrate" in
        //                                                         navigator
        //                                                     ) {
        //                                                         navigator
        //                                                             .vibrate(
        //                                                                 [
        //                                                                     1000
        //                                                                 ]
        //                                                             );
        //                                                     }
        //                                                     document
        //                                                         .getElementById(
        //                                                             'Audioerror'
        //                                                         )
        //                                                         .play();
        //                                                     Swal.fire({
        //                                                         icon: 'error',
        //                                                         title: 'Error',
        //                                                         text: `Data OverFlow Tgl: ${data.date}`,
        //                                                         showConfirmButton: true, // Menampilkan tombol OK
        //                                                     });
        //                                                     input1
        //                                                         .val(
        //                                                             ""
        //                                                         )
        //                                                         .focus();
        //                                                 }
        //                                             },
        //                                         });
        //                                     } else if (data.message ===
        //                                         "error") {
        //                                         hideLoading();
        //                                         if ("vibrate" in
        //                                             navigator) {
        //                                             navigator.vibrate([
        //                                                 1000
        //                                             ]);
        //                                         }
        //                                         document.getElementById(
        //                                             'Audioerror').play();
        //                                         swal.fire({
        //                                             icon: 'error',
        //                                             title: 'Error',
        //                                             text: 'Qty Melebihi Max',
        //                                             showConfirmButton: true, // Menampilkan tombol OK
        //                                         });
        //                                         input1.val("");
        //                                         input1.focus();
        //                                     }
        //                                 },
        //                             });

        //                         } else if (data.message == "not_null") {
        //                             // alert('cutter address suda ada');

        //                             hideLoading();
        //                             if ("vibrate" in navigator) {
        //                                 navigator.vibrate([1000]);
        //                             }
        //                             document.getElementById('Audioerror').play();
        //                             swal.fire({
        //                                 icon: 'error',
        //                                 title: 'Data Sudah Di Scan Chutter',
        //                                 text: 'Data Already Exist',
        //                                 showConfirmButton: true, // Menampilkan tombol OK
        //                             });
        //                             input1.val("");
        //                             input1.focus();
        //                         }
        //                     },
        //                 });
        //             } else {
        //                 // alert('data sudah ada fg out');

        //                 hideLoading();
        //                 if ("vibrate" in navigator) {
        //                     navigator.vibrate([1000]);
        //                 }
        //                 document.getElementById('Audioerror').play();
        //                 swal.fire({
        //                     icon: 'error',
        //                     title: 'DATA SUDAH DI CHUTER OUT',
        //                     text: 'Data Already Exist',
        //                     showConfirmButton: true, // Menampilkan tombol OK
        //                 });
        //                 input1.val("");
        //                 input1.focus();
        //             }
        //             // hideLoading();
        //         }
        //     });
        // }



        // include validasi max and validasi overflow chuter
        // function addDataToTable2(spliteData1) {

        //     var getKanban = spliteData1[1];
        //     var getSquence = spliteData1[2];
        //     var getPartno = spliteData1[3];
        //     var getItemcode = spliteData1[4];
        //     var getQty = spliteData1[5];
        //     // console.log(spliteData1);
        //     // console.log(getSquence);
        //     // console.log(getPartno);
        //     // console.log(getItemcode);
        //     function showLoading() {
        //         $('.loading-spinner-container').show();
        //     }

        //     // Menyembunyikan loading spinner
        //     function hideLoading() {
        //         $('.loading-spinner-container').hide();
        //     }
        //     // validasi fg out
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
        //                 .attr('content')
        //         }
        //     });
        //     $.ajax({
        //         url: "{{ route('validasi_fgout2') }}",
        //         type: "get",
        //         data: {
        //             getItemcode: getItemcode,
        //             getSquence: getSquence,
        //             getKanban: getKanban
        //         },
        //         dataType: 'json',
        //         beforeSend: function() {
        //             showLoading(); // Memanggil fungsi showLoading sebelum request
        //         },
        //         success: function(data) {
        //             if (data == "") {
        //                 $.ajaxSetup({
        //                     headers: {
        //                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
        //                             .attr('content')
        //                     }
        //                 });
        //                 $.ajax({
        //                     url: "{{ route('validasi_fgin2') }}",
        //                     type: "get",
        //                     data: {
        //                         getItemcode: getItemcode,
        //                         getSquence: getSquence,
        //                         getKanban: getKanban
        //                     },
        //                     dataType: 'json',
        //                     success: function(data) {

        //                         if (data.message === "data_not") {
        //                             // alert('data tidak ada');
        //                             hideLoading();
        //                             if ("vibrate" in navigator) {
        //                                 navigator.vibrate([1000]);
        //                             }
        //                             document.getElementById('Audioerror').play();
        //                             swal.fire({
        //                                 icon: 'error',
        //                                 title: 'Data Not Found',
        //                                 text: 'Data Belum di Scan In Fg',
        //                                 showConfirmButton: true, // Menampilkan tombol OK
        //                             });
        //                             input1.val("");
        //                             input1.focus();
        //                         } else if (data.message == "null") {
        //                             var table = $("#tblChutter").DataTable();
        //                             var qty = 0; // Variabel untuk menyimpan total qty
        //                             var getQtyInt = parseInt(getQty, 10);
        //                             // Mengecek apakah tabel memiliki baris
        //                             if (table.data().count() !== 0) {
        //                                 table.rows().every(function() {
        //                                     var rowData = this.data();
        //                                     var qtyValue = parseInt($(rowData[
        //                                             3]).val(),
        //                                         10
        //                                     ); // Mengambil dan mengubah nilai qty menjadi integer
        //                                     qty += isNaN(qtyValue) ? 0 :
        //                                         qtyValue; // Menambahkan nilai qty ke total jika valid
        //                                 });
        //                             }
        //                             //hasil qty inputan dan qty pada tabel
        //                             var resultQty = getQtyInt + qty;
        //                             $.ajaxSetup({
        //                                 headers: {
        //                                     'X-CSRF-TOKEN': $(
        //                                             'meta[name="csrf-token"]')
        //                                         .attr('content')
        //                                 }
        //                             });
        //                             $.ajax({
        //                                 url: "{{ route('validasi_max_chuter') }}",
        //                                 type: "get",
        //                                 data: {
        //                                     getItemcode: getItemcode,
        //                                     resultQty: resultQty
        //                                 },
        //                                 dataType: 'json',
        //                                 success: function(data) {
        //                                     if (data.message ===
        //                                         "success") {
        //                                         // validasi kanban over flow by date print  kanban
        //                                         $.ajaxSetup({
        //                                             headers: {
        //                                                 'X-CSRF-TOKEN': $(
        //                                                         'meta[name="csrf-token"]'
        //                                                     )
        //                                                     .attr(
        //                                                         'content'
        //                                                     )
        //                                             }
        //                                         });
        //                                         $.ajax({
        //                                             url: "{{ route('validasi_overflow') }}",
        //                                             type: "get",
        //                                             data: {
        //                                                 getKanban: getKanban,
        //                                                 getSquence: getSquence
        //                                             },
        //                                             dataType: 'json',
        //                                             success: function(
        //                                                 data) {
        //                                                 if (data
        //                                                     .message ===
        //                                                     "success"
        //                                                 ) {
        //                                                     // Masukkan data pada kolom
        //                                                     hideLoading
        //                                                         ();

        //                                                     // Tabel kosong, langsung tambahkan data
        //                                                     hideLoading
        //                                                         ();
        //                                                     var table =
        //                                                         $(
        //                                                             "#tblChutter"
        //                                                             )
        //                                                         .DataTable();
        //                                                     if (table
        //                                                         .data()
        //                                                         .count() ===
        //                                                         0
        //                                                     ) {
        //                                                         // Tabel kosong, langsung tambahkan data
        //                                                         var t =
        //                                                             $(
        //                                                                 '#tblChutter'
        //                                                                 )
        //                                                             .DataTable();
        //                                                         var counter =
        //                                                             t
        //                                                             .rows()
        //                                                             .count();
        //                                                         var jml_row =
        //                                                             Number(
        //                                                                 counter
        //                                                             ) +
        //                                                             1;
        //                                                         var Itemcode =
        //                                                             "Itemcode" +
        //                                                             jml_row;
        //                                                         var part_no =
        //                                                             "part_no" +
        //                                                             jml_row;
        //                                                         var Squence =
        //                                                             "Squence" +
        //                                                             jml_row;
        //                                                         var Qty =
        //                                                             "Qty" +
        //                                                             jml_row;
        //                                                         var Kanban_no =
        //                                                             "Kanban_no" +
        //                                                             jml_row;
        //                                                         t.row
        //                                                             .add(
        //                                                                 [

        //                                                                     '<input type="text" class="text-center" id="' +
        //                                                                     Itemcode +
        //                                                                     '" name="Itemcode[]" value="' +
        //                                                                     getItemcode +
        //                                                                     '" readonly>',
        //                                                                     '<input type="text" class="text-center" id="' +
        //                                                                     part_no +
        //                                                                     '" name="part_no[]" value="' +
        //                                                                     getPartno +
        //                                                                     '" readonly>',

        //                                                                     '<input type="text" class="text-center" id="' +
        //                                                                     Squence +
        //                                                                     '" name="Squence[]" value="' +
        //                                                                     getSquence +
        //                                                                     '" readonly>',
        //                                                                     '<input type="text" class="text-center" id="' +
        //                                                                     Qty +
        //                                                                     '" name="Qty[]" value="' +
        //                                                                     getQty +
        //                                                                     '" readonly>',
        //                                                                     '<input type="text" class="text-center" name="Kanban_no[]" id="' +
        //                                                                     Kanban_no +
        //                                                                     '" value="' +
        //                                                                     getKanban +
        //                                                                     '">',
        //                                                                     // '<input type="text" name="kanbanNO[]" id="' + kanbanNO +
        //                                                                     // '" value="' + getKanban + '">', // Tambahkan value dengan getKanban
        //                                                                 ]
        //                                                             )
        //                                                             .draw();
        //                                                         input1
        //                                                             .val(
        //                                                                 ""
        //                                                             );

        //                                                         $('#input1')
        //                                                             .focus();
        //                                                     } else {
        //                                                         // validasi data kosong
        //                                                         // Tabel tidak kosong, periksa apakah Part No sudah ada dalam tabel
        //                                                         var partNoExists =
        //                                                             false;
        //                                                         table
        //                                                             .rows()
        //                                                             .every(
        //                                                                 function() {
        //                                                                     var rowData =
        //                                                                         this
        //                                                                         .data();

        //                                                                     var existingPartNo =
        //                                                                         rowData[
        //                                                                             1
        //                                                                         ];
        //                                                                     var valuePartno =
        //                                                                         $(
        //                                                                             existingPartNo
        //                                                                             )
        //                                                                         .val();
        //                                                                     if (valuePartno ==
        //                                                                         getPartno
        //                                                                     ) {
        //                                                                         partNoExists
        //                                                                             =
        //                                                                             true;
        //                                                                         return false; // Keluar dari perulangan jika sudah ditemukan Part No yang cocok
        //                                                                     }
        //                                                                 }
        //                                                             );
        //                                                         // jika data nya sama
        //                                                         if (
        //                                                             partNoExists
        //                                                             ) {
        //                                                             var sq =
        //                                                                 true;
        //                                                             table
        //                                                                 .rows()
        //                                                                 .every(
        //                                                                     function() {
        //                                                                         var rowData =
        //                                                                             this
        //                                                                             .data();
        //                                                                         // console.log(rowData);
        //                                                                         var exitingSq =
        //                                                                             rowData[
        //                                                                                 2
        //                                                                             ];
        //                                                                         // console.log(exitingSq);
        //                                                                         var valueSq =
        //                                                                             $(
        //                                                                                 exitingSq
        //                                                                                 )
        //                                                                             .val();
        //                                                                         // console.log(valueSq);
        //                                                                         // console.log(getSquence);
        //                                                                         if (valueSq ==
        //                                                                             getSquence
        //                                                                         ) {
        //                                                                             sq =
        //                                                                                 false;
        //                                                                         }
        //                                                                     }
        //                                                                 );
        //                                                             // jika squence nya tidak sama
        //                                                             // console.log(sq);
        //                                                             if (
        //                                                                 sq
        //                                                                 ) {
        //                                                                 // alert('Squence tidak sama');
        //                                                                 hideLoading
        //                                                                     ();
        //                                                                 var colKanban =
        //                                                                     "";
        //                                                                 var colSeq =
        //                                                                     "";

        //                                                                 table
        //                                                                     .rows()
        //                                                                     .every(
        //                                                                         function() {
        //                                                                             var rowData =
        //                                                                                 this
        //                                                                                 .data();
        //                                                                             // console.log(rowData);
        //                                                                             var exitingKn =
        //                                                                                 rowData[
        //                                                                                     4
        //                                                                                 ];
        //                                                                             // console.log(exitingKn);
        //                                                                             var exitingSq =
        //                                                                                 rowData[
        //                                                                                     2
        //                                                                                 ];
        //                                                                             // console.log(exitingSq);

        //                                                                             colKanban
        //                                                                                 =
        //                                                                                 $(
        //                                                                                     exitingKn
        //                                                                                     )
        //                                                                                 .val();
        //                                                                             colSeq
        //                                                                                 =
        //                                                                                 $(
        //                                                                                     exitingSq
        //                                                                                     )
        //                                                                                 .val();
        //                                                                         }
        //                                                                     );

        //                                                                 //  validasi date kanban kolom dan kanban tabel
        //                                                                 $.ajaxSetup({
        //                                                                     headers: {
        //                                                                         'X-CSRF-TOKEN': $(
        //                                                                                 'meta[name="csrf-token"]'
        //                                                                             )
        //                                                                             .attr(
        //                                                                                 'content'
        //                                                                             )
        //                                                                     }
        //                                                                 });
        //                                                                 $.ajax({
        //                                                                     url: "{{ route('validasi_date1') }}",
        //                                                                     type: "get",
        //                                                                     data: {
        //                                                                         colKanban: colKanban,
        //                                                                         colSeq: colSeq,
        //                                                                         getKanban: getKanban,
        //                                                                         getSquence: getSquence

        //                                                                     }, // Data yang akan dikirim ke server
        //                                                                     dataType: 'json',

        //                                                                     success: function(
        //                                                                         response
        //                                                                     ) {
        //                                                                         if (response
        //                                                                             .message ===
        //                                                                             "success"
        //                                                                         ) {
        //                                                                             var t =
        //                                                                                 $(
        //                                                                                     '#tblChutter'
        //                                                                                 )
        //                                                                                 .DataTable();
        //                                                                             var counter =
        //                                                                                 t
        //                                                                                 .rows()
        //                                                                                 .count();
        //                                                                             var jml_row =
        //                                                                                 Number(
        //                                                                                     counter
        //                                                                                 ) +
        //                                                                                 1;
        //                                                                             var Itemcode =
        //                                                                                 "Itemcode" +
        //                                                                                 jml_row;
        //                                                                             var part_no =
        //                                                                                 "part_no" +
        //                                                                                 jml_row;
        //                                                                             var Squence =
        //                                                                                 "Squence" +
        //                                                                                 jml_row;
        //                                                                             var Qty =
        //                                                                                 "Qty" +
        //                                                                                 jml_row;
        //                                                                             var Kanban_no =
        //                                                                                 "Kanban_no" +
        //                                                                                 jml_row;
        //                                                                             t.row
        //                                                                                 .add(
        //                                                                                     [

        //                                                                                         '<input type="text" class="text-center" id="' +
        //                                                                                         Itemcode +
        //                                                                                         '" name="Itemcode[]" value="' +
        //                                                                                         getItemcode +
        //                                                                                         '" readonly>',
        //                                                                                         '<input type="text" class="text-center" id="' +
        //                                                                                         part_no +
        //                                                                                         '" name="part_no[]" value="' +
        //                                                                                         getPartno +
        //                                                                                         '" readonly>',
        //                                                                                         '<input type="text" class="text-center" id="' +
        //                                                                                         Squence +
        //                                                                                         '" name="Squence[]" value="' +
        //                                                                                         getSquence +
        //                                                                                         '" readonly>',
        //                                                                                         '<input type="text" class="text-center" id="' +
        //                                                                                         Qty +
        //                                                                                         '" name="Qty[]" value="' +
        //                                                                                         getQty +
        //                                                                                         '" readonly>',
        //                                                                                         '<input type="text" class="text-center" name="Kanban_no[]" id="' +
        //                                                                                         Kanban_no +
        //                                                                                         '" value="' +
        //                                                                                         getKanban +
        //                                                                                         '">',
        //                                                                                     ]
        //                                                                                 )
        //                                                                                 .draw();
        //                                                                             input1
        //                                                                                 .val(
        //                                                                                     ""
        //                                                                                 );

        //                                                                             $('#input1')
        //                                                                                 .focus();

        //                                                                         } else if (
        //                                                                             response
        //                                                                             .message ===
        //                                                                             "error"
        //                                                                         ) {
        //                                                                             if ("vibrate" in
        //                                                                                 navigator
        //                                                                             ) {
        //                                                                                 navigator
        //                                                                                     .vibrate(
        //                                                                                         [
        //                                                                                             1000
        //                                                                                         ]
        //                                                                                     );
        //                                                                             }
        //                                                                             document
        //                                                                                 .getElementById(
        //                                                                                     'Audioerror'
        //                                                                                 )
        //                                                                                 .play();
        //                                                                             input1
        //                                                                                 .val(
        //                                                                                     ""
        //                                                                                 );

        //                                                                             $('#input1')
        //                                                                                 .focus();
        //                                                                             swal.fire({
        //                                                                                 icon: 'error',
        //                                                                                 title: 'TANGGAL TIDAK SAMA',
        //                                                                                 text: 'Error',
        //                                                                                 showConfirmButton: true, // Menampilkan tombol OK
        //                                                                                 // timer: 2000, // Menampilkan selama 2 detik
        //                                                                             });
        //                                                                         }
        //                                                                     }
        //                                                                 })

        //                                                                 // jika squence nya sama
        //                                                             } else {
        //                                                                 // alert('error squence sama');
        //                                                                 hideLoading
        //                                                                     ();
        //                                                                 // notif bergetar
        //                                                                 if ("vibrate" in
        //                                                                     navigator
        //                                                                 ) {
        //                                                                     navigator
        //                                                                         .vibrate(
        //                                                                             [
        //                                                                                 1000
        //                                                                             ]
        //                                                                         );
        //                                                                 }
        //                                                                 document
        //                                                                     .getElementById(
        //                                                                         'Audioerror'
        //                                                                     )
        //                                                                     .play();
        //                                                                 swal.fire({
        //                                                                     icon: 'error',
        //                                                                     title: 'Squence Tidak Boleh Sama',
        //                                                                     text: 'Squence Sudah di Scan',
        //                                                                     showConfirmButton: true, // Menampilkan tombol OK
        //                                                                     // timer: 2000, // Menampilkan selama 2 detik
        //                                                                 });
        //                                                                 input1
        //                                                                     .val(
        //                                                                         ""
        //                                                                     );

        //                                                                 $('#input1')
        //                                                                     .focus();
        //                                                             }


        //                                                             // jika data nya tidak sama
        //                                                         } else {
        //                                                             // alert('partno tidak sama');
        //                                                             input1
        //                                                                 .val(
        //                                                                     ""
        //                                                                 );
        //                                                             hideLoading
        //                                                                 ();
        //                                                             $('#input1')
        //                                                                 .focus();
        //                                                             if ("vibrate" in
        //                                                                 navigator
        //                                                             ) {
        //                                                                 navigator
        //                                                                     .vibrate(
        //                                                                         [
        //                                                                             1000
        //                                                                         ]
        //                                                                     );
        //                                                             }
        //                                                             document
        //                                                                 .getElementById(
        //                                                                     'Audioerror'
        //                                                                 )
        //                                                                 .play();
        //                                                             swal.fire({
        //                                                                 icon: 'error',
        //                                                                 title: 'Part No Tidak Sama',
        //                                                                 text: 'Part No Tidak Sama',
        //                                                                 showConfirmButton: true, // Menampilkan tombol OK
        //                                                                 // timer: 2000, // Menampilkan selama 2 detik
        //                                                             });
        //                                                         }

        //                                                     }

        //                                                 } else if (
        //                                                     data
        //                                                     .message ===
        //                                                     "error"
        //                                                 ) {
        //                                                     hideLoading
        //                                                         ();
        //                                                     if ("vibrate" in
        //                                                         navigator
        //                                                     ) {
        //                                                         navigator
        //                                                             .vibrate(
        //                                                                 [
        //                                                                     1000
        //                                                                 ]
        //                                                             );
        //                                                     }
        //                                                     document
        //                                                         .getElementById(
        //                                                             'Audioerror'
        //                                                         )
        //                                                         .play();
        //                                                     Swal.fire({
        //                                                         icon: 'error',
        //                                                         title: 'Error',
        //                                                         text: `Data OverFlow Tgl: ${data.date}`,
        //                                                         showConfirmButton: true, // Menampilkan tombol OK
        //                                                     });
        //                                                     input1
        //                                                         .val(
        //                                                             ""
        //                                                         )
        //                                                         .focus();
        //                                                 }
        //                                             },
        //                                         });
        //                                     } else if (data.message ===
        //                                         "error") {
        //                                         hideLoading();
        //                                         if ("vibrate" in
        //                                             navigator) {
        //                                             navigator.vibrate([
        //                                                 1000
        //                                             ]);
        //                                         }
        //                                         document.getElementById(
        //                                             'Audioerror').play();
        //                                         swal.fire({
        //                                             icon: 'error',
        //                                             title: 'Error',
        //                                             text: 'Qty Melebihi Max',
        //                                             showConfirmButton: true, // Menampilkan tombol OK
        //                                         });
        //                                         input1.val("");
        //                                         input1.focus();
        //                                     }
        //                                 },
        //                             });
        //                         } else if (data.message == "not_null") {
        //                             // alert('cutter address suda ada');
        //                             hideLoading();
        //                             if ("vibrate" in navigator) {
        //                                 navigator.vibrate([1000]);
        //                             }
        //                             document.getElementById('Audioerror').play();
        //                             swal.fire({
        //                                 icon: 'error',
        //                                 title: 'Data Sudah Di Scan Chutter',
        //                                 text: 'Data Already Exist',
        //                                 showConfirmButton: true, // Menampilkan tombol OK
        //                                 // timer: 2000, // Menampilkan selama 2 detik
        //                             });
        //                             input1.val("");
        //                             input1.focus();
        //                         }

        //                     },
        //                 });
        //             } else {
        //                 // alert('data sudah ada fg out');
        //                 hideLoading();
        //                 if ("vibrate" in navigator) {
        //                     navigator.vibrate([1000]);
        //                 }
        //                 document.getElementById('Audioerror').play();
        //                 swal.fire({
        //                     icon: 'error',
        //                     title: 'DATA SUDAH DI CHUTER OUT',
        //                     text: 'Data Already Exist',
        //                     showConfirmButton: true, // Menampilkan tombol OK
        //                 });
        //                 input1.val("");
        //                 input1.focus();
        //             }

        //         }
        //     });
        //     // validasi fgin


        // }

        // Input field 2
        input2.on("keydown", function(e) {

            if (e.which === 13) {
                // handleInput2Change();
                var input2 = $("#input2");
                // var itemcodeLokal = $("#itemcodeLokal");
                // Input field 2 for add row tabel
                // if (input2.val() !== "") {
                var getInput2 = input2.val();
                if (getInput2.includes(',')) {
                    var spliteData = getInput2.split(',');
                    // var Getpart_no = spliteData[1];
                    // var Getpart_no = spliteData[2];
                    var getItemcode = spliteData[1];
                    // alert(getItemcode);
                    $("#itemcodeChutter").val(getItemcode);
                    var table = $("#tblChutter").DataTable();

                    // Mengambil data dari seluruh baris dalam tabel
                    var data = table.rows().data();

                    var exitItemcode = "";
                    var exitkanban = "";
                    var exitSeq = "";
                    if (data.length > 0) {
                        var rowData = data[data.length -
                            1]; // Mendapatkan data dari baris terakhir
                        exitItemcode = $(rowData[0])
                            .val(); // Mengambil nilai dari elemen pertama
                        exitSeq = $(rowData[2])
                            .val(); // Mengambil nilai dari elemen pertama
                        exitkanban = $(rowData[4])
                            .val(); // Mengambil nilai dari elemen pertama
                    }

                    if (getItemcode === exitItemcode) {
                        // addDataToTable(spliteData);
                        // alert('sama');

                        var itemcodeChutter = $('#itemcodeChutter')
                            .val();
                        // function add fg in

                        addInchuter(itemcodeChutter, exitkanban,
                            exitSeq);

                    } else {
                        function showLoading() {
                            $('.loading-spinner-container').show();
                        }

                        // Menyembunyikan loading spinner
                        function hideLoading() {
                            $('.loading-spinner-container').hide();
                        }
                        // alert('Tidak sama ');
                        input1.focus();

                        var itemLokal = $('#itemcodeLokal').val();
                        // alert(itemLokal);
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $(
                                        'meta[name="csrf-token"]'
                                    )
                                    .attr(
                                        'content')
                            }
                        });
                        $.ajax({
                            url: "{{ route('get_chutterinput2') }}",
                            type: "get",
                            data: {
                                itemLokal: exitItemcode
                            }, // Data yang akan dikirim ke server
                            dataType: 'json',
                            beforeSend: function() {
                                showLoading
                                    (); // Memanggil fungsi showLoading sebelum request
                            },
                            success: function(data) {
                                var table = $(
                                        "#tblChutter")
                                    .DataTable();
                                hideLoading();
                                input1.focus();
                                // notif getar
                                if ("vibrate" in
                                    navigator) {
                                    navigator.vibrate([
                                        1000
                                    ]);
                                }
                                // notif audio
                                document.getElementById(
                                        'Audioerror')
                                    .play();
                                // show alert
                                swal.fire({
                                    icon: 'error',
                                    title: 'Itemcode Tidak Sama',
                                    text: 'Alamat chutter : ' +
                                        data
                                        .chutter_address,
                                });

                                // Mengatur ulang input dan tampilan

                                $('#itemcodeChutter')
                                    .val("");
                                document.getElementById(
                                        "divLokal")
                                    .style.display =
                                    "block";
                                document.getElementById(
                                        "divChutter")
                                    .style.display =
                                    "none";
                                $('#input1').val(
                                    ""
                                ); // <-- Menggunakan jQuery untuk membersihkan nilai input1
                                $('#input2').val(
                                    ""
                                ); // <-- Menambahkan nilai yang benar untuk membersihkan input2
                                table.clear().draw();
                                $('#input1').focus();


                            }

                        })
                    }


                } else {
                    input2.val(
                        ""); // Kosongkan input2 jika tidak ada koma
                    input2.attr('readonly', false);
                    $('#input2').focus();
                }

            }
        });

        // add update colum for ekanban fgin
        function addInchuter(itemcodeChutter, exitkanban, exitSeq) {
            function showLoading() {
                $('.loading-spinner-container').show();
            }

            // Menyembunyikan loading spinner
            function hideLoading() {
                $('.loading-spinner-container').hide();
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                        .attr('content')
                }
            });

            $.ajax({
                url: "{{ route('validasi_itemcode') }}",
                type: "get",
                data: {
                    itemcodeChutter: itemcodeChutter,
                    exitkanban: exitkanban,
                    exitSeq: exitSeq
                },
                dataType: 'json',
                beforeSend: function() {
                    showLoading
                        (); // Memanggil fungsi showLoading sebelum request
                },
                success: function(data) {
                    if (data == "") {
                        hideLoading();
                        // Handle case when data is not found
                        $('#itemcodeChutter').val("");
                        $('#itemcodeLokal').val("");
                        $('#input1').val("");
                        $('#input1').focus();
                        $('#input2').val("");
                        if ("vibrate" in navigator) {
                            navigator.vibrate([1000]);
                        }
                        document.getElementById('Audioerror')
                            .play();
                        Swal.fire({
                            icon: 'error',
                            timer: 2000,
                            title: 'Error',
                            text: 'Chutter Not Found',
                        });
                    } else {
                        hideLoading();
                        // Handle case when data is found
                        var itemcodeChutter = $(
                            '#itemcodeChutter').val();
                        document.getElementById(
                            "chutter_address").value = data;
                        // var dataChutteradress = $('#chutter_address').val();
                        // // alert(dataChutteradress);
                        // var sequence = $('#sequence').val();

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $(
                                        'meta[name="csrf-token"]'
                                    )
                                    .attr('content')
                            }
                        });

                        $.ajax({
                            url: "{{ route('add_chutteraddress') }}",
                            type: "POST",
                            data: $('#formChutter')
                                .serialize(),
                            dataType: 'json',
                            beforeSend: function() {
                                showLoading
                                    (); // Memanggil fungsi showLoading sebelum request
                            },
                            success: function(data) {
                                if (data.message ===
                                    "first_date") {
                                    hideLoading();
                                    input1.attr(
                                        "readonly",
                                        false);
                                    $('#itemcodeChutter')
                                        .val("");
                                    $('#itemcodeLokal')
                                        .val("");
                                    document
                                        .getElementById(
                                            "divLokal"
                                        )
                                        .style
                                        .display =
                                        "block";
                                    document
                                        .getElementById(
                                            "divChutter"
                                        ).style
                                        .display =
                                        "none";
                                    document
                                        .getElementById(
                                            'Audiosucces'
                                        )
                                        .play();
                                    input1.focus();
                                    input1.val("");
                                    input2.val("");
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'KANBAN SIMPAN DI DEPAN',
                                        text: 'Data Saved Successfully',
                                    });
                                    input1.focus();
                                    $('#tblChutter')
                                        .DataTable()
                                        .clear()
                                        .draw();

                                } else if (data
                                    .message ===
                                    "end_date") {
                                    hideLoading();
                                    input1.attr(
                                        "readonly",
                                        false);
                                    $('#itemcodeChutter')
                                        .val("");
                                    $('#itemcodeLokal')
                                        .val("");
                                    document
                                        .getElementById(
                                            "divLokal"
                                        )
                                        .style
                                        .display =
                                        "block";
                                    document
                                        .getElementById(
                                            "divChutter"
                                        ).style
                                        .display =
                                        "none";
                                    document
                                        .getElementById(
                                            'Audiosucces'
                                        )
                                        .play();
                                    input1.focus();
                                    input1.val("");
                                    input2.val("");
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'KANBAN SIMPAN DI BELAKANG \nTGL: ' +
                                            data
                                            .formattedDateForDatabase,
                                        text: 'Data Saved Successfully',
                                    });
                                    input1.focus();
                                    $('#tblChutter')
                                        .DataTable()
                                        .clear()
                                        .draw();
                                } else if (data
                                    .message ===
                                    "kanban_error"
                                ) {
                                    hideLoading();
                                    input1.attr(
                                        "readonly",
                                        false);
                                    $('#itemcodeChutter')
                                        .val("");
                                    $('#itemcodeLokal')
                                        .val("");
                                    document
                                        .getElementById(
                                            "divLokal"
                                        )
                                        .style
                                        .display =
                                        "block";
                                    document
                                        .getElementById(
                                            "divChutter"
                                        ).style
                                        .display =
                                        "none";
                                    if ("vibrate" in
                                        navigator) {
                                        navigator
                                            .vibrate(
                                                [
                                                    1000
                                                ]
                                            );
                                    }
                                    document
                                        .getElementById(
                                            'Audioerror'
                                        )
                                        .play();
                                    input1.focus();
                                    input1.val("");
                                    input2.val("");
                                    swal.fire({
                                        icon: 'error',
                                        timer: 2000,
                                        title: 'Error',
                                        text: 'Kanban error is not standard ',
                                    });
                                    input1.focus();
                                    $('#tblChutter')
                                        .DataTable()
                                        .clear()
                                        .draw();
                                } else {
                                    // notif bergetar
                                    input1.attr(
                                        "readonly",
                                        false);
                                    $('#itemcodeChutter')
                                        .val("");
                                    $('#itemcodeLokal')
                                        .val("");
                                    hideLoading();
                                    if ("vibrate" in
                                        navigator) {
                                        navigator
                                            .vibrate(
                                                [
                                                    1000
                                                ]
                                            );
                                    }
                                    document
                                        .getElementById(
                                            'Audioerror'
                                        )
                                        .play();
                                    input1.focus();
                                    input1.val("");
                                    input2.val("");
                                    swal.fire({
                                        icon: 'error',
                                        timer: 2000,
                                        title: 'Error',
                                        text: 'Data Not Found',
                                    });
                                }
                            },
                            // error: function(xhr, status, error) {
                            //     // Handle error message
                            //     // var err = xhr.responseJSON.message;
                            //     // console.log(err);
                            //     // alert(err);
                            //     hideLoading();
                            //     input1.attr("readonly", false);
                            //     $('#itemcodeChutter').val("");
                            //     $('#itemcodeLokal').val("");
                            //     document.getElementById("divLokal")
                            //         .style.display =
                            //         "block";
                            //     document.getElementById(
                            //             "divChutter").style
                            //         .display = "none";
                            //     document.getElementById('Audioerror')
                            //         .play();
                            //     if ("vibrate" in
                            //         navigator) {
                            //         navigator.vibrate([
                            //             1000
                            //         ]);
                            //     }
                            //     input1.focus();
                            //     input1.val("");
                            //     input2.val("");
                            //     swal.fire({
                            //         icon: 'error',
                            //         timer: 2000,
                            //         title: 'Error',
                            //         text: 'Server Error',
                            //     });
                            //     input1.focus();
                            //     $('#tblChutter').DataTable().clear()
                            //         .draw();
                            // }
                        });
                    }
                },
            });
        }
        reset.on("click", function() {
            // Kode di bawah ini akan mengembalikan tampilan ke kondisi semula
            $('#tblChutter').DataTable().clear().draw();
            // Menampilkan divLokal
            document.getElementById("divLokal").style.display =
                "block";

            // Sembunyikan divChutter
            document.getElementById("divChutter").style.display =
                "none";

            // Fokuskan input1
            input1.focus();

            // Kosongkan nilai input1
            input1.val("");

            // Kosongkan nilai input2
            input2.val("");
        });

        // button add to inputan chutter
        var isChutterActive = false;

        document.getElementById("addChutter").addEventListener("click",
            function() {
                // Toggle status
                isChutterActive = !isChutterActive;

                if (isChutterActive) {
                    // Sembunyikan divLokal dan fokuskan input2
                    document.getElementById("divLokal").style.display =
                        "none";
                    document.getElementById("divChutter").style
                        .display = "block";
                    document.getElementById("input2").focus();
                    document.getElementById("input1").value =
                        ""; // Bersihkan nilai input1
                } else {
                    // Tampilkan divLokal, sembunyikan divChutter, dan fokuskan input1
                    document.getElementById("divLokal").style.display =
                        "block";
                    document.getElementById("divChutter").style
                        .display = "none";
                    document.getElementById("input1").focus();
                    document.getElementById("input2").value =
                        ""; // Bersihkan nilai input2
                }
            });

        // // Fungsi untuk mereload halaman
        // function reloadPage() {
        //     location.reload(true);
        // }

        // let inactivityTimeout;

        // // Fungsi untuk memulai timer inaktivitas
        // function startInactivityTimer() {
        //     inactivityTimeout = setTimeout(reloadPage, 10 * 60 *
        //         1000); // Setelah 10 menit, panggil fungsi reloadPage
        // }

        // // Fungsi untuk mereset timer inaktivitas
        // function resetInactivityTimer() {
        //     clearTimeout(inactivityTimeout); // Hentikan timer sebelumnya (jika ada)
        //     startInactivityTimer(); // Mulai ulang timer inaktivitas
        // }

        // // Event listener untuk setiap aksi pengguna (misalnya, klik, keypress, focus, input)
        // document.addEventListener('click', resetInactivityTimer);
        // document.addEventListener('keypress', resetInactivityTimer);

        // // Event listener untuk menanggapi tekanan tombol "Enter"
        // document.addEventListener('keydown', function(event) {
        //     if (event.key === 'Enter') {
        //         resetInactivityTimer
        //             (); // Jika tombol yang ditekan adalah "Enter", reset timer inaktivitas
        //     }
        // });

        // // Mulai timer inaktivitas saat halaman dimuat
        // startInactivityTimer();

        // Fungsi untuk mengecek apakah mode layar penuh didukung
        // Fungsi untuk mengecek apakah mode layar penuh didukung
    });
</script>
