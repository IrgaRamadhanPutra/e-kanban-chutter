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
                    if (value.includes(',')) {
                        var spliteData1 = value.split(',');
                        if (spliteData1.length === 7 || spliteData1.length === 8) {
                            if (spliteData1.length === 7) {
                                if (spliteData1.length > 1) {
                                    // var getItemcodelocal = spliteData1[3];
                                    // $("#itemcodeLokal").val(getItemcodelocal);
                                    // var itemLokal = $('#itemcodeLokal').val();
                                    addDataToTable(spliteData1);
                                } else {
                                    input1.val("");
                                    input1.attr('readonly', false);
                                }
                            } else if (spliteData1.length === 8) {
                                if (spliteData1.length > 1) {
                                    // var getItemcodelocal = spliteData1[4];
                                    // $("#itemcodeLokal").val(getItemcodelocal);
                                    // var itemLokal = $('#itemcodeLokal').val();
                                    addDataToTable2(spliteData1);
                                } else {
                                    input1.val("");
                                    input1.attr('readonly', false);
                                }
                            }
                        } else {
                            // Situasi ketika panjang data tidak sama dengan 7 atau 8
                            input1.val("");
                            $('#input1').focus();
                        }
                    } else {
                        // Situasi ketika tidak ada koma dalam value
                        input1.val("");

                        $('#input1').focus();
                    }

                } else {
                    reset.removeClass("d-none")
                }

                return false;
            }
        });


        /* ajax no fifo */
        // funtion add to tabel koma 7
        function addDataToTable(spliteData1) {
            var getSquence = spliteData1[1];
            var getPartno = spliteData1[2];
            var getItemcode = spliteData1[3];
            var getKanban = spliteData1[0];
            var getQty = spliteData1[4];
            var getCustcode = spliteData1[5];
            // console.log(spliteData1);
            var table = $("#tblChutter").DataTable();

            function showLoading() {
                $('.loading-spinner-container').show();
            }

            function hideLoading() {
                $('.loading-spinner-container').hide();
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('validasi_access_account3') }}",
                type: "get",
                data: {
                    getCustcode
                },
                dataType: 'json',
                beforeSend: function() {
                    showLoading(); // Call showLoading before the request
                },
                success: function(response) {
                    // alert('hiden awal');
                    hideLoading(); // Hide loading spinner after the request

                    // Check the message in the response
                    if (response.message === "success") {
                        // Handle the success case
                        // alert("Success");
                        if (table.data().count() === 0) {
                            // validasi to ekanban_fgout
                            validasiEkanbanchuterout(getSquence, getItemcode, getPartno, getKanban,
                                getQty);
                        } else {
                            // validasi data kosong
                            // partno harus sama
                            // Tabel tidak kosong, periksa apakah Part No sudah ada dalam tabel
                            var partNoExists = false;
                            table.rows().every(function() {
                                var rowData = this.data();

                                var existingPartNo = rowData[1];
                                var valuePartno = $(existingPartNo).val();
                                if (valuePartno == getPartno) {
                                    partNoExists = true;
                                    return false; // Exit the loop if a matching Part No is found
                                }
                            });
                            // jika data nya sama
                            if (partNoExists) {
                                // squnece tidak boleh sama maka di buat kan validasi
                                var sq = true;
                                table.rows().every(function() {
                                    var rowData = this.data();
                                    // console.log(rowData);
                                    var exitingSq = rowData[2];
                                    // console.log(exitingSq);
                                    var valueSq = $(exitingSq).val();
                                    // console.log(valueSq);
                                    // console.log(getSquence);
                                    if (valueSq == getSquence) {
                                        sq = false;
                                    }
                                });
                                // jika squence nya tidak sama
                                // console.log(sq);
                                if (sq) {
                                    // alert('Squence tidak sama');
                                    // validasi tabel ekanban_fgout
                                    validasiEkanbanchuterout(getSquence, getItemcode, getPartno,
                                        getKanban,
                                        getQty);

                                } else {
                                    // jika squence nya sama
                                    // alert('error squence sama');
                                    // notif bergetar
                                    // hideLoading();
                                    if ("vibrate" in navigator) {
                                        navigator.vibrate([1000]);
                                    }
                                    document.getElementById('Audioerror').play();
                                    swal.fire({
                                        icon: 'error',
                                        title: 'Squence Tidak Boleh Sama',
                                        text: 'Squence Sudah di Scan',
                                        showConfirmButton: true, // Show OK button
                                        // timer: 2000, // Display for 2 seconds
                                    });
                                    input1.val("");
                                    input1.attr('readonly', false);
                                    $('#input1').focus();
                                }
                            } else {
                                // jika data nya tidak sama
                                // alert('partno tidak sama');
                                // hideLoading();
                                input1.val("");
                                input1.attr('readonly', false);
                                $('#input1').focus();
                                // notif bergetar
                                if ("vibrate" in navigator) {
                                    navigator.vibrate([1000]);
                                }
                                document.getElementById('Audioerror').play();
                                swal.fire({
                                    icon: 'error',
                                    title: 'Part No Tidak Sama',
                                    text: 'Part No Tidak Sama',
                                    showConfirmButton: true, // Show OK button
                                    // timer: 2000, // Display for 2 seconds
                                });
                            }
                        }
                        // allValidasi(getItemcode, getSquence, getPartno, getItemcode, getQty,
                        //     getKanban);
                        // Additional actions for success
                    } else if (response.message === "error") {
                        // Handle the error case
                        // console.error("Error:", response.detail);
                        // Additional actions for error
                        hideLoading();
                        // alert('data tidak ada');
                        if ("vibrate" in navigator) {
                            navigator.vibrate([1000]);
                        }
                        document.getElementById('Audioerror').play();
                        swal.fire({
                            icon: 'error',
                            title: 'User Not Found',
                            text: response.detail,
                            showConfirmButton: true,
                            // timer: 2000, // Display for 2 seconds
                        });
                        input1.val("");
                        input1.focus();
                    }
                },
            });
        }


        // add to table for koma 8
        function addDataToTable2(spliteData1) {
            var getKanban = spliteData1[1];
            var getSquence = spliteData1[2];
            var getPartno = spliteData1[3];
            var getItemcode = spliteData1[4];
            var getQty = spliteData1[5];
            var getCustcode = spliteData1[6];
            var table = $("#tblChutter").DataTable();

            function showLoading() {
                $('.loading-spinner-container').show();
            }

            function hideLoading() {
                $('.loading-spinner-container').hide();
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('validasi_access_account4') }}",
                type: "get",
                data: {
                    getCustcode
                },
                dataType: 'json',
                beforeSend: function() {
                    showLoading(); // Show loading before request
                },
                success: function(response) {
                    hideLoading(); // Hide loading spinner after the request

                    // Check the message in the response
                    if (response.message === "success") {
                        // Handle the success case
                        // alert("Success");
                        if (table.data().count() === 0) {
                            // validasi to ekanban_fgout
                            validasiEkanbanchuterout(getSquence, getItemcode, getPartno, getKanban,
                                getQty);

                        } else {
                            // validasi data kosong
                            // partno harus sama untuk kanban yamaha
                            var partNoExists = false;
                            table.rows().every(function() {
                                var rowData = this.data();

                                var existingPartNo = rowData[1];
                                var valuePartno = $(existingPartNo).val();
                                if (valuePartno == getPartno) {
                                    partNoExists = true;
                                    return false; // Exit the loop if a matching Part No is found
                                }
                            });
                            // jika data nya sama => yamaha
                            if (partNoExists) {

                                // squnece tidak boleh sama maka di buat kan validasi
                                var sq = true;
                                table.rows().every(function() {
                                    var rowData = this.data();
                                    var exitingSq = rowData[2];
                                    var valueSq = $(exitingSq).val();
                                    if (valueSq == getSquence) {
                                        sq = false;
                                    }
                                });
                                // jika squence nya tidak sama
                                if (sq) {
                                    // alert('Squence tidak sama');
                                    // validasi tabel ekanban_fgout

                                    validasiEkanbanchuterout(getSquence, getItemcode, getPartno,
                                        getKanban, getQty);

                                } else {
                                    hideLoading();
                                    // jika squence nya sama
                                    // alert('error squence sama');
                                    // notif bergetar
                                    if ("vibrate" in navigator) {
                                        navigator.vibrate([1000]);
                                    }
                                    document.getElementById('Audioerror').play();
                                    swal.fire({
                                        icon: 'error',
                                        title: 'Squence Tidak Boleh Sama',
                                        text: 'Squence Sudah di Scan',
                                        showConfirmButton: true, // Show OK button
                                        // timer: 2000, // Display for 2 seconds
                                    });
                                    input1.val("");
                                    input1.attr('readonly', false);
                                    $('#input1').focus();
                                }

                            } else {
                                // jika data nya tidak sama
                                hideLoading();
                                input1.val("");
                                input1.attr('readonly', false);
                                $('#input1').focus();
                                // notif bergetar
                                if ("vibrate" in navigator) {
                                    navigator.vibrate([1000]);
                                }
                                document.getElementById('Audioerror').play();
                                swal.fire({
                                    icon: 'error',
                                    title: 'Part No Tidak Sama',
                                    text: 'Part No Tidak Sama',
                                    showConfirmButton: true, // Show OK button
                                    // timer: 2000, // Display for 2 seconds
                                });
                            }

                        }

                        // Additional actions for success
                    } else if (response.message === "error") {
                        // Handle the error case
                        // console.error("Error:", response.detail);
                        // Additional actions for error
                        hideLoading();
                        // alert('data tidak ada');
                        if ("vibrate" in navigator) {
                            navigator.vibrate([1000]);
                        }
                        document.getElementById('Audioerror').play();
                        swal.fire({
                            icon: 'error',
                            title: 'User Not Found',
                            text: response.detail,
                            showConfirmButton: true,
                            // timer: 2000, // Display for 2 seconds
                        });
                        input1.val("");
                        input1.focus();
                    }
                },
            });
        }

        // validasi ekanban chuter out
        function validasiEkanbanchuterout(getSquence, getItemcode, getPartno, getKanban, getQty) {
            function showLoading() {
                $('.loading-spinner-container').show();
            }

            // Menyembunyikan loading spinner
            function hideLoading() {
                $('.loading-spinner-container').hide();
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('validasi_itemcode_fgout') }}",
                type: "get",
                data: {
                    getSquence: getSquence,
                    getItemcode: getItemcode
                },
                dataType: 'json',
                beforeSend: function() {
                    showLoading(); // Call showLoading function before request
                },
                success: function(data) {
                    // alert('hiden 1');
                    hideLoading();
                    if (data == "") {
                        // Validation for chutter address
                        validateChuterrAddress(getSquence, getItemcode, getPartno, getKanban,
                            getQty)
                    } else {
                        // Notify user of error
                        if ("vibrate" in navigator) {
                            navigator.vibrate([1000]);
                        }
                        document.getElementById('Audioerror').play();
                        swal.fire({
                            icon: 'error',
                            title: 'DATA SUDAH OUT CHUTER',
                            text: 'Data Already Exist',
                            showConfirmButton: true
                        });
                        input1.val("");
                        $('#input1').focus();
                    }
                }
            });
        }

        // validateChuterrAddress
        function validateChuterrAddress(getSquence, getItemcode, getPartno, getKanban, getQty) {
            function showLoading() {
                $('.loading-spinner-container').show();
            }

            // Menyembunyikan loading spinner
            function hideLoading() {
                $('.loading-spinner-container').hide();
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('validasi_chuterr_address') }}",
                type: "get",
                data: {
                    getSquence: getSquence,
                    getItemcode: getItemcode
                },
                dataType: 'json',
                beforeSend: function() {
                    showLoading(); // Call showLoading function before request
                },
                success: function(response) {
                    hideLoading();
                    if (response != "") {
                        var t = $('#tblChutter').DataTable();
                        var counter = t.rows().count();
                        var jml_row = Number(counter) + 1;

                        // Create unique identifiers for each field
                        var Itemcode = "Itemcode" + jml_row;
                        var part_no = "part_no" + jml_row;
                        var Squence = "Squence" + jml_row;
                        var Kanban = "Kanban" + jml_row;
                        var Qty = "Qty" + jml_row;

                        // Add new row to DataTable
                        t.row.add([
                            '<input type="text" class="text-center" id="' + Itemcode +
                            '" name="Itemcode[]" value="' + getItemcode + '" readonly>',
                            '<input type="text" class="text-center" id="' + part_no +
                            '" name="part_no[]" value="' + getPartno + '" readonly>',
                            '<input type="text" class="text-center" id="' + Squence +
                            '" name="Squence[]" value="' + getSquence + '" readonly>',
                            '<input type="text" class="text-center" id="' + Kanban +
                            '" name="Kanban[]" value="' + getKanban + '" >',
                            '<input type="text" class="text-center" id="' + Qty +
                            '" name="Qty[]" value="' + getQty + '" >'
                        ]).draw();

                        input1.val("");
                        input1.attr('readonly', false);
                        $('#input1').focus();
                    } else {
                        if ("vibrate" in navigator) {
                            navigator.vibrate([1000]);
                        }
                        document.getElementById('Audioerror').play();
                        swal.fire({
                            icon: 'error',
                            title: 'Data Not Found',
                            text: 'Kanban Belum In Chuter',
                            showConfirmButton: true
                        });
                        input1.val("");
                        $('#input1').focus();
                    }
                }
            });
        }




        /* ajax fifo */
        /*   // funtion add to tabel koma 7
          function addDataToTable(spliteData1) {
              var getSquence = spliteData1[1];
              var getPartno = spliteData1[2];
              var getItemcode = spliteData1[3];
              var getKanban = spliteData1[0];
              var getQty = spliteData1[4];
              var table = $("#tblChutter").DataTable();

              if (table.data().count() === 0) {
                  function showLoading() {
                      $('.loading-spinner-container').show();
                  }

                  // Menyembunyikan loading spinner
                  function hideLoading() {
                      $('.loading-spinner-container').hide();
                  }
                  // validasi to ekanban_fgout
                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                              'content')
                      }
                  });
                  $.ajax({
                      url: "{{ route('validasi_itemcode_fgout') }}",
                      type: "get",
                      data: {
                          getSquence: getSquence,
                          getItemcode: getItemcode
                      }, // Data yang akan dikirim ke server
                      dataType: 'json',
                      beforeSend: function() {
                          showLoading(); // Memanggil fungsi showLoading sebelum request
                      },
                      success: function(data) {
                          if (data == "") {
                              hideLoading();
                              // validasi chutter address
                              $.ajaxSetup({
                                  headers: {
                                      'X-CSRF-TOKEN': $(
                                              'meta[name="csrf-token"]')
                                          .attr(
                                              'content')
                                  }
                              });
                              $.ajax({
                                  url: "{{ route('validasi_chuterr_address') }}",
                                  type: "get",
                                  data: {
                                      getSquence: getSquence,
                                      getItemcode: getItemcode,

                                  }, // Data yang akan dikirim ke server
                                  dataType: 'json',
                                  beforeSend: function() {
                                      showLoading
                                          (); // Memanggil fungsi showLoading sebelum request
                                  },
                                  success: function(response) {
                                      if (response != "") {
                                          // alert('data ada');
                                          hideLoading();
                                          // alert('lanjut validasi fgin');
                                          // validasi fg in get fifo data
                                          $.ajaxSetup({
                                              headers: {
                                                  'X-CSRF-TOKEN': $(
                                                      'meta[name="csrf-token"]'
                                                  ).attr(
                                                      'content')
                                              }
                                          });
                                          $.ajax({
                                              url: "{{ route('validasi_fifo_lokal') }}",
                                              type: "get",
                                              data: {
                                                  getSquence: getSquence,
                                                  getItemcode: getItemcode,
                                                  getKanban: getKanban
                                              }, // Data yang akan dikirim ke server
                                              dataType: 'json',
                                              beforeSend: function() {
                                                  showLoading
                                                      (); // Memanggil fungsi showLoading sebelum request
                                              },
                                              success: function(response) {
                                                  // console.log(response);

                                                  if (response.message ===
                                                      "success") {
                                                      hideLoading();
                                                      // Data cocok, lakukan sesuatu dengan response.data
                                                      // alert('data sama');
                                                      // alert('masukan data ke table');
                                                      // Tabel kosong, langsung tambahkan data
                                                      var t = $('#tblChutter')
                                                          .DataTable();
                                                      var counter = t.rows()
                                                          .count();
                                                      var jml_row = Number(
                                                          counter) + 1;
                                                      var Itemcode =
                                                          "Itemcode" +
                                                          jml_row;
                                                      var part_no =
                                                          "part_no" + jml_row;
                                                      var Squence =
                                                          "Squence" + jml_row;
                                                      var Kanban = "Kanban" +
                                                          jml_row;
                                                      var Qty = "Qty" +
                                                          jml_row;
                                                      t.row.add([
                                                          '<input type="text" class=" text-center" id="' +
                                                          Itemcode +
                                                          '" name="Itemcode[]" value="' +
                                                          getItemcode +
                                                          '" readonly>',
                                                          '<input type="text" class=" text-center" id="' +
                                                          part_no +
                                                          '" name="part_no[]" value="' +
                                                          getPartno +
                                                          '" readonly>',
                                                          '<input type="text" class=" text-center" id="' +
                                                          Squence +
                                                          '" name="Squence[]" value="' +
                                                          getSquence +
                                                          '" readonly>',
                                                          '<input type="text" class=" text-center" id="' +
                                                          Kanban +
                                                          '" name="Kanban[]" value="' +
                                                          getKanban +
                                                          '" >',
                                                          '<input type="text" class=" text-center" id="' +
                                                          Qty +
                                                          '" name="Qty[]" value="' +
                                                          getQty +
                                                          '" >',
                                                      ]).draw();
                                                      input1.val("");
                                                      input1.attr('readonly',
                                                          false);
                                                      $('#input1').focus();
                                                  } else if (response
                                                      .message === "error") {
                                                      hideLoading();
                                                      // Data tidak cocok, tampilkan pesan error
                                                      // alert('error');
                                                      $('#input1').focus();
                                                      input1.val("");
                                                      // $('#input1').focus();
                                                      // notif bergetar
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
                                                          // timer: 2000,
                                                          title: 'FIFO NOT FOUND',
                                                          text: `Kanban No: ${response.data.kanban_no}, Date: ${response.date}`,
                                                      });
                                                  } else {
                                                      hideLoading();
                                                      swal.fire({
                                                          icon: 'error',
                                                          // timer: 2000,
                                                          title: 'DATA NOT FOUND',

                                                      });
                                                  }

                                              }

                                          })
                                      } else {
                                          hideLoading();
                                          // alert('data not found');
                                          // notif bergetar
                                          if ("vibrate" in navigator) {
                                              navigator.vibrate([1000]);
                                          }
                                          document.getElementById('Audioerror').play();
                                          swal.fire({
                                              icon: 'error',
                                              title: 'Data Not Found',
                                              text: 'Kanban Belum In Chuter',
                                              showConfirmButton: true, // Menampilkan tombol OK
                                              // timer: 2000, // Menampilkan selama 2 detik
                                          });
                                          input1.val("");
                                          $('#input1').focus();
                                      }
                                  }
                              })

                          } else {
                              hideLoading();
                              // alert('eror data ada pada fgout');
                              // notif bergetar
                              if ("vibrate" in navigator) {
                                  navigator.vibrate([1000]);
                              }
                              document.getElementById('Audioerror').play();
                              swal.fire({
                                  icon: 'error',
                                  title: 'DATA SUDAH OUT CHUTER',
                                  text: 'Data Already Exist',
                                  showConfirmButton: true, // Menampilkan tombol OK
                                  // timer: 2000, // Menampilkan selama 2 detik
                              });
                              input1.val("");
                              $('#input1').focus();
                          }
                      }

                  })
              } else {
                  function showLoading() {
                      $('.loading-spinner-container').show();
                  }

                  // Menyembunyikan loading spinner
                  function hideLoading() {
                      $('.loading-spinner-container').hide();
                  }
                  // validasi data kosong
                  // partno harus sama
                  // Tabel tidak kosong, periksa apakah Part No sudah ada dalam tabel
                  var partNoExists = false;
                  table.rows().every(function() {
                      var rowData = this.data();

                      var existingPartNo = rowData[1];
                      var valuePartno = $(existingPartNo).val();
                      if (valuePartno == getPartno) {
                          partNoExists = true;
                          return false; // Keluar dari perulangan jika sudah ditemukan Part No yang cocok
                      }
                  });
                  // jika data nya sama
                  if (partNoExists) {
                      // squnece tidak boleh sama maka di buat kan validasi
                      var sq = true;
                      table.rows().every(function() {
                          var rowData = this.data();
                          // console.log(rowData);
                          var exitingSq = rowData[2];
                          // console.log(exitingSq);
                          var valueSq = $(exitingSq).val();
                          // console.log(valueSq);
                          // console.log(getSquence);
                          if (valueSq == getSquence) {
                              sq = false;
                          }
                      });
                      // jika squence nya tidak sama
                      // console.log(sq);
                      if (sq) {
                          function showLoading() {
                              $('.loading-spinner-container').show();
                          }

                          // Menyembunyikan loading spinner
                          function hideLoading() {
                              $('.loading-spinner-container').hide();
                          }
                          // alert('Squence tidak sama');
                          // validasi tabel ekanban_fgout
                          $.ajaxSetup({
                              headers: {
                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                      'content')
                              }
                          });
                          $.ajax({
                              url: "{{ route('validasi_itemcode_fgout1') }}",
                              type: "get",
                              data: {
                                  getSquence: getSquence,
                                  getItemcode: getItemcode
                              }, // Data yang akan dikirim ke server
                              dataType: 'json',
                              beforeSend: function() {
                                  showLoading
                                      (); // Memanggil fungsi showLoading sebelum request
                              },
                              success: function(data) {
                                  // data tidak ada di tabel ekanbanfgout
                                  if (data == "") {
                                      hideLoading();
                                      // validasi  chutter_chutter addres for inputan 1
                                      $.ajaxSetup({
                                          headers: {
                                              'X-CSRF-TOKEN': $(
                                                      'meta[name="csrf-token"]')
                                                  .attr(
                                                      'content')
                                          }
                                      });
                                      $.ajax({
                                          url: "{{ route('validasi_chuterr_address1') }}",
                                          type: "get",
                                          data: {
                                              getSquence: getSquence,
                                              getItemcode: getItemcode,

                                          }, // Data yang akan dikirim ke server
                                          dataType: 'json',
                                          beforeSend: function() {
                                              showLoading
                                                  (); // Memanggil fungsi showLoading sebelum request
                                          },
                                          success: function(response) {
                                              if (response != "") {
                                                  hideLoading();
                                                  // alert('data ada');
                                                  var lastIndex = table.rows().count() -
                                                      1; // Mendapatkan indeks baris terakhir
                                                  var lastRowData = table.row(lastIndex)
                                                      .data();
                                                  var exitingItem = lastRowData[0];
                                                  var exitingKanban = lastRowData[3];
                                                  var exitingSq = lastRowData[2];
                                                  var valueItem = $(exitingItem).val();
                                                  var valueSq = $(exitingSq).val();
                                                  var valueKanban = $(exitingKanban)
                                              .val();
                                                  // console.log(lastRowData);
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
                                                      url: "{{ route('validasi_fifo_lokal1') }}",
                                                      type: "get",
                                                      data: {
                                                          getSquence: getSquence,
                                                          getItemcode: getItemcode,
                                                          getKanban: getKanban,
                                                          tabelSquence: valueSq,
                                                          tabelItemcode: valueItem,
                                                          tabelKanban: valueKanban
                                                      }, // Data yang akan dikirim ke server
                                                      dataType: 'json',
                                                      beforeSend: function() {
                                                          showLoading
                                                              (); // Memanggil fungsi showLoading sebelum request
                                                      },
                                                      success: function(
                                                          response) {
                                                          // console.log(
                                                          //     response);
                                                          if (response
                                                              .message ===
                                                              "success") {
                                                              hideLoading();
                                                              // Data cocok, lakukan sesuatu dengan response.data
                                                              var t = $(
                                                                      '#tblChutter'
                                                                  )
                                                                  .DataTable();
                                                              var counter = t
                                                                  .rows()
                                                                  .count();
                                                              var jml_row =
                                                                  Number(
                                                                      counter
                                                                  ) + 1;
                                                              var Itemcode =
                                                                  "Itemcode" +
                                                                  jml_row;
                                                              var part_no =
                                                                  "part_no" +
                                                                  jml_row;
                                                              var Squence =
                                                                  "Squence" +
                                                                  jml_row;
                                                              var Kanban =
                                                                  "Kanban" +
                                                                  jml_row;
                                                              var Qty =
                                                                  "Qty" +
                                                                  jml_row;
                                                              t.row.add([
                                                                  '<input type="text" class=" text-center" id="' +
                                                                  Itemcode +
                                                                  '" name="Itemcode[]" value="' +
                                                                  getItemcode +
                                                                  '" readonly>',
                                                                  '<input type="text" class=" text-center" id="' +
                                                                  part_no +
                                                                  '" name="part_no[]" value="' +
                                                                  getPartno +
                                                                  '" readonly>',
                                                                  '<input type="text" class=" text-center" id="' +
                                                                  Squence +
                                                                  '" name="Squence[]" value="' +
                                                                  getSquence +
                                                                  '" readonly>',
                                                                  '<input type="text" class=" text-center" id="' +
                                                                  Kanban +
                                                                  '" name="Kanban[]" value="' +
                                                                  getKanban +
                                                                  '" >',
                                                                  '<input type="text" class=" text-center" id="' +
                                                                  Qty +
                                                                  '" name="Qty[]" value="' +
                                                                  getQty +
                                                                  '" >',
                                                              ]).draw();

                                                              input1.val("");
                                                              input1.attr(
                                                                  'readonly',
                                                                  false);
                                                              $('#input1')
                                                                  .focus();

                                                              input1.val("");
                                                              input1.attr(
                                                                  'readonly',
                                                                  false);
                                                              $('#input1')
                                                                  .focus();
                                                          } else if (response
                                                              .message ===
                                                              "error") {
                                                              hideLoading();
                                                              // Data tidak cocok, tampilkan pesan error
                                                              // console.log(response
                                                              //     .data
                                                              // );
                                                              input1.val("");
                                                              $('#input1')
                                                                  .focus();
                                                              // notif bergetar
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
                                                              // alert('error');
                                                              swal.fire({
                                                                  icon: 'error',
                                                                  title: 'TANGGAL TIDAK SAMA',
                                                                  text: `Kanban No: ${response.data.kanban_no}, Date: ${response.date}`,
                                                              }); // Ini akan mencetak data yang tidak cocok ke konsol
                                                          }
                                                      }
                                                  })
                                              } else {
                                                  // alert('chutter kosong');
                                                  // notif bergetar
                                                  hideLoading();
                                                  if ("vibrate" in navigator) {
                                                      navigator.vibrate([1000]);
                                                  }
                                                  document.getElementById('Audioerror')
                                                      .play();
                                                  swal.fire({
                                                      icon: 'error',
                                                      title: 'Data Not Found',
                                                      text: 'Kanban Belum In Chuter',
                                                      showConfirmButton: true, // Menampilkan tombol OK
                                                      // timer: 2000, // Menampilkan selama 2 detik
                                                  });
                                                  input1.val("");
                                                  $('#input1').focus();
                                              }
                                          }
                                      })
                                      // alert('data kosong');
                                  } else {
                                      // alert('data ada fgout');
                                      // notif bergetar
                                      hideLoading();
                                      if ("vibrate" in navigator) {
                                          navigator.vibrate([1000]);
                                      }
                                      document.getElementById('Audioerror').play();
                                      swal.fire({
                                          icon: 'error',
                                          title: 'DATA SUDAH OUT CHUTER',
                                          text: 'Data Already Exist',
                                          showConfirmButton: true, // Menampilkan tombol OK
                                          // timer: 2000, // Menampilkan selama 2 detik
                                      });
                                      input1.val("");
                                      input1.attr('readonly', false);
                                      $('#input1').focus();
                                  }
                              }

                          })
                      } else {
                          // jika squence nya sama
                          // alert('error squence sama');
                          // notif bergetar
                          // hideLoading();
                          if ("vibrate" in navigator) {
                              navigator.vibrate([1000]);
                          }
                          document.getElementById('Audioerror').play();
                          swal.fire({
                              icon: 'error',
                              title: 'Squence Tidak Boleh Sama',
                              text: 'Squence Sudah di Scan',
                              showConfirmButton: true, // Menampilkan tombol OK
                              // timer: 2000, // Menampilkan selama 2 detik
                          });
                          input1.val("");
                          input1.attr('readonly', false);
                          $('#input1').focus();
                      }
                  } else {
                      // jika data nya tidak sama
                      // alert('partno tidak sama');
                      // hideLoading();
                      input1.val("");
                      input1.attr('readonly', false);
                      $('#input1').focus();
                      // notif bergetar
                      if ("vibrate" in navigator) {
                          navigator.vibrate([1000]);
                      }
                      document.getElementById('Audioerror').play();
                      swal.fire({
                          icon: 'error',
                          title: 'Part No Tidak Sama',
                          text: 'Part No Tidak Sama',
                          showConfirmButton: true, // Menampilkan tombol OK
                          // timer: 2000, // Menampilkan selama 2 detik
                      });
                  }

              }
          }


          // add to table for koma 8
          function addDataToTable2(spliteData1) {
              var getKanban = spliteData1[1];
              var getSquence = spliteData1[2];
              var getPartno = spliteData1[3];
              var getItemcode = spliteData1[4];
              var getQty = spliteData1[5];
              var table = $("#tblChutter").DataTable();

              if (table.data().count() === 0) {
                  function showLoading() {
                      $('.loading-spinner-container').show();
                  }

                  // Menyembunyikan loading spinner
                  function hideLoading() {
                      $('.loading-spinner-container').hide();
                  }
                  // validasi to ekanban_fgout
                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                              'content')
                      }
                  });
                  $.ajax({
                      url: "{{ route('validasi_itemcode_fgout2') }}",
                      type: "get",
                      data: {
                          getSquence: getSquence,
                          getItemcode: getItemcode
                      }, // Data yang akan dikirim ke server
                      dataType: 'json',
                      beforeSend: function() {
                          showLoading(); // Memanggil fungsi showLoading sebelum request
                      },
                      success: function(data) {
                          // console.log(data);
                          if (data == "") {
                              // validasi chutter addres
                              hideLoading();
                              $.ajaxSetup({
                                  headers: {
                                      'X-CSRF-TOKEN': $(
                                              'meta[name="csrf-token"]')
                                          .attr(
                                              'content')
                                  }
                              });
                              $.ajax({
                                  url: "{{ route('validasi_chuterr_address2') }}",
                                  type: "get",
                                  data: {
                                      getSquence: getSquence,
                                      getItemcode: getItemcode,

                                  }, // Data yang akan dikirim ke server
                                  dataType: 'json',
                                  beforeSend: function() {
                                      showLoading
                                          (); // Memanggil fungsi showLoading sebelum request
                                  },
                                  success: function(response) {
                                      if (response != "") {
                                          hideLoading();
                                          $.ajaxSetup({
                                              headers: {
                                                  'X-CSRF-TOKEN': $(
                                                      'meta[name="csrf-token"]'
                                                  ).attr(
                                                      'content')
                                              }
                                          });
                                          $.ajax({
                                              url: "{{ route('validasi_fifo_lokal2') }}",
                                              type: "get",
                                              data: {
                                                  getSquence: getSquence,
                                                  getItemcode: getItemcode,
                                                  getKanban: getKanban
                                              }, // Data yang akan dikirim ke server
                                              dataType: 'json',
                                              beforeSend: function() {
                                                  showLoading
                                                      (); // Memanggil fungsi showLoading sebelum request
                                              },
                                              success: function(response) {
                                                  // console.log(response);

                                                  if (response.message ===
                                                      "success") {
                                                      hideLoading();
                                                      // Data cocok, lakukan sesuatu dengan response.data
                                                      // alert('data sama');
                                                      // alert('masukan data ke table');
                                                      // Tabel kosong, langsung tambahkan data
                                                      var t = $('#tblChutter')
                                                          .DataTable();
                                                      var counter = t.rows()
                                                          .count();
                                                      var jml_row = Number(
                                                          counter) + 1;
                                                      var Itemcode =
                                                          "Itemcode" +
                                                          jml_row;
                                                      var part_no =
                                                          "part_no" + jml_row;
                                                      var Squence =
                                                          "Squence" + jml_row;
                                                      var Kanban = "Kanban" +
                                                          jml_row;
                                                      var Qty = "Qty" +
                                                          jml_row;
                                                      t.row.add([
                                                          '<input type="text" class=" text-center" id="' +
                                                          Itemcode +
                                                          '" name="Itemcode[]" value="' +
                                                          getItemcode +
                                                          '" readonly>',
                                                          '<input type="text" class=" text-center" id="' +
                                                          part_no +
                                                          '" name="part_no[]" value="' +
                                                          getPartno +
                                                          '" readonly>',
                                                          '<input type="text" class=" text-center" id="' +
                                                          Squence +
                                                          '" name="Squence[]" value="' +
                                                          getSquence +
                                                          '" readonly>',
                                                          '<input type="text" class=" text-center" id="' +
                                                          Kanban +
                                                          '" name="Kanban[]" value="' +
                                                          getKanban +
                                                          '" >',
                                                          '<input type="text" class=" text-center" id="' +
                                                          Qty +
                                                          '" name="Qty[]" value="' +
                                                          getQty +
                                                          '" >',
                                                      ]).draw();
                                                      input1.val("");
                                                      input1.attr('readonly',
                                                          false);
                                                      $('#input1').focus();
                                                  } else if (response
                                                      .message === "error") {
                                                      hideLoading();
                                                      // Data tidak cocok, tampilkan pesan error
                                                      // alert('error');
                                                      input1.val("");
                                                      $('#input1').focus();
                                                      // notif bergetar
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
                                                          title: 'FIFO NOT FOUND',
                                                          text: `Kanban No: ${response.data.kanban_no}, Date: ${response.date}`,
                                                      });
                                                  }

                                              }

                                          })
                                      } else {
                                          // alert('chutter kosong');
                                          // notif bergetar
                                          if ("vibrate" in navigator) {
                                              navigator.vibrate([1000]);
                                          }
                                          document.getElementById('Audioerror').play();
                                          swal.fire({
                                              icon: 'error',
                                              title: 'Data Not Found',
                                              text: 'Kanban Belum In Chuter',
                                              showConfirmButton: true, // Menampilkan tombol OK
                                              // timer: 2000, // Menampilkan selama 2 detik
                                          });
                                          input1.val("");
                                          $('#input1')
                                      .focus(); // batas untuk adm string 8
                                      }
                                  }
                              })
                              // alert('lanjut validasi fgin');
                              // validasi fg in get fifo data

                          } else {
                              // alert('eror data ada pada fgout');
                              // // notif bergetar
                              hideLoading();
                              if ("vibrate" in navigator) {
                                  navigator.vibrate([1000]);
                              }
                              document.getElementById('Audioerror').play();
                              swal.fire({
                                  icon: 'error',
                                  title: 'DATA SUDAH OUT CHUTER',
                                  text: 'Data Already Exist',
                                  showConfirmButton: true, // Menampilkan tombol OK
                                  // timer: 2000, // Menampilkan selama 2 detik
                              });
                              input1.val("");
                              input1.attr('readonly', false);
                              $('#input1').focus();


                          }
                      }

                  })

              } else {
                  function showLoading() {
                      $('.loading-spinner-container').show();
                  }

                  // Menyembunyikan loading spinner
                  function hideLoading() {
                      $('.loading-spinner-container').hide();
                  }
                  // validasi data kosong
                  // partno harus sama untuk kanban yamaha
                  var partNoExists = false;
                  table.rows().every(function() {
                      var rowData = this.data();

                      var existingPartNo = rowData[1];
                      var valuePartno = $(existingPartNo).val();
                      if (valuePartno == getPartno) {
                          partNoExists = true;
                          return false; // Keluar dari perulangan jika sudah ditemukan Part No yang cocok
                      }
                  });
                  // jika data nya sama => yamaha
                  if (partNoExists) {

                      // squnece tidak boleh sama maka di buat kan validasi
                      var sq = true;
                      table.rows().every(function() {
                          var rowData = this.data();
                          // console.log(rowData);
                          var exitingSq = rowData[2];
                          // console.log(exitingSq);
                          var valueSq = $(exitingSq).val();
                          // console.log(valueSq);
                          // console.log(getSquence);
                          if (valueSq == getSquence) {
                              sq = false;
                          }
                      });
                      // jika squence nya tidak sama
                      // console.log(sq);
                      if (sq) {
                          // alert('Squence tidak sama');
                          // validasi tabel ekanban_fgout
                          $.ajaxSetup({
                              headers: {
                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                      'content')
                              }
                          });
                          $.ajax({
                              url: "{{ route('validasi_itemcode_fgout4') }}",
                              type: "get",
                              data: {
                                  getSquence: getSquence,
                                  getItemcode: getItemcode
                              }, // Data yang akan dikirim ke server
                              dataType: 'json',
                              beforeSend: function() {
                                  showLoading(); // Memanggil fungsi showLoading sebelum request
                              },
                              success: function(data) {
                                  // console.log(data);
                                  // data tidak ada di tabel ekanbanfgout
                                  if (data == "") {
                                      hideLoading();
                                      // validasi chutter address
                                      $.ajaxSetup({
                                          headers: {
                                              'X-CSRF-TOKEN': $(
                                                      'meta[name="csrf-token"]')
                                                  .attr(
                                                      'content')
                                          }
                                      });
                                      $.ajax({
                                          url: "{{ route('validasi_chuterr_address3') }}",
                                          type: "get",
                                          data: {
                                              getSquence: getSquence,
                                              getItemcode: getItemcode,

                                          }, // Data yang akan dikirim ke server
                                          dataType: 'json',
                                          beforeSend: function() {
                                              showLoading
                                                  (); // Memanggil fungsi showLoading sebelum request
                                          },
                                          success: function(response) {
                                              if (response != "") {
                                                  hideLoading();
                                                  // validasi fifo for tabel ekanban_fgin
                                                  // alert('data ada');
                                                  var lastIndex = table.rows().count() -
                                                      1; // Mendapatkan indeks baris terakhir
                                                  var lastRowData = table.row(lastIndex)
                                                      .data();
                                                  var exitingSq = lastRowData[2];
                                                  var exitingKanban = lastRowData[3];
                                                  var exitingItem = lastRowData[0];
                                                  var valueItem = $(exitingItem).val();
                                                  var valueSq = $(exitingSq).val();
                                                  var valueKanban = $(exitingKanban)
                                              .val();
                                                  // console.log(lastRowData);
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
                                                      url: "{{ route('validasi_fifo_lokal3') }}",
                                                      type: "get",
                                                      data: {
                                                          getSquence: getSquence,
                                                          getItemcode: getItemcode,
                                                          getKanban: getKanban,
                                                          tabelSquence: valueSq,
                                                          tabelItemcode: valueItem,
                                                          tabelKanban: valueKanban
                                                      }, // Data yang akan dikirim ke server
                                                      dataType: 'json',
                                                      beforeSend: function() {
                                                          showLoading
                                                              (); // Memanggil fungsi showLoading sebelum request
                                                      },
                                                      success: function(
                                                          response) {
                                                          // console.log(
                                                          //     response);
                                                          if (response
                                                              .message ===
                                                              "success") {
                                                              hideLoading();
                                                              // Data cocok, lakukan sesuatu dengan response.data
                                                              var t = $(
                                                                      '#tblChutter'
                                                                  )
                                                                  .DataTable();
                                                              var counter = t
                                                                  .rows()
                                                                  .count();
                                                              var jml_row =
                                                                  Number(
                                                                      counter
                                                                  ) + 1;
                                                              var Itemcode =
                                                                  "Itemcode" +
                                                                  jml_row;
                                                              var part_no =
                                                                  "part_no" +
                                                                  jml_row;
                                                              var Squence =
                                                                  "Squence" +
                                                                  jml_row;
                                                              var Kanban =
                                                                  "Kanban" +
                                                                  jml_row;
                                                              var Qty =
                                                                  "Qty" +
                                                                  jml_row;
                                                              t.row.add([
                                                                  '<input type="text" class=" text-center" id="' +
                                                                  Itemcode +
                                                                  '" name="Itemcode[]" value="' +
                                                                  getItemcode +
                                                                  '" readonly>',
                                                                  '<input type="text" class=" text-center" id="' +
                                                                  part_no +
                                                                  '" name="part_no[]" value="' +
                                                                  getPartno +
                                                                  '" readonly>',
                                                                  '<input type="text" class=" text-center" id="' +
                                                                  Squence +
                                                                  '" name="Squence[]" value="' +
                                                                  getSquence +
                                                                  '" readonly>',
                                                                  '<input type="text" class=" text-center" id="' +
                                                                  Kanban +
                                                                  '" name="Kanban[]" value="' +
                                                                  getKanban +
                                                                  '" >',
                                                                  '<input type="text" class=" text-center" id="' +
                                                                  Qty +
                                                                  '" name="Qty[]" value="' +
                                                                  getQty +
                                                                  '" >',
                                                              ]).draw();

                                                              input1.val("");
                                                              input1.attr(
                                                                  'readonly',
                                                                  false);
                                                              $('#input1')
                                                                  .focus();

                                                              input1.val("");
                                                              input1.attr(
                                                                  'readonly',
                                                                  false);
                                                              $('#input1')
                                                                  .focus();
                                                          } else if (response
                                                              .message ===
                                                              "error") {
                                                              hideLoading();
                                                              // Data tidak cocok, tampilkan pesan error
                                                              // console.log(response
                                                              //     .data
                                                              // );
                                                              input1.val("");
                                                              $('#input1')
                                                                  .focus();
                                                              // alert('error');
                                                              // notif bergetar
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
                                                              swal.fire({
                                                                  icon: 'error',
                                                                  title: 'TANGGAL TIDAK SAMA',
                                                                  text: `Kanban No: ${response.data.kanban_no}, Date: ${response.date}`,
                                                              }); // Ini akan mencetak data yang tidak cocok ke konsol
                                                          }
                                                      }
                                                  })
                                              } else {
                                                  // alert('chutter kosong');
                                                  hideLoading();
                                                  // notif bergetar
                                                  if ("vibrate" in navigator) {
                                                      navigator.vibrate([1000]);
                                                  }
                                                  document.getElementById('Audioerror')
                                                      .play();
                                                  swal.fire({
                                                      icon: 'error',
                                                      title: 'Data Not Found',
                                                      text: 'Kanban Belum In Chuter',
                                                      showConfirmButton: true, // Menampilkan tombol OK
                                                      // timer: 2000, // Menampilkan selama 2 detik
                                                  });
                                                  input1.val("");
                                                  $('#input1').focus();
                                              }
                                          }
                                      })
                                  } else {
                                      hideLoading();
                                      // notif bergetar
                                      if ("vibrate" in navigator) {
                                          navigator.vibrate([1000]);
                                      }
                                      document.getElementById('Audioerror').play();
                                      // alert('data ada fgout');
                                      swal.fire({
                                          icon: 'error',
                                          title: 'DATA SUDAH OUT CHUTER',
                                          text: 'Data Already Exist',
                                          showConfirmButton: true, // Menampilkan tombol OK
                                          // timer: 2000, // Menampilkan selama 2 detik
                                      });
                                      input1.val("");
                                      input1.attr('readonly', false);
                                      $('#input1').focus();
                                  }
                              }

                          })


                      } else {
                          hideLoading();
                          // jika squence nya sama
                          // alert('error squence sama');
                          // notif bergetar
                          if ("vibrate" in navigator) {
                              navigator.vibrate([1000]);
                          }
                          document.getElementById('Audioerror').play();
                          swal.fire({
                              icon: 'error',
                              title: 'Squence Tidak Boleh Sama',
                              text: 'Squence Sudah di Scan',
                              showConfirmButton: true, // Menampilkan tombol OK
                              // timer: 2000, // Menampilkan selama 2 detik
                          });
                          input1.val("");
                          input1.attr('readonly', false);
                          $('#input1').focus();
                      }


                      // jika data nya tidak sama
                  } else {
                      hideLoading();
                      input1.val("");
                      input1.attr('readonly', false);
                      $('#input1').focus();
                      // notif bergetar
                      if ("vibrate" in navigator) {
                          navigator.vibrate([1000]);
                      }
                      document.getElementById('Audioerror').play();
                      swal.fire({
                          icon: 'error',
                          title: 'Part No Tidak Sama',
                          text: 'Part No Tidak Sama',
                          showConfirmButton: true, // Menampilkan tombol OK
                          // timer: 2000, // Menampilkan selama 2 detik
                      });

                  }

              }
          } */
        // Input field 2
        input2.on("keydown", function(e) {
            if (e.which === 13) {
                // handleInput2Change();
                function showLoading() {
                    $('.loading-spinner-container').show();
                }

                // Menyembunyikan loading spinner
                function hideLoading() {
                    $('.loading-spinner-container').hide();
                }
                var input2 = $("#input2");
                // var itemcodeLokal = $("#itemcodeLokal");
                // Input field 2 for add row tabel
                // if (input2.val() !== "") {
                var getInput2 = input2.val();
                if (getInput2.includes(',')) {
                    // ... (kode lainnya)
                    var spliteData = getInput2.split(',');
                    // var Getpart_no = spliteData[1];
                    // var Getpart_no = spliteData[2];
                    var getItemcode = spliteData[1];
                    // alert(getItemcode);
                    $("#itemcodeChutter").val(getItemcode);
                    var itemcodeChutter = $('#itemcodeChutter').val();
                    // var itemcodeLokalValue = $('#itemcodeLokal').val();
                    var table = $("#tblChutter").DataTable();

                    // Mengambil data dari seluruh baris dalam tabel
                    var data = table.rows().data();

                    var exitItemcode = "";

                    if (data.length > 0) {
                        var rowData = data[data.length - 1]; // Mendapatkan data dari baris terakhir
                        exitItemcode = $(rowData[0]).val(); // Mengambil nilai dari elemen pertama
                    }
                    // alert(itemcodeLokal);
                    // alert(itemcodeLokalValue);
                    // console.log('itemcodelokalkanban', exitItemcode);
                    // console.log('itemcodechutter', itemcodeChutter);
                    if (itemcodeChutter === exitItemcode) {
                        // addDataToTable(spliteData);
                        // alert('sama');
                        var itemcodeChutter = $('#itemcodeChutter').val();
                        // AddFromfgin();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            }
                        });
                        $.ajax({
                            url: "{{ route('add_ekanbanChuterout') }}",
                            type: "post",
                            data: $('#formChutter').serialize(),
                            dataType: 'json',
                            beforeSend: function() {
                                showLoading
                                    (); // Memanggil fungsi showLoading sebelum request
                            },
                            success: function(data) {
                                // console.log(data);
                                if (data.message === 'Data successfully processed') {
                                    hideLoading();
                                    const Kanban = data.Kanban;
                                    const part_no = data.part_no;
                                    const dataCount = data.data;
                                    // Tindakan jika data berhasil diproses
                                    // console.log('Data berhasil diproses');
                                    $('#tblChutter').DataTable().clear().draw();
                                    // Menampilkan divLokal
                                    document.getElementById("divLokal").style.display =
                                        "block";
                                    // Sembunyikan divChutter
                                    document.getElementById("divChutter").style.display =
                                        "none";
                                    // Fokuskan input1
                                    input1.focus();
                                    input1.val("");
                                    input2.val("");
                                    document.getElementById('Audiosucces').play();
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Successfully!',
                                        html: `Masih Ada Data Over Flow<br>Kanban No: "${Kanban}", Part No: "${part_no}",${dataCount}Box`
                                    });

                                } else {
                                    hideLoading();
                                    document.getElementById('Audioerror')
                                    if ("vibrate" in
                                        navigator) {
                                        navigator.vibrate([
                                            1000
                                        ]);
                                    }
                                    $('#tblChutter').DataTable().clear().draw();
                                    // Menampilkan divLokal
                                    document.getElementById("divLokal").style.display =
                                        "block";
                                    // Sembunyikan divChutter
                                    document.getElementById("divChutter").style.display =
                                        "none";
                                    input1.focus();
                                    input1.val("");
                                    input2.val("");
                                    // Tindakan jika pesan lain diterima dari server
                                    // console.log('Pesan tidak dikenali: ' + data.message);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: 'Data Not Found',
                                    });
                                    // Tindakan jika pesan lain diterima dari server
                                    // console.log('Pesan tidak dikenali: ' + data.message);
                                }
                            },
                            // error: function(xhr, status, error) {
                            //     hideLoading();
                            //     document.getElementById('Audioerror')
                            //     // console.error("Error:", error);
                            //     if ("vibrate" in
                            //         navigator) {
                            //         navigator.vibrate([
                            //             1000
                            //         ]);
                            //     }
                            //     $('#tblChutter').DataTable().clear().draw();
                            //     // Menampilkan divLokal
                            //     document.getElementById("divLokal").style.display =
                            //         "block";
                            //     // Sembunyikan divChutter
                            //     document.getElementById("divChutter").style.display =
                            //         "none";
                            //     input1.focus();
                            //     input1.val("");
                            //     input2.val("");
                            //     Swal.fire({
                            //         icon: 'error',
                            //         title: 'Error!',
                            //         text: 'Server Error',
                            //     });
                            // }
                        })

                    } else {
                        // alert('Tidak sama ');
                        input1.focus();

                        // var itemLokal = $('#itemcodeLokal').val();
                        // alert(itemLokal);
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                    .attr(
                                        'content')
                            }
                        });
                        // menampilkan alamat chutter pada itemcode nya
                        $.ajax({
                            url: "{{ route('getChutter') }}",
                            type: "get",
                            data: {
                                itemLokal: exitItemcode
                            }, // Data yang akan dikirim ke server
                            dataType: 'json',
                            success: function(data) {
                                // input1.focus();
                                var table = $("#tblChutter").DataTable();
                                // notif bergetar
                                if ("vibrate" in navigator) {
                                    navigator.vibrate([1000]);
                                }
                                document.getElementById('Audioerror').play();
                                swal.fire({
                                    icon: 'error',
                                    title: 'Itemcode Tidak Sama',
                                    text: 'Alamat chutter : ' + data
                                        .chutter_address,
                                }).then(function() {
                                    // Tindakan yang ingin Anda lakukan setelah pengguna menutup pesan kesalahan
                                    input1.focus();
                                });

                                // Mengatur ulang input dan tampilan

                                $('#itemcodeChutter').val("");

                                // Sembunyikan divChutter

                                document.getElementById("divChutter").style.display =
                                    "none";
                                // Tampilkan elemen dengan ID "divLokal"
                                document.getElementById("divLokal").style.display = "block";

                                // Fokuskan input1 dengan ID "input1"
                                document.getElementById("input1").focus();

                                // Kosongkan nilai input1 dengan ID "input1"
                                document.getElementById("input1").value = "";

                                // Kosongkan nilai input2 dengan ID "input2"
                                document.getElementById("input2").value = "";

                                // Fokuskan input1 dengan ID "input1"
                                document.getElementById("input1").focus();
                                table.clear().draw();

                            }

                        })

                    }
                } else {
                    input2.val(""); // Kosongkan input2 jika tidak ada koma
                    input2.attr('readonly', false);
                    $('#input2').focus();
                }

            }
        });

        // function AddFromfgin() {


        // }

        reset.on("click", function() {
            // Kode di bawah ini akan mengembalikan tampilan ke kondisi semula
            $('#tblChutter').DataTable().clear().draw();
            // Menampilkan divLokal
            document.getElementById("divLokal").style.display = "block";

            // Sembunyikan divChutter
            document.getElementById("divChutter").style.display = "none";

            // Fokuskan input1
            input1.focus();

            // Kosongkan nilai input1
            input1.val("");

            // Kosongkan nilai input2
            input2.val("");
        });

        // button add to inputan chutter
        // var isChutterActive = false; // Status awal

        // document.getElementById("addChutter").addEventListener("click", function() {
        //     // Toggle status
        //     isChutterActive = !isChutterActive;

        //     if (isChutterActive) {
        //         // Sembunyikan divLokal
        //         document.getElementById("divLokal").style.display = "none";

        //         // Tampilkan divChutter
        //         document.getElementById("divChutter").style.display = "block";

        //         // Fokuskan input2
        //         document.getElementById("input2").focus();
        //     } else {
        //         // Tampilkan divLokal
        //         document.getElementById("divLokal").style.display = "block";

        //         // Sembunyikan divChutter
        //         document.getElementById("divChutter").style.display = "none";

        //         // Fokuskan input1
        //         document.getElementById("input1").focus();
        //     }
        // });
        var isChutterActive = false;

        document.getElementById("addChutter").addEventListener("click", function() {
            // Toggle status
            isChutterActive = !isChutterActive;

            if (isChutterActive) {
                // Sembunyikan divLokal dan fokuskan input2
                document.getElementById("divLokal").style.display = "none";
                document.getElementById("divChutter").style.display = "block";
                document.getElementById("input2").focus();
                document.getElementById("input1").value = ""; // Bersihkan nilai input1
            } else {
                // Tampilkan divLokal, sembunyikan divChutter, dan fokuskan input1
                document.getElementById("divLokal").style.display = "block";
                document.getElementById("divChutter").style.display = "none";
                document.getElementById("input1").focus();
                document.getElementById("input2").value = ""; // Bersihkan nilai input2
            }
        });


    });
</script>
