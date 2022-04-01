jQuery.noConflict();

$(document).on("change", "#addfile", function (e) {
  var fileName = e.target.files[0].name;
  $(".label-additional").html(fileName);
});

$(document).on("change", "#file", function (e) {
  var fileName = e.target.files[0].name;
  if (fileName != "") {
    $(".label-watermark").html(fileName);
  }
});

$(document).on("click", ".ui-v3_close-button", function () {
  $(".view-remove").remove();
  $(".file_upload").show();
  $(".file_upload img").show();
  $(".file_upload label").show();
  $(".ui-v3_close-button").hide();
  $(".viewer-file").hide();
  $(".progress").hide();
  $(".uploadForm").removeClass("form-file-upload").show();
  $("#span6").removeClass("files-uploaded");
});

$(document).on("change", "#w_type", function () {
  $(".watermark").hide();
  $("#" + $(this).val()).show();
});

$(document).on("change", "#evaluation_type", function () {
  var id = "10";
  if ($("#evaluation_type").val() === id) {
    $("#evaluation_value").hide();
    $("#evaluation_date").show();
  } else {
    $("#evaluation_value").show();
    $("#evaluation_date").hide();
  }
  if ($("#evaluation_type").val() == "14") {
    $("#evaluation_value").hide();
  }
});

$(document).ready(function () {
  // File upload via Ajax
  $(document).on("change", 'input[name="uploadfile"]', function (e) {
    var file = this.files[0];
    var size = this.files[0].size;
    var imp = $("#imp").val();
    if (imp < 100) {
      var limit = 2000000;
      if (size > limit) {
        Swal.fire({
          text: "The file upload size is restrcited to 2mb while your a free account or your impression counter is below 100. Do you wish to top up now?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes",
        }).then((result) => {
          if (result.isConfirmed) {
            window.location = "setting.php";
          }
        });
        $('input[name="uploadfile"]').val("");
        return false;
      }
    }
    var fileType = file.type;
    console.log(fileType);
    //File Validation
    var allowedTypes = [
      "application/pdf",
      "image/jpeg",
      "image/png",
      "image/jpg",
      "image/gif",
      "video/mp4",
      "video/webm",
      "audio/mp3",
      "audio/mpeg",
    ];
    var file = this.files[0];
    var fileType = file.type;
    //alert(fileType);
    if (!allowedTypes.includes(fileType)) {
      Swal.fire(
        "We are only supporting this formates (PDF/JPEG/JPG/PNG/GIF/MP4/WEBM/MP3)."
      );
      $('input[name="uploadfile"]').val("");
      return false;
    } else {
      $("#file_type").val(fileType);
      e.preventDefault();
      $.ajax({
        xhr: function () {
          var xhr = new window.XMLHttpRequest();
          var t = 0;
          var s = 0;
          xhr.upload.addEventListener(
            "progress",
            function (evt) {
              $(".loader").show();
              $(".file_upload img").hide();
              $(".file_upload label").hide();
              if (evt.lengthComputable) {
                var percentComplete = (evt.loaded / evt.total) * 100;
                var a = Math.round(percentComplete);
                var t = a / 100;
                //bar.animate(t);
              }
            },
            false
          );
          return xhr;
        },
        type: "POST",
        url: "include/upload.php",
        data: new FormData($(this).closest("form")[0]),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
          $("#uploadStatus").html(
            '<img src="http://shareio.com/image/giphy.gif" style="height: 50px;"/>'
          );
        },
        error: function () {
          $("#uploadStatus").html(
            '<p style="color:#EA4335;">File upload failed, please try again.</p>'
          );
        },
        success: function (resp) {
          if (resp) {
            $("#fileurl").val(myTrim(resp));
            $("#uploadStatus img").attr("style", "display: none");
          } else if (resp == "invalid") {
            $("#uploadStatus").html(
              '<p style="color:#red;">Invalid File Type, please try again.</p>'
            );
          } else if (resp == "no") {
            $("#uploadStatus").html(
              '<p style="color:#EA4335;">File already exists, please try again.</p>'
            );
          }
          $(".file_upload").hide();
          $(".ui-v3_close-button").show();
          //span6()addClass();
          $(".uploadForm").addClass("form-file-upload");
          $("#span6").addClass("files-uploaded");
          if (fileType == "application/msword") {
            PreviewDocs(resp);
          } else if (
            fileType ==
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
          ) {
            PreviewDocs(resp);
          } else {
            PreviewImage(fileType, resp);
          }
          if (fileType == "audio/mp3" || fileType == "audio/mpeg") {
            audio_duration(resp);
          }
          $(".loader").hide();
          //bar.animate(0.0);
        },
      });
    }
  });
});

