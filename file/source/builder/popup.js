//top.dzstaa_startinit = '[zoomtabsandaccordions skin="skin-blue" settings_starttab="1" design_tabsposition="bottom"][dzstaa_tab][dzstaa_tab_title]insert title here[/dzstaa_tab_title][dzstaa_tab_content]insert content here[/dzstaa_tab_content][/dzstaa_tab][dzstaa_tab][dzstaa_tab_title]insert title here[/dzstaa_tab_title][dzstaa_tab_content]celebrate the feeling<br><br>cant complain about much these days<br>[/dzstaa_tab_content][/dzstaa_tab][/zoomtabsandaccordions]';

//top.dzstaa_startinit='[zoomtabsandaccordions skin="skin-default" design_tabsposition="top" settings_enable_linking="off" settings_is_always_accordion="off" toggle_type="accordion" settings_appendwholecontent="on"][dzstaa_tab][dzstaa_tab_title]insert title here[/dzstaa_tab_title][dzstaa_tab_content]insert content here[/dzstaa_tab_content][/dzstaa_tab][dzstaa_tab][dzstaa_tab_title]insert title here[/dzstaa_tab_title][dzstaa_tab_content]insert content [zoomtabsandaccordions skin="skin-default" design_tabsposition="top" settings_enable_linking="off" settings_is_always_accordion="off" toggle_type="accordion" settings_appendwholecontent="off"][dzstaa_tab][dzstaa_tab_title]insert title here[/dzstaa_tab_title][dzstaa_tab_content]insert content here[/dzstaa_tab_content][/dzstaa_tab][dzstaa_tab][dzstaa_tab_title]insert title here[/dzstaa_tab_title][dzstaa_tab_content]insert content here[/dzstaa_tab_content][/dzstaa_tab][/zoomtabsandaccordions] here[/dzstaa_tab_content][/dzstaa_tab][dzstaa_tab][dzstaa_tab_title]insert title here[/dzstaa_tab_title][dzstaa_tab_content]insert content here[/dzstaa_tab_content][/dzstaa_tab][/zoomtabsandaccordions]';
//top.dzstaa_startinit='<!-- remember the following shortcode for placing inside the generator: [zoomtabsandaccordions skin="skin-default" design_tabsposition="top" settings_enable_linking="off" settings_is_always_accordion="off" toggle_type="accordion" settings_appendwholecontent="off"][dzstaa_tab][dzstaa_tab_title]insert title here[/dzstaa_tab_title][dzstaa_tab_content]insert content here[/dzstaa_tab_content][/dzstaa_tab][dzstaa_tab][dzstaa_tab_title]insert title here[/dzstaa_tab_title][dzstaa_tab_content]insert content here[/dzstaa_tab_content][/dzstaa_tab][/zoomtabsandaccordions]--> <div class="dzs-tabs auto-init skin-default" data-options=\'{design_tabsposition:"top",settings_enable_linking:"off",settings_is_always_accordion:"off",toggle_type:"accordion",settings_appendWholeContent:true}\'><div class="dzs-tab-tobe"><div class="tab-menu with-tooltip">insert title here</div><div class="tab-content">insert content here</div></div><div class="dzs-tab-tobe"><div class="tab-menu with-tooltip">insert title here</div><div class="tab-content">insert content here</div></div></div>';

//<div class="dzstaa-table skin-default-black two-in-a-row" id="generator-dzstaa"> <div class="dzstaa-col"><div class="dzstaa-col-inner"><div class="dzstaa-item title-item">title</div><div class="dzstaa-item"><span class="feat-currency">$</span><span class="feat-ammount">10</span><span class="feat-period">per month</span></div><div class="dzstaa-item">test3</div></div></div><div class="dzstaa-col"><div class="dzstaa-col-inner"><div class="dzstaa-item">test21</div><div class="dzstaa-item">test22</div><div class="dzstaa-item">test23</div></div></div></div>



if(dzstaa_settings.startSetup!=''){
    top.dzstaa_startinit = dzstaa_settings.startSetup;
}

var generator_items = [{'content':'insert content here', 'title':'insert title here'}];
var generator_options = {};
var generator_current_tab = -1;
var generator_current_content = -1;

var includemediasupport = ',responsivefilemanager';


