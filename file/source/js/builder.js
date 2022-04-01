



jQuery(document).ready(function($){





    var _areaCanvas = $('.dzszvp-builder-con--canvas-area').eq(0);
    var _areaLayers = $('.dzszvp-builder-con--layers-area').eq(0);
    var _style_areaCanvas = $('style.style-for--canvas-area').eq(0);


    dzsscr_init('.scroller-con');

    _areaLayers.sortable({
        placeholder: "ui-state-highlight"
        ,handle: '.sortable-handle-con'
        ,start: function(arg1,arg2){
            var _t = arg2.item;
//            console.info(_t.find('.with-tinymce.activated'))

        }
        ,stop: function(){
            arrange_layers();
            update_fields();
        }
    });
//    _areaLayers.disableSelection();


    $('.dzszvp-builder-con--add-area').children().draggable({

        helper: "clone",
        revert: "invalid"
    });


    $(document).delegate('.builder-align-selector', 'click', function(){
        var _t = $(this);

        $('.builder-align-selector').removeClass('active');

        _t.addClass('active');

        $('*[name*="[builder_align]"]').val(_t.attr('data-val'));

        update_fields();
    });




    $( ".dzszvp-builder-con--canvas-area" ).droppable({
        drop: function( e, ui ) {
//            console.info(e, ui, this, ui.draggable );
            var _t = $(this);
            var _comp = $(ui.draggable).children().eq(0);
            var _comp_class = _comp.attr('class');

            _t.removeClass('component-over');

//            console.info(_t, _comp, _t.has(_comp));
            if(_comp.length==0 || _t.has(_comp).length>0){
                return;
            }

            var dropl = ui.position.left;
            var dropt = ui.position.top;

            if(dropl<0){ dropl = 0; }
            if(dropt<0){ dropt = 0; }




//            _t_class = _t_class.replace('ui-draggable', '');
//            _t_class = _t_class.replace('ui-draggable-handle', '');

//            var aux = '<div class="builder-layer';
//            aux+='">';
//            aux+='<div class="builder-layer--head">';
//            aux+='<input type="hidden" name="bars[0][class]" value="'+_comp_class+'"/><textarea class="hidden" name="bars[0][innerhtml]"></textarea><span class="the-title">'+_comp_class+'</span><span class="sortable-handle-con"><span class="sortable-handle"></span></span>';
//            aux+='</div>';
//
//
//            aux+='<div class="builder-layer--inside"><div class="dzs-tabs skin-box"><div class="dzs-tab-tobe">            <div class="tab-menu with-tooltip">            Position            </div>            <div class="tab-content">            <div class="setting">            <div class="setting-label">Type</div><select name="bars[0][position_type]" class="styleme builder-field"><option value="absolute">absolute</option><option value="relative" selected>relative</option></select></div>            <div class="one-half">            <div class="setting">            <div class="setting-label">Width</div>            <input class="builder-field" type="text" name="bars[0][width]" value="'++'">                </div>                </div>            <div class="one-half">            <div class="setting">            <div class="setting-label">Height</div>            <input class="builder-field" type="text" name="bars[0][height]" value="'+_comp.get(0).style.height+'">                </div>                </div>    <div class="clear"></div>            <hr>            <div class="one-half" style="float:none; margin: 0 auto;">            <div class="setting">            <div class="setting-label">Top</div>            <input class="builder-field" type="text" name="bars[0][top]" value="0">                </div>                </div>    <div class="clear"></div>            <div class="one-half">            <div class="setting">            <div class="setting-label">Left</div>            <input class="builder-field" type="text" name="bars[0][left]" value="0">                </div>                </div>            <div class="one-half">            <div class="setting">            <div class="setting-label">Right</div>            <input class="builder-field" type="text" name="bars[0][right]" value="auto">                </div>                </div>    <div class="clear"></div>            <div class="one-half" style="float:none; margin: 0 auto;">            <div class="setting">            <div class="setting-label">Bottom</div>            <input class="builder-field" type="text" name="bars[0][bottom]" value="auto">                </div>                </div>    <div class="clear"></div>            <hr>            <div class="one-half" style="float:none; margin: 0 auto;">            <div class="setting">            <div class="setting-label">Margin Top</div>            <input class="builder-field" type="text" name="bars[0][margin_top]" value="0">                </div>                </div>    <div class="clear"></div>            <div class="one-half">            <div class="setting">            <div class="setting-label">Margin Left</div>            <input class="builder-field" type="text" name="bars[0][margin_left]" value="0">                </div>                </div>            <div class="one-half">            <div class="setting">            <div class="setting-label">Margin Right</div>            <input class="builder-field" type="text" name="bars[0][margin_right]" value="0">                </div>                </div>    <div class="clear"></div>            <div class="one-half" style="float:none; margin: 0 auto;">            <div class="setting">            <div class="setting-label">Margin Bottom</div>            <input class="builder-field" type="text" name="bars[0][margin_bottom]" value="0">                </div>                </div>    <div class="clear"></div>            </div>        </div>            <div class="dzs-tab-tobe">                <div class="tab-menu with-tooltip">                Styling                </div>                <div class="tab-content">                <div class="setting ">            <div class="setting-label">Background Color</div>            <input class="builder-field with-colorpicker" type="text" name="bars[0][background_color]" value="#285e8e"><span class="picker-con picker-left"><span class="the-icon"></span><span class="picker"></span></span>                </div>                <div class="setting type-text">            <div class="setting-label">Color</div>            <input class="builder-field with-colorpicker" type="text" name="bars[0][color]" value="#ffffff"><span class="picker-con picker-left"><span class="the-icon"></span><span class="picker"></span></span>                </div>                <div class="setting type-circ">            <div class="setting-label">Outer Circle Color</div>            <input class="builder-field with-colorpicker" type="text" name="bars[0][circle_outside_fill]" value="#fb1919"><span class="picker-con picker-left"><span class="the-icon"></span><span class="picker"></span></span>                </div>                <div class="setting type-circ">            <div class="setting-label">Inner Circle Color</div>            <input class="builder-field with-colorpicker" type="text" name="bars[0][circle_inside_fill]" value="transparent"><span class="picker-con picker-left"><span class="the-icon"></span><span class="picker"></span></span>                </div>                                <div class="setting type-circ">            <div class="setting-label">Arc Percentage</div>            <input class="builder-field" type="text" name="bars[0][circle_outer_width]" value="{{perc-decimal}}">                </div>                <div class="setting type-circ">            <div class="setting-label">Outer Circle Width</div>            <input class="builder-field" type="text" name="bars[0][circle_line_width]" value="10">                </div>                <div class="setting type-rect">            <div class="setting-label">Border Radius</div>            <input class="builder-field" type="text" name="bars[0][border_radius]" value="0">                </div>                <div class="setting">            <div class="setting-label">Border</div>            <input class="builder-field" type="text" name="bars[0][border]" value="0">                </div>                <div class="setting">            <div class="setting-label">Opacity</div>            <input class="builder-field" type="text" name="bars[0][opacity]" value="1">                </div>                <div class="setting">            <div class="setting-label">Font Size</div>            <input class="builder-field" type="text" name="bars[0][font_size]" value="12">                <div class="jqueryui-slider for-fontsize"></div>                </div>                <div class="setting ">                    <div class="setting-label">Extra Classes</div>                    <input class="builder-field" type="text" name="bars[0][extra_classes]" value="">                </div>                <!--            <div class="setting type-text">            <div class="setting-label">Text Align</div><select name="bars[0][text_align]" class="styleme builder-field"><option value="left" selected>left</option><option value="center">center</option><option value="right">right</option></select></div>-->                <br>                </div>            </div>            <div class="dzs-tab-tobe">                <div class="tab-menu with-tooltip">                Animation                </div>                <div class="tab-content">                                <div class="setting">                    <div class="setting-label">Animation Brake</div>                    <input class="builder-field" type="text" name="bars[0][animation_brake]" value="">                    <div class="sidenote">Test</div>                </div>                            </div>            </div>        </div><a href="#" class="builder-layer--btn-delete">Delete Item</a></div>';
//
//
//            aux+='</div>';

            var aux = dzszvp_builder_settings.struct_layer;

            var str_href = '';

//            console.info(_comp.attr('href'));
            if(_comp.attr('href')){
                str_href = _comp.attr('href');
            }

//            console.info(_comp.get(0).nodeName, _comp.get(0).style.width, _comp.get(0).style.backgroundImage);

            // ---- on item drop
            aux = aux.replace(/{{jsreplace_class}}/g, _comp_class);
            aux = aux.replace(/{{jsreplace_nodename}}/g, _comp.get(0).nodeName);
            aux = aux.replace(/{{jsreplace_href}}/g, str_href);
            aux = aux.replace(/{{jsreplace_innerhtml}}/g, _comp.html());
            aux = aux.replace(/{{jsreplace_width}}/g, _comp.get(0).style.width);
            aux = aux.replace(/{{jsreplace_height}}/g, _comp.get(0).style.height);
            aux = aux.replace(/{{jsreplace_top}}/g, dropt + 'px');
            aux = aux.replace(/{{jsreplace_left}}/g, dropl + 'px');

            var aux2 = 'transparent';
            if(_comp.get(0).style.backgroundColor){
                aux2 = _comp.get(0).style.backgroundColor;
            }
            console.info(aux, aux2);
            aux = aux.replace(/{{jsreplace_backgroundColor}}/g,aux2);

            aux2 = '0';
            if(_comp.get(0).style.marginRight){
                aux2 = _comp.get(0).style.marginRight;
            }
            aux = aux.replace(/{{jsreplace_marginRight}}/g,aux2);





            _areaLayers.append(aux);
            init_dzstabsandaccordions();
            arrange_layers();
            update_fields();

        }
        ,over: function( event, ui ) {
            $(this).addClass('component-over');
        }
        ,out: function( event, ui ) {
            $(this).removeClass('component-over');
        }
    });


//    console.info($('input[name="bars[mainsettings][maxperc]"]').eq(0).val());
    $( ".jqueryui-slider.for-perc" ).slider({
        range: "max",
        min: 1,
        max: 100,
        value: $('input[name="bars[mainsettings][maxperc]"]').eq(0).val(),
        slide: function( e, ui ) {
//            $( "#amount" ).val( ui.value );
            var _t = $(this);
            var _par = _t.parent();
            _par.find('input').eq(0).val(ui.value);
            _par.find('input').eq(0).trigger('change');
        }
    });

    $('.builder-add-rect').bind('click', click_add_btn);
    $('input[name="builder_skin_name"]').bind('change', change_skin_name);
    $('.btn-show-select').bind('click', click_show_select);
    $('.btn-save-skin').bind('click', click_save_skin);
    $('.btn-preview').bind('click' ,click_preview);

    $(document).delegate('.builder-field','change', change_builder_field);
    $(document).delegate('.tab-content-styling .builder-field','change', change_builder_field_styling);
    $(document).delegate('.builder-layer--head','click', click_layer_head);
    $(document).delegate('.builder-layer--btn-delete','click', click_layer_delete);
    $(document).delegate('.dzszvp-builder-con--canvas-area > *', 'click', click_layer_in_canvas);



    $('#tabs-mainsettings').dzstabsandaccordions({
        'design_tabsposition' : 'top'
        ,design_transition: 'fade'
        ,design_tabswidth: 'fullwidth'
        ,toggle_breakpoint : '4000'
        ,toggle_type: 'toggle'
        ,settings_appendWholeContent: true
    });
    init_dzstabsandaccordions();
    reskin_select();
    arrange_layers();

    setTimeout(function(){
        update_fields();

        _areaCanvas.css('opacity',1);
        $('.saveconfirmer').removeClass('active');
    }, 500);


    function click_preview(){


        return;
        if(_areaCanvas.hasClass('inited')){
            _areaCanvas.css('height', $('input[name="bars[mainsettings][height]"]').eq(0).val());
            _areaCanvas.get(0).api_restart_and_reinit();
        }else{
            _areaCanvas.css('opacity',1);
            _areaCanvas.css('height', $('input[name="bars[mainsettings][height]"]').eq(0).val());
//            _areaCanvas.progressbars({
//                'initon' : 'init'
//                ,'maxperc' : $('input[name="bars[mainsettings][maxperc]"]').eq(0).val()
//                ,'maxnr' : $('input[name="bars[mainsettings][maxnr]"]').eq(0).val()
//                ,'animation_time' : $('input[name="bars[mainsettings][animation_time]"]').eq(0).val()
//            });
        }
    }

    function click_layer_in_canvas(){
        var _t = $(this);
        var _par = _t.parent();
        var ind = _par.children().index(_t);

        _areaLayers.children().eq(ind).addClass('active');
        $('html').animate({
            scrollTop: _areaLayers.children().eq(ind).offset().top
        }, 300);

        return false;
    }
    function click_layer_delete(){
        var r = confirm("Confirm Item Delete");
        var _t = $(this);
        var _par = _t.parent().parent();
        if (r == true) {
            _par.remove();
        }
        arrange_layers();
        update_fields();
    }
    function click_save_skin(){

        var mainarray = $('form[name="builder-form"]').serialize();
        var canvasstring = _areaCanvas.html()
        var canvasstylestring = _style_areaCanvas.html()
//        console.info(_areaCanvas, canvasstring);
        var ajaxurl = 'builder.php';
        var data = {
            action: 'dzszvp_saveskin'
            ,postdata: mainarray
            ,canvasstring: canvasstring
            ,canvasstylestring: canvasstylestring
            ,currSkin: dzszvp_builder_settings.currSkin
        };

        $('.saveconfirmer').html('Saving...');
        $('.saveconfirmer').addClass('active');
//        return false;
        $.post(ajaxurl, data, function(response) {
            if(window.console != undefined){
                console.log('Got this from the server: ' + response);
            }
            if(response.indexOf('success - ')>-1){
                $('.saveconfirmer').html('Options saved.');
            }else{
                $('.saveconfirmer').html('Seems there was a error saving....');
            }
            setTimeout(function(){

                $('.saveconfirmer').removeClass('active');
            },2000);
        });
        return false;
    }
    function change_skin_name(){
        var _t = $(this);
        $('form#create-custom-skin').attr('action', 'builder.php?skin='+_t.val());
    }
    function click_add_btn(e){
//        console.info(_areaCanvas);
        var _t = $(this);

        if(_t.hasClass('builder-add-rect')){
            _areaLayers.append(''+dzszvp_builder_settings.struct_layer+'');
        }



        init_dzstabsandaccordions();
        arrange_layers();
        reskin_select();
        update_fields();

    }

    function click_show_select(){
        var _t = $(this);
        var _par = _t.parent();

        _par.toggleClass('active');
        $('.super-select--options').eq(0)[0].reinit();
    }

    function change_builder_field(){
        var _t = $(this);
        var _t_name = _t.attr('name');

        if(_t_name.indexOf('[top]')>-1){
            if(_t.val()!='auto'){
                _t.parent().parent().parent().find('input[name*="[bottom]"]').eq(0).val('auto');
            }
        }
        if(_t_name.indexOf('[bottom]')>-1){
            if(_t.val()!='auto'){
                _t.parent().parent().parent().find('input[name*="[top]"]').eq(0).val('auto');
            }
        }
        if(_t_name.indexOf('[left]')>-1){
            if(_t.val()!='auto'){
                _t.parent().parent().parent().find('input[name*="[right]"]').eq(0).val('auto');
            }
        }
        if(_t_name.indexOf('[right]')>-1){
            if(_t.val()!='auto'){
                _t.parent().parent().parent().find('input[name*="[left]"]').eq(0).val('auto');
            }
        }
        update_fields();
    }
    function change_builder_field_styling(){
        var _t = $(this);
        var _t_name = _t.attr('name');
        arrange_layers();
        update_fields();
    }

    function update_fields(){
        _areaLayers.children('.builder-layer').each(function(){
            var _t = $(this);
            var ind = _t.parent().children().index(_t);
            var _ite = _areaCanvas.children().eq(ind);

//            console.info(_t);
            _t.find('.builder-field').each(function(){
                var _t2 = $(this);
                var props_obj = {};
                if(typeof _ite.attr('data-animprops')!='undefined' && _ite.attr('data-animprops')!=''){
                    props_obj = JSON.parse(_ite.attr('data-animprops'));
                }

                if(typeof _t2.attr('name')!='undefined' && _t2.attr('name')!=''){
                    var arr_labels = ['width','height','top', 'left','bottom','right','margin_top', 'margin_left','margin_bottom','margin_right','font_size','extra_classes', 'builder_align', 'design_set_width_to_fit', 'absolute_right_calculate', 'background_color'];

                    //'border_radius','border','opacity'
                    for(i=0;i<arr_labels.length;i++){

                        if(String(_t2.attr('name').indexOf('['+arr_labels[i]+']')) > -1){

                            var aux = arr_labels[i];
                            var val = _t2.val();
                            if( (aux=='top' || aux=='right' || aux=='bottom' || aux=='left' || aux=='width' || aux=='height') && val.indexOf('%')==-1 && val.indexOf('px')==-1 && val!='auto' ){
                                val+='px';
                            }
                            if((aux=='margin_top' || aux=='margin_right' || aux=='margin_bottom' || aux=='margin_left' || aux=='border_radius' || aux=='font_size' || aux=='background_color')){

                                aux = aux.replace('_', '-');
                                if(val.indexOf('%')==-1 && val.indexOf('px')==-1 && val!='auto' ){

                                    val+='px';
                                }
                            }

                            if(aux=='text-align'){
//                                console.info(val);
                            }
                            if(aux=='absolute_right_calculate'){
                                _ite.attr('data-absolute_right_calculate', val);
                                return;
                            }
                            if(aux=='design_set_width_to_fit'){
                                _ite.attr('data-design_set_width_to_fit', val);
                                return;
                            }
                            if(aux=='extra_classes'){
                                _ite.addClass(val);
                                return;
                            }
                            if(aux=='builder_align'){
                                _ite.removeClass('builder-align-top-left builder-align-top-right builder-align-bottom-right builder-align-bottom-left');
                                _ite.addClass(val);

                                return;
                            }

//                            console.info(aux);

                            if(val.indexOf('{{')==-1){
                                _ite.css(aux, val);

                            }else{
                                _ite.css(aux, '');
//                                console.info(_ite.attr('animprops'));


                                props_obj[aux] = _t2.val();


                            }

                        }
                    }
//                    if(String(_t2.attr('name').indexOf('[text_align]')) > -1){
//                        _areaCanvas.children().eq(ind).css({
//                            'text-align' : _t2.val()
//                        })
//
//                    }
                    if(String(_t2.attr('name').indexOf('[position_type]')) > -1){

                        _areaCanvas.children().eq(ind).css({
                            'position' : _t2.val()
                        })

                    }

                    _ite.attr('data-animprops', JSON.stringify(props_obj));
                }
            })
        });



        var right_calculate = 0;


        var tw = _areaCanvas.width();
        _areaCanvas.children('*[data-absolute_right_calculate="on"]').each(function(){
            var _t = $(this);

            _t.css('left', 'auto');
            _t.css('right', right_calculate);

            right_calculate+=_t.outerWidth(true);
        });
        _areaCanvas.children('*[data-design_set_width_to_fit="on"]').each(function(){
            var _t = $(this);
            var aux = tw - parseInt(_t.css('left'),10) - right_calculate - parseInt(_t.css('margin-right'),10);
            _t.width(aux);


        });


        var aux='';
        aux+='&lt;div class="dzs-progress-bar auto-init skin-'+dzszvp_builder_settings.currSkin+'" style="';

        var arr_labels = ['width','height','margin_top', 'margin_left','margin_bottom','margin_right'];

//        console.info($('input[name*="bars[mainsettings]"]'));
        $('input[name*="bars[mainsettings]"]').each(function(){
            var _t2 = $(this);

//            console.info(_t2, aux);
            for(i=0;i<arr_labels.length;i++) {

                if (String(_t2.attr('name').indexOf('[' + arr_labels[i] + ']')) > -1) {

                    var aux_lab = arr_labels[i];
                    var val = _t2.val();
                    if ((aux_lab == 'margin_top' || aux_lab == 'margin_right' || aux_lab == 'margin_bottom' || aux_lab == 'margin_left')) {

                        aux_lab = aux_lab.replace('_', '-');
                        if (val.indexOf('%') == -1 && val != 'auto') {

                            val += 'px';
                        }
                    }
                    aux+=''+aux_lab+':'+val+';';
                }
            }
        })
        aux+='"';

        aux+=' data-animprops=\'{';

        var auxlab = 'animation_time';
        var firstset = false;
        if($('input[name*="bars[mainsettings]['+auxlab+']"]').length>0 && $('input[name*="bars[mainsettings]['+auxlab+']"]').val()!=''){
            aux+='"'+auxlab+'":"'+$('input[name*="bars[mainsettings]['+auxlab+']"]').val()+'"';
            firstset=true;
        }

        auxlab = 'maxperc';
        if($('input[name*="bars[mainsettings]['+auxlab+']"]').length>0 && $('input[name*="bars[mainsettings]['+auxlab+']"]').val()!=''){
            if(firstset){ aux+=','; };
            aux+='"'+auxlab+'":"'+$('input[name*="bars[mainsettings]['+auxlab+']"]').val()+'"';
            firstset=true;
        }
        auxlab = 'maxnr';
        if($('input[name*="bars[mainsettings]['+auxlab+']"]').length>0 && $('input[name*="bars[mainsettings]['+auxlab+']"]').val()!=''){
            if(firstset){ aux+=','; };
            aux+='"'+auxlab+'":"'+$('input[name*="bars[mainsettings]['+auxlab+']"]').val()+'"';
            firstset=true;
        }
        auxlab = 'initon';
        if($('select[name*="bars[mainsettings]['+auxlab+']"]').length>0 && $('select[name*="bars[mainsettings]['+auxlab+']"]').val()!=''){
            if(firstset){ aux+=','; };
            aux+='"'+auxlab+'":"'+$('select[name*="bars[mainsettings]['+auxlab+']"]').val()+'"';
            firstset=true;
        }


        aux+='}\''

        aux+='&gt;';

        var aux_items = htmlEncode(_areaCanvas.html());
//        console.info(aux_items);
        aux_items = aux_items.replace(/data-animprops="(.*?)" /g ,"data-animprops='$1' ");
        aux_items = aux_items.replace(/&amp;quot;/g,'"');
//        console.info(aux_items);
        aux+=aux_items ;
        aux+='&lt;/div&gt;';

        $('.dzszvp-output-div').html(aux);
        click_preview();
    }

    function init_dzstabsandaccordions(){

        _areaLayers.children().find('.dzs-tabs').dzstabsandaccordions({
            'design_tabsposition' : 'top'
            ,design_transition: 'fade'
            ,design_tabswidth: 'fullwidth'
            ,toggle_breakpoint : '4000'
            ,toggle_type: 'toggle'
            ,settings_appendWholeContent: true
        });

        reskin_select();
        window.farbtastic_reinit();


        $( ".jqueryui-slider.for-fontsize" ).slider({
            range: "max",
            min: 11,
            max: 72,
            value: 24,
            slide: function( e, ui ) {
//            $( "#amount" ).val( ui.value );
                var _t = $(this);
                var _par = _t.parent();
                _par.find('input').eq(0).val(ui.value);
                _par.find('input').eq(0).trigger('change');
            }
        });
    }

    function arrange_layers(){
        _areaCanvas.children().remove();

//        console.info(_areaLayers.children());

        var style_canvas_area_html = '';
        for(i=0;i<_areaLayers.children().length;i++){
            var _layer = _areaLayers.children().eq(i);


            _layer.find('*[name^="bars["]').each(function(){
                var _t = $(this);
//                console.info(_t);

                var aux = _t.attr('name');

                aux = aux.replace(/bars\[(0|[1-9][0-9]*)\]/g, "bars["+i+"]");

                _t.attr('name',aux);
            })

//            console.info(_layer);

            var aux_type = _layer.find('.the-title').eq(0).html();

            var aux_nodename = 'span';

            var aux_classname =_layer.find('*[name*="[class]"]').eq(0).val();
            var aux_classname_for_css = aux_classname.replace(/ /g, '.');

            if(_layer.find('*[name*="[nodename]"]').eq(0).val()=='A'){
                aux_nodename = 'a';
            }

            var str_href = '';
            if(_layer.find('*[name*="[href]"]').eq(0).val()!=''){
                str_href = ' href="'+_layer.find('*[name*="[href]"]').eq(0).val()+'"';
            }


            _areaCanvas.append('<'+aux_nodename+' class="'+aux_classname+'" '+str_href+'>'+_layer.find('*[name*="[innerhtml]"]').eq(0).val()+'</'+aux_nodename+'>')

//            console.info(_layer.find('*[name*="[background_color]"]'), _layer.find('*[name*="[background_color]"]').eq(0).val());

            if( (_layer.find('*[name*="[background_color]"]').eq(0).val()!='' && _layer.find('*[name*="[background_color]"]').eq(0).val()!='transparent') || (_layer.find('*[name*="[hover_color]"]').eq(0).val()!='' && _layer.find('*[name*="[hover_color]"]').eq(0).val()!='transparent') ){


                if(aux_classname=='controls-bg'){
                    if((_layer.find('*[name*="[background_color]"]').eq(0).val()!='' && _layer.find('*[name*="[background_color]"]').eq(0).val()!='transparent')){
                        style_canvas_area_html+='.dzszvp-builder-con--canvas-area .'+aux_classname_for_css;
                        style_canvas_area_html+='{ background-color:'+_layer.find('*[name*="[background_color]"]').eq(0).val()+';';
                        style_canvas_area_html+='} ';
                    }

                    //console.info(aux_classname, style_canvas_area_html);
                }
                if(aux_classname=='play-btn play-btn-for-skin-default' || aux_classname=='play-btn play-btn-for-skin-playbig' || aux_classname=='play-btn play-btn-for-skin-avanti' || aux_classname=='pause-btn pause-btn-for-skin-avanti' || aux_classname.indexOf('mute-btn mute-btn-for-skin-avanti')>-1 || aux_classname=='unmute-btn unmute-btn-for-skin-avanti'){
                    if((_layer.find('*[name*="[background_color]"]').eq(0).val()!='' && _layer.find('*[name*="[background_color]"]').eq(0).val()!='transparent')){
                        style_canvas_area_html+='.dzszvp-builder-con--canvas-area .'+aux_classname_for_css+' path';
                        style_canvas_area_html+='{ fill:'+_layer.find('*[name*="[background_color]"]').eq(0).val()+';';
                        style_canvas_area_html+='} ';
                    }
                    if((_layer.find('*[name*="[hover_color]"]').eq(0).val()!='' && _layer.find('*[name*="[hover_color]"]').eq(0).val()!='transparent')){
                        style_canvas_area_html+='.dzszvp-builder-con--canvas-area .'+aux_classname_for_css+':hover path';
                        style_canvas_area_html+='{ fill:'+_layer.find('*[name*="[hover_color]"]').eq(0).val()+';';
                        style_canvas_area_html+='} ';
                    }

                }
//                console.info(aux_classname);
                if(aux_classname=='pause-btn pause-btn-for-skin-default'|| aux_classname=='fullscreen-btn fullscreen-btn-for-skin-default'|| aux_classname=='download-btn download-btn-for-skin-default'|| aux_classname=='pause-btn pause-btn-for-skin-playbig'){

                    if((_layer.find('*[name*="[background_color]"]').eq(0).val()!='' && _layer.find('*[name*="[background_color]"]').eq(0).val()!='transparent')){
                    style_canvas_area_html+='.dzszvp-builder-con--canvas-area .'+aux_classname_for_css+' rect';
                    style_canvas_area_html+='{ fill:'+_layer.find('*[name*="[background_color]"]').eq(0).val()+';';
                    style_canvas_area_html+='} ';
                    }

                    if((_layer.find('*[name*="[hover_color]"]').eq(0).val()!='' && _layer.find('*[name*="[hover_color]"]').eq(0).val()!='transparent')){
                    style_canvas_area_html+='.dzszvp-builder-con--canvas-area .'+aux_classname_for_css+':hover rect';
                    style_canvas_area_html+='{ fill:'+_layer.find('*[name*="[hover_color]"]').eq(0).val()+';';
                    style_canvas_area_html+='} ';
                    }
                }
                if(aux_classname=='vol-btn vol-btn-for-skin-default'){

                    if((_layer.find('*[name*="[background_color]"]').eq(0).val()!='' && _layer.find('*[name*="[background_color]"]').eq(0).val()!='transparent')){
                    style_canvas_area_html+='.dzszvp-builder-con--canvas-area .'+aux_classname_for_css+' polygon';
                    style_canvas_area_html+='{ fill:'+_layer.find('*[name*="[background_color]"]').eq(0).val()+';';
                    style_canvas_area_html+='} ';
                    }

                    if((_layer.find('*[name*="[hover_color]"]').eq(0).val()!='' && _layer.find('*[name*="[hover_color]"]').eq(0).val()!='transparent')){
                    style_canvas_area_html+='.dzszvp-builder-con--canvas-area .'+aux_classname_for_css+':hover polygon';
                    style_canvas_area_html+='{ fill:'+_layer.find('*[name*="[hover_color]"]').eq(0).val()+';';
                    style_canvas_area_html+='} ';
                    }
                }
                if(aux_classname=='hd-btn hd-btn-for-skin-default' || aux_classname=='social-btn social-btn-for-skin-default' || aux_classname=='embed-btn embed-btn-for-skin-default' ){

                    if((_layer.find('*[name*="[background_color]"]').eq(0).val()!='' && _layer.find('*[name*="[background_color]"]').eq(0).val()!='transparent')){
                    style_canvas_area_html+='.dzszvp-builder-con--canvas-area .'+aux_classname_for_css+' path';
                    style_canvas_area_html+='{ fill:'+_layer.find('*[name*="[background_color]"]').eq(0).val()+';';
                    style_canvas_area_html+='} ';
                    }

                    if((_layer.find('*[name*="[hover_color]"]').eq(0).val()!='' && _layer.find('*[name*="[hover_color]"]').eq(0).val()!='transparent')){
                    style_canvas_area_html+='.dzszvp-builder-con--canvas-area .'+aux_classname_for_css+':hover path';
                    style_canvas_area_html+='{ fill:'+_layer.find('*[name*="[hover_color]"]').eq(0).val()+';';
                    style_canvas_area_html+='} ';
                    }
                }


                if(aux_classname=='scrubbar scrubbar-for-skin-default'){

                    if((_layer.find('*[name*="[background_color]"]').eq(0).val()!='' && _layer.find('*[name*="[background_color]"]').eq(0).val()!='transparent')){
                        style_canvas_area_html+='.dzszvp-builder-con--canvas-area .'+aux_classname_for_css+' .scrubbar-box-prog';
                        style_canvas_area_html+='{ background-color:'+_layer.find('*[name*="[background_color]"]').eq(0).val()+';';
                        style_canvas_area_html+='} ';
                        style_canvas_area_html+='.dzszvp-builder-con--canvas-area .'+aux_classname_for_css+' .scrubbar-box-prog:before';
                        style_canvas_area_html+='{ border-top-color:'+_layer.find('*[name*="[background_color]"]').eq(0).val()+';';
                        style_canvas_area_html+='} ';
                    }
                }

                if(aux_classname=='scrubbar scrubbar-for-skin-pro'){

//                    console.info(aux_classname, _layer.find('*[name*="[hover_color]"]').eq(0).val());
                    if((_layer.find('*[name*="[hover_color]"]').eq(0).val()!='' && _layer.find('*[name*="[hover_color]"]').eq(0).val()!='transparent')){
                        style_canvas_area_html+='.dzszvp-builder-con--canvas-area .'+aux_classname_for_css+' .scrubbar-prog';
                        style_canvas_area_html+='{ background-color:'+_layer.find('*[name*="[hover_color]"]').eq(0).val()+';';
                        style_canvas_area_html+='} ';
                    }
                }



                if(aux_classname=='play-btn play-btn-for-skin-pro'){
                    if((_layer.find('*[name*="[background_color]"]').eq(0).val()!='' && _layer.find('*[name*="[background_color]"]').eq(0).val()!='transparent')) {
                        style_canvas_area_html += '.dzszvp-builder-con--canvas-area .' + aux_classname_for_css + ' .play-btn-fig';
                        style_canvas_area_html += '{ border-left-color:' + _layer.find('*[name*="[background_color]"]').eq(0).val() + '!important;';
                        style_canvas_area_html += '} ';
                    }
                    if((_layer.find('*[name*="[hover_color]"]').eq(0).val()!='' && _layer.find('*[name*="[hover_color]"]').eq(0).val()!='transparent')){
                        style_canvas_area_html+='.dzszvp-builder-con--canvas-area .'+aux_classname_for_css+':hover .play-btn-fig';
                        style_canvas_area_html+='{ border-left-color:'+_layer.find('*[name*="[hover_color]"]').eq(0).val()+'!important;';
                        style_canvas_area_html+='} ';
                    }

                }


                if(aux_classname=='pause-btn pause-btn-for-skin-pro'){
                    if((_layer.find('*[name*="[background_color]"]').eq(0).val()!='' && _layer.find('*[name*="[background_color]"]').eq(0).val()!='transparent')) {
                        style_canvas_area_html += '.dzszvp-builder-con--canvas-area .' + aux_classname_for_css + ' *[class^="pause-btn-fig-"]';
                        style_canvas_area_html += '{ background-color:' + _layer.find('*[name*="[background_color]"]').eq(0).val() + '!important;';
                        style_canvas_area_html += '} ';
                    }
                    if((_layer.find('*[name*="[hover_color]"]').eq(0).val()!='' && _layer.find('*[name*="[hover_color]"]').eq(0).val()!='transparent')){
                        style_canvas_area_html+='.dzszvp-builder-con--canvas-area .'+aux_classname_for_css+':hover *[class^="pause-btn-fig-"]';
                        style_canvas_area_html+='{ background-color:'+_layer.find('*[name*="[hover_color]"]').eq(0).val()+'!important;';
                        style_canvas_area_html+='} ';
                    }

                }
                if(aux_classname=='curr-time-holder curr-time-holder-for-skin-pro'){
                    if((_layer.find('*[name*="[background_color]"]').eq(0).val()!='' && _layer.find('*[name*="[background_color]"]').eq(0).val()!='transparent')) {
                        style_canvas_area_html += '.dzszvp-builder-con--canvas-area .' + aux_classname_for_css + ' ';
                        style_canvas_area_html += '{ color:' + _layer.find('*[name*="[background_color]"]').eq(0).val() + '!important;';
                        style_canvas_area_html += '} ';
                    }

                }
                if(aux_classname=='total-time-holder total-time-holder-for-skin-pro'){
                    if((_layer.find('*[name*="[background_color]"]').eq(0).val()!='' && _layer.find('*[name*="[background_color]"]').eq(0).val()!='transparent')) {
                        style_canvas_area_html += '.dzszvp-builder-con--canvas-area .' + aux_classname_for_css + '';
                        style_canvas_area_html += '{ color:' + _layer.find('*[name*="[background_color]"]').eq(0).val() + '!important;';
                        style_canvas_area_html += '} ';
                    }

                }
                if(aux_classname=='fullscreen-btn fullscreen-btn-for-skin-pro'){
                    if((_layer.find('*[name*="[background_color]"]').eq(0).val()!='' && _layer.find('*[name*="[background_color]"]').eq(0).val()!='transparent')) {
                        style_canvas_area_html += '.dzszvp-builder-con--canvas-area .' + aux_classname_for_css + ' .fullscreen-btn-fig-1,.dzszvp-builder-con--canvas-area .' + aux_classname_for_css + ' .fullscreen-btn-fig-3';
                        style_canvas_area_html += '{ border-left-color:' + _layer.find('*[name*="[background_color]"]').eq(0).val() + '!important;';
                        style_canvas_area_html += '} ';
                        style_canvas_area_html += '.dzszvp-builder-con--canvas-area .' + aux_classname_for_css + ' .fullscreen-btn-fig-2';
                        style_canvas_area_html += '{ border-right-color:' + _layer.find('*[name*="[background_color]"]').eq(0).val() + '!important;';
                        style_canvas_area_html += '} ';
                        style_canvas_area_html += '.dzszvp-builder-con--canvas-area .' + aux_classname_for_css + ' .fullscreen-btn-fig-4';
                        style_canvas_area_html += '{ border-bottom-color:' + _layer.find('*[name*="[background_color]"]').eq(0).val() + '!important;';
                        style_canvas_area_html += '} ';
                        style_canvas_area_html += '.dzszvp-builder-con--canvas-area .' + aux_classname_for_css + ' .fullscreen-btn-fig-circ';
                        style_canvas_area_html += '{ background-color:' + _layer.find('*[name*="[background_color]"]').eq(0).val() + '!important;';
                        style_canvas_area_html += '} ';
                    }
                    if((_layer.find('*[name*="[hover_color]"]').eq(0).val()!='' && _layer.find('*[name*="[hover_color]"]').eq(0).val()!='transparent')){
                        style_canvas_area_html += '.dzszvp-builder-con--canvas-area .' + aux_classname_for_css + ':hover .fullscreen-btn-fig-1,.dzszvp-builder-con--canvas-area .' + aux_classname_for_css + ':hover .fullscreen-btn-fig-3';
                        style_canvas_area_html += '{ border-left-color:' + _layer.find('*[name*="[hover_color]"]').eq(0).val() + '!important;';
                        style_canvas_area_html += '} ';
                        style_canvas_area_html += '.dzszvp-builder-con--canvas-area .' + aux_classname_for_css + ':hover .fullscreen-btn-fig-2';
                        style_canvas_area_html += '{ border-right-color:' + _layer.find('*[name*="[hover_color]"]').eq(0).val() + '!important;';
                        style_canvas_area_html += '} ';
                        style_canvas_area_html += '.dzszvp-builder-con--canvas-area .' + aux_classname_for_css + ':hover .fullscreen-btn-fig-4';
                        style_canvas_area_html += '{ border-bottom-color:' + _layer.find('*[name*="[hover_color]"]').eq(0).val() + '!important;';
                        style_canvas_area_html += '} ';
                        style_canvas_area_html += '.dzszvp-builder-con--canvas-area .' + aux_classname_for_css + ':hover .fullscreen-btn-fig-circ';
                        style_canvas_area_html += '{ background-color:' + _layer.find('*[name*="[hover_color]"]').eq(0).val() + '!important;';
                        style_canvas_area_html += '} ';
                    }

                }

            }

        }

        _style_areaCanvas.html(style_canvas_area_html);

//        console.info(_style_areaCanvas);


        _areaCanvas.children().draggable({

            revert: false
            ,stop : function(e, ui){
                var _t = $(this);

                var ind = _t.parent().children().index(_t);
//                console.info(e,ui,_t, ind);

                var dropl = parseInt(ui.position.left,10);
                var dropt = parseInt(ui.position.top,10);
                var dropr = parseInt(_areaCanvas.outerWidth() - dropl - _t.outerWidth(),10);
                var dropb = parseInt(_areaCanvas.outerHeight() - dropt - _t.outerHeight(),10);

//                console.info((_areaCanvas.outerWidth(), dropl)

                if(_t.hasClass('builder-align-top-left')){
//                    console.info(_areaLayers);

                    var _c = _areaLayers.children().eq(ind);

                    _c.find('*[name*="[top]"]').eq(0).val(dropt + 'px');
                    _c.find('*[name*="[left]"]').eq(0).val(dropl + 'px');

                    _c.find('*[name*="[right]"]').eq(0).val('auto');
                    _c.find('*[name*="[bottom]"]').eq(0).val('auto');
                }


                if(_t.hasClass('builder-align-top-right')){
//                    console.info(_areaLayers);

                    var _c = _areaLayers.children().eq(ind);

                    _c.find('*[name*="[top]"]').eq(0).val(dropt + 'px');
                    _c.find('*[name*="[right]"]').eq(0).val(dropr + 'px');

                    _c.find('*[name*="[left]"]').eq(0).val('auto');
                    _c.find('*[name*="[bottom]"]').eq(0).val('auto');
                }


                if(_t.hasClass('builder-align-bottom-right')){
//                    console.info(_areaLayers);

                    var _c = _areaLayers.children().eq(ind);

                    _c.find('*[name*="[bottom]"]').eq(0).val(dropb + 'px');
                    _c.find('*[name*="[right]"]').eq(0).val(dropr + 'px');

                    _c.find('*[name*="[left]"]').eq(0).val('auto');
                    _c.find('*[name*="[top]"]').eq(0).val('auto');
                }


                if(_t.hasClass('builder-align-bottom-left')){
//                    console.info(_areaLayers);

                    var _c = _areaLayers.children().eq(ind);

                    _c.find('*[name*="[bottom]"]').eq(0).val(dropb + 'px');
                    _c.find('*[name*="[left]"]').eq(0).val(dropl + 'px');

                    _c.find('*[name*="[right]"]').eq(0).val('auto');
                    _c.find('*[name*="[top]"]').eq(0).val('auto');
                }


            }
        });


//        console.info($('.dzszvp-output-con'), String(htmlEncode(_areaCanvas.html())));
    }

    function htmlEncode(value){
        //create a in-memory div, set it's inner text(which jQuery automatically encodes)
        //then grab the encoded contents back out.  The div never exists on the page.
        return $('<div/>').text(value).html();
    }

    function htmlDecode(value){
        return $('<div/>').html(value).text();
    }


    function click_layer_head(e){
        var _t = $(this);

        if(_t.find('.sortable-handle-con').has($(e.target)).length > 0){
            return ;
        }
        _t.parent().toggleClass('active');
    }

    function reskin_select(){
        $(document).undelegate(".select-wrapper select", "change");
        $(document).delegate(".select-wrapper select", "change",  change_select);

//        console.info($('select'));
        $('select.styleme').each(function(){

            var _cache = $(this);
//            console.log(_cache);

            if(_cache.parent().hasClass('select_wrapper') || _cache.parent().hasClass('select-wrapper')){
                return;
            }
            var sel = (_cache.find(':selected'));
//            console.info(sel, _cache.val());
            _cache.wrap('<div class="select-wrapper"></div>')
            _cache.parent().prepend('<span>' + sel.text() + '</span>');
            _cache.trigger('change');
        })


        function change_select(){
            var selval = ($(this).find(':selected').text());
            $(this).parent().children('span').text(selval);
        }

    }
});



/* @projectDescription jQuery Serialize Anything - Serialize anything (and not just forms!)
 * @author Bramus! (Bram Van Damme)
 * @version 1.0
 * @website: http://www.bram.us/
 * @license : BSD
 */

(function($) {

    $.fn.serializeAnything = function() {

        var toReturn    = [];
        var els         = $(this).find(':input').get();

        $.each(els, function() {
            if (this.name && !this.disabled && (this.checked || /select|textarea/i.test(this.nodeName) || /text|hidden|password/i.test(this.type))) {
                var val = $(this).val();
                toReturn.push( encodeURIComponent(this.name) + "=" + encodeURIComponent( val ) );
            }
        });

        return toReturn.join("&").replace(/%20/g, "+");

    }

})(jQuery);