function myTrim(x) {
  return x.replace(/^\s+|\s+$/gm, "");
}
function PreviewImage(Type, resp) {
  var allowedTypes = ["image/jpeg", "image/png", "image/jpg", "image/gif"];
  var allowedTypesvideo = ["video/mp4"];
  var allowedTypesaudio = ["audio/mp3", "audio/mpeg"];
  pdffile = $('input[name="uploadfile"]').prop("files")[0];
  var fileType = pdffile.type;
  pdffile_url = URL.createObjectURL(pdffile);
  $(".viewer-file").show();
  if (
    !allowedTypes.includes(fileType) &&
    !allowedTypesvideo.includes(fileType) &&
    !allowedTypesaudio.includes(fileType)
  ) {
    $(".viewer-file").html(
      '<div class="view-remove"><a href="javascript:void(0);" onclick="fileupload();"><iframe class="viewer" frameborder="0" scrolling="no" autoplay=""></iframe></a></div>'
    );
    var input = $('input[name="uploadfile"]');
    var reader = new FileReader();
    reader.readAsBinaryString(input.prop("files")[0]);
    reader.onloadend = function () {
      var count = reader.result.match(/\/Type[\s]*\/Page[^s]/g).length;
      document.getElementById("trial_start").value = "1";
      document.getElementById("trial_end").value = count;
      document.getElementById("number").value = count;
    };
    $("#trial_setting").show();
    $("#trial_s").html("From Page");
    $("#trial_e").html("To Page");
  } else if (
    !allowedTypesvideo.includes(fileType) &&
    !allowedTypesaudio.includes(fileType)
  ) {
    $(".viewer-file").html(
      '<div class="view-remove" class="file-image"><a href="javascript:void(0);" onclick="fileupload();"><img width="570px" height="600px" class="viewer"></a></div>'
    );
    $("#trial_setting").hide();
    $.ajax({
      type: "POST",
      url: "Image-Zoom/Example/Image.php",
      data: {
        url: pdffile_url,
      },
      success: function (html) {
        $(".view-remove").html(html);
      },
    });
  } else if (allowedTypesaudio.includes(fileType)) {
    $(".viewer-file").html(
      '<div class="view-remove" class="file-image"><a href="javascript:void(0);" onclick="fileupload();" class="audio"><video id="myVideo" controls="" class="viewer" name="media" style="background-color:black;"><source type="audio/mpeg" class="viewer"></video></a></div>'
    );
    $(document).ready(function () {
      setTimeout(function () {
        $("#getduration").click();
      }, 2000);
    });
    $("#number").attr("style", "display: none");
    $("#trial_setting").show();
    $("#trial_s").html("Start time");
    $("#trial_e").html("End time");
  } else {
    $(".viewer-file").html(
      '<div class="view-remove" class="file-image"><a href="javascript:void(0);" onclick="fileupload();"><video id="myVideo" width="570px" height="600px" controls><source class="viewer"></video></a></div>'
    );
    $(document).ready(function () {
      setTimeout(function () {
        $("#getduration").click();
      }, 2000);
    });
    $("#number").attr("style", "display: none");
    $("#trial_setting").show();
    $("#trial_s").html("Start time");
    $("#trial_e").html("End time");
  }

  $(".viewer").attr("src", pdffile_url);
}