var tinymce_settings = {
    script_url : dzstaa_settings.thepath + 'tinymce/jscripts/tiny_mce/tiny_mce.js'
    ,mode : "textareas"
    ,theme : "modern"
    ,plugins : "image,code,media,hr,fullscreen,advlist,fontawesome"+includemediasupport
    ,relative_urls : false
    ,remove_script_host : false
    ,image_advtab: true
    ,convert_urls : true
    ,forced_root_block : ""
    ,extended_valid_elements: 'span[class],a[*]'
    ,content_css: '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css'
    ,theme_advanced_toolbar_location : "top"
    //,theme_advanced_toolbar_align : "left"
    //,theme_advanced_statusbar_location : "bottom"
    ,toolbar: "bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | removeformat code  | fontawesome | responsivefilemanager"

    ,external_filemanager_path:dzstaa_settings.thepath + 'builder/tinymce/filemanager/'
    ,filemanager_title:"Responsive Filemanager"
    ,external_plugins: { "filemanager" : dzstaa_settings.thepath + 'filemanager/plugin.min.js'}
    ,setup : function(ed) {
        // Add a custom button
        //console.info(dzstaa_settings.thepath + 'tinymce/img/addimagebutton.png');
        ed.addButton('addimagebutton', {
            title : 'Add Image via WordPress Uploader',
            image : dzstaa_settings.thepath + 'tinymce/img/addimagebutton.png',
            onclick : function() {
                // Add you own code to execute something on click
                ed.focus();
                if ( typeof file_frame !='undefined' ) {
                    file_frame.open();
                    return;
                }

                // Create the media frame.
                file_frame = wp.media.frames.file_frame = wp.media({
                    title: jQuery( this ).data( 'uploader_title' ),
                    button: {
                        text: jQuery( this ).data( 'uploader_button_text' )
                    },
                    multiple: false  // Set to true to allow multiple files to be selected
                });

                // When an image is selected, run a callback.
                file_frame.on( 'select', function() {
                    // We set multiple to false so only get one image from the uploader
                    var att = file_frame.state().get('selection').first().toJSON();

                    //console.log(attachment);
                    ed.selection.setContent('<img src="'+att.url+'" class="fullwidth needs-loading"/>');

                    // Do something with attachment.id and/or attachment.url here
                });

                // Finally, open the modal
                file_frame.open();
            }
        });
    }
};


function htmlEncode(arg){
    return jQuery('<div/>').text(arg).html();
}

function htmlDecode(value){
    return jQuery('<div/>').html(arg).text();
}



