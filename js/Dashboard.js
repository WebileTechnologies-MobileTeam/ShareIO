function initDashboard(content) {
  var config = {
    content: [
      {
        type: "stack",
        content: [
            {
              type: "component",
              componentName: "panle1tab1",
              title: "Settings",
              componentState: { text: content },
            },
            {
              type: "component",
              componentName: "panle1tab2",
              title: "Advanced",
              componentState: { text: content },
            },
            {
              type: "component",
              componentName: "panle1tab3",
              title: "Geofence",
              componentState: { text: content },
            }
          ]
      }]
  };

  var myLayout = new GoldenLayout(config, $(".main_content"));

  myLayout.registerComponent("panle1tab1", function (container, state) {
    $.ajax({
      type: "GET",
      url: "AddFileContent.php?content=tab1&&type=" + state.text,
      data: {},
      success: function (html) {
        var element = container.getElement();
        element.addClass("panle1tab1");
        container.getElement().html(html);
      },
    });
  });

  myLayout.registerComponent("panle1tab2", function (container, state) {
    $.ajax({
      type: "GET",
      url: "AddFileContent.php?content=tab2&&type=" + state.text,
      data: {},
      success: function (html) {
        var element = container.getElement();
        element.addClass("panle1tab2");
        container.getElement().html(html);
      },
    });
  });

  myLayout.registerComponent("panle1tab3", function (container, state) {
    $.ajax({
      type: "GET",
      url: "AddFileContent.php?content=tab3&&type=" + state.text,
      data: {},
      success: function (html) {
        var element = container.getElement();
        element.addClass("panle1tab3");
        container.getElement().html(html);
      },
    });
  });

  myLayout.init();

  // $(window).resize(function () {
  //   myLayout.updateSize();
  // });
}

function refreshPanel1(type) {
  if (type == "File") {
    $.ajax({
      type: "GET",
      url: "AddFileContent.php?content=tab1&&type=" + type,
      data: {},
      success: function (html) {
        $(".panle1tab1").html(html);
      },
    });

    $.ajax({
      type: "GET",
      url: "AddFileContent.php?content=tab2&&type=" + type,
      data: {},
      success: function (html) {
        $(".panle1tab2").html(html);
      },
    });

    $.ajax({
      type: "GET",
      url: "AddFileContent.php?content=tab3&&type=" + type,
      data: {},
      success: function (html) {
        $(".panle1tab3").html(html);
      },
    });

    $('.panle2tab1').parent().show();
    $('.panle2tab2').parent().hide();
    $('.panle2tab3').parent().hide();
    $('.lm_tabs li').each(function(){
      if(this.title == "Files"){
        $(this).addClass('lm_active');
      } else if(this.title == "Packages" || this.title == "Dashboards"){
        $(this).removeClass('lm_active');
      }
    });
  } else if (type == "Package") {
    $.ajax({
      type: "GET",
      url: "AddPackageContent.php?content=tab1&&type=" + type,
      data: {},
      success: function (html) {
        $(".panle1tab1").html(html);
      },
    });

    $.ajax({
      type: "GET",
      url: "AddPackageContent.php?content=tab2&&type=" + type,
      data: {},
      success: function (html) {
        $(".panle1tab2").html(html);
      },
    });

    $.ajax({
      type: "GET",
      url: "AddPackageContent.php?content=tab3&&type=" + type,
      data: {},
      success: function (html) {
        $(".panle1tab3").html(html);
      },
    });

    $('.panle2tab1').parent().hide();
    $('.panle2tab2').parent().show();
    $('.panle2tab3').parent().hide();
    $('.lm_tabs li').each(function(){
      if(this.title == "Packages"){
        $(this).addClass('lm_active');
      } else if(this.title == "Files" || this.title == "Dashboards"){
        $(this).removeClass('lm_active');
      }
    });
  } else {
    $.ajax({
      type: "GET",
      url: "AddUserDashboardContent.php?content=tab1&&type=" + type,
      data: {},
      success: function (html) {
        $(".panle1tab1").html(html);
      },
    });

    $.ajax({
      type: "GET",
      url: "AddUserDashboardContent.php?content=tab2&&type=" + type,
      data: {},
      success: function (html) {
        $(".panle1tab2").html(html);
      },
    });

    $.ajax({
      type: "GET",
      url: "AddUserDashboardContent.php?content=tab3&&type=" + type,
      data: {},
      success: function (html) {
        $(".panle1tab3").html(html);
      },
    });

    $('.panle2tab1').parent().hide();
    $('.panle2tab2').parent().hide();
    $('.panle2tab3').parent().show();
    $('.lm_tabs li').each(function(){
      if(this.title == "Dashboards"){
        $(this).addClass('lm_active');
      } else if(this.title == "Files" || this.title == "Packages"){
        $(this).removeClass('lm_active');
      }
    });
  }
}

function refreshPanel2(type) {
  if (type == "File") {
    $.ajax({
      type: "GET",
      url: "reports.php?content=tab1",
      data: {},
      success: function (html) {
        $(".panle2tab1").html(html);
      },
    });

  } else if (type == "Package") {
    $.ajax({
      type: "GET",
      url: "reports.php?content=tab2",
      data: {},
      success: function (html) {
        $(".panle2tab2").html(html);
      },
    });

  } else {
    $.ajax({
      type: "GET",
      url: "reports.php?content=tab3",
      data: {},
      success: function (html) {
        $(".panle2tab3").html(html);
      },
    });
  }
}

$(document).on("change", "#content_select", function () {
  refreshPanel1($(this).val());
});

// $(document).on("click", ".lm_tab", function () {
//   console.log($(this).title)
//   if(this.title == "Files"){
//     $('#content_select').val('File');
//     refreshPanel1('File');
//   } else if(this.title == "Packages"){
//     $('#content_select').val('Package');
//     refreshPanel1('Package');
//   } else if(this.title == "Dashboards"){
//     $('#content_select').val('Dashboard');
//     refreshPanel1('Dashboard');
//   }
// });