var iframe = $(".viewer").contents();
iframe.click(function (event) {
  $('input[name="uploadfile"]').click();
});

function audio_duration(resp) {
  var files = resp;

  jQuery.ajax({
    type: "POST",
    data: {
      file: files,
    },
    url: "include/audio_duration/mp3file.class.php",
    success: function (resp) {
      $("#number").val(resp);
      //$/("#myModal").attr("style" , "display: block");
    },
  });
}

function videoduration() {
  var x = document.getElementById("myVideo").duration;
  var h = Math.floor((x % (3600 * 24)) / 3600);
  var m = Math.floor((x % 3600) / 60);
  var s = Math.floor(x % 60);

  var hDisplay = h > 0 ? h + (h == 9 ? ":" : ":") : "";
  var mDisplay = m > 0 ? m + (m == 1 ? ":" : ":") : "";
  var sDisplay = s > 0 ? s + (s == 1 ? " " : " ") : "";
  if (hDisplay == "") {
    hDisplay = "00:";
  }
  if (mDisplay <= "9") {
    mDisplay = "0" + mDisplay;
  }
  var video_duration = hDisplay + mDisplay + sDisplay;
  $("#number").val(video_duration);
  $("#trial_start").val("00:00:01");
  $("#trial_end").val(video_duration);
  $("#getduration").attr("style", "display: none");
  $("#number").removeAttr("style");
}

function submitfiledata(e) {
  var number = document.getElementById("number").value;
  var price = document.getElementById("price").value;
  var fileurl = document.getElementById("fileurl").value;
  var w_type = document.getElementById("w_type").value;
  var evaluation_type = document.getElementById("evaluation_type").value;
  var error = document.getElementById("error");
  var errorfile = document.getElementById("errorfile");
  var errorw = document.getElementById("errorw");
  var errorevl = document.getElementById("errorevl");
  if (fileurl == "") {
    errorfile.innerHTML = "Please Select a file to upload.";
    return false;
  } else {
    errorfile.innerHTML = "";
  }
  if (number == "") {
    error.innerHTML = "Please enter total pages.";
    return false;
  } else {
    error.innerHTML = "";
  }
  if (price == "") {
    error.innerHTML = " ";
    ("Please enter file price.");
    return false;
  } else {
    error.innerHTML = "";
  }
  if (evaluation_type == "14") {
  } else {
    if (evaluation_type == "10") {
      var evaluation_date = document.getElementById("evaluation_date").value;
      if (evaluation_date == "") {
        errorevl.innerHTML = "Please enter Evaluation Setting.";
        return false;
      }
    } else {
      var evaluation_value = document.getElementById("evaluation_value").value;
      if (evaluation_value == "") {
        errorevl.innerHTML = "Please enter Evaluation Setting.";
        return false;
      }
    }
  }

  if (w_type == "None") {
  } else {
    if (w_type == "Text") {
      var watermark_text = document.getElementById("watermark_text").value;
      if (watermark_text == "") {
        errorw.innerHTML = "Please enter watermark.";
        return false;
      }
    } else {
      var file = document.getElementById("file").value;
      if (file == "") {
        errorw.innerHTML = "Please select watermark file.";
        return false;
      }
    }
  }

  var x = document.getElementById("block_country");
  var wrapper_db = $("#block_country_db");
  var txt = "All options: ";
  var i;
  for (i = 0; i < x.length; i++) {
    txt = x.options[i].value;
    $(wrapper_db).append(
      '<input type="hidden" value="' + txt + '" name="block_country[]" />'
    );
  }

  var blockCountry = [];
  var inps = document.getElementsByName("block_country[]");
  for (var i = 0; i < inps.length; i++) {
    blockCountry.push(inps[i].value);
  }

  var data = new FormData();
  data.append("fileurl", $("#fileurl").val());
  data.append("number", number);
  data.append("price", price);
  data.append("file_type", $("#file_type").val());
  data.append("w_type", w_type);
  data.append("trial_start", $("#trial_start").val());
  data.append("trial_end", $("#trial_end").val());
  data.append("evaluation_type", evaluation_type);
  data.append("evaluation_value", $("#evaluation_value").val());
  data.append("evaluation_date", $("#evaluation_date").val());
  data.append("password", $("#password").val());
  data.append("ip_dns", $("#ip_dns").val());
  data.append("browser_view", $("#browser_view").val());
  data.append("notification", $("#notification").val());
  data.append("social_share", $("#social_share").val());
  data.append("download", $("#download").val());
  data.append("hide_banner", $("#hide_banner").val());
  data.append("block_country", blockCountry);
  data.append("watermark_text", $("#watermark_text").val());
  data.append("file", $("#file").prop("files")[0]);
  data.append("addfile", $("#addfile").prop("files")[0]);

  //console.log(data);
  $.ajax({
    type: "POST",
    processData: false, // important
    contentType: false, // important
    data: data,
    url: "include/uploadfile.php",
    dataType: "script",
    // in PHP you can call and process file in the same way as if it was submitted from a form:
    // $_FILES['input_file_name']
    success: function (resp) {
      if (resp.replace(/\s/g, "") == "1") {
        window.location = "reports.php";
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "There is some issue please try again.",
        });
      }
    },
  });
}