jQuery(document).ready(function($){
    //--- 1 generator per page



    window.dzstaa_init_generator = function () {
        var coll_buffer = 0;
        var fout = '';
        var file_frame;
        var auxa = [];
        var inter_refresh_preview = null;

        var _cmain = $('#generator-dzstaa');

        reskin_select();

        var shortcode_inshortcode_actualcontent = '';


        initmarkup_ishtml = false;
        initmarkup_isshortcode = false;

        //console.info($('.changer-skin'));

        $('.changer-skin').unbind('change', change_skin);
        $('.changer-skin').bind('change', change_skin);
        $('.btn-master-generate').unbind('click', click_master_generate);
        $('.btn-master-generate').bind('click', click_master_generate);
        $('.btn-submit-start-content').unbind('click', click_submit_start_content);
        $('.btn-submit-start-content').bind('click', click_submit_start_content);
        $(document).undelegate('.btn-add-tab', 'click', click_add_tab);
        $(document).delegate('.btn-add-tab', 'click', click_add_tab);
        $(document).undelegate('.delete-trigger', 'click', click_item_editor_delete_trigger);
        $(document).delegate('.delete-trigger', 'click', click_item_editor_delete_trigger);
        $(document).undelegate('.btn-close-generator', 'click', click_close_generator);
        $(document).delegate('.btn-close-generator', 'click', click_close_generator);
        $(document).undelegate('.changer-color', 'change', change_color);
        $(document).delegate('.changer-color', 'change', change_color);
        $(document).undelegate('.textinput', 'change', change_textinput);
        $(document).delegate('.textinput', 'change', change_textinput);




        $(document).undelegate('#generator-dzstaa .dzs-tabs .tabs-menu .tab-menu-con.active .tab-menu', 'click', click_for_edit_tab_menu);
        $(document).undelegate('#generator-dzstaa .dzs-tabs .tabs-content div.tab-content.active', 'click', click_for_edit_tab_content);
        $(document).undelegate('.item-editor .update-trigger', 'click', click_item_editor_update_trigger);
        $(document).delegate('#generator-dzstaa .dzs-tabs .tabs-menu .tab-menu-con.active .tab-menu', 'click', click_for_edit_tab_menu);
        $(document).delegate('#generator-dzstaa .dzs-tabs .tabs-content div.tab-content.active', 'click', click_for_edit_tab_content);
        $(document).delegate('.item-editor .update-trigger', 'click', click_item_editor_update_trigger);


//    var regex_initmarkup_isshortcode = /\[zoomtabsandaccordions.*?\][\s\S]*?\[\/zoomtabsandaccordions]/g;

        var regex_isshortcode_insideshortcode = /\[zoomtabsandaccordions.*?\][\s\S]*?(\[zoomtabsandaccordions.*?\][\s\S]*?\[\/zoomtabsandaccordions])/g;


        if (typeof top.dzstaa_startinit != 'undefined' && top.dzstaa_startinit != '') {
            if (regex_isshortcode_insideshortcode.test(top.dzstaa_startinit)) {
                regex_isshortcode_insideshortcode.lastIndex = 0;
                var auxa = (regex_isshortcode_insideshortcode.exec(top.dzstaa_startinit));
//            console.info(auxa[1]);
                shortcode_inshortcode_actualcontent = auxa[1];
//            auxa[1]='zoomtabs'
                top.dzstaa_startinit = String(top.dzstaa_startinit).replace(auxa[1], '<br>{{shortcodeinshortcodeplaceholder}}<br>');
//            console.info(auxa[1], top.dzstaa_startinit);
            }
        }

        if (typeof top.dzstaa_startinit != 'undefined' && top.dzstaa_startinit != '') {

//        console.info(top.dzstaa_startinit)

            var regex_initmarkup_isshortcode = /\[zoomtabsandaccordions.*?\][\s\S]*?\[\/zoomtabsandaccordions]/g;

            $('.popup-admin-wrapper').append('<div class="misc-initSetup"><h5>Start Setup</h5></h5><p>' + htmlEncode(top.dzstaa_startinit) + '</p></div>');


            if (regex_initmarkup_isshortcode.test(top.dzstaa_startinit)) {


                var str_main = top.dzstaa_startinit;

                //console.log(top.dzstaa_startinit);


                var regex_skin = /skin-.*?(?=[\s|"])/;
                if (regex_skin.test(str_main)) {
                    regex_skin.lastIndex = 0;
                    var arr_aux = (regex_skin.exec(str_main))
                    //console.log(arr_aux[0]);
                    $('select[name=skin]').val(arr_aux[0]).trigger('change');
                }
                var regex_aux = /settings_starttab="(.*?)"/g;
                if (regex_aux.test(str_main)) {
                    regex_aux.lastIndex = 0;
                    var arr_aux = (regex_aux.exec(str_main))
                    $('*[name=settings_starttab]').val(arr_aux[1]).trigger('change');
                }
                var regex_aux = /design_tabsposition="(.*?)"/g;
                if (regex_aux.test(str_main)) {
                    regex_aux.lastIndex = 0;
                    var arr_aux = (regex_aux.exec(str_main))
                    $('*[name=design_tabsposition]').val(arr_aux[1]).trigger('change');
                }
                var regex_aux = /settings_appendwholecontent="(.*?)"/;
                if (regex_aux.test(str_main)) {
                    regex_aux.lastIndex = 0;
                    var arr_aux = (regex_aux.exec(str_main))
                    $('*[name=settings_appendwholecontent]').val(arr_aux[1]).trigger('change');
                }


                var regex_aux = /toggle_breakpoint="(.*?)"/g;
                if (regex_aux.test(str_main)) {
                    regex_aux.lastIndex = 0;
                    var arr_aux = (regex_aux.exec(str_main))
                    $('*[name=toggle_breakpoint]').val(arr_aux[1]).trigger('change');
                }


                //arr_items = regex_item.exec(str_main);
                //arr_items = str_main.match(regex_item);

                generator_items = [];


                //console.log(regex_dzstaa_col.exec(str_main))

                var regex_dzstaa_tab = /\[dzstaa_tab.*?\]([\s\S]*?)\[\/dzstaa_tab\]/g;
                var breaki = 0; // == failsafe
                auxa = [];
                while (auxa = regex_dzstaa_tab.exec(str_main)) {

                    var regex_dzstaa_tab_content = /\[dzstaa_tab_content.*?\]([\s\S]*?)\[\/dzstaa_tab_content\]/g;
                    var regex_dzstaa_tab_title = /\[dzstaa_tab_title.*?\]([\s\S]*?)\[\/dzstaa_tab_title\]/g;

                    if (!auxa[1]) {
                        continue;
                    }


                    var auxac = regex_dzstaa_tab_content.exec(auxa[1]);
                    var auxat = regex_dzstaa_tab_title.exec(auxa[1]);

                    var str_title = '';
                    var str_content = '';

                    if (auxac[1]) {
                        str_content = auxac[1];
                    }
                    if (auxat[1]) {
                        str_title = auxat[1];
                    }

                    var auxobj = {'content': str_content, 'title': str_title};
                    generator_items.push(auxobj);

                    breaki++;
                    if (breaki > 30) {
                        break;
                    }
                    // match is now the next match, in array form.
                }


                regex_initmarkup_isshortcode.lastIndex = 0;
            }


            if (regex_initmarkup_isshortcode.test(top.dzstaa_startinit) == false) {
                $('.popup-admin-wrapper').append('<div class="error">layout is broken</div>');
            }


        }


        refresh_all();


        prepare_preview();

        function click_item_editor_update_trigger() {
            update_generator_items();
            prepare_preview();

            generator_current_content = -1;
            generator_current_tab = -1;


            $('.delete-trigger').removeClass('active');

            $('.item-editor').html('');
        }

        function click_item_editor_delete_trigger() {

            var r = confirm("Are you sure you want to delete this tab ?");
            if (r == false) {
                return;
            }

            if (generator_current_content > -1) {
                generator_items.splice(generator_current_content, 1);
            } else {
                if (generator_current_tab > -1) {

                    generator_items.splice(generator_current_tab, 1);
                }
            }

            update_generator_items();
            prepare_preview();

            generator_current_content = -1;
            generator_current_tab = -1;
            $('.delete-trigger').removeClass('active');

            $('.item-editor').html('');
        }

        function update_generator_items() {

            if (generator_current_content > -1) {

                if (generator_items[generator_current_content]) {
                    var aux_html = $('.item-editor textarea').eq(0).tinymce().getContent({format: 'raw'});
                    generator_items[generator_current_content].content = aux_html;
                }

            }
            if (generator_current_tab > -1) {

                if (generator_items[generator_current_tab]) {
                    var aux_html = $('.item-editor textarea').eq(0).tinymce().getContent({format: 'raw'});
                    generator_items[generator_current_tab].title = aux_html;
                }
            }

        }

        function change_textinput() {

            if (inter_refresh_preview) {
                clearTimeout(inter_refresh_preview);
            }
            inter_refresh_preview = setTimeout(prepare_preview, 200);

        }

        function click_for_edit_tab_menu(e) {
            var _t = $(this);
            var ind = _t.parent().parent().children().index(_t.parent());

            if (generator_current_content > -1 || generator_current_tab > -1) {
                update_generator_items();
            }


            generator_current_content = -1;
            generator_current_tab = ind;

            $('.delete-trigger').addClass('active');


            $('.item-editor').html('<h3 style="margin-top: 0;">Edit Item - <span class="update-trigger">click here to update</span></h3><textarea>' + generator_items[ind].title + '</textarea>');

            $('.item-editor textarea').tinymce(tinymce_settings);


        }

        function click_for_edit_tab_content(e) {
            var _t = $(this);
            var ind = _t.parent().children().index(_t);

            if (generator_current_content > -1 || generator_current_tab > -1) {
                update_generator_items();
            }

            generator_current_content = ind;
            generator_current_tab = -1;

            $('.delete-trigger').addClass('active');

            $('.item-editor').html('<h3 style="margin-top: 0;">Edit Item - <span class="update-trigger">click here to update</span></h3><textarea>' + generator_items[ind].content + '</textarea>');

            $('.item-editor textarea').tinymce(tinymce_settings);
        }


        function construct_generators() {

        }

        function prepare_fout() {
            //console.log($('img'));
            var cnt = '';
            fout = '';
            var _c = null;
            var _cmain = $('#generator-dzstaa');


            //-- if there is any item in editing lets update
            if (generator_current_content > -1 || generator_current_tab > -1) {
                update_generator_items();
            }

            _cmain.find('.aux-icon').remove();

            var aux = '';


            // -- we start html generation from here...

            fout += '<!-- remember the following shortcode for placing inside the generator: ';

            // -- we end html generation here...

            fout += '[zoomtabsandaccordions';
            _c = $('select[name=skin]');
            if (_c.val() != '') {
                fout += ' skin="' + _c.val() + '"';
            }

            aux = 'settings_starttab'
            _c = $('*[name=' + aux + ']');
            if (_c.val() != '') {
                fout += ' ' + aux + '="' + _c.val() + '"';
            }

            aux = 'design_tabsposition'
            _c = $('*[name=' + aux + ']');
            if (_c.val() != '') {
                fout += ' ' + aux + '="' + _c.val() + '"';
            }

            aux = 'toggle_breakpoint'
            _c = $('*[name=' + aux + ']');
            if (_c.val() != '') {
                fout += ' ' + aux + '="' + _c.val() + '"';
            }

            aux = 'design_highlightcolor'
            _c = $('*[name=' + aux + ']');
            if (_c.val() != '') {
                fout += ' ' + aux + '="' + _c.val() + '"';
            }
            aux = 'settings_enable_linking'
            _c = $('*[name=' + aux + ']');
            if (_c.val() != '') {
                fout += ' ' + aux + '="' + _c.val() + '"';
            }
            aux = 'settings_is_always_accordion'
            _c = $('*[name=' + aux + ']');
            if (_c.val() != '') {
                fout += ' ' + aux + '="' + _c.val() + '"';
            }

            aux = 'toggle_type'
            _c = $('*[name=' + aux + ']');
            if (_c.val() != '') {
                fout += ' ' + aux + '="' + _c.val() + '"';
            }

            aux = 'settings_appendwholecontent'
            _c = $('*[name=' + aux + ']');
            if (_c.val() != '') {
                fout += ' ' + aux + '="' + _c.val() + '"';
            }


            fout += ']';
            for (i = 0; i < generator_items.length; i++) {

                var _t = $(this);

                if (shortcode_inshortcode_actualcontent != '') {
                    generator_items[i].content = String(generator_items[i].content).replace('<br>{{shortcodeinshortcodeplaceholder}}<br>', shortcode_inshortcode_actualcontent);
                }


                fout += '[dzstaa_tab]';

                fout += '[dzstaa_tab_title]' + generator_items[i].title + '[/dzstaa_tab_title]';
                fout += '[dzstaa_tab_content]' + generator_items[i].content + '[/dzstaa_tab_content]';

                fout += '[/dzstaa_tab]';
            }
            fout += '[/zoomtabsandaccordions]';


            if (window.console) {
                console.log(fout);
            }

            // -- we start html generation from here...


            fout += '-->\n\n\n\n\n\n';


            aux = 'design_highlightcolor';
            _c = $('*[name=' + aux + ']');
            if (_c.val() != '') {
                fout += '<style>';
                fout += 'body .dzs-tabs.skin-blue .tabs-menu .tab-menu-con.active .tab-menu{ background-color: ' + _c.val() + '; }';
                fout += 'body .dzs-tabs.skin-melbourne .tabs-menu .tab-menu-con.active{ border-color: ' + _c.val() + '; color: ' + _c.val() + '; }';
                fout += 'body .dzs-tabs.skin-default .tabs-menu .tab-menu-con.active .tab-menu{ border-color: ' + _c.val() + '; }';
                fout += '</style>';
            }

            fout += '<div class="dzs-tabs auto-init';

            _c = $('select[name=skin]');
            if (_c.val() != '') {
                fout += ' ' + _c.val() + '';
            }

            fout += '"' + " data-options='{";


            aux = 'design_tabsposition'
            _c = $('*[name=' + aux + ']');
            if (_c.val() != '') {
                fout += '' + aux + ':"' + _c.val() + '"';
            }


            aux = 'settings_starttab';
            _c = $('*[name=' + aux + ']');
            if (_c.val() != '') {
                fout += ',settings_startTab:"' + _c.val() + '"';
            }
            aux = 'toggle_breakpoint';
            _c = $('*[name=' + aux + ']');
            if (_c.val() != '') {
                fout += ',' + aux + ':"' + _c.val() + '"';
            }
            aux = 'settings_enable_linking';
            _c = $('*[name=' + aux + ']');
            if (_c.val() != '') {
                fout += ',' + aux + ':"' + _c.val() + '"';
            }
            aux = 'settings_is_always_accordion';
            _c = $('*[name=' + aux + ']');
            if (_c.val() != '') {
                fout += ',' + aux + ':"' + _c.val() + '"';
            }
            aux = 'toggle_type';
            _c = $('*[name=' + aux + ']');
            if (_c.val() != '') {
                fout += ',' + aux + ':"' + _c.val() + '"';
            }
            aux = 'settings_appendwholecontent';
            _c = $('*[name=' + aux + ']');
            if (_c.val() != '') {
                fout += ',settings_appendWholeContent:true';
            }

            fout += "}'";
            fout += '>';

            for (i = 0; i < generator_items.length; i++) {


                if (shortcode_inshortcode_actualcontent != '') {
                    generator_items[i].content = String(generator_items[i].content).replace('<br>{{shortcodeinshortcodeplaceholder}}<br>', shortcode_inshortcode_actualcontent);
                }


                fout += '<div class="dzs-tab-tobe">';

                fout += '<div class="tab-menu with-tooltip">' + generator_items[i].title + '</div>';
                fout += '<div class="tab-content">' + generator_items[i].content + '</div>';

                fout += '</div>';
            }
            fout += '</div>';

            // -- we end html generation here...


            return fout;
        }

        function change_skin() {
            var _t = $(this);

            refresh_all();
        }

        function change_color() {
            //console.log('ceva');

            if ($('select[name=skin]').val() != 'skin-default' && $('select[name=skin]').val() != 'skin-default-black') {
                $('#generator-dzstaa-style').html('');
                return;
            }

            var color_style_text = '';

            if ($('input[name=color_bg]').val() != '') {
                color_style_text += '#generator-dzstaa .dzstaa-col .dzstaa-col-inner{background-color:' + $('input[name=color_bg]').val() + ';} #generator-dzstaa .dzstaa-col-inner .dzstaa-item:nth-child(2n){background-color:' + $('input[name=color_bg]').val() + ';} #generator-dzstaa .dzstaa-col-inner .dzstaa-item.title-item{background-color:' + $('input[name=color_bg]').val() + ';}  #generator-dzstaa .dzstaa-col .dzstaa-col.premium-col .dzstaa-col-inner .title-item{ background-color:' + $('input[name=color_bg]').val() + '; } ';
            }
            if ($('input[name=color_bg2]').val() != '') {
                color_style_text += ' #generator-dzstaa .dzstaa-col-inner .dzstaa-item:nth-child(2n+1){background-color:' + $('input[name=color_bg]').val() + ';} ';
            }
            if ($('input[name=color_text]').val() != '') {
                color_style_text += ' #generator-dzstaa {color:' + $('input[name=color_text]').val() + ';} ';
            }
            if ($('input[name=color_high]').val() != '') {
                color_style_text += ' #generator-dzstaa .dzstaa-col .dzstaa-col-inner .title-item{color:' + $('input[name=color_high]').val() + ';} #generator-dzstaa .dzstaa-col .dzstaa-col.premium-col .dzstaa-col-inner .title-item{ background-color:' + $('input[name=color_high]').val() + '; }';
            }


            //console.info(color_style_text);

            $('#generator-dzstaa-style').html(color_style_text);


        }

        function change_col_ispremium() {
            var _t = $(this);

            //console.info(_t.prop('checked'));
            if (_t.prop('checked') == true) {
                _t.parent().parent().parent().addClass('premium-col');
            } else {
                _t.parent().parent().parent().removeClass('premium-col');

            }
        }


        function refresh_column_number() {
            var _c = jQuery('#generator-dzstaa');
            _c.removeClass('one-in-a-row two-in-a-row three-in-a-row four-in-a-row five-in-a-row six-in-a-row ')
            var len_cols = _c.find('.dzstaa-col').length;
            switch (len_cols) {
                case 2:
                    _c.addClass('two-in-a-row');
                    jQuery('.btn-add-column').css({
                        'pointer-events': 'auto', 'opacity': 1
                    })
                    break;
                case 3:
                    _c.addClass('three-in-a-row');
                    jQuery('.btn-add-column').css({
                        'pointer-events': 'auto', 'opacity': 1
                    })
                    break;
                case 4:
                    _c.addClass('four-in-a-row');
                    jQuery('.btn-add-column').css({
                        'pointer-events': 'auto', 'opacity': 1
                    })
                    break;
                case 5:
                    _c.addClass('five-in-a-row');
                    jQuery('.btn-add-column').css({
                        'pointer-events': 'auto', 'opacity': 1
                    })
                    break;
                case 6:
                    _c.addClass('six-in-a-row');
                    jQuery('.btn-add-column').css({
                        'pointer-events': 'none', 'opacity': 0.5
                    })
                    break;
                default:
                    _c.addClass('one-in-a-row');
                    jQuery('.btn-add-column').css({
                        'pointer-events': 'auto', 'opacity': 1
                    })
                    break;
            }

            _c.find('.dzstaa-col').each(function () {
                var _t = $(this);

                if (_t.find('.column-options').length == 0) {
                    _t.append('<div class="column-options"><div class="btn-add-row"><i class="fa fa-plus white-circle-bg">&nbsp;</i>Add Row</div><br><br><span class="checkbox-con"><input type="checkbox" value="on" name="col_ispremium">&nbsp;&nbsp;Premium Column</span><br><br><div class="btn-delete-column"><i class="fa fa-minus white-circle-bg">&nbsp;</i>Delete Column</div></div>');
                }
                ;


            });


        }

        function refresh_all() {
            var _c = jQuery('#generator-dzstaa');

            _c.removeClass('skin-default skin-default-black skin-the-grey skin-emerald skin-clean');
            _c.addClass(jQuery('select[name=skin]').val());

            refresh_column_number();


        }

        function click_add_tab(e) {

            var aux = {'content': 'insert content here', 'title': 'insert title here'};
            generator_items.push(aux);
            prepare_preview();
        }

        function click_close_generator() {
            var _t = $(this);
            var _tcon = _t.parent().parent();
            var aux_html = _tcon.find('textarea.the-dzstaa-item-content').tinymce().getContent({format: 'raw'});
            aux_html += '<i class="aux-icon fa fa-pencil"></i>';
            _tcon.prev().html(aux_html);
            _tcon.removeClass('active');

            _tcon.prev().removeClass('title-item price-item purchase-item');

            if (_tcon.find('input[name=istitle]').prop('checked') == true) {
                _tcon.prev().addClass('title-item');
            }
            if (_tcon.find('input[name=isprice]').prop('checked') == true) {
                _tcon.prev().addClass('price-item');
            }
            if (_tcon.find('input[name=ispurchase]').prop('checked') == true) {
                _tcon.prev().addClass('purchase-item');
            }
            if (_tcon.find('input[name=outofcontainer]').prop('checked') == true) {
                //console.log(_tcon);

                if (_tcon.parent().is('.dzstaa-col') == false) {

                    _tcon.find('textarea.the-dzstaa-item-content').tinymce().remove();
                    _tcon.parent().before(_tcon.prev());
                    _tcon.parent().before(_tcon);
                    _tcon.find('textarea.the-dzstaa-item-content').tinymce(tinymce_settings);
                }
            } else {
                //console.log(jQuery('.dzstaa-col'), jQuery('.dzstaa-col').has(_tcon));
                if (jQuery('.dzstaa-col').has(_tcon).length > 0) {
                    _tcon.find('textarea.the-dzstaa-item-content').tinymce().remove();
                    _tcon.parent().find(".dzstaa-col-inner").append(_tcon.prev())
                    _tcon.parent().find(".dzstaa-col-inner").append(_tcon);
                    _tcon.find('textarea.the-dzstaa-item-content').tinymce(tinymce_settings);
                }
            }
        }

        function click_master_generate() {
            prepare_fout();
            tinymce_add_content(fout);
            return false;
        }

        function click_submit_start_content(){
//            console.info($('textarea[name=start-content]'), $('textarea[name=start-content]').val());
            top.dzstaa_startinit = $('textarea[name=start-content]').val();
            window.dzstaa_init_generator();
        }

        function click_add_biggallery() {
            var _t = $(this);

            ////console.log(_t, _t.prev());


            var data = {
                action: 'dzstaa_add_biggallery',
                postdata: _t.prev().val()
            };
            $.post(ajaxurl, data, function (response) {
                if (response.charAt(response.length - 1) == '0') {
                    response = response.slice(0, response.length - 1);
                }
                if (response.indexOf("error:") != 0) {
                    if (window.console) {
                        console.log(_t.prev().val());
                    }
                    ;
                    $('.radios-biggallery').append('<input name="settings_biggallery" type="radio" value="' + _t.prev().val() + '"/>  ' + _t.prev().val() + '<br>');
                }


                _t.prev().val('');
                if (typeof window.console != "undefined") {
                    //console.log('Got this from the server: ' + response);
                }


                //$('.preview-inner').html(response);
                //jQuery('#save-ajax-loading').css('visibility', 'hidden');
            });

            return false;
        }

        function click_upload_bigmedia() {

            var _t = $(this);

            var valtarget = _t.prev();
            // If the media frame already exists, reopen it.
            if (file_frame) {
                file_frame.open();
                return;
            }

            // Create the media frame.
            file_frame = wp.media.frames.file_frame = wp.media({
                title: jQuery(this).data('uploader_title'),
                button: {
                    text: jQuery(this).data('uploader_button_text')
                },
                multiple: false  // Set to true to allow multiple files to be selected
            });

            // When an image is selected, run a callback.
            file_frame.on('select', function () {
                // We set multiple to false so only get one image from the uploader
                attachment = file_frame.state().get('selection').first();
                //console.log(attachment);
                // Do something with attachment.id and/or attachment.url here

                valtarget.val(attachment.attributes.url);
                file_frame.close();
            });

            // Finally, open the modal
            file_frame.open();


            return false;
        }

        function prepare_preview() {

            var aux_html_style = '';

            if ($('input[name=design_highlightcolor]').val() != '') {
                var val = $('input[name=design_highlightcolor]').val();
                aux_html_style = 'body .dzs-tabs.skin-blue .tabs-menu .tab-menu-con.active .tab-menu{ background-color: ' + val + '; }';
                aux_html_style += 'body .dzs-tabs.skin-default .tabs-menu .tab-menu-con.active .tab-menu { border-color: ' + val + ';  }';
                aux_html_style += 'body .dzs-tabs.skin-melbourne .tabs-menu .tab-menu-con.active { border-color: ' + val + '; color: ' + val + ';  }';
            }
            $('#generator-dzstaa-style').html(aux_html_style);


            var aux_html = '';

            aux_html = '<div class="dzs-tabs ';


            _c = $('select[name=skin]');
            if (_c.val() != '') {
                aux_html += _c.val();
            }
//        console.info(_c.val());

            aux_html += '">';
            for (i = 0; i < generator_items.length; i++) {

                aux_html += '<div class="dzs-tab-tobe">';
                aux_html += '<div class="tab-menu">';
                aux_html += generator_items[i].title;
                aux_html += '<div class="dzstooltip arrow-bottom width-auto test" style="left:50%; margin-left: -27px; margin-bottom: 0;">Edit</div>';
                aux_html += '</div>';
                aux_html += '<div class="tab-content">';
                aux_html += generator_items[i].content;
                aux_html += '<div class="dzstooltip arrow-bottom width-auto test" style="left:27px; margin-left: -27px; margin-bottom: 10px;">Edit</div>';
                aux_html += '</div>';
                aux_html += '</div>';

            }
            aux_html += '</div>';


            _cmain.html(aux_html);

            _c = $('*[name=design_tabsposition]');
            generator_options.design_tabsposition = _c.val();
            _c = $('*[name=settings_starttab]');
            if (_c.val() != '') {

                generator_options.settings_startTab = _c.val();
            }
            _cmain.children('.dzs-tabs').dzstabsandaccordions(generator_options);
            //alert('ceva');
//        prepare_fout();
//        //console.log(fout);
//        var data = {
//            action: 'dzstaa_preparePreview',
//            postdata: fout
//        };
//        $.post(ajaxurl, data, function(response) {
//            if(response.charAt(response.length-1) == '0'){
//                response = response.slice(0,response.length-1);
//            }
//            if(typeof window.console != "undefined" ){
//            //console.log('Got this from the server: ' + response);
//            }
//            response+='<script>jQuery(document).ready(function($){ $(".zoombox").zoomBox(); });</script>'
//            $('.preview-inner').html(response);
//        //jQuery('#save-ajax-loading').css('visibility', 'hidden');
//        });
        }

    }


    dzstaa_init_generator();
})
function tinymce_add_content(arg){

    if(typeof(top.dzstaa_receiver)=='function'){
        top.dzstaa_receiver(arg);
    }else{
        jQuery('.output-div').text(arg).html();
        jQuery('.output-div').prepend('<h3>Output</h3>')
    }
}
function reskin_select(){
    for(i=0;i<jQuery('select').length;i++){
        var $cache = jQuery('select').eq(i);
        //console.log($cache.parent().attr('class'));
		
        if($cache.hasClass('styleme')==false || $cache.parent().hasClass('select_wrapper') || $cache.parent().hasClass('select-wrapper')){
            continue;
        }
        var sel = ($cache.find(':selected'));
        $cache.wrap('<div class="select-wrapper"></div>')
        $cache.parent().prepend('<span>' + sel.text() + '</span>')
    }
    jQuery('.select-wrapper select').unbind();
    jQuery(document).on('change','.select-wrapper select',change_select);	
        
    function change_select(){
        var selval = (jQuery(this).find(':selected').text());
        jQuery(this).parent().children('span').text(selval);
    }
}