$(document).on('click', '#delete-content', function(){
  var id = $('#file_id').val();
  Swal.fire({
    title: 'Do you wish to delete this share?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "include/delete-content.php?id="+id,
        success: function(res){ 
          Swal.fire({
            text: "Content Deleted Successfully",
            icon: "success",
            showConfirmButton: false,
            timer: 1500
          });
          refreshPanel1("File");
          refreshPanel2("File");
        }
      });
    }
  })
}); 

$(document).on('click', '.strip-acc', function(){
    Swal.fire({
      text: "Your Stripe Account is not activated do you wish to activate your account?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes'
    }).then((result) => {
      if (result.isConfirmed) {
            //window.location = "setting.php";
          }
    })
});

$(document).on('click', '.getimp', function(){
    Swal.fire({
      text: "Your impressions tokens have expired any shared links will not be viewable. Please update your tokens by going to your settings page.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes'
    }).then((result) => {
      if (result.isConfirmed) {
            //window.location = "setting.php";
          }
    })
});

$(document).on('click', '#getqr', function(){
    var imageUrl = $('#file_qr').val();
    if(imageUrl.includes("contentshare.me")){
      imageUrl = imageUrl.replace("contentshare.me", "shareio.com");
    }
    
    Swal.fire({
    title: 'ShareIO',
    imageUrl: imageUrl,
    imageWidth: 300,
    imageHeight: 300,
    html:
      '<a href="'+imageUrl+'" download>Download</a>'
  })
});

function CopyURL(){
  var copyText = document.getElementById("url");
  copyText.select();
  copyText.setSelectionRange(0, 99999)
  document.execCommand("copy");
  $('.socialCircle-center').click();
  //alert("Copied the text: " + copyText.value);
  Swal.fire({
    text: "URL Copied Successfully",
    icon: "success",
    showConfirmButton: false,
    timer: 1500
  });
}

function paused_icon() {
  $("input[name=paused][value=no]").attr('checked', 'checked');
  $("input[name=paused][value=yes]").removeAttr('checked', 'checked');
  $(".play_pause_btn #yes").hide();
  $(".play_pause_btn #no").show();
  var id = $('#file_id').val();
  var paused = 'no';
  $.ajax({
      type: "POST",
      url: "include/Updatepause.php",
      data:{
        id:id,
        paused:paused
      },
      success: function(res){ 
        //window.location = "reports.php";
      }
    });
}
function play_icon() {
  $("input[name=paused][value=yes]").attr('checked', 'checked');
  $("input[name=paused][value=no]").removeAttr('checked', 'checked');
  $(".play_pause_btn #no").hide();
  $(".play_pause_btn #yes").show();
  var id = $('#file_id').val();
  var paused = 'yes';
  $.ajax({
      type: "POST",
      url: "include/Updatepause.php",
      data:{
        id:id,
        paused:paused
      },
      success: function(res){ 
        //window.location = "reports.php";

      }
    });
}

function updatefiledata(e) {
  var number = document.getElementById("number").value;
  var price = document.getElementById("price").value;
  var fileurl = document.getElementById("fileurl").value;
  var w_type = document.getElementById("w_type").value;
  var evaluation_type = document.getElementById("evaluation_type").value;
  var error = document.getElementById("error");
  var errorfile = document.getElementById("errorfile");
  var errorw = document.getElementById("errorw");
  if (fileurl == "") {
    errorfile.innerHTML = "Please Select a file to upload.";
    return false;
  } else {
    errorfile.innerHTML = "";
  }
  if (number == "") {
    error.innerHTML = "Please enter total pages.";
    return false;
  } else {
    error.innerHTML = "";
  }
  if (price == "") {
    error.innerHTML = " ";
    ("Please enter file price.");
    return false;
  } else {
    error.innerHTML = "";
  }
  
  if (w_type == "None") {
  } else {
    if (w_type == "Text") {
      var watermark_text = document.getElementById("watermark_text").value;
      if (watermark_text == "") {
        errorw.innerHTML = "Please enter watermark.";
        return false;
      }
    } else {
      var file = document.getElementById("file").value;
      if (file == "") {
        errorw.innerHTML = "Please select watermark file.";
        return false;
      }
    }
  }

  var x = document.getElementById("block_country");
  var wrapper_db = $("#block_country_db");
  var txt = "All options: ";
  var i;
  for (i = 0; i < x.length; i++) {
    txt = x.options[i].value;
    $(wrapper_db).append(
      '<input type="hidden" value="' + txt + '" name="block_country[]" />'
    );
  }

  var blockCountry = [];
  var inps = document.getElementsByName("block_country[]");
  for (var i = 0; i < inps.length; i++) {
    blockCountry.push(inps[i].value);
  }

  var data = new FormData();
  data.append("file_id", $("#file_id").val());
  data.append("fileurl", $("#fileurl").val());
  data.append("number", number);
  data.append("price", price);
  data.append("file_type", $("#file_type").val());
  data.append("w_type", w_type);
  data.append("trial_start", $("#trial_start").val());
  data.append("trial_end", $("#trial_end").val());
  data.append("evaluation_type", evaluation_type);
  data.append("evaluation_value", $("#evaluation_value").val());
  data.append("evaluation_date", $("#evaluation_date").val());
  data.append("password", $("#password").val());
  data.append("ip_dns", $("#ip_dns").val());
  data.append("browser_view", $("#browser_view").val());
  data.append("notification", $("#notification").val());
  data.append("social_share", $("#social_share").val());
  data.append("download", $("#download").val());
  data.append("hide_banner", $("#hide_banner").val());
  data.append("block_country", blockCountry);
  data.append("watermark_text", $("#watermark_text").val());
  data.append("file", $("#file").prop("files")[0]);
  data.append("addfile", $("#addfile").prop("files")[0]);
  data.append("watermark_image", $("#watermark_image").val());
  data.append("addfileUrl", $("#addfileUrl").val());

  //console.log(data);
  $.ajax({
    type: "POST",
    processData: false, // important
    contentType: false, // important
    data: data,
    url: "include/updatefile.php",
    dataType: "script",
    // in PHP you can call and process file in the same way as if it was submitted from a form:
    // $_FILES['input_file_name']
    success: function (resp) {
      if (resp.replace(/\s/g, "") == "1") {
        Swal.fire({
          text: "Data Updated Successfully",
          icon: "success",
          confirmButtonText: "Close",
        });

        refreshPanel2("File");
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "There is some issue please try again.",
        });
      }
    },
  });
}

